<?php
/**
 * 
 * @author Pawan
 * @Controller Pathologies
 *
 */
class PathologiesController extends AppController {
	
	public $name = 'Pathologies';	
	public $helpers = array('Html','Form', 'Js','DateFormat');	 
	public $components = array('RequestHandler','DateFormat');
	public $uses = array('Patient');
	
	function requestTest(){
		if(isset($this->request->data) && !empty($this->request->data)){
			
		}
	}
	
	function editTest(){
		
	}
	
	
	function index(){
	$this->set('data','');
    	$this->paginate = array(
	        'limit' => Configure::read('number_of_rows'),
	        'order' => array(
	            'Patient.id' => 'asc'
	        )
    	);	
    	#pr($this->params);
    	$role = $this->Session->read('role');
    	$search_key['Patient.is_deleted'] = 0;
    	if($role == 'admin'){
    		#$search_key['User.facility_id']=$this->Session->read('facilityid');
    		$this->Patient->bindModel(array(
 								'belongsTo' => array( 											 
														'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id'))
    												)),false);  
    	}else{
    		$search_key['User.location_id']=$this->Session->read('locationid');
    		$this->Patient->bindModel(array(
 								'belongsTo' => array( 											 
														'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id' ))
    												)),false);  
    	}
    	
    	  	
    	if(!empty($this->params->query)){	    	 
	    	$search_ele = $this->params->query  ;//make it get 
	    	 
	    	
	    	if(!empty($search_ele['lookup_name'])){
	    		    $search_key['Patient.lookup_name like '] = "%".trim($search_ele['lookup_name'])."%" ;	
	    	}if(!empty($search_ele['patient_id'])){
	    		    $search_key['Patient.patient_id like '] = "%".trim($search_ele['patient_id']) ;
	    	}if(!empty($search_ele['admission_id'])){
	    		    $search_key['Patient.admission_id like '] = "%".trim($search_ele['admission_id']) ;	
	    	}	
	    	$this->paginate = array(
				        'limit' => Configure::read('number_of_rows'),
				        'order' => array('Patient.id' => 'asc'),
 						'fields'=> array('Patient.lookup_name,
 										 Patient.id,Patient.patient_id,Patient.admission_id,Patient.mobile_phone,Patient.landline_phone,CONCAT(User.first_name," ",User.last_name) as name, Patient.create_time'),
	    				'conditions'=>$search_key
 						);   	 
	    	/*$data = $this->paginate('Patient',array('conditions'=>$search_key,'fields'=>
	    	array('Patient.full_name,Patient.mobile,Patient.home_phone,CONCAT(User.first_name,",",User.last_name) as full.name') ));*/
 			$this->set('data',$this->paginate('Patient')); 	    	
	       
    	}else{
    	 
	    	$this->paginate = array(
				        'limit' => Configure::read('number_of_rows'),
				        'order' => array('Patient.id' => 'asc'),
 						'fields'=> array('Patient.lookup_name,
 										 Patient.id,Patient.patient_id,Patient.admission_id,Patient.mobile_phone,Patient.landline_phone,CONCAT(User.first_name," ",User.last_name) as name, Patient.create_time'),
	    				'conditions'=>$search_key
 						);		  
 						#pr($this->paginate('Patient'));exit;
 			$this->set('data',$this->paginate('Patient'));      	
	      #pr($this->paginate('Patient'));exit;  	
    	}
	}
}