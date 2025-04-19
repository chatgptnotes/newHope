<?php 
/**
 *CouponGenration model
 *
 * PHP 5
 *
 * @copyright     ----
 * @link          http://www.drmhope.com/
 * @package       CouponTransaction Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Swati Newale
 */
class CouponTransaction extends AppModel {

	public $name = 'CouponTransaction';
	var $useTable = 'coupon_transactions';
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

	/**
	 * function to coupon transaction 
	 * @param array $data
	 * @return boolean
	 * @author Swati Newale
	 */
	public function setCouponTransaction($patientId,$couponName){ 
		$session = new cakeSession (); 
			$coupon = Classregistry::init('Coupon')->find('first',array('fields'=>array('Coupon.id','Coupon.coupon_amount'),'conditions' =>array('Coupon.batch_name'=>$couponName)));	
			$couponData['coupon_id']=$coupon['Coupon']['id'];
			$couponData['amount']=$coupon['Coupon']['coupon_amount'];
			$couponData['patient_id']=$patientId;
			$couponData['type']='deposit';
			$couponData['location_id']= $session->read('locationid');
			$couponData['created_time']=  date("Y-m-d H:i:s");
			$couponData['created_by']= $session->read('userid');
			$this->save($couponData);
			$updateCoupon['id'] = $coupon['Coupon']['id'];
			$updateCoupon['status'] = '2';
			Classregistry::init('Coupon')->save($updateCoupon);
		
	}

	/**
	 * function to get all transaction record for a coupon
	 * @author swati
	 */
	public function getCouponTransactions($patientId){
		$session = new cakeSession ();
		return $this->find('all',array('conditions'=>array('patient_id'=>$patientId,'is_deleted'=>0,'location_id'=>$session->read('locationid'))));
	}
	
	/**
	 * function to give coupon discount on OPD registration
	 * @author Swatin
	 */
 function ApplyCouponDiscount($patientId,$couponAmount)
    {
    	$session = new cakeSession ();
    	$ServiceBill = Classregistry::init('ServiceBill');
    	$Billing = Classregistry::init('Billing');
    	$discAmt = 0;
    	$couponServiceAmt = 0;	
    	$discountService = $ServiceBill->find('all',array('fields'=>array('id','patient_id','service_id','amount','paid_amount'),
    			'conditions'=>array('patient_id'=>$patientId),'order'=>'id DESC'));
    	foreach($discountService as $key =>$val){
    		$couponServiceAmt = $couponServiceAmt + $val['ServiceBill']['amount'];
    	}
    	
    	if (strpos($couponAmount,'%') == true){
    		$couponAmt = explode('%',$couponAmount);
    		$couponAmt[1] = '%';
    		$perSentAmt = ($discountService[0]['ServiceBill']['amount']/100)*$couponAmt[0];
    		$couponAmt[0] = $perSentAmt;
    		$pending = $couponServiceAmt -  $perSentAmt;
    	}else{
    		$couponAmt = explode('.',$couponAmount);
    		$pending = $couponServiceAmt -  $couponAmt['0'];
    		$couponAmt[0] = $couponAmt['0'];
    	}
    	$tariff_list_id[Configure::read('mandatoryservices')][] = $service['ServiceBill']['id'];
    	
    	$ServiceBill->updateAll(array('ServiceBill.discount'=>"'".$couponAmt[0]."'"/* ,'ServiceBill.paid_amount'=>"'".$pending."'" */),
    			array('ServiceBill.id'=>$discountService['0']['ServiceBill']['id']));
    	
    	if($couponAmt[0] > 0){
    		$serSrArray = serialize($tariff_list_id);
    		$couponBillArrayData['patient_id'] = $patientId;
    		$couponBillArrayData['tariff_list_id'] = $serSrArray;
    		$couponBillArrayData['location_id'] = $session->read('locationid');
    		$couponBillArrayData['date'] = date('Y-m-d H:i:s');
    		$couponBillArrayData['payment_category'] = 'Finalbill';
    		$couponBillArrayData['amount'] = '0';
    		$couponBillArrayData['mode_of_payment'] = 'Cash';
    		$couponBillArrayData['total_amount'] = $couponServiceAmt;
    		$couponBillArrayData['amount_pending'] = $pending;
    		$couponBillArrayData['create_time'] = date("Y-m-d H:i:s");
    		$couponBillArrayData['discount'] = $couponAmt[0];
    		$couponBillArrayData['created_by']= $session->read('userid');
    		$couponBillArrayData['discount_type']= 'Coupon';
    		$Billing->save($couponBillArrayData);
    		//$Billing->addPartialPaymentJV($couponBillArrayData,$patientId);
    		$billingId = $Billing->id;
    		$Billing->id = '';
 
    	}
    }
	/**
	 * function to give coupon discount on other Group(Clinical services)
	 * @author Swatin $patient_id,$date,$groupId,$totalPayment,$totDis
	 */
	public function ApplyCouponDiscountOnService($patientId,$date,$groupId,$totalPayment,$totDis,$serviceBillID,$coupon){
		$session = new cakeSession ();
		$ServiceBill = Classregistry::init('ServiceBill');
		$Billing = Classregistry::init('Billing');
		$ConsultantBilling = Classregistry::init('ConsultantBilling');
		$Coupon = Classregistry::init('Coupon');
		$ServiceCategory = Classregistry::init('ServiceCategory');	

		$serviceCategorys = $ServiceCategory->find('list', array('conditions'=>array('ServiceCategory.is_deleted'=>0,'ServiceCategory.is_view'=>1,'ServiceCategory.alias IS not null','ServiceCategory.location_id !='=>'23','ServiceCategory.service_type !='=>''),
				'fields'=>array('ServiceCategory.id','ServiceCategory.alias')));

		$couponDetails  = $Coupon->find('first',array('conditions'=>array('Coupon.batch_name'=>$coupon),'fields'=>array('id','batch_name','sevices_available','coupon_amount')));
				
		$sevicesAvailable = explode(',',$couponDetails['Coupon']['sevices_available']);
	           $couponAMT = unserialize($couponDetails['Coupon']['coupon_amount']);
	            $Coupontype = $couponAMT[$groupId]['type'];
	            $CoupontypeAmount = $couponAMT[$groupId]['value'];
	    
  
        $discAmt = 0;
		if($Coupontype == 'Percentage'){
			$perSentAmt = ($totalPayment/100)*$CoupontypeAmount;
			$pending = $totalPayment - $perSentAmt;
			$discAmt = $perSentAmt;
		}else if($Coupontype == 'Amount'){
			$pending = $totalPayment - $CoupontypeAmount;
			$discAmt = $CoupontypeAmount;
		}
				
		$tariff_list_id[$serviceCategorys[$groupId]][] = $serviceBillID;		
			if(in_array($groupId, $sevicesAvailable) and $totalPayment > 0){ 
		                     $tariff_list_id[$serviceCategorys[$groupId]][] = $serviceBillID;		
						    $ServiceBill->updateAll(array('ServiceBill.discount'=>"'".round($discAmt)."'"),array('ServiceBill.id'=>$serviceBillID));
			} 
			if($discAmt > 0 ){
			$serSrArray=serialize($tariff_list_id);
			$couponBillArrayData['patient_id']= $patientId;
			$couponBillArrayData['tariff_list_id'] = $serSrArray;
			$couponBillArrayData['location_id']= $session->read('locationid');
			$couponBillArrayData['date']= $date;
			$couponBillArrayData['payment_category']= $groupId ;
			$couponBillArrayData['amount']='0';
			$couponBillArrayData['total_amount']= $totalPayment;
			$couponBillArrayData['amount_pending']= $totalPayment-$discAmt;
			$couponBillArrayData['create_time']=date("Y-m-d H:i:s");
			$couponBillArrayData['discount'] = $discAmt;
			$couponBillArrayData['created_by']=$session->read('userid');
			$couponBillArrayData['discount_type']= 'Coupon';
			$Billing->save($couponBillArrayData);
			//debug($couponBillArrayData);exit;
			//$this->Billing->addPartialPaymentJV($couponBillArrayData,$couponBillArrayData['patient_id']);
			$billingId = $Billing->id;
			$Billing->id = '';
		}
	}
}
?>