<?php

App::uses('AppModel', 'Model');
/**
 * CollaborateCompany Model
 *
 * @property Patient $Patient
*/
class PhvsVaccinesMvx extends AppModel {

	public $specific = true;
	public $name = 'PhvsVaccinesMvx';
	var $useTable = 'phvs_vaccines_mvxs';
	
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}


}
?>