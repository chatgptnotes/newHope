<?php
/**
 * HomeController file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Home Controller
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 */

class LandingsController extends AppController {
	 
	public $name = 'Landings';
	public $uses = array() ;
	public $helpers = array('Html','Form', 'Js','DateFormat','RupeesToWords','Number','General','JsFusionChart');
	public $components = array('RequestHandler','Email','General','Number');
	
	
	//landing page for each role 
	function index($date=null){
		$this->uses = array('User','DoctorProfile','CeoMessage','VoucherEntry','AccountReceipt','VoucherPayment','Account','ContraEntry','Patient'); 
		$this->layout ='advance' ;
		
		
		//BOF license's expiration check
		$rolename = $this->Session->read('role');
		$this->set("rolename",$rolename);
		
		if(Configure::read('external_radiologist')==strtolower($rolename)){
			$this->redirect("/PatientDocuments/radiologistDashboard");
		}
		$today=$this->CeoMessage->find('all',array(
			'fields'=>array('CeoMessage.id','CeoMessage.message','CeoMessage.created_time','CeoMessage.msg_date'),
			'conditions'=>array('CeoMessage.msg_date' =>date('Y-m-d'))));		
		$this->set('today',$today); 
		
		//for only management role
		if($rolename=="Management")
		{
		
		if(!empty($this->params->query)){
			$this->request->data['VoucherEntry']=$this->params->query;
		}
	
		$locationId = $this->Session->read('locationid');
		//if($Reporttype == 'TrialBalance' || $Reporttype == Configure::read('profit_loss_statement')) not required here
		//{ //BOF-profitLossStatement condition added by Mahalaxmi
		
			$isHide = $this->request->data['VoucherEntry']['isHide'];
			$click=1;
			if(!empty($this->request->data['Patient']['admission_id'])){
				$this->Patient->bindModel(array(
					"hasOne"=>array(
							"Account"=>array("foreignKey"=>false ,'conditions'=>array('Account.system_user_id=Patient.person_id','Account.user_type'=>"Patient")),
				))) ;
				$patientData = $this->Patient->find('first',array('fields'=>array('Account.id','Patient.id','Patient.person_id'),
						'conditions'=>array('admission_id'=>$this->request->data['Patient']['admission_id'])));
				$userid = $patientData['Account']['id'];
				
				$Pconditions['Patient.id'] = $Econditions['Patient.id'] = $Rconditions['Patient.id'] = $patientData['Patient']['id'];
			}else{
				$userid=$this->request->data['VoucherEntry']['user_id'];
			}

			$locationId = $this->request->data['VoucherEntry']['location_id'];
			
			$amount=$this->request->data['VoucherEntry']['amount'];
			if(!empty($this->request->data['VoucherEntry']['amount'])){
				$Econditions['VoucherEntry.debit_amount']=$amount;
				$Pconditions['VoucherPayment.paid_amount']=$amount;
				$Rconditions['AccountReceipt.paid_amount']=$amount;
				$Cconditions['ContraEntry.debit_amount']=$amount;
			}
			
			$narration=$this->request->data['VoucherEntry']['narration'];
			if(!empty($this->request->data['VoucherEntry']['narration'])){
				$Econditions['VoucherEntry.narration LIKE']='%'.$narration.'%';
				$Pconditions['VoucherPayment.narration LIKE']='%'.$narration.'%';
				$Rconditions['AccountReceipt.narration LIKE']='%'.$narration.'%';
				$Cconditions['ContraEntry.narration LIKE']='%'.$narration.'%';
			}
			$this->request->data['VoucherEntry']['from']=date('d/m/Y');
			if(!empty($this->request->data['VoucherEntry']['from'])){ 			
				$fromDate = $this->DateFormat->formatDate2STDForReport($this->request->data['VoucherEntry']['from'],Configure::read('date_format'))." 00:00:00";
				$Econditions['VoucherEntry.date >=']=$fromDate;
				$Pconditions['VoucherPayment.date >=']=$fromDate;
				$Rconditions['AccountReceipt.date >=']=$fromDate;
				$Cconditions['ContraEntry.date >=']=$fromDate;
				$from=$this->request->data['VoucherEntry']['from'];
			}else{
				if($Reporttype == 'TrialBalance' || $Reporttype == Configure::read('profit_loss_statement')){ //BOF-profitLossStatement condition added by Mahalaxmi
					$userid = $ledgerId;
					$locationId = $locId;					
					$dateFrom = str_replace(',', '/', $trialFrom);					
					$fromDate = $this->DateFormat->formatDate2STDForReport($dateFrom,Configure::read('date_format'))." 00:00:00";
					$from = $dateFrom;					
				}else{
					$fromDate = date('Y-m-d').' 00:00:00';
					$from=date('d/m/Y');
				}
				$Econditions['VoucherEntry.date >=']=$fromDate;
				$Pconditions['VoucherPayment.date >=']=$fromDate;
				$Rconditions['AccountReceipt.date >=']=$fromDate;
				$Cconditions['ContraEntry.date >=']=$fromDate;
			}
			if(!empty($this->request->data['VoucherEntry']['to'])){ 		
				$toDate = $this->DateFormat->formatDate2STDForReport($this->request->data['VoucherEntry']['to'],Configure::read('date_format'))." 23:59:59";
				$Econditions['VoucherEntry.date <=']=$toDate;
				$Pconditions['VoucherPayment.date <=']=$toDate;
				$Rconditions['AccountReceipt.date <=']=$toDate;
				$Cconditions['ContraEntry.date <=']=$toDate;
				$to=$this->request->data['VoucherEntry']['to'];
			}else{
				if($Reporttype == 'TrialBalance' || $Reporttype == Configure::read('profit_loss_statement')){ //BOF-profitLossStatement condition added by Mahalaxmi
					$dateTrialTo = str_replace(',', '/', $trialTo);
					$dateTo = $this->DateFormat->formatDate2STDForReport($dateTrialTo,Configure::read('date_format'))." 23:59:59";
					$to = $dateTrialTo;
				}else{
					$dateTo = date('Y-m-d H:i:s');
					$to = date('d/m/Y');
				}
				$Econditions['VoucherEntry.date <=']=$dateTo;
				$Pconditions['VoucherPayment.date <=']=$dateTo;
				$Rconditions['AccountReceipt.date <=']=$dateTo;
				$Cconditions['ContraEntry.date <=']=$dateTo;
			}
			$Econditions['VoucherEntry.is_deleted']='0';
			$Pconditions['VoucherPayment.is_deleted']='0';
			$Rconditions['AccountReceipt.is_deleted']='0';
			$Cconditions['ContraEntry.is_deleted']='0';
			
			$Econditions['VoucherEntry.location_id']=$this->Session->read('locationid');
			$Pconditions['VoucherPayment.location_id']=$this->Session->read('locationid');
			$Rconditions['AccountReceipt.location_id']=$this->Session->read('locationid');
			$Cconditions['ContraEntry.location_id']=$this->Session->read('locationid');
			//RefferalCharges
			$cashIds = $this->Account->getGroupByAccountList(Configure::read('cash'));
			$this->Account->id='';
			
			$userid="562";
			if(array_key_exists($userid, $cashIds)){
				$Pconditions['VoucherPayment.type NOT'] = 'RefferalCharges';
				$paymentCon['VoucherPayment.type NOT'] = 'RefferalCharges';
			}
			$Econditions['VoucherEntry.type !='] = 'AnaesthesiaCharges';
			
			$Econditions['VoucherEntry.type'] = array('USER','PurchaseOrder','SurgeryCharges','VisitCharges','CTMRI','Blood','PharmacyCharges','ServiceBill',
					'Consultant','Laboratory','Radiology','Registration','First Consul','Discount','DoctorCharges','NursingCharges','RoomCharges',
					'RefferalDoctor','OTChargesHospital','AnaesthesiaChargesHospital','SurgeryChargesHospital','DirectPharmacyCharges','PharmacyReturnCharges',
					'ExternalRad','ExternalLab','CashierShort','CashierExcess','ExternalConsultant','MLJV','Anaesthesia','Tds','HrPayment');
					
			$Rconditions['AccountReceipt.type'] = array('USER','PartialPayment','Advance','PharmacyCharges','DirectPharmacyCharge','FinalPayment',
					'DirectSaleBill','PatientCard','DirectPharmacyCharges','SuspenseAccount','SpotBacking');
			$Econditions['OR']=array('VoucherEntry.user_id'=>$userid,'VoucherEntry.account_id'=>$userid);
			$Pconditions['OR']=array('VoucherPayment.user_id'=>$userid,'VoucherPayment.account_id'=>$userid);
			$Rconditions['OR']=array('AccountReceipt.user_id'=>$userid,'AccountReceipt.account_id'=>$userid);
			$Cconditions['OR']=array('ContraEntry.user_id'=>$userid,'ContraEntry.account_id'=>$userid);
	
			//for Journal Entries Account type
			$this->VoucherEntry->bindModel(array(
					"belongsTo"=>array(
							"Account"=>array("foreignKey"=>false ,'conditions'=>array('OR'=>array('Account.id=VoucherEntry.user_id'))),
							"AccountAlias"=>array('className'=>'Account',"foreignKey"=>false ,'conditions'=>array('AccountAlias.id=VoucherEntry.account_id')),
					))) ;
			$getAccountType=$this->Account->find('first',array('fields'=>array('Account.user_type'),
						'conditions'=>array('Account.location_id'=>$this->Session->read('locationid'),'Account.is_deleted'=>'0','Account.id'=>$userid)));
			
			if($getAccountType['Account']['user_type'] == 'InventorySupplier'){
				$JournalEntry=$this->VoucherEntry->find('all',array('fields'=>array('Account.name','Account.balance','VoucherEntry.user_id'
					,'VoucherEntry.account_id','VoucherEntry.narration','VoucherEntry.id','SUM(VoucherEntry.debit_amount) as total','VoucherEntry.date','VoucherEntry.type','VoucherEntry.batch_identifier',
					'VoucherEntry.patient_id','AccountAlias.name','Account.opening_balance'),
					'conditions'=>$Econditions,'group'=>array('VoucherEntry.batch_identifier')));
			}elseif($getAccountType['Account']['user_type'] == 'Patient'){
				$jvEntry=$this->VoucherEntry->find('all',array('fields'=>array('Account.name','Account.balance',
						'VoucherEntry.user_id','VoucherEntry.account_id','VoucherEntry.narration','VoucherEntry.id','VoucherEntry.debit_amount','VoucherEntry.date','VoucherEntry.type',
						'VoucherEntry.batch_identifier','VoucherEntry.patient_id','AccountAlias.name','Account.opening_balance'),
						'conditions'=>$Econditions));
	
				if(count($jvEntry)){
					foreach ($jvEntry as $key=> $data){
						if($data['VoucherEntry']['type'] == 'Discount'){
							$DiscountEntry[$key] = $data;
						}elseif($data['VoucherEntry']['type'] == 'Tds'){
							$tdsEntry[$key] = $data;
						}else{
							$debitAmount[$data['VoucherEntry']['patient_id']]['debit_amount'] = $debitAmount[$data['VoucherEntry']['patient_id']]['debit_amount'] + $data['VoucherEntry']['debit_amount'];
							$JournalEntry[$data['VoucherEntry']['patient_id']] = $data;
							$JournalEntry[$data['VoucherEntry']['patient_id']]['VoucherEntry']['debit_amount'] = $debitAmount[$data['VoucherEntry']['patient_id']]['debit_amount'];
						}
					}
				}
			}else{
 				$otherEntry=$this->VoucherEntry->find('all',array('fields'=>array('Account.name','Account.balance',
					'VoucherEntry.user_id','VoucherEntry.account_id','VoucherEntry.narration','VoucherEntry.id','VoucherEntry.debit_amount','VoucherEntry.date','VoucherEntry.type',
 					'VoucherEntry.batch_identifier','VoucherEntry.patient_id','AccountAlias.name','Account.opening_balance'),
					'conditions'=>array($Econditions)));
			}

			foreach ($otherEntry as $key=> $dataCust){
				if($dataCust['VoucherEntry']['batch_identifier'] != null){
					$debitAmount[$dataCust['VoucherEntry']['batch_identifier']]['debit_amount'] = $debitAmount[$dataCust['VoucherEntry']['batch_identifier']]['debit_amount'] + $dataCust['VoucherEntry']['debit_amount'];
					$JournalEntry[$dataCust['VoucherEntry']['batch_identifier']] = $dataCust;
					$JournalEntry[$dataCust['VoucherEntry']['batch_identifier']]['VoucherEntry']['debit_amount'] = $debitAmount[$dataCust['VoucherEntry']['batch_identifier']]['debit_amount'];
				}else{
					$JournalEntry = $otherEntry;
				}
			}
			//For Payment Enteries Account type
			$this->VoucherPayment->bindModel(array(
					"belongsTo"=>array(
							"Account"=>array("foreignKey"=>false ,'conditions'=>array('Account.id=VoucherPayment.user_id')),
							"AccountAlias"=>array('className'=>'Account',"foreignKey"=>false ,'conditions'=>array('AccountAlias.id=VoucherPayment.account_id')),
							))) ;
			$PaymentEntry=$this->VoucherPayment->find('all',array('fields'=>array('Account.name','Account.alias_name','Account.system_user_id',
					'Account.user_type','AccountAlias.alias_name','Account.balance','AccountAlias.name','VoucherPayment.date',
					'VoucherPayment.user_id','VoucherPayment.narration','VoucherPayment.account_id','VoucherPayment.id','VoucherPayment.paid_amount',
					'VoucherPayment.type'),
					'conditions'=>$Pconditions));
			
			//for Reciept Entries Account type
			$this->AccountReceipt->bindModel(array(
					"belongsTo"=>array(
							"Account"=>array("foreignKey"=>false ,'conditions'=>array('Account.id=AccountReceipt.user_id')),
							"AccountAlias"=>array('className'=>'Account',"foreignKey"=>false ,
									'conditions'=>array('AccountAlias.id=AccountReceipt.account_id')),
					))) ;
			$RecieptEntry=$this->AccountReceipt->find('all',array('fields'=>array('Account.name','Account.balance','AccountAlias.name','AccountReceipt.date',
					'AccountReceipt.user_id','AccountReceipt.narration','AccountReceipt.account_id','AccountReceipt.id','AccountReceipt.paid_amount'),
					'conditions'=>$Rconditions));
			
			//for Contra Entries Account type
			$this->ContraEntry->bindModel(array(
					"belongsTo"=>array(
							"Account"=>array("foreignKey"=>false ,'conditions'=>array('Account.id=ContraEntry.user_id')),
							"AccountAlias"=>array('className'=>'Account',"foreignKey"=>false ,
									'conditions'=>array('AccountAlias.id=ContraEntry.account_id')),
					))) ;
			$ContraEntry=$this->ContraEntry->find('all',array('fields'=>array('Account.name','Account.balance','AccountAlias.name','ContraEntry.date',
					'ContraEntry.user_id','ContraEntry.narration','ContraEntry.account_id','ContraEntry.id','ContraEntry.debit_amount'),
					'conditions'=>$Cconditions));

			// for calculation of opening amount
			$sequenceDate=$this->DateFormat->formatDate2STD($from,Configure::read('date_format'));
			$sequenceDate=explode(' ',$sequenceDate);
			$sequenceDate=$sequenceDate[0].' 00:00:00';
			$paymentDebit=$this->VoucherPayment->find('first',array('fields'=>array('SUM(VoucherPayment.paid_amount) as debit'),
					'conditions'=>array('VoucherPayment.date <'=>$sequenceDate,'VoucherPayment.user_id'=>$userid,'VoucherPayment.is_deleted'=>0,
							'VoucherPayment.location_id'=>$this->Session->read('locationid'))));
			$paymentCredit=$this->VoucherPayment->find('first',array('fields'=>array('SUM(VoucherPayment.paid_amount) as credit'),
					'conditions'=>array('VoucherPayment.date <'=>$sequenceDate,'VoucherPayment.account_id'=>$userid,'VoucherPayment.is_deleted'=>0,
							'VoucherPayment.location_id'=>$this->Session->read('locationid'),$paymentCon)));
			
			$journalCredit=$this->VoucherEntry->find('first',array('fields'=>array('SUM(VoucherEntry.debit_amount) as credit'),
					'conditions'=>array('VoucherEntry.date <'=>$sequenceDate,'VoucherEntry.user_id'=>$userid,'VoucherEntry.is_deleted'=>0,'VoucherEntry.location_id'=>$this->Session->read('locationid'))));
			$journalDebit=$this->VoucherEntry->find('first',array('fields'=>array('SUM(VoucherEntry.debit_amount) as debit'),
					'conditions'=>array('VoucherEntry.date <'=>$sequenceDate,'VoucherEntry.account_id'=>$userid,'VoucherEntry.is_deleted'=>0,'VoucherEntry.location_id'=>$this->Session->read('locationid'))));
			
			$recieptDebit=$this->AccountReceipt->find('first',array('fields'=>array('SUM(AccountReceipt.paid_amount) as debit'),
					'conditions'=>array('AccountReceipt.date <'=>$sequenceDate,'AccountReceipt.account_id'=>$userid,'AccountReceipt.is_deleted'=>0,'AccountReceipt.location_id'=>$this->Session->read('locationid'))));
			$recieptCredit=$this->AccountReceipt->find('first',array('fields'=>array('SUM(AccountReceipt.paid_amount) as credit'),
					'conditions'=>array('AccountReceipt.date <'=>$sequenceDate,'AccountReceipt.user_id'=>$userid,'AccountReceipt.is_deleted'=>0,'AccountReceipt.location_id'=>$this->Session->read('locationid'))));
			
			$contraDebit=$this->ContraEntry->find('first',array('fields'=>array('SUM(ContraEntry.debit_amount) as debit'),
					'conditions'=>array('ContraEntry.date <'=>$sequenceDate,'ContraEntry.account_id'=>$userid,'ContraEntry.is_deleted'=>0,'ContraEntry.location_id'=>$this->Session->read('locationid'))));
			$contraCredit=$this->ContraEntry->find('first',array('fields'=>array('SUM(ContraEntry.debit_amount) as credit'),
					'conditions'=>array('ContraEntry.date <'=>$sequenceDate,'ContraEntry.user_id'=>$userid,'ContraEntry.is_deleted'=>0,'ContraEntry.location_id'=>$this->Session->read('locationid'))));
		//	}
			
			$ledger = array();
			$payment = array();
			$reciept = array();
			$contra = array();
			$discount = array();
			$tds = array();
			
			// setting array for sequencing of journal entry, payment entry and reciept entry
			$i=0;
			foreach($tdsEntry as $tdsEntry){
				$date=$this->DateFormat->formatDate2Local($tdsEntry['VoucherEntry']['date'],Configure::read('date_format'),false);
				$tds[$i][strtotime($tdsEntry['VoucherEntry']['date'])]=$tdsEntry;
				$i++;
			}
			$i=0;
			foreach($DiscountEntry as $DiscountEntry){
				$date=$this->DateFormat->formatDate2Local($DiscountEntry['VoucherEntry']['date'],Configure::read('date_format'),false);
				$discount[$i][strtotime($DiscountEntry['VoucherEntry']['date'])]=$DiscountEntry;
				$i++;
			}
			$i=0;
			foreach($JournalEntry as $JournalEntry){				 
				$date=$this->DateFormat->formatDate2Local($JournalEntry['VoucherEntry']['date'],Configure::read('date_format'),false);
				$ledger[$i][strtotime($JournalEntry['VoucherEntry']['date'])]=$JournalEntry;
				$i++;		
			}
			$i=0;
			foreach($PaymentEntry as $PaymentEntry){
				$date=$this->DateFormat->formatDate2Local($PaymentEntry['VoucherPayment']['date'],Configure::read('date_format'),false);
				$payment[$i][strtotime($PaymentEntry['VoucherPayment']['date'])]=$PaymentEntry;
				$i++;				
			}
			$i=0;
			foreach($RecieptEntry as $RecieptEntry){
				$date=$this->DateFormat->formatDate2Local($RecieptEntry['AccountReceipt']['date'],Configure::read('date_format'),false);
				$reciept[$i][strtotime($RecieptEntry['AccountReceipt']['date'])]=$RecieptEntry;
				$i++;
			}
			$i=0;
			foreach($ContraEntry as $ContraEntry){
				$date=$this->DateFormat->formatDate2Local($ContraEntry['ContraEntry']['date'],Configure::read('date_format'),false);
				$contra[$i][strtotime($ContraEntry['ContraEntry']['date'])]=$ContraEntry;
				$i++;
			}
			
			$combineArray =array_merge($ledger,$reciept,$payment,$contra,$discount,$tds);
			//to add sort order by date - amit J #0038
			foreach($combineArray as $combKey=>$combValue){
					$refineCombineArray[key($combValue)][]  = $combValue[key($combValue)] ;   
			}
			//EOF sort order 
			
			// For setting the name of user
			
			$userName=$this->Account->find('first',array('fields'=>array('Account.name','Account.opening_balance','Account.payment_type','Account.user_type'),
					'conditions'=>array('Account.id'=>$userid,'Account.location_id'=>$this->Session->read('locationid'),'Account.is_deleted'=>0)));
			
			//Setting the Opening balance
			if(empty($paymentDebit[0]['debit'])&& empty($paymentCredit[0]['credit'])&& empty($journalCredit[0]['credit'])&& 
					empty($journalDebit[0]['debit']) && empty($recieptCredit[0]['credit'])&& empty($recieptDebit[0]['debit'])&& 
					empty($contraCredit[0]['credit'])&& empty($contraDebit[0]['debit'])){
				if($userName['Account']['payment_type']=='Dr'){
					$type='Dr';
					$opening = $userName['Account']['opening_balance'];
				}else{
					$type='Cr';
					$opening = $userName['Account']['opening_balance'];
				}
			}else{ //Dr
				if($userName['Account']['payment_type']=='Dr'){
					$openingBalanceDebit = $userName['Account']['opening_balance'];
				}else{
					$openingBalanceCredit = $userName['Account']['opening_balance'];
				}
				$opening=($openingBalanceDebit + $paymentDebit[0]['debit']+ $journalDebit[0]['debit']+ $recieptDebit[0]['debit']+ 
						$contraDebit[0]['debit'])-($journalCredit[0]['credit']+$paymentCredit[0]['credit']+$recieptCredit[0]['credit']+
								$contraCredit[0]['credit']+$openingBalanceCredit);
				if($opening<0){
					$type='Cr';
					$opening=-($opening);
				}
				else{
					$type='Dr';
					$opening=$opening;
				}
			}
			
			if(empty($from)){
				$from = $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'));
			}
			if(empty($to)){
				$to = $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'));
			}
			
		
			$userType = $userName['Account']['user_type'];
			$this->set('currency',$this->Session->read('Currency.currency_symbol'));
			$this->set(compact('userName','payable','from','to','opening','type','click','userid','narration','amount','userType','isHide'));
			$this->set('ledger',$refineCombineArray);
			
		
		}
		
		
		//comented by pooja as there is no need to have license check in indian version
		/*if((strtolower($rolename) == strtolower(Configure::read('doctorLabel')))){
			$expirationdate=$this->User->find('first', array('fields'=> array('id','licensure_type', 'expiration_date') ,
					'conditions' => array('User.id'=> $this->Session->read('userid'))));
			if($expirationdate['User']['expiration_date'] >= date('Y-m-d H:i:s')){
				$diff=$this->DateFormat->dateDiff(date('Y-m-d H:i:s'),$expirationdate['User']['expiration_date']);
				$dateDiff=$diff->days+1;
				$expDate=$expirationdate['User']['expiration_date'];
				//	$this->set(compact('dateDiff','expDate'));
				$this->set('Diff',$dateDiff);
				$this->set('expDate',$expDate);
			}else{
				$this->redirect('/Users/logout/expired');
			}		
		}*/
  
		//EOF 
		/*$hasPermissions = $this->Session->read('hasPermissions'); 
		if(!empty($hasPermissions)){
			$this->layout = 'default' ; 
			$this->Render('loadPermissions'); 
		} */
 
		 
	}
	
	//BOF pankaj
	function loadPermissions(){
		$this->layout = 'landing' ; 
		$this->uses = array('User','DoctorProfile');
		//for expiration msg
		//BOF license's expiration check
		$rolename = $this->Session->read('role'); 
		if((strtolower($rolename) == strtolower(Configure::read('doctorLabel')))){
			$expirationdate=$this->User->find('first', array('fields'=> array('id','licensure_type', 'expiration_date') ,
					'conditions' => array('User.id'=> $this->Session->read('userid'))));
			if($expirationdate['User']['expiration_date'] >= date('Y-m-d H:i:s')){
				$diff=$this->DateFormat->dateDiff(date('Y-m-d H:i:s'),$expirationdate['User']['expiration_date']);
				$dateDiff=$diff->days+1;
				$expDate=$expirationdate['User']['expiration_date'];
				//	$this->set(compact('dateDiff','expDate'));
				$this->set('Diff',$dateDiff);
				$this->set('expDate',$expDate);
			}else{
				$this->redirect('/Users/logout/expired');
			}
		}
		//EOF
	}
	//EOF pankaj
	 
	 public function patient_overview(){
	 	    	// $this->uses = array('User','DoctorProfile','CeoMessage','VoucherEntry','AccountReceipt','VoucherPayment','Account','ContraEntry','Patient'); 
		$this->layout ='false' ;
	 	}
}
?>