<?php
class State extends AppModel {

	public $name = 'State';
    public $specific = true;
	//public $useDbConfig = 'test';
	  function __construct($id = false, $table = null, $ds = null) {
	  	if(empty($ds)){
	  	$session = new cakeSession();
		if($session->read('db_name')!="")
	 		{
				$this->specific = true;
				$this->db_name =  $session->read('db_name');
			}
	  	}else{
	  		$this->db_name =  $ds;
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
	function insertState($data=array(),$action='insert'){
		$session = new CakeSession();
		if($action=='insert'){
			$data["State"]["create_time"] = date("Y-m-d H:i:s");	        
	        $data["State"]["created_by"] = $session->read('userid');	
	                
		}else{
			$data["State"]["modify_time"] = date("Y-m-d H:i:s");
			$data["State"]["modified_by"] = $session->read('userid'); 
		}		
        $this->create();
        $this->save($data);
	}	

	function getStateList(){
		return $this->find('list',array('fields'=>array('id','name'),'conditions'=>array('country_id'=>'1')));
	}

}
?>