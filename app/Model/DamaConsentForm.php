<?php
class DamaConsentForm extends AppModel {

	public $name = 'DamaConsentForm';
        		
	 
	      public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }  
    
    function insertData($data=array()){
    	$session= new cakeSession();
    	$data['location_id']=$session->read('locationid');
    	if(empty($data['id'])) {
                 $data['created_by'] = $session->read('userid');
                 $data['create_time'] = date("Y-m-d H:i:s");
        }else{
                 $data['modified_by'] = $session->read('userid');
                 $data['modify_time'] = date("Y-m-d H:i:s");
        }
        $this->save($data);
    }
}
?>