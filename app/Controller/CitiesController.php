<?php
/**
 * This is roles controller file.
 *
 * Use to create/edit/view/delete roles
 * created : 16 Nov
 */
class CitiesController extends AppController {

	public $name = 'Cities';
	public $uses = array('City');
	public $helpers = array('Html','Form', 'Js');
	public $components = array('RequestHandler','Email'); 
	
	
	public function admin_index() {
		 $this->paginate = array(
	        'limit' => Configure::read('number_of_rows'),
	        'order' => array(
	            'City.name' => 'asc'
	        )
    	);
                $this->set('title_for_layout', __('Manage Cities', true));
	 			$this->City->bindModel(array(
 												'belongsTo' => array( 											 
												'User' =>array(
															'fields'=>'User.first_name,User.last_name',
															'foreignKey'=>'created_by'),
												'State' =>array(
															'fields'=>'State.name',
															'foreignKey'=>'state_id',			 
												)
 										)));
                $data = $this->paginate('City');
                $this->set('data', $data);
	}
	
	//funtion to view city details
	public function admin_view($id = null) {
	    $this->set('title_for_layout', __('View State Detail', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for state.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->City->bindModel(array(
 								'belongsTo' => array( 											 
								'User' =>array(
											'fields'=>'User.first_name,User.last_name',
											'foreignKey'=>'created_by'),
								'State' =>array(
											'fields'=>'State.name',
											'foreignKey'=>'state_id'),
								'Country' =>array(
											'fields'=>'Country.name',
											'foreignKey'=>false ,
											'conditions'=>'Country.id=State.country_id'				 
								)
 						)));
		$this->set('Cities', $this->City->read(null, $id));
	}
	
	//funtion to add city 
	public function admin_add() {
                
                
            $this->set('title_for_layout', __('Add City', true));
            $this->loadModel("State");    
             $this->loadModel("Country");  
            $this->set('states', '');     
            $this->set('countries', $this->Country->find('list', array('fields'=> array('id', 'name'), 'order' => array('Country.name'))));
			if (!empty($this->data)) {
						$this->request->data['City']['state_id'] = $this->request->data['User']['state_id']; 
						$old_data = $this->City->find('count',array('conditions'=>array('name'=>$this->request->data['City']['name'],' state_id ='=>$this->request->data['City']['state_id'] ) ));
						if($old_data){
						 	$this->set('states', $this->State->find('list', array('fields'=> array('id', 'name'),'conditions'=>array('country_id'=>$this->request->data['City']['country_id']))));
						 	 
							$this->Session->setFlash(__('This City is already exist for selected state.'),'default',array('class'=>'error'));
							return false ;
							
							//$this->redirect(array('action'=>'add'));
						}
                        $this->request->data["City"]["create_time"] = date("Y-m-d H:i:s");
                        $this->request->data["City"]["modify_time"] = date("Y-m-d H:i:s");
                        $this->request->data["City"]["created_by"] = $this->Session->read('userid');
                        $this->request->data["City"]["modified_by"] = $this->Session->read('userid'); 
                         
                        $this->City->create();
                        $this->City->save($this->request->data);
						
						$errors = $this->City->invalidFields();
                        if(!empty($errors)) {
                           $this->set("errors", $errors);
                        } else {
                           		$this->Session->setFlash(__('City has been added successfully'),'default',array('class'=>'message'));
  							 	$this->redirect(array("action" => "index", "admin" => true));
			            }
			}
           
               
	} //EOF of function add
	 
	//funtion to delete role 
	public function admin_delete($id = null) {
		    $this->set('title_for_layout', __('- Delete City', true));
			if (!$id) {
				$this->Session->setFlash(__('Invalid id for City'),'default',array('class'=>'error'));
				$this->redirect(array('action'=>'index'));
			}
			if ($this->City->delete($id)) {
				$this->Session->setFlash(__('City successfully deleted'),'default',array('class'=>'message'));
				$this->redirect(array('action'=>'index'));
			}
	}
	
	 
	
	public function admin_edit($id = null) {
		 	$this->loadModel("State");
		 	$this->loadModel("Country");        
			$this->set('title_for_layout', __('Edit City', true));
			$states_array  = $this->State->find('list', array('fields'=> array('id', 'name'), 'order' => array('State.name')));
			$countries_array  = $this->Country->find('list', array('fields'=> array('id', 'name'), 'order' => array('Country.name')));
			
			$this->set('states', $states_array);  			 
			$this->set('countries', $countries_array);
			if (!$id && empty($this->data)) {
				$this->Session->setFlash(__('Invalid City'),'default',array('class'=>'error'));
				$this->redirect(array('action'=>'index'));
			}
			 
			if (!empty($this->data)) {
					$current_data = $this->City->read(null, $this->request->data['City']['id']);
					//changing user array to city array
					if(!empty($this->request->data['User']['state_id']))
					$this->request->data['City']['state_id'] = $this->request->data['User']['state_id']; 
					 
					if($current_data['City']['name']==$this->request->data['City']['name'] && ($current_data['City']['state_id']==$this->request->data['City']['state_id'])){
						
					} else{
						$old_data = $this->City->find('count',array('conditions'=>array('name'=>$this->request->data['City']['name'],'state_id ' =>$this->request->data["City"]['state_id']) ));
						if($old_data){
						 	$this->set('states', $this->State->find('list', array('fields'=> array('id', 'name'),'conditions'=>array('country_id'=>$this->request->data['City']['country_id']))));
							$this->Session->setFlash(__('This City is already exist for selected state.'),'default',array('class'=>'error'));
							$this->redirect(array('action'=>'edit',$this->request->data['City']['id']));
							//$this->redirect(array('action'=>'add'));
						}
					}
		  
                    $this->request->data["City"]["modify_time"] = date("Y-m-d H:i:s");
                    $this->request->data["City"]["created_by"] = $this->Session->read('userid');
                    		              
					if ($this->City->save($this->data)) {
						$this->Session->setFlash(__('City has been updated successfully'),'default',array('class'=>'message'));
						$this->redirect(array('action'=>'index'));
					} else {
						$this->Session->setFlash(__('City could not be saved. Please, try again.'),'default',array('class'=>'error'));
					}
			}
			if (empty($this->data)) {
					$this->City->bindModel(array('belongsTo' => array( 											 
							
								'State' =>array(
											'fields'=>'State.name',
											'foreignKey'=>'state_id'),
								'Country' =>array(
											'fields'=>'Country.id',
											'foreignKey'=>false ,
											'conditions'=>'Country.id=State.country_id'				 
								)
 						)));  
				$this->data = $this->City->read(null, $id);
				 	 
			}
			
			$this->set('id', $id);
	}
		
	//function to return country wise state only for ajac call
	function admin_getStates($country_id=null){		 
		$this->loadModel("State");
		$state_array = array(''=>__('Please select'));    
		$state_array1 = $this->State->find('list', array('fields'=> array('id', 'name'),'conditions'=>array('country_id'=>$country_id)));
		echo json_encode($state_array+$state_array1);
		exit;
	}
	//function to return country wise state only for ajac call
	function getCities($stateName=null){		 
		$this->loadModel("City");	  
		$this->City->bindModel(array('belongsTo' => array( 							
								'State' =>array('foreignKey'=>false,'conditions'=>array('State.id=City.state_id'),
											),										 
								)
 						)); 
		$cityData = $this->City->find('all', array('fields'=> array('City.id', 'City.name'),'conditions'=>array('State.name'=>$stateName),'order'=>array('City.name'=>'ASC')));
		foreach ($cityData  as $key => $value) {
			$cityArr[$value['City']['id']]=$value['City']['name'];
		}
		echo json_encode($cityArr);
		exit;
	}
		
	}//EOF class