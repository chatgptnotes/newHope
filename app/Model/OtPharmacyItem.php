<?php 


class OtPharmacyItem extends AppModel {

	public $name = 'OtPharmacyItem';
	public $useTable= 'ot_pharmacy_items';
	
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
	
	public $hasMany = array(
		'OtPharmacyItemRate' => array(
		'className' => 'OtPharmacyItemRate',
		'dependent' => true,
		'foreignKey' => 'item_id'
		)
	);
	
	public function deleteOtPharmacyItem($postData) {
	
		$this->id = $postData;
		$this->data["OtPharmacyItem"]["id"] =$postData;
		$this->data["OtPharmacyItem"]["is_deleted"] = '1';
		$this->save($this->data);
	
		//delete item rate also
		$pharmacyItemRate= Classregistry::init('OtPharmacyItemRate');
		$pharmacyItemRate->updateAll(array('OtPharmacyItemRate.is_deleted'=>1),array('item_id'=>$postData));
		return true;
	}
	
	
	
}
?>