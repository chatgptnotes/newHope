<?php
class DoctorTemplateText extends AppModel {

	public $name = 'DoctorTemplateText';
	public $validate = array(
		'template_text ' => array(
			'rule' => "notEmpty",
			'message' => "Please enter template text."
			)
    );
                
         public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }  	             
	function insertTemplateText($data=array(),$action='insert'){
		$session = new cakeSession();
		 
		if($action){			
			$data['DoctorTemplateText']['created_by'] = $session->read('userid');
			$data['DoctorTemplateText']['user_id'] = $session->read('userid');
			$data['DoctorTemplateText']['location_id'] = $session->read('locationid');
			$data["DoctorTemplateText"]["create_time"] = date("Y-m-d H:i:s");	     
		}else{			
			$data['DoctorTemplateText']['modified_by'] = $session->read('userid');
			$data["DoctorTemplateText"]["modify_time"] = date("Y-m-d H:i:s");	   
			$data['DoctorTemplateText']['location_id'] = $session->read('locationid');  
		}
		$this->create();
		$result = $this->save($data);
		return $result ; 
	}
		 
        
}
?>