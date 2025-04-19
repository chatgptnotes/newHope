<?php
class Hl70322Completionstatuses extends AppModel {
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $name = 'Hl70322Completionstatuses';


	public $specific = true;
	public $useTable='hl7_0322_completionstatuses';
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}

}
