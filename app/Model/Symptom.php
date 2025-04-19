<?php

App::uses('AppModel', 'Model');
/**
 * CollaborateCompany Model
 *
 * @property Patient $Patient
*/
class Symptom extends AppModel {

	public $specific = true;
	public $name = 'Symptom';
	var $useTable = 'symptoms';

	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}

	
	function insertSymptom($data =array()){
		 
		$session = new cakeSession();
	
		if(!empty($data["Symptom"]["id"])){
			$data["Symptom"]["modify_time"] = date("Y-m-d H:i:s");
			$data["Symptom"]["modified_by"] = $session->read('userid') ;
			$data["Symptom"]["location_id"] = $session->read('locationid');
		}else{
			$data["Symptom"]["create_time"] = date("Y-m-d H:i:s");
			$data["Symptom"]["created_by"]  = $session->read('userid') ;
			$data["Symptom"]["location_id"] = $session->read('locationid');
		}
		$this->create();
		$this->save($data);
		//$lastinsid=$this->getInsertId();
		return true;
	}

}
?>