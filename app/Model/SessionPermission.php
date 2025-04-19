<?php
//By pankaj wanjari
//For storing user permission in session for succeding call
class SessionPermission extends AppModel {

	public $name = 'SessionPermission';
	public $specific = true;
	//public $primaryKey = 'pid' ;
	
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}
	
	public function saveData($id,$data,$expiry,$hospital_mode){
		if(!$id) return false ;
		$record = compact('id','data','expiry','hospital_mode');
		return $this->save($record);
	}
}