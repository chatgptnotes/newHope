<?php
/**
 * This is roles controller file.
 *
 * Use to create/edit/view/delete roles
 * created : 16 Nov
 */
class RolesController extends AppController {

	public $name = 'Roles';
	public $uses = array('Role');
	public $helpers = array('Html','Form', 'Js');
	public $components = array('RequestHandler','Email');
	
	public function admin_index() {
		//$this->uses=array('Location');
		if($this->request->data){
			$conditions['Role.name LIKE'] = $this->request->data['name'].'%';
			$conditions['Role.name NOT'] = array('admin','superadmin');
		}else{
			$conditions['Role.name NOT'] = array('admin','superadmin');
		}
	//	$this->Role->unbindModel(array('hasMany'=>array('User')));
	//	$this->Role->bindModel(array('belongsTo'=>array('Location'=>array('foreignKey'=>false,'conditions'=>array('Role.location_id = Location.id')))));
		if($this->Session->read('role') !="superadmin"){
	    
			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'conditions' =>$conditions,//'Role.name <> \'admin\' and Role.name <> \'superadmin\'',
					'order' => array(
							'Role.name' => 'asc'
					)
			);

		}else{
		
			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'conditions' =>$conditions,//'Role.name <> \'admin\' and Role.name <> \'superadmin\'',
					'order' => array(
							'Role.name' => 'asc'
					)
			);
		}
		
		$this->set('title_for_layout', __('Manage Roles', true));
		$this->Role->recursive = 0;

		//collecting search param
		/*	if(!empty($this->request->data['Role']['search']) && ($this->request->data['Role']['search'] !='Search')){
		 $searchBy  = $this->request->data['Role']['search'];
		$search_condition = "Location.name='$searchBy'";
		}else{
		$search_condition = '1=1';
		}*/
		/*$this->Role->bindModel(array(
		 'belongsTo' => array(
		 		'User' =>array(
		 				'fields'=>'User.first_name,User.last_name',
		 				'foreignKey'=>'created_by',
		 				'conditions' => array('User.location_id' => $this->Session->read('locationid'))
		 		)
		 )));*/
		$data = $this->paginate('Role');
		$this->set('data', $data);
	}

	public function admin_add() {

		$this->uses = array( 'Role', 'StoreLocation','Location');
		$this->set('title_for_layout', __('Create Role', true));

		if($this->request->is('post') || $this->request->is('put')) {
			 $old_data = $this->Role->find('count',array('conditions'=>array('name'=> trim($this->request->data['Role']['name']), 'location_id' => $this->Session->read('locationid'), 'is_deleted' => 0)));
			
			 if($old_data){
			$this->Session->setFlash(__('This Role is already exist.'),'default',array('class'=>'error'));
			return false;
			//$this->redirect(array('action'=>'add'));
			} 

			$this->request->data["Role"]["name"] = trim($this->request->data["Role"]["name"]);
			$this->request->data["Role"]["accessable_role"] = serialize($this->request->data["Role"]["accessable_role"]);
			$this->request->data["Role"]["store_location_id"] = trim($this->request->data["Role"]["store_location_id"]);
			//$this->request->data["Role"]["location_id"] = $this->request->data["Role"]["location_id"];
			$this->request->data["Role"]["location_id"] = $this->Session->read('locationid');
			$this->request->data["Role"]["create_time"] = date("Y-m-d H:i:s");
			$this->request->data["Role"]["modify_time"] = date("Y-m-d H:i:s");
			$this->request->data["Role"]["created_by"] = $this->Session->read('userid');//temp set to 5 later on change this to current logged in user's id
			$this->request->data["Role"]["modified_by"] = $this->Session->read('userid');//temp set to 5 later on change this to current logged in user's id
			//$this->request->data["Role"]['accessable_role']=implode('|',$this->request->data["Role"]['accessable_role']);
			$this->Role->create(); //debug($this->request->data);exit;
			
			$this->Role->save($this->request->data); 

			$errors = $this->Role->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
				$this->Session->setFlash(__('The Role has been created'),'default',array('class'=>'message'));
				$this->redirect(array("controller" => "Roles", "action" => "index", "admin" => true));
			}
		}
		$StoreLocation = $this->StoreLocation->find('list',array('fields'=> array('id','name'),'order' => array('StoreLocation.name')));
		//$location = $this->Location->find('list', array('fields'=> array('id', 'name'),'order' => array('Location.name'),'conditions' => array('Location.is_deleted' => 0,'Location.is_active' => 1)));
		// Following condition for hope hospital because doctor role also accesible by other user like billing manager - Atul ,Date:16 Feb 2015
		if($this->Session->read('website.instance')=='hope'){
		$roles = $this->Role->find('list',array('fields'=> array('id','name'),'order' => array('Role.name'),
				'conditions'=>array('NOT'=>array('name'=>array(configure::read('patientLabel'),configure::read('superAdminLabel'),configure::read('adminLabel'))))));
		}else{
			$roles = $this->Role->find('list',array('fields'=> array('id','name'),'order' => array('Role.name'),
					'conditions'=>array('NOT'=>array('name'=>array(configure::read('patientLabel'),configure::read('superAdminLabel'),configure::read('adminLabel'),configure::read('doctorLabel'))))));		
		}
		
		//debug($name);exit;
		$this->set(compact('StoreLocation','roles'/*,'location'*/));
		//$this->request->data['store_location']['name']= $name;
		//$licenture= $this->LicensureType->find('list', array('fields'=> array('id', 'name'),'order' => array('LicensureType.name')));
		/*   $this->set('facilities', $this->Facility->find('list', array('fields'=> array('id', 'name'),'conditions'=>array('Facility.is_deleted' => 0 , 'Facility.is_active' => 1))));*/
	} //EOF of function add

	//funtion to delete role
	public function admin_delete($id = null) {
		$this->set('title_for_layout', __('Role - Delete Role', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Hospital'),'default',array('class'=>'error'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Role->delete($id)) {
			$this->Session->setFlash(__('Role deleted successfully'),'default',array('class'=>'message'));
			$this->redirect(array('action'=>'index'));
		}
	}

	//funtion to view role details
	public function admin_view($id = null) {
		$this->uses = array('StoreLocation');
		$this->set('title_for_layout', __('View Role Detail', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for role.', true));
			$this->redirect(array('action'=>'index'));
		}

		$this->Role->unbindModel(array('hasMany' => array('User')));

		$this->Role->bindModel(array(
				'belongsTo' => array(
						'User' =>array(
								'fields'=>'User.first_name,User.last_name',
								'foreignKey'=>'created_by',),
						'StoreLocation'=>array(
								'foreignKey'=>'store_location_id',
				 				'fields'=>array('StoreLocation.name')),
					   /* 'Location'=>array(
					    		'foreignKey'=>false,
					    		'conditions'=>array('Role.location_id = Location.id'),
					    		'fields'=>array('Location.name')),*/
							     
				)));

		$getData=$this->Role->find('first',array('conditions'=>array('Role.id'=>$id)));
		$this->set('role',$getData);
			
		//$this->set('userData',$data);
	}

	public function admin_edit($id = null) {
		$this->uses = array( 'Role', 'StoreLocation','Location');
		$this->set('title_for_layout', __('Edit Role Detail', true));
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Role'),'default',array('class'=>'errror'));
			$this->redirect(array('action'=>'index'));
		}

		if (!empty($this->data)) {
			$old_data = $this->Role->find('count',array('conditions'=>array('id != '=>$this->request->data['Role']['id'],'name'=> trim($this->request->data['Role']['name']), 'location_id' => $this->Session->read('locationid'), 'is_deleted' => 0)));

			if($old_data){
				$this->Session->setFlash(__('This Role is already exist.'),'default',array('class'=>'error'));
				$this->redirect(array('action'=>'edit',$this->request->data['Role']['id']));
			}
				
			$this->request->data["Role"]["name"] = trim($this->request->data["Role"]["name"]);
			$this->request->data["Role"]["store_location_id"] = trim($this->request->data["Role"]["store_location_id"]);
			$this->request->data["Role"]["accessable_role"] = serialize($this->request->data["Role"]["accessable_role"]);
			$this->request->data["Role"]["location_id"] = $this->Session->read('locationid');
		//	$this->request->data["Role"]["location_id"] = $this->request->data["Role"]["location_id"];
			$this->request->data["Role"]["modify_time"] = date("Y-m-d H:i:s");
			$this->request->data["Role"]["modified_by"] = $this->Session->read('userid');;//temp set to 5 later on change this to current logged in user's id

			if ($this->Role->save($this->data)) {
				$this->Session->setFlash(__('The Role has been update successfully'),'default',array('class'=>'message'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Role could not be saved. Please, try again.'),'default',array('class'=>'error'));
			}
		}
		$this->Role->unbindModel(array('hasMany' => array('User')));
		$roleData = $this->Role->read(null, $id);
		$roleData['Role']['accessable_role'] = unserialize($roleData['Role']['accessable_role']);
		$this->request->data = $roleData;
		$this->set('id', $id);
		$StoreLocation = $this->StoreLocation->find('list',array('fields'=> array('id','name'),'order' => array('StoreLocation.name')));
		//$location = $this->Location->find('list', array('fields'=> array('id', 'name'),'order' => array('Location.name'),'conditions' => array('Location.is_deleted' => 0,'Location.is_active' => 1)));
		if($this->Session->read('website.instance')=='hope'){
		$roles = $this->Role->find('list',array('fields'=> array('id','name'),'order' => array('Role.name'),
				'conditions'=>array('is_deleted'=>'0','location_id'=>$this->Session->read('locationid'),'NOT'=>array('name'=>array(configure::read('patientLabel'),configure::read('superAdminLabel'),configure::read('doctorLabel'),$roleData['Role']['name'])))));
		}else{
		$roles = $this->Role->find('list',array('fields'=> array('id','name'),'order' => array('Role.name'),
				'conditions'=>array(/*'location_id'=>$roleData['Role']['location_id'],*/'NOT'=>array('name'=>array(configure::read('patientLabel'),configure::read('superAdminLabel'),configure::read('adminLabel'),configure::read('doctorLabel'),$roleData['Role']['name'])))));
		}
		
		$this->set(compact('StoreLocation','roles','location'));
	}

	public function admin_search(){
		$this->loadModel("Location");
		$location_array = $this->Location->find('list', array('fields'=> array('id', 'name'),'conditions'=>array("Location.name like " => "$_GET[q]%")));
		foreach ($location_array as $key=>$value) {
			echo "$value|$key\n";
		}
		exit;
	}

	function superadmin_getRoles($location_id=null){
		$this->loadModel("Role");
		$location_array = array(''=>__('Please select'));
		$location_array1 = $this->Role->find('list', array('fields'=> array('id', 'name'),'conditions'=>array('location_id'=>$location_id, 'name <>' =>  'superadmin')));
		echo json_encode($location_array+$location_array1);
		exit;
	}

	/**
	 * check unique role name during creation of role name on client side.
	 *
	 */
	function admin_checkduprole(){
		$this->autoRender =false ;
		$rolename = $this->params->query['fieldValue'];
		if($rolename == ''){
			return;
		}
		$count = $this->Role->find('count',array('conditions'=>array('Role.name'=>trim($rolename))));
		if(!$count){
			return json_encode(array('rolename',true,'alertTextOk')) ;
		}else return json_encode(array('rolename',false,'alertText')) ;

		exit;
	}
	
/*	function admin_getChangableRoles($location=null){
		$this->layout  = 'ajax';
		$this->autoRender= false;		 
		$this->loadModel('Role');
		$accessLocList = $this->Role->find('list',array('fields'=> array('id','name'),'order' => array('Role.name ASC'),
				'conditions'=>array('NOT'=>array('name'=>array(configure::read('patientLabel'),configure::read('superAdminLabel'),configure::read('adminLabel'),configure::read('doctorLabel'))),'Role.location_id'=>$location)));
		echo json_encode($accessLocList);
		 
	}
	*/

}

?>