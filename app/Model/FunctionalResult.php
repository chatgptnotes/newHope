<?php

App::uses('AppModel', 'Model');
/**
 * CollaborateCompany Model
 *
 * @property Patient $Patient
*/
class FunctionalResult extends AppModel {

	public $specific = true;
	public $name = 'FunctionalResult';
	var $useTable = 'functional_results';

	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}

	
	function insertResult($data =array()){
		 
		$session = new cakeSession();
	
		if(!empty($data["FunctionalResult"]["id"])){
			$data["FunctionalResult"]["modify_time"] = date("Y-m-d H:i:s");
			$data["FunctionalResult"]["modified_by"] = $session->read('userid') ;
			$data["FunctionalResult"]["location_id"] = $session->read('locationid');
		}else{
			$data["FunctionalResult"]["create_time"] = date("Y-m-d H:i:s");
			$data["FunctionalResult"]["created_by"]  = $session->read('userid') ;
			$data["FunctionalResult"]["location_id"] = $session->read('locationid');
		}
		$this->create();
		$this->save($data);
		//$lastinsid=$this->getInsertId();
		return true;
	}

}
?>