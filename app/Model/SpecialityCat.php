<?php
class SpecialityCat extends AppModel {

	public $specific = true;
	public $name = 'SpecialityCat';
	var $useTable = 'speciality_cats';

	function __construct($id = false, $table = null, $ds = null) 
	{
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }  

	
}
?>