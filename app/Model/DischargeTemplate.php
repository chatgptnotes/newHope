<?php
class DischargeTemplate extends AppModel {

	public $name = 'DischargeTemplate';
	public $validate = array(
		'template_name' => array(
			'rule' => "notEmpty",
			'message' => "Please enter template name."
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