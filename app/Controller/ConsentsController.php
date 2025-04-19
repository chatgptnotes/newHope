<?php
/**
 * ConsentsController file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Consents Controller
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 */

class ConsentsController extends AppController {
	
	public $name = 'Consents';
	public $uses = array('Consent','Patient','DoctorProfile');
	public $helpers = array('Html','Form', 'Js','General');
	public $components = array('RequestHandler','Email', 'Session');

	public function index($patientId=null,$admissionId=null) {
		#echo '<pre>';print_r($this->request);exit;
		if(isset($this->request->data) && !empty($this->request->data)) {
			#pr($this->request->data);exit;
			$location_id = $this->Session->read('locationid') ;
    		$userid 	 = $this->Session->read('locationid') ;
    		$this->request->data["Consent"]["location_id"] =  empty($location_id)?'1':$location_id ; 
    	 	$this->request->data["Consent"]["create_time"] = date("Y-m-d H:i:s");
            $this->request->data["Consent"]["modify_time"] = date("Y-m-d H:i:s");
            $this->request->data["Consent"]["created_by"]  = empty($userid)?'1':$userid;
            $this->request->data["Consent"]["modified_by"] = empty($userid)?'1':$userid; 
            $this->Consent->create();
            $this->Consent->save($this->request->data);	
            $this->redirect(array('action' => 'searchConsentForm', $this->request->data["Consent"]["patient_id"]));
            
        }
        $consentData = $this->Consent->find('first', array('conditions' => array('Consent.patient_id' => $admissionId)));
		if($consentData){
			$this->redirect(array('action' =>'searchConsentForm',$admissionId));
		}else{
	        $patientDetails = $this->Patient->find('first',array('conditions' =>array('id'=>$patientId,'location_id'=>$this->Session->read('locationid'))));
			#pr($patientDetails);
			$this->loadModel('Diagnosis');
			$diagnosisData = $this->Diagnosis->find('first',array('conditions'=>array('Diagnosis.patient_id'=>$patientId)));
			#$this->set('diagnosisData',$diagnosisData);
			#echo '<pre>'; print_r($diagnosisData);exit;
	        $consentArr = array('Consent' => array(
	        				'patient_name' => $patientDetails['Patient']['lookup_name'],
	        				'patient_age' => $patientDetails['Patient']['age'],
	        				'patient_sex' => $patientDetails['Patient']['sex'],
	        				'patient_id' => $patientDetails['Patient']['admission_id'],
	        				'patient_diagnosis' => $diagnosisData['Diagnosis']['final_diagnosis']
	        )); 	
	        $this->data = $consentArr;
                
                $doctorNotAnaesthesialist = $this->User->getAnaesthesistAndNone(false);
                $doctorWithAnaesthesialist = $this->User->getAnaesthesistAndNone(true);

	         $this->set('patientDetails',$patientDetails);
	         $this->set('doctorNotAnaesthesialist',$doctorNotAnaesthesialist);
                 $this->set('doctorWithAnaesthesialist',$doctorWithAnaesthesialist);
		}
        #pr($patientDetails);exit;
		$this->patient_info($patientId);
	}
	
	
	/*public function viewConsentForm($patient_id = ''){
		$consentData = $this->Consent->find('first', array('conditions' => array('Consent.patient_id' => $patient_id)));
		$this->set('data', $consentData);
		#echo '<pre>';print_r($consentData);exit;
		
	}*/
	
	public function searchConsentForm($patient_id = ''){
		#echo '<pre>';print_r($this->request['data']);exit;
		if($this->request['data']){
			$consentData = $this->Consent->find('first', array('conditions' => array('Consent.patient_id' => $this->request['data']['Consent']['patient_id_search'])));
			if($consentData != ''){
				$this->set('consentData', $consentData);	
			}else{
				$this->Session->setFlash(__('No record found.', true));
            	$this->redirect(array("controller" => "consents", "action" => "index"));
			}
			
		}else if($patient_id != ''){
			$consentData = $this->Consent->find('first', array('conditions' => array('Consent.patient_id' => $patient_id)));
			if($consentData != ''){
				$this->set('consentData', $consentData);	
			}else{
				$this->Session->setFlash(__('No record found.', true));
            	$this->redirect(array("controller" => "consents", "action" => "index"));
			}
		}
		$this->set('doctors',$this->DoctorProfile->getDoctors());
	}
	
	public function printConsentForm($patient_id = ''){
		$this->layout = false;
		if($patient_id != ''){
			$consentData = $this->Consent->find('first', array('conditions' => array('Consent.patient_id' => $patient_id)));
			if($consentData != ''){
				$this->set('consentData', $consentData);	
			}else{
				$this->Session->setFlash(__('No record found.', true));
            	$this->redirect(array("controller" => "consents", "action" => "index"));
			}
		}
		$this->set('doctors',$this->DoctorProfile->getDoctors());
	}
	
/**
 * patient specific consent 
 *
 */
	public function patient_specific_consent($patientid=null,$optId=null) {
		//$this->layout = "advance";
                $this->set('title_for_layout', __('Patient Specific Consent Form', true));
				$this->set(compact('optId')); //BOF-Mahalaxmi For map multiple surgery
                $this->patient_info($patientid); 
                $this->Consent->bindModel(array('belongsTo' => array('User' =>array('foreignKey' => false, 'conditions' => array('User.id=Consent.surgeon_name')),'Surgery' =>array('foreignKey' => false, 'conditions' => array('Surgery.id=Consent.surgery_id')),'DoctorProfile' =>array('foreignKey' => false, 'conditions' => array('DoctorProfile.user_id=Consent.anaesthetic_name')),'Initial' =>array('foreignKey' => false, 'conditions' => array('Initial.id=  User.initial_id')))));
                $this->paginate = array('limit' => Configure::read('number_of_rows'),
                'conditions' => array('Consent.patient_id' => $patientid,'Consent.opt_appointment_id' =>$optId, 'Consent.is_deleted' => 0,
                'Consent.location_id'=>$this->Session->read('locationid')));
                $data = $this->paginate('Consent');
               
                
                if(empty($data)){
                	$this->redirect(array('action'=>'add_patient_specific_consent',$patientid,$optId));
                }else{
                	 $this->set('data', isset($data)?$data:'');
                }
               
                
        }

/**
 * view patient specific consent forms
 *
 */
	public function view_patient_specific_consent($patientid = null) {
                $this->set('title_for_layout', __('Patient Specific Consent Form', true));
                $this->patient_info($patientid); 
                $this->Consent->bindModel(array('belongsTo' => array('User' =>array('foreignKey' => false, 'conditions' => array('User.id=Consent.surgeon_name')),'Surgery' =>array('foreignKey' => 'surgery_id'), 'DoctorProfile' =>array('foreignKey' => false, 'conditions' => array('DoctorProfile.user_id=Consent.anaesthetic_name')),'Doctor' =>array('foreignKey' => false, 'conditions' => array('Doctor.id=Consent.investigating_dr')),'Initial' =>array('foreignKey' => false, 'conditions' => array('Initial.id=  User.initial_id')))));
                if (!$this->params['named']['pscid']) {
			     $this->Session->setFlash(__('Invalid Patient Specific Consent Form', true));
			     $this->redirect(array("controller" => "consents", "action" => "patient_specific_consent",$patientid));
		        }
		$data  =$this->Consent->find('first', array('conditions' => array('Consent.id' => $this->params['named']['pscid'], 'Consent.location_id' => $this->Session->read('locationid')), 'fields' => array('Consent.*','DoctorProfile.doctor_name','Surgery.name', 'CONCAT(User.first_name," ", User.last_name) as userfullname', 'CONCAT(Doctor.first_name," ", Doctor.last_name) as doctorfullname'))) ;
		$this->set('patientConsentDetails', $data);
	}


/**
 * delete function of patient specific consent form
 *
 */
	public function delete_patient_specific_consent($patientid = null,$optId=null) {
        if (empty($this->params['named']['pscid'])) {
			$this->Session->setFlash(__('Invalid Id For Patient Specific Consent Form', true));
			$this->redirect(array("controller" => "consents", "action" => "patient_specific_consent",$patientid));
		}
		if (!empty($this->params['named']['pscid'])) { 
                        $this->Consent->id = $this->params['named']['pscid'];
                        $this->request->data["Consent"]["id"] = $this->params['named']['pscid'];
                        $this->request->data["Consent"]["is_deleted"] = "1";
                        $this->Consent->save($this->request->data);
                        $this->Session->setFlash(__('Patient Specific Consent Record deleted', true));
			$this->redirect(array("controller" => "consents", "action" => "patient_specific_consent", $patientid,$optId));
		}else {
                        $this->Session->setFlash(__('This patient specific consent form  is associated with other details so you can not be delete this patient specific consent form', true));
			$this->redirect(array("controller" => "consents", "action" => "patient_specific_consent", $patientid,$optId));
                }
	}
/**
 * add patient specific consent form 
 *
 */
	public function add_patient_specific_consent($patientid=null,$optId=null) {
		//$this->layout = "advance";
                $this->uses = array('User', 'Surgery');
                $this->set('title_for_layout', __('Patient Specific Consent Form', true));
				$this->set(compact('optId')); //BOF-Mahalaxmi For map multiple surgery
                $this->patient_info($patientid); 
                $doctorNotAnaesthesialist = $this->User->getAnaesthesistAndNone(false);
              
                $this->Consent->bindModel(array('belongsTo' => array('User' =>array('foreignKey' => false, 'conditions' => array('User.id=Consent.surgeon_name')),'Surgery' =>array('foreignKey' => 'surgery_id'), 'DoctorProfile' =>array('foreignKey' => false, 'conditions' => array('DoctorProfile.user_id=Consent.anaesthetic_name')),'Doctor' =>array('foreignKey' => false, 'conditions' => array('Doctor.id=Consent.investigating_dr')),'Initial' =>array('foreignKey' => false, 'conditions' => array('Initial.id=  User.initial_id')))));
                $this->request->data = $this->Consent->find('first', array('conditions' => array('Consent.id' => $this->params['named']['pscid'], 'Consent.location_id' => $this->Session->read('locationid'), 'Consent.is_deleted' => 0)));
                $this->set('patientConsentDetails', isset($patientConsentDetails)?$patientConsentDetails:'');
                $this->set('anaesthesialist',$this->User->getAnaesthesistAndNone(true));
              
                $doctorWithAnaesthesialist = $this->User->getAnaesthesistAndNone(true);
                
                $this->Surgery->bindModel(array('hasOne' => array('OptAppointment' =>array('foreignKey' => 'surgery_id'))));
                $this->set('surgeries', $this->Surgery->find('list', array('conditions' => array('Surgery.location_id' => $this->Session->read('locationid'), 'Surgery.is_deleted' => 0, 'OptAppointment.patient_id' => $patientid), 'recursive' => 1)));
	            $this->set('doctorNotAnaesthesialist',$doctorNotAnaesthesialist);
                $this->set('doctorWithAnaesthesialist',$doctorWithAnaesthesialist);
                
        }

/**
 * patient specific consent page for print 
 *
 */
	public function print_patient_specific_consent($id=null) {
                $this->Consent->bindModel(array('belongsTo' => array('User' =>array('foreignKey' => false, 'conditions' => array('User.id=Consent.surgeon_name')),
                                                                     'Surgery' =>array('foreignKey' => 'surgery_id'), 
                                                                     'DoctorProfile' =>array('foreignKey' => false, 'conditions' => array('DoctorProfile.user_id=Consent.anaesthetic_name')),
                                                                     'Doctor' =>array('foreignKey' => false, 'conditions' => array('Doctor.id=Consent.investigating_dr')),
                                                                     'Initial' =>array('foreignKey' => false, 'conditions' => array('Initial.id=  User.initial_id')),
                                                                     'Patient' =>array('foreignKey' => false, 'conditions' => array('Patient.id=  Consent.patient_id')),
                                                                     'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
    		                                                         'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
                                          )));
                $patientConsentDetails = $this->Consent->find('first', array('conditions' => array('Consent.id' => $id, 'Consent.location_id' => $this->Session->read('locationid'), 'Consent.is_deleted' => 0), 'fields' => array('PatientInitial.name','Consent.*','Patient.*','DoctorProfile.doctor_name','Surgery.name', 'CONCAT(User.first_name," ", User.last_name) as userfullname', 'CONCAT(Doctor.first_name," ", Doctor.last_name) as doctorfullname'))) ;
                $this->set('consentData', $patientConsentDetails);
                $this->layout = 'print_with_header';
        }

/**
 * save patient specific consent form
 *
 */
	public function savePatientSpecificConsent() {
		 if ($this->request->is('post') || $this->request->is('put')) {             	
            	  App::import('Vendor', 'signature_to_image'); 
            	  if(!empty($this->request->data["Consent"]["output"])) {
            	   $signImage = sigJsonToImage($this->request->data["Consent"]["output"],array('imageSize'=>array(320, 150)));
            	   $signpadfile = date('U').'.png';
            	   imagepng($signImage, WWW_ROOT.'signpad'.DS.$signpadfile);
            	   $this->request->data["Consent"]["signpad_file"] = $signpadfile;
            	  }
                  //$this->request->data["Consent"]["consent_for1"] = isset($this->request->data["Consent"]["consent_for1"])?$this->request->data["Consent"]["consent_for1"]:0;
                  //$this->request->data["Consent"]["consent_for2"] = isset($this->request->data["Consent"]["consent_for2"])?$this->request->data["Consent"]["consent_for2"]:0;
                  $this->request->data["Consent"]["terms_conditions_1"] = isset($this->request->data["Consent"]["terms_conditions_1"])?$this->request->data["Consent"]["terms_conditions_1"]:0;
                  $this->request->data["Consent"]["terms_conditions_2"] = isset($this->request->data["Consent"]["terms_conditions_2"])?$this->request->data["Consent"]["terms_conditions_2"]:0;
                  // update if anaesthesia id found //
                  if($this->request->data["Consent"]['id']) {
                      $this->Consent->id = $this->request->data["Consent"]['id'];
	                  if(!empty($this->request->data["Consent"]["output"])) {
	            	   $signImage = sigJsonToImage($this->request->data["Consent"]["output"],array('imageSize'=>array(320, 150)));
	            	   $signpadfile = date('U').'.png';
	            	   imagepng($signImage, WWW_ROOT.'signpad'.DS.$signpadfile);
	            	   $this->request->data["Consent"]["signpad_file"] = $signpadfile;
	            	  }
					   $this->request->data["Consent"]["modify_time"] = date("Y-m-d H:i:s"); 
					   $this->request->data["Consent"]["modified_by"] = $this->Session->read('userid');		         
                  }
	              $this->request->data["Consent"]["create_time"] = date("Y-m-d H:i:s");
		          $this->request->data["Consent"]["created_by"] = $this->Session->read('userid');
		        
		          $this->request->data["Consent"]["location_id"] = $this->Session->read('locationid');
                  //print_r($this->request->data);exit;
                  if($this->Consent->save($this->request->data)) {
                    $this->Session->setFlash(__('Patient Specific Consent Form Saved.', true));
                  }
	        }
                $this->redirect(array("action" => "patient_specific_consent", $this->request->data["Consent"]['patient_id'],$this->request->data["Consent"]['opt_appointment_id']));
                exit;
	}
	
        
}