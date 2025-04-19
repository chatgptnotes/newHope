<?php
/**
 * WardModel file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       InventoryPurchaseReturnItem Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Mayank Jain
 */
class InventoryPurchaseReturnItem extends AppModel {
	
	public $name = 'InventoryPurchaseReturnItem';
	
	  public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }  
	public $belongsTo = array(
		'InventoryPurchaseReturnItem' => array(
		'className' => 'InventoryPurchaseReturnItem',
		'foreignKey' => 'inventory_purchase_return_id'
		),
		'PharmacyItem' => array(
		'className' => 'PharmacyItem',
		'foreignKey' => 'item_id'
		)
	); 
	/* for add the item details*/
	public function saveReturnDetails($data,$id){
		App::import('Component', 'DateFormat');
	    $dateformat = new DateFormatComponent();
		$flag = true;
		$array_id = array();
		$pharmacyItem = Classregistry::init('PharmacyItem');
		for($i=0;$i<count($data['item_name']);$i++){
			$field = array();
			$item = $pharmacyItem->findByName($data['item_name'][$i]);
			$field['inventory_purchase_return_id'] =$id;
			$field['qty'] = $data['qty'][$i];
			$field['batch_no'] = $data['batch_number'][$i];
			$field['expiry_date'] = $dateformat->formatDate2STD( $data['expiry_date'][$i] ,Configure::read('date_format'));
			$field['free'] = $data['free'][$i];
			$field['value'] = $data['value'][$i];
			$field['item_id'] = $item['PharmacyItem']['id'];
			$field['tax'] = $data['tax'][$i];
			$stock = (double)$item['PharmacyItem']['stock']-(double)$data['qty'][$i];
			$this->create();
			$this->save($field);
			 $errors = $this->invalidFields();
			 if(!empty($errors)) {
			 	$flag =  false;
			 }else{
			 	/* increase the stock by quantity*/
				$pharmacyItem->id =   $item['PharmacyItem']['id'];
				$pharmacyItem->saveField('stock', $stock);
				array_push($array_id,$this->id);
			}
		}
		if($flag==false){
			return false;
		}else{
			return $array_id;
		}
	}
}
?>