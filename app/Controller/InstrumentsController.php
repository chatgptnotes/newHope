<?php
/**
 * Instrument Controller
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Instrument Controller
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 
 */
class InstrumentsController   extends AppController {
	public $name = 'Instruments';
	public $uses = array('DeviceMaster');
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
			            'DeviceMaster.name' => 'asc'
			        ),
                                'conditions' => array('DeviceMaster.is_deleted' => 0, 'DeviceMaster.location_id' => $this->Session->read('locationid'))
			    );
		$this->set('instruments', $this->paginate('DeviceMaster')); 
	}


/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->DeviceMaster->create();
                        $this->request->data['DeviceMaster']['location_id'] = $this->Session->read('locationid');
                        $this->request->data['DeviceMaster']['create_time'] = date('Y-m-d H:i:s');
                        $this->request->data['DeviceMaster']['created_by'] = $this->Auth->user('id');
			if ($this->DeviceMaster->save($this->request->data)) {
				$this->Session->setFlash(__('The Instrument has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				if($this->DeviceMaster->validationErrors){
					$this->set('errors', $this->DeviceMaster->validationErrors);
				}else{
					$this->Session->setFlash(__('The Instrument could not be saved. Please, try again.'));
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
                $this->DeviceMaster->id = $id;
		if ($this->request->is('post') || $this->request->is('put')) {
                        $this->request->data['DeviceMaster']['modify_time'] = date('Y-m-d H:i:s');
                        $this->request->data['DeviceMaster']['modified_by'] = $this->Auth->user('id');
			if ($this->DeviceMaster->save($this->request->data)) {
				$this->Session->setFlash(__('The Instrument has been updated.'));
				$this->redirect(array('action' => 'index'));
			} else {
			$this->set('errors', $this->DeviceMaster->validationErrors);

				$this->Session->setFlash(__('The Instrument could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->DeviceMaster->read(null, $id);
		}
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->DeviceMaster->id = $id;
		if (!$this->DeviceMaster->exists()) {
			throw new NotFoundException(__('Invalid designation'));
		}
		if ($this->DeviceMaster->save(array('is_deleted' => 1))) {
			$this->Session->setFlash(__('Instrument deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Instrument was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	function change_status($id=null,$status=null){
		if($id==''){
			$this->Session->setFlash(__('There is some problem'),'default',array('class'=>'error'));
			$this->redirect($this->referer());
		}
		$this->DeviceMaster->id = $id ;
		$this->DeviceMaster->save(array('is_active'=>$status));
		$this->Session->setFlash(__('Status has been changed successfully'),'default',array('class'=>'message'));
		$this->redirect($this->referer());
	}
}
