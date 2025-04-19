<?php
/**
 * Languages Controller
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       CollaborateCompany.Controller
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Mayank Jain
 */
class CollaborateCompaniesController extends AppController {
	public $name = 'CollaborateCompanies';
	public $uses = array('CollaborateCompany');
	public $helpers = array('Html','Form', 'Js');
	public $components = array('RequestHandler','Email');	
	public $paginate = array(
        'limit' => 25,
        'order' => array(
            'CollaborateCompany.name' => 'asc'
        )
    );


/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->CollaborateCompany->recursive = 0;
		$this->set('collaborateCompanies', $this->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->CollaborateCompany->id = $id;
		if (!$this->CollaborateCompany->exists()) {
			throw new NotFoundException(__('Invalid collaborate company'));
		}
		$this->set('collaborateCompany', $this->CollaborateCompany->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->CollaborateCompany->create();
			if ($this->CollaborateCompany->save($this->request->data)) {
				$this->Session->setFlash(__('The collaborate company has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->set('errors', $this->CollaborateCompany->validationErrors);
				$this->Session->setFlash(__('The collaborate company could not be saved. Please, try again.'));
			}
		}
	}

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->CollaborateCompany->id = $id;
		if (!$this->CollaborateCompany->exists()) {
			throw new NotFoundException(__('Invalid collaborate company'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->CollaborateCompany->save($this->request->data)) {
				$this->Session->setFlash(__('The collaborate company has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->set('errors', $this->CollaborateCompany->validationErrors);
				$this->Session->setFlash(__('The collaborate company could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->CollaborateCompany->read(null, $id);
		}
	}

/**
 * admin_delete method
 *
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
	
		$this->CollaborateCompany->id = $id;
		if (!$this->CollaborateCompany->exists()) {
			throw new NotFoundException(__('Invalid collaborate company'));
		}
		if ($this->CollaborateCompany->save(array('is_deleted' => 1))) {
			$this->Session->setFlash(__('Collaborate company deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Collaborate company was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
