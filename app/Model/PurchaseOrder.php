<?php
App::uses('AppModel', 'Model');

class PurchaseOrder extends AppModel {

	public $hasMany = array('PurchaseOrderItem' => array('className' => 'PurchaseOrderItem'));

	
	public $name = 'PurchaseOrder';
	
  	public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }
    
    /*
    	Generate Purchase Order number
    	By Swapnil G.Sharma
    */
    function GeneratePurchaseOrderId()
    {
	  	$count = $this->find('count');
	  	$count++ ; 
  		$unique_id  = 'PO/';  
  		$unique_id .= date('y')."-"; 				//year
  		$unique_id .= str_pad($count, 4, '0', STR_PAD_LEFT);
  		return strtoupper($unique_id) ; 
    }
    
    public function Insert($data = array()){
    	if(!empty($data)){
	    	$session = new cakeSession();
	    	$data['order_date'] =  DateFormatComponent::formatDate2STD($data['order_date'],Configure::read('date_format'));
	    	$data['create_time'] = date("Y-m-d H:i:s");
	    	$data['modify_time'] = date("Y-m-d H:i:s");
	    	$data['location_id'] = $session->read('locationid');
	    	$data['created_by'] = $session->read('userid');
	    	if($this->save($data)){
	    		return $this->getLastInsertId();
	    	}
    	}else{
    		return false;
    	}
    }
    
    public function UpdateStatus($id,$status){
    	if(!empty($id))	{
	    	$data['id'] = $id;
    		$data['status'] = $status; 
	    	$this->save($data);
    	}
    }
    
    /**
     * function for update Purchase GRN JV by amit jain
     */
    public function editPurchaseJv($requestData = array()){
    	$session = new CakeSession();
    	$accountObj = ClassRegistry::init('Account');
    	$voucherEntryObj = ClassRegistry::init('VoucherEntry');
    	$voucherLogObj = ClassRegistry::init('VoucherLog');
    	$voucherReferenceObj = ClassRegistry::init('VoucherReference');
    	
    	$getLogDetails = $voucherLogObj->find('first',array('fields'=>array('VoucherLog.id','VoucherLog.purchase_value'),
    					'conditions'=>array('VoucherLog.voucher_no'=>$requestData['PurchaseOrder']['id'],'VoucherLog.type'=>"PurchaseOrder",
    							'VoucherLog.is_deleted'=>'0')));
    	if(!empty($getLogDetails)){
	    	$unserData = unserialize($getLogDetails['VoucherLog']['purchase_value']);
			$voucherEntryObj->updateAll(array('VoucherEntry.is_deleted'=>'1'),array('VoucherEntry.batch_identifier'=>$unserData['BatchIdentifier'],'VoucherEntry.type'=>"PurchaseOrder"));
			$voucherEntryObj->id='';
			
			$voucherLogObj->updateAll(array('VoucherLog.is_deleted'=>'1'),array('VoucherLog.id'=>$getLogDetails['VoucherLog']['id']));
			$voucherLogObj->id='';
    	}
		//BOF for tax and vat jv for PO and GRN by amit jain
		$vatFor = 0; $grossFor = 0; $netFor = 0;
		$vatFor5 = 0; $grossFor5 = 0; $netFor5 = 0;
		$vatFor55 = 0; $grossFor55 = 0; $netFor55 = 0;
		$vatFor12 = 0; $grossFor12 = 0; $netFor12 = 0;
		
		foreach($requestData['purchase_order_item'] as $key=>$pItem){
			if($pItem['tax']=='5'){ //for %5 vat
				$vatFor5 += ($pItem['purchase_price']*$pItem['tax'])/100;
				$grossFor5 += $pItem['amount'];
				$netFor5 += $vatFor5 + $grossFor5;
			}else if($pItem['tax']=='5.5'){ //for %5.5 vat
				$vatFor55 += ($pItem['purchase_price']*$pItem['tax'])/100;
				$grossFor55 += $pItem['amount'];
				$netFor55 += $vatFor55 + $grossFor55;
			}else if($pItem['tax']=='12.5'){//for 12.5%
				$vatFor12 += ($pItem['purchase_price']*$pItem['tax'])/100;
				$grossFor12 += $pItem['amount'];
				$netFor12 += $vatFor12 + $grossFor12;
			}else{//else vat
				$vatFor += ($pItem['purchase_price']*$pItem['tax'])/100;
				$grossFor += $pItem['amount'];
				$netFor += $vatFor + $grossFor;
			}
		}
		
		$totalAmount = round($grossFor + $grossFor5 + $grossFor55 + $grossFor12 + $vatFor5 + $vatFor12 + $vatFor55);
	
		$medicinesSurgicalPurchase = (Configure::read('medicinesSurgicalPurchaseLabel'));
		$vatLabel = (Configure::read('inputVATLabel'));
		$batchIdentifier = strtotime("now") ;
		$doneDate  =  DateFormatComponent::formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'),true);
		$narration = 'Being surgical items purchased from '.$requestData['PurchaseOrder']['supplier_name'].' as per invoice no. '.$requestData['PurchaseOrder']['party_invoice_number']." ".'done on '.$doneDate;
		//non vat
		$accountObj->id = '';
		$userId = $accountObj->getUserIdOnly($requestData['PurchaseOrder']['supplier_id'],'InventorySupplier',$requestData['PurchaseOrder']['supplier_name']);
		if($grossFor > 0){
			$supplierId = $accountObj->getAccountIdOnly($medicinesSurgicalPurchase[0]);
			$jvData = array(
					'date'=>date('Y-m-d H:i:s'),
					'account_id'=>$supplierId,
					'user_id'=>$userId,
					'type'=>'PurchaseOrder',
					'batch_identifier'=>$batchIdentifier,
					'narration'=>$narration,
					'debit_amount'=>$grossFor,
					'create_time'=>date('Y-m-d H:i:s'));
			$voucherEntryObj->insertJournalEntry($jvData);
			$accountObj->setBalanceAmountByAccountId($supplierId,$grossFor,'debit');
			$voucherEntryObj->id= '';
			$accountObj->id = '';
		}
			
		//for med 5%
		if($grossFor5 > 0 ){
			$supplierId = $accountObj->getAccountIdOnly($medicinesSurgicalPurchase[1]);
			$jvData = array(
					'date'=>date('Y-m-d H:i:s', strtotime("now +1 sec")),
					'account_id'=>$supplierId,
					'user_id'=>$userId,
					'type'=>'PurchaseOrder',
					'batch_identifier'=>$batchIdentifier,
					'narration'=>$narration,
					'debit_amount'=>$grossFor5,
					'create_time'=>date('Y-m-d H:i:s', strtotime("now +1 sec")));
			$voucherEntryObj->insertJournalEntry($jvData);
			$accountObj->setBalanceAmountByAccountId($supplierId,$grossFor5,'debit');
			$voucherEntryObj->id= '';
			$accountObj->id = '';
		}
			
		//for med 5.5%
		if($grossFor55 > 0 ){
			$supplierId = $accountObj->getAccountIdOnly($medicinesSurgicalPurchase[6]);
			$jvData = array(
					'date'=>date('Y-m-d H:i:s', strtotime("now +1 sec")),
					'account_id'=>$supplierId,
					'user_id'=>$userId,
					'type'=>'PurchaseOrder',
					'batch_identifier'=>$batchIdentifier,
					'narration'=>$narration,
					'debit_amount'=>$grossFor55,
					'create_time'=>date('Y-m-d H:i:s', strtotime("now +1 sec")));
			$voucherEntryObj->insertJournalEntry($jvData);
			$accountObj->setBalanceAmountByAccountId($supplierId,$grossFor55,'debit');
			$voucherEntryObj->id= '';
			$accountObj->id = '';
		}
			
		//for vat 5%
		if($vatFor5 > 0){
			$supplierId = $accountObj->getAccountIdOnly($vatLabel[0]);
			$jvData = array(
					'date'=>date('Y-m-d H:i:s', strtotime("now +2 sec")),
					'account_id'=>$supplierId,
					'user_id'=>$userId,
					'type'=>'PurchaseOrder',
					'batch_identifier'=>$batchIdentifier,
					'narration'=>$narration,
					'debit_amount'=>$vatFor5,
					'create_time'=>date('Y-m-d H:i:s', strtotime("now +2 sec")));
			$voucherEntryObj->insertJournalEntry($jvData);
			$accountObj->setBalanceAmountByAccountId($supplierId,$vatFor5,'debit');
			$voucherEntryObj->id= '';
			$accountObj->id = '';
		}
			
		//for vat 5%
		if($vatFor55 > 0){
			$supplierId = $accountObj->getAccountIdOnly($vatLabel[4]);
			$jvData = array(
					'date'=>date('Y-m-d H:i:s', strtotime("now +2 sec")),
					'account_id'=>$supplierId,
					'user_id'=>$userId,
					'type'=>'PurchaseOrder',
					'batch_identifier'=>$batchIdentifier,
					'narration'=>$narration,
					'debit_amount'=>$vatFor55,
					'create_time'=>date('Y-m-d H:i:s', strtotime("now +2 sec")));
			$voucherEntryObj->insertJournalEntry($jvData);
			$accountObj->setBalanceAmountByAccountId($supplierId,$vatFor55,'debit');
			$voucherEntryObj->id= '';
			$accountObj->id = '';
		}
		
		//for med 12.5%
		if($grossFor12 > 0){
			$supplierId = $accountObj->getAccountIdOnly($medicinesSurgicalPurchase[2]);
			$jvData = array(
					'date'=>date('Y-m-d H:i:s', strtotime("now +3 sec")),
					'account_id'=>$supplierId,
					'user_id'=>$userId,
					'type'=>'PurchaseOrder',
					'batch_identifier'=>$batchIdentifier,
					'narration'=>$narration,
					'debit_amount'=>$grossFor12,
					'create_time'=>date('Y-m-d H:i:s', strtotime("now +3 sec")));
			$voucherEntryObj->insertJournalEntry($jvData);
			$accountObj->setBalanceAmountByAccountId($supplierId,$grossFor12,'debit');
			$voucherEntryObj->id= '';
			$accountObj->id = '';
		}
																	
		//for vat 12.5%
		if($vatFor12 > 0){
			$supplierId = $accountObj->getAccountIdOnly($vatLabel[1]);
			$jvData = array(
					'date'=>date('Y-m-d H:i:s', strtotime("now +4 sec")),
					'account_id'=>$supplierId,
					'user_id'=>$userId,
					'type'=>'PurchaseOrder',
					'batch_identifier'=>$batchIdentifier,
					'narration'=>$narration,
					'debit_amount'=>$vatFor12,
					'create_time'=>date('Y-m-d H:i:s', strtotime("now +4 sec")));
			$voucherEntryObj->insertJournalEntry($jvData);
			$accountObj->setBalanceAmountByAccountId($supplierId,$vatFor12,'debit');
			$voucherEntryObj->id= '';
			$accountObj->id = '';
		}
		$serializeArray = array(
				'0%tax'=>$grossFor,
				'5%tax'=>round($vatFor5),
				'5%amount'=>$grossFor5,
				'14%tax'=>round($vatFor12),
				'14%amount'=>$grossFor12,
				'BatchIdentifier'=>$batchIdentifier,
				'InvoiceNo'=>$requestData['PurchaseOrder']['party_invoice_number']);
			//BOF voucher Log entry for purchase voucher entry
		if(!empty($totalAmount)){
			$voucherLogData = array(
					'date'=>date('Y-m-d H:i:s'),
					'created_by'=>$session->read('userid'),
					'account_id'=>$supplierId,
					'user_id'=>$userId,
					'type'=>'PurchaseOrder',
					'narration'=>$narration,
					'purchase_value'=>serialize($serializeArray),
					'debit_amount'=>$totalAmount);
			$voucherLogData['voucher_no']=$requestData['PurchaseOrder']['id'];
			$voucherLogData['voucher_type']="Purchase";
			$voucherLogObj->insertVoucherLog($voucherLogData);
			$accountObj->setBalanceAmountByUserId($userId,$totalAmount,'credit');
			$voucherLogObj->id='';
		}
	//supplier
		if(!empty($requestData['net_amount']) && $requestData['net_amount'] !='0'){
			$vrData = array(
					'reference_type_id'=> '2',
					'voucher_id'=> $voucherEntryObj->getLastInsertID(),
					'voucher_type'=> 'journal',
					'location_id'=> $session->read('locationid'),
					'user_id'=> $userId,
					'date' => date('Y-m-d H:i:s'),
					'amount'=>$requestData['net_amount'],
					'credit_period'=>'45',
					'payment_type'=>'Cr',
					'reference_no'=>$requestData['PurchaseOrder']['party_invoice_number'],
					'parent_id' => '0');
			$voucherReferenceObj->save($vrData);
			$voucherReferenceObj->id= '';	
		}
	//EOF supplier
    }   
}
?>