<?php 
App::uses('AppModel', 'Model');
/**
 * CollaborateCompany Model
 *
 * @property Patient $Patient
 */
class PhvsIcd9cm extends AppModel {
	
	public $name = 'PhvsIcd9cm';
	var $useTable = 'phvs_icd9cms';
	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}
	

}
?>