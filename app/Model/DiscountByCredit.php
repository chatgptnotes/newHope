<?php

class DiscountByCredit extends AppModel {

	public $name = 'DiscountByCredit'; 
	public $specific = true;
	public $actsAs = array('Cipher' => array('autoDecypt' => true,
						   'cipher'=>array('reason_for_credit_voucher')));
	 
    public function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    } 
        
        
	
}