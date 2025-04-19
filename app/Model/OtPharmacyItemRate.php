<?php 

class OtPharmacyItemRate extends AppModel {
	
	public $name = 'OtPharmacyItemRate';

	
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
	 
	 public $belongsTo = array(
		'OtPharmacyItem' => array(
		'className' => 'OtPharmacyItem',
		'foreignKey' => 'item_id'
		)
	);  
}
?>