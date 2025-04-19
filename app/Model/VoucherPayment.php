<?php 
/** Service Amount model
*
* PHP 5
*
* @copyright     Copyright 2013 DrM Hope Softwares
* @link          http://www.drmcaduceus.com/
* @package       ServiceAmount.Model
* @since         CakePHP(tm) v 2.0
* @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
* @author        Pooja
*/
class VoucherPayment extends AppModel {
	
	public $name = 'VoucherPayment'; 

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
			'paid_amount' => array(
					'rule' => "notEmpty",
					'message' => "Please enter amount"
			),
	);
		
	function __construct($id = false, $table = null, $ds = null) {	
		if(empty($ds)){
			$session = new cakeSession();
			$this->db_name =  $session->read('db_name');
		}else{
			$this->db_name =  $ds;
		}
		parent::__construct($id, $table, $ds);
	}
	
	public function insertPaymentEntry($data=array()){
		$session = new CakeSession();
		$data['create_time'] = date('Y-m-d H:i:s') ;
		$data['modify_time'] = $session->read('userid') ;
		$data['location_id'] = $session->read('locationid') ;
		$this->save($data) ;
		return $this->getLastInsertId();
	}
	public function beforeSave(){
		$session = new CakeSession();
		if (!isset($this->data[$this->alias]['location_id'])) {
			$this->data[$this->alias]['location_id'] = $session->read('locationid');
		}
		return true;
	}
	
	/**
	 * function to get Payment Data Group wise in date range for trial balance
	 * @param  int $groupId --> Accounting Group Id
	 * @param  datetime $from --> From Date;
	 * @param  datetime $to --> To Date;
	 * @param  int $location_id --> Account Location id and if location id = All then skip location id
	 * @return debit sum of account_id and credit sum of user_id
	 * @author  Amit Jain
	 */
	public function getPaymentData($fromDate,$toDate,$locationId=null,$groupId=null,$reportType=null){
		$session = new CakeSession();
		$accountObj = ClassRegistry::init('Account');
	
		if($locationId != 'All'){
			$conditions['VoucherPayment.location_id']=$locationId;
		}
		if($groupId != ''){
			$conditions['Account.accounting_group_id']=$groupId;
		}
		$conditions['VoucherPayment.is_deleted']='0';
		$conditions['Account.is_deleted']='0';
		$conditions['VoucherPayment.type NOT'] = 'RefferalCharges';//RefferalCharges
		if($reportType==Configure::read('profit_loss_statement') || $reportType==Configure::read('balance_sheet_statement')){ //ProfitLoss condition added by Mahalaxmi
			$fromDate = $fromDate;
		}else{
			$fromDate = '2000-01-01';
		}
		//---------------------------Debit VoucherPayment----------------------------//
		$accountObj->bindModel(array(
				'hasOne'=>array(
						'VoucherPayment'=>array('type'=>'inner','foreignKey'=>'user_id')),
		));
		
		$payDebitArray = $accountObj->find('all',array('fields'=>array('SUM(VoucherPayment.paid_amount) as paymentSumDebit','Account.id','Account.name',
				'Account.accounting_group_id','Account.system_user_id','Account.user_type'),
				'conditions'=>array($conditions,'VoucherPayment.date BETWEEN ? AND ?' => array($fromDate,$toDate)),
				'group'=>array('VoucherPayment.user_id'),
				'order'=>'Account.name ASC'));
				
				
	
		//---------------------------Credit VoucherPayment----------------------------//
		$accountObj->bindModel(array(
				'hasOne'=>array(
						'VoucherPayment'=>array('type'=>'inner','foreignKey'=>'account_id')),
		));
		$payCreditArray = $accountObj->find('all',array('fields'=>array('SUM(VoucherPayment.paid_amount) as paymentSumCredit','Account.id','Account.name',
				'Account.accounting_group_id'),
				'conditions'=>array($conditions,'VoucherPayment.date BETWEEN ? AND ?' => array($fromDate,$toDate)),
				'group'=>array('VoucherPayment.account_id'),
				'order'=>'Account.name ASC'));
	
		return array($payDebitArray,$payCreditArray);
	}
	
	/**
	 * function to get Payment Data User wise in date range for consultant outstanding report
	 * @param  int $id --> user id
	 * @param  datetime $from --> From Date;
	 * @param  datetime $to --> To Date;
	 * @return debit sum of user_id
	 * @author  Amit Jain
	 */
	public function getUserWiseData($fromDate,$toDate,$id=array()){
		$session = new CakeSession();
		//---------------------------Debit VoucherPayment----------------------------//
		$getPaymentDebit = $this->find('all',array('fields'=>array(
				'DATE_FORMAT(VoucherPayment.date, "%Y") AS year_reports','DATE_FORMAT(VoucherPayment.date, "%m") AS month_reports',
				'VoucherPayment.user_id','SUM(VoucherPayment.paid_amount) as paymentSumDebit'),
				'conditions'=>array('VoucherPayment.is_deleted'=>'0','VoucherPayment.user_id'=>array_keys($id),
						'VoucherPayment.date BETWEEN ? AND ?' => array($fromDate,$toDate)),
				'group'=>array('user_id','year_reports','month_reports')));
		
		$paymentDebit=array();
		foreach ($getPaymentDebit as $key=>$data){
			$paymentDebit[$data['VoucherPayment']['user_id']][$data['0']['year_reports']][$data['0']['month_reports']]['debit'] += round($data['0']['paymentSumDebit']);
		}
		return array('paymentDebit'=>$paymentDebit);
	}
	
}
?>