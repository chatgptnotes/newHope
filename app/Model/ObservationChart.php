<?php
	class ObservationChart extends AppModel {
	
		public $name = 'ObservationChart';
		public $specific = true;
		public $actsAs = array('Cipher' => array('autoDecypt' => true,'cipher'=>array('pulse','rr','bp','temp','osat'
		 ,'rbs','ivf','rtf','total_output','progress_remark','patient_name')));
		 
		function __construct($id = false, $table = null, $ds = null) {
			$session = new cakeSession();
			$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	    }     		
		
	}