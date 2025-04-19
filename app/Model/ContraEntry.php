<?php 
/** Contra Entry model
*
* PHP 5
*
* @copyright     Copyright 2013 DrM Hope Softwares
* @link          http://www.drmcaduceus.com/
* @package       ContraEntry.Model
* @since         CakePHP(tm) v 2.0
* @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
* @author        Amit
*/
class ContraEntry extends AppModel {
	
	public $name = 'ContraEntry'; 

	public $specific = true;
	public $validate = array(
			'account_id' => array(
					'rule' => "notEmpty",
					'message' => "Please try again."
			),
			'user_id' => array(
					'rule' => "notEmpty",
					'message' => "Please try again."
			),
			'debit_amount' => array(
					'rule' => "notEmpty",
					'message' => "Please enter amount"
			),
	);
		
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}
	
	/**
	 * function to get Contra Data Group wise in date range for trial balance
	 * @param  int $groupId --> Accounting Group Id
	 * @param  datetime $from --> From Date;
	 * @param  datetime $to --> To Date;
	 * @param  int $location_id --> Account Location id and if location id = All then skip location id
	 * @return debit sum of account_id and credit sum of user_id
	 * @author  Amit Jain
	 */
	public function getContraData($fromDate,$toDate,$locationId=null,$groupId=null,$reportType=null){
		$session = new CakeSession();
		$accountObj = ClassRegistry::init('Account');
	
		if($locationId != 'All'){
			$conditions['ContraEntry.location_id']=$locationId;
		}
		if($groupId != ''){
			$conditions['Account.accounting_group_id']=$groupId;
		}
		$conditions['ContraEntry.is_deleted']='0';
		$conditions['Account.is_deleted']='0';
		if($reportType==Configure::read('profit_loss_statement') || $reportType==Configure::read('balance_sheet_statement') ){ //ProfitLoss condition added by Mahalaxmi
			$fromDate = $fromDate;
		}else{
			$fromDate = '2000-01-01';
		}
		//---------------------------Debit ContraEntry----------------------------//
		$accountObj->bindModel(array(
				'hasOne'=>array(
						'ContraEntry'=>array('type'=>'inner','foreignKey'=>'account_id')),
		));
		$conDebitArray = $accountObj->find('all',array('fields'=>array('SUM(ContraEntry.debit_amount) as contraSumDebit','Account.id','Account.name',
				'Account.accounting_group_id'),
				'conditions'=>array($conditions,'ContraEntry.date BETWEEN ? AND ?' => array($fromDate,$toDate)),
				'group'=>array('ContraEntry.account_id'),
				'order'=>'Account.name ASC'));
	
		//---------------------------Credit ContraEntry----------------------------//
		$accountObj->bindModel(array(
				'hasOne'=>array(
						'ContraEntry'=>array('type'=>'inner','foreignKey'=>'user_id')),
		));
		$conCreditArray = $accountObj->find('all',array('fields'=>array('SUM(ContraEntry.debit_amount) as contraSumCredit','Account.id','Account.name',
				'Account.accounting_group_id'),
				'conditions'=>array($conditions,'ContraEntry.date BETWEEN ? AND ?' => array($fromDate,$toDate)),
				'group'=>array('ContraEntry.user_id'),
				'order'=>'Account.name ASC'));
	
		return array($conDebitArray,$conCreditArray);
	}
}
?>