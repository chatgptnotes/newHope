<?php 
class StockIssueDetail extends AppModel{
	public $name='StockIssueDetail';
	public $specific=true;
	public $useTable='stock_issue_details';
	
	function __construct($id = false, $table = null, $ds =null){
		$session= new CakeSession();
		$this->db_name= $session->read('db_name');
		parent::__construct($id,$table,$ds);
	}

}?>