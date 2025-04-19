<?php
/**
 * Designations Controller
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Designations.Controller
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Mayank Jain
 */
class DesignationsController extends AppController {
	public $name = 'Designations';
	public $uses = array('Designation');
	public $helpers = array('Html','Form', 'Js');
	public $components = array('RequestHandler','Email');	
	

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->paginate = array(
			        'limit' => Configure::read('number_of_rows'),
			        'order' => array(
			            'Designation.name' => 'asc'
			        ),
                                'conditions' => array('Designation.is_deleted' => 0, 'Designation.location_id' => $this->Session->read('locationid'))
			    );
		$this->set('designations', $this->paginate('Designation'));
	}


/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Designation->create();
                        $this->request->data['Designation']['location_id'] = $this->Session->read('locationid');
                        $this->request->data['Designation']['create_time'] = date('Y-m-d H:i:s');
                        $this->request->data['Designation']['created_by'] = $this->Auth->user('id');
			if ($this->Designation->save($this->request->data)) {
				$this->Session->setFlash(__('The designation has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				if($this->Designation->validationErrors){
					$this->set('errors', $this->Designation->validationErrors);
				}else{
					$this->Session->setFlash(__('The designation could not be saved. Please, try again.'));
				}
			}
		}
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
                $this->Designation->id = $id;
		if ($this->request->is('post') || $this->request->is('put')) {
                        $this->request->data['Designation']['modify_time'] = date('Y-m-d H:i:s');
                        $this->request->data['Designation']['modified_by'] = $this->Auth->user('id');
                        $errors = $this->Designation->invalidFields();
			if ($this->Designation->save($this->request->data)) {
				$this->Session->setFlash(__('The designation has been updated.'));
				$this->redirect(array('action' => 'index'));
			} else {
			$this->set('errors', $this->Designation->validationErrors);

				$this->Session->setFlash(__('The designation could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Designation->read(null, $id);
		}
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Designation->id = $id;
		if (!$this->Designation->exists()) {
			throw new NotFoundException(__('Invalid designation'));
		}
		if ($this->Designation->save(array('is_deleted' => 1))) {
			$this->Session->setFlash(__('Designation deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Designation was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	

	//function to render body chart by pankaj
	function body_chart(){
		 $this->layout  = false   ; 
	}
	//EOF body chart
}
