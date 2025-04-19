<?php
/**
 * This is roles controller file.
 *
 * Use to create/edit/view/delete roles
 * created : 16 Nov
 */
class DepartmentsController extends AppController {

	public $name = 'Departments';
	public $uses = array('Department');
	public $helpers = array('Html','Form', 'Js'); 
	public $components = array('RequestHandler','Email');
	
	public function admin_index() {
				
                $this->set('title_for_layout', __('Manage Department', true));
	 			$this->Department->bindModel(array(
 												'belongsTo' => array( 											 
												'User' =>array(
															'fields'=>'User.first_name,User.last_name',
															'foreignKey'=>'created_by',),
	 											'Location'=>array('foreignKey'=>'location_id')
												)));		

	 			//BOF pankaj
	 			$conditions = array('Department.location_id' => $this->Session->read('locationid')); 
	 			if(!empty($this->request->data['name'])){
	 				$conditions = array_merge($conditions,array('Department.name like '=> "%".$this->request->data['name']."%")) ;
	 			}
	 			//EOF pankaj
    			$this->paginate = array(
			        'limit' => Configure::read('number_of_rows'),
			        'order' => array(
			            'Department.name' => 'asc'
			        ),
			        'conditions'=>array($conditions)       
			    );

    			
                $data = $this->paginate('Department');
                $this->set('data', $data);
	}
	
	public function admin_add() {
                
                
            $this->set('title_for_layout', __('Add Department', true));
            $this->uses = array('Location');    
			if (!empty($this->data)) {
						$old_data = $this->Department->find('count',array('conditions'=>array('name'=>$this->request->data['Department']['name'],'location_id' => $this->request->data['Department']['location_id'])));
						if($old_data){
						 
							$this->Session->setFlash(__('This Speciality is already exist.'),'default',array('class'=>'error'));
							return false;
							//$this->redirect(array('action'=>'add'));
						}
						//$this->request->data['Department']['inventory_type_id'] = implode(",",$this->request->data['Department']['inventory_type_id']);
                        $this->Department->insertDepartment($this->request->data,'insert');						
						$errors = $this->Department->invalidFields();
                        if(!empty($errors)) {
                           $this->set("errors", $errors);
                        } else {
                           		$this->Session->setFlash(__('Speciality has been added successfully'),'default',array('class'=>'message'));
  							 	$this->redirect(array("controller" => "Departments", "action" => "index", "admin" => true));
			            }
			}
            $this->set('locations',$this->Location->find('list',array('fields'=>array('name'),'conditions'=>array('Location.is_deleted'=> 0))));
               
	} //EOF of function add
	
	//funtion to delete role 
	public function admin_delete($id = null) {
			
		    $this->set('title_for_layout', __('- Delete Speciality', true));
			if (!$id) {
				$this->Session->setFlash(__('Invalid id for Speciality'),'default',array('class'=>'error'));
				$this->redirect(array('action'=>'index'));
			}
			if ($this->Department->delete($id)) {
				 
				$this->Session->setFlash(__('Speciality deleted successfully'),'default',array('class'=>'message'));
				$this->redirect(array('action'=>'index'));
			}
			$this->redirect(array('action'=>'index'));
	}
	
	 
	
	public function admin_edit($id = null) {
		        $this->uses = array('Location');
			$this->set('title_for_layout', __('Edit Department', true));
			if (!$id && empty($this->data)) {
				$this->Session->setFlash(__('Invalid Speciality'),'default',array('class'=>'error'));
				$this->redirect(array('action'=>'index'));
			}
			
			if ($this->request->is('post')) {
					 
					$old_data = $this->Department->find('count',array('conditions'=>array('name'=>$this->request->data['Department']['name'],'id <>' =>$this->request->data["Department"]['id'], 'location_id' => $this->Session->read('locationid'))));
                                        if($old_data){
					 
						$this->Session->setFlash(__('This Speciality is already exist.'),'default',array('class'=>'error'));
						$this->redirect(array('action'=>'edit',$this->request->data['Department']['id']));
						//$this->redirect(array('action'=>'add'));
					}                 
                    $this->Department->insertDepartment($this->request->data,'update');
					$errors = $this->Department->invalidFields();
                    if(!empty($errors)) {
                        $this->set("errors", $errors);
                    } else {
                        $this->Session->setFlash(__('Speciality has been update successfully'),'default',array('class'=>'message'));
  				 		$this->redirect(array("action" => "index", "admin" => true));
		            } 
			}
			if (empty($this->data)) {
				$dept_arr = $this->Department->read(null, $id);
				$dept_arr['Department']['inventory_type_id'] = explode(',', $dept_arr['Department']['inventory_type_id']);
				$dept_arr['Department']['inventory_type'] = explode(',', $dept_arr['Department']['inventory_type']);
				$this->data = $dept_arr;
				$this->set('locations',$this->Location->find('list',array('fields'=>array('name'),'conditions'=>array('Location.is_deleted'=> 0))));
				//echo"<pre>";print_r($this->data);exit;
			}
			$this->set('id', $id);
	}
	
	function dashboard($dept_id=null){
			if($dept_id){
				$this->set('department',$this->Department->read(null,$dept_id));
				$this->render('dashboard_options');
			}else{
				$this->set('title_for_layout', __('Dashboard', true));
		 		$this->Department->bindModel(array(
		 										'belongsTo' => array( 											 
												'User' =>array(
															'fields'=>'User.first_name,User.last_name',
															'foreignKey'=>'created_by',),
		 										'Location'=>array('foreignKey'=>'location_id')
												)));										
		    	$this->paginate = array(
			        'limit' => Configure::read('number_of_rows'),
			        'order' => array(
			            'Department.name' => 'Asc'
			        ),
			        'conditions'=>array('Department.location_id' => $this->Session->read('locationid'))       
			    );							
	            $data = $this->paginate('Department');
	            $this->set('data', $data);
			}
                
	}
		
		
	}//EOF class