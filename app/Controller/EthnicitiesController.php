<?php
/**
 * Languages Controller
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Ethnicities Controller
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Mayank Jain
 */
class EthnicitiesController extends AppController {
	public $name = 'Ethnicities';
	public $uses = array('Ethnicity');
	public $helpers = array('Html','Form', 'Js');
	public $components = array('RequestHandler','Email');	
	public $paginate = array(
        'limit' => 25,
        'order' => array(
            'Ethnicity.name' => 'asc'
        )
    );


/**
 * superadmin_index method
 *
 * @return void
 */
	public function superadmin_index() {
		$this->Ethnicity->recursive = 0;
		$this->set('ethnicities', $this->paginate());
	}

/**
 * superadmin_view method
 *
 * @param string $id
 * @return void
 */
	public function superadmin_view($id = null) {
		$this->Ethnicity->id = $id;
		if (!$this->Ethnicity->exists()) {
			throw new NotFoundException(__('Invalid ethnicity'));
		}
		$this->set('ethnicity', $this->Ethnicity->read(null, $id));
	}

/**
 * superadmin_add method
 *
 * @return void
 */
	public function superadmin_add() {
		if ($this->request->is('post')) {
			$this->Ethnicity->create();
			if ($this->Ethnicity->save($this->request->data)) {
				$this->Session->setFlash(__('The ethnicity has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->set('errors', $this->Ethnicity->validationErrors);
				$this->Session->setFlash(__('The ethnicity could not be saved. Please, try again.'));
			}
		}
	}

/**
 * superadmin_edit method
 *
 * @param string $id
 * @return void
 */
	public function superadmin_edit($id = null) {
		$this->Ethnicity->id = $id;
		if (!$this->Ethnicity->exists()) {
			throw new NotFoundException(__('Invalid ethnicity'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Ethnicity->save($this->request->data)) {
				$this->Session->setFlash(__('The ethnicity has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->set('errors', $this->Ethnicity->validationErrors);
				$this->Session->setFlash(__('The ethnicity could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Ethnicity->read(null, $id);
		}
	}

/**
 * superadmin_delete method
 *
 * @param string $id
 * @return void
 */
	public function superadmin_delete($id = null) {
	
		$this->Ethnicity->id = $id;
		if (!$this->Ethnicity->exists()) {
			throw new NotFoundException(__('Invalid ethnicity'));
		}
		if ($this->Ethnicity->save(array('is_deleted' => 1))) {
			$this->Session->setFlash(__('Ethnicity deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Ethnicity was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
