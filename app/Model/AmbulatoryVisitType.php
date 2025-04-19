<?php
class AmbulatoryVisitType extends AppModel {

	public $name = 'AmbulatoryVisitType';
        		
	public $cacheQueries = false ;
	
	
	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }  
    
}
?>