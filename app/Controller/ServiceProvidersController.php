<?php 

/**
 * Services controller
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Service Provider 
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pankaj wanjari
 * $function 	  :Add/edit/view and delete service provider
 */
class ServiceProvidersController extends AppController {

	public $name = 'ServiceProviders';
	public $uses = array('ServiceProvider');
	public $helpers = array('Html','Form', 'Js');
	public $components = array('RequestHandler','Email','General'); 
	
	//listing of service providers
	function admin_index(){	
    	$this->set('title_for_layout', __('-Service Providers', true));									
		$this->paginate = array(
			        'limit' => Configure::read('number_of_rows'),
			        'order' => array(
			            'ServiceProviders' => 'ServiceProvider.name'
			        ),
			        'conditions' => array('ServiceProvider.location_id' => $this->Session->read('locationid'))
   		);
		
		$result = $this->paginate('ServiceProvider');
		$this->set('data',$result);
	}
	
	function admin_add($lab_id=null){
		$this->uses=array('AccountingGroup','HrDetail');
				if(isset($this->request->data) && !empty($this->request->data)){	
							 		 
				if(($this->ServiceProvider->insertServiceProvider($this->request->data))){		
					$last_user = $this->ServiceProvider->getInsertId();
					if(empty($last_user))
							$last_user=$lab_id;
					if(!empty($this->request->data['HrDetail']) && !empty($last_user)){						
						$this->request->data['HrDetail']['user_id']=$last_user;
						$this->request->data['HrDetail']['type_of_user']=Configure::read('serviceProviderUser');					
						$this->HrDetail->saveData($this->request->data);
					}
					$this->Session->setFlash(__('Record has been added successfully'),'default',array('class'=>'message'));
					$this->redirect(array("action" => "index")); 	 
				}
				$errors = $this->ServiceProvider->invalidFields();			 
            	if(!empty($errors)) {
            		$this->set("errors", $errors);           
            		$this->request->data['ServiceProvidersParameter']= "";     		 
            	}
		}
		if(!empty($lab_id)){
			$testQuery = $this->ServiceProvider->read(null,$lab_id); 
			$this->data = $testQuery ; 
			//BOF-Mahalaxmi for Fetch the hrdetails
			$this->set('hrDetails',$this->HrDetail->findFirstHrDetails($lab_id,Configure::read('serviceProviderUser')));
			//EOF-Mahalaxmi for Fetch the hrdetails
		}
		
		if($this->data['ServiceProvider']['account_no']){
			$this->set('accountNo',$this->data['ServiceProvider']['account_no']);
		}else{
			$this->set('accountNo',"SP".$this->General->generateRandomBillNo());
		}
		$this->set('group',$this->AccountingGroup->getAllGroup());
		$this->set('groupId',$this->AccountingGroup->getAccountingGroupID(Configure::read('sundry_creditors')));
	}
	
	function admin_change_status($test_id=null,$status=null){
		if($test_id==''){
			$this->Session->setFlash(__('There is some problem'),'default',array('class'=>'error'));
			$this->redirect($this->referer());
		}
		$this->ServiceProvider->id = $test_id ;
		$this->ServiceProvider->save(array('status'=>$status));
		$this->Session->setFlash(__('Status has been changed successfully'),'default',array('class'=>'message'));
		$this->redirect($this->referer());
	}


}