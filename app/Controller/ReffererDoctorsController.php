<?php
/**
 * ReffererDoctorsController file
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
class ReffererDoctorsController extends AppController {

	public $name = 'ReffererDoctors';
	public $uses = array('ReffererDoctor');
	public $helpers = array('Html','Form', 'Js');
	public $components = array('RequestHandler','Email');
	
/**
 * refferer doctor listing
 *
 */	
	
	public function index() {
				$this->paginate = array(
			        'limit' => Configure::read('number_of_rows'),
			        'order' => array(
			            'ReffererDoctor.name' => 'asc'
			        ),
			        'conditions' => array('ReffererDoctor.is_deleted' => 0)
   				);
                $this->set('title_for_layout', __('Referer Doctor', true));
                $this->ReffererDoctor->recursive = 0;
                $data = $this->paginate('ReffererDoctor');
                $this->set('data', $data);
	}

/**
 * refferer doctor view
 *
 */
	public function view($id = null) {
                $this->set('title_for_layout', __('Referer Doctor Detail', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid Referer Doctor', true));
			$this->redirect(array("controller" => "refferer_doctors", "action" => "index"));
		}
                $this->set('reffererdoctor', $this->ReffererDoctor->read(null, $id));
    }

/**
 * refferer doctor add
 *
 */
	public function add() {
                $this->set('title_for_layout', __('Add New Referer Doctor', true));
                if ($this->request->is('post')) {
                        $this->request->data['ReffererDoctor']['create_time'] = date('Y-m-d H:i:s');
                        $this->request->data['ReffererDoctor']['created_by'] = $this->Auth->user('id');
                        $this->request->data['ReffererDoctor']['location_id'] = $this->Session->read('locationid');
                        
                        $this->ReffererDoctor->create();
                        $this->ReffererDoctor->save($this->request->data);
                        $errors = $this->ReffererDoctor->invalidFields();
			if(!empty($errors)) {
                           $this->set("errors", $errors);
                        } else {
                           $this->Session->setFlash(__('The referer doctor has been saved', true));
			   $this->redirect(array("controller" => "refferer_doctors", "action" => "index"));
                        }
		} 
                
	}

/**
 * refferer doctor edit
 *
 */
	public function edit($id = null) {
                $this->set('title_for_layout', __('Edit Referer Doctor Detail', true));
                if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid Referer Doctor', true));
                        $this->redirect(array("controller" => "refferer_doctors", "action" => "index"));
		}
                if ($this->request->is('post') && !empty($this->request->data)) {
                        $this->request->data['ReffererDoctor']['modify_time'] = date('Y-m-d H:i:s');
                        $this->request->data['ReffererDoctor']['modified_by'] = $this->Auth->user('id');
                        $this->ReffererDoctor->id = $this->request->data["ReffererDoctor"]['id'];
                        $this->ReffererDoctor->save($this->request->data);
			$errors = $this->ReffererDoctor->invalidFields();
                        if(!empty($errors)) {
                           $this->set("errors", $errors);
                        } else {
                           $this->Session->setFlash(__('The referer doctor has been updated', true));
			   $this->redirect(array("controller" => "refferer_doctors", "action" => "index"));
                        }
		} else {
                        $this->request->data = $this->ReffererDoctor->read(null, $id);
                }
		
	}

/**
 * refferer doctor delete
 *
 */
	public function delete($id = null) {
                $this->set('title_for_layout', __('Delete Referer Doctor', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Referer Doctor', true));
			$this->redirect(array("controller" => "refferer_doctors", "action" => "index"));
		}
		if ($id) {
                        $this->ReffererDoctor->deleteReffererDoctor($this->request->params);
                        $this->Session->setFlash(__('Referer Doctor deleted', true));
			$this->redirect(array("controller" => "refferer_doctors", "action" => "index"));
		}
	}
        

        
}
?>