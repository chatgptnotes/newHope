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
class ProductItemDetail extends AppModel {

	public $name = 'ProductItemDetail';

	  public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }
	public $belongsTo = array(
		'ProductDetail' => array(
		'className' => 'ProductDetail',
		'foreignKey' => 'product_detail_id'
		),
		'Product' => array(
		'className' => 'Product',
		'foreignKey' => 'item_id'
		)
	);
	/* for add the item details*/
	public function saveDetails($data,$id,$party_id){
		App::import('Component', 'DateFormat');
		$dateformat = new DateFormatComponent();
	 	$session = new cakeSession();
		$flag = true;
		$array_id = array();
		$productItem = Classregistry::init('Product');
		for($i=0;$i<count($data['item_name']);$i++){
			$field = array();
				$item = $productItem->find('first',array('conditions' => array("Product.id"=>$data['item_id'][$i],"Product.location_id" => $session->read('locationid'))));
			//$item = $pharmacyItem->findByName();
			$field['ProductItemDetail']['product_detail_id'] =$id;
			$field['ProductItemDetail']['qty'] = $data['qty'][$i];
			$field['ProductItemDetail']['batch_no'] = $data['batch_number'][$i];
			$field['ProductItemDetail']['expiry_date'] = $dateformat->formatDate2STD( $data['expiry_date'][$i] ,Configure::read('date_format'));
			$field['ProductItemDetail']['free'] = $data['free'][$i];
			$field['ProductItemDetail']['value'] = $data['value'][$i];
            $field['ProductItemDetail']['mrp'] = number_format($data['mrp'][$i],2);
            $field['ProductItemDetail']['price'] = number_format($data['price'][$i],2);
			$field['ProductItemDetail']['item_id'] = $item['Product']['id'];
			$field['ProductItemDetail']['tax'] = $data['tax'][$i];


			$stock = (double)$item['Product']['quantity']+(double)$data['qty'][$i];
			$this->create();
			$this->save($field);

			 $errors = $this->invalidFields();
			 if(!empty($errors)) {
			 	$flag =  false;
			 }else{
			 	$productItem->id =   $item['Product']['id'];
				$productItem->saveField('quantity', $stock);

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