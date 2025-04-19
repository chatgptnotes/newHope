<?php

class BmiBpResult extends AppModel {

	public $specific = true;
	public $name = 'BmiBpResult';
	var $useTable = 'bmi_bp_results';
	
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}

}
?>