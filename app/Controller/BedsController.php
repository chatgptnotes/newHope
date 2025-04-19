<?php
/**
 * WardsController file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Wards Controller
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 */

class BedsController extends AppController {
	//
	public $name = 'Beds';
	public $uses = array('Bed');
	public $helpers = array('Html','Form', 'Js');
	public $components = array('RequestHandler','Email', 'Session'); 
	
	function index($id=null, $wardid=null){
		$this->uses= array('Ward','Patient','Room');
		$data = $this->Room->find('first', array('conditions' => array('Room.id' => $id,'location_id' => $this->Session->read('locationid'))));
		$this->set('data', $data);
		$patientsData = $this->Patient->find('all', array('fields'=>array('Patient.id,Patient.room_id,Patient.lookup_name,Patient.admission_id,
				Patient.age,Patient.admission_type,Patient.bed_id,Patient.ward_id'),'conditions' => array('Patient.room_id' => $id,'admission_type'=>"IPD",
						 'location_id' => $this->Session->read('locationid'),'is_deleted'=>0,'is_discharge'=>0)));
		#pr($patientsData);exit;
		$this->set('patientsData', $patientsData);
        $this->set('wardid', $wardid);
	/*	$waitingList = $this->Patient->find('all', array('fields'=>array('Patient.full_name,Patient.age,Patient.admission_type'),'conditions' => array('Patient.ward_id' => $id, 'Patient.bed_id' => 0,'admission_type'=>"IPD")));
		$this->set('waitingList', $waitingList);*/
		#$this->set('wardId', $wardId);
		#echo '<pre>';print_r($waitingList);exit;
	}
	
	function admin_add($patientId,$wardId,$bedId){
		if (!empty($this->data)) {
			#echo '????';exit;
		}
	}
	
	//function to return formatted the complete address
    /* @params : array of patient details
     * 
     * */ 
 	public function setAddressFormat($patient_details=array()){
		 	$format = '';
 	  
 	 		if(!empty($patient_details['plot_no']))
 	 			$format .= $patient_details['plot_no'].","; 	 
 	 		if(!empty($patient_details['house_no']))
 	 			$format .= $patient_details['address2'].","; 	
 	 		if(!empty($patient_details['landmark']))
 	 			$format .= $patient_details['landmark'].",<br/>"; 	 	 
 	 		if(!empty($patient_details['city']))
 	 			$format .= $patient_details['city'].",";
 	 		if(!empty($patient_details['taluka']))
 	 			$format .= $patient_details['taluka'].",<br/>";
 	 		if(!empty($patient_details['district']))
 	 			$format .= $patient_details['district'].",<br/>";
 	 		if(!empty($patient_details['pin_code']))
 	 			$format .= "P.O.Box  ".$patient_details['pin_code'].",<br/>";
 	 		 
 	 		
 	 		return $format ;
	}   
	
	function view_waiting_list($patientId,$roomId,$bedId){
		#echo '<pre>';print_r($this->request->params);exit;
		$this->layout = false;
		$this->uses= array('Ward','Patient','Person','Room');
		if(!empty($patientId)){    		    	 
    		$this->Patient->bindModel(array(
 								'belongsTo' => array( 											 
								'Initial' =>array(
											'foreignKey'=>'initial_id'				 
 											)
 						))); 			 
 			$UIDpatient_details  = $this->Person->getUIDPatientDetailsByPatientID($patientId); 				 			 
 			$formatted_address = $this->setAddressFormat($UIDpatient_details['Person']);
 			$patient_details  = $this->Patient->getPatientDetailsByID($patientId);
 			$this->set(array('address'=>$formatted_address,'patient'=>$patient_details,'id'=>$patientId));   
 			
			$data = $this->Room->find('first', array('conditions' => array('Room.id' => $roomId)));
			$this->set('data', $data);
			$patientsData = $this->Patient->find('all', array('fields'=>array('Patient.id,Patient.lookup_name,Patient.age,Patient.admission_type,
																			   Patient.bed_id,Patient.ward_id,Patient.room_id,Patient.admission_id'),
															  'conditions' => array('Patient.room_id' => $roomId,'location_id' => $this->Session->read('locationid'),'Patient.is_deleted'=>0)));
			$this->set('patientsData', $patientsData);
		#echo '<pre>';print_r($patientsData);exit;
    	}else{
    		$this->redirect(array("controller" => "patients", "action" => "index"));
    	}
	}
	
	function assignBed(){
		//$this->autoRender =false ;
		$this->uses= array('Patient','Ward','Room');
		$this->layout = false;
		#pr($this->request->data);exit;
		$locationId = $this->Session->read('locationid');
		$data = $this->request->data['Bed'];
		$wardId = $data['room_id'];
		$wardData = $this->Room->find('first', array('fields'=> array('id', 'name','bed_prefix'), 'conditions' => array('Room.is_active' => 1,'Room.id' => $wardId, 'location_id' => $this->Session->read('locationid'))));
		
		$isAdmit = $this->Bed->find('first', array('fields'=> array('id','bedno'), 'conditions' => array('Bed.patient_id' => $data['patient_id'],'Bed.room_id' => $wardId, 'location_id' => $this->Session->read('locationid'))));
		#echo '<pre>';print_r($this->request->data);exit;
		
		$this->request->data['Bed']['location_id'] = $this->Session->read('locationid');
		if(count($isAdmit) > 0){
			$this->request->data['Bed']['id'] = $isAdmit['Bed']['id'];
			$this->Bed->insertBed($wardData,$this->request->data,'update');
			
		}else{
			$this->Bed->insertBed($wardData,$this->request->data,'insert');	
		}
		$this->Session->setFlash(__('Bed assigned successfully'),true,array('class'=>'message'));
		$this->Patient->id = $data['patient_id'];
		$this->Patient->bed_id = $data['bed_id'];
		$this->Patient->save($this->Patient);
			
		#$this->redirect(array("controller" => "beds", "action" => "index"));
		//echo 'test'.$bedId;exit;
	}
	
	/*function getAvailableBeds($wardId = 1){
		$locationId = $this->Session->read('locationid');
		$wardData = $this->Ward->find('first', array('conditions' => array('Ward.is_deleted' => 0, 'Ward.is_active' => 1, 'location_id' => $locationId, 'Ward.id' => $wardId)));
		echo '<pre>';print_r($wardData);exit;
		
	}*/
	//BOF pankaj
	//function to delete bed
	function delete($bed_id=null){
		$this->uses = array('Bed','Room');
		if($bed_id){
			$bedData = $this->Bed->read(array('room_id'),$bed_id);
			
			#pr($roomData);exit;			
			if($this->Bed->delete($bed_id)){ 
				$this->Room->unBindModel(array(
 								'hasMany' => array('Bed')));
				$roomData = $this->Room->read('no_of_beds',$bedData['Bed']['room_id']);
				$this->Room->id = $bedData['Bed']['room_id'];
				$this->Room->save(array('no_of_beds'=>$roomData['Room']['no_of_beds']-1,'id'=>$bedData['Bed']['room_id']));
				$this->Session->setFlash(__('Bed has been removed successfully'),true,array('class'=>'message'));
			}
			else{
				$this->Session->setFlash(__('Please try again'),true,array('class'=>'message'));
			}
		}else{
			$this->Session->setFlash(__('Please try again'),true,array('class'=>'error'));
		}
		$this->redirect($this->referer());
	}
	
	function status($bed_id=null,$status = 0){
		$this->uses = array('Bed');
		if($bed_id){	
			$this->Bed->id  = $bed_id ;		
			if($this->Bed->save(array('under_maintenance'=>$status))) 
				$this->Session->setFlash(__('Bed status has been change successfully'),true,array('class'=>'message'));
			else
				$this->Session->setFlash(__('Please try again'),true,array('class'=>'message'));
		}else{
			$this->Session->setFlash(__('Please try again'),true,array('class'=>'error'));
		}
		
		$this->redirect($this->referer());
	}
	//EOF pankaj
	
}