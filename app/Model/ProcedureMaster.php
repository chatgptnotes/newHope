<?php
class ProcedureMaster extends AppModel{
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $name = 'ProcedureMaster';
	var $useTable = 'procedure_masters';

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * hasMany associations
	 *
	 * @var array
	 */

	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}
	
	
	function insertProcedure($data =array()){
			
		$session = new cakeSession();
	
		if(!empty($data["ProcedureMaster"]["id"])){
			$data["ProcedureMaster"]["modify_time"] = date("Y-m-d H:i:s");
			$data["ProcedureMaster"]["modified_by"] = $session->read('userid') ;
			$data["ProcedureMaster"]["location_id"] = $session->read('locationid');
		}else{
			$data["ProcedureMaster"]["create_time"] = date("Y-m-d H:i:s");
			$data["ProcedureMaster"]["created_by"]  = $session->read('userid') ;
			$data["ProcedureMaster"]["location_id"] = $session->read('locationid');
		}
		$this->create();
		$this->save($data);
		//$lastinsid=$this->getInsertId();
		return true;
	}
}
?>