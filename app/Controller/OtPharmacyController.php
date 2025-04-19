<?php

class OtPharmacyController extends AppController {
	
	public $name = 'OtPharmacy';
	public $uses = array('OtPharmacyItem','OtPharmacyItemRate','OtPharmacySalesBill','OtPharmacySalesBillDetail','OtPharmacySalesReturn','OtPharmacySalesReturnDetail');
	public $components = array('RequestHandler','Email','DateFormat','Number','General');
	public $helpers = array('Html','Form', 'Js','DateFormat','Number','General','RupeesToWords');
	
	public function index(){
		
	}
	
	public function add_item(){
		
		$this->uses = array('OtPharmacyItemRate','Configuration','Location','OtPharmacyItem');
		$this->layout ='advance';
		
		$this->OtPharmacyItem->bindModel(array('belongsTo'=>array('Location'=>array('foreignKey'=>false,'conditions'=>array('OtPharmacyItem.location_id = Location.id'),'fields'=>array('Location.id','Location.name')))));
		if ($this->request->is('post') && !empty($this->request->data)) {
		
		   if($this->request->data['name'] !=""){
				$conditions['OtPharmacyItem.name LIKE'] = '%'.$this->request->data['name'].'%';
			}
           if($this->request->data['item_code'] !=""){
			
			     $conditions['OtPharmacyItem.item_code like'] = '%'.$this->request->data['item_code'].'%';	
			}
		    if($this->request->data['location_id'] !=""){
					
				$conditions['OtPharmacyItem.location_id'] = $this->request->data['location_id'];
			} 
			
		/*	$arrayOtItem = array();
			$arrayOtItem['created_time'] = date('Y-m-d H:i:s');
			$arrayOtItem['created_by'] = $this->Auth->user('id');
			$arrayOtItem['location_id'] = $this->Session->read('locationid');
			$arrayOtItem['name'] = $this->request->data['OtPharmacyItem']['name'];
			$arrayOtItem['item_code'] = $this->request->data['OtPharmacyItem']['item_code'];
			$arrayOtItem['pack'] = $this->request->data['OtPharmacyItem']['pack'];
			$arrayOtItem['minimum'] = $this->request->data['OtPharmacyItem']['minimum'];
			$arrayOtItem['manufacturer'] = $this->request->data['OtPharmacyItem']['manufacturer'];
			$arrayOtItem['manufacturer_id'] = $this->request->data['OtPharmacyItem']['manufacturer_id'];
			$arrayOtItem['maximum'] = $this->request->data['OtPharmacyItem']['maximum'];
			$arrayOtItem['date'] = $this->DateFormat->formatDate2STD($this->request->data['OtPharmacyItem']['date'],Configure::read('date_format'));
			$arrayOtItem['shelf'] = $this->request->data['OtPharmacyItem']['shelf'];
			$arrayOtItem['generic'] = $this->request->data['OtPharmacyItem']['generic'];
			$arrayOtItem['supplier_name'] = $this->request->data['OtPharmacyItem']['supplier_name'];
			$arrayOtItem['supplier_id'] = $this->request->data['OtPharmacyItem']['supplier_id'];
			
			$this->OtPharmacyItem->create();
			$this->OtPharmacyItem->save($arrayOtItem);
			$this->OtPharmacyItem->id =" ";
			return $this->redirect($this->referer());*/
		}
		
		$this->paginate = array(
				'limit' => '10',
				'order' => array(
						'OtPharmacyItem.name' => 'asc'
				),
				'conditions' => array($conditions,'OtPharmacyItem.is_deleted' => 0/*,"OtPharmacyItem.location_id" =>$this->Session->read('locationid')*/)
		);
		
		/* $data = $this->OtPharmacyItem->find('all'); */
		$data = $this->paginate('OtPharmacyItem');
		$this->set('data',$data);
		$location = $this->Location->find('list', array('fields'=> array('id', 'name'),'conditions'=>array('Location.is_active' => 1, 'Location.is_deleted' => 0)));
		$this->set('location',$location);
	}
	
	public function add_item_rate(){
		
		$this->uses = array('OtPharmacyItemRate','Configuration');
			$this->layout ='advance';
		if ($this->request->is('post') && !empty($this->request->data)) {
			if(!empty($this->request->data['OtPharmacyItem']['item_id'])){
				$arrayOtItem = array();
				$arrayOtItem['item_id'] =  $this->request->data['OtPharmacyItem']['item_id'];
				$arrayOtItem['created_time'] = date('Y-m-d H:i:s');
				$arrayOtItem['created_by'] = $this->Auth->user('id');
				$arrayOtItem['location_id'] = $this->Session->read('locationid');
				$arrayOtItem['batch_number'] = $this->request->data['OtPharmacyItemRate']['batch_number'];
				$arrayOtItem['purchase_price'] = $this->request->data['OtPharmacyItemRate']['purchase_price'];
				$arrayOtItem['sale_price'] = $this->request->data['OtPharmacyItemRate']['sale_price'];
				$arrayOtItem['mrp'] = $this->request->data['OtPharmacyItemRate']['mrp'];
				$arrayOtItem['stock'] = $this->request->data['OtPharmacyItemRate']['stock'];
				$arrayOtItem['expiry_date'] = $this->DateFormat->formatDate2STD($this->request->data['OtPharmacyItemRate']['expiry_date'],Configure::read('date_format'));
				
				$this->OtPharmacyItemRate->create();
				$this->OtPharmacyItemRate->save($arrayOtItem);
				$this->OtPharmacyItemRate->id =" ";
				$this->Session->setFlash(__('Item Rate Saved Successfully', true));
				return $this->redirect($this->referer());
			
			}else{
				$this->Session->setFlash(__('Invalid Item ID', true));
				return $this->redirect($this->referer());
			}
			
		}
		$data = $this->OtPharmacyItemRate->find('all',array(
				'conditions'=>array('OtPharmacyItemRate.is_deleted'=>'0','OtPharmacyItemRate.batch_number IS NOT NULL',
									'OtPharmacyItemRate.stock IS NOT NULL',"OtPharmacyItemRate.location_id" =>$this->Session->read('locationid')),
				'fields'=>array('OtPharmacyItem.id','OtPharmacyItem.pack','OtPharmacyItem.name','OtPharmacyItemRate.*')		
		));
		
		$this->set('data',$data);
		
	}
	
	public function sales_bill(){
		$this->uses = array('OtPharmacySalesBill','OtPharmacySalesBillDetail');
		//$inventory = new InventoryCategoriesController;
		
		$this->layout = "advance";
		$this->loadModel("Configuration");
		$configPharmacy = $this->Configuration->getPharmacyServiceType();
		$mode_of_payment = array('Credit'=>'Credit'/* ,'Cash'=>'Cash' */);
		/* if($configPharmacy['cashCounter']=="yes"){
			$mode_of_payment = array_merge($mode_of_payment,array('Cash'=>'Cash'));
		} */
		$this->set(compact(array('mode_of_payment')));
		
		if($this->request->is('Post') && (!empty($this->request->data))){
			
			$salesBillArray = array();
			$salesBillArray['patient_id'] = $this->request->data['OtPharmacySalesBill']['patient_id'];
			$salesBillArray['doctor_id'] = $this->request->data['OtPharmacySalesBill']['doctor_id'];
			$salesBillArray['total'] = round($this->request->data['OtPharmacySalesBill']['total']);
			$salesBillArray['discount'] = round($this->request->data['OtPharmacySalesBill']['discount']);
			$salesBillArray['payment_mode'] = $this->request->data['OtPharmacySalesBill']['payment_mode'];
			$salesBillArray['item_type'] = $this->request->data['OtPharmacySalesBill']['itemType'];
			$salesBillArray['payment_mode'] = $this->request->data['OtPharmacySalesBill']['payment_mode'];
			$salesBillArray['bill_code']  = $this->OtPharmacySalesBill->generateRandomBillNo();
			$salesBillArray['created_time'] = date('Y-m-d H:i:s');
			$salesBillArray['created_by'] = $this->Auth->user('id');
			$salesBillArray['is_deleted'] = 0;
			
			if($this->request->data['OtPharmacySalesBill']['payment_mode'] == "Cash"){
				$salesBillArray['paid_amount'] = $this->request->data['OtPharmacySalesBill']['total'] - $this->request->data['OtPharmacySalesBill']['discount']; //by swapnil 20.02.2015
			}
			
			$this->OtPharmacySalesBill->create();
			$this->OtPharmacySalesBill->save($salesBillArray);
			$lastInsertedIdOfSalesBill = $this->OtPharmacySalesBill->getLastInsertID(); 
			$patientId = $this->request->data['OtPharmacySalesBill']['patient_id'];
			//save in billing if payment is cash 
			if($this->request->data['OtPharmacySalesBill']['payment_mode'] == "Cash"){
				
				$this->loadModel('Billing');
				 $this->loadModel('ServiceCategory');
				$payment_category = $this->ServiceCategory->getOtPharmacyId(); 
				$billingData = array();
				$billingData['date']=date("Y-m-d H:i:s");
				$billingData['patient_id']=$patientId;
				$billingData['payment_category']=$payment_category;
				$billingData['location_id']=$this->Session->read('locationid');
				$billingData['created_by']=$this->Session->read('userid');
				$billingData['create_time']=date("Y-m-d H:i:s");
				$billingData['mode_of_payment']=$this->request->data['OtPharmacySalesBill']['payment_mode'];
				$billingData['total_amount']=$this->request->data['OtPharmacySalesBill']['total'];
				$billingData['amount']=$this->request->data['OtPharmacySalesBill']['total'] - $this->request->data['OtPharmacySalesBill']['discount'];
				$billingData['ot_pharmacy_sales_bill_id'] = $lastInsertedIdOfSalesBill;
					
				if($this->request->data['OtPharmacySalesBill']['is_discount']==1){
					$billingData['discount_type']=$this->request->data['OtPharmacySalesBill']['discount_type'];
					if($billingData['discount_type'] == "Percentage"){
						$billingData['discount_percentage'] = $this->request->data['OtPharmacySalesBill']['input_discount'];
					}else
						if($billingData['discount_type'] == "Amount"){
						$billingData['discount_amount'] = $this->request->data['OtPharmacySalesBill']['discount'];
					}
				}
				$billingData['discount'] = $this->request->data['OtPharmacySalesBill']['discount'];
				
				$this->Billing->save($billingData);
				$lastBillId=$this->Billing->getLastInsertID();
				$billNo= $this->Billing->generateBillNoPerPay($patientId,$lastBillId);
				$updateBillingArray=array('Billing.bill_number'=>"'$billNo'");
				$this->Billing->updateAll($updateBillingArray,array('Billing.patient_id'=>$patientId,'Billing.id'=>$lastBillId));
					
				$this->OtPharmacySalesBill->id = $lastInsertedIdOfSalesBill;
				$updateBillId['billing_id'] = $lastBillId;
				
				$this->OtPharmacySalesBill->save($updateBillId);
				$this->OtPharmacySalesBill->id = "";
				
			}/** billing credit entry for discount -- Gaurav Chauriya */
				elseif($this->request->data['OtPharmacySalesBill']['payment_mode'] == "Credit" && isset($this->request->data['OtPharmacySalesBill']['discount'])){	//updated by Swapnil (iff discount on sales bill) 26.03.2015
					$this->loadModel('Billing');
					$this->loadModel('ServiceCategory');
					$payment_category = $this->ServiceCategory->getOtPharmacyId(); 
					$billingData = array();
					$billingData['date']=date("Y-m-d H:i:s");
					$billingData['patient_id']=$patientId;
					$billingData['payment_category']=$payment_category;
					$billingData['location_id']=$this->Session->read('locationid');
					$billingData['created_by']=$this->Session->read('userid');
					$billingData['create_time']=date("Y-m-d H:i:s");
					$billingData['mode_of_payment']=$this->request->data['OtPharmacySalesBill']['payment_mode'];
					$billingData['total_amount']=round($this->request->data['OtPharmacySalesBill']['total']);
					$billingData['amount']= '0';
					$billingData['ot_pharmacy_sales_bill_id'] = $lastInsertedIdOfSalesBill;
					
					/* if($this->request->data['OtPharmacySalesBill']['is_discount']==1){
						$billingData['discount_type'] = $this->request->data['OtPharmacySalesBill']['discount_type'];
						if($billingData['discount_type'] == "Percentage"){
							$billingData['discount_percentage'] = round($this->request->data['OtPharmacySalesBill']['input_discount']);
						}else
							if($billingData['discount_type'] == "Amount"){
							$billingData['discount_amount'] = round($this->request->data['OtPharmacySalesBill']['discount']);
						}
					} */
					$billingData['discount'] = round($this->request->data['OtPharmacySalesBill']['discount']);
					//$billingData['is_card'] = $this->request->data['PharmacySalesBill']['is_card'];
					//$billingData['patient_card'] = $this->request->data['PharmacySalesBill']['patient_card'];
						
					$this->Billing->save($billingData);	
					$lastNotesId=$this->Billing->getLastInsertID();
					$billNo= $this->Billing->generateBillNoPerPay($patientId,$lastNotesId);
					$updateBillingArray=array('Billing.bill_number'=>"'$billNo'");
					$this->Billing->updateAll($updateBillingArray,array('Billing.patient_id'=>$patientId,'Billing.id'=>$lastNotesId));
					//for accounting
					/** Not confirm hence commented gaurav*/
					/*$billingDataDetails['Billing'] = $billingData;
					$this->Billing->addPartialPaymentJV($billingDataDetails,$patientId);*/
					//EOF a/c by amit jain
					$this->OtPharmacySalesBill->id = $lastInsertedIdOfSalesBill;
					$updateBillId['billing_id'] = $lastNotesId;
					$this->OtPharmacySalesBill->save($updateBillId);
				}
			
			
			$errors = $this->OtPharmacySalesBill->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			}else{
				
				$this->OtPharmacySalesBillDetail->saveBillDetails($this->request->data,$lastInsertedIdOfSalesBill);
				
				$this->Session->setFlash(__('The Ot Sales Bill has been saved', true));
				if($this->request->data['print']){
					$url = Router::url(array("controller" => "OtPharmacy", "action" => "print_view",'OtPharmacySalesBill',$this->OtPharmacySalesBill->id));
					echo "<script>window.open('".$url."','Print','fullscreen=no,height=800px,width=800px,location=0,titlebar=no,toolbar=no',true )</script>";
				}else{
					$this->redirect(array("controller" => "OtPharmacy", "action" => "sales_bill", '?'=>array('print'=>'print','id'=>$lastInsertedIdOfSalesBill)));
				}
				
			}
		}
	}
	
	public function ot_details($type=null,$search=null){
		$this->uses = array('OtPharmacySalesBill','OtPharmacySalesBillDetail','Patient','Configuration','Billing','OtPharmacySalesReturn');
		$this->layout = "advance";
		switch($type){
			case "sales":
				$this->loadModel('ServiceCategory');
				if($search !== null){
					if($this->params->query['billno'] !==""){
						$conditions['OtPharmacySalesBill.bill_code LIKE'] = '%'.$this->params->query['billno'].'%';
					}
				
					if($this->params->query['date'] !==""){
						$date = $this->DateFormat->formatDate2STD($this->params->query['date'],Configure::read('date_format'));
						$date = explode(' ',$date);
						$conditions['OtPharmacySalesBill.create_time >'] = $date[0]." 00:00:00";
						$conditions['OtPharmacySalesBill.create_time <'] = $date[0]." 23:59:59";
					}
						
					if($this->params->query['customer_name'] !==""){
						if($this->params->query['person_id'] !==""){
							$conditions['OtPharmacySalesBill.patient_id'] =$this->params->query['person_id'];
						}else{
							$conditions['OtPharmacySalesBill.customer_name like'] = '%'.$this->params->query['customer_name'].'%';
						}
					}
				}
				
				$data = $this->OtPharmacySalesBill->find('all' ,array(
														'fields'=>array('OtPharmacySalesBill.*','Patient.id','Patient.admission_id','Patient.lookup_name')) );
				
				
				$this->paginate = array(
						'limit' => 15,
						'fields'=> array('OtPharmacySalesBill.id','OtPharmacySalesBill.patient_id','OtPharmacySalesBill.doctor_id',
								'OtPharmacySalesBill.discount','sum(OtPharmacySalesBill.total) as pharma','sum(OtPharmacySalesBill.discount) as disc','sum(OtPharmacySalesBill.paid_amount) as paidAmount',
								'OtPharmacySalesBill.total','OtPharmacySalesBill.bill_code', 'OtPharmacySalesBill.payment_mode',
								'OtPharmacySalesBill.created_time','Patient.id','Patient.patient_id',
								'Patient.lookup_name','Patient.payment_category','Patient.tariff_standard_id',
								'Patient.form_received_on','Patient.last_name', 'Patient.sex','Patient.person_id', 'Patient.admission_id',
								),
						'conditions'=>array($conditions,'OtPharmacySalesBill.is_deleted' =>'0'),
						'order' => array('OtPharmacySalesBill.id' => "DESC"),
						'group'=>array('Patient.id')
				);
				
				$this->set('title_for_layout', __('Sales Details', true));
				$data = $this->paginate('OtPharmacySalesBill');
				
				$this->set('data',$data);
				//by pankaj for return medicine amt
				 $returnList  = $this->OtPharmacySalesReturn->find('all',array('fields'=>array('SUM(OtPharmacySalesReturn.total) as total',
						'OtPharmacySalesReturn.patient_id'),
						'conditions'=>array('OtPharmacySalesReturn.is_deleted'=>'0'),'group'=>array('OtPharmacySalesReturn.patient_id')));
					
				foreach($returnList as $returnKey=>$returnValue){
					$returnListArray[$returnValue['OtPharmacySalesReturn']['patient_id']]= $returnValue[0]['total'];
					//return amount if billing_id exist ny swapnil 09.04.2015
					$retData= $this->Billing->returnPaidAmount($returnValue['InventoryPharmacySalesReturn']['patient_id']);
					$returnAmountArray[$returnValue['OtPharmacySalesReturn']['patient_id']] = $retData['otpharmacy'][0]['total'];
				}
				//EOF return
				$this->set('returnListArray',$returnListArray); 
				
				foreach($data as $pharmacy){ 
					$patientId[]=$pharmacy['OtPharmacySalesBill']['patient_id'];
					$tariff[]=$pharmacy['Patient']['tariff_standard_id'];
				}
				$this->Patient->bindModel(array(
						'belongsTo'=>array('TariffStandard'=>array('foreignKey'=>false, 'conditions'=>array('Patient.tariff_standard_id=TariffStandard.id')))));
				
				$tariffName=$this->Patient->find('all',array('fields'=>array('TariffStandard.name','Patient.id'),
						'conditions'=>array('TariffStandard.id'=>$tariff,'Patient.id'=>$patientId),
						'group'=>array('Patient.id')));
				
				$payment_category = $this->ServiceCategory->getOtPharmacyId();
				
				$paid=$this->Billing->find('all',array('fields'=>array('Billing.amount','Billing.discount','Billing.paid_to_patient','Billing.patient_id'),
						'conditions'=>array('Billing.patient_id'=>$patientId,'Billing.is_deleted'=>0,
								'Billing.payment_category'=>$payment_category),
						));
				
				foreach($paid as $key=>$pharPaid){
					$paidAmt[$pharPaid['Billing']['patient_id']]=$paidAmt[$pharPaid['Billing']['patient_id']]+$pharPaid['Billing']['amount'];
					$refund[$pharPaid['Billing']['patient_id']] = $refund[$pharPaid['Billing']['patient_id']] + $pharPaid['Billing']['paid_to_patient'];
					$discount[$pharPaid['Billing']['patient_id']] = $discount[$pharPaid['Billing']['patient_id']] + $pharPaid['Billing']['discount'];
					
				}
				foreach($tariffName as $tariffStandard){
					$patientTariff[$tariffStandard['Patient']['id']]=$tariffStandard['TariffStandard']['name'];
					
				}
				
				
				$this->set('tariff',$patientTariff);
				$this->set('paidAmt',$paidAmt);
				$this->set('refund',$refund);
				$this->set('billDiscount',$discount);
				$this->layout="advance";
				$this->render('sales_detail_list');
			break;
				
			case "sales_return":
			
				if($search !== null){
			
					if($this->params->query['date'] !==""){
						$date = $this->DateFormat->formatDate2STD($this->params->query['date'],Configure::read('date_format'));
						$date = explode(' ',$date);
						$conditions['OtPharmacySalesReturn.created_time >'] = $date[0]." 00:00:00";
						$conditions['OtPharmacySalesReturn.created_time <'] = $date[0]." 23:59:59";
					}
					if($this->params->query['customer_name'] !==""){
						if($this->params->query['person_id'] !==""){
							$conditions['OtPharmacySalesReturn.patient_id'] =$this->params->query['person_id'];
						}else{
			
							$conditions['OtPharmacySalesReturn.customer_name like'] = '%'.$this->params->query['customer_name'].'%';
						}
					}
				}
			
				$this->paginate = array(
						'limit' => Configure::read('number_of_rows'),
						'order' => array(
								'OtPharmacySalesReturn.created_time' => 'desc'
						),
						'conditions'=>array($conditions,'OtPharmacySalesReturn.is_deleted'=>'0')
				);
				$this->set('title_for_layout', __('Sales Return Details', true));
				$data = $this->paginate('OtPharmacySalesReturn');
				$this->set('data',$data);
				$this->render('sales_return_details');
			
			break;
			
			case "detail_bill":
				
				$roleName = $this->Session->read('role');
				//debug($this->Session->('role'));exit;
				$this->set(compact(array('roleName')));
				//commnetd by pankaj w as we dont need locatio id in patient sales bill
				//$conditions['PharmacySalesBill.location_id'] =$this->Session->read('locationid');
				$conditions['OtPharmacySalesBill.patient_id NOT'] = NULL;
				if($search !== null){
					if($this->params->query['billno'] !==""){
						$conditions['OtPharmacySalesBill.bill_code LIKE' ] = '%'.$this->params->query['billno'].'%';
					}
					if($this->params->query['date'] !==""){
						$date = $this->DateFormat->formatDate2STD($this->params->query['date'],Configure::read('date_format'));
						$date = explode(' ',$date);
						$conditions['OtPharmacySalesBill.created_time >'] = $date[0]." 00:00:00";
						$conditions['OtPharmacySalesBill.created_time <'] = $date[0]." 23:59:59";
					}
				}
				if($this->params->query['customer_name'] !==""){
					if($this->params->query['person_id'] !==""){
						$conditions['OtPharmacySalesBill.patient_id'] =$this->params->query['person_id'];
					}else{
						$conditions['OtPharmacySalesBill.customer_name like'] = '%'.$this->params->query['customer_name'].'%';
					}
				}
			
				$SalesData =$this->OtPharmacySalesBill->find('all',array(
						'order' => array(
								'OtPharmacySalesBill.created_time' => 'desc'),
								'fields'=> array('OtPharmacySalesBill.id','OtPharmacySalesBill.patient_id','OtPharmacySalesBill.doctor_id','OtPharmacySalesBill.paid_amount',
								'OtPharmacySalesBill.total','OtPharmacySalesBill.bill_code', 'OtPharmacySalesBill.payment_mode','OtPharmacySalesBill.created_time',
								'OtPharmacySalesBill.discount','Patient.id','Patient.patient_id','Patient.lookup_name','Patient.payment_category',
								'Patient.form_received_on','Patient.last_name','Patient.sex','Patient.person_id','Patient.admission_id',
								),
								'conditions'=>array($conditions,'OtPharmacySalesBill.is_deleted' =>'0')
				));
			
				if($this->params->query['customer_name'] !==""){
					if($this->params->query['person_id'] !==""){
						$returnConditions['OtPharmacySalesReturn.patient_id'] =$this->params->query['person_id'];
					}else{
						$returnConditions['OtPharmacySalesReturn.customer_name like'] = '%'.$this->params->query['customer_name'].'%';
					}
				}
				
				$salesReturnData =$this->OtPharmacySalesReturn->find('all',array(
						'conditions'=>array($returnConditions,'OtPharmacySalesReturn.is_deleted'=>'0')));
			
				$data =  $SalesData ; 
				$this->set('data',$data);
				$this->set('returnData',$salesReturnData);
				$this->layout = false;
				$this->render('detailed_ot_bill');
			break;
				
			case "cash_collected":
				//$conditions['OtPharmacySalesBill.location_id'] =$this->Session->read('locationid');
				$conditions['OtPharmacySalesBill.patient_id NOT'] = NULL;
				if($search !== null){
					if($this->params->query['billno'] !==""){
						$conditions['OtPharmacySalesBill.bill_code LIKE'] = '%'.$this->params->query['billno'].'%';
					}
			
					if($this->params->query['date'] !==""){
						$date = $this->DateFormat->formatDate2STD($this->params->query['date'],Configure::read('date_format'));
						$date = explode(' ',$date);
						$conditions['OtPharmacySalesBill.created_time >'] = $date[0]." 00:00:00";
						$conditions['OtPharmacySalesBill.created_time <'] = $date[0]." 23:59:59";
					}
				}
				if($this->params->query['customer_name'] !=""){
					if($this->params->query['person_id'] !=""){
						$conditions['OtPharmacySalesBill.patient_id'] =$this->params->query['person_id'];
					}else{
			
						$conditions['OtPharmacySalesBill.customer_name like'] = '%'.$this->params->query['customer_name'].'%';
					}
				}
			
				$SalesData =$this->OtPharmacySalesBill->find('all',array(
						'order' => array(
								'OtPharmacySalesBill.created_time' => 'desc'),
						'fields'=> array('OtPharmacySalesBill.id','OtPharmacySalesBill.patient_id','OtPharmacySalesBill.doctor_id','OtPharmacySalesBill.paid_amount',
								'OtPharmacySalesBill.total','OtPharmacySalesBill.bill_code','OtPharmacySalesBill.created_time','OtPharmacySalesBill.discount',
								'OtPharmacySalesBill.payment_mode','Patient.id','Patient.patient_id','Patient.lookup_name','Patient.payment_category',
								'Patient.form_received_on','Patient.last_name', 'Patient.sex','Patient.person_id', 'Patient.admission_id',
								),
						'conditions'=>array($conditions,'OtPharmacySalesBill.is_deleted' =>'0')
				));
			
				$this->set('title_for_layout', __('Sales Details', true));
				$this->set('data',$SalesData);
				
				$this->autoRender = false;
				$this->layout = 'ajax';
				$this->render('detailed_ot_cash',false);
			break;
		}
		
	}
	
	public function fetch_rate_for_item(){
		$this->layout = 'ajax';
		 
		$discountType = ''; 
		if(isset($_POST['roomType'])){
			$roomType = $_POST['roomType'];
					$allRoomListarray = array(
						'opd_ward'=>'opdgeneral_ward_discount',
						'general'=>'gen_ward_discount',
						'special'=>'spcl_ward_discount',
						'semi_special'=>'semi_spcl_ward_discount',
						'Delux'=>'dlx_ward_discount',
						'Isolation'=>'islolation_ward_discount');
				$discountType = $allRoomListarray[$roomType];
		}
		
		if($discountType){
			$discountTypeVar = 'OtPharmacyItem.'.$discountType ;
		}
		if(isset($_POST['item_id'])){
			$this->OtPharmacyItem->unbindModel(array('hasMany'=>array('OtPharmacyItemRate')));
				
			$this->OtPharmacyItem->bindModel(array(
					'hasMany'=>array(
							'OtPharmacyItemRate'=>array('foreignKey'=>'item_id',
									'order'=>array('OtPharmacyItemRate.expiry_date'=>'ASC')))
			));
			
			$item = $this->OtPharmacyItem->find('first' ,array(
						'fields'=>array('OtPharmacyItem.pack','OtPharmacyItem.name','OtPharmacyItem.stock','OtPharmacyItem.loose_stock','OtPharmacyItem.product_id',
								"$discountTypeVar"),
						'conditions'=>array('OtPharmacyItem.id' =>$this->request->data['item_id'],'OtPharmacyItem.product_id !='=>NULL),
				)); 
		}
		
		$item['OtPharmacyItem']['discount'] = $item['OtPharmacyItem'][$discountType];
		
		foreach($item['OtPharmacyItemRate'] as $key=>$val)
		{
			$item['OtPharmacyItemRate'][$key]['expiry_date'] = $this->DateFormat->formatDate2Local($val['expiry_date'],Configure::read('date_format'),false);
			if(strtolower($website) == "vadodara"/* && $privateId != $tariff*/){	//by swapnil to display sale price as MRP for corporate patient only 19.03.2015
				$item['OtPharmacyItemRate'][$key]['sale_price'] = $item['OtPharmacyItemRate'][$key]['mrp'];
			}
		}
		echo (json_encode($item));
		exit; 
		
	} 
	
	public function autocomplete_item($field=null){
		
		$searchKey = $this->params->query['term'];
		$filedOrder = array('id');
		
		if($field == "name"){
			array_push( $filedOrder,'name');
		}
		$conditions[$field." LIKE"] = $searchKey."%";
		$conditions["OtPharmacyItem.is_deleted"] ='0';
		$conditions[] = array('OR'=>array("OtPharmacyItem.stock > 0", "OtPharmacyItem.loose_stock > 0"));
	
		$this->OtPharmacyItem->recursive = -1;
		$items = $this->OtPharmacyItem->find('all', array('fields'=> $filedOrder,'conditions'=>$conditions,'limit'=>15/*,'group' => 'PharmacyItem.item_code'*/));
		
		foreach ($items as $key=>$value) {
			foreach ($value as $k=>$v) {
			}
			if($field == "name"){
				$output[] = array('id'=>$value['OtPharmacyItem']['id'],'value'=>$value['OtPharmacyItem']['name'],'discount'=>$value['OtPharmacyItem'][$discountType]); 
			}
		}
		
		echo json_encode($output);
		exit;//dont remove this
	}
	
	public function get_ot_bill($patient_id){
		$this->layout = false;
		$this->loadModel('ServiceCategory');
		$this->loadModel('Billing');
		$this->Billing->bindModel(array(
				'belongsTo'=>array(
						'Patient'=>array('foreignKey'=>'patient_id'))));
		$payment_category = $this->ServiceCategory->getOtPharmacyId();
		/** we get all pay details from sales bill not from Billing **/
		/* $billingArray=$this->Billing->find('all',array('fields'=>array('Patient.id','Patient.lookup_name','Billing.id','Billing.amount','Billing.discount','Billing.paid_to_patient','Billing.date','Billing.mode_of_payment'),
				'conditions'=>array('Billing.patient_id'=>$patient_id ,'Billing.payment_category'=>$payment_category ))); */
		
		$salesBillArray = $this->OtPharmacySalesBill->find('all',array(
				'conditions'=>array('OtPharmacySalesBill.patient_id'=>$patient_id,'OtPharmacySalesBill.paid_amount > 0'),
				'fields'=>array('OtPharmacySalesBill.*','Patient.id','Patient.lookup_name','Patient.admission_id','Patient.patient_id')));
		
		$this->set('patientId',$patient_id);
		$this->set('billingArray',$billingArray);
		$this->set('salesBillArray',$salesBillArray);
	
	}
	
	public function savePaymentFromOt($patientId=null){
		
		$this->uses=array('OtPharmacySalesBill');
		$this->autoRender = false;
		$this->layout = "ajax";
		$this->loadModel('Billing');
		$this->loadModel('ServiceCategory');
		$payment_category = $this->ServiceCategory->getOtPharmacyId();
		$total_amount = $this->request->data['Payment']['total_amount'];
		$discType = $this->request->data['Payment']['discount_type'];
		$discount = $this->request->data['Payment']['discount'];
		//debug($this->request->data);
		foreach($this->request->data['Payment']['bill_id'] as $key => $value){
			
			$saleBillData = $this->OtPharmacySalesBill->find('first',array(
								'fields'=>array('OtPharmacySalesBill.id','OtPharmacySalesBill.total','OtPharmacySalesBill.paid_amount','OtPharmacySalesBill.discount'),
								'conditions'=>array('OtPharmacySalesBill.id'=>$value)));
			
			$balance = $saleBillData['OtPharmacySalesBill']['total'] - ($saleBillData['OtPharmacySalesBill']['paid_amount'] + $saleBillData['OtPharmacySalesBill']['discount']) ;
		
			if($discType == "Percentage"){
				$disc = ($balance * $discount) / 100;
			}else{
				$discPer = ($discount * 100) / $total_amount;	//calculate percent% from total and discount amount
				$disc = ($balance * $discPer) / 100;
			}
			//	debug($balance-$disc);exit;
			$saveSalesData = array();
			$this->OtPharmacySalesBill->id = $saleBillData['OtPharmacySalesBill']['id'];
			
			$saveSalesData['modified_time'] = date("Y-m-d H:i:s");
			$saveSalesData['paid_amount'] = $saleBillData['OtPharmacySalesBill']['paid_amount'] + ($balance - $disc);
 
			if(strtolower($this->Session->read('website.instance')) == "vadodara"){
				$saveSalesData['discount'] = $saleBillData['OtPharmacySalesBill']['discount'] ;
			}else{
				$saveSalesData['discount'] = $disc;
			}
			$saveSalesData['modified_time']=date('Y-m-d H:i:s');
			$this->OtPharmacySalesBill->save($saveSalesData);
			$this->OtPharmacySalesBill->id = "";
			//save into billing
			$billingData = array();
			$billingData['date']=date("Y-m-d H:i:s");
			$billingData['patient_id']=$patientId;
			$billingData['payment_category']=$payment_category;
			$billingData['location_id']=$this->Session->read('locationid');
			$billingData['created_by']=$this->Session->read('userid');
			$billingData['create_time']=date("Y-m-d H:i:s");
			$billingData['mode_of_payment']="Cash";
			$billingData['total_amount'] = $saleBillData['OtPharmacySalesBill']['total'];
			$billingData['amount'] = $saveSalesData['paid_amount'] ;
			$billingData['discount_type'] = $discType;
			$billingData['amount_pending'] = $saleBillData['OtPharmacySalesBill']['total'] - $saveSalesData['paid_amount'] - $disc;
			$billingData['discount'] = $disc ;
			$billingData['refund']=$this->request->data['Payment']['refund'];
			$billingData['remark']=$this->request->data['Payment']['remark'];
				
			if($this->request->data['Payment']['refund'] == 1){
				$billingData['paid_to_patient'] = $this->request->data['Payment']['paid_to_patient'];
			}
				
			if($this->request->data['Payment']['discount_type'] == "Percentage"){
				$billingData['discount_percentage'] = $this->request->data['Payment']['is_discount'];
			}else
				if($this->request->data['Payment']['discount_type'] == "Amount"){
				$billingData['discount_amount'] = $disc;
			}
			
			$this->Billing->save($billingData);
			$this->Billing->id = "";
			$billingDataDetails['Billing'] = $billingData; //for accounting by amit
			$this->Billing->addPartialPaymentJV($billingDataDetails,$patientId);
			$lastNotesId=$this->Billing->getLastInsertID();
				
			$this->OtPharmacySalesBill->id = $saleBillData['OtPharmacySalesBill']['id'];
			$saveBillId = array();
			$saveBillId['billing_id'] = $lastNotesId;
			$this->OtPharmacySalesBill->save($saveBillId);
			$this->OtPharmacySalesBill->id = "";
				
			$billNo= $this->Billing->generateBillNoPerPay($patientId,$lastNotesId);
			$updateBillingArray=array('Billing.bill_number'=>"'$billNo'");
			$this->Billing->updateAll($updateBillingArray,array('Billing.patient_id'=>$patientId,'Billing.id'=>$lastNotesId));
				
		} //eof foreach
		$this->Session->setFlash(__('The Payment Has Been Successfully Paid', true));
		//$this->redirect(array('action'=>'pharmacy_details',"inventory"=>true,'cash_collected',"?"=>array('customer_name'=>"Ashwin Pate"),"&"=>array("person_id"=>$patientId)));
		//$this->inventory_pharmacy_details("cash_collected","");
	}
	
	
	public function get_ot_details($type=null,$id=null,$page=null){
		$this->uses = array('OtPharmacySalesBill','OtPharmacySalesBillDetail','OtPharmacyItemRate','OtPharmacySalesReturn');
		switch($type){
			case "sales":
				/* $this->loadModel("Configuration");
				$website_service_type = $this->Configuration->find('first',array('conditions'=>array('Configuration.name'=>'website')));
				$websiteConfig=unserialize($website_service_type['Configuration']['value']);
				$this->set('websiteConfig',$websiteConfig); */
		
				if($id!=null){
					$this->OtPharmacySalesBill->bindModel(array(
							'belongsTo' => array(
									/* 'User' =>array('foreignKey' => 'guarantor_id'),array('conditions'=>array('OtPharmacySalesBill.guarantor_id=User.id')), */
									'DoctorProfile' =>array('foreignKey' => false,'conditions' => array('OtPharmacySalesBill.doctor_id = DoctorProfile.user_id'))),
								
					));
		
					$saleBill = $this->OtPharmacySalesBill->find('first',array('conditions'=>
							array('OtPharmacySalesBill.id'=>$id,'OtPharmacySalesBill.is_deleted' =>'0'),
							'fields'=>array(/* 'User.username', */'OtPharmacySalesBill.*','Patient.*','DoctorProfile.doctor_name'
							)));
						
					foreach($saleBill['OtPharmacySalesBillDetail'] as $saleDetail){
						$otRate[]= $this->OtPharmacyItemRate->find('first',array(
								'conditions'=>array('OtPharmacyItemRate.item_id'=>$saleDetail['item_id'],'OtPharmacyItemRate.batch_number'=>$saleDetail['batch_number'])));
						//debug($pharmacyRate);
					}//debug($pharmacyRate);exit;
						
					$this->set('otRate',$otRate);
					$this->set('data',$saleBill);
				}
				$this->layout=false;
				$this->render('sales_bill_view');
			break;
			
			default:
				if(!empty($page) && $page == "salesBill"){
					$this->layout = "ajax";
				}
				if($id!=null){
					$sale_return_details = $this->OtPharmacySalesReturn->find('first',
							array('conditions' =>
									array("OtPharmacySalesReturn.id"=>$id,"OtPharmacySalesReturn.location_id" =>$this->Session->read('locationid'), 
											'OtPharmacySalesReturn.is_deleted'=>'0')));
					$this->set("data", $sale_return_details);
					
				}
				$this->render('sales_return_view');
		}
	}
	
	function sales_delete($type,$id){
		
	$this->uses = array('VoucherEntry','NewCropPrescription','Billing','OtPharmacySalesBill','OtPharmacySalesBillDetail','OtPharmacyItemRate','OtPharmacySalesReturnDetail');
	if(empty($id)){
			$this->Session->setFlash(__('Sales Bill Does Not Exists', true));
		}else{
			if($type=='sales'){
				$this->OtPharmacySalesBillDetail->bindModel(array(
						'belongsTo'=>array('OtPharmacyItemRate'=>array('foreignKey'=>false,'conditions'=>array('OtPharmacyItem.id = OtPharmacyItemRate.item_id',
								'OtPharmacySalesBillDetail.batch_number = OtPharmacyItemRate.batch_number')))));
				$itemInStock=$this->OtPharmacySalesBillDetail->find('all',array('conditions'=>array('OtPharmacySalesBillDetail.ot_pharmacy_sales_bill_id'=>$id)));
				
				//update stock in pharmacy Item and Pharmacy item rates
				foreach($itemInStock as $stock){
						
					//sales details
					$salePack = $stock['OtPharmacySalesBillDetail']['pack'];
					$qtyType = $stock['OtPharmacySalesBillDetail']['qty_type'];
					$saleQty = $stock['OtPharmacySalesBillDetail']['qty'];
						
					if($qtyType == "Tab"){
						$soldTab = $saleQty;
					}else{
						$soldTab = (int)$salePack * $saleQty;
					}
						
					//pharmacyItem Details
					$pharStock = $stock['OtPharmacyItem']['stock'];
					$pharLooseStock = $stock['OtPharmacyItem']['loose_stock'];
					$pharPack = $stock['OtPharmacyItem']['pack'];
					$pharTotalTab = (int)$pharPack * $pharStock + $pharLooseStock;
					$currentPharTabs = $pharTotalTab + $soldTab;
					$newPharStock = floor($currentPharTabs / $pharPack);
					$newPharLooseStock = $currentPharTabs % $pharPack;
						
					//pharmacyItemRate Details
					$pharRateStock = $stock['OtPharmacyItemRate']['stock'];
					$pharRateLooseStock = $stock['OtPharmacyItemRate']['loose_stock'];
					$pharRateTotalTab = (int)$pharPack * $pharRateStock + $pharRateLooseStock;
					$currentPharRateTabs = $pharRateTotalTab + $soldTab;
					$newPharRateStock = floor($currentPharRateTabs / $pharPack);
					$newPharRateLooseStock = $currentPharRateTabs % $pharPack;
						
					//new PharmacyItem Stock
					$pharmacyItemStock['OtPharmacyItem']['stock'] = $newPharStock;
					$pharmacyItemStock['OtPharmacyItem']['loose_stock'] = $newPharLooseStock;
					$pharmacyItemStock['OtPharmacyItem']['id'] = $stock['OtPharmacyItem']['id'];
					
					$this->OtPharmacyItem->save($pharmacyItemStock);
					$this->OtPharmacyItem->id = "";
						
					//new PharmacyItemRate Stock
					$pharmacyItemRateStock['OtPharmacyItemRate']['stock'] = $newPharRateStock;
					$pharmacyItemRateStock['OtPharmacyItemRate']['loose_stock'] = $newPharRateLooseStock;
					$pharmacyItemRateStock['OtPharmacyItemRate']['id'] = $stock['OtPharmacyItemRate']['id'];
					
					$this->OtPharmacyItemRate->save($pharmacyItemRateStock);
					$this->OtPharmacyItemRate->id = "";
						
				}
	
				//$this->VoucherEntry->updateAll(array('VoucherEntry.is_deleted'=>'1'),array('VoucherEntry.billing_id'=>$id));//for accounting - amit
				$this->OtPharmacySalesBill->updateAll(array('OtPharmacySalesBill.is_deleted'=>'1'),array('OtPharmacySalesBill.id'=>$id));
				$this->Billing->updateAll(array('Billing.is_deleted'=>'1'),array('Billing.ot_pharmacy_sales_bill_id'=>$id));
	
				/* $newUpdatedSalesId = $this->NewCropPrescription->find('all',
						array('conditions'=>array('NewCropPrescription.ot_pharmacy_sales_bill_id'=>$id),
								'fields'=>array('id','pharmacy_sales_bill_id')));
				/* By Mrunal on delete of sales bill update Pharmacy_sales_bill_id as null 
				foreach($newUpdatedSalesId as $updated){
						
					if($updated['NewCropPrescription']['id']){
						$arrayUpdate = array();
						$arrayUpdate['id'] = $updated['NewCropPrescription']['id'];
						$arrayUpdate['pharmacy_sales_bill_id'] = null;
	
						$this->NewCropPrescription->save($arrayUpdate);
						$this->NewCropPrescription->id = "";
					}
				} */
				/* End Of Code */
			}else if($type=='return'){
				$this->loadModel('OtPharmacySalesReturn');
				$this->OtPharmacySalesReturnDetail->bindModel(array(
						'belongsTo'=>array('OtPharmacyItemRate'=>array('foreignKey'=>false,'conditions'=>array('OtPharmacyItem.id=OtPharmacyItemRate.item_id',
								'OtPharmacySalesReturnDetail.batch_number = OtPharmacyItemRate.batch_number')))));
				$returnItemInStock=$this->OtPharmacySalesReturnDetail->find('all',array('conditions'=>array('OtPharmacySalesReturnDetail.ot_pharmacy_sales_return_id'=>$id)));
				//update stock in pharmacy Item and Pharmacy item rates
				foreach($returnItemInStock as $stock){
					$pharmacyItemStock['OtPharmacyItem']['stock']=$stock['OtPharmacyItem']['stock']-$stock['OtPharmacySalesReturnDetail']['qty'];
					$pharmacyItemStock['OtPharmacyItem']['id']=$stock['OtPharmacyItem']['id'];
					$this->OtPharmacyItem->save($pharmacyItemStock);
					
					$pharmacyItemRateStock['OtPharmacyItemRate']['stock']=$stock['OtPharmacyItemRate']['stock']-$stock['OtPharmacySalesReturnDetail']['qty'];
					$pharmacyItemRateStock['OtPharmacyItemRate']['id']=$stock['OtPharmacyItemRate']['id'];
					$this->OtPharmacyItemRate->save($pharmacyItemRateStock);
				}
				//$this->VoucherEntry->updateAll(array('VoucherEntry.is_deleted'=>'1'),array('VoucherEntry.billing_id'=>$id));//for accounting - amit
				$this->OtPharmacySalesReturn->updateAll(array('OtPharmacySalesReturn.is_deleted'=>'1'),array('OtPharmacySalesReturn.id'=>$id));
			}else if($type=='duplicate'){
				$this->loadModel('OtPharmacyDuplicateSalesBill');
				$this->OtPharmacyDuplicateSalesBill->updateAll(array('OtPharmacyDuplicateSalesBill.is_deleted'=>'1'),array('OtPharmacyDuplicateSalesBill.id'=>$id));
			}
			$this->Session->setFlash(__('Sales bill Deleted', true));
			$this->redirect($this->referer());
		}
	}
	
	public function printRefundReceipt(){
		//pr($this->request->query);exit;
		$this->layout = false;
		$this->uses = array('Billing','Patient');
		$this->Patient->bindModel(array(
				'belongsTo' => array(   'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
						'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
						'TariffStandard' =>array('foreignKey' => false,'conditions'=>array('TariffStandard.id =Patient.tariff_standard_id' )),
				)),false);
	
		$this->Billing->bindModel(array(
				'belongsTo' => array(
						'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Billing.created_by' )),
						'PatientCard' =>array('foreignKey' => false,'conditions'=>array('PatientCard.billing_id=Billing.id' )),
						'OtPharmacySalesBill'=>array('foreignKey' => false, 'conditions'=>array('Billing.ot_pharmacy_sales_bill_id = OtPharmacySalesBill.id'))
				)),false);
		
	if($this->request->params){
			$otBillId = $this->request->params['pass'][0];
			$billingData = $this->Billing->find('first',array('fields'=>array('Billing.*','User.username','User.first_name','User.last_name','PatientCard.amount',
					'OtPharmacySalesBill.*'),
					'conditions'=>array('Billing.ot_pharmacy_sales_bill_id'=>$otBillId,'Billing.is_deleted'=>'0')));
			$patientData = $this->Patient->find('first',array('conditions'=>array('Patient.id'=>$billingData['Billing']['patient_id']), 
					'fields' => array('Patient.*','PatientInitial.name','TariffStandard.name')));
			$this->set(array('billingData'=>$billingData,'patientData'=>$patientData));
			$this->patient_info($billingData['Billing']['patient_id']);
	
		}
	}
	
	public function sales_return($type=NULL,$returnId=NULL) {
		
		$this->layout = 'advance';
		$this->set('title_for_layout', __('Ot Pharmacy - Sales Return', true));
		$this->uses=array('Patient','Account','VoucherEntry','OtPharmacySalesReturn','OtPharmacySalesReturnDetail','OtPharmacySalesBill','OtPharmacyItemRate');
		if ($this->request->is('post') && !empty($this->request->data)) {
			//debug($this->request->data); 
			if($type=='sales_return_edit'){
				foreach($this->request->data['item_id'] as $key=>$stockUpdate){
					$item = $this->OtPharmacyItem->find('first',array('conditions' =>
								array("OtPharmacyItem.id"=>$stockUpdate)));
					
						$itemRate = $this->OtPharmacyItemRate->find('first',array('conditions' =>
								array("OtPharmacyItemRate.item_id"=>$stockUpdate,"OtPharmacyItemRate.batch_number" =>$this->request->data['batch_number'][$key])));
							
						$item['OtPharmacyItem']['stock']=$item['OtPharmacyItem']['stock']-$this->request->data['pre_sold_qty'][$key];
						$itemRate['OtPharmacyItemRate']['stock']=$itemRate['OtPharmacyItemRate']['stock']-$this->request->data['qty'][$key];
						$this->OtPharmacyItem->save($item);
						$this->OtPharmacyItemRate->save($itemRate);

						
				}
				$this->request->data['OtPharmacySalesReturn']['id']=$returnId;
				$this->OtPharmacySalesReturn->save($this->request->data);
				/******************** Deleteing the previous records of sales bill********************************/	
				$this->OtPharmacySalesReturnDetail->deleteAll(array('OtPharmacySalesReturnDetail.ot_pharmacy_sales_return_id' =>$returnId));				
				/******************** EOF Deleteing***************************************************************/			
				
				if($this->OtPharmacySalesReturnDetail->saveSaleReturn($this->request->data,$returnId)){
					$this->Session->setFlash(__('The Sale Return Details has been updated', true));
					$this->redirect('/inventory/Pharmacy/pharmacy_details/sales_return');
				}
				
			//EOF stock update
			
			}else{ 
				if(trim($this->request->data['OtPharmacySalesReturn']['party_code'])!=""){
					$conditions["Patient.admission_id"] =$this->request->data['ar']['person_id'];
					$Patient = $this->Patient->find('first', array('conditions'=>$conditions));
					$this->request->data['OtPharmacySalesReturn']['patient_id'] = $this->request->data['OtPharmacySalesReturn']['person_id'];
				}else{ 
					$this->request->data['OtPharmacySalesReturn']['customer_name']  = $this->request->data['OtPharmacySalesReturn']['party_name'];
				}
				
			$this->request->data['OtPharmacySalesReturn']['discount'] = round($this->request->data['OtPharmacySalesReturn']['discountTotal']);
			$this->request->data['OtPharmacySalesReturn']['created_time'] = date('Y-m-d H:i:s');
			$this->request->data['OtPharmacySalesReturn']['created_by'] = $this->Auth->user('id');
			$this->request->data['OtPharmacySalesReturn']['location_id'] = $this->Session->read('locationid');
			$this->request->data['OtPharmacySalesReturn']['bill_code'] = $this->OtPharmacySalesReturn->generateReturnBillNo();
			$this->request->data['OtPharmacySalesReturn']['is_deleted'] = 0 ;
				
			$this->OtPharmacySalesReturn->create(); 
			$this->OtPharmacySalesReturn->save($this->request->data);
			
			$get_last_insertID = $this->OtPharmacySalesBill->getLastInsertId();
			
			$errors = $this->OtPharmacySalesBill->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			}else{
				
				$this->OtPharmacySalesReturnDetail->saveSaleReturn($this->request->data,$this->OtPharmacySalesReturn->id);
				$this->Session->setFlash(__('The Sale Return Details has been saved', true));
				$get_last_insertID = $this->OtPharmacySalesReturn->getLastInsertId();
				if($this->request->data['print']){
					//$url = Router::url(array("controller" => "pharmacy", "action" => "inventory_print_view",'InventoryPharmacySalesReturn',$this->InventoryPharmacySalesReturn->id,'inventory'=>true));

					//echo "<script>window.open('".$url."','Print','fullscreen=no,height=800px,width=800px,location=0,titlebar=no,toolbar=no',true )</script>";
				}else{
					//$this->redirect(array("controller" => "pharmacy", "action" => "get_pharmacy_details" ,'sales_return',$this->InventoryPharmacySalesReturn->id,'inventory'=>true));
					$this->redirect(array("controller" => "OtPharmacy", "action" => "sales_return" /* ,'?'=>array('print'=>'print','id'=>$get_last_insertID )*/));
				}

			}
		}
	}
		
		
		if($type=="sales_return_edit"){
			if(!empty($returnId)){
				
				$editReturn=$this->OtPharmacySalesReturn->find('first',array(
						'conditions'=>array('OtPharmacySalesReturn.id'=>$returnId,'OtPharmacySalesReturn.is_deleted'=>'0')));
				$this->set('editReturn',$editReturn);
				//debug($editReturn);
				$this->OtPharmacyItem->bindModel(array(
					'belongsTo' => array(
							'OtPharmacySalesBillDetail' =>array('foreignKey' => false),
							array('conditions'=>array('OtPharmacySalesBillDetail.item_id = OtPharmacyItem.id')),
							'OtPharmacySalesBill' =>array('foreignKey' => false),array('OtPharmacySalesBill.id = OtPharmacySalesBillDetail.pharmacy_sales_bill_id','OtPharmacySalesBill.is_deleted' =>'0')
					)
	
				));
				
				foreach($editReturn['OtPharmacySalesReturnDetail'] as $item){
					$data=$this->OtPharmacyItem->find('first',array('conditions'=>array('OtPharmacySalesBill.patient_id'=>$editReturn['Patient']['id'],
							'OtPharmacyItem.id'=>$item['item_id']/* ,'OtPharmacyItemRate.batch_number'=>$item['batch_no'] */)));
					debug($item);
					$itemArray[$item['item_id']]['item_name']=$data['OtPharmacyItem']['name'];
					$itemArray[$item['item_id']]['manufacturer']=$data['OtPharmacyItem']['manufacturer'];
					$itemArray[$item['item_id']]['item_code']=$data['OtPharmacyItem']['item_code'];
					$itemArray[$item['item_id']]['sold_qty']=$data['OtPharmacySalesBillDetail']['qty'];
					$itemArray[$item['item_id']]['mrp']=$data['OtPharmacyItemRate']['mrp'];
					$itemArray[$item['item_id']]['price']=$data['OtPharmacyItemRate']['sale_price'];
					$itemArray[$item['item_id']]['pack']=$data['OtPharmacyItem']['pack'];
					$itemArray[$item['item_id']]['stock']=$data['OtPharmacyItem']['stock'];
					
					
				}
				$this->set('itemArray',$itemArray);
			}
		}
	}
	
	public function autocomplete_sales_return_item($field=null){
		$this->uses=array('OtPharmacySalesBillDetail','OtPharmacyItem','OtPharmacySalesBill');
		
		$searchKey = $this->params->query['term'] ;
		$filedOrder = array('OtPharmacyItem.id');
		if($field == "name"){
			$conditions["OtPharmacyItem.name LIKE"] = $searchKey."%";
			array_push( $filedOrder,'OtPharmacyItem.item_code','OtPharmacyItem.name');
		}else{
			$conditions["OtPharmacyItem.item_code LIKE"] = $searchKey."%";
			array_push( $filedOrder,'OtPharmacyItem.name','OtPharmacyItem.item_code');
		}
		$patientId = $this->request->query['patientId'];
		/* $conditions["OtPharmacyItem.location_id"] =$this->Session->read('locationid'); */
		$conditions["OtPharmacyItem.is_deleted"] ='0';
		$conditions["OtPharmacyItem.product_id !="] ='0';
		$conditions["OtPharmacySalesBill.patient_id"] = $patientId;
		
		$this->OtPharmacySalesBill->recursive = 0;
		$this->OtPharmacyItem->recursive = 0;	
		 
		 $this->OtPharmacySalesBill->bindModel(array(
					'belongsTo' => array(
							'OtPharmacySalesBillDetail' => array('foreignKey' => false,
																'conditions'=>"OtPharmacySalesBill.id = OtPharmacySalesBillDetail.ot_pharmacy_sales_bill_id"),
							'OtPharmacyItem' => array('foreignKey' => false,
																'conditions'=>"OtPharmacySalesBillDetail.item_id = OtPharmacyItem.id"))
			)); 
		
		$items = $this->OtPharmacySalesBill->find('all', array(
												'fields'=>$filedOrder,
												'conditions'=>array($conditions),
												'group' => 'OtPharmacyItem.id'));
		
		foreach ($items as $key=>$value) {
			if($field == "name"){
				$output[] = array('id'=>$value['OtPharmacyItem']['id'],'value'=>$value['OtPharmacyItem']['name'],'item_code'=>$value['OtPharmacyItem']['item_code']);
			}else{
				$output[] = array('id'=>$value['OtPharmacyItem']['id'],'value'=>$value['OtPharmacyItem']['item_code'],'name'=>$value['OtPharmacyItem']['name']);
			}
		}
		echo json_encode($output);
		exit;//dont remove this
	}
	
	public function fetch_rate_for_return_item(){
		$this->uses=array('OtPharmacySalesBillDetail','OtPharmacySalesBill','OtPharmacySalesReturn','OtPharmacySalesReturnDetail');
		if(isset($_POST['item_id'])){

				
			$item = $this->OtPharmacySalesBillDetail->find('all',array(
					'fields'=>array('OtPharmacySalesBillDetail.*'),
					'conditions'=>array('OtPharmacySalesBillDetail.item_id'=>$_POST['item_id'],
							'OtPharmacySalesBill.patient_id'=>$_POST['patient_id']),
					'order'=>array('OtPharmacySalesBillDetail.batch_number'=>"DESC")
			));
				
			/* Deduct Previous Return Quantity */
			$this->OtPharmacySalesReturn->unbindModel(array('belongsTo'=>array('Patient')));
				
			 $this->OtPharmacySalesReturn->bindModel(array(
					'belongsTo'=>array(
							'OtPharmacySalesReturnDetail'=>array(
									'foreignKey'=>false,
									'conditions'=>array('OtPharmacySalesReturnDetail.ot_pharmacy_sales_return_id=OtPharmacySalesReturn.id'))))); 
				
			$returnList = $this->OtPharmacySalesReturn->find('first',array(
					'fields'=>array('OtPharmacySalesReturnDetail.*','OtPharmacySalesReturn.*','sum(OtPharmacySalesReturnDetail.qty) as returnSum'),
					'conditions'=>array('OtPharmacySalesReturnDetail.item_id'=>$_POST['item_id'],
							'OtPharmacySalesReturn.patient_id'=>$_POST['patient_id'])));
			
			$returnQty = $returnList[0]['returnSum'];
			
			/* END of deduction */
			
			$batchVar = "";
			$totalTab = 0;
			$dataArr = array();
	
			foreach($item as $key => $val){ 
				$curBatch = $val['OtPharmacySalesBillDetail']['batch_number'];
				if($batchVar != $curBatch){
					$batchVar = $curBatch;
				}
				if($batchVar == $curBatch){
					if($val['OtPharmacySalesBillDetail']['qty_type'] == "Tab"){
						$qty = $val['OtPharmacySalesBillDetail']['qty'];
					}else{
						//if the pack is not avaialble
						if($val['OtPharmacySalesBillDetail']['pack'])
							$pack = $val['OtPharmacySalesBillDetail']['pack'] ;
						else
							$pack = 1 ;
							
						$qty = $val['OtPharmacySalesBillDetail']['qty']*(int)$pack;
					}
					$totalTab += $qty;
				} 
				$discount = $val['OtPharmacySalesBillDetail']['discount'] / $val['OtPharmacySalesBillDetail']['qty'];
			}
				
			$this->OtPharmacyItem->unbindModel(array('hasMany'=>array('OtPharmacyItemRate')));
			$this->OtPharmacyItem->bindModel(array('hasMany'=>array(
					'OtPharmacyItemRate'=>array('foreignKey'=>'item_id',
							'order'=>array('OtPharmacyItemRate.expiry_date'=>'ASC'))),
					));
				
			$pharmacyItemData = $this->OtPharmacyItem->find('first',array('conditions'=>array('OtPharmacyItem.id'=>$_POST['item_id']/* ,'OtPharmacyItem.location_id'=>$this->Session->read('locationid') */)));
				
			foreach($pharmacyItemData['OtPharmacyItemRate'] as $key=>$val)
			{
				$pharmacyItemData['OtPharmacyItemRate'][$key]['expiry_date'] = $this->DateFormat->formatDate2Local($val['expiry_date'],Configure::read('date_format'),false);
			}
			$pharmacyItemData['OtPharmacyItem']['totalSold'] = $totalTab - $returnQty;
			$pharmacyItemData['OtPharmacyItem']['discount'] = $discount; 
 			echo json_encode($pharmacyItemData) ;
			exit;
		}
		
	}
	
	public function print_view($print_section = null,$id = null){
		
		$this->layout = false;
		if($id == null){
			$this->Session->setFlash(__('Invalid Id for '.$print_section.'', true));
		}
		$this->OtPharmacySalesReturn->bindModel(array(
				'belongsTo' => array('Person' =>array('foreignKey' => 'patient_id'))
		));
		$this->OtPharmacySalesBill->bindModel(array(
				'belongsTo' => array('Person' =>array('foreignKey' => 'patient_id'))
		));
		$this->set('section',$print_section);
		
		if($print_section == "OtPharmacySalesBill"){
			$model = "OtPharmacySalesBill";
				
			$this->OtPharmacySalesBill->bindModel(array(
					'belongsTo' => array(
							/* 'User' =>array('foreignKey' => 'guarantor_id','conditions'=>array('OtPharmacySalesBill.guarantor_id=User.id')), */
							'DoctorProfile' =>array('foreignKey' => false,'conditions' => array('OtPharmacySalesBill.doctor_id = DoctorProfile.user_id')))
		
			),false);
		
			$data = $this->OtPharmacySalesBill->find('first',array('conditions'=>
					array('OtPharmacySalesBill.id'=>$id/* ,"OtPharmacySalesBill.location_id" =>$this->Session->read('locationid') */,
							'OtPharmacySalesBill.is_deleted' =>'0'),
					'fields'=>array( 'OtPharmacySalesBill.*','Patient.id','Patient.person_id','Patient.lookup_name','Patient.doctor_id','DoctorProfile.doctor_name','DoctorProfile.id')));
			
			$formatted_address = $this->setAddressFormat($saleBill['Person']);
		
			$this->set('address',$formatted_address);
			
			$userName=$this->User->getUserDetails($data['OtPharmacySalesBill']['created_by']);
			$this->set('userName',$userName['User']['username']);
			$this->set('createdDate',$data['OtPharmacySalesBill']['created_time']);
			
		}else{
			$model = "OtPharmacySalesReturn";
			
			$this->$model->bindModel(array(
					'belongsTo' => array(
						'Patient'=>array('foreignKey' => 'patient_id'),
						//'Doctor' =>array('foreignKey' => false,'conditions'=>array('Patient.doctor_id=Doctor.id')),
						'DoctorProfile' =>array('foreignKey' => false,'conditions' => array('Patient.doctor_id = DoctorProfile.user_id')),
			)));
			$data = $this->$model->find('first',array('conditions'=>
					array('OtPharmacySalesReturn.id'=>$id,/* "OtPharmacySalesReturn.location_id" =>$this->Session->read('locationid'), */'OtPharmacySalesReturn.is_deleted' =>'0'),
					'fields'=>array('OtPharmacySalesReturn.*','Patient.id','Patient.person_id','Patient.lookup_name','Patient.doctor_id','DoctorProfile.doctor_name','DoctorProfile.user_id')));
			
			$formatted_address = $this->setAddressFormat($saleReturn['Person']);
			$userName=$this->User->getUserDetails($data['OtPharmacySalesReturn']['created_by']);
			$this->set('userName',$userName['User']['username']);
			$this->set('createdDate',$data['OtPharmacySalesReturn']['created_time']);
			$this->set('address',$formatted_address);
		}
		
		$DocName=$this->User->getUserDetails($data['Patient']['doctor_id']);
		$this->set('doctorName',$DocName);
		$this->set('data',$data);
		
			
	}
	
 	public function saleBillTotalAmount(){
 		
		$this->uses = array('OtPharmacySalesBill','OtPharmacySalesBillDetail');
		$this->OtPharmacySalesBill->unbindModel(array('hasMany'=>array('OtPharmacySalesBillDetail')));
		$saleBil = $this->OtPharmacySalesBill->find('all',array(
							'fields'=>array('sum(OtPharmacySalesBill.total)')));
		return $saleBil;
	}
	/* For  OtPharmacy - to edit Item*/
	public function edit_item($id){
		$this->uses= array('Product');
		$this->layout ='advance';
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid Item ID', true));
			$this->redirect(array("controller" => "OtPharmacy", "action" => "add_item"));
		}
		
		if ($this->request->is('post') && !empty($this->request->data)) {
			$this->request->data['OtPharmacyItem']['date'] = $this->DateFormat->formatDate2STD($this->request->data['PharmacyItem']['date'],Configure::read('date_format'));
			$this->request->data['OtPharmacyItem']['modify_time'] = date('Y-m-d H:i:s');
			$this->request->data['OtPharmacyItem']['modified_by'] = $this->Auth->user('id');
			
		
			$this->OtPharmacyItem->id = $id;
			$this->OtPharmacyItem->save($this->request->data);
			$isProductId = $this->Product->find('first',array('conditions'=>array('Product.name'=>$this->request->data['OtPharmacyItem']['nameHidden'])));
		
			/* code to update name & manufacturer of product on edit of pharmacy item  */
			if($isProductId['Product']['id']){
					
				$productArray = array();
				$productArray['id'] = $isProductId['Product']['id'];
				$productArray['name'] = $this->request->data['OtPharmacyItem']['name'];
					
				$productArray['manufacturer_id'] = $this->request->data['OtPharmacyItem']['manufacturer_id'];
				$this->Product->save($productArray);
				$this->Product->id = "";
			}
			// End of Code //
			$this->Product->id = $id;
			$this->Product->save($this->request->data);
		
			$errors = $this->OtPharmacyItem->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
		
				$this->Session->setFlash(__('The Item has been updated', true));
				$this->redirect(array("controller" => "OtPharmacy", "action" => "add_item"));
			}
		} else {
			$this->OtPharmacyItem->bindModel(array('belongsTo'=>array(
					'InventorySupplier'=>array('foreignKey'=>false,'conditions'=>array('InventorySupplier.id=OtPharmacyItem.supplier_id')),
					'ManufacturerCompany'=>array('foreignKey'=>false,'conditions'=>array('ManufacturerCompany.id=OtPharmacyItem.manufacturer_id')),
					)));
			$this->set('data', $this->OtPharmacyItem->find('first',array('conditions' => array("OtPharmacyItem.id"=>$id))));
		}
	}
	
	/* Delete From OtPharmacyItem */
	public function item_delete($id = null) {
		$this->set('title_for_layout', __('Ot Pharmacy Management - Delete Item ', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid ID	', true));
			$this->redirect(array("controller" => "OtPharmacy", "action" => "add_item"));
		}
		if ($id) {
			$this->OtPharmacyItem->deleteOtPharmacyItem($id);
			$this->Session->setFlash(__('Item deleted', true));
			$this->redirect(array("controller" => "OtPharmacy", "action" => "add_item"));
			
		}
	}
	 
	
	/* edit particular item rate details
	 */
	/* public function edit_item_rate($id = null){
		$this->loadModel('Configuration');
		$website_service_type = $this->Configuration->find('first',array('conditions'=>array('Configuration.name'=>'website')));
		$websiteConfig=unserialize($website_service_type['Configuration']['value']);
		$this->set('websiteConfig',$websiteConfig);
	
		$this->uses=array('OtPharmacyItem','OtPharmacyItemRate');
		if($this->params->query['type']=='edit'){
			$id=$this->params->query['itemId'];
			$this->layout='advance_ajax';
			if(!empty($this->params->query['item_rate_id']) && $this->params->query['item_rate_id']!='null')
				$condition=array('OtPharmacyItemRate.id'=>$this->params->query['item_rate_id']);
	
		}
	
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid Item ID', true));
			//$this->redirect(array("controller" => "OTharmacy", "action" => "view_item_rate"));
		}
		if ($this->request->is('post') && !empty($this->request->data)) {
	
			$this->request->data['OtPharmacyItemRate']['expiry_date'] = $this->DateFormat->formatDate2STD($this->request->data['OtPharmacyItemRate']['expiry_date'],Configure::read('date_format'));
	
			/* for new prodcut update itemcode in PharmacyItem  
			$pharmaRateItemId = $this->request->data['OtPharmacyItemRate']['item_id'];
			$pharmaCode = $this->OtPharmacyItem->find('first',array('conditions'=>array('OtPharmacyItem.id'=>$pharmaRateItemId)));
			//debug($this->request->data);exit;
	
			$pharmaItemRate = $this->request->data['item_code'];
			if(!empty($pharmaItemRate) && ($pharmaItemRate != $pharmaCode['OtPharmacyItem']['item_code'])){
	
				$pharmaUpdateItemCode = array();
				$pharmaUpdateItemCode['id'] = $this->request->data['OtPharmacyItemRate']['item_id'];
				$pharmaUpdateItemCode['item_code'] = $this->request->data['item_code'];
				if(empty($pharmaCode['OtPharmacyItem']['stock'])){
					$pharmaUpdateItemCode['stock'] = $this->request->data['OtPharmacyItemRate']['stock'];
				}else{
					$curPharmaStock = $pharmaCode['OtPharmacyItem']['stock'];
					$curPharmaRateStock = $this->request->data['OtPharmacyItemRate']['stockHiddn'];
					$changStock = $this->request->data['OtPharmacyItemRate']['stock'];
	
					$remainStock = $curPharmaRateStock-$changStock;                  //add to pharmacy stock
					$pharmaUpdateItemCode['stock'] = $curPharmaStock-$remainStock;
				}
	
				$this->OtPharmacyItem->save($pharmaUpdateItemCode);
				$this->OtPharmacyItem->id = "";
			}
			
			 End Of Updation Code 
			
			$this->OtPharmacyItemRate->save($this->request->data);
			$errors = $this->OtPharmacyItemRate->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
	
				$this->Session->setFlash(__('The Item has been updated', true));
				if($this->params->query['type']=='edit'){
					echo "<script>
							var fieldNo=parent.$('#no_of_fields').val();
								parent.$('#item_code'+fieldNo).val('');
								parent.$('#item_id'+fieldNo).val('');
								parent.$('#item_name-'+fieldNo).val('');
								parent.$('#manufacturer'+fieldNo).val('');
								parent.$('#pack'+fieldNo).val('');
								parent.$('#batch_number'+fieldNo).empty();
								parent.$('#stockQty'+fieldNo).val('');
								parent.$('#expiry_date'+fieldNo).val('');
								parent.$('#mrp'+fieldNo).val('');
								parent.$('#rate'+fieldNo).val('');
								parent.$.fancybox.close();
							</script>";
				}else{
					//$this->redirect(array("controller" => "pharmacy", "action" => "view_item_rate"));
				}
			}
		} else {
			$this->set('itemDetails', $this->OtPharmacyItem->find('first',array(
					'conditions' => array( "PharmacyItem.location_id" =>$this->Session->read('locationid'), 
							"OtPharmacyItemRate.id" => $id, $condition))));
	
		}
		$this->set('data',$data);
	} */
	
	
	
	/* Fetch Generic Search Data */
	public function generic_search($fieldNo,$generic){
		$this->layout = "advance_ajax";
		
		if(!empty($this->request->data)){
			$generic = $this->request->data['OtPharmacyItem']['generic_name'];
		}
		
		$this->OtPharmacyItem->recursive = 0;
		$conditions[] = array('OR'=>array("OtPharmacyItem.stock > 0", "OtPharmacyItem.loose_stock > 0"));
		$data = $this->OtPharmacyItem->find('all',array(
				'fields'=>array('OtPharmacyItem.id','OtPharmacyItem.name','OtPharmacyItem.item_code','OtPharmacyItem.pack','OtPharmacyItem.stock','OtPharmacyItem.loose_stock',
								'OtPharmacyItem.generic'),
				'conditions'=>array($conditions,'OtPharmacyItem.generic'=>$generic),'group'=>"OtPharmacyItem.id"));
		$this->set('PharmacyData',$data);
		$this->set('field_number',$fieldNo);
	}
	
	/* Search Generic Item */
	public function generic_item(){
	
		$searchKey = $this->params->query['term'];
		//$conditions["OtPharmacyItem.location_id"] =$this->Session->read('locationid');
		$conditions["OtPharmacyItem.is_deleted"] ='0';
		$conditions["OtPharmacyItem.product_id !="] ='0';
		$conditions["OtPharmacyItem.generic LIKE"] = $searchKey."%";
	
		$this->OtPharmacyItem->recursive = 0;
		$items = $this->OtPharmacyItem->find('all', array(
				'fields'=>array('OtPharmacyItem.id','OtPharmacyItem.item_code','OtPharmacyItem.name','OtPharmacyItem.stock','OtPharmacyItem.generic'),
				'conditions'=>$conditions,'limit'=>15,'group' => 'OtPharmacyItem.generic'));
		foreach($items as $val){
			$returnArray[] = array('id'=>$val['OtPharmacyItem']['id'],'value'=>$val['OtPharmacyItem']['generic']);
		}
		echo json_encode($returnArray);
		exit;//dont remove this
	}
	
	/* END OF Generic code*/
	
	/*
	 * view Item with Batches
	 */
	public function viewBatches($id=null){
		$this->layout = 'advance_ajax';
		$this->set('title_for_layout', __('View Batches', true));
		if(!empty($id)){
			$data = $this->OtPharmacyItem->find('first',array('conditions' => array("OtPharmacyItem.id"=>$id))); 
			$this->set('datas',$data);
		}
	}
	/* END of Batches */
	
	/* for autocomplete og Sales bill */
	public function fetch_batch_for_item(){
		$this->layout  = 'ajax' ;
		$this->loadModel('OtPharmacyItemRate');
		$item = $this->OtPharmacyItemRate->find('first',array(
						'conditions'=>array('OtPharmacyItemRate.id'=>$this->request->query['itemRate']),
				));
		//debug($item);
		if(!empty($item)){
			
			$item['OtPharmacyItemRate']['sale_price'] = $item['OtPharmacyItemRate']['mrp'];
			
			$item['OtPharmacyItemRate']['expiry_date'] = $this->DateFormat->formatDate2Local($item['OtPharmacyItemRate']['expiry_date'],Configure::read('date_format'));
			$item['OtPharmacyItemRate']['loose_stock'] = $item['OtPharmacyItemRate']['loose_stock']!=""?$item['OtPharmacyItemRate']['loose_stock']:0;
		}
		echo (json_encode($item));
		exit;
	}
	
	/* for fetch the bill  */
	public function fetch_bill($field=null){
		$this->loadModel('Person');
		$this->loadModel('OtPharmacySalesBill');
		$searchKey = $this->params->query['term'];
		$filedOrder = array('id','bill_code');
		$conditions[$field." like"] = "%".$searchKey."%";
	//	$conditions["OtPharmacySalesBill.location_id"] =$this->Session->read('locationid');
		$items = $this->OtPharmacySalesBill->find('list', array('fields'=> $filedOrder,'conditions'=>array($conditions,'OtPharmacySalesBill.is_deleted' =>'0'),'limit'=>10));
		$output ='';
		foreach ($items as $key=>$value) {
			$returnArray[] = array('id'=>$key,'value'=>$value);
			//$output .= "$key|$value";
			//$output .= "\n";
		}
		echo json_encode($returnArray);
		//echo $output;
		exit;//dont remove this
	}
}
?>