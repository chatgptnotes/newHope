<?php
class SurgeryConsentForm extends AppModel {

	public $name = 'SurgeryConsentForm';
	
        
        public $validate = array(
		        'surgery_body_part' => array(
			    'rule' => "notEmpty",
			    'message' => "Please enter surgery body part."
			    ),
                'relative_name' => array(
			    'rule' => "notEmpty",
			    'message' => "Please enter relative name."
			    ),
		
                );
			
	
      
	public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }
}
?>