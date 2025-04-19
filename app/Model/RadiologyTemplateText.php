<?php
class RadiologyTemplateText extends AppModel {

	public $name = 'RadiologyTemplateText';
	public $validate = array(
		'template_text ' => array(
			'rule' => "notEmpty",
			'message' => "Please template text."
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
			$data['RadiologyTemplateText']['created_by'] = $session->read('userid');
			$data['RadiologyTemplateText']['user_id'] = $session->read('userid');
			$data['RadiologyTemplateText']['location_id'] = $session->read('locationid');
			$data["RadiologyTemplateText"]["create_time"] = date("Y-m-d H:i:s");	     
		}else{			
			$data['RadiologyTemplateText']['modified_by'] = $session->read('userid');
			$data["RadiologyTemplateText"]["modify_time"] = date("Y-m-d H:i:s");	   
			$data['RadiologyTemplateText']['location_id'] = $session->read('locationid');  
		}
		$this->create();
		$result = $this->save($data);
		return $result ; 
	}
		 
        
}
?>