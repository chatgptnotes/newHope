<?php 

class OtPharmacySalesBill extends AppModel {
	public $patient ;
	public $name = 'OtPharmacySalesBill';
	public $useTable= 'ot_pharmacy_sales_bills';
	
	public $hasMany = array(
			'OtPharmacySalesBillDetail' => array(
					'className' => 'OtPharmacySalesBillDetail',
					'dependent' => true,
					'foreignKey' => 'Ot_pharmacy_sales_bill_id',
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
	
	public function getPatientDetails($patient_id){
		
		$this->patient = $patient_id;
		$sale_details = $this->find('all',array("conditions"=>array("OtPharmacySalesBill.patient_id"=>$patient_id,'OtPharmacySalesBill.is_deleted'=>'0')));
		if(count($sale_details)>0){
			return $sale_details ;
		}else{
			return false;
		}
	}
	
	public function getCreditAmount($sales_bill_details){ 
		$credit_amount = 0;
		foreach($sales_bill_details as $key =>$value){
			if($value['OtPharmacySalesBill']['payment_mode'] == "Credit")
				$credit_amount = $credit_amount+$value['OtPharmacySalesBill']['total'];
		}
		return $credit_amount;
	}
	
	/**
	 * for getting otpharmacy data
	 * @param unknown_type $patient_id
	 * @return Ambigous <multitype:, NULL, mixed>
	 * @yashwant
	 */
	public function getOtPharmacyData($patient_id){
		$OtPharmacyData=$this->find('all',array('fields'=>array('OTPharmacySalesBill.*'),
				'conditions'=>array('OTPharmacySalesBill.patient_id'=>$patient_id,'OTPharmacySalesBill.is_deleted'=>'0')));
		return $OtPharmacyData;
	}
	
	//BOF for sum of paid amount and discount amount, return patient wise service name by amit jain
	function getOTPharmacyCharges($patientId=null,$date=null,$userId=null){
		$session     = new cakeSession();
		if(!$patientId) return false ;
		$this->unBindModel(array(
				'hasMany' => array('OtPharmacySalesBillDetail')));
		$this->bindModel(array(
				'belongsTo' => array(
						'Billing' =>array('foreignKey' => false,'conditions'=>array('OTPharmacySalesBill.billing_id=Billing.id')))),false);
		$amountDetails = $this->find(all,array('conditions'=>array('OTPharmacySalesBill.is_deleted'=>'0',
				'OTPharmacySalesBill.patient_id'=>$patientId,'OTPharmacySalesBill.paid_amount NOT'=>'0','DATE_FORMAT(Billing.date,"%Y-%m-%d")'=>$date,'Billing.created_by'=>$userId,'Billing.mode_of_payment'=>'Cash'),
				'fields'=>array('SUM(OTPharmacySalesBill.paid_amount) as TotalAmount','SUM(OTPharmacySalesBill.discount) as TotalDiscount')));
		return $amountDetails ;
	}
	//EOF
	
	/*
	 * fucntion to return OT sales bill charges substracting return charges for patients
	*/
	public function getPatientOtPharmacyCharges($patient_id=null,$conditions=NULL,$superBillId=NULL){
			
		if(!$patient_id) return false ;
		$otPharmacySalesReturnObj = ClassRegistry::init('OtPharmacySalesReturn');
		$this->unBindModel(array('hasMany'=>array('OtPharmacySalesBillDetail'),'belongsTo'=>array('Patient','Doctor','Initial')));
		$otPharmacySalesBillData= $this->find('all',array(
				'fields'=> array('OtPharmacySalesBill.patient_id','SUM(OtPharmacySalesBill.total) as pharmacyTotal',
						'SUM(OtPharmacySalesBill.discount) as discount','SUM(OtPharmacySalesBill.paid_amount) as paidAmt'),
				'conditions'=>array('OtPharmacySalesBill.patient_id'=>$patient_id,'OtPharmacySalesBill.is_deleted'=>0),
				'group'=>array('OtPharmacySalesBill.patient_id')));
			
		$pharmacyDataArray =array();
		foreach ($otPharmacySalesBillData as $key => $value){
			$pharmacySalesTotal 	= $value[0]['pharmacyTotal'] ;
			$pharmacySalesDiscount 	= $value[0]['discount'] ;
			$pharmacySalesPaidAmt   = $value[0]['paidAmt'] ;
			$pharmacyDataArray[$value['OtPharmacySalesBill']['patient_id']]['total']= $pharmacySalesTotal ;
			$pharmacyDataArray[$value['OtPharmacySalesBill']['patient_id']]['paid_amount']= $pharmacySalesPaidAmt ;
			$pharmacyDataArray[$value['OtPharmacySalesBill']['patient_id']]['discount']= $pharmacySalesDiscount ;
		}
	
		$otPharmacySalesReturnObj->unBindModel(array('hasMany'=>array('OtPharmacySalesReturnDetail'),'belongsTo'=>array('Patient')));
		$otSalesReturnTotal = $otPharmacySalesReturnObj->find('all',
				array('fields'=>array('OtPharmacySalesReturn.patient_id','SUM(OtPharmacySalesReturn.total) as sumTotal',
						'SUM(OtPharmacySalesReturn.discount) as sumReturnDiscount'),
						'conditions'=>array('OtPharmacySalesReturn.patient_id'=>$patient_id,'OtPharmacySalesReturn.is_deleted'=>'0'),
						'group'=>array('OtPharmacySalesReturn.patient_id')));
			
		$otPharmacySalesTotal = $otPharmacySalesBillTotal-($otSalesReturnTotal[0]['sumTotal']/* -$otSalesReturnTotal[0]['sumReturnDiscount'] */);
	
		foreach ($otSalesReturnTotal as $key => $value){
			$pharmacySalesTotal 	= $value[0]['sumTotal'] ;
			$pharmacySalesDiscount 	= $value[0]['sumReturnDiscount'] ;
			$pharmacyDataArray[$value['OtPharmacySalesReturn']['patient_id']]['return']= $pharmacySalesTotal ;
			$pharmacyDataArray[$value['OtPharmacySalesReturn']['patient_id']]['returnDiscount']= $pharmacySalesDiscount ;
		}
	
		$otPharmacySalesReturnObj->unBindModel(array('hasMany'=>array('OtPharmacySalesReturnDetail'),'belongsTo'=>array('Patient')));
		$otSalesReturnTotal = $otPharmacySalesReturnObj->find('all',
				array('fields'=>array('OtPharmacySalesReturn.patient_id','SUM(OtPharmacySalesReturn.total-OtPharmacySalesReturn.discount) as sumTotal',
						'SUM(OtPharmacySalesReturn.discount) as sumReturnDiscount'),
						'conditions'=>array('OtPharmacySalesReturn.patient_id'=>$patient_id,
								'OtPharmacySalesReturn.billing_id NOT'=>NULL,
								'OtPharmacySalesReturn.is_deleted'=>'0'),
						'group'=>array('OtPharmacySalesReturn.patient_id')));
			
		$otPharmacySalesTotal = $otPharmacySalesBillTotal-($otSalesReturnTotal[0]['sumTotal']/* -$otSalesReturnTotal[0]['sumReturnDiscount'] */);
	
		foreach ($otSalesReturnTotal as $key => $value){
			$pharmacySalesTotal 	= $value[0]['sumTotal'] ;
			$pharmacySalesDiscount 	= $value[0]['sumReturnDiscount'] ;
			$pharmacyDataArray[$value['OtPharmacySalesReturn']['patient_id']]['returnPaid']= $pharmacySalesTotal ;
			$pharmacyDataArray[$value['OtPharmacySalesReturn']['patient_id']]['returnDiscountPaid']= $pharmacySalesDiscount ;
		}
	
		return $pharmacyDataArray;
	}
	
	function otPharmacyServicesUpdate($serviceData,$encId,$catKey,$billId,$percent,$modified){
		$session = new cakeSession();
		$OtPharmacySalesReturnObj = ClassRegistry::init('OtPharmacySalesReturn');
		$modified_by=$session->read('userid');
		$this->unbindModel(array('hasMany'=>array('OtPharmacySalesBillDetail')),false);
		foreach($serviceData as $serviceKey=>$eachData){//debug($serviceData);exit;
			$singleServiceData='';
			$singleServiceData=$this->find('all',
					array(
							'fields'=>array('OtPharmacySalesBill.id','OtPharmacySalesBill.total',
									'OtPharmacySalesBill.paid_amount','OtPharmacySalesBill.discount'),
							'conditions'=>array('OtPharmacySalesBill.patient_id'=>$encId,
									'OR'=>array(array("OtPharmacySalesBill.billing_id"=>'0'),
											array("OtPharmacySalesBill.billing_id"=>NULL)),
									'OR'=>array(array("OtPharmacySalesBill.paid_amount"=>'0'),
											array("OtPharmacySalesBill.paid_amount"=>NULL)))));
	
			foreach($singleServiceData as $phar){//debug($phar);exit;
				$amtToPay=0;$serDiscount=0;$serpaid=0;$balAmt=0;
	
				$billTariffId[$catKey][]=$phar['OtPharmacySalesBill']['id']; //tariff_list_id serialize array
				$balAmt=$phar['OtPharmacySalesBill']['total']-$phar['OtPharmacySalesBill']['paid_amount']-$phar['OtPharmacySalesBill']['discount'];
				$amtToPay=($balAmt*$percent)/100;
				$serpaid=$amtToPay+$phar['OtPharmacySalesBill']['paid_amount'];
	
				$serDiscount=$phar['OtPharmacySalesBill']['total']-($serpaid);
				$this->updateAll(
						array('OtPharmacySalesBill.paid_amount'=>"'$serpaid'",
								'OtPharmacySalesBill.discount'=>"'$serDiscount'",
								'OtPharmacySalesBill.billing_id'=>"'$billId'",
								'OtPharmacySalesBill.modified_by'=>"'$modified_by'",
								'OtPharmacySalesBill.modified_time'=>"'$modified'"),
						array('OtPharmacySalesBill.id'=>$phar['OtPharmacySalesBill']['id'],
								'OtPharmacySalesBill.patient_id'=>$encId));
			}
	
			$return=$OtPharmacySalesReturnObj->find('all',array('fields'=>array('OtPharmacySalesReturn.id',
					'OtPharmacySalesReturn.patient_id'),
					'conditions'=>array('OtPharmacySalesReturn.patient_id'=>$encId,
							'OtPharmacySalesReturn.billing_id'=>NULL)));
	
			foreach($return as $returndata){
				$OtPharmacySalesReturnObj->updateAll(
						array('OtPharmacySalesReturn.billing_id'=>"'$billId'",
								'OtPharmacySalesReturn.modified_by'=>"'$modified_by'",
								'OtPharmacySalesReturn.modified_time'=>"'$modified'"),
						array('OtPharmacySalesReturn.patient_id'=>$encId,
								'OtPharmacySalesReturn.id'=>$returndata['OtPharmacySalesReturn']['id']));
			}
		}
		return $billTariffId;
	}
}


?>