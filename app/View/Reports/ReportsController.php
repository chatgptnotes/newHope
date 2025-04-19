<?php
/**
 * ReportsController file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Hope
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pankaj S. Wanjari
 */
class ReportsController extends AppController {

	public $name = 'Reports';
	public $uses = null;
	public $helpers = array('Html','Form', 'Js','Number','DateFormat');
	public $components = array('RequestHandler','Auth','Session','Acl');

	function viewPdf($id = null)
	{
		$this->uses = array('Person','Patient');
		 

		$this->Person->bindModel(array('belongsTo'=>array('Patient'=>array('foreignKey'=>false,'conditions'=>array("Person.patient_uid=Patient.patient_id")))));
		if(!empty($this->params->query)){
			$search_ele = $this->params->query  ;//make it get
	   
			$search_key['Patient.is_deleted'] = 0;
			if(!empty($search_ele['lookup_name'])){
				$search_key['Patient.lookup_name like '] = "%".$search_ele['lookup_name']."%" ;
			}if(!empty($search_ele['patient_id'])){
				$search_key['Patient.patient_id like '] = "%".$search_ele['patient_id'] ;
			}if(!empty($search_ele['admission_id'])){
				$search_key['Patient.admission_id like '] = "%".$search_ele['admission_id'] ;
			}
				
			$search_key['Patient.is_deleted'] = 0;
			$search_key['Patient.is_discharge'] = 0;//display only non-discharge patient
				
			$pdfData  = $this->Person->find('all',array('fields'=>array('Person.age,Person.sex,Patient.lookup_name,Patient.admission_id,
       									Patient.patient_id,Patient.admission_type'),'conditions'=>array($search_key,'Patient.admission_type'=>'IPD','Patient.location_id'=>$this->Session->read('locationid'))));   	 

			$this->set('pdfData',$pdfData);

		}else{
			$pdfData  = $this->Person->find('all',array('order' => array('Patient.create_time' => 'DESC'),'fields'=>array('Person.age,Person.sex,Patient.lookup_name,Patient.admission_id,
       									Patient.patient_id,Patient.admission_type'),'conditions'=>array('Patient.location_id'=>$this->Session->read('locationid'),'Patient.admission_type'=>'IPD','Patient.is_deleted'=>0,'Patient.is_discharge'=>0)));
			//pr($pdfData);exit;
			$this->set('pdfData',$pdfData);
		}

		$this->layout = 'pdf'; //this will use the pdf.ctp layout
		$this->render();
		 
	}

	/**
	 * staff survey reports
	 *
	 */

	public function admin_staff_survey_reports() {
		$this->set('title_for_layout', __('Staff Survey Reports', true));
		$this->uses = array('StaffSurvey');
		$totalNumber = $this->StaffSurvey->find('count', array('conditions' => array('StaffSurvey.location_id' => $this->Session->read('locationid')), 'group' => array('user_id')));

		$yesResults = $this->StaffSurvey->find('all', array('fields' => array('COUNT(*) AS report_results', 'question_id', 'answer', 'location_id', 'id'), 'conditions' => array('StaffSurvey.location_id' => $this->Session->read('locationid'), 'StaffSurvey.answer' => 'Y'), 'group' => array('question_id', 'answer'), 'order' => array('question_id')));
		foreach($yesResults as $yesResultsVal) {
			$yesQuestionIdArray[] = $yesResultsVal['StaffSurvey']['question_id'];
			$yesResultArray[$yesResultsVal['StaffSurvey']['question_id']] = $yesResultsVal[0]['report_results'];
		}
		$noResults = $this->StaffSurvey->find('all', array('fields' => array('COUNT(*) AS report_results', 'question_id', 'answer', 'location_id', 'id'), 'conditions' => array('StaffSurvey.location_id' => $this->Session->read('locationid'), 'StaffSurvey.answer' => 'N'), 'group' => array('question_id', 'answer'), 'order' => array('question_id')));
		foreach($noResults as $noResultsVal) {
			$noQuestionIdArray[] = $noResultsVal['StaffSurvey']['question_id'];
			$noResultArray[$noResultsVal['StaffSurvey']['question_id']] = $noResultsVal[0]['report_results'];
		}
		//print_r($yesQuestionIdArray);exit;
		$this->set('yesQuestionIdArray', $yesQuestionIdArray);
		$this->set('yesResultArray', $yesResultArray);
		$this->set('noQuestionIdArray', $noQuestionIdArray);
		$this->set('noResultArray', $noResultArray);
		$this->set('totalNumber', $totalNumber);
	}

	/**
	 * download staff survey xls reports
	 *
	 */

	public function admin_staff_survey_xlsreports() {
		$this->set('title_for_layout', __('Staff Survey Reports', true));
		$this->uses = array('StaffSurvey');
		$totalNumber = $this->StaffSurvey->find('count', array('conditions' => array('StaffSurvey.location_id' => $this->Session->read('locationid')), 'group' => array('user_id')));

		$yesResults = $this->StaffSurvey->find('all', array('fields' => array('COUNT(*) AS report_results', 'question_id', 'answer', 'location_id', 'id'), 'conditions' => array('StaffSurvey.location_id' => $this->Session->read('locationid'), 'StaffSurvey.answer' => 'Y'), 'group' => array('question_id', 'answer'), 'order' => array('question_id')));
		foreach($yesResults as $yesResultsVal) {
			$yesQuestionIdArray[] = $yesResultsVal['StaffSurvey']['question_id'];
			$yesResultArray[$yesResultsVal['StaffSurvey']['question_id']] = $yesResultsVal[0]['report_results'];
		}
		$noResults = $this->StaffSurvey->find('all', array('fields' => array('COUNT(*) AS report_results', 'question_id', 'answer', 'location_id', 'id'), 'conditions' => array('StaffSurvey.location_id' => $this->Session->read('locationid'), 'StaffSurvey.answer' => 'N'), 'group' => array('question_id', 'answer'), 'order' => array('question_id')));
		foreach($noResults as $noResultsVal) {
			$noQuestionIdArray[] = $noResultsVal['StaffSurvey']['question_id'];
			$noResultArray[$noResultsVal['StaffSurvey']['question_id']] = $noResultsVal[0]['report_results'];
		}
		//print_r($yesQuestionIdArray);exit;
		$this->set('yesQuestionIdArray', $yesQuestionIdArray);
		$this->set('yesResultArray', $yesResultArray);
		$this->set('noQuestionIdArray', $noQuestionIdArray);
		$this->set('noResultArray', $noResultArray);
		$this->set('totalNumber', $totalNumber);
		$this->layout = false;
	}

	/**
	 * patient survey reports
	 *
	 */

	public function admin_patient_survey_reports() {
		$this->set('title_for_layout', __('Patient Survey Reports', true));
		$this->uses = array('PatientSurvey');
		$totalNumber = $this->PatientSurvey->find('count', array('conditions' => array('PatientSurvey.location_id' => $this->Session->read('locationid')), 'group' => array('PatientSurvey.patient_id')));

		$strongAgreeResults = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS report_results', 'question_id', 'answer', 'location_id', 'id'), 'conditions' => array('PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.answer' => 'Strongly Agree'), 'group' => array('question_id', 'answer'), 'order' => array('question_id')));
		foreach($strongAgreeResults as $strongAgreeResultsVal) {
			$strongAgreeQuestionIdArray[] = $strongAgreeResultsVal['PatientSurvey']['question_id'];
			$strongAgreeResultArray[$strongAgreeResultsVal['PatientSurvey']['question_id']] = $strongAgreeResultsVal[0]['report_results'];
			$this->set('strongAgreeQuestionIdArray', $strongAgreeQuestionIdArray);
			$this->set('strongAgreeResultArray', $strongAgreeResultArray);
		}
		$agreeResults = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS report_results', 'question_id', 'answer', 'location_id', 'id'), 'conditions' => array('PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.answer' => 'Agree'), 'group' => array('question_id', 'answer'), 'order' => array('question_id')));
		foreach($agreeResults as $agreeResultsVal) {
			$agreeQuestionIdArray[] = $agreeResultsVal['PatientSurvey']['question_id'];
			$agreeResultArray[$agreeResultsVal['PatientSurvey']['question_id']] = $agreeResultsVal[0]['report_results'];
			$this->set('agreeQuestionIdArray', $agreeQuestionIdArray);
			$this->set('agreeResultArray', $agreeResultArray);
		}
		$nandResults = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS report_results', 'question_id', 'answer', 'location_id', 'id'), 'conditions' => array('PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.answer' => 'Neither Agree Nor  Disagree'), 'group' => array('question_id', 'answer'), 'order' => array('question_id')));
		foreach($nandResults as $nandResultsVal) {
			$nandQuestionIdArray[] = $nandResultsVal['PatientSurvey']['question_id'];
			$nandResultArray[$nandResultsVal['PatientSurvey']['question_id']] = $nandResultsVal[0]['report_results'];
			$this->set('nandQuestionIdArray', $nandQuestionIdArray);
			$this->set('nandResultArray', $nandResultArray);
		}
		$disagreeResults = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS report_results', 'question_id', 'answer', 'location_id', 'id'), 'conditions' => array('PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.answer' => 'Disagree'), 'group' => array('question_id', 'answer'), 'order' => array('question_id')));
		foreach($disagreeResults as $disagreeResultsVal) {
			$disagreeQuestionIdArray[] = $disagreeResultsVal['PatientSurvey']['question_id'];
			$disagreeResultArray[$disagreeResultsVal['PatientSurvey']['question_id']] = $disagreeResultsVal[0]['report_results'];
			$this->set('disagreeQuestionIdArray', $disagreeQuestionIdArray);
			$this->set('disagreeResultArray', $disagreeResultArray);
		}
		$strongDisagreeResults = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS report_results', 'question_id', 'answer', 'location_id', 'id'), 'conditions' => array('PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.answer' => 'Strongly Disagree'), 'group' => array('question_id', 'answer'), 'order' => array('question_id')));
		foreach($strongDisagreeResults as $strongDisagreeResultsVal) {
			$strongDisagreeQuestionIdArray[] = $strongDisagreeResultsVal['PatientSurvey']['question_id'];
			$strongDisagreeResultArray[$strongDisagreeResultsVal['PatientSurvey']['question_id']] = $strongDisagreeResultsVal[0]['report_results'];
			$this->set('strongDisagreeQuestionIdArray', $strongDisagreeQuestionIdArray);
			$this->set('strongDisagreeResultArray', $strongDisagreeResultArray);
		}
		$naResults = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS report_results', 'question_id', 'answer', 'location_id', 'id'), 'conditions' => array('PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.answer' => 'Not Applicable'), 'group' => array('question_id', 'answer'), 'order' => array('question_id')));
		foreach($naResults as $naResultsVal) {
			$naQuestionIdArray[] = $naResultsVal['PatientSurvey']['question_id'];
			$naResultArray[$naResultsVal['PatientSurvey']['question_id']] = $naResultsVal[0]['report_results'];
			$this->set('naQuestionIdArray', $naQuestionIdArray);
			$this->set('naResultArray', $naResultArray);
		}
		$this->set('totalNumber', $totalNumber);
	}

	/**
	 * download patient survey xls reports
	 *
	 */

	public function admin_patient_survey_xlsreports() {
		$this->set('title_for_layout', __('Patient Survey Reports', true));
		$this->uses = array('PatientSurvey');
		$totalNumber = $this->PatientSurvey->find('count', array('conditions' => array('PatientSurvey.location_id' => $this->Session->read('locationid')), 'group' => array('PatientSurvey.patient_id')));

		$strongAgreeResults = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS report_results', 'question_id', 'answer', 'location_id', 'id'), 'conditions' => array('PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.answer' => 'Strongly Agree'), 'group' => array('question_id', 'answer'), 'order' => array('question_id')));
		foreach($strongAgreeResults as $strongAgreeResultsVal) {
			$strongAgreeQuestionIdArray[] = $strongAgreeResultsVal['PatientSurvey']['question_id'];
			$strongAgreeResultArray[$strongAgreeResultsVal['PatientSurvey']['question_id']] = $strongAgreeResultsVal[0]['report_results'];
			$this->set('strongAgreeQuestionIdArray', $strongAgreeQuestionIdArray);
			$this->set('strongAgreeResultArray', $strongAgreeResultArray);
		}
		$agreeResults = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS report_results', 'question_id', 'answer', 'location_id', 'id'), 'conditions' => array('PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.answer' => 'Agree'), 'group' => array('question_id', 'answer'), 'order' => array('question_id')));
		foreach($agreeResults as $agreeResultsVal) {
			$agreeQuestionIdArray[] = $agreeResultsVal['PatientSurvey']['question_id'];
			$agreeResultArray[$agreeResultsVal['PatientSurvey']['question_id']] = $agreeResultsVal[0]['report_results'];
			$this->set('agreeQuestionIdArray', $agreeQuestionIdArray);
			$this->set('agreeResultArray', $agreeResultArray);
		}
		$nandResults = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS report_results', 'question_id', 'answer', 'location_id', 'id'), 'conditions' => array('PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.answer' => 'Neither Agree Nor  Disagree'), 'group' => array('question_id', 'answer'), 'order' => array('question_id')));
		foreach($nandResults as $nandResultsVal) {
			$nandQuestionIdArray[] = $nandResultsVal['PatientSurvey']['question_id'];
			$nandResultArray[$nandResultsVal['PatientSurvey']['question_id']] = $nandResultsVal[0]['report_results'];
			$this->set('nandQuestionIdArray', $nandQuestionIdArray);
			$this->set('nandResultArray', $nandResultArray);
		}
		$disagreeResults = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS report_results', 'question_id', 'answer', 'location_id', 'id'), 'conditions' => array('PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.answer' => 'Disagree'), 'group' => array('question_id', 'answer'), 'order' => array('question_id')));
		foreach($disagreeResults as $disagreeResultsVal) {
			$disagreeQuestionIdArray[] = $disagreeResultsVal['PatientSurvey']['question_id'];
			$disagreeResultArray[$disagreeResultsVal['PatientSurvey']['question_id']] = $disagreeResultsVal[0]['report_results'];
			$this->set('disagreeQuestionIdArray', $disagreeQuestionIdArray);
			$this->set('disagreeResultArray', $disagreeResultArray);
		}
		$strongDisagreeResults = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS report_results', 'question_id', 'answer', 'location_id', 'id'), 'conditions' => array('PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.answer' => 'Strongly Disagree'), 'group' => array('question_id', 'answer'), 'order' => array('question_id')));
		foreach($strongDisagreeResults as $strongDisagreeResultsVal) {
			$strongDisagreeQuestionIdArray[] = $strongDisagreeResultsVal['PatientSurvey']['question_id'];
			$strongDisagreeResultArray[$strongDisagreeResultsVal['PatientSurvey']['question_id']] = $strongDisagreeResultsVal[0]['report_results'];
			$this->set('strongDisagreeQuestionIdArray', $strongDisagreeQuestionIdArray);
			$this->set('strongDisagreeResultArray', $strongDisagreeResultArray);
		}
		$naResults = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS report_results', 'question_id', 'answer', 'location_id', 'id'), 'conditions' => array('PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.answer' => 'Not Applicable'), 'group' => array('question_id', 'answer'), 'order' => array('question_id')));
		foreach($naResults as $naResultsVal) {
			$naQuestionIdArray[] = $naResultsVal['PatientSurvey']['question_id'];
			$naResultArray[$naResultsVal['PatientSurvey']['question_id']] = $naResultsVal[0]['report_results'];
			$this->set('naQuestionIdArray', $naQuestionIdArray);
			$this->set('naResultArray', $naResultArray);
		}
		$this->set('totalNumber', $totalNumber);
		$this->layout = false;
	}


	/**
	 * list of all link required for reports modules
	 *
	 */
	public function admin_all_report(){

	}



	/**
	@name : admin_patient_registration_report
	@created for: Admission report
	@created on : 2/15/2012
	@created By : Anand

	**/

	public function admin_patient_registration_report(){
		$this->uses = array('Patient','Location','Person');
		$fieldsArr = array('executive_emp_id_no'=>'Executive Employee ID No','relation_to_employee'=>'Relationship with Employee',
		 					'non_executive_emp_id_no'=>'Non Executive Employee ID No','designation'=>'Designation','passport_no'=>'Passport No/ID',
		 					'allergies'=>'Allergies','relative_name'=>'Relatives Name','home_phone'=>'Home Phone No','instruction'=>'Instruction',
		 					'mobile'=>'Mobile Phone No','patient_owner'=>'Emergency Contact Name','asst_phone'=>'Emergency Contact No',
		 					'email'=>'Email','fax'=>'Fax','nationality'=>'Nationality' ); 		 	
		$this->set('fieldsArr',$fieldsArr);
		if($this->request->data){

			$format = $this->request->data['PatientRegistrationReport']['format'];
			$from = $this->request->data['PatientRegistrationReport']['from'];
			$to =   $this->request->data['PatientRegistrationReport']['to'];
			$sex = $this->request->data['PatientRegistrationReport']['sex'];
			$age = $this->request->data['PatientRegistrationReport']['age'];
			$blood_group = $this->request->data['PatientRegistrationReport']['blood_group'];
			$patientlocation = $this->request->data['PatientRegistrationReport']['patient_location'];
			//$sponsor = $this->request->data['PatientRegistrationReport']['sponsor'];
			$record = '';
			$this->Person->unbindModel(array(
 								'hasMany' => array('PharmacySalesBill'))); 
				


			//BOF pankaj code
			$this->Person->bindModel(array(
 								'belongsTo' => array( 											 
														'Location' =>array('foreignKey' => 'location_id'), 
			   
			                                            'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
			)),false);
				
			if(!empty($to) && !empty($from)){
				$from = $this->DateFormat->formatDate2STDForReport($this->request->data['PatientRegistrationReport']['from'],Configure::read('date_format'))." 00:00:00";
				$to = $this->DateFormat->formatDate2STDForReport($this->request->data['PatientRegistrationReport']['to'],Configure::read('date_format'))." 23:59:59";

				//pr($from." ".$to);exit;
				// get record between two dates. Make condition
				$search_key = array('Person.create_time <=' => $to, 'Person.create_time >=' => $from,'Person.is_deleted'=>0,'Person.location_id'=>$this->Session->read('locationid'));
			}else{
				$search_key =array('Person.is_deleted'=>0,'Person.location_id'=>$this->Session->read('locationid')) ;
			}
			if(!(empty($sex))){
				$search_key['Person.sex'] =  $sex;
			}
		    if(!(empty($patientlocation))){
				$search_key['Person.city'] =  $patientlocation;
			}
			if(!(empty($age))){
				$ageRange = explode('-',$age);
				$search_key['Person.age between ? and ?'] =  array($ageRange[0],$ageRange[1]);
			}
			if(!(empty($blood_group))){
				$search_key['Person.blood_group'] =  $blood_group;
			}
			$selectedFields ='';
			$selectedFields .= 'CONCAT(Person.plot_no," ",Person.landmark, " ",Person.city, " ",Person.taluka, " ",Person.district, " ",Person.pin_code) as address ';
				
			if(!empty($this->request->data['PatientRegistrationReport']['field_id'])){
				$selectedFields .=  ",Person.".implode(',Person.',$this->request->data['PatientRegistrationReport']['field_id']);
			}

			$fields =array('Person.create_time,Person.city,Person.blood_group,Person.patient_uid,CONCAT(PatientInitial.name," ",Person.first_name," ",Person.last_name) as full_name,Person.age,Person.sex,'.$selectedFields);
			$record = $this->Person->find('all',array('order'=>array('Person.create_time' => 'DESC'),'fields'=>$fields,'conditions'=>$search_key));

			$this->set('selctedFields',$this->request->data['PatientRegistrationReport']['field_id']);


			//EOF pankaj code
				
			if($format == 'PDF'){
				$this->set('reports',$record);
				$this->set(compact('fieldName'));
				$this->render('patient_registration_pdf','pdf');
			} else {
					
				$this->set('reports', $record);
				$this->set(compact('fieldName'));
				//$this->render('patient_registration_excel','patient_report_excel');
				$this->render('patient_registration_excel','');
			}
		}
		$this->set('locationlist',$this->Person->find('list',array('fields'=>array('city','city'))));
	}




	/**
	@Name			: admin_patient_sponsor_report
	@Created for	: To get the coporate as type. will call bye ajax.
	@created By		: Anand
	@created On		: 2/23/2012
	**/


	public function admin_patient_sponsor_report(){
		$this->uses = array('Patient','Corporate','InsuranceCompany','Location','CorporateSublocation','CorporateLocation','Person');
		if($this->request->data){

			$format = $this->request->data['PatientRegistrationReport']['format'];
			$payment_category = $this->request->data['PatientRegistrationReport']['payment_category'];
			$patientlocation = $this->request->data['PatientRegistrationReport']['patient_location'];
			$record = '';
			$insurence_name = '';
			$corporate_name = '';
			$sublocation = '';
			$corporate_location_name = '';

			$from = $this->DateFormat->formatDate2STDForReport($this->request->data['PatientRegistrationReport']['from'],Configure::read('date_format'))." 00:00:00";
			$to = $this->DateFormat->formatDate2STDForReport($this->request->data['PatientRegistrationReport']['to'],Configure::read('date_format'))." 23:59:59";

			//pr($this->request->data);exit;

			$location_id = $this->Session->read('locationid');
			$this->Patient->bindModel(array(
 								'belongsTo' => array( 											 
									'Person' =>array('foreignKey' => 'person_id'),
			                        'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
			)),false);
            
  
			$conditions = array('Patient.form_received_on <=' => $to, 'Patient.form_received_on >=' => $from); // Codition for date
		    if(!empty($patientlocation)) {
            	$addLocationCondition = array('Person.city' => $patientlocation);
            	$conditions = array_merge($conditions, $addLocationCondition);
            }
			$fields = array('CONCAT(Person.plot_no," ",Person.landmark, " ",Person.city, " ",Person.taluka, " ",Person.district, " ",Person.pin_code) as address','Patient.payment_category',
						'Person.city','Patient.lookup_name','PatientInitial.name','Patient.mobile_phone','Patient.patient_id','Patient.admission_id','Patient.age','Patient.sex','Patient.create_time','Patient.email','Patient.credit_type_id', 'Patient.form_received_on');
			if($payment_category !=  '' && $payment_category =='card'){	 // Payment cadegory
				$sponsor = $this->request->data['PatientRegistrationReport']['sponsor'];

				// When sponsor is corporate i.e.1
				if($sponsor == 1){
					if(isset($this->request->data['PatientRegistrationReport']['corporate_id']) && $this->request->data['PatientRegistrationReport']['corporate_id'] != ''){
						$corporate = $this->request->data['PatientRegistrationReport']['corporate_id'];
						$corporate_location = $this->request->data['PatientRegistrationReport']['corporate_location_id'];// Location
						$corporate_sublocation = $this->request->data['PatientRegistrationReport']['sublocation_id'];// Sub Location

						// Is the sublocation is given
						if(!empty($corporate_sublocation)){
							$record = $this->Patient->find('all',array('order'=>array('Patient.create_time' => 'DESC'),'fields'=>$fields,'conditions' => array($conditions,'Patient.corporate_id'=>$corporate,'Patient.corporate_location_id'=>$corporate_location,'Patient.corporate_sublocation_id'=>$corporate_sublocation,'Patient.location_id'=>$location_id)));
							// Get sub-location name
							$sublocation = $this->CorporateSublocation->field('name',array('CorporateSublocation.id'=>$corporate_sublocation));

						} else {
							$record = $this->Patient->find('all',array('order'=>array('Patient.create_time' => 'DESC'),'fields'=>$fields,'conditions' => array($conditions,'Patient.corporate_id'=>$corporate,'Patient.corporate_location_id'=>$corporate_location,'Patient.location_id'=>$location_id)));
						}
							
						// Get corporate name
						$corporate_name = $this->Corporate->field('name',array('Corporate.id'=>$corporate));
						$type = 'Corporate'; // Set type
						// Get location for corporate
						$corporate_location_name = $this->CorporateLocation->field('name',array('CorporateLocation.id'=>$corporate_location));
							
					}
					// When sponsor is insurence i.e.2
				} else {
					if (isset($this->request->data['PatientRegistrationReport']['insurenceCom_id']) && $this->request->data['PatientRegistrationReport']['insurenceCom_id'] !=''){

						$insurance_company_id = $this->request->data['PatientRegistrationReport']['insurenceCom_id'];// Insurence Company Id
						$insurance_type_id = $this->request->data['PatientRegistrationReport']['insurance_type_id'];// Insurence type id

						$record = $this->Patient->find('all',array('order'=>array('Patient.form_received_on' => 'DESC'),'fields'=>$fields,'conditions' => array($conditions,'Patient.insurance_company_id'=>$insurance_company_id,'Patient.insurance_type_id'=>$insurance_type_id,'Patient.location_id'=>$location_id)));
						$corporate_name = $this->InsuranceCompany->field('name',array('InsuranceCompany.id'=>$insurance_company_id));
						$type = 'Insurence';
					}
				}
			} else if($payment_category =='cash') {
				$record = $this->Patient->find('all',array('order'=>array('Patient.form_received_on' => 'DESC'),
		'fields'=>$fields,'conditions' => array($conditions,'Patient.payment_category'=>$payment_category,'Patient.location_id'=>$location_id)));
				$type = 'Self Pay';
			} else {
				$record = $this->Patient->find('all',array('order'=>array('Patient.create_time' => 'DESC'),'fields'=>$fields,
		'conditions' => array($conditions,'Patient.location_id'=>$location_id)));
				$type = 'Self Pay And Card';

			}

			//pr($record);exit;
		 if($format == 'PDF'){

				$this->set('reports',$record);
				$this->set(compact('corporate_name')); // Corporate name
				$this->set(compact('type'));// Type of sponsor
				$this->set(compact('corporate_location_name')); // Corporate location name when corporate
				$this->set(compact('sublocation')); // Sublocation when corporate sublocation is there else empty
				$this->render('patient_sponsor_pdf','pdf');
			} else {

				$this->set('reports', $record);
				$this->set(compact('corporate_name'));
				$this->set(compact('type'));
				$this->set(compact('corporate_location_name')); // Corporate location name when corporate
				$this->set(compact('sublocation')); // Sublocation when corporate sublocation is there else empty
				$this->render('patient_sponsor_excel','');
			}

	 }
	 $this->set('locationlist',$this->Person->find('list',array('fields'=>array('city','city'))));
	}


	/**
	@Name			: admin_patient_sponsor_report
	@Created for	: To get the coporate as type. will call bye ajax.
	@created By		: Anand
	@created On		: 2/23/2012
	**/

	public function admin_patient_sponsor_report_chart(){

		$this->uses = array('Patient','Location','Consultant');
		if(!empty($this->request->data)){
				
			//pr($this->request->data);exit;
			$this->set('title_for_layout', __('Total Empanelment Report Chart', true));
				
				
			$reportYear = $this->request->data['PatientRegistrationReport']['year'];
			$consultantName = '';
			$reportMonth = $this->request->data['PatientRegistrationReport']['month'];
			$payment_category = $this->request->data['PatientRegistrationReport']['payment_category'];
            $patientlocation = $this->request->data['PatientRegistrationReport']['patient_location'];
			if(!empty($reportMonth)){
				$countDays = cal_days_in_month(CAL_GREGORIAN, $reportMonth, $reportYear); // Days of the month selected
				$fromDate = $reportYear."-".$reportMonth."-01";
				$toDate = $reportYear."-".$reportMonth."-".$countDays;
			} else {
				$fromDate = $reportYear."-01-01"; // set first date of current year
				$toDate = $reportYear."-12-31"; // set last date of current year
			}

			$this->Patient->bindModel(array(
 								'belongsTo' => array( 											 
									'Person' =>array('foreignKey' => 'person_id')
			                        
			)),false);
			$conditions = array('Patient.form_received_on <=' => $toDate, 'Patient.form_received_on >=' => $fromDate); // Condition for year and month
		    if(!empty($patientlocation)) {
            	$addLocationCondition = array('Person.city' => $patientlocation);
            	$conditions = array_merge($conditions, $addLocationCondition);
            }
			$location_id = $this->Session->read('locationid');
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));

			}
				

			//$countRecord = $this->Patient->find('count',array('conditions'=>array($conditions,'Patient.known_fam_physician'=>1,'Patient.consultant_id'=>$reference)));
			if($payment_category != 'cash'){
				$corporate_id = $this->request->data['PatientRegistrationReport']['corporate_id'];
				$corporate_location_id = $this->request->data['PatientRegistrationReport']['corporate_location_id'];
				$corporate_sublocation_id = $this->request->data['PatientRegistrationReport']['sublocation_id'];

				$countRecord = $this->Patient->find('all', array('fields' => array('COUNT(*) AS recordcount', 'DATE_FORMAT(Patient.create_time, "%M-%Y") AS month_reports', 'Patient.form_received_on', 'Patient.corporate_id'), 'conditions' => array('Patient.location_id' => $location_id,$conditions,'Patient.payment_category'=>'card','Patient.corporate_id'=>$corporate_id,'Patient.corporate_location_id'=>$corporate_location_id,'Patient.corporate_sublocation_id'=>$corporate_sublocation_id),'group' => array('month_reports')));
			} else {
				$countRecord = $this->Patient->find('all', array('fields' => array('COUNT(*) AS recordcount', 'DATE_FORMAT(Patient.create_time, "%M-%Y") AS month_reports',
					 'Patient.form_received_on', 'Patient.corporate_id'), 'conditions' => array('Patient.location_id' => $location_id,$conditions,
					 'Patient.payment_category'=>'cash'),'group' => array('month_reports')));
			}
			foreach($countRecord as $countRecordVal) {
				$filterRecordDateArray[] = $countRecordVal[0]['month_reports'];
				$filterRecordCountArray[$countRecordVal[0]['month_reports']] = $countRecordVal[0]['recordcount'];
			}

		}
		//pr($countRecord);exit;

		//pr($filterSsiCountArray);exit;
		$this->set('filterRecordDateArray', isset($filterRecordDateArray)?$filterRecordDateArray:"");
		$this->set('filterRecordCountArray', isset($filterRecordCountArray)?$filterRecordCountArray:0);
		$this->set('yaxisArray', $yaxisArray);
		$this->set(compact('payment_category'));
		$this->set(compact('countRecord'));
		$this->set(compact('reportMonth'));

	}



	/**
	 Name : admin_patient_ot_report
	 Created On : 2/10/2012
	 **/

	public function admin_patient_ot_report(){
		$this->uses = array('Surgery','OptAppointment','Location','Department','DoctorProfile', 'Doctor');
		if($this->request->data){
			$sergery = $this->request->data['PatientOtReport']['surgery'];
			$sergery_type = $this->request->data['PatientOtReport']['sergery_type'];
			$from = $this->DateFormat->formatDate2STDForReport($this->request->data['PatientOtReport']['from'],Configure::read('date_format'))." 00:00:00";
			$to = $this->DateFormat->formatDate2STDForReport($this->request->data['PatientOtReport']['to'],Configure::read('date_format'))." 23:59:59";
			$format = $this->request->data['PatientOtReport']['format'];
			$department = $this->request->data['department'];
			$doctor = $this->request->data['doctor'];
			$this->DoctorProfile->virtualFields = array(
    							'doctor_name' => 'CONCAT(Initial.name, " ", DoctorProfile.doctor_name)'
							);
			
			// get record between two dates. Make condition

			$location_id = $this->Session->read('locationid');
			$conditionsOt['OptAppointment'] = array('starttime BETWEEN ? AND ?' => array($from,$to));
			if(!empty($this->request->data['PatientOtReport']['procedure_complete']) || $this->request->data['PatientOtReport']['procedure_complete'] != "") {
			  $conditionsOt['OptAppointment']['procedure_complete'] = $this->request->data['PatientOtReport']['procedure_complete'];
			} else {
			  $conditionsOt['OptAppointment']['procedure_complete'] = array(0,1);
			} 
			$conditionsOt['OptAppointment']['is_deleted'] = 0;
			$conditionsOt['OptAppointment']['location_id'] = $location_id;
			if($sergery != "") {
				$conditionsOt['OptAppointment']['surgery_id'] = $sergery;
			}
			if($sergery_type != "") {
				$conditionsOt['OptAppointment']['operation_type'] = $sergery_type;
			}
			if($department != "") {
				$conditionsOt['DoctorProfile']['department_id'] = $department;
			}
			if($doctor != "") {
				$conditionsOt['DoctorProfile']['user_id'] = $doctor;
			}

			$allConditionsOt = $this->postConditions($conditionsOt);
			$this->OptAppointment->unbindModel(array('belongsTo' => array('Initial', 'Doctor')));
			$this->OptAppointment->bindModel(array(
 								'belongsTo' => array( 		
    													 'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
    		                                             'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
				                                         'User' =>array('foreignKey' => false,'conditions'=>array('User.id = DoctorProfile.user_id' )),	
				                                         'Initial' =>array('foreignKey' => false,'conditions'=>array('Initial.id =User.initial_id' )),	
				                                          
														
    												)),false);  
			$record = $this->OptAppointment->find('all',array('order'=>array('OptAppointment.create_time' => 'DESC'),'conditions'=>$allConditionsOt, 'fields' => array('Patient.id', 'Patient.form_received_on', 'Patient.admission_id', 'Patient.lookup_name', 'Patient.age', 'Patient.sex', 'PatientInitial.name','Initial.name', 'Surgery.name', 'OptAppointment.id', 'OptAppointment.operation_type', 'OptAppointment.starttime', 'OptAppointment.endtime', 'OptAppointment.ot_in_date','OptAppointment.out_date','OptAppointment.procedure_complete','DoctorProfile.doctor_name','Opt.name')));


			//pr($record);exit;
			if($format == 'PDF'){

				$this->set('reports',$record);

				$this->render('patient_ot_pdf','pdf');
			} else {

				$this->set('reports', $record);

				$this->render('patient_ot_excel','patient_ot_excel');
			}
		}
		$sergery = $this->Surgery->find('list',array('conditions'=>array('Surgery.location_id'=>$this->Session->read('locationid'))));
		$this->set(compact('sergery'));
		//get department list //
		$departmentList = $this->Department->find('list', array('fields' => array('Department.id', 'Department.name'), 'conditions' => array('Department.location_id' => $this->Session->read('locationid'), 'Department.is_active' => 1)));
		$this->set('departmentList', $departmentList);
	}

	/**
	 Name : admin_patient_otutilizationrate_report
	 Created On : 2/10/2012
	 created by :Anand
	 **/
	public function admin_patient_otutilizationrate_report(){
		$this->uses = array('Surgery','OptAppointment','Location');
		$this->OptAppointment->unbindModel(array('belongsTo' => array('Initial', 'Doctor')));
			$this->OptAppointment->bindModel(array(
 								'belongsTo' => array( 		
    													 'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
    		                                             'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
				                                         'User' =>array('foreignKey' => false,'conditions'=>array('User.id = DoctorProfile.user_id' )),	
				                                         'Initial' =>array('foreignKey' => false,'conditions'=>array('Initial.id =User.initial_id' )),	
				                                          
														
    												)),false);  
			
		if($this->request->data){
			$sergery = $this->request->data['PatientOtReport']['surgery'];
			$sergery_type = $this->request->data['PatientOtReport']['sergery_type'];
			$from = $this->DateFormat->formatDate2STDForReport($this->request->data['PatientOtReport']['from'],Configure::read('date_format'))." 00:00:00";
			$to = $this->DateFormat->formatDate2STDForReport($this->request->data['PatientOtReport']['to'],Configure::read('date_format'))." 23:59:59";
			$format = $this->request->data['PatientOtReport']['format'];
			$total = '';

			$conditions = array('OptAppointment.starttime <=' => $to, 'OptAppointment.endtime >=' => $from);
			$location_id = $this->Session->read('locationid');
			// Fetch the data as per the condition
			if($sergery == '' && $sergery_type == ''){
				$record = $this->OptAppointment->find('all',array('order'=>array('OptAppointment.create_time' => 'DESC'),'conditions'=>array($conditions,'OptAppointment.location_id'=>$location_id),'fields' => array('Patient.id', 'Patient.form_received_on', 'Patient.admission_id', 'Patient.lookup_name', 'Patient.age', 'Patient.sex', 'PatientInitial.name','Initial.name', 'Surgery.name', 'OptAppointment.id', 'OptAppointment.operation_type', 'OptAppointment.starttime', 'OptAppointment.endtime', 'OptAppointment.ot_in_date','OptAppointment.out_date','OptAppointment.procedure_complete','DoctorProfile.doctor_name','Opt.name')));
			} else if($sergery != '' && $sergery_type == ''){
				$record = $this->OptAppointment->find('all',array('order'=>array('OptAppointment.create_time' => 'DESC'),'conditions'=>array($conditions,'OptAppointment.surgery_id'=>$sergery,'OptAppointment.location_id'=>$location_id,'OptAppointment.procedure_complete'=>1),'fields' => array('Patient.id', 'Patient.form_received_on', 'Patient.admission_id', 'Patient.lookup_name', 'Patient.age', 'Patient.sex', 'PatientInitial.name','Initial.name', 'Surgery.name', 'OptAppointment.id', 'OptAppointment.operation_type', 'OptAppointment.starttime', 'OptAppointment.endtime', 'OptAppointment.ot_in_date','OptAppointment.out_date','OptAppointment.procedure_complete','DoctorProfile.doctor_name','Opt.name')));
			} else if($sergery == '' && $sergery_type != ''){
				$record = $this->OptAppointment->find('all',array('order'=>array('OptAppointment.create_time' => 'DESC'),'conditions'=>array($conditions,'OptAppointment.operation_type'=>$sergery_type,'OptAppointment.location_id'=>$location_id,'OptAppointment.procedure_complete'=>1),'fields' => array('Patient.id', 'Patient.form_received_on', 'Patient.admission_id', 'Patient.lookup_name', 'Patient.age', 'Patient.sex', 'PatientInitial.name','Initial.name', 'Surgery.name', 'OptAppointment.id', 'OptAppointment.operation_type', 'OptAppointment.starttime', 'OptAppointment.endtime', 'OptAppointment.ot_in_date','OptAppointment.out_date','OptAppointment.procedure_complete','DoctorProfile.doctor_name','Opt.name')));
			} else if($sergery != '' && $sergery_type != ''){
				$record = $this->OptAppointment->find('all',array('order'=>array('OptAppointment.create_time' => 'DESC'),'conditions'=>array($conditions,'OptAppointment.operation_type'=>$sergery_type,'OptAppointment.surgery_id'=>$sergery,'OptAppointment.location_id'=>$location_id,'OptAppointment.procedure_complete'=>1),'fields' => array('Patient.id', 'Patient.form_received_on', 'Patient.admission_id', 'Patient.lookup_name', 'Patient.age', 'Patient.sex', 'PatientInitial.name','Initial.name', 'Surgery.name', 'OptAppointment.id', 'OptAppointment.operation_type', 'OptAppointment.starttime', 'OptAppointment.endtime', 'OptAppointment.ot_in_date','OptAppointment.out_date','OptAppointment.procedure_complete','DoctorProfile.doctor_name','Opt.name')));
			}


			// Calcualate total utilization rate here formula:-> (Total duration of Surgery / 8 * no. Days)*100
			// Collect number of days between daterange
			$d1 = $this->DateFormat->formatDate2STDForReport($this->request->data['PatientOtReport']['from'],Configure::read('date_format'));
			$d2 = $this->DateFormat->formatDate2STDForReport($this->request->data['PatientOtReport']['to'],Configure::read('date_format'));

			$days = (strtotime($d2) - strtotime($d1)) / (60 * 60 * 24) +1;
			//pr($days);exit;
			// Get the total hours of surgery
			foreach($record as $pdfData){
				$t1 = explode(" ", $pdfData['OptAppointment']['strttime']);
				$t2 = explode(" ", $pdfData['OptAppointment']['endtime']);

				$a1 = explode(":",$t1[1]);
				$a2 = explode(":",$t2[1]);
				$time1 = (($a1[0]*60*60)+($a1[1]*60));
				$time2 = (($a2[0]*60*60)+($a2[1]*60));
				$diff = abs($time1-$time2);
				$hours = floor($diff/(60*60));
				$mins = floor(($diff-($hours*60*60))/(60));
				$secs = floor(($diff-(($hours*60*60)+($mins*60))));
				$result = $hours.":".$mins.":".$secs;

				$duration = explode(':',$result);
				$total += $duration[0] * 60;
				$total += $duration[1];
			}

			// Total number of hurs for surgery
			$totalHours = $total / 60;

			// Total time of surgery
			//$date = date('Y-m-d');
			//$split = explode('-',$date);
			// Calculate days of the current month
			//monthDays = cal_days_in_month(CAL_GREGORIAN, $split[1], $split[0]);
			// Get total time alloted for surgery in the current month. per day surgery time is 16 hrs.
			$totalTime = $days * 8;

			// Calculate total utilization rate here formulla: AVG = tota hours/total surgery time*100
			$totalUtilization = $totalHours / $totalTime * 100;
			//pr($totalHours);exit;
			// Get answer up to two decimal places
			$totalUtilization = round($totalUtilization,2);

			//pr($totalUtilization);exit;

			// Set the format of report as per user input of format
			if($format == 'PDF'){

				$this->set('reports',$record);
				$this->set(compact('totalUtilization'));
				$this->render('patient_otutilization_pdf','pdf');
			} else {

				$this->set('reports', $record);
				$this->set(compact('totalUtilization'));
				$this->render('patient_otutilization_excel','patient_otutilization_excel');
			}
		}
		$sergery = $this->Surgery->find('list',array('conditions'=>array('Surgery.location_id'=>$this->Session->read('locationid'))));
		$this->set(compact('sergery'));
	}

	/**
	@Name		 : patient_otutilizationrate_report_chart
	@created for : Observation chart by nursing
	@created by  : ANAND
	@created on  : 2/23/2012
	@modified on :
	**/

	public function admin_otutilizationrate_report_chart(){
		$this->uses = array('Surgery','OptAppointment','Patient','Location','Consultant');
		if(!empty($this->request->data)){
				
			//pr($this->request->data);exit;
			$this->set('title_for_layout', __('Total Ututilizationrate Report Chart', true));
				
				
			$reportYear = $this->request->data['PatientRegistrationReport']['year'];
			$consultantName = '';
			//$reportMonth = $this->request->data['PatientRegistrationReport']['month'];
			$sergery_type = $this->request->data['PatientOtReport']['sergery_type'];
			$sergery_id = $this->request->data['PatientOtReport']['surgery'];
			$fromDate = $reportYear."-01-01"; // set first date of current year
			$toDate = $reportYear."-12-31"; // set last date of current year
				

			//$countRecord = $this->Patient->find('count',array('conditions'=>array($conditions,'Patient.known_fam_physician'=>1,'Patient.consultant_id'=>$reference)));
			if($sergery_type != '' && $sergery_id != ''){

				$takenTimeRegCount = $this->OptAppointment->find('all', array('fields' => array('AVG((TIME_TO_SEC(TIMEDIFF(endtime,starttime)))/60) AS takentimeregcount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'OptAppointment.location_id', 'OptAppointment.id', 'OptAppointment.is_deleted'), 'group' => array("month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('OptAppointment.is_deleted' => 0, 'OptAppointment.location_id' => $this->Session->read('locationid'),'OptAppointment.operation_type'=>$sergery_type,'OptAppointment.surgery_id'=>$sergery_id), 'recursive' => -1));

			} else if($sergery_type == '' && $sergery_id != ''){
				$takenTimeRegCount = $this->OptAppointment->find('all', array('fields' => array('AVG((TIME_TO_SEC(TIMEDIFF(endtime,starttime)))/60) AS takentimeregcount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'OptAppointment.location_id', 'OptAppointment.id', 'OptAppointment.is_deleted'), 'group' => array("month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('OptAppointment.is_deleted' => 0, 'OptAppointment.location_id' => $this->Session->read('locationid'),'OptAppointment.surgery_id'=>$sergery_id), 'recursive' => -1));

			} else if($sergery_type != '' && $sergery_id == ''){
				$takenTimeRegCount = $this->OptAppointment->find('all', array('fields' => array('AVG((TIME_TO_SEC(TIMEDIFF(endtime,starttime)))/60) AS takentimeregcount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'OptAppointment.location_id', 'OptAppointment.id', 'OptAppointment.is_deleted'), 'group' => array("month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('OptAppointment.is_deleted' => 0, 'OptAppointment.location_id' => $this->Session->read('locationid'),'OptAppointment.operation_type'=>$sergery_type), 'recursive' => -1));

			} else if($sergery_type == '' && $sergery_id == ''){
				$takenTimeRegCount = $this->OptAppointment->find('all', array('fields' => array('AVG((TIME_TO_SEC(TIMEDIFF(endtime,starttime)))/60) AS takentimeregcount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'OptAppointment.location_id', 'OptAppointment.id', 'OptAppointment.is_deleted'), 'group' => array("month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('OptAppointment.is_deleted' => 0, 'OptAppointment.location_id' => $this->Session->read('locationid')), 'recursive' => -1));
			}

			// Get the total hours of surgery

			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}

			foreach($takenTimeRegCount as $takenTimeRegCountVal) {
				$filterRecordDateArray[] = $takenTimeRegCountVal[0]['month_reports'];
				$filterRecordCountArray[$takenTimeRegCountVal[0]['month_reports']] = $takenTimeRegCountVal[0]['takentimeregcount'];
			}
			 
		}

		//pr($filterRecordCountArray);exit;

		$this->set('filterRecordDateArray', isset($filterRecordDateArray)?$filterRecordDateArray:"");
		$this->set('filterRecordCountArray', isset($filterRecordCountArray)?$filterRecordCountArray:0);
		$this->set('yaxisArray', $yaxisArray);
		$this->set('reportYear',$reportYear);
		$this->set(compact('payment_category'));
		$this->set(compact('countRecord'));
		$this->set(compact('reportMonth'));
	}

	/**
	 * get insurance type by xmlhttprequest
	 *
	 */
	public function getInsuranceTypeList() {
		$this->loadModel('InsuranceType');
		if($this->params['isAjax']) {
			$this->set('insurancetypelist', $this->InsuranceType->find('all', array('fields'=> array('id', 'name'),'conditions' => array('InsuranceType.is_deleted' => 0, 'InsuranceType.credit_type_id' => $this->params->query['paymentCategoryId']))));
			$this->layout = 'ajax';
			$this->render('/Persons/ajaxgetinsurancetypes');
		}
	}


	/**
	 * get insurance company by xmlhttprequest
	 *
	 */
	public function getInsuranceCompanyList() {
		$this->loadModel('InsuranceCompany');
		if($this->params['isAjax']) {
			$this->set('insurancecompanylist', $this->InsuranceCompany->find('all', array('fields'=> array('id', 'name'),'conditions' => array('InsuranceCompany.is_deleted' => 0, 'InsuranceCompany.insurance_type_id' => $this->params->query['insurancetypeid']))));
			$this->layout = 'ajax';
			$this->render('/Persons/ajaxgetinsurancecompanies');
		}
	}

	/**
	 * get corporate by xmlhttprequest
	 *
	 */
	public function getCorporateList() {
		$this->loadModel('Corporate');
		if($this->params['isAjax']) {
			$this->set('corporatelist', $this->Corporate->find('all', array('fields'=> array('id', 'name'),'conditions' => array('Corporate.is_deleted' => 0, 'Corporate.corporate_location_id' => $this->params->query['ajaxcorporatelocationid']))));
			$this->layout = 'ajax';
			$this->render('/Persons/ajaxgetcorporate');
		}
	}

	/**
	 * get corporate by xmlhttprequest
	 *
	 */
	public function getCorporateSublocList() {
		$this->loadModel('CorporateSublocation');
		if($this->params['isAjax']) {
			$this->set('corporatesulloclist', $this->CorporateSublocation->find('all', array('fields'=> array('id', 'name'),'conditions' => array('CorporateSublocation.is_deleted' => 0, 'CorporateSublocation.corporate_id' => $this->params->query['ajaxcorporateid']))));
			$this->layout = 'ajax';
			$this->render('/Persons/ajaxgetcorporatesubloc');
		}
	}


	/**
	 * get payment type by xmlhttprequest
	 *
	 */
	public function getPaymentType() {
		if($this->params['isAjax']) {
			$paytype = $this->params->query['paymentType'];

			if($paytype == "card") {
				$this->render('ajaxgetcredittype');
			}else{
				$this->render('ajaxgetcashtype');
			}
			$this->layout = 'ajax';
		}
	}


	function week_number($date)
	{
		return idate('W', strtotime($date));
	}

	function get_week($weeknum,$date) {
		$currentDay = date($weeknum);
		if($currentDay == 'Monday'){
			$timestampFirstDay = strtotime('monday',$date);
		}else{
			$timestampFirstDay = strtotime('last monday',$date);
		}

		/*$currentDay = $timestampFirstDay;
		 $weekArray=array();
		 for ($i = 0 ; $i < 7 ; $i++) {
		 array_push($weekArray, date('Y-m-d', $currentDay));
		 $currentDay += 24 * 3600;
		 }*/
		return $timestampFirstDay;
	}


	public function getselected(){
		$this->uses = array('City','State','Country');
		if($this->params['isAjax']) {
			$field_name = $this->params->query['field_name'];
			//pr($this->params->query);exit;
			if($field_name == 'Sex'){
				$options = array('Male'=>'Male','Female'=>'Female');
			} else if($field_name == 'Blood Group'){
				$options = array('+A'=>'A Positive','-A'=>'A Negative','+B'=>'B Positive','-B'=>'B Negative','+AB'=>'AB Positive','-AB'=>'AB Negative','+O'=>'O Positive','-O'=>'O Negative');
			} else if($field_name == 'City'){
				$options = $this->City->find('list');
			} else if($field_name == 'State'){
				$options = $this->State->find('list');
			} else if($field_name == 'Country'){
				$options = $this->Country->find('list');
			} else {
				$options = '';
			}

			$this->set(compact('options'));
			$this->layout = 'ajax';
			$this->render('ajaxgetselected');
		}

	}


	//BOF pankaj
	function admin_ipd_opd(){
		$this->uses = array('Patient');
		if($this->request->data){
				
			$this->set('report_title','Patient report- type wise');
			$format = $this->request->data['Report']['format'];
			$search_ele  = $this->request->data['Report'];
			$this->Patient->bindModel(array(
 								'belongsTo' => array( 											 
														'Location' =>array('foreignKey' => 'location_id'),
			   'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
    		                                             'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
			)),false);
			$search_key = array('Patient.is_deleted'=>0,'Patient.location_id'=>$this->Session->read('locationid'));

			if(!empty($search_ele['from']) && !empty($search_ele['to'])){
				//$last_split_date_time = explode(" ",$search_ele['from']);
				$search_ele['from'] = $this->DateFormat->formatDate2STDForReport($search_ele['from'],Configure::read('date_format'));

				//$last_split_date_time = explode(" ",$search_ele['to']);
				$search_ele['to'] = $this->DateFormat->formatDate2STDForReport($search_ele['to'],Configure::read('date_format'))." 23:59:59";
				$search_key['Patient.create_time BETWEEN ? and ?']=array($search_ele['from'],$search_ele['to']);
			}
				
			if(!empty($search_ele['type'])){
				$search_key['Patient.admission_type'] = $search_ele['type'] ;
			}

			$fields =array('PatientInitial.name','id','Patient.lookup_name','Patient.admission_id','Patient.patient_id','Patient.admission_type','Patient.form_received_on','Patient.form_completed_on','create_time','doc_ini_assess_on','nurse_assess_on','nurse_assess_end_on','credit_type_id');
			$record = $this->Patient->find('all',array('fields'=>$fields,'conditions'=>$search_key));
			 
			 

			if($format=='GRAPH'){
				$this->set('reports',$record);
				$this->render('ipd_opd_chart');
			}else{
				if($format == 'PDF'){
					$this->set('reports',$record);
					//$this->layout = 'pdf'; //this will use the pdf.ctp layout
					$this->render('ipd_opd_pdf','pdf');
				} else {
					$this->set('reports', $record);
					$this->render('ipd_opd_excel','');
				}
			}
		}
		//retrive the last yr in db
		$this->Patient->recursive = -1 ;
		$last = $this->Patient->find('first',array('fields'=>array('create_time'),'order'=>'create_time desc'));
		$this->set('endyear',date('Y',strtotime($last['Patient']['create_time']))) ;
	}
	//EOF pankaj

	public function admin_haicent_reports() {
		$this->set('title_for_layout', __('Hospital Acquire Infections Reports', true));
		$this->uses = array('NosocomialInfection', 'PatientExposure');
		$ssiCount = $this->NosocomialInfection->find('all', array('fields' => array('COUNT(*) AS ssicount', 'NosocomialInfection.surgical_site_infection', 'NosocomialInfection.location_id', 'NosocomialInfection.id'), 'conditions' => array('NosocomialInfection.location_id' => $this->Session->read('locationid'), 'NosocomialInfection.surgical_site_infection' => 'Yes'), 'group' => array('surgical_site_infection')));
		$this->set('ssiCount', $ssiCount);
		$vapCount = $this->NosocomialInfection->find('all', array('fields' => array('COUNT(*) AS vapcount', 'NosocomialInfection.ventilator_associated_pneumonia', 'NosocomialInfection.location_id', 'NosocomialInfection.id'), 'conditions' => array('NosocomialInfection.location_id' => $this->Session->read('locationid'), 'NosocomialInfection.ventilator_associated_pneumonia' => 'Yes'), 'group' => array('ventilator_associated_pneumonia')));
		$this->set('vapCount', $vapCount);
		$utiCount = $this->NosocomialInfection->find('all', array('fields' => array('COUNT(*) AS uticount', 'NosocomialInfection.urinary_tract_infection', 'NosocomialInfection.location_id', 'NosocomialInfection.id'), 'conditions' => array('NosocomialInfection.location_id' => $this->Session->read('locationid'), 'NosocomialInfection.urinary_tract_infection' => 'Yes'), 'group' => array('urinary_tract_infection')));
		$this->set('utiCount', $utiCount);
		$bsiCount = $this->NosocomialInfection->find('all', array('fields' => array('COUNT(*) AS bsicount', 'NosocomialInfection.clabsi', 'NosocomialInfection.location_id', 'NosocomialInfection.id'), 'conditions' => array('NosocomialInfection.location_id' => $this->Session->read('locationid'), 'NosocomialInfection.clabsi' => 'Yes'), 'group' => array('clabsi')));
		$this->set('bsiCount', $bsiCount);
		$thromboCount = $this->NosocomialInfection->find('all', array('fields' => array('COUNT(*) AS thrombocount', 'NosocomialInfection.thrombophlebitis', 'NosocomialInfection.location_id', 'NosocomialInfection.id'), 'conditions' => array('NosocomialInfection.location_id' => $this->Session->read('locationid'), 'NosocomialInfection.thrombophlebitis' => 'Yes'), 'group' => array('thrombophlebitis')));
		$this->set('thromboCount', $thromboCount);

	}

	public function admin_haicent_xlsreports() {
		$this->set('title_for_layout', __('Hospital Acquire Infections Reports', true));
		$this->uses = array('NosocomialInfection', 'PatientExposure');

		$ssiCount = $this->NosocomialInfection->find('all', array('fields' => array('COUNT(*) AS ssicount', 'NosocomialInfection.surgical_site_infection', 'NosocomialInfection.location_id', 'NosocomialInfection.id'), 'conditions' => array('NosocomialInfection.location_id' => $this->Session->read('locationid'), 'NosocomialInfection.surgical_site_infection' => 'Yes'), 'group' => array('surgical_site_infection')));
		$this->set('ssiCount', $ssiCount);
		$vapCount = $this->NosocomialInfection->find('all', array('fields' => array('COUNT(*) AS vapcount', 'NosocomialInfection.ventilator_associated_pneumonia', 'NosocomialInfection.location_id', 'NosocomialInfection.id'), 'conditions' => array('NosocomialInfection.location_id' => $this->Session->read('locationid'), 'NosocomialInfection.ventilator_associated_pneumonia' => 'Yes'), 'group' => array('ventilator_associated_pneumonia')));
		$this->set('vapCount', $vapCount);
		$utiCount = $this->NosocomialInfection->find('all', array('fields' => array('COUNT(*) AS uticount', 'NosocomialInfection.urinary_tract_infection', 'NosocomialInfection.location_id', 'NosocomialInfection.id'), 'conditions' => array('NosocomialInfection.location_id' => $this->Session->read('locationid'), 'NosocomialInfection.urinary_tract_infection' => 'Yes'), 'group' => array('urinary_tract_infection')));
		$this->set('utiCount', $utiCount);
		$bsiCount = $this->NosocomialInfection->find('all', array('fields' => array('COUNT(*) AS bsicount', 'NosocomialInfection.clabsi', 'NosocomialInfection.location_id', 'NosocomialInfection.id'), 'conditions' => array('NosocomialInfection.location_id' => $this->Session->read('locationid'), 'NosocomialInfection.clabsi' => 'Yes'), 'group' => array('clabsi')));
		$this->set('bsiCount', $bsiCount);
		$thromboCount = $this->NosocomialInfection->find('all', array('fields' => array('COUNT(*) AS thrombocount', 'NosocomialInfection.thrombophlebitis', 'NosocomialInfection.location_id', 'NosocomialInfection.id'), 'conditions' => array('NosocomialInfection.location_id' => $this->Session->read('locationid'), 'NosocomialInfection.thrombophlebitis' => 'Yes'), 'group' => array('thrombophlebitis')));
		$this->set('thromboCount', $thromboCount);
		$this->layout = false;
	}
	 
	public function all_report() {
		 
	}
	 
	/**
	 *
	 * ssi rate percentage reports
	 *
	 **/

	public function admin_ssirate_reports() {
		$this->uses = array('NosocomialInfection', 'OptAppointment');
		//$ssiCount = $this->SurgicalSiteInfection->find('all', array('fields' => array('COUNT(*) AS ssicount', 'SurgicalSiteInfection.location_id'), 'conditions' => array('SurgicalSiteInfection.location_id' => $this->Session->read('locationid'), 'SurgicalSiteInfection.is_deleted' => 0), 'group' => array('location_id'),'recursive' => -1));
		$ssiCount = $this->NosocomialInfection->find('all', array('fields' => array('COUNT(*) AS ssicount', 'NosocomialInfection.surgical_site_infection', 'NosocomialInfection.location_id', 'NosocomialInfection.id'), 'conditions' => array('NosocomialInfection.location_id' => $this->Session->read('locationid'), 'NosocomialInfection.surgical_site_infection' => 'Yes'), 'group' => array('surgical_site_infection')));
		$this->set('ssiCount', $ssiCount);
		$this->set('ssiCount', $ssiCount);
		$spYesCount = $this->OptAppointment->find('all', array('fields' => array('COUNT(*) AS spYescount', 'OptAppointment.location_id'), 'conditions' => array('OptAppointment.location_id' => $this->Session->read('locationid'), 'OptAppointment.procedure_complete' => 1, 'OptAppointment.is_deleted' => 0), 'group' => array('location_id'),'recursive' => -1));
		$this->set('spYesCount', $spYesCount);
		 
	}

	/**
	 *
	 * ssi rate xls reports
	 *
	 **/

	public function admin_ssirate_xlsreports() {
		$this->uses = array('NosocomialInfection', 'OptAppointment');
		//$ssiCount = $this->SurgicalSiteInfection->find('all', array('fields' => array('COUNT(*) AS ssicount', 'SurgicalSiteInfection.location_id'), 'conditions' => array('SurgicalSiteInfection.location_id' => $this->Session->read('locationid'), 'SurgicalSiteInfection.is_deleted' => 0), 'group' => array('location_id'),'recursive' => -1));
		$ssiCount = $this->NosocomialInfection->find('all', array('fields' => array('COUNT(*) AS ssicount', 'NosocomialInfection.surgical_site_infection', 'NosocomialInfection.location_id', 'NosocomialInfection.id'), 'conditions' => array('NosocomialInfection.location_id' => $this->Session->read('locationid'), 'NosocomialInfection.surgical_site_infection' => 'Yes'), 'group' => array('surgical_site_infection')));
		$this->set('ssiCount', $ssiCount);
		$this->set('ssiCount', $ssiCount);
		$spYesCount = $this->OptAppointment->find('all', array('fields' => array('COUNT(*) AS spYescount', 'OptAppointment.location_id'), 'conditions' => array('OptAppointment.location_id' => $this->Session->read('locationid'), 'OptAppointment.procedure_complete' => 1, 'OptAppointment.is_deleted' => 0), 'group' => array('location_id'),'recursive' => -1));
		$this->set('spYesCount', $spYesCount);
		$this->layout = false;
	}

	/**
	 *
	 * uti rate percentage reports
	 *
	 **/

	public function admin_utirate_reports() {
		$this->uses = array('NosocomialInfection', 'PatientExposure');
		$utiCount = $this->NosocomialInfection->find('all', array('fields' => array('COUNT(*) AS uticount', 'NosocomialInfection.urinary_tract_infection', 'NosocomialInfection.location_id', 'NosocomialInfection.id'), 'conditions' => array('NosocomialInfection.location_id' => $this->Session->read('locationid'), 'NosocomialInfection.urinary_tract_infection' => 'Yes'), 'group' => array('urinary_tract_infection')));
		$this->set('utiCount', $utiCount);
		$ucCount = $this->PatientExposure->find('all', array('fields' => array('COUNT(*) AS uccount', 'PatientExposure.urinary_catheter', 'PatientExposure.location_id', 'PatientExposure.id'), 'conditions' => array('PatientExposure.location_id' => $this->Session->read('locationid'), 'PatientExposure.urinary_catheter' => 'Yes'), 'group' => array('urinary_catheter')));
		$this->set('ucCount', $ucCount);
		 
	}

	/**
	 *
	 * uti rate xls reports
	 *
	 **/

	public function admin_utirate_xlsreports() {
		$this->uses = array('NosocomialInfection', 'PatientExposure');
		$utiCount = $this->NosocomialInfection->find('all', array('fields' => array('COUNT(*) AS uticount', 'NosocomialInfection.urinary_tract_infection', 'NosocomialInfection.location_id', 'NosocomialInfection.id'), 'conditions' => array('NosocomialInfection.location_id' => $this->Session->read('locationid'), 'NosocomialInfection.urinary_tract_infection' => 'Yes'), 'group' => array('urinary_tract_infection')));
		$this->set('utiCount', $utiCount);
		$ucCount = $this->PatientExposure->find('all', array('fields' => array('COUNT(*) AS uccount', 'PatientExposure.urinary_catheter', 'PatientExposure.location_id', 'PatientExposure.id'), 'conditions' => array('PatientExposure.location_id' => $this->Session->read('locationid'), 'PatientExposure.urinary_catheter' => 'Yes'), 'group' => array('urinary_catheter')));
		$this->set('ucCount', $ucCount);
		$this->layout = false;
	}

	/**
	 *
	 * vap rate percentage reports
	 *
	 **/

	public function admin_vaprate_reports() {
		$this->uses = array('NosocomialInfection', 'PatientExposure');
		$vapCount = $this->NosocomialInfection->find('all', array('fields' => array('COUNT(*) AS vapcount', 'NosocomialInfection.ventilator_associated_pneumonia', 'NosocomialInfection.location_id', 'NosocomialInfection.id'), 'conditions' => array('NosocomialInfection.location_id' => $this->Session->read('locationid'), 'NosocomialInfection.ventilator_associated_pneumonia' => 'Yes'), 'group' => array('ventilator_associated_pneumonia')));
		$this->set('vapCount', $vapCount);
		$mvCount = $this->PatientExposure->find('all', array('fields' => array('COUNT(*) AS mvcount', 'PatientExposure.mechanical_ventilation', 'PatientExposure.location_id', 'PatientExposure.id'), 'conditions' => array('PatientExposure.location_id' => $this->Session->read('locationid'), 'PatientExposure.mechanical_ventilation' => 'Yes'), 'group' => array('mechanical_ventilation')));
		$this->set('mvCount', $mvCount);
	}

	/**
	 *
	 * vap rate xls reports
	 *
	 **/

	public function admin_vaprate_xlsreports() {
		$this->uses = array('NosocomialInfection', 'PatientExposure');
		$vapCount = $this->NosocomialInfection->find('all', array('fields' => array('COUNT(*) AS vapcount', 'NosocomialInfection.ventilator_associated_pneumonia', 'NosocomialInfection.location_id', 'NosocomialInfection.id'), 'conditions' => array('NosocomialInfection.location_id' => $this->Session->read('locationid'), 'NosocomialInfection.ventilator_associated_pneumonia' => 'Yes'), 'group' => array('ventilator_associated_pneumonia')));
		$this->set('vapCount', $vapCount);
		$mvCount = $this->PatientExposure->find('all', array('fields' => array('COUNT(*) AS mvcount', 'PatientExposure.mechanical_ventilation', 'PatientExposure.location_id', 'PatientExposure.id'), 'conditions' => array('PatientExposure.location_id' => $this->Session->read('locationid'), 'PatientExposure.mechanical_ventilation' => 'Yes'), 'group' => array('mechanical_ventilation')));
		$this->set('mvCount', $mvCount);
		$this->layout = false;
	}

	/**
	 *
	 * bsi rate percentage reports
	 *
	 **/

	public function admin_bsirate_reports() {
		$this->uses = array('NosocomialInfection', 'PatientExposure');
		$bsiCount = $this->NosocomialInfection->find('all', array('fields' => array('COUNT(*) AS bsicount', 'NosocomialInfection.clabsi', 'NosocomialInfection.location_id', 'NosocomialInfection.id'), 'conditions' => array('NosocomialInfection.location_id' => $this->Session->read('locationid'), 'NosocomialInfection.clabsi' => 'Yes'), 'group' => array('clabsi')));
		$this->set('bsiCount', $bsiCount);
		$clCount = $this->PatientExposure->find('all', array('fields' => array('COUNT(*) AS clcount', 'PatientExposure.central_line', 'PatientExposure.location_id', 'PatientExposure.id'), 'conditions' => array('PatientExposure.location_id' => $this->Session->read('locationid'), 'PatientExposure.central_line' => 'Yes'), 'group' => array('central_line')));
		$this->set('clCount', $clCount);
		 
	}

	/**
	 *
	 * bsi rate xls reports
	 *
	 **/

	public function admin_bsirate_xlsreports() {
		$this->uses = array('NosocomialInfection', 'PatientExposure');
		$bsiCount = $this->NosocomialInfection->find('all', array('fields' => array('COUNT(*) AS bsicount', 'NosocomialInfection.clabsi', 'NosocomialInfection.location_id', 'NosocomialInfection.id'), 'conditions' => array('NosocomialInfection.location_id' => $this->Session->read('locationid'), 'NosocomialInfection.clabsi' => 'Yes'), 'group' => array('clabsi')));
		$this->set('bsiCount', $bsiCount);
		$clCount = $this->PatientExposure->find('all', array('fields' => array('COUNT(*) AS clcount', 'PatientExposure.central_line', 'PatientExposure.location_id', 'PatientExposure.id'), 'conditions' => array('PatientExposure.location_id' => $this->Session->read('locationid'), 'PatientExposure.central_line' => 'Yes'), 'group' => array('central_line')));
		$this->set('clCount', $clCount);
		$this->layout = false;
	}

	/**
	 *
	 * thrombo rate percentage reports
	 *
	 **/

	public function admin_thrombophlebitisrate_reports() {
		$this->uses = array('NosocomialInfection', 'PatientExposure');
		$thromboCount = $this->NosocomialInfection->find('all', array('fields' => array('COUNT(*) AS thrombocount', 'NosocomialInfection.thrombophlebitis', 'NosocomialInfection.location_id', 'NosocomialInfection.id'), 'conditions' => array('NosocomialInfection.location_id' => $this->Session->read('locationid'), 'NosocomialInfection.thrombophlebitis' => 'Yes'), 'group' => array('thrombophlebitis')));
		$this->set('thromboCount', $thromboCount);
		$plCount = $this->PatientExposure->find('all', array('fields' => array('COUNT(*) AS plcount', 'PatientExposure.peripheral_line', 'PatientExposure.location_id', 'PatientExposure.id'), 'conditions' => array('PatientExposure.location_id' => $this->Session->read('locationid'), 'PatientExposure.peripheral_line' => 'Yes'), 'group' => array('peripheral_line')));
		$this->set('plCount', $plCount);
		 
	}

	/**
	 *
	 * thrombo rate xls reports
	 *
	 **/

	public function admin_thrombophlebitisrate_xlsreports() {
		$this->uses = array('NosocomialInfection', 'PatientExposure');
		$thromboCount = $this->NosocomialInfection->find('all', array('fields' => array('COUNT(*) AS thrombocount', 'NosocomialInfection.thrombophlebitis', 'NosocomialInfection.location_id', 'NosocomialInfection.id'), 'conditions' => array('NosocomialInfection.location_id' => $this->Session->read('locationid'), 'NosocomialInfection.thrombophlebitis' => 'Yes'), 'group' => array('thrombophlebitis')));
		$this->set('thromboCount', $thromboCount);
		$plCount = $this->PatientExposure->find('all', array('fields' => array('COUNT(*) AS plcount', 'PatientExposure.peripheral_line', 'PatientExposure.location_id', 'PatientExposure.id'), 'conditions' => array('PatientExposure.location_id' => $this->Session->read('locationid'), 'PatientExposure.peripheral_line' => 'Yes'), 'group' => array('peripheral_line')));
		$this->set('plCount', $plCount);
		$this->layout = false;
	}

	/**
	 * hospital acquire infections reports chart
	 *
	 */


	public function admin_hai_reports_chart() {
		$this->set('title_for_layout', __('Hospital Associated Infections Reports Chart', true));
		if ($this->request->is('post')) {
			$reportType = $this->request->data['reportType'];
			$reportYear = $this->request->data['reportYear'];
			$reportMonth = $this->request->data['reportMonth'];
			$fromDate = $reportYear."-01-01"; // set first date of current year
			$toDate = $reportYear."-12-31"; // set last date of current year
			$this->hai_allreports($fromDate,$toDate);
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
		}

		$this->set('yaxisArray', $yaxisArray);
		$this->set('reportType', $reportType);
	}


	/**
	 * hospital acquire infections xls reports
	 *
	 */

	public function admin_hai_xlsreports() {
		$this->set('title_for_layout', __('Hospital Acquire Infections Reports', true));
		if ($this->request->is('post')) {
			$reportType = $this->request->data['reportType'];
			$reportYear = $this->request->data['reportYear'];
			$reportMonth = $this->request->data['reportMonth'];
			// if month is selected //
			if(!empty($reportMonth)) {
				// if report type cases or rate is selected //
				if($reportType == 1 || $reportType == 2) {
					$startDate=1;
					$countDays = cal_days_in_month(CAL_GREGORIAN, $reportMonth, $reportYear);
					while($startDate <= $countDays) {
						$dateVal = $reportYear."-".$reportMonth."-".$startDate;
						$yaxisIndex = date("d-F", strtotime($dateVal));
						$yaxisArray[$yaxisIndex] = date("d-F-Y", strtotime($dateVal));
						$startDate++;
					}

					$this->hai_monthcases($yaxisArray,$reportYear);
					$this->set('yaxisArray', $yaxisArray);
				}
				 
				// if month is not selected //
			} else {
				$fromDate = $reportYear."-01-01"; // set first date of current year
				$toDate = $reportYear."-12-31"; // set last date of current year
				$this->hai_allreports($fromDate,$toDate);
				while($toDate > $fromDate) {
					$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
					$expfromdate = explode("-", $fromDate);
					$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
				}
				$this->set('yaxisArray', $yaxisArray);

			}
		}
		$this->set('reportType', isset($this->request->data['reportType'])?$this->request->data['reportType']:"1"); // 1 for number of cases
		$this->set('reportYear', isset($this->request->data['reportYear'])?$this->request->data['reportYear']:date("Y"));
		$this->set('reportMonth', isset($this->request->data['reportMonth'])?$this->request->data['reportMonth']:"");
		$this->layout = false;
	}
	/**
	 * hospital acquire infections survey reports
	 *
	 */

	public function admin_hospital_acquire_infections_reports() {
		$this->set('title_for_layout', __('Hospital Associated Infections Cases', true));
		if ($this->request->is('post')) {
			$reportType = $this->request->data['reportType'];
			$reportYear = $this->request->data['reportYear'];
			$reportMonth = $this->request->data['reportMonth'];
			// if month is selected //
			if(!empty($reportMonth)) {
				// if report type cases or rate is selected //
				if($reportType == 1 || $reportType == 2) {
					$startDate=1;
					$countDays = cal_days_in_month(CAL_GREGORIAN, $reportMonth, $reportYear);
					while($startDate <= $countDays) {
						$dateVal = $reportYear."-".$reportMonth."-".$startDate;
						$yaxisIndex = date("d-F", strtotime($dateVal));
						$yaxisArray[$yaxisIndex] = date("d-F-Y", strtotime($dateVal));
						$startDate++;
					}

					$this->hai_monthcases($yaxisArray,$reportYear);
					$this->set('yaxisArray', $yaxisArray);
				}
				 
				// if month is not selected //
			} else {
				$fromDate = $reportYear."-01-01"; // set first date of current year
				$toDate = $reportYear."-12-31"; // set last date of current year
				$this->hai_allreports($fromDate,$toDate);
				while($toDate > $fromDate) {
					$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
					$expfromdate = explode("-", $fromDate);
					$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
				}
				$this->set('yaxisArray', $yaxisArray);

			}
		} else {
			$fromDate = date("Y")."-01-01"; // set first date of current year
			$toDate = date("Y")."-12-31"; // set last date of current year
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray', $yaxisArray);
			$this->hai_allreports();

		}
		$this->set('reportType', isset($this->request->data['reportType'])?$this->request->data['reportType']:"1"); // 1 for number of cases
		$this->set('reportYear', isset($this->request->data['reportYear'])?$this->request->data['reportYear']:date("Y"));
		$this->set('reportMonth', isset($this->request->data['reportMonth'])?$this->request->data['reportMonth']:"");

	}


	/**
	 * hospital acquire infections survey  filter by month and reprt type is cases
	 *
	 */

	private function hai_monthcases($yaxisArray, $reportYear) {
		$this->uses = array('NosocomialInfection', 'PatientExposure');
		$assignIndex = array_keys($yaxisArray);
		$firstDate = date("Y-m-d", strtotime($yaxisArray[$assignIndex[0]]."-".$reportYear));
		$lastDate = date("Y-m-d", strtotime($yaxisArray[$assignIndex[count($yaxisArray)-1]]."-".$reportYear));

		$ssiCount = $this->NosocomialInfection->find('all', array('fields' => array('COUNT(*) AS ssicount', 'DATE_FORMAT(submit_date, "%d-%M") AS day_reports', 'NosocomialInfection.surgical_site_infection', 'submit_date', 'NosocomialInfection.location_id', 'NosocomialInfection.id'), 'conditions' => array('NosocomialInfection.location_id' => $this->Session->read('locationid'), 'NosocomialInfection.surgical_site_infection' => 'Yes','NosocomialInfection.submit_date BETWEEN ? AND ?' => array($firstDate, $lastDate)), 'group' => array('submit_date')));
		foreach($ssiCount as $ssiCountVal) {
			$filterSsiDateArray[] = $ssiCountVal[0]['day_reports'];
			$filterSsiCountArray[$ssiCountVal[0]['day_reports']] = $ssiCountVal[0]['ssicount'];
		}
		$this->set('filterSsiDateArray', isset($filterSsiDateArray)?$filterSsiDateArray:"");
		$this->set('filterSsiCountArray', isset($filterSsiCountArray)?$filterSsiCountArray:0);

		$spCount = $this->PatientExposure->find('all', array('fields' => array('COUNT(*) AS spcount', 'DATE_FORMAT(submit_date, "%d-%M") AS day_reports', 'PatientExposure.surgical_procedure', 'submit_date', 'PatientExposure.location_id', 'PatientExposure.id'), 'conditions' => array('PatientExposure.location_id' => $this->Session->read('locationid'), 'PatientExposure.surgical_procedure' => 'Yes','PatientExposure.submit_date BETWEEN ? AND ?' => array($firstDate, $lastDate)), 'group' => array('submit_date')));
		foreach($spCount as $spCountVal) {
			$filterSpDateArray[] = $spCountVal[0]['day_reports'];
			$filterSpCountArray[$spCountVal[0]['day_reports']] = $spCountVal[0]['spcount'];
		}
		$this->set('filterSpDateArray', isset($filterSpDateArray)?$filterSpDateArray:"");
		$this->set('filterSpCountArray', isset($filterSpCountArray)?$filterSpCountArray:0);

		 
		$vapCount = $this->NosocomialInfection->find('all', array('fields' => array('COUNT(*) AS vapcount', 'DATE_FORMAT(submit_date, "%d-%M") AS day_reports', 'NosocomialInfection.ventilator_associated_pneumonia', 'submit_date', 'NosocomialInfection.location_id', 'NosocomialInfection.id'), 'conditions' => array('NosocomialInfection.location_id' => $this->Session->read('locationid'), 'NosocomialInfection.ventilator_associated_pneumonia' => 'Yes','NosocomialInfection.submit_date BETWEEN ? AND ?' => array($firstDate, $lastDate)), 'group' => array('submit_date')));
		foreach($vapCount as $vapCountVal) {
			$filterVapDateArray[] = $vapCountVal[0]['day_reports'];
			$filterVapCountArray[$vapCountVal[0]['day_reports']] = $vapCountVal[0]['vapcount'];
		}
		$this->set('filterVapDateArray', isset($filterVapDateArray)?$filterVapDateArray:"");
		$this->set('filterVapCountArray', isset($filterVapCountArray)?$filterVapCountArray:0);

		$mvCount = $this->PatientExposure->find('all', array('fields' => array('COUNT(*) AS mvcount', 'DATE_FORMAT(submit_date, "%d-%M") AS day_reports', 'PatientExposure.mechanical_ventilation', 'submit_date', 'PatientExposure.location_id', 'PatientExposure.id'), 'conditions' => array('PatientExposure.location_id' => $this->Session->read('locationid'), 'PatientExposure.mechanical_ventilation' => 'Yes','PatientExposure.submit_date BETWEEN ? AND ?' => array($firstDate, $lastDate)), 'group' => array('submit_date')));
		foreach($mvCount as $mvCountVal) {
			$filterMvDateArray[] = $mvCountVal[0]['day_reports'];
			$filterMvCountArray[$mvCountVal[0]['day_reports']] = $mvCountVal[0]['mvcount'];
		}

		$this->set('filterMvDateArray', isset($filterMvDateArray)?$filterMvDateArray:"");
		$this->set('filterMvCountArray', isset($filterMvCountArray)?$filterMvCountArray:0);

		$utiCount = $this->NosocomialInfection->find('all', array('fields' => array('COUNT(*) AS uticount', 'DATE_FORMAT(submit_date, "%d-%M") AS day_reports', 'NosocomialInfection.urinary_tract_infection', 'submit_date', 'NosocomialInfection.location_id', 'NosocomialInfection.id'), 'conditions' => array('NosocomialInfection.location_id' => $this->Session->read('locationid'), 'NosocomialInfection.urinary_tract_infection' => 'Yes','NosocomialInfection.submit_date BETWEEN ? AND ?' => array($firstDate, $lastDate)), 'group' => array('submit_date')));
		foreach($utiCount as $utiCountVal) {
			$filterUtiDateArray[] = $utiCountVal[0]['day_reports'];
			$filterUtiCountArray[$utiCountVal[0]['day_reports']] = $utiCountVal[0]['uticount'];
		}
		$this->set('filterUtiDateArray', isset($filterUtiDateArray)?$filterUtiDateArray:"");
		$this->set('filterUtiCountArray', isset($filterUtiCountArray)?$filterUtiCountArray:0);

		$ucCount = $this->PatientExposure->find('all', array('fields' => array('COUNT(*) AS uccount', 'DATE_FORMAT(submit_date, "%d-%M") AS day_reports', 'PatientExposure.urinary_catheter', 'submit_date', 'PatientExposure.location_id', 'PatientExposure.id'), 'conditions' => array('PatientExposure.location_id' => $this->Session->read('locationid'), 'PatientExposure.urinary_catheter' => 'Yes','PatientExposure.submit_date BETWEEN ? AND ?' => array($firstDate, $lastDate)), 'group' => array('submit_date')));
		foreach($ucCount as $ucCountVal) {
			$filterUcDateArray[] = $ucCountVal[0]['day_reports'];
			$filterUcCountArray[$ucCountVal[0]['day_reports']] = $ucCountVal[0]['uccount'];
		}
		$this->set('filterUcDateArray', isset($filterUcDateArray)?$filterUcDateArray:"");
		$this->set('filterUcCountArray', isset($filterUcCountArray)?$filterUcCountArray:0);

		$bsiCount = $this->NosocomialInfection->find('all', array('fields' => array('COUNT(*) AS bsicount', 'DATE_FORMAT(submit_date, "%d-%M") AS day_reports', 'NosocomialInfection.clabsi', 'submit_date', 'NosocomialInfection.location_id', 'NosocomialInfection.id'), 'conditions' => array('NosocomialInfection.location_id' => $this->Session->read('locationid'), 'NosocomialInfection.clabsi' => 'Yes','NosocomialInfection.submit_date BETWEEN ? AND ?' => array($firstDate, $lastDate)), 'group' => array('submit_date')));
		foreach($bsiCount as $bsiCountVal) {
			$filterBsiDateArray[] = $bsiCountVal[0]['day_reports'];
			$filterBsiCountArray[$bsiCountVal[0]['day_reports']] = $bsiCountVal[0]['bsicount'];
		}
		$this->set('filterBsiDateArray', isset($filterBsiDateArray)?$filterBsiDateArray:"");
		$this->set('filterBsiCountArray', isset($filterBsiCountArray)?$filterBsiCountArray:0);

		$clCount = $this->PatientExposure->find('all', array('fields' => array('COUNT(*) AS clcount', 'DATE_FORMAT(submit_date, "%d-%M") AS day_reports', 'PatientExposure.central_line', 'submit_date', 'PatientExposure.location_id', 'PatientExposure.id'), 'conditions' => array('PatientExposure.location_id' => $this->Session->read('locationid'), 'PatientExposure.central_line' => 'Yes','PatientExposure.submit_date BETWEEN ? AND ?' => array($firstDate, $lastDate)), 'group' => array('submit_date')));
		foreach($clCount as $clCountVal) {
			$filterClDateArray[] = $clCountVal[0]['day_reports'];
			$filterClCountArray[$clCountVal[0]['day_reports']] = $clCountVal[0]['clcount'];
		}
		$this->set('filterClDateArray', isset($filterClDateArray)?$filterClDateArray:"");
		$this->set('filterClCountArray', isset($filterClCountArray)?$filterClCountArray:0);

		$thromboCount = $this->NosocomialInfection->find('all', array('fields' => array('COUNT(*) AS thrombocount', 'DATE_FORMAT(submit_date, "%d-%M") AS day_reports', 'NosocomialInfection.thrombophlebitis', 'submit_date', 'NosocomialInfection.location_id', 'NosocomialInfection.id'), 'conditions' => array('NosocomialInfection.location_id' => $this->Session->read('locationid'), 'NosocomialInfection.thrombophlebitis' => 'Yes','NosocomialInfection.submit_date BETWEEN ? AND ?' => array($firstDate, $lastDate)), 'group' => array('submit_date')));
		foreach($thromboCount as $thromboCountVal) {
			$filterThromboDateArray[] = $thromboCountVal[0]['day_reports'];
			$filterThromboCountArray[$thromboCountVal[0]['day_reports']] = $thromboCountVal[0]['thrombocount'];
		}
		$this->set('filterThromboDateArray', isset($filterThromboDateArray)?$filterThromboDateArray:"");
		$this->set('filterThromboCountArray', isset($filterThromboCountArray)?$filterThromboCountArray:0);

		$plCount = $this->PatientExposure->find('all', array('fields' => array('COUNT(*) AS plcount', 'DATE_FORMAT(submit_date, "%d-%M") AS day_reports', 'PatientExposure.peripheral_line', 'submit_date', 'PatientExposure.location_id', 'PatientExposure.id'), 'conditions' => array('PatientExposure.location_id' => $this->Session->read('locationid'), 'PatientExposure.peripheral_line' => 'Yes','PatientExposure.submit_date BETWEEN ? AND ?' => array($firstDate, $lastDate)), 'group' => array('submit_date')));
		foreach($plCount as $plCountVal) {
			$filterPlDateArray[] = $plCountVal[0]['day_reports'];
			$filterPlCountArray[$plCountVal[0]['day_reports']] = $plCountVal[0]['plcount'];
		}
		$this->set('filterPlDateArray', isset($filterPlDateArray)?$filterPlDateArray:"");
		$this->set('filterPlCountArray', isset($filterPlCountArray)?$filterPlCountArray:0);

		$otherCount = $this->NosocomialInfection->find('all', array('fields' => array('COUNT(*) AS othercount', 'DATE_FORMAT(submit_date, "%d-%M") AS day_reports', 'NosocomialInfection.other_nosocomial_infection', 'submit_date', 'NosocomialInfection.location_id', 'NosocomialInfection.id'), 'conditions' => array('NosocomialInfection.location_id' => $this->Session->read('locationid'), 'NosocomialInfection.other_nosocomial_infection' => 'Yes','NosocomialInfection.submit_date BETWEEN ? AND ?' => array($firstDate, $lastDate)), 'group' => array('submit_date')));
		foreach($otherCount as $otherCountVal) {
			$filterOtherDateArray[] = $otherCountVal[0]['day_reports'];
			$filterOtherCountArray[$otherCountVal[0]['day_reports']] = $otherCountVal[0]['othercount'];
		}
		$this->set('filterOtherDateArray', isset($filterOtherDateArray)?$filterOtherDateArray:"");
		$this->set('filterOtherCountArray', isset($filterOtherCountArray)?$filterOtherCountArray:0);
	}


	/**
	 * hospital acquire infections survey all record reports (default page, yearly report by cases and rate)
	 *
	 */

	private function hai_allreports($fromDate=null,$toDate=null) {
		$this->uses = array('NosocomialInfection', 'PatientExposure','FinalBilling');
		if(empty($fromDate) && empty($toDate)) {
			$fromDate = date("Y")."-01-01"; // set first date of current year
			$toDate = date("Y")."-12-31";
		}
		$ssiCount = $this->NosocomialInfection->find('all', array('fields' => array('COUNT(*) AS ssicount', 'DATE_FORMAT(submit_date, "%M-%Y") AS month_reports', 'NosocomialInfection.surgical_site_infection', 'submit_date', 'NosocomialInfection.location_id', 'NosocomialInfection.id'), 'conditions' => array('NosocomialInfection.location_id' => $this->Session->read('locationid'), 'NosocomialInfection.surgical_site_infection' => 'Yes','NosocomialInfection.submit_date BETWEEN ? AND ?' => array($fromDate, $toDate)), 'group' => array('surgical_site_infection', 'month_reports')));
		foreach($ssiCount as $ssiCountVal) {
			$filterSsiDateArray[] = $ssiCountVal[0]['month_reports'];
			$filterSsiCountArray[$ssiCountVal[0]['month_reports']] = $ssiCountVal[0]['ssicount'];
		}
		$this->set('filterSsiDateArray', isset($filterSsiDateArray)?$filterSsiDateArray:"");
		$this->set('filterSsiCountArray', isset($filterSsiCountArray)?$filterSsiCountArray:0);

		$spCount = $this->PatientExposure->find('all', array('fields' => array('COUNT(*) AS spcount', 'DATE_FORMAT(submit_date, "%M-%Y") AS month_reports', 'PatientExposure.surgical_procedure', 'submit_date', 'PatientExposure.location_id', 'PatientExposure.id'), 'conditions' => array('PatientExposure.location_id' => $this->Session->read('locationid'), 'PatientExposure.surgical_procedure' => 'Yes','PatientExposure.submit_date BETWEEN ? AND ?' => array($fromDate, $toDate)), 'group' => array('surgical_procedure', 'month_reports')));
		foreach($spCount as $spCountVal) {
			$filterSpDateArray[] = $spCountVal[0]['month_reports'];
			$filterSpCountArray[$spCountVal[0]['month_reports']] = $spCountVal[0]['spcount'];
		}
		$this->set('filterSpDateArray', isset($filterSpDateArray)?$filterSpDateArray:"");
		$this->set('filterSpCountArray', isset($filterSpCountArray)?$filterSpCountArray:0);

		 
		$vapCount = $this->NosocomialInfection->find('all', array('fields' => array('COUNT(*) AS vapcount', 'DATE_FORMAT(submit_date, "%M-%Y") AS month_reports', 'NosocomialInfection.ventilator_associated_pneumonia', 'submit_date', 'NosocomialInfection.location_id', 'NosocomialInfection.id'), 'conditions' => array('NosocomialInfection.location_id' => $this->Session->read('locationid'), 'NosocomialInfection.ventilator_associated_pneumonia' => 'Yes','NosocomialInfection.submit_date BETWEEN ? AND ?' => array($fromDate, $toDate)), 'group' => array('ventilator_associated_pneumonia', 'month_reports')));
		foreach($vapCount as $vapCountVal) {
			$filterVapDateArray[] = $vapCountVal[0]['month_reports'];
			$filterVapCountArray[$vapCountVal[0]['month_reports']] = $vapCountVal[0]['vapcount'];
		}
		$this->set('filterVapDateArray', isset($filterVapDateArray)?$filterVapDateArray:"");
		$this->set('filterVapCountArray', isset($filterVapCountArray)?$filterVapCountArray:0);

		$mvCount = $this->PatientExposure->find('all', array('fields' => array('COUNT(*) AS mvcount', 'DATE_FORMAT(submit_date, "%M-%Y") AS month_reports', 'PatientExposure.mechanical_ventilation', 'submit_date', 'PatientExposure.location_id', 'PatientExposure.id'), 'conditions' => array('PatientExposure.location_id' => $this->Session->read('locationid'), 'PatientExposure.mechanical_ventilation' => 'Yes','PatientExposure.submit_date BETWEEN ? AND ?' => array($fromDate, $toDate)), 'group' => array('mechanical_ventilation', 'month_reports')));
		foreach($mvCount as $mvCountVal) {
			$filterMvDateArray[] = $mvCountVal[0]['month_reports'];
			$filterMvCountArray[$mvCountVal[0]['month_reports']] = $mvCountVal[0]['mvcount'];
		}

		$this->set('filterMvDateArray', isset($filterMvDateArray)?$filterMvDateArray:"");
		$this->set('filterMvCountArray', isset($filterMvCountArray)?$filterMvCountArray:0);

		$utiCount = $this->NosocomialInfection->find('all', array('fields' => array('COUNT(*) AS uticount', 'DATE_FORMAT(submit_date, "%M-%Y") AS month_reports', 'NosocomialInfection.urinary_tract_infection', 'submit_date', 'NosocomialInfection.location_id', 'NosocomialInfection.id'), 'conditions' => array('NosocomialInfection.location_id' => $this->Session->read('locationid'), 'NosocomialInfection.urinary_tract_infection' => 'Yes','NosocomialInfection.submit_date BETWEEN ? AND ?' => array($fromDate, $toDate)), 'group' => array('urinary_tract_infection', 'month_reports')));
		foreach($utiCount as $utiCountVal) {
			$filterUtiDateArray[] = $utiCountVal[0]['month_reports'];
			$filterUtiCountArray[$utiCountVal[0]['month_reports']] = $utiCountVal[0]['uticount'];
		}
		$this->set('filterUtiDateArray', isset($filterUtiDateArray)?$filterUtiDateArray:"");
		$this->set('filterUtiCountArray', isset($filterUtiCountArray)?$filterUtiCountArray:0);

		$ucCount = $this->PatientExposure->find('all', array('fields' => array('COUNT(*) AS uccount', 'DATE_FORMAT(submit_date, "%M-%Y") AS month_reports', 'PatientExposure.urinary_catheter', 'submit_date', 'PatientExposure.location_id', 'PatientExposure.id'), 'conditions' => array('PatientExposure.location_id' => $this->Session->read('locationid'), 'PatientExposure.urinary_catheter' => 'Yes','PatientExposure.submit_date BETWEEN ? AND ?' => array($fromDate, $toDate)), 'group' => array('urinary_catheter', 'month_reports')));
		foreach($ucCount as $ucCountVal) {
			$filterUcDateArray[] = $ucCountVal[0]['month_reports'];
			$filterUcCountArray[$ucCountVal[0]['month_reports']] = $ucCountVal[0]['uccount'];
		}
		$this->set('filterUcDateArray', isset($filterUcDateArray)?$filterUcDateArray:"");
		$this->set('filterUcCountArray', isset($filterUcCountArray)?$filterUcCountArray:0);

		$bsiCount = $this->NosocomialInfection->find('all', array('fields' => array('COUNT(*) AS bsicount', 'DATE_FORMAT(submit_date, "%M-%Y") AS month_reports', 'NosocomialInfection.clabsi', 'submit_date', 'NosocomialInfection.location_id', 'NosocomialInfection.id'), 'conditions' => array('NosocomialInfection.location_id' => $this->Session->read('locationid'), 'NosocomialInfection.clabsi' => 'Yes','NosocomialInfection.submit_date BETWEEN ? AND ?' => array($fromDate, $toDate)), 'group' => array('clabsi', 'month_reports')));
		foreach($bsiCount as $bsiCountVal) {
			$filterBsiDateArray[] = $bsiCountVal[0]['month_reports'];
			$filterBsiCountArray[$bsiCountVal[0]['month_reports']] = $bsiCountVal[0]['bsicount'];
		}
		$this->set('filterBsiDateArray', isset($filterBsiDateArray)?$filterBsiDateArray:"");
		$this->set('filterBsiCountArray', isset($filterBsiCountArray)?$filterBsiCountArray:0);

		$clCount = $this->PatientExposure->find('all', array('fields' => array('COUNT(*) AS clcount', 'DATE_FORMAT(submit_date, "%M-%Y") AS month_reports', 'PatientExposure.central_line', 'submit_date', 'PatientExposure.location_id', 'PatientExposure.id'), 'conditions' => array('PatientExposure.location_id' => $this->Session->read('locationid'), 'PatientExposure.central_line' => 'Yes','PatientExposure.submit_date BETWEEN ? AND ?' => array($fromDate, $toDate)), 'group' => array('central_line', 'month_reports')));
		foreach($clCount as $clCountVal) {
			$filterClDateArray[] = $clCountVal[0]['month_reports'];
			$filterClCountArray[$clCountVal[0]['month_reports']] = $clCountVal[0]['clcount'];
		}
		$this->set('filterClDateArray', isset($filterClDateArray)?$filterClDateArray:"");
		$this->set('filterClCountArray', isset($filterClCountArray)?$filterClCountArray:0);

		$thromboCount = $this->NosocomialInfection->find('all', array('fields' => array('COUNT(*) AS thrombocount', 'DATE_FORMAT(submit_date, "%M-%Y") AS month_reports', 'NosocomialInfection.thrombophlebitis', 'submit_date', 'NosocomialInfection.location_id', 'NosocomialInfection.id'), 'conditions' => array('NosocomialInfection.location_id' => $this->Session->read('locationid'), 'NosocomialInfection.thrombophlebitis' => 'Yes','NosocomialInfection.submit_date BETWEEN ? AND ?' => array($fromDate, $toDate)), 'group' => array('thrombophlebitis', 'month_reports')));
		foreach($thromboCount as $thromboCountVal) {
			$filterThromboDateArray[] = $thromboCountVal[0]['month_reports'];
			$filterThromboCountArray[$thromboCountVal[0]['month_reports']] = $thromboCountVal[0]['thrombocount'];
		}
		$this->set('filterThromboDateArray', isset($filterThromboDateArray)?$filterThromboDateArray:"");
		$this->set('filterThromboCountArray', isset($filterThromboCountArray)?$filterThromboCountArray:0);

		$plCount = $this->PatientExposure->find('all', array('fields' => array('COUNT(*) AS plcount', 'DATE_FORMAT(submit_date, "%M-%Y") AS month_reports', 'PatientExposure.peripheral_line', 'submit_date', 'PatientExposure.location_id', 'PatientExposure.id'), 'conditions' => array('PatientExposure.location_id' => $this->Session->read('locationid'), 'PatientExposure.peripheral_line' => 'Yes','PatientExposure.submit_date BETWEEN ? AND ?' => array($fromDate, $toDate)), 'group' => array('peripheral_line', 'month_reports')));
		foreach($plCount as $plCountVal) {
			$filterPlDateArray[] = $plCountVal[0]['month_reports'];
			$filterPlCountArray[$plCountVal[0]['month_reports']] = $plCountVal[0]['plcount'];
		}
		$this->set('filterPlDateArray', isset($filterPlDateArray)?$filterPlDateArray:"");
		$this->set('filterPlCountArray', isset($filterPlCountArray)?$filterPlCountArray:0);

		$otherCount = $this->NosocomialInfection->find('all', array('fields' => array('COUNT(*) AS othercount', 'DATE_FORMAT(submit_date, "%M-%Y") AS month_reports', 'NosocomialInfection.other_nosocomial_infection', 'submit_date', 'NosocomialInfection.location_id', 'NosocomialInfection.id'), 'conditions' => array('NosocomialInfection.location_id' => $this->Session->read('locationid'), 'NosocomialInfection.other_nosocomial_infection' => 'Yes','NosocomialInfection.submit_date BETWEEN ? AND ?' => array($fromDate, $toDate)), 'group' => array('other_nosocomial_infection', 'month_reports')));
		foreach($otherCount as $otherCountVal) {
			$filterOtherDateArray[] = $otherCountVal[0]['month_reports'];
			$filterOtherCountArray[$otherCountVal[0]['month_reports']] = $otherCountVal[0]['othercount'];
		}
		$this->set('filterOtherDateArray', isset($filterOtherDateArray)?$filterOtherDateArray:"");
		$this->set('filterOtherCountArray', isset($filterOtherCountArray)?$filterOtherCountArray:0);
	}

	/**
	 *
	 * ssi percentage reports
	 *
	 **/

	public function admin_ssi_reports() {
		$this->uses = array('SurgicalSiteInfection', 'OptAppointment');
		$ssiCount = $this->SurgicalSiteInfection->find('all', array('fields' => array('COUNT(*) AS ssicount', 'SurgicalSiteInfection.location_id'), 'conditions' => array('SurgicalSiteInfection.location_id' => $this->Session->read('locationid'), 'SurgicalSiteInfection.is_deleted' => 0), 'group' => array('location_id'),'recursive' => -1));
		$this->set('ssiCount', $ssiCount);
		$spYesCount = $this->OptAppointment->find('all', array('fields' => array('COUNT(*) AS spYescount', 'OptAppointment.location_id'), 'conditions' => array('OptAppointment.location_id' => $this->Session->read('locationid'), 'OptAppointment.procedure_complete' => 1, 'OptAppointment.is_deleted' => 0), 'group' => array('location_id'),'recursive' => -1));
		$this->set('spYesCount', $spYesCount);
		 
	}

	/**
	 *
	 * ssi percentage reports
	 *
	 **/

	public function admin_ssi_xlsreports() {
		$this->uses = array('SurgicalSiteInfection', 'OptAppointment');
		$ssiCount = $this->SurgicalSiteInfection->find('all', array('fields' => array('COUNT(*) AS ssicount', 'SurgicalSiteInfection.location_id'), 'conditions' => array('SurgicalSiteInfection.location_id' => $this->Session->read('locationid'), 'SurgicalSiteInfection.is_deleted' => 0), 'group' => array('location_id'),'recursive' => -1));
		$this->set('ssiCount', $ssiCount);
		$spYesCount = $this->OptAppointment->find('all', array('fields' => array('COUNT(*) AS spYescount', 'OptAppointment.location_id'), 'conditions' => array('OptAppointment.location_id' => $this->Session->read('locationid'), 'OptAppointment.procedure_complete' => 1, 'OptAppointment.is_deleted' => 0), 'group' => array('location_id'),'recursive' => -1));
		$this->set('spYesCount', $spYesCount);
		$this->layout = false;
	}



	/**
	@name : admin_patient_admission_report
	@created for: Admission report
	@created on : 2/15/2012
	@created By : Anand

	**/
	public function admin_patient_admission_report(){
		$this->uses = array('Patient','Location','Person','Consultant','User','DoctorProfile', 'Department');
		$fieldsArr = array('department_id'=>'Department','previous_receivable'=>'Previous receivable','email'=>'Email','relative_name'=>'Relatives name','sponsers_auth'=>'Authorization from Sponsor','mobile_phone'=>'Relative Phone No.','relation'=>'Relationship with patient','doc_ini_assessment'=>'Form received by Patient','form_received_on'=>'Form received Date','nurse_assessment'=>'Registration Completed by patient','doc_ini_assess_on'=>'Start of assessment by Doctor','doc_ini_assess_end_on'=>'End of assessment by Doctor','nurse_assess_on'=>'Start of Nursing Assessment','nurse_assess_end_on'=>'End of Nursing Assessment','nutritional_assess_on'=>'Start of Nutritional Assessment','nutritional_assess_end_on'=>'End of Nutritional Assessment','admission_id'=>'Registration Number', 'form_received_on'=>'Date Of Admission', 'discharge_date'=>'Date Of Discharge', 'name_of_ip' => 'Name of the Employee', 'executive_emp_id_no' => 'Card Number', 'bill_number' => 'Bill Number', 'total_amount' => 'Total Bill', 'amount_paid' => 'Advance Recieved', 'discount_rupees' => 'Discount Amount', 'amount_pending' => 'Balance', 'instructions' => 'Note');
		$this->set('fieldsArr',$fieldsArr);

		if($this->request->data){
			// pr($this->request->data);exit;
			// Collect required values in variables
			$format = $this->request->data['PatientAdmissionReport']['format'];
			$from = $this->request->data['PatientAdmissionReport']['from'];
			$to =   $this->request->data['PatientAdmissionReport']['to'];
			$sex = $this->request->data['PatientAdmissionReport']['sex'];
			$age = $this->request->data['PatientAdmissionReport']['age'];
			$patient_location = $this->request->data['PatientAdmissionReport']['patient_location'];
			$blood_group = $this->request->data['PatientAdmissionReport']['blood_group'];
			$reference_doctor = $this->request->data['PatientAdmissionReport']['reference_doctor'];
			$patient_type = $this->request->data['PatientAdmissionReport']['type'];
			$doctor_type = $this->request->data['doctor'];
			$department_type = $this->request->data['PatientAdmissionReport']['department_type'];
				
			if(isset($this->request->data['PatientAdmissionReport']['treatment_type'])){
				$treatment_type = $this->request->data['PatientAdmissionReport']['treatment_type'];
			}
			//$sponsor = $this->request->data['PatientRegistrationReport']['sponsor'];
			$record = '';
			//BOF pankaj code
				
			$this->Patient->bindModel(array(
 								'belongsTo' => array( 										 
													'Location' =>array('foreignKey' => 'location_id'),
													'Person'=>array('foreignKey'=>'person_id'),
													'DoctorProfile'=>array('foreignKey'=>false,'conditions'=>array('DoctorProfile.user_id=Patient.doctor_id')),
			                                        'User'=>array('foreignKey'=>false,'conditions'=>array('User.id=Patient.doctor_id')),
			                                        'Initial'=>array('foreignKey'=>false,'conditions'=>array('Initial.id=User.initial_id')),
													'Consultant'=>array('foreignKey'=>'consultant_id'),														
													'Department'=>array('foreignKey'=>'department_id'),
                                                                                                        'FinalBilling'=>array('foreignKey'=>false,'conditions'=>array('FinalBilling.patient_id=Patient.id')),
			   
    		                                             'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
			)),false);
				
				
			if(!empty($to) && !empty($from)){
				$from = $this->DateFormat->formatDate2STDForReport($this->request->data['PatientAdmissionReport']['from'],Configure::read('date_format'))." 00:00:00";
				$to = $this->DateFormat->formatDate2STDForReport($this->request->data['PatientAdmissionReport']['to'],Configure::read('date_format'))." 23:59:59";
				// get record between two dates. Make condition
				$search_key = array('Patient.form_received_on <=' => $to, 'Patient.form_received_on >=' => $from,'Patient.is_deleted'=>0,'Patient.location_id'=>$this->Session->read('locationid'));
			}else{
				$search_key =array('Patient.location_id'=>$this->Session->read('locationid')) ;
			}
			if(!(empty($sex))){
				$search_key['Person.sex'] =  $sex;
			}
			if(!(empty($age))){
				$ageRange = explode('-',$age);
				$search_key['Person.age between ? and ?'] =  array($ageRange[0],$ageRange[1]);
			}
			if(!(empty($blood_group))){
				$search_key['Person.blood_group'] =  $blood_group;
			}
			if(!empty($patient_location)){
				$search_key['Person.city'] =  $patient_location;
			}
			if(!empty($reference_doctor)){
				$search_key['Patient.consultant_id'] =  $reference_doctor;
			}
			if(!empty($patient_type)){
				if($patient_type == 'Emergency'){
					$search_key['Patient.is_emergency'] = 1;
					$search_key['Patient.admission_type'] =  'IPD';
				} else if($patient_type == 'IPD'){
					$search_key['Patient.admission_type'] =  'IPD';
				} else if($patient_type == 'OPD'){
					if(isset($treatment_type) AND $treatment_type != ''){
						$search_key['Patient.treatment_type'] = $treatment_type;
						$search_key['Patient.admission_type'] =  'OPD';
					} else {
						$search_key['Patient.admission_type'] =  'OPD';
					}
				}
			}
				
			if(!empty($doctor_type)){
				$search_key['Patient.doctor_id'] =  $doctor_type;
			}
			if(!empty($department_type)){
				$search_key['Patient.department_id'] =  $department_type;
			}

			//$search_key['DoctorProfile.is_deleted'] =  0;
			//$search_key['DoctorProfile.location_id'] =  $this->Session->read('locationid');
			//$search_key['User.is_deleted']  = 0;
			//pr($search_key);exit;
			$selectedFields = '';
			// if you select fields of finalbilling table //
			$finalBillingFields = array('bill_number', 'total_amount', 'amount_paid', 'discount_rupees', 'amount_pending');
			if(!empty($this->request->data['PatientAdmissionReport']['field_id'])){
				foreach($this->request->data['PatientAdmissionReport']['field_id'] as $key=>$value){
					 
					if($value=='department_id'){
						$selectedFields .= ",Department.name";
					} elseif($value=='name_of_ip'){
						$selectedFields .= ",Person.name_of_ip";
					} elseif($value=='executive_emp_id_no'){
						$selectedFields .= ",Person.executive_emp_id_no";
					} elseif(in_array($value, $finalBillingFields)) {
						$selectedFields .= ",FinalBilling.".$this->request->data['PatientAdmissionReport']['field_id'][$key];
					} else {
						$selectedFields .= ",Patient.".$this->request->data['PatientAdmissionReport']['field_id'][$key];
					}
				}
			}
			$fields =array('PatientInitial.name,Patient.id,Patient.patient_id,Patient.lookup_name,Patient.is_emergency,Patient.admission_type,Patient.treatment_type,Person.city,Patient.form_received_on,
	    					Patient.admission_id,Patient.mobile_phone,Person.age,Person.sex,Person.blood_group,Department.name AS deptname, CONCAT(Initial.name," ",DoctorProfile.doctor_name) AS doctor_name,CONCAT(Consultant.first_name," ",Consultant.last_name)'.$selectedFields);
			 
				
			$record = $this->Patient->find('all',array('order'=>array('Patient.form_received_on' => 'DESC'),'fields'=>$fields,'conditions'=>$search_key));
			$this->set('selctedFields',$this->request->data['PatientAdmissionReport']['field_id']);


			//EOF pankaj code
			//pr($record);exit;
			if($format == 'PDF'){
				$this->set('reports',$record);
				$this->set(compact('fieldName'));
				$this->set(compact('patient_type'));
				$this->render('patient_admission_pdf','pdf');
			} else {
				$this->set('reports', $record);
				$this->set(compact('fieldName'));
				$this->set(compact('patient_type'));
				$this->render('patient_admission_excel','');
			}
		}
		//patient location
		$this->set('patient_location',$this->Person->find('list',array('fields'=>array('city','city'))));
		$this->set('refrences',$this->Consultant->getConsultant());
		// get department list //
		$departmentList = $this->Department->find('list', array('fields' => array('Department.id', 'Department.name'), 'conditions' => array('Department.location_id' => $this->Session->read('locationid'), 'Department.is_active' => 1)));
		$this->set('departmentList', $departmentList);
		$this->set('doctorList', $this->DoctorProfile->getDoctors());

	}


	/**
	@name : admin_patient_admission_report_chart
	@created for: Admission report
	@created on : 2/15/2012
	@created By : Anand
	This action get triggred when user select graph in format list on admission report.
	**/
	public function admin_patient_admission_report_chart(){

		$this->uses = array('Patient','Location','Person','Consultant','User','DoctorProfile');
		if(!empty($this->request->data)){
				
			$this->set('title_for_layout', __('Total Admissions Report Chart', true));

			$reportYear = $this->request->data['PatientAdmissionReport']['year'];
			$reference = $this->request->data['PatientAdmissionReport']['reference_doctor'];
			$patient_type = $this->request->data['PatientAdmissionReport']['type'];
			$doctor_type = $this->request->data['doctor'];
			$department_type = $this->request->data['PatientAdmissionReport']['department_type'];
			$location_id = $this->Session->read('locationid');
			$consultantName = '';
			$type = 'All';
			$reportMonth = $this->request->data['PatientAdmissionReport']['month'];
			if(!empty($reportMonth)){
				$countDays = cal_days_in_month(CAL_GREGORIAN, $reportMonth, $reportYear); // Days of the month selected
				$fromDate = $reportYear."-".$reportMonth."-01";
				$toDate = $reportYear."-".$reportMonth."-".$countDays;
			} else {
				$fromDate = $reportYear."-01-01"; // set first date of current year
				$toDate = $reportYear."-12-31"; // set last date of current year
			}
				
			// Bind Models
			$this->Patient->bindModel(array(
								'belongsTo' => array( 										 
													'Location' =>array('foreignKey' => 'location_id'),
													'Person'=>array('foreignKey'=>'person_id'),
			/*'DoctorProfile'=>array('foreignKey'=>false,'conditions'=>array('DoctorProfile.user_id=Patient.doctor_id')),*/
													'Consultant'=>array('foreignKey'=>'consultant_id'),														
													'Department'=>array('foreignKey'=>'department_id'),
			)),false);
			// This will not change the actual from date
			$setDate = $fromDate;
			// Create Y axix array as per month
			while($toDate > $setDate) {
				$yaxisArray[date("F-Y", strtotime($setDate))] = date("F", strtotime($setDate));
				$expfromdate = explode("-", $setDate);
				$setDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
				
			if($fromDate != '' AND $toDate != ''){
				$toSearch = array('Patient.form_received_on <=' => $toDate, 'Patient.form_received_on >=' => $fromDate, 'Patient.is_deleted'=>0,'Patient.location_id'=>$this->Session->read('locationid'));
			}

			if(!empty($reference)){
				$toSearch['Patient.consultant_id'] = $reference; // Condition reference doctors
			}

			if(!empty($patient_type)){
				if($patient_type == 'Emergency'){
					$toSearch['Patient.is_emergency'] = 1;
					$toSearch['Patient.admission_type'] = 'IPD'; // Condition for year and month
					$type = $patient_type;
				} else {
					$toSearch['Patient.admission_type'] = $patient_type; // Condition for year and month
					$type = $patient_type;

				}
			}
			if(!empty($doctor_type)){
				$toSearch['Patient.doctor_id'] = $doctor_type; // Condition reference doctors
			}
			if(!empty($department_type)){
				$toSearch['Patient.department_id'] = $department_type; // Condition reference doctors
			}
				
			// Collect record here
			$countRecord = $this->Patient->find('all', array('fields' => array('COUNT(*) AS recordcount', 'DATE_FORMAT(form_received_on, "%M-%Y") AS month_reports',
			 'Patient.form_received_on', 'Patient.doctor_id','Patient.admission_type','Patient.is_emergency','CONCAT(Consultant.first_name," ",Consultant.last_name)'), 
			 'conditions' => $toSearch ,'group' => array('month_reports')));
				
			//pr($countRecord);exit;

			// Set data for view as per record counted
			foreach($countRecord as $countRecordVal) {
				$filterRecordDateArray[] = $countRecordVal[0]['month_reports'];
				$filterRecordCountArray[$countRecordVal[0]['month_reports']] = $countRecordVal[0]['recordcount'];
			}

			$this->set('filterRecordDateArray', isset($filterRecordDateArray)?$filterRecordDateArray:"");
			$this->set('filterRecordCountArray', isset($filterRecordCountArray)?$filterRecordCountArray:0);
			$this->set('yaxisArray', $yaxisArray);
			$this->set(compact('countRecord'));
			$this->set(compact('reportMonth'));
			$this->set(compact('type'));

		}
	}


	/**
	@name : admin_patient_discharge_report
	@created for: Admission report
	@created on : 2/15/2012
	@created By : Anand

	**/

	public function admin_patient_discharge_report(){

		$this->uses = array('FinalBilling','Location','Patient','Person');
		if($this->request->data){

			$from = $this->DateFormat->formatDate2STDForReport($this->request->data['PatientDischargeReport']['from'],Configure::read('date_format'))." 00:00:00";
			$to = $this->DateFormat->formatDate2STDForReport($this->request->data['PatientDischargeReport']['to'],Configure::read('date_format'))." 23:59:59";

			$format = $this->request->data['PatientDischargeReport']['format'];
			$reason = $this->request->data['PatientDischargeReport']['reason'];

			$this->FinalBilling->bindModel(array(
 								'belongsTo' => array( 											 
														'Patient' =>array('foreignKey' => 'patient_id'),
														'Person'=>array('foreignKey'=>'patient_id'),
			'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
			)),false);

			// get record between two dates. Make condition
			$conditions = array('FinalBilling.discharge_date <=' => $to, 'FinalBilling.discharge_date >=' => $from);

			$location_id = $this->Session->read('locationid');
			if($reason != ''){
				$record = $this->FinalBilling->find('all',array('order'=>array('FinalBilling.create_time' => 'DESC'),'conditions' => array($conditions,'FinalBilling.location_id'=>$location_id,'FinalBilling.reason_of_discharge'=>$reason,'FinalBilling.discharge_date !='=>'NULL')));
			} else {
				$record = $this->FinalBilling->find('all',array('order'=>array('FinalBilling.create_time' => 'DESC'),'conditions' => array($conditions,'FinalBilling.location_id'=>$location_id,'FinalBilling.reason_of_discharge !='=>'NULL','FinalBilling.discharge_date !='=>'NULL')));
			}

			//pr($record);exit;
			if($format == 'PDF'){
					
				$this->set('reports',$record);
					
				$this->render('patient_discharge_pdf','pdf');
			} else {
					
				$this->set('reports', $record);
					
				$this->render('patient_discharge_excel','patient_discharge_excel');
		 }
		}
	}


	//BOF pankaj
	function admin_incedence_report(){
		$this->uses = array('Incident','FinalBilling','IncidentType');
		if($this->request->data){

			$this->set('report_title','Incendence Report');
			$format = $this->request->data['Report']['format'];
			$search_ele  = $this->request->data['Report'];
			$this->Incident->bindModel(array(
 								'belongsTo' => array( 											 
														'Location' =>array('foreignKey' => 'location_id'),
														'IncidentType'=>array('foreignKey'=>'analysis_option'),
														'FinalBilling'=>array('foreignKey'=>false,'conditions'=>array('FinalBilling.patient_id=Incident.patient_id',"reason_of_discharge != '' "))
			)),false);
			$search_key = array('Incident.location_id'=>$this->Session->read('locationid'));

			if(!empty($search_ele['year'])){
				$search_key = array('Incident.incident_date >='=>$search_ele['year']."-01-01",'Incident.incident_date <='=>$search_ele['year']."-12-31",'Incident.location_id'=>$this->Session->read('locationid'));
			}
			 
			$fields =array('monthname(incident_date) as month','count(*) as count','medication_error','analysis_option','incident_date','FinalBilling.reason_of_discharge','IncidentType.name');
			$search_key["FinalBilling.reason_of_discharge != "]= '' ;
			$search_key["FinalBilling.discharge_date != "]= '' ;

			$record = $this->Incident->find('all',array('fields'=>$fields,'conditions'=>$search_key,'group'=>array('IncidentType.name,MONTH( incident_date )')));
			$mediKey = $search_key ;
			$mediKey['medication_error !='] = '';
			$medicationRecord = $this->Incident->find('all',array('fields'=>array('monthname(incident_date) as month','count(*) as count','medication_error'),'conditions'=>$mediKey,'group'=>array('MONTH( incident_date )')));

			$discharge = $this->FinalBilling->find('all',array('fields'=>array('monthname(discharge_date) as month,year(discharge_date) as year ,count(*) as count'),
					'conditions'=>array("reason_of_discharge != ''","discharge_date !='' "),'group'=>array('MONTH( discharge_date ) , YEAR( discharge_date )')));

			$incidentRes  = $this->IncidentType->Find('all',array('fields'=>array('name'),'conditions'=>array('location_id'=>$this->Session->read('locationid'))));
			foreach($record as $key =>$value){
				$finalArr[$value[0]['month']][$value['IncidentType']['name']] = $value[0]['count'];
			}
			foreach($medicationRecord as $medKey => $medVal){
				$finalArr[$medVal[0]['month']]['medication_error'] = $medVal[0]['count'];
			}
			 
			foreach($discharge as $key =>$disMonth){
				$monthCount[$disMonth[0]['month']]  = $disMonth[0]['count'] ;
			}
			 
			$this->set(array('record'=>$finalArr,'discharge'=>$monthCount,'incidentType'=>$incidentRes,'year'=>$search_ele['year']));
				
			/*if(!empty($discharge)){

			//discharge count
			$monthCount = array();
			 
			foreach($discharge as $key =>$disMonth){
			$monthCount[$disMonth[0]['month']]  = $disMonth[0]['count'] ;
			}
				
			$m = 1 ;
			$f = 1;
			$fa = 1;
			$s =1 ;
			$in =1 ;

			foreach($record as $pdfData){
				
			if(!empty($pdfData['FinalBilling']['reason_of_discharge'])){
				
			$medication_error = $pdfData['Incident']['medication_error'];
			$analysis_option  = $pdfData['Incident']['analysis_option'];
			$month =date('M',strtotime($pdfData['Incident']['incident_date'])) ;
			$error = array();
			if(!empty($medication_error)){
			$error[$month][]     =1 ;
			}
			if($analysis_option=='tranfusion error'){
			$fusionJan[$month]   =1;
			}
			if($analysis_option=='patient fall'){
			$fallJan[$month][]   =1;
			}
			if($analysis_option=='bed sores') {
			$soreJan[$month][]   =1;
			}
			if($analysis_option=='needle stick injury'){
			$injuryJan[$month][] =1;
			}
			}
			}

			$month =array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
			$fullMonth =array('Jan'=>'January','Feb'=>'February','Mar'=>'March','Apr'=>'April','May'=>'May','Jun'=>'June','Jul'=>'July','Aug'=>'August','Sep'=>'September','Oct'=>'October','Nov'=>'November','Dec'=>'December');

			foreach($month as $mon){
			$fullMonthCount = $monthCount[$fullMonth[$mon]] ;
			if($fullMonthCount > 0 ){
			$medicationErrorArray[$fullMonth[$mon]]  = (count($error[$mon])/$fullMonthCount)*100;
			$fusionArray[$fullMonth[$mon]]			 = (count($fusionJan[$mon])/$fullMonthCount)*100;
			$fallArray[$fullMonth[$mon]]			 = (count($fallJan[$mon])/$fullMonthCount)*100;
			$soreArray[$fullMonth[$mon]]			 = (count($soreJan[$mon])/$fullMonthCount)*100;
			$injuryArray[$fullMonth[$mon]]			 = (count($injuryJan[$mon])/$fullMonthCount)*100;
			}
			}

				
			$this->set(array('medicationArray'=>$medicationErrorArray,'fusionArray'=>$fusionArray,'fallArray'=>$fallArray,'soreArray'=>$soreArray,'injuryArray'=>$injuryArray));
			}*/

			if($format == 'PDF'){
				$this->set('reports',$record);
				//$this->layout = 'pdf'; //this will use the pdf.ctp layout
				$this->render('incedence_pdf','pdf');
			} else {
				$this->set('reports', $record);
				$this->render('incedence_excel','');
				//$this->render('patient_registration_excel');
			}
		}
		//retrive the last yr in db
		$this->Incident->recursive = -1 ;
		$last = $this->Incident->find('first',array('fields'=>array('incident_date'),'order'=>'incident_date desc'));
		$this->set('endyear',date('Y',strtotime($last['Incident']['incident_date']))) ;
	}


	function admin_incedence_chart_report(){
		$this->uses = array('Incident','FinalBilling','IncidentType');
		if($this->request->data){

			$this->set('report_title','Incendence Report');
			$format = $this->request->data['Report']['format'];
			$search_ele  = $this->request->data['Report'];
			$this->Incident->bindModel(array(
 								'belongsTo' => array( 											 
														'Location' =>array('foreignKey' => 'location_id'),
														'IncidentType'=>array('foreignKey'=>'analysis_option'),
														'FinalBilling'=>array('foreignKey'=>false,'conditions'=>array('FinalBilling.patient_id=Incident.patient_id',"reason_of_discharge != '' "))
			)),false);
			$search_key = array('Incident.location_id'=>$this->Session->read('locationid'));

			if(!empty($search_ele['year'])){
				$search_key = array('Incident.incident_date >='=>$search_ele['year']."-01-01",'Incident.incident_date <='=>$search_ele['year']."-12-31",'Incident.location_id'=>$this->Session->read('locationid'));
			}
			 
			$fields =array('monthname(incident_date) as month','count(*) as count','medication_error','analysis_option','incident_date','FinalBilling.reason_of_discharge','IncidentType.name');
			$search_key["FinalBilling.reason_of_discharge != "]= '' ;
			$search_key["FinalBilling.discharge_date != "]= '' ;

			$record = $this->Incident->find('all',array('fields'=>$fields,'conditions'=>$search_key,'group'=>array('IncidentType.name,MONTH( incident_date )')));
			$mediKey = $search_key ;
			$mediKey['medication_error !='] = '';
			$medicationRecord = $this->Incident->find('all',array('fields'=>array('monthname(incident_date) as month','count(*) as count','medication_error'),'conditions'=>$mediKey,'group'=>array('MONTH( incident_date )')));

			$discharge = $this->FinalBilling->find('all',array('fields'=>array('monthname(discharge_date) as month,year(discharge_date) as year ,count(*) as count'),
					'conditions'=>array("reason_of_discharge != ''","discharge_date !='' "),'group'=>array('MONTH( discharge_date ) , YEAR( discharge_date )')));

			$incidentRes  = $this->IncidentType->Find('all',array('fields'=>array('name'),'conditions'=>array('location_id'=>$this->Session->read('locationid'))));
			foreach($record as $key =>$value){
				$finalArr[$value[0]['month']][$value['IncidentType']['name']] = $value[0]['count'];
			}
			foreach($medicationRecord as $medKey => $medVal){
				$finalArr[$medVal[0]['month']]['medication_error'] = $medVal[0]['count'];
			}
			 
			foreach($discharge as $key =>$disMonth){
				$monthCount[$disMonth[0]['month']]  = $disMonth[0]['count'] ;
			}
			 
			$this->set(array('record'=>$finalArr,'discharge'=>$monthCount,'incidentType'=>$incidentRes,'year'=>$search_ele['year']));
				
				
			//retrive the last yr in db
			$this->Incident->recursive = -1 ;
			$last = $this->Incident->find('first',array('fields'=>array('incident_date'),'order'=>'incident_date desc'));
			$this->set('endyear',date('Y',strtotime($last['Incident']['incident_date']))) ;
			$this->set('pdfData',$last);
		}else{
			$this->redirect($this->referer());
				
		}
			
	}


	/**
	 *
	 * length of stay reports
	 *
	 **/

	public function admin_length_of_stay() {
		$this->set('title_for_layout', __('Average length of stay', true));
		if ($this->request->is('post')) {
			$reportYear = $this->request->data['reportYear'];
			$fromDate = $reportYear."-01-01"; // set first date of current year
			$toDate = $reportYear."-12-31"; // set last date of current year
			$this->losreports($fromDate,$toDate);
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray', $yaxisArray);
		} else {
			$fromDate = date("Y")."-01-01"; // set first date of current year
			$toDate = date("Y")."-12-31"; // set last date of current year
			$this->losreports($fromDate,$toDate);
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray', $yaxisArray);
				
		}
		$this->set('reportYear', isset($this->request->data['reportYear'])?$this->request->data['reportYear']:date("Y"));

	}

	/**
	 *
	 * length of stay reports query and to calculate inpatient days for ward occupancy report
	 *
	 **/

	private function losreports($fromDate=NULL, $toDate=NULL) {
		$this->uses = array('Patient', 'FinalBilling', 'WardPatient');
		$admitDatePerPatient = $this->WardPatient->find('all', array('fields' => array('DATE_FORMAT(in_date, "%M-%Y") AS month_reports', 'DATE_FORMAT(in_date, "%Y-%m-%d") AS admit_date',  'WardPatient.location_id','WardPatient.patient_id'), 'conditions' => array('WardPatient.location_id' => $this->Session->read('locationid'),'WardPatient.is_deleted' => 0), 'group' => array("patient_id  HAVING  admit_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'order' => 'in_date'));

		$dischargeDatePerPatient = $this->WardPatient->find('all', array('fields' => array('DATE_FORMAT(out_date, "%M-%Y") AS month_reports', 'DATE_FORMAT(out_date, "%Y-%m-%d") AS discharge_date',  'WardPatient.location_id','WardPatient.patient_id'), 'conditions' => array('WardPatient.location_id' => $this->Session->read('locationid'), 'is_discharge'=> 1,'WardPatient.is_deleted' => 0), 'group' => array("patient_id  HAVING  discharge_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'order' => 'out_date'));

		foreach($admitDatePerPatient as $admitDatePerPatientVal) {
			$patientAdmitDetails[$admitDatePerPatientVal['WardPatient']['patient_id']]['month'] = $admitDatePerPatientVal[0]['month_reports'];
			$patientAdmitDetails[$admitDatePerPatientVal['WardPatient']['patient_id']]['admit_date'] = $admitDatePerPatientVal[0]['admit_date'];
		}

		foreach($dischargeDatePerPatient as $dischargeDatePerPatientVal) {
			$patientDischargeDetails[$dischargeDatePerPatientVal['WardPatient']['patient_id']]['month'] = $dischargeDatePerPatientVal[0]['month_reports'];
			$patientDischargeDetails[$dischargeDatePerPatientVal['WardPatient']['patient_id']]['discharge_date'] = $dischargeDatePerPatientVal[0]['discharge_date'];
			$dischargePatientIdArray[] = $dischargeDatePerPatientVal['WardPatient']['patient_id'];
		}
		 
		$lastval = "";
		foreach($patientAdmitDetails as $key => $patientAdmitDetailsVal ) {
			// store last month value  //
			$cnt++;
			// check last month value if same or not //
			if($lastval == $patientAdmitDetailsVal['month']) {
				// if admit and dischare are on same month otherwise go to else //
			if($patientAdmitDetailsVal['month'] == $patientDischargeDetails[$key]['month']) {
					$interval = $this->DateFormat->dateDiff($patientAdmitDetailsVal['admit_date'], $patientDischargeDetails[$key]['discharge_date']);
					$timeDay 	= $interval->days+1;
					if($timeDay > 0) {
						$filterIpdCountArray[$patientAdmitDetailsVal['month']] += $timeDay;
					} elseif($timeDay == 0) {
						$filterIpdCountArray[$patientAdmitDetailsVal['month']] += 1;
					} else {
						$filterIpdCountArray[$patientAdmitDetailsVal['month']] += 0;
					}
				} else {
					// if discharge date exist but more than one month // 
					if(in_array($key, $dischargePatientIdArray)) {
					    $expPatientAdmitDate = explode("-", $patientAdmitDetailsVal['admit_date']);
					    $expPatientDischargeDate = explode("-", $patientDischargeDetails[$key]['discharge_date']);
						// more than one month gap //
						$diffDate = date("m-Y" , strtotime($patientDischargeDetails[$key]['discharge_date'])) - date("m-Y", strtotime($patientAdmitDetailsVal['admit_date']));
						
						$i=0;
						while($i <= $diffDate) {
							
							if($i == 0) {
								$maxDate = $expPatientAdmitDate[0]."-".$expPatientAdmitDate[1]."-".cal_days_in_month(CAL_GREGORIAN, $expPatientAdmitDate[1], $expPatientAdmitDate[0]);
							    $interval = $this->DateFormat->dateDiff($patientAdmitDetailsVal['admit_date'],$maxDate);
						        $timeDay 	= $interval->days+1;
								if($timeDay > 0) {
									$filterIpdDateArray[] = $patientAdmitDetailsVal['month'];
									$filterIpdCountArray[$patientAdmitDetailsVal['month']] += $timeDay;
								} elseif($timeDay == 0) {
									$filterIpdDateArray[] = $patientAdmitDetailsVal['month'];
									$filterIpdCountArray[$patientAdmitDetailsVal['month']] += 1;
								} else {
									$filterIpdDateArray[] = $patientAdmitDetailsVal['month'];
									$filterIpdCountArray[$patientAdmitDetailsVal['month']] += 0;
								}
							} else if($i == $diffDate) {
							    $maxDate = $patientDischargeDetails[$key]['discharge_date'];
							    $startDate = $expPatientDischargeDate[0]."-".$expPatientDischargeDate[1]."-"."01";
							    $interval = $this->DateFormat->dateDiff($startDate,$maxDate);
							    
						        $timeDay 	= $interval->days+1;
								if($timeDay > 0) {
									$filterIpdDateArray[] = date("F-Y" ,strtotime($patientDischargeDetails[$key]['discharge_date']));
									$filterIpdCountArray[date("F-Y" ,strtotime($patientDischargeDetails[$key]['discharge_date']))] += $timeDay;
								} elseif($timeDay == 0) {
									$filterIpdDateArray[] = date("F-Y" ,strtotime($patientDischargeDetails[$key]['discharge_date']));
									$filterIpdCountArray[date("F-Y" ,strtotime($patientDischargeDetails[$key]['discharge_date']))] += 1;
								} else {
									$filterIpdDateArray[] = date("F-Y" ,strtotime($patientDischargeDetails[$key]['discharge_date']));
									$filterIpdCountArray[date("F-Y" ,strtotime($patientDischargeDetails[$key]['discharge_date']))] += 0;
								}
							} else {
							    $maxDate = $expPatientAdmitDate[0]."-".($expPatientAdmitDate[1]+$i)."-".cal_days_in_month(CAL_GREGORIAN, ($expPatientAdmitDate[1]+$i), $expPatientAdmitDate[0]);
							    $startDate = $expPatientAdmitDate[0]."-".($expPatientAdmitDate[1]+$i)."-"."01";
							    
							    $interval = $this->DateFormat->dateDiff($startDate,$maxDate);
						        $timeDay 	= $interval->days+1;
								if($timeDay > 0) {
									$filterIpdDateArray[] = date("F-Y", strtotime($maxDate));
									$filterIpdCountArray[date("F-Y", strtotime($maxDate))] += $timeDay;
								} elseif($timeDay == 0) {
									$filterIpdDateArray[] = date("F-Y", strtotime($maxDate));
									$filterIpdCountArray[date("F-Y", strtotime($maxDate))] += 1;
								} else {
									$filterIpdDateArray[] = date("F-Y", strtotime($maxDate));
									$filterIpdCountArray[date("F-Y", strtotime($maxDate))] += 0;
								}
							}
							$i++;
						}
					// if discharge date is not exist then calculate upto date  //	
					} else {
						
						$expPatientAdmitDate = explode("-", $patientAdmitDetailsVal['admit_date']);
						// more than one month gap //
						$diffDate = date("m-Y") - date("m-Y", strtotime($patientAdmitDetailsVal['admit_date']));
						
						$i=0;
						while($i <= $diffDate) {
							if($i == 0) {
								//$maxDate = $expPatientAdmitDate[0]."-".$expPatientAdmitDate[1]."-".cal_days_in_month(CAL_GREGORIAN, $expPatientAdmitDate[1], $expPatientAdmitDate[0]);
								$maxDate = $this->DateFormat->formatDate2STDForReport(date("Y-m-d"),Configure::read('date_format'));
							    $interval = $this->DateFormat->dateDiff($patientAdmitDetailsVal['admit_date'],$maxDate);
						        $timeDay 	= $interval->days+1;
						        
								if($timeDay > 0) {
									$filterIpdDateArray[] = $patientAdmitDetailsVal['month'];
									$filterIpdCountArray[$patientAdmitDetailsVal['month']] += $timeDay;
								} elseif($timeDay == 0) {
									$filterIpdDateArray[] = $patientAdmitDetailsVal['month'];
									$filterIpdCountArray[$patientAdmitDetailsVal['month']] += 1;
								} else {
									$filterIpdDateArray[] = $patientAdmitDetailsVal['month'];
									$filterIpdCountArray[$patientAdmitDetailsVal['month']] += 0;
								} 
							} else if($i == $diffDate) {
							    //$maxDate = date("Y")."-".date("m")."-".cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y"));
							    $maxDate = $this->DateFormat->formatDate2STDForReport(date("Y-m-d"),Configure::read('date_format'));
							    $startDate = date("Y")."-".date("m")."-"."01";
							    $interval = $this->DateFormat->dateDiff($startDate,$maxDate);
							    
						        $timeDay 	= $interval->days+1;
								if($timeDay > 0) {
									$filterIpdDateArray[] = date("F-Y");
									$filterIpdCountArray[date("F-Y")] += $timeDay;
								} elseif($timeDay == 0) {
									$filterIpdDateArray[] = date("F-Y");
									$filterIpdCountArray[date("F-Y")] += 1;
								} else {
									$filterIpdDateArray[] = date("F-Y");
									$filterIpdCountArray[date("F-Y")] += 0;
								}
							} else {
							    $maxDate = $expPatientAdmitDate[0]."-".($expPatientAdmitDate[1]+$i)."-".cal_days_in_month(CAL_GREGORIAN, ($expPatientAdmitDate[1]+$i), $expPatientAdmitDate[0]);
							    $startDate = $expPatientAdmitDate[0]."-".($expPatientAdmitDate[1]+$i)."-"."01";
							    
							    $interval = $this->DateFormat->dateDiff($startDate,$maxDate);
						        $timeDay 	= $interval->days+1;
								if($timeDay > 0) {
									$filterIpdDateArray[] = date("F-Y", strtotime($maxDate));
									$filterIpdCountArray[date("F-Y", strtotime($maxDate))] += $timeDay;
								} elseif($timeDay == 0) {
									$filterIpdDateArray[] = date("F-Y", strtotime($maxDate));
									$filterIpdCountArray[date("F-Y", strtotime($maxDate))] += 1;
								} else {
									$filterIpdDateArray[] = date("F-Y", strtotime($maxDate));
									$filterIpdCountArray[date("F-Y", strtotime($maxDate))] += 0;
								}
							}
							$i++;
						}
						
					 }
												
					}
			// close lastval if conditions  //
			} else {
				// if admit and dischare are on same month otherwise go to else //
				if($patientAdmitDetailsVal['month'] == $patientDischargeDetails[$key]['month']) {
					$interval = $this->DateFormat->dateDiff($patientAdmitDetailsVal['admit_date'], $patientDischargeDetails[$key]['discharge_date']);
					$timeDay 	= $interval->days+1;
					if($timeDay > 0) {
						$filterIpdCountArray[$patientAdmitDetailsVal['month']] = $timeDay;
					} elseif($timeDay == 0) {
						$filterIpdCountArray[$patientAdmitDetailsVal['month']] = 1;
					} else {
						$filterIpdCountArray[$patientAdmitDetailsVal['month']] = 0;
					}
				} else {
					if(in_array($key, $dischargePatientIdArray)) {
					    $expPatientAdmitDate = explode("-", $patientAdmitDetailsVal['admit_date']);
					    $expPatientDischargeDate = explode("-", $patientDischargeDetails[$key]['discharge_date']);
						// more than one month gap //
						$diffDate = date("m-Y" , strtotime($patientDischargeDetails[$key]['discharge_date'])) - date("m-Y", strtotime($patientAdmitDetailsVal['admit_date']));
						
						$i=0;
						while($i <= $diffDate) {
							if($i == 0) {
								$maxDate = $expPatientAdmitDate[0]."-".$expPatientAdmitDate[1]."-".cal_days_in_month(CAL_GREGORIAN, $expPatientAdmitDate[1], $expPatientAdmitDate[0]);
							    $interval = $this->DateFormat->dateDiff($patientAdmitDetailsVal['admit_date'],$maxDate);
						        $timeDay 	= $interval->days+1;
								if($timeDay > 0) {
									$filterIpdDateArray[] = $patientAdmitDetailsVal['month'];
									$filterIpdCountArray[$patientAdmitDetailsVal['month']] += $timeDay;
								} elseif($timeDay == 0) {
									$filterIpdDateArray[] = $patientAdmitDetailsVal['month'];
									$filterIpdCountArray[$patientAdmitDetailsVal['month']] += 1;
								} else {
									$filterIpdDateArray[] = $patientAdmitDetailsVal['month'];
									$filterIpdCountArray[$patientAdmitDetailsVal['month']] += 0;
								}
							} else if($i == $diffDate) {
							    $maxDate = $patientDischargeDetails[$key]['discharge_date'];
							    $startDate = $expPatientDischargeDate[0]."-".$expPatientDischargeDate[1]."-"."01";
							    $interval = $this->DateFormat->dateDiff($startDate,$maxDate);
							    
						        $timeDay 	= $interval->days+1;
								if($timeDay > 0) {
									$filterIpdDateArray[] = date("F-Y" ,strtotime($patientDischargeDetails[$key]['discharge_date']));
									$filterIpdCountArray[date("F-Y" ,strtotime($patientDischargeDetails[$key]['discharge_date']))] += $timeDay;
								} elseif($timeDay == 0) {
									$filterIpdDateArray[] = date("F-Y" ,strtotime($patientDischargeDetails[$key]['discharge_date']));
									$filterIpdCountArray[date("F-Y" ,strtotime($patientDischargeDetails[$key]['discharge_date']))] += 1;
								} else {
									$filterIpdDateArray[] = date("F-Y" ,strtotime($patientDischargeDetails[$key]['discharge_date']));
									$filterIpdCountArray[date("F-Y" ,strtotime($patientDischargeDetails[$key]['discharge_date']))] += 0;
								}
							} else {
							    $maxDate = $expPatientAdmitDate[0]."-".($expPatientAdmitDate[1]+$i)."-".cal_days_in_month(CAL_GREGORIAN, ($expPatientAdmitDate[1]+$i), $expPatientAdmitDate[0]);
							    $startDate = $expPatientAdmitDate[0]."-".($expPatientAdmitDate[1]+$i)."-"."01";
							    
							    $interval = $this->DateFormat->dateDiff($startDate,$maxDate);
						        $timeDay 	= $interval->days+1;
								if($timeDay > 0) {
									$filterIpdDateArray[] = date("F-Y", strtotime($maxDate));
									$filterIpdCountArray[date("F-Y", strtotime($maxDate))] += $timeDay;
								} elseif($timeDay == 0) {
									$filterIpdDateArray[] = date("F-Y", strtotime($maxDate));
									$filterIpdCountArray[date("F-Y", strtotime($maxDate))] += 1;
								} else {
									$filterIpdDateArray[] = date("F-Y", strtotime($maxDate));
									$filterIpdCountArray[date("F-Y", strtotime($maxDate))] += 0;
								}
							}
							$i++;
						}
					} else {
						$expPatientAdmitDate = explode("-", $patientAdmitDetailsVal['admit_date']);
						// more than one month gap //
						$diffDate = date("m-Y") - date("m-Y", strtotime($patientAdmitDetailsVal['admit_date']));
						
						$i=0;
						while($i <= $diffDate) {
							if($i == 0) {
								//$maxDate = $expPatientAdmitDate[0]."-".$expPatientAdmitDate[1]."-".cal_days_in_month(CAL_GREGORIAN, $expPatientAdmitDate[1], $expPatientAdmitDate[0]);
								$maxDate = $this->DateFormat->formatDate2STDForReport(date("Y-m-d"),Configure::read('date_format'));
							    $interval = $this->DateFormat->dateDiff($patientAdmitDetailsVal['admit_date'],$maxDate);
						        $timeDay 	= $interval->days+1;
								if($timeDay > 0) {
									$filterIpdDateArray[] = $patientAdmitDetailsVal['month'];
									$filterIpdCountArray[$patientAdmitDetailsVal['month']] += $timeDay;
								} elseif($timeDay == 0) {
									$filterIpdDateArray[] = $patientAdmitDetailsVal['month'];
									$filterIpdCountArray[$patientAdmitDetailsVal['month']] += 1;
								} else {
									$filterIpdDateArray[] = $patientAdmitDetailsVal['month'];
									$filterIpdCountArray[$patientAdmitDetailsVal['month']] += 0;
								}
							} else if($i == $diffDate) {
							    //$maxDate = date("Y")."-".date("m")."-".cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y"));
							    $maxDate = $this->DateFormat->formatDate2STDForReport(date("Y-m-d"),Configure::read('date_format'));
							    $startDate = date("Y")."-".date("m")."-"."01";
							    $interval = $this->DateFormat->dateDiff($startDate,$maxDate);
							    
						        $timeDay 	= $interval->days+1;
								if($timeDay > 0) {
									$filterIpdDateArray[] = date("F-Y");
									$filterIpdCountArray[date("F-Y")] += $timeDay;
								} elseif($timeDay == 0) {
									$filterIpdDateArray[] = date("F-Y");
									$filterIpdCountArray[date("F-Y")] += 1;
								} else {
									$filterIpdDateArray[] = date("F-Y");
									$filterIpdCountArray[date("F-Y")] += 0;
								}
							} else {
							    $maxDate = $expPatientAdmitDate[0]."-".($expPatientAdmitDate[1]+$i)."-".cal_days_in_month(CAL_GREGORIAN, ($expPatientAdmitDate[1]+$i), $expPatientAdmitDate[0]);
							    $startDate = $expPatientAdmitDate[0]."-".($expPatientAdmitDate[1]+$i)."-"."01";
							    
							    $interval = $this->DateFormat->dateDiff($startDate,$maxDate);
						        $timeDay 	= $interval->days+1;
								if($timeDay > 0) {
									$filterIpdDateArray[] = date("F-Y", strtotime($maxDate));
									$filterIpdCountArray[date("F-Y", strtotime($maxDate))] += $timeDay;
								} elseif($timeDay == 0) {
									$filterIpdDateArray[] = date("F-Y", strtotime($maxDate));
									$filterIpdCountArray[date("F-Y", strtotime($maxDate))] += 1;
								} else {
									$filterIpdDateArray[] = date("F-Y", strtotime($maxDate));
									$filterIpdCountArray[date("F-Y", strtotime($maxDate))] += 0;
								}
							}
							$i++;
						}
					 }
												
					}
				}
		
			//print_r($filterIpdDateArray);exit;
			$lastval = $patientAdmitDetailsVal['month'];
		}
		 
		$this->set('filterIpdDateArray', isset($filterIpdDateArray)?$filterIpdDateArray:"");
		$this->set('filterIpdCountArray', isset($filterIpdCountArray)?$filterIpdCountArray:0);

		$dischargeDeathCount = $this->FinalBilling->find('all', array('fields' => array('COUNT(*) AS dischargedeathcount', 'DATE_FORMAT(discharge_date, "%M-%Y") AS month_reports', 'DATE_FORMAT(discharge_date, "%Y-%m-%d") AS discharge_date', 'FinalBilling.location_id', 'FinalBilling.id'), 'group' => array("month_reports  HAVING  discharge_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('FinalBilling.location_id' => $this->Session->read('locationid'), 'FinalBilling.reason_of_discharge' =>  array('Recovered', 'DAMA','Death'))));

		foreach($dischargeDeathCount as $dischargeDeathCountVal) {
			$filterdischargeDeathDateArray[] = $dischargeDeathCountVal[0]['month_reports'];
			$filterdischargeDeathCountArray[$dischargeDeathCountVal[0]['month_reports']] = $dischargeDeathCountVal[0]['dischargedeathcount'];
		}
		$this->set('filterdischargeDeathDateArray', isset($filterdischargeDeathDateArray)?$filterdischargeDeathDateArray:"");
		$this->set('filterdischargeDeathCountArray', isset($filterdischargeDeathCountArray)?$filterdischargeDeathCountArray:0);
	}

	/**
	 * length of stay reports chart
	 *
	 */


	public function admin_length_of_stay_chart() {
		$this->set('title_for_layout', __('Average length of stay Chart', true));
		if ($this->request->is('post')) {
			$reportYear = $this->request->data['reportYear'];
			$fromDate = $reportYear."-01-01"; // set first date of current year
			$toDate = $reportYear."-12-31"; // set last date of current year
			$this->losreports($fromDate,$toDate);
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
		}
		$this->set('yaxisArray', $yaxisArray);
		$this->set('reportYear', $reportYear);
	}


	/**
	 * length of stay xls reports
	 *
	 */

	public function admin_length_of_stay_xls() {
		if ($this->request->is('post')) {
			$reportYear = $this->request->data['reportYear'];
			$fromDate = $reportYear."-01-01"; // set first date of current year
			$toDate = $reportYear."-12-31"; // set last date of current year
			$this->losreports($fromDate,$toDate);
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray', $yaxisArray);
		} else {
			$fromDate = date("Y")."-01-01"; // set first date of current year
			$toDate = date("Y")."-12-31"; // set last date of current year
			$this->losreports($fromDate,$toDate);
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray', $yaxisArray);
				
		}
		$this->set('reportYear', isset($this->request->data['reportYear'])?$this->request->data['reportYear']:date("Y"));
		$this->layout = false;
	}

	/**
	 * Ward Occupancy Rate Report
	 */

	public function ward_occupancy_rate(){
		$this->uses = array('Bed','Patient');
		 
		if ($this->request->is('post')) {#echo $this->request->data['reportYear'];exit;
			$reportYear = $this->request->data['reportYear'];
			$reportMonth = $this->request->data['reportMonth'];
			$fromDate = $reportYear."-01-01"; // set first date of current year
			$toDate = $reportYear."-12-31"; // set last date of current year
			if(!empty($reportMonth)) {
				$startDate=1;
				$countDays = cal_days_in_month(CAL_GREGORIAN, $reportMonth, $reportYear);
				while($startDate <= $countDays) {
					$dateVal = $reportYear."-".$reportMonth."-".$startDate;
					$yaxisIndex = date("d-M", strtotime($dateVal));
					$yaxisArray[$yaxisIndex] = date("d-F-Y", strtotime($dateVal));
					$startDate++;
				}
				$this->monthlyWardOccupancy($yaxisArray,$reportYear);
				$this->set('yaxisArray', $yaxisArray);
				$this->set('reportMonth', $reportMonth);
			} else {
				// date for last day midnight time //
				if($reportYear == date("Y")) {
					$lastMidFromoDate = $reportYear."-01-01 00:00:00";
					$lastMidToDate = date("Y-m-d H:i:s", mktime(23, 59, 59, date("m"), date("d")-1, date("Y")));
				} else {
					$lastMidFromoDate = $reportYear."-01-01 00:00:00";
					$lastMidToDate = $reportYear."-12-31 23:59:59";
				}
				$wardOccupancyCount = $this->Bed->find('all', array('conditions' => array('modify_time BETWEEN ? AND ?' => array($lastMidFromoDate,$lastMidToDate), 'patient_id' =>0, 'Bed.location_id' => $this->Session->read('locationid')), 'fields' => array('COUNT(*) AS bedcount', 'DATE_FORMAT(modify_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(modify_time, "%Y-%m-%d %H:%i:%s") AS bed_date', 'Bed.location_id', 'Bed.id','Bed.patient_id'), 'group' => array("month_reports")));
				// this will gives number of inpatient days //
				$this->losreports($fromDate,$toDate);
									
				foreach($wardOccupancyCount as $wardOccupancy) {
					$filterWardArray[] = $wardOccupancy[0]['month_reports'];
					$filterWardCountArray[$wardOccupancy[0]['month_reports']] = $wardOccupancy[0]['bedcount'];
				}#pr($filterWardCountArray);exit;
				$this->set('filterWardArray', isset($filterWardArray)?$filterWardArray:"");
				$this->set('filterWardCountArray', isset($filterWardCountArray)?$filterWardCountArray:0);
					
				while($toDate > $fromDate) {
					$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
					$expfromdate = explode("-", $fromDate);
					$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
				}
		 }
		 $this->set('yaxisArray',$yaxisArray);
		 // by default page //
		}else{

			$fromDate = date("Y")."-01-01";
			$toDate = date("Y")."-12-31";
			$lastMidFromoDate = date("Y")."-01-01 00:00:00";
			$lastMidToDate = date("Y-m-d H:i:s", mktime(23, 59, 59, date("m"), date("d")-1, date("Y")));

			// total bed days //

			$wardOccupancyCount = $this->Bed->find('all', array('conditions' => array('modify_time BETWEEN ? AND ?' => array($lastMidFromoDate,$lastMidToDate), 'patient_id' =>0, 'Bed.location_id' => $this->Session->read('locationid')), 'fields' => array('COUNT(*) AS bedcount', 'DATE_FORMAT(modify_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(modify_time, "%Y-%m-%d %H:%i:%s") AS bed_date', 'Bed.location_id', 'Bed.id','Bed.patient_id'), 'group' => array("month_reports")));
			// this will gives number of inpatient days //
			$this->losreports($fromDate,$toDate);
							
			foreach($wardOccupancyCount as $wardOccupancy) {
				$filterWardArray[] = $wardOccupancy[0]['month_reports'];
				$filterWardCountArray[$wardOccupancy[0]['month_reports']] = $wardOccupancy[0]['bedcount'];
			}
			$this->set('filterWardArray', isset($filterWardArray)?$filterWardArray:"");
			$this->set('filterWardCountArray', isset($filterWardCountArray)?$filterWardCountArray:0);
				
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray',$yaxisArray);
		}

		$totalBed = $this->Bed->find('count',array('conditions'=>array('Bed.location_id'=>$this->Session->read('locationid'))));
		$this->set('totalBed', $totalBed);
		$this->set('reportYear', isset($this->request->data['reportYear'])?$this->request->data['reportYear']:date("Y"));
	}

	/**
	 *
	 *
	 * monthly Ward Occupancy query
	 *
	 *
	 **/
	private function monthlyWardOccupancy($yaxisArray, $reportYear) {
		$this->loadModel('WardPatient');
		//$assignIndex = array_keys($yaxisArray);
		//$fromDate = date("Y-m-d", strtotime($yaxisArray[$assignIndex[0]]."-".$reportYear)); echo $fromDate;exit;
		//$toDate = date("Y-m-d", strtotime($yaxisArray[$assignIndex[count($yaxisArray)-1]]."-".$reportYear));
		$fromDate = $reportYear."-01-01"; // set first date of current year
		$toDate = $reportYear."-12-31"; // set last date of current year
		$admitDatePerPatient = $this->WardPatient->find('all', array('fields' => array('DATE_FORMAT(in_date, "%M-%Y") AS month_reports', 'DATE_FORMAT(in_date, "%Y-%m-%d") AS admit_date',  'WardPatient.location_id','WardPatient.patient_id'), 'conditions' => array('WardPatient.location_id' => $this->Session->read('locationid'),'WardPatient.is_deleted' => 0), 'group' => array("patient_id  HAVING  admit_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'order' => 'in_date'));

		$dischargeDatePerPatient = $this->WardPatient->find('all', array('fields' => array('DATE_FORMAT(out_date, "%M-%Y") AS month_reports', 'DATE_FORMAT(out_date, "%Y-%m-%d") AS discharge_date',  'WardPatient.location_id','WardPatient.patient_id'), 'conditions' => array('WardPatient.location_id' => $this->Session->read('locationid'), 'is_discharge'=> 1,'WardPatient.is_deleted' => 0), 'group' => array("patient_id  HAVING  discharge_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'order' => 'out_date'));

		foreach($admitDatePerPatient as $admitDatePerPatientVal) {
			$patientAdmitDetails[$admitDatePerPatientVal['WardPatient']['patient_id']]['month'] = $admitDatePerPatientVal[0]['month_reports'];
			$patientAdmitDetails[$admitDatePerPatientVal['WardPatient']['patient_id']]['admit_date'] = $admitDatePerPatientVal[0]['admit_date'];
		}

		foreach($dischargeDatePerPatient as $dischargeDatePerPatientVal) {
			$patientDischargeDetails[$dischargeDatePerPatientVal['WardPatient']['patient_id']]['month'] = $dischargeDatePerPatientVal[0]['month_reports'];
			$patientDischargeDetails[$dischargeDatePerPatientVal['WardPatient']['patient_id']]['discharge_date'] = $dischargeDatePerPatientVal[0]['discharge_date'];
			$dischargePatientIdArray[] = $dischargeDatePerPatientVal['WardPatient']['patient_id'];
		}
		 
		$lastval = "";
		foreach($patientAdmitDetails as $key => $patientAdmitDetailsVal ) {
			// store last month value  //
			$cnt++;
			
			if($lastval == $patientAdmitDetailsVal['month']) {
				// if admit and dischare are on same month otherwise go to else //
			if($patientAdmitDetailsVal['month'] == $patientDischargeDetails[$key]['month']) {
					$interval = $this->DateFormat->dateDiff($patientAdmitDetailsVal['admit_date'], $patientDischargeDetails[$key]['discharge_date']);
					$timeDay 	= $interval->days;
					$j=0;
					// create days and store the value in it
					while($j <= $timeDay) {
						 $filterIpdDateArray[] = date('d-M', strtotime(date("Y-m-d", strtotime($patientAdmitDetailsVal['admit_date'])) . " +$j day"));
						 $filterIpdCountArray[date('d-M', strtotime(date("Y-m-d", strtotime($patientAdmitDetailsVal['admit_date'])) . " +$j day"))] += 1;
						 $j++;
					}
					
				} else {
					if(in_array($key, $dischargePatientIdArray)) {
					    $expPatientAdmitDate = explode("-", $patientAdmitDetailsVal['admit_date']);
					    $expPatientDischargeDate = explode("-", $patientDischargeDetails[$key]['discharge_date']);
						// more than one month gap //
						$diffDate = date("m-Y" , strtotime($patientDischargeDetails[$key]['discharge_date'])) - date("m-Y", strtotime($patientAdmitDetailsVal['admit_date']));
						
						$i=0;
						while($i <= $diffDate) {
							if($i == 0) {
								$maxDate = $expPatientAdmitDate[0]."-".$expPatientAdmitDate[1]."-".cal_days_in_month(CAL_GREGORIAN, $expPatientAdmitDate[1], $expPatientAdmitDate[0]);
							    $interval = $this->DateFormat->dateDiff($patientAdmitDetailsVal['admit_date'],$maxDate);
						        $timeDay 	= $interval->days;
							    $j=0;
								// create days and store the value in it
								while($j <= $timeDay) {
									 $filterIpdDateArray[] = date('d-M', strtotime(date("Y-m-d", strtotime($patientAdmitDetailsVal['admit_date'])) . " +$j day"));
									 $filterIpdCountArray[date('d-M', strtotime(date("Y-m-d", strtotime($patientAdmitDetailsVal['admit_date'])) . " +$j day"))] += 1;
									 $j++;
								}
								
							} else if($i == $diffDate) {
							    $maxDate = $patientDischargeDetails[$key]['discharge_date'];
							    $startDate = $expPatientDischargeDate[0]."-".$expPatientDischargeDate[1]."-"."01";
							    $interval = $this->DateFormat->dateDiff($startDate,$maxDate);
							    $timeDay 	= $interval->days;
							    // create days and store the value in it
							    $j=0;
								while($j <= $timeDay) {
									 $filterIpdDateArray[] = date('d-M', strtotime(date("Y-m-d", strtotime($startDate)) . " +$j day"));
									 $filterIpdCountArray[date('d-M', strtotime(date("Y-m-d", strtotime($startDate)) . " +$j day"))] += 1;
									 $j++;
								}
								
							} else {
							    $maxDate = $expPatientAdmitDate[0]."-".($expPatientAdmitDate[1]+$i)."-".cal_days_in_month(CAL_GREGORIAN, ($expPatientAdmitDate[1]+$i), $expPatientAdmitDate[0]);
							    $startDate = $expPatientAdmitDate[0]."-".($expPatientAdmitDate[1]+$i)."-"."01";
							    $interval = $this->DateFormat->dateDiff($startDate,$maxDate);
						        $timeDay 	= $interval->days;
							    // create days and store the value in it
							    $j=0;
								while($j <= $timeDay) {
									 $filterIpdDateArray[] = date('d-M', strtotime(date("Y-m-d", strtotime($maxDate)) . " +$j day"));
									 $filterIpdCountArray[date('d-M', strtotime(date("Y-m-d", strtotime($maxDate)) . " +$j day"))] += 1;
									 $j++;
								}
								
							}
							$i++;
						}
						
					} else {
						
						$expPatientAdmitDate = explode("-", $patientAdmitDetailsVal['admit_date']);
						// more than one month gap //
						$diffDate = date("m-Y") - date("m-Y", strtotime($patientAdmitDetailsVal['admit_date']));
						
						$i=0;
						while($i <= $diffDate) {
							if($i == 0) {
								//$maxDate = $expPatientAdmitDate[0]."-".$expPatientAdmitDate[1]."-".cal_days_in_month(CAL_GREGORIAN, $expPatientAdmitDate[1], $expPatientAdmitDate[0]);
								$maxDate = $this->DateFormat->formatDate2STDForReport(date("Y-m-d"),Configure::read('date_format'));
							    $interval = $this->DateFormat->dateDiff($patientAdmitDetailsVal['admit_date'],$maxDate);
						        $timeDay 	= $interval->days;
							    // create days and store the value in it
							    $j=0;
								while($j <= $timeDay) {
									 $filterIpdDateArray[] = date('d-M', strtotime(date("Y-m-d", strtotime($patientAdmitDetailsVal['admit_date'])) . " +$j day"));
									 $filterIpdCountArray[date('d-M', strtotime(date("Y-m-d", strtotime($patientAdmitDetailsVal['admit_date'])) . " +$j day"))] += 1;
									 $j++;
								}
								
							} else if($i == $diffDate) {
							    //$maxDate = date("Y")."-".date("m")."-".cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y"));
							    $maxDate = $this->DateFormat->formatDate2STDForReport(date("Y-m-d"),Configure::read('date_format'));
							    $startDate = date("Y")."-".date("m")."-"."01";
							    $interval = $this->DateFormat->dateDiff($startDate,$maxDate);
							    $timeDay 	= $interval->days;
							    // create days and store the value in it
							    $j=0;
								while($j <= $timeDay) {
									 $filterIpdDateArray[] = date('d-M', strtotime(date("Y-m-d", strtotime($startDate)) . " +$j day"));
									 $filterIpdCountArray[date('d-M', strtotime(date("Y-m-d", strtotime($startDate)) . " +$j day"))] += 1;
									 $j++;
								}
						    } else {
							    $maxDate = $expPatientAdmitDate[0]."-".($expPatientAdmitDate[1]+$i)."-".cal_days_in_month(CAL_GREGORIAN, ($expPatientAdmitDate[1]+$i), $expPatientAdmitDate[0]);
							    $startDate = $expPatientAdmitDate[0]."-".($expPatientAdmitDate[1]+$i)."-"."01";
							    
							    $interval = $this->DateFormat->dateDiff($startDate,$maxDate);
						        $timeDay 	= $interval->days;
						        // create days and store the value in it
							    $j=0;
								while($j <= $timeDay) {
									 $filterIpdDateArray[] = date('d-M', strtotime(date("Y-m-d", strtotime($startDate)) . " +$j day"));
									 $filterIpdCountArray[date('d-M', strtotime(date("Y-m-d", strtotime($startDate)) . " +$j day"))] += 1;
									 $j++;
								}
								
							}
							$i++;
						}
						
					 }
												
					}
				// close if admit //
			} else { 
				// if admit and dischare are on same month otherwise go to else //
				if($patientAdmitDetailsVal['month'] == $patientDischargeDetails[$key]['month']) {
					$interval = $this->DateFormat->dateDiff($patientAdmitDetailsVal['admit_date'], $patientDischargeDetails[$key]['discharge_date']);
					$timeDay 	= $interval->days;
				    // create days and store the value in it
					$j=0;
					while($j <= $timeDay) {
						 $filterIpdDateArray[] = date('d-M', strtotime(date("Y-m-d", strtotime($patientAdmitDetailsVal['admit_date'])) . " +$j day"));
						 $filterIpdCountArray[date('d-M', strtotime(date("Y-m-d", strtotime($patientAdmitDetailsVal['admit_date'])) . " +$j day"))] += 1;
						 $j++;
					}
					
				} else {
					if(in_array($key, $dischargePatientIdArray)) {
					    $expPatientAdmitDate = explode("-", $patientAdmitDetailsVal['admit_date']);
					    $expPatientDischargeDate = explode("-", $patientDischargeDetails[$key]['discharge_date']);
						// more than one month gap //
						$diffDate = date("m-Y" , strtotime($patientDischargeDetails[$key]['discharge_date'])) - date("m-Y", strtotime($patientAdmitDetailsVal['admit_date']));
						
						$i=0;
						while($i <= $diffDate) {
							if($i == 0) {
								$maxDate = $expPatientAdmitDate[0]."-".$expPatientAdmitDate[1]."-".cal_days_in_month(CAL_GREGORIAN, $expPatientAdmitDate[1], $expPatientAdmitDate[0]);
							    $interval = $this->DateFormat->dateDiff($patientAdmitDetailsVal['admit_date'],$maxDate);
						        $timeDay 	= $interval->days;
							    // create days and store the value in it
					            $j=0;
								while($j <= $timeDay) {
									 $filterIpdDateArray[] = date('d-M', strtotime(date("Y-m-d", strtotime($patientAdmitDetailsVal['admit_date'])) . " +$j day"));
									 $filterIpdCountArray[date('d-M', strtotime(date("Y-m-d", strtotime($patientAdmitDetailsVal['admit_date'])) . " +$j day"))] += 1;
									 $j++;
								}
							} else if($i == $diffDate) {
							    $maxDate = $patientDischargeDetails[$key]['discharge_date'];
							    $startDate = $expPatientDischargeDate[0]."-".$expPatientDischargeDate[1]."-"."01";
							    $interval = $this->DateFormat->dateDiff($startDate,$maxDate);
							    $timeDay 	= $interval->days;
							    // create days and store the value in it
							    
					            $j=0;
								while($j <= $timeDay) {
									 $filterIpdDateArray[] = date('d-M', strtotime(date("Y-m-d", strtotime($startDate)) . " +$j day"));
									 $filterIpdCountArray[date('d-M', strtotime(date("Y-m-d", strtotime($startDate)) . " +$j day"))] += 1;
									 $j++;
								}
								
							} else {
							    $maxDate = $expPatientAdmitDate[0]."-".($expPatientAdmitDate[1]+$i)."-".cal_days_in_month(CAL_GREGORIAN, ($expPatientAdmitDate[1]+$i), $expPatientAdmitDate[0]);
							    $startDate = $expPatientAdmitDate[0]."-".($expPatientAdmitDate[1]+$i)."-"."01";
							    $interval = $this->DateFormat->dateDiff($startDate,$maxDate);
						        $timeDay 	= $interval->days;
							    // create days and store the value in it
					            $j=0;
								while($j <= $timeDay) {
									 $filterIpdDateArray[] = date('d-M', strtotime(date("Y-m-d", strtotime($startDate)) . " +$j day"));
									 $filterIpdCountArray[date('d-M', strtotime(date("Y-m-d", strtotime($startDate)) . " +$j day"))] += 1;
									 $j++;
								}
								
							}
							$i++;
						} 
					} else {
						$expPatientAdmitDate = explode("-", $patientAdmitDetailsVal['admit_date']);
						// more than one month gap //
						$diffDate = date("m-Y") - date("m-Y", strtotime($patientAdmitDetailsVal['admit_date']));
						
						$i=0;
						while($i <= $diffDate) {
							if($i == 0) {
								//$maxDate = $expPatientAdmitDate[0]."-".$expPatientAdmitDate[1]."-".cal_days_in_month(CAL_GREGORIAN, $expPatientAdmitDate[1], $expPatientAdmitDate[0]);
								$maxDate = $this->DateFormat->formatDate2STDForReport(date("Y-m-d"),Configure::read('date_format'));
							    $interval = $this->DateFormat->dateDiff($patientAdmitDetailsVal['admit_date'],$maxDate);
						        $timeDay 	= $interval->days;
							    // create days and store the value in it
					            $j=0;
								while($j <= $timeDay) {
									 $filterIpdDateArray[] = date('d-M', strtotime(date("Y-m-d", strtotime($patientAdmitDetailsVal['admit_date'])) . " +$j day"));
									 $filterIpdCountArray[date('d-M', strtotime(date("Y-m-d", strtotime($patientAdmitDetailsVal['admit_date'])) . " +$j day"))] += 1;
									 $j++;
								}
								
							} else if($i == $diffDate) {
							    //$maxDate = date("Y")."-".date("m")."-".cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y"));
							    $maxDate = $this->DateFormat->formatDate2STDForReport(date("Y-m-d"),Configure::read('date_format'));
							    $startDate = date("Y")."-".date("m")."-"."01";
							    $interval = $this->DateFormat->dateDiff($startDate,$maxDate);
							    $timeDay 	= $interval->days;
							    // create days and store the value in it
					            $j=0;
								while($j <= $timeDay) {
									 $filterIpdDateArray[] = date('d-M', strtotime(date("Y-m-d", strtotime($startDate)) . " +$j day"));
									 $filterIpdCountArray[date('d-M', strtotime(date("Y-m-d", strtotime($startDate)) . " +$j day"))] += 1;
									 $j++;
								}
						  	 } else {
							    $maxDate = $expPatientAdmitDate[0]."-".($expPatientAdmitDate[1]+$i)."-".cal_days_in_month(CAL_GREGORIAN, ($expPatientAdmitDate[1]+$i), $expPatientAdmitDate[0]);
							    $startDate = $expPatientAdmitDate[0]."-".($expPatientAdmitDate[1]+$i)."-"."01";
							    $interval = $this->DateFormat->dateDiff($startDate,$maxDate);
						        $timeDay 	= $interval->days;
						  	    // create days and store the value in it
					            $j=0;
								while($j <= $timeDay) {
									 $filterIpdDateArray[] = date('d-M', strtotime(date("Y-m-d", strtotime($startDate)) . " +$j day"));
									 $filterIpdCountArray[date('d-M', strtotime(date("Y-m-d", strtotime($startDate)) . " +$j day"))] += 1;
									 $j++;
								}
								
							}
							$i++;
						}
					 }
												
					}
				}
		
			//print_r($filterIpdDateArray);exit;
			$lastval = $patientAdmitDetailsVal['month'];
		}
		 
		$this->set('filterIpdDateArray', isset($filterIpdDateArray)?$filterIpdDateArray:"");
		$this->set('filterIpdCountArray', isset($filterIpdCountArray)?$filterIpdCountArray:0);
		 
		 
	}
	/**
	 * Ward Occupancy Rate Excel Report
	 */

	public function ward_occupancy_rate_xls(){
		#echo 'here';exit;
		$this->uses = array('Bed','Patient');
		if ($this->request->is('post')) {#echo $this->request->data['reportYear'];exit;
			$reportYear = $this->request->data['reportYear'];
			$reportMonth = $this->request->data['reportMonth'];
			$fromDate = $reportYear."-01-01"; // set first date of current year
			$toDate = $reportYear."-12-31"; // set last date of current year
			if(!empty($reportMonth)) {
				$startDate=1;
				$countDays = cal_days_in_month(CAL_GREGORIAN, $reportMonth, $reportYear);
				while($startDate <= $countDays) {
					$dateVal = $reportYear."-".$reportMonth."-".$startDate;
					$yaxisIndex = date("d-M", strtotime($dateVal));
					$yaxisArray[$yaxisIndex] = date("d-F-Y", strtotime($dateVal));
					$startDate++;
				}
				$this->monthlyWardOccupancy($yaxisArray,$reportYear);
				$this->set('yaxisArray', $yaxisArray);
				$this->set('reportMonth', $reportMonth);
			} else {
				if($reportYear == date("Y")) {
					$lastMidFromoDate = $reportYear."-01-01 00:00:00";
					$lastMidToDate = date("Y-m-d H:i:s", mktime(23, 59, 59, date("m"), date("d")-1, date("Y")));
				} else {
					$lastMidFromoDate = $reportYear."-01-01 00:00:00";
					$lastMidToDate = $reportYear."-12-31 23:59:59";
				}
				$wardOccupancyCount = $this->Bed->find('all', array('conditions' => array('modify_time BETWEEN ? AND ?' => array($lastMidFromoDate,$lastMidToDate), 'patient_id' =>0, 'Bed.location_id' => $this->Session->read('locationid')), 'fields' => array('COUNT(*) AS bedcount', 'DATE_FORMAT(modify_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(modify_time, "%Y-%m-%d %H:%i:%s") AS bed_date', 'Bed.location_id', 'Bed.id','Bed.patient_id'), 'group' => array("month_reports")));
				$this->losreports($fromDate,$toDate);
	
				foreach($wardOccupancyCount as $wardOccupancy) {
					$filterWardArray[] = $wardOccupancy[0]['month_reports'];
					$filterWardCountArray[$wardOccupancy[0]['month_reports']] = $wardOccupancy[0]['bedcount'];
				}#pr($filterWardCountArray);exit;
				$this->set('filterWardArray', isset($filterWardArray)?$filterWardArray:"");
				$this->set('filterWardCountArray', isset($filterWardCountArray)?$filterWardCountArray:0);
					
				while($toDate > $fromDate) {
					$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
					$expfromdate = explode("-", $fromDate);
					$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
				}
				$this->set('yaxisArray',$yaxisArray);
			}
		}else{

			$fromDate = date("Y")."-01-01";
			$toDate = date("Y")."-12-31";
			$lastMidFromoDate = date("Y")."-01-01 00:00:00";
			$lastMidToDate = date("Y-m-d H:i:s", mktime(23, 59, 59, date("m"), date("d")-1, date("Y")));

			$wardOccupancyCount = $this->Bed->find('all', array('conditions' => array('modify_time BETWEEN ? AND ?' => array($lastMidFromoDate,$lastMidToDate), 'patient_id' =>0, 'Bed.location_id' => $this->Session->read('locationid')), 'fields' => array('COUNT(*) AS bedcount', 'DATE_FORMAT(modify_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(modify_time, "%Y-%m-%d %H:%i:%s") AS bed_date', 'Bed.location_id', 'Bed.id','Bed.patient_id'), 'group' => array("month_reports")));
			$this->losreports($fromDate,$toDate);

			foreach($wardOccupancyCount as $wardOccupancy) {
				$filterWardArray[] = $wardOccupancy[0]['month_reports'];
				$filterWardCountArray[$wardOccupancy[0]['month_reports']] = $wardOccupancy[0]['bedcount'];
			}#pr($filterWardCountArray);exit;
			$this->set('filterWardArray', isset($filterWardArray)?$filterWardArray:"");
			$this->set('filterWardCountArray', isset($filterWardCountArray)?$filterWardCountArray:0);
				
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray',$yaxisArray);
		}
		$totalBed = $this->Bed->find('count',array('conditions'=>array('Bed.location_id'=>$this->Session->read('locationid'))));
		$this->set('totalBed', $totalBed);
		$this->set('reportYear', isset($this->request->data['reportYear'])?$this->request->data['reportYear']:date("Y"));
		//pr($filterWardCountArray);exit;
		$this->layout = false;
	}

	/**
	 * Ward Occupancy Rate Excel Report
	 */

	public function ward_occupancy_rate_chart(){
		$this->uses = array('Bed','Patient');
		if ($this->request->is('post')) {#echo $this->request->data['reportYear'];exit;
			$reportYear = $this->request->data['reportYear'];
			$reportMonth = $this->request->data['reportMonth'];
			$fromDate = $reportYear."-01-01"; // set first date of current year
			$toDate = $reportYear."-12-31"; // set last date of current year
			if(!empty($reportMonth)) {
				$startDate=1;
				$countDays = cal_days_in_month(CAL_GREGORIAN, $reportMonth, $reportYear);
				while($startDate <= $countDays) {
					$dateVal = $reportYear."-".$reportMonth."-".$startDate;
					$yaxisIndex = date("d-M", strtotime($dateVal));
					$yaxisArray[$yaxisIndex] = date("d-F-Y", strtotime($dateVal));
					$startDate++;
				}
				$this->monthlyWardOccupancy($yaxisArray,$reportYear);
				$this->set('yaxisArray', $yaxisArray);
				$this->set('reportMonth', $reportMonth);
			} else {
				if($reportYear == date("Y")) {
					$lastMidFromoDate = $reportYear."-01-01 00:00:00";
					$lastMidToDate = date("Y-m-d H:i:s", mktime(23, 59, 59, date("m"), date("d")-1, date("Y")));
				} else {
					$lastMidFromoDate = $reportYear."-01-01 00:00:00";
					$lastMidToDate = $reportYear."-12-31 23:59:59";
				}
	
				$wardOccupancyCount = $this->Bed->find('all', array('conditions' => array('modify_time BETWEEN ? AND ?' => array($lastMidFromoDate,$lastMidToDate), 'patient_id' =>0, location_id => $this->Session->read('locationid')), 'fields' => array('COUNT(*) AS bedcount', 'DATE_FORMAT(modify_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(modify_time, "%Y-%m-%d %H:%i:%s") AS bed_date', 'Bed.location_id', 'Bed.id','Bed.patient_id'), 'group' => array("month_reports")));
				$this->losreports($fromDate,$toDate);
	
				foreach($wardOccupancyCount as $wardOccupancy) {
					$filterWardArray[] = $wardOccupancy[0]['month_reports'];
					$filterWardCountArray[$wardOccupancy[0]['month_reports']] = $wardOccupancy[0]['bedcount'];
				}#pr($filterWardCountArray);exit;
				$this->set('filterWardArray', isset($filterWardArray)?$filterWardArray:"");
				$this->set('filterWardCountArray', isset($filterWardCountArray)?$filterWardCountArray:0);
					
				while($toDate > $fromDate) {
					$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
					$expfromdate = explode("-", $fromDate);
					$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
				}
				$this->set('yaxisArray',$yaxisArray);
			}
			$totalBed = $this->Bed->find('count',array('conditions'=>array('Bed.location_id'=>$this->Session->read('locationid'))));
			$this->set('totalBed', $totalBed);
			$this->set('reportYear', $reportYear);
		}

	}

	/**
	 * staff survey chart
	 *
	 */

	public function admin_staff_survey_chart() {
		$this->set('title_for_layout', __('Staff Survey Reports Chart', true));
		$this->uses = array('StaffSurvey');
		$totalNumber = $this->StaffSurvey->find('count', array('conditions' => array('StaffSurvey.location_id' => $this->Session->read('locationid')), 'group' => array('user_id')));

		$yesResults = $this->StaffSurvey->find('all', array('fields' => array('COUNT(*) AS report_results', 'question_id', 'answer', 'location_id', 'id'), 'conditions' => array('StaffSurvey.location_id' => $this->Session->read('locationid'), 'StaffSurvey.answer' => 'Y'), 'group' => array('question_id', 'answer'), 'order' => array('question_id')));
		foreach($yesResults as $yesResultsVal) {
			$yesQuestionIdArray[] = $yesResultsVal['StaffSurvey']['question_id'];
			$yesResultArray[$yesResultsVal['StaffSurvey']['question_id']] = $yesResultsVal[0]['report_results'];
		}
		$noResults = $this->StaffSurvey->find('all', array('fields' => array('COUNT(*) AS report_results', 'question_id', 'answer', 'location_id', 'id'), 'conditions' => array('StaffSurvey.location_id' => $this->Session->read('locationid'), 'StaffSurvey.answer' => 'N'), 'group' => array('question_id', 'answer'), 'order' => array('question_id')));
		foreach($noResults as $noResultsVal) {
			$noQuestionIdArray[] = $noResultsVal['StaffSurvey']['question_id'];
			$noResultArray[$noResultsVal['StaffSurvey']['question_id']] = $noResultsVal[0]['report_results'];
		}
		//print_r($yesQuestionIdArray);exit;
		$this->set('yesQuestionIdArray', $yesQuestionIdArray);
		$this->set('yesResultArray', $yesResultArray);
		$this->set('noQuestionIdArray', $noQuestionIdArray);
		$this->set('noResultArray', $noResultArray);
		$this->set('totalNumber', $totalNumber);
	}

	/**
	 * patient survey chart
	 *
	 */

	public function admin_patient_survey_chart() {
		$this->set('title_for_layout', __('Patient Survey Reports Chart', true));
		$this->uses = array('PatientSurvey');
		$totalNumber = $this->PatientSurvey->find('count', array('conditions' => array('PatientSurvey.location_id' => $this->Session->read('locationid')), 'group' => array('PatientSurvey.patient_id')));

		$strongAgreeResults = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS report_results', 'question_id', 'answer', 'location_id', 'id'), 'conditions' => array('PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.answer' => 'Strongly Agree'), 'group' => array('question_id', 'answer'), 'order' => array('question_id')));
		foreach($strongAgreeResults as $strongAgreeResultsVal) {
			$strongAgreeQuestionIdArray[] = $strongAgreeResultsVal['PatientSurvey']['question_id'];
			$strongAgreeResultArray[$strongAgreeResultsVal['PatientSurvey']['question_id']] = $strongAgreeResultsVal[0]['report_results'];
			$this->set('strongAgreeQuestionIdArray', $strongAgreeQuestionIdArray);
			$this->set('strongAgreeResultArray', $strongAgreeResultArray);
		}
		$agreeResults = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS report_results', 'question_id', 'answer', 'location_id', 'id'), 'conditions' => array('PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.answer' => 'Agree'), 'group' => array('question_id', 'answer'), 'order' => array('question_id')));
		foreach($agreeResults as $agreeResultsVal) {
			$agreeQuestionIdArray[] = $agreeResultsVal['PatientSurvey']['question_id'];
			$agreeResultArray[$agreeResultsVal['PatientSurvey']['question_id']] = $agreeResultsVal[0]['report_results'];
			$this->set('agreeQuestionIdArray', $agreeQuestionIdArray);
			$this->set('agreeResultArray', $agreeResultArray);
		}
		$nandResults = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS report_results', 'question_id', 'answer', 'location_id', 'id'), 'conditions' => array('PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.answer' => 'Neither Agree Nor  Disagree'), 'group' => array('question_id', 'answer'), 'order' => array('question_id')));
		foreach($nandResults as $nandResultsVal) {
			$nandQuestionIdArray[] = $nandResultsVal['PatientSurvey']['question_id'];
			$nandResultArray[$nandResultsVal['PatientSurvey']['question_id']] = $nandResultsVal[0]['report_results'];
			$this->set('nandQuestionIdArray', $nandQuestionIdArray);
			$this->set('nandResultArray', $nandResultArray);
		}
		$disagreeResults = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS report_results', 'question_id', 'answer', 'location_id', 'id'), 'conditions' => array('PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.answer' => 'Disagree'), 'group' => array('question_id', 'answer'), 'order' => array('question_id')));
		foreach($disagreeResults as $disagreeResultsVal) {
			$disagreeQuestionIdArray[] = $disagreeResultsVal['PatientSurvey']['question_id'];
			$disagreeResultArray[$disagreeResultsVal['PatientSurvey']['question_id']] = $disagreeResultsVal[0]['report_results'];
			$this->set('disagreeQuestionIdArray', $disagreeQuestionIdArray);
			$this->set('disagreeResultArray', $disagreeResultArray);
		}
		$strongDisagreeResults = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS report_results', 'question_id', 'answer', 'location_id', 'id'), 'conditions' => array('PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.answer' => 'Strongly Disagree'), 'group' => array('question_id', 'answer'), 'order' => array('question_id')));
		foreach($strongDisagreeResults as $strongDisagreeResultsVal) {
			$strongDisagreeQuestionIdArray[] = $strongDisagreeResultsVal['PatientSurvey']['question_id'];
			$strongDisagreeResultArray[$strongDisagreeResultsVal['PatientSurvey']['question_id']] = $strongDisagreeResultsVal[0]['report_results'];
			$this->set('strongDisagreeQuestionIdArray', $strongDisagreeQuestionIdArray);
			$this->set('strongDisagreeResultArray', $strongDisagreeResultArray);
		}
		$naResults = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS report_results', 'question_id', 'answer', 'location_id', 'id'), 'conditions' => array('PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.answer' => 'Not Applicable'), 'group' => array('question_id', 'answer'), 'order' => array('question_id')));
		foreach($naResults as $naResultsVal) {
			$naQuestionIdArray[] = $naResultsVal['PatientSurvey']['question_id'];
			$naResultArray[$naResultsVal['PatientSurvey']['question_id']] = $naResultsVal[0]['report_results'];
			$this->set('naQuestionIdArray', $naQuestionIdArray);
			$this->set('naResultArray', $naResultArray);
		}
		$this->set('totalNumber', $totalNumber);
	}

	/**
	 *
	 * surgical site infections reports
	 *
	 **/

	public function admin_surgical_site_infections() {
		$this->set('title_for_layout', __('Surgical Site Infections Report', true));
		$this->uses = array('SurgicalSiteInfection', 'OptAppointment');
		if ($this->request->is('post')) {
			$reportYear = $this->request->data['reportYear'];
			$fromDate = $reportYear."-01-01"; // set first date of current year
			$toDate = $reportYear."-12-31"; // set last date of current year
			$this->ssireports($fromDate,$toDate);
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray', $yaxisArray);
		} else {
			$fromDate = date("Y")."-01-01"; // set first date of current year
			$toDate = date("Y")."-12-31"; // set last date of current year
			$this->ssireports($fromDate,$toDate);
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray', $yaxisArray);
				
		}
		$this->set('reportYear', isset($this->request->data['reportYear'])?$this->request->data['reportYear']:date("Y"));

	}

	/**
	 *
	 * surgical site infection reports query
	 *
	 **/

	private function ssireports($fromDate=NULL, $toDate=NULL) {
		// ssi for surgical site infections count in surgical_site_infections table
		$ssiCount = $this->SurgicalSiteInfection->find('all', array('fields' => array('COUNT(*) AS ssicount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'SurgicalSiteInfection.patient_id', 'SurgicalSiteInfection.location_id', 'SurgicalSiteInfection.id'), 'group' => array("month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('SurgicalSiteInfection.location_id' => $this->Session->read('locationid')), 'recursive' => -1));
		foreach($ssiCount as $ssiCountVal) {
			$filterSsiDateArray[] = $ssiCountVal[0]['month_reports'];
			$filterSsiCountArray[$ssiCountVal[0]['month_reports']] = $ssiCountVal[0]['ssicount'];
		}
		$this->set('filterSsiDateArray', isset($filterSsiDateArray)?$filterSsiDateArray:"");
		$this->set('filterSsiCountArray', isset($filterSsiCountArray)?$filterSsiCountArray:0);
		// sp for surgical procedure completed count in opt_appointments table
		$spCount = $this->OptAppointment->find('all', array('fields' => array('COUNT(*) AS spcount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'OptAppointment.location_id', 'OptAppointment.procedure_complete', 'OptAppointment.id'), 'group' => array("month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('OptAppointment.location_id' => $this->Session->read('locationid'), 'OptAppointment.procedure_complete' =>  1), 'recursive' => -1));

		foreach($spCount as $spCountVal) {
			$filterSpDateArray[] = $spCountVal[0]['month_reports'];
			$filterSpCountArray[$spCountVal[0]['month_reports']] = $spCountVal[0]['spcount'];
		}
		$this->set('filterSpDateArray', isset($filterSpDateArray)?$filterSpDateArray:"");
		$this->set('filterSpCountArray', isset($filterSpCountArray)?$filterSpCountArray:0);
	}

	/**
	 * surgical site infection  chart
	 *
	 */


	public function admin_surgical_site_infections_chart() {
		$this->set('title_for_layout', __('Surgical Site Infections Chart', true));
		$this->uses = array('SurgicalSiteInfection', 'OptAppointment');
		if ($this->request->is('post')) {
			$reportYear = $this->request->data['reportYear'];
			$fromDate = $reportYear."-01-01"; // set first date of current year
			$toDate = $reportYear."-12-31"; // set last date of current year
			$this->ssireports($fromDate,$toDate);
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
		}
		$this->set('yaxisArray', $yaxisArray);
		$this->set('reportYear', $reportYear);
	}


	/**
	 * surgical site infections xls reports
	 *
	 */

	public function admin_surgical_site_infections_xls() {
		$this->uses = array('SurgicalSiteInfection', 'OptAppointment');
		if ($this->request->is('post')) {
			$reportYear = $this->request->data['reportYear'];
			$fromDate = $reportYear."-01-01"; // set first date of current year
			$toDate = $reportYear."-12-31"; // set last date of current year
			$this->ssireports($fromDate,$toDate);
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray', $yaxisArray);
		} else {
			$fromDate = date("Y")."-01-01"; // set first date of current year
			$toDate = date("Y")."-12-31"; // set last date of current year
			$this->ssireports($fromDate,$toDate);
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray', $yaxisArray);
				
		}
		$this->set('reportYear', isset($this->request->data['reportYear'])?$this->request->data['reportYear']:date("Y"));
		$this->layout = false;
	}



	/**
	 * hospital associated infetctions cent report
	 *
	 */

	public function admin_hai_cent() {
		$this->set('title_for_layout', __('Hospital Associated Infections Cent Report', true));
		$this->uses = array('NosocomialInfection', 'PatientExposure', 'FinalBilling');
		if ($this->request->is('post')) {
			$reportYear = $this->request->data['reportYear'];
			$fromDate = $reportYear."-01-01"; // set first date of current year
			$toDate = $reportYear."-12-31"; // set last date of current year
			$this->hai_allreports($fromDate,$toDate);
			$dischargeDeathCount = $this->FinalBilling->find('all', array('fields' => array('COUNT(*) AS dischargedeathcount', 'DATE_FORMAT(discharge_date, "%M-%Y") AS month_reports', 'DATE_FORMAT(discharge_date, "%Y-%m-%d") AS discharge_date', 'FinalBilling.location_id', 'FinalBilling.id'), 'group' => array("month_reports  HAVING  discharge_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('FinalBilling.location_id' => $this->Session->read('locationid'), 'FinalBilling.reason_of_discharge' =>  array('Recovered', 'DAMA','Death'))));

			foreach($dischargeDeathCount as $dischargeDeathCountVal) {
				$filterdischargeDeathDateArray[] = $dischargeDeathCountVal[0]['month_reports'];
				$filterdischargeDeathCountArray[$dischargeDeathCountVal[0]['month_reports']] = $dischargeDeathCountVal[0]['dischargedeathcount'];
			}
			$this->set('filterdischargeDeathDateArray', isset($filterdischargeDeathDateArray)?$filterdischargeDeathDateArray:"");
			$this->set('filterdischargeDeathCountArray', isset($filterdischargeDeathCountArray)?$filterdischargeDeathCountArray:0);

			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray', $yaxisArray);
		} else {
			$fromDate = date("Y")."-01-01"; // set first date of current year
			$toDate = date("Y")."-12-31"; // set last date of current year
			$this->hai_allreports($fromDate,$toDate);
			$dischargeDeathCount = $this->FinalBilling->find('all', array('fields' => array('COUNT(*) AS dischargedeathcount', 'DATE_FORMAT(discharge_date, "%M-%Y") AS month_reports', 'DATE_FORMAT(discharge_date, "%Y-%m-%d") AS discharge_date', 'FinalBilling.location_id', 'FinalBilling.id'), 'group' => array("month_reports  HAVING  discharge_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('FinalBilling.location_id' => $this->Session->read('locationid'), 'FinalBilling.reason_of_discharge' =>  array('Recovered', 'DAMA','Death'))));

			foreach($dischargeDeathCount as $dischargeDeathCountVal) {
				$filterdischargeDeathDateArray[] = $dischargeDeathCountVal[0]['month_reports'];
				$filterdischargeDeathCountArray[$dischargeDeathCountVal[0]['month_reports']] = $dischargeDeathCountVal[0]['dischargedeathcount'];
			}
			$this->set('filterdischargeDeathDateArray', isset($filterdischargeDeathDateArray)?$filterdischargeDeathDateArray:"");
			$this->set('filterdischargeDeathCountArray', isset($filterdischargeDeathCountArray)?$filterdischargeDeathCountArray:0);

			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray', $yaxisArray);
				
		}
		$this->set('reportYear', isset($this->request->data['reportYear'])?$this->request->data['reportYear']:date("Y"));

	}


	/**
	 * hospital associated cent reports chart
	 *
	 */


	public function admin_hai_cent_chart() {
		$this->set('title_for_layout', __('Hospital Associated Infections Cent Report Chart', true));
		$this->uses = array('NosocomialInfection', 'PatientExposure', 'FinalBilling');
		if ($this->request->is('post')) {
			$reportYear = $this->request->data['reportYear'];
			$fromDate = $reportYear."-01-01"; // set first date of current year
			$toDate = $reportYear."-12-31"; // set last date of current year
			$this->hai_allreports($fromDate,$toDate);

			$dischargeDeathCount = $this->FinalBilling->find('all', array('fields' => array('COUNT(*) AS dischargedeathcount', 'DATE_FORMAT(discharge_date, "%M-%Y") AS month_reports', 'DATE_FORMAT(discharge_date, "%Y-%m-%d") AS discharge_date', 'FinalBilling.location_id', 'FinalBilling.id'), 'group' => array("month_reports  HAVING  discharge_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('FinalBilling.location_id' => $this->Session->read('locationid'), 'FinalBilling.reason_of_discharge' =>  array('Recovered', 'DAMA','Death'))));

			foreach($dischargeDeathCount as $dischargeDeathCountVal) {
				$filterdischargeDeathDateArray[] = $dischargeDeathCountVal[0]['month_reports'];
				$filterdischargeDeathCountArray[$dischargeDeathCountVal[0]['month_reports']] = $dischargeDeathCountVal[0]['dischargedeathcount'];
			}
			$this->set('filterdischargeDeathDateArray', isset($filterdischargeDeathDateArray)?$filterdischargeDeathDateArray:"");
			$this->set('filterdischargeDeathCountArray', isset($filterdischargeDeathCountArray)?$filterdischargeDeathCountArray:0);

			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray', $yaxisArray);


		}
		$this->set('reportYear', isset($this->request->data['reportYear'])?$this->request->data['reportYear']:date("Y"));
	}


	/**
	 * hospital associated cent reports xls reports
	 *
	 */

	public function admin_hai_cent_xls() {
		$this->set('title_for_layout', __('Hospital Associated Infections Cent Report', true));
		$this->uses = array('NosocomialInfection', 'PatientExposure', 'FinalBilling');
		if ($this->request->is('post')) {
			$reportYear = $this->request->data['reportYear'];
			$fromDate = $reportYear."-01-01"; // set first date of current year
			$toDate = $reportYear."-12-31"; // set last date of current year
			$this->hai_allreports($fromDate,$toDate);
			$dischargeDeathCount = $this->FinalBilling->find('all', array('fields' => array('COUNT(*) AS dischargedeathcount', 'DATE_FORMAT(discharge_date, "%M-%Y") AS month_reports', 'DATE_FORMAT(discharge_date, "%Y-%m-%d") AS discharge_date', 'FinalBilling.location_id', 'FinalBilling.id'), 'group' => array("month_reports  HAVING  discharge_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('FinalBilling.location_id' => $this->Session->read('locationid'), 'FinalBilling.reason_of_discharge' =>  array('Recovered', 'DAMA','Death'))));

			foreach($dischargeDeathCount as $dischargeDeathCountVal) {
				$filterdischargeDeathDateArray[] = $dischargeDeathCountVal[0]['month_reports'];
				$filterdischargeDeathCountArray[$dischargeDeathCountVal[0]['month_reports']] = $dischargeDeathCountVal[0]['dischargedeathcount'];
			}
			$this->set('filterdischargeDeathDateArray', isset($filterdischargeDeathDateArray)?$filterdischargeDeathDateArray:"");
			$this->set('filterdischargeDeathCountArray', isset($filterdischargeDeathCountArray)?$filterdischargeDeathCountArray:0);

			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray', $yaxisArray);

		}

		$this->set('reportYear', isset($this->request->data['reportYear'])?$this->request->data['reportYear']:date("Y"));
		$this->layout = false;
	}

	/**
	@Name			: getCorporateLocationList
	@Created for	: To get the coporate location on selecting corporate as type. will call bye ajax.
	@created By		: Anand
	@created On		: 2/23/2012
	**/
	public function getCorporateLocationList() {
		$this->loadModel('CorporateLocation');
		$this->loadModel('InsuranceType');
		if($this->params['isAjax']) {
			$paycatid = $this->params->query['paymentCategoryId'];
			if($paycatid == "2") {
				$this->set('insurancetypelist', $this->InsuranceType->find('list', array('fields'=> array('id', 'name'),'conditions' => array('InsuranceType.is_deleted' => 0, 'InsuranceType.credit_type_id' => $paycatid),'order'=>array('name'))));
				$this->render('ajaxgetinsutypes');
			}else if($paycatid == "1") {
				$this->set('corporatelocationlist', $this->CorporateLocation->find('list', array('fields'=> array('id', 'name'),'conditions' => array('CorporateLocation.is_deleted' => 0, 'CorporateLocation.credit_type_id' => $paycatid,'CorporateLocation.location_id'=>$this->Session->read('locationid')),'order'=>array('CorporateLocation.name'))));
				$this->render('ajaxgetcorplocations');
			} else {
				$this->render('ajaxgetcashtype');
			}
			 
			$this->layout = 'ajax';
		}
	}


	/**
	@Name			: getCropList
	@Created for	: To get the coporate location on selecting corporate as type. will call bye ajax.
	@created By		: Anand
	@created On		: 2/23/2012
	**/
	public function getCropList() {
		$this->loadModel('Corporate');
		if($this->params['isAjax']) {
			$this->set('corporatelist', $this->Corporate->find('list', array('fields'=> array('id', 'name'),'conditions' => array('Corporate.is_deleted' => 0, 'Corporate.corporate_location_id' => $this->params->query['ajaxcorporateid'],'Corporate.location_id'=>$this->Session->read('locationid')),'order'=>array('Corporate.name'))));
			$this->layout = 'ajax';
			$this->render('ajaxgetcorporate');
		}
	}


	/**
	@Name			: getInsComLis
	@Created for	: To get the coporate location on selecting corporate as type. will call bye ajax.
	@created By		: Anand
	@created On		: 2/23/2012
	**/
	public function getInsComList() {
		$this->loadModel('InsuranceCompany');
		if($this->params['isAjax']) {
			$this->set('insurancecompanylist', $this->InsuranceCompany->find('list', array('fields'=> array('id', 'name'),'conditions' => array('InsuranceCompany.is_deleted' => 0, 'InsuranceCompany.insurance_type_id' => $this->params->query['insurancetypeid'],'InsuranceCompany.location_id'=>$this->Session->read('locationid')))));
			$this->layout = 'ajax';
			$this->render('ajaxgetinsucomp');
		}
	}

	/**
	@Name			: getcorpsublocation
	@Created for	: To get the coporate as type. will call bye ajax.
	@created By		: Anand
	@created On		: 2/23/2012
	**/

	public function getcorpsublocation(){
		$this->uses = array('Corporate','CorporateSublocation');
		if($this->params['isAjax']) {
			
		 $this->set('corporatesulloclist', $this->CorporateSublocation->find('list', array('fields'=> array('id', 'name'),'conditions' => array('CorporateSublocation.is_deleted' => 0, 'CorporateSublocation.corporate_id' => $this->params->query['ajaxcorporateid']),'order'=>array('CorporateSublocation.name'))));
		 
		 $this->layout = 'ajax';
		 $this->render('ajaxgetcorpsublocation');
	 }
	}


	/**
	 *
	 * annually staff survey reports
	 *
	 **/

	public function admin_staffsurvey_reports() {
		$this->set('title_for_layout', __('Staff Survey Reports', true));
		$this->uses = array('StaffSurvey');
		if ($this->request->is('post')) {
			$reportYear = $this->request->data['reportYear'];
			$fromDate = $reportYear."-01-01"; // set first date of current year
			$toDate = $reportYear."-12-31"; // set last date of current year
			$this->staffreports($fromDate,$toDate);
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray', $yaxisArray);
		} else {
			$fromDate = date("Y")."-01-01"; // set first date of current year
			$toDate = date("Y")."-12-31"; // set last date of current year
			$this->staffreports($fromDate,$toDate);
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray', $yaxisArray);
				
		}
		$this->set('reportYear', isset($this->request->data['reportYear'])?$this->request->data['reportYear']:date("Y"));

	}

	/**
	 *
	 * staff survey report query
	 *
	 **/

	private function staffreports($fromDate=NULL, $toDate=NULL) {
		$yesAnsCount = $this->StaffSurvey->find('all', array('fields' => array('COUNT(*) AS yesanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'StaffSurvey.question_id', 'StaffSurvey.location_id', 'StaffSurvey.id'), 'group' => array("question_id, month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('StaffSurvey.answer' => 'Y', 'StaffSurvey.location_id' => $this->Session->read('locationid')), 'recursive' => -1));

		foreach($yesAnsCount as $yesAnsCountVal) {
			$filterYesAnsDateArray[] = $yesAnsCountVal[0]['month_reports'];
			$filterYesAnsQuestIdArray[] = $yesAnsCountVal['StaffSurvey']['question_id'];
			$filterYesAnsCountArray[$yesAnsCountVal['StaffSurvey']['question_id']][$yesAnsCountVal[0]['month_reports']] = $yesAnsCountVal[0]['yesanscount'];
		}
		//pr($filterYesAnsCountArray);
		$this->set('filterYesAnsDateArray', isset($filterYesAnsDateArray)?$filterYesAnsDateArray:"");
		$this->set('filterYesAnsQuestIdArray', isset($filterYesAnsQuestIdArray)?$filterYesAnsQuestIdArray:"");
		$this->set('filterYesAnsCountArray', isset($filterYesAnsCountArray)?$filterYesAnsCountArray:0);

		$noAnsCount = $this->StaffSurvey->find('all', array('fields' => array('COUNT(*) AS noanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'StaffSurvey.question_id', 'StaffSurvey.location_id', 'StaffSurvey.id'), 'group' => array("question_id, month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('StaffSurvey.answer' => 'N', 'StaffSurvey.location_id' => $this->Session->read('locationid')), 'recursive' => -1));

		foreach($noAnsCount as $noAnsCountVal) {
			$filterNoAnsDateArray[] = $noAnsCountVal[0]['month_reports'];
			$filterNoAnsQuestIdArray[] = $noAnsCountVal['StaffSurvey']['question_id'];
			$filterNoAnsCountArray[$noAnsCountVal['StaffSurvey']['question_id']][$noAnsCountVal[0]['month_reports']] = $noAnsCountVal[0]['noanscount'];
		}
		$this->set('filterNoAnsDateArray', isset($filterNoAnsDateArray)?$filterNoAnsDateArray:"");
		$this->set('filterNoAnsQuestIdArray', isset($filterNoAnsQuestIdArray)?$filterNoAnsQuestIdArray:"");
		$this->set('filterNoAnsCountArray', isset($filterNoAnsCountArray)?$filterNoAnsCountArray:0);
	}

	/**
	 * staff survey reports chart
	 *
	 */


	public function admin_staffsurvey_chart() {
		$this->set('title_for_layout', __('Staff Survey Reports Chart', true));
		$this->uses = array('StaffSurvey');
		if ($this->request->is('post')) {
			$reportYear = $this->request->data['reportYear'];
			$fromDate = $reportYear."-01-01"; // set first date of current year
			$toDate = $reportYear."-12-31"; // set last date of current year

			$yesAnsCount = $this->StaffSurvey->find('all', array('fields' => array('COUNT(*) AS yesanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'StaffSurvey.question_id', 'StaffSurvey.location_id', 'StaffSurvey.id'), 'group' => array("month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('StaffSurvey.answer' => 'Y', 'StaffSurvey.location_id' => $this->Session->read('locationid')), 'recursive' => -1));

			foreach($yesAnsCount as $yesAnsCountVal) {
				$filterYesAnsDateArray[] = $yesAnsCountVal[0]['month_reports'];
				$filterYesAnsCountArray[$yesAnsCountVal[0]['month_reports']] = $yesAnsCountVal[0]['yesanscount'];
			}

			$this->set('filterYesAnsDateArray', isset($filterYesAnsDateArray)?$filterYesAnsDateArray:"");
			$this->set('filterYesAnsCountArray', isset($filterYesAnsCountArray)?$filterYesAnsCountArray:0);

			$noAnsCount = $this->StaffSurvey->find('all', array('fields' => array('COUNT(*) AS noanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'StaffSurvey.question_id', 'StaffSurvey.location_id', 'StaffSurvey.id'), 'group' => array("month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('StaffSurvey.answer' => 'N', 'StaffSurvey.location_id' => $this->Session->read('locationid')), 'recursive' => -1));

			foreach($noAnsCount as $noAnsCountVal) {
				$filterNoAnsDateArray[] = $noAnsCountVal[0]['month_reports'];
				$filterNoAnsCountArray[$noAnsCountVal[0]['month_reports']] = $noAnsCountVal[0]['noanscount'];
			}
			$this->set('filterNoAnsDateArray', isset($filterNoAnsDateArray)?$filterNoAnsDateArray:"");
			$this->set('filterNoAnsCountArray', isset($filterNoAnsCountArray)?$filterNoAnsCountArray:0);


			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
		}
		$this->set('yaxisArray', $yaxisArray);
		$this->set('reportYear', $reportYear);
	}


	/**
	 * staff survey  xls reports
	 *
	 */

	public function admin_staffsurvey_xls() {
		$this->uses = array('StaffSurvey');
		if ($this->request->is('post')) {
			$reportYear = $this->request->data['reportYear'];
			$fromDate = $reportYear."-01-01"; // set first date of current year
			$toDate = $reportYear."-12-31"; // set last date of current year
			$this->staffreports($fromDate,$toDate);
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray', $yaxisArray);
		} else {
			$fromDate = date("Y")."-01-01"; // set first date of current year
			$toDate = date("Y")."-12-31"; // set last date of current year
			$this->staffreports($fromDate,$toDate);
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray', $yaxisArray);
		}
		$this->set('reportYear', isset($this->request->data['reportYear'])?$this->request->data['reportYear']:date("Y"));
		$this->layout = false;
	}

	/**
	 *
	 * annually patient survey reports
	 *
	 **/

	public function admin_patientsurvey_reports() {
		$this->set('title_for_layout', __('Patient Survey Reports', true));
		$this->uses = array('PatientSurvey');
		if ($this->request->is('post')) {
			$reportYear = $this->request->data['reportYear'];
			$fromDate = $reportYear."-01-01"; // set first date of current year
			$toDate = $reportYear."-12-31"; // set last date of current year
			$this->patientreports($fromDate,$toDate);
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray', $yaxisArray);
		} else {
			$fromDate = date("Y")."-01-01"; // set first date of current year
			$toDate = date("Y")."-12-31"; // set last date of current year
			$this->patientreports($fromDate,$toDate);
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray', $yaxisArray);
				
		}
		$this->set('reportYear', isset($this->request->data['reportYear'])?$this->request->data['reportYear']:date("Y"));

	}

	/**
	 *
	 * patient survey report query
	 *
	 **/

	private function patientreports($fromDate=NULL, $toDate=NULL) {
		$stAgreeAnsCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS stagreeanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("question_id, month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Strongly Agree', 'PatientSurvey.location_id' => $this->Session->read('locationid')), 'recursive' => -1));

		foreach($stAgreeAnsCount as $stAgreeAnsCountVal) {
			$filterStAgreeDateArray[] = $stAgreeAnsCountVal[0]['month_reports'];
			$filterStAgreeQuestIdArray[] = $stAgreeAnsCountVal['PatientSurvey']['question_id'];
			$filterStAgreeAnsCountArray[$stAgreeAnsCountVal['PatientSurvey']['question_id']][$stAgreeAnsCountVal[0]['month_reports']] = $stAgreeAnsCountVal[0]['stagreeanscount'];
		}
		$this->set('filterStAgreeDateArray', isset($filterStAgreeDateArray)?$filterStAgreeDateArray:"");
		$this->set('filterStAgreeQuestIdArray', isset($filterStAgreeQuestIdArray)?$filterStAgreeQuestIdArray:"");
		$this->set('filterStAgreeAnsCountArray', isset($filterStAgreeAnsCountArray)?$filterStAgreeAnsCountArray:0);

		$agreeAnsCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS agreeanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("question_id, month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Agree', 'PatientSurvey.location_id' => $this->Session->read('locationid')), 'recursive' => -1));

		foreach($agreeAnsCount as $agreeAnsCountVal) {
			$filterAgreeDateArray[] = $agreeAnsCountVal[0]['month_reports'];
			$filterAgreeQuestIdArray[] = $agreeAnsCountVal['PatientSurvey']['question_id'];
			$filterAgreeAnsCountArray[$agreeAnsCountVal['PatientSurvey']['question_id']][$agreeAnsCountVal[0]['month_reports']] = $agreeAnsCountVal[0]['agreeanscount'];
		}
		$this->set('filterAgreeDateArray', isset($filterAgreeDateArray)?$filterAgreeDateArray:"");
		$this->set('filterAgreeQuestIdArray', isset($filterAgreeQuestIdArray)?$filterAgreeQuestIdArray:"");
		$this->set('filterAgreeAnsCountArray', isset($filterAgreeAnsCountArray)?$filterAgreeAnsCountArray:0);

		$nandAnsCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS nandanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("question_id, month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Neither Agree Nor  Disagree', 'PatientSurvey.location_id' => $this->Session->read('locationid')), 'recursive' => -1));

		foreach($nandAnsCount as $nandAnsCountVal) {
			$filterNandDateArray[] = $nandAnsCountVal[0]['month_reports'];
			$filterNandQuestIdArray[] = $nandAnsCountVal['PatientSurvey']['question_id'];
			$filterNandAnsCountArray[$nandAnsCountVal['PatientSurvey']['question_id']][$nandAnsCountVal[0]['month_reports']] = $nandAnsCountVal[0]['nandanscount'];
		}
		$this->set('filterNandDateArray', isset($filterNandDateArray)?$filterNandDateArray:"");
		$this->set('filterNandQuestIdArray', isset($filterNandQuestIdArray)?$filterNandQuestIdArray:"");
		$this->set('filterNandAnsCountArray', isset($filterNandAnsCountArray)?$filterNandAnsCountArray:0);

		$disagreeAnsCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS disagreeanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("question_id, month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Disagree', 'PatientSurvey.location_id' => $this->Session->read('locationid')), 'recursive' => -1));

		foreach($disagreeAnsCount as $disagreeAnsCountVal) {
			$filterDisgreeDateArray[] = $disagreeAnsCountVal[0]['month_reports'];
			$filterDisgreeQuestIdArray[] = $disagreeAnsCountVal['PatientSurvey']['question_id'];
			$filterDisgreeAnsCountArray[$disagreeAnsCountVal['PatientSurvey']['question_id']][$disagreeAnsCountVal[0]['month_reports']] = $disagreeAnsCountVal[0]['disagreeanscount'];
		}
		$this->set('filterDisgreeDateArray', isset($filterDisgreeDateArray)?$filterDisgreeDateArray:"");
		$this->set('filterDisgreeQuestIdArray', isset($filterDisgreeQuestIdArray)?$filterDisgreeQuestIdArray:"");
		$this->set('filterDisgreeAnsCountArray', isset($filterDisgreeAnsCountArray)?$filterDisgreeAnsCountArray:0);

		$stdAnsCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS stdanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("question_id, month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Strongly Disagree', 'PatientSurvey.location_id' => $this->Session->read('locationid')), 'recursive' => -1));

		foreach($stdAnsCount as $stdAnsCountVal) {
			$filterStdDateArray[] = $stdAnsCountVal[0]['month_reports'];
			$filterStdQuestIdArray[] = $stdAnsCountVal['PatientSurvey']['question_id'];
			$filterStdAnsCountArray[$stdAnsCountVal['PatientSurvey']['question_id']][$stdAnsCountVal[0]['month_reports']] = $stdAnsCountVal[0]['stdanscount'];
		}
		$this->set('filterStdDateArray', isset($filterStdDateArray)?$filterStdDateArray:"");
		$this->set('filterStdQuestIdArray', isset($filterStdQuestIdArray)?$filterStdQuestIdArray:"");
		$this->set('filterStdAnsCountArray', isset($filterStdAnsCountArray)?$filterStdAnsCountArray:0);

		$naAnsCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS naanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("question_id, month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Not Applicable', 'PatientSurvey.location_id' => $this->Session->read('locationid')), 'recursive' => -1));

		foreach($naAnsCount as $naAnsCountVal) {
			$filterNaDateArray[] = $naAnsCountVal[0]['month_reports'];
			$filterNaQuestIdArray[] = $naAnsCountVal['PatientSurvey']['question_id'];
			$filterNaAnsCountArray[$naAnsCountVal['PatientSurvey']['question_id']][$naAnsCountVal[0]['month_reports']] = $naAnsCountVal[0]['naanscount'];
		}
		$this->set('filterNaDateArray', isset($filterNaDateArray)?$filterNaDateArray:"");
		$this->set('filterNaQuestIdArray', isset($filterNaQuestIdArray)?$filterNaQuestIdArray:"");
		$this->set('filterNaAnsCountArray', isset($filterNaAnsCountArray)?$filterNaAnsCountArray:0);
	}

	/**
	 * patient reports chart
	 *
	 */


	public function admin_patientsurvey_chart() {
		$this->set('title_for_layout', __('Patient Survey Reports Chart', true));
		$this->uses = array('PatientSurvey');
		if ($this->request->is('post')) {
			$reportYear = $this->request->data['reportYear'];
			$fromDate = $reportYear."-01-01"; // set first date of current year
			$toDate = $reportYear."-12-31"; // set last date of current year
			// chart query for all options include strong agree, disagree and so on //
			$stAgreeAnsCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS stagreeanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Strongly Agree', 'PatientSurvey.location_id' => $this->Session->read('locationid')), 'recursive' => -1));

			foreach($stAgreeAnsCount as $stAgreeAnsCountVal) {
				$filterStAgreeDateArray[] = $stAgreeAnsCountVal[0]['month_reports'];
				$filterStAgreeAnsCountArray[$stAgreeAnsCountVal[0]['month_reports']] = $stAgreeAnsCountVal[0]['stagreeanscount'];
			}
			$this->set('filterStAgreeDateArray', isset($filterStAgreeDateArray)?$filterStAgreeDateArray:"");
			$this->set('filterStAgreeAnsCountArray', isset($filterStAgreeAnsCountArray)?$filterStAgreeAnsCountArray:0);

			$agreeAnsCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS agreeanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Agree', 'PatientSurvey.location_id' => $this->Session->read('locationid')), 'recursive' => -1));

			foreach($agreeAnsCount as $agreeAnsCountVal) {
				$filterAgreeDateArray[] = $agreeAnsCountVal[0]['month_reports'];
				$filterAgreeAnsCountArray[$agreeAnsCountVal[0]['month_reports']] = $agreeAnsCountVal[0]['agreeanscount'];
			}
			$this->set('filterAgreeDateArray', isset($filterAgreeDateArray)?$filterAgreeDateArray:"");
			$this->set('filterAgreeAnsCountArray', isset($filterAgreeAnsCountArray)?$filterAgreeAnsCountArray:0);

			$nandAnsCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS nandanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Neither Agree Nor  Disagree', 'PatientSurvey.location_id' => $this->Session->read('locationid')), 'recursive' => -1));

			foreach($nandAnsCount as $nandAnsCountVal) {
				$filterNandDateArray[] = $nandAnsCountVal[0]['month_reports'];
				$filterNandAnsCountArray[$nandAnsCountVal[0]['month_reports']] = $nandAnsCountVal[0]['nandanscount'];
			}
			$this->set('filterNandDateArray', isset($filterNandDateArray)?$filterNandDateArray:"");
			$this->set('filterNandAnsCountArray', isset($filterNandAnsCountArray)?$filterNandAnsCountArray:0);

			$disagreeAnsCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS disagreeanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Disagree', 'PatientSurvey.location_id' => $this->Session->read('locationid')), 'recursive' => -1));

			foreach($disagreeAnsCount as $disagreeAnsCountVal) {
				$filterDisgreeDateArray[] = $disagreeAnsCountVal[0]['month_reports'];
				$filterDisgreeAnsCountArray[$disagreeAnsCountVal[0]['month_reports']] = $disagreeAnsCountVal[0]['disagreeanscount'];
			}
			$this->set('filterDisgreeDateArray', isset($filterDisgreeDateArray)?$filterDisgreeDateArray:"");
			$this->set('filterDisgreeAnsCountArray', isset($filterDisgreeAnsCountArray)?$filterDisgreeAnsCountArray:0);

			$stdAnsCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS stdanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Strongly Disagree', 'PatientSurvey.location_id' => $this->Session->read('locationid')), 'recursive' => -1));

			foreach($stdAnsCount as $stdAnsCountVal) {
				$filterStdDateArray[] = $stdAnsCountVal[0]['month_reports'];
				$filterStdAnsCountArray[$stdAnsCountVal[0]['month_reports']] = $stdAnsCountVal[0]['stdanscount'];
			}
			$this->set('filterStdDateArray', isset($filterStdDateArray)?$filterStdDateArray:"");
			$this->set('filterStdAnsCountArray', isset($filterStdAnsCountArray)?$filterStdAnsCountArray:0);

			$naAnsCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS naanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Not Applicable', 'PatientSurvey.location_id' => $this->Session->read('locationid')), 'recursive' => -1));

			foreach($naAnsCount as $naAnsCountVal) {
				$filterNaDateArray[] = $naAnsCountVal[0]['month_reports'];
				$filterNaAnsCountArray[$naAnsCountVal[0]['month_reports']] = $naAnsCountVal[0]['naanscount'];
			}
			$this->set('filterNaDateArray', isset($filterNaDateArray)?$filterNaDateArray:"");
			$this->set('filterNaAnsCountArray', isset($filterNaAnsCountArray)?$filterNaAnsCountArray:0);
			// end //
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
		}
		$this->set('yaxisArray', $yaxisArray);
		$this->set('reportYear', $reportYear);
	}


	/**
	 * patient survey  xls reports
	 *
	 */

	public function admin_patientsurvey_xls() {
		$this->uses = array('PatientSurvey');
		if ($this->request->is('post')) {
			$reportYear = $this->request->data['reportYear'];
			$fromDate = $reportYear."-01-01"; // set first date of current year
			$toDate = $reportYear."-12-31"; // set last date of current year
			$this->patientreports($fromDate,$toDate);
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray', $yaxisArray);
		} else {
			$fromDate = date("Y")."-01-01"; // set first date of current year
			$toDate = date("Y")."-12-31"; // set last date of current year
			$this->patientreports($fromDate,$toDate);
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray', $yaxisArray);
		}
		$this->set('reportYear', isset($this->request->data['reportYear'])?$this->request->data['reportYear']:date("Y"));
		$this->layout = false;
	}

	/**
	 * patient registration reports chart
	 *
	 */


	public function admin_patient_registration_chart() {
		$this->set('title_for_layout', __('Patient Registration Report Chart', true));
		$this->uses = array('Person');
		$reportYear = date('Y');
		$fromDate = $reportYear."-01-01"; // set first date of current year
		$toDate = $reportYear."-12-31"; // set last date of current year

		$patientRegCount = $this->Person->find('all', array('fields' => array('COUNT(*) AS patientregcount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'Person.patient_uid', 'Person.location_id', 'Person.id', 'Person.is_deleted'), 'group' => array("month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('Person.is_deleted' => 0, 'Person.location_id' => $this->Session->read('locationid')), 'recursive' => -1));

		foreach($patientRegCount as $patientRegCountVal) {
			$filterPatientRegDateArray[] = $patientRegCountVal[0]['month_reports'];
			$filterPatientRegCountArray[$patientRegCountVal[0]['month_reports']] = $patientRegCountVal[0]['patientregcount'];
		}

		$this->set('filterPatientRegDateArray', isset($filterPatientRegDateArray)?$filterPatientRegDateArray:"");
		$this->set('filterPatientRegCountArray', isset($filterPatientRegCountArray)?$filterPatientRegCountArray:0);

			
		while($toDate > $fromDate) {
			$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
			$expfromdate = explode("-", $fromDate);
			$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
		}
		 
		$this->set('yaxisArray', $yaxisArray);
		$this->set('reportYear', $reportYear);
	}

	/**
	 * patient ot reports chart
	 *
	 */


	public function admin_patient_ot_chart() {
		$this->set('title_for_layout', __('Patient OT Report Chart', true));
		$this->uses = array('OptAppointment');
		$reportYear = date("Y");
		$fromDate = $reportYear."-01-01"; // set first date of current year
		$toDate = $reportYear."-12-31"; // set last date of current year

		$majorCount = $this->OptAppointment->find('all', array('fields' => array('COUNT(*) AS majorcount', 'DATE_FORMAT(schedule_date, "%M-%Y") AS month_reports', 'OptAppointment.schedule_date', 'OptAppointment.operation_type', 'OptAppointment.location_id', 'OptAppointment.id','OptAppointment.procedure_complete'), 'group' => array("month_reports  HAVING  schedule_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('OptAppointment.procedure_complete' => 1, 'OptAppointment.operation_type' => 'major', 'OptAppointment.location_id' => $this->Session->read('locationid'), 'OptAppointment.is_deleted' => 0), 'recursive' => -1));

		foreach($majorCount as $majorCountVal) {
			$filterMajorDateArray[] = $majorCountVal[0]['month_reports'];
			$filterMajorCountArray[$majorCountVal[0]['month_reports']] = $majorCountVal[0]['majorcount'];
		}

		$this->set('filterMajorDateArray', isset($filterMajorDateArray)?$filterMajorDateArray:"");
		$this->set('filterMajorCountArray', isset($filterMajorCountArray)?$filterMajorCountArray:0);

		$minorCount = $this->OptAppointment->find('all', array('fields' => array('COUNT(*) AS minorcount', 'DATE_FORMAT(schedule_date, "%M-%Y") AS month_reports', 'OptAppointment.schedule_date', 'OptAppointment.operation_type', 'OptAppointment.location_id', 'OptAppointment.id','OptAppointment.procedure_complete'), 'group' => array("month_reports  HAVING  schedule_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('OptAppointment.procedure_complete' => 1, 'OptAppointment.operation_type' => 'minor', 'OptAppointment.location_id' => $this->Session->read('locationid'), 'OptAppointment.is_deleted' => 0), 'recursive' => -1));

		foreach($minorCount as $minorCountVal) {
			$filterMinorDateArray[] = $minorCountVal[0]['month_reports'];
			$filterMinorCountArray[$minorCountVal[0]['month_reports']] = $minorCountVal[0]['minorcount'];
		}

		$this->set('filterMinorDateArray', isset($filterMinorDateArray)?$filterMinorDateArray:"");
		$this->set('filterMinorCountArray', isset($filterMinorCountArray)?$filterMinorCountArray:0);


		while($toDate > $fromDate) {
			$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
			$expfromdate = explode("-", $fromDate);
			$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
		}
		 
		$this->set('yaxisArray', $yaxisArray);
		$this->set('reportYear', $reportYear);
	}

	/**
	 * patient discharge reports chart
	 *
	 */


	public function admin_patient_discharge_chart() {
		$this->set('title_for_layout', __('Patient Discharge Report Chart', true));
		$this->uses = array('FinalBilling');
		$reportYear = date("Y");
		$fromDate = $reportYear."-01-01"; // set first date of current year
		$toDate = $reportYear."-12-31"; // set last date of current year

		$recoverCount = $this->FinalBilling->find('all', array('fields' => array('COUNT(*) AS recovercount', 'DATE_FORMAT(discharge_date, "%M-%Y") AS month_reports', 'FinalBilling.discharge_date', 'FinalBilling.reason_of_discharge', 'FinalBilling.location_id', 'FinalBilling.id'), 'group' => array("month_reports  HAVING  discharge_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('FinalBilling.reason_of_discharge' => 'Recovered', 'FinalBilling.location_id' => $this->Session->read('locationid')), 'recursive' => -1));
		foreach($recoverCount as $recoverCountVal) {
			$filterRecoverDateArray[] = $recoverCountVal[0]['month_reports'];
			$filterRecoverCountArray[$recoverCountVal[0]['month_reports']] = $recoverCountVal[0]['recovercount'];
		}

		$this->set('filterRecoverDateArray', isset($filterRecoverDateArray)?$filterRecoverDateArray:"");
		$this->set('filterRecoverCountArray', isset($filterRecoverCountArray)?$filterRecoverCountArray:0);

		$damaCount = $this->FinalBilling->find('all', array('fields' => array('COUNT(*) AS damarcount', 'DATE_FORMAT(discharge_date, "%M-%Y") AS month_reports', 'FinalBilling.discharge_date', 'FinalBilling.reason_of_discharge', 'FinalBilling.location_id', 'FinalBilling.id'), 'group' => array("month_reports  HAVING  discharge_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('FinalBilling.reason_of_discharge' => 'DAMA', 'FinalBilling.location_id' => $this->Session->read('locationid')), 'recursive' => -1));
		foreach($damaCount as $damaCountVal) {
			$filterDamaDateArray[] = $damaCountVal[0]['month_reports'];
			$filterDamaCountArray[$damaCountVal[0]['month_reports']] = $damaCountVal[0]['damarcount'];
		}

		$this->set('filterDamaDateArray', isset($filterDamaDateArray)?$filterDamaDateArray:"");
		$this->set('filterDamaCountArray', isset($filterDamaCountArray)?$filterDamaCountArray:0);

		$deathCount = $this->FinalBilling->find('all', array('fields' => array('COUNT(*) AS deathcount', 'DATE_FORMAT(discharge_date, "%M-%Y") AS month_reports', 'FinalBilling.discharge_date', 'FinalBilling.reason_of_discharge', 'FinalBilling.location_id', 'FinalBilling.id'), 'group' => array("month_reports  HAVING  discharge_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('FinalBilling.reason_of_discharge' => 'Death', 'FinalBilling.location_id' => $this->Session->read('locationid')), 'recursive' => -1));
		foreach($deathCount as $deathCountVal) {
			$filterDeathDateArray[] = $deathCountVal[0]['month_reports'];
			$filterDeathCountArray[$deathCountVal[0]['month_reports']] = $deathCountVal[0]['deathcount'];
		}

		$this->set('filterDeathDateArray', isset($filterDeathDateArray)?$filterDeathDateArray:"");
		$this->set('filterDeathCountArray', isset($filterDeathCountArray)?$filterDeathCountArray:0);


		while($toDate > $fromDate) {
			$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
			$expfromdate = explode("-", $fromDate);
			$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
		}
		 
		$this->set('yaxisArray', $yaxisArray);
		$this->set('reportYear', $reportYear);
	}

	/**
	 * patient surveys type
	 *
	 */

	public function admin_patient_survey_type() {
	}

	/**
	 *
	 * annually OPD patient survey reports
	 *
	 **/

	public function admin_opdpatientsurvey_reports() {
		$this->set('title_for_layout', __('OPD Patient Survey Reports', true));
		$this->uses = array('PatientSurvey');
		if ($this->request->is('post')) {
			$reportYear = $this->request->data['reportYear'];
			$fromDate = $reportYear."-01-01"; // set first date of current year
			$toDate = $reportYear."-12-31"; // set last date of current year
			$this->cleanliness_survey($fromDate,$toDate);
			$this->service_survey($fromDate,$toDate);
			$this->satisfaction_survey($fromDate,$toDate);
			$this->recommendation_survey($fromDate,$toDate);
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray', $yaxisArray);
		} else {
			$fromDate = date("Y")."-01-01"; // set first date of current year
			$toDate = date("Y")."-12-31"; // set last date of current year
			$this->cleanliness_survey($fromDate,$toDate);
			$this->service_survey($fromDate,$toDate);
			$this->satisfaction_survey($fromDate,$toDate);
			$this->recommendation_survey($fromDate,$toDate);
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray', $yaxisArray);
				
		}
		$this->set('reportYear', isset($this->request->data['reportYear'])?$this->request->data['reportYear']:date("Y"));

	}

	/**
	 *
	 * cleanliness survey report query
	 *
	 **/

	private function cleanliness_survey($fromDate=NULL, $toDate=NULL) {
		$stAgreeCleanCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS stagreeanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("question_id, month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Strongly Agree', 'PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.survey_category' => 'cleanliness', 'PatientSurvey.patient_type' => 'OPD'), 'recursive' => -1));

		foreach($stAgreeCleanCount as $stAgreeCleanCountVal) {
			$stAgreeDateCleanArray[] = $stAgreeCleanCountVal[0]['month_reports'];
			$stAgreeQuestIdCleanArray[] = $stAgreeCleanCountVal['PatientSurvey']['question_id'];
			$stAgreeAnsCountCleanArray[$stAgreeCleanCountVal['PatientSurvey']['question_id']][$stAgreeCleanCountVal[0]['month_reports']] = $stAgreeCleanCountVal[0]['stagreeanscount'];
		}
		$this->set('stAgreeDateCleanArray', isset($stAgreeDateCleanArray)?$stAgreeDateCleanArray:"");
		$this->set('stAgreeQuestIdCleanArray', isset($stAgreeQuestIdCleanArray)?$stAgreeQuestIdCleanArray:"");
		$this->set('stAgreeAnsCountCleanArray', isset($stAgreeAnsCountCleanArray)?$stAgreeAnsCountCleanArray:0);

		$agreeCleanCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS agreeanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("question_id, month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Agree', 'PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.survey_category' => 'cleanliness', 'PatientSurvey.patient_type' => 'OPD'), 'recursive' => -1));

		foreach($agreeCleanCount as $agreeCleanCountVal) {
			$agreeDateCleanArray[] = $agreeCleanCountVal[0]['month_reports'];
			$agreeQuestIdCleanArray[] = $agreeCleanCountVal['PatientSurvey']['question_id'];
			$agreeAnsCountCleanArray[$agreeCleanCountVal['PatientSurvey']['question_id']][$agreeCleanCountVal[0]['month_reports']] = $agreeCleanCountVal[0]['agreeanscount'];
		}
		$this->set('agreeDateCleanArray', isset($agreeDateCleanArray)?$agreeDateCleanArray:"");
		$this->set('agreeQuestIdCleanArray', isset($agreeQuestIdCleanArray)?$agreeQuestIdCleanArray:"");
		$this->set('agreeAnsCountCleanArray', isset($agreeAnsCountCleanArray)?$agreeAnsCountCleanArray:0);

		$nandAnsCleanCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS nandanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("question_id, month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Neither Agree Nor  Disagree', 'PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.survey_category' => 'cleanliness', 'PatientSurvey.patient_type' => 'OPD'), 'recursive' => -1));

		foreach($nandAnsCleanCount as $nandAnsCleanCountVal) {
			$nandDateCleanArray[] = $nandAnsCleanCountVal[0]['month_reports'];
			$nandQuestIdCleanArray[] = $nandAnsCleanCountVal['PatientSurvey']['question_id'];
			$nandAnsCountCleanArray[$nandAnsCleanCountVal['PatientSurvey']['question_id']][$nandAnsCleanCountVal[0]['month_reports']] = $nandAnsCleanCountVal[0]['nandanscount'];
		}
		$this->set('nandDateCleanArray', isset($nandDateCleanArray)?$nandDateCleanArray:"");
		$this->set('nandQuestIdCleanArray', isset($nandQuestIdCleanArray)?$nandQuestIdCleanArray:"");
		$this->set('nandAnsCountCleanArray', isset($nandAnsCountCleanArray)?$nandAnsCountCleanArray:0);

		$disagreeAnsCleanCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS disagreeanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("question_id, month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Disagree', 'PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.survey_category' => 'cleanliness', 'PatientSurvey.patient_type' => 'OPD'), 'recursive' => -1));

		foreach($disagreeAnsCleanCount as $disagreeAnsCleanCountVal) {
			$disgreeDateCleanArray[] = $disagreeAnsCleanCountVal[0]['month_reports'];
			$disgreeQuestIdCleanArray[] = $disagreeAnsCleanCountVal['PatientSurvey']['question_id'];
			$disgreeAnsCountCleanArray[$disagreeAnsCleanCountVal['PatientSurvey']['question_id']][$disagreeAnsCleanCountVal[0]['month_reports']] = $disagreeAnsCleanCountVal[0]['disagreeanscount'];
		}
		$this->set('disgreeDateCleanArray', isset($disgreeDateCleanArray)?$disgreeDateCleanArray:"");
		$this->set('disgreeQuestIdCleanArray', isset($disgreeQuestIdCleanArray)?$disgreeQuestIdCleanArray:"");
		$this->set('disgreeAnsCountCleanArray', isset($disgreeAnsCountCleanArray)?$disgreeAnsCountCleanArray:0);

		$stdAnsCleanCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS stdanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("question_id, month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Strongly Disagree', 'PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.survey_category' => 'cleanliness', 'PatientSurvey.patient_type' => 'OPD'), 'recursive' => -1));

		foreach($stdAnsCleanCount as $stdAnsCleanCountVal) {
			$stdDateCleanArray[] = $stdAnsCleanCountVal[0]['month_reports'];
			$stdQuestIdCleanArray[] = $stdAnsCleanCountVal['PatientSurvey']['question_id'];
			$stdAnsCountCleanArray[$stdAnsCleanCountVal['PatientSurvey']['question_id']][$stdAnsCleanCountVal[0]['month_reports']] = $stdAnsCleanCountVal[0]['stdanscount'];
		}
		$this->set('stdDateCleanArray', isset($stdDateCleanArray)?$stdDateCleanArray:"");
		$this->set('stdQuestIdCleanArray', isset($stdQuestIdCleanArray)?$stdQuestIdCleanArray:"");
		$this->set('stdAnsCountCleanArray', isset($stdAnsCountCleanArray)?$stdAnsCountCleanArray:0);


	}

	/**
	 *
	 * service survey report query
	 *
	 **/

	private function service_survey($fromDate=NULL, $toDate=NULL) {
		$stAgreeServiceCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS stagreeanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("question_id, month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Strongly Agree', 'PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.survey_category' => 'service', 'PatientSurvey.patient_type' => 'OPD'), 'recursive' => -1));

		foreach($stAgreeServiceCount as $stAgreeServiceCountVal) {
			$stAgreeDateServiceArray[] = $stAgreeServiceCountVal[0]['month_reports'];
			$stAgreeQuestIdServiceArray[] = $stAgreeServiceCountVal['PatientSurvey']['question_id'];
			$stAgreeAnsCountServiceArray[$stAgreeServiceCountVal['PatientSurvey']['question_id']][$stAgreeServiceCountVal[0]['month_reports']] = $stAgreeServiceCountVal[0]['stagreeanscount'];
		}
		$this->set('stAgreeDateServiceArray', isset($stAgreeDateServiceArray)?$stAgreeDateServiceArray:"");
		$this->set('stAgreeQuestIdServiceArray', isset($stAgreeQuestIdServiceArray)?$stAgreeQuestIdServiceArray:"");
		$this->set('stAgreeAnsCountServiceArray', isset($stAgreeAnsCountServiceArray)?$stAgreeAnsCountServiceArray:0);

		$agreeServiceCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS agreeanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("question_id, month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Agree', 'PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.survey_category' => 'service', 'PatientSurvey.patient_type' => 'OPD'), 'recursive' => -1));

		foreach($agreeServiceCount as $agreeServiceCountVal) {
			$agreeDateServiceArray[] = $agreeServiceCountVal[0]['month_reports'];
			$agreeQuestIdServiceArray[] = $agreeServiceCountVal['PatientSurvey']['question_id'];
			$agreeAnsCountServiceArray[$agreeServiceCountVal['PatientSurvey']['question_id']][$agreeServiceCountVal[0]['month_reports']] = $agreeServiceCountVal[0]['agreeanscount'];
		}
		$this->set('agreeDateServiceArray', isset($agreeDateServiceArray)?$agreeDateServiceArray:"");
		$this->set('agreeQuestIdServiceArray', isset($agreeQuestIdServiceArray)?$agreeQuestIdServiceArray:"");
		$this->set('agreeAnsCountServiceArray', isset($agreeAnsCountServiceArray)?$agreeAnsCountServiceArray:0);

		$nandAnsServiceCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS nandanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("question_id, month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Neither Agree Nor  Disagree', 'PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.survey_category' => 'service', 'PatientSurvey.patient_type' => 'OPD'), 'recursive' => -1));

		foreach($nandAnsServiceCount as $nandAnsServiceCountVal) {
			$nandDateServiceArray[] = $nandAnsServiceCountVal[0]['month_reports'];
			$nandQuestIdServiceArray[] = $nandAnsServiceCountVal['PatientSurvey']['question_id'];
			$nandAnsCountServiceArray[$nandAnsServiceCountVal['PatientSurvey']['question_id']][$nandAnsServiceCountVal[0]['month_reports']] = $nandAnsServiceCountVal[0]['nandanscount'];
		}
		$this->set('nandDateServiceArray', isset($nandDateServiceArray)?$nandDateServiceArray:"");
		$this->set('nandQuestIdServiceArray', isset($nandQuestIdServiceArray)?$nandQuestIdServiceArray:"");
		$this->set('nandAnsCountServiceArray', isset($nandAnsCountServiceArray)?$nandAnsCountServiceArray:0);

		$disagreeAnsServiceCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS disagreeanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("question_id, month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Disagree', 'PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.survey_category' => 'service', 'PatientSurvey.patient_type' => 'OPD'), 'recursive' => -1));

		foreach($disagreeAnsServiceCount as $disagreeAnsServiceCountVal) {
			$disgreeDateServiceArray[] = $disagreeAnsServiceCountVal[0]['month_reports'];
			$disgreeQuestIdServiceArray[] = $disagreeAnsServiceCountVal['PatientSurvey']['question_id'];
			$disgreeAnsCountServiceArray[$disagreeAnsServiceCountVal['PatientSurvey']['question_id']][$disagreeAnsServiceCountVal[0]['month_reports']] = $disagreeAnsServiceCountVal[0]['disagreeanscount'];
		}
		$this->set('disgreeDateServiceArray', isset($disgreeDateServiceArray)?$disgreeDateServiceArray:"");
		$this->set('disgreeQuestIdServiceArray', isset($disgreeQuestIdServiceArray)?$disgreeQuestIdServiceArray:"");
		$this->set('disgreeAnsCountServiceArray', isset($disgreeAnsCountServiceArray)?$disgreeAnsCountServiceArray:0);

		$stdAnsServiceCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS stdanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("question_id, month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Strongly Disagree', 'PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.survey_category' => 'service', 'PatientSurvey.patient_type' => 'OPD'), 'recursive' => -1));

		foreach($stdAnsServiceCount as $stdAnsServiceCountVal) {
			$stdDateServiceArray[] = $stdAnsServiceCountVal[0]['month_reports'];
			$stdQuestIdServiceArray[] = $stdAnsServiceCountVal['PatientSurvey']['question_id'];
			$stdAnsCountServiceArray[$stdAnsServiceCountVal['PatientSurvey']['question_id']][$stdAnsServiceCountVal[0]['month_reports']] = $stdAnsServiceCountVal[0]['stdanscount'];
		}
		$this->set('stdDateServiceArray', isset($stdDateServiceArray)?$stdDateServiceArray:"");
		$this->set('stdQuestIdServiceArray', isset($stdQuestIdServiceArray)?$stdQuestIdServiceArray:"");
		$this->set('stdAnsCountServiceArray', isset($stdAnsCountServiceArray)?$stdAnsCountServiceArray:0);


	}

	/**
	 *
	 * satisfaction survey report query
	 *
	 **/

	private function satisfaction_survey($fromDate=NULL, $toDate=NULL) {
		$stAgreeSatisCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS stagreeanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("question_id, month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Strongly Agree', 'PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.survey_category' => 'satisfaction', 'PatientSurvey.patient_type' => 'OPD'), 'recursive' => -1));

		foreach($stAgreeSatisCount as $stAgreeSatisCountVal) {
			$stAgreeDateSatisArray[] = $stAgreeSatisCountVal[0]['month_reports'];
			$stAgreeQuestIdSatisArray[] = $stAgreeSatisCountVal['PatientSurvey']['question_id'];
			$stAgreeAnsCountSatisArray[$stAgreeSatisCountVal['PatientSurvey']['question_id']][$stAgreeSatisCountVal[0]['month_reports']] = $stAgreeSatisCountVal[0]['stagreeanscount'];
		}
		$this->set('stAgreeDateSatisArray', isset($stAgreeDateSatisArray)?$stAgreeDateSatisArray:"");
		$this->set('stAgreeQuestIdSatisArray', isset($stAgreeQuestIdSatisArray)?$stAgreeQuestIdSatisArray:"");
		$this->set('stAgreeAnsCountSatisArray', isset($stAgreeAnsCountSatisArray)?$stAgreeAnsCountSatisArray:0);

		$agreeSatisCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS agreeanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("question_id, month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Agree', 'PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.survey_category' => 'satisfaction', 'PatientSurvey.patient_type' => 'OPD'), 'recursive' => -1));

		foreach($agreeSatisCount as $agreeSatisCountVal) {
			$agreeDateSatisArray[] = $agreeSatisCountVal[0]['month_reports'];
			$agreeQuestIdSatisArray[] = $agreeSatisCountVal['PatientSurvey']['question_id'];
			$agreeAnsCountSatisArray[$agreeSatisCountVal['PatientSurvey']['question_id']][$agreeSatisCountVal[0]['month_reports']] = $agreeSatisCountVal[0]['agreeanscount'];
		}
		$this->set('agreeDateSatisArray', isset($agreeDateSatisArray)?$agreeDateSatisArray:"");
		$this->set('agreeQuestIdSatisArray', isset($agreeQuestIdSatisArray)?$agreeQuestIdSatisArray:"");
		$this->set('agreeAnsCountSatisArray', isset($agreeAnsCountSatisArray)?$agreeAnsCountSatisArray:0);

		$nandAnsSatisCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS nandanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("question_id, month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Neither Agree Nor  Disagree', 'PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.survey_category' => 'satisfaction', 'PatientSurvey.patient_type' => 'OPD'), 'recursive' => -1));

		foreach($nandAnsSatisCount as $nandAnsSatisCountVal) {
			$nandDateSatisArray[] = $nandAnsSatisCountVal[0]['month_reports'];
			$nandQuestIdSatisArray[] = $nandAnsSatisCountVal['PatientSurvey']['question_id'];
			$nandAnsCountSatisArray[$nandAnsSatisCountVal['PatientSurvey']['question_id']][$nandAnsSatisCountVal[0]['month_reports']] = $nandAnsSatisCountVal[0]['nandanscount'];
		}
		$this->set('nandDateSatisArray', isset($nandDateSatisArray)?$nandDateSatisArray:"");
		$this->set('nandQuestIdSatisArray', isset($nandQuestIdSatisArray)?$nandQuestIdSatisArray:"");
		$this->set('nandAnsCountSatisArray', isset($nandAnsCountSatisArray)?$nandAnsCountSatisArray:0);

		$disagreeAnsSatisCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS disagreeanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("question_id, month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Disagree', 'PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.survey_category' => 'satisfaction', 'PatientSurvey.patient_type' => 'OPD'), 'recursive' => -1));

		foreach($disagreeAnsSatisCount as $disagreeAnsSatisCountVal) {
			$disgreeDateSatisArray[] = $disagreeAnsSatisCountVal[0]['month_reports'];
			$disgreeQuestIdSatisArray[] = $disagreeAnsSatisCountVal['PatientSurvey']['question_id'];
			$disgreeAnsCountSatisArray[$disagreeAnsSatisCountVal['PatientSurvey']['question_id']][$disagreeAnsSatisCountVal[0]['month_reports']] = $disagreeAnsSatisCountVal[0]['disagreeanscount'];
		}
		$this->set('disgreeDateSatisArray', isset($disgreeDateSatisArray)?$disgreeDateSatisArray:"");
		$this->set('disgreeQuestIdSatisArray', isset($disgreeQuestIdSatisArray)?$disgreeQuestIdSatisArray:"");
		$this->set('disgreeAnsCountSatisArray', isset($disgreeAnsCountSatisArray)?$disgreeAnsCountSatisArray:0);

		$stdAnsSatisCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS stdanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("question_id, month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Strongly Disagree', 'PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.survey_category' => 'satisfaction', 'PatientSurvey.patient_type' => 'OPD'), 'recursive' => -1));

		foreach($stdAnsSatisCount as $stdAnsSatisCountVal) {
			$stdDateSatisArray[] = $stdAnsSatisCountVal[0]['month_reports'];
			$stdQuestIdSatisArray[] = $stdAnsSatisCountVal['PatientSurvey']['question_id'];
			$stdAnsCountSatisArray[$stdAnsSatisCountVal['PatientSurvey']['question_id']][$stdAnsSatisCountVal[0]['month_reports']] = $stdAnsSatisCountVal[0]['stdanscount'];
		}
		$this->set('stdDateSatisArray', isset($stdDateSatisArray)?$stdDateSatisArray:"");
		$this->set('stdQuestIdSatisArray', isset($stdQuestIdSatisArray)?$stdQuestIdSatisArray:"");
		$this->set('stdAnsCountSatisArray', isset($stdAnsCountSatisArray)?$stdAnsCountSatisArray:0);


	}

	/**
	 *
	 * recommendation survey report query
	 *
	 **/

	private function recommendation_survey($fromDate=NULL, $toDate=NULL) {
		$stAgreeRecomCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS stagreeanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("question_id, month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Strongly Agree', 'PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.survey_category' => 'recommendation', 'PatientSurvey.patient_type' => 'OPD'), 'recursive' => -1));

		foreach($stAgreeRecomCount as $stAgreeRecomCountVal) {
			$stAgreeDateRecomArray[] = $stAgreeRecomCountVal[0]['month_reports'];
			$stAgreeQuestIdRecomArray[] = $stAgreeRecomCountVal['PatientSurvey']['question_id'];
			$stAgreeAnsCountRecomArray[$stAgreeRecomCountVal['PatientSurvey']['question_id']][$stAgreeRecomCountVal[0]['month_reports']] = $stAgreeRecomCountVal[0]['stagreeanscount'];
		}
		$this->set('stAgreeDateRecomArray', isset($stAgreeDateRecomArray)?$stAgreeDateRecomArray:"");
		$this->set('stAgreeQuestIdRecomArray', isset($stAgreeQuestIdRecomArray)?$stAgreeQuestIdRecomArray:"");
		$this->set('stAgreeAnsCountRecomArray', isset($stAgreeAnsCountRecomArray)?$stAgreeAnsCountRecomArray:0);

		$agreeRecomCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS agreeanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("question_id, month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Agree', 'PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.survey_category' => 'recommendation', 'PatientSurvey.patient_type' => 'OPD'), 'recursive' => -1));

		foreach($agreeRecomCount as $agreeRecomCountVal) {
			$agreeDateRecomArray[] = $agreeRecomCountVal[0]['month_reports'];
			$agreeQuestIdRecomArray[] = $agreeRecomCountVal['PatientSurvey']['question_id'];
			$agreeAnsCountRecomArray[$agreeRecomCountVal['PatientSurvey']['question_id']][$agreeRecomCountVal[0]['month_reports']] = $agreeRecomCountVal[0]['agreeanscount'];
		}
		$this->set('agreeDateRecomArray', isset($agreeDateRecomArray)?$agreeDateRecomArray:"");
		$this->set('agreeQuestIdRecomArray', isset($agreeQuestIdRecomArray)?$agreeQuestIdRecomArray:"");
		$this->set('agreeAnsCountRecomArray', isset($agreeAnsCountRecomArray)?$agreeAnsCountRecomArray:0);

		$nandAnsRecomCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS nandanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("question_id, month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Neither Agree Nor  Disagree', 'PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.survey_category' => 'recommendation', 'PatientSurvey.patient_type' => 'OPD'), 'recursive' => -1));

		foreach($nandAnsRecomCount as $nandAnsRecomCountVal) {
			$nandDateRecomArray[] = $nandAnsRecomCountVal[0]['month_reports'];
			$nandQuestIdRecomArray[] = $nandAnsRecomCountVal['PatientSurvey']['question_id'];
			$nandAnsCountRecomArray[$nandAnsRecomCountVal['PatientSurvey']['question_id']][$nandAnsRecomCountVal[0]['month_reports']] = $nandAnsRecomCountVal[0]['nandanscount'];
		}
		$this->set('nandDateRecomArray', isset($nandDateRecomArray)?$nandDateRecomArray:"");
		$this->set('nandQuestIdRecomArray', isset($nandQuestIdRecomArray)?$nandQuestIdRecomArray:"");
		$this->set('nandAnsCountRecomArray', isset($nandAnsCountRecomArray)?$nandAnsCountRecomArray:0);

		$disagreeAnsRecomCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS disagreeanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("question_id, month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Disagree', 'PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.survey_category' => 'recommendation', 'PatientSurvey.patient_type' => 'OPD'), 'recursive' => -1));

		foreach($disagreeAnsRecomCount as $disagreeAnsRecomCountVal) {
			$disgreeDateRecomArray[] = $disagreeAnsRecomCountVal[0]['month_reports'];
			$disgreeQuestIdRecomArray[] = $disagreeAnsRecomCountVal['PatientSurvey']['question_id'];
			$disgreeAnsCountRecomArray[$disagreeAnsRecomCountVal['PatientSurvey']['question_id']][$disagreeAnsRecomCountVal[0]['month_reports']] = $disagreeAnsRecomCountVal[0]['disagreeanscount'];
		}
		$this->set('disgreeDateRecomArray', isset($disgreeDateRecomArray)?$disgreeDateRecomArray:"");
		$this->set('disgreeQuestIdRecomArray', isset($disgreeQuestIdRecomArray)?$disgreeQuestIdRecomArray:"");
		$this->set('disgreeAnsCountRecomArray', isset($disgreeAnsCountRecomArray)?$disgreeAnsCountRecomArray:0);

		$stdAnsRecomCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS stdanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("question_id, month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Strongly Disagree', 'PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.survey_category' => 'recommendation', 'PatientSurvey.patient_type' => 'OPD'), 'recursive' => -1));

		foreach($stdAnsRecomCount as $stdAnsRecomCountVal) {
			$stdDateRecomArray[] = $stdAnsRecomCountVal[0]['month_reports'];
			$stdQuestIdRecomArray[] = $stdAnsRecomCountVal['PatientSurvey']['question_id'];
			$stdAnsCountRecomArray[$stdAnsRecomCountVal['PatientSurvey']['question_id']][$stdAnsRecomCountVal[0]['month_reports']] = $stdAnsRecomCountVal[0]['stdanscount'];
		}
		$this->set('stdDateRecomArray', isset($stdDateRecomArray)?$stdDateRecomArray:"");
		$this->set('stdQuestIdRecomArray', isset($stdQuestIdRecomArray)?$stdQuestIdRecomArray:"");
		$this->set('stdAnsCountRecomArray', isset($stdAnsCountRecomArray)?$stdAnsCountRecomArray:0);


	}

	/**
	 *
	 * annually OPD patient survey xls reports
	 *
	 **/

	public function admin_opdpatientsurvey_xls() {
		$this->set('title_for_layout', __('OPD Patient Survey Reports', true));
		$this->uses = array('PatientSurvey');
		if ($this->request->is('post')) {
			$reportYear = $this->request->data['reportYear'];
			$fromDate = $reportYear."-01-01"; // set first date of current year
			$toDate = $reportYear."-12-31"; // set last date of current year
			$this->cleanliness_survey($fromDate,$toDate);
			$this->service_survey($fromDate,$toDate);
			$this->satisfaction_survey($fromDate,$toDate);
			$this->recommendation_survey($fromDate,$toDate);
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray', $yaxisArray);
		} else {
			$fromDate = date("Y")."-01-01"; // set first date of current year
			$toDate = date("Y")."-12-31"; // set last date of current year
			$this->cleanliness_survey($fromDate,$toDate);
			$this->service_survey($fromDate,$toDate);
			$this->satisfaction_survey($fromDate,$toDate);
			$this->recommendation_survey($fromDate,$toDate);
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray', $yaxisArray);
				
		}

		$this->layout = false;

	}

	/**
	 *
	 * annually OPD patient survey chart reports
	 *
	 **/

	public function admin_opdpatientsurvey_chart() {
		$this->set('title_for_layout', __('OPD Patient Survey Reports', true));
		$this->uses = array('PatientSurvey');
		if ($this->request->is('post')) {
			$reportYear = $this->request->data['reportYear'];
			$fromDate = $reportYear."-01-01"; // set first date of current year
			$toDate = $reportYear."-12-31"; // set last date of current year
			$this->cleanliness_survey($fromDate,$toDate);
			$this->service_survey($fromDate,$toDate);
			$this->satisfaction_survey($fromDate,$toDate);
			$this->recommendation_survey($fromDate,$toDate);
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray', $yaxisArray);
		} else {
			$fromDate = date("Y")."-01-01"; // set first date of current year
			$toDate = date("Y")."-12-31"; // set last date of current year
			$this->cleanliness_survey($fromDate,$toDate);
			$this->service_survey($fromDate,$toDate);
			$this->satisfaction_survey($fromDate,$toDate);
			$this->recommendation_survey($fromDate,$toDate);
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray', $yaxisArray);
				
		}
	}

	/**
	 *
	 * monthly wise consultation reports
	 *
	 **/

	public function admin_monthly_consultations() {
		$this->set('title_for_layout', __('Monthly Consultations', true));
		$this->uses = array('Appointment');
		if ($this->request->is('post')) {
			$reportYear = $this->request->data['reportYear'];
			$fromDate = $reportYear."-01-01"; // set first date of current year
			$toDate = $reportYear."-12-31"; // set last date of current year
			$this->monthly_consultations($fromDate,$toDate);
			while($toDate > $fromDate) {
			 $yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
			 $expfromdate = explode("-", $fromDate);
			 $fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray', $yaxisArray);
		} else {
			$fromDate = date("Y")."-01-01"; // set first date of current year
			$toDate = date("Y")."-12-31"; // set last date of current year
			$this->monthly_consultations($fromDate,$toDate);
			while($toDate > $fromDate) {
			 $yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
			 $expfromdate = explode("-", $fromDate);
			 $fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray', $yaxisArray);
				
		}
		$this->set('reportYear', isset($this->request->data['reportYear'])?$this->request->data['reportYear']:date("Y"));

	}

	/**
	 *
	 * monthly consultations reports query
	 *
	 **/

	private function monthly_consultations($fromDate=NULL, $toDate=NULL) {
		$consultationCount = $this->Appointment->find('all', array('fields' => array('COUNT(*) AS consultationcount', 'DATE_FORMAT(date, "%M-%Y") AS month_reports', 'Appointment.date', 'Appointment.location_id', 'Appointment.id', 'Appointment.is_deleted'), 'group' => array("month_reports"), 'conditions' => array('Appointment.is_deleted'=> 0, 'Appointment.location_id' => $this->Session->read('locationid'), 'Appointment.date BETWEEN ? AND ?' => array($fromDate, $toDate))));

		foreach($consultationCount as $consultationCountVal) {
			$filterConsultationDateArray[] = $consultationCountVal[0]['month_reports'];
			$filterConsultationCountArray[$consultationCountVal[0]['month_reports']] = $consultationCountVal[0]['consultationcount'];
		}
		$this->set('filterConsultationDateArray', isset($filterConsultationDateArray)?$filterConsultationDateArray:"");
		$this->set('filterConsultationCountArray', isset($filterConsultationCountArray)?$filterConsultationCountArray:0);
	}

	/**
	 * monthly consultations reports chart
	 *
	 */


	public function admin_monthly_consultations_chart() {
		$this->set('title_for_layout', __('Monthly Consultation Chart', true));
		$this->uses = array('Appointment');
		if ($this->request->is('post')) {
			$reportYear = $this->request->data['reportYear'];
			$fromDate = $reportYear."-01-01"; // set first date of current year
			$toDate = $reportYear."-12-31"; // set last date of current year
			$this->monthly_consultations($fromDate,$toDate);
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
		}
		$this->set('yaxisArray', $yaxisArray);
		$this->set('reportYear', $reportYear);
	}


	/**
	 * monthly consultations xls reports
	 *
	 */

	public function admin_monthly_consultations_xls() {
		$this->uses = array('Appointment');
		if ($this->request->is('post')) {
			$reportYear = $this->request->data['reportYear'];
			$fromDate = $reportYear."-01-01"; // set first date of current year
			$toDate = $reportYear."-12-31"; // set last date of current year
			$this->monthly_consultations($fromDate,$toDate);
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray', $yaxisArray);
		} else {
			$fromDate = date("Y")."-01-01"; // set first date of current year
			$toDate = date("Y")."-12-31"; // set last date of current year
			$this->monthly_consultations($fromDate,$toDate);
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray', $yaxisArray);
				
		}
		$this->set('reportYear', isset($this->request->data['reportYear'])?$this->request->data['reportYear']:date("Y"));
		$this->layout = false;
	}

	/**
	 *
	 * department wise consultation reports
	 *
	 **/

	public function admin_consultationsby_department() {
		$this->set('title_for_layout', __('Consultations By Department', true));
		$this->uses = array('Appointment', 'Department');
		if ($this->request->is('post')) {
			$reportYear = $this->request->data['reportYear'];
			$reportMonth = $this->request->data['reportMonth'];
			$departmentType = $this->request->data['departmentType'];
			// if month is selected //
			if(!empty($reportMonth)) {
				$startDate=1;
				$countDays = cal_days_in_month(CAL_GREGORIAN, $reportMonth, $reportYear);
				while($startDate <= $countDays) {
					$dateVal = $reportYear."-".$reportMonth."-".$startDate;
					$yaxisIndex = date("d-F", strtotime($dateVal));
					$yaxisArray[$yaxisIndex] = date("d-F-Y", strtotime($dateVal));
					$startDate++;
				}
				$this->consultationby_mdepartment($yaxisArray, $reportYear, $departmentType);
				$this->set('yaxisArray', $yaxisArray);

				// if month is not selected //
			} else {
				$fromDate = $reportYear."-01-01"; // set first date of current year
				$toDate = $reportYear."-12-31"; // set last date of current year
				$this->consultationby_ydepartment($fromDate, $toDate, $departmentType);
				while($toDate > $fromDate) {
					$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
					$expfromdate = explode("-", $fromDate);
					$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
				}
				$this->set('yaxisArray', $yaxisArray);

			}
		} else {
			$fromDate = date("Y")."-01-01"; // set first date of current year
			$toDate = date("Y")."-12-31"; // set last date of current year
			$departmentType = "";
			$this->consultationby_ydepartment($fromDate,$toDate, $departmentType);
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray', $yaxisArray);
		}
		// get department list //
		$departmentList = $this->Department->find('list', array('fields' => array('Department.id', 'Department.name'), 'conditions' => array('Department.location_id' => $this->Session->read('locationid'), 'Department.is_active' => 1)));

		$this->set('departmentType', isset($departmentType)?$departmentType:"1"); // 1 for number of cases
		$this->set('reportYear', isset($this->request->data['reportYear'])?$this->request->data['reportYear']:date("Y"));
		$this->set('reportMonth', isset($this->request->data['reportMonth'])?$this->request->data['reportMonth']:"");
		$this->set('departmentList', $departmentList);

	}

	/**
	 *
	 * department wise consultations with monthly reports query
	 *
	 **/

	private function consultationby_mdepartment($yaxisArray=NULL, $reportYear=NULL, $departmentType=NULL) {
		$assignIndex = array_keys($yaxisArray);
		$fromDate = date("Y-m-d", strtotime($yaxisArray[$assignIndex[0]]."-".$reportYear));
		$toDate = date("Y-m-d", strtotime($yaxisArray[$assignIndex[count($yaxisArray)-1]]."-".$reportYear));

		$monthlyDepartConsultCount = $this->Appointment->find('all', array('fields' => array('COUNT(*) AS departconsultcount', 'DATE_FORMAT(date, "%d-%M") AS day_reports', 'Appointment.department_id', 'Appointment.is_deleted', 'Appointment.location_id', 'Appointment.id', 'Appointment.date'), 'conditions' => array('Appointment.location_id' => $this->Session->read('locationid'), 'Appointment.department_id' => $departmentType, 'Appointment.is_deleted' => 0, 'Appointment.date BETWEEN ? AND ?' => array($fromDate, $toDate)), 'group' => array('date')));
		foreach($monthlyDepartConsultCount as $monthlyDepartConsultCountVal) {
			$filterDepartConsultDateArray[] = $monthlyDepartConsultCountVal[0]['day_reports'];
			$filterDepartConsultCountArray[$monthlyDepartConsultCountVal[0]['day_reports']] = $monthlyDepartConsultCountVal[0]['departconsultcount'];
		}
		$this->set('filterDepartConsultDateArray', isset($filterDepartConsultDateArray)?$filterDepartConsultDateArray:"");
		$this->set('filterDepartConsultCountArray', isset($filterDepartConsultCountArray)?$filterDepartConsultCountArray:0);
	}

	/**
	 *
	 * department wise consultations with yearly reports query
	 *
	 **/

	private function consultationby_ydepartment($fromDate=NULL, $toDate=NULL, $departmentType=NULL) {
		$departConsultCount = $this->Appointment->find('all', array('fields' => array('COUNT(*) AS departconsultcount', 'DATE_FORMAT(date, "%M-%Y") AS month_reports', 'Appointment.date', 'Appointment.location_id', 'Appointment.id', 'Appointment.is_deleted', 'Appointment.department_id'), 'group' => array("month_reports"), 'conditions' => array('Appointment.department_id' => $departmentType, 'Appointment.is_deleted'=> 0, 'Appointment.location_id' => $this->Session->read('locationid'), 'Appointment.date BETWEEN ? AND ?' => array($fromDate, $toDate))));

		foreach($departConsultCount as $departConsultCountVal) {
			$filterDepartConsultDateArray[] = $departConsultCountVal[0]['month_reports'];
			$filterDepartConsultCountArray[$departConsultCountVal[0]['month_reports']] = $departConsultCountVal[0]['departconsultcount'];
		}
		$this->set('filterDepartConsultDateArray', isset($filterDepartConsultDateArray)?$filterDepartConsultDateArray:"");
		$this->set('filterDepartConsultCountArray', isset($filterDepartConsultCountArray)?$filterDepartConsultCountArray:0);
	}

	/**
	 * monthly consultations by department reports chart
	 *
	 */


	public function admin_consultationsby_department_chart() {
		$this->set('title_for_layout', __('Monthly Consultation Chart', true));
		$this->uses = array('Appointment');
		if ($this->request->is('post')) {
			$reportYear = $this->request->data['reportYear'];
			$departmentType = $this->request->data['departmentType'];
			$fromDate = $reportYear."-01-01"; // set first date of current year
			$toDate = $reportYear."-12-31"; // set last date of current year
			$this->consultationby_ydepartment($fromDate, $toDate, $departmentType);
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
		}
		$this->set('yaxisArray', $yaxisArray);
		$this->set('reportYear', isset($this->request->data['reportYear'])?$this->request->data['reportYear']:date("Y"));
		$this->set('departmentType', isset($departmentType)?$departmentType:1);
	}


	/**
	 * monthly consultations xls reports
	 *
	 */

	public function admin_consultationsby_department_xls() {
		$this->uses = array('Appointment');
		if ($this->request->is('post')) {
			$reportYear = $this->request->data['reportYear'];
			$reportMonth = $this->request->data['reportMonth'];
			$departmentType = $this->request->data['departmentType'];
			// if month is selected //
			if(!empty($reportMonth)) {
				$startDate=1;
				$countDays = cal_days_in_month(CAL_GREGORIAN, $reportMonth, $reportYear);
				while($startDate <= $countDays) {
					$dateVal = $reportYear."-".$reportMonth."-".$startDate;
					$yaxisIndex = date("d-F", strtotime($dateVal));
					$yaxisArray[$yaxisIndex] = date("d-F-Y", strtotime($dateVal));
					$startDate++;
				}
				$this->consultationby_mdepartment($yaxisArray, $reportYear, $departmentType);
				$this->set('yaxisArray', $yaxisArray);

				// if month is not selected //
			} else {
				$fromDate = $reportYear."-01-01"; // set first date of current year
				$toDate = $reportYear."-12-31"; // set last date of current year
				$this->consultationby_ydepartment($fromDate, $toDate, $departmentType);
				while($toDate > $fromDate) {
					$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
					$expfromdate = explode("-", $fromDate);
					$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
				}
				$this->set('yaxisArray', $yaxisArray);

			}
		}
		$this->set('yaxisArray', $yaxisArray);
		$this->set('reportYear', isset($this->request->data['reportYear'])?$this->request->data['reportYear']:date("Y"));
		$this->set('departmentType', isset($departmentType)?$departmentType:1);
		$this->set('reportMonth', isset($reportMonth)?$reportMonth:"");
		$this->layout = false;
	}

	/**
	 *
	 * patient summary reports
	 *
	 **/

	public function admin_patient_summary() {
		$this->set('title_for_layout', __('Patient Summary', true));
		$this->uses = array('Patient');
		if ($this->request->is('post')) {
			$reportYear = $this->request->data['reportYear'];
			$reportMonth = $this->request->data['reportMonth'];
			// if month is selected //
			if(!empty($reportMonth)) {
				$startDate=1;
				$countDays = cal_days_in_month(CAL_GREGORIAN, $reportMonth, $reportYear);
				while($startDate <= $countDays) {
					$dateVal = $reportYear."-".$reportMonth."-".$startDate;
					$yaxisIndex = date("d-F", strtotime($dateVal));
					$yaxisArray[$yaxisIndex] = date("d-F-Y", strtotime($dateVal));
					$startDate++;
				}
				$this->mpatientsummary($yaxisArray, $reportYear);
				$this->set('yaxisArray', $yaxisArray);

				// if month is not selected //
			} else {
				$fromDate = $reportYear."-01-01"; // set first date of current year
				$toDate = $reportYear."-12-31"; // set last date of current year
				$this->ypatientsummary($fromDate, $toDate);
				while($toDate > $fromDate) {
					$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
					$expfromdate = explode("-", $fromDate);
					$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
				}
				$this->set('yaxisArray', $yaxisArray);

			}
		} else {
			$fromDate = date("Y")."-01-01"; // set first date of current year
			$toDate = date("Y")."-12-31"; // set last date of current year
			$this->ypatientsummary($fromDate,$toDate);
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray', $yaxisArray);
		}

		$this->set('reportYear', isset($this->request->data['reportYear'])?$this->request->data['reportYear']:date("Y"));
		$this->set('reportMonth', isset($this->request->data['reportMonth'])?$this->request->data['reportMonth']:"");
	}

	/**
	 *
	 * patient summary with monthly reports query
	 *
	 **/

	private function mpatientsummary($yaxisArray=NULL, $reportYear=NULL) {
		$assignIndex = array_keys($yaxisArray);
		$fromDate = date("Y-m-d", strtotime($yaxisArray[$assignIndex[0]]."-".$reportYear));
		$toDate = date("Y-m-d", strtotime($yaxisArray[$assignIndex[count($yaxisArray)-1]]."-".$reportYear));

		// for IPD patient query //
		$monthIPDCashCount = $this->Patient->find('all', array('fields' => array('COUNT(*) AS cashcount', 'DATE_FORMAT(create_time, "%d-%M") AS day_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'Patient.payment_category', 'Patient.location_id', 'Patient.id', 'Patient.is_deleted'), 'group' => array("register_date  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('Patient.admission_type' => 'IPD', 'Patient.payment_category' => 'cash', 'Patient.is_deleted' => 0, 'Patient.location_id' => $this->Session->read('locationid')), 'recursive' => -1));
		foreach($monthIPDCashCount as $monthIPDCashCountVal) {
			$filterMonthIPDCashDateArray[] = $monthIPDCashCountVal[0]['day_reports'];
			$filterMonthIPDCashCountArray[$monthIPDCashCountVal[0]['day_reports']] = $monthIPDCashCountVal[0]['cashcount'];
		}
		$this->set('filterMonthIPDCashDateArray', isset($filterMonthIPDCashDateArray)?$filterMonthIPDCashDateArray:"");
		$this->set('filterMonthIPDCashCountArray', isset($filterMonthIPDCashCountArray)?$filterMonthIPDCashCountArray:0);

		$monthIPDCardCount = $this->Patient->find('all', array('fields' => array('COUNT(*) AS cardcount', 'DATE_FORMAT(create_time, "%d-%M") AS day_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'Patient.payment_category', 'Patient.location_id', 'Patient.id', 'Patient.is_deleted'), 'group' => array("register_date  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('Patient.admission_type' => 'IPD', 'Patient.payment_category' => 'card', 'Patient.is_deleted' => 0, 'Patient.location_id' => $this->Session->read('locationid')), 'recursive' => -1));
		foreach($monthIPDCardCount as $monthIPDCardCountVal) {
			$filterMonthIPDCardDateArray[] = $monthIPDCardCountVal[0]['day_reports'];
			$filterMonthIPDCardCountArray[$monthIPDCardCountVal[0]['day_reports']] = $monthIPDCardCountVal[0]['cardcount'];
		}
		$this->set('filterMonthIPDCardDateArray', isset($filterMonthIPDCardDateArray)?$filterMonthIPDCardDateArray:"");
		$this->set('filterMonthIPDCardCountArray', isset($filterMonthIPDCardCountArray)?$filterMonthIPDCardCountArray:0);
		 
		// for OPD patient query //
		$monthOPDCashCount = $this->Patient->find('all', array('fields' => array('COUNT(*) AS cashcount', 'DATE_FORMAT(create_time, "%d-%M") AS day_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'Patient.payment_category', 'Patient.location_id', 'Patient.id', 'Patient.is_deleted'), 'group' => array("register_date  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('Patient.admission_type' => 'OPD', 'Patient.payment_category' => 'cash', 'Patient.is_deleted' => 0, 'Patient.location_id' => $this->Session->read('locationid')), 'recursive' => -1));
		foreach($monthOPDCashCount as $monthOPDCashCountVal) {
			$filterMonthOPDCashDateArray[] = $monthOPDCashCountVal[0]['day_reports'];
			$filterMonthOPDCashCountArray[$monthOPDCashCountVal[0]['day_reports']] = $monthOPDCashCountVal[0]['cashcount'];
		}
		$this->set('filterMonthOPDCashDateArray', isset($filterMonthOPDCashDateArray)?$filterMonthOPDCashDateArray:"");
		$this->set('filterMonthOPDCashCountArray', isset($filterMonthOPDCashCountArray)?$filterMonthOPDCashCountArray:0);

		$monthOPDCardCount = $this->Patient->find('all', array('fields' => array('COUNT(*) AS cardcount', 'DATE_FORMAT(create_time, "%d-%M") AS day_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'Patient.payment_category', 'Patient.location_id', 'Patient.id', 'Patient.is_deleted'), 'group' => array("register_date  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('Patient.admission_type' => 'OPD', 'Patient.payment_category' => 'card', 'Patient.is_deleted' => 0, 'Patient.location_id' => $this->Session->read('locationid')), 'recursive' => -1));
		foreach($monthOPDCardCount as $monthOPDCardCountVal) {
			$filterMonthOPDCardDateArray[] = $monthOPDCardCountVal[0]['day_reports'];
			$filterMonthOPDCardCountArray[$monthOPDCardCountVal[0]['day_reports']] = $monthOPDCardCountVal[0]['cardcount'];
		}
		$this->set('filterMonthOPDCardDateArray', isset($filterMonthOPDCardDateArray)?$filterMonthOPDCardDateArray:"");
		$this->set('filterMonthOPDCardCountArray', isset($filterMonthOPDCardCountArray)?$filterMonthOPDCardCountArray:0);
	}

	/**
	 *
	 * patient summary with yearly reports query
	 *
	 **/

	private function ypatientsummary($fromDate=NULL, $toDate=NULL) {
		// for IPD patient query //
		$yearIPDCashCount = $this->Patient->find('all', array('fields' => array('COUNT(*) AS cashcount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'Patient.payment_category', 'Patient.location_id', 'Patient.id', 'Patient.is_deleted'), 'group' => array("month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('Patient.admission_type' => 'IPD', 'Patient.payment_category' => 'cash', 'Patient.is_deleted' => 0, 'Patient.location_id' => $this->Session->read('locationid')), 'recursive' => -1));
		foreach($yearIPDCashCount as $yearIPDCashCountVal) {
			$filterYearIPDCashDateArray[] = $yearIPDCashCountVal[0]['month_reports'];
			$filterYearIPDCashCountArray[$yearIPDCashCountVal[0]['month_reports']] = $yearIPDCashCountVal[0]['cashcount'];
		}
		$this->set('filterYearIPDCashDateArray', isset($filterYearIPDCashDateArray)?$filterYearIPDCashDateArray:"");
		$this->set('filterYearIPDCashCountArray', isset($filterYearIPDCashCountArray)?$filterYearIPDCashCountArray:0);

		$yearIPDCardCount = $this->Patient->find('all', array('fields' => array('COUNT(*) AS cardcount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'Patient.payment_category', 'Patient.location_id', 'Patient.id', 'Patient.is_deleted'), 'group' => array("month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('Patient.admission_type' => 'IPD', 'Patient.payment_category' => 'card', 'Patient.is_deleted' => 0, 'Patient.location_id' => $this->Session->read('locationid')), 'recursive' => -1));
		foreach($yearIPDCardCount as $yearIPDCardCountVal) {
			$filterYearIPDCardDateArray[] = $yearIPDCardCountVal[0]['month_reports'];
			$filterYearIPDCardCountArray[$yearIPDCardCountVal[0]['month_reports']] = $yearIPDCardCountVal[0]['cardcount'];
		}
		$this->set('filterYearIPDCardDateArray', isset($filterYearIPDCardDateArray)?$filterYearIPDCardDateArray:"");
		$this->set('filterYearIPDCardCountArray', isset($filterYearIPDCardCountArray)?$filterYearIPDCardCountArray:0);
		 
		// for OPD patient query //
		$yearOPDCashCount = $this->Patient->find('all', array('fields' => array('COUNT(*) AS cashcount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'Patient.payment_category', 'Patient.location_id', 'Patient.id', 'Patient.is_deleted'), 'group' => array("month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('Patient.admission_type' => 'OPD', 'Patient.payment_category' => 'cash', 'Patient.is_deleted' => 0, 'Patient.location_id' => $this->Session->read('locationid')), 'recursive' => -1));
		foreach($yearOPDCashCount as $yearOPDCashCountVal) {
			$filterYearOPDCashDateArray[] = $yearOPDCashCountVal[0]['month_reports'];
			$filterYearOPDCashCountArray[$yearOPDCashCountVal[0]['month_reports']] = $yearOPDCashCountVal[0]['cashcount'];
		}
		$this->set('filterYearOPDCashDateArray', isset($filterYearOPDCashDateArray)?$filterYearOPDCashDateArray:"");
		$this->set('filterYearOPDCashCountArray', isset($filterYearOPDCashCountArray)?$filterYearOPDCashCountArray:0);

		$yearOPDCardCount = $this->Patient->find('all', array('fields' => array('COUNT(*) AS cardcount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'Patient.payment_category', 'Patient.location_id', 'Patient.id', 'Patient.is_deleted'), 'group' => array("month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('Patient.admission_type' => 'OPD', 'Patient.payment_category' => 'card', 'Patient.is_deleted' => 0, 'Patient.location_id' => $this->Session->read('locationid')), 'recursive' => -1));
		foreach($yearOPDCardCount as $yearOPDCardCountVal) {
			$filterYearOPDCardDateArray[] = $yearOPDCardCountVal[0]['month_reports'];
			$filterYearOPDCardCountArray[$yearOPDCardCountVal[0]['month_reports']] = $yearOPDCardCountVal[0]['cardcount'];
		}
		$this->set('filterYearOPDCardDateArray', isset($filterYearOPDCardDateArray)?$filterYearOPDCardDateArray:"");
		$this->set('filterYearOPDCardCountArray', isset($filterYearOPDCardCountArray)?$filterYearOPDCardCountArray:0);
	}

	/**
	 * patient summary reports chart
	 *
	 */


	public function admin_patient_summary_chart() {
		$this->set('title_for_layout', __('Patient Summary Chart', true));
		$this->uses = array('Patient');
		if ($this->request->is('post')) {
			$reportYear = $this->request->data['reportYear'];
			$fromDate = $reportYear."-01-01"; // set first date of current year
			$toDate = $reportYear."-12-31"; // set last date of current year
			$this->ypatientsummary($fromDate, $toDate);
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
		}
		$this->set('yaxisArray', $yaxisArray);
		$this->set('reportYear', isset($this->request->data['reportYear'])?$this->request->data['reportYear']:date("Y"));
		 
	}


	/**
	 * patient summary xls reports
	 *
	 */

	public function admin_patient_summary_xls() {
		$this->uses = array('Patient');
		if ($this->request->is('post')) {
			$reportYear = $this->request->data['reportYear'];
			$reportMonth = $this->request->data['reportMonth'];
			// if month is selected //
			if(!empty($reportMonth)) {
				$startDate=1;
				$countDays = cal_days_in_month(CAL_GREGORIAN, $reportMonth, $reportYear);
				while($startDate <= $countDays) {
					$dateVal = $reportYear."-".$reportMonth."-".$startDate;
					$yaxisIndex = date("d-F", strtotime($dateVal));
					$yaxisArray[$yaxisIndex] = date("d-F-Y", strtotime($dateVal));
					$startDate++;
				}
				$this->mpatientsummary($yaxisArray, $reportYear);
				$this->set('yaxisArray', $yaxisArray);

				// if month is not selected //
			} else {
				$fromDate = $reportYear."-01-01"; // set first date of current year
				$toDate = $reportYear."-12-31"; // set last date of current year
				$this->ypatientsummary($fromDate, $toDate);
				while($toDate > $fromDate) {
					$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
					$expfromdate = explode("-", $fromDate);
					$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
				}
				$this->set('yaxisArray', $yaxisArray);

			}
		}
		$this->set('yaxisArray', $yaxisArray);
		$this->set('reportYear', isset($this->request->data['reportYear'])?$this->request->data['reportYear']:date("Y"));
		$this->set('reportMonth', isset($reportMonth)?$reportMonth:"");
		$this->layout = false;
	}


	/**
	@name		: admin_total_anesthesia
	@created for: To show total anesthesia taken for the months of year
	@created on : 4/26/2012
	@created By : Anand
	**/

	public function admin_total_anesthesia(){
		$this->uses = array('AnaesthesiaConsentForm','Location','Patient','Person');
    
		if(!empty($this->request->data)){
				$this->layout = false;
			$this->set('title_for_layout', __('Total Anesthesia', true));
			// Collect data in to the variable
			$reportYear = $this->request->data['TotalAnesthesia']['year'];
			$reportType = $this->request->data['TotalAnesthesia']['format'];
			$location_id = $this->Session->read('locationid');
			$consultantName = '';
			$type = 'All';
			$reportMonth = $this->request->data['TotalAnesthesia']['month'];
			// Create date if month is given
			if(!empty($reportMonth)){
				$countDays = cal_days_in_month(CAL_GREGORIAN, $reportMonth, $reportYear); // Days of the month selected
				$fromDate = $reportYear."-".$reportMonth."-01";
				$toDate = $reportYear."-".$reportMonth."-".$countDays;
			} else {
				$fromDate = $reportYear."-01-01"; // set first date of current year
				$toDate = $reportYear."-12-31"; // set last date of current year
			}
				
			// Bind Models
			$this->Patient->bindModel(array(
								'belongsTo' => array(												
													'AnaesthesiaConsentForm'=>array('foreignKey'=>false,'conditions'=>array('AnaesthesiaConsentForm.patient_uid=Patient.patient_id')),				
			)),false);

			// This will not change the actual from date
			$setDate = $fromDate;
			// Create Y axix array as per month
			while($toDate > $setDate) {
				$yaxisArray[date("F-Y", strtotime($setDate))] = date("F", strtotime($setDate));
				$expfromdate = explode("-", $setDate);
				$setDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
				
			if($fromDate != '' AND $toDate != ''){
				$toSearch = array('AnaesthesiaConsentForm.anaesthesia_time <=' => $toDate, 'AnaesthesiaConsentForm.anaesthesia_time >=' => $fromDate, 'AnaesthesiaConsentForm.location_id'=>$this->Session->read('locationid'));
			}
				
			// Collect record here
			$countRecord = $this->AnaesthesiaConsentForm->find('all', array('fields' => array('COUNT(*) AS recordcount', 'DATE_FORMAT(anaesthesia_time 	, "%M-%Y") AS month_reports'), 'conditions' => $toSearch ,'group' => array('month_reports')));
				

			// Set data for view as per record counted
			foreach($countRecord as $countRecordVal) {
				$filterRecordDateArray[] = $countRecordVal[0]['month_reports'];
				$filterRecordCountArray[$countRecordVal[0]['month_reports']] = $countRecordVal[0]['recordcount'];
			}
			// For Excel
			if($reportType == 'EXCEL'){
				$this->set('yaxisArray',$yaxisArray);
				$this->set('filterdischargeDeathDateArray', isset($filterRecordDateArray)?$filterRecordDateArray:"");
				$this->set('filterdischargeDeathCountArray', isset($filterRecordCountArray)?$filterRecordCountArray:0);
				$this->render('total_anesthesia_xls'); // Render View
				
				// For PDF
			} else if($reportType == 'PDF'){
				$this->set('yaxisArray',$yaxisArray);
				$this->set('filterdischargeDeathDateArray', isset($filterRecordDateArray)?$filterRecordDateArray:"");
				$this->set('filterdischargeDeathCountArray', isset($filterRecordCountArray)?$filterRecordCountArray:0);
				$this->render('total_anesthesia_pdf','pdf'); // Render VIew
				// For Graph
			} else if($reportType = 'GRAPH'){
				$this->set('filterRecordDateArray', isset($filterRecordDateArray)?$filterRecordDateArray:"");
				$this->set('filterRecordCountArray', isset($filterRecordCountArray)?$filterRecordCountArray:0);
				$this->set('yaxisArray', $yaxisArray);
				$this->set('reportYear',$reportYear);
				$this->set(compact('reportMonth'));
				$this->render('total_anesthesia_chart'); // render View
			}
		}

	}


	/**
	@name		: admin_initial_assessment_time
	@created for: To show time taken for inital assessment
	@created on : 4/26/2012
	@created By : Anand
	**/

	public function admin_initial_assessment_time(){
		$this->uses = array('Patient','Location','Person','Appointment');
		// Initialize variables
		$patientType = 'OPD';
		// Strats here
		if(!empty($this->request->data) AND isset($patientType) AND $patientType != ''){
			// Collect data in to the variable
			$reportYear = $this->request->data['InitialAssessmentTime']['year'];
			$reportType = $this->request->data['InitialAssessmentTime']['format'];
			$location_id = $this->Session->read('locationid');
			$reportMonth = $this->request->data['InitialAssessmentTime']['month'];
			$total = '';
			$totalHours = '';
			$i = 0;
			$newRecord[] = '';

			// Bind Models
			$this->Patient->bindModel(array(
								'belongsTo' => array(												
													'Person'=>array('foreignKey'=>false,'conditions'=>array('Person.patient_uid=Patient.patient_id'),'fields'=>array('Person.age','Person.sex')),
			'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),				
			)),false);
				
			// Create date if month is given
			if(!empty($reportMonth)){
				$countDays = cal_days_in_month(CAL_GREGORIAN, $reportMonth, $reportYear); // Days of the month selected
				$fromDate = $reportYear."-".$reportMonth."-01";
				$toDate = $reportYear."-".$reportMonth."-".$countDays;
			} else {
				$fromDate = $reportYear."-01-01"; // set first date of current year
				$toDate = $reportYear."-12-31"; // set last date of current year
			}
			// This will not change the actual from date
			$setDate = $fromDate;
			// Create Y axix array as per month
			while($toDate > $setDate) {
				$yaxisArray[date("F-Y", strtotime($setDate))] = date("F", strtotime($setDate));
				$expfromdate = explode("-", $setDate);
				$setDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
				
			if($fromDate != '' AND $toDate != ''){
				$toSearch = array('Patient.doc_ini_assess_on <=' => $toDate, 'Patient.doc_ini_assess_on >=' => $fromDate, 'Patient.location_id'=>$this->Session->read('locationid'));
			}

			// Additional condition to fetch record if the doc_ini_asses is not empty
			$condition = 'Patient.doc_ini_assess_on != ""';

			// Fetch the patient data
			$data = $this->Patient->find('all',array('fields'=>array('PatientInitial.name','Patient.patient_id','Patient.lookup_name','Patient.age','Patient.sex','Patient.doc_ini_assess_on','Person.age','Person.sex'),'conditions'=>array($toSearch,$condition,'Patient.admission_type'=>'OPD','Patient.location_id'=>$this->Session->read('locationid'))));

			// Collect the appointment time. Nad calculate the duration to start the initial assessment
			if(!empty($data)){
					
				foreach($data as $record){
					// Latest appointment ID of the patient
					$maxId = $this->Appointment->find('first',array('conditions'=>array('Appointment.patient_id'=>$record['Patient']['id'],'Appointment.location_id'=>$this->Session->read('locationid')),'fields' => array('MAX(Appointment.id) as max_id')));

					// Strt time of the latest appointment
					$getAppointmentTime = $this->Appointment->find('first',array('field'=>array('Appointment.start_time','Appointment.date'),'conditions'=>array('Appointment.id'=>$maxId[0]['max_id'])));
						
					// Get the time from date
					$splitStart = explode(' ',$record['Patient']['doc_ini_assess_on']);

					// Calculation for duration starts here
					$t1 = $splitStart[1];
					$t2 = $getAppointmentTime['Appointment']['start_time'].':00';

					// Get the difference between to time
					$diff = abs(strtotime($t1)-strtotime($t2));

					// Convert it the diff in hours
					$hours = round($diff/(60*60));
					// In min
					$mins = round($diff/60);

					// Create an array
					$total['duration'] = $mins;
					$total['apt_start_time'] = $getAppointmentTime['Appointment']['start_time'].':00';
					$total['apt_date'] = $getAppointmentTime['Appointment']['date'];
					// Create new array by merging two arraty
					$newRecord[$i] = array_merge($record['Patient'],$total,$record['PatientInitial']);

					// Incease the array kew
					$i++;
				}
			}
			//pr($newRecord);exit;

			//Report Generation starts here
			if($reportType == 'EXCEL'){
				$this->set('record',$newRecord);
				$this->render('initial_assessment_xls',false);
			} else if($reportType == 'PDF'){
				$this->set('record',$newRecord);
				$this->render('initial_assessment_pdf',false);
			}
				
		}
	}


	/**
	@name		: admin_icu_utilization_rate
	@created for: To show time taken for inital assessment
	@created on : 4/26/2012
	@created By : Anand
	**/

	public function admin_icu_utilization_rate(){
		$this->uses = array('Patient','Location','Person','Ward','WardPatient');
		if(!empty($this->request->data)){
			// Initialize variables
			$reportMonth = $this->request->data['IcuUtilizationRate']['month'];
			$reportYear = $this->request->data['IcuUtilizationRate']['year'];
			$reportType = $this->request->data['IcuUtilizationRate']['format'];
			$location_id = $this->Session->read('locationid');
			// Set Date
			// Create date if month is given
			if(!empty($reportMonth)){
				$countDays = cal_days_in_month(CAL_GREGORIAN, $reportMonth, $reportYear); // Days of the month selected
				$fromDate = $reportYear."-".$reportMonth."-01";
				$toDate = $reportYear."-".$reportMonth."-".$countDays;
			} else {
				$fromDate = $reportYear."-01-01"; // set first date of current year
				$toDate = $reportYear."-12-31"; // set last date of current year
			}
				
			// This will not change the actual from date
			$setDate = $fromDate;
			// Create Y axix array as per month
			while($toDate > $setDate) {
				$yaxisArray[date("F-Y", strtotime($setDate))] = date("F", strtotime($setDate));
				$expfromdate = explode("-", $setDate);
				$setDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
				
			if($fromDate != '' AND $toDate != ''){
				$toSearch = array('WardPatient.in_date <=' => $toDate, 'WardPatient.in_date >=' => $fromDate, 'Patient.location_id'=>$this->Session->read('locationid'));
			}

				
			// Bind Models
			$this->WardPatient->bindModel(array(
								'belongsTo' => array(												
													'Patient'=>array('foreignKey'=>false,'conditions'=>array('Patient.id=WardPatient.patient_id','Patient.admission_type'=>'IPD'),
													'fields'=>array('Patient.lookup_name','Patient.form_received_on','Patient.discharge_date','Patient.patient_id')),				
			)),false);

			// Find the Ward Id of ICU
			$icuId = $this->Ward->field('Ward.id',array('Ward.name'=>'ICU','Ward.location_id'=>$this->Session->read('locationid')));

			if($icuId == ''){
				$this->Session->setFlash(__('Sorry! There is no ICU ward in this hospital.',array('class'=>'error')));
				$this->redirect(array("controller" => "reports", "action" => "all_report",'admin'=>true));
			}

			// NumerOF patient in for ICU For month Wise
			$icuUtilize = $this->WardPatient->find('all',array('fields' => array('COUNT(*) AS recordcount', 'DATE_FORMAT(in_date, "%M-%Y") AS month_reports','WardPatient.in_date','WardPatient.out_date','Patient.form_received_on','Patient.discharge_date'),'conditions'=>array($toSearch,'WardPatient.ward_id'=>$icuId,'WardPatient.location_id'=>$this->Session->read('locationid')),'group' => array('month_reports')));

			// 	For yearly
			$icuCount = $this->WardPatient->find('all',array('conditions'=>array($toSearch,'WardPatient.ward_id'=>$icuId,'WardPatient.location_id'=>$this->Session->read('locationid'))));

			// Calculate Total Utilization Rate
			$totalTimeIcu = '';
			$totalTimeIpd = '';
			$monthlyTimeIcu = '';
			$monthlyTimeIpd = '';
			foreach($icuCount as $data){

				// If Patient is still in ICU
				if(empty($data['WardPatient']['out_date'])){
					$data['WardPatient']['out_date'] = date('Y-m-d h:i:s');
				}
					
				$t1 = $data['WardPatient']['in_date'];
				$t2 = $data['WardPatient']['out_date'];
					
				$totalTimeIcu += abs(strtotime($t1)-strtotime($t2));
				//Total ICU Hours
				$totalHoursIcu = round($totalTimeIcu/(60*60),2);
					
				//Calculate total IPD Hrs
				$regTime = explode(' ',$data['Patient']['form_received_on']);

				if(empty($data['Patient']['discharge_date'])){
					$data['Patient']['discharge_date'] = date('Y-m-d h:i:s');
				}
				$disDate = explode(' ',$data['Patient']['discharge_date']);
				$totalTimeIpd += abs(strtotime($data['Patient']['discharge_date'])-strtotime($data['Patient']['form_received_on']));
					
				//Total ICU Hours
				$totalHoursIpd = round($totalTimeIpd/(60*60),2);
			}

			// Total Icu Utilization
			$icuUtilizationRate = round(($totalHoursIcu / $totalHoursIpd)*100,2).'%';
				

			//Calculate month wise utilization rate
			// Set data for view as per record counted
			foreach($icuUtilize as $countRecordVal) {

				// If Patient is still in ICU
				if(empty($countRecordVal['WardPatient']['out_date'])){
					$countRecordVal['WardPatient']['out_date'] = date('Y-m-d h:i:s');
				}
				$t1 = $countRecordVal['WardPatient']['in_date'];
				$t2 = $countRecordVal['WardPatient']['out_date'];
					
				$monthlyTimeIcu = abs(strtotime($t1)-strtotime($t2));
				//Total ICU Hours
				$monthlyHoursIcu = round($monthlyTimeIcu/(60*60),2);
					
				//Calculate total IPD Hrs
				$regTime = explode(' ',$data['Patient']['form_received_on']);

				if(empty($countRecordVal['Patient']['discharge_date'])){
					$countRecordVal['Patient']['discharge_date'] = date('Y-m-d h:i:s');
				}
					
				$monthlyTimeIpd = abs(strtotime($countRecordVal['Patient']['discharge_date'])-strtotime($countRecordVal['Patient']['form_received_on']));
					
				//Total ICU Hours Month Wise
				$monthlyHoursIpd = round($monthlyTimeIpd/(60*60),2);
				$monthlyIcuUtilizationRate = round(($monthlyHoursIcu / $monthlyHoursIpd)*100);

				$filterRecordDateArray[] = $countRecordVal[0]['month_reports'];
				$filterRecordCountArray[$countRecordVal[0]['month_reports']] = $monthlyIcuUtilizationRate;
					
			}

			// Generate report here
			// PDF
			if($reportType == 'PDF'){
				$this->set(array('reports'=>$icuCount,'icuUtilizationRate'=>$icuUtilizationRate,'reportYear'=>$reportYear,'yaxisArray'=>$yaxisArray,'totalHoursIpd'=>$totalHoursIpd,'totalHoursIcu'=>$totalHoursIcu));
				$this->set('filterdischargeDeathDateArray', isset($filterRecordDateArray)?$filterRecordDateArray:"");
				$this->set('filterdischargeDeathCountArray', isset($filterRecordCountArray)?$filterRecordCountArray:0);
				$this->render('icu_utilization_pdf','pdf');

				//EXCEL
			} else if($reportType == 'EXCEL'){
				$this->set(array('reports'=>$icuCount,'icuUtilizationRate'=>$icuUtilizationRate,'reportYear'=>$reportYear,'yaxisArray'=>$yaxisArray,'totalHoursIpd'=>$totalHoursIpd,'totalHoursIcu'=>$totalHoursIcu));
				$this->set('filterdischargeDeathDateArray', isset($filterRecordDateArray)?$filterRecordDateArray:"");
				$this->set('filterdischargeDeathCountArray', isset($filterRecordCountArray)?$filterRecordCountArray:0);
				$this->render('icu_utilization_xls',false);
			} else if($reportType = 'GRAPH'){
				$this->set('filterRecordDateArray', isset($filterRecordDateArray)?$filterRecordDateArray:"");
				$this->set('filterRecordCountArray', isset($filterRecordCountArray)?$filterRecordCountArray:0);
				$this->set('yaxisArray', $yaxisArray);
				$this->set('reportYear',$reportYear);
				$this->set(compact('reportMonth'));
				$this->render('icu_utilization_chart'); // render View
			}
		}
	}

	/**
	@name		: admin_time_taken_initial_assessment
	@created for: To show time taken for inital assessment
	@created on : 5/3/2012
	@created By : Anand
	**/

	public function admin_time_taken_initial_assessment(){
		$this->uses = array('Patient','Location','Person');
		if(!empty($this->request->data)){
			// Collect data in to the variable
			$reportYear = $this->request->data['InitialAssessmentTime']['year'];
			$reportType = $this->request->data['InitialAssessmentTime']['format'];
			$location_id = $this->Session->read('locationid');
			$reportMonth = $this->request->data['InitialAssessmentTime']['month'];
			$patientType = $this->request->data['InitialAssessmentTime']['patient_type'];
			$totalMonthlyAssessHours = '';
			$totalMonthlyAssess = '';
			$totalAssessHours = '';
			$totalAssess = '';
			$totalPatient = '';
			$totalMonthPatient = '';
			$avgTimeTaken = '';
			$avgTimeTakenMonthly = '';

			// Bind Models
			$this->Person->bindModel(array(
								'belongsTo' => array(												
													'Patient'=>array('foreignKey'=>false,'conditions'=>array('Patient.patient_id = Person.patient_uid'),'fields'=>array('Person.age','Person.sex')),
			'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),				
			)),false);

				
			// Create date if month is given
			if(!empty($reportMonth)){
				$countDays = cal_days_in_month(CAL_GREGORIAN, $reportMonth, $reportYear); // Days of the month selected
				$fromDate = $reportYear."-".$reportMonth."-01";
				$toDate = $reportYear."-".$reportMonth."-".$countDays;
			} else {
				$fromDate = $reportYear."-01-01"; // set first date of current year
				$toDate = $reportYear."-12-31"; // set last date of current year
			}
			// This will not change the actual from date
			$setDate = $fromDate;
			// Create Y axix array as per month
			while($toDate > $setDate) {
				$yaxisArray[date("F-Y", strtotime($setDate))] = date("F", strtotime($setDate));
				$expfromdate = explode("-", $setDate);
				$setDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}

			//Set Condition
			$condition = array('Patient.doc_ini_assess_on != ""','Patient.doc_ini_assess_end_on != ""');

			if($fromDate != '' AND $toDate != ''){
				$toSearch = array('Patient.doc_ini_assess_on <=' => $toDate, 'Patient.doc_ini_assess_on >=' => $fromDate, 'Patient.location_id'=>$this->Session->read('locationid'));
			}

			// Collect the data for initial assessment for IPD patient
		 if($patientType != 'EMERGENCY'){
		 	$patientCount = $this->Patient->find('all',array('fields' => array('COUNT(*) AS recordcount', 'DATE_FORMAT(doc_ini_assess_on, "%M-%Y") AS month_reports','Patient.doc_ini_assess_on','Patient.doc_ini_assess_end_on'),'conditions'=>array($condition,$toSearch,'Patient.admission_type'=>$patientType,'Patient.location_id'=>$this->Session->read('locationid')),'group' => array('month_reports')));
		 } else{
		 	$patientCount = $this->Patient->find('all',array('fields' => array('COUNT(*) AS recordcount', 'DATE_FORMAT(doc_ini_assess_on, "%M-%Y") AS month_reports','Patient.doc_ini_assess_on','Patient.doc_ini_assess_end_on'),'conditions'=>array($condition,$toSearch,'Patient.is_emergency'=>1,'Patient.location_id'=>$this->Session->read('locationid')),'group' => array('month_reports')));
		 }

		 if(!empty($patientCount)){
		 	// Set data for view as per record counted
		 	foreach($patientCount as $countRecordVal) {
		 		// For total Year
		 		// count patient for total year
		 		$totalPatient += $countRecordVal[0]['recordcount'];
		 		//Collect Total Monthly Assess
		 		$totalAssess += abs(strtotime($countRecordVal['Patient']['doc_ini_assess_on'])-strtotime($countRecordVal['Patient']['doc_ini_assess_end_on']));
		 		$totalAssessHours = round($totalAssess/(60*60),2);

		 		// For Monthly basis
		 		//Count patient for each month
		 		$totalMonthPatient = $countRecordVal[0]['recordcount'];
		 		//Collect monthly assess
		 		$totalMonthlyAssess = abs(strtotime($countRecordVal['Patient']['doc_ini_assess_on'])-strtotime($countRecordVal['Patient']['doc_ini_assess_end_on']));
		 		$totalMonthlyAssessHours = round($totalMonthlyAssess/(60*60),2);
		 		//Total average time taken monthly
		 		$avgTimeTakenMonthly = round(($totalMonthlyAssessHours/$totalMonthPatient),2);

		 		$filterRecordDateArray[] = $countRecordVal[0]['month_reports'];
		 		$filterRecordCountArray[$countRecordVal[0]['month_reports']] = $avgTimeTakenMonthly;
		 	}
		 		
		 	// Average time taken for each Patient
		 	$avgTimeTaken = round(($totalAssessHours/$totalPatient),2);
		 }
		 // Generate report here
			// PDF
			if($reportType == 'PDF'){
				$this->set(array('reportYear'=>$reportYear,'yaxisArray'=>$yaxisArray,'avgTimeTaken'=>$avgTimeTaken,'avgTimeTakenMonthly'=>$avgTimeTakenMonthly,'patientType'=>$patientType));
				$this->set('filterdischargeDeathDateArray', isset($filterRecordDateArray)?$filterRecordDateArray:"");
				$this->set('filterdischargeDeathCountArray', isset($filterRecordCountArray)?$filterRecordCountArray:0);
				$this->render('time_taken_initial_assessment_pdf','pdf');

				//EXCEL
			} else if($reportType == 'EXCEL'){
				$this->set(array('reportYear'=>$reportYear,'yaxisArray'=>$yaxisArray,'avgTimeTaken'=>$avgTimeTaken,'avgTimeTakenMonthly'=>$avgTimeTakenMonthly,'patientType'=>$patientType));
				$this->set('filterdischargeDeathDateArray', isset($filterRecordDateArray)?$filterRecordDateArray:"");
				$this->set('filterdischargeDeathCountArray', isset($filterRecordCountArray)?$filterRecordCountArray:0);
				$this->render('time_taken_initial_assessment_xls',false);

				//GRAPH
			} else if($reportType = 'GRAPH'){
				$this->set('filterRecordDateArray', isset($filterRecordDateArray)?$filterRecordDateArray:"");
				$this->set('filterRecordCountArray', isset($filterRecordCountArray)?$filterRecordCountArray:0);
				$this->set('yaxisArray', $yaxisArray);
				$this->set('reportYear',$reportYear);
				$this->set(compact('reportMonth'));
				$this->set('patientType',$patientType);
				$this->render('time_taken_initial_assessment_chart'); // render View
			}
				
		}
	}

	/**
	@name		: admin_time_taken_initial_assessment
	@created for: To show time taken for inital assessment
	@created on : 5/3/2012
	@created By : Anand
	**/

	public function admin_perticular_incident_report(){

		$this->uses = array('Patient','Location','Person','Incident');

		if(!empty($this->request->data)){
			$reportYear = $this->request->data['IncidentReport']['year'];
			$reportType = $this->request->data['IncidentReport']['format'];
			$location_id = $this->Session->read('locationid');
			$reportMonth = $this->request->data['IncidentReport']['month'];
			$incidentType = $this->request->data['IncidentReport']['incident'];

			// Bind Models
			$this->Incident->bindModel(array(
								'belongsTo' => array(												
													'Patient'=>array('foreignKey'=>false,'conditions'=>array('Incident.patient_id = Patient.id'),'fields'=>array('Patient.lookup_name')),
			
													'Person'=>array('foreignKey'=>false,'conditions'=>array('Patient.patient_id = Person.patient_uid'),'fields'=>array('Person.age','Person.sex')),
			'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
			)),false);

			// Create date if month is given
			if(!empty($reportMonth)){
				$countDays = cal_days_in_month(CAL_GREGORIAN, $reportMonth, $reportYear); // Days of the month selected
				$fromDate = $reportYear."-".$reportMonth."-01";
				$toDate = $reportYear."-".$reportMonth."-".$countDays;
			} else {
				$fromDate = $reportYear."-01-01"; // set first date of current year
				$toDate = $reportYear."-12-31"; // set last date of current year
			}

			//IF the incident is medication error Set Condition
			if($incidentType == 'medication error'){
				$condition = array('Incident.medication_error != ""');
			} else {
				$condition = array('Incident.analysis_option'=>$incidentType);
			}

			$field = array('Incident.medication_error','Incident.analysis_option','Incident.incident_date','Incident.incident_time','Person.age','Person.sex','PatientInitial.name','Patient.lookup_name','Patient.patient_id');

			if($fromDate != '' AND $toDate != ''){
				$toSearch = array('Incident.incident_date <=' => $toDate, 'Incident.incident_date >=' => $fromDate, 'Incident.location_id'=>$this->Session->read('locationid'));
			}
				
			$getRecord = $this->Incident->find('all',array('conditions'=>array($condition,$toSearch),'fields'=>$field));

			// Generate report here
			// PDF
			if($reportType == 'PDF'){
				$this->set(array('record'=>$getRecord,'incidentType'=>$incidentType));
				$this->render('perticular_incident_report_pdf','pdf');

				//EXCEL
			} else if($reportType == 'EXCEL'){
				$this->set(array('record'=>$getRecord,'incidentType'=>$incidentType));
				$this->render('perticular_incident_report_xls',false);

				//GRAPH
				/*} else if($reportType = 'GRAPH'){
				 $this->set('filterRecordDateArray', isset($filterRecordDateArray)?$filterRecordDateArray:"");
				 $this->set('filterRecordCountArray', isset($filterRecordCountArray)?$filterRecordCountArray:0);
				 $this->set('yaxisArray', $yaxisArray);
				 $this->set('reportYear',$reportYear);
				 $this->set(compact('reportMonth'));
				 $this->set('patientType',$patientType);
				 $this->render('time_taken_initial_assessment_chart'); // render View*/
			}
			//pr($getRecord);exit;
		}

	}

	/**
	@name		: admin_time_taken_for_discharge
	@created for: To show time taken for inital assessment
	@created on : 5/8/2012
	@created By : Anand
	**/

	public function admin_time_taken_for_discharge(){
			
		$this->uses = array('DischargeSummary','Patient','Person','Ward', 'FinalBilling');

		if(!empty($this->request->data)){
			// Collect data in to the variable
			$reportYear = $this->request->data['DischargeSummary']['year'];
			$reportType = $this->request->data['DischargeSummary']['format'];
			$location_id = $this->Session->read('locationid');
			$reportMonth = $this->request->data['DischargeSummary']['month'];
			$totalPatient = '';
			$totalDischarge = '';
			$totalDischargeTime = '';
			$avgTimeTaken = '';
			$totalAvg = '';


			// Bind Models
			$this->DischargeSummary->bindModel(array(
								'belongsTo' => array(												
													'Patient'=>array('foreignKey'=>false,'conditions'=>array('DischargeSummary.patient_id = Patient.id'),'fields'=>array('Patient.lookup_name','Patient.patient_id')),
                                                                                                        'FinalBilling'=>array('foreignKey'=>false,'conditions'=>array('DischargeSummary.patient_id = FinalBilling.patient_id'),'fields'=>array('FinalBilling.discharge_date')),
													'Person'=>array('foreignKey'=>false,'conditions'=>array('Patient.patient_id = Person.patient_uid'),'fields'=>array('Person.age','Person.sex')),
			'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
			)),false);

			// Create date if month is given
			if(!empty($reportMonth)){
				$countDays = cal_days_in_month(CAL_GREGORIAN, $reportMonth, $reportYear); // Days of the month selected
				$fromDate = $reportYear."-".$reportMonth."-01";
				$toDate = $reportYear."-".$reportMonth."-".$countDays;
			} else {
				$fromDate = $reportYear."-01-01"; // set first date of current year
				$toDate = $reportYear."-12-31"; // set last date of current year
			}
				
			if($fromDate != '' AND $toDate != ''){
				$toSearch = array('DischargeSummary.review_on <=' => $toDate, 'DischargeSummary.review_on >=' => $fromDate);
			}

			// Collect the data for initial assessment for IPD patient
			$patientCount = $this->DischargeSummary->find('all',array('conditions'=>array($toSearch,'FinalBilling.location_id'=>$this->Session->read('locationid'),'FinalBilling.discharge_date <>'=>null)));

			$totalPatient = count($patientCount);

			// Calculate total time taken to discharge
			foreach($patientCount as $patient){
				$totalDischarge = abs(strtotime($patient['FinalBilling']['discharge_date'])-strtotime($patient['DischargeSummary']['review_on']));
				$totalDischargeTime += round($totalDischarge/60,2);
			}
				
			// Average time taken to each patient Formula: totalHours/totalPatient * 100%
			if($totalPatient != 0){
				$totalAvg = ($totalDischargeTime/$totalPatient)* 100;
				$avgTimeTaken = round($totalAvg / 60, 2);
			}
			//pr($avgTimeTaken);exit;
			if($reportType == 'PDF'){
				$this->set(array('record'=>$patientCount,'avgTimeTaken'=>$avgTimeTaken,'totalDischargeTime'=>$totalDischargeTime));
				$this->render('time_taken_for_discharge_pdf','pdf');

				//EXCEL
			} else if($reportType == 'EXCEL'){
				$this->set(array('record'=>$patientCount,'avgTimeTaken'=>$avgTimeTaken,'totalDischargeTime'=>$totalDischargeTime));
				$this->render('time_taken_for_discharge_xls','');
			}
				
		}

	}

	/**
	 *
	 * reports regarding to patient readmitted to ICU withing 48 hrs
	 *
	 **/

	public function admin_patient_readmitted_to_icu() {

		$this->set('title_for_layout', __('Patient Readmitted To ICU', true));
		$this->uses = array('WardPatient');
		if($this->request->is('post')) {
			$reportYear = $this->request->data['reportYear'];
			$reportMonth = $this->request->data['reportMonth'];
			// if month is selected //
			if(!empty($reportMonth)) {
				$startDate=1;
				$countDays = cal_days_in_month(CAL_GREGORIAN, $reportMonth, $reportYear);
				while($startDate <= $countDays) {
					$dateVal = $reportYear."-".$reportMonth."-".$startDate;
					$yaxisIndex = date("d-F", strtotime($dateVal));
					$yaxisArray[$yaxisIndex] = date("d-F-Y", strtotime($dateVal));
					$startDate++;
				}
				$this->monthly_readmitted_to_icu($yaxisArray, $reportYear);
				$this->set('yaxisArray', $yaxisArray);

				// if month is not selected //
			} else {
				$fromDate = $reportYear."-01-01"; // set first date of current year
				$toDate = $reportYear."-12-31"; // set last date of current year
				$this->yearly_readmitted_to_icu($fromDate, $toDate);
				while($toDate > $fromDate) {
					$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
					$expfromdate = explode("-", $fromDate);
					$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
				}
				$this->set('yaxisArray', $yaxisArray);

			}
		} else {
			$fromDate = date("Y")."-01-01"; // set first date of current year
			$toDate = date("Y")."-12-31"; // set last date of current year
			$this->yearly_readmitted_to_icu($fromDate, $toDate);
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray', $yaxisArray);
		}

		$this->set('reportYear', isset($this->request->data['reportYear'])?$this->request->data['reportYear']:date("Y"));
		$this->set('reportMonth', isset($this->request->data['reportMonth'])?$this->request->data['reportMonth']:"");
	}

	/**
	 *
	 * report regarding to  patient readmitted to icu within 48 hrs (for monthly)
	 *
	 **/

	private function monthly_readmitted_to_icu($yaxisArray=NULL, $reportYear=NULL) {
		$assignIndex = array_keys($yaxisArray);
		$fromDate = date("Y-m-d", strtotime($yaxisArray[$assignIndex[0]]."-".$reportYear));
		$toDate = date("Y-m-d", strtotime($yaxisArray[$assignIndex[count($yaxisArray)-1]]."-".$reportYear));
		$this->WardPatient->bindModel(array('belongsTo'=>array('Ward'=>array('foreignKey'=> 'ward_id'))));
		$monthlyPatientReadmittedToIcuCount = $this->WardPatient->find('all', array('fields' => array('COUNT(*) AS patientcount', 'DATE_FORMAT(WardPatient.create_time, "%d-%M") AS day_reports', 'DATE_FORMAT(WardPatient.create_time, "%Y-%m-%d") AS created_time', 'WardPatient.patient_id', 'WardPatient.is_discharge', 'WardPatient.location_id', 'WardPatient.id'), 'conditions' => array('WardPatient.readmitted' => 1, 'WardPatient.readmitted_timediff <=' => 48, 'WardPatient.location_id' => $this->Session->read('locationid'), 'Ward.name' => 'ICU', 'WardPatient.is_discharge' => 0), 'group' => array("day_reports  HAVING  created_time BETWEEN '{$fromDate}' AND '{$toDate}'")));
		foreach($monthlyPatientReadmittedToIcuCount as $monthlyPatientReadmittedToIcuCountVal) {
			$filterPatientReadmittedDateArray[] = $monthlyPatientReadmittedToIcuCountVal[0]['day_reports'];
			$filterPatientReadmittedCountArray[$monthlyPatientReadmittedToIcuCountVal[0]['day_reports']] = $monthlyPatientReadmittedToIcuCountVal[0]['patientcount'];
		}
		$this->set('filterPatientReadmittedDateArray', isset($filterPatientReadmittedDateArray)?$filterPatientReadmittedDateArray:"");
		$this->set('filterPatientReadmittedCountArray', isset($filterPatientReadmittedCountArray)?$filterPatientReadmittedCountArray:0);
	}

	/**
	 *
	 * report regarding to  patient readmitted to icu within 48 hrs (for yearly)
	 *
	 **/

	private function yearly_readmitted_to_icu($fromDate=NULL, $toDate=NULL) {
		$this->WardPatient->bindModel(array('belongsTo'=>array('Ward'=>array('foreignKey'=>'ward_id'))));
		$yearlyPatientReadmittedToIcuCount = $this->WardPatient->find('all', array('fields' => array('COUNT(*) AS patientcount', 'DATE_FORMAT(WardPatient.create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(WardPatient.create_time, "%Y-%m-%d") AS created_time', 'WardPatient.patient_id', 'WardPatient.is_discharge', 'WardPatient.location_id', 'WardPatient.id'), 'conditions' => array('WardPatient.readmitted' => 1, 'WardPatient.readmitted_timediff <=' => 48, 'WardPatient.location_id' => $this->Session->read('locationid'), 'Ward.name' => 'ICU', 'WardPatient.is_discharge' => 0), 'group' => array("month_reports  HAVING  created_time BETWEEN '{$fromDate}' AND '{$toDate}'")));

		foreach($yearlyPatientReadmittedToIcuCount as $yearlyPatientReadmittedToIcuCountVal) {
			$filterPatientReadmittedDateArray[] = $yearlyPatientReadmittedToIcuCountVal[0]['month_reports'];
			$filterPatientReadmittedCountArray[$yearlyPatientReadmittedToIcuCountVal[0]['month_reports']] = $yearlyPatientReadmittedToIcuCountVal[0]['patientcount'];
		}
		$this->set('filterPatientReadmittedDateArray', isset($filterPatientReadmittedDateArray)?$filterPatientReadmittedDateArray:"");
		$this->set('filterPatientReadmittedCountArray', isset($filterPatientReadmittedCountArray)?$filterPatientReadmittedCountArray:0);
	}

	/**
	 * chart report regarding to patient readmitted to ICU withing 48 hrs
	 *
	 */


	public function admin_patient_readmitted_to_icu_chart() {
		$this->set('title_for_layout', __('Patient Readmitted To ICU Chart', true));
		$this->uses = array('WardPatient');
		if ($this->request->is('post')) {
			$reportYear = $this->request->data['reportYear'];
			$fromDate = $reportYear."-01-01"; // set first date of current year
			$toDate = $reportYear."-12-31"; // set last date of current year
			$this->yearly_readmitted_to_icu($fromDate, $toDate);
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
		}
		$this->set('yaxisArray', $yaxisArray);
		$this->set('reportYear', isset($this->request->data['reportYear'])?$this->request->data['reportYear']:date("Y"));
	}


	/**
	 * xls report regarding to patient readmitted to ICU withing 48 hrs
	 *
	 */

	public function admin_patient_readmitted_to_icu_xls() {
		$this->uses = array('WardPatient');
		if ($this->request->is('post')) {
			$reportYear = $this->request->data['reportYear'];
			$reportMonth = $this->request->data['reportMonth'];
			// if month is selected //
			if(!empty($reportMonth)) {
				$startDate=1;
				$countDays = cal_days_in_month(CAL_GREGORIAN, $reportMonth, $reportYear);
				while($startDate <= $countDays) {
					$dateVal = $reportYear."-".$reportMonth."-".$startDate;
					$yaxisIndex = date("d-F", strtotime($dateVal));
					$yaxisArray[$yaxisIndex] = date("d-F-Y", strtotime($dateVal));
					$startDate++;
				}
				$this->monthly_readmitted_to_icu($yaxisArray, $reportYear);
				$this->set('yaxisArray', $yaxisArray);

				// if month is not selected //
			} else {
				$fromDate = $reportYear."-01-01"; // set first date of current year
				$toDate = $reportYear."-12-31"; // set last date of current year
				$this->yearly_readmitted_to_icu($fromDate, $toDate);
				while($toDate > $fromDate) {
					$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
					$expfromdate = explode("-", $fromDate);
					$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
				}
				$this->set('yaxisArray', $yaxisArray);
			}
		}
		$this->set('yaxisArray', $yaxisArray);
		$this->set('reportYear', isset($this->request->data['reportYear'])?$this->request->data['reportYear']:date("Y"));
		$this->set('reportMonth', isset($reportMonth)?$reportMonth:"");
		$this->layout = false;
	}

	//BOF pankaj
	function admin_tor($is_chart=null){
		$this->uses = array('FinalBilling','Bed','Patient');
		if(!empty($this->request->data)){
			//BOF logic
			$reportType = $this->request->data['Report']['format'];
			$this->Bed->bindModel(array(
	 				'belongsTo' => array('Room'=>array('foreignKey'=>'room_id','type'=>'inner'))),false);

			$bedData = $this->Bed->Find('count',array('conditions'=>array('Room.location_id'=>$this->Session->read('locationid'))));
				
			$dischargeData = $this->FinalBilling->find('all',array('fields'=>array('monthname(discharge_date) as month,year(discharge_date) as year ,count(*) as count'),
						'conditions'=>array("reason_of_discharge != ''",'year(discharge_date)'=>$this->request->data['Report']['year'],'FinalBilling.location_id'=>$this->Session->read('locationid')),'group'=>array('MONTH( discharge_date ) , YEAR( discharge_date )')));
				
				
			$fullMonth =array('January','February','March','April','May','June','July','August','September','October','November','December');
			for($i=0;$i<12;$i++){
				foreach($dischargeData as $monKey=>$mon){
					if($mon[0]['month']==$fullMonth[$i]){
						$mainArr[$fullMonth[$i]]= array('tor'=>round($mon[0]['count']/$bedData,2),'dischargeCount'=>$mon[0]['count']);
					}elseif(!isset($mainArr[$fullMonth[$i]])){
						$mainArr[$fullMonth[$i]]= array('tor'=>0,'dischargeCount'=>0);
					}
				}
			}

			$this->set(array('bedCount'=>$bedData,'dischargeData'=>$dischargeData,'data'=>$mainArr));
			//EOF logic

			if($is_chart=='chart'){
				$this->render('tor_chart');
			}else{
				if($reportType == 'PDF'){
						
					$this->render('tor_pdf','pdf');
					//EXCEL
				} else if($reportType == 'EXCEL'){

					$this->render('tor_excel',false);
				}
			}
		}
		//retrive the last yr in db to maintin year dropdown
		$this->Patient->recursive = -1 ;
		$last = $this->Patient->find('first',array('fields'=>array('create_time'),'order'=>'create_time desc'));
		$this->set('endyear',date('Y',strtotime($last['Patient']['create_time']))) ;
	}

	// x_ray_utilization_report
	public function admin_x_ray_utilization_report(){
		if ($this->request->is('post')) {
			$this->uses = array('RadiologyTestOrder');
			$fromMonth = $this->request->data('fromMonth');
			$toMonth = $this->request->data('toMonth');
			pr(date("t", mktime (0,0,0,2,1,2012)));exit;


		}
	}

	//function to generate reprots of total no of comaplaints,resolved complaints and time taken for complaints resolutaion
	public function admin_complaints($is_chart=null){
		$this->uses = array('Complaint','Patient');
		if(!empty($this->request->data)){
			//BOF logic
			$reportType = $this->request->data['Report']['format'];
				
			$complaintData = $this->Complaint->find('all',array('fields'=>array('monthname(date) as month  ,count(*) as count'),
						'conditions'=>array('Complaint.location_id'=>$this->Session->read('locationid'),'year(date)'=>$this->request->data['Report']['year']),
						'group'=>array('MONTH(date)')));
			$complaintResolvedData = $this->Complaint->find('all',array('fields'=>array('monthname(date) as month  ,count(*) as count'),
						'conditions'=>array('Complaint.location_id'=>$this->Session->read('locationid'),'Complaint.resolved'=>1,'year(date)'=>$this->request->data['Report']['year']),
						'group'=>array('MONTH(date)')));
			$timeTakenData = $this->Complaint->find('all',array('fields'=>array('monthname(date) as month  ,resolution_time_taken'),
						'conditions'=>array('Complaint.location_id'=>$this->Session->read('locationid'),'Complaint.resolved'=>1,'resolution_time_taken != "" ','year(date)'=>$this->request->data['Report']['year'])));
			$convertedData=array();
			foreach($timeTakenData as $timeData){
				$stringToTime= $timeData['Complaint']['resolution_time_taken'];
				$convertedData[$timeData[0]['month']][] = $stringToTime;
			}
			$this->set(array('complaintResolvedData'=>$complaintResolvedData,'timeTaken'=>$convertedData,'complaintData'=>$complaintData,'year'=>$this->request->data['Report']['year']));
			//EOF logic

			if($is_chart=='chart'){
				$type = 'chart';
			}else{
				if($reportType == 'PDF'){
					$type = 'pdf';
					$this->layout= 'pdf';
					//EXCEL
				} else if($reportType == 'EXCEL'){
					$type = 'excel';
					$this->layout =false ;
					$this->render('complaint_combine',false);
				}
			}
			$this->set('type',$type);
			$this->render('complaint_combine');
		}
		//retrive the last yr in db to maintin year dropdown
		$this->Patient->recursive = -1 ;
		$last = $this->Patient->find('first',array('fields'=>array('create_time'),'order'=>'create_time desc'));
		$this->set('endyear',date('Y',strtotime($last['Patient']['create_time']))) ;
	}
	//EOF pankaj


	/**
	 * ssi rate reports
	 *
	 */

	public function admin_ssirate() {
		$this->set('title_for_layout', __('SSI Rate', true));
		if ($this->request->is('post')) {
			$reportYear = $this->request->data['reportYear'];
			$fromDate = $reportYear."-01-01"; // set first date of current year
			$toDate = $reportYear."-12-31"; // set last date of current year
			$this->ssiratereports($fromDate,$toDate);
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray', $yaxisArray);
		} else {
			$fromDate = date("Y")."-01-01"; // set first date of current year
			$toDate = date("Y")."-12-31"; // set last date of current year
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray', $yaxisArray);
			$this->ssiratereports();

		}
		$this->set('reportYear', isset($this->request->data['reportYear'])?$this->request->data['reportYear']:date("Y"));
	}


	/**
	 * ssi rate reports query
	 *
	 */

	private function ssiratereports($fromDate=null,$toDate=null) {
		$this->uses = array('NosocomialInfection', 'OptAppointment');
		if(empty($fromDate) && empty($toDate)) {
			$fromDate = date("Y")."-01-01"; // set first date of current year
			$toDate = date("Y")."-12-31";
		}
		// number of surgical site infections count //
		$ssiCount = $this->NosocomialInfection->find('all', array('fields' => array('COUNT(*) AS ssicount', 'DATE_FORMAT(submit_date, "%M-%Y") AS month_reports', 'NosocomialInfection.surgical_site_infection', 'submit_date', 'NosocomialInfection.location_id', 'NosocomialInfection.id'), 'conditions' => array('NosocomialInfection.location_id' => $this->Session->read('locationid'), 'NosocomialInfection.surgical_site_infection' => 'Yes','NosocomialInfection.submit_date BETWEEN ? AND ?' => array($fromDate, $toDate)), 'group' => array('surgical_site_infection', 'month_reports')));
		foreach($ssiCount as $ssiCountVal) {
			$filterSsiDateArray[] = $ssiCountVal[0]['month_reports'];
			$filterSsiCountArray[$ssiCountVal[0]['month_reports']] = $ssiCountVal[0]['ssicount'];
		}
		$this->set('filterSsiDateArray', isset($filterSsiDateArray)?$filterSsiDateArray:"");
		$this->set('filterSsiCountArray', isset($filterSsiCountArray)?$filterSsiCountArray:0);

		// number surgical surgery performed //
		$surgicalPerformCount = $this->OptAppointment->find('all', array('fields' => array('COUNT(*) AS spcount', 'DATE_FORMAT(schedule_date, "%M-%Y") AS month_reports', 'OptAppointment.procedure_complete', 'OptAppointment.is_deleted', 'OptAppointment.schedule_date', 'OptAppointment.location_id', 'OptAppointment.id'), 'conditions' => array('OptAppointment.location_id' => $this->Session->read('locationid'), 'OptAppointment.procedure_complete' => 1, 'OptAppointment.is_deleted' => 0,'OptAppointment.schedule_date BETWEEN ? AND ?' => array($fromDate, $toDate)), 'group' => array('month_reports'), 'recursive' => -1));
		foreach($surgicalPerformCount as $surgicalPerformCountVal) {
			$filterSurgicalPerformDateArray[] = $surgicalPerformCountVal[0]['month_reports'];
			$filterSurgicalPerformCountArray[$surgicalPerformCountVal[0]['month_reports']] = $surgicalPerformCountVal[0]['spcount'];
		}
		$this->set('filterSurgicalPerformDateArray', isset($filterSurgicalPerformDateArray)?$filterSurgicalPerformDateArray:"");
		$this->set('filterSurgicalPerformCountArray', isset($filterSurgicalPerformCountArray)?$filterSurgicalPerformCountArray:0);

	}

	/**
	 * ssi rate chart
	 *
	 */


	public function admin_ssirate_chart() {
		$this->set('title_for_layout', __('SSI Rate Chart', true));
		if ($this->request->is('post')) {
			$reportYear = $this->request->data['reportYear'];
			$fromDate = $reportYear."-01-01"; // set first date of current year
			$toDate = $reportYear."-12-31"; // set last date of current year
			$this->ssiratereports($fromDate,$toDate);
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
		}

		$this->set('yaxisArray', $yaxisArray);
	}


	/**
	 * ssi rate xls reports
	 *
	 */

	public function admin_ssirate_xls() {
		$this->set('title_for_layout', __('SSI Rate XLS Report', true));
		if ($this->request->is('post')) {
			$reportYear = $this->request->data['reportYear'];
			$fromDate = $reportYear."-01-01"; // set first date of current year
			$toDate = $reportYear."-12-31"; // set last date of current year
			$this->ssiratereports($fromDate,$toDate);
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray', $yaxisArray);
		}
		$this->set('reportYear', isset($this->request->data['reportYear'])?$this->request->data['reportYear']:date("Y"));
		$this->layout = false;
	}

	/**
	 * uti rate reports
	 *
	 */

	public function admin_utirate() {
		$this->set('title_for_layout', __('UTI Rate', true));
		if ($this->request->is('post')) {
			$reportYear = $this->request->data['reportYear'];
			$fromDate = $reportYear."-01-01"; // set first date of current year
			$toDate = $reportYear."-12-31"; // set last date of current year
			$this->utiratereports($fromDate,$toDate);
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray', $yaxisArray);
		} else {
			$fromDate = date("Y")."-01-01"; // set first date of current year
			$toDate = date("Y")."-12-31"; // set last date of current year
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray', $yaxisArray);
			$this->utiratereports();

		}
		$this->set('reportYear', isset($this->request->data['reportYear'])?$this->request->data['reportYear']:date("Y"));
	}


	/**
	 * uti rate reports query
	 *
	 */

	private function utiratereports($fromDate=null,$toDate=null) {
		$this->uses = array('NosocomialInfection');
		if(empty($fromDate) && empty($toDate)) {
			$fromDate = date("Y")."-01-01"; // set first date of current year
			$toDate = date("Y")."-12-31";
		}
		// count of uti infected cases //
		$utiCount = $this->NosocomialInfection->find('all', array('fields' => array('COUNT(*) AS uticount', 'DATE_FORMAT(submit_date, "%M-%Y") AS month_reports', 'NosocomialInfection.urinary_tract_infection', 'submit_date', 'NosocomialInfection.location_id', 'NosocomialInfection.id'), 'conditions' => array('NosocomialInfection.location_id' => $this->Session->read('locationid'), 'NosocomialInfection.urinary_tract_infection' => 'Yes','NosocomialInfection.submit_date BETWEEN ? AND ?' => array($fromDate, $toDate)), 'group' => array('urinary_tract_infection', 'month_reports')));
		foreach($utiCount as $utiCountVal) {
			$filterUtiDateArray[] = $utiCountVal[0]['month_reports'];
			$filterUtiCountArray[$utiCountVal[0]['month_reports']] = $utiCountVal[0]['uticount'];
		}
		$this->set('filterUtiDateArray', isset($filterUtiDateArray)?$filterUtiDateArray:"");
		$this->set('filterUtiCountArray', isset($filterUtiCountArray)?$filterUtiCountArray:0);

		// count total uti days //
		$utiTotalCount = $this->NosocomialInfection->find('all', array('fields' => array('COUNT(*) AS uticount', 'DATE_FORMAT(submit_date, "%M-%Y") AS month_reports', 'NosocomialInfection.urinary_tract_infection', 'submit_date', 'NosocomialInfection.location_id', 'NosocomialInfection.id'), 'conditions' => array('NosocomialInfection.location_id' => $this->Session->read('locationid'), 'NosocomialInfection.urinary_tract_infection' => array('Yes', 'No'),'NosocomialInfection.submit_date BETWEEN ? AND ?' => array($fromDate, $toDate)), 'group' => array('month_reports')));
		foreach($utiTotalCount as $utiTotalCountVal) {
			$filterUtiTotalDateArray[] = $utiTotalCountVal[0]['month_reports'];
			$filterUtiTotalCountArray[$utiTotalCountVal[0]['month_reports']] = $utiTotalCountVal[0]['uticount'];
		}
		$this->set('filterUtiTotalDateArray', isset($filterUtiTotalDateArray)?$filterUtiTotalDateArray:"");
		$this->set('filterUtiTotalCountArray', isset($filterUtiTotalCountArray)?$filterUtiTotalCountArray:0);

	}

	/**
	 * uti rate chart
	 *
	 */


	public function admin_utirate_chart() {
		$this->set('title_for_layout', __('SSI Rate Chart', true));
		if ($this->request->is('post')) {
			$reportYear = $this->request->data['reportYear'];
			$fromDate = $reportYear."-01-01"; // set first date of current year
			$toDate = $reportYear."-12-31"; // set last date of current year
			$this->utiratereports($fromDate,$toDate);
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
		}

		$this->set('yaxisArray', $yaxisArray);
	}


	/**
	 * uti rate xls reports
	 *
	 */

	public function admin_utirate_xls() {
		$this->set('title_for_layout', __('SSI Rate XLS Report', true));
		if ($this->request->is('post')) {
			$reportYear = $this->request->data['reportYear'];
			$fromDate = $reportYear."-01-01"; // set first date of current year
			$toDate = $reportYear."-12-31"; // set last date of current year
			$this->utiratereports($fromDate,$toDate);
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray', $yaxisArray);
		}
		$this->set('reportYear', isset($this->request->data['reportYear'])?$this->request->data['reportYear']:date("Y"));
		$this->layout = false;
	}

	/**
	 * vap rate reports
	 *
	 */

	public function admin_vaprate() {
		$this->set('title_for_layout', __('VAP Rate', true));
		if ($this->request->is('post')) {
			$reportYear = $this->request->data['reportYear'];
			$fromDate = $reportYear."-01-01"; // set first date of current year
			$toDate = $reportYear."-12-31"; // set last date of current year
			$this->vapratereports($fromDate,$toDate);
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray', $yaxisArray);
		} else {
			$fromDate = date("Y")."-01-01"; // set first date of current year
			$toDate = date("Y")."-12-31"; // set last date of current year
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray', $yaxisArray);
			$this->vapratereports();

		}
		$this->set('reportYear', isset($this->request->data['reportYear'])?$this->request->data['reportYear']:date("Y"));
	}


	/**
	 * vap rate reports query
	 *
	 */

	private function vapratereports($fromDate=null,$toDate=null) {
		$this->uses = array('NosocomialInfection');
		if(empty($fromDate) && empty($toDate)) {
			$fromDate = date("Y")."-01-01"; // set first date of current year
			$toDate = date("Y")."-12-31";
		}
		// count of vap cases //
		$vapCount = $this->NosocomialInfection->find('all', array('fields' => array('COUNT(*) AS vapcount', 'DATE_FORMAT(submit_date, "%M-%Y") AS month_reports', 'NosocomialInfection.ventilator_associated_pneumonia', 'submit_date', 'NosocomialInfection.location_id', 'NosocomialInfection.id'), 'conditions' => array('NosocomialInfection.location_id' => $this->Session->read('locationid'), 'NosocomialInfection.ventilator_associated_pneumonia' => 'Yes','NosocomialInfection.submit_date BETWEEN ? AND ?' => array($fromDate, $toDate)), 'group' => array('ventilator_associated_pneumonia', 'month_reports')));
		foreach($vapCount as $vapCountVal) {
			$filterVapDateArray[] = $vapCountVal[0]['month_reports'];
			$filterVapCountArray[$vapCountVal[0]['month_reports']] = $vapCountVal[0]['vapcount'];
		}
		$this->set('filterVapDateArray', isset($filterVapDateArray)?$filterVapDateArray:"");
		$this->set('filterVapCountArray', isset($filterVapCountArray)?$filterVapCountArray:0);

		// count total vap days //
		$vapTotalCount = $this->NosocomialInfection->find('all', array('fields' => array('COUNT(*) AS vapcount', 'DATE_FORMAT(submit_date, "%M-%Y") AS month_reports', 'NosocomialInfection.ventilator_associated_pneumonia', 'submit_date', 'NosocomialInfection.location_id', 'NosocomialInfection.id'), 'conditions' => array('NosocomialInfection.location_id' => $this->Session->read('locationid'), 'NosocomialInfection.ventilator_associated_pneumonia' => array('Yes', 'No'),'NosocomialInfection.submit_date BETWEEN ? AND ?' => array($fromDate, $toDate)), 'group' => array('month_reports')));
		foreach($vapTotalCount as $vapTotalCountVal) {
			$filterVapTotalDateArray[] = $vapTotalCountVal[0]['month_reports'];
			$filterVapTotalCountArray[$vapTotalCountVal[0]['month_reports']] = $vapTotalCountVal[0]['vapcount'];
		}
		$this->set('filterVapTotalDateArray', isset($filterVapTotalDateArray)?$filterVapTotalDateArray:"");
		$this->set('filterVapTotalCountArray', isset($filterVapTotalCountArray)?$filterVapTotalCountArray:0);

	}

	/**
	 * vap rate chart
	 *
	 */


	public function admin_vaprate_chart() {
		$this->set('title_for_layout', __('VAP Rate Chart', true));
		if ($this->request->is('post')) {
			$reportYear = $this->request->data['reportYear'];
			$fromDate = $reportYear."-01-01"; // set first date of current year
			$toDate = $reportYear."-12-31"; // set last date of current year
			$this->vapratereports($fromDate,$toDate);
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
		}

		$this->set('yaxisArray', $yaxisArray);
	}


	/**
	 * vap rate xls reports
	 *
	 */

	public function admin_vaprate_xls() {
		$this->set('title_for_layout', __('VAP Rate XLS Report', true));
		if ($this->request->is('post')) {
			$reportYear = $this->request->data['reportYear'];
			$fromDate = $reportYear."-01-01"; // set first date of current year
			$toDate = $reportYear."-12-31"; // set last date of current year
			$this->vapratereports($fromDate,$toDate);
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray', $yaxisArray);
		}
		$this->set('reportYear', isset($this->request->data['reportYear'])?$this->request->data['reportYear']:date("Y"));
		$this->layout = false;
	}

	/**
	 * bsi rate reports
	 *
	 */

	public function admin_bsirate() {
		$this->set('title_for_layout', __('BSI Rate', true));
		if ($this->request->is('post')) {
			$reportYear = $this->request->data['reportYear'];
			$fromDate = $reportYear."-01-01"; // set first date of current year
			$toDate = $reportYear."-12-31"; // set last date of current year
			$this->bsiratereports($fromDate,$toDate);
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray', $yaxisArray);
		} else {
			$fromDate = date("Y")."-01-01"; // set first date of current year
			$toDate = date("Y")."-12-31"; // set last date of current year
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray', $yaxisArray);
			$this->bsiratereports();

		}
		$this->set('reportYear', isset($this->request->data['reportYear'])?$this->request->data['reportYear']:date("Y"));
	}


	/**
	 * bsi rate reports query
	 *
	 */

	private function bsiratereports($fromDate=null,$toDate=null) {
		$this->uses = array('NosocomialInfection');
		if(empty($fromDate) && empty($toDate)) {
			$fromDate = date("Y")."-01-01"; // set first date of current year
			$toDate = date("Y")."-12-31";
		}

		// count of bsi cases //
		$bsiCount = $this->NosocomialInfection->find('all', array('fields' => array('COUNT(*) AS bsicount', 'DATE_FORMAT(submit_date, "%M-%Y") AS month_reports', 'NosocomialInfection.clabsi', 'submit_date', 'NosocomialInfection.location_id', 'NosocomialInfection.id'), 'conditions' => array('NosocomialInfection.location_id' => $this->Session->read('locationid'), 'NosocomialInfection.clabsi' => 'Yes','NosocomialInfection.submit_date BETWEEN ? AND ?' => array($fromDate, $toDate)), 'group' => array('clabsi', 'month_reports')));
		foreach($bsiCount as $bsiCountVal) {
			$filterBsiDateArray[] = $bsiCountVal[0]['month_reports'];
			$filterBsiCountArray[$bsiCountVal[0]['month_reports']] = $bsiCountVal[0]['bsicount'];
		}
		$this->set('filterBsiDateArray', isset($filterBsiDateArray)?$filterBsiDateArray:"");
		$this->set('filterBsiCountArray', isset($filterBsiCountArray)?$filterBsiCountArray:0);
		// count total bsi days //
		$bsiTotalCount = $this->NosocomialInfection->find('all', array('fields' => array('COUNT(*) AS bsicount', 'DATE_FORMAT(submit_date, "%M-%Y") AS month_reports', 'NosocomialInfection.clabsi', 'submit_date', 'NosocomialInfection.location_id', 'NosocomialInfection.id'), 'conditions' => array('NosocomialInfection.location_id' => $this->Session->read('locationid'), 'NosocomialInfection.clabsi' => array('Yes', 'No'),'NosocomialInfection.submit_date BETWEEN ? AND ?' => array($fromDate, $toDate)), 'group' => array('month_reports')));
		foreach($bsiTotalCount as $bsiTotalCountVal) {
			$filterBsiTotalDateArray[] = $bsiTotalCountVal[0]['month_reports'];
			$filterBsiTotalCountArray[$bsiTotalCountVal[0]['month_reports']] = $bsiTotalCountVal[0]['bsicount'];
		}
		$this->set('filterBsiTotalDateArray', isset($filterBsiTotalDateArray)?$filterBsiTotalDateArray:"");
		$this->set('filterBsiTotalCountArray', isset($filterBsiTotalCountArray)?$filterBsiTotalCountArray:0);

	}

	/**
	 * bsi rate chart
	 *
	 */


	public function admin_bsirate_chart() {
		$this->set('title_for_layout', __('BSI Rate Chart', true));
		if ($this->request->is('post')) {
			$reportYear = $this->request->data['reportYear'];
			$fromDate = $reportYear."-01-01"; // set first date of current year
			$toDate = $reportYear."-12-31"; // set last date of current year
			$this->bsiratereports($fromDate,$toDate);
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
		}

		$this->set('yaxisArray', $yaxisArray);
	}


	/**
	 * bsi rate xls reports
	 *
	 */

	public function admin_bsirate_xls() {
		$this->set('title_for_layout', __('BSI Rate XLS Report', true));
		if ($this->request->is('post')) {
			$reportYear = $this->request->data['reportYear'];
			$fromDate = $reportYear."-01-01"; // set first date of current year
			$toDate = $reportYear."-12-31"; // set last date of current year
			$this->bsiratereports($fromDate,$toDate);
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray', $yaxisArray);
		}
		$this->set('reportYear', isset($this->request->data['reportYear'])?$this->request->data['reportYear']:date("Y"));
		$this->layout = false;
	}

	/**
	 * thrombophlebitis rate reports
	 *
	 */

	public function admin_thrombophlebitisrate() {
		$this->set('title_for_layout', __('Thrombophlebitis Rate', true));
		if ($this->request->is('post')) {
			$reportYear = $this->request->data['reportYear'];
			$fromDate = $reportYear."-01-01"; // set first date of current year
			$toDate = $reportYear."-12-31"; // set last date of current year
			$this->thrombophlebitisratereports($fromDate,$toDate);
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray', $yaxisArray);
		} else {
			$fromDate = date("Y")."-01-01"; // set first date of current year
			$toDate = date("Y")."-12-31"; // set last date of current year
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray', $yaxisArray);
			$this->thrombophlebitisratereports();

		}
		$this->set('reportYear', isset($this->request->data['reportYear'])?$this->request->data['reportYear']:date("Y"));
	}


	/**
	 * thrombophlebitis rate reports query
	 *
	 */

	private function thrombophlebitisratereports($fromDate=null,$toDate=null) {
		$this->uses = array('NosocomialInfection');
		if(empty($fromDate) && empty($toDate)) {
			$fromDate = date("Y")."-01-01"; // set first date of current year
			$toDate = date("Y")."-12-31";
		}

		// count of thrombophlebitis cases //
		$thromboCount = $this->NosocomialInfection->find('all', array('fields' => array('COUNT(*) AS thrombocount', 'DATE_FORMAT(submit_date, "%M-%Y") AS month_reports', 'NosocomialInfection.thrombophlebitis', 'submit_date', 'NosocomialInfection.location_id', 'NosocomialInfection.id'), 'conditions' => array('NosocomialInfection.location_id' => $this->Session->read('locationid'), 'NosocomialInfection.thrombophlebitis' => 'Yes','NosocomialInfection.submit_date BETWEEN ? AND ?' => array($fromDate, $toDate)), 'group' => array('thrombophlebitis', 'month_reports')));
		foreach($thromboCount as $thromboCountVal) {
			$filterThromboDateArray[] = $thromboCountVal[0]['month_reports'];
			$filterThromboCountArray[$thromboCountVal[0]['month_reports']] = $thromboCountVal[0]['thrombocount'];
		}
		$this->set('filterThromboDateArray', isset($filterThromboDateArray)?$filterThromboDateArray:"");
		$this->set('filterThromboCountArray', isset($filterThromboCountArray)?$filterThromboCountArray:0);

		// count total thrombophlebitis days //
		$thromboTotalCount = $this->NosocomialInfection->find('all', array('fields' => array('COUNT(*) AS thrombocount', 'DATE_FORMAT(submit_date, "%M-%Y") AS month_reports', 'NosocomialInfection.thrombophlebitis', 'submit_date', 'NosocomialInfection.location_id', 'NosocomialInfection.id'), 'conditions' => array('NosocomialInfection.location_id' => $this->Session->read('locationid'), 'NosocomialInfection.thrombophlebitis' => array('Yes', 'No'),'NosocomialInfection.submit_date BETWEEN ? AND ?' => array($fromDate, $toDate)), 'group' => array('month_reports')));
		foreach($thromboTotalCount as $thromboTotalCountVal) {
			$filterThromboTotalDateArray[] = $thromboTotalCountVal[0]['month_reports'];
			$filterThromboTotalCountArray[$thromboTotalCountVal[0]['month_reports']] = $thromboTotalCountVal[0]['thrombocount'];
		}
		$this->set('filterThromboTotalDateArray', isset($filterThromboTotalDateArray)?$filterThromboTotalDateArray:"");
		$this->set('filterThromboTotalCountArray', isset($filterThromboTotalCountArray)?$filterThromboTotalCountArray:0);
	}

	/**
	 * thrombophlebitis rate chart
	 *
	 */


	public function admin_thrombophlebitisrate_chart() {
		$this->set('title_for_layout', __('Thrombophlebitis Rate Chart', true));
		if ($this->request->is('post')) {
			$reportYear = $this->request->data['reportYear'];
			$fromDate = $reportYear."-01-01"; // set first date of current year
			$toDate = $reportYear."-12-31"; // set last date of current year
			$this->thrombophlebitisratereports($fromDate,$toDate);
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
		}

		$this->set('yaxisArray', $yaxisArray);
	}


	/**
	 * thrombophlebitis rate xls reports
	 *
	 */

	public function admin_thrombophlebitisrate_xls() {
		$this->set('title_for_layout', __('Thrombophlebitis Rate XLS Report', true));
		if ($this->request->is('post')) {
			$reportYear = $this->request->data['reportYear'];
			$fromDate = $reportYear."-01-01"; // set first date of current year
			$toDate = $reportYear."-12-31"; // set last date of current year
			$this->thrombophlebitisratereports($fromDate,$toDate);
			while($toDate > $fromDate) {
				$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
				$expfromdate = explode("-", $fromDate);
				$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
			$this->set('yaxisArray', $yaxisArray);
		}
		$this->set('reportYear', isset($this->request->data['reportYear'])?$this->request->data['reportYear']:date("Y"));
		$this->layout = false;
	}

	/**
	 *
	 * total admission report by reference doctor
	 *
	 **/
	public function admin_admission_report_by_reference_doctor() {
		$this->uses = array('Patient','Location','Person','Consultant','User','DoctorProfile','ReffererDoctor');

		if($this->request->data){
			// pr($this->request->data);exit;
			// Collect required values in variables
			$format = $this->request->data['PatientAdmissionReport']['format'];
			$from = $this->request->data['PatientAdmissionReport']['from'];
			$to =   $this->request->data['PatientAdmissionReport']['to'];
			$reference_doctor = $this->request->data['PatientAdmissionReport']['reference_doctor'];
			$reference_category = $this->request->data['known_fam_physician'];
				
			$record = '';
			//BOF pankaj code
			$this->Patient->bindModel(array(
 								'belongsTo' => array( 										 
													'Location' =>array('foreignKey' => 'location_id'),
													'Person'=>array('foreignKey'=>'person_id'),
													'DoctorProfile'=>array('foreignKey'=>false,'conditions'=>array('DoctorProfile.user_id=Patient.doctor_id')),
			                                        'User'=>array('foreignKey'=>false,'conditions'=>array('User.id=Patient.doctor_id')),
			                                        'Initial'=>array('foreignKey'=>false,'conditions'=>array('Initial.id=User.initial_id')),
													'Consultant'=>array('foreignKey'=>'consultant_id'),	
			'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),													
													'Department'=>array('foreignKey'=>'department_id'),
			)),false);
				
			if(!empty($to) && !empty($from)){
				$from = $this->DateFormat->formatDate2STDForReport($this->request->data['PatientAdmissionReport']['from'],Configure::read('date_format'))." 00:00:00";
				$to = $this->DateFormat->formatDate2STDForReport($this->request->data['PatientAdmissionReport']['to'],Configure::read('date_format'))." 23:59:59";
				// get record between two dates. Make condition
				$search_key = array('Patient.form_received_on <=' => $to, 'Patient.form_received_on >=' => $from,'Patient.is_deleted'=>0,'Patient.location_id'=>$this->Session->read('locationid'));
			}else{
				$search_key =array('Patient.location_id'=>$this->Session->read('locationid')) ;
			}
			if(!empty($reference_category)){
				$search_key['Patient.known_fam_physician'] =  $reference_category;
			}
			if(!empty($reference_doctor)){
				if($this->data['known_fam_physician'] == 4) {
				 $search_key['Patient.doctor_id'] =  $reference_doctor;
				} else {
				 $search_key['Patient.consultant_id'] =  $reference_doctor;
				}
			}
			$search_key['DoctorProfile.is_deleted'] =  0;
			$search_key['DoctorProfile.location_id'] =  $this->Session->read('locationid');
			$fields =array('PatientInitial.name,Patient.id,Patient.patient_id,Patient.admission_type,Patient.treatment_type,Person.city,Patient.lookup_name,Patient.form_received_on,
	    					Patient.admission_id,Patient.is_emergency,Patient.mobile_phone,Person.age,Person.sex,Person.blood_group,CONCAT(Initial.name," ",DoctorProfile.doctor_name) AS doctor_name,CONCAT(Consultant.first_name," ",Consultant.last_name) AS consultant_name');
				
			$record = $this->Patient->find('all',array('order'=>array('Patient.form_received_on' => 'DESC'),'fields'=>$fields,'conditions'=>$search_key));
			$this->set('selctedFields',$this->request->data['PatientAdmissionReport']['field_id']);
			// echo "<pre>".print_r($record);exit;
			//EOF pankaj code
			//pr($record);exit;
			if($format == 'PDF'){
				$this->set('reports',$record);
				$this->set(compact('fieldName'));
				$this->set(compact('patient_type'));
				$this->render('admission_report_by_referencedoctor_pdf','pdf');
			} else {
				$this->set('reports', $record);
				$this->set(compact('fieldName'));
				$this->set(compact('patient_type'));
				$this->render('admission_report_by_referencedoctor_xls','');
			}
		}
		$this->set('refrences',$this->Consultant->getReffererDoctor());
		$this->set('reffererdoctors',$this->ReffererDoctor->find('list',array('conditions' => array('ReffererDoctor.is_deleted' => 0, 'ReffererDoctor.is_referral' => 'Y'), 'fields' => array('ReffererDoctor.id', 'ReffererDoctor.name'))));
	}

	/**
	 *
	 * chart of total admission report by reference doctor
	 *
	 **/

	public function admin_admission_report_by_reference_doctor_chart(){

		$this->uses = array('Patient','Location','Person','Consultant','User','DoctorProfile');
		if(!empty($this->request->data)){
				
			$this->set('title_for_layout', __('Total Admissions Report Chart', true));

			$reportYear = $this->request->data['PatientAdmissionReport']['year'];
			$reference = $this->request->data['PatientAdmissionReport']['reference_doctor'];
			$patient_type = $this->request->data['PatientAdmissionReport']['type'];
			$reference_category = $this->request->data['known_fam_physician'];
			$location_id = $this->Session->read('locationid');
			$consultantName = '';
			$type = 'All';
			$reportMonth = $this->request->data['PatientAdmissionReport']['month'];
			if(!empty($reportMonth)){
				$countDays = cal_days_in_month(CAL_GREGORIAN, $reportMonth, $reportYear); // Days of the month selected
				$fromDate = $reportYear."-".$reportMonth."-01";
				$toDate = $reportYear."-".$reportMonth."-".$countDays;
			} else {
				$fromDate = $reportYear."-01-01"; // set first date of current year
				$toDate = $reportYear."-12-31"; // set last date of current year
			}
				
			// Bind Models
			$this->Patient->bindModel(array(
								'belongsTo' => array( 										 
													'Location' =>array('foreignKey' => 'location_id'),
													'Person'=>array('foreignKey'=>'person_id'),
			/*'DoctorProfile'=>array('foreignKey'=>false,'conditions'=>array('DoctorProfile.user_id=Patient.doctor_id')),*/
													'Consultant'=>array('foreignKey'=>'consultant_id'),														
													'Department'=>array('foreignKey'=>'department_id'),
			)),false);
			// This will not change the actual from date
			$setDate = $fromDate;
			// Create Y axix array as per month
			while($toDate > $setDate) {
				$yaxisArray[date("F-Y", strtotime($setDate))] = date("F", strtotime($setDate));
				$expfromdate = explode("-", $setDate);
				$setDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
				
			if($fromDate != '' AND $toDate != ''){
				$toSearch = array('Patient.form_received_on <=' => $toDate, 'Patient.form_received_on >=' => $fromDate, 'Patient.is_deleted'=>0,'Patient.location_id'=>$this->Session->read('locationid'));
			}
			if(!empty($reference_category)){
				$toSearch['Patient.known_fam_physician'] =  $reference_category;
			}
			if(!empty($reference)){
				if($this->data['known_fam_physician'] == 4) {
				 $toSearch['Patient.doctor_id'] =  $reference;
				} else {
				 $toSearch['Patient.consultant_id'] =  $reference;
				}
				//$toSearch['Patient.consultant_id'] = $reference; // Condition reference doctors
			}

			if(!empty($patient_type)){
				if($patient_type == 'Emergency'){
					$toSearch['Patient.is_emergency'] = 1;
					$toSearch['Patient.admission_type'] = 'IPD'; // Condition for year and month
					$type = $patient_type;
				} else {
					$toSearch['Patient.admission_type'] = $patient_type; // Condition for year and month
					$type = $patient_type;

				}
			}
				
				
			// Collect record here
			$countRecord = $this->Patient->find('all', array('fields' => array('COUNT(*) AS recordcount', 'DATE_FORMAT(form_received_on, "%M-%Y") AS month_reports',
			 'Patient.form_received_on', 'Patient.doctor_id','Patient.admission_type','Patient.is_emergency','CONCAT(Consultant.first_name," ",Consultant.last_name)'), 
			 'conditions' => $toSearch ,'group' => array('month_reports')));
				
			//pr($countRecord);exit;

			// Set data for view as per record counted
			foreach($countRecord as $countRecordVal) {
				$filterRecordDateArray[] = $countRecordVal[0]['month_reports'];
				$filterRecordCountArray[$countRecordVal[0]['month_reports']] = $countRecordVal[0]['recordcount'];
			}

			$this->set('filterRecordDateArray', isset($filterRecordDateArray)?$filterRecordDateArray:"");
			$this->set('filterRecordCountArray', isset($filterRecordCountArray)?$filterRecordCountArray:0);
			$this->set('yaxisArray', $yaxisArray);
			$this->set(compact('countRecord'));
			$this->set(compact('reportMonth'));
			$this->set(compact('type'));

		}
	}

	/**
	 *
	 * total admission report by patient location
	 *
	 **/
	public function admin_admission_report_by_patient_location() {
		$this->uses = array('Patient','Location','Person','Consultant','User','DoctorProfile');
		$fieldsArr = array('department_id'=>'Department','previous_receivable'=>'Previous receivable','email'=>'Email','relative_name'=>'Relatives name','sponsers_auth'=>'Authorization from Sponsor','mobile_phone'=>'Relative Phone No.','relation'=>'Relationship with patient','doc_ini_assessment'=>'Form received by Patient','form_received_on'=>'Form received Date','nurse_assessment'=>'Registration Completed by patient','doc_ini_assess_on'=>'Start of assessment by Doctor','doc_ini_assess_end_on'=>'End of assessment by Doctor','nurse_assess_on'=>'Start of Nursing Assessment','nurse_assess_end_on'=>'End of Nursing Assessment','nutritional_assess_on'=>'Start of Nutritional Assessment',				'nutritional_assess_end_on'=>'End of Nutritional Assessment');
		$this->set('fieldsArr',$fieldsArr);
		if($this->request->data){
			// pr($this->request->data);exit;
			// Collect required values in variables
			$format = $this->request->data['PatientAdmissionReport']['format'];
			$from = $this->request->data['PatientAdmissionReport']['from'];
			$to =   $this->request->data['PatientAdmissionReport']['to'];
			$sex = $this->request->data['PatientAdmissionReport']['sex'];
			$age = $this->request->data['PatientAdmissionReport']['age'];
			$patient_location = $this->request->data['PatientAdmissionReport']['patient_location'];
			$blood_group = $this->request->data['PatientAdmissionReport']['blood_group'];
			$reference_doctor = $this->request->data['PatientAdmissionReport']['reference_doctor'];
			$patient_type = $this->request->data['PatientAdmissionReport']['type'];
				
			if(isset($this->request->data['PatientAdmissionReport']['treatment_type'])){
				$treatment_type = $this->request->data['PatientAdmissionReport']['treatment_type'];
			}
			//$sponsor = $this->request->data['PatientRegistrationReport']['sponsor'];
			$record = '';
			//BOF pankaj code
				
			$this->Patient->bindModel(array(
 								'belongsTo' => array( 										 
													'Location' =>array('foreignKey' => 'location_id'),
													'Person'=>array('foreignKey'=>'person_id'),
													'DoctorProfile'=>array('foreignKey'=>false,'conditions'=>array('DoctorProfile.user_id=Patient.doctor_id')),
			                                        'User'=>array('foreignKey'=>false,'conditions'=>array('User.id=Patient.doctor_id')),
			                                        'Initial'=>array('foreignKey'=>false,'conditions'=>array('Initial.id=User.initial_id')),
													'Consultant'=>array('foreignKey'=>'consultant_id'),	
			'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),													
													'Department'=>array('foreignKey'=>'department_id'),
                                                                                                        'FinalBilling'=>array('foreignKey'=>false,'conditions'=>array('FinalBilling.patient_id=Patient.id'))
			)),false);
				
			if(!empty($to) && !empty($from)){
				$from = $this->DateFormat->formatDate2STDForReport($this->request->data['PatientAdmissionReport']['from'],Configure::read('date_format'))." 00:00:00";
				$to = $this->DateFormat->formatDate2STDForReport($this->request->data['PatientAdmissionReport']['to'],Configure::read('date_format'))." 23:59:59";
				// get record between two dates. Make condition
				$search_key = array('Patient.form_received_on <=' => $to, 'Patient.form_received_on >=' => $from,'Patient.is_deleted'=>0,'Patient.location_id'=>$this->Session->read('locationid'));
			}else{
				$search_key =array('Patient.location_id'=>$this->Session->read('locationid')) ;
			}
			if(!(empty($sex))){
				$search_key['Person.sex'] =  $sex;
			}
			if(!(empty($age))){
				$ageRange = explode('-',$age);
				$search_key['Person.age between ? and ?'] =  array($ageRange[0],$ageRange[1]);
			}
			if(!(empty($blood_group))){
				$search_key['Person.blood_group'] =  $blood_group;
			}
			if(!empty($patient_location)){
				$search_key['Person.city'] =  $patient_location;
			}
			if(!empty($reference_doctor)){
				$search_key['Patient.consultant_id'] =  $reference_doctor;
			}
			if(!empty($patient_type)){
				if($patient_type == 'Emergency'){
					$search_key['Patient.is_emergency'] = 1;
					$search_key['Patient.admission_type'] =  'IPD';
				} else if($patient_type == 'IPD'){
					$search_key['Patient.admission_type'] =  'IPD';
				} else if($patient_type == 'OPD'){
					if(isset($treatment_type) AND $treatment_type != ''){
						$search_key['Patient.treatment_type'] = $treatment_type;
						$search_key['Patient.admission_type'] =  'OPD';
					} else {
						$search_key['Patient.admission_type'] =  'OPD';
					}
				}
			}

			$search_key['DoctorProfile.is_deleted'] =  0;
			$search_key['DoctorProfile.location_id'] =  $this->Session->read('locationid');
			//$search_key['User.is_deleted']  = 0;
			//pr($search_key);exit;
			$selectedFields = '';
			if(!empty($this->request->data['PatientAdmissionReport']['field_id'])){
				foreach($this->request->data['PatientAdmissionReport']['field_id'] as $key=>$value){
					if($key=='department_id'){
						$selectedFields .= ",Department.name";
					}else{
						$selectedFields .= ",Patient.".$this->request->data['PatientAdmissionReport']['field_id'][$key];
					}
				}
			}
			$fields =array('PatientInitial.name,Patient.id,Patient.patient_id,Patient.admission_type,Patient.treatment_type,Person.city,Patient.lookup_name,Patient.form_received_on,
	    					Patient.admission_id,Patient.is_emergency, Patient.mobile_phone,Person.age,Person.sex,Person.blood_group,CONCAT(Initial.name," ",DoctorProfile.doctor_name) AS doctor_name,CONCAT(Consultant.first_name," ",Consultant.last_name)'.$selectedFields);
				
			$record = $this->Patient->find('all',array('order'=>array('Patient.form_received_on' => 'DESC'),'fields'=>$fields,'conditions'=>$search_key));
			$this->set('selctedFields',$this->request->data['PatientAdmissionReport']['field_id']);

			//EOF pankaj code
			//pr($record);exit;
			if($format == 'PDF'){
				$this->set('reports',$record);
				$this->set(compact('fieldName'));
				$this->set(compact('patient_type'));
				$this->render('admission_report_by_patientlocation_pdf','pdf');
			} else {
				$this->set('reports', $record);
				$this->set(compact('fieldName'));
				$this->set(compact('patient_type'));
				$this->render('admission_report_by_patientlocation_xls','');
			}
		}
		//patient location
		$this->set('locationlist',$this->Person->find('list',array('fields'=>array('city','city'))));
	}

	/**
	 *
	 * chart of total admission report by patient location
	 *
	 **/

	public function admin_admission_report_by_patient_location_chart() {

		$this->uses = array('Patient','Location','Person','Consultant','User','DoctorProfile');
		if(!empty($this->request->data)){
				
			$this->set('title_for_layout', __('Total Admissions Report Chart By Location', true));

			$reportYear = $this->request->data['PatientAdmissionReport']['year'];
			$reference = $this->request->data['PatientAdmissionReport']['reference_doctor'];
			$patient_type = $this->request->data['PatientAdmissionReport']['type'];
			$location_id = $this->Session->read('locationid');
			$consultantName = '';
			$type = 'All';
			$reportMonth = $this->request->data['PatientAdmissionReport']['month'];
			if(!empty($reportMonth)){
				$countDays = cal_days_in_month(CAL_GREGORIAN, $reportMonth, $reportYear); // Days of the month selected
				$fromDate = $reportYear."-".$reportMonth."-01";
				$toDate = $reportYear."-".$reportMonth."-".$countDays;
			} else {
				$fromDate = $reportYear."-01-01"; // set first date of current year
				$toDate = $reportYear."-12-31"; // set last date of current year
			}
				
			// Bind Models
			$this->Patient->bindModel(array(
								'belongsTo' => array( 										 
													'Location' =>array('foreignKey' => 'location_id'),
													'Person'=>array('foreignKey'=>'person_id'),
			/*'DoctorProfile'=>array('foreignKey'=>false,'conditions'=>array('DoctorProfile.user_id=Patient.doctor_id')),*/
													'Consultant'=>array('foreignKey'=>'consultant_id'),														
													'Department'=>array('foreignKey'=>'department_id'),
			)),false);
			// This will not change the actual from date
			$setDate = $fromDate;
			// Create Y axix array as per month
			while($toDate > $setDate) {
				$yaxisArray[date("F-Y", strtotime($setDate))] = date("F", strtotime($setDate));
				$expfromdate = explode("-", $setDate);
				$setDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
				
			if($fromDate != '' AND $toDate != ''){
				$toSearch = array('Patient.form_received_on <=' => $toDate, 'Patient.form_received_on >=' => $fromDate, 'Patient.is_deleted'=>0,'Patient.location_id'=>$this->Session->read('locationid'));
			}

			if(!empty($reference)){
				$toSearch['Patient.consultant_id'] = $reference; // Condition reference doctors
			}

			if(!empty($patient_type)){
				if($patient_type == 'Emergency'){
					$toSearch['Patient.is_emergency'] = 1;
					$toSearch['Patient.admission_type'] = 'IPD'; // Condition for year and month
					$type = $patient_type;
				} else {
					$toSearch['Patient.admission_type'] = $patient_type; // Condition for year and month
					$type = $patient_type;

				}
			}
				
				
			// Collect record here
			$countRecord = $this->Patient->find('all', array('fields' => array('COUNT(*) AS recordcount', 'DATE_FORMAT(form_received_on, "%M-%Y") AS month_reports',
			 'Patient.form_received_on', 'Patient.doctor_id','Patient.admission_type','Patient.is_emergency','CONCAT(Consultant.first_name," ",Consultant.last_name)'), 
			 'conditions' => $toSearch ,'group' => array('month_reports')));
				
			//pr($countRecord);exit;

			// Set data for view as per record counted
			foreach($countRecord as $countRecordVal) {
				$filterRecordDateArray[] = $countRecordVal[0]['month_reports'];
				$filterRecordCountArray[$countRecordVal[0]['month_reports']] = $countRecordVal[0]['recordcount'];
			}

			$this->set('filterRecordDateArray', isset($filterRecordDateArray)?$filterRecordDateArray:"");
			$this->set('filterRecordCountArray', isset($filterRecordCountArray)?$filterRecordCountArray:0);
			$this->set('yaxisArray', $yaxisArray);
			$this->set(compact('countRecord'));
			$this->set(compact('reportMonth'));
			$this->set(compact('type'));

		}
	}

	/**
	 * daily cash collection report
	 *
	 */

	public function admin_daily_cash_collection() {
		$this->set('title_for_layout', __('Daily Cash Collection', true));
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->dailyCashCollection($this->request->data);
			if($this->request->data['format'] == "PDF") {
				$this->render('daily_cash_collection_pdf', 'pdf');
			}
			if($this->request->data['format'] == "EXCEL") {
				$this->render('daily_cash_collection_xls','');
			}
		}
	}


	/**
	 * daily cash collection query
	 *
	 */

	private function dailyCashCollection($getData=null) {
		$this->uses = array('Billing','RadiologyTestPayment','LabTestPayment','PharmacySalesBill');
		$from = $this->DateFormat->formatDate2STDForReport($getData['from'],Configure::read('date_format'))." 00:00:00";
		$to = $this->DateFormat->formatDate2STDForReport($getData['to'],Configure::read('date_format'))." 23:59:59";

		if($getData['admission_type'] != "") {
			$conditions['Patient']['admission_type'] = $getData['admission_type'];
		} else {
			$conditions['Patient']['admission_type'] =  array('IPD', 'OPD');
			
		} 
		if($getData['skip_registration'] != "") { 
			$conditions['Patient']['treatment_type'] = $getData['skip_registration'];
		}
		if($getData['ipd_patient_status'] != "") { 
			$conditions['Patient']['is_discharge'] = $getData['ipd_patient_status'];
		}
		if($getData['opd_patient_status'] != "") { 
			$conditions['Patient']['is_discharge'] = $getData['opd_patient_status'];
		}
		
		$conditions['Patient']['location_id'] = $this->Session->read('locationid');
		$conditions['Patient']['is_deleted'] = 0;
		// get billing cash collection //
		$this->Billing->bindModel(array('belongsTo'=>array('Patient'=>array('foreignKey'=>false,'conditions'=>array("Billing.patient_id=Patient.id")),
		          'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
		                                                  'Department' =>array('foreignKey' => false,'conditions'=>array('Department.id=Patient.department_id' )),
    		                                              'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
		                         )));
		$conditionsBilling['Billing'] = array('date BETWEEN ? AND ?'=> array($from,$to));
		$conditionsBilling['Billing']['mode_of_payment'] = 'Cash';
		$conditionsBilling = $this->postConditions(array_merge($conditionsBilling,$conditions)); 
		
		$getBillingCash = $this->Billing->find("all",array('conditions' => $conditionsBilling, 'fields' => array('Department.name','Person.*','Billing.date','PatientInitial.name','Patient.is_discharge','Patient.form_received_on','Patient.form_completed_on', 'Patient.lookup_name', 'Patient.mobile_phone', 'Patient.admission_type', 'Patient.admission_id', 'Patient.address1', 'SUM(Billing.amount) AS sum_amount','Billing.amount', 'Billing.reason_of_payment', 'Billing.mode_of_payment'), 'group' => array('Billing.id'), 'order' => array('Billing.date')));
		$this->set('getBillingCash', $getBillingCash);
		// get radiology  billing //
		$this->RadiologyTestPayment->bindModel(array('belongsTo'=>array('Patient'=>array('foreignKey'=>false,'conditions'=>array("RadiologyTestPayment.patient_id=Patient.id")),
		                                                                'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id')),
		                                                                'Department' =>array('foreignKey' => false,'conditions'=>array('Department.id=Patient.department_id')),
    		                                                            'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id')),
		)));
		$conditionsRadiology['RadiologyTestPayment'] = array('create_time BETWEEN ? AND ?'=> array($from,$to));
		$conditionsRadiology = $this->postConditions(array_merge($conditionsRadiology,$conditions));
		$getRadiologyTestCash = $this->RadiologyTestPayment->find("all",array('conditions' => $conditionsRadiology, 'fields' => array('Department.name','Person.*','RadiologyTestPayment.create_time','PatientInitial.name','Patient.is_discharge','Patient.form_received_on','Patient.form_completed_on','Patient.lookup_name', 'Patient.mobile_phone', 'Patient.admission_type', 'Patient.admission_id', 'Patient.address1', 'SUM(RadiologyTestPayment.paid_amount) AS sum_amount', 'RadiologyTestPayment.paid_amount'), 'group' => array('RadiologyTestPayment.id'), 'order' => array('RadiologyTestPayment.create_time')));
		
		$this->set('getRadiologyTestCash', $getRadiologyTestCash);
		// get laboratory  billing //
		$this->LabTestPayment->bindModel(array('belongsTo'=>array('Patient'=>array('foreignKey'=>false,'conditions'=>array("LabTestPayment.patient_id=Patient.id")),
		                                                          'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
		                                                          'Department' =>array('foreignKey' => false,'conditions'=>array('Department.id=Patient.department_id' )),
    		                                                      'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
		)));
		$conditionsLaboratory['LabTestPayment'] = array('create_time BETWEEN ? AND ?'=> array($from,$to));
		$conditionsLaboratory = $this->postConditions(array_merge($conditionsLaboratory,$conditions));
		$getLaboratoryTestCash = $this->LabTestPayment->find("all",array('conditions' => $conditionsLaboratory, 'fields' => array('Department.name','Person.*','LabTestPayment.create_time','PatientInitial.name','Patient.is_discharge','Patient.form_received_on','Patient.form_completed_on','Patient.lookup_name', 'Patient.mobile_phone', 'Patient.admission_type', 'Patient.admission_id', 'Patient.address1', 'SUM(LabTestPayment.paid_amount) AS sum_amount', 'LabTestPayment.paid_amount'), 'group' => array('LabTestPayment.id'), 'order' => array('LabTestPayment.create_time')));
		
		$this->set('getLaboratoryTestCash', $getLaboratoryTestCash);
		// get pharmacy  billing //
		$this->PharmacySalesBill->bindModel(array('belongsTo'=>array('Patient'=>array('foreignKey'=>false,'conditions'=>array("PharmacySalesBill.patient_id=Patient.id")),
		'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
		                                                  'Department' =>array('foreignKey' => false,'conditions'=>array('Department.id=Patient.department_id' )),
    		                                             'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
		)));
		$conditionsPharmacy['PharmacySalesBill'] = array('create_time BETWEEN ? AND ?'=> array($from,$to));
		$conditionsBilling['PharmacySalesBill'] = array('mode_of_payment'=> 'cash');
		$conditionsPharmacy = $this->postConditions(array_merge($conditionsPharmacy,$conditions));
		
		$getPharmacyCash = $this->PharmacySalesBill->find("all",array('conditions' => $conditionsPharmacy, 'fields' => array('Department.name','Person.*','PharmacySalesBill.create_time','PatientInitial.name','Patient.is_discharge','Patient.form_received_on','Patient.form_completed_on','Patient.lookup_name', 'Patient.mobile_phone', 'Patient.admission_type', 'Patient.admission_id', 'Patient.address1', 'SUM(PharmacySalesBill.total) AS sum_amount', 'PharmacySalesBill.total'), 'group' => array('PharmacySalesBill.id'), 'order' => array('PharmacySalesBill.create_time')));
		
		$this->set('patientType', $getData['admission_type']);
		$this->set('getPharmacyCash', $getPharmacyCash);
	}

	/**
	 * daily credit collection report
	 *
	 */

	public function admin_daily_credit_collection() {
		$this->set('title_for_layout', __('Daily Credit Collection', true));
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->dailyCreditCollection($this->request->data);
			if($this->request->data['format'] == "PDF") {
				$this->render('daily_credit_collection_pdf', 'pdf');
			}
			if($this->request->data['format'] == "EXCEL") {
				$this->render('daily_credit_collection_xls','');

			}
		}
	}


	/**
	 * daily credit collection query
	 *
	 */

	private function dailyCreditCollection($getData=null) {
		$this->uses = array('Billing','PharmacySalesBill');
		$from = $this->DateFormat->formatDate2STDForReport($getData['from'],Configure::read('date_format'))." 00:00:00";
		$to = $this->DateFormat->formatDate2STDForReport($getData['to'],Configure::read('date_format'))." 23:59:59";

		if($getData['admission_type'] != "") {
			$conditions['Patient']['admission_type'] = $getData['admission_type'];
		} else {
			$conditions['Patient']['admission_type'] =  array('IPD', 'OPD');
			
		} 
		if($getData['skip_registration'] != "") { 
			$conditions['Patient']['treatment_type'] = $getData['skip_registration'];
		}
		if($getData['ipd_patient_status'] != "") { 
			$conditions['Patient']['is_discharge'] = $getData['ipd_patient_status'];
		}
		if($getData['opd_patient_status'] != "") { 
			$conditions['Patient']['is_discharge'] = $getData['opd_patient_status'];
		}
		if($getData['sponsor_details'] != "") { 
			$conditions['Patient']['credit_type_id'] = $getData['sponsor_details'];
		}
		if($getData['[PatientRegistrationReport]']['corporate_location_id'] != "") { 
			$conditions['Patient']['corporate_location_id'] = $getData['[PatientRegistrationReport]']['corporate_location_id'];
		}
		if($getData['[PatientRegistrationReport]']['corporate_id'] != "") { 
			$conditions['Patient']['corporate_id'] = $getData['[PatientRegistrationReport]']['corporate_id'];
		}
		if($getData['[PatientRegistrationReport]']['sublocation_id'] != "") { 
			$conditions['Patient']['corporate_sublocation_id'] = $getData['[PatientRegistrationReport]']['sublocation_id'];
		}
		if($getData['[PatientRegistrationReport]']['[insurance_type_id]'] != "") { 
			$conditions['Patient']['insurance_type_id'] = $getData['[PatientRegistrationReport]']['[insurance_type_id]'];
		}
		if($getData['[PatientRegistrationReport]']['[insurenceCom_id]'] != "") { 
			$conditions['Patient']['insurance_company_id'] = $getData['[PatientRegistrationReport]']['[insurenceCom_id]'];
		}

		$conditions['Patient']['location_id'] = $this->Session->read('locationid');
		$conditions['Patient']['is_deleted'] = 0;
		// get billing cash collection //
		$this->Billing->bindModel(array('belongsTo'=>array('Patient'=>array('foreignKey'=>false,'conditions'=>array("Billing.patient_id=Patient.id")),
		   'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
		                                                  'Department' =>array('foreignKey' => false,'conditions'=>array('Department.id=Patient.department_id' )),
    		                                             'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
		)));
		$conditionsBilling['Billing'] = array('date BETWEEN ? AND ?'=> array($from,$to));
		$conditionsBilling['Billing']['mode_of_payment'] =  'Credit Card';
		$conditionsBilling = $this->postConditions(array_merge($conditions,$conditionsBilling));
		$getBillingCredit = $this->Billing->find("all",array('conditions' => $conditionsBilling, 'fields' => array('Department.name','Person.*','Billing.date','PatientInitial.name', 'Patient.is_discharge','Patient.form_received_on','Patient.form_completed_on', 'Patient.lookup_name', 'Patient.mobile_phone', 'Patient.admission_type', 'Patient.admission_id', 'Patient.address1', 'SUM(Billing.amount) AS sum_amount', 'Billing.amount', 'Billing.reason_of_payment'), 'group' => array('Billing.id'),'order' => array('Billing.date')));
		$this->set('getBillingCredit', $getBillingCredit);
		// get pharmacy  billing //
		$this->PharmacySalesBill->bindModel(array('belongsTo'=>array('Patient'=>array('foreignKey'=>false,'conditions'=>array("PharmacySalesBill.patient_id=Patient.id")),
		'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
		                                                  'Department' =>array('foreignKey' => false,'conditions'=>array('Department.id=Patient.department_id' )),
    		                                             'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
		)));
		$conditionsPharmacy['PharmacySalesBill'] = array('create_time BETWEEN ? AND ?'=> array($from,$to));
		$conditionsBilling['PharmacySalesBill']['mode_of_payment'] =  'credit';
		$conditionsPharmacy = $this->postConditions(array_merge($conditions, $conditionsPharmacy));
		$getPharmacyCredit = $this->PharmacySalesBill->find("all",array('conditions' => $conditionsPharmacy, 'fields' => array('Department.name','Person.*','PharmacySalesBill.create_time','PatientInitial.name', 'Patient.is_discharge','Patient.form_received_on','Patient.form_completed_on', 'Patient.lookup_name', 'Patient.mobile_phone', 'Patient.admission_type', 'Patient.admission_id', 'Patient.address1', 'SUM(PharmacySalesBill.total) AS sum_amount', 'PharmacySalesBill.total'), 'group' => array('PharmacySalesBill.id'),'order' => array('PharmacySalesBill.create_time')));
		$this->set('getPharmacyCredit', $getPharmacyCredit);
		$this->set('patientType', $getData['admission_type']);

	}

	/**
	 * daily check collection report
	 *
	 */

	public function admin_daily_check_collection() {
		$this->set('title_for_layout', __('Daily Check Collection', true));
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->dailyCheckCollection($this->request->data);
			if($this->request->data['format'] == "PDF") {
				$this->render('daily_check_collection_pdf', 'pdf');
			}
			if($this->request->data['format'] == "EXCEL") {
				$this->render('daily_check_collection_xls','');

			}
		}
	}


	/**
	 * daily check collection query
	 *
	 */

	private function dailyCheckCollection($getData=null) {
		$this->uses = array('Billing');
		$from = $this->DateFormat->formatDate2STDForReport($getData['from'],Configure::read('date_format'))." 00:00:00";
		$to = $this->DateFormat->formatDate2STDForReport($getData['to'],Configure::read('date_format'))." 23:59:59";
        $conditionsBilling['Billing'] = array('date BETWEEN ? AND ?'=> array($from,$to));
		if($getData['admission_type'] != "") {
			$conditions['Patient']['admission_type'] = $getData['admission_type'];
		} else {
			$conditions['Patient']['admission_type'] =  array('IPD', 'OPD');
			
		} 
		if($getData['skip_registration'] != "") { 
			$conditions['Patient']['treatment_type'] = $getData['skip_registration'];
		}
		if($getData['ipd_patient_status'] != "") { 
			$conditions['Patient']['is_discharge'] = $getData['ipd_patient_status'];
		}
		if($getData['opd_patient_status'] != "") { 
			$conditions['Patient']['is_discharge'] = $getData['opd_patient_status'];
		}
		if($getData['collection_type'] != "") {  
			$conditionsBilling['Billing']['mode_of_payment'] = $getData['collection_type'];
		} else {
			$conditionsBilling['Billing']['mode_of_payment'] = array('Cheque', 'NEFT');
		}
		
		
		$conditions['Patient']['location_id'] = $this->Session->read('locationid');
		$conditions['Patient']['is_deleted'] = 0;
		// get billing check collection //
		$this->Billing->bindModel(array('belongsTo'=>array('Patient'=>array('foreignKey'=>false,'conditions'=>array("Billing.patient_id=Patient.id")),
		'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
		                                                  'Department' =>array('foreignKey' => false,'conditions'=>array('Department.id=Patient.department_id' )),
    		                                             'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
		)));
		
		
		$conditionsBilling = $this->postConditions(array_merge($conditions,$conditionsBilling));
		
		$getBillingCheck = $this->Billing->find("all",array('conditions' => $conditionsBilling, 'fields' => array('Department.name','Person.*','Billing.date','PatientInitial.name', 'Patient.is_discharge','Patient.form_received_on','Patient.form_completed_on', 'Patient.lookup_name', 'Patient.mobile_phone', 'Patient.admission_type', 'Patient.admission_id', 'Patient.address1', 'SUM(Billing.amount) AS sum_amount','Billing.amount', 'Billing.reason_of_payment','Billing.check_credit_card_number','Billing.mode_of_payment','Billing.neft_number'), 'group' => array('Billing.id'),'order' => array('Billing.date')));
		$this->set('getBillingCheck', $getBillingCheck);
		$this->set('patientType', $getData['admission_type']);
	}

	/**
	 * payment dues report
	 *
	 */

	public function admin_payment_dues() {
		$this->set('title_for_layout', __('Payment Dues', true));
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->paymentDues($this->request->data);
			if($this->request->data['format'] == "PDF") {
				$this->render('daily_payement_dues_pdf', 'pdf');
			}
			if($this->request->data['format'] == "EXCEL") {
				$this->render('daily_payment_dues_xls','');
			}
		}
		 
	}


	/**
	 * payment dues query
	 *
	 */

	private function paymentDues($getData=null) {
		$this->uses = array('FinalBilling','RadiologyTestPayment','LabTestPayment');
		$from = $this->DateFormat->formatDate2STDForReport($getData['from'],Configure::read('date_format'))." 00:00:00";
		$to = $this->DateFormat->formatDate2STDForReport($getData['to'],Configure::read('date_format'))." 23:59:59";

		if($getData['admission_type'] != "") {
			$conditions['Patient']['admission_type'] = $getData['admission_type'];
		} else {
			$conditions['Patient']['admission_type'] =  array('IPD', 'OPD');
			
		} 
		if($getData['skip_registration'] != "") { 
			$conditions['Patient']['treatment_type'] = $getData['skip_registration'];
		}
		if($getData['ipd_patient_status'] != "") { 
			$conditions['Patient']['is_discharge'] = $getData['ipd_patient_status'];
		}
		if($getData['opd_patient_status'] != "") { 
			$conditions['Patient']['is_discharge'] = $getData['opd_patient_status'];
		}

		$conditions['Patient']['location_id'] = $this->Session->read('locationid');
		$conditions['Patient']['is_deleted'] = 0;
		// get final bill pending //
		$this->FinalBilling->bindModel(array('belongsTo'=>array('Patient'=>array('foreignKey'=>false,'conditions'=>array("FinalBilling.patient_id=Patient.id")),
		'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
		                                                  'Department' =>array('foreignKey' => false,'conditions'=>array('Department.id=Patient.department_id' )),
    		                                             'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
		)));
		$conditionsBilling['FinalBilling'] = array('discharge_date BETWEEN ? AND ?'=> array($from,$to));
		$conditionsBilling['FinalBilling']['amount_pending !='] = 0;
		$conditionsBilling = $this->postConditions(array_merge($conditions,$conditionsBilling));
		
		$getBillingPending = $this->FinalBilling->find("all",array('conditions' => $conditionsBilling, 'fields' => array('FinalBilling.discharge_date','Department.name','Person.*','PatientInitial.name','Patient.form_received_on','Patient.form_completed_on','Patient.lookup_name', 'Patient.mobile_phone', 'Patient.admission_type', 'Patient.admission_id', 'Patient.address1', 'FinalBilling.total_amount', 'FinalBilling.amount_paid', 'FinalBilling.amount_pending'),'order' => array('FinalBilling.discharge_date')));
		$this->set('getBillingPending', $getBillingPending);
		// get radiology  bill pending //
		// query for generating latest entry within group query //
		$getLatestRadioList = $this->RadiologyTestPayment->find('all', array('fields' => array('RadiologyTestPayment.id', 'RadiologyTestPayment.patient_id', 'RadiologyTestPayment.total_amount', 'RadiologyTestPayment.status'), 'joins' => array(array('table' => '(SELECT MAX(`id`) as id1 FROM radiology_test_payments  GROUP BY `patient_id`) RadiologyTestPayment1',
                                                                'type'  => 'INNER',
                                                                'foreignKey'    => false,
                                                                'conditions' => array('id = id1'))), 'conditions' => array('create_time BETWEEN ? AND ?'=> array($from,$to))));
		foreach($getLatestRadioList as $getLatestRadioListVal) {
			// get only those list having pending amount //
			if($getLatestRadioListVal['RadiologyTestPayment']['status'] == "advance") {
				$radpatientIdWithAmount[$getLatestRadioListVal['RadiologyTestPayment']['patient_id']] = $getLatestRadioListVal['RadiologyTestPayment']['total_amount'];
			}
		}
		$this->set('radpatientIdWithAmount', $radpatientIdWithAmount);
		$this->RadiologyTestPayment->bindModel(array('belongsTo'=>array('Patient'=>array('foreignKey'=>false,'conditions'=>array("RadiologyTestPayment.patient_id=Patient.id")),
		  'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
		                                                  'Department' =>array('foreignKey' => false,'conditions'=>array('Department.id=Patient.department_id' )),
    		                                             'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
		)));
		$conditionsRadiology['RadiologyTestPayment'] = array('create_time BETWEEN ? AND ?'=> array($from,$to));
		$conditionsRadiology = $this->postConditions(array_merge($conditions,$conditionsRadiology));
		$getRadiologyTestPendingDues = $this->RadiologyTestPayment->find("all",array('conditions' => $conditionsRadiology, 'fields' => array('MAX(RadiologyTestPayment.id) AS id', 'Department.name','Person.*','PatientInitial.name', 'Patient.form_received_on','Patient.form_completed_on', 'Patient.lookup_name', 'Patient.mobile_phone', 'Patient.admission_type', 'Patient.admission_id', 'Patient.address1', 'SUM(RadiologyTestPayment.paid_amount) AS amount','RadiologyTestPayment.patient_id','RadiologyTestPayment.create_time'), 'group' => array('RadiologyTestPayment.patient_id'),'order' => array('RadiologyTestPayment.create_time')));
		$this->set('getRadiologyTestPendingDues', $getRadiologyTestPendingDues);
		// get laboratory  bill pending //
		// query for generating latest entry within group query //
		$getLatestLabList = $this->LabTestPayment->find('all', array('fields' => array('LabTestPayment.id', 'LabTestPayment.patient_id', 'LabTestPayment.total_amount','LabTestPayment.status'), 'joins' => array(array('table' => '(SELECT MAX(`id`) as id1 FROM lab_test_payments  GROUP BY `patient_id`) LabTestPayment1',
                                                                'type'  => 'INNER',
                                                                'foreignKey'    => false,
                                                                'conditions' => array('id = id1'))), 'conditions' => array('create_time BETWEEN ? AND ?'=> array($from,$to))));
		foreach($getLatestLabList as $getLatestLabListVal) {
			// get only those list having pending amount //
			if($getLatestLabListVal['LabTestPayment']['status'] == "advance") {
				$labpatientIdWithAmount[$getLatestLabListVal['LabTestPayment']['patient_id']] = $getLatestLabListVal['LabTestPayment']['total_amount'];
			}
		}
		$this->set('labpatientIdWithAmount', $labpatientIdWithAmount);
		$this->LabTestPayment->bindModel(array('belongsTo'=>array('Patient'=>array('foreignKey'=>false,'conditions'=>array("LabTestPayment.patient_id=Patient.id")),
		 'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
		                                                  'Department' =>array('foreignKey' => false,'conditions'=>array('Department.id=Patient.department_id' )),
    		                                             'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
		)));
		$conditionsLaboratory['LabTestPayment'] = array('create_time BETWEEN ? AND ?'=> array($from,$to));
		$conditionsLaboratory = $this->postConditions(array_merge($conditions,$conditionsLaboratory));
		$getLaboratoryTestPendingDues = $this->LabTestPayment->find("all",array('conditions' => $conditionsLaboratory, 'fields' => array('MAX(LabTestPayment.id) AS id', 'Department.name','Person.*','PatientInitial.name','Patient.form_received_on','Patient.form_completed_on', 'Patient.lookup_name', 'Patient.mobile_phone', 'Patient.admission_type', 'Patient.admission_id', 'Patient.address1', 'SUM(LabTestPayment.paid_amount) AS amount', 'LabTestPayment.patient_id','LabTestPayment.create_time'), 'group' => array('LabTestPayment.patient_id'),'order' => array('LabTestPayment.create_time')));
		$this->set('getLaboratoryTestPendingDues', $getLaboratoryTestPendingDues);
        $this->set('patientType', $getData['admission_type']);
	}
	/**
	 * doctor wise collection report
	 *
	 */

	public function admin_doctorwise_collection() {
		$this->set('title_for_layout', __('Doctor Wise Collection', true));
		$this->uses = array('DoctorProfile', 'Department', 'Consultant');
		$this->DoctorProfile->virtualFields = array('doctor_name' => 'CONCAT(Initial.name, " ", DoctorProfile.doctor_name)');
		$consultantList = $this->DoctorProfile->find('list',array('fields'=>array('id','doctor_name'),
      			'conditions'=>array('User.is_deleted'=>0, 'DoctorProfile.is_deleted'=>0,'User.location_id'=>$this->Session->read('locationid'), 'DoctorProfile.is_registrar'=>0),'order'=>array('DoctorProfile.doctor_name'),'contain' => array('User', 'Initial'), 'order' => array('DoctorProfile.doctor_name'), 'recursive' => 1));	
		$this->set('consultantList', $consultantList); 
		$this->set('externalConsultantList', $this->Consultant->getExeternalConsultant()); 
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->doctorWiseCollection($this->request->data);
			if($this->request->data['format'] == "PDF") {
				$this->render('doctorwise_collection_pdf', 'pdf');
			}
			if($this->request->data['format'] == "EXCEL") {
				$this->render('doctorwise_collection_xls','');
			}
		}
		
	}


	/**
	 * doctor wise collection query
	 *
	 */

	private function doctorWiseCollection($getData=null) {
		$this->uses = array('Patient', 'Location', 'TariffStandard','ConsultantBilling');
		// get nabh type of hospital location //
		$getNabhStatus = $this->Location->read('accreditation', $this->Session->read('locationid'));
		$from = $this->DateFormat->formatDate2STDForReport($getData['from'],Configure::read('date_format'))." 00:00:00";
		$hospitalType = $this->Session->read('hospitaltype');
		$to = $this->DateFormat->formatDate2STDForReport($getData['to'],Configure::read('date_format'))." 23:59:59";
		$this->ConsultantBilling->bindModel(array(
 								'belongsTo' => array('Patient' =>array('foreignKey' => false, 'conditions' => array('Patient.id=ConsultantBilling.patient_id')),
		                                             'DoctorProfile' =>array('foreignKey' => false, 'conditions' => array('DoctorProfile.id=ConsultantBilling.doctor_id')),
			                                         'User' =>array('foreignKey' => false, 'conditions' => array('User.id = DoctorProfile.user_id')),
		                                             'Initial' =>array('foreignKey' => false, 'conditions' => array('Initial.id = User.initial_id')),
		                                             'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
		                                             'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id')),
			                                         'Consultant' =>array('foreignKey' => false, 'conditions' => array('Consultant.id=ConsultantBilling.consultant_id')),
			                                         'InitialAlias' =>array('foreignKey' => false, 'conditions' => array('InitialAlias.id=Consultant.initial_id')),
		                                            ) 
			),false);

		$conditions['ConsultantBilling'] = array('date BETWEEN ? AND ?'=> array($from,$to));	
		if($getData['admission_type'] != "") {
			$conditions['Patient']['admission_type'] = $getData['admission_type'];
		} else {
			$conditions['Patient']['admission_type'] =  array('IPD', 'OPD');
			
		} 
		if($getData['skip_registration'] != "") { 
			$conditions['Patient']['treatment_type'] = $getData['skip_registration'];
		}
		if($getData['ipd_patient_status'] != "") { 
			$conditions['Patient']['is_discharge'] = $getData['ipd_patient_status'];
		}
		if($getData['opd_patient_status'] != "") { 
			$conditions['Patient']['is_discharge'] = $getData['opd_patient_status'];
		}
        if($getData['consultant_type'] == 1) { 
			$conditions['ConsultantBilling']['doctor_id NOT'] = 'NULL';
		}
		if($getData['consultant_type'] == 2) { 
			$conditions['ConsultantBilling']['consultant_id NOT'] = 'NULL';
		}
        if($getData['treating_consultant'] != "") { 
			$conditions['ConsultantBilling']['doctor_id'] = $getData['treating_consultant'];
		}
		if($getData['external_consultant'] != "") { 
			$conditions['ConsultantBilling']['consultant_id'] = $getData['external_consultant'];
		}

		$conditions['Patient']['location_id'] = $this->Session->read('locationid');
		$conditions['Patient']['is_deleted'] = 0;
				
		$conditionsDoctorWiseCollection = $this->postConditions($conditions);
		//print_r($conditionsDoctorWiseCollection);exit;
		$getDoctorWiseCollection = $this->ConsultantBilling->find('all', array('conditions' => $conditionsDoctorWiseCollection, 'fields' => array( 'Person.*','PatientInitial.name','Patient.form_received_on','Patient.form_completed_on', 'Patient.lookup_name', 'Patient.mobile_phone', 'Patient.admission_type','Patient.is_discharge', 'Patient.admission_id', 'Consultant.first_name','Consultant.last_name', 'InitialAlias.name', 'DoctorProfile.doctor_name', 'Initial.name', 'ConsultantBilling.date', 'ConsultantBilling.amount','ConsultantBilling.consultant_id','ConsultantBilling.doctor_id'), 'order' => array('ConsultantBilling.date')));
		
		$this->set('getDoctorWiseCollection', $getDoctorWiseCollection);
		
		
	}
	/**
	 * total concessions report
	 *
	 */

	public function admin_total_concessions() {
		$this->set('title_for_layout', __('Total Concessions', true));
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->totalConcessions($this->request->data);
			if($this->request->data['format'] == "PDF") {
				$this->render('total_concessions_pdf', 'pdf');
			}
			if($this->request->data['format'] == "EXCEL") {
				$this->render('total_concessions_xls','');
			}
		}
	}


	/**
	 * total concessions query
	 *
	 */

	private function totalConcessions($getData=null) {
		$this->uses = array('FinalBilling');
		$from = $this->DateFormat->formatDate2STDForReport($getData['from'],Configure::read('date_format'))." 00:00:00";
		$to = $this->DateFormat->formatDate2STDForReport($getData['to'],Configure::read('date_format'))." 23:59:59";

		if($getData['admission_type'] != "") {
			$conditions['Patient']['admission_type'] = $getData['admission_type'];
		} else {
			$conditions['Patient']['admission_type'] =  array('IPD', 'OPD');
			
		} 
		if($getData['treating_consultant'] != "") { 
			$conditions['Patient']['doctor_id'] = $getData['treating_consultant'];
		}
		if($getData['skip_registration'] != "") { 
			$conditions['Patient']['treatment_type'] = $getData['skip_registration'];
		}
		if($getData['ipd_patient_status'] != "") { 
			$conditions['Patient']['is_discharge'] = $getData['ipd_patient_status'];
		}
		if($getData['opd_patient_status'] != "") { 
			$conditions['Patient']['is_discharge'] = $getData['opd_patient_status'];
		}
		$conditions['Patient']['location_id'] = $this->Session->read('locationid');
		$conditions['Patient']['is_deleted'] = 0;
		// get concessions //
		$this->FinalBilling->bindModel(array('belongsTo'=>array('Patient'=>array('foreignKey'=>'patient_id'),
		'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
		                                                  'Department' =>array('foreignKey' => false,'conditions'=>array('Department.id=Patient.department_id' )),
    		                                             'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
		)));
		$conditionsBilling['FinalBilling'] = array('discharge_date BETWEEN ? AND ?'=> array($from,$to));
		$conditionsBilling = $this->postConditions(array_merge($conditions,$conditionsBilling));
		$getConcessions = $this->FinalBilling->find("all",array('conditions' => $conditionsBilling, 'fields' => array('PatientInitial.name','Person.*','Patient.form_received_on','Patient.form_completed_on','Patient.lookup_name', 'Patient.mobile_phone', 'Patient.admission_id', 'Patient.address1','Patient.admission_id','Patient.is_discharge','Patient.admission_type', 'FinalBilling.discount_rupees','FinalBilling.discharge_date', 'FinalBilling.reason_of_discharge','FinalBilling.bill_number','FinalBilling.create_time','FinalBilling.reason_for_discount','FinalBilling.total_amount')));
		$this->set('getConcessions', $getConcessions);
		$this->set('patientType', $getData['admission_type']);
	}

	/**
	 * get doctor listing with category type by xmlhttprequest
	 *
	 */
	public function getDoctorsList() {
		$this->uses = array('Consultant', 'DoctorProfile');
		$this->Consultant->virtualFields = array(
    							'full_name' => 'CONCAT(Initial.name, " ", Consultant.first_name, " ", Consultant.last_name)'
    							);
    							if($this->params['isAjax']) {
    								// 4 id for registrar only //
    								$this->set("familyknown", $this->params->query['familyknowndoctor']);
    								if($this->params->query['familyknowndoctor'] == 4) {
    									$this->set('doctorlist', $this->DoctorProfile->getRegistrar());
    									$this->layout = 'ajax';
    									$this->render('/Reports/ajaxgetdoctors');
    								} elseif(!empty($this->params->query['familyknowndoctor'])) {
    									$this->set('doctorlist', $this->Consultant->find('all', array('fields'=> array('id', 'full_name'),'conditions' => array('Consultant.is_deleted' => 0, 'Consultant.refferer_doctor_id' => $this->params->query['familyknowndoctor'], 'Consultant.location_id' => $this->Session->read('locationid')))));
    									$this->layout = 'ajax';
    									$this->render('/Reports/ajaxgetdoctors');
    								} else {
    									// this is for blank ctp //
    									$this->layout = 'ajax';
    									$this->render('/Reports/ajaxgetcashtype');
    								}
    							}
	}

	/**
	 * appointment report
	 *
	 */

	public function admin_appointment() {
		$this->uses = array('Department', 'DoctorProfile');
		$this->set('title_for_layout', __('Appointment', true));
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->appointment($this->request->data);
			if($this->request->data['format'] == "PDF") {
				$this->render('appointment_pdf', 'pdf');
			}
			if($this->request->data['format'] == "EXCEL") {
				$this->render('appointment_xls','');
			}
		} else {
			// get department list //
			$departmentList = $this->Department->find('list', array('fields' => array('Department.id', 'Department.name'), 'conditions' => array('Department.location_id' => $this->Session->read('locationid'), 'Department.is_active' => 1)));
			$this->set('departmentList', $departmentList);
			$this->set('doctorList', $this->DoctorProfile->getDoctors());
		}
	}


	/**
	 * appointment details query
	 *
	 */

	private function appointment($getData=null) {
		$this->uses = array('Appointment');
		$from = $this->DateFormat->formatDate2STDForReport($getData['from'],Configure::read('date_format'))." 00:00:00";
		$to = $this->DateFormat->formatDate2STDForReport($getData['to'],Configure::read('date_format'))." 23:59:59";

		if(!(empty($getData['age']))){
			$ageRange = explode('-',$getData['age']);
			$conditions['Patient']= array('age BETWEEN ? AND ?'=> array($ageRange[0],$ageRange[1]));
		}
		if(!empty($getData['gender'])) {
			$conditions['Patient']['sex'] = $getData['gender'];
		}

		// get appointment details //
		$this->Appointment->bindModel(array('belongsTo'=>array('Patient'=>array('foreignKey'=>false,'conditions'=>array("Appointment.patient_id=Patient.id")),
                                                                       'DoctorProfile'=>array('foreignKey'=>false,'conditions'=>array("Appointment.doctor_id=DoctorProfile.user_id")),
                                                                       'Department'=>array('foreignKey'=>false,'conditions'=>array("Appointment.department_id=Department.id")),
                                                                       'User'=>array('foreignKey'=>false,'conditions'=>array("User.id=Appointment.doctor_id")),
                                                                       'Initial'=>array('foreignKey'=>false,'conditions'=>array("Initial.id=User.initial_id")),
		    'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
		                                                  'Department' =>array('foreignKey' => false,'conditions'=>array('Department.id=Patient.department_id' )),
    		                                             'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),      
		)));
		$conditionsAppointment['Appointment'] = array('date BETWEEN ? AND ?'=> array($from,$to));
		if(!empty($getData['department'])) {
			$conditionsAppointment['Appointment']['department_id'] = $getData['department'];
		}
		if(!empty($getData['doctor'])) {
			$conditionsAppointment['Appointment']['doctor_id'] = $getData['doctor'];
		}
		if(!empty($getData['visit_type'])) {
			$conditionsAppointment['Appointment']['visit_type'] = $getData['visit_type'];
		}
		$conditionsAppointment['Appointment']['is_deleted'] = 0;
		$conditionsAppointment['Appointment']['location_id'] = $this->Session->read('locationid');
		if(isset($conditions)) {
			$conditionsAppointment = $this->postConditions(array_merge($conditions,$conditionsAppointment));
		} else {
			$conditionsAppointment = $this->postConditions($conditionsAppointment);
		}
		 
		$getAppointmentReport = $this->Appointment->find("all",array('conditions' => $conditionsAppointment, 'fields' => array('PatientInitial.name','Person.*','Patient.lookup_name', 'Patient.mobile_phone', 'Patient.admission_id', 'Patient.address1','Patient.sex','Patient.age','Patient.admission_type', 'Department.name', 'CONCAT(Initial.name, " ", DoctorProfile.doctor_name) as doctor_name','Appointment.date','Appointment.start_time','Appointment.end_time','Appointment.purpose', 'Appointment.visit_type'), 'order'=> array('Appointment.date DESC')));
		$this->set('getAppointmentReport', $getAppointmentReport);
	}

	/**
	 * get doctor listing department wise by xmlhttprequest
	 * used in admin_appointment, patient_admission_report,patient_admitted_report, patient_ot_report
	 */
	public function getDepartmentDoctorsList() {
		$this->uses = array('DoctorProfile');
		if($this->params['isAjax']) {
			if($this->params->query['deptid']) {
				$this->set('doctorlist', $this->DoctorProfile->getDoctors($this->params->query['deptid']));
				$this->layout = 'ajax';
				$this->render('/Reports/ajaxgetdepartmentdoctors');
			} else {
				// this is for blank ctp //
				$this->layout = 'ajax';
				$this->set('doctorlist','');
				$this->render('/Reports/ajaxgetdepartmentdoctors');
			}
		}

	}

	/**
	@name : admin_patient_admitted_report
	@created for: Admitted report

	**/
	public function admin_patient_admitted_report(){
		$this->uses = array('Patient','Location','Person','Consultant','User','DoctorProfile', 'Department');


		if($this->request->data){
			// pr($this->request->data);exit;
			// Collect required values in variables
			$format = $this->request->data['PatientAdmissionReport']['format'];
			$from = $this->request->data['PatientAdmissionReport']['from'];
			$to =   $this->request->data['PatientAdmissionReport']['to'];
			$sex = $this->request->data['PatientAdmissionReport']['sex'];
			$age = $this->request->data['PatientAdmissionReport']['age'];
			$patient_location = $this->request->data['PatientAdmissionReport']['patient_location'];
			$blood_group = $this->request->data['PatientAdmissionReport']['blood_group'];
			$reference_doctor = $this->request->data['PatientAdmissionReport']['reference_doctor'];
			$patient_type = 'IPD';
			$doctor_type = $this->request->data['doctor'];
			$department_type = $this->request->data['PatientAdmissionReport']['department_type'];
				
			if(isset($this->request->data['PatientAdmissionReport']['treatment_type'])){
				$treatment_type = $this->request->data['PatientAdmissionReport']['treatment_type'];
			}
			//$sponsor = $this->request->data['PatientRegistrationReport']['sponsor'];
			$record = '';
			//BOF pankaj code
			$this->Patient->bindModel(array(
 								'belongsTo' => array( 										 
													'Location' =>array('foreignKey' => 'location_id'),
													'Person'=>array('foreignKey'=>'person_id'),
													'DoctorProfile'=>array('foreignKey'=>false,'conditions'=>array('DoctorProfile.user_id=Patient.doctor_id')),
			                                        'User'=>array('foreignKey'=>false,'conditions'=>array('User.id=Patient.doctor_id')),
			                                        'Initial'=>array('foreignKey'=>false,'conditions'=>array('Initial.id=User.initial_id')),
													'Consultant'=>array('foreignKey'=>'consultant_id'),														
													'Department'=>array('foreignKey'=>'department_id'),
			
    		                                             'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
                                                                                                        'FinalBilling'=>array('foreignKey'=>false,'conditions'=>array('FinalBilling.patient_id=Patient.id'))
			)),false);
				
			if(!empty($to) && !empty($from)){
				$from = $this->DateFormat->formatDate2STDForReport($this->request->data['PatientAdmissionReport']['from'],Configure::read('date_format'))." 00:00:00";
				$to = $this->DateFormat->formatDate2STDForReport($this->request->data['PatientAdmissionReport']['to'],Configure::read('date_format'))." 23:59:59";
				// get record between two dates. Make condition
				$search_key = array('Patient.form_received_on <=' => $to, 'Patient.form_received_on >=' => $from,'Patient.is_deleted'=>0,'Patient.location_id'=>$this->Session->read('locationid'));
			}else{
				$search_key =array('Patient.location_id'=>$this->Session->read('locationid')) ;
			}
			if(!(empty($sex))){
				$search_key['Person.sex'] =  $sex;
			}
			if(!(empty($age))){
				$ageRange = explode('-',$age);
				$search_key['Person.age between ? and ?'] =  array($ageRange[0],$ageRange[1]);
			}
			if(!(empty($blood_group))){
				$search_key['Person.blood_group'] =  $blood_group;
			}
			if(!empty($patient_location)){
				$search_key['Person.city'] =  $patient_location;
			}
			if(!empty($reference_doctor)){
				$search_key['Patient.consultant_id'] =  $reference_doctor;
			}
			if(!empty($patient_type)){
				if($patient_type == 'Emergency'){
					$search_key['Patient.is_emergency'] = 1;
					$search_key['Patient.admission_type'] =  'IPD';
				} else if($patient_type == 'IPD'){
					$search_key['Patient.admission_type'] =  'IPD';
				} else if($patient_type == 'OPD'){
					if(isset($treatment_type) AND $treatment_type != ''){
						$search_key['Patient.treatment_type'] = $treatment_type;
						$search_key['Patient.admission_type'] =  'OPD';
					} else {
						$search_key['Patient.admission_type'] =  'OPD';
					}
				}
			}
				
			if(!empty($doctor_type)){
				$search_key['Patient.doctor_id'] =  $doctor_type;
			}
			if(!empty($department_type)){
				$search_key['Patient.department_id'] =  $department_type;
			}

				
			$selectedFields = '';
			// if you select fields of finalbilling table //
			$finalBillingFields = array('bill_number', 'total_amount', 'amount_paid', 'discount_rupees', 'amount_pending');
			if(!empty($this->request->data['PatientAdmissionReport']['field_id'])){
				foreach($this->request->data['PatientAdmissionReport']['field_id'] as $key=>$value){
					 
					if($value=='department_id'){
						$selectedFields .= ",Department.name";
					} elseif($value=='name_of_ip'){
						$selectedFields .= ",Person.name_of_ip";
					} elseif($value=='executive_emp_id_no'){
						$selectedFields .= ",Person.executive_emp_id_no";
					} elseif(in_array($value, $finalBillingFields)) {
						$selectedFields .= ",FinalBilling.".$this->request->data['PatientAdmissionReport']['field_id'][$key];
					} else {
						$selectedFields .= ",Patient.".$this->request->data['PatientAdmissionReport']['field_id'][$key];
					}
				}
			}
			$fields =array('PatientInitial.name,Patient.id,Patient.patient_id,Patient.lookup_name,Patient.is_emergency,Patient.admission_type,Patient.treatment_type,Person.city,Patient.form_received_on,
	    					Patient.admission_id,Patient.mobile_phone,Person.age,Person.sex,Person.blood_group,CONCAT(Initial.name," ",DoctorProfile.doctor_name) AS doctor_name,CONCAT(Consultant.first_name," ",Consultant.last_name)'.$selectedFields);
			 
				
			$record = $this->Patient->find('all',array('order'=>array('Patient.form_received_on' => 'DESC'),'fields'=>$fields,'conditions'=>$search_key));
			$this->set('selctedFields',$this->request->data['PatientAdmissionReport']['field_id']);


			//EOF pankaj code
			//pr($record);exit;
			if($format == 'PDF'){
				$this->set('reports',$record);
				$this->set(compact('fieldName'));
				$this->set(compact('patient_type'));
				$this->render('patient_admitted_pdf','pdf');
			} else {
				$this->set('reports', $record);
				$this->set(compact('fieldName'));
				$this->set(compact('patient_type'));
				$this->render('patient_admitted_excel','');
			}
		}
		//patient location
		$this->set('patient_location',$this->Person->find('list',array('fields'=>array('city','city'))));
		$this->set('refrences',$this->Consultant->getConsultant());
		// get department list //
		$departmentList = $this->Department->find('list', array('fields' => array('Department.id', 'Department.name'), 'conditions' => array('Department.location_id' => $this->Session->read('locationid'), 'Department.is_active' => 1)));
		$this->set('departmentList', $departmentList);
		$this->set('doctorList', $this->DoctorProfile->getDoctors());

	}


	/**
	@name : admin_patient_admitted_report_chart
	@created for: Admitted report

	**/
	public function admin_patient_admitted_report_chart(){

		$this->uses = array('Patient','Location','Person','Consultant','User','DoctorProfile');
		if(!empty($this->request->data)){
				
			$this->set('title_for_layout', __('Total Admissions Report Chart', true));

			$reportYear = $this->request->data['PatientAdmissionReport']['year'];
			$reference = $this->request->data['PatientAdmissionReport']['reference_doctor'];
			$patient_type = 'IPD';
			$doctor_type = $this->request->data['doctor'];
			$department_type = $this->request->data['PatientAdmissionReport']['department_type'];
			$location_id = $this->Session->read('locationid');
			$consultantName = '';
			$type = 'All';
			$reportMonth = $this->request->data['PatientAdmissionReport']['month'];
			if(!empty($reportMonth)){
				$countDays = cal_days_in_month(CAL_GREGORIAN, $reportMonth, $reportYear); // Days of the month selected
				$fromDate = $reportYear."-".$reportMonth."-01";
				$toDate = $reportYear."-".$reportMonth."-".$countDays;
			} else {
				$fromDate = $reportYear."-01-01"; // set first date of current year
				$toDate = $reportYear."-12-31"; // set last date of current year
			}
				
			// Bind Models
			$this->Patient->bindModel(array(
								'belongsTo' => array( 										 
													'Location' =>array('foreignKey' => 'location_id'),
													'Person'=>array('foreignKey'=>'person_id'),
			/*'DoctorProfile'=>array('foreignKey'=>false,'conditions'=>array('DoctorProfile.user_id=Patient.doctor_id')),*/
													'Consultant'=>array('foreignKey'=>'consultant_id'),														
													'Department'=>array('foreignKey'=>'department_id'),
			)),false);
			// This will not change the actual from date
			$setDate = $fromDate;
			// Create Y axix array as per month
			while($toDate > $setDate) {
				$yaxisArray[date("F-Y", strtotime($setDate))] = date("F", strtotime($setDate));
				$expfromdate = explode("-", $setDate);
				$setDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
				
			if($fromDate != '' AND $toDate != ''){
				$toSearch = array('Patient.form_received_on <=' => $toDate, 'Patient.form_received_on >=' => $fromDate, 'Patient.is_deleted'=>0,'Patient.location_id'=>$this->Session->read('locationid'));
			}

			if(!empty($reference)){
				$toSearch['Patient.consultant_id'] = $reference; // Condition reference doctors
			}

			if(!empty($patient_type)){
				$toSearch['Patient.admission_type'] = 'IPD';
			}
				
			if(!empty($doctor_type)){
				$toSearch['Patient.doctor_id'] = $doctor_type; // Condition reference doctors
			}
			if(!empty($department_type)){
				$toSearch['Patient.department_id'] = $department_type; // Condition reference doctors
			}
			// Collect record here
			$countRecord = $this->Patient->find('all', array('fields' => array('COUNT(*) AS recordcount', 'DATE_FORMAT(form_received_on, "%M-%Y") AS month_reports',
			 'Patient.form_received_on', 'Patient.doctor_id','Patient.admission_type','Patient.is_emergency','CONCAT(Consultant.first_name," ",Consultant.last_name)'), 
			 'conditions' => $toSearch ,'group' => array('month_reports')));
				
			//pr($countRecord);exit;

			// Set data for view as per record counted
			foreach($countRecord as $countRecordVal) {
				$filterRecordDateArray[] = $countRecordVal[0]['month_reports'];
				$filterRecordCountArray[$countRecordVal[0]['month_reports']] = $countRecordVal[0]['recordcount'];
			}

			$this->set('filterRecordDateArray', isset($filterRecordDateArray)?$filterRecordDateArray:"");
			$this->set('filterRecordCountArray', isset($filterRecordCountArray)?$filterRecordCountArray:0);
			$this->set('yaxisArray', $yaxisArray);
			$this->set(compact('countRecord'));
			$this->set(compact('reportMonth'));
			$this->set(compact('type'));

		}
	}

	/**
	 * birth/death report
	 *
	 */

	public function admin_birth_death() {
		$this->set('title_for_layout', __('Birth/Death', true));
		if ($this->request->is('post') || $this->request->is('put')) {
			if($this->request->data['format'] == "PDF") {
				if($this->request->data['reportType'] == "Death") {
					$this->death_record($this->request->data);
					$this->render('death_pdf', 'pdf');
				}
				if($this->request->data['reportType'] == "Birth") {
					$this->birth_record($this->request->data);
					$this->render('birth_pdf', 'pdf');
				}
			}
			if($this->request->data['format'] == "EXCEL") {
				if($this->request->data['reportType'] == "Death") {
					$this->death_record($this->request->data);
					$this->render('death_xls','');
				}
				if($this->request->data['reportType'] == "Birth") {
					$this->birth_record($this->request->data);
					$this->render('birth_xls','');
				}
			}
		}
	}


	/**
	 * death query
	 *
	 */

	private function death_record($getData=null) {
		$this->uses = array('DeathCertificate');
		$from = $this->DateFormat->formatDate2STDForReport($getData['from'],Configure::read('date_format'))." 00:00:00";
		$to = $this->DateFormat->formatDate2STDForReport($getData['to'],Configure::read('date_format'))." 23:59:59";
		$this->DeathCertificate->bindModel(array('belongsTo'=>array('Patient'=>array('foreignKey'=>false,'conditions'=>array("DeathCertificate.patient_id=Patient.id")),
		                                                                    'DoctorProfile'=>array('foreignKey'=>false,'conditions'=>array('DoctorProfile.user_id=Patient.doctor_id')),
			                                                                'User'=>array('foreignKey'=>false,'conditions'=>array('User.id=Patient.doctor_id')),
			                                                                'Initial'=>array('foreignKey'=>false,'conditions'=>array('Initial.id=User.initial_id')),
		          'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
		                                                  'Department' =>array('foreignKey' => false,'conditions'=>array('Department.id=Patient.department_id' )),
    		                                             'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )), 
		)));

		$conditionsDeath['DeathCertificate'] = array('expired_on BETWEEN ? AND ?'=> array($from,$to));
		$conditionsDeath['Patient'] = array('is_deleted'=> 0, 'location_id'=> $this->Session->read('locationid'));
		$conditionsDeath = $this->postConditions($conditionsDeath);
		$getDeathReport = $this->DeathCertificate->find("all",array('conditions' => $conditionsDeath, 'fields' => array('CONCAT(Initial.name, " ", DoctorProfile.doctor_name) AS doctor_name', 'Patient.lookup_name','PatientInitial.name','Person.*', 'Patient.mobile_phone', 'Patient.admission_id', 'Patient.address1','Patient.sex','Patient.age','Patient.admission_type', 'DeathCertificate.expired_on','DeathCertificate.cause_of_death','DeathCertificate.date_of_issue')));
		$this->set('getDeathReport', $getDeathReport);


	}

	/**
	 * birth query
	 *
	 */

	private function birth_record($getData=null) {
		$this->uses = array('ChildBirth');
		$from = $this->DateFormat->formatDate2STDForReport($getData['from'],Configure::read('date_format'))." 00:00:00";
		$to = $this->DateFormat->formatDate2STDForReport($getData['to'],Configure::read('date_format'))." 23:59:59";
		 
		$this->ChildBirth->bindModel(array('belongsTo'=>array('Patient'=>array('foreignKey'=>'patient_id'),
		                                                                    'User'=>array('foreignKey'=>false,'conditions'=>array('User.id=Patient.doctor_id')),
			                                                                'Initial'=>array('foreignKey'=>false,'conditions'=>array('Initial.id=User.initial_id')),
		     'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
		                                                  'Department' =>array('foreignKey' => false,'conditions'=>array('Department.id=Patient.department_id' )),
    		                                             'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )), 
		)));
		$conditionsBirth['ChildBirth'] = array('dob BETWEEN ? AND ?'=> array($from,$to));
		$conditionsBirth['Patient'] = array('is_deleted'=> 0, 'location_id'=> $this->Session->read('locationid'));
		$conditionsBirth = $this->postConditions($conditionsBirth);
		$getBirthReport = $this->ChildBirth->find("all",array('conditions' => $conditionsBirth, 'fields' => array('Patient.lookup_name','PatientInitial.name','Person.*','Patient.lookup_name', 'Patient.mobile_phone', 'Patient.admission_id', 'Patient.address1','Patient.sex','Patient.age','Patient.admission_type', 'ChildBirth.*', 'CONCAT(Initial.name, " ", User.first_name, " ", User.last_name) AS doctor_name')));
		$this->set('getBirthReport', $getBirthReport);
	}

	/**
	 * birth/death  chart report
	 *
	 */
	public function admin_birth_death_chart(){
		$this->uses = array('DeathCertificate', 'ChildBirth');
		$this->set('title_for_layout', __('Birth/Death Chart', true));
		if(!empty($this->request->data)){
			$reportYear = $this->request->data['year'];
			$reportMonth = $this->request->data['month'];
			if(!empty($reportMonth)){
				$countDays = cal_days_in_month(CAL_GREGORIAN, $reportMonth, $reportYear); // Days of the month selected
				$fromDate = $reportYear."-".$reportMonth."-01";
				$toDate = $reportYear."-".$reportMonth."-".$countDays;
			} else {
				$fromDate = $reportYear."-01-01"; // set first date of current year
				$toDate = $reportYear."-12-31"; // set last date of current year
			}
				
			// Bind Models
			$this->DeathCertificate->bindModel(array('belongsTo'=>array('Patient'=>array('foreignKey'=>false,'conditions'=>array("DeathCertificate.patient_id=Patient.id")))));
			$this->ChildBirth->bindModel(array('belongsTo'=>array('Patient'=>array('foreignKey'=>false,'conditions'=>array("ChildBirth.patient_id=Patient.id")))));
			// This will not change the actual from date
			$setDate = $fromDate;
			// Create Y axix array as per month
			while($toDate > $setDate) {
				$yaxisArray[date("F-Y", strtotime($setDate))] = date("F", strtotime($setDate));
				$expfromdate = explode("-", $setDate);
				$setDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
			}
				
				
			$toDeathSearch = array('DeathCertificate.expired_on  <=' => $toDate, 'DeathCertificate.expired_on >=' => $fromDate, 'Patient.is_deleted'=>0,'Patient.location_id'=>$this->Session->read('locationid'));
				
			// Collect record here
			$countRecord = $this->DeathCertificate->find('all', array('fields' => array('COUNT(*) AS recordcount', 'DATE_FORMAT(DeathCertificate.expired_on, "%M-%Y") AS month_reports',
			 'DeathCertificate.expired_on', 'Patient.doctor_id','Patient.admission_type','Patient.is_emergency'), 
			 'conditions' => $toDeathSearch ,'group' => array('month_reports')));
				
			// Set data for view as per record counted
			foreach($countRecord as $countRecordVal) {
				$filterRecordDateArray[] = $countRecordVal[0]['month_reports'];
				$filterRecordCountArray[$countRecordVal[0]['month_reports']] = $countRecordVal[0]['recordcount'];
			}

			$this->set('filterRecordDateArray', isset($filterRecordDateArray)?$filterRecordDateArray:"");
			$this->set('filterRecordCountArray', isset($filterRecordCountArray)?$filterRecordCountArray:0);
			$this->set('yaxisArray', $yaxisArray);
			$this->set(compact('countRecord'));
			$this->set(compact('reportMonth'));

			// for birth graph //
			$toBirthSearch = array('ChildBirth.dob  <=' => $toDate, 'ChildBirth.dob >=' => $fromDate, 'Patient.is_deleted'=>0,'Patient.location_id'=>$this->Session->read('locationid'));
			$countBirthRecord = $this->ChildBirth->find('all', array('fields' => array('COUNT(*) AS recordcount', 'DATE_FORMAT(ChildBirth.dob, "%M-%Y") AS month_reports',
			 'ChildBirth.dob', 'Patient.doctor_id','Patient.admission_type','Patient.is_emergency'), 
			 'conditions' => $toBirthSearch ,'group' => array('month_reports')));
				
				
			// Set data for view as per record counted
			foreach($countBirthRecord as $countBirthRecordVal) {
				$filterBirthRecordDateArray[] = $countBirthRecordVal[0]['month_reports'];
				$filterBirthRecordCountArray[$countBirthRecordVal[0]['month_reports']] = $countBirthRecordVal[0]['recordcount'];
			}

			$this->set('filterBirthRecordDateArray', isset($filterBirthRecordDateArray)?$filterBirthRecordDateArray:"");
			$this->set('filterBirthRecordCountArray', isset($filterBirthRecordCountArray)?$filterBirthRecordCountArray:0);
			$this->set(compact('countBirthRecord'));

		}
	}

	/**
	 * ot listing
	 *
	 */
	public function admin_ot_list() {
		$this->loadModel("OptAppointment");
		$this->set('title_for_layout', __('OT Listing', true));
		           $this->OptAppointment->unbindModel(array(
 								'belongsTo' => array('Initial')));
                    $this->OptAppointment->bindModel(array(
 								'belongsTo' => array( 		
    														
    		                                             'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
    		                                             'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id')),
														 'User' =>array('foreignKey' => false,'conditions'=>array('User.id =DoctorProfile.user_id')),
														 'Initial' =>array('foreignKey' => false,'conditions'=>array('Initial.id =User.initial_id')),
														 'InitialAlias' =>array('foreignKey' => false,'conditions'=>array('InitialAlias.id =Doctor.initial_id')),
														
    												)),false); 
		if ($this->request->is('post') || ($this->request->params['named']['report'] == "excel" || $this->request->params['named']['report'] == "print" && !empty($this->request->params['named']['fromdate']) && !empty($this->request->params['named']['todate']))) {
			if(!empty($this->request->params['named']['fromdate']) && !empty($this->request->params['named']['todate']))  {
				$stdfromdate = $this->request->params['named']['fromdate'];
				$stdtodate = $this->request->params['named']['todate'];
			} else {
				$stdfromdate = $this->DateFormat->formatDate2STDForReport($this->request->data["from"],Configure::read('date_format'))." 00:00:00";
				$stdtodate = $this->DateFormat->formatDate2STDForReport($this->request->data["to"],Configure::read('date_format'))." 23:59:59";
			}
			$data = $this->OptAppointment->find('all', array('conditions' => array('OptAppointment.procedure_complete'=> 0,'OptAppointment.location_id' => $this->Session->read('locationid'), 'OR' => array('OptAppointment.starttime BETWEEN ? AND ?' => array($stdfromdate,$stdtodate),'OptAppointment.endtime BETWEEN ? AND ?' => array($stdfromdate,$stdtodate)), 'OptAppointment.is_deleted' => 0), 'fields' => array('PatientInitial.name','Patient.lookup_name','Patient.admission_id','Patient.admission_type','Patient.form_received_on','Patient.form_completed_on','OptAppointment.starttime','OptAppointment.endtime','Opt.name','OptTable.name','Surgery.name','OptAppointment.operation_type','DoctorProfile.doctor_name','OptAppointment.anaesthesia','Initial.name','InitialAlias.name','Doctor.first_name','Doctor.middle_name','Doctor.last_name')));
			$this->set('stdfromdate', $stdfromdate);
			$this->set('stdtodate', $stdtodate);
		} else {
			$data = $this->OptAppointment->find('all', array('conditions' => array('OptAppointment.procedure_complete'=> 0, 'OptAppointment.location_id' => $this->Session->read('locationid'),'OptAppointment.starttime BETWEEN ? AND ?' => array($this->DateFormat->formatDate2STDForReport(date('Y-m-d'),Configure::read('date_format'))." 00:00:00",$this->DateFormat->formatDate2STDForReport(date('Y-m-d'),Configure::read('date_format'))." 23:59:59"), 'OptAppointment.is_deleted' => 0), 'fields' => array('PatientInitial.name','Patient.lookup_name','Patient.admission_id','Patient.admission_type','Patient.form_received_on','Patient.form_completed_on','OptAppointment.starttime','OptAppointment.endtime','Opt.name','OptTable.name','Surgery.name','OptAppointment.operation_type','DoctorProfile.doctor_name','OptAppointment.anaesthesia','Initial.name','InitialAlias.name','Doctor.first_name','Doctor.middle_name','Doctor.last_name')));
		}
		$this->set('data', $data);
		if($this->request->params['named']['report'] == "print") {
			$this->layout = false;
			$this->render('print_ot_list');
		}
		if($this->request->params['named']['report'] == "excel") {
			$this->layout = false;
			$this->render('ot_list_xls');
		}
	}
	
	/***
		this function for pharmacy Purchase report
	**/
	public function admin_purchase_report($type="purchase"){
		$this->uses = array("InventoryPurchaseDetail","InventoryPurchaseReturn","InventoryPurchaseItemDetail","PharmacyItem");
			 $this->set('title_for_layout', __('Pharmacy Report - Purchase Report', true));
			 if ($this->request->is('post')) {  
			   $from = $this->DateFormat->formatDate2STDForReport($this->request->data['PharmacyPurchase']['from'],Configure::read('date_format'))." 00:00:00";
			   $to = $this->DateFormat->formatDate2STDForReport($this->request->data['PharmacyPurchase']['to'],Configure::read('date_format'))." 23:59:59";
			   $format = $this->request->data['PharmacyPurchase']['format'];
			   if($this->request->data['PharmacyPurchase']['payment_type'] == "cash" ||  $this->request->data['PharmacyPurchase']['payment_type'] == "credit") {
			   	$payment_type = $this->request->data['PharmacyPurchase']['payment_type'];
			   } else {
			   	$payment_type = array("cash", "credit");
			   }
			   $this->set('from',$from);
			   $this->set('to',$to);
				if($this->request->data['PharmacyPurchase']['for'] == "Purchase"){
					$this->set('for',"purchase");
					$this->InventoryPurchaseDetail->bindModel(array(
						"hasMany"=>array(
							"InventoryPurchaseItemDetail"=>array("foreignKey"=>"inventory_purchase_detail_id"), 
							
						),
						"belongsTo"=>array(
							"InventorySupplier"=>array("foreignKey"=>"party_id"),
							"User"=>array("foreignKey"=>"created_by"), 
							  'Initial'=>array('foreignKey'=>false,'conditions'=>array('Initial.id=User.initial_id')),
						)

					));
					$record = $this->InventoryPurchaseDetail->find("all",array(
										"conditions"=>array("InventoryPurchaseDetail.location_id" =>$this->Session->read('locationid'),
										'InventoryPurchaseDetail.create_time <=' => $to, 'InventoryPurchaseDetail.create_time >=' => $from,
					                    'InventoryPurchaseDetail.payment_mode' => $payment_type
										),
										 
										));
				  foreach($record as $key=>$value){					
				     foreach($value['InventoryPurchaseItemDetail'] as $k=>$v){
						 $this->InventoryPurchaseItemDetail->unbindModel(array("belongsTo"=>array("InventoryPurchaseDetail")));
						 $itemdetail = $this->InventoryPurchaseItemDetail->read(null,$v['id']);
						$record[$key]['InventoryPurchaseItemDetail'][$k]['item'] = $itemdetail['PharmacyItem']['name'];
						$record[$key]['InventoryPurchaseItemDetail'][$k]['code'] = $itemdetail['PharmacyItem']['item_code'];
					  }
					} 
				}else{
					$this->set('for',"return");
					$this->InventoryPurchaseReturn->bindModel(array(
						"hasMany"=>array(
							"InventoryPurchaseReturnItem"=>array("foreignKey"=>"inventory_purchase_return_id"), 
						),
					 
						"belongsTo"=>array(
							"InventorySupplier"=>array("foreignKey"=>"party_id"),
							"User"=>array("foreignKey"=>"created_by"), 
							 'Initial'=>array('foreignKey'=>false,'conditions'=>array('Initial.id=User.initial_id')),
								
						)

					));
					$record = $this->InventoryPurchaseReturn->find("all",array(
										"conditions"=>array("InventoryPurchaseReturn.location_id" =>$this->Session->read('locationid'),
										'InventoryPurchaseReturn.create_time <=' => $to, 'InventoryPurchaseReturn.create_time >=' => $from
										) 
										 
										));   
					 foreach($record as $key=>$value){					
				     foreach($value['InventoryPurchaseReturnItem'] as $k=>$v){
						 $this->PharmacyItem->belongsTo = array();
						 $this->PharmacyItem->hasMany = array();
						 $this->PharmacyItem->hasOne = array();
						 $itemdetail = $this->PharmacyItem->read(null,$v['item_id']);
						$record[$key]['InventoryPurchaseReturnItem'][$k]['item'] = $itemdetail['PharmacyItem']['name'];
						$record[$key]['InventoryPurchaseReturnItem'][$k]['code'] = $itemdetail['PharmacyItem']['item_code'];
					  }
					} 					
				}
			  #pr($record);exit;
				$this->set('reports',$record);
				$this->layout = false;
				if($format == 'PDF'){   
					if($this->request->data['PharmacyPurchase']['for'] == "Purchase") 
						$this->render('purchase_report_pdf');
					else	 
						$this->render('purchase_return_report_pdf'); 
				} else { 
					if($this->request->data['PharmacyPurchase']['for'] == "Purchase") 
						$this->render('purchase_report_excel');
					else	 
						$this->render('purchase_reportl_return_excel');
				}
			}
			 
	}
	/***
		this function for pharmacy Sale report
	**/
	public function admin_sales_report($type="sale"){
			$this->uses = array("PharmacySalesBill","InventoryPharmacySalesReturn","PharmacyItem","PharmacySalesBillDetail","Initial");
			$this->set('title_for_layout', __('Pharmacy Report - Sale Report', true));
			if ($this->request->is('post')) { //pr($this->request->data);
			   $from = $this->DateFormat->formatDate2STDForReport($this->request->data['PharmacySale']['from'],Configure::read('date_format'))." 00:00:00";
			   $to = $this->DateFormat->formatDate2STDForReport($this->request->data['PharmacySale']['to'],Configure::read('date_format'))." 23:59:59";
			   $format = $this->request->data['PharmacySale']['format'];
			if($this->request->data['PharmacySale']['payment_type'] == "cash" ||  $this->request->data['PharmacySale']['payment_type'] == "credit") {
			   	$payment_type = $this->request->data['PharmacySale']['payment_type'];
			   } else {
			   	$payment_type = array("cash", "credit");
			   }
			   $this->set('from',$from);
			   $this->set('to',$to);
				if($this->request->data['PharmacySale']['for'] == "Sales"){
					$this->set('for',"Sale");
					 $this->PharmacySalesBill->bindModel(array(  
						"belongsTo"=>array(
 							"User"=>array("foreignKey"=>"created_by"), 
							
								
						)

					));
					$record = $this->PharmacySalesBill->find("all",array(
										"conditions"=>array("PharmacySalesBill.location_id" =>$this->Session->read('locationid'),
										'PharmacySalesBill.create_time <=' => $to, 'PharmacySalesBill.create_time >=' => $from,
					                    'PharmacySalesBill.payment_mode' => $payment_type
										),
										 
										));
										 
				  foreach($record as $key=>$value){					
				     foreach($value['PharmacySalesBillDetail'] as $k=>$v){
						 $this->PharmacySalesBillDetail->unbindModel(array("belongsTo"=>array("PharmacySalesBill")));
						 $itemdetail = $this->PharmacySalesBillDetail->read(null,$v['id']);
						$record[$key]['PharmacySalesBillDetail'][$k]['item'] = $itemdetail['PharmacyItem']['name'];
						$record[$key]['PharmacySalesBillDetail'][$k]['code'] = $itemdetail['PharmacyItem']['item_code'];
					  }
					} 
				}else{
					$this->set('for',"Sale Return");
					$this->InventoryPharmacySalesReturn->bindModel(array( 
						"belongsTo"=>array(
 							"User"=>array("foreignKey"=>"created_by"), 
							 'Initial'=>array('foreignKey'=>false,'conditions'=>array('Initial.id=User.initial_id')),
								
						)

					));
					$record = $this->InventoryPharmacySalesReturn->find("all",array(
										"conditions"=>array("InventoryPharmacySalesReturn.location_id" =>$this->Session->read('locationid'),
										'InventoryPharmacySalesReturn.create_time <=' => $to, 'InventoryPharmacySalesReturn.create_time >=' => $from
										) 
										 
										));   
					 foreach($record as $key=>$value){					
				     foreach($value['InventoryPharmacySalesReturnsDetail'] as $k=>$v){
						 $this->PharmacyItem->belongsTo = array();
						 $this->PharmacyItem->hasMany = array();
						 $this->PharmacyItem->hasOne = array();
						 $itemdetail = $this->PharmacyItem->read(null,$v['item_id']);
						$record[$key]['InventoryPharmacySalesReturnsDetail'][$k]['item'] = $itemdetail['PharmacyItem']['name'];
						$record[$key]['InventoryPharmacySalesReturnsDetail'][$k]['code'] = $itemdetail['PharmacyItem']['item_code'];
					  }
					} 					
				}
			 #  pr($record);exit;
				$this->set('reports',$record);
				$this->layout = false;
				if($format == 'PDF'){   
					if($this->request->data['PharmacySale']['for'] == "Sales") 
						$this->render('sale_report_pdf');
					else	 
						$this->render('sale_return_report_pdf'); 
				} else { 
					if($this->request->data['PharmacySale']['for'] == "Sales") 
						$this->render('sale_report_excel');
					else	 
						$this->render('sale_return_report_excel');
				}
	
			}
	
	}


	
}
?>
