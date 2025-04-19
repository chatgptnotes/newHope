<?php
class NoteTemplate extends AppModel {

	public $name = 'NoteTemplate';
	public $validate = array(
		'template_name' => array(
			'rule' => "notEmpty",
			'message' => "Please enter template name."
			)
    );		

	public $belongsTo = array('User' => array('className'    => 'User',
                                                  'foreignKey'    => 'user_id'
                                                 ),
                                  'Location' => array('className'    => 'Location',
                                                   'foreignKey'    => 'location_id'
                                                 )
                                  );
        
	//function to insert template by admin                                   
     public function insertGeneralTemplate($data=array(),$action='insert'){
     		$session= new cakeSession();
     		if($action=='insert'){
     			$data['NoteTemplate']['location_id'] = $session->read('locationid');
            	$data['NoteTemplate']['created_by']  = $session->read('userid');
            	$data['NoteTemplate']['create_time'] = date("Y-m-d H:i:s");	
     		}else{
     			$data['NoteTemplate']['location_id'] = $session->read('locationid');
            	$data['NoteTemplate']['modified_by'] = $session->read('userid');
            	$data['NoteTemplate']['modify_time'] = date("Y-m-d H:i:s");
     		}
     		
             return $this->save($data);
     } 
     
	public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }
}
?>