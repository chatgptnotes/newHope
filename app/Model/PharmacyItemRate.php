<?php
/**
 * WardModel file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       PharmacyItemRate Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Mayank Jain
 */
class PharmacyItemRate extends AppModel {
	
	public $name = 'PharmacyItemRate';

	
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
	 public $belongsTo = array(
		'PharmacyItem' => array(
		'className' => 'PharmacyItem',
		'foreignKey' => 'item_id'
		)
	);  
	
	
	 /* add the rate of item in rate table*/
	 public function insertRate($data){
	 	$field = array();
		$pharmacyItem = Classregistry::init('PharmacyItem');
		for($i=0;$i<count($data['item_name']);$i++){
			$item = $pharmacyItem->findByName($data['item_name'][$i]);		
			$field['mrp'] = $data['mrp'][$i];
			$field['purchase_price'] = $data['price'][$i];
			$field['item_id'] = $item['PharmacyItem']['id'];
			$this->id = $item['PharmacyItemRate']['id'];
			$this->save($field);
			 $errors = $this->invalidFields();
			 if(!empty($errors)) {
			 	return false;
			 }else{
				return $this->id;
			}
		}
	}	
	
	/* To delete particular item rate by swapnil*/
	 public function deletePharmacyItemRate($id){
			$pharmacyItem = Classregistry::init('PharmacyItem');
			if(!empty($id)){ 
				$pharmacyItem->begin();
				$itemRateData = $this->find('first',array('conditions'=>array('PharmacyItemRate.id'=>$id)));
				$itemData = $pharmacyItem->find('first',array('conditions'=>array('PharmacyItem.id'=>$itemRateData['PharmacyItemRate']['item_id'])));
				$pack = (int)$itemData['PharmacyItem']['pack'];
				$totalItemRateStock = ($itemData['PharmacyItemRate']['stock'] * $pack) + $itemData['PharmacyItemRate']['loose_stock'];
				$totalItemStock = ($itemData['PharmacyItem']['stock'] * $pack) + $itemData['PharmacyItem']['loose_stock'];
				$updatedTotalStock = $totalItemStock - $totalItemRateStock;
				
				$updateData = array();
				$updateData['stock'] = floor($updatedTotalStock/$pack);
				$updateData['loose_stock'] = floor($updatedTotalStock % $pack);
				
				//deduct the deleted qty from pharmacy Item by swapnil 
				$pharmacyItem->id = $itemData['PharmacyItem']['id'];
				$pharmacyItem->save($updateData);
				$pharmacyItem->id = '';
				 
				$this->id = $id;
		      	$this->data["PharmacyItemRate"]["id"] =$id;
		      	$this->data["PharmacyItemRate"]["is_deleted"] = '1';
		      	
		      	if($this->save($this->data)){
			      	$error = false;
		      	}
		      	
		      	if($error == false){
		      		$pharmacyItem->commit();
		      	}else{
		      		$pharmacyItem->rollback();
		      	}
			}
		}	
	
}
?>