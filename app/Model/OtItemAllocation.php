<?php
class OtItemAllocation extends AppModel {

	public $name = 'OtItemAllocation';
	
        
        public $validate = array(
		        'opt_id' => array(
			    'rule' => "notEmpty",
			    'message' => "Please select OT Room."
			    )
		        );

       
	public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }
}
?>