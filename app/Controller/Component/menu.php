<?php
/**
 * Menu Component
 *
 * Uses ACL to generate Menus.
 *
 * Copyright 2008, Mark Story.
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2008, Mark Story.
 * @link http://mark-story.com
 * @version 1.1
 * @author Mark Story <mark@mark-story.com>
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 */
class MenuComponent extends Component{
	public $components = array('Acl', 'Auth','Session','Cookie');
	public $menu = array();
	public $uses       = array('Aro','Role','User','Aco');
	public static  $controller_action;
	public $allowed_action = array();
	public function __construct(ComponentCollection $collection, $settings = array()) {
		$this->_controller = $collection->getController();
		parent::__construct($collection, $settings);
	}

	public function initialize() {
	if(!self::$controller_action){
	        self::$controller_action =$this->get_all_app_controllers_actions();

			}


	}
	public function initMenu($actionName) {
		if (!$this->Auth->user()) {
			return;
		}	
		$defaultHosiptalMode = $this->Session->read('hospital_permission_mode');
		if(empty($defaultHosiptalMode))		
		$defaultHosiptalMode = Configure::read('hospital_default_mode'); //commented by pankaj
		//BOF pankaj
		$cakeSession = ClassRegistry::init('SessionPermission'); 		
		$role = $this->Session->read('role') ;
		$location = $this->Session->read('location_name');

		 
		if($this->Session->check('skipSwapPermissions')){ //if role has been changed
			$realRole = $this->Session->read('skipSwapPermissions');  			
			if($realRole == $role){ //compare existing and previous role. 
				$result = $cakeSession->read(null,$_COOKIE['CAKEPHP']);
				$fetchPermissions = false ;
			}else{ 
				$fetchPermissions = true  ; 
				$this->Session->write('skipSwapPermissions',$this->Session->read('role')) ;
			}
		}else if($this->Session->check('realLocationName')){			
			//$realLocation = $this->Session->read('realLocationName');  			
			//if($realLocation == $location){ //compare existing and previous role. 
				$result = $cakeSession->read(null,$_COOKIE['CAKEPHP']);
				$fetchPermissions = true ;
			/*}else{ 
				$fetchPermissions = true  ; 
				$this->Session->write('realLocationName',$this->Session->read('location_name')) ;
			}*/
		}else{
			$result = $cakeSession->read(null,$_COOKIE['CAKEPHP']); //if role hasn't been change
		}
		if(strtolower($role)==strtolower(Configure::read('adminLabel')) || $this->Session->read("roleid") == "1"){ //admin n superadmin			 
			$this->constructMenu($this->Auth->user());	
			return ($this->allowed_action);
		}else{  
			//exit;
			$sessionPermissionData = unserialize($result['SessionPermission']['data']) ;
			 
 			if(empty($sessionPermissionData[$defaultHosiptalMode])){ 
				$allowedActions = $this->constructMenu($this->Auth->user()); 	 
				#debug($allowedActions);
				if(($this->Session->check('hasPermissions'))){ 					
					$cakeSession->id = '';
					$cakeSession->saveData($_COOKIE['CAKEPHP'],serialize(array('Clinic'=>$allowedActions['0'],'Hospital'=>$allowedActions['1'])),strtotime("+2 days"));
				}else if($fetchPermissions){ 
					$cakeSession->id = '';
					$cakeSession->saveData($_COOKIE['CAKEPHP'],serialize(array('Clinic'=>$allowedActions['0'],'Hospital'=>$allowedActions['1'])),strtotime("+2 days"));
					
				} 
				if($defaultHosiptalMode == 'Hospital'){
					$this->allowed_action = $allowedActions['1'];
				}else if($defaultHosiptalMode == 'Clinic'){
					$this->allowed_action = $allowedActions['0'];
				}	
				return ($this->allowed_action);
			}else{  
				$permissionData = unserialize($result['SessionPermission']['data']);				 
				return $permissionData[$defaultHosiptalMode];
			}
		}
		//EOF pankaj 		
	}

	public function constructMenu($aro) {
		$role = $this->Session->read('role') ;
		if(strtolower($role)==strtolower(Configure::read('adminLabel')) || $this->Session->read("roleid") == "1"){
			//admin n superadmin
			$this->constructClinicHospitalMenu($aro,'Hospital');
			return ($this->allowed_action);
		}else{
			$hospitalMode = $this->Session->read('hospital_permission_mode') ; 
			//if($hospitalMode=='Clinic'){
				$clinicAllowedActions = $this->constructClinicHospitalMenu($aro,'Clinic');
				//debug($clinicAllowedActions);
			//}else{
				$hospitalAllowedActions = $this->constructClinicHospitalMenu($aro,'Hospital');
 
			//}  
			$this->Session->write('hasPermissions','yes') ; //set haspermissions
			return array_merge(array($clinicAllowedActions),array($hospitalAllowedActions));
		}

	}
	
	function constructClinicHospitalMenu($aro,$hospitalMode){
		$c = array();
		if($this->Session->read("roleid") == "1"){ 
			$this->allowed_action = self::$controller_action;
			return ;
		} 
		 
		$aro = $this->Acl->Aro->find('first', array(
								'conditions' => array(
										'Aro.model' => 'Role',
										'Aro.foreign_key' => $this->Session->read("roleid"),
		),
								'recursive' => -1,
		));  // get the aros id for user's role
		
		$aro_user = $this->Acl->Aro->find('first', array(
								'conditions' => array(
										'Aro.model' => 'User',
										'Aro.foreign_key' => $this->Auth->user('id'),
		),
								'recursive' => -1,
		));  // get the aros id for user's
		
		$this->aroId =  $aro['Aro']['id'];
		$this->aroUser =  $aro_user['Aro']['id'];
			
		if(empty( $this->aroUser)) $this->aroUser = 0;
			
		$allowedActions=array();
		
		//BOF admin permission
		//EOF admin permission
		
		// check for all permission
		$admin_permission =    $this->Acl->Aco->Permission->find("first",array("conditions"=>array("Permission.aro_id"=> $this->aroId,"Permission.aco_id"=>1,
								'Permission._delete' => 1,'Permission._update' => 1,'Permission._create' => 1,'Permission._read' => 1,)));
		if(!empty($admin_permission)){
			$this->allowed_action = self::$controller_action;
			/* pr($this->allowed_action);
			 exit; */
			return ;
		}
		if(!$this->aroId){
			$this->aroId = "''";
		}
		$allowedActions = $this->Acl->Aco->Permission->query("SELECT  `Aco`.`id`, `Aco`.`parent_id`,  `Aco`.`foreign_key`, `Aco`.`alias` FROM `aros_acos` AS `Permission` LEFT JOIN
								`aros` AS `Aro` ON (`Permission`.`aro_id` = `Aro`.`id`) LEFT JOIN `acos` AS `Aco` ON (`Permission`.`aco_id` = `Aco`.`id`) WHERE
								`Permission`.`hospital_mode` = \"$hospitalMode\" AND `Permission`.`aro_id` = ". $this->aroId." AND `Permission`.`_create` = '1' AND `Permission`.`_read` = '1' AND `Permission`.`_update` = '1' AND
								`Permission`.`_delete` = '1' AND `Permission`.`aco_id` not in (SELECT `Permission`.`aco_id` FROM `aros_acos` AS `Permission` LEFT JOIN `aros` AS `Aro`
								ON (`Permission`.`aro_id` = `Aro`.`id`) LEFT JOIN `acos` AS `Aco` ON (`Permission`.`aco_id` = `Aco`.`id`) WHERE `Permission`.`aro_id` = ".$this->aroUser." AND
								`Permission`.`_create` = -1 AND `Permission`.`_read` = -1 AND `Permission`.`_update` = -1 AND `Permission`.`_delete` = -1)");
		
		
		if(!empty($aro_user)){
			$allowedActionsForUser = $this->Acl->Aco->Permission->find('all', array(
									'conditions' => array(
											'Permission.aro_id' =>  $this->aroUser,
											'Permission._create' => 1,
											'Permission._read' => 1,
											'Permission._update' => 1,
											'Permission._delete' => 1,
											'Permission.hospital_mode' => $hospitalMode,
			),
			));
			$result = array_merge($allowedActions,$allowedActionsForUser); // merge user specifc and role secific permission
		}else{
			$result = $allowedActions ;
		}
		
		$defaultallowd
		= $this->Acl->Aco->find('all', array(
								'conditions' => array(
										'Aco.is_permission_need' => 0,
		
		),
		));
		$result = array_merge($result,$defaultallowd); // merge default allowed actions
		//PAWAN MESHRAM DO NOT CHANGE 
		$parent_id = Set::classicExtract($result, '{n}.Aco.parent_id');
		$alias = Set::classicExtract($result, '{n}.Aco.alias');
		$controller_names = $this->Acl->Aco->find('all', array(
				'conditions' => array(
						'Aco.id' =>   $parent_id,
				),
		));
		$controller_names_list = Set::classicExtract($controller_names, '{n}.Aco.id');
		foreach($parent_id  as $key => $value){
			$controller_name = $controller_names[array_search($value, $controller_names_list)];
			if(trim($controller_name['Aco']['alias'])!=""){
					if(!isset($c[$controller_name['Aco']['alias']]))
					$c[$controller_name['Aco']['alias']] = array();
		
					array_push($c[$controller_name['Aco']['alias']],$alias[$key]);
				}
		}//Pawan Meshram DO NOT CHANGE 
		$this->allowed_action = $c;
		return $this->allowed_action;
		
	}
	
	/*
	 * function constructClinicHospitalMenu($aro,$hospitalMode){
		$c = array();
		if($this->Session->read("roleid") == "1" ||  (!$this->Session->check('hasPermissions'))){ 
			$this->allowed_action = self::$controller_action;
			return ;
		} 
		 
		$aro = $this->Acl->Aro->find('first', array(
								'conditions' => array(
										'Aro.model' => 'Role',
										'Aro.foreign_key' => $this->Session->read("roleid"),
		),
								'recursive' => -1,
		));  // get the aros id for user's role
		
		$aro_user = $this->Acl->Aro->find('first', array(
								'conditions' => array(
										'Aro.model' => 'User',
										'Aro.foreign_key' => $this->Auth->user('id'),
		),
								'recursive' => -1,
		));  // get the aros id for user's
		
		$this->aroId =  $aro['Aro']['id'];
		$this->aroUser =  $aro_user['Aro']['id'];
			
		if(empty( $this->aroUser)) $this->aroUser = 0;
			
		$allowedActions=array();
		
		//BOF admin permission
		//EOF admin permission
		
		// check for all permission
		$admin_permission =    $this->Acl->Aco->Permission->find("first",array("conditions"=>array("Permission.aro_id"=> $this->aroId,"Permission.aco_id"=>1,
								'Permission._delete' => 1,'Permission._update' => 1,'Permission._create' => 1,'Permission._read' => 1,)));
		if(!empty($admin_permission)){
			$this->allowed_action = self::$controller_action;
			
			return ;
		}
		if(!$this->aroId){
			$this->aroId = "''";
		}
		$allowedActions = $this->Acl->Aco->Permission->query("SELECT  `Aco`.`id`, `Aco`.`parent_id`,  `Aco`.`foreign_key`, `Aco`.`alias` FROM `aros_acos` AS `Permission` LEFT JOIN
								`aros` AS `Aro` ON (`Permission`.`aro_id` = `Aro`.`id`) LEFT JOIN `acos` AS `Aco` ON (`Permission`.`aco_id` = `Aco`.`id`) WHERE
								`Permission`.`hospital_mode` = \"$hospitalMode\" AND `Permission`.`aro_id` = ". $this->aroId." AND `Permission`.`_create` = '1' AND `Permission`.`_read` = '1' AND `Permission`.`_update` = '1' AND
								`Permission`.`_delete` = '1' AND `Permission`.`aco_id` not in (SELECT `Permission`.`aco_id` FROM `aros_acos` AS `Permission` LEFT JOIN `aros` AS `Aro`
								ON (`Permission`.`aro_id` = `Aro`.`id`) LEFT JOIN `acos` AS `Aco` ON (`Permission`.`aco_id` = `Aco`.`id`) WHERE `Permission`.`aro_id` = ".$this->aroUser." AND
								`Permission`.`_create` = -1 AND `Permission`.`_read` = -1 AND `Permission`.`_update` = -1 AND `Permission`.`_delete` = -1)");
		
		
		if(!empty($aro_user)){
			$allowedActionsForUser = $this->Acl->Aco->Permission->find('all', array(
									'conditions' => array(
											'Permission.aro_id' =>  $this->aroUser,
											'Permission._create' => 1,
											'Permission._read' => 1,
											'Permission._update' => 1,
											'Permission._delete' => 1,
											'Permission.hospital_mode' => $hospitalMode,
			),
			));
			$result = array_merge($allowedActions,$allowedActionsForUser); // merge user specifc and role secific permission
		}else{
			$result = $allowedActions ;
		}
		
		$defaultallowd
		= $this->Acl->Aco->find('all', array(
								'conditions' => array(
										'Aco.is_permission_need' => 0,
		
		),
		));
		$result = array_merge($result,$defaultallowd); // merge default allowed actions
		foreach($result  as $key => $value){
			if(is_array($value['Aco'])){
				$controller_name = $this->Acl->Aco->find('first', array(
										'conditions' => array(
												'Aco.id' =>   $value['Aco']['parent_id'],
				),
				));
				if(trim($controller_name['Aco']['alias'])!=""){
					if(!isset($c[$controller_name['Aco']['alias']]))
					$c[$controller_name['Aco']['alias']] = array();
		
					array_push($c[$controller_name['Aco']['alias']],$value['Aco']['alias']);
				}
			}
		}
		$this->allowed_action = $c;
		return $this->allowed_action;
		
	}
	 */
	

	public function get_all_app_controllers()
	{
		$controllers = array();

		App::uses('Folder', 'Utility');
		$folder = new Folder();

		$didCD = $folder->cd(APP . 'Controller');
		if(!empty($didCD))
		{
		    $files = $folder->findRecursive('.*Controller\.php');

		    foreach($files as $fileName)
			{
				$file = basename($fileName);

				// Get the controller name
				//$controller_class_name = Inflector::camelize(substr($file, 0, strlen($file) - strlen('Controller.php')));

				$controller_class_name = Inflector::camelize(substr($file, 0, strlen($file) - strlen('.php')));
				App::uses($controller_class_name, 'Controller');

				$controllers[] = array('name' => substr($controller_class_name, 0, strlen($controller_class_name) - strlen('Controller')));
			}
		}



		return $controllers;
	}
	
	public function get_all_app_controllers_actions()
	{
		$controllers = $this->get_all_app_controllers(); 
		//BOF pankaj for module permission
		$modulePermissions = $this->Session->read('module_permissions') ;
		$modulePermissions = array_map('strtolower', $modulePermissions);
		foreach($controllers as $key => $controller)
		{
		 	if(!in_array(strtolower($controller['name']),$modulePermissions,false)){
		 		unset($controllers[$key]); //remove module those dont have permissions at hospital level
		 	}
		}
		//EOF pankaj for module permission		
		foreach($controllers as $controller)
		{	if($controller['name'] !="App"){
				$controller_class_name = $controller['name'];
				if($controller_class_name !="Bridge" && $controller_class_name !="Home"&& $controller_class_name !="Sessions"){
				$ctrl_cleaned_methods = $this->get_controller_actions($controller_class_name);
					$c[$controller['name']] = array();
				foreach($ctrl_cleaned_methods as $action)
				{
					array_push($c[$controller['name']],$action);
				}
			}
			}
		} 
		return $c;
	}
	
	
	public function get_controller_actions($controller_classname, $filter_base_methods = true)
	{
	    $controller_classname = $this->get_controller_classname($controller_classname);
		$methods = get_class_methods($controller_classname);
		if(isset($methods) && !empty($methods))
		{
    		if($filter_base_methods)
    		{
    			$baseMethods = get_class_methods('Controller');

    			$ctrl_cleaned_methods = array();
    		    foreach($methods as $method)
    		    {
    		        if(!in_array($method, $baseMethods) && strpos($method, '_') !== 0)
    				{
    				    $ctrl_cleaned_methods[] = $method;
    				}
    		    }

    		    return $ctrl_cleaned_methods;
    		}
    		else
    		{
    			return $methods;
    		}
		}
		else
		{
		    return array();
		}
	}
	public function get_controller_classname($controller_name)
	{
	    if(strrpos($controller_name, 'Controller') !== strlen($controller_name) - strlen('Controller'))
	    {
	        /*
	         * If $controller does not already end with 'Controller'
	         */

    	    if(stripos($controller_name, '/') === false)
    	    {
    	        $controller_classname = $controller_name . 'Controller';
    	    }
    	    else
    	    {
    	        /*
    	         * Case of plugin controller
    	         */
    	        $controller_classname = substr($controller_name, strripos($controller_name, '/') + 1) . 'Controller';
    	    }

    	    return $controller_classname;
	    }
	    else
	    {
	        return $controller_name;
	    }
	}
	public function in_object($val, $obj){
		$flag = false;
		foreach($obj as $key => $value){

			  if(in_array($val,$value['Aco']))
				$flag =  true;

		}
	   return $flag;
	}
}
?>