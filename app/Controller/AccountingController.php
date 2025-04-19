
<?php
/**
 * Accounting controller
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Accounting Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pankaj Wanjari
 */


App::import('Controller', 'Billings');
class AccountingController extends BillingsController {

	public $name = 'Accounting';
	public $uses = array('Accounting');
	public $helpers = array('Html','Form', 'Js','DateFormat','RupeesToWords','Number','General','JsFusionChart');
	public $components = array('RequestHandler','Email','General','Number');

	public function admin_index(){ 

	}

	public function admin_add(){
			
	}

	public function admin_edit(){
			
	}
	

	//function to create account for each patient encounter
	public function account_creation($id){	
		$this->layout='advance';
		$this->uses = array('AccountingGroup','Account','VoucherReference','VoucherEntry','HrDetail');
		
		if(isset($this->request->data) && !empty($this->request->data)){
				$result  = $this->Account->accountCreation($this->request->data['Account']);
				if(!empty($this->request->data['HrDetail'])){	
						$this->request->data['HrDetail']['user_id']=$result['Account']['id'];
						$this->request->data['HrDetail']['type_of_user']=Configure::read('AccountType');					
						$this->HrDetail->saveData($this->request->data);
					}
				if(!$this->request->data['Account']['id']){
					if($result){
						$this->Session->setFlash(__('Record saved successfully!'),'default',array('class'=>'message'));
					}else{
						$this->Session->setFlash(__('Duplicate Entry Please try again'),'default',array('class'=>'error'));
						$this->redirect(array("action" => "account_creation"));
					}
				}else{
					if($result){
						$this->Session->setFlash(__('Record update successfully!'),'default',array('class'=>'message'));
					}else{
						$this->Session->setFlash(__('Opening Balance Can Not Changed After Any Transaction'),'default',array('class'=>'error'));
					}
				}
				//for showing payable entry need to blank entry in voucher entry table
					if(!empty($this->request->data['VoucherReference'][0]['reference_type_id'])){
						 $jvData = array('date'=>date('Y-m-d H:i:s'),
								'account_id'=>'0',
								'user_id'=>'0',
								'debit_amount'=>'0');
						$this->VoucherEntry->insertJournalEntry($jvData);
						$this->VoucherEntry->id= ''; 
					}
				//EOF
				if(empty($result['Account']['id'])){
					foreach($this->request->data['VoucherReference'] as $key => $value){
						if(!empty($value['reference_type_id'])){
							$value['voucher_id']= $this->VoucherEntry->getLastInsertID() ;
							$value['voucher_type']= 'opening';
							$value['location_id']= $this->Session->read('locationid') ;
							$value['user_id']= $this->Account->getLastInsertID() ;
							$value['date'] = date('Y-m-d H:i:s');
							$value['parent_id'] = '0';
							$value['payment_type']=$value['payment_type'];
							$this->VoucherReference->save($value);
							$this->VoucherReference->id= '';
						}
					}
				}else{
					foreach($this->request->data['VoucherReference'] as $key => $value){
						if(!empty($value['reference_type_id'])){
							$value['voucher_id']= $this->VoucherEntry->getLastInsertID();
							$value['voucher_type']= 'opening';
							$value['location_id']= $this->Session->read('locationid') ;
							$value['user_id']= $result['Account']['id'];
							$value['date'] = date('Y-m-d H:i:s');
							$value['parent_id'] = '0';
							$value['payment_type']=$value['payment_type'];
							$this->VoucherReference->save($value);
							$this->VoucherReference->id= '';
						}
					}
				}
				$this->redirect(array("action" => "index"));
		}
		
		$result = $this->AccountingGroup->find('list',array('fields'=>array('AccountingGroup.id','AccountingGroup.name'),
				'conditions'=>array('AccountingGroup.is_deleted'=>'0','AccountingGroup.location_id'=>$this->Session->read('locationid'),
						'AccountingGroup.user_type NOT'=>array('TariffStandard','Sublocation')),
						'order'=>array('name ASC')));
		$this->set('result',$result);

		if($id == ''){
			$autoId = $this->autoGenratedId();
		}
		$this->set(compact('autoId','id'));
		if(!empty($id)){
			// for reference voucher edit section start by amit
			$dataDetail = $this->VoucherReference->find('all',array('conditions'=>array('VoucherReference.user_id'=>$id,'VoucherReference.status'=>'pending','VoucherReference.voucher_type'=>'opening'),
					'fields'=>array('VoucherReference.*')));
			$this->set('dataDetail',$dataDetail);
			
			$this->data = $this->Account->find('first',array('conditions'=>array('id'=>$id)));
			//BOF-Mahalaxmi for Fetch the hrdetails
			$this->set('hrDetails',$this->HrDetail->findFirstHrDetails($id,Configure::read('AccountType')));
		}
	}

	//function for account_type
	public function account_type($patient_id=null){
		$this->set('patient_id',$patient_id);
			
	}

	//function to create accounting voucher
	public function patient_account_receivable(){
		$this->layout='advance';
		if($this->request->data){
			$patient_id=$this->request->data['Patient']['user_id'];
			$click=1;
		$this->uses = array('NoteDiagnosis','TariffList','TariffStandard','Bed','FinalBilling','InsuranceCompany','SubServiceDateFormat','ServiceBill',
				'Corporate','Service','DoctorProfile','Person','Consultant','User','Patient','ConsultantBilling','SubService',
				'PharmacySalesBill','PharmacySalesBillDetail','InventoryPharmacySalesReturn','InventoryPharmacySalesReturnsDetail','Billing','Icd10pcMaster');


		//if(!$patient_id) $this->redirect($this->referer()) ;
		$this->Patient->unbindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$patientData = $this->Patient->find('first',array('conditions'=>array('id'=>$patient_id),
				'fields'=>array('lookup_name','is_discharge','form_received_on','discharge_date')));
		
		$this->set('patientData',$patientData) ;

		$data = $this->Billing->find('all',array('conditions'=>array('patient_id'=>$patient_id)));
		$this->set('data',$data) ;
		
		$this->ServiceBill->bindModel(array(
				'belongsTo' => array(
						'Icd10pcMaster' =>array('foreignKey' => false,'conditions'=>array('Icd10pcMaster.id=ServiceBill.tariff_list_id' )),
						'FinalBilling' =>array('foreignKey' => false,'conditions'=>array('FinalBilling.patient_id=ServiceBill.patient_id' ))
				)),false);
		$getIpdServices=$this->ServiceBill->find('all',array('conditions'=>array('ServiceBill.patient_id'=>$patient_id),
				'fields'=>array('FinalBilling.*','ServiceBill.date','Icd10pcMaster.ICD10PCS_FULL_DESCRIPTION','Icd10pcMaster.ICD10PCS','Icd10pcMaster.charges')));
		//debug($getIpdServices);exit;
		$this->set('getIpdServices',$getIpdServices);
		$this->set('click',$click);

		//***************************************************************
		//calling generateReceipt function which covers all the billing for patient
		//$this->requestAction( array('controller' => 'billings', 'action' => 'generateReceipt'),array('pass' => array($patient_id)));
		$this->generateReceipt($patient_id);
		//***************************************************************

	}
	}

	/**function to create payment voucher
	 *	arg billing table id
	*/

	public function patient_payment_voucher($billing_id=null){
		//$this->layout = false ;
		$session = new cakeSession();
		$this->uses = array('Patient','Billing','ServiceBill');
		if(!$billing_id) $this->redirect($this->referer()) ;
		$this->Patient->unbindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$patientData = $this->Patient->find('first',array('conditions'=>array('id'=>$patient_id),
				'fields'=>array('lookup_name','is_discharge','form_received_on','discharge_date')));

		//BOF receipt code
		//$this->Patient->unbindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$this->Patient->unbindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$this->Patient->bindModel(array(
				'belongsTo' => array(   'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
						'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
				)),false);
		if($billing_id){
			$billingData = $this->Billing->find('first',array('conditions'=>array('id'=>$billing_id)));
			$patientData = $this->Patient->find('first',array('conditions'=>array('Patient.id'=>$billingData['Billing']['patient_id']), 'fields' => array('lookup_name','is_discharge','form_received_on','discharge_date','PatientInitial.name')));
			$this->set(array('billingData'=>$billingData,'patientData'=>$patientData));
		}
			
		//EOF receipt code

		//BOF IPD billing
		$this->ServiceBill->bindModel(array(
				'belongsTo' => array(
						'Icd10pcMaster' =>array('foreignKey' => false,'conditions'=>array('Icd10pcMaster.id=ServiceBill.tariff_list_id' )),
						'FinalBilling' =>array('foreignKey' => false,'conditions'=>array('FinalBilling.patient_id=ServiceBill.patient_id' ))
				)),false);
		$getIpdServices=$this->ServiceBill->find('all',array('conditions'=>array('ServiceBill.patient_id'=>$billingData['Billing']['patient_id']),
				'fields'=>array("SUM(Icd10pcMaster.charges) as charges" )));
			
		$this->set('getIpdServices',$getIpdServices);
		//EOF IPD billing
		$hospital=$session->read('facility');
		$this->set('hospital',$hospital);

	}


	public function admin_group_creation(){
		$this->layout = 'advance';
		$this->uses = array("AccountingGroup","Account");
		
		$this->set('title_for_layout', __('Manage Group Creation', true));
		if(!empty($this->params->query)){
			$search_ele = $this->params->query  ;//make it get
			if(!empty($search_ele['group_name'])){
				$search_key['AccountingGroup.name like '] = "%".trim($search_ele['group_name']) ;
			}
			$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'conditions'=>array($search_key,'AccountingGroup.is_deleted'=>'0','AccountingGroup.location_id'=>$this->Session->read('locationid')),
				'order' => array('AccountingGroup.name' => 'asc',
					)
				);
			}else{
			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'conditions'=>array('AccountingGroup.is_deleted'=>'0','AccountingGroup.location_id'=>$this->Session->read('locationid')),
					'order' => array('AccountingGroup.name' => 'asc',
					)
				);
			}
			$this->set('data',$this->paginate('AccountingGroup'));
			foreach ($this->paginate('AccountingGroup') as $key=> $countData){
				$countResult[$countData['AccountingGroup']['id']] = $this->Account->getEntryCount($countData['AccountingGroup']['id']);
			}
			$this->set('countResult',$countResult);
		}

	public function admin_group_add(){
		$this->uses=array("AccountingGroup");
		$groupName = $this->AccountingGroup->find('list',array('fields'=>array('id','name'),
				'conditions'=>array('AccountingGroup.is_deleted'=>'0','AccountingGroup.location_id'=>$this->Session->read('locationid')),
				'order'=>array('name' =>'ASC')));
		$this->set('groupName',$groupName);
		if($this->request->data)
		{
			if(empty($this->request->data['AccountingGroup']['parent_id'])){
				$this->request->data['AccountingGroup']['parent_id'] = 0 ;
			}
			
			$result = $this->AccountingGroup->group_add($this->request->data,'');
			
			if($result){
				$this->Session->setFlash(__('Group Added successfully '),'default',array('class'=>'message'));
				$this->redirect(array("action" => "group_creation","admin"=>true));
			}else{
				$this->Session->setFlash(__('Duplicate Entry Please try again'),'default',array('class'=>'error'));
				$this->redirect(array("action" => "group_add","admin"=>true));
			}
		} 	
	}

	public function admin_group_edit($id=null){
		$this->loadModel("AccountingGroup");
		$groupName = $this->AccountingGroup->find('list',array('fields'=>array('id','name'),
				'conditions'=>array('AccountingGroup.id NOT'=>$id,'AccountingGroup.is_deleted'=>'0','AccountingGroup.location_id'=>$this->Session->read('locationid')),
				'order'=>array('name' =>'ASC')));
		$this->set('groupName',$groupName);
		if($this->request->data)
		{
			$this->AccountingGroup->group_add($this->request->data,$id);
			$this->Session->setFlash(__('Group Updated successfully '),'default',array('class'=>'message'));
			$this->redirect(array("action" => "admin_group_creation","admin"=>true));
		}
		if(empty($id))
		{
			$this->redirect($this->referer);
		}
		else{
			$edit=$this->AccountingGroup->find('first',array('conditions'=>array('AccountingGroup.id'=>$id,'AccountingGroup.location_id'=>$this->Session->read('locationid'),'AccountingGroup.is_deleted'=>'0')));
			$this->data=$edit;
		}
	}
	
	
	public function admin_group_delete($id=null){
		$this->uses=array('AccountingGroup','Person');
		$result = $this->AccountingGroup->updateAll(array('is_deleted'=>'1'),array('id'=>$id)) ;
		$result1=$this->AccountingGroup->find('all',array('conditions'=>array('is_deleted'=>'1')));
		$this->redirect(array("action" => "admin_group_creation","admin"=>true));
	}
	// Function For KPI dashBoard

	public function kpiDashboard(){
		//Monthly Patient Visits
		$this->uses=array('Patient','Person');
		$reportYear=date("Y");
		$startDate=$reportYear."-01-01 00:00:00";
		$endDate=$reportYear."-12-31 23:59:59";
		$this->Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$countRecord = $this->Patient->find('all', array('fields' => array('COUNT(*) AS recordcount', 'DATE_FORMAT(form_received_on, "%M-%Y") AS month_reports',
				'Patient.form_received_on', 'Patient.doctor_id','Patient.admission_type','Patient.is_emergency'),'conditions'=>array('Patient.form_received_on <=' => $endDate, 'Patient.form_received_on >=' => $startDate, 'Patient.is_deleted'=>0,'Patient.location_id'=>$this->Session->read('locationid')),
				'group' => array('Patient.person_id')));
		while($endDate>$startDate)
		{
			$yaxis[date("F-Y",strtotime($startDate))]=date("M",strtotime($startDate));
			$expfromdate = explode("-", $startDate);
			$startDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));

		}
		foreach($countRecord as $countRecord)
		{
			$split=explode("-",$countRecord[0]['month_reports']);
			if($countRecord[0]['recordcount']>1)
			{
				$exist[$reportYear][$split[0]]=$exist[$reportYear][$split[0]]+1;
			}
			else{
				$new[$reportYear][$split[0]]=$new[$reportYear][$split[0]]+1;
			}
		}
		$this->set(compact('yaxis','exist','new','reportYear'));
		//end of Patient visits
	 //chart for Revenue cycle
	 $this->uses = array('FinalBilling','Billing');
	 $reportYear="2014";
	 $startDate=$reportYear."-01-01 00:00:00";
	 $endDate=$reportYear."-12-31 23:59:59";
	 $this->FinalBilling->bindModel(array(
	 		'belongsTo' => array(
	 				'Patient' =>array('foreignKey' => false,'conditions'=>array('Patient.id=FinalBilling.patient_id')),
	 				'Billing' =>array('foreignKey' => false,'conditions'=>array('Billing.patient_id=FinalBilling.patient_id')),
	 		)),false);

	 $billingConditions = array('DATE_FORMAT(Billing.date, "%Y-%m") BETWEEN ? AND ?' => array($startDate,$endDate),'Billing.location_id'=>$this->Session->read('locationid'));
	 $billingData = $this->Billing->find('all',array('conditions' => $billingConditions,'fields'=>array('DATE_FORMAT(LAST_DAY(Billing.date),"%d") as DAY','MONTH(Billing.date) as MONTH','SUM(copay_amount) as copay_amount','SUM(primary_insurance_amount) as primary_insurance_amount')
	 		,'group' => array('MONTH')));
	 foreach($billingData as $data)
	 {
	 	$month=date("m");

	 	if($data[0]['MONTH']==$month)
	 	{
	 		$mDial=$data[0]['copay_amount']+$data[0]['primary_insurance_amount'];
	 	}
	 	else
	 	{
	 		$temp=$data[0]['copay_amount']+$data[0]['primary_insurance_amount'];
	 		$yDial=$yDial+$temp;
	 	}

	 }

	 $this->set(compact('mDial','yDial'));
	 //end of chart revenue cycle
	 //Chart for daignosis
	 $this->uses = array('NoteDiagnosis');
	 $commonDiagnosis = $this->NoteDiagnosis->find('all', array(
	 		'fields' => array('COUNT(*) AS recordcount', 'DATE_FORMAT(created, "%M-%Y") AS month_reports',
	 				'NoteDiagnosis.diagnoses_name'),
	 		'conditions'=>array('NoteDiagnosis.created <=' => $endDate, 'NoteDiagnosis.created >=' => $startDate
	 				,'NoteDiagnosis.snowmedid '=>Configure::read('common_diagnosis_kpi')),
	 		'group' => array('NoteDiagnosis.snowmedid')));


	 $otherDiagnosis = $this->NoteDiagnosis->find('all', array(
	 		'fields' => array('COUNT(*) AS recordcount', 'DATE_FORMAT(created, "%M-%Y") AS month_reports',
	 				'NoteDiagnosis.diagnoses_name'),
	 		'conditions'=>array('NoteDiagnosis.created <=' => $endDate, 'NoteDiagnosis.created >=' => $startDate
	 				,'NoteDiagnosis.snowmedid NOT '=>Configure::read('common_diagnosis_kpi')),
	 		'group' => array('NoteDiagnosis.snowmedid ')));

	 foreach($otherDiagnosis as $others)
	 {
	 	$other=$other+$others[0]['recordcount'];
	 }
	 $this->set(compact('commonDiagnosis','other'));
	 //end of diagnosis
	 //chart for Surgery
	 $this->uses=array('OptAppointment','TariffList');
	 $this->OptAppointment->bindModel(array(
	 		'belongsTo'=>array(
	 				'TariffList'=>array('foreignKey'=>false,'conditions'=>array('TariffList.id=OptAppointment.tariff_list_id')))));
	 $SurgeryCount=$this->OptAppointment->find('all',array('fields'=>array('COUNT(*) AS recordcount','TariffList.id','TariffList.short_name'),
	 		'conditions'=>array('OptAppointment.create_time <=' => $endDate, 'OptAppointment.create_time >=' => $startDate,'OptAppointment.location_id'=>$this->Session->read('locationid'),'TariffList.service_category_id'=>Configure::read('servicecategoryid')),
	 		'group'=>array('OptAppointment.tariff_list_id')));
	 //debug($SurgeryCount);exit;
	 $this->set(compact('SurgeryCount'));
	 //end of Surgery

	}

	//end of KPI daschboard


	//function to update payment narration
	function updateNarration($billing_id=null){
		if(!billing_id) $this->redirect($this->referer());
		$this->uses = array('Billing');
		$result = $this->Billing->updateAll(array('narration'=>"'".$this->request->data['accounting']['narration']."'"),array('id'=>$billing_id)) ;
		if($result){
			$this->Session->setFlash(__('Record saved successfully'),'default',array('class'=>'message'));
		}else{
			$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
		}
		$this->redirect($this->referer()) ;
	}

	public function paymentRecieved($fromDate=null,$toDate=null){
		$this->uses = array('FinalBilling','Billing');
		$this->FinalBilling->bindModel(array(
				'belongsTo' => array(
						'Patient' =>array('foreignKey' => false,'conditions'=>array('Patient.id=FinalBilling.patient_id')),
						'Billing' =>array('foreignKey' => false,'conditions'=>array('Billing.patient_id=FinalBilling.patient_id')),
				)),false);
		$fromDate = trim($this->request->data['Billing']['from'],Configure::read('date_format'));
		$toDate = trim($this->request->data['Billing']['to'],Configure::read('date_format'));
		$id = 85;
		$this->patient_info($id);
		if(!empty($fromDate) && !empty($toDate)){
			$fromDate = $this->DateFormat->formatDate2STD($fromDate,Configure::read('date_format'));
			$toDate = $this->DateFormat->formatDate2STD($toDate,Configure::read('date_format'));

			$fromDate = explode(" ",$fromDate);
			if(count($fromDate) > 1)
				$fromDate = $fromDate[0];

			$toDate = explode(" ",$toDate);
			if(count($toDate) > 1)
				$toDate = $toDate[0];
			$conditions = array('Patient.form_received_on BETWEEN ? AND ?' => array($fromDate,$toDate),'FinalBilling.location_id'=>$this->Session->read('locationid'));

		}else{
			$fromDate = date('Y-01-01');
			$toDate = date('Y-12-31');
			$conditions = array('DATE_FORMAT(Patient.form_received_on, "%Y-%M") BETWEEN ? AND ?' => array($fromDate,date('Y-m')),'FinalBilling.location_id'=>$this->Session->read('locationid'));
		}
		/*$finalBillingData = $this->FinalBilling->find('all',array('fields'=>array('FinalBilling.patient_id','date','amount_paid','amount_pending','copay','collected_copay',
		 'amount_pending_ins_company','amount_collected_ins_company'),'conditions'=>$conditions
		));*/
		$billingConditions = array('DATE_FORMAT(Billing.date, "%Y-%m") BETWEEN ? AND ?' => array($fromDate,$toDate),'Billing.location_id'=>$this->Session->read('locationid'));
		$billingData = $this->Billing->find('all',array('conditions' => $billingConditions,'fields'=>array('DATE_FORMAT(LAST_DAY(Billing.date),"%d") as DAY','MONTH(Billing.date) as MONTH','SUM(copay_amount) as copay_amount','SUM(primary_insurance_amount) as primary_insurance_amount')
				,'group' => array('MONTH')));


		//pr($billingData);exit;
		$currency = $this->Session->read('Currency.currency_symbol');
		$xmlString = '<chart caption="Account Receivable Sumamry" xAxisName="Bucket Days" yAxisName="Account Receivable" numberPrefix="'.$currency.'" formatNumberScale="0" bgColor="#262D30" bgAlpha="100" canvasBgColor="1B1B1B" baseFontColor="#fff" toolTipBgColor="1B1B1B" legendBgColor="1B1B1B" showAlternateHGridColor="0" divLineColor="#AFD8F8" divLineAlpha="70" divLineIsDashed="1" showBorder="0" use3DLighting="0" showShadow="0" canvasBaseColor="#1B1B1B" legendBorderColor="#5B6672">';

		$xmCategories = '<categories>';
		$xmlValuesCoPay = '<dataset seriesname="Patient" color="1C4680">';
		$xmlValuesIcPay = '<dataset seriesname="Insurance" color="86201C">';
		$amountCopPay = $amountIc = 0;
		$count = count($billingData) - 1;
		foreach ($billingData as $key=>$data){
			if($key > 3){
				$amountCopPay  = $amountCopPay + (int) $data['0']['copay_amount'];
				$amountIc = $amountIc + (int) $data['0']['primary_insurance_amount'];
				if($key < $count){
					continue;
				}
			}
			
			if($key < 4){
				$xmCategories .= '<category label="'.$this->Billing->graphXIntervalAccountReceivable[$key].'" />';
				$xmlValuesCoPay .= '<set label="' . $data['0']['copay_amount'] . '" value="' . $data['0']['copay_amount'] . '" />';
				$xmlValuesIcPay .= '<set label="' . $data['0']['primary_insurance_amount'] . '" value="' . $data['0']['primary_insurance_amount'] . '" />';
			}else{
				$xmCategories .= '<category label="'.$this->Billing->graphXIntervalAccountReceivable[4].'" />';
				$xmlValuesCoPay .= '<set label="' . $amountCopPay . '" value="' . $amountCopPay . '" />';
				$xmlValuesIcPay .= '<set label="' . $amountIc . '" value="' . $amountIc . '" />';

			}
		}

		//$xmCategories = '<categories>';  $xmlValues = '<dataset>';
		/*foreach ($billingData as $data){
		 $xmCategories .= '<category label="' . $data['0']['MONTH'] . '" />';
		if(!empty($data['0']['copay_amount']))
			$xmlValues .= '<set label="' . $data['0']['copay_amount'] . '" value="' . $data['0']['copay_amount'] . '" />';
		}*/


		$xmCategories .= '</categories>';
		$xmlValuesCoPay .= '</dataset>';
		$xmlValuesIcPay .= '</dataset>';

		$xmlString .= $xmCategories.$xmlValuesCoPay.$xmlValuesIcPay;
		$xmlString .= '</chart>';
		$this->set('xmlValues',$xmlString);

		/*
		 *
		* SELECT MONTH( date ) AS year, year( date ) AS year,SUM(copay_amount)
		FROM billings
		GROUP BY MONTH( date ) , year( date )
		ORDER BY MONTH( date ) DESC , year( date )
		LIMIT 0 , 30

		*/
	}
	
	//function to generate receivable from patient
	//Author : Amit Jain
	function account_receivable(){
		$this->uses=array('User','VoucherEntry','VoucherReference');
		$this->layout='advance';
		
		if($this->request->data)
		{
			$conditions=array();
			$conditions['VoucherReference.user_id']=$this->request->data['VoucherEntry']['user_id'];
				
			if(!empty($this->request->data['VoucherEntry']['from'])){
				$fromDate = $this->DateFormat->formatDate2STDForReport($this->request->data['VoucherEntry']['from'],Configure::read('date_format'))." 00:00:00";
				$conditions['VoucherEntry.date >=']=$fromDate;
				$from=$this->request->data['VoucherEntry']['from'];
			}else{
				$startMonth = Configure::read('startFinancialYear');
				if((int) date('m') > 3){
					$date = date("Y$startMonth");
				}else{
					$date = (date("Y") - 1).date("$startMonth");
				}
				$conditions['VoucherEntry.date >=']=$date.' 00:00:00';
				$dateFrom=$this->DateFormat->formatDate2LocalForReport($date,Configure::read('date_format'));
				$from=$dateFrom;
			}
				
			if(!empty($this->request->data['VoucherEntry']['to'])){
				$toDate = $this->DateFormat->formatDate2STDForReport($this->request->data['VoucherEntry']['to'],Configure::read('date_format'))." 23:59:59";
				$conditions['VoucherEntry.date <=']=$toDate;
				$to=$this->request->data['VoucherEntry']['to'];
			}else{
				$endMonth = Configure::read('endFinancialYear');
				if((int) date('m') <= 3){
					$date = date("Y$endMonth");
				}else{
					$date = (date("Y")+1).date("$endMonth");
				}
				$conditions['VoucherEntry.date <=']=$date.' 23:59:59';
				$dateTo=$this->DateFormat->formatDate2LocalForReport($date,Configure::read('date_format'));
				$to=$dateTo;
			}
		
			$conditions['VoucherEntry.is_deleted']='0';
			$conditions['VoucherReference.reference_type_id !=']= 3;
			$conditions['VoucherReference.status']= 'pending' ;
			$conditions['VoucherReference.payment_type']= 'Dr';
		
			$this->VoucherReference->bindModel(array(
					'belongsTo'=>array('Account'=>array('foreignKey'=>'user_id'),
							'VoucherEntry'=>array('foreignKey'=>false,'type'=>'inner','conditions'=>array('VoucherReference.voucher_id=VoucherEntry.id','VoucherReference.parent_id=0'))),
					'hasMany' =>  array( //for clild references
							'ReferenceChild' => array(
									'className' => 'VoucherReference',
									'foreignKey'   => 'parent_id'))));
		
			$receivableAmt = $this->VoucherReference->find('all',array('fields'=>array('Account.name','VoucherReference.*'),'conditions'=>$conditions,'order'=>array('VoucherReference.date ASC')));
		}else{
		$this->VoucherReference->bindModel(array(
					'belongsTo'=>array('Account'=>array('foreignKey'=>'user_id'),
							'VoucherEntry'=>array('foreignKey'=>false,'type'=>'inner','conditions'=>array('VoucherReference.voucher_id=VoucherEntry.id'))),
					'hasMany' =>  array( //for clild references
							'ReferenceChild' => array(
									'className' => 'VoucherReference',
									'foreignKey'   => 'parent_id'))));
			$receivableAmt = $this->VoucherReference->find('all',array('fields'=>array('Account.name','VoucherEntry.*','VoucherReference.*'),'conditions'=>array('VoucherReference.status'=>'pending',
				 'VoucherEntry.is_deleted=0', 'VoucherReference.payment_type'=>'Dr', 'OR'=>array('VoucherReference.reference_type_id !='=>'3')),'order'=>array('VoucherReference.date ASC')));//for user specific
		}
		$this->set('currency',$this->Session->read('Currency.currency_symbol'));
		$this->set(compact('user','receivableAmt'));
	}
		 
	public function addNewEncounter($patient_id=null){
		$this->uses = array('Encounter','DoctorProfile','Patient','NewInsurance','Department','City','User','FinalBilling');
		if($this->request->query['request'] == 'iframe')
			$this->layout = false;
		$departments=$this->Department->find('list',array('fields'=>array('id','name'),'order' => array('Department.name'),'conditions'=>array('Department.location_id'=>$this->Session->read('locationid'))));
			
		$users=$this->User->find('list',array('fields'=>array('id','full_name'),'order' => array('User.full_name'),'conditions'=>array('User.role_id'=>'70')));
		$cities=$this->City->find('list',array('fields'=>array('id','name'),'order' => array('City.name')));
		$getPatientInfo=$this->Patient->find('first',array('fields'=>array('id','admission_id','lookup_name','form_received_on','discharge_date'),'order' => array('Patient.lookup_name'),'conditions'=>array('Patient.id'=>$patient_id)));
		$getCopayDue=$this->FinalBilling->find('first',array('fields'=>array('id','copay'),'conditions'=>array('FinalBilling.patient_id'=>$patient_id)));
		//debug($getCopayDue);exit;
		$getInsuranceNo=$this->NewInsurance->find('first',array('fields'=>array('id','insurance_number'),'conditions'=>array('NewInsurance.patient_id'=>$patient_id)));
		$this->set('doctors',$this->DoctorProfile->getDoctors());
		if(!empty($this->request->data)){
			if(!empty($this->request->data['Encounter']['service_date']))
				$this->request->data['Encounter']['service_date'] = $this->DateFormat->formatDate2STD($this->request->data['Encounter']['service_date'],Configure::read('date_format'));
			if(!empty($this->request->data['Encounter']['to_date']))
				$this->request->data['Encounter']['to_date'] = $this->DateFormat->formatDate2STD($this->request->data['Encounter']['to_date'],Configure::read('date_format'));
			if(!empty($this->request->data['Encounter']['post_date']))
				$this->request->data['Encounter']['post_date'] = $this->DateFormat->formatDate2STD($this->request->data['Encounter']['post_date'],Configure::read('date_format'));
			if(!empty($this->request->data['Encounter']['payment_post_date']))
				$this->request->data['Encounter']['payment_post_date'] = $this->DateFormat->formatDate2STD($this->request->data['Encounter']['payment_post_date'],Configure::read('date_format'));
			$this->request->data['Encounter']['location_id']=$this->Session->read('locationid');
			$this->request->data['Encounter']['created_by']=$this->Session->read('userid');
			$this->request->data['Encounter']['created_time']=date('Y-m-d H:i:s');
			//debug($this->request->data);exit;
			if ($this->Encounter->save($this->request->data)){
				$lastInsertID = $this->Encounter->getLastInsertID();
				$this->Session->setFlash(__('Encounter saved successfully'),true);
				$this->redirect(array('action'=>'addBeforeClaim',$lastInsertID)); //redirect to second form
			} else {
				$this->Session->setFlash('Unable to add your Encounter.');
			}
		}else
			$EncounterData = $this->Encounter->find('first',array('conditions'=>array('Encounter.patient_id'=>$patient_id)));
		//debug($EncounterData);exit;
		if(!empty($EncounterData)){
			if(!empty($EncounterData['Encounter']['service_date']))
				$EncounterData['Encounter']['service_date'] = $this->DateFormat->formatDate2Local($EncounterData['Encounter']['service_date'],Configure::read('date_format'));
			if(!empty($EncounterData['Encounter']['to_date']))
				$EncounterData['Encounter']['to_date'] = $this->DateFormat->formatDate2Local($EncounterData['Encounter']['to_date'],Configure::read('date_format'));
			if(!empty($EncounterData['Encounter']['post_date']))
				$EncounterData['Encounter']['post_date'] = $this->DateFormat->formatDate2Local($EncounterData['Encounter']['post_date'],Configure::read('date_format'));
			if(!empty($EncounterData['Encounter']['payment_post_date']))
				$EncounterData['Encounter']['payment_post_date'] = $this->DateFormat->formatDate2Local($EncounterData['Encounter']['payment_post_date'],Configure::read('date_format'));
			$this->request->data['Encounter']['location_id']=$this->Session->read('locationid');
			$this->request->data['Encounter']['modified_by']=$this->Session->read('userid');
			$this->request->data['Encounter']['modified_time']=date('Y-m-d H:i:s');
			$this->set('EncounterData',$EncounterData);
		}

		$this->data = $EncounterData;
		$this->set(compact('patient_id','getPatientInfo','getInsuranceNo','departments','cities','users','getCopayDue'));

	}


	public function addBeforeClaim($id){		
		
		//save record
		//redirect
		
		//find record
		
		//set record 
		
	}


	
	//function to make payment voucher for users by pankaj 
	function user_account_payable($user_id){
	 
		$this->uses = array('AccountEmployee','User');
		
		//save payment
		if(!empty($this->request->data['AccountEmployee']['paid_amount'])){
			$result = $this->AccountEmployee->savePayment($this->request->data['AccountEmployee']);
			if($result){
				$this->Session->setFlash(__('Record saved successfully!'),'default',array('class'=>'message'));
			}else{
				$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
			}
			$this->redirect($this->referer()) ;
		}
		
		$this->User->unBindModel( array('belongsTo'=> array('City','State','Country','Role','Initial'))) ;
		
		$startDate =  date('Y').'-01-01' ; 
		$endDate   =  date('Y-m-d') ;
		//retrive user's payment
		$this->User->bindModel(array(
				"belongsTo"=>array(
						"AccountEmployee"=>array("foreignKey"=>false ,'conditions'=>array('User.id=AccountEmployee.user_id','DATE_FORMAT(AccountEmployee.paid_on, "%Y-%m-%d") BETWEEN "'.$startDate.'" AND "'.$endDate.'" ' )),
				))) ;
		$data = $this->User->find('all',array('fields'=>array('payment','User.full_name',"AccountEmployee.paid_amount",'AccountEmployee.paid_on','AccountEmployee.description'),
				'conditions'=>array('User.payment IS NOT NULL','User.id'=>$user_id) ,'order'=>array('AccountEmployee.paid_on Desc'))) ; //temp date filter
		 
		$monthDiff = $this->DateFormat->dateDiff($startDate,$endDate);
		 
		$this->set(array('data'=>$data,'user_id'=>$user_id,'month'=>$monthDiff->m)) ;
	}
	
	//function to make payment to all(employee,consultant,pharmacy, etc) by pankaj 
	function payment_payable(){
		$this->uses = array('AccountEmployee','User');
		$this->User->unBindModel( array('belongsTo'=> array('City','State','Country','Role','Initial'))) ;
		
		$startDate =  date('Y').'-01-01' ; 
		$endDate   =  date('Y-m-d') ;
		//retrive user's payment
		$this->User->bindModel(array(
				"belongsTo"=>array(
						"AccountEmployee"=>array("foreignKey"=>false ,'conditions'=>array('User.id=AccountEmployee.user_id','DATE_FORMAT(AccountEmployee.paid_on, "%Y-%m-%d") BETWEEN "'.$startDate.'" AND "'.$endDate.'" ' )),
				))) ;
		$data = $this->User->find('all',array('fields'=>array('payment','User.full_name',"AccountEmployee.paid_amount",'AccountEmployee.paid_on','AccountEmployee.description'),
				'conditions'=>array('User.payment IS NOT NULL','User.id'=>$user_id) ,'order'=>array('AccountEmployee.paid_on Desc'))) ; //temp date filter
		 
		$monthDiff = $this->DateFormat->dateDiff($startDate,$endDate);
		 
		$this->set(array('data'=>$data,'user_id'=>$user_id,'month'=>$monthDiff->m)) ;
	}
	
	//BOF paymentVelocity-Pooja

	function paymentVelocity(){
		
	
	}
	
	//function to generate report of payment receivable
	//Author : Amit Jain
 	function account_payable($id){
		$this->uses=array('User','VoucherReference');
		$this->layout='advance';
		if($this->request->data)
		{
			$conditions=array();	
			$conditions['VoucherReference.user_id']=$this->request->data['VoucherEntry']['user_id'];
			
			if(!empty($this->request->data['VoucherEntry']['from'])){
				$fromDate = $this->DateFormat->formatDate2STDForReport($this->request->data['VoucherEntry']['from'],Configure::read('date_format'))." 00:00:00";
				$conditions['VoucherEntry.date >=']=$fromDate;
				$from=$this->request->data['VoucherEntry']['from'];
			}else{
				$startMonth = Configure::read('startFinancialYear');
					if((int) date('m') > 3){
						$date = date("Y$startMonth");
					}else{
						$date = (date("Y") - 1).date("$startMonth");
					}
				$conditions['VoucherEntry.date >=']=$date.' 00:00:00';
				$dateFrom=$this->DateFormat->formatDate2LocalForReport($date,Configure::read('date_format'));
				$from=$dateFrom;
			}
			
			if(!empty($this->request->data['VoucherEntry']['to'])){
				$toDate = $this->DateFormat->formatDate2STDForReport($this->request->data['VoucherEntry']['to'],Configure::read('date_format'))." 23:59:59";
				$conditions['VoucherEntry.date <=']=$toDate;
				$to=$this->request->data['VoucherEntry']['to'];
			}else{
				$endMonth = Configure::read('endFinancialYear');
					if((int) date('m') <= 3){
						$date = date("Y$endMonth");
					}else{
						$date = (date("Y")+1).date("$endMonth");
					}
				$conditions['VoucherEntry.date <=']=$date.' 23:59:59';
				$dateTo=$this->DateFormat->formatDate2LocalForReport($date,Configure::read('date_format'));
				$to=$dateTo;
			}
				
			$conditions['VoucherEntry.is_deleted']='0';
			$conditions['VoucherReference.reference_type_id !=']= 3;
			$conditions['VoucherReference.status']= 'pending' ;
			$conditions['VoucherReference.payment_type']= 'Cr';
				
			$this->VoucherReference->bindModel(array(
					'belongsTo'=>array('Account'=>array('foreignKey'=>'user_id'),
							'VoucherEntry'=>array('foreignKey'=>false,'type'=>'inner','conditions'=>array('VoucherReference.voucher_id=VoucherEntry.id','VoucherReference.parent_id=0'))),
					'hasMany' =>  array( //for clild references
							'ReferenceChild' => array(
									'className' => 'VoucherReference',
									'foreignKey'   => 'parent_id'))));
	
			$payable=$this->VoucherReference->find('all',array('fields'=>array('Account.name','VoucherReference.*'),'conditions'=>$conditions,'order'=>array('VoucherReference.date ASC')));
		}else if(!empty($id)){
		$this->VoucherReference->bindModel(array(
					'belongsTo'=>array('Account'=>array('foreignKey'=>'user_id'),
							'VoucherEntry'=>array('foreignKey'=>false,'type'=>'inner','conditions'=>array('VoucherReference.voucher_id=VoucherEntry.id'))),
							//'Account'=>array('foreignKey'=>false,'type'=>'inner','conditions'=>array('VoucherReference.user_id=Account.id'))),
					'hasMany' =>  array( //for clild references
							'ReferenceChild' => array(
									'className' => 'VoucherReference',
									'foreignKey'   => 'parent_id'))));
			$payable=$this->VoucherReference->find('all',array('fields'=>array('Account.*','VoucherEntry.*','VoucherReference.*'),'conditions'=>array('VoucherReference.status'=>'pending',
				 'VoucherEntry.is_deleted=0', 'VoucherReference.payment_type'=>'Cr', 'Account.accounting_sub_group_id'=>$id, 'OR'=>array('VoucherReference.reference_type_id !='=>'3')),'order'=>array('VoucherReference.date ASC')));
		}else{
			$this->VoucherReference->bindModel(array(
					'belongsTo'=>array('Account'=>array('foreignKey'=>'user_id'),
							'VoucherEntry'=>array('foreignKey'=>false,'type'=>'inner','conditions'=>array('VoucherReference.voucher_id=VoucherEntry.id'))),
					'hasMany' =>  array( //for clild references
							'ReferenceChild' => array(
									'className' => 'VoucherReference',
									'foreignKey'   => 'parent_id'))));
			$payable=$this->VoucherReference->find('all',array('fields'=>array('Account.name','VoucherEntry.*','VoucherReference.*'),'conditions'=>array('VoucherReference.status'=>'pending',
				 'VoucherEntry.is_deleted=0', 'VoucherReference.payment_type'=>'Cr', 'OR'=>array('VoucherReference.reference_type_id !='=>'3')),'order'=>array('VoucherReference.date ASC')));//for user specific
		}
		$this->set('currency',$this->Session->read('Currency.currency_symbol'));
		$this->set(compact('user','payable'));
	} 
	//*******************
	
	
	//BOF For Consultant Account Payable-Pooja
	function consultant_account_payable($consultant_id){
		$this->uses=array('Consultant','JournalEntryConsultant');
		$user=$this->Consultant->find('all',array('conditions'=>array('Consultant.id'=>$consultant_id)));
		if($this->request->data)
		{	
			$from = $this->DateFormat->formatDate2STDForReport($this->request->data['JournalEntryConsultant']['from'],Configure::read('date_format'))." 00:00:00";
			$to = $this->DateFormat->formatDate2STDForReport($this->request->data['JournalEntryConsultant']['to'],Configure::read('date_format'))." 23:59:59";
			$payable=$this->JournalEntryConsultant->find('all',array('conditions'=>array('JournalEntryConsultant.user_id'=>$consultant_id,'JournalEntryConsultant.date >='=>$from,'JournalEntryConsultant.date <='=>$to)));
		}
		else{
	
			$payable=$this->JournalEntryConsultant->find('all',array('conditions'=>array('JournalEntryConsultant.user_id'=>$consultant_id)));
		}
		$this->set('currency',$this->Session->read('Currency.currency_symbol'));
		$this->set(compact('user','payable'));
	
	
	}
	//EOF consultant_account_payable
	
	//BOF For Supplier Account Payable-Pooja
	function supplier_account_payable($supplier_id){
		$this->uses=array('InventorySupplier','JournalEntrySupplier');
		$user=$this->InventorySupplier->find('all',array('conditions'=>array('InventorySupplier.id'=>$supplier_id)));
		if($this->request->data)
		{
			$from = $this->DateFormat->formatDate2STDForReport($this->request->data['JournalEntrySupplier']['from'],Configure::read('date_format'))." 00:00:00";
			$to = $this->DateFormat->formatDate2STDForReport($this->request->data['JournalEntrySupplier']['to'],Configure::read('date_format'))." 23:59:59";
			$payable=$this->JournalEntrySupplier->find('all',array('conditions'=>array('JournalEntrySupplier.user_id'=>$supplier_id,'JournalEntrySupplier.date >='=>$from,'JournalEntrySupplier.date <='=>$to)));
		}
		else{
			$payable=$this->JournalEntrySupplier->find('all',array('conditions'=>array('JournalEntrySupplier.user_id'=>$supplier_id)));
		}
		$this->set('currency',$this->Session->read('Currency.currency_symbol'));
		$this->set(compact('user','payable'));
	}
	//EOF supplier_account_payable
	//BOF For Supplier Account Payable-Pooja
	function service_provider_account_payable($service_id){
		$this->uses=array('ServiceProvider','JournalEntryServiceProvider');
		$user=$this->ServiceProvider->find('all',array('conditions'=>array('ServiceProvider.id'=>$service_id)));
		if($this->request->data)
		{
			$from = $this->DateFormat->formatDate2STDForReport($this->request->data['JournalEntryServiceProvider']['from'],Configure::read('date_format'))." 00:00:00";
			$to = $this->DateFormat->formatDate2STDForReport($this->request->data['JournalEntryServiceProvider']['to'],Configure::read('date_format'))." 23:59:59";
			$payable=$this->JournalEntryServiceProvider->find('all',array('conditions'=>array('JournalEntryServiceProvider.user_id'=>$service_id,'JournalEntryServiceProvider.date >='=>$from,'JournalEntryServiceProvider.date <='=>$to)));
		}
		else{
	
			$payable=$this->JournalEntryServiceProvider->find('all',array('conditions'=>array('JournalEntryServiceProvider.user_id'=>$service_id)));
		}
		$this->set('currency',$this->Session->read('Currency.currency_symbol'));
		$this->set(compact('user','payable'));
	}
	//EOF supplier_account_payable
	//BOF for deleting account
	public function delete($id = null) {
		$this->uses=array('Account');
		$this->set('title_for_layout', __('- Delete Account', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Account'),'default',array('class'=>'error'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Account->delete($id)) {
			$this->Session->setFlash(__('Account successfully deleted'),'default',array('class'=>'message'));
			$this->redirect(array('action'=>'index'));
		}
	}
	
	/**
	 * function to delete Payment entry and Voucher log entry
	 * @param  int $id
	 * @author Amit Jain
	 */
	public function voucher_delete($id) {
		$this->uses=array('VoucherPayment','Account','VoucherLog');
		$this->set('title_for_layout', __('- Delete Account', true));
		if (empty($id)){
			$this->Session->setFlash(__('Invalid id for Payment Voucher'),'default',array('class'=>'error'));
			$this->redirect(array('action'=>'legder_voucher'));
		}else{
			$paymentDetails = $this->VoucherPayment->find('first',array('fields'=>array('paid_amount','user_id','account_id'),
					'conditions'=>array('VoucherPayment.id'=>$id)));
		//===============================================================BOF Update Balance into Account===================================================//
			$this->Account->setBalanceAmountByAccountId($paymentDetails['VoucherPayment']['user_id'],$paymentDetails['VoucherPayment']['paid_amount'],'debit');
			$this->Account->setBalanceAmountByUserId($paymentDetails['VoucherPayment']['account_id'],$paymentDetails['VoucherPayment']['paid_amount'],'credit');
		//===============================================================BOF Update Balance into Account===================================================//
		//===============================================================BOF Get Voucher Id================================================================//
				$voucherId = $this->VoucherLog->getVoucherId($id,'Payment');
		//================================================================EOF Get Voucher Id===============================================================//
		
		//=======================================================BOF Delete Entry from Voucher Entry & Voucher Log=========================================//
			$this->VoucherPayment->updateAll(array('VoucherPayment.is_deleted'=>'1'),array('VoucherPayment.id'=>$id));
			$this->VoucherPayment->id='';
			if(!empty($voucherId)){
				$this->VoucherLog->updateAll(array('VoucherLog.is_deleted'=>'1'),array('VoucherLog.id'=>$voucherId));
				$this->VoucherLog->id='';
			}
			$this->Session->setFlash(__('Payment Voucher successfully deleted'),'default',array('class'=>'message'));
			$this->redirect(array('action'=>'legder_voucher'));
		//=======================================================BOF Delete Entry from Voucher Entry & Voucher Log=========================================//
		}
	}
	
	
	/**
     * function to delete journal entry and voucher log entry
     * @param  int $id
     * @author Amit Jain
     */
	public function journal_delete($id) {
		$this->uses=array('VoucherEntry','Account','VoucherLog');
		$this->set('title_for_layout', __('- Delete Account', true));
		if(empty($id)){
			$this->Session->setFlash(__('Invalid id for Journal Entry'),'default',array('class'=>'error'));
			$this->redirect(array('action'=>'legder_voucher'));
		}else{
			$journalDetails = $this->VoucherEntry->find('first',array('fields'=>array('VoucherEntry.debit_amount','VoucherEntry.user_id',
					'VoucherEntry.account_id','VoucherEntry.batch_identifier'),
						'conditions'=>array('VoucherEntry.id'=>$id)));
			if($journalDetails['VoucherEntry']['batch_identifier'] != null){
				$journalDetailsAll = $this->VoucherEntry->find('all',array('fields'=>array('VoucherEntry.debit_amount','VoucherEntry.user_id',
						'VoucherEntry.account_id','VoucherEntry.batch_identifier'),
						'conditions'=>array('VoucherEntry.batch_identifier'=>$journalDetails['VoucherEntry']['batch_identifier'])));
				foreach ($journalDetailsAll as $key=> $data){
					$this->Account->setBalanceAmountByAccountId($data['VoucherEntry']['account_id'],$data['VoucherEntry']['debit_amount'],'debit');
					$this->Account->setBalanceAmountByUserId($data['VoucherEntry']['user_id'],$data['VoucherEntry']['debit_amount'],'credit');
				}
				$voucherId = $this->VoucherLog->getVoucherId(null,'Journal',$journalDetails['VoucherEntry']['batch_identifier']);
				$this->VoucherEntry->updateAll(array('VoucherEntry.is_deleted'=>'1'),array('VoucherEntry.batch_identifier'=>$journalDetails['VoucherEntry']['batch_identifier']));
				$this->VoucherEntry->id='';
				if(!empty($voucherId)){
					$this->VoucherLog->updateAll(array('VoucherLog.is_deleted'=>'1'),array('VoucherLog.id'=>$voucherId));
					$this->VoucherLog->id='';
				}
				$this->Session->setFlash(__('Journal Entry successfully deleted'),'default',array('class'=>'message'));
				$this->redirect(array('action'=>'legder_voucher'));
			}else{
			//================================================================BOF Update Balance into Account===========================================//
				$this->Account->setBalanceAmountByAccountId($journalDetails['VoucherEntry']['account_id'],$journalDetails['VoucherEntry']['debit_amount'],'debit');
				$this->Account->setBalanceAmountByUserId($journalDetails['VoucherEntry']['user_id'],$journalDetails['VoucherEntry']['debit_amount'],'credit');
			//=================================================================EOF Update Balance into Account===========================================//
			
			//=====================================================================BOF Get Voucher Id=====================================================//
				$voucherId = $this->VoucherLog->getVoucherId($id,'Journal');
			//===================================================================EOF Get Voucher Id=====================================================//
			
			//================================================BOF Delete Entry from Voucher Entry & Voucher Log=========================================//
				$this->VoucherEntry->updateAll(array('VoucherEntry.is_deleted'=>'1'),array('VoucherEntry.id'=>$id));
				$this->VoucherEntry->id='';
				if(!empty($voucherId)){
					$this->VoucherLog->updateAll(array('VoucherLog.is_deleted'=>'1'),array('VoucherLog.id'=>$voucherId));
					$this->VoucherLog->id='';
				}
				$this->Session->setFlash(__('Journal Entry successfully deleted'),'default',array('class'=>'message'));
				$this->redirect(array('action'=>'legder_voucher'));
				}
			//================================================EOF Delete Entry from Voucher Entry & Voucher Log=========================================//
		}
	}
	
	//for journal voucher 
	function journal_entry($id,$isPayment = null){
		$this->uses=array('VoucherEntry','VoucherReference','Account','VoucherLog');
		$this->set('isPayment',$isPayment);
		if($isPayment == 'isPayment'){
			$this->layout = 'advance_ajax';
		}else{
			$this->layout = 'advance' ;
		}
		
		$lastIdDetails = $this->VoucherEntry->find('first',array('fields'=>array('id'),'order'=>array('id' =>'DESC')));
		$lastID= ($lastIdDetails['VoucherEntry']['id'] +1);
		$this->set('jv_no',$lastID);
		$this->set('id',$id);
		
		if(isset($this->request->data) && !empty($this->request->data)){
			if(!empty($this->request->data['VoucherEntry']['batch_identifier'])){
				$journalDetailsAll = $this->VoucherEntry->find('all',array('fields'=>array('VoucherEntry.debit_amount','VoucherEntry.user_id',
						'VoucherEntry.account_id','VoucherEntry.batch_identifier'),
						'conditions'=>array('VoucherEntry.batch_identifier'=>$this->request->data['VoucherEntry']['batch_identifier'])));
				foreach ($journalDetailsAll as $key=> $data){
					$this->Account->setBalanceAmountByAccountId($data['VoucherEntry']['account_id'],$data['VoucherEntry']['debit_amount'],'debit');
					$this->Account->setBalanceAmountByUserId($data['VoucherEntry']['user_id'],$data['VoucherEntry']['debit_amount'],'credit');
				}
				$voucherId = $this->VoucherLog->getVoucherId(null,'Journal',$this->request->data['VoucherEntry']['batch_identifier']);
				$this->VoucherEntry->updateAll(array('VoucherEntry.is_deleted'=>'1'),array('VoucherEntry.batch_identifier'=>$this->request->data['VoucherEntry']['batch_identifier']));
				$this->VoucherEntry->id='';
				if(!empty($voucherId)){
					$this->VoucherLog->updateAll(array('VoucherLog.is_deleted'=>'1'),array('VoucherLog.id'=>$voucherId));
					$this->VoucherLog->id='';
				}
			}
			$this->request->data["VoucherEntry"]['date'] = $this->DateFormat->formatDate2STD($this->request->data["VoucherEntry"]['date'],Configure::read('date_format'));
			$this->request->data["VoucherEntry"]["batch_identifier"]=strtotime(date("Y-m-d H:i:s"));
			
			if($this->request->data['VoucherEntry']['debit_field']>=$this->request->data['VoucherEntry']['credit_field']){
				$foreach=$this->request->data['VoucherEntry']['debit'];
			}else{
				$foreach=$this->request->data['VoucherEntry']['credit'];
			}
			foreach($foreach as $key=>$users){
			if($this->request->data['VoucherEntry']['debit_field']>=$this->request->data['VoucherEntry']['credit_field']){
				//multiple debit ie multiple account id and single user id
				$userId=$this->request->data['VoucherEntry']['credit'][1]['user_id'];
				$this->request->data['VoucherEntry']['user_id']=$userId;
				$this->request->data["VoucherEntry"]['account_id']=$users['account_id'];
				$this->request->data["VoucherEntry"]['debit_amount']=$users['debit_amount'];
				$this->request->data["VoucherEntry"]['total']+=$users['debit_amount'];
			}else{
				//multiple credit ie multiple user id and single account id
				$account_id=$this->request->data['VoucherEntry']['debit'][1]['account_id'];
				$this->request->data['VoucherEntry']['user_id']=$users['user_id'];
				$this->request->data["VoucherEntry"]['account_id']=$account_id;
				$this->request->data["VoucherEntry"]['debit_amount']=$users['credit_amount'];
				$this->request->data["VoucherEntry"]['total']+=$users['credit_amount'];
			}
				$this->request->data["VoucherEntry"]["system_ip_address"] = $this->request->clientIp();
				$result = $this->VoucherEntry->insertJournalEntry($this->request->data['VoucherEntry']);
				$errors = $this->VoucherEntry->invalidFields();
				if(!empty($errors)) {
					$this->set("errors", $errors);
				} else {
				if(empty($this->request->data["VoucherEntry"]['id'])){
					$paymentEntry =  $this->VoucherEntry->getLastInsertID();
				}else{
					$paymentEntry = $this->request->data["VoucherEntry"]['id'];
				}

				//insert into voucher log ntable - Pankaj M
				if(!empty($this->request->data["VoucherLog"]['id'])){
					$this->request->data['VoucherEntry']['id'] = $this->request->data["VoucherLog"]['id'];
				}
				$this->request->data['VoucherEntry']['voucher_id']=$paymentEntry;
				$this->request->data['VoucherEntry']['voucher_type']="Journal";
				$this->request->data['VoucherEntry']['type']="USER";
				$this->request->data['VoucherEntry']['voucher_no']=$this->request->data['VoucherEntry']['journal_voucher_no'];
				//end
				
				$locationid = $this->Session->read('locationid') ;
				$jvdebit=0;
				foreach($this->request->data["VoucherReference"][$key] as $refKey => $voucherRefrence  ){
					$jvdebit=$jvdebit+$voucherRefrence['amount'];
					if(!empty ($voucherRefrence['reference_type_id'])){
					$voucherRefrence['id']= $voucherRefrence['id'] ;
					$voucherRefrence['voucher_id']= $paymentEntry ;
					$voucherRefrence['voucher_type']= 'journal';
					$voucherRefrence['location_id']= $locationid ;
					$voucherRefrence['account_id']= $this->request->data["VoucherEntry"]['account_id'];
					$voucherRefrence['user_id']= $this->request->data["VoucherEntry"]['user_id'] ;
					$voucherRefrence['date']= $this->request->data["VoucherEntry"]['date'] ;
					$voucherRefrence['parent_id'] =	$voucherRefrence["voucher_reference_id"] ? $voucherRefrence["voucher_reference_id"] : '0';
						if(!empty($voucherRefrence["voucher_reference_id"])){  
					  	 
					  		$getdata = $this->VoucherReference->find('first',array('fields'=>array('VoucherReference.amount','VoucherReference.paid_amount','VoucherReference.voucher_type'),'conditions'=>array('VoucherReference.id'=>$voucherRefrence["voucher_reference_id"]))) ;
	 	 					$diff = ($getdata['VoucherReference']['amount'] - $voucherRefrence['amount']);   
					  		//update prev entry
					  		$prev['pending_amount'] = $diff ;
					  		$prev['paid_amount'] = $voucherRefrence['amount'];
					  		$prev['voucher_type']=$getdata['VoucherReference']['voucher_type'];
					  		$prev['status'] = 'nil' ;
					  		$prev['id'] = $voucherRefrence["voucher_reference_id"] ;
							$this->VoucherReference->save($prev) ;
							$this->VoucherReference->id='' ;
							$voucherRefrence['voucher_type']=$getdata['VoucherReference']['voucher_type'];						
							//EOF prev entry update 
					  		$voucherRefrence['amount'] = $prev['pending_amount'];
					  }
					  if($voucherRefrence['amount']<0){
					  	$voucherRefrence['amount']=-($voucherRefrence['amount']);
					  	$voucherRefrence['voucher_type']='journal';
					  }
					  $voucherRefrence['pending_amount'] = $voucherRefrence['amount'] - $voucherRefrence['paid_amount'] ;
					  $finalRefArray[] = $voucherRefrence ;
					  $voucherRefrence='';
					}
					 // calculate total jv amt according to voucher ref-pooja
				}
				
				if($prev['pending_amount'] == '0.00'){
					
				}else{
					$resultReference=$this->VoucherReference->saveAll($finalRefArray);
				}
			// ***insert into Account 	 (Debit)
				$acc_id = $this->request->data['VoucherEntry']['account_id'];
				$use_id = $this->request->data['VoucherEntry']['user_id'];
				$bal = $this->request->data['VoucherEntry']['debit_amount'];
				
				$this->Account->setBalanceAmountByAccountId($use_id,$bal,'debit',$this->request->data['VoucherEntry']['previous_paid_amount']);
				$this->Account->setBalanceAmountByUserId($acc_id,$bal,'credit',$this->request->data['VoucherEntry']['previous_paid_amount']);
				
				//	***	
				if(!$this->request->data['VoucherReference'][0]['id']){
					if($result || $resultReference){
						$this->Session->setFlash(__('Record saved successfully!'),'default',array('class'=>'message'));
					}else{
						$this->Session->setFlash(__('Record saved successfully!'),'default',array('class'=>'error'));
					}
				}else{
					if($result || $resultReference){
						$this->Session->setFlash(__('Record update successfully!'),'default',array('class'=>'message'));
					}else{
						$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
					}
				}
				}
				$finalRefArray='';
			}//Foreach Loop Users -Pooja
			$this->VoucherLog->insertJvLog($this->request->data['VoucherEntry']);
			$this->redirect(array('action'=>'journal_entry'));
		}
			// edit section start
			$this->VoucherEntry->bindModel(array(
					"belongsTo"=>array(
							"Account"=>array("foreignKey"=>false ,'conditions'=>array('Account.id=VoucherEntry.user_id')),
							"AccountAlias"=>array('className'=>'Account',"foreignKey"=>false ,'conditions'=>array('AccountAlias.id=VoucherEntry.account_id')),
							"VoucherLog"=>array("foreignKey"=>false ,'conditions'=>array('VoucherLog.voucher_id=VoucherEntry.id','VoucherLog.voucher_type'=>"Journal"))),
					'hasMany' =>  array( //for clild references
							'VoucherReference' => array(
							'foreignKey'   => 'voucher_id','conditions'=>array('VoucherReference.voucher_type="journal"','VoucherReference.voucher_id'=>$id/* ,
									'VoucherReference.Patient_id'=>null */)))));			
			$dataDetail = $this->VoucherEntry->find('first',array('conditions'=>array('VoucherEntry.id'=>$id,'VoucherEntry.is_deleted'=>0),
					'fields'=>array('VoucherEntry.id','VoucherEntry.date','VoucherEntry.account_id','VoucherEntry.debit_amount','VoucherEntry.dr_narration',
							'VoucherEntry.user_id','VoucherEntry.cr_narration','VoucherEntry.narration','Account.name','Account.balance','AccountAlias.name',
							'AccountAlias.balance','VoucherLog.id')));
			if(!empty($dataDetail['VoucherEntry']['date'])){
				$dataDetail['VoucherEntry']['date']=$this->DateFormat->formatDate2Local($dataDetail['VoucherEntry']['date'],Configure::read('date_format'),true);
			}
			if($dataDetail['Account']['balance'] < 0 ){
				$dataDetail['Account']['balance']=$this->Number->currency(ceil($dataDetail['Account']['balance']*(-1)))." Cr";
			}else{
				$dataDetail['Account']['balance']=$this->Number->currency(ceil($dataDetail['Account']['balance']))." Dr";
			}
			if($dataDetail['AccountAlias']['balance'] < 0 ){
				$dataDetail['AccountAlias']['balance']=$this->Number->currency(ceil($dataDetail['AccountAlias']['balance']*(-1)))." Cr";
			}else{
				$dataDetail['AccountAlias']['balance']=$this->Number->currency(ceil($dataDetail['AccountAlias']['balance']))." Dr";
			}
			$this->data= $dataDetail ;
			$this->set('dataDetail',$dataDetail);
		}
	
	public function payment_voucher($id){
		$this->layout='advance';
		$this->uses = array('VoucherPayment','Account','VoucherLog','Message','Configuration');
		$lastIdDetails = $this->VoucherPayment->find('first',array('fields'=>array('id'),'order'=>array('id' =>'DESC')));
		$lastID= ($lastIdDetails['VoucherPayment']['id'] +1);
		$this->set('pv_no',$lastID);
		$this->set('id',$id);
		$locationid = $this->Session->read('locationid');
	
		if(isset($this->request->data) && !empty($this->request->data)){
			
		$this->request->data["VoucherPayment"]['date'] = $this->DateFormat->formatDate2STD($this->request->data["VoucherPayment"]['date'],Configure::read('date_format'));
		$userid = $this->Session->read('userid');
		$this->request->data["VoucherPayment"]["create_by"]  = $userid;
		$this->request->data["VoucherPayment"]["modified_by"] = $userid;
		$this->request->data["VoucherPayment"]["location_id"] = $locationid;
		$this->request->data['VoucherPayment']['batch_identifier']=strtotime(date('Y-m-d H:i:s'));//batch identifier --pooja
		//for multiple users or parties -Pooja
		foreach($this->request->data['VoucherPayment']['user'] as $key=>$users){					
			$this->request->data["VoucherPayment"]["create_time"]=date("Y-m-d H:i:s", strtotime("+1 minutes"));
			if(empty($users['user_id'])){
				$this->request->data['VoucherPayment']['user_id']=$users['staff_user_id'];
				$users['user_id'] = $users['staff_user_id'];
			}else{
				$this->request->data['VoucherPayment']['user_id']=$users['user_id'];
			}
			$this->request->data['VoucherPayment']['paid_amount']=$users['paid_amount'];
			$this->request->data["VoucherPayment"]["system_ip_address"] = $this->request->clientIp();
			$result=$this->VoucherPayment->save($this->request->data["VoucherPayment"]);
			
			$errors = $this->VoucherPayment->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
				///BOF-Mahalaxmi-For send SMS to Owner								
				$smsActive=$this->Configuration->getConfigSmsValue('Payment Voucher');				
				if($smsActive){							
					if(!empty($users['user_id']) && !empty($users['paid_amount'])){
						$accountSmsData = $this->Account->find('first',array('fields'=>array('Account.name'),'conditions'=>array('Account.id'=>$users['user_id'])));	
						$accountSmsData['Account']['name'] = str_replace ('&','and', $accountSmsData['Account']['name']);	
					if(!empty($this->request->data["VoucherPayment"]['narration'])){		
						$this->request->data["VoucherPayment"]['narration'] = str_replace ('&','and', $this->request->data["VoucherPayment"]['narration']);
					$showMsg= sprintf(Configure::read('payment_voucher_with_narration'),$users['paid_amount'],$accountSmsData['Account']['name'],$this->request->data["VoucherPayment"]['narration']);	
					}else{					
						$showMsg= sprintf(Configure::read('payment_voucher'),$users['paid_amount'],$accountSmsData['Account']['name']);		
					}				
					$this->Message->sendToSms($showMsg,Configure::read('owner_no'));
				//	$this->Patient->sendToSmsOwner($getLastId,'PaymentVoucher');	
					}
				}
				
				///EOF-Mahalaxmi-For send SMS to Owner				
				if(empty($this->request->data["VoucherPayment"]['id'])){
					$paymentEntry =  $this->VoucherPayment->getLastInsertID();
				}else{
					$paymentEntry = $this->request->data["VoucherPayment"]['id'];
				} 

				//insert into voucher log ntable - Pankaj M
				if(!empty($this->request->data["VoucherLog"]['id'])){
					$this->request->data["VoucherPayment"]['id'] = $this->request->data["VoucherLog"]['id'];
				}
				$this->request->data['VoucherPayment']['voucher_id']=$paymentEntry;
				$this->request->data['VoucherPayment']['voucher_type']="Payment";
				$this->request->data['VoucherPayment']['voucher_no']=$paymentEntry; //for voucher no. amit
				$this->VoucherLog->insertVoucherLog($this->request->data["VoucherPayment"]);
				//end
			
				// ***insert into Account (By) credit manage current balance
				$accountId = $this->request->data['VoucherPayment']['account_id'];
				$userId = $this->request->data['VoucherPayment']['user_id'];
				$this->Account->setBalanceAmountByAccountId($accountId,$this->request->data['VoucherPayment']['paid_amount'],'debit',$users['previous_paid_amount']);
				$this->Account->setBalanceAmountByUserId($userId,$this->request->data['VoucherPayment']['paid_amount'],'credit',$users['previous_paid_amount']);
			
				if(empty($this->request->data["VoucherLog"]['id'])){
					if($result){
						$this->Session->setFlash(__('Record saved successfully!'),'default',array('class'=>'message'));
					}else{
						$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
					}
				}else{
					if($result){
						$this->Session->setFlash(__('Record update successfully!'),'default',array('class'=>'message'));
					}else{
						$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
					}
				}
				$this->set(array('lastInsertID'=>$paymentEntry,'action'=>'print'));
				}
				
		}//Foreach Loop Users -Pooja
		
	} 
		// edit section start
		$this->VoucherPayment->bindModel(array(
					"belongsTo"=>array(
							"Account"=>array("foreignKey"=>false ,'conditions'=>array('Account.id=VoucherPayment.user_id')),
							"AccountAlias"=>array('className'=>'Account',"foreignKey"=>false ,'conditions'=>array('AccountAlias.id=VoucherPayment.account_id')),
							"VoucherLog"=>array("foreignKey"=>false ,'conditions'=>array('VoucherLog.voucher_id=VoucherPayment.id','VoucherLog.voucher_type'=>"Payment")))
				));
		if(!empty($id)){
			$dataDetail = $this->VoucherPayment->find('first',array('conditions'=>array('VoucherPayment.id'=>$id,'VoucherPayment.is_deleted=0'),
					'fields'=>array('VoucherPayment.*','Account.name','Account.balance','AccountAlias.name','AccountAlias.balance','VoucherLog.id')));
		}
			if(!empty($dataDetail['VoucherPayment']['date'])){
				$dataDetail['VoucherPayment']['date']=$this->DateFormat->formatDate2Local($dataDetail['VoucherPayment']['date'],Configure::read('date_format'),true);
			}
			if($dataDetail['Account']['balance'] < 0 ){
				$dataDetail['Account']['balance']=$this->Number->currency(ceil($dataDetail['Account']['balance']*(-1)))." Cr";
			}else{
				$dataDetail['Account']['balance']=$this->Number->currency(ceil($dataDetail['Account']['balance']))." Dr";
			}
			if($dataDetail['AccountAlias']['balance'] < 0 ){
				$dataDetail['AccountAlias']['balance']=$this->Number->currency(ceil($dataDetail['AccountAlias']['balance']*(-1)))." Cr";
			}else{
				$dataDetail['AccountAlias']['balance']=$this->Number->currency(ceil($dataDetail['AccountAlias']['balance']))." Dr";
			}
				
		$this->data= $dataDetail ;
		$this->set('dataDetail',$dataDetail);
	}
 
	public function get_user_current_balance($id){ 
		$this->layout = 'ajax';
		$this->autoRender = false;
		$this->uses = array('JournalEntryUser');
		$this->JournalEntryUser->bindModel(array(
				"belongsTo"=>array(
						"User"=>array("foreignKey"=>false ,'conditions'=>array('User.id=JournalEntryUser.user_id')),
				))) ; 
		$credit  = $this->JournalEntryUser->find('first',array('fields'=>array('credit'),'conditions'=>array('JournalEntryUser.user_id'=>$id))); 
		echo $this->Number->currency(ceil($credit['JournalEntryUser']['credit']));
	} 
	
	public function get_account_current_balance($id){
		$this->layout = 'ajax';
		$this->uses = array('Account','VoucherPayment','AccountReceipt','VoucherEntry');
		$this->autoRender = false;
		$this->Account->bindModel(array(
				'belongsTo'=>array(
						'AccountingGroup'=>array('foreignKey'=>false,'conditions'=>array('AccountingGroup.id=Account.accounting_group_id')))));
			
		//for last narration
		$lastNarrationDetails = $this->VoucherPayment->find('first',array('fields'=>array('VoucherPayment.narration'),'conditions'=>array('VoucherPayment.user_id'=>$id),'order'=>array('VoucherPayment.id' =>'DESC')));
		//Eof by amit jain
		
		//for last narration
		$lastNarrationDetailsReceipt = $this->AccountReceipt->find('first',array('fields'=>array('AccountReceipt.narration'),'conditions'=>array('AccountReceipt.user_id'=>$id),'order'=>array('AccountReceipt.id' =>'DESC')));
		//Eof by amit jain
		
		//for last narration
		$lastNarrationDetailsJournal = $this->VoucherEntry->find('first',array('fields'=>array('VoucherEntry.narration'),'conditions'=>array('VoucherEntry.user_id'=>$id),'order'=>array('VoucherEntry.id' =>'DESC')));
		//Eof by amit jain
		
		$creditData  = $this->Account->find('first',array('fields'=>array('Account.balance','AccountingGroup.account_type','Account.is_reference'),'conditions'=>array('Account.id'=>$id)));
		if($creditData['Account']['balance'] < 0 ){
			$credit = $this->Number->currency(ceil(($creditData['Account']['balance'])*(-1)))." Cr";
			$acountType = "Cr";
		}else{
			$credit = $this->Number->currency(ceil($creditData['Account']['balance']))." Dr";
			$acountType = "Dr";
		}
		$referenceNo = $creditData['Account']['is_reference']; //for reference area in payment voucher by amit jain
		echo json_encode (array('credit'=>$credit,'account_type'=>$creditData['AccountingGroup']['account_type'],'acountType'=>$acountType,'referenceNo'=>$referenceNo,'narrationPayment'=>$lastNarrationDetails['VoucherPayment']['narration'],'narrationReceipt'=>$lastNarrationDetailsReceipt['AccountReceipt']['narration'],'narrationVoucherEntry'=>$lastNarrationDetailsJournal['VoucherEntry']['narration']));
		exit;
	}
	
	
	//function to return journal entries of selected users.
	public function getJournalEntries($user_id){
		$this->layout = 'ajax';
		if(!$user_id) $this->redirect($this->referer());                     
		$this->uses =  array('VoucherEntry'); 
		$conditions = array('user_id'=>$user_id,'location_id'=>$this->Session->read('locationid')) ;
		$data = $this->VoucherEntry->find('all',array('conditions'=>$conditions)) ;
		$this->set('data',$data);
		
	}
	
	/**function to return payment entries
	 * 
	 */
	
	public function getJournalEntryPayment($user_id,$eleid = null,$type=null){
		$this->layout = 'ajax';
		if(!$user_id) $this->redirect($this->referer());
		$this->uses =  array('VoucherReference','VoucherEntry','Account');
		//type 0 for payable and type 1 define for receivable
		if($type == 0){
		//Changes done by amit jain because bind with voucherEntry
		$this->VoucherReference->bindModel(array(
				'belongsTo'=>array('Account'=>array('foreignKey'=>'user_id'),
						'VoucherEntry'=>array('foreignKey'=>false,'type'=>'inner','conditions'=>array('VoucherReference.voucher_id=VoucherEntry.id'))),
				'hasMany' =>  array( //for clild references
						'ReferenceChild' => array(
								'className' => 'VoucherReference',
								'foreignKey'   => 'parent_id'))));
		$data=$this->VoucherReference->find('all',array('conditions'=>array('VoucherReference.status'=>'pending','VoucherReference.user_id'=>$user_id ,
				'VoucherEntry.is_deleted=0', 'VoucherReference.payment_type'=>'Cr', 'OR'=>array('VoucherReference.reference_type_id !='=>'3')),'order'=>array('VoucherReference.date ASC')));//for user specific
		}
		/* $conditions = array('user_id'=>$user_id , 'status'=>'pending') ; //for advance entries only
		$data = $this->VoucherReference->find('all',array('conditions'=>$conditions)) ; */
		$this->set(array('data'=>$data,'eleid'=>$eleid));  
	
	}
	public function getJournalEntryPaymentReceivable($user_id,$eleid = null,$type=null){
		$this->layout = 'ajax';
		if(!$user_id) $this->redirect($this->referer());
		$this->uses =  array('VoucherReference','VoucherEntry','Account');
		//type 0 for payable and type 1 define for receivable
		if($type == 1){
			//Changes done by amit jain because bind with voucherEntry
			$this->VoucherReference->bindModel(array(
					'belongsTo'=>array('Account'=>array('foreignKey'=>'user_id'),
							'VoucherEntry'=>array('foreignKey'=>false,'type'=>'inner','conditions'=>array('VoucherReference.voucher_id=VoucherEntry.id'))),
					'hasMany' =>  array( //for clild references
							'ReferenceChild' => array(
									'className' => 'VoucherReference',
									'foreignKey'   => 'parent_id'))));
			$data=$this->VoucherReference->find('all',array('conditions'=>array('VoucherReference.status'=>'pending','VoucherReference.user_id'=>$user_id ,
					'VoucherEntry.is_deleted=0', 'VoucherReference.payment_type'=>'Dr', 'OR'=>array('VoucherReference.reference_type_id !='=>'3')),'order'=>array('VoucherReference.date ASC')));//for user specific
		}
		//EOF
		/* $conditions = array('user_id'=>$user_id , 'status'=>'pending') ; //for advance entries only
			$data = $this->VoucherReference->find('all',array('conditions'=>$conditions)) ; */
		$this->set(array('data'=>$data,'eleid'=>$eleid));
	
	}
	public function account_receipt($id){
		
		$this->layout='advance';
		$this->uses = array('AccountReceipt','VoucherReference','Account','AccountingGroup','Patient','VoucherLog','Message','VoucherEntry','Configuration');
		$lastIdDetails = $this->AccountReceipt->find('first',array('fields'=>array('id'),'order'=>array('id' =>'DESC')));
		$lastID= ($lastIdDetails['AccountReceipt']['id'] +1);
		$this->set('ar_no',$lastID);
		//$this->set('ar_no',"AR-".$this->General->generateRandomBillNo());
		$this->set('id',$id);
		$locationid = $this->Session->read('locationid');
		if(isset($this->request->data) && !empty($this->request->data)){
			if(!empty($this->request->data["AccountReceipt"]['date'])){
				$this->request->data["AccountReceipt"]['date'] = $this->DateFormat->formatDate2STD($this->request->data["AccountReceipt"]['date'],Configure::read('date_format'));
			}
			$userid = $this->Session->read('userid') ;
			$this->request->data["AccountReceipt"]["create_time"] = date("Y-m-d H:i:s");
			$this->request->data["AccountReceipt"]["create_by"]  = $userid;
			$this->request->data["AccountReceipt"]["modified_by"] = $userid;
			$this->request->data["AccountReceipt"]["location_id"] = $locationid;
			$this->request->data["AccountReceipt"]["batch_identifier"] = strtotime(date("Y-m-d H:i:s"));
			$this->request->data["AccountReceipt"]["system_ip_address"] = $this->request->clientIp();
			$result=$this->AccountReceipt->save($this->request->data["AccountReceipt"]);
			//BOF TDS Receivable Entry for corporate suspense
			if(!empty($this->request->data["AccountReceipt"]['tds_amount'])){
				$tdsAmount = $this->request->data['AccountReceipt']['tds_amount'];
				$TdsId = $this->Account->getAccountIdOnly(Configure::read('TDSreceivable'));
				$narration = "TDS Receivable $tdsAmount/-";
				$voucherLogDataTds = $jvData = array('date'=>$this->request->data['AccountReceipt']['date'],
						'created_by'=>$userid,
						'modified_by'=>$userid,
						'account_id'=>$TdsId,
						'user_id'=>$this->request->data["AccountReceipt"]['user_id'],
						'type'=>'Tds',
						'narration'=>$narration,
						'batch_identifier'=>strtotime(date("Y-m-d H:i:s")),
						'debit_amount'=>$tdsAmount);
				if(!empty($jvData['debit_amount']) && ($jvData['debit_amount'] != 0)){
					$lastVoucher = $this->VoucherEntry->insertJournalEntry($jvData);
					//insert into voucher_logs table added by PankajM
					$voucherLogDataTds['voucher_no']=$lastVoucher;
					$voucherLogDataTds['voucher_id']=$lastVoucher;
					$voucherLogDataTds['voucher_type']="Journal";
					$this->VoucherLog->insertVoucherLog($voucherLogDataTds);
					$this->VoucherLog->id= '';
					// ***insert into Account (By) credit manage current balance
					$this->Account->setBalanceAmountByAccountId($TdsId,$tdsAmount,'debit');
					$this->Account->setBalanceAmountByUserId($this->request->data["AccountReceipt"]['user_id'],$tdsAmount,'credit');
				}
			}
			//EOF TDS Receivable
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
				///BOF-Mahalaxmi-For send SMS to Owner										
				$smsActive=$this->Configuration->getConfigSmsValue('Receipt Voucher');				
				if($smsActive){
					//$getLastId=$this->AccountReceipt->getLastInsertID();
					//$this->Patient->sendToSmsOwner($getLastId,'recieptVoucher');
					if(!empty($this->request->data["AccountReceipt"]["user_id"]) && !empty($this->request->data["AccountReceipt"]['paid_amount'])){
						$accountSmsData = $this->Account->find('first',array('fields'=>array('Account.name'),'conditions'=>array('Account.id'=>$this->request->data["AccountReceipt"]["user_id"])));	
						$accountSmsData['Account']['name'] = str_replace ('&','and', $accountSmsData['Account']['name']);
						if(!empty($this->request->data["AccountReceipt"]['narration'])){
							$this->request->data["AccountReceipt"]['narration'] = str_replace ('&','and', $this->request->data["AccountReceipt"]['narration']);
						$showMsg= sprintf(Configure::read('reciept_voucher_with_narration'),$this->request->data["AccountReceipt"]['paid_amount'],$accountSmsData['Account']['name'],$this->request->data["AccountReceipt"]['narration']);	
						}else{					
							$showMsg= sprintf(Configure::read('reciept_voucher'),$this->request->data["AccountReceipt"]['paid_amount'],$accountSmsData['Account']['name']);		
						}				
						$this->Message->sendToSms($showMsg,Configure::read('owner_no'));
						//$this->Patient->sendToSmsOwner($getLastId,'PaymentVoucher');	
					}
				}
				///EOF-Mahalaxmi-For send SMS to Owner
			if(empty($this->request->data["AccountReceipt"]['id'])){ 
				$paymentEntry =  $this->AccountReceipt->getLastInsertID();
			}else{
				$paymentEntry = $this->request->data["AccountReceipt"]['id'];
			} 
			
			//insert into voucher log ntable - Pankaj M
			if(!empty($this->request->data["VoucherLog"]['id'])){
				$this->request->data['AccountReceipt']['id'] = $this->request->data["VoucherLog"]['id'];
			}
			$this->request->data['AccountReceipt']['voucher_id']=$paymentEntry;
			$this->request->data['AccountReceipt']['voucher_type']="Receipt";
			$this->request->data['AccountReceipt']['voucher_no']=$paymentEntry; //for voucher no. amit
			$this->VoucherLog->insertVoucherLog($this->request->data["AccountReceipt"]);
			//end
			
			foreach($this->request->data["VoucherReference"] as $key => $voucherRefrence  ){
				if(!empty ($voucherRefrence['reference_type_id'])){
					$voucherRefrence['id']= $voucherRefrence['id'];
					$voucherRefrence['voucher_id']= $paymentEntry ;
					$voucherRefrence['voucher_type']= 'receipt';
					$voucherRefrence['location_id']= $locationid ;
					$voucherRefrence['account_id']= $this->request->data["AccountReceipt"]['account_id'];
					$voucherRefrence['account_receipt_no']= $this->request->data["AccountReceipt"]['account_receipt_no'];
					$voucherRefrence['user_id']= $this->request->data["AccountReceipt"]['user_id'] ;
					$voucherRefrence['date']= $this->request->data["AccountReceipt"]['date'] ;
					$voucherRefrence['parent_id'] =	$voucherRefrence["voucher_reference_id"] ? $voucherRefrence["voucher_reference_id"] : '0';
					if(!empty($voucherRefrence["voucher_reference_id"])){
		
						$getdata = $this->VoucherReference->find('first',array('fields'=>array('VoucherReference.amount','VoucherReference.paid_amount','VoucherReference.voucher_type'),'conditions'=>array('VoucherReference.id'=>$voucherRefrence["voucher_reference_id"]))) ;
						$diff = ($getdata['VoucherReference']['amount'] - $voucherRefrence['amount']);
						//update prev entry
						$prev['pending_amount'] = $diff ;
						$prev['paid_amount']=$voucherRefrence['amount'];
						$prev['voucher_type']=$getdata['VoucherReference']['voucher_type'];
						$prev['status']='nil' ;
						$prev['id']=$voucherRefrence["voucher_reference_id"] ;
						$this->VoucherReference->save($prev) ;
						$this->VoucherReference->id='' ;
						//EOF prev entry update
						$voucherRefrence['amount'] = $prev['pending_amount'];
						$voucherRefrence['voucher_type']= $getdata['VoucherReference']['voucher_type'];// for reference of previous reference voucher type
					}
					
				//if the reference amount is greater
				if($voucherRefrence['amount']<0){
					$voucherRefrence['amount']=-($voucherRefrence['amount']);
					$voucherRefrence['voucher_type']='receipt';
				}
					$voucherRefrence['pending_amount'] = $voucherRefrence['amount'] - $voucherRefrence['paid_amount'] ;
				
					
				$finalRefArray[] = $voucherRefrence ;
			}
		}
			if($prev['pending_amount'] == '0.00'){
		
			}else{
				$resultReference=$this->VoucherReference->saveAll($finalRefArray);
			}
			// ***insert into Account (By) credit manage current balance
			$accountId = $this->request->data['AccountReceipt']['account_id'];
			$userId = $this->request->data['AccountReceipt']['user_id'];
			
			$this->Account->setBalanceAmountByAccountId($userId,$this->request->data['AccountReceipt']['paid_amount'],'debit',$this->request->data['AccountReceipt']['previous_paid_amount']);
			$this->Account->setBalanceAmountByUserId($accountId,$this->request->data['AccountReceipt']['paid_amount'],'credit',$this->request->data['AccountReceipt']['previous_paid_amount']);
			
		if(!$this->request->data['VoucherReference'][0]['id']){
				if($result || $resultReference){
					$this->Session->setFlash(__('Record saved successfully!'),'default',array('class'=>'message'));
				}else{
					$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
				}
			}else{
				if($result || $resultReference){
					$this->Session->setFlash(__('Record update successfully!'),'default',array('class'=>'message'));
				}else{
					$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
				}
			}
			if($this->request->data['AccountReceipt']['corporate_action'] == '1'){
				$this->Session->setFlash(__('Record saved successfully!'),'default',array('class'=>'message'));
				$this->redirect(array('action'=>'corporateSuspense'));
			}else{
				$lastId = $this->AccountReceipt->getLastInsertID();
				$this->set(array('lastInsertID'=>$lastId,'action'=>'print'));
			}
			}
		}	
		
		// edit section start
		$this->AccountReceipt->bindModel(array(
				"belongsTo"=>array(
						"Account"=>array("foreignKey"=>false ,'conditions'=>array('Account.id=AccountReceipt.user_id')),
						"AccountAlias"=>array('className'=>'Account',"foreignKey"=>false ,'conditions'=>array('AccountAlias.id=AccountReceipt.account_id')),
						"VoucherLog"=>array("foreignKey"=>false ,'conditions'=>array('VoucherLog.voucher_id=AccountReceipt.id','VoucherLog.voucher_type'=>"Receipt"))),
				'hasMany' =>  array( //for clild references
						'VoucherReference' => array(
								'foreignKey'   => 'voucher_id','conditions'=>array('voucher_type="receipt"','voucher_id'=>$id)))));
		
			
		$dataDetail = $this->AccountReceipt->find('first',array('conditions'=>array('AccountReceipt.id'=>$id,'AccountReceipt.is_deleted=0'),
				'fields'=>array('AccountReceipt.*','Account.name','Account.balance','AccountAlias.name','AccountAlias.balance','VoucherLog.id')));
		if(!empty($dataDetail['AccountReceipt']['date'])){
			$dataDetail['AccountReceipt']['date']=$this->DateFormat->formatDate2Local($dataDetail['AccountReceipt']['date'],Configure::read('date_format'),true);
		}
		if($dataDetail['Account']['balance'] < 0 ){
			$dataDetail['Account']['balance']=$this->Number->currency(ceil($dataDetail['Account']['balance']*(-1)))." Cr";
		}else{
			$dataDetail['Account']['balance']=$this->Number->currency(ceil($dataDetail['Account']['balance']))." Dr";
		}
		if($dataDetail['AccountAlias']['balance'] < 0 ){
			$dataDetail['AccountAlias']['balance']=$this->Number->currency(ceil($dataDetail['AccountAlias']['balance']*(-1)))." Cr";
		}else{
			$dataDetail['AccountAlias']['balance']=$this->Number->currency(ceil($dataDetail['AccountAlias']['balance']))." Dr";
		}
		//debug($dataDetail);
		$this->data= $dataDetail ;
		$this->set('dataDetail',$dataDetail);
	}
	
	/**
	 * function to delete Receipt entry and Voucher log entry
	 * @param  int $id
	 * @author Amit Jain
	 */
	public function receipt_delete($id) {
		$this->uses=array('AccountReceipt','Account','VoucherLog');
		$this->set('title_for_layout', __('- Delete Account', true));
		if (empty($id)){
			$this->Session->setFlash(__('Invalid id for Receipt Voucher'),'default',array('class'=>'error'));
			$this->redirect(array('action'=>'legder_voucher'));
		}else{
			$receiptDetails = $this->AccountReceipt->find('first',array('fields'=>array('paid_amount','user_id','account_id'),
					'conditions'=>array('AccountReceipt.id'=>$id)));
		//===============================================================BOF Update Balance into Account===================================================//
			$this->Account->setBalanceAmountByAccountId($receiptDetails['AccountReceipt']['account_id'],$receiptDetails['AccountReceipt']['paid_amount'],'debit');
			$this->Account->setBalanceAmountByUserId($receiptDetails['AccountReceipt']['user_id'],$receiptDetails['AccountReceipt']['paid_amount'],'credit');
		//===============================================================BOF Update Balance into Account===================================================//
		//===============================================================BOF Get Voucher Id================================================================//
			$voucherId = $this->VoucherLog->getVoucherId($id,'Receipt');
		//================================================================EOF Get Voucher Id===============================================================//
		
		//=======================================================BOF Delete Entry from Account Receipt & Voucher Log=========================================//
			$this->AccountReceipt->updateAll(array('AccountReceipt.is_deleted'=>'1'),array('AccountReceipt.id'=>$id));
			$this->AccountReceipt->id='';
			if(!empty($voucherId)){
				$this->VoucherLog->updateAll(array('VoucherLog.is_deleted'=>'1'),array('VoucherLog.id'=>$voucherId));
				$this->VoucherLog->id='';
			}
			$this->Session->setFlash(__('Receipt Voucher successfully deleted'),'default',array('class'=>'message'));
			$this->redirect(array('action'=>'legder_voucher'));
		//=======================================================BOF Delete Entry from Account Receipt & Voucher Log=========================================//
		}
	}
	
	//BOF payable details user wise description -pooja
	public function payable_details($id){
		$this->layout='advance';
		/*$this->layout= false ;*/
		$this->uses=array('VoucherEntry','VoucherReference','AccountingGroup');
		/*user/staff data*/
		/* $this->loadModel('AccountingGroup');
		
		$sundryDebtors=(Configure::read('sundry_debtors'));
		$sundryCreditors=(Configure::read('sundry_creditors'));
		$id=$this->AccountingGroup->find('all',array('fields'=>array('AccountingGroup.id'),'conditions'=>array('AND'=>array('AccountingGroup.name'=>array($sundryDebtors,$sundryCreditors)))));
		//debug($id);
		foreach ($id as $idd)
		{
			$iddd['AccountingGroup']['id'][]=($idd['AccountingGroup']['id']);
		}
		
		//debug($iddd);
		$this->set('iddd'); */
		if($this->request->data)
		{	
			$conditions['VoucherEntry.user_id']=$this->request->data['VoucherEntry']['user_id'];
			
			if(!empty($this->request->data['VoucherEntry']['from']))
			{
				$dateFrom=$this->DateFormat->formatDate2STD($this->request->data['VoucherEntry']['from'],Configure::read('date_format'));
				$dateFrom=explode(" ",$dateFrom);
				
				$conditions['VoucherReference.date >=']=$dateFrom[0].' 00:00:00';
				$from=$this->request->data['VoucherEntry']['from'];
			}
			else
			{
				$conditions['VoucherReference.date >=']=date('Y').'-01-01 00:00:00';
				//$from=date('Y').'-01-01 00:00:00';
				$from=date('01/01/Y');
			}
			if(!empty($this->request->data['VoucherEntry']['to']))
			{
				$dateTo=$this->DateFormat->formatDate2STD($this->request->data['VoucherEntry']['to'],Configure::read('date_format'));
				$dateTo=explode(" ",$dateTo);
				$conditions['VoucherReference.date <=']=$dateTo[0];
				$to=$this->request->data['VoucherEntry']['to'];
			}
			else
			{
				$conditions['VoucherReference.date <=']=date('Y-m-d H:i:s');
				//$to=date('Y-m-d H:i:s');
				$to=date('d/m/Y');
			}
			$conditions['VoucherEntry.is_deleted']='0';
			$this->VoucherReference->bindModel(array(
				'belongsTo'=>array('Account'=>array('foreignKey'=>'user_id'),
						'VoucherEntry'=>array('foreignKey'=>false,'type'=>'inner','conditions'=>array('VoucherReference.voucher_id=VoucherEntry.id','VoucherReference.parent_id=0'))),
				'hasMany' =>  array( /*for clild references*/
                        'ReferenceChild' => array(
                                'className' => 'VoucherReference', 
                                'foreignKey'   => 'parent_id'))));
			$payable=$this->VoucherReference->find('all',array('fields'=>array('Account.name','VoucherEntry.*','VoucherReference.*'),'conditions'=>$conditions));/*for user specific*/
		}
		
		$this->set('currency',$this->Session->read('Currency.currency_symbol'));
		$this->set(compact('user','payable','from','to'));
		
	}
	  
	function get_patient_details(){
		$this->layout = 'advance';
		$this->uses = array('FinalBilling','Patient','AccountReceipt','Account','VoucherPayment','VoucherEntry','VoucherLog');
		if($this->request->data)
		{
			$click=1;
			$userid=$this->request->data['Voucher']['user_id'];	
			if(!empty($this->request->data['Voucher']['from']))
			{
				$fromDate = $this->DateFormat->formatDate2STDForReport($this->request->data['Voucher']['from'],Configure::read('date_format'))." 00:00:00";
				$Rconditions['AccountReceipt.date >=']=$fromDate;
				$Pconditions['VoucherPayment.date >=']=$fromDate;
				$Vconditions['VoucherLog.create_time >=']=$fromDate;
				$from=$this->request->data['Voucher']['from'];
			}
			else
			{
				$startMonth = Configure::read('startFinancialYear');
				if((int) date('m') > 3){
					$date = date("Y$startMonth");
				}else{
					$date = (date("Y") - 1).date("$startMonth");
				}
				$Rconditions['AccountReceipt.date >=']=$date.' 00:00:00';
				$Pconditions['VoucherPayment.date >=']=$date.' 00:00:00';
				$Vconditions['VoucherLog.create_time >=']=$date.' 00:00:00';
				$dateFrom=$this->DateFormat->formatDate2LocalForReport($date,Configure::read('date_format'));
				$from=$dateFrom;
			}
			if(!empty($this->request->data['Voucher']['to']))
			{
				$toDate = $this->DateFormat->formatDate2STDForReport($this->request->data['Voucher']['to'],Configure::read('date_format'))." 23:59:59";
				$Rconditions['AccountReceipt.date <=']=$toDate;
				$Pconditions['VoucherPayment.date <=']=$toDate;
				$Vconditions['VoucherLog.create_time <=']=$toDate;
				$to=$this->request->data['Voucher']['to'];
			}
			else
			{
				$endMonth = Configure::read('endFinancialYear');
				if((int) date('m') <= 3){
					$date = date("Y$endMonth");
				}else{
					$date = (date("Y")+1).date("$endMonth");
				}
				$Rconditions['AccountReceipt.date <=']=$date." 23:59:59";
				$Pconditions['VoucherPayment.date <=']=$date." 23:59:59";
				$Vconditions['VoucherLog.create_time <=']=$date." 23:59:59";
				$dateTo=$this->DateFormat->formatDate2LocalForReport($date,Configure::read('date_format'));
				$to=$dateTo;
			}
			$Rconditions['AccountReceipt.patient_id']=$userid;
			$Pconditions['VoucherPayment.patient_id']=$userid;
			$Vconditions['VoucherLog.patient_id']=$userid;
			$Donditions['VoucherEntry.patient_id']=$userid;
			
			$Rconditions['AccountReceipt.is_deleted']='0';
			$Pconditions['VoucherPayment.is_deleted']='0';
			$Vconditions['VoucherLog.is_deleted']='0';
			$Donditions['VoucherEntry.is_deleted']='0';
			
			$Vconditions['VoucherLog.voucher_type']=array('Journal');
			
			$Donditions['VoucherEntry.type']=array('Discount','Tds');
			$Pconditions['VoucherPayment.type']=array('USER','Refund','PatientCardRefund');
			$Rconditions['AccountReceipt.type NOT']=array('PatientCard','SpotBacking');
			//for Reciept Entries Account type
			$this->AccountReceipt->bindModel(array(
					'belongsTo' => array(
							'Account' =>array('foreignKey' => false,'conditions'=>array('AccountReceipt.account_id=Account.id')),
					)),false);
			$receiptDetails = $this->AccountReceipt->find('all',array('fields' =>array('AccountReceipt.id','AccountReceipt.paid_amount','AccountReceipt.date','AccountReceipt.patient_id','AccountReceipt.billing_id','Account.name'),'conditions'=>$Rconditions));
		
			//for Payment Entries Account type
			$this->VoucherPayment->bindModel(array(
				'belongsTo' => array(
						'Account' =>array('foreignKey' => false,'conditions'=>array('VoucherPayment.account_id=Account.id')),
				)),false);
			$paymentDetails = $this->VoucherPayment->find('all',array('fields' =>array('VoucherPayment.id','VoucherPayment.paid_amount','VoucherPayment.date','VoucherPayment.patient_id','Account.name'),'conditions'=>$Pconditions));
			
			$voucherLog = $this->VoucherLog->find('all',array('fields'=>array('VoucherLog.*'),'conditions'=>$Vconditions));
			
			//for discount
			$this->VoucherEntry->bindModel(array(
						"belongsTo"=>array(
								"Account"=>array("foreignKey"=>false ,'conditions'=>array('Account.id=VoucherEntry.account_id')),
						))) ;
			$discount=$this->VoucherEntry->find('all',array('fields'=>array('VoucherEntry.debit_amount','VoucherEntry.date','VoucherEntry.narration','VoucherEntry.id','Account.name','VoucherEntry.type','VoucherEntry.patient_id'),
						'conditions'=>$Donditions));//for user specifi
			//For opening balance
			$sequenceDate=$this->DateFormat->formatDate2STD($from,Configure::read('date_format'));
			$sequenceDate=explode(' ',$sequenceDate);
			$sequenceDate=$sequenceDate[0].' 00:00:00';
				
			$recieptDebit=$this->AccountReceipt->find('first',array('fields'=>array('SUM(AccountReceipt.paid_amount) as debit'),
					'conditions'=>array('AccountReceipt.date <'=>$sequenceDate,'AccountReceipt.user_id'=>$this->request->data['Voucher']['user_id'])));
			$recieptCredit=$this->AccountReceipt->find('first',array('fields'=>array('SUM(AccountReceipt.paid_amount) as credit'),
					'conditions'=>array('AccountReceipt.date <'=>$sequenceDate,'AccountReceipt.account_id'=>$this->request->data['Voucher']['user_id'])));
			$paymentDebit=$this->VoucherPayment->find('first',array('fields'=>array('SUM(VoucherPayment.paid_amount) as debit'),
					'conditions'=>array('VoucherPayment.date <'=>$sequenceDate,'VoucherPayment.user_id'=>$this->request->data['Voucher']['user_id'])));
			$paymentCredit=$this->VoucherPayment->find('first',array('fields'=>array('SUM(VoucherPayment.paid_amount) as credit'),
					'conditions'=>array('VoucherPayment.date <'=>$sequenceDate,'VoucherPayment.account_id'=>$this->request->data['Voucher']['user_id'])));
		}
		
		$data=array_merge($receiptDetails,$voucherLog,$paymentDetails,$discount);

		$userName=$this->Patient->find('first',array('fields'=>array('Patient.lookup_name','Patient.person_id'),
				'conditions'=>array('Patient.id'=>$this->request->data['Voucher']['user_id'])));
		
		//for patient opening balance
		$getOpeningBalance=$this->Account->find('first',array('fields'=>array('Account.opening_balance'),
				'conditions'=>array('Account.system_user_id'=>$userName['Patient']['person_id'])));
		
		//Setting the Opening balance
		if(empty($recieptDebit[0]['debit']) && empty($recieptCredit[0]['credit']) && empty($paymentDebit[0]['debit']) && empty($paymentCredit[0]['credit']))
		{
			if($opening<0){
				$type='Dr';
				$opening = -($getOpeningBalance['Account']['opening_balance']);
				//$opening=0;
			}else{
				$type='Cr';
				$opening = $getOpeningBalance['Account']['opening_balance'];
			}
		}
		else
		{ //Dr
			$opening=($recieptDebit[0]['debit']+$paymentDebit[0]['debit'])-($recieptCredit[0]['credit']+$paymentCredit[0]['credit']);
			if($opening<0){
				$type='Cr';
				$opening=-($opening);
			}
			else{
				$type='Dr';
				$opening=$opening;
			}
		}
		$this->set('currency',$this->Session->read('Currency.currency_symbol'));
		$this->set("data",$data);
		$this->set(compact('opening','from','to','type','click','userName','userid'));
	}
	
	public function autoGenratedId(){
		$this->uses = array('Account');
		$count = $this->Account->find('count',array('conditions'=>array('Account.create_time like'=> "%".date("Y-m-d")."%",'Account.location_id'=>$this->Session->read('locationid'))));
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
		$hospital = $this->Session->read('facility');
		//creating patient ID
		$unique_id   = 'A';
		$unique_id  .= ucfirst(substr($hospital,0,1)); //first letter of the hospital name
		$unique_id  .= strtoupper(substr($this->Session->read('location'),0,2));//first 2 letter of d location
		$unique_id  .= date('y'); //year
		$unique_id  .= $month_array[date('n')-1];//first letter of month
		$unique_id  .= date('d');//day
		$unique_id .= $count;
		
		return $unique_id;
	}

	public function index(){
		$this->layout = 'advance';
		$this->uses = array('Account','AccountingGroup','VoucherLog');
		$this->set('data','');
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array('Account.name' => 'ASC'));
		$this->Account->bindModel(array(
				'belongsTo' => array(
						'AccountingGroup' =>array('foreignKey' => false,'conditions'=>array('AccountingGroup.id=Account.accounting_group_id','AccountingGroup.location_id'=>$this->Session->read('locationid'))),
				)),false);

		if(!empty($this->params->query)){
		 $search_ele = $this->params->query  ;//make it get
		 if(!empty($search_ele['name'])){
		 	$search_key['Account.name like '] = "%".trim($search_ele['name'])."%" ;
		 }

		 if(!empty($search_ele['group_name'])){
		 	$search_key['AccountingGroup.name like '] = "%".trim($search_ele['group_name']) ;
		 }
		 if(!isset($this->params->query['showLedger'])){
		 	$accountConditions['Account.user_type not'] = array('Patient','TariffList','ExternalPatient');
		 }
		 $this->paginate = array(
		 		'limit' => Configure::read('number_of_rows'),
					'order' => array('Account.name' => 'ASC'),
		 		'fields'=> array('id','name','account_type','status','balance','account_code','payment_type','AccountingGroup.name','opening_balance'),
					'conditions'=>array('Account.is_deleted'=>0,$search_key,'Account.location_id'=>$this->Session->read('locationid'),$accountConditions)
			);
		}else {
			$accountConditions['Account.user_type not'] = array('Patient','TariffList','ExternalPatient');
			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'order' => array('Account.name' => 'ASC'),
					'fields'=> array('id','name','account_type','status','balance','account_code','payment_type','AccountingGroup.name','AccountingGroup.account_type','opening_balance'),
					'conditions'=>array('Account.is_deleted'=>0,'Account.location_id'=>$this->Session->read('locationid'),$accountConditions)
			); 
		}
		$this->set('data',$this->paginate('Account'));
		foreach ($this->paginate('Account') as $key=> $countData){
			$countResult[$countData['Account']['id']] = $this->VoucherLog->getEntryCount($countData['Account']['id']);
		}
		$this->set('countResult',$countResult);
	} 
	
	/**
	 * paymentPosting advance payment dashboard
	 * @author Gaurav Chauriya
	 */
	function paymentPosting($id=null){
		$this->layout = 'advance' ;
		$this->uses = array('AccountBillingInterface','Billing','Account','FinalBilling','Patient');
		
		// for edit patient receipt start here
		$this->AccountBillingInterface->bindModel(array(
				'belongsTo' => array(
						'Patient' =>array('foreignKey' => false,'conditions'=>array('AccountBillingInterface.patient_id=Patient.id')),
						'Account' =>array('foreignKey' => false,'conditions'=>array('AccountBillingInterface.account_id=Account.id')),
						'Billing' =>array('foreignKey' => false,'conditions'=>array('AccountBillingInterface.date=Billing.date'))
				)),false);
		$transactionDetailsNew = $this->AccountBillingInterface->find('first',array('fields'=>array('Patient.lookup_name','Patient.id','Patient.admission_type','Patient.admission_id',
																									'Account.name','Account.balance','Account.id','AccountBillingInterface.*','Billing.date',
																									'Billing.id','Billing.patient_id','Billing.mode_of_payment','Billing.description',
																									'Billing.narration','Billing.refund'),
																					'conditions'=>array('AccountBillingInterface.id'=>$id,'AccountBillingInterface.is_deleted=0')));
		//debug($transactionDetailsNew);
		$this->set("dataId",$transactionDetailsNew);
		//EOC
		
		if($this->request->data){
			//debug($this->request->data);
			//exit; 
			$patientId =$this->request->data['Billing']['patient_id'];
			$this->request->data['Billing']['date']=$this->DateFormat->formatDate2STD($this->request->data['Billing']['date'],Configure::read('date_format'));
			$this->request->data["Billing"]["location_id"] = $this->Session->read('locationid');
			$this->request->data["Billing"]["create_time"] = date("Y-m-d H:i:s");
			$this->request->data["Billing"]["modify_time"] = date("Y-m-d H:i:s");
			$this->request->data["Billing"]["created_by"]  = $this->Session->read('userid') ;
			$this->request->data["Billing"]["modified_by"] = $this->Session->read('userid') ;
			if($this->request->data['Billing']['refund']==1){
				$this->request->data['Billing']['paid_to_patient'] = $this->request->data['Billing']['amount'];
				$this->request->data['Billing']['amount'] = '0';
				$this->request->data['Billing']['copay_amount'] = '0';
				$this->request->data['Billing']['type'] = 'Dr';
				$this->request->data['Billing']['payment_category'] = 'Refund';
			}else{
				$this->request->data['Billing']['amount'] = $this->request->data['Billing']['amount'];
				$this->request->data['Billing']['copay_amount'] = $this->request->data['Billing']['amount'];
				$this->request->data['Billing']['paid_to_patient'] = '0';
				$this->request->data['Billing']['type'] = 'Cr';
				$this->request->data['Billing']['payment_category'] = 'Advance';
			}
			$this->Billing->id = $this->request->data['Billing']['billing_id']; //for edit pateint receipt
			
			$this->Billing->save($this->request->data['Billing']);
			$this->request->data['Billing']['voucher_type'] = 'Receipt';
			$this->request->data['Billing']['balance'] = (int) $this->request->data['Billing']['balance'] - (int) $this->request->data['Billing']['amount'];
			
			$this->AccountBillingInterface->id = $this->request->data['Billing']['accounting_billing_interface_id']; //for edit pateint receipt
			
			$this->AccountBillingInterface->save($this->request->data['Billing']);
			$this->Account->updateAll(array("Account.balance" => "'".$this->request->data['Billing']['balance']."'"),
					array('Account.id'=>$this->request->data['Billing']['account_id']));
			
			/** Updating FinalBilling */
			$this->advancePayment($patientId);
			
			$this->Session->setFlash(__('Payment added successfully', true));
			$this->redirect(array("controller" => "Accounting", "action" => "paymentPosting",$this->request->data['Billing']['patient_id']));
		}
	}
	
	
	
	//Delete patient payment from PatientPayment------ Amit jain
	public function patientPayment_delete($id = null) {
		$this->uses=array('Billing');
		$this->set('title_for_layout', __('- Delete Account', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Patient Payment'),'default',array('class'=>'error'));
			$this->redirect(array('action'=>'legder_voucher'));
		}
		//debug($id);exit;
		$updatearray=array('Billing.is_deleted'=>'1');
		if ($this->Billing->updateAll($updatearray,array('Billing.id'=>$id))) {
			$this->Session->setFlash(__('Patient Payment successfully deleted'),'default',array('class'=>'message'));
			$this->redirect(array('action'=>'legder_voucher'));
		}
	}
	
	//Delete patient Ledger from Patient Ledger Voucher------ Amit jain
	public function patientLedger_delete($id = null) {
		$this->uses=array('AccountBillingInterface');
		$this->set('title_for_layout', __('- Delete Account', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Patient Ledger'),'default',array('class'=>'error'));
			$this->redirect(array('action'=>'get_patient_details'));
		}
		//debug($id);exit;
		$updatearray=array('AccountBillingInterface.is_deleted'=>'1');
		if ($this->AccountBillingInterface->updateAll($updatearray,array('AccountBillingInterface.id'=>$id))) {
			$this->Session->setFlash(__('Patient Ledger successfully deleted'),'default',array('class'=>'message'));
			$this->redirect(array('action'=>'get_patient_details'));
		}
	}
	/**
	 * fetchPatientData ajax function
	 * @param int $patientId
	 * @param int $personId
	 */
	function fetchPatientData($patientId=null,$personId=null){
	
		$this->layout = 'ajax' ;
		$this->loadModel('Patient');
	
		$filedOrder = array('Patient.id','Patient.lookup_name','Patient.admission_id','Patient.admission_type',
				'CONCAT(Guarantor.gau_first_name," ", Guarantor.gau_last_name) AS full_name');
		if($patientId != null)
			$conditions["Patient.id"] = $patientId;
		else
			$conditions["Patient.person_id"] = $personId;
		$conditions["Patient.location_id"] = $this->Session->read('locationid');
		$conditions["Patient.is_discharge"] =0;
		$conditions["Patient.is_deleted"] =0;
		$this->Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$this->Patient->bindModel(array(
				"hasOne"=>array(
						"Guarantor"=>array("foreignKey"=>false ,'conditions'=>array('Guarantor.person_id=Patient.person_id')),
				))) ;
		$items = $this->Patient->find('first', array('fields'=> $filedOrder,'conditions'=>$conditions,'order'=>'Patient.person_id Desc'));
		echo json_encode($items)."***";
		
		if($items['Patient']['id']){
			$this->redirect(array("controller" => "Accounting", "action" => "patientBillTransactions",$items['Patient']['id']));
		}
		exit;
	}
	
	/**
	 * patientBillTransactions 
	 * transaction listing ajax function
	 * @param int $patientId
	 * @author Gaurav Chauriya
	 */
	function patientBillTransactions($patientId){
		$this->layout = 'ajax' ;
		$this->loadModel('Billing');
		$this->Billing->bindModel(array(
				"belongsTo"=>array(
						"Patient"=>array("foreignKey"=>false ,'conditions'=>array('Billing.patient_id=Patient.id')),
				))) ;
		$advancedPayments = $this->Billing->find('all',array('fields'=>array('Patient.id','Billing.id','adjustment_code','Billing.amount','Billing.plan',
				'Billing.ins_status','Billing.date','Billing.reason_of_payment','Billing.description','Billing.mode_of_payment','Billing.remit','Billing.amount_covered','Billing.amount_net_covered',
				'Billing.decuctible_amount','Billing.co_ins_amount','Billing.refund','Billing.paid_to_patient'),
				'conditions'=>array('Patient.is_discharge'=>0,'Billing.location_id'=>$this->Session->read('locationid'),'Billing.patient_id'=>$patientId)));
		$this->set(compact('advancedPayments'));
	}

	//BOF ledger Voucher -pooja
	public function legder_voucher($Reporttype=null,$ledgerId=null,$locId=null,$trialFrom=null,$trialTo=null){	
	
		ob_end_clean();
		ob_start("ob_gzhandler");
		$this->layout='advance';
		$this->uses=array('VoucherEntry','AccountReceipt','VoucherPayment','Account','ContraEntry','Patient');
		if(!empty($this->params->query)){
			$this->request->data['VoucherEntry']=$this->params->query;
		}
	
		$locationId = $this->Session->read('locationid');
		if($this->request->data || $Reporttype == 'TrialBalance' || $Reporttype == Configure::read('profit_loss_statement')){ //BOF-profitLossStatement condition added by Mahalaxmi
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
			}elseif($getAccountType['Account']['user_type'] == 'Patient' || $getAccountType['Account']['user_type'] == 'User'){
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
							/*$debitAmount[$data['VoucherEntry']['patient_id']]['debit_amount'] = $debitAmount[$data['VoucherEntry']['patient_id']]['debit_amount'] + $data['VoucherEntry']['debit_amount'];
							$JournalEntry[$data['VoucherEntry']['patient_id']] = $data;
							$JournalEntry[$data['VoucherEntry']['patient_id']]['VoucherEntry']['debit_amount'] = $debitAmount[$data['VoucherEntry']['patient_id']]['debit_amount'];*/

							$debitAmount[$key]['debit_amount'] = $debitAmount[$key]['debit_amount'] + $data['VoucherEntry']['debit_amount'];
							$JournalEntry[$key] = $data;
							$JournalEntry[$key]['VoucherEntry']['debit_amount'] = $debitAmount[$key]['debit_amount'];


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
			}
			
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
			//$combineArray =array_merge($reciept,$payment,$contra,$tds);
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
			if($Reporttype=='TrialBalance' || $Reporttype==Configure::read('profit_loss_statement')){				
				$this->data = $userid;
				$this->layout='advance_ajax';
				$this->render('ajax_trial_ledger_details');
			}
			if($Reporttype=='excel'){
				$this->layout=false;
				$this->render('legder_voucher_xls',false);
			}
		}

		/**
		 * Function to maintian purchase receipt for any purchase in hospital other than pharmacy
		 * Pankaj Wanjari
		 */
		function purchase_receipt(){
			$this->layout='advance';
			$this->set('pr_no',"PR-".$this->General->generateRandomBillNo());	
			if(!empty($this->request->data)){
			pr($this->request->data);exit;	
			}	
		}
		
		/**
		 * Function to view the total account balance of a pateint
		 * Pooja Gupta
		 */
		public function patient_account_total(){
			$this->layout='advance';
			$this->uses=array('FinalBilling','Patient');
			if($this->request->data){
				$click=1;
			$name=$this->Patient->find('first',array('fields'=>array('lookup_name'),'conditions'=>array('id'=>$this->request->data['Voucher']['user_id'])));
			$total=$this->FinalBilling->find('first',array('fields'=>array('total_amount'),'conditions'=>array('patient_id'=>$this->request->data['Voucher']['user_id'])));
			$this->set(compact('name','total','click'));
			}
		}
		

		/*
		 * Function for patient detailed account statement
		 * Pooja Gupta
		 */
		
		public function patient_statement(){
			$this->layout='advance';
			$this->uses=array('AccountBillingInterface');
			if($this->request->data){
				$click=1;
				debug($this->request->data);
				$conditions['AccountBillingInterface.patient_id']=$this->request->data['VoucherEntry']['user_id'];
				if(!empty($this->request->data['VoucherEntry']['from']))
				{
					$fromDate=$this->DateFormat->formatDate2STD($this->request->data['VoucherEntry']['from'],Configure::read('date_format'));
					$fromDate=explode(' ',$fromDate);					
					$conditions['AccountBillingInterface.date >=']=$fromDate[0].' 00:00:00';
					$from=$this->request->data['VoucherEntry']['from'];
				}
				else
				{
					$conditions['AccountBillingInterface.date >=']=date('Y').'-01-01 00:00:00';
					$from=date('01/01/Y');
				}
				if(!empty($this->request->data['VoucherEntry']['to']))
				{
					$toDate=$this->DateFormat->formatDate2STD($this->request->data['VoucherEntry']['to'],Configure::read('date_format'));
					$toDate=explode(' ',$toDate);
					$conditions['AccountBillingInterface.date <=']=$toDate[0].' 00:00:00';
					$to=$this->request->data['VoucherEntry']['to'];
				}
				else
				{
					$conditions['AccountBillingInterface.date <=']=date('Y-m-d H:i:s');
					$to=date('m/d/Y');
				}
				$this->AccountBillingInterface->bindModel(array(
						'belongsTo'=>array(
								'Account'=>array('foreignKey'=>false,'conditions'=>array('Account.id=AccountBillingInterface.account_id')),
								'Patient'=>array('foreignKey'=>false,'conditions'=>array('Patient.id=AccountBillingInterface.patient_id'))
								)));
				$details=$this->AccountBillingInterface->find('all',array('fields'=>array('AccountBillingInterface.*','Account.name','Patient.lookup_name'),'conditions'=>$conditions));
				$sequenceDate=$this->DateFormat->formatDate2STD($from,Configure::read('date_format'));
				$paymentDebit=$this->AccountBillingInterface->find('first',array('fields'=>array('SUM(AccountBillingInterface.paid_to_patient) as debit'),
						'conditions'=>array('AccountBillingInterface.date <'=>$sequenceDate,
								'AccountBillingInterface.type'=>'Dr')));
				$paymentCredit=$this->AccountBillingInterface->find('first',array('fields'=>array('SUM(AccountBillingInterface.amount) as credit'),
						'conditions'=>array('AccountBillingInterface.date <'=>$sequenceDate,
								'AccountBillingInterface.type'=>'Cr')));
				debug($details);
				if(empty($paymentCredit[0]['credit'])&& empty($paymentdebit[0]['debit'])){
					$opening=0;
				}
				else{
					$opening=$paymentCredit[0]['credit']-$paymentDebit[0]['debit'];
					debug($opening);
					if($opening<0){
						$type='Dr';
						$opening=-($opening);
					}
					else{
						$type='Cr';
					}
				}
			}//end of parent if
			$this->set(compact('details','click','from','to','opening','type'));
		}//end of function
		
		

		/**
		 * Function to show balance sheet for duration
		 */
		
		function balance_sheet(){
			$this->uses = array('AccountingGroup');
			$this->AccountingGroup->bindModel(array('hasMany'=>array('Account'=>array("foreignKey"=>'accouting_group_id'))));
			
			$this->AccountingGroup->find();
		}
		
		/*
		 * AutoComplete function to select only a/c with bank or cash as a accounting group
		 * Pooja
		 */
		
		public function accountAutoComplete(){
			$this->uses=array('Account','AccountingGroup');
			$conditions['name like'] = $this->params->query['term']."%";
			$bankCashId=$this->AccountingGroup->find('list',array('fields'=>array('AccountingGroup.id'),
					'conditions'=>array('OR'=>array('AccountingGroup.name LIKE'."'%".cash."%'",'AccountingGroup.name LIKE '."'%".bank."%'"))));
			$data=$this->Account->find('list',array('fields'=>array('id','name'),
					'conditions'=>array($conditions,'Account.accounting_group_id'=>$bankCashId)));
		
			foreach ($data as $key=>$value) {
				//converting date from local to DB format.
				$returnArray[] = array( 'id'=>$key,
						'value'=>$value,
				) ;
		
			}
			echo json_encode($returnArray);
			exit;
		
		}
		
		public function getaccountId(){
			$this->layout = "ajax";
			$this->autoRender = false;
			$id = ($this->request->data['id']);
			$this->uses=array('Account');
			$result = $this->Account->find('first',array('conditions'=>array('Account.system_user_id'=>$id)));
			if(isset($result) && !empty($result['Account']['name']))
			{
				return 1;
			}
			else 
			{
				return 0;
			}
			//debug($result);
		}
		public function printPaymentVoucher($id=null){	
			$this->layout = false;
			$this->uses = array('VoucherPayment','Account','VoucherReference');
			$this->VoucherPayment->bindModel(array(
					"belongsTo"=>array(
							"Account"=>array("foreignKey"=>false ,'conditions'=>array('Account.id=VoucherPayment.user_id')),
							"AccountAlias"=>array('className'=>'Account',"foreignKey"=>false ,'conditions'=>array('AccountAlias.id=VoucherPayment.account_id'))),
					//'hasMany' =>  array( //for clild references
					//		'VoucherReference' => array(
						//			'foreignKey'   => 'voucher_id'/*,'conditions'=>array('VoucherReference.voucher_type="payment"','VoucherReference.voucher_id'=>$id)*/
							//))
					));
			if(!empty($id)){			
				$voucherPaymentData = $this->VoucherPayment->find('first',array('fields' => array('Account.name','Account.balance','VoucherPayment.*','AccountAlias.name','AccountAlias.balance'),'conditions'=>array('VoucherPayment.id'=>$id,'VoucherPayment.is_deleted=0')));
				$voucherReferenceData = $this->VoucherReference->find('first',array('fields' => array('VoucherReference.reference_type_id','reference_no'),'conditions'=>array('VoucherReference.voucher_id'=>$id)));
						
				if($voucherPaymentData['Account']['balance'] < 0 ){
					$voucherPaymentData['Account']['balance']=$this->Number->currency(ceil($voucherPaymentData['Account']['balance']*(-1)))." Cr";
				}else{
					$voucherPaymentData['Account']['balance']=$this->Number->currency(ceil($voucherPaymentData['Account']['balance']))." Dr";
				}
				if($voucherPaymentData['AccountAlias']['balance'] < 0 ){
					$voucherPaymentData['AccountAlias']['balance']=$this->Number->currency(ceil($voucherPaymentData['AccountAlias']['balance']*(-1)))." Cr";
				}else{
					$voucherPaymentData['AccountAlias']['balance']=$this->Number->currency(ceil($voucherPaymentData['AccountAlias']['balance']))." Dr";
				}
				$this->set(array('voucherPaymentData'=>$voucherPaymentData,'voucherReferenceData'=>$voucherReferenceData));
			}
		}
		
		public function printReceiptVoucher($id=null){
			$this->layout = false;
			$this->uses = array('AccountReceipt','Account','VoucherReference');
			$this->AccountReceipt->bindModel(array(
					"belongsTo"=>array(
							"Account"=>array("foreignKey"=>false ,'conditions'=>array('Account.id=AccountReceipt.user_id')),
							"AccountAlias"=>array('className'=>'Account',"foreignKey"=>false ,'conditions'=>array('AccountAlias.id=AccountReceipt.account_id'))),
			));
			if(!empty($id)){
				$accountReceiptData = $this->AccountReceipt->find('first',array('fields' => array('Account.name','Account.balance','AccountReceipt.*','AccountAlias.name','AccountAlias.balance'),'conditions'=>array('AccountReceipt.id'=>$id,'AccountReceipt.is_deleted=0')));
				$voucherReferenceData = $this->VoucherReference->find('first',array('fields' => array('VoucherReference.reference_type_id','VoucherReference.reference_no','VoucherReference.credit_period'),'conditions'=>array('VoucherReference.voucher_id'=>$id)));
		
				if($accountReceiptData['Account']['balance'] < 0 ){
					$accountReceiptData['Account']['balance']=$this->Number->currency(ceil($accountReceiptData['Account']['balance']*(-1)))." Cr";
				}else{
					$accountReceiptData['Account']['balance']=$this->Number->currency(ceil($accountReceiptData['Account']['balance']))." Dr";
				}
				if($accountReceiptData['AccountAlias']['balance'] < 0 ){
					$accountReceiptData['AccountAlias']['balance']=$this->Number->currency(ceil($accountReceiptData['AccountAlias']['balance']*(-1)))." Cr";
				}else{
					$accountReceiptData['AccountAlias']['balance']=$this->Number->currency(ceil($accountReceiptData['AccountAlias']['balance']))." Dr";
				}
				//debug($accountReceiptData);exit;
				$this->set(array('accountReceiptData'=>$accountReceiptData,'voucherReferenceData'=>$voucherReferenceData));		
			}		
		}
		
		public function patient_journal_voucher($patientid = null){
			$this->layout='advance';
			$this->uses=array('VoucherEntry','Account','FinalBilling','Patient','VoucherLog');
			if(!empty($this->request->data) || (!empty($patientid)))
			{
				$patientid = ($this->request->data['VoucherEntry']['user_id']) ? $this->request->data['VoucherEntry']['user_id'] : $patientid;
				$click=1;
				//for view of day book check patient is not null. by amit jain
				if(!empty($this->request->data['VoucherEntry']['from'])){
					$fromDate = $this->DateFormat->formatDate2STDForReport($this->request->data['VoucherEntry']['from'],Configure::read('date_format'))." 00:00:00";
					$conditions['VoucherEntry.date >=']=$fromDate;
					$from=$this->request->data['VoucherEntry']['from'];
				}else{
					$startMonth = Configure::read('startFinancialYear');
					if((int) date('m') > 3){
						$date = date("Y$startMonth");
					}else{
						$date = (date("Y") - 1).date("$startMonth");
					}
					$conditions['VoucherEntry.date >=']=$date.' 00:00:00';
					$dateFrom=$this->DateFormat->formatDate2LocalForReport($date,Configure::read('date_format'));
					$from=$dateFrom;
				}
			
				if(!empty($this->request->data['VoucherEntry']['to'])){
					$toDate = $this->DateFormat->formatDate2STDForReport($this->request->data['VoucherEntry']['to'],Configure::read('date_format'))." 23:59:59";
					$conditions['VoucherEntry.date <=']=$toDate;
					$to=$this->request->data['VoucherEntry']['to'];
				}else{ 	 
					$endMonth = Configure::read('endFinancialYear');
					if((int) date('m') <= 3){
						$date = date("Y$endMonth");
					}else{
						$date = (date("Y")+1).date("$endMonth");
					}
					$conditions['VoucherEntry.date <=']=$date.' 23:59:59';
					$dateTo=$this->DateFormat->formatDate2LocalForReport($date,Configure::read('date_format'));
					$to=$dateTo;
				}
				$conditions['VoucherEntry.is_deleted']='0';
				$conditions['VoucherEntry.patient_id']=$patientid;
				$conditions['VoucherEntry.location_id']=$this->Session->read('locationid');
				$conditions['VoucherEntry.type NOT']=array('VisitCharges','CTMRI','Blood','AnaesthesiaCharges','SurgeryCharges','Discount','ExternalLab','ExternalRad','ExternalConsultant','Anaesthesia','Tds');
				
				//for Journal Entries Account type
				$this->VoucherEntry->bindModel(array(
						"belongsTo"=>array(
								"Account"=>array("foreignKey"=>false ,'conditions'=>array('Account.id=VoucherEntry.user_id')),
						))) ;
		
				$JournalEntry=$this->VoucherEntry->find('all',array('fields'=>array('VoucherEntry.debit_amount','VoucherEntry.date',
						'VoucherEntry.narration','VoucherEntry.id','Account.name','VoucherEntry.type','VoucherEntry.patient_id'),
						'conditions'=>$conditions));//for user specifi
				
				$voucherLog = $this->VoucherLog->find('first',array('fields'=>array('VoucherLog.*'),
						'conditions'=>array('VoucherLog.voucher_type'=>'Journal','VoucherLog.patient_id'=>$patientid,'VoucherLog.type'=>'FinalDischarge')));
			}
			$this->data= $patientid ;
			// For setting the name of user	
			$userName=$this->Patient->find('first',array('fields'=>array('lookup_name'),
					'conditions'=>array('id'=>$patientid,'Patient.location_id'=>$this->Session->read('locationid'))));
		
			$this->set('currency',$this->Session->read('Currency.currency_symbol'));
			$this->set(compact('userName','from','to','opening','type','click','patientid'));
			$this->set('ledger',$JournalEntry);
			$this->set('voucherLog',$voucherLog);
		}
		
		public function printPatientJournalVoucher(){
			$this->uses=array('VoucherEntry','Account','Billing','Patient','Laboratory','Radiology','TariffList');
			$this->request->data['VoucherEntry'] = $this->params->query ;
			$this->patient_journal_voucher();
			$this->layout=false;
			}
		/**
		 * by amit jain
		
		function :auotcomplete
		
		@purpose : ajax auto fill with the available options.
		
		@params : field: single searching field or "&" Seperated String with find field should be in second position
		
		@params : type=>date,datetime (need to convert into DB format)
		
		@params : is_deleted=>any string to avoid filter of is_deleted field
		
		@params : location=>any string to avoid filter on location_id
		
		@params : $argConditions=>string like "admission_type=OPD&admission_id=xyz"
		
		@params : $group=>array('name','id')
		
		*/
			function advance_autocomplete($model=null,$field=null,$type=null,$is_deleted=null,$location=null,$argConditions=null,$group=array()){
				$this->loadModel('AccountingGroup');
				$bank = Configure::read('bankLabel');
				$location_id = $this->Session->read('locationid');
				$this->layout = "ajax";
				$this->loadModel($model);
				$conditions =array();
				if(!empty($argConditions)){
					if(strpos($argConditions, "&")){
						$allCondition = explode('&',$argConditions);
						foreach($allCondition as $cond){
							if(!empty($cond)){
								$condPara = explode('=',$cond);
								if(!empty($condPara[0]) && (!empty($condPara[1])||$condPara[0]==0)){
									$conditions[$condPara[0]] = $condPara[1];
								}
							}
						}
					}else{
						$condPara = explode('=',$argConditions);
						if(!empty($condPara[0]) && (!empty($condPara[1])||$condPara[0]==0)){
							$conditions[$condPara[0]] = $condPara[1];
						}
					}
				}else{
					$conditions =array();
				}
				$searchKey = $this->params->query['term'] ;
				//converting date from local to DB format.
				if($type=="date"){
					$searchKey = $this->DateFormat->formatDate2STD($this->params->query['q'],Configure::read('date_format'));
				}elseif($type=="datetime"){  //converting datetime from local to DB format.
					$searchKey = $this->DateFormat->formatDate2STD($this->params->query['q'],Configure::read('date_format'),true);
				}
				//filter deleted items
			
				if(empty($is_deleted) || $is_deleted=='null'):
				$conditions['is_deleted'] = 0 ;
				endif ;
			
				if(($model =='Drug') || ($model =='icd') || (!empty($location) && $location != "null")){
				}else{
					$conditions['location_id'] = $location_id ;
				}
				if($model =='OtItem'){
					$conditions['OtItem.ot_item_category_id'] = $this->params->query['category'];
				}
				if($model =='Patient'){
					//$conditions['Patient.is_discharge'] = '0';
					$conditions['Patient.is_deleted'] = '0';
				}
				if($model =='PharmacyItem'){
					// $conditions["PharmacyItem.supplier_id <>"] ="";
					$conditions["PharmacyItem.is_deleted"] ='0';
					if(isset($this->params->query['supplierID'])){
						//$conditions["PharmacyItem.supplier_id"] = $this->params->query['supplierID'];
					}
				}
				if($model =='User'){
					$conditions["User.username <>"] ="admin";
					$conditions["User.username !="] ="superadmin";
				}
			
			
				if(strpos($field, "&")){
					$field = explode('&',$field);
				}else{
					$field =array('id', $field);
				}
				$conditions['trim('.$model.".".$field[1].") like"] = $searchKey."%";
				$conditions['location_id'] = $location_id ;
				// not showing patient ledger in accounts autocomplete by amit
				if($this->params->named['type']=="Patient"){
					$conditions['trim('.$model.".user_type".") !="] = "Patient";
					$name = $this->AccountingGroup->getAccountIdByName(array(Configure::read('cash'),$bank['0']));
					$conditions["Account.accounting_group_id NOT"] = $name;
				}
				
				//for accounting cash bank accounts only by amit
				if($this->params->named['type']=="CashBankOnly"){
					$name = $this->AccountingGroup->getAccountIdByName(array(Configure::read('cash'),$bank['0']));
					$conditions["Account.accounting_group_id"] = $name;
				}
		
				//for accounting except cash bank accounts by amit
				if($this->params->named['type']=="NotCashBank"){
					$name = $this->AccountingGroup->getAccountIdByName(array(Configure::read('cash'),$bank['0']));
					$conditions["Account.accounting_group_id NOT"] = $name;
				}
				$patientArray = $this->$model->find('list', array('fields'=> $field,'conditions'=>$conditions,'group'=>$group,'limit'=>Configure::read('number_of_rows')));
				$returnArray = array();
				foreach ($patientArray as $key=>$value) {
					//converting date from local to DB format.
					if($type=="date"){
						$value = $this->DateFormat->formatDate2Local($value,Configure::read('date_format'));
					}elseif($type=="datetime"){  //converting datetime from local to DB format.
						$value = $this->DateFormat->formatDate2Local($value,Configure::read('date_format'),true);
					}
			
					$returnArray[] = array( 'id'=>$key,
							'value'=>$value,
					) ;
				}
				echo json_encode($returnArray);
				exit;//dont remove this
			}
		
		//for Contra Voucher by amit jain
		function contra_entry($id){
			$this->uses=array('ContraEntry','VoucherReference','Account','VoucherLog');
			$this->layout = 'advance' ;
			$lastIdDetails = $this->ContraEntry->find('first',array('fields'=>array('id'),'order'=>array('id' =>'DESC')));
			$lastID= ($lastIdDetails['ContraEntry']['id'] +1);
			$this->set('cv_no',$lastID);
			$this->set('id',$id);
			if(isset($this->request->data) && !empty($this->request->data)){
				if(!empty($this->request->data["ContraEntry"]['date'])){
					$this->request->data["ContraEntry"]['date'] = $this->DateFormat->formatDate2STD($this->request->data["ContraEntry"]['date'],Configure::read('date_format'));
				}
				$this->request->data['ContraEntry']['create_time']=date('Y-m-d H:i:s');
				$this->request->data['ContraEntry']['location_id']=$this->Session->read('locationid');
				$this->request->data['ContraEntry']['created_by']=$this->Session->read('userid');
				$this->request->data["ContraEntry"]["system_ip_address"] = $this->request->clientIp();
				$result = $this->ContraEntry->save($this->request->data['ContraEntry']);
					
				if(empty($this->request->data["ContraEntry"]['id'])){
					$contraEntry =  $this->ContraEntry->getLastInsertID();
				}else{
					$contraEntry = $this->request->data["ContraEntry"]['id'];
				}
				
				//insert into voucher log ntable - Pankaj M
				if(!empty($this->request->data["VoucherLog"]['id'])){
					$this->request->data['ContraEntry']['id']=$this->request->data["VoucherLog"]['id'];
				}
				$this->request->data['ContraEntry']['voucher_id']=$contraEntry;
				$this->request->data['ContraEntry']['voucher_type']="Contra";
				$this->request->data['ContraEntry']['voucher_no']=$contraEntry;
				$this->VoucherLog->insertVoucherLog($this->request->data["ContraEntry"]);
				//end
					
				$locationid = $this->Session->read('locationid') ;
				foreach($this->request->data["VoucherReference"] as $key => $voucherRefrence  ){
					if(!empty ($voucherRefrence['reference_type_id'])){
						$voucherRefrence['id']= $voucherRefrence['id'] ;
						$voucherRefrence['voucher_id']= $contraEntry ;
						$voucherRefrence['voucher_type']= 'contra';
						$voucherRefrence['location_id']= $locationid ;
						$voucherRefrence['account_id']= $this->request->data["ContraEntry"]['account_id'];
						$voucherRefrence['user_id']= $this->request->data["ContraEntry"]['user_id'] ;
						$voucherRefrence['date']= $this->request->data["ContraEntry"]['date'] ;
						$voucherRefrence['parent_id'] =	$voucherRefrence["voucher_reference_id"] ? $voucherRefrence["voucher_reference_id"] : '0';
						if(!empty($voucherRefrence["voucher_reference_id"])){
		
							$getdata = $this->VoucherReference->find('first',array('fields'=>array('VoucherReference.amount','VoucherReference.paid_amount','VoucherReference.voucher_type'),'conditions'=>array('VoucherReference.id'=>$voucherRefrence["voucher_reference_id"]))) ;
							$diff = ($getdata['VoucherReference']['amount'] - $voucherRefrence['amount']);
							//update prev entry
							$prev['pending_amount'] = $diff ;
							$prev['paid_amount'] = $voucherRefrence['amount'];
							$prev['voucher_type']=$getdata['VoucherReference']['voucher_type'];
							$prev['status'] = 'nil' ;
							$prev['id'] = $voucherRefrence["voucher_reference_id"] ;
							$this->VoucherReference->save($prev) ;
							$this->VoucherReference->id='' ;
							$voucherRefrence['voucher_type']=$getdata['VoucherReference']['voucher_type'];
							//EOF prev entry update
							$voucherRefrence['amount'] = $prev['pending_amount'];
						}
						if($voucherRefrence['amount']<0){
							$voucherRefrence['amount']=-($voucherRefrence['amount']);
							$voucherRefrence['voucher_type']='contra';
						}
						$voucherRefrence['pending_amount'] = $voucherRefrence['amount'] - $voucherRefrence['paid_amount'] ;
						$finalRefArray[] = $voucherRefrence ;
					}
				}
					
				if($prev['pending_amount'] == '0.00'){
		
				}else{
					$resultReference=$this->VoucherReference->saveAll($finalRefArray);
				}
				// ***insert into Account 	 (Debit)
				$acc_id = $this->request->data['ContraEntry']['account_id'];
				$use_id = $this->request->data['ContraEntry']['user_id'];
				$bal = $this->request->data['ContraEntry']['debit_amount'];
					
				$this->Account->setBalanceAmountByAccountId($acc_id,$bal,'debit',$this->request->data['ContraEntry']['previous_paid_amount']);
				$this->Account->setBalanceAmountByUserId($use_id,$bal,'credit',$this->request->data['ContraEntry']['previous_paid_amount']);
				
				if(!$this->request->data['VoucherReference'][0]['id']){
					if($result || $resultReference){
						$this->Session->setFlash(__('Record saved successfully!'),'default',array('class'=>'message'));
					}else{
						$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
					}
				}else{
					if($result || $resultReference){
						$this->Session->setFlash(__('Record update successfully!'),'default',array('class'=>'message'));
					}else{
						$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
					}
				}
				$this->redirect(array('action'=>'contra_entry'));
			}
			// edit section start
			$this->ContraEntry->bindModel(array(
					"belongsTo"=>array(
							"Account"=>array("foreignKey"=>false ,'conditions'=>array('Account.id=ContraEntry.user_id')),
							"AccountAlias"=>array('className'=>'Account',"foreignKey"=>false ,'conditions'=>array('AccountAlias.id=ContraEntry.account_id')),
							"VoucherLog"=>array("foreignKey"=>false ,'conditions'=>array('VoucherLog.voucher_id=ContraEntry.id','VoucherLog.voucher_type'=>"Contra"))),
					'hasMany'=>array( //for clild references
							'VoucherReference'=>array(
									'foreignKey'=>'voucher_id','conditions'=>array('voucher_type="contra"','voucher_id'=>$id)))));
		
			$dataDetail = $this->ContraEntry->find('first',array('conditions'=>array('ContraEntry.id'=>$id,'ContraEntry.is_deleted=0'),
					'fields'=>array('ContraEntry.*','Account.name','Account.balance','AccountAlias.name','AccountAlias.balance','VoucherLog.id')));
			if(!empty($dataDetail['ContraEntry']['date'])){
				$dataDetail['ContraEntry']['date']=$this->DateFormat->formatDate2Local($dataDetail['ContraEntry']['date'],Configure::read('date_format'),true);
			}
			if($dataDetail['Account']['balance'] < 0 ){
				$dataDetail['Account']['balance']=$this->Number->currency(ceil($dataDetail['Account']['balance']*(-1)))." Cr";
			}else{
				$dataDetail['Account']['balance']=$this->Number->currency(ceil($dataDetail['Account']['balance']))." Dr";
			}
			if($dataDetail['AccountAlias']['balance'] < 0 ){
				$dataDetail['AccountAlias']['balance']=$this->Number->currency(ceil($dataDetail['AccountAlias']['balance']*(-1)))." Cr";
			}else{
				$dataDetail['AccountAlias']['balance']=$this->Number->currency(ceil($dataDetail['AccountAlias']['balance']))." Dr";
			}
			$this->data= $dataDetail ;
			$this->set('dataDetail',$dataDetail);
		}
		
		/**
		 * function to delete Contra entry and Voucher log entry
		 * @param  int $id
		 * @author Amit Jain
		 */
		public function contra_delete($id) {
			$this->uses=array('ContraEntry','Account','VoucherLog');
			$this->set('title_for_layout', __('- Delete Account', true));
			if (empty($id)){
				$this->Session->setFlash(__('Invalid id for Contra Voucher'),'default',array('class'=>'error'));
				$this->redirect(array('action'=>'legder_voucher'));
			}else{
				$contraDetails = $this->ContraEntry->find('first',array('fields'=>array('debit_amount','user_id','account_id'),
						'conditions'=>array('ContraEntry.id'=>$id)));
			
			//===============================================================BOF Update Balance into Account===================================================//
				$this->Account->setBalanceAmountByAccountId($contraDetails['ContraEntry']['user_id'],$contraDetails['ContraEntry']['debit_amount'],'debit');
				$this->Account->setBalanceAmountByUserId($contraDetails['ContraEntry']['account_id'],$contraDetails['ContraEntry']['debit_amount'],'credit');
			//===============================================================BOF Update Balance into Account===================================================//
			
			//===============================================================BOF Get Voucher Id================================================================//
				$voucherId = $this->VoucherLog->getVoucherId($id,'Contra');
			//================================================================EOF Get Voucher Id===============================================================//
		
			//=======================================================BOF Delete Entry from Account Receipt & Voucher Log=========================================//
				$this->ContraEntry->updateAll(array('ContraEntry.is_deleted'=>'1'),array('ContraEntry.id'=>$id));
				$this->ContraEntry->id='';
				if(!empty($voucherId)){
					$this->VoucherLog->updateAll(array('VoucherLog.is_deleted'=>'1'),array('VoucherLog.id'=>$voucherId));
					$this->VoucherLog->id='';
				}
				$this->Session->setFlash(__('Contra Voucher successfully deleted'),'default',array('class'=>'message'));
				$this->redirect(array('action'=>'legder_voucher'));
			//=======================================================BOF Delete Entry from Account Receipt & Voucher Log=========================================//
			}
		}
		
		/**
		 * Function to view the grpup summary
		 * Amit Jain
		 */
		public function admin_group_summary(){
		$this->layout='advance';	
		$this->uses = array("AccountingGroup","Patient","Billing","FinalBilling");
		if(!empty($this->request->data['AccountingGroup']['id'])){
			$click=1;
			$this->Patient->unbindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn')));
			$id = $this->request->data['AccountingGroup']['id'];
			$name=$this->AccountingGroup->find('all',array('fields'=>array('name'),'conditions'=>array('AccountingGroup.id'=>$id,'AccountingGroup.is_deleted'=>0)));
			//$patientName=$this->Patient->find('all',array('fields'=>array('lookup_name','create_time','id'),'conditions'=>array('Patient.corporate_id'=>$id)));
			
			//for Patient Payment Account type
			$this->Billing->bindModel(array(
					"belongsTo"=>array(
							'Patient' =>array('foreignKey' => false,'conditions'=>array('Billing.patient_id=Patient.id')),
							'FinalBilling'=>array('foreignKey'=>false,'conditions'=>array('FinalBilling.patient_id=Billing.patient_id')),
					))) ;
			
			$groupDetail=$this->Billing->find('all',array('fields' =>array('Billing.total_amount','Billing.amount_paid','Patient.lookup_name','Patient.create_time','FinalBilling.total_amount','Billing.amount_pending','Billing.amount','Billing.paid_to_patient','Billing.amount_to_pay_today','Billing.refund','Billing.copay_amount','Billing.patient_id'),
					'conditions'=>array('Billing.account_id'=>'1','Patient.corporate_id'=>$id,'FinalBilling.total_amount !='=> '0')));//for user specific
			//debug($groupDetail);
			//$group=array_merge($patientName,$billingAmount);
			$this->set('group',$groupDetail);
			//debug($group);
			$this->set(compact('name','click'));
		}
		
	}

	public function post_to_tallynew($patientid,$voucherId=null){
        $this->layout=ajax;
        $this->autorender=false;
        $this->uses = array("Account","VoucherEntry","Location","AccountReceipt","VoucherPayment","ContraEntry","VoucherLog","AccountingGroup");
        $Jconditions['VoucherEntry.is_deleted']='0';
        $Rconditions['AccountReceipt.is_deleted']='0';
        $Pconditions['VoucherPayment.is_deleted']='0';
        $Cconditions['ContraEntry.is_deleted']='0';
   
        $locationId = $this->Session->read('locationid');
   
        $Jconditions['VoucherEntry.location_id']=$locationId;
        $Cconditions['ContraEntry.location_id']=$locationId;
        $Pconditions['VoucherPayment.location_id']=$locationId;
        $Rconditions['AccountReceipt.location_id']=$locationId;
       
        $journalPatientconditions['VoucherEntry.is_deleted']='0';
        $journalPatientconditions['VoucherEntry.location_id']=$locationId;
        $journalPatientconditions['VoucherEntry.type NOT']=array('VisitCharges','CTMRI','Blood','AnaesthesiaCharges','SurgeryCharges','Discount',
        		'ExternalLab','ExternalRad','ExternalConsultant','Anaesthesia');
        
        if($this->request->data){
            foreach($this->request->data['user_id'] as $key => $value){//$this->request->data['patient_id'] - It contain voucher log table primary key
            	$patientDetails = array();
            	$purchaseDetails = array();
            	$othersJournal = array();
                if($value!=0 ){
                	//for discount entry only
                	if($this->request->data['logType'][$key] == 'Discount'){
                		$id = $this->VoucherLog->find('first',array('fields'=>array('voucher_id','user_id','account_id','voucher_no','type'),
                				'conditions'=>array('VoucherLog.id'=>$value)));
                		$userId = $id['VoucherLog']['user_id'];
                		$accountId = $id['VoucherLog']['account_id'];
                		$dsConditions['VoucherEntry.id']=$id['VoucherLog']['voucher_id'];
                		$this->VoucherEntry->bindModel(array(
                				"belongsTo"=>array(
                						"Account"=>array('foreignKey'=>false,'conditions'=>array('Account.id'=>$userId)),
                						"AccountAlias"=>array('className'=>'Account',"foreignKey"=>false,'conditions'=>array('AccountAlias.id'=>$accountId)),
                				))) ;
                		$discountData=$this->VoucherEntry->find('all',array('fields'=>array('VoucherEntry.id','VoucherEntry.debit_amount','VoucherEntry.date',
                				'VoucherEntry.narration','Account.name','Account.accounting_group_id','AccountAlias.name','AccountAlias.accounting_group_id'),
                				'conditions'=>$dsConditions));
                	}
                	
                	//for journal voucher for patient
                	if(($this->request->data['voucher_type'][$key] == 'Journal') && (!empty($this->request->data['patientId'][$key]) && $this->request->data['logType'][$key] != 'Discount')){
                		$id = $this->VoucherLog->find('first',array('fields'=>array('patient_id','user_id'),'conditions'=>array('VoucherLog.id'=>$value)));
                		$userId = $id['VoucherLog']['user_id'];
                		$journalPatientconditions['VoucherEntry.patient_id']=$id['VoucherLog']['patient_id'];
                		$this->VoucherEntry->bindModel(array(
                				"belongsTo"=>array(
                						"Account"=>array('foreignKey'=>false,'conditions'=>array('VoucherEntry.user_id=Account.id')),
                				))) ;
                		$journalVoucher=$this->VoucherEntry->find('all',array('fields'=>array('VoucherEntry.id','VoucherEntry.debit_amount',
                				'VoucherEntry.create_time','VoucherEntry.patient_id','Account.name','Account.accounting_group_id'),
                				'conditions'=>$journalPatientconditions));
                
                		$this->VoucherLog->bindModel(array(
                				"belongsTo"=>array(
                						"Account"=>array('foreignKey'=>false,'conditions'=>array('VoucherLog.user_id=Account.id','VoucherLog.type'=>'FinalDischarge')),
                				))) ;
                		$patientDetails=$this->VoucherLog->find('first',array('fields'=>array('VoucherLog.debit_amount','VoucherLog.narration','VoucherLog.id',
                				'VoucherLog.create_time','Account.name','Account.accounting_group_id','Account.accounting_sub_group_id','Account.accounting_sub_sub_group_id'),
                				'conditions'=>array('VoucherLog.patient_id'=>$id['VoucherLog']['patient_id'],'VoucherLog.type'=>'FinalDischarge')));
                	}
                	
                	//for journal voucher for others
                	 if(($this->request->data['voucher_type'][$key] == 'Journal') && (empty($this->request->data['patientId'][$key]))){
		                $id = $this->VoucherLog->find('first',array('fields'=>array('voucher_id','user_id','account_id','voucher_no','type','tariff_standard_name'),
		                		'conditions'=>array('VoucherLog.id'=>$value)));
		                $userId = $id['VoucherLog']['user_id'];
		                $accountId = $id['VoucherLog']['account_id'];
                		$Jconditions['VoucherEntry.id']=$id['VoucherLog']['voucher_id'];
                		$this->VoucherEntry->bindModel(array(
                		 		"belongsTo"=>array(
                		 				"Account"=>array('foreignKey'=>false,'conditions'=>array('Account.id'=>$userId)),
                		 				"AccountAlias"=>array('className'=>'Account',"foreignKey"=>false ,'conditions'=>array('AccountAlias.id'=>$accountId)),
                		 		))) ;
                		$journalVoucherOther=$this->VoucherEntry->find('all',array('fields'=>array('VoucherEntry.id','VoucherEntry.debit_amount','VoucherEntry.narration',
                				'VoucherEntry.date','Account.name','Account.accounting_group_id','AccountAlias.name','AccountAlias.accounting_group_id'),
                				'conditions'=>$Jconditions));

                	}
              
                    //for receipt voucher
                    if($this->request->data['voucher_type'][$key] == 'Receipt'){
	                   $id = $this->VoucherLog->find('first',array('fields'=>array('voucher_id','user_id','account_id','patient_id'),
	                   		'conditions'=>array('VoucherLog.id'=>$value)));
	                   $userId = $id['VoucherLog']['user_id'];
	                   $accountId = $id['VoucherLog']['account_id'];
	                   $patientId = $id['VoucherLog']['patient_id'];
	                   $Rconditions['AccountReceipt.id']=$id['VoucherLog']['voucher_id'];
	                    $this->AccountReceipt->bindModel(array(
	                            "belongsTo"=>array(
	                                    "Account"=>array('foreignKey' =>false,'conditions'=>array('Account.id'=>$userId)),
	                            		"AccountAlias"=>array('className'=>'Account',"foreignKey"=>false ,'conditions'=>array('AccountAlias.id'=>$accountId)),
	                            		"Patient"=>array('foreignKey' =>false,'conditions'=>array('Patient.id'=>$patientId)),
	                            ))) ;
	                    $receiptVoucher=$this->AccountReceipt->find('all',array('fields'=>array('AccountReceipt.id','AccountReceipt.paid_amount',
	                    		'AccountReceipt.narration','AccountReceipt.date','Account.name','Account.accounting_group_id','AccountAlias.name',
	                    		'AccountAlias.accounting_group_id','Patient.admission_type'),
	                            'conditions'=>$Rconditions));
                    }
                 //for payment voucher
                    if($this->request->data['voucher_type'][$key] == 'Payment'){
                    	$paymentLogid = $this->VoucherLog->find('first',array('fields'=>array('VoucherLog.voucher_id','VoucherLog.user_id','VoucherLog.account_id',
                    			'VoucherLog.type'),'conditions'=>array('VoucherLog.id'=>$value)));
                    	$userId = $paymentLogid['VoucherLog']['user_id'];
                    	$accountId = $paymentLogid['VoucherLog']['account_id'];
                    	$Pconditions['VoucherPayment.id']=$paymentLogid['VoucherLog']['voucher_id'];
	                    $this->VoucherPayment->bindModel(array(
	                            "belongsTo"=>array(
	                                    "Account"=>array('foreignKey' =>false,'conditions'=>array('Account.id'=>$userId)),
	                            		"AccountAlias"=>array('className'=>'Account',"foreignKey"=>false,'conditions'=>array('AccountAlias.id'=>$accountId)),
	                            ))) ;
	                    $paymentVoucher=$this->VoucherPayment->find('all',array('fields'=>array('VoucherPayment.id','VoucherPayment.paid_amount',
	                    		'VoucherPayment.narration','VoucherPayment.date','Account.name','Account.accounting_group_id','AccountAlias.name',
	                    		'AccountAlias.accounting_group_id'),
	                    		'conditions'=>$Pconditions));
                    }
                    //for contra voucher
                    if($this->request->data['voucher_type'][$key] == 'Contra'){
                    	$id = $this->VoucherLog->find('first',array('fields'=>array('voucher_id','user_id','account_id'),
                    			'conditions'=>array('VoucherLog.id'=>$value)));
                    	$userId = $id['VoucherLog']['user_id'];
                    	$accountId = $id['VoucherLog']['account_id'];
                    	$Cconditions['ContraEntry.id']=$id['VoucherLog']['voucher_id'];
                    	$this->ContraEntry->bindModel(array(
                    			"belongsTo"=>array(
                    					"Account"=>array('foreignKey'=>false,'conditions'=>array('Account.id'=>$userId)),
                    					"AccountAlias"=>array('className'=>'Account',"foreignKey"=>false ,'conditions'=>array('AccountAlias.id'=>$accountId)),
                    			))) ;
                    	$contraVoucher=$this->ContraEntry->find('all',array('fields'=>array('ContraEntry.id','ContraEntry.debit_amount','ContraEntry.date',
                    			'ContraEntry.narration','Account.name','Account.accounting_group_id','AccountAlias.name','AccountAlias.accounting_group_id'),
                    			'conditions'=>$Cconditions));
                    }
                    //for purchase voucher
                	if($this->request->data['voucher_type'][$key] == 'Purchase'){
                    	$voucherLogData = $this->VoucherLog->find('first',array('fields'=>array('purchase_value'),'conditions'=>array('VoucherLog.id'=>$value)));
                    	$unserializeData = unserialize($voucherLogData['VoucherLog']['purchase_value']);
                    	
                    	$this->VoucherEntry->bindModel(array(
                    			"belongsTo"=>array(
                    					"Account"=>array('foreignKey'=>false,'conditions'=>array('VoucherEntry.account_id=Account.id')),
                    			))) ;
                    	$purchaseVoucher=$this->VoucherEntry->find('all',array('fields'=>array('VoucherEntry.id','VoucherEntry.debit_amount','VoucherEntry.create_time',
                    			'Account.name','Account.accounting_group_id','VoucherEntry.type',),
                    			'conditions'=>array('VoucherEntry.batch_identifier'=>$unserializeData['BatchIdentifier'])));
                    	
                    	$this->VoucherLog->bindModel(array(
                    			"belongsTo"=>array(
                    					"Account"=>array('foreignKey'=>false,'conditions'=>array('VoucherLog.user_id=Account.id','VoucherLog.voucher_type'=>'Purchase')),
                    			))) ;
                    	$purchaseDetails=$this->VoucherLog->find('first',array('fields'=>array('VoucherLog.debit_amount','VoucherLog.narration','VoucherLog.id',
                    			'VoucherLog.create_time','Account.name','Account.accounting_group_id'),
                    			'conditions'=>array('VoucherLog.id'=>$value,'VoucherLog.voucher_type'=>'Purchase')));
                    	
                    }
                     
                    //for company name
                    $companyName = $this->request->data['companyName'][$key];
                    
                    $serviceArray= array();
                    // Joural
                    if($this->request->data['voucher_type'][$key] == "Receipt"){
                        $vchType = $this->request->data['voucher_type'][$key];
                        foreach($receiptVoucher as $key=>$data){
	                        	$groupName = $this->AccountingGroup->getGroupNameById($data['Account']['accounting_group_id']);
	                        	$groupNameService = $this->AccountingGroup->getGroupNameById($data['AccountAlias']['accounting_group_id']);
	                        	
	                        	$parentId =  $this->AccountingGroup->getParentId($data['Account']['accounting_group_id']);
	                        	$parentGroupName =  $this->AccountingGroup->getGroupNameById($parentId);
	                        	
	                        	$parentAliasId =  $this->AccountingGroup->getParentId($data['AccountAlias']['accounting_group_id']);
	                        	$parentGroupAliasName =  $this->AccountingGroup->getGroupNameById($parentAliasId);
	                        	
	                            $serviceArray[$key] = array('isPosted'=>$this->request->data['postedId'][$key],
                            									'id'=>$data['AccountReceipt']['id'],
								                             	'name'=>$data['Account']['name'],
								                            	'amount'=>$data['AccountReceipt']['paid_amount'],
								                            	'narration'=>$data['AccountReceipt']['narration'],
								                             	'date'=> date('Ymd',strtotime($data['AccountReceipt']['date'])),
								                             	'type'=>"Receipt",
								                            	'group'=> $groupName,
	                            								'parentGroup'=>$parentGroupName,
								                            	'aliasName'=>$data['AccountAlias']['name'],
	                            								'parentAliasGroup'=>$parentGroupAliasName,
								                            	'servicegroup'=> $groupNameService); 
                        }
                    }else if($this->request->data['voucher_type'][$key] == "Payment"){
                        $vchType = $this->request->data['voucher_type'][$key];
                        foreach($paymentVoucher as $key=>$data){
	                        	if($paymentLogid['VoucherLog']['type']=="RefferalCharges"){
	                        		$name ="ML Enterprise";
	                        	}else{
	                        		$name = $data['Account']['name'];
	                        	}
                        		$groupName = $this->AccountingGroup->getGroupNameById($data['Account']['accounting_group_id']);
                        		$groupNameService = $this->AccountingGroup->getGroupNameById($data['AccountAlias']['accounting_group_id']);
                        	
	                        	$parentId =  $this->AccountingGroup->getParentId($data['Account']['accounting_group_id']);
	                        	$parentGroupName =  $this->AccountingGroup->getGroupNameById($parentId);
	                        	
	                        	$parentAliasId =  $this->AccountingGroup->getParentId($data['AccountAlias']['accounting_group_id']);
	                        	$parentGroupAliasName =  $this->AccountingGroup->getGroupNameById($parentAliasId);
	                        	
	                            $serviceArray[$key]= array('isPosted'=>$this->request->data['postedId'][$key],
									                         'id'=>$data['VoucherPayment']['id'],
									                         'name'=>$name,
									                         'amount'=>$data['VoucherPayment']['paid_amount'],
									                         'narration'=>$data['VoucherPayment']['narration'],
									                         'date'=> date('Ymd',strtotime($data['VoucherPayment']['date'])),
									                         'type'=>"Payment",
									                         'group'=> $groupName,
	                            							 'parentGroup'=>$parentGroupName,
									                         'aliasName'=>$data['AccountAlias']['name'],
	                            							 'parentAliasGroup'=>$parentGroupAliasName,
									                         'servicegroup'=> $groupNameService);
                        }
                    }else if($this->request->data['voucher_type'][$key] == "Contra"){
                        $vchType = $this->request->data['voucher_type'][$key];
                        foreach($contraVoucher as $key=>$data){
	                        	$groupName = $this->AccountingGroup->getGroupNameById($data['Account']['accounting_group_id']);
	                        	$groupNameService = $this->AccountingGroup->getGroupNameById($data['AccountAlias']['accounting_group_id']);
	                        	 
	                        	$parentId =  $this->AccountingGroup->getParentId($data['Account']['accounting_group_id']);
	                        	$parentGroupName =  $this->AccountingGroup->getGroupNameById($parentId);
	                        	
	                        	$parentAliasId =  $this->AccountingGroup->getParentId($data['AccountAlias']['accounting_group_id']);
	                        	$parentGroupAliasName =  $this->AccountingGroup->getGroupNameById($parentAliasId);
                        	
	                        	$serviceArray[$key]=array('isPosted'=>$this->request->data['postedId'][$key],
								                            'id'=>$data['ContraEntry']['id'],
								                            'name'=>$data['Account']['name'],
								                            'amount'=>$data['ContraEntry']['debit_amount'],
								                           	'narration'=>$data['ContraEntry']['narration'],
								                           	'date'=> date('Ymd',strtotime($data['ContraEntry']['date'])),
								                           	'type'=>"Contra",
								                           	'group'=> $groupName,
	                        								'parentGroup'=>$parentGroupName,
								                           	'aliasName'=>$data['AccountAlias']['name'],
	                        								'parentAliasGroup'=>$parentGroupAliasName,
								                           	'servicegroup'=> $groupNameService);
                        }
                    }else if(($this->request->data['voucher_type'][$key] == "Journal") && (empty($this->request->data['patientId'][$key]))){
                    	$vchType = $this->request->data['voucher_type'][$key];
                    	foreach($journalVoucherOther as $key=>$data){
	                    		$groupName = $this->AccountingGroup->getGroupNameById($data['Account']['accounting_group_id']);
	                    		$groupNameService = $this->AccountingGroup->getGroupNameById($data['AccountAlias']['accounting_group_id']);
	                    		 
	                    		$parentId =  $this->AccountingGroup->getParentId($data['Account']['accounting_group_id']);
	                    		$parentGroupName =  $this->AccountingGroup->getGroupNameById($parentId);
	                    		
	                    		$parentAliasId =  $this->AccountingGroup->getParentId($data['AccountAlias']['accounting_group_id']);
	                    		$parentGroupAliasName =  $this->AccountingGroup->getGroupNameById($parentAliasId);
                    		
	                    		$othersJournal = "Others Journal";
	                    		
	                    		$serviceArray[$key]=array('isPosted' => $this->request->data['postedId'][$key],
								                    		'id'=>$data['VoucherEntry']['id'],
								                    		'name'=>$data['Account']['name'],
								                    		'amount'=>$data['VoucherEntry']['debit_amount'],
								                    		'narration'=>$data['VoucherEntry']['narration'],
								                    		'date'=> date('Ymd',strtotime($data['VoucherEntry']['date'])),
								                    		'type'=>"Journal",
								                    		'group'=> $groupName,
	                    									'parentGroup'=>$parentGroupName,
								                    		'patient_id'=>$this->request->data['patientId'][$key],
								                    		'aliasName'=>$data['AccountAlias']['name'],
	                    									'parentAliasGroup'=>$parentGroupAliasName,
								                    		'servicegroup'=> $groupNameService,
	                    									'voucher_no'=>$id['VoucherLog']['voucher_no'],
	                    									'voucher_log_type'=>$id['VoucherLog']['type'],
	                    									'tariff_standard_name'=>$id['VoucherLog']['tariff_standard_name']);
                    	}
                    }else if(($this->request->data['voucher_type'][$key] == "Journal") && !empty($this->request->data['patientId'][$key]) && $this->request->data['logType'][$key] != 'Discount'){
                        $vchType = $this->request->data['voucher_type'][$key];
                        foreach($journalVoucher as $key=>$data){
	                        	$groupName = $this->AccountingGroup->getGroupNameById($data['Account']['accounting_group_id']);
	                        	$serviceArray[$key]=array('isPosted'=>$this->request->data['postedId'][$key],
								                           'id'=>$data['VoucherEntry']['id'],
								                           'name'=>$data['Account']['name'],
								                           'amount'=>$data['VoucherEntry']['debit_amount'],
								                           'narration'=>$patientDetails['VoucherLog']['narration'],
								                           'date'=> date('Ymd',strtotime($data['VoucherEntry']['create_time'])),
								                           'type'=>"Journal",
								                           'group'=>$groupName,
								                           'patient_id'=>$data['VoucherEntry']['patient_id']);
                        }
                        $groupName = $this->AccountingGroup->getGroupNameById($patientDetails['Account']['accounting_group_id']);
                        $subgroupName = $this->AccountingGroup->getGroupNameById($patientDetails['Account']['accounting_sub_group_id']);
                        $subSubGroupName = $this->AccountingGroup->getGroupNameById($patientDetails['Account']['accounting_sub_sub_group_id']);
                        
                        $patientDetails['Account']['group']=$groupName;
                        $patientDetails['Account']['sub_group']=$subgroupName;
                       	$patientDetails['Account']['sub_sub_group']=$subSubGroupName;
                        $patientDetails['Account']['type']='Journal';
                        $patientDetails['VoucherLog']['date']= date('Ymd',strtotime($patientDetails['VoucherLog']['create_time']));
                    }else if($this->request->data['logType'][$key] == 'Discount'){ //for discount entry
                    	$vchType = $this->request->data['voucher_type'][$key];
                    	foreach($discountData as $key=>$data){
	                    		$groupName = $this->AccountingGroup->getGroupNameById($data['Account']['accounting_group_id']);
	                    		$groupNameService = $this->AccountingGroup->getGroupNameById($data['AccountAlias']['accounting_group_id']);
	                    		
	                    		$parentId =  $this->AccountingGroup->getParentId($data['Account']['accounting_group_id']);
	                    		$parentGroupName =  $this->AccountingGroup->getGroupNameById($parentId);
	                    		
	                    		$parentAliasId =  $this->AccountingGroup->getParentId($data['AccountAlias']['accounting_group_id']);
	                    		$parentGroupAliasName =  $this->AccountingGroup->getGroupNameById($parentAliasId);
                    		
                    			$othersJournal = "Others Journal";
                    			$serviceArray[$key]=array('isPosted' => $this->request->data['postedId'][$key],
						                    				'id'=>$data['VoucherEntry']['id'],
						                    				'name'=>$data['Account']['name'],
						                    				'amount'=>$data['VoucherEntry']['debit_amount'],
						                    				'narration'=>$data['VoucherEntry']['narration'],
						                    				'date'=> date('Ymd',strtotime($data['VoucherEntry']['date'])),
						                    				'type'=>"Journal",
						                    				'group'=> $groupName,
                    										'parentGroup'=>$parentGroupName,
						                    				'aliasName'=>$data['AccountAlias']['name'],
                    										'parentAliasGroup'=>$parentGroupAliasName,
						                    				'servicegroup'=> $groupNameService,
                    										'voucher_no'=>$id['VoucherLog']['voucher_no'],
	                    									'voucher_log_type'=>$id['VoucherLog']['type']);
                    	}
                    }else if($this->request->data['voucher_type'][$key] == "Purchase"){
                        $vchType = $this->request->data['voucher_type'][$key];
                        foreach($purchaseVoucher as $key=>$data){
                        		$parentTaxId =  $this->AccountingGroup->getParentId($data['Account']['accounting_group_id']);
                        		$parentTaxName =  $this->AccountingGroup->getGroupNameById($parentTaxId);
	                        	$groupName = $this->AccountingGroup->getGroupNameById($data['Account']['accounting_group_id']);
	                        	
	                        	$serviceArray[$key]=array('isPosted'=>$this->request->data['postedId'][$key],
								                           'id'=>$data['VoucherEntry']['id'],
								                           'name'=>$data['Account']['name'],
								                           'amount'=>$data['VoucherEntry']['debit_amount'],
								                           'narration'=>$purchaseDetails['VoucherLog']['narration'],
								                           'date'=> date('Ymd',strtotime($data['VoucherEntry']['create_time'])),
								                           'type'=>"Purchase",
								                           'group'=>$groupName,
	                        							   'parentTaxGroup'=>$parentTaxName,
	                        							   'entry_type'=>$data['VoucherEntry']['type'],
	                        							   'reference'=>$unserializeData['InvoiceNo']);
                        }
                        $parentId =  $this->AccountingGroup->getParentId($purchaseDetails['Account']['accounting_group_id']);
						$parentGroupName =  $this->AccountingGroup->getGroupNameById($parentId);
                        $groupName = $this->AccountingGroup->getGroupNameById($purchaseDetails['Account']['accounting_group_id']);
                        
                        $purchaseDetails['Account']['group']=$groupName;
                        $purchaseDetails['Account']['parentGroup']=$parentGroupName;
                        $purchaseDetails['Account']['type']='Purchase';
                        $purchaseDetails['VoucherLog']['date']= date('Ymd',strtotime($purchaseDetails['VoucherLog']['create_time']));
                    }
                  $getResult=$this->Account->postToTally($value,$companyName,$vchType,$tallyRequest="Import",$tallyDataType="Data",$serviceArray,
                  		$patientDetails,$othersJournal,$purchaseDetails);
                }
            }
            if($getResult['ERRORS']>0){
                echo $getResult['LINEERROR'];exit;
            }else{
                echo 'Voucher Successfully Posted to Tally';
            }
            exit;
        }
    }
	
	public function narration_box($patientid,$voucherId=null){
		$this->layout='advance_ajax';
		$this->uses = array("VoucherEntry");
		$vconditions['VoucherEntry.patient_id']=$patientid;
		$vconditions['VoucherEntry.location_id']=$this->Session->read('locationid');
		$vconditions['VoucherEntry.type']='FinalBilling';
		if(!empty($patientid) && empty($this->request->data)){
			$id = $this->VoucherEntry->find('first',array('fields'=>array('VoucherEntry.id'),'conditions'=>$vconditions));
			$voucherId = $id['VoucherEntry']['id'];
			$this->set('patientid',$patientid);
			$this->set('voucherId',$voucherId);
		}else{
			if(!empty($this->request->data)){
				if(!empty($voucherId)){
					$data['VoucheEntry']['id'] = $voucherId;	//$id holds the Voucher's id
					$data['VoucheEntry']['final_voucher_narration'] =$this->request->data['accountings']['narration'];
					$this->VoucherEntry->save($data['VoucheEntry']);
					$getResult=$this->post_to_tally($patientid);
					$this->set('close',$getResult);
				}
			}
		}
	}

	function day_book($is_print = null){
		$this->layout = 'advance';
		$this->uses = array('VoucherLog');
		if($this->request->data){
			$click=1;
			$userid=$this->request->data['Voucher']['patient_id'];
			if(!empty($this->request->data['Voucher']['from'])){
				$logConditions['VoucherLog.create_time >='] = $this->DateFormat->formatDate2STDForReport($this->request->data['Voucher']['from'],Configure::read('date_format'))." 00:00:00";
				$from=$this->request->data['Voucher']['from'];
			}else{
				$logConditions['VoucherLog.create_time >=']=date('Y-m-d').' 00:00:00';
				$from=date('01/01/Y');
			}if(!empty($this->request->data['Voucher']['to'])){
				$logConditions['VoucherLog.create_time <='] = $this->DateFormat->formatDate2STDForReport($this->request->data['Voucher']['to'],Configure::read('date_format'))." 23:59:59";
				$to=$this->request->data['Voucher']['to'];
			}else{
				$logConditions['VoucherLog.create_time <=']=date('Y-m-d').' 23:59:59';
				$to=date('d/m/Y');
			}
			if(!empty($this->request->data['Voucher']['patient_id'])){
				$logConditions['OR']=array('VoucherLog.user_id'=>$userid,'VoucherLog.account_id'=>$userid);
			}
			
			if(!empty($this->request->data['Voucher']['type'])){
				if($this->request->data['Voucher']['type'] == '1'){
					$logConditions['VoucherLog.voucher_type']='Journal';
				}else if($this->request->data['Voucher']['type'] == '2'){
					$logConditions['VoucherLog.voucher_type']='Receipt';
				}else if($this->request->data['Voucher']['type'] == '3'){
					$logConditions['VoucherLog.voucher_type']='Payment';
				}else if($this->request->data['Voucher']['type'] == '4'){
					$logConditions['VoucherLog.voucher_type']='Contra';
				}else if($this->request->data['Voucher']['type'] == '5'){
					$logConditions['VoucherLog.voucher_type']='Purchase';
				}
			}
			
			if(!empty($this->request->data['Voucher']['is_posted'])){
				if($this->request->data['Voucher']['is_posted'] == '1'){
					$logConditions['VoucherLog.is_posted']='1';
				}else if($this->request->data['Voucher']['is_posted'] == '2'){
					$logConditions['VoucherLog.is_posted']='0';
				}else if($this->request->data['Voucher']['is_posted'] == '3'){
					$logConditions['VoucherLog.is_posted']='2';
				}
			}
		}
		
		if($this->request->query){
			if($this->request->query['type'] == '1'){
				$logConditions['VoucherLog.voucher_type']='Journal';
			}else if($this->request->query['type'] == '2'){
				$logConditions['VoucherLog.voucher_type']='Receipt';
			}else if($this->request->query['type'] == '3'){
				$logConditions['VoucherLog.voucher_type']='Payment';
			}else if($this->request->query['type'] == '4'){
				$logConditions['VoucherLog.voucher_type']='Contra';
			}else if($this->request->query['type'] == '5'){
				$logConditions['VoucherLog.voucher_type']='Purchase';
			}else{
				$logConditions['VoucherLog.is_deleted']='0';
			}
			if($this->request->query['is_posted'] == '1'){
				$logConditions['VoucherLog.is_posted']='1';
			}else if($this->request->query['is_posted'] == '2'){
				$logConditions['VoucherLog.is_posted']='0';
			}else if($this->request->query['is_posted'] == '3'){
				$logConditions['VoucherLog.is_posted']='2';
			}
		}

		$this->VoucherLog->bindModel(array(
				'belongsTo'=>array(
						"Account"=>array('foreignKey' =>false,'conditions'=>array('Account.id=VoucherLog.user_id')),
						"AccountAlias"=>array('className'=>'Account',"foreignKey"=>false ,'conditions'=>array('AccountAlias.id=VoucherLog.account_id')),
						"Patient" =>array('foreignKey' => false,'conditions'=>array('VoucherLog.patient_id=Patient.id')),
						"TariffStandard" =>array('foreignKey' => false,'conditions'=>array('TariffStandard.id=Patient.tariff_standard_id')),
						
				)),false);
		$logConditions['VoucherLog.location_id']=$this->Session->read('locationid');
		$logConditions['VoucherLog.is_deleted']='0';
		if(empty($this->request->data)){
			$logConditions['VoucherLog.create_time >=']=date('Y-m-d').' 00:00:00';
			$logConditions['VoucherLog.create_time <=']=date('Y-m-d').' 23:59:59';
		}
			
		$voucherLogData=$this->VoucherLog->find('all',array('fields'=>array('VoucherLog.id','VoucherLog.is_posted','VoucherLog.debit_amount',
				'VoucherLog.narration','VoucherLog.voucher_type','VoucherLog.voucher_id','VoucherLog.create_time','VoucherLog.patient_id',
				'VoucherLog.billing_id','VoucherLog.voucher_no','VoucherLog.paid_amount','VoucherLog.type','VoucherLog.date','Account.name','AccountAlias.name',
				'Patient.lookup_name','Patient.admission_id','TariffStandard.name'),
				'conditions'=>array($logConditions),
				'order' => array('VoucherLog.create_time' => 'DESC')));

		$this->set('data',$voucherLogData);
		if(empty($from)){
			$from = $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'));
		}
		if(empty($to)){
			$to = $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'));
		}
		$this->set(compact('from','to','type','isPosted','userid'));
		if(empty($is_print)){
			if($this->request->query){
				$this->set('data',$voucherLogData);
				$this->render('ajax_day_book',false);
			}
		}
	}
	
	//For print patient ledger by amit jain
	function print_patient_ledger(){
		$this->uses = array('AccountBillingInterface','Patient','FinalBilling','Billing','Patient','AccountReceipt');
		$this->request->data['Voucher'] = $this->params->query ;
		$this->get_patient_details();
		$this->layout = false;
	}
	public function print_legder_voucher(){
		$this->uses=array('VoucherEntry','AccountReceipt','VoucherPayment','Account','Billing','ContraEntry');
		$this->request->data['VoucherEntry'] = $this->params->query ;
		$this->legder_voucher();
		$this->layout = false;
	}
	
	function sub_group_summary(){
		$this->layout = 'advance';
		$this->uses=array('Account','AccountingGroup');
		if(!empty($this->request->data['Group']['group_id'])){
			$groupId = $this->request->data['Group']['group_id'];
		}
		
		 if($this->request->data){
		 	$this->Account->bindModel(array(
		 			"belongsTo"=>array(
		 					"AccountingGroup"=>array("foreignKey"=>false,'type'=>'INNER','conditions'=>array('Account.accounting_sub_group_id=AccountingGroup.id')),
		 					"VoucherReference"=>array("foreignKey"=>false,'conditions'=>array('VoucherReference.user_id=Account.id','VoucherReference.payment_type'=>'Cr')))));
		 	$subGroupsDetalis=$this->Account->find('all',array( 'fields'=>array('sum(VoucherReference.amount) AS sumAmount','AccountingGroup.*'),
		 											'conditions'=>array('AccountingGroup.parent_id !='=>'0','AccountingGroup.id'=>$groupId),
		 											'group'=>array('Account.accounting_sub_group_id')));
			$this->set('data',$subGroupsDetalis);
		}else{
			$this->Account->bindModel(array(
					"belongsTo"=>array(
							"AccountingGroup"=>array("foreignKey"=>false,'type'=>'INNER','conditions'=>array('Account.accounting_sub_group_id=AccountingGroup.id')),
							"VoucherReference"=>array("foreignKey"=>false,'conditions'=>array('VoucherReference.user_id=Account.id','VoucherReference.payment_type'=>'Cr')))));
			$subGroupsDetalis=$this->Account->find('all',array('fields'=>array('sum(VoucherReference.amount) AS sumAmount','AccountingGroup.*'),
													'conditions'=>array('AccountingGroup.parent_id !='=>'0'),
													'group'=>array('Account.accounting_sub_group_id')));
			$this->set('data',$subGroupsDetalis);
		} 
	}
	
	
	/**
	 * Patient Card
	 * @param unknown_type $id
	 * Pooja Gupta
	 */
	function patient_card($id){
		$this->layout="advance_ajax";
		$this->uses=array('Patient','Account','AccountReceipt','VoucherLog','VoucherPayment','PatientCard');
		
		if($this->request->data){ //debug($this->request->data);exit;
			$accDetails=$this->Account->find('first',array('conditions'=>array('Account.system_user_id'=>$this->request->data['Patient_card']['person_id'],
					'Account.user_type'=>'Patient')));		
			
			//cash amt
			if(!empty($this->request->data['Patient_card']['pay_amt'])){
				$mode='Cash';
				$paidAmt=$this->request->data['Patient_card']['pay_amt'];
				$cashId=$this->Account->getAccountIdOnly('cash');
				$this->request->data['pay']['cash']='1';
				//if opening balance of patient is '0' update opening balance
				/* if($accDetails['Account']['opening_balance']==0){
					$accDetails['Account']['opening_balance']=$this->request->data['Patient_card']['pay_amt'];
				} */
			}
				
			//credit card amt
			if(!empty($this->request->data['pay']['bank_amt'])){
				$mode='Credit ';
				$acc_no=$this->request->data['pay']['bank_acct_no'];
				$cashId=$this->request->data['pay']['bank'];
				$creditCard_no=$this->request->data['pay']['bank_card_no'];
				$paidAmt=$this->request->data['pay']['bank_amt'];
				//if opening balance of patient is '0' update opening balance
				/* if($accDetails['Account']['opening_balance']==0){
					$accDetails['Account']['opening_balance']=$this->request->data['pay']['bank_amt'];
				} */	
			}
				
			//cheque amt
			if(!empty($this->request->data['pay']['cheque_amt'])){
				$mode='Cheque';
				$acc_no=$this->request->data['pay']['cheque_acct_no'];				
				$paidAmt=$this->request->data['pay']['cheque_amt'];
				$cashId=$this->request->data['pay']['cheque_bank'];
				$cheque_no=$this->request->data['pay']['cheque_no'];
				//if opening balance of patient is '0' update opening balance
				/* if($accDetails['Account']['opening_balance']==0){
					$accDetails['Account']['opening_balance']=$this->request->data['pay']['cheque_amt'];
				} */
			}
			
			if(!empty($this->request->data['Patient_card']['corporate_adv'])){
				$this->request->data['Patient_card']['type']='Corporate Advance';
			}
			
			$patientCard['person_id']=$this->request->data['Patient_card']['person_id'];
			$patientCard['account_id']=$accDetails['Account']['id'];
			$patientCard['type']=$this->request->data['Patient_card']['type'];
			$patientCard['amount']=$paidAmt;
			$patientCard['bank_id']=$cashId;
			$patientCard['mode_type']=$mode;
			$patientCard['bank_account_no']=$acc_no;
			$patientCard['credit_card_no']=$creditCard_no;
			$patientCard['cheque_no']=$cheque_no;
			$patientCard['created_by']=$this->Session->read('userid');
			$patientCard['create_time']=date('Y-m-d H:i:s');
			
			if($this->request->data['Patient_card']['type']=='deposit'){
				$accDetails['Account']['card_balance']=$accDetails['Account']['card_balance']+$paidAmt;
			}else if($this->request->data['Patient_card']['type']=='refund'){
				$accDetails['Account']['card_balance']=$accDetails['Account']['card_balance']-$paidAmt;
			}else if($this->request->data['Patient_card']['type']=='Corporate Advance'){
				$accDetails['Account']['card_balance']=$accDetails['Account']['card_balance']+$paidAmt;
			}

			if($this->PatientCard->save($patientCard)){
				$patientCardId=$this->PatientCard->getLastInsertID();
				//updating Patient account
				$this->Account->saveAll($accDetails);
				//debug($accDetails);exit;
				
				$this->Account->id='';
				$this->request->data['patient_detail']=serialize($this->request->data['pay']);

				
				if(empty($this->request->data['Patient_card']['corporate_adv'])){
				
				//BOF for accounting by amit jain
				//creating reciept voucher if type is deposit / creating Payment voucher if type is refund
				$getPatientDetails=$this->Patient->find('first',array('conditions'=>array('Patient.id'=>$id),
						'fields'=>array('person_id','lookup_name','form_received_on')));//for patient details
				$patientName = $getPatientDetails['Patient']['lookup_name'];
				$mode = $patientCard['mode_type'];
				$regDate  =  $this->DateFormat->formatDate2Local($getPatientDetails['Patient']['form_received_on'],Configure::read('date_format'),true);
				$doneDate  =  $this->DateFormat->formatDate2Local($patientCard['create_time'],Configure::read('date_format'),true);
				$ptCardId = $this->Account->getAccountIdOnly(Configure::read('PatientCardLabel'));//for patient card id
				
				if($this->request->data['Patient_card']['type']=='deposit'){
					$narrationDetails = "Being $mode received from patient card against Pt. $patientName done on $doneDate" ;
					$voucherLogDataFinalpayment = $rvData = array('date'=>$patientCard['create_time'],
							'create_by'=>$this->Session->read('userid'),
							'modified_by'=>$this->Session->read('userid'),
							'patient_id'=>$id,
							'account_id'=>$cashId,
							'user_id'=>$ptCardId,
							'type'=>'PatientCard',
							'narration'=>$narrationDetails,
							'paid_amount'=>$paidAmt,
							'patient_card_detail'=>$this->request->data['patient_detail']);
					if(!empty($rvData['paid_amount']) && ($rvData['paid_amount'] != 0)){
						$lastVoucherIdRecFinal=$this->AccountReceipt->insertReceiptEntry($rvData);
						$this->Account->setBalanceAmountByAccountId($ptCardId,$paidAmt,'debit');
						$this->Account->setBalanceAmountByUserId($cashId,$paidAmt,'credit');
						//insert into voucher_logs table added by PankajM
						$voucherLogDataFinalpayment['voucher_no']=$lastVoucherIdRecFinal;
						$voucherLogDataFinalpayment['voucher_id']=$lastVoucherIdRecFinal;
						$voucherLogDataFinalpayment['voucher_type']="Receipt";
						$this->VoucherLog->insertVoucherLog($voucherLogDataFinalpayment);
						$voucherId=$lastVoucherIdRecFinal;// voucher id
					}
				}else if($this->request->data['Patient_card']['type']=='refund'){
					// for refund
					$refundNarration = "Being $mode refund from patient card against Pt. $patientName done on $doneDate" ;
					$voucherLogDataPay=$pvData = array('date'=>$patientCard['create_time'],
							'create_by'=>$this->Session->read('userid'),
							'modified_by'=>$this->Session->read('userid'),
							'patient_id'=>$id,
							'account_id'=>$cashId,
							'user_id'=>$ptCardId,
							'type'=>'PatientCardRefund',
							'narration'=>$refundNarration,
							'paid_amount'=>$paidAmt);
					if(!empty($paidAmt) && ($paidAmt != 0)){
						$lastVoucherIdPayment=$this->VoucherPayment->insertPaymentEntry($pvData);
						$this->Account->setBalanceAmountByAccountId($cashId,$paidAmt,'debit');
						$this->Account->setBalanceAmountByUserId($ptCardId,$paidAmt,'credit');
						//insert into voucher_logs table added by PankajM
						$voucherLogDataPay['voucher_no']=$lastVoucherIdPayment;
						$voucherLogDataPay['voucher_id']=$lastVoucherIdPayment;
						$voucherLogDataPay['voucher_type']="Payment";
						$this->VoucherLog->insertVoucherLog($voucherLogDataPay);
						$voucherId=$lastVoucherIdPayment;// voucher id
						$this->VoucherLog->id= '';
						$this->VoucherPayment->id= '';
					}
				}
				
			//EOF accounting
			
				}
				$this->PatientCard->updateAll(array('voucher_id'=>$voucherId),array('id'=>$patientCardId));
			}
			$this->redirect($this->referer().'&print='.$patientCardId);
			//$this->redirect(array("controller" => "Accounting", "action" => "patient_card",'?'=>array('print'=>$patientCardId)));
	
		}
		
		$this->Patient->unbindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn')));		
		$this->Patient->bindModel(array('belongsTo'=>array(
				'Person'=>array('foreignKey'=>false,'conditions'=>array('Person.id=Patient.person_id')),
				'State'=>array('foreignKey'=>false,'conditions'=>array('Person.state=State.id')),
				'TariffStandard'=>array('foreignKey'=>false,'conditions'=>array('Patient.tariff_standard_id=TariffStandard.id')),
				'Account'=>array('foreignKey'=>false,'conditions'=>array('Account.system_user_id=Patient.person_id')),
				)),false);
	
		$this->Account->bindModel(array(
				'belongsTo' => array(
						'AccountingGroup'=>array('foreignKey' => false,'conditions'=>array('AccountingGroup.id=Account.accounting_group_id')),
				)),false);
		$bankData =$this->Account->find('all',array('fields'=>array('id','name'),'conditions'=>array('Account.is_deleted'=>'0',
				'AccountingGroup.name'=>Configure::read('bankLabel'))));
		$bankDataArray = array();
		foreach($bankData as $bank){
			$bankDataArray[$bank['Account']['id']] = $bank['Account']['name'];
		}
		$this->set('bankData',$bankDataArray);
	
		$patient=$this->Patient->find('all',array('fields'=>array('Person.plot_no','Person.landmark','Person.city','Person.pin_code','Patient.id','Person.mobile','Person.email','Patient.lookup_name','Patient.admission_id','Person.sex','Patient.email','Account.card_balance',
				/*'CONCAT(Person.plot_no,", ",Person.landmark,", ",Person.city,"- ",Person.pin_code) as address'*/'Person.id','Account.id','State.name',
				'Patient.admission_type','Patient.mobile_phone','Account.account_code','TariffStandard.name'),
				'conditions'=>array('Patient.id'=>$id,'Account.user_type'=>'Patient')));
		
		$this->PatientCard->bindModel(array('belongsTo'=>array(
				'Person'=>array('foreignKey'=>false,'conditions'=>array('Person.id=PatientCard.person_id')),
				
		)),false);
		
		$acc=$this->PatientCard->find('all',array('fields'=>array('PatientCard.*'),
				'conditions'=>array('PatientCard.person_id'=>$patient[0]['Person']['id']),
				));
		foreach($acc as $accData){
			if(!empty($accData['PatientCard']['create_time'])){
				$aData[$accData['PatientCard']['create_time']][]=$accData['PatientCard'];
			}
			
		}
		krsort($aData);
		$this->set('dataAcc',$aData);
		$this->set('patient',$patient);
	
	}
	
	
	/**
	 * function for print of spot and backing amount
	 * By-Pooja Gupta 
	 */
	
	public function printSpotPaymentVoucher($id=null){
		$this->layout = false;
		$this->uses = array('VoucherPayment','Account','VoucherReference');
		
		$this->VoucherPayment->bindModel(array(
				'belongsTo'=>array(
						'Account'=>array("foreignKey"=>false ,'conditions'=>array('Account.id=VoucherPayment.user_id')),
						'Consultant'=>array('foreignKey'=>false,'conditions'=>array('Account.system_user_id=Consultant.id','Account.user_type'=>'Consultant')),
						'AccountAlias'=>array('className'=>'Account',"foreignKey"=>false ,'conditions'=>array('AccountAlias.id=VoucherPayment.account_id'))),
		));
		if(!empty($id)){
			
			$voucherPaymentData = $this->VoucherPayment->find('first',array('fields' => array('Account.name','Account.balance','VoucherPayment.*','Consultant.market_team',
					'AccountAlias.name','AccountAlias.balance'),
					'conditions'=>array('VoucherPayment.id'=>$id,'VoucherPayment.is_deleted=0')));
			$voucherReferenceData = $this->VoucherReference->find('first',array('fields' => array('VoucherReference.reference_type_id','reference_no'),'conditions'=>array('VoucherReference.voucher_id'=>$id)));
	
			if($voucherPaymentData['Account']['balance'] < 0 ){
				$voucherPaymentData['Account']['balance']=$this->Number->currency(ceil($voucherPaymentData['Account']['balance']*(-1)))." Cr";
			}else{
				$voucherPaymentData['Account']['balance']=$this->Number->currency(ceil($voucherPaymentData['Account']['balance']))." Dr";
			}
			if($voucherPaymentData['AccountAlias']['balance'] < 0 ){
				$voucherPaymentData['AccountAlias']['balance']=$this->Number->currency(ceil($voucherPaymentData['AccountAlias']['balance']*(-1)))." Cr";
			}else{
				$voucherPaymentData['AccountAlias']['balance']=$this->Number->currency(ceil($voucherPaymentData['AccountAlias']['balance']))." Dr";
			}
			//debug($voucherPaymentData);exit;
			$this->set(array('voucherPaymentData'=>$voucherPaymentData,'voucherReferenceData'=>$voucherReferenceData));
			if($this->params->query['mlPrint']){
				$this->render('mlEnterpriseInvoice');
			}
				
		}	
	}
	
	function daily_collection($Reporttype=null){
		$this->layout = 'advance';
		$this->uses=array('User','PatientCard','Account','Role','Billing','Location','PharmacySalesBill');
		$this->set('locationList',$this->Location->getLocationIdByHospital());
		
		if(!empty($this->params->query)){
			$this->request->data['Voucher']=$this->params->query;
		}
		if(!empty($this->request->data['Voucher']['date'])){
			$date = $this->DateFormat->formatDate2STDForReport($this->request->data['Voucher']['date'],Configure::read('date_format'));
			$transDate = $this->request->data['Voucher']['date'];
		}else{
			$date = date('Y-m-d');
			$transDate = date('d/m/Y');
		}
		
		$getCashId = $this->Account->find('list',array('fields'=>array('Account.id'),
				'conditions'=>array('Account.name'=>Configure::read('cash'),'Account.is_deleted'=>0)));
		
		$roleConditions['Role.code_name'] = array(Configure::read('frontOffice_role'),Configure::read('cashier_role'),Configure::read('pharmacy_role'),
				Configure::read('adminLabel'),Configure::read('otpharmacycode'));
	
		if($this->Session->read('website.instance')=='vadodara'){
			if($this->Session->read('role') != 'Admin' && $this->Session->read('role') != 'Accounts Assistant'){
				$userConditions['User.id'] = $this->Session->read('userid');
				$userConditions['User.location_id'] = $this->Session->read('locationid');
			}
		}else{
			if($this->Session->read('role') != 'Admin' ){
				$userConditions['User.id'] = $this->Session->read('userid');
				$userConditions['User.location_id'] = $this->Session->read('locationid');
			}
		}
		
		$this->User->unBindModel(array(
				'belongsTo' => array('City','State','Country','Role','Initial')),false);
		
			$this->User->bindModel(array(
						'belongsTo'=>array(
								"Role"=>array("foreignKey"=>false,'type'=>'INNER','conditions'=>array($roleConditions,'User.role_id=Role.id'),'order'=>array('Role.name'=>'asc'))),
						"hasMany"=>array(
								"Billing"=>array('fields'=>array('SUM(amount) as total','SUM(paid_to_patient) as return_total','SUM(discount) as total_discount'),"foreignKey"=>'created_by',
										'conditions'=>array('DATE_FORMAT(Billing.date,"%Y-%m-%d")'=>$date,'Billing.is_deleted'=>'0','Billing.mode_of_payment'=>'Cash'),
										'group'=>array('Billing.created_by')),
														
								"PatientCard"=>array('fields'=>array('SUM(amount) as card_total'),"foreignKey"=>'created_by',
										'conditions'=>array('DATE_FORMAT(PatientCard.create_time,"%Y-%m-%d")'=>$date,'PatientCard.type'=>'deposit','PatientCard.mode_type'=>'Cash'),
										'group'=>array('PatientCard.created_by')),
								
								"PatientCardAlias"=>array('className'=>'PatientCard','fields'=>array('SUM(amount) as card_refund'),"foreignKey"=>'created_by',
										'conditions'=>array('DATE_FORMAT(PatientCardAlias.create_time,"%Y-%m-%d")'=>$date ,'PatientCardAlias.type'=>'refund','PatientCardAlias.mode_type'=>'Cash'),
										'group'=>array('PatientCardAlias.created_by')),
								
								"PatientCardAliasTwo"=>array('className'=>'PatientCard','fields'=>array('SUM(amount) as card_payment'),"foreignKey"=>'created_by',
										'conditions'=>array('DATE_FORMAT(PatientCardAliasTwo.create_time,"%Y-%m-%d")'=>$date ,'PatientCardAliasTwo.type'=>'Payment'),
										'group'=>array('PatientCardAliasTwo.created_by')),
						)));
						
			$this->set('locationId',$locationId);
			
			$userDetails=$this->User->find('all',array('fields'=>array('User.full_name','Role.name'),
				'conditions'=>array('User.role_id','User.is_deleted'=>'0',
						$userConditions),'group'=>array('User.id')));
		$this->set('date',$transDate);
		$this->set('data',$userDetails);
	
		if($Reporttype=='pdf'){
			$this->set('date',$transDate);
			$this->set('data',$userDetails);
			$this->layout=false;
			$this->render('daily_collection_pdf',false);
		}
		if($Reporttype=='excel'){
			$this->layout=false;
			$this->render('daily_collection_xls',false);
		}
	} 
	
	function user_daily_collection($date,$userId){
		$this->layout = 'advance_ajax';
		$this->uses=array('User','Account','Billing','Patient','PatientCard','Person');
		
		$userName=$this->User->find('first',array('fields'=>array('User.full_name'),
				'conditions'=>array('User.id'=>$userId,'User.is_deleted'=>'0',
						'User.location_id'=>$this->Session->read('locationid'))));
		$this->set(userName,$userName);
		
		$dateTrans = str_replace(',', '/', $date);
		
		if($dateTrans){
		$getDate = $this->DateFormat->formatDate2STDForReport($dateTrans,Configure::read('date_format'));
		}
		//BOF For deposit card amount
		$this->Person->bindModel(array(
				'belongsTo'=>array(
						"PatientCard"=>array("foreignKey"=>false,'type'=>'INNER',
						'conditions'=>array('PatientCard.person_id=Person.id','DATE_FORMAT(PatientCard.create_time,"%Y-%m-%d")'=>$getDate,
						'PatientCard.type'=>'deposit','PatientCard.mode_type'=>'Cash','PatientCard.created_by'=>$userId)),
				)));
		
		$cardDepositDetails=$this->Person->find('all',array('fields'=>array('Person.id','Person.first_name','Person.last_name','Person.patient_uid',
				'SUM(PatientCard.amount) as card_total'),'group'=>array('Person.id')));
		//EOF deposit
		
		//BOF For refund card amount
		$this->Person->bindModel(array(
				'belongsTo'=>array(
						"PatientCardAlias"=>array('className'=>'PatientCard',"foreignKey"=>false,'type'=>'INNER',
						'conditions'=>array('PatientCardAlias.person_id=Person.id','DATE_FORMAT(PatientCardAlias.create_time,"%Y-%m-%d")'=>$getDate,
						'PatientCardAlias.type'=>'refund','PatientCardAlias.mode_type'=>'Cash','PatientCardAlias.created_by'=>$userId))
				)));
		
		$cardRefundDetails=$this->Person->find('all',array('fields'=>array('Person.id','Person.first_name','Person.last_name','Person.patient_uid',
				'SUM(PatientCardAlias.amount) as card_refund'),'group'=>array('Person.id')));
		//EOF For refund
		
		//BOF For payment card amount
		$this->Person->bindModel(array(
				'belongsTo'=>array(
						"PatientCardAliasTwo"=>array('className'=>'PatientCard',"foreignKey"=>false,'type'=>'INNER',
						'conditions'=>array('PatientCardAliasTwo.person_id=Person.id','DATE_FORMAT(PatientCardAliasTwo.create_time,"%Y-%m-%d")'=>$getDate,
						'PatientCardAliasTwo.type'=>'Payment','PatientCardAliasTwo.created_by'=>$userId))
				)));
		
		$cardPaymentDetails=$this->Person->find('all',array('fields'=>array('Person.id','Person.first_name','Person.last_name','Person.patient_uid',
				'SUM(PatientCardAliasTwo.amount) as card_payment'),'group'=>array('Person.id')));
 		//EOF for payment
 		
		//BOF for billing deposit, refund and discount
		$this->Patient->bindModel(array(
				'belongsTo'=>array(
						 "Billing"=>array("foreignKey"=>false,'type'=>'INNER',
						 'conditions'=>array('Billing.patient_id=Patient.id','DATE_FORMAT(Billing.date,"%Y-%m-%d")'=>$getDate,'Billing.is_deleted'=>'0',
						 		'Billing.mode_of_payment'=>'Cash','Billing.created_by'=>$userId)),
				)));

		$billingDetails=$this->Patient->find('all',array('fields'=>array('Patient.id','Patient.person_id','Patient.admission_id','Patient.lookup_name',
				'SUM(Billing.amount) as billing_total','SUM(Billing.paid_to_patient) as billing_refund','SUM(Billing.discount) as total_discount'),
				'group'=>array('Patient.id')));
 		//EOF billing
 		
		$personArray =array(); 
		foreach ($billingDetails as $billKey=> $billData){
			$personArray[$billData['Patient']['person_id']]['patient'] = $billData ;
		}
		foreach ($cardDepositDetails as $key=> $cardDepositData){ 
			$personArray[$cardDepositData['Person']['id']]['patient_card_deposit'] = $cardDepositData ; 
		}
		foreach ($cardRefundDetails as $key=> $cardRefundData){
			$personArray[$cardRefundData['Person']['id']]['patient_card_refund'] = $cardRefundData ;
		}
		foreach ($cardPaymentDetails as $key=> $cardPaymentData){
			$personArray[$cardPaymentData['Person']['id']]['patient_card_payment'] = $cardPaymentData ;
		}
		$this->set('billingDetails',$personArray);
		$this->set('date',$dateTrans);
		$this->set('userId',$userId);
	}

	function payment_collection($date,$userId,$patientId){
		$this->layout = 'advance_ajax';
		$this->uses=array('Billing','Patient','WardPatientService','ServiceBill','ConsultantBilling','LaboratoryTestOrder',
				'RadiologyTestOrder','PharmacySalesBill','OtPharmacySalesBill','PatientCard','ServiceCategory');

		$patientName=$this->Patient->find('first',array('fields'=>array('Patient.lookup_name','Patient.person_id','Patient.admission_type'),
				'conditions'=>array('Patient.id'=>$patientId)));
		$this->set('patientName',$patientName);
		
		$dateTrans = str_replace(',', '/', $date);
		
		if($dateTrans){
			$getDate = $this->DateFormat->formatDate2STDForReport($dateTrans,Configure::read('date_format'));
		}
		
		$pharmacyId = $this->ServiceCategory->getPharmacyId();
		$billingDetails=$this->Billing->find('first',array('fields'=>array('SUM(Billing.paid_to_patient) as billing_refund'),
				'conditions'=>array('Billing.patient_id'=>$patientId,'DATE_FORMAT(Billing.date,"%Y-%m-%d")'=>$getDate,
						'Billing.is_deleted'=>'0','Billing.mode_of_payment'=>'Cash','Billing.payment_category NOT'=>$pharmacyId),
				 'group'=>array('Billing.patient_id')));
		$this->set('billingData',$billingDetails);
		
		$cardDeposit=$this->PatientCard->find('first',array('fields'=>array('SUM(PatientCard.amount) as card_total'),
				'conditions'=>array('DATE_FORMAT(PatientCard.create_time,"%Y-%m-%d")'=>$getDate,'PatientCard.type'=>'deposit',
				'PatientCard.mode_type'=>'Cash','PatientCard.person_id'=>$patientName['Patient']['person_id']),
				'group'=>array('PatientCard.person_id')));
		$this->set('cardDeposit',$cardDeposit);
		
		$cardPayment=$this->PatientCard->find('first',array('fields'=>array('SUM(PatientCard.amount) as card_payment'),
				'conditions'=>array('DATE_FORMAT(PatientCard.create_time,"%Y-%m-%d")'=>$getDate,'PatientCard.type'=>array('refund','Payment'),
				'PatientCard.person_id'=>$patientName['Patient']['person_id']),
				'group'=>array('PatientCard.person_id')));
		$this->set('cardPayment',$cardPayment);
	
		$wardDataArray = $this->WardPatientService->getServiceWiseCharges($patientId,$getDate,$userId);		
		$serviceDataArray = $this->ServiceBill->getServiceWiseCharges($patientId,$getDate,$userId);
		$consultantDataArray = $this->ConsultantBilling->getServiceWiseCharges($patientId,$getDate,$userId);
		$labDataArray = $this->LaboratoryTestOrder->getServiceWiseCharges($patientId,$getDate,$userId);
		$radDataArray = $this->RadiologyTestOrder->getServiceWiseCharges($patientId,$getDate,$userId);
		$doctorDataArray = $this->WardPatientService->getMandatoryDoctorCharges($patientId,$getDate,$userId);
		$doctorDataArray[0]['TariffList']['name'] = 'Doctor Charges' ;
		$nurseDataArray = $this->WardPatientService->getMandatoryNurseCharges($patientId,$getDate,$userId);
		$nurseDataArray[0]['TariffList']['name'] = 'Nursing Charges' ;
		$pharmacyDataArray = $this->PharmacySalesBill->getPharmacyCharges($patientId,$getDate,$userId);
		$otPharmacyDataArray = $this->OtPharmacySalesBill->getOTPharmacyCharges($patientId,$getDate,$userId);
		$otPharmacyDataArray[0]['TariffList']['name'] = 'OT Pharmacy' ;

		$serviceData = array();
		$wardArray = array();
		$consultantArray = array();
		$labArray = array();
		$radArray = array();
		$doctorArray = array();
		$nurseArray = array();
		$pharmacyArray = array();
		$oTpharmacyArray = array();
		
		foreach($wardDataArray as $key => $wardData){
			$wardArray[$wardData['ServiceCategory']['name']][] = array($wardData['TariffList']['name'] => ($wardData['WardPatientService']['paid_amount']/* -$wardData['WardPatientService']['discount'] */));
		}
		foreach($serviceDataArray as $key => $val){
			$serviceData[$val['ServiceCategory']['name']][] = array($val['TariffList']['name'] => ($val['ServiceBill']['paid_amount']/* -$val['ServiceBill']['discount'] */));
		}
		foreach($consultantDataArray as $key => $consultantData){
			$consultantArray[$consultantData['ServiceCategory']['name']][] = array($consultantData['TariffList']['name'] => ($consultantData['ConsultantBilling']['paid_amount']/* -$consultantData['ConsultantBilling']['discount'] */));
		}
		foreach($labDataArray as $key => $labData){
			$labArray[$labData['ServiceCategory']['name']][] = array($labData['Laboratory']['name'] => ($labData['LaboratoryTestOrder']['paid_amount']/* -$labData['LaboratoryTestOrder']['discount'] */));
		}
		foreach($radDataArray as $key => $radData){
			$radArray[$radData['ServiceCategory']['name']][] = array($radData['Radiology']['name'] => ($radData['RadiologyTestOrder']['paid_amount']/* -$radData['RadiologyTestOrder']['discount'] */));
		}
		foreach($doctorDataArray as $key => $doctorData){
			if(!empty($doctorData['0']['TotalDoctorAmount'])){
				$doctorArray[$doctorData['TariffList']['name']][] = array($doctorData['TariffList']['name'] => ($doctorData['0']['TotalDoctorAmount']/* -$doctorData['0']['TotalDoctorDiscount'] */));
			}
		}
		foreach($nurseDataArray as $key => $nurseData){
			if(!empty($nurseData['0']['TotalNurseAmount'])){
				$nurseArray[$nurseData['TariffList']['name']][] = array($nurseData['TariffList']['name'] => ($nurseData['0']['TotalNurseAmount']/* -$nurseData['0']['TotalNurseDiscount'] */));
			}
		}
		foreach($pharmacyDataArray as $key => $pharmacyData){
			if(!empty($pharmacyData['0']['TotalAmount'])){
				$pharmacyArray[$pharmacyData['ServiceCategory']['name']][] = array($pharmacyData['ServiceCategory']['name'] => ($pharmacyData['0']['TotalAmount']/* -$pharmacyData['0']['TotalDiscount'] */));
			}
		}
		foreach($otPharmacyDataArray as $key => $oTpharmacyData){
			if(!empty($oTpharmacyData['0']['TotalAmount'])){
				$oTpharmacyArray[$oTpharmacyData['TariffList']['name']][] = array($oTpharmacyData['TariffList']['name'] => ($oTpharmacyData['0']['TotalAmount']/* -$pharmacyData['0']['TotalDiscount'] */));
			}
		}
		$data=array_merge($serviceData,$wardArray,$consultantArray,$labArray,$radArray,$doctorArray,$nurseArray,$pharmacyArray,$oTpharmacyArray);
		$this->set('data',$data);
	}
	
	function external_charges(){
		$this->layout = 'advance';
		$this->uses = array('ServiceCategory','Configuration','User','Consultant');
		if(!empty($this->request->data)){
			$dataDetails = $this->Configuration->find('all',array('fields'=>array('Configuration.*'),
					'conditions'=>array('Configuration.name'=>$this->request->data['Service']['name'].'-Commision')));
			
			//insert
				if(empty($dataDetails)){
					$dataService[0] = $this->request->data['Service'];
					$dataNew  = serialize($dataService);
					
					$serviceData = array(
							'name'=>$this->request->data['Service']['name']."-Commision",
							'value'=>$dataNew,
							'location_id'=>$this->Session->read('locationid')
					);
					$this->Configuration->save($serviceData);
					$this->Configuration->id = '';
						
					$this->redirect(array('action'=>'external_charges'));
				}else{
					
			//update
				foreach($dataDetails as $key=>$data){
					$dataArray  = unserialize($data['Configuration']['value']);
					$count = count($dataArray);
					$dataArray = ($dataArray[$count-1]);
					
			//set previous array status = 0 and To date of new from date
					//$dataArray['status'] = 0;
					//$dataArray['to'] = $this->request->data['Service']['from'];
				
					if($this->request->data['Service']['id'] == $dataArray['id']){
						$data['Configuration']['value'] = serialize(array($dataArray,$this->request->data['Service']));
						$this->Configuration->save($data);
						$this->Configuration->id = '';
						$this->redirect(array('action'=>'external_charges'));
					}
				}
			}
		}
		$consultantDetails = $this->User->find('all',array('fields'=>array('User.doctor_commision'),'conditions'=>array('User.doctor_commision NOT'=>'0')));
		$this->set('consultantDetails',$consultantDetails);
		
		$externalDetails = $this->Consultant->find('all',array('fields'=>array('Consultant.doctor_commision'),'conditions'=>array('Consultant.doctor_commision NOT'=>null)));
		$this->set('externalDetails',$externalDetails);
		
		$dataDetails = $this->Configuration->find('all',array('fields'=>array('Configuration.*'),'conditions'=>array('Configuration.name like'=>"%".'-Commision')));
		$this->set('data',$dataDetails);
	}
	
	
	function patient_card_print($id=null){
		$this->layout='ajax';
		$this->loadModel('PatientCard');
		$this->PatientCard->bindModel(array(
				'belongsTo'=>array(
						'Account'=>array('foreignKey'=>false,'conditions'=>array('Account.id=PatientCard.bank_id')),
						'UserAccount'=>array('className'=>'Account','foreignKey'=>false,'conditions'=>array('UserAccount.id=PatientCard.account_id')),
						'Billing'=>array('foreignKey'=>false,'conditions'=>array('Billing.id=PatientCard.billing_id')),
						)));
		
		$printDetail=$this->PatientCard->find('first',array('fields'=>array('PatientCard.*','Account.name,Account.id',
				'UserAccount.id, UserAccount.name','Billing.id '/*,Billing.Bill_no'*/),'conditions'=>array('PatientCard.id'=>$id)));
		$this->set('printDetail',$printDetail);
	}
	
	function corporate_receivable(){
		
		$this->layout = 'advance';
		
		//change receivable as per approved amount
		$this->uses = array('CorporateSuperBill');
		//BOF date range by pankaj
		$condition= array();
		$this->request->data['Voucher'] = $this->params->query ;
		if(!empty($this->request->data)){
			if($this->request->data['Voucher']['from']){
				$fromDate = $this->DateFormat->formatDate2STDForReport($this->request->data['Voucher']['from'],Configure::read('date_format'));
			}
			if($this->request->data['Voucher']['to']){
				$toDate = $this->DateFormat->formatDate2STDForReport($this->request->data['Voucher']['to'],Configure::read('date_format'));
			}
			if(!empty($fromDate) && !empty($toDate)){
				$condition = array('CorporateSuperBill.date between ? and ?'=>array($fromDate,$toDate));
			}
		}	
		
		$this->CorporateSuperBill->bindModel(array('belongsTo'=>array(
				'TariffStandard'=>array('type'=>'INNER',
										'conditions'=>array('CorporateSuperBill.tariff_standard_id=TariffStandard.id')) ,
				'CorporateSuperBillList'=>array('foreignKey'=>false ,
											'conditions'=>array('CorporateSuperBill.id=CorporateSuperBillList.corporate_super_bill_id')
				))));
		
		$data  = $this->CorporateSuperBill->find('all',array('conditions'=>array_merge(array('CorporateSuperBill.bill_settled_date IS NULL','CorporateSuperBill.is_deleted=0'),$condition),
				'fields'=>array('SUM(CorporateSuperBillList.tds) as tds','SUM(CorporateSuperBill.approved_amount) as total_amount','SUM(CorporateSuperBill.received_amount) as amount_paid','TariffStandard.name','TariffStandard.id'),
				'group'=>array('CorporateSuperBill.tariff_standard_id')));
		
		$this->set(array('data'=>$data));
		$this->set(compact('from','to'));
		//EOF new logic to generate corporate receivable report 	
	}
	
	function corporate_patient_details($id = null){
		$this->layout = 'advance_ajax';
		if(!$id) $id = $this->params->query['tariff_standard_id'];
		//BOF super bill list as per selection by pankaj 
		$this->uses=array('CorporateSuperBill','TariffStandard');
		$condition= array();
		$this->request->data['Voucher'] = $this->params->query ;
		if(!empty($this->request->data)){
			if($this->request->data['Voucher']['from']){
				$fromDate = $this->DateFormat->formatDate2STDForReport($this->request->data['Voucher']['from'],Configure::read('date_format'));
			}
			if($this->request->data['Voucher']['to']){
				$toDate = $this->DateFormat->formatDate2STDForReport($this->request->data['Voucher']['to'],Configure::read('date_format'));
			}
			if(!empty($fromDate) && !empty($toDate)){
				$condition = array('CorporateSuperBill.date between ? and ?'=>array($fromDate,$toDate));
			}
		}
		 
		$this->CorporateSuperBill->bindModel(array('belongsTo'=>array('Patient'=>array('type'=>'INNER','foreignKey'=>false,
				'conditions'=>array('CorporateSuperBill.person_id=Patient.person_id')))));
		$result  =  $this->CorporateSuperBill->find('all',array('conditions'=>array_merge(
				array('CorporateSuperBill.tariff_standard_id'=>$id,'CorporateSuperBill.bill_settled_date IS NULL'),$condition),
				'fields'=>array('Patient.lookup_name','CorporateSuperBill.approved_amount',
				'CorporateSuperBill.received_amount' ),'group'=>array('CorporateSuperBill.id'),'order'=>Array('Patient.lookup_name asc')));
		$this->set(array('data'=>$result));
		$corporateName=$this->TariffStandard->find('first',array('fields'=>array('TariffStandard.name','TariffStandard.id'),'conditions'=>array('TariffStandard.id'=>$id)));
		$this->set('corporateName',$corporateName);
 		
		//EOF super bill list by pankaj
		
	}
	
	/*******************************************************************************************************************/
	
	public function updateCorporateAmount(){
        $this->layout=ajax;
        $this->autorender=false;
		$this->uses = array('Patient','FinalBilling','Billing') ;

		if($this->request->data)
		{
			$date = $this->DateFormat->formatDate2STDForReport($this->request->data['date'],Configure::read('date_format'));
			$pendingAmount = $this->request->data['totalAmount'] - $this->request->data['amountPaid'] - $this->request->data['remainingAmount'] - $this->request->data['discountAmount'];
			$amountPaid = $this->request->data['remainingAmount'] + $this->request->data['amountPaid'];
			$discount = $this->request->data['discountAmount'] + $this->request->data['previousDiscount'];
			$data = array('id'=>$this->request->data['finalBillingId'],'amount_paid'=>$amountPaid,'amount_pending'=>$pendingAmount,'discount'=>$discount,'modified_by'=>$this->Session->read('userid'),'modify_time'=>date("Y-m-d H:i:s"));
			$this->FinalBilling->save($data);
		
			$billingData = array();
			$billingData['date']=$date;
			$billingData['patient_id']=$this->request->data['patientId'];
			$billingData['payment_category']='Finalbill';
			$billingData['location_id']=$this->Session->read('locationid');
			$billingData['created_by']=$this->Session->read('userid');
			$billingData['create_time']=date("Y-m-d H:i:s");
			$billingData['mode_of_payment']="Cash";
			$billingData['total_amount']=$this->request->data['totalAmount'];
			$billingData['amount']=$this->request->data['remainingAmount'];
			$billingData['amount_paid']=$this->request->data['remainingAmount'];
			$billingData['amount_pending']=$pendingAmount;
			$billingData['discount']=$this->request->data['discountAmount'];
			$billingData['remark']=$this->request->data['description'];
			if($this->Billing->save($billingData)){
				echo true;
			}else{
				echo false;
			}
			$this->Billing->id = '';
		}
		exit;
	}
	function opdSettlement(){
		$this->layout = 'advance';
		$this->uses=array('TariffStandard','Billing','Patient','ServiceBill','LaboratoryTestOrder','RadiologyTestOrder');
		if(!empty($this->request->data)){
			$date = $this->DateFormat->formatDate2STDForReport($this->request->data['Patient']['date'],Configure::read('date_format'));
		}else{
			$date = date('Y-m-d');
		}
		$allOpdPatientId = $this->Patient->getOpdPatientId($date);
		$serviceBillArray = $this->ServiceBill->getPatientWiseCharges($allOpdPatientId);
		$laboratoryTestOrderArray = $this->LaboratoryTestOrder->getPatientWiseCharges($allOpdPatientId);
		$radiologyTestOrderArray = $this->RadiologyTestOrder->getPatientWiseCharges($allOpdPatientId);
		
		foreach ($serviceBillArray as $key=> $serData){
			$serviceData[$serData['ServiceBill']['patient_id']] = $serData[0]['totalAmount'];
		}
		foreach ($laboratoryTestOrderArray as $key=> $labData){
			$laboratoryData[$labData['LaboratoryTestOrder']['patient_id']] = $labData[0]['totalAmount'];
		}
		foreach ($radiologyTestOrderArray as $key=> $radData){
			$radiologyData[$radData['RadiologyTestOrder']['patient_id']] = $radData[0]['totalAmount'];
		}

		foreach ($allOpdPatientId as $key=> $value){
			$allData[$value] = $serviceData[$value]+$laboratoryData[$value]+$radiologyData[$value];
		}
		$this->set('allData',$allData);
	
		
		$this->Patient->bindModel(array(
				"hasMany"=>array(
						"Billing"=>array('fields'=>array('amount','discount','paid_to_patient'),
								"foreignKey"=>'patient_id',
								'group'=>array('Billing.patient_id')))));
		
		$userDetails=$this->Patient->find('all',array('fields'=>array('Patient.id','Patient.lookup_name','Patient.admission_id'),
				'conditions'=>array('Patient.location_id'=>$this->Session->read('locationid'),'Patient.admission_type'=>'OPD','DATE_FORMAT(create_time, "%Y-%m-%d")'=>$date),'group'=>array('Patient.id')));
		$this->set('data',$userDetails);
	}

	public function cashier_open(){
		$this->layout = 'advance_ajax';
	}
	
	//for accounting index ledger search by amit jain
	public function ledger_search($field=null){
		$this->loadModel('Account');
		$searchKey = $this->params->query['term'];
		$filedOrder = array('id','name');
		$conditions[$field." like"] = $searchKey."%";
		$conditions["Account.location_id"] =$this->Session->read('locationid');
		$accountData = $this->Account->find('list', array('fields'=> $filedOrder,'conditions'=>array($conditions,'Account.is_deleted' =>'0'),'limit'=>15));
		$output ='';
		foreach ($accountData as $key=>$value) {
			$returnArray[] = array('id'=>$key,'value'=>$value);
		}
		echo json_encode($returnArray);
		exit;//dont remove this
	}
	
	public function cashier_approve(){
		$this->layout = 'advance';
		$this->uses = array('Billing','CashierBatch');
		$webSite = $this->Session->read('website.instance');
		$this->set('userName',$this->Billing->getUserList(Configure::read('cashier_role')));
	
		if(!empty($this->request->data)){
			foreach($this->request->data['cashier'] as $key=> $data){
				if(isset($data['is_radio'])){
					$cashierName = $data['name'];
					$updateCashierId = $data['id'];
				}
			}
			$cashierId = $this->CashierBatch->find('first', array('fields'=> array('CashierBatch.id'),
					'conditions'=>array('CashierBatch.type'=>'Cashier','CashierBatch.cashier_id NOT'=>'0'),
					'order'=>array('id' =>'DESC')));
			$this->CashierBatch->updateAll(array('cashier_id'=>$updateCashierId),
					array('CashierBatch.id'=>$cashierId['CashierBatch']['id']));
			$this->Session->setFlash(__("$cashierName is Now Able to Collect Cash !"),'default',array('class'=>'message'));
			$this->redirect($this->referer()) ;
		}
	}
	
	function getSubGroups($groupId=null){
		$this->layout = 'ajax';
		$this->autoRender =false ;
		if(groupId != ''){
			$this->uses = array('AccountingGroup');
			$subGroups = $this->AccountingGroup->find('list', array('fields'=> array('id', 'name'),
					'conditions'=>array('parent_id'=>$groupId,'location_id' => $this->Session->read('locationid'))));
			echo json_encode($subGroups);
			exit;
		}else{
			exit ;
		}
	}
	
	function daily_card_collection($Reporttype=null){
		$this->layout = 'advance';
		$this->uses=array('User','PatientCard','Role','Account');
		if(!empty($this->params->query)){
			$this->request->data['Voucher']=$this->params->query;
		}
		if(!empty($this->request->data['Voucher']['date'])){
			$date = $this->DateFormat->formatDate2STDForReport($this->request->data['Voucher']['date'],Configure::read('date_format'));
			$transDate = $this->request->data['Voucher']['date'];
		}else{
			$date = date('Y-m-d');
			$transDate = date('d/m/Y');
		}
		
		$roleConditions['Role.code_name'] = array(Configure::read('frontOffice_role'),Configure::read('cashier_role'),Configure::read('pharmacy_role'),
				Configure::read('adminLabel'),Configure::read('otpharmacycode'));
		
		if($this->Session->read('role') != 'Admin'){
			$userConditions['User.id'] = $this->Session->read('userid');
			$userConditions['User.location_id'] = $this->Session->read('locationid');
		}

		$this->User->unBindModel(array(
				'belongsTo' => array('City','State','Country','Role','Initial')),false);
			
		$this->User->bindModel(array(
				'belongsTo'=>array(
						"Role"=>array("foreignKey"=>false,'type'=>'INNER','conditions'=>array($roleConditions,'User.role_id=Role.id'),'order'=>array('Role.name'=>'asc'))),
				"hasMany"=>array(
						"PatientCard"=>array('fields'=>array('amount','type'),"foreignKey"=>'created_by',
								'conditions'=>array('DATE_FORMAT(create_time,"%Y-%m-%d")'=>$date)),
				)));
			
		$userDetails=$this->User->find('all',array('fields'=>array('User.full_name','Role.name'),
				'conditions'=>array('User.role_id','User.is_deleted'=>'0',
						$userConditions),'group'=>array('User.id')));
		$this->set('date',$transDate);
		$this->set('data',$userDetails);
		if($Reporttype=='pdf'){
			$this->set('date',$transDate);
			$this->set('data',$userDetails);
			$this->layout=false;
			$this->render('daily_card_collection_pdf',false);
		}
		if($Reporttype=='excel'){
			$this->layout=false;
			$this->render('daily_card_collection_xls',false);
		}
	}
	
	function user_daily_card_collection($date,$userId){
		$this->layout = 'advance_ajax';
		$this->uses=array('User','PatientCard','Account','Role','Billing','Person');

		$userName=$this->User->find('first',array('fields'=>array('User.full_name'),
				'conditions'=>array('User.id'=>$userId,'User.is_deleted'=>'0',
						'User.location_id'=>$this->Session->read('locationid'))));
		$this->set(userName,$userName);
	
		$dateTrans = str_replace(',', '/', $date);
	
		if($dateTrans){
			$getDate = $this->DateFormat->formatDate2STDForReport($dateTrans,Configure::read('date_format'));
		}
	
		 $this->Person->bindModel(array(
				"hasMany"=>array(
						"PatientCard"=>array('fields'=>array('amount','type'),
								'conditions'=>array('DATE_FORMAT(create_time,"%Y-%m-%d")'=>$getDate,'PatientCard.created_by'=>$userId)),
		)));
	
		$userDetails=$this->Person->find('all',array('fields'=>array('Person.full_name','Person.id')));
		$this->set('data',$userDetails);
		$this->set('date',$dateTrans);
		$this->set('userId',$userId);
	}
	
	/**
	 * List of patients to add amount in  patient card 
	 * Pooja Gupta
	 */
	public function patient_card_list(){
		$this->layout='advance';
		$this->uses=array('Account','Patient');
		$this->Patient->bindModel(array(
				'belongsTo'=>array('Account'=>array('foreignKey'=>false,
						'conditions'=>array('Patient.person_id=Account.system_user_id','Account.user_type'=>'Patient')),
						'TariffStandard'=>array('foreignKey'=>false,'conditions'=>array('Patient.tariff_standard_id=TariffStandard.id'))
				)));
		if(!empty($this->params->query)){
			$condition=array();
			if($this->params->query['name']){
				$pName=explode('-',$this->params->query['name']);
				$condition['Patient.lookup_name LIKE']="%".$pName['0']."%";
			}
		}
		if(empty($condition)){
			$condition['Patient.form_received_on like']=date('Y-m-d').'%';
		}
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'fields'=>array('Patient.id','Patient.person_id','Patient.lookup_name',
						'Patient.patient_id','Account.id','Account.card_balance',
						'TariffStandard.id','TariffStandard.name'),
				'conditions'=>array('Patient.is_deleted'=>'0',/*'Patient.is_discharge'=>'0',*/
						'Patient.location_id'=>$this->Session->read('locationid'),$condition),
				'order' => array(
						'Patient.id' => 'DESC',
				),
				/*'group'=>array('Patient.person_id')*/
		);		
		$patientData=$this->paginate('Patient');
		$this->set('patientData',$patientData);
	}
	
	function daily_collection_details($Reporttype=null){
		$this->layout = 'advance';
		$this->uses=array('User','Role','Billing','Account','PatientCard');
		if(!empty($this->params->query)){
			$this->request->data['Voucher']=$this->params->query;
		}
		if(!empty($this->request->data['Voucher']['date'])){
			$date = $this->DateFormat->formatDate2STDForReport($this->request->data['Voucher']['date'],Configure::read('date_format'));
			$transDate = $this->request->data['Voucher']['date'];
		}else{
			$date = date('Y-m-d');
			$transDate = date('d/m/Y');
		}
		
		$roleConditions['Role.code_name'] = array(Configure::read('frontOffice_role'),Configure::read('cashier_role'),Configure::read('pharmacy_role'),Configure::read('adminLabel'),Configure::read('otpharmacycode'));
		
		if($this->Session->read('role') != 'Admin'){
			$userConditions['User.id'] = $this->Session->read('userid');
			$userConditions['User.location_id'] = $this->Session->read('locationid');
		}
		
		$this->User->unBindModel(array(
				'belongsTo' => array('City','State','Country','Role','Initial')),false);
			
		$this->User->bindModel(array(
				'belongsTo'=>array(
						"Role"=>array("foreignKey"=>false,'type'=>'INNER','conditions'=>array($roleConditions,'User.role_id=Role.id'),'order'=>array('Role.name'=>'asc'))),
				"hasMany"=>array(
						/* "Billing"=>array('fields'=>array('SUM(amount) as total','SUM(paid_to_patient) as return_total'),"foreignKey"=>'created_by',
								'conditions'=>array('DATE_FORMAT(Billing.date,"%Y-%m-%d")'=>$date,'Billing.is_deleted'=>'0'),
								'group'=>array('Billing.created_by','Billing.mode_of_payment having Billing.mode_of_payment IN ("Cash","Cheque")')), */
						 "Billing"=>array('fields'=>array('SUM(amount) as total','SUM(paid_to_patient) as return_total'),"foreignKey"=>'created_by',
								'conditions'=>array('DATE_FORMAT(Billing.date,"%Y-%m-%d")'=>$date,'Billing.is_deleted'=>'0','Billing.mode_of_payment'=>'Cash'),
								'group'=>array('Billing.created_by')),
						"PatientCard"=>array('fields'=>array('SUM(amount) as card_total'),"foreignKey"=>'created_by',
								'conditions'=>array('DATE_FORMAT(PatientCard.create_time,"%Y-%m-%d")'=>$date,'PatientCard.type'=>'deposit','PatientCard.mode_type'=>'Cash'),'group'=>array('PatientCard.created_by')),
						"PatientCardAlias"=>array('className'=>'PatientCard','fields'=>array('SUM(amount) as card_refund'),"foreignKey"=>'created_by',
								'conditions'=>array('DATE_FORMAT(PatientCardAlias.create_time,"%Y-%m-%d")'=>$date ,'PatientCardAlias.type'=>'refund'),'group'=>array('PatientCardAlias.created_by')),
						"PatientCardAliasTwo"=>array('className'=>'PatientCard','fields'=>array('SUM(amount) as card_payment'),"foreignKey"=>'created_by',
								'conditions'=>array('DATE_FORMAT(PatientCardAliasTwo.create_time,"%Y-%m-%d")'=>$date ,'PatientCardAliasTwo.type'=>'Payment'),'group'=>array('PatientCardAliasTwo.created_by')),
						"PatientCardAliasThree"=>array('className'=>'PatientCard','fields'=>array('SUM(amount) as card_amount_cheque'),"foreignKey"=>'created_by',
								'conditions'=>array('DATE_FORMAT(PatientCardAliasThree.create_time,"%Y-%m-%d")'=>$date ,'PatientCardAliasThree.mode_type'=>'Cheque'),'group'=>array('PatientCardAliasThree.created_by'))
				)));
		$userDetails=$this->User->find('all',array('fields'=>array('User.full_name','Role.name'),
				'conditions'=>array('User.role_id','User.is_deleted'=>'0',
						$userConditions),'group'=>array('User.id')));
		
		$this->set('date',$transDate);
		$this->set('data',$userDetails);
		
		//for phramy users
		/* $pharmacyConditions['Role.code_name'] = Configure::read('pharmacy_role');
		
		$this->User->unBindModel(array(
				'belongsTo' => array('City','State','Country','Role','Initial')),false);
		
		$this->User->bindModel(array(
				'belongsTo'=>array(
						"Role"=>array("foreignKey"=>false,'type'=>'INNER','conditions'=>array($pharmacyConditions,'User.role_id=Role.id'),'order'=>array('Role.name'=>'asc'))),
				"hasMany"=>array(
						"PharmacySalesBill"=>array('fields'=>array('SUM(PharmacySalesBill.paid_amnt) as pharmacy_total'),
								"foreignKey"=>'created_by','conditions'=>array('DATE_FORMAT(PharmacySalesBill.create_time,"%Y-%m-%d")'=>$date,'PharmacySalesBill.is_deleted'=>'0'),
								'group'=>array('PharmacySalesBill.created_by')),
				)));
		$pharamacyDetails=$this->User->find('all',array('fields'=>array('User.full_name','Role.name'),
				'conditions'=>array('User.role_id','User.is_deleted'=>'0',$userConditions),'group'=>array('User.id')));
		
		$data=array_merge($userDetails,$pharamacyDetails);
		
		$this->set('data',$data); */
		if($Reporttype=='pdf'){
			$this->set('date',$transDate);
			$this->set('data',$userDetails);
			$this->layout=false;
			$this->render('daily_collection_details_pdf',false);
		}
		if($Reporttype=='excel'){
			$this->layout=false;
			$this->render('daily_collection_details_xls',false);
		}
	}
	//For print Daily collection details by amit jain
	function daily_collection_details_print(){
		$this->uses=array('User','Role','Billing','Account','PatientCard');
		$this->request->data['Voucher'] = $this->params->query ;
		$this->daily_collection_details();
		$this->layout = false;
	}
	
	//For print Daily collection by amit jain
	function daily_collection_print(){
		$this->uses=array('User','AccountReceipt','VoucherPayment','VoucherEntry','Account','Role','Billing');
		$this->request->data['Voucher'] = $this->params->query ;
		$this->daily_collection();
		$this->layout = false;
	}
	
	//For print Daily card collection by amit jain
	function daily_card_collection_print(){
		$this->uses=array('User','PatientCard','Role','Account');
		$this->request->data['Voucher'] = $this->params->query ;
		$this->daily_card_collection();
		$this->layout = false;
	}
	
	//Service wise collection by amit jain
	function service_wise_collection(){
		$this->layout = 'advance';
		$this->uses=array('Location','ServiceSubCategory','ServiceBill','ConsultantBilling','RadiologyTestOrder',
				'LaboratoryTestOrder','WardPatientService','PharmacySalesBill','OtPharmacySalesBill',
				'OptAppointment','PatientCard','InventoryPharmacySalesReturn',
				'OtPharmacySalesReturn');
		
		$this->set('locationList',$this->Location->getLocationIdByHospital());
		
		$startMonth = Configure::read('startFinancialYear');
		if((int) date('m') > 3){
			$date = date("Y$startMonth");
		}else{
			$date = (date("Y") - 1).date("$startMonth");
		}
		$conditions=array();
		
		if(empty($this->params->query)){
			$conditions=array();$pharCond=array();
				$conditions['TariffList.service_location NOT'] =NULL;
				$pharCond['PharmacyItem.location_id NOT']=NULL;
				$otpharCond['OtPharmacyItem.location_id NOT']=NULL;
				$fromDate=date('Y-m-d').' 00:00:00';
				$toDate=date('Y-m-d').' 23:59:59';
				$location='All';
		}else{
			$conditions=array();
			if($this->params->query['type'] == "All"){
				$conditions['TariffList.service_location NOT'] =NULL;
				$pharCond['PharmacyItem.location_id NOT']=NULL;
				$otpharCond['OtPharmacyItem.location_id NOT']=NULL;
				$location='All';
			}else{
				$conditions=array();
				$conditions['OR']= array('TariffList.service_location'=>$this->params->query['type'],array('AND'=>array('TariffList.service_location'=>'All',
		 							'Patient.location_id'=>$this->params->query['type']))) ; //1,24
				
				
				$pharCond['PharmacyItem.location_id ']=$this->params->query['type'];
				$otpharCond['OtPharmacyItem.location_id ']=$this->params->query['type'];				
				//$conditions['Patient.location_id']=$this->params->query['type'];				
				$location=$this->params->query['type'];
			}			
			if(!empty($this->params->query['from_date'])){
				$fromDate = $this->DateFormat->formatDate2STDForReport($this->params->query['from_date'],Configure::read('date_format'))." 00:00:00";				
			}else{
				$fromDate=date('Y-m-d').' 00:00:00';
			}
			if(!empty($this->params->query['to_date'])){
				$toDate = $this->DateFormat->formatDate2STDForReport($this->params->query['to_date'],Configure::read('date_format'))." 23:59:59";
			}else{
				$toDate=date('Y-m-d').' 23:59:59';
			}
		}
		
		$this->set('locationid',$location);
		
		 $this->ServiceBill->bindModel(array(
				'belongsTo'=>array(
						'Patient'=>array("foreignKey"=>false,'conditions'=>array('Patient.id = ServiceBill.patient_id')),
						"TariffList"=>array("foreignKey"=>false,'conditions'=>array('TariffList.id = ServiceBill.tariff_list_id')),
						"ServiceCategory"=>array("foreignKey"=>false,'conditions'=>array('ServiceCategory.id = TariffList.service_category_id')),
						"ServiceSubCategory"=>array("foreignKey"=>false,'conditions'=>array('ServiceSubCategory.id = TariffList.service_sub_category_id')))
		 			)
		 		);
		 
		 
		 $serviceBillDetails = $this->ServiceBill->find('all',array('fields'=>array('ServiceSubCategory.name','ServiceSubCategory.id','ServiceCategory.alias',
		 			'SUM(ServiceBill.paid_amount) as total_amount',
		 			'SUM(ServiceBill.discount) as total_discount'),'conditions'=>array('ServiceBill.modified_time between ? and ?'=>array($fromDate,$toDate) ,
		 					'ServiceBill.is_deleted'=>'0',
		 					$conditions,
		 					'OR'=>array(
		 							array('OR'=>array(array('ServiceBill.paid_amount NOT'=>'0'),array('ServiceBill.paid_amount NOT'=>NULL))),
		 							array('OR'=>array(array('ServiceBill.discount NOT'=>'0'),array('ServiceBill.discount NOT'=>NULL)))
		 						  )
		 					),
		 			'group'=>array('ServiceSubCategory.id')));
		
		
		$this->ConsultantBilling->bindModel(array(
				'belongsTo'=>array(
						'Patient'=>array("foreignKey"=>false,'conditions'=>array('Patient.id = ConsultantBilling.patient_id')),
						"TariffList"=>array("foreignKey"=>false,'conditions'=>array('TariffList.id = ConsultantBilling.consultant_service_id')),
						"ServiceCategory"=>array("foreignKey"=>false,'conditions'=>array('ServiceCategory.id = TariffList.service_category_id')),
						"ServiceSubCategory"=>array("foreignKey"=>false,'conditions'=>array('ServiceSubCategory.id = TariffList.service_sub_category_id'))
						)
			));
		
		$consultantDetails=$this->ConsultantBilling->find('all',array('fields'=>array('ServiceSubCategory.name','ServiceSubCategory.id','ServiceCategory.alias',
				'SUM(ConsultantBilling.paid_amount) as total_amount','SUM(ConsultantBilling.discount) as total_discount'),
				'conditions'=>array('ConsultantBilling.modify_time between ? and ?'=>array($fromDate,$toDate),
				$conditions,
				'OR'=>array(
						array('OR'=>array(array('ConsultantBilling.paid_amount NOT'=>'0'),array('ConsultantBilling.paid_amount NOT'=>NULL ))),
						array('OR'=>array(array('ConsultantBilling.discount NOT'=>'0'),array('ConsultantBilling.discount NOT'=>NULL)))
						)
				),'group'=>array('ServiceSubCategory.id')));
		
		$this->RadiologyTestOrder->bindModel(array(
				'belongsTo'=>array(
						'Patient'=>array("foreignKey"=>false,'conditions'=>array('Patient.id = RadiologyTestOrder.patient_id')),
						"Radiology"=>array("foreignKey"=>false,'conditions'=>array('Radiology.id = radiology_id')),
						"TariffList"=>array("foreignKey"=>false,'conditions'=>array('TariffList.id = Radiology.tariff_list_id')),
						"ServiceCategory"=>array("foreignKey"=>false,'conditions'=>array('ServiceCategory.id = TariffList.service_category_id')),
						"ServiceSubCategory"=>array("foreignKey"=>false,'conditions'=>array('ServiceSubCategory.id = TariffList.service_sub_category_id')))
		));
		
		$radiologyDetails=$this->RadiologyTestOrder->find('all',array('fields'=>array('ServiceSubCategory.name','ServiceSubCategory.id','ServiceCategory.alias',
				'SUM(RadiologyTestOrder.paid_amount) as total_amount','SUM(RadiologyTestOrder.discount) as total_discount'),
				'conditions'=>array('RadiologyTestOrder.modified_bill_date between ? and ?'=>array($fromDate,$toDate),
				$conditions,
				'OR'=>array(
						array('OR'=>array(array('RadiologyTestOrder.paid_amount NOT'=>'0'),array('RadiologyTestOrder.paid_amount NOT'=>NULL ))),
						array('OR'=>array(array('RadiologyTestOrder.discount NOT'=>'0'),array('RadiologyTestOrder.discount NOT'=>NULL))),
						)
				),'group'=>array('ServiceSubCategory.id')));
		
		$this->LaboratoryTestOrder->bindModel(array(
				'belongsTo'=>array(
						'Patient'=>array("foreignKey"=>false,'conditions'=>array('Patient.id = LaboratoryTestOrder.patient_id')),
						"Laboratory"=>array("foreignKey"=>false,'conditions'=>array('Laboratory.id = LaboratoryTestOrder.laboratory_id')),
						"TariffList"=>array("foreignKey"=>false,'conditions'=>array('TariffList.id = Laboratory.tariff_list_id')),
						"ServiceCategory"=>array("foreignKey"=>false,'conditions'=>array('ServiceCategory.id = TariffList.service_category_id')),
						"ServiceSubCategory"=>array("foreignKey"=>false,'conditions'=>array('ServiceSubCategory.id = TariffList.service_sub_category_id')))
		));
		$laboratoryDetails=$this->LaboratoryTestOrder->find('all',array('fields'=>array('ServiceSubCategory.name','ServiceSubCategory.id','ServiceCategory.alias',
				'SUM(LaboratoryTestOrder.paid_amount) as total_amount','SUM(LaboratoryTestOrder.discount) as total_discount'),
				'conditions'=>array('LaboratoryTestOrder.modified_bill_date between ? and ?'=>array($fromDate,$toDate),
				'LaboratoryTestOrder.is_deleted'=>'0',$conditions,
						'OR'=>array(
								array('OR'=>array(array('LaboratoryTestOrder.paid_amount NOT'=>'0'),array('LaboratoryTestOrder.paid_amount NOT'=>NULL) )),
								array('OR'=>array(array('LaboratoryTestOrder.discount NOT'=>'0'),array('LaboratoryTestOrder.discount NOT'=>NULL)))
							)
						)
						,'group'=>array('ServiceCategory.id')));
		
		$this->WardPatientService->bindModel(array(
				'belongsTo'=>array(
						'Patient'=>array("foreignKey"=>false,'conditions'=>array('Patient.id = WardPatientService.patient_id')),
						"TariffList"=>array("foreignKey"=>false,'conditions'=>array('TariffList.id = WardPatientService.tariff_list_id')),
						"ServiceCategory"=>array("foreignKey"=>false,'conditions'=>array('ServiceCategory.id = TariffList.service_category_id')),
						"ServiceSubCategory"=>array("foreignKey"=>false,'conditions'=>array('ServiceSubCategory.id = TariffList.service_sub_category_id')))
		));
		$wardPatientDetails=$this->WardPatientService->find('all',array('fields'=>array('ServiceSubCategory.name','ServiceSubCategory.id','ServiceCategory.alias',
				'SUM(WardPatientService.paid_amount) as total_amount','SUM(WardPatientService.discount) as total_discount'),
				'conditions'=>array('WardPatientService.modified_time between ? and ?'=>array($fromDate,$toDate),
					'WardPatientService.is_deleted'=>'0',$conditions,
					'OR'=>array(
								array('OR'=>array(array('WardPatientService.paid_amount NOT'=>'0'),array('WardPatientService.paid_amount NOT'=>NULL))),
								array('OR'=>array(array('WardPatientService.discount NOT'=>'0'),array('WardPatientService.discount NOT'=>NULL))),
							)
				),
				'group'=>array('ServiceSubCategory.id')));
		
		$this->OptAppointment->unbindModel(array(
				'belongsTo' => array('Initial','Patient','Location','Opt','OptTable','Surgery','SurgerySubcategory','Doctor','DoctorProfile'
							)
				));
		
		$this->OptAppointment->bindModel(array(
				'belongsTo'=>array(
						'Patient'=>array("foreignKey"=>false,'conditions'=>array('Patient.id = OptAppointment.patient_id')),
						"TariffList"=>array("foreignKey"=>false,'conditions'=>array('TariffList.id = OptAppointment.tariff_list_id')),
						"ServiceCategory"=>array("foreignKey"=>false,'conditions'=>array('ServiceCategory.id = TariffList.service_category_id')),
						"ServiceSubCategory"=>array("foreignKey"=>false,'conditions'=>array('ServiceSubCategory.id = TariffList.service_sub_category_id')))
		));
		$optAppointmentDetails=$this->OptAppointment->find('all',array('fields'=>array('ServiceSubCategory.name','ServiceSubCategory.id','ServiceCategory.alias',
				'SUM(OptAppointment.paid_amount) as total_amount','SUM(OptAppointment.discount) as total_discount'),
				'conditions'=>array('OptAppointment.modify_time between ? and ?'=>array($fromDate,$toDate),
				'OptAppointment.is_deleted'=>'0',$conditions,
				'OR'=>array(
						array('OR'=>array(array('OptAppointment.paid_amount NOT'=>'0'),array('OptAppointment.paid_amount NOT'=>NULL))),
						array('OR'=>array(array('OptAppointment.discount NOT'=>'0'),array('OptAppointment.discount NOT'=>NULL)))
						)
				),'group'=>array('ServiceSubCategory.id')));
		
		$this->PharmacySalesBill->unBindModel(array('hasMany'=>array('PharmacySalesBillDetail'),
				'belongsTo'=>array('Patient','Doctor','Initial')
				));
		 
		$this->PharmacySalesBill->bindModel(array('belongsTo'=>Array(
				'PharmacySalesBillDetail'=>array('type'=>'inner','foreignKey'=>false,'conditions'=>Array('PharmacySalesBill.id=PharmacySalesBillDetail.pharmacy_sales_bill_id')),
				'PharmacyItem'=>Array('type'=>'inner','foreignKey'=>false,'conditions'=>Array('PharmacySalesBillDetail.item_id=PharmacyItem.id'))
				)));		
		 
		$pharmacyDetail=$this->PharmacySalesBill->find('all',array('fields'=>Array('sum(PharmacySalesBillDetail.qty * PharmacySalesBillDetail.mrp) AS total_amount', 
				'sum( PharmacySalesBillDetail.discount) as total_discount'), 
				'conditions'=>Array("PharmacySalesBill.paid_amnt != ''",$pharCond,'PharmacySalesBill.is_deleted'=>'0',
						'PharmacySalesBill.modified_time between ? and ?'=>array($fromDate, $toDate))));
 		
		$this->InventoryPharmacySalesReturn->bindModel(array('belongsTo'=>Array(
				'InventoryPharmacySalesReturnsDetail'=>array('type'=>'inner','foreignKey'=>false,'conditions'=>Array('InventoryPharmacySalesReturn.id=InventoryPharmacySalesReturnsDetail.inventory_pharmacy_sales_return_id')),
				'PharmacyItem'=>Array('type'=>'inner','foreignKey'=>false,'conditions'=>Array('InventoryPharmacySalesReturnsDetail.item_id=PharmacyItem.id'))
		)));
	
		$pharmacyReturnDetail=$this->InventoryPharmacySalesReturn->find('all',array('fields'=>Array('sum(InventoryPharmacySalesReturnsDetail.qty * InventoryPharmacySalesReturnsDetail.mrp) AS total_amount',
				'sum( InventoryPharmacySalesReturn.discount) as total_discount'),
				'conditions'=>Array('InventoryPharmacySalesReturn.billing_id NOT'=>NULL,$pharCond,'InventoryPharmacySalesReturn.is_deleted'=>'0',
						'InventoryPharmacySalesReturn.modified_time between ? and ?'=>array($fromDate, $toDate))));
		
		$pharReturn=round($pharmacyReturnDetail['0']['0']['total_amount'])-round($pharmacyReturnDetail['0']['0']['total_discount']);
		
		$pharmacyDetails['Pharmacy'][0]['total_amount']=$pharmacyDetail['0']['0']['total_amount']-$pharmacyDetail['0']['0']['total_discount']-$pharReturn;
		
		$pharmacyDetails['Pharmacy'][0]['total_discount']=$pharmacyDetail['0']['0']['total_discount']-round($pharmacyReturnDetail['0']['0']['total_discount']);
		
		
		$this->OtPharmacySalesBill->bindModel(array('belongsTo'=>Array(
				'OtPharmacySalesBillDetail'=>array('type'=>'inner','foreignKey'=>false,'conditions'=>Array('OtPharmacySalesBill.id=OtPharmacySalesBillDetail.ot_pharmacy_sales_bill_id')),
				'OtPharmacyItem'=>Array('type'=>'inner','foreignKey'=>false,'conditions'=>Array(
						'OtPharmacySalesBillDetail.item_id=OtPharmacyItem.id'))
		)));
			
		$otPharmacyDetail=$this->OtPharmacySalesBill->find('all',array('fields'=>Array('sum(OtPharmacySalesBillDetail.qty * OtPharmacySalesBillDetail.mrp) AS total_amount',
				'sum( OtPharmacySalesBillDetail.discount) as total_discount'),
				'conditions'=>Array("OtPharmacySalesBill.paid_amount != ''",$otpharCond,'OtPharmacySalesBill.is_deleted'=>'0',
						'OtPharmacySalesBill.modified_time between ? and ?'=>array($fromDate, $toDate))));
  
		
		$this->OtPharmacySalesReturn->bindModel(array('belongsTo'=>Array(
				'OtPharmacySalesReturnDetail'=>array('type'=>'inner','foreignKey'=>false,
						'conditions'=>Array('OtPharmacySalesReturn.id=OtPharmacySalesReturnDetail.ot_pharmacy_sales_return_id')),
				'OtPharmacyItem'=>Array('type'=>'inner','foreignKey'=>false,'conditions'=>Array(
						'OtPharmacySalesReturnDetail.item_id=OtPharmacyItem.id')
					)
				)
				));
			
		$otPharmacyReturnDetail=$this->OtPharmacySalesReturn->find('all',array('fields'=>Array('sum(OtPharmacySalesReturnDetail.qty * OtPharmacySalesReturnDetail.mrp) AS total_amount',
				'sum( OtPharmacySalesReturnDetail.discount) as total_discount'),
				'conditions'=>Array('OtPharmacySalesReturn.billing_id NOT'=>NULL,$otpharCond,'OtPharmacySalesReturn.is_deleted'=>'0',
						'OtPharmacySalesReturn.modified_time between ? and ?'=>array($fromDate, $toDate))));
		
		$otpharReturn=round($otPharmacyReturnDetail['0']['0']['total_amount'])-round($otPharmacyReturnDetail['0']['0']['total_discount']);
		
		$otPharmacyDetails['OtPharmacy'][0]['total_amount']=$otPharmacyDetail['0']['0']['total_amount']-$otPharmacyDetail['0']['0']['total_discount']-$otpharReturn;
		$otPharmacyDetails['OtPharmacy'][0]['total_discount']=$otPharmacyDetail['0']['0']['total_discount']-round($otPharmacyReturnDetail['0']['0']['total_discount']);
 
		if($this->params->query['type']!='24' || empty($this->params->query['type'])){
			$patientCardDeposit=$this->PatientCard->find('all',array('fields'=>array('SUM(PatientCard.amount) as deposit'),
					'conditions'=>array('PatientCard.type'=>'deposit',
							'PatientCard.create_time between ? and ?'=>array($fromDate, $toDate))));
			
			$patientCardRefund=$this->PatientCard->find('all',array('fields'=>array('SUM(PatientCard.amount) as refund'),
					'conditions'=>array('PatientCard.type'=>'refund',
							'PatientCard.create_time between ? and ?'=>array($fromDate, $toDate))));
			
			$patientCardpayment=$this->PatientCard->find('all',array('fields'=>array('SUM(PatientCard.amount) as payment'),
					'conditions'=>array('PatientCard.type'=>'Payment',
							'PatientCard.create_time between ? and ?'=>array($fromDate, $toDate))));
		}
		
		$patientCard['Patient Card'][0]['total_amount']=$patientCardDeposit['0']['0']['deposit']-$patientCardRefund['0']['0']['refund']-$patientCardpayment['0']['0']['payment'];
		$dataDetails = array_merge($serviceBillDetails,$consultantDetails,$radiologyDetails,$laboratoryDetails,$wardPatientDetails,$optAppointmentDetails,$pharmacyDetails,$otPharmacyDetails,$patientCard);
		$this->set('dataDetails',$dataDetails);
			if($this->params->query['print']=='yes'){
					$this->set('dataDetails',$dataDetails);
					$this->render('service_wise_collection_print',false);
			}			
		
	}
	
	//BOF only for lab and rad service group report -amit jain
	public function service_group_report($Reporttype=null){
		$this->layout='advance';
		$this->uses=array('VoucherEntry','AccountReceipt','VoucherPayment','Account','ContraEntry','Patient');
		if(!empty($this->params->query)){
			$this->request->data['VoucherEntry']=$this->params->query;
		}
		if($this->request->data)
		{
			$click=1;
			$serviceType=$this->request->data['VoucherEntry']['name'];
			
			if(!empty($this->request->data['VoucherEntry']['from']))
			{
				$fromDate = $this->DateFormat->formatDate2STDForReport($this->request->data['VoucherEntry']['from'],Configure::read('date_format'))." 00:00:00";
				$conditions['VoucherEntry.date >=']=$fromDate;
				$from=$this->request->data['VoucherEntry']['from'];
			}
			else
			{
				$conditions['VoucherEntry.date >=']=date('Y-m-d').' 00:00:00';
				$from=date('d/m/Y');
			}
			if(!empty($this->request->data['VoucherEntry']['to']))
			{
				$toDate = $this->DateFormat->formatDate2STDForReport($this->request->data['VoucherEntry']['to'],Configure::read('date_format'))." 23:59:59";
				$conditions['VoucherEntry.date <=']=$toDate;
				$to=$this->request->data['VoucherEntry']['to'];
			}
			else
			{
				$dateTo = date('Y-m-d H:i:s');
				$conditions['VoucherEntry.date <=']=$dateTo;
				$to=date('d/m/Y');
			}
			$conditions['VoucherEntry.is_deleted']='0';
			$conditions['VoucherEntry.location_id']=$this->Session->read('locationid');
			$conditions['VoucherEntry.type'] = $serviceType;
			//for Journal Entries Account type
			$this->VoucherEntry->bindModel(array(
					"belongsTo"=>array(
							"Account"=>array("foreignKey"=>false ,'conditions'=>array('Account.id=VoucherEntry.user_id')),
							"AccountAlias"=>array('className'=>'Account',"foreignKey"=>false ,'conditions'=>array('AccountAlias.id=VoucherEntry.account_id')),
							'Patient' =>array('foreignKey' => false,'conditions'=>array('VoucherEntry.patient_id=Patient.id')),
					))) ;
			$JournalEntry=$this->VoucherEntry->find('all',array('fields'=>array('Patient.admission_type','Patient.lookup_name','VoucherEntry.user_id',
					'VoucherEntry.account_id','VoucherEntry.narration','VoucherEntry.id','VoucherEntry.debit_amount','VoucherEntry.date','VoucherEntry.type',
					'VoucherEntry.patient_id','AccountAlias.name','Account.opening_balance'),
					'conditions'=>$conditions));

			// for calculation of opening amount
			$sequenceDate=$this->DateFormat->formatDate2STD($from,Configure::read('date_format'));
			$sequenceDate=explode(' ',$sequenceDate);
			$sequenceDate=$sequenceDate[0].' 00:00:00';
				
			$journalCredit=$this->VoucherEntry->find('first',array('fields'=>array('SUM(VoucherEntry.debit_amount) as credit'),
					'conditions'=>array('VoucherEntry.date <'=>$sequenceDate,'VoucherEntry.user_id'=>$userid,'VoucherEntry.is_deleted'=>0,'VoucherEntry.location_id'=>$this->Session->read('locationid'))));
			$journalDebit=$this->VoucherEntry->find('first',array('fields'=>array('SUM(VoucherEntry.debit_amount) as debit'),
					'conditions'=>array('VoucherEntry.date <'=>$sequenceDate,'VoucherEntry.account_id'=>$userid,'VoucherEntry.is_deleted'=>0,'VoucherEntry.location_id'=>$this->Session->read('locationid'))));
		}
			
		$ledger = array();
		$payment = array();
		$reciept = array();
		$contra = array();
			
		// setting array for sequencing of journal entry, payment entry and reciept entry
		$i=0;
		foreach($JournalEntry as $JournalEntry){
			$date=$this->DateFormat->formatDate2Local($JournalEntry['VoucherEntry']['date'],Configure::read('date_format'),false);
			$ledger[$i/*strtotime($JournalEntry['VoucherEntry']['date'])*/][strtotime($JournalEntry['VoucherEntry']['date'])]=$JournalEntry;
			$i++;
		}
			
		$combineArray =array_merge($ledger);
		//to add sort order by date - amit J #0038
		foreach($combineArray as $combKey=>$combValue){
			$refineCombineArray[key($combValue)][]  = $combValue[key($combValue)] ;
		}
		//EOF sort order
		// For setting the name of user
			
		$userName=$this->Account->find('first',array('fields'=>array('name','opening_balance','payment_type'),'conditions'=>array('id'=>$userid,'location_id'=>$this->Session->read('locationid'),'is_deleted'=>0)));
		//Setting the Opening balance
		if(empty($journalCredit[0]['credit'])&& empty($journalDebit[0]['debit']))
		{
			if($userName['Account']['payment_type']=='Dr'){
				$type='Dr';
				$opening = $userName['Account']['opening_balance'];
			}else{
				$type='Cr';
				$opening = $userName['Account']['opening_balance'];
			}
		}
		else
		{ //Dr
			if($userName['Account']['payment_type']=='Dr'){
				$openingBalanceDebit = $userName['Account']['opening_balance'];
			}else{
				$openingBalanceCredit = $userName['Account']['opening_balance'];
			}
			$opening=($openingBalanceDebit + $journalDebit[0]['debit'])-($journalCredit[0]['credit']+$openingBalanceCredit);
			if($opening<0){
				$type='Cr';
				$opening=-($opening);
			}
			else{
				$type='Dr';
				$opening=$opening;
			}
		}
			
		$this->set('currency',$this->Session->read('Currency.currency_symbol'));
		$this->set(compact('serviceType','payable','from','to','opening','type','click','userid','narration','amount'));
		$this->set('ledger',$refineCombineArray);
		if($Reporttype=='excel'){
			$this->layout=false;
			$this->render('service_group_report_xls',false);
		}
	}
	
	public function autocompleteDirectSales(){
		$this->uses = array('User','Person','Patient','Account');
		$searchKey = $this->params->query['term'];
		
		$this->Patient->bindModel(array(
				'belongsTo'=>array(
					
				)));
	}
	
	public function service_wise_detail_report(){
		$this->layout = 'advance';
		$this->uses=array('Location','ServiceSubCategory','ServiceBill','ConsultantBilling','RadiologyTestOrder',
				'LaboratoryTestOrder','WardPatientService','PharmacySalesBill','OtPharmacySalesBill',
				'OptAppointment','PatientCard','InventoryPharmacySalesReturn',
				'OtPharmacySalesReturn');
		
		$this->set('locationList',$this->Location->getLocationIdByHospital());
		
		$startMonth = Configure::read('startFinancialYear');
		if((int) date('m') > 3){
			$date = date("Y$startMonth");
		}else{
			$date = (date("Y") - 1).date("$startMonth");
		}
		$conditions=array();
		
		if(empty($this->params->query)){
			$conditions=array();$pharCond=array();
			$conditions['TariffList.service_location NOT'] =NULL;
			$pharCond['PharmacyItem.location_id NOT']=NULL;
			$otpharCond['OtPharmacyItem.location_id NOT']=NULL;
			$fromDate=date('Y-m-d').' 00:00:00';
			$toDate=date('Y-m-d').' 23:59:59';
			$location='All';
		}else{
			$conditions=array();
			if($this->params->query['type'] == "All"){
				$conditions['TariffList.service_location NOT'] =NULL;
				$pharCond['PharmacyItem.location_id NOT']=NULL;
				$otpharCond['OtPharmacyItem.location_id NOT']=NULL;
				$location='All';
			}else{
				$conditions=array();
				$conditions['OR']= array('TariffList.service_location'=>$this->params->query['type'],array('AND'=>array('TariffList.service_location'=>'All',
						'Patient.location_id'=>$this->params->query['type']))) ; //1,24
		
		
				$pharCond['PharmacyItem.location_id ']=$this->params->query['type'];
				$otpharCond['OtPharmacyItem.location_id ']=$this->params->query['type'];
				//$conditions['Patient.location_id']=$this->params->query['type'];
				$location=$this->params->query['type'];
			}
			if(!empty($this->params->query['from_date'])){
				$fromDate = $this->DateFormat->formatDate2STDForReport($this->params->query['from_date'],Configure::read('date_format'))." 00:00:00";
			}else{
				$fromDate=date('Y-m-d').' 00:00:00';
			}
			if(!empty($this->params->query['to_date'])){
				$toDate = $this->DateFormat->formatDate2STDForReport($this->params->query['to_date'],Configure::read('date_format'))." 23:59:59";
			}else{
				$toDate=date('Y-m-d').' 23:59:59';
			}
		}
		
		$this->set('locationid',$location);
		
		$this->ServiceBill->bindModel(array(
				'belongsTo'=>array(
						'Patient'=>array("foreignKey"=>false,'conditions'=>array('Patient.id = ServiceBill.patient_id')),
						"TariffList"=>array("foreignKey"=>false,'conditions'=>array('TariffList.id = ServiceBill.tariff_list_id')),
						"ServiceCategory"=>array("foreignKey"=>false,'conditions'=>array('ServiceCategory.id = TariffList.service_category_id')),
						"ServiceSubCategory"=>array("foreignKey"=>false,'conditions'=>array('ServiceSubCategory.id = TariffList.service_sub_category_id')))
		)
		);
			
			
		$serviceBillDetails = $this->ServiceBill->find('all',array('fields'=>array('ServiceSubCategory.name','ServiceSubCategory.id','ServiceCategory.alias',
				'SUM(ServiceBill.paid_amount) as total_amount',
				'SUM(ServiceBill.discount) as total_discount'),'conditions'=>array('ServiceBill.modified_time between ? and ?'=>array($fromDate,$toDate) ,
						'ServiceBill.is_deleted'=>'0',
						$conditions,
						'OR'=>array(
								array('OR'=>array(array('ServiceBill.paid_amount NOT'=>'0'),array('ServiceBill.paid_amount NOT'=>NULL))),
								array('OR'=>array(array('ServiceBill.discount NOT'=>'0'),array('ServiceBill.discount NOT'=>NULL)))
						)
				),
				'group'=>array('ServiceSubCategory.id')));
		
		
		$this->ConsultantBilling->bindModel(array(
				'belongsTo'=>array(
						'Patient'=>array("foreignKey"=>false,'conditions'=>array('Patient.id = ConsultantBilling.patient_id')),
						"TariffList"=>array("foreignKey"=>false,'conditions'=>array('TariffList.id = ConsultantBilling.consultant_service_id')),
						"ServiceCategory"=>array("foreignKey"=>false,'conditions'=>array('ServiceCategory.id = TariffList.service_category_id')),
						"ServiceSubCategory"=>array("foreignKey"=>false,'conditions'=>array('ServiceSubCategory.id = TariffList.service_sub_category_id'))
				)
		));
		
		$consultantDetails=$this->ConsultantBilling->find('all',array('fields'=>array('ServiceSubCategory.name','ServiceSubCategory.id','ServiceCategory.alias',
				'SUM(ConsultantBilling.paid_amount) as total_amount','SUM(ConsultantBilling.discount) as total_discount'),
				'conditions'=>array('ConsultantBilling.modify_time between ? and ?'=>array($fromDate,$toDate),
						$conditions,
						'OR'=>array(
								array('OR'=>array(array('ConsultantBilling.paid_amount NOT'=>'0'),array('ConsultantBilling.paid_amount NOT'=>NULL ))),
								array('OR'=>array(array('ConsultantBilling.discount NOT'=>'0'),array('ConsultantBilling.discount NOT'=>NULL)))
						)
				),'group'=>array('ServiceSubCategory.id')));
		
		$this->RadiologyTestOrder->bindModel(array(
				'belongsTo'=>array(
						'Patient'=>array("foreignKey"=>false,'conditions'=>array('Patient.id = RadiologyTestOrder.patient_id')),
						"Radiology"=>array("foreignKey"=>false,'conditions'=>array('Radiology.id = radiology_id')),
						"TariffList"=>array("foreignKey"=>false,'conditions'=>array('TariffList.id = Radiology.tariff_list_id')),
						"ServiceCategory"=>array("foreignKey"=>false,'conditions'=>array('ServiceCategory.id = TariffList.service_category_id')),
						"ServiceSubCategory"=>array("foreignKey"=>false,'conditions'=>array('ServiceSubCategory.id = TariffList.service_sub_category_id')))
		));
		
		$radiologyDetails=$this->RadiologyTestOrder->find('all',array('fields'=>array('ServiceSubCategory.name','ServiceSubCategory.id','ServiceCategory.alias',
				'SUM(RadiologyTestOrder.paid_amount) as total_amount','SUM(RadiologyTestOrder.discount) as total_discount'),
				'conditions'=>array('RadiologyTestOrder.modified_bill_date between ? and ?'=>array($fromDate,$toDate),
						$conditions,
						'OR'=>array(
								array('OR'=>array(array('RadiologyTestOrder.paid_amount NOT'=>'0'),array('RadiologyTestOrder.paid_amount NOT'=>NULL ))),
								array('OR'=>array(array('RadiologyTestOrder.discount NOT'=>'0'),array('RadiologyTestOrder.discount NOT'=>NULL))),
						)
				),'group'=>array('ServiceSubCategory.id')));
		
		$this->LaboratoryTestOrder->bindModel(array(
				'belongsTo'=>array(
						'Patient'=>array("foreignKey"=>false,'conditions'=>array('Patient.id = LaboratoryTestOrder.patient_id')),
						"Laboratory"=>array("foreignKey"=>false,'conditions'=>array('Laboratory.id = LaboratoryTestOrder.laboratory_id')),
						"TariffList"=>array("foreignKey"=>false,'conditions'=>array('TariffList.id = Laboratory.tariff_list_id')),
						"ServiceCategory"=>array("foreignKey"=>false,'conditions'=>array('ServiceCategory.id = TariffList.service_category_id')),
						"ServiceSubCategory"=>array("foreignKey"=>false,'conditions'=>array('ServiceSubCategory.id = TariffList.service_sub_category_id')))
		));
		$laboratoryDetails=$this->LaboratoryTestOrder->find('all',array('fields'=>array('ServiceSubCategory.name','ServiceSubCategory.id','ServiceCategory.alias',
				'SUM(LaboratoryTestOrder.paid_amount) as total_amount','SUM(LaboratoryTestOrder.discount) as total_discount'),
				'conditions'=>array('LaboratoryTestOrder.modified_bill_date between ? and ?'=>array($fromDate,$toDate),
						'LaboratoryTestOrder.is_deleted'=>'0',$conditions,
						'OR'=>array(
								array('OR'=>array(array('LaboratoryTestOrder.paid_amount NOT'=>'0'),array('LaboratoryTestOrder.paid_amount NOT'=>NULL) )),
								array('OR'=>array(array('LaboratoryTestOrder.discount NOT'=>'0'),array('LaboratoryTestOrder.discount NOT'=>NULL)))
						)
				)
				,'group'=>array('ServiceCategory.id')));
		
		$this->WardPatientService->bindModel(array(
				'belongsTo'=>array(
						'Patient'=>array("foreignKey"=>false,'conditions'=>array('Patient.id = WardPatientService.patient_id')),
						"TariffList"=>array("foreignKey"=>false,'conditions'=>array('TariffList.id = WardPatientService.tariff_list_id')),
						"ServiceCategory"=>array("foreignKey"=>false,'conditions'=>array('ServiceCategory.id = TariffList.service_category_id')),
						"ServiceSubCategory"=>array("foreignKey"=>false,'conditions'=>array('ServiceSubCategory.id = TariffList.service_sub_category_id')))
		));
		$wardPatientDetails=$this->WardPatientService->find('all',array('fields'=>array('ServiceSubCategory.name','ServiceSubCategory.id','ServiceCategory.alias',
				'SUM(WardPatientService.paid_amount) as total_amount','SUM(WardPatientService.discount) as total_discount'),
				'conditions'=>array('WardPatientService.modified_time between ? and ?'=>array($fromDate,$toDate),
						'WardPatientService.is_deleted'=>'0',$conditions,
						'OR'=>array(
								array('OR'=>array(array('WardPatientService.paid_amount NOT'=>'0'),array('WardPatientService.paid_amount NOT'=>NULL))),
								array('OR'=>array(array('WardPatientService.discount NOT'=>'0'),array('WardPatientService.discount NOT'=>NULL))),
						)
				),
				'group'=>array('ServiceSubCategory.id')));
		
		$this->OptAppointment->unbindModel(array(
				'belongsTo' => array('Initial','Patient','Location','Opt','OptTable','Surgery','SurgerySubcategory','Doctor','DoctorProfile'
				)
		));
		
		$this->OptAppointment->bindModel(array(
				'belongsTo'=>array(
						'Patient'=>array("foreignKey"=>false,'conditions'=>array('Patient.id = OptAppointment.patient_id')),
						"TariffList"=>array("foreignKey"=>false,'conditions'=>array('TariffList.id = OptAppointment.tariff_list_id')),
						"ServiceCategory"=>array("foreignKey"=>false,'conditions'=>array('ServiceCategory.id = TariffList.service_category_id')),
						"ServiceSubCategory"=>array("foreignKey"=>false,'conditions'=>array('ServiceSubCategory.id = TariffList.service_sub_category_id')))
		));
		$optAppointmentDetails=$this->OptAppointment->find('all',array('fields'=>array('ServiceSubCategory.name','ServiceSubCategory.id','ServiceCategory.alias',
				'SUM(OptAppointment.paid_amount) as total_amount','SUM(OptAppointment.discount) as total_discount'),
				'conditions'=>array('OptAppointment.modify_time between ? and ?'=>array($fromDate,$toDate),
						'OptAppointment.is_deleted'=>'0',$conditions,
						'OR'=>array(
								array('OR'=>array(array('OptAppointment.paid_amount NOT'=>'0'),array('OptAppointment.paid_amount NOT'=>NULL))),
								array('OR'=>array(array('OptAppointment.discount NOT'=>'0'),array('OptAppointment.discount NOT'=>NULL)))
						)
				),'group'=>array('ServiceSubCategory.id')));
		
		$this->PharmacySalesBill->unBindModel(array('hasMany'=>array('PharmacySalesBillDetail'),
				'belongsTo'=>array('Patient','Doctor','Initial')
		));
			
		$this->PharmacySalesBill->bindModel(array('belongsTo'=>Array(
				'PharmacySalesBillDetail'=>array('type'=>'inner','foreignKey'=>false,'conditions'=>Array('PharmacySalesBill.id=PharmacySalesBillDetail.pharmacy_sales_bill_id')),
				'PharmacyItem'=>Array('type'=>'inner','foreignKey'=>false,'conditions'=>Array('PharmacySalesBillDetail.item_id=PharmacyItem.id'))
		)));
			
		$pharmacyDetail=$this->PharmacySalesBill->find('all',array('fields'=>Array('sum(PharmacySalesBillDetail.qty * PharmacySalesBillDetail.mrp) AS total_amount',
				'sum( PharmacySalesBillDetail.discount) as total_discount'),
				'conditions'=>Array("PharmacySalesBill.paid_amnt != ''",$pharCond,'PharmacySalesBill.is_deleted'=>'0',
						'PharmacySalesBill.modified_time between ? and ?'=>array($fromDate, $toDate))));
			
		$this->InventoryPharmacySalesReturn->bindModel(array('belongsTo'=>Array(
				'InventoryPharmacySalesReturnsDetail'=>array('type'=>'inner','foreignKey'=>false,'conditions'=>Array('InventoryPharmacySalesReturn.id=InventoryPharmacySalesReturnsDetail.inventory_pharmacy_sales_return_id')),
				'PharmacyItem'=>Array('type'=>'inner','foreignKey'=>false,'conditions'=>Array('InventoryPharmacySalesReturnsDetail.item_id=PharmacyItem.id'))
		)));
		
		$pharmacyReturnDetail=$this->InventoryPharmacySalesReturn->find('all',array('fields'=>Array('sum(InventoryPharmacySalesReturnsDetail.qty * InventoryPharmacySalesReturnsDetail.mrp) AS total_amount',
				'sum( InventoryPharmacySalesReturn.discount) as total_discount'),
				'conditions'=>Array('InventoryPharmacySalesReturn.billing_id NOT'=>NULL,$pharCond,'InventoryPharmacySalesReturn.is_deleted'=>'0',
						'InventoryPharmacySalesReturn.modified_time between ? and ?'=>array($fromDate, $toDate))));
		
		$pharReturn=round($pharmacyReturnDetail['0']['0']['total_amount'])-round($pharmacyReturnDetail['0']['0']['total_discount']);
		
		$pharmacyDetails['Pharmacy'][0]['total_amount']=$pharmacyDetail['0']['0']['total_amount']-$pharmacyDetail['0']['0']['total_discount']-$pharReturn;
		
		$pharmacyDetails['Pharmacy'][0]['total_discount']=$pharmacyDetail['0']['0']['total_discount']-round($pharmacyReturnDetail['0']['0']['total_discount']);
		
		
		$this->OtPharmacySalesBill->bindModel(array('belongsTo'=>Array(
				'OtPharmacySalesBillDetail'=>array('type'=>'inner','foreignKey'=>false,'conditions'=>Array('OtPharmacySalesBill.id=OtPharmacySalesBillDetail.ot_pharmacy_sales_bill_id')),
				'OtPharmacyItem'=>Array('type'=>'inner','foreignKey'=>false,'conditions'=>Array(
						'OtPharmacySalesBillDetail.item_id=OtPharmacyItem.id'))
		)));
			
		$otPharmacyDetail=$this->OtPharmacySalesBill->find('all',array('fields'=>Array('sum(OtPharmacySalesBillDetail.qty * OtPharmacySalesBillDetail.mrp) AS total_amount',
				'sum( OtPharmacySalesBillDetail.discount) as total_discount'),
				'conditions'=>Array("OtPharmacySalesBill.paid_amount != ''",$otpharCond,'OtPharmacySalesBill.is_deleted'=>'0',
						'OtPharmacySalesBill.modified_time between ? and ?'=>array($fromDate, $toDate))));
		
		
		$this->OtPharmacySalesReturn->bindModel(array('belongsTo'=>Array(
				'OtPharmacySalesReturnDetail'=>array('type'=>'inner','foreignKey'=>false,
						'conditions'=>Array('OtPharmacySalesReturn.id=OtPharmacySalesReturnDetail.ot_pharmacy_sales_return_id')),
				'OtPharmacyItem'=>Array('type'=>'inner','foreignKey'=>false,'conditions'=>Array(
						'OtPharmacySalesReturnDetail.item_id=OtPharmacyItem.id')
				)
		)
		));
			
		$otPharmacyReturnDetail=$this->OtPharmacySalesReturn->find('all',array('fields'=>Array('sum(OtPharmacySalesReturnDetail.qty * OtPharmacySalesReturnDetail.mrp) AS total_amount',
				'sum( OtPharmacySalesReturnDetail.discount) as total_discount'),
				'conditions'=>Array('OtPharmacySalesReturn.billing_id NOT'=>NULL,$otpharCond,'OtPharmacySalesReturn.is_deleted'=>'0',
						'OtPharmacySalesReturn.modified_time between ? and ?'=>array($fromDate, $toDate))));
		
		$otpharReturn=round($otPharmacyReturnDetail['0']['0']['total_amount'])-round($otPharmacyReturnDetail['0']['0']['total_discount']);
		
		$otPharmacyDetails['OtPharmacy'][0]['total_amount']=$otPharmacyDetail['0']['0']['total_amount']-$otPharmacyDetail['0']['0']['total_discount']-$otpharReturn;
		$otPharmacyDetails['OtPharmacy'][0]['total_discount']=$otPharmacyDetail['0']['0']['total_discount']-round($otPharmacyReturnDetail['0']['0']['total_discount']);
		
		if($this->params->query['type']!='24' || empty($this->params->query['type'])){
			$patientCardDeposit=$this->PatientCard->find('all',array('fields'=>array('SUM(PatientCard.amount) as deposit'),
					'conditions'=>array('PatientCard.type'=>'deposit',
							'PatientCard.create_time between ? and ?'=>array($fromDate, $toDate))));
				
			$patientCardRefund=$this->PatientCard->find('all',array('fields'=>array('SUM(PatientCard.amount) as refund'),
					'conditions'=>array('PatientCard.type'=>'refund',
							'PatientCard.create_time between ? and ?'=>array($fromDate, $toDate))));
				
			$patientCardpayment=$this->PatientCard->find('all',array('fields'=>array('SUM(PatientCard.amount) as payment'),
					'conditions'=>array('PatientCard.type'=>'Payment',
							'PatientCard.create_time between ? and ?'=>array($fromDate, $toDate))));
		}
		
		$patientCard['Patient Card'][0]['total_amount']=$patientCardDeposit['0']['0']['deposit']-$patientCardRefund['0']['0']['refund']-$patientCardpayment['0']['0']['payment'];
		$dataDetails = array_merge($serviceBillDetails,$consultantDetails,$radiologyDetails,$laboratoryDetails,$wardPatientDetails,$optAppointmentDetails,$pharmacyDetails,$otPharmacyDetails,$patientCard);
		$this->set('dataDetails',$dataDetails);
		if($this->params->query['print']=='yes'){
			$this->set('dataDetails',$dataDetails);
			$this->render('service_wise_collection_print',false);
		}
	}
	//function for summary invoice posting into tally only for kanpur by amit jain
	public function summaryInvoicePosting(){
		$this->uses = array('AccountBillingInterface','Patient','AccountReceipt','Location','VoucherLog','Account','AccountAlias');
		if($this->params->query){
			$this->request->data['Voucher'] = $this->params->query ;
		}else if($this->request->data){
			$this->request->data = $this->request->data;
		}
		$this->day_book('ajax','1');
	}
	/**
	 * function to set Is Posted 1 and 0
	 * @author Amit Jain
	 */
	public function setIsPosted(){
		$this->uses = array('VoucherLog');
		$this->VoucherLog->updateAll(array('VoucherLog.is_posted'=>$this->request->data['is_posted']),
				array('VoucherLog.id'=>$this->request->data['id']));
		exit;
	}
	
	//BOF for Print Cheque for payment voucher by - Amit Jain
	function printCheque($id=null){
		$this->layout = false;
		$this->uses = array('VoucherPayment','Account');
		$this->VoucherPayment->bindModel(array(
				"belongsTo"=>array(
						"Account"=>array("foreignKey"=>false ,'conditions'=>array('Account.id=VoucherPayment.user_id')),
						"AccountAlias"=>array('className'=>'Account',"foreignKey"=>false ,'conditions'=>array('AccountAlias.id=VoucherPayment.account_id'))),
		));
		if(!empty($id)){
			$voucherPaymentData = $this->VoucherPayment->find('first',array('fields'=>array('Account.name','Account.balance','VoucherPayment.*',
					'AccountAlias.name','AccountAlias.balance'),
					'conditions'=>array('VoucherPayment.id'=>$id,'VoucherPayment.is_deleted=0')));
	
			if($voucherPaymentData['Account']['balance'] < 0 ){
				$voucherPaymentData['Account']['balance']=$this->Number->currency(ceil($voucherPaymentData['Account']['balance']*(-1)))." Cr";
			}else{
				$voucherPaymentData['Account']['balance']=$this->Number->currency(ceil($voucherPaymentData['Account']['balance']))." Dr";
			}
			if($voucherPaymentData['AccountAlias']['balance'] < 0 ){
				$voucherPaymentData['AccountAlias']['balance']=$this->Number->currency(ceil($voucherPaymentData['AccountAlias']['balance']*(-1)))." Cr";
			}else{
				$voucherPaymentData['AccountAlias']['balance']=$this->Number->currency(ceil($voucherPaymentData['AccountAlias']['balance']))." Dr";
			}
			//debug($voucherPaymentData);
			$this->set(array('voucherPaymentData'=>$voucherPaymentData));
		}
	}
	//EOF for Print Cheque
	
	//BOF for external requisition commission by amit jain
	function ExternalRequisition(){
		$this->layout = 'advance';
		$this->uses = array('ExternalRequisitionCommission','ServiceProvider','ServiceCategory','Radiology');
		$category = Configure::read('service_provider_category');

		$this->set('categoryId',$this->ServiceCategory->getServiceGroupId('radiologyservices'));
		$this->set('serviceProvider',$this->ServiceProvider->getServiceProvider($category['radiology']));
		if(!empty($this->request->data)){
			if(!empty($this->request->data['ExternalRequisitionCommission'])){
				foreach($this->request->data['ExternalRequisitionCommission'] as $key => $value){
					$value['location_id']=$this->Session->read('locationid');
					$value['create_by']=$this->Session->read('userid');
					$value['create_time']=date('Y-m-d H:i:s');
					$value['service_provider_id']=$this->request->data['service_provider_id'];
					$value['service_category_id']=$this->request->data['service_category_id'];
					$this->ExternalRequisitionCommission->saveAll($value);
				}
				$this->Session->setFlash(__('Record saved successfully!'),true);
				$this->redirect(array('action'=>'ExternalRequisition'));
			}
		}else{
			$this->ExternalRequisitionCommission->bindModel(array(
					"belongsTo"=>array(
							"Radiology"=>array("foreignKey"=>false,'type'=>'INNER',
									'conditions'=>array('Radiology.id=ExternalRequisitionCommission.service_id')),
							"ServiceProvider"=>array("foreignKey"=>false,'type'=>'INNER',
									'conditions'=>array('ServiceProvider.id=ExternalRequisitionCommission.service_provider_id'))),
			));
			$commissionData=$this->ExternalRequisitionCommission->find('all',array('fields'=>array('ExternalRequisitionCommission.id',
					'ExternalRequisitionCommission.private_amount','ExternalRequisitionCommission.cghs_amount','Radiology.name','ServiceProvider.name'),
					'conditions'=>array('ExternalRequisitionCommission.is_deleted'=>'0',
							'ExternalRequisitionCommission.location_id'=>$this->Session->read('locationid'))));
			$this->set('commissionData',$commissionData);
		}
	}
	//EOF ERC
	
	//function to update private and cghs charges Commissions amit jain - 2.07.2015
	public function updateCommissions(){
		$this->autoRender = false;
		$this->uses = array('ExternalRequisitionCommission');
		if(!empty($this->request->data)){
			$data = $this->request->data;
			if(!empty($data['id'])){
				$this->ExternalRequisitionCommission->id = $data['id'];
				if($this->ExternalRequisitionCommission->save($data)){
					$returnArray = array('status'=>'updated','id'=>$data['id'],'private_amount'=>$data['private_amount'],'cghs_amount'=>$data['cghs_amount']);
					echo json_encode($returnArray);
					exit;
				}
			}
		}
	}
	//function to delete the Commissions by amit jain - 27.07.2015
	function deleteCommissions($id){
		$this->autoRender = false;
		$this->uses = array('ExternalRequisitionCommission');
		if(!empty($id)){
			if($this->ExternalRequisitionCommission->updateAll(array('ExternalRequisitionCommission.is_deleted'=>'1'),
					array('ExternalRequisitionCommission.id'=>$id))){
					return true;
			}
		}
	}
	
	/**
	 * function to generate report of corporate received payement
	 */
	function corporate_received(){
		$this->layout = 'advance';
			
		//change receivable as per approved amount
		$this->uses = array('CorporateSuperBill');
		//BOF date range by pankaj
		$condition= array();
		$this->request->data['Voucher'] = $this->params->query ;
		if(!empty($this->request->data)){
			if($this->request->data['Voucher']['from']){
				$fromDate = $this->DateFormat->formatDate2STDForReport($this->request->data['Voucher']['from'],Configure::read('date_format'));
			}
			if($this->request->data['Voucher']['to']){
				$toDate = $this->DateFormat->formatDate2STDForReport($this->request->data['Voucher']['to'],Configure::read('date_format'));
			}
			if(!empty($fromDate) && !empty($toDate)){
				$condition = array('CorporateSuperBill.date between ? and ?'=>array($fromDate,$toDate));
			}
		}
			
		$this->CorporateSuperBill->bindModel(array('belongsTo'=>array(
				'TariffStandard'=>array('type'=>'INNER',
						'conditions'=>array('CorporateSuperBill.tariff_standard_id=TariffStandard.id')) ,
				'CorporateSuperBillList'=>array('foreignKey'=>false ,
						'conditions'=>array('CorporateSuperBill.id=CorporateSuperBillList.corporate_super_bill_id')
				))));
			
		$data  = $this->CorporateSuperBill->find('all',array('conditions'=>array_merge(array( 'CorporateSuperBill.is_deleted=0','CorporateSuperBillList.is_deleted'=>0),$condition),
				'fields'=>array('SUM(CorporateSuperBillList.tds) as tds','SUM(CorporateSuperBill.received_amount) as amount_paid','TariffStandard.name','TariffStandard.id'),
				'group'=>array('CorporateSuperBill.tariff_standard_id')));
			
		$this->set(array('data'=>$data));
		$this->set(compact('from','to'));
	}
	function corporate_received_patient_details($id = NULL){
		//$this->layout = 'advance_ajax';
		if(!$id) $id = $this->params->query['tariff_standard_id'];
		//BOF super bill list as per selection by pankaj
		$this->uses=array('CorporateSuperBill','TariffStandard');
		$condition= array();
		$this->request->data['Voucher'] = $this->params->query ;
		if(!empty($this->request->data)){
			if($this->request->data['Voucher']['from']){
				$fromDate = $this->DateFormat->formatDate2STDForReport($this->request->data['Voucher']['from'],Configure::read('date_format'));
			}
			if($this->request->data['Voucher']['to']){
				$toDate = $this->DateFormat->formatDate2STDForReport($this->request->data['Voucher']['to'],Configure::read('date_format'));
			}
			if(!empty($fromDate) && !empty($toDate)){
				$condition = array('CorporateSuperBill.date between ? and ?'=>array($fromDate,$toDate));
			}
		}
	
		$this->CorporateSuperBill->bindModel(array('belongsTo'=>array(
				'Person'=>array('type'=>'INNER','foreignKey'=> false ,'conditions'=>array('CorporateSuperBill.person_id=Person.id')),
				'TariffStandard'=>array('type'=>'INNER',
						'conditions'=>array('CorporateSuperBill.tariff_standard_id=TariffStandard.id')) ,
				'CorporateSuperBillList'=>array('foreignKey'=>false ,'type'=>'INNER',
						'conditions'=>array('CorporateSuperBill.id=CorporateSuperBillList.corporate_super_bill_id')
				))));
			
		$result  =  $this->CorporateSuperBill->find('all',array('conditions'=>array_merge(
				array('CorporateSuperBill.tariff_standard_id'=>$id ,'CorporateSuperBillList.is_deleted'=>0),$condition),
				'fields'=>array('Person.first_name','Person.last_name' ,'SUM(CorporateSuperBill.approved_amount) as approved_amount',
						'SUM(CorporateSuperBill.received_amount) as received_amount','SUM(CorporateSuperBillList.tds) as TDS' ),'group'=>array('CorporateSuperBill.id'),'order'=>Array('Person.first_name asc')));
		$this->set(array('data'=>$result));
		$corporateName=$this->TariffStandard->find('first',array('fields'=>array('TariffStandard.name','TariffStandard.id'),'conditions'=>array('TariffStandard.id'=>$id)));
		$this->set('corporateName',$corporateName);
			
	}
	
	//BOF for posting payment & receipt entry backdated entry in voucherlog by amit jain
	//for accounting by amit
	public function addBackDatedEntry(){
		$this->uses = array('VoucherLog','AccountReceipt');
		$fromDate=date('2014-12-01').' 00:00:00';
		$toDate=date('2014-12-31').' 23:59:59';
		
		$receiptData = $this->AccountReceipt->find('all',array('fields'=> array('AccountReceipt.*'),
				'conditions'=>array('AccountReceipt.location_id'=>'1','AccountReceipt.is_deleted'=>'0',
						'AccountReceipt.date between ? and ?'=>array($fromDate, $toDate)),
		));
		
		$customArray = array();
		foreach ($receiptData as $key=> $data){
			$customArray[$data['AccountReceipt']['id']]['voucher_id'] = $data['AccountReceipt']['id'];
			$customArray[$data['AccountReceipt']['id']]['voucher_type'] = 'Receipt';
			$customArray[$data['AccountReceipt']['id']]['user_id'] = $data['AccountReceipt']['user_id'];
			$customArray[$data['AccountReceipt']['id']]['account_id'] = $data['AccountReceipt']['account_id'];
			$customArray[$data['AccountReceipt']['id']]['narration'] = $data['AccountReceipt']['narration'];
			$customArray[$data['AccountReceipt']['id']]['location_id'] = $data['AccountReceipt']['location_id'];
			$customArray[$data['AccountReceipt']['id']]['create_time'] = $data['AccountReceipt']['date'];
			$customArray[$data['AccountReceipt']['id']]['created_by'] = $data['AccountReceipt']['modified_by'];
			$customArray[$data['AccountReceipt']['id']]['paid_amount'] = $data['AccountReceipt']['paid_amount'];
			$customArray[$data['AccountReceipt']['id']]['voucher_no'] = $data['AccountReceipt']['id'];
			$customArray[$data['AccountReceipt']['id']]['type'] = 'USER';
		}
	
		foreach ($customArray as $key=> $accountData){
			$this->VoucherLog->save($accountData);
			$this->VoucherLog->id = '';
		}
		exit;
	}
	
	public function addBackDatedPaymentEntry(){
		$this->uses = array('VoucherLog','VoucherPayment');
		$fromDate=date('2014-12-01').' 00:00:00';
		$toDate=date('2014-12-31').' 23:59:59';
	
		$paymentData = $this->VoucherPayment->find('all',array('fields'=> array('VoucherPayment.*'),
				'conditions'=>array('VoucherPayment.location_id'=>'1','VoucherPayment.is_deleted'=>'0',
						'VoucherPayment.date between ? and ?'=>array($fromDate, $toDate)),
		));
		
		$customArray = array();
		foreach ($paymentData as $key=> $data){
			$customArray[$data['VoucherPayment']['id']]['voucher_id'] = $data['VoucherPayment']['id'];
			$customArray[$data['VoucherPayment']['id']]['voucher_type'] = 'Payment';
			$customArray[$data['VoucherPayment']['id']]['user_id'] = $data['VoucherPayment']['user_id'];
			$customArray[$data['VoucherPayment']['id']]['account_id'] = $data['VoucherPayment']['account_id'];
			$customArray[$data['VoucherPayment']['id']]['narration'] = $data['VoucherPayment']['narration'];
			$customArray[$data['VoucherPayment']['id']]['location_id'] = $data['VoucherPayment']['location_id'];
			$customArray[$data['VoucherPayment']['id']]['create_time'] = $data['VoucherPayment']['date'];
			$customArray[$data['VoucherPayment']['id']]['created_by'] = $data['VoucherPayment']['modified_by'];
			$customArray[$data['VoucherPayment']['id']]['paid_amount'] = $data['VoucherPayment']['paid_amount'];
			$customArray[$data['VoucherPayment']['id']]['voucher_no'] = $data['VoucherPayment']['id'];
			$customArray[$data['VoucherPayment']['id']]['type'] = 'USER';
		}
		
		foreach ($customArray as $key=> $accountData){
			$this->VoucherLog->save($accountData);
			$this->VoucherLog->id = '';
		}
		exit;
	}
	
	public function addBackDatedContraEntry(){
		$this->uses = array('VoucherLog','ContraEntry');
		$fromDate=date('2014-12-01').' 00:00:00';
		$toDate=date('2014-12-31').' 23:59:59';
	
		$contraData = $this->ContraEntry->find('all',array('fields'=> array('ContraEntry.*'),
				'conditions'=>array('ContraEntry.location_id'=>'1','ContraEntry.is_deleted'=>'0',
						'ContraEntry.date between ? and ?'=>array($fromDate, $toDate)),
		));
		
		$customArray = array();
		foreach ($contraData as $key=> $data){
			$customArray[$data['ContraEntry']['id']]['voucher_id'] = $data['ContraEntry']['id'];
			$customArray[$data['ContraEntry']['id']]['voucher_type'] = 'Contra';
			$customArray[$data['ContraEntry']['id']]['user_id'] = $data['ContraEntry']['user_id'];
			$customArray[$data['ContraEntry']['id']]['account_id'] = $data['ContraEntry']['account_id'];
			$customArray[$data['ContraEntry']['id']]['narration'] = $data['ContraEntry']['narration'];
			$customArray[$data['ContraEntry']['id']]['location_id'] = $data['ContraEntry']['location_id'];
			$customArray[$data['ContraEntry']['id']]['create_time'] = $data['ContraEntry']['date'];
			$customArray[$data['ContraEntry']['id']]['created_by'] = $data['ContraEntry']['created_by'];
			$customArray[$data['ContraEntry']['id']]['debit_amount'] = $data['ContraEntry']['debit_amount'];
			$customArray[$data['ContraEntry']['id']]['voucher_no'] = $data['ContraEntry']['id'];
			$customArray[$data['ContraEntry']['id']]['type'] = 'USER';
		}
		
		foreach ($customArray as $key=> $accountData){
			$this->VoucherLog->save($accountData);
			$this->VoucherLog->id = '';
		}
		exit;
	}
	
	public function purchase_entry($userid = null,$batchIdentifier = null,$type = null){
		$this->layout = 'advance';
		$this->uses = array('VoucherEntry');
		
		if(!empty($this->request->data)){			
			$requestData = array();
			foreach ($this->request->data['VoucherEntry'] as $key=> $data){
				$requestData['id'] = $data['id'];
				$requestData['user_id'] = $this->request->data['Entry']['user_id'];
				$requestData['account_id'] = $data['account_id'];
				$requestData['debit_amount'] = $data['debit_amount'];

				$requestData['date'] = $this->DateFormat->formatDate2STD($this->request->data['VoucherEntry']['date'],Configure::read('date_format'));
				$requestData['narration'] = $this->request->data['Entry']['narration'];
				
				$this->VoucherEntry->save($requestData);
				$this->VoucherEntry->id = '';
			}
			$this->Session->setFlash(__('Record update successfully!'),'default',array('class'=>'message'));
			$this->redirect(array('action'=>'legder_voucher'));
		}else{
			$this->VoucherEntry->bindModel(array(
					"belongsTo"=>array(
							"Account"=>array("foreignKey"=>false ,'conditions'=>array('Account.id=VoucherEntry.user_id')),
							"AccountAlias"=>array('className'=>'Account',"foreignKey"=>false ,'conditions'=>array('AccountAlias.id=VoucherEntry.account_id'))),
					));
			$dataDetail = $this->VoucherEntry->find('all',array('fields'=>array('VoucherEntry.id','VoucherEntry.date','VoucherEntry.account_id',
						'VoucherEntry.debit_amount','VoucherEntry.user_id','VoucherEntry.narration','VoucherEntry.batch_identifier','Account.name','Account.balance','AccountAlias.name',
						'AccountAlias.balance'),
						'conditions'=>array('VoucherEntry.user_id'=>$userid,'VoucherEntry.is_deleted'=>0,'VoucherEntry.batch_identifier'=>$batchIdentifier,
								'VoucherEntry.type'=>$type)));
			$customData = array();
			foreach ($dataDetail as $key=> $data){
				$customData['Account']['name'] = $data['Account']['name'];
				$customData['Account']['balance'] = $data['Account']['balance'];
				$customData['VoucherEntry']['user_id'] = $data['VoucherEntry']['user_id'];
				$customData['VoucherEntry']['user_id'] = $data['VoucherEntry']['user_id'];
				$customData['VoucherEntry']['date'] = $data['VoucherEntry']['date'];
				$customData['VoucherEntry']['credit_amount'] += $data['VoucherEntry']['debit_amount'];	
			}
			$this->set('creditData',$customData);
			$this->set('dataDetail',$dataDetail);
		}
	}
	
	/**
	 * function to set Is Posted 1 and 0
	 * @author Amit Jain
	 */
	function printDayBook(){
		$this->uses = array('AccountBillingInterface','Patient','AccountReceipt','Location','VoucherLog','Account','AccountAlias');
		$this->request->data['Voucher'] = $this->params->query ;
		$this->day_book($is_print = true);
		$this->layout = false;
	}
        
	//for get di
	function getAllPatientDiagnosis(){
            $this->uses = array('Patient','Diagnosis');
            $fromDate=date('Y-09-01').' 00:00:00';
            $toDate=date('Y-09-28').' 23:59:59';
            $this->Patient->bindModel(array(
                    "belongsTo"=>array(
                        "Diagnosis"=>array("foreignKey"=>false ,'conditions'=>array('Patient.id=Diagnosis.patient_id'))),
                    ));
            $purchaseData = $this->Patient->find('all',array('fields'=> array('Patient.form_received_on','Patient.lookup_name','Diagnosis.final_diagnosis'),
                    'conditions'=>array('Patient.form_received_on between ? and ?'=>array($fromDate, $toDate)),
            ));
	}
	
	/**
	 * Function to Show Petty Cash Book Transactions
	 * @author Amit Jain
	 */
	public function pettyCashBook($Reporttype=null){
		$this->layout = 'advance';
		$this->uses = array('VoucherPayment','Account','User','ContraEntry','Location','Billing','AccountReceipt');
		if(!empty($this->params->query)){
			$this->request->data['Voucher']=$this->params->query;
		}
		$new_type = $this->request->data['Voucher']['type'];
		$isHide = $this->request->data['Voucher']['isHide'];
		$location_id = $this->request->data['Voucher']['location_id'];
	
		if($this->request->data){
			//this condition for amount search by amit jain
			$amount=$this->request->data['Voucher']['amount'];
			if(!empty($this->request->data['Voucher']['amount'])){
				$Pconditions['VoucherPayment.paid_amount']=$amount;
				$Rconditions['AccountReceipt.paid_amount']=$amount;
				$Cconditions['ContraEntry.debit_amount']=$amount;
			}
			$manager_name = $this->request->data['Voucher']['manager_type'];
			if(!empty($this->request->data['Voucher']['manager_type'])){
				$Pconditions['VoucherPayment.create_by']=$manager_name;
				$Rconditions['AccountReceipt.create_by']=$manager_name;
				$Cconditions['ContraEntry.created_by']=$manager_name;
			}
			$user_name = $this->request->data['Voucher']['user_type'];
			if(!empty($this->request->data['Voucher']['user_type'])){
				$Pconditions['VoucherPayment.create_by']=$user_name;
				$Rconditions['AccountReceipt.create_by']=$user_name;
				$Cconditions['ContraEntry.created_by']=$user_name;
			}
			//this condition for narration search by amit jain
			$narration=$this->request->data['Voucher']['narration'];
			if(!empty($this->request->data['Voucher']['narration'])){
				$Pconditions['VoucherPayment.narration LIKE']='%'.$narration.'%';
				$Rconditions['AccountReceipt.narration LIKE']='%'.$narration.'%';
				$Cconditions['ContraEntry.narration LIKE']='%'.$narration.'%';
			}
			if(!empty($this->request->data['Voucher']['from'])){
				$fromDate = $this->DateFormat->formatDate2STDForReport($this->request->data['Voucher']['from'],Configure::read('date_format'))." 00:00:00";
	
				$Pconditions['VoucherPayment.date >=']=$fromDate;
				$Rconditions['AccountReceipt.date >=']=$fromDate;
				$Cconditions['ContraEntry.date >=']=$fromDate;
				$from=$this->request->data['Voucher']['from'];
	
				$balanceDateA['AccountReceipt.date <=']=$fromDate;
				$balanceDateP['VoucherPayment.date <=']=$fromDate;
				$balanceDateC['ContraEntry.date <=']=$fromDate;
			}else{
	
				$dateArray = date('Y-m-d').' 00:00:00';
				$Pconditions['VoucherPayment.date >='] = $dateArray;
				$Rconditions['AccountReceipt.date >='] = $dateArray;
				$Cconditions['ContraEntry.date >='] = $dateArray;
	
				$balanceDateA['AccountReceipt.date <=']=$dateArray;
				$balanceDateP['VoucherPayment.date <=']=$dateArray;
				$balanceDateC['ContraEntry.date <=']=$dateArray;
				$from=date('d/m/Y');
			}
			if(!empty($this->request->data['Voucher']['to'])){
				$toDate = $this->DateFormat->formatDate2STDForReport($this->request->data['Voucher']['to'],Configure::read('date_format'))." 23:59:59";
				$Pconditions['VoucherPayment.date <=']=$toDate;
				$Rconditions['AccountReceipt.date <=']=$toDate;
				$Cconditions['ContraEntry.date <=']=$toDate;
				$to=$this->request->data['Voucher']['to'];
	
			}else{
				$date = date('Y-m-d H:i:s');
				$Pconditions['VoucherPayment.date <=']=$date;
				$Rconditions['AccountReceipt.date <=']=$date;
				$Cconditions['ContraEntry.date <=']=$date;
				$to=date('d/m/Y');
			}
		}
		$Pconditions['VoucherPayment.paid_amount NOT'] = array('0','');
		$Rconditions['AccountReceipt.paid_amount NOT'] = array('0','');
	
		$Pconditions['VoucherPayment.is_deleted'] = 0;
		$Rconditions['AccountReceipt.is_deleted'] = 0;
		$Cconditions['ContraEntry.is_deleted'] = 0;
	
		if(!empty($location_id)){
			$Pconditions['VoucherPayment.location_id'] = $location_id;
			$Rconditions['AccountReceipt.location_id'] = $location_id;
			$Cconditions['ContraEntry.location_id'] = $location_id;
		}else{
			$Pconditions['VoucherPayment.location_id'] = $this->Session->read('locationid');
			$Rconditions['AccountReceipt.location_id'] = $this->Session->read('locationid');
			$Cconditions['ContraEntry.location_id'] = $this->Session->read('locationid');
			$location_id = $this->Session->read('locationid');
		}
	
		if(empty($this->request->data)){
			$dateArray = date('Y-m-d').' 00:00:00';
			$Pconditions['VoucherPayment.date >='] = $dateArray;
			$Rconditions['AccountReceipt.date >='] = $dateArray;
			$Cconditions['ContraEntry.date >='] = $dateArray;
	
			$balanceDateA['AccountReceipt.date <=']=$dateArray;
			$balanceDateP['VoucherPayment.date <=']=$dateArray;
			$balanceDateC['ContraEntry.date <=']=$dateArray;
			$from=date('d/m/Y');
			$to=date('d/m/Y');
		}
		$balanceDateP['VoucherPayment.type !='] ='MLCharges';
		$Pconditions['VoucherPayment.type !='] ='MLCharges';
	
		$pettyCash = "Petty Cash-in-hand";
		$cash= $this->Account->find('first',array('fields'=>array('Account.id','Account.opening_balance'),
				'conditions'=>array('Account.alias_name'=>$pettyCash,'Account.is_deleted'=>0,'Account.location_id'=>$location_id)));
	
		$balanceAmountReceipt = $this->AccountReceipt->find('all',array('fields'=>array('SUM(AccountReceipt.paid_amount) as totalReceiptBalance'),
				'conditions'=>array('AccountReceipt.account_id'=>$cash['Account']['id'],'AccountReceipt.is_deleted'=>0,$balanceDateA,
						'AccountReceipt.location_id'=>$location_id)));
		$balanceAmountPayment = $this->VoucherPayment->find('all',array('fields'=>array('SUM(VoucherPayment.paid_amount) as totalPaymentBalance'),
				'conditions'=>array('VoucherPayment.account_id'=>$cash['Account']['id'],'VoucherPayment.is_deleted'=>0,$balanceDateP,
						'VoucherPayment.location_id'=>$location_id)));
		$balanceAmountContraDebit = $this->ContraEntry->find('all',array('fields'=>array('SUM(ContraEntry.debit_amount) as totalDebitBalance'),
				'conditions'=>array('ContraEntry.account_id'=>$cash['Account']['id'],'ContraEntry.is_deleted'=>0,$balanceDateC,
						'ContraEntry.location_id'=>$location_id)));
		$balanceAmountContraCredit = $this->ContraEntry->find('all',array('fields'=>array('SUM(ContraEntry.debit_amount) as totalCreditBalance'),
				'conditions'=>array('ContraEntry.user_id'=>$cash['Account']['id'],'ContraEntry.is_deleted'=>0,$balanceDateC,
						'ContraEntry.location_id'=>$location_id)));
		$debit = $balanceAmountReceipt['0']['0']['totalReceiptBalance'] + $balanceAmountContraDebit['0']['0']['totalDebitBalance'];
		$credit = $balanceAmountPayment['0']['0']['totalPaymentBalance'] + $balanceAmountContraCredit['0']['0']['totalCreditBalance'];
		$openingBalance = $cash['Account']['opening_balance']+($debit - $credit);
		if($openingBalance<0){
			$type='Cr';
			$openingBalance=-($openingBalance);
		}else{
			$type='Dr';
			$openingBalance=$openingBalance;
		}
	
		//for payment entry by amit jain
		$this->VoucherPayment->bindModel(array(
				'belongsTo'=>array(
						'Account'=>array('foreignKey'=>'user_id','conditions'=>array('VoucherPayment.user_id=Account.id')),
						'User' =>array('foreignKey' => false,'conditions'=>array('VoucherPayment.create_by=User.id')),
				)),false);
		$voucherPaymentDetails = $this->VoucherPayment->find('all',array('fields'=>array('User.last_name','User.first_name','VoucherPayment.id',
				'VoucherPayment.paid_amount','VoucherPayment.date','VoucherPayment.account_id','VoucherPayment.narration','VoucherPayment.type',
				'Account.name','VoucherPayment.payment_voucher_no'),
				'conditions'=>array('OR'=>array('VoucherPayment.account_id'=>$cash['Account']['id'],'VoucherPayment.user_id'=>$cash['Account']['id']),
						$Pconditions),
				'order' =>array('VoucherPayment.date' => 'ASC')));
	
		//for receipt entry by amit jain
		$this->AccountReceipt->bindModel(array(
				'belongsTo'=>array(
						'Account'=>array('foreignKey'=>'user_id','conditions'=>array('AccountReceipt.user_id=Account.id')),
						'User' =>array('foreignKey' => false,'conditions'=>array('AccountReceipt.create_by=User.id')),
				)),false);
	
		$transactionPaidAccounts = $this->AccountReceipt->find('all',array('fields'=>array('User.last_name','User.first_name','AccountReceipt.id',
				'AccountReceipt.paid_amount','AccountReceipt.date','AccountReceipt.account_id','AccountReceipt.narration','Account.name',
				'AccountReceipt.account_receipt_no'),
				'conditions'=>array('OR'=>array('AccountReceipt.account_id'=>$cash['Account']['id'],'AccountReceipt.user_id'=>$cash['Account']['id']),
						$Rconditions),
				'order' =>array('AccountReceipt.date' => 'ASC')));
	
		//for contra entry by amit jain
		$this->ContraEntry->bindModel(array(
				'belongsTo'=>array(
						'Account'=>array('foreignKey'=>'user_id','conditions'=>array('ContraEntry.user_id=Account.id')),
						"AccountAlias"=>array('className'=>'Account',"foreignKey"=>'account_id' ,'conditions'=>array('ContraEntry.account_id=AccountAlias.id')),
						'User' =>array('foreignKey' => false,'conditions'=>array('ContraEntry.created_by=User.id')),
				)),false);
		$transactionContraEntry = $this->ContraEntry->find('all',array('fields'=>array('User.last_name','User.first_name','ContraEntry.id','ContraEntry.contra_voucher_no',
				'ContraEntry.debit_amount','ContraEntry.date','ContraEntry.account_id','ContraEntry.narration','Account.name','AccountAlias.name','Account.alias_name','AccountAlias.alias_name'),
				'conditions'=>array('OR'=>array('ContraEntry.account_id'=>$cash['Account']['id'],'ContraEntry.user_id'=>$cash['Account']['id']),$Cconditions),
				'order' =>array('ContraEntry.date' => 'ASC')));
		$this->set('userName',$this->Billing->getUserList(Configure::read('nurseLabel')));
	
		if($this->Session->read('location_created_by') == '0'){
			$this->set('locations',$this->Location->find('list',array('field'=>array('id','name'),
					'conditions'=>array('is_deleted'=>0,'created_by NOT'=>'0'))));
		}
		$this->set('transactionPaidAccounts',$transactionPaidAccounts);
		$this->set('voucherPaymentDetails',$voucherPaymentDetails);
		$this->set('transactionContraEntry',$transactionContraEntry);
		$this->set(compact('from','to','openingBalance','type','narration','amount','dateArray','new_type','location_id','isHide'));
		if($Reporttype=='excel'){
			$this->layout=false;
			$this->render('petty_cash_book_xls',false);
		}
	}
	
	//function to create Corporate Suspense by Swapnil - 02.11.2015
	public function corporateSuspense(){
		$this->layout = "advance";
		$this->set('title_for_layout',__('Corporate Suspense'));
		$this->uses = array('Account','AccountReceipt');
		
		$suspenseTypes = $this->Account->find('list',array('conditions'=>array('Account.user_type'=>Configure::read('SuspenseType'),'Account.is_deleted'=>'0')));
		$this->set('suspenseType',$suspenseTypes);
		$bankTypes = $this->Account->getBankNameList();
		$this->set('bankTypes',$bankTypes);
		
		if(!empty($this->request->data)){
			$conditions['AccountReceipt.user_id'] = $this->request->data['search_user_id'];
			$this->set('suspenseLedger',$this->request->data['search_user_id']);
		}

		$this->AccountReceipt->bindModel(array(
						'belongsTo'=>array(
							'Account'=>array('foreignKey'=>false,
								'conditions'=>array('AccountReceipt.user_id=Account.id')),
                            'User'=>array('foreignKey'=>false,
                            	'conditions'=>array('AccountReceipt.create_by=User.id')),
				)),false);
		$receiptData = $this->AccountReceipt->find('all',array(
			'fields'=>array(
				'AccountReceipt.id','AccountReceipt.paid_amount','AccountReceipt.date','AccountReceipt.narration',
				'AccountReceipt.tds_amount',
				'Account.name','Account.system_user_id',
				'User.first_name','User.last_name'),
			'conditions'=>array('AccountReceipt.type'=>Configure::read('SuspenseType'),'AccountReceipt.is_deleted'=>'0','AccountReceipt.paid_amount Not'=>'0',$conditions)));
		 
		$this->set('receiptData',$receiptData);
	}
  
	public function newCorporateAccountReceipt($id,$tariffStdId){ 
		$this->layout = "advance_ajax";
		$this->uses = array('Account','AccountReceipt','VoucherLog','VoucherEntry');
		if($this->request->data){
			$getReceiptData = $this->AccountReceipt->find('first',array('fields'=>array('AccountReceipt.*'),
					'conditions'=>array('AccountReceipt.id'=>$this->request->data['AccountReceipt']['id'],'AccountReceipt.is_deleted'=>'0')));
			
			$suspenseMergeData = array();
			foreach ($this->request->data['Corporate'] as $key=> $data){
				$suspenseMergeData['total_receipt_amount'] += $data['amount'];
				$suspenseMergeData['total_receipt_tds'] += $data['tds'];
			}
			if(!empty($this->request->data['AccountReceipt']['id'])){
				if(!empty($suspenseMergeData['total_receipt_amount']) || !empty($suspenseMergeData['total_receipt_tds'])){
					$updateAmount = $getReceiptData['AccountReceipt']['paid_amount']-$suspenseMergeData['total_receipt_amount'];
					$updateTds = $getReceiptData['AccountReceipt']['tds_amount']-$suspenseMergeData['total_receipt_tds'];
					
					$this->AccountReceipt->updateAll(array('AccountReceipt.paid_amount'=>$updateAmount,'AccountReceipt.tds_amount'=>$updateTds),
							array('AccountReceipt.id'=>$this->request->data['AccountReceipt']['id']));
					$this->VoucherLog->updateAll(array('VoucherLog.paid_amount'=>$updateAmount),array('VoucherLog.id'=>$this->request->data['VoucherLog']['id']));
					
					$this->VoucherEntry->updateAll(array('VoucherEntry.debit_amount'=>$updateTds),array('VoucherEntry.id'=>$this->request->data['VoucherEntry']['id']));
					$this->VoucherLog->updateAll(array('VoucherLog.paid_amount'=>$updateAmount),array('VoucherLog.voucher_id'=>$this->request->data['VoucherEntry']['id'],
							'VoucherLog.voucher_type'=>'Journal'));
				}
			}
			foreach ($this->request->data['Corporate'] as $key=> $data){
				$data['bank_id'] = $getReceiptData['AccountReceipt']['account_id'];
				$data['remark'] = $getReceiptData['AccountReceipt']['narration'];
				$data['date'] = $this->DateFormat->formatDate2STD($this->request->data["AccountReceipt"]['date'],Configure::read('date_format'));
				$result = $this->getAmountReceived($data['final_billing_id'],$data);
			}
			if($result){
				$this->Session->setFlash(__('Record update successfully!'),'default',array('class'=>'message'));
			}else{
				$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
			}
		}
		
		// edit section start
		if(!empty($id)){
			$this->AccountReceipt->bindModel(array(
					"belongsTo"=>array(
							"Account"=>array("foreignKey"=>false ,'conditions'=>array('Account.id=AccountReceipt.user_id')),
							"AccountAlias"=>array('className'=>'Account',"foreignKey"=>false ,'conditions'=>array('AccountAlias.id=AccountReceipt.account_id')),
							"VoucherLog"=>array("foreignKey"=>false ,'conditions'=>array('VoucherLog.voucher_id=AccountReceipt.id','VoucherLog.voucher_type'=>"Receipt")),
							'VoucherEntry'=>array('foreignKey'=>false,'conditions'=>array('VoucherEntry.batch_identifier=AccountReceipt.batch_identifier')),
							"AccountAliasTwo"=>array('className'=>'Account',"foreignKey"=>false ,'conditions'=>array('AccountAliasTwo.id=VoucherEntry.account_id'))),
					));
			$dataDetail = $this->AccountReceipt->find('first',array('conditions'=>array('AccountReceipt.id'=>$id,'AccountReceipt.is_deleted=0'),
					'fields'=>array('AccountReceipt.id','AccountReceipt.user_id','AccountReceipt.account_id','AccountReceipt.paid_amount','AccountReceipt.date',
							'AccountReceipt.narration','AccountReceipt.account_receipt_no','Account.name','AccountAlias.name',
							'VoucherLog.id','VoucherEntry.debit_amount','AccountAliasTwo.name','VoucherEntry.id')));
			//debug($dataDetail);
		}
		if(!empty($dataDetail['AccountReceipt']['date'])){
			$dataDetail['AccountReceipt']['date']=$this->DateFormat->formatDate2Local($dataDetail['AccountReceipt']['date'],Configure::read('date_format'),true);
		}
		if($dataDetail['Account']['balance'] < 0 ){
			$dataDetail['Account']['balance']=$this->Number->currency(ceil($dataDetail['Account']['balance']*(-1)))." Cr";
		}else{
			$dataDetail['Account']['balance']=$this->Number->currency(ceil($dataDetail['Account']['balance']))." Dr";
		}
		if($dataDetail['AccountAlias']['balance'] < 0 ){
			$dataDetail['AccountAlias']['balance']=$this->Number->currency(ceil($dataDetail['AccountAlias']['balance']*(-1)))." Cr";
		}else{
			$dataDetail['AccountAlias']['balance']=$this->Number->currency(ceil($dataDetail['AccountAlias']['balance']))." Dr";
		}
		if($dataDetail['AccountAliasTwo']['balance'] < 0 ){
			$dataDetail['AccountAliasTwo']['balance']=$this->Number->currency(ceil($dataDetail['AccountAliasTwo']['balance']*(-1)))." Cr";
		}else{
			$dataDetail['AccountAliasTwo']['balance']=$this->Number->currency(ceil($dataDetail['AccountAliasTwo']['balance']))." Dr";
		}
		$this->data= $dataDetail ;
		$this->set('dataDetail',$dataDetail);
	}
	/**
	 *  Function to show Trial Balance for duration
	 * @author Amit Jain
	 */
	public function trialBalanceReport(){
		$this->layout = 'advance';
		$this->uses=array('AccountingGroup','Account');
		$this->AccountingGroup->bindModel(array(
				'belongsTo'=>array(
						'Account'=>array('foreignKey'=>false,'conditions'=>array('AccountingGroup.id = Account.accounting_group_id','Account.is_deleted'=>'0'))
				)),false);
	
		$accountingGroupData = $this->AccountingGroup->find('all',array('fields'=>array('AccountingGroup.id','AccountingGroup.name',
				'Account.id','Sum(Account.balance) as TotalBalance'),
				'conditions'=>array('Account.is_deleted'=>'0','Account.location_id'=>$this->Session->read('locationid')),
				'group'=>array('AccountingGroup.id'),
				'order'=>array('AccountingGroup.name ASC')));
		$this->set('groupData',$accountingGroupData);
	}
	
	/**
	 *  Function to show Trial Balance for duration
	 * @author Amit Jain
	 */
	public function getGroupWiseLedger(){
		$this->layout = 'advance_ajax';
		$this->uses=array('AccountingGroup','Account');
		$groupId = $this->request->data['GroupId'];
		$this->AccountingGroup->bindModel(array(
				'belongsTo'=>array(
						'Account'=>array('foreignKey'=>false,'conditions'=>array('AccountingGroup.id = Account.accounting_group_id','Account.is_deleted'=>'0'))
				)),false);
	
		$accountingGroupData = $this->AccountingGroup->find('all',array('fields'=>array('Account.id','Account.name','SUM(Account.balance) as TotalLedgerBalance'),
				'conditions'=>array('Account.accounting_group_id'=>$groupId,'Account.is_deleted'=>'0',
						'Account.location_id'=>$this->Session->read('locationid'),'Account.balance NOT'=>'0'),
				'group'=>array('Account.id'),
				'order'=>array('Account.name ASC')));
		$this->set('ledgerData',$accountingGroupData);
		$this->render('ajax_ledger_data',false);
	}
	
	//================================BOF temp functions for hope hospital to correct all ledger balances by amit jain===========================//
	public function updateServicesLedger(){
		$this->layout = 'advance_ajax';
		$this->uses=array('Account','VoucherEntry');
		
		$serviceData = $this->Account->find('all',array('fields'=>array('Account.id'),
				'conditions'=>array('Account.is_deleted'=>'0','Account.user_type'=>array('TariffList','Ward'))));

		foreach ($serviceData as $key=>$data){
			$voucherData = $this->VoucherEntry->find('first',array('fields'=>array('VoucherEntry.user_id','SUM(VoucherEntry.debit_amount) as totalAmount'),
					'conditions'=>array('VoucherEntry.is_deleted'=>'0','VoucherEntry.user_id'=>$data['Account']['id'])));

			$this->Account->updateAll(array('Account.balance' => "'-".$voucherData['0']['totalAmount']."'"),
					array('Account.id'=>$data['Account']['id']));
			$this->Account->id='';
		}
	}
	//================================================================EOF =================================================================================//
	
	//================================BOF temp functions for hope hospital to correct all ledger balances by amit jain===========================//
	public function updateOthersLedger($groupId){
		
		$this->layout = 'advance_ajax';
		$this->uses=array('Account','VoucherEntry','VoucherPayment','ContraEntry','AccountReceipt','AccountingGroup');
		$result = $this->AccountingGroup->find('list',array('fields'=>array('AccountingGroup.id','AccountingGroup.id'),
				'conditions'=>array('AccountingGroup.is_deleted'=>0,'AccountingGroup.id'=>$groupId)));
				
ini_set('max_execution_time', 1200);
ini_set('max_input_time', 1200);
		foreach ($result as $key=> $group){
			$accountData = $this->Account->find('all',array('fields'=>array('Account.id','Account.name'),
						'conditions'=>array('Account.is_deleted'=>'0','Account.accounting_group_id'=>$group/* ,'Account.id >='=> '7242' */)));
		
			foreach ($accountData as $key=> $data){
				$userid = $data['Account']['id'];
				Configure::write('debug',2);
				debug($userid);
				debug($data['Account']['name']);
				$Econditions['VoucherEntry.date >=']=date('2012-m-d').' 00:00:00';
				$Pconditions['VoucherPayment.date >=']=date('2012-m-d').' 00:00:00';
				$Rconditions['AccountReceipt.date >=']=date('2012-m-d').' 00:00:00';
				$Cconditions['ContraEntry.date >=']=date('2012-m-d').' 00:00:00';
				
				$dateTo = date('Y-m-d H:i:s');
				$Econditions['VoucherEntry.date <=']=$dateTo;
				$Pconditions['VoucherPayment.date <=']=$dateTo;
				$Rconditions['AccountReceipt.date <=']=$dateTo;
				$Cconditions['ContraEntry.date <=']=$dateTo;
				
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
				if(array_key_exists($userid, $cashIds)){
					$Pconditions['VoucherPayment.type NOT'] = 'RefferalCharges';
				}
					
				$Econditions['VoucherEntry.type'] = array('USER','PurchaseOrder','SurgeryCharges','VisitCharges','CTMRI','Blood','PharmacyCharges','ServiceBill',
						'Consultant','Laboratory','Radiology','Registration','First Consul','Discount','DoctorCharges','NursingCharges','RoomCharges',
						'RefferalDoctor','OTChargesHospital','AnaesthesiaChargesHospital','SurgeryChargesHospital','DirectPharmacyCharges','PharmacyReturnCharges',
						'ExternalRad','ExternalLab','CashierShort','CashierExcess','ExternalConsultant','MLJV','Anaesthesia','Tds');
				$Rconditions['AccountReceipt.type'] = array('USER','PartialPayment','Advance','PharmacyCharges','DirectPharmacyCharge','FinalPayment',
						'DirectSaleBill','PatientCard','DirectPharmacyCharges','SuspenseAccount');
				
				//=========================================================BOF journal==================================================================//
				$JournalUserId = $this->VoucherEntry->find('first',array('fields'=>array('SUM(VoucherEntry.debit_amount) as voucherEntryAmtCredit'),
						'conditions'=>array($Econditions,'VoucherEntry.user_id'=>$userid)));
				
				$JournalAccountId = $this->VoucherEntry->find('first',array('fields'=>array('SUM(VoucherEntry.debit_amount) as voucherEntryAmtDebit'),
						'conditions'=>array($Econditions,'VoucherEntry.account_id'=>$userid)));
				//=========================================================EOF journal==================================================================//
				
				//=========================================================BOF VoucherPayment==================================================================//
				$PaymentUserId = $this->VoucherPayment->find('first',array('fields'=>array('SUM(VoucherPayment.paid_amount) as voucherPaymentAmtDebit'),
						'conditions'=>array($Pconditions,'VoucherPayment.user_id'=>$userid)));
			
				$PaymentAccountId = $this->VoucherPayment->find('first',array('fields'=>array('SUM(VoucherPayment.paid_amount) as voucherPaymentAmtCredit'),
						'conditions'=>array($Pconditions,'VoucherPayment.account_id'=>$userid)));
				//=========================================================EOF VoucherPayment==================================================================//
				
				//=========================================================BOF AccountReceipt==================================================================//
				$RecieptUserId = $this->AccountReceipt->find('first',array('fields'=>array('SUM(AccountReceipt.paid_amount) as accountReceiptAmtCredit'),
						'conditions'=>array($Rconditions,'AccountReceipt.user_id'=>$userid)));
		
				$RecieptAccountId = $this->AccountReceipt->find('first',array('fields'=>array('SUM(AccountReceipt.paid_amount) as accountReceiptAmtDebit'),
						'conditions'=>array($Rconditions,'AccountReceipt.account_id'=>$userid)));
				//=========================================================EOF AccountReceipt==================================================================//
				
				//=========================================================BOF ContraEntry==================================================================//
				$ContraUserId = $this->ContraEntry->find('first',array('fields'=>array('SUM(ContraEntry.debit_amount) as contraEntryAmtCredit'),
						'conditions'=>array($Cconditions,'ContraEntry.user_id'=>$userid)));
			
				$ContraAccountId = $this->ContraEntry->find('first',array('fields'=>array('SUM(ContraEntry.debit_amount) as contraEntryAmtDebit'),
						'conditions'=>array($Cconditions,'ContraEntry.account_id'=>$userid)));
				//=========================================================EOFContraEntry==================================================================//
				
				$openingBalance = $this->Account->find('first',array('fields'=>array('Account.opening_balance','Account.payment_type'),
						'conditions'=>array('Account.id'=>$userid,'Account.location_id'=>$this->Session->read('locationid'),'Account.is_deleted'=>0)));
		
				if($openingBalance['Account']['payment_type'] == 'Dr'){
					$openingBalDebit = $openingBalance['Account']['opening_balance'];
				}else{
					$openingBalCredit = $openingBalance['Account']['opening_balance'];
				}
				$debitAmount = $JournalAccountId['0']['voucherEntryAmtDebit']+$PaymentUserId['0']['voucherPaymentAmtDebit']+
								$RecieptAccountId['0']['accountReceiptAmtDebit']+$ContraAccountId['0']['contraEntryAmtDebit']+$openingBalDebit;
				
				$creditAmount = $JournalUserId['0']['voucherEntryAmtCredit']+$PaymentAccountId['0']['voucherPaymentAmtCredit']+
								$RecieptUserId['0']['accountReceiptAmtCredit']+$ContraUserId['0']['contraEntryAmtCredit']+$openingBalCredit;
				
				$netAmount = (round($debitAmount)-round($creditAmount));
				
				$this->Account->updateAll(array('Account.balance'=>$netAmount),array('Account.id'=>$userid));
				$this->Account->id='';
				$openingBalDebit = '';
				$openingBalCredit = '';
				$debitAmount = '';
				$creditAmount = '';
				$netAmount = '';
			}
		}
		exit;
	}
	//================================================================EOF =================================================================================//
	
	public function journal_entry_new($patientId = null){
		$this->layout = 'advance';
		$this->uses = array('VoucherEntry');
		if(!empty($this->request->data)){
			$requestData = array();
			foreach ($this->request->data['VoucherEntry'] as $key=> $data){
				$requestData['id'] = $data['id'];
				$requestData['user_id'] = $this->request->data['Entry']['user_id'];
				$requestData['account_id'] = $data['account_id'];
				$requestData['debit_amount'] = $data['debit_amount'];
				$requestData['date'] = $this->DateFormat->formatDate2STD($this->request->data['Entry']['date'],Configure::read('date_format'));
				$requestData['narration'] = $this->request->data['Entry']['narration'];
				$this->VoucherEntry->save($requestData);
				$this->VoucherEntry->id = '';
			}
			$this->Session->setFlash(__('Record update successfully!'),'default',array('class'=>'message'));
			$this->redirect(array('action'=>'legder_voucher'));
		}else{
			$this->VoucherEntry->bindModel(array(
					"belongsTo"=>array(
							"Account"=>array("foreignKey"=>false ,'conditions'=>array('Account.id=VoucherEntry.account_id')),
							"AccountAlias"=>array('className'=>'Account',"foreignKey"=>false ,'conditions'=>array('AccountAlias.id=VoucherEntry.user_id'))),
			));
			$dataDetail = $this->VoucherEntry->find('all',array('fields'=>array('VoucherEntry.id','VoucherEntry.date','VoucherEntry.account_id',
					'VoucherEntry.debit_amount','VoucherEntry.user_id','VoucherEntry.narration','VoucherEntry.batch_identifier',
					'VoucherEntry.patient_id','VoucherEntry.type','Account.name','Account.balance','AccountAlias.name','AccountAlias.balance'),
					'conditions'=>array('VoucherEntry.patient_id'=>$patientId,'VoucherEntry.is_deleted'=>0,
							'VoucherEntry.type NOT'=>array('Discount','VisitCharges','FinalBilling'))));
			
			$customData = array();
			foreach ($dataDetail as $key=> $data){
				$customData['Account']['name'] = $data['Account']['name'];
				$customData['Account']['balance'] = $data['Account']['balance'];
				$customData['VoucherEntry']['account_id'] = $data['VoucherEntry']['account_id'];
				$customData['VoucherEntry']['user_id'] = $data['VoucherEntry']['user_id'];
				$customData['VoucherEntry']['date'] = $data['VoucherEntry']['date'];
				$customData['VoucherEntry']['credit_amount'] += $data['VoucherEntry']['debit_amount'];
			}
			$this->set('creditData',$customData);
			$this->set('dataDetail',$dataDetail);
		}
	}
	
	public function printContraVoucher($id){
		$this->layout = false;
		$this->uses = array('ContraEntry','Account');
		$this->ContraEntry->bindModel(array(
				"belongsTo"=>array(
						"Account"=>array("foreignKey"=>false ,'conditions'=>array('Account.id=ContraEntry.user_id')),
						"AccountAlias"=>array('className'=>'Account',"foreignKey"=>false ,'conditions'=>array('AccountAlias.id=ContraEntry.account_id'))),
		));
		if(!empty($id)){
			$contraData = $this->ContraEntry->find('first',array('fields' => array('Account.name','ContraEntry.*','AccountAlias.name'),
					'conditions'=>array('ContraEntry.id'=>$id,'ContraEntry.is_deleted=0')));
			$this->set(array('contraData'=>$contraData));
		}
	}
	
	public function printJournalVoucher($id){
		$this->layout = false;
		$this->uses=array('VoucherEntry');
		$getMultyEntry = $this->VoucherEntry->getBatchIdentifier($id);

		if(!empty($getMultyEntry['VoucherEntry']['batch_identifier'])){
			$condition['VoucherEntry.batch_identifier']=$getMultyEntry['VoucherEntry']['batch_identifier'];
		}elseif($getMultyEntry['VoucherEntry']['patient_id']){
			$condition['VoucherEntry.patient_id']=$getMultyEntry['VoucherEntry']['patient_id'];
			$condition['VoucherEntry.type']=array('Laboratory','Radiology','ServiceBill','Consultant','SurgeryChargesHospital','AnaesthesiaChargesHospital',
					'OTChargesHospital','PharmacyCharges','DoctorCharges','NursingCharges','RoomCharges');
		}else{
			$condition['VoucherEntry.id']=$id;
		}
		
		$this->VoucherEntry->bindModel(array(
				"belongsTo"=>array(
						"Account"=>array("foreignKey"=>false ,'conditions'=>array('Account.id=VoucherEntry.user_id')),
						"AccountAlias"=>array('className'=>'Account',"foreignKey"=>false ,'conditions'=>array('AccountAlias.id=VoucherEntry.account_id'))),
			));
	
		$getData = $this->VoucherEntry->find('all',array('fields' => array('Account.name','AccountAlias.name',
					'VoucherEntry.journal_voucher_no','VoucherEntry.date','VoucherEntry.debit_amount','VoucherEntry.narration','VoucherEntry.location_id'),
					'conditions'=>array($condition,'VoucherEntry.is_deleted=0')));
		
		$journalData=array();
		foreach ($getData as $key=>$data){
			$journalData['journal_voucher_no'] = $data['VoucherEntry']['journal_voucher_no'];
			$journalData['date'] = $data['VoucherEntry']['date'];
			$journalData['location_id'] = $data['VoucherEntry']['location_id'];
			$journalData['narration'] = $data['VoucherEntry']['narration'];
			$journalData['debit']['name'] = $data['AccountAlias']['name'];
			$journalData['debit']['debit_amount'] += $data['VoucherEntry']['debit_amount'];
			$journalData['credit'][$key]['name'] = $data['Account']['name'];
			$journalData['credit'][$key]['credit_amount'] = $data['VoucherEntry']['debit_amount'];
			$journalData['total_amount'] += $data['VoucherEntry']['debit_amount'];
		}
		$this->set(array('journalData'=>$journalData));
	}
	public function printRtgsRemittance($id,$type,$paymentVoucherId){
		$this->layout = 'advance_ajax';
		$this->uses=array('VoucherPayment','HrDetail');
		$this->set('hrDetails',$this->HrDetail->findFirstHrDetails($id,$type));
		$this->VoucherPayment->bindModel(array(
				"belongsTo"=>array(
						"Account"=>array("foreignKey"=>false ,'conditions'=>array('Account.id=VoucherPayment.user_id')),
		)));
		$paymentEntry=$this->VoucherPayment->find('first',array('fields'=>array('Account.name','VoucherPayment.date','VoucherPayment.user_id','VoucherPayment.narration','VoucherPayment.account_id','VoucherPayment.id','VoucherPayment.paid_amount'),'conditions'=>array('VoucherPayment.id'=>$paymentVoucherId,'VoucherPayment.is_deleted'=>0,'Account.is_deleted'=>0)));	
		$this->set('paymentEntry',$paymentEntry);
	}
	 public function saveRtgs() {
       	$this->uses=array('VoucherPayment','HrDetail');
        $this->autoRender = false;
        $this->layout =false;
	
		if(!empty($this->request->data['HrDetail'])){									
						$this->HrDetail->saveData($this->request->data);
		}
		
		$this->set('print',1);
		$this->set('hrDetails',$this->HrDetail->findFirstHrDetails($this->request->data['HrDetail']['user_id'],$this->request->data['HrDetail']['type_of_user']));
			$this->VoucherPayment->bindModel(array(
				"belongsTo"=>array(
						"Account"=>array("foreignKey"=>false ,'conditions'=>array('Account.id=VoucherPayment.user_id')),
		)));
		$paymentEntry=$this->VoucherPayment->find('first',array('fields'=>array('Account.name','VoucherPayment.date','VoucherPayment.user_id','VoucherPayment.narration','VoucherPayment.account_id','VoucherPayment.id','VoucherPayment.paid_amount'),'conditions'=>array('VoucherPayment.id'=>$this->request->data['VoucherPayment']['id'],'VoucherPayment.is_deleted'=>0,'Account.is_deleted'=>0)));	
		$this->set('paymentEntry',$paymentEntry);
		$this->render('print_rtgs_remittance','print_without_header');
       /* if ($this->request->query['remark'] != NULL) {
            $this->request->data['Patient']['id'] = $id;
            $this->request->data['HrDetail']['remark'] = "Package amount Rs." . $this->request->query['remark'] . "/-";
            $this->Patient->save($this->request->data);
        }*/
    }
	// tem. function for update opd patient is discharge 0 for crone by amit jain
    public function updateIsDischargeOpd() {
    	$this->uses=array('Patient');
    	$this->layout =false;
    	$fromDate = '2014-11-12 00:00:00';
    	$toDate = '2014-12-31 23:59:59';
    	$patientIds=$this->Patient->find('all',array('fields'=>array('Patient.id'),
    			'conditions'=>array('Patient.admission_type NOT'=>'IPD','Patient.is_deleted'=>0,
    					'Patient.create_time BETWEEN ? AND ?' => array($fromDate,$toDate))));
    	foreach ($patientIds as $patientData){
    		$this->Patient->updateAll(array('Patient.is_discharge'=>'0'),array('Patient.id'=>$patientData['Patient']['id']));
    		$this->Patient->id='';
    	}
    	exit;
    }
    //EOF
    
    public function spotAdvanceSharing($id=null){
    	$this->layout = "advance_ajax";
    	$this->uses = array('Account','VoucherPayment','VoucherLog','VoucherEntry','AccountReceipt');
    	if($this->request->data){
    		foreach ($this->request->data['Corporate'] as $key=> $data)
    		$result = $this->insertSpotBackingPayment($data,$this->request->data);
    		if($result){
    			$this->Session->setFlash(__('Record update successfully!'),'default',array('class'=>'message'));
    		}else{
    			$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
    		}
    	}
    
    	// edit section start
    	if(!empty($id)){
    		$this->VoucherPayment->bindModel(array(
    				"belongsTo"=>array(
    						"Account"=>array("foreignKey"=>false ,'conditions'=>array('Account.id=VoucherPayment.user_id')),
    						"AccountAlias"=>array('className'=>'Account',"foreignKey"=>false ,'conditions'=>array('AccountAlias.id=VoucherPayment.account_id'))),
    		));
    		$dataDetail = $this->VoucherPayment->find('first',array('conditions'=>array('VoucherPayment.id'=>$id,'VoucherPayment.is_deleted=0'),
    				'fields'=>array('VoucherPayment.id','VoucherPayment.user_id','VoucherPayment.account_id','VoucherPayment.paid_amount','VoucherPayment.date',
    						'VoucherPayment.narration','VoucherPayment.payment_voucher_no','VoucherPayment.remaining_sharing_amount','Account.name','Account.system_user_id','AccountAlias.name')));
    	}
    	if(!empty($dataDetail['VoucherPayment']['date'])){
    		$dataDetail['VoucherPayment']['date']=$this->DateFormat->formatDate2Local($dataDetail['VoucherPayment']['date'],Configure::read('date_format'),true);
    	}
    	if($dataDetail['Account']['balance'] < 0 ){
    		$dataDetail['Account']['balance']=$this->Number->currency(ceil($dataDetail['Account']['balance']*(-1)))." Cr";
    	}else{
    		$dataDetail['Account']['balance']=$this->Number->currency(ceil($dataDetail['Account']['balance']))." Dr";
    	}
    	if($dataDetail['AccountAlias']['balance'] < 0 ){
    		$dataDetail['AccountAlias']['balance']=$this->Number->currency(ceil($dataDetail['AccountAlias']['balance']*(-1)))." Cr";
    	}else{
    		$dataDetail['AccountAlias']['balance']=$this->Number->currency(ceil($dataDetail['AccountAlias']['balance']))." Dr";
    	}
    	if($dataDetail['AccountAliasTwo']['balance'] < 0 ){
    		$dataDetail['AccountAliasTwo']['balance']=$this->Number->currency(ceil($dataDetail['AccountAliasTwo']['balance']*(-1)))." Cr";
    	}else{
    		$dataDetail['AccountAliasTwo']['balance']=$this->Number->currency(ceil($dataDetail['AccountAliasTwo']['balance']))." Dr";
    	}
    	$this->data= $dataDetail ;
    	$this->set('consultantId',$dataDetail['Account']['system_user_id']);
    	$this->set('dataDetail',$dataDetail);
    }
    
    //function corporate patient search autocomplete on suspense account by Swapnil - 14.11.2015
    public function patientSearch($consultantId=null) {
    	$this->uses = array('Patient');
    	$this->autoRender = false;
    	$this->layout = false;
    	$searchKey = $this->params->query['term'];
    	$patientData = $this->Patient->find('all', array('fields' => array('Patient.id','Patient.lookup_name','Patient.consultant_id'),
    			'conditions' => array('Patient.is_deleted'=>'0','Patient.lookup_name LIKE'=>$searchKey."%",'Patient.consultant_id !='=>null),
    			'order' => array('Patient.id'=>'DESC')));
    	
    	foreach ($patientData as $key => $value) { 
    		$consultantUnser = unserialize($value['Patient']['consultant_id']);
    		if(in_array($consultantId, $consultantUnser)){
	    		$spotAmount = $this->spotImplantPayment($value['Patient']['id'],$consultantId,true);
	    		
	    		$returnArr[] = array(
	    				'id' => $value['Patient']['id'],
	    				'name' => $value['Patient']['lookup_name'],
	    				'value' => $value['Patient']['lookup_name'],
	    				's_payable'=>$spotAmount['sAmount'] ? $spotAmount['sAmount'] : '0',
	    				'b_payable'=>$spotAmount['profitBillData'] ? $spotAmount['profitBillData'] :'0',
	    				'b_amount'=>$spotAmount['advanceAmntSb']['Patient']['b_amount'] ? $spotAmount['advanceAmntSb']['Patient']['b_amount'] : '0',
	    				'spot_amount'=>$spotAmount['advanceAmntSb']['Patient']['spot_amount'] ? $spotAmount['advanceAmntSb']['Patient']['spot_amount'] : '0',
	    				'balance_amount'=>(($spotAmount['sAmount'] + $spotAmount['profitBillData']) - ($spotAmount['advanceAmntSb']['Patient']['b_amount'] + $spotAmount['advanceAmntSb']['Patient']['spot_amount'])),
	    		);
    		}
    	}
    	echo json_encode($returnArr);
    	exit;
    }
    
    public function insertSpotBackingPayment($patientData=array(),$requestData=array()){
    	$this->uses = array('Account','VoucherPayment','VoucherLog','AccountReceipt','SpotApproval','VoucherEntry','Patient');
    	if(!empty($patientData)){
    		$date = date('Y-m-d H:i:s');
    		
    		$this->VoucherPayment->updateAll(array('VoucherPayment.remaining_sharing_amount'=>$requestData['VoucherPayment']['remaining_sharing_amount']),
    				array('VoucherPayment.id'=>$requestData['VoucherPayment']['id']));
    		$this->VoucherPayment->id='';
    		
    		
    		$patientDetails = $this->Patient->find('first', array('fields'=>array('Patient.spot_amount','Patient.spot_date','Patient.b_date','Patient.b_amount'),
    				'conditions' => array('Patient.id'=>'0')));
    		if($patientData['spot_type'] == 'S'){
	    		$this->Patient->updateAll(array('Patient.spot_amount'=>$patientDetails['Patient']['spot_amount'] + $patientData['sharing_amount'],
	    				'Patient.spot_date'=>$date),array('Patient.id'=>$patientData['patient_id']));
	    		$this->Patient->id='';
    		}else if($patientData['spot_type'] == 'B'){
    			$this->Patient->updateAll(array('Patient.b_amount'=>$patientDetails['Patient']['b_amount'] + $patientData['sharing_amount'],
    					'Patient.b_date'=>$date),array('Patient.id'=>$patientData['patient_id']));
    			$this->Patient->id='';
    		}
    		
    		$narration='';
    		$patientName = $patientData['patient_name'];
    		$narration = "Being cash paid for implant purchase against patient $patientName on $date";
    		$voucherLogDataPay=$pvData = array(
		    				'date'=>$date,
		    				'modified_by'=>$this->Session->read('userid'),
		    				'create_by'=>$this->Session->read('userid'),
		    				'account_id'=>$requestData['VoucherPayment']['account_id'],
		    				'patient_id'=>$patientData['patient_id'],
		    				'type'=>'RefferalCharges',
		    				'user_id'=>$requestData['VoucherPayment']['user_id'],
		    				'narration'=>$narration,
		    				'paid_amount'=>$patientData['sharing_amount']);
    		if(!empty($pvData['paid_amount']) && ($pvData['paid_amount'] != 0)){
    			$lastVoucherIdPayment=$this->VoucherPayment->insertPaymentEntry($pvData);
    			// ***insert into Account (By) credit manage current balance
    			$this->Account->setBalanceAmountByAccountId($requestData['VoucherPayment']['account_id'],$patientData['sharing_amount'],'debit');
    			$this->Account->setBalanceAmountByUserId($requestData['VoucherPayment']['user_id'],$patientData['sharing_amount'],'credit');
    			//insert into voucher_logs table added by PankajM
    			$voucherLogDataPay['voucher_no']=$lastVoucherIdPayment;
    			$voucherLogDataPay['voucher_id']=$lastVoucherIdPayment;
    			$voucherLogDataPay['voucher_type']="Payment";
    			$this->VoucherLog->insertVoucherLog($voucherLogDataPay);
    			$this->VoucherLog->id= '';
    			$this->VoucherPayment->id= '';
    		}
    			
    		//for dummy payment entry (Hope hopital)
    		$narration = "$patientName done on $date";
    		$mlId = $this->Account->getAccountIdOnly(Configure::read('mlEnterprise'));//for cash id
    		$dpvData = array();
    		$dpvData = array('date'=>$date,
    				'modified_by'=>$this->Session->read('userid'),
    				'create_by'=>$this->Session->read('userid'),
    				'account_id'=>$requestData['VoucherPayment']['account_id'],
    				'patient_id'=>$patientData['patient_id'],
    				'batch_identifier'=>$lastVoucherIdPayment,
    				'type'=>'MLCharges',
    				'user_id'=>$mlId,
    				'narration'=>$narration,
    				'paid_amount'=>$patientData['sharing_amount']);
    		if(!empty($dpvData['paid_amount']) && ($dpvData['paid_amount'] != 0)){
    			$this->VoucherPayment->insertPaymentEntry($dpvData);
    			// ***insert into Account (By) credit manage current balance
    			$this->Account->setBalanceAmountByAccountId($mlId,$patientData['sharing_amount'],'debit');
    			$this->VoucherPayment->id= '';
    		}
    
    		$this->SpotApproval->save(array(
    						'voucher_payment_id'=>$lastVoucherIdPayment,
    						'patient_id'=>$patientData['patient_id'],
    						'amount'=>$patientData['sharing_amount'],
    						'type'=>$patientData['spot_type'],
    						'create_time'=>date('Y-m-d H:i:s')));
    		$this->SpotApproval->id= '';
    		$lastVoucherIdPayment='';
    		
    		//JV Entry for spot
    		$this->Account->id='';
    		$implantPurchaseId = $this->Account->getAccountIdOnly(Configure::read('implantPurchaseLabel'));//for cash id
    		$jvData = array();
    		$jvData = array('date'=>$date,
    				'created_by'=>$this->Session->read('userid'),
    				'account_id'=>$implantPurchaseId,
    				'user_id'=>$mlId,
    				'type'=>'MLJV',
    				'narration'=>$narration,
    				'debit_amount'=>$patientData['sharing_amount']);
    		if(!empty($jvData['debit_amount']) && ($jvData['debit_amount'] != 0)){
    			$this->VoucherEntry->insertJournalEntry($jvData);
    			$this->VoucherEntry->id ='';
    			// ***insert into Account (By) credit manage current balance
    			$this->Account->setBalanceAmountByAccountId($implantPurchaseId,$patientData['sharing_amount'],'debit');
    			$this->Account->setBalanceAmountByUserId($mlId,$patientData['sharing_amount'],'credit');
    		}
    		//EOF JV
    		
    		//BOF for receipt voucher againest payment voucher
    		$narration='';
    		//$narration = "Being cash paid for implant purchase against patient $patientName on $date";
    		$voucherLogDataPay=$rvData = array(
    				'date'=>$date,
    				'modified_by'=>$this->Session->read('userid'),
    				'create_by'=>$this->Session->read('userid'),
    				'account_id'=>$requestData['VoucherPayment']['account_id'],
    				'patient_id'=>$patientData['patient_id'],
    				'type'=>'SpotBacking',
    				'user_id'=>$requestData['VoucherPayment']['user_id'],
    				'narration'=>$narration,
    				'paid_amount'=>$patientData['sharing_amount']);
    		if(!empty($rvData['paid_amount']) && ($rvData['paid_amount'] != 0)){
    			$lastVoucherId=$this->AccountReceipt->insertReceiptEntry($rvData);
    			// ***insert into Account (By) credit manage current balance
    			$this->Account->setBalanceAmountByAccountId($requestData['VoucherPayment']['user_id'],$patientData['sharing_amount'],'debit');
    			$this->Account->setBalanceAmountByUserId($requestData['VoucherPayment']['account_id'],$patientData['sharing_amount'],'credit');
    			//insert into voucher_logs table added by PankajM
    			$voucherLogDataPay['voucher_no']=$lastVoucherId;
    			$voucherLogDataPay['voucher_id']=$lastVoucherId;
    			$voucherLogDataPay['voucher_type']="Receipt";
    			$this->VoucherLog->insertVoucherLog($voucherLogDataPay);
    			$this->VoucherLog->id= '';
    			$this->AccountReceipt->id= '';
    		}
    		//EOF
    		return true;
    	}//EOF sAmount
    }
    
    public function referralSharingReport(){
    	$this->layout = 'advance';
    	$this->uses = array('Patient','Consultant','SpotApproval');
   
    	if(empty($this->request->data)){
    		$date = date('Y-m');
    	}else{
    		$year = $this->request->data['Spot']['year'];
    		$month = $this->request->data['Spot']['month'];
    		$date = date($year."-".$month);
    	}
	
    	//=================================================BOF for Spot Paid amount========================================// 
    	$this->SpotApproval->bindModel(array(
    			"belongsTo"=>array(
    					"Consultant"=>array("foreignKey"=>false,'type'=>'INNER','conditions'=>array('SpotApproval.consultant_id=Consultant.id')))
    	));
    	$spotPaidSum = $this->SpotApproval->find('all',array('fields'=>array('SUM(SpotApproval.amount) as total_spot_paid','Consultant.id','Consultant.market_team'),
    			'conditions'=>array('SpotApproval.is_deleted'=>'0','SpotApproval.type'=>'S','DATE_FORMAT(SpotApproval.create_time,"%Y-%m")'=>$date),
    			'group'=>array('SpotApproval.consultant_id')));
    	$finalSpotArr = array();
    	foreach ($spotPaidSum as $key=> $spotSum){
    		$finalSpotArr[$spotSum['Consultant']['market_team']]['s_paid'] = $finalSpotArr[$spotSum['Consultant']['market_team']]['s_paid'] + $spotSum['0']['total_spot_paid'];
    	}
    	
    	//=================================================EOF for Spot Paid amount=========================================//
    	
    	//=================================================BOF for Backing Paid amount======================================//
    	$this->SpotApproval->bindModel(array(
    			"belongsTo"=>array(
    					"Consultant"=>array("foreignKey"=>false,'type'=>'INNER','conditions'=>array('SpotApproval.consultant_id=Consultant.id')))
    	));
    	$backingPaidSum = $this->SpotApproval->find('all',array('fields'=>array('SUM(SpotApproval.amount) as total_backing_paid','Consultant.id','Consultant.market_team'),
    			'conditions'=>array('SpotApproval.is_deleted'=>'0','SpotApproval.type'=>'B','DATE_FORMAT(SpotApproval.create_time,"%Y-%m")'=>$date),
    			'group'=>array('SpotApproval.consultant_id')));
    	
    	foreach ($backingPaidSum as $key=> $backingSum){
    		$finalSpotArr[$backingSum['Consultant']['market_team']]['b_paid'] = $finalSpotArr[$backingSum['Consultant']['market_team']]['b_paid'] + $backingSum['0']['total_backing_paid'];
    	}
    	
    	//=================================================EOF for Backing Paid amount======================================//
    	$this->Patient->bindModel(array(
    			"belongsTo"=>array(
    					"Billing"=>array("foreignKey"=>false,'type'=>'LEFT','conditions'=>array('Billing.patient_id=Patient.id')))
    	));
    	
    	$patientDetails=$this->Patient->find('all',array('fields'=>array('Patient.id','Patient.consultant_id',
    			'SUM(amount) as total_amount','SUM(paid_to_patient) as total_refund'),
    			'conditions'=>array('Patient.admission_type'=>'IPD','Patient.is_deleted'=>'0','Patient.consultant_id NOT'=>null,
    					'AND'=>array('DATE_FORMAT(Patient.form_received_on,"%Y-%m")'=>$date)),
    			'group'=>array('Patient.id')));
    	
    	$counsultantData = $this->Consultant->find('list',array('fields'=>array('Consultant.id','Consultant.market_team'),
    			'conditions'=>array('Consultant.market_team NOT'=>'','Consultant.is_deleted'=>'0')));
    	 
    	foreach ($patientDetails as $key=> $data){
    		$returnArr[$key] = $data;
    		$consultantIds = unserialize($data['Patient']['consultant_id']);
    		foreach ($consultantIds as $subKey => $val){ 
    			if($val !== "None"){
	    			$spotAmount = $this->Consultant->getReferralSpotBackingAmount($data['Patient']['id'],$val);
	    			$teamCount = count($consultantIds);  
	    			$finalSpotArr[$counsultantData[$val]]['s_payable'] = $finalSpotArr[$counsultantData[$val]]['s_payable'] + round($spotAmount['sAmount']);
	    			$finalSpotArr[$counsultantData[$val]]['b_payable'] = $finalSpotArr[$counsultantData[$val]]['b_payable'] + round($spotAmount['profitBillData']);
	    			$finalSpotArr[$counsultantData[$val]]['collection_amount'] = $finalSpotArr[$counsultantData[$val]]['collection_amount'] + round(($returnArr[$key]['0']['total_amount']-$returnArr[$key]['0']['total_refund'])/$teamCount);
    			}
    		}
    	}
    	 
    	$this->set(compact('date'));
    	$this->set('spotData',$finalSpotArr);
    }
    
    public function referralConsultantReport($date,$team){
    	$this->layout = 'advance_ajax';
    	$this->uses = array('Patient','Consultant','SpotApproval');
   
    	$date = str_replace(',', '/', $date);
    	//=================================================BOF for Spot Paid amount========================================//
    	$this->SpotApproval->bindModel(array(
    			"belongsTo"=>array(
    					"Consultant"=>array("foreignKey"=>false,'type'=>'INNER','conditions'=>array('SpotApproval.consultant_id=Consultant.id')),
    					"MarketingTeam"=>array("foreignKey"=>false,'type'=>'INNER','conditions'=>array('Consultant.market_team=MarketingTeam.name')))
    	));
    	$spotPaidSum = $this->SpotApproval->find('all',array('fields'=>array('SUM(SpotApproval.amount) as total_spot_paid','Consultant.id',
    				'Consultant.market_team','Consultant.first_name','Consultant.last_name'),
    			'conditions'=>array('SpotApproval.is_deleted'=>'0','SpotApproval.type'=>'S','DATE_FORMAT(SpotApproval.create_time,"%Y-%m")'=>$date,
    					'MarketingTeam.name'=>$team),
    			'group'=>array('SpotApproval.consultant_id')));
    	
    	$finalSpotArr = array();
    	foreach ($spotPaidSum as $key=> $spotSum){
    		$finalSpotArr[$spotSum['Consultant']['first_name']." ".$spotSum['Consultant']['last_name']]['s_paid'] = $finalSpotArr[$spotSum['Consultant']['first_name']." ".$spotSum['Consultant']['last_name']]['s_paid'] + $spotSum['0']['total_spot_paid'];
    		$finalSpotArr[$spotSum['Consultant']['first_name']." ".$spotSum['Consultant']['last_name']]['consultant_id'] = $spotSum['Consultant']['id'];
    	}
    	//=================================================EOF for Spot Paid amount=========================================//
    	 
    	//=================================================BOF for Backing Paid amount======================================//
    	$this->SpotApproval->bindModel(array(
    			"belongsTo"=>array(
    					"Consultant"=>array("foreignKey"=>false,'type'=>'INNER','conditions'=>array('SpotApproval.consultant_id=Consultant.id')),
    					"MarketingTeam"=>array("foreignKey"=>false,'type'=>'INNER','conditions'=>array('Consultant.market_team=MarketingTeam.name')))
    	));
    	$backingPaidSum = $this->SpotApproval->find('all',array('fields'=>array('SUM(SpotApproval.amount) as total_backing_paid','Consultant.id',
    				'Consultant.market_team','Consultant.first_name','Consultant.last_name'),
    			'conditions'=>array('SpotApproval.is_deleted'=>'0','SpotApproval.type'=>'B','DATE_FORMAT(SpotApproval.create_time,"%Y-%m")'=>$date,
    					'MarketingTeam.name'=>$team),
    			'group'=>array('SpotApproval.consultant_id')));
    	 
    	foreach ($backingPaidSum as $key=> $backingSum){
    		$finalSpotArr[$backingSum['Consultant']['first_name']." ".$backingSum['Consultant']['last_name']]['b_paid'] = $finalSpotArr[$backingSum['Consultant']['first_name']." ".$backingSum['Consultant']['last_name']]['b_paid'] + $backingSum['0']['total_backing_paid'];
    		$finalSpotArr[$backingSum['Consultant']['first_name']." ".$backingSum['Consultant']['last_name']]['consultant_id'] = $backingSum['Consultant']['id'];
    	}
    	//=================================================EOF for Backing Paid amount======================================//
    	$patientDetails=$this->Patient->find('all',array('fields'=>array('Patient.id','Patient.consultant_id'),
    			'conditions'=>array('Patient.admission_type'=>'IPD','Patient.is_deleted'=>'0','Patient.consultant_id NOT'=>null,
    					'AND'=>array('DATE_FORMAT(Patient.form_received_on,"%Y-%m")'=>$date))));
    	 
    	$counsultantData = $this->Consultant->find('list',array('fields'=>array('Consultant.id','Consultant.full_name'),
    			'conditions'=>array('Consultant.market_team'=>$team,'Consultant.is_deleted'=>'0')));
    	 
    	foreach ($patientDetails as $key=> $data){
    		$consultantIds = unserialize($data['Patient']['consultant_id']);  
    		foreach ($consultantIds as $subKey => $val){  
    			if($val != "None" && array_key_exists($val, $counsultantData)==true){
	    			$spotAmount = $this->Consultant->getReferralSpotBackingAmount($data['Patient']['id'],$val);
	    			$finalSpotArr[$counsultantData[$val]]['s_payable'] = $finalSpotArr[$counsultantData[$val]]['s_payable'] + round($spotAmount['sAmount']);
	    			$finalSpotArr[$counsultantData[$val]]['b_payable'] = $finalSpotArr[$counsultantData[$val]]['b_payable'] + round($spotAmount['profitBillData']);
	    			$finalSpotArr[$counsultantData[$val]]['consultant_id'] = $val;
    			}
    		}
    	}
    	$this->set(compact('team','date'));
    	$this->set('consultantData',$finalSpotArr);
    }
    
    function referralPatientReport($date,$consultantId,$consulName){
    	$this->layout = 'advance_ajax';
    	$this->uses=array('SpotApproval','Consultant','Patient','Billing');
    
    	//=================================================BOF for Spot Paid amount========================================//
    	$this->SpotApproval->bindModel(array(
    			"belongsTo"=>array(
    					"Patient"=>array("foreignKey"=>false,'type'=>'INNER','conditions'=>array('Patient.id=SpotApproval.patient_id')),
    					"TariffStandard"=>array("foreignKey"=>false,'type'=>'INNER','conditions'=>array('Patient.tariff_standard_id=TariffStandard.id')))
    	));
    	$spotPaidSum = $this->SpotApproval->find('all',array('fields'=>array('SUM(SpotApproval.amount) as total_spot_paid','Patient.lookup_name','Patient.id','TariffStandard.name'),
    			'conditions'=>array('SpotApproval.is_deleted'=>'0','SpotApproval.type'=>'S','DATE_FORMAT(SpotApproval.create_time,"%Y-%m")'=>$date,
    					'SpotApproval.consultant_id'=>$consultantId),
    			'group'=>array('SpotApproval.patient_id')));
    	 
    	$finalSpotArr = array();
    	foreach ($spotPaidSum as $key=> $spotSum){
    		$finalSpotArr[$spotSum['Patient']['lookup_name']]['s_paid'] = $finalSpotArr[$spotSum['Patient']['lookup_name']]['s_paid'] + $spotSum['0']['total_spot_paid'];
    		$finalSpotArr[$spotSum['Patient']['lookup_name']]['tariff_type'] = $spotSum['TariffStandard']['name'];
    	}
    	//=================================================EOF for Spot Paid amount=========================================//
    	 
    	//=================================================BOF for Backing Paid amount======================================//
    	$this->SpotApproval->bindModel(array(
    			"belongsTo"=>array(
    					"Patient"=>array("foreignKey"=>false,'type'=>'INNER','conditions'=>array('Patient.id=SpotApproval.patient_id')),
    					"TariffStandard"=>array("foreignKey"=>false,'type'=>'INNER','conditions'=>array('Patient.tariff_standard_id=TariffStandard.id')))
    	));
    	$backingPaidSum = $this->SpotApproval->find('all',array('fields'=>array('SUM(SpotApproval.amount) as total_backing_paid','Patient.lookup_name','Patient.id','TariffStandard.name'),
    			'conditions'=>array('SpotApproval.is_deleted'=>'0','SpotApproval.type'=>'B','DATE_FORMAT(SpotApproval.create_time,"%Y-%m")'=>$date,
    					'SpotApproval.consultant_id'=>$consultantId),
    			'group'=>array('SpotApproval.patient_id')));
    	 
    	foreach ($backingPaidSum as $key=> $backingSum){
    		$finalSpotArr[$backingSum['Patient']['lookup_name']]['b_paid'] = $finalSpotArr[$backingSum['Patient']['lookup_name']]['b_paid'] + $backingSum['0']['total_backing_paid'];
    		$finalSpotArr[$backingSum['Patient']['lookup_name']]['tariff_type'] = $backingSum['TariffStandard']['name'];
    	}
    	//=================================================EOF for Backing Paid amount======================================//
    	$this->Patient->bindModel(array(
    			"belongsTo"=>array(
    					"TariffStandard"=>array("foreignKey"=>false,'type'=>'INNER','conditions'=>array('Patient.tariff_standard_id=TariffStandard.id')))
    	));
    	$patientData=$this->Patient->find('all',array('fields'=>array('Patient.id','Patient.lookup_name','Patient.consultant_id','TariffStandard.name'),
    			'conditions'=>array('Patient.consultant_id NOT'=>null,'Patient.admission_type'=>'IPD','Patient.is_deleted'=>'0',
    					'AND'=>array('DATE_FORMAT(Patient.form_received_on,"%Y-%m")'=>$date))));
  
    	foreach ($patientData as $key=> $data){
    		$consultantArray = unserialize($data['Patient']['consultant_id']);
    		if(!in_array($consultantId,$consultantArray)) continue;
    		$spotAmount = $this->Consultant->getReferralSpotBackingAmount($data['Patient']['id'],$consultantId); 
    		$finalSpotArr[$data['Patient']['lookup_name']]['s_payable'] = $finalSpotArr[$data['Patient']['lookup_name']]['s_payable'] + round($spotAmount['sAmount']);
    		$finalSpotArr[$data['Patient']['lookup_name']]['b_payable'] = $finalSpotArr[$data['Patient']['lookup_name']]['b_payable'] + round($spotAmount['profitBillData']);
    		$finalSpotArr[$data['Patient']['lookup_name']]['tariff_type'] = $data['TariffStandard']['name'];
    		/* if($data['TariffStandard']['name'] == Configure::read('RGJAY')){
    			$billingDetails=$this->Billing->find('first',array('fields'=>array('Billing.patient_id','SUM(Billing.amount) as total_amount','SUM(Billing.paid_to_patient) as total_refund'),
    					'conditions'=>array('Billing.is_deleted'=>'0','Billing.location_id'=>$this->Session->read('locationid'),'Billing.patient_id'=>$data['Patient']['id']),
    					'group'=>array('Billing.patient_id')));
    		}
    		debug($billingDetails); 
    		$finalSpotArr[$data['Patient']['lookup_name']]['rgjay_amount'] = $billingDetails['0']['total_amount']-$billingDetails['0']['total_refund'];
    		*/
    	}
    	$this->set(compact('consulName','date','consultantId'));
    	$this->set('patientData',$finalSpotArr);
    }
    

    /**
     * function to update narration for all vouchers
     * @author Amit Jain
     */
    public function editNarration(){
    	$this->autoRender = false;
    	$this->Layout = 'ajax';
    	$this->uses = array('Account');
    	$result = $this->Account->updateNarration($this->params->query['id'],$this->params->query['voucherType'],$this->params->query['modelName'],$this->params->query['narration']);
    	return $result;
    }
    
    /**
     * function to set Is Posted 1 and 0
     * @author Amit Jain
     */
    function printReferralPatientReport(){
    	$this->uses=array('SpotApproval');
    	$date = $this->params->query['date'];
    	$consultantId = $this->params->query['consultant_id'];
    	$consulName = $this->params->query['consultant_name'];
    	$this->referralPatientReport($date,$consultantId,$consulName);
    	$this->layout = false;
    }

    /**
     * @author Amit Jain
     */
    function printReferralConsultantReport(){
    	$this->uses=array('SpotApproval');
    	$date = $this->params->query['date'];
    	$team = $this->params->query['team'];
    	$this->referralConsultantReport($date,$team);
    	$this->layout = false;
    }
    
    /**
     * function for to give one doctors duty amount to other if he/she not present
     * @author Atul Chandankhede
     */
    
    function hrPayment(){
    	$this->layout='advance';
    	$this->uses=array('Account','VoucherPayment','VoucherLog','VoucherEntry');
    	$requestData=$this->request->data['VoucherPayment'];
    	
    	if(!empty($requestData)){
    	$date=$this->DateFormat->formatDate2STD($requestData['date'],Configure::read('date_format'));
    	$voucherLogData=$pvData = array('date'=>$date,
    			'create_by'=>$this->Session->read('userid'),
    			'modified_by'=>$this->Session->read('userid'),
    			'account_id'=>$requestData['account_id'], // cash id in account table
    			'location_id'=>$this->Session->read('locationid'),
    			'user_id'=>$requestData['pay_user_id'], //user id in account table
    			'type'=>'HrPayment',
    			'narration'=>$requestData['narration'],
    			'paid_amount'=>$requestData['paid_amount']);
    
    	if(!empty($pvData['paid_amount']) && ($pvData['paid_amount'] != 0)){
    		$lastId=$this->VoucherPayment->insertPaymentEntry($pvData);
    		$voucherLogData['voucher_no']=$lastId;
    		$voucherLogData['voucher_id']=$lastId;
    		$voucherLogData['voucher_type']="Payment";
    		$this->VoucherLog->insertVoucherLog($voucherLogData);
    		$this->VoucherLog->id= '';
    		$this->VoucherPayment->id= '';
    			
    		// ***insert into Account (By) credit manage current balance
    		$this->Account->setBalanceAmountByAccountId($requestData['account_id'],$requestData['paid_amount'],'debit');
    		$this->Account->setBalanceAmountByUserId($requestData['pay_user_id'],$requestData['paid_amount'],'credit');
    		$this->Account->id = '';
    	}
    
    	$debitAmnt=$requestData['debit_amount'];
    	$debitUserName=$requestData['debit_user_name'];
    	$creditUserName=$requestData['pay_user_name'];
    	$narrationDetails = "Debit Rs.$debitAmnt from $debitUserName for $creditUserName " ;
    
    	$voucherLogDataJv = $jvData = array('date'=>$date,
    			'create_by'=>$this->Session->read('userid'),
    			'modified_by'=>$this->Session->read('userid'),
    			'location_id'=>$this->Session->read('locationid'),
    			'user_id'=>$requestData['pay_user_id'], //id of whom we give payment
    			'account_id'=>$requestData['debit_user_id'], // id of debited user
    			'type'=>'HrPayment',
    			'narration'=>$narrationDetails,
    			'debit_amount'=>$requestData['debit_amount']);
    	if(!empty($jvData['debit_amount']) && ($jvData['debit_amount'] != 0)){
    		$lastVoucher = $this->VoucherEntry->insertJournalEntry($jvData);
    		$voucherLogDataJv['voucher_no']=$lastVoucher;
    		$voucherLogDataJv['voucher_id']=$lastVoucher;
    		$voucherLogDataJv['voucher_type']="Journal";
    		$this->VoucherLog->insertVoucherLog($voucherLogDataJv);
    		$this->VoucherLog->id= '';
    		// ***insert into Account (By) credit manage current balance
    		$this->Account->setBalanceAmountByAccountId($requestData['debit_user_id'],$requestData['debit_amount'],'debit');
    		$this->Account->setBalanceAmountByUserId($requestData['pay_user_id'],$requestData['debit_amount'],'credit');
    	}
    	
    	if($lastId){
    		$this->Session->setFlash(__('Record saved successfully!'),'default',array('class'=>'message'));
    	}else{
    		$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
    	}
    	$this->set(array('lastInsertID'=>$lastId,'action'=>'print'));
    }
  }
  
  /**
   * function for Trail Balance
   * @author  Amit Jain
   */
  public function trialBalanceNew(){
  	ob_end_clean();
  	ob_start("ob_gzhandler");
  	$this->layout = 'advance';
  	$this->uses=array('Account','VoucherEntry','VoucherPayment','ContraEntry','AccountReceipt','AccountingGroup','Location');
  		
  	$locationId = $this->Session->read('locationid');
  		
  	if(!empty($this->request->data['Voucher']['from'])){
  		$fromDate = $this->DateFormat->formatDate2STDForReport($this->request->data['Voucher']['from'],Configure::read('date_format'))." 00:00:00";
  		$from = $this->request->data['Voucher']['from'];
  	}else{
  		$fromDate = date('Y-m-d').' 00:00:00';
  		$from = date('d/m/Y');
  	}if(!empty($this->request->data['Voucher']['to'])){
  		$toDate = $this->DateFormat->formatDate2STDForReport($this->request->data['Voucher']['to'],Configure::read('date_format'))." 23:59:59";
  		$to=$this->request->data['Voucher']['to'];
  	}else{
  		$toDate = date('Y-m-d H:i:s');
  		$to=date('d/m/Y');
  	}
  		
  	if(!empty($this->request->data)){
  		if($this->request->data['Voucher']['location_id'] == ''){
  			$locationId = 'All';
  		}else{
  			$locationId = $this->request->data['Voucher']['location_id'];
  		}
  	}
  		
  	$receiptArray = $this->AccountReceipt->getReceiptData($fromDate,$toDate,$locationId);
  	$paymentArray = $this->VoucherPayment->getPaymentData($fromDate,$toDate,$locationId);
  	$contraArray = $this->ContraEntry->getContraData($fromDate,$toDate,$locationId);
  	$journalArray = $this->VoucherEntry->getJournalData($fromDate,$toDate,$locationId);
  	$openingBal = $this->Account->getOpeningBalanceData($locationId);
  	
  	$allCombDebitArray = array_merge($receiptArray['0'],$paymentArray['0'],$contraArray['0'],$journalArray['0'],$receiptArray['1'],$paymentArray['1'],$contraArray['1'],$journalArray['1'],$openingBal['0'],$openingBal['1']);
  		
  	$finalArray = array();
  	foreach ($allCombDebitArray as $key=> $data){
  		$finalArray[$data['Account']['accounting_group_id']][$data['Account']['id']] += ((round($data['0']['receiptSumDebit'])+round($data['0']['paymentSumDebit'])+round($data['0']['contraSumDebit'])+round($data['0']['journalSumDebit'])+round($data['Account']['dr_opening_balance']))-(round($data['0']['receiptSumCredit'])+round($data['0']['paymentSumCredit'])+round($data['0']['contraSumCredit'])+round($data['0']['journalSumCredit'])+round($data['Account']['cr_opening_balance'])));
  	}
  
  	foreach($finalArray as $key => $val){
  		foreach($val as $subKey => $mval){
  			if($mval >= 0){
  				$returnArr[$key]['debit'] += $mval;
  			}else{
  				$returnArr[$key]['credit'] += $mval;
  			}
  		}
  	}
  
  	$groupList = $this->AccountingGroup->getAllGroup();
  	foreach ($groupList as $key => $value){
  		$returnArray[$key] = array(
  				'name'=>$value,
  				'debit'=>abs($returnArr[$key]['debit']),
  				'credit'=>abs($returnArr[$key]['credit'])
  		);
  	}
  	$this->set(array('groupData'=>$returnArray));
  		
  	if($this->Session->read('location_created_by') == '0'){
  		$this->set('locations',$this->Location->getLocationIdByHospital());
  	}
  	$this->set(compact('from','to','locationId'));
  }
  
  /**
   *  Function to show Trial Balance for duration
   * @author Amit Jain
   */
  public function getLedgerGroupWise(){
  	ob_end_clean();
  	ob_start("ob_gzhandler");
  	$this->layout = 'advance_ajax';
  	$this->uses=array('VoucherEntry','VoucherPayment','ContraEntry','AccountReceipt','Account','Patient');
 Configure::write('debug',2); 	
  	$groupId = $this->request->data['GroupId'];
  	$locationId = $this->request->data['locationId'];
  	$fromDate = $this->DateFormat->formatDate2STDForReport($this->request->data['from'],Configure::read('date_format'))." 00:00:00";
  	$toDate = $this->DateFormat->formatDate2STDForReport($this->request->data['to'],Configure::read('date_format'))." 23:59:59";
  	$from = $this->request->data['from'];
  	$to = $this->request->data['to'];
  		
  	$receiptArray = $this->AccountReceipt->getReceiptData($fromDate,$toDate,$locationId,$groupId);//
  	$paymentArray = $this->VoucherPayment->getPaymentData($fromDate,$toDate,$locationId,$groupId);
  	$contraArray = $this->ContraEntry->getContraData($fromDate,$toDate,$locationId,$groupId);
  	$journalArray = $this->VoucherEntry->getJournalData($fromDate,$toDate,$locationId,$groupId);
  	$openingBal = $this->Account->getOpeningBalanceData($locationId,$groupId);
  		
  	$allCombDebitArray = array_merge($receiptArray['0'],$paymentArray['0'],$contraArray['0'],$journalArray['0'],$receiptArray['1'],$paymentArray['1'],$contraArray['1'],$journalArray['1'],$openingBal['0'],$openingBal['1']);
  		
  	$finalArray = array();
	//echo "<pre>";
	//print_r($allCombDebitArray);
	$patientdata="";
  	foreach ($allCombDebitArray as $key=> $data){
		//temparory fetch data for patient for audit purpose- Pankaj M
	   if($data['Account']['user_type']=='Patient')
	   {
	       $patientdata.=$data['Account']['system_user_id'].",";
	   }
  		$finalArray[$data['Account']['id']]['name'] = $data['Account']['name'];//Patient //system_user_id
  		$finalArray[$data['Account']['id']]['amount']+= ((round($data['0']['receiptSumDebit'])+round($data['0']['paymentSumDebit'])+round($data['0']['contraSumDebit'])+round($data['0']['journalSumDebit'])+round($data['Account']['dr_opening_balance']))-(round($data['0']['receiptSumCredit'])+round($data['0']['paymentSumCredit'])+round($data['0']['contraSumCredit'])+round($data['0']['journalSumCredit'])+round($data['Account']['cr_opening_balance'])));
  	}
	$this->Patient->bindModel(array(
						'belongsTo'=>array(
							'TariffStandard'=>array('type'=>'INNER','foreignKey'=>false,'Conditions'=>array('TariffStandard.id=Patient.tariff_standard_id'))),
	));
//echo $patientdata;
 // $ptdata=$this->Patient->find("all",array('fields'=>array('TariffStandard.id','TariffStandard.name'),'Conditions'=>array('Patient.person_id'=> $patientdata)));
  //debug($ptdata);
  //exit;
  	$this->set(compact('locationId','from','to'));
  	$this->set('ledgerData',$finalArray);
  	$this->render('ajax_ledger_wise_data',false);
  }
  
  /**
   * Function to get Consultant Outstanding Statement report
   * @author Amit Jain
   */
  public function consultantOutstandingStatement(){
  	$this->layout = 'advance';
  	$this->uses=array('User','VoucherEntry','VoucherPayment','ContraEntry','AccountReceipt','Account');
  	
  	if(!empty($this->request->data)){
  		$doctorList = $this->User->getDoctorsByLocation();
  		$accountList = $this->Account->getAccountList('User',$doctorList);
  		$formYear = $this->request->data['Voucher']['fromYear'];
  		$formMonth = $this->request->data['Voucher']['fromMonth'];
  		$toYear = $this->request->data['Voucher']['toYear'];
  		$toMonth = $this->request->data['Voucher']['toMonth'];
 
		$lastDate = date('t',strtotime(date("$toYear-$toMonth-d")));
		$date = array(date("$formYear-$formMonth-01 00:00:00"),date("$toYear-$toMonth-$lastDate 23:59:59"));
		$startDate = $date[0];
		$endDate = $date[1];
		
		$monthList = $this->getMonthsInRange(date("$formYear-$formMonth-01"),date("$toYear-$toMonth-$lastDate"));
		
		foreach($monthList as $monthKey => $val){
			if(empty($start) && empty($end)){
				$start = date('1970-m-d');
			}else{
				//$start = date("Y-".$val['month']."-01",strtotime($end));
				$start = date($val['year']."-".$val['month']."-01",strtotime($end));
			} 
			$lastDate = date("t",strtotime(date($val['year']."-".$val['month']."-d")));
			$end = date($val['year']."-".$val['month']."-".$lastDate);
			$journalArray[$val['month']] = $this->VoucherEntry->getUserWiseData($start,$end,$accountList);
			$paymentArray[$val['month']] = $this->VoucherPayment->getUserWiseData($start,$end,$accountList);
		}
  		
  		//debug($journalArray);
  		//debug($paymentArray);
  		exit;
  		$returnArray = $userList = array(); 
  		foreach ($accountList as $userId=> $value){
  			foreach($monthList as $monthKey => $val){
  				$resultValue = ($journalArray['voucherDebit'][$userId][$val['year']][$val['month']]['debit'] + 
  					$paymentArray['paymentDebit'][$userId][$val['year']][$val['month']]['debit']) - $journalArray['voucherCredit'][$userId][$val['year']][$val['month']]['credit'];
  				if(!empty($resultValue)){
  					//to fetch only non-empty records
  					$returnArr[$userId][$val['year']][$val['month']] = $resultValue;
  					$userList[$userId] = $value;
  				}
  			} 
  		} 
  		$this->set(compact(array('monthList','accountList','userList')));
   		$this->set('data',$returnArr);
  	}
  	
  }
  
  function getMonthsInRange($startDate, $endDate) {
  	$months = array();
  	while (strtotime($startDate) <= strtotime($endDate)) {
  		$months[] = array('year' => date('Y', strtotime($startDate)), 'month' => date('m', strtotime($startDate)), );
  		$startDate = date('d M Y', strtotime($startDate.
  				'+ 1 month'));
  	}
  
  	return $months;
  }
  
  /*
   * function autocomplete of employee id 
   * @author : Swapnil
   * @created : 02.04.2016
   */
  public function employeeAutocomplete(){
      $this->autoRender = false; 
      $term = $this->params->query['term']."%" ;
      $this->loadModel('Account');
      $result = $this->Account->find('all',array('fields'=>array('Account.id', 'Account.name', 'Account.emp_id'),'conditions'=>array('Account.is_deleted'=>'0','Account.emp_id LIKE'=>$term)));
      foreach($result as $key =>$val){
          $returnArr[] = array('id'=>$val['Account']['id'],'name'=>$val['Account']['name'],'value'=>$val['Account']['emp_id']."-".$val['Account']['name']);
      }
      echo json_encode($returnArr);
      exit;
  }
  
  /*
   * function to get Report patient wise spot and backing calculations and reffer doctors
  * @author : Amit Jain
  * @created : 14.05.2016
  */
  public function patientSpotBacking($date){
  	$this->uses = array('SpotApproval','Billing');
	  	if(empty($this->request->data)){
	  		$date = date('Y-m');
	  	}else{
	  		$year = $this->request->data['Spot']['year'];
	  		$month = $this->request->data['Spot']['month'];
	  		$date = date($year."-".$month);
	  	}
  	
  		$this->SpotApproval->bindModel(array(
    			"belongsTo"=>array(
    					"Patient"=>array("foreignKey"=>false,'type'=>'INNER',
    							'conditions'=>array('Patient.id=SpotApproval.patient_id')),
    					"Consultant"=>array("foreignKey"=>false,'type'=>'INNER',
    							'conditions'=>array('Consultant.id=SpotApproval.consultant_id')))
    	));
    	$getPtRefferalData = $this->SpotApproval->find('all',array('fields'=>array('SpotApproval.amount','SpotApproval.type','SpotApproval.consultant_id',
    			'Patient.id','Patient.lookup_name','CONCAT(Consultant.first_name," ",Consultant.last_name) as fullname'),
    			'conditions'=>array('SpotApproval.is_deleted'=>'0','DATE_FORMAT(SpotApproval.create_time,"%Y-%m")'=>$date)));
    
    	$cusArray = array();
    	foreach($getPtRefferalData as $key=>$data){
    		$cusArray[$data['Patient']['id']]['name'] = $data['Patient']['lookup_name'];
    		$cusArray[$data['Patient']['id']]['referral'][$data['SpotApproval']['consultant_id']]['referral_name'] = $data['0']['fullname'];
    		if($data['SpotApproval']['type'] == "S"){
    			$cusArray[$data['Patient']['id']]['referral'][$data['SpotApproval']['consultant_id']]['spot_amount'] += $data['SpotApproval']['amount'];
    		}
    		if($data['SpotApproval']['type'] == "B"){
    			$cusArray[$data['Patient']['id']]['referral'][$data['SpotApproval']['consultant_id']]['backing_amount'] += $data['SpotApproval']['amount'];
    		}
    	}
   
    	$finalArray=array();
    	foreach ($cusArray as $patientId=>$patientData){
    		$finalArray[$patientId] = $patientData;
    		$finalArray[$patientId]['paid_amount'] = $this->Billing->getPatientPaidAmount($patientId);
    	}
    	$this->set('finalData',$finalArray);
  }
  
  public function editJournalEntry($batchIdentifier = null){
  	$this->layout = 'advance';
  	$this->uses = array('VoucherEntry');
  		if(!empty($batchIdentifier)){
	  		$this->VoucherEntry->bindModel(array(
	  				"belongsTo"=>array(
	  						"Account"=>array("foreignKey"=>false ,
	  								'conditions'=>array('Account.id=VoucherEntry.account_id')),
	  						"AccountAlias"=>array('className'=>'Account',"foreignKey"=>false,
	  								'conditions'=>array('AccountAlias.id=VoucherEntry.user_id'))),
	  		));
	  		$dataDetail = $this->VoucherEntry->find('all',array('fields'=>array('VoucherEntry.id','VoucherEntry.date','VoucherEntry.account_id',
	  				'VoucherEntry.debit_amount','VoucherEntry.user_id','VoucherEntry.narration','VoucherEntry.batch_identifier',
	  				'VoucherEntry.journal_voucher_no','Account.name','Account.balance','AccountAlias.name','AccountAlias.balance'),
	  				'conditions'=>array('VoucherEntry.is_deleted'=>0,'VoucherEntry.batch_identifier'=>$batchIdentifier)));
	  
	  		$customData = array();
	  		$serviceData = array();
	  		foreach ($dataDetail as $key=> $data){
	  			$customData['AccountAlias']['name'] = $data['Account']['name'];
	  			$customData['VoucherEntry']['account_id'] = $data['VoucherEntry']['account_id'];
	  			$customData['VoucherEntry']['date'] = $this->DateFormat->formatDate2Local($data['VoucherEntry']['date'],Configure::read('date_format'),true);
	  			$customData['VoucherEntry']['debit_amount'] += $data['VoucherEntry']['debit_amount'];
	  			$customData['VoucherEntry']['narration'] = $data['VoucherEntry']['narration'];
	  			$customData['VoucherEntry']['journal_voucher_no'] = $data['VoucherEntry']['journal_voucher_no'];
	  			$customData['VoucherEntry']['batch_identifier'] = $data['VoucherEntry']['batch_identifier'];
	  			if($data['Account']['balance'] < 0 ){
	  				$customData['AccountAlias']['balance']=$this->Number->currency(ceil($data['Account']['balance']))." Cr";
	  			}else{
	  				$customData['AccountAlias']['balance']=$this->Number->currency(ceil($data['Account']['balance']))." Dr";
	  			}
	  			$serviceData[$key] = $data;
	  			if($data['AccountAlias']['balance'] < 0 ){
	  				$serviceData[$key]['AccountAlias']['balance']=$this->Number->currency(ceil($data['AccountAlias']['balance']*(-1)))." Cr";
	  			}else{
	  				$serviceData[$key]['AccountAlias']['balance']=$this->Number->currency(ceil($data['AccountAlias']['balance']))." Dr";
	  			}
	  		}

	  		$type = "editJv";
	  		$this->data = $customData;
	  		$this->set('dataDetail',$serviceData);
	  		$this->set(compact('type'));
	  		$this->render('journal_entry');
  		}
  	}
  	
  	function printPettyCashBook(){
  		$this->uses = array('VoucherPayment','ContraEntry','Account','AccountReceipt');
  		$this->request->data['Voucher'] = $this->params->query;
  		$this->pettyCashBook();
  		$this->layout=false;
  	}

  	function teamWiseCollectionReport(){
  		$this->layout = 'advance';
    	$this->uses = array('Patient','Consultant','SpotApproval');
   
    	if(empty($this->request->data)){
    		$date = date('Y-m');
    	}else{
    		$year = $this->request->data['SpotBacking']['year'];
    		$month = $this->request->data['SpotBacking']['month'];
    		$date = date($year."-".$month);
    	}
    	if(!empty($this->request->data)){
	    	$this->Patient->bindModel(array(
	    			"belongsTo"=>array(
	    					"SpotApproval"=>array("foreignKey"=>false,'type'=>'INNER',
	    						'conditions'=>array('SpotApproval.patient_id=Patient.id')),
	    					"Consultant"=>array("foreignKey"=>false,'type'=>'LEFT',
	    						'conditions'=>array('Consultant.id=SpotApproval.consultant_id'))),
	    			"hasMany"=>array(
								"Billing"=>array(
									'fields'=>array('amount','paid_to_patient'),
									"foreignKey"=>'patient_id',
									'conditions'=>array('Billing.is_deleted'=>'0'))
								)));
	    	
	    	$patientDetails=$this->Patient->find('all',array(
	    		'fields'=>array('Consultant.market_team'),
	    		'conditions'=>array('Patient.admission_type'=>'IPD','Patient.is_deleted'=>'0','Patient.consultant_id IS NOT NULL','DATE_FORMAT(Patient.discharge_date,"%Y-%m")'=>$date,'Patient.is_discharge'=>'1'),
	    		'group'=>array('SpotApproval.patient_id')));

			$finalArray = array();
	    	foreach ($patientDetails as $key => $value) {
	    		foreach ($value['Billing'] as $bkey => $billingData) {
	    			$finalArray[$value['Consultant']['market_team']] +=  $billingData['amount'] - $billingData['paid_to_patient'];
	    		}
	    	}
    	 }
    	$this->set(compact('date'));
    	$this->set('teamData',$finalArray);
  	}

  	function getTeamWisePatientData($date,$team){
  		$this->layout = 'advance_ajax';
    	$this->uses = array('Patient','Consultant','SpotApproval','Billing');
    	$date = str_replace(',', '/', $date);
    	
    	$this->Patient->bindModel(array(
	    			"belongsTo"=>array(
	    					"SpotApproval"=>array("foreignKey"=>false,'type'=>'INNER',
	    						'conditions'=>array('SpotApproval.patient_id=Patient.id')),
	    					"Consultant"=>array("foreignKey"=>false,'type'=>'LEFT',
	    						'conditions'=>array('Consultant.id=SpotApproval.consultant_id')),
	    					"MarketingTeam"=>array("foreignKey"=>false,'type'=>'INNER',
	    						'conditions'=>array('Consultant.market_team=MarketingTeam.name'))),
	    		));
	    	
	    	$patientDetails=$this->Patient->find('all',array(
	    		'fields'=>array('SpotApproval.patient_id'),
	    		'conditions'=>array('Patient.admission_type'=>'IPD','Patient.is_deleted'=>'0','Patient.consultant_id IS NOT NULL','DATE_FORMAT(Patient.discharge_date,"%Y-%m")'=>$date,'Patient.is_discharge'=>'1','MarketingTeam.name'=>$team),
	    		'group'=>array('SpotApproval.patient_id')));

	    	$patientList = array();
	    	foreach ($patientDetails as $key => $value) {
	    		$patientList[$value['SpotApproval']['patient_id']] = $value['SpotApproval']['patient_id'];
	    	}
			$this->Patient->bindModel(array(
	    			"belongsTo"=>array(
	    					"Billing"=>array("foreignKey"=>false,'type'=>'INNER',
	    						'conditions'=>array('Billing.patient_id=Patient.id')),
	    					"TariffStandard"=>array("foreignKey"=>false,'type'=>'INNER',
	    						'conditions'=>array('TariffStandard.id=Patient.tariff_standard_id'))),
	    		));
	    	$billingDetails=$this->Patient->find('all',array(
	    		'fields'=>array('Billing.patient_id','SUM(amount) as total_amount','SUM(paid_to_patient) as total_refund_amount','Patient.lookup_name','TariffStandard.name'),
	    		'conditions'=>array('Billing.patient_id'=>$patientList,'Billing.is_deleted'=>'0'),
	    		'group'=>array('Billing.patient_id')));
	    	
	    	$this->set('team',$team);
	    	$this->set('billingData',$billingDetails);
  	}

  	/*
   * function autocomplete of staff
   * @author : Atul Chandankhede
   * @created : 30.07.2016
   */
  public function staffAutocomplete(){
      $this->autoRender = false; 
      $term = "%".$this->params->query['q']."%" ;
      $this->loadModel('Account');
      $result = $this->Account->find('list',array('fields'=>array('Account.id', 'Account.name'),'conditions'=>array('Account.is_deleted'=>'0','Account.user_type'=>'User','Account.name LIKE'=>$term)));
      foreach($result as $key =>$val){
          echo ucwords(strtolower("$val   $key|$key\n"));
      }
     
      exit;
  }


  public function department_wise_revenue($type=null) {
		$this->uses=array('Department');
		$this->layout ='advance';
		$this->set('title_for_layout', __('Department Wise Revenue', true));
        //For visit type
		$departments=$this->Department->find('list',array('fields'=>array('id','name'),'order' => array('Department.name'),'conditions'=>array('Department.location_id'=>$this->Session->read('locationid'))));
		
		if($type == "excel") {
			$this->departmentRevenue($this->request->data);
			$this->render('department_wise_revenue_xls','');
		}else{
			$this->departmentRevenue($this->request->data);
	        $this->render('department_wise_revenue');
		}
	}


	/**
	 * daily cash collection query
	 *
	 */

        private function departmentRevenue($getData = null) {
            $this->uses = array('Billing', 'LaboratoryTestOrder', 'RadiologyTestOrder', 'PharmacySalesBill', 'TariffList', 'User');

            $this->layout = 'advance';
            if (empty($getData['billtype'])) {
                $getData['billtype'] = 'TOTAL BILL'; // for current day
            }
          

            $reportYear = $getData['reportYear'];
			$reportMonth = $getData['reportMonth'];
		
			if(empty($reportYear)){
				$reportYear=date('Y');
			}

            if(empty($reportMonth)){
				$reportMonth=date('m');
			}

			if(!empty($reportMonth)){
				$countDays = cal_days_in_month(CAL_GREGORIAN, $reportMonth, $reportYear); // Days of the month selected
				$from = $reportYear."-".$reportMonth."-01 00:00:00";
				$to = $reportYear."-".$reportMonth."-".$countDays.' 23:59:59';
			} else {
				$from = $reportYear."-01-01 00:00:00"; // set first date of current year
				$to = $reportYear."-12-31 23:59:59"; // set last date of current year
			}
            
           $this->set(array('reportYear'=>$reportYear,'reportMonth'=>$reportMonth));
          

            // get billing  collection //
         	if ($getData['billtype'] == 'TOTAL BILL') {
                $this->Billing->bindModel(array(
                    'belongsTo' => array('Patient' => array('foreignKey' => false, 'conditions' => array("Billing.patient_id=Patient.id", "Billing.location_id" => $this->Session->read('locationid'))),
                        'Person' => array('foreignKey' => false, 'conditions' => array('Person.id=Patient.person_id', "Person.location_id" => $this->Session->read('locationid'))),
                        'Department' => array('foreignKey' => false, 'conditions' => array('Department.id=Patient.department_id', "Department.location_id" => $this->Session->read('locationid'))),
                        'PatientInitial' => array('foreignKey' => false, 'conditions' => array('PatientInitial.id =Person.initial_id')),
                        'User' => array('foreignKey' => false, 'conditions' => array('User.id=Patient.doctor_id', "User.location_id" => $this->Session->read('locationid'))),
                )));
                $conditionsBilling['Billing']['location_id'] = $this->Session->read('locationid');
                $conditionsBilling['Billing'] = array('date BETWEEN ? AND ?' => array($from, $to));
                $conditionsBilling['Patient']['is_deleted'] = '0';
                #$conditionsBilling['Billing']['mode_of_payment'] = 'Cash';
                if ($getData['mode_of_payment'] != "") {
                   $conditionsBilling['Billing']['mode_of_payment'] = $getData['mode_of_payment']; 
                } else {
                   $conditionsBilling['Billing']['mode_of_payment'] = array('Cash', 'Cheque', 'NEFT', 'Credit Card','Credit'); 
                   
                }
             
                $conditionsBilling = $this->postConditions($conditionsBilling);
                
                $getBillingCash = $this->Billing->find("all", array('conditions' => $conditionsBilling,
                    'fields' => array('Department.name', 'User.username','User.first_name','User.last_name', 'Person.plot_no', 'Person.landmark', 'Person.city', 'Person.taluka', 'Person.district', 'Person.state',
                        'Person.pin_code', 'Person.mobile', 'Billing.date', 'PatientInitial.name', 'Patient.is_discharge',
                        'Patient.form_received_on', 'Patient.form_completed_on', 'Patient.lookup_name', 'Patient.mobile_phone', 'Patient.id',
                        'Patient.admission_type', 'Patient.admission_id', 'Patient.address1', 'SUM(Billing.amount) AS sum_amount',
                        'Billing.amount', 'Billing.reason_of_payment', 'Billing.mode_of_payment', 'Billing.tariff_list_id', 'Billing.created_by'),
                    'group' => array('Patient.id'),
                    'order' => array('Billing.date')));
               # debug($getBillingCash);
               
                foreach ($getBillingCash as $key => $value) {
                	$billingResult[$value['Department']['name']][] = $value;
                	
                }   

                 $this->set('getBillingCash', $billingResult);  
            }

            // get radiology  billing //
             if ($getData['billtype'] == 'RADIOLOGY') {
                $this->RadiologyTestOrder->bindModel(array(
                    'belongsTo' => array(
                        'Patient' => array('foreignKey' => false, 'conditions' => array("RadiologyTestOrder.patient_id=Patient.id", "Patient.location_id" => $this->Session->read('locationid'))),
                        'Person' => array('foreignKey' => false, 'conditions' => array('Person.id=Patient.person_id', "Person.location_id" => $this->Session->read('locationid'))),
                        'Department' => array('foreignKey' => false, 'conditions' => array('Department.id=Patient.department_id', "Department.location_id" => $this->Session->read('locationid'))),
                        'PatientInitial' => array('foreignKey' => false, 'conditions' => array('PatientInitial.id =Person.initial_id')),
                        'Billing' => array('foreignKey' => false, 'conditions' => array('Billing.patient_id =Patient.id', "Billing.location_id" => $this->Session->read('locationid'))),
                        'ServiceCategory' => array('foreignKey' => false, 'conditions' => array('ServiceCategory.id=Billing.payment_category', "ServiceCategory.location_id" => $this->Session->read('locationid'))),
                        'User' => array('foreignKey' => false, 'conditions' => array('User.id=Patient.doctor_id', "User.location_id" => $this->Session->read('locationid'))),
                )));
                $conditionsRadiology['RadiologyTestOrder'] = array('create_time BETWEEN ? AND ?' => array($from, $to));
                 $conditionsRadiology['Patient']['is_deleted'] = '0';
                #$conditionsRadiology['Billing']['mode_of_payment'] = 'Cash';
                 if ($getData['mode_of_payment'] != "") {
                   $conditionsRadiology['Billing']['mode_of_payment'] = $getData['mode_of_payment']; 
                } else {
                   $conditionsRadiology['Billing']['mode_of_payment'] = array('Cash', 'Cheque', 'NEFT', 'Credit Card','Credit'); 
                   
                }
                $conditionsRadiology['ServiceCategory']['name'] = 'radiology';
                $conditionsRadiology = $this->postConditions($conditionsRadiology);
                $getRadiologyTestCash = $this->RadiologyTestOrder->find("all", array('conditions' => $conditionsRadiology,
                    'fields' => array('Department.name', 'Person.plot_no', 'Person.landmark', 'Person.city', 'Person.taluka', 'Person.district', 'Person.state',
                        'Person.pin_code', 'Person.mobile', 'RadiologyTestOrder.create_time', 'PatientInitial.name',
                        'Patient.is_discharge', 'Patient.form_received_on', 'Patient.form_completed_on', 'Patient.lookup_name',
                        'Patient.mobile_phone', 'Patient.admission_type', 'Patient.admission_id', 'Patient.address1',
                        'SUM(RadiologyTestOrder.amount) AS sum_amount', 'RadiologyTestOrder.paid_amount',
                        'Billing.mode_of_payment', 'RadiologyTestOrder.testname', 'Billing.created_by', 'User.username','User.first_name','User.last_name'), 'group' => array('RadiologyTestOrder.id'),
                    'order' => array('RadiologyTestOrder.create_time')));
                
           		foreach ($getRadiologyTestCash as $key => $value) {
                	$radResult[$value['Department']['name']][] = $value;
                	
                }     
                $this->set('getRadiologyTestCash', $radResult);
            }

            // get laboratory  billing //
            if ($getData['billtype'] == 'LABORATORY') {
                $this->LaboratoryTestOrder->bindModel(array('belongsTo' => array('Patient' => array('foreignKey' => false, 'conditions' => array("LaboratoryTestOrder.patient_id=Patient.id", "LaboratoryTestOrder.location_id" => $this->Session->read('locationid'))),
                        'Person' => array('foreignKey' => false, 'conditions' => array('Person.id=Patient.person_id', "Person.location_id" => $this->Session->read('locationid'))),
                        'Department' => array('foreignKey' => false, 'conditions' => array('Department.id=Patient.department_id', "Department.location_id" => $this->Session->read('locationid'))),
                        'PatientInitial' => array('foreignKey' => false, 'conditions' => array('PatientInitial.id =Person.initial_id')),
                        'Billing' => array('foreignKey' => false, 'conditions' => array('Billing.patient_id =Patient.id', "Billing.location_id" => $this->Session->read('locationid'))),
                        'ServiceCategory' => array('foreignKey' => false, 'conditions' => array('ServiceCategory.id=Billing.payment_category', "ServiceCategory.location_id" => $this->Session->read('locationid'))),
                        'User' => array('foreignKey' => false, 'conditions' => array('User.id=Patient.doctor_id', "User.location_id" => $this->Session->read('locationid'))),
                )));
                $conditionsLaboratory['LaboratoryTestOrder'] = array('create_time BETWEEN ? AND ?' => array($from, $to));
                #$conditionsLaboratory['Billing']['mode_of_payment'] = 'Cash';
                if ($getData['mode_of_payment'] != "") {
                
                   $conditionsLaboratory['Billing']['mode_of_payment'] = $getData['mode_of_payment']; 
                } else {
                   $conditionsLaboratory['Billing']['mode_of_payment'] = array('Cash', 'Cheque', 'NEFT', 'Credit Card','Credit'); 
                   
                }
                $conditionsLaboratory['ServiceCategory']['name'] = 'Laboratory';
                $conditionsLaboratory['Patient']['is_deleted'] = '0';
                $conditionsLaboratory = $this->postConditions($conditionsLaboratory);
                $getLaboratoryTestCash = $this->LaboratoryTestOrder->find("all", array('conditions' => $conditionsLaboratory,
                    'fields' => array('Department.name', 'Person.plot_no', 'Person.landmark', 'Person.city', 'Person.taluka', 'Person.district', 'Person.state',
                        'Person.pin_code', 'Person.mobile', 'LaboratoryTestOrder.create_time', 'PatientInitial.name',
                        'Patient.is_discharge', 'Patient.form_received_on', 'Patient.form_completed_on', 'Patient.lookup_name',
                        'Patient.mobile_phone', 'Patient.admission_type', 'Patient.admission_id', 'Patient.address1',
                        'SUM(LaboratoryTestOrder.amount) AS sum_amount', 'LaboratoryTestOrder.paid_amount',
                        'Billing.mode_of_payment', 'Billing.created_by', 'User.username','User.first_name','User.last_name'), 'group' => array('LaboratoryTestOrder.id'), 'order' => array('LaboratoryTestOrder.create_time')));
               foreach ($getLaboratoryTestCash as $key => $value) {
                	$labResult[$value['Department']['name']][] = $value;
                	
                }     
                $this->set('getLaboratoryTestCash', $labResult);
          }
            // get pharmacy  billing //
            if ($getData['billtype'] == 'PHARMACY') {
                $this->PharmacySalesBill->bindModel(array(
                    'belongsTo' => array('Patient' => array('foreignKey' => false, 'conditions' => array("PharmacySalesBill.patient_id=Patient.id",
                                "Patient.location_id" => $this->Session->read('locationid'))),
                        'Person' => array('foreignKey' => false, 'conditions' => array('Person.id=Patient.person_id',
                                "Person.location_id" => $this->Session->read('locationid'))),
                        'Department' => array('foreignKey' => false, 'conditions' => array('Department.id=Patient.department_id',
                                "Department.location_id" => $this->Session->read('locationid'))),
                        'PatientInitial' => array('foreignKey' => false, 'conditions' => array('PatientInitial.id =Person.initial_id')),
                        'User' => array('foreignKey' => false, 'conditions' => array('User.id=Patient.doctor_id',
                                "User.location_id" => $this->Session->read('locationid'))),
                )));
                $conditionsPharmacy['PharmacySalesBill'] = array('create_time BETWEEN ? AND ?' => array($from, $to));
                if ($getData['mode_of_payment'] != "") {
                    $conditionsPharmacy['PharmacySalesBill']['payment_mode'] = $getData['mode_of_payment'];    
                }else{
                    $conditionsPharmacy['PharmacySalesBill']['payment_mode'] = array('Cash', 'Credit'); 
                }
                
                $conditionsPharmacy = $this->postConditions($conditionsPharmacy);

                $getPharmacyCash = $this->PharmacySalesBill->find("all", array('conditions' => $conditionsPharmacy,
                    'fields' => array('Department.name', 'Person.plot_no', 'Person.landmark', 'Person.city', 'Person.taluka', 'Person.district', 'Person.state',
                        'Person.pin_code', 'Person.mobile', 'PharmacySalesBill.create_time', 'PatientInitial.name', 'Patient.is_discharge', 'Patient.form_received_on',
                        'Patient.form_completed_on', 'Patient.lookup_name', 'Patient.mobile_phone', 'Patient.admission_type', 'Patient.admission_id', 'Patient.address1',
                        'SUM(PharmacySalesBill.total) AS sum_amount', 'PharmacySalesBill.total', 'PharmacySalesBill.payment_mode', 'PharmacySalesBill.created_by', 'User.username','User.first_name','User.last_name'),
                    'group' => array('PharmacySalesBill.id'), 'order' => array('PharmacySalesBill.create_time')));
               
                 foreach ($getPharmacyCash as $key => $value) {
                	$pharmaResult[$value['Department']['name']][] = $value;
                	
                }  

                 $this->set('getPharmacyCash', $pharmaResult);
              
        }
    }
    
    // @7387737063
    // amount_paid_doctors
    	public function amount_paid_doctors($Reporttype=null,$ledgerId=null,$locId=null,$trialFrom=null,$trialTo=null){	
	
		ob_end_clean();
		ob_start("ob_gzhandler");
		$this->layout='advance';
		$this->uses=array('VoucherEntry','AccountReceipt','VoucherPayment','Account','ContraEntry','Patient');
// 		debug($this->request->data);
		if(!empty($this->params->query)){
			$this->request->data['VoucherEntry']=$this->params->query;
		}
	
		$locationId = $this->Session->read('locationid');
		if($this->request->data || $Reporttype == 'TrialBalance' || $Reporttype == Configure::read('profit_loss_statement')){ //BOF-profitLossStatement condition added by Mahalaxmi
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
// 			debug($narration);exit;
			if(!empty($this->request->data['VoucherEntry']['narration'])){
				$Econditions['VoucherEntry.narration LIKE']='%'.$narration.'%';
				$Pconditions['VoucherPayment.narration LIKE']='%'.$narration.'%';
				$Rconditions['AccountReceipt.narration LIKE']='%'.$narration.'%';
				$Cconditions['ContraEntry.narration LIKE']='%'.$narration.'%';
			}
			$Econditions['VoucherEntry.narration NOT LIKE'] = '%surgery%';
$Pconditions['VoucherPayment.narration NOT LIKE'] = '%surgery%';
$Rconditions['AccountReceipt.narration NOT LIKE'] = '%surgery%';
$Cconditions['ContraEntry.narration NOT LIKE'] = '%surgery%';
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
			}elseif($getAccountType['Account']['user_type'] == 'Patient' || $getAccountType['Account']['user_type'] == 'User'){
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
							/*$debitAmount[$data['VoucherEntry']['patient_id']]['debit_amount'] = $debitAmount[$data['VoucherEntry']['patient_id']]['debit_amount'] + $data['VoucherEntry']['debit_amount'];
							$JournalEntry[$data['VoucherEntry']['patient_id']] = $data;
							$JournalEntry[$data['VoucherEntry']['patient_id']]['VoucherEntry']['debit_amount'] = $debitAmount[$data['VoucherEntry']['patient_id']]['debit_amount'];*/

							$debitAmount[$key]['debit_amount'] = $debitAmount[$key]['debit_amount'] + $data['VoucherEntry']['debit_amount'];
							$JournalEntry[$key] = $data;
							$JournalEntry[$key]['VoucherEntry']['debit_amount'] = $debitAmount[$key]['debit_amount'];


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
			}
			
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
			//$combineArray =array_merge($reciept,$payment,$contra,$tds);
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
			if($Reporttype=='TrialBalance' || $Reporttype==Configure::read('profit_loss_statement')){				
				$this->data = $userid;
				$this->layout='advance_ajax';
				$this->render('ajax_trial_ledger_details');
			}
			if($Reporttype=='excel'){
			 //   debug($this->request->data);exit;
				$this->layout=false;
				$this->render('amount_paid_doctors_excel',false);
			}
		}
	
}