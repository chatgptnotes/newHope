<?php
class PatientCompletedSaleBill extends AppModel {
	
	public $name = 'PatientCompletedSaleBill';
	public $useTable = 'patient_completed_sale_bills';

	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}
}
?>
