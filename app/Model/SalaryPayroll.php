<?php
/**
 * @model SalaryPayroll model
 * @author Swapnil
 * @created : 15.03.2016
 */

	class SalaryPayroll extends AppModel {

		public $name = 'SalaryPayroll';  
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
    }
?>