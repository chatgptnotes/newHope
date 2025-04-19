<?php 

class OtPharmacySalesBillDetail extends AppModel {
	public $name = 'OtPharmacySalesBillDetail';
	public $useTable= 'ot_pharmacy_sales_bill_details';
	public $belongsTo = array(
			'OtPharmacyItem' => array(
					'className' => 'OtPharmacyItem',
					'foreignKey' => 'item_id',
					'dependent'=> true
			),
			'OtPharmacySalesBill' => array(
					'className' => 'OtPharmacySalesBill',
					'foreignKey' => 'ot_pharmacy_sales_bill_id',
					'dependent'=> true
			)
	);

	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		if(empty($ds)){
			$session = new cakeSession();
			$this->db_name =  $session->read('db_name');
		}else{
			$this->db_name =  $ds;
		}
		parent::__construct($id, $table, $ds);
	}
	
	/* this method store bill details*/
	public function saveBillDetails($data,$id){ 
		
		App::import('Component', 'DateFormat');
		$dateformat = new DateFormatComponent();
		$session = new cakeSession();
		$flag = true;
		$array_id = array();
		$pharmacyItem = Classregistry::init('OtPharmacyItem');
		$pharmacyItemRate = Classregistry::init('OtPharmacyItemRate');
		
		$requisitionArray=array();
		$arrayStoreLoc = array();
		
		for($i=0;$i<count($data['OtPharmacySalesBill']['item_id']);$i++){
			$field = array();
			$field['qty'] = $data['OtPharmacySalesBill']['qty'][$i];
			/* Removed LocationId by - MRUNAL */
			$item = $pharmacyItem->find('first',array('conditions' =>
					array("OtPharmacyItem.id"=>$data['OtPharmacySalesBill']['item_id'][$i]/*,"OtPharmacyItem.location_id" => $session->read('locationid') */)));
			
			
			$itemRate = $pharmacyItemRate->find('first',array('conditions' =>
					array("OtPharmacyItemRate.item_id"=>$data['OtPharmacySalesBill']['item_id'][$i],"OtPharmacyItemRate.id" => $data['pharmacyItemId'][$i]/*,"PharmacyItemRate.location_id" => $session->read('locationid')*/)));
			
			$field['item_id'] = $data['OtPharmacySalesBill']['item_id'][$i];
			$field['batch_number'] = $itemRate['OtPharmacyItemRate']['batch_number'];
			$field['mrp'] = $data['OtPharmacySalesBill']['mrp'][$i];
			$field['qty_type'] = $data['OtPharmacySalesBill']['itemType'];
			$field['pack'] = $data['OtPharmacySalesBill']['pack'][$i];
			$field['discount'] = round($data['OtPharmacySalesBill']['itemWiseDiscountAmount'][$i]);
			$field['sale_price'] = $data['OtPharmacySalesBill']['rate'][$i];
			$field['expiry_date'] = DateFormatComponent::formatDate2STD($data['OtPharmacySalesBill']['expiry_date'][$i],Configure::read('date_format'));
			//$field['tax'] = $data['OtPharmacySalesBill']['tax'][$i];
			$field['ot_pharmacy_sales_bill_id'] = $id;
			 
			$this->create();
			$this->save($field);
			$errors = $this->invalidFields();
			if(!empty($errors)) {
				$flag =  false;
			}else{
				/* decrease the stock by quantity */
				$pack = $data['OtPharmacySalesBill']['pack'][$i];
				$saleQty = $data['OtPharmacySalesBill']['qty'][$i];
				$type = $data['OtPharmacySalesBill']['itemType'];
				
				$pharmacyStock = $item['OtPharmacyItem']['stock'];
				$pharmacyLooseStock = $item['OtPharmacyItem']['loose_stock'];
				 
				$pharmacyItemStock = $itemRate['OtPharmacyItemRate']['stock'];
				$pharmacyItemLooseStock = $itemRate['OtPharmacyItemRate']['loose_stock'];
				
				if(!$pack || $pack==0) $pack=1;					// If in case pack is not availble
				
				if($type == "Tab"){
					//for OTpharmacy Item
					$totalPharmacyTabs = ($pharmacyStock * $pack) + $pharmacyLooseStock;
					$remPharTabs = $totalPharmacyTabs - $saleQty;
					$currentPharStock = floor($remPharTabs / $pack);			//pack stock
					$loosePharStock = $remPharTabs % $pack;					//loose stock

					//for OTpharmacy Item Rate
					$totalPharmacyItemTabs = ($pharmacyItemStock * $pack) + $pharmacyItemLooseStock; // Displays Loose + pack Stock
					$remPharItemTabs = $totalPharmacyItemTabs - $saleQty; 
					$currentPharItemStock = floor($remPharItemTabs / $pack);	//pack stock
					$loosePharItemStock = $remPharItemTabs % $pack;			//loose stock
					$remainingStock = $remPharTabs;
					$reorderLevel = $item['OtPharmacyItem']['reorder_level'] * $pack; // ReorderLevel tablet Wise
				}else{

					//for OTpharmacy Item
					$currentPharStock = $pharmacyStock - $saleQty;			//pack stock
					$loosePharStock = $pharmacyLooseStock;					//loose stock
						
					//for OTpharmacy Item Rate
					$currentPharItemStock = $pharmacyItemStock - $saleQty;	//pack stock
					$loosePharItemStock = $pharmacyItemLooseStock;			//loose stock
					$remainingStock = $currentPharStock; 				//Display Pack Stock
					$reorderLevel = $item['OtPharmacyItem']['reorder_level']; // reorderLevel Pack wise 
				}
				/* Send request to APAM oR KCHRC if stock is less than reorder level - By MRUNAL*/
				
				if($remainingStock <= $reorderLevel){
					 
					$locationId = $item['OtPharmacyItem']['location_id'];
					//$this->sendReorderLevelRequest($data,$locationId);
					 $reorderDataArray[$locationId][] = array('item_id'=>$data['OtPharmacySalesBill']['product_id'][$i],
							'item_name'=>$data['OtPharmacySalesBill']['item_name'][$i],
							'qty'=>$data['OtPharmacySalesBill']['qty'][$i],
							); 
					
				}
				 /* End of code ReorderLeve Code*/
				
				$pharData = array();
				$pharmacyItem->id =   $item['OtPharmacyItem']['id'];
				$pharData['stock'] = $currentPharStock;
				$pharData['loose_stock'] = $loosePharStock;
				$pharmacyItem->save($pharData);
				$pharmacyItem->id = "";

				$pharItemData = array();
				$pharmacyItemRate->id = $itemRate['OtPharmacyItemRate']['id'];
				$pharItemData['stock'] = $currentPharItemStock;
				$pharItemData['loose_stock'] = $loosePharItemStock;
				
				$pharmacyItemRate->save($pharItemData);
				$pharmacyItemRate->id = "";
			}
			
			
		} $this->sendReorderLevelRequest($reorderDataArray); //to send auto requistion
		
	}
	
	/* Send request to APAM oR KCHRC if stock is less than reorder level - By MRUNAL*/
	public function sendReorderLevelRequest($data){
	
		$session = new cakeSession();
		$storeRequisitionParticular = Classregistry::init('StoreRequisitionParticular');
		$storeRequisition = Classregistry::init('StoreRequisition');
		$inventoryCategory = Classregistry::init('InventoryCategory');
		$storeLocation = Classregistry::init('StoreLocation');
		$location = Classregistry::init('Location');  
		$productRate  = ClassRegistry::init('ProductRate');
		/* Save in store requisition Table */
		$otStoreLocationID = $storeLocation->getStoreLocationID(Configure::read('otpharmacycode'));  
		
		foreach ($data as $key => $value) { 
			
			$locationName = $location->getLocationNameById($key);
			$storeLocationID = $storeLocation->find('first',array(
								'conditions'=>array('StoreLocation.name' => $locationName),
								'fields'=>array('StoreLocation.id','StoreLocation.name'))); 
			
			/* Requisition will be send to storeLocation Id will get here */
			if($storeLocationID['StoreLocation']['name'] == "APAM"){
				$storeLocationRequisitionID = $storeLocation->getStoreLocationID(Configure::read('apamCode'));
			}else{
				$storeLocationRequisitionID	= $storeLocation->getStoreLocationID(Configure::read('centralStoreCode'));
			}
			
			$arrayStoreLoc['requisition_for'] = $otStoreLocationID['StoreLocation']['id'];
			$arrayStoreLoc['requisition_by'] = $session->read('userid');
			$arrayStoreLoc['status'] = "Requesting";
			$arrayStoreLoc['requisition_date'] = date('Y-m-d H:i:s');
			$arrayStoreLoc['requisition_expiry_date'] = date('Y-m-d h:i:s',strtotime("+1 week"));
			$arrayStoreLoc['store_location_id'] = $storeLocationRequisitionID['StoreLocation']['id'];
			$arrayStoreLoc['created_by'] = $session->read('userid');
			$arrayStoreLoc['created_time'] = date('Y-m-d h:i:s');
			$arrayStoreLoc['location_id'] = $key;
			
			$storeRequisition->save($arrayStoreLoc);
			$lastIdd=$storeRequisition->getLastInsertID();
			
			if(is_array($value)){
				 foreach ($value as $storeParticularKey =>$storeParticularValue){ 
				 	
				 	/* $productRateData = $productRate->find('first',array(
				 			'fields'=>array('ProductRate.product_id','ProductRate.id'),
				 			'conditions'=>array('ProductRate.product_id'=>$storeParticularValue['item_id']),
				 			'order'=>array('ProductRate.stock DESC , ProductRate.expiry_date Desc'))); */
				 	
					$requisitionArray['location_id'] = $key;
					$requisitionArray['item_id'] = $storeParticularValue['item_id'];						// item id : Product table id
					$requisitionArray['purchase_order_item_id'] = $storeParticularValue['item_id'];
					$requisitionArray['requested_qty'] = $storeParticularValue['qty']; 
					$requisitionArray['store_requisition_detail_id'] = $lastIdd;
					
					$storeRequisitionParticular->save($requisitionArray); 
					$storeRequisitionParticular->id='';
				} 
			}
			$storeRequisition->id ='';  
		} 
	}
	/* END of CODE */
}

?>