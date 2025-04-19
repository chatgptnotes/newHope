<?php
/**
 * PatientPortalController file
 *
 * PHP 5
 *
 * @copyright     Copyright 2013 drmhope Inc.  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       PatientPortal Controller
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 */

class PatientPortalsController extends AppController {
	
	public $name = 'PatientPortals';
	public $uses = array('PatientPortal');
	public $helpers = array('Html','Form', 'Js');
	public $components = array('RequestHandler','Email', 'Session');
	
	public function labResults($patient_id=86){echo '##########';exit;
		$this->uses = array('Person','Patient','Consultant','User','LabManager','LaboratoryResult','RadiologyTestOrder','RadiologyReport','RadiologyResult','Radiology');
		if(!empty($patient_id)){
			
			$data1 = $this->RadiologyReport->find('all',array('fields'=>array('RadiologyReport.id','RadiologyReport.patient_id','RadiologyReport.file_name'),
					'conditions'=>array('RadiologyReport.patient_id'=>$patient_id)));
			
			for($a=0;$a<count($data1);$a++){
				
				$b[]='"'.$this->webroot.'uploads/radiology/'.$data1[$a][RadiologyReport][file_name].'"';
			}
			
			$this->set('data1',$data1);
			$this->set('b',$b);
			$sessionReturnString = $this->Session->read('labResultReturn') ;
			$currentReturnString = $this->params->query['return'] ;
			if(($currentReturnString!='') && ($currentReturnString != $sessionReturnString) ){
				$this->Session->write('labResultReturn',$currentReturnString);
			}
			
				
			$this->patient_info($patient_id);
		
			$this->LabManager->bindModel(array(
					'belongsTo' => array(
							'Laboratory'=>array('foreignKey'=>'laboratory_id','conditions'=>array('Laboratory.is_active'=>1))
					),
					'hasOne' => array( 'LaboratoryResult'=>array('foreignKey'=>'laboratory_test_order_id') ,
							'LaboratoryToken'=>array('foreignKey'=>'laboratory_test_order_id')
					)),false);
			 
			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'fields'=>array('LaboratoryResult.result_publish_date','LaboratoryResult.confirm_result','LabManager.id','LabManager.create_time',
							'LabManager.patient_id','LabManager.order_id','Laboratory.id','Laboratory.name','LaboratoryToken.ac_id','LaboratoryToken.sp_id'),
					'conditions'=>array('LabManager.patient_id'=>$patient_id,'LabManager.is_deleted'=>0),
					'order' => array(
							'LabManager.id' => 'asc'
					),
					'group'=>'LabManager.id'
			);
			$testOrdered   = $this->paginate('LabManager');
			
			$this->set(array('testOrdered'=>$testOrdered));echo '<pre>';print_r($testOrdered);exit;
			
		}else{
			$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
			$this->redirect($this->referer());
		}
	}
}