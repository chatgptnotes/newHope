<?php

App::uses('AppModel', 'Model');
/**
 * CollaborateCompany Model
 *
 * @property Patient $Patient
*/
class DeviceUse extends AppModel {

	public $specific = true;
	public $name = 'DeviceUse';
	var $useTable = 'device_uses';

	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}

	
	function insertDeviceUse($data =array()){
		 
		$session = new cakeSession();
	
		if(!empty($data["DeviceUse"]["id"])){
			$data["DeviceUse"]["modify_time"] = date("Y-m-d H:i:s");
			$data["DeviceUse"]["modified_by"] = $session->read('userid') ;
			$data["DeviceUse"]["location_id"] = $session->read('locationid');
		}else{
			$data["DeviceUse"]["create_time"] = date("Y-m-d H:i:s");
			$data["DeviceUse"]["created_by"]  = $session->read('userid') ;
			$data["DeviceUse"]["location_id"] = $session->read('locationid');
		}
		$this->create();
		$this->save($data);
		//$lastinsid=$this->getInsertId();
		return true;
	}

}
?>