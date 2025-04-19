<?php
/**
 * CreditTypesController file
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
class CreditTypesController extends AppController {

	public $name = 'CreditTypes';
	public $uses = array('CreditType');
	public $helpers = array('Html','Form', 'Js');
	public $components = array('RequestHandler','Email');
	
/**
 * credit type listing
 *
 */	
	
	public function index() {
				$this->paginate = array(
			        'limit' => Configure::read('number_of_rows'),
			        'order' => array(
			            'CreditType.name' => 'asc'
			        ),
			        'conditions' => array('CreditType.is_deleted' => 0)
   				);
                $this->set('title_for_layout', __('Credit Type', true));
                $this->CreditType->recursive = 0;
                $data = $this->paginate('CreditType');
                $this->set('data', $data);
	}

/**
 * credit type view
 *
 */
	public function view($id = null) {
                $this->set('title_for_layout', __('Credit Type Detail', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid Credit Type', true));
			$this->redirect(array("controller" => "credit_types", "action" => "index"));
		}
                $this->set('credittype', $this->CreditType->read(null, $id));
        }

/**
 * credit type add
 *
 */
	public function add() {
                $this->set('title_for_layout', __('Add New Credit Type', true));
                if ($this->request->is('post')) {
                        $this->request->data['CreditType']['create_time'] = date('Y-m-d H:i:s');
                        $this->request->data['CreditType']['created_by'] = $this->Auth->user('id');
                        $this->CreditType->create();
                        $this->CreditType->save($this->request->data);
                        $errors = $this->CreditType->invalidFields();
			if(!empty($errors)) {
                           $this->set("errors", $errors);
                        } else {
                           $this->Session->setFlash(__('The credit type has been saved', true));
			   $this->redirect(array("controller" => "credit_types", "action" => "index"));
                        }
		} 
                
                
	}

/**
 * credit type edit
 *
 */
	public function edit($id = null) {
                $this->set('title_for_layout', __('Edit Credit Type Detail', true));
                if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid Credit Type', true));
                        $this->redirect(array("controller" => "credit_types", "action" => "index"));
		}
                if ($this->request->is('post') && !empty($this->request->data)) {
                        $this->request->data['CreditType']['modify_time'] = date('Y-m-d H:i:s');
                        $this->request->data['CreditType']['modified_by'] = $this->Auth->user('id');
                        $this->CreditType->id = $this->request->data["CreditType"]['id'];
                        $this->CreditType->save($this->request->data);
			$errors = $this->CreditType->invalidFields();
                        if(!empty($errors)) {
                           $this->set("errors", $errors);
                        } else {
                           $this->Session->setFlash(__('The credit type has been updated', true));
			   $this->redirect(array("controller" => "credit_types", "action" => "index"));
                        }
		} else {
                        $this->request->data = $this->CreditType->read(null, $id);
                }
		
	}

/**
 * credit type delete
 *
 */
	public function delete($id = null) {
                $this->set('title_for_layout', __('Delete Credit Type', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Credit Type', true));
			$this->redirect(array("controller" => "credit_types", "action" => "index"));
		}
		if ($id) {
                        $this->CreditType->deleteCreditType($this->request->params);
                        $this->Session->setFlash(__('Credit Type deleted', true));
			$this->redirect(array("controller" => "credit_types", "action" => "index"));
		}
	}
        

        
}
?>