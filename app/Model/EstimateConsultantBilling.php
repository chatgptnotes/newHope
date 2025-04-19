<?php 
/**
 * EstimateConsultantBilling model
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Estimate Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 * @functions 	 : Add test respective to patient
 */
class EstimateConsultantBilling extends AppModel {

	public $name = 'EstimateConsultantBilling';

	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}

	public function assignPackage($data = array()){
		$session = new cakeSession();
		$optAppointment = ClassRegistry::init('OptAppointment');
		$data['location_id'] =  $data['location_id'] ;// passing dynamic locationId by user selection
		$data['created_by'] =  $session->read('userid') ;
		$data['create_time'] =  date('Y-m-d H:i:s') ;
		$data['modified_by'] =  $session->read('userid') ;
		$data['modify_time'] =  date('Y-m-d H:i:s') ;
		$data['other_doctor_staff'] = serialize($data['other_doctor_staff']);
		$data['payment_instruction'] = serialize($data['payment_instruction']);
		$data['discount'] = serialize($data['discount']);
		$data['date'] = DateFormatComponent::formatDate2STD($data['date'],Configure::read('date_format')) ;
		$data['admission_date'] = DateFormatComponent::formatDate2STD($data['admission_date'],Configure::read('date_format')) ;
		$data['surgery_date'] = DateFormatComponent::formatDate2STD(trim($data['surgery_date']).' '.date('H:i:s'),Configure::read('date_format')) ;
		if($data['approved']){
			$existingOpt = $optAppointment->find('count',array('conditions'=>array('OptAppointment.patient_id'=> $data['patient_id'],
					'OptAppointment.is_false_appointment !='=> 0)));
			if($existingOpt == 0)
				$data['opt_appointment_id'] = $this->setOptAppointment($data);
		}
		if($data['admittedPatient']){
			$this->updatePatientPackage($data['patient_id'],$data['admission_date']);
		}
		$this->save($data);
		$data['id'] = $this->id;
		return $data;
		 
	}

	public function setOptAppointment($packageData = array()){
		$optAppointment = ClassRegistry::init('OptAppointment');
		$packageEstimate = ClassRegistry::init('PackageEstimate');
		 
		$surgeryInfo = $packageEstimate->find('first',array('fields'=>array('surgery_category_id','surgery_subcategory_id'),
				'conditions'=>array('id'=>$packageData['package_estimate_id'])));
		$endTime = explode(' ',$packageData['surgery_date']);
		$endTime = $endTime[0]." ".date('H:i:s', strtotime('+1 hour'));
		$optDataArray = array(
				'patient_id' => $packageData['patient_id'],
				'is_false_appointment' => '1',
				'location_id' => $packageData['location_id'],
				'schedule_date' => $packageData['surgery_date'],
				'start_time' => date('H:i'),
				'end_time' => date('H:i', strtotime('+1 hour')),
				'starttime' => $packageData['surgery_date'],
				'endtime' => $endTime,
				'surgery_id' => $packageData['surgery_id'],
				'surgery_category_id' =>$surgeryInfo['PackageEstimate']['surgery_category_id'],
				'surgery_subcategory_id' =>$surgeryInfo['PackageEstimate']['surgery_subcategory_id'],
				'color' => '-1'
		);
		$optAppointment->save($optDataArray);
		return $optAppointment->id;
	}
	
	/**
	 * function to update is_packaged field when patient is IPD 
	 */
	function updatePatientPackage($patientId,$packageApplicationDate){
		$Patient = ClassRegistry::init('Patient');
		$updateStatus = $Patient->updateAll(array('is_packaged'=>"'".$patientId."'",'package_application_date'=>"'".$packageApplicationDate."'"),array('Patient.id'=>$patientId));
		return $updateStatus;
	}
}