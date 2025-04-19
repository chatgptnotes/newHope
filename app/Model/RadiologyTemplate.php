<?php
class RadiologyTemplate extends AppModel {

	public $name = 'RadiologyTemplate';
		

	public $belongsTo = array('User' => array('className'    => 'User',
                                                  'foreignKey'    => 'user_id'
                                                 ),
                                  'Location' => array('className'    => 'Location',
                                                   'foreignKey'    => 'location_id'
                                                 ),
                                  'Initial' => array('className' => 'Initial',
                                                           'foreignKey'    => false,
                                                           'conditions'=>array('Initial.id=User.initial_id')
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
     			$data['RadiologyTemplate']['location_id'] = $session->read('locationid');
            	$data['RadiologyTemplate']['created_by']  = $session->read('userid');
            	$data['RadiologyTemplate']['create_time'] = date("Y-m-d H:i:s");	
     		}else{
     			$data['RadiologyTemplate']['location_id'] = $session->read('locationid');
            	$data['RadiologyTemplate']['modified_by'] = $session->read('userid');
            	$data['RadiologyTemplate']['modify_time'] = date("Y-m-d H:i:s");
     		}
     		
             return $this->save($data);
     } 
      
}