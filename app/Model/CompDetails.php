<?php

class CompDetails extends AppModel {

    public $useTable = 'company_details';

    public $name = 'CompDetails';
    public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);}

}
?>
