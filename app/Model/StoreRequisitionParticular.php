<?php
/**
 * WardModel file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       InventoryPurchaseDetai Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Mayank Jain
 */
class StoreRequisitionParticular extends AppModel {

	public $name = 'StoreRequisitionParticular';
	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}


	public $belongsTo = array(
			'StoreRequisition' => array(
					'className' => 'StoreRequisition',
					'foreignKey' => 'store_requisition_detail_id'
			),
			'Product' => array(
					'className' => 'Product',
					'foreignKey' => 'item_id'
			),
			'PurchaseOrderItem' => array(
					'className' => 'PurchaseOrderItem',
					'foreignKey' => 'purchase_order_item_id'
			)
	);
	public $validate = array(
			'item_id' => array(
					'rule' => "notEmpty",
					'message' => "Please enter Product."
			),
			'requested_qty' => array(
					'rule' => "notEmpty",
					'message' => "Requested Quatity can not be empty."
			),


	);
	
	
	/* for add the item details*/
	public function saveParticulars($data,$id,$status,$pharmacy,$userId,$loc,$requisitionTo){ 
		// $data => item data
		// $id => store_requisition_detials_id
		// $status => Issued / Partially Issued / Partially Denied / Returned 
		// $requisitionTo => Requisition From (Central Store) 
		
		App::import('Component', 'DateFormat');
		$dateformat = new DateFormatComponent();
		$session = new cakeSession();
		$flag = false;
		$array_id = array();
		$productStock = Classregistry::init('Product');
		$productRateStock = Classregistry::init('ProductRate');
		$purchaseStock = ClassRegistry::init('PurchaseOrderItem');
		$storeDetails=Classregistry::init('StoreRequisition');
		$pharmacyItem = Classregistry::init('PharmacyItem');
		$pharmacyItemRate = Classregistry::init('PharmacyItemRate');
		$otPharmacyItem = Classregistry::init('OtPharmacyItem');
		$otPharmacyItemRate = Classregistry::init('OtPharmacyItemRate');
		$storeLocation = Classregistry::init('StoreLocation');
		$storeRequiParticular = Classregistry::init('StoreRequisitionParticular');
		
		for($i=0;$i<count($data['item_name']);$i++)
		{ 
			$field = array();
			$field['StoreRequisitionParticular']['id'] =$data['id'][$i];
			$field['StoreRequisitionParticular']['store_requisition_detail_id'] =$id;
			$field['StoreRequisitionParticular']['item_id'] = $data['item_id'][$i];
			$field['StoreRequisitionParticular']['item_name'] = $data['item_name'][$i];
			$field['StoreRequisitionParticular']['batch_id'] = $data['batch'][$i]; // BOF-Mahalaxmi For adding Stock transfer
			if(!empty($data['qty'][$i])) 
				$field['StoreRequisitionParticular']['requested_qty'] = $data['qty'][$i];
			if(!empty($data['Pitem_id'][$i]))
				$field['StoreRequisitionParticular']['purchase_order_item_id'] = $data['Pitem_id'][$i];
			
			if(!empty($data['existing_stock_order_item_id'][$i]))
				$field['StoreRequisitionParticular']['existing_stock_order_item_id'] = $data['existing_stock_order_item_id'][$i]; //////BOF-Mahalaxmi-For Stock Transfer
			
			if(!empty($data['remark'][$i]))
				$field['StoreRequisitionParticular']['remark'] = $data['remark'][$i];
			if(!empty($data['issue_remark'][$i]))
				$field['StoreRequisitionParticular']['issue_remark'] = $data['issue_remark'][$i];
			if(!empty($data['return_remark'][$i]))
				$field['StoreRequisitionParticular']['return_remark'] = $data['return_remark'][$i];
			if(!empty($data['issued_qty'][$i])){				
				if(!empty($data['pre_issued_qty'][$i]))
					$issued = $data['issued_qty'][$i]+$data['pre_issued_qty'][$i];
				else $issued = $data['issued_qty'][$i];
				$field['StoreRequisitionParticular']['issued_qty'] = $issued;				
			}
			if(!empty($data['used_qty'][$i]))
				$field['StoreRequisitionParticular']['used_qty'] = $data['used_qty'][$i];
			if(!empty($data['returned_qty'][$i]))
				
				$field['StoreRequisitionParticular']['returned_date'] = date('Y-m-d H:i:s');
			if(!empty($data['is_denied'][$i+1]))
				$field['StoreRequisitionParticular']['is_denied'] = $data['is_denied'][$i+1];
			if (!empty($field['StoreRequisitionParticular']['id']) && empty($data['returned_qty'][$i])) {
				$field['StoreRequisitionParticular']['modified']=date('Y-m-d H:i:s');
			} else if(empty($data['returned_qty'][$i])) {
				$field['StoreRequisitionParticular']['created']=date('Y-m-d H:i:s');
				$field['StoreRequisitionParticular']['modified']=NULL;
			}  
			
			if($status=='Issued' || $status=='Partially Issued' || $status=='Partially Denied'){
				//if the status is issued or Partially Issued or Partially Denied 
				
				$dataa = $this->find('first',array(
											'conditions'=>array('StoreRequisitionParticular.id'=>$data['id'][$i]),
											'fields'=>array('id','StoreRequisition.id','StoreRequisition.requisition_for','StoreRequisition.store_location_id','StoreRequisitionParticular.returned_qty')));

				$storLocId = $dataa['StoreRequisition']['requisition_for'];
				
				$allStores = $storeLocation->find('list',array(
												 'conditions'=>array('StoreLocation.is_deleted'=>0),
												 'fields'=>array('StoreLocation.id','StoreLocation.code_name')) );
				 
				$detail = $storeLocation->find('first',array(
												 'conditions'=>array('StoreLocation.id'=>$storLocId),
												 'fields'=>array('StoreLocation.id','StoreLocation.name','StoreLocation.code_name')) );
				
			 	//if requisition sent to pharmacy by swapnil 04.08.2015
				if (strtolower($requisitionTo['StoreLocation']['name']) == strtolower(Configure::read('Pharmacy'))) {
					$qty = (int)$data['issued_qty'][$i];
					$pharItemStock = $pharmacyItem->find('first',array('fields'=>array('id','stock','loose_stock','pack'),'conditions'=>array('PharmacyItem.id'=>$data['item_id'][$i])));
					//$pharItemRateStock = $pharmacyItemRate->find('first',array('fields'=>array('id','stock','loose_stock'),'conditions'=>array('PharmacyItemRate.id'=>$data['Pitem_id'][$i])));
					
					$itemRateStock = $pharmacyItemRate->find('all', array('conditions' => array('OR'=>array('PharmacyItemRate.stock > 0','PharmacyItemRate.loose_stock > 0'),
							'PharmacyItemRate.item_id'=>$data['Pitem_id'][$i]/*,'ProductRate.batch_number'=>$data['batch_no']*/),
							'order'=>array('PharmacyItemRate.expiry_date'=>'ASC')));
					
					if (!empty($data['id'][$i])) {
						$pack = $pharItemStock['PharmacyItem']['pack'];
						//for retaining the stock quantity and then deducting the issued quatity
						 
						foreach ($itemRateStock as $val) {
							if ($qty != 0 ) {
								$myRateStock = $val['PharmacyItemRate']['stock'] * (int)$pack + $val['PharmacyItemRate']['loose_stock'];
								$this->PharmacyItemRate->id = $val['PharmacyItemRate']['id'];
								
								if ($myRateStock < $qty) {
									$qty = $qty - $myRateStock;
									$saveStock = $myRateStock;
									$myProductRateStock  = 0;
								} else {
									$saveStock = $qty;
									$qty = 0;
									$myProductRateStock = ($val['PharmacyItemRate']['stock'] * (int)$pack + $val['PharmacyItemRate']['loose_stock']) - $saveStock;
								}
								//update product rate 
								$savePharData = array();
								$savePharData['stock'] = floor($myProductRateStock / $pack);
								$savePharData['loose_stock'] = floor($myProductRateStock % $pack);
						
								$pharmacyItemRate->id = $val['PharmacyItemRate']['id'];
								$pharmacyItemRate->save($savePharData);
								$pharmacyItemRate->id = '';
							}else{
					 			break;
					 		} 
						}
					} 
					//BOF of stock check
					$prodStock = ((int)$pharItemStock['Pharmacy']['stock'] * (int)$pharItemStock['Pharmacy']['pack']) + (int)$pharItemStock['Pharmacy']['loose_stock'] -(int)$qty;
					 
					if($prodStock<0){
						$errors[] = __($pharItemStock['Pharmacy']['name'] .' is out of stock. Please reduce the issued quantity');
						continue;						 
					} else{				 
						$this->updatePharmacyItemStock($pharItemStock['PharmacyItem']['id']);
					}  
				}
			  
			} 
			
			//if the status is Returned
			
			if ($status=='Returned') {
				
				if(strtolower($requisitionTo['StoreLocation']['name']) == strtolower(Configure::read('Pharmacy'))) {
					$pharmacyId = $pharmacyItem->find('first',array('conditions'=>array('PharmacyItem.id'=>$data['item_id'][$i])));
				 	$pharmacyItemId = $pharmacyItemRate->find('first',array('conditions'=>array('PharmacyItemRate.item_id'=>$data['Pitem_id'][$i])));
					
				 	$issueStock = $this->find('first',array('conditions'=>array('StoreRequisitionParticular.id'=>$data['id'][$i])));
					$stockStatus = $storeDetails->find('first',array('fields'=>array('status'),'conditions'=>array('StoreRequisition.id'=>$id)));
					$pharmaStock = ($pharmacyId['PharmacyItem']['stock'] * $pharmacyId['PharmacyItem']['pack'] + $pharmacyId['PharmacyItem']['loose_stock']);
					$rateStock =  ($pharmacyItemId['PharmacyItemRate']['stock'] * $pharmacyId['PharmacyItem']['pack'] + $pharmacyItemId['PharmacyItemRate']['loose_stock']);

					if ($issueStock['StoreRequisitionParticular']['returned_qty']=='') {
						$issueStock['StoreRequisitionParticular']['returned_qty'] = 0;
					}
				

					/*if ($stockStatus['StoreRequisition']['status']=='Issued') {
						$pharmaStock =$pharmaStock-(double)$issueStock['StoreRequisitionParticular']['returned_qty'];
						$rateStock =$rateStock-(double)$issueStock['StoreRequisitionParticular']['returned_qty'];
					}*/
					
					$field['StoreRequisitionParticular']['returned_qty'] = $issueStock['StoreRequisitionParticular']['returned_qty'] + $data['returned_qty'][$i];
					
					//Add the returned quantity in Product stock
					$myPharstock = $pharmaStock + $data['returned_qty'][$i];
					$phar['id'] = $pharmacyId['PharmacyItem']['id'];
					$phar['stock'] = floor($myPharstock / (int)$pharmacyId['PharmacyItem']['pack']);
					$phar['loose_stock'] = floor($myPharstock % (int)$pharmacyId['Product']['pack']);
					$pharmacyItem->save($phar);
					$pharmacyItem->id = "";
					
					$myRatestock = $rateStock + $data['returned_qty'][$i];
					$pharRate['id'] = $pharmacyItemId['PharmacyItemRate']['id'];
					$pharRate['stock'] = floor($myRatestock / (int)$pharmacyId['PharmacyItem']['pack']);
					$pharRate['loose_stock'] = floor($myRatestock % (int)$pharmacyId['Product']['pack']);
					
					$pharmacyItemRate->save($pharRate);
					$pharmacyItemRate->id = "";
					
				}
			}
		
			$this->create();
			if($this->save($field)){
				$flag=true;
			}	
			 
		}//eof foreach
		if(!empty($errors)){
			return $errors;
		}else{
			return true;
		}
	}
	
	public function save_stock_transfer(){
		
	}
	
	public function updatePharmacyItemStock($item_id){
		if(empty($item_id)){
			return false;
		}
		$pharmacyItem = Classregistry::init('PharmacyItem');
		$pharmacyItemRate = Classregistry::init('PharmacyItemRate'); 
		
		$result = $pharmacyItemRate->find('first',array('fields'=>array('SUM(PharmacyItemRate.stock) as totalStock',
						'SUM(PharmacyItemRate.loose_stock) as totalLooseStock','PharmacyItem.pack'),'conditions'=>array('PharmacyItemRate.item_id'=>$item_id)));
		$pack = $result['PharmacyItem']['pack'];
		$wholeStockinMSU = ($result[0]['totalStock'] * $pack) + $result[0]['totalLooseStock'];
		
		$saveData['stock'] = floor($wholeStockinMSU/$pack);
		$saveData['loose_stock'] = floor($wholeStockinMSU%$pack);
		
		$pharmacyItem->id = $item_id;
		if($pharmacyItem->save($saveData)){
			$pharmacyItem->id = '';
			return true;
		}
	}
}
?>