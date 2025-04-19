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
class AccountReceipt extends AppModel {
	
	public $name = 'AccountReceipt';

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
	
	public function insertReceiptEntry($data=array()){
		$session = new CakeSession();
		$data['create_time'] = date('Y-m-d H:i:s') ;
		$data['create_by'] = $session->read('userid') ;
		$data['location_id'] = $session->read('locationid') ;
		if(empty($data['date'])){
			$data['date']=date('Y-m-d H:i:s');
		}
	    $this->save($data);
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
	 * Function to Insert Receipt voucher and voucherEntry for discount and tds receivable 
	 * Amit Jain
	 */
	public function corporateReceiptEntry($data=array()){
		$session = new CakeSession(); 
		
		$patientObj=ClassRegistry::init('Patient');
		$accountObj=ClassRegistry::init('Account');
		$voucherLogObj=ClassRegistry::init('VoucherLog');
		$voucherEntryObj = ClassRegistry::init('VoucherEntry');
		
		$getPatientDetails=$patientObj->find('first',array('conditions'=>array('Patient.id'=>$data['Billing']['patient_id']),
				'fields'=>array('Patient.person_id','Patient.lookup_name')));//for person id
		$personId = $getPatientDetails['Patient']['person_id'];
		
		$accountDetails = $accountObj->getAccountID($personId,'Patient');//for account id
		$userId = $accountDetails['Account']['id'];
		if(!empty($data['Billing']['date'])){
			$date = $data['Billing']['date'];
		}elseif(!empty($data['Billing']['invoice_date'])){
			$date = DateFormatComponent::formatDate2STD($data['Billing']['invoice_date'],Configure::read('date_format'));
		}else{
			$date = date('Y-m-d H:i:s');
		}
	//BOF for Receipt Voucher Entry for Corporate Patient
		if(!empty($data['Billing']['amount'])){
			$voucherLogData=$rvData = array(
					'date'=>$date,
					'modified_by'=>$session->read('userid'),
					'create_by'=>$session->read('userid'),
					'patient_id'=>$data['Billing']['patient_id'],
					'account_id'=>$data['Billing']['bank_id'],
					'user_id'=>$userId,
					'type'=>'FinalPayment',
					'narration'=>$data['Billing']['remark'],
					'paid_amount'=>$data['Billing']['amount']);
			if(!empty($rvData['paid_amount']) && ($rvData['paid_amount'] != 0)){
				$lastVoucherIdRecFinal=$this->insertReceiptEntry($rvData);
				//insert into voucher_logs table added by PankajM
				$voucherLogData['voucher_no']=$lastVoucherIdRecFinal;
				$voucherLogData['voucher_id']=$lastVoucherIdRecFinal;
				$voucherLogData['voucher_type']="Receipt";
				$voucherLogObj->insertVoucherLog($voucherLogData);
				$voucherLogObj->id= '';
				$this->id= '';
				// ***insert into Account (By) credit manage current balance
				$accountObj->setBalanceAmountByAccountId($userId,$data['Billing']['amount'],'debit');
				$accountObj->setBalanceAmountByUserId($data['Billing']['bank_id'],$data['Billing']['amount'],'credit');
			}
		}
	//EOF for Receipt Voucher Entry for Corporate Patient
		
	//BOF Discount allowed entry for corporate patient
		if(!empty($data['Billing']['other_deduction']) && $data['Billing']['other_deduction'] !='0'){
			$voucherLogData = array();
			$discount = $data['Billing']['other_deduction'];
			$accountId = $accountObj->getAccountIdOnly(Configure::read('DiscountAllowedLabel'));
			$narrationDis = 'Discount Allowed '.$discount.'/- against Pt '.$getPatientDetails['Patient']['lookup_name'];
			
			$voucherLogData = $jvData = array(
					'date'=>$date,
					'modified_by'=>$session->read('userid'),
					'created_by'=>$session->read('userid'),
					'patient_id'=>$data['Billing']['patient_id'],
					'account_id'=>$accountId,
					'user_id'=>$userId,
					'type'=>'Discount',
					'narration'=>$narrationDis,
					'debit_amount'=>$discount);
			if(!empty($jvData['debit_amount']) && ($jvData['debit_amount'] != 0)){
				$lastVoucherIdPayment = $voucherEntryObj->insertJournalEntry($jvData);
				//insert into voucher_logs table added by PankajM
				$voucherLogData['voucher_no']=$lastVoucherIdPayment;
				$voucherLogData['voucher_id']=$lastVoucherIdPayment;
				$voucherLogData['voucher_type']="Journal";
		
				$voucherLogObj->insertVoucherLog($voucherLogData);
				$voucherLogObj->id= '';
				$voucherEntryObj->id= '';
				// ***insert into Account (By) credit manage current balance
				$accountObj->setBalanceAmountByAccountId($userId,$discount,'debit');
				$accountObj->setBalanceAmountByUserId($accountId,$discount,'credit');
			}
		}
	//EOF Discount allowed entry for corporate patient

	//BOF for TDS receivable
		if(!empty($data['Billing']['tds'])){
			$voucherLogDataTds = array();
			$tdsAmount = $data['Billing']['tds'];
			$TdsId = $accountObj->getAccountIdOnly(Configure::read('TDSreceivable'));
			$narrationTds = 'TDS receivable '.$tdsAmount.'/- against Pt '.$getPatientDetails['Patient']['lookup_name'];
			
			$voucherLogDataTds = $jvData = array(
					'date'=>$date,
					'modified_by'=>$session->read('userid'),
					'created_by'=>$session->read('userid'),
					'patient_id'=>$data['Billing']['patient_id'],
					'account_id'=>$TdsId,
					'user_id'=>$userId,
					'type'=>'Tds',
					'narration'=>$narrationTds,
					'debit_amount'=>$tdsAmount);
			if(!empty($jvData['debit_amount']) && ($jvData['debit_amount'] != 0)){
				$lastVoucherIdPaymentTds = $voucherEntryObj->insertJournalEntry($jvData);
				//insert into voucher_logs table added by PankajM
				$voucherLogDataTds['voucher_no']=$lastVoucherIdPaymentTds;
				$voucherLogDataTds['voucher_id']=$lastVoucherIdPaymentTds;
				$voucherLogDataTds['voucher_type']="Journal";
				$voucherLogObj->insertVoucherLog($voucherLogDataTds);
				$voucherLogObj->id= '';
				$voucherEntryObj->id= '';
				// ***insert into Account (By) credit manage current balance
				$accountObj->setBalanceAmountByAccountId($userId,$tdsAmount,'debit');
				$accountObj->setBalanceAmountByUserId($TdsId,$tdsAmount,'credit');
			}
		}
	//EOF for TDS receivable
	}
	
	/**
	 * function to get Receipt Data Group wise in date range for trial balance
	 * @param  int $groupId --> Accounting Group Id
	 * @param  datetime $from --> From Date;
	 * @param  datetime $to --> To Date;
	 * @param  int $location_id --> Account Location id and if location id = All then skip location id
	 * @return debit sum of account_id and credit sum of user_id
	 * @author  Amit Jain
	 */
	public function getReceiptData($fromDate,$toDate,$locationId=null,$groupId=null,$reportType=null){
		$session = new CakeSession();
		$accountObj = ClassRegistry::init('Account');
	
		if($locationId != 'All'){
			$conditions['AccountReceipt.location_id']=$locationId;
		}
		if($groupId != ''){
			$conditions['Account.accounting_group_id']=$groupId;
		}
		$conditions['AccountReceipt.is_deleted']='0';
		$conditions['Account.is_deleted']='0';
		if($reportType==Configure::read('profit_loss_statement') || $reportType==Configure::read('balance_sheet_statement')){ //ProfitLoss condition added by Mahalaxmi
			$fromDate = $fromDate;
		}else{
			$fromDate = '2000-01-01';
		}
		/* $conditions['AccountReceipt.type'] = array('USER','PartialPayment','Advance','PharmacyCharges','DirectPharmacyCharge','FinalPayment',
				'DirectSaleBill','PatientCard','DirectPharmacyCharges','SuspenseAccount','SpotBacking'); */
		//---------------------------Debit AccountReceipt----------------------------//
		$accountObj->bindModel(array(
				'hasOne'=>array(
						'AccountReceipt'=>array('type'=>'inner','foreignKey'=>'account_id')),
		));
		$recDebitArray = $accountObj->find('all',array('fields'=>array('SUM(AccountReceipt.paid_amount) as receiptSumDebit','Account.id','Account.name',
				'Account.accounting_group_id'),
				'conditions'=>array($conditions,'AccountReceipt.date BETWEEN ? AND ?' => array($fromDate,$toDate)),
				'group'=>array('AccountReceipt.account_id'),
				'order'=>'Account.name ASC'));
	
		//---------------------------Credit AccountReceipt----------------------------//
		$accountObj->bindModel(array(
				'hasOne'=>array(
						'AccountReceipt'=>array('type'=>'inner','foreignKey'=>'user_id')),
		));
		$recCreditArray = $accountObj->find('all',array('fields'=>array('SUM(AccountReceipt.paid_amount) as receiptSumCredit','Account.id','Account.name',
				'Account.accounting_group_id'),
				'conditions'=>array($conditions,'AccountReceipt.date BETWEEN ? AND ?' => array($fromDate,$toDate)),
				'group'=>array('AccountReceipt.user_id'),
				'order'=>'Account.name ASC'));
		return array($recDebitArray,$recCreditArray);
	}
}
?>