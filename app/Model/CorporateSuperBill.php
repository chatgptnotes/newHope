<?php

 /* Allergies model
*
* PHP 5
*
* @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
* @link          http://www.klouddata.com/
* @package       Languages.Model
* @since         CakePHP(tm) v 2.0
* @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
* @author        Pooja Gupta
*/
class CorporateSuperBill extends AppModel {
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $name = 'CorporateSuperBill';

	

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * hasMany associations
	 *
	 * @var array
	*/
	
	public $specific = true;
	public $useTable='corporate_super_bills';
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}

	public function generateSuperBillNo($tariff){		//by swapnil - 06.07.2015 
		$getBillCount = $this->find('count');
		return "GS-".str_pad(++$getBillCount, 4, '0', STR_PAD_LEFT);
	}
	
	public function saveData($data=array()){
		if(!empty($data)){  
			if($this->save($data)){		//insert
				return $this->getLastInsertID();
			} 
		}
	}
	
	public function updatePatientType($superId,$type){
		$this->updateAll(array('patient_type'=>"'$type'"),array('id'=>$superId));
		return ;
	}
	
	public function updateApprovedAmt($superId,$amount){
		$this->updateAll(array('approved_amount'=>"'$amount'"),array('id'=>$superId));
		return ;
	}
	
}
?>