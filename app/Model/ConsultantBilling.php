<?php
class ConsultantBilling extends AppModel {

	public $name = 'ConsultantBilling';
	/* public $actsAs = array('Cipher' => array('autoDecypt' => true,
						   'cipher'=>array('amount'))); */
	 
	public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }
	
	function saveBillingData($data){
		$this->save($data);
	}
	
	//function to remove entries after discharged date
	function deleteAfterDischargeRecords($date,$patient_id){
		if(empty($patient_id)) return ;
		$this->deleteAll(array('date > '=>$date,'patient_id'=>$patient_id)) ;
	}
	public function JVConsultantData($patient_id){
		$session     = new cakeSession();
		$patientObj = ClassRegistry::init('Patient');
		$accountObj = ClassRegistry::init('Account');
		$voucherEntry = ClassRegistry::init('VoucherEntry');
		$doctorProfile = ClassRegistry::init('DoctorProfile');
		$consultantObj = ClassRegistry::init('Consultant');
		$tariffListObj = ClassRegistry::init('TariffList');
		$configurationObj = ClassRegistry::init('Configuration');
		$voucherLogObj = ClassRegistry::init('VoucherLog');
		$voucherReferenceObj = ClassRegistry::init('VoucherReference');
		$userObj = ClassRegistry::init('User');
		$tariffStandardObj = ClassRegistry::init('TariffStandard');
		$optAppointmentObj = ClassRegistry::init('OptAppointment');
		
		$webSite = $session->read('website.instance');
		$this->bindModel(array(
				'belongsTo' => array(
						'TariffList'=>array('foreignKey' => false,'conditions'=>array('ConsultantBilling.consultant_service_id=TariffList.id'))
				)),false);
		$consultant =$this->find('all',array('fields'=>array('ConsultantBilling.*','TariffList.name'),
				'conditions'=>array('ConsultantBilling.patient_id'=>$patient_id)));
		
		$getPatientDetails = $patientObj->getPatientAllDetails($patient_id);
                if($getPatientDetails['Patient']['is_paragon'] != '1'){ // if temporary registration then restrict entries -Atul Chandankhede
		if($getPatientDetails['Patient']['is_staff_register'] == '1'){
				$getAccDetails = $accountObj->find('first',array('conditions'=>array('Account.user_type'=>'User',
												'Account.name'=>trim($getPatientDetails['Patient']['lookup_name']),
												'Account.location_id'=>$session->read('locationid')),
												'fields'=>array('Account.id','Account.name')));
		}else{
				$getAccDetails = $accountObj->getAccountID($getPatientDetails['Patient']['person_id'],'Patient');//for account id
		}

		$accId = $getAccDetails['Account']['id'];//for accounting id
		
		foreach($consultant as $key=> $consultantData){	
			$consultantDetails = $tariffListObj->find('first',array('conditions'=>array('TariffList.id'=>$consultantData['ConsultantBilling']['consultant_service_id']),
					'fields'=>array('TariffList.code_name')));
			$codeName = $consultantDetails['TariffList']['code_name'];
				
			$doctorId = $consultantData['ConsultantBilling']['doctor_id'];
			$consultantId = $consultantData['ConsultantBilling']['consultant_id'];
			
			if($consultantData['ConsultantBilling']['category_id'] == 1){
				$doctorDetailsAll = $doctorProfile->find('first',array('fields'=>array('DoctorProfile.doctor_name','DoctorProfile.user_id'),
						'conditions'=>array('DoctorProfile.is_deleted'=>'0','DoctorProfile.id'=>$doctorId)));
				$consultantName = $doctorDetailsAll['DoctorProfile']['doctor_name'];
				$userId = $accountObj->getUserIdOnly($doctorDetailsAll['DoctorProfile']['user_id'],'User',$consultantName);
			}else{
				//for external doctor
				$consultantDetails = $consultantObj->find('first',array('fields'=>array('Consultant.first_name','Consultant.last_name','Consultant.id'),
						'conditions'=>array('Consultant.is_deleted'=>'0','Consultant.id'=>$consultantId)));
				$consultantName = $consultantDetails['Consultant']['first_name']." ".$consultantDetails['Consultant']['last_name'];
				$userId = $accountObj->getUserIdOnly($consultantId,'Consultant',$consultantName);
			}
	
			$accountId = $accountObj->getAccountIdOnly(Configure::read('surgeryPaymentLabel'));

			$regDate  =  DateFormatComponent::formatDate2Local($getPatientDetails['Patient']['form_received_on'],Configure::read('date_format'),true);
			$doneDate  =  DateFormatComponent::formatDate2Local($consultantData['ConsultantBilling']['date'],Configure::read('date_format'),true);
			
			//BOF for HOPE
				$getPrivateId = $tariffStandardObj->getPrivateTariffID($session->read('locationid'));
				$getRgjayId = $tariffStandardObj->getTariffStandardID('RGJAY');
				
				if(empty($consultantData['ConsultantBilling']['not_to_pay_dr'])){
					if($codeName == 'visit charges'){
						if($getPatientDetails['Patient']['tariff_standard_id'] == $getPrivateId){
							$amount = Configure::read('external_consultant_fees');
						}elseif($getPatientDetails['Patient']['tariff_standard_id'] != $getRgjayId){
							$generalComponent = new GeneralComponent();
							$privatePackageData = $generalComponent->getPackageNameAndCost($patient_id);
							
							$consulDate=$consultantData['ConsultantBilling']['date'];
							$startDate = $privatePackageData['startDate'];
							$endDate = $privatePackageData['endDate'];
							
							if($consulDate >= $startDate && $consulDate <= $endDate){
								$amount = Configure::read('external_consultant_fees_company');
							}
						}else{
							$count = $optAppointmentObj->find('count',array('conditions'=>array('OptAppointment.patient_id'=>$patient_id,'OptAppointment.is_deleted'=>'0')));
							if($count=='0'){
								$amount = Configure::read('external_consultant_fees_company');
							}
						}
					}
				}
				//for narration set
				$tariffName = $consultantData['TariffList']['name'];
				$patientName = $getPatientDetails['Patient']['lookup_name'];
				$getTariffName = $tariffStandardObj->getTariffStandardName($getPatientDetails['Patient']['tariff_standard_id']);
				$narration = "Being $tariffName charged to pt. $patientName ($getTariffName), Date of Registration :$regDate done on $doneDate";
				if(!empty($userId)){
					$jvData = array('date'=>$consultantData['ConsultantBilling']['date'],
							'user_id'=>$userId,
							'account_id'=>$accountId,
							'debit_amount'=>$amount,
							'type'=>'VisitCharges',
							'narration'=>$narration,
							'patient_id'=>$patient_id);
					if(!empty($jvData['debit_amount']) && ($jvData['debit_amount'] != 0)){
						$voucherEntry->insertJournalEntry($jvData);
						$voucherEntry->id= '';
						// ***insert into Account (By) credit manage current balance
						$accountObj->setBalanceAmountByAccountId($userId,$amount,'debit');
						$accountObj->setBalanceAmountByUserId($accountId,$amount,'credit');
						$accountObj->id='';
					}
				}
				//EOF jv for Accounting
			$useId = $accountObj->getUserIdOnly($consultantData['ConsultantBilling']['consultant_service_id'],'TariffList',$consultantData['TariffList']['name']);//for user id
			if(empty($consultantData['ConsultantBilling']['description'])){
				$narration = 'Being'." ".$consultantData['TariffList']['name']." ".'charged to patient '.$getPatientDetails['Patient']['lookup_name']." (Date of Registration :".$regDate.")".'done on '.$doneDate;
			}else{
				$narration = $consultantData['ConsultantBilling']['description'];
			}
			$jvData = array('date'=>$consultantData['ConsultantBilling']['date'],
					'user_id'=>$useId,
					'account_id'=>$accId,
					'debit_amount'=>$consultantData['ConsultantBilling']['amount'],
					'type'=>'Consultant',
					'narration'=>$narration,
					'patient_id'=>$patient_id);
			if(!empty($jvData['debit_amount']) && ($jvData['debit_amount'] != 0)){
				$voucherEntry->insertJournalEntry($jvData);
				$voucherEntry->id= '';
				// ***insert into Account (By) credit manage current balance
				$accountObj->setBalanceAmountByAccountId($useId,$consultantData['ConsultantBilling']['amount'],'debit');
				$accountObj->setBalanceAmountByUserId($accId,$consultantData['ConsultantBilling']['amount'],'credit');
				$accountObj->id='';
			}
		}
            }
	}
	
	//BOF for sum of paid amount and discount amount, return patient wise service name by amit jain
	function getServiceWiseCharges($patientId=null,$date=null,$userId=null){
		$session     = new cakeSession();
		if(!$patientId) return false ;
		$serviceCategoryObj = ClassRegistry::init('ServiceCategory');
		$serviceId = $serviceCategoryObj->getServiceGroupId('Consultant',$session->read('locationid'));
		$this->bindModel(array(
				'belongsTo' => array(
						'TariffList' =>array('foreignKey' => false,'conditions'=>array('ConsultantBilling.consultant_service_id=TariffList.id')),
						'ServiceCategory' =>array('foreignKey' => false,'conditions'=>array('ServiceCategory.id'=>$serviceId)),
						'Billing' =>array('foreignKey' => false,'conditions'=>array('ConsultantBilling.billing_id=Billing.id')))),false);
		$amountDetails = $this->find(all,array('conditions'=>array('ConsultantBilling.location_id'=>$session->read('locationid'),
				'ConsultantBilling.patient_id'=>$patientId,'ConsultantBilling.billing_id NOT'=>NULL,'DATE_FORMAT(Billing.date,"%Y-%m-%d")'=>$date,
				'Billing.created_by'=>$userId,'Billing.mode_of_payment'=>'Cash'),
				'fields'=>array('ConsultantBilling.amount','ConsultantBilling.discount','TariffList.name','ServiceCategory.name')));
		return $amountDetails ;
	}
	//EOF
	
	/**
	 * for saving consultant billing data
	 * @yashwant
	 */
	function saveConsultantBillingData($patientId=null,$data=array()){
		
		$session     = new cakeSession();
		$tariffList = ClassRegistry::init('TariffList');
		$patient = ClassRegistry::init('Patient');
		$doctorProfile = ClassRegistry::init('DoctorProfile');
		$account = ClassRegistry::init('Account');
		$consultant = ClassRegistry::init('Consultant');
		$voucherPayment = ClassRegistry::init('VoucherPayment');
		$CouponTransaction = ClassRegistry::init('CouponTransaction');
		$voucherLog = ClassRegistry::init('VoucherLog');
		$voucherEntry = ClassRegistry::init('VoucherEntry');
		$Coupon = ClassRegistry::init('Coupon');
		$Billing = ClassRegistry::init('Billing');
		$patient_details  = $patient->find('first',array('conditions'=>array('Patient.id'=>$patientId),'fields'=>array('Patient.coupon_name')));
		
		$i=0;
		foreach($data['ConsultantBilling'] as $key=>$value){
			//debug($value);
			if($value['date']){
				$date= DateFormatComponent::formatDate2STD($value['date'],Configure::read('date_format'));
				$consultantBillingArr['ConsultantBilling'][$i]['date']=$date;
			}
			if($value['category_id']==0){
				$consultantBillingArr['ConsultantBilling'][$i]['consultant_id']=$value['doctor_id'];
				$consultantBillingArr['ConsultantBilling'][$i]['doctor_id']='';
			}else if($value['category_id']==1){
				$consultantBillingArr['ConsultantBilling'][$i]['doctor_id']=$value['doctor_id'];
				$consultantBillingArr['ConsultantBilling'][$i]['consultant_id']='';
			}
			$consultantBillingArr['ConsultantBilling'][$i]['consultant_service_id']=$value['consultant_service_id'];
			$consultantBillingArr['ConsultantBilling'][$i]['service_sub_category_id']=$value['service_sub_category_id'];
			$consultantBillingArr['ConsultantBilling'][$i]['service_category_id']=$value['service_category_id'];
			$consultantBillingArr['ConsultantBilling'][$i]['amount']=$value['amount'];
			$consultantBillingArr['ConsultantBilling'][$i]['description']=$value['description'];
			$consultantBillingArr['ConsultantBilling'][$i]['not_to_pay_dr']=$value['not_to_pay_dr'];
			$consultantBillingArr['ConsultantBilling'][$i]['pay_to_consultant']=$value['pay_to_consultant'];
			$consultantBillingArr['ConsultantBilling'][$i]['category_id']=$value['category_id'];
			$consultantBillingArr['ConsultantBilling'][$i]['location_id']=$session->read('locationid');
			$consultantBillingArr['ConsultantBilling'][$i]['created_by']=$session->read('userid');
			$consultantBillingArr['ConsultantBilling'][$i]['create_time']=date("Y-m-d H:i:s");
			$consultantBillingArr['ConsultantBilling'][$i]['patient_id']=$patientId;
			 
			$errors = $this->save($consultantBillingArr['ConsultantBilling'][$i]);
			//$consultantBillingArr['ConsultantBilling'][$i]['id']='';
			$idVar = $this->id;
			$this->id = '';
			$couponDetails  = $Coupon->find('first',array('conditions'=>array('Coupon.batch_name'=>$patient_details['Patient']['coupon_name']),'fields'=>array('id','batch_name','sevices_available','coupon_amount')));

			if(!empty($patient_details['Patient']['coupon_name'])){
				$ServiceCategory = Classregistry::init('ServiceCategory');
				$groupId = $ServiceCategory->getServiceGroupId(Configure::read('Consultant'));
				$sevicesAvailable = explode(',',$couponDetails['Coupon']['sevices_available']);
				$couponAMT = unserialize($couponDetails['Coupon']['coupon_amount']);
				$Coupontype = $couponAMT[$groupId]['type'];
				$CoupontypeAmount = $couponAMT[$groupId]['value'];
				$totalPayment = $value['amount'];
				$ConsultantBillingId = $idVar;
				$tariff_list_id[Configure::read('Consultant')][] = $ConsultantBillingId;
				$discAmt = 0;
				if($Coupontype == 'Percentage'){
					$perSentAmt = ($totalPayment/100)*$CoupontypeAmount;
					$pending = $totalPayment - $perSentAmt;
					$discAmt = $perSentAmt;
				}else if($Coupontype == 'Amount'){
					$pending = $totalPayment - $CoupontypeAmount;
					$discAmt = $CoupontypeAmount;
				} 				
				if(in_array($groupId, $sevicesAvailable)){
						$this->updateAll(array('ConsultantBilling.discount'=>"'".$discAmt."'"),array('ConsultantBilling.id'=>$ConsultantBillingId));
				}
				
				if($discAmt > 0){
						$serSrArray=serialize($tariff_list_id);
						$couponBillArrayData['patient_id']= $patientId;
						$couponBillArrayData['tariff_list_id'] = $serSrArray;
						$couponBillArrayData['location_id']= $session->read('locationid');
						$couponBillArrayData['date']= date('Y-m-d H:i:s');
						$couponBillArrayData['payment_category']= $groupId ;
						$couponBillArrayData['amount']='0';
						$couponBillArrayData['total_amount']= $totalPayment;
						$couponBillArrayData['amount_pending']= $totalPayment - $discAmt;
						$couponBillArrayData['create_time']= date("Y-m-d H:i:s");
						$couponBillArrayData['discount'] = $discAmt;
						$couponBillArrayData['created_by']= $session->read('userid');
						$couponBillArrayData['discount_type']= 'Coupon';
						$Billing->save($couponBillArrayData);
						//debug($couponBillArrayData);exit;
						//$this->Billing->addPartialPaymentJV($couponBillArrayData,$couponBillArrayData['patient_id']);
					
					
				}
			}
			//BOF Jv for accounting  
			$consultantDetails = $tariffList->find('first',array(
					'conditions'=>array('TariffList.name'=>$value['consultant_service_name']),
					'fields'=>array('code_name')));
			$codeName = $consultantDetails['TariffList']['code_name'];
			$doctorId = $value['doctor_id'];
			
			//find person id for updation amount of services and also used some details for narration
			$getPatientDetails=$patient->find('first',array(
					'conditions'=>array('Patient.id'=>$patientId),
					'fields'=>array('person_id','lookup_name','form_received_on')));
				
			if($value['category_id'] == 1){
				$doctorDetailsAll = $doctorProfile->find('first',array(
						'fields'=>array('DoctorProfile.doctor_name','DoctorProfile.user_id'),
						'conditions'=>array('DoctorProfile.is_deleted'=>'0','DoctorProfile.id'=>$doctorId)));
				$consultantName = $doctorDetailsAll['DoctorProfile']['doctor_name'];
				$userId = $account->getUserIdOnly($doctorDetailsAll['DoctorProfile']['user_id'],'User',$consultantName);
			}else{
				//for external doctor
				//find consultant first name and last name for create accounting ledger
				$consultantDetails = $consultant->find('first',array(
						'fields'=>array('Consultant.first_name','Consultant.last_name'),
						'conditions'=>array('Consultant.is_deleted'=>'0','Consultant.id'=>$doctorId)));
				$consultantName = $consultantDetails['Consultant']['first_name']." ".$consultantDetails['Consultant']['last_name'];
				$userId = $account->getUserIdOnly($doctorId,'Consultant',$consultantName);
			}
			
			$accountId = $account->getAccountIdOnly(Configure::read('surgeryPaymentLabel'));
			
			$regDate  =  DateFormatComponent::formatDate2Local($getPatientDetails['Patient']['form_received_on'],Configure::read('date_format'),true);
			$doneDate  = DateFormatComponent::formatDate2Local($consultantBillingArr['ConsultantBilling'][$i]['date'],Configure::read('date_format'),true);
			
  
			//for narration set
			$narration = 'Being'." ".$value['consultant_service_name']." ".'charged to patient '.$getPatientDetails['Patient']['lookup_name']." (Date of Registration :".$regDate.")".'done on '.$doneDate;
				
			if(!empty($value['pay_to_consultant'])){
				$caId = $account->find('first',array('fields'=>array('id'),'conditions'=>array('Account.name'=>Configure::read('cash'))));
				$cashId = $caId['Account']['id'];
				$voucherLogDataPay=$pvData = array(
						'date'=>$consultantBillingArr['ConsultantBilling'][$i]['date'],
						'modified_by'=>$session->read('userid'),
						'create_by'=>$session->read('userid'),
						'account_id'=>$cashId,
						'user_id'=>$userId,
						'narration'=>$narration,
						'paid_amount'=>$value['pay_to_consultant']);
				if(!empty($pvData['paid_amount']) && ($pvData['paid_amount'] != 0)){
					$lastVoucherIdPayment=$voucherPayment->insertPaymentEntry($pvData);
					// ***insert into Account (By) credit manage current balance
					$account->setBalanceAmountByAccountId($userId,$value['pay_to_consultant'],'debit');
					$account->setBalanceAmountByUserId($cashId,$value['pay_to_consultant'],'credit');
					//insert into voucher_logs table added by PankajM
					$voucherLogDataPay['voucher_id']=$lastVoucherIdPayment;
					$voucherLogDataPay['voucher_type']="Payment";
					$voucherLog->insertVoucherLog($voucherLogDataPay);
					$voucherLog->id= '';
					$voucherPayment->id= '';
				}
			} 
			
			
			$i++;
		}
		 
	}
	
	public function getDdetail($id,$condition=array(),$superBillId=NULL,$forCorporateOnly=false){	
		
			$condition['OR']=array('ConsultantBilling.paid_amount <='=>'0','ConsultantBilling.paid_amount'=>NULL);
			$this->bindModel(array(
				'belongsTo' => array('TariffList' =>array('foreignKey'=>'consultant_service_id'),
						'DoctorProfile' =>array('foreignKey' => 'doctor_id'),
						'Consultant' =>array('foreignKey' => 'consultant_id'),
						'User' =>array('foreignKey' => false ,'conditions'=>array('DoctorProfile.user_id=User.id')),
						'ServiceCategory'=>array('foreignKey' => 'service_category_id'),
						'Initial' =>array('foreignKey'=>false,'conditions' => array('Initial.id=User.initial_id')),
				)),false);	
	
		if(!empty($id))
			$condition['ConsultantBilling.patient_id']=$id;		
			
		$tempConDData = $this->find('all',array('fields'=>array('TariffList.*,ServiceCategory.*,ConsultantBilling.*,DoctorProfile.*','Initial.name'),
				'conditions'=>array('ConsultantBilling.consultant_id'=>NULL,'ConsultantBilling.is_deleted'=>'0',
						$condition),
				'order'=>array('ConsultantBilling.date')));
	
		if($forCorporateOnly)  return $tempConDData ;
	
		$cDArray=array();
		foreach($tempConDData as $tCD){
			$tCD['ConsultantBilling']['amount'] = $tCD['ConsultantBilling']['amount'];
			$cDArray[$tCD['ConsultantBilling']['consultant_service_id']][$tCD['ConsultantBilling']['doctor_id']][$tCD['ConsultantBilling']['amount']][]=$tCD;
				
		}
			
		return $cDArray;
	}
	
	
	/**
	 *  Function to return External consultant charges
	 * @param unknown_type $id
	 * @return Ambigous <multitype:, unknown>
	 * Pooja Gupta
	 */
	public function getCdetail($id,$condition=array(),$superBillId=NULL,$forCorporateOnly=false){
	
		$condition['ConsultantBilling.paid_amount <=']='0';
		$this->bindModel(array(
				'belongsTo' => array( 	'TariffList' =>array('foreignKey'=>'consultant_service_id'),
						'Consultant' =>array('foreignKey' => 'consultant_id'),
						'ServiceCategory'=>array('foreignKey' => 'service_category_id'),
						'Initial' =>array('foreignKey'=>false,'conditions' => array('Consultant.initial_id=Initial.id')),
				)),false);
	
		if(!empty($id))
			$condition['ConsultantBilling.patient_id']=$id;
	
		$tempConCData = $this->find('all',array('fields'=>array('TariffList.*,ServiceCategory.*,ConsultantBilling.*,Consultant.*','Initial.name'),
				'conditions'=>array('ConsultantBilling.doctor_id'=>NULL,'ConsultantBilling.is_deleted'=>'0',$condition),'order'=>array('ConsultantBilling.date')));
	
		if($forCorporateOnly){
			return $tempConCData ;
		}
		$cCArray=array();
		foreach($tempConCData as $tCD){
			$tCD['ConsultantBilling']['amount'] = $tCD['ConsultantBilling']['amount'];
			$cCArray[$tCD['ConsultantBilling']['consultant_service_id']][$tCD['ConsultantBilling']['consultant_id']][$tCD['ConsultantBilling']['amount']][]=$tCD;
	
		}
		return $cCArray;
	}
	
	function consultantServicesUpdate($serviceData,$encId,$catKey,$billId,$percent,$modified){
		$session = new cakeSession();
		$modified_by=$session->read('userid');
		foreach($serviceData as $serviceKey=>$eachData){
			$conData=0;
			$conPay=0;
			$conDiscount=0;
			$conpaid=0;
			$conData=$this->find('first',array(
					'fields'=>array('ConsultantBilling.amount','ConsultantBilling.paid_amount',
							'ConsultantBilling.discount'),
					'conditions'=>array('ConsultantBilling.id'=>$serviceKey,'ConsultantBilling.patient_id'=>$encId,
					)));
			$billTariffId[$catKey][]=$serviceKey; //tariff_list_id serialize array
	
			$conPay=($eachData['balAmt']*$percent)/100;
	
			$conpaid=$conPay+$conData['ConsultantBilling']['paid_amount'];
	
			$conDiscount=$conData['ConsultantBilling']['amount']-($conpaid);
	
			$this->updateAll(
					array('ConsultantBilling.paid_amount'=>"'$conpaid'",
							'ConsultantBilling.discount'=>"'$conDiscount'",
							'ConsultantBilling.billing_id'=>"'$billId'",
							'ConsultantBilling.modified_by'=>"'$modified_by'",
							'ConsultantBilling.modify_time'=>"'$modified'"),
					array('ConsultantBilling.id'=>$serviceKey,'ConsultantBilling.patient_id'=>$encId,
					)
			);
		}
		return $billTariffId;
	}
}

