<?php

App::uses('AppModel', 'Model');
/**
 * CollaborateCompany Model
 *
 * @property ManufacturerCompany $ManufacturerCompany
*/
class ManufacturerCompany extends AppModel {

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
	
	//insert by pankaj
	public function insertManufacturer($data){
		$this->save($data); 
		return $this->getLastInsertID();
	}
}
?>