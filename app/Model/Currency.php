<?php
	class Currency extends AppModel {
	
		public $name = 'Currency';     		
		public $validate = array(
			'name' => array(
				'rule' => "notEmpty",
				'message' => "Please enter name."
				),
			 'code' => array(
				'rule' => "notEmpty",
				'message' => "Please enter code."
				)
	         );
	     
		public $specific = false;
		function __construct($id = false, $table = null, $ds = null) {
	        $session = new cakeSession();
			$this->db_name =  $session->read('db_name');
	        parent::__construct($id, $table, $ds);
	    }  

	    
	    public function getAllCurrencies(){
	    	return $this->find('list',array('order'=>'Currency.name'));
	    }
	    
		public function getCurrencyByID($id=null){
			return $this->read(null,$id);
		}
		
		 
	}
?>