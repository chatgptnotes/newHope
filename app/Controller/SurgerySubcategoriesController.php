<?php
/**
 * SurgerySubcategoriesController file
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
class SurgerySubcategoriesController extends AppController {

	public $name = 'SurgerySubcategories';
	public $uses = array('SurgerySubcategory');
	public $helpers = array('Html','Form', 'Js');
	public $components = array('RequestHandler','Email');
	
/**
 * surgery subcategore listing
 *
 */	
	
	public function index() {
                		$this->paginate = array(
			        'limit' => Configure::read('number_of_rows'),
			        'order' => array(
			            'SurgerySubcategory.name' => 'asc'
			        ),
			        'conditions' => array('SurgeryCategory.is_deleted' => 0, 'SurgerySubcategory.is_deleted' => 0, 'SurgeryCategory.location_id' => $this->Session->read("locationid"))
   				);
                $this->set('title_for_layout', __('Surgery Subcategory', true));
                $this->SurgerySubcategory->recursive = 0;
                $data = $this->paginate('SurgerySubcategory');
                $this->set('data', $data);
	}

/**
 * Surgery subcategory view
 *
 */
	public function view($id = null) {
                $this->set('title_for_layout', __('Surgery Subcategory Detail', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid surgery subcategory', true));
			$this->redirect(array("controller" => "surgery_subcategories", "action" => "index"));
		}
                $this->set('surgery_subcategory', $this->SurgerySubcategory->read(null, $id));
        }

/**
 * Surgery Subcategory add
 *
 */
	public function add() {
                $this->loadModel("SurgeryCategory");
                $this->set('title_for_layout', __('Add New Surgery Subcategory', true));
                if ($this->request->is('post')) {
                        $this->request->data['SurgerySubcategory']['create_time'] = date('Y-m-d H:i:s');
                        $this->request->data['SurgerySubcategory']['created_by'] = $this->Auth->user('id');
                        $this->SurgerySubcategory->create();
                        $this->SurgerySubcategory->save($this->request->data);
                        $errors = $this->SurgerySubcategory->invalidFields();
			if(!empty($errors)) {
                           $this->set("errors", $errors);
                        } else {
                           $this->Session->setFlash(__('The surgery subcategory has been saved', true));
			               $this->redirect(array("controller" => "surgery_subcategories", "action" => "index"));
                        }
		} 
               $this->set('surgery', $this->SurgeryCategory->find('list', array('fields'=> array('id', 'name'),'conditions' => array('SurgeryCategory.is_deleted' => 0, 'SurgeryCategory.location_id' => $this->Session->read('locationid')))));
                
	}

/**
 * Surgery Subcategory edit
 *
 */
	public function edit($id = null) {
                $this->uses = array('SurgeryCategory');
                $this->set('title_for_layout', __('Edit Surgery Subcategory Detail', true));
                if (!$id && empty($this->request->data)) {
			            $this->Session->setFlash(__('Invalid Surgery Subcategory', true));
                        $this->redirect(array("controller" => "surgery_subcategories", "action" => "index"));
		        }
                if ($this->request->is('post') && !empty($this->request->data)) {
                        $this->request->data['SurgerySubcategory']['modify_time'] = date('Y-m-d H:i:s');
                        $this->request->data['SurgerySubcategory']['modified_by'] = $this->Auth->user('id');
                        $this->SurgerySubcategory->id = $this->request->data["SurgerySubcategory"]['id'];
                        $this->SurgerySubcategory->save($this->request->data);
			            $errors = $this->SurgerySubcategory->invalidFields();
                        if(!empty($errors)) {
                           $this->set("errors", $errors);
                        } else {
                           $this->Session->setFlash(__('The Surgery Subcategory has been updated', true));
			   $this->redirect(array("controller" => "surgery_subcategories", "action" => "index"));
                        }
		} else {
                        $this->request->data = $this->SurgerySubcategory->read(null, $id);
                        
                }
		 $this->set('surgery', $this->SurgeryCategory->find('list', array('fields'=> array('id', 'name'),'conditions' => array('SurgeryCategory.is_deleted' => 0, 'SurgeryCategory.location_id' => $this->Session->read('locationid')))));
                
	}

/**
 * Surgery Subcategory delete
 *
 */
	public function delete($id = null) {
                $this->set('title_for_layout', __('Delete Surgery Subcategory', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Surgery Subcategory', true));
			$this->redirect(array("controller" => "surgery_subcategories", "action" => "index"));
		}
		if ($id) {
                        $this->SurgerySubcategory->deleteSurgerySubcategory($this->request->params);
                        $this->Session->setFlash(__('Surgery subcategory deleted', true));
			$this->redirect(array("controller" => "surgery_subcategories", "action" => "index"));
		}
	}
        

        
}
?>