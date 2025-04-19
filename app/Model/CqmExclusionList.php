<?php 
App::uses('AppModel', 'Model');
/**
 * CollaborateCompany Model
 *
 * @property Patient $Patient
 */
class CqmExclusionList extends AppModel {
	
	public $name = 'CqmExclusionList';
	var $useTable = 'cqm_exclusion_lists';
	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}
	

}
?>