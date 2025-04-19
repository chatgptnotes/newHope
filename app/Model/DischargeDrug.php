<?php
class DischargeDrug extends AppModel {

	public $name = 'DischargeDrug';

  	public $belongsTo = array('PharmacyItem' => array('className'    => 'PharmacyItem',
	  											'type' => 'inner',
                                                 'foreignKey'    => 'drug_id')                                  
                                 );
 
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