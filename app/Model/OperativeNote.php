<?php
/**
 * 
 * @author W
 * Model : Operative Notes
 *
 */
class OperativeNote extends AppModel {
	
	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		if(empty($ds)){
			$session = new cakeSession();
			$this->db_name =  $session->read('db_name');
		}else{
			$this->db_name =  $ds;
		}
		parent::__construct($id, $table, $ds);
	}
	
	//function to save opertaive notes
	function saveOperationNotes($data,$validate=false){
		$session  = new CakeSession() ;
		//check for date and convert in std format
		$dateFormatComponent = new DateFormatComponent() ;
		if($data['ot_date']){
			$data['ot_date'] = $dateFormatComponent->formatDate2STD($data['ot_date'], Configure::read('date_format')) ;
		} 
		if($data['ot_notes_date']){
			$data['ot_notes_date'] = $dateFormatComponent->formatDate2STD($data['ot_notes_date'], Configure::read('date_format')) ;
		}
		$data['created_by'] = $session->read('userid') ; 
		$savedata['OperativeNote']=$data;
		
		$result  = $this->save($savedata['OperativeNote']);
		if($result) return true;
		else return false ;
	}
	
	//funtion to return getOperativeNote
	function getOperativeNote($patient_id){
		if(empty($patient_id)) return false ;
		//check for date and convert in std format
		$dateFormatComponent = new DateFormatComponent() ;
		$result= $this->find('first',array('conditions'=>Array('patient_id'=>$patient_id))) ;
		if($result['OperativeNote']['ot_date']){
			$result['OperativeNote']['ot_date'] = $dateFormatComponent->formatDate2Local($result['OperativeNote']['ot_date'], Configure::read('date_format'),true) ;
		} 
		if($result['OperativeNote']['ot_notes_date']){
			$result['OperativeNote']['ot_notes_date'] = $dateFormatComponent->formatDate2Local($result['OperativeNote']['ot_notes_date'], Configure::read('date_format'),true) ;
		}
		return $result ; 
	}
}