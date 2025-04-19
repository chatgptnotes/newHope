<?php
class Envallergytype extends AppModel {

	public $name = 'Envallergytype';
        		
	public $cacheQueries = false ;
	
	
	
	function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }  
    
}
?>