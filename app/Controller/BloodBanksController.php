<?php
 /**
	 *  Controller : Blood Bank
	 *  Use : Blood requisitions , and other blood mgmt 
	 *  @created by :pankaj wanjari
	 *  @created on :17 OCT 2012 
	 *  functions : blood_requisition
	 *  
	 **/
class BloodBanksController extends AppController {

	public $name = 'BloodBanks';	
	public $uses = 'BloodOrder' ;
	public $helpers = array('Html','Form', 'Js','DateFormat','General');	 
	public $components = array('RequestHandler','Email','ImageUpload','DateFormat');
	
	//function list's blood request entries.
	function index($patient_id=null){
		$this->patient_info($patient_id);
		if(empty($patient_id)) $this->redirect($this->referer()); 
        	$this->paginate = array(
				        'limit' => Configure::read('number_of_rows'),
				        'order' => array('BloodOrder.id' => 'desc'),
            			'conditions'=>array('BloodOrder.patient_id'=>$patient_id,'BloodOrder.is_deleted '=> '0') );         
            $this->set('patient_id',$patient_id);
    		$this->set('data',$this->paginate('BloodOrder')); 
	}
	
	//blood requisition form
	function blood_requisition($patient_id=null,$id=null){
		$this->uses = array('ServiceCategory','DoctorProfile','TariffList','Ward','Room');
		$this->patient_info($patient_id);
		$this->set('ward',$this->Ward->find('list',array('fields'=>array('id','name'))));
		$this->set('room',$this->Room->find('list',array('fields'=>array('id','bed_prefix'))));
		if(empty($patient_id)) $this->redirect($this->referer()) ;
		if(!empty($this->request->data['BloodOrder'])){
			//save record
			
			$this->BloodOrder->insertBloodOrder($this->request->data) ;
			$errors = $this->BloodOrder->invalidFields();
		 
        	if(!empty($errors)) {
            	$this->set("errors", $errors);			
            }else {
        		$this->Session->setFlash(__('Record added successfully'),'default',array('class'=>'message'));
        		$this->redirect(array('action'=>'index',$this->request->data['BloodOrder']['patient_id']));
            } 
		}
		//retrive previous added entry for update
		if(!empty($id)){
			$this->data = $this->BloodOrder->read(null,$id) ;
			$tariffListGroup  = $this->TariffList->getServiceByGroupId($this->data['BloodOrder']['service_group_id']);
			$this->set('tariffListGroup',$tariffListGroup);
		}
		$this->patient_info($patient_id); //calling complete patient details
		$this->set('serviceGroup',$this->ServiceCategory->getServiceGroup());
		$this->set('registrar', $this->DoctorProfile->getRegistrar());
	}

	//print blood requisition 
	function blood_requisition_print($patient_id=null,$id=null){
		$this->layout = 'print_with_header' ; 
		if(!empty($this->request->data['BloodOrder'])){
			//save record 
			$this->BloodOrder->updateBloodOrder($this->request->data) ;
			$errors = $this->BloodOrder->invalidFields();
		 
        	if(!empty($errors)) {
            	$this->set("errors", $errors);			
            }else {
        		$this->Session->setFlash(__('Record added successfully'),'default',array('class'=>'message'));
        		$this->redirect(array('action'=>'blood_requisition_print',
        							  $this->request->data['BloodOrder']['patient_id'],$this->request->data['BloodOrder']['id']
        							  ,'?'=>array('allow'=>'print')));
            } 
		}
		$this->blood_requisition($patient_id,$id);
		$this->loadModel('ServiceProvider');
		$this->set('serviceProviders',$this->ServiceProvider->getServiceProvider('blood'));
	} 
	
	function blood_requisition_delete($id=null){
		if(!empty($id)){
			$result = $this->BloodOrder->save(array('id'=>$id,'is_deleted'=>1,'modified_by'=>$this->Session->read('userid'),'modify_time'=>date("Y-m-d H:i:s")));
			if($result){
				$this->Session->setFlash(__('Record deleted successfully'),'default',array('class'=>'message'));
        		$this->redirect($this->referer());
			}else{
				$this->Session->setFlash(__('Please try again'),'default',array('class'=>'message'));
        		$this->redirect($this->referer());
			}
		}
		$this->Session->setFlash(__('Please try again'),'default',array('class'=>'message'));
        $this->redirect($this->referer());
	}
	
	function getDoctorByID($doctor_id=null){ 
		$this->layout = false ;
		$this->autoRender = false ;
		$this->uses = array('DoctorProfile');
		$result = $this->DoctorProfile->getDoctorByID($doctor_id);
		return $result['User']['mobile'];
		exit ;
	}
	
}