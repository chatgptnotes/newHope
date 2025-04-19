<?php

App::uses('AppModel', 'Model');
/**
 * CollaborateCompany Model
 *
 * @property Patient $Patient
*/
class ProcedurePerform extends AppModel {

	public $specific = true;
	public $name = 'ProcedurePerform';
	var $useTable = 'procedure_performs';

	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}

	
	function insertProcedurePerform($data =array()){
		 
		$session = new cakeSession();
	
		if(!empty($data["ProcedurePerform"]["id"])){
			$data["ProcedurePerform"]["modifid_time"] = date("Y-m-d H:i:s");
			$data["ProcedurePerform"]["modified_by"] = $session->read('userid') ;
			$data["ProcedurePerform"]["location_id"] = $session->read('locationid');
		}else{
			$data["ProcedurePerform"]["create_time"] = date("Y-m-d H:i:s");
			$data["ProcedurePerform"]["created_by"]  = $session->read('userid') ;
			$data["ProcedurePerform"]["location_id"] = $session->read('locationid');
		}
		debug($data);exit;
		$this->create();
		$this->save($data);
		//$lastinsid=$this->getInsertId();
		return true;
	}

}
?>
