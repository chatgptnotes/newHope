<?php
class NoteTemplateText extends AppModel {

	public $name = 'NoteTemplateText';
	public $validate = array(
		'template_text ' => array(
			'rule' => "notEmpty",
			'message' => "Please template text."
			)
    );
                
                
	function insertTemplateText($data=array(),$action='insert'){
		$session = new cakeSession();
		 
		if($action){			
			$data['NoteTemplateText']['created_by'] = $session->read('userid');
			$data['NoteTemplateText']['user_id'] = $session->read('userid');
			$data['NoteTemplateText']['location_id'] = $session->read('locationid');
			$data["NoteTemplateText"]["create_time"] = date("Y-m-d H:i:s");	     
		}else{			
			$data['NoteTemplateText']['modified_by'] = $session->read('userid');
			$data["NoteTemplateText"]["modify_time"] = date("Y-m-d H:i:s");	   
			$data['NoteTemplateText']['location_id'] = $session->read('locationid');  
		}
		$this->create();
		$result = $this->save($data);
		return $result ; 
	}
	
	public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }
		 
        
}
?>