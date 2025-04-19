<?php
class SettlementBilling extends AppModel {

	public $name = 'SettlementBilling';

	public $actsAs = array('Cipher' => array('autoDecypt' => true,
						   'cipher'=>array('name','unit','rate','amount','moa_sr_no','nabh_non_nabh')));
	
	public $specific = true;
    public function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    } 
        
        
	
}