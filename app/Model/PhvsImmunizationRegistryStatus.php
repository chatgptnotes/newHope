<?php

App::uses('AppModel', 'Model');
/**
 * CollaborateCompany Model
 *
 * @property Patient $Patient
*/
class PhvsImmunizationRegistryStatus extends AppModel {

	public $specific = true;
	public $name = 'PhvsImmunizationRegistryStatus';
	var $useTable = 'phvs_immunization_registry_status';
	
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}


}
?>