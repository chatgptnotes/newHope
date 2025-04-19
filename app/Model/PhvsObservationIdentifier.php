<?php

App::uses('AppModel', 'Model');
/**
 * CollaborateCompany Model
 *
 * @property Patient $Patient
*/
class PhvsObservationIdentifier extends AppModel {

	public $specific = true;
	public $name = 'PhvsObservationIdentifier';
	var $useTable = 'phvs_observation_identifiers';
	
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}


}
?>