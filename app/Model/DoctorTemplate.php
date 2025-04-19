<?php
class DoctorTemplate extends AppModel {

	public $name = 'DoctorTemplate';
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

      public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }  

	//function to insert template by admin                                   
     public function insertGeneralTemplate($data=array(),$action='insert'){
     		$session= new cakeSession();
     		if($action=='insert'){
     			$data['DoctorTemplate']['location_id'] = $session->read('locationid');
            	$data['DoctorTemplate']['created_by']  = $session->read('userid');
            	$data['DoctorTemplate']['create_time'] = date("Y-m-d H:i:s");	
     		}else{
     			$data['DoctorTemplate']['location_id'] = $session->read('locationid');
            	$data['DoctorTemplate']['modified_by'] = $session->read('userid');
            	$data['DoctorTemplate']['modify_time'] = date("Y-m-d H:i:s");
     		}
     		
             return $this->save($data);
     } 
}
?>