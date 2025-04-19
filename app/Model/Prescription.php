<?php
class Prescription extends AppModel {

	public $name = 'PrescriptionRecord';
	public $useTable = 'prescription_records';

	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}

	public function insertPrescriptionRecord($data=array(),$action='insert'){
	
		$data1[PrescriptionRecord] = $data;
		$session = new cakeSession();

		if(isset($data1['PrescriptionRecord']['id']) && !empty($data1['PrescriptionRecord']['id'])){
			$data1['PrescriptionRecord']['modify_time']= date("Y-m-d H:i:s");
			$data1['PrescriptionRecord']["modified_by"] =  $session->read('userid');

		}else{
			$data1['PrescriptionRecord']['create_time'] = date("Y-m-d H:i:s");
			$data1['PrescriptionRecord']["created_by"]  =  $session->read('userid');
		}
		$presSave  = $this->save($data1); 
		return $presSave  ;

	}
}
?>