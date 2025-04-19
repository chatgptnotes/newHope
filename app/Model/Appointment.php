<?php
class Appointment extends AppModel {

	public $name = 'Appointment';
	public $validate = array(
			'doctor_id' => array(
					'rule' => "notEmpty",
					'message' => "Please select doctor."
			),
			'date' => array(
					'rule' => "notEmpty",
					'message' => "Please enter visit date."
			),
			'start_time' => array(
					'rule' => "notEmpty",
					'message' => "Please enter start time."
			),
			'visit_type' => array(
					'rule' => "notEmpty",
					'message' => "Please enter visit type."
			),
			 
	);

	public function getAppointmentsByPatientID($patient_id=null){
		return $this->find('all',array('conditions'=>array('patient_id'=>$patient_id,'is_deleted'=>0)));
	}

	public function insertAppointment($data=array(),$action='insert'){
		App::import('Model', 'CakeSession');
		$session = new CakeSession();
		//swapping some of the field from appointment form
		$data["Appointment"]['start_time'] = $data["Appointment"]['start'];
		$data["Appointment"]['end_time'] = $data["Appointment"]['end'];
		if($action=='insert'){
			$data["Appointment"]["modify_time"] = date("Y-m-d H:i:s");
			$data["Appointment"]["modified_by"] = $session->read('userid');
			$data["Appointment"]["create_time"] = date("Y-m-d H:i:s");
			$data["Appointment"]["created_by"] = $session->read('userid');
		}else{
			$data["Appointment"]["modified_by"] = $session->read('userid');
			$data["Appointment"]["modify_time"] = date("Y-m-d H:i:s");
		}
		 
		//BOF assign token to patient's appointment by pankaj
		$data['Appointment']['app_token'] = $this->tokenNoPerPhysician($data["Appointment"]['doctor_id'])  ;
		//EOF token display
		$this->create();
		return $this->save($data);
	}

	function searchAppointment($app_date=null,$app_Dept=null,$app_Phys=null){

		//set search conditions
		$search_key['Appointment.is_deleted'] = "0" ;
		if(!empty($app_date)){
			$search_key['Appointment.date like'] = "%".$app_date ;
		}if(!empty($app_Dept)){
			$search_key['Appointment.department_id'] = $app_Dept ;
		}if(!empty($app_Phys)){
			$search_key['Appointment.doctor_id'] = $app_Phys ;
		}

		$this->bindModel(array(
				'belongsTo' => array(
						'User' =>array('foreignKey'=>'doctor_id'),
						'Department' =>array('foreignKey'=>'department_id'),
						'Patient' =>array('foreignKey'=>'patient_id'),
				)));
		return $search_key;

	}

	public $specific = true;
	public function __construct($id = false, $table = null, $ds = null) {
		if(empty($ds)){
        	$session = new cakeSession();
			$this->db_name =  $session->read('db_name');
	 	}else{
	 		$this->db_name =  $ds;
	 	}
		parent::__construct($id, $table, $ds);
	}

	//for opProcess done after selecting option seen or closed
	function opProcessDone($appointmentID=null){
		 
		$getAppointment = Classregistry::init('Appointment');
		$getFinalBilling = Classregistry::init('FinalBilling');
		$getPatient = Classregistry::init('Patient');
		$session = new cakeSession();
		 
		$patientId = $getAppointment->find('first',array('fields'=>array('Appointment.patient_id'),'conditions'=>array('Appointment.id'=>$appointmentID))) ;
			
		$finalBillingId = $getFinalBilling->find('first',array('fields'=>array('id'),
				'conditions'=>array('FinalBilling.patient_id'=> $patientId['Appointment']['patient_id'])));

		if(!empty($finalBillingId['FinalBilling']['id'])){
				
			$getFinalBillingData['FinalBilling']['date'] = date('Y-m-d');
			$getFinalBillingData['FinalBilling']['location_id'] = $session->read('locationid');
			$getFinalBillingData['FinalBilling']['created_by'] = $session->read('userid');
			$getFinalBillingData['FinalBilling']['modified_by'] = $session->read('userid');
			$getFinalBillingData['FinalBilling']['FinalBilling']['reason_of_discharge'] = 'Recovered';
			$getFinalBillingData['FinalBilling']['discharge_date'] = date('Y-m-d H:i:s');
			$getFinalBillingData['FinalBilling']['modify_time'] = date('Y-m-d H:i:s');
			$getFinalBillingData['FinalBilling']['id'] = $finalBillingId['FinalBilling']['id'];
			$getFinalBilling->save($getFinalBillingData['FinalBilling']);
		}else{
				
			$getFinalBillingData['FinalBilling']['date'] = date('Y-m-d');
			$getFinalBillingData['FinalBilling']['location_id'] = $session->read('locationid');
			$getFinalBillingData['FinalBilling']['created_by'] = $session->read('userid');
			$getFinalBillingData['FinalBilling']['create_time'] = date('Y-m-d H:i:s');
			$getFinalBillingData['FinalBilling']['reason_of_discharge'] = 'Recovered';
			$getFinalBillingData['FinalBilling']['discharge_date'] = date('Y-m-d H:i:s');
			$getFinalBillingData['FinalBilling']['patient_id'] = $patientId['Appointment']['patient_id'];
			$getFinalBilling->save($getFinalBillingData['FinalBilling']);
		}
		if(!empty($patientId['Appointment']['patient_id'])){
			$getPatientData['Patient']['is_discharge'] = '1';
			$getPatientData['Patient']['discharge_date'] = date('Y-m-d H:i:s');
			$getPatientData['Patient']['id'] = $patientId['Appointment']['patient_id'];
			$getPatient->save($getPatientData['Patient']);
		}
		return;

	}

	function setCurrentAppointment($patientArray=array()){
		$session = new CakeSession();
		$Appointment = Classregistry::init('Appointment');
		App::import('Vendor', 'DrmhopeDB');
		if(!empty($_SESSION['db_name'])){
			$db_connection = new DrmhopeDB($_SESSION['db_name']);
		}else{
			$db_connection = new DrmhopeDB('db_hope');
		}
		$db_connection->makeConnection($Appointment);
		//swapping some of the field from appointment form
		$data['Appointment']['person_id'] = $patientArray['Patient']['person_id'];
		$data['Appointment']['patient_id'] = $patientArray['Patient']['patient_id'];

		//by pankaj w
		if(!empty($patientArray["Patient"]['location_id'])){
			$data['Appointment']['location_id']  = $patientArray["Patient"]['location_id'] ; 
		}else{
			$data['Appointment']['location_id'] = $session->read('locationid');		
		} 

		$data['Appointment']['department_id'] = $patientArray['Patient']['department_id'];
		$data['Appointment']['doctor_id'] = $patientArray['Patient']['doctor_id'];
		$data['Appointment']['appointment_with'] = $patientArray['Patient']['doctor_id'];
		$data['Appointment']['date'] = $patientArray['Patient']['form_received_on'];
		if(trim($patientArray['Patient']['mode_communication'])=='Phone'){
			$data['Appointment']['status'] = 'Closed';
		}else{
			$data['Appointment']['status'] = 'Arrived';
		}
		$time = explode(':',date('H:i'));
		if($time[1] <= 15){
			$startTime = date('Y-m-d H').":15";
			$endTime = date('Y-m-d H').":30";
		}elseif($time[1] <= 30 && $time[1] >= 15 ){
			$startTime = date('Y-m-d H').":30";
			$endTime = date('Y-m-d H').":45";
		}elseif($time[1] <= 45 && $time[1] >= 30 ){
			$startTime = date('Y-m-d H').":45";
			$endTime = date('Y-m-d H', strtotime('+1 hour')).":00";
		}else{
			$startTime = date('Y-m-d H', strtotime('+1 hour')).":00";
			$endTime = date('Y-m-d H', strtotime('+1 hour')).":15";
		}
		
		if($patientArray['Person']['start_time']){
			$data['Appointment']['start_time'] =  date("H:i", strtotime($patientArray['Person']['start_time']));
			$data['Appointment']['end_time'] = date("H:i", strtotime($patientArray['Person']['start_time']."+15 minutes"));
			$data['Appointment']['status'] = 'Pending';
		}else{
			$data['Appointment']['start_time'] = date('H:i',strtotime($startTime));
			$data['Appointment']['end_time'] = date('H:i',strtotime($endTime));;
			$data['Appointment']['arrived_time'] = date('H:i');
		}
		$data['Appointment']['is_future_app'] = 0;
		if($patientArray['Patient']['treatment_type'])
			$data['Appointment']['visit_type'] = $patientArray['Patient']['treatment_type'];
		else
			$data['Appointment']['visit_type'] = 6;
		
		
		$data['Appointment']['created_by'] = $session->read('userid');
		$data['Appointment']['create_time'] = date('Y-m-d H:i:s');
		
		//BOF assign token to patient's appointment by pankaj
		$data['Appointment']['app_token'] = $this->tokenNoPerPhysician($patientArray['Patient']['doctor_id'])  ;
		//EOF token display
		 
		$this->create();
		return $Appointment->save($data);
	}
	
	
	/**
	 * doctor_id int
	 * return latest count of patient assigned to the doctor on current day
	 */
	function tokenNoPerPhysician($doctor_id=null){
		if(!$doctor_id) return false ;
		 
		$session = new cakeSession();
		$patientProfileObj = Classregistry::init('Patient') ;
		$count = $patientProfileObj->find('count',array('conditions'=>array('Patient.create_time like'=> "%".date("Y-m-d")."%",
				'Patient.location_id'=>$session->read('locationid'),'Patient.doctor_id'=>$doctor_id)));
		 
		return $count++ ;
	}
	
	
	/**
	 * setting multiple appointment for vadodara from quick reg
	 * Pooja Gupta
	 */
	function setMultipleAppointment($patientArray=array()){
		$session = new CakeSession();
		$Appointment = Classregistry::init('Appointment');
		$serviceBillingObj = Classregistry::init('ServiceBill');	
		$serviceCategoryObj = Classregistry::init('ServiceCategory');
		if(!empty($patientArray['Patient']['patient_id'])){
			$this->updateAll(array('Appointment.is_deleted'=>'1'),array('Appointment.patient_id'=>$patientArray['Patient']['patient_id']));
		}
		//swapping some of the field from appointment form
		$data['Appointment']['person_id'] = $patientArray['Patient']['person_id'];
		$data['Appointment']['patient_id'] = $patientArray['Patient']['patient_id'];
		
		//by pankaj w
		if(!empty($patientArray["Patient"]['location_id'])){
			$data['Appointment']['location_id']  = $patientArray["Patient"]['location_id'] ;
		}else{
			$data['Appointment']['location_id'] = $session->read('locationid');
		}
		foreach($patientArray['Appointment']['doctor_id'] as $appKey=>$appArray){
		$data['Appointment']['department_id'] = $patientArray['Appointment']['department_id'][$appKey];
		$data['Appointment']['doctor_id'] = $appArray;//doctorId
		$data['Appointment']['appointment_with'] = $appArray;//doctorId
		$data['Appointment']['date'] = $patientArray['Patient']['form_received_on'];
		if(trim($patientArray['Patient']['mode_communication'])=='Phone'){
			$data['Appointment']['status'] = 'Closed';
		}else{
			$data['Appointment']['status'] = 'Arrived'; //changed from arrived to pending for multiple appointmnet
		}
		$time = explode(':',date('H:i'));
		if($time[1] <= 15){
			$startTime = date('Y-m-d H').":15";
			$endTime = date('Y-m-d H').":30";
		}elseif($time[1] <= 30 && $time[1] >= 15 ){
			$startTime = date('Y-m-d H').":30";
			$endTime = date('Y-m-d H').":45";
		}elseif($time[1] <= 45 && $time[1] >= 30 ){
			$startTime = date('Y-m-d H').":45";
			$endTime = date('Y-m-d H', strtotime('+1 hour')).":00";
		}else{
			$startTime = date('Y-m-d H', strtotime('+1 hour')).":00";
			$endTime = date('Y-m-d H', strtotime('+1 hour')).":15";
		}
		
		if($patientArray['Person']['start_time']){
			$data['Appointment']['start_time'] =  date("H:i", strtotime($patientArray['Person']['start_time']));
			$data['Appointment']['end_time'] = date("H:i", strtotime($patientArray['Person']['start_time']."+15 minutes"));
			$data['Appointment']['status'] = 'Arrived';
			$data['Appointment']['arrived_time'] = date('H:i');
		}else{
			$data['Appointment']['start_time'] = date('H:i',strtotime($startTime));
			$data['Appointment']['end_time'] = date('H:i',strtotime($endTime));;
			$data['Appointment']['arrived_time'] = date('H:i');
			$data['Appointment']['status'] = 'Arrived';
		}
		$data['Appointment']['is_future_app'] = 0;
		if($patientArray['Patient']['treatment_type'])
			$data['Appointment']['visit_type'] = $patientArray['Appointment']['treatment_type'][$appKey];
		else
			$data['Appointment']['visit_type'] = 6;
		
		
		$data['Appointment']['created_by'] = $session->read('userid');
		$data['Appointment']['create_time'] = date('Y-m-d H:i:s');
		
		//BOF assign token to patient's appointment by pankaj
		$data['Appointment']['app_token'] = $this->tokenNoPerPhysician($appArray)  ;//doctorId
		//EOF token display
		$this->create();
			$Appointment->save($data);
			$Appointment->id='';
			
			//Inserting data in service bill for multiple service
			/*if($patientArray["Person"]['pay_amt']=='1' || $patientArray["Patient"]['pay_amt']=='1'){
				$paidAmount=$patientArray['Appointment']['visit_charge'][$appKey];
				$modified=date('Y-m-d');
				$modifieBy=$session->read('userid');
			}else{
				$paidAmount='0';
				$modified='';
				$modifieBy='';
			}
			$serviceArray['date']=date('Y-m-d H:i:s');
			$serviceArray['location_id']=isset($patientArray["Patient"]['location_id'])?$patientArray["Patient"]['location_id']:$session->read('locationid');
			$serviceArray['tariff_standard_id']=$patientArray['Patient']['tariff_standard_id'];
			$serviceArray['create_time']=date('Y-m-d H:i:s');
			$serviceArray['created_by']=$session->read('userid');
			$serviceArray['patient_id']=$patientArray['Patient']['patient_id'];
			$serviceArray['service_id']=$serviceCategoryObj->getServiceGroupId(Configure::read('mandatoryservices'));
			$serviceArray['tariff_list_id']=$patientArray['Appointment']['treatment_type'][$appKey];
			$serviceArray['no_of_times']=1;
			$serviceArray['paid_amount']=$paidAmount;
			$serviceArray['modified_by']=$modifieBy;
			$serviceArray['modified_time']=$modified;
			$serviceArray['amount']=$patientArray['Appointment']['visit_charge'][$appKey];
			$this->insertServiceAppointment($serviceArray);*/

			// commented by atul ,as we do not save visit charges in hope hospital
		}
		
		
		
		return true;
		
	}
	
	
	/**
	 * Insert services against multiple appointment
	 * @param unknown_type $serviceBill
	 * @return boolean
	 * Pooja gupta
	 */
	
	function insertServiceAppointment($serviceBill){
		$serviceBillingObj = Classregistry::init('ServiceBill');
		
		$serviceBillingObj->saveAll($serviceBill);
		$serviceBillingObj->id='';
		return true;
	}
}
?>