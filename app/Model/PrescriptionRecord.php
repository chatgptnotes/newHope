<?php
/**
 * PrescriptionRecord model
 *
 * PHP 5
 *
 * @link          http://www.drmhope.com/
 * @package       PrescriptionRecord Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Gaurav Chauriya
 */
class PrescriptionRecord extends AppModel {

	public $name = 'PrescriptionRecord';
	public $useTable = 'prescription_records';
	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}

	public function insertPrescriptionRecord($Prescdata){
		
		$session = new cakeSession();
		$data['PrescriptionRecord']['patient_uid'] = $Prescdata['patient_id'];
		$data['PrescriptionRecord']["administer_by"]  = $Prescdata['AdministerBy'];
		$data['PrescriptionRecord']["administered_time"]  = DateFormatComponent::formatDate2STD($Prescdata['administered_time'],Configure::read('date_format'));
		$data['PrescriptionRecord']["quantity"]  = $Prescdata['quantity'];
		$data['PrescriptionRecord']["dose_form"]  = $Prescdata['dose_form'];
		$data['PrescriptionRecord']["new_crop_prescription_id"]  = $Prescdata['new_crop_prescription_id'];
		$data['PrescriptionRecord']["medication"]  = $Prescdata['patientMedicat'];
		$data['PrescriptionRecord']['location_id'] = $session->read('locationid');
		$data['PrescriptionRecord']['create_time'] = date("Y-m-d H:i:s");
		$data['PrescriptionRecord']["created_by"]  = $session->read('userid');
		debug($data);
		$this->save($data); 
		return $this->id  ;

	}
}
?>