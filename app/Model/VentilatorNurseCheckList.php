<?php

App::uses('AppModel', 'Model');
/**
 * CollaborateCompany Model
 *
 * @property Patient $Patient
*/
class VentilatorNurseCheckList extends AppModel {

	public $specific = true;
	public $name = 'VentilatorNurseCheckList';
	var $useTable = 'ventilator_nurse_check_lists';
	
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}
		
	function insertCheckList($data= array()){
		
		$session = new cakeSession();
		$dateFormat  = new DateFormatComponent();
		$data['VentilatorNurseCheckList']['location_id'] = $session->read('locationid');
		if(empty($data['VentilatorNurseCheckList']['id'])){
			$data['VentilatorNurseCheckList']['created_by'] = $session->read('userid');
			$data['VentilatorNurseCheckList']['create_time'] = date("Y-m-d H:i:s");
			$data['VentilatorNurseCheckList']['created_by'] = $session->read('userid');
			$data['VentilatorNurseCheckList']['create_time'] = date("Y-m-d H:i:s");
		}else{
			$this->id = $data['VentilatorNurseCheckList']['id'] ;
			$data['VentilatorNurseCheckList']['modified_by'] = $session->read('userid');
			$data['VentilatorNurseCheckList']['modify_time'] = date("Y-m-d H:i:s");
			$data['VentilatorNurseCheckList']['modified_by'] = $session->read('userid');
			$data['VentilatorNurseCheckList']['modify_time'] = date("Y-m-d H:i:s");
		}
		$this->save($data['VentilatorNurseCheckList']);
		
		
	}
	
	

}
?>