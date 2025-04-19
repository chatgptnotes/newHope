<?php
/**
 * Accounting controller
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Accounting Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author
 */
class CostcenterController extends AppController {

	public $name = 'Costcenter';
	public $uses = array('Costcenter');
	public $helpers = array('Html','Form', 'Js','DateFormat','RupeesToWords','Number','General');
	public $components = array('RequestHandler','Email');

	public function admin_index(){


	}
	public function admin_add(){
		 
	}
	public function admin_edit(){
	}
	 
	/**
	 * function to add edit earning types
	 * @param int $earningDeductionId
	 * @author Gaurav Chauriya
	 */
	public function earningDeductionMaster($earningDeductionId = null){
		$this->layout = 'advance';
		$this->uses  = array('EarningDeduction');
		$this->set('title_for_layout', __('Payment System', true));
		if($this->request->data['EarningDeduction']){
			$this->EarningDeduction->saveEarningDeduction($this->request->data['EarningDeduction']);
			$message = ($this->request->data['EarningDeduction']['id']) ? 'Updated Successfully' : 'Added Successfully';
			$this->Session->setFlash(__($message, true, array('class'=>'message')));
			$this->redirect(array('action'=>'earningDeductionMaster'));
		}
		if($this->params->query['name']){
			$searchByName['EarningDeduction.name Like'] = $this->params->query['name'].'%';
		}
		$this->paginate = array(
				'evalScripts' => true,
				'limit' => Configure::read('number_of_rows'),
				'order' => array('EarningDeduction.id'=>'DESC'),
				'conditions' => array('EarningDeduction.is_deleted' => 0,$searchByName)
		);
		$data = $this->paginate('EarningDeduction');
		if($earningDeductionId){
			$this->data  = $this->EarningDeduction->read(null,$earningDeductionId);
			$this->set('action','edit');
		}
		$this->set('data', $data);
	}
	/**
	 * function to delete earning types
	 * @param int $earningDeductionId
	 * @author Gaurav Chauriya
	 */
	public function deleteEarningDeduction($earningDeductionId){
		$this->uses  = array('EarningDeduction');
		$deleteArray['id'] = $earningDeductionId;
		$deleteArray['is_deleted'] = 1;
		$this->EarningDeduction->saveEarningDeduction($deleteArray);
		$this->Session->setFlash(__('Deleted Successfully', true, array('class'=>'message')));
		$this->redirect(array('controller'=>'Costcenter','action'=>'earningDeductionMaster'));
	}

}