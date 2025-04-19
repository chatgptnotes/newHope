<?php
class Role extends AppModel {

	 public $name = 'Role';
	 public $specific = false;
	 public $hasMany = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'role_id',
            'dependent' => false
        )
    );
        public $actsAs = array(
	'Acl' => array('type' => 'requester'),
	);
        
    
	 public $validate = array(
		'name' => array(
		'rule' => "notEmpty",
		'message' => "Please enter role name."
		) ,
	 	'name' => array(
		'rule' => "isUnique",
	 	//"rule"=>array("checkUnique", array("name", "location_id")),
	 	'on' => 'create',
		'message' => "Role name already exists.",
	 	
		) 
	 		
 		/*'name' => array(
 				'rule' => array('checkUnique'),
 				'on' => 'create',
 				'message' => "Duplicate Role name."
 		)*/
	 );
	 // added for to add same role on different location, and restrict on same location-Atul
	 /** BOF Atul**/
	/* function checkUnique($data, $fields) {
	 	if (!is_array($fields)) {
	 		$fields = array($fields);
	 	}
	 	foreach($fields as $key) {
	 		$tmp[$key] = $this->data[$this->name][$key];
	 	}
	 	if (isset($this->data[$this->name][$this->primaryKey])) {
	 		$tmp[$this->primaryKey] = "<>".$this->data[$this->name][$this->primaryKey];
	 
	 	}
	 	return $this->isUnique($tmp, false);
	 }*/
	 /** EOF Atul**/
        
        public function parentNode() {
        	return null;
        }
		function __construct($id = false, $table = null, $ds = null) {
	 	$session = new cakeSession();
		if($session->read('db_name')!="")
	 		{
				$this->specific = true;
				$this->db_name =  $session->read('db_name');
			}
        parent::__construct($id, $table, $ds);
    }

    
    function getRoles(){
    	$session = new cakeSession();
    	return $this->find('list',array('conditions'=>array('location_id'=>array($session->read('locationid'),0),'is_deleted'=>0,'NOT'=>array('name'=>array('superadmin','admin'))),
    				'fields'=>array('name'),'order' => array('Role.name')));
    }
    
  	function getCoreRoles(){
    	$session = new cakeSession();
    	$locationID = $session->read('locationid') ;
    	if($locationID==1){
                	$condition = array('Role.is_deleted' => 0, 'Role.name !='=>"superadmin",'Role.name !=' =>Configure::read('patientLabel'),/*'location_id'=>array($session->read('locationid'),0)*/);
        }else{
                	$condition = array('Role.is_deleted' => 0, /* 'location_id'=>array($session->read('locationid'),0),*/ 'NOT'=>array('name'=>array('superadmin','admin')));
        }       
    	return $this->find('list',array('conditions'=>$condition,'fields'=>array('name'),'order' => array('Role.name')));
    }
    
    function getRolesIncludingAdmin(){
    	$session = new cakeSession();
    	return $this->find('list',array('conditions'=>array(/*'location_id'=>array($session->read('locationid'),0),*/'is_deleted'=>0,'NOT'=>array('name'=>array('superadmin'))),
    			'fields'=>array('name'),'order' => array('Role.name')));
    }
    
    /*** Added for to send clearance notification to  users--Atul**/
    function getStaffRoles(){
    	$session = new cakeSession();
    	$roles=array(Configure::read('staff'));
    	return $this->find('all',array('conditions'=>array('location_id'=>array($session->read('locationid'),0),'is_deleted'=>0,'name'=>array($roles[0]['Pharmacy Manager'],$roles[0]['Lab Manager'],$roles[0]['Radiology Manager'],$roles[0]['Front Office Executive'],$roles[0]['Nurse']),'NOT'=>array('name'=>array('superadmin'))),
    			'fields'=>array('id','name'),'order' => array('Role.name')));
    	
    }
    
    function getRoleIdByName($name=null){
    	if(!$name) return ;
    	$session = new cakeSession();
    	return $this->find('first',array('conditions'=>array('location_id'=>array($session->read('locationid'),0),
    			'is_deleted'=>0,'Role.name'=>$name),
    			'fields'=>array('id')));
    }
    
    /*
     * function to get Doctor id
    * @author : Swapnil
    * @created : 09.04.2016
    */
    public function getDoctorId(){
    	$result = $this->find('first',array(
    			'fields'=>array('Role.id'),
    			'conditions'=>array(
    					'name'=>"Doctor",
    					'is_deleted'=>'0'
    			)
    	));
    	return $result['Role']['id'];
    }
}
?>