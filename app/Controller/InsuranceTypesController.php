<?php
/**
 * InsuranceTypesController file
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
class InsuranceTypesController extends AppController {

	public $name = 'InsuranceTypes';
	public $uses = array('InsuranceType');
	public $helpers = array('Html','Form', 'Js');
	public $components = array('RequestHandler','Email');
	
/**
 * Insurance type listing
 *
 */	
	
	public function index() {
				$this->paginate = array(
			        'limit' => Configure::read('number_of_rows'),
			        'order' => array(
			            'InsuranceType.name' => 'asc'
			        ),
			        'conditions' => array('InsuranceType.is_deleted' => 0)
   				);
                $this->set('title_for_layout', __('Insurance Types', true));
                $this->InsuranceType->recursive = 0;
                $data = $this->paginate('InsuranceType');
                $this->set('data', $data);
	}

/**
 * insurance type view
 *
 */
	public function view($id = null) {
                $this->set('title_for_layout', __('Insurance Type Detail', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid Insurance Type', true));
			$this->redirect(array("controller" => "insurance_types", "action" => "index"));
		}
                $this->set('insurancetype', $this->InsuranceType->read(null, $id));
        }

/**
 * insurance type add
 *
 */
	public function add() {
                $this->set('title_for_layout', __('Add New Insurance Type', true));
                if ($this->request->is('post')) {
                        $this->request->data['InsuranceType']['create_time'] = date('Y-m-d H:i:s');
                        $this->request->data['InsuranceType']['created_by'] = $this->Auth->user('id');
                        $this->InsuranceType->create();
                        $this->InsuranceType->save($this->request->data);
                        $errors = $this->InsuranceType->invalidFields();
			if(!empty($errors)) {
                           $this->set("errors", $errors);
                        } else {
                           $this->Session->setFlash(__('The insurance type has been saved', true));
			   $this->redirect(array("controller" => "insurance_types", "action" => "index"));
                        }
		} 
                
	}

/**
 * insurance type edit
 *
 */
	public function edit($id = null) {
                $this->set('title_for_layout', __('Edit Insurance Type Detail', true));
                if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid Insurance Type', true));
                        $this->redirect(array("controller" => "insurance_types", "action" => "index"));
		}
                if ($this->request->is('post') && !empty($this->request->data)) {
                        $this->request->data['InsuranceType']['modify_time'] = date('Y-m-d H:i:s');
                        $this->request->data['InsuranceType']['modified_by'] = $this->Auth->user('id');
                        $this->InsuranceType->id = $this->request->data["InsuranceType"]['id'];
                        $this->InsuranceType->save($this->request->data);
			$errors = $this->InsuranceType->invalidFields();
                        if(!empty($errors)) {
                           $this->set("errors", $errors);
                        } else {
                           $this->Session->setFlash(__('The insurance type has been updated', true));
			   $this->redirect(array("controller" => "insurance_types", "action" => "index"));
                        }
		} else {
                        $this->request->data = $this->InsuranceType->read(null, $id);
                }
		
	}

/**
 * insurance type delete
 *
 */
	public function delete($id = null) {
                $this->set('title_for_layout', __('Delete Insurance Type', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for insurance type', true));
			$this->redirect(array("controller" => "insurance_types", "action" => "index"));
		}
		if ($id) {
                        $this->InsuranceType->deleteInsuranceType($this->request->params);
                        $this->Session->setFlash(__('Insurance type deleted', true));
			$this->redirect(array("controller" => "insurance_types", "action" => "index"));
		}
	}
        

        
}
?>