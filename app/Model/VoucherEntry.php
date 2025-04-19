<?php 
/** Voucher Entry model
*
* PHP 5
*
* @copyright     Copyright 2013 DrM Hope Softwares
* @link          http://www.drmcaduceus.com/
* @package       VoucherEntry.Model
* @since         CakePHP(tm) v 2.0
* @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
* @author        Amit Jain
*/
class VoucherEntry extends AppModel {
	
	public $name = 'VoucherEntry';

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
	* @param array $data array of JV entry
	**/
	public function insertJournalEntry($data=array()){ 
		$session = new CakeSession();
		
		if(empty($data['created_by'])){
			$data['created_by'] = $session->read('userid');
		}
		if(empty($data['date'])){
			$data['date'] = date('Y-m-d H:i:s');
		}
		if(empty($data['create_time'])){			 
			$data['create_time'] = date('Y-m-d H:i:s');
		} 
		if(empty($data['location_id'])){
			$data['location_id'] = $session->read('locationid');
		}
		$this->save($data);
		$this->id="";
		return $this->getLastInsertId();		
	}
	
	public function corporatePatientFinalJv($patientId,$amount){
		$session = new cakeSession();
		$accountObj = ClassRegistry::init('Account');
		$patientObj = ClassRegistry::init('Patient');
		$voucherEntryObj = ClassRegistry::init('VoucherEntry');
		$tariffStandardObj = ClassRegistry::init('TariffStandard');
		$voucherLogObj = ClassRegistry::init('VoucherLog');
		
		$patientDatails = $patientObj->getPatientAllDetails($patientId);
		$accountDetails = $accountObj->getAccountID($patientDatails['Patient']['person_id'],'Patient');//for account id
		$accountId = $accountDetails['Account']['id'];
		$tariffName = $tariffStandardObj->getTariffStandardName($patientDatails['Patient']['tariff_standard_id']);
		$tariffIncomeName = $tariffName."-"."Income";
		$accountObj->id='';
		$incomeId = $accountObj->getUserIdOnly($patientDatails['Patient']['tariff_standard_id'],'CorporateIncome',$tariffIncomeName);
		
		$voucherLogData = $jvData = array('date'=>date('Y-m-d H:i:s'),
				'account_id'=>$accountId,
				'user_id'=>$incomeId,
				'patient_id'=>$patientId,
				'modified_by'=>$session->read('userid'),
				'created_by'=>$session->read('userid'),
				'type'=>'ServiceBill',
				'debit_amount'=>$amount);
		if(!empty($jvData['debit_amount']) && ($jvData['debit_amount'] != 0)){
			$lastJvId = $voucherEntryObj->insertJournalEntry($jvData);
			
			$voucherLogData['type']=FinalDischarge;
			$voucherLogData['account_id']=$incomeId;
			$voucherLogData['user_id']=$accountId;
			$voucherLogData['voucher_id']=$lastJvId;
			$voucherLogData['voucher_no']=$patientDatails['Patient']['admission_id'];
			$voucherLogData['voucher_type']="Journal";
			$voucherLogObj->insertVoucherLog($voucherLogData);
			$voucherLogObj->id ='';
			
			$voucherEntryObj->id ='';
			// ***insert into Account (By) credit manage current balance
			$accountObj->setBalanceAmountByAccountId($incomeId,$amount,'debit');
			$accountObj->setBalanceAmountByUserId($accountId,$amount,'credit');
		}
	}
	
	/**
	 * function to get Journal Data Group wise in date range for trial balance
	 * @param  int $groupId --> Accounting Group Id
	 * @param  datetime $from --> From Date;
	 * @param  datetime $to --> To Date;
	 * @param  int $location_id --> Account Location id and if location id = All then skip location id
	 * @return debit sum of account_id and credit sum of user_id
	 * @author  Amit Jain
	 */
	public function getJournalData($fromDate,$toDate,$locationId=null,$groupId=null,$reportType=null){
		$session = new CakeSession();
		$accountObj = ClassRegistry::init('Account');
	
		if($locationId != 'All'){
			$conditions['VoucherEntry.location_id']=$locationId;
		}
		if($groupId != ''){
			$conditions['Account.accounting_group_id']=$groupId;
		}
		$conditions['VoucherEntry.is_deleted']='0';
		$conditions['Account.is_deleted']='0';
		if($reportType==Configure::read('profit_loss_statement') || $reportType==Configure::read('balance_sheet_statement')){ //ProfitLoss condition added by Mahalaxmi
			$fromDate = $fromDate;
		}else{
			$fromDate = '2000-01-01';
		}
		/* $conditions['VoucherEntry.type'] = array('USER','PurchaseOrder','SurgeryCharges','VisitCharges','CTMRI','Blood','PharmacyCharges','ServiceBill',
				'Consultant','Laboratory','Radiology','Registration','First Consul','Discount','DoctorCharges','NursingCharges','RoomCharges',
				'RefferalDoctor','OTChargesHospital','AnaesthesiaChargesHospital','SurgeryChargesHospital','DirectPharmacyCharges','PharmacyReturnCharges',
				'ExternalRad','ExternalLab','CashierShort','CashierExcess','ExternalConsultant','MLJV','Anaesthesia','Tds','HrPayment'); */
		//---------------------------Debit VoucherEntry----------------------------//
		$accountObj->bindModel(array(
				'hasOne'=>array(
						'VoucherEntry'=>array('type'=>'inner','foreignKey'=>'account_id')),
		));
		$jorDebitArray = $accountObj->find('all',array('fields'=>array('SUM(VoucherEntry.debit_amount) as journalSumDebit','Account.id','Account.name',
				'Account.accounting_group_id'),
				'conditions'=>array($conditions,'VoucherEntry.date BETWEEN ? AND ?' => array($fromDate,$toDate)),
				'group'=>array('VoucherEntry.account_id'),
				'order'=>'Account.name ASC'));
	
		//---------------------------Credit VoucherEntry----------------------------//
		$accountObj->bindModel(array(
				'hasOne'=>array(
						'VoucherEntry'=>array('type'=>'inner','foreignKey'=>'user_id')),
		));
		$jorCreditArray = $accountObj->find('all',array('fields'=>array('SUM(VoucherEntry.debit_amount) as journalSumCredit','Account.id','Account.name',
				'Account.accounting_group_id'),
				'conditions'=>array($conditions,'VoucherEntry.date BETWEEN ? AND ?' => array($fromDate,$toDate)),
				'group'=>array('VoucherEntry.user_id'),
				'order'=>'Account.name ASC'));
	
		return array($jorDebitArray,$jorCreditArray);
	}
	
	/**
	 * function to get Journal Data User wise in date range for consultant outstanding report
	 * @param  int $id --> user id 
	 * @param  datetime $from --> From Date;
	 * @param  datetime $to --> To Date;
	 * @return debit sum of account_id and credit sum of user_id
	 * @author  Amit Jain
	 */
	public function getUserWiseData($fromDate,$toDate,$id=array()){
		$session = new CakeSession();
		//---------------------------Debit VoucherEntry----------------------------//
		$getVoucherDebit = $this->find('all',array('fields'=>array(
				/* 'DATE_FORMAT(VoucherEntry.date, "%m") AS month_reports','DATE_FORMAT(VoucherEntry.date, "%Y") AS year_reports', */
				'VoucherEntry.account_id','SUM(VoucherEntry.debit_amount) as journalSumDebit'),
				'conditions'=>array('VoucherEntry.is_deleted'=>'0','VoucherEntry.account_id'=>array_keys($id),
						'VoucherEntry.date BETWEEN ? AND ?' => array($fromDate,$toDate)),
				'group'=>array('account_id' /*,'year_reports','month_reports' */)));
		
		debug($getVoucherDebit);
		$voucherDebit=array();
		foreach ($getVoucherDebit as $key=>$data){
			$voucherDebit[$data['VoucherEntry']['account_id']][$data['0']['year_reports']][$data['0']['month_reports']]['debit'] += round($data['0']['journalSumDebit']);
		}
		
		//---------------------------Credit VoucherEntry----------------------------//
		$getVoucherCredit = $this->find('all',array('fields'=>array(
				'DATE_FORMAT(VoucherEntry.date, "%m") AS month_reports','DATE_FORMAT(VoucherEntry.date, "%Y") AS year_reports',
				'VoucherEntry.user_id','SUM(VoucherEntry.debit_amount) as journalSumCredit'),
				'conditions'=>array('VoucherEntry.is_deleted'=>'0','VoucherEntry.user_id'=>array_keys($id),
						'VoucherEntry.date BETWEEN ? AND ?' => array($fromDate,$toDate)),
				'group'=>array('user_id','year_reports','month_reports')));
		
		$voucherCredit=array();
		foreach ($getVoucherCredit as $key=>$data){
			$voucherCredit[$data['VoucherEntry']['user_id']][$data['0']['year_reports']][$data['0']['month_reports']]['credit'] += round($data['0']['journalSumCredit']);
		}
		return array('voucherDebit'=>$voucherDebit,'voucherCredit'=>$voucherCredit);
	}
	
	public function getBatchIdentifier($id){
		$session = new CakeSession();
		$getBatchIdentifier = $this->find('first',array('fields'=>array('VoucherEntry.batch_identifier','VoucherEntry.patient_id'),
				'conditions'=>array('VoucherEntry.is_deleted'=>'0','VoucherEntry.location_id'=>$session->read('locationid'),
						'VoucherEntry.id'=>$id)));
		return $getBatchIdentifier;	
	}
	
}
?>