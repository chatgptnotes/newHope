<?php
class OtherService extends AppModel {

	public $name = 'OtherService';
	public $actsAs = array('Cipher' => array('autoDecypt' => true,
						   'cipher'=>array('service_name','service_amount')));
	
	public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }
	
	 
	//function to remove entries after discharged date
	function deleteAfterDischargeRecords($date,$patient_id){
		if(empty($patient_id)) return ;
		$session = new CakeSession();
		//split date 
		$splittedDate  = explode(' ',$date);
		$this->updateAll(array('is_deleted'=>1,'modified_by'=>$session->read('userid')),
		array('service_date  >= '=> $splittedDate[0],'patient_id'=>$patient_id)) ;
	}
}