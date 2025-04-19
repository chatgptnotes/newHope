<?php

class BmiResult extends AppModel {

	public $specific = true;
	public $name = 'BmiResult';
	var $useTable = 'bmi_results';
	
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}

	
	function afterSave(){
		
		
			$diagnoses = Classregistry::init('Diagnosis');
			$diagnoses->addBlankEntry($this->data['BmiResult']['patient_id']);
		
	}  
	public function getBmiHistory($patientId){
		$BmiBpResult = Classregistry::init('BmiBpResult');
		$Patient = Classregistry::init('Patient');
		/* for vitals  */
		$this->bindModel(array(
				'belongsTo' => array(
						'BmiBpResult' =>array('foreignKey'=>false,
								'conditions'=>array('BmiBpResult.bmi_result_id = BmiResult.id')),
				)));

		$result =$this->find('first',array('fields'=> array('BmiResult.id','BmiResult.patient_id','BmiResult.height_result',
				'BmiResult.weight_result','BmiResult.created_time','BmiResult.bmi','BmiResult.date','BmiBpResult.id','BmiBpResult.systolic',
				'BmiBpResult.diastolic','BmiBpResult.systolic1','BmiBpResult.diastolic1','BmiBpResult.systolic2','BmiBpResult.diastolic2'),
				'conditions'=>array('BmiResult.id'=>$patientId),'order'=>array('BmiBpResult.id Desc')));
		return $result;
	} 

}
?>