<?php
class AnaesthesiaNote extends AppModel {

	public $name = 'AnaesthesiaNote';
        		
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
    function getAnaesthesiaNote($patient_id){
    	if(empty($patient_id)) return false ;
    	//check for date and convert in std format
    	$dateFormatComponent = new DateFormatComponent() ;
    	$result= $this->find('first',array('conditions'=>Array('patient_id'=>$patient_id))) ;
    	if($result['AnaesthesiaNote']['pre_med_time']){
    		$result['AnaesthesiaNote']['pre_med_time'] = $dateFormatComponent->formatDate2Local($result['AnaesthesiaNote']['pre_med_time'], Configure::read('date_format')) ;
    	}
    	 
    	return $result ;
    }
    
    //function to save opertaive notes
    function saveAnaesthesiaNote($data,$validate=false){
    	$session  = new CakeSession() ;
    	//check for date and convert in std format
    	$dateFormatComponent = new DateFormatComponent() ;
    	//find if record is already exist for patietn and same surgery

        if($data['pre_med_time']){
    		$data['pre_med_time'] = $dateFormatComponent->formatDate2STD($data['pre_med_time'], Configure::read('date_format')) ;
    	}
        if($data['anae_date']){
            $data['anae_date'] = $dateFormatComponent->formatDate2STD($data['anae_date'], Configure::read('date_format')) ;
        } 
    	$data['created_by'] = $session->read('userid') ;
    	$data['created_time'] = date('Y-m-s H:i:s'); 
    	$result  = $this->save($data);
    	if($result) return true;
    	else return false ;
    }
}