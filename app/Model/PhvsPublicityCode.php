<?php

App::uses('AppModel', 'Model');
/**
 * CollaborateCompany Model
 *
 * @property Patient $Patient
*/
class PhvsPublicityCode extends AppModel {

	public $specific = true;
	public $name = 'PhvsPublicityCode';
	var $useTable = 'phvs_publicity_codes';
	
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}


}
?>