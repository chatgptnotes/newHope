<?php
class Imunization extends AppModel {

	public $useTable = 'immunizations';
	public $name = 'Imunization';
	public $specific = true;
	
	function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }

   
    
    // Get cause of death
    
    
}