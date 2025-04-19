<?php
/**
 * WardModel file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       InventoryPharmacySalesReturnsDetail Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Mayank Jain
 */
class InventoryPharmacySalesReturnsDetail extends AppModel {
	
	public $name = 'InventoryPharmacySalesReturnsDetail';
	 public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }  
	
	public $belongsTo = array(
		'InventoryPharmacySalesReturn' => array(
		'className' => 'InventoryPharmacySalesReturn',
		'foreignKey' => 'inventory_pharmacy_sales_return_id'
		),
		'PharmacyItem' => array(
		'className' => 'PharmacyItem',
		'foreignKey' => 'item_id'
		)
	); 
	 public function saveSaleReturn($data,$id){ 
	 	App::import('Component', 'DateFormat');
	    //$dateformat = new DateFormatComponent();
	    $session = new cakeSession();
  		$flag = true;
		$array_id = array();
		$pharmacyItem = Classregistry::init('PharmacyItem');
		$pharmacyItemRate = Classregistry::init('PharmacyItemRate');
		
		
		for($i=0;$i<count($data['item_id']);$i++){
			
			$field = array();
			/* LoactaionID Condition removed by MRUNAL for vadodara */
			if($session->read('website.instance')=='vadodara'){
				$item = $pharmacyItem->find('first',array('conditions' =>
						array("PharmacyItem.id"=>$data['item_id'][$i]/* ,"PharmacyItem.location_id" => $session->read('locationid') */)));
			}else{
				$item = $pharmacyItem->find('first',array('conditions' => 
						array("PharmacyItem.id"=>$data['item_id'][$i]/* ,"PharmacyItem.location_id" => $session->read('locationid')  */)));
			}
			$itemRate = $pharmacyItemRate->find('first',array('conditions' =>
						 array("PharmacyItemRate.item_id"=>$data['item_id'][$i],"PharmacyItemRate.id" => $data['pharmacyItemId'][$i]/*,"PharmacyItemRate.location_id" => $session->read('locationid')*/)));
			/* debug($data); 
			debug($itemRate); exit; */
			$field['return_tot_amount'] = $data['return_amount'][$i];
			$field['qty'] = $data['qty'][$i];
			$field['item_id'] = $data['item_id'][$i];
			$field['batch_no'] = $itemRate['PharmacyItemRate']['batch_number'];
			$field['mrp'] = $data['mrp'][$i];
			$field['qty_type'] = $data['itemType'][$i];
			$field['pack'] = $data['pack'][$i];
			$field['discount'] = $data['discount'][$i];
			$field['sale_price'] = $data['rate'][$i];
			$field['expiry_date'] = DateFormatComponent::formatDate2STD( $data['expiry_date'][$i] ,Configure::read('date_format'));
			$field['tax'] = $data['saleTax'][$i];
			$field['inventory_pharmacy_sales_return_id'] = $id;
			if(!empty($field['qty'])){
				$this->create();
				$this->save($field);
				$this->id = '' ;
			}
			 $errors = $this->invalidFields();
			 if(!empty($errors)) {
			 	$flag =  false;
			 }else{
			 	
			$pack = $data['pack'][$i];
	 		$saleQty = $data['qty'][$i];
	 		$type = $data['itemType'][$i];
	 		
	 		$pharmacyStock = $item['PharmacyItem']['stock'];
	 		$pharmacyLooseStock = $item['PharmacyItem']['loose_stock'];
	 		
	 		$pharmacyItemStock = $itemRate['PharmacyItemRate']['stock'];
	 		$pharmacyItemLooseStock = $itemRate['PharmacyItemRate']['loose_stock'];
	 		 
	 		if($type == "Tab"){
	 			//for pharmacy Item
				$totalPharmacyTabs = ($pharmacyStock * $pack) + $pharmacyLooseStock;
				$remPharTabs = $totalPharmacyTabs + $saleQty;
				$currentPharStock = floor($remPharTabs / $pack);			//pack stock
				$loosePharStock = $remPharTabs % $pack;					//loose stock
	 			
				//for pharmacy Item Rate					
				$totalPharmacyItemTabs = ($pharmacyItemStock * $pack) + $pharmacyItemLooseStock;
				$remPharItemTabs = $totalPharmacyItemTabs + $saleQty;	
				$currentPharItemStock = floor($remPharItemTabs / $pack);	//pack stock
				$loosePharItemStock = $remPharItemTabs % $pack;			//loose stock
				
	 		}else{
	 			//for pharmacy Item
				$currentPharStock = $pharmacyStock + $saleQty;			//pack stock
				$loosePharStock = $pharmacyLooseStock;					//loose stock
				
				//for pharmacy Item Rate	
				$currentPharItemStock = $pharmacyItemStock + $saleQty;	//pack stock
				$loosePharItemStock = $pharmacyItemLooseStock;			//loose stock
			}
			
			$pharData = array();
			$pharmacyItem->id =   $item['PharmacyItem']['id'];
			$pharData['stock'] = $currentPharStock;
			$pharData['loose_stock'] = $loosePharStock;
			$pharmacyItem->save($pharData);
			$pharmacyItem->id = "";
			
			$pharItemData = array();
			$pharmacyItemRate->id = $itemRate['PharmacyItemRate']['id'];
			$pharItemData['stock'] = $currentPharItemStock;
			$pharItemData['loose_stock'] = $loosePharItemStock;
			$pharmacyItemRate->save($pharItemData);
			$pharmacyItemRate->id = "";
						
			}
		}
		return true;
	}
}
?>