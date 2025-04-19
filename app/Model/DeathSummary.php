<?php
class DeathSummary extends AppModel {

	public $name = 'DeathSummary'; 
	public $specific = true;
	
	function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }

    function insertDeathSummary($data=array()){
    	$dateFormat  = new DateFormatComponent();
    	$session = new cakeSession();
    	if(!empty($data['death_on'])){
    		$data['death_on']= $dateFormat->formatDate2STD($data['death_on'],Configure::read('date_format')) ;
    	}
        if(!empty($data['date_of_illness'])){
            $data['date_of_illness'] = $dateFormat->formatDate2STD($data['date_of_illness'],Configure::read('date_format'));
        }   
        if(!empty($data['admission_date_iiw'])){
            $data['admission_date_iiw'] = $dateFormat->formatDate2STD($data['admission_date_iiw'],Configure::read('date_format'));
        }
        if(!empty($data['swab_taken_date'])){
            $data['swab_taken_date'] = $dateFormat->formatDate2STD($data['swab_taken_date'],Configure::read('date_format'));
        }
        if(!empty($data['swab_result_date'])){
            $data['swab_result_date'] = $dateFormat->formatDate2STD($data['swab_result_date'],Configure::read('date_format'));
        }

    	$data['location_id'] = $session->read('locationid');
    	if($data['id']){
    		$data['modify_time'] = date('Y-m-d H:i:s');
    		$data['modified_by'] = $session->read('userid');
    	}else{
    		$data['create_time'] = date('Y-m-d H:i:s');
    		$data['created_by'] = $session->read('userid');
    	}
    	 
    	$this->save($data);
    }
    
    function getData($patient_id=null){
    	$dateFormat  = new DateFormatComponent();
    	$result=  $this->find('first',array('conditions'=>array('patient_id'=>$patient_id)));
    	if($result['DeathSummary']['death_on']){
    		$result['DeathSummary']['death_on']= $dateFormat->formatDate2Local($result['DeathSummary']['death_on'],Configure::read('date_format'),true) ;
    	}

        if(!empty($result['DeathSummary']['date_of_illness'])){
            $result['DeathSummary']['date_of_illness'] = $dateFormat->formatDate2Local($result['DeathSummary']['date_of_illness'],Configure::read('date_format'));
        }   
        if(!empty($result['DeathSummary']['admission_date_iiw'])){
            $result['DeathSummary']['admission_date_iiw'] = $dateFormat->formatDate2Local($result['DeathSummary']['admission_date_iiw'],Configure::read('date_format'),true);
        }
        if(!empty($result['DeathSummary']['swab_taken_date'])){
            $result['DeathSummary']['swab_taken_date'] = $dateFormat->formatDate2Local($result['DeathSummary']['swab_taken_date'],Configure::read('date_format'));
        }
        if(!empty($result['DeathSummary']['swab_result_date'])){
            $result['DeathSummary']['swab_result_date'] = $dateFormat->formatDate2Local($result['DeathSummary']['swab_result_date'],Configure::read('date_format'));
        }
         
    	return $result ;
    }
    
    // Get cause of death
public function getCauseofDeath($id=null){
		return $this->find('all',array('conditions'=>array('DeathSummary.patient_id'=>$id)));
		//$this->set('getdata',$getdata);
		
	}
    
    
}