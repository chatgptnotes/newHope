<?php  
class CorporateSuperBillList extends AppModel {
	public $name = 'CorporateSuperBillList';
	public $specific = true;
	public $useTable='corporate_super_bill_lists';
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}
}
?>