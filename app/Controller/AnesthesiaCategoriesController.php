<?php
/**
 * AnesthesiaCategoriesController file
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
class AnesthesiaCategoriesController extends AppController {

	public $name = 'AnesthesiaCategories';
	public $uses = array('AnesthesiaCategory');
	public $helpers = array('Html','Form', 'Js');
	public $components = array('RequestHandler','Email');

	/**
	 * anesthesia category listing
	 *
	 */

	public function index() {
		
	
		$this->paginate = array(
			        'limit' => Configure::read('number_of_rows'),
			        'order' => array(
			            'AnesthesiaCategory.name' => 'asc'
			            ),
			        'conditions' => array('AnesthesiaCategory.is_deleted' => 0, 'AnesthesiaCategory.location_id' => $this->Session->read("locationid"))
			            );	
			            $this->set('title_for_layout', __('Anesthesia Category', true));
			            $this->AnesthesiaCategory->recursive = 0;
			            $data = $this->paginate('AnesthesiaCategory');
			           
			            $this->set('data', $data);
	}

	/**
	 * Anesthesia category view
	 *
	 */
	public function view($id = null) {
		$this->set('title_for_layout', __('Anesthesia Category Detail', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid Anesthesia Category', true));
			$this->redirect(array("controller" => "anesthesia_categories", "action" => "index"));
		}
		$this->set('anesthesia_category', $this->AnesthesiaCategory->read(null, $id));
	}

	/**
	 * Surgery category add
	 *
	 */
	public function add() {
		$this->set('title_for_layout', __('Add New Anesthesia Category', true));
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data['AnesthesiaCategory']['location_id'] = $this->Session->read('locationid');
			$this->request->data['AnesthesiaCategory']['create_time'] = date('Y-m-d H:i:s');
			$this->request->data['AnesthesiaCategory']['created_by'] = $this->Auth->user('id');
			$this->AnesthesiaCategory->create(); //debug($this->request->data);exit;
			$this->AnesthesiaCategory->save($this->request->data);
			$errors = $this->AnesthesiaCategory->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
				$this->Session->setFlash(__('The Anesthesia Category has been saved', true));
				$this->redirect(array("controller" => "anesthesia_categories", "action" => "index"));
			}
		}
		

	}

	/**
	 * Surgery category edit
	 *
	 */
	public function edit($id = null) {
		$this->set('title_for_layout', __('Edit Anesthesia Category Detail', true));
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid Anesthesia Category', true));
			$this->redirect(array("controller" => "anesthesia_categories", "action" => "index"));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data['AnesthesiaCategory']['modify_time'] = date('Y-m-d H:i:s');
			$this->request->data['AnesthesiaCategory']['modified_by'] = $this->Auth->user('id');
			$this->AnesthesiaCategory->id = $this->request->data["AnesthesiaCategory"]['id'];
			$this->AnesthesiaCategory->save($this->request->data);
			$errors = $this->AnesthesiaCategory->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
				$this->Session->setFlash(__('The Anesthesia Category has been updated', true));
				$this->redirect(array("controller" => "anesthesia_categories", "action" => "index"));
			}
		} 
			$this->request->data = $this->AnesthesiaCategory->read(null, $id);

	 }

	/**
	 * Anesthesia category delete
	 *
	 */
	public function delete($id = null) {
		$this->set('title_for_layout', __('Delete Anesthesia Category', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Anesthesia category', true));
			$this->redirect(array("controller" => "Anesthesia_categories", "action" => "index"));
		}
		if ($id) {
			$this->AnesthesiaCategory->deleteAnesthesiaCategory($this->request->params);
			$this->Session->setFlash(__('Anesthesia Category deleted', true));
			$this->redirect(array("controller" => "anesthesia_categories", "action" => "index"));
		}
	}



}
?>