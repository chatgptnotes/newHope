<?php
/**
 * Service model
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Bed Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pankaj  wanjari
 * @functions 	 : insertService(insert/update service data).	
 */
class ServiceBill extends AppModel {
	
	public $name = 'ServiceBill';
	public $validate = array(
	            'date' => array(
				'rule' => "notEmpty",
				'message' => "Please enter date."
				),
				 'patient_id' => array(
				'rule' => "notEmpty",
				'message' => "Please select patient."
				),				
			);
	
     public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }    
    function beforeFind($queryData){
    	$queryData['conditions']['ServiceBill.is_deleted']='0';
    	return $queryData;
    }                                       
	//insert and update service details		
	function insertServiceBill($iData=array(),$action='insert'){
		//$count = count($data['ServiceBill']);
		//swap service ele tp serviceBill
		$session = new cakeSession();
	//	$iData['ServiceBill']['location_id'] = $data['Service']['location_id'] ;
	//	$iData['ServiceBill']['patient_id']  = $data['Service']['patient_id'] ;
	//	$iData['ServiceBill']['date']        = $data['Service']['date'] ;
		if($action = 'update'){
			$iData['ServiceBill']['create_time'] = date("Y-m-d H:i:s");
			$iData['ServiceBill']['created_by']  = $session->read('userid') ;
		 
		}else{
			$iData['ServiceBill']['modify_time'] = date("Y-m-d H:i:s");
			$iData['ServiceBill']['modified_by']  = $session->read('userid') ;
		}		
		
		foreach($iData['ServiceBill'] as $key=>$value){			 
			$data['ServiceBill']['service_id'] = $key ;
			$data['ServiceBill']['patient_id'] = $iData['ServiceBill']['patient_id'];
			$data['ServiceBill']['location_id'] = $iData['ServiceBill']['location_id'];
			$data['ServiceBill']['date'] = $iData['ServiceBill']['date'];
			$data['ServiceBill']['corporate_id'] = $iData['ServiceBill']['corporate_id'];
			if(is_array($value)){#pr($value);exit;
				foreach($value as $k=>$v){
					$data['ServiceBill']['morning'] 	= $v['morning']  ;
					$data['ServiceBill']['evening']  	= $v['evening'] ;
					$data['ServiceBill']['night']      =  $v['night'] ;
					$data['ServiceBill']['sub_service_id'] = $k ;
					
					if($v['morning']  == 1){//echo 'here-';
						$data['ServiceBill']['morning_quantity'] = 1;
					}
					if($v['evening'] == 1){
						$data['ServiceBill']['evening_quantity'] = 1;
					}
					if($v['night'] == 1){
						$data['ServiceBill']['night_quantity'] = 1;
					}
					#pr($data);
					$this->save($data);		
					$this->id = ''; 
					$data['ServiceBill']['morning_quantity'] = 0;
					$data['ServiceBill']['evening_quantity'] = 0;
					$data['ServiceBill']['night_quantity'] = 0;
				}
			}			
		}#exit;                                  
        
	}
	
	function saveServiceBill($iData=array(),$action='insert'){
		//$count = count($data['ServiceBill']);
		//swap service ele tp serviceBill
		$session = new cakeSession();
	//	$iData['ServiceBill']['location_id'] = $data['Service']['location_id'] ;
	//	$iData['ServiceBill']['patient_id']  = $data['Service']['patient_id'] ;
	//	$iData['ServiceBill']['date']        = $data['Service']['date'] ;
		if($action = 'update'){
			$iData['ServiceBill']['create_time'] = date("Y-m-d H:i:s");
			$iData['ServiceBill']['created_by']  = $session->read('userid') ;
		 
		}else{
			$iData['ServiceBill']['modify_time'] = date("Y-m-d H:i:s");
			$iData['ServiceBill']['modified_by']  = $session->read('userid') ;
		}		
		#pr($iData);exit;
		foreach($iData['ServiceBill'] as $key=>$value){			 
			$data['ServiceBill']['service_id'] = $key ;
			$data['ServiceBill']['patient_id'] = $iData['billings']['patient_id'];
			$data['ServiceBill']['location_id'] = $iData['billings']['location_id'];
			$data['ServiceBill']['date'] = $iData['billings']['date'];
			$data['ServiceBill']['corporate_id'] = $iData['billings']['corporate_id'];
			if(is_array($value)){
				foreach($value as $k=>$v){
					$data['ServiceBill']['morning'] 	= $v['morning']  ;
					$data['ServiceBill']['evening']  	= $v['evening'] ;
					$data['ServiceBill']['night']      = $v['night'] ;
					$data['ServiceBill']['morning_quantity']      = $v['morning_quantity'] ;
					$data['ServiceBill']['evening_quantity']      = $v['evening_quantity'] ;
					$data['ServiceBill']['night_quantity']      = $v['night_quantity'] ;
					$data['ServiceBill']['sub_service_id'] = $k;
					$this->save($data);
					$this->id = ''; 
				}
			}			
		}#exit;                                  
        
	}
	
	//function to overwrite the paginator count '
	public function PaginateCount($conditions = null, $recursive =0, $extra = array()) {
                $rec = empty($extra['extra']['recursive']) ? $recursive : $extra['extra']['recursive'];
                return $this->find('count', array(
                        'conditions' => $conditions,
                		'fields'=>array('COUNT(DISTINCT(ServiceBill.date)) as count'),
                        'recursive' => $rec,
                		'group'=>array('ServiceBill.date','ServiceBill.patient_id')
                ));
        } 
        
	//function to remove entries after discharged date
	function deleteAfterDischargeRecords($date,$patient_id){
		if(empty($patient_id)) return ;
		$session = new CakeSession();
		$splittedDate = explode(" ",$date ) ; 
		$this->updateAll(array('is_deleted'=>1,'modified_by'=>$session->read('userid')),array("date > "=> $splittedDate[0] ,'patient_id'=>$patient_id)) ;
	}
	
	public function JVServiceData($patient_id){
		
		$session = new cakeSession();
		$patientObj = ClassRegistry::init('Patient');
		$accountObj = ClassRegistry::init('Account');
		$voucherEntry = ClassRegistry::init('VoucherEntry');
		$serviceProviderObj = ClassRegistry::init('ServiceProvider');
		$tariffListObj = ClassRegistry::init('TariffList');
		$voucherReferenceObj = ClassRegistry::init('VoucherReference');
		
		$this->bindModel(array(
				'belongsTo' => array(
						'TariffList'=>array('foreignKey' => false,'conditions'=>array('ServiceBill.tariff_list_id=TariffList.id'))
				)),false);
		$serviceBillData =$this->find('all',array('fields'=>array('ServiceBill.date','ServiceBill.no_of_times','ServiceBill.blood_bank',
				'ServiceBill.tariff_list_id','ServiceBill.amount','ServiceBill.description','ServiceBill.date','TariffList.name'),
				'conditions'=>array('ServiceBill.location_id'=>$session->read('locationid'),'ServiceBill.patient_id'=>$patient_id)));
		
		//for patient information
		$getPatientDetails = $patientObj->getPatientAllDetails($patient_id);
                
                if($getPatientDetails['Patient']['is_paragon'] != '1'){ // if temporary registration then restrict entries -Atul Chandankhede
		$personId = $getPatientDetails['Patient']['person_id'];
		if($getPatientDetails['Patient']['is_staff_register'] == '1'){
				$accId = $accountObj->find('first',array('conditions'=>array('Account.user_type'=>'User',
												'Account.name'=>trim($getPatientDetails['Patient']['lookup_name']),
												'Account.location_id'=>$session->read('locationid')),
												'fields'=>array('Account.id','Account.name')));
		}else{
				$accId = $accountObj->getAccountID($personId,'Patient');//for account id
		}
		
		$regDate  =  DateFormatComponent::formatDate2Local($getPatientDetails['Patient']['form_received_on'],Configure::read('date_format'),true);
		
		foreach($serviceBillData as $key=> $serviceData){
			$doneDate  =  DateFormatComponent::formatDate2Local($serviceData['ServiceBill']['date'],Configure::read('date_format'),true);
			$totalNo = $serviceData['ServiceBill']['no_of_times'];
			if(!empty($serviceData['ServiceBill']['blood_bank'])){
				// for accounting service provider name
				$serviceProviderDetails = $serviceProviderObj->find('first',array('fields'=>array('name','cost_to_hospital'),
						'conditions'=>array('ServiceProvider.id'=>$serviceData['ServiceBill']['blood_bank'],'ServiceProvider.is_deleted'=>0,
								'ServiceProvider.location_id'=>$session->read('locationid'))));
				$accountId = $accountObj->getAccountIdOnly(Configure::read('blood_purchased_Label'));
				$userId = $accountObj->getUserIdOnly($serviceData['ServiceBill']['blood_bank'],'ServiceProvider',$serviceProviderDetails['ServiceProvider']['name']);
			
				$narration = 'Being'." ".$serviceData['TariffList']['name']." ".'charged to patient '.$getPatientDetails['Patient']['lookup_name']." (Date of Registration :".$regDate.")".'done on '.$doneDate;
				$jvData = array('date'=>$serviceData['ServiceBill']['date'],
						'patient_id'=>$patient_id,
						'account_id'=>$accountId,
						'user_id'=>$userId,
						'type'=>'Blood',
						'narration'=>$narration,
						'debit_amount'=>$serviceProviderDetails['ServiceProvider']['cost_to_hospital']*($totalNo));
				if(!empty($jvData['debit_amount']) && ($jvData['debit_amount'] != 0)){
					$voucherEntry->insertJournalEntry($jvData);
					$voucherEntry->id= '';
					// ***insert into Account (By) credit manage current balance
					$accountObj->setBalanceAmountByAccountId($userId,$jvData['debit_amount'],'debit');
					$accountObj->setBalanceAmountByUserId($accountId,$jvData['debit_amount'],'credit');
					$accountObj->id='';
				}
				$vrData = array('reference_type_id'=> '2',
						'voucher_id'=> $voucherEntry->getLastInsertID(),
						'patient_id'=>$patient_id,
						'voucher_type'=> 'journal',
						'location_id'=> $session->read('locationid'),
						'user_id'=> $userId,
						'date' => $serviceData['ServiceBill']['date'],
						'amount'=>$serviceProviderDetails['ServiceProvider']['cost_to_hospital']*($totalNo),
						'credit_period'=>'45',
						'payment_type'=>'Cr',
						'reference_no'=>$voucherEntry->getLastInsertID(),
						'parent_id' => '0');
				$voucherReferenceObj->save($vrData);
				$voucherReferenceObj->id='';
			}
			//EOF
			
			$getTariffListDetails=$tariffListObj->find('first',array('conditions'=>array('TariffList.id'=>$serviceData['ServiceBill']['tariff_list_id'],
					'TariffList.is_deleted'=>0),'fields'=>array('TariffList.name')));//for tariff name
			$userId = $accountObj->getUserIdOnly($serviceData['ServiceBill']['tariff_list_id'],'TariffList',$getTariffListDetails['TariffList']['name']);//for user id
			$totalAmount = $serviceData['ServiceBill']['amount']*($totalNo);
			if(empty($serviceData['ServiceBill']['description'])){
				$narration = 'Being'." ".$getTariffListDetails['TariffList']['name']." ".'charged to patient '.$getPatientDetails['Patient']['lookup_name']." (Date of Registration :".$regDate.")".'done on '.$doneDate;
			}else{
				$narration =$serviceData['ServiceBill']['description'];
			}
			$accountId = $accId['Account']['id'];
			$jvData = array('date'=> $serviceData['ServiceBill']['date'],
					'account_id'=>$accountId,
					'user_id'=>$userId,
					'debit_amount'=>$totalAmount,
					'narration'=>$narration,
					'type'=>'ServiceBill',
					'patient_id'=>$patient_id);
			if(!empty($jvData['debit_amount']) && ($jvData['debit_amount'] != 0)){
				$voucherEntry->insertJournalEntry($jvData);
				$voucherEntry->id= '';
				// ***insert into Account (By) credit manage current balance
				$accountObj->setBalanceAmountByAccountId($userId,$totalAmount,'debit');
				$accountObj->setBalanceAmountByUserId($accountId,$totalAmount,'credit');
				$accountObj->id='';
			}
		}
                }
	}
	
	//BOF for sum of total amount, return patient wise total charges by amit jain
		function getPatientWiseCharges($patientId=array()){
			$session     = new cakeSession();
			if(!$patientId) return false ;
			$amountDetails = $this->find(all,array('conditions'=>array('is_deleted'=>'0','location_id'=>$session->read('locationid'),'patient_id'=>$patientId),
					'fields'=>array('sum(amount) AS totalAmount','patient_id'),'group'=>array("patient_id")));
			return $amountDetails ;
		}
	//EOF
	
	//BOF for sum of paid amount and discount amount, return patient wise service name by amit jain
	function getServiceWiseCharges($patientId=null,$date=null,$userId=null){
		$session     = new cakeSession();
		if(!$patientId) return false ;
		$this->bindModel(array(
				'belongsTo' => array(
						'TariffList' =>array('foreignKey' => false,'conditions'=>array('ServiceBill.tariff_list_id=TariffList.id')),
						'ServiceCategory' =>array('foreignKey' => false,'conditions'=>array('ServiceBill.service_id=ServiceCategory.id')),
						'Billing' =>array('foreignKey' => false,'conditions'=>array('ServiceBill.billing_id=Billing.id')))),false);
		$amountDetails = $this->find(all,array('conditions'=>array('ServiceBill.is_deleted'=>'0','ServiceBill.location_id'=>$session->read('locationid'),
				'ServiceBill.patient_id'=>$patientId,'ServiceBill.paid_amount NOT'=>'0','DATE_FORMAT(Billing.date,"%Y-%m-%d")'=>$date,'Billing.created_by'=>$userId,'Billing.mode_of_payment'=>'Cash'),
				'fields'=>array('ServiceBill.paid_amount','ServiceBill.discount','TariffList.name','ServiceCategory.name')));
		return $amountDetails ;
	}
	//EOF
	
	/**
	 * Function getServices
	 * All services of according to the conditions such as all services of specific patient_id
	 * @param unknown_type $superBillId
	 * @param unknown_type $tariffStandardId
	 * @return multitype:
	 *  returns Array with patient_id(encounter identifier) as encounterwise and serviceCategory id as key and details of individual services
	 *  Pooja Gupta
	 */
	public function getServices($condition=array(),$superBillId=NULL){
	
		if($superBillId){
			//If Superbill id is present then bind model with corporateSuperbill with inner join
			$this->bindModel(array(
					'belongsTo' => array(
							'TariffList' =>array( 'foreignKey'=>false,'type'=>'INNER','conditions'=>array('ServiceBill.tariff_list_id=TariffList.id')),
							/*'CorporateSuperBill'=>array('foreignKey'=>false,'type'=>'INNER','conditions'=>array('ServiceBill.corporate_super_bill_id=CorporateSuperBill.id'))*/
					)),false);
			$condition['OR']=array('ServiceBill.paid_amount <='=>'0','ServiceBill.paid_amount'=>NULL);
			//$condition['ServiceBill.corporate_super_bill_id']=$superBillId;
		}else{
			$this->bindModel(array(
					'belongsTo' => array(
							'TariffList' =>array( 'foreignKey'=>false,'type'=>'INNER','conditions'=>array('ServiceBill.tariff_list_id=TariffList.id')),
					)),false);
		}
	
		$serviceArray=$this->find('all',array('fields'=>array('ServiceBill.id','ServiceBill.service_id','ServiceBill.patient_id','ServiceBill.amount',
				'ServiceBill.paid_amount','ServiceBill.discount','ServiceBill.corporate_super_bill_id',
				'ServiceBill.no_of_times','TariffList.id','TariffList.name','TariffList.service_category_id',
				'TariffList.cghs_code'),
				'conditions'=>array('ServiceBill.is_deleted'=>'0',$condition)));
	
		return $serviceArray;
	
	}
	
	function ServicesUpdate($serviceData,$encId,$catKey,$billId,$percent,$modified){
		$session = new cakeSession();
		$modified_by=$session->read('userid');
		foreach($serviceData as $serviceKey=>$eachData){
			$singleServiceData='';$amtToPay=0;$serDiscount=0;$serpaid=0;
			$singleServiceData=$this->find('first',
					array('fields'=>array('ServiceBill.amount','ServiceBill.no_of_times','ServiceBill.paid_amount',
							'ServiceBill.discount'),
							'conditions'=>array('ServiceBill.id'=>$serviceKey,'ServiceBill.patient_id'=>$encId,
							)));
			$billTariffId[]=$serviceKey; //tariff_list_id serialize array
			$amtToPay=($eachData['balAmt']*$percent)/100;
			$serpaid=$amtToPay+$singleServiceData['ServiceBill']['paid_amount'];
			$serDiscount=($singleServiceData['ServiceBill']['amount']*$singleServiceData['ServiceBill']['no_of_times'])-($serpaid);
			$this->updateAll(
					array('ServiceBill.paid_amount'=>"'$serpaid'",
							'ServiceBill.discount'=>"'$serDiscount'",
							'ServiceBill.billing_id'=>"'$billId'",
							'ServiceBill.modified_by'=>"'$modified_by'",
							'ServiceBill.modified_time'=>"'$modified'"),
					array('ServiceBill.id'=>$serviceKey,'ServiceBill.patient_id'=>$encId));
		}
		return $billTariffId;
	}
	
/* commented by amit jain	
 * public function JvRgjayData($patient_id) {
		$session     = new cakeSession();
		$patientObj = ClassRegistry::init('Patient');
		$accountObj = ClassRegistry::init('Account');
		$voucherEntry = ClassRegistry::init('VoucherEntry');
		$serviceProviderObj = ClassRegistry::init('ServiceProvider');
		$tariffListObj = ClassRegistry::init('TariffList');
		$serviceCategoryObj = ClassRegistry::init('ServiceCategory');
                $finalBilling = ClassRegistry::init('FinalBilling');
			
		$rgjayPackage = $serviceCategoryObj->getServiceGroupIdFromAlias('RGJAY Package');
		$this->bindModel(array(
				'belongsTo' => array(
						'TariffList'=>array('foreignKey' => false,'conditions'=>array('ServiceBill.tariff_list_id=TariffList.id'))
				)),false);
		$serviceBillData =$this->find('all',array('fields'=>array('ServiceBill.id','ServiceBill.no_of_times','ServiceBill.date',
				'ServiceBill.tariff_list_id','ServiceBill.amount','ServiceBill.description','TariffList.name'),
				'conditions'=>array('ServiceBill.location_id'=>$session->read('locationid'),'ServiceBill.patient_id'=>$patient_id,'ServiceBill.service_id'=>$rgjayPackage)));
		
		foreach($serviceBillData as $key=> $serviceData){
			$totalNo = $serviceData['ServiceBill']['no_of_times'];
			//for patient information
			$getPatientDetails=$patientObj->find('first',array('conditions'=>array('Patient.id'=>$patient_id),'fields'=>array('person_id','lookup_name','form_received_on')));
			$personId = $getPatientDetails['Patient']['person_id'];
	
			$regDate  =  DateFormatComponent::formatDate2Local($getPatientDetails['Patient']['form_received_on'],Configure::read('date_format'),true);
			$doneDate  =  DateFormatComponent::formatDate2Local($serviceData['ServiceBill']['date'],Configure::read('date_format'),true);
	
			//EOF
			$accId = $accountObj->getAccountID($getPatientDetails['Patient']['person_id'],'Patient');//for accounting id
			$accountId = $accId['Account']['id'];
	
			$getTariffListDetails=$tariffListObj->find('first',array('fields'=>array('TariffList.name'),
					'conditions'=>array('TariffList.id'=>$serviceData['ServiceBill']['tariff_list_id'],'TariffList.is_deleted'=>0)));//for tariff name
			$userId = $accountObj->getUserIdOnly($serviceData['ServiceBill']['tariff_list_id'],'TariffList',$getTariffListDetails['TariffList']['name']);//for user id
			$totalAmount = $serviceData['ServiceBill']['amount']*($totalNo);
			if(empty($serviceData['ServiceBill']['description'])){
				$narration = 'Being'." ".$getTariffListDetails['TariffList']['name']." ".'charged to patient '.$getPatientDetails['Patient']['lookup_name']." (Date of Registration :".$regDate.")".'done on '.$doneDate;
			}else{
				$narration =$serviceData['ServiceBill']['description'];
			}
			$jvData = array('date'=> $serviceData['ServiceBill']['date'],
					'billing_id'=>$serviceData['ServiceBill']['id'],
					'account_id'=>$accountId,
					'user_id'=>$userId,
					'debit_amount'=>$totalAmount,
					'narration'=>$narration,
					'type'=>'ServiceBill',
					'patient_id'=>$patient_id);
			if(!empty($jvData['debit_amount']) && ($jvData['debit_amount'] != 0)){
				$voucherEntry->insertJournalEntry($jvData);
				$voucherEntry->id= '';
				// ***insert into Account (By) credit manage current balance
				$accountObj->setBalanceAmountByAccountId($accountId,$totalAmount,'debit');
				$accountObj->setBalanceAmountByUserId($userId,$totalAmount,'credit');
				$accountObj->id='';
                                
                                //update in final billing to save the hospital_invoice_amount by swapnil - 26.11.2015
                                $finalBilling->updateAll(array('FinalBilling.hospital_invoice_amount'=>$totalAmount),array('FinalBilling.patient_id'=>$patient_id));
                                $finalBilling->id = '';
			}
                        
		}
	} */
        
        //function to get RGJAY package amount by Swapnil - 09.11.2015
        //void return package amount
        public function getRgjayPackageAmount($patientID){ 
            $serviceCategoryObj = ClassRegistry::init('ServiceCategory'); 
            $rgjayPackageServiceGroupId = $serviceCategoryObj->getServiceGroupIdFromAlias('RGJAY Package');
            $result = $this->find('first',array(
                'fields'=>array('SUM(ServiceBill.amount * ServiceBill.no_of_times) as total'),
                'conditions'=>array('ServiceBill.service_id'=>$rgjayPackageServiceGroupId,'ServiceBill.is_deleted'=>'0','ServiceBill.patient_id'=>$patientID)));
            return $result[0]['total']; 
        }
}
?>
