<?php

App::uses('AppModel', 'Model');
/**
 * CollaborateCompany Model
 *
 * @property Patient $Patient
*/
class BillingOtherCode extends AppModel {

	public $specific = true;
	public $name = 'BillingOtherCode';
	var $useTable = 'billing_other_codes';
	
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}
	

}
?>