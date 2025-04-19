<?php
/**
 * NewLaboratory Model file
 *
 * PHP 5
 *
 * @copyright     Copyright 2013 Drmhope Softwares  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       Hope
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Gulshan Trivedi
*/
class NewLaboratory extends AppModel {
	public $name = 'NewLaboratory';
	public $useTable = false;
	public $specific = true;
	//public $actsAs = array('Sphinx');
	
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession ();
		$this->db_name = $session->read ( 'db_name' );
		parent::__construct ( $id, $table, $ds );
	}
	function insertLab($data) {
// 		debug($data);exit;
		unset ( $data ['LaboratoryParameter'] ['id'] );
		$session = new cakeSession ();
		$laboratoryResult = ClassRegistry::init ( 'LaboratoryResult' );
		$laboratoryhL7Result = ClassRegistry::init ( 'LaboratoryHl7Result' );
		$patientDocument = ClassRegistry::init ( 'PatientDocument' );
		$laboratoryTestOrder = ClassRegistry::init ( 'LaboratoryTestOrder' );
		$dateFormat = ClassRegistry::init('DateFormatComponent');
		// *** For histology part
		if ($data ['LaboratoryResult'] ['lab_type'] == '2') {
			$laboratoryResults ['laboratory_id'] = $data ['LaboratoryResult'] ['laboratory_id'];
			$laboratoryResults ['text'] = $data ['LaboratoryResult'] ['text'];
			$laboratoryResults ['patient_id'] = $data ['LaboratoryResult'] ['patient_id'];
			$laboratoryResults ['laboratory_test_order_id'] = $data ['LaboratoryResult'] ['laboratory_test_order_id'];
			$laboratoryResults ['user_id'] = $session->read ( 'userid' );
			$laboratoryResults ['id'] = $data ['LaboratoryResult'] ['id'];
			$laboratoryResults ['is_authenticate'] = $data ['LaboratoryResult'] ['is_authenticate'];
			$laboratoryResults['report_date']=$dateFormat->formatDate2STD($data ['LaboratoryResult']['report_date'],Configure::read('date_format'));
			 
			$laboratoryTestOrder->save(array('LaboratoryTestOrder.is_retest'=>null),array('LaboratoryTestOrder.id'=>$data ['LaboratoryResult'] ['laboratory_test_order_id']));
			$laboratoryResult->save ( $laboratoryResults );
			if($data ['LaboratoryResult'] ['id'])
				$labResultID = $data ['LaboratoryResult'] ['id'];
			else
				$labResultID = $laboratoryResult->getLastInsertID ();
			
			foreach ( $data ['LaboratoryParameter'] as $keyLab => $histo ) {
				$subArr = array ();
				$subArr ['laboratory_parameter_id'] = $keyLab;
				$subArr ['laboratory_test_order_id'] = $data ['LaboratoryResult'] ['laboratory_test_order_id'];
				$subArr ['observations'] = $histo;
				$subArr ['laboratory_result_id'] = $labResultID;
				$subArr ['laboratory_id'] = $data ['LaboratoryResult'] ['laboratory_id'];
				$subArr ['location_id'] = $session->read ( 'locationid' );
				$subArr ['created_by'] = $session->read ( 'userid' );
				$subArr ['create_time'] = date ( "Y-m-d H:i:s" );
				$subArr ['id'] = $data ['LaboratoryHl7Result'] [$keyLab];
				$laboratoryhL7Result->id = $data ['LaboratoryHl7Result'] [$keyLab];
				$laboratoryhL7Result->save ( $subArr );
			}
			$laboratoryResult->id = '';
		} else { // ***For Regular part
			foreach ( $data ['LaboratoryResult'] as $key => $value ) {
				//debug($value);exit;
				if ((empty ( $value ['id'] ) && ($value ['id'] == ''))) {
					$value['report_date']=$dateFormat->formatDate2STD($value['report_date'],Configure::read('date_format'));
					if(!$value['report_date']) $value['report_date']=  date('Y-m-d H:i:s') ;
					$laboratoryResult->save ( $value );
					$labResultID = $laboratoryResult->getLastInsertID ();
					if (is_array ( $data ['LaboratoryHl7Result'] [$key] )) {
						foreach ( $data ['LaboratoryHl7Result'] [$key] as $hl7key => $hl7Value ) {
							$hl7Value ['laboratory_result_id'] = $labResultID;
							$hl7Value ['location_id'] = $session->read ( 'locatioid' );
							// debug($hl7Value);exit;
							$laboratoryhL7Result->save ( $hl7Value );
							$laboratoryhL7Result->id = '';
						}
					}
					$laboratoryResult->id = '';
				} else {
					$labResultID = $value ['id'];
					$value['report_date']=$dateFormat->formatDate2STD($value['report_date'],Configure::read('date_format'));
					if(!$value['report_date']) $value['report_date']=  date('Y-m-d H:i:s') ;
					$laboratoryResult->id = $labResultID; // id of lab_result for update
					$laboratoryTestOrder->updateAll(array('LaboratoryTestOrder.is_retest'=>null),array('LaboratoryTestOrder.id'=>$value['laboratory_test_order_id']));
					$laboratoryResult->save ( $value ); // updating
					                                    // debug($data['LaboratoryHl7Result'][$key]);
					if (is_array ( $data ['LaboratoryHl7Result'] [$key] )) {
						foreach ( $data ['LaboratoryHl7Result'] [$key] as $hl7key => $hl7Value ) {
							$hl7Value ['id'] = $hl7Value ['id'];
							$hl7Value ['laboratory_result_id'] = $labResultID;
							$hl7Value ['location_id'] = $session->read ( 'locatioid' );
							// debug($hl7Value);exit;
							$laboratoryhL7Result->save ( $hl7Value );
							$laboratoryhL7Result->id = '';
						}
					}
					$laboratoryResult->id = '';
				}
			}
		}
	}
}

?>  