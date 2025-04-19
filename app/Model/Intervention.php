<?php

App::uses('AppModel', 'Model');
/**
 * CollaborateCompany Model
 *
 * @property Patient $Patient
*/
class Intervention extends AppModel {

	public $specific = true;
	public $name = 'Intervention';
	var $useTable = 'interventions';

	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}

	
	function insertIntervention($data =array()){
		 
		$session = new cakeSession();
	
		if(!empty($data["Intervention"]["id"])){
			$data["Intervention"]["modify_time"] = date("Y-m-d H:i:s");
			$data["Intervention"]["modified_by"] = $session->read('userid') ;
			$data["Intervention"]["location_id"] = $session->read('locationid');
		}else{
			$data["Intervention"]["create_time"] = date("Y-m-d H:i:s");
			$data["Intervention"]["created_by"]  = $session->read('userid') ;
			$data["Intervention"]["location_id"] = $session->read('locationid');
		}
		$this->create();
		$this->save($data);
		//$lastinsid=$this->getInsertId();
		return true;
	}

}
?>