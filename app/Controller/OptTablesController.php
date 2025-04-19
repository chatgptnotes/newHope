<?php
/**
 * OptTableController file
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
class OptTablesController extends AppController {

	public $name = 'OptTables';
	public $uses = array('OptTable');
	public $helpers = array('Html','Form', 'Js');
	public $components = array('RequestHandler','Email');
	
/**
 * operation table listing
 *   
 */	
	
	public function index() {
				$this->paginate = array(
			        'limit' => Configure::read('number_of_rows'),
			        'order' => array(
			            'OptTable.name' => 'asc'
			        ),
			        'conditions' => array('OptTable.is_deleted' => 0,'Opt.location_id' => $this->Session->read("locationid"))
   				);
                $this->set('title_for_layout', __('OPT Table', true));
                $this->OptTable->recursive = 0;
                $data = $this->paginate('OptTable');
                $this->set('data', $data);
	}

/**
 * operation table view
 *
 */
	public function view($id = null) {
                $this->set('title_for_layout', __('OT Table Detail', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid OT Table', true));
			$this->redirect(array("controller" => "opt_tables", "action" => "index"));
		}
                $this->set('opt_table', $this->OptTable->read(null, $id));
        }

/**
 * operation table add
 *
 */
	public function add() {
                $this->loadModel("Opt");
                $this->set('title_for_layout', __('Add New OT Table', true));
                if ($this->request->is('post')) {
                        $this->request->data['OptTable']['create_time'] = date('Y-m-d H:i:s');
                        $this->request->data['OptTable']['created_by'] = $this->Auth->user('id');
                        $this->OptTable->create();
                        $this->OptTable->save($this->request->data);
                        $errors = $this->OptTable->invalidFields();
			            if(!empty($errors)) {
                           $this->set("errors", $errors);
                        } else {
                           $this->Session->setFlash(__('The OT Table has been saved', true));
			               $this->redirect(array("controller" => "opt_tables", "action" => "index"));
                        }
		} 
               $this->set('opt', $this->Opt->find('list', array('fields'=> array('id', 'name'),'conditions' => array('Opt.is_deleted' => 0, 'Opt.location_id' => $this->Session->read('locationid')))));
                
	}

/**
 * operation table edit
 *
 */
	public function edit($id = null) {
                $this->uses = array('Opt');
                $this->set('title_for_layout', __('Edit OT Table Detail', true));
                if (!$id && empty($this->request->data)) {
			            $this->Session->setFlash(__('Invalid OT Table', true));
                        $this->redirect(array("controller" => "opt_tables", "action" => "index"));
		        }
                if ($this->request->is('post') && !empty($this->request->data)) {
                        $this->request->data['OptTable']['modify_time'] = date('Y-m-d H:i:s');
                        $this->request->data['OptTable']['modified_by'] = $this->Auth->user('id');
                        $this->OptTable->id = $this->request->data["OptTable"]['id'];
                        $this->OptTable->save($this->request->data);
			            $errors = $this->OptTable->invalidFields();
                        if(!empty($errors)) {
                           $this->set("errors", $errors);
                        } else {
                           $this->Session->setFlash(__('The OT Table has been updated', true));
			               $this->redirect(array("controller" => "opt_tables", "action" => "index"));
                        }
		} else {
                        $this->request->data = $this->OptTable->read(null, $id);
                        
                }
		                $this->set('opt', $this->Opt->find('list', array('fields'=> array('id', 'name'),'conditions' => array('Opt.is_deleted' => 0, 'Opt.location_id' => $this->Session->read('locationid')))));
                
	}

/**
 * operation table delete
 *
 */
	public function delete($id = null) {
                $this->set('title_for_layout', __('Delete OT Table', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for OT Table', true));
			$this->redirect(array("controller" => "opt_tables", "action" => "index"));
		}
		if ($id) {
            $this->OptTable->deleteOptTable($this->request->params);
            $this->Session->setFlash(__('OPT Table deleted', true));
			$this->redirect(array("controller" => "opt_tables", "action" => "index"));
		}
	}
        
        
}
?>