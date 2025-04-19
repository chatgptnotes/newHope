<?php
/**
 * HospitalAcquireInfectionsController file
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
class HospitalAcquireInfectionsController extends AppController {

	public $name = 'HospitalAcquireInfections';
	public $uses = array('HospitalAcquireInfection','IntrinsicRiskFactor');
	public $helpers = array('Html','Form', 'Js','DateFormat','General');
	public $components = array('RequestHandler','Email','DateFormat','CurrentWeek');
	
/**
 * hospital associated form listing
 *
 */	
	
	public function index($patient_id=null) { 
		$this->uses = array('IntrinsicRiskFactor', 'NosocomialInfection', 'SignSymptom', 'PatientExposure', 'MicroOrganism'); 
		$this->set('title_for_layout', __('Hospital Associated Infections', true));
		$this->patient_info($patient_id);
        if($this->params['pass'][3] && $this->params['pass'][2] && $this->params['pass'][1]) { 
			 $maxDate = $this->params['pass'][3]."-".$this->params['pass'][1]."-".$this->params['pass'][2]; 
			 $minDate =   date("Y-m-d", mktime(0, 0, 0, $this->params['pass'][1], $this->params['pass'][2]-2, $this->params['pass'][3])); 
			 $dateArray = array($minDate, date("Y-m-d", mktime(0, 0, 0, $this->params['pass'][1], $this->params['pass'][2]-1, $this->params['pass'][3])), $maxDate,);
	    } else {
			 $maxDate = date("Y-m-d"); 
			 $minDate =   date("Y-m-d", mktime(0, 0, 0,  date('m'), date('d')-2, date('Y'))); 
			 $dateArray = array($minDate, date("Y-m-d", mktime(0, 0, 0,  date('m'), date('d')-1, date('Y'))), $maxDate,);
		}
				
	 	
		$getIntrinsic = $this->IntrinsicRiskFactor->find('first',array('conditions'=>array('IntrinsicRiskFactor.patient_id'=>$patient_id), 'order' => array('IntrinsicRiskFactor.submit_date')));

		$getSignSymptom = $this->SignSymptom->find('all',array('conditions'=>array('SignSymptom.patient_id'=>$patient_id, 'SignSymptom.submit_date BETWEEN ? AND ?'=>array($minDate, $maxDate)), 'order' => array('SignSymptom.submit_date ASC')));
  
    	$getPatientExposure = $this->PatientExposure->find('all',array('conditions'=>array('PatientExposure.patient_id'=>$patient_id, 'PatientExposure.submit_date BETWEEN ? AND ?'=>array($minDate, $maxDate)), 'order' => array('PatientExposure.submit_date ASC')));

		 $getNosocomialInfections = $this->NosocomialInfection->find('first',array('conditions'=>array('NosocomialInfection.patient_id'=>$patient_id), 'order' => array('NosocomialInfection.submit_date')));

         $getMicroOrganism = $this->MicroOrganism->find('first',array('conditions'=>array('MicroOrganism.patient_id'=>$patient_id), 'order' => array('MicroOrganism.submit_date')));

        
        $this->set(compact('getIntrinsic', 'getSignSymptom', 'getNosocomialInfections', 'getMicroOrganism', 'getPatientExposure'));		
	 	$this->set('currentWeek',$this->get_week());
		$this->set('maxDate',$maxDate);
		$this->set('minDate',$minDate);
		$this->set('dateArray',$dateArray);
	 	

		// Set controller if the user is coming form nursing.
		if(isset($this->params['named']['sendTo'])){
			$this->set('redirectTo',$this->params['named']['sendTo']);
		}
	}
	
/*
 *
 * list of anaesthesia notes
 *
 */
	public function surgical_site_infections($patientid=null) {
		$this->loadModel('SurgicalSiteInfection');
		$this->set('title_for_layout', __('Surgical Site Infections', true));
		$this->patient_info($patientid);
		$this->SurgicalSiteInfection->bindModel(array('belongsTo' => array(
            					'Person' =>array('foreignKey'=>false, 'conditions'=> array('Person.id=Patient.person_id')),
		                        'PatientInitial' =>array('foreignKey'=>false, 'conditions'=> array('PatientInitial.id=Person.initial_id')), 
		)),false);
		$this->paginate = array(
				        'limit' => Configure::read('number_of_rows'),
				        'order' => array('SurgicalSiteInfection.id' => 'desc'),
            			'fields'=> array('PatientInitial.name','Patient.lookup_name','Patient.admission_id','Patient.admission_type','Patient.form_received_on','Patient.form_completed_on', 'SurgicalSiteInfection.*'),
            			'conditions'=>array('SurgicalSiteInfection.patient_id'=>$patientid,'SurgicalSiteInfection.location_id'=>$this->Session->read('locationid'), 'SurgicalSiteInfection.is_deleted'=>0)
		);
		$this->set('data',$this->paginate('SurgicalSiteInfection'));
	}
	
/**
 * surgical site infection listing
 *
 **/	
	public function add_ssi($patient_id=null) {
	        $this->set('title_for_layout', __('Surgical Site Infections', true));
    	    $this->uses = array('Patient', 'Person', 'SurgicalSiteInfection'); 
			$this->patient_info($patient_id);
	 	   
            if ($this->request->is('post') || $this->request->is('put')) {
                    $this->request->data['SurgicalSiteInfection']['location_id'] = $this->Session->read("locationid");
		            $this->request->data['SurgicalSiteInfection']['created_by'] = $this->Auth->user('id');
		            $this->request->data['SurgicalSiteInfection']['create_time'] = date('Y-m-d H:i:s');
		            $this->request->data['SurgicalSiteInfection']['ssi_lastcontact'] = $this->DateFormat->formatDate2STD($this->request->data["SurgicalSiteInfection"]['ssi_lastcontact'],Configure::read('date_format'));
		            $this->SurgicalSiteInfection->save($this->request->data);
                    $this->Session->setFlash(__('Your surgical site infection has been saved', true));
			$this->redirect(array("controller" => "hospital_acquire_infections", "action" => "surgical_site_infections", $this->request->data['SurgicalSiteInfection']['patient_id']));
        }
	}

/**
 * edit surgical site infection
 *
 **/	
public function edit_ssi($id = null, $patient_id=null) {
	   $this->uses = array('SurgicalSiteInfection','Patient'); 
	   $this->patient_info($patient_id);
	  
		        if ($this->request->is('post') || $this->request->is('put')) {
					    
					    $this->SurgicalSiteInfection->id = $this->request->data['SurgicalSiteInfection']['id'];
						$this->request->data['SurgicalSiteInfection']['modify_time'] = date('Y-m-d H:i:s');
                        $this->request->data['SurgicalSiteInfection']['modified_by'] = $this->Auth->user('id');
						$this->request->data['SurgicalSiteInfection']['ssi_lastcontact'] = $this->DateFormat->formatDate2STD($this->request->data["SurgicalSiteInfection"]['ssi_lastcontact'],Configure::read('date_format'));
			            if ($this->SurgicalSiteInfection->save($this->request->data)) {
				        $this->Session->setFlash(__('The surgical site infections has been updated.'));
				        $this->redirect(array('action' => 'surgical_site_infections',$this->request->data['SurgicalSiteInfection']['patient_id']));
			            } else {
			            $this->set('errors', $this->SurgicalSiteInfection->validationErrors);
				        $this->Session->setFlash(__('The surgical site infections could not be saved. Please, try again.'));
			            }
		         } else {
			            $this->request->data = $this->SurgicalSiteInfection->read(null, $id);
		         }
	}

/**
 * delete surgical site infection
 *
 **/
public function delete_ssi($id = null, $patient_id=null) {
	        $this->uses = array('SurgicalSiteInfection');
			$this->set('title_for_layout', __('Delete Surgical Site Infections', true));
			if (!$id) {
				$this->Session->setFlash(__('Invalid id for Surgical Site Infections'),'default',array('class'=>'error'));
				$this->redirect(array('action'=>'surgical_site_infections'));
			} else {
				$this->SurgicalSiteInfection->id = $id;
				$this->request->data['SurgicalSiteInfection']['id'] = $id;
				$this->request->data['SurgicalSiteInfection']['is_deleted'] = 1;
				$this->request->data['SurgicalSiteInfection']['modify_time'] = date('Y-m-d H:i:s');
                $this->request->data['SurgicalSiteInfection']['modified_by'] = $this->Auth->user('id');
				$this->SurgicalSiteInfection->save($this->request->data);
				$this->Session->setFlash(__('Surgical Site Infections Deleted Successfully'),'default',array('class'=>'message'));
				
			}
			
			$this->redirect(array('action'=>'surgical_site_infections',$patient_id));
	}



/**
 * save hospital associated  infections
 *
 */	
	public function get_week() {
		$currentDay = date('l');
		if($currentDay == 'Monday'){
			$timestampFirstDay = strtotime('monday');
		}else{
			$timestampFirstDay = strtotime('last monday');
		}
		$currentDay = $timestampFirstDay;
		$weekArray=array();
		for ($i = 0 ; $i < 7 ; $i++) {
		    array_push($weekArray, date('Y-m-d', $currentDay));
		    $currentDay += 24 * 3600;
		}
		return $weekArray;
	}
	
/**
 * save hospital associated  infections
 *
 */	
	public function add(){
		$this->uses=array('IntrinsicRiskFactor','PatientExposure','SignSymptom','NosocomialInfection','MicroOrganism');
                $checkDuplicate = $this->PatientExposure->find('count', array('conditions' => array('PatientExposure.submit_date'=>$this->DateFormat->formatDate2STD($this->request->data['IntrinsicRiskFactor']['date'],Configure::read('date_format')), 'PatientExposure.patient_id' => $this->request->data['patient_id'])));
                
                if($checkDuplicate > 0) {
			$this->Session->setFlash(__('You already have been saved today\'s hospital associated infections form', true));
                } else {
                        #pr($this->request->data);exit;
                        if(isset($this->request->data['IntrinsicRiskFactor'])){
            	               $this->request->data['IntrinsicRiskFactor']['submit_date']=$this->DateFormat->formatDate2STD($this->request->data['IntrinsicRiskFactor']['date'],Configure::read('date_format'));
				$this->IntrinsicRiskFactor->saveData($this->request->data);
			}
			if(isset($this->request->data['PatientExposure'])){
				$this->request->data['PatientExposure']['submit_date']=$this->DateFormat->formatDate2STD($this->request->data['IntrinsicRiskFactor']['date'],Configure::read('date_format'));
				$this->PatientExposure->saveData($this->request->data);
			}
			if(isset($this->request->data['SignSymptom'])){
				$this->request->data['SignSymptom']['submit_date']=$this->DateFormat->formatDate2STD($this->request->data['IntrinsicRiskFactor']['date'],Configure::read('date_format'));
				$this->SignSymptom->saveData($this->request->data);
			} 
			if(isset($this->request->data['NosocomialInfection'])){
				$this->request->data['NosocomialInfection']['submit_date']=$this->DateFormat->formatDate2STD($this->request->data['IntrinsicRiskFactor']['date'],Configure::read('date_format'));
				$this->NosocomialInfection->saveData($this->request->data);
			}
			if(isset($this->request->data['MicroOrganism'])){
				$this->request->data['MicroOrganism']['submit_date']=$this->DateFormat->formatDate2STD($this->request->data['IntrinsicRiskFactor']['date'],Configure::read('date_format'));
				$this->MicroOrganism->saveData($this->request->data);
			}
                        $this->Session->setFlash(__('Your hospital associated infections form has been saved', true));
                }
                
	        $this->redirect(array("controller" => "hospital_acquire_infections", "action" => "index", $this->request->data['patient_id']));
	}
	


/**
 * ssi view 
 *
 */
	public function view_ssi($ssi_id = null, $patient_id=null) {
                $this->uses = array('SurgicalSiteInfection', 'Patient', 'Person');
                $this->set('title_for_layout', __('Surgical Site Infection', true));
		if (!$ssi_id) {
			$this->Session->setFlash(__('Invalid Surgical Site Infection', true));
			$this->redirect(array("controller" => "hospital_acquire_infections", "action" => "surgical_site_infections", $patient_id));
		}
                $this->Patient->bindModel(array(
 				'belongsTo' => array( 											 
				'Initial' =>array(
							'foreignKey'=>'initial_id'				 
 							)
 		))); 			 
	 	$patient_details     = $this->Patient->getPatientDetailsByID($patient_id); 	
	 	$UIDpatient_details  = $this->Person->getUIDPatientDetailsByPatientID($patient_id); 				 			 
	 	$formatted_address   = $this->Patient->setAddressFormat($UIDpatient_details['Person']);
                $this->set(array('address'=>$formatted_address,'patient'=>$patient_details,'patientUID'=>$UIDpatient_details['Person']['patient_uid']));
		$this->set('ssi', $this->SurgicalSiteInfection->read(null, $ssi_id));
	}
	
/**
 * view all ssi 
 *
 */
	public function view_allssi($patient_id=null) {
                $this->uses = array('SurgicalSiteInfection', 'Patient', 'Person');
                $this->set('title_for_layout', __('List of Surgical Site Infection', true));
		if (!$patient_id) {
			$this->Session->setFlash(__('Invalid Surgical Site Infection', true));
			$this->redirect(array("controller" => "hospital_acquire_infections", "action" => "surgical_site_infections"));
		}
                $this->paginate = array(
			        'limit' => Configure::read('number_of_rows'),
			        'conditions' => array('SurgicalSiteInfection.is_deleted' => 0, 'SurgicalSiteInfection.location_id' => $this->Session->read('locationid'), 'SurgicalSiteInfection.patient_id' => $patient_id)
			    );
		$this->set('ssidata', $this->paginate('SurgicalSiteInfection'));

                // patient information //
                 $this->Patient->bindModel(array(
 				'belongsTo' => array( 											 
				'Initial' =>array(
							'foreignKey'=>'initial_id'				 
 							)
 		))); 			 
	 	$patient_details     = $this->Patient->getPatientDetailsByID($patient_id); 	
	 	$UIDpatient_details  = $this->Person->getUIDPatientDetailsByPatientID($patient_id); 				 			 
	 	$formatted_address   = $this->Patient->setAddressFormat($UIDpatient_details['Person']);
                $this->set(array('address'=>$formatted_address,'patient'=>$patient_details,'patientUID'=>$UIDpatient_details['Person']['patient_uid']));
	}

      
/**
*
* print ssi form
*
**/
    public function print_ssi($id = null){
		$this->uses = array('SurgicalSiteInfection','Patient','Person');
		$this->layout =  'print_with_header';
		$ssi = $this->SurgicalSiteInfection->find('first', array('conditions' => array('SurgicalSiteInfection.id' => $id)));
		$this->patient_info($ssi['SurgicalSiteInfection']['patient_id']);
		$this->set('title', __('Surgical Site Infections', true));
		$this->set(array('ssi'=>$ssi));

	}

/**
*
* print hai form
*
**/
    public function print_hai($patient_id = null){
		$this->uses = array('Patient', 'Person','IntrinsicRiskFactor', 'NosocomialInfection', 'SignSymptom', 'PatientExposure', 'MicroOrganism'); 
		$this->layout =  'print_with_header';
		$this->patient_info($patient_id);
		$this->set('title', __('Print Hospital Associated Infections', true));
		
		if($this->params['pass'][3] && $this->params['pass'][2] && $this->params['pass'][1]) { 
			 $maxDate = $this->params['pass'][3]."-".$this->params['pass'][2]."-".$this->params['pass'][1]; 
			 $minDate =   date("Y-m-d", mktime(0, 0, 0, $this->params['pass'][2], $this->params['pass'][1]-2, $this->params['pass'][3])); 
			 $dateArray = array($minDate, date("Y-m-d", mktime(0, 0, 0, $this->params['pass'][2], $this->params['pass'][1]-1, $this->params['pass'][3])), $maxDate,);
	    } else {
			 $maxDate = date("Y-m-d"); 
			 $minDate =   date("Y-m-d", mktime(0, 0, 0,  date('m'), date('d')-2, date('Y'))); 
			 $dateArray = array($minDate, date("Y-m-d", mktime(0, 0, 0,  date('m'), date('d')-1, date('Y'))), $maxDate,);
		}
				
	 	$this->patient_info($patient_id); 
		$getIntrinsic = $this->IntrinsicRiskFactor->find('first',array('conditions'=>array('IntrinsicRiskFactor.patient_id'=>$patient_id), 'order' => array('IntrinsicRiskFactor.submit_date')));

		$getSignSymptom = $this->SignSymptom->find('all',array('conditions'=>array('SignSymptom.patient_id'=>$patient_id, 'SignSymptom.submit_date BETWEEN ? AND ?'=>array($minDate, $maxDate)), 'order' => array('SignSymptom.submit_date ASC')));
  
    	$getPatientExposure = $this->PatientExposure->find('all',array('conditions'=>array('PatientExposure.patient_id'=>$patient_id, 'PatientExposure.submit_date BETWEEN ? AND ?'=>array($minDate, $maxDate)), 'order' => array('PatientExposure.submit_date ASC')));

		 $getNosocomialInfections = $this->NosocomialInfection->find('first',array('conditions'=>array('NosocomialInfection.patient_id'=>$patient_id), 'order' => array('NosocomialInfection.submit_date')));

         $getMicroOrganism = $this->MicroOrganism->find('first',array('conditions'=>array('MicroOrganism.patient_id'=>$patient_id), 'order' => array('MicroOrganism.submit_date')));

        
        $this->set(compact('getIntrinsic', 'getSignSymptom', 'getNosocomialInfections', 'getMicroOrganism', 'getPatientExposure'));		
	 	$this->set('currentWeek',$this->get_week());
		$this->set('maxDate',$maxDate);
		$this->set('minDate',$minDate);
		$this->set('dateArray',$dateArray);
	 	

	}

/**
 * edit intrinsic risk factor
 *
 **/	
public function edit_intrinsic_risk_factor($patient_id=null) { 
	   $this->uses = array('IntrinsicRiskFactor','Patient'); 
	            if ($this->request->is('post') || $this->request->is('put')) {
					    $maxDate = explode("-", $this->request->data['IntrinsicRiskFactor']['submit_date']);
					    $this->IntrinsicRiskFactor->id = $this->request->data['IntrinsicRiskFactor']['id'];
						$this->request->data['IntrinsicRiskFactor']['modify_time'] = date('Y-m-d H:i:s');
                        $this->request->data['IntrinsicRiskFactor']['modified_by'] = $this->Auth->user('id');
			            if ($this->IntrinsicRiskFactor->save($this->request->data)) {
				          $this->Session->setFlash(__('The intrinsic risk factors has been updated.'));
				        } else {
			              $this->set('errors', $this->IntrinsicRiskFactor->validationErrors);
				          $this->Session->setFlash(__('The intrinsic risk factors could not be saved. Please, try again.'));
			            }
		         } 
		         
		$this->redirect(array('action' => 'index',$patient_id, $maxDate[1], $maxDate[2], $maxDate[0]));
	}

/**
 * edit patient exposure
 *
 **/	
public function edit_patient_exposure($patient_id=null) { 
	   $this->uses = array('PatientExposure','Patient'); 
	    $minDate = $this->request->data['PatientExposure1']['min_date'];
		$maxDate = $this->request->data['PatientExposure1']['max_date'];
		 
	            if ($this->request->is('post') || $this->request->is('put')) {

					while($minDate <= $maxDate) {
					   $i++;
					   $this->request->data['PatientExposure'] = null;
					   $this->PatientExposure->id = $this->request->data['PatientExposure1']['id'][$minDate];
                       $this->request->data['PatientExposure']['id'] = $this->request->data['PatientExposure1']['id'][$minDate];
				       $this->request->data['PatientExposure']['surgical_procedure'] = $this->request->data['PatientExposure1']['surgical_procedure'][$minDate];
					   $this->request->data['PatientExposure']['urinary_catheter'] = $this->request->data['PatientExposure1']['urinary_catheter'][$minDate];
					   $this->request->data['PatientExposure']['mechanical_ventilation'] = $this->request->data['PatientExposure1']['mechanical_ventilation'][$minDate];
					   $this->request->data['PatientExposure']['central_line'] = $this->request->data['PatientExposure1']['central_line'][$minDate];
					   $this->request->data['PatientExposure']['peripheral_line'] = $this->request->data['PatientExposure1']['peripheral_line'][$minDate];
					   $this->request->data['PatientExposure']['patient_id'] = $this->request->data['PatientExposure1']['patient_id'];
					   $this->request->data['PatientExposure']['location_id'] = $this->Session->read('locationid');
					   $this->request->data['PatientExposure']['submit_date'] = $minDate;
					   if($this->request->data['PatientExposure1']['id'][$minDate]) {
					      $this->request->data['PatientExposure']['modify_time'] = date('Y-m-d H:i:s');
                          $this->request->data['PatientExposure']['modified_by'] = $this->Auth->user('id');
					   } else {
						  $this->request->data['PatientExposure']['create_time'] = date('Y-m-d H:i:s');
                          $this->request->data['PatientExposure']['created_by'] = $this->Auth->user('id');
					   }
					   
					   if ($this->PatientExposure->save($this->request->data['PatientExposure'])) {
				          $this->Session->setFlash(__('The patient exposure has been updated.'));
				       } else {
			              $this->set('errors', $this->PatientExposure->validationErrors);
				          $this->Session->setFlash(__('The patient exposure could not be saved. Please, try again.'));
			           }
                       $this->PatientExposure->id = false;
					   $minExpDate = explode("-", $minDate);
					  
				        $minDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $minExpDate[1], $minExpDate[2]+1, $minExpDate[0]))));
					   
					   
			         }
					 $minDate = explode("-", $minDate);
					 $minDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $minDate[1], $minDate[2]-1, $minDate[0]))));
					    
		         } 
		
		$minDate = explode("-", $minDate);
		$this->redirect(array('action' => 'index',$patient_id, $minDate[1], $minDate[2], $minDate[0]));
	}


/**
 * edit sign symptom
 *
 **/	
public function edit_sign_symptom($patient_id=null) { 
	   $this->uses = array('SignSymptom','Patient'); 
	    $minDate = $this->request->data['SignSymptom1']['min_date'];
		$maxDate = $this->request->data['SignSymptom1']['max_date'];
		 
	            if ($this->request->is('post') || $this->request->is('put')) {

					while($minDate <= $maxDate) {
					   $i++;
					   $this->request->data['SignSymptom'] = null;
					   $this->SignSymptom->id = $this->request->data['SignSymptom1']['id'][$minDate];
                       $this->request->data['SignSymptom']['id'] = $this->request->data['SignSymptom1']['id'][$minDate];
				       $this->request->data['SignSymptom']['fever'] = $this->request->data['SignSymptom1']['fever'][$minDate];
					   $this->request->data['SignSymptom']['chills'] = $this->request->data['SignSymptom1']['chills'][$minDate];
					   $this->request->data['SignSymptom']['local_pain'] = $this->request->data['SignSymptom1']['local_pain'][$minDate];
					   $this->request->data['SignSymptom']['swelling'] = $this->request->data['SignSymptom1']['swelling'][$minDate];
					   $this->request->data['SignSymptom']['redness'] = $this->request->data['SignSymptom1']['redness'][$minDate];
					   $this->request->data['SignSymptom']['pus_discharge'] = $this->request->data['SignSymptom1']['pus_discharge'][$minDate];
					   $this->request->data['SignSymptom']['urinary_frequency'] = $this->request->data['SignSymptom1']['urinary_frequency'][$minDate];
					   $this->request->data['SignSymptom']['respiratory_secretion'] = $this->request->data['SignSymptom1']['respiratory_secretion'][$minDate];
					   $this->request->data['SignSymptom']['dysuria'] = $this->request->data['SignSymptom1']['dysuria'][$minDate];
					   $this->request->data['SignSymptom']['suprapubic_tenderness'] = $this->request->data['SignSymptom1']['suprapubic_tenderness'][$minDate];
					   $this->request->data['SignSymptom']['oliguria'] = $this->request->data['SignSymptom1']['oliguria'][$minDate];
					   $this->request->data['SignSymptom']['pyuria'] = $this->request->data['SignSymptom1']['pyuria'][$minDate];
					   $this->request->data['SignSymptom']['cough'] = $this->request->data['SignSymptom1']['cough'][$minDate];
					   $this->request->data['SignSymptom']['blood_clot'] = $this->request->data['SignSymptom1']['blood_clot'][$minDate];
					   $this->request->data['SignSymptom']['other'] = $this->request->data['SignSymptom1']['other'][$minDate];
					   $this->request->data['SignSymptom']['patient_id'] = $this->request->data['SignSymptom1']['patient_id'];
					   $this->request->data['SignSymptom']['location_id'] = $this->Session->read('locationid');
					   $this->request->data['SignSymptom']['submit_date'] = $minDate;
					   if($this->request->data['SignSymptom1']['id'][$minDate]) {
					     $this->request->data['SignSymptom']['modify_time'] = date('Y-m-d H:i:s');
                         $this->request->data['SignSymptom']['modified_by'] = $this->Auth->user('id');
					   } else {
						 $this->request->data['SignSymptom']['create_time'] = date('Y-m-d H:i:s');
                         $this->request->data['SignSymptom']['created_by'] = $this->Auth->user('id');
					   }
					   
					   if ($this->SignSymptom->save($this->request->data['SignSymptom'])) {
				          $this->Session->setFlash(__('The sign symptom has been updated.'));
				       } else {
			              $this->set('errors', $this->SignSymptom->validationErrors);
				          $this->Session->setFlash(__('The sign symptom could not be saved. Please, try again.'));
			           }
                       $this->SignSymptom->id = false;
					   $minExpDate = explode("-", $minDate);
					  
				        $minDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $minExpDate[1], $minExpDate[2]+1, $minExpDate[0]))));
					   
					   
			         }
					 $minDate = explode("-", $minDate);
					 $minDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $minDate[1], $minDate[2]-1, $minDate[0]))));
					    
		         } 
		
		$minDate = explode("-", $minDate);
		$this->redirect(array('action' => 'index',$patient_id, $minDate[1], $minDate[2], $minDate[0]));
	}

/**
 * edit nosocomial infections
 *
 **/	
public function edit_nosocomial_infections($patient_id=null, $day=null, $month=null, $year=null) {
	   $this->uses = array('NosocomialInfection','Patient'); 
	            if ($this->request->is('post') || $this->request->is('put')) {
					  $maxDate = explode("-", $this->request->data['NosocomialInfection']['submit_date']);
					    $this->NosocomialInfection->id = $this->request->data['NosocomialInfection']['id'];
						$this->request->data['NosocomialInfection']['modify_time'] = date('Y-m-d H:i:s');
                        $this->request->data['NosocomialInfection']['modified_by'] = $this->Auth->user('id');
                        $this->request->data['NosocomialInfection']['location_id'] = $this->Session->read('locationid');
			            if ($this->NosocomialInfection->save($this->request->data)) {
				          $this->Session->setFlash(__('The nosocomial infections has been updated.'));
				        } else {
			              $this->set('errors', $this->NosocomialInfection->validationErrors);
				          $this->Session->setFlash(__('The nosocomial infections could not be saved. Please, try again.'));
			            }
		         } 
		$this->redirect(array('action' => 'index',$patient_id, $maxDate[1], $maxDate[2], $maxDate[0] ));
	}

/**
 * edit micro organism
 *
 **/	
public function edit_micro_organism($patient_id=null) { 
	   $this->uses = array('MicroOrganism','Patient'); 
	            $maxDate = explode("-", $this->request->data['MicroOrganism']['submit_date']);
	            if ($this->request->is('post') || $this->request->is('put')) {
					    
					    $this->MicroOrganism->id = $this->request->data['MicroOrganism']['id'];
						$this->request->data['MicroOrganism']['modify_time'] = date('Y-m-d H:i:s');
                        $this->request->data['MicroOrganism']['modified_by'] = $this->Auth->user('id');
			            if ($this->MicroOrganism->save($this->request->data)) {
				          $this->Session->setFlash(__('The micro organism has been updated.'));
				        } else {
			              $this->set('errors', $this->MicroOrganism->validationErrors);
				          $this->Session->setFlash(__('The micro organism could not be saved. Please, try again.'));
			            }
		         } 
		$this->redirect(array('action' => 'index',$patient_id, $maxDate[1], $maxDate[2], $maxDate[0] ));
	}
}
?>