 <?php

class ConfigurationsController extends AppController {

	public $name = 'Configurations';
	
	public function index(){
		$this->layout = "advance";
		$this->uses = array('User','TestGroup');
		$this->set('users',$this->User->getUsers());
		$this->set ( 'testGroup', $this->TestGroup->getAllGroups ( 'laboratory' ) );
		$this->set('configurationsMainData',$this->Configuration->find('all',array('fields'=>array('id','name'),'conditions'=>array('category'=>2))));	//saved configurations
		$configurations = $this->Configuration->find('all',array('fields'=>array('id','name'),'conditions'=>array('category'=>1)));	//saved configurations
		$this->set('configurations',$configurations);

		/* $value = array('Include in a bill'=>array('yes'));		//for pahrmacy set yes to include in a bill
		$val = serialize($value);	//serailize and saved in configuration table*/
		foreach($configurations as $Conf){
			$configurationsValues[$Conf['Configuration']['name']] = $Conf['Configuration']['id'];
		}
		$this->set('redirect',$this->Configuration->find('first',array('conditions'=>array('name'=>'Redirect From Registration','category'=>'1'))));
		$this->set('signature',$this->Configuration->find('first',array('conditions'=>array('name'=>'Signature','category'=>'1'))));
		$this->set('email',$this->Configuration->find('all',array('conditions'=>array('category'=>$configurationsValues['Email']))));
		$this->set('pharmacy',$this->Configuration->find('first',array('conditions'=>array('name'=>'Pharmacy','category'=>'0'))));
		if($this->request->data){
			$id = $this->request->data['User']['configuration_id'];
			if(!empty($this->request->data['User']['email_config'])){
				foreach ($this->request->data['User']['email_config'] as $key => $configVal){
					$emailConfigId=$this->request->data['User']['ConfigId'];
					$emailConfigArray = $emailConfigValues = array();
					$emailConfigArray['name'] = $configVal;
					$emailConfigArray['category'] = $configurationsValues['Email'];
					$emailConfigValues['email_id'] = $this->request->data['User']['Config']['email_id'][$key];
					$emailConfigValues['sms_number'] = $this->request->data['User']['Config']['sms_number'][$key];
					$emailConfigArray['value'] = serialize($emailConfigValues);
					$this->Configuration->id = $emailConfigId[$key];
					$this->Configuration->save($emailConfigArray);
					$this->Configuration->id = '';
				}
			}
				
				if($this->request->data['User']['configuration_name'] == 'Laboratory Results'){
					$this->request->data['Configuration']['value'] = serialize($this->request->data['User']['right_user']);
				}else if($this->request->data['User']['configuration_name'] == 'Pharmacy'){
					$previousValue = $this->Configuration->find('first',array('conditions'=>array('name'=>'Pharmacy'),'fields'=>array('value')));//
					$previousData = unserialize($previousValue['Configuration']['value']);
					$valueKey = strtolower($this->request->data['User']['value_key_phar']);
					$text = str_replace(" ", '_', $valueKey);
					$pharmacyArray[$text] = $this->request->data['User']['prefix'];
					
					if($previousData){
						$result = array_merge($previousData , $pharmacyArray); //append array with previous value
						$this->request->data['Configuration']['value'] = serialize($result);
					}else{
						$this->request->data['Configuration']['value'] = serialize($pharmacyArray);
					}
					//pharmacy set yes/no
					if($this->request->data['User']['included_in_bill']=='1')
						$this->request->data['User']['included_in_bill']="yes";
					else 
						$this->request->data['User']['included_in_bill']="no";
					$this->request->data['Configuration']['value'] = serialize($this->request->data['User']['included_in_bill']);	//set pharmacy yes/no
					//debug($this->request->data['Configuration']['value']); exit;
				}else if($this->request->data['User']['configuration_name'] == 'Redirect From Registration'){
					$redirect = $this->Configuration->find('first',array('conditions'=>array('name'=>'Redirect From Registration'),'fields'=>array('value')));
					$rediectData = unserialize($redirect['Configuration']['value']);
            		if($rediectData){
						$this->request->data['Configuration']['value'] = serialize($rediectData);
					}
					$this->request->data['Configuration']['value'] = serialize($this->request->data['User']['Redirect From Registration']);	//set pharmacy yes/no
					//debug($this->request->data['Configuration']['value']); exit;
				}else if($this->request->data['User']['configuration_name'] == 'allowTimelyQuickReg'){
					/** Nothing to say :-) */
				}else if($this->request->data['User']['configuration_name'] == 'Signature'){
					
					foreach($this->request->data['User']['specialty'] as  $signKey =>$signVal){
						 $signatureArray[$signVal][] = $this->request->data['User'] ['signature'][$signKey];
					}
					//debug($signatureArray); exit;
					
						$this->request->data['Configuration']['value'] = serialize($signatureArray);
				}elseif($this->request->data['User']['configuration_name'] == 'Re-test authority'){
					$this->request->data['Configuration']['value'] = serialize($this->request->data['User']['right']);
				}else{
					$previousValue = $this->Configuration->find('first',array('conditions'=>array('name'=>'Prefix'),'fields'=>array('value')));//
					$previousData = unserialize($previousValue['Configuration']['value']);
					
					// ******testing code for UID genrate*******used in Person Cotroller autoGeneratedPatientID();***gulshan
					 /* pr($previousData);
						$inArray = array_key_exists('u_id',$previousData);
						if($inArray){
							debug($previousData['u_id']);
						}
						echo 'kuch nai'; exit; */
					
					$prifixArray[$this->request->data['User']['value_key_prefix']] = $this->request->data['User']['prefix'];
					if($previousData){
						$result = array_merge($previousData , $prifixArray); //append array with previous value
						
						$this->request->data['Configuration']['value'] = serialize($result);
					}else{
						$this->request->data['Configuration']['value'] = serialize($prifixArray);
					}
					
				}

			$this->Configuration->id = $id; 

			//debug($this->request->data);exit;
			$this->Configuration->save($this->request->data);
			$this->Configuration->id = '';
			$this->redirect($this->referer());

		}
	}
	
	public function findAuthenticateUser($id){
		$this->layout = false;
		$this->autoRender = false;
		$this->uses = array('User');
		
		
		//$users = $this->User->getUsers(); //all users  (id => "full name")
		$roleName = Configure::read('labManager');
		$users = $this->User->getUsersByRoleName($roleName);
		
		$old_config = $this->Configuration->find('first',array('conditions'=>array('id'=>$id,'category'=>1)));
		$selectedUser = unserialize($old_config['Configuration']['value']);
		
		foreach($selectedUser as $val){
			if(array_key_exists($val, $users)){
				$value[$val] = $users[$val];
				unset($users[$val]);
			}
		}
		asort($users);
		$value = ($value) ? $value : array();	//selected usesr
		$variable = array('selected' => $value, 'all' => $users);
		
		echo json_encode($variable);
		exit;
	}
	
	
	public function holiday($id){
		$this->layout="advance";
	
		$this->uses = array('Configuration');
	
		if(!empty($this->request->data)){//debug($this->request->data);exit;
				
			$created_by = $this->Session->read('userid');
			$created_time = date("Y-m-d");
				
			/*foreach($this->request->data['Holiday'] as $key => $val){
			 $val['holiday_date'] = $this->DateFormat->formatDate2STD($val['holiday_date'],Configure::read('date_format'));
			$val['created_by'] = $created_by;
			$val['created_time'] = $created_time;
			}*/
			$this->request->data['name'] = 'Holiday_Tittel';
			$this->request->data['value'] = serialize($this->request->data['Holiday']);
				
			$this->Configuration->save($this->request->data);
			//debug($this->request->data);exit;
			$this->Session->setFlash(__('Save successfully!!!'));
			$this->redirect($this->referer());
				
				
		}
	}

	/**
	 * Function to save acos entry
	 * @author Swatin
	 */
	public function acos_entry(){
		$this->uses = array('Acos','ModulePermission');
		$this->layout = 'advance';
	
		if(!empty($this->request->data)){
			//debug($this->request->data);exit;
	
			if($this->request->data['Acos']['Process']==1){
				$controller = $this->Acos->find('first',array('fields'=>array('Acos.id'),'conditions'=>array('Acos.alias' => $this->request->data['Acos']['controller'])));
				if(empty($controller) )
				{
					$errors[] = "Controller not found.";
				}
			}else{
				$controller['Acos']['id']='1';
				$this->request->data['Acos']['is_viewable']='1';
				$this->request->data['Acos']['is_permission_need']='1';
			}
			$count = $this->Acos->find('count',array('conditions'=>array('Acos.alias' => $this->request->data['Acos']['alias'],'Acos.parent_id' =>$controller['Acos']['id'])));
			if($count>0)
			{
				$errors[] = "Entry already exist.";
			}
			if(empty($errors)){
				$otherData = $this->Acos->find('first',array('fields'=>array('Acos.id','Acos.rght'),'order'=> array('Acos.id'=>'desc')));
				$acosEntryData['parent_id']=$controller['Acos']['id'];
				$acosEntryData['alias']=$this->request->data['Acos']['alias'];
				$acosEntryData['lft']=$otherData['Acos']['rght']+1;
				$acosEntryData['rght']=$acosEntryData['lft']+1;
				$acosEntryData['is_viewable']=$this->request->data['Acos']['is_viewable'];
				$acosEntryData['is_permission_need']=$this->request->data['Acos']['is_permission_need'];
				$acosEntryData['label']=$this->request->data['Acos']['label'];
				$acosEntryData['desc']=$this->request->data['Acos']['desc'];
	
				$this->Acos->save($acosEntryData);
				if($acosEntryData['parent_id']=='1'){
					$this->ModulePermission->save(array('module'=>$acosEntryData['alias'],'description'=>$acosEntryData['desc'],'type'=>'BOTH'));
				}
				$this->Session->setFlash(__("Acos Entry Succesfully Saved."));
				$this->redirect(array('controller'=>'Configurations','action'=>'acos_entry'));
			}
	
			//$this->set(compact('errors'));
			$this->set("errors", $errors);
		}
	}

}