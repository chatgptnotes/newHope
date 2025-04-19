<?php
/**
 * This is HR controller file.
 *
 * Use to
 * created : 24 Jan 15
 */
class HRController extends AppController {

	public $name = 'HR';
	public $uses = array('State');
	public $helpers = array('Html','Form', 'Js','DateFormat','RupeesToWords','Number','General','JsFusionChart','PhpExcel');
	public $components = array('RequestHandler','Email','ImageUpload','DateFormat','GibberishAES','PhpExcel');
	public $nodeArry=array();
	public	$nodeArryCnt=0;
	
	public function index(){
		$this->set('title_for_layout',__(' : HR Dashboard'));
		$this->layout = "advance";
	}

	public function send_leave_request(){


	}

	public function leave_dashboard(){


	}

	public function leave_dashboard_list(){


	}

	public function leave_master(){
		$this->layout = 'advance';

		$this->uses=array('LeaveType');
		$this->set('title_for_layout', __('Leave Master', true));
		if(isset($this->request->data) && $this->request->data['LeaveType']['hiddenId']!=''){
			$conditions['LeaveType']['id'] = $this->request->data['LeaveType']['hiddenId'];
		}
		$conditions['LeaveType']['is_deleted'] = '0';
		$conditions = $this->postConditions($conditions);

		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'fields'=>array('LeaveType.*'),	'conditions' =>  $conditions);
		$data = $this->paginate('LeaveType');
		$this->set('data', $data);

	}

	public function add_leave_type(){
		//$this->layout = 'advance';
		$this->set('title_for_layout', __('Add Leave Type', true));
		$this->uses=array('LeaveType');
		//pr($this->request->data);exit;
		if(isset($this->request->data) && !empty($this->request->data)){

			$this->request->data['LeaveType']['location_id']=$this->Session->read('locationid');
			$this->request->data['LeaveType']['created_by']=$this->Session->read('userid');
			$this->request->data['LeaveType']['create_time']=date("Y-m-d H:i:s");
			if($this->LeaveType->save($this->request->data['LeaveType']))
			{
				$this->Session->setFlash(__($this->request->data['LeaveType']['name'].' has been saved successfully', true));
				$this->redirect(array('action'=>'leave_master'));
			}
			else
			{
				$this->Session->setFlash(__('Could not add', false));
			}
		}


	}

	public function edit_leave_type($id = null){

		//$this->layout = 'advance';
		$this->set('title_for_layout', __('Edit Leave Type', true));
		$this->uses=array('LeaveType');
		$this->LeaveType->id = $id;

		if(isset($this->request->data) && !empty($this->request->data)){
			$this->request->data['LeaveType']['modified_by']=$this->Session->read('userid');
			$this->request->data['LeaveType']['modify_time']=date("Y-m-d H:i:s");
			$this->request->data['LeaveType']['start_date']=$this->DateFormat->formatDate2STD($this->request->data['LeaveType']['start_date'],Configure::read('date_format'));
			$this->request->data['LeaveType']['expiry_date']=$this->DateFormat->formatDate2STD($this->request->data['LeaveType']['expiry_date'],Configure::read('date_format'));

			if($this->LeaveType->save($this->request->data['LeaveType']))
			{
				$this->Session->setFlash(__($this->request->data['LeaveType']['name'].' has been modified successfully', true));
				$this->redirect(array('action'=>'leave_master'));
			}
			else
			{
				$this->Session->setFlash(__('Could not add', false));
			}
		}

		$this->data = $this->LeaveType->read(null,$id);

	}

	public function delete_leave_type($id = null){
		$this->uses = array('LeaveType');
		$this->request->data['LeaveType']['is_deleted']=1;
		$this->LeaveType->id= $id;
		if($this->LeaveType->save($this->request->data['LeaveType'])){
			$this->Session->setFlash(__('Leave Type deleted successfully'),true);
			$this->redirect(array("action" => "leave_master"));
		}


	}
	/**
	 * function to search Profit Loss Report
	 * @author Mahalaxmi
	 */
	public function profitLossStatement($type=null){
		$this->layout = 'advance';
		$this->set('flag',$this->request->query['flag']);	
		if($type=='excel'){		 			
			$this->profitLossReport();
			$this->autoRender = false;					
			$this->layout = false ;
			$this->render('profit_loss_report_xls');		
		}	
		if($type=='print'){				
			$this->request->data = $this->params->query ;
			$this->profitLossReport();
			$this->layout = false;
			$this->render('profit_loss_report_print');	
		}
		if($type=='printGroup'){				
			$this->request->data = $this->params->query ;
			$this->profitLossReport();
			$this->layout = false;
			$this->render('profit_loss_report_group_print');	
		}
	}

	/**
	 * function to calculate Profit Loss Report
	 * @author Mahalaxmi
	 */
	public function profitLossReport(){
		//Configure::write('debug',2) ;
		ob_end_clean();
		ob_start("ob_gzhandler");
		$this->layout=false;				
		$this->uses=array('AccountingGroup','VoucherEntry','AccountReceipt','Account','VoucherPayment','ContraEntry','VoucherLog');		
		$locationId = $this->Session->read('locationid');
		$getLocName=$this->Session->read('location_name');
		$getLocAdd1=$this->Session->read('location_address1');
		$getLocAdd2=$this->Session->read('location_address2');
		$location_zipcode=$this->Session->read('location_zipcode');
		$location_country=$this->Session->read('location_country');	
	
		$getAccountingGroupDataAll=$this->AccountingGroup->getAllGroupDetails($this->Session->read('locationid'),Configure::read('group_type'));		
		foreach ($getAccountingGroupDataAll as $key => $value) {
			$getAccountingGroupDataIdWise[$value['AccountingGroup']['id']]=$value;
			$getAccountingGroupId[$value['AccountingGroup']['id']]=$value['AccountingGroup']['id'];	
			$accountingGroupList[$value['AccountingGroup']['parent_id']][] = $value['AccountingGroup']['id'];			
			if($value['AccountingGroup']['account_type']==Configure::read('income_label')  && $value['AccountingGroup']['name']!=Configure::read('indirect_income_label') || empty($value['AccountingGroup']['account_type'])){ 
				$accountingGroupListIncome[$value['AccountingGroup']['parent_id']][] = $value['AccountingGroup']['id'];
			}
			if($value['AccountingGroup']['account_type']==Configure::read('expense_label')  && $value['AccountingGroup']['name']!=Configure::read('indirect_expenses_label') || empty($value['AccountingGroup']['account_type'])){ 
				$accountingGroupListExpense[$value['AccountingGroup']['parent_id']][] = $value['AccountingGroup']['id'];
			}
			if($value['AccountingGroup']['name']==Configure::read('indirect_expenses_label') || empty($value['AccountingGroup']['account_type'])){			
				$accountingGroupListIndirectExpense[$value['AccountingGroup']['parent_id']][] = $value['AccountingGroup']['id'];
			}
			if($value['AccountingGroup']['name']==Configure::read('indirect_income_label') || empty($value['AccountingGroup']['account_type'])){
				$accountingGroupListIndireactIncome[$value['AccountingGroup']['parent_id']][] = $value['AccountingGroup']['id'];
			}
			
			$getAccountingGroupName[$value['AccountingGroup']['id']]=$value['AccountingGroup']['name'];			
		}
		asort($getAccountingGroupName);
		#debug($accountingGroupList);
		#debug($getAccountingGroupName);

		
		$this->set(compact('accountingGroupListIncome','accountingGroupListExpense','accountingGroupListIndirectExpense','accountingGroupListIndireactIncome'));
		
		if(!empty($this->request->data['from_date']) && !empty($this->request->data['to_date'])){
			$from=$this->request->data['from_date'];
			$fromDate=$this->DateFormat->formatDate2STDForReport($this->request->data['from_date'],Configure::read('date_format'))." 00:00:00";
			$to=$this->request->data['to_date'];
			$toDate=$this->DateFormat->formatDate2STDForReport($this->request->data['to_date'],Configure::read('date_format'))." 23:59:59";		
		}
		$journalArray = $this->VoucherEntry->getJournalData($fromDate,$toDate,$this->Session->read('locationid'),$getAccountingGroupId,Configure::read('profit_loss_statement'));
		$receiptArray = $this->AccountReceipt->getReceiptData($fromDate,$toDate,$this->Session->read('locationid'),$getAccountingGroupId,Configure::read('profit_loss_statement'));
   		$paymentArray = $this->VoucherPayment->getPaymentData($fromDate,$toDate,$this->Session->read('locationid'),$getAccountingGroupId,Configure::read('profit_loss_statement'));
  	 	$contraArray = $this->ContraEntry->getContraData($fromDate,$toDate,$this->Session->read('locationid'),$getAccountingGroupId,Configure::read('profit_loss_statement'));
  		
		$commanArr=array_merge($journalArray['0'],$journalArray['1'],$receiptArray['0'],$receiptArray['1'],$paymentArray['0'],$paymentArray['1'],$contraArray['0'],$contraArray['1']);
		#debug($commanArr);exit;
		$returnArr=array();		
		$finalExpenseInnerArray=array();
		$finalIncomeInnerArray=array();
		foreach ($commanArr as $key => $value) {	
			$refineArr[$value['Account']['accounting_group_id']][]=$value;						
			$returnArr[$value['Account']['accounting_group_id']]['acc_group_id']=$value['Account']['accounting_group_id'];	
			$InnerArr[$value['Account']['accounting_group_id']][$value['Account']['id']]['acc_id']=$value['Account']['id'];	
			$InnerArr[$value['Account']['accounting_group_id']][$value['Account']['id']]['acc_group_id']=$value['Account']['accounting_group_id'];	
			$InnerArr[$value['Account']['accounting_group_id']][$value['Account']['id']]['acc_name']=$value['Account']['name'];	

			$finalExpenseInnerArray[$value['Account']['accounting_group_id']][$value['Account']['id']] += round(($value['0']['receiptSumDebit']+$value['0']['paymentSumDebit']+$value['0']['contraSumDebit']+$value['0']['journalSumDebit'])-($value['0']['receiptSumCredit']+$value['0']['paymentSumCredit']+$value['0']['contraSumCredit']+$value['0']['journalSumCredit']));

			/*as discussed with Tushar and Murli Sir - show only payment entries*/
			$finalIncomeInnerArray[$value['Account']['accounting_group_id']][$value['Account']['id']] +=  round(($value['0']['receiptSumCredit']+$value['0']['paymentSumCredit']+$value['0']['contraSumCredit']+$value['0']['journalSumCredit'])-($value['0']['receiptSumDebit']+$value['0']['paymentSumDebit']+$value['0']['contraSumDebit']+$value['0']['journalSumDebit']));

		}	
		
		foreach($finalExpenseInnerArray as $keyExp => $valExp){
  			foreach($valExp as $subExpKey => $expVal){
  				if($expVal >= 0){
  					$returnArr[$keyExp]['debit'] += $expVal;
  					$InnerArr[$keyExp][$subExpKey]['debit'] += $expVal;
  				}else{
  					$returnArr[$keyExp]['credit'] += $expVal;
  					$InnerArr[$keyExp][$subExpKey]['credit'] += $expVal;
  				}
  			}
  		}
  		foreach($finalIncomeInnerArray as $key => $val){
  			foreach($val as $subKey => $mval){
  				if($mval >= 0){
  					$returnArr[$key]['income_debit'] += $mval;
  					$InnerArr[$key][$subKey]['income_debit'] += $mval;
  				}else{
  					$returnArr[$key]['income_credit'] += $mval;
  					$InnerArr[$key][$subKey]['income_credit'] += $mval;
  				}
  			}
  		}


  		#debug($InnerArr);
		//*************BOF-Calculating Gross Profit********//
		

		
		
		/*$temp=array();
		$subArry=array();
		$subArryCnt=0;
		
		
		
		foreach($getAccountingGroupDataAll as $key=>$childArry){// main array
			$childHolder="1";
			while($childHolder=='1'){
				$childHolder=$this->childSearch($getAccountingGroupDataAll,$childArry,$childArry['AccountingGroup']['name']);				
				foreach($getAccountingGroupDataAll as $key=>$mainSub){
					foreach($refineArr as $keyRef=>$refSub){
						if($keyRef==$mainSub['AccountingGroup']['id']){
							$getAccountingGroupDataAll[$key]['AccountingGroup']['ledger']=$refineArr[$keyRef];
						}
					}
				}

				if($childHolder!=0){
					$subArry[$subArryCnt]=$childHolder;
					$subArryCnt++;
				}
				if(!is_numeric($childHolder)){
					$childArry=$childHolder;
					continue;
				}
			}
		}

		$countOfChildArry=count($subArry)-1;
		
		for($j=$countOfChildArry;$j>=0;$j--){
			for($k=0;$k<=$j;$k++){
				foreach($subArry[$k][key($subArry[$k])] as $key => $subValue) {//debug($subValue);exit;
					if($subValue['AccountingGroup']['id']==$subArry[$j][key($subArry[$j])][0]['AccountingGroup']['parent_id']){
						$subArry[$k][key($subArry[$k])][$key][key($subArry[$j])]=$subArry[$j][key($subArry[$j])];
					}
				}
			}
		}
		
		
		$countOfParentArry=count($subArry)-1;
		foreach ($getAccountingGroupDataAll as $key => $subValueParent) {
			for($j=0;$j<=$countOfParentArry;$j++){
				if($subValueParent['AccountingGroup']['id']==$subArry[$j][key($subArry[$j])][0]['AccountingGroup']['parent_id']){
						$getAccountingGroupDataAll[$key][key($getAccountingGroupDataAll[$key])][key($subArry[$j])]=$subArry[$j][key($subArry[$j])];
				}
			}
		}
		debug($getAccountingGroupDataAll);
		//exit;*/
//debug($getAccountingGroupName);
		foreach ($accountingGroupList as $key => $value) {		
			foreach ($value as $subKey => $subValue) {				
				if($getAccountingGroupDataIdWise[$subValue]['AccountingGroup']['account_type']==Configure::read('income_label') || empty($getAccountingGroupDataIdWise[$subValue]['AccountingGroup']['account_type']) || $getAccountingGroupDataIdWise[$subValue]['AccountingGroup']['name']==Configure::read('indirect_income_label')){					
				    	if(!empty($returnArr[$subValue]['income_debit'])){
							$totalAmt[$subValue]=$returnArr[$subValue]['income_debit'];
						}else{
							$totalAmt[$subValue]=$returnArr[$subValue]['income_credit'];
						}							
							
					$recurciveBalParent[$key] =$recurciveBalParent[$key]+ round($totalAmt[$subValue]);
					$recurciveBalChild[$subValue] =$recurciveBalChild[$subValue]+ round($totalAmt[$subValue]);					
				}  
				if($getAccountingGroupDataIdWise[$subValue]['AccountingGroup']['account_type']==Configure::read('expense_label') || empty($getAccountingGroupDataIdWise[$subValue]['AccountingGroup']['account_type']) || $getAccountingGroupDataIdWise[$subValue]['AccountingGroup']['name']==Configure::read('indirect_expenses_label')){	
			    	if(!empty($returnArr[$subValue]['debit'])){
						$totalAmt[$subValue]=$returnArr[$subValue]['debit'];
					}else{
						$totalAmt[$subValue]=$returnArr[$subValue]['credit'];
					}						
				$recurciveBalParentExpense[$key] =$recurciveBalParentExpense[$key]+ round($totalAmt[$subValue]);
				$recurciveBalChildExpense[$subValue] =$recurciveBalChildExpense[$subValue]+ round($totalAmt[$subValue]);
				}  
			}			
	  	}
	  	$this->set(compact('recurciveBalParentExpense','recurciveBalChildExpense'));
	
	  	#debug($recurciveBalParent);
	 	#debug($recurciveBalChild);
	  //	exit;
		
		/*$totalGrpSumExp=0;
		$totalGrpSumInc=0;
		$totalGrpSumIndirExp=0;
		$totalGrpSumIndirInc=0;
		foreach($getAccountingGroupDataAll as $keyAccGrp=>$getAccountingGroupData){
			if($getAccountingGroupData['AccountingGroup']['account_type']==Configure::read('expense_label')  && $getAccountingGroupData['AccountingGroup']['name']!=Configure::read('indirect_expenses_label')){ //BOF-For Above Left handside -----Expense----- Side only for expense except Indirect expense and Income type
				if(!empty($returnArr[$getAccountingGroupData['AccountingGroup']['id']]['debit'])){
					$totalGrpSumExp=(int)$totalGrpSumExp+$returnArr[$getAccountingGroupData['AccountingGroup']['id']]['debit'];		
				}else if(!empty($returnArr[$getAccountingGroupData['AccountingGroup']['id']]['credit'])){
					$totalGrpSumExp=(int)$totalGrpSumExp+$returnArr[$getAccountingGroupData['AccountingGroup']['id']]['credit'];	
				}	
			}
			if($getAccountingGroupData['AccountingGroup']['account_type']==Configure::read('income_label')  && $getAccountingGroupData['AccountingGroup']['name']!=Configure::read('indirect_income_label')){ 				
				//BOF-For Below Left handside -----Income------ Side only except expense and Indirect Income
				if(!empty($returnArr[$getAccountingGroupData['AccountingGroup']['id']]['income_debit'])){
					$totalGrpSumInc=(int)$totalGrpSumInc+$returnArr[$getAccountingGroupData['AccountingGroup']['id']]['income_debit'];						
				}else if(!empty($returnArr[$getAccountingGroupData['AccountingGroup']['id']]['income_credit'])){
					$totalGrpSumInc=(int)$totalGrpSumInc+$returnArr[$getAccountingGroupData['AccountingGroup']['id']]['income_credit'];				
				}	
			}
			if($getAccountingGroupData['AccountingGroup']['name']==Configure::read('indirect_expenses_label')){
				//BOF-For Above Right handside ----expense----- Side only except Indirect expense						
				if(!empty($returnArr[$getAccountingGroupData['AccountingGroup']['id']]['debit'])){ 
					$totalGrpSumIndirExp=(int)$totalGrpSumIndirExp+$returnArr[$getAccountingGroupData['AccountingGroup']['id']]['debit'];						
				}else if(!empty($returnArr[$getAccountingGroupData['AccountingGroup']['id']]['credit'])){
					$totalGrpSumIndirExp=(int)$totalGrpSumIndirExp+$returnArr[$getAccountingGroupData['AccountingGroup']['id']]['credit'];				
				}
			}
			if($getAccountingGroupData['AccountingGroup']['name']==Configure::read('indirect_income_label')){ 
				//BOF-For Above Right handside ----Income---- Side only except Indirect income
				if(!empty($returnArr[$getAccountingGroupData['AccountingGroup']['id']]['income_debit'])){ 
					$totalGrpSumIndirInc=(int)$totalGrpSumIndirInc+$returnArr[$getAccountingGroupData['AccountingGroup']['id']]['income_debit'];				
				}else if(!empty($returnArr[$getAccountingGroupData['AccountingGroup']['id']]['income_credit'])){
					$totalGrpSumIndirInc=(int)$totalGrpSumIndirInc+$returnArr[$getAccountingGroupData['AccountingGroup']['id']]['income_credit'];				
				}	
			}
		}*/
	//debug($accountingGroupList['recurciveBalParent']);
	//debug($accountingGroupList['recurciveBalChild']);
		//exit;
		//debug($subgroupArr);
		/*$getGrpSumExp=(int)$totalGrpSumExp+10000; ////10000-For Opening Stock
		$getGrpSumInc=(int)$totalGrpSumInc+10000;////10000-For Closing Stock	
		
		$getGross=(int)$getGrpSumInc-$getGrpSumExp;
	
	
		if($getGross<0){
			//If  Gross Loss
			$getProfitLossFlag=true;			
			$getGrossLoss=(int)$getGrpSumInc-$getGrpSumExp; //**If  Gross Loss				
			///BOF-TOTAL VALUE OF EXPENSE SIDE//
			$getTotalExpExceptIndirExp=(int)$getGrpSumExp;				
			///BOF-TOTAL VALUE OF INCOME SIDE//
			if($getGrossLoss<0){
				$getGrossLoss1=abs($getGrossLoss);
			}
			$getTotalIncExceptIndirInc=(int)$getGrossLoss1+$getGrpSumInc;
			if($getTotalExpExceptIndirExp>$getTotalIncExceptIndirInc){
				$getTotalLossExpExceptIndirExpInc1=$getTotalExpExceptIndirExp;
			}else{
				$getTotalLossExpExceptIndirExpInc1=$getTotalIncExceptIndirInc;
			}
		}else{
			//If  Gross Profit				
			$getProfitLossFlag=false;
			$getGrossProfit=(int)$getGrpSumInc-$getGrpSumExp; //If  Gross Profit
			///BOF-TOTAL VALUE OF EXPENSE SIDE//
			$getTotalExpExceptIndirExp=(int)$getGrossProfit+$getGrpSumExp;				
			///BOF-TOTAL VALUE OF INCOME SIDE//
			$getTotalIncExceptIndirInc=(int)$getGrpSumInc;			
			if($getTotalExpExceptIndirExp>$getTotalIncExceptIndirInc){
				$getTotalProfitExpExceptIndirExpInc1=$getTotalExpExceptIndirExp;
			}else{
				$getTotalProfitExpExceptIndirExpInc1=$getTotalIncExceptIndirInc;
			}
				
		}
		//////EOF-Calculate Gross Profit///////	
		
	
		if($getGross<0){
			$getNetLossFlag=true; //if Net Loss
			$getGrossLoss2=abs($getGrossLoss);
			$getNet=(int)$getGrossLoss2-$totalGrpSumIndirExp+$totalGrpSumIndirInc;
			$getNetLoss=$getNet;				
			$getNetLoss=abs($getNetLoss);		
			//////BOF-Calculate Total Expenses///////
			$getTotalExpense=(int)$getNetLoss+$totalGrpSumIndirExp;	
			//////BOF-Calculate Total Incomes///////
			$getTotalIncomes=(int)$getGrossLoss2+$totalGrpSumIndirInc;
		}else{
			$getNetLossFlag=false; //if Net Profit			
			$getNet=(int)$getGrossProfit-$totalGrpSumIndirExp+$totalGrpSumIndirInc;
			$getNetProfit=$getNet;				
			//////BOF-Calculate Total Expenses//////
			$getTotalExpense=(int)$getNetProfit+$totalGrpSumIndirExp;				
			//////BOF-Calculate Total Incomes///////
			$getTotalIncomes=(int)$getGrossProfit+$totalGrpSumIndirInc;
		}*/
		////*****EOF-Calcualting Net Profit*****//
	
		$this->set(array('locationId'=>$locationId,'from'=>$from,'to'=>$to,'InnerArr'=>$InnerArr,'groupeExpIncData'=>$returnArr,'finalArr'=>$getAccountingGroupDataAll/*,'getTotalProfitExpExceptIndirExpInc1'=>$getTotalProfitExpExceptIndirExpInc1,'getTotalLossExpExceptIndirExpInc1'=>$getTotalLossExpExceptIndirExpInc1,'getGrossProfit'=>$getGrossProfit,'getNetProfit'=>$getNetProfit,'getTotalExpense'=>$getTotalExpense,'getTotalIncomes'=>$getTotalIncomes,'getGrpSumExp'=>$getGrpSumExp,'totalGrpSumInc'=>$totalGrpSumInc*/,'getLocName'=>$getLocName,'getLocAdd1'=>$getLocAdd1,'getLocAdd2'=>$getLocAdd2,'location_zipcode'=>$location_zipcode,'location_country'=>$location_country/*,'getTotalExpExceptIndirExp'=>$getTotalExpExceptIndirExp,'getTotalIncExceptIndirInc'=>$getTotalIncExceptIndirInc,'getProfitLossFlag'=>$getProfitLossFlag,'getNetLossFlag'=>$getNetLossFlag,'getGrossLoss'=>$getGrossLoss,'getNetLoss'=>$getNetLoss*/,'accountingGroupList'=>$accountingGroupList,
			'refineArr'=>$refineArr,'getAccountingGroupName'=>$getAccountingGroupName,'recurciveBalParent'=>$recurciveBalParent,'recurciveBalChild'=>$recurciveBalChild,'recurciveBalChild'=>$recurciveBalChild));
		//************
	
	}
	
	
	public function subgroup_list(){
		$this->layout = 'ajax' ;
		//$this->layout = false ;
		$this->uses=array('AccountingGroup','AccountReceipt','VoucherEntry','VoucherPayment','ContraEntry');
			if(!empty($this->request->data['fromDate']) && !empty($this->request->data['toDate'])){
				$fromDate=$this->DateFormat->formatDate2STDForReport($this->request->data['fromDate'],Configure::read('date_format'))." 00:00:00";
				$toDate=$this->DateFormat->formatDate2STDForReport($this->request->data['toDate'],Configure::read('date_format'))." 23:59:59";
			}	

		$journalArray = $this->VoucherEntry->getJournalData($fromDate,$toDate,$this->Session->read('locationid'),$this->request->data['valueGroupId']);
		$receiptArray = $this->AccountReceipt->getReceiptData($fromDate,$toDate,$this->Session->read('locationid'),$this->request->data['valueGroupId']);
   		$paymentArray = $this->VoucherPayment->getPaymentData($fromDate,$toDate,$this->Session->read('locationid'),$this->request->data['valueGroupId']);
  	 	$contraArray = $this->ContraEntry->getContraData($fromDate,$toDate,$this->Session->read('locationid'),$this->request->data['valueGroupId']);
  		
		$commanArr=array_merge($journalArray['0'],$journalArray['1'],$receiptArray['0'],$receiptArray['1'],$paymentArray['0'],$paymentArray['1'],$contraArray['0'],$contraArray['1']);
		//debug($commanArr);
		$returnArr=array();		
		$finalArray=array();
		foreach ($commanArr as $key => $value) {				
				$returnArr[$value['Account']['id']]['acc_id']=$value['Account']['id'];	
				$returnArr[$value['Account']['id']]['acc_name']=$value['Account']['name'];

				$finalArray[$value['Account']['id']] += round(($value['0']['receiptSumDebit']+$value['0']['paymentSumDebit']+$value['0']['contraSumDebit']+$value['0']['journalSumDebit'])-($value['0']['receiptSumCredit']+$value['0']['paymentSumCredit']+$value['0']['contraSumCredit']+$value['0']['journalSumCredit']));				
				
		}
		foreach($finalArray as $key => $val){  			
  				if($val >= 0){
  					$returnArr[$key]['exp_debit'] += $val;
  				}else{
  					$returnArr[$key]['exp_credit'] += $val;
  				}  			
  		}  		
  		

		$this->set(array('commanExpenseArrList'=>$returnArr,'accountAndSubArray'=>$getAccountingGroupIdTTTT));
		
		
	}
	
	public function subgroup_income_list(){
		$this->layout = 'ajax' ;		
		$this->uses=array('AccountingGroup','AccountReceipt','VoucherEntry','VoucherPayment','ContraEntry');
		if(!empty($this->request->data['fromDate']) && !empty($this->request->data['toDate'])){
			$fromDate=$this->DateFormat->formatDate2STDForReport($this->request->data['fromDate'],Configure::read('date_format'))." 00:00:00";
			$toDate=$this->DateFormat->formatDate2STDForReport($this->request->data['toDate'],Configure::read('date_format'))." 23:59:59";
		}	

		$journalArray = $this->VoucherEntry->getJournalData($fromDate,$toDate,$this->Session->read('locationid'),$this->request->data['valueGroupId']);
		$receiptArray = $this->AccountReceipt->getReceiptData($fromDate,$toDate,$this->Session->read('locationid'),$this->request->data['valueGroupId']);
   		$paymentArray = $this->VoucherPayment->getPaymentData($fromDate,$toDate,$this->Session->read('locationid'),$this->request->data['valueGroupId']);
  	 	$contraArray = $this->ContraEntry->getContraData($fromDate,$toDate,$this->Session->read('locationid'),$this->request->data['valueGroupId']);
  		
		$commanArr=array_merge($journalArray['0'],$journalArray['1'],$receiptArray['0'],$receiptArray['1'],$paymentArray['0'],$paymentArray['1'],$contraArray['0'],$contraArray['1']);
		//debug($commanArr);
		$returnArr=array();		
		foreach ($commanArr as $key => $value) {				
				$returnArr[$value['Account']['id']]['acc_id']=$value['Account']['id'];	
				$returnArr[$value['Account']['id']]['acc_name']=$value['Account']['name'];

				$finalArray[$value['Account']['id']] +=round(($value['0']['receiptSumCredit']+$value['0']['paymentSumCredit']+$value['0']['contraSumCredit']+$value['0']['journalSumCredit'])-($value['0']['receiptSumDebit']+$value['0']['paymentSumDebit']+$value['0']['contraSumDebit']+$value['0']['journalSumDebit']));			
				
		}
		
  		foreach($finalArray as $key => $val){  			
  				if($val >= 0){
  					$returnArr[$key]['income_debit'] += $val;
  				}else{
  					$returnArr[$key]['income_credit'] += $val;
  				}  			
  		}  
  		
		$this->set(array('commanIncomeArrList'=>$returnArr));
	}

	
	public function expense_main(){
		$this->layout = 'advance';
	}
	public function expense_list(){
		//$this->layout = 'ajax';
		$this->autoRender = false;
		$this->uses=array('AccountingGroup','Account','VoucherPayment','Expense');


		if ($this->request->query['month_list']) {
			if(!empty($this->request->query['month_list'])){
				$startDate =$this->request->query['year_list']."-".$this->request->query['month_list']."-28";
				$startDate = date("Y-m", strtotime($startDate."-1 month"));
				$endDate = date("Y-m",strtotime($startDate ." -5 months"));
				$search_key['DATE_FORMAT(VoucherPayment.date,"%Y-%m") between ? and ?'] =  array($endDate,$startDate);
			}
		}else{
			$startDate = date("Y-m",strtotime(date("Y-m") ." - 1 months"));
			$endDate = date("Y-m",strtotime(date("Y-m") ." - 5 months"));
			$search_key['DATE_FORMAT(VoucherPayment.date,"%Y-%m") between ? and ?'] =  array($endDate,$startDate);
		}

		
		$getAccountingGroupAllData=$this->AccountingGroup->find('list',array('fields'=>array('id','id'),'conditions'=>array("is_deleted"=>0,"AccountingGroup.name"=>Configure::read('acc_expense_group_name'))));
		$this->VoucherPayment->bindModel(array(
				'belongsTo'=>array(
						//'AccountingGroup'=>array('foreignKey'=>false,'conditions'=>array("AccountingGroup.name"=>array("Direct Expenses","Indirect Expenses"),"AccountingGroup.is_deleted"=>"0",'AccountingGroup.location_id'=>$this->Session->read('locationid'))),
						'Account'=>array('foreignKey'=>false,'conditions'=>array("Account.id=VoucherPayment.user_id","Account.is_deleted"=>"0",'Account.accounting_group_id'=>$getAccountingGroupAllData)),),

		));
		$resultAccountsData = $this->VoucherPayment->find('all',array('fields'=>array('MONTH(VoucherPayment.date) as MONTH','SUM(VoucherPayment.paid_amount) as paid_amounts','Account.name','Account.id','VoucherPayment.user_id','VoucherPayment.date'),
				'conditions'=>$search_key,
				'group'=>array('VoucherPayment.user_id','MONTH'),'order' => array ('Account.name'=>'ASC')));
		
		$reportArray = $monthsArray = array();
		foreach($resultAccountsData as $key=>$value){
			$reportArray[$value['Account']['name']][$value['0']['MONTH']] = $value['0']['paid_amounts'];
		}

		$getExpenseAllData=$this->Expense->find('all',array('fields'=>array('id','start_date','acc_name_all_amt','comment'),'conditions'=>array('is_deleted'=>0)));
		$this->set(array('resultAccountsData'=>$reportArray,'startDate'=>$startDate,'endDate'=>$endDate,'getExpenseAllData'=>$getExpenseAllData));
		$this->render ( "expense_list", false );
	}
	public function save_expense(){
		$this->uses=array('Expense');
		//	debug($this->request->data);exit;
		$saveExpArr['acc_name_all_amt']=serialize($this->request->data);
		$saveExpArr['comment']=$this->request->data['comment'];
		$saveExpArr['total_per_day_expense']=$this->request->data['total_per_day_expense'];
		$saveExpArr['start_date']=$this->request->data['Expenses']['start_date'];
		$saveExpArr['created_by']=$this->Session->read('userid');
		$saveExpArr['create_time']=date("Y-m-d H:i:s");

		if($this->Expense->save($saveExpArr)){
			$this->redirect("/HR/expense_main");
		}else{
			echo "not save";
		}
		exit;

	}
	public function edit_expense() {
		$this->autoRender = false;
		$this->Layout = 'ajax';
		$this->uses=array('Expense');
		$saveExpArr['comment']=$this->request->data['commentInTxt'];
		$saveExpArr['id']=$this->request->data['recId'];
		$flagSave=$this->Expense->save($saveExpArr);

		if($flagSave){
			echo $this->request->data['commentInTxt'];
		}

	}
	public function view_expense($id = null) {
		$this->uses=array('Expense');
		if(!empty($id)){
			$getExpenseData=$this->Expense->find('first',array('conditions'=>array('Expense.id'=>$id)));
			//debug($getExpenseData);
			//debug(unserialize($getExpenseData['Expense']['acc_name_all_amt']));
			$this->set('getExpenseData',$getExpenseData);
		}
	}
	public function delete_expense($id = null) {
		$this->uses = array('Expense');
		$this->request->data['Expense']['is_deleted']=1;
		$this->Expense->id= $id;
		if($this->Expense->save($this->request->data['Expense'])){
			$this->Session->setFlash(__('Expense deleted successfully'),true);
			$this->redirect(array("action" => "expense_main"));
		}
	}

	public function income_sheet(){
		$this->layout = 'advance';
	}
	public function income_list(){
		//$this->layout = 'ajax';
		$this->autoRender = false;
		$this->uses=array('AccountingGroup','Account','AccountReceipt','Income');

		if ($this->request->query['month_list']) {
			if(!empty($this->request->query['month_list'])){
				$startDate =$this->request->query['year_list']."-".$this->request->query['month_list']."-28";
				$startDate = date("Y-m", strtotime($startDate."-1 month"));
				$endDate = date("Y-m",strtotime($startDate ." -5 months"));
				$search_key['DATE_FORMAT(AccountReceipt.date,"%Y-%m") between ? and ?'] =  array($endDate,$startDate);
			}
		}else{
			$startDate = date("Y-m",strtotime(date("Y-m") ." - 1 months"));
			$endDate = date("Y-m",strtotime(date("Y-m") ." - 5 months"));
			$search_key['DATE_FORMAT(AccountReceipt.date,"%Y-%m") between ? and ?'] =  array($endDate,$startDate);
		}
		$getAccountingGroupAllData=$this->AccountingGroup->find('list',array('fields'=>array('id','id'),'conditions'=>array("is_deleted"=>0,"AccountingGroup.name"=>Configure::read('acc_income_group_name'))));

		$this->AccountReceipt->bindModel(array(
				'belongsTo'=>array(
						//	'AccountingGroup'=>array('foreignKey'=>false,'conditions'=>array("AccountingGroup.name"=>array("Direct Income","Indirect Income"),"AccountingGroup.is_deleted"=>"0"/*,'AccountingGroup.location_id'=>$this->Session->read('locationid')*/)),
						'Account'=>array('foreignKey'=>false,'conditions'=>array("Account.id=AccountReceipt.user_id","Account.is_deleted"=>"0",'Account.accounting_group_id'=>$getAccountingGroupAllData)),),

		));
		$resultAccountsData = $this->AccountReceipt->find('all',array('fields'=>array('MONTH(AccountReceipt.date) as MONTH','SUM(AccountReceipt.paid_amount) as paid_amounts','Account.name','Account.id','AccountReceipt.user_id','AccountReceipt.date'),
				'conditions'=>$search_key,
				'group'=>array('AccountReceipt.user_id','MONTH'),'order' => array ('Account.name'=>'ASC')));


		$reportArray = $monthsArray = array();
		foreach($resultAccountsData as $key=>$value){
			$reportArray[$value['Account']['name']][$value['0']['MONTH']] = $value['0']['paid_amounts'];
		}

		$getIncomeAllData=$this->Income->find('all',array('fields'=>array('id','start_date','acc_name_all_amt','comment'),'conditions'=>array('is_deleted'=>0)));

		$this->set(array('resultAccountsData'=>$reportArray,'startDate'=>$startDate,'endDate'=>$endDate,'getIncomeAllData'=>$getIncomeAllData));
		$this->render ( "income_list", false );
	}
	public function income_group_sheet(){
		$this->layout = 'advance';
	}
	public function income_group_list(){
		$this->layout = 'advance_ajax';
		$this->autoRender = false;
		$this->uses=array('AccountingGroup','Account','AccountReceipt','Income');
	
		if ($this->request->query['month_list']) {
			if(!empty($this->request->query['month_list'])){
				$startDate =$this->request->query['year_list']."-".$this->request->query['month_list']."-28";
				$startDate = date("Y-m", strtotime($startDate."-1 month"));
				$endDate = date("Y-m",strtotime($startDate ." -5 months"));
				$search_key['DATE_FORMAT(AccountReceipt.date,"%Y-%m") between ? and ?'] =  array($endDate,$startDate);
			}
		}else{
			$startDate = date("Y-m",strtotime(date("Y-m") ." - 1 months"));
			$endDate = date("Y-m",strtotime(date("Y-m") ." - 5 months"));
			$search_key['DATE_FORMAT(AccountReceipt.date,"%Y-%m") between ? and ?'] =  array($endDate,$startDate);
		}
		
		//**************
		$this->AccountingGroup->bindModel(array(
				'hasMany'=>array(
						'AccountingGroupChild'=>array('className' => 'AccountingGroup',
								'foreignKey'    => 'parent_id','fields'=>array('AccountingGroupChild.id','AccountingGroupChild.name')),
				),
		));
		//*******AccountingGroupChild-SubGrp of Groups for Expense*****////
		$getAccountingGroupIdTTTT=$this->AccountingGroup->find('all',array('fields'=>array('AccountingGroup.id','AccountingGroup.name','AccountingGroup.account_type'),
				'conditions'=>array("AccountingGroup.is_deleted"=>0,'AccountingGroup.location_id'=>$this->Session->read('locationid'),
						'AccountingGroup.account_type'=>array("Income"),'AccountingGroup.parent_id'=>"0"),'order' => array ('AccountingGroup.name'=>'ASC')));
		
		foreach($getAccountingGroupIdTTTT as $key => $value){
			if($value['AccountingGroupChild']){
				foreach ($value['AccountingGroupChild'] as $childKey =>$childValue) {
					$sugGroupID[] = $childValue['id'] ; //sub group ids
				}
			}else{
				$groupID[] = $value['AccountingGroup']['id'] ; //group ids
			}
		
		}
		
			
		$this->Account->bindModel(array('hasOne'=>array('AccountReceipt'=>array('foreignKey'=>'user_id','fields'=>array('MONTH(AccountReceipt.date) as MONTH','SUM(AccountReceipt.paid_amount) as paid_amounts','Account.name','Account.id','AccountReceipt.user_id','AccountReceipt.date'),'conditions'=>$search_key,'group'=>array('AccountReceipt.user_id','MONTH')))),
				false);
		
		///******BOF-Only Account table Data*****////
		$accountSum  = $this->Account->find('all',array('fields'=>array('Account.name','Account.accounting_sub_group_id','Account.accounting_group_id','SUM(AccountReceipt.paid_amount) as totalPayAccReceipt','Account.id'),
				'conditions'=>array("OR"=>array('Account.accounting_sub_group_id'=>$sugGroupID,array('Account.accounting_group_id'=>$groupID,'Account.accounting_sub_group_id IS NULL'))),
				'group'=>array('Account.id'),/*'order'=>array('Account.id'),*/'order' => array ('Account.name'=>'ASC'))) ;
		
		
		///******BOF-Only Account Group table respective sub grp ids Data*****////
		$subGroupSum  = $this->Account->find('all',array('fields'=>array('Account.name','Account.accounting_sub_group_id','Account.accounting_group_id','SUM(AccountReceipt.paid_amount) as totalPayAccReceipt','Account.id'),
				'conditions'=>array('Account.accounting_sub_group_id'=>$sugGroupID),'group'=>array('Account.accounting_sub_group_id'),/*'order'=>array('Account.accounting_sub_group_id')*/'order' => array ('Account.name'=>'ASC'))) ;
		
		///******BOF-Only Account Group table Data*****////
		$groupSum  = $this->Account->find('all',array('fields'=>array('Account.name','Account.accounting_sub_group_id','Account.accounting_group_id','SUM(AccountReceipt.paid_amount) as totalPayAccReceipt','Account.id'),
				'conditions'=>array("OR"=>array('Account.accounting_sub_group_id'=>$sugGroupID,array('Account.accounting_group_id'=>$groupID,'Account.accounting_sub_group_id IS NULL'))),'group'=>array('Account.accounting_group_id'), 'order' => array ('Account.name'=>'ASC'))) ;
		
		//debug($groupSum);
		
		
		
		$getAccountingGroupAllData=$this->AccountingGroup->find('list',array('fields'=>array('id','id'),'conditions'=>array("is_deleted"=>0,"AccountingGroup.name"=>Configure::read('acc_income_group_name'))));
	
		$this->AccountReceipt->bindModel(array(
				'belongsTo'=>array(
						//	'AccountingGroup'=>array('foreignKey'=>false,'conditions'=>array("AccountingGroup.name"=>array("Direct Income","Indirect Income"),"AccountingGroup.is_deleted"=>"0"/*,'AccountingGroup.location_id'=>$this->Session->read('locationid')*/)),
						'Account'=>array('foreignKey'=>false,'conditions'=>array("Account.id=AccountReceipt.user_id","Account.is_deleted"=>"0",'Account.accounting_group_id'=>$getAccountingGroupAllData)),),
		));
		$resultAccountsData = $this->AccountReceipt->find('all',array('fields'=>array('MONTH(AccountReceipt.date) as MONTH','SUM(AccountReceipt.paid_amount) as paid_amounts','Account.name','Account.id','AccountReceipt.user_id','AccountReceipt.date'),
				'conditions'=>$search_key,
				'group'=>array('AccountReceipt.user_id','MONTH'),'order' => array ('Account.name'=>'ASC')));
	
	
		$reportArray = $monthsArray = array();
		foreach($resultAccountsData as $key=>$value){
			$reportArray[$value['Account']['name']][$value['0']['MONTH']] = $value['0']['paid_amounts'];
		}
	
		$getIncomeAllData=$this->Income->find('all',array('fields'=>array('id','start_date','acc_name_all_amt','comment'),'conditions'=>array('is_deleted'=>0)));
	
		$this->set(array('resultAccountsData'=>$reportArray,'startDate'=>$startDate,'endDate'=>$endDate,'getIncomeAllData'=>$getIncomeAllData));
		$this->set(array('accountAndSubArray'=>$getAccountingGroupIdTTTT,'accSum'=>$accountSum,'subGroupSum'=>$subGroupSum,'groupSum'=>$groupSum,'getGrossProfit'=>$getGrossProfit,'getNetProfit'=>$getNetProfit,'getTotalExpense'=>$getTotalExpense,'getTotalIncomes'=>$getTotalIncomes,'getGrpSumExp'=>$getGrpSumExp,'totalGrpSumInc'=>$totalGrpSumInc,'getLocName'=>$getLocName,'getLocAdd1'=>$getLocAdd1,'getLocAdd2'=>$getLocAdd2,'location_zipcode'=>$location_zipcode,'location_country'=>$location_country));
		
		$this->render ( "income_group_list", false );
	}
	public function save_income(){
		$this->uses=array('Income');
		$saveIncArr['acc_name_all_amt']=serialize($this->request->data);
		$saveIncArr['comment']=$this->request->data['comment'];
		$saveIncArr['total_per_day_income']=$this->request->data['total_per_day_income'];
		$saveIncArr['start_date']=$this->request->data['Incomes']['start_date'];
		$saveIncArr['created_by']=$this->Session->read('userid');
		$saveIncArr['create_time']=date("Y-m-d H:i:s");

		if($this->Income->save($saveIncArr)){
			$this->redirect("/HR/income_sheet");
		}else{
			echo "not save";
		}
		exit;

	}
	public function edit_income() {
		$this->autoRender = false;
		$this->Layout = 'ajax';
		$this->uses=array('Income');
		$saveExpArr['comment']=$this->request->data['commentInTxt'];
		$saveExpArr['id']=$this->request->data['recId'];
		$flagSave=$this->Income->save($saveExpArr);

		if($flagSave){
			echo $this->request->data['commentInTxt'];
		}

	}
	public function view_income($id = null) {
		$this->uses=array('Income');
		if(!empty($id)){
			$getIncomeData=$this->Income->find('first',array('conditions'=>array('Income.id'=>$id)));
			$this->set('getIncomeData',$getIncomeData);
		}
	}
	public function delete_income($id = null) {
		$this->uses = array('Income');
		$this->request->data['Income']['is_deleted']=1;
		$this->Income->id= $id;
		if($this->Income->save($this->request->data['Income'])){
			$this->Session->setFlash(__('Income deleted successfully'),true);
			$this->redirect(array("action" => "income_main"));
		}
	}
	/**
	 * function for Birth Documentation Form
	 * @author Swati Newale
	 */
	public function birthDocForm($patientId = null){
		$this->layout =false;
		$this->uses=array('Patient','User','BirthDocumentation');
		if(!empty($this->request->data)){
			$this->BirthDocumentation->saveBirthdata($this->request->data['BirthDocumentation']);
			$this->Session->setFlash(__('Birth documentation form submitted successfully'),true);
			$this->redirect(array('controller'=>'users','action' => 'doctor_dashboard'));
		}
		$this->Patient->bindModel(array(
				'hasOne' =>  array(
						'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id' )),
						'BirthDocumentation'=>array('foreignKey' => false,'conditions'=>array('BirthDocumentation.patient_id=Patient.id' )))));

		if($patientId != null){
			$patientDetail = $this->Patient->find('first', array('conditions'=>array("Patient.id"=>$patientId),
					'fields'=>array('Patient.id','Patient.doctor_id','Patient.lookup_name','User.id','CONCAT(User.first_name," ",User.last_name) as name','BirthDocumentation.*'))); // set this to controller
		}
		$this->data = $patientDetail;
		$this->set('patientDetail',$patientDetail); 
	}
	
	
	/**
	 * function to calculate final attendence sheet
	 * @author Gaurav Chauriya
	 */
	public function generateAttendanceSheet($year,$month){
		$this->layout = false;//'advance';//_ajax
		$this->uses = array('DutyRoster','User');
                if(empty($year)) $year = date('Y');
                if(empty($month)) $month = date('m');
                $firstDate = date("$year-$month-01");
                
                $dailyRosterData = $this->DutyRoster->find('all',array(
                    'fields'=>array('id','user_id','date','shift','intime','outime'),
                    'conditions'=>array(
                        'YEAR(date)'=>$year,'MONTH(date)'=>$month,'location_id'=>$this->Session->read('locationid'))
                    ));
                
                foreach($dailyRosterData as $key => $val){
                    $rosterData[$val['DutyRoster']['user_id']][$val['DutyRoster']['date']] = $val['DutyRoster'];
		} 
                //get all Users
		$this->User->belongsTo = array();
		$this->User->bindModel(array(
                    'belongsTo'=>array(
                       'PlacementHistory'=>array(
                            'foreignKey'=>false,
                            'type'=>'inner',
                            'conditions'=>array('PlacementHistory.user_id = User.id')
                         )
                    )
		),false);

		$users = $this->User->find('all',array(
                    'fields'=>array('User.id, CONCAT(User.first_name," ",User.last_name) as full_name', 'PlacementHistory.shifts'),
                    'conditions'=>array('User.is_deleted'=>'0','PlacementHistory.shifts !='=>'','User.location_id'=>$this->Session->read('locationid')),
                    'order'=>array('User.first_name'=>'ASC','User.last_name'=>'ASC')));

		$this->set(compact(array('users','firstDate','rosterData')));   
                
		/*$oldShiftData= $this->Configuration->find('first',array('conditions'=>array('Configuration.name'=>Configure::read('shifts'))));
		$oldShiftData['Configuration']['value'] = unserialize($oldShiftData['Configuration']['value']);
		$shiftNames = $oldShiftData['Configuration']['value']['shift_names'];
		$shiftTimes = $oldShiftData['Configuration']['value']['Time'];
		foreach($shiftTimes as $key=>$shiftHours){
			$intime = new DateTime(date('Y-m-d').' '.$shiftHours['start']);
			$outtime = new DateTime(date('Y-m-d').' '.$shiftHours['end']);
			$interval = $intime->diff($outtime);
			$length = ( $interval->i != 0 ) ? (int) $interval->h + 0.5 : $interval->h;
			$shiftLength[strtolower($shiftNames[0][$key])] = $length;
			$shiftRange[strtolower($shiftNames[0][$key])] =  $shiftHours;
		}
		$this->set(compact('shiftLength' , 'shiftRange'));*/
		//$this->set('attendenceData',$this->DutyPlan->calculateAttendance());
	}
	public function test_treeview(){
		$this->layout = 'advance';
	}
	public function month_receipts_reports(){

	}

	public function childSearch($mainArry,$childArry,$keyCnt){//debug($mainArry);debug($childArry);exit;
		$cntOfMainArry=count($mainArry);
		$foundChild=array();
		$childCnt=0;
		for($i=0;$i<$cntOfMainArry;$i++){// child search till end 
			//debug($mainArry);
			if($mainArry[$i]['AccountingGroup']['parent_id']==$childArry['AccountingGroup']['id']){
			//	debug($mainArry[$i]);
				$foundChild[$childCnt]=$mainArry[$i];
				$childCnt++;
			}
		}
		if(!empty($foundChild)){
			$nodeArry[$keyCnt]=$foundChild;
			$cntfirstChild=count($foundChild);
			/*foreach ($foundChild as $keyChild => $firstLevelChild) {debug($firstLevelChild);exit;
				$this->childSearch($mainArry,$firstLevelChild,$firstLevelChild['AccountingGroup']['name']);
			}*/
			return $nodeArry;
		}else{
			return '0';
		}
	}

	// recursive function to create multilevel menu list, $parentId 0 is the Root
		function multilevelMenu($parentId,$accountingGroupList=array(), $ledgerArr=array(),$getAccountingGroupName=array(),$groupeExpIncData=array(),$flagAccountType=null,$recurciveBalParent,$totalGroup) {			
			
		  $html = '';       // stores and returns the html code with Menu lists

		  // if parent item with child IDs in accountingGroupList
		  	if(isset($accountingGroupList[$parentId])) {
		    	//$html = '<ul>';    // open UL

			    // traverses the array with child IDs of current parent, and adds them in LI tags, with their data from $ledgerArr	
			   	   
			    foreach ($accountingGroupList[$parentId] as $childId) {
			    	if($flagAccountType==Configure::read('income_label') || $flagAccountType==Configure::read('indirect_income_label')){
				    	if(!empty($groupeExpIncData[$childId]['income_debit'])){
							$totalAmtArr[$childId]=$groupeExpIncData[$childId]['income_debit'];
						}else{
							$totalAmtArr[$childId]=$groupeExpIncData[$childId]['income_credit'];
						}	
					}
					if($flagAccountType==Configure::read('expense_label') || $flagAccountType==Configure::read('indirect_expenses_label')){
				    	if(!empty($groupeExpIncData[$childId]['debit'])){
							$totalAmtArr[$childId]=$groupeExpIncData[$childId]['debit'];
						}else{
							$totalAmtArr[$childId]=$groupeExpIncData[$childId]['credit'];
						}	
					}
						
					
					if($parentId==0){						
		    			$totalGroup=0;
		    			$parentHeadId[$cnt-1]=$childId;
		    			 $cnt=0;	
		    		}
		    		
					$totalGroup=$totalGroup+$totalAmtArr[$childId];	
					debug($totalGroup.'+++'.$childId);				
					$totalGroupAmt[$parentHeadId]=$totalGroup;
					/*if($totalAmtArr[$childId]==0){
						$totalAmtArr[$childId]=$recurciveBalParent[$childId];
					}*/
					

					/*if($parentId==0){
						debug($totalGroup);
						$totalAmtArr[$childId]=$totalGroup;
		    		}*/
					
					$totalAmtShowArr[$childId] = number_format($totalAmtArr[$childId], 2);
						foreach($ledgerArr[$childId] as $key=>$ledger){	
				      		if($flagAccountType==Configure::read('income_label') || $flagAccountType==Configure::read('indirect_income_label')){   		
					      		if(!empty($ledger['income_debit'])){
									$totalLedgerAmtArr[$key]=$ledger['income_debit'];
								}else{
									$totalLedgerAmtArr[$key]=$ledger['income_credit'];
								}
							}
							if($flagAccountType==Configure::read('expense_label') || $flagAccountType==Configure::read('indirect_expenses_label')){if(!empty($ledger['debit'])){
									$totalLedgerAmtArr[$key]=$ledger['debit'];
								}else{
									$totalLedgerAmtArr[$key]=$ledger['credit'];
								}
							}
							//$groupTotal=$groupTotal+$totalLedgerAmtArr[$key];
							$totalAmtLedgerShowArr[$key] = number_format($totalLedgerAmtArr[$key], 2);
						    							      
				  		}//EOF foreach of ledger $ledgerArr[$childId]
			  		$html .= $this->multilevelMenu( $childId, $accountingGroupList, $ledgerArr, $getAccountingGroupName,$groupeExpIncData,$flagAccountType,$recurciveBalParent,$totalGroup); 		      		
		      
		    	}
		   	$cnt++;
		  	}

		  return $totalAmtArr;
		} 
		/*
		 * function to get list of payroll revision
		* @author: Swapnil
		* @created : 17.03.2016
		*/
		public function payrollRevision(){
			$this->layout = "advance";
			$this->set('title_for_layout',__(' : Payroll Revision'));
			$this->uses = array('SalaryPayroll','SalaryStatement');
			$this->SalaryStatement->bindModel(array(
					'belongsTo'=>array(
							'SalaryPayroll'=>array(
									'primaryKey'=>'salary_payroll_id'
							),
							'User'=>array(
									'foreignKey'=>false,
									'conditions'=>array(
											'SalaryPayroll.created_by = User.id'
									),
									'type'=>'inner'
							)
					)
			),false);
		
			$results = $this->SalaryStatement->find('all',array(
					'fields'=>array(
							'CONCAT(User.first_name," ",User.last_name) as full_name',
							'SalaryPayroll.from_date, SalaryPayroll.to_date, SalaryPayroll.id, SalaryPayroll.create_time',
							'COUNT(SalaryStatement.user_id) as total_employee',
							'SUM(SalaryStatement.total_earning) as total_earning',
							'SUM(SalaryStatement.total_deduction) as total_deduction'
					),
					'conditions'=>array(
							'SalaryPayroll.is_deleted'=>'0',
							'SalaryStatement.is_deleted'=>'0'
					),
					'group'=>array(
							'SalaryPayroll.id'
					),
					'order'=>array(
							'SalaryPayroll.from_date'=>'DESC'
					)
			));
		
			$this->set(compact('results'));
		}
		/*
		 * function to generate bank statement print
		* @author: Swapnil
		* @created : 17.03.2016
		*/
		public function generateBankStatement($payRollId,$bankId){
			$this->layout = "ajax";
			$this->loadModel('SalaryStatement');
			$results = $this->SalaryStatement->getSalaryBankStatement($payRollId,$bankId);
			$this->set('results',$results);
		}
		
		/*
		 * function to view the payroll
		* @author: Swapnil
		* @created : 19.03.2016
		*/
		public function viewPayroll($payRollId){
			if(empty($payRollId)){
				$this->redirect(array('action'=>'payrollRevision'));
			}
			$this->loadModel('SalaryStatement');
			$this->loadModel('Location');
			$this->set('locations',$this->Location->find('list',array('fields'=>array('name'),'conditions'=>array('Location.is_active'=>1,'Location.is_deleted'=>0))));
			$bankresults = $this->SalaryStatement->getSalaryBankStatement($payRollId,null,$this->request->query['location_id']);
			$cashResults = $this->SalaryStatement->getSalaryCashStatement($payRollId,$this->request->query['location_id']);
			$this->set(compact(array('bankresults','cashResults')));
		}
		
		/*
		 * function to genearet pay slip
		* @params salarystementid
		* @author: Swapnil
		* @created : 19.03.2016
		*/
		
		public function getPaySlip($salaryStatementId){
			$this->layout = "ajax";
			$this->uses = array('DutyRoster','User','Role','EarningDeduction','EmpLeaveBenefit','SalaryStatementDetail','SalaryStatement');
			$this->loadModel('SalaryStatementDetail');
		
			$this->SalaryStatement->bindModel(array(
					'belongsTo'=>array(
							'User'=>array(
									'foreignKey'=>'user_id'
							),
							'Role'=>array(
									'foreignKey'=>false,
									'conditions'=>array(
											'User.role_id = Role.id'
									)
							),
							'Location'=>array(
									'foreignKey'=>false,
									'conditions'=>array(
											'User.location_id = Location.id'
									)
							)
					)
			));
		
			$salaryStatementData = $this->SalaryStatement->read(array(
					'CONCAT(User.first_name," ",User.last_name) as full_name',
					'Role.name',
					'Location.name',
					'SalaryStatement.from_date, SalaryStatement.to_date, SalaryStatement.total_works, SalaryStatement.total_shifts, SalaryStatement.total_leaves'),
					$salaryStatementId);
		
			$this->SalaryStatementDetail->bindModel(array(
					'belongsTo'=>array(
							'EarningDeduction'=>array(
									'foreignKey'=>'earning_deduction_id'
							)
					)
			));
		
			$result = $this->SalaryStatementDetail->find('all',array(
					'fields'=>array(
							'EarningDeduction.name',
							'SalaryStatementDetail.*'
					),
					'conditions'=>array(
							'SalaryStatementDetail.salary_statement_id'=>$salaryStatementId,
							'SalaryStatementDetail.is_deleted'=>'0'
					)
			));
			foreach($result as $key => $val){
				$results[$val['SalaryStatementDetail']['type']][] = $val;
			}
			$this->set(compact(array('results','salaryStatementData')));
		}
		
		/*
		 * function to delete payroll process
		* @author: Swapnil
		* @created : 22.03.2016
		*/
		public function ajaxDeletePayRoll($payRollId){
			$this->autoRender = false;
			$this->loadModel('SalaryPayroll');
			if($this->SalaryPayroll->updateAll(array('SalaryPayroll.is_deleted'=>'1'),array('SalaryPayroll.id'=>$payRollId))){
				echo "true";
			}
		}
		
		public function salarySettlement($salaryPayRollId,$salaryStatementId){
			if(empty($salaryStatementId)) {
				$this->Session->setFlash(__('Could not settle', true));
				$this->redirect(array('action'=>'viewPayroll',$salaryPayRollId));
			}
			$this->autoRender = false;
			$this->loadModel('SalaryStatement');
			$this->uses = array('HrDetail');
			$this->HrDetail->bindModel(array(
					'belongsTo'=>array(
							'User'=>array(
									'type'=>'inner',
									'foreignKey'=>'user_id'
							),
							'Role'=>array(
									'type'=>'inner',
									'foreignKey'=>false,
									'conditions'=>array('User.role_id = Role.id')
							),
							'SalaryStatement'=>array(
									'type'=>'inner',
									'foreignKey'=>false,
									'conditions'=>array(
											'SalaryStatement.user_id = User.id'
									)
							)
					)
			),false);
		
			if($statement == "Bank Statement"){
				$conditions['AND'] = array('HrDetail.account_no IS NOT NULL','HrDetail.bank_id IS NOT NULL');
			}else{
				$conditions[] = 'HrDetail.account_no IS NULL';
			}
		
			$userData = $this->HrDetail->find('first',array(
					'fields'=>array(
							'HrDetail.id, HrDetail.account_no, HrDetail.bank_name, HrDetail.bank_id',
							'Role.id, Role.name',
							'User.id, User.username, CONCAT(User.first_name," ",User.last_name) as full_name, User.is_doctor, User.role_id',
							'SalaryStatement.from_date, SalaryStatement.to_date'
					),
					'conditions'=>array(
							'SalaryStatement.id'=>$salaryStatementId,
							'SalaryStatement.is_deleted'=>'0',
							'Role.name !=' => "Doctor",
							'HrDetail.is_deleted'=>'0',
							'User.is_active'=>'1',
							'User.is_deleted'=>'0'
					)));
		
			if(!empty($userData['HrDetail']['bank_id']) && !empty($userData['HrDetail']['account_no'])){
				$statement = "Bank Statement";
			}else{
				$statement = "Cash Statement";
			}
			$statementId = array_search($statement, Configure::read('salaryStatement'));
		
			if($this->SalaryStatement->deleteEntry($salaryStatementId)){
				if($this->generateStatement($userData, $userData['SalaryStatement']['from_date'], $userData['SalaryStatement']['to_date'], $statementId, $salaryPayRollId)){
					$this->Session->setFlash(__('Payroll rebuilt successfully', true));
					$this->redirect(array('action'=>'viewPayroll',$salaryPayRollId));
				}
			}
		}
		
		/**
		 * function to view doctor share
		 * @author Gaurav Chauriya <gauravc@drmhope.com>
		 */
		public function doctorShare(){
			$this->layout = 'advance';
		}
		
		/**
		 * function to update doctor share
		 * @author Gaurav Chauriya <gauravc@drmhope.com>
		 */
		public function ajaxMonthlyShare($userId,$date,$departmentId){
			$this->layout = false;
			$this->uses = array('DoctorShare','SalaryStatement');
			$firstDateOfMonth = date('Y-m-'.Configure::read('payrollFromDate'), strtotime('-1 month', strtotime($date)));
			$lastDateOfMonth = date('Y-m-'.Configure::read('payrollToDate'), strtotime($date));
			if($this->request->data['DoctorShare']){
				$shareData['DoctorShare'] = $this->DoctorShare->updateShare($this->request->data['DoctorShare']);
			}else{
				$shareData = $this->DoctorShare->find('first',array('conditions'=>array('user_id'=>$userId,'from_date'=>$firstDateOfMonth,'to_date'=>$lastDateOfMonth)));
				$shareData['DoctorShare']['user_id'] = $userId;
				$shareData['DoctorShare']['from_date'] = $firstDateOfMonth;
				$shareData['DoctorShare']['to_date'] = $lastDateOfMonth;
			}
			$this->DoctorShare->bindModel(array('hasOne'=>array('User'=>array('foreignKey'=>false,'conditions'=>array('DoctorShare.user_id = User.id'),'type'=>'inner'))));
			$attendedDoctors = $this->DoctorShare->find('all',array('fields'=>array('User.id','User.department_id','CONCAT(User.first_name," ", User.last_name) as full_name'),
					'conditions'=>array('user_id !='=>$userId,'from_date'=>$firstDateOfMonth,'to_date'=>$lastDateOfMonth)));
			$this->set('attendedDoctors',$attendedDoctors);
			$this->data = $shareData;
			if($this->request->is('post')){
				//$this->ExternalStatementPayment->getPaymentHead($shareData['DoctorShare']);
				$this->set('payrollData',$this->SalaryStatement->getSalaryDetailsOfDoctor($userId, $firstDateOfMonth, $lastDateOfMonth,$departmentId));
			}
		}
		
		public function getAjaxPayrollDetail($date){
			$this->layout = "ajax";
			$this->uses = array('DutyRoster','SalaryPayroll','SalaryStatement');
			$returnArray  = array();
		
			$this->SalaryStatement->bindModel(array(
					'belongsTo'=>array(
							'SalaryPayroll'=>array(
									'primaryKey'=>'salary_payroll_id'
							)
					)
			),false);
		
			$conditions['SalaryPayroll.from_date'] = date('Y-m-'.Configure::read('payrollFromDate'), strtotime('-1 month', strtotime($date)));
			$conditions['SalaryPayroll.to_date'] = date('Y-m-'.Configure::read('payrollToDate'), strtotime($date));
		
			$result = $this->SalaryStatement->find('all',array(
					'fields'=>array(
							'SalaryPayroll.from_date, SalaryPayroll.to_date, SalaryPayroll.id, SalaryPayroll.create_time',
							'SalaryStatement.salary_type',
							'COUNT(SalaryStatement.user_id) as total_employee',
							'SUM(SalaryStatement.total_earning) as total_earning',
							'SUM(SalaryStatement.total_deduction) as total_deduction'
					),
					'conditions'=>array(
							//'MONTH(SalaryPayroll.from_date)'=>date("m",  strtotime($date)),
							$conditions,
							'SalaryPayroll.is_deleted'=>'0',
							'SalaryStatement.is_deleted'=>'0'
					),
					'group'=>array(
							'SalaryPayroll.id',
							'SalaryStatement.salary_type'
					)
			));
		
			foreach($result as $key => $val){
				$returnArray[$val['SalaryPayroll']['id']]['SalaryPayroll'] = $val['SalaryPayroll'];
				$returnArray[$val['SalaryPayroll']['id']][$val['SalaryStatement']['salary_type']] = $val[0];
			}
			$this->set(compact('returnArray'));
		}
		
		/**
		 *
		 */
		public function searchInHouseDoctor(){
			$this->uses = array('User');
			$this->User->unbindModel(array('belongsTo'=>array('City','State','Country','Role','Initial')));
			$inhouseDoctors = $this->User->find('all',array('fields'=>array('id','full_name','department_id'),
					'conditions'=>array('is_doctor'=>1,'is_active'=>1,'paid_through_system'=>1,'attendance_track_system'=>1,'is_deleted'=>0,
							'OR'=>array('first_name like'=>$this->params->query['term'].'%','last_name like'=>$this->params->query['term'].'%'))));
			foreach($inhouseDoctors As $key=>$value){
				$doctor[] = array('id'=>$value['User']['id'],'value'=>$value['User']['full_name'],'department_id'=>$value['User']['department_id']);
			}#debug($inhouseDoctors);
			echo json_encode($doctor);
			exit;
		}
		
		/*
		 * function to generate the salary
		* @author : Swapnil
		* @created : 09.03.2016
		*/
		public function generateStatement($userDetails, $fromDate, $toDate ,$statement,$salaryPayRollId){
			$this->loadModel('SalaryStatement');
			$this->loadModel('SalaryStatementDetail');
			$getEarningDeductionDetails = array();
		
			//get all attendance details of current user
			$attendanceDetail = $this->getAllAttendanceDetail($userDetails['User']['id'],$fromDate,$toDate);
		
			//get any paid leaves (leaves type wise) of current user
			$paidLeaves = $this->getPaidLeave($userDetails['User']['id'], $fromDate, $toDate);
		
			//get count of leaves
			$LeavesTaken = $this->getLeaveTypeCount($paidLeaves);
			 
			//total Leaves taken of all leave types
			$totalLeaveTaken = array_sum($LeavesTaken);
		
			//get total lates days
			$totalLateDay = $this->getTotalLateDays($attendanceDetail['worksDetail']['total_late']);
			 
			//get count of holidays in current month
			$holidays = count($this->getPublicHolidays($fromDate,$toDate));
		
			//total sundays
			$totalSunday = count($attendanceDetail['worksDetail']['total_sunday']);
		
			//calculate number of working days of current month
			$totalWorkingDays = $attendanceDetail['worksDetail']['total_working_days'] - $totalSunday - $holidays;
		
			//calculate number of working days
			$totalHeWorksDay = ($attendanceDetail['worksDetail']['total_shift'] + $totalLeaveTaken + $attendanceDetail['worksDetail']['total_paid_off']) /*- $totalLateDay*/ ;
		
			//get salary Details (Earning and deduction) of current user
			//if($userDetails['Role']['name'] != "Doctor"){
		
			//for all non-doctor 'OR' DMO Doctors only
			$salaryDetails = $this->getSalaryDetailsOfNonDoctor($userDetails,$fromDate,$toDate);
			if(!empty($salaryDetails)){
				$getEarningDeductionDetails = $this->getSalaryEarningDeductionAmount($userDetails, $salaryDetails, $totalWorkingDays, $totalHeWorksDay);
			}
			if(!empty($getEarningDeductionDetails['Earning']['Basic']['id'])){
		
				//Transaction begin
				$ds = $this->SalaryStatement->getDataSource(); //creating dataSource object
				$ds->begin();
				$errorNotExist = false;
		
				$saveData['salary_payroll_id'] = $salaryPayRollId;
				$saveData['user_id'] = $userDetails['User']['id'];
				$saveData['created_by'] = $this->Session->read('userid');
				$saveData['from_date'] = $fromDate;
				$saveData['to_date'] = $toDate;
				$saveData['salary_type'] = $statement;
				$saveData['total_works'] = $attendanceDetail['worksDetail']['total_works_days'];
				$saveData['total_shifts'] = $attendanceDetail['worksDetail']['total_shift'];
				$saveData['total_leaves'] = $totalLeaveTaken;
		
				$this->SalaryStatement->id = '';
				if($this->SalaryStatement->save($saveData)){
					$errorNotExist = true;
					$salaryStatementId = $this->SalaryStatement->id;
				}
				$savedDetailsError = false;
				if ($errorNotExist) {
					foreach($getEarningDeductionDetails as $key => $earnDeduVal){
						if($savedDetailsError == true){
							break;
						}
						$tdsId = '';
						foreach($earnDeduVal as $edKey => $val){
							if($edKey === "TDS as %"){
								$tdsId = $val['id'];
							}
							if($key == "Earning"){
								$saveSalaryDetail['type'] = '1';
							}else{
								$saveSalaryDetail['type'] = '2';
							}
							$saveSalaryDetail['salary_statement_id'] = $salaryStatementId;
							$saveSalaryDetail['earning_deduction_id'] = $val['id'];
							$saveSalaryDetail['amount'] = $val['day_amount'];
		
							if($this->SalaryStatementDetail->saveAll($saveSalaryDetail)){
								$updateData[$key] += $val['day_amount'];
							} else {
								$savedDetailsError == true;
								break;
							}
						}
					}
					//update TDS for gross earning
					if($userDetails['HrDetail']['employee_type'] === "On-roll"){
						if(!empty($userDetails['HrDetail']['pan'])){
							$tdsPer = 10;
						}else{
							$tdsPer = 20;
						}
						$tdsAmount = ($updateData['Earning'] * $tdsPer) / 100;
					}else{
						$tdsAmount = 0;
					}
					if(!empty($tdsId)){
						$this->SalaryStatementDetail->updateAll(array('SalaryStatementDetail.amount'=>$tdsAmount),
							array('SalaryStatementDetail.salary_statement_id'=>$salaryStatementId,'SalaryStatementDetail.type'=>'2','SalaryStatementDetail.earning_deduction_id'=>$tdsId));
					}
					$this->SalaryStatement->updateAll(array('total_earning'=>$updateData['Earning'],'total_deduction'=>($updateData['Deduction']+$tdsAmount)),array('id'=>$salaryStatementId));
				}
		
				if($savedDetailsError == false){
					//commit trnasaction
					$ds->commit();
				} else{
					//rollback trnasaction
					$ds->rollback();
					return false;
				}
			}
			return true;
		}
		/*
		 * function to generate the salary statement of both bank statement and cash statement
		* @author : Swapnil
		* @created : 09.03.2016
		*/
		public function ajaxGenearatePayRoll($date){
			$this->layout = "ajax";
			$this->autoRender = false;
			$this->uses = array('User','HrDetail','SalaryPayroll','SalaryStatement');
			$saveData = array();
		
			$this->request->data['from_date'] = date('Y-m-'.Configure::read('payrollFromDate'), strtotime('-1 month', strtotime($date)));
			$this->request->data['to_date'] = date('Y-m-'.Configure::read('payrollToDate'), strtotime($date));
		
			if(!empty($this->request->data)){
				if(!empty($this->request->data['from_date'])){
					//$fromDate = $this->DateFormat->formatDate2STD($this->request->data['from_date'],Configure::read('date_format'));
					$fromDate = $this->request->data['from_date'];
				}
				if(!empty($this->request->data['to_date'])){
					//$toDate = $this->DateFormat->formatDate2STD($this->request->data['to_date'],Configure::read('date_format'));
					$toDate = $this->request->data['to_date'];
				}
		
				$saveData['from_date'] = $fromDate;
				$saveData['to_date'] = $toDate;
				$saveData['created_by'] = $this->Session->read('userid');
				$saveData['create_time'] = date("Y-m-d H:i:s");
		
				//Transaction begin
				$ds = $this->SalaryPayroll->getDataSource(); //creating dataSource object
				$ds->begin();
		
				if($this->SalaryPayroll->save($saveData)){
					$lastInsertedID = $this->SalaryPayroll->id;
					$generateBankStatement = $this->generateSalary("Bank Statement",$fromDate,$toDate,$lastInsertedID);
					$generateCashStatement = $this->generateSalary("Cash Statement",$fromDate,$toDate,$lastInsertedID);
				}
				if($generateBankStatement == true && $generateCashStatement == true){
					$ds->commit();
					echo "true";
				}else{
					$ds->rollback();
				}
			} else{
				echo "false";
			}
		}
		
		/*
		 * function to generate salary statement wise
		*
		*/
		
		public function generateSalary($statement,$fromDate,$toDate,$salaryPayRollId){
			$statementId = array_search($statement, Configure::read('salaryStatement'));
			$this->loadModel('Role');
			$this->loadModel('Department');
			$doctorRoleId = $this->Role->getDoctorId();
			$DMOdeptId = array_keys($this->Department->getDeptByName("DMO"));
		
			$this->uses = array('HrDetail');
			$this->HrDetail->bindModel(array(
					'belongsTo'=>array(
							'User'=>array(
									'type'=>'inner',
									'foreignKey'=>'user_id'
							),
							'PlacementHistory'=>array(
									'foreignKey'=>false,
									'type'=>'inner',
									'conditions'=>array('PlacementHistory.user_id = User.id')
							),
							'DoctorProfile'=>array(
									'type'=>'left',
									'foreignKey'=>false,
									'conditions'=>array(
											'DoctorProfile.user_id = User.id'
									)
							),
							'Department'=>array(
									'foreignKey'=>false,
									'conditions'=>array(
											'DoctorProfile.department_id = Department.id'
									)
							),
							'Role'=>array(
									'type'=>'inner',
									'foreignKey'=>false,
									'conditions'=>array('User.role_id = Role.id')
							)
					)
			),false);
		
			if($statement == "Bank Statement"){
				$conditions['AND'] = array('HrDetail.account_no IS NOT NULL','HrDetail.bank_id IS NOT NULL');
			}else{
				$conditions[] = 'HrDetail.account_no IS NULL';
			}
			$conditions['OR'] = array(
					'Role.id != '=>$doctorRoleId,
					'AND'=>array(
							'Role.id'=>$doctorRoleId,
							'DoctorProfile.department_id'=>$DMOdeptId
					)
			);
			$userData = $this->HrDetail->find('all',array(
					'fields'=>array(
							'HrDetail.id, HrDetail.account_no, HrDetail.bank_name, HrDetail.pan, HrDetail.employee_type, HrDetail.pay_application_date',
							'Role.id, Role.name',
							'DoctorProfile.department_id',
							'Department.name',
							'User.id, User.username, CONCAT(User.first_name," ",User.last_name) as full_name, User.is_doctor, User.role_id'
					),
					'conditions'=>array(
							$conditions,
							//'Role.name !=' => "Doctor",
							'PlacementHistory.shifts !='=>'',
							'HrDetail.is_deleted'=>'0',
							'User.is_active'=>'1',
							'User.is_deleted'=>'0'
					)));
			$isAllRight = true;
			foreach ($userData as $key => $userDetails){
				$result = $this->generateStatement($userDetails,$fromDate, $toDate,$statementId , $salaryPayRollId);
				if($result == false){
					$isAllRight = false;
					break;
				}
			}
			if($isAllRight == true){
				return true;
			}else{
				return false;
			}
		}
		/*
		 * function to return all the attendance Details
		* @return : (no of working days, no of days he/she works, number of lates comes with date and late times)
		* @author : Swapnil
		* @created : 05.03.2016
		*/
		public function getAllAttendanceDetail($user_id,$fromDate,$toDate){
		
			$this->uses = array('DutyRoster','Shift');
			$dailyRosterData = $this->DutyRoster->find('all',array(
					'conditions'=>array(
							'OR'=>array('DutyRoster.day_off IS NOT NULL'),
							'DutyRoster.user_id'=>$user_id,'DutyRoster.date BETWEEN ? AND ?'=>array($fromDate,$toDate),
							'OR'=>array('DutyRoster.intime IS NOT NULL','DutyRoster.outime IS NOT NULL'),
					),
					'fields'=>array('DutyRoster.id, DutyRoster.user_id, DutyRoster.date, DutyRoster.inouttime, DutyRoster.shift, DutyRoster.day_off, DutyRoster.is_present, DutyRoster.intime, DutyRoster.outime, DutyRoster.remark')));
			 
			$time['total_working_days'] = $this->DateFormat->getNoOfDays($fromDate,$toDate);
			$time['total_works_days'] = count($dailyRosterData);
			$shiftData = $this->Shift->getAllShiftDetails();
		
			foreach ($shiftData as $key => $val){
				$shiftDetails[$val['Shift']['id']] = $val['Shift'];
			}
		
			foreach ($dailyRosterData as $key => $val){
				$returnArray[$key]['date'] = $val['DutyRoster']['date'];
				$returnArray[$key]['name'] = $shiftDetails[$val['DutyRoster']['shift']]['name'];
				$time['total_shift'] += $shiftDetails[$val['DutyRoster']['shift']]['shift_count'];
				$time['total_paid_off'] += $val['DutyRoster']['day_off'] === "OFF" ? '1' : '0';
				$returnArray[$key]['working_time'] = $totalAllotTime[] = $this->DateFormat->getTimeDifference($shiftDetails[$val['DutyRoster']['shift']]['from_time'],$shiftDetails[$val['DutyRoster']['shift']]['to_time']);
				$returnArray[$key]['in_time'] =  $inTime = $val['DutyRoster']['intime'];
				$returnArray[$key]['out_time'] =  $outTime = $val['DutyRoster']['outime'];
				$returnArray[$key]['remark'] =  $val['DutyRoster']['remark'];
				$totalWorksTime[] = $returnArray[$key]['totalHeWork'] = $worksHour = $this->DateFormat->getTimeDifference($inTime,$outTime);
				$totalLateTime[] = $returnArray[$key]['lateHour'] = $lateHours = $this->DateFormat->getTimeDifference($shiftDetails[$val['DutyRoster']['shift']]['from_time'],$inTime);
				if($lateHours>0.15){
					$dayLateMoreThan15Min[$val['DutyRoster']['date']] = $lateHours;
				}
			}
			$sundayArrList = $this->DateFormat->getDateForSpecificDayBetweenDates($fromDate,$toDate, 0);
			$time['total_late'] = $dayLateMoreThan15Min;
			$time['total_sunday'] = $sundayArrList;
			$time['total_time_has_to_work'] = $this->DateFormat->getTotalTime($totalAllotTime);
			$time['total_time_came_late'] = $this->DateFormat->getTotalTime($totalLateTime);
			$time['total_time_work'] = $this->DateFormat->getTotalTime($totalWorksTime);
		
			return array('worksDetail'=>$time,'allData'=>$returnArray);
		}
		
		/*
		 * function to return the number of paid leaves
		* @author : Swapnil
		* @created : 09.03.2016
		*/
		public function getPaidLeave($user_id, $fromDate, $toDate){
			$this->loadModel('LeaveApproval');
			$leaveData = $this->LeaveApproval->find('all',array(
					'fields'=>array(
							'LeaveApproval.leave_from','LeaveApproval.leave_type'
					),
					'conditions'=>array($conditions,
							//'MONTH(LeaveApproval.leave_from)'=>date("m",  strtotime($date)),
							'LEaveApproval.leave_from BETWEEN ?AND?'=>array($fromDate, $toDate),
							'LeaveApproval.user_id'=>$user_id,
							'LeaveApproval.is_deleted'=>'0',
							'LeaveApproval.is_approved'=>'1')
			));
			foreach($leaveData as $key => $val){
				$returnArr[$val['LeaveApproval']['leave_type']][] = $val['LeaveApproval']['leave_from'];
			}
			return $returnArr;
		}
		
		/*
		 * function to return the number of count
		* @author : Swapnil
		* @created : 09.03.2016
		*/
		public function getLeaveTypeCount($leaves=array()){
			foreach($leaves as $key => $val){
				$returnArr[$key] = count($val);
			}
			return $returnArr;
		}
		
		/*
		 * function to calculate total late days
		* @params - array of lates
		* @author : Swapnil
		* @created : 11.03.2016
		*/
		public function getTotalLateDays($latesArray){
			$totalLateDay = 0;
			if(count($latesArray)>=Configure::read('graceLeave')){
				//deduct grace leave of two days
				$totalLate = count($latesArray) - Configure::read('graceLeave');
				if($totalLate > 0){
					$totalLateDay = $totalLate * Configure::read('perDayDeduction');   //deduct 1/4th per day
				}
			}
			return $totalLateDay;
		}
		
		/*
		 * function to return the public holidays of current month
		* @return (date with holiday)
		* @author : Swapnil
		* @created : 06.03.2016
		*/
		public function getPublicHolidays($fromDate,$toDate){
			$this->loadModel('Configuration');
			$holidayData = $this->Configuration->find('first',array(
					'fields'=>array('Configuration.value'),
					'conditions'=>array('Configuration.name'=>"Holiday")));
			$holiday = unserialize($holidayData['Configuration']['value']);
		
			list($fromYear,$fromMonth,$fromDate) = explode("-", $fromDate);
			list($toYear,$toMonth,$toDate) = explode("-", $toDate);
		
			foreach($holiday[$fromYear]['PH'][$fromMonth] as $fKey => $fVal){
				if($fromDate<=$fKey){
					$returnArray[$fromYear."-".$fromMonth."-".$fKey] = trim($fVal);
				}
			}
			foreach($holiday[$toYear]['PH'][$toMonth] as $tKey => $tVal){
				if($toDate>=$tKey){
					$returnArray[$toYear."-".$toMonth."-".$tKey] = trim($tVal);
				}
			}
		
			return $returnArray;
		}
		/*
		 * function to get the earning deduction head amount
		* @return (head wise amount)
		* @author : Swapnil
		* @created : 06.03.2016
		*/
		public function getSalaryDetailsOfNonDoctor($userDetail,$fromDate,$toDate){
			$this->uses = array('EmployeePayDetail');
			$currentDate = $this->getAppliedHeadDate($userDetail,$fromDate,$toDate);
		
			$this->EmployeePayDetail->bindModel(array(
					'belongsTo'=>array(
							'EarningDeduction'=>array(
									'foreignKey'=>false,
									'conditions'=>array(
											'EarningDeduction.id = EmployeePayDetail.earning_deduction_id'
									)
							)
					)
			));
		
			$data = $this->EmployeePayDetail->find('all',array(
					'fields'=>array(
							'EarningDeduction.id, EarningDeduction.type, EarningDeduction.name, EarningDeduction.payment_mode, EarningDeduction.statutory_treatement',
							'EmployeePayDetail.day_amount, EmployeePayDetail.night_amount'
					),
					'conditions'=>array(
							'EmployeePayDetail.user_id'=>$userDetail['User']['id'],'EmployeePayDetail.is_applicable'=>'1','EmployeePayDetail.is_deleted'=>'0',
							'EarningDeduction.type'=>'Earning',
							'EmployeePayDetail.pay_application_date'=>$currentDate
					)
			));
			$BasicFlexAmnt = 0;
			$returnArray = array();
			$deductionResult = array();
			foreach($data as $key => $val){
				//for ESI Deduction i.e 1.75% of (total Basic + Flexible Pay).
				if(trim($val['EarningDeduction']['name']) == "Basic" || trim($val['EarningDeduction']['name']) == "Flexible Pay"){
					if(trim($val['EarningDeduction']['name']) == "Basic"){
						$basicAmount = $val['EmployeePayDetail']['day_amount'];
					}
					$BasicFlexAmnt += $val['EmployeePayDetail']['day_amount'];
				}
				$returnArray[$val['EarningDeduction']['type']][$val['EarningDeduction']['name']] = array(
						'id'=>$val['EarningDeduction']['id'],
						'day_amount'=>$val['EmployeePayDetail']['day_amount'],
						'statutory_treatement'=>$val['EarningDeduction']['statutory_treatement'],
						'payment_mode'=>$val['EarningDeduction']['payment_mode'],
						'night_amount'=>$val['EmployeePayDetail']['night_amount'] );
		
				if(!empty($val['EarningDeduction']['statutory_treatement'])){
					$deductionResult[] = $this->getDeductionOfEarningHead($userDetail['User']['id'],$val['EmployeePayDetail']['day_amount'],$val['EarningDeduction']['payment_mode'],
							explode(",",$val['EarningDeduction']['statutory_treatement']));
				}
			}
		
			foreach ($deductionResult as $key => $dedArray){
				foreach($dedArray as $mkey => $val){
					$temp[$mkey]['value'] += $val['day_amount'];
					$returnArray['Deduction'][$mkey] = array(
							'id'=>$val['id'],
							'day_amount'=>$temp[$mkey]['value']
					);
				}
			}
			//overwrite ESI Deduction to 4.75% of total Basic + Flexible Pay
			if(!empty($returnArray['Deduction']['ESI as %']) && $userDetail['HrDetail']['employee_type'] == "On-roll"){
				$returnArray['Deduction']['ESI as %']['day_amount'] = ($BasicFlexAmnt * 4.75)/100;
			}else{
				$returnArray['Deduction']['ESI as %']['day_amount'] = 0;
			}
			//overwrite PF Deduction to 12% of total Gross Earning
			if(!empty($returnArray['Deduction']['PF AS %']) && $userDetail['HrDetail']['employee_type'] == "On-roll"){
				$returnArray['Deduction']['PF AS %']['day_amount'] = ($basicAmount * 12)/100;
			}else{
				$returnArray['Deduction']['PF AS %']['day_amount'] = 0;
			}
			if(isset($returnArray['Deduction']['TDS as %'])){
				$returnArray['Deduction']['TDS as %']['day_amount'] = 0;
			}
			return $returnArray;
		}
		/*
		 * function to return the applied earning-deduction head
		* @params: dates[]
		* @return: applied date
		* @author: Swapnil
		* @created: 06.04.2016
		*/
		public function getAppliedHeadDate($userDetail,$fromDate,$toDate){
			$this->uses = array('EmployeePayDetail');
			$empDates = $this->EmployeePayDetail->find('list',array(
					'fields'=>array('EmployeePayDetail.pay_application_date'),
					'conditions'=>array(
							'EmployeePayDetail.user_id'=>$userDetail['User']['id']
					),
					'group'=>array(
							'EmployeePayDetail.pay_application_date'
					)
			));
			foreach($empDates as $key => $val){
				//debug(($fromDate) ." >= ". ($val) ." && ". ($val) ." <= ". ($toDate) );
				if(strtotime($fromDate) >= strtotime($val) && strtotime($val) <= strtotime($toDate)){
					$ret = $val;
				}
			}
			return $ret;
		}
		/*
		 * function to get the deduction of earning head
		* @author : Swapnil
		* @created : 28.03.2016
		*/
		
		public function getDeductionOfEarningHead($user_id,$amount,$mode,$deductionIds){
			$this->uses = array('EmployeePayDetail');
			$this->loadModel('EarningDeduction');
			$this->EarningDeduction->bindModel(array(
					'belongsTo'=>array(
							'EmployeePayDetail'=>array(
									'foreignKey'=>false,
									'type'=>'inner',
									'conditions'=>array(
											'EmployeePayDetail.earning_deduction_id = EarningDeduction.id'
									)
							)
					)
			));
		
			$results = $this->EarningDeduction->find('all',array(
					'fields'=>array('EmployeePayDetail.day_amount','EarningDeduction.id, EarningDeduction.type, EarningDeduction.payment_mode, EarningDeduction.name'),
					'conditions'=>array('EarningDeduction.id'=>$deductionIds,'EmployeePayDetail.user_id'=>$user_id)));
		
			foreach($results as $key => $val){
				$deduction_amount = $val['EmployeePayDetail']['day_amount'];
				if($val['EarningDeduction']['payment_mode'] == "Percentage"){
					//calculate percentage
					$deduction_amount = ($amount * $deduction_amount)/100;
				}
				$returnArray[$val['EarningDeduction']['name']] = array(
						'id'=>$val['EarningDeduction']['id'],
						'day_amount'=>$deduction_amount
				);
			}
			return $returnArray;
		}
		/*
		 * function to calculate salary amount from basic salary
		* @author : Swapnil
		* @created : 09.03.2016
		*/
		
		public function getSalaryEarningDeductionAmount($userDetails, $salaryDetails, $totalWorkingDays, $totalHeWorksDay){
			 
			//basic Salary of month
			$basicSalary = $salaryDetails['Earning']['Basic']['day_amount'];
		
			//get per day basic amount from basic salary
			$basicAmount = $this->getSingleDayBasicAmount($basicSalary,$totalWorkingDays);
		
			//calculate total earning
			$earningAmount = $basicAmount * $totalHeWorksDay;
		
			$salaryDetails['Earning']['Basic']['day_amount'] = round($earningAmount,2);
		
			//debug($userDetails[0]['full_name'].",".$basicSalary.",".$basicAmount."+". $earningAmount."=".$totalHeWorksDay);
		
			//calculate Deduction Amount
			//$salaryDetails['Deduction'] = $this->deductionAmount($userDetails,$salaryDetails['Deduction'],$basicSalary);
		
			return $salaryDetails;
		}
		
		/*
		 * function to calculate per day amount
		* @params - amount, number_of_days
		* @author : Swapnil
		* @created : 11.03.2016
		*/
		
		public function getSingleDayBasicAmount($amount,$days){
			return round(($amount/$days),2);
		}
		
		/*
		 * function to calculate deduction amount from basic salary according to role
		* @author : Swapnil
		* @created : 09.03.2016
		*/
		public function deductionAmount($userDetails,$deductions,$amount){
			$total = 0;
			foreach($deductions as $key => $val){
				switch($key){
					case 'PF AS %':
						$result = $amount * 0.12;
						break;
		
					case 'ESI as %':
						$result = $amount * 0.065;
						break;
		
					case 'TDS as %':
						if($amount>=25000){
							if(!empty($userDetails['HrDetail']['pan'])){
								$result = $amount * 0.10;
							}else{
								$result = $amount * 0.20;
							}
						}else{
							$result = 0;
						}
						break;
		
					default:
						$result = $amount * 0.02;
						break;
				}
				$deductions[$key] = $val;
				$deductions[$key]['day_amount'] = round($result,2);
			}
			return $deductions;
		}

		public function balanceSheetStatement($type=null){
		$this->layout = 'advance';
		$this->set('flag',$this->request->query['flag']);	
		if($type=='excel'){		 			
			$this->balanceSheetReport();
			$this->autoRender = false;					
			$this->layout = false ;
			$this->render('balance_sheet_report_xls');		
		}	
		if($type=='print'){				
			$this->request->data = $this->params->query ;
			$this->balanceSheetReport();
			$this->layout = false;
			$this->render('balance_sheet_report_print');	
		}
		if($type=='printGroup'){				
			$this->request->data = $this->params->query ;
			$this->balanceSheetReport();
			$this->layout = false;
			$this->render('balance_sheet_report_group_print');	
		}
	}

	/**
	 * function to calculate Profit Loss Report
	 * @author Mahalaxmi
	 */
	public function balanceSheetReport(){
		//Configure::write('debug',2) ;
		ob_end_clean();
		ob_start("ob_gzhandler");
		$this->layout=false;				
		$this->uses=array('AccountingGroup','VoucherEntry','AccountReceipt','Account','VoucherPayment','ContraEntry','VoucherLog');		
		$locationId = $this->Session->read('locationid');
		$getLocName=$this->Session->read('location_name');
		$getLocAdd1=$this->Session->read('location_address1');
		$getLocAdd2=$this->Session->read('location_address2');
		$location_zipcode=$this->Session->read('location_zipcode');
		$location_country=$this->Session->read('location_country');	
	
		$getAccountingGroupDataAll=$this->AccountingGroup->getAllGroupDetails($this->Session->read('locationid'),Configure::read('balancesheet_group_type'));	
	 	#debug($getAccountingGroupDataAll);
		foreach ($getAccountingGroupDataAll as $key => $value) {
			$getAccountingGroupDataIdWise[$value['AccountingGroup']['id']]=$value;
			$getAccountingGroupId[$value['AccountingGroup']['id']]=$value['AccountingGroup']['id'];	
			$accountingGroupList[$value['AccountingGroup']['parent_id']][] = $value['AccountingGroup']['id'];			
			if($value['AccountingGroup']['account_type']==Configure::read('asset_label')  || empty($value['AccountingGroup']['account_type'])){ 
				$accountingGroupListIncome[$value['AccountingGroup']['parent_id']][] = $value['AccountingGroup']['id'];
			}
			if($value['AccountingGroup']['account_type']==Configure::read('liability_label')  || empty($value['AccountingGroup']['account_type'])){ 
				$accountingGroupListExpense[$value['AccountingGroup']['parent_id']][] = $value['AccountingGroup']['id'];
			}
			if($value['AccountingGroup']['name']==Configure::read('liability_label') || empty($value['AccountingGroup']['account_type'])){			
				$accountingGroupListIndirectExpense[$value['AccountingGroup']['parent_id']][] = $value['AccountingGroup']['id'];
			}
			if($value['AccountingGroup']['name']==Configure::read('asset_label') || empty($value['AccountingGroup']['account_type'])){
				$accountingGroupListIndireactIncome[$value['AccountingGroup']['parent_id']][] = $value['AccountingGroup']['id'];
			}
			
			$getAccountingGroupName[$value['AccountingGroup']['id']]=$value['AccountingGroup']['name'];			
		}
		asort($getAccountingGroupName);
		#debug($accountingGroupList);
		#debug($getAccountingGroupName);

		
		$this->set(compact('accountingGroupListIncome','accountingGroupListExpense','accountingGroupListIndirectExpense','accountingGroupListIndireactIncome'));
		
		if(!empty($this->request->data['from_date']) && !empty($this->request->data['to_date'])){
			$from=$this->request->data['from_date'];
			$fromDate=$this->DateFormat->formatDate2STDForReport($this->request->data['from_date'],Configure::read('date_format'))." 00:00:00";
			$to=$this->request->data['to_date'];
			$toDate=$this->DateFormat->formatDate2STDForReport($this->request->data['to_date'],Configure::read('date_format'))." 23:59:59";		
		}
		$journalArray = $this->VoucherEntry->getJournalData($fromDate,$toDate,$this->Session->read('locationid'),$getAccountingGroupId,Configure::read('balance_sheet_statement'));
		$receiptArray = $this->AccountReceipt->getReceiptData($fromDate,$toDate,$this->Session->read('locationid'),$getAccountingGroupId,Configure::read('balance_sheet_statement'));
   		$paymentArray = $this->VoucherPayment->getPaymentData($fromDate,$toDate,$this->Session->read('locationid'),$getAccountingGroupId,Configure::read('balance_sheet_statement'));
  	 	$contraArray = $this->ContraEntry->getContraData($fromDate,$toDate,$this->Session->read('locationid'),$getAccountingGroupId,Configure::read('balance_sheet_statement'));
  		
		$commanArr=array_merge($journalArray['0'],$journalArray['1'],$receiptArray['0'],$receiptArray['1'],$paymentArray['0'],$paymentArray['1'],$contraArray['0'],$contraArray['1']);
		#debug($commanArr);exit;
		$returnArr=array();		
		$finalExpenseInnerArray=array();
		$finalIncomeInnerArray=array();
		foreach ($commanArr as $key => $value) {	
			$refineArr[$value['Account']['accounting_group_id']][]=$value;						
			$returnArr[$value['Account']['accounting_group_id']]['acc_group_id']=$value['Account']['accounting_group_id'];	
			$InnerArr[$value['Account']['accounting_group_id']][$value['Account']['id']]['acc_id']=$value['Account']['id'];	
			$InnerArr[$value['Account']['accounting_group_id']][$value['Account']['id']]['acc_group_id']=$value['Account']['accounting_group_id'];	
			$InnerArr[$value['Account']['accounting_group_id']][$value['Account']['id']]['acc_name']=$value['Account']['name'];	

			$finalExpenseInnerArray[$value['Account']['accounting_group_id']][$value['Account']['id']] += round(($value['0']['receiptSumDebit']+$value['0']['paymentSumDebit']+$value['0']['contraSumDebit']+$value['0']['journalSumDebit'])-($value['0']['receiptSumCredit']+$value['0']['paymentSumCredit']+$value['0']['contraSumCredit']+$value['0']['journalSumCredit']));

			/*as discussed with Tushar and Murli Sir - show only payment entries*/
			$finalIncomeInnerArray[$value['Account']['accounting_group_id']][$value['Account']['id']] +=  round(($value['0']['receiptSumCredit']+$value['0']['paymentSumCredit']+$value['0']['contraSumCredit']+$value['0']['journalSumCredit'])-($value['0']['receiptSumDebit']+$value['0']['paymentSumDebit']+$value['0']['contraSumDebit']+$value['0']['journalSumDebit']));

		}	
		
		foreach($finalExpenseInnerArray as $keyExp => $valExp){
  			foreach($valExp as $subExpKey => $expVal){
  				if($expVal >= 0){
  					$returnArr[$keyExp]['debit'] += $expVal;
  					$InnerArr[$keyExp][$subExpKey]['debit'] += $expVal;
  				}else{
  					$returnArr[$keyExp]['credit'] += $expVal;
  					$InnerArr[$keyExp][$subExpKey]['credit'] += $expVal;
  				}
  			}
  		}
  		foreach($finalIncomeInnerArray as $key => $val){
  			foreach($val as $subKey => $mval){
  				if($mval >= 0){
  					$returnArr[$key]['income_debit'] += $mval;
  					$InnerArr[$key][$subKey]['income_debit'] += $mval;
  				}else{
  					$returnArr[$key]['income_credit'] += $mval;
  					$InnerArr[$key][$subKey]['income_credit'] += $mval;
  				}
  			}
  		}


  	
		foreach ($accountingGroupList as $key => $value) {		
			foreach ($value as $subKey => $subValue) {				
				if($getAccountingGroupDataIdWise[$subValue]['AccountingGroup']['account_type']==Configure::read('asset_label') || empty($getAccountingGroupDataIdWise[$subValue]['AccountingGroup']['account_type']) || $getAccountingGroupDataIdWise[$subValue]['AccountingGroup']['name']==Configure::read('asset_label')){					
				    	if(!empty($returnArr[$subValue]['income_debit'])){
							$totalAmt[$subValue]=$returnArr[$subValue]['income_debit'];
						}else{
							$totalAmt[$subValue]=$returnArr[$subValue]['income_credit'];
						}							
							
					$recurciveBalParent[$key] =$recurciveBalParent[$key]+ round($totalAmt[$subValue]);
					$recurciveBalChild[$subValue] =$recurciveBalChild[$subValue]+ round($totalAmt[$subValue]);					
				}  
				if($getAccountingGroupDataIdWise[$subValue]['AccountingGroup']['account_type']==Configure::read('liability_label') || empty($getAccountingGroupDataIdWise[$subValue]['AccountingGroup']['account_type']) || $getAccountingGroupDataIdWise[$subValue]['AccountingGroup']['name']==Configure::read('liability_label')){	
			    	if(!empty($returnArr[$subValue]['debit'])){
						$totalAmt[$subValue]=$returnArr[$subValue]['debit'];
					}else{
						$totalAmt[$subValue]=$returnArr[$subValue]['credit'];
					}						
				$recurciveBalParentExpense[$key] =$recurciveBalParentExpense[$key]+ round($totalAmt[$subValue]);
				$recurciveBalChildExpense[$subValue] =$recurciveBalChildExpense[$subValue]+ round($totalAmt[$subValue]);
				}  
			}			
	  	}
	  	$this->set(compact('recurciveBalParentExpense','recurciveBalChildExpense'));
	
	  	#debug($recurciveBalParent);
	 	#debug($recurciveBalChild);
	  //	exit;
		
		/*$totalGrpSumExp=0;
		$totalGrpSumInc=0;
		$totalGrpSumIndirExp=0;
		$totalGrpSumIndirInc=0;
		foreach($getAccountingGroupDataAll as $keyAccGrp=>$getAccountingGroupData){
			if($getAccountingGroupData['AccountingGroup']['account_type']==Configure::read('expense_label')  && $getAccountingGroupData['AccountingGroup']['name']!=Configure::read('indirect_expenses_label')){ //BOF-For Above Left handside -----Expense----- Side only for expense except Indirect expense and Income type
				if(!empty($returnArr[$getAccountingGroupData['AccountingGroup']['id']]['debit'])){
					$totalGrpSumExp=(int)$totalGrpSumExp+$returnArr[$getAccountingGroupData['AccountingGroup']['id']]['debit'];		
				}else if(!empty($returnArr[$getAccountingGroupData['AccountingGroup']['id']]['credit'])){
					$totalGrpSumExp=(int)$totalGrpSumExp+$returnArr[$getAccountingGroupData['AccountingGroup']['id']]['credit'];	
				}	
			}
			if($getAccountingGroupData['AccountingGroup']['account_type']==Configure::read('income_label')  && $getAccountingGroupData['AccountingGroup']['name']!=Configure::read('indirect_income_label')){ 				
				//BOF-For Below Left handside -----Income------ Side only except expense and Indirect Income
				if(!empty($returnArr[$getAccountingGroupData['AccountingGroup']['id']]['income_debit'])){
					$totalGrpSumInc=(int)$totalGrpSumInc+$returnArr[$getAccountingGroupData['AccountingGroup']['id']]['income_debit'];						
				}else if(!empty($returnArr[$getAccountingGroupData['AccountingGroup']['id']]['income_credit'])){
					$totalGrpSumInc=(int)$totalGrpSumInc+$returnArr[$getAccountingGroupData['AccountingGroup']['id']]['income_credit'];				
				}	
			}
			if($getAccountingGroupData['AccountingGroup']['name']==Configure::read('indirect_expenses_label')){
				//BOF-For Above Right handside ----expense----- Side only except Indirect expense						
				if(!empty($returnArr[$getAccountingGroupData['AccountingGroup']['id']]['debit'])){ 
					$totalGrpSumIndirExp=(int)$totalGrpSumIndirExp+$returnArr[$getAccountingGroupData['AccountingGroup']['id']]['debit'];						
				}else if(!empty($returnArr[$getAccountingGroupData['AccountingGroup']['id']]['credit'])){
					$totalGrpSumIndirExp=(int)$totalGrpSumIndirExp+$returnArr[$getAccountingGroupData['AccountingGroup']['id']]['credit'];				
				}
			}
			if($getAccountingGroupData['AccountingGroup']['name']==Configure::read('indirect_income_label')){ 
				//BOF-For Above Right handside ----Income---- Side only except Indirect income
				if(!empty($returnArr[$getAccountingGroupData['AccountingGroup']['id']]['income_debit'])){ 
					$totalGrpSumIndirInc=(int)$totalGrpSumIndirInc+$returnArr[$getAccountingGroupData['AccountingGroup']['id']]['income_debit'];				
				}else if(!empty($returnArr[$getAccountingGroupData['AccountingGroup']['id']]['income_credit'])){
					$totalGrpSumIndirInc=(int)$totalGrpSumIndirInc+$returnArr[$getAccountingGroupData['AccountingGroup']['id']]['income_credit'];				
				}	
			}
		}*/
	//debug($accountingGroupList['recurciveBalParent']);
	//debug($accountingGroupList['recurciveBalChild']);
		//exit;
		//debug($subgroupArr);
		/*$getGrpSumExp=(int)$totalGrpSumExp+10000; ////10000-For Opening Stock
		$getGrpSumInc=(int)$totalGrpSumInc+10000;////10000-For Closing Stock	
		
		$getGross=(int)$getGrpSumInc-$getGrpSumExp;
	
	
		if($getGross<0){
			//If  Gross Loss
			$getProfitLossFlag=true;			
			$getGrossLoss=(int)$getGrpSumInc-$getGrpSumExp; //**If  Gross Loss				
			///BOF-TOTAL VALUE OF EXPENSE SIDE//
			$getTotalExpExceptIndirExp=(int)$getGrpSumExp;				
			///BOF-TOTAL VALUE OF INCOME SIDE//
			if($getGrossLoss<0){
				$getGrossLoss1=abs($getGrossLoss);
			}
			$getTotalIncExceptIndirInc=(int)$getGrossLoss1+$getGrpSumInc;
			if($getTotalExpExceptIndirExp>$getTotalIncExceptIndirInc){
				$getTotalLossExpExceptIndirExpInc1=$getTotalExpExceptIndirExp;
			}else{
				$getTotalLossExpExceptIndirExpInc1=$getTotalIncExceptIndirInc;
			}
		}else{
			//If  Gross Profit				
			$getProfitLossFlag=false;
			$getGrossProfit=(int)$getGrpSumInc-$getGrpSumExp; //If  Gross Profit
			///BOF-TOTAL VALUE OF EXPENSE SIDE//
			$getTotalExpExceptIndirExp=(int)$getGrossProfit+$getGrpSumExp;				
			///BOF-TOTAL VALUE OF INCOME SIDE//
			$getTotalIncExceptIndirInc=(int)$getGrpSumInc;			
			if($getTotalExpExceptIndirExp>$getTotalIncExceptIndirInc){
				$getTotalProfitExpExceptIndirExpInc1=$getTotalExpExceptIndirExp;
			}else{
				$getTotalProfitExpExceptIndirExpInc1=$getTotalIncExceptIndirInc;
			}
				
		}
		//////EOF-Calculate Gross Profit///////	
		
	
		if($getGross<0){
			$getNetLossFlag=true; //if Net Loss
			$getGrossLoss2=abs($getGrossLoss);
			$getNet=(int)$getGrossLoss2-$totalGrpSumIndirExp+$totalGrpSumIndirInc;
			$getNetLoss=$getNet;				
			$getNetLoss=abs($getNetLoss);		
			//////BOF-Calculate Total Expenses///////
			$getTotalExpense=(int)$getNetLoss+$totalGrpSumIndirExp;	
			//////BOF-Calculate Total Incomes///////
			$getTotalIncomes=(int)$getGrossLoss2+$totalGrpSumIndirInc;
		}else{
			$getNetLossFlag=false; //if Net Profit			
			$getNet=(int)$getGrossProfit-$totalGrpSumIndirExp+$totalGrpSumIndirInc;
			$getNetProfit=$getNet;				
			//////BOF-Calculate Total Expenses//////
			$getTotalExpense=(int)$getNetProfit+$totalGrpSumIndirExp;				
			//////BOF-Calculate Total Incomes///////
			$getTotalIncomes=(int)$getGrossProfit+$totalGrpSumIndirInc;
		}*/
		////*****EOF-Calcualting Net Profit*****//
	
		$this->set(array('locationId'=>$locationId,'from'=>$from,'to'=>$to,'InnerArr'=>$InnerArr,'groupeExpIncData'=>$returnArr,'finalArr'=>$getAccountingGroupDataAll/*,'getTotalProfitExpExceptIndirExpInc1'=>$getTotalProfitExpExceptIndirExpInc1,'getTotalLossExpExceptIndirExpInc1'=>$getTotalLossExpExceptIndirExpInc1,'getGrossProfit'=>$getGrossProfit,'getNetProfit'=>$getNetProfit,'getTotalExpense'=>$getTotalExpense,'getTotalIncomes'=>$getTotalIncomes,'getGrpSumExp'=>$getGrpSumExp,'totalGrpSumInc'=>$totalGrpSumInc*/,'getLocName'=>$getLocName,'getLocAdd1'=>$getLocAdd1,'getLocAdd2'=>$getLocAdd2,'location_zipcode'=>$location_zipcode,'location_country'=>$location_country/*,'getTotalExpExceptIndirExp'=>$getTotalExpExceptIndirExp,'getTotalIncExceptIndirInc'=>$getTotalIncExceptIndirInc,'getProfitLossFlag'=>$getProfitLossFlag,'getNetLossFlag'=>$getNetLossFlag,'getGrossLoss'=>$getGrossLoss,'getNetLoss'=>$getNetLoss*/,'accountingGroupList'=>$accountingGroupList,
			'refineArr'=>$refineArr,'getAccountingGroupName'=>$getAccountingGroupName,'recurciveBalParent'=>$recurciveBalParent,'recurciveBalChild'=>$recurciveBalChild,'recurciveBalChild'=>$recurciveBalChild));
		//************
	
	}
	
		
}//EOF class