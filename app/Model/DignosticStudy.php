<?php

App::uses('AppModel', 'Model');
/**
 * CollaborateCompany Model
 *
 * @property Patient $Patient
*/
class DignosticStudy extends AppModel {

	public $specific = true;
	public $name = 'DignosticStudy';
	var $useTable = 'dignostic_studys';

	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}

	
	function insertProcedure($data =array()){
		 
		$session = new cakeSession();
	
		if(!empty($data["DignosticStudy"]["id"])){
			$data["DignosticStudy"]["modify_time"] = date("Y-m-d H:i:s");
			$data["DignosticStudy"]["modified_by"] = $session->read('userid') ;
			$data["DignosticStudy"]["location_id"] = $session->read('locationid');
		}else{
			$data["DignosticStudy"]["create_time"] = date("Y-m-d H:i:s");
			$data["DignosticStudy"]["created_by"]  = $session->read('userid') ;
			$data["DignosticStudy"]["location_id"] = $session->read('locationid');
		}
		$this->create();
		$this->save($data);
		//$lastinsid=$this->getInsertId();
		return true;
	}

}
?>