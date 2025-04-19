<?php

App::uses('AppModel', 'Model');
/**
 * CollaborateCompany Model
 *
 * @property Patient $Patient
*/
class Rxnatomarchive extends AppModel {

	public $specific = true;
	public $name = 'Rxnatomarchive';
	var $useTable = 'rxnatomarchives';
	
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}


}
?>