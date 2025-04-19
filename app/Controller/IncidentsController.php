<?php
/**
 * Incidents Controller
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Incidents
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 */

class IncidentsController extends AppController {

	public $name = 'Incidents';
	
	public $helpers = array('DateFormat','Navigation','General');
	
	public function add($id=null){
		$this->uses = array('Person','Patient','IncidentType');
		$this->patient_info($id);
		if($this->request->data){
			#pr($this->request->data);exit;
			if(!empty($this->request->data['Incident']['op_visit_date'])){
				$this->request->data['Incident']['op_visit_date'] = $this->DateFormat->formatDate2STD($this->request->data['Incident']['op_visit_date'],Configure::read('date_format'));
			}
	        if(!empty($this->request->data['Incident']['incident_date'])){
				$splitDate = explode(' ',$this->request->data['Incident']['incident_date']);
				$this->request->data['Incident']['incident_date'] = $this->DateFormat->formatDate2STD($this->request->data['Incident']['incident_date'],Configure::read('date_format'));
			}
			
			if(!empty($this->request->data['Incident']['notified_date'])){
				$last_split_date_time = explode(' ',$this->request->data['Incident']['notified_date']);
				$this->request->data['Incident']['notified_date'] = $this->DateFormat->formatDate2STD($this->request->data['Incident']['notified_date'],Configure::read('date_format'));
			}
			$this->request->data['Incident']['notified_time'] = $last_split_date_time[1];
			$this->request->data['Incident']['incident_time'] = $splitDate[1];
			$this->request->data['Incident']['location_id'] = $this->Session->read('locationid');
			$this->request->data['Incident']['created_by'] = $this->Session->read('userid');
			$this->request->data['Incident']['create_time'] = date('Y-m-d H:i:s');
			$this->request->data['Incident']['patient_id'] = $id;
			if(!isset($this->request->data['Incident']['witness_involved'])){
				$this->request->data['Incident']['witness_involved']='';
			}
			if(!isset($this->request->data['Incident']['report_by_patient'])){
				$this->request->data['Incident']['report_by_patient']='';
			}
			if(!isset($this->request->data['Incident']['report_by_family'])){
				$this->request->data['Incident']['report_by_family']='';
			}
			if(!isset($this->request->data['Incident']['report_by_staff'])){
				$this->request->data['Incident']['report_by_staff']='';
			}
			if(!isset($this->request->data['Incident']['assetment_after_incident'])){
				$this->request->data['Incident']['assetment_after_incident']='';
			}
			if(!isset($this->request->data['Incident']['review_of_record'])){
				$this->request->data['Incident']['review_of_record']='';
			}
			
			
			//pr($last_split_date_time);exit;
			if($this->Incident->save($this->request->data['Incident'])){
				$this->Session->setFlash(__('Record saved successfully', true));
				$this->redirect(array("action" => "add",$id));
			}else{
				$this->Session->setFlash(__('Please try again', true));
				$this->redirect(array("action" => "add",$id));
			}
			//$id = $this->request->data['Incident']['patient_id'];
		}
		if($id!=''){
			$incidentData = $this->Incident->find('first',array('conditions'=>array('patient_id'=>$id,'location_id'=>$this->Session->read('locationid')))); 
			//if($incidentData['Incident']['patient_id']!=''){#echo 'here';exit;
				$this->Patient->bindModel(array(
 								'belongsTo' => array( 											 
								'Initial' =>array( 'foreignKey'=>'initial_id'),
    							'Consultant' =>array('foreignKey'=>'consultant_treatment')
 						))); 
				$patient_details  = $this->Patient->getPatientDetailsByID($id); 	
 				$UIDpatient_details  = $this->Person->getUIDPatientDetailsByPatientID($id); 
 				$this->set('patient_details',$patient_details);
 				$this->set('patient_uiddetails',$UIDpatient_details);
			//}
			 
			$this->data=$incidentData;	
			//retrive incident data 
			$incidentType = $this->IncidentType->find('list',array('fields'=>array('name'),'conditions'=>array('location_id'=>$this->Session->read('locationid'))));
			$this->set('incidentType',$incidentType);
			//$this->set('patient_id',$id);
		}
			
						 			 
 		#pr($UIDpatient_details);exit;	
		
	}
	
	public function printForm($id=null){
		#echo $id;exit;
		$this->uses = array('Incident','Patient','Person');
		 $this->layout  = 'print';
		if(!empty($id)){
			$data = $this->Incident->find('first',array('conditions'=>array('patient_id'=>$id,'location_id'=>$this->Session->read('locationid')))); 
			$patient_name = $this->Patient->field('lookup_name',array('Patient.id'=>$id));
			$patient_uid = $this->Patient->field('patient_id',array('Patient.id'=>$id)); // UID of the patient	
			$UIDpatient_details  = $this->Person->getUIDPatientDetailsByPatientID($id);  //	Details of the patient			 			 
	 		$formatted_address   = $this->Patient->setAddressFormat($UIDpatient_details['Person']); // Formatted address for patient
			
			$this->set('title', __('INCIDENT REPORTING', true)); // THis is the title for the printout
			$this->set(compact('formatted_address'));
			$this->set(compact('patient_uid'));
			$this->set('patient',$this->Patient->find('first',array('conditions'=>array('Patient.id'=>$id,'Patient.location_id'=>$this->Session->read('locationid')))));
			$this->set(compact('patient_name'));
			$this->set(compact('data'));
			$this->set('patient_id',$id);
		}		
	}
	
	function admin_index(){
		$this->uses = array('IncidentType');
		$this->set('title_for_layout', __('Manage Incident Types', true));
		$this->paginate = array(
	        'limit' => Configure::read('number_of_rows'),
	        'order' => array(
	            'IncidentType.name' => 'asc'
	        ),
	        'conditions'=>array('IncidentType.location_id'=>$this->Session->read('locationid'))
    	);
    	
        $data = $this->paginate('IncidentType'); 
       
        $this->set('data', $data); 
	}
	
	function admin_add($type_id=null){
		$this->uses = array('IncidentType');
		
		$this->set('title_for_layout', __('Add Incident Type', true));
		 
		if(!empty($this->request->data["IncidentType"])){
			
                        $this->request->data["IncidentType"]["create_time"] = date("Y-m-d H:i:s");
                        $this->request->data["IncidentType"]["modify_time"] = date("Y-m-d H:i:s");
                        $this->request->data["IncidentType"]["created_by"] = $this->Session->read('userid');
                        $this->request->data["IncidentType"]["modified_by"] = $this->Session->read('userid'); 
                        $this->request->data["IncidentType"]["location_id"] = $this->Session->read('locationid');
                         
                        $this->IncidentType->create();
                        $this->IncidentType->save($this->request->data);
	
						$errors = $this->IncidentType->invalidFields();
	                    if(!empty($errors)) {
	                           $this->set("errors", $errors);
	                    } else {
	                           $this->Session->setFlash(__('Incident Type has been added successfully'),'default',array('class'=>'message'));
	  	 		   			   $this->redirect(array("action" => "index", "admin" => true));
	                    
	            		}
		}
		if($type_id){
			$result = $this->IncidentType->read('',$type_id);	 
			$this->data = $result;
			
		}
		 
	}
	
	function admin_delete($type_id=null){ 
		$this->uses = array('IncidentType');
			if (!$type_id) {
				$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
				$this->redirect(array('action'=>'index','admin'=>true));
			}
			if ($this->IncidentType->delete($type_id)) {
				$this->Session->setFlash(__('Incident Type successfully deleted'),'default',array('class'=>'message'));
				$this->redirect(array('action'=>'index','admin'=>true));
			}
	}
}