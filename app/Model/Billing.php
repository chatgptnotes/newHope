<?php
/**
 * Billing Model file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Billing Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 */
 App::uses("ComponentCollection") ;
class Billing extends AppModel {
	
	public $name = 'Billing';
	
	public $actsAs = array('Cipher' => array('autoDecypt' => true,
						   'cipher'=>array('bank_name','account_number','check_credit_card_number','neft_number')));
	
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
	function calculateConsultantCharges($patientId){
		$consultantData = Classregistry::init('ConsultantBilling')->find('all',array('conditions' =>array('patient_id'=>$patientId)));
		$totalCost=0;
		foreach($consultantData as $data){
			$totalCost = $totalCost + $data['ConsultantBilling']['amount'];
		}
		return $totalCost;
	}
	
	/*function calculateServicesCharges($patientId,$corporateId,$creditTypeId){
		Classregistry::init('Services')->bindModel(array(
 								'hasMany' => array( 											 
								'SubService' => array(
            					'className'  => 'SubService')
 						))); 			 
		if($creditTypeId ==1){
			$serviceData = Classregistry::init('Services')->find('all',array('conditions'=>array('corporate_id' => $corporateId,'credit_type_id' => $creditTypeId)));
		}elseif($creditTypeId ==2){
			$serviceData = Classregistry::init('Services')->find('all',array('conditions'=>array('insurance_company_id' => $corporateId,'credit_type_id' => $creditTypeId)));
		}else{
			$serviceData = Classregistry::init('Services')->find('all');	
		}
		$serviceBillData = Classregistry::init('ServiceBill')->find('all',array('conditions'=>array('patient_id'=>$patientId)));
		
		$servicesCostArr = array();
		foreach($serviceData as $services){
			foreach($services['SubService'] as $service){
				$servicesCostArr[$service['id']] = $service['cost'];
			}
		}
		$totalServicesCost = 0;
		foreach($serviceBillData as $serviceBill){
			$totalServicesCost = $totalServicesCost + ($serviceBill['ServiceBill']['morning_quantity']*$servicesCostArr[$serviceBill['ServiceBill']['sub_service_id']])
								+ ($serviceBill['ServiceBill']['evening_quantity']*$servicesCostArr[$serviceBill['ServiceBill']['sub_service_id']])
								+ ($serviceBill['ServiceBill']['night_quantity']*$servicesCostArr[$serviceBill['ServiceBill']['sub_service_id']]);
		}
		return $totalServicesCost;
	}*/
	
	/*function calculateServicesCharges($patientId,$tarrifId){
		Classregistry::init('Services')->bindModel(array(
 								'hasMany' => array( 											 
								'SubService' => array(
            					'className'  => 'SubService')
 						))); 			 
		if($tarrifId !='' && $tarrifId !=0){
			$serviceData = Classregistry::init('Services')->find('all',array('conditions'=>array('corporate_id' => $tarrifId)));
		}else{
			$serviceData = Classregistry::init('Services')->find('all');	
		}
		$serviceBillData = Classregistry::init('ServiceBill')->find('all',array('conditions'=>array('patient_id'=>$patientId)));
		#pr($serviceData);exit;
		$servicesCostArr = array();
		foreach($serviceData as $services){
			foreach($services['SubService'] as $service){
				$servicesCostArr[$service['id']] = $service['cost'];
			}
		}
		$totalServicesCost = 0;
		foreach($serviceBillData as $serviceBill){
			$totalServicesCost = $totalServicesCost + ($serviceBill['ServiceBill']['morning_quantity']*$servicesCostArr[$serviceBill['ServiceBill']['sub_service_id']])
								+ ($serviceBill['ServiceBill']['evening_quantity']*$servicesCostArr[$serviceBill['ServiceBill']['sub_service_id']])
								+ ($serviceBill['ServiceBill']['night_quantity']*$servicesCostArr[$serviceBill['ServiceBill']['sub_service_id']]);
		}
		return $totalServicesCost;
	}*/
	
	function calculateServicesCharges($patientId,$tarrifId){
		
	}
	
	function completeTests($patient_id=null){
			$laboratoryTestOrder = Classregistry::init('LaboratoryTestOrder') ;
 			$radiologyTestOrder  = Classregistry::init('RadiologyTestOrder') ;
 						
			$laboratoryTestOrder->bindModel(array(
 								'belongsTo' => array( 
    									'Laboratory'=>array('foreignKey'=>'laboratory_id','type'=>'inner','conditions'=>array('is_active'=>1))
    								)),false);
    		$radiologyTestOrder->bindModel(array(
 								'belongsTo' => array( 
    									'Radiology'=>array('foreignKey'=>'radiology_id','type'=>'inner','conditions'=>array('is_active'=>1))
    								)),false);    
    												
			$labOrdered = $laboratoryTestOrder->find('list',array('fields'=>array('Laboratory.id','Laboratory.name'),
			'conditions'=>array('LaboratoryTestOrder.patient_id'=>$patient_id),'recursive'=>1));
			
			$radOrdered = $radiologyTestOrder->find('list',array('fields'=>array('Radiology.id','Radiology.name'),
			'conditions'=>array('RadiologyTestOrder.patient_id'=>$patient_id),'recursive'=>1));
			
			return array('Laboratory'=>$labOrdered,'Radiology'=>$radOrdered);
			
			
			
	}
	
	public function calculateWardCharges($patientId=null,$admissionDateTime){
		Classregistry::init('WardBilling')->bindModel(array(
 								'belongsTo' => array( 											 
														'ServicesWard' =>array('foreignKey' => 'services_ward_id')
    												)),false);  
    	$totalCostData = Classregistry::init('WardBilling')->find('all',array('fields'=>array('sum(ServicesWard.sub_service_cost) AS total'),'conditions'=>array('WardBilling.patient_id'=>$patientId)));											
		
    	$WardCostData = Classregistry::init('WardPatient')->find('all',array('conditions'=>array('patient_id'=>$patientId)));
		$totalBedCharges=0;
    	$hack=0;
    		
    	foreach($WardCostData as $wardCost){#pr($wardCost);exit;
	    	$datetime1 = date_create($wardCost['WardPatient']['in_date']);
			if($wardCost['WardPatient']['out_date']==''){
				$datetime2 = date_create(date('Y-m-d'));
				$hack=1;
			}else{
				$datetime2 = date_create($wardCost['WardPatient']['out_date']);
			}
			$interval = date_diff($datetime1, $datetime2);
			$days = $interval->format('%a');
			Classregistry::init('Ward')->unBindModel(
        	array('hasMany' => array('Room','ServicesWard')));  	
			$wardData = Classregistry::init('Ward')->read(array('bed_cost'),$wardCost['WardPatient']['ward_id']);
			#pr($wardData);
			if($hack==1){
				$totalBedCharges = $totalBedCharges + (($days+1)*$wardData['Ward']['bed_cost']);	
			}else{
				$totalBedCharges = $totalBedCharges + ($days*$wardData['Ward']['bed_cost']);
			}
		}
    	$totalCost = $totalCostData[0][0]['total']+$totalBedCharges;
    	#echo $totalCost;exit;
    	return $totalCost;
	}
	
	public function wardChargesDetails($patientId=null){
		Classregistry::init('WardBilling')->bindModel(array(
 				'belongsTo' => array( 											 
						'ServicesWard' =>array('foreignKey' => 'services_ward_id'),
						'Ward' =>array('foreignKey' => 'ward_id')
    												)),false);  
    	
    	
    	#$totalCostData = Classregistry::init('WardBilling')->find('all',array('fields'=>array('sum(ServicesWard.sub_service_cost) AS total'),'conditions'=>array('WardBilling.patient_id'=>$patientId)));											
		
    	$WardCostData = Classregistry::init('WardPatient')->find('all',array('conditions'=>array('patient_id'=>$patientId)));
		$totalBedCharges=0;
    	$hack=0;
    	
    	$doctorCharges = array();
    	$nursingCharges = array();
    	$bedCharges = array();	
    	$doctorIndexCharges=array();
    	$nursingIndexCharges = array();
    	$bedIndexCharges = array();
    	$wardNameArr=array();
    	#pr($WardCostData);exit;
    	foreach($WardCostData as $wardCost){#pr($wardCost);exit;
	    	$datetime1 = date_create($wardCost['WardPatient']['in_date']);
			if($wardCost['WardPatient']['out_date']==''){
				$datetime2 = date_create(date('Y-m-d'));
				$hack=1;
			}else{
				$datetime2 = date_create($wardCost['WardPatient']['out_date']);
			}
			$interval = date_diff($datetime1, $datetime2);
			$days = $interval->format('%a');
			Classregistry::init('Ward')->unBindModel(
        	array('hasMany' => array('Room','ServicesWard')));  	
			$wardData = Classregistry::init('Ward')->read(array('name','bed_cost','doctor_charges','nursing_charges'),$wardCost['WardPatient']['ward_id']);
			#pr($wardData);
			if($hack==1){
				#$totalBedCharges = $totalBedCharges + (($days+1)*$wardData['Ward']['bed_cost']);
				#array_push($doctorIndexCharges,$days+1);
				array_push($doctorCharges,$wardData['Ward']['doctor_charges']);
				array_push($nursingIndexCharges,$days+1);
				array_push($nursingCharges,$wardData['Ward']['nursing_charges']);
				#array_push($bedIndexCharges,$days+1);
				array_push($bedCharges,$wardData['Ward']['bed_cost']);
				array_push($wardNameArr,$wardData['Ward']['name']);
				
			}else{
				#$totalBedCharges = $totalBedCharges + ($days*$wardData['Ward']['bed_cost']);
				#array_push($doctorIndexCharges,$days);
				array_push($doctorCharges,$wardData['Ward']['doctor_charges']);
				array_push($nursingIndexCharges,$days);
				array_push($nursingCharges,$wardData['Ward']['nursing_charges']);
				#array_push($bedIndexCharges,$days);
				array_push($bedCharges,$wardData['Ward']['bed_cost']);
				array_push($wardNameArr,$wardData['Ward']['name']);
				
			}
		}
		$otherServicesWard = Classregistry::init('WardBilling')->find('all',array('conditions'=>array('WardBilling.patient_id'=>$patientId)));
    	#pr($otherServicesWard);exit;
		//$totalCost = $totalCostData[0][0]['total']+$totalBedCharges;
    	#echo $totalCost;exit;
    	return array('index'=>$nursingIndexCharges,'wardOtherCharges'=>$otherServicesWard,'wardName'=>$wardNameArr,'doctorCharges'=>$doctorCharges,'nursingCharges'=>$nursingCharges,'bedCharges'=>$bedCharges);
	}
	
	public function getOtherWardCharges($patientId){
		Classregistry::init('WardBilling')->bindModel(array(
 				'belongsTo' => array( 											 
						'ServicesWard' =>array('foreignKey' => 'services_ward_id')
													)),false);  
    	
    	
    	$totalCostData = Classregistry::init('WardBilling')->find('all',array('fields'=>array('sum(ServicesWard.sub_service_cost) AS total'),'conditions'=>array('WardBilling.patient_id'=>$patientId)));											
		return $totalCostData[0][0]['total'];
    	#pr($totalCostData);exit;
	}
	
	public function getGeneralCharges($tarrifId){
		$this->uses=array('Service');
		$services = Classregistry::init('Service')->find('first',array('conditions'=>array('corporate_id'=>$tarrifId,'name'=>'General Charges')));
		$generalCharges = array();
		foreach($services['SubService'] as $service){
			if($service['service']=='Doctor Charges'){
				$generalCharges['Doctor Charges']=$service['cost'];
			}
			if($service['service']=='Nursing Charges'){
				$generalCharges['Nursing Charges']=$service['cost'];
			}
			if($service['service']=='Bed Charges'){
				$generalCharges['Bed Charges']=$service['cost'];
			}
		}
		return $generalCharges;
		#pr($generalCharges);exit;
	}
	
	//BOF 1053
	//function : returns Billing record 
	function getBillingByID($id=null){
		if(!$id) return false ;
		$result = $this->Find('first',array('conditions'=>array('Billing.id'=>$id)));
		return $result ;
	}
	//EOF 1053

	// by amit jain
	   function getCashierDailyTransactionAmount($date){
		 $accountReceiptModel = ClassRegistry::init('AccountReceipt');
		 $voucherPaymentModel = ClassRegistry::init('VoucherPayment');
		 $accountModel = ClassRegistry::init('Account');
		 
		$session     = new cakeSession();
		$userid 	 = $session->read('userid') ;
		$cashId = $accountModel->getAccountIdOnly(Configure::read('cash'));//for cash id
		$accountReceiptConditions = array('modified_by' => $userid,'AccountReceipt.create_time >=' => $date,
				'AccountReceipt.location_id'=>$session->read('locationid'),'AccountReceipt.is_deleted'=>'0','AccountReceipt.account_id'=>$cashId,'AccountReceipt.is_posted_cash'=>'0');
	
		$voucherPaymentRefundConditions = array('modified_by' => $userid,'VoucherPayment.create_time >=' => $date,
				'VoucherPayment.location_id'=>$session->read('locationid'),'VoucherPayment.is_deleted'=>'0','VoucherPayment.account_id'=>$cashId,'VoucherPayment.is_posted_cash'=>'0','VoucherPayment.type'=>'Refund');
		
		$accountReceiptData = $accountReceiptModel->find('all',array('conditions' => $accountReceiptConditions,
				'fields'=>array('count(AccountReceipt.id) as noOfTransactions','SUM(paid_amount) as amountReceived')));

		$voucherPaymentRefundData = $voucherPaymentModel->find('all',array('conditions' => $voucherPaymentRefundConditions,'fields'=>array('SUM(paid_amount) as refundAmount','count(VoucherPayment.id) as noOfTransactions')));
	
		$currency = $session->read('Currency.currency_symbol');
		$totalReceipt = (int) $accountReceiptData['0']['0']['amountReceived'];
		$totalRefund = (int) $voucherPaymentRefundData['0']['0']['refundAmount'];
		
		$todaysCollection = (int) $accountReceiptData['0']['0']['amountReceived'] ;
		$todaysTransaction = (int)$accountReceiptData['0']['0']['noOfTransactions']  + (int)$voucherPaymentRefundData['0']['0']['noOfTransactions'] ;
		
		return array($todaysCollection,$todaysTransaction,$totalReceipt,$totalRefund);
	} 
	 
	 function getLastLoginDate(){
	 	$session     = new cakeSession();
	 	$date = $session->read('last_login_billing');
	 	$date = DateFormatComponent::formatDate2Local($date,'yyyy-mm-dd',true);
	 	$date = explode(" ",$date);
	 	$date = $date[0];
	 	return $date;
	 }
	 
	 function createBtachID(){
	 	//Batch ID Date
	 	$session     = new cakeSession();
	 	$letters = range('A', 'Z');
	 	$cashierBatchModel = ClassRegistry::init('CashierBatch');
	 	$lastBatchPrefix = $cashierBatchModel->find('first',array('fields'=>array('LEFT(CashierBatch.batch_number, 1) as lastBatchPrefix','CashierBatch.id'),
	 	'conditions'=>array('CashierBatch.date'=>$this->getLastLoginDate()),'order' => array('CashierBatch.id' =>'DESC')));
	 	
	 	$dateFormat = GeneralComponent::getCurrentStandardDateFormat();
	 	if(!empty($lastBatchPrefix['0']['lastBatchPrefix']))
	 		$currentBatchID = ++$lastBatchPrefix['0']['lastBatchPrefix'] .' '. $session->read('username'). ' '. date($dateFormat);
	 	else
	 		$currentBatchID = 'A '. $session->read('username'). ' '. date($dateFormat);
	 	return $currentBatchID;
	 }
	 
	 public function getTotalCashDayAmount(){
	 	
	 	if(empty($date)){
	 		$date = $this->getLastLoginDate();
	 	}
	 	$billingModel = ClassRegistry::init('Billing');
	 	$billingModel->recursive = -1;
	 	$session     = new cakeSession();
	 	$billingConditions = array('DATE_FORMAT(Billing.date, "%Y-%m-%d")' => $date,'Billing.location_id'=>$session->read('locationid'),'Billing.mode_of_payment'=> array('Cash','Credit Card'));
	 	$billingData = $billingModel->find('all',array('conditions' => $billingConditions,'fields'=>array('DATE_FORMAT(LAST_DAY(Billing.date),"%d") as DAY',
	 	'MONTH(Billing.date) as MONTH','SUM(amount) as amount')
	 	,'group' => array('DAY')));
	 	$todaysCollection = (int) $billingData['0']['0']['amount'] ;
	 	return $todaysCollection;
	 	 
	 }
	 
	 function getLastFiledAmountByUser(){
	 	$cashierBatchModel = ClassRegistry::init('CashierBatch');
	 	$session     = new cakeSession();
	 	$userCashBatches = $cashierBatchModel->find('all',array('fields'=>array('SUM(overriden_amount) as overriden_amount','CashierBatch.id'),
	 		 	'conditions'=>array('CashierBatch.modified_by' =>$session->read('userid'),'CashierBatch.date'=>$this->getLastLoginDate()),'order' => array('CashierBatch.id' =>'DESC')));
	 	return $userCashBatches['CashierBatch']['overriden_amount'];
	 }
	 
	 function getOpeningBalanceOfCashier(){
	 	$cashierBatchModel = ClassRegistry::init('CashierBatch');
	 	$date = $this->getLastLoginDate();
	 	$openingBalanceDetails = $cashierBatchModel->find('all',array('fields'=>array('SUM(CashierBatch.overriden_amount) as openingBalance','SUM(CashierBatch.total_amount_overidden) as totalOpeningBalance'),'conditions'=>array('CashierBatch.date'=>$date,'CashierBatch.is_posted'=>0)));
	 	return $openingBalanceDetails;
	 }
	 
	 public function insertLabData($data=array(),$patient_id,$doctor_id){
	 	$session     = new cakeSession();
	 	$LaboratoryTestOrder = ClassRegistry::init('LaboratoryTestOrder');
	 	$Patient = ClassRegistry::init('Patient');
	 	$ServiceCategory = ClassRegistry::init('ServiceCategory');
	 	$tariffStandardObj= ClassRegistry::init('TariffStandard');
	 	$size = count($data['lab_name']);
	 	$patTariffId=$tariffStandardObj->getTariffIDByPatientId($patient_id);
	 	$pvtTariffStd=$tariffStandardObj->getPrivateTariffID();
	 	//$LabGroupID = $serviceCategory->getServiceGroupId('laboratoryservices');
	 	$serviceCategoryID = $ServiceCategory->getServiceGroupIdbyName('Laboratory');
	 	$patient_details  = $Patient->find('first',array('conditions'=>array('Patient.id'=>$patient_id),'fields'=>array('Patient.coupon_name')));
	 	//debug($data);exit;
	 	for($x=0;$x<$size;$x++)
	 	{
		 		if(!empty($data['lab_name'][$x])){
		 			/**************Default discount to be added while adding service for private patients --pooja*************************/
		 			$disAmt=0;
		 			if(Configure::read('apply_discount')=='1' && empty($patient_details['Patient']['coupon_name'])){
		 				if($patTariffId==$pvtTariffStd){
		 					if($data['fix_discount'][$x]){
		 						$disAmt=$this->getCalDiscount($data['fix_discount'][$x],$data['amount'][$x]);
		 						$data['amount'][$x]=$data['amount'][$x]+$disAmt;
		 						$totalPayment=$totalPayment+$data['amount'][$x];
		 						$ldiscount=$ldiscount+$disAmt;
		 					}
		 				}
		 			}
		 			/*******************************************************/
		 		$date=$data['start_date'][$x];
		 		$lDate=$start_date[$x]= DateFormatComponent::formatDate2STD($date,Configure::read('date_format'));
		 		$resetData['LaboratoryTestOrder'][$x]['patient_id'] = $patient_id ;
		 		
		 		if($session->read('website.instance')==Configure::read('websiteInstance')){
		 			$resetData['LaboratoryTestOrder'][$x]['doctor_id'] = $doctor_id ;
		 		}
		 		if(!$data['is_billable'][$x])$data['is_billable'][$x] = 0;
		 		$resetData['LaboratoryTestOrder'][$x]['is_billable'] = $data['is_billable'][$x];
		 		$resetData['LaboratoryTestOrder'][$x]['lab_name']=  $data['lab_name'][$x];
		 		$resetData['LaboratoryTestOrder'][$x]['laboratory_id']= $data['laboratory_id'][$x];
		 		$resetData['LaboratoryTestOrder'][$x]['description']= $data['description'][$x];
		 		$resetData['LaboratoryTestOrder'][$x]['amount']= $data['amount'][$x];
		 		$resetData['LaboratoryTestOrder'][$x]['service_provider_id']= $data['service_provider_id'][$x];
		 		$resetData['LaboratoryTestOrder'][$x]['start_date']= $start_date[$x];
		 		$resetData['LaboratoryTestOrder'][$x]['is_deleted']= '0';
		 		$resetData['LaboratoryTestOrder'][$x]['discount']=$disAmt;
		 		$resetData['LaboratoryTestOrder'][$x]['location_id']= $session->read('locationid');
		 		$resetData['LaboratoryTestOrder'][$x]['create_time']=  date("Y-m-d H:i:s");
		 		$resetData['LaboratoryTestOrder'][$x]['created_by']= $session->read('userid');
		 		//save
				$LaboratoryTestOrder->save($resetData['LaboratoryTestOrder'][$x]);
				$labOrderId =  $LaboratoryTestOrder->autoGeneratedLabID($LaboratoryTestOrder->id);
				$discount = $this->discountCouponBillData($data,$serviceCategoryID,$patient_id,$LaboratoryTestOrder->id,$x);
				if(!empty($discount))
					$LaboratoryTestOrder->saveAll(array('discount'=>$discount+$disAmt,'order_id'=>$labOrderId,'id'=>$LaboratoryTestOrder->id));
				$LaboratoryTestOrder->id ='';
		 	}
	 	}
	 	if(Configure::read('apply_discount')=='1' && empty($patient_details['Patient']['coupon_name'])){
	 		if($patTariffId==$pvtTariffStd){
	 			$this->saveBillingDiscount($patient_id,$lDate,$serviceCategoryID,$totalPayment,$ldiscount);
	 		}
	 	}
	 }
	 
	 public function insertRadData($data=array(),$patient_id,$doctor_id)
	 {
	 	$session     = new cakeSession();
	 	$RadiologyTestOrder = ClassRegistry::init('RadiologyTestOrder');	
	 	$size = count($data['rad_name']);
	 	$Patient = ClassRegistry::init('Patient');
	 	 
	 	$tariffStandardObj= ClassRegistry::init('TariffStandard');
	 	$ServiceCategory = ClassRegistry::init('ServiceCategory');	 	
	 	$serviceCategoryID = $ServiceCategory->getServiceGroupIdbyName('Radiology');
	 	$patTariffId=$tariffStandardObj->getTariffIDByPatientId($patient_id);
	 	$pvtTariffStd=$tariffStandardObj->getPrivateTariffID();
	 	$patient_details  = $Patient->find('first',array('conditions'=>array('Patient.id'=>$patient_id),'fields'=>array('Patient.coupon_name')));
	 	for($x=0;$x<$size;$x++)
	 	{ 
		 	if(!empty($data['rad_name'][$x])){
		 		$disAmt=0;
		 		if(Configure::read('apply_discount')=='1' && empty($patient_details['Patient']['coupon_name'])){
		 			if($patTariffId==$pvtTariffStd){
		 				if($data['fix_discount'][$x]){
		 					$disAmt=$this->getCalDiscount($data['fix_discount'][$x],$data['amount'][$x]);
		 					$data['amount'][$x]=$data['amount'][$x]+$disAmt;
		 					$totalPayment=$totalPayment+$data['amount'][$x];
		 					$rdiscount=$rdiscount+$disAmt;
		 				}
		 			}
		 		}
		 		$date=$data['radiology_order_date'][$x];
		 		$rdate=$radiology_order_date[$x]= DateFormatComponent::formatDate2STD($date,Configure::read('date_format'));
			 	$resetData['RadiologyTestOrder'][$x]['patient_id'] = $patient_id ;
			 	if($session->read('website.instance')=='vadodara'){
			 		$resetData['RadiologyTestOrder'][$x]['doctor_id'] = $doctor_id ;
			 	}
			 	if(!$data['is_billable'][$x])$data['is_billable'][$x] = 0;
			 	$resetData['RadiologyTestOrder'][$x]['is_billable'] = $data['is_billable'][$x] ;
			 	$resetData['RadiologyTestOrder'][$x]['testname']=  $data['rad_name'][$x];
			 	$resetData['RadiologyTestOrder'][$x]['radiology_id']= $data['radiology_id'][$x];
				$resetData['RadiologyTestOrder'][$x]['description']= $data['description'][$x];
				$resetData['RadiologyTestOrder'][$x]['service_provider_id']= $data['service_provider_id'][$x];
				$resetData['RadiologyTestOrder'][$x]['radiology_order_date']= $radiology_order_date[$x];
				$resetData['RadiologyTestOrder'][$x]['amount']= $data['amount'][$x];
			 	$resetData['RadiologyTestOrder'][$x]['is_deleted']= '0';
			 	$resetData['RadiologyTestOrder'][$x]['discount']=$disAmt;
			 	$resetData['RadiologyTestOrder'][$x]['location_id']= $session->read('locationid') ;
			 	$resetData['RadiologyTestOrder'][$x]['create_time']=  date("Y-m-d H:i:s");
			 	$resetData['RadiologyTestOrder'][$x]['created_by']= $session->read('userid');
			 	//save
			 	$RadiologyTestOrder->save($resetData['RadiologyTestOrder'][$x]);
			 	$radOrderId =  $RadiologyTestOrder->autoGeneratedRadID($RadiologyTestOrder->id);
			 	$discount = $this->discountCouponBillData($data,$serviceCategoryID,$patient_id,$RadiologyTestOrder->id,$x);
			 	if(!empty($discount))
			 		$RadiologyTestOrder->saveAll(array('discount'=>$discount+$disAmt,'order_id'=>$radOrderId,'id'=>$RadiologyTestOrder->id));
			 	$RadiologyTestOrder->id ='';
			}
		 }
		 if(Configure::read('apply_discount')=='1' && empty($patient_details['Patient']['coupon_name'])){
		 	if($patTariffId==$pvtTariffStd){
		 		$this->saveBillingDiscount($patient_id,$rdate,$serviceCategoryID,$totalPayment,$rdiscount);
		 	}
		 }
		/*  $RadiologyTestOrder->saveAll($resetData['RadiologyTestOrder']);
		 // save order id...
		 $radOrderId =  $RadiologyTestOrder->autoGeneratedRadID($RadiologyTestOrder->id);
		 $RadiologyTestOrder->saveAll(array('order_id'=>$radOrderId,'id'=>$RadiologyTestOrder->id));
		 $RadiologyTestOrder->id =''; */
	}
	
	
	
	// by amit jain registration charges and first consultation charges for jv
	
	public function getRegistrationCharges($hospitalType,$tariffStandardId,$patient_id){ 
		$session = new CakeSession() ;
		App::import('Vendor', 'DrmhopeDB');
		if(empty($_SESSION['db_name'])){
			$db_connection = new DrmhopeDB('db_hope');
			$db_connection->makeConnection($this);
		}else{
			$db_connection = new DrmhopeDB($_SESSION['db_name']);
		}
		$tariffAmountObj = Classregistry::init('TariffAmount');
		$tariffListObj = Classregistry::init('TariffList');
		$patientObj = Classregistry::init('Patient'); 
		$db_connection->makeConnection($tariffAmountObj);
		$db_connection->makeConnection($tariffListObj);
		$db_connection->makeConnection($patientObj);
		//skip registration charges if the optino is selected
		$patientObj->unBindModel(array('hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$patientData = $patientObj->find('first',array('fields'=>array('treatment_type','admission_type'),'conditions'=>array('Patient.id'=>$patient_id)));
		if(($patientData['Patient']['treatment_type']===0 || empty($patientData['Patient']['treatment_type'])) && ($patientData['Patient']['admission_type']=='OPD'))
			return 0 ;
		
		//by amit

		if(strtolower($patientData['Patient']['admission_type'])=='ipd'){
			if($session->read('website.instance') == 'kanpur'){//yashwant
				$registrationCharges = Configure::read('RegistrationChargesIPD');
			}else{
				$registrationCharges = Configure::read('RegistrationCharges');
			}
			$serviceType="IPD";
			$registId = $tariffListObj->find('first',array('fields'=>array('TariffList.id'),
			'conditions'=>array('TariffList.code_name LIKE'=>$registrationCharges,'TariffList.location_id'=>$session->read('locationid'))));
		}else{					
			$registrationCharges = Configure::read('RegistrationCharges');
			$serviceType="OPD";
			$registId = $tariffListObj->find('first',array('fields'=>array('TariffList.id'),
			'conditions'=>array('TariffList.code_name LIKE'=>$registrationCharges,'TariffList.location_id'=>$session->read('locationid'))));			
		}

		$id = $registId['TariffList']['id'];
			
		$registrationRateData=$tariffAmountObj->find('first',array('conditions'=>array('tariff_list_id'=>$id,'tariff_standard_id'=>$tariffStandardId)));
	
		if($hospitalType=='NABH'){
			$registrationRate=$registrationRateData['TariffAmount']['nabh_charges'];
		}else{
			$registrationRate=$registrationRateData['TariffAmount']['non_nabh_charges'];
		} 
		return $registrationRate;
	}
	
	
	/**
	 * 
	 * @param int $days
	 * @param varchar $hospitalType (NABH OR NON)
	 * @param int $tariffStandardId  - tariif of patient 
	 * @param varchar $patientType - IPD or OPD
	 * @param int $treatment_type - visit type for OPD (first consultation or follow up)
	 * @return int service charges for OPD and doctors charges for IPD
	 */
	public function getDoctorRate($days,$hospitalType,$tariffStandardId,$patientType='',$treatment_type=null,$patient_id=null,$doctor_id=null){
		 
		
		$session  = new CakeSession();
		//cond added for IPD patient vadodara only as no need to add doctor charges 
		if($session->read('website.instance')=='vadodara' && $patientType =='IPD') return false ;
		$tariffAmountObj = Classregistry::init('TariffAmount');		
		$tariffListObj = Classregistry::init('TariffList');
		
		$tariffListId=$tariffListObj->getServiceIdByName(Configure::read('DoctorsCharges'));//get tariff list id
		
	/* 	$doctorRateData = $tariffAmountObj->find('first',array('fields'=>array('TariffAmount.id','TariffAmount.nabh_charges','TariffAmount.non_nabh_charges'),
				'conditions'=>array('TariffAmount.tariff_list_id'=>20446,
						'TariffAmount.tariff_standard_id'=>4,'TariffAmount.location_id'=>$session->read('locationid')))); */
		
		
		$days=1; 		
		if($patientType=='OPD'){
			$doctorRateData = $tariffAmountObj->find('first',array('fields'=>array('TariffAmount.id','TariffAmount.nabh_charges','TariffAmount.non_nabh_charges'),
					'conditions'=>array('TariffAmount.tariff_list_id'=>$treatment_type,
							'TariffAmount.tariff_standard_id'=>$tariffStandardId,'TariffAmount.location_id'=>$session->read('locationid'))));
			$days=1; 
			$doctorRate	= $this->getTimelyConsultationCharges($doctorRateData['TariffAmount']['id'],$patient_id,$hospitalType,$doctor_id); //return timewise and daywise charges			
		}else if ($patientType=='IPD'){ //for IPD charges change tariff_list_id as per required service
			$doctorRateData=$tariffAmountObj->find('first',array('conditions'=>array('tariff_list_id'=>$tariffListId,'tariff_standard_id'=>$tariffStandardId)));
		}	
 		 
		if($doctorRate < 1 || $patientType=='IPD'){
			if($hospitalType=='NABH'){
				$doctorRate=$doctorRateData['TariffAmount']['nabh_charges'];
			}else{
				$doctorRate=$doctorRateData['TariffAmount']['non_nabh_charges'];
			}
		}
		 
		
		return $doctorRate;
	}
	
	//last transaction amount in AccountReceipt and VoucherPayment for cashier transaction by amit jain
	function getLastReceiptAmount($date)
	 {
		$receiptModel = ClassRegistry::init('AccountReceipt');
		$paymentModel = ClassRegistry::init('VoucherPayment');
		$accountModel = ClassRegistry::init('Account');
		$session  = new CakeSession();
		
		$cashId = $accountModel->getAccountIdOnly(Configure::read('cash'));//for cash id
		
		$lastReceiptAmountDetails = $receiptModel->find('first',array('fields'=>array('AccountReceipt.paid_amount','AccountReceipt.date'),
				'conditions'=>array('AccountReceipt.is_deleted'=>'0','AccountReceipt.create_by'=>$session->read('userid'),'AccountReceipt.account_id'=>$cashId,
						'AccountReceipt.location_id'=>$session->read('locationid'),'AccountReceipt.create_time >='=>$date),
				'order' => array('AccountReceipt.id' =>'DESC')));
		$lastReceiptAmount = $lastReceiptAmountDetails['AccountReceipt']['paid_amount'];
		
		$lastPaymentAmountDetails = $paymentModel->find('first',array('fields'=>array('VoucherPayment.paid_amount','VoucherPayment.date'),
				'conditions'=>array('VoucherPayment.is_deleted'=>'0','VoucherPayment.create_by'=>$session->read('userid'),'VoucherPayment.account_id'=>$cashId,'VoucherPayment.type'=>'Refund',
						'VoucherPayment.location_id'=>$session->read('locationid'),'VoucherPayment.create_time >='=>$date),
				'order' => array('VoucherPayment.id' =>'DESC')));
		$lastPaymentAmount = $lastPaymentAmountDetails['VoucherPayment']['paid_amount'];

		if($lastReceiptAmountDetails['AccountReceipt']['date'] > $lastPaymentAmountDetails['VoucherPayment']['date']){
			$lastAmount =  $lastReceiptAmount;
		}else{
			$lastAmount = $lastPaymentAmount;
		}
		return $lastAmount;
		
	} 
	
	//funtion to return timely and day wise charges 
	function getTimelyConsultationCharges($tariff_amount_id=null,$patient_id=null,$hospitalType=null,$doctor_id=null){
		
		//echo "tariff=".$tariff_amount_id."patient id".$patient_id ;
		if(!$tariff_amount_id || !$patient_id)  return false ; 
		 
		$tariffChargesObj = Classregistry::init('TariffCharge');
		$patientObj = Classregistry::init('Patient'); 
		//find registration time to apply registration chargees  
		$patientObj->unBindModel(array('hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn'))); 
		$patientData = $patientObj->find('first',array('conditions'=>array('id'=>$patient_id),'fields'=>'form_received_on'));
		
		$convertedDateTime = DateFormatComponent::formatDate2Local($patientData['Patient']['form_received_on'],'yyyy-mm-dd',true) ;
		$splittedTime = explode(" ",$convertedDateTime) ;		 
		$splittedTimeArray = explode(":",$splittedTime[1]) ; 
		$hrMin = $splittedTimeArray[0].":".$splittedTimeArray[1] ; 
		
		//$regDate  = strtotime($patientData['Patient']['form_received_on']) ;	

		$regDate  =  strtotime(DateFormatComponent::formatDate2Local($patientData['Patient']['form_received_on'],'yyyy-mm-dd',true));
		
		
		$day  = date("l",$regDate); 
		
		//EOF reg time checke 
		$charges  = $tariffChargesObj->find('first',array('conditions'=>array(
				'TariffCharge.tariff_amount_id'=>$tariff_amount_id,
				'TariffCharge.start <='=>$hrMin,
				'TariffCharge.end >='=>$hrMin,
				strtolower($day)=>1,
				'TariffCharge.doctor_id'=>$doctor_id,
				'TariffCharge.is_deleted'=>0)));
		 
		if($hospitalType=='NABH'){
			$tariffCharges =$charges['TariffCharge']['nabh_charges'];
		}else{
			$tariffCharges =$charges['TariffCharge']['non_nabh_charges'];
		} 
		return $tariffCharges  ; 
	} 
	
	
	/*
	 * BOF of updation of radiolody records by yashwant
	 */
	function UpdateRadiologyRec($data=null,$patientID=null,$recID=null)
	{
		$session     = new cakeSession();
		$RadiologyTestOrder = ClassRegistry::init('RadiologyTestOrder');

		$date= DateFormatComponent::formatDate2STD($data['date'],Configure::read('date_format'));
		$resetData['RadiologyTestOrder']['patient_id'] = $patientID ;
		$resetData['RadiologyTestOrder']['testname']=  $data['test_name'];
		$resetData['RadiologyTestOrder']['radiology_id']= $data['radID'];
		$resetData['RadiologyTestOrder']['description']= $data['description'];
		$resetData['RadiologyTestOrder']['service_provider_id']= $data['servicePrivider'];
		$resetData['RadiologyTestOrder']['is_billable'] = $data['is_billable'] ;
		$resetData['RadiologyTestOrder']['radiology_order_date']= $date;
		$resetData['RadiologyTestOrder']['amount']= $data['amount'];
		$resetData['RadiologyTestOrder']['is_deleted']= '0';
		$resetData['RadiologyTestOrder']['location_id']= $session->read('locationid') ;
		$resetData['RadiologyTestOrder']['modify_time']=  date("Y-m-d H:i:s");
		$resetData['RadiologyTestOrder']['modified_by']= $session->read('userid');
		$resetData['RadiologyTestOrder']['id']= $recID;
		
		$RadiologyTestOrder->saveAll($resetData['RadiologyTestOrder']);
	}
	
	/*
	 * BOF of updation of laboratory records by yashwant
	*/
	function UpdateLaboratoryRec($data=null,$patientID=null,$recID=null)
	{
		$session     = new cakeSession();
		$LaboratoryTestOrder = ClassRegistry::init('LaboratoryTestOrder');
	
		$date=$data['date'];
		$start_date= DateFormatComponent::formatDate2STD($date,Configure::read('date_format'));
		$resetData['LaboratoryTestOrder']['patient_id'] = $patientID ;
		$resetData['LaboratoryTestOrder']['lab_name']=  $data['test_name'];
		$resetData['LaboratoryTestOrder']['laboratory_id']= $data['labID'];
		$resetData['LaboratoryTestOrder']['description']= $data['description'];
		$resetData['LaboratoryTestOrder']['amount']= $data['amount'];
		$resetData['LaboratoryTestOrder']['service_provider_id']= $data['servicePrivider'];
		$resetData['LaboratoryTestOrder']['is_billable'] = $data['is_billable'] ;
		$resetData['LaboratoryTestOrder']['start_date']= $start_date;
		$resetData['LaboratoryTestOrder']['is_deleted']= '0';
		$resetData['LaboratoryTestOrder']['location_id']= $session->read('locationid') ;
		$resetData['LaboratoryTestOrder']['modify_time']=  date("Y-m-d H:i:s");
		$resetData['LaboratoryTestOrder']['modified_by']= $session->read('userid');
		$resetData['LaboratoryTestOrder']['id']= $recID;
		
		$LaboratoryTestOrder->saveAll($resetData['LaboratoryTestOrder']);
	}
	
	/*
	 * BOF of updation of service records by yashwant
	*/
	function UpdateServiceRec($data=null,$patientID=null,$recID=null,$groupID=null)
	{
		$session     = new cakeSession();
		$ServiceBill = ClassRegistry::init('ServiceBill');
		$TariffStandard = ClassRegistry::init('TariffStandard');
	 
		if(!$data['tariff_standard_id']) 
		  $data['tariff_standard_id'] = $TariffStandard->getPrivateTariffID() ; //backup with private patient
		   
		$date=$data['date'];
		$start_date= DateFormatComponent::formatDate2STD($date,Configure::read('date_format'));
		$resetData['ServiceBill']['patient_id'] = $patientID ;
		$resetData['ServiceBill']['tariff_standard_id']=  $data['tariff_standard_id'];
		$resetData['ServiceBill']['service_id']= $groupID;
		$resetData['ServiceBill']['tariff_list_id']= $data['serviceID'];
		$resetData['ServiceBill']['sub_service_id']= $data['subGroupID'];
		$resetData['ServiceBill']['amount']= $data['amount'];
		$resetData['ServiceBill']['no_of_times']= $data['noOfTimes'];
		$resetData['ServiceBill']['is_billable'] = $data['is_billable'] ;
		$resetData['ServiceBill']['date']= $start_date;
		$resetData['ServiceBill']['description']= $data['description'];
		$resetData['ServiceBill']['blood_bank']= $data['bloodBank'];
		$resetData['ServiceBill']['suplier']= $data['suplier'];
		//$resetData['ServiceBill']['paid_amount']= $data['paid_amount'];
		$resetData['ServiceBill']['is_deleted']= '0';
		$resetData['ServiceBill']['location_id']= $session->read('locationid') ;
		$resetData['ServiceBill']['modified_time']=  date("Y-m-d H:i:s");
		$resetData['ServiceBill']['modified_by']= $session->read('userid');
		$resetData['ServiceBill']['id']= $recID;
		 
		$ServiceBill->saveAll($resetData['ServiceBill']);
	}
	
	
	/*
	 * BOF of updation of ward_patient_service records by yashwant
	*/
	function UpdateWardPatientRec($data=null,$patientID=null,$recID=null){  
		$session     = new cakeSession();
		$WardPatientService = ClassRegistry::init('WardPatientService');
		  
		$date=$data['date'];
		$date= DateFormatComponent::formatDate2STD($date,Configure::read('date_format'));
		if($date){
			$dateArray=$WardPatientService->find('list',array('fields'=>array('id','date'),
				'conditions'=>array('WardPatientService.patient_id'=>$patientID,'WardPatientService.is_deleted'=>'0','DATE_FORMAT(WardPatientService.date,"%Y-%m-%d")'=>$date)));
			if ($dateArray){
				$error='Duplicate entry for same day.';
				return $error;
				exit;
			} 
		}
		$resetData['WardPatientService']['patient_id'] = $patientID ;
		$resetData['WardPatientService']['ward_id']=  $data['ward_id'];
		$resetData['WardPatientService']['room_id']=  $data['room_id'];
		$resetData['WardPatientService']['amount']= $data['amount'];
		$resetData['WardPatientService']['service_id']= $data['groupID'];
		
		if($recID){
			$resetData['WardPatientService']['modified_time']=  date("Y-m-d H:i:s");
			$resetData['WardPatientService']['modified_by']= $session->read('userid');
		}else{
			//$resetData['WardPatientService']['unit']= $data['unit'];
			$resetData['WardPatientService']['date']= $date;
			$resetData['WardPatientService']['location_id']= $session->read('locationid');
			$resetData['WardPatientService']['is_deleted']= '0';
			$resetData['WardPatientService']['create_time']=  date("Y-m-d H:i:s");
			$resetData['WardPatientService']['created_by']= $session->read('userid');
		}
		$resetData['WardPatientService']['id']= $recID;
		$WardPatientService->save($resetData['WardPatientService']);
	}
	
	
	
	/*
	 * function for surgery charges in billing
	*/
	public function surgeryChargesForBilling($patientId=null,$tariffStandardId=null){
		
		$session     = new cakeSession();
		$OptAppointment = ClassRegistry::init('OptAppointment');
		$TariffStandard = ClassRegistry::init('TariffStandard');
		$ServiceCategory= ClassRegistry::init('ServiceCategory');
		
		//if(!$tariffStandardId) $tariffStandardId = $TariffStandard->getPrivateTariffID() ;
		$OptAppointment->unbindModel(array(
				'belongsTo' => array('Initial','Patient','Location','Opt','OptTable','Surgery',
						'SurgerySubcategory','Doctor','DoctorProfile')));
		//Payment category Id Of "Surgery" -- Pooja
		$ServiceCategory->unbindModel(array('hasMany'=>array('ServiceSubCategory')));
		$paymentCategoryId=$ServiceCategory->find('first',array('fields'=>array('id'),
				'conditions'=>array('ServiceCategory.name Like'=>Configure::read('surgeryservices'))));
		
		$OptAppointment->bindModel(array(
				'belongsTo' => array(
						'Patient'=>array('foreignKey'=>'patient_id'),
						'TariffList' =>array( 'foreignKey'=>'tariff_list_id','type'=>'LEFT','conditions'=>array('TariffList.is_deleted'=>0)),
						'Surgeon' =>array('className'=>'DoctorProfile',
								'foreignKey'=>false,
								'type'=>'LEFT',
								'conditions'=>array('Surgeon.user_id=OptAppointment.doctor_id')),
						'User'=>array('foreignKey'=>'doctor_id'),
						'Initial'=>array('foreignKey'=>false,'conditions'=>array('Initial.id=User.initial_id')),
						'Anaesthesist' =>array('className'=>'DoctorProfile',
								'foreignKey'=>false,
								'type'=>'LEFT',
								'conditions'=>array('Anaesthesist.user_id=OptAppointment.department_id')),
						'AnaeUser'=>array('className'=>'User','foreignKey'=>'department_id'),
						'AnaeInitial'=>array('className'=>'Initial','foreignKey'=>false,'conditions'=>array('AnaeInitial.id=AnaeUser.initial_id')),
						'TariffAmount' =>array( 'foreignKey'=>false,'conditions'=>array('TariffAmount.tariff_list_id=OptAppointment.tariff_list_id',
								'TariffAmount.tariff_standard_id'=>$tariffStandardId)),
						'Surgery'=>array('foreignKey'=>'surgery_id'),
						'AnaeTariffAmount' =>array('className'=>'TariffAmount',
								'foreignKey'=>false,
								'conditions'=>array('AnaeTariffAmount.tariff_list_id=OptAppointment.anaesthesia_tariff_list_id',"AnaeTariffAmount.tariff_standard_id"=>$tariffStandardId)),
						'Billing'=>array('foreignKey'=>false,'conditions'=>array('TariffList.id=Billing.tariff_list_id','Patient.id=Billing.patient_id','Billing.payment_category'=>$paymentCategoryId['ServiceCategory']['id'])),
				)));
	
		$surgery_Data = $OptAppointment->find('all',
				array('conditions'=>array('OptAppointment.location_id'=>$session->read('locationid'),/** is_false_appointment == 0 means non packaged ot */
						'OptAppointment.is_deleted'=>0,'OptAppointment.patient_id'=>$patientId,'OptAppointment.is_false_appointment'=>0),
						'fields'=>array('Billing.*','OptAppointment.anaesthesia_tariff_list_id','Surgeon.education','Surgeon.doctor_name','Anaesthesist.education','Anaesthesist.doctor_name','TariffList.*,TariffAmount.moa_sr_no,
									TariffAmount.tariff_list_id,TariffAmount.nabh_charges,TariffAmount.non_nabh_charges,
									TariffAmount.unit_days','AnaeTariffAmount.id','AnaeTariffAmount.nabh_charges','AnaeTariffAmount.non_nabh_charges',
								'OptAppointment.starttime','OptAppointment.endtime','Surgery.name','Initial.name','AnaeInitial.name',
								'OptAppointment.schedule_date','OptAppointment.department_id','TariffList.name','OptAppointment.surgery_cost','OptAppointment.anaesthesia_cost','OptAppointment.ot_charges'),
						'order'=>'OptAppointment.schedule_date Asc',
						'group'=>'OptAppointment.id',
						'recursive'=>1));
			
			
	
		/********************** Surgery Data Starts ******************************/
		$hospitalType = $session->read('hospitaltype');
		if($hospitalType=='NABH'){
			$chargeType='nabh_charges';
		}else{
			$chargeType='non_nabh_charges';
		}
		$surgeries = array();
		/* foreach($surgery_Data as $uniqueSurgery){
		 //convert date to local format
		$sugeryDate = $dateFormatComObj->formatDate2Local($uniqueSurgery['OptAppointment']['starttime'],'yyyy-mm-dd',true);
		$sugeryEndDate = $dateFormatComObj->formatDate2Local($uniqueSurgery['OptAppointment']['endtime'],'yyyy-mm-dd',true);
		$surgeries[]=array('name'=>$uniqueSurgery['Surgery']['name'],
				'surgeryScheduleDate'=>$sugeryDate,
				'surgeryScheduleEndDate'=>$sugeryEndDate,
				'surgeryAmount'=>$uniqueSurgery['TariffAmount'][$chargeType],
				'unitDays'=>$uniqueSurgery['TariffAmount']['unit_days'],
				'cghs_nabh'=>$uniqueSurgery['TariffList']['cghs_nabh'],
				'cghs_non_nabh'=>$uniqueSurgery['TariffList']['cghs_non_nabh'],
				'cghs_code'=>$uniqueSurgery['TariffList']['cghs_code'],
				'moa_sr_no'=>$uniqueSurgery['TariffAmount']['moa_sr_no'],
				'doctor'=>$uniqueSurgery['Initial']['name'].$uniqueSurgery['Surgeon']['doctor_name'],
				'doctor_education'=>$uniqueSurgery['Surgeon']['education'],
				'anaesthesist'=>$uniqueSurgery['AnaeInitial']['name'].$uniqueSurgery['Anaesthesist']['doctor_name'],
				'anaesthesist_education'=>$uniqueSurgery['Anaesthesist']['education'],
				'anaesthesist_cost'=>$uniqueSurgery['AnaeTariffAmount'][$chargeType]
		);
		}
		pr($surgeries); */
		//$this->set('surgeryData',$surgery_Data); //set all surgeries array
		return $surgery_Data;
	}
	
	/**
	 * function for surgery charges
	 * @author Gaurav Chauriya
	 */
	public function surgeryCharges($patientId=null,$tariffStandardId=null){
	
		$session = new cakeSession();
		$OptAppointment = ClassRegistry::init('OptAppointment');
		$TariffList = ClassRegistry::init('TariffList');
		$OptAppointment->unbindModel(array('belongsTo' => array('Initial','Patient','Location','Opt','OptTable','Surgery','SurgerySubcategory','Doctor','DoctorProfile')));
		$procedureCompleteSondition = ($session->read('website.instance') == 'kanpur') ? 'OptAppointment.procedure_complete = 1' : '';
		$surgeryData = $OptAppointment->find('all',
				array('conditions'=>array('OptAppointment.location_id'=>$session->read('locationid'),'OptAppointment.is_deleted'=>0,'OptAppointment.patient_id'=>$patientId,
						'OptAppointment.is_false_appointment'=>0,/* false app != 0 only for privatepackaged patient */$procedureCompleteSondition),
						'fields'=>array('OptAppointment.surgery_cost','OptAppointment.ot_charges','OptAppointment.anaesthesia_cost','OptAppointment.surgeon_amt',
								'OptAppointment.asst_surgeon_one_charge','OptAppointment.asst_surgeon_two_charge','OptAppointment.cardiologist_charge',
								'OptAppointment.ot_asst_charge','OptAppointment.ot_in_date','OptAppointment.out_date','OptAppointment.operation_type','OptAppointment.ot_service'),
						'order'=>'OptAppointment.schedule_date Asc','group'=>'OptAppointment.id','recursive'=>1));
		if($session->read('website.instance') == 'kanpur'){
			$TariffList->bindModel(array(
					'hasOne' => array(
							'TariffAmount' =>array( 'foreignKey'=>'tariff_list_id','conditions'=>array('TariffList.is_deleted'=>0))
					)));
		}
		if($session->read('hospitaltype') == 'NABH')
			$chargeType='nabh_charges';
		else
			$chargeType='non_nabh_charges';
		$surgeriesCharges = 0;
		foreach($surgeryData as $uniqueSurgery){
			if($session->read('website.instance') == 'kanpur'){
				$otServices = explode(',',$uniqueSurgery[OptAppointment][ot_service]);
				$totalServiceCharge = $TariffList->find('first',array('fields'=>array("SUM(TariffAmount.".$chargeType.") AS Total"),
						'conditions'=>array("TariffList.id"=>$otServices)));
			} 
			$otInDate = $uniqueSurgery['OptAppointment']['ot_in_date'];
			$otOutDate = $uniqueSurgery['OptAppointment']['out_date'];
			$optType = $uniqueSurgery['OptAppointment']['operation_type'];
			$extraTimeOtCharge = $this->getExtraTimeOtCharge($otInDate,$otOutDate,$optType);
			$surgeriesCharges = $surgeriesCharges + $uniqueSurgery['OptAppointment']['surgery_cost'] + $uniqueSurgery['OptAppointment']['anaesthesia_cost'] +
			$uniqueSurgery['OptAppointment']['ot_charges'] + $uniqueSurgery['OptAppointment']['surgeon_amt'] + $uniqueSurgery['OptAppointment']['asst_surgeon_one_charge'] +
			$uniqueSurgery['OptAppointment']['asst_surgeon_two_charge'] + $uniqueSurgery['OptAppointment']['cardiologist_charge'] +
			$uniqueSurgery['OptAppointment']['ot_asst_charge'] + $this->getExtraTimeOtCharge($otInDate,$otOutDate,$optType) + $totalServiceCharge['0']['Total'] ;
		}
		return $surgeriesCharges;
	}
	
	/**
	 * function for updating charges according to new tariff
	 * By yashwant
	 * @params patient_id, tariff_standerd_id
	 * return updated charges
	 */
	public function changeTariff($patient_id=null,$tariffStandardId=null){		
		$updateLabCharge=$this->updateLabCharge($patient_id,$tariffStandardId);//updating lab charges		
		$updateRadCharge=$this->updateRadCharge($patient_id,$tariffStandardId);//updating rad charges		
		$updateServiceCharge=$this->updateServiceCharge($patient_id,$tariffStandardId);//updating service charges
		$updateSurgeryCharge=$this->updateSurgeryCharge($patient_id,$tariffStandardId);//updating surgery/package charges
		//by pankaj 
		$wardPatientService = ClassRegistry::init('WardPatientService');
		$wardPatientService->updateWardCharges($patient_id,$tariffStandardId);
		$updateConsultantCharge=$this->updateConsultantCharge($patient_id,$tariffStandardId);//updating consultant charges
	}
	
	/**
	 * updating lab charge function
	 * By yashwant
	 * @params patient_id, tariff_standerd_id
	 * return updated charges
	 */
	public function updateLabCharge($patient_id=null,$tariffStandardId=null){
		
		$session     = new cakeSession();
		$Laboratory = ClassRegistry::init('Laboratory');
		$LaboratoryTestOrder = ClassRegistry::init('LaboratoryTestOrder');
			
		$Laboratory->bindModel(array(
				'belongsTo' => array(
						'TariffAmount'=>array('foreignKey' => false,'conditions'=>array('TariffAmount.tariff_list_id=Laboratory.tariff_list_id',
								'TariffAmount.tariff_standard_id'=>$tariffStandardId)),
						'LaboratoryTestOrder'=>array('foreignKey' => false,'conditions'=>array('LaboratoryTestOrder.laboratory_id=Laboratory.id'))
				)),false);
		
		$laboratoryData= $Laboratory->find('all',array(
				'fields'=> array('LaboratoryTestOrder.id','Laboratory.name','Laboratory.id','TariffAmount.nabh_charges,TariffAmount.non_nabh_charges'),
				'conditions'=>array('Laboratory.location_id'=>$session->read('locationid'),'Laboratory.is_deleted'=>0,
				'Laboratory.is_active'=>1,'LaboratoryTestOrder.patient_id'=>$patient_id)));
		
		$hospitalType =$session->read('hospitaltype');
		if($hospitalType == 'NABH'){
			$serviceCostType = 'nabh_charges';
		}else{
			$serviceCostType = 'non_nabh_charges';
		}
		
		foreach($laboratoryData as $key=>$laboratoryDataValue){
			$labServiceCost = ($laboratoryDataValue['TariffAmount'][$serviceCostType])?$laboratoryDataValue['TariffAmount'][$serviceCostType]:0 ;
			$LaboratoryTestOrder->updateAll(array('amount'=>$labServiceCost),
					array('LaboratoryTestOrder.patient_id'=>$patient_id,'LaboratoryTestOrder.id'=>$laboratoryDataValue['LaboratoryTestOrder']['id']));
		}
	}
	
	/**
	 * updating rad charge function
	 * By yashwant
	 * @params patient_id, tariff_standerd_id
	 * return updated charges
	 */
	public function updateRadCharge($patient_id=null,$tariffStandardId=null){
	
		$session     = new cakeSession();
		$Radiology = ClassRegistry::init('Radiology');
		$RadiologyTestOrder = ClassRegistry::init('RadiologyTestOrder');
			
		$Radiology->bindModel(array(
				'belongsTo' => array(
						'TariffAmount'=>array('foreignKey' => false,'conditions'=>array('TariffAmount.tariff_list_id=Radiology.tariff_list_id' ,
										'TariffAmount.tariff_standard_id'=>$tariffStandardId)),
						'RadiologyTestOrder'=>array('foreignKey' => false,'conditions'=>array('RadiologyTestOrder.radiology_id=Radiology.id'))
				)),false);
	
		$radiologyData= $Radiology->find('all',array(
				'fields'=> array('RadiologyTestOrder.id','Radiology.name,Radiology.id,TariffAmount.nabh_charges,TariffAmount.non_nabh_charges'),
				'conditions'=>array('Radiology.location_id'=>$session->read('locationid'),'Radiology.is_deleted'=>0,
						'Radiology.is_active'=>1,'RadiologyTestOrder.patient_id'=>$patient_id)));

		$hospitalType =$session->read('hospitaltype');
		if($hospitalType == 'NABH'){
			$serviceCostType = 'nabh_charges';
		}else{
			$serviceCostType = 'non_nabh_charges';
		}
		
		foreach($radiologyData as $key=>$radiologyDataValue){
			$radServiceCost = ($radiologyDataValue['TariffAmount'][$serviceCostType])?$radiologyDataValue['TariffAmount'][$serviceCostType]:0 ;
			$RadiologyTestOrder->updateAll(array('amount'=>$radServiceCost),
					array('RadiologyTestOrder.patient_id'=>$patient_id,'RadiologyTestOrder.id'=>$radiologyDataValue['RadiologyTestOrder']['id']));
		}
	}
	
	/**
	 * updating service charge function
	 * By yashwant
	 * @params patient_id, tariff_standerd_id
	 * return updated charges
	 */
	public function updateServiceCharge($patient_id=null,$tariffStandardId=null){
	
		$session     = new cakeSession();
		$TariffList = ClassRegistry::init('TariffList');
		$ServiceBill = ClassRegistry::init('ServiceBill');
		
		$TariffList->bindModel(array(
				'belongsTo' => array(
						'TariffAmount'=>array('foreignKey' => false,'conditions'=>array('TariffList.id=TariffAmount.tariff_list_id',
								'TariffAmount.tariff_standard_id'=>$tariffStandardId)),
						'ServiceBill'=>array('foreignKey' => false,'conditions'=>array('TariffList.id=ServiceBill.tariff_list_id'))
				)),false);
		
		$services =$TariffList->find('all',array(
				'fields'=>array('ServiceBill.id','TariffList.name','TariffList.id','TariffAmount.nabh_charges,TariffAmount.non_nabh_charges'),
				'conditions'=>array('TariffList.location_id'=>$session->read('locationid'),'TariffList.is_deleted'=>0,
						'ServiceBill.patient_id'=>$patient_id),'group'=>array('TariffList.id')));
		
		$hospitalType =$session->read('hospitaltype');
		if($hospitalType == 'NABH'){
			$serviceCostType = 'nabh_charges';
		}else{
			$serviceCostType = 'non_nabh_charges';
		}
	
		foreach($services as $key=>$servicesValue){
			$serServiceCost = ($servicesValue['TariffAmount'][$serviceCostType])?$servicesValue['TariffAmount'][$serviceCostType]:0 ;
			$ServiceBill->updateAll(array('amount'=>$serServiceCost),
					array('ServiceBill.patient_id'=>$patient_id,'ServiceBill.id'=>$servicesValue['ServiceBill']['id']));
		}
	}
	
	
	/**
	 * updating consultant charge function
	 * By yashwant
	 * @params patient_id, tariff_standerd_id
	 * results updated charges of consultant
	 */
	public function updateConsultantCharge($patient_id=null,$tariffStandardId=null){
	
		$session     = new cakeSession();
		$TariffList = ClassRegistry::init('TariffList');
		$ConsultantBilling  = Classregistry::init('ConsultantBilling') ;
	
		$TariffList->bindModel(array(
			'belongsTo' => array(
					'TariffAmount'=>array('foreignKey' => false,'conditions'=>array('TariffList.id=TariffAmount.tariff_list_id',
							'TariffAmount.tariff_standard_id'=>$tariffStandardId)),
					'ConsultantBilling'=>array('foreignKey' => false,'conditions'=>array('TariffList.id=ConsultantBilling.consultant_service_id'))
			)),false);
	
		$consultntServices =$TariffList->find('all',array(
			'fields'=>array('ConsultantBilling.id','TariffList.name','TariffList.id','TariffAmount.nabh_charges,TariffAmount.non_nabh_charges'),
			'conditions'=>array('TariffList.location_id'=>$session->read('locationid'),'TariffList.is_deleted'=>0,
					'ConsultantBilling.patient_id'=>$patient_id),'group'=>array('TariffList.id')));
	
		$hospitalType =$session->read('hospitaltype');
		if($hospitalType == 'NABH'){
			$serviceCostType = 'nabh_charges';
		}else{
			$serviceCostType = 'non_nabh_charges';
		}
	
		foreach($consultntServices as $key=>$consultntServicesValue){
			$conServiceCost = ($consultntServicesValue['TariffAmount'][$serviceCostType])?$consultntServicesValue['TariffAmount'][$serviceCostType]:0 ;
			$ConsultantBilling->updateAll(array('amount'=>$conServiceCost),
				array('ConsultantBilling.patient_id'=>$patient_id,'ConsultantBilling.id'=>$consultntServicesValue['ConsultantBilling']['id']));
		}
	}
	
	
	/**
	 * updating surgery charge function
	 * By yashwant
	 * @params patient_id, tariff_standerd_id
	 * return updated charges
	 */
	public function updateSurgeryCharge($patient_id=null,$tariffStandardId=null){
	
		$session     = new cakeSession();
		$tariffList = ClassRegistry::init('TariffList');
		$optAppointment = ClassRegistry::init('OptAppointment');
	
		/* $TariffList->bindModel(array(
				'belongsTo' => array(
						'TariffAmount'=>array('foreignKey' => false,'conditions'=>array('TariffList.id=TariffAmount.tariff_list_id',
								'TariffAmount.tariff_standard_id'=>$tariffStandardId)),
						'OptAppointment'=>array('foreignKey' => false,'conditions'=>array('OR'=>array('TariffList.id=OptAppointment.tariff_list_id',
								'TariffList.id=OptAppointment.anaesthesia_tariff_list_id'))),
						'AnaeTariffAmount' =>array('className'=>'TariffAmount','foreignKey'=>false,
								'conditions'=>array('AnaeTariffAmount.tariff_list_id=OptAppointment.anaesthesia_tariff_list_id',
										'AnaeTariffAmount.tariff_standard_id'=>$tariffStandardId)),
				)),false); */
	
		$optAppointment->unBindModel( array('belongsTo' => array('Patient','Location','Opt','OptTable','Surgery','SurgerySubcategory','Doctor',
						'DoctorProfile','Initial')));
		
		$optAppointment->bindModel(array(
				'belongsTo' => array(
						'TariffList' =>array( 'foreignKey'=>'tariff_list_id','type'=>'LEFT','conditions'=>array('TariffList.is_deleted'=>0)),
						'TariffAmount' =>array( 'foreignKey'=>false,'conditions'=>array('TariffAmount.tariff_list_id=OptAppointment.tariff_list_id',
								'TariffAmount.tariff_standard_id'=>$tariffStandardId)),						 
						'AnaeTariffAmount' =>array('className'=>'TariffAmount',
								'foreignKey'=>false,
								'conditions'=>array('AnaeTariffAmount.tariff_list_id=OptAppointment.anaesthesia_tariff_list_id',
										'AnaeTariffAmount.tariff_standard_id'=>$tariffStandardId)),
				)));
		
		$surgeryData = $optAppointment->find('all',array('fields'=>array('OptAppointment.id','OptAppointment.tariff_list_id',
				'OptAppointment.anaesthesia_tariff_list_id','TariffList.name','TariffList.id','TariffAmount.nabh_charges',
				'TariffAmount.non_nabh_charges','AnaeTariffAmount.nabh_charges','AnaeTariffAmount.non_nabh_charges'),
				'conditions'=>array('OptAppointment.patient_id'=>$patient_id)));
/* 		$surgeryData =$TariffList->find('all',array(
				'fields'=>array('OptAppointment.id','OptAppointment.tariff_list_id','OptAppointment.anaesthesia_tariff_list_id','TariffList.name',
						'TariffList.id','TariffAmount.nabh_charges','TariffAmount.non_nabh_charges','AnaeTariffAmount.nabh_charges','AnaeTariffAmount.non_nabh_charges'),
				'conditions'=>array('TariffList.location_id'=>$session->read('locationid'),'TariffList.is_deleted'=>0,
						'OptAppointment.patient_id'=>$patient_id) )); */
	
		$hospitalType =$session->read('hospitaltype');
		if($hospitalType == 'NABH'){
			$serviceCostType = 'nabh_charges';
		}else{
			$serviceCostType = 'non_nabh_charges';
		}
	
		foreach($surgeryData as $key=>$surgeryDataValue){
			$surgeryServiceCost = ($surgeryDataValue['TariffAmount'][$serviceCostType])?$surgeryDataValue['TariffAmount'][$serviceCostType]:0 ;
			$anaServiceCost = ($surgeryDataValue['AnaeTariffAmount'][$serviceCostType])?$surgeryDataValue['AnaeTariffAmount'][$serviceCostType]:0 ;
			
			$optAppointment->updateAll(array('surgery_cost'=>$surgeryServiceCost,
					'anaesthesia_cost'=>$anaServiceCost),
					array('OptAppointment.patient_id'=>$patient_id,'OptAppointment.id'=>$surgeryDataValue['OptAppointment']['id']));
		}
	}
	
	public function beforefind($queryData) {
		parent::beforeFind();
	 
		if (!isset($queryData['conditions']['Billing.is_deleted'])) {
			$queryData['conditions']['Billing.is_deleted'] = "0"; //add private tariff id if nothingi s there in array
		}
	
		return $queryData;
	}
	//for accounting cash book by amit jain return only cashier user name
	function getCashierUserList($name = null){
		$session     = new cakeSession();
		$userObj = ClassRegistry::init('User');
		$roleObj = ClassRegistry::init('Role');
		$userObj->virtualFields = array(
				'user_name' => 'CONCAT(User.first_name, " ", User.last_name)'
		);
		$roleObj->unBindModel( array('hasMany' => array('User')));
		$user_id = $roleObj->find('first',array('fields'=>array('Role.id'),'conditions'=>array('Role.name'=>Configure::read('cashier_role'))));
			return $userObj->find('list',array('fields'=>array('User.id','user_name'),
					'conditions'=>array('User.is_deleted'=>0,'User.location_id'=>$session->read('locationid'),'User.role_id'=>$user_id['Role']['id'])));
	}
	
	//for accounting daily cash collection by amit jain return cashier and pharmacy user name
	function getDailyCollectionUserList($name = null){
		$session     = new cakeSession();
		$userObj = ClassRegistry::init('User');
		$roleObj = ClassRegistry::init('Role');
		$userObj->virtualFields = array(
				'user_name' => 'CONCAT(User.first_name, " ", User.last_name)'
		);
		$roleObj->unBindModel( array('hasMany' => array('User')));
		$user_id = $roleObj->find('list',array('fields'=>array('Role.id'),'conditions'=>array("Role.name = '".Configure::read('cashier_role')."' OR Role.name ='".Configure::read('pharmacy_role')."'")));
			return $userObj->find('list',array('fields'=>array('User.id','user_name'),
					'conditions'=>array('User.is_deleted'=>0,'User.location_id'=>$session->read('locationid'),'User.role_id'=>$user_id)));
	}
	//for accounting by amit jain return any user name
	function getUserList($name = null,$userID = null){
		$session     = new cakeSession();
		$userObj = ClassRegistry::init('User');
		$roleObj = ClassRegistry::init('Role');
		$userObj->virtualFields = array(
				'user_name' => 'CONCAT(User.first_name, " ", User.last_name)'
		);
		$roleObj->unBindModel( array('hasMany' => array('User')));
		$user_id = $roleObj->find('first',array('fields'=>array('Role.id'),'conditions'=>array('Role.code_name'=>$name)));
		$condition = array('User.is_deleted'=>0,'User.location_id'=>$session->read('locationid'),
		'User.role_id'=>$user_id['Role']['id']);
		//for current cashier id hidden from cashier transaction by amit
		if($userID){
			$condition =array_merge($condition,array('User.id NOT'=>$userID)) ;
		}
		
		return $userObj->find('list',array('fields'=>array('User.id','user_name'),
				'conditions'=>array($condition)));
	}
	
	
	/**
	 *function for  generating bill no. for each payment
	 *@params patient_id and record_id of billing.
	 *By Yashwant
	 *@Return dynamic bill no.
	 */
	public function generateBillNoPerPay($id,$recId){
		//$this->uses=array('FinalBilling');
		$session  =  new CakeSession();
		$monthArray = array('A','B','C','D','E','F','G','H','I','J','K','L');
		$count = $this->find('count',array('conditions'=>array('location_id'=>$session->read('locationid'),'is_deleted'=>'0',
				'date'=>date('Y-m-d'))));

		$billNo = 'BL'.date('y').'-'.$monthArray[(date('n')-1)].date('d').'/'.($count+1).'/'.$recId;
		return $billNo;
	}
	
	/**
	 * jv for lab function
	 * By amit
	 * @params patient_id
	 * return data
	 */
	public function JVLabData($patient_id){
	
		$session     = new cakeSession();
		$Laboratory = ClassRegistry::init('Laboratory');
		$LaboratoryTestOrder = ClassRegistry::init('LaboratoryTestOrder');
		$patientObj = ClassRegistry::init('Patient');
		$accountObj = ClassRegistry::init('Account');
		$voucherEntryLab = ClassRegistry::init('VoucherEntry');
		$tariffListObj = ClassRegistry::init('TariffList');
		$serviceCategoryObj = ClassRegistry::init('ServiceCategory');
		$serviceProviderObj = ClassRegistry::init('ServiceProvider');
		$configurationObj = ClassRegistry::init('Configuration');
		$voucherReferenceObj = ClassRegistry::init('VoucherReference');
		$voucherLogObj = ClassRegistry::init('VoucherLog');
		
		$LaboratoryTestOrder->bindModel(array(
				'belongsTo' => array(
						'Laboratory'=>array('foreignKey' => false,'conditions'=>array('LaboratoryTestOrder.laboratory_id=Laboratory.id'))
				)),false);
		$laboratoryData= $LaboratoryTestOrder->find('all',array('fields'=> array('LaboratoryTestOrder.*','Laboratory.name'),
				'conditions'=>array('LaboratoryTestOrder.location_id'=>$session->read('locationid'),'LaboratoryTestOrder.is_deleted'=>0,
						'LaboratoryTestOrder.patient_id'=>$patient_id)));
		
		$getPatientDetails=$patientObj->find('first',array('conditions'=>array('Patient.id'=>$patient_id),
				'fields'=>array('person_id','lookup_name','form_received_on','admission_type','is_staff_register','is_paragon')));
		
		$personId = $getPatientDetails['Patient']['person_id'];
                if($getPatientDetails['Patient']['is_paragon'] != '1'){ // if temporary registration then restrict entries -Atul Chandankhede
		if($getPatientDetails['Patient']['is_staff_register'] == '1'){
			$accountId = $accountObj->find('first',array('conditions'=>array('Account.user_type'=>'User',
											'Account.name'=>trim($getPatientDetails['Patient']['lookup_name']),
											'Account.location_id'=>$session->read('locationid')),
											'fields'=>array('Account.id','Account.name')));
		}else{
			$accountId = $accountObj->getAccountID($personId,'Patient');//for account id
		}
		
		foreach($laboratoryData as $key=>$labData){
			
				if(!empty($labData['Laboratory']['name'])){
				$getLabTariffId = $Laboratory->find('first',array('fields'=>array('tariff_list_id'),
								'conditions'=>array('Laboratory.id'=>$labData['LaboratoryTestOrder']['laboratory_id'],
								'Laboratory.location_id'=>$session->read('locationid'))));
				$tariffListId = $getLabTariffId['Laboratory']['tariff_list_id'];
				if(empty($tariffListId)){
					$getTariffId = $tariffListObj->find('first',array('fields'=>array('id'),
							'conditions'=>array('TariffList.name'=>$labData['Laboratory']['name'],'TariffList.location_id'=>$session->read('locationid'))));
					$tariffListId=$getTariffId['TariffList']['id'];
					if(empty($tariffListId)){
						$tariffListData  = array(
								'location_id'=>$session->read('locationid'),
								'name'=>$labData['Laboratory']['name'],
								'create_time'=> date('Y-m-d H:i:s'),
								'created_by'=>$session->read('userid'),
								'service_id'=>$serviceCategoryObj->getServiceGroupId(Configure::read('laboratoryservices')));
						$tariffListObj->saveAll($tariffListData); //insert registration and consulation servicde and charges
						$tariffListId = $tariffListObj->id;
					}
					$Laboratory->updateAll(array('tariff_list_id'=>$tariffListId),
							array('Laboratory.id'=>$labData['LaboratoryTestOrder']['laboratory_id'],'Laboratory.location_id'=>$session->read('locationid')));
				}
				
				$userId = $accountObj->getUserIdOnly($tariffListId,'TariffList',$labData['Laboratory']['name']);
				$serviceProviderDetails = $serviceProviderObj->find('first',array('fields'=>array('ServiceProvider.name'),
						'conditions'=>array('ServiceProvider.is_deleted'=>'0','ServiceProvider.id'=>$labData['LaboratoryTestOrder']['service_provider_id'])));
				
				$userServiceProviderId = $accountObj->getUserIdOnly($labData['LaboratoryTestOrder']['service_provider_id'],'ServiceProvider',$serviceProviderDetails['ServiceProvider']['name']);
				$regDate  =  DateFormatComponent::formatDate2Local($getPatientDetails['Patient']['form_received_on'],Configure::read('date_format'),true);
				$doneDate  =  DateFormatComponent::formatDate2Local($labData['LaboratoryTestOrder']['start_date'],Configure::read('date_format'),true);
				
			//for hope hospital only
				$accountObj->id='';
				 $amountLab = $labData['LaboratoryTestOrder']['amount'];
				if(empty($labData['LaboratoryTestOrder']['description'])){
					$narration = 'Being'." ".$labData['Laboratory']['name']." ".'charged to pt '.$getPatientDetails['Patient']['lookup_name']." (Date of Registration :".$regDate.")".'done on '.$doneDate;
				}else{
					$narration = $labData['LaboratoryTestOrder']['description'];
				}
				$jvData = array('date'=>$labData['LaboratoryTestOrder']['start_date'],
						'user_id'=>$userId,
						'account_id'=>$accountId['Account']['id'],
						'debit_amount'=>$amountLab,
						'type'=>'Laboratory',
						'narration'=>$narration,
						'patient_id'=>$patient_id);
					if(!empty($jvData['debit_amount']) && ($jvData['debit_amount'] != 0)){
					$voucherEntryLab->insertJournalEntry($jvData);
					$voucherEntryLab->id ='';
					// ***insert into Account (By) credit manage current balance
					$accountObj->setBalanceAmountByAccountId($userId,$amountLab,'debit');
					$accountObj->setBalanceAmountByUserId($accountId['Account']['id'],$amountLab,'credit');
					}
				//EOF JV
				}
			}
                   }
		}
	
	/**
	 * jv for rad function
	 * By amit
	 * @params patient_id
	 * return data
	 */
	public function JVRadData($patient_id){
	
		$session     = new cakeSession();
		$Radiology = ClassRegistry::init('Radiology');
		$RadiologyTestOrder = ClassRegistry::init('RadiologyTestOrder');
		$patientObj = ClassRegistry::init('Patient');
		$accountObj = ClassRegistry::init('Account');
		$voucherEntryRad = ClassRegistry::init('VoucherEntry');
		$serviceProviderObj = ClassRegistry::init('ServiceProvider');
		$serviceSubCategoryObj = ClassRegistry::init('ServiceSubCategory');
		$tariffListObj = ClassRegistry::init('TariffList');
		$voucherReferenceObj = ClassRegistry::init('VoucherReference');
		$serviceCategoryObj = ClassRegistry::init('ServiceCategory');
		$configurationObj = ClassRegistry::init('Configuration');
		$voucherLogObj = ClassRegistry::init('VoucherLog');
		
		$RadiologyTestOrder->bindModel(array(
				'belongsTo' => array(
						'Radiology'=>array('foreignKey' => false,'conditions'=>array('RadiologyTestOrder.radiology_id=Radiology.id'))
				)),false);
		$radiologyData= $RadiologyTestOrder->find('all',array('fields'=> array('RadiologyTestOrder.*','Radiology.name'),
				'conditions'=>array('RadiologyTestOrder.location_id'=>$session->read('locationid'),'RadiologyTestOrder.is_deleted'=>0,
						'RadiologyTestOrder.patient_id'=>$patient_id)));
		
		$radChargesDetails = $configurationObj->find('first',array('fields'=>array('Configuration.value'),
				'conditions'=>array('Configuration.name'=>'Radiology-Commision','Configuration.location_id'=>$session->read('locationid'))));
		$allRadCharges = unserialize($radChargesDetails['Configuration']['value']);
		$comissionPer = '';
		foreach($allRadCharges as $configRadData){
			$date  =  DateFormatComponent::formatDate2STD($configRadData['from'],Configure::read('date_format'));
			if($date <= date('Y-m-d')){
				$comissionPer= $configRadData['external_charges'];
			}
		}
		//for patient information
		$getPatientDetails=$patientObj->find('first',array('conditions'=>array('Patient.id'=>$patient_id),
				'fields'=>array('person_id','lookup_name','form_received_on','admission_type','is_staff_register','is_paragon')));
                if($getPatientDetails['Patient']['is_paragon']!= '1'){ // if temporary registration then restrict entries -Atul Chandankhede
		$personId = $getPatientDetails['Patient']['person_id'];
		
		$webSite = $session->read('website.instance');
		foreach($radiologyData as $key=>$radData){
			if(!empty($radData['Radiology']['name'])){
				$getRadTariffId = $Radiology->find('first',array('fields'=>array('tariff_list_id'),
						'conditions'=>array('Radiology.id'=>$radData['RadiologyTestOrder']['radiology_id'],'Radiology.location_id'=>$session->read('locationid'))));
				$tariffListId = $getRadTariffId['Radiology']['tariff_list_id'];
				if(empty($tariffListId)){
					$getTariffId = $tariffListObj->find('first',array('fields'=>array('id'),
							'conditions'=>array('TariffList.name'=>$radData['Radiology']['name'],'TariffList.location_id'=>$session->read('locationid'))));
					$tariffListId=$getTariffId['TariffList']['id'];
					if(empty($tariffListId)){
						$tariffListData  = array(
								'location_id'=>$session->read('locationid'),
								'name'=>$radData['Radiology']['name'],
								'create_time'=> date('Y-m-d H:i:s'),
								'created_by'=>$session->read('userid'),
								'service_id'=>$serviceCategoryObj->getServiceGroupId(Configure::read('radiologyservices')));
						$tariffListObj->saveAll($tariffListData); //insert registration and consulation servicde and charges
						$tariffListId = $tariffListObj->getLastInsertID();
					}
					$Radiology->updateAll(array('tariff_list_id'=>$tariffListId),
							array('Radiology.id'=>$radData['RadiologyTestOrder']['radiology_id'],'Radiology.location_id'=>$session->read('locationid')));
				}
		
				$regDate  =  DateFormatComponent::formatDate2Local($getPatientDetails['Patient']['form_received_on'],Configure::read('date_format'),true);
				$doneDate  =  DateFormatComponent::formatDate2Local($radData['RadiologyTestOrder']['radiology_order_date'],Configure::read('date_format'),true);
				
				if(!empty($radData['RadiologyTestOrder']['service_provider_id'])){
					//find service sub category id
					$getserviceSubCategoryId = $serviceSubCategoryObj->find('first',array('fields'=>array('id'),
							'conditions'=>array('ServiceSubCategory.name'=>Configure::read('mri_ct'),'ServiceSubCategory.is_deleted'=>0)));
					$serviceSubCategoryId = $getserviceSubCategoryId['ServiceSubCategory']['id'];
					//find private cost in tariff list table by service sub category id
					$getPrivatePrice = $tariffListObj->find('first',array('fields'=>array('price_for_private','name'),
							'conditions'=>array('TariffList.service_sub_category_id'=>$serviceSubCategoryId,'TariffList.is_deleted'=>0)));
					$privatePrice = $getPrivatePrice['TariffList']['price_for_private'];
					if(!empty($privatePrice)){
						$accountId = $accountObj->getAccountIdOnly(Configure::read('ct_mri_Label'));
						$serviceProviderDetails = $serviceProviderObj->find('first',array('fields'=>array('ServiceProvider.name'),
								'conditions'=>array('ServiceProvider.is_deleted'=>'0','ServiceProvider.id'=>$radData['RadiologyTestOrder']['service_provider_id'])));//service provider name
						$userId = $accountObj->getUserIdOnly($radData['RadiologyTestOrder']['service_provider_id'],'ServiceProvider',$serviceProviderDetails['ServiceProvider']['name']);//for userId
						$accountObj->id='';
						$narration = 'Being'." ".$getPrivatePrice['TariffList']['name']." ".'charged to patient '.$getPatientDetails['Patient']['lookup_name']." (Date of Registration :".$regDate.")".'done on '.$doneDate;//for narration set
							
						$jvData = array('date'=>$radData['RadiologyTestOrder']['radiology_order_date'],
								'location_id'=>$session->read('locationid'),
								'account_id'=>$accountId,
								'user_id'=>$userId,
								'patient_id'=>$patient_id,
								'type'=>'CTMRI',
								'narration'=>$narration,
								'debit_amount'=>$privatePrice);
						if(!empty($jvData['debit_amount']) && ($jvData['debit_amount'] != 0)){
							$voucherEntryRad->insertJournalEntry($jvData);
							$voucherEntryRad->id = '';
							// ***insert into Account (By) credit manage current balance
							$accountObj->setBalanceAmountByAccountId($userId,$privatePrice,'debit');
							$accountObj->setBalanceAmountByUserId($accountId,$privatePrice,'credit');
						}
						$vrData = array('reference_type_id'=> '2',
								'voucher_id'=> $voucherEntryRad->getLastInsertID(),
								'patient_id'=>$patient_id,
								'voucher_type'=> 'journal',
								'location_id'=> $session->read('locationid'),
								'user_id'=> $userId,
								'date' => $radData['RadiologyTestOrder']['radiology_order_date'],
								'amount'=>$privatePrice,
								'credit_period'=>'45',
								'payment_type'=>'Cr',
								'reference_no'=>$voucherEntryRad->getLastInsertID(),
								'parent_id' => '0');
						$voucherReferenceObj->save($vrData);
						$voucherReferenceObj->id='';
					}
				}
				//EOF for kanpur
				if($getPatientDetails['Patient']['is_staff_register'] == '1'){
					$accountId = $accountObj->find('first',array('conditions'=>array('Account.user_type'=>'User',
													'Account.name'=>trim($getPatientDetails['Patient']['lookup_name']),
													'Account.location_id'=>$session->read('locationid')),
													'fields'=>array('Account.id','Account.name')));
				}else{
					$accountId = $accountObj->getAccountID($personId,'Patient');//for account id
				}

				$userId = $accountObj->getUserIdOnly($tariffListId,'TariffList',$radData['Radiology']['name']);
				$accountObj->id='';
				$amountRad = $radData['RadiologyTestOrder']['amount'];
				if(empty($radData['RadiologyTestOrder']['description'])){
					$narration = 'Being'." ".$radData['Radiology']['name']." ".'charged to patient '.$getPatientDetails['Patient']['lookup_name']." (Date of Registration :".$regDate.")".'done on '.$doneDate;//for narration set
				}else{
					$narration = $radData['RadiologyTestOrder']['description'];
				}
				$jvData = array('date'=>$radData['RadiologyTestOrder']['radiology_order_date'],
						'user_id'=>$userId,
						'account_id'=>$accountId['Account']['id'],
						'debit_amount'=>$amountRad,
						'type'=>'Radiology',
						'narration'=>$narration,
						'patient_id'=>$patient_id);
					if(!empty($jvData['debit_amount']) && ($jvData['debit_amount'] != 0)){
					$voucherEntryRad->insertJournalEntry($jvData);
					$voucherEntryRad->id ='';
					// ***insert into Account (By) credit manage current balance
					$accountObj->setBalanceAmountByAccountId($userId,$amountRad,'debit');
					$accountObj->setBalanceAmountByUserId($accountId['Account']['id'],$amountRad,'credit');
					}
				}
			}
                    }
		}
		
		
		public function receiptVoucherCreate($requestPartialData=array(),$patientId=null){
			$session = new CakeSession();
			$account=ClassRegistry::init('Account');
			$voucherEntry=ClassRegistry::init('VoucherEntry');
			$patient=ClassRegistry::init('Patient');
			$billing=ClassRegistry::init('Billing');
			$accountReceipt=ClassRegistry::init('AccountReceipt');
			$voucherPayment=ClassRegistry::init('VoucherPayment');
			$voucherLog=ClassRegistry::init('VoucherLog');
			$doctorProfile=ClassRegistry::init('DoctorProfile');
			
			$website=$session->read('website.instance');
		
			//voucher enrty id for account_receipt of journal_entry_id by amit jain
			$cashId = $account->getAccountIdOnly(Configure::read('cash'));//for cash id
			$getPatientDetails = $patient->getPatientAllDetails($patientId);
			$personId = $getPatientDetails['Patient']['person_id'];
			if($getPatientDetails['Patient']['is_paragon'] != '1'){ // if temporary registration then restrict entries -Atul Chandankhede
			if($getPatientDetails['Patient']['is_staff_register'] == '1'){
				$accountDetails = $account->find('first',array('conditions'=>array('Account.user_type'=>'User',
												'Account.name'=>trim($getPatientDetails['Patient']['lookup_name']),
												'Account.location_id'=>$session->read('locationid')),
												'fields'=>array('Account.id','Account.name')));
			}else{
				$accountDetails = $account->getAccountID($personId,'Patient');//for account id
			}
			

			$accountId = $accountDetails['Account']['id'];

			$lastBillingId = $billing->getLastInsertID();
		
			$admissionId = $getPatientDetails['Patient']['admission_id'];
			$patientLookUpName = $getPatientDetails['Patient']['lookup_name'];
			
			$narration = $requestPartialData['Billing']['remark'];
		
			// for refund
			if($requestPartialData['Billing']['refund'] == 1){
				if($requestPartialData['Billing']['mode_of_payment'] == 'Cash'){
					$voucherLogDataPay=$pvData = array('date'=>$requestPartialData['Billing']['date'],
							'modified_by'=>$session->read('userid'),
							'create_by'=>$session->read('userid'),
							'patient_id'=>$requestPartialData['Billing']['patient_id'],
							'account_id'=>$cashId,
							'user_id'=>$accountId,
							'type'=>'Refund',
							'narration'=>$narration,
							'paid_amount'=>$requestPartialData['Billing']['paid_to_patient']);
					if(!empty($pvData['paid_amount']) && ($pvData['paid_amount'] != 0)){
						$lastVoucherIdPayment=$voucherPayment->insertPaymentEntry($pvData);
						// ***insert into Account (By) credit manage current balance
						$account->setBalanceAmountByAccountId($cashId,$requestPartialData['Billing']['paid_to_patient'],'debit');
						$account->setBalanceAmountByUserId($accountId,$requestPartialData['Billing']['paid_to_patient'],'credit');
					}
				}else if($requestPartialData['Billing']['mode_of_payment']=='Bank Deposit' || 
						$requestPartialData['Billing']['mode_of_payment']=='Cheque' || 
						$requestPartialData['Billing']['mode_of_payment']=='Credit Card' || 
						$requestPartialData['Billing']['mode_of_payment']=='NEFT' ||
						$requestPartialData['Billing']['mode_of_payment']=='Debit Card'){
					if($requestPartialData['Billing']['mode_of_payment']=='Bank Deposit'){
						$date = $requestPartialData['Billing']['date'];
						$bankId = $requestPartialData['Billing']['bank_deposite'];
					}else if($requestPartialData['Billing']['mode_of_payment']=='Cheque' || 
							$requestPartialData['Billing']['mode_of_payment']=='Credit Card' ||
							$requestPartialData['Billing']['mode_of_payment']=='Debit Card'){
						$date = $requestPartialData['Billing']['cheque_date'];
						$bankId = $requestPartialData['Billing']['bank_name'];
					}else if($requestPartialData['Billing']['mode_of_payment']=='NEFT'){
						$bankId = $requestPartialData['Billing']['bank_name_neft'];
						$date = $requestPartialData['Billing']['neft_date'];
					}
					$voucherLogDataPay=$pvData = array('date'=>$date,
							'modified_by'=>$session->read('userid'),
							'create_by'=>$session->read('userid'),
							'patient_id'=>$requestPartialData['Billing']['patient_id'],
							'account_id'=>$bankId,
							'user_id'=>$accountId,
							'type'=>'Refund',
							'narration'=>$narration,
							'paid_amount'=>$requestPartialData['Billing']['paid_to_patient']);
					if(!empty($pvData['paid_amount']) && ($pvData['paid_amount'] != 0)){
						$lastVoucherIdPayment=$voucherPayment->insertPaymentEntry($pvData);
						// ***insert into Account (By) credit manage current balance
						$account->setBalanceAmountByAccountId($bankId,$requestPartialData['Billing']['paid_to_patient'],'debit');
						$account->setBalanceAmountByUserId($accountId,$requestPartialData['Billing']['paid_to_patient'],'credit');
					}
				}
				//insert into voucher_logs table added by PankajM
				$voucherLogDataPay['voucher_no']=$lastVoucherIdPayment;
				$voucherLogDataPay['voucher_id']=$lastVoucherIdPayment;
				$voucherLogDataPay['voucher_type']="Payment";
				$voucherLog->insertVoucherLog($voucherLogDataPay);
				$voucherLog->id= '';
				$voucherPayment->id= '';
				//End
			}else{
				//for patient card rv
				if($website=='hope'){
					if($requestPartialData['Billing']['is_card'] == '1'){
						$doctorDetailsAll = $doctorProfile->find('first',array('fields'=>array('DoctorProfile.doctor_name','DoctorProfile.user_id'),
								'conditions'=>array('DoctorProfile.is_deleted'=>'0','DoctorProfile.user_id'=>$getPatientDetails['Patient']['doctor_id'],
										'DoctorProfile.location_id'=>$session->read('locationid'))));
						$doctorName = $doctorDetailsAll['DoctorProfile']['doctor_name'];
						$narrationCard = "Being Card amount received against Pt $patientLookUpName ($admissionId) Receipt No.- $lastBillingId, $doctorName.";
						$pateintCardId = $account->getAccountIdOnly(Configure::read('PatientCardLabel'));//for patient card id
						$voucherLogDataFinalpayment=$rvData = array('date'=>$requestPartialData['Billing']['date'],
								'billing_id'=>$lastBillingId,
								'modified_by'=>$session->read('userid'),
								'create_by'=>$session->read('userid'),
								'patient_id'=>$patientId,
								'account_id'=>$pateintCardId,
								'user_id'=>$accountId,
								'type'=>'FinalPayment',
								'narration'=>$narrationCard,
								'paid_amount'=>$requestPartialData['Billing']['patient_card']);
						if(!empty($rvData['paid_amount']) && ($rvData['paid_amount'] != 0)){
							$lastVoucherIdRecFinal=$accountReceipt->insertReceiptEntry($rvData);
							//insert into voucher_logs table added by PankajM
							$voucherLogDataFinalpayment['voucher_no']=$lastVoucherIdRecFinal;
							$voucherLogDataFinalpayment['voucher_id']=$lastVoucherIdRecFinal;
							$voucherLogDataFinalpayment['voucher_type']="Receipt";
							$voucherLog->insertVoucherLog($voucherLogDataFinalpayment);
							$voucherLog->id= '';
							$accountReceipt->id= '';
							// ***insert into Account (By) credit manage current balance
							$account->setBalanceAmountByAccountId($accountId,$requestPartialData['Billing']['patient_card'],'debit');
							$account->setBalanceAmountByUserId($pateintCardId,$requestPartialData['Billing']['patient_card'],'credit');
						}
					}
				}
					
				//EOF refund
				if($requestPartialData['Billing']['mode_of_payment']=='Cash'){
					$amount = $requestPartialData['Billing']['amount'];
					if($requestPartialData['Billing']['is_card'] == '1'){
						$patientCardAmount = $requestPartialData['Billing']['patient_card'];
					}
					$cashAmount = abs($amount-$patientCardAmount);
						$voucherLogDataFinalpayment=$rvData = array('date'=>$requestPartialData['Billing']['date'],
								'billing_id'=>$lastBillingId,
								'modified_by'=>$session->read('userid'),
								'create_by'=>$session->read('userid'),
								'patient_id'=>$patientId,
								'account_id'=>$cashId,
								'user_id'=>$accountId,
								'type'=>'FinalPayment',
								'narration'=>$narration,
								'paid_amount'=>$cashAmount);
						if(!empty($rvData['paid_amount']) && ($rvData['paid_amount'] != 0)){
							$lastVoucherIdRecFinal=$accountReceipt->insertReceiptEntry($rvData);
							//insert into voucher_logs table added by PankajM
							$voucherLogDataFinalpayment['voucher_no']=$lastVoucherIdRecFinal;
							$voucherLogDataFinalpayment['voucher_id']=$lastVoucherIdRecFinal;
							$voucherLogDataFinalpayment['voucher_type']="Receipt";
							$voucherLog->insertVoucherLog($voucherLogDataFinalpayment);
							$voucherLog->id= '';
							$this->id= '';
							// ***insert into Account (By) credit manage current balance
							$account->setBalanceAmountByAccountId($accountId,$cashAmount,'debit');
							$account->setBalanceAmountByUserId($cashId,$cashAmount,'credit');
						}
				}else if($requestPartialData['Billing']['mode_of_payment']=='Bank Deposit' || 
						$requestPartialData['Billing']['mode_of_payment']=='Cheque' || 
						$requestPartialData['Billing']['mode_of_payment']=='Credit Card' || 
						$requestPartialData['Billing']['mode_of_payment']=='NEFT'){
					if($requestPartialData['Billing']['mode_of_payment']=='Bank Deposit'){
						$date = $requestPartialData['Billing']['date'];
						$bankId = $requestPartialData['Billing']['bank_deposite'];
					}else if($requestPartialData['Billing']['mode_of_payment']=='Cheque' || $requestPartialData['Billing']['mode_of_payment']=='Credit Card'){
						$bankId = $requestPartialData['Billing']['bank_name'];
						$date = $requestPartialData['Billing']['cheque_date'];
					}else if($requestPartialData['Billing']['mode_of_payment']=='NEFT'){
						$bankId = $requestPartialData['Billing']['bank_name_neft'];
						$date = $requestPartialData['Billing']['neft_date'];
					}
					
					$amount = $requestPartialData['Billing']['amount'];
					if($requestPartialData['Billing']['is_card'] == '1'){
						$patientCardAmount = $requestPartialData['Billing']['patient_card'];
					}
					$cashAmount = abs($amount-$patientCardAmount);
					
					$voucherLogDataFinalpayment=$rvData = array('date'=>$date,
							'billing_id'=>$lastBillingId,
							'modified_by'=>$session->read('userid'),
							'create_by'=>$session->read('userid'),
							'patient_id'=>$requestPartialData['Billing']['patient_id'],
							'account_id'=>$bankId,
							'user_id'=>$accountId,
							'type'=>'FinalPayment',
							'narration'=>$narration,
							'paid_amount'=>$cashAmount);
					if(!empty($rvData['paid_amount']) && ($rvData['paid_amount'] != 0)){
						$lastVoucherIdRecFinal=$accountReceipt->insertReceiptEntry($rvData);
						//insert into voucher_logs table added by PankajM
						$voucherLogDataFinalpayment['voucher_no']=$lastVoucherIdRecFinal;
						$voucherLogDataFinalpayment['voucher_id']=$lastVoucherIdRecFinal;
						$voucherLogDataFinalpayment['voucher_type']="Receipt";
						$voucherLog->insertVoucherLog($voucherLogDataFinalpayment);
						$voucherLog->id= '';
						$this->id= '';
						// ***insert into Account (By) credit manage current balance
						$account->setBalanceAmountByAccountId($accountId,$cashAmount,'debit');
						$account->setBalanceAmountByUserId($bankId,$cashAmount,'credit');
					}
				}
			}

			//for discount jv
			/* if(!empty($requestPartialData['Billing']['discount'])){
				$userId = $account->getAccountIdOnly(Configure::read('DiscountAllowedLabel'));
				$voucherLogDataPay = $jvData = array('date'=>$requestPartialData['Billing']['date'],
						'modified_by'=>$session->read('userid'),
						'created_by'=>$session->read('userid'),
						'account_id'=>$userId,
						'user_id'=>$accountId,
						'patient_id'=>$patientId,
						'type'=>'Discount',
						'narration'=>$requestPartialData['Billing']['remark'],
						'debit_amount'=>$requestPartialData['Billing']['discount']);
				if(!empty($jvData['debit_amount']) && ($jvData['debit_amount'] != 0)){
					$lastVoucherIdPayment = $voucherEntry->insertJournalEntry($jvData);
					//insert into voucher_logs table added by PankajM
					$voucherLogDataPay['voucher_no']=$lastVoucherIdPayment;
					$voucherLogDataPay['voucher_id']=$lastVoucherIdPayment;
					$voucherLogDataPay['voucher_type']="Journal";
					$voucherLog->insertVoucherLog($voucherLogDataPay);
					$voucherLog->id= '';
					$voucherEntry->id= '';
					// ***insert into Account (By) credit manage current balance
					$account->setBalanceAmountByAccountId($accountId,$requestPartialData['Billing']['discount'],'debit');
					$account->setBalanceAmountByUserId($userId,$requestPartialData['Billing']['discount'],'credit');
				}
			} */
                        }
			}
		// function to calculate day to day ward charges 
		function getDay2DayCharges($id,$tariffStandardId,$applyPackageCondition,$location_id){
			 
			$wardPatientObj = Classregistry::init('WardPatient') ;
			$optAppointmentObj = Classregistry::init('OptAppointment') ;
			$locationObj = Classregistry::init('Location') ;
			$session = new CakeSession();
 
			/** Code construct for private packaged patient  Gaurav Chauriya*/
			/*if($applyPackageCondition){ 
				$patientObj = Classregistry::init('Patient') ;
				$privatePackagedDetails = $patientObj->find('first',array('fields'=>array('is_packaged'),'conditions'=>array('id'=>$id)));
				if($privatePackagedDetails['Patient']['is_packaged']){//echo 'hehe';
					/** by pass execution with calculatePrivatePackageWardCost() if patient is private packaged */
				/*	$this->set('isPackaged',true);
					return $this->calculatePrivatePackageDay2DayWardCost($id,$privatePackagedDetails['Patient']['is_packaged']);
				}
			}*/
			/** EOF private package code */
			////BOF collecting checkout hrs
			$config_hrs = $locationObj->getCheckoutTime();
			//EOD collecting hrs 

			//making sergery array
			$optAppointmentObj->unbindModel(array(
					'belongsTo' => array('Initial','Patient','Location','Opt','OptTable','Surgery','SurgerySubcategory','Doctor','DoctorProfile'
								
					)));
			$optAppointmentObj->bindModel(array(
				'belongsTo' => array(
						'TariffList' =>array( 'foreignKey'=>'tariff_list_id','type'=>'LEFT','conditions'=>array('TariffList.is_deleted'=>0)),
						'Surgeon' =>array('className'=>'DoctorProfile','foreignKey'=>false,'type'=>'LEFT',
								'conditions'=>array('Surgeon.user_id=OptAppointment.doctor_id')),
						'User'=>array('foreignKey'=>'doctor_id'),
						'Initial'=>array('foreignKey'=>false,'conditions'=>array('Initial.id=User.initial_id')),
						/** Anaesthesist */
						'Anaesthesist' =>array('className'=>'DoctorProfile','foreignKey'=>false,'type'=>'LEFT',
								'conditions'=>array('Anaesthesist.user_id=OptAppointment.department_id')),
						'AnaeUser'=>array('className'=>'User','foreignKey'=>'department_id'),
						'AnaeInitial'=>array('className'=>'Initial','foreignKey'=>false,'conditions'=>array('AnaeInitial.id=AnaeUser.initial_id')),
						
						/** Assistant Surgeon one */
						'AssistantOne' =>array('className'=>'DoctorProfile','foreignKey'=>false,'type'=>'LEFT',
								'conditions'=>array('AssistantOne.user_id=OptAppointment.asst_surgeon_one')),
						'AssistantOneUser'=>array('className'=>'User',
								'foreignKey'=>'asst_surgeon_one'),
						'AssistantOneInitial'=>array('className'=>'Initial','foreignKey'=>false,
								'conditions'=>array('AssistantOneInitial.id=AssistantOneUser.initial_id')),
						/** Assistant Surgeon two */
						'AssistantTwo' =>array('className'=>'DoctorProfile','foreignKey'=>false,'type'=>'LEFT',
								'conditions'=>array('AssistantTwo.user_id=OptAppointment.asst_surgeon_two')),
						'AssistantTwoUser'=>array('className'=>'User',
								'foreignKey'=>'asst_surgeon_two'),
						'AssistantTwoInitial'=>array('className'=>'Initial','foreignKey'=>false,
								'conditions'=>array('AssistantTwoInitial.id=AssistantTwoUser.initial_id')),
						
						/** Cardiologist */
						'Cardiologist' =>array('className'=>'DoctorProfile','foreignKey'=>false,'type'=>'LEFT',
								'conditions'=>array('Cardiologist.user_id=OptAppointment.cardiologist_id')),
						'CardioUser'=>array('className'=>'User',
								'foreignKey'=>'cardiologist_id'),
						'CardioInitial'=>array('className'=>'Initial','foreignKey'=>false,
								'conditions'=>array('CardioInitial.id=CardioUser.initial_id')),
						
						'TariffAmount' =>array( 'foreignKey'=>false,'conditions'=>array('TariffAmount.tariff_list_id=OptAppointment.tariff_list_id',
								'TariffAmount.tariff_standard_id'=>$tariffStandardId)),
						'Surgery'=>array('foreignKey'=>'surgery_id'),
						'AnaeTariffAmount' =>array('className'=>'TariffAmount',
								'foreignKey'=>false,
								'conditions'=>array('AnaeTariffAmount.tariff_list_id=OptAppointment.anaesthesia_tariff_list_id',
										"AnaeTariffAmount.tariff_standard_id"=>$tariffStandardId) )
							
				)));
			$procedureCompleteSondition = ($session->read('website.instance') == 'kanpur') ? 'OptAppointment.procedure_complete = 1' : '';
			$surgery_Data = $optAppointmentObj->find('all',
					array('conditions'=>array('OptAppointment.location_id'=>$session->read('locationid'),$procedureCompleteSondition,
							'OptAppointment.is_deleted'=>0,'OptAppointment.patient_id'=>$id,'OptAppointment.is_false_appointment'=>0),/** is_false_appointment == 0 means non packaged ot */
							'fields'=>array('Surgery.id','OptAppointment.surgery_cost','OptAppointment.ot_charges','OptAppointment.anaesthesia_cost','OptAppointment.anaesthesia_tariff_list_id',
								'Surgeon.education','Surgeon.doctor_name','Anaesthesist.education','Anaesthesist.doctor_name',
								'TariffList.*,TariffAmount.moa_sr_no,OptAppointment.id,OptAppointment.paid_amount,OptAppointment.surgeon_amt,
								TariffAmount.tariff_list_id,TariffAmount.nabh_charges,TariffAmount.non_nabh_charges,
								TariffAmount.unit_days','AnaeTariffAmount.id','AnaeTariffAmount.nabh_charges','AnaeTariffAmount.non_nabh_charges',
								'OptAppointment.starttime','OptAppointment.endtime','Surgery.name','Initial.name','AnaeInitial.name',
								'OptAppointment.schedule_date','OptAppointment.department_id','TariffList.name',
								'AssistantOneInitial.name','AssistantOne.doctor_name','AssistantOne.education','OptAppointment.asst_surgeon_one_charge',
								'AssistantTwoInitial.name','AssistantTwo.doctor_name','AssistantTwo.education','OptAppointment.asst_surgeon_two_charge',
								'CardioInitial.name','Cardiologist.doctor_name','Cardiologist.education','OptAppointment.cardiologist_charge','OptAppointment.ot_asst_charge',
								'OptAppointment.ot_in_date','OptAppointment.out_date','OptAppointment.operation_type','OptAppointment.ot_service'),
							'order'=>'OptAppointment.schedule_date Asc',
							'group'=>'OptAppointment.id',
							'recursive'=>1));
				
			/*if($session->read('website.instance') == 'kanpur'){ 
				$tariffListObj = ClassRegistry::init('TariffList');
				$tariffListObj->bindModel(array(
						'hasOne' => array(
								'TariffAmount' =>array( 'foreignKey'=>'tariff_list_id','conditions'=>array('TariffList.is_deleted'=>0))
						)));
			}*/
			/********************** Surgery Data Starts ******************************/
			$hospitalType = $session->read('hospitaltype');
			if($hospitalType=='NABH'){
				$chargeType='nabh_charges';
			}else{
				$chargeType='non_nabh_charges';
			}
			$surgeries = array();
				//debug($surgery_Data);exit;
			foreach($surgery_Data as $uniqueSurgery){
				if($session->read('website.instance') == 'kanpur'){
					$otServices = explode(',',$uniqueSurgery[OptAppointment][ot_service]);
					$tariffListObj = ClassRegistry::init('TariffList');
					$tariffListObj->bindModel(array(
							'hasOne' => array(
									'TariffAmount' =>array( 'foreignKey'=>'tariff_list_id','conditions'=>array('TariffList.is_deleted'=>0))
							)));
					$tariff = $tariffListObj->find('all',array('fields'=>array('TariffList.name',"TariffAmount.$chargeType"),
							'conditions'=>array("TariffList.id"=>$otServices)));
					$otChargedServices ='';
					foreach($tariff as $services){
						$otChargedServices[$services['TariffList']['name']] =  $services['TariffAmount'][$chargeType];
					}
				}
				//convert date to local format
				
				$sugeryDate = DateFormatComponent::formatDate2Local($uniqueSurgery['OptAppointment']['starttime'],'yyyy-mm-dd',true);
				$sugeryEndDate = DateFormatComponent::formatDate2Local($uniqueSurgery['OptAppointment']['endtime'],'yyyy-mm-dd',true);
				$otInDate = $uniqueSurgery['OptAppointment']['ot_in_date'];
				$otOutDate = $uniqueSurgery['OptAppointment']['out_date'];
				$optType = $uniqueSurgery['OptAppointment']['operation_type'];
				$surgeries[]=array('name'=>$uniqueSurgery['Surgery']['name'],
						'surgeryScheduleDate'=>$sugeryDate,
						'surgeryScheduleEndDate'=>$sugeryEndDate,
						/* 'surgeryAmount'=>$uniqueSurgery['TariffAmount'][$chargeType], */
						'surgeryAmount'=>$uniqueSurgery['OptAppointment']['surgery_cost'],
						'unitDays'=>$uniqueSurgery['TariffAmount']['unit_days'],
						'cghs_nabh'=>$uniqueSurgery['TariffList']['cghs_nabh'],
						'cghs_non_nabh'=>$uniqueSurgery['TariffList']['cghs_non_nabh'],
						'cghs_code'=>$uniqueSurgery['TariffList']['cghs_code'],
						'cghs_alias_name'=>$uniqueSurgery['TariffList']['cghs_alias_name'],
						'moa_sr_no'=>$uniqueSurgery['TariffAmount']['moa_sr_no'],
						'doctor'=>$uniqueSurgery['Initial']['name'].$uniqueSurgery['Surgeon']['doctor_name'],
						'doctor_education'=>$uniqueSurgery['Surgeon']['education'],
						'anaesthesist'=>$uniqueSurgery['AnaeInitial']['name'].$uniqueSurgery['Anaesthesist']['doctor_name'],
						'anaesthesist_education'=>$uniqueSurgery['Anaesthesist']['education'],
						'anaesthesist_cost'=>$uniqueSurgery['OptAppointment']['anaesthesia_cost'],
						'ot_charges'=>$uniqueSurgery['OptAppointment']['ot_charges'],
						/* 'anaesthesist_cost'=>$uniqueSurgery['AnaeTariffAmount'][$chargeType] */
						/** gaurav */
						'surgeon_cost'=>$uniqueSurgery['OptAppointment']['surgeon_amt'],
						'asst_surgeon_one'=>($uniqueSurgery['AssistantOne']['doctor_name']) ? $uniqueSurgery['AssistantOneInitial']['name'].$uniqueSurgery['AssistantOne']['doctor_name'].','.$uniqueSurgery['AssistantOne']['education'] : '',
						'asst_surgeon_one_charge'=>$uniqueSurgery['OptAppointment']['asst_surgeon_one_charge'],
						'asst_surgeon_two'=>($uniqueSurgery['AssistantTwo']['doctor_name']) ? $uniqueSurgery['AssistantTwoInitial']['name'].$uniqueSurgery['AssistantTwo']['doctor_name'].','.$uniqueSurgery['AssistantTwo']['education'] : '',
						'asst_surgeon_two_charge' => $uniqueSurgery['OptAppointment']['asst_surgeon_two_charge'],
						'cardiologist' => ($uniqueSurgery['Cardiologist']['doctor_name']) ? $uniqueSurgery['CardioInitial']['name'].$uniqueSurgery['Cardiologist']['doctor_name'].','.$uniqueSurgery['Cardiologist']['education'] : '',
						'cardiologist_charge' => $uniqueSurgery['OptAppointment']['cardiologist_charge'],
						'ot_assistant' => $uniqueSurgery['OptAppointment']['ot_asst_charge'],
						'extra_hour_charge' => $this->getExtraTimeOtCharge($otInDate,$otOutDate,$optType),
						'operationType' => $optType,
						'ot_extra_services' => $otChargedServices
						/**  EOF gaurav*/
				);
			}
				
			//EOF making serugery array
			// $packageDays =1 ;
			# echo  $surgeryDate;
			/*$surgeries[0]=array('name'=>'Heart Surgery','surgeryScheduleDate'=>'2012-04-21 13:45:00','surgeryAmount'=>'2000','unitDays'=>'3');
			 $surgeries[1]=array('name'=>'By Pass','surgeryScheduleDate'=>'2012-04-23 14:00:00','surgeryAmount'=>'1000','unitDays'=>'1');
			 $surgeries[2]=array('name'=>'testis','surgeryScheduleDate'=>'2012-04-26 10:20:00','surgeryAmount'=>'3000','unitDays'=>'2');
			 $surgeries[3]=array('name'=>'Leg Surgery1','surgeryScheduleDate'=>'2012-05-03 16:10:00','surgeryAmount'=>'4000','unitDays'=>'1');*/

			if(empty($location_id)){
				$location_id = $session->read('locationid');
			}
			$wardPatientObj->bindModel(array(
					'belongsTo' => array(
							'Ward' =>array('foreignKey' => 'ward_id'),
							'TariffAmount' =>array('foreignKey' => false,'conditions'=>array('Ward.tariff_list_id=TariffAmount.tariff_list_id','TariffAmount.tariff_standard_id'=>$tariffStandardId )),
							'TariffList'=>array('foreignKey' => false,'conditions'=>array('TariffAmount.tariff_list_id=TariffList.id'))
					)),false);

			$wardData = $wardPatientObj->find('all',array('group'=>array('WardPatient.id'),
					'conditions'=>array('patient_id'=>$id,'WardPatient.location_id'=>$location_id,'WardPatient.is_deleted'=>'0'),
					'fields'=>array('WardPatient.*','TariffList.id','TariffList.cghs_code,TariffAmount.moa_sr_no,TariffAmount.nabh_charges,TariffAmount.non_nabh_charges,TariffAmount.unit_days','Ward.name','Ward.id')));
			//array walk of ward Detail
 
			$dayArr = array();
			$wardDayCount =0 ; 
			$calDays = $this->calculateWardDays($wardData,$surgeries,$config_hrs);

			$dayArr = $calDays['dayArr'] ;
		$surgeryDays= $calDays['surgeryData']; //EOF day array calcualtion
		$daysBeforeAfterSurgeries = array();
		$j=0 ;
		
		if(!empty($surgeryDays['sugeryValidity'])){
			foreach($dayArr['day'] as $dayArrKey =>$daySubArr){
				$last  = end($daysBeforeAfterSurgeries) ;
				$splitDaySubArr =explode(" ",$daySubArr['out']);
				foreach($surgeryDays['sugeryValidity'] as $key =>$value){
					$surgeryStartDate = explode(" ",$value['start']);
					$surgeryEndDate   = explode(" ",$value['end']);

					if($value['validity']>1){
						//for surgery package days greater than 1
						//reduce 1 days for before 10AM case
						//below code is commented because for 24 hrs checkout no need to remove d last day
						//on compare with timing .
						/*if(strtotime($splitDaySubArr[0]." ".$config_hrs) > strtotime($value['start'])){

						$reducedByOneDay = strtotime($surgeryStartDate[0].'-1 Days') ;
						$reducedByOneDay = date("Y-m-d",$reducedByOneDay);
						unset($dayArr['day'][$dayArrKey-1]);//unset first day
						}else{*/
						$reducedByOneDay = $surgeryStartDate[0] ;
						//}
							
						//loop through validity days
							

						for($v=0;$v<$value['validity'];$v++){
							if(strtotime($splitDaySubArr[1]) <= strtotime($surgeryStartDate[1])){
								$dayArrKeyIncreased = $dayArrKey+1 ;
							}else{
								$dayArrKeyIncreased = $dayArrKey;
							}
							#echo date('d/m/Y : H:i:s',strtotime($splitDaySubArr[0]))."===".date('d/m/Y : H:i:s',strtotime($reducedByOneDay."+$v Days"))."<br>" ;
							if(strtotime($splitDaySubArr[0]) == strtotime($reducedByOneDay."+$v Days")){
								if(!isset($surgeryDays['sugeryValidity'][$key]['surgery_billing_date'])){
									$surgeryDays['sugeryValidity'][$key]['surgery_billing_date'] = $dayArr['day'][$dayArrKey]['in'];
								}
								unset($dayArr['day'][$dayArrKeyIncreased]);
							}

						}
						//EOF loop
					}/*else if(strtotime($splitDaySubArr[0]) == strtotime($surgeryStartDate[0])){//else for single day package surgery

					if(strtotime($splitDaySubArr[0]." ".$config_hrs) > strtotime($value['start']) && $dayArrKey!=0){
					unset($dayArr['day'][$dayArrKey-1]);
					}else{
					unset($dayArr['day'][$dayArrKey]);
					}
					}*/ //no need of else past
				}
				$j++ ;
			}
		}
		//BOF conservative n surgical combination

		$f=0;
		$combo=array();
			
		if(is_array($dayArr['day']) && !empty($dayArr['day'])){
			$lastDay  = end($dayArr['day']) ;
			foreach($dayArr['day'] as $dayArrKey =>$daySubArr){

				if($f<=count($dayArr['day'])){

					//For multiple surgeries for single day(charges)
					if((count($dayArr['day'])==1) && (is_array($surgeryDays['sugeryValidity']))){
						$combo[] = $daySubArr ;
						foreach($surgeryDays['sugeryValidity'] as $surgeryKey){
							$combo[] = $surgeryKey ;
						}
					}else{
						if($f ==0)$combo[] = $daySubArr ;
						//EOF multiple surgery
						$splitDaySubArr = explode(" ",$daySubArr['out']);
						//to insert surgeries between ward days

						foreach($surgeryDays['sugeryValidity'] as $surgeryKey=> $surgeryValue){


							/* 	echo "last day out ".$lastDay['out']."=" ;
							 echo "surgery start time".$surgeryValue['start']."=" ;
							echo "day out ".$daySubArr['out']."<br>" ; */
							/* echo $config_hrs; exit;
							 echo date("d-m-Y H:i:s",strtotime($splitDaySubArr[0]." ".$config_hrs))."=" ;
							echo $surgeryValue['start']."==".strtotime($surgeryValue['start'])."<br>"; */

							if(strtotime($splitDaySubArr[0]." ".$config_hrs) > strtotime($surgeryValue['start'])
			 					|| (
			 							//(strtotime($lastDay['out']) <= strtotime($surgeryValue['start'])) && (condition change when we add surgery for the current it's not addedd in current day bill by pankaj w and yashwant)
			 							(strtotime($lastDay['out']) >= strtotime($surgeryValue['start'])) &&
			 							(strtotime(date('Y-m-d H:i:s'))>=strtotime($surgeryValue['start'])) &&
			 							($daySubArr['out'] == $lastDay['out'])
			 					) ){
									
								$combo[] = $surgeryValue ; //for single surgery
								//unset added surgery
									
								//	unset($dayArr['day'][$dayArrKey]);
								unset($surgeryDays['sugeryValidity'][$surgeryKey]);

									
								//EOF package
							}
						}

						if($f >0 && !empty($dayArr['day'][$dayArrKey])) $combo[] = $dayArr['day'][$dayArrKey] ;

							

					}
					$f++;
				}else{
					$combo[] = $daySubArr ;

				}
			}
		}else if(is_array($surgeryDays['sugeryValidity']) && !empty($surgeryDays['sugeryValidity'])){

			//$combo[] = $surgeryDays['sugeryValidity'][0] ;
			//commented above to display multiple surgeries in listing
			$combo = $surgeryDays['sugeryValidity'] ;
		}

		$g=0;
		$groupCombo=array();
			

		foreach($combo as $roomKey=>$roomCost){
			if(isset($roomCost['ward'])){
				$groupCombo[$g][$roomCost['ward']][]=$roomCost ;
				if($combo[$roomKey+1]['ward']!=$roomCost['ward']){
					$g++;
				}
			}else{
				//if($roomKey>0)$g++; comment to maintaing proper array indexing

				$groupCombo[$g]=$roomCost ;
				$g++;
			}

		}
			
		if($locationObj->getCheckoutTime() != "24 hours"){
			foreach($groupCombo as $groupKey=>$subGroupCombo){
				$wardKeyN= key($subGroupCombo);
				foreach($subGroupCombo[$wardKeyN] as $wardKey=>$perWard){
					if(!empty($perWard['in'])){
						$groupCombo[$groupKey][$wardKeyN][$wardKey]['in']= DateFormatComponent::formatDate2STD($perWard['in'],Configure::read('date_format'));
					}
					if(!empty($perWard['out'])){
						$groupCombo[$groupKey][$wardKeyN][$wardKey]['out'] = DateFormatComponent::formatDate2STD($perWard['out'],Configure::read('date_format'));
					}
				}
			}
		}
		 
		//EOF combo
		return $groupCombo;
			//commented becuase 5:30 hours added already in above logic
		/*	foreach($dayArr['day'] as $dayKey=>$singleDay){
				if(!empty($singleDay['in'])){
					$dayArr['day'][$dayKey]['in'] = DateFormatComponent::formatDate2STD($singleDay['in'],Configure::read('date_format'));
				}
				if(!empty($singleDay['out'])){
					$dayArr['day'][$dayKey]['out'] = DateFormatComponent::formatDate2STD($singleDay['out'],Configure::read('date_format'));
				}
			} 
			return $dayArr;
				*/

			//EOD array walk
		}


		/**
	 * function to calculate ward charges for private packaged patient
	 * @param int $patientId (current encounter patient Id)
	 * @param int $packagedPatientId (previous or current encounter patient Id with which package is applied)
	 * @author Gaurav Chauriya
	 */
	public function calculatePrivatePackageDay2DayWardCost($patientId,$packagedPatientId){
		 
		$wardPatientObj  = Classregistry::init('WardPatient') ;
		$tariffStandardObj  = Classregistry::init('TariffStandard') ;
		$session = new CakeSession();
		$privatePackagedData = $this->getPackageNameAndCost($packagedPatientId);
		$locationId = $session->read('locationid');
		$wardPatientObj->bindModel(array(
				'belongsTo' => array(
						'Ward' =>array('foreignKey' => 'ward_id'),
						'TariffAmount' =>array('foreignKey' => false,
								'conditions'=>array('Ward.tariff_list_id=TariffAmount.tariff_list_id',
										'TariffAmount.tariff_standard_id'=>$tariffStandardObj->getPrivateTariffID($locationId) )),
						'TariffList'=>array('foreignKey' => false,'conditions'=>array('TariffAmount.tariff_list_id=TariffList.id'))
				)),false);

		$wardData = $wardPatientObj->find('all',array('group'=>array('WardPatient.id'),
				'conditions'=>array('patient_id'=>$patientId,'WardPatient.location_id'=>$locationId,'WardPatient.is_deleted'=>"0"),
				'fields'=>array('TariffAmount.nabh_charges','TariffAmount.non_nabh_charges','TariffAmount.moa_sr_no','TariffList.cghs_code',
						'WardPatient.in_date','WardPatient.out_date','Ward.name','Ward.id')));
		foreach($wardData as $wardInfo){
			if($session->read('hospitaltype')=='NABH'){
				$charge = (int)$wardInfo['TariffAmount']['nabh_charges']  ;
			}else{
				$charge = (int)$wardInfo['TariffAmount']['non_nabh_charges']  ;
			}

			$x = strtotime($wardInfo['WardPatient']['in_date']);
			$y = ($wardInfo['WardPatient']['out_date']) ? strtotime($wardInfo['WardPatient']['out_date']) : strtotime(date('Y-m-d H:i:s'));
			while($x < $y) {
				if($x <= strtotime(date('Y-m-d',strtotime($privatePackagedData['startDate']))) )
					$costArray[] = array(
							'cghs_code' => $wardInfo['TariffList']['cghs_code'],
							'moa_sr_no' => $wardInfo['TariffAmount']['moa_sr_no'],
							'in' => DateFormatComponent::formatDate2Local(date('Y-m-d H:i:s',$x),'yyyy-mm-dd',true),
							'out' => DateFormatComponent::formatDate2Local(date('Y-m-d H:i:s',$x),'yyyy-mm-dd',true),
							'cost' => $charge,
							'ward' => $wardInfo['Ward']['name'],
							'ward_id' => $wardInfo['Ward']['id']
					);

				if( $x > strtotime(date('Y-m-d',strtotime($privatePackagedData['endDate']))) ){
					$costArray[] = array(
							'cghs_code' => $wardInfo['TariffList']['cghs_code'],
							'moa_sr_no' => $wardInfo['TariffAmount']['moa_sr_no'],
							'in' => DateFormatComponent::formatDate2Local(date('Y-m-d H:i:s',$x),'yyyy-mm-dd',true),
							'out' => DateFormatComponent::formatDate2Local(date('Y-m-d H:i:s',$x),'yyyy-mm-dd',true),
							'cost' => $charge,
							'ward' => $wardInfo['Ward']['name'],
							'ward_id' => $wardInfo['Ward']['id']
					);

				}
				$x = $x+(3600*24);
			}
			$wardCostArray['day']=$costArray;
		}
		return ($wardCostArray);


	}


	
	/**
	 * private package information
	 * @author gaurav chauriya
	 */
	public function getPackageNameAndCost($packagedPatientId){
		if($packagedPatientId){
			$estimateConsultantBillingObj = classRegistry::init('EstimateConsultantBilling'); 
			
			$estimateConsultantBillingObj->bindModel(array(
					'hasOne'=>array(
							'PackageEstimate'=>array('foreignKey'=>false,
									'conditions'=>array('EstimateConsultantBilling.package_estimate_id = PackageEstimate.id')),
							'Patient'=>array('foreignKey' => false,
									'conditions'=>array('Patient.is_packaged = EstimateConsultantBilling.patient_id'))
					)));
			$packageData = $estimateConsultantBillingObj->find('first',array('conditions'=>array('EstimateConsultantBilling.patient_id'=>$packagedPatientId),
					'fields'=>array('PackageEstimate.name','EstimateConsultantBilling.discount','EstimateConsultantBilling.total_amount','EstimateConsultantBilling.no_of_days',
							'EstimateConsultantBilling.days_in_icu','Patient.form_received_on','Patient.package_application_date')));
			$packageData['EstimateConsultantBilling']['discount'] = unserialize($packageData['EstimateConsultantBilling']['discount']);

			if( $packageData['EstimateConsultantBilling']['discount']['total_discount_package'] )
				$packageAmount = $packageData['EstimateConsultantBilling']['discount']['total_discount_package'];
			else
				$packageAmount = $packageData['EstimateConsultantBilling']['total_amount'];

			$totalPackageDays = (int) $packageData['EstimateConsultantBilling']['no_of_days'] + (int) $packageData['EstimateConsultantBilling']['days_in_icu'];
			$startDate = $packageData['Patient']['package_application_date'];
			//$startDate = $dateFormatComObj->formatDate2Local($startDate,Configure::read('date_format'),true);
			$endDate = date('Y-m-d H:i:s', strtotime("+$totalPackageDays day", strtotime($packageData['Patient']['package_application_date'])));
			//$endDate = $dateFormatComObj->formatDate2Local($endDate,Configure::read('date_format'),true);

			return array('packageName'=> $packageData['PackageEstimate']['name'],
					'packageAmount'=> $packageAmount,
					'startDate'=> $startDate,
					'endDate'=> $endDate);
		}else
			return false;
	}

	/**
	 * function to calculate ot charge for extra time spent in Ot room
	 * @param dateTime $otInDate
	 * @param dateTime $otOutDate
	 * @param string $optType
	 * @return number integer
	 * @author Gaurav Chauriya
	 */


/*public function getExtraTimeOtCharge($otInDate,$otOutDate,$optType){
$difference = DateFormatComponent::dateDiff($otInDate,$otOutDate);debug($difference);
$totalExtraHalfHours = 0;
               if($difference->h != 0){
                   if($difference->h > 1)
                        $totalExtraHalfHours = ($difference->h - 1) * 2;
                   if($difference->i <= 30)
                       $totalExtraHalfHours = (int) $totalExtraHalfHours + 1;
                   else if($difference->i > 30)
                        $totalExtraHalfHours = (int) $totalExtraHalfHours + 2;
               }
return $extraHourPanelty = (strtolower($optType) == 'major') ? $totalExtraHalfHours * 2000 : $totalExtraHalfHours * 1000;
}*/

	public function getExtraTimeOtCharge($otInDate,$otOutDate,$optType){
		$difference = DateFormatComponent::dateDiff($otInDate,$otOutDate);
		$totalExtraHalfHours = 0;
                if($difference->h != 0){
                    if($difference->h > 1)
                         $totalExtraHalfHours = ($difference->h - 1) * 2;
                    if($difference->i <= 30)
                        $totalExtraHalfHours = (int) $totalExtraHalfHours + 1;
                    else if($difference->i > 30)
                         $totalExtraHalfHours = (int) $totalExtraHalfHours + 2;
                }
		return $extraHourPanelty = (strtolower($optType) == 'major') ? $totalExtraHalfHours * 2000 : $totalExtraHalfHours * 1000;
	}

	//EOF billing


	//function to calculate ward days
	//by pankaj
	function calculateWardDays($wardData=array(),$surgeries=array(),$config_hrs){ 
		$session = new CakeSession();
		foreach($wardData as $wardKey =>$wardValue){ 
			//Date Converting to Local b4 calculation
			if(!empty($wardValue['WardPatient']['in_date'])){
				$wardValue['WardPatient']['in_date'] = DateFormatComponent::formatDate2Local($wardValue['WardPatient']['in_date'],'yyyy-mm-dd',true);
			}
			if(!empty($wardValue['WardPatient']['out_date'])){
				$wardValue['WardPatient']['out_date'] = DateFormatComponent::formatDate2Local($wardValue['WardPatient']['out_date'],'yyyy-mm-dd',true);
			}
			$currDateUTC  = DateFormatComponent::formatDate2Local(date('Y-m-d H:i:s'),'yyyy-mm-dd',true)  ;
			//EOF date change

			//Bed cost
			if($session->read('hospitaltype')=='NABH'){
				$charge   = 	(int)$wardValue['TariffAmount']['nabh_charges']  ;
			}else{
				$charge   = 	(int)$wardValue['TariffAmount']['non_nabh_charges']  ;
			}

			//EOF bed cost
			$surgeryDays = $this->getSurgeryArray($surgeries,$wardValue['WardPatient']['in_date'],$wardValue['WardPatient']['out_date']);
			$surgeryFirstDate  = explode(" ",$surgeryDays['sugeryValidity'][0]['start']);
			$lastKey =end($surgeryDays['sugeryValidity']) ;
			$surgeryLastDate  =  explode(" ",$lastKey['end']);

			if(!empty($wardValue['WardPatient']['out_date'])){
					

				$slpittedIn = explode(" ",$wardValue['WardPatient']['in_date']) ;
				//if checkout timing is 24 hours then set time to default in time
				if($config_hrs=='24 hours'){
					$config_hrs = $slpittedIn[1];
				}
				//EOF config check
				$slpittedOut = explode(" ",$wardValue['WardPatient']['out_date']) ;
				$interval = DateFormatComponent::dateDiff($slpittedIn[0],$slpittedOut[0]);

				$days = $interval->days ; //to match with the date_diiff fucntion result as of 24hr day diff
				$hrInterval = DateFormatComponent::dateDiff($wardValue['WardPatient']['in_date'],$wardValue['WardPatient']['out_date']); //for hr calculation 
				if($days > 0 ){
					$dayArrCount  = count($dayArr['day']);
					for($i=0;$i<=$days;$i++){
							
						$nextDate  = date('Y-m-d H:i:s',strtotime($wardValue['WardPatient']['in_date'].$i." days")) ;
						// Code to add one day before 10 AM
						$firstDate10 = date('Y-m-d H:i:s',strtotime($slpittedIn[0]." $config_hrs"));

						//check if the shift of ward is between 4 hours to avoid that ward charges
						if($i !=0 && $hrInterval->h < 4 && $hrInterval->d ==0 && $hrInterval->m ==0 && $hrInterval->y ==0){
							//$dayArr['day'][$dayArrCount-1]['out'] = $wardValue['WardPatient']['out_date'] ;
							#echo "line8474";
							continue ; //no need maintain data below 4 hours
						}

						//to avoid if diff is less than 4 hours between closing time and in time
						$closingInterval = DateFormatComponent::dateDiff($wardValue['WardPatient']['in_date'],$firstDate10); //for hr calculation

						if($i !=0 &&  $closingInterval->h < 4 && $closingInterval->d ==0 && $closingInterval->m ==0 && $closingInterval->y ==0){

							//$dayArr['day'][$dayArrCount-1]['out'] = $wardValue['WardPatient']['out_date'];
							#echo "line8482"; //commneted for raju thakare 
							//continue ; //no need maintain data below 4 hours


						}
							

						if($i==0 && strtotime($wardValue['WardPatient']['in_date']) < strtotime($firstDate10)){
							/* 	$dayArr['day'][] = array('cghs_code'=>$wardValue['TariffList']['cghs_code'],
							 'cghs_nabh'=>$wardValue['TariffList']['cghs_nabh'],
									'cghs_non_nabh'=>$wardValue['TariffList']['cghs_non_nabh'],
									'moa_sr_no'=>$wardValue['TariffAmount']['moa_sr_no'],
									'apply_in_a_day'=>$wardValue['TariffList']['apply_in_a_day'],
									"in"=>date('Y-m-d H:i:s',strtotime($slpittedIn[0].' -1 days '.$config_hrs)),
									"out"=>$firstDate10,'cost'=>$charge,'ward'=>$wardValue['Ward']['name']) ; */
						}
							

						//checking for greater price of same day
						if(($dayArrCount>0)	&&	($i==0) && ($dayArr['day'][$dayArrCount-1]['out']==$wardValue['WardPatient']['in_date'])
								&& ($hrInterval->h >= 4 || $hrInterval->d > 0)){

							if($dayArr['day'][$dayArrCount-1]['cost']<$charge){
								$dayArr['day'][$dayArrCount-1]['cost'] = $charge ;
								$dayArr['day'][$dayArrCount-1]['ward'] = $wardValue['Ward']['name'] ;
								$dayArr['day'][$dayArrCount-1]['ward_id'] = $wardValue['Ward']['id'] ;
								$dayArr['day'][$dayArrCount-1]['service_id'] = $wardValue['TariffList']['id'] ;


							}
							#echo "line8508";
							continue;
						}

						//EOF cost check

						if( (strtotime($nextDate) >= strtotime($wardValue['WardPatient']['out_date'])) || ($i==$days) ){
							if($i>0){
								$firstOutDate10 = date('Y-m-d H:i:s',strtotime($slpittedOut[0]." ".$config_hrs));
								// start of skip day if discharged b4 10 AM
								if(strtotime($wardValue['WardPatient']['out_date']) < strtotime($firstOutDate10)){								 
									continue;
								}
								// end of skip day if discharged b4 10 AM
								$tempOutDate = strtotime($slpittedIn[0].$i." days $config_hrs");

							}else{
								$tempOutDate = strtotime($wardValue['WardPatient']['in_date']);
							}

							//skip if hour diff is less than 4 hours
							//check for in n out time diff (if the diff less than 4 hours then skip this iteration)
							$inConvertedDate  =  date('Y-m-d H:i:s',$tempOutDate);
							$outConvertedDate =  $wardValue['WardPatient']['out_date'];

							$shortTimeDiff    =  DateFormatComponent::dateDiff($inConvertedDate,$outConvertedDate);

							//$i cond added for below example
							/**
							 suppose admission on 22:00 and checkout timing is 00:00 then charges should be applied for that day
							 but this is not true for ward shuffling added by pankaj
							**/

							if($i != 0 && ($shortTimeDiff->h>0 || $shortTimeDiff->i>0)&& $shortTimeDiff->h<4 && $shortTimeDiff->d==0 && $shortTimeDiff->m==0 && $shortTimeDiff->y==0){
								#echo "line8541";
								continue ;
							}
							//skip if hour diff is less than 4 hours

							$dayArr['day'][] = array('cghs_code'=>$wardValue['TariffList']['cghs_code'],
									'moa_sr_no'=>$wardValue['TariffAmount']['moa_sr_no'],
									"in"=>date('Y-m-d H:i:s',$tempOutDate),
									"out"=>$wardValue['WardPatient']['out_date'],
									'cost'=>$charge,'ward'=>$wardValue['Ward']['name'],
									'ward_id'=>$wardValue['Ward']['id'],
									'service_id'=>$wardValue['TariffList']['id']) ;
						}else if((strtotime($nextDate) <= strtotime($wardValue['WardPatient']['out_date']))){

							if($i==0){
								//if($days==1)
								$tempOutDate = strtotime($slpittedIn[0]."1 days $config_hrs");
								//else
								//$tempOutDate = strtotime($slpittedIn[0].$i." days $config_hrs");
							}else{
								$tempOutDate = strtotime($wardValue['WardPatient']['in_date'].$i." days");
							}

							//check for in n out time diff (if the diff less than 4 hours then skip this iteration)
							$inConvertedDate  =date('Y-m-d H:i:s',strtotime($wardValue['WardPatient']['in_date'].$i." days")) ;
							$outConvertedDate = date('Y-m-d H:i:s',$tempOutDate);

							//echo "<br/>";
							$shortTimeDiff =   DateFormatComponent::dateDiff($inConvertedDate,$outConvertedDate);

							//$i cond added for below example
							/**
							 suppose admission on 22:00 and checkout timing is 00:00 then charges should be applied for that day
							 but this is not true for ward shuffling added by pankaj
							**/

							if($i != 0 && ($shortTimeDiff->h>0 || $shortTimeDiff->i>0)&& $shortTimeDiff->h<4 && $shortTimeDiff->d==0 && $shortTimeDiff->m==0 && $shortTimeDiff->y==0){
								#echo "line8574";
								continue ;
							}


							$dayArr['day'][] =
							array('cghs_code'=>$wardValue['TariffList']['cghs_code'],
									'moa_sr_no'=>$wardValue['TariffAmount']['moa_sr_no'],
									"in"=>$inConvertedDate,
									"out"=>$outConvertedDate,
									'cost'=>$charge,
									'ward'=>$wardValue['Ward']['name'],
									'ward_id'=>$wardValue['Ward']['id'],
									'service_id'=>$wardValue['TariffList']['id']) ;
						}
					}

				}else if($hrInterval->h >= 4){

					 
					$nextDate  = date('Y-m-d H:i:s',strtotime($wardValue['WardPatient']['in_date'])) ;
					//checking for greater price of same day
					//same day ward shift and price check 
					$dayArrCountEX = count($dayArr['day']);
					if(($dayArr['day'][$dayArrCountEX-1]['out']==$wardValue['WardPatient']['in_date'])){
						if($dayArr['day'][$dayArrCountEX-1]['cost']<$charge){
							$dayArr['day'][$dayArrCountEX-1]['cost'] = $charge ;
							$dayArr['day'][$dayArrCountEX-1]['ward'] = $wardValue['Ward']['name'] ;
							$dayArr['day'][$dayArrCountEX-1]['ward_id'] = $wardValue['Ward']['id'] ;
							$dayArr['day'][$dayArrCountEX-1]['service_id'] = $wardValue['TariffList']['id'] ;

						}
						$dayArr['day'][$dayArrCountEX-1]['out'] =  $wardValue['WardPatient']['out_date'] ; //so that we can compare out and in date to skip charge for same day
						continue;
					}

					if(is_array($wardData[$wardKey+1])){
						if($session->read('hospitaltype')=='NABH'){
							$nextCharge   = 	(int)$wardData[$wardKey+1]['TariffAmount']['nabh_charges']  ;
						}else{
							$nextCharge   = 	(int)$wardData[$wardKey+1]['TariffAmount']['non_nabh_charges']  ;
						}
						//check if the patient has stays more than 4hr our in next shifted ward
						$slpittedInForNext = explode(" ",$wardData[$wardKey+1]['WardPatient']['in_date']) ;
						if(!empty($wardData[$wardKey+1]['WardPatient']['out_date']))
							$slpittedOutForNext = explode(" ",$wardData[$wardKey+1]['WardPatient']['out_date']) ;
						else
							//$slpittedOutForNext = explode(" ",$currDateUTC) ;
							$slpittedOutForNext = explode(" ",$wardValue['WardPatient']['out_date']) ;

						$intervaForNext = DateFormatComponent::dateDiff($slpittedInForNext[0],$slpittedOutForNext[0]);
						if($intervaForNext->days > 0 || $intervaForNext->h >= 4)
							if($nextCharge > $charge) continue ;
						//EOF check
					} 	//EOF cost check

					if(strtotime($nextDate) > strtotime($wardValue['WardPatient']['out_date'])){
						if(is_array($wardData[$wardKey+1])){
							$dayArr['day'][] = array('cghs_code'=>$wardValue['TariffList']['cghs_code'],
									'moa_sr_no'=>$wardValue['TariffAmount']['moa_sr_no'],
									"in"=>$wardValue['WardPatient']['in_date'],
									"out"=>$wardData[$wardKey]['WardPatient']['out_date'],
									'cost'=>$charge,
									'ward'=>$wardValue['Ward']['name'],
									'ward_id'=>$wardValue['Ward']['id'],
									'service_id'=>$wardValue['TariffList']['id']) ;
						}else{
							$dayArr['day'][] = array('cghs_code'=>$wardValue['TariffList']['cghs_code'],
									'moa_sr_no'=>$wardValue['TariffAmount']['moa_sr_no'],
									"in"=>$wardValue['WardPatient']['in_date'],
									"out"=>$wardValue['WardPatient']['out_date'],
									'cost'=>$charge,'ward'=>$wardValue['Ward']['name'],'ward_id'=>$wardValue['Ward']['id'],
									'service_id'=>$wardValue['TariffList']['id']) ;
						}
					}else{
						$dayArr['day'][] =  array('cghs_code'=>$wardValue['TariffList']['cghs_code'],
								'moa_sr_no'=>$wardValue['TariffAmount']['moa_sr_no'],
								"in"=>$wardValue['WardPatient']['in_date'],
								"out"=>date('Y-m-d H:i:s',strtotime($wardValue['WardPatient']['out_date'])),
								'cost'=>$charge,'ward'=>$wardValue['Ward']['name'],'ward_id'=>$wardValue['Ward']['id'],
									'service_id'=>$wardValue['TariffList']['id']) ;
					}


				}else{
					//if($hrInterval->h < 4) continue ; //to skip same day ward shifting charges for less than 4 hours
					//check out date should less than indate for dday 1 adminission
					$dayArrCountEX = count($dayArr['day']);
					//check if the shift of ward is between 4 hours to avoid that ward charges
					if($hrInterval->h < 4 && $hrInterval->d ==0 && $hrInterval->m ==0 && $hrInterval->y ==0 && $i!=0){ //for first $i cond 
						if($dayArrCountEX > 0)
							$dayArr['day'][$dayArrCountEX-1]['out'] = $wardValue['WardPatient']['out_date']; //to correct same day charge compare for makiing previous and currnt day n time
						//echo "test2";
						continue ; //no need maintain data below 4 hours
					}



					if(($dayArr['day'][$dayArrCountEX-1]['out']==$wardValue['WardPatient']['in_date'])){
						if($dayArr['day'][$dayArrCountEX-1]['cost']<$charge){
							$dayArr['day'][$dayArrCountEX-1]['cost'] = $charge ;
							$dayArr['day'][$dayArrCountEX-1]['ward'] = $wardValue['Ward']['name'] ;
							$dayArr['day'][$dayArrCountEX-1]['ward_id'] = $wardValue['Ward']['id'] ;
							$dayArr['day'][$dayArrCountEX-1]['service_id'] = $wardValue['TariffList']['id'] ;

						}
						$dayArr['day'][$dayArrCountEX-1]['out'] =  $wardValue['WardPatient']['out_date'] ; //so that we can compare out and in date to skip charge for same day
						continue;
					}

					$dayArr['day'][] =  array(
							'cghs_code'=>$wardValue['TariffList']['cghs_code'],
							'cghs_nabh'=>$wardValue['TariffList']['cghs_nabh'],
							'cghs_non_nabh'=>$wardValue['TariffList']['cghs_non_nabh'],
							'moa_sr_no'=>$wardValue['TariffAmount']['moa_sr_no'],
							'apply_in_a_day'=>$wardValue['TariffList']['apply_in_a_day'],
							"in"=>$wardValue['WardPatient']['in_date'], //started day from checkout hrs
							"out"=>$wardValue['WardPatient']['out_date'],
							'cost'=>$charge,'ward'=>$wardValue['Ward']['name']
							,'ward_id'=>$wardValue['Ward']['id'],
							'service_id'=>$wardValue['TariffList']['id']) ;


				}
			}else{
				$slpittedIn = explode(" ",$wardValue['WardPatient']['in_date']) ;
				//if checkout timing is 24 hours then set time to default in time
				if($config_hrs=='24 hours'){
					$config_hrs = $slpittedIn[1];
				}
				//EOF config check
				$interval = DateFormatComponent::dateDiff($slpittedIn[0],date('Y-m-d'));
				$hrInterval = DateFormatComponent::dateDiff($wardValue['WardPatient']['in_date'],$currDateUTC); //for hr calculation
				$days = $interval->days ; //to match with the date_diiff fucntion result as of 24hr day diff
				$dayArrCount  = count($dayArr['day']);
				$firstDate10 = date('Y-m-d H:i:s',strtotime($slpittedIn[0]." ".$config_hrs));

				if($days > 0){
					for($i=0;$i<=$days;$i++){
						$nextDate  = date('Y-m-d H:i:s',strtotime($wardValue['WardPatient']['in_date'].$i." days")) ;

						if($i==0 && strtotime($wardValue['WardPatient']['in_date']) < strtotime($firstDate10)){
							$dayArr['day'][] = array(
									'cghs_code'=>$wardValue['TariffList']['cghs_code'],
									'cghs_nabh'=>$wardValue['TariffList']['cghs_nabh'],
									'cghs_non_nabh'=>$wardValue['TariffList']['cghs_non_nabh'],
									'moa_sr_no'=>$wardValue['TariffAmount']['moa_sr_no'],
									'apply_in_a_day'=>$wardValue['TariffList']['apply_in_a_day'],
									"in"=>date('Y-m-d H:i:s',strtotime($slpittedIn[0].' -1 day '.$config_hrs)),
									"out"=>$firstDate10,'cost'=>$charge,'ward'=>$wardValue['Ward']['name']
									,'ward_id'=>$wardValue['Ward']['id'],
									'service_id'=>$wardValue['TariffList']['id']) ;
						}

							
						//checking for greater price of same day
						if(($dayArrCount>0)	&&	($i==0) && ($dayArr['day'][$dayArrCount-1]['out']==$wardValue['WardPatient']['in_date'])){

							if($dayArr['day'][$dayArrCount-1]['cost']<$charge){
								$dayArr['day'][$dayArrCount-1]['cost'] = $charge ;
								$dayArr['day'][$dayArrCount-1]['ward'] = $wardValue['Ward']['name'] ;
								$dayArr['day'][$dayArrCount-1]['ward_id'] = $wardValue['Ward']['id'] ;
								$dayArr['day'][$dayArrCount-1]['service_id'] = $wardValue['TariffList']['id'] ;
							}
							continue;
						}

						//EOF cost check
							
						if(	(strtotime($nextDate) >= strtotime($currDateUTC)) || ($i==$days)){ //change || to && for hours diff

							if($i>0){
								$tempOutDate = strtotime($slpittedIn[0].$i." days $config_hrs");
							}else{
								$tempOutDate = strtotime($wardValue['WardPatient']['in_date']);
							}

							if($tempOutDate < strtotime($currDateUTC))  {
								//if cond to handle mid hours case
								//like if the starts at 6pm then the last day count should be upto 6pm
								//and skip the count after 6pm
								$dayArr['day'][] = array(
										'cghs_code'=>$wardValue['TariffList']['cghs_code'],
										'cghs_nabh'=>$wardValue['TariffList']['cghs_nabh'],
										'cghs_non_nabh'=>$wardValue['TariffList']['cghs_non_nabh'],
										'moa_sr_no'=>$wardValue['TariffAmount']['moa_sr_no'],
										'apply_in_a_day'=>$wardValue['TariffList']['apply_in_a_day'],
										"in"=>date('Y-m-d H:i:s',$tempOutDate),"out"=>$currDateUTC,
										'cost'=>$charge,'ward'=>$wardValue['Ward']['name'],
										'ward_id'=>$wardValue['Ward']['id'],
										'service_id'=>$wardValue['TariffList']['id']) ;
							}
						}else{

							//commented below line for correcting out date for first array element
							if($i==0){
								//if($days==1)
								$tempOutDate = strtotime($slpittedIn[0]."1 days $config_hrs");
								//else
								//$tempOutDate = strtotime($slpittedIn[0].$i." days $config_hrs");
							}else{
								$g= $i + 1 ;
								$tempOutDate =   strtotime($wardValue['WardPatient']['in_date'].$g." days");
							}

							//BOF pankaj
							//check if the previous entry is of same day
							/*	$previousIn =  explode(" ",$dayArr['day'][$dayArrCount-1]['in']);
							 $currentIn = explode(" ",$wardValue['WardPatient']['in_date']);

							if($previousIn[0]==$currentIn[0]){ pr($dayArr['day']);
							$dayArr['day'][$dayArrCount-1]['cost'] = $charge ;
							$dayArr['day'][$dayArrCount-1]['ward'] = $wardValue['Ward']['name'] ;
							$dayArr['day'][$dayArrCount-1]['out']=date('Y-m-d H:i:s',$tempOutDate) ;
							continue;
							}*/

							//EOF pankaj
							$dayArr['day'][] =  array('cghs_code'=>$wardValue['TariffList']['cghs_code'],
									'cghs_nabh'=>$wardValue['TariffList']['cghs_nabh'],
									'cghs_non_nabh'=>$wardValue['TariffList']['cghs_non_nabh'],
									'moa_sr_no'=>$wardValue['TariffAmount']['moa_sr_no'],
									'apply_in_a_day'=>$wardValue['TariffList']['apply_in_a_day'],
									"in"=>date('Y-m-d H:i:s',strtotime($wardValue['WardPatient']['in_date'].$i." days")),
									"out"=>date('Y-m-d H:i:s',$tempOutDate),'cost'=>$charge,
									'ward'=>$wardValue['Ward']['name']
									,'ward_id'=>$wardValue['Ward']['id'],
									'service_id'=>$wardValue['TariffList']['id']) ;
						}
					}

				}else if($hrInterval->h >= 4 || $wardDayCount == 0){
					$nextDate  = date('Y-m-d H:i:s',strtotime($wardValue['WardPatient']['in_date'])) ;
					//checking for greater price of same day
					//EOF cost check

					if(($dayArrCount>0)	 && ($dayArr['day'][$dayArrCount-1]['out']==$wardValue['WardPatient']['in_date'])){
						if($dayArr['day'][$dayArrCount-1]['cost']<$charge){
							$dayArr['day'][$dayArrCount-1]['cost'] = $charge ;
							$dayArr['day'][$dayArrCount-1]['ward'] = $wardValue['Ward']['name'] ;
							$dayArr['day'][$dayArrCount-1]['ward_id'] = $wardValue['Ward']['id'] ;
							$dayArr['day'][$dayArrCount-1]['service_id'] = $wardValue['TariffList']['id'] ;
						}
						continue;
					}
					if(strtotime($nextDate) > strtotime($currDateUTC)){
						$dayArr['day'][] = array(
								'cghs_code'=>$wardValue['TariffList']['cghs_code'],
								'moa_sr_no'=>$wardValue['TariffAmount']['moa_sr_no'],
								'in'=>date('Y-m-d H:i:s',strtotime($wardValue['WardPatient']['in_date'])),"out"=>$currDateUTC,'cost'=>$charge,
								'ward'=>$wardValue['Ward']['name'],'ward_id'=>$wardValue['Ward']['id'],
									'service_id'=>$wardValue['TariffList']['id']) ;
					}else{
						$dayArr['day'][] =  array('cghs_code'=>$wardValue['TariffList']['cghs_code'],'moa_sr_no'=>$wardValue['TariffAmount']['moa_sr_no'],"in"=>date('Y-m-d H:i:s',strtotime($wardValue['WardPatient']['in_date'])),"out"=>date('Y-m-d H:i:s',strtotime($wardValue['WardPatient']['in_date'])),'cost'=>$charge,
								'ward'=>$wardValue['Ward']['name'],'ward_id'=>$wardValue['Ward']['id'],
									'service_id'=>$wardValue['TariffList']['id']) ;
					}
				} 
			}
			$wardDayCount++ ;
		} 
		 
		return array('dayArr'=>$dayArr,'surgeryData'=>$surgeryDays) ; 
	}  


	//retrun surgerical duration
	function getSurgeryArray($subArray=array(),$in_date,$out_date){
		$sergerySlot =array();
		$conservativeDays =array();
		$locationObj = classRegistry::init('Location');
		
		//BOF collecting checkout hrs
		$config_hrs = $locationObj->getCheckoutTime();
		//if checkout timing is 24 hours then set time to default in time
		if($config_hrs=='24 hours'){
			$slpittedIn= explode(" ",$in_date);
			$config_hrs = $slpittedIn[1];
		}
		//EOF config check
		//EOD collecting hrs
		if(!empty($subArray)){
			foreach($subArray as $key =>$value){

				$slittedValiditiyDate = explode(" ",$value['surgeryScheduleDate']);
				//reduced 1day if time is before config hours
				if(strtotime($slittedValiditiyDate[0]." ".$config_hrs) > strtotime($value['surgeryScheduleDate']) && $value['unitDays'] > 1){
					$reducedValidity = $value['unitDays']-1 ;
				}else{
					if(strtotime($slittedValiditiyDate[0]." ".$config_hrs) > strtotime($value['surgeryScheduleDate']))
						$reducedValidity = 0 ;
					else
						$reducedValidity = $value['unitDays'] ;
				}
				//EOF config hours check
				$sergeryValidityDate = date('Y-m-d H:i:s',strtotime($slittedValiditiyDate[0].$reducedValidity." days $config_hrs"));
				if($key>0){
					$lastKey = end($sergerySlot) ;
					if(strtotime($lastKey['end']) > strtotime($sergeryValidityDate)){
						$sergerySlot[$key] = array( 'start'=>$value['surgeryScheduleDate'],
								'end'=>$lastKey['end'],
								'name'=>$value['name'],
								'cost'=>$value['surgeryAmount'],
								'validity'=>$value['unitDays'],
								'moa_sr_no'=>$value['moa_sr_no'],
								'cghs_nabh'=>$value['cghs_nabh'],
								'cghs_non_nabh'=>$value['cghs_non_nabh'],
								'cghs_code'=>$value['cghs_code'],
								'doctor'=>$value['doctor'],
								'doctor_education'=>$value['doctor_education'],
								'anaesthesist'=>$value['anaesthesist'],
								'anaesthesist_education'=>$value['anaesthesist_education'],
								'anaesthesist_cost'=>$value['anaesthesist_cost'],
								'ot_charges'=>$value['ot_charges'],
								'opt_id'=>$value['opt_id'],
								'discount'=>$value['discount'],
								'paid_amount'=>$value['paid_amount'],
								/** gaurav */
								'surgeon_cost'=>$value['surgeon_cost'],
								'asst_surgeon_one'=>$value['asst_surgeon_one'],
								'asst_surgeon_one_charge'=>$value['asst_surgeon_one_charge'],
								'asst_surgeon_two'=>$value['asst_surgeon_two'],
								'asst_surgeon_two_charge' => $value['asst_surgeon_two_charge'],
								'cardiologist' => $value['cardiologist'],
								'cardiologist_charge' => $value['cardiologist_charge'],
								'ot_assistant' => $value['ot_assistant'],
								'extra_hour_charge' => $value['extra_hour_charge'],
								'operationType' => $value['operationType'],
								'ot_extra_services' => $value['ot_extra_services']
						);
					}else{
						//BOF checking the diff between the two sergery validity
						$slpittedStart = explode(" ",$value['surgeryScheduleDate']) ;
						$slpittedEnd = explode(" ",$lastKey['end']) ;
						$interval = DateFormatComponent::dateDiff($slpittedEnd[0],$slpittedStart[0]);
						$extraDays = $this->is_In_Out_Before_10_AM($value['surgeryScheduleDate']);
						$remainingDays = $interval->days - $extraDays;
						if($remainingDays > 0){
							//include next day till 10AM in sergery package validity
							$nextDayTill10AM = date('Y-m-d H:i:s',strtotime($slpittedEnd[0]."0 days $config_hrs"));
							if(strtotime($nextDayTill10AM) <= strtotime($value['surgeryScheduleDate'])){
								for($c=1;$c<$remainingDays;$c++){
									if(strtotime($nextDayTill10AM) <= strtotime($value['surgeryScheduleDate'])){
										$conservativeDays[$key][] = array('in'=>$nextDayTill10AM,'out'=>date('Y-m-d H:i:s',strtotime($nextDayTill10AM.$c.' days')));
										$nextDayTill10AM = date('Y-m-d H:i:s',strtotime($nextDayTill10AM.'1 days'));
									}
								}
							}
						}
						//EOF validity check
						$sergerySlot[$key] = array('start'=>$value['surgeryScheduleDate'],
								'end'=>$sergeryValidityDate,
								'name'=>$value['name'],
								'cost'=>$value['surgeryAmount'],
								'validity'=>$value['unitDays'],
								'moa_sr_no'=>$value['moa_sr_no'],
								'cghs_nabh'=>$value['cghs_nabh'],
								'cghs_non_nabh'=>$value['cghs_non_nabh'],
								'cghs_code'=>$value['cghs_code'],
								'doctor'=>$value['doctor'],
								'doctor_education'=>$value['doctor_education'],
								'anaesthesist'=>$value['anaesthesist'],
								'anaesthesist_education'=>$value['anaesthesist_education'],
								'anaesthesist_cost'=>$value['anaesthesist_cost'],
								'ot_charges'=>$value['ot_charges'],
								'opt_id'=>$value['opt_id'],
								'discount'=>$value['discount'],
								'paid_amount'=>$value['paid_amount'],
								/** gaurav */
								'surgeon_cost'=>$value['surgeon_cost'],
								'asst_surgeon_one'=>$value['asst_surgeon_one'],
								'asst_surgeon_one_charge'=>$value['asst_surgeon_one_charge'],
								'asst_surgeon_two'=>$value['asst_surgeon_two'],
								'asst_surgeon_two_charge' => $value['asst_surgeon_two_charge'],
								'cardiologist' => $value['cardiologist'],
								'cardiologist_charge' => $value['cardiologist_charge'],
								'ot_assistant' => $value['ot_assistant'],
								'extra_hour_charge' => $value['extra_hour_charge'],
								'operationType' => $value['operationType'],
								'ot_extra_services' => $value['ot_extra_services']
							);
					}
				}else{
					if($value['unitDays'] > 1){//for single surgery as a package to set proper end calculated on the basis of validity period
						$sergerySlot[$key] = array('start'=>$value['surgeryScheduleDate'],
								'end'=>$sergeryValidityDate,
								'name'=>$value['name'],
								'cost'=>$value['surgeryAmount'],
								'validity'=>$value['unitDays'],
								'moa_sr_no'=>$value['moa_sr_no'],
								'cghs_nabh'=>$value['cghs_nabh'],
								'cghs_non_nabh'=>$value['cghs_non_nabh'],
								'cghs_code'=>$value['cghs_code'],
								'doctor'=>$value['doctor'],
								'doctor_education'=>$value['doctor_education'],
								'anaesthesist'=>$value['anaesthesist'],
								'anaesthesist_education'=>$value['anaesthesist_education'],
								'anaesthesist_cost'=>$value['anaesthesist_cost'],
								'ot_charges'=>$value['ot_charges'],
								'opt_id'=>$value['opt_id'],
								'discount'=>$value['discount'],
								'paid_amount'=>$value['paid_amount'],
								/** gaurav */
								'surgeon_cost'=>$value['surgeon_cost'],
								'asst_surgeon_one'=>$value['asst_surgeon_one'],
								'asst_surgeon_one_charge'=>$value['asst_surgeon_one_charge'],
								'asst_surgeon_two'=>$value['asst_surgeon_two'],
								'asst_surgeon_two_charge' => $value['asst_surgeon_two_charge'],
								'cardiologist' => $value['cardiologist'],
								'cardiologist_charge' => $value['cardiologist_charge'],
								'ot_assistant' => $value['ot_assistant'],
								'extra_hour_charge' => $value['extra_hour_charge'],
								'operationType' => $value['operationType'],
								'ot_extra_services' => $value['ot_extra_services']);
					}else{
						$sergerySlot[$key] = array('start'=>$value['surgeryScheduleDate'],
								// 'end'=>$sergeryValidityDate,
								'end'=>$value['surgeryScheduleEndDate'],
								'name'=>$value['name'],
								'cost'=>$value['surgeryAmount'],
								'validity'=>$value['unitDays'],
								'moa_sr_no'=>$value['moa_sr_no'],
								'cghs_nabh'=>$value['cghs_nabh'],
								'cghs_non_nabh'=>$value['cghs_non_nabh'],
								'cghs_code'=>$value['cghs_code'],
								'doctor'=>$value['doctor'],
								'doctor_education'=>$value['doctor_education'],
								'anaesthesist'=>$value['anaesthesist'],
								'anaesthesist_education'=>$value['anaesthesist_education'],
								'anaesthesist_cost'=>$value['anaesthesist_cost'],
								'ot_charges'=>$value['ot_charges'],
								'opt_id'=>$value['opt_id'],
								'discount'=>$value['discount'],
								'paid_amount'=>$value['paid_amount'],
								/** gaurav */
								'surgeon_cost'=>$value['surgeon_cost'],
								'asst_surgeon_one'=>$value['asst_surgeon_one'],
								'asst_surgeon_one_charge'=>$value['asst_surgeon_one_charge'],
								'asst_surgeon_two'=>$value['asst_surgeon_two'],
								'asst_surgeon_two_charge' => $value['asst_surgeon_two_charge'],
								'cardiologist' => $value['cardiologist'],
								'cardiologist_charge' => $value['cardiologist_charge'],
								'ot_assistant' => $value['ot_assistant'],
								'extra_hour_charge' => $value['extra_hour_charge'],
								'operationType' => $value['operationType'],
								'ot_extra_services' => $value['ot_extra_services']);
					}
				}
			}
		}

		return array('sugeryValidity'=>$sergerySlot,'conservativeDays'=>$conservativeDays) ;
	}

	//function to check whether the patient added before 10AM and
	function is_In_Out_Before_10_AM($inDate=null,$outDate=null,$surgeryDate=null){
		$days = 0;

		if(!empty($inDate)){
			if(strlen($inDate)>10){
				$entryHr = substr($inDate,-8,2);
				$days = ($entryHr >= 10)?0:1 ;
			}
		}
		if(!empty($outDate)){
			//if(empty($surgeryDate)){
			if(strlen($inDate)>10){
				$entryHr = substr($outDate,-8,2);
				$days += ($entryHr <= 10)?0:1 ;
			}
			//}
		}
		return (int)$days ;

	}
	
	public function getSurgeryDetails($id,$tariffStandardId){
		$optAppointmentObj = ClassRegistry::init('OptAppointment');
		$session = new CakeSession();
		//making sergery array
		$optAppointmentObj->unbindModel(array(
				'belongsTo' => array('Initial','Patient','Location','Opt','OptTable','Surgery','SurgerySubcategory','Doctor','DoctorProfile'
		
				)));
		$optAppointmentObj->bindModel(array(
				'belongsTo' => array(
						'TariffList' =>array( 'foreignKey'=>'tariff_list_id','type'=>'LEFT','conditions'=>array('TariffList.is_deleted'=>0)),
						'Surgeon' =>array('className'=>'DoctorProfile','foreignKey'=>false,'type'=>'LEFT',
								'conditions'=>array('Surgeon.user_id=OptAppointment.doctor_id')),
						'User'=>array('foreignKey'=>'doctor_id'),
						'Initial'=>array('foreignKey'=>false,'conditions'=>array('Initial.id=User.initial_id')),
						/** Anaesthesist */
						'Anaesthesist' =>array('className'=>'DoctorProfile','foreignKey'=>false,'type'=>'LEFT',
								'conditions'=>array('Anaesthesist.user_id=OptAppointment.department_id')),
						'AnaeUser'=>array('className'=>'User','foreignKey'=>'department_id'),
						'AnaeInitial'=>array('className'=>'Initial','foreignKey'=>false,'conditions'=>array('AnaeInitial.id=AnaeUser.initial_id')),
		
						/** Assistant Surgeon one */
						'AssistantOne' =>array('className'=>'DoctorProfile','foreignKey'=>false,'type'=>'LEFT',
								'conditions'=>array('AssistantOne.user_id=OptAppointment.asst_surgeon_one')),
						'AssistantOneUser'=>array('className'=>'User',
								'foreignKey'=>'asst_surgeon_one'),
						'AssistantOneInitial'=>array('className'=>'Initial','foreignKey'=>false,
								'conditions'=>array('AssistantOneInitial.id=AssistantOneUser.initial_id')),
						/** Assistant Surgeon two */
						'AssistantTwo' =>array('className'=>'DoctorProfile','foreignKey'=>false,'type'=>'LEFT',
								'conditions'=>array('AssistantTwo.user_id=OptAppointment.asst_surgeon_two')),
						'AssistantTwoUser'=>array('className'=>'User',
								'foreignKey'=>'asst_surgeon_two'),
						'AssistantTwoInitial'=>array('className'=>'Initial','foreignKey'=>false,
								'conditions'=>array('AssistantTwoInitial.id=AssistantTwoUser.initial_id')),
		
						/** Cardiologist */
						'Cardiologist' =>array('className'=>'DoctorProfile','foreignKey'=>false,'type'=>'LEFT',
								'conditions'=>array('Cardiologist.user_id=OptAppointment.cardiologist_id')),
						'CardioUser'=>array('className'=>'User',
								'foreignKey'=>'cardiologist_id'),
						'CardioInitial'=>array('className'=>'Initial','foreignKey'=>false,
								'conditions'=>array('CardioInitial.id=CardioUser.initial_id')),
		
						'TariffAmount' =>array( 'foreignKey'=>false,'conditions'=>array('TariffAmount.tariff_list_id=OptAppointment.tariff_list_id',
								'TariffAmount.tariff_standard_id'=>$tariffStandardId)),
						'Surgery'=>array('foreignKey'=>'surgery_id'),
						'AnaeTariffAmount' =>array('className'=>'TariffAmount',
								'foreignKey'=>false,
								'conditions'=>array('AnaeTariffAmount.tariff_list_id=OptAppointment.anaesthesia_tariff_list_id',
										"AnaeTariffAmount.tariff_standard_id"=>$tariffStandardId) )
							
				)));
		$procedureCompleteSondition = ($session->read('website.instance') == 'kanpur') ? 'OptAppointment.procedure_complete = 1' : '';
		$surgery_Data = $optAppointmentObj->find('all',
				array('conditions'=>array('OptAppointment.location_id'=>$session->read('locationid'),$procedureCompleteSondition,
						'OptAppointment.is_deleted'=>0,'OptAppointment.patient_id'=>$id,'OptAppointment.is_false_appointment'=>0),/** is_false_appointment == 0 means non packaged ot */
						'fields'=>array('OptAppointment.surgery_cost','OptAppointment.ot_charges','OptAppointment.anaesthesia_cost','OptAppointment.anaesthesia_tariff_list_id',
								'Surgeon.education','Surgeon.doctor_name','Anaesthesist.education','Anaesthesist.doctor_name',
								'TariffList.*,TariffAmount.moa_sr_no,OptAppointment.id,OptAppointment.paid_amount,OptAppointment.surgeon_amt,
								TariffAmount.tariff_list_id,TariffAmount.nabh_charges,TariffAmount.non_nabh_charges,
								TariffAmount.unit_days','AnaeTariffAmount.id','AnaeTariffAmount.nabh_charges','AnaeTariffAmount.non_nabh_charges',
								'OptAppointment.starttime','OptAppointment.endtime','Surgery.name','Initial.name','AnaeInitial.name',
								'OptAppointment.schedule_date','OptAppointment.department_id','TariffList.name',
								'AssistantOneInitial.name','AssistantOne.doctor_name','AssistantOne.education','OptAppointment.asst_surgeon_one_charge',
								'AssistantTwoInitial.name','AssistantTwo.doctor_name','AssistantTwo.education','OptAppointment.asst_surgeon_two_charge',
								'CardioInitial.name','Cardiologist.doctor_name','Cardiologist.education','OptAppointment.cardiologist_charge','OptAppointment.ot_asst_charge',
								'OptAppointment.ot_in_date','OptAppointment.out_date','OptAppointment.operation_type','OptAppointment.ot_service'),
						'order'=>'OptAppointment.schedule_date Asc',
						'group'=>'OptAppointment.id',
						'recursive'=>1));
		
		
		if($session->read('website.instance') == 'kanpur'){
			$tariffListObj = ClassRegistry::init('TariffList');
			$tariffListObj->bindModel(array(
					'hasOne' => array(
							'TariffAmount' =>array( 'foreignKey'=>'tariff_list_id','conditions'=>array('TariffList.is_deleted'=>0))
					)));
		}
		/********************** Surgery Data Starts ******************************/
		$hospitalType = $session->read('hospitaltype');
		if($hospitalType=='NABH'){
			$chargeType='nabh_charges';
		}else{
			$chargeType='non_nabh_charges';
		}
		$surgeries = array();
		//debug($surgery_Data);exit;
		foreach($surgery_Data as $uniqueSurgery){
			if($session->read('website.instance') == 'kanpur'){
				$otServices = explode(',',$uniqueSurgery[OptAppointment][ot_service]);
				$tariff = $tariffListObj->find('all',array('fields'=>array('TariffList.name',"TariffAmount.".$chargeType),
						'conditions'=>array("TariffList.id"=>$otServices)));
				$otChargedServices ='';
				foreach($tariff as $services){
					$otChargedServices[$services['TariffList']['name']] =  $services['TariffAmount'][$chargeType];
				}
			}
			//convert date to local format
		
			$sugeryDate = DateFormatComponent::formatDate2Local($uniqueSurgery['OptAppointment']['starttime'],'yyyy-mm-dd',true);
			$sugeryEndDate = DateFormatComponent::formatDate2Local($uniqueSurgery['OptAppointment']['endtime'],'yyyy-mm-dd',true);
			$otInDate = $uniqueSurgery['OptAppointment']['ot_in_date'];
			$otOutDate = $uniqueSurgery['OptAppointment']['out_date'];
			$optType = $uniqueSurgery['OptAppointment']['operation_type'];
			$surgeries[]=array('name'=>$uniqueSurgery['Surgery']['name'],
					'surgeryScheduleDate'=>$sugeryDate,
					'surgeryScheduleEndDate'=>$sugeryEndDate,
					/* 'surgeryAmount'=>$uniqueSurgery['TariffAmount'][$chargeType], */
					'surgeryAmount'=>$uniqueSurgery['OptAppointment']['surgery_cost'],
					'unitDays'=>$uniqueSurgery['TariffAmount']['unit_days'],
					'cghs_nabh'=>$uniqueSurgery['TariffList']['cghs_nabh'],
					'cghs_non_nabh'=>$uniqueSurgery['TariffList']['cghs_non_nabh'],
					'cghs_code'=>$uniqueSurgery['TariffList']['cghs_code'],
					'cghs_alias_name'=>$uniqueSurgery['TariffList']['cghs_alias_name'],
					'moa_sr_no'=>$uniqueSurgery['TariffAmount']['moa_sr_no'],
					'doctor'=>$uniqueSurgery['Initial']['name'].$uniqueSurgery['Surgeon']['doctor_name'],
					'doctor_education'=>$uniqueSurgery['Surgeon']['education'],
					'anaesthesist'=>$uniqueSurgery['AnaeInitial']['name'].$uniqueSurgery['Anaesthesist']['doctor_name'],
					'anaesthesist_education'=>$uniqueSurgery['Anaesthesist']['education'],
					'anaesthesist_cost'=>$uniqueSurgery['OptAppointment']['anaesthesia_cost'],
					'ot_charges'=>$uniqueSurgery['OptAppointment']['ot_charges'],
					/* 'anaesthesist_cost'=>$uniqueSurgery['AnaeTariffAmount'][$chargeType] */
					/** gaurav */
					'surgeon_cost'=>$uniqueSurgery['OptAppointment']['surgeon_amt'],
					'asst_surgeon_one'=>($uniqueSurgery['AssistantOne']['doctor_name']) ? $uniqueSurgery['AssistantOneInitial']['name'].$uniqueSurgery['AssistantOne']['doctor_name'].','.$uniqueSurgery['AssistantOne']['education'] : '',
					'asst_surgeon_one_charge'=>$uniqueSurgery['OptAppointment']['asst_surgeon_one_charge'],
					'asst_surgeon_two'=>($uniqueSurgery['AssistantTwo']['doctor_name']) ? $uniqueSurgery['AssistantTwoInitial']['name'].$uniqueSurgery['AssistantTwo']['doctor_name'].','.$uniqueSurgery['AssistantTwo']['education'] : '',
					'asst_surgeon_two_charge' => $uniqueSurgery['OptAppointment']['asst_surgeon_two_charge'],
					'cardiologist' => ($uniqueSurgery['Cardiologist']['doctor_name']) ? $uniqueSurgery['CardioInitial']['name'].$uniqueSurgery['Cardiologist']['doctor_name'].','.$uniqueSurgery['Cardiologist']['education'] : '',
					'cardiologist_charge' => $uniqueSurgery['OptAppointment']['cardiologist_charge'],
					'ot_assistant' => $uniqueSurgery['OptAppointment']['ot_asst_charge'],
					'extra_hour_charge' => $this->getExtraTimeOtCharge($otInDate,$otOutDate,$optType),
					'operationType' => $optType,
					'ot_extra_services' => $otChargedServices
					/**  EOF gaurav*/
			);
		}
		return $surgeries;
		//EOF making serugery array
	}
	
	function finalDischargeJV($patientId,$singleBill=null){
		$ServiceBillObj  = Classregistry::init('ServiceBill') ;
		$ConsultantBillingObj  = Classregistry::init('ConsultantBilling') ;
		$OptAppointmentObj  = Classregistry::init('OptAppointment') ;
		$PharmacySalesBillObj  = Classregistry::init('PharmacySalesBill') ;
		
		$this->JVLabData($patientId);
		$this->JVRadData($patientId);
		$ServiceBillObj->JVServiceData($patientId);
		$ConsultantBillingObj->JVConsultantData($patientId);
		$OptAppointmentObj->JVSurgeryData($patientId);
		$PharmacySalesBillObj->JVSaleBillData($patientId);
	}

	//get docor charges as per ward days by amit j.
	public function getDoctorCharges($days,$hospitalType,$tariffStandardId,$patientType='',$treatment_type=null){
		$session=new CakeSession();
		
			if($session->read('website.instance')=='vadodara') return ;
			
		$tariffStandardObj=ClassRegistry::init('TariffStandard') ;
		$pvtTariffStandard= $tariffStandardObj->getPrivateTariffID() ;
		
		//if($tariffStandardId!=$pvtTariffStandard)return 0;
		$tariffAmountObj = ClassRegistry::init('TariffAmount');
		$tariffListObj = ClassRegistry::init('TariffList'); 
		$session = new CakeSession();
		$tariffListId=$tariffListObj->getServiceIdByName(Configure::read('DoctorsCharges'));//get tariff list id
		if($patientType=='OPD'){
			$doctorRateData = $tariffAmountObj->find('first',array('fields'=>array('TariffAmount.nabh_charges','TariffAmount.non_nabh_charges'),
					'conditions'=>array('TariffAmount.tariff_list_id'=>$treatment_type,
							'TariffAmount.tariff_standard_id'=>$tariffStandardId,'TariffAmount.location_id'=>$session->read('locationid'))));
			$days=1;

		}else{
			$doctorRateData=$tariffAmountObj->find('first',array('conditions'=>array('tariff_list_id'=>$tariffListId,'tariff_standard_id'=>$tariffStandardId)));
		}
	 
		 
		if($hospitalType=='NABH'){
			$doctorRate=$doctorRateData['TariffAmount']['nabh_charges'];
		}else{
			$doctorRate=$doctorRateData['TariffAmount']['non_nabh_charges'];
		}
		$cost=$days*$doctorRate;
		return $cost;
	}
	//get nursing charges as per ward days by amit j.
	public function getNursingCharges($days,$hospitalType,$tariffStandardId){
		$session=new CakeSession();
		if($session->read('website.instance')=='vadodara') return ;
		 
		$tariffStandardObj=ClassRegistry::init('TariffStandard') ;
		$pvtTariffStandard=$tariffStandardObj->getPrivateTariffID() ;
		//if($tariffStandardId!=$pvtTariffStandard) return 0;
		$tariffAmountObj = ClassRegistry::init('TariffAmount');
		$tariffListObj = ClassRegistry::init('TariffList'); 
		$tariffListId=$tariffListObj->getServiceIdByName(Configure::read('NursingCharges'));//get tariff list id
	
		$nursingRateData=$tariffAmountObj->find('first',array('conditions'=>array('tariff_list_id'=>$tariffListId,'tariff_standard_id'=>$tariffStandardId)));
		if($hospitalType=='NABH'){
			$nursingRate=$nursingRateData['TariffAmount']['nabh_charges'];
		}else{
			$nursingRate=$nursingRateData['TariffAmount']['non_nabh_charges'];
		}
		$cost=0;
			
		$cost=$cost + ($days*$nursingRate);
			
		return  $cost;
	}
	
	//function to return ward wise patient charges by amit j.
	function getWardWiseCharges($wardData=array()){
		if(!$wardData) return false ;
		foreach($wardData['day'] as $key=>$value){
			$wardCost[$value['ward_id']] = $wardCost[$value['ward_id']]+ $value['cost'];
		}
		return $wardCost ;
	}
	/**
	 * function to get array of surgeries
	 * @param integer $patientId
	 * @author Gaurav Chauriya
	 */
	public function getSurgeryCharges($patientId){
		$optAppointmentObj = Classregistry::init('OptAppointment') ;
		$locationObj = Classregistry::init('Location') ;
		$tariffStandardObj = Classregistry::init('TariffStandard') ;
		$session = new CakeSession();
		//making sergery array
		$optAppointmentObj->unbindModel(array(
				'belongsTo' => array('Initial','Patient','Location','Opt','OptTable','Surgery','SurgerySubcategory','Doctor','DoctorProfile'
	
				)));
		$optAppointmentObj->bindModel(array(
				'belongsTo' => array(
						'TariffList' =>array( 'foreignKey'=>'tariff_list_id','type'=>'LEFT','conditions'=>array('TariffList.is_deleted'=>0)),
						'Surgeon' =>array('className'=>'DoctorProfile','foreignKey'=>false,'type'=>'LEFT',
								'conditions'=>array('Surgeon.user_id=OptAppointment.doctor_id')),
						'User'=>array('foreignKey'=>'doctor_id'),
						'Initial'=>array('foreignKey'=>false,'conditions'=>array('Initial.id=User.initial_id')),
						/** Anaesthesist */
						'Anaesthesist' =>array('className'=>'DoctorProfile','foreignKey'=>false,'type'=>'LEFT',
								'conditions'=>array('Anaesthesist.user_id=OptAppointment.department_id')),
						'AnaeUser'=>array('className'=>'User','foreignKey'=>'department_id'),
						'AnaeInitial'=>array('className'=>'Initial','foreignKey'=>false,'conditions'=>array('AnaeInitial.id=AnaeUser.initial_id')),
	
						/** Assistant Surgeon one */
						'AssistantOne' =>array('className'=>'DoctorProfile','foreignKey'=>false,'type'=>'LEFT',
								'conditions'=>array('AssistantOne.user_id=OptAppointment.asst_surgeon_one')),
						'AssistantOneUser'=>array('className'=>'User',
								'foreignKey'=>'asst_surgeon_one'),
						'AssistantOneInitial'=>array('className'=>'Initial','foreignKey'=>false,
								'conditions'=>array('AssistantOneInitial.id=AssistantOneUser.initial_id')),
						/** Assistant Surgeon two */
						'AssistantTwo' =>array('className'=>'DoctorProfile','foreignKey'=>false,'type'=>'LEFT',
								'conditions'=>array('AssistantTwo.user_id=OptAppointment.asst_surgeon_two')),
						'AssistantTwoUser'=>array('className'=>'User',
								'foreignKey'=>'asst_surgeon_two'),
						'AssistantTwoInitial'=>array('className'=>'Initial','foreignKey'=>false,
								'conditions'=>array('AssistantTwoInitial.id=AssistantTwoUser.initial_id')),
	
						/** Cardiologist */
						'Cardiologist' =>array('className'=>'DoctorProfile','foreignKey'=>false,'type'=>'LEFT',
								'conditions'=>array('Cardiologist.user_id=OptAppointment.cardiologist_id')),
						'CardioUser'=>array('className'=>'User',
								'foreignKey'=>'cardiologist_id'),
						'CardioInitial'=>array('className'=>'Initial','foreignKey'=>false,
								'conditions'=>array('CardioInitial.id=CardioUser.initial_id')),
	
						'TariffAmount' =>array( 'foreignKey'=>false,'conditions'=>array('TariffAmount.tariff_list_id=OptAppointment.tariff_list_id',
								'TariffAmount.tariff_standard_id'=>$tariffStandardObj->getTariffIDByPatientId($patientId))),
						'Surgery'=>array('foreignKey'=>'surgery_id'),
						'AnaeTariffAmount' =>array('className'=>'TariffAmount',
								'foreignKey'=>false,
								'conditions'=>array('AnaeTariffAmount.tariff_list_id=OptAppointment.anaesthesia_tariff_list_id',
										"AnaeTariffAmount.tariff_standard_id"=>$tariffStandardObj->getTariffIDByPatientId($patientId)) )
	
				)));
		$procedureCompleteSondition = ($session->read('website.instance') == 'kanpur') ? 'OptAppointment.procedure_complete = 1' : '';
		$surgery_Data = $optAppointmentObj->find('all',
				array('conditions'=>array('OptAppointment.location_id'=>$session->read('locationid'),$procedureCompleteSondition,
						'OptAppointment.is_deleted'=>0,'OptAppointment.patient_id'=>$patientId,'OptAppointment.is_false_appointment'=>0),/** is_false_appointment == 0 means non packaged ot */
						'fields'=>array('Surgery.id','OptAppointment.id','OptAppointment.paid_amount','OptAppointment.surgery_cost','OptAppointment.ot_charges','OptAppointment.anaesthesia_cost','OptAppointment.anaesthesia_tariff_list_id',
								'Surgeon.education','Surgeon.doctor_name','Anaesthesist.education','Anaesthesist.doctor_name','OptAppointment.discount','OptAppointment.billing_id',
								'TariffList.*,TariffAmount.moa_sr_no,OptAppointment.id,OptAppointment.paid_amount,OptAppointment.surgeon_amt,
								TariffAmount.tariff_list_id,TariffAmount.nabh_charges,TariffAmount.non_nabh_charges,
								TariffAmount.unit_days','AnaeTariffAmount.id','AnaeTariffAmount.nabh_charges','AnaeTariffAmount.non_nabh_charges',
								'OptAppointment.starttime','OptAppointment.endtime','Surgery.name','Initial.name','AnaeInitial.name',
								'OptAppointment.schedule_date','OptAppointment.department_id','TariffList.name',
								'AssistantOneInitial.name','AssistantOne.doctor_name','AssistantOne.education','OptAppointment.asst_surgeon_one_charge',
								'AssistantTwoInitial.name','AssistantTwo.doctor_name','AssistantTwo.education','OptAppointment.asst_surgeon_two_charge',
								'CardioInitial.name','Cardiologist.doctor_name','Cardiologist.education','OptAppointment.cardiologist_charge','OptAppointment.ot_asst_charge',
								'OptAppointment.ot_in_date','OptAppointment.out_date','OptAppointment.operation_type','OptAppointment.ot_service','OptAppointment.procedure_complete'),
						'order'=>'OptAppointment.schedule_date Asc',
						'group'=>'OptAppointment.id',
						'recursive'=>1)); 
	
		if($session->read('website.instance') == 'kanpur'){
			$tariffListObj = ClassRegistry::init('TariffList');
			$tariffListObj->bindModel(array(
					'hasOne' => array(
							'TariffAmount' =>array( 'foreignKey'=>'tariff_list_id','conditions'=>array('TariffList.is_deleted'=>0))
					)),false);
		}
		/********************** Surgery Data Starts ******************************/
		$hospitalType = $session->read('hospitaltype');
		if($hospitalType=='NABH'){
			$chargeType='nabh_charges';
		}else{
			$chargeType='non_nabh_charges';
		}
		$surgeries = array();
		foreach($surgery_Data as $uniqueSurgery){
			if($session->read('website.instance') == 'kanpur'){
				$otServices = unserialize($uniqueSurgery[OptAppointment][ot_service]);
				/*$tariff = $tariffListObj->find('all',array('fields'=>array('TariffList.name',"TariffAmount.".$chargeType),
						'conditions'=>array("TariffList.id"=>$otServices,'TariffList.is_deleted'=>0,'TariffAmount.is_deleted'=>0)));*/
				$otChargedServices ='';
				foreach($otServices as $key => $services){
					$otChargedServices[$key] =  $services;//['TariffAmount'][$chargeType];
				}
			}
			//convert date to local format
	
			$sugeryDate = DateFormatComponent::formatDate2Local($uniqueSurgery['OptAppointment']['starttime'],'yyyy-mm-dd',true);
			$sugeryEndDate = DateFormatComponent::formatDate2Local($uniqueSurgery['OptAppointment']['endtime'],'yyyy-mm-dd',true);
			$otInDate = $uniqueSurgery['OptAppointment']['ot_in_date'];
			$otOutDate = $uniqueSurgery['OptAppointment']['out_date'];
			$optType = $uniqueSurgery['OptAppointment']['operation_type'];
			$surgeries[]=array(
					'start'=>$sugeryDate,
					'end'=>$sugeryEndDate,
					'surgery_id'=>$uniqueSurgery['Surgery']['id'],
					'name'=>$uniqueSurgery['Surgery']['name'],
					'cost'=>$uniqueSurgery['OptAppointment']['surgery_cost'],
					'validity'=>$uniqueSurgery['TariffAmount']['unit_days'],
					'cghs_nabh'=>$uniqueSurgery['TariffList']['cghs_nabh'],
					'cghs_non_nabh'=>$uniqueSurgery['TariffList']['cghs_non_nabh'],
					'cghs_code'=>$uniqueSurgery['TariffList']['cghs_code'],
					'cghs_alias_name'=>$uniqueSurgery['TariffList']['cghs_alias_name'],
					'moa_sr_no'=>$uniqueSurgery['TariffAmount']['moa_sr_no'],
					'doctor'=>$uniqueSurgery['Initial']['name'].$uniqueSurgery['Surgeon']['doctor_name'],
					'doctor_education'=>$uniqueSurgery['Surgeon']['education'],
					'anaesthesist'=>$uniqueSurgery['AnaeInitial']['name'].$uniqueSurgery['Anaesthesist']['doctor_name'],
					'anaesthesist_education'=>$uniqueSurgery['Anaesthesist']['education'],
					'anaesthesist_cost'=>$uniqueSurgery['OptAppointment']['anaesthesia_cost'],
					'ot_charges'=>$uniqueSurgery['OptAppointment']['ot_charges'],
					'paid_amount'=>$uniqueSurgery['OptAppointment']['paid_amount'],
					'opt_id'=>$uniqueSurgery['OptAppointment']['id'],
					'discount'=>$uniqueSurgery['OptAppointment']['discount'],
					'billing_id'=> $uniqueSurgery['OptAppointment']['billing_id'],
					/** gaurav */
					'surgeon_cost'=>$uniqueSurgery['OptAppointment']['surgeon_amt'],
					'asst_surgeon_one'=>($uniqueSurgery['AssistantOne']['doctor_name']) ? $uniqueSurgery['AssistantOneInitial']['name'].$uniqueSurgery['AssistantOne']['doctor_name'].','.$uniqueSurgery['AssistantOne']['education'] : '',
					'asst_surgeon_one_charge'=>$uniqueSurgery['OptAppointment']['asst_surgeon_one_charge'],
					'asst_surgeon_two'=>($uniqueSurgery['AssistantTwo']['doctor_name']) ? $uniqueSurgery['AssistantTwoInitial']['name'].$uniqueSurgery['AssistantTwo']['doctor_name'].','.$uniqueSurgery['AssistantTwo']['education'] : '',
					'asst_surgeon_two_charge' => $uniqueSurgery['OptAppointment']['asst_surgeon_two_charge'],
					'cardiologist' => ($uniqueSurgery['Cardiologist']['doctor_name']) ? $uniqueSurgery['CardioInitial']['name'].$uniqueSurgery['Cardiologist']['doctor_name'].','.$uniqueSurgery['Cardiologist']['education'] : '',
					'cardiologist_charge' => $uniqueSurgery['OptAppointment']['cardiologist_charge'],
					'ot_assistant' => $uniqueSurgery['OptAppointment']['ot_asst_charge'],
					'extra_hour_charge' => $this->getExtraTimeOtCharge($otInDate,$otOutDate,$optType),
					'operationType' => $optType,
					'ot_extra_services' => $otChargedServices,
					'procedure_complete' => $uniqueSurgery['OptAppointment']['procedure_complete'],
					/**  EOF gaurav*/
			);
				
		}
		return $surgeries;
		
	}
	
	//for accounting partial payment by amit jain
	function addPartialPaymentJV($requestPartialData=array(),$patientId=null){
		$session = new CakeSession();
		$accountObj=ClassRegistry::init('Account');
		$voucherEntryObj=ClassRegistry::init('VoucherEntry');
		$patientObj=ClassRegistry::init('Patient');
		$accountReceiptObj=ClassRegistry::init('AccountReceipt');
		$voucherPaymentObj=ClassRegistry::init('VoucherPayment');
		$voucherLogObj=ClassRegistry::init('VoucherLog');
		$doctorProfileObj=ClassRegistry::init('DoctorProfile');

		//voucher enrty id for account_receipt of journal_entry_id by amit jain
		$cashId = $accountObj->getAccountIdOnly(Configure::read('cash'));//for cash id
		$getPatientDetails=$patientObj->find('first',array('conditions'=>array('Patient.id'=>$patientId),
				'fields'=>array('person_id','lookup_name','form_received_on','admission_id','doctor_id','admission_type','is_staff_register','is_paragon')));//for person id
               if($getPatientDetails['Patient']['is_paragon'] != '1'){ // if temporary registration then restrict entries -Atul Chandankhede
		$personId = $getPatientDetails['Patient']['person_id'];

		if($getPatientDetails['Patient']['is_staff_register'] == '1'){
			$accountDetails = $accountObj->find('first',array('conditions'=>array('Account.user_type'=>'User',
											'Account.name'=>trim($getPatientDetails['Patient']['lookup_name']),
											'Account.location_id'=>$session->read('locationid')),
											'fields'=>array('Account.id','Account.name')));
		}else{
			$accountDetails = $accountObj->getAccountID($personId,'Patient');//for account id
		}
		
		$accountId = $accountDetails['Account']['id'];
			
		$doctorDetailsAll = $doctorProfileObj->find('first',array('fields'=>array('DoctorProfile.doctor_name','DoctorProfile.user_id'),
				'conditions'=>array('DoctorProfile.is_deleted'=>'0','DoctorProfile.user_id'=>$getPatientDetails['Patient']['doctor_id'],
						'DoctorProfile.location_id'=>$session->read('locationid'))));
		$doctorName = $doctorDetailsAll['DoctorProfile']['doctor_name'];
		$website=$session->read('website.instance');
		
		$lastBillingId = $this->getLastInsertID();
		$patientName = $getPatientDetails['Patient']['lookup_name'];
		$admissionId = $getPatientDetails['Patient']['admission_id'];
		$narration = $requestPartialData['Billing']['remark'];
		
		// for refund
		if($requestPartialData['Billing']['refund'] == 1){
			if($requestPartialData['Billing']['mode_of_payment'] == 'Cash'){
				$voucherLogDataPay=$pvData = array('date'=>$requestPartialData['Billing']['date'],
						'modified_by'=>$session->read('userid'),
						'create_by'=>$session->read('userid'),
						'patient_id'=>$requestPartialData['Billing']['patient_id'],
						'account_id'=>$cashId,
						'user_id'=>$accountId,
						'type'=>'Refund',
						'narration'=>$narration,
						'paid_amount'=>$requestPartialData['Billing']['paid_to_patient']);
				if(!empty($pvData['paid_amount']) && ($pvData['paid_amount'] != 0)){
					$lastVoucherIdPayment=$voucherPaymentObj->insertPaymentEntry($pvData);
					// ***insert into Account (By) credit manage current balance
					$accountObj->setBalanceAmountByAccountId($cashId,$requestPartialData['Billing']['paid_to_patient'],'debit');
					$accountObj->setBalanceAmountByUserId($accountId,$requestPartialData['Billing']['paid_to_patient'],'credit');
				}
			}else if($requestPartialData['Billing']['mode_of_payment']=='Bank Deposit' || $requestPartialData['Billing']['mode_of_payment']=='Cheque' || $requestPartialData['Billing']['mode_of_payment']=='Credit Card' || $requestPartialData['Billing']['mode_of_payment']=='NEFT'){
				if($requestPartialData['Billing']['mode_of_payment']=='Bank Deposit'){
					$date = $requestPartialData['Billing']['date'];
					$bankId = $requestPartialData['Billing']['bank_deposite'];
				}else if($requestPartialData['Billing']['mode_of_payment']=='Cheque' || $requestPartialData['Billing']['mode_of_payment']=='Credit Card'){
					$date = $requestPartialData['Billing']['cheque_date'];
					$bankId = $requestPartialData['Billing']['bank_name'];
				}else if($requestPartialData['Billing']['mode_of_payment']=='NEFT'){
					$bankId = $requestPartialData['Billing']['bank_name_neft'];
					$date = $requestPartialData['Billing']['neft_date'];
				}
				$voucherLogDataPay=$pvData = array('date'=>$date,
						'modified_by'=>$session->read('userid'),
						'created_by'=>$session->read('userid'),
						'patient_id'=>$requestPartialData['Billing']['patient_id'],
						'account_id'=>$bankId,
						'user_id'=>$accountId,
						'type'=>'Refund',
						'narration'=>$narration,
						'paid_amount'=>$requestPartialData['Billing']['paid_to_patient']);
				if(!empty($pvData['paid_amount']) && ($pvData['paid_amount'] != 0)){
					$lastVoucherIdPayment=$voucherPaymentObj->insertPaymentEntry($pvData);
					// ***insert into Account (By) credit manage current balance
					$accountObj->setBalanceAmountByAccountId($bankId,$requestPartialData['Billing']['paid_to_patient'],'debit');
					$accountObj->setBalanceAmountByUserId($accountId,$requestPartialData['Billing']['paid_to_patient'],'credit');
				}
			}
			//insert into voucher_logs table added by PankajM
			$voucherLogDataPay['voucher_no']=$lastVoucherIdPayment;
			$voucherLogDataPay['voucher_id']=$lastVoucherIdPayment;
			$voucherLogDataPay['voucher_type']="Payment";
			$voucherLogObj->insertVoucherLog($voucherLogDataPay);
			$voucherLogObj->id= '';
			$voucherPaymentObj->id= '';
			//End
		}else{
			if($website=='hope'){
				//for patient card rv
				if($requestPartialData['Billing']['is_card'] == '1'){
					$narrationCard = "Being Card amount received against Pt $patientName ($admissionId) Receipt No.-$lastBillingId, $doctorName.";
					$pateintCardId = $accountObj->getAccountIdOnly(Configure::read('PatientCardLabel'));//for patient card id
					$voucherLogDataFinalpayment=$rvData = array('date'=>$requestPartialData['Billing']['date'],
							'billing_id'=>$lastBillingId,//$this->Billing->getLastInsertID(),
							'modified_by'=>$session->read('userid'),
							'create_by'=>$session->read('userid'),
							'patient_id'=>$patientId,
							'account_id'=>$pateintCardId,
							'user_id'=>$accountId,
							'type'=>'PartialPayment',
							'narration'=>$narrationCard,
							'paid_amount'=>$requestPartialData['Billing']['patient_card']);
					if(!empty($rvData['paid_amount']) && ($rvData['paid_amount'] != 0)){
						$lastVoucherIdRecFinal=$accountReceiptObj->insertReceiptEntry($rvData);
						//insert into voucher_logs table added by PankajM
						$voucherLogDataFinalpayment['voucher_no']=$lastVoucherIdRecFinal;
						$voucherLogDataFinalpayment['voucher_id']=$lastVoucherIdRecFinal;
						$voucherLogDataFinalpayment['voucher_type']="Receipt";
						$voucherLogObj->insertVoucherLog($voucherLogDataFinalpayment);
						$voucherLogObj->id= '';
						$accountReceiptObj->id= '';
						// ***insert into Account (By) credit manage current balance
						$accountObj->setBalanceAmountByAccountId($accountId,$requestPartialData['Billing']['patient_card'],'debit');
						$accountObj->setBalanceAmountByUserId($pateintCardId,$requestPartialData['Billing']['patient_card'],'credit');
					}
				}
			}
			
			if($requestPartialData['Billing']['mode_of_payment']=='Cash'){
				$amount = $requestPartialData['Billing']['amount'];
				if($requestPartialData['Billing']['is_card'] == '1'){
					$patientCardAmount = $requestPartialData['Billing']['patient_card'];
				}
				$cashAmount = abs($amount-$patientCardAmount);
				$voucherLogDataFinalpayment=$rvData = array('date'=>$requestPartialData['Billing']['date'],
						'billing_id'=>$lastBillingId,
						'modified_by'=>$session->read('userid'),
						'create_by'=>$session->read('userid'),
						'patient_id'=>$patientId,
						'account_id'=>$cashId,
						'user_id'=>$accountId,
						'type'=>'PartialPayment',
						'narration'=>$narration,
						'paid_amount'=>$cashAmount);
				if(!empty($rvData['paid_amount']) && ($rvData['paid_amount'] != 0)){
					$lastVoucherIdRecFinal=$accountReceiptObj->insertReceiptEntry($rvData);
					//insert into voucher_logs table added by PankajM
					$voucherLogDataFinalpayment['voucher_no']=$lastVoucherIdRecFinal;
					$voucherLogDataFinalpayment['voucher_id']=$lastVoucherIdRecFinal;
					$voucherLogDataFinalpayment['voucher_type']="Receipt";
					$voucherLogObj->insertVoucherLog($voucherLogDataFinalpayment);
					$voucherLogObj->id= '';
					$accountReceiptObj->id= '';
					// ***insert into Account (By) credit manage current balance
					$accountObj->setBalanceAmountByAccountId($accountId,$cashAmount,'debit');
					$accountObj->setBalanceAmountByUserId($cashId,$cashAmount,'credit');
				}
			}else if($requestPartialData['Billing']['mode_of_payment']=='Bank Deposit' || 
					$requestPartialData['Billing']['mode_of_payment']=='Cheque' || 
					$requestPartialData['Billing']['mode_of_payment']=='Credit Card' || 
					$requestPartialData['Billing']['mode_of_payment']=='NEFT' ||
					$requestPartialData['Billing']['mode_of_payment']=='Debit Card'){
				if($requestPartialData['Billing']['mode_of_payment']=='Bank Deposit'){
					$date = $requestPartialData['Billing']['date'];
					$bankId = $requestPartialData['Billing']['bank_deposite'];
				}else if($requestPartialData['Billing']['mode_of_payment']=='Cheque' ||
						 $requestPartialData['Billing']['mode_of_payment']=='Credit Card' || 
						 $requestPartialData['Billing']['mode_of_payment']=='Debit Card' ){
					$bankId = $requestPartialData['Billing']['bank_name'];
					$date = $requestPartialData['Billing']['cheque_date'];
				}else if($requestPartialData['Billing']['mode_of_payment']=='NEFT'){
					$bankId = $requestPartialData['Billing']['bank_name_neft'];
					$date = $requestPartialData['Billing']['neft_date'];
				}
				$amount = $requestPartialData['Billing']['amount'];
				if($requestPartialData['Billing']['is_card'] == '1'){
					$patientCardAmount = $requestPartialData['Billing']['patient_card'];
				}
				$cashAmount = abs($amount-$patientCardAmount);
				
				$voucherLogDataFinalpayment=$rvData = array('date'=>$date,
						'billing_id'=>$this->getLastInsertID(),
						'modified_by'=>$session->read('userid'),
						'create_by'=>$session->read('userid'),
						'patient_id'=>$requestPartialData['Billing']['patient_id'],
						'account_id'=>$bankId,
						'user_id'=>$accountId,
						'type'=>'PartialPayment',
						'narration'=>$narration,
						'paid_amount'=>$cashAmount);
				if(!empty($rvData['paid_amount']) && ($rvData['paid_amount'] != 0)){
					$lastVoucherIdRecFinal=$accountReceiptObj->insertReceiptEntry($rvData);
					//insert into voucher_logs table added by PankajM
					$voucherLogDataFinalpayment['voucher_no']=$lastVoucherIdRecFinal;
					$voucherLogDataFinalpayment['voucher_id']=$lastVoucherIdRecFinal;
					$voucherLogDataFinalpayment['voucher_type']="Receipt";
					$voucherLogObj->insertVoucherLog($voucherLogDataFinalpayment);
					$voucherLogObj->id= '';
					$accountReceiptObj->id= '';
					// ***insert into Account (By) credit manage current balance
					$accountObj->setBalanceAmountByAccountId($accountId,$cashAmount,'debit');
					$accountObj->setBalanceAmountByUserId($bankId,$cashAmount,'credit');
				}
			}
		}

		//for discount jv
		/* if(!empty($requestPartialData['Billing']['discount'])){
			$userId = $accountObj->getAccountIdOnly(Configure::read('DiscountAllowedLabel'));
			$voucherLogDataPay = $jvData = array('date'=>$requestPartialData['Billing']['date'],
					'modified_by'=>$session->read('userid'),
					'created_by'=>$session->read('userid'),
					'account_id'=>$userId,
					'user_id'=>$accountId,
					'patient_id'=>$patientId,
					'type'=>'Discount',
					'narration'=>$requestPartialData['Billing']['remark'],
					'debit_amount'=>$requestPartialData['Billing']['discount']);
			if(!empty($jvData['debit_amount']) && ($jvData['debit_amount'] != 0)){
				$lastVoucherIdPayment = $voucherEntryObj->insertJournalEntry($jvData);
				//insert into voucher_logs table added by PankajM
				$voucherLogDataPay['voucher_no']=$lastVoucherIdPayment;
				$voucherLogDataPay['voucher_id']=$lastVoucherIdPayment;
				$voucherLogDataPay['voucher_type']="Journal";
				$voucherLogObj->insertVoucherLog($voucherLogDataPay);
				$voucherLogObj->id= '';
				$voucherEntryObj->id= '';
				// ***insert into Account (By) credit manage current balance
				$accountObj->setBalanceAmountByAccountId($accountId,$requestPartialData['Billing']['discount'],'debit');
				$accountObj->setBalanceAmountByUserId($userId,$requestPartialData['Billing']['discount'],'credit');
			}
		} */
               }
		
	} 
	//for accounting voucher Log final entry by amit jain
	function addFinalVoucherLogJV($requestPartialData=array(),$patientId=null){
		$session = new CakeSession();
		$voucherEntryObj=ClassRegistry::init('VoucherEntry');
		$voucherLogObj = ClassRegistry::init('VoucherLog');
		$accountObj = ClassRegistry::init('Account');
		$patientObj = ClassRegistry::init('Patient');
		
		$voucherEntryData = $voucherEntryObj->find('all',array('fields'=>array('SUM(VoucherEntry.debit_amount) as TotalAmount'),
				'conditions'=>array('VoucherEntry.patient_id'=>$patientId,'VoucherEntry.type'=>array('Laboratory','Radiology','ServiceBill',
						'Consultant','SurgeryChargesHospital','AnaesthesiaChargesHospital','OTChargesHospital','PharmacyCharges','DoctorCharges','NursingCharges','RoomCharges'),
						'VoucherEntry.is_deleted'=>'0')));
		
		$amount = $voucherEntryData['0']['0']['TotalAmount'];
		
		$cashId = $accountObj->getAccountIdOnly(Configure::read('cash'));//for cash id
		$getPatientDetails = $patientObj->getPatientAllDetails($patientId);
		$personId = $getPatientDetails['Patient']['person_id'];
		if($getPatientDetails['Patient']['is_paragon'] != '1'){ // if temporary registration then restrict entries -Atul Chandankhede
		if($getPatientDetails['Patient']['is_staff_register'] == '1'){
			$accountDetails = $accountObj->find('first',array('conditions'=>array('Account.user_type'=>'User',
											'Account.name'=>trim($getPatientDetails['Patient']['lookup_name']),
											'Account.location_id'=>$session->read('locationid')),
											'fields'=>array('Account.id','Account.name')));
		}else{
			$accountDetails = $accountObj->getAccountID($personId,'Patient');//for account id
		}
		$accountId = $accountDetails['Account']['id'];
		
		if($session->read('userid') == '1'){
			$createDate = $requestPartialData['Billing']['date'];
		}else{
			$createDate = date('Y-m-d H:i:s');
		}
		//for journal entry in voucher log bye amit
		$voucherLogDataFinalpayment = array(
				'date'=>$createDate,
				'create_time'=>$createDate,
				'billing_id'=>$this->getLastInsertID(),
				'modified_by'=>$session->read('userid'),
				'created_by'=>$session->read('userid'),
				'patient_id'=>$patientId,
				'account_id'=>$cashId,
				'user_id'=>$accountId,
				'type'=>'FinalDischarge',
				'narration'=>$requestPartialData['Billing']['remark'],
				'debit_amount'=>$amount);
		$voucherLogDataFinalpayment['voucher_no']=$getPatientDetails['Patient']['admission_id'];
		$voucherLogDataFinalpayment['voucher_type']="Journal";
		$voucherLogObj->insertVoucherLog($voucherLogDataFinalpayment);
		$voucherLogObj->id ='';
		
		//for discount jv
		$totalDiscount = $this->find('first',array('fields'=>array('SUM(Billing.discount) as totalDiscount'),
				'conditions'=>array('Billing.patient_id'=>$patientId,'Billing.is_deleted'=>'0','Billing.location_id'=>$session->read('locationid'))));
		$discount = $totalDiscount['0']['totalDiscount'];
		
			if(!empty($discount)){
				$voucherLogData = array();
				$userId = $accountObj->getAccountIdOnly(Configure::read('DiscountAllowedLabel'));
				$voucherLogData = $jvData = array(
						'date'=>$requestPartialData['Billing']['date'],
						'created_by'=>$session->read('userid'),
						'account_id'=>$userId,
						'user_id'=>$accountId,
						'patient_id'=>$patientId,
						'type'=>'Discount',
						'narration'=>$requestPartialData['Billing']['remark'],
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
					$accountObj->setBalanceAmountByAccountId($accountId,$discount,'debit');
					$accountObj->setBalanceAmountByUserId($userId,$discount,'credit');
				}
			}
                   }
		}
		
		//after revoke nursing, doctor and room charges deleted by amit
		function deleteRevokeJV($patientId){
			$session = new CakeSession();
			$voucherEntryObj=ClassRegistry::init('VoucherEntry');
			$voucherLogObj = ClassRegistry::init('VoucherLog');
			$voucherReferenceObj = ClassRegistry::init('VoucherReference');
			$patientObj = ClassRegistry::init('Patient');
			
			if(!empty($patientId)){
				$this->updateRevokeJvAmount($patientId);
			}
			$DischargeJV = $voucherEntryObj->find('all',array('fields'=>array('VoucherEntry.id'),
					'conditions'=>array('VoucherEntry.patient_id'=>$patientId,'VoucherEntry.type !='=>'Tds','VoucherEntry.is_deleted'=>'0')));
			foreach($DischargeJV as $dataJV){
				$voucherEntryObj->updateAll(array('VoucherEntry.is_deleted'=>'1'),array('VoucherEntry.id'=>$dataJV['VoucherEntry']['id']));
				$voucherEntryObj->id='';
			}

			$refferenceV = $voucherReferenceObj->find('first',array('fields'=>array('VoucherReference.id'),
					'conditions'=>array('VoucherReference.patient_id'=>$patientId)));
			$voucherReferenceObj->delete($refferenceV['VoucherReference']['id']);
		
			$finalVoucherLog = $voucherLogObj->find('all',array('fields'=>array('id'),
					'conditions'=>array('VoucherLog.patient_id'=>$patientId,'VoucherLog.type'=>array('FinalDischarge','Discount'),
							'VoucherLog.location_id'=>$session->read('locationid'),'VoucherLog.is_deleted'=>'0')));
			foreach($finalVoucherLog as $finalVoucher){
				$voucherLogObj->updateAll(array('VoucherLog.is_deleted'=>'1'),array('VoucherLog.id'=>$finalVoucher['VoucherLog']['id']));
				$voucherLogObj->id='';
			}
		}
		
		
		/**
		 * To save data in billing and accounting called from quick reg
		 * vadodara
		 * Pooja Gupta
		 * 
		 */
		
		function saveRegBill($data){
			$session = new CakeSession();
			$serviceCategoryObj=ClassRegistry::init('ServiceCategory');
			$serviceBillObj = ClassRegistry::init('ServiceBill');
			$billingObj = ClassRegistry::init('Billing');
			$serviceCategory=$serviceCategoryObj->getServiceGroupId(Configure::read('mandatoryservices'));
			$last_service_id = $serviceBillObj->find('list',array('fields'=>array('id'),'conditions'=>array('service_id'=>$serviceCategory,'patient_id'=>$data['Patient']['patient_id'],'paid_amount !='=>'0')));
			$tariff[Configure::read('mandatoryservices')]=$last_service_id;//$this->request->data['Patient']['treatment_type'];
			$tariffId=serialize($tariff);
			$date=date('Y-m-d H:i:s');				
				debug($data);
			$billingObj->save(array(
					'patient_id'=>$data['Patient']['patient_id'],
					'location_id'=>$data['Patient']['location_id'],
					'amount'=>$data['Patient']['total'],
					'payment_category'=>$serviceCategory,
					'date'=>$date,
					'tariff_list_id'=>$tariffId,
					'mode_of_payment'=>'Cash',
					'total_amount'=>$data['Patient']['total'],
					'amount_pending'=>'0',
					'amount_paid'=>'0',
					'created_by'=>$session->read('userid'),
					));
				
			$billId=$billingObj->getlastInsertID();
			$serviceBId=$serviceBillObj->find('list',array('fields'=>array('id'),'conditions'=>array('service_id'=>$serviceCategory,'patient_id'=>$data['Patient']['patient_id'],'paid_amount !='=>'0')));
			$serviceBillObj->updateAll(array('billing_id'=>"'".$billId."'"),array('id'=>$serviceBId));
			//for accounting Billing Array by amit jain
			$billArray['Billing']['mode_of_payment']='Cash';
			$billArray['Billing']['date']=$date;
			$billArray['Billing']['amount']=$data['Patient']['total'];
			$patientId=$data['Patient']['patient_id'];
			$billingObj->addPartialPaymentJV($billArray,$patientId);
			return $billId ;
			
		}

		
		public function autoGeneratedReceiptID($admissionType=null){

		$session = new cakeSession();
		
			$configuration=Classregistry::init('Configuration');
			$patient=Classregistry::init('Patient');
			$prefix = $configuration->find('first',array('conditions'=>array('name'=>'Prefix')));
			$previousData = unserialize($prefix['Configuration']['value']);
			$inArray = array_key_exists('u_id',$previousData);
			if($inArray){
				$prefix = $previousData['u_id'];  // for reference go to configuration controller in index (); ***gulshan
			}
			//Count of Patient table ID --pooja
			//$count = $this->find('count');
			$this->bindModel(array(
 								'belongsTo' => array( 
    									'Patient'=>array('foreignKey'=>false,'conditions'=>array('Billing.patient_id = Patient.id'))
    								)));
															
			$count = $this->find('count',array('conditions'=>array('Billing.create_time > '=>'2015-03-31 23:59:59','Billing.location_id'=>$session->read('locationid'),'Patient.admission_type'=>$admissionType)));
			
			$count++;
			if($count==0){
			 $count = "00001" ;
			}else if($count < 10 ){
			$count = "0000$count"  ;
			}else if($count >= 10 && $count <100){
			$count = "000$count"  ;
			}
			else if($count >= 100 && $count <1000){
			$count = "00$count"  ;
			}
			else if($count >= 1000 && $count <10000){
			$count = "0$count"  ;
			}
			else if($count >= 10000){
			$count = $count  ;
			}
			
			$month_array = array('A','B','C','D','E','F','G','H','I','J','K','L');
	
			$hospital = $session->read('facility');
	
			//by pankaj wanjari
			if($patient_info['Patient']['location_id'] != ''){
				$locationObj = Classregistry::init('Location');
				$locationData = $locationObj->getLocationDetails($patient_info['Patient']['location_id']);
				$location = $locationData['Location']['name'];
			}else{
				$location = $session->read('location');
			}
	
			//creating patient ID
			$splitLoaction=explode(' ',$location);
			if(!empty($splitLoaction['1'])){
				$loc1=strtoupper(substr($splitLoaction['0'],0,1));
				$loc2=strtoupper(substr($splitLoaction['1'],0,1));
				$loc=$loc1.$loc2;
			}else $loc=strtoupper(substr($location,0,2));
					
			
			$unique_id  .= ucfirst(substr($admissionType,0,1));			
			$unique_id  .= '-';
			$unique_id  .= $count;

			 $this->bindModel(array(
 								'belongsTo' => array( 
    									'Patient'=>array('foreignKey'=>false,'conditions'=>array('Billing.patient_id = Patient.id'))
    								)));
			$countuniqueid = $this->find('count',array('conditions'=>array('Billing.create_time > '=>'2015-03-31 23:59:59','Billing.location_id'=>$session->read('locationid'),'Billing.receiptNo'=>strtoupper($unique_id))));
		    if($countuniqueid>0)
			{
			   $unique_id1  .= ucfirst(substr($admissionType,0,1));			
			   $unique_id1  .= '-';
			   $unique_id1  .= $count+1;
			   return strtoupper($unique_id1) ;
			}
			else
			{
		       return strtoupper($unique_id) ;
			}
	}

		
		//return total amount of OPD patient for NON closed patient.
		function getPatientTotalBill($patient_id=null,$type = null){			
			if(!$patient_id) return ;
			$session = new CakeSession();
			//lab charge
			$patient=ClassRegistry::init('Patient'); 
			$tariffStandard=ClassRegistry::init('TariffStandard'); 
			$laboratoryTestOrderObj=ClassRegistry::init('LaboratoryTestOrder'); 
			$radiologyTestOrderTestOrderObj=ClassRegistry::init('RadiologyTestOrder');
			$consultantBillingObj=ClassRegistry::init('ConsultantBilling');
			$serviceBillObj=ClassRegistry::init('ServiceBill');
			$pharmacySaleObj=ClassRegistry::init('PharmacySalesBill');
			$duplicatePharmacySaleObj=ClassRegistry::init('PharmacyDuplicateSalesBill');
			$wardPatientServiceObj=ClassRegistry::init('WardPatientService');
                        $pharmacyReturnObj=ClassRegistry::init('InventoryPharmacySalesReturn');
			
			$patientDetails = $patient->getPatientAllDetails($id);
			$laboratoryData= $laboratoryTestOrderObj->find('first',array(
					'fields'=> array('SUM(LaboratoryTestOrder.amount) as labTotal'),
					'conditions'=>array('LaboratoryTestOrder.patient_id'=>$patient_id,'LaboratoryTestOrder.is_deleted'=>0)));
		
			$radiologyData= $radiologyTestOrderTestOrderObj->find('first',array(
					'fields'=> array('SUM(RadiologyTestOrder.amount) as radTotal'),
					'conditions'=>array('RadiologyTestOrder.patient_id'=>$patient_id,'RadiologyTestOrder.is_deleted'=>0)));
			
			$consultantBillingData= $consultantBillingObj->find('first',array(
					'fields'=> array('SUM(ConsultantBilling.amount) as consultantTotal'),
					'conditions'=>array('ConsultantBilling.patient_id'=>$patient_id/*,'ConsultantBilling.is_deleted'=>0*/)));
		
			$serviceBillData= $serviceBillObj->find('first',array(
					'fields'=> array('SUM(ServiceBill.amount*ServiceBill.no_of_times) as serviceTotal'),
					'conditions'=>array('ServiceBill.patient_id'=>$patient_id,'ServiceBill.is_deleted'=>0)));
			
                        $useDuplicateSales = $patient->getFlagUseDuplicateSalesCharge($patient_id);    
                        if($useDuplicateSales=='1'){
                            $pharmacySaleData= $duplicatePharmacySaleObj->getPharmacyTotal($patient_id);//for total pharmacy charge
                            $pharmacySaleData[0]['pharmacyTotal'] = $pharmacySaleData[0]['total'];
                        }else{
                            $pharmacySaleData= $pharmacySaleObj->find('first',array(
					'fields'=> array('SUM(PharmacySalesBill.total) as pharmacyTotal'),
					'conditions'=>array('PharmacySalesBill.patient_id'=>$patient_id,'PharmacySalesBill.is_deleted'=>0))); 
                        
                        
                        //to get pharmacy return amount by Swapnil - 5.11.2015
                        $pharmacyReturnData= $pharmacyReturnObj->find('first',array(
					'fields'=> array('SUM(InventoryPharmacySalesReturn.total) as returnTotal'),
					'conditions'=>array('InventoryPharmacySalesReturn.patient_id'=>$patient_id,'InventoryPharmacySalesReturn.is_deleted'=>0))); 
                        }
                        
			if($type == 'IPD'){
                            $wardPatientServiceData= $wardPatientServiceObj->find('first',array(
                                            'fields'=> array('SUM(WardPatientService.amount) as wardPatientTotal'),
                                            'conditions'=>array('WardPatientService.patient_id'=>$patient_id,'WardPatientService.is_deleted'=>0)));

                            /* by Swapnil to include nursing charges */
                            $hospitalType = $session->read('hospitaltype');
                            $wardCharges = $wardPatientServiceObj->getWardCharges($patient_id); 
                            $totalWardDays=count($wardCharges['day']); //total no of days
                            $tariffStandardId = $tariffStandard->getTariffIDByPatientId($patient_id);
                            $this->set('totalWardDays',$totalWardDays); 
                            $nursingCharges = $this->getNursingCharges($totalWardDays,$hospitalType,$tariffStandardId);  
							$doctorCharges = $this->getDoctorCharges($totalWardDays,$hospitalType,$tariffStandardId,$type, $patientDetails['Patient']['treatment_type']);
			}
			
                        
                        /*
                        * doctor and nursing charges for mandatory services
                       */
                       if($tariffStdData['Patient']['admission_type']=='IPD'){
                               

                               //for discount and paidAmount of roomTariff
                       } 
			/*$patientTotal = ((int)$laboratoryData[0]['labTotal']+(int)$radiologyData[0]['radTotal']+(int)$consultantBillingData[0]['consultantTotal']+
								(int)$serviceBillData[0]['serviceTotal']+(int)$pharmacySaleData[0]['pharmacyTotal']+(int)$wardPatientServiceData[0]['wardPatientTotal'])-(int)$pharmacyReturnData[0]['returnTotal'];*/

                        /*echo "<br/>".((int)$laboratoryData[0]['labTotal']."+".(int)$radiologyData[0]['radTotal']."+".(int)$consultantBillingData[0]['consultantTotal']."+".
								(int)$serviceBillData[0]['serviceTotal']."+".(int)$pharmacySaleData[0]['pharmacyTotal']."+".(int)$wardPatientServiceData[0]['wardPatientTotal'])."-".(int)$pharmacyReturnData[0]['returnTotal']; 
                        */
                        //by Swapnil to get the surgery charges
                        $newSurgeryChargesArray = $this->getSurgeryCharges($patient_id); 
                        $surgeryCharges = '0';
                        foreach($newSurgeryChargesArray as $key => $val){
                            $surgeryCharges += $val['cost']+$val['anaesthesist_cost']+$val['ot_charges']+
	        								$val['surgeon_cost']+$val['asst_surgeon_one_charge']+$val['asst_surgeon_two_charge']+
	        								$val['cardiologist_charge']+$val['extra_hour_charge']+$val['ot_extra_services'];
                        } 

                        $PatientCovidPackageModel = ClassRegistry::init('PatientCovidPackage');
                        $covidPackageBill = $PatientCovidPackageModel->getTotalCovidPackageBill($patient_id);

               if(!empty($covidPackageBill)){
               	$patientTotal = ((float)$laboratoryData[0]['labTotal'] + (float)$radiologyData[0]['radTotal'] + (float)$consultantBillingData[0]['consultantTotal'] + (float)$serviceBillData[0]['serviceTotal'] + (float)$pharmacySaleData[0]['pharmacyTotal']  + (float)$covidPackageBill[$patient_id]['total_package_bill'] + (float)$covidPackageBill[$patient_id]['total_ppe_bill'] + (float)$covidPackageBill[$patient_id]['total_visit_bill']) - (float)$pharmacyReturnData[0]['returnTotal'];
               }else{
               		$patientTotal = ((float)$laboratoryData[0]['labTotal'] + (float)$radiologyData[0]['radTotal'] + (float)$consultantBillingData[0]['consultantTotal'] + $surgeryCharges + $nursingCharges + $doctorCharges +
					(float)$serviceBillData[0]['serviceTotal'] + (float)$pharmacySaleData[0]['pharmacyTotal'] + (float)$wardPatientServiceData[0]['wardPatientTotal'] + (float)$covidPackageBill[$patient_id]['total_package_bill'] + (float)$covidPackageBill[$patient_id]['total_ppe_bill'] + (float)$covidPackageBill[$patient_id]['total_visit_bill']) - (float)$pharmacyReturnData[0]['returnTotal'];
               }

			
					
			return round($patientTotal) ;
		}
		// by amit jain
		function getAgentDailyTransactionAmount($date){
			$voucherPaymentModel = ClassRegistry::init('VoucherPayment');
			$accountModel = ClassRegistry::init('Account');
			$contraEntryModel = ClassRegistry::init('ContraEntry');
			$currentDate = date('Y-m-d');
			$session     = new cakeSession();
			$userid 	 = $session->read('userid') ;
			$cashId = $accountModel->getAccountIdOnly(Configure::read('cash'));//for cash id

			$totalCollectDataConditions = array('DATE_FORMAT(VoucherPayment.date,"%Y-%m-%d")'=>$currentDate,'VoucherPayment.location_id'=>$session->read('locationid'),
					'VoucherPayment.is_deleted'=>'0','VoucherPayment.account_id'=>$cashId,'VoucherPayment.type'=>'CashierAgent','VoucherPayment.is_posted_cash'=>'0');
			
			$totalContraDataConditions = array('ContraEntry.date >=' =>$date,'ContraEntry.location_id'=>$session->read('locationid'),
					'ContraEntry.is_deleted'=>'0','ContraEntry.user_id'=>$cashId,'ContraEntry.created_by'=>$userid);
			
			$totalPaymentDataConditions = array('VoucherPayment.date >=' =>$date,'VoucherPayment.location_id'=>$session->read('locationid'),
					'VoucherPayment.is_deleted'=>'0','VoucherPayment.account_id'=>$cashId,'VoucherPayment.create_by'=>$userid,'VoucherPayment.type'=>'USER');
			
			$totalCollectData = $voucherPaymentModel->find('all',array('conditions' => $totalCollectDataConditions,
					'fields'=>array('SUM(paid_amount) as agentAmount')));
	
			$totalPaymentData = $voucherPaymentModel->find('all',array('conditions' => $totalPaymentDataConditions,
					'fields'=>array('SUM(paid_amount) as agentPaymentAmount','count(VoucherPayment.id) as noOfPaymentTransactions')));
			
			$totalContraData = $contraEntryModel->find('all',array('conditions' => $totalContraDataConditions,
					'fields'=>array('SUM(debit_amount) as agentContraAmount','count(ContraEntry.id) as noOfContraTransactions')));
			
			$totalAgentAmount = (int) $totalPaymentData['0']['0']['agentPaymentAmount'] + (int) $totalContraData['0']['0']['agentContraAmount'];
			$totalAgentTransaction = $totalPaymentData['0']['0']['noOfPaymentTransactions'] + $totalContraData['0']['0']['noOfContraTransactions'];
		
			return array($totalAgentTransaction,$totalCollectData['0']['0']['agentAmount'],$totalAgentAmount);
		}
		
		//after revoke all services charges updated by amit
		function updateRevokeJvAmount($patientId){
			$session = new CakeSession();
			$voucherEntryObj=ClassRegistry::init('VoucherEntry');
			$accountObj = ClassRegistry::init('Account');
				
			$jvDetails = $voucherEntryObj->find('all',array('fields'=>array('VoucherEntry.id','VoucherEntry.user_id','VoucherEntry.account_id','VoucherEntry.debit_amount'),
					'conditions'=>array('VoucherEntry.patient_id'=>$patientId,'VoucherEntry.type !='=>'Tds','VoucherEntry.is_deleted'=>'0')));
			foreach($jvDetails as $dataJV){
				$accountObj->setBalanceAmountByAccountId($dataJV['VoucherEntry']['account_id'],$dataJV['VoucherEntry']['debit_amount'],'debit');
				$accountObj->id='';
				$accountObj->setBalanceAmountByUserId($dataJV['VoucherEntry']['user_id'],$dataJV['VoucherEntry']['debit_amount'],'credit');
				$accountObj->id='';
			}
		}
		
		/**
		 * Function to calculate amount that is to be subtracted from paid amount 
		 * where billling id is not null
		 * @param unknown_type $patientId
		 * Pooja Gupta
		 */
		public function returnPaidAmount($patientId){
			$session = new CakeSession();
			$salesRetrunObj=ClassRegistry::init('InventoryPharmacySalesReturn');
			$otsalesRetrunObj=ClassRegistry::init('OtPharmacySalesReturn');
			
			$pharmacyreturnData['pharmacy'] = $salesRetrunObj->find('first',array('fields'=>array(
				'Sum(InventoryPharmacySalesReturn.total) as total','Sum(InventoryPharmacySalesReturn.discount) as total_discount'),
				'conditions'=>array('InventoryPharmacySalesReturn.patient_id'=>$patientId,'InventoryPharmacySalesReturn.billing_id NOT'=>NULL,'InventoryPharmacySalesReturn.is_deleted'=>'0',
				)));
			
			$pharmacyreturnData['pharmacy']['0']['total']=round($pharmacyreturnData['pharmacy']['0']['total'])-round($pharmacyreturnData['pharmacy']['0']['total_discount']);
			
			$pharmacyreturnData['otpharmacy'] = $otsalesRetrunObj->find('first',array('fields'=>array(
					'Sum(OtPharmacySalesReturn.total) as total','Sum(OtPharmacySalesReturn.discount) as total_discount'),
					'conditions'=>array('OtPharmacySalesReturn.patient_id'=>$patientId,
							'OtPharmacySalesReturn.billing_id NOT'=>NULL,'OtPharmacySalesReturn.is_deleted'=>'0',
					)));
			$pharmacyreturnData['otpharmacy']['0']['total']=round($pharmacyreturnData['otpharmacy']['0']['total'])-round($pharmacyreturnData['otpharmacy']['0']['total_discount']);
				
			return $pharmacyreturnData;
		}

		//for accounting voucher Log final entry by amit jain
		function addVoucherLogJV($patientId=null){
			$session = new CakeSession();
			$voucherEntry = ClassRegistry::init('VoucherEntry');
			$voucherLogObj = ClassRegistry::init('VoucherLog');
			$accountObj = ClassRegistry::init('Account');
			$patientObj = ClassRegistry::init('Patient');
			$configurationObj = ClassRegistry::init('Configuration');
			$serviceProviderObj = ClassRegistry::init('ServiceProvider');
			$doctorProfile = ClassRegistry::init('DoctorProfile');
			$optAppointment = ClassRegistry::init('OptAppointment');
			$voucherReferenceObj = ClassRegistry::init('VoucherReference');
			$tariffStandardObj = ClassRegistry::init('TariffStandard');
			
			$getPatientDetails=$patientObj->find('first',array('conditions'=>array('Patient.id'=>$patientId),
					'fields'=>array('person_id','admission_id','summary_invoice_discount','lookup_name','tariff_standard_id')));//for person id
			$personId = $getPatientDetails['Patient']['person_id'];
			
			$data = unserialize($getPatientDetails['Patient']['summary_invoice_discount']);
	
			$patientName = $getPatientDetails['Patient']['lookup_name'];
			$admissionId .= $getPatientDetails['Patient']['admission_id'];
			$admissionId .= _;
			$narrationRec = "Being Income for the $admissionId$patientName";
			$narrationExp = "Being Charges for the $admissionId$patientName";
			$narrationDisc = "Being Discount Allowed for the $admissionId$patientName";
			
			//BOF for final total amount entry
			if(!empty($data['finalTotal'])){
				$tariffName = $tariffStandardObj->getTariffStandardName($getPatientDetails['Patient']['tariff_standard_id']);
				$accountDetails = $accountObj->getAccountID($personId,'Patient');//for account id
				$accountId = $accountDetails['Account']['id'];
				$ipdReceiptsId = $accountObj->getAccountIdOnly(Configure::read('IpdReceipts'));//for ipd Receipts Id
				$jvData = array('date'=>date("Y-m-d H:i:s"),
						'created_by'=>$session->read('userid'),
						'account_id'=>$ipdReceiptsId,
						'user_id'=>$accountId,
						'type'=>'FinalEntry',
						'narration'=>$narrationRec,
						'debit_amount'=>$data['finalTotal']);
				$lastJvId = $voucherEntry->insertJournalEntry($jvData);
				$voucherEntry->id ='';
				// ***insert into Account (By) credit manage current balance
				$accountObj->setBalanceAmountByAccountId($ipdReceiptsId,$data['finalTotal'],'debit');
				$accountObj->setBalanceAmountByUserId($accountId,$data['finalTotal'],'credit');
				
			//for journal entry in voucher log by amit
				$voucherLogData = array('date'=>date("Y-m-d H:i:s"),
						'created_by'=>$session->read('userid'),
						'account_id'=>$ipdReceiptsId,
						'user_id'=>$accountId,
						'type'=>'FinalEntry',
						'narration'=>$narrationRec,
						'debit_amount'=>$data['finalTotal'],
						'is_summary'=>'1',
						'tariff_standard_name'=>$tariffName,
						'voucher_no'=>$getPatientDetails['Patient']['admission_id'],
						'voucher_id'=>$lastJvId,
						'voucher_type'=>"Journal");
				$voucherLogObj->insertVoucherLog($voucherLogData);
				$voucherLogObj->id ='';
			}
			//EOF final entry
			
			//BOF for lab entry
			if(!empty($data['Laboratory']['headsTotal'])){
				$labChargesDetails = $configurationObj->find('first',array('fields'=>array('Configuration.value'),
						'conditions'=>array('Configuration.name'=>'Laboratory-Commision','Configuration.location_id'=>$session->read('locationid'))));
				$allLabCharges = unserialize($labChargesDetails['Configuration']['value']);
				$comissionPerLab = '';
				foreach($allLabCharges as $configLabData){
					$date  =  DateFormatComponent::formatDate2STD($configLabData['from'],Configure::read('date_format'));
					if($date <= date('Y-m-d')){
						$comissionPerLab= $configLabData['external_charges'];
					}
				}	
				//insert into voucher_logs table added by PankajM
				$externalLabCharges = ($data['Laboratory']['headsTotal']*$comissionPerLab/100);
				if(!empty($externalLabCharges)){
					$providerId = $serviceProviderObj->find('first',array('fields'=>array('ServiceProvider.id'),
							'conditions'=>array('ServiceProvider.name'=>Configure::read('LabProviderLabel'),'ServiceProvider.location_id'=>$session->read('locationid'))));
					$serviceProviderId = $accountObj->getUserIdOnly($providerId['ServiceProvider']['id'],'ServiceProvider',Configure::read('LabProviderLabel'));//for userId
							
					$labAccountId = $accountObj->getAccountIdOnly(Configure::read('LaboratoryTestLabel'));	
					$jvData = array('date'=>date("Y-m-d H:i:s"),
							'created_by'=>$session->read('userid'),
							'account_id'=>$serviceProviderId,
							'user_id'=>$labAccountId,
							'type'=>'ExternalLab',
							'narration'=>$narrationExp,
							'debit_amount'=>$externalLabCharges);
						$lastJvId = $voucherEntry->insertJournalEntry($jvData);
						$voucherEntry->id ='';
						// ***insert into Account (By) credit manage current balance
						$accountObj->setBalanceAmountByAccountId($serviceProviderId,$externalLabCharges,'debit');
						$accountObj->setBalanceAmountByUserId($labAccountId,$externalLabCharges,'credit');
					
					$voucherLogDataJV = array('date'=>date("Y-m-d H:i:s"),
							'created_by'=>$session->read('userid'),
							'account_id'=>$serviceProviderId,
							'user_id'=>$labAccountId,
							'type'=>'ExternalLab',
							'narration'=>$narrationExp,
							'debit_amount'=>$externalLabCharges,
							'voucher_type'=>"Journal",
							'voucher_no'=>$lastJvId,
							'voucher_id'=>$lastJvId,
							'is_summary'=>'1');
						$voucherLogObj->insertVoucherLog($voucherLogDataJV);
						$voucherLogObj->id= '';
		
					$vrData = array('reference_type_id'=> '2',
							'voucher_id'=> $voucherEntry->getLastInsertID(),
							'voucher_type'=> 'journal',
							'location_id'=> $session->read('locationid'),
							'user_id'=> $labAccountId,
							'date' => date("Y-m-d H:i:s"),
							'amount'=>$externalLabCharges,
							'credit_period'=>'45',
							'payment_type'=>'Cr',
							'reference_no'=>$voucherEntry->getLastInsertID(),
							'parent_id' => '0');
						$voucherReferenceObj->save($vrData);
						$voucherReferenceObj->id='';
					}
				}
			//EOF for lab
			
			//BOF for rad entry
			if(!empty($data['Radiology']['headsTotal'])){
			$radChargesDetails = $configurationObj->find('first',array('fields'=>array('Configuration.value'),
					'conditions'=>array('Configuration.name'=>'Radiology-Commision','Configuration.location_id'=>$session->read('locationid'))));
			$allRadCharges = unserialize($radChargesDetails['Configuration']['value']);
			$comissionPerRad = '';
			foreach($allRadCharges as $configRadData){
				$date  =  DateFormatComponent::formatDate2STD($configRadData['from'],Configure::read('date_format'));
				if($date <= date('Y-m-d')){
					$comissionPerRad = $configRadData['external_charges'];
				}
			}
			//insert into voucher_logs table added by PankajM
			$externalRadCharges = ($data['Radiology']['headsTotal']*$comissionPerRad/100);
				if(!empty($externalRadCharges)){
					$providerId = $serviceProviderObj->find('first',array('fields'=>array('ServiceProvider.id'),
							'conditions'=>array('ServiceProvider.name'=>Configure::read('RadProviderLabel'),'ServiceProvider.location_id'=>$session->read('locationid'))));
					$serviceProviderId = $accountObj->getUserIdOnly($providerId['ServiceProvider']['id'],'ServiceProvider',Configure::read('RadProviderLabel'));//for userId
					$radAccountId = $accountObj->getAccountIdOnly(Configure::read('RadiologyTestLabel'));
					
					$jvData = array('date'=>date("Y-m-d H:i:s"),
							'created_by'=>$session->read('userid'),
							'account_id'=>$serviceProviderId,
							'user_id'=>$radAccountId,
							'type'=>'ExternalRad',
							'narration'=>$narrationExp,
							'debit_amount'=>$externalRadCharges);
						$lastJvId = $voucherEntry->insertJournalEntry($jvData);
						$voucherEntry->id ='';
						// ***insert into Account (By) credit manage current balance
						$accountObj->setBalanceAmountByAccountId($serviceProviderId,$externalRadCharges,'debit');
						$accountObj->setBalanceAmountByUserId($radAccountId,$externalRadCharges,'credit');
					
					$voucherLogDataJV = array('date'=>date("Y-m-d H:i:s"),
							'created_by'=>$session->read('userid'),
							'account_id'=>$serviceProviderId,
							'user_id'=>$radAccountId,
							'type'=>'ExternalRad',
							'narration'=>$narrationExp,
							'debit_amount'=>$externalRadCharges,
							'voucher_no'=>$lastJvId,
							'voucher_id'=>$lastJvId,
							'voucher_type'=>"Journal",
							'is_summary'=>'1');
						$voucherLogObj->insertVoucherLog($voucherLogDataJV);
						$voucherLogObj->id= '';
					
					$vrData = array('reference_type_id'=> '2',
							'voucher_id'=> $voucherEntry->getLastInsertID(),
							'voucher_type'=> 'journal',
							'location_id'=> $session->read('locationid'),
							'user_id'=> $radAccountId,
							'date' => date("Y-m-d H:i:s"),
							'amount'=>$externalRadCharges,
							'credit_period'=>'45',
							'payment_type'=>'Cr',
							'reference_no'=>$voucherEntry->getLastInsertID(),
							'parent_id' => '0');
						$voucherReferenceObj->save($vrData);
						$voucherReferenceObj->id='';
					}
				}
			//EOF for rad
			
			//BOF for pharmacy entry
			if(!empty($data['Medical Services']['headsTotal'])){
				
				$accountId = $accountObj->getAccountIdOnly(Configure::read('RomanPharmaLabel'));
				$userId = $accountObj->getAccountIdOnly(Configure::read('MedicineExpensesLabel'));
				
				$jvData = array('date'=>date("Y-m-d H:i:s"),
						'created_by'=>$session->read('userid'),
						'account_id'=>$accountId,
						'user_id'=>$userId,
						'type'=>'PharmacyCharges',
						'narration'=>$narrationExp,
						'debit_amount'=>$data['Medical Services']['headsTotal']);
				$lastJvId = $voucherEntry->insertJournalEntry($jvData);
				$voucherEntry->id ='';
				// ***insert into Account (By) credit manage current balance
				$accountObj->setBalanceAmountByAccountId($accountId,$data['Medical Services']['headsTotal'],'debit');
				$accountObj->setBalanceAmountByUserId($userId,$data['Medical Services']['headsTotal'],'credit');

				$voucherLogDataJV = array('date'=>date("Y-m-d H:i:s"),
						'created_by'=>$session->read('userid'),
						'account_id'=>$accountId,
						'user_id'=>$userId,
						'type'=>'PharmacyCharges',
						'narration'=>$narrationExp,
						'debit_amount'=>$data['Medical Services']['headsTotal'],
						'voucher_no'=>$lastJvId,
						'voucher_id'=>$lastJvId,
						'voucher_type'=>"Journal",
						'is_summary'=>'1');
				$voucherLogObj->insertVoucherLog($voucherLogDataJV);
				$voucherLogObj->id= '';
			}
			//EOF for pharmacy
			
			//BOF for discount entry
			$getTotalDiscount = $this->find('first',array('conditions'=>array('Billing.patient_id'=>$patientId ,'Billing.location_id'=>$session->read('locationid')),
				'fields'=>array('SUM(Billing.discount) as totalDiscount')));
			
			if(!empty($getTotalDiscount['0']['totalDiscount'])){
				$accountId = $accountObj->getAccountIdOnly(Configure::read('DiscountAllowedLabel'));
				$getPatientId = $accountObj->getAccountID($personId,'Patient');//for account id
				$userId = $getPatientId['Account']['id'];
				$voucherLogDataPay = $jvData = array('date'=>date("Y-m-d H:i:s"),
						'created_by'=>$session->read('userid'),
						'account_id'=>$accountId,
						'user_id'=>$userId,
						'patient_id'=>$patientId,
						'type'=>'Discount',
						'narration'=>$narrationDisc,
						'debit_amount'=>$getTotalDiscount['0']['totalDiscount']);
					$lastJvId = $voucherEntry->insertJournalEntry($jvData);
					//insert into voucher_logs table added by PankajM
					$voucherLogDataPay['voucher_no']=$getPatientDetails['Patient']['admission_id'];
					$voucherLogDataPay['voucher_id']=$lastJvId;
					$voucherLogDataPay['voucher_type']="Journal";
					$voucherLogDataPay['is_summary']='1';
					$voucherLogObj->insertVoucherLog($voucherLogDataPay);
					$voucherLogObj->id= '';
					$voucherEntry->id= '';
					// ***insert into Account (By) credit manage current balance
					$accountObj->setBalanceAmountByAccountId($accountId,$getTotalDiscount['0']['totalDiscount'],'debit');
					$accountObj->setBalanceAmountByUserId($userId,$getTotalDiscount['0']['totalDiscount'],'credit');
			}
			//EOF discount
			
			//BOF for consultant / surgeon entry
			$surgeryId = array();
			foreach($data['Surgery'] as $key=> $data){
				$surgeryId[] = $key;
			}
			$optDetails=$optAppointment->find('first',array('conditions'=>array('OptAppointment.patient_id'=>$patientId,'OptAppointment.surgery_id'=>$surgeryId,'OptAppointment.location_id'=>$session->read('locationid')),
					'fields'=>array('OptAppointment.surgeon_amt')));
			
			if(!empty($optDetails['OptAppointment']['surgeon_amt'])){
				$doctorDetailsAll = $doctorProfile->find('first',array('fields'=>array('DoctorProfile.user_id'),
						'conditions'=>array('DoctorProfile.is_deleted'=>'0','DoctorProfile.doctor_name'=>Configure::read('DrRkLabel'),
								'DoctorProfile.location_id'=>'22')));
				$accountId = $accountObj->getUserIdOnly($doctorDetailsAll['DoctorProfile']['user_id'],'User','Dr R.K. Singh');
				//insert into voucher_logs table added by PankajM
				$userId = $accountObj->getAccountIdOnly(Configure::read('SurgeonFeesLabel'));
				
				$jvData = array('date'=>date("Y-m-d H:i:s"),
						'created_by'=>$session->read('userid'),
						'account_id'=>$accountId,
						'user_id'=>$userId,
						'type'=>'ExternalConsultant',
						'narration'=>$narrationExp,
						'debit_amount'=>$optDetails['OptAppointment']['surgeon_amt']);
				$lastJvId = $voucherEntry->insertJournalEntry($jvData);
				$voucherEntry->id ='';
				// ***insert into Account (By) credit manage current balance
				$accountObj->setBalanceAmountByAccountId($accountId,$optDetails['OptAppointment']['surgeon_amt'],'debit');
				$accountObj->setBalanceAmountByUserId($userId,$optDetails['OptAppointment']['surgeon_amt'],'credit');
				
				$voucherLogDataJV = array('date'=>date("Y-m-d H:i:s"),
						'created_by'=>$session->read('userid'),
						'account_id'=>$accountId,
						'user_id'=>$userId,
						'type'=>'ExternalConsultant',
						'narration'=>$narrationExp,
						'debit_amount'=>$optDetails['OptAppointment']['surgeon_amt'],
						'voucher_no'=>$lastJvId,
						'voucher_id'=>$lastJvId,
						'voucher_type'=>"Journal",
						'is_summary'=>'1');
				$voucherLogObj->insertVoucherLog($voucherLogDataJV);
				$voucherLogObj->id= '';
			//EOF consultant
			}
		}
		
		/**
		 * Function to insert data in billings,Final Billing,Accounts and PatientCard (for vadodara instance)
		 * @param unknown_type $patientId
		 * @param unknown_type $personId
		 * @param unknown_type $amount
		 * @param unknown_type $discount
		 * @param unknown_type $refund
		 * @param unknown_type $totalBill
		 * @param unknown_type $advanceAmt
		 * @param unknown_type $accountId
		 * @param unknown_type $billNo
		 * @param unknown_type $data
		 * @return mixed (billing id)
		 */
		function saveBillingData($patientId=NULL,$personId=NULL,$amount=NULL,$discount=NULL,$refund=NULL,
				$totalBill=NULL,$advanceAmt=NULL,$accountId=NULL,$billNo=NULL,$data=NULL){
			$session = new cakeSession();
			$patientCardObj = ClassRegistry::init('PatientCard');
			$TariffStandard=ClassRegistry::init('TariffStandard');
			$accountObj = ClassRegistry::init('Account');
			$patientObj =ClassRegistry::init('Patient');
			$finalBillingObj=ClassRegistry::init('FinalBilling');
				
			$billingArray=array();$this->id='';
				
			$data['Billing']['discharge_date']=DateFormatComponent::formatDate2STD($data['Billing']['date'],Configure::read('date_format'));
			$billArrayData['Billing']['patient_id']=$patientId;
			$billArrayData['Billing']['location_id']=$session->read('locationid');
			$billArrayData['Billing']['date']=DateFormatComponent::formatDate2STD($data['Billing']['date'],Configure::read('date_format'));
			$billArrayData['Billing']['amount']=$amount;
			$billArrayData['Billing']['payment_category']='Finalbill';
			//$billArrayData['Billing']['tariff_list_id']=$srArray;
			$billArrayData['Billing']['mode_of_payment']=$data['Billing']['payment_mode'];
			$billArrayData['Billing']['total_amount']=$totalBill;
			$billArrayData['Billing']['amount_pending']='0';
			$billArrayData['Billing']['discount']=$discount;
			$billArrayData['Billing']['amount_paid']=$advanceAmt;
			$billArrayData['Billing']['created_by']=$session->read('userid');
			$billArrayData['Billing']['bill_number']=$billNo;
			$billArrayData['Billing']['remark']=$data['Billing']['remark'];
			$billArrayData['Billing']['guarantor']=$data['Billing']['guarantor'];
			$billArrayData['Billing']['reason_of_discharge']=$data['Billing']['reason_of_discharge'];
			$billArrayData['Billing']['reason_of_balance']=$data['Billing']['reason_of_balance'];
			$billArrayData['Billing']['discount_type']='Amount';
			$billArrayData['Billing']['discharge_date']=DateFormatComponent::formatDate2STD($data['Billing']['date'],Configure::read('date_format'));
			$billArrayData['Billing']['is_card']=$data['Billing']['is_card'];
			$billArrayData['Billing']['patient_card']=$data['Billing']['patient_card'];
				
			$this->save($billArrayData);
				
			$billId=$this->id;
			$billArrayData['Billing']['id']=$billId;
			$this->id='';
				
			$pvtTariffId=$TariffStandard->getPrivateTariffID() ;
			$patientType=$patientObj->find('first',array('fields'=>array('admission_type','tariff_standard_id'),
					'conditions'=>array('id'=>$patientId)));
				
			//for accounting by amit jain
			if($patientType['Patient']['admission_type']=='IPD'){
				/*if($this->params->query['singleBillPay']){
				 $this->Billing->deleteRevokeJV($patientId);
				}*/
				$this->receiptVoucherCreate($billArrayData,$patientId);
				$this->finalDischargeJV($patientId);
				$this->addFinalVoucherLogJV($billArrayData,$patientId);
			}else{
				$this->addPartialPaymentJV($billArrayData,$patientId);
			}
			//EOF for accounting
				
			$totalDiscount=$this->find('first',array('fields'=>array('Sum(Billing.discount) as discount'),
					'conditions'=>array('patient_id'=>$patientId),
					'group'=>array('Billing.patient_id')));
			if(!empty($totalDiscount)){
				$billArrayData['Billing']['discount']=$totalDiscount[0]['discount'];
			}
			$data = $finalBillingObj->find('first',array('fields'=>array('FinalBilling.id','FinalBilling.total_amount','FinalBilling.discount'),
					'conditions'=>array(/*'location_id'=>$this->Session->read('locationid'),*/'patient_id'=>$patientId)));
			if(!empty($data)){
				$finalBillingObj->id = $data['FinalBilling']['id'];
				$billArrayData['Billing']['total_amount']=$data['FinalBilling']['total_amount'];
				if(!$billArrayData['Billing']['total_amount']){
					$billArrayData['Billing']['total_amount']=$totalBill;
				}
				$billingArray['Billing']['amount_paid']=$amount+$data['FinalBilling']['amount_paid'];
				$billingArray['Billing']['discount']=$billingArray['Billing']['discount']+$data['FinalBilling']['discount'];
				$billingArray['Billing']['amount_pending']=$billArrayData['Billing']['total_amount']-$billingArray['Billing']['amount_paid']-$billingArray['Billing']['discount'];
				$billArrayData['Billing']['id']= $data['FinalBilling']['id'];
			}
			$finalBillingObj->save($billArrayData['Billing']);
			$finalBillingObj->id='';
				
			return $billId;
		}
		
		/*public function getDoctorCharges($days,$hospitalType,$tariffStandardId,$patientType='',$treatment_type=null){
		
			$session=new CakeSession();
			if($session->read('website.instance')=='vadodara') return ;
			$TariffAmountObj=ClassRegistry::init('TariffAmount');
			$TariffListObj=ClassRegistry::init('TariffList');
			
			$tariffListId=$TariffListObj->getServiceIdByName(Configure::read('DoctorsCharges'));//get tariff list id
			if($patientType=='OPD'){
				$doctorRateData = $TariffAmountObj->find('first',array('fields'=>array('TariffAmount.nabh_charges','TariffAmount.non_nabh_charges'),
						'conditions'=>array('TariffAmount.tariff_list_id'=>$treatment_type,
								'TariffAmount.tariff_standard_id'=>$tariffStandardId,'TariffAmount.location_id'=>$this->Session->read('locationid'))));
				$days=1;
		
			}else{
				$doctorRateData=$TariffAmountObj->find('first',array('conditions'=>array('tariff_list_id'=>$tariffListId,'tariff_standard_id'=>$tariffStandardId)));
			}
		
			if($hospitalType=='NABH'){
				$doctorRate=$doctorRateData['TariffAmount']['nabh_charges'];
			}else{
				$doctorRate=$doctorRateData['TariffAmount']['non_nabh_charges'];
			}
			$cost=$days*$doctorRate;
		
			return $cost;
		}
		
		public function getNursingCharges($days,$hospitalType,$tariffStandardId){
			$session=new CakeSession();
			if($session->read('website.instance')=='vadodara') return ;
			$TariffAmountObj=ClassRegistry::init('TariffAmount');
			$TariffListObj=ClassRegistry::init('TariffList');
			$tariffListId=$TariffListObj->getServiceIdByName(Configure::read('NursingCharges'));//get tariff list id
		
			$nursingRateData=$TariffAmountObj->find('first',array('conditions'=>array('tariff_list_id'=>$tariffListId,'tariff_standard_id'=>$tariffStandardId)));
				
			if($hospitalType=='NABH'){
				$nursingRate=$nursingRateData['TariffAmount']['nabh_charges'];
			}else{
				$nursingRate=$nursingRateData['TariffAmount']['non_nabh_charges'];
			}
			$cost=0;
				
			$cost=$cost + ($days*$nursingRate);
				
			return $cost;
		}*/
    
    //function to get the total paid by patient by Swapnil - 06.11.2015 
    function getPatientPaidAmount($patient_id=null){			
        if(!$patient_id) return ;
        $session = new CakeSession(); 

        $billing= $this->find('first',array(
                        'fields'=> array('SUM(Billing.amount) as totalPaid','SUM(Billing.paid_to_patient) as totalRefund'),
                        'conditions'=>array('Billing.patient_id'=>$patient_id,'Billing.is_deleted'=>0)));

        if(!empty($billing)){
            $result = ($billing[0]['totalPaid'] - $billing[0]['totalRefund']);
        } 
        return $result;
    }
    
    //function to get the total discount to patient by Swapnil - 09.11.2015 
    function getPatientDiscountAmount($patient_id=null){			
        if(!$patient_id) return ;
        $session = new CakeSession(); 

        $billing= $this->find('first',array(
                        'fields'=> array('SUM(Billing.discount) as discountAmount'),
                        'conditions'=>array('Billing.patient_id'=>$patient_id,'Billing.is_deleted'=>0)));
		if(!empty($billing)){
            $result = ($billing[0]['discountAmount']);
        } 
        return $result;
    }
    
     //by Swapnil to get the lab/rad test - 05.12.2015
    function completeLabRadTests($patient_id = null, $printInvestigation = null) {
        $laboratoryTestOrder = Classregistry::init('LaboratoryTestOrder');
        $radiologyTestOrder = Classregistry::init('RadiologyTestOrder');
        $labHL7Result = Classregistry::init('LaboratoryHl7Result');
        $radiologyResult = Classregistry::init('RadiologyResult');

        $laboratoryTestOrder->bindModel(array(
            'belongsTo' => array(
                'Laboratory' => array('foreignKey' => 'laboratory_id', 'type' => 'inner', 'conditions' => array('is_active' => 1)),
                //'LaboratoryResult' => array('foreignKey' => false, 'type' => 'inner', 'conditions' => array('LaboratoryResult.laboratory_test_order_id = LaboratoryTestOrder.id'))
                )), false);

        $radiologyTestOrder->bindModel(array(
            'belongsTo' => array(
                'Radiology' => array('foreignKey' => 'radiology_id', 'type' => 'inner', 'conditions' => array('is_active' => 1)),
                'RadiologyResult' => array('foreignKey' => false, 'type' => 'inner', 'conditions' => array('RadiologyResult.radiology_test_order_id = RadiologyTestOrder.id'))
                )), false);

        /*$labData = $laboratoryTestOrder->find('all', array('fields' => array('Laboratory.id', 'Laboratory.name','LaboratoryTestOrder.id' ),
            'conditions' => array('LaboratoryTestOrder.patient_id' => $patient_id), 'recursive' => 1,
            //'order'=>array('LaboratoryTestOrder.id'=>'DESC'),
            //'group'=>array('LaboratoryTestOrder.laboratory_id')
            ));  */
         
        if(!empty($printInvestigation) && $printInvestigation == '1'){
             $labData = $laboratoryTestOrder->find('all', array('fields' => array('Laboratory.id', 'Laboratory.name','LaboratoryTestOrder.id','LaboratoryTestOrder.start_date'),
                    'conditions' => array('LaboratoryTestOrder.patient_id' => $patient_id), 'recursive' => 1,
                    'order'=>array('LaboratoryTestOrder.id'=>'DESC'),
                    'group'=>array('LaboratoryTestOrder.laboratory_id')
            ));   
            foreach($labData as $lKey => $lVal){
                $retData[$lVal['Laboratory']['id']] = $lVal;
            } 
        }else{
            $retData = $laboratoryTestOrder->find('all', array('fields' => array('Laboratory.id', 'Laboratory.name','LaboratoryTestOrder.id','LaboratoryTestOrder.start_date'),
                'conditions' => array('LaboratoryTestOrder.patient_id' => $patient_id), 'recursive' => 1 
            ));  
        } 

        $labHL7Result->bindModel(array(
                'belongsTo'=>array(
                    'LaboratoryParameter'=>array(
                        'foreignKey'=>'laboratory_parameter_id',
                        'type'=>'inner'
                )
            )
        ),false);
 
        foreach ($retData as $rKey => $rVal){  
            $returnLabArray[$rKey]['name'] = $rVal['Laboratory']['name'];
            $returnLabArray[$rKey]['loboratory_id'] = $rVal['Laboratory']['id'];
            $returnLabArray[$rKey]['date'] = DateFormatComponent::formatDate2Local($rVal['LaboratoryTestOrder']['start_date'],Configure::read('date_format'),false);

            $result = $labHL7Result->find('all',array(
                'fields'=>array('LaboratoryHl7Result.result','LaboratoryParameter.name','LaboratoryParameter.unit_txt'),
                'conditions'=>array('LaboratoryHl7Result.laboratory_test_order_id' => $rVal['LaboratoryTestOrder']['id'],
                    'LaboratoryHl7Result.laboratory_id' => $rVal['Laboratory']['id']))); 
             
            $output = ''; 
            foreach($result as $key => $val){
                if($key>0){
                    $output .= ", ";
                }
                $output .= $val['LaboratoryParameter']['name'].":".$val['LaboratoryHl7Result']['result']." ".$val['LaboratoryParameter']['unit_txt'];
            }
            $returnLabArray[$rKey]['results'] = $output;
        } 
     
         
        $radData = $radiologyTestOrder->find('all', array('fields' => array('Radiology.id', 'Radiology.name','RadiologyTestOrder.id','RadiologyResult.note','RadiologyResult.img_impression'),
            'conditions' => array('RadiologyTestOrder.patient_id' => $patient_id), 'recursive' => 1));
        
        //to generate unique last lab tests
        foreach($radData as $radKey => $radVal){
            $returnRadArray[$radKey]['name'] = $radVal['Radiology']['name'];
            $returnRadArray[$radKey]['results'] = $radVal['RadiologyResult']['img_impression'];//$radVal['RadiologyResult']['note'];
           // $returnRadArray[$radKey]['img_impression'] = $radVal['RadiologyResult']['img_impression'];
            
            //$returnRadArray[$radVal['Radiology']['id']]['name'] = $radVal['Radiology']['name'];
            //$returnRadArray[$radVal['Radiology']['id']]['results'] = $radVal['RadiologyResult']['img_impression'];
        }  

        return array('Laboratory' => $returnLabArray, 'Radiology' => $returnRadArray);
    }
    public function discountCouponBillData($data,$serviceCategoryID,$patient_id,$orderID,$serviceCounter){
    	$ServiceCategory = ClassRegistry::init('ServiceCategory');
    	$Patient = ClassRegistry::init('Patient');
    	$Billing = ClassRegistry::init('Billing');
    	$serviceCategory = $ServiceCategory->find("list",array('fields'=>array('id','name'),
    			"conditions"=>array("ServiceCategory.id"=>$serviceCategoryID)));
    		
    	$Patient->bindModel(array(
    			'hasOne'=>array('Coupon'=>array('foreignKey'=>false,'conditions'=>array('Coupon.batch_name = Patient.coupon_name')),
    					'CouponTransaction'=>array('foreignKey'=>false,'conditions'=>array('CouponTransaction.patient_id = Patient.id')))
    	));
    		
    	$patientData = $Patient->find('first',array('fields'=>array('Patient.id','Patient.tariff_standard_id','Patient.is_discharge',
    			'Patient.coupon_name','Patient.treatment_type','Patient.admission_type','Patient.is_packaged','Patient.person_id','Patient.known_fam_physician',
    			'Coupon.id','Coupon.sevices_available','CouponTransaction.id','CouponTransaction.amount','CouponTransaction.remain_balance','Coupon.coupon_amount'),
    			'conditions'=>array('Patient.id'=>$patient_id),'order'=>'CouponTransaction.id DESC'));
    	$sevicesAvailable = explode(',',trim($patientData['Coupon']['sevices_available'],','));
    	
    	$serviceKey = array_flip(array_filter($sevicesAvailable));
    	$couponAmount = unserialize($patientData['Coupon']['coupon_amount']);
    	$discount = 0;
   		if($patientData['Patient']['coupon_name'] != '' and in_array($serviceCategoryID,$sevicesAvailable)){ //coupon Bill
    		$totalDisAmt=0;$amountPending=0;
    		if(($serviceCategory[$serviceCategoryID]==Configure::read('laboratoryservices'))||
    				($serviceCategory[$serviceCategoryID]==Configure::read('radiologyservices'))||
    				($serviceCategory[$serviceCategoryID]==Configure::read('surgeryservices')) ||
    				($serviceCategory[$serviceCategoryID]==Configure::read('Consultant')) ||
    				$serviceCategory[$serviceCategoryID]==Configure::read('Pharmacy') ||
    				$serviceCategory[$serviceCategoryID]==Configure::read('OtPharmacy') ||
    				$serviceCategory[$serviceCategoryID]==Configure::read('PharmacyReturn') ||
    				$serviceCategory[$serviceCategoryID]==Configure::read('OtPharmacyReturn')){
    				
    			if($serviceCategory[$serviceCategoryID]==Configure::read('laboratoryservices')){
    				$model='LaboratoryTestOrder';
    				$date = $data['start_date'][$serviceCounter];
    			}else if($serviceCategory[$serviceCategoryID]==Configure::read('radiologyservices')){
    				$model='RadiologyTestOrder';
    				$date = $data['radiology_order_date'][$serviceCounter];
    			}else if($serviceCategory[$serviceCategoryID]==Configure::read('surgeryservices')){
    				$model='OptAppointment';
    			}else if($serviceCategory[$serviceCategoryID]==Configure::read('Consultant')){
    				$model='ConsultantBilling';
    			}else if($serviceCategory[$serviceCategoryID]==Configure::read('Pharmacy') || $serviceCategory[$serviceCategoryID]==Configure::read('PharmacyReturn')){
    				$model='PharmacySalesBill';
    			}else if($serviceCategory[$serviceCategoryID]==Configure::read('OtPharmacy') || $serviceCategory[$serviceCategoryID]==Configure::read('OtPharmacyReturn')){
    				$model='OtPharmacySalesBill';
    			}
    
    			if($model=='LaboratoryTestOrder' and in_array($serviceCategoryID,$sevicesAvailable)){ 
    				
    				$billTariffId[$serviceCategory[$serviceCategoryID]]= $data['laboratory_id'][$serviceCounter];
    				if($couponAmount[$serviceCategoryID/*$serviceKey[$serviceCategoryID]*/]['type'] == 'Percentage'){
    					$discAmt = ($data['amount'][$serviceCounter] * ($couponAmount[$serviceCategoryID/*$serviceKey[$serviceCategoryID]*/]['value']))/100;
    				}else{
    					$discAmt = $couponAmount[$serviceCategoryID/*$serviceKey[$serviceCategoryID]*/]['value'];
    				}
    			} 
    			
    			if($model=='RadiologyTestOrder' and in_array($serviceCategoryID,$sevicesAvailable)){
    				$billTariffId[$serviceCategory[$serviceCategoryID]]= $data['radiology_id'][$serviceCounter];
    				if($couponAmount[$serviceCategoryID/*$serviceKey[$serviceCategoryID]*/]['type'] == 'Percentage'){
    					$discAmt = ($data['amount'][$serviceCounter]*($couponAmount[$serviceCategoryID/*$serviceKey[$serviceCategoryID]*/]['value']))/100;
    				}else{
    					$discAmt = $couponAmount[$serviceCategoryID/*$serviceKey[$serviceCategoryID]*/]['value'];
    				}
    			}
    			$servKeyArrayId=$serviceCategory[$serviceCategoryID];
    			$billTariffId[$servKeyArrayId]=$orderID;
    		}

    		$srArray=serialize($billTariffId);
    		$session     = new cakeSession();
    		$billArrayData['Billing']['id']= '';
    		$billArrayData['Billing']['patient_id']= $patient_id;
    		$billArrayData['Billing']['location_id']= $session->read('locationid'); 
    		
    		$billArrayData['Billing']['date']= DateFormatComponent::formatDate2STD($date,Configure::read('date_format'));
    		$billArrayData['Billing']['amount']='0';
    		$billArrayData['Billing']['payment_category']=$serviceCategoryID;
    		$billArrayData['Billing']['tariff_list_id']=$srArray;
    		$billArrayData['Billing']['mode_of_payment']='Cash';
    		$billArrayData['Billing']['total_amount']= $data['amount'][$serviceCounter];
    		$billArrayData['Billing']['amount_pending']='0';
    		$billArrayData['Billing']['discount']= $discAmt;
    		$billArrayData['Billing']['amount_paid']='0';
    		$billArrayData['Billing']['created_by']=$session->read('userid');
    		$billArrayData['Billing']['discount_type']= 'Amount';
    		$Billing->id = '';
    		$Billing->save($billArrayData['Billing']);
    		//for accounting
    		$Billing->addPartialPaymentJV($billArrayData,$patient_id);
    			
    		if(!empty($discAmt)){
    			$discount=round($discAmt);
    		}else{
    			$discount=0;
    		}
    	}	//coupon cond
    	return $discount;
    }
    
    /**
     * function return discount amt for services having predefined fixed discount in %
     * @param unknown_type $fixedDiscount
     * @param unknown_type $serviceAmt
     * return rounded discount amount
     * pooja
     */
    function getCalDiscount($fixedDiscount,$serviceAmt){
    	$disAmt=($fixedDiscount*$serviceAmt)/100;
    	return round($disAmt);
    }
    
    /**
     * Function to enter a negative discount on deleting discounted services
     * @param unknown_type $patientId
     * @param unknown_type $groupId
     * @param unknown_type $serviceDiscount
     */
    function discountDeleteEntry($patientId,$groupId,$serviceDiscount){
    	$session=new CakeSession();
    	if($serviceDiscount>0){
    		$this->save(array(
    				'patient_id'=>$patientId,
    				'date'=>date('Y-m-d H:i:s'),
    				'location_id'=>$session->read('locationid'),
    				'amount'=>'0',
    				'payment_category'=>$groupId,
    				'mode_of_payment'=>'Cash',
    				'discount'=>-($serviceDiscount),
    				'created_by'=>$session->read('userid'),
    				'create_time'=>date('Y-m-d H:i:s')
    		));
    		$this->Billing->id='';
    	}
    	return true;
    }
    
    function saveBillingDiscount($patient_id,$date,$groupId,$totalPayment,$totDis){
    	$session=new CakeSession();
    	$this->save(array(
    			'patient_id'=>$patient_id,
    			'date'=>$date,
    			'location_id'=>$session->read('locationid'),
    			'payment_category'=>$groupId,
    			'amount'=>'0',
    			'mode_of_payment'=>'Cash',
    			'total_amount'=>$totalPayment,
    			'amount_pending'=>$totalPayment-$totDis,
    			'discount'=>$totDis,
    			'created_by'=>$session->read('userid'),
    			'created_time'=>date('Y-m-d H:i:s')
    	));
    }
    
    /**
     * function to Add Mandatory Services like Nursing charges,Doctor Charges and Ward Charges
     * @param  array $patientId --> Patient Id;
     * @author  Amit Jain
     */
    function jvMandatoryService($patientId){
    	$session = new CakeSession();
    	$account=ClassRegistry::init('Account');
    	$voucherEntry=ClassRegistry::init('VoucherEntry');
    	$patient=ClassRegistry::init('Patient');
    	$tariffList=ClassRegistry::init('TariffList');
    	$ward=ClassRegistry::init('Ward');
    	$wardPatientServiceObj=ClassRegistry::init('WardPatientService');
    	
    	//voucher enrty id for account_receipt of journal_entry_id by amit jain
    	$cashId = $account->getAccountIdOnly(Configure::read('cash'));//for cash id
    	$getPatientDetails = $patient->getPatientAllDetails($patientId);
        if($getPatientDetails['Patient']['is_paragon'] != '1'){ // if temporary registration then restrict entries -Atul Chandankhede
    	$personId = $getPatientDetails['Patient']['person_id'];
    	if($getPatientDetails['Patient']['is_staff_register'] == '1'){
			$accountDetails = $account->find('first',array('conditions'=>array('Account.user_type'=>'User',
											'Account.name'=>trim($getPatientDetails['Patient']['lookup_name']),
											'Account.location_id'=>$session->read('locationid')),
											'fields'=>array('Account.id','Account.name')));
		}else{
			$accountDetails = $account->getAccountID($personId,'Patient');//for account id
		}

    	$accountId = $accountDetails['Account']['id'];
    	
    	$regDate  =  DateFormatComponent::formatDate2Local($getPatientDetails['Patient']['form_received_on'],Configure::read('date_format'),true);
    	$doneDate  =  DateFormatComponent::formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'),true);
    		
    	$tariffStandardId = $getPatientDetails['Patient']['tariff_standard_id'];
    	$hospitalType = $session->read('hospitaltype');
    		
    	$wardCharges = $wardPatientServiceObj->getWardCharges($patientId);
    		
    	$totalWardDays=count($wardCharges['day']); //total no of days
    		
    	$doctorCharges = $this->getDoctorCharges($totalWardDays,$hospitalType,$tariffStandardId,$getPatientDetails['Patient']['admission_type'], $getPatientDetails['Patient']['treatment_type']);
    	$nursingCharges = $this->getNursingCharges($totalWardDays,$hospitalType,$tariffStandardId);
    	$ward_days = $this->getWardWiseCharges($wardCharges) ;
    	
    	$patientName = $getPatientDetails['Patient']['lookup_name'];
    	$dateDischarge = $getPatientDetails['Patient']['discharge_date'] ? $getPatientDetails['Patient']['discharge_date'] : date('Y-m-d H:i:s');
    	if($getPatientDetails['Patient']['admission_type'] == 'IPD'){
    		if($tariffStandardId == Configure::read('privateTariffId')){
    			//for doctor charges, nursing charges and ward charges jv
    			if(!empty($doctorCharges) && ($doctorCharges !=0)){
    				$tariffDetails = $tariffList->getServiceDetails(Configure::read('DoctorChargesLabel'));
    				$account->id='';
    				$userId = $account->getUserIdOnly($tariffDetails['TariffList']['id'],'TariffList',$tariffDetails['TariffList']['name']);//doctor id
    				$tariffName = $tariffDetails['TariffList']['name'];
    					
    				$narration = "Being $tariffName charged to pt. $patientName (Date of Registration : $regDate) done on $doneDate";
    				$jvData = array('date'=>$dateDischarge,
    						'modified_by'=>$session->read('userid'),
    						'created_by'=>$session->read('userid'),
    						'account_id'=>$accountId,
    						'user_id'=>$userId,
    						'patient_id'=>$patientId,
    						'type'=>'DoctorCharges',
    						'narration'=>$narration,
    						'debit_amount'=>$doctorCharges);
    				$voucherEntry->insertJournalEntry($jvData);
    				$voucherEntry->id= '';
    				// ***insert into Account (By) credit manage current balance
    				$account->setBalanceAmountByAccountId($userId,$doctorCharges,'debit');
    				$account->setBalanceAmountByUserId($accountId,$doctorCharges,'credit');
    			}
    			if(!empty($nursingCharges) && ($nursingCharges != 0)){
    				$tariffDetails = $tariffList->getServiceDetails(Configure::read('NursingChargesLabel'));
    				$account->id='';
    				$userId = $account->getUserIdOnly($tariffDetails['TariffList']['id'],'TariffList',$tariffDetails['TariffList']['name']);//nursing id
    				$tariffName = $tariffDetails['TariffList']['name'];
    				$narration = "Being $tariffName charged to pt. $patientName (Date of Registration :$regDate) done on $doneDate";
    				$jvData = array('date'=>$dateDischarge,
    						'modified_by'=>$session->read('userid'),
    						'created_by'=>$session->read('userid'),
    						'account_id'=>$accountId,
    						'user_id'=>$userId,
    						'patient_id'=>$patientId,
    						'type'=>'NursingCharges',
    						'narration'=>$narration,
    						'debit_amount'=>$nursingCharges);
    				$voucherEntry->insertJournalEntry($jvData);
    				$voucherEntry->id= '';
    				// ***insert into Account (By) credit manage current balance
    				$account->setBalanceAmountByAccountId($userId,$nursingCharges,'debit');
    				$account->setBalanceAmountByUserId($accountId,$nursingCharges,'credit');
    			}
    		}
            }
    	
    	foreach($ward_days as $key => $value){
    		$ward->unBindModel(array(
    				'hasMany' => array('Room','ServicesWard')));
    		$roomDetalis = $ward->find('first',array('fields'=>array('Ward.name'),'conditions'=>array('Ward.id'=>$key)));
    		$roomName = $roomDetalis['Ward']['name'];
    		$userId = $account->getUserIdOnly($key,'Ward',$roomName);// for user id
    		$narration = "Being $roomName charged to pt. $patientName (Date of Registration :$regDate) done on $doneDate";
    		$jvData = array('date'=>$dateDischarge,
    				'modified_by'=>$session->read('userid'),
    				'created_by'=>$session->read('userid'),
    				'account_id'=>$accountId,
    				'user_id'=>$userId,
    				'patient_id'=>$patientId,
    				'type'=>'RoomCharges',
    				'narration'=>$narration,
    				'debit_amount'=>$value);
    		if(!empty($value) && ($value != 0) && (!empty($userId))){
    			$voucherEntry->insertJournalEntry($jvData);
    			$voucherEntry->id= '';
    			// ***insert into Account (By) credit manage current balance
    			$account->setBalanceAmountByAccountId($userId,$value,'debit');
    			$account->setBalanceAmountByUserId($accountId,$value,'credit');
    			$account->id ='';
    		}
            }
        }
    }


    /**
	*	Function to return total bill of patients for report
	*	Pooja gupta
    */
    function getAllPatientTotalBillForReport($conditions){
		
			//if(!$patient_id) return ;
			$session = new CakeSession();
			
			$laboratoryTestOrderObj=ClassRegistry::init('LaboratoryTestOrder');
			$radiologyTestOrderTestOrderObj=ClassRegistry::init('RadiologyTestOrder');
			$consultantBillingObj=ClassRegistry::init('ConsultantBilling');
			$serviceBillObj=ClassRegistry::init('ServiceBill');
			$pharmacySaleObj=ClassRegistry::init('PharmacySalesBill');
			$wardPatientServiceObj=ClassRegistry::init('WardPatientService');
			$inventoryPharmacySalesReturnObj = ClassRegistry::init('InventoryPharmacySalesReturn') ;
			$otPharmacySalesBillobj = ClassRegistry::init('OtPharmacySalesBill') ;
			$otPharmacySalesReturnObj = ClassRegistry::init('OtPharmacySalesReturn') ;
			$hospitalType = $session->read('hospitaltype');	
			$optAppointmentObj=ClassRegistry::init('OptAppointment');
		//BOF for lab charge
			$laboratoryTestOrderObj->bindModel(
				array('belongsTo'=>array(
						'Patient'=>array('foreignKey'=>'patient_id','type'=>'INNER'))));

			$laboratoryData= $laboratoryTestOrderObj->find('all',array(
					'fields'=> array(
						'SUM(LaboratoryTestOrder.amount) as labTotalAmt',
						'SUM(LaboratoryTestOrder.paid_amount) as labTotal',
						'SUM(LaboratoryTestOrder.discount) as labDiscount',
						'LaboratoryTestOrder.patient_id'),
					'conditions'=>array($conditions,
						'LaboratoryTestOrder.is_deleted'=>0),
					'group'=>'LaboratoryTestOrder.patient_id'));
				$labData = array();
				if(!empty($laboratoryData)){
					foreach ($laboratoryData as $idKey=> $data){
						$netAmount['Total'][$data['LaboratoryTestOrder']['patient_id']] += $data['0']['labTotalAmt'];
						$netAmount['Paid'][$data['LaboratoryTestOrder']['patient_id']] += $data['0']['labTotal'];
						$netAmount['Discount'][$data['LaboratoryTestOrder']['patient_id']] += $data['0']['labDiscount'];
					}
			    }
		//EOF for lab
		
		//BOF for rad charge
			$radiologyTestOrderTestOrderObj->bindModel(
				array('belongsTo'=>array(
						'Patient'=>array('foreignKey'=>'patient_id','type'=>'INNER'))));
			$radiologyData= $radiologyTestOrderTestOrderObj->find('all',array(
					'fields'=> array(
									 'SUM(RadiologyTestOrder.amount) as radTotalAmt',
									 'SUM(RadiologyTestOrder.paid_amount) as radTotal',
									 'SUM(RadiologyTestOrder.discount) as radDiscount',
							         'RadiologyTestOrder.patient_id'),
					'conditions'=>array($conditions,
						'RadiologyTestOrder.is_deleted'=>0),
					'group'=>'RadiologyTestOrder.patient_id'));
				
			$radData = array();
				if(!empty($radiologyData)){
					foreach ($radiologyData as $idKey=> $data){
						$netAmount['Total'][$data['RadiologyTestOrder']['patient_id']] += $data['0']['radTotalAmt'];
						$netAmount['Paid'][$data['RadiologyTestOrder']['patient_id']] += $data['0']['radTotal'];
						$netAmount['Discount'][$data['RadiologyTestOrder']['patient_id']] += $data['0']['radDiscount'];
					}
			    }

		//EOF for rad
		
		//BOF for consultant charge
			$consultantBillingObj->bindModel(
				array('belongsTo'=>array(
						'Patient'=>array('foreignKey'=>'patient_id','type'=>'INNER'))));

			$consultantBillingData= $consultantBillingObj->find('all',array(
					'fields'=> array('SUM(ConsultantBilling.amount) as consultantTotalAmt',
									 'SUM(ConsultantBilling.paid_amount) as consultantTotal',
									 'SUM(ConsultantBilling.discount) as consultantDiscount',
									 'ConsultantBilling.patient_id'),
					'conditions'=>array($conditions),
					'group'=>'ConsultantBilling.patient_id'));
			
				$conData = array();
				if(!empty($consultantBillingData)){
					foreach ($consultantBillingData as $idKey=> $data){
						$netAmount['Total'][$data['ConsultantBilling']['patient_id']] += $data['0']['consultantTotalAmt'];
						$netAmount['Paid'][$data['ConsultantBilling']['patient_id']] += $data['0']['consultantTotal'];
						$netAmount['Discount'][$data['ConsultantBilling']['patient_id']] += $data['0']['consultantDiscount'];
					}
				}
		//EOF for consultant
		
		//BOF for ServiceBill charge
			$serviceBillObj->bindModel(
				array('belongsTo'=>array(
						'Patient'=>array('foreignKey'=>'patient_id','type'=>'INNER'))));

			$serviceBillData= $serviceBillObj->find('all',array(
					'fields'=> array(
						'SUM(ServiceBill.amount*ServiceBill.no_of_times) as serviceTotalAmt',
						'SUM(ServiceBill.paid_amount) as serviceTotal',
						'SUM(ServiceBill.discount) as serviceDiscount',
						'ServiceBill.patient_id'),
					'conditions'=>array($conditions,'ServiceBill.is_deleted'=>0),
					'group'=>'ServiceBill.patient_id'));
			
				$serData = array();
				if(!empty($serviceBillData)){
					foreach ($serviceBillData as $idKey=> $data){
						$netAmount['Total'][$data['ServiceBill']['patient_id']] += $data['0']['serviceTotalAmt'];
						$netAmount['Paid'][$data['ServiceBill']['patient_id']]  += $data['0']['serviceTotal'];
						$netAmount['Discount'][$data['ServiceBill']['patient_id']]  += $data['0']['serviceDiscount'];
					}
				}
		//EOF for ServiceBill
		
		//BOF for Pharmacy charge
			$pharmacySaleObj->unBindModel(array('hasMany'=>array('PharmacySalesBillDetail')));
			$pharmacySaleObj->bindModel(
				array('belongsTo'=>array(
						'Patient'=>array('foreignKey'=>'patient_id','type'=>'INNER'))));

			$pharmacySaleData= $pharmacySaleObj->find('all',array(
					'fields'=> array(
						'SUM(PharmacySalesBill.total) as pharmacyTotalAmt',
						'SUM(PharmacySalesBill.paid_amnt) as pharmacyTotal',
						'SUM(PharmacySalesBill.discount) as pharmacyDiscount',
						'PharmacySalesBill.patient_id'),
					'conditions'=>array($conditions,'PharmacySalesBill.is_deleted'=>0),
					'group'=>'PharmacySalesBill.patient_id'));
			$pharData = array();
			if(!empty($pharmacySaleData)){
				foreach ($pharmacySaleData as $idKey=> $data){
					$pharTotal[$data['PharmacySalesBill']['patient_id']] = $data['0']['pharmacyTotalAmt'];
					$pharData[$data['PharmacySalesBill']['patient_id']] = $data['0']['pharmacyTotal'];
					$pharDis[$data['PharmacySalesBill']['patient_id']] = $data['0']['pharmacyDiscount'];
				}
			}
			
			$inventoryPharmacySalesReturnObj->unBindModel(array('hasMany'=>array('InventoryPharmacySalesReturnsDetail'),'belongsTo'=>array('Patient')));

			$inventoryPharmacySalesReturnObj->bindModel(
				array('belongsTo'=>array(
						'Patient'=>array('foreignKey'=>'patient_id','type'=>'INNER'))));

			$salesReturnTotal = $inventoryPharmacySalesReturnObj->find('all',
					array('fields'=>array('SUM(InventoryPharmacySalesReturn.total) as sumTotal',
						'SUM(InventoryPharmacySalesReturn.discount) as sumDiscount'
						,'InventoryPharmacySalesReturn.patient_id'),
							'conditions'=>array($conditions,'InventoryPharmacySalesReturn.is_deleted'=>'0'),
							'group'=>'InventoryPharmacySalesReturn.patient_id'));
		
			$pharRetrData = array();
			if(!empty($salesReturnTotal)){
				foreach ($salesReturnTotal as $idKey=> $data){
					$pharRetrData[$data['InventoryPharmacySalesReturn']['patient_id']] = $data['0']['sumTotal']-$data['0']['sumDiscount'];
					$pharRetrDis[$data['InventoryPharmacySalesReturn']['patient_id']] =$data['0']['sumDiscount'];
				}
			}
			$netPharmay = array();
			foreach ($pharData as $idKey=> $data){
				$netAmount['Total'][$idKey] += round($pharTotal[$idKey] - $pharRetrData[$idKey]);
				$netAmount['Paid'][$idKey] += round($data - $pharRetrData[$idKey]);
				$netAmount['Discount'][$idKey] += round($pharDis[$idKey] - $pharRetrDis[$idKey]);
			}			
		//EOF pharmacy
				
		//BOF for OT charge 
			$otPharmacySalesBillobj->unBindModel(array('hasMany'=>array('OtPharmacySalesBillDetail'),'belongsTo'=>array('Patient','Doctor','Initial')));

			$otPharmacySalesBillobj->bindModel(
				array('belongsTo'=>array(
						'Patient'=>array('foreignKey'=>'patient_id','type'=>'INNER'))));

			$otPharmacySalesBillData= $otPharmacySalesBillobj->find('all',array(
					'fields'=> array('SUM(OtPharmacySalesBill.total) as otPharmacyTotalAmt',
						'SUM(OtPharmacySalesBill.paid_amount) as otPharmacyTotal',
						'SUM(OtPharmacySalesBill.discount) as otPharmacyDiscount'
						,'OtPharmacySalesBill.patient_id'),
					'conditions'=>array($conditions,'OtPharmacySalesBill.is_deleted'=>0),
					'group'=>'OtPharmacySalesBill.patient_id'));
			
			$otPharData = array();
			if(!empty($otPharmacySalesBillData)){
				foreach ($otPharmacySalesBillData as $idKey=> $data){
					$otPharTotal[$data['OtPharmacySalesBill']['patient_id']] = $data['0']['otPharmacyTotalAmt'];
					$otPharData[$data['OtPharmacySalesBill']['patient_id']] = $data['0']['otPharmacyTotal'];
					$otPharDis[$data['OtPharmacySalesBill']['patient_id']] = $data['0']['otPharmacyDiscount'];
				}
			}
				
			$otPharmacySalesReturnObj->unBindModel(array('hasMany'=>array('OtPharmacySalesReturnDetail'),'belongsTo'=>array('Patient')));

			$otPharmacySalesReturnObj->bindModel(
				array('belongsTo'=>array(
						'Patient'=>array('foreignKey'=>'patient_id','type'=>'INNER'))));

			$otSalesReturnTotal = $otPharmacySalesReturnObj->find('all',
					array('fields'=>array('SUM(OtPharmacySalesReturn.total) as sumTotal',
						'SUM(OtPharmacySalesReturn.discount) as sumDiscount'
						,'OtPharmacySalesReturn.patient_id'),
							'conditions'=>array($conditions,'OtPharmacySalesReturn.is_deleted'=>'0'),
							'group'=>'OtPharmacySalesReturn.patient_id'));
				
			$otPharRetrData = array();
			if(!empty($otSalesReturnTotal)){
				foreach ($otSalesReturnTotal as $idKey=> $data){
					$otPharRetrData[$data['OtPharmacySalesReturn']['patient_id']] = $data['0']['sumTotal']-$data['0']['sumDiscount'];
					$otPharRetrDis[$data['OtPharmacySalesReturn']['patient_id']] = $data['0']['sumDiscount'];
				}
			}
			
			$netOtPharmay = array();
			if(!empty($otPharData)){
				foreach ($otPharData as $idKey=> $data){
					$netAmount['Total'][$idKey] += round($otPharTotal[$idKey] - $otPharRetrData[$idKey]);
					$netAmount['Paid'][$idKey] += round($data - $otPharRetrData[$idKey]);
					$netAmount['Discount'][$idKey] += round($otPharDis[$idKey] - $otPharRetrDis[$idKey]);
				}
			}
		//EOF OT
		
		//BOF for ward charges 
		    $wardPatientServiceObj->bindModel(
				array('belongsTo'=>array(
						'Patient'=>array('foreignKey'=>'patient_id','type'=>'INNER'))));

			$wardPatientServiceData= $wardPatientServiceObj->find('all',
					array('fields'=> array('SUM(WardPatientService.amount) as wardPatientTotalAmt',
						'SUM(WardPatientService.paid_amount) as wardPatientTotal',
						'SUM(WardPatientService.discount) as wardPatientDiscount'
						,'WardPatientService.patient_id','COUNT(WardPatientService.id) as wardDays',
						'Patient.tariff_standard_id'),
						'conditions'=>array($conditions,
											'WardPatientService.is_deleted'=>0),
						'group'=>'WardPatientService.patient_id'));
			
			$wardData = array();
			if(!empty($wardPatientServiceData)){
				foreach ($wardPatientServiceData as $idKey=> $data){
					$doctorCharges=$nursingCharges=0;

					$doctorCharges = $this->getDoctorCharges($data['0']['wardDays'],$hospitalType,$data['Patient']['tariff_standard_id']);
					$nursingCharges = $this->getNursingCharges($data['0']['wardDays'],$hospitalType,$data['Patient']['tariff_standard_id']);

					$netAmount['Total'][$data['WardPatientService']['patient_id']] += $data['0']['wardPatientTotalAmt']+$doctorCharges+$nursingCharges; 
					$netAmount['Paid'][$data['WardPatientService']['patient_id']] += $data['0']['wardPatientTotal']; 
					$netAmount['Discount'][$data['WardPatientService']['patient_id']] += $data['0']['wardPatientDiscount']; 
				}
			}

			//Surgery Data

			$optAppointmentObj->bindModel(
				array('belongsTo'=>array(
						'Patient'=>array('foreignKey'=>'patient_id','type'=>'INNER'),
					    'OptAppointmentDetail'=>array(
					  				'foreignKey'=>false,
					  				'conditions'=>array(
					  					'OptAppointmentDetail.opt_appointment_id=OptAppointment.id',
					  					'OptAppointmentDetail.is_deleted'=>'0')
					  			),
					  	)
				));

			$optServiceData= $optAppointmentObj->find('all',
					array('fields'=> array('SUM(OptAppointmentDetail.cost) as totalAmt','OptAppointment.patient_id'),
						'conditions'=>array($conditions,
											'OptAppointment.is_deleted'=>0),
						'group'=>'OptAppointment.patient_id'));
			
			$wardData = array();
			if(!empty($optServiceData)){
				foreach ($optServiceData as $idKey=> $data){
					$netAmount['Total'][$data['OptAppointment']['patient_id']] += $data['0']['totalAmt'];/*+$doctorCharges+$nursingCharges; 
					$netAmount['Paid'][$data['OptAppointment']['patient_id']] += $data['0']['wardPatientTotal']; 
					$netAmount['Discount'][$data['OptAppointment']['patient_id']] += $data['0']['wardPatientDiscount']; */
				}
			}


			#dpr($netAmount);exit;
		//EOF for ward
		
		//BOF for totala amount 
			/*$netAmount = array();
			foreach ($patient_id as $idKey){
				$netAmount['Total'][$idKey] = $labTotal[$idKey] + $radTotal[$idKey] + $conTotal[$idKey] + $serTotal[$idKey] + $netPharmayTotal[$idKey] + $netOtPharmayTotal[$idKey]+$wardTotal[$idKey];

				$netAmount['Paid'][$idKey] = $labData[$idKey] + $radData[$idKey] + $conData[$idKey] + $serData[$idKey] + $netPharmay[$idKey] + $netOtPharmay[$idKey]+$wardData[$idKey];

				$netAmount['Discount'][$idKey] = $labDis[$idKey] + $radDis[$idKey] + $conDis[$idKey] + $serDis[$idKey] + $netPharmayDis[$idKey] + $netOtPharmayDis[$idKey]+$wardDis[$idKey];
			}*/ 

			$this->bindModel(
				array('belongsTo'=>array(
						'Patient'=>array('foreignKey'=>'patient_id','type'=>'INNER'))));

			$billData=$this->find('all',array('fields'=>array('SUM(amount) as paid','SUM(discount) as discount','SUM(paid_to_patient) as refund','patient_id','SUM(discount_amount) as other_deduction',),
				'conditions'=>array($conditions),
				'group'=>array('Billing.patient_id')));
			foreach ($billData as $key => $value) {
				$netAmount['FinalPaid'][$value['Billing']['patient_id']] +=$value['0']['paid'];
				$netAmount['FinalDiscount'][$value['Billing']['patient_id']] +=$value['0']['discount']+$value['0']['other_deduction'];
				$netAmount['FinalRefund'][$value['Billing']['patient_id']] +=$value['0']['refund'];

			}
			//debug($netAmount);exit;

			return $netAmount ;

	}
}