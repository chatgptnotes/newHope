<?php
/**
 *
 * @author   Nicolas Rod <nico@alaxos.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.alaxos.ch
 */
class ArosController extends AclAppController
{

	public $name       = 'Aros';
	public $uses       = array('Aro','Role','User','Aco');
	public $helpers    = array('Js' => array('Jquery'));
	

	
	public function beforeFilter()
	{
	   $userID = $this->Session->read("userid");
	 	if(!$userID){
			echo "<script>parent.window.location.href='/';</script>";exit;
		}
	    
	    parent :: beforeFilter();
	}
    
	public function admin_index()
	{
	    
	}
	
	public function admin_check($run = null)
	{
		$user_model_name = Configure :: read('acl.aro.user.model');
	    $role_model_name = Configure :: read('acl.aro.role.model');
	    
	    $user_display_field = $this->AclManager->set_display_name($user_model_name, Configure :: read('acl.user.display_name'));
	    $role_display_field = $this->AclManager->set_display_name($role_model_name, Configure :: read('acl.aro.role.display_field'));
	    
	    $this->set('user_display_field', $user_display_field);
	    $this->set('role_display_field', $role_display_field);
	    
		$roles = $this->{$role_model_name}->find('all', array('order' => $role_display_field, 'contain' => false, 'recursive' => -1));
	 	
		$missing_aros = array('roles' => array(), 'users' => array());
	    
		foreach($roles as $role)
		{
			/*
			 * Check if ARO for role exist
			 */
			$aro = $this->Aro->find('first', array('conditions' => array('model' => $role_model_name, 'foreign_key' => $role[$role_model_name][$this->_get_role_primary_key_name()])));
			
			if($aro === false)
			{
				$missing_aros['roles'][] = $role;
			}
		}
		
		$users = $this->{$user_model_name}->find('all', array('order' => $user_display_field, 'contain' => false, 'recursive' => -1));
		foreach($users as $user)
		{
			/*
			 * Check if ARO for user exist
			 */
			$aro = $this->Aro->find('first', array('conditions' => array('model' => $user_model_name, 'foreign_key' => $user[$user_model_name][$this->_get_user_primary_key_name()])));
			
			if($aro === false)
			{
				$missing_aros['users'][] = $user;
			}
		}
		
		
		if(isset($run))
		{
			$this->set('run', true);
			
			/*
			 * Complete roles AROs
			 */
			if(count($missing_aros['roles']) > 0)
			{
				foreach($missing_aros['roles'] as $k => $role)
				{
					$this->Aro->create(array('parent_id' 		=> null,
												'model' 		=> $role_model_name,
												'foreign_key' 	=> $role[$role_model_name][$this->_get_role_primary_key_name()],
												'alias'			=> $role[$role_model_name][$role_display_field]));
					
					if($this->Aro->save())
					{
						unset($missing_aros['roles'][$k]);
					}
				}
			}
			
			/*
			 * Complete users AROs
			 */
			if(count($missing_aros['users']) > 0)
			{
				foreach($missing_aros['users'] as $k => $user)
				{
					/*
					 * Find ARO parent for user ARO
					 */
					$parent_id = $this->Aro->field('id', array('model' => $role_model_name, 'foreign_key' => $user[$user_model_name][$this->_get_role_foreign_key_name()]));
					
					if($parent_id !== false)
					{
						$this->Aro->create(array('parent_id' 		=> $parent_id,
													'model' 		=> $user_model_name,
													'foreign_key' 	=> $user[$user_model_name][$this->_get_user_primary_key_name()],
													'alias'			=> $user[$user_model_name][$user_display_field]));
						
						if($this->Aro->save())
						{
							unset($missing_aros['users'][$k]);
						}
					}
				}
			}
		}
		else
		{
			$this->set('run', false);
		}
		
		$this->set('missing_aros', $missing_aros);
		
	}
	
	public function admin_users()
	{
	    $user_model_name = Configure :: read('acl.aro.user.model');
	    $role_model_name = Configure :: read('acl.aro.role.model');
	    
	    $user_display_field = $this->AclManager->set_display_name($user_model_name, Configure :: read('acl.user.display_name'));
	    $role_display_field = $this->AclManager->set_display_name($role_model_name, Configure :: read('acl.aro.role.display_field'));
	    
	    $this->paginate['order'] = array($user_display_field => 'asc');
	    
	    $this->set('user_display_field', $user_display_field);
	    $this->set('role_display_field', $role_display_field);
	    
	    $this->{$role_model_name}->recursive = -1;
	    $roles = $this->{$role_model_name}->find('all', array('order' => $role_display_field, 'contain' => false, 'recursive' => -1));
	 
	    $this->{$user_model_name}->recursive = -1;
	    
	    if(isset($this->request->data['User'][$user_display_field]) || $this->Session->check('acl.aros.users.filter'))
	    {
	        if(!isset($this->request->data['User'][$user_display_field]))
	        {
	            $this->request->data['User'][$user_display_field] = $this->Session->read('acl.aros.users.filter');
	        }
	        else
	        {
	            $this->Session->write('acl.aros.users.filter', $this->request->data['User'][$user_display_field]);
	        }
	        
	        $filter = array($user_model_name . '.' . $user_display_field . ' LIKE' => '%' . $this->request->data['User'][$user_display_field] . '%');
	    }
	    else
	    {
	        $filter = array();
	    }
	    
	    $users = $this->paginate($user_model_name, $filter);
	    
	    $missing_aro = false;
	    
	    foreach($users as &$user)
	    {
	    	$aro = $this->Acl->Aro->find('first', array('conditions' => array('model' => $user_model_name, 'foreign_key' => $user[$user_model_name][$this->_get_user_primary_key_name()])));
	    	
	        if($aro !== false)
	        {
	            $user['Aro'] = $aro['Aro'];
	        }
	        else
	        {
	            $missing_aro = true;
	        }
	    }
	    
	    $this->set('roles', $roles);
	    $this->set('users', $users);
	    $this->set('missing_aro', $missing_aro);
	}
	
	public function admin_update_user_role()
	{
	    $user_model_name = Configure :: read('acl.aro.user.model');
	    
        $data = array($user_model_name => array($this->_get_user_primary_key_name() => $this->params['named']['user'], $this->_get_role_foreign_key_name() => $this->params['named']['role']));
	    
	    if($this->{$user_model_name}->save($data))
	    {
	        $this->Session->setFlash(__d('acl', 'The user role has been updated', true), 'flash_message', null, 'plugin_acl');
	    }
	    else
	    {
	        $errors = array_merge(array(__d('acl', 'The user role could not be updated', true)), $this->{$user_model_name}->validationErrors);
	        $this->Session->setFlash($errors, 'flash_error', null, 'plugin_acl');
	    }

	    $this->_return_to_referer();
	}
	
	public function admin_ajax_role_permissions()
	{
		$this->loadModel('AclArosAco');
		$role_model_name = Configure :: read('acl.aro.role.model');
	    
		$role_display_field = $this->AclManager->set_display_name($role_model_name, Configure :: read('acl.aro.role.display_field'));
	    
	    $this->set('role_display_field', $role_display_field);
	    
	    $this->{$role_model_name}->recursive = -1;
	    $roles = $this->{$role_model_name}->find('all', array('conditions' =>'Role.name <>\'admin\' and Role.name <>\'superadmin\' and Role.is_deleted<>1' ),array('order' => $role_display_field, 'contain' => false, 'recursive' => -1));
		foreach($roles as $key=>$value)
		{
		 $aro = $this->Aro->find('first', array(
					'conditions' => array(
						'Aro.model' => 'Role',
						'Aro.foreign_key' => $value['Role']['id'],
					),
					'recursive' => -1,
				));
			 $perm = $this->AclArosAco->find('count', array(
					'conditions' => array(
						'AclArosAco.aro_id' => $aro['Aro']['id'],
						'AclArosAco.aco_id' => '1',
						   'AclArosAco._create' => 1,
							'AclArosAco._read' => 1,
							'AclArosAco._update' => 1,
							'AclArosAco._delete' => 1,
					),
					'recursive' => -1,
				));	
				if($perm==1){
					$roles[$key]['Role']['is_all_permssion'] ="1";
				}else{
					$roles[$key]['Role']['is_all_permssion'] ="0";
				}
				
				
	}
	
	    $actions = $this->AclReflector->get_all_actions();
	    
	    $methods = array();
		foreach($actions as $full_action)
    	{
	    	$arr = String::tokenize($full_action, '/');
	    	
			if (count($arr) == 2)
			{
				$plugin_name     = null;
				$controller_name = $arr[0];
				$action          = $arr[1];
			}
			elseif(count($arr) == 3)
			{
				$plugin_name     = $arr[0];
				$controller_name = $arr[1];
				$action          = $arr[2];
			}
			
    		if(isset($plugin_name))
            {
            	$methods['plugin'][$plugin_name][$controller_name][] = array('name' => $action);
            }
            else
            {
        	    $methods['app'][$controller_name][] = array('name' => $action);
            }
    	}
    	
	    $this->set('roles', $roles);
	    $this->set('actions', $methods);
	}
	public function admin_module_permssion(){
		$this->layout = false;
		$action_desc = array();
		$controller_name = $this->request->query['controller_name'];
		$role_model_name = Configure :: read('acl.aro.role.model');
		
	    $role_display_field = $this->AclManager->set_display_name($role_model_name, Configure :: read('acl.aro.role.display_field'));
	    
	    $this->set('role_display_field', $role_display_field);
	    
	    $this->{$role_model_name}->recursive = -1;
	    $roles = $this->{$role_model_name}->find('all',  array('conditions' =>'Role.name <>\'admin\' and Role.name <>\'superadmin\'' ),array('order' => $role_display_field, 'contain' => false, 'recursive' => -1));
	 
	    //$ctrl_cleaned_methods = $this->AclReflector->get_controller_actions($controller_name);
				 $controller = $this->Aco->find('first', array(
					'conditions' => array(
						'Aco.alias' => $controller_name,					
					),
					'recursive' => -1,
				));
            // $ctrl_cleaned_methods = $this->AclReflector->get_controller_actions($controller_name);
				 $ctrl_cleaned_methods = $this->Aco->find("all",array(
					'conditions' => array(
						'Aco.parent_id' => $controller['Aco']['id'],
						'Aco.is_viewable' => '1',
					
					)));
			foreach($ctrl_cleaned_methods as $action)
			{
				$actions[] = $controller_name . '/' . $action['Aco']['alias'];
			}
	      
	    $permissions = array();
	    $methods     = array();
	    
	    foreach($actions as $full_action)
    	{
	    	$arr = String::tokenize($full_action, '/');
	    	
			if (count($arr) == 2)
			{
				$plugin_name     = null;
				$controller_name = $arr[0];
				$action          = $arr[1];
			}
			elseif(count($arr) == 3)
			{
				$plugin_name     = $arr[0];
				$controller_name = $arr[1];
				$action          = $arr[2];
			}
    		
		    foreach($roles as $role)
	    	{
	    	    $aro_node = $this->Acl->Aro->node($role);
	            if(!empty($aro_node))
	            {
	            	$aco_node = $this->Acl->Aco->node($full_action);
	        	    if(!empty($aco_node))
	        	    {
	        	    	$authorized = $this->Acl->check($role, $full_action);
	        	    	
	        	    	$permissions[$role[Configure :: read('acl.aro.role.model')][$this->_get_role_primary_key_name()]] = $authorized ? 1 : 0 ;
					}
	            }
	    		else
        	    {
        	        /*
        	         * No check could be done as the ARO is missing
        	         */
        	        $permissions[$role[Configure :: read('acl.aro.role.model')][$this->_get_role_primary_key_name()]] = -1;
        	    }
    		}
    		
    		if(isset($plugin_name))
            {
            	$methods['plugin'][$plugin_name][$controller_name][] = array('name' => $action, 'permissions' => $permissions);
            }
            else
            {
        	    $methods['app'][$controller_name][] = array('name' => $action, 'permissions' => $permissions);
            }
    	}
 		foreach($methods['app'] as $controller_name => $ctrl_infos){	
			foreach($ctrl_infos as $ctrl_info)			
			{	
			
				$controller = $this->Aco->find('first', array('conditions' => array('alias' => $controller_name)));
				$action_detail = $this->Aco->find('first', array('conditions' => array('parent_id' => $controller['Aco']['id'],'alias'=>$ctrl_info['name'])));
				
			$action_desc[$controller_name][$ctrl_info['name']]['label'] = $action_detail['Aco']['label'];
			$action_desc[$controller_name][$ctrl_info['name']]['desc'] = $action_detail['Aco']['desc'];
			}
			
		}
		
	    $this->set('roles', $roles);
	    $this->set('actions', $methods);
		 $this->set('controller_name', $controller_name);
		 $this->set('action_desc', $action_desc);
	
	}
	public function admin_role_permissions()
	{$this->loadModel('AclArosAco');
	    $role_model_name = Configure :: read('acl.aro.role.model');
	    
	    $role_display_field = $this->AclManager->set_display_name($role_model_name, Configure :: read('acl.aro.role.display_field'));
	    
	    $this->set('role_display_field', $role_display_field);
	    
	    $this->{$role_model_name}->recursive = -1;
	    $roles = $this->{$role_model_name}->find('all',  array('conditions' =>'Role.name <>\'admin\' and Role.name <>\'superadmin\' and Role.is_deleted<>1' ),array('order' => $role_display_field, 'contain' => false, 'recursive' => -1));
	 
	    //$actions = $this->AclReflector->get_all_actions();
	    foreach($roles as $key=>$value)
		{
		 $aro = $this->Aro->find('first', array(
					'conditions' => array(
						'Aro.model' => 'Role',
						'Aro.foreign_key' => $value['Role']['id'],
					),
					'recursive' => -1,
				));
			 $perm = $this->AclArosAco->find('count', array(
					'conditions' => array(
						'AclArosAco.aro_id' => $aro['Aro']['id'],
						'AclArosAco.aco_id' => '1',
						   'AclArosAco._create' => 1,
							'AclArosAco._read' => 1,
							'AclArosAco._update' => 1,
							'AclArosAco._delete' => 1,
					),
					'recursive' => -1,
				));	
				if($perm==1){
					$roles[$key]['Role']['is_all_permssion'] ="1";
				}else{
					$roles[$key]['Role']['is_all_permssion'] ="0";
				}
				
				
	}
	    $permissions = array();
	    $methods     = array();
	    $controllers = $this->Aco->find('all', array(
					'conditions' => array(
						'Aco.parent_id' => '1',
						'Aco.is_viewable' => '1'
					
					),
					'recursive' => -1,
				));
	   /* foreach($actions as $full_action)
    	{
	    	$arr = String::tokenize($full_action, '/');
	    	
			if (count($arr) == 2)
			{
				$plugin_name     = null;
				$controller_name = $arr[0];
				$action          = $arr[1];
			}
			elseif(count($arr) == 3)
			{
				$plugin_name     = $arr[0];
				$controller_name = $arr[1];
				$action          = $arr[2];
			}
    		
		    foreach($roles as $role)
	    	{
	    	    $aro_node = $this->Acl->Aro->node($role);
	            if(!empty($aro_node))
	            {
	            	$aco_node = $this->Acl->Aco->node($full_action);
	        	    if(!empty($aco_node))
	        	    {
	        	    	$authorized = $this->Acl->check($role, $full_action);
	        	    	
	        	    	$permissions[$role[Configure :: read('acl.aro.role.model')][$this->_get_role_primary_key_name()]] = $authorized ? 1 : 0 ;
					}
	            }
	    		else
        	    {
        	        /*
        	         * No check could be done as the ARO is missing
        	         */
        	      /*  $permissions[$role[Configure :: read('acl.aro.role.model')][$this->_get_role_primary_key_name()]] = -1;
        	    }
    		}*/
    		
    	/*	if(isset($plugin_name))
            {
            	$methods['plugin'][$plugin_name][$controller_name][] = array('name' => $action, 'permissions' => $permissions);
            }
            else
            {
        	    $methods['app'][$controller_name][] = array('name' => $action, 'permissions' => $permissions);
            }
    	}*/
 		
	    $this->set('roles', $roles);
	    $this->set('controllers', $controllers);
	}
	public function admin_permission_on_module(){
	$this->layout = false;
	$result = '';
		$controller_name = $this->params->query['controller_name'];
		
			 $role = $this->Acl->Aro->find('first', array(
                    'conditions' => array(
                        'Aro.foreign_key' => $this->params->query['role'],
                        'Aro.model' => "Role",						
                    ),
                  
                    'recursive' => '-1',
                ));
		 $controller = $this->Acl->Aco->find('first', array(
                    'conditions' => array(
                        'Aco.alias' => $controller_name,
                    ),
                  
                    'recursive' => '-1',
                ));
		
		 $thisControllerActions = $this->Acl->Aco->find('all', array(
                    'conditions' => array(
                        'Aco.parent_id' => $controller['Aco']['id'],
                    ),
                   
                    'recursive' => '-1',
                ));
			foreach($thisControllerActions as $k ){
				
			$action = $this->Acl->Aco->Permission->find('first', array(
                    'conditions' => array(
                        'Permission.aro_id' => $role['Aro']['id'],
                        'Permission.aco_id' => $k['Aco']['id'],
                        'Permission._create' => 1,
                        'Permission._read' => 1,
                        'Permission._update' => 1,
                        'Permission._delete' => 1,
                    ),
                  
                ));
				$arr = array('aro_id'=>$role['Aro']['id'],'aco_id'=>$k['Aco']['id'],'_create'=>1,'_read'=>1,'_update'=>1,'_delete'=>1);
			
					if(count($action)>0){
						$this->Acl->Aco->Permission->id=$action['Permission']['id'];
					
						 $this->Acl->Aco->Permission->save($arr); 
					
					}else{
						
						 $this->Acl->Aco->Permission->save($arr); 
					}
				
			
		  }
		  echo "1";
		  exit;
	
	}
	public function admin_module_user_permssion($user_id = null,$controller_name = null){
		$this->layout = false;
		$action_desc = array();
		$user_model_name = Configure :: read('acl.aro.user.model');
	    $role_model_name = Configure :: read('acl.aro.role.model');
	    $user_display_field = $this->AclManager->set_display_name($user_model_name, Configure :: read('acl.user.display_name'));
	    
	    $this->paginate['order'] = array($user_display_field => 'asc');
	    $this->set('user_display_field', $user_display_field);
	    
	    if(empty($user_id))
	    {
    	    if(isset($this->request->data['User'][$user_display_field]) || $this->Session->check('acl.aros.user_permissions.filter'))
    	    {
    	        if(!isset($this->request->data['User'][$user_display_field]))
    	        {
    	            $this->request->data['User'][$user_display_field] = $this->Session->read('acl.aros.user_permissions.filter');
    	        }
    	        else
    	        {
    	            $this->Session->write('acl.aros.user_permissions.filter', $this->request->data['User'][$user_display_field]);
    	        }
    	        
    	        $filter = array($user_model_name . '.' . $user_display_field . ' LIKE' => '%' . $this->request->data['User'][$user_display_field] . '%');
    	    }
    	    else
    	    {
    	        $filter = array();
    	    }
	        
	        $users = $this->paginate($user_model_name, $filter);
	        
	        $this->set('users', $users);
	    }
	    else
	    {
	    	$role_display_field = $this->AclManager->set_display_name($role_model_name, Configure :: read('acl.aro.role.display_field'));
	    
	    	$this->set('role_display_field', $role_display_field);
	    
	        $this->{$role_model_name}->recursive = -1;
	        $roles = $this->{$role_model_name}->find('all', array('order' => $role_display_field, 'contain' => false, 'recursive' => -1));
	 		
	        $this->{$user_model_name}->recursive = -1;
	        $user = $this->{$user_model_name}->read(null, $user_id);
	        
	        $permissions = array();
	    	$methods     = array();
	    		
	        /*
             * Check if the user exists in the ARO table
             */
            $user_aro = $this->Acl->Aro->node($user);
            if(empty($user_aro))
            {
                $display_user = $this->{$user_model_name}->find('first', array('conditions' => array($user_model_name . '.id' => $user_id, 'contain' => false, 'recursive' => -1)));
                $this->Session->setFlash(sprintf(__d('acl', "The user '%s' does not exist in the ARO table", true), $display_user[$user_model_name][$user_display_field]), 'flash_error', null, 'plugin_acl');
            }
            else
            {
              $controller = $this->Aco->find('first', array(
					'conditions' => array(
						'Aco.alias' => $controller_name,					
					),
					'recursive' => -1,
				));
            // $ctrl_cleaned_methods = $this->AclReflector->get_controller_actions($controller_name);
				 $ctrl_cleaned_methods = $this->Aco->find("all",array(
					'conditions' => array(
						'Aco.parent_id' => $controller['Aco']['id'],
						'Aco.is_viewable' => '1'
					
					)));
					
			foreach($ctrl_cleaned_methods as $action)
			{
				$actions[] = $controller_name . '/' . $action['Aco']['alias'];
			}
            	
        		
	            foreach($actions as $full_action)
		    	{
			    	$arr = String::tokenize($full_action, '/');
			    	
					if (count($arr) == 2)
					{
						$plugin_name     = null;
						$controller_name = $arr[0];
						$action          = $arr[1];
					}
					elseif(count($arr) == 3)
					{
						$plugin_name     = $arr[0];
						$controller_name = $arr[1];
						$action          = $arr[2];
					}

					if(!isset($this->params['named']['ajax']))
					{
    		    		$aco_node = $this->Acl->Aco->node($full_action);
    	        	    if(!empty($aco_node))
    	        	    {
    	        	    	$authorized = $this->Acl->check($user, $full_action);

    	        	    	$permissions[$user[$user_model_name][$this->_get_user_primary_key_name()]] = $authorized ? 1 : 0 ;
    					}
					}
					
			    	if(isset($plugin_name))
		            {
		            	$methods['plugin'][$plugin_name][$controller_name][] = array('name' => $action, 'permissions' => $permissions);
		            }
		            else
		            {
		        	    $methods['app'][$controller_name][] = array('name' => $action, 'permissions' => $permissions);
		            }
		    	}
		    	
		    	/*
		    	 * Check if the user has specific permissions
		    	 */
		    	$count = $this->Aro->Permission->find('count', array('conditions' => array('Aro.id' => $user_aro[0]['Aro']['id'])));
		    	if($count != 0)
		    	{
		    	    $this->set('user_has_specific_permissions', true);
		    	}
		    	else
		    	{
		    	    $this->set('user_has_specific_permissions', false);
		    	}
            }
			foreach($methods['app'] as $controller_name => $ctrl_infos){	
			foreach($ctrl_infos as $ctrl_info)			
			{	
			
				$controller = $this->Aco->find('first', array('conditions' => array('alias' => $controller_name)));
				$action_detail = $this->Aco->find('first', array('conditions' => array('parent_id' => $controller['Aco']['id'],'alias'=>$ctrl_info['name'])));
				
			$action_desc[$controller_name][$ctrl_info['name']]['label'] = $action_detail['Aco']['label'];
			$action_desc[$controller_name][$ctrl_info['name']]['desc'] = $action_detail['Aco']['desc'];
			}
			
		}
			 $this->set('action_desc', $action_desc);
            $this->set('user', $user);
            $this->set('roles', $roles);
            $this->set('actions', $methods);	
			
            if(isset($this->params['named']['ajax']))
            {
                $this->render('admin_ajax_user_permissions');
            }
	    }
	
	
	
	}
	public function admin_user_permissions($user_id = null)
	{
	    $user_model_name = Configure :: read('acl.aro.user.model');
	    $role_model_name = Configure :: read('acl.aro.role.model');
	    
	    $user_display_field = $this->AclManager->set_display_name($user_model_name, Configure :: read('acl.user.display_name'));
	    
	   
	    $this->set('user_display_field', $user_display_field);
	    
	    if(empty($user_id))
	    {
    	    if(isset($this->params->query['username']))
    	    {
    	      
    	        
    	        $filter[$user_model_name . '.username LIKE '] = "%".$this->params->query['username']."%" ;
    	    }
    	    else
    	    {
    	        $filter = array();
    	    }
			 		 $filter['Role.name <>'] = 'admin';
				    $filter['Role.name !='] = 'superadmin';
					$filter['User.is_deleted <>'] ="1";
	       		if($this->Session->read("facilityid")){
					# $filter['User.facility_id'] =$this->Session->read("facilityid");
				}
			$this->paginate = array(
			'limit' => Configure::read('number_of_rows'),
			
			
		);
		
	        $users = $this->paginate($user_model_name, $filter);
	        
	        $this->set('users', $users);
	    }
	    else
	    {
	    	$role_display_field = $this->AclManager->set_display_name($role_model_name, Configure :: read('acl.aro.role.display_field'));
	    
	    	$this->set('role_display_field', $role_display_field);
	    
	        $this->{$role_model_name}->recursive = -1;
	        $roles = $this->{$role_model_name}->find('all', array('order' => $role_display_field, 'contain' => false, 'recursive' => -1));
	 		
	        $this->{$user_model_name}->recursive = -1;
	        $user = $this->{$user_model_name}->read(null, $user_id);
	        
	        $permissions = array();
	    	$methods     = array();
	    		
	        /*
             * Check if the user exists in the ARO table
             */
            $user_aro = $this->Acl->Aro->node($user);
            if(empty($user_aro))
            {
                $display_user = $this->{$user_model_name}->find('first', array('conditions' => array($user_model_name . '.id' => $user_id, 'contain' => false, 'recursive' => -1)));
                $this->Session->setFlash(sprintf(__d('acl', "The user '%s' does not exist in the ARO table", true), $display_user[$user_model_name][$user_display_field]), 'flash_error', null, 'plugin_acl');
            }
            else
            {
            	$actions = $this->AclReflector->get_all_actions();
        		
	            foreach($actions as $full_action)
		    	{
			    	$arr = String::tokenize($full_action, '/');
			    	
					if (count($arr) == 2)
					{
						$plugin_name     = null;
						$controller_name = $arr[0];
						$action          = $arr[1];
					}
					elseif(count($arr) == 3)
					{
						$plugin_name     = $arr[0];
						$controller_name = $arr[1];
						$action          = $arr[2];
					}

					if(!isset($this->params['named']['ajax']))
					{
    		    		$aco_node = $this->Acl->Aco->node($full_action);
    	        	    if(!empty($aco_node))
    	        	    {
    	        	    	$authorized = $this->Acl->check($user, $full_action);

    	        	    	$permissions[$user[$user_model_name][$this->_get_user_primary_key_name()]] = $authorized ? 1 : 0 ;
    					}
					}
					
			    	if(isset($plugin_name))
		            {
		            	$methods['plugin'][$plugin_name][$controller_name][] = array('name' => $action, 'permissions' => $permissions);
		            }
		            else
		            {
		        	    $methods['app'][$controller_name][] = array('name' => $action, 'permissions' => $permissions);
		            }
		    	}
		    	
		    	/*
		    	 * Check if the user has specific permissions
		    	 */
		    	$count = $this->Aro->Permission->find('count', array('conditions' => array('Aro.id' => $user_aro[0]['Aro']['id'])));
		    	if($count != 0)
		    	{
		    	    $this->set('user_has_specific_permissions', true);
		    	}
		    	else
		    	{
		    	    $this->set('user_has_specific_permissions', false);
		    	}
            }
			  $controllers = $this->Aco->find('all', array(
					'conditions' => array(
						'Aco.parent_id' => '1',
						'Aco.is_viewable' => '1'
					
					),
					'recursive' => -1,
				));
			 $this->set('controllers', $controllers);
            $this->set('user', $user);
            $this->set('roles', $roles);
            $this->set('actions', $methods);	
			$url = explode("/",$this->request->url);
			$this->set('a_path', $this->request->base."/".$url[0]."/".$url[1]."/".$url[2]);
            if(isset($this->params['named']['ajax']))
            {
                $this->render('admin_ajax_user_permissions');
            }
	    }
	}

	public function admin_empty_permissions()
	{
	    if($this->Aro->Permission->deleteAll(array('Permission.id > ' => 0)))
	    {
	        $this->Session->setFlash(__d('acl', 'The permissions have been cleared', true), 'flash_message', null, 'plugin_acl');
	    }
	    else
	    {
	        $this->Session->setFlash(__d('acl', 'The permissions could not be cleared', true), 'flash_error', null, 'plugin_acl');
	    }
	    
	    $this->_return_to_referer();
	}
	
	public function admin_clear_user_specific_permissions($user_id)
	{
	    $user =& $this->{Configure :: read('acl.aro.user.model')};
	    $user->id = $user_id;
	    
	    /*
         * Check if the user exists in the ARO table
         */
        $node = $this->Acl->Aro->node($user);
        if(empty($node))
        {
            $asked_user = $user->read(null, $user_id);
            $this->Session->setFlash(sprintf(__d('acl', "The user '%s' does not exist in the ARO table", true), $asked_user['User'][Configure :: read('acl.user.display_name')]), 'flash_error', null, 'plugin_acl');
        }
        else
        {
            if($this->Aro->Permission->deleteAll(array('Aro.id' => $node[0]['Aro']['id'])))
    	    {
    	        $this->Session->setFlash(__d('acl', 'The specific permissions have been cleared', true), 'flash_message', null, 'plugin_acl');
    	    }
    	    else
    	    {
    	        $this->Session->setFlash(__d('acl', 'The specific permissions could not be cleared', true), 'flash_error', null, 'plugin_acl');
    	    }
        }
        
	    $this->_return_to_referer();
	}
	
	public function admin_grant_all_controllers($role_id)
	{
	    $role =& $this->{Configure :: read('acl.aro.role.model')};
        $role->id = $role_id;
        
		/*
         * Check if the Role exists in the ARO table
         */
        $node = $this->Acl->Aro->node($role);
        if(empty($node))
        {
            $asked_role = $role->read(null, $role_id);
            $this->Session->setFlash(sprintf(__d('acl', "The role '%s' does not exist in the ARO table", true), $asked_role['Role'][Configure :: read('acl.aro.role.display_field')]), 'flash_error', null, 'plugin_acl');
        }
        else
        {
            //Allow to everything
            $this->Acl->allow($role, 'controllers');
        }
        
	    $this->_return_to_referer();
	}
	public function admin_deny_all_controllers($role_id)
	{
	    $role =& $this->{Configure :: read('acl.aro.role.model')};
        $role->id = $role_id;
        
        /*
         * Check if the Role exists in the ARO table
         */
        $node = $this->Acl->Aro->node($role);
        if(empty($node))
        {
            $asked_role = $role->read(null, $role_id);
            $this->Session->setFlash(sprintf(__d('acl', "The role '%s' does not exist in the ARO table", true), $asked_role['Role'][Configure :: read('acl.aro.role.display_field')]), 'flash_error', null, 'plugin_acl');
        }
        else
        {
            //Deny everything
            $this->Acl->deny($role, 'controllers');
        }
        
	    $this->_return_to_referer();
	}
	
	public function admin_get_role_controller_permission($role_id)
	{	$this->layout = false;
		$role =& $this->{Configure :: read('acl.aro.role.model')};
        
        $role_data = $role->read(null, $role_id);
        
        $aro_node = $this->Acl->Aro->node($role_data);
        if(!empty($aro_node))
        {
	        $plugin_name        = $this->params['named']['plugin'];
	        $controller_name    = $this->params['named']['controller'];
	        $controller_actions = $this->AclReflector->get_controller_actions($controller_name);
	        
	        $role_controller_permissions = array();
	        
	        foreach($controller_actions as $action_name)
	        {
	        	$aco_path  = $plugin_name;
		        $aco_path .= empty($aco_path) ? $controller_name : '/' . $controller_name;
		        $aco_path .= '/' . $action_name;
		        
		        $aco_node = $this->Acl->Aco->node($aco_path);
        	    if(!empty($aco_node))
        	    {
        	        $authorized = $this->Acl->check($role_data, $aco_path);
        	        $role_controller_permissions[$action_name] = $authorized;
        	    }
        	    else
        	    {
        	        $role_controller_permissions[$action_name] = -1;
        	    }
	        }
	    }
		else
        {
        	//$this->set('acl_error', true);
            //$this->set('acl_error_aro', true);
        }
        
		if($this->request->is('ajax'))
        {
        	Configure::write('debug', 0); //-> to disable printing of generation time preventing correct JSON parsing
        	echo json_encode($role_controller_permissions);
        	$this->autoRender = false;
        }
        else
        {
            $this->_return_to_referer();
        }
	}
	public function admin_grant_role_permission($role_id)
	{
	    $role =& $this->{Configure :: read('acl.aro.role.model')};
        
        $role->id = $role_id;
        
        $aco_path = $this->_get_passed_aco_path();
        
        /*
         * Check if the role exists in the ARO table
         */
        $aro_node = $this->Acl->Aro->node($role);
        if(!empty($aro_node))
        {
            if(!$this->AclManager->save_permission($aro_node, $aco_path, 'grant'))
            {
                $this->set('acl_error', true);
            }
        }
        else
        {
            $this->set('acl_error', true);
            $this->set('acl_error_aro', true);
        }
        
        $this->set('role_id', $role_id);
        $this->_set_aco_variables();
        
        if($this->request->is('ajax'))
        {
            $this->render('ajax_role_granted');
        }
        else
        {
            $this->_return_to_referer();
        }
	}
	public function admin_deny_role_permission($role_id)
	{
	    $role =& $this->{Configure :: read('acl.aro.role.model')};
        
        $role->id = $role_id;
        
        $aco_path = $this->_get_passed_aco_path();
        
        $aro_node = $this->Acl->Aro->node($role);
        if(!empty($aro_node))
        {
            if(!$this->AclManager->save_permission($aro_node, $aco_path, 'deny'))
            {
                $this->set('acl_error', true);
            }
        }
        else
        {
        	$this->set('acl_error', true);
        }
        
        $this->set('role_id', $role_id);
        $this->_set_aco_variables();
        
        if($this->request->is('ajax'))
        {
            $this->render('ajax_role_denied');
        }
        else
        {
            $this->_return_to_referer();
        }
	}

	public function admin_get_user_controller_permission($user_id)
	{
        $user =& $this->{Configure :: read('acl.aro.user.model')};

	    $user_data = $user->read(null, $user_id);
		$roleAroId = $this->Acl->Aro->find('first', array(
                    'conditions' => array(
                        'Aro.model' => 'Role',
                        'Aro.foreign_key' =>$user_data['Role']['id']
                    )
                ));		
        $aro_node = $this->Acl->Aro->node($user_data);
        if(!empty($aro_node))
        {
	        $plugin_name        = $this->params['named']['plugin'];
	        $controller_name    = $this->params['named']['controller'];
	        $controller_actions = $this->AclReflector->get_controller_actions($controller_name);
	        $user_controller_permissions = array();
	        foreach($controller_actions as $action_name)
	        {
	        	$aco_path  = $plugin_name;
		        $aco_path .= empty($aco_path) ? $controller_name : '/' . $controller_name;
		        $aco_path .= '/' . $action_name;

		        $aco_node = $this->Acl->Aco->node($aco_path);
				$acoID = $aco_node['0']['Aco']['id'];
        	    if(!empty($aco_node))
        	    {
        	        $authorized = $this->Acl->check($user_data, $aco_path);
					  if(!$authorized){
							$perm = $this->Acl->Aro->Permission->find('first', array(
								'conditions' => array(
									'Permission.aro_id' => $aro_node['0']['Aro']['id'],
									'Permission.aco_id' => $acoID,
									'Permission._create' => '-1',
									'Permission._read' => '-1',
									'Permission._update' => '-1',
									'Permission._delete' => '-1',
								),
							 ));
							if($perm){
								 $user_controller_permissions[$action_name] = false;
							}else{
								
								$perm = $this->Acl->Aro->Permission->find('first', array(
									'conditions' => array(
										'Permission.aro_id' => $roleAroId['Aro']['id'],
										'Permission.aco_id' => $acoID,
										'Permission._create' => '1',
										'Permission._read' => '1',
										'Permission._update' => '1',
										'Permission._delete' => '1',
									),
								 ));
							
								if($perm){
									 $user_controller_permissions[$action_name] = true;
								 }else{
									 $user_controller_permissions[$action_name] = false;
								 }
							 }
						}else{
							 $user_controller_permissions[$action_name] = $authorized;
						}
        	    }
        	    else
        	    {
        	        $user_controller_permissions[$action_name] = -1;
        	    }
	        }
	    }
		else
        {
        	//$this->set('acl_error', true);
            //$this->set('acl_error_aro', true);
        }

		if($this->request->is('ajax'))
        {
        	Configure::write('debug', 0); //-> to disable printing of generation time preventing correct JSON parsing
        	echo json_encode($user_controller_permissions);
        	$this->autoRender = false;
        }
        else
        {
            $this->_return_to_referer();
        }
	}
	public function admin_grant_user_permission($user_id)
	{
	    $user =& $this->{Configure :: read('acl.aro.user.model')};
        
        $user->id = $user_id;

        $aco_path = $this->_get_passed_aco_path();
        
        /*
         * Check if the user exists in the ARO table
         */
        $aro_node = $this->Acl->Aro->node($user);
        if(!empty($aro_node))
        {
        	$aco_node = $this->Acl->Aco->node($aco_path);
        	if(!empty($aco_node))
        	{
	            if(!$this->AclManager->save_permission($aro_node, $aco_path, 'grant'))
	            {
	                $this->set('acl_error', true);
	            }
        	}
        	else
        	{
        		$this->set('acl_error', true);
            	$this->set('acl_error_aco', true);
        	}
        }
        else
        {
            $this->set('acl_error', true);
            $this->set('acl_error_aro', true);
        }
        
        $this->set('user_id', $user_id);
        $this->_set_aco_variables();
        
        if($this->request->is('ajax'))
        {
            $this->render('ajax_user_granted');
        }
        else
        {
            $this->_return_to_referer();
        }
	}
	public function admin_deny_user_permission($user_id)
	{
	    $user =& $this->{Configure :: read('acl.aro.user.model')};
        
        $user->id = $user_id;

        $aco_path = $this->_get_passed_aco_path();
        
        /*
         * Check if the user exists in the ARO table
         */
        $aro_node = $this->Acl->Aro->node($user);
        if(!empty($aro_node))
        {
        	$aco_node = $this->Acl->Aco->node($aco_path);
        	
        	if(!empty($aco_node))
        	{
        	    if(!$this->AclManager->save_permission($aro_node, $aco_path, 'deny'))
	            {
	                $this->set('acl_error', true);
	            }
        	}
        	else
        	{
        		$this->set('acl_error', true);
            	$this->set('acl_error_aco', true);
        	}
        }
        else
        {
            $this->set('acl_error', true);
            $this->set('acl_error_aro', true);
        }
        
        $this->set('user_id', $user_id);
        $this->_set_aco_variables();
        
        if($this->request->is('ajax'))
        {
            $this->render('ajax_user_denied');
        }
        else
        {
            $this->_return_to_referer();
        }
	}
}
?>