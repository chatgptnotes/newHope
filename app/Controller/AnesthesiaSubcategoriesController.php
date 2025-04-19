<?php
/**
 * AnesthesiaSubcategoriesController file
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
class AnesthesiaSubcategoriesController extends AppController {

	public $name = 'AnesthesiaSubcategories';
	public $uses = array('AnesthesiaSubcategory');
	public $helpers = array('Html','Form', 'Js');
	public $components = array('RequestHandler','Email');
	
/**
 * Anesthesia subcategore listing
 *
 */	
	
	public function index() {
                		$this->paginate = array(
			        'limit' => Configure::read('number_of_rows'),
			        'order' => array(
			            'AnesthesiaSubcategory.name' => 'asc'
			        ),
			        'conditions' => array('AnesthesiaCategory.is_deleted' => 0, 'AnesthesiaSubcategory.is_deleted' => 0, 'AnesthesiaCategory.location_id' => $this->Session->read("locationid"))
   				);
                $this->set('title_for_layout', __('Anesthesia Subcategory', true));
                $this->AnesthesiaSubcategory->recursive = 0;
                $data = $this->paginate('AnesthesiaSubcategory');
                $this->set('data', $data);
	}

/**
 * Anesthesia subcategory view
 *
 */
	public function view($id = null) {
                $this->set('title_for_layout', __('Anesthesia Subcategory Detail', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid Anesthesia subcategory', true));
			$this->redirect(array("controller" => "AnesthesiaSubcategories", "action" => "index"));
		}
                $this->set('anesthesia_subcategory', $this->AnesthesiaSubcategory->read(null, $id));
        }

/**
 * Anesthesia Subcategory add
 *
 */
	public function add() {
                $this->loadModel("AnesthesiaCategory");
                $this->set('title_for_layout', __('Add New Anesthesia Subcategory', true));
                if ($this->request->is('post')) {
                        $this->request->data['AnesthesiaSubcategory']['create_time'] = date('Y-m-d H:i:s');
                        $this->request->data['AnesthesiaSubcategory']['created_by'] = $this->Auth->user('id');
                        $this->AnesthesiaSubcategory->create();
                        $this->AnesthesiaSubcategory->save($this->request->data);
                        $errors = $this->AnesthesiaSubcategory->invalidFields();
			if(!empty($errors)) {
                           $this->set("errors", $errors);
                        } else {
                           $this->Session->setFlash(__('The Anesthesia subcategory has been saved', true));
			               $this->redirect(array("controller" => "AnesthesiaSubcategories", "action" => "index"));
                        }
		} 
               $this->set('anesthesia', $this->AnesthesiaCategory->find('list', array('fields'=> array('id', 'name'),'conditions' => array('AnesthesiaCategory.is_deleted' => 0, 'AnesthesiaCategory.location_id' => $this->Session->read('locationid')))));
                
	}

/**
 * Anesthesia Subcategory edit
 *
 */
	public function edit($id = null) {
                $this->uses = array('AnesthesiaCategory');
                $this->set('title_for_layout', __('Edit Anesthesia Subcategory Detail', true));
                if (!$id && empty($this->request->data)) {
			            $this->Session->setFlash(__('Invalid Anesthesia Subcategory', true));
                        $this->redirect(array("controller" => "AnesthesiaSubcategories", "action" => "index"));
		        }
                if ($this->request->is('post') && !empty($this->request->data)) {
                        $this->request->data['AnesthesiaSubcategory']['modify_time'] = date('Y-m-d H:i:s');
                        $this->request->data['AnesthesiaSubcategory']['modified_by'] = $this->Auth->user('id');
                        $this->AnesthesiaSubcategory->id = $this->request->data["AnesthesiaSubcategory"]['id'];
                        $this->AnesthesiaSubcategory->save($this->request->data);
			            $errors = $this->AnesthesiaSubcategory->invalidFields();
                        if(!empty($errors)) {
                           $this->set("errors", $errors);
                        } else {
                           $this->Session->setFlash(__('The Anesthesia Subcategory has been updated', true));
			   $this->redirect(array("controller" => "AnesthesiaSubcategories", "action" => "index"));
                        }
		} else {
                        $this->request->data = $this->AnesthesiaSubcategory->read(null, $id);
                        
                }
		 $this->set('anesthesia', $this->AnesthesiaCategory->find('list', array('fields'=> array('id', 'name'),'conditions' => array('AnesthesiaCategory.is_deleted' => 0, 'AnesthesiaCategory.location_id' => $this->Session->read('locationid')))));
                
	}

/**
 * Anesthesia Subcategory delete
 *
 */
	public function delete($id = null) {
                $this->set('title_for_layout', __('Delete Anesthesia Subcategory', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Anesthesia Subcategory', true));
			$this->redirect(array("controller" => "AnesthesiaSubcategories", "action" => "index"));
		}
		if ($id) {
                        $this->AnesthesiaSubcategory->deleteAnesthesiaSubcategory($this->request->params);
                        $this->Session->setFlash(__('Anesthesia subcategory deleted', true));
			$this->redirect(array("controller" => "AnesthesiaSubcategories", "action" => "index"));
		}
	}
        

        
}
?>