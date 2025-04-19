<?php
	class FallAssessment extends AppModel {
	
		public $name = 'FallAssessment';				
		public $specific = true;
		public $actsAs = array('Cipher' => array('autoDecypt' => true,'cipher'=>array('patient_name','gait_score'
	 ,'mental_status_score','total_score','risk_level')));
		 
		  function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
			$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	    }
	}