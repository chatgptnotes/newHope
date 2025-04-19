<?php

/**
 * Patient Card Model
 * Pooja
 *  
 */

App::uses('AppModel', 'Model');

class PatientCard extends AppModel {

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
	
	/**
	 * function to insert row in patient card table
	 * @param unknown_type $cardAmount // amount deducted from card
	 * @param unknown_type $personId  // person id
	 * @param unknown_type $billId	// Billing id 
	 */
	function insertIntoCard($cardAmount,$personId,$billId=NULL,$type=NULL){
		$session = new cakeSession();
		$Account = Classregistry::init('Account');
		$accId=$Account->find('first',array('fields'=>array('Account.id','Account.card_balance'),
				'conditions'=>array('Account.system_user_id'=>$personId,'Account.user_type'=>'Patient',
						'Account.is_deleted'=>"0")));
		$cardBalance=$accId['Account']['card_balance']-$cardAmount;
		$Account->updateAll(array('Account.card_balance'=>$cardBalance),array('Account.id'=>$accId['Account']['id']));
		$patientCard['person_id']=$personId;
		$patientCard['account_id']=$accId['Account']['id'];
		$patientCard['amount']=$cardAmount;
		$patientCard['type']=$type;
		$patientCard['billing_id']=$billId;
		$patientCard['bank_id']=$Account->getAccountIdOnly(Configure::read('PatientCardLabel'));
		$patientCard['mode_type']='Patient Card';
		$patientCard['created_by']=$session->read('userid');
		$patientCard['create_time']=date('Y-m-d H:i:s');
		$this->save($patientCard);
		
	}
}

?>