<?php
class VaccinationRemainder extends AppModel {

	public $name = 'VaccinationRemainder';


	public $specific = true;
	public $useTable='vaccination_remainders';
	public function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}



}