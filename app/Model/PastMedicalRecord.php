<?php
class PastMedicalRecord extends AppModel {

	public $name = 'PastMedicalRecord';

	public $cacheQueries = false ;


	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}
	
	function insertPast_Medical_Record($data =array(),$action='insert',$id){
		$this->uses=array('PastMedicalRecord');
		$session     = new cakeSession();
		$userid 	 = $session->read('userid') ;
		$locationId  = $session->read('locationid') ;
	//debug($data);
	//exit;
		 
		//$this->create(); 	//illness  	status    duration    comments
		
		 
		///return($latest_insert_id);
	///$data['Diagnosis']['patient_id']
	}
	
}
?>