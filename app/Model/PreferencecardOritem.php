<?php

App::uses('AppModel', 'Model');
/**
 * CollaborateCompany Model
 *
 * @property Patient $Patient
*/
class PreferencecardOritem extends AppModel {

	public $specific = true;
	public $name = 'PreferencecardOritem';
	var $useTable = 'preferencecard_oritems';

	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}


}
?>