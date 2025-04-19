<?php
class AllergyReaction extends AppModel {

	public $name = 'AllergyReaction';
        		
	public $cacheQueries = false ;
	
	
	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }  
    
}
?>