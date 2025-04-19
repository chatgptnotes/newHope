<?php
/**
 * AdvanceTypecontroller file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Wards Controller
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 */

class AdvanceTypeController extends AppController {
	
	public $name = 'AdvanceTypes';
	public $uses = array('AdvanceType');
	public $helpers = array('Html','Form', 'Js','Number');
	public $components = array('RequestHandler','Email', 'Session'); 
	
	 
	//function to list against (type)
	function admin_index(){
		$this->set('title_for_layout', __('-Advance Type', true));
		$this->paginate = array(
									'limit' => Configure::read('number_of_rows'),
				        			'order' => array('AdvanceType.date' => 'asc'),
			    					'conditions'=>array('AdvanceType.location_id'=>$this->Session->read('locationid')));
		
		$this->set('data',$this->paginate('AdvanceType')); 	 
	}
	
	//function to add/edit type
	function admin_add($id=null){
			$this->set('title_for_layout', __('-Advance Type', true));
			if(!empty($this->request->data)){
			 
				$result = $this->AdvanceType->insertType($this->request->data);
				$errors = $this->AdvanceType->invalidFields();
				if(!empty($errors)) {
	            	$this->set("errors", $errors);			
	            	$this->Session->setFlash(__('Please try again' ),'default',array('class'=>'error'));
	            }else {
	            	$this->Session->setFlash(__('Record added successfully' ),'default',array('class'=>'message'));
	            	$this->redirect(array('action'=>'index'));
	            }
			}
			if($id){
				$this->data = $this->AdvanceType->read(null,$id);
			}
	}
	
	function admin_delete($id=null){
		if($id){
			if($this->AdvanceType->delete($id)){
				$this->Session->setFlash(__('Record deleted successfully' ),'default',array('class'=>'message'));
		        $this->redirect(array('action'=>'index'));
			}else{
				$this->Session->setFlash(__('Please try again' ),'default',array('class'=>'error'));
		        $this->redirect(array('action'=>'index'));
			}
		}else{
			$this->redirect($this->redirect());
		}		
	}
}