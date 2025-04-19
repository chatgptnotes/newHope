<?php
/**
 * DoctorsController file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Hope hospital
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Santosh R. Yadav
 */
class DoctorsController extends AppController {

	public $name = 'Doctors';
	public $uses = array('Doctor');
	public $helpers = array('Html','Form', 'Js','DateFormat','General');
	public $components = array('RequestHandler','Email','DateFormat');

	/**
	 * doctors listing by superadmin url
	 *
	*/

	public function superadmin_index() {
		$location_id = $this->Session->read('locationid');
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array(
						'Doctor.doctor_name' => 'desc'
				),
				'conditions' => array('Doctor.is_deleted' => 0,'Doctor.is_active' => 1,'Role.name'=> 'doctor', 'Doctor.location_id' => $location_id)
		);
		$this->set('title_for_layout', __('Superadmin - Manage Doctors', true));
		$this->Doctor->recursive = 0;
		$data = $this->paginate('Doctor');
		$this->set('data', $data);
	}

	/**
	 * doctors view by superadmin url
	 *
	 */
	public function superadmin_view($id = null) {
		$this->loadModel("Department");
		$this->set('title_for_layout', __('Superadmin - Doctor Detail', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid Superadmin', true));
			$this->redirect(array("controller" => "doctors", "action" => "index", "superadmin" => true));
		}
		$doctorDetails = $this->Doctor->read(null, $id);
		$doctorDepartment = $this->Department->read(null, $doctorDetails['DoctorProfile']['department_id']);
		$this->set('doctor', $doctorDetails);
		$this->set('department', $doctorDepartment);
	}

	/**
	 * doctors add by superadmin url
	 *
	 */
	public function superadmin_add() {
		$this->uses = array('City', 'Country', 'State', 'Location', 'Role', 'Initial', 'Department', 'DoctorProfile');
		$this->set('title_for_layout', __('Superadmin - Add New Doctor', true));
		if ($this->request->is('post')) {
			$this->Doctor->create();
			$this->Doctor->save($this->request->data);
			$errors = $this->Doctor->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
				// save to doctor profile table //
				$this->request->data['DoctorProfile']['dateofbirth'] = $this->DateFormat->formatDate2STD($this->request->data['DoctorProfile']['dateofbirth'],Configure::read('date_format'));
				$this->request->data['DoctorProfile']['expiration_date'] = $this->DateFormat->formatDate2STD($this->request->data['DoctorProfile']['expiration_date'],Configure::read('date_format'));
				$this->Doctor->saveDoctorProfile($this->request->data);
				$this->Session->setFlash(__('The doctor has been saved', true));
				$this->redirect(array("controller" => "doctors", "action" => "index", "superadmin" => true));
			}
		}
		$this->set('cities', $this->City->find('list', array('fields'=> array('id', 'name'))));
		$this->set('states', $this->State->find('list', array('fields'=> array('id', 'name'))));
		$this->set('countries', $this->Country->find('list', array('fields'=> array('id', 'name'))));
		$this->set('locations', $this->Location->find('list', array('fields'=> array('id', 'name'), 'conditions' => array('Location.is_deleted' => 0,'Location.is_active' => 1))));
		$this->set('roles', $this->Role->find('list', array('fields'=> array('id', 'name'), 'conditions' => array('Role.is_deleted' => 0))));
		$this->set('initials', $this->Initial->find('list', array('fields'=> array('id', 'name'))));
		$this->set('departments', $this->Department->find('list', array('fields'=> array('id', 'name'), 'conditions' => array('Department.is_active' => 1))));
		/* $this->set('facilities', $this->Facility->find('list', array('fields'=> array('id', 'name'), 'conditions' => array('Facility.is_deleted' => 0,'Facility.is_active' => 1))));*/
	}

	/**
	 * doctors edit by superadmin url
	 *
	 */
	public function superadmin_edit($id = null) {
		$this->uses = array('City', 'Country', 'State', 'Location', 'Role', 'Initial', 'Department','DoctorProfile');
		$this->set('title_for_layout', __('Superadmin - Edit Doctor Detail', true));

		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid Doctor', true));
			$this->redirect(array("controller" => "doctors", "action" => "index", "superadmin" => true));
		}
		if ($this->request->is('post') && !empty($this->request->data)) {
			$this->Doctor->id = $this->request->data["Doctor"]['id'];
			$this->Doctor->save($this->request->data);
			$errors = $this->Doctor->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
				// save to doctor profile table //
				$this->request->data['DoctorProfile']['doctor_name'] = $this->data['DoctorProfile']['first_name']." ".$this->data['DoctorProfile']['middle_name']." ".$this->data['DoctorProfile']['last_name'];
				$this->request->data['DoctorProfile']['dateofbirth'] = $this->DateFormat->formatDate2STD($this->request->data["DoctorProfile"]['dateofbirth'],Configure::read('date_format'));
				$this->Doctor->saveDoctorProfile($this->request->data);
				$this->Session->setFlash(__('The Doctor has been updated', true));
				$this->redirect(array("controller" => "doctors", "action" => "index", "superadmin" => true));
			}
		} else {
			$this->request->data = $this->Doctor->read(null, $id);
			$this->set('doctorprofile', $this->DoctorProfile->find("first", array('conditions' => array('DoctorProfile.user_id' => $id))));
		}
		$this->set('cities', $this->City->find('list', array('fields'=> array('id', 'name'))));
		$this->set('states', $this->State->find('list', array('fields'=> array('id', 'name'))));
		$this->set('countries', $this->Country->find('list', array('fields'=> array('id', 'name'))));
		$this->set('locations', $this->Location->find('list', array('fields'=> array('id', 'name'), 'conditions' => array('Location.is_deleted' => 0,'Location.is_active' => 1))));
		$this->set('roles', $this->Role->find('list', array('fields'=> array('id', 'name'), 'conditions' => array('Role.is_deleted' => 0))));
		$this->set('initials', $this->Initial->find('list', array('fields'=> array('id', 'name'))));
		$this->set('departments', $this->Department->find('list', array('fields'=> array('id', 'name'), 'conditions' => array('Department.is_active' => 1))));
		/*$this->set('facilities', $this->Facility->find('list', array('fields'=> array('id', 'name'), 'conditions' => array('Facility.is_deleted' => 0,'Facility.is_active' => 1))));*/
	}

	/**
	 * doctors delete by superadmin url
	 *
	 */
	public function superadmin_delete($id = null) {
		$this->set('title_for_layout', __('Superadmin - Delete Doctor', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Doctor', true));
			$this->redirect(array("controller" => "doctors", "action" => "index", "superadmin" => true));
		}
		if (!empty($id)) {
			$this->Doctor->deleteDoctor($this->request->params);
			$this->Session->setFlash(__('Doctor deleted', true));
			$this->redirect(array("controller" => "doctors", "action" => "index", "superadmin" => true));
		}else {
			$this->Session->setFlash(__('This doctor is associated with other details so you can not be deleted this doctor', true));
			$this->redirect(array("controller" => "doctors", "action" => "index", "superadmin" => true));
		}
	}


	/**
	 * doctors listing by admin url
	 *
	 */

	public function admin_index() {
		$this->uses = array('Location');
		//$location_id = $this->Session->read('locationid');
		$this->Location->recursive = -1;

	
		if($this->request->data['Doctor']['first_name']!=''){
			$conditions['Doctor']['first_name LIKE'] = "%".$this->request->data['Doctor']['first_name']."%";
		}
		if($this->request->data['Doctor']['last_name']!=''){
			$conditions['Doctor']['last_name LIKE'] = "%".$this->request->data['Doctor']['last_name']."%";
		}
		
		$conditions['Doctor']['is_deleted'] = 0;
		$conditions['Role']['id'] != 1;
		$conditions['Role']['name'] =array(Configure::read('doctorLabel'), Configure::read('RegistrarLabel'));
		$conditions['Doctor']['location_id'] = $this->Session->read('locationid');	
		$conditions = $this->postConditions($conditions);		
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array(
						'DoctorProfile.doctor_name' => 'asc'
				),
				'conditions' =>$conditions
				/*'conditions' => array('Doctor.is_deleted' => 0,'Role.id <>' => 1,'Role.name'=> array(Configure::read('doctorLabel'), Configure::read('RegistrarLabel')), 'Doctor.location_id' => $location_id)*/
		);
	
		$this->set('title_for_layout', __('Admin - Manage Doctors', true));
		$this->Doctor->recursive = 0;
		$data = $this->paginate('Doctor', false);
		//debug($data);
		$this->set('data', $data);
	}

	/**
	 * doctors view by admin url
	 *
	 */
	public function admin_view($id = null) {
		$this->loadModel("Department");
		$this->loadModel('LicensureType');
		$this->loadModel('User');
		$this->set('title_for_layout', __('Admin - Doctor Detail', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid Admin', true));
			$this->redirect(array("controller" => "doctors", "action" => "index", "admin" => true));
		}
		$doctorDetails = $this->Doctor->read(null, $id);
		$userData = $this->User->read(null, $id) ;
		$licenture=$this->LicensureType->find('first', array('fields'=> array('id', 'name'),'conditions'=>array('LicensureType.id'=>$userData['User']['id'])));
		$this->set('licenture',$licenture);
		$doctorDepartment = $this->Department->read(null, $doctorDetails['DoctorProfile']['department_id']);
		$this->set('doctor', $doctorDetails);
		$this->set('users', $userData);
		$this->set('department', $doctorDepartment);
		$applicationStatus=Configure::read('enrollment_status');
		//debug($applicationStatus);exit;
		$this->set('applicationStatus', $applicationStatus);
	}

	/**
	 * doctors add by admin url
	 *
	 */
	public function admin_add() {
		$this->uses = array('City', 'Country', 'State', 'Location', 'Role', 'Initial', 'Department', 'DoctorProfile');
		$this->set('title_for_layout', __('Admin - Add New Doctor', true));
		if ($this->request->is('post')) {
			$this->Doctor->create();
			debug($this->request->data);exit;
			$this->Doctor->save($this->request->data);
			
			$errors = $this->Doctor->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
				// save to doctor profile table //
				$this->request->data['DoctorProfile']['dateofbirth'] = $this->DateFormat->formatDate2STD($this->request->data["DoctorProfile"]['dateofbirth'],Configure::read('date_format'));
				$this->request->data['DoctorProfile']['expiration_date'] = $this->DateFormat->formatDate2STD($this->request->data["DoctorProfile"]['expiration_date'],Configure::read('date_format'));
				
				$this->Doctor->saveDoctorProfile($this->request->data);
				$this->Session->setFlash(__('The doctor has been saved', true));
				$this->redirect(array("controller" => "doctors", "action" => "index", "admin" => true));
			}
		}
		$this->set('cities', $this->City->find('list', array('fields'=> array('id', 'name'))));
		$this->set('states', $this->State->find('list', array('fields'=> array('id', 'name'))));
		$this->set('countries', $this->Country->find('list', array('fields'=> array('id', 'name'))));
		$this->set('locations', $this->Location->find('list', array('fields'=> array('id', 'name'), 'conditions' => array('Location.is_deleted' => 0,'Location.is_active' => 1))));
		$this->set('roles', $this->Role->find('list', array('fields'=> array('id', 'name'), 'conditions' => array('Role.is_deleted' => 0))));
		$this->set('initials', $this->Initial->find('list', array('fields'=> array('id', 'name'))));
		$this->set('departments', $this->Department->find('list', array('fields'=> array('id', 'name'), 'conditions' => array('Department.is_active' => 1))));
		/* $this->set('facilities', $this->Facility->find('list', array('fields'=> array('id', 'name'), 'conditions' => array('Facility.is_deleted' => 0,'Facility.is_active' => 1))));*/
	}

	/**
	 * doctors edit by admin url
	 *
	 */
	public function admin_edit($id = null) {
		$this->uses = array('City', 'Country','User','State', 'Location', 'Role', 'Initial', 'Department','DoctorProfile');
		$this->set('title_for_layout', __('Admin - Edit Doctor Detail', true));

		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid Doctor', true));
			$this->redirect(array("controller" => "doctors", "action" => "index", "admin" => true));
		}
		if ($this->request->is('post') && !empty($this->request->data)) {
			$this->Doctor->id = $this->request->data["Doctor"]['id'];
			$this->Doctor->save($this->request->data);
			//$this->DoctorProfile->save($this->request->data);
			$errors = $this->Doctor->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
				// save to doctor profile table //
				$this->request->data['DoctorProfile']['doctor_name'] = $this->request->data['DoctorProfile']['first_name']." ".$this->request->data['DoctorProfile']['middle_name']." ".$this->request->data['DoctorProfile']['last_name'];
				$this->request->data['DoctorProfile']['dateofbirth'] = $this->DateFormat->formatDate2STD($this->request->data["DoctorProfile"]['dateofbirth'],Configure::read('date_format'));
				$this->request->data['DoctorProfile']['expiration_date'] = $this->DateFormat->formatDate2STD($this->request->data["DoctorProfile"]['expiration_date'],Configure::read('date_format'));
				
				
				$this->Doctor->saveDoctorProfile($this->request->data);
				$this->Session->setFlash(__('The Doctor has been updated', true));
				$this->redirect(array("controller" => "doctors", "action" => "index", "admin" => true));
			}
		} else {
			$this->request->data = $this->Doctor->read(null, $id);

			$this->set('doctorprofile', $this->DoctorProfile->find("first", array('conditions' => array('DoctorProfile.user_id' => $id))));
		}
		$this->set('cities', $this->City->find('list', array('fields'=> array('id', 'name'))));
		$this->set('states', $this->State->find('list', array('fields'=> array('id', 'name'))));
		$this->set('countries', $this->Country->find('list', array('fields'=> array('id', 'name'))));
		$this->set('locations', $this->Location->find('list', array('fields'=> array('id', 'name'), 'conditions' => array('Location.is_deleted' => 0,'Location.is_active' => 1))));
		$this->set('roles', $this->Role->find('list', array('fields'=> array('id', 'name'), 'conditions' => array('Role.is_deleted' => 0))));
		$this->set('initials', $this->Initial->find('list', array('fields'=> array('id', 'name'))));
		$this->set('departments', $this->Department->find('list', array('fields'=> array('id', 'name'), 'conditions' => array('Department.is_active' => 1))));
		/* $this->set('facilities', $this->Facility->find('list', array('fields'=> array('id', 'name'), 'conditions' => array('Facility.is_deleted' => 0,'Facility.is_active' => 1))));*/
		//debug($data);exit;
		//$this->set('userData',$doctor);
	}
	


	/**
	 * doctors profile edit by admin url
	 *
	 */
	public function admin_doctorprofile($id = null) {
       //$expirydate=date('m/d/Y');
		//pr($this->request->data);exit;
		
		$this->uses = array('Department', 'DoctorProfile', 'Location', 'Country', 'State', 'City','User','LicensureType');
		$this->set('title_for_layout', __('Admin - Add Doctor Profile', true));

		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid Doctor', true));
			$this->redirect(array("controller" => "doctors", "action" => "index", "admin" => true));
		}
		
		if ($this->request->is('post') && !empty($this->request->data)) {
			//sdebug($this->request->data);exit;
			// save to doctor profile table //
			$this->request->data['DoctorProfile']['doctor_name'] = ucfirst($this->request->data['DoctorProfile']['first_name'])." ".ucfirst($this->request->data['DoctorProfile']['middle_name'])." ".ucfirst($this->request->data['DoctorProfile']['last_name']);
			$this->request->data['DoctorProfile']['dateofbirth'] = $this->DateFormat->formatDate2STD($this->request->data["DoctorProfile"]['dateofbirth'],Configure::read('date_format'));
			$this->request->data['DoctorProfile']['expiration_date'] = $this->DateFormat->formatDate2STD($this->request->data["DoctorProfile"]['expiration_date'],Configure::read('date_format'));
				
			
			
			$city_id = $this->City->checkIsCityAvailable($this->request->data['DoctorProfile']['city_id'],$this->request->data['DoctorProfile']['state_id']);
			$this->request->data['DoctorProfile']['city_id'] = $city_id ; //city id instead of name coming from user form
			$this->Doctor->saveDoctorProfile($this->request->data);
			$this->Session->setFlash(__('The Doctor Profile has been saved', true));
			$this->redirect(array("controller" => "doctors", "action" => "index", "admin" => true));
			

		}else{
			$this->request->data = $this->Doctor->read(null, $id);
			
			
			$assignedArray = $this->DoctorProfile->find('list',array('fields'=>array('token_alphabet','token_alphabet'),'conditions'=>array('token_alphabet !=' =>'')));
			$month_array = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
			$final = array_diff($month_array,$assignedArray);
			foreach($final as $mo =>$alpha){
				$final1[$alpha] =$alpha;
			}
			$result = $this->DoctorProfile->find("first", array('conditions' => array('DoctorProfile.user_id' => $id)));
			$self= array($result['DoctorProfile']['token_alphabet']=>$result['DoctorProfile']['token_alphabet']);
			$this->set('doctorprofile',$result);
			$alphaArr = array_merge($final1,$self) ;
			ksort($alphaArr);
			$this->set('alphabet',$alphaArr) ;
			//debug($data);exit;
		}
		
		$userData = $this->User->read(null, $id) ;
		$this->set('userData',$userData) ;
		$this->set('licenture',$this->LicensureType->find('list', array('fields'=> array('id', 'name'),'order' => array('LicensureType.name'))));
		$this->set('states', $this->State->find('list', array('order' => array('State.name'),'fields'=> array('id', 'name'))));
		$this->set('countries', $this->Country->find('list', array('order' => array('Country.name'),'fields'=> array('id', 'name'))));
		$this->set('departments', $this->Department->find('list', array('order' => array('Department.name'),'fields'=> array('id', 'name'), 'conditions' => array('Department.is_active' => 1, 'Department.location_id' => $this->Session->read('locationid')))));
		$this->set('locations', $this->Location->find('list', array('order' => array('Location.name'),'fields'=> array('id', 'name'), 'conditions' => array('Location.is_active' => 1, 'Location.is_deleted' => 0))));	
	}

	/**
	 * doctors delete by admin url
	 *
	 */
	public function admin_delete($id = null) {
		$this->set('title_for_layout', __('Admin - Delete Doctor', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Doctor', true));
			$this->redirect(array("controller" => "doctors", "action" => "index", "admin" => true));
		}
		if (!empty($id)) {
			$this->Doctor->deleteDoctor($this->request->params);
			$this->Session->setFlash(__('Doctor deleted', true));
			$this->redirect(array("controller" => "doctors", "action" => "index", "admin" => true));
		}else {
			$this->Session->setFlash(__('This doctor is associated with other details so you can not be deleted this doctor', true));
			$this->redirect(array("controller" => "doctors", "action" => "index", "admin" => true));
		}
	}

	/**
	 * doctors edit by doctor ownself
	 *
	 */
	public function doctor_account($id = null) {
		$this->uses = array('City', 'Country', 'State', 'Location', 'Role', 'Initial', 'Department','DoctorProfile');
		$this->set('title_for_layout', __('Edit Doctor Detail', true));

		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid Doctor', true));
			$this->redirect("/");
		}
		if ($this->request->is('post') && !empty($this->request->data)) {
			$this->Doctor->id = $this->request->data["Doctor"]['id'];
			$this->Doctor->save($this->request->data);
			$errors = $this->Doctor->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
				// save to doctor profile table //
				$this->request->data['DoctorProfile']['dateofbirth'] = $this->DateFormat->formatDate2STD($this->request->data["DoctorProfile"]['dateofbirth'],Configure::read('date_format'));
				$this->Doctor->saveDoctorProfile($this->request->data);
				$this->Session->setFlash(__('The Doctor has been updated', true));
				$this->redirect("/");
			}
		} else {
			$this->request->data = $this->Doctor->read(null, $id);
			$this->set('doctorprofile', $this->DoctorProfile->find("first", array('conditions' => array('DoctorProfile.user_id' => $id))));
		}
		$this->set('cities', $this->City->find('list', array('fields'=> array('id', 'name'))));
		$this->set('states', $this->State->find('list', array('fields'=> array('id', 'name'))));
		$this->set('countries', $this->Country->find('list', array('fields'=> array('id', 'name'))));
		$this->set('locations', $this->Location->find('list', array('fields'=> array('id', 'name'), 'conditions' => array('Location.is_deleted' => 0,'Location.is_active' => 1))));
		$this->set('roles', $this->Role->find('list', array('fields'=> array('id', 'name'), 'conditions' => array('Role.is_deleted' => 0))));
		$this->set('initials', $this->Initial->find('list', array('fields'=> array('id', 'name'))));
		$this->set('departments', $this->Department->find('list', array('fields'=> array('id', 'name'), 'conditions' => array('Department.is_active' => 1))));
		/* $this->set('facilities', $this->Facility->find('list', array('fields'=> array('id', 'name'), 'conditions' => array('Facility.is_deleted' => 0,'Facility.is_active' => 1))));*/
	}
	/**
	 * doctors appointment listing
	 *
	 */
	function doctor_appointment(){
		$this->loadModel("DoctorAppointment");
		$this->set('title_for_layout', __('Doctor Appointment management', true));
		if(!empty($this->request->data['Doctor']['appointmentDate'])) {
			$appointmentDateVal = $this->DateFormat->formatDate2STD($this->request->data['Doctor']['appointmentDate'],Configure::read('date_format'));

			$conditions = array('DoctorAppointment.is_deleted' => 0, 'Doctor.id' => $this->Auth->user('id'), 'DoctorAppointment.date' => $appointmentDateVal);
		} else {
			$conditions = array('DoctorAppointment.is_deleted' => 0, 'Doctor.id' => $this->Auth->user('id'), 'DoctorAppointment.date' => date('Y-m-d'));
		}
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array('DoctorAppointment.date' => 'asc'),
				'conditions'=>$conditions
		);
		//$this->set('appointdate',$this->request->data['appointmentDate']);
		$this->set('data',$this->paginate('DoctorAppointment'));

	}

	/**
	 * doctor appointment view
	 *
	 */
	public function appointment_view($id = null) {
		$this->loadModel("DoctorAppointment");
		$this->set('title_for_layout', __('Doctor Appointment View', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid Doctor Appointment', true));
			$this->redirect(array("controller" => "doctor", "action" => "doctor_appointment"));
		}
		$this->set('doctor_appointment', $this->DoctorAppointment->read(null, $id));
	}

	/**
	 * doctors account settings
	 *
	 */
	public function account_settings($id = null) {
		$this->uses = array('Department', 'DoctorProfile', 'Location');
		$this->set('title_for_layout', __('Admin - Add Doctor Profile', true));

		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid Doctor', true));
			$this->redirect(array("controller" => "doctors", "action" => "index", "admin" => true));
		}
		if ($this->request->is('post') && !empty($this->request->data)) {
			// save to doctor profile table //
			$this->request->data['DoctorProfile']['dateofbirth'] = $this->DateFormat->formatDate2STD($this->request->data["DoctorProfile"]['dateofbirth'],Configure::read('date_format'));
			$this->Doctor->saveDoctorProfile($this->request->data);
			$this->Session->setFlash(__('The Doctor Profile has been saved', true));
			$this->redirect(array("controller" => "users", "action" => "common"));

		} else {
			$this->request->data = $this->Doctor->read(null, $id);
			$this->set('doctorprofile', $this->DoctorProfile->find("first", array('conditions' => array('DoctorProfile.user_id' => $id))));
		}
		$this->set('departments', $this->Department->find('list', array('fields'=> array('id', 'name'), 'conditions' => array('Department.is_active' => 1))));
		$this->set('locations', $this->Location->find('list', array('fields'=> array('id', 'name'), 'conditions' => array('Location.is_active' => 1, 'Location.is_deleted' => 0))));

	}
	/* fetch the doctor list*/
	public function getDoctorDetail($field=null){
		$this->loadModel('User');
		$searchKey = $this->params->query['q'];


		$conditions[$field." like"] = $searchKey."%";
		$conditions["User.is_deleted"] = "0";
		//	  $conditions["DoctorProfile.is_active"] = 1;
		$conditions["Role.name"] = Configure::read('doctorLabel');
		$conditions["User.location_id"] = $this->Session->read('locationid');
		$doctors = $this->User->find('all', array( 'conditions'=>$conditions));
		$output = '';
		foreach ($doctors as $value) {
			$output .= $value['User']['first_name']."|".$value['User']['id']."\n";
		}
		echo $output;
		exit;//dont remove this



	}
	public function clinicalsuport($doc=null){//debug($this->request->data);debug($this->Session->read('role'));exit;
		//echo "<pre>";print_r($this->request->data);
		$this->uses=array('ClinicalSupport','DoctorProfile','User');
		//-----------------------------------show the reminders for the paticular doctors-------------------------------------------------------------------
		$exp_doc_name=explode(" ",$this->request->data['clinicalsuport']['dname']);
		 
		$doc_username=$this->User->find('list',array('fields'=>array('User.username'),'conditions'=>array('User.first_name'=>$exp_doc_name['1'],'User.last_name'=>$exp_doc_name['3'])));

		$reminder_show=$this->ClinicalSupport->find('all',array('conditions'=>array('username'=>$doc_username)));
		 
		$this->set('RD_old',$reminder_show);
		//============================================================end===================================================================================
		if($doc_username=='admin'){
			$doc_reminder=$this->Doctor->RemindersSchedule($reminders=array());
		}

		 
		$this->set('doctors_name',$this->DoctorProfile->getDoctors());
		$name=$_SESSION['Auth']['User']['username'];

		$reminder_dta=$this->ClinicalSupport->find('all',array('conditions'=>array('username'=>$name)));

		$this->set('RD',$reminder_dta);
		
		if(isset($this->request->data)&& !empty($this->request->data)){
			
			
			if($this->request->data['ClinicalSupport']['dname']!=''){
			
				if($this->request->data['ClinicalSupport']['dname']=="admin"){
						
					$exp_names=explode(" ",$this->request->data['ClinicalSupport']['dname_major']);
						
					$doc_username=$this->User->find('all',array('fields'=>array('User.username'),'conditions'=>array('User.first_name'=>$exp_names[1],'User.last_name'=>$exp_names[3])));
						
					$exp_name=$doc_username['0']['User']['username'];
						
						
				}
				else{
					$exp_name=$this->request->data['ClinicalSupport']['dname'];
						
				}
				$rolename = $this->Session->read('role');
				if($rolename=='Admin'){
					//echo "<pre>";print_r($this->request->data);
					//exit;
					$expl_dname=explode(' ',$this->request->data['ClinicalSupport']['dname_major']);
					//debug($exp_name);exit;
					$hyp=$this->request->data['ClinicalSupport']['Hyptension'];
					$ccr=$this->request->data['ClinicalSupport']['ccr'];
					$dr=$this->request->data['ClinicalSupport']['dr'];
					$dmc=$this->request->data['ClinicalSupport']['dmc'];
					
					$Alcoholism=$this->request->data['ClinicalSupport']['Alcoholism'];
					$Depression=$this->request->data['ClinicalSupport']['Depression'];
					$Urinary=$this->request->data['ClinicalSupport']['Urinary'];
					$adult_care=$this->request->data['ClinicalSupport']['adult_care'];
					$risky_sex=$this->request->data['ClinicalSupport']['risky_sex'];
					$drug_abuse=$this->request->data['ClinicalSupport']['drug_abuse'];
					
					$this->ClinicalSupport->updateAll(array('Hyptension'=>"'$hyp'",'ccr'=>"'$ccr'",'dr'=>"'$dr'",'dmc'=>"'$dmc'",
							'Alcoholism'=>"'$Alcoholism'",
							'Depression'=>"'$Depression'",
							'Urinary'=>"'$Urinary'",
							'adult_care'=>"'$adult_care'",
							'risky_sex'=>"'$risky_sex'",
							'drug_abuse'=>"'$drug_abuse'",
							),array('username'=>$this->Session->read('username')));
					
					//$log = $this->ClinicalSupport->getDataSource()->getLog(false, false);
					//debug($log);exit;
					$this->Session->setFlash(__('Reminders Updated', true));
					$this->redirect(array('controller' => 'doctors', 'action' => 'clinicalsuport'));
					
				}
				else{
				$m_date=date("Y-m-d H:i:s");
				
				$this->ClinicalSupport->id= $this->request->data['ClinicalSupport']['id'];
				$this->ClinicalSupport->save($this->request->data);
				//$log = $this->ClinicalSupport->getDataSource()->getLog(false, false);
				//debug($log);exit;
			//	debug($this->ClinicalSupport->getDataSource()->getLog(false, false));
			//	exit;
				$this->Session->setFlash(__('Reminders Updated', true));
				$this->redirect(array('controller' => 'doctors', 'action' => 'clinicalsuport'));
				}
				
			}
			 
			else{
				$c_date=date("Y-m-d H:i:s");
				
				$userCount=$this->ClinicalSupport->find('count',array('conditions'=>array('ClinicalSupport.username'=>$this->Session->read('username'))));
				if($userCount=='0'){
				$this->ClinicalSupport->save(array('username'=>"$name",
						'Hyptension'=>$this->request->data['ClinicalSupport']['Hyptension'],
						'ccr'=>$this->request->data['ClinicalSupport']['ccr'],
						'dr'=>$this->request->data['ClinicalSupport']['dr'],
						'dmc'=>$this->request->data['ClinicalSupport']['dmc'],
						'conso'=>$this->request->data['ClinicalSupport']['conso'],
						
						'Alcoholism'=>$this->request->data['ClinicalSupport']['Alcoholism'],
						'Depression'=>$this->request->data['ClinicalSupport']['Depression'],
						'Urinary'=>$this->request->data['ClinicalSupport']['Urinary'],
						'adult_care'=>$this->request->data['ClinicalSupport']['adult_care'],
						'risky_sex'=>$this->request->data['ClinicalSupport']['risky_sex'],
						'drug_abuse'=>$this->request->data['ClinicalSupport']['drug_abuse'],
						
						'create_time'=>$c_date));
				}
				
				$this->Session->setFlash(__('Reminders Save', true));
			}
		}
		 
		 
	}
	public function RemindersSchedule($dname=null){
		 
		$this->uses=array('ClinicalSupport','DoctorProfile','User');
		//-----------------------------------show the reminders for the paticular doctors-------------------------------------------------------------------
		$exp_doc_name=explode(" ",$dname);
		debug($exp_doc_name);
		$doc_username=$this->User->find('list',array('fields'=>array('User.username'),'conditions'=>array('User.first_name'=>$exp_doc_name['1'],'User.last_name'=>$exp_doc_name['3'])));
		 
		$reminder_show=$this->ClinicalSupport->find('all',array('conditions'=>array('username'=>$doc_username)));
		echo json_encode($reminder_show);
		//debug($dname);
		exit;
		 
		//	$this->set('RD_old',$reminder_show);
		//============================================================end===================================================================================
		 
	}

	public function config($dname=null){
		//echo "<pre>";print_r($this->request->data);
		$this->uses=array('ClinicalSupport');
		//-------------setting the reminder in ctp for the doctors form DB-------------------------------------------------
		$config_data=$this->ClinicalSupport->find('all',array('conditions'=>array('ClinicalSupport.username'=>$dname)));
		$this->set('config_data',$config_data);
		//-------------------------------------------------------------------------------------------------------------------
		//echo "<pre>";print_r($config_data);
		//-----------------------------Update and save the reminders for the doctors-------------------------------------------
		$this->set('d_name',$dname);
		if(isset($this->request->data)&& !empty($this->request->data)){
			$com_h= $this->request->data['config']['com_h'];
			$age=  $this->request->data['config']['age'];
			$com_c=  $this->request->data['config']['com_c'];
			$c_age=  $this->request->data['config']['c_age'];
			$test_c=  $this->request->data['config']['test_c'];
			$com_d=  $this->request->data['config']['com_d'];
			$d_age=  $this->request->data['config']['d_age'];
			$test_d=  $this->request->data['config']['test_d'];
			
			$com_c1=  $this->request->data['config']['com_c1'];
			$c_age1=  $this->request->data['config']['c_age1'];
			$d_age1=  $this->request->data['config']['d_age1'];
			$com_d1=  $this->request->data['config']['com_d1'];
			
			$com_e=  $this->request->data['config']['com_e'];
			$age_e=  $this->request->data['config']['age_e'];
			
			$com_nnd=  $this->request->data['config']['com_nnd'];
			$age_nnd=  $this->request->data['config']['age_nnd'];
			
			$this->ClinicalSupport->updateAll(array('com_h'=>"'$com_h'",'age'=>"'$age'",
					'com_c'=>"'$com_c'",'c_age'=>"'$c_age'",'test_c'=>"'$test_c'",
					'com_d'=>"'$com_d'",'d_age'=>"'$d_age'",'test_d'=>"'$test_d'"
					,'com_c1'=>"'$com_c1'",'c_age1'=>"'$c_age1'",'d_age1'=>"'$d_age1'",'com_d1'=>"'$com_d1'"
					,'com_e'=>"'$com_e'",'age_e'=>"'$age_e'"
					,'com_nnd'=>"'$com_nnd'",'age_nnd'=>"'$age_nnd'"
			),array('username'=>$this->request->data['config']['dname']));
			$this->Session->setFlash(__('Reminders Edited', true));
		}
		//---------------------------------------------------------------------------------------------------------------------------
		 
		//echo  $dname;
		 
	}
	public function a(){
		
	}
	public function b(){
	
	}
	public function c(){
	
	}
	public function d(){
	
	}
	/*
	 * action and view created for traversing patient 
	 * not in use 
	 * called form patient_information element
	 */
	public function doctorsPatientSearch(){
	
		$this->uses = array('Patient');
		$this->layout = false;
		$this->set('data','');
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows')
		);
	
		$role = $this->Session->read('role');
		$department_id = $_Session['Auth']['User']['department_id'];
	
		//Search patient as per the url request
		if(!empty($this->params->query['type'])){
			if(strtolower($this->params->query['type'])=='emergency'){
				$search_key['Patient.admission_type'] = "IPD";
				$search_key['Patient.is_emergency'] = "1";
			}else if($this->params->query['type']=='IPD'){
				$search_key['Patient.admission_type'] = $this->params->query['type'];
				$search_key['Patient.is_emergency'] = "0";
			}else{
				$search_key['Patient.admission_type'] = $this->params->query['type'];
			}
		}
		//Search patient if type is empty for future appointment //
		if(empty($this->params->query['type'])){
			$inpatientUID = $this->Patient->find('list',array('fields'=>'patient_id','conditions'=>array('Patient.patient_id <>'=>'', 'Patient.is_discharge'=>0,'Patient.is_deleted'=>0),'group'=>'Patient.patient_id','order'=>'patient_id DESC'));
			$search_key['Patient.admission_type'] = array('IPD','OPD');
			$search_key["NOT"] = array("Patient.patient_id" => $inpatientUID);
			$orderstatus = array('Patient.discharge_date' => 'desc');
		} else {
			$orderstatus = array('Patient.id' => 'desc');
		}
	
		if(!empty($this->params->query['dept_id'])){
			$search_key['Patient.department_id'] = $this->params->query['dept_id'];
		}
		if(!empty($this->params->query['type'])){
			if($this->params->query['patientstatus']=='discharged' || $this->params->query['patientstatus']=='processed') {
				$search_key['Patient.is_discharge'] = 1;//display only non-discharge patient
			} else {
				$search_key['Patient.is_discharge'] = 0;//display only non-discharge patient
			}
		}
		//EOF patient search as per category
	
		$search_key['Patient.is_deleted'] = 0;
		//if($role== Configure::read('adminLabel')){
		if($_SESSION['Auth']['User']['role_id']=='2'){
			$search_key['Patient.location_id']=$this->Session->read('locationid');
	
			$this->Patient->bindModel(array(
					'belongsTo' => array(
							'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id' )),
							'Initial' =>array('foreignKey' => false,'conditions'=>array('User.initial_id=Initial.id' )),
							'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
							'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
							'Location' =>array('foreignKey' => 'location_id')
					)),false);
		}else if($role== Configure::read('doctorLabel')){
	
			$search_key['Patient.location_id']=$this->Session->read('locationid');
			$search_key['Patient.doctor_id']=$this->Session->read('userid');
			$this->Patient->bindModel(array(
					'belongsTo' => array(
							'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id' )),
							'Initial' =>array('foreignKey' => false,'conditions'=>array('User.initial_id=Initial.id' )),
							'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
							'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
	
					)),false);
		}else if($role== Configure::read('nurseLabel')){
	
			$search_key['Patient.location_id']=$this->Session->read('locationid');
			$search_key['Patient.nurse_id']=$this->Session->read('userid');
			$this->Patient->bindModel(array(
					'belongsTo' => array(
							'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id' )),
							'Initial' =>array('foreignKey' => false,'conditions'=>array('User.initial_id=Initial.id' )),
							'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
							'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
	
					)),false);
		}
		else{
	
			$search_key['Patient.location_id']=$this->Session->read('locationid');
				
			$this->Patient->bindModel(array(
					'belongsTo' => array(
							'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id' )),
							'Initial' =>array('foreignKey' => false,'conditions'=>array('User.initial_id=Initial.id' )),
							'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
							'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
							'Location' =>array('foreignKey' => 'location_id')
					)),false);
				
		}
	
		
		// If Search is for emergency patient
		if(isset($this->params['named']['searchFor']) AND $this->params['named']['searchFor'] == 'emergency'){
			// Condition is here
	
			$conditions = array('OR'=>array(array('User.department_id'=>$department_id),array($search_key,'Patient.is_discharge'=>0,'Patient.admission_type'=>'IPD','Patient.is_emergency'=>1)));
	
		} else {
			// If patient is OPD
			if(!empty($this->params->query)){
				$search_ele = $this->params->query  ;//make it get
				if(!empty($search_ele['lookup_name'])){
					$search_key['Patient.lookup_name like '] = "%".trim($search_ele['lookup_name'])."%" ;
				}if(!empty($search_ele['patient_id'])){
					$search_key['Patient.patient_id like '] = "%".trim($search_ele['patient_id']) ;
				}if(!empty($search_ele['admission_id'])){
					$search_key['Patient.admission_id like '] = "%".trim($search_ele['admission_id']) ;
				}
				// Condition is here
				$conditions = $search_key;
			}else{
				// For IPD patient
				// Condition is here
				//$conditions = array($search_key,'Patient.is_discharge'=>0,'Patient.admission_type'=>'IPD');
				$conditions = array('OR'=>array(array('User.department_id'=>$department_id),array($search_key,'Patient.is_discharge'=>0,'Patient.admission_type'=>'IPD')));
			}
	
		}
		// Paginate Data here
	
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => $orderstatus,
				'fields'=> array('Patient.form_received_on,Patient.form_received_on,Patient.discharge_date,CONCAT(PatientInitial.name," ",Patient.lookup_name) as lookup_name,
						Patient.id,Patient.patient_id,Patient.admission_id,Patient.mobile_phone,Patient.landline_phone,CONCAT(User.first_name," ",User.last_name) as name, User.initial_id, Patient.create_time, Initial.name'),
				'conditions'=>$conditions
		);
	
		$this->set('data',$this->paginate('Patient'));
		
	}
	
	function index(){
		
	}
	
}
?>