<?php
class StockMaintenanceDetail extends AppModel {

	public $specific = true;
	public $name='StockMaintenanceDetail';
	public $useTable='stock_maintenance_details';
	function __construct($id = false, $table = null, $ds = null) {
		if(empty($ds)){
			$session = new cakeSession();
			$this->db_name =  $session->read('db_name');
		}else{
			$this->db_name =  $ds;
		}
		parent::__construct($id, $table, $ds);
	}
}


?>