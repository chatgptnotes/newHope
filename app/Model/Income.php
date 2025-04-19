<?php
class Income extends AppModel {

	public $name = 'Income';

	public $useTable = 'incomes';
	public $specific = true;
	public function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}



}