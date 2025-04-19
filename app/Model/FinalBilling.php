<?php
/**
 * Final Billing Model file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Final Billing Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 */
class FinalBilling extends AppModel {
	
	public $name = 'FinalBilling';
	public $specific = true;
	 public $actsAs = array('Cipher' => array('autoDecypt' => true,
						   'cipher'=>array('patient_discharge_condition','primary_consultant','credit_period','other_consultant',
						   'final_diagnosis','discount_percent','discount_rupees','reason_for_discount','bill_number'))); 
	
	public function __construct($id = false, $table = null, $ds = null) {
		if(empty($ds)){
        	$session = new cakeSession();
			$this->db_name =  $session->read('db_name');
	 	}else{
	 		$this->db_name =  $ds;
	 	}
		parent::__construct($id, $table, $ds);
	}
	public function saveFinalBill(){
		
	}
}