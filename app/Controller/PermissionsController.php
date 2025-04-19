<?php
/**
 * This is roles controller file.
 *
 * Use to create/edit/view/delete roles
 * created : 16 Nov
 */
class PermissionsController extends AppController {

	public $name = "Permissions";
	public $uses  = array('Aro','Role','User','Aco',"AclArosAco","PackagePermission");
	public $helpers = array('Html','Form', 'Js');
	public $components = array('RequestHandler','Email');
	function beforeFilter(){
		parent::beforeFilter(); //to allow appcontrollers beforeFilter
		//commented by pankaj for clinic and hospital wise permssion 
		//$this->Session->write('hospital_default_mode',ucfirst(Configure::read('hospital_default_mode'))); 
		//overwrite config var for seperate permission 
		$hospitalMode = $this->Session->read('hospital_permission_mode');
		if($hospitalMode) Configure::write('hospital_default_mode',$hospitalMode) ; 
	}
	
	public function admin_index() {
	}

	/**
		Role permission

	*/
	public function admin_role_permission($aro_id = null, $hospitalMode='Hospital') {
		 $this->set('packageid', null);
		 
		 if(!$hospitalMode){
			$hospitalMode = Configure::read('hospital_default_mode') ;
		 } 
 
		 $this->Session->write('hospital_permission_mode',$hospitalMode);
		 
		 $this->Aco->unbindModel( array(
							'hasAndBelongsToMany' => array(
							  'Aro',
		)));
			$this->Role->bindModel(array(
							'hasOne' => array(
							  'Aro' =>array('foreignKey' => false,'conditions'=>array('Role.id = Aro.foreign_key and Aro.model = "Role"' )),
		)),false);
		if($aro_id!=null){
			$this->Role->unbindModel( array(
								'hasMany' => array(
								  'User',
			)));
			$role  = $this->Role->read(null,$aro_id);
			$this->Aco->bindModel(array(
					"hasMany" =>array(
						"AclArosAco"=>array("foreignKey"=>"aco_id")
					)
			));
			$modules = $this->Aco->find("all",array("conditions"=>array("Aco.parent_id = '1' and Aco.is_viewable = '1'  and Aco.is_permission_need ='1' "),'order'=>array('Aco.alias')));
			$this->set('role', $role);
			//BOF pankaj for module permission
			$modulePermissions = $this->Session->read('module_permissions') ;
			foreach($modules as $key => $value)
			{
			 	if(!in_array($value['Aco']['alias'],$modulePermissions)){
			 		unset($modules[$key]); //remove module those dont have permissions at hospital level
			 	}
			}
			$this->getPermissionOfModuleBaseOnRole($modules,$role['Aro']['id'],"controller");
			//EOF pankaj for module permission
			$this->set('modules', $modules);
		 }
		 $this->Role->unbindModel( array(
							'hasMany' => array(
							  'User',
		)));
		$roles = $this->Role->find("all" ,array("conditions"=>
												array("(Role.name !='superadmin' and
												Role.name !='admin')"),'group'=>array('Role.id'),'order'=>"Role.name"));
		$this->set('roles', $roles);
		

	}
	/**
		User permission

	*/
	public function admin_user_permission($aro_id = null,$emer=null, $packageId=null, $hospitalMode='Hospital') {
		$hospitalMode = Configure::read('hospital_default_mode') ;
		$this->Session->write('hospital_permission_mode',$hospitalMode);
		
	 		$this->Aco->unbindModel( array(
 								'hasAndBelongsToMany' => array(
    							  'Aro',
			)));
			 $this->User->bindModel(array(
 								'hasOne' => array(
    							  'Aro' =>array('foreignKey' => false,'conditions'=>
								  array('User.id = Aro.foreign_key and Aro.model = "User"' )))),false);
			if($aro_id!=null){
					 $this->User->unbindModel( array(
							'belongsTo'=>array('City','State','Country')
					 ));
					 $user  = $this->User->read(null,$aro_id);
						$this->Aco->bindModel(array(
								"hasMany" =>array(
									"AclArosAco"=>array("foreignKey"=>"aco_id")
								)
						));
					$roleAro  = $this->Aro->find("first",array("conditions"=>array("Aro.model" => "Role","Aro.foreign_key"=> $user['Role']['id'])));
					$modules = $this->Aco->find("all",array("conditions"=>array("Aco.parent_id = '1' and Aco.is_viewable = '1'  and Aco.is_permission_need ='1'"),'order'=>array('Aco.alias')));
					$this->getPermissionOfModuleBaseOnRole($modules,$user['Aro']['id'],"controller", $roleAro['Aro']['id']);
					$this->set('user', $user);
					$this->set('modules', $modules);
			 }
			$users = $this->User->find("all",array("conditions"=>
											array("(User.is_deleted = '0') and (Role.name !='superadmin' and
											Role.name !='admin')"),"group"=>"User.id",'order'=>array('User.first_name')));
			$this->set('users', $users);
			$this->set(compact('emer','aro_id'));
			//$this->Session->write('hospital_permission_mode',$hospitalMode);


	}
/**
		for deny a permission on particular aro id

	*/
	public function admin_assign_permission() {
		$this->layout = false;
		$this->Aco->bindModel(array(
					   "hasMany"=>array(
							'Child' => array(
								'className' => 'Aco',
								'foreignKey' => 'parent_id'  ,
								'conditions' =>array("Child.is_permission_need"=>"1")
								),
						),
			));
		$data["AclArosAco"]["hospital_mode"]= Configure::read('hospital_default_mode');
		
		$controller = $this->Aco->find("first",array("conditions"=>array("Aco.id"=> $this->request->data['aco']) ));
		 if($controller['Aco']['parent_id'] != "1"){
		 	  $this->AclArosAco->unBindModel(array('belongsTo'=>array('AclAro','AclAco'))); //Added by pankaj to remove error in "table aros not found for model AclAro "

			  $permission = $this->AclArosAco->find("first",
												array("conditions"=>
													array("AclArosAco.aro_id"=>$this->request->data['aro'],"AclArosAco.aco_id"=>$this->request->data['aco'],'AclArosAco.hospital_mode'=>$data["AclArosAco"]["hospital_mode"])));
			  $data["AclArosAco"]["aro_id"]= $this->request->data['aro'];
			  $data["AclArosAco"]["aco_id"]= $this->request->data['aco'];
			  $data["AclArosAco"]["_delete"]= "1";
			  $data["AclArosAco"]["_create"]= "1";
			  $data["AclArosAco"]["_read"]= "1";
			  $data["AclArosAco"]["_update"]= "1";
			  
				
			 if(is_array($permission))
				$this->AclArosAco->id = $permission["AclArosAco"]["id"];
			 else
				$this->AclArosAco->create();
			 $this->AclArosAco->save($data);
		 }else{
			 $this->PackagePermission->providePermission($this->request->data['aro'],$controller['Child'],"1");
		 }
		exit;
	}
	/**
		for deny a permission on particular aro id

	*/
	public function admin_deny_permission() {
	 
		 	$this->Aco->bindModel(array(
					   "hasMany"=>array(
							'Child' => array(
								'className' => 'Aco',
								'foreignKey' => 'parent_id'  ,
								'conditions' =>array("Child.is_permission_need"=>"1")
								),
						),
			));
		$controller = $this->Aco->find("first",array("conditions"=>array("Aco.id"=> $this->request->data['aco']) ));

		 if($controller['Aco']['parent_id'] != "1"){
		 		 $this->AclArosAco->unBindModel(array('belongsTo'=>array('AclAro','AclAco'))); //Added by pankaj to remove error in "table aros not found for model AclAro "

				 $permission = $this->AclArosAco->find("first",
													array("conditions"=>
														array("AclArosAco.aro_id"=>$this->request->data['aro'],"AclArosAco.aco_id"=>$this->request->data['aco'],"hospital_mode"=>Configure::read('hospital_default_mode'))));


				  $data["AclArosAco"]["aro_id"]= $this->request->data['aro'];
				  $data["AclArosAco"]["aco_id"]= $this->request->data['aco'];
				  $data["AclArosAco"]["_delete"]= "-1";
				  $data["AclArosAco"]["_create"]= "-1";
				  $data["AclArosAco"]["_read"]= "-1";
				  $data["AclArosAco"]["_update"]= "-1";
				  
				  
				if(is_array($permission))
					 $this->AclArosAco->id = $permission["AclArosAco"]["id"];
				else{
					$this->AclArosAco->create();
					$data["AclArosAco"]['hospital_mode'] = Configure::read('hospital_default_mode'); //set configured default mode.
				}

				 $this->AclArosAco->save($data);
		}else{
		 		$this->PackagePermission->providePermission($this->request->data['aro'],$controller['Child'],"-1");
		}
		exit;
	}
	/**
		For show the all action of a controller permission

	*/
    public function admin_screen_permission($aco_id = null,$aro_id = null,$roleAroID = null,$screen = "false",$packageid = null) {
			 $this->set('screen',$screen);
			 $this->set('packageid', $packageid );
			 $roleAro = null;
	  		 $this->Aro->unbindModel( array(
 								'hasAndBelongsToMany' => array(
    							  'Aco',
			)));
			$aro = $this->Aro->read(null,$aro_id);
			 if( $aro['Aro']['model'] == "Role"){
				 $this->Role->unbindModel( array(
									'hasMany' => array(
									  'User',
				)));
			}
	 		$this->$aro['Aro']['model']->bindModel(array(
 								'hasOne' => array(
    							  'Aro' =>array('foreignKey' => false,'conditions'=>
								  		array(''.$aro['Aro']['model'].'.id = Aro.foreign_key and Aro.model = "'.$aro['Aro']['model'].'"' )),
			)),false);
			if($aro_id!=null){
				 $this->Aco->unbindModel( array(
 								'hasAndBelongsToMany' => array(
    							  'Aro',
				)));
				$entity  = $this->$aro['Aro']['model']->read(null,$aro['Aro']['foreign_key']);
				$module  = $this->Aco->find("first",array("conditions"=>array("Aco.id = '".$aco_id."'") ));
				$this->Aco->bindModel(array(
						"hasMany" =>array(
							"AclArosAco"=>array("foreignKey"=>"aco_id"),
						)
				));
			 	$this->set('entity', $entity);
				$modules = $this->Aco->find("all",array("conditions"=>array("Aco.parent_id = '".$aco_id."' and Aco.is_permission_need ='1'") ));
				if($roleAroID !=null){
			 		$role   = $this->Aro->find("first",array("conditions"=>array("Aro.model" => "Role","Aro.foreign_key"=> $roleAroID)));
					$roleAro = $role['Aro']['id'];
					$this->set('roleAro', $roleAroID);
				}
				$this->getPermissionOfModuleBaseOnRole($modules,$aro['Aro']['id'],null,$roleAro);
			    $this->set('modules', $modules);
				$this->set('module', $module);
			 }
		  if( $aro['Aro']['model'] == "User"){
			$fieldname = "username";
			 $this->User->unbindModel(array('belongsTo'=>array('City','State','Country')));
			}else{
				$fieldname = "name";
				$this->Role->unbindModel(array('hasMany'=>array('User')));
			}
		  $entities = $this->$aro['Aro']['model']->find("all",
		  						 array("conditions"=>
										array("((".$aro['Aro']['model'].".location_id ='0' or ".$aro['Aro']['model'].".location_id = '".$this->Session->read('locationid')."')) and
										(Role.name !='superadmin' and Role.name !='admin')"),
										"group"=>$aro['Aro']['model'].".id",
		  						 		'order'=>array('Role.name')));
		$this->set('entities', $entities);
	}
/**
		Package Permission which combine some of controller

	*/
	public function admin_package_permission($aro = null){
			$this->Role->unbindModel( array(
											'hasMany' => array(
											  'User',
			 )));
			$this->User->unbindModel( array(
									'belongsTo'=>array('City','State','Country')
					 ));
			$this->User->bindModel(array(
										'hasOne' => array(
										  'Aro' =>array('foreignKey' => false,'conditions'=>
										  array('User.id = Aro.foreign_key and Aro.model = "User"' )))),false);
			$this->Role->bindModel(array(
										'hasOne' => array(
										  'Aro' =>array('foreignKey' => false,'conditions'=>array('Role.id = Aro.foreign_key and Aro.model = "Role"' )),
					)),false);
			$roles = $this->Role->find("all" ,array("conditions"=>
										 array("(Role.location_id = 0  OR Role.location_id = '".$this->Session->read('locationid')."') and (Role.name !='superadmin' and
														Role.name !='admin')"),'group'=>array('Role.id'),'order'=>"Role.name"));

		    $this->set('roles', $roles);

            $users = $this->User->find("all",array("conditions"=>
												array("(User.is_deleted = '0' and User.location_id = '".$this->Session->read('locationid')."') and (Role.name !='superadmin' and
												Role.name !='admin')"),"group"=>"User.id"));
			 $this->set('users', $users);
			 if($aro != null){
			 	$packages = $this->PackagePermission->find("all");
			  	$this->PackagePermission->getPermissionLevel($packages,$aro);
		     	$this->set('packages', $packages);
				$this->set('aro', $aro);
			}
	}

		/**
		Role permission

	*/
	public function admin_package_first_level($packageID = null,$aro_id = null) {
		 $this->set('packageid', $packageID );
		  $this->set('screen', "true" );
		 $this->Aro->unbindModel( array(
 								'hasAndBelongsToMany' => array(
    							  'Aco',
			)));

		 $package = $this->PackagePermission->read(null,$packageID);
		
		 $controllerAcoID = explode(",",$package['PackagePermission']['module_name']);
		 $aro = $this->Aro->read(null,$aro_id);
		 
		 $this->set('aro', $aro);
		 $this->Aco->unbindModel( array(
							'hasAndBelongsToMany' => array(
							  'Aro',
		 )));

			$modules = $this->Aco->find("all",array("conditions"=> array("Aco.id"=>$controllerAcoID,"Aco.parent_id"=>1,"Aco.is_permission_need"=>1)));
			$this->getPermissionOfModuleBaseOnRole($modules,$aro_id,"controller");
 			$this->set('modules', $modules);
			if($aro['Aro']['model']=='Role'){
					$this->Role->bindModel(array(
							'hasOne' => array(
							  'Aro' =>array('foreignKey' => false,'conditions'=>array('Role.id = Aro.foreign_key and Aro.model = "Role"' )),
					)),false);

        			$this->Role->unbindModel( array(
								'hasMany' => array(
								  'User',
					)));

				$role  = $this->Role->read(null,$aro['Aro']['foreign_key']);
				$this->set('role', $role);
				$this->Role->unbindModel( array(
								'hasMany' => array(
								  'User',
					)));
				$roles = $this->Role->find("all" ,array("conditions"=>
													array("(Role.location_id = 0  OR Role.location_id = '".$this->Session->read('facilityid')."') and (Role.name !='superadmin' and
													Role.name !='admin')")));
				$this->set('roles', $roles);
				$this->render('admin_role_permission');
			}else{
			    $this->User->bindModel(array(
 								'hasOne' => array(
    							  'Aro' =>array('foreignKey' => false,'conditions'=>
								  array('User.id = Aro.foreign_key and Aro.model = "User"' )))),false);

                $this->User->unbindModel( array(
						 'belongsTo'=>array('City','State','Country')
					  ));
				 $user  = $this->User->read(null,$aro['Aro']['foreign_key']);
				 $this->set('user', $user);
				 $users = $this->User->find("all",array("conditions"=>
										array("(User.location_id = '".$this->Session->read('locationid')."') and (Role.name !='superadmin' and
										Role.name !='admin')"),"group"=>"User.id"));
				 $this->set('users', $users);
				$this->render('admin_user_permission');
			}


	 }

	/**
		for assign complete package permission on particular aro id

	*/
	public function admin_assign_package_permission(){
	    $this->layout = false;
		$packages = $this->PackagePermission->find("first",array("conditions"=>
												array("PackagePermission.id"=>$this->request->data['aco'])));
		$controller = explode(",",$packages['PackagePermission']['module_name']);
		
		foreach($controller as $key => $value){
		  $this->Aco->bindModel(array(
						   "hasMany"=>array(

								'Child' => array(
									'className' => 'Aco',
									'foreignKey' => 'parent_id'  ,
									'conditions' =>array("Child.is_permission_need"=>"1")
        							),
							),
				));
		  $this->Aco->unbindModel(array(
						   "hasAndBelongsToMany"=>array('Aro'),
				));
		    
			$controller = $this->Aco->find("first",array("conditions"=>array("Aco.id"=> $value) ));
			
			 if($controller['Aco']['parent_id'] != "1"){
                $this->AclArosAco->belongsTo = array();
				  $permission = $this->AclArosAco->find("first",
													array("conditions"=>
														array("AclArosAco.aro_id"=>$this->request->data['aro'],"AclArosAco.aco_id"=>$controller['Aco']['id'])));
//pr($permission);exit;
				  $data["AclArosAco"]["aro_id"]= $this->request->data['aro'];
				  $data["AclArosAco"]["aco_id"]= $controller['Aco']['id'];
				  $data["AclArosAco"]["_delete"]= "1";
				  $data["AclArosAco"]["_create"]= "1";
				  $data["AclArosAco"]["_read"]= "1";
				  $data["AclArosAco"]["_update"]= "1";
				  
				 if(is_array($permission))
					$this->AclArosAco->id = $permission["AclArosAco"]["id"];
				 else
					$this->AclArosAco->create();
				 $this->AclArosAco->save($data);
		 	}else{ 
				$this->PackagePermission->providePermission($this->request->data['aro'],$controller['Child'],"1");
			}
		 }
		exit;
	}

	/**
		for deny complete package permission on particular aro id

	*/
	public function admin_deny_package_permission(){
	    $this->layout = false;
		  $this->Aco->bindModel(array(
						   "hasMany"=>array(

								'Child' => array(
									'className' => 'Aco',
									'foreignKey' => 'parent_id'  ,
									'conditions' =>array("Child.is_permission_need"=>"1")
        							),
							),
				));
		$packages = $this->PackagePermission->find("first",array("conditions"=>
												array("PackagePermission.id"=>$this->request->data['aco'])));
		$controller = explode(",",$packages['PackagePermission']['module_name']);
		foreach($controller as $key => $value){
			$controller = $this->Aco->find("first",array("conditions"=>array("Aco.id"=> $value) ));
				 if($controller['Aco']['parent_id'] != "1"){
				  $permission = $this->AclArosAco->find("first",
													array("conditions"=>
														array("AclArosAco.aro_id"=>$this->request->data['aro'],"AclArosAco.aco_id"=>$controller['Aco']['id'])));
				  $data["AclArosAco"]["aro_id"]= $this->request->data['aro'];
				  $data["AclArosAco"]["aco_id"]= $controller['Aco']['id'];
				  $data["AclArosAco"]["_delete"]= "-1";
				  $data["AclArosAco"]["_create"]= "-1";
				  $data["AclArosAco"]["_read"]= "-1";
				  $data["AclArosAco"]["_update"]= "-1";
				 if(is_array($permission))
					$this->AclArosAco->id = $permission["AclArosAco"]["id"];
				 else
					$this->AclArosAco->create();
				 $this->AclArosAco->save($data);
		 	}else{
				$this->PackagePermission->providePermission($this->request->data['aro'],$controller['Child'],"-1");
			}
		 }
		exit;
	}

	/* this method check the permission */
	private function getPermissionOfModuleBaseOnRole(&$modules,$aro_id,$for=null,$roleAroID = null){
			if($for == null){
				foreach($modules as $key => $value){
					$flag= false;
						foreach($value['AclArosAco'] as $k=>$v){

                        if($v['aro_id'] == $aro_id ){
								if(($v['_read'] == "1" && $v['_update'] =="1" ) && ($v['_create'] =="1" && $v['_delete'] =="1" )){
									 $flag = true;
								}else if(($v['_read'] == "-1" && $v['_update'] =="-1" ) && ($v['_create'] =="-1" && $v['_delete'] =="-1" )){
					             	 $flag = false;
					 			}
							}else if($roleAroID != null && $v['aro_id'] == $roleAroID){
								if(($v['_read'] == "1" && $v['_update'] =="1" ) && ($v['_create'] =="1" && $v['_delete'] =="1" )){
									 $flag = true;
								}else if(($v['_read'] == "-1" && $v['_update'] =="-1" ) && ($v['_create'] =="-1" && $v['_delete'] =="-1" )){
					             	 $flag = false;
					 			}
							}
						}
					if($flag == true)
						array_push($modules[$key],"true");
					else
						array_push($modules[$key],"false");
						unset($modules[$key]['AclArosAco']);
			 	}
			}else{
				$this->getControllerPermissionLevel($modules,$aro_id,$roleAroID);
			}
	}

	/**
		SHow  aco based permission

	*/
	private function getControllerPermissionLevel(&$modules,$aro_id,$roleAroID = null){
		$access = array();
		$hospitalMode = $this->Session->read('hospital_permission_mode');
		 foreach($modules as $k => $v ){
				 $access[$v['Aco']['id']] = array();
					 $this->Aco->bindModel(array(
						   "hasMany"=>array(
								'Child' => array(
									'className' => 'Aco',
									'foreignKey' => 'parent_id'  ,
									'conditions' =>array("Child.is_permission_need"=>"1")
        							),
									"AclArosAco"=>array(
										"foreignKey"=>"aco_id",
					 					'conditions' =>array("AclArosAco.hospital_mode"=> $hospitalMode)
										)
							),
				));
				$permission =  $this->Aco->find("first",array("conditions"=>array("Aco.id"=> $v['Aco']['id'] ) ));
				 foreach($permission['Child'] as $childk => $childv ){
					$child_action_permission =  $this->Aco->find("first",array("conditions"=>array("Aco.id"=> $childv['id'],"Aco.is_permission_need"=>1 ) ));
				 	if(count($child_action_permission['Aro'])==0){
						array_push($access[$v['Aco']['id']],"deny");
					}else{
						if($hospitalMode == $child_action_permission['Aro']['0']['Permission']['hospital_mode'])
							array_push($access[$v['Aco']['id']],$this->PackagePermission->checkPermission($child_action_permission['Aro'],$aro_id,$roleAroID));
					}
				 }
			  $result = array_unique($access[$v['Aco']['id']]);
			  if(count($result) == 0){
			 	 	$controller[$v['Aco']['id']] = "deny";
			  }else if(count($result) == 1){
					if($result[0] == "not"){
						$controller[$v['Aco']['id']]  = "not";
					}else if($result[0] == "full"){
						$controller[$v['Aco']['id']]  = "full";
					}else{
						$controller[$v['Aco']['id']] = "deny";
					}
			   }else{
					if ( in_array('full', $result) && in_array('deny', $result)) {
						$controller[$v['Aco']['id']] = "not";
					}else if (in_array('full', $result) && in_array('not', $result)) {
						 $controller[$v['Aco']['id']] = "not";
					}else if (in_array('deny', $result) && in_array('not', $result)) {
						$controller[$v['Aco']['id']] = "deny";
					}
	   		}
		} // first foreachclose
	#pr($controller);exit;
	   	$this->set('permission_on_module', $controller);
	 }
	 
	 //fucntion to add description
	 public function admin_add_acos_description(){
	 	$this->layout = ajax;
	 	$this->autoRender = false ;
	 	if($this->request->data['aco']){
	 		$this->Aco->save(array('id'=>$this->request->data['aco'],'desc'=>$this->request->data['desc']));
	 	}
	 }
}

?>