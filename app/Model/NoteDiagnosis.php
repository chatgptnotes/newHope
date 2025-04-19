<?php
class NoteDiagnosis extends AppModel {

	public $name = 'NoteDiagnosis';
	public $useTable = 'note_diagnosis'; 
	public $specific = true; 
	//public $actsAs = array('Auditable');
	
	function __construct($id = false, $table = null, $ds = null) {
		 
		if(empty($ds)){
        	$session = new cakeSession();
			$this->db_name =  $session->read('db_name');
	 	}else{
	 		$this->db_name =  $ds;
	 	}
		parent::__construct($id, $table, $ds);
	}
	
	public function insertNoteDiagnosis($data=array()){
		
		$data1[NoteDiagnosis] = $data;
		$session = new cakeSession();
		
		if(isset($data1['NoteDiagnosis']['id']) && !empty($data1['NoteDiagnosis']['id'])){
			//set id for update d record
			$data1['NoteDiagnosis']['modified']= date("Y-m-d H:i:s");
			$data1['NoteDiagnosis']["modified_by"] =  $session->read('userid');
			 
			$note_id =$data1['NoteDiagnosis']['id'] ;
		}else{
			$data1['NoteDiagnosis']['created'] = date("Y-m-d H:i:s");
			$data1['NoteDiagnosis']["created_by"]  =  $session->read('userid');
		}
		debug($data1);
		$noteSave  = $this->save($data1);  //return of main query
		if(empty($note_id)){
			$note_id = $this->getInsertID();
		}
		
	
		return $noteSave  ;
		
	}
	public function encounterProblems($patientId,$apptId){
		$problems=$this->find('all',array('fields'=>array('icd_id','diagnoses_name','start_dt','end_dt','disease_status','snowmedid','terminal','snowmedid'),
		'conditions'=>array('NoteDiagnosis.patient_id'=>$patientId,'NoteDiagnosis.appointment_id'=>$apptId,'is_deleted'=>0,'terminal'=>'Yes')));
		return $problems;
	}
	public $belongsTo = array(
			'icds' => array('className'    => 'icds',
					'foreignKey'    => 'icd_id',
					//'conditions' => array('icds.id=NoteDiagnosis.icd_id')
			));
	
//	public $virtualFields = array(
	//		'full_icd' => 'CONCAT(icds.Icd_code,"    ",icds.description)'
	//);

	
	
	
	
}
?>