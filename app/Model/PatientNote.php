<?php
class PatientNote extends AppModel {

	public $name = 'PatientNote';
        public $useTable = 'notes';
       // public $actsAs = array('Auditable');


	      public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }  

}

?>