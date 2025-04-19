<?php
/**
 * ScheduleJobsShell file
 *
 * PHP 5
 * 
 *
 * @copyright     Copyright 2015 drmhope Inc.  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       ScheduleJobsShell
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 */
App::uses('ConnectionManager', 'Model');
App::uses('Component', 'Controller');

App::uses('AppModel','Model');
App::uses('Patient', 'Model');
App::uses('FinalBilling', 'Model');
App::uses('Appointment', 'Model');
App::uses('Billing', 'Model');
App::uses('LaboratoryTestOrder', 'Model');

App::uses('RadiologyTestOrder', 'Model');
App::uses('ConsultantBilling', 'Model');
App::uses('ServiceBill', 'Model');
App::uses('PharmacySalesBill', 'Model');
App::uses('WardPatientService', 'Model'); 
App::uses('PharmacySalesBillDetail','Model');
App::uses('Doctor','Model');

App::uses('Laboratory', 'Model');
App::uses('Account', 'Model');
App::uses('VoucherEntry', 'Model');
App::uses('TariffList', 'Model');
App::uses('ServiceCategory', 'Model');
App::uses('ServiceProvider', 'Model');
App::uses('Configuration', 'Model');
App::uses('VoucherReference', 'Model');
App::uses('VoucherLog', 'Model');
App::uses('Radiology', 'Model');
App::uses('ServiceSubCategory', 'Model');
App::uses('DoctorProfile', 'Model');
App::uses('Consultant', 'Model');
App::uses('User', 'Model');
App::uses('TariffStandard', 'Model');
App::uses('OptAppointment', 'Model');
App::uses('TariffAmount', 'Model');
App::uses('InventoryPharmacySalesReturn', 'Model');
App::uses('AccountingGroup', 'Model');
App::uses('MarketingTeam', 'Model');
App::uses('InventoryPharmacySalesReturnsDetail', 'Model');
App::uses('Department', 'Model');

App::uses('CakeSession', 'Model/Datasource');
App::uses('DateFormatComponent', 'Controller/Component');
App::uses('GeneralComponent', 'Controller/Component');


class OpdCloseShell extends AppShell { 
	public function main() {
		$this->closedOPDEncounters();
	} 
	/**
	 * @author Pawan Meshram
	 * DO NOT CHANGE
	 * This job will run at every night 12.00 PM to close all encounter of OPD
	 */
	public function closedOPDEncounters(){
		$dataSource = ConnectionManager::getDataSource('default');
		$confDeafult = ConnectionManager::$config->defaultHospital;
		$this->database = $confDeafult['database'];
		 
		App::uses('CakeSession', 'Model/Datasource'); 
		$cakeSessionObj = new CakeSession(); 
		$patientModel = new Patient(null,null,$this->database);
		$finalBillingModel = new FinalBilling(null,null,$this->database);
		$appointmentModel = new Appointment(null,null,$this->database); 
		//$appointmentData = $appointmentModel->find('all',array('conditions'=>array("Appointment.status != 'Closed'")));
		$patientData = $patientModel->find('all',array('conditions'=>array("Patient.is_discharge"=>0,'Patient.is_deleted'=>0,'Patient.admission_type !='=>'IPD'),
				'fields'=>array('Patient.id'))); //includes opd,lab and radiology patient also 
		foreach($patientData as $appKey=>$appValue){ 
			if($appValue['Patient']['id'] != ''){
				$patientModel->updateAll(array('is_discharge'=>1,'discharge_date'=>"'".date("Y-m-d H:i:s")."'"),array('Patient.id'=>$appValue['Patient']['id'])); //update patient 
				$finalBillingData = $finalBillingModel->findByPatientId($appValue['Patient']['id']);		
				$advancePaid = $this->getPaidAndDiscount($appValue['Patient']['id']);  
				$patientTotal = $this->getPatientTotalBill($appValue['Patient']['id']);
				 
				$finalBillingModel->save(array('discharge_date'=>"'".date("Y-m-d H:i:s")."'",'id'=>$finalBillingData['FinalBilling']['id'],
						'patient_id'=>$appValue['Patient']['id'],'total_amount'=>(int)$patientTotal,
						'amount_paid'=>$advancePaid[0]['paid_amount'],'amount_pending'=>(int)$patientTotal-(int)$advancePaid[0]['paid_amount'],
						'discount'=>$advancePaid[0]['discount'] ));//update/insert finalBilling  
				 
				/* $appointmentModel->updateAll(
					array('Appointment.status' => '"Closed"'),
					array('Appointment.patient_id ' => $appValue['Patient']['id'])
				); */
				//$appointmentModel->updateAll(array('Appointment.status="Closed"'),array('Appointment.patient_id="'.$appValue['Patient']['id'].'"'));
				//update appointment  
				$appointmentModel->id = null;
				$finalBillingModel->id = null;
				$patientModel->id = null;
				
				
				//BOF accounting by amit
					$this->finalDischargeJV($appValue['Patient']['id']);
				//EOF accounting by amit
			}
		}
	}  
	
	function getPaidAndDiscount($patient_id=null){
		$billingModel = new Billing(null,null,$this->database);
		$advancePaid = $billingModel->find('first',array('fields'=>array('SUM(amount) as paid_amount','SUM(discount) as discount'),
				'conditions'=>array('Billing.patient_id'=>$patient_id,'Billing.is_deleted'=>0)));
		return $advancePaid ;  
	}
	
		//return total amount of OPD patient for NON closed patient.
		function getPatientTotalBill($patient_id=null,$type = null){
			if(!$patient_id) return ; 
			//lab charge
			
			$laboratoryTestOrderObj = new LaboratoryTestOrder(null,null,$this->database); 
			$radiologyTestOrderTestOrderObj = new RadiologyTestOrder(null,null,$this->database);
			$consultantBillingObj = new ConsultantBilling(null,null,$this->database);
			$serviceBillObj = new ServiceBill(null,null,$this->database);
			$pharmacySaleObj = new PharmacySalesBill(null,null,$this->database);
			$wardPatientServiceObj = new WardPatientService(null,null,$this->database); 
			
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
			
			$pharmacySaleObj->unBindModel(array('hasMany'=>array('PharmacySalesBillDetail'),'belongsTo'=>array('Patient','Doctor','Initial')));
			$pharmacySaleData= $pharmacySaleObj->find('first',array(
					'fields'=> array('SUM(PharmacySalesBill.total) as pharmacyTotal'),
					'conditions'=>array('PharmacySalesBill.patient_id'=>$patient_id,'PharmacySalesBill.is_deleted'=>0))); 
			
			if($type == 'IPD'){
			$wardPatientServiceData= $wardPatientServiceObj->find('first',array(
					'fields'=> array('SUM(WardPatientService.amount) as wardPatientTotal'),
					'conditions'=>array('WardPatientService.patient_id'=>$patient_id,'WardPatientService.is_deleted'=>0)));
			}
			
			$patientTotal = (int)$laboratoryData[0]['labTotal']+(int)$radiologyData[0]['radTotal']+(int)$consultantBillingData[0]['consultantTotal']+
								(int)$serviceBillData[0]['serviceTotal']+(int)$pharmacySaleData[0]['pharmacyTotal']+(int)$wardPatientServiceData[0]['wardPatientTotal']; 
			return $patientTotal ;
		}
		
		function finalDischargeJV($patientId){
			$voucherLogObj = new VoucherLog(null,null,$this->database);
			$finalVoucherLogDetails=$voucherLogObj->find('first',array('fields'=>array('VoucherLog.id'),
			'conditions'=>array('VoucherLog.patient_id'=>$patientId,'VoucherLog.type'=>'FinalDischarge')));
			if(empty($finalVoucherLogDetails['VoucherLog']['id'])){
				$this->deleteRevokeJV($patientId);
				$this->JVLabData($patientId);
				$this->JVRadData($patientId);
				$this->JVServiceData($patientId);
				$this->JVConsultantData($patientId);
				$this->JVSaleBillData($patientId);
				$this->addFinalVoucherLogJV($patientId);
			}
		}
		
		/**
		 * jv for lab function
		 * By amit
		 * @params patient_id
		 * return data
		 */
		public function JVLabData($patient_id){
			$dateFormatComponentModel = new DateFormatComponent(new ComponentCollection());
			$laboratoryTestOrderObj = new LaboratoryTestOrder(null,null,$this->database);
			$laboratoryObj = new Laboratory(null,null,$this->database);
			$patientObj = new Patient(null,null,$this->database);
			$accountingGroupObj = new AccountingGroup(null,null,$this->database);
			$accountObj = new Account(null,null,$this->database);
			$voucherEntryObj = new VoucherEntry(null,null,$this->database);
			$tariffListObj = new TariffList(null,null,$this->database);
			$serviceCategoryObj = new ServiceCategory(null,null,$this->database);
			$serviceProviderObj = new ServiceProvider(null,null,$this->database);
			$configurationObj = new Configuration(null,null,$this->database);
			$voucherReferenceObj = new VoucherReference(null,null,$this->database);
			$voucherLogObj = new VoucherLog(null,null,$this->database);
			$radiologyObj = new Radiology(null,null,$this->database); 
			
			$laboratoryTestOrderObj->bindModel(array(
					'belongsTo' => array(
							'Laboratory'=>array('foreignKey' => false,'conditions'=>array('LaboratoryTestOrder.laboratory_id=Laboratory.id'))
					)),false);
			$laboratoryData= $laboratoryTestOrderObj->find('all',array('fields'=> array('LaboratoryTestOrder.laboratory_id','LaboratoryTestOrder.start_date',
					'LaboratoryTestOrder.amount','LaboratoryTestOrder.description','LaboratoryTestOrder.id','Laboratory.name'),
					'conditions'=>array('LaboratoryTestOrder.is_deleted'=>'0','LaboratoryTestOrder.patient_id'=>$patient_id)));
	
			foreach($laboratoryData as $key=>$labData){	
				if(!empty($labData['Laboratory']['name'])){
					$getLabTariffId = $laboratoryObj->find('first',array('fields'=>array('tariff_list_id'),
							'conditions'=>array('Laboratory.id'=>$labData['LaboratoryTestOrder']['laboratory_id'])));
					$tariffListId = $getLabTariffId['Laboratory']['tariff_list_id'];
					if(empty($tariffListId)){
						$getTariffId = $tariffListObj->find('first',array('fields'=>array('id'),'conditions'=>array('TariffList.name'=>$labData['Laboratory']['name'])));
						$tariffListId=$getTariffId['TariffList']['id'];
						if(empty($tariffListId)){
							$tariffListData  = array(
									'location_id'=>'1',
									'name'=>$labData['Laboratory']['name'],
									'create_time'=> date('Y-m-d H:i:s'),
									'created_by'=>'1',
									'service_id'=>$this->getServiceGroupId(Configure::read('laboratoryservices')));
							$tariffListObj->saveAll($tariffListData); //insert registration and consulation servicde and charges
							$tariffListId = $tariffListObj->getLastInsertID();
						}
					$laboratoryObj->updateAll(array('tariff_list_id'=>$tariffListId),array('Laboratory.id'=>$labData['LaboratoryTestOrder']['laboratory_id']));
					}
					$getPatientDetails=$patientObj->find('first',array('conditions'=>array('Patient.id'=>$patient_id),'fields'=>array('person_id','lookup_name','form_received_on','admission_type')));
					$personId = $getPatientDetails['Patient']['person_id'];
					
					$accountId = $this->getAccountID($personId,'Patient');
					$userId = $this->getUserIdOnly($tariffListId,'TariffList',$labData['Laboratory']['name']);
	
					$regDate  =  $dateFormatComponentModel->formatDate2Local($getPatientDetails['Patient']['form_received_on'],Configure::read('date_format'),true);
					$doneDate  =  $dateFormatComponentModel->formatDate2Local($labData['LaboratoryTestOrder']['start_date'],Configure::read('date_format'),true);
		
					//for hope hospital only
					$amountLab = $labData['LaboratoryTestOrder']['amount'];
					$labName =$labData['Laboratory']['name'];
					$patientName = $getPatientDetails['Patient']['lookup_name'];
					
					if(empty($labData['LaboratoryTestOrder']['description'])){
						$narration = "Being $labName to pt. $patientName (Date of Registration :$regDate) done on $doneDate";//for narration set
					}else{
						$narration = $labData['LaboratoryTestOrder']['description'];
					}
					$jvData = array('date'=>$labData['LaboratoryTestOrder']['start_date'],
							'location_id'=>'1',
							'created_by'=>'1',
							'user_id'=>$userId,
							'billing_id'=>$labData['LaboratoryTestOrder']['id'],
							'account_id'=>$accountId['Account']['id'],
							'debit_amount'=>$amountLab,
							'type'=>'Laboratory',
							'narration'=>$narration,
							'patient_id'=>$patient_id);
					if(!empty($jvData['debit_amount']) && ($jvData['debit_amount'] != 0)){
						$voucherEntryObj->insertJournalEntry($jvData);
						$voucherEntryObj->id ='';
						// ***insert into Account (By) credit manage current balance
						$this->setBalanceAmountByAccountId($accountId['Account']['id'],$amountLab,'debit');
						$this->setBalanceAmountByUserId($userId,$amountLab,'credit');
					}
					//EOF JV
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
			$dateFormatComponentModel = new DateFormatComponent(new ComponentCollection());
			$radiologyTestOrderObj = new RadiologyTestOrder(null,null,$this->database);
			$radiologyObj = new Radiology(null,null,$this->database);
			$patientObj = new Patient(null,null,$this->database);
			$accountObj = new Account(null,null,$this->database);
			$voucherEntryObj = new VoucherEntry(null,null,$this->database);
			$tariffListObj = new TariffList(null,null,$this->database);
			$serviceCategoryObj = new ServiceCategory(null,null,$this->database);
			$serviceProviderObj = new ServiceProvider(null,null,$this->database);
			$voucherReferenceObj = new VoucherReference(null,null,$this->database);
			$voucherLogObj = new VoucherLog(null,null,$this->database);
			$serviceSubCategoryObj = new ServiceSubCategory(null,null,$this->database);
			 
			$radiologyTestOrderObj->bindModel(array(
					'belongsTo' => array(
							'Radiology'=>array('foreignKey' => false,'conditions'=>array('RadiologyTestOrder.radiology_id=Radiology.id'))
					)),false);
			$radiologyData= $radiologyTestOrderObj->find('all',array('fields'=> array('RadiologyTestOrder.id','RadiologyTestOrder.radiology_id',
					'RadiologyTestOrder.radiology_order_date','RadiologyTestOrder.service_provider_id','RadiologyTestOrder.amount',
					'RadiologyTestOrder.description','Radiology.name'),
					'conditions'=>array('RadiologyTestOrder.is_deleted'=>'0','RadiologyTestOrder.patient_id'=>$patient_id)));
			
			foreach($radiologyData as $key=>$radData){
				if(!empty($radData['Radiology']['name'])){
					$getRadTariffId = $radiologyObj->find('first',array('fields'=>array('Radiology.tariff_list_id'),'conditions'=>array('Radiology.id'=>$radData['RadiologyTestOrder']['radiology_id'])));
					$tariffListId = $getRadTariffId['Radiology']['tariff_list_id'];
					if(empty($tariffListId)){
						$getTariffId = $tariffListObj->find('first',array('fields'=>array('TariffList.id'),'conditions'=>array('TariffList.name'=>$radData['Radiology']['name'])));
						$tariffListId=$getTariffId['TariffList']['id'];
						if(empty($tariffListId)){
							$tariffListData  = array(
									'location_id'=>'1',
									'name'=>$radData['Radiology']['name'],
									'create_time'=> date('Y-m-d H:i:s'),
									'created_by'=>'1',
									'service_id'=>$this->getServiceGroupId(Configure::read('radiologyservices')));
							$tariffListObj->saveAll($tariffListData); //insert registration and consulation servicde and charges
							$tariffListId = $tariffListObj->getLastInsertID();
						}
						$radiologyObj->updateAll(array('Radiology.tariff_list_id'=>$tariffListId),array('Radiology.id'=>$radData['RadiologyTestOrder']['radiology_id']));
					}
		
					//for patient information
					$getPatientDetails=$patientObj->find('first',array('conditions'=>array('Patient.id'=>$patient_id),'fields'=>array('person_id','lookup_name','form_received_on','admission_type')));
					$personId = $getPatientDetails['Patient']['person_id'];
					$regDate  =  $dateFormatComponentModel->formatDate2Local($getPatientDetails['Patient']['form_received_on'],Configure::read('date_format'),true);
					$doneDate  =  $dateFormatComponentModel->formatDate2Local($radData['RadiologyTestOrder']['radiology_order_date'],Configure::read('date_format'),true);
		
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
								$accountId = $this->getAccountIdOnly(Configure::read('ct_mri_Label'));
								$serviceProviderDetails = $serviceProviderObj->find('first',array('fields'=>array('ServiceProvider.name'),
										'conditions'=>array('ServiceProvider.is_deleted'=>'0','ServiceProvider.id'=>$radData['RadiologyTestOrder']['service_provider_id'])));//service provider name
								$userId = $this->getUserIdOnly($radData['RadiologyTestOrder']['service_provider_id'],'ServiceProvider',$serviceProviderDetails['ServiceProvider']['name']);//for userId
								$radName = $getPrivatePrice['TariffList']['name'];
								$patientName = $getPatientDetails['Patient']['lookup_name'];
								$narration = "Being $radName charged to pt. $patientName (Date of Registration :$regDate) done on $doneDate";//for narration set
		
								$jvData = array('date'=>$radData['RadiologyTestOrder']['radiology_order_date'],
										'location_id'=>'1',
										'account_id'=>$accountId,
										'user_id'=>$userId,
										'billing_id'=>$radData['RadiologyTestOrder']['id'],
										'patient_id'=>$patient_id,
										'type'=>'CTMRI',
										'created_by'=>'1',
										'narration'=>$narration,
										'debit_amount'=>$privatePrice);
								if(!empty($jvData['debit_amount']) && ($jvData['debit_amount'] != 0)){
									$voucherEntryObj->insertJournalEntry($jvData);
									$voucherEntryObj->id = '';
									// ***insert into Account (By) credit manage current balance
									$this->setBalanceAmountByAccountId($accountId,$privatePrice,'debit');
									$this->setBalanceAmountByUserId($useId,$privatePrice,'credit');
								}
								$vrData = array('reference_type_id'=> '2',
										'voucher_id'=> $voucherEntryObj->getLastInsertID(),
										'patient_id'=>$patient_id,
										'voucher_type'=> 'journal',
										'location_id'=> '1',
										'user_id'=> $userId,
										'date' => $radData['RadiologyTestOrder']['radiology_order_date'],
										'amount'=>$privatePrice,
										'credit_period'=>'45',
										'payment_type'=>'Cr',
										'reference_no'=>$voucherEntryObj->getLastInsertID(),
										'parent_id' => '0');
								$voucherReferenceObj->save($vrData);
								$voucherReferenceObj->id='';
							}
					}
					$accountId = $this->getAccountID($personId,'Patient');
					$userId = $this->getUserIdOnly($tariffListId,'TariffList',$radData['Radiology']['name']);
					
					$amountRad = $radData['RadiologyTestOrder']['amount'];
					$radName = $radData['Radiology']['name'];
					$patientName =$getPatientDetails['Patient']['lookup_name'];
					
					if(empty($radData['RadiologyTestOrder']['description'])){
						$narration = "Being $radName charged to pt. $patientName (Date of Registration :$regDate) done on $doneDate";//for narration set
					}else{
						$narration = $radData['RadiologyTestOrder']['description'];
					}
					$jvData = array('date'=>$radData['RadiologyTestOrder']['radiology_order_date'],
							'user_id'=>$userId,
							'billing_id'=>$radData['RadiologyTestOrder']['id'],
							'account_id'=>$accountId['Account']['id'],
							'debit_amount'=>$amountRad,
							'type'=>'Radiology',
							'created_by'=>'1',
							'narration'=>$narration,
							'location_id'=>'1',
							'patient_id'=>$patient_id);
					if(!empty($jvData['debit_amount']) && ($jvData['debit_amount'] != 0)){
						$voucherEntryObj->insertJournalEntry($jvData);
						$voucherEntryObj->id ='';
						// ***insert into Account (By) credit manage current balance
						$this->setBalanceAmountByAccountId($accountId['Account']['id'],$amountRad,'debit');
						$this->setBalanceAmountByUserId($userId,$amountRad,'credit');
					}
				}
			}
		}
		
		/**
		 * jv for ServiceBill function
		 * By amit
		 * @params patient_id
		 * return data
		 */
		public function JVServiceData($patient_id){
			$dateFormatComponentModel = new DateFormatComponent(new ComponentCollection());
			$serviceBillObj = new ServiceBill(null,null,$this->database);
			$patientObj = new Patient(null,null,$this->database);
			$accountObj = new Account(null,null,$this->database);
			$voucherEntryObj = new VoucherEntry(null,null,$this->database);
			$tariffListObj = new TariffList(null,null,$this->database);
			$serviceProviderObj = new ServiceProvider(null,null,$this->database);
			$voucherReferenceObj = new VoucherReference(null,null,$this->database);
			
			$serviceBillObj->bindModel(array(
					'belongsTo' => array(
							'TariffList'=>array('foreignKey' => false,'conditions'=>array('ServiceBill.tariff_list_id=TariffList.id'))
					)),false);
			$serviceBillData =$serviceBillObj->find('all',array('fields'=>array('ServiceBill.no_of_times','ServiceBill.date','ServiceBill.blood_bank',
					'ServiceBill.id','ServiceBill.tariff_list_id','ServiceBill.amount','ServiceBill.description','TariffList.name'),
					'conditions'=>array('ServiceBill.patient_id'=>$patient_id)));
		
			foreach($serviceBillData as $key=> $serviceData){
					
				$totalNo = $serviceData['ServiceBill']['no_of_times'];
				//for patient information
				$getPatientDetails=$patientObj->find('first',array('conditions'=>array('Patient.id'=>$patient_id),'fields'=>array('person_id','lookup_name','form_received_on')));
				$personId = $getPatientDetails['Patient']['person_id'];
				$patientName = $getPatientDetails['Patient']['lookup_name'];
				
				$regDate  =  $dateFormatComponentModel->formatDate2Local($getPatientDetails['Patient']['form_received_on'],Configure::read('date_format'),true);
				$doneDate  =  $dateFormatComponentModel->formatDate2Local($serviceData['ServiceBill']['date'],Configure::read('date_format'),true);
				if(!empty($serviceData['ServiceBill']['blood_bank'])){
					// for accounting service provider name
					$serviceProviderDetails = $serviceProviderObj->find('first',array('fields'=>array('name','cost_to_hospital'),
							'conditions'=>array('ServiceProvider.id'=>$serviceData['ServiceBill']['blood_bank'],'ServiceProvider.is_deleted'=>0)));
					$accountId = $this->getAccountIdOnly(Configure::read('blood_purchased_Label'));//for Account id
					$userId = $this->getUserIdOnly($serviceData['ServiceBill']['blood_bank'],'ServiceProvider',$serviceProviderDetails['ServiceProvider']['name']);//for user id
					$serviceName =$serviceData['TariffList']['name'];
					$narration = "Being $serviceName charged to pt. $patientName (Date of Registration :$regDate) done on $doneDate";
					$jvData = array('date'=>$serviceData['ServiceBill']['date'],
							'billing_id'=> $serviceData['ServiceBill']['id'],
							'patient_id'=>$patient_id,
							'account_id'=>$accountId,
							'user_id'=>$userId,
							'created_by'=>'1',
							'location_id'=>'1',
							'type'=>'Blood',
							'narration'=>$narration,
							'debit_amount'=>$serviceProviderDetails['ServiceProvider']['cost_to_hospital']*($totalNo));
					if(!empty($jvData['debit_amount']) && ($jvData['debit_amount'] != 0)){
						$voucherEntryObj->insertJournalEntry($jvData);
						$voucherEntryObj->id= '';
					}
					$vrData = array('reference_type_id'=> '2',
							'voucher_id'=> $voucherEntryObj->getLastInsertID(),
							'patient_id'=>$patient_id,
							'voucher_type'=> 'journal',
							'location_id'=>'1',
							'user_id'=> $userId,
							'date' => $serviceData['ServiceBill']['date'],
							'amount'=>$serviceProviderDetails['ServiceProvider']['cost_to_hospital']*($totalNo),
							'credit_period'=>'45',
							'payment_type'=>'Cr',
							'reference_no'=>$voucherEntryObj->getLastInsertID(),
							'parent_id' => '0');
					$voucherReferenceObj->save($vrData);
					$voucherReferenceObj->id='';
				}
				//EOF
				$accId = $this->getAccountID($getPatientDetails['Patient']['person_id'],'Patient');//for accounting id
				$accountId = $accId['Account']['id'];
				$getTariffListDetails=$tariffListObj->find('first',array('conditions'=>array('TariffList.id'=>$serviceData['ServiceBill']['tariff_list_id'],'TariffList.is_deleted'=>0),'fields'=>array('name')));//for tariff name
				$userId = $this->getUserIdOnly($serviceData['ServiceBill']['tariff_list_id'],'TariffList',$getTariffListDetails['TariffList']['name']);//for user id
				$totalAmount = $serviceData['ServiceBill']['amount']*($totalNo);
				$tariffListName = $getTariffListDetails['TariffList']['name'];
				if(empty($serviceData['ServiceBill']['description'])){
					$narration = "Being $tariffListName charged to pt. $patientName (Date of Registration :$regDate) done on $doneDate";
				}else{
					$narration = $serviceData['ServiceBill']['description'];
				}
				$jvData = array('date'=> $serviceData['ServiceBill']['date'],
						'billing_id'=>$serviceData['ServiceBill']['id'],
						'account_id'=>$accountId,
						'user_id'=>$userId,
						'created_by'=>'1',
						'location_id'=>'1',
						'debit_amount'=>$totalAmount,
						'narration'=>$narration,
						'type'=>'ServiceBill',
						'patient_id'=>$patient_id);
				if(!empty($jvData['debit_amount']) && ($jvData['debit_amount'] != 0)){
					$voucherEntryObj->insertJournalEntry($jvData);
					$voucherEntryObj->id= '';
					// ***insert into Account (By) credit manage current balance
					$this->setBalanceAmountByAccountId($accountId,$totalAmount,'debit');
					$this->setBalanceAmountByUserId($userId,$totalAmount,'credit');
				}
			}
		}
		
		/**
		 * jv for ConsultantBilling function
		 * By amit
		 * @params patient_id
		 * return data
		 */
		public function JVConsultantData($patient_id){
			$dateFormatComponentModel = new DateFormatComponent(new ComponentCollection());
			$generalComponentModel = new GeneralComponent(new ComponentCollection());
			$patientObj = new Patient(null,null,$this->database);
			$accountObj = new Account(null,null,$this->database);
			$voucherEntryObj = new VoucherEntry(null,null,$this->database);
			$doctorProfileObj = new DoctorProfile(null,null,$this->database);
			$consultantObj = new Consultant(null,null,$this->database);
			$tariffListObj = new TariffList(null,null,$this->database);
			$userObj = new User(null,null,$this->database);
			$tariffStandardObj = new TariffStandard(null,null,$this->database);
			$optAppointmentObj = new OptAppointment(null,null,$this->database);
			$consultantBillingObj = new ConsultantBilling(null,null,$this->database);
			$marketingTeamObj = new MarketingTeam(null,null,$this->database);
			$departmentObj = new Department(null,null,$this->database);
			
			$consultantBillingObj->bindModel(array(
					'belongsTo' => array(
							'TariffList'=>array('foreignKey' => false,'conditions'=>array('ConsultantBilling.consultant_service_id=TariffList.id'))
					)),false);
			$consultant =$consultantBillingObj->find('all',array('fields'=>array('ConsultantBilling.patient_id','ConsultantBilling.consultant_service_id',
					'ConsultantBilling.doctor_id','ConsultantBilling.consultant_id','ConsultantBilling.category_id','ConsultantBilling.date',
					'ConsultantBilling.not_to_pay_dr','ConsultantBilling.description','ConsultantBilling.id','ConsultantBilling.amount','TariffList.name'),
					'conditions'=>array('ConsultantBilling.patient_id'=>$patient_id)));
		
			foreach($consultant as $key=> $consultantData){
				//find person id for updation amount of services and also used some details for narration
				$getPatientDetails=$patientObj->find('first',array('conditions'=>array('Patient.id'=>$consultantData['ConsultantBilling']['patient_id']),'fields'=>array('person_id','lookup_name','form_received_on','admission_type','tariff_standard_id')));
				$consultantDetails = $tariffListObj->find('first',array('conditions'=>array('TariffList.id'=>$consultantData['ConsultantBilling']['consultant_service_id']),'fields'=>array('code_name')));
				$codeName = $consultantDetails['TariffList']['code_name'];
		
				$doctorId = $consultantData['ConsultantBilling']['doctor_id'];
				$consultantId = $consultantData['ConsultantBilling']['consultant_id'];
					
				if($consultantData['ConsultantBilling']['category_id'] == '1'){
					$doctorDetailsAll = $doctorProfileObj->find('first',array('fields'=>array('DoctorProfile.doctor_name','DoctorProfile.user_id'),'conditions'=>array('DoctorProfile.is_deleted'=>'0','DoctorProfile.id'=>$doctorId)));
					$consultantName = $doctorDetailsAll['DoctorProfile']['doctor_name'];
					$userId = $this->getUserIdOnly($doctorDetailsAll['DoctorProfile']['user_id'],'User',$consultantName);
				}else{
					//for external doctor
					$consultantDetails = $consultantObj->find('first',array('fields'=>array('Consultant.first_name','Consultant.last_name','Consultant.id'),'conditions'=>array('Consultant.is_deleted'=>'0','Consultant.id'=>$consultantId)));
					$consultantName = $consultantDetails['Consultant']['first_name']." ".$consultantDetails['Consultant']['last_name'];
					$userId = $this->getUserIdOnly($consultantId,'Consultant',$consultantName);
				}
				$accountId = $this->getAccountIdOnly(Configure::read('surgeryPaymentLabel'));
		
				$regDate  =  $dateFormatComponentModel->formatDate2Local($getPatientDetails['Patient']['form_received_on'],Configure::read('date_format'),true);
				$doneDate  =  $dateFormatComponentModel->formatDate2Local($consultantData['ConsultantBilling']['date'],Configure::read('date_format'),true);
					//BOF for HOPE
					$getPrivateId = $this->getPrivateTariffID('1');
					$getRgjayId = $this->getTariffStandardID('RGJAY');
		
					if(empty($consultantData['ConsultantBilling']['not_to_pay_dr'])){
						if($codeName == 'visit charges'){
							if($getPatientDetails['Patient']['tariff_standard_id'] == $getPrivateId){
								$amount = Configure::read('external_consultant_fees');
							}elseif($getPatientDetails['Patient']['tariff_standard_id'] != $getRgjayId){
								$privatePackageData = $generalComponentModel->getPackageNameAndCost($patient_id);
									
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
					$getTariffName = $this->getTariffStandardName($getPatientDetails['Patient']['tariff_standard_id']);
					$narration = "Being $tariffName charged to pt. $patientName ($getTariffName), Date of Registration :$regDate done on $doneDate";
		
					$jvData = array('date'=>$consultantData['ConsultantBilling']['date'],
							'user_id'=>$userId,
							'account_id'=>$accountId,
							'billing_id'=>$consultantData['ConsultantBilling']['id'],
							'created_by'=>'1',
							'location_id'=>'1',
							'debit_amount'=>$amount,
							'type'=>'VisitCharges',
							'narration'=>$narration,
							'patient_id'=>$patient_id);
					if(!empty($jvData['debit_amount']) && ($jvData['debit_amount'] != 0)){
						$voucherEntryObj->insertJournalEntry($jvData);
						$voucherEntryObj->id= '';
					}
					//EOF jv for Accounting
				//journal entry by amit
				$getAccDetails = $this->getAccountID($getPatientDetails['Patient']['person_id'],'Patient');
				$accId = $getAccDetails['Account']['id'];//for accounting id
					
				$useId = $this->getUserIdOnly($consultantData['ConsultantBilling']['consultant_service_id'],'TariffList',$consultantData['TariffList']['name']);//for user id
				if(empty($consultantData['ConsultantBilling']['description'])){
					$narration = "Being $tariffName charged to pt. $patientName (Date of Registration :$regDate) done on $doneDate";
				}else{
					$narration = $consultantData['ConsultantBilling']['description'];
				}
				$jvData = array('date'=>$consultantData['ConsultantBilling']['date'],
						'user_id'=>$useId,
						'account_id'=>$accId,
						'billing_id'=>$consultantData['ConsultantBilling']['id'],
						'created_by'=>'1',
						'location_id'=>'1',
						'debit_amount'=>$consultantData['ConsultantBilling']['amount'],
						'type'=>'Consultant',
						'narration'=>$narration,
						'patient_id'=>$patient_id);
				if(!empty($jvData['debit_amount']) && ($jvData['debit_amount'] != 0)){
					$voucherEntryObj->insertJournalEntry($jvData);
					$voucherEntryObj->id= '';
				}
			}
		}
		
		/**
		 * jv for pharmacysalebill function
		 * By amit
		 * @params patient_id
		 * return data
		 */
		public function JVSaleBillData($patient_id){
			$dateFormatComponentModel = new DateFormatComponent(new ComponentCollection());
			$patientObj = new Patient(null,null,$this->database);
			$accountObj = new Account(null,null,$this->database);
			$voucherEntryObj = new VoucherEntry(null,null,$this->database);
			$inventoryPharmacySalesReturnObj = new InventoryPharmacySalesReturn(null,null,$this->database);
			$pharmacySalesBillObj = new PharmacySalesBill(null,null,$this->database);
			$pharmacySalesBillDetailObj = new PharmacySalesBillDetail(null,null,$this->database);
			$inventoryPharmacySalesReturnsDetailObj = new InventoryPharmacySalesReturnsDetail(null,null,$this->database);
			
			$pharmacySalesBillObj->unBindModel(array('hasMany'=>array('PharmacySalesBillDetail'),'belongsTo'=>array('Patient','Doctor','Initial')));
			$saleBillData= $pharmacySalesBillObj->find('all',array('fields'=> array('SUM(PharmacySalesBill.total) as TotalAmount','PharmacySalesBill.create_time'),
					'conditions'=>array('PharmacySalesBill.is_deleted'=>'0','PharmacySalesBill.patient_id'=>$patient_id)));
		
			$saleBillReturnData= $inventoryPharmacySalesReturnObj->find('all',array('fields'=> ('SUM(InventoryPharmacySalesReturn.total) as TotalRefundAmount'),
					'conditions'=>array('InventoryPharmacySalesReturn.is_deleted'=>'0','InventoryPharmacySalesReturn.patient_id'=>$patient_id)));
		
			$finalAmount = $saleBillData[0][0]['TotalAmount'] - $saleBillReturnData[0][0]['TotalRefundAmount'];
		
			$accountId = $this->getAccountIdOnly(Configure::read('pharmacy_sale_Label'));//for Account id
			$getPatientDetails=$patientObj->find('first',array('conditions'=>array('Patient.id'=>$patient_id),'fields'=>array('person_id','lookup_name','form_received_on')));
			$personId = $getPatientDetails['Patient']['person_id'];
			$getAccDetails = $this->getAccountID($personId,'Patient');//for user id
			$userId = $getAccDetails['Account']['id'];
		
			$regDate  =  $dateFormatComponentModel->formatDate2Local($getPatientDetails['Patient']['form_received_on'],Configure::read('date_format'),true);
			$doneDate  =  $dateFormatComponentModel->formatDate2Local($saleBillData[0]['PharmacySalesBill']['create_time'],Configure::read('date_format'),true);
			$patientName = $getPatientDetails['Patient']['lookup_name'];
			$narration = "Being pharmacy charged to pt. $patientName (Date of Registration $regDate ) done on $doneDate";
		
			$jvData = array('date'=> $saleBillData[0]['PharmacySalesBill']['create_time'],
					'user_id'=>$accountId,
					'account_id'=>$userId,
					'debit_amount'=>$finalAmount,
					'type'=>'PharmacyCharges',
					'narration'=>$narration,
					'created_by'=>'1',
					'location_id'=>'1',
					'patient_id'=>$patient_id);
			if(!empty($jvData['debit_amount']) && ($jvData['debit_amount'] != 0)){
				$voucherEntryObj->insertJournalEntry($jvData);
				$voucherEntryObj->id= '';
		
				// ***insert into Account (By) credit manage current balance
				$this->setBalanceAmountByAccountId($userId,$finalAmount,'debit');
				$this->setBalanceAmountByUserId($accountId,$finalAmount,'credit');
			}
		}
		
		/**
		 * function to return account id from user_id (user_id,service_provider_id,supplier_id etc)
		 * @param  int $user_id
		 * @param  char $type - "serviceProvider","supplier" etc
		 * @return array
		 */
		 public function getAccountID($user_id=null,$type=null){
			$accountObj = new Account(null,null,$this->database);
			if(!$user_id) return false ;
			$result  = $accountObj->find('first',array('conditions'=>array('user_type'=>$type,'system_user_id'=>$user_id),'fields'=>array('id','name')));
			return $result ;
		}
		
		public function getUserIdOnly($user_id=null,$type=null,$name=null){
			$accountObj = new Account(null,null,$this->database);
			if(!$user_id) return false ;
			$resultDetails  = $accountObj->find('first',array('conditions'=>array('system_user_id'=>$user_id,'user_type'=>$type,'is_deleted'=>0),'fields'=>array('id','name')));
			$result = $resultDetails['Account']['id'];
			if(empty($resultDetails)){
				$accountDetalis = array('id'=>$user_id,
						'name'=>$name,
						'type'=>$type); //for tem accounting group
				$result = $this->autoCreationAccount($accountDetalis);
			}
			return $result ;
		}
		
		public function getAccountIdOnly($name=null,$user_type='Account'){
			if(!$name) return false ;
			$accountObj = new Account(null,null,$this->database);
			$resultDetails  = $accountObj->find('first',array('conditions'=>array('name'=>$name,'is_deleted'=>0),'fields'=>array('id')));
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
		
		public function autoCreationAccount($accountDetalis)
		{
			$accountObj = new Account(null,null,$this->database);
			$getExpenseName = Configure::read('acc_expense_group_name');
			$groupId = $this->getAccountingGroupID($getExpenseName['indirect expenses']);
			$accountObj->data['Account']['create_time']=date("Y-m-d H:i:s");
			$accountObj->data['Account']['account_code']='System1';
			$accountObj->data['Account']['status']='Active';
			$accountObj->data['Account']['name']=$accountDetalis['name'];
			$accountObj->data['Account']['user_type']=$accountDetalis['type'];
			$accountObj->data['Account']['system_user_id']=$accountDetalis['id'];
			$accountObj->data['Account']['location_id']='1';
			$accountObj->data['Account']['accounting_group_id']=$groupId;
			$accountObj->save($accountObj->data['Account']);
			return  $accountObj->getLastInsertID();
		}
		
		//return id for all config define name by amit jain
		function getAccountingGroupID($name){
			$accountingGroupObj = new AccountingGroup(null,null,$this->database);
			$result = $accountingGroupObj->find("first",array('fields'=>array('id'),"conditions"=>array('OR'=>array(array("AccountingGroup.code_name"=>$name
					,'AccountingGroup.is_deleted'=>0),
					array("AccountingGroup.name"=>$name,'AccountingGroup.is_deleted'=>0)))));
			return $result['AccountingGroup']['id'];
		}
		
		public function setBalanceAmountByAccountId($acc_id=null,$debit_balance=null,$type=null){
			$accountObj = new Account(null,null,$this->database);
			if($type==debit){
				$getByBalance=$accountObj->find('first',array('conditions'=>array('id'=>$acc_id,'is_deleted'=>0),'fields'=>array('balance')));
				$total=$getByBalance['Account']['balance'] - $debit_balance;
				$accountObj->updateAll(array('balance'=>$total),array('id'=>$acc_id));
			}
		}
		
		public function setBalanceAmountByUserId($use_id=null,$debit_balance=null,$type=null){
			$accountObj = new Account(null,null,$this->database);
			if($type==credit){
				$getToBalance=$accountObj->find('first',array('conditions'=>array('id'=>$use_id,'is_deleted'=>0),'fields'=>array('balance')));
				$totalTo=$getToBalance['Account']['balance'] + $debit_balance;
				$accountObj->updateAll(array('balance'=>$totalTo),array('id'=>$use_id));
			}
		}
		//2nd argument by pankaj w
		function getServiceGroupId($name=null,$location_id=null){
			$serviceCategoryObj = new ServiceCategory(null,null,$this->database);
			$serviceCategoryObj->unBindModel(array('hasMany' => array('ServiceSubCategory')));
			if($name==Configure::read('mandatoryservices')){// do not remove, as we hav kept location ID for mandatory service=0  --yashwant
				$result = $serviceCategoryObj->find("first",array("conditions"=>array("ServiceCategory.name"=>Configure::read($name))));
			}else{
				if(!$location_id){
					$location_id =  '1' ;
				}
				$result = $serviceCategoryObj->find("first",array("conditions"=>array("ServiceCategory.name"=>Configure::read($name),'location_id'=>$location_id)));
			}
			if($result){
				return $result['ServiceCategory']['id'];
			}else{
				return 0;
			}
		}
		
		//BOF Amit, to fetch the tariffstandard name from tariffstandard id
		function getTariffStandardName($id=null){
			$tariffStandardObj = new TariffStandard(null,null,$this->database);
			$result = $tariffStandardObj->find("first",array('fields'=>array('TariffStandard.name'),"conditions"=>array("TariffStandard.id"=>$id,"TariffStandard.is_deleted"=>'0')));
			return $result['TariffStandard']['name'];
		}
		
		//return private ID
		function getPrivateTariffID($locationId){
			$tariffStandardObj = new TariffStandard(null,null,$this->database);
			$privateLabel = Configure::read('privateTariffName') ;
			$result = $tariffStandardObj->find("first",array('fields'=>array('TariffStandard.id'),
					'conditions'=>array('OR'=>array(array("TariffStandard.code_name"=>$privateLabel,'TariffStandard.location_id'=>$locationId),array("TariffStandard.name"=>$privateLabel,'TariffStandard.location_id'=>$locationId)))));
			return $result['TariffStandard']['id'];
		}
		//BOF Atul, to fetch the tariffstandard id from tariffstandard name
		function getTariffStandardID($name=null){
			$tariffStandardObj = new TariffStandard(null,null,$this->database);
			$result = $tariffStandardObj->find("first",array("conditions"=>array("TariffStandard.name"=>Configure::read($name),"TariffStandard.is_deleted"=>'0')));
			return $result['TariffStandard']['id'];
		}
		
		//get tariff_Standard_id from patient_id
		public function getTariffStandardIDByPatient($patient_id=null){
			$patientObj = new Patient(null,null,$this->database);
			if(!$patient_id) return false ;
			$patientObj->unBindModel(array('hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
			$result = $patientObj->find("first",array('fields'=>array('tariff_standard_id'),"conditions"=>array("Patient.id"=>$patient_id)));
			return $result['Patient']['tariff_standard_id'];
		}
		
		//for accounting voucher Log final entry by amit jain
		function addFinalVoucherLogJV($patientId){
			$voucherEntryObj = new VoucherEntry(null,null,$this->database);
			$voucherLogObj = new VoucherLog(null,null,$this->database);
			$accountObj = new Account(null,null,$this->database);
			$patientObj = new Patient(null,null,$this->database);
			$billingObj = new Billing(null,null,$this->database);
			
			$voucherEntryData = $voucherEntryObj->find('all',array('fields'=>array('SUM(VoucherEntry.debit_amount) as TotalAmount'),
					'conditions'=>array('VoucherEntry.patient_id'=>$patientId,'VoucherEntry.type NOT'=>array('VisitCharges','CTMRI','Blood',
							'AnaesthesiaCharges','SurgeryCharges','Discount','ExternalLab','ExternalRad','ExternalConsultant'))));
			$amount = $voucherEntryData['0']['0']['TotalAmount'];
		
			$cashId = $this->getAccountIdOnly(Configure::read('cash'));//for cash id
		
			$getPatientDetails=$patientObj->find('first',array('conditions'=>array('Patient.id'=>$patientId),'fields'=>array('person_id','admission_id','create_time')));//for person id
			$personId = $getPatientDetails['Patient']['person_id'];
		
			$accountDetails = $this->getAccountID($personId,'Patient');//for account id
			$accountId = $accountDetails['Account']['id'];
		
			if(!empty($getPatientDetails['Patient']['create_time'])){
				$createTime = $getPatientDetails['Patient']['create_time'];
			}else{
				$createTime = date("Y-m-d H:i:s");
			}
			//for journal entry in voucher log bye amit
			$voucherLogDataFinalpayment = array('date'=>$createTime,
					'billing_id'=>$billingObj->getLastInsertID(),
					'modified_by'=>'1',
					'created_by'=>'1',
					'create_time'=>$createTime,
					'location_id'=>'1',
					'patient_id'=>$patientId,
					'account_id'=>$cashId,
					'user_id'=>$accountId,
					'type'=>'FinalDischarge',
					'narration'=>'',
					'debit_amount'=>$amount);
			if(!empty($amount) && ($amount != 0)){
				$voucherLogDataFinalpayment['voucher_no']=$getPatientDetails['Patient']['admission_id'];
				$voucherLogDataFinalpayment['voucher_type']="Journal";
				$voucherLogObj->insertVoucherLog($voucherLogDataFinalpayment);
				$voucherLogObj->id ='';
			}
		}
		
		//after revoke nursing, doctor and room charges deleted by amit
		function deleteRevokeJV($patientId){
			
			$voucherEntryObj = new VoucherEntry(null,null,$this->database);
			$voucherLogObj = new VoucherLog(null,null,$this->database);
			$patientObj = new Patient(null,null,$this->database);
			$voucherReferenceObj = new VoucherReference(null,null,$this->database);
				
			if(!empty($patientId)){
				$this->updateRevokeJvAmount($patientId);
			}
			$DischargeJV = $voucherEntryObj->find('all',array('fields'=>array('id'),'conditions'=>array('VoucherEntry.patient_id'=>$patientId,
					'VoucherEntry.type !='=>('Discount'))));
			foreach($DischargeJV as $dataJV){
				$voucherEntryObj->delete($dataJV['VoucherEntry']['id']);
				$voucherEntryObj->id='';
			}
			
			$refferenceV = $voucherReferenceObj->find('first',array('fields'=>array('id'),
							'conditions'=>array('VoucherReference.patient_id'=>$patientId)));
			
				$voucherReferenceObj->delete($refferenceV['VoucherReference']['id']);
				$voucherReferenceObj->id='';
		
			$finalVoucherLog = $voucherLogObj->find('all',array('fields'=>array('id'),
							'conditions'=>array('VoucherLog.patient_id'=>$patientId,'VoucherLog.type'=>'FinalDischarge')));
			foreach($finalVoucherLog as $finalVoucher){
				$voucherLogObj->delete($finalVoucher['VoucherLog']['id']);
				$voucherLogObj->id='';
			}
		}
		
		//after revoke all services charges updated by amit
		function updateRevokeJvAmount($patientId){
	
			$voucherEntryObj = new VoucherEntry(null,null,$this->database);
			$accountObj = new Account(null,null,$this->database);
		
			$jvDetails = $voucherEntryObj->find('all',array('fields'=>array('VoucherEntry.id','VoucherEntry.user_id','VoucherEntry.account_id',
					'VoucherEntry.debit_amount'),
					'conditions'=>array('VoucherEntry.patient_id'=>$patientId,'VoucherEntry.type !='=>('Discount'))));
			foreach($jvDetails as $dataJV){
				$this->setBalanceAmountByAccountId($dataJV['VoucherEntry']['account_id'],$dataJV['VoucherEntry']['debit_amount'],'debit');
				$this->id='';
				$this->setBalanceAmountByUserId($dataJV['VoucherEntry']['user_id'],$dataJV['VoucherEntry']['debit_amount'],'credit');
				$this->id='';
			}
		}
}