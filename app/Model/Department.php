<?php
class Department extends AppModel {

	public $name = 'Department';
        		
	public $validate = array(
		'name' => array(
			'rule' => "notEmpty",
			'message' => "Please enter name."
			),
			'name' => array(
					'rule' => "checkUnique",
					'message' => "Speciality with this name is already exists.",
						
			),
                );
    public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }       
	public function getDepartmentByLocationID($id=null){
		$details =  $this->find('all',array('fields'=>array('id','name'),'conditions'=>array('Department.location_id'=>$id)));
		$return_arr =array();
		foreach($details as $key =>$value){
			foreach($details[$key] as $lastnode){
				$return_arr[$lastnode['id']]  =  $lastnode['name'] ;
			}
			 
		}
		return $return_arr;
	}
		
	function insertDepartment($data=array(),$action='insert'){
		$session = new CakeSession();
		
		if($action=='insert'){
			$data['Department']['location_id']=$session->read('locationid');	
			$data["Department"]["create_time"] = date("Y-m-d H:i:s");	        
	        $data["Department"]["created_by"] = $session->read('userid');	        
		}else{
			//$data['Department']['location_id']=$session->read('locationid');	
			$data["Department"]["modify_time"] = date("Y-m-d H:i:s");
			$data["Department"]["modified_by"] = $session->read('userid'); 
		}		
        $this->create();
        $this->save($data);
	}
	public function checkUnique($check){
		$session = new cakeSession();
		if(!empty($this->id)){
			$conditions = array('id !='.$this->id,'location_id'=>$session->read('locationid'),'name'=>$this->data['Department']['name']);
		}else{
			$conditions = array('location_id'=>$session->read('locationid'),'name'=>$this->data['Department']['name']);
		}
		$countUser = $this->find( 'count', array('conditions' => $conditions , 'recursive' => -1));
		if($countUser > 0) {
			return false;
		} else {
			return true;
		}
	}
	
	//condition array for location  
	public function DepartmentList($condition= array())
	{
 
		$session = new cakeSession();
		if($condition){
			$activeCond = array('is_active'=>1);
			return $this->find('list',array('conditions'=>array_merge($activeCond,$condition),'order'=>array('Department.name')));
		}else{
			return $this->find('list',array('conditions'=>array('is_active'=>1),'order'=>array('Department.name')));
		}
	}


	function getDepartmentByID($department_id=null){
		if(empty($department_id)) return false;
		return $this->find('first',array('conditions'=>array('id'=>$department_id))) ;
	}
	 
	//to get the doctors Department id from given name by Swapnil - 04.03.2016
	public function getDeptByName($names=array()){
		return $this->find('list',array('fields'=>array('id','name'),'conditions'=>array('is_active'=>'1','name'=>$names)));
	}
}
?>