

<?php
App::uses ( 'AppModel', 'Model' );
/**
 * CollaborateCompany Model
 *
 * @property Patient $Patient
 *
 */
class LaboratoryManualEntry extends AppModel {
	public $name = 'LaboratoryManualEntry';
	var $useTable = 'laboratory_manual_entry';
	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession ();
		$this->db_name = $session->read ( 'db_name' );
		parent::__construct ( $id, $table, $ds );
	}
}
?>