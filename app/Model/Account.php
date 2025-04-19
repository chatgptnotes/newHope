<?php

App::uses('AppModel', 'Model');
/**
 * CollaborateCompany Model
 *
 * @property Patient $Patient
*/
class Account extends AppModel {

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

	
	/* public function accountCreation($data=array())
	{
		$session = new cakeSession();
		if($data['id']){
			$data['modified_by']=$session->read('userid');
			$data['modify_time']=date("Y-m-d H:i:s");
			$data['location_id']=$session->read('locationid');
			if($data['payment_type']=='Dr'){
				$data['balance']=(-$data['balance']);
			}else{
				$data['balance']=$data['balance'];
			}
			$result = $this->save($data);  
		}else{ 
			$data['created_by']=$session->read('userid');
			$data['create_time']=date("Y-m-d H:i:s");
			$data['location_id']=$session->read('locationid');
		if($data['payment_type']=='Dr'){
				$data['balance']=(-$data['balance']);
			}else{
				$data['balance']=$data['balance'];
			}
			$result = $this->save($data);			
		}		
		return $result ;		
	} */
	
	public function accountCreation($data=array(),$openingBalance=null)
	{
		$session = new cakeSession();  
		if($data['id']){
			//for opening balance
				$accountDetails = $this->find('first',array('fields'=>array('Account.opening_balance'),
						'conditions'=>array('Account.id'=>$data['id'],'Account.location_id'=>$session->read('locationid'))));
				$openingBalance = $accountDetails['Account']['opening_balance'];
			//EOF
			$data['modified_by']=$session->read('userid');
			$data['modify_time']=date("Y-m-d H:i:s");
			$data['location_id']=$session->read('locationid');
			if($data['opening_balance']==null){
				$data['opening_balance']="0";
			}
			if($data['payment_type']==null){
				$data['payment_type']="Cr";
			}
			if($data['payment_type']=='Dr'){
				$data['opening_balance']=((-1)*(-$data['opening_balance']));
			}else{
				$data['opening_balance']=$data['opening_balance'];
			}

			if($openingBalance != $data['opening_balance']){
				$data['balance'] = ($data['balance'] + $data['opening_balance']);
			}
			$result = $this->save($data);
		}else{
			$old_data = $this->find('count',array('conditions'=>array('Account.name'=>trim($data['name']),'Account.is_deleted'=>0,
					'Account.location_id'=>$session->read('locationid'))));
			
			if($old_data == 0){
				$data['created_by']=$session->read('userid');
				$data['create_time']=date("Y-m-d H:i:s");
				$data['location_id']=$session->read('locationid');
				if($data['opening_balance']==null){
					$data['opening_balance']="0";
				}
				if($data['payment_type']==null){
					$data['payment_type']="Cr";
				}
				if($data['payment_type']=='Dr'){
					$data['opening_balance']=((-1)*(-$data['opening_balance']));
					$data['balance']= $data['opening_balance'];
				}else{
					$data['opening_balance']=$data['opening_balance'];
					$data['balance']= $data['opening_balance'];
				}
				$result = $this->save($data);
			}else{
				return $result;
			}
		}
		return $result ;
	}	
	/**
	 * function to return account id from user_id (user_id,service_provider_id,supplier_id etc)
	 * @param  int $user_id
	 * @param  char $type - "serviceProvider","supplier" etc 
	 * @return array
	 */	
	public function getAccountID($user_id=null,$type=null){
		$session= new CakeSession();
		if(!$user_id) return false ;
		$result  = $this->find('first',array('conditions'=>array('Account.user_type'=>$type,'Account.system_user_id'=>$user_id,
				'Account.location_id'=>$session->read('locationid')),'fields'=>array('Account.id','Account.name')));
		return $result ; 
	}
	
	public function setBalanceAmountByAccountId($acc_id=null,$debit_balance=null,$type=null,$previousAmount=null){
		$session= new CakeSession();
		if($type==debit){	
				$getByBalance=$this->find('first',array('conditions'=>array('Account.id'=>$acc_id,'Account.is_deleted'=>0,
						'Account.location_id'=>$session->read('locationid')),'fields'=>array('Account.balance')));
				$total=$getByBalance['Account']['balance'] - $debit_balance + $previousAmount;
				$this->updateAll(array('Account.balance'=>$total),array('Account.id'=>$acc_id));
			}
	}	
	
	public function setBalanceAmountByUserId($use_id=null,$debit_balance=null,$type=null,$previousAmount=null){
		$session= new CakeSession();
		if($type==credit){
				$getToBalance=$this->find('first',array('conditions'=>array('Account.id'=>$use_id,'Account.is_deleted'=>0,
						'Account.location_id'=>$session->read('locationid')),'fields'=>array('Account.balance')));
				$totalTo=$getToBalance['Account']['balance'] + $debit_balance - $previousAmount;
				$this->updateAll(array('Account.balance'=>$totalTo),array('Account.id'=>$use_id));
			}
	}
	
	public function postToTally($patientId,$companyName,$vchType,$tallyRequest="Import",$tallyDataType="Data",$serviceArray,$patientDetails,$othersJournal,$purchaseDetails)
	{
		$session= new CakeSession();
		if($session->read('website.instance') == 'hope'){
			$companyName = 'DR M HOPE HOSPITAL PVT. LTD.';
		}
		$VoucherLog = ClassRegistry::init('VoucherLog');
		$configurationObj = ClassRegistry::init('Configuration');
		foreach($serviceArray as $serviceArrayData)
		{
			$currentDate=($serviceArrayData['date']);
			$voucherNarration=$serviceArrayData['narration'];
			$debitAmt=$serviceArrayData['amount'];
			$idReceived=$serviceArrayData['id'];
			$voucherType=$serviceArrayData['type'];
			$isPosted=$serviceArrayData['isPosted'];
			$reference=$serviceArrayData['reference'];
			if($isPosted == '0'){
				$action = 'Create';
			}else{
				$action = 'Alter';
			}
		}
		$xmlData='<ENVELOPE>
		<HEADER>
			<VERSION>1</VERSION>
			<TALLYREQUEST>'.$tallyRequest.'</TALLYREQUEST>
			<TYPE>'.$tallyDataType.'</TYPE>
			<ID>Vouchers</ID>
		</HEADER>
		<BODY>
			<DESC>
				<STATICVARIABLES>
					<IMPORTDUPS>@@DUPCOMBINE</IMPORTDUPS>
					<SVCURRENTCOMPANY>'.$companyName.'</SVCURRENTCOMPANY>
				</STATICVARIABLES>
			</DESC>
		<DATA>';
		
		//create ledger name for the services if does not exist
		foreach($serviceArray as $serviceArrayData)
		{
			if($serviceArrayData['type']=='Receipt' || $serviceArrayData['type']=='Payment' || $serviceArrayData['type']=='Contra' 
					|| $serviceArrayData['type']=='Journal' && empty($serviceArrayData['patient_id'])){
				
				//creating group
				$serviceGroup = $serviceArrayData['servicegroup'];
				$xmlData.='<TALLYMESSAGE xmlns:UDF="TallyUDF">
					<GROUP NAME="'.$serviceGroup.'" RESERVEDNAME="'.$serviceGroup.'">
					<PARENT>'.$serviceArrayData['parentAliasGroup'].'</PARENT>
					<ADDLALLOCTYPE/>
					<ISBILLWISEON>Yes</ISBILLWISEON>
					<ISSUBLEDGER>Yes</ISSUBLEDGER>
					<TRACKNEGATIVEBALANCES>Yes</TRACKNEGATIVEBALANCES>
					<LANGUAGENAME.LIST>
					<NAME.LIST TYPE="String">
					<NAME>'.$serviceGroup.'</NAME>
					</NAME.LIST>
					</LANGUAGENAME.LIST>
					</GROUP>
					</TALLYMESSAGE>';
				//EOG group creating
		if($session->read('website.instance') == 'kanpur'){
			$standardType = '';
			if($serviceArrayData['tariff_standard_name'] != 'Private' && !empty($serviceArrayData['tariff_standard_name'])){
				$standardType .= "-";
				$standardType .= $serviceArrayData['tariff_standard_name'];
			}
		}
			$table = $this->get_html_translation_table_CP1252();
			$replaceStr = strtr($serviceArrayData['aliasName'].$standardType,$table) ;

			$xmlData.='<TALLYMESSAGE xmlns:UDF="TallyUDF">
            <LEDGER NAME="'.$replaceStr.'" ACTION="Create">
             <NAME.LIST>
             	<NAME>'.$replaceStr.'</NAME>
             </NAME.LIST>
             <PARENT>'.$serviceGroup.'</PARENT>
             <ISBILLWISEON>No</ISBILLWISEON>
             <AFFECTSSTOCK>No</AFFECTSSTOCK>
             <OPENINGBALANCE>0</OPENINGBALANCE>
             <USEFORVAT>No</USEFORVAT>
             <TAXCLASSIFICATIONNAME/>
             <TAXTYPE/>
              <RATEOFTAXCALCULATION/>
              </LEDGER>
             </TALLYMESSAGE>';
			
			//creating group
			$group = $serviceArrayData['group'];
			$xmlData.='<TALLYMESSAGE xmlns:UDF="TallyUDF">
					<GROUP NAME="'.$group.'" RESERVEDNAME="'.$group.'">
					<PARENT>'.$serviceArrayData['parentGroup'].'</PARENT>
					<ADDLALLOCTYPE/>
					<ISBILLWISEON>Yes</ISBILLWISEON>
					<ISSUBLEDGER>Yes</ISSUBLEDGER>
					<TRACKNEGATIVEBALANCES>Yes</TRACKNEGATIVEBALANCES>
					<LANGUAGENAME.LIST>
					<NAME.LIST TYPE="String">
					<NAME>'.$group.'</NAME>
					</NAME.LIST>
					</LANGUAGENAME.LIST>
					</GROUP>
					</TALLYMESSAGE>';
			
			//EOG group creating
			if($session->read('website.instance') == 'kanpur'){
				$admissionId = '';
				if(($serviceArrayData['voucher_log_type']=='FinalEntry') || $serviceArrayData['voucher_log_type']=='Discount'){
					$admissionId .= $serviceArrayData['voucher_no'];
					$admissionId .= "_";
				}
			}
			$table = $this->get_html_translation_table_CP1252();
			$replaceStr = strtr($admissionId.$serviceArrayData['name'],$table) ;
			$xmlData.='<TALLYMESSAGE xmlns:UDF="TallyUDF">
            <LEDGER NAME="'.$replaceStr.'" ACTION="Create">
             <NAME.LIST>
             	<NAME>'.$replaceStr.'</NAME>
             </NAME.LIST>
             <PARENT>'.$group.'</PARENT>
             <ISBILLWISEON>No</ISBILLWISEON>
             <AFFECTSSTOCK>No</AFFECTSSTOCK>
             <OPENINGBALANCE>0</OPENINGBALANCE>
             <USEFORVAT>No</USEFORVAT>
             <TAXCLASSIFICATIONNAME/>
             <TAXTYPE/>
              <RATEOFTAXCALCULATION/>
              </LEDGER>
             </TALLYMESSAGE>';
			}
		}

		//--------for patient journal voucher only -----------------//
			if($patientDetails['Account']['type']=='Journal'){
				if(!empty($patientDetails['Account']['sub_group']) && !empty($patientDetails['Account']['sub_sub_group'])){
					$table = $this->get_html_translation_table_CP1252();
					$groupStr = strtr($patientDetails['Account']['group'],$table) ;
					$subGroupStr = strtr($patientDetails['Account']['sub_group'],$table) ;
					$subsubGroupStr = strtr($patientDetails['Account']['sub_sub_group'],$table) ;
					
					$xmlData.='<TALLYMESSAGE xmlns:UDF="TallyUDF">
					<GROUP NAME="'.$subGroupStr.'" RESERVEDNAME="">
					<PARENT>'.$groupStr.'</PARENT>
					<ADDLALLOCTYPE/>
					<ISBILLWISEON>Yes</ISBILLWISEON>
					<ISSUBLEDGER>Yes</ISSUBLEDGER>
					<TRACKNEGATIVEBALANCES>Yes</TRACKNEGATIVEBALANCES>
					<LANGUAGENAME.LIST>
					<NAME.LIST TYPE="String">
					<NAME>'.$subGroupStr.'</NAME>
					</NAME.LIST>
					</LANGUAGENAME.LIST>
					</GROUP>
					</TALLYMESSAGE>';
							
					$xmlData.='<TALLYMESSAGE xmlns:UDF="TallyUDF">
					<GROUP NAME="'.$subsubGroupStr.'" RESERVEDNAME="">
					<PARENT>'.$subGroupStr.'</PARENT>
					<ADDLALLOCTYPE/>
					<ISBILLWISEON>Yes</ISBILLWISEON>
					<ISSUBLEDGER>Yes</ISSUBLEDGER>
					<TRACKNEGATIVEBALANCES>Yes</TRACKNEGATIVEBALANCES>
					<LANGUAGENAME.LIST>
					<NAME.LIST TYPE="String">
					<NAME>'.$subsubGroupStr.'</NAME>
					</NAME.LIST>
					</LANGUAGENAME.LIST>
					</GROUP>
					</TALLYMESSAGE>';
				}else{
					$table = $this->get_html_translation_table_CP1252();
					$subsubGroupStr = strtr($patientDetails['Account']['group'],$table) ;
				}
				$table = $this->get_html_translation_table_CP1252();
				$replaceStr = strtr($patientDetails['Account']['name'],$table) ;
		
				$xmlData.='<TALLYMESSAGE xmlns:UDF="TallyUDF">
	            <LEDGER NAME="'.$replaceStr.'" ACTION="Create">
	             <NAME.LIST>
	             	<NAME>'.$replaceStr.'</NAME>
	             </NAME.LIST>
	             <PARENT>'.$subsubGroupStr.'</PARENT>
	             <ISBILLWISEON>No</ISBILLWISEON>
	             <AFFECTSSTOCK>No</AFFECTSSTOCK>
	             <OPENINGBALANCE>0</OPENINGBALANCE>
	             <USEFORVAT>No</USEFORVAT>
	             <TAXCLASSIFICATIONNAME/>
	             <TAXTYPE/>
	              <RATEOFTAXCALCULATION/>
	              </LEDGER>
	             </TALLYMESSAGE>';
				
				foreach($serviceArray as $serviceArrayData)
				{
					if($serviceArrayData['type']=='Journal' && !empty($serviceArrayData['patient_id'])){
					//creating group
					$serviceGroup = $serviceArrayData['group'];
					$xmlData.='<TALLYMESSAGE xmlns:UDF="TallyUDF">
					<GROUP NAME="'.$serviceGroup.'" RESERVEDNAME="'.$serviceGroup.'">
					<PARENT/>
					<ADDLALLOCTYPE/>
					<ISBILLWISEON>Yes</ISBILLWISEON>
					<ISSUBLEDGER>Yes</ISSUBLEDGER>
					<TRACKNEGATIVEBALANCES>Yes</TRACKNEGATIVEBALANCES>
					<LANGUAGENAME.LIST>
					<NAME.LIST TYPE="String">
					<NAME>'.$serviceGroup.'</NAME>
					</NAME.LIST>
					</LANGUAGENAME.LIST>
					</GROUP>
					</TALLYMESSAGE>';
					//EOG group creating
					
					$table = $this->get_html_translation_table_CP1252();
					$replaceStr = strtr($serviceArrayData['name'],$table) ;
					$xmlData.='<TALLYMESSAGE xmlns:UDF="TallyUDF">
		            <LEDGER NAME="'.$replaceStr.'" ACTION="Create">
		             <NAME.LIST>
		             	<NAME>'.$replaceStr.'</NAME>
		             </NAME.LIST>
		             <PARENT>'.$serviceGroup.'</PARENT>
		             <ISBILLWISEON>No</ISBILLWISEON>
		             <AFFECTSSTOCK>No</AFFECTSSTOCK>
		             <OPENINGBALANCE>0</OPENINGBALANCE>
		             <USEFORVAT>No</USEFORVAT>
		             <TAXCLASSIFICATIONNAME/>
		             <TAXTYPE/>
		              <RATEOFTAXCALCULATION/>
		              </LEDGER>
		             </TALLYMESSAGE>';
					}
				}
			}
		//------------------EOF---------------------------------------//
		
			
		//--------for purchase voucher only -----------------//
				if($purchaseDetails['Account']['type']=='Purchase'){
				$table = $this->get_html_translation_table_CP1252();
				$groupStr = strtr($purchaseDetails['Account']['group'],$table) ;
				//creating group
				$xmlData.='<TALLYMESSAGE xmlns:UDF="TallyUDF">
					<GROUP NAME="'.$groupStr.'" RESERVEDNAME="'.$groupStr.'">
					<PARENT>'.$purchaseDetails['Account']['parentGroup'].'</PARENT>
					<ADDLALLOCTYPE/>
					<ISBILLWISEON>No</ISBILLWISEON>
					<ISSUBLEDGER>No</ISSUBLEDGER>
					<USEFORVAT>No</USEFORVAT>
					<TRACKNEGATIVEBALANCES>Yes</TRACKNEGATIVEBALANCES>
					<LANGUAGENAME.LIST>
					<NAME.LIST TYPE="String">
					<NAME>'.$groupStr.'</NAME>
					</NAME.LIST>
					</LANGUAGENAME.LIST>
					</GROUP>
					</TALLYMESSAGE>';
				//EOG group creating
				
				$table = $this->get_html_translation_table_CP1252();
				$replaceStr = strtr($purchaseDetails['Account']['name'],$table) ;
				$xmlData.='<TALLYMESSAGE xmlns:UDF="TallyUDF">
	            <LEDGER NAME="'.$replaceStr.'" ACTION="Create">
	             <NAME.LIST>
	             	<NAME>'.$replaceStr.'</NAME>
	             </NAME.LIST>
	             <PARENT>'.$groupStr.'</PARENT>
	             <ISBILLWISEON>No</ISBILLWISEON>
	             <AFFECTSSTOCK>No</AFFECTSSTOCK>
	             <OPENINGBALANCE>0</OPENINGBALANCE>
	             <USEFORVAT>No</USEFORVAT>
	             <TAXCLASSIFICATIONNAME/>
	             <TAXTYPE/>
	              <RATEOFTAXCALCULATION/>
	              </LEDGER>
	             </TALLYMESSAGE>';
		
				foreach($serviceArray as $serviceArrayData)
				{
					if($serviceArrayData['type']=='Purchase'){
						//creating group
						$table = $this->get_html_translation_table_CP1252();
						$serviceGroup = strtr($serviceArrayData['group'],$table) ;
						
						$table = $this->get_html_translation_table_CP1252();
						$serviceParentGroup = strtr($serviceArrayData['parentTaxGroup'],$table) ;
				
						$xmlData.='<TALLYMESSAGE xmlns:UDF="TallyUDF">
					<GROUP NAME="'.$serviceGroup.'" RESERVEDNAME="'.$serviceGroup.'">
					<PARENT>'.$serviceParentGroup.'</PARENT>
					<ADDLALLOCTYPE/>
					<ISBILLWISEON>No</ISBILLWISEON>
					<ISSUBLEDGER>No</ISSUBLEDGER>
					<USEFORVAT>No</USEFORVAT>
					<TRACKNEGATIVEBALANCES>Yes</TRACKNEGATIVEBALANCES>
					<LANGUAGENAME.LIST>
					<NAME.LIST TYPE="String">
					<NAME>'.$serviceGroup.'</NAME>
					</NAME.LIST>
					</LANGUAGENAME.LIST>
					</GROUP>
					</TALLYMESSAGE>';
						//EOG group creating
							
						$table = $this->get_html_translation_table_CP1252();
						$replaceStr = strtr($serviceArrayData['name'],$table) ;
						$xmlData.='<TALLYMESSAGE xmlns:UDF="TallyUDF">
		            <LEDGER NAME="'.$replaceStr.'" ACTION="Create">
		             <NAME.LIST>
		             	<NAME>'.$replaceStr.'</NAME>
		             </NAME.LIST>
		             <PARENT>'.$serviceGroup.'</PARENT>
		             <ISBILLWISEON>No</ISBILLWISEON>
		             <AFFECTSSTOCK>No</AFFECTSSTOCK>
		             <OPENINGBALANCE>0</OPENINGBALANCE>
		             <USEFORVAT>No</USEFORVAT>
		             <TAXCLASSIFICATIONNAME/>
		             <TAXTYPE/>
		              <RATEOFTAXCALCULATION/>
		              </LEDGER>
		             </TALLYMESSAGE>';
					}
				}
			}
			//------------------EOF purchase voucher---------------------------------------//
	
		//----*******----BOF Create Ledger and Unique id------********------//
				//create voucher code
				if($vchType=='Journal'){
					$uniqueId = 'JV'.$idReceived;
				}elseif ($vchType=='Receipt'){
					$uniqueId = 'RV'.$idReceived;
				}else if($vchType=='Contra'){
					$uniqueId = 'CV'.$idReceived;
				}else if($vchType=='Payment'){
					$uniqueId = 'PV'.$idReceived;
				}else if($vchType=='Purchase'){
					$uniqueId = 'PO'.$idReceived;
				}
				$table = $this->get_html_translation_table_CP1252();
				$replaceStr = strtr($voucherNarration,$table) ;
				$xmlData.='<TALLYMESSAGE>
						<VOUCHER REMOTEID="'.$uniqueId.'" VCHTYPE="'.$vchType.'" ACTION="'.$action.'">
						<DATE>'.$currentDate.'</DATE>
						<NARRATION>'.$replaceStr.'</NARRATION>
						<VOUCHERTYPENAME>'.$vchType.'</VOUCHERTYPENAME>
						<GUID>'.$uniqueId.'</GUID>
						<REFERENCE>'.$reference.'</REFERENCE>
						<VOUCHERNUMBER>'.$idReceived.'</VOUCHERNUMBER>';
				
		//----*******----EOF define amount debit n credit side------********------//

		
		//----*******----BOF define amount debit n credit side------********------//
		//for journal entry
		if($vchType == 'Journal' && empty($othersJournal)){
		//for debit entry
				$xmlData.='<ALLLEDGERENTRIES.LIST>
				<LEDGERNAME>'.$patientDetails['Account']['name'].'</LEDGERNAME>
				<ISDEEMEDPOSITIVE>Yes</ISDEEMEDPOSITIVE>
				<AMOUNT>-'.$patientDetails['VoucherLog']['debit_amount'].'</AMOUNT>
				</ALLLEDGERENTRIES.LIST>';

			foreach($serviceArray as $serviceArrayData)
			{
				$table = $this->get_html_translation_table_CP1252();
				$replaceStr = strtr($serviceArrayData['name'],$table) ;
				
			    $xmlData.='<ALLLEDGERENTRIES.LIST>
		      	<LEDGERNAME>'.$replaceStr.'</LEDGERNAME>
		      	<ISDEEMEDPOSITIVE>No</ISDEEMEDPOSITIVE>
		      	<AMOUNT>'.round($serviceArrayData['amount']).'</AMOUNT>
		      	</ALLLEDGERENTRIES.LIST>';
			}
		}else if($vchType == 'Receipt'){
				//for receipt entry
				foreach($serviceArray as $serviceArrayData)
				{
					$table = $this->get_html_translation_table_CP1252();
					$replaceStr = strtr($serviceArrayData['name'],$table) ;
					$xmlData.='<ALLLEDGERENTRIES.LIST>
					<LEDGERNAME>'.$replaceStr.'</LEDGERNAME>
					<ISDEEMEDPOSITIVE>No</ISDEEMEDPOSITIVE>
					<AMOUNT>'.$serviceArrayData['amount'].'</AMOUNT>
					</ALLLEDGERENTRIES.LIST>';
					
					$table = $this->get_html_translation_table_CP1252();
					$replaceStr = strtr($serviceArrayData['aliasName'],$table) ;
					$xmlData.='<ALLLEDGERENTRIES.LIST>
			      	<LEDGERNAME>'.$replaceStr.'</LEDGERNAME>
			     	<ISDEEMEDPOSITIVE>Yes</ISDEEMEDPOSITIVE>
			      	<AMOUNT>-'.$serviceArrayData['amount'].'</AMOUNT>
			      	</ALLLEDGERENTRIES.LIST>';
				}
			}else if($vchType == 'Payment'){
				foreach($serviceArray as $serviceArrayData)
				{
					$table = $this->get_html_translation_table_CP1252();
					$replaceStr = strtr($serviceArrayData['aliasName'],$table) ;
					$xmlData.='<ALLLEDGERENTRIES.LIST>
					<LEDGERNAME>'.$replaceStr.'</LEDGERNAME>
					<ISDEEMEDPOSITIVE>No</ISDEEMEDPOSITIVE>
					<AMOUNT>'.$serviceArrayData['amount'].'</AMOUNT>
					</ALLLEDGERENTRIES.LIST>';
						
					$table = $this->get_html_translation_table_CP1252();
					$replaceStr = strtr($serviceArrayData['name'],$table) ;
					$xmlData.='<ALLLEDGERENTRIES.LIST>
			      	<LEDGERNAME>'.$replaceStr.'</LEDGERNAME>
			     	<ISDEEMEDPOSITIVE>Yes</ISDEEMEDPOSITIVE>
			      	<AMOUNT>-'.$serviceArrayData['amount'].'</AMOUNT>
			      	</ALLLEDGERENTRIES.LIST>';
				}
			}else if($vchType == 'Contra'){
				foreach($serviceArray as $serviceArrayData)
				{
					$table = $this->get_html_translation_table_CP1252();
					$replaceStr = strtr($serviceArrayData['aliasName'],$table) ;
					$xmlData.='<ALLLEDGERENTRIES.LIST>
			      	<LEDGERNAME>'.$replaceStr.'</LEDGERNAME>
			     	<ISDEEMEDPOSITIVE>Yes</ISDEEMEDPOSITIVE>
			      	<AMOUNT>-'.$serviceArrayData['amount'].'</AMOUNT>
			      	</ALLLEDGERENTRIES.LIST>';
					
					$table = $this->get_html_translation_table_CP1252();
					$replaceStr = strtr($serviceArrayData['name'],$table) ;
					$xmlData.='<ALLLEDGERENTRIES.LIST>
					<LEDGERNAME>'.$replaceStr.'</LEDGERNAME>
					<ISDEEMEDPOSITIVE>No</ISDEEMEDPOSITIVE>
					<AMOUNT>'.$serviceArrayData['amount'].'</AMOUNT>
					</ALLLEDGERENTRIES.LIST>';
				}
			}else if($vchType == 'Journal' && !empty($othersJournal)){
				//for receipt entry
				foreach($serviceArray as $serviceArrayData)
				{
					if($session->read('website.instance') == 'kanpur'){
						$standardType = '';
						if($serviceArrayData['tariff_standard_name'] != 'Private'){
							$standardType .= "-";
							$standardType .= $serviceArrayData['tariff_standard_name'];
						}
					}
					$table = $this->get_html_translation_table_CP1252();
					$replaceStr = strtr($serviceArrayData['aliasName'].$standardType,$table) ;
					$xmlData.='<ALLLEDGERENTRIES.LIST>
					<LEDGERNAME>'.$replaceStr.'</LEDGERNAME>
					<ISDEEMEDPOSITIVE>Yes</ISDEEMEDPOSITIVE>
					<AMOUNT>-'.$serviceArrayData['amount'].'</AMOUNT>
					</ALLLEDGERENTRIES.LIST>';
					
					if($session->read('website.instance') == 'kanpur'){
						$admissionId = '';
						if(($serviceArrayData['voucher_log_type']=='FinalEntry') || $serviceArrayData['voucher_log_type']=='Discount'){
							$admissionId .= $serviceArrayData['voucher_no'];
							$admissionId .= "_";
						}
					}
					$table = $this->get_html_translation_table_CP1252();
					$replaceStr = strtr($admissionId.$serviceArrayData['name'],$table) ;
					$xmlData.='<ALLLEDGERENTRIES.LIST>
			      	<LEDGERNAME>'.$replaceStr.'</LEDGERNAME>
			     	<ISDEEMEDPOSITIVE>No</ISDEEMEDPOSITIVE>
			      	<AMOUNT>'.$serviceArrayData['amount'].'</AMOUNT>
			      	</ALLLEDGERENTRIES.LIST>';
				
				}
			}else if($vchType == 'Purchase'){
				//for purchase entry
				$table = $this->get_html_translation_table_CP1252();
				$replaceStr = strtr($purchaseDetails['Account']['name'],$table) ;
					$xmlData.='<ALLLEDGERENTRIES.LIST>
					<LEDGERNAME>'.$replaceStr.'</LEDGERNAME>
					<ISDEEMEDPOSITIVE>No</ISDEEMEDPOSITIVE>
					<AMOUNT>'.$purchaseDetails['VoucherLog']['debit_amount'].'</AMOUNT>
					</ALLLEDGERENTRIES.LIST>';
					
				foreach($serviceArray as $serviceArrayData)
				{
					if($serviceArrayData['name']!='Round Off' && $serviceArrayData['entry_type']=='PurchaseOrder'){
					$table = $this->get_html_translation_table_CP1252();
					$replaceStr = strtr($serviceArrayData['name'],$table) ;
					
				    $xmlData.='<ALLLEDGERENTRIES.LIST>
			      	<LEDGERNAME>'.$replaceStr.'</LEDGERNAME>
			      	<ISDEEMEDPOSITIVE>Yes</ISDEEMEDPOSITIVE>
			      	<AMOUNT>-'.round($serviceArrayData['amount']).'</AMOUNT>
			      	</ALLLEDGERENTRIES.LIST>';
					}else{
						$table = $this->get_html_translation_table_CP1252();
						$replaceStr = strtr($serviceArrayData['name'],$table) ;
							
						$xmlData.='<ALLLEDGERENTRIES.LIST>
			      	<LEDGERNAME>'.$replaceStr.'</LEDGERNAME>
			      	<ISDEEMEDPOSITIVE>No</ISDEEMEDPOSITIVE>
			      	<AMOUNT>'.$serviceArrayData['amount'].'</AMOUNT>
			      	</ALLLEDGERENTRIES.LIST>';
					}
				}
			}
		//----*******----EOF define amount debit n credit side------********------//
		$xmlData.='</VOUCHER>
		</TALLYMESSAGE>';
		//create voucher code end
		$xmlData.='</DATA></BODY></ENVELOPE>'; 
		$getTallyUrl=$configurationObj->find('first',array('conditions'=>array('name'=>'tallyUrl'),'fields'=>array('value')));
		$url=$getTallyUrl['Configuration']['value'];
		if($session->read('website.instance') == 'hope'){
			$url = "http://192.168.8.228:9000/";
			//$url = "http://localhost:9002/";
		}
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		// Following line is compulsary to add as it is:
		curl_setopt($ch, CURLOPT_POSTFIELDS,
		"xmlRequest=" . $xmlData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
		$dataNew = curl_exec($ch);
		curl_close($ch);
		
		$array_data = json_decode(json_encode(simplexml_load_string($dataNew)), true);
		print_r('<pre>');
		print_r($array_data);
		print_r('</pre>');
		Configure::write('debug',2);
		debug($xmlData);
		//debug($url);
		if($array_data['BODY']['DATA']['IMPORTRESULT']['ERRORS'] == '0'){
			$isPosted = '1';
		}else{
			$isPosted = '2';
		}
		$VoucherLog->updateAll(array('is_posted'=>$isPosted),array('id'=>$patientId));
		return $array_data['BODY']['DATA']['IMPORTRESULT'];
	}
	
	public function postVoucher($xml,$action){
	
		$xml='<ENVELOPE><HEADER>
            <TALLYREQUEST>Import Data</TALLYREQUEST>
            </HEADER>';
		 
		/** SVCURRENTCOMPANY will hace company Name **/
		$xml.='    <BODY>
            <IMPORTDATA>
                <REQUESTDESC>
                    <REPORTNAME>All Masters</REPORTNAME>
                        <STATICVARIABLES>
                            <SVCURRENTCOMPANY>MFI NAME</SVCURRENTCOMPANY>
                        </STATICVARIABLES>
                    </REQUESTDESC>
                <REQUESTDATA>';
	
		/** VCHTYPE will contain wheather its Journal OR Receipt  and actio cab be CREATE ATLER DELETE.
		 TRANSACTION DATE format is DDDDMMYY.
		 ALLLEDGERENTRIES.LIST can be repeated in loop to add information.
		 CATEGORYALLOCATIONS.LIST and COSTCENTREALLOCATIONS can be use for the location purpose.
		 **/
		$xml.='<TALLYMESSAGE xmlns:UDF="TallyUDF">
            <VOUCHER VCHTYPE="Journal OR Receipt" ACTION="Create">
                    <DATE>
                        TRANSACTION DATE:DDDDMMYY
                    </DATE>
      
                    <NARRATION>
                        EXPORT FILE NAME
                    </NARRATION>
      
                    <VOUCHERTYPENAME>
                        Payment
                    </VOUCHERTYPENAME>
      
                    <ALLLEDGERENTRIES.LIST>
                            <LEDGERNAME>
                                Debit Account Ledger Name
                            </LEDGERNAME>
              
                            <ISDEEMEDPOSITIVE>
                                Yes
                            </ISDEEMEDPOSITIVE>
              
                            <AMOUNT>
                                 - (MINUS) AGGREGATED AMOUNT (amount A)
                            </AMOUNT>
              
                            <CATEGORYALLOCATIONS.LIST>
                                    <CATEGORY>
                                        Primary Cost Category
                                    </CATEGORY>
                                    <COSTCENTREALLOCATIONS.LIST>
                                            <NAME> Branch 1 NAME </NAME>
                                            <AMOUNT> amount A </AMOUNT>
                                    </COSTCENTREALLOCATIONS.LIST>
                            </CATEGORYALLOCATIONS.LIST>
                    </ALLLEDGERENTRIES.LIST>
      
                    <ALLLEDGERENTRIES.LIST>
                                <LEDGERNAME>
                                     Debit Account Ledger Name 2
                                 </LEDGERNAME>
                                <ISDEEMEDPOSITIVE>
                                    Yes
                                </ISDEEMEDPOSITIVE>
                                <AMOUNT>
                                    - (MINUS) AGGREGATED AMOUNT (amount B)
                                 </AMOUNT>
                                <CATEGORYALLOCATIONS.LIST>
                                        <CATEGORY>Primary Cost Category</CATEGORY>
                                        <COSTCENTREALLOCATIONS.LIST>
                                            <NAME> Branch 1 NAME </NAME>
                                            <AMOUNT> amount B </AMOUNT>
                                        </COSTCENTREALLOCATIONS.LIST>
                                </CATEGORYALLOCATIONS.LIST>
                </ALLLEDGERENTRIES.LIST>
      
                <ALLLEDGERENTRIES.LIST>
                        <LEDGERNAME> Credit Account Ledger Name </LEDGERNAME>
                        <ISDEEMEDPOSITIVE>No</ISDEEMEDPOSITIVE>
                        <AMOUNT> positive AGGREGATED AMOUNT (C = A+B)</AMOUNT>
                </ALLLEDGERENTRIES.LIST>
      
                <CATEGORYALLOCATIONS.LIST>
                    <CATEGORY>Primary Cost Category</CATEGORY>
                    <COSTCENTREALLOCATIONS.LIST>
                        <NAME> Branch 1 NAME </NAME>
                        <AMOUNT> amount C </AMOUNT>
                    </COSTCENTREALLOCATIONS.LIST>
                </CATEGORYALLOCATIONS.LIST>
        </VOUCHER>
        </TALLYMESSAGE>
        </BODY>
        </ENVELOPE>';	 
	}

	/**
	 * 
	 * patient post data and last insert id of patient table
	 */
	function insertMandatoryServiceCharges($data,$latest_insert_id){
		App::import('Vendor', 'DrmhopeDB');
		$session = new CakeSession();
		if(empty($_SESSION['db_name'])){
			$db_connection = new DrmhopeDB('db_hope');
			$db_connection->makeConnection($this);
		}else{
			$db_connection = new DrmhopeDB($_SESSION['db_name']);
		}
		$tariffListObj = Classregistry::init('TariffList');
		$voucherEntryObj = Classregistry::init('VoucherEntry');
		$tariffStandardObj = Classregistry::init('TariffStandard');
		$billingObj = Classregistry::init('Billing'); 
		$serviceBillingObj = Classregistry::init('ServiceBill');	
		$serviceCategoryObj = Classregistry::init('ServiceCategory');
		$patientObj = Classregistry::init('Patient');
		$db_connection->makeConnection($tariffListObj);
		$db_connection->makeConnection($voucherEntryObj);
		$db_connection->makeConnection($tariffStandardObj);
		$db_connection->makeConnection($billingObj);
		$db_connection->makeConnection($serviceBillingObj);
		$db_connection->makeConnection($serviceCategoryObj);
		$db_connection->makeConnection($patientObj);
		//journal entry by amit
		$privateID = $tariffStandardObj->getPrivateTariffID();//retrive private ID
		$tariffStdData = $data['Patient']['admission_type'];
		$tariffStd = $data['Patient']['treatment_type']; //visit type first or follow consultaion
		$tariffStandardId = $data['Patient']['tariff_standard_id']?$data['Patient']['tariff_standard_id']:$privateID;
		$hospitalType = $session->read('hospitaltype');
		
		$regCharges = $billingObj->getRegistrationCharges($hospitalType,$tariffStandardId,$latest_insert_id);				
		$doctorRate = $billingObj->getDoctorRate(1,$hospitalType,$tariffStandardId,$tariffStdData,$tariffStd,$latest_insert_id,$data['Patient']['doctor_id']);  
		 
		$consultationService = Configure::read('OPCheckUpOptions'); //code name in tariffList for registration charges
		
		//for registration charges 
		 
		if(strtolower($data['Patient']['admission_type'])=='ipd'){
			if($session->read('website.instance') == 'kanpur'){//yashwant
				$registrationCharges = Configure::read('RegistrationChargesIPD');
			}else{
				$registrationCharges = Configure::read('RegistrationCharges');
			}
			$registId = $tariffListObj->find('first',array('fields'=>array('TariffList.id','TariffList.name'),'conditions'=>array('TariffList.code_name'=>$registrationCharges,'TariffList.location_id'=>$session->read('locationid'))));
		}else{					
			$registrationCharges = Configure::read('RegistrationCharges');
			$registId = $tariffListObj->find('first',array('fields'=>array('TariffList.id','TariffList.name'),'conditions'=>array('TariffList.code_name'=>$registrationCharges,'TariffList.location_id'=>$session->read('locationid'))));
		}
		$regId = $registId['TariffList']['id'];


		//EOF reg charges 
		
		if($this->applyRegistrationCharges($tariffStdData,$latest_insert_id,$tariffStd) && !empty($regId)){ 
			$getPatientDetails=$patientObj->find('first',array('conditions'=>array('Patient.id'=>$latest_insert_id),'fields'=>array('person_id','lookup_name','form_received_on')));
			$personId = $getPatientDetails['Patient']['person_id'];
			$accountId = $this->getAccountID($personId,'Patient');
			$userId = $this->getUserIdOnly($regId,'TariffList',$registId['TariffList']['name']);
			if(!empty($regCharges)){
				$serviceBill  = array('date'=>date('Y-m-d H:i:s'),
						'location_id'=>($data['Patient']['location_id'])?$data['Patient']['location_id']:$session->read('locationid'),
						'tariff_standard_id'=>$tariffStandardObj->getPrivateTariffID(),
						'create_time'=> date('Y-m-d H:i:s'),
						'created_by'=>$session->read('userid'),
						'patient_id'=>$latest_insert_id,
						'service_id'=>$serviceCategoryObj->getServiceGroupId(Configure::read('mandatoryservices')),
						'tariff_list_id'=>$regId,
						'no_of_times'=>1,
						'amount'=>$regCharges
						);
				$serviceBillingObj->saveAll($serviceBill); //insert registration
		}
		}
		 
		if($this->firstFollowupCharges($tariffStdData,$latest_insert_id,$tariffStd)){
			$getPatientDetails=$patientObj->find('first',array('conditions'=>array('Patient.id'=>$latest_insert_id),'fields'=>array('person_id','lookup_name','form_received_on')));
			$personId = $getPatientDetails['Patient']['person_id'];
			$accountId = $this->getAccountID($personId,'Patient');
			$tariffDetalis = $tariffListObj->find('first',array('fields'=>array('TariffList.name'),'conditions'=>array('TariffList.id'=>$data['Patient']['treatment_type'])));
			$userId = $this->getUserIdOnly($data['Patient']['treatment_type'],'TariffList',$tariffDetalis['TariffList']['name']);
			if(!empty($data['Patient']['treatment_type'])){
				if($session->read('website.instance')=='vadodara'){
					if($data["Person"]['pay_amt']){
						$paidAmount= $doctorRate;
						$modified=date('Y-m-d');
						$modifieBy=$session->read('userid');
					}else{
						$paidAmount='0';
						$modified='';
						$modifieBy='';
					}
				}else{
					$paidAmount='0';
					$modified='';
					$modifieBy='';
				}
				if(!empty($doctorRate)){				
					$serviceBill  = array('date'=>date('Y-m-d H:i:s'),
							'location_id'=>($data['Patient']['location_id'])?$data['Patient']['location_id']:$session->read('locationid'),
							'tariff_standard_id'=>$tariffStandardObj->getPrivateTariffID(),
							'create_time'=> date('Y-m-d H:i:s'),
							'created_by'=>$session->read('userid'),
							'patient_id'=>$latest_insert_id,
							'service_id'=>$serviceCategoryObj->getServiceGroupId(Configure::read('mandatoryservices')),
							'tariff_list_id'=>$data['Patient']['treatment_type'], //for first/follow-up consultation
							'no_of_times'=>1,
							'paid_amount'=>$paidAmount,
							'modified_by'=>$modifieBy,
							'modified_time'=>$modified,
							'amount'=>$doctorRate
					);
				
					$serviceBillingObj->saveAll($serviceBill); //insert registration and consulation servicde and charges
				}
			}	
		}	
	} 	
	
	//check for registration charges 
	function applyRegistrationCharges($admission_type=null ,$patient_id=null,$treatment_type=null){
		$session = new CakeSession();
		if(($treatment_type==Configure::read('radiotherapy'))||($treatment_type==Configure::read('radiotherapyOpd'))){
			return false;
		}
		if($session->read('website.instance') == 'kanpur' && $treatment_type=='206'){
			return false;
		}
		$patient = ClassRegistry::init('Patient');		
		if(strtolower($admission_type) == 'ipd' || strtolower($admission_type) == 'opd'){ 
			//registration charges
			$getpersonId=$patient->find('first',array('conditions'=>array('Patient.id'=>$patient_id)));	
			
			$getPatientCount = $patient->find('count',array('conditions'=>array('person_id'=>$getpersonId['Patient']['person_id']),'order'=>'Patient.id ASC'));
			$getDate=$patient->find('first',array('fields'=>array('person_id','form_received_on','last_reg_charges_taken_on'),
					'conditions'=>array('person_id'=>$getpersonId['Patient']['person_id']),
					'order'=>'Patient.id ASC'));
			
			if($getPatientCount==1){
				$patient->updateAll(array('Patient.last_reg_charges_taken_on'=>"'".$getDate['Patient']['form_received_on']."'"),array('Patient.id'=>$patient_id));
				return true ; //for the first regitration no need to cross check
			}  
			
			if(!empty($getDate['Patient']['last_reg_charges_taken_on'])){
				$getLastDate=$getDate['Patient']['last_reg_charges_taken_on'];
			}else{	
				$getLastDate=$getDate['Patient']['form_received_on'];
			}			
			$currDate=date('Y-m-d H:i:s');
			$diff=DateFormatComponent::dateDiff($getLastDate,$currDate);
			$months=Configure::read('regValidity');
			//registration charges added for >=6 month and for the first time
			if(strtolower($admission_type) == 'opd')
			{
			if($diff->m >= $months || ($diff->y==0 && $diff->m==0 && $diff->d==0 && $diff->s=0)){ //second added for same day patient registration (for testers only) 
				//update patient table with a current date as on this date registration charges has beed applied on patient 
				$patient->updateAll(array('Patient.last_reg_charges_taken_on'=>"'".$getDate['Patient']['form_received_on']."'"),array('Patient.id'=>$patient_id));
				return true ;
			}else{
				return false ;
			}
			}
			else
				return true; //for kanpur globus instance registraion charges will be mandatory applied for IPD patient
		}else{
			return false  ; //no need to add registration charges
		}
	}

	//first consultation charges and followup charges
	function firstFollowupCharges($admission_type=null ,$patient_id=null,$treatment_type=null){
		if(($treatment_type==Configure::read('radiotherapy'))||($treatment_type==Configure::read('radiotherapyOpd'))){
			return false;
		}
		//Only for OPD patients
		App::import('Vendor', 'DrmhopeDB');
		if(empty($_SESSION['db_name'])){
			$db_connection = new DrmhopeDB('db_hope');
			$db_connection->makeConnection($this);
		}else{
			$db_connection = new DrmhopeDB($_SESSION['db_name']);
		}
		$patient = ClassRegistry::init('Patient');
		$tariffListObj = ClassRegistry::init('TariffList');
		$tariffCharges=ClassRegistry::init('TariffCharge');
		$db_connection->makeConnection($patient);
		$db_connection->makeConnection($tariffListObj);
		$db_connection->makeConnection($tariffCharges);
		if($admission_type == 'OPD'){  
			$getpersonId=$patient->find('first',array('conditions'=>array('Patient.id'=>$patient_id)));
			$gettariffListId=$patient->find('first',array('fields'=>array('treatment_type','form_received_on','doctor_id','last_visit_type_charges_on'),
					'conditions'=>array('person_id'=>$getpersonId['Patient']['person_id']),
					));
			$getPatientCount = $patient->find('count',array('conditions'=>array('person_id'=>$getpersonId['Patient']['person_id']),'order'=>'Patient.id ASC'));
			
			
			if($getPatientCount==1){//return for the first time 
				//update patient table with a current date as on this date first charges has been applied on patient
				$patient->updateAll(array('Patient.last_visit_type_charges_on'=>"'".$gettariffListId['Patient']['form_received_on']."'"),array('Patient.id'=>$patient_id));
				return true; //charges to be added  for first time and if the no.of days extends no.of total validity days(first consultation validity days + follwup visit validity days )
			}
			
			$options=Configure::read('OPCheckUpOptions');
			$firstConsultation=$tariffListObj->find('first',array('fields'=>array('TariffList.id'),
					'conditions'=>array('TariffList.code_name LIKE'=>$options['consultation'])));
			$followup=$tariffListObj->find('first',array('fields'=>array('TariffList.id'),'conditions'=>array('TariffList.code_name LIKE'=>$options['followup'])));
			
			$firstvalidity=$tariffCharges->find('first',array('fields'=>array('TariffCharge.id','TariffCharge.doctor_id','TariffCharge.unit_days'),
					'conditions'=>array('TariffCharge.is_deleted'=>0,'TariffCharge.tariff_list_id'=>$firstConsultation['TariffList']['id'],'TariffCharge.doctor_id'=>$gettariffListId['Patient']['doctor_id'])));
			$followupvalidity=$tariffCharges->find('first',array('fields'=>array('TariffCharge.id','TariffCharge.doctor_id',
				'TariffCharge.unit_days'),
					'conditions'=>array('TariffCharge.is_deleted'=>0,'TariffCharge.tariff_list_id'=>$followup['TariffList']['id'],'TariffCharge.doctor_id'=>$gettariffListId['Patient']['doctor_id'])));
			$totalDays=$firstvalidity['TariffCharge']['unit_days']+$followupvalidity['TariffCharge']['unit_days']; 
			
			/* pr($gettariffListId);
			pr($firstConsultation);
			pr($followup);
			pr($getDate);
			pr($firstvalidity);
			pr($followupvalidity);
			pr($totalDays);  */
			
			//exit;
			if($gettariffListId['Patient']['treatment_type']==$firstConsultation['TariffList']['id'] || 
					$gettariffListId['Patient']['treatment_type']==$followup['TariffList']['id']){
				if(!empty($getDate['Patient']['last_visit_type_charges_on'])){
					$getLastDate=$gettariffListId['Patient']['last_visit_type_charges_on'];
				}else{
					$getLastDate=$gettariffListId['Patient']['form_received_on'];
				}
				$currDate=date('Y-m-d H:i:s'); 
				$diff=DateFormatComponent::dateDiff($getLastDate,$currDate); 
				//condition for first day, followup and more then total days
				if(($diff->y=='0' && $diff->m=='0' && $diff->d=='0' && $diff->s=='0') ||
				   ($diff->y=='0' && $diff->m=='0' && $diff->d >=$firstvalidity['TariffCharge']['unit_days'] && $diff->d <=$totalDays) ||
				   ($diff->d >=$totalDays || ($diff->m >0 && $diff->d <=$totalDays) || ($diff->y > 0 && $diff->m =0 && $diff->d <=$totalDays ))){ //for older duration 					 
					//update patient table with a current date as on this date first charges has been applied on patient
					$patient->updateAll(array('Patient.last_visit_type_charges_on'=>"'".$gettariffListId['Patient']['form_received_on']."'"),array('Patient.id'=>$patient_id));
					return true; //charges to be added  for first time and if the no.of days extends no.of total validity days(first consultation validity days + follwup visit validity days )
				}else {
					return false;
				}
			} 
			return true ;//backup 
		}// end of OPD if
		
	}
	function get_html_translation_table_CP1252() {
		$trans = get_html_translation_table(HTML_ENTITIES);
		$trans[chr(130)] = '&sbquo;'; // Single Low-9 Quotation Mark
		$trans[chr(131)] = '&fnof;'; // Latin Small Letter F With Hook
		$trans[chr(132)] = '&bdquo;'; // Double Low-9 Quotation Mark
		$trans[chr(133)] = '&hellip;'; // Horizontal Ellipsis
		$trans[chr(134)] = '&dagger;'; // Dagger
		$trans[chr(135)] = '&Dagger;'; // Double Dagger
		$trans[chr(136)] = '&circ;'; // Modifier Letter Circumflex Accent
		$trans[chr(137)] = '&permil;'; // Per Mille Sign
		$trans[chr(138)] = '&Scaron;'; // Latin Capital Letter S With Caron
		$trans[chr(139)] = '&lsaquo;'; // Single Left-Pointing Angle Quotation Mark
		$trans[chr(140)] = '&OElig; '; // Latin Capital Ligature OE
		$trans[chr(145)] = '&lsquo;'; // Left Single Quotation Mark
		$trans[chr(146)] = '&rsquo;'; // Right Single Quotation Mark
		$trans[chr(147)] = '&ldquo;'; // Left Double Quotation Mark
		$trans[chr(148)] = '&rdquo;'; // Right Double Quotation Mark
		$trans[chr(149)] = '&bull;'; // Bullet
		$trans[chr(150)] = '&ndash;'; // En Dash
		$trans[chr(151)] = '&mdash;'; // Em Dash
		$trans[chr(152)] = '&tilde;'; // Small Tilde
		$trans[chr(153)] = '&trade;'; // Trade Mark Sign
		$trans[chr(154)] = '&scaron;'; // Latin Small Letter S With Caron
		$trans[chr(155)] = '&rsaquo;'; // Single Right-Pointing Angle Quotation Mark
		$trans[chr(156)] = '&oelig;'; // Latin Small Ligature OE
		$trans[chr(159)] = '&Yuml;'; // Latin Capital Letter Y With Diaeresis
		$trans['&nbsp;'] = '&#160;'; // Latin Capital Letter Y With Diaeresis
		$trans['<'] = '&#60;'; // less then "<"
		$trans['>'] = '&#62;'; // less then ">"
	
		ksort($trans);
		return $trans;
	}
	
	public function autoCreationAccount($accountDetalis,$prefix='AC'){
		//For generating account code for account table
		$session = new CakeSession();
		$accountingGroup = Classregistry::init('AccountingGroup');
		$getExpenseName = Configure::read('acc_expense_group_name');
		$directIncome = Configure::read('acc_income_group_name');
		
		if ($accountDetalis['type'] == 'TariffList' || $accountDetalis['type'] == 'Ward'){
			$groupId = $accountingGroup->getAccountingGroupID($directIncome['direct incomes']);
		}else if($accountDetalis['type'] == 'ServiceProvider' || $accountDetalis['type'] == 'Consultant' ||  $accountDetalis['type'] == 'InventorySupplier'){
			$groupId = $accountingGroup->getAccountingGroupID(Configure::read('sundry_creditors'));
		}elseif($accountDetalis['type'] == 'ExternalPatient'){
			$groupId = $accountingGroup->getAccountingGroupID(Configure::read('sundry_debtors'));
		}else{
			$groupId = $accountingGroup->getAccountingGroupID($getExpenseName['indirect expenses']);
		}
		
		$count = $this->find('count',array('conditions'=>array('Account.create_time like'=> "%".date("Y-m-d")."%",'Account.location_id'=>$session->read('locationid'))));
		$count++ ; //count currrent entry also
		if($count==0){
			$count = "001" ;
		}else if($count < 10 ){
			$count = "00$count"  ;
		}else if($count >= 10 && $count <100){
			$count = "0$count"  ;
		}
		$month_array = array('A','B','C','D','E','F','G','H','I','J','K','L');
		//find the Hospital name.
		$hospital = $session->read('facility');
		//creating patient ID
		$unique_id   = $prefix;
		$unique_id  .= ucfirst(substr($hospital,0,1)); //first letter of the hospital name
		$unique_id  .= strtoupper(substr($session->read('location'),0,2));//first 2 letter of d location
		$unique_id  .= date('y'); //year
		$unique_id  .= $month_array[date('n')-1];//first letter of month
		$unique_id  .= date('d');//day
		$unique_id .= $count;
		
		$this->data['Account']['create_time']=date("Y-m-d H:i:s");
		$this->data['Account']['account_code']=$unique_id;
		$this->data['Account']['status']='Active';
		$this->data['Account']['name']=$accountDetalis['name'];
		$this->data['Account']['user_type']=$accountDetalis['type'];
		$this->data['Account']['system_user_id']=$accountDetalis['id'];
		$this->data['Account']['location_id']=$session->read('locationid');
		$this->data['Account']['accounting_group_id']=$groupId;
		$this->save($this->data['Account']);
		
		return  $this->getLastInsertID(); 
	}
	
	public function getAccountIdOnly($name,$user_type='Account'){
		if(!$name) return false ;
		
		$session= new CakeSession();
		$resultDetails  = $this->find('first',array('conditions'=>array('OR'=>array('Account.name'=>$name,'Account.alias_name'=>$name),
				'Account.is_deleted'=>0,'Account.location_id'=>$session->read('locationid')),
				'fields'=>array('Account.id')));
		$result = $resultDetails['Account']['id'];
		if(empty($resultDetails)){
			$accountDetalis = array('id'=>0,
									'name'=>$name,
									'type'=>$user_type); //for tem accounting group
			$result = $this->autoCreationAccount($accountDetalis);
		}
		$this->id='';
		return $result ;
	}
	
	public function getUserIdOnly($user_id,$type,$name){
		if(!$user_id) return false ;
		
		$session= new CakeSession();
		$resultDetails  = $this->find('first',array('conditions'=>array('Account.system_user_id'=>$user_id,'Account.user_type'=>$type,'Account.is_deleted'=>0,
				'Account.location_id'=>$session->read('locationid')),'fields'=>array('Account.id','Account.name')));
		$result = $resultDetails['Account']['id'];
		if(empty($resultDetails)){
			$accountDetalis = array('id'=>$user_id,
					'name'=>$name,
					'type'=>$type); //for tem accounting group
			$result = $this->autoCreationAccount($accountDetalis);
		}
		return $result ;
	}
	
	/**
	 * function for card balance
	 * @param unknown_type $personId
	 * @return Ambigous <multitype:, NULL, mixed>
	 * @yashwant
	 */
	public function getCardBalance($personId){
		return $cardBal=$this->find('first',array('fields'=>array('Account.card_balance'),'conditions'=>array('Account.system_user_id'=>$personId,'Account.user_type'=>'Patient')));
	}
	
	public function getBankNameList(){
		$session= new CakeSession();
		//BOF for bank name
		$this->bindModel(array(
				'belongsTo' => array(
						'AccountingGroup'=>array('foreignKey' => false,'conditions'=>array('AccountingGroup.id=Account.accounting_group_id')),
				)),false);
		$bankData =$this->find('all',array('fields'=>array('Account.id','Account.name'),'conditions'=>array('Account.is_deleted'=>'0',
				'AccountingGroup.name'=>Configure::read('bankLabel'),'Account.location_id'=>$session->read('locationid')),
				'Order'=>array('Account.name' => 'ASC')));
		
		$bankDataArray = array();
		foreach($bankData as $bank){
			$bankDataArray[$bank['Account']['id']] = $bank['Account']['name'];
		}
		
		return $bankDataArray;
		//EOF for bank name
	}
	
	/**
	 * function for Get Bank Accounts, Cash group all Ledger List 
	 * @param group name $groupName
	 * @return Account List 
	 * @author Amit Jain
	 */
	public function getGroupByAccountList($groupName){
		$session= new CakeSession();
		//BOF for account name
		$this->bindModel(array(
				'belongsTo' => array(
						'AccountingGroup'=>array('foreignKey' => false,'conditions'=>array('AccountingGroup.id=Account.accounting_group_id')),
				)),false);
		$accountData =$this->find('all',array('fields'=>array('Account.id','Account.name'),'conditions'=>array('Account.is_deleted'=>'0',
				'OR'=>array('AccountingGroup.name'=>$groupName,'AccountingGroup.code_name'=>$groupName),'Account.location_id'=>$session->read('locationid')),
				'Order'=>array('Account.name' => 'ASC')));
		
		$accountDataArray = array();
		foreach($accountData as $account){
			$accountDataArray[$account['Account']['id']] = $account['Account']['name'];
		}
		return $accountDataArray;
		//EOF for account name
	}
	
	public function updateNarration($id,$voucherType,$modelName,$narration){
		$session = new CakeSession();
		
		$dynModelObj = ClassRegistry::init($modelName);
		$voucherLogObj = ClassRegistry::init('VoucherLog');
		if(!empty($id)){
			$dynModelObj->updateAll(array('narration'=>"'".$narration."'"),array('id'=>$id));
			$dynModelObj->id='';
			
			$voucherLogObj->updateAll(array('narration'=>"'".$narration."'"),array('voucher_id'=>$id,'voucher_type'=>$voucherType));
			$voucherLogObj->id='';
			return true;
		}else{
			return false;
		}
	}
	
	function getOpeningBalanceData($locationId,$groupId){
		$session = new CakeSession();
	
		if($locationId != 'All'){
			$conditions['Account.location_id']=$locationId;
		}
		if($groupId != ''){
			$conditions['Account.accounting_group_id']=$groupId;
		}
	
		$openingBalData = $this->find('all',array('fields'=>array('Account.id','Account.name','Account.opening_balance','Account.payment_type','Account.accounting_group_id'),
				'conditions'=>array('Account.opening_balance NOT'=>'0','Account.is_deleted'=>0,$conditions)));
		$drOpeningBal = array();
		$crOpeningBal = array();
		foreach ($openingBalData as $key=> $data){
			if($data['Account']['payment_type'] = 'Dr'){
				$drOpeningBal[$key]['Account']['id'] = $data['Account']['id'];
				$drOpeningBal[$key]['Account']['name'] = $data['Account']['name'];
				$drOpeningBal[$key]['Account']['accounting_group_id'] = $data['Account']['accounting_group_id'];
				$drOpeningBal[$key]['Account']['dr_opening_balance'] = $data['Account']['opening_balance'];
			}else{
				$crOpeningBal[$key]['Account']['id'] = $data['Account']['id'];
				$crOpeningBal[$key]['Account']['name'] = $data['Account']['name'];
				$crOpeningBal[$key]['Account']['accounting_group_id'] = $data['Account']['accounting_group_id'];
				$crOpeningBal[$key]['Account']['cr_opening_balance'] = $data['Account']['opening_balance'];
			}
		}
		return array($drOpeningBal,$crOpeningBal);
	}
	
	function getAccountList($userType=null,$id=array()){
		$session = new CakeSession();
		return $this->find('list',array('fields'=>array('Account.id','Account.name'),
				'conditions'=>array($condition,'Account.user_type'=>$userType,'Account.is_deleted'=>'0','Account.system_user_id'=>array_keys($id),
						'Account.location_id'=>$session->read('locationid'))));
	}
	
	/**
	 * function to get Account details
	 * @param  int $id --> Id;
	 * @return array
	 * @author  Amit Jain
	 */
	public function getAccountDetails($id){
		return ($this->find('first',array('fields'=>array('Account.name','Account.system_user_id','Account.user_type'),
				'conditions'=>array('Account.is_deleted'=>'0','Account.id'=>$id))));
	}
	
	/**
	 * function for get count of entry
	 * @param  $id = Accounting Group id
	 * @return count
	 * @author Amit Jain
	 */
	function getEntryCount($id){
		$session= new CakeSession();
		return $this->find('count',array('conditions'=>array('Account.accounting_group_id'=>$id,'Account.is_deleted'=>0,
				'Account.location_id'=>$session->read('locationid'))));
	}
}
?>