<?php
/**
 * CorporateLocationsController file
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
class CorporateLocationsController extends AppController {

	public $name = 'CorporateLocations';
	public $uses = array('CorporateLocation');
	public $helpers = array('Html','Form', 'Js');
	public $components = array('RequestHandler','Email');
	
/**
 * corporate location listing
 *
 */	
	
	public function index() {
				$this->paginate = array(
			        'limit' => Configure::read('number_of_rows'),
			        'order' => array(
			            'CorporateLocation.name' => 'asc'
			        ),
			        'conditions' => array('CorporateLocation.is_deleted' => 0,'CorporateLocation.location_id'=>$this->Session->read('locationid'))
   				);
                $this->set('title_for_layout', __('Corporate Location', true));
                $this->CorporateLocation->recursive = 0;
                $data = $this->paginate('CorporateLocation');
                $this->set('data', $data);
	}

/**
 * corporate location view
 *
 */
	public function view($id = null) {
                $this->set('title_for_layout', __('Corporate Location Detail', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid Corporate Location', true));
			$this->redirect(array("controller" => "corporate_locations", "action" => "index"));
		}
                $this->set('corporatelocation', $this->CorporateLocation->read(null, $id));
        }

/**
 * corporate location add
 *
 */
	public function add() {
                $this->set('title_for_layout', __('Add New Corporate Location', true));
                if ($this->request->is('post')) {
                		$this->request->data['CorporateLocation']['location_id'] = $this->Session->read('locationid');
                        $this->request->data['CorporateLocation']['create_time'] = date('Y-m-d H:i:s');
                        $this->request->data['CorporateLocation']['created_by'] = $this->Auth->user('id');
                        $this->CorporateLocation->create();
                        $this->CorporateLocation->save($this->request->data);
                        $errors = $this->CorporateLocation->invalidFields();
			if(!empty($errors)) {
                           $this->set("errors", $errors);
                        } else {
                           $this->Session->setFlash(__('The corporate location has been saved', true));
			   $this->redirect(array("controller" => "corporate_locations", "action" => "index"));
                        }
		} 
                
	}

/**
 * corporate location edit
 *
 */
	public function edit($id = null) {
                $this->set('title_for_layout', __('Edit Corporate Location Detail', true));
                if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid Corporate Location', true));
                        $this->redirect(array("controller" => "corporate_locations", "action" => "index"));
		}
                if ($this->request->is('post') && !empty($this->request->data)) {
                		$this->request->data['CorporateLocation']['location_id'] = $this->Session->read('locationid');
                        $this->request->data['CorporateLocation']['modify_time'] = date('Y-m-d H:i:s');
                        $this->request->data['CorporateLocation']['modified_by'] = $this->Auth->user('id');
                        $this->CorporateLocation->id = $this->request->data["CorporateLocation"]['id'];
                        $this->CorporateLocation->save($this->request->data);
			$errors = $this->CorporateLocation->invalidFields();
                        if(!empty($errors)) {
                           $this->set("errors", $errors);
                        } else {
                           $this->Session->setFlash(__('The corporate location has been updated', true));
			   $this->redirect(array("controller" => "corporate_locations", "action" => "index"));
                        }
		} else {
                        $this->request->data = $this->CorporateLocation->read(null, $id);
                }
                
		
	}

/**
 * corporate location delete
 *
 */
	public function delete($id = null) {
                $this->set('title_for_layout', __('Delete Corporate Location', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for corporate location', true));
			$this->redirect(array("controller" => "corporate_locations", "action" => "index"));
		}
		if ($id) {
                        $this->CorporateLocation->deleteCorporateLocation($this->request->params);
                        $this->Session->setFlash(__('Corporate location deleted', true));
			$this->redirect(array("controller" => "corporate_locations", "action" => "index"));
		}
	}
        
/**
 * corporate location common
 *
 */
	public function common(){
		
	}
}
?>