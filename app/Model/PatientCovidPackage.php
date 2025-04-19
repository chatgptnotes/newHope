<?php
class PatientCovidPackage extends AppModel {

	public $name = 'PatientCovidPackage';

	public $specific = true; 
	function __construct($id = false, $table = null, $ds = null) {
		if(empty($ds)){
        	$session = new cakeSession();
			$this->db_name =  $session->read('db_name');
	 	}else{
	 		$this->db_name =  $ds;
	 	}
		parent::__construct($id, $table, $ds);
	}

	function getTotalCovidPackageBill($patientIds = array()){

		$data = $this->find('all',array('conditions'=>array('PatientCovidPackage.patient_id'=>$patientIds)));
		$totalCovidBill = array();
		foreach ($data as $key => $value) {
			$packageCost = $value['PatientCovidPackage']['package_cost'] * $value['PatientCovidPackage']['package_days'] ;
			$ppeCost = $value['PatientCovidPackage']['ppe_unit_cost'] * $value['PatientCovidPackage']['ppe_count'] ;
			$visitCost = $value['PatientCovidPackage']['doctor_visiting_charge'] * $value['PatientCovidPackage']['no_of_visit'] ;

			$totalCovidBill[$value['PatientCovidPackage']['patient_id']]['total_package_bill'] += ($packageCost) ? $packageCost : 0  ;
			$totalCovidBill[$value['PatientCovidPackage']['patient_id']]['total_ppe_bill'] += ($ppeCost) ? $ppeCost : 0 ;
			$totalCovidBill[$value['PatientCovidPackage']['patient_id']]['total_visit_bill'] += ($visitCost) ? $visitCost : 0  ;
		}
		return $totalCovidBill ;

	}
	
}
?>