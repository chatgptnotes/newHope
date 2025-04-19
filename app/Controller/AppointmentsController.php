<?php
/**
 * Languages Controller
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Appointment.Controller
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pankaj wanjari
 */
class AppointmentsController extends AppController {

	public $name = 'Appointments';
	public $uses = array('Appointment');
	public $components = array('RequestHandler','Email','DateFormat');
	public $helpers = array('Html','Form', 'Js','DateFormat','General');

	function index(){
		$this->set('title_for_layout', __('-Appointment management', true));
		$this->uses=array('Department' , 'DoctorProfile');

		//location id
		$location_id = $this->Session->read('locationid');
		if(isset($this->data['Appointment'])){
			$app_form = $this->data['Appointment'];
		}/*else if(!empty($this->params['named']['sDate'])|| !empty($this->params['named']['sDept']) || !empty($this->params['named']['sPhys'])){
		$app_form = $this->params['named'] ;
		}*/else{
		$app_form = $this->params->query ;
		}
			
		//collect all the search entities
		$app_date = (!empty($app_form['sDate'])) ? $app_form['sDate'] :"";
		$app_Dept = (!empty($app_form['sDept'])) ? $app_form['sDept'] :"";
		$app_Phys = (!empty($app_form['sPhys'])) ? $app_form['sPhys'] :"";
		if(!empty($app_date)){
			$app_date = $this->DateFormat->formatDate2STD($app_date,Configure::read('date_format'));
		}
		//print_r($this->params['url']);
		$search_key= $this->Appointment->searchAppointment($app_date,$app_Dept,$app_Phys);
			
		if(empty($app_date)){
			$search_key['Appointment.date like '] = "%".date('Y-m-d');//default listing of today's date
		}
			
		$this->loadModel('User');
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array('Appointment.date' => 'asc'),
				'fields'=> array('Appointment.*,concat(User.first_name," ",User.last_name) as full_name,Department.name,Patient.full_name,Patient.age'),
				'conditions'=>$search_key

		);
		//get all departments by location ID
		$this->set('departments',$this->Department->getDepartmentByLocationID($location_id));
		$getAllDoctorList = $this->User->getDoctorList($this->Session->read('locationid'));

		$this->set('doctors',$this->DoctorProfile->find('list', array('conditions' => array('DoctorProfile.user_id' => $getAllDoctorList), 'fields' => array('DoctorProfile.user_id', 'DoctorProfile.doctor_name'))));
		//$this->set('data',$this->paginate('Appointment'));
		//temp commented
		$this->set('data','');
		$this->set('search_key',$search_key);
		$app_date_calender = (!empty($app_form['sDate']))?$this->DateFormat->formatDate2Local($app_date,Configure::read('date_format')):"" ;
		$this->set('app_date_calender',$app_date_calender);
		$this->data  = array('Appointment' =>
				array('sDate'=>$app_date,
						'sDept'=>$app_Dept,
						'sPhys'=>$app_Phys
				));
	}

	/**
	 * Method to edit appointment
	 *
	 * @param id: appointment id
	 *
	 **/
	public function add($id=null){
			
		$this->set('title_for_layout', __('-Appointment management', true));
		$this->uses=array('Location','Department','Role','User', 'DoctorProfile');
		if($this->RequestHandler->isAjax()){
			$this->layout = 'ajax';
			//$this->autoRender =false ;
		}
			
		if(!empty($this->request->data)){
			$this->viewClass = '';
			$patient_id =$this->request->data['Appointment']['patient_id'] ;
			$this->request->data["Appointment"]['date'] = $this->DateFormat->formatDate2STD($this->request->data["Appointment"]['visit_on'],Configure::read('date_format'));
			if($this->Appointment->insertAppointment($this->request->data,'insert')){
				if($this->RequestHandler->isAjax()){
					$this->Session->setFlash(__('Appointment added successfully' ),true,array('class'=>'message'));
					$this->redirect('/appointments/appointmentList/'.$patient_id);
				}else{
					$this->Session->setFlash(__('Appointment added successfully' ),'default',array('class'=>'message'));
					$this->redirect('/appointments/appointmentList/'.$patient_id);
				}
			}else{
				$errors = $this->Appointment->invalidFields();
				if(!empty($errors)) {
					$this->set("errors", $errors);
				}else{
					$this->Session->setFlash(__('Unable to set appointment ,Please try again' ),'default',array('class'=>'error'));
				}
			}
		}else if(empty($id)){
			$this->Session->setFlash(__('Please select the patient first' ),'default',array('class'=>'message'));
			$this->redirect(array("controller" => "patients", "action" => "search"));
		}
		$location_id= $this->Session->read('locationid');
		//$this->set('doctors',$this->User->getDoctorsByLocation($location_id));
		$getAllDoctorList = $this->User->getDoctorList($this->Session->read('locationid'));
		$this->set('doctors',$this->DoctorProfile->find('list', array('conditions' => array('DoctorProfile.user_id' => $getAllDoctorList), 'fields' => array('DoctorProfile.user_id', 'DoctorProfile.doctor_name'))));
		$this->set('departments',$this->Department->find('list',array('fields'=>array('id','name'),'conditions'=>array('Department.location_id'=>$location_id))));
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array(
						'Appointment.date' => 'asc',
						'condition'=>array('Appointment.patient_id'=>$id)
				)
		);
		$this->set('patient_id',$id);
		$this->set('data',$this->paginate('Appointment'));

	}

	/**
	 * Method to edit appointment
	 *
	 * @param id: appointment id
	 *
	 **/

	public function edit($id=null){
		$this->set('title_for_layout', __('-Appointment management', true));
		$this->uses=array('Location','Department','Doctor','User','Role', 'DoctorProfile');
		if($this->RequestHandler->isAjax()){
			$this->layout = 'ajax';
		}
		if(!empty($this->request->data)){
			$patient_id =$this->request->data['Appointment']['patient_id'] ;
			$this->request->data["Appointment"]['date'] = $this->DateFormat->formatDate2STD($this->request->data["Appointment"]['visit_on'],Configure::read('date_format'));
			if($this->Appointment->insertAppointment($this->request->data,'insert')){
				$this->Session->setFlash(__('Appointment updated successfully' ),true,array('class'=>'message'));
				echo $this->requestAction('/appointments/appointmentList/'.$patient_id,array('return'));
				exit;

				$this->redirect(array("controller" => "patients", "action" => "patient_information",$patient_id));
			}else{
				$errors = $this->Appointment->invalidFields();
				if(!empty($errors)) {
					$this->set("errors", $errors);
				}else{
					$this->Session->setFlash(__('Unable to set appointment ,Please try again' ),'default',array('class'=>'error'));
				}
			}
		}
		if($id){
			$location_id= $this->Session->read('locationid');
			//$this->set('doctors',$this->User->getDoctorsByLocation($location_id));
			$getAllDoctorList = $this->User->getDoctorList($this->Session->read('locationid'));
			$this->set('doctors',$this->DoctorProfile->find('list', array('conditions' => array('DoctorProfile.user_id' => $getAllDoctorList), 'fields' => array('DoctorProfile.user_id', 'DoctorProfile.doctor_name'))));
			$this->set('departments',$this->Department->find('list',array('fields'=>array('id','name'),'conditions'=>array('Department.location_id'=>$location_id))));

			$this->set('id',$id);
			$app_data = $this->Appointment->read(null,$id) ;

			//once again swap date and time ele
			$app_data['Appointment']['visit_on'] =$app_data['Appointment']['date'];
			$app_data['Appointment']['start'] =$app_data['Appointment']['start_time'];
			$app_data['Appointment']['end'] =$app_data['Appointment']['end_time'];
			if(!empty($app_data['Appointment']['visit_on'])){
				$app_data['Appointment']['visit_on'] = $this->DateFormat->formatDate2Local($app_data['Appointment']['visit_on'],Configure::read('date_format'));
			}
			$this->data= $app_data;

		}else{
			$this->redirect(array("action" => "index"));
		}
	}


	public function app_edit($id=null){
		$this->set('title_for_layout', __('-Appointment management', true));
		$this->uses=array('Location','Department','Doctor','User','Role', 'DoctorProfile');

		if(!empty($this->request->data)){
			$patient_id =$this->request->data['Appointment']['patient_id'] ;
			$this->request->data["Appointment"]['date'] = $this->DateFormat->formatDate2STD($this->request->data["Appointment"]['visit_on'],Configure::read('date_format'));
			if($this->Appointment->insertAppointment($this->request->data,'insert')){
				$this->Session->setFlash(__('Appointment updated successfully' ),'default',array('class'=>'message'));
					
				$this->redirect('/appointments');
			}else{
				$errors = $this->Appointment->invalidFields();
				if(!empty($errors)) {
					$this->set("errors", $errors);
				}else{
					$this->Session->setFlash(__('Unable to set appointment ,Please try again' ),'default',array('class'=>'error'));
				}
			}
		}
		if($id){
			$location_id= $this->Session->read('locationid');
			//$this->set('doctors',$this->User->getDoctorsByLocation($location_id));
			$getAllDoctorList = $this->User->getDoctorList($this->Session->read('locationid'));
			$this->set('doctors',$this->DoctorProfile->find('list', array('conditions' => array('DoctorProfile.user_id' => $getAllDoctorList), 'fields' => array('DoctorProfile.user_id', 'DoctorProfile.doctor_name'))));
			$this->set('departments',$this->Department->find('list',array('fields'=>array('id','name'),'conditions'=>array('Department.location_id'=>$location_id))));
			$this->set('id',$id);
			$app_data = $this->Appointment->read(null,$id) ;

			//once again swap date and time ele
			$app_data['Appointment']['visit_on'] =$app_data['Appointment']['date'];
			$app_data['Appointment']['start'] =$app_data['Appointment']['start_time'];
			$app_data['Appointment']['end'] =$app_data['Appointment']['end_time'];
			if(!empty($app_data['Appointment']['visit_on'])){
				$app_data['Appointment']['visit_on'] = $this->DateFormat->formatDate2Local($app_data['Appointment']['visit_on'],Configure::read('date_format'));
			}
			$this->data= $app_data;

		}else{
			$this->redirect(array("action" => "index"));
		}
	}


	/**
	 * Method to cancel appointment
	 *
	 * @param id: appointment id
	 *
	 **/
	public function delete($id = null,$patient_id=null) {

		if($id){
			$this->Appointment->id = $id;
			if ($this->Appointment->save(array('is_deleted' => 1))) {
				//$this->Session->setFlash(__('Appointment cancelled','',array('class'=>'message')));
				/*if($patient_id)
					$this->redirect(array('controller'=>'patients','action'=>'index',$patient_id));
				else
					$this->redirect(array('action'=>'index'));*/
				echo $this->requestAction('/appointments/appointmentList/'.$patient_id,array('return'));
				exit ;
				$this->redirect($this->referer());
			}
		}else{
			$this->Session->setFlash(__('Invalid operation'),array('class'=>'error'));
			$this->redirect(array('action' => 'index'));
		}
	}

	public function appointmentList($patient_id=null){
			
		//$this->layout = 'ajax';
		$this->Appointment->bindModel(array(
				'belongsTo' => array(
						'User' =>array('foreignKey'=>'doctor_id'),
						'Department' =>array('foreignKey'=>'department_id'),
				)));
		$this->paginate = array(
				'update' => '#list_content',
				'evalScripts' => true

		);
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array('Appointment.create_time' => 'desc'),
				'fields'=> array('Appointment.*,concat(User.first_name," ",User.last_name) as full_name,Department.name'),
				'conditions'=>array('Appointment.patient_id'=>$patient_id,'Appointment.is_deleted'=>'0')
		);
		$this->set('id',$patient_id);
		$this->set('data',$this->paginate('Appointment'));
		$this->render('appointmentList');
	}

	/**
	 * doctor appointment listing
	 *
	 */
	public function doctor_appointmentlist($patient_id=null) {
		$this->loadModel("DoctorProfile");
		$this->layout = 'ajax';
		$doctorlist = $this->DoctorProfile->find('list', array('conditions'=>array('DoctorProfile.availability' => 1, 'DoctorProfile.is_deleted' => 0), 'fields' => array('DoctorProfile.user_id', 'DoctorProfile.doctor_name')));
		$this->set('patientid',$patient_id);
		$this->set('doctorlist',$doctorlist);
		$this->render('doctor_appointmentlist');
	}

	public function getDoctorDetails($doctorId){

		$this->uses = array('User','Patient','DoctorProfile');
		//$patientUid = 'UHHO13J16001';
		$patientUid = $this->Session->read('username');
		$patientDetails = $this->Patient->find('first',array('conditions'=>array('Patient.patient_id'=>$patientUid),'fields'=>array('doctor_id','id','person_id'),'order'=>'Patient.id DESC'));
		if(empty($doctorId)){
			$doctorId = $patientDetails['Patient']['doctor_id'];
			//$doctorId = 100;
		}

		$this->User->bindModel(array(
				'belongsTo'=>array(
						'Department' => array('className'    => 'Department',
								'foreignKey'    => 'department_id'
						),
						'Initial' => array('className' => 'Initial',
								'foreignKey'    => false,
								'conditions'=>array('Initial.id=User.initial_id')
						),
						'City' => array('className' => 'City',
								'foreignKey'    => false,
								'conditions'=>array('User.city_id=City.id')
						),
						'State' => array('className' => 'State',
								'foreignKey'    => false,
								'conditions'=>array('User.state_id=State.id')
						),
						'Country' => array('className' => 'Country',
								'foreignKey'    => false,
								'conditions'=>array('User.country_id=Country.id')
						)
				)));
		$doctorDetails = $this->User->find('first',array('conditions'=>array('User.id'=>$doctorId,'User.is_deleted'=>0,'User.location_id'=>$this->Session->read('locationid'))));
		$doctoProifle = $this->DoctorProfile->findByUserId($doctorId);
		//echo '<pre>';print_r($doctorDetails);exit;
		$this->set('doctoProifle',$doctoProifle);
		$this->set('doctorDetails',$doctorDetails);
		$this->set('doctorList',$this->DoctorProfile->getDoctors());
		$this->set('doctorId',$doctorId);
		$this->set('patientId',$patientDetails['Patient']['person_id']);
		$this->set('lastWeekDate',date('Y-m-d'));
		//$lastWeekDate = date("Y-m-d",strtotime("+1 day",strtotime(date("Y-m-d"))));
		//echo date("d D",strtotime($lastWeekDate));
	}

	public function getAppointmentDetails($doctorId,$patientId,$date=null){

		$this->layout = 'ajax' ;
		$this->uses = array('Appointment','DoctorChamber','DoctorProfile','User');
		if(empty($date)){
			$date = date("Y-m-d");
		}
		$flag = 0;
		$currDateExplode = explode("-",$date);
		$minutesDifference = '96';
		$startHours = date("G:i A",strtotime($startHours));
		$timeInterval = "15";

		$dateExplode = explode("-",$date);
		$lastWeekDate = date("Y-m-d",strtotime("+6 day",strtotime($date)));


		$doctorChambers = $this->DoctorChamber->find('all',array(
				'conditions'=>array('doctor_id'=>$doctorId,'is_deleted'=>0,'location_id'=>$this->Session->read('locationid'),
						'DATE_FORMAT(`DoctorChamber`.`starttime`, "%Y-%m-%d") >=' =>$date,'DATE_FORMAT(`DoctorChamber`.`starttime`, "%Y-%m-%d") <=' =>$lastWeekDate),
				'order'=>'DoctorChamber.id ASC',
				'fields'=>array('chamber_id','purpose','start_time','end_time','DATE_FORMAT(`DoctorChamber`.`starttime`, "%Y-%m-%d") as starttime','endtime','is_all_day_event','is_recurring','recurring_month','weekdays')));

		$doctorDetails = $this->User->find('first',array('conditions'=>array('User.id'=>$doctorId,'User.is_deleted'=>0,'User.location_id'=>$this->Session->read('locationid'))));
		$doctorProfile = $this->DoctorProfile->findByUserId($doctorId);
		
		$startHours = $doctorProfile['DoctorProfile']['starthours'];
		$endHours = $doctorProfile['DoctorProfile']['endhours'];
		if(empty($startHours) || empty($endHours)){
			$startHours = Configure::read('calendar_start_time');
			$endHours = Configure::read('calendar_end_time');
		}
		$startHours = $startHours.'.00';
		$endHours = $endHours.'.00';
		//$startTimeExp = explode(" ",$doctorChambers['DoctorChamber']['starttime']);
		//$endTimeExp = explode(" ",$doctorChambers['DoctorChamber']['endtime']);
		//$doctorChambers['DoctorChamber']['starttime'] = $startTimeExp[0];
		//$doctorChambers['DoctorChamber']['endtime'] = $endTimeExp[0];
		//$startHours = $doctorChambers['DoctorChamber']['start_time'];
		//$endHours = $doctorChambers['DoctorChamber']['end_time'];

		//$minutesDifference = round((strtotime($endHours) - strtotime($startHours))/30/60, 1);
		$holidays = array();
		$doctorChambersModified = array();
		$docChamberArray = $docChamber = array();
		$blockHours = array();
		$ldate = '';
		$key = 0;
		$flag = 0;

		for($i=0; $i < 7; $i++){
			$docChamber['DoctorChamber']['start_time'] = $startHours;
			$docChamber['DoctorChamber']['end_time'] = $endHours;
			$docChamber['DoctorChamber']['holiday'] = 0;
			$docChamber['0']['starttime'] = date('Y-m-d', strtotime($date . " + $i days"));
			array_push($docChamberArray, $docChamber);
		}

		foreach ($doctorChambers as $key=>$doctorChamber){
			$blockHours[$doctorChamber[0]['starttime']][$key]['block_start_time'] =  $doctorChamber['DoctorChamber']['start_time'];
			$blockHours[$doctorChamber[0]['starttime']][$key]['block_end_time'] =  $doctorChamber['DoctorChamber']['end_time'];
		}
		$lastWeekDateExplode = explode("-",$lastWeekDate);
		$timePeriodNext= date("F",strtotime($date))." ".$dateExplode[2]." - ".date("F",strtotime($lastWeekDate))." ".$lastWeekDateExplode[2]." , ".$lastWeekDateExplode[0];;
		if(strtotime($date) > strtotime(date("Y-m-d"))){
			$prevWeekDate = date("Y-m-d",strtotime("-7 day",strtotime($date)));
			$timePeriodPrev = $prevWeekDate;
		}

		$appointments = $this->Appointment->find('all',array('fields'=>array('status','date','start_time','end_time','purpose','patient_id','id','person_id'),
				'conditions'=>array('doctor_id'=>$doctorId,'location_id'=>$this->Session->read('locationid'),
						'is_deleted'=>0,'date >='=>$date,'date <='=>$lastWeekDate),'order'=>array('start_time ASC')));
		
		foreach ($appointments as $key=>$slotAppointment){
			if((strtotime($slotAppointment['Appointment']['start_time']) + 900) != strtotime($slotAppointment['Appointment']['end_time'])){
				$loopStart = $slotAppointment['Appointment']['start_time'];
				$loopEnd = $slotAppointment['Appointment']['end_time'];
				for($i = strtotime($loopStart); $i<strtotime($loopEnd); $i +=900){
					$slotAppointment['Appointment']['start_time'] = date("H:i",$i);
					$slotAppointment['Appointment']['end_time'] = date("H:i",$i + 900);
					$newAppointment[] = $slotAppointment;
				}
			}else{
				$newAppointment[] = $slotAppointment;
			}
		}
		//debug($newAppointment);
		$this->set('appointments',$newAppointment);
		$this->set(array('patientId'=>$patientId,'doctorId'=>$doctorId,'startHours'=>$startHours,'endHours'=>$endHours,
				'timeInterval'=>$timeInterval,'timePeriodNext'=>$timePeriodNext,'currentDate'=>$date,
				'lastWeekDate'=>date("Y-m-d",strtotime("+7 day",strtotime($date))),'minutesDifference'=>$minutesDifference,
				'timePeriodPrev'=>$timePeriodPrev,'doctorChambers'=>$docChamberArray,'doctorChambersOff'=>$doctorChambersModified,'blockHours'=>$blockHours));
	}

	/**
	 * Author (Pawan Meshram)
	 * DONT CHANGE WITHOUT PERMISSION
	 * Appointment Scheduling From Patient Portal
	 * @param (int) $patientId
	 * @param (int) $departmentId
	 * @param (varchar) $startTime
	 * @param (varchar) $startDate
	 * @param (int) $doctorId
	 * @param (varchar) $currStartDate
	 */

	public function schedulePatientAppointment($patientId,$departmentId,$startTime,$startDate,$doctorId,$currStartDate){
		$this->layout = false;
		$this->uses = array("DoctorProfile","Patient","Appointment","Person");
	   
		if($this->request->data){
			$this->request->data['Appointment']['start_time'] = date("H:i",strtotime($this->request->data['Appointment']['start_time']));
			$this->request->data['Appointment']['end_time'] = date("H:i",strtotime("+15 minutes",strtotime($this->request->data['Appointment']['start_time'])));
			$this->request->data['Appointment']['location_id'] = $this->Session->read('locationid');
			$this->request->data['Appointment']['purpose'] = $this->request->data['Appointment_purpose'];
			$this->request->data['Appointment']['doctor_id'] = $this->request->data['Appointment']['appointment_with'];
			$this->request->data['Appointment']['created_by'] = $this->Session->read('userid');
			$this->request->data['Appointment']['role'] = strtolower($this->Session->read('role'));
			$this->request->data['Appointment']['create_time'] = date("Y-m-d H:i:s");
			$existingAppointment = $this->Appointment->find('first',array('fields'=>array('Appointment.is_future_app','Appointment.id'),
			 'conditions'=>array('person_id'=>$this->request->data['Appointment']['person_id'],'date'=>date("Y-m-d")),
					'order'=>array('Appointment.id DESC')));
			if(empty($existingAppointment) || strtotime($startDate) > strtotime(date("Y-m-d"))){
			$this->request->data['Appointment']['is_future_app'] = 1;
			}else{
			$this->request->data['Appointment']['is_future_app'] = 0;
			}
			//$this->request->data['Appointment']['is_future_app'] = 1;
			$this->request->data['Appointment']['is_deleted'] = 0;
			$this->request->data['Appointment']['date'] = $startDate;
			if($this->request->data['Appointment']['to_tast_fast'] == 1){
				$this->request->data['Appointment']['to_tast_fast']="To Fast for fasting blood sugar";
			}
			$patientData = $this->Patient->find('first',array('conditions'=>array('Patient.person_id'=>$this->request->data['Appointment']['person_id'],'Patient.is_deleted'=>'0'),'fields'=>array('Patient.id')));
			
			$this->request->data['Appointment']['patient_id'] = $patientData['Patient']['id'];
			
			// only 30 appointments should be scheduled-Leena
			$appCount1=$this->Appointment->find('all',array('fields'=>array('COUNT(Appointment.id) as count'),
					'conditions'=>array('DATE_FORMAT(Appointment.date, "%Y-%m-%d") LIKE' => $startDate,'Appointment.doctor_id'=>$doctorId)));			
			 if($appCount1[0][0]['count'] < Configure::read('max_appointments')){
				
				$this->Appointment->save($this->request->data);
			}
			
		}
		
		$appCount=$this->Appointment->find('all',array('fields'=>array('COUNT(Appointment.id) as count'),
				'conditions'=>array('DATE_FORMAT(Appointment.date, "%Y-%m-%d") LIKE' => $startDate,'Appointment.doctor_id'=>$doctorId)));
		
		$startDate1 = date("Y-m-d",strtotime("-1 day",strtotime($startDate)));
		$startTime = str_replace("-", ":", $startTime);
		$departmentId = str_replace("-", ":", $departmentId);
		$patientDetails = $this->Person->read(array('first_name','last_name','patient_uid'),$patientId);
		$visitTypeArray = Configure::read('patient_visit_type');
		$this->set('doctorList',$this->DoctorProfile->getDoctors());
		$this->set('appCount',$appCount);
		$this->set(array('currStartDate'=>$currStartDate,'visitTypeArray'=>$visitTypeArray,'patientId'=>$patientId,'startTime'=>$startTime,'startDate'=>$startDate,'doctorId'=>$doctorId,'patientDetails'=>$patientDetails,'departmentId'=>$departmentId,'startDate1'=>$startDate1));
	}

	public function appointments_management(){
		if($this->params->query['type'] == "slidesix"){
			$this->layout = 'advance_ajax';
		}else{
			$this->layout = 'advance';
		}
		$this->uses = array('User');
		$opddoctors = $this->User->getOpdDoctors();
		$this->set('doctors',$opddoctors);
		$this->set('doctorsJson',json_encode($doctors));
	}

	public function appointments_dashboard($future_apt=null,$patient_id=null,$opt=null,$aptId=null){
		//$this->layout = 'ajax';
		$this->uses = array('Chamber','User','Patient','Note','NoteDiagnosis','LaboratoryResult','ServiceCategory',
				'LaboratoryTestOrder','RadiologyTestOrder','RadiologyResult','ReferralToSpecialist','TariffStandard');
		if(!empty($this->request->data)){
			//debug($this->request->data);exit;
			if($opt=='nurse'){
				//for nurse update
				//find  room is allocated already
				$isRoomAllot = $this->Appointment->find('first',array('fields'=>array('Appointment.chamber_id','Appointment.status'),'conditions'=>array('Appointment.id'=>$aptId)));
				$nurse_id= $this->request->data['value'];
				$this->Appointment->updateAll(array('Appointment.nurse_id'=>"'$nurse_id'"),array('Appointment.id'=> $aptId));
				if(/*!empty($isRoomAllot['Appointment']['chamber_id']) && */!empty($nurse_id)){
					if($isRoomAllot['Appointment']['status']=='In-Progress'){
						$status="'In-Progress'";
					}
					else if($statusCheck['Appointment']['status']=='Seen'){
						$status="'Seen'";
					}
					else if($statusCheck['Appointment']['status']=='Closed'){
						$status="'Closed'";
					}
					else{
						$status="'Assigned'";
					}
					$this->Appointment->updateAll(array('status'=>$status),array('Appointment.id'=>$aptId)) ; //change status on nurse and room allocation
					//$this->redirect('appointment_dashboard') ;
				}else if(empty($nurse_id)){
					$this->Appointment->updateAll(array('status'=>"'Arrived'"),array('Appointment.id'=>$aptId)) ; //change status on nurse and room allocation
				}
				//EOF check
			}elseif($opt=='room'){//room allocation
				{	//for room cond $patient_id is the appointment's ID
					$room_id=$this->request->data['value'];
					//EOF check
					$this->Appointment->bindModel(array(
							'hasOne' => array(
									'TariffList' =>array('foreignKey'=>false,'conditions'=>array('TariffList.id = Appointment.visit_type')))));
					$statusCheck=$this->Appointment->find('first',array('fields'=>array('Appointment.status','Appointment.nurse_id',
							'Appointment.token_no','TariffList.code_name'),
							'conditions'=>array('Appointment.id'=>$patient_id)));
					if(empty($statusCheck['Appointment']['token_no'])){
						$count = $this->Appointment->find('count',array('conditions'=>array(
								'Appointment.date '=> date("Y-m-d"),'token_no !=' => null)));
						$statusCheck['Appointment']['token_no'] = $count+1;
					}
					if($statusCheck['TariffList']['code_name'] == "Physiotherapy/Direct OPD")
						$statusCheck['Appointment']['token_no'] = null;
					$this->Appointment->updateAll(array('Appointment.chamber_id'=>"'$room_id'",
							'Appointment.token_no'=>$statusCheck['Appointment']['token_no']),
							array('Appointment.id'=>$patient_id));
					if(!empty($statusCheck['Appointment']['nurse_id']) && !empty($room_id)){
						if($statusCheck['Appointment']['status']=='In-Progress'){
							$status="'In-Progress'";
						}
						else if($statusCheck['Appointment']['status']=='Seen'){
							$status="'Seen'";
						}
						else if($statusCheck['Appointment']['status']=='Closed'){
							$status="'Closed'";
						}
						else{
							$status="'Assigned'";
						}
						$this->Appointment->updateAll(array('status'=>$status),array('Appointment.id'=>$patient_id)) ; //change status on nurse and room allocation
						//$this->redirect('appointment_dashboard') ;
					}else if(empty($room_id)){
						$this->Appointment->updateAll(array('status'=>"'Arrived'"),array('Appointment.id'=>$patient_id)) ; //change status on nurse and room allocation
					}
				}
			}
		}
		if (empty($this->request->data['Appointment']['patient_id'])) {
			$this->set('dateSearch','1');
			if(!empty($this->params->query['dateFrom'])&&!empty($this->params->query['dateTo'])){
				$dateFrom = explode(' ',$this->DateFormat->formatDate2STD($this->params->query['dateFrom'],Configure::read('date_format')));
				$dateTo = explode(' ',$this->DateFormat->formatDate2STD($this->params->query['dateTo'],Configure::read('date_format')));
				$conditionFrom=array('Appointment.date >='=>$dateFrom[0]);
				$conditionDateTo=array('Appointment.date <='=>$dateTo[0]);
			}else if(!empty($this->params->query['dateFrom']) && empty($this->params->query['dateTo'])){
				$dateFrom = explode(' ',$this->DateFormat->formatDate2STD($this->params->query['dateFrom'],Configure::read('date_format')));
				$conditionFrom=array('Appointment.date >='=>$dateFrom[0]);
				$conditionDateTo=array('Appointment.date <='=>date('Y-m-d'));
			}else if(empty($this->params->query['dateFrom']) && !empty($this->params->query['dateTo'])){
				$dateTo = explode(' ',$this->DateFormat->formatDate2STD($this->params->query['dateTo'],Configure::read('date_format')));
				$conditionFrom=array('Appointment.date >='=>date('Y-m-d'));
				$conditionDateTo=array('Appointment.date <='=>$dateTo[0]);
			}
			else if(empty($this->params->query['dateFrom']) && empty($this->params->query['dateTo'])){
				$date[0] = date('Y-m-d');
			}
		}
		$role = $this->Session->read('role');
		if($role == Configure::read('doctorLabel') || $role==Configure::read('residentLabel')){
			$conditionDoctor = array('Appointment.doctor_id'=>$this->Session->read('userid'));

		}
		if($this->request->params['pass'][0] == Configure::read('nurseLabel')){
			$nurseCondition = 'Appointment.nurse_id='.$this->Session->read('userid');
			$this->set('viewAll','0');

		}
		else{
			$this->set('viewAll','1');
		}
		
		
		//To get Mandatory Service Id
		$this->ServiceCategory->unbindModel(array('hasMany'=>array('ServiceSubCategory')));		
		$paymentCategoryId=$this->ServiceCategory->find('first',array('fields'=>array('id'),'conditions'=>array('ServiceCategory.name Like'=>Configure::read('mandatoryServices'))));
		
		//tariff List Private Id
		$privateID = $this->TariffStandard->getPrivateTariffID();//retrive private ID
		$this->set('privateId',$privateID);
		$this->Appointment->bindModel(array(
				'belongsTo' => array(
						'User' =>array('foreignKey'=>'doctor_id'),
						'Patient'=>array('foreignKey'=>'patient_id','type'=>'INNER','conditions'=>array('Patient.is_deleted=0'/*,'Patient.is_discharge=0'*/)),
						'TariffStandard'=>array('foreignKey'=>false,'conditions'=>array('TariffStandard.id=Patient.tariff_standard_id')),
						'Person'=>array('foreignKey'=>false,'conditions'=>array('Person.id=Patient.person_id')),
						'Diagnosis'=>array('foreignKey'=>false,'conditions'=>array('Diagnosis.patient_id=Patient.id','Diagnosis.is_discharge'=>0)),/*
						'FinalBilling'=>array('foreignKey'=>false,'conditions'=>array('FinalBilling.patient_id=Patient.id')),*/
						'Billing'=>array('foreignKey'=>false,'conditions'=>array('Billing.patient_id=Patient.id')),
						'Note'=>array('foreignKey'=>false,'conditions'=>array('Note.patient_id=Patient.id')),
					 ),
				'hasmany'=>array()
				),false); //hasmany for future appt.

						$this->paginate = array(
								'update' => '#list_content',
								'evalScripts' => true
						);
                           
						$conditionIsDeleted = array('Appointment.is_deleted'=>'0');
						$conditionStatus = array('Appointment.status !='=>'Closed');
						//by pankaj w for vadodara only
						if($this->Session->read('website.instance')=='vadodara'){
							$conditionLocation = array();
						}else{
							$conditionLocation = array('Appointment.location_id'=>$this->Session->read('locationid'));
						}
						//doctor filter (click on tabs)
						//if (!empty($this->request->data['Appointment']['All Doctors'])) {
						/* if (!empty($this->request->data['Appointment']['doctor_id'])) {
						$conditionsDoc = array('Appointment.doctor_id'=>$this->request->data['Appointment']['doctor_id']);
						} */


						if (!empty($this->request->data['Appointment']['patient_id'])) {
							//To find the list of all the patient having name like searched name
							//$patientIds=$this->Patient->find('list',array('fields'=>array('id'),'conditions'=>array('Patient.lookup_name LIKE'=>'%'.$this->request->data['Appointment']['patient_name'].'%')));
							$conditionPatientId =array('Appointment.patient_id'=>$this->request->data['Appointment']['patient_id']);

						}
						if($this->params->query['doctorsId']){
							/* foreach($this->request->data as $key=>$value){
								if($key=='context-menu-input-'.$value){
							$doctorArray[]=$value;
							}
							} */
							$docArray=explode('_',$this->params->query['doctorsId']);
							$docArray=implode(',',$docArray);
							if(!empty($docArray)){
								$conditionDoctor=array('Appointment.doctor_id IN ('.$docArray.")");
							}
							$rt='1';
							$this->set('rtSelect',$rt);
						}
						if($future_apt == 'future'||!empty($this->request->data['Appointment']['patient_id'])||$this->params->query['doctorsId']||!empty($this->params->query['dateFrom'])||!empty($this->params->query['dateTo'])){
							$conditions=array($conditionDoctor,$conditionIsDeleted/*,$conditionStatus*/,$conditionLocation,$conditionPatientId,$nurseCondition,$conditionDateTo,$conditionFrom);
						}
						else{
							$conditions=array($conditionDoctor,$conditionIsDeleted,$conditionStatus,$conditionLocation,$conditionPatientId,$nurseCondition);

						}
						//To Show Today's Closed Appointment
						if($this->params->query['closed']=='closed')//for pagination
							$future_apt='closed';
						
						if($future_apt== 'closed'){
							$conditionStatus=array('Appointment.status '=>'Closed');
							$conditions=array($conditionDoctor,$conditionIsDeleted,$conditionStatus,$conditionLocation,$conditionPatientId,$nurseCondition);
						}
						
						
						
						if($future_apt == 'closed'){
							$this->Appointment->bindModel(array(
									'belongsTo' => array(
											'User' =>array('foreignKey'=>'doctor_id'),
											'Patient'=>array('foreignKey'=>'patient_id','type'=>'INNER','conditions'=>array('Patient.is_deleted=0'/*,'Patient.is_discharge=0'*/)),
											'TariffStandard'=>array('foreignKey'=>false,'conditions'=>array('TariffStandard.id=Patient.tariff_standard_id')),
											'Person'=>array('foreignKey'=>false,'conditions'=>array('Person.id=Patient.person_id')),
											'Diagnosis'=>array('foreignKey'=>false,'conditions'=>array('Diagnosis.patient_id=Patient.id','Diagnosis.is_discharge'=>0)),/*
											'FinalBilling'=>array('foreignKey'=>false,'conditions'=>array('FinalBilling.patient_id=Patient.id')),*/
											'Billing'=>array('foreignKey'=>false,'conditions'=>array('Billing.patient_id=Patient.id')),
											'Note'=>array('foreignKey'=>false,'conditions'=>array('Note.patient_id=Patient.id')),
											 ),
									'hasmany'=>array()
							),false); //hasmany for future appt.
							$conditions = array_merge($conditions,array('Appointment.date '=>date('Y-m-d')));
							
							$this->paginate = array(
									'limit' => '8',
									'order' => array('Appointment.token_no' => 'DESC'),
									'fields'=> array('Appointment.*','concat(User.first_name," ",User.last_name) as full_name','Patient.id','Patient.patient_id','Patient.person_id','Patient.age',
											'Patient.admission_id','Patient.epenImages','Patient.lookup_name','Person.vip_chk',
											'Patient.nurse_id','Person.mobile','Person.dob','Person.email','Person.ssn_us','Person.patient_credentials_created_date','Person.patient_uid' ,
											'Patient.tariff_standard_id','TariffStandard.name',
											'Person.id','Person.sex',/*'VerifyMedicationOrder.id',*/'Patient.is_opd','Billing.patient_id','Billing.total_amount',
											'SUM(Billing.amount_pending) as amount_pending','SUM(Billing.amount) as amount_paid','SUM(Billing.discount) as discount',
											'SUM(Billing.paid_to_patient) as refund','Person.photo','Person.patient_credentials_created_date','Person.patient_uid','Diagnosis.id',/*'Count(Note.id) as noteCount','Note.has_no_followup',*/'Note.id'
											 ),
									'conditions'=>$conditions,'group'=>array('Appointment.patient_id'),

							);

							$this->set('closed',$future_apt);
						}else if($future_apt == 'future'){
							if (empty($this->request->data['Appointment']['patient_id'])) {
								if(strtotime($date[0]) > strtotime(date('Y-m-d'))){
									$conditions = array_merge($conditions,array('Appointment.date'=>$date[0]));
								}else{
									$conditions = array_merge($conditions,array('Appointment.date >'=>date('Y-m-d')));
								}
							}

							$this->paginate = array(
									'limit' => 8,
									'order' => array('Appointment.token_no' => 'DESC'),
									'fields'=> array('Appointment.*','concat(User.first_name," ",User.last_name) as full_name',
											'Patient.patient_id','Patient.person_id','Patient.lookup_name',
											'Person.mobile','Person.email','Person.dob','Person.patient_credentials_created_date',
											'Person.patient_uid' ,'Person.id','Person.sex','Person.patient_credentials_created_date','Note.id'
											/*'NewInsurance.*','Encounter.*','Note.*'*/),
									'conditions'=>$conditions,'group'=>array('Appointment.id')
									//'DATE_FORMAT(Appointment.create_time,"%b %d %Y")'=>date('Y-m-d'),
							);

							$this->set('future',$future_apt);
						}else{
							
							if(!empty($this->params->query['data']['Appointment']['date_from'])){
								$condiDate = $this->DateFormat->formatDate2STD($this->params->query['data']['Appointment']['date_from'],Configure::read('date_format'));
								$dateSearched=$this->params->query['data']['Appointment']['date_from'];
								$this->set('dateSearched',$dateSearched);
							}
							if (empty($this->request->data['Appointment']['patient_id'])) {
								//Edited by-Pooja (Please confirm before editing)
								if(!empty($dateFrom) && !empty($dateTo)){
									$todayCondition = $conditions;
								}
								else if(!empty($dateFrom)){
									$todayCondition = $conditions;
								}else if(!empty($dateTo)){
									$todayCondition = $conditions;
								}else{
									$todayCondition = array_merge($conditions,array('Appointment.date'=>$date[0]));
								}
								
							}elseif(!empty($this->request->data['Appointment']['patient_id']) && $this->request->data['Appointment']['Discharged']=='1'){
								// following cond added by atul
								$conditionIsDischarge = array(array('Appointment.status'=>'Closed'));
								$todayCondition=array_merge($conditions,$conditionIsDischarge);						
							}else if(!empty($this->request->data['Appointment']['patient_id'])){
								$conditionIsDischarge = array(array('Appointment.status NOT'=>'Closed'));
								$todayCondition=array_merge($conditions,$conditionIsDischarge);	
							}
							/*elseif(!empty($this->request->data['Appointment']['patient_id'])){
								$todayCondition=$conditions;
							}*/
							$role=$this->Session->read('role');
							if($role==Configure::read('doctorLabel')||$role==Configure::read('nurseLabel') || $role==Configure::read('medicalAssistantLabel') || $role==Configure::read('residentLabel'))
							{
								if(!empty($dateFrom) && !empty($dateTo)){
									$order= 'Note.sign_note asc' ; //for keyword order "Sign Note"
								}
								else{
									$order= "IF(instr(Appointment.status, 'In-Progress'), instr(Appointment.status, 'In-Progress'), 65535) asc" ; //for keyword order "In-Progress"
								}
							}
							else{
								//Order by for ordering the in the status in sequence of Arrived, Scheduled, Assigned, and Seen - Pooja ///
								/*$order="(CASE Appointment.status
										WHEN 'Arrived' 	 THEN 1
										WHEN 'Ready' 	 THEN 2
										WHEN 'Scheduled' THEN 3
										WHEN 'Pending' 	 THEN 4
										WHEN 'Assigned'  THEN 5
										WHEN 'Seen' THEN 6
										ELSE 100 END) ASC, Appointment.status DESC";*/
								//$order="IF(instr(Appointment.status, 'Arrived'), instr(Appointment.status, 'Arrived'), 65535) asc" ; //for keyword order 'Arrived'
							}
							if($this->Session->read('website.instance')=='kanpur' && $this->Session->read('role') == Configure::read('doctorLabel')){  //to remove limit from kanpur---Mahalaxmi
								$getLimit='1000';
							}else{
								$getLimit='15';
							}
																					
							if($condiDate)
								$todayCondition['Appointment.date']=$condiDate;
							
							$this->paginate = array(
									'limit' =>$getLimit,
									'order' => array('Appointment.token_no' => 'DESC'),
									'fields'=> array('Appointment.*','concat(User.first_name," ",User.last_name) as full_name',
											'Patient.id','Patient.patient_id','Patient.person_id','Patient.age',
											'Patient.admission_id','Patient.lookup_name','Patient.epenImages',
										    'Person.vip_chk','TariffStandard.name',
											'Patient.nurse_id','Person.mobile','Person.dob','Person.email','Person.ssn_us',
											'Person.patient_credentials_created_date','Person.patient_uid' ,
											'Patient.tariff_standard_id',
											'Person.id','Person.sex',/*'VerifyMedicationOrder.id',*/'Patient.is_opd',
											'Billing.total_amount','Billing.patient_id',
											'SUM(Billing.amount_pending) as amount_pending','SUM(Billing.amount) as amount_paid',
											'SUM(Billing.discount) as discount',
											'SUM(Billing.paid_to_patient) as refund',
											'Person.photo','Person.patient_credentials_created_date',
											'Person.patient_uid','Note.id','Diagnosis.id'/*'Count(Note.id) as noteCount','Note.has_no_followup',
											'Count(Diagnosis.id) as initCount','Diagnosis.id','Diagnosis.flag_event','Count(FinalBilling.id) as paidCount',
											'NewCropPrescriptionAlias.id',
											'NewCropPrescriptionAlias.is_med_administered','NewCropPrescription.id','NewCropPrescription.is_med_administered',
											'Count(NewCropPrescription.id)as medication','Encounter.id','NewInsurance.is_eligible','Note.id','Note.sign_note'*/ ),
											'conditions'=>$todayCondition,'group'=>array('Appointment.patient_id'),
											//'order'=>$order
											//'DATE_FORMAT(Appointment.create_time,"%b %d %Y")'=>date('Y-m-d'),
							);
							
						}
						$nurses  = $this->User->getUsersByRoleName(Configure::read('nurseLabel')) ;
						$this->set('nurses',$nurses);
						$chamberList = $this->Chamber->getChamberList();
						$this->set('id',$patient_id);
						$data = $this->paginate('Appointment') ; //debug($data); exit;
						$this->set('count',COUNT($data)); //Counting the data in appointment table
						// lab Rad count ---- BOF Gaurav
						
					if($future_apt != 'future' && !empty($data)){
							foreach($data as $patientKey => $patientValue){
								$ids[] = $patientValue['Patient']['id'] ;
							}
							$idsStr = implode(",",$ids) ;
							
							if(!empty($data)){
								// Initialize $ids and $customArray
								foreach($data as $patientKey => $patientValue){
									$ids[] = $patientValue['Patient']['id'];
									$customArray[$patientValue['Patient']['id']]['Patient'] = $patientValue;			
								}
								$idsStr = implode(",", $ids);
								
								// Fetch lab and radiology orders and results
								$labOrderData = $this->LaboratoryTestOrder->find('all', array(
									'fields' => array('Count(*) as lab', 'patient_id'),
									'conditions' => array("LaboratoryTestOrder.patient_id IN ($idsStr)"),
									'group' => array('LaboratoryTestOrder.patient_id')
								));
								
								$radOrderData = $this->RadiologyTestOrder->find('all', array(
									'fields' => array('Count(*) as rad', 'patient_id'),
									'conditions' => array("RadiologyTestOrder.patient_id IN ($idsStr)"),
									'group' => array('RadiologyTestOrder.patient_id')
								));
							
								$labResultData = $this->LaboratoryResult->find('all', array(
									'fields' => array('Count(*) as labResult', 'patient_id'),
									'conditions' => array("LaboratoryResult.patient_id IN ($idsStr)"),
									'group' => array('LaboratoryResult.patient_id')
								));
								
	
								$radResultData = $this->RadiologyResult->find('all', array(
									'fields' => array('Count(*) as radResult', 'patient_id'),
									'conditions' => array("RadiologyResult.patient_id IN ($idsStr)"),
									'group' => array('RadiologyResult.patient_id')
								));
							
								// Populate the $customArray with fetched data
								foreach($labOrderData as $labKey => $labValue){
									$customArray[$labValue['LaboratoryTestOrder']['patient_id']]['LaboratoryTestOrder'] = $labValue[0];
								}
								foreach($radOrderData as $labKey => $labValue){
									$customArray[$labValue['RadiologyTestOrder']['patient_id']]['RadiologyTestOrder'] = $labValue[0];
								}
								foreach($labResultData as $labKey => $labValue){
									$customArray[$labValue['LaboratoryResult']['patient_id']]['LaboratoryResult'] = $labValue[0];
								}
								foreach($radResultData as $labKey => $labValue){
									$customArray[$labValue['RadiologyResult']['patient_id']]['RadiologyResult'] = $labValue[0];
								}
							
								// Fetch doctors and nurses
								$doctors = $this->User->getDoctorsByLocation($this->Session->read('locationid'));
								$nurses = $this->User->getUsersByRoleName(Configure::read('nurseLabel'));
							}
						}
							$this->set('customArray', $customArray); 
						
						$opddoctors = $this->User->getOpdDoctors();
						$this->set('doctors',$opddoctors);
						$this->set(array('data'=>$data,'chambers'=>$chamberList,
								/*'referalCount'=>$refererCount,'referSpecialist'=>$referalSpecialist,
								 * 'referSpeciality'=>$referalSpeciality*/));
							
						//for fingerprint device
						/*$this->loadModel('Configuration');
						$isFingerPrintEnable = $this->Configuration->find('first',array('conditions'=>array('name'=>'isFingerPrintEnable')));
						$this->set('isFingerPrintEnable',$isFingerPrintEnable['Configuration']['value']);
							
						//Schedule count
						$this->Appointment->unbindModel(array('belongsTo' => array(
											'User' ,'Patient','TariffStandard','Person','Billing')));
						
						$schedule=$this->Appointment->find('all',array('fields'=>array('COUNT(Appointment.id)as scheCount',
								'Appointment.patient_id'),
								'conditions'=>array('Appointment.date >'=>date('Y-m-d'),
										'Appointment.is_deleted'=>'0'),'group'=>array('Appointment.patient_id')));
						$this->set('schedule',$schedule);*/
							
						/**
						 * redirecting to shortdashboard for users other than doctor or nurse
						 * pooja
						 *
						*/
						if($this->Session->read('website.instance')=='vadodara' && ($role != Configure::read('doctorLabel') && $role != Configure::read('nurseLabel'))){
							$this->render('appointment_short_dashboard');
						}
							
					 
					 
						
						$this->set('criticalArray',$criticalArray);
						 
						
						
	}
	//FOR DASHBOARD SLIDESHOW
	public function appointment_dashboard_slide_two($future_apt=null,$patient_id=null,$opt=null,$aptId=null){
		//$this->layout = 'ajax';
		$this->uses = array('Chamber','User','Patient','Note','NoteDiagnosis','LaboratoryResult','ServiceCategory',
				'LaboratoryTestOrder','RadiologyTestOrder','RadiologyResult','ReferralToSpecialist','TariffStandard');
		if(!empty($this->request->data)){
			if($opt=='nurse'){
				//for nurse update
				//find  room is allocated already
				$isRoomAllot = $this->Appointment->find('first',array('fields'=>array('Appointment.chamber_id','Appointment.status'),'conditions'=>array('Appointment.id'=>$aptId)));
				$nurse_id= $this->request->data['value'];
				$this->Appointment->updateAll(array('Appointment.nurse_id'=>"'$nurse_id'"),array('Appointment.id'=> $aptId));
				if(/*!empty($isRoomAllot['Appointment']['chamber_id']) && */!empty($nurse_id)){
					if($isRoomAllot['Appointment']['status']=='In-Progress'){
						$status="'In-Progress'";
					}
					else if($statusCheck['Appointment']['status']=='Seen'){
						$status="'Seen'";
					}
					else if($statusCheck['Appointment']['status']=='Closed'){
						$status="'Closed'";
					}
					else{
						$status="'Assigned'";
					}
					$this->Appointment->updateAll(array('status'=>$status),array('Appointment.id'=>$aptId)) ; //change status on nurse and room allocation
					//$this->redirect('appointment_dashboard') ;
				}else if(empty($nurse_id)){
					$this->Appointment->updateAll(array('status'=>"'Arrived'"),array('Appointment.id'=>$aptId)) ; //change status on nurse and room allocation
				}
				//EOF check
			}elseif($opt=='room'){//room allocation
				{	//for room cond $patient_id is the appointment's ID
					$room_id=$this->request->data['value'];
					//EOF check
					$this->Appointment->bindModel(array(
							'hasOne' => array(
									'TariffList' =>array('foreignKey'=>false,'conditions'=>array('TariffList.id = Appointment.visit_type')))));
					$statusCheck=$this->Appointment->find('first',array('fields'=>array('Appointment.status','Appointment.nurse_id',
							'Appointment.token_no','TariffList.code_name'),
							'conditions'=>array('Appointment.id'=>$patient_id)));
					if(empty($statusCheck['Appointment']['token_no'])){
						$count = $this->Appointment->find('count',array('conditions'=>array(
								'Appointment.date '=> date("Y-m-d"),'token_no !=' => null)));
						$statusCheck['Appointment']['token_no'] = $count+1;
					}
					if($statusCheck['TariffList']['code_name'] == "Physiotherapy/Direct OPD")
						$statusCheck['Appointment']['token_no'] = null;
					$this->Appointment->updateAll(array('Appointment.chamber_id'=>"'$room_id'",
							'Appointment.token_no'=>$statusCheck['Appointment']['token_no']),
							array('Appointment.id'=>$patient_id));
					if(!empty($statusCheck['Appointment']['nurse_id']) && !empty($room_id)){
						if($statusCheck['Appointment']['status']=='In-Progress'){
							$status="'In-Progress'";
						}
						else if($statusCheck['Appointment']['status']=='Seen'){
							$status="'Seen'";
						}
						else if($statusCheck['Appointment']['status']=='Closed'){
							$status="'Closed'";
						}
						else{
							$status="'Assigned'";
						}
						$this->Appointment->updateAll(array('status'=>$status),array('Appointment.id'=>$patient_id)) ; //change status on nurse and room allocation
						//$this->redirect('appointment_dashboard') ;
					}else if(empty($room_id)){
						$this->Appointment->updateAll(array('status'=>"'Arrived'"),array('Appointment.id'=>$patient_id)) ; //change status on nurse and room allocation
					}
				}
			}
		}
		if (empty($this->request->data['Appointment']['patient_id'])) {
			$this->set('dateSearch','1');
			if(!empty($this->params->query['dateFrom'])&&!empty($this->params->query['dateTo'])){
				$dateFrom = explode(' ',$this->DateFormat->formatDate2STD($this->params->query['dateFrom'],Configure::read('date_format')));
				$dateTo = explode(' ',$this->DateFormat->formatDate2STD($this->params->query['dateTo'],Configure::read('date_format')));
				$conditionFrom=array('Appointment.date >='=>$dateFrom[0]);
				$conditionDateTo=array('Appointment.date <='=>$dateTo[0]);
			}else if(!empty($this->params->query['dateFrom']) && empty($this->params->query['dateTo'])){
				$dateFrom = explode(' ',$this->DateFormat->formatDate2STD($this->params->query['dateFrom'],Configure::read('date_format')));
				$conditionFrom=array('Appointment.date >='=>$dateFrom[0]);
				$conditionDateTo=array('Appointment.date <='=>date('Y-m-d'));
			}else if(empty($this->params->query['dateFrom']) && !empty($this->params->query['dateTo'])){
				$dateTo = explode(' ',$this->DateFormat->formatDate2STD($this->params->query['dateTo'],Configure::read('date_format')));
				$conditionFrom=array('Appointment.date >='=>date('Y-m-d'));
				$conditionDateTo=array('Appointment.date <='=>$dateTo[0]);
			}
			else if(empty($this->params->query['dateFrom']) && empty($this->params->query['dateTo'])){
				$date[0] = date('Y-m-d');
			}
		}
		$role = $this->Session->read('role');
		if($role == Configure::read('doctorLabel') || $role==Configure::read('residentLabel')){
			$conditionDoctor = array('Appointment.doctor_id'=>$this->Session->read('userid'));

		}
		if($this->request->params['pass'][0] == Configure::read('nurseLabel')){
			$nurseCondition = 'Appointment.nurse_id='.$this->Session->read('userid');
			$this->set('viewAll','0');

		}
		else{
			$this->set('viewAll','1');
		}
		
		//To get Mandatory Service Id
		$this->ServiceCategory->unbindModel(array('hasMany'=>array('ServiceSubCategory')));		
		$paymentCategoryId=$this->ServiceCategory->find('first',array('fields'=>array('id'),'conditions'=>array('ServiceCategory.name Like'=>Configure::read('mandatoryServices'))));
		
		//tariff List Private Id
		$privateID = $this->TariffStandard->getPrivateTariffID();//retrive private ID
		$this->set('privateId',$privateID);
		$this->Appointment->bindModel(array(
				'belongsTo' => array(
						'User' =>array('foreignKey'=>'doctor_id'),
						'Patient'=>array('foreignKey'=>'patient_id','type'=>'INNER','conditions'=>array('Patient.is_deleted=0'/*,'Patient.is_discharge=0'*/)),
						'TariffStandard'=>array('foreignKey'=>false,'conditions'=>array('TariffStandard.id=Patient.tariff_standard_id')),
						'Person'=>array('foreignKey'=>false,'conditions'=>array('Person.id=Patient.person_id')),
						/*'Diagnosis'=>array('foreignKey'=>false,'conditions'=>array('Diagnosis.patient_id=Patient.id','Diagnosis.is_discharge'=>0)),
						'FinalBilling'=>array('foreignKey'=>false,'conditions'=>array('FinalBilling.patient_id=Patient.id')),*/
						'Billing'=>array('foreignKey'=>false,'conditions'=>array('Billing.patient_id=Patient.id')),
						/*'NewCropPrescription'=>array('foreignKey'=>false,
								'conditions'=>array('NewCropPrescription.patient_uniqueid =Patient.id','NewCropPrescription.archive'=>'N','NewCropPrescription.is_med_administered'=>'1')),
						"NewCropPrescriptionAlias"=>array('className'=>'NewCropPrescription',"foreignKey"=>false ,
								'conditions'=>array('NewCropPrescriptionAlias.patient_uniqueid =Patient.id','NewCropPrescriptionAlias.archive'=>'N','NewCropPrescriptionAlias.is_med_administered'=>'2')),
						'NewInsurance'=>array('foreignKey'=>false,
								'conditions'=>array('NewInsurance.patient_id =Patient.id')),
						'Encounter'=>array('foreignKey'=>false,
								'conditions'=>array('Encounter.patient_id =Patient.id')),
						'Note'=>array('foreignKey'=>false,
								'conditions'=>array('Note.patient_id =Patient.id')),
						'VerifyMedicationOrder'=>array('foreignKey'=>false,
								'conditions'=>array('VerifyMedicationOrder.patient_id =Patient.id'))*/),
				'hasmany'=>array()
				),false); //hasmany for future appt.

						$this->paginate = array(
								'update' => '#list_content',
								'evalScripts' => true
						);
                           
						$conditionIsDeleted = array('Appointment.is_deleted'=>'0');
						$conditionStatus = array('Appointment.status !='=>'Closed');
						//by pankaj w for vadodara only
						if($this->Session->read('website.instance')=='vadodara'){
							$conditionLocation = array();
						}else{
							$conditionLocation = array('Appointment.location_id'=>$this->Session->read('locationid'));
						}
						//doctor filter (click on tabs)
						//if (!empty($this->request->data['Appointment']['All Doctors'])) {
						/* if (!empty($this->request->data['Appointment']['doctor_id'])) {
						$conditionsDoc = array('Appointment.doctor_id'=>$this->request->data['Appointment']['doctor_id']);
						} */


						if (!empty($this->request->data['Appointment']['patient_id'])) {
							//To find the list of all the patient having name like searched name
							//$patientIds=$this->Patient->find('list',array('fields'=>array('id'),'conditions'=>array('Patient.lookup_name LIKE'=>'%'.$this->request->data['Appointment']['patient_name'].'%')));
							$conditionPatientId =array('Appointment.patient_id'=>$this->request->data['Appointment']['patient_id']);

						}
						if($this->params->query['doctorsId']){
							/* foreach($this->request->data as $key=>$value){
								if($key=='context-menu-input-'.$value){
							$doctorArray[]=$value;
							}
							} */
							$docArray=explode('_',$this->params->query['doctorsId']);
							$docArray=implode(',',$docArray);
							if(!empty($docArray)){
								$conditionDoctor=array('Appointment.doctor_id IN ('.$docArray.")");
							}
							$rt='1';
							$this->set('rtSelect',$rt);
						}
						if($future_apt == 'future'||!empty($this->request->data['Appointment']['patient_id'])||$this->params->query['doctorsId']||!empty($this->params->query['dateFrom'])||!empty($this->params->query['dateTo'])){
							$conditions=array($conditionDoctor,$conditionIsDeleted/*,$conditionStatus*/,$conditionLocation,$conditionPatientId,$nurseCondition,$conditionDateTo,$conditionFrom);
						}
						else{
							$conditions=array($conditionDoctor,$conditionIsDeleted,$conditionStatus,$conditionLocation,$conditionPatientId,$nurseCondition);

						}
						//To Show Today's Closed Appointment
						if($this->params->query['closed']=='closed')//for pagination
							$future_apt='closed';
						
						if($future_apt== 'closed'){
							$conditionStatus=array('Appointment.status '=>'Closed');
							$conditions=array($conditionDoctor,$conditionIsDeleted,$conditionStatus,$conditionLocation,$conditionPatientId,$nurseCondition);
						}
						
						
						
						if($future_apt == 'closed'){
							$this->Appointment->bindModel(array(
									'belongsTo' => array(
											'User' =>array('foreignKey'=>'doctor_id'),
											'Patient'=>array('foreignKey'=>'patient_id','type'=>'INNER','conditions'=>array('Patient.is_deleted=0'/*,'Patient.is_discharge=0'*/)),
											'TariffStandard'=>array('foreignKey'=>false,'conditions'=>array('TariffStandard.id=Patient.tariff_standard_id')),
											'Person'=>array('foreignKey'=>false,'conditions'=>array('Person.id=Patient.person_id')),
											/*'Diagnosis'=>array('foreignKey'=>false,'conditions'=>array('Diagnosis.patient_id=Patient.id','Diagnosis.is_discharge'=>0)),
											'FinalBilling'=>array('foreignKey'=>false,'conditions'=>array('FinalBilling.patient_id=Patient.id')),*/
											'Billing'=>array('foreignKey'=>false,'conditions'=>array('Billing.patient_id=Patient.id')),
											/*'NewCropPrescription'=>array('foreignKey'=>false,
													'conditions'=>array('NewCropPrescription.patient_uniqueid =Patient.id','NewCropPrescription.archive'=>'N','NewCropPrescription.is_med_administered'=>'1')),
											"NewCropPrescriptionAlias"=>array('className'=>'NewCropPrescription',"foreignKey"=>false ,
													'conditions'=>array('NewCropPrescriptionAlias.patient_uniqueid =Patient.id','NewCropPrescriptionAlias.archive'=>'N','NewCropPrescriptionAlias.is_med_administered'=>'2')),
											'NewInsurance'=>array('foreignKey'=>false,
													'conditions'=>array('NewInsurance.patient_id =Patient.id')),
											'Encounter'=>array('foreignKey'=>false,
													'conditions'=>array('Encounter.patient_id =Patient.id')),
											'Note'=>array('foreignKey'=>false,
													'conditions'=>array('Note.patient_id =Patient.id')),
											'VerifyMedicationOrder'=>array('foreignKey'=>false,
													'conditions'=>array('VerifyMedicationOrder.patient_id =Patient.id'))*/),
									'hasmany'=>array()
							),false); //hasmany for future appt.
							$conditions = array_merge($conditions,array('Appointment.date '=>date('Y-m-d')));
							
							$this->paginate = array(
									'limit' => '8',
									'order' => array('Appointment.start_time' => 'desc'),
									'fields'=> array('Appointment.*','concat(User.first_name," ",User.last_name) as full_name','Patient.id','Patient.patient_id','Patient.person_id','Patient.age',
											'Patient.admission_id','Patient.epenImages','Patient.lookup_name','Person.vip_chk',
											'Patient.nurse_id','Person.mobile','Person.dob','Person.email','Person.ssn_us','Person.patient_credentials_created_date','Person.patient_uid' ,
											'Patient.tariff_standard_id','TariffStandard.name',
											'Person.id','Person.sex',/*'VerifyMedicationOrder.id',*/'Patient.is_opd','Billing.patient_id','Billing.total_amount',
											'SUM(Billing.amount_pending) as amount_pending','SUM(Billing.amount) as amount_paid','SUM(Billing.discount) as discount',
											'SUM(Billing.paid_to_patient) as refund','Person.photo','Person.patient_credentials_created_date','Person.patient_uid',/*'Count(Note.id) as noteCount','Note.has_no_followup',*/
											/*'Count(Diagnosis.id) as initCount','Diagnosis.id','Diagnosis.flag_event','Count(FinalBilling.id) as paidCount','NewCropPrescriptionAlias.id',
											/*'NewCropPrescriptionAlias.is_med_administered','NewCropPrescription.id','NewCropPrescription.is_med_administered',
											'Count(NewCropPrescription.id)as medication','Encounter.id','NewInsurance.is_eligible','Note.id','Note.sign_note'*/),
									'conditions'=>$conditions,'group'=>array('Appointment.patient_id'),

							);

							$this->set('closed',$future_apt);
						}else if($future_apt == 'future'){
							if (empty($this->request->data['Appointment']['patient_id'])) {
								if(strtotime($date[0]) > strtotime(date('Y-m-d'))){
									$conditions = array_merge($conditions,array('Appointment.date'=>$date[0]));
								}else{
									$conditions = array_merge($conditions,array('Appointment.date >'=>date('Y-m-d')));
								}
							}

							$this->paginate = array(
									'limit' => 8,
									'order' => array('Appointment.date' => 'ASC'),
									'fields'=> array('Appointment.*','concat(User.first_name," ",User.last_name) as full_name',
											'Patient.patient_id','Patient.person_id','Patient.lookup_name',
											'Person.mobile','Person.email','Person.dob','Person.patient_credentials_created_date',
											'Person.patient_uid' ,'Person.id','Person.sex','Person.patient_credentials_created_date',
											/*'NewInsurance.*','Encounter.*','Note.*'*/),
									'conditions'=>$conditions,'group'=>array('Appointment.id')
									//'DATE_FORMAT(Appointment.create_time,"%b %d %Y")'=>date('Y-m-d'),
							);

							$this->set('future',$future_apt);
						}else{
							if (empty($this->request->data['Appointment']['patient_id'])) {
								//Edited by-Pooja (Please confirm before editing)
								if(!empty($dateFrom) && !empty($dateTo)){
									$todayCondition = $conditions;
								}
								else if(!empty($dateFrom)){
									$todayCondition = $conditions;
								}else if(!empty($dateTo)){
									$todayCondition = $conditions;
								}else{
									$todayCondition = array_merge($conditions,array('Appointment.date'=>$date[0]));
								}
							}elseif(!empty($this->request->data['Appointment']['patient_id']) && $this->request->data['Appointment']['Discharged']=='1'){
								// following cond added by atul
								$conditionIsDischarge = array(array('Appointment.status'=>'Closed'));
								$todayCondition=array_merge($conditions,$conditionIsDischarge);						
							}else if(!empty($this->request->data['Appointment']['patient_id'])){
								$conditionIsDischarge = array(array('Appointment.status NOT'=>'Closed'));
								$todayCondition=array_merge($conditions,$conditionIsDischarge);	
							}
							/*elseif(!empty($this->request->data['Appointment']['patient_id'])){
								$todayCondition=$conditions;
							}*/
							$role=$this->Session->read('role');
							if($role==Configure::read('doctorLabel')||$role==Configure::read('nurseLabel') || $role==Configure::read('medicalAssistantLabel') || $role==Configure::read('residentLabel'))
							{
								if(!empty($dateFrom) && !empty($dateTo)){
									$order= 'Note.sign_note asc' ; //for keyword order "Sign Note"
								}
								else{
									$order= "IF(instr(Appointment.status, 'In-Progress'), instr(Appointment.status, 'In-Progress'), 65535) asc" ; //for keyword order "In-Progress"
								}
							}
							else{
								//Order by for ordering the in the status in sequence of Arrived, Scheduled, Assigned, and Seen - Pooja ///
								/*$order="(CASE Appointment.status
										WHEN 'Arrived' 	 THEN 1
										WHEN 'Ready' 	 THEN 2
										WHEN 'Scheduled' THEN 3
										WHEN 'Pending' 	 THEN 4
										WHEN 'Assigned'  THEN 5
										WHEN 'Seen' THEN 6
										ELSE 100 END) ASC, Appointment.status DESC";*/
								//$order="IF(instr(Appointment.status, 'Arrived'), instr(Appointment.status, 'Arrived'), 65535) asc" ; //for keyword order 'Arrived'
							}
							if($this->Session->read('website.instance')=='kanpur' && $this->Session->read('role') == Configure::read('doctorLabel')){  //to remove limit from kanpur---Mahalaxmi
								$getLimit='1000';
							}else{
								$getLimit='8';
							}
							
							$this->paginate = array(
									'limit' =>$getLimit,
									'order' => array('Appointment.start_time' => 'desc'),
									'fields'=> array('Appointment.*','concat(User.first_name," ",User.last_name) as full_name',
											'Patient.id','Patient.patient_id','Patient.person_id','Patient.age',
											'Patient.admission_id','Patient.lookup_name','Patient.epenImages',
										    'Person.vip_chk','TariffStandard.name',
											'Patient.nurse_id','Person.mobile','Person.dob','Person.email','Person.ssn_us',
											'Person.patient_credentials_created_date','Person.patient_uid' ,
											'Patient.tariff_standard_id',
											'Person.id','Person.sex',/*'VerifyMedicationOrder.id',*/'Patient.is_opd',
											'Billing.total_amount','Billing.patient_id',
											'SUM(Billing.amount_pending) as amount_pending','SUM(Billing.amount) as amount_paid',
											'SUM(Billing.discount) as discount',
											'SUM(Billing.paid_to_patient) as refund',
											'Person.photo','Person.patient_credentials_created_date',
											'Person.patient_uid',/*'Count(Note.id) as noteCount','Note.has_no_followup',
											'Count(Diagnosis.id) as initCount','Diagnosis.id','Diagnosis.flag_event','Count(FinalBilling.id) as paidCount',
											'NewCropPrescriptionAlias.id',
											'NewCropPrescriptionAlias.is_med_administered','NewCropPrescription.id','NewCropPrescription.is_med_administered',
											'Count(NewCropPrescription.id)as medication','Encounter.id','NewInsurance.is_eligible','Note.id','Note.sign_note'*/ ),
											'conditions'=>$todayCondition,'group'=>array('Appointment.patient_id'),
											'order'=>$order
											//'DATE_FORMAT(Appointment.create_time,"%b %d %Y")'=>date('Y-m-d'),
							);
							
						}
						$nurses  = $this->User->getUsersByRoleName(Configure::read('nurseLabel')) ;
						$this->set('nurses',$nurses);
						$chamberList = $this->Chamber->getChamberList();
						$this->set('id',$patient_id);
						$data = $this->paginate('Appointment') ; //debug($data); exit;
						$this->set('count',COUNT($data)); //Counting the data in appointment table
						// lab Rad count ---- BOF Gaurav
						
						if($future_apt != 'future' && !empty($data)){
							foreach($data as $patientKey => $patientValue){
								$ids[] = $patientValue['Patient']['id'] ;
							}
							$idsStr = implode(",",$ids) ;
							
							/** Biiling data **/
							/*$this->loadModel('Billing');
							$billigData=$this->Billing->find('all',array('fields'=>array('Billing.total_amount','Billing.patient_id','SUM(Billing.amount) as paidAmount','SUM(Billing.discount) as discountAmount'),
									'conditions'=>array("Billing.patient_id IN ($idsStr)"),
									'group'=>array('Billing.patient_id')));
							
							foreach($billigData as $bill){
								$billData[$bill['Billing']['patient_id']]['total']=$bill['Billing']['total_amount'];
								$billData[$bill['Billing']['patient_id']]['paid']=$bill['0']['paidAmount'];
								$billData[$bill['Billing']['patient_id']]['discount']=$bill['0']['discountAmount'];
							}
							$this->set('billData',$billData);*/	
							
						}
						
						$opddoctors = $this->User->getOpdDoctors();
						$this->set('doctors',$opddoctors);
						$this->set(array('data'=>$data,'chambers'=>$chamberList,
								/*'referalCount'=>$refererCount,'referSpecialist'=>$referalSpecialist,
								 * 'referSpeciality'=>$referalSpeciality*/));
							
						//for fingerprint device
						/*$this->loadModel('Configuration');
						$isFingerPrintEnable = $this->Configuration->find('first',array('conditions'=>array('name'=>'isFingerPrintEnable')));
						$this->set('isFingerPrintEnable',$isFingerPrintEnable['Configuration']['value']);
							
						//Schedule count
						$this->Appointment->unbindModel(array('belongsTo' => array(
											'User' ,'Patient','TariffStandard','Person','Billing')));
						
						$schedule=$this->Appointment->find('all',array('fields'=>array('COUNT(Appointment.id)as scheCount',
								'Appointment.patient_id'),
								'conditions'=>array('Appointment.date >'=>date('Y-m-d'),
										'Appointment.is_deleted'=>'0'),'group'=>array('Appointment.patient_id')));
						$this->set('schedule',$schedule);*/
							
						/**
						 * redirecting to shortdashboard for users other than doctor or nurse
						 * pooja
						 *
						*/
						if($this->Session->read('website.instance')=='vadodara' && ($role != Configure::read('doctorLabel') && $role != Configure::read('nurseLabel'))){
							$this->render('appointment_short_dashboard');
						}
							
						if($future_apt != 'future' && !empty($data) && !empty($idsStr)){	
							/** Lab Code Start*/
							$this->LaboratoryTestOrder->bindModel(array(
									'belongsTo' => array(
											'LaboratoryResult' =>array('foreignKey'=>false,'conditions'=>array('LaboratoryResult.laboratory_test_order_id=LaboratoryTestOrder.id')),
											'LaboratoryHl7Result'=>array('foreignKey'=>false,'conditions'=>array('LaboratoryHl7Result.laboratory_result_id=LaboratoryResult.id')),
									)));
							$labData = $this->LaboratoryTestOrder->find('all',array('fields'=>array('LaboratoryTestOrder.id','LaboratoryTestOrder.patient_id','LaboratoryTestOrder.create_time',
									'LaboratoryHl7Result.id','LaboratoryHl7Result.abnormal_flag'),'conditions'=>array("LaboratoryTestOrder.patient_id IN ($idsStr)")));
							$labCount = array();
							foreach($labData as $labRecords){
								$difference = $this->DateFormat->dateDiff($labRecords['LaboratoryTestOrder']['create_time'],date('Y-m-d H:i:s')) ;
								$showFlag = (($difference->h >= 23 || $difference->d != 0) && empty($labRecords['LaboratoryHl7Result']['id'])) ? true : false;
								$labCount[$labRecords['LaboratoryTestOrder']['patient_id']][$labRecords['LaboratoryTestOrder']['id']]['showFlag'] = $showFlag;
								$flag = ($labRecords['LaboratoryHl7Result']['abnormal_flag']=='A' || $labRecords['LaboratoryHl7Result']['abnormal_flag']=='H' || $labRecords['LaboratoryHl7Result']['abnormal_flag']=='L')? true : false;
								$labCount[$labRecords['LaboratoryTestOrder']['patient_id']][$labRecords['LaboratoryTestOrder']['id']]['abnormalFlag'] = $flag;
								$isResulted = ($labRecords['LaboratoryHl7Result']['id'])? true : false;
								$labCount[$labRecords['LaboratoryTestOrder']['patient_id']][$labRecords['LaboratoryTestOrder']['id']]['is_Resulted'] = $isResulted;
							}
							$this->set('labCount',$labCount);
							/* end of lab start of Rad */
							$this->RadiologyTestOrder->bindModel(array(
									'belongsTo' => array(
											'RadiologyResult' =>array('foreignKey'=>false,'conditions'=>array('RadiologyResult.radiology_test_order_id=RadiologyTestOrder.id')),
									)));
							$radData = $this->RadiologyTestOrder->find('all',array('fields'=>array('RadiologyTestOrder.id','RadiologyTestOrder.patient_id','RadiologyTestOrder.create_time',
									'RadiologyResult.id','RadiologyResult.img_impression'),'conditions'=>array("RadiologyTestOrder.patient_id IN ($idsStr)")));
							$radCount = array();
							$showFlag = '';
							$isResulted = '';
							foreach($radData as $radRecords){
								$difference = $this->DateFormat->dateDiff($radRecords['RadiologyTestOrder']['create_time'],date('Y-m-d H:i:s')) ;
								$showFlag = (($difference->h >= 23 || $difference->d != 0) && empty($radRecords['RadiologyResult']['id'])) ? true : false;
								$radCount[$radRecords['RadiologyTestOrder']['patient_id']][$radRecords['RadiologyTestOrder']['id']]['showFlag'] = $showFlag;
								$isResulted = ($radRecords['RadiologyResult']['id'])? true : false;
								$radCount[$radRecords['RadiologyTestOrder']['patient_id']][$radRecords['RadiologyTestOrder']['id']]['is_Resulted'] = $isResulted;
								$flag = ($radRecords['RadiologyResult']['img_impression'] == 'Positive' || $radRecords['RadiologyResult']['img_impression'] == '' )? false : true;
								$radCount[$radRecords['RadiologyTestOrder']['patient_id']][$radRecords['RadiologyTestOrder']['id']]['abnormalFlag'] = $flag;
							}
							$this->set('radCount',$radCount);
							/** end of Rad */

						}
						//EOF lab and radiology
						//**********BOF Managed Critical Value
						if(!empty($data) /* && $future_apt != 'future' */){

							$this->LaboratoryResult->bindModel(array(
									'belongsTo'=>array('LaboratoryHl7Result'=>array('foreignKey'=>false,'conditions'=>array('LaboratoryResult.id = LaboratoryHl7Result.laboratory_result_id')))
							));
							$labResultData = $this->LaboratoryResult->find('all',array('fields'=>array('patient_id'),
									'conditions'=>array('OR'=>array(array('LaboratoryHl7Result.abnormal_flag'=>'A'),array('LaboratoryHl7Result.abnormal_flag'=>'L'),array('LaboratoryHl7Result.abnormal_flag'=>'H'))),
									'group'=>array('LaboratoryResult.patient_id')));
							foreach($labResultData as $criticalValue){
								$criticalArray[] = $criticalValue['LaboratoryResult']['patient_id'];
							}
						}
						
						$this->set('criticalArray',$criticalArray);
						//**********EOF Managed Critical Value
						/*$this->ReferralToSpecialist->bindModel(array('belongsTo'=>array(
								'Patient'=>array('foreignKey'=>'patient_id'))),false);
						if(!empty($idsStr)){
							$notSentReferrer=$this->ReferralToSpecialist->find('all',array('fields'=>array('ReferralToSpecialist.patient_id','ReferralToSpecialist.speciality_specialist','ReferralToSpecialist.specialist_name'),'conditions'=>array("ReferralToSpecialist.patient_id IN ($idsStr)",'ReferralToSpecialist.is_sent IN (0,1)')));
							$sentReferrer=$this->ReferralToSpecialist->find('all',array('fields'=>array('ReferralToSpecialist.patient_id','ReferralToSpecialist.speciality_specialist','ReferralToSpecialist.specialist_name'),'conditions'=>array("ReferralToSpecialist.patient_id IN ($idsStr)",'ReferralToSpecialist.is_sent=1')));
							foreach($notSentReferrer as $nSent){
								$refererCount[$nSent['ReferralToSpecialist']['patient_id']]['nCount']+=1;
								$referalSpeciality[$nSent['ReferralToSpecialist']['patient_id']][]= $nSent['ReferralToSpecialist']['speciality_specialist'];
								$referalSpecialist[$nSent['ReferralToSpecialist']['patient_id']][]= $nSent['ReferralToSpecialist']['specialist_name'];
								
							}
							foreach($sentReferrer as $ySent){
								$refererCount[$ySent['ReferralToSpecialist']['patient_id']]['yCount']+=1;
							}
						}*/
						
						
	}



	public function update_appointment_status($status,$field){
		$this->layout = 'ajax';
		$this->uses=array('Appointment','Patient','Chamber');
		if(!empty($this->request->data['id'])){
			if($field=='status'){
				$updateArray = array($field=>"'".$status."'") ;
				$options = array('Arrived'=>'Arrived','Assigned'=>'Assigned','In-Progress'=>'In-Progress','Seen'=>'Seen','Closed'=>'Closed');
				//array('In Lobby'=>'In Lobby','Pending'=>'Pending','In Room'=>'In Room','Seen'=>'Seen') ;
			}else if($field=='chamber_id' && $this->request->data['chamber']!=""){
				$updateArray = array($field=>"'".$status."'",'status'=>'""','seen_status'=>"'".'In Room'."'") ;
				$options =  array('In Room'=>'In Room :'.$this->request->data['chamber'],'Seen'=>'Seen') ;
			}else if($field=='seen_status' && $this->request->data['chamber']==""){
				$updateArray = array($field=>"'".$status."'",'status'=>'""') ;
				$options =  array('Schedule'=>'Schedule','Arrived'=>'Arrived','Assigned'=>'Assigned','In-Progress'=>'In-Progress','Seen'=>'Seen','Closed'=>'Closed');
			}else{
				echo "Something went wrong" ;
				exit;
			}

			if($status=='Arrived'){
				$time=$this->request->data['arrived_time'];
				$time=date('H:i',strtotime($time));
				$count = $this->Appointment->find('count',array('conditions'=>array('Appointment.date '=> date("Y-m-d"),'token_no !=' => null)));
				$this->Appointment->bindModel(array(
						'hasOne' => array(
								'TariffList' =>array('foreignKey'=>false,'conditions'=>array('TariffList.id = Appointment.visit_type')))));
				$token = $this->Appointment->find('first',array('fields'=>array('Appointment.token_no','TariffList.code_name'),
						'conditions'=>array('Appointment.id'=>$this->request->data['id'])));
				$chamberCount = $this->Chamber->find('first',array('fields'=>array('count(id) as count','id'),'conditions'=>array('Chamber.is_deleted'=> 0,
						'Chamber.location_id'=>$this->Session->read('locationid'))));
				$chamberId = ($chamberCount[0]['count'] == 1) ? $chamberCount['Chamber']['id'] : null;
				$tokenNo = ($token['Appointment']['token_no']) ? $token['Appointment']['token_no'] : $count+1;
				if($token['TariffList']['code_name'] == "Physiotherapy/Direct OPD"){
					$tokenNo = null;
				}
				$updateArray = array($field=>"'".$status."'",'Appointment.arrived_time'=>"'$time'",'Appointment.token_no'=>$tokenNo,'chamber_id'=>$chamberId) ;
			}
			else if($status=='Seen' || $status=='Closed'){
				$time=explode(' ',$this->request->data['elapsed_time']);
				$time=$time[0]; 
				$updateArray = array($field=>"'".$status."'",'Appointment.elapsed_time'=>"'$time'") ;
				if($status=='Closed'){
					$patientId=$this->Appointment->find('first',array('fields'=>array('patient_id','location_id'),'conditions'=>array('id'=>$this->request->data['id'])));
					$is_discharge=array('Patient.is_discharge'=>"'1'", 'Patient.discharge_date'=>"'".date('Y-m-d H:i:s')."'");
					$this->Patient->updateAll($is_discharge,array('id'=>$patientId['Appointment']['patient_id']));
					//update finalBilling entry by pankaj 
					$this->loadModel('FinalBilling');
					$this->loadModel('Billing');
					$isFinalEntryExist = $this->FinalBilling->find('first',array('fields'=>array('FinalBilling.id'),'conditions'=>array('FinalBilling.patient_id'=>$patientId['Appointment']['patient_id'])));
					$patientTotal = $this->Billing->getPatientTotalBill($patientId['Appointment']['patient_id']);
					$advancePaid = $this->Billing->find('first',array('fields'=>array('SUM(amount) as paid_amount','SUM(discount) as discount'),'conditions'=>array('Billing.patient_id'=>$patientId['Appointment']['patient_id'],'Billing.is_deleted'=>0)));
					if(!empty($isFinalEntryExist['FinalBilling']['id'])){ //update finalBilling entry
						$this->FinalBilling->save(array('location_id'=>$patientId['Appointment']['location_id'],'id'=>$isFinalEntryExist['FinalBilling']['id'],'total_amount'=>$patientTotal,'patient_id'=>$patientId['Appointment']['patient_id'],
								'amount_paid'=>$advancePaid[0]['paid_amount'],'amount_pending'=>(int)$patientTotal-(int)$advancePaid[0]['paid_amount'],'discount'=>$advancePaid[0]['discount']));
					}else{
						$this->FinalBilling->save(array('location_id'=>$patientId['Appointment']['location_id'],'id'=>$isFinalEntryExist['FinalBilling']['id'],'total_amount'=>$patientTotal,'patient_id'=>$patientId['Appointment']['patient_id'],
								'amount_paid'=>$advancePaid[0]['paid_amount'],'amount_pending'=>(int)$patientTotal-(int)$advancePaid[0]['paid_amount'],'discount'=>$advancePaid[0]['discount']));
					}
					//for accounting insert all jv for opd patient
					$this->loadModel('Billing');
					$this->loadModel('ServiceBill');
					$this->loadModel('ConsultantBilling');
					$this->loadModel('OptAppointment');
					$this->loadModel('PharmacySalesBill');
					
					$this->Billing->deleteRevokeJV($patientId['Appointment']['patient_id']); //for delete old jv entry
					
					$this->Billing->JVLabData($patientId['Appointment']['patient_id']);
					$this->Billing->JVRadData($patientId['Appointment']['patient_id']);
					$this->ServiceBill->JVServiceData($patientId['Appointment']['patient_id']);
					$this->ConsultantBilling->JVConsultantData($patientId['Appointment']['patient_id']);
					$this->OptAppointment->JVSurgeryData($patientId['Appointment']['patient_id']);
					$this->PharmacySalesBill->JVSaleBillData($patientId['Appointment']['patient_id']);
					
					$billingArray['Billing'] = array('date'=>date('Y-m-d H:i:s'));
					$this->Billing->addFinalVoucherLogJV($billingArray,$patientId['Appointment']['patient_id']); //add final jv
					//EOF Accounting by amit jain
				}
			}
			else if($status=='Confirmed with Patient'){
				$confirm=$this->request->data['confirmed_by_doctor'];
				$updateArray = array($field=>"'".$status."'",'Appointment.confirmed_by_doctor'=>"'$confirm'") ;
			}
			else if($status=='Cancelled'){
				if(!empty($this->request->data['is_deleted'])){
					$updateArray = array($field=>"'".$status."'",'Appointment.is_deleted'=>"'1'") ;
				}
				else{
					$updateArray = array($field=>"'".$status."'");
				}
			}
		
			$res = $this->Appointment->updateAll($updateArray,array('id'=>$this->request->data['id']));
				
			/* if(strtolower($status)=='seen' || strtolower($status)=='closed'){
				$this->Appointment->opProcessDone($this->request->data['id']);//passing appointment id
			} */
			//find futere appointment
			$isFutureApp = $this->Appointment->find('count',array('conditions'=>array('is_future_app'=>1,'id'=>$this->request->data['id'])));
			if($isFutureApp > 0)  echo "register" ;
			else if($res) echo json_encode($options) ;
			else echo "Please try again" ; 
			/* if(!empty($this->request->data['chamber'])){
			 $options =  array('In Room'=>'In Room :'.$this->request->data['chamber'],'Seen'=>'Seen') ;
			}else if($status=='Seen'){
			$options =  array('Seen'=>'Seen') ;
			}else{
			$options =  array('In Lobby'=>'In Lobby','Pending'=>'Pending','In Room'=>'In Room','Seen'=>'Seen') ;
			}	 */
			//$this->redirect('appointments_dashboard') ;
			
			///BOF-Mahalaxmi-For send SMS to Patient			
			$dataPersonId = $this->Appointment->find('first',array('fields'=>array('Appointment.person_id'),'conditions'=>array('Appointment.id'=>$this->request->data['id'])));
			if($status=='No-Show'){
				$getEnableFeatureChk=$this->Session->read('sms_feature_chk');
				if($getEnableFeatureChk=='1'){
					$this->Patient->sendToSmsPatient($dataPersonId['Appointment']['person_id'],'Noshow',$this->request->data['id']);
				}
			}
			///EOF-Mahalaxmi-For send SMS to Physician And Patient
		}else{
			echo "Please try again" ;
		}
		exit;
	}


	// updating table if no follow up needed
	public function updateFollowUp(){
		$this->loadmodel('Note');
		$updateArray = array('Appointment.has_no_followup'=>"'1'") ;
		$this->Appointment->updateAll($updateArray,array('Appointment.id '=>$this->request->data['id']));
		$updateNote= array('Note.has_no_followup'=>"'1'") ;
		$this->Note->updateAll($updateNote,array('Note.patient_id '=>$this->request->data['patient_id']));
		exit;
	}
	public function positiveIdDone(){
		$updateArray = array('Appointment.positive_id'=>"'1'") ;
		$this->Appointment->updateAll($updateArray,array('Appointment.id '=>$this->request->data['id']));
		//$this->redirect($this->referer());
		exit;

	}

	//******************Changing of physician-Pooja **************/
	public function changeProvider($apptId,$prevDoctor,$newDoctor,$patient_id){
		$this->layout='advance_ajax';
		$this->loadModel('User');
		$this->loadModel('Patient');
		$this->User->bindModel(array(
				'hasOne' => array('DoctorProfile'=>array('foreignKey'=>'user_id'))));
		$details =  $this->User->find('all',array('fields'=>array('User.full_name','User.id'),'conditions'=>array('Role.name'=>Configure::read("doctorLabel"),
				'User.is_active'=>1,'DoctorProfile.is_deleted'=>0,'DoctorProfile.is_registrar'=>0,'User.id'=>$prevDoctor ,'User.is_deleted'=>0),
		));
		$this->set('details',$details);//for the pop up window on physician change
		$this->set(compact('apptId','newDoctor','patient_id'));
		if(!empty($this->request->data)){
			$this->Appointment->save($this->request->data['Appointment']);
			$updateArray = array('Patient.doctor_id'=>$this->request->data['Appointment']['doctor_id']) ;// for changing the doctor id in Patient table
			$this->Patient->updateAll($updateArray,array('Patient.id '=>$this->request->data['Patient']['id']));
			$this->Session->setFlash(__('Provider has been changed', true, array('class'=>'message')));
		}

	}

	/* public function updateDoctor(){
		$updateArray = array('Appointment.doctor_id'=>$this->request->data['doctor_id']) ;
	$this->Appointment->updateAll($updateArray,array('Appointment.id '=>$this->request->data['id']));
	exit;

	} */
	public function appointments_count(){
		$role=$this->Session->read('role');
		if($role==Configure::read('doctorLabel')){
			$condition['Appointment.doctor_id']= $this->Session->read('userid');
			$condition['Appointment.date']= date('Y-m-d') ;
		}else if($role==Configure::read('nurseLabel')){
			$condition['Patient.nurse_id']= $this->Session->read('userid');
			$condition['Appointment.date']= date('Y-m-d') ;
		}else{
			$condition['Appointment.date']= date('Y-m-d') ;
		}
		$condition['Appointment.status NOT']='Closed';
		$this->Appointment->bindModel(array(
				'belongsTo' => array(
						'Patient'=>array('foreignKey'=>'patient_id','type'=>'INNER','conditions'=>array('Patient.is_deleted=0','Patient.is_discharge= 0')),
				))); //hasmany for futere appt.

				$latestCount=$this->Appointment->find('count',array('conditions'=>$condition));
				echo $latestCount;
				exit;
	}
	
	/**
	 * function to display token numbers
	 * @param integer $apptId --- Appointment id of the token in display
	 */
	
	public function token_display($apptId=NULL){
		$this->layout='advance_ajax';
		$this->uses=array('Appointment','Chamber');
		$order="(CASE Appointment.status
					WHEN 'Ready' THEN 1
					WHEN 'Arrived' THEN 2
					ELSE 100 END) ASC, Appointment.status DESC";
		$role=$this->Session->read('role');
		if($role==Configure::read('doctorLabel')){
			$condition['Appointment.doctor_id']= $this->Session->read('userid');
			$condition['Appointment.date']= date('Y-m-d') ;
		}else if($role==Configure::read('nurseLabel')){
			$condition['Patient.nurse_id']= $this->Session->read('userid');
			$condition['Appointment.date']= date('Y-m-d') ;
		}else{
			$condition['Appointment.date']= date('Y-m-d') ;
		}
		$condition['Appointment.status NOT']='Closed'/*,'Scheduled','Seen','In-Progress','Assigned')*/;
		$this->Appointment->bindModel(array(
				'belongsTo' => array(
						'Patient'=>array('foreignKey'=>'patient_id','type'=>'INNER','conditions'=>array('Patient.is_deleted=0')),
						'Chamber'=>array('foreignKey'=>'chamber_id')
				))); //has many for future appt.

		$latestCount=$this->Appointment->find('first',array('conditions'=>array('Appointment.is_deleted'=>'0','Appointment.date'=>date('Y-m-d'),'Appointment.location_id'=>$this->Session->read('locationid'),
				$condition),'order'=>$order,));
		
		$this->set('appToken',$latestCount);
	}
	
	/**
	 * changing token number on status of the current token numbers changes to 'Seen'
	 * @param unknown_type $apptId
	 */
	public function app_token($apptId){
	$this->uses=array('Appointment');
	$this->Appointment->bindModel(array(
			'belongsTo' => array(
					'Patient'=>array('foreignKey'=>'patient_id','type'=>'INNER','conditions'=>array('Patient.is_deleted=0')),
					'Chamber'=>array('foreignKey'=>'chamber_id')
			))); //has many for future appt.
		if($apptId){
			$apptStatus=$this->Appointment->find('first',array('conditions'=>array('Appointment.id'=>$apptId,'Appointment.date'=>date('Y-m-d'),)));
		}
		if(!empty($apptStatus)){
			if($apptStatus['Appointment']['status']!='Seen' && $apptStatus['Appointment']['status']!='Closed'){
				echo json_encode($apptStatus);
				exit;
			}else{
				$order="(CASE Appointment.status
										WHEN 'Ready' THEN 1
										WHEN 'Arrived' THEN 2
										ELSE 100 END) ASC, Appointment.status DESC";
				$role=$this->Session->read('role');
				if($role==Configure::read('doctorLabel')){
					$condition['Appointment.doctor_id']= $this->Session->read('userid');
					$condition['Appointment.date']= date('Y-m-d') ;
				}else if($role==Configure::read('nurseLabel')){
					$condition['Patient.nurse_id']= $this->Session->read('userid');
					$condition['Appointment.date']= date('Y-m-d') ;
				}else{
					$condition['Appointment.date']= date('Y-m-d') ;
				}
				$condition['Appointment.status NOT']='Closed'/*,'Scheduled','Seen','In-Progress','Assigned'*/;			
				
				$latestCount=$this->Appointment->find('first',array('conditions'=>array('Appointment.is_deleted'=>'0','Appointment.date'=>date('Y-m-d'),'Appointment.location_id'=>$this->Session->read('locationid'),
						$condition),'order'=>$order,));
				echo json_encode($latestCount);
				exit;
			}
		}else{
		$order="(CASE Appointment.status
										WHEN 'Arrived' THEN 1
										WHEN 'Ready' THEN 2										
										ELSE 100 END) ASC, Appointment.status DESC";
		$role=$this->Session->read('role');
		if($role==Configure::read('doctorLabel')){
			$condition['Appointment.doctor_id']= $this->Session->read('userid');
			$condition['Appointment.date']= date('Y-m-d') ;
		}else if($role==Configure::read('nurseLabel')){
			$condition['Patient.nurse_id']= $this->Session->read('userid');
			$condition['Appointment.date']= date('Y-m-d') ;
		}else{
			$condition['Appointment.date']= date('Y-m-d') ;
		}
		$condition['Appointment.status NOT']='Closed'/*,'Scheduled','Seen','In-Progress','Assigned'*/;
			/*	$this->Appointment->bindModel(array(
						'belongsTo' => array(
								'Patient'=>array('foreignKey'=>'patient_id','type'=>'INNER','conditions'=>array('Patient.is_deleted=0')),
								'Chamber'=>array('foreignKey'=>'chamber_id')
						))); //has many for future appt.*/
				
				$latestCount=$this->Appointment->find('first',array('conditions'=>array('Appointment.is_deleted'=>'0','Appointment.date'=>date('Y-m-d'),'Appointment.location_id'=>$this->Session->read('locationid'),$condition),'order'=>$order,));
				echo json_encode($latestCount);
				exit;
	}
}


//function to return OPD patients only on patient list dashboard by pooja
public function testcomplete($type=NULL,$discharge=NULL){

		/*$this->layout = "ajax";
		$this->loadModel('Patient');
		$conditions =array();		
		$searchKey = $this->params->query['q'] ;
		$conditions["Patient.lookup_name like"] = "%".$searchKey."%";
		$conditions["Patient.admission like"] = "%".$searchKey."%";
		$testArray = $this->Patient->find('list', array('fields'=> array('Patient.id', 'Patient.lookup_name'),'conditions'=>array($conditions,'Patient.is_deleted=0','Patient.admission_type'=>array('OPD','LAB','RAD')),'order'=>array("Patient.lookup_name ASC")));
		foreach ($testArray as $key=>$value) {
			echo "$value   $key|$key\n";
		}
		exit;*/
	$this->layout = 'ajax';
	$this->loadModel('Patient');
	$conditions =array();$condition=array();
	$searchKey = $this->params->query['term'] ;
	//Vadodara search will be for name and Patient UID / for other instance its Name and Patient MRN
	if($this->Session->read('website.instance')=='vadodara'){
		$conditions["Patient.patient_id like"] = '%'.$searchKey.'%';		
	}else{
		$conditions["Patient.admission_id like"] = '%'.$searchKey.'%';		
	}
	$conditions["Patient.lookup_name like"] = '%'.$searchKey.'%';
	if($discharge)
		$condition['Patient.is_discharge']='1';
	
	if(!empty($type)){
		$condition["Patient.admission_type"]=$type;
	}else{
		$condition["Patient.admission_type NOT"]='IPD';
	}

	$testArray = $this->Patient->find('all', array(
			'fields'=> array('Patient.id','Patient.lookup_name',
			'Patient.form_received_on','Patient.admission_id',
			'Patient.patient_id','Patient.admission_type'),
			'conditions'=>array('OR'=>($conditions),$condition
			,'Patient.is_deleted=0'),
			'order'=>array("Patient.lookup_name ASC"),
			'limit'=>Configure::read('number_of_rows')));
	
	if($this->Session->read('website.instance')=='vadodara'){
		foreach ($testArray as $key=>$value) {
			if(!empty($value['Patient']['form_received_on'])){
			$addDate=$this->DateFormat->formatDate2Local($value['Patient']['form_received_on'],Configure::read('date_format'));
			$returnArray[]=array('id'=>$value['Patient']['id'],'value'=>ucwords(strtolower($value['Patient']['lookup_name'])).'-'.$value['Patient']['patient_id'].' '.$value['Patient']['admission_type'].' ( '.$addDate.' )','admission_type'=>$value['Patient']['admission_type']);
			//echo "$value   $key|$key\n";
			}
		}
	}else{
		foreach ($testArray as $key=>$value) {	
			$returnArray[]=array('id'=>$value['Patient']['id'],'value'=>$value['Patient']['lookup_name'].'-'.$value['Patient']['admission_id']);
			//echo "$value   $key|$key\n";
		}
	}
	echo json_encode($returnArray);
	exit;
	}
	
	public function discount_patient_list($type=NULL){
		$this->uses=array('FinalBilling','Patient','Person');
		$this->Patient->bindModel(array('belongsTo'=>array(
				'Person'=>array('foreignKey'=>false,'conditions'=>array('Person.id=Patient.person_id')),
				'FinalBilling'=>array('foreignKey'=>false,'conditions'=>array('FinalBilling.patient_id=Patient.id'))
				)),false);
		
		if($type=='discount'){
			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'fields'=>array('Patient.lookup_name','FinalBilling.total_amount','FinalBilling.discount','FinalBilling.discount_type'),
					'conditions'=>array('Person.vip_chk'=>'0',
					'OR' =>  array(
			               array('AND' => array(
			                              array('FinalBilling.discount NOT' =>array('0','100','')),
			                              array('FinalBilling.discount_type' =>'Percentage')
			                        )),
			               array('AND' => array(
			                              array('FinalBilling.discount < FinalBilling.total_amount'),
			               				  array('FinalBilling.discount NOT'=> '0'),
			               				  array('FinalBilling.discount NOT'=> ''),
			                              array('FinalBilling.discount_type' =>'Amount')
			                        )),
			             ),
					'Patient.is_deleted'=>'0')			
			);
			
		}else if($type=='free'){
			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'fields'=>array('Patient.lookup_name','FinalBilling.total_amount','FinalBilling.discount','FinalBilling.discount_type'),
					'conditions'=>array('Person.vip_chk'=>'1',
					'OR' =>  array(
			               array('AND' => array(
			                              array('FinalBilling.discount' =>'100'),
			                              array('FinalBilling.discount_type' =>'Percentage')
			                        )),
			               array('AND' => array(
			                              array('FinalBilling.discount = FinalBilling.total_amount'),
			                              array('FinalBilling.discount_type' =>'Amount')
			                        )),
			             ),
					'Patient.is_deleted'=>'0')						
			);	
			
		}else if($type=='all'){
			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'fields'=>array('Patient.lookup_name','FinalBilling.total_amount','FinalBilling.discount','FinalBilling.discount_type'),
					'conditions'=>array('FinalBilling.discount NOT'=>array('','0'),'Patient.is_deleted'=>'0')			
			);
			
		}
		$patientList=$this->paginate('Patient');
		$this->set('patientList',$patientList);
		
	}
	public function patientQueque(){
		$this->layout='advance_ajax';
		$this->uses=array('DoctorProfile','User');
		$this->User->bindModel(array(
				'belongsTo' => array(
						'DoctorProfile' =>array('foreignKey'=>false,'conditions'=>array('DoctorProfile.user_id=User.id')),
						//'Department' =>array('foreignKey'=>'department_id'),
				)));
		$listDoctor=$this->User->find('all',array('fields'=>array('User.id','DoctorProfile.doctor_name'),'conditions'=>array('DoctorProfile.is_opd_allow'=>'1')));
		foreach($listDoctor as $listData){
			$docList[$listData['User']['id']]=$listData['DoctorProfile']['doctor_name'];
		}
		$this->set('listDoctor',$docList);
	}
	public function chamberOne($docId){
		//$this->layout='ajax';
		$this->uses=array('Appointment','Patient');
		$this->Appointment->bindModel(array(
				'belongsTo' => array(
						'Patient' =>array('foreignKey'=>'patient_id'),
						//'Department' =>array('foreignKey'=>'department_id'),
				)));
		$this->paginate = array(
				'update' => '#list_content',
				'evalScripts' => true
	
		);
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array('Appointment.create_time' => 'desc'),
				'fields'=> array('Appointment.id','Patient.id','Patient.lookup_name','Appointment.start_time','Appointment.status'),
				'conditions'=>array('Appointment.is_deleted'=>'0','Appointment.date'=>date('Y-m-d'),array("Appointment.status!='Closed'"),'Appointment.doctor_id'=>$docId),
				'order'=>'FIELD(Appointment.status, "Ready") DESC, Appointment.start_time ASC'
		);
		$this->set('id',$patient_id);
		$patientLists = $this->paginate('Appointment');
		foreach($patientLists as $key=>$patientList){
				
				
			$patientListData[$key]['patientName']=$patientList['Patient']['lookup_name'];
			$patientListData[$key]['start_time']=$patientList['Appointment']['start_time'];
			$startTimeExplode=explode(':',$patientList['Appointment']['start_time']);
			$curTimeExplode=explode(':',date('H:i:s'));
			/* logic for remain time Aditya */
			if($startTimeExplode['0'] >= $curTimeExplode['0']){
				$hr=$startTimeExplode['0']-$curTimeExplode['0'];
				if($startTimeExplode['1']>$curTimeExplode['1']){
					$min=$startTimeExplode['1']-$curTimeExplode['1'];
				}else{
					$min=$curTimeExplode['1']-$startTimeExplode['1'];
				}
				$patientListData[$key]['remain_time']=$hr.":".$min;
			}else{
				$patientListData[$key]['remain_time']="00:00";
			}
			/* EOD */
		}
		$this->set('data',$patientListData);
		$this->render('chamber_one');
	
	}
	public function chamberTwo($docId){
		//$this->layout='ajax';
		$this->uses=array('Appointment','Patient');
		$this->Appointment->bindModel(array(
				'belongsTo' => array(
						'Patient' =>array('foreignKey'=>'patient_id'),
						//'Department' =>array('foreignKey'=>'department_id'),
				)));
		$this->paginate = array(
				'update' => '#list_content',
				'evalScripts' => true
	
		);
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array('Appointment.create_time' => 'desc'),
				'fields'=> array('Appointment.id','Patient.id','Patient.lookup_name','Appointment.start_time','Appointment.status'),
				'conditions'=>array('Appointment.is_deleted'=>'0','Appointment.date'=>date('Y-m-d'),array("Appointment.status!='Closed'"),'Appointment.doctor_id'=>$docId),
				'order'=>'FIELD(Appointment.status, "Ready") DESC, Appointment.start_time ASC'
		);
		$this->set('id',$patient_id);
		foreach($this->paginate('Appointment') as $key=>$patientList){
	
			$patientListData[$key]['patientName']=$patientList['Patient']['lookup_name'];
			$patientListData[$key]['start_time']=$patientList['Appointment']['start_time'];
			$startTimeExplode=explode(':',$patientList['Appointment']['start_time']);
			$curTimeExplode=explode(':',date('H:i:s'));
			/* logic for remain time Aditya */
			if($startTimeExplode['0'] >= $curTimeExplode['0']){
				$hr=$startTimeExplode['0']-$curTimeExplode['0'];
				if($startTimeExplode['1']>$curTimeExplode['1']){
					$min=$startTimeExplode['1']-$curTimeExplode['1'];
				}else{
					$min=$curTimeExplode['1']-$startTimeExplode['1'];
				}
				$patientListData[$key]['remain_time']=$hr.":".$min;
			}else{
				$patientListData[$key]['remain_time']="00:00";
			}
			/* EOD */
		}
		$this->set('data',$patientListData);
		$this->render('chamber_two');
	
	}
	public function chamberThree($docId){
		//$this->layout='ajax';
		$this->uses=array('Appointment','Patient');
		$this->Appointment->bindModel(array(
				'belongsTo' => array(
						'Patient' =>array('foreignKey'=>'patient_id'),
						//'Department' =>array('foreignKey'=>'department_id'),
				)));
		$this->paginate = array(
				'update' => '#list_content',
				'evalScripts' => true
	
		);
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array('Appointment.create_time' => 'desc'),
				'fields'=> array('Appointment.id','Patient.id','Patient.lookup_name','Appointment.start_time','Appointment.status'),
				'conditions'=>array('Appointment.is_deleted'=>'0','Appointment.date'=>date('Y-m-d'),array("Appointment.status!='Closed'"),'Appointment.doctor_id'=>$docId),
				'order'=>'FIELD(Appointment.status, "Ready") DESC, Appointment.start_time ASC'
		);
		$this->set('id',$patient_id);
		foreach($this->paginate('Appointment') as $key=>$patientList){
	
			$patientListData[$key]['patientName']=$patientList['Patient']['lookup_name'];
			$patientListData[$key]['start_time']=$patientList['Appointment']['start_time'];
			$startTimeExplode=explode(':',$patientList['Appointment']['start_time']);
			$curTimeExplode=explode(':',date('H:i:s'));
			/* logic for remain time Aditya */
			if($startTimeExplode['0'] >= $curTimeExplode['0']){
				$hr=$startTimeExplode['0']-$curTimeExplode['0'];
				if($startTimeExplode['1']>$curTimeExplode['1']){
					$min=$startTimeExplode['1']-$curTimeExplode['1'];
				}else{
					$min=$curTimeExplode['1']-$startTimeExplode['1'];
				}
				$patientListData[$key]['remain_time']=$hr.":".$min;
			}else{
				$patientListData[$key]['remain_time']="00:00";
			}
			/* EOD */
		}
		$this->set('data',$patientListData);
		$this->render('chamber_three');
	
	}
	
	public function lab_management(){
		$this->layout = 'advance';
		$this->uses = array('User');
		$opddoctors = $this->User->getOpdDoctors();
		$this->set('doctors',$opddoctors);
		$this->set('doctorsJson',json_encode($doctors));
	}
	
	
	public function lab_patient_dashboard($future_apt=null,$patient_id=null,$opt=null,$aptId=null){
		//$this->layout = 'ajax';
		
		$this->uses = array('Chamber','User','Patient','Note','NoteDiagnosis','LaboratoryResult','ServiceCategory',
				'LaboratoryTestOrder','RadiologyTestOrder','RadiologyResult','ReferralToSpecialist','TariffStandard');
		if(!empty($this->request->data)){
			
		}
		//if(empty($this->request->data['Appointment'])){
	
		//$date[0] = date('Y-m-d');
		//}
		/*if (empty($this->request->data['Appointment']['patient_id'])) {
		 if (!empty($this->params->query['dateFrom'])&&!empty($this->params->query['dateTo'])) {
		$dateFrom = explode(' ',$this->DateFormat->formatDate2STD($this->params->query['dateFrom'],Configure::read('date_format')));
		$dateTo = explode(' ',$this->DateFormat->formatDate2STD($this->params->query['dateTo'],Configure::read('date_format')));
		$this->set('dateSearch','1');
		//$conditions = array('Appointment.is_deleted'=>'0');
		}else{
		$date[0] = date('Y-m-d');
		}
		}
		if(!empty($dateFrom)){
		$conditionFrom=array('Patient.form_received_on >='=>$dateFrom[0].' 00:00:00');
		}
		else{
		$conditionFrom=array('Patient.form_received_on >='=>date('Y-m-d').' 00:00:00');
		}
		if(!empty($dateTo)){
		$conditionDateTo=array('Patient.form_received_on <='=>$dateTo[0].' 23:59:59');
		}
		else{
		$conditionDateTo=array('Patient.form_received_on <='=>date('Y-m-d').' 23:59:59');
		}*/
		if (empty($this->request->data['Appointment']['patient_id'])) {
			$this->set('dateSearch','1');
			if(!empty($this->params->query['dateFrom'])&&!empty($this->params->query['dateTo'])){
				$dateFrom = explode(' ',$this->DateFormat->formatDate2STD($this->params->query['dateFrom'],Configure::read('date_format')));
				$dateTo = explode(' ',$this->DateFormat->formatDate2STD($this->params->query['dateTo'],Configure::read('date_format')));
				$conditionFrom=array('Patient.form_received_on >='=>$dateFrom[0].' 00:00:00');
				$conditionDateTo=array('Patient.form_received_on <='=>$dateTo[0].' 23:59:59');
			}else if(!empty($this->params->query['dateFrom']) && empty($this->params->query['dateTo'])){
				$dateFrom = explode(' ',$this->DateFormat->formatDate2STD($this->params->query['dateFrom'],Configure::read('date_format')));
				$conditionFrom=array('Patient.form_received_on >='=>$dateFrom[0].' 00:00:00');
				$conditionDateTo=array('Patient.form_received_on <='=>date('Y-m-d').' 23:59:59');
			}else if(empty($this->params->query['dateFrom']) && !empty($this->params->query['dateTo'])){
				$dateTo = explode(' ',$this->DateFormat->formatDate2STD($this->params->query['dateTo'],Configure::read('date_format')));
				$conditionFrom=array('Patient.form_received_on >='=>date('Y-m-d').'00:00:00');
				$conditionDateTo=array('Patient.form_received_on <='=>$dateTo[0].' 23:59:59');
			}
			else if(empty($this->params->query['dateFrom']) && empty($this->params->query['dateTo'])){
				$date[0] = date('Y-m-d');
			}
		}
		$role = $this->Session->read('role');
		if($role == Configure::read('doctorLabel') || $role==Configure::read('residentLabel')){
			$conditionDoctor = array('Patient.doctor_id'=>$this->Session->read('userid'));
	
		}
		if($this->request->params['pass'][0] == Configure::read('nurseLabel')){
			$nurseCondition = 'Appointment.nurse_id='.$this->Session->read('userid');
			$this->set('viewAll','0');
	
		}
		else{
			$this->set('viewAll','1');
		}
	
		//To get Mandatory Service Id
		$this->ServiceCategory->unbindModel(array('hasMany'=>array('ServiceSubCategory')));
		$paymentCategoryId=$this->ServiceCategory->find('first',array('fields'=>array('id'),'conditions'=>array('ServiceCategory.name Like'=>Configure::read('mandatoryServices'))));
	
		//tariff List Private Id
		$privateID = $this->TariffStandard->getPrivateTariffID();//retrive private ID
		$this->set('privateId',$privateID);
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'User' =>array('foreignKey'=>'doctor_id'),
						'Person'=>array('foreignKey'=>false,'conditions'=>array('Person.id=Patient.person_id')),
						'Diagnosis'=>array('foreignKey'=>false,'conditions'=>array('Diagnosis.patient_id=Patient.id','Diagnosis.is_discharge'=>0)),
						'FinalBilling'=>array('foreignKey'=>false,'conditions'=>array('FinalBilling.patient_id=Patient.id')),
						'Billing'=>array('foreignKey'=>false,'conditions'=>array('Billing.patient_id=Patient.id')),
						"BillingAlias"=>array('className'=>'Billing',"foreignKey"=>false ,
								'conditions'=>array('BillingAlias.patient_id=Patient.id','BillingAlias.payment_category'=>$paymentCategoryId['ServiceCategory']['id'])),
						'NewCropPrescription'=>array('foreignKey'=>false,
								'conditions'=>array('NewCropPrescription.patient_uniqueid =Patient.id','NewCropPrescription.archive'=>'N','NewCropPrescription.is_med_administered'=>'1')),
						"NewCropPrescriptionAlias"=>array('className'=>'NewCropPrescription',"foreignKey"=>false ,
								'conditions'=>array('NewCropPrescriptionAlias.patient_uniqueid =Patient.id','NewCropPrescriptionAlias.archive'=>'N','NewCropPrescriptionAlias.is_med_administered'=>'2')),
						'Note'=>array('foreignKey'=>false,
								'conditions'=>array('Note.patient_id =Patient.id')),
		
						),
				'hasmany'=>array()
		),false); //hasmany for future appt.
	
		$this->paginate = array(
				'update' => '#list_content',
				'evalScripts' => true
		);
			
		$conditionIsDeleted = array('Patient.is_deleted'=>'0');
		$conditionStatus = array('Patient.is_discharge '=>'0');
		$conditionLocation = array('Patient.location_id'=>$this->Session->read('locationid'));
		//doctor filter (click on tabs)
		//if (!empty($this->request->data['Appointment']['All Doctors'])) {
		/* if (!empty($this->request->data['Appointment']['doctor_id'])) {
		 $conditionsDoc = array('Appointment.doctor_id'=>$this->request->data['Appointment']['doctor_id']);
		} */
	
	
		if (!empty($this->request->data['Appointment']['patient_id'])) {
			//To find the list of all the patient having name like searched name
			$patientIds=$this->Patient->find('list',array('fields'=>array('id'),
					'conditions'=>array('Patient.lookup_name LIKE'=>'%'.$this->request->data['Appointment']['patient_name'].'%')));
			$conditionPatientId =array('Patient.id'=>$patientIds);
			
			
		}
		if($this->params->query['doctorsId']){
			/* foreach($this->request->data as $key=>$value){
			 if($key=='context-menu-input-'.$value){
			$doctorArray[]=$value;
			}
			} */
			$docArray=explode('_',$this->params->query['doctorsId']);
			$docArray=implode(',',$docArray);
			if(!empty($docArray)){
				$conditionDoctor=array('Patient.doctor_id IN ('.$docArray.")");
			}
			$rt='1';
			$this->set('rtSelect',$rt);
		}
		//$conditions=array();
		if($future_apt == 'future'||!empty($this->request->data['Appointment']['patient_id'])||$this->params->query['doctorsId']||!empty($this->params->query['dateFrom'])||!empty($this->params->query['dateTo'])){
			if(!empty($this->params->query['dateFrom'])||!empty($this->params->query['dateTo'])){
				$conditions=array($conditionDoctor,$conditionIsDeleted/*,$conditionStatus*/,$conditionLocation,$conditionPatientId,$nurseCondition,$conditionDateTo,$conditionFrom);
			}else{
				$conditions=array($conditionDoctor,$conditionIsDeleted/*,$conditionStatus*/,$conditionLocation,$conditionPatientId,$nurseCondition);
			}
		}
		else{
			$conditions=array($conditionDoctor,$conditionIsDeleted,$conditionStatus,$conditionLocation,$conditionPatientId,$nurseCondition);
	
		}
		//To Show Today's Closed Appointment
		if($this->params->query['closed']=='closed')//for pagination
			$future_apt='closed';
	
		if($future_apt== 'closed'){
			$conditionStatus=array('Patient.is_discharge'=>'1');
			$conditions=array($conditionDoctor,$conditionIsDeleted,$conditionStatus,$conditionLocation,$conditionPatientId,$nurseCondition);
		}
	
	
	
		if($future_apt == 'closed'){
			$this->Patient->bindModel(array(
					'belongsTo' => array(
							'User' =>array('foreignKey'=>'doctor_id'),
							'Person'=>array('foreignKey'=>false,'conditions'=>array('Person.id=Patient.person_id')),
							'Diagnosis'=>array('foreignKey'=>false,'conditions'=>array('Diagnosis.patient_id=Patient.id','Diagnosis.is_discharge'=>0)),
							'FinalBilling'=>array('foreignKey'=>false,'conditions'=>array('FinalBilling.patient_id=Patient.id')),
							'Billing'=>array('foreignKey'=>false,'conditions'=>array('Billing.patient_id=Patient.id')),
							'NewCropPrescription'=>array('foreignKey'=>false,
									'conditions'=>array('NewCropPrescription.patient_uniqueid =Patient.id','NewCropPrescription.archive'=>'N','NewCropPrescription.is_med_administered'=>'1')),
							"NewCropPrescriptionAlias"=>array('className'=>'NewCropPrescription',"foreignKey"=>false ,
									'conditions'=>array('NewCropPrescriptionAlias.patient_uniqueid =Patient.id','NewCropPrescriptionAlias.archive'=>'N','NewCropPrescriptionAlias.is_med_administered'=>'2')),
							'Note'=>array('foreignKey'=>false,
									'conditions'=>array('Note.patient_id =Patient.id')),
							),
					'hasmany'=>array()
			),false); //hasmany for future appt.
							$conditions = array_merge($conditions,array('Patient.form_received_on >='=>date('Y-m-d 00:00:00'),'Patient.admission_type'=>'LAB','Patient.form_received_on <='=>date('Y-m-d 23:59:59')));
							$this->paginate = array(
									'limit' => '8',
									'fields'=> array('concat(User.first_name," ",User.last_name) as full_name','Patient.id','Patient.patient_id','Patient.person_id','Patient.age',
											'Patient.lookup_name','Person.vip_chk','Patient.is_discharge',
											'Patient.nurse_id','Person.mobile','Person.dob','Person.email','Person.ssn_us','Person.patient_credentials_created_date','Person.patient_uid' ,
											'Patient.tariff_standard_id',
											'Person.id','Person.sex','Patient.is_opd','Billing.patient_id','Billing.total_amount',
											'SUM(Billing.amount_pending) as amount_pending','SUM(Billing.amount) as amount_paid','SUM(Billing.discount) as discount',
											'SUM(Billing.paid_to_patient) as refund',
											'Person.photo','Person.patient_credentials_created_date','Person.patient_uid','Count(Note.id) as noteCount','Note.has_no_followup',
											'Count(Diagnosis.id) as initCount','Diagnosis.id','Count(FinalBilling.id) as paidCount','NewCropPrescriptionAlias.id',
											'NewCropPrescriptionAlias.is_med_administered','NewCropPrescription.id','NewCropPrescription.is_med_administered',
											'Count(NewCropPrescription.id)as medication','Note.id','Note.sign_note'),
									'conditions'=>$conditions,'group'=>array('Patient.id'),
	
							);
							$this->set('closed',$future_apt);
		}else if($future_apt == 'future'){
			if (empty($this->request->data['Appointment']['patient_id'])) {
				if(strtotime($date[0]) > strtotime(date('Y-m-d'))){
					$conditions = array_merge($conditions,array('Patient.form_received_on >='=>$date[0].'00:00:00'));
				}else{
					$conditions = array_merge($conditions,array('Patient.form_received_on >'=>date('Y-m-d').'00:00:00'));
				}
			}
			$this->paginate = array(
					'limit' => 8,
					'fields'=> array('concat(User.first_name," ",User.last_name) as full_name','Patient.patient_id','Patient.person_id','Patient.lookup_name','Patient.is_discharge',
							'Person.mobile','Person.email','Person.dob','Person.patient_credentials_created_date','Person.patient_uid' ,'Person.id','Person.sex','Person.patient_credentials_created_date','NewInsurance.*','Encounter.*','Note.*'),
					'conditions'=>$conditions,'group'=>array('Patient.id')
					//'DATE_FORMAT(Appointment.create_time,"%b %d %Y")'=>date('Y-m-d'),
			);
	
			$this->set('future',$future_apt);
		}else{
			if (empty($this->request->data['Appointment']['patient_id'])) {
				//Edited by-Pooja (Please confirm before editing)
				if(!empty($dateFrom) && !empty($dateTo)){
					$todayCondition = $conditions;
				}else if(!empty($dateFrom)){
					$todayCondition = $conditions;
				}else if(!empty($dateTo)){
					$todayCondition = $conditions;
				}else{
					$todayCondition = array_merge($conditions,array('Patient.form_received_on >='=>$date[0].' 00:00:00','Patient.form_received_on <='=>$date[0].' 23:59:59'));
				}
			}else if(!empty($this->request->data['Appointment']['patient_id']) && ($this->request->data['Appointment']['Discharged']=='1')){
			   $conditionDischarged = array('Patient.is_discharge '=>'1');   
			   $todayCondition=array_merge($conditions,$conditionDischarged);
			}elseif(!empty($this->request->data['Appointment']['patient_id'])){
				 $conditionDischarged = array('Patient.is_discharge '=>'0');   
			     $todayCondition=array_merge($conditions,$conditionDischarged);
			}
			
			$role=$this->Session->read('role');
			if($role==Configure::read('doctorLabel')||$role==Configure::read('nurseLabel') || $role==Configure::read('medicalAssistantLabel') || $role==Configure::read('residentLabel'))
			{
				if(!empty($dateFrom) && !empty($dateTo)){
					$order= 'Note.sign_note asc' ; //for keyword order "Sign Note"
				}
				else{
					$order= "IF(instr(Appointment.status, 'In-Progress'), instr(Appointment.status, 'In-Progress'), 65535) asc" ; //for keyword order "In-Progress"
				}
			}
			else{
				//Order by for ordering the in the status in sequence of Arrived, Scheduled, Assigned, and Seen - Pooja ///
				/*$order="(CASE Appointment.status
				 WHEN 'Arrived' 	 THEN 1
						WHEN 'Ready' 	 THEN 2
						WHEN 'Scheduled' THEN 3
						WHEN 'Pending' 	 THEN 4
						WHEN 'Assigned'  THEN 5
						WHEN 'Seen' THEN 6
						ELSE 100 END) ASC, Appointment.status DESC";*/
				//$order="IF(instr(Appointment.status, 'Arrived'), instr(Appointment.status, 'Arrived'), 65535) asc" ; //for keyword order 'Arrived'
			}
			
			$this->paginate = array(
					'limit' => '8',
					'fields'=> array('concat(User.first_name," ",User.last_name) as full_name','Patient.id','Patient.patient_id','Patient.person_id','Patient.age',
							'Patient.lookup_name','Person.vip_chk','Patient.form_received_on',
							'Patient.nurse_id','Person.mobile','Person.dob','Person.email','Person.ssn_us','Person.patient_credentials_created_date','Person.patient_uid' ,
							'Patient.tariff_standard_id','Patient.is_discharge',
							'Person.id','Person.sex','Patient.is_opd','Billing.patient_id','Billing.total_amount',
							'SUM(Billing.amount_pending) as amount_pending','SUM(Billing.amount) as amount_paid','SUM(Billing.discount) as discount',
							'SUM(Billing.paid_to_patient) as refund',
							'Person.photo','Person.patient_credentials_created_date','Person.patient_uid','Count(Note.id) as noteCount','Note.has_no_followup',
							'Count(Diagnosis.id) as initCount','Diagnosis.id','Count(FinalBilling.id) as paidCount','NewCropPrescriptionAlias.id',
							'NewCropPrescriptionAlias.is_med_administered','NewCropPrescription.id','NewCropPrescription.is_med_administered',
							'Count(NewCropPrescription.id)as medication','Note.id','Note.sign_note' ),
							'conditions'=>array($todayCondition,'Patient.admission_type'=>'LAB','Patient.id NOT'=>NULL),
							'group'=>array('Patient.id')
							//'DATE_FORMAT(Appointment.create_time,"%b %d %Y")'=>date('Y-m-d'),
			);
	
		}
		$nurses  = $this->User->getUsersByRoleName(Configure::read('nurseLabel')) ;
		$this->set('nurses',$nurses);
		$chamberList = $this->Chamber->getChamberList();
		$this->set('id',$patient_id);
		$data = $this->paginate('Patient') ; //debug($data); exit;
		$this->set('count',COUNT($data)); //Counting the data in appointment table
		// lab LAB count ---- BOF Gaurav
		if($future_apt != 'future' && !empty($data)){
			foreach($data as $patientKey => $patientValue){
				$ids[] = $patientValue['Patient']['id'] ;
			}
			$idsStr = implode(",",$ids) ;
			/** Lab Code Start*/
			if(!empty($idsStr)){
			$this->LaboratoryTestOrder->bindModel(array(
					'belongsTo' => array(
							'LaboratoryResult' =>array('foreignKey'=>false,'conditions'=>array('LaboratoryResult.laboratory_test_order_id=LaboratoryTestOrder.id')),
							'LaboratoryHl7Result'=>array('foreignKey'=>false,'conditions'=>array('LaboratoryHl7Result.laboratory_result_id=LaboratoryResult.id')),
					)));
			$labData = $this->LaboratoryTestOrder->find('all',array('fields'=>array('LaboratoryTestOrder.id','LaboratoryTestOrder.patient_id','LaboratoryTestOrder.create_time',
					'LaboratoryHl7Result.id','LaboratoryHl7Result.abnormal_flag'),'conditions'=>array("LaboratoryTestOrder.patient_id IN ($idsStr)")));
			$labCount = array();
			foreach($labData as $labRecords){
				$difference = $this->DateFormat->dateDiff($labRecords['LaboratoryTestOrder']['create_time'],date('Y-m-d H:i:s')) ;
				$showFlag = (($difference->h >= 23 || $difference->d != 0) && empty($labRecords['LaboratoryHl7Result']['id'])) ? true : false;
				$labCount[$labRecords['LaboratoryTestOrder']['patient_id']][$labRecords['LaboratoryTestOrder']['id']]['showFlag'] = $showFlag;
				$flag = ($labRecords['LaboratoryHl7Result']['abnormal_flag']=='A' || $labRecords['LaboratoryHl7Result']['abnormal_flag']=='H' || $labRecords['LaboratoryHl7Result']['abnormal_flag']=='L')? true : false;
				$labCount[$labRecords['LaboratoryTestOrder']['patient_id']][$labRecords['LaboratoryTestOrder']['id']]['abnormalFlag'] = $flag;
				$isResulted = ($labRecords['LaboratoryHl7Result']['id'])? true : false;
				$labCount[$labRecords['LaboratoryTestOrder']['patient_id']][$labRecords['LaboratoryTestOrder']['id']]['is_Resulted'] = $isResulted;
			}
			$this->set('labCount',$labCount);
			/* end of lab start of Rad */
			$this->RadiologyTestOrder->bindModel(array(
					'belongsTo' => array(
							'RadiologyResult' =>array('foreignKey'=>false,'conditions'=>array('RadiologyResult.radiology_test_order_id=RadiologyTestOrder.id')),
					)));
			$radData = $this->RadiologyTestOrder->find('all',array('fields'=>array('RadiologyTestOrder.id','RadiologyTestOrder.patient_id','RadiologyTestOrder.create_time',
					'RadiologyResult.id','RadiologyResult.img_impression'),'conditions'=>array("RadiologyTestOrder.patient_id IN ($idsStr)")));
			$radCount = array();
			$showFlag = '';
			$isResulted = '';
			foreach($radData as $radRecords){
				$difference = $this->DateFormat->dateDiff($radRecords['RadiologyTestOrder']['create_time'],date('Y-m-d H:i:s')) ;
				$showFlag = (($difference->h >= 23 || $difference->d != 0) && empty($radRecords['RadiologyResult']['id'])) ? true : false;
				$radCount[$radRecords['RadiologyTestOrder']['patient_id']][$radRecords['RadiologyTestOrder']['id']]['showFlag'] = $showFlag;
				$isResulted = ($radRecords['RadiologyResult']['id'])? true : false;
				$radCount[$radRecords['RadiologyTestOrder']['patient_id']][$radRecords['RadiologyTestOrder']['id']]['is_Resulted'] = $isResulted;
				$flag = ($radRecords['RadiologyResult']['img_impression'] == 'Positive' || $radRecords['RadiologyResult']['img_impression'] == '' )? false : true;
				$radCount[$radRecords['RadiologyTestOrder']['patient_id']][$radRecords['RadiologyTestOrder']['id']]['abnormalFlag'] = $flag;
			}
			$this->set('radCount',$radCount);
			/** end of Rad */
	
		}
		//EOF lab and radiology
		//**********BOF Managed Critical Value
		if(!empty($data) /* && $future_apt != 'future' */){
	
			$this->LaboratoryResult->bindModel(array(
					'belongsTo'=>array('LaboratoryHl7Result'=>array('foreignKey'=>false,'conditions'=>array('LaboratoryResult.id = LaboratoryHl7Result.laboratory_result_id')))
			));
			$labResultData = $this->LaboratoryResult->find('all',array('fields'=>array('patient_id'),
					'conditions'=>array('OR'=>array(array('LaboratoryHl7Result.abnormal_flag'=>'A'),array('LaboratoryHl7Result.abnormal_flag'=>'L'),array('LaboratoryHl7Result.abnormal_flag'=>'H'))),
					'group'=>array('LaboratoryResult.patient_id')));
			foreach($labResultData as $criticalValue){
				$criticalArray[] = $criticalValue['LaboratoryResult']['patient_id'];
			}
		}
		//**********EOF Managed Critical Value
		//Schedule count
		/*$schedule=$this->Appointment->find('all',array('fields'=>array('COUNT(Appointment.id)as scheCount','Appointment.patient_id'),
				'conditions'=>array('Appointment.date >'=>date('Y-m-d'),'Appointment.is_deleted'=>'0'),'group'=>array('Appointment.patient_id')));
		$this->set('schedule',$schedule);
	
		/*$this->ReferralToSpecialist->bindModel(array('belongsTo'=>array(
		 'Patient'=>array('foreignKey'=>'patient_id'))),false);
		if(!empty($idsStr)){
		$notSentReferrer=$this->ReferralToSpecialist->find('all',array('fields'=>array('ReferralToSpecialist.patient_id','ReferralToSpecialist.speciality_specialist','ReferralToSpecialist.specialist_name'),'conditions'=>array("ReferralToSpecialist.patient_id IN ($idsStr)",'ReferralToSpecialist.is_sent IN (0,1)')));
		$sentReferrer=$this->ReferralToSpecialist->find('all',array('fields'=>array('ReferralToSpecialist.patient_id','ReferralToSpecialist.speciality_specialist','ReferralToSpecialist.specialist_name'),'conditions'=>array("ReferralToSpecialist.patient_id IN ($idsStr)",'ReferralToSpecialist.is_sent=1')));
		foreach($notSentReferrer as $nSent){
		$refererCount[$nSent['ReferralToSpecialist']['patient_id']]['nCount']+=1;
		$referalSpeciality[$nSent['ReferralToSpecialist']['patient_id']][]= $nSent['ReferralToSpecialist']['speciality_specialist'];
		$referalSpecialist[$nSent['ReferralToSpecialist']['patient_id']][]= $nSent['ReferralToSpecialist']['specialist_name'];
	
		}
		foreach($sentReferrer as $ySent){
		$refererCount[$ySent['ReferralToSpecialist']['patient_id']]['yCount']+=1;
		}
		}*/
		}
		$opddoctors = $this->User->getOpdDoctors();
		$this->set('doctors',$opddoctors);
		$this->set(array('data'=>$data,'chambers'=>$chamberList,'criticalArray'=>$criticalArray,
				/*'referalCount'=>$refererCount,'referSpecialist'=>$referalSpecialist,'referSpeciality'=>$referalSpeciality*/));
	}
	
	
	public function rad_management(){
		$this->layout = 'advance';
		$this->uses = array('User');
		$opddoctors = $this->User->getOpdDoctors();
		$this->set('doctors',$opddoctors);
		$this->set('doctorsJson',json_encode($doctors));
	}
	
	public function rad_patient_dashboard($future_apt=null,$patient_id=null,$opt=null,$aptId=null){
		//$this->layout = 'ajax';
		
		$this->uses = array('Chamber','User','Patient','Note','NoteDiagnosis','LaboratoryResult','ServiceCategory',
				'LaboratoryTestOrder','RadiologyTestOrder','RadiologyResult','ReferralToSpecialist','TariffStandard');
		if(!empty($this->request->data)){
			
		}
		//if(empty($this->request->data['Appointment'])){
	
		//$date[0] = date('Y-m-d');
		//}
	/*	if (empty($this->request->data['Appointment']['patient_id'])) {
		 if (!empty($this->params->query['dateFrom'])&&!empty($this->params->query['dateTo'])) {
		$dateFrom = explode(' ',$this->DateFormat->formatDate2STD($this->params->query['dateFrom'],Configure::read('date_format')));
		$dateTo = explode(' ',$this->DateFormat->formatDate2STD($this->params->query['dateTo'],Configure::read('date_format')));
		$this->set('dateSearch','1');
		//$conditions = array('Appointment.is_deleted'=>'0');
		}else{
		$date[0] = date('Y-m-d');
		}
		}
		if(!empty($dateFrom)){
		$conditionFrom=array('Patient.form_received_on >='=>$dateFrom[0].' 00:00:00');
		}
		else{
		$conditionFrom=array('Patient.form_received_on >='=>date('Y-m-d').' 00:00:00');
		}
		if(!empty($dateTo)){
		$conditionDateTo=array('Patient.form_received_on <='=>$dateTo[0].' 23:59:59');
		}
		else{
		$conditionDateTo=array('Patient.form_received_on <='=>date('Y-m-d').' 23:59:59');
		}*/
		if (empty($this->request->data['Appointment']['patient_id'])) {
			$this->set('dateSearch','1');
			if(!empty($this->params->query['dateFrom'])&&!empty($this->params->query['dateTo'])){
				$dateFrom = explode(' ',$this->DateFormat->formatDate2STD($this->params->query['dateFrom'],Configure::read('date_format')));
				$dateTo = explode(' ',$this->DateFormat->formatDate2STD($this->params->query['dateTo'],Configure::read('date_format')));
				$conditionFrom=array('Patient.form_received_on >='=>$dateFrom[0].' 00:00:00');
				$conditionDateTo=array('Patient.form_received_on <='=>$dateTo[0].' 23:59:59');
			}else if(!empty($this->params->query['dateFrom']) && empty($this->params->query['dateTo'])){
				$dateFrom = explode(' ',$this->DateFormat->formatDate2STD($this->params->query['dateFrom'],Configure::read('date_format')));
				$conditionFrom=array('Patient.form_received_on >='=>$dateFrom[0].' 00:00:00');
				$conditionDateTo=array('Patient.form_received_on <='=>date('Y-m-d').' 23:59:59');
			}else if(empty($this->params->query['dateFrom']) && !empty($this->params->query['dateTo'])){
				$dateTo = explode(' ',$this->DateFormat->formatDate2STD($this->params->query['dateTo'],Configure::read('date_format')));
				$conditionFrom=array('Patient.form_received_on >='=>date('Y-m-d').' 00:00:00');
				$conditionDateTo=array('Patient.form_received_on <='=>$dateTo[0].' 23:59:59');
			}
			else if(empty($this->params->query['dateFrom']) && empty($this->params->query['dateTo'])){
				$date[0] = date('Y-m-d');
			}
		}
		$role = $this->Session->read('role');
		if($role == Configure::read('doctorLabel') || $role==Configure::read('residentLabel')){
			$conditionDoctor = array('Patient.doctor_id'=>$this->Session->read('userid'));
	
		}
		if($this->request->params['pass'][0] == Configure::read('nurseLabel')){
			$nurseCondition = 'Appointment.nurse_id='.$this->Session->read('userid');
			$this->set('viewAll','0');
	
		}
		else{
			$this->set('viewAll','1');
		}
	
		//To get Mandatory Service Id
		$this->ServiceCategory->unbindModel(array('hasMany'=>array('ServiceSubCategory')));
		$paymentCategoryId=$this->ServiceCategory->find('first',array('fields'=>array('id'),'conditions'=>array('ServiceCategory.name Like'=>Configure::read('mandatoryServices'))));
	
		//tariff List Private Id
		$privateID = $this->TariffStandard->getPrivateTariffID();//retrive private ID
		$this->set('privateId',$privateID);
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'User' =>array('foreignKey'=>'doctor_id'),
						'Person'=>array('foreignKey'=>false,'conditions'=>array('Person.id=Patient.person_id')),
						'Diagnosis'=>array('foreignKey'=>false,'conditions'=>array('Diagnosis.patient_id=Patient.id','Diagnosis.is_discharge'=>0)),
						'FinalBilling'=>array('foreignKey'=>false,'conditions'=>array('FinalBilling.patient_id=Patient.id')),
						'Billing'=>array('foreignKey'=>false,'conditions'=>array('Billing.patient_id=Patient.id')),
						"BillingAlias"=>array('className'=>'Billing',"foreignKey"=>false ,
								'conditions'=>array('BillingAlias.patient_id=Patient.id','BillingAlias.payment_category'=>$paymentCategoryId['ServiceCategory']['id'])),
						'NewCropPrescription'=>array('foreignKey'=>false,
								'conditions'=>array('NewCropPrescription.patient_uniqueid =Patient.id','NewCropPrescription.archive'=>'N','NewCropPrescription.is_med_administered'=>'1')),
						"NewCropPrescriptionAlias"=>array('className'=>'NewCropPrescription',"foreignKey"=>false ,
								'conditions'=>array('NewCropPrescriptionAlias.patient_uniqueid =Patient.id','NewCropPrescriptionAlias.archive'=>'N','NewCropPrescriptionAlias.is_med_administered'=>'2')),
						'Note'=>array('foreignKey'=>false,
								'conditions'=>array('Note.patient_id =Patient.id')),
						),
				'hasmany'=>array()
		),false); //hasmany for future appt.
	
		$this->paginate = array(
				'update' => '#list_content',
				'evalScripts' => true
		);
			
		$conditionIsDeleted = array('Patient.is_deleted'=>'0');
		$conditionStatus = array('Patient.is_discharge'=>'0');
		$conditionLocation = array('Patient.location_id'=>$this->Session->read('locationid'));
		//doctor filter (click on tabs)
		//if (!empty($this->request->data['Appointment']['All Doctors'])) {
		/* if (!empty($this->request->data['Appointment']['doctor_id'])) {
		 $conditionsDoc = array('Appointment.doctor_id'=>$this->request->data['Appointment']['doctor_id']);
		} */
	
	
		if (!empty($this->request->data['Appointment']['patient_id'])) {
			//To find the list of all the patient having name like searched name
			$patientIds=$this->Patient->find('list',array('fields'=>array('id'),
					'conditions'=>array('Patient.lookup_name LIKE'=>'%'.$this->request->data['Appointment']['patient_name'].'%')));
			
			$conditionPatientId =array('Patient.id'=>$patientIds);
			
		}
		if($this->params->query['doctorsId']){
			/* foreach($this->request->data as $key=>$value){
			 if($key=='context-menu-input-'.$value){
			$doctorArray[]=$value;
			}
			} */
			$docArray=explode('_',$this->params->query['doctorsId']);
			$docArray=implode(',',$docArray);
			if(!empty($docArray)){
				$conditionDoctor=array('Patient.doctor_id IN ('.$docArray.")");
			}
			$rt='1';
			$this->set('rtSelect',$rt);
		}
		if($future_apt == 'future'||!empty($this->request->data['Appointment']['patient_id'])||$this->params->query['doctorsId']||!empty($this->params->query['dateFrom'])||!empty($this->params->query['dateTo'])){
			if(!empty($this->params->query['dateFrom'])||!empty($this->params->query['dateTo'])){
				$conditions=array($conditionDoctor,$conditionIsDeleted/*,$conditionStatus*/,$conditionLocation,$conditionPatientId,$nurseCondition,$conditionDateTo,$conditionFrom);
			}else{
				$conditions=array($conditionDoctor,$conditionIsDeleted/*,$conditionStatus*/,$conditionLocation,$conditionPatientId,$nurseCondition);
			}
		}
		else{
			$conditions=array($conditionDoctor,$conditionIsDeleted,$conditionStatus,$conditionLocation,$conditionPatientId,$nurseCondition);
	
		}
		//To Show Today's Closed Appointment
		if($this->params->query['closed']=='closed')//for pagination
			$future_apt='closed';
	
		if($future_apt== 'closed'){
			$conditionStatus=array('Patient.is_discharge '=>'1');
			$conditions=array($conditionDoctor,$conditionIsDeleted,$conditionStatus,$conditionLocation,$conditionPatientId,$nurseCondition);
		}
	
	
	
		if($future_apt == 'closed'){
			$this->Patient->bindModel(array(
					'belongsTo' => array(
							'User' =>array('foreignKey'=>'doctor_id'),
							'Person'=>array('foreignKey'=>false,'conditions'=>array('Person.id=Patient.person_id')),
							'Diagnosis'=>array('foreignKey'=>false,'conditions'=>array('Diagnosis.patient_id=Patient.id','Diagnosis.is_discharge'=>0)),
							'FinalBilling'=>array('foreignKey'=>false,'conditions'=>array('FinalBilling.patient_id=Patient.id')),
							'Billing'=>array('foreignKey'=>false,'conditions'=>array('Billing.patient_id=Patient.id')),
							'NewCropPrescription'=>array('foreignKey'=>false,
									'conditions'=>array('NewCropPrescription.patient_uniqueid =Patient.id','NewCropPrescription.archive'=>'N','NewCropPrescription.is_med_administered'=>'1')),
							"NewCropPrescriptionAlias"=>array('className'=>'NewCropPrescription',"foreignKey"=>false ,
									'conditions'=>array('NewCropPrescriptionAlias.patient_uniqueid =Patient.id','NewCropPrescriptionAlias.archive'=>'N','NewCropPrescriptionAlias.is_med_administered'=>'2')),
							
							'Note'=>array('foreignKey'=>false,
									'conditions'=>array('Note.patient_id =Patient.id')),
							),
					'hasmany'=>array()
			),false); //hasmany for future appt.
							$conditions = array_merge($conditions,array('Patient.admission_type '=>'RAD','Patient.form_received_on >='=>date('Y-m-d 00:00:00'),'Patient.form_received_on <='=>date('Y-m-d 23:59:59')));
	
							$this->paginate = array(
									'limit' => '8',
									'fields'=> array('concat(User.first_name," ",User.last_name) as full_name','Patient.id','Patient.patient_id','Patient.person_id','Patient.age',
											'Patient.lookup_name','Person.decline_portal','Person.payment_category','Person.vip_chk','Patient.is_discharge ',
											'Patient.nurse_id','Person.mobile','Person.dob','Person.email','Person.ssn_us','Person.patient_credentials_created_date','Person.patient_uid' ,
											'Patient.tariff_standard_id',
											'Person.id','Person.sex','VerifyMedicationOrder.id','Patient.is_opd','Billing.patient_id','Billing.total_amount',
											'SUM(Billing.amount_pending) as amount_pending','SUM(Billing.amount) as amount_paid','SUM(Billing.discount) as discount',
											'SUM(Billing.paid_to_patient) as refund',
											'Person.photo','Person.patient_credentials_created_date','Person.patient_uid','Count(Note.id) as noteCount','Note.has_no_followup',
											'Count(Diagnosis.id) as initCount','Diagnosis.id','Diagnosis.flag_event','Count(FinalBilling.id) as paidCount','NewCropPrescriptionAlias.id',
											'NewCropPrescriptionAlias.is_med_administered','NewCropPrescription.id','NewCropPrescription.is_med_administered',
											'Count(NewCropPrescription.id)as medication','Encounter.id','NewInsurance.is_eligible','Note.id','Note.sign_note'),
									'conditions'=>$conditions,'group'=>array('Patient.id'),
	
							);
	
							$this->set('closed',$future_apt);
		}else if($future_apt == 'future'){
			if (empty($this->request->data['Appointment']['patient_id'])) {
				if(strtotime($date[0]) > strtotime(date('Y-m-d'))){
					$conditions = array_merge($conditions,array('Patient.form_received_on'=>$date[0].' 00:00:00'));
				}else{
					$conditions = array_merge($conditions,array('Patient.form_received_on >'=>date('Y-m-d').' 00:00:00'));
				}
			}
	
			$this->paginate = array(
					'limit' => 8,
					'fields'=> array('concat(User.first_name," ",User.last_name) as full_name','Patient.patient_id','Patient.person_id','Patient.lookup_name','Patient.form_received_on','Patient.is_discharge ',
							'Person.mobile','Person.email','Person.dob','Person.patient_credentials_created_date','Person.patient_uid' ,'Person.id','Person.sex','Person.patient_credentials_created_date','NewInsurance.*','Encounter.*','Note.*'),
					'conditions'=>$conditions,'group'=>array('Patient.id')
					//'DATE_FORMAT(Appointment.create_time,"%b %d %Y")'=>date('Y-m-d'),
			);
	
			$this->set('future',$future_apt);
		}else{
			if (empty($this->request->data['Appointment']['patient_id'])) {
				//Edited by-Pooja (Please confirm before editing)
				if(!empty($dateFrom) && !empty($dateTo)){
					$todayCondition = $conditions;
				}
				else if(!empty($dateFrom)){
					$todayCondition = $conditions;
				}else if(!empty($dateTo)){
					$todayCondition = $conditions;
				}else{
					$todayCondition = array_merge($conditions,array('Patient.form_received_on >='=>$date[0].' 00:00:00', 'Patient.form_received_on <='=>$date[0].' 23:59:59'));
				}
			}else if(!empty($this->request->data['Appointment']['patient_id']) && ($this->request->data['Appointment']['Discharged']=='1')){
				$conditionDischarged = array('Patient.is_discharge '=>'1');
				$todayCondition=array_merge($conditions,$conditionDischarged);	
			}
			elseif(!empty($this->request->data['Appointment']['patient_id'])){
				$conditionDischarged = array('Patient.is_discharge '=>'0');
				$todayCondition=array_merge($conditions,$conditionDischarged);
			}
			$role=$this->Session->read('role');
			if($role==Configure::read('doctorLabel')||$role==Configure::read('nurseLabel') || $role==Configure::read('medicalAssistantLabel') || $role==Configure::read('residentLabel'))
			{
				if(!empty($dateFrom) && !empty($dateTo)){
					$order= 'Note.sign_note asc' ; //for keyword order "Sign Note"
				}
				else{
					$order= "IF(instr(Appointment.status, 'In-Progress'), instr(Appointment.status, 'In-Progress'), 65535) asc" ; //for keyword order "In-Progress"
				}
			}
			else{
				//Order by for ordering the in the status in sequence of Arrived, Scheduled, Assigned, and Seen - Pooja ///
				/*$order="(CASE Appointment.status
				 WHEN 'Arrived' 	 THEN 1
						WHEN 'Ready' 	 THEN 2
						WHEN 'Scheduled' THEN 3
						WHEN 'Pending' 	 THEN 4
						WHEN 'Assigned'  THEN 5
						WHEN 'Seen' THEN 6
						ELSE 100 END) ASC, Appointment.status DESC";*/
				//$order="IF(instr(Appointment.status, 'Arrived'), instr(Appointment.status, 'Arrived'), 65535) asc" ; //for keyword order 'Arrived'
			}
			$this->paginate = array(
					'limit' => '8',
					'fields'=> array('concat(User.first_name," ",User.last_name) as full_name','Patient.id','Patient.patient_id','Patient.person_id','Patient.age',
							'Patient.lookup_name','Person.vip_chk','Patient.form_received_on',
							'Patient.nurse_id','Person.mobile','Person.dob','Person.email','Person.ssn_us','Person.patient_credentials_created_date','Person.patient_uid' ,
							'Patient.tariff_standard_id','Patient.is_discharge ',
							'Person.id','Person.sex','Patient.is_opd','Billing.patient_id','Billing.total_amount',
							'SUM(Billing.amount_pending) as amount_pending','SUM(Billing.amount) as amount_paid','SUM(Billing.discount) as discount',
							'SUM(Billing.paid_to_patient) as refund','Person.photo','Person.patient_credentials_created_date','Person.patient_uid','Count(Note.id) as noteCount','Note.has_no_followup',
							'Count(Diagnosis.id) as initCount','Diagnosis.id','Count(FinalBilling.id) as paidCount','NewCropPrescriptionAlias.id',
							'NewCropPrescriptionAlias.is_med_administered','NewCropPrescription.id','NewCropPrescription.is_med_administered',
							'Count(NewCropPrescription.id)as medication','Note.id','Note.sign_note' ),
							'conditions'=>array($todayCondition,'Patient.admission_type'=>'RAD','Patient.id NOT'=>NULL),
							'group'=>array('Patient.id')
							//'DATE_FORMAT(Appointment.create_time,"%b %d %Y")'=>date('Y-m-d'),
			);
	
		}
		$nurses  = $this->User->getUsersByRoleName(Configure::read('nurseLabel')) ;
		$this->set('nurses',$nurses);
		$chamberList = $this->Chamber->getChamberList();
		$this->set('id',$patient_id);
		$data = $this->paginate('Patient') ; //debug($data); exit;
		$this->set('count',COUNT($data)); //Counting the data in appointment table
		// lab Rad count ---- BOF Gaurav
		if($future_apt != 'future' && !empty($data)){
			foreach($data as $patientKey => $patientValue){
				$ids[] = $patientValue['Patient']['id'] ;
			}
			$idsStr = implode(",",$ids) ;
			/** Lab Code Start*/
			$this->LaboratoryTestOrder->bindModel(array(
					'belongsTo' => array(
							'LaboratoryResult' =>array('foreignKey'=>false,'conditions'=>array('LaboratoryResult.laboratory_test_order_id=LaboratoryTestOrder.id')),
							'LaboratoryHl7Result'=>array('foreignKey'=>false,'conditions'=>array('LaboratoryHl7Result.laboratory_result_id=LaboratoryResult.id')),
					)));
			$labData = $this->LaboratoryTestOrder->find('all',array('fields'=>array('LaboratoryTestOrder.id','LaboratoryTestOrder.patient_id','LaboratoryTestOrder.create_time',
					'LaboratoryHl7Result.id','LaboratoryHl7Result.abnormal_flag'),'conditions'=>array("LaboratoryTestOrder.patient_id IN ($idsStr)")));
			$labCount = array();
			foreach($labData as $labRecords){
				$difference = $this->DateFormat->dateDiff($labRecords['LaboratoryTestOrder']['create_time'],date('Y-m-d H:i:s')) ;
				$showFlag = (($difference->h >= 23 || $difference->d != 0) && empty($labRecords['LaboratoryHl7Result']['id'])) ? true : false;
				$labCount[$labRecords['LaboratoryTestOrder']['patient_id']][$labRecords['LaboratoryTestOrder']['id']]['showFlag'] = $showFlag;
				$flag = ($labRecords['LaboratoryHl7Result']['abnormal_flag']=='A' || $labRecords['LaboratoryHl7Result']['abnormal_flag']=='H' || $labRecords['LaboratoryHl7Result']['abnormal_flag']=='L')? true : false;
				$labCount[$labRecords['LaboratoryTestOrder']['patient_id']][$labRecords['LaboratoryTestOrder']['id']]['abnormalFlag'] = $flag;
				$isResulted = ($labRecords['LaboratoryHl7Result']['id'])? true : false;
				$labCount[$labRecords['LaboratoryTestOrder']['patient_id']][$labRecords['LaboratoryTestOrder']['id']]['is_Resulted'] = $isResulted;
			}
			$this->set('labCount',$labCount);
			/* end of lab start of Rad */
			$this->RadiologyTestOrder->bindModel(array(
					'belongsTo' => array(
							'RadiologyResult' =>array('foreignKey'=>false,'conditions'=>array('RadiologyResult.radiology_test_order_id=RadiologyTestOrder.id')),
					)));
			$radData = $this->RadiologyTestOrder->find('all',array('fields'=>array('RadiologyTestOrder.id','RadiologyTestOrder.patient_id','RadiologyTestOrder.create_time',
					'RadiologyResult.id','RadiologyResult.img_impression'),'conditions'=>array("RadiologyTestOrder.patient_id IN ($idsStr)")));
			$radCount = array();
			$showFlag = '';
			$isResulted = '';
			foreach($radData as $radRecords){
				$difference = $this->DateFormat->dateDiff($radRecords['RadiologyTestOrder']['create_time'],date('Y-m-d H:i:s')) ;
				$showFlag = (($difference->h >= 23 || $difference->d != 0) && empty($radRecords['RadiologyResult']['id'])) ? true : false;
				$radCount[$radRecords['RadiologyTestOrder']['patient_id']][$radRecords['RadiologyTestOrder']['id']]['showFlag'] = $showFlag;
				$isResulted = ($radRecords['RadiologyResult']['id'])? true : false;
				$radCount[$radRecords['RadiologyTestOrder']['patient_id']][$radRecords['RadiologyTestOrder']['id']]['is_Resulted'] = $isResulted;
				$flag = ($radRecords['RadiologyResult']['img_impression'] == 'Positive' || $radRecords['RadiologyResult']['img_impression'] == '' )? false : true;
				$radCount[$radRecords['RadiologyTestOrder']['patient_id']][$radRecords['RadiologyTestOrder']['id']]['abnormalFlag'] = $flag;
			}
			$this->set('radCount',$radCount);
			/** end of Rad */
	
		}
		//EOF lab and radiology
		//**********BOF Managed Critical Value
		if(!empty($data) /* && $future_apt != 'future' */){
	
			$this->LaboratoryResult->bindModel(array(
					'belongsTo'=>array('LaboratoryHl7Result'=>array('foreignKey'=>false,'conditions'=>array('LaboratoryResult.id = LaboratoryHl7Result.laboratory_result_id')))
			));
			$labResultData = $this->LaboratoryResult->find('all',array('fields'=>array('patient_id'),
					'conditions'=>array('OR'=>array(array('LaboratoryHl7Result.abnormal_flag'=>'A'),array('LaboratoryHl7Result.abnormal_flag'=>'L'),array('LaboratoryHl7Result.abnormal_flag'=>'H'))),
					'group'=>array('LaboratoryResult.patient_id')));
			foreach($labResultData as $criticalValue){
				$criticalArray[] = $criticalValue['LaboratoryResult']['patient_id'];
			}
		}
		//**********EOF Managed Critical Value
		//Schedule count
		/*$schedule=$this->Appointment->find('all',array('fields'=>array('COUNT(Appointment.id)as scheCount','Appointment.patient_id'),
				'conditions'=>array('Appointment.date >'=>date('Y-m-d'),'Appointment.is_deleted'=>'0'),'group'=>array('Appointment.patient_id')));
		$this->set('schedule',$schedule);
	
		/*$this->ReferralToSpecialist->bindModel(array('belongsTo'=>array(
		 'Patient'=>array('foreignKey'=>'patient_id'))),false);
		if(!empty($idsStr)){
		$notSentReferrer=$this->ReferralToSpecialist->find('all',array('fields'=>array('ReferralToSpecialist.patient_id','ReferralToSpecialist.speciality_specialist','ReferralToSpecialist.specialist_name'),'conditions'=>array("ReferralToSpecialist.patient_id IN ($idsStr)",'ReferralToSpecialist.is_sent IN (0,1)')));
		$sentReferrer=$this->ReferralToSpecialist->find('all',array('fields'=>array('ReferralToSpecialist.patient_id','ReferralToSpecialist.speciality_specialist','ReferralToSpecialist.specialist_name'),'conditions'=>array("ReferralToSpecialist.patient_id IN ($idsStr)",'ReferralToSpecialist.is_sent=1')));
		foreach($notSentReferrer as $nSent){
		$refererCount[$nSent['ReferralToSpecialist']['patient_id']]['nCount']+=1;
		$referalSpeciality[$nSent['ReferralToSpecialist']['patient_id']][]= $nSent['ReferralToSpecialist']['speciality_specialist'];
		$referalSpecialist[$nSent['ReferralToSpecialist']['patient_id']][]= $nSent['ReferralToSpecialist']['specialist_name'];
	
		}
		foreach($sentReferrer as $ySent){
		$refererCount[$ySent['ReferralToSpecialist']['patient_id']]['yCount']+=1;
		}
		}*/
		$opddoctors = $this->User->getOpdDoctors();
		$this->set('doctors',$opddoctors);
		$this->set(array('data'=>$data,'chambers'=>$chamberList,'criticalArray'=>$criticalArray,
				/*'referalCount'=>$refererCount,'referSpecialist'=>$referalSpecialist,'referSpeciality'=>$referalSpeciality*/));
	}
	
	public function lab_count(){
		$role=$this->Session->read('role');
		if($role==Configure::read('doctorLabel')){
			$condition['Patient.doctor_id']= $this->Session->read('userid');
			$condition['Patient.form_received_on']= date('Y-m-d').' %' ;
		}else if($role==Configure::read('nurseLabel')){
			$condition['Patient.nurse_id']= $this->Session->read('userid');
			$condition['Patient.form_received_on']= date('Y-m-d').' %' ;
		}else{
			$condition['Patient.form_received_on LIKE']= date('Y-m-d').' %' ;
		}
		$this->loadModel('Patient');
		$latestCount=$this->Patient->find('count',array('conditions'=>array($condition, 'Patient.admission_type'=>'LAB','Patient.is_discharge'=>'0')));
		echo $latestCount;
		exit;
	}
	
	public function rad_count(){
		$role=$this->Session->read('role');
		if($role==Configure::read('doctorLabel')){
			$condition['Patient.doctor_id']= $this->Session->read('userid');
			$condition['Patient.form_received_on']= date('Y-m-d').' %' ;
		}else if($role==Configure::read('nurseLabel')){
			$condition['Patient.nurse_id']= $this->Session->read('userid');
			$condition['Patient.form_received_on']= date('Y-m-d').' %' ;
		}else{
			$condition['Patient.form_received_on']= date('Y-m-d').' %' ;
		}
		$this->loadModel('Patient');
		$latestCount=$this->Patient->find('count',array('conditions'=>array($condition, 'Patient.admission_type'=>'RAD','Patient.is_discharge'=>'0')));
		echo $latestCount;
		exit;
	}
	
	/**
	 * Patient Queue
	 * @author Gaurav Chauriya
	 */
	public function patientWaitingList(){
		$this->layout = 'advance_ajax';
		$this->uses=array('User','Chamber');
		$this->set('chamberList' , $this->Chamber->find('all',array('fields'=>array('id','name'),'conditions' => array('Chamber.is_deleted'=> 0,
						'Chamber.location_id'=>$this->Session->read('locationid')))));
		$this->set('listDoctor',$this->User->getOpdDoctors());
	}
	
	
	/**
	 * Patient Queue listing page
	 * @author Gaurav Chauriya
	 */
	public function chamberPatient($doctorId,$chamberId){
		$this->layout = false;
		$this->autoRender = false;
		$this->uses=array('Appointment','Patient');
		$this->Appointment->bindModel(array(
				'belongsTo' => array(
						'Patient' =>array('foreignKey'=>'patient_id'),
						//'Department' =>array('foreignKey'=>'department_id'),
				)));
		$this->paginate = array(
				'update' => '#list_content',
				'evalScripts' => true
	
		);
		$this->paginate = array(
				'limit' => 13,
				'order' => array('Appointment.create_time' => 'desc'),
				'fields'=> array('Appointment.id','Appointment.token_no','Patient.lookup_name','Appointment.start_time','Appointment.status'),
				'conditions'=>array('Appointment.is_deleted'=>'0','Appointment.date'=>date('Y-m-d'),"Appointment.status"=>array("Arrived","In-Progress","Seen","Assigned","Ready"),
						'Appointment.doctor_id'=>$doctorId,'chamber_id'=>$chamberId,'token_no NOT'=>null),
				'order'=> 'token_no'
				//'order'=>'FIELD(Appointment.status, "Ready") DESC, Appointment.start_time ASC'
		);
		$this->set('id',$patient_id);
		$patientLists = $this->paginate('Appointment');
		foreach($patientLists as $key=>$patientList){
	
	
			$patientListData[$key]['patientName']=$patientList['Patient']['lookup_name'];
			$patientListData[$key]['start_time']=$patientList['Appointment']['start_time'];
			$patientListData[$key]['token_no']=$patientList['Appointment']['token_no'];
			$patientListData[$key]['status']= $patientList['Appointment']['status'];
			$startTimeExplode=explode(':',$patientList['Appointment']['start_time']);
			$curTimeExplode=explode(':',date('H:i:s'));
			/* logic for remain time Aditya */
			if($startTimeExplode['0'] >= $curTimeExplode['0']){
				$hr=$startTimeExplode['0']-$curTimeExplode['0'];
				if($startTimeExplode['1']>$curTimeExplode['1']){
					$min=$startTimeExplode['1']-$curTimeExplode['1'];
				}else{
					$min=$curTimeExplode['1']-$startTimeExplode['1'];
				}
				$patientListData[$key]['remain_time']=$hr.":".$min;
			}else{
				$patientListData[$key]['remain_time']="00:00";
			}
			/* EOD */
		}
		$this->set('data',$patientListData);
		$this->render('chamber_patient');
	
	}
	
/**
 * Function to close encouter of LAB ad RAD patients
 * 
 */
	
	public function update_encounter(){
		if(!empty($this->request->data)){
			$this->loadModel('Patient');
			$this->Patient->updateAll(array('Patient.is_discharge'=>'1','Patient.discharge_date'=>"'".date('Y-m-d H:i:s')."'"),array('Patient.id'=>$this->request->data['id']));
			exit;
		}	
		
	}
	
function set_multiple_appointment($patientID){
		$this->layout='advance_ajax';
		$this->uses=array('User','TariffList','Department','Patient','TariffStandard','Billing');
		
		if($this->request->data){
			$serviceIds=$this->Appointment->setMultipleAppointment($this->request->data);
			$this->set('close','1');
			/*if($this->request->data["Patient"]['pay_amt']=='1'){
				$billId=$this->Billing->saveRegBill($this->request->data,$serviceIds);
				$this->redirect(array("controller" => "Appointments", "action" => "set_multiple_appointment",'?'=>array('print'=>$billId)));
			}*/
		}
		
		$OPCheckUpOptions=$this->TariffList->find('list',array('fields'=>array('id','name'),'conditions'=>array('is_deleted'=>'0','check_status'=>'1','location_id'=>$this->Session->read('locationid'))));
		$this->set('opdoptions',$OPCheckUpOptions);
		$this->set('doctorlist',$this->User->getOpdDoctors());
		$this->set('departments',$this->Department->find('list',array('fields'=>array('id','name'),'conditions'=>array('Department.location_id'=>$this->Session->read('locationid')),'order' => array('Department.name'))));
		$patientData=$this->Patient->find('first',array('fields'=>array('Patient.id','Patient.person_id','Patient.location_id','Patient.tariff_standard_id','Patient.lookup_name'
				,'Patient.form_received_on','Patient.admission_id'),
				'conditions'=>array('Patient.id'=>$patientID)));
		$tariffName=$this->TariffStandard->getTariffStandardName($patientData['Patient']['tariff_standard_id']);
		$this->set('patientData',$patientData);
		$this->set('tariffName',$tariffName);

		$currentAppointment = $this->Appointment->getAppointmentsByPatientID($patientID);
		$this->set('currentAppointment',$currentAppointment);
	}

	public function update_token_number(){
		$this->autoRender = false;
		$this->loadmodel('Appointment');

		$id = $this->request->data['id']; 
		$patientId = $this->request->data['patient_id'];
		$tokenNo = $this->request->data['token_no'];
		$updateArray = array('Appointment.token_no'=>'"'.$tokenNo.'"') ;
		$this->Appointment->updateAll($updateArray,array('Appointment.id'=>$id,'Appointment.patient_id'=>$patientId));
		
		exit;
	}

	function createOpdInvoice($patientId){
		$this->layout = 'advance';
		$this->uses = array('Patient','OpdInvoice','OpdInvoiceDetail');

		if($this->request->data){

			#debug($this->request->data);exit;
				if($this->request->data['OpdInvoice']['id'] == ''){
					$this->request->data['OpdInvoice']['bill_number']  =  $this->OpdInvoice->generateInvoiceNo();
				}
				
				$this->request->data['OpdInvoice']['date']  = $this->DateFormat->formatDate2STD($this->request->data['OpdInvoice']['date'],Configure::read('date_format'));
				$this->request->data['OpdInvoice']['create_time']  = date('Y-m-d H:i:s');
    			$this->request->data['OpdInvoice']['created_by']   = $this->Session->read('userid');
    			
    			$this->OpdInvoice->save($this->request->data);
    			$lastId = $this->OpdInvoice->id;

    			/*delete existing entries*/
				$this->OpdInvoiceDetail->deleteAll(array('OpdInvoiceDetail.opd_invoice_id' => $lastId));


			    foreach ($this->request->data['OpdInvoiceDetail']['tests'] as $key => $value) {
			    	if(!empty($value)){
			    		$saveDetails['opd_invoice_id'] = $lastId;
						$saveDetails['services'] = $value;
						
						$this->OpdInvoiceDetail->save($saveDetails);
						$this->OpdInvoiceDetail->id = '';
			    	}
			    		
			    
			    }

		    if($lastId){
				$this->Session->setFlash(__('Records Saved successfully' ),'default',array('class'=>'message'));
				$this->redirect(array("controller" => "Appointments", "action" => "createOpdInvoice",$patientId));	
			}else{
				$this->Session->setFlash(__('Something Went Wrong ! Please Try Again' ),'default',array('class'=>'erroe'));
				$this->redirect(array("controller" => "Appointments", "action" => "createOpdInvoice",$patientId));	
			}

		}
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id')),
				)));

		$getBasicData=$this->Patient->find('first',array('fields'=>array('Patient.id','Patient.person_id','Person.dob','Patient.lookup_name','Patient.age','Patient.sex','Patient.admission_type', 'Patient.admission_id','Person.patient_uid','Patient.executive_emp_id_no','Patient.name_police_station'),
				'conditions'=>array('Patient.id'=>$patientId)));
		$age = $this->getAge($getBasicData['Person']['dob']);


		$this->OpdInvoice->bindModel(array(
			'hasMany'=>array(
				'OpdInvoiceDetail'=>array('foreingKey'=>'opd_invoice_id'),
				/*'OpdInvoiceDetail' => array(
                     'foreignKey' => false,
                    'className' => 'OpdInvoiceDetail',
                    'finderQuery' => 'select OpdInvoiceDetail.service_id,OpdInvoiceDetail.service_type,laboratories.name,radiologies.name,tariff_lists.name from opd_invoice_details  as OpdInvoiceDetail left join 
                        laboratories on(OpdInvoiceDetail.service_id=laboratories.id AND OpdInvoiceDetail.service_type="lab") left join radiologies on(OpdInvoiceDetail.service_id=radiologies.id AND OpdInvoiceDetail.service_type="rad") left join tariff_lists on(OpdInvoiceDetail.service_id=tariff_lists.id AND OpdInvoiceDetail.service_type="other") where  OpdInvoiceDetail.opd_invoice_id ={$__cakeID__$} ' 
                ),*/
				)


		));

		$savedData = $this->OpdInvoice->find('first',array('conditions'=>array('OpdInvoice.patient_id'=>$patientId))) ;
		
		$this->set(array('getBasicData'=>$getBasicData,'age'=>$age,'savedData'=>$savedData));

	}


	function printOpdInvoice($patientId){
		$this->uses = array('Patient','OpdInvoice','OpdInvoiceDetail');
        $this->layout = 'print_without_header' ;
       	$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id')),
				)));

		$getBasicData=$this->Patient->find('first',array('fields'=>array('Patient.id','Patient.person_id','Person.dob','Patient.lookup_name','Patient.age','Patient.sex','Patient.admission_type', 'Patient.admission_id','Person.patient_uid','Patient.executive_emp_id_no','Patient.name_police_station'),
				'conditions'=>array('Patient.id'=>$patientId)));
		$age = $this->getAge($getBasicData['Person']['dob']);


		$this->OpdInvoice->bindModel(array(
			'hasMany'=>array(
				'OpdInvoiceDetail'=>array('foreingKey'=>'opd_invoice_id'),
				/*'OpdInvoiceDetail' => array(
                     'foreignKey' => false,
                    'className' => 'OpdInvoiceDetail',
                    'finderQuery' => 'select OpdInvoiceDetail.service_id,OpdInvoiceDetail.service_type,laboratories.name,radiologies.name,tariff_lists.name from opd_invoice_details  as OpdInvoiceDetail left join 
                        laboratories on(OpdInvoiceDetail.service_id=laboratories.id AND OpdInvoiceDetail.service_type="lab") left join radiologies on(OpdInvoiceDetail.service_id=radiologies.id AND OpdInvoiceDetail.service_type="rad") left join tariff_lists on(OpdInvoiceDetail.service_id=tariff_lists.id AND OpdInvoiceDetail.service_type="other") where  OpdInvoiceDetail.opd_invoice_id ={$__cakeID__$} ' 
                ),*/
				)


		));

		$savedData = $this->OpdInvoice->find('first',array('conditions'=>array('OpdInvoice.patient_id'=>$patientId))) ;

		$this->set(array('getBasicData'=>$getBasicData,'age'=>$age,'savedData'=>$savedData));
         
	}

	function opdInvoiceDoc($patientId){
		$this->uses = array('Patient','OpdInvoice','OpdInvoiceDetail');
        $this->layout = false; ;
       	$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id')),
				)));

		$getBasicData=$this->Patient->find('first',array('fields'=>array('Patient.id','Patient.person_id','Person.dob','Patient.lookup_name','Patient.age','Patient.sex','Patient.admission_type', 'Patient.admission_id','Person.patient_uid','Patient.executive_emp_id_no','Patient.name_police_station'),
				'conditions'=>array('Patient.id'=>$patientId)));
		$age = $this->getAge($getBasicData['Person']['dob']);


		$this->OpdInvoice->bindModel(array(
			'hasMany'=>array(
				'OpdInvoiceDetail'=>array('foreingKey'=>'opd_invoice_id'),
				/*'OpdInvoiceDetail' => array(
                     'foreignKey' => false,
                    'className' => 'OpdInvoiceDetail',
                    'finderQuery' => 'select OpdInvoiceDetail.service_id,OpdInvoiceDetail.service_type,laboratories.name,radiologies.name,tariff_lists.name from opd_invoice_details  as OpdInvoiceDetail left join 
                        laboratories on(OpdInvoiceDetail.service_id=laboratories.id AND OpdInvoiceDetail.service_type="lab") left join radiologies on(OpdInvoiceDetail.service_id=radiologies.id AND OpdInvoiceDetail.service_type="rad") left join tariff_lists on(OpdInvoiceDetail.service_id=tariff_lists.id AND OpdInvoiceDetail.service_type="other") where  OpdInvoiceDetail.opd_invoice_id ={$__cakeID__$} ' 
                ),*/
				)


		));

		$savedData = $this->OpdInvoice->find('first',array('conditions'=>array('OpdInvoice.patient_id'=>$patientId))) ;

		$this->set(array('getBasicData'=>$getBasicData,'age'=>$age,'savedData'=>$savedData));
         
	}

      
//             public function uniqueqr_list() {
//                 	if($this->params->query['type'] == "slidesix"){
// 			$this->layout = 'advance_ajax';
//                 		}else{
//                 			$this->layout = 'advance';
//                 		}
//                       $this->loadModel('Patient'); 
//                     //   debug('Patient');exit;
//                     $this->loadModel('Person');

//                                 // Fetching data from both Person and Patient tables with a join on the Patient's patient_id matching Person's id
//                               $persons = $this->Person->find('all', array(
//                                             'conditions' => array(
//                                                 'Person.admission_type' => 'OPD',
//                                                 'Person.create_time >=' => '2024-11-14 00:00:00',
//                                             ),
//                                             'joins' => array(
//                                                 array(
//                                                     'table' => 'patients',            // Assuming the table name is 'patients'
//                                                     'alias' => 'Patient',             // Alias for the Patient model
//                                                     'type' => 'INNER',                // INNER JOIN, you can change it to LEFT if necessary
//                                                     'conditions' => 'Patient.patient_id = Person.patient_uid'  // Join condition
//                                                 )
//                                             ),
//                                             'fields' => array('Person.*', 'Patient.*'),  // Select fields from both tables
//                                             'order' => array('Person.create_time DESC')  // Order by create_time in descending order
//                                         ));
//                                         // debug($persons);exit;
//                                         $this->set(compact('persons'));

//     }
    
                	public function uniqueqr_list()
            {
                $userSession = $this->Session->read('Auth.User');
                $userDatabase = $this->Session->read('db_name'); 
                if ($this->params->query['type'] == "slidesix") {
                    $this->layout = 'advance_ajax';
                } else {
                    $this->layout = 'advance';
                }
                $this->loadModel('Patient');
                $this->loadModel('Person');
                $this->Patient->setDatasource($userDatabase);
                $this->Person->setDatasource($userDatabase);
            
                $persons = $this->Person->find('all', array(
                    'conditions' => array(
                        'Person.admission_type' => 'OPD',
                        'Person.create_time >=' => '2024-11-14 00:00:00',
                    ),
                    'joins' => array(
                        array(
                            'table' => 'patients',  // Assuming the table name is 'patients'
                            'alias' => 'Patient',   // Alias for the Patient model
                            'type' => 'INNER',      // INNER JOIN, you can change it to LEFT if necessary
                            'conditions' => 'Patient.patient_id = Person.patient_uid'  // Join condition
                        )
                    ),
                    'fields' => array('Person.*', 'Patient.*'),  // Select fields from both tables
                    'order' => array('Person.create_time DESC')  // Order by create_time in descending order
                ));
            
                $this->set(compact('persons'));
            }

         public function referal_doctor($type=null) {
                // $this->layout = 'advance';
                	$this->layout = 'advance';
                $this->uses=array('CorporateSublocation','MarketingTeam','Initial','Consultant','City');
        		//refral doctors and ambulance @7387737062
        		$bothSponsor=array();
        		$bothSponsor=$this->CorporateSublocation->getCorporateSublocationList();
        		$bothSponsor=$bothSponsor+array('withoutsublocation'=>'Without Sponsors');
        		$this->set('sponsor',$bothSponsor);
        		$this->set('marketing_teams', $this->MarketingTeam->getMarketingTeamList($this->Session->read('locationid')));
        		$this->set('initials', $this->Initial->find('list', array('fields'=> array('id', 'name'))));
        		$data = $this->Consultant->find('all', array(
                            'fields' => array('Consultant.*', 'City.name'),
                            'conditions' => $conditions,
                            'order' => array('Consultant.first_name' => 'asc')
                            // 'recursive' => 0
                        ));
        	   //refral doctors and ambulance @7387737062	
        		$this->set('data', $data);
        		if($type=='print'){
        			$this->autoRender = false;
        			$this->layout = 'print_without_header' ;
        			$this->render('referral_doctor_print');
        		}
        		
        		if($type=='excel'){
        			$this->autoRender = false;					
        			$this->layout = false ;
        			$this->render('referral_doctor_excel');
        		}

    }
        public function saveReferralData() {
            if ($this->request->is('post')) {
                $data = $this->request->data;
                // Loop through the disposition data and save it
                foreach ($data['disposition'] as $consultantId => $disposition) {
                    $consultantData = [
                        'consultant_id' => $consultantId,
                        'disposition' => $disposition,
                        'sub_disposition' => isset($data['sub_disposition'][$consultantId]) ? $data['sub_disposition'][$consultantId] : null,
                        'remarks' => isset($data['remarks'][$consultantId]) ? $data['remarks'][$consultantId] : null,
                         'telecaller_name' => $data['telecaller_name'][$consultantId],
                    ];
        
                    // Save each consultant's referral data
                    $this->loadModel('ReferralConsultant');
                    $this->ReferralConsultant->create();
                    if (!$this->ReferralConsultant->save($consultantData)) {
                        $this->Session->setFlash(__('Unable to save the data.'));
                        // Redirect back to the same page if there is an error
                        return $this->redirect($this->referer());
                    }
                }
                $this->Session->setFlash(__('Data saved successfully.'));
                // Redirect back to the same page after successful save
                return $this->redirect($this->referer());
            }
        }
         public function send_whatsapp_msg() {
                if ($this->request->is('post')) {
                   
                    $phoneNumbers = json_decode($this->request->data['phoneNumbers'], true); 
                    if (empty($phoneNumbers)) {
                        echo json_encode(['success' => false, 'message' => 'No phone numbers provided.']);
                        exit;
                    }
                    
                    $apiUrl = "https://public.doubletick.io/whatsapp/message/template";
                    $apiKey = "key_8sc9MP6JpQ"; 
                    foreach ($phoneNumbers as $phone) {
                        $phone = preg_replace('/\D/', '', $phone); 
                        if (strlen($phone) < 10 || strlen($phone) > 15) {
                            continue;
                        }
                        $phone ="7387737062";
                        $payload = [
                            'messages' => [
                                [
                                     'to' => '+91' . $phone,
                                    'content' => [
                                        'templateName' => 'a_m_generalize_patient_qr_scanned',
                                        'language' => 'en',
                                        'templateData' => [
                                            'body' => [
                                                'placeholders' => ["pratik", "7030291823"] 
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ];
                        $ch = curl_init($apiUrl);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
                        curl_setopt($ch, CURLOPT_HTTPHEADER, [
                            'accept' => 'application/json',
                            'content-type' => 'application/json',
                            'Authorization' => $apiKey
                        ]);
                        $response = curl_exec($ch);
                        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                        curl_close($ch);
                        if ($statusCode != 200) {
                            continue;
                        }
                    }
                    echo json_encode(['success' => true, 'message' => 'Messages sent successfully.']);
                    exit;
                } else {
                    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
                    exit;
                }
        
        }
         public function referal_doctor_testing($type=null) {
                // $this->layout = 'advance';
                	$this->layout = 'advance';
                $this->uses=array('CorporateSublocation','MarketingTeam','Initial','Consultant','City');
        		//refral doctors and ambulance @7387737062
        		$bothSponsor=array();
        		$bothSponsor=$this->CorporateSublocation->getCorporateSublocationList();
        		$bothSponsor=$bothSponsor+array('withoutsublocation'=>'Without Sponsors');
        		$this->set('sponsor',$bothSponsor);
        		$this->set('marketing_teams', $this->MarketingTeam->getMarketingTeamList($this->Session->read('locationid')));
        		$this->set('initials', $this->Initial->find('list', array('fields'=> array('id', 'name'))));
        		$data = $this->Consultant->find('all', array(
                            'fields' => array('Consultant.*', 'City.name'),
                            'conditions' => $conditions,
                            'order' => array('Consultant.first_name' => 'asc')
                            // 'recursive' => 0
                        ));
        	   //refral doctors and ambulance @7387737062	
        		$this->set('data', $data);
        		if($type=='print'){
        			$this->autoRender = false;
        			$this->layout = 'print_without_header' ;
        			$this->render('referral_doctor_print');
        		}
        		
        		if($type=='excel'){
        			$this->autoRender = false;					
        			$this->layout = false ;
        			$this->render('referral_doctor_excel');
        		}

    }
    
    
    // function by dinesh tawade
    	public function marketing(){
		$this->layout = false;
		App::import('Vendor', 'DrmhopeDB', array('file' => 'DrmhopeDB.php'));

        if ($this->Session->read('db_name')) {
            $db_connection = new DrmhopeDB($this->Session->read('db_name'));
        } else {
            $db_connection = new DrmhopeDB('db_ayushman');
			$db_connection = new DrmhopeDB('db_hopehospital');
			$db_connection = new DrmhopeDB('db_hope');
        }
		// debug($db_connection);
        $db_connection->makeConnection($this->MarketingTeam);
		$db_connection->makeConnection($this->CompDetails);
		$this->uses=array('CorporateSublocation','MarketingTeam','Initial','Consultant','City','CompDetails','MarketingTeam');
		
		if ($this->request->is('post')) {
			$data = $this->request->data;
	// debug($this->request->data);exit;
			$companyData = array(
				'CompDetails' => array(
					'company_name' => $data['company_name'],
					'hr_name' => $data['hr_name'],
					'number' => $data['number'],
					'email_id' => $data['email_id'],
					'employee_size' => $data['employee_size'],
					'remark' => $data['remark'],
					'tied_hospital' => $data['tied_hospital'],
					'disposition' => $data['disposition'],
					'sub_disposition' => $data['sub_disposition'],
					'final_status' => $data['final_status'],
					'date_of_event' => $data['date_of_event'],
					'marketing_team' => $data['marketing_team'] 
				)
			);
	// debug($companyData);
	if ($this->CompDetails->save($companyData)){
				$this->Session->setFlash('Data saved successfully!', 'default', array('class' => 'success'));
				$this->redirect(array('controller' => 'Appointments', 'action' => 'marketing'));
			} else {
				$this->Session->setFlash('Failed to save data!', 'default', array('class' => 'error'));
			}
		}

		$this->loadModel('MarketingTeam');
		$marketTeam = $this->MarketingTeam->find('all');
		$this->set('marketTeam',$marketTeam);
		// debug($marketTeam);exit;

		$this->loadModel('CompDetails');
		$comp = $this->CompDetails->find('all');
		
		$this->set('comp',$comp);
		// debug($comp);exit;
	
}

}
