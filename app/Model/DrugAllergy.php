<?php

class DrugAllergy extends AppModel {

	  public $name = 'DrugAllergy';
		
	  public $belongsTo = array('PharmacyItem' => array('className'    => 'PharmacyItem',
	  											'type' => 'inner',
                                                 'foreignKey'    => 'drug_id')                                  
                                 );
                                  
      
	       public $specific = true;
	       public $validate = array(
	       		'from1' => array(
	       				'rule' => "notEmpty",
	       				'message' => "Please enter allergy."
	       		),
	       		
	       		//'startdate' => array(
	       			//	'rule' => "notEmpty",
	       			//	'message' => "Please enter Start Date."
	       		//),
	       		
	       );
	       
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }  
}
?>