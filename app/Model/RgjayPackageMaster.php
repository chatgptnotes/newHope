<?php
class  RgjayPackageMaster  extends AppModel {

	public $name = 'RgjayPackageMaster';
        		
	public $cacheQueries = false ;
	
	
	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		if(empty($ds)){
        	$session = new cakeSession();
			$this->db_name =  $session->read('db_name');
	 	}else{
	 		$this->db_name =  $ds;
	 	}
        parent::__construct($id, $table, $ds);
    }  
    
    
    function saveServicePackage($service_id=null,$patient_id=null){
    	$this->layout = 'ajax' ;
    	$this->autoRender  = false ;
    	if($this->request->data['tariff_list_id'] && $patient_id){
    		$this->loadModel('ServiceBill');
    		$this->loadModel('TariffList');
    		$serviceData = $this->TariffList->find('first',array('conditions'=>array('TariffList.id'=>$this->request->data['tariff_list_id'])));//find group id
    
    		//check if package already added
    		if(!empty($service_id)){
    			$isExist = $this->ServiceBill->find('first',array('conditions'=>array('ServiceBill.patient_id'=>$patient_id,'ServiceBill.service_id'=>$service_id)));
    		}
    		$result  = $this->ServiceBill->save(array(
    				'id'=>$isExist['ServiceBill']['id'],
    				'patient_id'=>$patient_id,
    				'tariff_list_id'=>$this->request->data['tariff_list_id'],
    				'tariff_standard_id'=>$this->request->data['tariff_standard_id'],
    				'service_id'=>$serviceData['TariffList']['service_category_id'],
    				'date'=>date('Y-m-d H:i:s'),
    				'location_id'=>1,
    				'amount'=>$this->request->data['amount'],
    				'no_of_times'=>1,
    				'create_time'=>date('Y-m-d H:i:s'),
    				'created_by'=>1	));
    		if($result) return true ;
    	}
    	return false  ;
    	exit;
    }
    
    
}