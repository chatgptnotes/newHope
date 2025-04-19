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
class InventoryPurchaseItemDetail extends AppModel {

	public $name = 'InventoryPurchaseItemDetail';

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
		'InventoryPurchaseDetail' => array(
		'className' => 'InventoryPurchaseDetail',
		'foreignKey' => 'inventory_purchase_detail_id'
		),
		'PharmacyItem' => array(
		'className' => 'PharmacyItem',
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
		$pharmacyItem = Classregistry::init('PharmacyItem');
		//$voucherEntry = ClassRegistry::init('VoucherEntry');
		for($i=0;$i<count($data['item_name']);$i++){
			$field = array();
				$item = $pharmacyItem->find('first',array('conditions' => array("PharmacyItem.id"=>$data['item_id'][$i],"PharmacyItem.location_id" => $session->read('locationid'))));
			//$item = $pharmacyItem->findByName();
			$field['InventoryPurchaseItemDetail']['inventory_purchase_detail_id'] =$id;
			$field['InventoryPurchaseItemDetail']['qty'] = $data['qty'][$i];
			$field['InventoryPurchaseItemDetail']['batch_no'] = $data['batch_number'][$i];
			$field['InventoryPurchaseItemDetail']['expiry_date'] = $dateformat->formatDate2STD( $data['expiry_date'][$i] ,Configure::read('date_format'));
			$field['InventoryPurchaseItemDetail']['free'] = $data['free'][$i];
			$field['InventoryPurchaseItemDetail']['value'] = $data['value'][$i];
            $field['InventoryPurchaseItemDetail']['mrp'] = number_format($data['mrp'][$i],2);
            $field['InventoryPurchaseItemDetail']['price'] = number_format($data['price'][$i],2);
			$field['InventoryPurchaseItemDetail']['item_id'] = $item['PharmacyItem']['id'];
			$field['InventoryPurchaseItemDetail']['tax'] = $data['tax'][$i];
			$stock = (double)$item['PharmacyItem']['stock']+(double)$data['qty'][$i]; 
			$this->create();
			
			//journal entry by amit jain
			//commented by amit jain
			/* $field['InventoryPurchaseItemDetail']['vr_date'] = $dateformat->formatDate2STD($data['InventoryPurchaseDetail']['vr_date'],Configure::read('date_format'));
			$jvData = array('date'=>$field['InventoryPurchaseItemDetail']['vr_date'],
					'user_id'=>$field['InventoryPurchaseItemDetail']['item_id'],
					'credit_amount'=>$field['InventoryPurchaseItemDetail']['value'],
					'type'=>'Pharmacy',
					//'narration'=>$field['InventoryPurchaseItemDetail']['narration'],
					//'patient_id'=>$resetData['LaboratoryTestOrder'][$x]['patient_id']
					);
			$voucherEntry->insertJournalEntry($jvData);
			$this->VoucherEntry->id= ''; */
			//EOF JV
			$this->save($field);

			 $errors = $this->invalidFields();
			 if(!empty($errors)) {
			 	$flag =  false;
			 }else{
			 	/* increase the stock by quantity*///echo $item['PharmacyItem']['id'];exit;
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