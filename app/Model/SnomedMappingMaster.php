<?php

App::uses('AppModel', 'Model');
/**
 * CollaborateCompany Model
 *
 * @property Patient $Patient
*/
class SnomedMappingMaster extends AppModel {

	public $specific = true;
	public $name = 'SnomedMappingMaster';
	var $useTable = 'snomed_mapping_masters';
	
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}
	
	/*function find($type, $options = array()){
		$data = parent::find($type, $options);
		foreach ($data as $key => $value) {
			$value['SnomedMappingMaster']['mapTarget'] = str_replace("?","",$value['SnomedMappingMaster']['mapTarget']);
			$data[$key] = $value;
    	}   
		return $data;
	}
*/

}
?>