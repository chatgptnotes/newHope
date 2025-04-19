<?php
/**
 * ScheduleJobsShell file
 *
 * PHP 5
 * 
 *
 * @copyright     Copyright 2015 drmhope Inc.  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       ScheduleJobsShell
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 */
App::uses('ConnectionManager', 'Model');
class ScheduleJobShell extends AppShell {
	/* public $name = 'ScheduleJob';
	public $uses = array('ScheduleJob'); */
	public $helpers = array('Html','Form', 'Js');
	//public $components = array('RequestHandler','Email', 'Session');
	
	/* public function __construct(){
		
	} */
	
	public function main() {
		$this->closedOPDEncounters();
	}
	
	/**
	 * @author Pawan Meshram
	 * DO NOT CHANGE
	 * This job will run at every night 12.00 PM to close all encounter of OPD
	 */
	public function closedOPDEncounters(){
		$dataSource = ConnectionManager::getDataSource('default');
		$confDeafult = ConnectionManager::$config->defaultHospital;
		$this->database = $confDeafult['database'];
		App::uses('AppModel','Model');
		App::uses('Patient', 'Model');
		App::uses('FinalBilling', 'Model');
		App::uses('Appointment', 'Model');
		App::uses('PharmacySalesBill', 'Model');
		App::uses('InventoryPharmacySalesReturn', 'Model');
		$patientModel = new Patient(null,null,$this->database);
		$finalBillingModel = new FinalBilling(null,null,$this->database);
		$appointmentModel = new Appointment(null,null,$this->database);
		$patientModel->unBindModel(array(
				'hasMany' => array(new PharmacySalesBill(null,null,$this->database),
						new InventoryPharmacySalesReturn(null,null,$this->database))));
		$appointmentData = $appointmentModel->find('all',array('conditions'=>array("Appointment.status != 'Closed'")));
		foreach($appointmentData as $appKey=>$appValue){
			$patientModel->set('is_discharged','1');
			$patientModel->set('discharge_date',date("Y-m-d H:i:s"));
			$patientModel->id = $appValue['Appointment']['patient_id'];
			$patientModel->saveAll(null,array('callbacks' =>false));
			$finalBillingData = $finalBillingModel->findByPatientId($appValue['Appointment']['patient_id']);
			$finalBillingModel->id = $finalBillingData['FinalBilling']['id'];
			$finalBillingModel->set('is_discharged','1');
			$finalBillingModel->set('discharge_date',date("Y-m-d H:i:s"));
			$finalBillingModel->saveAll(null,array('callbacks' =>false));
			$appointmentModel->id = $appValue['Appointment']['id'];
			$appointmentModel->set('status','Closed');
			$appointmentModel->saveAll(null,array('callbacks' =>false));
			$appointmentModel->id = null;
			$finalBillingModel->id = null;
			$patientModel->id = null;
		}
	}
		
}