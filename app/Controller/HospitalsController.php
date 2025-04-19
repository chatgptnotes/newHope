<?php
/**
 * HospitalsController file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Hospitals.Controller
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Santosh R. Yadav
 */
class HospitalsController extends AppController {

	public $name = 'Hospitals';
	public $uses = array('Facility');
	public $helpers = array('Html','Form', 'Js');
	public $components = array('RequestHandler','Email');

/**
 * users listing by superadmin url
 *
 */

	public function superadmin_index() {
		$this->paginate = array(
			'limit' => Configure::read('number_of_rows'),
			'order' => array(
				'Facility.name' => 'desc'
			),
			'group'=>'Facility.id',
			'conditions' => array('Facility.is_deleted' => 0)
		);
		$this->set('title_for_layout', __('Superadmin - Manage Hospitals', true));
		$this->Facility->recursive = 0;
		$data = $this->paginate('Facility');

		$this->set('data', $data);
	}

/**
 * users view by superadmin url
 *
 */
	public function superadmin_view($id = null) {
                $this->set('title_for_layout', __('Superadmin - Hospital Detail', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid Superadmin', true, array('class'=>'error')));
			$this->redirect(array("controller" => "hospitals", "action" => "index", "superadmin" => true));
		}
		$this->set('hospital', $this->Facility->read(null, $id));
	}

/**
 * users add by superadmin url
 *
 */
	public function superadmin_add() {
			App::import('Vendor', 'DrmhopeDB');
			$this->uses = array('City', 'Country', 'State', 'Location','FacilityDatabaseMapping','Currency');
			$this->set('title_for_layout', __('Superadmin - Add New Hospital', true));
			
			if (!empty($this->request->data)) {
					$this->request->data["Facility"]["create_time"] = date("Y-m-d H:i:s");
					$this->request->data["Facility"]["created_by"] =  $this->Auth->user('id');
					$this->request->data["Facility"]["is_deleted"] =  0;
					$this->Facility->create();
					$this->Facility->save($this->request->data);
					$errors = $this->Facility->invalidFields();
				if(!empty($errors)) {
						$this->set("errors", $errors);
				} else {
					$drmhope = new DrmhopeDB($this->request->data["Facility"]["name"]);       // create the slave database
						$this->Facility->save();
						$this->FacilityDatabaseMapping->save(array('facility_id'=>$this->Facility->id,'db_name'=>$flag,'is_active'=>1));
				// 		$this->Facility->addDeafaultLocation($flag,$this->Facility->id,$this->request->data);
					$flag = $drmhope->create_facility_db();          // create the slave database
					if($flag){
						$drmhope->seed_data();
						$this->Facility->save();
						$this->FacilityDatabaseMapping->save(array('facility_id'=>$this->Facility->id,'db_name'=>$flag,'is_active'=>1));
						$this->Facility->addDeafaultLocation($flag,$this->Facility->id,$this->request->data);
						$this->Session->setFlash(__('The Hospital has been saved', true));
						$this->redirect(array("controller" => "hospitals", "action" => "index", "superadmin" => true));
					}
					else{
						$this->Session->setFlash($drmhope->db_error);
					}
				}
			}
			$this->set('cities', $this->City->find('list', array('fields'=> array('id', 'name'))));
			$this->set('states', $this->State->find('list', array('fields'=> array('id', 'name'))));
			$this->set('countries', $this->Country->find('list', array('fields'=> array('id', 'name'))));
			$this->set('currency', $this->Currency->getAllCurrencies());
	}

/**
 * users edit by superadmin url
 *
 */
	public function superadmin_edit($id = null) {
                $this->loadModel("City");
                $this->loadModel("Country");
                $this->loadModel("State");
                $this->set('title_for_layout', __('Superadmin - Edit Hospital Detail', true));

		 
                $this->Facility->id = $id;
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid Hospital', true, array('class'=>'error')));
                        $this->redirect(array("controller" => "hospitals", "action" => "index", "superadmin" => true));
		}

		if (!empty($this->request->data)) {
                        $this->request->data["Facility"]["modify_time"] = date("Y-m-d H:i:s");
                        $this->request->data["Facility"]["modified_by"] =  $this->Auth->user('id');
			$this->Facility->save($this->request->data);
			$errors = $this->Facility->invalidFields();
                        if(!empty($errors)) {
                           $this->set("errors", $errors);
                        } else {
                           $this->Session->setFlash(__('The Hospital has been updated', true, array('class'=>'message')));
			   $this->redirect(array("controller" => "hospitals", "action" => "index", "superadmin" => true));
                        }
		}
		if (empty($this->request->data)) {
			
			$this->request->data = $this->Facility->read(null, $id);
		}
		$this->set('id', $id);
                $this->set('cities', $this->City->find('list', array('fields'=> array('id', 'name'))));
                $this->set('states', $this->State->find('list', array('fields'=> array('id', 'name'))));
                $this->set('countries', $this->Country->find('list', array('fields'=> array('id', 'name'))));
	}

/**
 * users delete by superadmin url
 *
 */
	public function superadmin_delete($id = null) {
                $this->set('title_for_layout', __('Superadmin - Delete Hospital', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Hospital', true, array('class'=>'error')));
			$this->redirect(array("controller" => "hospitals", "action" => "index", "superadmin" => true));
		}
		if (!empty($id)) {
                        $this->Facility->id = $id;
                        $this->request->data["Facility"]["id"] = $id;
                        $this->request->data["Facility"]["is_deleted"] = '1';
                        $this->Facility->save($this->request->data);
                        $this->Session->setFlash(__('Hospital deleted', true, array('class'=>'message')));
			$this->redirect(array("controller" => "hospitals", "action" => "index", "superadmin" => true));
		}else {
                        $this->Session->setFlash(__('This hospital is associated with other details so you can not be deleted this hospital', true, array('class'=>'error')));
			$this->redirect(array("controller" => "hospitals", "action" => "index", "superadmin" => true));
                }
	}
	
	//----------code for Company (Gulshan)------
	
	
	public function admin_company_list() {
		
		$this->uses = array('Company') ;
		$facility = $this->Session->read('facilityid');	  
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'conditions'=>array('facility_id'=>$facility),
				'order' => array(
						'Company.name' => 'asc'
				)
		);
		$this->set('title_for_layout', __('Manage Company', true));
			
		$data = $this->paginate('Company');
		$this->set('data', $data);
	}
	
	public function admin_company_add($id) {

		$this->set('title_for_layout', __('Add Company', true));
		$this->uses = array('Company') ;
		if (!empty($this->data)) {
			$old_data = $this->Company->find('count',array('conditions'=>array('name'=>$this->request->data['Company']['name'],'id != '=>$this->request->data['Company']['id'] ) ));
			if($old_data){					
				$this->Session->setFlash(__('This Company is already exist.'),'default',array('class'=>'error'));
				return false; 
			}			
			if(empty($this->request->data["Company"]['id'])){
				$this->request->data["Company"]["created_by"] = $this->Session->read('userid');
				$this->request->data["Company"]["facility_id"] = $this->Session->read('facilityid');				
				$this->request->data["Company"]["create_time"] = date("Y-m-d H:i:s");
				$msg= 'Company has been added successfully' ;
			}else{
				$this->request->data["Company"]["modified_by"] = $this->Session->read('userid');
				$this->request->data["Company"]["modify_time"] = date("Y-m-d H:i:s");
				$this->request->data["Company"]["facility_id"] = $this->Session->read('facilityid');
				$msg = 'Company has been updated successfully';
			}
			   
			$this->Company->save($this->request->data);

			$errors = $this->Company->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
				$this->Session->setFlash(__($msg),'default',array('class'=>'message'));
				$this->redirect(array('action'=>'company_list'));
			}
		}
		
		if($id){
			$this->data = $this->Company->read(null,$id);
		}

		 
	} //EOF of function add

	//funtion to delete role
	public function admin_company_delete($id = null) {
		$this->set('title_for_layout', __('- Delete Company', true));
		$this->uses = array("Company");
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Company'),'default',array('class'=>'error'));
			$this->redirect(array('action'=>'company_list'));
		}
		if ($this->Company->delete($id)) {
			$this->Session->setFlash(__('Company deleted successfully'),'default',array('class'=>'message'));
			$this->redirect(array('action'=>'company_list'));
		}
	}
	
	//function to add permissions to admin users
	public function superadmin_permissions(){ 
		$this->uses  = array('ModulePermission','Facility') ;   
		$modules ="" ;
		if(!empty($this->request->data['Facility']['facility_id'])){
			$this->ModulePermission->bindModel(array(
					"belongsTo" =>array(
							"AssignedModulePermission"=>array("foreignKey"=>false,
									'conditions'=>array('AssignedModulePermission.facility_id'=>$this->request->data['Facility']['facility_id'],
											'AssignedModulePermission.module_permission_id=ModulePermission.id'))
					)
			));
			$modules  = $this->ModulePermission->find('all',array('order'=>array('ModulePermission.module')));
		} 
	 
		$facility  = $this->Facility->find('list',array('fields'=>array('Facility.id','Facility.name'))); 
		$this->set(array('modules'=> $modules,'hospitals'=>$facility));   
	} 
	
	public function superadmin_assign_permission(){
		$this->layout = 'ajax';
		$this->autoRender = false ;
		$this->uses =  array('AssignedModulePermission') ;
		 
		if(!empty($this->request->data['module_permission_id']) && !empty($this->request->data['facility_id'])){
			//search if already exit
			$isExist= $this->AssignedModulePermission->find('first',array('conditions'=>array('module_permission_id'=>$this->request->data['module_permission_id'],
						'facility_id'=>$this->request->data['facility_id']))) ;
			if(!empty($isExist['AssignedModulePermission']['id'])){
				$this->request->data['id'] = $isExist['AssignedModulePermission']['id'];
			}
			//EOD search
			$data = array('id'=>$this->request->data['id'],
						'module_permission_id'=>$this->request->data['module_permission_id'],
						'facility_id'=>$this->request->data['facility_id']);
			$result = $this->AssignedModulePermission->save($data);
			if($result){
				echo  trim($this->AssignedModulePermission->id) ;
			}else{
				echo "Please try again" ;
			}			
		}
	}
	
	public function superadmin_deny_permission(){
		$this->layout = 'ajax';
		$this->autoRender = false ;
		$this->uses =  array('AssignedModulePermission') ;
		if(!empty($this->request->data['module_permission_id']) && !empty($this->request->data['facility_id']) && !empty($this->request->data['id'])){ 
			$result = $this->AssignedModulePermission->delete($this->request->data['id']);
			if($result){
				return  ;
			}else{
				echo "Please try again" ;
			}
		}
	}
}
?>