<?php
class Hl7Nip extends AppModel {
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $name = 'Hl7Nip';


	public $specific = true;
	//public $useTable='ambulatory_results';
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}

}
?>