<?php
/**
 * Languages Controller
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Languages.Controller
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Mayank Jain
 */
class LanguagesController extends AppController {
	public $name = 'Languages';
	public $uses = array('Language');
	public $helpers = array('Html','Form', 'Js');
	public $components = array('RequestHandler','Email');	
	public $paginate = array(
        'limit' => 25,
        'order' => array(
            'Language.name' => 'asc'
        )
    );
    


/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Language->recursive = 0;
		$this->set('languages', $this->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Language->id = $id;
		if (!$this->Language->exists()) {
			throw new NotFoundException(__('Invalid language'));
		}
		$this->set('language', $this->Language->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Language->create();
			if ($this->Language->save($this->request->data)) {
				$this->Session->setFlash(__('The language has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->set('errors', $this->Language->validationErrors);

				$this->Session->setFlash(__('The language could not be saved. Please, try again.'));
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
		$this->Language->id = $id;
		if (!$this->Language->exists()) {
			throw new NotFoundException(__('Invalid language'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Language->save($this->request->data)) {
				$this->Session->setFlash(__('The language has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
			$this->set('errors', $this->Language->validationErrors);

				$this->Session->setFlash(__('The language could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Language->read(null, $id);
		}
	}

/**
 * admin_delete method
 *
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {

		$this->Language->id = $id;
		if (!$this->Language->exists()) {
			throw new NotFoundException(__('Invalid language'));
		}
		if ($this->Language->save(array('is_deleted' => 1))) {
			$this->Session->setFlash(__('Language deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Language was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
