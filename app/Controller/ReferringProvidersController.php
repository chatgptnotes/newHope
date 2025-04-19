<?php
/**
 * Languages Controller
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       ReferringProviders Controller
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Mayank Jain
 */
class ReferringProvidersController extends AppController {

	public $name = 'ReferringProviders';
		public $uses = array('ReferringProvider');
		public $helpers = array('Html','Form', 'Js');
		public $components = array('RequestHandler','Email');	
		public $paginate = array(
			'limit' => 25,
			'order' => array(
				'ReferringProvider.name' => 'asc'
			)
		);

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->ReferringProvider->recursive = 0;
		$this->set('referringProviders', $this->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->ReferringProvider->id = $id;
		if (!$this->ReferringProvider->exists()) {
			throw new NotFoundException(__('Invalid referring provider'));
		}
		$this->set('referringProvider', $this->ReferringProvider->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->ReferringProvider->create();
			if ($this->ReferringProvider->save($this->request->data)) {
				$this->Session->setFlash(__('The referring provider has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->set('errors', $this->ReferringProvider->validationErrors);
				$this->Session->setFlash(__('The referring provider could not be saved. Please, try again.'));
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
		$this->ReferringProvider->id = $id;
		if (!$this->ReferringProvider->exists()) {
			throw new NotFoundException(__('Invalid referring provider'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->ReferringProvider->save($this->request->data)) {
				$this->Session->setFlash(__('The referring provider has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->set('errors', $this->ReferringProvider->validationErrors);
				$this->Session->setFlash(__('The referring provider could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->ReferringProvider->read(null, $id);
		}
	}

/**
 * admin_delete method
 *
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
	
		$this->ReferringProvider->id = $id;
		if (!$this->ReferringProvider->exists()) {
			throw new NotFoundException(__('Invalid referring provider'));
		}
		if ($this->ReferringProvider->save(array('is_deleted' => 1))) {
			$this->Session->setFlash(__('Referring provider deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Referring provider was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
