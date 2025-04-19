<?php
/**
 * @model SalaryStatementDetail model
 * @author Swapnil
 * @created : 08.03.2016
 */

	class SalaryStatementDetail extends AppModel {

		public $name = 'SalaryStatementDetail';  
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
            
        /*
         * function to delete all the entries of salary statement
         * @author : Swapnil
         * @created : 23.03.2016
         */
            
        public function deleteAllEntry($salaryStatementId){
            if(empty($salaryStatementId)) return false;
            $ds = $this->getDataSource();
            $ds->begin();
            if($this->updateAll(array('SalaryStatementDetail.is_deleted'=>'1'),array('SalaryStatementDetail.salary_statement_id'=>$salaryStatementId))){
                $ds->commit();
                return true;
            }else{
                $ds->rollback();
                return false;
            }
        }
    }
?>