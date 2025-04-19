<?php
/**
 * PatientCentricDepartmentsController file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Hope hospital
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Mayank Jain
 */
class PatientCentricDepartmentsController extends AppController {	
	public $name = 'PatientCentricDepartments';
	public $uses = array('PatientCentricDepartment');
	public $helpers = array('Html','Form', 'Js');
	public $components = array('RequestHandler','Email');
	
/**
 * operation theature listing
 *
 */	
	
	public function admin_index() {
				$this->paginate = array(
			        'limit' => Configure::read('number_of_rows'),
			        'order' => array(
			            'PatientCentricDepartment.name' => 'asc'
			        ),
			        'conditions' => array('PatientCentricDepartment.is_deleted' => 0,'PatientCentricDepartment.location_id' => $this->Session->read("locationid"))
   				);
                $this->set('title_for_layout', __('Patient Centric Department - List', true));
                $this->PatientCentricDepartment->recursive = 0;
                $data = $this->paginate('PatientCentricDepartment');
                $this->set('data', $data);
	}
	
	public function admin_add(){
	   $this->set('title_for_layout', __('Add New Patient Centric Department', true));
		if ($this->request->is('post')) { 
			$this->request->data['PatientCentricDepartment']['location_id'] = $this->Session->read("locationid");
			$this->request->data['PatientCentricDepartment']['create_time'] = date('Y-m-d H:i:s');
			$this->request->data['PatientCentricDepartment']['created_by'] = $this->Auth->user('id');
			$this->PatientCentricDepartment->create();
			$this->PatientCentricDepartment->save($this->request->data);
			$errors = $this->PatientCentricDepartment->invalidFields();
			if(!empty($errors)) {
			    $this->set("errors", $errors);
			} else {
			    $this->Session->setFlash(__('The Patient Centric Department has been saved', true));
			 	$this->redirect(array("controller" => "patient_centric_departments", "action" => "index","admin" =>true));
			}
		}  
	}
	public function admin_edit($id = null) {
		$this->set('title_for_layout', __('Edit Patient Centric Department Detail', true));
		if (!$id && empty($this->request->data)) {
				$this->Session->setFlash(__('Invalid Patient Centric Department', true));
				$this->redirect(array("controller" => "patient_centric_departments", "action" => "index","admin" =>true));
		}
		if ($this->request->is('post') && !empty($this->request->data)) {
				$this->request->data['PatientCentricDepartment']['modify_time'] = date('Y-m-d H:i:s');
				$this->request->data['PatientCentricDepartment']['modified_by'] = $this->Auth->user('id'); 
 				$this->PatientCentricDepartment->save($this->request->data); 
				$errors = $this->PatientCentricDepartment->invalidFields();
				if(!empty($errors)) {
				   $this->set("errors", $errors);
				} else {
				   $this->Session->setFlash(__('The Patient Centric Department has been updated', true));
				   $this->redirect(array("controller" => "patient_centric_departments", "action" => "index","admin" =>true));
				}
		} else {
				$this->request->data = $this->PatientCentricDepartment->read(null, $id);
		} 
	}
	
	
/**
 * operation theature delete
 *
 */
	public function admin_delete($id = null) {
 		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Patient Centric Department', true));
			$this->redirect(array("controller" => "patient_centric_departments", "action" => "index","admin" =>true));
		}
		if ($id) {
			$this->PatientCentricDepartment->id = $id;
		
			$this->request->data['PatientCentricDepartment']['is_deleted'] =1;
		    $this->PatientCentricDepartment->save($this->request->data);  
 			$this->Session->setFlash(__('Patient Centric Department deleted', true));
			$this->redirect(array("controller" => "patient_centric_departments", "action" => "index","admin" =>true));
		}
	}
        
}
?>