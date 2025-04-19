<?php
class VerifyMedicationOrder extends AppModel {

	public $name = 'VerifyMedicationOrder';


	public $specific = true;
	public function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}



}