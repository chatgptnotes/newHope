<?php
/**
 * SurgeryCategoriesController file
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
class SurgeryCategoriesController extends AppController {

	public $name = 'SurgeryCategories';
	public $uses = array('SurgeryCategory');
	public $helpers = array('Html','Form', 'Js');
	public $components = array('RequestHandler','Email');

	/**
	 * surgery category listing
	 *
	 */

	public function index() {
		$this->paginate = array(
			        'limit' => Configure::read('number_of_rows'),
			        'order' => array(
			            'SurgeryCategory.name' => 'asc'
			            ),
			        'conditions' => array('SurgeryCategory.is_deleted' => 0, 'SurgeryCategory.location_id' => $this->Session->read("locationid"))
			            );
			            $this->set('title_for_layout', __('Surgery Category', true));
			            $this->SurgeryCategory->recursive = 0;
			            $data = $this->paginate('SurgeryCategory');
			            $this->set('data', $data);
	}

	/**
	 * Surgery category view
	 *
	 */
	public function view($id = null) {
		$this->set('title_for_layout', __('Surgery Category Detail', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid Surgery Category', true));
			$this->redirect(array("controller" => "surgery_categories", "action" => "index"));
		}
		$this->set('surgery_category', $this->SurgeryCategory->read(null, $id));
	}

	/**
	 * Surgery category add
	 *
	 */
	public function add() {
		$this->set('title_for_layout', __('Add New Surgery Category', true));
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data['SurgeryCategory']['location_id'] = $this->Session->read('locationid');
			$this->request->data['SurgeryCategory']['create_time'] = date('Y-m-d H:i:s');
			$this->request->data['SurgeryCategory']['created_by'] = $this->Auth->user('id');
			$this->SurgeryCategory->create();
			$this->SurgeryCategory->save($this->request->data);
			$errors = $this->SurgeryCategory->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
				$this->Session->setFlash(__('The Surgery Category has been saved', true));
				$this->redirect(array("controller" => "surgery_categories", "action" => "index"));
			}
		}
		

	}

	/**
	 * Surgery category edit
	 *
	 */
	public function edit($id = null) {
		$this->set('title_for_layout', __('Edit Surgery Category Detail', true));
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid Surgery Category', true));
			$this->redirect(array("controller" => "surgery_categories", "action" => "index"));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data['SurgeryCategory']['modify_time'] = date('Y-m-d H:i:s');
			$this->request->data['SurgeryCategory']['modified_by'] = $this->Auth->user('id');
			$this->SurgeryCategory->id = $this->request->data["SurgeryCategory"]['id'];
			$this->SurgeryCategory->save($this->request->data);
			$errors = $this->SurgeryCategory->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
				$this->Session->setFlash(__('The Surgery Category has been updated', true));
				$this->redirect(array("controller" => "surgery_categories", "action" => "index"));
			}
		} 
			$this->request->data = $this->SurgeryCategory->read(null, $id);

	 }

	/**
	 * Surgery category delete
	 *
	 */
	public function delete($id = null) {
		$this->set('title_for_layout', __('Delete Surgery Category', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for surgery category', true));
			$this->redirect(array("controller" => "surgery_categories", "action" => "index"));
		}
		if ($id) {
			$this->SurgeryCategory->deleteSurgeryCategory($this->request->params);
			$this->Session->setFlash(__('Surgery Category deleted', true));
			$this->redirect(array("controller" => "surgery_categories", "action" => "index"));
		}
	}



}
?>