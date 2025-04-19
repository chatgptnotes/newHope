<?php
class Country extends AppModel {

	public $name = 'Country';
    //public $useDbConfig = 'test';   		
	public $validate = array(
		'name' => array(
			'rule' => "notEmpty",
			'message' => "Please enter name."
			)
                );
        
	public function getCountryByID($id=null){
		return $this->read(null,$id);
	}
	      public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
	  	if(empty($ds)){
        	$session = new cakeSession();
			$this->db_name =  $session->read('db_name');
	 	}else{
	 		$this->db_name =  $ds;
	 	}
        parent::__construct($id, $table, $ds);
    }  	

}
?>