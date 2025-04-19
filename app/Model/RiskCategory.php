<?php

App::uses('AppModel', 'Model');
/**
 * CollaborateCompany Model
 *
 * @property Patient $Patient
*/
class RiskCategory extends AppModel {

	public $specific = true;
	public $name = 'RiskCategory';
	var $useTable = 'risk_categories';

	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}

	
	function insertRiskCategory($data =array()){
		 
		$session = new cakeSession();
	
		if(!empty($data["RiskCategory"]["id"])){
			$data["RiskCategory"]["modify_time"] = date("Y-m-d H:i:s");
			$data["RiskCategory"]["modified_by"] = $session->read('userid') ;
			$data["RiskCategory"]["location_id"] = $session->read('locationid');
		}else{
			$data["RiskCategory"]["create_time"] = date("Y-m-d H:i:s");
			$data["RiskCategory"]["created_by"]  = $session->read('userid') ;
			$data["RiskCategory"]["location_id"] = $session->read('locationid');
		}
		$this->create();
		$this->save($data);
		//$lastinsid=$this->getInsertId();
		return true;
	}

}
?>
