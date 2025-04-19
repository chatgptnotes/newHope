<?php
/**
 * Final Billing Options Model file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Final Billing Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pankaj wanjari
 */
class FinalBillingOption extends AppModel {
	
	public $name = 'FinalBillingOption';
	public $specific = true;
	public $actsAs = array('Cipher' => array('autoDecypt' => true,
						   'cipher'=>array('name','value')));
	
	function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    } 
	public function insertOptions($data,$final_billing_id){
		if(empty($final_billing_id)) return false ;
		 
		//remove previous entries if any (trick to update records)
		$this->deleteAll(array('final_billing_id'=>$final_billing_id));
		//now insert new records
		foreach($data as  $value ){ 
			$value['final_billing_id'] = $final_billing_id ;  
			if(!empty($value['name']) && trim($value['name']) != ''){
				$this->save($value);
			}
			 
			$this->id = '';
			
		} 
		
		return true ;
	}
}