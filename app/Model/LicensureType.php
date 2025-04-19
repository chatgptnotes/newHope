<?php
class LicensureType extends AppModel {

	public $name = 'LicensureType';
    public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
    	$session = new cakeSession();
		if($session->read('db_name')!="")
	 		{
				$this->specific = true;
				$this->db_name =  $session->read('db_name');
			}
        parent::__construct($id, $table, $ds);
    }     		
	/*public $validate = array(
		'name' => array(
			'rule' => "notEmpty",
			'message' => "Please enter name."
			)
                );
        */
	function insertLicensureType($data=array(),$action='insert'){
		$session = new CakeSession();
		if($action=='insert'){
			//$data["LicensureType"]["create_time"] = date("Y-m-d H:i:s");	        
	        $data["LicensureType"]["created_by"] = $session->read('userid');	
	                
		}else{
			//$data["State"]["modify_time"] = date("Y-m-d H:i:s");
			$data["LicensureType"]["modified_by"] = $session->read('userid'); 
		}		
        $this->create();
        $this->save($data);
	}	

}
?>