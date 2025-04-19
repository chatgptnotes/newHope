<?php

App::uses('AppModel', 'Model');
/**
 * CollaborateCompany Model
 *
 * @property Patient $Patient
*/
class PlannedProblem extends AppModel {

	public $specific = true;
	public $name = 'PlannedProblem';
	var $useTable = 'planned_problems';

	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}

	
	function insertProblem($data =array()){
		 
		$session = new cakeSession();
	
		if(!empty($data["PlannedProblem"]["id"])){
			$data["PlannedProblem"]["modify_time"] = date("Y-m-d H:i:s");
			$data["PlannedProblem"]["modified_by"] = $session->read('userid') ;
			$data["PlannedProblem"]["location_id"] = $session->read('locationid');
		}else{
			$data["PlannedProblem"]["create_time"] = date("Y-m-d H:i:s");
			$data["PlannedProblem"]["created_by"]  = $session->read('userid') ;
			$data["PlannedProblem"]["location_id"] = $session->read('locationid');
		}
		$this->create();
		$this->save($data);
		//$lastinsid=$this->getInsertId();
		return true;
	}

}
?>