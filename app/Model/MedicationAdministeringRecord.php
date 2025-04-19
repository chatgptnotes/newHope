<?php 
App::uses('AppModel', 'Model');
/**
 * MedicationAdministeringRecord Model
 * @copyright     Copyright 2013 DrM Hope Software.  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       Medication Prescription Records
 * @since         CakePHP(tm) v 5.4.3
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Gaurav Chauriya
 * 
*/

class MedicationAdministeringRecord extends AppModel {

	public $name = 'MedicationAdministeringRecord';
	var $useTable = 'medication_administering_records';
	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}
	
	function insertRecord($data = array()){
		$session     = new cakeSession();
		//$ReviewIoPatientDetail = ClassRegistry::init('ReviewIoPatientDetail');
		$userId 	 = $session->read('userid') ;
		$locationId  = $session->read('locationid') ;
			
		if(!empty($data['MedicationAdministeringRecord']['id'])){
			$data["MedicationAdministeringRecord"]["modify_time"] = date("Y-m-d H:i:s");
			$data["MedicationAdministeringRecord"]["modified_by"] = empty($userid)?'1':$userid;
			$data["MedicationAdministeringRecord"]["location_id"] = $locationId ;
		}else{
			$data["MedicationAdministeringRecord"]["create_time"] = date("Y-m-d H:i:s");
			$data["MedicationAdministeringRecord"]["created_by"]  = empty($userid)?'1':$userid;
			$data["MedicationAdministeringRecord"]["modify_time"] = date("Y-m-d H:i:s");
			$data["MedicationAdministeringRecord"]["modified_by"] = empty($userid)?'1':$userid;
			$data["MedicationAdministeringRecord"]["location_id"] = $locationId ;
		}
		
		
		$this->create();
			
		$this->save($data['MedicationAdministeringRecord']);
		
		return true;
	}
	
	function signMedications($patientId = null,$data = array()){
		$NewCropPrescription = ClassRegistry::init('NewCropPrescription');
		foreach($data['SignMar'] as $signData){
			
			$medication_administering_time = date('Y-m-d H:i:s');//DateFormatComponent::formatDate2STD(date("d/m/Y H:i:s"),Configure::read('date_format'));
			
			if(!isset($signData['scheduled_datetime']) || empty($signData['scheduled_datetime'])){
				$scheduled_datetime = $medication_administering_time;
			}else{
				$scheduled_datetime = DateFormatComponent::formatDate2STD($signData['scheduled_datetime'],Configure::read('date_format'));
			}
			$NewCropPrescription->updateAll(array('NewCropPrescription.medication_administering_time' =>"'".$medication_administering_time."'"), 
    						array('NewCropPrescription.id' => $signData['id'],'NewCropPrescription.patient_uniqueid' => $patientId));
			$this->updateAll(array('MedicationAdministeringRecord.is_signed' => '1','MedicationAdministeringRecord.scheduled_datetime' => "'".$scheduled_datetime."'"), 
    					array('MedicationAdministeringRecord.new_crop_prescription_id' => $signData['id'],'MedicationAdministeringRecord.patient_id' => $patientId,
    							'MedicationAdministeringRecord.admin_note_flag' => '0','MedicationAdministeringRecord.med_request_flag' => '0'));
		}
		return true;
	}
}
?>