<?php
/**
 * AclFilter Component
 *
 * PHP version 5
 *
 * @category Component
 * @package  DrmHope
 * @version  1.0
 * @author   Mayank jain
 */
class AclFilterComponent extends Component {
var $components = array('Session');
/**
 * @param object $controller controller
 * @param array  $settings   settings
 */
    public function initialize($controller, $settings = array()) {
        $this->controller =$controller;
    }

/**
 * acl and auth
 *
 * @return void
 */
    public function auth() {
		$flag = false;
        $this->controller->Auth->loginAction = array( 'controller' => 'users', 'action' => 'login');
        $this->controller->Auth->logoutRedirect = array( 'controller' => 'users', 'action' => 'login');
        $this->controller->Auth->loginRedirect = array('controller' => 'users', 'action' => 'login');
        $this->controller->Auth->userScope = array('User.status' => 1);
		if($this->controller->Auth->user('role_id') == "1")
			{
				return true;
			}
		if($this->controller->action != "common" && $this->controller->action != "login" && $this->controller->action != "logout" && $this->controller->action != "autocomplete" ){
            $aro = $this->controller->Acl->Aro->find('first', array(
                'conditions' => array(
                    'Aro.model' => 'Role',
                    'Aro.foreign_key' => $this->controller->Auth->user('role_id'),
                ),
                'recursive' => -1,
            ));  // get the aros id for user's role
            $aroId = $aro['Aro']['id'];
			$aroUser = $this->controller->Acl->Aro->find('first', array(
                'conditions' => array(
                    'Aro.model' => 'User',
                    'Aro.foreign_key' => $this->controller->Auth->user('id'),
                ),
                'recursive' => -1,
            )); // get the aros id for user's specific ID
            $aroUserId = $aroUser['Aro']['id'];
		
			if($this->controller->name == "Nursing"){
				$this->controller->name = "Nursings";
			}
			
/***********************************************************check for admin*******************************************************************************/
						$is_allow_all_controller = $this->controller->Acl->Aco->find('list', array(
																		'conditions' => array(
																			'alias' => 'controllers'
																		),
																		'fields' => array(
																			'id'
																		)
																		));
					
						if(!empty($is_allow_all_controller)){
							 $allowedActions = $this->controller->Acl->Aco->Permission->find('list', array(
								'conditions' => array(
									'Permission.aro_id' => $aroId,
									'Permission.aco_id' => $is_allow_all_controller,
									'Permission._create' => 1,
									'Permission._read' => 1,
									'Permission._update' => 1,
									'Permission._delete' => 1,
								),
								'fields' => array(
									'id',
									'aco_id',
								),
								'recursive' => '-1',
							));
							 if(count($allowedActions)>0){
			 					return true;	
							}
						 }
/********************************************************************************************************************************************************/

            $thisControllerNode = $this->controller->Acl->Aco->node($this->controller->Auth->actionPath.$this->controller->name);
			// get the  id from acos for current controller
           
                $thisControllerNode = $thisControllerNode['0'];
                $thisControllerActions = $this->controller->Acl->Aco->find('list', array(
                    'conditions' => array(
                        'Aco.parent_id' => $thisControllerNode['Aco']['id'],
                    ),
                    'fields' => array(
                        'Aco.id',
                        'Aco.alias',
                    ),
                    'recursive' => '-1',
                ));  // get the all actions for current controller
				
	/*********************** get is from acos table for current action ***********************/	
				$current_action_acosid = $this->controller->Acl->Aco->find('first', array(
                    'conditions' => array(
                        'alias' => $this->controller->action,
						 'Aco.parent_id' => $thisControllerNode['Aco']['id'],
                    ),
                   
                ));
	/*****************************************************************************************/		
              foreach($current_action_acosid['Aro'] as $key =>$value){
			
			 if($this->path_through_array('Permission.aro_id', $value) == $aroUserId ){
					if(($this->path_through_array('Permission._create', $value) =="1" && $this->path_through_array('Permission._read', $value) =="1") && ($this->path_through_array('Permission._update', $value) =="1" && $this->path_through_array('Permission._delete', $value) =="1")){
					$flag = true;
						
					}else if(($this->path_through_array('Permission._create', $value) =="-1" && $this->path_through_array('Permission._read', $value) =="-1") && ($this->path_through_array('Permission._update', $value) =="-1" && $this->path_through_array('Permission._delete', $value) =="-1")){
					$flag = false;
					
					}				
				}else if($this->path_through_array('Permission.aro_id', $value) == $aroId ){
					if(($this->path_through_array('Permission._create', $value) =="1" && $this->path_through_array('Permission._read', $value) =="1") && ($this->path_through_array('Permission._update', $value) =="1" && $this->path_through_array('Permission._delete', $value) =="1")){
						$flag = true;
					}else if(($this->path_through_array('Permission._create', $value) =="-1" && $this->path_through_array('Permission._read', $value) =="-1") && ($this->path_through_array('Permission._update', $value) =="-1" && $this->path_through_array('Permission._delete', $value) =="-1")){
					$flag = false;
					
					}	
				
				}	  
			  }
			 if($flag==1){
			 	return true;	
			}else{
			 	$this->Session->setFlash(__('You don\'t have permission for this section.'));
			 	$this->controller->redirect(array('controller'=> 'users','action' => 'common','admin'=>false,'superadmin'=>false));
			}	
            }
		
	}
	public function path_through_array($path, $array, $delimiter = '.', $strict = false){
		  $path_token = explode($delimiter, $path);
		  $head = array_shift($path_token);		
		  if (isset($array[$head]) && (0 == count($path_token))) {
			return $array[$head];
		  }
		  else if (isset($array[$head])){
			return $this->path_through_array(implode($delimiter, $path_token), $array[$head], $delimiter, $strict);
		  }
		  else if ($strict == true) {
			return false;
		  }
		  foreach ($array as $key=>$value){
			if (is_array($value)){
			  $found = $this->path_through_array($path, $value, $delimiter, $strict);		
			  if(false != $found){
				return $found;
			  }
			}
		  }
		  return false;
	}
}
?>
