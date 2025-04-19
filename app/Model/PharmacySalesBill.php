<?php
/**
 * WardModel file
 * 
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       PharmacySalesBill Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Mayank Jain
 */
class PharmacySalesBill extends AppModel {
	public $patient ;
	public $name = 'PharmacySalesBill';
	public $hasMany = array(
		'PharmacySalesBillDetail' => array(
		'className' => 'PharmacySalesBillDetail',
		'dependent' => true,
		'foreignKey' => 'pharmacy_sales_bill_id',
		),
	 
	); 
   public $belongsTo = array(
		'Patient' => array(
		'className' => 'Patient',
		'foreignKey' => 'patient_id',
		'dependent'=> true
		),
		'Doctor' => array(
		'className' => 'Doctor',
		'foreignKey' => 'doctor_id',
		'dependent'=> true
		),
		'Initial' =>array('foreignKey'=>false,"conditions"=>array("Initial.id = Doctor.initial_id"))
		
		); 
	public function generateRandomBillNo(){
		$characters = array(
		"A","B","C","D","E","F","G","H","J","K","L","M",
		"N","P","Q","R","S","T","U","V","W","X","Y","Z",
		"1","2","3","4","5","6","7","8","9");		
		$keys = array();
		$random_chars ='';		
		while(count($keys) < 7) {			
			$x = mt_rand(0, count($characters)-1);
			if(!in_array($x, $keys)) {
			   $keys[] = $x;
			}
		}		
		foreach($keys as $key){
		   $random_chars .= $characters[$key];
		}
		return $random_chars;	
	}
	
	public function generateSalesBillNo(){		//by swapnil
		$getBillCount = $this->find('count'); 
		return "SB-".str_pad($getBillCount, 4, '0', STR_PAD_LEFT);	
	}
	
	public function generateSalesBillNoForKanpur($locationID){ // By atul for kanpur
		
		$getBillCount = $this->find('count',array('conditions'=>array('PharmacySalesBill.location_id'=>$locationID,'PharmacySalesBill.create_time >'=>'2015-06-01 23:59:59')));

		if($locationID=='25'){
			$sbNo= "R-".str_pad($getBillCount, 5, '0', STR_PAD_LEFT); // for ROMAN PHARMA 
			$getBillNum = $this->find('first',array('fields'=>array('PharmacySalesBill.bill_code'),'conditions'=>array('PharmacySalesBill.bill_code'=>$sbNo)));
			 if($getBillNum['PharmacySalesBill']['bill_code']==$sbNo){
				$sbNo = "E-".str_pad($getBillCount+1, 5, '0', STR_PAD_LEFT);
			 }
		}else{
			$sbNo = "E-".str_pad($getBillCount, 5, '0', STR_PAD_LEFT); // FOR ROMAN PHARMA EXTENTION
			$getBillNum = $this->find('first',array('fields'=>array('PharmacySalesBill.bill_code'),'conditions'=>array('PharmacySalesBill.bill_code'=>$sbNo)));
			 if($getBillNum['PharmacySalesBill']['bill_code']==$sbNo){
			    $sbNo = "E-".str_pad($getBillCount+1, 5, '0', STR_PAD_LEFT);
			 }
		}
		return $sbNo;
	}

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
	
	public function getPatientSaleDetails($patient_id){
		$this->patient = $patient_id;
		$this->unbindModel(array('belongsTo'=>array('Patient','Doctor','Initial')));
		$sale_details = $this->find('all',array(
				"conditions"=>array("PharmacySalesBill.patient_id"=>$patient_id,
						'PharmacySalesBill.is_deleted'=>'0')));
		if(count($sale_details)>0){
			return $sale_details ;
		}else{
			return false;
		}
	}
	
		
	public function getCreditAmount($sales_bill_details){		
		$credit_amount = 0;		
		foreach($sales_bill_details as $key =>$value){
		if($value['PharmacySalesBill']['payment_mode'] == "credit")
				$credit_amount =$credit_amount+(double)$value['PharmacySalesBill']['total'];			
		}
		return $credit_amount;
	}
	
	public function getCashAmount($sales_bill_details){		
		$cash_amount = 0;
		$sale_return_amount = 0;
		foreach($sales_bill_details as $key =>$value){
		if($value['PharmacySalesBill']['payment_mode'] == "cash")
				$cash_amount =$cash_amount+(double)$value['PharmacySalesBill']['total'];		
		}
		/* check is patient return some medicine*/
		/*$InventoryPharmacySalesReturn = Classregistry::init('InventoryPharmacySalesReturn');
		$sale_return = $InventoryPharmacySalesReturn->find("all",array('conditions'=>array("InventoryPharmacySalesReturn.patient_id"=>$this->patient)));
		if(count($sale_return)>0)
			foreach($sale_return as $key =>$value){			
					$sale_return_amount =$sale_return_amount+(double)$value['InventoryPharmacySalesReturn']['total'];		
			}*/
			return $cash_amount;//+$sale_return_amount;
	}
	
		public function getTotalAmount($sales_bill_details){		
		$total = 0;		
		foreach($sales_bill_details as $key =>$value){		
				$total =$total+(double)$value['PharmacySalesBill']['total'];			
		}
		return $total;
	}
	
	//function to remove entries after discharged date
	function deleteAfterDischargeRecords($date,$patient_id){
		if(empty($patient_id)) return ;
		$session = new CakeSession();
		$this->deleteAll(array('PharmacySalesBill.create_time > '=>$date,'PharmacySalesBill.patient_id'=>$patient_id,'PharmacySalesBill.payment_mode'=>'credit'),true) ;  //cascade set to true
	}
	
	/* //for calculation of pharmacy tax --yashwant
	public function getTaxTotal($patient_id){
		$this->patient = $patient_id;
		$tax_details = $this->find('first',array("conditions"=>array("PharmacySalesBill.patient_id"=>$patient_id)));
		if(!empty($tax_details['PharmacySalesBill']['tax'])){
			return $tax_details['PharmacySalesBill']['tax'] ;
		}
	} */
	
	 public function deleteirectSale($id){
			
			$this->id = $id;
	      	$this->data["PharmacySalesBill"]["id"] = $id;
	      	$this->data["PharmacySalesBill"]["is_deleted"] = '1';
	      	$this->save($this->data);
	      	return true;
		}	
	/**
	 * jv for salebill function
	 * By amit
	 * @params patient_id
	 * return data
	 */
	public function JVSaleBillData($patient_id,$pharmacyAmount=null){
	
		$session     = new cakeSession();
		$patientObj = ClassRegistry::init('Patient');
		$accountObj = ClassRegistry::init('Account');
		$voucherEntry = ClassRegistry::init('VoucherEntry');
		$inventoryPharmacySalesReturnObj = ClassRegistry::init('InventoryPharmacySalesReturn');
		
		$this->unBindModel(array(
				'hasMany' => array('PharmacySalesBillDetail')));
		$saleBillData= $this->find('all',array('fields'=> array('SUM(PharmacySalesBill.total) as TotalAmount','PharmacySalesBill.create_time'),
				'conditions'=>array('PharmacySalesBill.location_id'=>$session->read('locationid'),'PharmacySalesBill.is_deleted'=>0,'PharmacySalesBill.patient_id'=>$patient_id)));
	
		$saleBillReturnData= $inventoryPharmacySalesReturnObj->find('all',array('fields'=> ('SUM(InventoryPharmacySalesReturn.total) as TotalRefundAmount'),
				'conditions'=>array('InventoryPharmacySalesReturn.location_id'=>$session->read('locationid'),'InventoryPharmacySalesReturn.is_deleted'=>0,'InventoryPharmacySalesReturn.patient_id'=>$patient_id)));
	
		$finalAmount = round($saleBillData[0][0]['TotalAmount']) - round($saleBillReturnData[0][0]['TotalRefundAmount']);
		
		if(!empty($pharmacyAmount)){
			$finalAmount = $pharmacyAmount;
		}
		$accountId = $accountObj->getAccountIdOnly(Configure::read('pharmacy_sale_Label'));//for Account id
		$getPatientDetails = $patientObj->getPatientAllDetails($patient_id);
                if($getPatientDetails['Patient']['is_paragon'] != '1'){ // if temporary registration then restrict entries -Atul Chandankhede
		$personId = $getPatientDetails['Patient']['person_id'];
		if($getPatientDetails['Patient']['is_staff_register'] == '1'){
				$getAccDetails = $accountObj->find('first',array('conditions'=>array('Account.user_type'=>'User',
												'Account.name'=>trim($getPatientDetails['Patient']['lookup_name']),
												'Account.location_id'=>$session->read('locationid')),
												'fields'=>array('Account.id','Account.name')));
		}else{
				$getAccDetails = $accountObj->getAccountID($personId,'Patient');//for user id
		}

		$userId = $getAccDetails['Account']['id'];
		
		$regDate  =  DateFormatComponent::formatDate2Local($getPatientDetails['Patient']['form_received_on'],Configure::read('date_format'),true);
		$doneDate  =  DateFormatComponent::formatDate2Local($saleBillData[0]['PharmacySalesBill']['create_time'],Configure::read('date_format'),true);
		$patientName = $getPatientDetails['Patient']['lookup_name'];
		$narration = "Being pharmacy charged to pt. $patientName (Date of Registration $regDate ) done on $doneDate";
		
		$jvData = array('date'=> $saleBillData[0]['PharmacySalesBill']['create_time'],
				'user_id'=>$accountId,
				'account_id'=>$userId,
				'debit_amount'=>$finalAmount,
				'type'=>'PharmacyCharges',
				'narration'=>$narration,
				'created_by'=>$session->read('userid'),
				'patient_id'=>$patient_id);
		if(!empty($jvData['debit_amount']) && ($jvData['debit_amount'] != 0)){
		$voucherEntry->insertJournalEntry($jvData);
		$voucherEntry->id= '';

		// ***insert into Account (By) credit manage current balance
		$accountObj->setBalanceAmountByAccountId($accountId,$finalAmount,'debit');
		$accountObj->setBalanceAmountByUserId($userId,$finalAmount,'credit');
		}
                }//end of temp reg
	}
	
	
	//BOF for sum of paid amount and discount amount, return patient wise service name by amit jain
	function getPharmacyCharges($patientId=null,$date=null,$userId=null){
		$session     = new cakeSession();
		if(!$patientId) return false ;
		$serviceCategoryObj = ClassRegistry::init('ServiceCategory');
		$serviceId = $serviceCategoryObj->getServiceGroupId('pharmacyservices',$session->read('locationid'));
		$this->unBindModel(array(
				'hasMany' => array('PharmacySalesBillDetail')));
		$this->bindModel(array(
				'belongsTo' => array(
						'ServiceCategory' =>array('foreignKey' => false,'conditions'=>array('ServiceCategory.id'=>$serviceId)),
						'Billing' =>array('foreignKey' => false,'conditions'=>array('PharmacySalesBill.billing_id=Billing.id')))),false);
		$amountDetails = $this->find(all,array('conditions'=>array('PharmacySalesBill.is_deleted'=>'0',
				'PharmacySalesBill.patient_id'=>$patientId,'PharmacySalesBill.paid_amnt NOT'=>'0','DATE_FORMAT(Billing.date,"%Y-%m-%d")'=>$date,'Billing.created_by'=>$userId,'Billing.mode_of_payment'=>'Cash'),
				'fields'=>array('SUM(PharmacySalesBill.paid_amnt) as TotalAmount','SUM(PharmacySalesBill.discount) as TotalDiscount','ServiceCategory.name')));
		return $amountDetails ;
	}
	//EOF
	
	//function to return pharmacy charges excluding return charges
	function  getPatientPharmacyCharges($patient_id=null,$conditions=NULL,$superBillId=NULL){
		$session = new cakeSession();
	
		if(!$patient_id) return false ;
		$this->unBindModel(array('hasMany' => array('PharmacySalesBillDetail')));
		$InventoryPharmacySalesReturnObj = ClassRegistry::init('InventoryPharmacySalesReturn');
		$this->recursive = -1 ;
		$pharmacySaleData= $this->find('all',array(
				'fields'=> array('PharmacySalesBill.patient_id','PharmacySalesBill.corporate_super_bill_id','SUM(PharmacySalesBill.total) as pharmacyTotal',
						'SUM(PharmacySalesBill.discount) as discount','SUM(PharmacySalesBill.paid_amnt) as paidAmt'),
				'conditions'=>array('PharmacySalesBill.patient_id'=>$patient_id,'PharmacySalesBill.is_deleted'=>0,$conditions),
				'group'=>array('PharmacySalesBill.patient_id')));
	
		foreach ($pharmacySaleData as $key => $value){
			$pharmacySalesTotal 	= $value[0]['pharmacyTotal'] ;
			$pharmacySalesDiscount 	= $value[0]['discount'] ;
			$pharmacySalesPaidAmt   = $value[0]['paidAmt'] ;
			$pharmacyDataArray[$value['PharmacySalesBill']['patient_id']]['total']= $pharmacySalesTotal ;
			$pharmacyDataArray[$value['PharmacySalesBill']['patient_id']]['discount']= $pharmacySalesDiscount ;
			$pharmacyDataArray[$value['PharmacySalesBill']['patient_id']]['paid_amount']= $pharmacySalesPaidAmt ;
			$pharmacyDataArray[$value['PharmacySalesBill']['patient_id']]['corporate_super_bill_id'] = $value['PharmacySalesBill']['corporate_super_bill_id'];
		}
	
		$InventoryPharmacySalesReturnObj->unBindModel(array('hasMany'=>array('InventoryPharmacySalesReturnsDetail'),'belongsTo'=>array('Patient')));
		$salesReturnTotal = $InventoryPharmacySalesReturnObj->find('all',
				array('fields'=>array('SUM(InventoryPharmacySalesReturn.total) as sumTotal','InventoryPharmacySalesReturn.patient_id',
						'SUM(InventoryPharmacySalesReturn.discount) as sumReturnDiscount'),
						'conditions'=>array('InventoryPharmacySalesReturn.patient_id'=>$patient_id,
								'InventoryPharmacySalesReturn.is_deleted'=>'0'),
						'group'=>array('InventoryPharmacySalesReturn.patient_id')));
	
		foreach ($salesReturnTotal as $key => $value){
			$pharmacySalesTotal 	= $value[0]['sumTotal'] ;
			$pharmacySalesDiscount 	= $value[0]['sumReturnDiscount'] ;
			$pharmacyDataArray[$value['InventoryPharmacySalesReturn']['patient_id']]['return']= $pharmacySalesTotal ;
			$pharmacyDataArray[$value['InventoryPharmacySalesReturn']['patient_id']]['returnDiscount']= $pharmacySalesDiscount ;
		}
	
		$InventoryPharmacySalesReturnObj->unBindModel(array('hasMany'=>array('InventoryPharmacySalesReturnsDetail'),'belongsTo'=>array('Patient')));
		$salesReturnPaidTotal = $InventoryPharmacySalesReturnObj->find('all',
				array('fields'=>array('SUM(InventoryPharmacySalesReturn.total-InventoryPharmacySalesReturn.discount) as sumTotal','InventoryPharmacySalesReturn.patient_id',
						'SUM(InventoryPharmacySalesReturn.discount) as sumReturnDiscount'),
						'conditions'=>array('InventoryPharmacySalesReturn.patient_id'=>$patient_id,
								'InventoryPharmacySalesReturn.billing_id NOT'=>NULL,
								'InventoryPharmacySalesReturn.is_deleted'=>'0'),
						'group'=>array('InventoryPharmacySalesReturn.patient_id')));
	
		foreach ($salesReturnPaidTotal as $key => $value){
			$pharmacyRetSalesTotal 	= $value[0]['sumTotal'] ;
			$pharmacyRetSalesDiscount 	= $value[0]['sumReturnDiscount'] ;
			$pharmacyDataArray[$value['InventoryPharmacySalesReturn']['patient_id']]['returnPaid']= $pharmacySalesTotal ;
			$pharmacyDataArray[$value['InventoryPharmacySalesReturn']['patient_id']]['returnDiscountPaid']= $pharmacySalesDiscount ;
		}
			
		return $pharmacyDataArray;
	}
	
	function pharmacyServicesUpdate($serviceData,$encId,$catKey,$billId,$percent,$modified){
		$session = new cakeSession();
		$InventoryPharmacySalesReturnObj = ClassRegistry::init('InventoryPharmacySalesReturn');
		$modified_by=$session->read('userid');
		$this->unbindModel(array(
				'hasMany'=>array('PharmacySalesBillDetail')),false);
		foreach($serviceData as $serviceKey=>$eachData){//debug($serviceData);exit;
			$singleServiceData='';
			$singleServiceData=$this->find('all',
					array('fields'=>array('PharmacySalesBill.id','PharmacySalesBill.total',
							'PharmacySalesBill.paid_amnt','PharmacySalesBill.discount'),
							'conditions'=>array('PharmacySalesBill.patient_id'=>$encId,
									'OR'=>array(array("PharmacySalesBill.billing_id"=>'0'),array("PharmacySalesBill.billing_id"=>NULL)),
									'OR'=>array(array("PharmacySalesBill.paid_amnt"=>'0'),array("PharmacySalesBill.paid_amnt"=>NULL)))));
			foreach($singleServiceData as $phar){//debug($phar);
				$amtToPay=0;$serDiscount=0;$serpaid=0;$balAmt=0;
	
				$billTariffId[$catKey][]=$phar['PharmacySalesBill']['id']; //tariff_list_id serialize array
	
				$balAmt=$phar['PharmacySalesBill']['total']-$phar['PharmacySalesBill']['paid_amnt']-$phar['PharmacySalesBill']['discount'];
				$amtToPay=($balAmt*$percent)/100;
	
				$serpaid=$amtToPay+$phar['PharmacySalesBill']['paid_amnt'];
	
				$serDiscount=$phar['PharmacySalesBill']['total']-($serpaid);
	
				$this->updateAll(
						array('PharmacySalesBill.paid_amnt'=>"'$serpaid'",
								'PharmacySalesBill.discount'=>"'$serDiscount'",
								'PharmacySalesBill.billing_id'=>"'$billId'",
								'PharmacySalesBill.modified_by'=>"'$modified_by'",
								'PharmacySalesBill.modified_time'=>"'$modified'"),
						array('PharmacySalesBill.id'=>$phar['PharmacySalesBill']['id'],
								'PharmacySalesBill.patient_id'=>$encId));
			}
	
			$return=$InventoryPharmacySalesReturnObj->find('all',array('fields'=>array('InventoryPharmacySalesReturn.id','InventoryPharmacySalesReturn.patient_id'),
					'conditions'=>array('InventoryPharmacySalesReturn.patient_id'=>$encId,'InventoryPharmacySalesReturn.billing_id'=>NULL)));
			foreach($return as $returndata){
				$InventoryPharmacySalesReturnObj->updateAll(
						array('InventoryPharmacySalesReturn.billing_id'=>"'$billId'",
								'InventoryPharmacySalesReturn.modified_by'=>"'$modified_by'",
								'InventoryPharmacySalesReturn.modified_time'=>"'$modified'"),
						array('InventoryPharmacySalesReturn.patient_id'=>$encId,'InventoryPharmacySalesReturn.id'=>$returndata['InventoryPharmacySalesReturn']['id']));
			}
		}
		return $billTariffId;
	}


	public function patientPharmacySalesBillDetail($patientId){
		$patient = Classregistry::init('Patient');
		$pharmacyItem = Classregistry::init('PharmacyItem');
		$patientInitial = Classregistry::init('PatientInitial');
		$salebillDetail = Classregistry::init('PharmacySalesBillDetail');
		$session = new cakeSession();
		
		$saleDetail = $salebillDetail->find('all',array(
											'conditions'=>array("PharmacySalesBill.location_id" =>$session->read('locationid'),
																'PharmacySalesBill.is_deleted' =>'0','PharmacySalesBill.patient_id'=>$patientId),
											'fields'=>array('PharmacySalesBill.*','PharmacySalesBillDetail.*','PharmacyItem.id','PharmacyItem.name','PharmacyItem.generic'))); 
		 
		return $saleDetail;
	}
}
?>