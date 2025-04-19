<?php
/**
 * SurveysController file
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
class SurveysController extends AppController {

	public $name = 'Surveys';
	public $uses = array('StaffSurvey');
	public $helpers = array('Html','Form', 'Js','General','PhpExcel');
	public $components = array('RequestHandler','Email','PhpExcel');
	
/**
 * staff surveys questions
 *
 */	
	
	public function staff_surveys() {
	        $this->uses = array('User');
		$this->set('title_for_layout', __('Staff Satisfaction Survey Questionnaire', true));
                $this->User->bindModel(array(
 				'belongsTo' => array( 											 
				'Designation' =>array(
							'foreignKey'=>'designation_id'				 
 							)
 		)));
    	        $staffDetails = $this->User->find('first', array('conditions' => array('User.id' => $this->Auth->user('id')), 'fields' => array('User.full_name', 'User.dob', 'User.gender', 'Designation.name', 'User.designation_id')));
		$this->set('staffDetails', $staffDetails);
	}


	
/**
 * patient surveys questions
 *
 */	
	
	public function patient_surveys($patient_id=null) {
		$this->set('title_for_layout', __('Patient Satisfaction Survey', true));
    	$this->uses = array('Patient', 'Person','PatientSurvey'); 
		$this->Patient->bindModel(array(
 				'belongsTo' => array( 											 
				'Initial' =>array(
							'foreignKey'=>'initial_id'				 
 							)
 		))); 			 
	 	$patient_details     = $this->Patient->getPatientDetailsByID($patient_id); 	
	 	$UIDpatient_details  = $this->Person->getUIDPatientDetailsByPatientID($patient_id);
	 	$formatted_address   = $this->Patient->setAddressFormat($UIDpatient_details['Person']);
	 	$this->PatientSurvey->recursive  =-1 ;
	 	//if already entered
	 	$result = $this->PatientSurvey->find('all',array('conditions'=>array('patient_id'=>$patient_id)));
	 	$this->set('age',$UIDpatient_details['Person']['age']);
	 	//echo"<pre>";print_r($UIDpatient_details['Person']['age']);exit;
	 	foreach($result as $data){	 		
	 		$temArr['PatientSurvey']['question_id'][$data['PatientSurvey']['question_id']]  = $data['PatientSurvey']['answer'] ;
	 	}
	 	$this->data  = $temArr;
	 	 
	 	$this->set(array('address'=>$formatted_address,'patient'=>$patient_details,'patientUID'=>$UIDpatient_details['Person']['patient_uid']));	
	}

/**
 * OPD patient surveys questions
 *
 */	
	
	public function opd_patient_surveys($patient_id=null) {
		$this->set('title_for_layout', __('OPD Patient Satisfaction Survey', true));
    	        $this->uses = array('Patient', 'Person','PatientSurvey'); 
		$this->Patient->bindModel(array(
 				'belongsTo' => array( 											 
				'Initial' =>array(
							'foreignKey'=>'initial_id'				 
 							)
 		))); 			 
	 	$patient_details     = $this->Patient->getPatientDetailsByID($patient_id); 	
	 	$UIDpatient_details  = $this->Person->getUIDPatientDetailsByPatientID($patient_id); 				 			 
	 	$formatted_address   = $this->Patient->setAddressFormat($UIDpatient_details['Person']);
	 	$this->PatientSurvey->recursive  =-1 ;
	 	//if already entered
	 	$result = $this->PatientSurvey->find('all',array('conditions'=>array('patient_id'=>$patient_id)));
	 	foreach($result as $data){	 		
	 		$temArr['PatientSurvey']['question_id'][$data['PatientSurvey']['question_id']]  = $data['PatientSurvey']['answer'] ;  
	 	}
	 	$this->data  = $temArr;
	 	$this->set(array('address'=>$formatted_address,'patient'=>$patient_details,'patientUID'=>$UIDpatient_details['Person']['patient_uid']));	
	}
	
/**
 * save staff surveys questions
 *
 */	
	
	public function staffSurveySave() {
	    $this->loadModel("StaffSurvey");
		if ($this->request->is('post')) {
			$this->request->data['StaffSurvey']['create_time']=$this->DateFormat->formatDate2STD($this->request->data['StaffSurvey']['create_time'],Configure::read('date_format'));
			//echo '<pre>';print_r($this->request->data);exit;
		    $this->StaffSurvey->saveStaffSurveyQuest($this->request->data);
                    $this->Session->setFlash(__('Your Questions has been saved', true));
		    $this->redirect(array("controller" => "surveys", "action" => "staff_surveys"));
        }
	}
       
/**
 * save patient surveys questions
 *
 */	
	
	public function patientSurveySave() {
		$this->loadModel("PatientSurvey");
	    if ($this->request->is('post')) {	    	
	    		$count = $this->PatientSurvey->find('count',array('conditions'=>array('PatientSurvey.patient_id'=>$this->request->data['PatientSurvey']['patient_id'])));
	    		if($count){
	    			$this->PatientSurvey->updatePatientSurveyQuest($this->request->data);
        			 $this->Session->setFlash(__('Your Questions has been updated', true));
	    			
	    		}else{ 
        			$this->PatientSurvey->savePatientSurveyQuest($this->request->data);
	    			 $this->Session->setFlash(__('Your Questions has been saved', true));
	    		}
               
				$this->redirect(array("action" => "patient_surveys", $this->request->data['PatientSurvey']['patient_id']));
        }
	}

/**
 * save OPD patient surveys questions
 *
 */	
	
	public function opdPatientSurveySave() {
		$this->loadModel("PatientSurvey");
	    if ($this->request->is('post')) {
	    		$count = $this->PatientSurvey->find('count',array('conditions'=>array('PatientSurvey.patient_id'=>$this->request->data['PatientSurvey']['patient_id'])));
	    		if($count){
	    			$this->PatientSurvey->updatePatientSurveyQuest($this->request->data);
        			 $this->Session->setFlash(__('Your Questions has been updated', true));
	    			
	    		}else{ 
        			$this->PatientSurvey->savePatientSurveyQuest($this->request->data);
	    			 $this->Session->setFlash(__('Your Questions has been saved', true));
	    		}
               
				$this->redirect(array("action" => "opd_patient_surveys", $this->request->data['PatientSurvey']['patient_id']));
        }
	}
	
	/*
	function hope_adr_form(){
		
	}
	*/
	
	/**
	 * Camp details
	 * @param unknown_type $camp_id
	 * Pooja gupta
	 */
	function camp_survey_detail($camp_id=null){
		$this->layout='advance';
		$this->loadModel('CampDetail');
		if($this->request->data){//debug($this->request->data);exit;
			if($camp_id){
				$this->request->data['id']=$camp_id;
				$this->request->data['modified_by']=$this->Session->read('userid');
				$this->request->data['modified_time']=date('Y-m-d H:i:s');
			}else{
				$this->request->data['created_by']=$this->Session->read('userid');
				$this->request->data['created_time']=date('Y-m-d H:i:s');
			}
			$this->request->data['camp_date']=$this->DateFormat->formatDate2STD($this->request->data['camp_date'],Configure::read('date_format'));
			$this->request->data['compilation']=serialize($this->request->data['Compile']);
			if($this->CampDetail->save($this->request->data)){
				$this->Session->setFlash(__('Camp Details Saved', true));
				$this->redirect(array('action'=>'camp_list'));
			}else{
				$this->Session->setFlash(__('Please try again', true));
				$this->redirect(array('action'=>'camp_list'));
			}
		}
		
		if($camp_id){
			$conditions['CampDetail.id']=$camp_id;
			$camp=$this->CampDetail->getCampList($conditions);
			$this->set('camp',$camp);			
		}
		
		if($this->params->query['print']){
			$this->layout=false;
			$this->render('print_camp_detail');
		}
	}
	
	/**
	 * Camp participants details
	 * @param unknown_type $camp_id
	 * Pooja gupta
	 */
	function add_camp_participant($camp_id=null){		
		$this->layout='advance';
		$this->loadModel('CampParticipantsDetail');
		if($this->request->data){//debug($this->request->data);exit;			
			if($this->CampParticipantsDetail->savePatientData($this->request->data,$camp_id)){
					$this->Session->setFlash(__('Camp Details Saved', true));
					$this->redirect(array('action'=>'camp_list'));
				}else{
					$this->Session->setFlash(__('Please try again', true));
					$this->redirect(array('action'=>'camp_list'));
				}
			}
		$conditions['CampDetail.id']=$camp_id;
		$camp=$this->CampParticipantsDetail->getCampDetails($conditions);//get participant details
		if(empty($camp)){
			$this->loadModel('CampDetail');
			$parent=$this->CampDetail->getCampList($conditions);
		}
		$this->loadModel('User');
		$doctors=$this->User->getAllDoctorList($this->Session->read('locationid'));
		$this->set('doctors',$doctors);
		$this->set('parent',$parent);
		$this->set('camp',$camp);
		
		if($this->params->query['view']){
			$this->render('view_added_patients');
		}
		if($this->params->query['excel']){
			$this->layout=false;
			$this->render('excel_participant_list');
		}
	}
	
	/**
	 * Camp List
	 * Pooja gupta
	 */
	function camp_list(){
		$this->layout='advance';
		if($this->request->data){
			if($this->request->data['camp_id'])
					$conditions['CampDetail.id']=$this->request->data['camp_id'];
			if($this->request->data['date_from']){
				$dateFrom=$this->DateFormat->formatDate2STD($this->request->data['date_from'],Configure::read('date_format'));
				$dateTo=date('Y-m-d');
			}
			if($this->request->data['date_to'])
				$dateTo=$this->DateFormat->formatDate2STD($this->request->data['date_to'],Configure::read('date_format'));
			if($dateFrom){
				$conditions['DATE_FORMAT(CampDetail.camp_date,"%Y-%m-%d") between ? and ?']=array($dateFrom,$dateTo);
			}			
			
		}
		$this->loadModel('CampDetail');
		$list=$this->CampDetail->getCampList($conditions);//get list of camp 
		$this->set(array('list'=>$list,'camp_name'=>$this->request->data['camp_name'],'camp_id'=>$this->request->data['camp_id'],
						 'dateFrom'=>$this->DateFormat->formatDate2Local($dateFrom,Configure::read('date_format'),false),
				         'dateTo'=>$this->DateFormat->formatDate2Local($dateTo,Configure::read('date_format'),false)));
	}
	
	/**
	 * Function to add file numbers for patients
	 * Pooja gupta
	 */
	function patient_file_list(){
		$this->layout='advance';
		if($this->request->data){//debug($this->request->data);exit;
			if($this->request->data['file_list']['patient_id'])
				$conditions['Patient.id']=$this->request->data['file_list']['patient_id'];
			if($this->request->data['file_list']['date_from']){
				$dateFrom=$this->DateFormat->formatDate2STD($this->request->data['file_list']['date_from'],Configure::read('date_format'));
				$dateTo=date('Y-m-d');				
			}
			if($this->request->data['file_list']['date_to'])
				$dateTo=$this->DateFormat->formatDate2STD($this->request->data['file_list']['date_to'],Configure::read('date_format'));
			else
				if($dateFrom)
				$this->request->data['file_list']['date_to']=date('d/m/Y');//to set todays date in variable for view 
			if($dateFrom){
				$conditions['DATE_FORMAT(Patient.form_received_on,"%Y-%m-%d") between ? and ?']=array($dateFrom,$dateTo);
			}
				
		}
		if($conditions){
			$this->loadModel('Patient');
			$list=$this->Patient->getPatientFileList($conditions);
			$this->set(array('list'=>$list,'patient_name'=>$this->request->data['patient_name'],'patient_id'=>$this->request->data['patient_id'],
					'dateFrom'=>$this->DateFormat->formatDate2Local($dateFrom,Configure::read('date_format'),false),
					'dateTo'=>$this->DateFormat->formatDate2Local($dateTo,Configure::read('date_format'),false)));
		}		
	}
	
	/**
	 * ajax function to save file number
	 * @param unknown_type $patientId
	 * Pooja gupta
	 */
	function saveFileNumber($patientId){
		$this->loadModel('Patient');
		$this->Patient->saveFile($this->request->data['file_number'],$patientId);
		exit;
	}
	
	function investigation_form($patientId){
		$this->layout="advance_ajax";
		
		
	}
	  
}
?>