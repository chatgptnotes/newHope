<?php
/**
 * Other Treatment Model file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Final Billing Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 */
class OtherTreatment extends AppModel {

	public $name = 'OtherTreatment';
	public $specific = true;
	public $actsAs = array('Cipher' => array('autoDecypt' => true,
			'cipher'=>array('patient_discharge_condition','primary_consultant','credit_period','other_consultant',
					'final_diagnosis','discount_percent','discount_rupees','reason_for_discount','bill_number')));

	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}
	public function insertOtherTreatment($data=array()){
		$session = new cakeSession();
		$dateFormat = ClassRegistry::init('DateFormatComponent');	
		$data['OtherTreatment']['patient_id']=$data['OtherTreatment']['patient_id'];
		$result= $this->find('first',array('fields'=>array('id','patient_id'),'conditions'=>array('patient_id'=>$data['OtherTreatment']['patient_id'])));
		$data['OtherTreatment']['first_round_date']=$dateFormat->formatDate2STD($data['OtherTreatment']['first_round_date'],Configure::read('date_format'));
		$data['OtherTreatment']['last_round_date']=$dateFormat->formatDate2STD($data['OtherTreatment']['last_round_date'],Configure::read('date_format'));
		$data['OtherTreatment']['radiation_start_date']=$dateFormat->formatDate2STD($data['OtherTreatment']['radiation_start_date'],Configure::read('date_format'));
		$data['OtherTreatment']['radiation_finish_date']=$dateFormat->formatDate2STD($data['OtherTreatment']['radiation_finish_date'],Configure::read('date_format'));
		$data['OtherTreatment']['receive_chemotherapy_date']=$dateFormat->formatDate2STD($data['OtherTreatment']['receive_chemotherapy_date'],Configure::read('date_format'));
		if($result){			
			$data['OtherTreatment']['modified_time']= date("Y-m-d H:i:s");
			$data['OtherTreatment']["modified_by"] =  $session->read('userid');
			$this->id = $result['OtherTreatment']['id'];
		}else{
			$data['OtherTreatment']['created_time'] = date("Y-m-d H:i:s");
			$data['OtherTreatment']["created_by"]  =  $session->read('userid');
		}	
		$this->save($data);	
		return true;
	}
	function afterSave($created){
		if($created){
			$diagnoses = Classregistry::init('Diagnosis');
			$diagnoses->addBlankEntry($this->data['OtherTreatment']['patient_id']);
		}
	}
}