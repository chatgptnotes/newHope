<?php
/**
 * This is roles controller file.
 *
 * Use to create/edit/view/delete State
 * created : 16 Nov
 */
class StatesController extends AppController {

	public $name = 'States';
	public $uses = array('State');
	public $helpers = array('Html','Form', 'Js'); 
	public $components = array('RequestHandler','Email');
		
	public function admin_index() {
				$this->paginate = array(
			        'limit' => Configure::read('number_of_rows'),
			        'order' => array(
			            'State.name' => 'asc'
			        )
		    	);
                $this->set('title_for_layout', __('Manage State', true));
	 			$this->State->bindModel(array(
 												'belongsTo' => array( 											 
												'User' =>array(
															'fields'=>'User.first_name,User.last_name',
															'foreignKey'=>'created_by'),
												'Country' =>array(
															'fields'=>'Country.name',
															'foreignKey'=>'country_id',			 
												)
 										)));
                $data = $this->paginate('State');
                $this->set('data', $data);
	}
	
	//funtion to view state details
	public function admin_view($id = null) {
	    $this->set('title_for_layout', __('View State Detail', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for state.'),'default',array('class'=>'error'));
			$this->redirect(array('action'=>'index'));
		}
		$this->State->bindModel(array(
 								'belongsTo' => array( 											 
								'User' =>array(
											'fields'=>'User.first_name,User.last_name',
											'foreignKey'=>'created_by'),
								'Country' =>array(
											'fields'=>'Country.name',
											'foreignKey'=>'country_id',			 
								)
 						)));
		$this->set('States', $this->State->read(null, $id));
	}
	
	public function admin_add() {
                
                
            $this->set('title_for_layout', __('-Add State', true));
            $this->loadModel("Country");    
			if (!empty($this->data)) {
						$old_data = $this->State->find('count',array('conditions'=>array('name'=>$this->request->data['State']['name'],'country_id '=>$this->request->data['State']['country_id'] ) ));
					 
						if($old_data){
						 	$this->set('countries', $this->Country->find('list', array('fields'=> array('id', 'name'))));
							$this->Session->setFlash(__('This State is already exist for selected country.'),'default',array('class'=>"error"));
							return false;
							//$this->redirect(array('action'=>'add'));
						}
                        $this->State->insertState($this->request->data,'insert');
						
						$errors = $this->State->invalidFields();
                        if(!empty($errors)) {
                           $this->set("errors", $errors);
                        } else {
                           		$this->Session->setFlash(__('State has been added successfully'),'default',array('class'=>"message"));
  							 	$this->redirect(array("action" => "index", "admin" => true));
			            }
			}
			$this->set('countries', $this->Country->find('list', array('fields'=> array('id', 'name'), 'order' => array('Country.name'))));
            
               
	} //EOF of function add
	
	//funtion to delete role 
	public function admin_delete($id = null) {
		    $this->set('title_for_layout', __('- Delete State', true));
			if (!$id) {
				$this->Session->setFlash(__('Invalid id for State'), true,array('class'=>"error"));
				$this->redirect(array('action'=>'index'));
			}
			if ($this->State->delete($id)) {
				$this->Session->setFlash(__('State deleted successfully'), true,array('class'=>"error"));
				$this->redirect(array('action'=>'index'));
			}
	}
	
	 
	
	public function admin_edit($id = null) {
		 
			$this->set('title_for_layout', __('Edit State'));
			     $this->loadModel("Country");    
			if (!$id && empty($this->data)) {
				$this->Session->setFlash(__('Invalid State'),'default',array('class'=>"error"));
				$this->redirect(array('action'=>'index'));
			}
			 
			if (!empty($this->data)) {
					 
					$old_data = $this->State->find('count',array('conditions'=>array('name'=>$this->request->data['State']['name'],'id !='=>$this->request->data['State']['id'] ) ));
				 
					if($old_data){
					 	$this->set('countries', $this->Country->find('list', array('fields'=> array('id', 'name'))));
						$this->Session->setFlash(__('This State is already exist for selected country.'),'default',array('class'=>"error"));
						$this->redirect(array('action'=>'edit',$this->request->data['State']['id']));
						//$this->redirect(array('action'=>'add'));
					}
		  
                    $this->State->insertState($this->request->data,'update');	  
		 			if(!empty($errors)) {
                           $this->set("errors", $errors);
                        } else {
                           	$this->Session->setFlash(__('State has been update successfully'),'default',array('class'=>"message"));
  						 	$this->redirect(array("action" => "index", "admin" => true));
		            }			                        
					 
			}
			if (empty($this->data)) {
				$this->data = $this->State->read(null, $id);		
				$this->set('countries', $this->Country->find('list', array('fields'=> array('id', 'name'), 'order' => array('Country.name'))));	 
			}
			$this->set('id', $id);
	}
		
		
	}//EOF class