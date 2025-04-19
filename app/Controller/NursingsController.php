<?php
/**
 * NursingsController file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Hope hospital
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensoursce.org/licenses/mit-license.php)
 * @author        Pankaj wanjari
 */

define('IVSTRLEN',20);
class NursingsController extends AppController {

	public $name = 'Nursing';
	public $uses = null;
	public $helpers = array('Html','Form', 'Js','DateFormat','General','Number');
	public $components = array('RequestHandler','Email','DateFormat','General','ImageUpload');

	//Please do not add beforeFilter in and controller - pankaj w
	/* public function beforefilter(){
		$this->Auth->allow('prescription_record');
	} */

	public function search(){
		$this->uses = array('Patient','User','TimeSlot');
		$this->set('data','');
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array(
						'Patient.create_time' => 'DESC'
				)
		);
			
		#pr($this->params);
		$role = $this->Session->read('role');
		$search_key['Patient.is_deleted'] = 0;
		if($_SESSION['Auth']['User']['role_id']=='2'){
			#$search_key['Location.facility_id']=$this->Session->read('facilityid');
			$this->Patient->bindModel(array(
			'belongsTo' => array(

			'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id' )),
			'Initial' =>array('foreignKey' => false,'conditions'=>array('Initial.id=User.initial_id' )),
			'Location' =>array('foreignKey' => 'location_id'),
			'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
			'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
			'Department' =>array('foreignKey' => false,'conditions'=>array('Department.id =Patient.department_id' )),
			)),false);
		}
		else{
			$search_key['Patient.location_id']=$this->Session->read('locationid');
			$this->Patient->bindModel(array(
					'belongsTo' => array(
							'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id' )),
							'Initial' =>array('foreignKey' => false,'conditions'=>array('Initial.id=User.initial_id' )),
							'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
							'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
							'Department' =>array('foreignKey' => false,'conditions'=>array('Department.id =Patient.department_id' )),
					)),false);
		}


		if(!empty($this->params->query)){
			$search_ele = $this->params->query  ;//make it get


		if(!empty($search_ele['lookup_name'])){
		$search_ele['lookup_name'] = explode(" ",$search_ele['lookup_name']);
						if(count($search_ele['lookup_name']) > 1){
							$search_key['SOUNDEX(Person.first_name) like'] = "%".soundex(trim($search_ele['lookup_name'][0]))."%";
							$search_key['SOUNDEX(Person.last_name) like'] = "%".soundex(trim($search_ele['lookup_name'][1]))."%";
						}else if(count($search_ele['lookup_name)']) == 0){
							$search_key['OR'] = array( 
							 'SOUNDEX(Person.first_name)  like'  => "%".soundex(trim($search_ele['lookup_name'][0]))."%",
							 'SOUNDEX(Person.last_name)   like'  => "%".soundex(trim($search_ele['lookup_name'][0]))."%");
					}
					}if(!empty($search_ele['patient_id'])){
				$search_key['Patient.patient_id like '] = "%".trim($search_ele['patient_id']) ;
			}if(!empty($search_ele['admission_id'])){
				$search_key['Patient.admission_id like '] = "%".trim($search_ele['admission_id']) ;
			}if(!empty($search_ele['dob'])){
						$search_key['Person.dob like '] = "%".trim(substr($this->DateFormat->formatDate2STD($search_ele['dob'],Configure::read('date_format')),0,10));
				}if(!empty($search_ele['ssn_us'])){
							$search_key['Person.ssn_us like '] = "%".trim($search_ele['ssn_us'])."%" ; ;
				}

			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'order' => array('Patient.create_time' => 'DESC'),
					'fields'=> array('CONCAT(PatientInitial.name," ",Patient.lookup_name) as lookup_name,Patient.form_received_on,
							Patient.id,Patient.sex,Patient.patient_id,Department.name,Patient.admission_id,Person.ssn_us,Person.dob,Patient.mobile_phone,Patient.landline_phone,CONCAT(Initial.name," ",User.first_name," ",User.last_name) as name, Patient.create_time'),
					'conditions'=>array($search_key,'Patient.is_discharge'=>0,'Patient.admission_type'=>'IPD')
			);
			if($role == 'Nurse'){
				//		$this->set('data',$this->paginate('Patient',array('conditions'=>)));
			}
			$this->set('data',$this->paginate('Patient'));

		}else{
			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'order' => array('Patient.create_time' => 'DESC'),
					'fields'=> array('CONCAT(PatientInitial.name," ",Patient.lookup_name) as lookup_name,Patient.form_received_on,
							Patient.id,Patient.sex,Patient.patient_id,Department.name,Patient.admission_id,Person.ssn_us,Person.dob,Patient.mobile_phone,Patient.landline_phone,CONCAT(Initial.name," ",User.first_name," ",User.last_name) as name, Patient.create_time'),
					'conditions'=>array($search_key,'Patient.is_discharge'=>0,'Patient.admission_type'=>'IPD')
			);
			//pr($this->paginate('Patient'));exit;
			$this->set('data',$this->paginate('Patient'));

		}
			
	}

	public function patient_information($id=null) {
		$role = $this->Session->read('role');
		if(!empty($id)){
			$this->uses = array('Person','Consultant','User','Patient','Ward','Room','Bed','Corporate','InsuranceCompany','Language');

			$languages = $this->Language->find('list',array('fields'=>array('code','language')));
			$this->set('languages',$languages);

			$this->Patient->bindModel(array(
					'belongsTo' => array(
							'Initial' =>array( 'foreignKey'=>'initial_id'),
							'Consultant' =>array('foreignKey'=>'consultant_treatment')
					)));
			// patient_ifo function is defined in app controller, parameter needed: Patient Id
			$this->patient_info($id);

			$this->loadModel('Appointment');
			$this->Appointment->bindModel(array(
					'belongsTo' => array(
							'User' =>array('foreignKey'=>'doctor_id'),
							'Department' =>array('foreignKey'=>'department_id'),
					)));
			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'order' => array('Appointment.create_time' => 'desc'),
					'fields'=> array('Appointment.*,concat(User.first_name," ",User.last_name) as full_name,Department.name'),
					'conditions'=>array('Appointment.patient_id'=>$id,'Appointment.is_deleted'=>'0')
			);

			$this->set('data',$this->paginate('Appointment'));
		}else{
			$this->redirect(array("controller" => "patients", "action" => "index"));
		}
		$this->set(compact('role'));
	}

	function assessment_first_admission($id=''){
		#pr($this->request->data);exit;
		$this->uses = array('AssessmentFirstAdmission','Patient');
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Initial' =>array( 'foreignKey'=>'initial_id'),
						'Consultant' =>array('foreignKey'=>'consultant_treatment')
				)));
		if(isset($this->request->data['Nursing']['patient_id'])){
			$patient_details  = $this->Patient->getPatientDetailsByID($this->request->data['Nursing']['patient_id']);
		}
		else if($id!=''){
			$patient_details  = $this->Patient->getPatientDetailsByID($id);
		}


		$this->set('patient_details',$patient_details);
		//$UIDpatient_details  = $this->Person->getUIDPatientDetailsByPatientID($id);
		#pr($this->request->data);exit;
		if($this->request->data){
			$this->request->data['Nursing']['date']= $this->DateFormat->formatDate2STD($this->request->data['Nursing']['date'],Configure::read('date_format'));
			$this->request->data['Nursing']['location_id'] = $this->Session->read('locationid');
			$this->AssessmentFirstAdmission->save($this->request->data['Nursing']);
		}
		if($id!=''){
			$nursingData = $this->AssessmentFirstAdmission->find('first',array('conditions'=>array('patient_id'=>$id,'location_id'=>$this->Session->read('locationid'))));
			$this->request->data['Nursing'] = $nursingData['AssessmentFirstAdmission'];
			#pr($nursingData);exit;
		}
	}

	function assessment_second_admission($id=''){
		$this->uses = array('AssessmentSecondAdmission','Patient');
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Initial' =>array( 'foreignKey'=>'initial_id'),
						'Consultant' =>array('foreignKey'=>'consultant_treatment')
				)));
		if(isset($this->request->data['Nursing']['patient_id'])){
			$patient_details  = $this->Patient->getPatientDetailsByID($this->request->data['Nursing']['patient_id']);
		}
		else if($id!=''){
			$patient_details  = $this->Patient->getPatientDetailsByID($id);
		}

		#pr($patient_details);exit;
		$this->set('patient_details',$patient_details);

		if($this->request->data){
			$this->request->data['Nursing']['location_id'] = $this->Session->read('locationid');
			$this->AssessmentSecondAdmission->save($this->request->data['Nursing']);
		}
		if($id!=''){
			$nursingData = $this->AssessmentSecondAdmission->find('first',array('conditions'=>array('patient_id'=>$id,'location_id'=>$this->Session->read('locationid'))));
			$this->request->data['Nursing'] = $nursingData['AssessmentSecondAdmission'];
			#pr($nursingData);exit;
		}
	}

	function assessment_third_admission($id=''){
		if($this->request->data){
			echo count($this->request->data['Nursing']);
			pr($this->request->data);exit;
		}

	}


	/**
	@Name		 : oservation_chart
	@created for : Observation chart by nursing
	@created by  : ANAND
	@created on  : 2/23/2012
	@modified on :
	**/

	public function observation_chart_list($id = null){
		$this->uses = array('ObservationChart');
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array(
						'ObservationChart.date' => 'desc'
				),
				'group' => "date",
				'conditions' => array('ObservationChart.patient_id' => $id)
		);
		$this->set('title_for_layout', __('Observation Chart List', true));
		$this->ObservationChart->recursive = 0;
		$data = $this->paginate('ObservationChart');
		$this->patient_info($id);
		$this->set('data', $data);

	}
	public function observation_chart($id = null){
		// Model to be used here

		$this->uses = array('ObservationChart','Patient','Person','User','Ward','Room','Bed','Corporate','InsuranceCompany');

		$noError = true; // Set Flag
		$empty = false;
		$delete = false;
		// When previous observation date is selected
		if(!$this->params['isAjax']) {
			$this->patient_info($id);
		}else{
			$this->set("isAjax","1");
		}
		if(isset($this->params->query['patient_id'])) {
			// Collect the data

			$patient_id = $this->params->query['patient_id'];
			// Change date to standered format
			$queryDate = $this->DateFormat->formatDate2STDForReport($this->params->query['date'],Configure::read('date_format'));
			// 	Get data from table accordingly
			$lastRecord = $this->ObservationChart->find('all',array('conditions'=>array('ObservationChart.location_id'=>$this->Session->read('locationid'),'ObservationChart.patient_id'=>$patient_id,'ObservationChart.date'=>$queryDate)));
			// get the Lasr 24 hrs progress remark
			$getDates = $this->ObservationChart->find('all',array('conditions'=>array('ObservationChart.location_id'=>$this->Session->read('locationid'),'ObservationChart.patient_id'=>$patient_id)));

			// Create an arrray of entered dates in table to be displayed in datepicker
			$this->arrayDateHighlight($getDates,'ObservationChart');
			// fetch dates from database.
			$count = $this->ObservationChart->find('count',array('conditions'=>array('ObservationChart.patient_id'=>$patient_id,'ObservationChart.location_id'=>$this->Session->read('locationid'))));
			//$arrayDate[] = '';

			// Time slots for dropdown
			$timeSlots = array('12AM'=>'12 AM','1AM'=>'1AM','2AM'=>'2 AM','3AM'=>'3 AM','4AM'=>'4 AM','5AM'=>'5 AM','6AM'=>'6 AM','7AM'=>'7 AM','8AM'=>'8 AM','9AM'=>'9 AM','10AM'=>'10 AM','11AM'=>'11 AM','12PM'=>'12 Noon','1PM'=>'1 PM','2PM'=>'2 PM','3PM'=>'3 PM','4PM'=>'4 PM','5PM'=>'5 PM','6PM'=>'6 PM','7PM'=>'7 PM','8PM'=>'8 PM','9PM'=>'9 PM','10PM'=>'10 PM','11PM'=>'11 PM');

			$this->set(compact('timeSlots'));

			// Set data to view
			$this->set('observationDate',$this->params->query['date']);

			$this->set(compact('lastRecord')); // Total Data
			$this->set(compact('patient_id')); // patient data
			
			$this->set('date',$queryDate); // last entry date
			// render view
			$this->render('ajaxobservation_chart');

		}
		if(!empty($this->request->data)){

			// Unset repetating data on observation chart if comin gthrough ajax

		 // Count How manyy record inserted
			$count = $this->ObservationChart->find('count',array('conditions'=>array('ObservationChart.patient_id'=>$id,'ObservationChart.location_id'=>$this->Session->read('locationid'))));
			for($i=1;$i<=$count;$i++){
				if(isset($this->request->data['ObservationChartOld_'.$i])){
					unset($this->request->data['ObservationChartOld_'.$i]);
				}
			}
			// Collect Data
				
			$getData = $this->request->data;
			// collect patient info
			$patientData = $this->Patient->find('first',array('conditions'=>array('Patient.id'=>$id)));
			// echo "<pre>";print_r($this->request->data);exit;
			// Prepare data to save in DB
			foreach($this->request->data['ObservationChart']['deleteId'] as $key=>$data){
				$this->ObservationChart->delete($data);
				$delete =  true;
			}

			foreach($getData as $key=>$data){

				$split = explode('_',$key); // Explode the key, will get time abd model

				// Unset empty fields
				if(isset($data['pulse']) AND $data['pulse'] =='')unset($data['pulse']);
				if(isset($data['rr']) AND $data['rr'] =='')  unset($data['rr']);
				if(isset($data['bp']) AND $data['bp'] =='') {
					unset($data['bp']);
				}else{$data['bp'] = implode("/",$data['bp']);
				}
				if(isset($data['temp']) AND $data['temp'] =='')  unset($data['temp']);
				if(isset($data['osat']) AND $data['osat'] =='')  unset($data['osat']);
				if(isset($data['rbs']) AND $data['rbs'] =='')  unset($data['rbs']);
				if(isset($data['ivf']) AND $data['ivf'] =='')  unset($data['ivf']);
				if(isset($data['other']) AND $data['other'] =='')  unset($data['other']);
				if(isset($data['total_intake']) AND $data['total_intake'] =='') unset($data['total_intake']);
				if(isset($data['bowel']) AND $data['bowel'] =='')  unset($data['bowel']);
				if(isset($data['rtf']) AND $data['rtf'] =='')  unset($data['rtf']);
				if(isset($data['hourly']) AND $data['hourly'] =='')  $data['hourly'] = 0;
				if(isset($data['total_output']) AND $data['total_output'] =='') $data['total_output'] = 0;

				if(isset($data['time']) && $data['time'] == ''){
					unset($data);
				}
				//pr($getData);exit;
				if(isset($split[1]) AND (!empty($data))){
					// Arrange data for model
					$this->request->data[$split[0]] = $data;
					//$this->request->data[$split[0]]['time'] = $split[1];
					$this->request->data[$split[0]]['patient_id'] = $id;
					$this->request->data[$split[0]]['patient_uid'] = $patientData['Patient']['patient_id'];
					$this->request->data[$split[0]]['patient_name'] = $patientData['Patient']['lookup_name'];
					$this->request->data[$split[0]]['progress_remark'] = $getData['ObservationChart']['progress_remark'];
					$this->request->data[$split[0]]['created_by'] = $this->Session->read('userid');
					$this->request->data[$split[0]]['location_id'] = $this->Session->read('locationid');
					$this->request->data[$split[0]]["date"] = $this->DateFormat->formatDate2STD($getData['ObservationChart']['date'],Configure::read('date_format'));
					$this->request->data[$split[0]]["create_time"] = date("Y-m-d H:i:s");


					// print_r($this->request->data ); exit;

					//Save data here

				 if($this->request->data[$split[0]] != ''){
				 	if($this->ObservationChart->saveAll($this->request->data[$split[0]])){
				 		$delete = false;
				 		$noError = true; // Saved successfully
				 	}
				 } else {
				 	$noError = false;
				 }
				}
			} //exit;
			if($noError == true){
				if(!$delete)
					$this->Session->setFlash(__('The observation has been saved successfully!'),'default',array('class'=>'message'));
				else
					$this->Session->setFlash(__('The observation has been deleted!'),'default',array('class'=>'message'));
					
				$this->redirect(array('controller'=>'nursings','action'=>'observation_chart_list',$id));

			} else {
				$this->Session->setFlash(__('The observation could not be saved!'),'default',array('class'=>'error'));
				$this->redirect(array('controller'=>'nursings','action'=>'observation_chart',$id));
			}
		}

			
		if(empty($this->request->data)){
			//Get the record from table
			$getDates = $this->ObservationChart->find('all',array('conditions'=>array('ObservationChart.location_id'=>$this->Session->read('locationid'),'ObservationChart.patient_id'=>$id)));
			// Time slots for dropdown
		 $timeSlots = array('12AM'=>'12 AM','1AM'=>'1AM','2AM'=>'2 AM','3AM'=>'3 AM','4AM'=>'4 AM','5AM'=>'5 AM','6AM'=>'6 AM','7AM'=>'7 AM','8AM'=>'8 AM','9AM'=>'9 AM','10AM'=>'10 AM','11AM'=>'11 AM','12PM'=>'12 Noon','1PM'=>'1 PM','2PM'=>'2 PM','3PM'=>'3 PM','4PM'=>'4 PM','5PM'=>'5 PM','6PM'=>'6 PM','7PM'=>'7 PM','8PM'=>'8 PM','9PM'=>'9 PM','10PM'=>'10 PM','11PM'=>'11 PM');
		 // Create an arrray of entered dates in table to be displayed in datepicker
			$this->arrayDateHighlight($getDates,'ObservationChart');

			$this->set(compact('timeSlots'));

			//$this->set(compact('lastRecord'));

			// patient_ifo function is defined in app controller, parameter needed: Patient Id


		}
	}
	/**
	@Name		 : print_observation
	@created for : To print Observation chart by nursing
	@created by  : ANAND
	@created on  : 2/24/2012
	@modified on :
	**/

	public function print_observation($id = null){

		$this->uses = array('ObservationChart','Patient','Person');

		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Initial' =>array( 'foreignKey'=>'initial_id'),

				)
		));
		$this->layout  = 'print_with_header';
		$this->set('title_for_layout', __('OBSERVATION CHART', true));
		if(!isset($this->params->query['date']) || !isset($id)){
			$this->Session->setFlash(__('Something went wrong!'),'default',array('class'=>'error'));
			$this->redirect(array('controller'=>'nursings','action'=>'observation_chart_list',$id));
		}
		$date = $this->params->query['date'];
		$patient_id = $id;
		// Time slots for dropdown
		$timeSlots = array('12AM'=>'12 AM','1AM'=>'1AM','2AM'=>'2 AM','3AM'=>'3 AM','4AM'=>'4 AM','5AM'=>'5 AM','6AM'=>'6 AM','7AM'=>'7 AM','8AM'=>'8 AM','9AM'=>'9 AM','10AM'=>'10 AM','11AM'=>'11 AM','12PM'=>'12 Noon','1PM'=>'1 PM','2PM'=>'2 PM','3PM'=>'3 PM','4PM'=>'4 PM','5PM'=>'5 PM','6PM'=>'6 PM','7PM'=>'7 PM','8PM'=>'8 PM','9PM'=>'9 PM','10PM'=>'10 PM','11PM'=>'11 PM');
		if(!empty($id)){
			$record = $this->ObservationChart->find('all',array('conditions'=>array('ObservationChart.location_id'=>$this->Session->read('locationid'),'ObservationChart.patient_id'=>$id,'ObservationChart.date'=>$date)));
			//pr($record);exit;
			$patient_name = $this->Patient->field('lookup_name',array('Patient.id'=>$id));
			$patient_uid = $this->Patient->field('patient_id',array('Patient.id'=>$id)); // UID of the patient
			$UIDpatient_details  = $this->Person->getUIDPatientDetailsByPatientID($id);  //	Details of the patient
			$formatted_address   = $this->Patient->setAddressFormat($UIDpatient_details['Person']); // Formatted address for patient

			$remark = $this->ObservationChart->find('first',array('conditions'=>array('ObservationChart.location_id'=>$this->Session->read('locationid'),'ObservationChart.patient_id'=>$id,'ObservationChart.date'=>$date)));
			$getRemark = $remark['ObservationChart']['progress_remark'];

			// Set data to view
			$this->set(compact('getRemark'));
			$this->set(compact('formatted_address'));
			$this->set(compact('patient_uid'));
			$this->set('patient',$this->Patient->find('first',array('conditions'=>array('Patient.id'=>$id,'Patient.location_id'=>$this->Session->read('locationid')))));
			$this->set(compact('patient_name'));
			$this->set(compact('record'));
			$this->set(compact('timeSlots'));
			$this->set('title', __('OBSERVATION CHART', true)); // THis is the title for the printout
			$this->patient_info($id);
		}
	}


	/**
	@Name		 : print_observation
	@created for : To print Observation chart by nursing
	@created by  : ANAND
	@created on  : 2/24/2012
	@modified on : 3/14/2012
	**/

	public function quality_monitoring_format($id = null){
		$this->uses = array('QualityMonitoringFormat','Patient','Person','Ward','Room','Bed','Corporate','User','InsuranceCompany');

		if(!empty($this->request->data)){
			// Set data format
		 if(!empty($this->request->data['QualityMonitoringFormat']['date_insertion'])) {
		 	$splitInsertion = explode(' ',$this->request->data['QualityMonitoringFormat']['date_insertion']);
		 	$date_insertion = $this->DateFormat->formatDate2STD($this->request->data['QualityMonitoringFormat']['date_insertion'],Configure::read('date_format')) ;
		 }

		 if(!empty($this->request->data['QualityMonitoringFormat']['date_removel'])) {
		 	$splitRemovel = explode(' ',$this->request->data['QualityMonitoringFormat']['date_removel']);
		 	$date_removel = $this->DateFormat->formatDate2STD($this->request->data['QualityMonitoringFormat']['date_removel'],Configure::read('date_format'));
		 }

		 if(!empty($this->request->data['QualityMonitoringFormat']['skin_observed_date'])) {
		 	$skin_observed_date =  $this->request->data['QualityMonitoringFormat']['skin_observed_date'];
		 	$this->request->data['QualityMonitoringFormat']['skin_observed_date'] = $this->DateFormat->formatDate2STD($skin_observed_date,Configure::read('date_format'));
		 }

		 if(!empty($this->request->data['QualityMonitoringFormat']['thrombophlebits_observed_date'])) {
		 	$thrombophlebits_observed_date = $this->request->data['QualityMonitoringFormat']['thrombophlebits_observed_date'];
		 	$this->request->data['QualityMonitoringFormat']['thrombophlebits_observed_date'] = $this->DateFormat->formatDate2STD($thrombophlebits_observed_date,Configure::read('date_format'));
		 }

		 if(!empty($this->request->data['QualityMonitoringFormat']['blockage_observed_date'])) {
		 	$blockage_observed_date = $this->request->data['QualityMonitoringFormat']['blockage_observed_date'];
		 	$this->request->data['QualityMonitoringFormat']['blockage_observed_date'] = $this->DateFormat->formatDate2STD($blockage_observed_date,Configure::read('date_format'));
		 }

		 if(!empty($this->request->data['QualityMonitoringFormat']['accidential_line_observed_date'])) {
		 	$accidential_line_observed_date =  $this->request->data['QualityMonitoringFormat']['accidential_line_observed_date'];
		 	$this->request->data['QualityMonitoringFormat']['accidential_line_observed_date'] = $this->DateFormat->formatDate2STD($accidential_line_observed_date,Configure::read('date_format'));
		 }

		 if(!empty($this->request->data['QualityMonitoringFormat']['patient_fall_observed_date'])) {
		 	$patient_fall_observed_date = $this->request->data['QualityMonitoringFormat']['patient_fall_observed_date'];
		 	$this->request->data['QualityMonitoringFormat']['patient_fall_observed_date'] = $this->DateFormat->formatDate2STD($patient_fall_observed_date,Configure::read('date_format'));
		 }

		 // Get the patient detail
			$patientData = $this->Patient->find('first',array('conditions'=>array('Patient.id'=>$id)));
			// Initialise variable
			$saveData = '';
			$noError = false;
			// loop to save data
			$this->request->data['QualityMonitoringFormat']['date_insertion'] = $date_insertion;
			$this->request->data['QualityMonitoringFormat']['date_removel'] = $date_removel;
			$this->request->data['QualityMonitoringFormat']['created_by'] = $this->Session->read('userid');
			$this->request->data['QualityMonitoringFormat']['location_id'] = $this->Session->read('locationid');
			$this->request->data['QualityMonitoringFormat']['create_time'] = date("Y-m-d H:i:s");
			$this->request->data['QualityMonitoringFormat']['date'] =date("Y-m-d");
			$this->request->data['QualityMonitoringFormat']['patient_id'] = $id;
			$this->request->data['QualityMonitoringFormat']['patient_uid'] = $patientData['Patient']['patient_id'];
			$this->request->data['QualityMonitoringFormat']['patient_name'] = $patientData['Patient']['lookup_name'];
			//pr($this->request->data);exit;

			if($this->QualityMonitoringFormat->saveAll($this->request->data)){
				$this->Session->setFlash(__('The data has been saved successfully!'),'default',array('class'=>'message'));
				$this->redirect(array('controller'=>'nursings','action'=>'quality_monitoring_format',$id));
			} else {
				$this->Session->setFlash(__('The data could not be saved!'),'default',array('class'=>'error'));
				$this->redirect(array('controller'=>'nursings','action'=>'quality_monitoring_format',$id));
			}
		}

		// When form is not submitted
		if(empty($this->request->data)){
			$maxId = $this->QualityMonitoringFormat->find('first',array('conditions'=>array('QualityMonitoringFormat.patient_id'=>$id,'QualityMonitoringFormat.location_id'=>$this->Session->read('locationid')),'fields' => array('MAX(QualityMonitoringFormat.id) as max_id')));

			$data = $this->QualityMonitoringFormat->find('first',array('conditions'=>array('QualityMonitoringFormat.id'=>$maxId[0]['max_id'],'QualityMonitoringFormat.patient_id'=>$id,'QualityMonitoringFormat.location_id'=>$this->Session->read('locationid'))));

			if(!empty($data)){
				$count = count($data);
			} else {
				$count = 0;
			}

			//$count = $this->QualityMonitoringFormat->find('count',array('conditions'=>array('QualityMonitoringFormat.location_id'=>$this->Session->read('locationid'),'QualityMonitoringFormat.patient_id'=>$id)));

			$this->request->data = $data;
			$this->set('patient',$this->Patient->find('first',array('conditions'=>array('Patient.id'=>$id,'Patient.location_id'=>$this->Session->read('locationid')))));
			// patient_ifo function is defined in app controller, parameter needed: Patient Id
			$this->patient_info($id);
			$this->set(compact('count'));

		}

	}

	/**
	@Name		 : print_quality_monitoring_format
	@created for : To print print_quality_monitoring_format by nursing
	@created by  : ANAND
	@created on  : 2/27/2012
	@modified on :
	**/

	public function print_quality_monitoring_format($id = null){
		$this->uses = array('QualityMonitoringFormat','Patient','Person','InsuranceCompany','Corporate');
		$this->layout  = 'print_with_header' ;
		$this->set('title_for_layout', __('NURSING SENSITIVE QUALITY INDICATORS MONITORING FORMAT', true));
		if(!empty($id)){
			// get current data
			$maxId = $this->QualityMonitoringFormat->find('first',array('conditions'=>array('QualityMonitoringFormat.patient_id'=>$id,'QualityMonitoringFormat.location_id'=>$this->Session->read('locationid')),'fields' => array('MAX(QualityMonitoringFormat.id) as max_id')));

			//$record = $this->QualityMonitoringFormat->find('all',array('conditions'=>array('QualityMonitoringFormat.id'=>$maxId[0]['max_id'],'QualityMonitoringFormat.patient_id'=>$id,'QualityMonitoringFormat.location_id'=>$this->Session->read('locationid'))));

			$data = $this->QualityMonitoringFormat->find('first',array('conditions'=>array('QualityMonitoringFormat.id'=>$maxId[0]['max_id'],'QualityMonitoringFormat.patient_id'=>$id,'QualityMonitoringFormat.location_id'=>$this->Session->read('locationid'))));
			$patientDetails =  $this->Patient->find('first',array('conditions'=>array('Patient.id'=>$id,'Patient.location_id'=>$this->Session->read('locationid'))));
			$patient_name = $patientDetails['Patient']['lookup_name'];
			$patient_uid = $patientDetails['Patient']['patient_id'];

			$UIDpatient_details  = $this->Person->getUIDPatientDetailsByPatientID($id);
			$formatted_address   = $this->Patient->setAddressFormat($UIDpatient_details['Person']); // Formatted address for patient
			$this->set(compact('formatted_address'));
			$this->set(compact('patient_uid'));
			//$this->set('patient',$this->Patient->find('first',array('conditions'=>array('Patient.id'=>$id))));
			$this->set(compact('patient_name'));
			$this->set(compact('data'));
			$this->patient_info($id);
			$this->set('title', __('NURSING SENSITIVE QUALITY INDICATORS MONITORING FORMAT', true)); // THis is the title for the printout
		}
	}

	/**
	@Name		 : dietaryAssessment
	@created for : detry assessment form for nursing
	@created by  : ANAND
	@created on  : 3/21/2012
	@modified on :
	**/
	public function dietaryAssessment($id=null,$source=''){
		$this->uses = array('DietaryAssessment','DietryNote','Patient','Person','User','Ward','Room','Bed','Corporate','InsuranceCompany');
		if($this->params['isAjax']){
			$patient_id = $this->params->query['patient_id'];
			// Change date to standered format
			$queryDate = $this->DateFormat->formatDate2STDForReport($this->params->query['date'],Configure::read('date_format'));
			// Collect all the data
			$collectData = $this->DietaryAssessment->find('all',array('conditions'=>array('DietaryAssessment.patient_id'=>$patient_id,
					'DietaryAssessment.location_id'=>$this->Session->read('locationid'))));
			// collect dates for which the data has been inserted. arrayDate is the function defined in nursings controller
			$this->arrayDate($collectData,'DietaryAssessment');
			//Get the Dietry Assessment details
			$getDietryAssessment = $this->DietaryAssessment->find('first',array('conditions'=>array('DietaryAssessment.patient_id'=>$patient_id,
		   "DietaryAssessment.date like '%$queryDate%'",'DietaryAssessment.location_id'=>$this->Session->read('locationid'))));
			$this->set(array('date'=>$this->params->query['date'],'getDietryAssessment'=>$getDietryAssessment,'patient_id'=>$patient_id));
			//pr($getDietryAssessment);exit;
			// render view
			$this->render('ajaxdietary_assessment');
		}
		if(!empty($this->request->data)){
			// unset unwanted data
			unset($this->request->data['previousRecord']);
			unset($this->request->data['datePrevious']);
			//pr($this->request->data);exit;
			$getData = $this->request->data;
			$patientData = $this->Patient->find('first',array('conditions'=>array('Patient.id'=>$id))); // COllect patient details
			// Collect Patient data

			$this->request->data['DietaryAssessment']['patient_id'] =  $patientData['Patient']['id'];
			$this->request->data['DietaryAssessment']['patient_uid'] =  $patientData['Patient']['patient_id'];
			$this->request->data['DietaryAssessment']['patient_name'] =  $patientData['Patient']['lookup_name'];
			$this->request->data['DietaryAssessment']['location_id'] = $this->Session->read('locationid');

			$this->request->data['DietaryAssessment']['date'] = $this->DateFormat->formatDate2STD($this->request->data['DietaryAssessment']['date'],Configure::read('date_format'));

			$splitDate = explode(' ',$this->request->data['DietaryAssessment']['date']);
			$this->request->data['DietaryAssessment']['time'] = $splitDate[1];
			$this->request->data['DietaryAssessment']['date'] = $splitDate[0];

			$this->request->data['DietaryAssessment']['created_by'] = $this->Session->read('userid');
			$this->request->data['DietaryAssessment']['modified_by'] = $this->Session->read('userid');
			$this->request->data['DietaryAssessment']['create_time'] = date('Y-m-d H:i:s');
			$this->request->data['DietaryAssessment']['modify_time'] = date('Y-m-d H:i:s');
			//pr($this->request->data);exit;
			if($this->DietaryAssessment->save($this->request->data['DietaryAssessment'])){
				foreach($getData as $key => $data){
					if($key!= 'DietaryAssessment'){
						$split = explode(' ',$data['date']);
						$data['patient_id'] = $patientData['Patient']['id'];
						$data['dietry_assessment_id'] = $this->DietaryAssessment->id;
						$data['location_id'] = $this->Session->read('locationid');
						$data['created_by'] = $this->Session->read('userid');
						$data['modified_by'] = $this->Session->read('userid');
						$data['create_time'] = date('Y-m-d H:i:s');
						$data['modify_time'] = date('Y-m-d H:i:s');
						$data['date'] = $this->DateFormat->formatDate2STD($split[0],Configure::read('date_format'));
						$data['time'] = $split[1];
						//pr($data);exit;
						if(!empty($data['date'])){
							$this->DietryNote->saveAll($data);
						}
					}
				}
				$this->Session->setFlash(__('The data has been saved successfully!'),'default',array('class'=>'message'));
				$this->redirect(array('controller'=>'nursings','action'=>'dietaryAssessment',$id));
			} else {
				$this->Session->setFlash(__('The data could not be saved!'),'default',array('class'=>'error'));
				$this->redirect(array('controller'=>'nursings','action'=>'dietaryAssessment',$id));
			}
		}
		if(empty($this->request->data)){
			// patient_ifo function is defined in app controller, parameter needed: Patient Id
			$this->patient_info($id);
			// Collect all the data
			$collectData = $this->DietaryAssessment->find('all',array('conditions'=>array('DietaryAssessment.patient_id'=>$id,'DietaryAssessment.location_id'=>$this->Session->read('locationid'))));
			// collect dates for which the data has been inserted. arrayDate is the function defined in nursings controller
			$this->arrayDate($collectData,'DietaryAssessment');

		}
		$this->set('patient_id',$id);
		$this->set('source',$source);
	}


	public function print_dietry_assessment($id=null){
		$this->layout = 'print_with_header';
		$this->uses = array('DietaryAssessment','DietryNote','Patient','Person','User','Ward','Room','Bed','Corporate','InsuranceCompany');
		$date = $queryDate = $this->DateFormat->formatDate2STDForReport($this->params->query['date'],Configure::read('date_format'));

		$getDietryAssessment = '';
		$this->patient_info($id);
		if(!empty($id)){
			//Get the Dietry Assessment details
			$getDietryAssessment = $this->DietaryAssessment->find('first',array('conditions'=>array('DietaryAssessment.patient_id'=>$id,
					"DietaryAssessment.date like '%$date%'",'DietaryAssessment.location_id'=>$this->Session->read('locationid'))));

			$this->set(array('getDietryAssessment'=>$getDietryAssessment));
		}
		$this->set('title', __('DIETRY ASSESSMENT', true)); // THis is the title for the printout

	}


	/**
	@Name		 : assessment_forth_admission
	@created for : To fourth admission nursing form
	@created by  : ANAND
	@created on  : 3/5/2012
	@modified on :
	**/
	public function assessment_forth_admission($id = null){

	}

	/**
	@Name		 : fall_assessment
	@created for : To fall_assessment form
	@created by  : ANAND
	@created on  : 3/6/2012
	@modified on :
	**/
	public function fall_assessment($id = null){
		$this->uses = array('FallAssessment','Patient','Person','User','Ward','Room','Bed','Corporate','InsuranceCompany');
		// When there is call of ajax

		if($this->params['isAjax']){
			$patient_id = $this->params->query['patient_id'];
			// Change date to standered format
			$queryDate = $this->DateFormat->formatDate2STDForReport($this->params->query['date'],Configure::read('date_format'));
			// Get the letest entry on the paient
			//$maxId = $this->FallAssessment->find('first',array('conditions'=>array('FallAssessment.date'=>$queryDate,
			//'FallAssessment.patient_id'=>$patient_id,'FallAssessment.location_id'=>$this->Session->read('locationid')),'fields' => array('MAX(FallAssessment.id) as max_id')));
			// get current data
			$getData = $this->FallAssessment->find('first',array('conditions'=>array(
					'FallAssessment.date like'=>"%".$queryDate ,'FallAssessment.patient_id'=>$patient_id,'FallAssessment.location_id'=>$this->Session->read('locationid'))));

			/*To collect dates in array for which the data has been enterd. Used in datepicker*/
			// Collect all the data
			$collectData = $this->FallAssessment->find('all',array('conditions'=>array('FallAssessment.patient_id'=>$patient_id,'FallAssessment.location_id'=>$this->Session->read('locationid'))));
			// collect dates for which the data has been inserted. arrayDate is the function defined in nursings controller
			$this->arrayDate($collectData,'FallAssessment');

			// Set data to ajax view
			$this->set(compact('getData'));
			$this->set(compact('patient_id'));
			$this->set('date',$queryDate); // last entry date
			$this->render('ajaxfallassessment');

		}

		if(!empty($this->request->data)){

			unset($this->request->data['previousRecord']);
			$split = explode(' ',$this->request->data['FallAssessment']['date']);
			$this->request->data['FallAssessment']['date'] = $split[0];
			$this->request->data['FallAssessment']['time'] = $split[1];

			$count = 0;

			// Create ne array with proper record
			$patientData = $this->Patient->find('first',array('conditions'=>array('Patient.id'=>$id))); // COllect patient details
			$this->request->data['FallAssessment']['date'] = $this->DateFormat->formatDate2STD($this->request->data['FallAssessment']['date'],Configure::read('date_format'));
			$this->request->data['FallAssessment']['location_id'] = $this->Session->read('locationid');
			$this->request->data['FallAssessment']['patient_uid'] = $patientData['Patient']['patient_id'];
			$this->request->data['FallAssessment']['patient_name'] = $patientData['Patient']['lookup_name'];
			$this->request->data['FallAssessment']['patient_id'] = $id;
			$this->request->data['FallAssessment']['created_by'] = $this->Session->read('userid');
			$this->request->data['FallAssessment']['create_time'] =date('Y-m-d h:i:s');
			$this->request->data['FallAssessment']['modify_time'] =date('Y-m-d h:i:s');
			$this->request->data['FallAssessment']['created_by'] = $this->Session->read('userid');
			//pr($this->request->data);exit;
			if($this->FallAssessment->save($this->request->data)){
				$this->Session->setFlash(__('The Fall Assessment has been saved successfully!'),'default',array('class'=>'message'));
				$this->redirect(array('controller'=>'nursings','action'=>'fall_assessment',$id));

			} else {
				$this->Session->setFlash(__('The Fall Assessment could not be saved!'),'default',array('class'=>'error'));
				$this->redirect(array('controller'=>'nursings','action'=>'fall_assessment',$id));
			}

		}
		// Set necessary element to view
		if(empty($this->request->data)){
			//Count record to print
			$countRecord = $this->FallAssessment->find('count',array('conditions'=>array('FallAssessment.patient_id'=>$id,'FallAssessment.location_id'=>$this->Session->read('locationid'))));


			// patient_ifo function is defined in app controller, parameter needed: Patient Id
			$this->patient_info($id);

			// Collect all the data
			$collectData = $this->FallAssessment->find('all',array('conditions'=>array('FallAssessment.patient_id'=>$id,'FallAssessment.location_id'=>$this->Session->read('locationid'))));
			// collect dates for which the data has been inserted. arrayDate is the function defined in nursings controller
			$this->arrayDate($collectData,'FallAssessment');
			$this->set('countRecord',$countRecord);
		}
	}

	/**
	@Name		 : setAddressFormat
	@created for : To get formated address
	@created by  : ANAND
	@created on  : 3/6/2012
	@modified on :
	**/

	public function print_fallassessment($id=null){
		$this->uses = array('FallAssessment','Patient','Person');
		$this->layout  = 'print_with_header' ;
		$this->set('title_for_layout', __('FALL ASSESSMENT', true));
		$date = $this->params['named']['date'];
		//pr($this->params);exit;
		if(!empty($id) AND $date != ''){
			$record = $this->FallAssessment->find('first',array('conditions'=>array('FallAssessment.patient_id'=>$id,'FallAssessment.date'=>$date,'FallAssessment.location_id'=>$this->Session->read('locationid'))));
			//pr($record);exit;
			$patient_name = $this->Patient->field('lookup_name',array('Patient.id'=>$id));
			$patient_uid = $this->Patient->field('patient_id',array('Patient.id'=>$id));

			$UIDpatient_details  = $this->Person->getUIDPatientDetailsByPatientID($id);
			$formatted_address   = $this->Patient->setAddressFormat($UIDpatient_details['Person']); // Formatted address for patient
			$this->set('date',$this->DateFormat->formatDate2Local($date,Configure::read('date_format')));
			$this->set(compact('formatted_address'));
			$this->set(compact('patient_uid'));
			$this->set('patient',$this->Patient->find('first',array('conditions'=>array('Patient.id'=>$id))));
			$this->set(compact('patient_name'));
			$this->set(compact('record'));
			$this->set('title', __('FALL ASSESSMENT', true)); // THis is the title for the printout
			$this->patient_info($id);
		} else {
			echo "No Record Found!";exit;
		}
	}


	/**
	@Name		 : fall_assessment_summery
	@created for : To get formated address
	@created by  : ANAND
	@created on  : 3/6/2012
	@modified on :
	**/
	public function fall_assessment_summary($id = null){
		$this->uses = array('FallAssessmentSummery','FallAssessment','Patient','Person','User','Ward','Room','Bed','Corporate','InsuranceCompany');

		if(empty($this->request->data)){

			// Collect Fall Assesment, Thins need to paginate.
			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'order' => array('FallAssessment.create_time' => 'DESC'),
					'fields'=> array('FallAssessment.date,FallAssessment.total_score ,FallAssessment.risk_level,FallAssessment.time,FallAssessment.id'),
					'conditions'=>array('FallAssessment.patient_id'=>$id,'FallAssessment.location_id'=>$this->Session->read('locationid'))
			);


			// Get the previous Entry
			$PreviousEntry = $this->FallAssessmentSummery->find('all',array('conditions'=>array('FallAssessmentSummery.patient_id'=>$id,'FallAssessmentSummery.location_id'=>$this->Session->read('locationid'))));
			// patient_ifo function is defined in app controller, parameter needed: Patient Id
			$this->patient_info($id);
			// Set data to view
			$this->set(array('record'=>$this->paginate('FallAssessment'),'PreviousEntry'=>$PreviousEntry));

		}
	}


	/**
	@Name		 : print_fall_assessment_summery
	@created for : To gprint fall assessmet summary
	@created by  : ANAND
	@created on  : 3/12/2012
	@modified on :
	**/

	public function print_fall_assessment_summary($id=null){
		$this->uses = array('FallAssessmentSummery','FallAssessment','Patient','Person');
		$this->layout  = 'print_with_header' ;
		$this->set('title_for_layout', __('FALL ASSESSMENT SUMMARY', true));

		if(!empty($id)){
			// Collect Fall Assesment
			$record = $this->FallAssessment->find('all',array('order'=>array('FallAssessment.create_time'=>'desc'),'conditions'=>array('FallAssessment.patient_id'=>$id,'FallAssessment.location_id'=>$this->Session->read('locationid'))));

			// Get the previous Entry
			$PreviousEntry = $this->FallAssessmentSummery->find('all',array('conditions'=>array('FallAssessmentSummery.patient_id'=>$id,'FallAssessmentSummery.location_id'=>$this->Session->read('locationid'))));
			$patient_name = $this->Patient->field('lookup_name',array('Patient.id'=>$id));
			$patient_uid = $this->Patient->field('patient_id',array('Patient.id'=>$id));

			$UIDpatient_details  = $this->Person->getUIDPatientDetailsByPatientID($id);
			$formatted_address   = $this->Patient->setAddressFormat($UIDpatient_details['Person']); // Formatted address for patient
			$this->set('patient',$this->Patient->find('first',array('conditions'=>array('Patient.id'=>$id))));
			$this->set('title', __('FALL ASSESSMENT SUMMARY', true));
			$this->patient_info($id);
			$this->set(array('record'=>$record,'PreviousEntry'=>$PreviousEntry,'formatted_address'=>$formatted_address,'patient_uid'=>$patient_uid,'patient_name'=>$patient_name));
		} else {
			echo "Sorry! Fall Assessment Summary could not be displayed due to some internal error. Please try again later.";exit;
		}

	}

	/**
	@Name		 : intervention
	@created for : To get interventions on fall assessment summary
	@created by  : ANAND
	@created on  : 3/6/2012
	@modified on :
	**/
	public function intervention($id = null){
		$this->layout =  false;
		$this->uses = array('FallAssessment');
		$risk_level = $this->params['named']['risk_level'];
		$row_id = $this->params['named']['row_id'];
		// Set variables to layout
		$this->set(array('risk_level'=>$risk_level,'patient_id'=>$id,'row_id'=>$row_id));
		if(!empty($id)){
			$PreviousEntry = $this->FallAssessment->find('first',array('conditions'=>array('FallAssessment.id'=>$row_id,'FallAssessment.patient_id'=>$id,'FallAssessment.location_id'=>$this->Session->read('locationid'))));
			$this->set('title', __('FALL ASSESSMENT INTERVENTIONS', true));
			$this->patient_info($id);
			$this->set(array('PreviousEntry'=>$PreviousEntry));
		}
		$this->patient_info($id);
	}




	/**
	 * add ward charges
	 */

	public function addWardCharges($patientId=''){

		$this->uses = array('Nursing','ServiceBill','Patient','TariffList');
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Initial' =>array( 'foreignKey'=>'initial_id'),
				)));
		$patient_details  = $this->Patient->getPatientDetailsByID($patientId);
		#pr($patient_details);exit;
		$this->set('patient',$patient_details);
		$this->patient_info($patientId);


		if($this->request->data  && !isset($this->request->data['service_name'])){

			$serviceData = array();
			$patient_id = $this->request->data['Nursing']['patient_id'];
			if($this->DateFormat->formatDate2STD($this->request->data['Nursing']['date'],Configure::read('date_format')) == date("Y-m-d")){
				#$this->ServiceBill->deleteAll(array('patient_id'=>$patient_id,'date'=>date("Y-m-d")),false);
			}
			$dte = $this->DateFormat->formatDate2STD($this->request->data['Nursing']['date'],Configure::read('date_format'));
			echo $passedDate = explode(" ",$dte);
			$oldData = $this->ServiceBill->find('all',array('conditions'=>array('patient_id'=>$patient_id,'date'=>$passedDate[0])));
			$tmpData = array();
			foreach($oldData as $oData){
				$tmpData[$oData['ServiceBill']['tariff_list_id']]= $oData['ServiceBill']['id'];
			}

			foreach($this->request->data['Nursing'] as $key=>$service){
				if(is_array($service)){#pr($service);exit;
					$serviceData['tariff_list_id']=$key;
					$serviceData['tariff_standard_id']=$patient_details['Patient']['tariff_standard_id'];
					$serviceData['location_id']=$this->Session->read('locationid');
					$serviceData['morning']=$service['morning'];
					$serviceData['evening']=$service['evening'];
					$serviceData['night']=$service['night'];
					$serviceData['no_of_times']=$service['no_of_times'];
					$serviceData['patient_id']=$patient_id;

					$serviceData['date']=$this->DateFormat->formatDate2STD($this->request->data['Nursing']['date'],Configure::read('date_format'));//date("Y-m-d");
					$serviceData['create_time'] = date('Y-m-d H:i:s');
					if($serviceData['morning']==1 || $serviceData['evening']==1 || $serviceData['night']==1){
						if(isset($tmpData[$key])){
							$this->ServiceBill->delete($tmpData[$key]);
						}

						$this->ServiceBill->save($serviceData);
						$this->ServiceBill->id='';
					}
					$serviceData['morning']=$serviceData['evening']=$serviceData['night']=0;
				}

			}
			$this->Session->setFlash(__('Record saved successfully.'),'default',array('class'=>'message'));
			$this->redirect($this->referer());
		}
			
		if(isset($this->request->data['service_name']) && $this->request->data['service_name']!=''){
			$serviceName = $this->request->data['service_name'];
		}else{
			$serviceName = '';
		}

		if($this->request->data['Nursing']['date']==''){
			$date=date('Y-m-d');
		}else{
			$date=$this->DateFormat->formatDate2STD($this->request->data['Nursing']['date'],Configure::read('date_format'));
		}
		if(isset($this->request->query['serviceDate']) && $this->request->query['serviceDate']!=''){
			$date=$this->DateFormat->formatDate2STD($this->request->query['serviceDate'],Configure::read('date_format'));
		}
		$date = explode(" ",$date);
		$date = $date[0];

		$this->TariffList->bindModel(array(
				'belongsTo' => array(
						'TariffAmount' =>array('foreignKey' => false,'conditions'=>array('TariffAmount.tariff_list_id=TariffList.id','TariffAmount.tariff_standard_id='.$patient_details['Patient']['tariff_standard_id'])),
						'ServiceBill' =>array( 'foreignKey'=>false,'type'=>'left','conditions'=>array('ServiceBill.patient_id'=>$patientId,'ServiceBill.tariff_list_id=TariffList.id','ServiceBill.date'=>$date)),
						'ServiceCategory'=>array( 'foreignKey'=>'service_category_id')
				)),false);
			
		if($serviceName!=''){
			/*$this->paginate = array(
			 'limit' => Configure::read('number_of_rows'),
					'order' => array('TariffList.id' => 'asc'),
					'group'=>array('TariffList.id'),
					'conditions'=>array('TariffList.name like'=> $serviceName.'%','TariffList.location_id'=>$this->Session->read('locationid'),
							'TariffList.is_deleted'=>0)
			);
			$services=$this->paginate('TariffList');*/
			$services = $this->TariffList->find('all',array('group'=>array('TariffList.id'),'order'=>array('TariffList.name'),
					'conditions'=>array('TariffList.name like'=>$serviceName.'%','TariffList.location_id'=>$this->Session->read('locationid'),
							'TariffList.is_deleted'=>0)));
		}else{
			/*$this->paginate = array(
			 'limit' => Configure::read('number_of_rows'),
					'order' => array('TariffList.id' => 'asc'),
					'group'=>array('TariffList.id'),
					'conditions'=>array('TariffList.location_id'=>$this->Session->read('locationid'),'TariffList.is_deleted'=>0));
			$services=$this->paginate('TariffList');*/

			//No need to display
		}

		$this->set('services',$services);
		$this->set('patient_id',$patientId);
		$this->set('service_date',$date);
	}

	public function saveWardCharges(){
		$this->uses = array('WardBilling');
		#pr($this->request->data);exit;
		$data = array();
		$this->WardBilling->deleteAll(array('date'=>$this->request->data['Ward']['date'],'patient_id'=>$this->request->data['Ward']['patient_id'],'ward_id'=>$this->request->data['Ward']['ward_id'],'location_id'=>$this->Session->read('locationid')));
		foreach($this->request->data['Ward']['id'] as $key=>$service){
			if(isset($this->request->data['Ward']['service'][$key])){
				#array_push($data, $service);
				$data['services_ward_id']=$service;
				$data['ward_id']=$this->request->data['Ward']['ward_id'];
				$data['patient_id']=$this->request->data['Ward']['patient_id'];
				$data['location_id']=$this->Session->read('locationid');
				$data['date']=$this->request->data['Ward']['date'];
				$data['created_by']=$this->Session->read('userid');
				$data['modified_by']=$this->Session->read('userid');
				$data['create_time']=date('Y-m-d H:i:s');
				$data['modify_time']=date('Y-m-d H:i:s');
				#pr($data);exit;
				$this->WardBilling->save($data);
				$this->WardBilling->id ='';
			}

		}#pr($data);exit;
		$this->redirect(array('controller'=>'nursings','action'=>'addWardCharges',$this->request->data['Ward']['patient_id']));
	}

	/**
	@Name		 : print_intervention
	@created for : To print the interventions of the patient according to the risk
	@created by  : ANAND
	@created on  : 3/6/2012
	@modified on :
	**/
	public function print_intervention($id = null){
		$this->uses = array('FallAssessmentSummery','FallAssessment','Patient','Person');
		$this->layout =  'print_with_header';
		$risk_level = $this->params['named']['risk_level'];
		$row_id = $this->params['named']['row_id'];
		if(!empty($id)){
			$PreviousEntry = $this->FallAssessment->find('first',array('conditions'=>array('FallAssessment.id'=>$row_id,'FallAssessment.patient_id'=>$id,'FallAssessment.location_id'=>$this->Session->read('locationid'))));
			//pr($PreviousEntry);exit;
			$patient_name = $this->Patient->field('lookup_name',array('Patient.id'=>$id));
			$patient_uid = $this->Patient->field('patient_id',array('Patient.id'=>$id));

			$UIDpatient_details  = $this->Person->getUIDPatientDetailsByPatientID($id);
			$formatted_address   = $this->Patient->setAddressFormat($UIDpatient_details['Person']); // Formatted address for patient
			$this->set('patient',$this->Patient->find('first',array('conditions'=>array('Patient.id'=>$id))));
			$this->set('title', __('FALL ASSESSMENT INTERVENTIONS', true));
			$this->patient_info($id);
			$this->set(array('formatted_address'=>$formatted_address,'patient_uid'=>$patient_uid,'patient_name'=>$patient_name,
					'PreviousEntry'=>$PreviousEntry));
		}
		// Set variables to layout
		$this->set(array('risk_level'=>$risk_level,'patient_id'=>$id));
	}

	/**
	@Name		 : admission_checklist
	@created for : admission checklist for nursing
	@created by  : ANAND
	@created on  : 3/20/2012
	@modified	 : 3/21/2012
	**/
	public function admission_checklist($id=null){
		$this->uses = array('AdmissionChecklist','Patient','Person','User','Ward','Room','Bed','Corporate','InsuranceCompany');
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'User' =>array( 'foreignKey'=>'nurse_id'),
						
				),
			));
		$patientData = $this->Patient->find('first',array('conditions'=>array('Patient.id'=>$id))); // COllect patient details
		
		//pr($patientData);exit;
		if(!empty($this->request->data)){
			// if the admission checklist is already saved then take its id and edit it
			$lastEntryId = $this->AdmissionChecklist->field('id',array('AdmissionChecklist.patient_id'=>$id,'AdmissionChecklist.location_id'=>$this->Session->read('locationid')));
			if(!empty($lastEntryId)){
				$this->request->data['AdmissionChecklist']['id'] = $lastEntryId;
			}
			// Seprate date and time


			// Collect patient details
			
			$converted = $this->DateFormat->formatDate2STD($this->request->data['AdmissionChecklist']['date'],Configure::read('date_format'));
			$split = explode(' ',$converted);
			$this->request->data['AdmissionChecklist']['time'] = $split[1];
			$this->request->data['AdmissionChecklist']['date'] = $split[0];
			$this->request->data['AdmissionChecklist']['location_id'] = $this->Session->read('locationid');
			$this->request->data['AdmissionChecklist']['patient_uid'] = $patientData['Patient']['patient_id'];
			$this->request->data['AdmissionChecklist']['patient_name'] = $patientData['Patient']['lookup_name'];
			$this->request->data['AdmissionChecklist']['patient_id'] = $id;
			$this->request->data['AdmissionChecklist']['created_by'] = $this->Session->read('userid');
			$this->request->data['AdmissionChecklist']['create_time'] =date('Y-m-d h:i:s');
			$this->request->data['AdmissionChecklist']['modify_time'] =date('Y-m-d h:i:s');
			$this->request->data['AdmissionChecklist']['created_by'] = $this->Session->read('userid');
			//pr($this->request->data);exit;
			// Save collected data in table
			if($this->AdmissionChecklist->save($this->request->data)){
				$this->Session->setFlash(__('The Registration Checklist has been saved successfully!'),'default',array('class'=>'message'));
				$this->redirect(array('controller'=>'nursings','action'=>'admission_checklist',$id));
			} else {
				$this->Session->setFlash(__('The Registration Checklist could not be saved!'),'default',array('class'=>'error'));
				$this->redirect(array('controller'=>'nursings','action'=>'admission_checklist',$id));
			}


		}
		/*This is needed for patient information element */
		if(empty($this->request->data)){

			$maxId = $this->AdmissionChecklist->find('first',array('conditions'=>array('AdmissionChecklist.patient_id'=>$id,'AdmissionChecklist.location_id'=>$this->Session->read('locationid')),'fields' => array('MAX(AdmissionChecklist.id) as max_id')));

			$data = $this->AdmissionChecklist->find('first',array('conditions'=>array('AdmissionChecklist.id'=>$maxId[0]['max_id'],'AdmissionChecklist.patient_id'=>$id,'AdmissionChecklist.location_id'=>$this->Session->read('locationid'))));
			// Check if last entry is in table or not for the patient to print the form
			$lastEntryId = $data['AdmissionChecklist']['id'];
			$this->set('lastEntryId',$lastEntryId);
			//pr($data);exit;
			$this->request->data = $data;

			// patient_ifo function is defined in app controller, parameter needed: Patient Id
			$this->patient_info($id);

		}
		$this->set(compact('patientData'));
	}

	/**
	@Name		 : print_admission_checklist
	@created for : to print admission checklist for nursing
	@created by  : ANAND
	@created on  :3/21/2012
	@modified
	**/
	public function print_admission_checklist($id = null){
		$this->uses = array('AdmissionChecklist','Patient','Person','User','Ward','Room','Bed','Corporate','InsuranceCompany');
		$this->layout =  'print_with_header';
		if(!empty($id)){
			$lastEntry	= $this->AdmissionChecklist->find('first',array('conditions'=>array('AdmissionChecklist.patient_id'=>$id,'AdmissionChecklist.location_id'=>$this->Session->read('locationid'))));
			$patient_name = $this->Patient->field('lookup_name',array('Patient.id'=>$id));
			$patient_uid = $this->Patient->field('patient_id',array('Patient.id'=>$id));
			$this->patient_info($id);
			$UIDpatient_details  = $this->Person->getUIDPatientDetailsByPatientID($id);
			$formatted_address   = $this->Patient->setAddressFormat($UIDpatient_details['Person']); // Formatted address for patient
			$this->set('patient',$this->Patient->find('first',array('conditions'=>array('Patient.id'=>$id))));
			$this->set('title', __('ADMISSION CHECKLIST', true));
			$this->set(array('formatted_address'=>$formatted_address,'patient_uid'=>$patient_uid,'patient_name'=>$patient_name,'lastEntry'=>$lastEntry));

		}
	}

	/**
	@Name		 : arrayDate
	@created for : to collect the dates on which data has been inserted.
	@created by  : ANAND
	@created on  :3/23/2012
	@modified
	**/

	function arrayDate($collectData, $model){
		$arrayDate[] = '';
		// Set loop to get dates
		foreach($collectData as $data){
			// get dates from table
			$date = $data[$model]['date'];

			// Explode to set proper format. Datepicker needs month and date without zero
			$getDate = explode('-',$date);


			// Create proper date
			if(!empty($getDate)){
				if($getDate[2] < 10){
					$newDay = explode(0,$getDate[2]);
				} else {
					$newDay = $getDate[2];
				}
				//Create proper month
				if($getDate[1] < 10){
					$newMonth = explode(0,$getDate[1]);
				} else {
					$newMonth = $getDate[1];
				}

				//pr($newDay);exit;
				// WHen date is 10 no need to spleet
				$newMonth =array();
				if($newMonth[1] == '') $newMonth[1] = 10;
				// new date here
				if($getDate[2] > 10){
					$newDate = $newMonth[1].'-'.$newDay.'-'.$getDate[0];
				} else {
					$newDate = $newMonth[1].'-'.$newDay[1].'-'.$getDate[0];
				}
			} else {
				// When dates and months are of tow digit
				$newDate = date('m-d-Y',strtotime($date));
			}

			// Create an array
			$arrayDate[] = $newDate;
		}

		$this->set(compact('arrayDate'));
	}


	/**
	@Name		 : arrayDateHighlight
	@created for : to collect the dates on which data has been inserted.
	@created by  : ANAND
	@created on  :3/23/2012
	@modified
	**/

	function arrayDateHighlight($collectData, $model){
		$arrayDateHighlight[] = '';
		// Set loop to get dates
		foreach($collectData as $data){
			// get dates from table
			$date = $data[$model]['date'];

			// Explode to set proper format. Datepicker needs month and date without zero
			$getDate = explode('-',$date);


			// Create proper date
			if(!empty($getDate)){

				$newDate = $getDate[1].'/'.$getDate[2].'/'.$getDate[0];
				//pr($getDate);exit;

			} else {
				// When dates and months are of tow digit
				$newDate = date('mm/dd/YY',strtotime($date));
			}

			// Create an array
			$arrayDateHighlight[] = $newDate;
		}

		$this->set(compact('arrayDateHighlight'));
	}

	/**
	@Name		 : notes_view
	@created for : for saving prescriptions.
	@created by  : Gaurav
	@created on  :3/23/2012
	@modified
	**/
	/*----------------not in use ---------------
	 * public function notes_view($notes_id=null,$patient_id=null) {
	$this->uses = array("Note",'SuggestedDrug','User','Consultant','PrescriptionRecord');
	$this->layout = 'ajax';
	if (empty($patient_id)) {
	echo "Invalid Note! Please Try Again."; exit;
	} else {

	// Collect the latest Id of the notes for the patient
	$notesRec = $this->Note->read(null,$notes_id);
	$suggestedDrugRec = $this->SuggestedDrug->find('all',array('conditions'=>array('note_id'=>$notes_id)));
	$checkdata = $this->PrescriptionRecord->find('all',array('fields'=>array('med_no','suggested_drug_id','create_time'),'conditions'=>array('patient_id'=>$patient_id,'note_id'=>$notes_id)));
	if(!empty($suggestedDrugRec)){
	$this->set('registrar',$this->User->getDoctorByID($notesRec['Note']['sb_consultant']));
	$this->set('consultant',$this->User->getDoctorByID($notesRec['Note']['sb_registrar']));
	$this->set('note', $notesRec);
	$this->set('patientid', $patient_id);
	for($k=0;$k<count($suggestedDrugRec);$k++){
	for($i=0;$i<count($checkdata);$i++){

	if($suggestedDrugRec[$k][SuggestedDrug][id] == $checkdata[$i][PrescriptionRecord][suggested_drug_id]){
	$suggestedDrugRec[$k][SuggestedDrug][create_date] = substr($checkdata[$i][PrescriptionRecord][create_time], 0, 10);
	$suggestedDrugRec[$k][SuggestedDrug][med_no][$i] = $checkdata[$i][PrescriptionRecord][med_no];
	}
	}
	}

	$this->set('medicines',$suggestedDrugRec);
	} else {
	echo "<center><h3>Sorry! No Prescription found for patient.</h3></center>";exit;
	}
	}
	}------------------------------------------*/

	public function notes_view($patient_id) {
		$this->uses = array('NewCropPrescription','Patient');
		$this->layout = 'ajax';
		if (empty($patient_id)) {
			echo "Invalid Note! Please Try Again."; exit;
		} else {
			//$patient_uid = $this->Patient->read('patient_id',$patient_id);

			//$newcrop_data = $this->NewCropPrescription->find('all',array('conditions'=>array('patient_id'=>$patient_uid['Patient']['patient_id'],'archive'=>'N','is_reconcile'=>'0'),
			//'group'=>'NewCropPrescription.description'));
				
			$newcrop_data = $this->NewCropPrescription->query("SELECT `NewCropPrescription`.`id`,`NewCropPrescription`.`route`,`NewCropPrescription`.`frequency`,
					`NewCropPrescription`.`frequency`,`NewCropPrescription`.`is_discharge_medication`,`NewCropPrescription`.`description`, `NewCropPrescription`.`patient_uniqueid`,
					`NewCropPrescription`.`dose` ,`NewCropPrescription`.`is_ccda` ,`NewCropPrescription`.`archive`,`NewCropPrescription`.`date_of_prescription` FROM
					`new_crop_prescription` AS `NewCropPrescription` INNER JOIN(SELECT MAX(date_of_prescription) as dateofpr from new_crop_prescription
					WHERE `patient_uniqueid` = $patient_id
					AND ( `new_crop_prescription`.`is_discharge_medication` IN (0,2) AND `new_crop_prescription`.`archive` IN ('N')  OR `new_crop_prescription`.`is_ccda` IN (1))
					group by description) newcrp1 on NewCropPrescription.date_of_prescription=newcrp1.dateofpr
					WHERE `patient_uniqueid` = $patient_id AND NewCropPrescription.`archive` IN ('N') AND NewCropPrescription.`is_reconcile` IN ('0') group by `NewCropPrescription`.`description`");
				
			//echo "<pre>";print_r($newcrop_data);
			if(!empty($newcrop_data)){
				$this->set(array('medicines'=>$newcrop_data,'patientid'=>$patient_id));
			} else {
				echo "<center><h3>Sorry! No Prescription found for patient.</h3></center>";exit;
			}
		}
	}

	public function print_doctors_prescription($id=null) {
		$this->uses = array("Note",'SuggestedDrug','Consultant','Patient','Person','User','Ward','Room','Bed','Corporate','InsuranceCompany');
		$this->layout = 'print_with_header';
		if (empty($id)) {
			echo "Invalid Note! Please Try Again."; exit;
		} else {

			// Collect the latest Id of the notes for the patient
			$maxId = $this->Note->find('first',array('conditions'=>array('Note.patient_id'=>$id),'fields' => array('MAX(Note.id) as max_id')));

			$notesRec = $this->Note->find('first',array('conditions'=>array('Note.id'=>$maxId[0]['max_id'],'Note.patient_id'=>$id)));

			$suggestedDrugRec = $this->SuggestedDrug->find('all',array('conditions'=>array('note_id'=>$maxId[0]['max_id'])));

			$patient_name = $this->Patient->field('lookup_name',array('Patient.id'=>$id));
			$patient_uid = $this->Patient->field('patient_id',array('Patient.id'=>$id));

			$UIDpatient_details  = $this->Person->getUIDPatientDetailsByPatientID($id);
			$formatted_address   = $this->Patient->setAddressFormat($UIDpatient_details['Person']); // Formatted address for patient
			$this->set('patient',$this->Patient->find('first',array('conditions'=>array('Patient.id'=>$id))));
			$this->set('title', __('DOCTOR'."'S".' PRESCRIPTION', true));
			$this->set(array('formatted_address'=>$formatted_address,'patient_uid'=>$patient_uid,'patient_name'=>$patient_name));

			$this->set('medicines',$suggestedDrugRec);
			$this->set('registrar',$this->User->getDoctorByID($notesRec['Note']['sb_registrar']));
			$this->set('consultant',$this->User->getDoctorByID($notesRec['Note']['sb_consultant']));
			$this->set('note', $notesRec);
			$this->set('patientid', $id);
		}
	}

	/**
	 *
	 * physiotherapy assessment form
	 *
	 **/
	public function physiotherapy_assessment_view($id=null) {

		$this->uses = array('PhysiotherapyAssessment','Patient');
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array(
						'PhysiotherapyAssessment.create_time' => 'DESC'
				)
		);
		$this->set('data',$this->paginate('PhysiotherapyAssessment'));
		// set patient dasboard information //
		$this->patient_info($id);
	}

	public function physiotherapy_assessment($id=null,$recordId=null,$flag=null) {

		$this->uses = array('PhysiotherapyAssessment','Patient');
		if($this->request->is('post') || $this->request->is('put')){
			// update if already exist //
			if($this->request->data['PhysiotherapyAssessment']['id']) {
				$this->PhysiotherapyAssessment->id = $this->request->data['PhysiotherapyAssessment']['id'];
			}
			$converted = $this->DateFormat->formatDate2STD($this->request->data['PhysiotherapyAssessment']['submit_date'],Configure::read('date_format'));
			$this->request->data['PhysiotherapyAssessment']['location_id'] = $this->Session->read('locationid');
			$this->request->data['PhysiotherapyAssessment']['submit_date'] = $converted;
			$this->request->data['PhysiotherapyAssessment']['created_by'] = $this->Session->read('userid');
			$this->request->data['PhysiotherapyAssessment']['create_time'] =date('Y-m-d h:i:s');
			$this->request->data['PhysiotherapyAssessment']['modify_time'] =date('Y-m-d h:i:s');
			$this->request->data['PhysiotherapyAssessment']['created_by'] = $this->Session->read('userid');
			$this->request->data['PhysiotherapyAssessment']['modified_by'] = $this->Session->read('userid');

			$patient_id  = $this->request->data['PhysiotherapyAssessment']['patient_id'];
			if($this->request->data['PhysiotherapyAssessment']['sbar'] == 'sbar'){
				if($this->PhysiotherapyAssessment->save($this->request->data)){
					$this->redirect(array('controller'=>'PatientsTrackReports','action' => 'sbar',$patient_id,'Assessment'));
				}
			}else{
					if($this->PhysiotherapyAssessment->save($this->request->data)){
						$this->Session->setFlash(__('The Physiotherapy Assessment has been saved successfully!'),'default',array('class'=>'message'));
						$this->redirect(array('controller'=>'nursings','action'=>'physiotherapy_assessment_view',$patient_id));
					}else {
						$this->Session->setFlash(__('The Physiotherapy Assessment could not be saved!'),'default',array('class'=>'error'));
					//$this->redirect(array('controller'=>'nursings','action'=>'physiotherapy_assessment_view',$id));
					}
				}
			}
		if(!empty($id) && !empty($recordId)){
			$patientPhysioAssessDetails = $this->PhysiotherapyAssessment->find('first',
					array('conditions' => array('PhysiotherapyAssessment.id' => $recordId,'PhysiotherapyAssessment.patient_id' => $id)));
			$this->set('patientPhysioAssessDetails', $patientPhysioAssessDetails);
			//$this->patient_info($patient_id);
		}
		$this->patient_info($id);
		$this->set('patient_id',$id);
		$this->set('flag',$flag);
		
		// set patient dasboard information //

	}

	/**
	 *
	 * print physiotherapy assessment form
	 *
	 **/
	public function print_physiotherapy_assessment($id = null){
		$this->uses = array('PhysiotherapyAssessment','Patient','Person');
		$this->layout =  'print_with_header';
		$patientPhysioAssessDetails = $this->PhysiotherapyAssessment->find('first', array('conditions' => array('PhysiotherapyAssessment.id' => $id), 'order' => array('PhysiotherapyAssessment.create_time DESC')));

		//$patient_name = $this->Patient->field('lookup_name',array('Patient.id'=>$id));
		//$patient_uid = $this->Patient->field('patient_id',array('Patient.id'=>$id));
		//$UIDpatient_details  = $this->Person->getUIDPatientDetailsByPatientID($id);
		//$formatted_address   = $this->Patient->setAddressFormat($UIDpatient_details['Person']); // Formatted address for patient
		//$this->set('patient',$this->Patient->find('first',array('conditions'=>array('Patient.id'=>$id))));
		$this->patient_info($patientPhysioAssessDetails['PhysiotherapyAssessment']['patient_id']);
		$this->set('title', __('Physiotherapy Assessment', true));
		$this->set(array('patientPhysioAssessDetails'=>$patientPhysioAssessDetails));

	}

	public function delete_physiotherapy_assessment($id){
		$this->uses = array('PhysiotherapyAssessment');
		if(!$id){
			$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));

		}
		if($this->PhysiotherapyAssessment->delete($id)){
			$this->Session->setFlash(__('Record deleted successfully'),'default',array('class'=>'message'));

		}else{
			$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));

		}
		$this->redirect($this->referer());
	}
	/* Blood Sugar Monitor form*/
	public function blood_sugar_monitoring($id = null,$print = false){
		$this->uses = array('Person','Consultant','User','Patient','Ward','Room','Bed','Corporate','InsuranceCompany','PatientBloodSugarMonitoring');
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Initial' =>array( 'foreignKey'=>'initial_id'),
						'Consultant' =>array('foreignKey'=>'consultant_treatment')
				),
				'hasMany'=>array(
						'PatientBloodSugarMonitoring' =>array( 'foreignKey'=>'patient_id'),
				)

		));
		if($this->request->is('post') || $this->request->is('put')){
			$data['PatientBloodSugarMonitoring'] = array();
			// echo "<pre>";print_r($this->request->data['PatientBloodSugarMonitoring']);exit;
			foreach($this->request->data['PatientBloodSugarMonitoring'] as $value){
				if(isset($value['deleteId'])){
					$this->PatientBloodSugarMonitoring->delete($value['deleteId']);
				}else{
					$value['patient_id'] = $id;
					$value['datetime'] =  $this->DateFormat->formatDate2STD($value['datetime'],Configure::read('date_format'));
					$value['created_by'] = $this->Session->read('userid');
					$value['create_time'] = date('Y-m-d h:i:s');
					array_push($data['PatientBloodSugarMonitoring'],$value);
				}

			}
			if(count($data['PatientBloodSugarMonitoring'])>0){
				if($this->PatientBloodSugarMonitoring->saveAll($data['PatientBloodSugarMonitoring'])){
					$this->Session->setFlash(__('Blood Monitor Details has been saved!'),'default',array('class'=>'message'));
					$this->redirect(array('controller'=>'nursings','action'=>'blood_sugar_monitoring',$id));
				}else {
					$this->Session->setFlash(__('Blood Monitor Details could not be saved'),'default',array('class'=>'error'));
					$this->redirect(array('controller'=>'nursings','action'=>'blood_sugar_monitoring',$id));
				}
			}else{
				$this->Session->setFlash(__('Record Deleted Successfully'),'default',array('class'=>'message'));
				$this->redirect(array('controller'=>'nursings','action'=>'blood_sugar_monitoring',$id));

			}
		}
		$this->patient_info($id);
		$bloodsugardetails = $this->PatientBloodSugarMonitoring->find("all",array("conditions"=>array("PatientBloodSugarMonitoring.patient_id"=> $id)));
		//echo "<pre>";print_r($this->referer());exit;
		$this->set('bloodsugardetails',$bloodsugardetails);
		//$this->set('moveBack',$this->referer());
		if($print){
			$this->layout = "print_with_header";
			$this->render('blood_sugar_monitoring_chart');
		}
	}
	/* Blood Transfusion Form*/
	public function patient_blood_transfusion($id,$formID = null,$print = false){
		$this->uses = array('Person','Consultant','User','Patient','Ward','Room','Bed','Corporate','InsuranceCompany','PatientBloodTransfusion');
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Initial' =>array( 'foreignKey'=>'initial_id'),
						'Consultant' =>array('foreignKey'=>'consultant_treatment')
				)
		));

		if($this->request->is('post') || $this->request->is('put')){

			if($formID == null){
				$this->request->data['PatientBloodTransfusion']['patient_id'] = $id;
				$this->request->data['PatientBloodTransfusion']['created_time'] = date('Y-m-d h:i:s');
				$this->request->data['PatientBloodTransfusion']['created_by'] = $this->Session->read('userid');
			}
			if($formID != null){
				$this->PatientBloodTransfusion->id =$formID;
				$this->request->data['PatientBloodTransfusion']['updated_time'] = date('Y-m-d h:i:s');
				$this->request->data['PatientBloodTransfusion']['updated_by'] = $this->Session->read('userid');
			}
			if(!isset($this->request->data['PatientBloodTransfusion']['is_unusual_discoloration'])){
				$this->request->data['PatientBloodTransfusion']['is_unusual_discoloration'] =0;
				$this->request->data['PatientBloodTransfusion']['unusual_discoloration'] ="";

			}
			if(!isset($this->request->data['PatientBloodTransfusion']['is_premedication_given'])){
				$this->request->data['PatientBloodTransfusion']['is_premedication_given'] = 0;
				$this->request->data['PatientBloodTransfusion']['premedication_given'] ="";

			}
			$this->request->data['PatientBloodTransfusion']['other_detail'] = serialize($this->request->data['PatientBloodTransfusion']['other_detail']);
			$this->request->data['PatientBloodTransfusion']['systemic_examination'] = serialize($this->request->data['PatientBloodTransfusion']['systemic_examination']);
			$this->request->data['PatientBloodTransfusion']['transfusion_date'] = $this->DateFormat->formatDate2STD($this->request->data['PatientBloodTransfusion']['transfusion_date'],Configure::read('date_format'));
			$this->request->data['PatientBloodTransfusion']['expiry_date'] = $this->DateFormat->formatDate2STD($this->request->data['PatientBloodTransfusion']['expiry_date'],Configure::read('date_format'));
			// echo "<pre>";print_r($this->request->data['PatientBloodTransfusion']);exit;
			$this->request->data['PatientBloodTransfusion']['time_termination_of_tranfusion'] = $this->DateFormat->formatDate2STD($this->request->data['PatientBloodTransfusion']['time_termination_of_tranfusion'],Configure::read('date_format'));
			if($this->PatientBloodTransfusion->save($this->request->data)){
				$this->Session->setFlash(__('Details saved!'),'default',array('class'=>'message'));
				$this->redirect(array('controller'=>'nursings','action'=>'patient_blood_transfusion_list',$id));
			}else{
				$this->Session->setFlash(__('Details could not be saved!'),'default',array('class'=>'error'));
				$this->redirect(array('controller'=>'nursings','action'=>'patient_blood_transfusion',$id,$formID));
			}
		}
		$this->patient_info($id);
		if($formID!=null){
			$bloodTransusion = $this->PatientBloodTransfusion->read(null,$formID);
			$this->set("bloodTransusion",$bloodTransusion);
			if($print !=false){
				$this->layout = "print_with_header";
				$this->render('patient_blood_transfusion_print');
			}else{
				$this->render('patient_blood_transfusion_edit');
			}
		}
	}
	/* Blood Transfusion list*/
	public function patient_blood_transfusion_list($id = null){

		$this->uses = array('Person','Consultant','User','Patient','Ward','Room','Bed','Corporate','InsuranceCompany','PatientBloodTransfusion');
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Initial' =>array( 'foreignKey'=>'initial_id'),
						'Consultant' =>array('foreignKey'=>'consultant_treatment')
				),
				'hasMany'=>array(
						'PatientBloodTransfusion' =>array( 'foreignKey'=>'patient_id')
				)
		));
		$this->patient_info($id);
	}
	/* IVF list*/
	public function patient_ivf($id = null,$formID = null,$print = false){
		$this->uses = array('Person','Consultant','User','Patient','Ward','Room','Bed','Corporate','InsuranceCompany','PatientIvf');
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Initial' =>array( 'foreignKey'=>'initial_id'),
						'Consultant' =>array('foreignKey'=>'consultant_treatment')
				),
				'hasMany'=>array(
						'PatientIvf' =>array( 'foreignKey'=>'patient_id')
				)
		));
		if($this->request->is('post') || $this->request->is('put')){
			if($formID == null){
				$this->request->data['PatientIvf']['patient_id'] = $id;
				$this->request->data['PatientIvf']['created_time'] = date('Y-m-d h:i:s');
				$this->request->data['PatientIvf']['created_by'] = $this->Session->read('userid');
			}
			if($formID != null){
				$this->PatientIvf->id =$formID;
				$this->request->data['PatientIvf']['updated_time'] = date('Y-m-d h:i:s');
				$this->request->data['PatientIvf']['updated_by'] = $this->Session->read('userid');
			}
			foreach($this->request->data['intake_detail']['time'] as $key => $value){

				$time = $this->DateFormat->formatDate2STD(date($this->General->getCurrentStandardDateFormat("H:i:s"),strtotime($value)),Configure::read('date_format'));
				$timesplit = explode(" ",$time);
				$this->request->data['intake_detail']['time'][$key] = $timesplit[1];
			}

			$this->request->data['PatientIvf']['date'] = $this->DateFormat->formatDate2STD($this->request->data['PatientIvf']['date'],Configure::read('date_format'));
			$this->request->data['PatientIvf']['intake_detail'] = serialize($this->request->data['intake_detail']);
			if($this->PatientIvf->save($this->request->data)){
				$this->Session->setFlash(__('Details saved!'),'default',array('class'=>'message'));
				$this->redirect(array('controller'=>'nursings','action'=>'patient_ivf_list',$id));
			}else{
				$this->Session->setFlash(__('Details could not be saved!'),'default',array('class'=>'error'));
				$this->redirect(array('controller'=>'nursings','action'=>'patient_ivf',$id,$formID));
			}
		}
		$this->patient_info($id);
		if($formID!=null){
			$PatientIvf = $this->PatientIvf->read(null,$formID);
			$this->set("PatientIvf",$PatientIvf);
			if($print !=false){
				$this->layout = "print_with_header";
				$this->render('patient_ivf_print');
			}else{
				$this->render('patient_ivf_edit');
			}
		}
	}
	/* I.V.F. list*/
	public function patient_ivf_list($id = null){
		$this->uses = array('Person','Consultant','User','Patient','Ward','Room','Bed','Corporate','InsuranceCompany','PatientIvf');
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Initial' =>array( 'foreignKey'=>'initial_id'),
						'Consultant' =>array('foreignKey'=>'consultant_treatment')
				),
				'hasMany'=>array(
						'PatientIvf' =>array( 'foreignKey'=>'patient_id')
				)
		));
		$this->patient_info($id);
	}

	public function delete_record_form($id,$form = null, $formid = null){
		$this->uses = array('PatientBloodTransfusion','TracheostomyConsent','PatientIvf','PatientVentilatorConsent','HippaConsent');
		switch($form){
			case "ventilator_consent":
				$this->PatientVentilatorConsent->delete($formid);
				$this->redirect(array('controller'=>'nursings','action'=>'ventilator_consent_list',$id));
				break;
			case "ivf":
				$this->PatientIvf->delete($formid);
				$this->redirect(array('controller'=>'nursings','action'=>'patient_ivf_list',$id));
				break;
			case "blood_transfusion":
				$this->PatientBloodTransfusion->delete($formid);
				$this->redirect(array('controller'=>'nursings','action'=>'patient_blood_transfusion_list',$id));
				break;
			case "tracheostomy_consent":
				$this->TracheostomyConsent->delete($formid);
				$this->redirect(array('controller'=>'nursings','action'=>'tracheostomy_consent_list',$id));
				break;
			case "hippa_consent":
				$this->HippaConsent->delete($formid);
				$this->redirect(array('controller'=>'nursings','action'=>'hippa_consent_list',$id));
				break;
		}


	}
	/* icu consent form */
	
	public function icu_consent($id = null){
		$this->patient_info($id);
	}

	public function icu_consent_list($id = null){
		$this->patient_info($id);
	}
	
	
	public function icu_consent_edit($id = null){
		
	}
	
	public function icu_consent_print($id = null){
		
	}
	
	/*hippa consent form */
	public function hippa_consent($id = null,$formID=null,$print = false){//debug($this->request->data);exit;
		$this->layout = 'advance_ajax';
		App::import('Vendor', 'signature_to_image');
		 $this->uses = array('Person','Consultant','User','Patient','Ward','Room','Bed','Corporate','InsuranceCompany','HippaConsent','Location','NewInsurance','');
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Initial' =>array( 'foreignKey'=>'initial_id'),
						'Consultant' =>array('foreignKey'=>'consultant_treatment'),
					    'Doctor' =>array('foreignKey'=>'doctor_id'),
						
				),
				'hasMany'=>array(
						'HippaConsent' =>array( 'foreignKey'=>'patient_id')
				)
		));
		
		if($this->request->is('post') || $this->request->is('put')){
			$this->request->data['HippaConsent']['dob'] =$this->DateFormat->formatDate2STD($this->request->data['HippaConsent']['dob'],Configure::read('date_format'));
			$this->request->data['HippaConsent']['expi_date'] =$this->DateFormat->formatDate2STD($this->request->data['HippaConsent']['expi_date'],Configure::read('date_format'));
			$this->request->data['HippaConsent']['redis_client_date'] =$this->DateFormat->formatDate2STD($this->request->data['HippaConsent']['redis_client_date'],Configure::read('date_format'));
			$this->request->data['HippaConsent']['staff_witness_date'] =$this->DateFormat->formatDate2STD($this->request->data['HippaConsent']['staff_witness_date'],Configure::read('date_format'));
			if($formID == null){
				$this->request->data['HippaConsent']['patient_id'] = $id;
				$this->request->data['HippaConsent']['create_time'] = date('Y-m-d h:i:s');
				$this->request->data['HippaConsent']['created_by'] = $this->Session->read('userid');
			}
			if($formID != null){
				$this->PatientVentilatorConsent->id =$formID;
				$this->request->data['HippaConsent']['id'] = $formID;
				$this->request->data['HippaConsent']['modify_time'] = date('Y-m-d h:i:s');
				$this->request->data['HippaConsent']['modified_by'] = $this->Session->read('userid');
			}
			if(!empty($this->request->data["HippaConsent"]["client_output"])) {
				$signImage = sigJsonToImage($this->request->data["HippaConsent"]["client_output"],array('imageSize'=>array(320, 150)));
				$signpadfile = date('U').'.png';
				imagepng($signImage, WWW_ROOT.'signpad'.DS.$signpadfile);
				$this->request->data["HippaConsent"]["client_sign"] = $signpadfile;
			}
			if(!empty($this->request->data["HippaConsent"]["parent_output"])) {
				$signImage = sigJsonToImage($this->request->data["HippaConsent"]["parent_output"],array('imageSize'=>array(320, 150)));
				$signpadfile = date('U').'.png';
				imagepng($signImage, WWW_ROOT.'signpad'.DS.$signpadfile);
				$this->request->data["HippaConsent"]["parent_sign"] = $signpadfile;
			}
			if(!empty($this->request->data["HippaConsent"]["staff_output"])) {
				$signImage = sigJsonToImage($this->request->data["HippaConsent"]["staff_output"],array('imageSize'=>array(320, 150)));
				$signpadfile = date('U').'.png';
				imagepng($signImage, WWW_ROOT.'signpad'.DS.$signpadfile);
				$this->request->data["HippaConsent"]["staff_sign"] = $signpadfile;
			}
	
			if($this->HippaConsent->save($this->request->data)){
				$this->Session->setFlash(__('Details saved!'),'default',array('class'=>'message'));
				//$this->redirect(array('controller'=>'nursings','action'=>'hippa_consent_list',$id));
				$this->set('status','success') ;
			}else{
				$this->Session->setFlash(__('Details could not be saved!'),'default',array('class'=>'error'));
				$this->redirect(array('controller'=>'nursings','action'=>'hippa_consent',$id,$formID));
			}
		}
		$this->patient_info($id);
		$loc_id = $this->Session->read('locationid');
		$address2 = $this->Location->find('first',array('fields'=>array('Location.address1'),'conditions'=>array('Location.id'=>$loc_id)));
		$this->set('address2',$address2);
		
		if($formID!=null){
			$TracheostomyConsent = $this->HippaConsent->read(null,$formID);
			
			$this->set("HippaConsent",$TracheostomyConsent);
			
			if($print !=false){
				$this->layout = "print_with_header";
				$this->render('hippa_consent_print');
			}else{  
				$this->render('hippa_consent_edit'); 
			}
		}  
		
		$this->NewInsurance->bindModel(array(
				'belongsTo' => array(
						'Patient' =>array('foreignKey'=>false,
								'conditions'=>array('Patient.id = NewInsurance.patient_id')),
						'InsuranceCompany' =>array('foreignKey'=>false,
								'conditions'=>array('InsuranceCompany.id = NewInsurance.insurance_company_id'))),
				
		));
		$insurance_name=$this->NewInsurance->find('first',array('fields'=>array('InsuranceCompany.name'),'conditions'=>array('NewInsurance.patient_id'=>$id)));
		$this->set('insurance_name',$insurance_name);
		
		$requestData = $this->HippaConsent->find('first',array('conditions'=>array('patient_id'=>$id)));
		$requestData['HippaConsent']['dob'] =$this->DateFormat->formatDate2Local($requestData['HippaConsent']['dob'],Configure::read('date_format'),false);
		$requestData['HippaConsent']['expi_date'] =$this->DateFormat->formatDate2Local($requestData['HippaConsent']['expi_date'],Configure::read('date_format'),false);
		$requestData['HippaConsent']['redis_client_date'] =$this->DateFormat->formatDate2Local($requestData['HippaConsent']['redis_client_date'],Configure::read('date_format'),false);
		$requestData['HippaConsent']['staff_witness_date'] =$this->DateFormat->formatDate2Local($requestData['HippaConsent']['staff_witness_date'],Configure::read('date_format'),false);
		$this->data = $requestData;
	}
	
	
	
	public function hippa_consent_list($id = null){
		
		
		$this->uses = array('Person','Consultant','User','Patient','Ward','Room','Bed','Corporate','InsuranceCompany','HippaConsent');
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Initial' =>array( 'foreignKey'=>'initial_id'),
						'Consultant' =>array('foreignKey'=>'consultant_treatment')
				),
				'hasMany'=>array(
						'HippaConsent' =>array( 'foreignKey'=>'patient_id')
				)
		));
		$this->patient_info($id);
		
	}
	
	/* ventilator Consent form*/

	public function ventilator_consent($id = null,$formID = null,$print = false){
		$this->uses = array('Person','Consultant','User','Patient','Ward','Room','Bed','Corporate','InsuranceCompany','PatientVentilatorConsent');
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Initial' =>array( 'foreignKey'=>'initial_id'),
						'Consultant' =>array('foreignKey'=>'consultant_treatment')
				),
				'hasMany'=>array(
						'PatientVentilatorConsent' =>array( 'foreignKey'=>'patient_id')
				)
		));
		if($this->request->is('post') || $this->request->is('put')){
			$this->request->data['PatientVentilatorConsent']['date1'] =$this->DateFormat->formatDate2STD($this->request->data['PatientVentilatorConsent']['date1'],Configure::read('date_format'));
			$this->request->data['PatientVentilatorConsent']['date2'] =$this->DateFormat->formatDate2STD($this->request->data['PatientVentilatorConsent']['date2'],Configure::read('date_format'));
			if($formID == null){
				$this->request->data['PatientVentilatorConsent']['patient_id'] = $id;
				$this->request->data['PatientVentilatorConsent']['created_time'] = date('Y-m-d h:i:s');
				$this->request->data['PatientVentilatorConsent']['created_by'] = $this->Session->read('userid');
			}
			if($formID != null){
				$this->PatientVentilatorConsent->id =$formID;
				$this->request->data['PatientVentilatorConsent']['updated_time'] = date('Y-m-d h:i:s');
				$this->request->data['PatientVentilatorConsent']['updated_by'] = $this->Session->read('userid');
			}

			if($this->PatientVentilatorConsent->save($this->request->data)){
				$this->Session->setFlash(__('Details saved!'),'default',array('class'=>'message'));
				$this->redirect(array('controller'=>'nursings','action'=>'ventilator_consent_list',$id));
			}else{
				$this->Session->setFlash(__('Details could not be saved!'),'default',array('class'=>'error'));
				$this->redirect(array('controller'=>'nursings','action'=>'ventilator_consent',$id,$formID));
			}
		}
	 $this->patient_info($id);
	 if($formID!=null){
			$PatientVentilatorConsent = $this->PatientVentilatorConsent->read(null,$formID);
			$this->set("PatientVentilatorConsent",$PatientVentilatorConsent);
			if($print !=false){
				$this->layout = "print_with_header";
				$this->render('ventilator_consent_print');
			}else{
				$this->render('ventilator_consent_edit');
			}
	 }
	}
	public function ventilator_consent_list($id = null){
		$this->uses = array('Person','Consultant','User','Patient','Ward','Room','Bed','Corporate','InsuranceCompany','PatientVentilatorConsent');
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Initial' =>array( 'foreignKey'=>'initial_id'),
						'Consultant' =>array('foreignKey'=>'consultant_treatment')
				),
				'hasMany'=>array(
						'PatientVentilatorConsent' =>array( 'foreignKey'=>'patient_id')
				)
		));
		$this->patient_info($id);
	}


	/* Tracheostomy Consent form*/

	public function tracheostomy_consent($id = null,$formID = null,$print = false){
		App::import('Vendor', 'signature_to_image');
		$this->uses = array('Person','Consultant','User','Patient','Ward','Room','Bed','Corporate','InsuranceCompany','TracheostomyConsent');
		
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Initial' =>array( 'foreignKey'=>'initial_id'),
						'Consultant' =>array('foreignKey'=>'consultant_treatment')
				),
				'hasMany'=>array(
						'TracheostomyConsent' =>array( 'foreignKey'=>'patient_id')
				)
		));
		if($this->request->is('post') || $this->request->is('put')){
			$this->request->data['TracheostomyConsent']['date1'] =$this->DateFormat->formatDate2STD($this->request->data['TracheostomyConsent']['date1'],Configure::read('date_format'));
			$this->request->data['TracheostomyConsent']['date2'] =$this->DateFormat->formatDate2STD($this->request->data['TracheostomyConsent']['date2'],Configure::read('date_format'));
			if($formID == null){
				$this->request->data['TracheostomyConsent']['patient_id'] = $id;
				$this->request->data['TracheostomyConsent']['created_time'] = date('Y-m-d h:i:s');
				$this->request->data['TracheostomyConsent']['created_by'] = $this->Session->read('userid');
			}
			if($formID != null){
				$this->PatientVentilatorConsent->id =$formID;
				$this->request->data['TracheostomyConsent']['id'] = $formID;
				$this->request->data['TracheostomyConsent']['updated_time'] = date('Y-m-d h:i:s');
				$this->request->data['TracheostomyConsent']['updated_by'] = $this->Session->read('userid');
			}
			if(!empty($this->request->data["TracheostomyConsent"]["patient_output"])) {
				$signImage = sigJsonToImage($this->request->data["TracheostomyConsent"]["patient_output"],array('imageSize'=>array(320, 150)));
				$signpadfile = date('U').'.png';
				imagepng($signImage, WWW_ROOT.'signpad'.DS.$signpadfile);
				$this->request->data["TracheostomyConsent"]["patient_sign"] = $signpadfile;
			}
			if(!empty($this->request->data["TracheostomyConsent"]["witness_output"])) {
				$signImage = sigJsonToImage($this->request->data["TracheostomyConsent"]["witness_output"],array('imageSize'=>array(320, 150)));
				$signpadfile = date('U').'.png';
				imagepng($signImage, WWW_ROOT.'signpad'.DS.$signpadfile);
				$this->request->data["TracheostomyConsent"]["witness_sign"] = $signpadfile;
			}
			if(!empty($this->request->data["TracheostomyConsent"]["doctor_output"])) {
				$signImage = sigJsonToImage($this->request->data["TracheostomyConsent"]["doctor_output"],array('imageSize'=>array(320, 150)));
				$signpadfile = date('U').'.png';
				imagepng($signImage, WWW_ROOT.'signpad'.DS.$signpadfile);
				$this->request->data["TracheostomyConsent"]["doctor_sign"] = $signpadfile;
			}
			if(!empty($this->request->data["TracheostomyConsent"]["signature_output"])) {
				$signImage = sigJsonToImage($this->request->data["TracheostomyConsent"]["signature_output"],array('imageSize'=>array(320, 150)));
				$signpadfile = date('U').'.png';
				imagepng($signImage, WWW_ROOT.'signpad'.DS.$signpadfile);
				$this->request->data["TracheostomyConsent"]["signature"] = $signpadfile;
			}

			if($this->TracheostomyConsent->save($this->request->data)){
				$this->Session->setFlash(__('Details saved!'),'default',array('class'=>'message'));
				$this->redirect(array('controller'=>'nursings','action'=>'tracheostomy_consent_list',$id));
			}else{
				$this->Session->setFlash(__('Details could not be saved!'),'default',array('class'=>'error'));
				$this->redirect(array('controller'=>'nursings','action'=>'tracheostomy_consent',$id,$formID));
			}
		}
	 $this->patient_info($id);
	 if($formID!=null){
			$TracheostomyConsent = $this->TracheostomyConsent->read(null,$formID);
			$this->set("TracheostomyConsent",$TracheostomyConsent);
			if($print !=false){
				$this->layout = "print_with_header";
				$this->render('tracheostomy_consent_print');
			}else{
				$this->render('tracheostomy_consent_edit');
			}
	 }
	}
	
	public function tracheostomy_consent_list($id = null){
		$this->uses = array('Patient','TracheostomyConsent');

		$patientList = $this->TracheostomyConsent->find('all',array('fields'=>array('TracheostomyConsent.created_time','TracheostomyConsent.id','TracheostomyConsent.patient_id'),'conditions'=>array('patient_id'=>$id)));
		$this->patient_info($id);
		$this->set('patient_id',$id);
		//	$this->set('moveBack',$this->referer());
		$this->set('patientList',$patientList);
	}

	public function notes_list($patient_id=null) {
		$this->loadModel("Note");
		//$this->layout = 'ajax';
		$this->Note->bindModel(array('belongsTo' => array(
				'Patient' =>array('foreignKey'=>'patient_id'),
				'User' =>array('foreignKey'=>'sb_registrar'),
				'Doctor' =>array('foreignKey'=>'sb_consultant'),
		)),false);
			
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array('Note.id' => 'desc'),
				'fields'=> array('Note.id', 'Note.note', 'Note.note_type', 'Note.created_by', 'Note.note_date', 'Note.create_time','CONCAT(User.first_name, " ", User.last_name) as doctor_name','CONCAT(Doctor.first_name, " ", Doctor.last_name) as registrar'),
				'conditions'=>array('Note.patient_id'=>$patient_id,'Note.note_type !='=>'ward')
		);
		//$this->set('data',$this->paginate('PatientNote'));
		$this->set('patientid',$patient_id);
		$this->set('datapost',$this->paginate('Note'));
	}
	

	public function prescription_list($patient_id) {

		$this->uses = array('NewCropPrescription','Patient','Person');
		if (empty($patient_id)) {
			echo "Invalid Note! Please Try Again."; exit;
		} else {
			$patient_uid = $this->Patient->read('patient_id',$patient_id);
				
				
			//$newcrop_data = $this->NewCropPrescription->find('all',array('conditions'=>array('patient_id'=>$patient_uid['Patient']['patient_id'],'archive'=>'N','is_reconcile'=>'0'),
			//		'group'=>'NewCropPrescription.description'));
			$newcrop_data = $this->NewCropPrescription->query("SELECT `NewCropPrescription`.`id`,`NewCropPrescription`.`route`,`NewCropPrescription`.`frequency`,
				 `NewCropPrescription`.`frequency`,`NewCropPrescription`.`is_discharge_medication`,`NewCropPrescription`.`description`, `NewCropPrescription`.`patient_uniqueid`,
					`NewCropPrescription`.`dose` ,`NewCropPrescription`.`is_ccda` ,`NewCropPrescription`.`archive`,`NewCropPrescription`.`date_of_prescription` FROM
					`new_crop_prescription` AS `NewCropPrescription` INNER JOIN(SELECT MAX(date_of_prescription) as dateofpr from new_crop_prescription
				 WHERE `patient_uniqueid` = $patient_id
					AND ( `new_crop_prescription`.`is_discharge_medication` IN (0,2) AND `new_crop_prescription`.`archive` IN ('N')  OR `new_crop_prescription`.`is_ccda` IN (1))
				 group by description) newcrp1 on NewCropPrescription.date_of_prescription=newcrp1.dateofpr
				 WHERE `patient_uniqueid` = $patient_id AND NewCropPrescription.`archive` IN ('N') AND NewCropPrescription.`is_reconcile` IN ('0') group by `NewCropPrescription`.`description`");
				
		}

		if(isset($this->request->data['Presc'])){
			$patientInfo = explode("#",$this->request->data['Presc']['patientInfo']);

			$patientMedicat = explode("^~~^",$this->request->data['Presc']['patientMedicat']);

			$cnt=0;
			for($i=1;$i<=count($patientMedicat);$i++){

				$medicate[$cnt][] = $patientMedicat[$i-1];
				if($i%4==0){
					$cnt++;
				}

			}unset($medicate[$cnt]);
				
			$this->Patient->unBindModel(array(
					'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
			$this->Patient->bindModel(array(
					'belongsTo' => array(
							'Person'=>array('foreignKey'=>'person_id',
							))
			));
			//------dont change the order of fields in field list
			$check = $this->Patient->find('first',array('fields'=>array('Patient.patient_id','Patient.lookup_name','Person.dob'),'conditions'=>array('Patient.id'=>$patient_id)));
			$check['Person']['dob'] = $this->DateFormat->formatDate2Local($check['Person']['dob'],Configure::read('date_format'),false);
			echo json_encode(array('patientInfo' =>$patientInfo,'patientMedicat'=>$medicate,'patientdb'=>$check));
			exit;
		}

		$this->set(array('medicines'=>$newcrop_data,'patientid'=>$patient_id));


	}

	function medication_check($patient_id=null,$suggestedId=null,$note_id=null,$med_no=null){

		$this->uses = array('Patient','Note','SuggestedDrug','PharmacyItem');

		if(isset($this->request->data['Presc'])){
			$patientInfo = explode("\n",$this->request->data['Presc'][patientInfo]);
			$patientMedicat = explode("\n",$this->request->data['Presc'][patientMedicat]);
			$this->Patient->unBindModel(array(
					'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));

			$check = $this->Patient->find('first',array('fields'=>array('id'),'conditions'=>array('patient_id'=>trim($patientInfo[0]))));

			/*$this->Note->bindModel(array('hasMany' => array(
				'SuggestedDrug' =>array('foreignKey'=>'note_id','fields'=>array('id')))),false);
			*/
			$drug_id = $this->PharmacyItem->find('all',array('fields'=>array('id'),'conditions'=>array('')));
			$this->SuggestedDrug->find('all',array('fields'=>array('note_id'),'conditions'=>array('')));

			exit;
		}

		$this->set(compact('patient_id','note_id','suggestedId'));

	}


	public function prescription_record(){

		$this->autoRender = false;
		$this->uses = array('PrescriptionRecord');
		$this->PrescriptionRecord->insertPrescriptionRecord($this->request->data['Presc']);
		exit;
	}


	public function medication_record($patient_id=null){

		$this->uses = array('User','PrescriptionRecord','Patient');
		$this->User->unbindModel(
				array('belongsTo' => array('City','State','Country','Initial')));
		$users = $this->User->find("all",array("conditions"=>
				array("(User.is_deleted = '0' and User.location_id = '".$this->Session->read('locationid')."') and (Role.name !='superadmin' and
						Role.name !='admin')")
				,"fields"=>array('User.id','User.first_name','User.last_name','Role.id','Role.name')
				,"group"=>"User.id"));
		if(!empty($this->request->data)){
			$this->Patient->unBindModel(array(
					'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
			$patient_uid = $this->Patient->find('first',array('fields'=>array('patient_id'),'conditions'=>array('Patient.id'=>$patient_id)));
			$username = $this->User->find('first',array('fields'=>array('username','first_name','last_name'),'conditions'=>array('User.id'=>$this->request->data['Nursing']['user'])));
			$this->request->data['Nursing']['search_date'] = $this->DateFormat->formatDate2STD($this->request->data['Nursing']['search_date'],Configure::read('date_format'));
			$reportData = $this->PrescriptionRecord->find('all',array('conditions'=>array('patient_uid'=>$patient_uid['Patient']['patient_id'],'create_time LIKE'=>substr($this->request->data['Nursing']['search_date'],0,10)."%",'administer_by LIKE'=>$username['User']['username']."%")));
			foreach($reportData as $report){
					
				$patientMedicat[] = explode("^~~^",$report['PrescriptionRecord']['medication']);

			}
			$this->set(compact('patientMedicat','username'));

		}unset($this->request->data);
		$this->set(compact('patient_id','users','reportData'));


	}


	public function ventilator_order(){

	}

	/**
	 * VAP monitor
	 * Gauarav Chauriya
	 */

	// VAP monitor
	public function ventilator_doctor_list($patientId = null){
		$this->uses = array('Person','Consultant','User','Patient','Ward','Room','Bed','Corporate','InsuranceCompany','VentilatorCheckList');
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Initial' =>array( 'foreignKey'=>'initial_id'),
						'Consultant' =>array('foreignKey'=>'consultant_treatment')
				),
				'hasMany'=>array(
						'VentilatorCheckList' =>array( 'foreignKey'=>'patient_id',
								'conditions'=>array('VentilatorCheckList.is_deleted'=>'0'))
				)
		));
		$this->patient_info($patientId);

	}

	public function delete_doctors_form($patient_id,$id){
		$this->uses = array('VentilatorCheckList');
		if(!$id){
			$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));

		}
		if($this->VentilatorCheckList->save(array('id'=>$id,'is_deleted'=>'1'))){
			$this->Session->setFlash(__('Record deleted successfully'),'default',array('class'=>'message'));

		}else{
			$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));

		}
		$this->redirect($this->referer());
	}
	
	public function ventilator_doctors_form($patient_id = null,$id=null){
		$this->uses = array('VentilatorCheckList','Patient','Consultant','User');
		if(!empty($this->request->data['VentilatorCheckList'])){
			$this->VentilatorCheckList->insertCheckList($this->request->data);
			$this->Session->setFlash(__('Records Added Sucessfully!'),'default',array('class'=>'message'));
			//$this->redirect($this->referer());
			$this->redirect(array("action" => "ventilator_doctor_list",$patient_id));
		}
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Initial' =>array( 'foreignKey'=>'initial_id'),
						'Consultant' =>array('foreignKey'=>'consultant_treatment')
				),
		));
		$this->patient_info($patient_id);
		if(!empty($id)){
			$list_data=$this->VentilatorCheckList->find('all',array('conditions'=>array('id'=>$id,'patient_id'=>$patient_id)));
			$list_data[0]['VentilatorCheckList']['ventilator_date'] =  $this->DateFormat->formatDate2Local($list_data[0]['VentilatorCheckList']['ventilator_date'],Configure::read('date_format_us'));
				
			$list_data[0]['VentilatorCheckList']['sedation'] = explode(',',$list_data[0]['VentilatorCheckList']['sedation']);
				
			$list_data[0]['VentilatorCheckList']['analgesia'] = explode(',',$list_data[0]['VentilatorCheckList']['analgesia']);
			$list_data[0]['VentilatorCheckList']['dvt_prophaxis'] = explode(',',$list_data[0]['VentilatorCheckList']['dvt_prophaxis']);
			
			$list_data[0]['VentilatorCheckList']['ventSettingAry'] = explode('-',$list_data[0]['VentilatorCheckList']['vent_setting']);
			$list_data[0]['VentilatorCheckList']['vent_setting'] = $list_data[0]['VentilatorCheckList']['ventSettingAry']['0'];
			$list_data[0]['VentilatorCheckList']['vent_setting_period'] = $list_data[0]['VentilatorCheckList']['ventSettingAry']['1'];
			
			$list_data[0]['VentilatorCheckList']['ventMgtAry'] = explode('-',$list_data[0]['VentilatorCheckList']['vent_management']);
			$list_data[0]['VentilatorCheckList']['vent_management'] = $list_data[0]['VentilatorCheckList']['ventMgtAry']['0'];
			$list_data[0]['VentilatorCheckList']['vent_management_period'] = $list_data[0]['VentilatorCheckList']['ventMgtAry']['1'];
			
			$list_data[0]['VentilatorCheckList']['ventProphyAry'] = explode('-',$list_data[0]['VentilatorCheckList']['vte_prophylaxis']);
			$list_data[0]['VentilatorCheckList']['vte_prophylaxis'] = $list_data[0]['VentilatorCheckList']['ventProphyAry']['0'];
			$list_data[0]['VentilatorCheckList']['vte_prophylaxis_period'] = $list_data[0]['VentilatorCheckList']['ventProphyAry']['1'];
			
			$list_data[0]['VentilatorCheckList']['ventProphAry'] = explode('-',$list_data[0]['VentilatorCheckList']['gi_proph']);
			$list_data[0]['VentilatorCheckList']['gi_proph'] = $list_data[0]['VentilatorCheckList']['ventProphAry']['0'];
			$list_data[0]['VentilatorCheckList']['gi_proph_period'] = $list_data[0]['VentilatorCheckList']['ventProphAry']['1'];
			
			$list_data[0]['VentilatorCheckList']['ventOralAry'] = explode('-',$list_data[0]['VentilatorCheckList']['oral_care']);
			$list_data[0]['VentilatorCheckList']['oral_care'] = $list_data[0]['VentilatorCheckList']['ventOralAry']['0'];
			$list_data[0]['VentilatorCheckList']['oral_care_period'] = $list_data[0]['VentilatorCheckList']['ventOralAry']['1'];
			
			$list_data[0]['VentilatorCheckList']['ventHobAry'] = explode('-',$list_data[0]['VentilatorCheckList']['hob']);
			$list_data[0]['VentilatorCheckList']['hob'] = $list_data[0]['VentilatorCheckList']['ventHobAry']['0'];
			$list_data[0]['VentilatorCheckList']['hob_period'] = $list_data[0]['VentilatorCheckList']['ventHobAry']['1'];
			
			$list_data[0]['VentilatorCheckList']['pud_prophaxis'] = explode(',',$list_data[0]['VentilatorCheckList']['pud_prophaxis']);
			if($list_data[0]['VentilatorCheckList']['pud_prophaxis'][0] == 'Zantac 50 mg IV q 8 hrs'){
				$list_data[0]['VentilatorCheckList']['prophaxis_arr'][0] = 'Zantac 50 mg IV q 8 hrs';
				unset($list_data[0]['VentilatorCheckList']['pud_prophaxis'][0]);
				$list_data[0]['VentilatorCheckList']['prophaxis_arr'][1] = implode(',',$list_data[0]['VentilatorCheckList']['pud_prophaxis']);
				$list_data[0]['VentilatorCheckList']['pud_prophaxis'] = $list_data[0]['VentilatorCheckList']['prophaxis_arr'];

			}else{
				unset($list_data[0]['VentilatorCheckList']['pud_prophaxis'][0]);
				$list_data[0]['VentilatorCheckList']['prophaxis_arr'][1] = implode(',',$list_data[0]['VentilatorCheckList']['pud_prophaxis']);
				$list_data[0]['VentilatorCheckList']['pud_prophaxis'] = $list_data[0]['VentilatorCheckList']['prophaxis_arr'];
			}
			$this->data = $list_data[0];
		}
		$this->set('doctors',$this->User->getDoctorsByLocation($this->Session->read('locationid')));
		$this->set(array('id'=>$patient_id));
	}

	public function ventilator_nurse_list($id = null){
		$this->uses = array('Person','Consultant','User','Patient','Ward','Room','Bed','Corporate','InsuranceCompany','VentilatorNurseCheckList','VentilatorCheckList');
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Initial' =>array( 'foreignKey'=>'initial_id'),
						'Consultant' =>array('foreignKey'=>'consultant_treatment')
				),
				'hasMany'=>array(
						'VentilatorNurseCheckList' =>array( 'foreignKey'=>'patient_id',
								'conditions'=>array('VentilatorNurseCheckList.is_deleted'=>'0')),
						'VentilatorCheckList' =>array( 'foreignKey'=>'patient_id',
								'conditions'=>array('VentilatorCheckList.is_deleted'=>'0'))

				)
		));
		$this->patient_info($id);

	}

	public function delete_nurse_check_list($patient_id,$id){
		$this->uses = array('VentilatorNurseCheckList');
		if(!$id){
			$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));

		}
		if($this->VentilatorNurseCheckList->save(array('id'=>$id,'is_deleted'=>'1'))){
			$this->Session->setFlash(__('Record deleted successfully'),'default',array('class'=>'message'));

		}else{
			$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));

		}
		$this->redirect($this->referer());
	}

	public function ventilator_nurse_checklist($patient_id = null,$id=null,$ventChkid=null){
		$this->uses = array('VentilatorNurseCheckList','VentilatorCheckList','Patient','Consultant','User');
		if(!empty($this->request->data['VentilatorNurseCheckList'])){
			$this->VentilatorNurseCheckList->insertCheckList($this->request->data);
			$this->Session->setFlash(__('Records Added Sucessfully!'),'default',array('class'=>'message'));
			$this->redirect(array('controller'=>'nursings','action'=>'ventilator_nurse_list',$this->request->data['VentilatorNurseCheckList']['patient_id']));
		}
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Initial' =>array( 'foreignKey'=>'initial_id'),
						'Consultant' =>array('foreignKey'=>'consultant_treatment')
				),
		));
		$this->patient_info($patient_id);
		$list_data = $this->VentilatorCheckList->retrieveCheckList($patient_id,$id,$ventChkid);
		$this->data = $this->VentilatorNurseCheckList->find('first',array('conditions'=>array('id'=>$id,'is_deleted' => 0)));


		$this->set(array('list_data'=>$list_data));

	}

	public function quality_monitor(){
		$this->uses = array('VentilatorCheckList','Patient');

		$this->VentilatorCheckList->bindModel(array(
				'belongsTo' => array(
						'VentilatorNurseCheckList'=>array('foreignKey'=>false,
								'conditions'=>array('VentilatorCheckList.id = VentilatorNurseCheckList.ventilator_check_list_id'),
								//'group'=>array('VentilatorNurseCheckList.patient_id'),
						),
						'Patient'=>array('foreignKey'=>'patient_id'),
						'Ward' =>array('foreignKey'=>false,
								'conditions'=>array('Ward.id = Patient.ward_id')),
						'Bed' =>array('foreignKey'=>false,
								'conditions'=>array('Patient.bed_id = Bed.id')),
						'Room' =>array('foreignKey'=>false,
								'conditions'=>array('Patient.room_id = Room.id')),
				),
		));
		$patient_details = $this->VentilatorCheckList->find('all',array('fields'=>array('VentilatorCheckList.vent_priority','VentilatorCheckList.vent_setting_priority',
				'VentilatorCheckList.vte_priority','VentilatorCheckList.gi_proph_priority','VentilatorCheckList.hob_priority','VentilatorCheckList.oral_care_priority',
				'VentilatorCheckList.ventilator_date','VentilatorNurseCheckList.id','VentilatorNurseCheckList.patient_id','VentilatorNurseCheckList.ventilator_management',
				'VentilatorNurseCheckList.ventilator_setting','VentilatorNurseCheckList.dvt_prophaxis','VentilatorNurseCheckList.pud_prophaxis',
				'VentilatorNurseCheckList.activity','VentilatorNurseCheckList.oral_care_order_set',
				'Patient.id','Patient.patient_id','Patient.form_received_on','Ward.name','Bed.bedno','Room.bed_prefix'),
				'conditions'=>array('VentilatorCheckList.is_deleted'=> 0,'VentilatorNurseCheckList.is_deleted'=> 0,'Patient.doctor_id'=>$this->Session->read('userid'),
						'VentilatorCheckList.location_id'=> $this->Session->read('locationid'),'VentilatorNurseCheckList.location_id'=> $this->Session->read('locationid')),
				'group'=>'VentilatorCheckList.patient_id',
				'order'=>array('VentilatorNurseCheckList.id DESC')));
		$i=0;
		foreach($patient_details as $pati_reg){
			$diff = $this->DateFormat->dateDiff($pati_reg['Patient']['form_received_on'],date('Y-m-d H:i:s'));
			$ventdiff = $this->DateFormat->dateDiff($pati_reg['VentilatorCheckList']['ventilator_date'],date('Y-m-d H:i:s'));
			$patient_details[$i]['Patient']['total_days'] = $diff->days;
			if($ventdiff->days == 0){
				$patient_details[$i]['VentilatorCheckList']['total_days'] = $ventdiff->h."h";
			}else{
				$patient_details[$i]['VentilatorCheckList']['total_days'] = $ventdiff->days."d";
			}
			$diff = '';
			$i++;
		}
		//echo "<pre>"; print_r($diff1);
		//echo "<pre>"; print_r($patient_details);
		$this->set(array('patient_details'=>$patient_details));

	}
	//------EOF's VAP monitor----Gaurav Chauriya

	//Main screen for intractive view
	public function interactive_view($patient_id=null,$flags=null){
		
		ob_end_clean();
		ob_start("ob_gzhandler");
		$this->layout = 'advance' ;
		$this->uses = array('ReviewCategory','ReviewSubCategory','ReviewSubCategoriesOption');
		$this->ReviewCategory->bindModel(array(
				'hasMany'=>array(
							'ReviewSubCategory'=>array('foreignKey'=>'review_category_id'), )));
		$data = $this->ReviewCategory->find('all');
		
		$this->patient_info($patient_id); 
		
		$this->set(array('categoryData'=>$data,'patient_id'=>$patient_id,'flags'=>$flags));
		
	}
	
	//Add categories for interactive view
	public function add_categories(){
		//$this->autoRender = false ;
		$this->layout = 'ajax' ;
		$this->uses = array('ReviewCategory','ReviewSubCategory');
		$mainCategory = $this->ReviewCategory->find('list',array('fields'=>array('id','name')));
		$this->ReviewCategory->bindModel(array(
				'hasMany'=>array(
						'ReviewSubCategory'=>array('foreignKey'=>'review_category_id'), )));
		$data = $this->ReviewCategory->find('all');
		$this->set(array('mainCategories'=>$mainCategory,'categoryData'=>$data));
	}
	
	//save category for nursing obervation 
	public function category_save(){
		//$this->layout  = 'ajax' ;
		$this->autoRender = false ;
		$this->uses = array('ReviewCategory','ReviewSubCategory','ReviewSubCategoriesOption');
		 
		if(!empty($this->request->data)){
			if($this->request->data['nursings']['CategoryType']=='main' && !empty($this->request->data['nursings']['name'])){
				$result = $this->ReviewCategory->save(array('name'=>$this->request->data['nursings']['name'] ));
				
			}else if($this->request->data['nursings']['CategoryType']=='sub' && !empty($this->request->data['nursings']['name'])){
				$result = $this->ReviewSubCategory->save(array('name'=>$this->request->data['nursings']['name'],
						'review_category_id'=>$this->request->data['nursings']['review_category_id'],'parameter'=>$this->request->data['parameter']));
				
			}else if($this->request->data['nursings']['CategoryType']=='option' && !empty($this->request->data['nursings']['name'])){
				$values = (!empty($this->request->data['nursings']['values']))?serialize($this->request->data['nursings']['values']):"" ;
				$result = $this->ReviewSubCategoriesOption->save(array(
						'name'=>$this->request->data['nursings']['name'],'values'=>$values,
						'review_sub_categories_id'=>$this->request->data['nursings']['review_subcategory_id']));				 
			}			
			if($result){
				$this->Session->setFlash(__('Record added successfully'),'default',array('class'=>'message'));
			}else{
				$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
			}
			$this->redirect('add_categories') ; //render previous page with latest data
		}		
	}
	
	
	//ajax call for categories
	function getCategories($id){
		$this->autoRender = false ;
		$this->uses = array('ReviewCategory','ReviewSubCategory','ReviewSubCategoriesOption');
		if($id){
			return json_encode($this->ReviewSubCategory->find('list',array('conditions'=>array('ReviewSubCategory.review_category_id'=>$id))));
		}else{
			return ;
		}
	}
	
	/** @author Node-11
	 *
	 * @param int $patient_id
	 * @param int $id sub category id
	 * return HTML
	 **/
	//data display in excel format
	function getExcelLayout($patient_id,$id,$backcharting=null,$backdate=null){
		 $this->autoRender = false ;
		
	 	ob_end_clean();
	 	ob_start("ob_gzhandler");
		
		$this->layout = 'ajax';		 
		//str length
		
		$this->uses = array('ReviewCategory','ReviewPatientDetail','ReviewSubCategoriesOption','ReviewSubCategory','ReviewCategoryCustomization','ReviewDateTimeSlot');  
		$this->ReviewSubCategory->bindModel(array(
				'hasMany' => array(
						'ReviewSubCategoriesOption' =>array('foreignKey'=>'review_sub_categories_id') 
				)));
		$customiztionData = $this->ReviewCategoryCustomization->find('first',array('conditions'=>array('patient_id'=>$patient_id)));
		if(!$id){
			//retrive first record and set to default ID
			$res = $this->ReviewCategory->find('first',array('fields'=>'id'));
			$id  =   $res['ReviewCategory']['id'];
		} 
		 
		$this->ReviewPatientDetail->bindModel(array(
				'belongsTo' => array(
						'ReviewSubCategory' =>array('foreignKey'=>'review_sub_categories_id','type'=>'inner'),
		
				)));
		
		//entered data
		
			
			
		if(isset($this->request->data['date']) && !empty($this->request->data['date']) || ($backcharting=='yes' && !empty($backdate))){ //retrive data for selected date
			$filterDate = !empty($backdate)?$backdate:$this->request->data['date'];
			$reviewData = $this->ReviewPatientDetail->find('all',array('conditions'=>array( 'ReviewPatientDetail.patient_id'=>$patient_id,'ReviewSubCategory.review_category_id'=>$id,
					'OR'=>array('date'=>$filterDate) ,'ReviewPatientDetail.edited_on IS NULL' ),'order'=>array('ReviewPatientDetail.id DESC')));
			if(!empty($filterDate)){
				$this->set('selectedDate',$filterDate);
			}else if(!empty($this->request->data['date'])){
				$this->set('selectedDate',$this->request->data['date']);
			}else{
				$this->set('selectedDate',date('Y-m-d'));
			}
		}else{
			$reviewData = $this->ReviewPatientDetail->find('all',array('conditions'=>array( 'ReviewPatientDetail.patient_id'=>$patient_id,'ReviewSubCategory.review_category_id'=>$id,
					'OR'=>array('date'=>array(date('Y-m-d'))),'ReviewPatientDetail.edited_on IS NULL' ),'order'=>array('ReviewPatientDetail.id DESC'))); 
			$this->set('selectedDate',date('Y-m-d'));
		} 
		
		$subCatOptions = $this->ReviewSubCategory->find('all',array('conditions'=>array('ReviewSubCategory.review_category_id'=>$id),'order'=>array('ReviewSubCategory.id')));	 
	 
		$backdate      = ($backdate)?$backdate:$this->request->data['date']  ;
		$backcharting  = ($backcharting)?$backcharting:$this->request->data['backcharting']  ;
		
		//set current date if empty
		$backdate      = ($backdate)?$backdate:date('Y-m-d')  ;
		//time slot for patient if any
		$customTimeSlotResult = $this->ReviewDateTimeSlot->find('list',array('fields'=>array('date','time_slot'),'conditions'=>array('patient_id'=>$patient_id,'date'=>$backdate))) ;
		$this->set(array('subCatOptions'=>$subCatOptions,"reviewData"=>$reviewData,'subCategoryID'=>$id,'patient_id'=>$patient_id,'slot'=>$this->request->data['slot'],
				'customiztionData'=>unserialize($customiztionData['ReviewCategoryCustomization']['category_options']),'customTimeSlotResult'=>$customTimeSlotResult));
		
		 
		//render diffreent HTML build for
		if(isset($this->request->data['slot']) && (!empty($this->request->data['slot'])|| (isset($this->request->data['slot']) && $this->request->data['slot']== 0))){ 
			 			
			$timeArray['patient_id'] 	= $patient_id;
			if( !empty($backdate) && $backcharting=='yes'){
				$timeArray['date'] 			= $backdate;
				$timeArray['hours']			= date('H:i') ;
			}else{
				$timeArray['date'] 			= date('Y-m-d');
				$timeArray['hours']			= date('H:i') ;
			}
			$timeArray['time_slot'] 	= $this->request->data['slot'];
		
			$this->ReviewDateTimeSlot->save($timeArray);
			
			//time slot for patient if any
			$customTimeSlotResult = $this->ReviewDateTimeSlot->find('list',array('fields'=>array('date','time_slot'),
					'conditions'=>array('patient_id'=>$patient_id,'date'=>$backdate))) ;
			$this->set(array('customTimeSlotResult'=>$customTimeSlotResult));
			 
			if($this->request->data['slot'] >= 60){
				$this->render('getExcelLayout');
			}elseif($this->request->data['slot'] < 60 && $this->request->data['slot'] > 0){ //below 1 hours render html for current day only
				$this->render('getCustomizedExcelLayout');
			}else{
				$this->render('getCustomizedActualExcelLayout');
			}
		}else if(!empty($customTimeSlotResult)){ //below 1 hours render html for current day only
			if($customTimeSlotResult[$backdate] >= 60){
				$this->render('getExcelLayout');
			}else if($customTimeSlotResult[$backdate] < 60 && $customTimeSlotResult[$backdate] > 0){
				$this->render('getCustomizedExcelLayout');
			}else{
				$this->render('getCustomizedActualExcelLayout'); 
			}
		}else{
			 $this->render('getExcelLayout');
		} 
	}
	
	//data display in excel format
	function getExcelLayoutForIO($patient_id,$id,$backcharting=null,$backdate=null){
		//$this->autoRender = false ;
		ob_end_clean();
		ob_start("ob_gzhandler");
	 	//$this->layout = 'ajax';		 
		$this->uses = array('ReviewPatientDetail','ReviewSubCategoriesOption','ReviewSubCategory','ReviewCategoryCustomization','MedicationAdministeringRecord',''); 
		$this->ReviewSubCategory->bindModel(array(
				'hasMany' => array(
						'ReviewSubCategoriesOption' =>array('foreignKey'=>'review_sub_categories_id'),
		
				))); 
		
		$customiztionData = $this->ReviewCategoryCustomization->find('first',array('conditions'=>array('patient_id'=>$patient_id)));
		if($id){			
			$this->ReviewPatientDetail->bindModel(array(
					'belongsTo' => array(
							'ReviewSubCategory' =>array('foreignKey'=>'review_sub_categories_id','type'=>'inner'),
			
					)));
			//entered data
			if(isset($this->request->data['date']) && !empty($this->request->data['date']) || ($backcharting=='yes' && !empty($backdate))){ //retrive data for selected date
				$filterDate = !empty($backdate)?$backdate:$this->request->data['date'];
				$reviewData = $this->ReviewPatientDetail->find('all',array('conditions'=>array( 'ReviewPatientDetail.patient_id'=>$patient_id,'ReviewSubCategory.review_category_id'=>$id,
						'OR'=>array('date'=>array($filterDate)),'ReviewPatientDetail.edited_on IS NULL' ),'order'=>array('ReviewPatientDetail.id DESC')));
			}else{
				 
				$reviewData = $this->ReviewPatientDetail->find('all',array('conditions'=>array( 'ReviewPatientDetail.patient_id'=>$patient_id,'ReviewSubCategory.review_category_id'=>$id,
					'OR'=>array('date'=>array(date('Y-m-d'),date('Y-m-d',strtotime("-1 day")),date('Y-m-d',strtotime("+1 day")))),'ReviewPatientDetail.edited_on IS NULL')
						,'order'=>array('ReviewPatientDetail.id DESC'))); 
			}
			$subCatOptions = $this->ReviewSubCategory->find('all',array('conditions'=>array('ReviewSubCategory.review_category_id'=>$id),
					'order'=>array('ReviewSubCategory.id','ReviewSubCategory.parameter ASC')));	

			//retrive data from MAR
			 $this->MedicationAdministeringRecord->bindModel(array(
					'belongsTo'=>array('NewCropPrescription'=>array('foreignKey'=>'new_crop_prescription_id','conditions'=>array('NewCropPrescription.archive'=>'N')),
							'ReviewSubCategory'=>array('foreignKey'=>false,'conditions'=>array('ReviewSubCategory.id=NewCropPrescription.review_sub_category_id')))));
			   
			 $marContinuousData =$this->MedicationAdministeringRecord->find('all',array('fields'=>array('MedicationAdministeringRecord.inf_volume_hourly','MedicationAdministeringRecord.infused_time','MedicationAdministeringRecord.inf_time_unit','NewCropPrescription.drug_name',
			 		'NewCropPrescription.review_sub_category_id','performed_datetime','volume','NewCropPrescription.id','NewCropPrescription.strength')
			 		,'conditions'=>array('MedicationAdministeringRecord.is_deleted'=>0,'MedicationAdministeringRecord.is_signed'=>1,'MedicationAdministeringRecord.patient_id'=>$patient_id,'ReviewSubCategory.name LIKE "%continuous infusion%"'),'order'=>array('MedicationAdministeringRecord.performed_datetime')));
			 
			 
			 $this->MedicationAdministeringRecord->bindModel(array(
			 		'belongsTo'=>array('NewCropPrescription'=>array('foreignKey'=>'new_crop_prescription_id','conditions'=>array('NewCropPrescription.archive'=>'N')),
			 				'ReviewSubCategory'=>array('foreignKey'=>false,'conditions'=>array('ReviewSubCategory.id=NewCropPrescription.review_sub_category_id')))));
			 
			 $marMedicationData =$this->MedicationAdministeringRecord->find('all',array('fields'=>array('MedicationAdministeringRecord.inf_volume_hourly','MedicationAdministeringRecord.infused_time','MedicationAdministeringRecord.inf_time_unit','NewCropPrescription.drug_name',
			 		'NewCropPrescription.review_sub_category_id','performed_datetime','volume','NewCropPrescription.id','NewCropPrescription.strength')
			 		,'conditions'=>array('MedicationAdministeringRecord.is_deleted'=>0,'MedicationAdministeringRecord.is_signed'=>1,'MedicationAdministeringRecord.patient_id'=>$patient_id,'ReviewSubCategory.name LIKE "%medications%"'),'order'=>array('MedicationAdministeringRecord.performed_datetime')));

			 $this->MedicationAdministeringRecord->bindModel(array(
			 		'belongsTo'=>array('NewCropPrescription'=>array('foreignKey'=>'new_crop_prescription_id','conditions'=>array('NewCropPrescription.archive'=>'N')),
			 				'ReviewSubCategory'=>array('foreignKey'=>false,'conditions'=>array('ReviewSubCategory.id=NewCropPrescription.review_sub_category_id')))));

			 $marParenteralData =$this->MedicationAdministeringRecord->find('all',array('fields'=>array('MedicationAdministeringRecord.inf_volume_hourly','MedicationAdministeringRecord.infused_time','MedicationAdministeringRecord.inf_time_unit','NewCropPrescription.drug_name',
			 		'NewCropPrescription.review_sub_category_id','performed_datetime','volume','NewCropPrescription.id','NewCropPrescription.strength')
			 		,'conditions'=>array('MedicationAdministeringRecord.is_deleted'=>0,'MedicationAdministeringRecord.is_signed'=>1,'MedicationAdministeringRecord.patient_id'=>$patient_id,'ReviewSubCategory.name LIKE "%parenteral%"'),'order'=>array('MedicationAdministeringRecord.performed_datetime')));
			 $this->set(array('marContinuousData'=>$marContinuousData,'marMedicationData'=>$marMedicationData,'marParenteralData'=>$marParenteralData)) ;
			 			
		}/* else{		
			$this->ReviewPatientDetail->bindModel(array(
					'belongsTo' => array(
							'ReviewSubCategory' =>array('foreignKey'=>'review_sub_categories_id','type'=>'inner'),			
					)));
			//entered data
			$reviewData = $this->ReviewPatientDetail->find('all',array('conditions'=>array('ReviewPatientDetail.patient_id'=>$patient_id,
					'OR'=>array('date'=>array(date('Y-m-d'),date('Y-m-d',strtotime("-1 day")),date('Y-m-d',strtotime("+1 day"))))),'order'=>array('ReviewPatientDetail.id DESC')));
			 
			$subCatOptions = $this->ReviewSubCategory->find('all');
			 
		}  */
		 
		$this->set(array('subCatOptions'=>$subCatOptions,"reviewData"=>$reviewData,'subCategoryID'=>$id,'patient_id'=>$patient_id,
				'customiztionData'=>unserialize($customiztionData['ReviewCategoryCustomization']['category_options']))); 
		
		if(isset($this->request->data['date']) && !empty($this->request->data['date']) || ($backcharting=='yes' && !empty($backdate))){
			if(!empty($backdate)){
				$this->set('selectedDate',$backdate);
			}else{
				$this->set('selectedDate',$this->request->data['date']);
			} 
			$this->render("get_excel_layout_io_backcharting") ; // custom page for selected date
		}  
	}  
	
	//save review data
	function saveReviewData($patient_id,$argument){
		$this->autoRender = false ;
		$this->layout = 'ajax';
		$this->uses = array('ReviewPatientDetail'); 
		if(!empty($this->request->data['values'])){
			$postData = json_decode($this->request->data['values']);
			$backcharting = $this->request->data['backcharting'] ;
			$time = explode("_",$this->request->data['timeslot']) ; 
			//EOF deletion
			if($this->request->data['format']=='actual'){
				$actualTime =  substr($time[1],0,2).":".substr($time[1],2,2) ;
			}else{
				$actualTime = date('H:i');
			} 
			foreach($postData as $key => $dataObj){ 
				//check if value has show/hide text of conditional flag
				$value = strip_tags($dataObj->values) ;
				if(strpos("^",$value) > 0){
					$stripeedVal = explode('^',$dataObj->values);
					$stripeedVal = $stripeedVal[0];
				}else{
					$stripeedVal = $value ;
				}
				//$edited_on= $this->DateFormat->formatDate2STD(date('Y-m-d H:i:s'),Configure::read('date_format'));
				$edited_on = date('Y-m-d H:i:s') ;
				//update indi option				
				$this->ReviewPatientDetail->updateAll(array('edited_on'=>"'".$edited_on."'" ),
						array('is_deleted '=>0,'patient_id'=>$patient_id,'review_sub_categories_id'=>$dataObj->sub_id,'review_sub_categories_options_id'=>$dataObj->id,
								'date'=>date('Y-m-d',strtotime($time[0])),'hourSlot'=>$time[1])) ;
				//EOF update 
				if($stripeedVal != 'In Error' ) { //skip to update with error string 
					$dataArray[] = array(
							'review_sub_categories_options_id'=>$dataObj->id,
							'values'=>$stripeedVal,//remove all the html tags
							'date'=>date('Y-m-d',strtotime($time[0])),
							'hourSlot'=>$time[1],
							'actualTime'=>$actualTime,
							'patient_id'=>$patient_id,
							'review_sub_categories_id'=>$dataObj->sub_id,
							'is_edited'=>$this->request->data['modify'],
					);  
				}
			}
			
			$result = $this->ReviewPatientDetail->saveAll($dataArray);
			if($result){
				echo $this->ReviewPatientDetail->getLastInsertID(); 
			} 
			//$this->Session->setFlash(__('Record added successfully'),true,array('class'=>'message')); //displayed on view side
		}
		if($argument =='io'){		 
			$this->redirect(array('action'=>'getExcelLayoutForIO',$patient_id,$this->request->data['categoryid'],$backcharting,$time[0])) ;
		}else{			 	
			$this->redirect(array('action'=>'getExcelLayout',$patient_id,$this->request->data['categoryid'])) ;
		}
	}
	
	
	//Display customization of category for patients 
	function category_customization($patient_id=null,$category_id=null){
		$this->layout = 'ajax' ; 
		$this->uses = array('ReviewSubCategoriesOption','ReviewSubCategory','ReviewCategoryCustomization'); 
		$this->ReviewSubCategory->bindModel(array(
				'hasMany' => array(
						'ReviewSubCategoriesOption' =>array('foreignKey'=>'review_sub_categories_id'),
		
				)));		  
		/* if(!empty($category_id)){
			$condition['review_category_id']= $category_id ;
			$condition['name NOT'] = array('Continuous Infusion','Medications ');
		}else{
			$condition[1] = 1 ;
		}	 */

		$condition['name NOT'] = array('Continuous Infusion','Medications ');
		
		$data = $this->ReviewSubCategory->find('all',array('conditions'=>$condition));		
		$customiztionData = $this->ReviewCategoryCustomization->find('first',array('conditions'=>array('patient_id'=>$patient_id)));
		$this->set(array('data'=>$data,'patient_id'=>$patient_id,'customiztionData'=>unserialize($customiztionData['ReviewCategoryCustomization']['category_options'])));
	} 
	
	//save patientwise category display
	function save_customization($patient_id){
		 if($patient_id){
		 	$this->uses = array('ReviewCategoryCustomization');
		 	//delete record if any for same patient 
		 	$this->ReviewCategoryCustomization->deleteAll(array('patient_id'=>$patient_id));
		 	$result = $this->ReviewCategoryCustomization->save(array('patient_id'=>$patient_id,'category_options'=>serialize($this->request->data['nursings'])));
		 	if($result){
		 		$this->Session->setFlash(__('Record added successfully'),'default',array('class'=>'message'));
		 	}else{
		 		$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
		 	}
		 }
		 $this->redirect($this->referer());
	}
	
	
	function getChildrens(){
		$this->autoRender =  false ;
		$id = $this->request->data['root'] ;
		if($id){
			$this->uses = array('ReviewSubCategoriesOption');
			$result = $this->ReviewSubCategoriesOption->find('all',array('conditions'=>array('review_sub_categories_id'=>$id)));
			foreach($result as $key => $values){
				$valuesArray = unserialize($values['ReviewSubCategoriesOption']['values']) ;				 
				foreach($valuesArray as $child => $childVal){ 
					$children[]   = (object)array( "text"=> $childVal  ) ; 
				}
				$resetArray[] = (object)  array('text' =>$values['ReviewSubCategoriesOption']['name']."&nbsp; &nbsp; <span id='".$values['ReviewSubCategoriesOption']['id']."' class='remove-cat'>Remove</span>",
						"expanded"=>true,
						"classes"=> "important", 
						"collapsed"=> true,
						"unique"=> true,
						"children"=>$children
				  ); 
			} 
		} 
		 
		return json_encode($resetArray );
	}
	
	
	function delete_category_options($id){
		$this->autoRender = false ;
		$this->layout = 'ajax' ;
		if($id){
			$this->uses = array('ReviewSubCategoriesOption');
			if($this->ReviewSubCategoriesOption->delete($id)){
				echo "Record Deleted" ;
			}else{
				echo "Please try again" ;
			}
		}
	}
	
	function delete_sub_category($id){
		$this->autoRender = false ;
		$this->layout = 'ajax' ;
		if($id){
			$this->uses = array('ReviewSubCategory');
			if($this->ReviewSubCategory->delete($id)){
				echo "Record Deleted" ;
			}else{
				echo "Please try again" ;
			}
		}
	}
	
	//import cat,sub etc...through excel sheet 
	function import_iv_categories(){
	App::import('Vendor', 'reader');
		$this->set('title_for_layout', __('Iteractice View- Import Data', true));
		$this->uses = array('ReviewCategory');
		if ($this->request->is('post')) { 
			if($this->request->data['nursings']['import_file']['error'] !="0"){
				$this->Session->setFlash(__('Please Upload the file'), 'default', array('class' => 'error'));
				$this->redirect($this->referer());
			} 
			/* $data = new Spreadsheet_Excel_Reader();
			$data->setOutputEncoding('CP1251'); */
			ini_set('memory_limit',-1);
			set_time_limit(0);
			$newName  = strtotime("now")."_".$this->request->data['nursings']['import_file']['name'] ;
			$path = WWW_ROOT.'uploads'.DS.'import'.DS. $newName;
			//$is_uploaded= move_uploaded_file($this->request->data['nursings']['import_file']['name'],$path );
			 
			if(!empty($this->request->data['nursings']['import_file']['name'])){
				
				$showError = $this->ImageUpload->uploadFile($this->params,'import_file','uploads/import',$newName);
				if(!empty($showError)){
					pr($showError);
				}else{ 				
					/* $data = new Spreadsheet_Excel_Reader($path,false);
					$data->path= $path;
					chmod($data->path,777);
					$data->setOutputEncoding('CP1251'); */
					$is_uploaded = $this->ReviewCategory->importData($path); 
					 
				}
			}		 
			/* if($is_uploaded==true){
				unset($data);
				chmod($path,0777);
				unlink( $path );
				$this->Session->setFlash(__('Data imported sucessfully'), 'default', array('class' => 'message'));
				//$this->redirect($this->referer());
			}else{  */
				unset($data);
				chmod($path,0777);
				unlink( $path );
				$this->Session->setFlash(__('Data imported sucessfully'), 'default', array('class' => 'message'));
				$this->redirect($this->referer());
			//} 
		}  
	}
	
	//save context menu options
	function saveReviewAttribute(){
		$this->layout = 'ajax' ;
		$this->autoRender = false ;
		$id=$this->request->data['id'] ;
		if(!$id)  return false   ;
		$this->uses = array('ReviewPatientDetail');
		$field = $this->request->data['field'] ;
		if($field=='flag_comment'){ //update 2 fields
			$fieldArray = array(
								'id'=>$this->request->data['id'],
								'flag'=>1,
								'flag_comment'=>$this->request->data['fieldValue'],
								'flag_date'=>date('Y-m-d H:i:s')) ;
		}else{
			$actDate = $field."_date" ;
			$fieldArray = array(
							'id'=>$this->request->data['id'],
							$field=>$this->request->data['fieldValue'],
								$actDate=>date('Y-m-d H:i:s'));
		}
		
		 
		$this->ReviewPatientDetail->save($fieldArray);
		
	}
	
	//view result details 
	
	function view_result_details($patient_id=null,$option_id=null,$date=null,$hourslot=null){
		//if(!$id || !patient_id) return false ;
		
		$this->layout = 'ajax' ;
		$this->uses = array('ReviewPatientDetail');
		if(!is_numeric($option_id)){
			$this->ReviewPatientDetail->bindModel(array(
					'belongsTo' => array(
							'ReviewSubCategoriesOption' =>array('className'=>'NewCropPrescription','foreignKey'=>false,
									'conditions'=>array('ReviewSubCategoriesOption.id'=>str_replace('crop',"",$option_id))),
					)));
			$date = date('Y-m-d',strtotime($date));
			$data = $this->ReviewPatientDetail->find('all',array('fields'=>array('ReviewPatientDetail.*','ReviewSubCategoriesOption.drug_name as name'),
					'conditions'=>array('ReviewPatientDetail.patient_id'=>$patient_id,'review_sub_categories_options_id'=>$option_id,
					'ReviewPatientDetail.date'=>$date,'hourSlot'=>$hourslot),'order'=>array('ReviewPatientDetail.edited_on','ReviewPatientDetail.id DESC')));
		}else{
			$this->ReviewPatientDetail->bindModel(array(
					'belongsTo' => array(
							'ReviewSubCategoriesOption' =>array('foreignKey'=>'review_sub_categories_options_id','type'=>'inner'), 
					)));
			$date = date('Y-m-d',strtotime($date));
			$data = $this->ReviewPatientDetail->find('all',array('conditions'=>array('patient_id'=>$patient_id,'review_sub_categories_options_id'=>$option_id,
					'date'=>$date,'hourSlot'=>$hourslot),'order'=>array('ReviewPatientDetail.edited_on','ReviewPatientDetail.id DESC')));
		}
		$this->set('data',$data);
	} 
	
	
	//unchart result 
	function unchart_result($id=null){
		$this->layout = 'ajax' ;
		$this->uses = array('ReviewPatientDetail');
		if(!empty($this->request->data['Nursing']['id'])){
			//save unchart comment n reason
			$fieldArray = $this->request->data['Nursing'] ;
			$fieldArray['is_deleted'] = 1;
			$fieldArray['uncharted_on'] = date('Y-m-d H:i:s'); 
			$result = $this->ReviewPatientDetail->save($fieldArray); 
		}
		
		if(!empty($id)){ 
			$this->uses = array('ReviewPatientDetail'); 
			$this->ReviewPatientDetail->bindModel(array(
					'belongsTo' => array(
							'ReviewSubCategoriesOption' =>array('foreignKey'=>'review_sub_categories_options_id','type'=>'left'),
					)));
			$date = date('Y-m-d',strtotime($date));
			$data = $this->ReviewPatientDetail->find('first',array('conditions'=>array('ReviewPatientDetail.id'=>$id),'order'=>array('ReviewPatientDetail.edited_on')));
			$optionID  = $data['ReviewPatientDetail']['review_sub_categories_options_id'] ;
			if(!is_numeric($optionID)){
				$this->ReviewPatientDetail->bindModel(array(
						'belongsTo' => array(
								'ReviewSubCategoriesOption' =>array('className'=>'NewCropPrescription','foreignKey'=>false,
										'conditions'=>array('ReviewSubCategoriesOption.id'=>str_replace('crop',"",$optionID))),
						)));
				$date = date('Y-m-d',strtotime($date));
				$data = $this->ReviewPatientDetail->find('first',array('conditions'=>array('ReviewPatientDetail.id'=>$id),'order'=>array('ReviewPatientDetail.edited_on')));				
			}
			$this->set(array('data'=>$data,'id'=>$id));
		} 
		
	}
	
	/**
	 * Nurse Dashboard for viewing medication and vitals
	 * @author Gaurav Chauriya
	 */
	public function nurseDashboard(){
		$this->layout = 'advance';
		$this->set('title_for_layout', __('Nurse Dashboard', true));
		$this->uses = array('Patient');
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'conditions' => array('Patient.admission_type' => 'IPD','')
		);
		
		$data = $this->paginate('ObservationChart');
	}
	
	
	/** Mrunal
	 * to add prescription by nurse without price
	 *
	 */
	public function add_prescription($statusChange = null){
		
		$this->loadModel('Configuration');
		$this->loadModel('NewCropPrescription');
		
		$this->layout="advance";
		$this->uses=array('Patient','PharmacySalesBill','PharmacySalesBillDetail','NewCropPrescription','PharmacyItem');
		
		$this->Patient->bindModel(array(
				'belongsTo' => array( 
						'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
						//'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
						'NewCropPrescription' =>array('foreignKey' => false, 'conditions'=>array('NewCropPrescription.patient_uniqueid = Patient.id')),
						'User' =>array('foreignKey' => false, 'conditions'=>array('NewCropPrescription.created_by = User.id')), 
					)),false);
		
		if(isset($this->request->query['lookup_name']) && !empty($this->request->query['lookup_name'])){
			$name=explode('-',$this->request->query['lookup_name']);
		} 
		$pId = $this->request->query['admission_id']; 
		
		if(!empty($this->params->query)){ 
				$condition['Patient.lookup_name like'] ="%".$name[0]."%"; 
				$condition['Patient.admission_id like'] = "%".$pId."%"; 
				if($this->params->query['date']){
					$condition['NewCropPrescription.date_of_prescription LIKE'] = $this->DateFormat->formatDate2STD($this->params->query['date'],Configure::read('date_format'))."%";
					//$condition['NewCropPrescription.date_of_prescription <'] = date("Y-m-d")."%";
				}else{
					$condition['NewCropPrescription.date_of_prescription LIKE'] = date("Y-m-d")."%";
				}
		}else{
			$condition['NewCropPrescription.date_of_prescription LIKE'] = date("Y-m-d")."%";
		}
		$website_service_type = $this->Configuration->find('first',array('conditions'=>array('Configuration.name'=>'website'))); 
		$websiteConfig=unserialize($website_service_type['Configuration']['value']);
		
		$condition['Patient.admission_type'] ='IPD';
		$condition['Patient.is_deleted'] ='0';
		$condition['Patient.is_discharge'] = '0';
		$condition['NewCropPrescription.by_nurse'] = '1'; 
		$condition['NewCropPrescription.is_deleted'] = '0';
		$condition['NewCropPrescription.is_override'] = '0';
		
		$isPending = true;  
		$conditionArray =array();
		if($this->params->query['isCompleted'] == 1){
			$isPending = false;
			$conditionArray[] = 2;  
		}
		
		if($this->params->query['isPartial'] == '1'){
			$isPending = false ;
			$conditionArray[] = 1;
			//$condition = array('NewCropPrescription.quantity !=  NewCropPrescription.recieved_quantity');
		}
		
		if(empty($this->params->query)   || $this->params->query['isPending'] ==1){
			$conditionArray[] = 0;
		}
		
		if(empty($conditionArray)) $conditionArray = array(0,1,2);
	
		$this->paginate = array(	
				'limit' => Configure::read('number_of_rows'),
				'fields'=> array('admission_id,Patient.lookup_name,Patient.id,Patient.patient_id','NewCropPrescription.by_nurse','NewCropPrescription.batch_identifier',
						'NewCropPrescription.date_of_prescription','NewCropPrescription.patient_uniqueid','NewCropPrescription.quantity',
						'NewCropPrescription.recieved_quantity' ,'NewCropPrescription.status',
						'User.first_name','User.last_name','NewCropPrescription.status'),
				'conditions'=>array($condition),
				'order' => array('NewCropPrescription.date_of_prescription' => 'asc'),
				//'order' => "FIELD(NewCropPrescription.status, 2)",
				'group'=>array('NewCropPrescription.batch_identifier HAVING 
									COUNT(`NewCropPrescription`.`status`) = SUM(CASE WHEN `NewCropPrescription`.`status` IN ('.implode(',',$conditionArray).') THEN 1 ELSE 0 END)') 
						
		);
		
		$pateintdat = $this->paginate('Patient',null,array('fields'=>array('count(*) as count','NewCropPrescription.status')));
		$this->set('patienStatus',$patienStatus);   
		//******* change status for every nurse indent *******// 
		
		foreach($pateintdat as $pateintdatKey => $data){
			
			$patintMedStatus = $this->NewCropPrescription->find('list',array(
								'conditions'=>array('NewCropPrescription.batch_identifier'=>$data['NewCropPrescription']['batch_identifier'],
										'NewCropPrescription.patient_uniqueid'=>$data['NewCropPrescription']['patient_uniqueid']),
								'fields'=>array('id','status')));
			$statusCount = count($patintMedStatus); 
			$temp = "";
			$myVal = "";
			$count = 0; 
			$isPendingStat = 0;
			$isPartialStat = 0;
			$isCompletedStat = 0 ;
			foreach($patintMedStatus as $statusKey => $statusVal){
				 if($statusVal==0){
				 	$isPendingStat++; 
				 }else if($statusVal==1){
				 	$isPartialStat++ ;
				 }else if($statusVal==2){
				 	$isCompletedStat++ ; 
				 }
			}//EOF innner foreach
			 
			if($isPartialStat==0 && $isCompletedStat==0){
				$statusArray[$data['NewCropPrescription']['batch_identifier']] =  'Pending'; 
			}else if ($isPartialStat>0){
				$statusArray[$data['NewCropPrescription']['batch_identifier']] =  'Partial';
			}else if($isPartialStat==0 && $isPendingStat==0 && $isCompletedStat >0){
				$statusArray[$data['NewCropPrescription']['batch_identifier']] =  'Completed';
			}else{
				$statusArray[$data['NewCropPrescription']['batch_identifier']] =  'Pending';
			}
		}
		$this->set('pateintdat',$pateintdat);
		$this->set('statusData',$statusArray);
	} 
	public function get_add_prescription_detail($patientId=null,$batchIdentfier = null,$status = null){
		
		$this->layout="advance_ajax";
		$this->uses = array('PharmacyItem','PharmacyItemRate','PharmacySalesBill','Patient','NewCropPrescription');
		
		$this->Patient->unBindModel(array(
					'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));

		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
						//'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
						'User' => array('foreignKey' =>false, 'conditions'=>array('User.id = Patient.doctor_id')),
						'NewCropPrescription'=>array('foreignKey' =>false, 'conditions'=>array('NewCropPrescription.patient_uniqueid = Patient.id')),
						'PharmacyItem' =>array('foreignKey'=>false,'conditions'=>array('NewCropPrescription.drug_id = PharmacyItem.id'))
				)),false);
		 
		/* Location Id Is Removed - please do not add it again
		 * 'Patient.location_id'=>$this->Session->read('locationid') 
		 * by Mrunal 
		 * for Kanpur
		 * */
		$conditionArray = array();
		if($status == 1){ 
			$conditionArray[] = 0; 	// For Status Pending
		}else if($status == 2){
			$conditionArray[] = 1;  // for Status Partial
		}else{
			$conditionArray[] = 2; /// for Status Completed
		}
		if(empty($conditionArray)) $conditionArray = array(0,1,2);
		$patient = $this->Patient->find('all',array(
		 		/* 'limit' => Configure::read('number_of_rows'), */
		 		//'order' => array('NewCropPrescription.create_time' => 'desc'),
		 		'fields'=> array('Patient.id','Patient.lookup_name','Patient.admission_id','Patient.doctor_id','User.username',/*,'PatientInitial.name'*/
		 				'NewCropPrescription.description','NewCropPrescription.dose','NewCropPrescription.quantity','NewCropPrescription.recieved_quantity','PharmacyItem.pack','PharmacyItem.item_code',
		 				'PharmacyItem.name','NewCropPrescription.batch_identifier'),
		 		'conditions'=>array( 'NewCropPrescription.status'=>$conditionArray,'NewCropPrescription.by_nurse'=> '1','Patient.id'=>$patientId,
		 						'Patient.is_deleted'=>'0','NewCropPrescription.batch_identifier'=>$batchIdentfier,'NewCropPrescription.is_deleted'=>'0'),
		 		//'group'=>array('NewCropPrescription.batch_identifier')
		 		));
		
		$this->set('patient',$patient);
	}
	/**End Of Code **/
	
	public function fetch_patient_detail($field=null){
		debug($field);
		$this->loadModel('Patient');
		$searchKey = $this->params->query['term'];
		$filedOrder = array();
		/* if($field == "admission_id"){
			$filedOrder = array('Patient.id','Patient.admission_id','Patient.lookup_name','Patient.admission_type');
		}else{ */
			$filedOrder = array('Patient.id','Patient.lookup_name','Patient.admission_id','Patient.admission_type');
		//}
			
		$conditions["Patient.admission_id like"] = '%'.$searchKey.'%';
		$conditions["Patient.lookup_name like"] ='%'.$searchKey.'%';
		$items = $this->Patient->find('all', array(
				'fields'=> $filedOrder,
				'conditions'=>array('OR'=>($conditions),
						'Patient.is_deleted=0','Patient.admission_type'=>array('IPD')),'limit'=>10,'order'=>array("Patient.lookup_name ASC")));
		
		 $output ='';
		foreach ($items as $key => $value) {
			$id = $value['Patient']['id'];
			$party_code = $value['Patient']['admission_id'];
			$output = $value['Patient']['lookup_name']."-".$value['Patient']['admission_id'];
			$admission_type = $value['Patient']['admission_type'];
			$returnArray[] = array('id'=>$id,'party_code'=>$party_code,'value'=>$output,'admission_type'=>$admission_type,'tariff_id'=>$tariff_id,'tariff_name'=>$tariff_name);	//by swapnil
		}
	
		echo json_encode($returnArray);
		//exit;//dont remove this
	}
}

