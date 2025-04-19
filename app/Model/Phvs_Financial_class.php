<?php

App::uses('AppModel', 'Model');
/**
 * CollaborateCompany Model
 *
 * @property Patient $Patient
*/
class Phvs_Financial_class extends AppModel {

	public $specific = true;
	public $name = 'Phvs_Financial_class';
	var $useTable = 'phvs_financial_class';
	
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}


}
?>