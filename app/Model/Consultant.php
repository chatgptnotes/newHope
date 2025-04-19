<?php
/**
 * ConsultantModel file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Consultant.Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Santosh R. Yadav
 */
class Consultant extends AppModel {

	public $name = 'Consultant';
/**
 * Consultant table binding with cities , states, countries and initials tables
 *
 */	
        public $virtualFields = array(
    							'full_name' => 'CONCAT(Consultant.first_name, " ", Consultant.last_name)'
							);
        public $belongsTo = array('City' => array('className'    => 'City',
                                                  'foreignKey'    => 'city_id'
                                                 ),
                                  'State' => array('className'    => 'State',
                                                   'foreignKey'    => 'state_id'
                                                 ),
                                  'Country' => array('className'    => 'Country',
                                                     'foreignKey'    => 'country_id'
                                                 ),
                                  'Initial' => array('className'    => 'Initial',
                                                     'foreignKey'    => 'initial_id'
                                                 ),
					        	  'MarketingTeam' => array('className'    => 'MarketingTeam',
					        				'foreignKey'    => 'market_team'
					        		) 
					                                  
                                 );
/**
 * server side validation
 *
 */ 
		
	public $validate = array(
              /*  'initial_id' => array(
			'rule' => "notEmpty",
			'message' => "Please select hospital name."
			),*/
                'refferer_doctor_id' => array(
			'rule' => "notEmpty",
			'message' => "Please select refering doctor."
			),
		  'first_name' => array(
			'rule' => "notEmpty",
			'message' => "Please enter name."
			),
                'last_name' => array(
			'rule' => "notEmpty",
			'message' => "Please enter name."
			),
		
//                 'hospital_name' => array(
// 			'rule' => "notEmpty",
// 			'message' => "Please enter contact person."
// 			),
//                 'charges' => array(
// 			'rule' => "notEmpty",
// 			'message' => "Please enter charges."
// 			),
//                 'education' => array(
// 			'rule' => "notEmpty",
// 			'message' => "Please enter education."
// 			),
//                 'specility_keyword' => array(
// 			'rule' => "notEmpty",
// 			'message' => "Please enter specility keyword."
// 			),
//                 'experience' => array(
// 			'rule' => "notEmpty",
// 			'message' => "Please enter experience."
// 			),
//                 'dateofbirth' => array(
// 			'rule' => "notEmpty",
// 			'message' => "Please enter date of birth."
// 			),
//                 'profile_description' => array(
// 			'rule' => "notEmpty",
// 			'message' => "Please enter maximum locations."
// 			)
                
                );

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
 * assign some value befor save function
 *
 */	
        public function beforeSave() {
               if(empty($this->data['Consultant']['id'])) {
                 $this->data['Consultant']['created_by'] = AuthComponent::user('id');;
                 $this->data['Consultant']['create_time'] = date("Y-m-d H:i:s");
               }
               if(!empty($this->data['Consultant']['id'])) {
                 $this->data['Consultant']['modified_by'] = AuthComponent::user('id');;
                 $this->data['Consultant']['modify_time'] = date("Y-m-d H:i:s");
               }
               if (isset($this->data[$this->alias]['first_name'])) {
                        $this->data[$this->alias]['first_name'] = ucfirst($this->data[$this->alias]['first_name']);
               }
	           if (isset($this->data[$this->alias]['middle_name'])) {
                        $this->data[$this->alias]['middle_name'] = ucfirst($this->data[$this->alias]['middle_name']);
               }   
	           if (isset($this->data[$this->alias]['last_name'])) {
                        $this->data[$this->alias]['last_name'] = ucfirst($this->data[$this->alias]['last_name']);
               }  
               return true;
        }

	public function getConsultant(){
      	App::import('Model', 'CakeSession');
		$session = new CakeSession(); 
        $this->virtualFields = array(
    							'full_name' => 'CONCAT(Initial.name, " ", Consultant.first_name, " ", Consultant.last_name)'
							);
       

        $this->bindModel(array('belongsTo' => array('ReffererDoctor' => array('className' => 'ReffererDoctor', 'foreignKey'=> 'refferer_doctor_id'))));

      $this->find('list',array('fields'=>array('id','full_name'),
      	'conditions'=>array('ReffererDoctor.is_referral'=>'N', 'Consultant.is_deleted'=>0,'Consultant.location_id'=>$session->read('locationid')), 'order' => array('Consultant.first_name'), 'recursive' => 1));

	}
      
	public function getConsultantWithDeleted(){
      	App::import('Model', 'CakeSession');
		$session = new CakeSession(); 
        $this->virtualFields = array(
    							'full_name' => 'CONCAT(Initial.name, " ", Consultant.first_name, " ", Consultant.last_name)'
							);
        $this->bindModel(array('belongsTo' => array('ReffererDoctor' => array('className' => 'ReffererDoctor', 'foreignKey'=> 'refferer_doctor_id'))));

      	return $this->find('list',array('fields'=>array('id','full_name'),
      	'conditions'=>array('ReffererDoctor.is_referral'=>'N', 'Consultant.location_id'=>$session->read('locationid')), 'order' => array('Consultant.first_name'), 'recursive' => 1));
      }
      
      public function getConsultantByID($consultant_id=null){      
                if(!empty($consultant_id)){		
      			return $this->read('full_name',$consultant_id);
      		}
      }
      
	public function getChargesByID($consultant_id=null){      
      		if(!empty($consultant_id)){		
      			return $this->read('charges',$consultant_id);
      		}
      }
      
      public function getConsultantCharges($consultant_id=null,$charges_type=null){
      	if(!empty($consultant_id) ){	
      		$charges = $this->find('first',array('fields'=>array('charges','surgery_charges','other_charges','anaesthesia_charges'),'conditions'=>array('Consultant.id'=>$consultant_id)));
      		return $charges;
      	}
      }
      
      public function getConsultantList($charges_type){
      	App::import('Model', 'CakeSession');
		$session = new CakeSession(); 
        $this->virtualFields = array(
    							'full_name' => 'CONCAT(Initial.name, " ", Consultant.first_name, " ", Consultant.last_name)'
							);
      	return $this->find('list',array('fields'=>array('id','full_name'),
      	'conditions'=>array('is_deleted'=>0,'location_id'=>$session->read('locationid'),'charges_type'=>$charges_type), 'order' => array('Consultant.first_name'), 'recursive' => 1));
      }
/**
 * get only external consultant listing
 *
**/
      public function getExeternalConsultant(){
        $this->virtualFields = array(
    							'full_name' => 'CONCAT(Initial.name, " ", Consultant.first_name, " ", Consultant.last_name)'
							);
      	$this->bindModel(array('belongsTo' => array('ReffererDoctor' => array('className' => 'ReffererDoctor', 'foreignKey'=> 'refferer_doctor_id'))));
      	return $this->find('list',array('fields'=>array('full_name','id'),
      	'conditions'=>array('ReffererDoctor.name'=>'External Consultant', 'Consultant.is_deleted'=>0,'Consultant.location_id'=> AuthComponent::user('location_id')), 'order' => array('Consultant.first_name'), 'recursive' => 1));
      }
/**
 * get only registrar listing 
 *
**/
      public function getRegistrar(){
        $getRegistrar = Classregistry::init('DoctorProfile')->getRegistrar();
        return $getRegistrar;
      }
/**
 * get only refferer doctor listing
 *
**/
      public function getReffererDoctor(){
        $this->virtualFields = array(
    							'full_name' => 'CONCAT(Initial.name, " ", Consultant.first_name, " ", Consultant.last_name)'
							);
      	$this->bindModel(array('belongsTo' => array('ReffererDoctor' => array('className' => 'ReffererDoctor', 'foreignKey'=> 'refferer_doctor_id'))));
      	return $this->find('list',array('fields'=>array('id','full_name'),
      	'conditions'=>array('ReffererDoctor.name <>'=>'External Consultant', 'Consultant.is_deleted'=>0,'Consultant.location_id'=> AuthComponent::user('location_id')), 'order' => array('Consultant.first_name'), 'recursive' => 1));
      }

/**
* afterSave function for saving data in account table--Pooja
*
**/
    public function afterSave($id=null)
      {
      	//For generating account code for account table
      	 $session = new CakeSession();
      	$accountingGroup = Classregistry::init('AccountingGroup');
      	$getRegistrar = Classregistry::init('Account'); 
      	$count = $getRegistrar->find('count',array('conditions'=>array('Account.create_time like'=> "%".date("Y-m-d")."%",'Account.location_id'=>$session->read('locationid'))));
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
      	$unique_id   = 'CO';
      	$unique_id  .= ucfirst(substr($hospital,0,1)); //first letter of the hospital name
      	$unique_id  .= strtoupper(substr($session->read('location'),0,2));//first 2 letter of d location
      	$unique_id  .= date('y'); //year
      	$unique_id  .= $month_array[date('n')-1];//first letter of month
      	$unique_id  .= date('d');//day
      	$unique_id .= $count;
      	
      	$sundryCreditors = $accountingGroup->getAccountingGroupID(Configure::read('sundry_creditors'));
  
      	$var=$getRegistrar->find('first',array('fields'=>array('id','account_code','accounting_group_id'),'conditions'=>array('system_user_id'=>$this->data['Consultant']['id'],'user_type'=>'Consultant','Account.location_id'=>$session->read('locationid'))));
      	if($var!='')
      	{
      		//avoid delete updatation
	      	if($this->data['Consultant']['is_deleted']==1){
	      		$getRegistrar->updateAll(array('is_deleted'=>1), array('Account.system_user_id' => $this->data['Consultant']['id'],'Account.user_type'=>'Consultant','Account.location_id'=>$session->read('locationid')));
				return ;
			}
      		$this->data['Account']['id']=$var['Account']['id'];
      		$this->data['Account']['modified_time']=date("Y-m-d H:i:s");
      		if(empty($var['Account']['account_code']))
      		{
      			$this->data['Account']['account_code']=$unique_id;
      		}
      		if(empty($var['Account']['accounting_group_id']))
      		{
      			$this->data['Account']['accounting_group_id']=$sundryCreditors;
      		}
      	}else{
      		if($this->data['Consultant']['is_deleted']==1){
      			 return ; //return if delete 
      		}
      		$this->data['Account']['create_time']=date("Y-m-d H:i:s");
      		$this->data['Account']['account_code']=$unique_id;
      		$this->data['Account']['status']='Active';
      	}
      	$this->data['Account']['name']=$this->data['Consultant']['first_name']." ".$this->data['Consultant']['last_name'];
      	$this->data['Account']['user_type']='Consultant';
      	$this->data['Account']['system_user_id']=$this->data['Consultant']['id'];
      	$this->data['Account']['location_id']=$session->read('locationid');
      	$this->data['Account']['accounting_group_id']=$this->data['Consultant']['accounting_group_id'];
      	$getRegistrar->save($this->data['Account']);
       }
       
       public function sendToSmsMultipleDoctor($id,$mobile=null){     
       	$doctorModel = ClassRegistry::init('Consultant');
       	$messageModel = ClassRegistry::init('Message');
       	//$personModel = ClassRegistry::init('Person');
       	$TemplateSmsModel = ClassRegistry::init('TemplateSms');
       	$getHospitalName=$_SESSION['location_name'];
       
       	$templateSmsData = $TemplateSmsModel->find('first',array('fields'=>array('sms','patient_id'),'conditions'=>array('TemplateSms.id'=>$id)));
       	$getSmsDoctorIds=unserialize($templateSmsData['TemplateSms']['patient_id']);		//here doctor mob No
     
       	$getDoctorId=explode(',',$getSmsDoctorIds);
		
       	$getDoctorNameArr = array();
       
       	if(empty($mobile)){
       		$doctorData = $doctorModel->find('all',array('fields'=>array('Consultant.id','Consultant.full_name','Consultant.mobile'),
       				'conditions'=>array('Consultant.id'=>$getDoctorId,'Consultant.is_deleted'=>0)));
       		
       		foreach($doctorData as $keyFinal=>$getDoctorData){
       			$mobNo = $getDoctorData['Consultant']['mobile'];
       			$msgText=$templateSmsData['TemplateSms']['sms'].'.-'.Configure::read('hosp_details');
	       		$res = $messageModel->sendToSms($msgText,$mobNo);
	       	}
       	}else{
       		$mobNo = $mobile;
       		$msgText=$templateSmsData['TemplateSms']['sms'].'.-'.Configure::read('hosp_details');
       		$res = $messageModel->sendToSms($msgText,$mobNo);
       	}
     
	 
       	return $getDoctorNameArr; ///For Patient Name which is confirmed to  Sent SMS.
       
       }

	   /**
	 * function for send SMS to whovere we have to put Msg as well as Mobile no.
	 * @param unknown_type Message as well as Mobile no.
	 * @Mahalaxmi
	 */
	   public function findConsltantDetails($data=array()){			  
			$doctorModel = ClassRegistry::init('Consultant');
			return $doctorModel->find('all',array('fields'=>array('Consultant.id','Consultant.mobile','Consultant.first_name','Consultant.last_name'),'conditions'=>array('Consultant.id'=>$data,'Consultant.is_deleted'=>0),'order'=>array('Consultant.id')));			
	   }
	   
	   public function getReferralSpotBackingAmount($patientId,$consultantId){
			$serviceCategoryObj = ClassRegistry::init('ServiceCategory');
			$configurationObj = ClassRegistry::init('Configuration');
			$billingObj = ClassRegistry::init('Billing');
			$serviceBillObj = ClassRegistry::init('ServiceBill');
			$laboratoryTestOrderObj = ClassRegistry::init('LaboratoryTestOrder');
			$optAppointmentObj = ClassRegistry::init('OptAppointment');
			$pharmacySalesBillObj = ClassRegistry::init('PharmacySalesBill');
			$consultantBillingObj = ClassRegistry::init('ConsultantBilling');
			$radiologyTestOrderObj = ClassRegistry::init('RadiologyTestOrder');
			$patientObj = ClassRegistry::init('Patient');
			
			$ImplantId = $serviceCategoryObj->getServiceGroupId("Implant");
			$bloodId = $serviceCategoryObj->getServiceGroupId("Blood");
			
		   	$conProPercentage = $this->find('first',array('fields'=>array('id','profit_percentage','referal_spot_amount'),
		   						'conditions'=>array('Consultant.id'=>$consultantId)));
		   
		   //Final Bill and Billing charges calculations for profit referral
		   $pharmConfig = $configurationObj->getPharmacyServiceType();// to get pharmacy service type
		   
		   if($pharmConfig['addChargesInInvoice']=='yes'){
		   	$BillingAmt = $billingObj->find('first',array('fields'=>array('Billing.patient_id',
		   			'Sum(Billing.amount) as paid','Sum(Billing.paid_to_patient) as refund'),
		   			'conditions'=>array('Billing.patient_id'=>$patientId,'Billing.is_deleted'=>'0'),
		   			'group'=>array('Billing.patient_id')));
		   }else{
		   	$pharmacyCategoryId = $serviceCategoryObj->getPharmacyId();//in case need of pharmacy category ID
		   	$BillingAmt = $billingObj->find('first',array('fields'=>array('Billing.patient_id',
		   			'Sum(Billing.amount) as paid','Sum(Billing.paid_to_patient) as refund'),
		   			'conditions'=>array('Billing.patient_id'=>$patientId,'Billing.payment_category !='=>$pharmacyCategoryId,'Billing.is_deleted'=>'0'),
		   			'group'=>array('Billing.patient_id')));
		   }
		   
		   //Combine charges for blood and implant
		   $bloodImpAmt = $serviceBillObj->find('first',array('fields'=>array('ServiceBill.patient_id','ServiceBill.service_id','ServiceBill.no_of_times',
		   		'Sum(ServiceBill.amount * ServiceBill.no_of_times) as bloodCharges'),
		   		'conditions'=>array('ServiceBill.patient_id'=>$patientId,
		   				'ServiceBill.service_id'=>array($ImplantId['ServiceCategory']['id'],$bloodId['ServiceCategory']['id']),'ServiceBill.is_deleted'=>'0'),
		   		'group'=>array('ServiceBill.patient_id')));
		   
		   $labAmt = $laboratoryTestOrderObj->find('first',array('fields'=>array('LaboratoryTestOrder.patient_id',
		   		'Sum(LaboratoryTestOrder.amount) as labCharges','Sum(LaboratoryTestOrder.paid_amount) as labPaid'),
		   		'conditions'=>array('LaboratoryTestOrder.patient_id'=>$patientId,'LaboratoryTestOrder.is_deleted'=>'0'),
		   		'group'=>array('LaboratoryTestOrder.patient_id')));
		   
		   if($pharmConfig['addChargesInInvoice']=='yes'){
		   	$pharmacySalesBillObj->unbindModel(array('belongsTo'=>array('Patient')));
		   	$pharmacyAmt = $pharmacySalesBillObj->find('all',array('fields'=>array('PharmacySalesBill.patient_id',
		   			'Sum(PharmacySalesBill.total) as pharmacyCharges'),
		   			'conditions'=>array('PharmacySalesBill.patient_id'=>$patientId,'PharmacySalesBill.is_deleted'=>'0'),
		   			'group'=>array('PharmacySalesBill.patient_id')));
		   }
		   
		   $radiologyTestOrderObj->bindModel(array('belongsTo'=>array(
		   		'Radiology'=>array('foreignKey'=>false,'conditions'=>array('Radiology.id=RadiologyTestOrder.radiology_id')))));
		   
		   $radAmt = $radiologyTestOrderObj->find('first',array('fields'=>array('RadiologyTestOrder.patient_id',
		   		'Sum(RadiologyTestOrder.amount) as radCharges','Sum(RadiologyTestOrder.paid_amount) as radPaid'),
		   		'conditions'=>array('OR'=>array(array('Radiology.name LIKE'=>'CT%'),array('Radiology.name LIKE'=>'MRI%'),
		   				array('Radiology.name LIKE'=>'USG%')),'RadiologyTestOrder.patient_id'=>$patientId,'RadiologyTestOrder.is_deleted'=>'0'),
		   		'group'=>array('RadiologyTestOrder.patient_id')));
		   
		   $paidBill=$BillingAmt['0']['paid'];
		   $radioBill=$radAmt['0']['radCharges'];
		   $labBill=$labAmt['0']['labCharges'];
		   $bloodImpBill=$bloodImpAmt['0']['bloodCharges'];
		   $pharBill=$pharmacyAmt['0']['pharmacyCharges'];
		  
		   if(!empty($paidBill)){
		   		$excludingExpenses=$paidBill-($radioBill+$labBill+$bloodImpBill+$pharBill);
			   	if($consultantCount>1){
			   		$profitReferal=$excludingExpenses*(20/100); // if consultant more than 1 then profit percentage is 20 as per Dr.Murli- Atul
			   	}else{
			   		$profitReferal=$excludingExpenses*($conProPercentage['Consultant']['profit_percentage']/100);
			   	}	
		   }
		   $retuData = array('profitBillData'=>$profitReferal,'sAmount'=>$conProPercentage['Consultant']['referal_spot_amount'],
		   		'sBAmt'=>$sBAmt);
		   return $retuData;
	   }
}
?>