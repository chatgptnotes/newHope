<?php
class OpdInvoice extends AppModel {

	public $name = 'OpdInvoice';

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

	function generateInvoiceNo(){
		$getBillCount = $this->find('count'); 
		$getBillCount++;
		return "HHC-".date('Y')."-".str_pad($getBillCount, 4, '0', STR_PAD_LEFT);	
	}
	
}
?>