<?php

App::uses('AppModel', 'Model');
/**
 * CollaborateCompany Model
 *
 * @property Patient $Patient
*/
class Diagnostic extends AppModel {

	public $specific = true;
	public $name = 'Diagnostic';
	var $useTable = 'diagnostics';

	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}

	
	function insertDiagnostic($data =array()){
		 
		$session = new cakeSession();
	
		if(!empty($data["Diagnostic"]["id"])){
			$data["Diagnostic"]["modify_time"] = date("Y-m-d H:i:s");
			$data["Diagnostic"]["modified_by"] = $session->read('userid') ;
			$data["Diagnostic"]["location_id"] = $session->read('locationid');
		}else{
			$data["Diagnostic"]["create_time"] = date("Y-m-d H:i:s");
			$data["Diagnostic"]["created_by"]  = $session->read('userid') ;
			$data["Diagnostic"]["location_id"] = $session->read('locationid');
		}
		$this->create();
		$this->save($data);
		//$lastinsid=$this->getInsertId();
		return true;
	}

}
?>
