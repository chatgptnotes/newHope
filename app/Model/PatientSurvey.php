<?php
/**
 * PatientSurveyModel file
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
class PatientSurvey extends AppModel {

	public $name = 'PatientSurvey';
		
/**
 * association with patients table.
 *
 */
  public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    } 
	public $belongsTo = array('Patient' => array('className'    => 'Patient',
                                                  'foreignKey'    => 'patient_id'
                                                 )
                                  );
    
/**
 * save patient survey
 *
 */	
        public function savePatientSurveyQuest($postData) {
                           $countQuest = 0;
                           //categorised questions //
                           $cleanliness = array(1, 2); 
                           $service = array(3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
                           $satisfaction = array(13, 14, 15, 16, 17);
                           $recommendation = array(18, 19); 
						   for($i=0; $i<count($postData['PatientSurvey']['question_id']); $i++) {
						     $countQuest++; 
                                                     if($postData['PatientSurvey']['patient_type'] == "OPD") { 
							if(in_array($countQuest, $cleanliness)) { 
                                                           $this->data['PatientSurvey']['survey_category'] = 'cleanliness';
							}
							if(in_array($countQuest, $service)) {
							   $this->data['PatientSurvey']['survey_category'] = 'service';
							}
							if(in_array($countQuest, $satisfaction)) {
							   $this->data['PatientSurvey']['survey_category'] = 'satisfaction';
							}
							if(in_array($countQuest, $recommendation)) {
							   $this->data['PatientSurvey']['survey_category'] = 'recommendation';
							}
                                                     } 
						         $this->data['PatientSurvey']['question_id'] = $countQuest;
							 $this->data['PatientSurvey']['location_id'] = AuthComponent::user('location_id');
							 $this->data['PatientSurvey']['answer'] = $postData['PatientSurvey']['question_id'][$countQuest];
							 $this->data['PatientSurvey']['patient_id'] = $postData['PatientSurvey']['patient_id'];
                                                         $this->data['PatientSurvey']['patient_type'] = $postData['PatientSurvey']['patient_type'];
                                                         $this->data['PatientSurvey']['create_time'] = date('Y-m-d H:i:s');
							 Classregistry::init('PatientSurvey')->save($this->data);
							 Classregistry::init('PatientSurvey')->id = false;
						   }
          	return true;
                
        }
        
 		public function updatePatientSurveyQuest($postData) {
            $countQuest = 0;
                   $this->recursive =-1 ;        
		   for($i=0; $i<count($postData['PatientSurvey']['question_id']); $i++) {
				     $countQuest++;				     
					 $this->data['PatientSurvey']['location_id'] = AuthComponent::user('location_id');
					 $this->data['PatientSurvey']['answer'] = "'".$postData['PatientSurvey']['question_id'][$countQuest]."'";					 
					 $this->data['PatientSurvey']['modify_time'] = "'".date('Y-m-d H:i:s')."'";					 
					 $this->updateAll($this->data['PatientSurvey'], array('PatientSurvey.question_id'=>$countQuest,'PatientSurvey.patient_id'=>$postData['PatientSurvey']['patient_id']));
					 $this->id = '';
		   }
          	return true;
                
        }
}
?>