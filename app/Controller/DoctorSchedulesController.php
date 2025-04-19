<?php
/**
 * DoctorSchedulesController file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Hope hospital
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Santosh R. Yadav
 */
class DoctorSchedulesController extends AppController {

	public $name = 'DoctorSchedules';
	public $uses = array('DoctorProfile');
	public $helpers = array('Html','Form', 'Js','General');
	public $components = array('RequestHandler','Email','DateFormat', 'ScheduleTime');

	/**
	 * doctor listing
	 *
	*/
	public function index() {

		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array(
						'DoctorProfile.doctor_name' => 'asc'
				),
				'conditions' => array('DoctorProfile.is_deleted' => 0,'DoctorProfile.location_id'=>$this->Session->read('locationid'))
		);
		$this->set('title_for_layout', __('Doctors Schedule', true));
		$data = $this->paginate('DoctorProfile');
		$this->set('data', $data);
	}

	/**
	 * add doctor schedules
	 *
	 */
	public function doctor_schedule() {
		$this->loadModel("DoctorSchedule");
		$this->set('title_for_layout', __('Add Doctor Schedule', true));
		if ($this->request->is('post')) {
			$checkIsStart = 0;
			$checkIsEnd = 0;
			foreach($this->request->data['schedule'] as $keyindex => $valindex) {
				foreach($valindex as $key => $val) {
					foreach($val as $keyactual => $valactual) {
						if(!empty($this->request->data['schedule'][$keyindex]['startdate'][$keyactual])) {
							$checkIsStart++;
						}
						if(!empty($this->request->data['schedule'][$keyindex]['enddate'][$keyactual])) {
							$checkIsEnd++;
						}
					}
				}
			}

			if($checkIsStart >  0 && $checkIsEnd >0) {
				$this->DoctorSchedule->saveDoctorSchedule($this->request->data);
				$this->Session->setFlash(__('The doctor schedule time has been saved', true, array('class'=>'message')));
				$this->redirect(array("action" => "scheduled_doctor"));
			} else {
				$this->Session->setFlash(__('Please select atleast one time', true, array('class'=>'error')));
				$this->redirect(array("action" => "doctor_schedule", $this->request->data['doctid']));
			}
		}
		if($this->params['isAjax']) {
			$numofdays = cal_days_in_month(CAL_GREGORIAN, $this->params->query['monthidval'], $this->params->query['yearidval']);
			$this->set('numofdays', $numofdays);
			$this->set('monthval', date("M", mktime(0, 0, 0, $this->params->query['monthidval']+1, 0)));
			$this->set('yearval', $this->params->query['yearidval']);
			$this->set('doctid', $this->params->query['doctidval']);
			$this->render('/DoctorSchedules/appointmentform');
			$this->layout = 'ajax';
		}  else {
			$numofdays = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
			$this->set('doctid', $this->request->params['pass'][0]);
			$this->set('numofdays', $numofdays);
			$this->set('monthval', date('M'));
			$this->set('yearval', date('Y'));
		}

	}

	/**
	 * scheduled doctor listing
	 *
	 */

	public function scheduled_doctor() {
		$this->loadModel("DoctorSchedule");
		if($this->Session->read('role') == 'admin') {
			$conditions = array('DoctorProfile.is_deleted' => 0);
		} else {
			$conditions = array('DoctorProfile.is_deleted' => 0, 'DoctorProfile.user_id' => $this->Auth->user('id'));
		}
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array(
						'DoctorSchedule.schedule_date' => 'DESC'
				),
				'conditions' => $conditions
		);
		$this->set('title_for_layout', __('Scheduled Doctor Listing', true));
		$data = $this->paginate('DoctorSchedule');
		$this->set('data', $data);
		// when doctor add its own schedule//
		$doctorid = $this->DoctorProfile->find('first', array('fields' => array('DoctorProfile.id'), 'conditions'=> array('DoctorProfile.user_id' => $this->Auth->user('id'))));
		$this->set('doctid', $doctorid['DoctorProfile']['id']);

	}

	/**
	 * view details of scheduled doctor
	 *
	 */

	public function scheduled_view($id = null) {
		$this->loadModel("DoctorSchedule");
		$this->set('title_for_layout', __('Doctor schedule Detail', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid Doctor Schedule', true, array('class'=>'error')));
			$this->redirect(array("action" => "index"));
		}
		$this->set('doctorschedule', $this->DoctorSchedule->read(null, $id));
	}

	/**
	 * edit doctor schedule
	 *
	 */
	public function scheduled_edit($id = null) {
		$this->loadModel("DoctorSchedule");
		$this->set('title_for_layout', __('Edit Scheduled Doctor Detail', true));

		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid Scheduled Doctor', true));
			$this->redirect(array("action" => "scheduled_doctor"));
		}
		if ($this->request->is('post') && !empty($this->request->data)) {
			if(empty($this->request->data["DoctorSchedule"]['schedule_date']) || empty($this->request->data["DoctorSchedule"]['schedule_time'])) {
				$this->Session->setFlash(__('Please enter schedule date and time', true));
				$this->redirect(array("action" => "scheduled_edit", $this->request->data["DoctorSchedule"]['id']));
			} else {
				$this->DoctorSchedule->id = $this->request->data["DoctorSchedule"]['id'];
				$this->request->data['DoctorSchedule']['schedule_date'] = $this->DateFormat->formatDate2STD($this->request->data["DoctorSchedule"]['schedule_date'],Configure::read('date_format'));
				$this->DoctorSchedule->save($this->request->data);
				$this->Session->setFlash(__('The Doctor schedule has been updated', true));
				$this->redirect(array("action" => "scheduled_doctor"));
			}
		} else {
			$this->request->data = $this->DoctorSchedule->read(null, $id);

		}

	}

	/**
	 * deleted doctor scheduled
	 *
	 */
	public function scheduled_delete($id = null) {
		$this->loadModel("DoctorSchedule");
		$this->set('title_for_layout', __('Delete Scheduled Doctor', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Scheduled Doctor', true));
			$this->redirect(array("action" => "scheduled_doctor"));
		}
		if (!empty($id)) {
			$this->DoctorSchedule->id = $id;
			$this->request->data['DoctorSchedule']['is_deleted'] = 1;
			$this->DoctorSchedule->save($this->request->data);
			$this->Session->setFlash(__('Scheduled Doctor deleted', true));
			$this->redirect(array("action" => "scheduled_doctor"));
		} else {
			$this->Session->setFlash(__('This doctor is associated with other details so you can not be deleted this doctor', true));
			$this->redirect(array("action" => "scheduled_doctor"));
		}
	}


	/**
	 * doctor schedule event for admin type user
	 * @param $showCalendarDay integer
	 * @param $doctorId integer
	 * @param $removeFlag string (just_me / select_all / commaSeperatedString)
	 * @param $inputDate date type
	 *
	 */
	public function doctor_event($showCalendarDay=1,$doctorId=null,$removeFlag=false,$inputDate=null,$checkFrom=null) {
      
		$this->layout = 'advance';
		$this->loadModel('TariffList');
		$this->uses = array('Appointment', 'DoctorProfile', 'Department', 'Patient', 'User', 'DoctorChamber');
		$doctorArray = array();
		if($this->Session->read('website.instance')=='vadodara'){
			$locationCondition = "";// location condition removed
		}else{
			$locationCondition = "Appointment.location_id = ".$this->Session->read('locationid');
		}
		// reschedule or transfer the appointment from one doctor to another //
		if(isset($this->params['named']['aptid'])) {

			$this->Appointment->id =  $this->params['named']['aptid'];
			$this->request->data['Appointment']['id'] = $this->params['named']['aptid'];
			$this->request->data['Appointment']['doctor_id'] = $doctor_userid;
			$this->request->data['Appointment']['appointment_with'] = $this->params['named']['appointment_with'];
			$this->request->data['Appointment']['modify_time'] = date("Y-m-d H:i:s");
			$this->request->data['Appointment']['modified_by'] = $this->Session->read('userid');
			if($this->Appointment->save($this->request->data)) {
				$this->Session->setFlash(__('Appointment has been rescheduled successfully.', true));
			}
		}
		// end reschedule //
		$this->set('title_for_layout', __('Add Schedule', true));
		$this->Appointment->bindModel(array('belongsTo' => array( 'Patient' => array('className'    => 'Patient', 'foreignKey'    => 'patient_id'),
				'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
				'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
				'DoctorProfile' =>array('foreignKey' => false,'conditions'=>array('DoctorProfile.user_id =Appointment.doctor_id' )),
				//'DoctorProfileRequested' =>array('foreignKey' => false,'conditions'=>array('DoctorProfile.user_id =Appointment.doctor_id')),
		)));
		$fieldsRequired = array('Appointment.id','Appointment.person_id','Appointment.patient_id','Appointment.doctor_id','Appointment.nurse_id',
				'Appointment.department_id','Appointment.appointment_with','Appointment.date','Appointment.start_time','Appointment.end_time',
				'Appointment.purpose','Appointment.visit_type','Appointment.is_future_app','Appointment.status','Appointment.seen_status',
				'Appointment.chamber_id','Appointment.is_deleted','Patient.id','Patient.admission_id','Patient.lookup_name','Patient.patient_id','Patient.is_discharge',
				'Patient.is_deleted','Patient.admission_type','Patient.person_id','Patient.admission_id','Patient.doctor_id','Patient.is_paragon',
				'Person.id','Person.dob','Person.patient_uid','Person.alternate_patient_uid','DoctorProfile.id','DoctorProfile.doctor_name',
				'DoctorProfile.first_name','DoctorProfile.last_name','DoctorProfile.middle_name','DoctorProfile.starthours','DoctorProfile.endhours',
				'DoctorProfile.department_id','DoctorProfile.user_id','DoctorProfile.is_active','DoctorProfile.is_deleted','DoctorProfile.future_event_color',
				'DoctorProfile.appointment_visit_color','DoctorProfile.present_event_color','DoctorProfile.past_event_color','DoctorProfile.show_color_from');
		//array_push( ,7);//to be removed
		//if(!empty($doctorId))
		//array_push($doctorArray,$doctorId);

		/*if($removeFlag == 'just_me'){
			unset($doctorArray);
		$doctorArray['0'] = $this->Session->read('userid');
		}else if($removeFlag == 'select_all'){
		unset($doctorArray);
		}else{
		unset($doctorArray);
		$doctorArray = $removeFlag;
		}*/

		if(empty($inputDate) || ($inputDate == 'undefined') || ($inputDate == 'null')){
			$inputDate1 = date("Y-m-d");
			//$inputDate = array(date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("y"))), date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")+ (Configure::read('calendar_days_to_show')), date("y"))));
			$inputDate = array(date("Y-m-d",strtotime('monday last week')),date("Y-m-d",strtotime("sunday next week")));
		}else{
			$inputDate1 = $inputDate;
			$inputDate = array(date("Y-m-d",strtotime('last monday',strtotime(date($inputDate1)))),date("Y-m-d",strtotime('next sunday',strtotime(date($inputDate1)))));
		}

		if($this->Session->read('role') == Configure::read('doctorLabel')) {
			$removeFlag = ($removeFlag) ? $removeFlag : 'just_me'; // first time checking $removeFlag
			$newRemove = ($removeFlag) ? $removeFlag : 'just_me';
		}else{
			$removeFlag = ($removeFlag) ? $removeFlag : 'select_all'; // first time checking $removeFlag
			$newRemove = $removeFlag;
		}
		//($removeFlag) ? $removeFlag : 'just_me';
		if($newRemove == 'just_me'){
			$calledDoctors = "DoctorProfile.user_id=".$this->Session->read('userid');
		}elseif($newRemove == 'select_all' || !$newRemove){
			$calledDoctors = "DoctorProfile.user_id != 0";
		}else{
			$doctorAray =explode(',',$newRemove);
			$calledDoctors = "DoctorProfile.user_id IN ($newRemove)";
		}
		
		$doctorDataList = $this->DoctorProfile->find("list", array('fields'=>array('user_id','doctor_name'),
				'conditions' => array($calledDoctors,'DoctorProfile.is_opd_allow'=> 1,'DoctorProfile.is_active'=> 1,'DoctorProfile.is_deleted'=> 0,
						'DoctorProfile.location_id'=>$this->Session->read('locationid'))));
		$appointmentdoctorList = array_flip($doctorDataList);
		
		if($this->Session->read('role') == Configure::read('doctorLabel')) {
			//$this->set('currentDoctor', '7'); //to be removed
			$removeFlag = (!$removeFlag) ? 'just_me' : $removeFlag; // for showing logged in doc only on first load
			if($removeFlag == 'select_all' || !$removeFlag){
				$allEvent = $this->Appointment->find("all", array('order'=>array('DoctorProfile.id'),'fields'=>$fieldsRequired,
						'conditions' => array('DoctorProfile.is_deleted'=>0,'DoctorProfile.is_opd_allow'=> 1,'DoctorProfile.is_active'=> 1,
								'Appointment.appointment_with'=> $appointmentdoctorList,'Appointment.is_deleted'=> 0,
								 'Appointment.date BETWEEN ? AND ?' => $inputDate,$locationCondition)));
			}else{
				if($removeFlag == 'just_me'){
					$searchDoctor = $this->Session->read('userid');
				}else{
					$searchDoctor = explode(',',$removeFlag);
				}
				$allEvent = $this->Appointment->find("all", array('order'=>array('DoctorProfile.id'),'fields'=>$fieldsRequired,
						'conditions' => array('DoctorProfile.is_deleted'=>0,'DoctorProfile.is_active'=> 1,'Appointment.appointment_with'=> $searchDoctor/* $doctorArray['0']*/,
								'Appointment.is_deleted'=> 0, 'Appointment.date BETWEEN ? AND ?' => $inputDate, $locationCondition)));
			}
		} else {
			if($removeFlag == 'just_me'){
				$allEvent = $this->Appointment->find("all", array('order'=>array('DoctorProfile.id'),'fields'=>$fieldsRequired,
						'conditions' => array('DoctorProfile.is_opd_allow'=> 1,'DoctorProfile.is_deleted'=>0,'DoctorProfile.is_active'=> 1,
								'Appointment.appointment_with'=> $this->Session->read('userid'),'Appointment.is_deleted'=> 0, 
								'Appointment.date BETWEEN ? AND ?' => $inputDate, $locationCondition )));
			}else{
				if($removeFlag == 'select_all' || !$removeFlag){
					$allEvent = $this->Appointment->find("all", array('order'=>array('DoctorProfile.id'),'fields'=>$fieldsRequired,
							'conditions' => array('DoctorProfile.is_opd_allow'=> 1,'DoctorProfile.is_deleted'=>0,'DoctorProfile.is_active'=> 1,
									'Appointment.appointment_with'=> $appointmentdoctorList,'Appointment.is_deleted'=> 0,
									 'Appointment.date BETWEEN ? AND ?' => $inputDate, $locationCondition )));
				}else{
					$searchDoctor = explode(',',$removeFlag);
					$allEvent = $this->Appointment->find("all", array('order'=>array('DoctorProfile.id'),'fields'=>$fieldsRequired,
							'conditions' => array('DoctorProfile.is_opd_allow'=> 1,'DoctorProfile.is_deleted'=>0,'DoctorProfile.is_active'=> 1,
									'Appointment.appointment_with'=> $searchDoctor,'Appointment.is_deleted'=> 0,
									'Appointment.date BETWEEN ? AND ?' => $inputDate, $locationCondition )));
				}
			}
		}

		if(!empty($this->request->params['named']['patientid'])){
			$patientId = $this->request->params['named']['patientid'];
			$this->set('patientAppointmentData', $this->getpatientAppointmentData($patientId));
		}
		$doctorColorList = $this->DoctorProfile->find("list", array('fields'=>array('user_id','present_event_color'),
				'conditions' => array($calledDoctors,'DoctorProfile.is_opd_allow'=> 1,'DoctorProfile.is_deleted'=> 0,'DoctorProfile.is_active'=> 1,
						'DoctorProfile.location_id'=>$this->Session->read('locationid'))));
		
		$this->set('allEvent', $allEvent);
		$this->set('doctorData', $doctorData);
		$this->set('showCalendarDay', $showCalendarDay);
		$this->loadModel('DoctorChamber');
		$doctors = $doctorDataList;
		$this->set('doctors', $doctors);
		$this->set('doctorDataList', $doctorDataList);
		$this->set('doctorColorList', $doctorColorList);
		$this->set('currentDoctor', $this->Session->read('userid'));
		/*if(count($doctorArray[0]) > 0){
			$cond = array('DoctorProfile.is_deleted'=> 0,'DoctorProfile.user_id'=>$doctorArray[0]);
		}else{
		$cond = array('DoctorProfile.is_deleted'=> 0);
		}
		$doctorDataListName = $this->DoctorProfile->find("list", array('fields'=>array('user_id','doctor_name'),'conditions' => $cond));*/
		$nameStr = '';$doctorListArray = array();
		if($removeFlag ) $removeFlag = explode(',',$removeFlag);
		if($removeFlag[0] == 'just_me') $removeFlag[0] = $this->Session->read('userid');
		foreach ($doctorDataList as $key=>$name){
			if(is_array($removeFlag) && ($removeFlag[0] != 'select_all')){
				if(in_array($key,$removeFlag)){
					$nameStr .= "'".$name."',";
					array_push($doctorListArray, $key);
				}
			}else{
				$nameStr .= "'".$name."',";
				array_push($doctorListArray, $key);
			}
		}
		if(count($removeFlag) == 1 && $removeFlag[0] != 'select_all'){
			$doctorCompleteProfile = $this->DoctorProfile->find("first", array('fields'=>array('id','user_id','show_color_from','starthours','endhours','appointment_visit_color'),
					'conditions' => array($calledDoctors,'DoctorProfile.is_opd_allow'=> 1,'DoctorProfile.is_deleted'=> 0,'DoctorProfile.is_active'=> 1,
							'DoctorProfile.location_id'=>$this->Session->read('locationid')),'recursive'=>'-1'));
			$this->set('doctorVisitColor', unserialize($doctorCompleteProfile['DoctorProfile']['appointment_visit_color']));
		}else{
			$doctorCompleteProfile = $this->DoctorProfile->find("all", array('fields'=>array('id','user_id','starthours','endhours','appointment_visit_color'),
					'conditions' => array($calledDoctors,'DoctorProfile.is_opd_allow'=> 1,'DoctorProfile.is_deleted'=> 0,'DoctorProfile.is_active'=> 1,
							'DoctorProfile.location_id'=>$this->Session->read('locationid')),'recursive'=>'-1'));
		}
		$this->data = $doctorCompleteProfile;
		$freeBusys = $this->DoctorChamber->prepareDoctorSchedule($doctorDataList,$inputDate1,$doctorCompleteProfile);
		$this->set('nameStr',$nameStr);
		$this->set('doctorListArray',$doctorListArray);

		array_pop($doctorArray,$this->Session->read('userid'));
		$doctorArray = serialize($doctorArray);
		$this->set('freeBusys',$freeBusys);
		$this->Session->write('doctorCalendarArray',$doctorArray);
		$this->set('removeFlag',$removeFlag);
		
		$visitTypeArray=$this->TariffList->find("list",array('fields'=>array('TariffList.id','TariffList.name'),'conditions'=>array('TariffList.is_deleted'=>'0','TariffList.check_status'=>'1','TariffList.location_id'=>$this->Session->read('locationid'))));
		$this->set('visitTypeArray',$visitTypeArray);
		$this->loadModel('Location');
		$this->set('locations',$this->Location->find('list',array('fields'=>array('name'),'conditions'=>array('Location.is_active'=>1,'Location.is_deleted'=>0))));
		$this->set(array('year'=>date("Y",strtotime($inputDate1)),'month'=>date("m",strtotime($inputDate1)),'day'=>date("d",strtotime($inputDate1))));
		if(($checkFrom=='Calendar') && (!empty($doctorId) || ($doctorId == '0') || ($removeFlag[0] == $this->Session->read('userid')) || ($removeFlag[0] == 'select_all') || ($removeFlag[0] == 'undefined'))){
			$this->layout = 'ajax' ;
			$this->render('doctor_layout_ajax');
		}
	}
	
	public function getLocationDoctor($locationId = null,$calledDoctors = null){
		$this->loadModel('DoctorProfile');
		$this->autoRender = false;
		if($calledDoctors == '') $calledDoctors = "DoctorProfile.user_id != 0";
		if($locationId == 'null') $locationId = $this->Session->read('locationid');
		$doctorDataList = $this->DoctorProfile->find("list", array('fields'=>array('user_id','doctor_name'),
				'conditions' => array($calledDoctors,'DoctorProfile.is_opd_allow'=> 1,'DoctorProfile.is_active'=> 1,'DoctorProfile.is_deleted'=> 0,
						'DoctorProfile.location_id'=>$locationId)));
		return json_encode($doctorDataList);
	}

	private function getpatientAppointmentData($patientId){
		$this->uses = array('Patient');
		$this->Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
				)),false);
		$patientAppointmentData = $this->Patient->find('first', array('fields'=>array('Patient.id','Patient.lookup_name','Patient.admission_id','Patient.location_id',
					'Patient.patient_id','Person.dob'),'conditions' => array('Patient.id' => $patientId)));
		$patientAppointmentData['Person']['dob'] = $this->DateFormat->formatDate2Local($patientAppointmentData['Person']['dob'],Configure::read('date_format'),false);
		return $patientAppointmentData;
	}

	function test(){

	}

	/**
	 * autosearch admission id
	 *
	 */
	public function autoSearchAdmissionId() {
		$this->loadModel("Patient");
		$patientArray = $this->Patient->find('list', array('fields'=> array('id', 'admission_id'), 'conditions'=> array('Patient.is_deleted' => 0, 'Patient.location_id' => $this->Session->read('locationid'), 'Patient.is_discharge' => 0, 'Patient.admission_type' => 'IPD')));
			
		foreach ($patientArray as $key=>$value) {
			echo "$value|$key\n";
		}
		exit; //dont remove this
	}


	/**
	 * doctor schedule event save by xmlhttprequest for admin type user
	 *
	 */
	public function saveDoctorEvent() {
		//$this->layout = 'ajax';
		//debug($this->params);
		$this->loadModel("Appointment");
		$this->loadModel("DoctorProfile");
		$this->loadModel("Patient");
		$this->loadModel("DeleteAppointment");
		if($this->params['isAjax']) {//pr($this->params->query);exit;
			if(!($this->params->query['admissionid'])) {
				//$this->Session->setFlash(__('Please enter admission id', true));
				echo "Please enter MRN";
				exit;
			}
			// check multiple appointment form admission id //
			$this->DeleteAppointment->bindModel(array('belongsTo' => array('Patient' => array( 'className' => 'Patient', 'foreignKey'=> 'patient_id'))));
			$countMultiAdmissionId = $this->DeleteAppointment->find('first', array('conditions' => array('Patient.admission_id' => $this->params->query['admissionid'], 'DeleteAppointment.is_deleted' => 0, 'DeleteAppointment.date'=>$this->params->query['scheduledate'])));

			// delete existing admission id //
			/*if($countMultiAdmissionId['DeleteAppointment']['id']) {
			 $this->DeleteAppointment->id = $countMultiAdmissionId['DeleteAppointment']['id'];
			$this->request->data['DeleteAppointment']['id'] = $countMultiAdmissionId['DeleteAppointment']['id'];
			$this->request->data['DeleteAppointment']['is_deleted'] = 1;
			$this->request->data['DeleteAppointment']['modified_by'] = $this->Auth->user('id');
			$this->request->data['DeleteAppointment']['modify_time '] = date("Y-m-d H:i:s");
			$this->DeleteAppointment->save($this->request->data);
			}*/


			$countAdmissionId = $this->Patient->find('count', array('conditions' => array('Patient.admission_id' => $this->params->query['admissionid'])));
			if($countAdmissionId > 0) {
				$getPatientId = $this->Patient->find('first', array('conditions' => array('Patient.admission_id' => $this->params->query['admissionid']),
						'fields' => array('Patient.id', 'Patient.person_id','is_paragon')));
				$getDoctorData = $this->DoctorProfile->find('first', array('conditions' => array('DoctorProfile.user_id' => $this->params->query['appointment_with']), 'fields' => array('DoctorProfile.user_id', 'DoctorProfile.department_id')));
				if($this->DateFormat->formatDate2STDForReport($this->params->query['scheduledate'],Configure::read('date_format')) >= date("Y-m-d")) {
					// check overlapping time //
					$checkDoctorSchedule = $this->ScheduleTime->checkDoctorSchedule($this->params->query);
					$isAppointmentOverlap = $this->ScheduleTime->CheckOverlapBlockTime($this->params->query);
					if($checkDoctorSchedule['appointment'] == 1 && $checkDoctorSchedule['staffplan'] == 1 && $checkDoctorSchedule['doctoroptappointment'] == 1 && $checkDoctorSchedule['anaesthesiaoptappointment'] == 1 && !$isAppointmentOverlap) {
						// generate token //

						$getTokenAlpha = $this->DoctorProfile->find('first', array('conditions' => array('DoctorProfile.user_id' => $this->params->query['doctor_userid']), 'fields' => array('DoctorProfile.token_alphabet')));
						$countDayApp = $this->Appointment->find('count', array('conditions' => array('Appointment.doctor_id' => $this->params->query['doctor_userid'], 'Appointment.date' => date("Y-m-d"), 'Appointment.is_deleted' => 0)));
						$serialTokenNumber = $getTokenAlpha['DoctorProfile']['token_alphabet'].($countDayApp+1);
						$countDayPat = $this->Appointment->find('count', array('conditions' => array('Appointment.doctor_id' => $this->params->query['doctor_userid'], 'Appointment.date' => date("Y-m-d"), 'Appointment.is_deleted' => 0)));
						$this->request->data['Appointment']['person_id'] = $getPatientId['Patient']['person_id'];
						$this->request->data['Appointment']['patient_id'] = $getPatientId['Patient']['id'];
						$this->request->data['Appointment']['location_id'] = ($this->params->query['location_id'] != 'undefined') ? $this->params->query['location_id'] : $this->Session->read("locationid");
						$this->request->data['Appointment']['doctor_id'] = $this->params->query['appointment_with'];//$getDoctorData['DoctorProfile']['user_id'];
						$this->request->data['Appointment']['department_id'] = $getDoctorData['DoctorProfile']['department_id'];
						$this->request->data['Appointment']['date'] = $this->DateFormat->formatDate2STD($this->params->query['scheduledate'],Configure::read('date_format'));
						$this->request->data['Appointment']['start_time'] = $this->params->query['schedule_starttime'];
						$this->request->data['Appointment']['end_time'] = $this->params->query['schedule_endtime'];
						$this->request->data['Appointment']['purpose'] = addslashes($this->params->query['purpose']);
						$this->request->data['Appointment']['visit_type'] = $this->params->query['visit_type'];
						$this->request->data['Appointment']['appointment_with'] = $this->params->query['appointment_with'];
						$this->request->data['Appointment']['observation_identifier_id'] = $this->params->query['observation_identifier_id'];
						$this->request->data['Appointment']['app_token'] = $serialTokenNumber;
						$this->request->data['Appointment']['created_by'] = $this->Auth->user('id');
						$this->request->data['Appointment']['create_time'] = date("Y-m-d H:i:s");
						if($this->params->query['current_doctor'] != $this->request->data['Appointment']['appointment_with']){
							$this->request->data['Appointment']['scheduled_by_other_doctor'] = '1';
							$this->request->data['Appointment']['calendar_doctor_id'] = $this->params->query['current_doctor'];
							$this->request->data['Appointment']['confirmed_by_doctor'] = 'Awaiting';
						}
						$sameDayPatientApp = $this->Appointment->find('first',array('fields'=>array('Appointment.id','Appointment.is_future_app','Appointment.date'),
								'conditions'=>array('Appointment.person_id'=>$getPatientId['Patient']['person_id'],'Appointment.is_deleted'=>'0'),
								'order'=>array('Appointment.id'=>'DESC')));
						if(!empty($sameDayPatientApp) && strtotime($this->DateFormat->formatDate2STDForReport($this->params->query['scheduledate'],Configure::read('date_format'))) == strtotime($sameDayPatientApp['Appointment']['date'])){
							$this->Appointment->id = null;
							$this->request->data['Appointment']['is_future_app'] = $sameDayPatientApp['Appointment']['is_future_app'];
						}else{
							$this->Appointment->id = null;
							if(empty($sameDayPatientApp))
								$this->request->data['Appointment']['is_future_app'] = 0;
							else
								$this->request->data['Appointment']['is_future_app'] = 1;
								
						}
						// only 30 appointments should be scheduled-Leena
						
						$startDate=$this->DateFormat->formatDate2STD($this->params->query['scheduledate'],Configure::read('date_format'));
						$msgDate=$this->params->query['scheduledate'];
						$doctorId=$this->params->query['appointment_with'];
						$appCount1=$this->Appointment->find('all',array('fields'=>array('COUNT(Appointment.id) as count'),
								'conditions'=>array('DATE_FORMAT(Appointment.date, "%Y-%m-%d") LIKE' => $startDate,'Appointment.doctor_id'=>$doctorId)));
						
						if($appCount1[0][0]['count'] < Configure::read('max_appointments')){
						
						        $this->Appointment->save($this->request->data);	
						}else 
						{
							echo Configure::read('max_appointments'). " appointments for today are already scheduled.";
							//echo "Appointment cannot be scheduled for ".$msgDate;
							exit;
							
						}
						// End 
						$errors = $this->Appointment->invalidFields();
						
						if(!empty($errors)){
							echo $errors['visit_type']['0'];
							exit;
						}else{
							$this->Session->setFlash(__('Appointment saved'),true,array('class'=>'message'));
						}
						/***BOF-Mahalaxmi-For SMS Sending*******/
						$lastAppointmentId=$this->Appointment->getLastInsertID();						
						$getEnableFeatureChk=$this->Session->read('sms_feature_chk');
						if($getEnableFeatureChk=='1'){
							$this->Patient->sendToSmsPatient($this->request->data['Appointment']['person_id'],'FollowUp',$lastAppointmentId);
						}
						/***EOF-Mahalaxmi-For SMS Sending*******/
						echo "save";
						exit;
					} else {
						if($isAppointmentOverlap){
							echo "Physician is not available for this time slot.";
							exit;
						}
						if($checkDoctorSchedule['appointment'] == 2){
							//$this->Session->setFlash(__('Doctor appointment time is overlapping.'), true,array('class'=>'error'));
							echo 'Doctor appointment time is overlapping.';
							exit;
						} elseif($checkDoctorSchedule['staffplan'] == 2) {
							//$this->Session->setFlash(__('Your staff plan is overlapping.'), true,array('class'=>'error'));
							echo 'Your staff plan is overlapping.';
							exit;
						} elseif($checkDoctorSchedule['doctoroptappointment'] == 2) {
							//$this->Session->setFlash(__('Doctor OT appointment is overlapping.'), true,array('class'=>'error'));
							echo 'Doctor OT appointment is overlapping.';
							exit;
						} elseif($checkDoctorSchedule['anaesthesiaoptappointment'] == 2) {
							//$this->Session->setFlash(__('Anaethetist OT appointment is overlapping.'), true,array('class'=>'error'));
							echo 'Anaethetist OT appointment is overlapping.';
							exit;
						} else {
							//$this->Session->setFlash(__('Doctor is set for other apppointment.'), true,array('class'=>'error'));
							echo 'Doctor is set for other apppointment.';
							exit;
						}
							
					}
				} else {
					$this->Session->setFlash(__('You cannot set appointments for a past date'),true,array('class'=>'error'));
					exit;
				}
			} else {
				$this->Session->setFlash(__('Your admission id is wrong so please try again.'),true,array('class'=>'error'));
				exit;
			}


		}
		//exit;
	}

	/**
	 * doctor schedule event for doctor type user
	 *
	 */
	public function schedule_event($showCalendarDay=1) {
		$this->uses = array('Appointment', 'DoctorProfile', 'Department', 'Patient');
		$this->loadModel("Appointment");
		$this->set('title_for_layout', __('Add Schedule', true));
		$this->Appointment->bindModel(array('belongsTo' => array('Patient' => array('className'    => 'Patient', 'foreignKey'    => 'patient_id'),
				'DoctorProfile' => array('className'    => 'DoctorProfile', 'foreignKey'    => false,'conditions'=>array('DoctorProfile.user_id=Appointment.doctor_id'))
		)));
		// if patientid set from patient registration form //
		if($this->request['named']['patientid']) {
			$patientAppointmentData = $this->Patient->find('first', array('conditions' => array('Patient.id' => $this->request['named']['patientid'])));
			$this->set('patientAppointmentData', $patientAppointmentData);
		}
		$allEvent = $this->Appointment->find("all", array('conditions' => array('Appointment.doctor_id'=> $this->Auth->user('id'),'Appointment.is_deleted'=> 0)));
		$doctorData = $this->DoctorProfile->find("first", array('conditions' => array('DoctorProfile.user_id'=> $this->Auth->user('id'),'DoctorProfile.is_deleted'=> 0)));
		$departmentList = $this->Department->find('all', array('conditions' => array('Department.is_active' => 1)));
		$this->set('allEvent', $allEvent);
		$this->set('doctorData', $doctorData);
		$this->set('departmentList', $departmentList);
		$this->set('showCalendarDay', $showCalendarDay);
	}

	/**
	 * doctor schedule event save by xmlhttprequest for doctor type user
	 *
	 */
	public function saveScheduleEvent() {
			
		$this->loadModel("Appointment");
		$this->loadModel("Patient");
		$this->loadModel("DoctorProfile");

		if($this->params['isAjax']) {
			// set userid value in ajax variable//
			$this->params->query['doctor_userid'] = $this->Auth->user('id');
			if(!($this->params->query['admissionid'])) {
				$this->Session->setFlash(__('Please enter admission id', true));
				exit;
			}
			$countAdmissionId = $this->Patient->find('count', array('conditions' => array('Patient.admission_id' => $this->params->query['admissionid'])));
			if($countAdmissionId > 0) {
				$getPatientId = $this->Patient->find('first', array('conditions' => array('Patient.admission_id' => $this->params->query['admissionid']), 'fields' => array('Patient.id', 'Patient.person_id')));
				$getDoctorData = $this->DoctorProfile->find('first', array('conditions' => array('DoctorProfile.user_id' => $this->params->query['appointment_with']), 'fields' => array('DoctorProfile.user_id', 'DoctorProfile.department_id')));
				if(date("Y-m-d", strtotime($this->params->query['scheduledate'])) >= date("Y-m-d")) {
					$checkDoctorSchedule = $this->ScheduleTime->checkDoctorSchedule($this->params->query);
					if($checkDoctorSchedule['appointment'] == 1 && $checkDoctorSchedule['staffplan'] == 1 && $checkDoctorSchedule['doctoroptappointment'] == 1 && $checkDoctorSchedule['anaesthesiaoptappointment'] == 1) {

						// generate token //
						$getTokenAlpha = $this->DoctorProfile->find('first', array('conditions' => array('DoctorProfile.user_id' => $this->params->query['doctor_userid']), 'fields' => array('DoctorProfile.token_alphabet')));
						$countDayApp = $this->Appointment->find('count', array('conditions' => array('Appointment.doctor_id' => $this->params->query['doctor_userid'], 'Appointment.date' => date("Y-m-d"), 'Appointment.is_deleted' => 0)));
						$serialTokenNumber = $getTokenAlpha['DoctorProfile']['token_alphabet'].($countDayApp+1);
						$this->request->data['Appointment']['person_id'] = $getPatientId['Patient']['person_id'];
						//if($this->params->query['listflag']) {
						//set future date flag by pankaj
						if(date("Y-m-d", strtotime($this->params->query['scheduledate'])) > date("Y-m-d")) {
							$this->request->data['Appointment']['is_future_app'] = 1;
						}
						//}
						$this->request->data['Appointment']['patient_id'] = $getPatientId['Patient']['id'];
						$this->request->data['Appointment']['location_id'] = $this->Session->read("locationid");
						$this->request->data['Appointment']['doctor_id'] = $getDoctorData['DoctorProfile']['user_id'];
						$this->request->data['Appointment']['department_id'] = $getDoctorData['DoctorProfile']['department_id'];
						$this->request->data['Appointment']['date'] = $this->params->query['scheduledate'];
						$this->request->data['Appointment']['start_time'] = $this->params->query['schedule_starttime'];
						$this->request->data['Appointment']['end_time'] = $this->params->query['schedule_endtime'];
						$this->request->data['Appointment']['purpose'] = $this->params->query['purpose'];
						$this->request->data['Appointment']['visit_type'] = $this->params->query['visit_type'];
						$this->request->data['Appointment']['app_token'] = $serialTokenNumber;
						$this->request->data['Appointment']['created_by'] = $this->Auth->user('id');
						$this->request->data['Appointment']['create_time'] = date("Y-m-d H:i:s");
							
						$this->Appointment->save($this->request->data);
						$this->Session->setFlash(__('Schedule time has been saved', true));
						exit;
					} else {
						if($checkDoctorSchedule['appointment'] == 2){
							$this->Session->setFlash(__('Doctor appointment time is overlapping.', true));
							exit;
						} elseif($checkDoctorSchedule['staffplan'] == 2) {
							$this->Session->setFlash(__('Your staff plan is overlapping.', true));
							exit;
						} elseif($checkDoctorSchedule['doctoroptappointment'] == 2) {
							$this->Session->setFlash(__('Doctor OT appointment is overlapping.', true));
							exit;
						} elseif($checkDoctorSchedule['anaesthesiaoptappointment'] == 2) {
							$this->Session->setFlash(__('Anaethetist OT appointment is overlapping.', true));
							exit;
						} else {
							$this->Session->setFlash(__('Doctor is set for other apppointment.', true));
							exit;
						}

					}
				} else {
					$this->Session->setFlash(__('You cannot set appointments for a past date', true));
					exit;
				}
			} else {
				$this->Session->setFlash(__('Your admission id is wrong so please try again.', true));
				exit;
			}

		}

	}

	/**
	 *  update doctor schedule event by xmlhttprequest for both admin and doctor type user
	 *
	 */
	public function updateScheduleEvent() {
		$this->uses = array('Appointment', 'Patient', 'DoctorProfile');

		if($this->params['isAjax']) {

			if(!($this->params->query['admissionid'])) {
				$this->Session->setFlash(__('Please enter admission id', true));
				exit;
			}
			//$checkDoctorSchedule = $this->ScheduleTime->checkDoctorSchedule($this->params->query);
			$countAdmissionId = $this->Patient->find('count', array('conditions' => array('Patient.admission_id' => $this->params->query['admissionid'])));
			if($countAdmissionId > 0) {

				$getPatientId = $this->Patient->find('first', array('conditions' => array('Patient.admission_id' => $this->params->query['admissionid']), 'fields' => array('Patient.id', 'Patient.person_id')));
				$getDoctorData = $this->DoctorProfile->find('first', array('conditions' => array('DoctorProfile.user_id' => $this->params->query['appointment_with']), 'fields' => array('DoctorProfile.user_id', 'DoctorProfile.department_id')));
				if($this->DateFormat->formatDate2STDForReport($this->params->query['scheduledate'],Configure::read('date_format')) >= date("Y-m-d")) {
					$checkDoctorSchedule = $this->ScheduleTime->checkDoctorSchedule($this->params->query);
					$isAppointmentOverlap = $this->ScheduleTime->CheckOverlapBlockTime($this->params->query);

					if($checkDoctorSchedule['appointment'] == 1 && $checkDoctorSchedule['staffplan'] == 1 && $checkDoctorSchedule['doctoroptappointment'] == 1 && $checkDoctorSchedule['anaesthesiaoptappointment'] == 1 && !$isAppointmentOverlap) {
						$this->Appointment->id = $this->params->query['id'];
						$this->request->data['Appointment']['id'] = $this->params->query['id'];
						$this->request->data['Appointment']['person_id'] = $getPatientId['Patient']['person_id'];
							
						//if($this->params->query['listflag']) {
						//by pankaj
						if(date("Y-m-d", strtotime($this->params->query['scheduledate'])) > date("Y-m-d")) {
							$this->request->data['Appointment']['is_future_app'] = 1;
						}

						if((strtolower($this->params->query['status']) == 'seen') || (strtolower($this->params->query['status']) == 'closed')){
							$this->Appointment->id = null;
							$this->request->data['Appointment']['is_future_app'] = 1;
						}
						$this->request->data['Appointment']['patient_id'] = $getPatientId['Patient']['id'];
						$this->request->data['Appointment']['location_id'] = ($this->params->query['location_id'] != 'undefined') ? $this->params->query['location_id'] :$this->Session->read("locationid");
						$this->request->data['Appointment']['doctor_id'] = $getDoctorData['DoctorProfile']['user_id'];
						$this->request->data['Appointment']['department_id'] = $getDoctorData['DoctorProfile']['department_id'];
						$this->request->data['Appointment']['date'] = $this->DateFormat->formatDate2STD($this->params->query['scheduledate'],Configure::read('date_format'));
						$this->request->data['Appointment']['start_time'] = $this->params->query['schedule_starttime'];
						$this->request->data['Appointment']['appointment_with'] = $this->params->query['appointment_with'];
						$this->request->data['Appointment']['end_time'] = $this->params->query['schedule_endtime'];
						$this->request->data['Appointment']['purpose'] = addslashes($this->params->query['purpose']);
						$this->request->data['Appointment']['visit_type'] = $this->params->query['visit_type'];
						$this->request->data['Appointment']['status'] = $this->params->query['status'];
						$this->request->data['Appointment']['modified_by'] = $this->Auth->user('id');
						$this->request->data['Appointment']['modify_time'] = date("Y-m-d H:i:s");
						$this->request->data['Appointment']['confirmed_by_doctor'] = $this->params->query['confirmed_by_doctor'];
						
						//  print_r($this->request->data['Appointment']);exit;
						$result = $this->Appointment->save($this->request->data);
						$errors = $this->Appointment->invalidFields();
						if($errors){
							echo $errors['visit_type']['0'];
							exit;
						}
						if($result) {
							if($this->request->data['Appointment']['confirmed_by_doctor'] == 1){
								$this->Session->setFlash(__('Appointment is confirmed.', true));
							}else{
								$this->Session->setFlash(__('Appointment updated.', true));
							}
							echo 'save';
							exit;
						} else {
							$this->Session->setFlash(__('Schedule time has not been updated.', true));
						}
						exit;
					} else {
						if($isAppointmentOverlap){
							echo "Physician is not available for this time slot.";
							exit;
						}
						if($checkDoctorSchedule['appointment'] == 2){
							//$this->Session->setFlash(__('Doctor appointment time is overlapping.', true));
							echo "Doctor appointment time is overlapping.";
							exit;
						} elseif($checkDoctorSchedule['staffplan'] == 2) {
							$this->Session->setFlash(__('Your staff plan is overlapping.', true));
							exit;
						} elseif($checkDoctorSchedule['doctoroptappointment'] == 2) {
							$this->Session->setFlash(__('Doctor OT appointment is overlapping.', true));
							exit;
						} elseif($checkDoctorSchedule['anaesthesiaoptappointment'] == 2) {
							$this->Session->setFlash(__('Anaethetist OT appointment is overlapping.', true));
							exit;
						} else {
							$this->Session->setFlash(__('Doctor is set for other apppointment.', true));
							exit;
						}
					}
				} else {
					//$this->Session->setFlash(__('You cannot set appointments for a past date', true));
					echo 'You cannot set appointments for a past date';
					exit;
				}
			} else {
				$this->Session->setFlash(__('Your admission id is wrong so please try again.', true));
				exit;
			}

		}

	}

	/**
	 * delete doctor schedule event by xmlhttprequest for both admin and doctor type user
	 *
	 */
	public function deleteScheduleEvent() {
		$this->loadModel("Appointment");
		if($this->params['isAjax']) {
			$this->Appointment->id = $this->params->query['id'];
			$this->request->data['Appointment']['id'] = $this->params->query['id'];
			$this->request->data['Appointment']['is_deleted'] = 1;
			$this->request->data['Appointment']['modified_by'] = $this->Auth->user('id');
			$this->request->data['Appointment']['modify_time '] = date("Y-m-d H:i:s");
			$this->Appointment->save($this->data);
			$this->Session->setFlash(__('Appointment deleted', true));
			exit;
		}

	}

	/**
	 * get patient name by xmlhttprequest
	 *
	 */
	public function ajaxGetPatientName() {
		if($this->params['isAjax']) {
			$this->loadModel("Patient");
			$getPatientName = $this->Patient->find('first', array('fields'=> array('lookup_name'), 'conditions'=> array('Patient.is_deleted' => 0, 'Patient.location_id' => $this->Session->read('locationid'), 'Patient.admission_id' => $this->params->query['paid'])));
			echo $getPatientName['Patient']['lookup_name'];
			exit;
			//$this->set('getPatientName', $getPatientName);
			//$this->layout = false;
			// $this->render('/DoctorSchedules/ajax_get_patient_name');
		}

	}

	/**
	 * view all doctor schedule event for admin type user
	 *
	 */
	public function view_alldoctor_event($doctor_userid=null, $showCalendarDay=1) {
		$this->uses = array('Appointment', 'DoctorProfile', 'Department', 'Patient', 'User', 'DoctorChamber');

		//cond for doctor user
		$role = $this->Session->read('role');
		if(strtolower($role) == strtolower(Configure::read("doctorLabel"))){
			$this->redirect(array('controller'=>'doctorSchedules','action'=>'schedule_event')) ;
		}
		//EOD cond added by pankaj
		if(isset($this->request->data['doctor_userid'])) {
			$doctor_userid = $this->request->data['doctor_userid'];
		}
		$this->DoctorProfile->virtualFields = array(
				'doctor_name' => 'CONCAT(Initial.name, " ", DoctorProfile.doctor_name)'
		);
		$this->set('title_for_layout', __('Add Schedule', true));
		$this->Appointment->bindModel(array('belongsTo' => array('Patient' => array('className'    => 'Patient', 'foreignKey'    => 'patient_id'),
				'DoctorProfile' => array('className'    => 'DoctorProfile', 'foreignKey'    => false,'conditions'=>array('DoctorProfile.user_id=Appointment.doctor_id'))
		)));
		//  print($doctor_userid);exit;
		$dept_id = $this->params->query['dept_id'] ;
		if(!empty($doctor_userid) && $doctor_userid != "all") {
			if(!empty($this->params->query['dept_id'])){
				$doctorData = $this->DoctorProfile->find("first", array('conditions' => array('DoctorProfile.department_id'=>$dept_id,'DoctorProfile.user_id'=> $doctor_userid,'DoctorProfile.is_deleted'=> 0)));
				$this->DoctorProfile->virtualFields = false;
				$allEvent = $this->Appointment->find("all", array('conditions' => array('Appointment.doctor_id'=> $doctor_userid,'Appointment.is_deleted'=> 0, 'Appointment.date BETWEEN ? AND ?' => array(date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")-50, date("y"))), date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")+50, date("y")))))));
				$doctorAvailability = $this->DoctorChamber->find('all', array('conditions' => array('DoctorChamber.doctor_id' => $doctor_userid, 'DoctorChamber.starttime >=' => date('Y-m-d'), 'DoctorChamber.endtime <=' => date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")+6, date("Y"))))));

			}else{
				$doctorData = $this->DoctorProfile->find("first", array('conditions' => array('DoctorProfile.user_id'=> $doctor_userid,'DoctorProfile.is_deleted'=> 0)));
				$this->DoctorProfile->virtualFields = false;
				$allEvent = $this->Appointment->find("all", array('conditions' => array('Appointment.doctor_id'=> $doctor_userid,'Appointment.is_deleted'=> 0, 'Appointment.date BETWEEN ? AND ?' => array(date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")-50, date("y"))), date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")+50, date("y")))))));
				$doctorAvailability = $this->DoctorChamber->find('all', array('conditions' => array('DoctorChamber.doctor_id' => $doctor_userid, 'DoctorChamber.starttime >=' => date('Y-m-d'), 'DoctorChamber.endtime <=' => date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")+6, date("Y"))))));
			}
		} else {
			//BOF pankaj
			if(!empty($this->params->query['dept_id'])){
				$doctorData = $this->DoctorProfile->find("first", array('conditions' => array('DoctorProfile.department_id'=>$dept_id,'User.is_deleted'=> 0, 'DoctorProfile.is_deleted'=> 0,'DoctorProfile.is_registrar'=> 0, 'DoctorProfile.location_id'=> $this->Session->read('locationid')), 'order' => array('DoctorProfile.doctor_name DESC'), 'recursive' => 1));
				$this->DoctorProfile->virtualFields = false;
				$allEvent = $this->Appointment->find("all", array('conditions' => array('Appointment.doctor_id'=> $doctorData['DoctorProfile']['user_id'],'Appointment.is_deleted'=> 0, 'Appointment.date BETWEEN ? AND ?' => array(date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")-50, date("y"))), date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")+50, date("y")))))));
				$doctorAvailability = $this->DoctorChamber->find('all', array('conditions' => array('DoctorChamber.doctor_id' => $doctor_userid, 'DoctorChamber.starttime >=' => date('Y-m-d'), 'DoctorChamber.endtime <=' => date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")+6, date("Y"))))));
			}else{//EOF pankaj
				$doctorData = $this->DoctorProfile->find("first", array('conditions' => array('DoctorProfile.user_id'=> $doctor_userid, 'User.is_deleted'=> 0, 'DoctorProfile.is_deleted'=> 0,'DoctorProfile.is_registrar'=> 0, 'DoctorProfile.location_id'=> $this->Session->read('locationid')), 'order' => array('DoctorProfile.doctor_name DESC')));
				$this->DoctorProfile->virtualFields = false;
				$allEvent = $this->Appointment->find("all", array('conditions' => array('Appointment.is_deleted'=> 0, 'Appointment.date BETWEEN ? AND ?' => array(date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")-50, date("y"))), date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")+50, date("y")))))));
				$dept_id='';
				$doctorAvailability = $this->DoctorChamber->find('all', array('conditions' => array('DoctorChamber.doctor_id' => $doctor_userid, 'DoctorChamber.starttime >=' => date('Y-m-d'), 'DoctorChamber.endtime <=' => date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")+6, date("Y"))))));
			}
		}
		$departmentList = $this->Department->find('all', array('conditions' => array('Department.is_active' => 1)));
		$this->set('allEvent', $allEvent);
		$this->set('doctorData', $doctorData);
		$this->set('departmentList', $departmentList);
		$this->set('showCalendarDay', $showCalendarDay);
		//get all departments by location ID
		$this->set('departments',$this->Department->getDepartmentByLocationID($this->Session->read('locationid')));
		$this->set('doctors',$this->DoctorProfile->getDoctors($dept_id));
		$this->set('doctorAvailability',$doctorAvailability);

	}

	/**
	 * get diagnosis name by xmlhttprequest
	 *
	 */
	public function ajaxGetDiagnosisName() {
		if($this->params['isAjax']) {
			$this->loadModel("Patient");
			$this->layout = false;
			$this->Patient->unbindModel(array('hasMany' => array('PharmacySalesBill', 'InventoryPharmacySalesReturn')));
			$this->Patient->bindModel(array('hasOne'=>array('Diagnosis'=>array('foreignKey'=>'patient_id'))));
			$getDiagnosisName = $this->Patient->find('first', array('conditions'=> array('Patient.is_deleted' => 0, 'Patient.location_id' => $this->Session->read('locationid'), 'Patient.admission_id' => $this->params->query['paid'])));
			echo $getDiagnosisName['Diagnosis']['final_diagnosis'];
			//print_r($getDiagnosisName['Diagnosis']);
			exit;
		}

	}

	/**
	 * autosearch patient name
	 *
	 */
	public function autoSearchPatientName() {
		$this->loadModel("Patient");
		$patientArray = $this->Patient->find('all', array('fields'=> array('id', 'admission_id', 'lookup_name'), 'conditions'=> array('Patient.is_deleted' => 0, 'Patient.location_id' => $this->Session->read('locationid'), 'Patient.is_discharge' => 0, 'Patient.admission_type' => 'IPD')));
		$this->layout = false;
		foreach ($patientArray as $patientArrayVal) {
			echo "{$patientArrayVal['Patient']['lookup_name']} ({$patientArrayVal['Patient']['admission_id']})\n";
		}
		exit; //dont remove this
	}


	/**
	 * doctor appointment (not in used)
	 *
	 */
	public function doctor_appointment() {

	}

	/**
	 * edit ot appointment event (not in used)
	 *
	 */
	public function doctor_appointment_edit() {
		$this->uses = array('StaffPlan','User');
			
		// get opt details //
		$getUserList = $this->User->find('list', array('conditions' => array('User.location_id' => $this->Session->read('locationid'), 'User.is_deleted' => 0, 'User.is_active' => 1), 'fields' => array('User.id', 'User.full_name')));
			
		$getStaffPlan =  $this->StaffPlan->find('first', array('conditions' => array('StaffPlan.id' => $_GET["id"])));
			
		$sarr1 = explode(" ", $this->php2JsTime($this->mySql2PhpTime($getStaffPlan['StaffPlan']['starttime'])));
		$earr1 = explode(" ", $this->php2JsTime($this->mySql2PhpTime($getStaffPlan['StaffPlan']['endtime'])));
		$this->set('sarr1', $sarr1);
		$this->set('earr1', $earr1);
		$this->set('getStaffPlan', $getStaffPlan);
		$this->set('getUserList', $getUserList);
		$this->layout = false;
	}
	/**
	 * internal url for calender event (not in used)
	 *
	 */
	public function datafeed() {
		header('Content-type:text/javascript;charset=UTF-8');
		$method = $_GET["method"];
		switch ($method) {
			case "add":
				$ret = $this->addCalendar($_POST["CalendarStartTime"], $_POST["CalendarEndTime"], $_POST["CalendarTitle"], $_POST["IsAllDayEvent"]);
				break;
			case "list":
				$ret = $this->listCalendar($_POST["showdate"], $_POST["viewtype"]);
				break;
			case "update":
				$ret = $this->updateCalendar($_POST["calendarId"], $_POST["CalendarStartTime"], $_POST["CalendarEndTime"]);
				break;
			case "remove":
				$ret = $this->removeCalendar( $_POST["calendarId"]);
				break;
			case "adddetails":
				$st = $_POST["stpartdate"] . " " . $_POST["stparttime"];
				$et = $_POST["etpartdate"] . " " . $_POST["etparttime"];
				if(isset($_GET["id"])){
					$ret = $this->updateDetailedCalendar($_GET["id"], $st, $et,
							$_POST["subject"], isset($_POST["is_all_day_event"])?1:0, $_POST["purpose"],
							$_POST["colorvalue"], $_POST["timezone"], $_POST);
				}else{
					$ret = $this->addDetailedCalendar($st, $et,
							$_POST["subject"], isset($_POST["is_all_day_event"])?1:0, $_POST["purpose"],
							$_POST["colorvalue"], $_POST["timezone"],$_POST);
		  }
		  break;
		}
		echo json_encode($ret);   exit;
			
	}

	/**
	 * add new event calendar (not in used)
	 *
	 */
	public function addCalendar($st, $et, $sub, $ade){
		$this->loadModel('StaffPlan');
		$ret = array();
		try{
			$scheduleDateStart = explode(" ", $this->php2MySqlTime($this->js2PhpTime($st)));
			$scheduleDateEnd = explode(" ", $this->php2MySqlTime($this->js2PhpTime($et)));
			$this->request->data['StaffPlan']['location_id'] = $this->Session->read('locationid');
			$this->request->data['StaffPlan']['schedule_date'] = $scheduleDateStart[0];
			$this->request->data['StaffPlan']['start_time'] = $scheduleDateStart[1];
			$this->request->data['StaffPlan']['end_time'] = $scheduleDateEnd[1];
			$this->request->data['StaffPlan']['created_by'] = $this->Session->read('userid');
			$this->request->data['StaffPlan']['create_time'] = date('Y-m-d H:i:s');
			$this->request->data['StaffPlan']['subject'] = $sub;
			$this->request->data['StaffPlan']['starttime'] = $this->php2MySqlTime($this->js2PhpTime($st));
			$this->request->data['StaffPlan']['endtime'] = $this->php2MySqlTime($this->js2PhpTime($et));
			$this->request->data['StaffPlan']['is_all_day_event'] = $ade;
			$checkSave = $this->StaffPlan->save($this->request->data);
			if(!$checkSave){
				$ret['IsSuccess'] = false;
				$ret['Msg'] = "Unable to add this plan";
			}else{
				$ret['IsSuccess'] = true;
				$ret['Msg'] = 'add success';
				$ret['Data'] = $this->StaffPlan->getLastInsertID();
			}
		}catch(Exception $e){
			$ret['IsSuccess'] = false;
			$ret['Msg'] = $e->getMessage();
		}
		return $ret;
	}

	/**
	 * add new event with details (not in used)
	 *
	 */
	public function addDetailedCalendar($st, $et, $sub, $ade, $dscr, $color, $tz, $allvar){
		$this->uses = array('StaffPlan');
		$ret = array();
	 try{
	 	if($this->js2PhpTime($st) > $this->js2PhpTime($et)) {
	 		$ret['IsSuccess'] = false;
	 		$ret['Msg'] = "Start Date & Time Should Not Be Greater Than End Date & Time";
	 	} else {
	 		// check overlap time //
	 		$checkOverlapTime = $this->ScheduleTime->checkOverlapForStaffPlan("", $this->php2MySqlTime($this->js2PhpTime($st)), $this->php2MySqlTime($this->js2PhpTime($et)), $allvar);
	 		if($checkOverlapTime['leaveoverlap'] == 2 || $checkOverlapTime['appointmentoverlap'] == 2) {
	 			if($checkOverlapTime['leaveoverlap'] == 2) {
	 				$ret['IsSuccess'] = false;
	 				$ret['Msg'] = "Your leave plan is overlap with other leave plan.";
	 			}
	 			if($checkOverlapTime['appointmentoverlap'] == 2) {
	 				$ret['IsSuccess'] = false;
	 				$ret['Msg'] = "Your appointment is set for this plan";
	 			}
	 		} else {
	 			$scheduleDateStart = explode(" ", $this->php2MySqlTime($this->js2PhpTime($st)));
	 			$scheduleDateEnd = explode(" ", $this->php2MySqlTime($this->js2PhpTime($et)));
	 			$this->request->data['StaffPlan']['user_id'] = $allvar['user_id'];
	 			$this->request->data['StaffPlan']['purpose'] = $dscr;
	 			$this->request->data['StaffPlan']['location_id'] = $this->Session->read('locationid');
	 			$this->request->data['StaffPlan']['subject'] = $sub;
	 			$this->request->data['StaffPlan']['schedule_date'] = $scheduleDateStart[0];
	 			$this->request->data['StaffPlan']['start_time'] = $scheduleDateStart[1];
	 			$this->request->data['StaffPlan']['end_time'] = $scheduleDateEnd[1];
	 			$this->request->data['StaffPlan']['starttime'] = $this->php2MySqlTime($this->js2PhpTime($st));
	 			$this->request->data['StaffPlan']['endtime'] = $this->php2MySqlTime($this->js2PhpTime($et));
	 			$this->request->data['StaffPlan']['is_all_day_event'] = $ade;
	 			$this->request->data['StaffPlan']['color'] = $color;
	 			$this->request->data['StaffPlan']['created_by'] = $this->Session->read('userid');
	 			$this->request->data['StaffPlan']['create_time'] = date('Y-m-d H:i:s');

	 			$checkSave = $this->StaffPlan->save($this->request->data);
	 			if(!$checkSave){
	 				$ret['IsSuccess'] = false;
	 				$ret['Msg'] = "Unable to addd this plan";
	 			}else{
	 				$ret['IsSuccess'] = true;
	 				$ret['Msg'] = 'add success';
	 				$ret['Data'] = $this->StaffPlan->getLastInsertID();
	 			}
	 		}
	 	}
	 }catch(Exception $e){
	 	$ret['IsSuccess'] = false;
	 	$ret['Msg'] = $e->getMessage();
	 }
	  
	 return $ret;
	}

	/**
	 * list event calendar by range.(not in used)
	 *
	 */
	public function listCalendarByRange($sd, $ed){
		$this->loadModel('StaffPlan');
		$ret = array();
		$ret['events'] = array();
		$ret["issort"] =true;
		$ret["start"] = $this->php2JsTime($sd);
		$ret["end"] = $this->php2JsTime($ed);
		$ret['error'] = null;
		$sd = $this->php2MySqlTime($sd);
		$ed = $this->php2MySqlTime($ed);
		try{

			$getList = $this->StaffPlan->find('all', array('conditions' => array('StaffPlan.starttime BETWEEN ? and ?' => array($sd, $ed),'StaffPlan.location_id' => $this->Session->read('locationid'), 'StaffPlan.is_deleted' => 0)));

			foreach($getList as $getListVal) {
				$realstartDate = $getListVal['StaffPlan']['starttime'];
				$realendate = $getListVal['StaffPlan']['endtime'];
				$startDate = strtotime(date("Y-m-d",strtotime($getListVal['StaffPlan']['starttime'])));
				$endDate = strtotime(date("Y-m-d",strtotime($getListVal['StaffPlan']['endtime'])));
				$datediff = $endDate - $startDate;
				$totaldaysDiff = floor(abs($endDate - $startDate) / 86400);
				//echo $totaldaysDiff;
				$moreThanDay=0;
				if($totaldaysDiff>0){
					$moreThanDay = 1;
				}
				$ret['events'][] = array(
						$getListVal['StaffPlan']['id'],
						$getListVal['StaffPlan']['subject'],
						$this->php2JsTime($this->mySql2PhpTime($realstartDate)),
						$this->php2JsTime($this->mySql2PhpTime($realendate)),
						$getListVal['StaffPlan']['IsAllDayEvent'],
						$moreThanDay, //more than one day event
						//$row->InstanceType,
						0,//Recurring event,
						$getListVal['StaffPlan']['color'],
						1,//editable
						date("m/d/Y H:i",strtotime($realstartDate)),
						date("m/d/Y H:i",strtotime($realendate))
				);
			}
		}catch(Exception $e){
			$ret['error'] = $e->getMessage();
		}
		return $ret;
	}

	/**
	 * list event calendar.(not in used)
	 *
	 */
	public function listCalendar($day, $type){
		$phpTime = $this->js2PhpTime($day);
		//echo $phpTime . "+" . $type;
		switch($type){
			case "month":
				$st = mktime(0, 0, 0, date("m", $phpTime), 1, date("Y", $phpTime));
				$et = mktime(0, 0, -1, date("m", $phpTime)+1, 1, date("Y", $phpTime));
				break;
			case "week":
				//suppose first day of a week is monday
				$monday  =  date("d", $phpTime) - date('N', $phpTime) + 1;
				//echo date('N', $phpTime);
				$st = mktime(0,0,0,date("m", $phpTime), $monday, date("Y", $phpTime));
				$et = mktime(0,0,-1,date("m", $phpTime), $monday+7, date("Y", $phpTime));
				break;
			case "day":
				$st = mktime(0, 0, 0, date("m", $phpTime), date("d", $phpTime), date("Y", $phpTime));
				$et = mktime(0, 0, -1, date("m", $phpTime), date("d", $phpTime)+1, date("Y", $phpTime));
				break;
		}
		//echo $st . "--" . $et;
		return $this->listCalendarByRange($st, $et);
	}

	/**
	 * update event calendar.(not in used)
	 *
	 */
	public function updateCalendar($id, $st, $et){
		$this->loadModel('StaffPlan');
		$ret = array();
		try{
			if($this->js2PhpTime($st) > $this->js2PhpTime($et)) {
				$ret['IsSuccess'] = false;
				$ret['Msg'] = "Start Date & Time Should Not Be Greater Than End Time";
			} else {
				// check overlap time //
				$checkOverlapTime = $this->ScheduleTime->checkOverlapForStaffPlan($id, $this->php2MySqlTime($this->js2PhpTime($st)), $this->php2MySqlTime($this->js2PhpTime($et)), $allvar);
				if($checkOverlapTime['leaveoverlap'] == 2 || $checkOverlapTime['appointmentoverlap'] == 2) {
					if($checkOverlapTime['leaveoverlap'] == 2) {
						$ret['IsSuccess'] = false;
						$ret['Msg'] = "Your leave plan is overlap with other leave plan.";
					}
					if($checkOverlapTime['appointmentoverlap'] == 2) {
						$ret['IsSuccess'] = false;
						$ret['Msg'] = "Your appointment is set for this plan";
					}
				} else {
					$this->StaffPlan->id = $id;
					$scheduleDateStart = explode(" ", $this->php2MySqlTime($this->js2PhpTime($st)));
					$scheduleDateEnd = explode(" ", $this->php2MySqlTime($this->js2PhpTime($et)));
					$this->request->data['StaffPlan']['location_id'] = $this->Session->read('locationid');
					$this->request->data['StaffPlan']['schedule_date'] = $scheduleDateStart[0];
					$this->request->data['StaffPlan']['start_time'] = $scheduleDateStart[1];
					$this->request->data['StaffPlan']['end_time'] = $scheduleDateEnd[1];
					$this->request->data['StaffPlan']['modified_by'] = $this->Session->read('userid');
					$this->request->data['StaffPlan']['modify_time'] = date('Y-m-d H:i:s');
					$this->request->data['StaffPlan']['starttime'] = $this->php2MySqlTime($this->js2PhpTime($st));
					$this->request->data['StaffPlan']['endtime'] = $this->php2MySqlTime($this->js2PhpTime($et));
					$checkSave = $this->StaffPlan->save($this->request->data);

					if(!$checkSave){
						$ret['IsSuccess'] = false;
						$ret['Msg'] = "Unable to update this plan";
					}else{
						$ret['IsSuccess'] = true;
						$ret['Msg'] = 'Update success';
					}
				}
			}
		}catch(Exception $e){
			$ret['IsSuccess'] = false;
			$ret['Msg'] = $e->getMessage();
		}
		return $ret;
	}

	/**
	 * update detailed event calendar.(not in used)
	 *
	 */
	public function updateDetailedCalendar($id, $st, $et, $sub, $ade, $dscr, $color, $tz,$allvar){
		$this->uses = array('StaffPlan','User');
		$ret = array();
		try{
			$scheduleDateStart = explode(" ", $this->php2MySqlTime($this->js2PhpTime($st)));
			$scheduleDateEnd = explode(" ", $this->php2MySqlTime($this->js2PhpTime($et)));
			$this->StaffPlan->id = $id;
			$this->request->data['StaffPlan']['user_id'] = $allvar['user_id'];
			$this->request->data['StaffPlan']['purpose'] = $dscr;
			$this->request->data['StaffPlan']['location_id'] = $this->Session->read('locationid');
			$this->request->data['StaffPlan']['subject'] = $sub;
			$this->request->data['StaffPlan']['schedule_date'] = $scheduleDateStart[0];
			$this->request->data['StaffPlan']['start_time'] = $scheduleDateStart[1];
			$this->request->data['StaffPlan']['end_time'] = $scheduleDateEnd[1];
			$this->request->data['StaffPlan']['starttime'] = $this->php2MySqlTime($this->js2PhpTime($st));
			$this->request->data['StaffPlan']['endtime'] = $this->php2MySqlTime($this->js2PhpTime($et));
			$this->request->data['StaffPlan']['is_all_day_event'] = $ade;
			$this->request->data['StaffPlan']['color'] = $color;
			$this->request->data['StaffPlan']['modified_by'] = $this->Session->read('userid');
			$this->request->data['StaffPlan']['modify_time'] = date('Y-m-d H:i:s');
			$checkSave = $this->StaffPlan->save($this->request->data);
			if(!$checkSave){
				$ret['IsSuccess'] = false;
				$ret['Msg'] = "Unable to update this plan";
			}else{
				$ret['IsSuccess'] = true;
				$ret['Msg'] = 'update success';
				$ret['Data'] = $this->StaffPlan->getLastInsertID();
			}
		}catch(Exception $e){
			$ret['IsSuccess'] = false;
			$ret['Msg'] = $e->getMessage();
		}
		return $ret;
	}


	/**
	 * remove event calendar.(not in used)
	 *
	 */
	public function removeCalendar($id){
		$this->loadModel('StaffPlan');
		$ret = array();
		try{
			$this->request->data['StaffPlan']['id'] = $id;
			$this->request->data['StaffPlan']['is_deleted'] = 1;
			$checkSave = $this->StaffPlan->save($this->request->data);
			if(!$checkSave){
				$ret['IsSuccess'] = false;
				$ret['Msg'] = "Unable to delete this plan";
			}else{
				$ret['IsSuccess'] = true;
				$ret['Msg'] = 'Succefully';
			}
		}catch(Exception $e){
			$ret['IsSuccess'] = false;
			$ret['Msg'] = $e->getMessage();
		}
		return $ret;
	}

	/**
	 * internal url for for converting js to php time (not in used)
	 *
	 */
	public function js2PhpTime($jsdate){
		if(preg_match('@(\d+)/(\d+)/(\d+)\s+(\d+):(\d+)@', $jsdate, $matches)==1){
			$ret = mktime($matches[4], $matches[5], 0, $matches[1], $matches[2], $matches[3]);
			//echo $matches[4] ."-". $matches[5] ."-". 0  ."-". $matches[1] ."-". $matches[2] ."-". $matches[3];
		}else if(preg_match('@(\d+)/(\d+)/(\d+)@', $jsdate, $matches)==1){
			$ret = mktime(0, 0, 0, $matches[1], $matches[2], $matches[3]);
			//echo 0 ."-". 0 ."-". 0 ."-". $matches[1] ."-". $matches[2] ."-". $matches[3];
		}
		return $ret;
	}

	/**
	 * internal url for for converting php to js time (not in used)
	 *
	 */
	public function php2JsTime($phpDate){
		//echo $phpDate;
		//return "/Date(" . $phpDate*1000 . ")/";
		return date("m/d/Y H:i", $phpDate);
	}

	/**
	 * internal url for for converting php to mysql time  (not in used)
	 *
	 */
	public function php2MySqlTime($phpDate){
		return date("Y-m-d H:i:s", $phpDate);
	}

	/**
	 * internal url for for converting php to mysql time (not in used)
	 *
	 */
	public function mySql2PhpTime($sqlDate){
		$arr = date_parse($sqlDate);
		return mktime($arr["hour"],$arr["minute"],$arr["second"],$arr["month"],$arr["day"],$arr["year"]);
	}

	/**
	 * patient appointment portal
	 *
	 */
	public function patient_appointment_event($patientid=null, $showCalendarDay=1) {
		$this->uses = array('Appointment', 'DoctorProfile', 'User','ObservationIdentifier','PhvsVisit');
		$this->set('title_for_layout', __('Add Schedule', true));
		$this->Appointment->bindModel(array('belongsTo' => array( 'DoctorProfile' =>array('foreignKey' => false,'conditions'=>array('DoctorProfile.user_id=Appointment.doctor_id' )),

		)));

		$allEvent = $this->Appointment->find("all", array('conditions' => array('Appointment.patient_id'=> $patientid,'Appointment.is_deleted'=> 0, 'Appointment.date BETWEEN ? AND ?' => array(date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")-50, date("y"))), date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")+50, date("y")))))));
		$phvsvisit = $this->PhvsVisit->find('list', array('fields'=>array('description')));
		$obsidenti = $this->ObservationIdentifier->find('list', array('fields'=>array('description')));
		$this->set(compact('obsidenti','phvsvisit'));
		$this->set('allEvent', $allEvent);
		$this->set('showCalendarDay', $showCalendarDay);
		$getAllDoctorList = $this->User->getDoctorList($this->Session->read('locationid'));
		$this->set('doctors',$this->DoctorProfile->find('list', array('conditions' => array('DoctorProfile.user_id' => $getAllDoctorList), 'fields' => array('DoctorProfile.user_id', 'DoctorProfile.doctor_name'))));
	}

	/**
	 * future appointment
	 *
	 */
	public function future_event($showCalendarDay=1) {
		$this->uses = array('Appointment', 'DoctorProfile', 'Department', 'Patient');
		$this->loadModel("Appointment");
		$this->set('title_for_layout', __('Add Schedule', true));
		$this->Appointment->bindModel(array('belongsTo' => array('Patient' => array('className'    => 'Patient', 'foreignKey'    => 'patient_id'),
				'DoctorProfile' => array('className'    => 'DoctorProfile', 'foreignKey'    => false,'conditions'=>array('DoctorProfile.user_id=Appointment.doctor_id'))
		)));
		// if patientid set from patient registration form //
		if($this->request['named']['patientid']) {
			$patientAppointmentData = $this->Patient->find('first', array('conditions' => array('Patient.id' => $this->request['named']['patientid'])));
			$this->set('patientAppointmentData', $patientAppointmentData);
		}
		$allEvent = $this->Appointment->find("all", array('conditions' => array('Appointment.doctor_id'=> $this->Auth->user('id'),'Appointment.is_deleted'=> 0)));
		$doctorData = $this->DoctorProfile->find("first", array('conditions' => array('DoctorProfile.user_id'=> $this->Auth->user('id'),'DoctorProfile.is_deleted'=> 0)));
		$departmentList = $this->Department->find('all', array('conditions' => array('Department.is_active' => 1)));
		$this->set('allEvent', $allEvent);
		$this->set('doctorData', $doctorData);
		$this->set('departmentList', $departmentList);
		$this->set('showCalendarDay', $showCalendarDay);
	}

	/**
	 * doctor future schedule event save by xmlhttprequest
	 *
	 */
	public function saveFutureEvent() {
		$this->loadModel("Appointment");
		$this->loadModel("Patient");
		$this->loadModel("DoctorProfile");

		if($this->params['isAjax']) {
			// set userid value in ajax variable//
			$this->params->query['doctor_userid'] = $this->Auth->user('id');
			if(!($this->params->query['admissionid'])) {
				$this->Session->setFlash(__('Please enter admission id', true));
				exit;
			}
			$countAdmissionId = $this->Patient->find('count', array('conditions' => array('Patient.admission_id' => $this->params->query['admissionid'])));
			if($countAdmissionId > 0) {
				$getPatientId = $this->Patient->find('first', array('conditions' => array('Patient.admission_id' => $this->params->query['admissionid']), 'fields' => array('Patient.id')));
				if(date("Y-m-d", strtotime($this->params->query['scheduledate'])) >= date("Y-m-d")) {
					$checkDoctorSchedule = $this->ScheduleTime->checkDoctorSchedule($this->params->query);
					if($checkDoctorSchedule['appointment'] == 1 && $checkDoctorSchedule['staffplan'] == 1 && $checkDoctorSchedule['doctoroptappointment'] == 1 && $checkDoctorSchedule['anaesthesiaoptappointment'] == 1) {
						// generate token //
						$getTokenAlpha = $this->DoctorProfile->find('first', array('conditions' => array('DoctorProfile.user_id' => $this->params->query['doctor_userid']), 'fields' => array('DoctorProfile.token_alphabet')));
						$countDayApp = $this->Appointment->find('count', array('conditions' => array('Appointment.doctor_id' => $this->params->query['doctor_userid'], 'Appointment.date' => date("Y-m-d"), 'Appointment.is_deleted' => 0)));
						$serialTokenNumber = $getTokenAlpha['DoctorProfile']['token_alphabet'].($countDayApp+1);

						$this->request->data['Appointment']['patient_id'] = $getPatientId['Patient']['id'];
						$this->request->data['Appointment']['location_id'] = $this->Session->read("locationid");
						$this->request->data['Appointment']['doctor_id'] = $this->params->query['doctor_userid'];
						$this->request->data['Appointment']['department_id'] = $this->params->query['department'];
						$this->request->data['Appointment']['date'] = $this->params->query['scheduledate'];
						$this->request->data['Appointment']['start_time'] = $this->params->query['schedule_starttime'];
						$this->request->data['Appointment']['end_time'] = $this->params->query['schedule_endtime'];
						$this->request->data['Appointment']['purpose'] = $this->params->query['purpose'];
						$this->request->data['Appointment']['visit_type'] = $this->params->query['visit_type'];
						$this->request->data['Appointment']['app_token'] = $serialTokenNumber;
						$this->request->data['Appointment']['created_by'] = $this->Auth->user('id');
						$this->request->data['Appointment']['create_time'] = date("Y-m-d H:i:s");
						$this->Appointment->save($this->request->data);
						$this->Session->setFlash(__('Schedule time has been saved', true));
						exit;
					} else {
						if($checkDoctorSchedule['appointment'] == 2){
							$this->Session->setFlash(__('Doctor appointment time is overlapping.', true));
							exit;
						} elseif($checkDoctorSchedule['staffplan'] == 2) {
							$this->Session->setFlash(__('Your staff plan is overlapping.', true));
							exit;
						} elseif($checkDoctorSchedule['doctoroptappointment'] == 2) {
							$this->Session->setFlash(__('Doctor OT appointment is overlapping.', true));
							exit;
						} elseif($checkDoctorSchedule['anaesthesiaoptappointment'] == 2) {
							$this->Session->setFlash(__('Anaethetist OT appointment is overlapping.', true));
							exit;
						} else {
							$this->Session->setFlash(__('Doctor is set for other apppointment.', true));
							exit;
						}

					}
				} else {
					$this->Session->setFlash(__('You cannot set appointments for a past date', true));
					exit;
				}
			} else {
				$this->Session->setFlash(__('Your admission id is wrong so please try again.', true));
				exit;
			}

		}

	}

	/**
	 *  update future schedule event by xmlhttprequest
	 *
	 */
	public function updateFutureEvent() {
		$this->loadModel("Appointment");
		$this->loadModel("Patient");
			
		if($this->params['isAjax']) {
			if(!($this->params->query['admissionid'])) {
				$this->Session->setFlash(__('Please enter admission id', true));
				exit;
			}
			//$checkDoctorSchedule = $this->ScheduleTime->checkDoctorSchedule($this->params->query);
			$countAdmissionId = $this->Patient->find('count', array('conditions' => array('Patient.admission_id' => $this->params->query['admissionid'])));
			if($countAdmissionId > 0) {

				$getPatientId = $this->Patient->find('first', array('conditions' => array('Patient.admission_id' => $this->params->query['admissionid']), 'fields' => array('Patient.id')));
				if(date("Y-m-d", strtotime($this->params->query['scheduledate'])) >= date("Y-m-d")) {
					$checkDoctorSchedule = $this->ScheduleTime->checkDoctorSchedule($this->params->query);
					if($checkDoctorSchedule['appointment'] == 1 && $checkDoctorSchedule['staffplan'] == 1 && $checkDoctorSchedule['doctoroptappointment'] == 1 && $checkDoctorSchedule['anaesthesiaoptappointment'] == 1) {
						$this->Appointment->id = $this->params->query['id'];
						$this->request->data['Appointment']['id'] = $this->params->query['id'];
						$this->request->data['Appointment']['patient_id'] = $getPatientId['Patient']['id'];
						$this->request->data['Appointment']['location_id'] = $this->Session->read("locationid");
						$this->request->data['Appointment']['department_id'] = $this->params->query['department'];
						$this->request->data['Appointment']['date'] = $this->params->query['scheduledate'];
						$this->request->data['Appointment']['start_time'] = $this->params->query['schedule_starttime'];
						$this->request->data['Appointment']['appointment_with'] = $this->params->query['appointment_with'];
						$this->request->data['Appointment']['end_time'] = $this->params->query['schedule_endtime'];
						$this->request->data['Appointment']['purpose'] = $this->params->query['purpose'];
						$this->request->data['Appointment']['visit_type'] = $this->params->query['visit_type'];
						$this->request->data['Appointment']['modified_by'] = $this->Auth->user('id');
						$this->request->data['Appointment']['modify_time'] = date("Y-m-d H:i:s");
						$this->Appointment->save($this->request->data);
						$this->Session->setFlash(__('Schedule time has been updated.', true));
						exit;
					} else {
						if($checkDoctorSchedule['appointment'] == 2){
							$this->Session->setFlash(__('Doctor appointment time is overlapping.', true));
							exit;
						} elseif($checkDoctorSchedule['staffplan'] == 2) {
							$this->Session->setFlash(__('Your staff plan is overlapping.', true));
							exit;
						} elseif($checkDoctorSchedule['doctoroptappointment'] == 2) {
							$this->Session->setFlash(__('Doctor OT appointment is overlapping.', true));
							exit;
						} elseif($checkDoctorSchedule['anaesthesiaoptappointment'] == 2) {
							$this->Session->setFlash(__('Anaethetist OT appointment is overlapping.', true));
							exit;
						} else {
							$this->Session->setFlash(__('Doctor is set for other apppointment.', true));
							exit;
						}
					}
				} else {
					$this->Session->setFlash(__('You cannot set appointments for a past date', true));
					exit;
				}
			} else {
				$this->Session->setFlash(__('Your admission id is wrong so please try again.', true));
				exit;
			}

		}

	}

	/**
	 * delete future schedule event by xmlhttprequest
	 *
	 */
	public function deleteFutureEvent() {
		$this->loadModel("Appointment");
		if($this->params['isAjax']) {
			$this->Appointment->id = $this->params->query['id'];
			$this->request->data['Appointment']['id'] = $this->params->query['id'];
			$this->request->data['Appointment']['is_deleted'] = 1;
			$this->request->data['Appointment']['modified_by'] = $this->Auth->user('id');
			$this->request->data['Appointment']['modify_time '] = date("Y-m-d H:i:s");
			$this->Appointment->save($this->data);
			$this->Session->setFlash(__('Schedule time deleted', true));
			exit;
		}

	}

	/**
	 * get patient name by xmlhttprequest
	 *
	 */
	public function ajaxGetPatientNameForFutureEvent() {
		if($this->params['isAjax']) {
			$this->loadModel("Patient");
			$getPatientName = $this->Patient->find('first', array('fields'=> array('lookup_name'), 'conditions'=> array('Patient.is_deleted' => 0, 'Patient.location_id' => $this->Session->read('locationid'), 'Patient.admission_id' => $this->params->query['paid'])));
			echo $getPatientName['Patient']['lookup_name'];
			exit;
		}

	}

	public function saveDoctorColor($showCalendarDay=7){
		$this->uses = array('DoctorProfile');
		$this->layout = false;
		$this->DoctorProfile->updateAll(
				array('DoctorProfile.present_event_color' => "'".$this->request->data['color']."'"),
				array('DoctorProfile.user_id' => $this->request->data['doctorId'])
		);
		echo 1;
		exit;
	}
	/**
	 * saveVisitColor
	 *  for saving doctors appointment type color
	 */
	public function saveVisitColor(){
		$this->uses = array('DoctorProfile');
		$this->layout = false;
		set::filter($this->request->data['color']);
		$this->DoctorProfile->updateAll(
				array('DoctorProfile.appointment_visit_color' => "'".serialize(array_combine($this->request->data['color'], $this->request->data['colors']))."'"),
				array('DoctorProfile.user_id' => $this->Session->read('userid'))
		);
		echo 1;
		exit;
	}

	/**
	 * getChangeCalColor
	 *  for changing doctors appointment bg color
	 */
	public function getChangeCalColor($changeColor,$userId){
		$this->uses = array('DoctorProfile');
		$this->layout = false;
		$this->DoctorProfile->updateAll(
				array('DoctorProfile.show_color_from' => "'".$changeColor."'"),
				array('DoctorProfile.user_id' => $userId)
		);
		echo 1;
		exit;
	}

	/**
	 * getChangeCalColor
	 *  for changing doctors appointment bg color
	 */
	public function updateDoctorTime(){
		$this->uses = array('DoctorProfile');
		$this->layout = false;
		$this->DoctorProfile->updateAll(
				array('DoctorProfile.starthours' => "'".$this->request->data['starthours']."'",
						'DoctorProfile.endhours' => "'".$this->request->data['endhours']."'"),
				array('DoctorProfile.user_id' => $this->Session->read('userid'))
		);
		echo 1;
		exit;
	}

	/**
	 * getPatientDetails ajax action
	 *
	 * @author gaurav
	 */
	function getPatientDetails($patientId = null, $patientUid = null ){
		$this->layout = 'ajax';
		$this->uses = array('Patient','User');
		$this->Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
				)),false);
		$getPatientName = $this->Patient->find('first', array('fields'=> array('lookup_name','admission_id','doctor_id','Person.dob','patient_id'),
				'conditions'=> array('Patient.is_deleted' => 0, 'Patient.location_id' => $this->Session->read('locationid'),
						'OR'=>array('Patient.patient_id' =>$patientUid,'Patient.id' =>$patientId)),'order'=>array('Patient.id'=>'DESC')));
		$getPatientName['Person']['dob'] = $this->DateFormat->formatDate2Local($getPatientName['Person']['dob'],Configure::read('date_format'),false);
		$doctorName = $this->User->getUserByID($getPatientName['Patient']['doctor_id'],array('id','full_name','department_id'));
		echo json_encode(array($getPatientName,$doctorName));
		exit;
	}

}
?>