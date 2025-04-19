<?php 

class OtPharmacySalesReturn extends AppModel {

	public $name = 'OtPharmacySalesReturn';
	public $useTable= 'ot_pharmacy_sales_returns';

	public $hasMany = array(
			'OtPharmacySalesReturnDetail' => array(
					'className' => 'OtPharmacySalesReturnDetail',
					'foreignKey' => 'ot_pharmacy_sales_return_id',
					'dependent'=> true
			)
	);

	public $belongsTo = array(
			'Patient' => array(
					'className' => 'Patient',
					'foreignKey' => 'patient_id',
					'dependent'=> true
			)
	);
	
	public function generateReturnBillNo(){		
		$getBillCount = $this->find('count');
		return "OT-".str_pad($getBillCount, 4, '0', STR_PAD_LEFT);
	}
	
	public function generateRandomBillNo(){
		$characters = array(
				"A","B","C","D","E","F","G","H","J","K","L","M",
				"N","P","Q","R","S","T","U","V","W","X","Y","Z",
				"1","2","3","4","5","6","7","8","9");
		$keys = array();
		$random_chars ='';
		while(count($keys) < 7) {
			$x = mt_rand(0, count($characters)-1);
			if(!in_array($x, $keys)) {
				$keys[] = $x;
			}
		}
		foreach($keys as $key){
			$random_chars .= $characters[$key];
		}
		return $random_chars;
	}

	public function saveBillDetails($data,$id){

		$flag = true;
		$array_id = array();
		$pharmacyItem = Classregistry::init('OtPharmacyItem');
		for($i=0;$i<count($data['item_id']);$i++){
			$field = array();
			$field['qty'] = $data['qty'][$i];
			$item = $pharmacyItem->findById($data['item_id'][$i]);
			$field['item_id'] = $data['item_id'][$i];
			$field['ot_pharmacy_sales_bill_id'] = $id;
			$this->create();
			$this->save($field);
			$errors = $this->invalidFields();
			if(!empty($errors)) {
				$flag =  false;
			}else{
				/* decrease the stock by quantity*/
				$stock = (double)$item['OtPharmacyItem']['stock']-(double)$data['qty'][$i];
				$pharmacyItem->id =   $item['OtPharmacyItem']['id'];
				$pharmacyItem->saveField('stock', $stock);

			}
		}
	}
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
	
	/**
	 * for otpharmacy return data
	 * @param unknown_type $patient_id
	 * @return unknown
	 * @yashwant
	 */
	public function getOtPharmacyReturnData($patient_id){
		$OtPharmacyReturnData=$this->find('all',array('fields'=>array('OtPharmacySalesReturn.*'),
				'conditions'=>array('OtPharmacySalesReturn.patient_id'=>$patient_id,'OtPharmacySalesReturn.is_deleted'=>'0')));
		return $OtPharmacyReturnData;
	}
}

?>