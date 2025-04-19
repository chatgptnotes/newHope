<?php
class DischargeTemplateText extends AppModel {

	public $name = 'DischargeTemplateText';
	public $validate = array(
		'template_name' => array(
			'rule' => "notEmpty",
			'message' => "Please enter template text name."
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