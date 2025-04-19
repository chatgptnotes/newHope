<?php
/**
 * LocationsController file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Locations.Controller
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Santosh R. Yadav
 */
class LocationsController extends AppController {

	public $name = 'Locations';
	public $uses = array('Location');
	public $helpers = array('Html','Form', 'Js','Fck','General');
	public $components = array('RequestHandler','Email','ImageUpload');

	/**
	 * location listing by superadmin url
	 *
	*/

	public function superadmin_index() {
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array(
						'Location.name' => 'asc'
				),
				'conditions' => array('Location.is_deleted' => 0)
		);
		$this->set('title_for_layout', __('Superadmin - Manage Locations', true));
		$this->Location->recursive = 0;
		$data = $this->paginate('Location');
		$this->set('data', $data);
	}

	/**
	 * location view by superadmin url
	 *
	 */
	public function superadmin_view($id = null) {
		$this->set('title_for_layout', __('Superadmin - Location Detail', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid Superadmin', true, array('class'=>'error')));
			$this->redirect(array("controller" => "locations", "action" => "index", "superadmin" => true));
		}
		$this->set('location', $this->Location->read(null, $id));
	}

	/**
	 * location add by superadmin url
	 *
	 */
	public function superadmin_add() {
		$this->loadModel("City");
		$this->loadModel("Country");
		$this->loadModel("State");
		$this->loadModel("Facility");
		$this->set('title_for_layout', __('Superadmin - Add New Location', true));
		$facilityId = $this->Session->read('facilityid');
		$locationCount = $this->Location->find('count', array('conditions' => array('Location.is_deleted' => 0)));
		$facilityData = $this->Facility->read(array('Facility.maxlocations'), $facilityId);
		$this->Facility->id = $facilityId;
		// check count of maxlocations //
		if($locationCount >  $facilityData['Facility']['maxlocations']){
			$this->Session->setFlash(__('Maximum location created.', true),'default',array('class'=> 'error'));
			$this->redirect($this->referer());
		}

		if (!empty($this->request->data)) {
			$dupLocation = $this->Location->find('count', array('conditions' => array('Location.is_deleted' => 0, 'Location.name' => trim($this->request->data['Location']['name']))));
			if($dupLocation > 0) {
				$this->Session->setFlash(__('You already have been created this location name so please try another name', true),'default',array('class'=> 'error'));
				$this->redirect($this->referer());
			}
			$this->request->data["Location"]["create_time"] = date("Y-m-d H:i:s");
			$this->request->data["Location"]["modify_time"] = date("Y-m-d H:i:s");
			$this->request->data["Location"]["created_by"] = "1";
			$this->Location->create();
			$this->Location->save($this->request->data);
			$errors = $this->Location->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
				$this->Session->setFlash(__('The Location has been saved', true, array('class'=>'message')));
				$this->redirect(array("controller" => "locations", "action" => "index", "superadmin" => true));
			}
		}
		$this->set('cities', $this->City->find('list', array('fields'=> array('id', 'name'), 'order' => array('City.name'))));
		$this->set('states', $this->State->find('list', array('fields'=> array('id', 'name'), 'order' => array('State.name'))));
		$this->set('countries', $this->Country->find('list', array('fields'=> array('id', 'name'), 'order' => array('Country.name'))));
		$this->set('facilities', $this->Facility->find('list', array('fields'=> array('id', 'name'),'order' => array('Facility.name'), 'conditions' => array('Facility.is_deleted' => 0,'Facility.is_active' => 1))));
	}

	/**
	 * location edit by superadmin url
	 *
	 */
	public function superadmin_edit($id = null) {
		$this->loadModel("City");
		$this->loadModel("Country");
		$this->loadModel("State");
		$this->loadModel("Facility");
		$this->set('title_for_layout', __('Superadmin - Edit Location Detail', true));
		$facilityId = $this->Session->read('facilityid');
		$this->Location->id = $id;
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid Location', true, array('class'=>'error')));
			$this->redirect(array("controller" => "locations", "action" => "index", "superadmin" => true));
		}
		if (!empty($this->request->data)) {
			// check duplicate location name //
			$dupLocation = $this->Location->find('count', array('conditions' => array( 'Location.is_deleted' => 0, 'Location.name' => trim($this->request->data['Location']['name']), 'Location.id <>' => $this->request->data['Location']['id'])));
			if($dupLocation > 0) {
				$this->Session->setFlash(__('You already have been created this location name so please try another name', true),'default',array('class'=> 'error'));
				$this->redirect($this->referer());
			}
			//remove left side space from location name
			$this->request->data['Location']['name']= ltrim($this->request->data['Location']['name']);

			$this->Location->save($this->request->data);
			$errors = $this->Location->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
				$this->Session->setFlash(__('The Location has been saved', true, array('class'=>'message')));
				$this->redirect(array("controller" => "locations", "action" => "index", "superadmin" => true));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Location->read(null, $id);
		}
		$this->set('id', $id);
		$this->set('cities', $this->City->find('list', array('fields'=> array('id', 'name'), 'order' => array('City.name'))));
		$this->set('states', $this->State->find('list', array('fields'=> array('id', 'name'), 'order' => array('State.name'))));
		$this->set('countries', $this->Country->find('list', array('fields'=> array('id', 'name'), 'order' => array('Country.name'))));
		$this->set('facilities', $this->Facility->find('list', array('fields'=> array('id', 'name'), 'order' => array('Facility.name'), 'conditions' => array('Facility.is_deleted' => 0,'Facility.is_active' => 1))));
	}

	/**
	 * location delete by superadmin url
	 *
	 */
	public function superadmin_delete($id = null) {
		$this->set('title_for_layout', __('Superadmin - Delete Location', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Location', true, array('class'=>'error')));
			$this->redirect(array("controller" => "locations", "action" => "index", "superadmin" => true));
		}
		if (!empty($id)) {
			$this->Location->id = $id;
			$this->request->data["Location"]["id"] = $id;
			$this->request->data["Location"]["is_deleted"] = "1";
			$this->Location->save($this->request->data);
			$this->Session->setFlash(__('Location deleted', true, array('class'=>'message')));
			$this->redirect(array("controller" => "locations", "action" => "index", "superadmin" => true));
		} else {
			$this->Session->setFlash(__('This location is associated with other details so you can not be deleted this location', true, array('class'=>'error')));
			$this->redirect(array("controller" => "locations", "action" => "index", "superadmin" => true));
		}
	}

	/**
	 * location listing by admin url
	 *
	 */

	public function admin_index() {
		$facilityId = $this->Session->read('facilityid');
		$this->Location->bindModel(array(
				'belongsTo' => array(
						'Company' =>array('foreignKey'=>'company_id')
				)));
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array(
						'Location.name' => 'asc'
				),
				'conditions' => array('Location.is_deleted' => 0)
		);
		$this->set('title_for_layout', __('Admin - Manage Locations', true));
		$this->Location->recursive = 0;
		$data = $this->paginate('Location');
		$this->set('data', $data);
	}

	/**
	 * location view by admin url
	 *
	 */
	public function admin_view($id = null) {

		$this->uses=array('Company');
		$this->set('title_for_layout', __('Admin - Location Detail', true));

		if (!$id) {
			$this->Session->setFlash(__('Invalid Admin', true, array('class'=>'error')));
			$this->redirect(array("controller" => "locations", "action" => "index", "admin" => true));
		}
		$this->Location->bindModel(array(
				'belongsTo' => array(
						'Company' =>array('foreignKey'=>'company_id')
				)));
		$data = $this->Location->read(array('Location.*','Company.name'), $id) ;
		$this->set('location', $data);
		$codeOption=Configure::read('place_service_code');
		//debug($codeOption);exit;
		$this->set('codeOption', $codeOption);


	}

	/**
	 * location add by admin url
	 *
	 */
	public function admin_add() {
		//debug($this->request->data);exit;
		//$this->layout = 'advance';
		$this->uses =array('Facility','City','Country','State','Currency','Company');
			
		$this->set('title_for_layout', __('Admin - Add New Location', true));
		$facilityId = $this->Session->read('facilityid');

		$locationCount = $this->Location->find('count', array('conditions' => array('Location.is_deleted' => 0)));
		$facilityData = $this->Facility->read(array('Facility.maxlocations'), $facilityId);
		$this->Facility->id = $facilityId;
		// check count of maxlocations //
		if($locationCount >=  $facilityData['Facility']['maxlocations']){
			$this->Session->setFlash(__('Maximum location created.', true),'default',array('class'=> 'error'));
			$this->redirect($this->referer());
		}

		if ($this->request->is('put') || $this->request->is('post')) {
			// check duplicate location name //
			$dupLocation = $this->Location->find('count', array('conditions' => array('Location.is_deleted' => 0, 'Location.name' => trim($this->request->data['Location']['name']))));
			if($dupLocation > 0) {
				$this->Session->setFlash(__('You already have been created this location name so please try another name', true),'default',array('class'=> 'error'));
				$this->redirect($this->referer());
			}
			$this->request->data["Location"]["create_time"] = date("Y-m-d H:i:s");
			$this->request->data["Location"]["modify_time"] = date("Y-m-d H:i:s");
			$this->request->data["Location"]["created_by"] = $this->Session->read('userid');
			$this->Location->create();

			//BOF image uplaod
			if(!empty($this->request->data['Location']['header_image']['name'])){
				//creating runtime image name
				$original_image_extension  = explode(".",$this->request->data['Location']['header_image']['name']);
				if(!isset($original_image_extension[1])){
					$imagename= "header_".mktime().'.'.$original_image_extension[0];
				}else{
					$imagename= "header_".mktime().'.'.$original_image_extension[1];
				}
					
			}else{
				unset($this->request->data["Location"]['header_image']);
			}


			if(!empty($this->request->data['Location']['header_image']['name'])){
					
				$showError = $this->ImageUpload->uploadFile($this->params,'header_image','uploads/image',$imagename);
				copy($this->request->data['Location']['header_image']['tmp_name'], APP.'Vendor'.DS.'tcpdf'.DS.'images'.DS.$imagename);
					
			}
			//EOF image upload
			if(!empty($imagename)){
				//set new image name to DB
				$this->request->data["Location"]['header_image']  = $imagename ;
			}
			//check it first fixed option is selected or 24 hours for checkout timing

			if(isset($this->request->data['Location']['checkout_time_option'])){
				if($this->request->data['Location']['checkout_time_option']==0){
					$this->request->data['Location']['checkout_time'] = "24";
				}
			}
			$city_id = $this->City->checkIsCityAvailable($this->request->data['Location']['city_id'],$this->request->data['Location']['state_id']);
			$this->request->data['Location']['city_id'] = $city_id ;
			//remove left side space from location name
			$this->request->data['Location']['name']= ltrim($this->request->data['Location']['name']);
			$this->Location->save($this->request->data);
			//debug($this->request->data);exit;
			$errors = $this->Location->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
				//BOF master data for location by santosh
				$importTable = array('departments','designations');
				foreach($importTable as $importTableVal) {
					if($importTableVal == "departments") {
						$importQuery = "INSERT INTO ".$importTableVal." ( `name` , `location_id` , `created_by` , `create_time`)
								SELECT `name` , ".$this->Location->getLastInsertID().",  ".$this->Session->read('userid')." , now()  FROM ".$importTableVal." WHERE location_id = 1 AND is_active = 1";
					} else {
						$importQuery = "INSERT INTO ".$importTableVal." ( `name` , `location_id` , `created_by` , `create_time`)
								SELECT `name` , ".$this->Location->getLastInsertID().",  ".$this->Session->read('userid')." , now()  FROM ".$importTableVal." WHERE location_id = 1 AND is_deleted = 0 ";
					}
					$this->Location->query($importQuery);
				}
				//EOF santosh

				$this->Session->setFlash(__('The Location has been saved', true, array('class'=>'message')));
				$this->redirect(array("controller" => "locations", "action" => "index", "admin" => true));
				//debug($codeOption);exit;
			}
		}
		$this->set('tempState',$this->State->find('list', array('fields'=> array('id', 'name'),'conditions'=>array('State.country_id'=>'2'),'order' => array('State.name'))));
		$this->set('company', $this->Company->find('list', array('fields'=> array('id', 'name'),'order' => array('Company.name'))));
		//$this->set('cities', $this->City->find('list', array('fields'=> array('id', 'name'),'order' => array('City.name'))));
		//$this->set('states', $this->State->find('list', array('fields'=> array('id', 'name'),'order' => array('State.name'))));
		$this->set('countries', $this->Country->find('list', array('fields'=> array('id', 'name'),'order' => array('Country.name DESC'))));
		$this->set('currency', $this->Currency->getAllCurrencies());

	}

	/**
	 * location edit by admin url
	 *
	 */
	public function admin_edit($id = null) {

		$this->uses = array('Currency','City','Country','State','Company');
		$facilityId = $this->Session->read('facilityid');
		$this->set('title_for_layout', __('Admin - Edit Location Detail', true));
		$this->Location->id = $id;
		$facility = $this->Session->read('facilityid') ;

		$this->set('company_name', $this->Company->find('list', array('fields'=> array('name'),'conditions'=>array('facility_id'=>$facility))));

		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid Location', true, array('class'=>'error')));
			$this->redirect(array("controller" => "locations", "action" => "index", "admin" => true));
		}

		if($this->request->is('put') || $this->request->is('post')) {
			// check duplicate location name //
			$dupLocation = $this->Location->find('count', array('conditions' => array( 'Location.is_deleted' => 0, 'Location.name' => trim($this->request->data['Location']['name']), 'Location.id <>' => $this->request->data['Location']['id'])));
			if($dupLocation > 0) {
				$this->Session->setFlash(__('You already have been created this location name so please try another name', true,array('class'=> 'error')));
				$this->redirect($this->referer());
			}
			//BOF image uplaod
			if(!empty($this->request->data['Location']['header_image']['name'])){
				//creating runtime image name
				$original_image_extension  = explode(".",$this->request->data['Location']['header_image']['name']);
				if(!isset($original_image_extension[1])){
					$imagename= "header_".mktime().'.'.$original_image_extension[0];
				}else{
					$imagename= "header_".mktime().'.'.$original_image_extension[1];
				}
			}else{
				unset($this->request->data["Location"]['header_image']);
			}

			$image_data = $this->Location->read('header_image',$this->request->data['Location']['header_image']) ;
			if(!empty($this->request->data['Location']['header_image']['name'])){
				//remove previous image
				if($image_data['Location']['header_image']){
					$this->ImageUpload->removeFile($image_data['Location']['header_image'],'uploads/image');
				}
				$showError = $this->ImageUpload->uploadFile($this->params,'header_image','uploads/image',$imagename);

				if(empty($showError)) {
					// making thumbnail of 100X100
					$this->ImageUpload->load($this->request->data["Location"]['header_image']['tmp_name']);
					$this->ImageUpload->resize(120,70);
					$this->ImageUpload->save("uploads/hospital/thumbnail/".$imagename,'uploads/hospital/thumbnail/');
					copy($this->request->data['Location']['header_image']['tmp_name'], APP.'Vendor'.DS.'tcpdf'.DS.'images'.DS.'uploads'.DS.'hospital'.DS.'thumbnail'.DS.$imagename);
					unlink(APP.'Vendor'.DS.'tcpdf'.DS.'images'.DS.'uploads'.DS.'hospital'.DS.'thumbnail'.DS.$image_data['Location']['header_image']);
					$this->ImageUpload->removeFile($image_data['Location']['header_image'],'uploads/hospital/thumbnail/');
				}
			}
			if(!empty($imagename)){
				//set new image name to DB
				$this->request->data["Location"]['header_image']  = $imagename ;
			}

			//EOF image upload
			//check it first fixed option is selected or 24 hours for checkout timing

			if(isset($this->request->data['Location']['checkout_time_option'])){
				if($this->request->data['Location']['checkout_time_option']==0){
					$this->request->data['Location']['checkout_time'] = "24";
				}
			}
			//reset currency session
			$this->setCurrencySession($this->request->data['Location']['currency_id']);
			//Currency session
			$city_id = $this->City->checkIsCityAvailable($this->request->data['Location']['city_id'],$this->request->data['Location']['state_id']);
			$this->request->data['Location']['city_id'] = $city_id ;
			//remove left side space from location name
			$this->request->data['Location']['name']= ltrim($this->request->data['Location']['name']);
			$this->Location->save($this->request->data);
			$errors = $this->Location->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
				$this->Session->setFlash(__('The Location has been saved', true, array('class'=>'message')));
				$this->redirect(array("controller" => "locations", "action" => "index", "admin" => true));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Location->read(null, $id);
		}
		$this->set('id', $id);
		$this->set('cities', $this->City->find('list', array('fields'=> array('id', 'name'),'order' => array('City.name'))));
		$this->set('states', $this->State->find('list', array('fields'=> array('id', 'name'),'order' => array('State.name'))));
		$this->set('countries', $this->Country->find('list', array('fields'=> array('id', 'name'),'order' => array('Country.name'))));
		$this->set('currency', $this->Currency->getAllCurrencies());
			
	}

	/**
	 * location delete by admin url
	 *
	 */
	public function admin_delete($id = null) {
		$this->set('title_for_layout', __('Admin - Delete Location', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Location', true, array('class'=>'error')));
			$this->redirect(array("controller" => "locations", "action" => "index", "admin" => true));
		}
		if (!empty($id)) {
			$this->Location->recursive =-1;
			//check if the selected location is default or not
			$result = $this->Location->find('first',array('conditions'=>array('Location.id'=>$id),'fields'=>array('created_by'))); //1 is for superadmin

			if($result['Location']['id']==1){
				$this->Session->setFlash(__('This is the default location of your hospital,can not be deleted.'), true, array('class'=>'error'));
				$this->redirect(array("controller" => "locations", "action" => "index", "admin" => true));
			}else{
				$this->Location->id = $id;
				$this->request->data["Location"]["id"] = $id;
				$this->request->data["Location"]["is_deleted"] = "1";
				$this->Location->save($this->request->data);
				$this->Session->setFlash(__('Location deleted', true, array('class'=>'message')));
				$this->redirect(array("controller" => "locations", "action" => "index", "admin" => true));
			}


		}
	}
	//ajax call to get all locations whose admin is not created yet !!
	public function getNonAdminLocations($role_id=null){
			
		if((empty($role_id)) || ($role_id != 2)) {
			echo ''; exit;
		} //check for admin users only
		$this->Layout = false ;
		echo json_encode($this->Location->getNonAdminLocations($role_id));
		exit;
	}

	/**
	 * Store Location
	 * for listing,adding and updating Store Locations
	 * @param integer $storeLocationId
	 * @author Gaurav Chauriya
	 */
	public function storeLocation($storeLocationId = null){
		$this->layout = 'advance';
		$this->uses  = array('StoreLocation','Department','Account','LocationType','Role');
		$this->set('title_for_layout', __('Store Locations', true));
		if($this->request->data['StoreLocation']){
			$this->request->data['StoreLocation']['role_id'] = implode('|',$this->request->data['StoreLocation']['role_id']);
			$this->StoreLocation->saveStoreLocation($this->request->data['StoreLocation']);
			$message = ($this->request->data['StoreLocation']['id']) ? 'Updated Successfully' : 'Added Successfully';
			$this->Session->setFlash(__($message, true, array('class'=>'message')));
		}
		if($this->params->query['name']){
			$searchByName['StoreLocation.name Like'] = $this->params->query['name'].'%';
		}
		$this->paginate = array(
				'evalScripts' => true,
				'limit' => Configure::read('number_of_rows'),
				'order' => array('StoreLocation.id'=>'DESC'),
				'fields'=> array('StoreLocation.id','StoreLocation.name','StoreLocation.description'),
				'conditions' => array('StoreLocation.is_deleted' => 0,$searchByName)
		);
		$data = $this->paginate('StoreLocation');
		if($storeLocationId){
			$storeLocationData = $this->StoreLocation->read(null,$storeLocationId);
			$storeLocationData['StoreLocation']['role_id'] = explode('|',$storeLocationData['StoreLocation']['role_id']);
			$this->data  = $storeLocationData;
			$this->set('action','edit');
		}
		$this->set('data', $data);
		$this->set('departments',$this->Department->find('list',array('fields'=>array('id','name'),'conditions'=>array('is_active'=>1),'order' => array('Department.name'),
				'group'=>'Department.name')));
		$this->set('role',$this->Role->find('list',array('fields'=>array('id','name'),'order' => array('Role.name'),
								'conditions'=>array('is_deleted'=>0,'location_id'=>$this->Session->read('locationid'),
								'NOT'=>array('name'=>array(Configure::read('patientLabel'),Configure::read('superAdminLabel')))))));
		$this->set('account',$this->Account->find('list',array('fields'=>array('id','name'),'conditions'=>array('is_deleted'=>0),'order' => array('Account.name'),
				'group'=>'Account.name')));
		$this->set('types',$this->LocationType->find('list',array('fields'=>array('id','name')/*,'conditions'=>array('is_deleted'=>0)*/,'order' => array('LocationType.name'),
				'group'=>'LocationType.name')));
	}

	/**
	 * View Store Location Details
	 * @param unknown_type $storeLocationId
	 * @author Gaurav Chauriya
	 */
	public function viewStoreLocation($storeLocationId){
		$this->uses  = array('StoreLocation','Role');
		$this->StoreLocation->bindModel(array(
				'hasOne'=>array(
						'Department'=>array('foreignKey'=>false,'conditions'=>array('Department.id = StoreLocation.department_id')),
						'Account'=>array('foreignKey'=>false,'conditions'=>array('Account.id = StoreLocation.account_id')),
						'LocationType'=>array('foreignKey'=>false,'conditions'=>array('LocationType.id = StoreLocation.location_type_id'))
				))
		);
		$location = $this->StoreLocation->find('first',array('fields'=>array('StoreLocation.name','StoreLocation.assignment_path_rule',
				'StoreLocation.description','StoreLocation.role_id','Department.name','Account.name','LocationType.name'),
				'conditions'=>array('StoreLocation.id'=>$storeLocationId)));
		$this->set('location',$location);
		$this->set('role',$this->Role->find('list',array('fields'=>array('id','name'),
				'conditions'=>array('id'=>explode('|',$location['StoreLocation']['role_id'])))));
	}

	/**
	 * Delete Store Location
	 * @param unknown_type $storeLocationId
	 * @author Gaurav Chauriya
	 */
	public function deleteStoreLocation($storeLocationId){
		$this->uses  = array('StoreLocation');
		$deleteArray['id'] = $storeLocationId;
		$deleteArray['is_deleted'] = 1;
		$this->StoreLocation->saveStoreLocation($deleteArray);
		$this->Session->setFlash(__('Deleted Successfully', true, array('class'=>'message')));
		$this->redirect(array('controller'=>'Locations','action'=>'storeLocation'));
	}

	/**
	 * Location Type
	 * for listing,adding and updating Store Locations
	 * @param integer $storeLocationId
	 * @author Gaurav Chauriya
	 */
	public function locationType($locationTypeId = null){
		$this->layout = 'advance';
		$this->uses  = array('LocationType','Account');
		$this->set('title_for_layout', __('Location Type', true));
		if($this->request->data['LocationType']){
			$this->LocationType->saveLocationType($this->request->data['LocationType']);
			$message = ($this->request->data['LocationType']['id']) ? 'Updated Successfully' : 'Added Successfully';
			$this->Session->setFlash(__($message, true, array('class'=>'message')));
		}
		if($this->params->query['name']){
			$searchByName['LocationType.name Like'] = $this->params->query['name'].'%';
		}
		$this->paginate = array(
				'evalScripts' => true,
				'limit' => Configure::read('number_of_rows'),
				'order' => array('LocationType.id'=>'DESC'),
				'fields'=> array('LocationType.id','LocationType.name','LocationType.description'),
				'conditions' => array('LocationType.is_deleted' => 0,$searchByName)
		);
		$data = $this->paginate('LocationType');
		if($locationTypeId){
			$this->data  = $this->LocationType->read(null,$locationTypeId);
			$this->set('action','edit');
		}
		$this->set('data', $data);
		$this->set('account',$this->Account->find('list',array('fields'=>array('id','name'),'conditions'=>array('is_deleted'=>0),'order' => array('Account.name'),
				'group'=>'Account.name')));
	}

	/**
	 * View Location Type Details
	 * @param unknown_type $storeLocationId
	 * @author Gaurav Chauriya
	 */
	public function viewLocationType($locationTypeId){
		$this->uses  = array('LocationType');
		$this->LocationType->bindModel(array(
				'hasOne'=>array(
						'Account'=>array('foreignKey'=>false,'conditions'=>array('Account.id = LocationType.account_id')),
				)));
		$this->set('locationType',$this->LocationType->find('first',array('conditions'=>array('LocationType.id'=>$locationTypeId))));
		$this->set(array('stockRule'=>Configure::read('stockRule'),'reStockRule'=>Configure::read('reStockRule'),
				'transientAssignmentRule'=>Configure::read('transientAssignmentRule'),'productAssignmentRule'=>Configure::read('productAssignmentRule'),
				'inventoryType'=>Configure::read('inventoryType'),'consignmentType'=>Configure::read('consignmentType')));
	}

	/**
	 * Delete Store Location
	 * @param unknown_type $storeLocationId
	 * @author Gaurav Chauriya
	 */
	public function deleteLocationType($locationTypeId){
		$this->uses  = array('LocationType');
		$deleteArray['id'] = $locationTypeId;
		$deleteArray['is_deleted'] = 1;
		$this->LocationType->saveLocationType($deleteArray);
		$this->Session->setFlash(__('Deleted Successfully', true, array('class'=>'message')));
		$this->redirect(array('controller'=>'Locations','action'=>'locationType'));
	}
	
	public function getLocations($company_id)
	{
		if(!empty($company_id))
		{
			$data = $this->Location->find('list',array('conditions'=>array('company_id'=>$company_id,'is_deleted'=>0,'is_active'=>1)));
			echo json_encode($data);
			exit;
		}
	}

}
?>