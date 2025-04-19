<?php

class SettlementBillingOption extends AppModel {

	public $name = 'SettlementBillingOption'; 
	public $specific = true;
	public $actsAs = array('Cipher' => array('autoDecypt' => true,
						   'cipher'=>array('name','rate','amount','moa_sr_no','nabh_non_nabh')));
    public function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    } 
        
        
	
}