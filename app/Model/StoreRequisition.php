<?php
	class StoreRequisition extends AppModel{
		public $name = 'StoreRequisition';
		public $specific = true;    		
		public $useTable = "store_requisition_details";  
		 
		function __construct($id = false, $table = null, $ds = null) {
				$session = new cakeSession();
				$this->db_name =  $session->read('db_name');
				parent::__construct($id, $table, $ds);
		}

		//function to send auto requesition to central store as per reorder level
		function autoRequisition($data){ 
			if(empty($data)) return false ;
			  
			$itemData  = $data['item_id'] ;
			$pharmacyItemObj =  ClassRegistry::init('PharmacyItem');
			/*for($i=0;$i< count($itemData);$i++){
				$pharmacyItemObj->fin
			}*/
			$pharmacyItemObj->recursive =  -1  ;
			$itemResult = $pharmacyItemObj->find('all',array(
					'fields'=>array('PharmacyItem.expensive_product','PharmacyItem.id','PharmacyItem.stock','PharmacyItem.pack','PharmacyItem.loose_stock',
									'PharmacyItem.reorder_level'),
					'conditions'=>array('PharmacyItem.id'=>$itemData)));
			
			$requisitionItem = array();
			 
			foreach($itemResult as $key => $value){ 
				//get the key of item id array 
				$itemIdKey = array_search($value['PharmacyItem']['id'],$data['item_id']); 
				$pack = (int)$value['PharmacyItem']['pack'] ;
				$stock = (int)$value['PharmacyItem']['stock'] ;
				$looseStock = (int)$value['PharmacyItem']['loose_stock'] ;
				if(!$pack || $pack==0) $pack=1; //set pack to 1 if anything went wrong , just backup yourself ;)
				
				/* If Item type Is PACK or TAB then Stock is as followws*/
				if($data['itemType'][$key] == 'Tab'){
					$ItemTypeStock = (($pack*$stock)+$looseStock)-$data['qty'][$itemIdKey] ;   // Tablet wise Stock
					$reorderLevel = (int)$value['PharmacyItem']['reorder_level'] * $pack;	   
				}else{
					$ItemTypeStock = $stock-$data['qty'][$itemIdKey];							// Pack Wise Stock
					$reorderLevel = (int)$value['PharmacyItem']['reorder_level'];
				}
				
				if(!empty($reorderLevel) && $value['PharmacyItem']['expensive_product']!=1){ //check if reorder level is set for looped item and skip expensive medication
					if($reorderLevel >= $ItemTypeStock){ 
						$requisitionItem[] = array('item_id'=>$value['PharmacyItem']['id'],
							'item_batch_id'=>$value['PharmacyItem']['pharmacyItemId'],
							'reorder_level'=>$reorderLevel);
						
					}
				}	
			}
			if(!empty($requisitionItem)){
				$this->sendRequistion($requisitionItem);
			}

			
		}

		function sendRequistion($requisitionItem){  
			 
			$storeLocationObj  = ClassRegistry::init('StoreLocation');
			$storeRequisitionParticularObj  = ClassRegistry::init('StoreRequisitionParticular');
			$productObj  = ClassRegistry::init('Product');
			$productRateObj  = ClassRegistry::init('ProductRate');
			$pharmacyItemObj  = ClassRegistry::init('PharmacyItem');  
			$session = new CakeSession();
			$phamacyStoreLocationID = $storeLocationObj->getStoreLocationID(Configure::read('pharmacyCode'));
			$centralStoreLocationID = $storeLocationObj->getStoreLocationID(Configure::read('centralStoreCode'));
			 
			$requisitionArray = array('location_id'=>$session->read('locationid'),
					'requisition_for'=>$phamacyStoreLocationID['StoreLocation']['id'],
					'store_location_id'=>$centralStoreLocationID['StoreLocation']['id'],
					'requisition_by'=>$session->read('userid'),
					'requisition_date'=>date('Y-m-d H:i:s'),
					'requisition_expiry_date'=>date('Y-m-d h:i:s',strtotime("+1 week")),
					'created_time'=>date('Y-m-d h:i:s'),
					'created_by'=>$session->read('userid'),
					);	
			 
			$this->save($requisitionArray);
			$lastInsertId= $this->getLastInsertID();
			$pharmacyItemObj->recursive = -1 ;
			$productRateObj->recursive = -1; 
			foreach($requisitionItem as $key =>$itemId){
				//find product id and product rate id 
				$drugId = $pharmacyItemObj->find('first',array('fields'=>array('PharmacyItem.drug_id'),'conditions'=>array('PharmacyItem.id'=>$itemId['item_id'])));

				 
				if(!$drugId['PharmacyItem']['drug_id']) continue ; //skip if there is no product id available in pharmacy tables 

				$productRateData = $productRateObj->find('first',array('fields'=>array('ProductRate.product_id','ProductRate.id'),'conditions'=>array('ProductRate.product_id'=>$drugId['PharmacyItem']['drug_id']),'order'=>array('ProductRate.stock DESC , ProductRate.expiry_date Desc')));
				 
				$requisitionPerticuarArray = array('location_id'=>$session->read('locationid'),
					'purchase_order_item_id'=>$productRateData['ProductRate']['product_id'],
					'item_id'=>$productRateData['ProductRate']['product_id'],
					'requested_qty'=>$itemId['reorder_level'],
					'store_requisition_detail_id'=>$lastInsertId);	 
				
				$storeRequisitionParticularObj->save($requisitionPerticuarArray);
				$storeRequisitionParticularObj->id='';
			}
		}
	}
?>