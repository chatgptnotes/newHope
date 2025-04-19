<?php
/**
 * InsuranceCompanies Controller
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       InsuranceCompanies Controller
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Mayank Jain
 */
class InsuranceCompaniesController extends AppController {

public $name = 'InsuranceCompanies';
		public $uses = array('InsuranceCompany');
		public $helpers = array('Html','Form', 'Js');
		public $components = array('RequestHandler','Email');	
		public $paginate = array(
			'limit' => 25,
			'order' => array('InsuranceCompany.name' => 'asc')
			 
		);

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		 
		$this->InsuranceCompany->recursive = 0;
		$this->set('insuranceCompanies', $this->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->InsuranceCompany->id = $id;
		if (!$this->InsuranceCompany->exists()) {
			throw new NotFoundException(__('Invalid insurance company'));
		}
		$this->set('insuranceCompany', $this->InsuranceCompany->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
        $this->uses = array('City', 'Country', 'State');
		if ($this->request->is('post')) {
			$this->InsuranceCompany->create();
			if ($this->InsuranceCompany->save($this->request->data)) {
				$this->Session->setFlash(__('The insurance company has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->set('errors', $this->InsuranceCompany->validationErrors);
				$this->Session->setFlash(__('The insurance company could not be saved. Please, try again.'));
			}
		}
		$cities = $this->City->find('list');
		$states = $this->State->find('list');
                $countries = $this->Country->find('list');
                $this->set(compact('cities', 'states','countries'));
	}

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->InsuranceCompany->id = $id;
		if (!$this->InsuranceCompany->exists()) {
			throw new NotFoundException(__('Invalid insurance company'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->InsuranceCompany->save($this->request->data)) {
				$this->Session->setFlash(__('The insurance company has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->set('errors', $this->InsuranceCompany->validationErrors);
				$this->Session->setFlash(__('The insurance company could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->InsuranceCompany->read(null, $id);
		}
		$cities = $this->InsuranceCompany->City->find('list');
		$states = $this->InsuranceCompany->State->find('list');
		$this->set(compact('cities', 'states'));
	}

/**
 * admin_delete method
 *
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		
		$this->InsuranceCompany->id = $id;
		if (!$this->InsuranceCompany->exists()) {
			throw new NotFoundException(__('Invalid insurance company'));
		}
		if ($this->InsuranceCompany->save(array('is_deleted' => 1))) {
			$this->Session->setFlash(__('Insurance company deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Insurance company was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

 /**
 * index method
 *
 * @return void
 */
	public function index() {
                $this->paginate = array('limit' => Configure::read('number_of_rows'),
										'order' => array('InsuranceCompany.id' => 'DESC'),
                                        'conditions' => array('InsuranceCompany.is_deleted' => 0,'InsuranceCompany.location_id'=>$this->Session->read('locationid')));
		$this->set('insuranceCompanies', $this->paginate('InsuranceCompany'));
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->InsuranceCompany->id = $id;
		if (!$this->InsuranceCompany->exists()) {
			throw new NotFoundException(__('Invalid insurance company'));
		}
		$this->set('insuranceCompany', $this->InsuranceCompany->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		$this->uses = array('City', 'Country', 'State', 'InsuranceType');
		if ($this->request->is('post')) {

			$this->InsuranceCompany->create();
			$this->request->data['InsuranceCompany']['location_id'] = $this->Session->read('locationid');
			if ($this->InsuranceCompany->save($this->request->data)) {
				$this->Session->setFlash(__('The insurance company has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->set('errors', $this->InsuranceCompany->validationErrors);
				$this->Session->setFlash(__('The insurance company could not be saved. Please, try again.'));
			}
		}
		$cities = $this->City->find('list');
		$states = $this->State->find('list');
                $countries = $this->Country->find('list');
                $insurancetypes = $this->InsuranceType->find('list', array('conditions' => array('InsuranceType.is_deleted' => 0),'fields' => array('InsuranceType.id', 'InsuranceType.name')));
                $this->set(compact('cities', 'states','countries', 'insurancetypes'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
                $this->uses = array('City', 'Country', 'State', 'InsuranceType');
		$this->InsuranceCompany->id = $id;
		if (!$this->InsuranceCompany->exists()) {
			throw new NotFoundException(__('Invalid insurance company'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data['InsuranceCompany']['location_id'] = $this->Session->read('locationid');
			if ($this->InsuranceCompany->save($this->request->data)) {
				$this->Session->setFlash(__('The insurance company has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->set('errors', $this->InsuranceCompany->validationErrors);
				$this->Session->setFlash(__('The insurance company could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->InsuranceCompany->read(null, $id);
		}
		$cities = $this->City->find('list');
		$states = $this->State->find('list');
                $countries = $this->Country->find('list');
                $insurancetypes = $this->InsuranceType->find('list', array('conditions' => array('InsuranceType.is_deleted' => 0),'fields' => array('InsuranceType.id', 'InsuranceType.name')));
                $this->set(compact('cities', 'states','countries', 'insurancetypes'));
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		
		$this->InsuranceCompany->id = $id;
		if (!$this->InsuranceCompany->exists()) {
			throw new NotFoundException(__('Invalid insurance company'));
		}
		if ($this->InsuranceCompany->save(array('is_deleted' => 1))) {
			$this->Session->setFlash(__('Insurance company deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Insurance company was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

}

?>