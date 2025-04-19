<?php
/**
 * This is roles controller file.
 *
 * Use to create/edit/view/delete roles
 * created : 16 Nov
 */
class CountriesController extends AppController {

	public $name = 'Countries';
	public $uses = array('Country');
	public $helpers = array('Html','Form', 'Js'); 
	public $components = array('RequestHandler','Email');
	
	public function admin_index() {
				$this->paginate = array(
			        'limit' => Configure::read('number_of_rows'),
			        'order' => array(
			            'Country.name' => 'asc'
			        )
			    );
                $this->set('title_for_layout', __('Manage Country', true));
	 			
                $data = $this->paginate('Country');
                $this->set('data', $data);
	}
	
	 
	
	public function admin_add() {
                
                
            $this->set('title_for_layout', __('Add Country', true));
                
			if (!empty($this->data)) {
						$old_data = $this->Country->find('count',array('conditions'=>array('name'=>$this->request->data['Country']['name'] ) ));
						if($old_data){
						 
							$this->Session->setFlash(__('This Country is already exist.'),'default',array('class'=>'error'));
							return false;
							//$this->redirect(array('action'=>'add'));
						}
                        $this->request->data["Country"]["create_time"] = date("Y-m-d H:i:s");
                        $this->request->data["Country"]["modify_time"] = date("Y-m-d H:i:s");
                        $this->request->data["Country"]["created_by"] = $this->Session->read('userid');
                        $this->request->data["Country"]["modified_by"] = $this->Session->read('userid'); 
                         
                        $this->Country->create();
                        $this->Country->save($this->request->data);
						
						$errors = $this->Country->invalidFields();
                        if(!empty($errors)) {
                           $this->set("errors", $errors);
                        } else {
                           		$this->Session->setFlash(__('Country has been added successfully'),'default',array('class'=>'message'));
  							 	$this->redirect(array("controller" => "countries", "action" => "index", "admin" => true));
			            }
			}
            
               
	} //EOF of function add
	
	//funtion to delete role 
	public function admin_delete($id = null) {
		    $this->set('title_for_layout', __('- Delete Country', true));
			if (!$id) {
				$this->Session->setFlash(__('Invalid id for Country'),'default',array('class'=>'error'));
				$this->redirect(array('action'=>'index'));
			}
			if ($this->Country->delete($id)) {
				$this->Session->setFlash(__('Country deleted successfully'),'default',array('class'=>'message'));
				$this->redirect(array('action'=>'index'));
			}
	}
	
	 
	
	public function admin_edit($id = null) {
		 
			$this->set('title_for_layout', __('Edit country', true));
			if (!$id && empty($this->data)) {
				$this->Session->setFlash(__('Invalid Country'),'default',array('class'=>'error'));
				$this->redirect(array('action'=>'index'));
			}
			 
			if (!empty($this->data)) {
					 
					$old_data = $this->Country->find('count',array('conditions'=>array('name'=>$this->request->data['Country']['name'],'id !=' =>$this->request->data["Country"]['id']) ));
					if($old_data){
					 
						$this->Session->setFlash(__('This Country is already exist.'),'default',array('class'=>'error'));
						$this->redirect(array('action'=>'edit',$this->request->data['Country']['id']));
						//$this->redirect(array('action'=>'add'));
					}
		  
                    $this->request->data["Country"]["modify_time"] = date("Y-m-d H:i:s");
                    $this->request->data["Country"]["created_by"] = $this->Session->read('userid');
                    		              
					if ($this->Country->save($this->data)) {
						$this->Session->setFlash(__('Country has been update successfully'),'default',array('class'=>'message'));
						$this->redirect(array('action'=>'index'));
					} else {
						$this->Session->setFlash(__('Country could not be saved. Please, try again.'),'default',array('class'=>'error'));
					}
			}
			if (empty($this->data)) {
				$this->data = $this->Country->read(null, $id);			 
			}
			$this->set('id', $id);
	}
		
        public function admin_geographicmap() {

        }
		
}//EOF class