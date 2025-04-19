<?php
class Chamber extends AppModel {

	public $name = 'Chamber';
    public $specific = true;    		
	public $validate = array(
								'name' => array(
									'rule' => "notEmpty",
									'message' => "Please enter chamber name."
							));
    
	
	function __construct($id = false, $table = null, $ds = null) {
	        $session = new cakeSession();
			$this->db_name =  $session->read('db_name');
	        parent::__construct($id, $table, $ds);
    }  
    
    function insertChmaber($data = array()){
    	$session = new cakeSession();
    	if($data['Chamber']['id']){
    		$data['Chamber']['modify_time'] = date("Y-m-d H:i:s");
    		$data['Chamber']['modified_by'] = $session->read('userid');
    		$data['Chamber']['location_id'] = $session->read('locationid'); 
    	}else{ 
    		$data['Chamber']['create_time'] = date("Y-m-d H:i:s");
    		$data['Chamber']['created_by'] = $session->read('userid');
    		$data['Chamber']['location_id'] = $session->read('locationid');
    	}
    	$this->save($data);
    }
    
    function getChambers($id){
      	App::import('Model', 'CakeSession');
		$session = new CakeSession();
		if($id){
			$conditions =  array('id'=>$id,'Chamber.location_id'=>$session->read('locationid'));
		}else{
			$conditions =  array('Chamber.location_id'=>$session->read('locationid'));
		}
		$result  =  $this->find('all',array('fields'=>array('name'),'conditions'=>$conditions)) ;
		
		return $result ; 
    }
    
    function getChamberList(){
    	App::import('Model', 'CakeSession');
		$session = new CakeSession();
		
		$conditions =  array('Chamber.location_id'=>$session->read('locationid'),'Chamber.is_deleted'=>0);
		
		$result  =  $this->find('list',array('fields'=>array('name'),'conditions'=>$conditions)) ;
		
		return $result ;
    }
}
?> 