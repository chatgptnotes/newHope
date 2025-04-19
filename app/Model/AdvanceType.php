<?php
class AdvanceType extends AppModel {

	public $name = 'AdvanceType';
    public $validate = array(
            'type' => array(
			'rule' => "notEmpty",
			'message' => "Please enter type."
			),
			'standard_amount' => array(
			'rule' => "notEmpty",
			'message' => "Please enter standard amount"
			),			
		 
               
    );        
	 public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    } 
    //ADD/EDIT advance type
    function insertType($data =array()){
    	$session = new cakeSession();
    	if(!empty($data['AdvanceType']['id'])){
    		$data["AdvanceType"]["modify_time"] = date("Y-m-d H:i:s");
	        $data["AdvanceType"]["modified_by"] = $session->read('userid'); 
    	}else{
    		$data["AdvanceType"]["create_time"] = date("Y-m-d H:i:s");
	        $data["AdvanceType"]["created_by"] = $session->read('userid');
    	}
    	$data["AdvanceType"]["location_id"] = $session->read('locationid');
    	 
    	return $this->save($data) ;
     }
	 
}
?>