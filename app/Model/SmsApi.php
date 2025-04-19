<?php
/**
 * SmsApi Model
 *
 * PHP 5
 *
 * @copyright     Copyright 2013 drmhope Inc.  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       SmsApi Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 */
App::uses('RadiologyTestOrder', 'Model');
App::uses('LaboratoryTestOrder', 'Model');
App::uses('Billing', 'Model');
App::uses('AccountReceipt', 'Model');
App::uses('VoucherPayment', 'Model');
App::uses('TariffStandard', 'Model');
class SmsApi extends AppModel {

	public $specific = true;
	public $name = 'SmsApi';
	public $useTable = false;
	public $database = 'db_hope';
	public $hospitalName = "Globus Hospital";
	
	function __construct($id = false, $table = null, $ds = null) {		
		$this->db_name =  $this->database;
		parent::__construct($id, $table, $ds);
	}
	
	
	
	public function sendToSmsPatient($personId,$type,$data){
		App::uses('Patient', 'Model');
		App::uses('Person', 'Model');
		App::uses('Room', 'Model');
		App::uses('Bed', 'Model');
		App::uses('Ward', 'Model');
		App::uses('User', 'Model');
		App::uses('Diagnosis', 'Model');
		App::uses('NoteDiagnosis', 'Model');
		App::uses('OptAppointment', 'Model');
		App::uses('FinalBilling', 'Model');
		App::uses('Appointment', 'Model');
		
		$patientModel = new Patient(null,null,$this->database);
		$person = new Person(null,null,$this->database);
		$room = new Room(null,null,$this->database);
		$bed = new Bed(null,null,$this->database);
		$ward = new Ward(null,null,$this->database);
		$user = new User(null,null,$this->database);
		$diagnosis = new Diagnosis(null,null,$this->database);
		$noteDiagnosis = new NoteDiagnosis(null,null,$this->database);
		$optAppointment = new OptAppointment(null,null,$this->database);
		$finalBilling = new FinalBilling(null,null,$this->database);
		$appointment = new Appointment(null,null,$this->database);	
	
		$patientModel->bindModel(array(			
			'belongsTo' => array(			
						'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
						'Room' =>array('foreignKey' => false,'conditions'=>array('Room.id=Patient.room_id' )),
						'Bed' =>array('foreignKey' => false,'conditions'=>array('Bed.id=Patient.bed_id' )),
						'Ward' =>array('foreignKey' => false,'conditions'=>array('Ward.id=Room.ward_id' )),
						'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id')),
						'Diagnosis' =>array('foreignKey' => false,'conditions'=>array('Diagnosis.patient_id=Patient.id')),
						'NoteDiagnosis' =>array('foreignKey' => false,'conditions'=>array('NoteDiagnosis.patient_id=Patient.id')),
						'OptAppointment' =>array('foreignKey' => false,'conditions'=>array('OptAppointment.patient_id=Patient.id')),
						'FinalBilling' =>array('foreignKey' => false,'conditions'=>array('FinalBilling.patient_id=Patient.id')),
						'Appointment' =>array('foreignKey' => false,'conditions'=>array('Appointment.patient_id=Patient.id','Appointment.id'=>$data)),
	
				)));
		$patientData = $patientModel->find('first',array('fields'=>array('full_name' => 'CONCAT(User.first_name," ", User.last_name)','Patient.lookup_name','Person.dob','Ward.name','Person.mobile','Diagnosis.complaints','NoteDiagnosis.diagnoses_name','Patient.mobile_phone','OptAppointment.starttime','FinalBilling.amount_paid','FinalBilling.amount_pending','FinalBilling.discount_type','Appointment.start_time','Appointment.date'),'conditions'=>array('Patient.person_id'=>$personId,'Patient.is_deleted'=>0)));
	
		if(!empty($patientData['Diagnosis']['complaints'])){
			$getDiagnoses=$patientData['Diagnosis']['complaints'];
		}else{
			$getDiagnoses=$patientData['NoteDiagnosis']['diagnoses_name'];
		}
	
		if($type=='Reg'){
			/******After patient reg to  get sms alert for Patient  ***/
			$mobNo = $patientData['Person']['mobile'];
			$msgText='You have been assigned '.$patientData['Ward']['name'].' room . Your treating physician will be '.$patientData[0]['CONCAT(User.first_name," ", User.last_name)'].'.';
		}else if($type=='OR'){
			/******After patient reg to  get sms alert for Patient Relative  ***/
			$mobNo = $patientData['Patient']['mobile_phone'];
			$msgText='Your relative named '.$patientData['Patient']['lookup_name'].' aged '.$personModel->getCurrentAge($patientData['Person']['dob']).' admitted in '.$getHospitalName.' hospital for diagnosis '.$getDiagnoses.' has been operated for--------- and is shifted to room no '.$patientData['Ward']['name'];
		}else if($type=='OT'){
			/******After patient reg to  get sms alert for Patient  ***/
			$getDateTime=$patientData['OptAppointment']['starttime'];
			$getExplodeData=explode(' ',$getDateTime);
			$getExplodeData[0] = DateFormatComponent::formatDate2LocalForReport($getExplodeData[0],Configure::read('date_format'));
			$mobNo = $patientData['Person']['mobile'];
			$msgText='Your surgery is scheduled for '.$getExplodeData[0].' and '.$getExplodeData[1];
		}else if($type=='FollowUp'){
			/******After patient  on leaving the clinic  to  get sms alert for Patient ***/
			$patientData['Appointment']['date'] = DateFormatComponent::formatDate2Local($patientData['Appointment']['date'],Configure::read('date_format'));
			$mobNo = $patientData['Person']['mobile'];
				
			/**BOF- For Converting Time in 24 hours to 12 hours  **/
			/*$explodeData=explode(':',$patientData['Appointment']['start_time']);
				$hours =$explodeData['0'];// substr($patientData['Appointment']['start_time'], 0, 2);
			$minutes = $explodeData['1'];//substr($patientData['Appointment']['start_time'], 3, 2);
			if ($hours > 12 ) {
			$hours = $hours - 12;
			$ampm = 'PM';
			} else {
			if ($hours != 11) {
			$hours = substr($hours,0, 2);
			}
			$ampm = 'AM';
			}
			//EOF- For Converting Time in 24 hours to 12 hours
			$getTimeForAmPm=$hours . ':' . $minutes . $ampm;*/
			$msgText='Thank you for your visit. Your next visit is scheduled at '.$patientData['Appointment']['date'].' and '.date("h:i A", strtotime($patientData['Appointment']['start_time'])).'.';
		}else if($type=='PayPaid'){
					/******After patient paid the payment  to  get sms alert for Patient ***/
						$mobNo = $patientData['Person']['mobile'];
						$msgText='We have received Rs.'.$patientData['FinalBilling']['amount_paid'].' from you for availing various services in our clinic. Thank you! ';
		}else if($type=='PayRemainder' && $patientData['FinalBilling']['amount_pending']!='0'){
			/******After patient paid the payment but some amount are balanced to  get sms alert for Patient ***/
				$mobNo =$patientData['Person']['mobile'];
				if($patientData['FinalBilling']['discount_type']=='Percentage'){
				$getSign="%";
					}else{
					$getSign="Rs.";
					}
					$msgText='Balance amount of '.$patientData['FinalBilling']['amount_pending'].' '.$getSign.' is pending in your account. Please Pay as soon as possible!';
		}
	
					/****BOF-for Only Sending SMS *****/
					$sender_id=Configure::read('sender_id');           // sender id
					$mob_no = $mobNo;       //123, 456 being recepients number To-Physician no or Patient no
					$userName=Configure::read('user_name');   ///User Name
					$pwd=Configure::read('pwd');               //your SMS gatewayhub account password
					$msg=$msgText;//'Sample Msg from DRMhope App';       //your message
					$str = trim(str_replace(' ', '%20', $msg));
					// to replace the space in message with  �%20'
					$url=Configure::read('url').'?user='.$userName.'&pwd='.$pwd.'&to='.$mob_no.'&sid='.$sender_id.'&msg='.$str.'&fl=0&gwid=2';
	
					// create a new cURL resource
					$ch = curl_init();
					// set URL and other appropriate options
					curl_setopt($ch, CURLOPT_URL,$url);
					// grab URL and pass it to the browser
					curl_exec($ch);
					//	print_r(curl_getinfo($ch));
					// close cURL resource, and free up system resources
					curl_close($ch);
					/*unset($ch);
					var_dump($data);*/
					/****EOF-for Only Sending SMS *****/
					//	return true;
	
		}
		public function sendToSmsPatientBdayWish($type){
			App::uses('Patient', 'Model');
			App::uses('Person', 'Model');
			App::uses('User', 'Model');
		
			$patientModel = new Patient(null,null,$this->database);
			$person = new Person(null,null,$this->database);
			$user = new User(null,null,$this->database);

			App::uses('PharmacySalesBill', 'Model');
			App::uses('InventoryPharmacySalesReturn', 'Model');
			$patientModel->unBindModel(array(
					'hasMany' => array(new PharmacySalesBill(null,null,$this->database),
							new InventoryPharmacySalesReturn(null,null,$this->database))));
			
			
			$getHospitalName=$this->hospitalName;
			/***BOF-SMS Sending****/
			$userName=Configure::read('user_name');   ///User Name
			$sender_id=Configure::read('sender_id');           // sender id
			$pwd=Configure::read('pwd');               //your SMS gatewayhub account password
			/***EOF-SMS Sending****/
			$patientModel->bindModel(array(
					'belongsTo' => array(
							'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
							'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id')),
					)));
			
			
			$patientDataAllBday =$patientModel->find('all',array(
					'fields'=>array('full_name' => 'CONCAT(User.first_name," ", User.last_name)','Person.dob','Person.mobile'),'conditions'=>array('DATE_FORMAT(Person.dob, "%m-%d")'=>date('m-d'),'Patient.is_deleted'=>0)));
			
			if($type=='Bday'){
				foreach($patientDataAllBday as $patientDataAllBdays){
					/****BOF-Only Sending SMS *****/
					$mobNo = $patientDataAllBdays['Person']['mobile'];
					$msgText=$getHospitalName.' wishes you a very happy birthday. Wishing you good health and happiness in life -'.$patientDataAllBdays[0]['CONCAT(User.first_name," ", User.last_name)'].'.';
					$str = trim(str_replace(' ', '%20', $msgText));
					// to replace the space in message with  �%20'
				/*	$url='curl "' .Configure::read('url').'?user='.$userName.'&pwd='.$pwd.'&to='.$mobNo.'&sid='.$sender_id.'&msg='.$str.'&fl=0&gwid=2"';
					return system($url);*/
					
					$url=Configure::read('url').'?user='.$userName.'&pwd='.$pwd.'&to='.$mobNo.'&sid='.$sender_id.'&msg='.$str.'&fl=0&gwid=2';
					
					// create a new cURL resource
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL,$url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_exec($ch);
					curl_close($ch);
				}
			}
		}
		
		//Send sms to Murli sir if patient is not converted to RGJAY - by Mrunal
		public function sendSmsRGJAYPatient($type){

			App::uses('Patient', 'Model');
			App::uses('Person', 'Model');
			App::uses('User', 'Model');
			
			$patientModel = new Patient(null,null,$this->database);
			$person = new Person(null,null,$this->database);
			$user = new User(null,null,$this->database);
			
			App::uses('PharmacySalesBill', 'Model');
			App::uses('InventoryPharmacySalesReturn', 'Model');
			$patientModel->unBindModel(array(
					'hasMany' => array(new PharmacySalesBill(null,null,$this->database),
							new InventoryPharmacySalesReturn(null,null,$this->database))));
				
				
			$getHospitalName=$this->hospitalName;
			/***BOF-SMS Sending****/
			$userName=Configure::read('user_name');   ///User Name
			$sender_id=Configure::read('sender_id');           // sender id
			$pwd=Configure::read('pwd');               //your SMS gatewayhub account password
			/***EOF-SMS Sending****/
			$patientModel->bindModel(array(
					'belongsTo' => array(
							'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
							'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id')),
					)));
				
			$conditions['Patient.is_deleted'] = 0;
			$conditions['Patient.is_discharge'] = 0;
			$conditions['Patient.tariff_standard_id'] = 39;
			
			$asonPatient =$patientModel->find('all',array(
					'fields'=>array('full_name' => 'CONCAT(User.first_name," ", User.last_name)','Patient.claim_status','Patient.lookup_name','Patient.create_time','Patient.tariff_standard_id','Patient.age','Patient.sex'),
					'conditions'=>$conditions,
					'order'=>array('Patient.create_time'=>'DESC')));
			
			$currentDate = date("Y-m-d H:i:s");//2016-02-17 15:23:48
			$mobNo = array(9890682577,9373111709,9850341544,9423441926);//9373111709-Murali Sir//9850341544 ---Administrator-Shrikant//9423441926-Pallavi
			//$dateFormat=new DateFormatComponent();
			
			if($type=='RGJAYASON'){
				foreach($asonPatient as $asonRGJAY){
					$admition_date = $asonRGJAY['Patient']['create_time'];
					$diff = StrToTime($currentDate) - StrToTime($admition_date);
					$hours = $diff / ( 60 * 60 );
					$strTime=strtotime($admition_date);
					if($asonRGJAY['Patient']['sex']=='male'){$sex = 'm'; }else if($asonRGJAY['Patient']['sex']=='female'){$sex = 'f';}
					$age=explode(" ", $asonRGJAY['Patient']['age']);
					if(($asonRGJAY['Patient']['claim_status'] != 'Pre-authorization (Approved)') && ($hours > 48)){ 
						/****BOF-Only Sending SMS *****/
						foreach($mobNo as $mob){ 
							$msgText = 'Pt.'.$asonRGJAY['Patient']['lookup_name'].'('.$sex.') '.$age[0].' admitted on '.date('d-m-Y',$strTime).' is still under RGJAY(Private as on today). Action need to be taken.';
							$str = trim(str_replace(' ', '%20', $msgText));
							
							$url=Configure::read('url').'?user='.$userName.'&pwd='.$pwd.'&to='.$mob.'&sid='.$sender_id.'&msg='.$str.'&fl=0&gwid=2';
								
							// create a new cURL resource
							$ch = curl_init();
							curl_setopt($ch, CURLOPT_URL,$url);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							curl_exec($ch);
							curl_close($ch); 
							echo "Message sent succesfully"; 
						}
					}
				}// ENND of foreach
			}// end of if type
			
		}// End Of RGJAY(as on private) SMS

	/**
	 * function for send SMS to whovere we have to put Msg as well as Mobile no.
	 * @param unknown_type Message as well as Mobile no.
	 * @Mahalaxmi
	 */
	public function sendToSms($msg,$mobNo,$type=null){			
		if(!$this->is_connected()) return; //check for internet connectivity .
		/****BOF-Only Sending SMS *****/
			$sender_id=Configure::read('sender_id');           // sender id
			//$mob_no = $mobNo;     //123, 456 being recepients number To-Physician no or Patient no
			$userName=Configure::read('user_name');   ///User Name
			$pwd=Configure::read('pwd');               //your SMS gatewayhub account password
			//$msg=$msgText;      //your message		
			$msg = str_replace(array("\n", "\r"), ' ', $msg);
			$str = trim(str_replace(' ', '%20', $msg));		
			if($type=="Hexa"){
				$url=Configure::read('url').'?user='.$userName.'&pwd='.$pwd.'&to='.$mobNo.'&sid='.$sender_id.'&msg='.$str.'&fl=0&dc=8&gwid=2';
			//Its only for Unicode msg
			}else{
				$url=Configure::read('url').'?user='.$userName.'&pwd='.$pwd.'&to='.$mobNo.'&sid='.$sender_id.'&msg='.$str.'&fl=0&gwid=2';
			}	
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 15);
		$data=curl_exec($ch);		
		curl_close($ch);		
		$getExplode=explode("<",$data);			
		//For send Sms with confirmation		
		if(preg_match('/\s/',trim($getExplode[0])))
			return "no";
		else
			return "yes";
		/****EOF-Only Sending SMS *****/		
	}
	//check if internet is working on machine .
	function is_connected()
	{
		$connected = fsockopen("www.google.com", 80, $errno, $errstr, 10);
		//website, port  (try 80 or 443)
		if ($connected){
			$is_conn = true; //action when connected
			fclose($connected);
		}else{
			$is_conn = false; //action in connection failure
		}
		return $is_conn;
	}
	
	/**
	 * function for send SMS to unicode in hindi.
	 * @param unknown_type Message.
	 * @Mahalaxmi
	 */
	public function utf8_to_unicode($str) {
        $unicode = array();
        $values = array();
        $lookingFor = 1;
        for ($i = 0; $i < strlen($str); $i++) {
            $thisValue = ord($str[$i]);
            if ($thisValue < 128) {
                $number = dechex($thisValue);
                $unicode[] = (strlen($number) == 1) ? '%u000' . $number : "%u00" . $number;
            } else {
                if (count($values) == 0)
                    $lookingFor = ( $thisValue < 224 ) ? 2 : 3;
                $values[] = $thisValue;
                if (count($values) == $lookingFor) {
                    $number = ( $lookingFor == 3 ) ?
                            ( ( $values[0] % 16 ) * 4096 ) + ( ( $values[1] % 64 ) * 64 ) + ( $values[2] % 64 ) :
                            ( ( $values[0] % 32 ) * 64 ) + ( $values[1] % 64
                            );
                    $number = dechex($number);
                    $unicode[] =
                            (strlen($number) == 3) ? "%u0" . $number : "%u" . $number;
                    $values = array();
                    $lookingFor = 1;
                } // if
            } // if
        }
        return implode("", $unicode);
    }
	/**
	 * function for send SMS related to claim Approved or Rejected.
	 * @param unknown_type .
	 * @Mahalaxmi
	 */
	public function sendToSmsForClaim(){
		App::uses('Patient', 'Model');
		App::uses('PharmacySalesBill', 'Model');
		App::uses('InventoryPharmacySalesReturn', 'Model');
		App::uses('TariffStandard', 'Model');
		$dbconfig = ConnectionManager::getDataSource('defaultHospital')->config; 
		$this->database = $dbconfig['database']; 

		$patientModel = new Patient(null,null,$this->database);
		$tariffStandardModel = new TariffStandard(null,null,$this->database);

			
		$patientModel->unBindModel(array(
					'hasMany' => array(new PharmacySalesBill(null,null,$this->database),
							new InventoryPharmacySalesReturn(null,null,$this->database))));


		$getTariffRgjayId=$tariffStandardModel->getTariffStandardID('RGJAY');			
		$patientDataAll =$patientModel->find('all',array('fields'=>array('Patient.lookup_name','Patient.claim_status','Patient.claim_status_change_date'),'conditions'=>array('Patient.tariff_standard_id'=>$getTariffRgjayId,'Patient.is_discharge'=>1,'Patient.is_deleted'=>0)));
	
		foreach($patientDataAll as $key=>$patientDataAlls){			
			$date=strtotime($patientDataAlls['Patient']['claim_status_change_date']);
			$newDateThirtyAfterDays = date('Y-m-d',strtotime('+30 days',$date));
			$newDateTwentyAfterDays = date('Y-m-d',strtotime('+20 days',$date));
			$newDateFifteenAfterDays = date('Y-m-d',strtotime('+14 days',$date)); //It should be  on 15 day only
			$newDateThirteenAfterDays = date('Y-m-d',strtotime('+13 days',$date));
			$newDateTenAfterDays = date('Y-m-d',strtotime('+10 days',$date));
			$patientDataAlls['Patient']['claim_status_change_date'] =DateFormatComponent::formatDate2LocalForReport($patientDataAlls['Patient']['claim_status_change_date'],Configure::read('date_format'));

			$newDateTwentyAfterDays =DateFormatComponent::formatDate2LocalForReport($newDateTwentyAfterDays,Configure::read('date_format'));
			
			$newDateThirtyAfterDays =DateFormatComponent::formatDate2LocalForReport($newDateThirtyAfterDays,Configure::read('date_format'));
			
			$newDateFifteenAfterDays =DateFormatComponent::formatDate2LocalForReport($newDateFifteenAfterDays,Configure::read('date_format'));

			$newDateTenAfterDays =DateFormatComponent::formatDate2LocalForReport($newDateTenAfterDays,Configure::read('date_format'));
			
			//debug($newDateFifteenAfterDays);
			if($patientDataAlls['Patient']['claim_status']=="Preauth Approved" && $newDateFifteenAfterDays==date('Y-m-d')){
				$showMsg= sprintf(Configure::read('claimSms'),$patientDataAlls['Patient']['lookup_name'],$patientDataAlls['Patient']['claim_status'],$patientDataAlls['Patient']['claim_status_change_date'],$newDateThirtyAfterDays,Configure::read('hosp_details'));
				$this->SmsApi->sendToSms($showMsg,Configure::read('cordinator_rgjay_mobile_no')); //for admit to send SMS to All cordinators of RGJAY.
			}else if($patientDataAlls['Patient']['claim_status']=="Claim Doctor Rejected" && $newDateTenAfterDays==date('Y-m-d') /*&& $newDateThirteenAfterDays==date('Y-m-d')*/ && $newDateThirteenAfterDays >=$newDateTwentyAfterDays){
				$showMsg= sprintf(Configure::read('claimSms'),$patientDataAlls['Patient']['lookup_name'],$patientDataAlls['Patient']['claim_status'],$patientDataAlls['Patient']['claim_status_change_date'],$newDateTenAfterDays,Configure::read('hosp_details'));
				$this->SmsApi->sendToSms($showMsg,Configure::read('cordinator_rgjay_mobile_no')); //for admit to send SMS to All cordinators of RGJAY.
			}							
		}	
	}
	/**
	 * function for send SMS to Chairman / Medical Superintendent / Administrator of Total Revenue of Daily Mis Report
	 * @param unknown_type Todays Date
	 * @Mahalaxmi
	 */
	public function smsToSendForTotalRevenue(){		
		$voucherPaymentModel = new VoucherPayment(null,null,$this->database);		
		$accountReceiptModel = new AccountReceipt(null,null,$this->database);					
		$billingModel = new Billing(null,null,$this->database);
		$getPreviousDate=date('Y-m-d', strtotime('-1 day'));
		$getBilledData=$billingModel->find("first",array("fields"=>array("SUM(Billing.amount)-SUM(Billing.paid_to_patient) as sumRevenueAmts"),"conditions"=>array("Billing.is_deleted"=>0,"Billing.date like"=>$getPreviousDate."%"))); //date('Y-m-d')		
		
		$getPharamcyPaidAmt=$accountReceiptModel->find('first',array('fields'=>array('SUM(AccountReceipt.paid_amount) as pharamacyAmt'),'conditions'=>array('AccountReceipt.type'=>'DirectSaleBill','AccountReceipt.is_deleted'=>0,"AccountReceipt.date like"=>$getPreviousDate."%")));
		
		$getPharamcyPaidReturnAmt=$voucherPaymentModel->find('first',array('fields'=>array('SUM(VoucherPayment.paid_amount) as pharamacyReturnAmt'),'conditions'=>array('VoucherPayment.type'=>'DirectPharmacyRefund','VoucherPayment.is_deleted'=>0,"VoucherPayment.date like"=>$getPreviousDate."%")));
		
		$getFinalAmt=round($getBilledData['0']['sumRevenueAmts'])+round($getPharamcyPaidAmt[0]['pharamacyAmt'])-round($getPharamcyPaidReturnAmt[0]['pharamacyReturnAmt']);
		return $getFinalAmt;
	}
	/**
	 * function for send SMS to Chairman / Medical Superintendent / Administrator of Total Ipd Patient Daily
	 * @param unknown_type Todays Date
	 * @Mahalaxmi
	 */
	public function smsToSendForIpdPatient(){
		App::uses('Patient', 'Model');					
		$patientModel = new Patient(null,null,$this->database);
		
		$getPreviousDate=date('Y-m-d', strtotime('-1 day'));
		$getPatientData=$patientModel->find("first",array("fields"=>array("count(id) as countPatients"),"conditions"=>array("Patient.form_received_on like "=>$getPreviousDate."%","Patient.admission_type"=>"IPD",""))); //date('Y-m-d')	
		
		return $getPatientData['0']['countPatients'];

	}

	/**
	 * function for send SMS to Chairman / Medical Superintendent / Administrator of Total Ipd Patient Daily
	 * @param unknown_type Todays Date
	 * @Mahalaxmi
	 */
	public function smsToSendForIpdPrivatePatient(){
		App::uses('Patient', 'Model');					
		$patientModel = new Patient(null,null,$this->database);
		$tariffStandardModel = new TariffStandard(null,null,$this->database);
		$getPrivateTarifID=$tariffStandardModel->getTariffStandardID('privateTariffName');
		$getPreviousDate=date('Y-m-d', strtotime('-1 day'));
		$getPatientData=$patientModel->find("first",array("fields"=>array("count(id) as countPatients"),"conditions"=>array("Patient.form_received_on like "=>$getPreviousDate."%","Patient.admission_type"=>"IPD","Patient.tariff_standard_id"=>$getPrivateTarifID))); //date('Y-m-d')			
		return $getPatientData['0']['countPatients'];

	}
	/**
	 * function for send SMS to Chairman / Medical Superintendent / Administrator of Total Ipd Patient Daily
	 * @param unknown_type Todays Date
	 * @Mahalaxmi
	 */
	public function smsToSendForIpdOtherCorporatePatient(){
		App::uses('Patient', 'Model');					
		$patientModel = new Patient(null,null,$this->database);
		$tariffStandardModel = new TariffStandard(null,null,$this->database);
		$getPrivateTarifID=$tariffStandardModel->getTariffStandardID('privateTariffName');
		$getRJAyTarifID=$tariffStandardModel->getTariffStandardID('RGJAY');
		$getPreviousDate=date('Y-m-d', strtotime('-1 day'));
		$getPatientData=$patientModel->find("first",array("fields"=>array("count(id) as countPatients"),"conditions"=>array("Patient.form_received_on like "=>$getPreviousDate."%","Patient.admission_type"=>"IPD","Patient.tariff_standard_id NOT"=>array($getPrivateTarifID,$getRJAyTarifID)))); //date('Y-m-d')			
		return $getPatientData['0']['countPatients'];

	}
	/**
	 * function for send SMS to Chairman / Medical Superintendent / Administrator of Total Ipd Patient Daily
	 * @param unknown_type Todays Date
	 * @Mahalaxmi
	 */
	public function smsToSendForIpdRjayPatient(){
		App::uses('Patient', 'Model');					
		$patientModel = new Patient(null,null,$this->database);
		$tariffStandardModel = new TariffStandard(null,null,$this->database);
		$getPrivateTarifID=$tariffStandardModel->getTariffStandardID('RGJAY');
		$getPreviousDate=date('Y-m-d', strtotime('-1 day'));
		$getPatientData=$patientModel->find("first",array("fields"=>array("count(id) as countPatients"),"conditions"=>array("Patient.form_received_on like "=>$getPreviousDate."%","Patient.admission_type"=>"IPD","Patient.tariff_standard_id"=>$getPrivateTarifID))); //date('Y-m-d')			
		return $getPatientData['0']['countPatients'];

	}
	
	/**
	 * function for send SMS to Chairman / Medical Superintendent / Administrator of Total OPD Patient Daily
	 * @param unknown_type Todays Date
	 * @Mahalaxmi
	 */
	public function smsToSendForOpdPatient(){
		App::uses('Patient', 'Model');					
		$patientModel = new Patient(null,null,$this->database);

		App::uses('Appointment', 'Model');					
		$appointmentModel = new Appointment(null,null,$this->database);

		$getPreviousDate=date('Y-m-d', strtotime('-1 day'));

		$getPatientData=$patientModel->find("first",array("fields"=>array("count(Patient.id) as countPatients"),"conditions"=>array("Patient.is_discharge"=>1,"Patient.is_deleted"=>0,"Patient.form_received_on like "=>$getPreviousDate."%","Patient.admission_type !="=>"IPD"))); //date('Y-m-d')	


		//$getAppData=$appointmentModel->find("first",array("fields"=>array("count(Appointment.id) as countAppointment"),"conditions"=>array("Appointment.date like "=>$getPreviousDate."%"))); //date('Y-m-d')	
	
		return $getPatientData['0']['countPatients']+$getAppData['0']['countAppointment'];
	}
	/**
	 * function for send SMS to Chairman / Medical Superintendent / Administrator of Total Discharged Patient Daily
	 * @param unknown_type Todays Date
	 * @Mahalaxmi
	 */
	public function smsToSendForDischargePatient(){
		App::uses('Patient', 'Model');					
		$patientModel = new Patient(null,null,$this->database);
		$getPreviousDate=date('Y-m-d', strtotime('-1 day'));
		$getPatientData=$patientModel->find("first",array("fields"=>array("count(id) as countPatients"),"conditions"=>array("Patient.is_discharge"=>1,"Patient.discharge_date like "=>$getPreviousDate."%","Patient.admission_type"=>"IPD"))); //date('Y-m-d')	
		
		return $getPatientData['0']['countPatients'];
	}
	/**
	 * function for send SMS to Chairman / Medical Superintendent / Administrator of Total Discharged Patient Daily
	 * @param unknown_type Todays Date
	 * @Mahalaxmi
	 */
	public function smsToSendForPrivateDischargePatient(){
		App::uses('Patient', 'Model');					
		$patientModel = new Patient(null,null,$this->database);
		$tariffStandardModel = new TariffStandard(null,null,$this->database);
		$getPrivateTarifID=$tariffStandardModel->getTariffStandardID('privateTariffName');
		
		$getPreviousDate=date('Y-m-d', strtotime('-1 day'));
		$getPatientData=$patientModel->find("first",array("fields"=>array("count(id) as countPatients"),"conditions"=>array("Patient.is_discharge"=>1,"Patient.discharge_date like "=>$getPreviousDate."%","Patient.admission_type"=>"IPD","Patient.tariff_standard_id"=>$getPrivateTarifID))); //date('Y-m-d')	
		
		return $getPatientData['0']['countPatients'];
	}
	/**
	 * function for send SMS to Chairman / Medical Superintendent / Administrator of Total Discharged Patient Daily
	 * @param unknown_type Todays Date
	 * @Mahalaxmi
	 */
	public function smsToSendForRjayDischargePatient(){
		App::uses('Patient', 'Model');					
		$patientModel = new Patient(null,null,$this->database);
		$tariffStandardModel = new TariffStandard(null,null,$this->database);
		$getPrivateTarifID=$tariffStandardModel->getTariffStandardID('RGJAY');
		
		$getPreviousDate=date('Y-m-d', strtotime('-1 day'));
		$getPatientData=$patientModel->find("first",array("fields"=>array("count(id) as countPatients"),"conditions"=>array("Patient.is_discharge"=>1,"Patient.discharge_date like "=>$getPreviousDate."%","Patient.admission_type"=>"IPD","Patient.tariff_standard_id"=>$getPrivateTarifID))); //date('Y-m-d')	
		
		return $getPatientData['0']['countPatients'];
	}
	/**
	 * function for send SMS to Chairman / Medical Superintendent / Administrator of Total Discharged Patient Daily
	 * @param unknown_type Todays Date
	 * @Mahalaxmi
	 */
	public function smsToSendForOtherCorporateDischargePatient(){
		App::uses('Patient', 'Model');					
		$patientModel = new Patient(null,null,$this->database);
		$tariffStandardModel = new TariffStandard(null,null,$this->database);
		$getPrivateTarifID=$tariffStandardModel->getTariffStandardID('privateTariffName');
		$getRJAyTarifID=$tariffStandardModel->getTariffStandardID('RGJAY');
		
		$getPreviousDate=date('Y-m-d', strtotime('-1 day'));
		$getPatientData=$patientModel->find("first",array("fields"=>array("count(id) as countPatients"),"conditions"=>array("Patient.is_discharge"=>1,"Patient.discharge_date like "=>$getPreviousDate."%","Patient.admission_type"=>"IPD","Patient.tariff_standard_id NOT"=>array($getPrivateTarifID,$getRJAyTarifID)))); //date('Y-m-d')	
		
		return $getPatientData['0']['countPatients'];
	}
	/**
	 * function for send SMS to Chairman / Medical Superintendent / Administrator of Total No of Lab service Patient Daily
	 * @param unknown_type Todays Date
	 * @Mahalaxmi
	 */
	public function smsToSendForLabServiceCount(){ 
		$laboratoryTestOrderModel = new LaboratoryTestOrder(null,null,$this->database); 		
		$getPreviousDate=date('Y-m-d', strtotime('-1 day'));	
	
		$getLabData=$laboratoryTestOrderModel->find("first",array("fields"=>array("count(LaboratoryTestOrder.id) as countLab"),"conditions"=>array("start_date like "=>$getPreviousDate."%","LaboratoryTestOrder.is_deleted"=>0))); //date('Y-m-d')	
		
		return $getLabData['0']['countLab'];
	}
	
	/**
	 * function for send SMS to Chairman / Medical Superintendent / Administrator of Total No of Rad for XRAY service Patient Daily
	 * @param unknown_type Todays Date
	 * @Mahalaxmi
	 */
	public function smsToSendRadiologyCount(){
		App::uses('RadiologyTestOrder', 'Model');					
		$radiologyTestOrderModel = new RadiologyTestOrder(null,null,$this->database);	
		$getPreviousDate=date('Y-m-d', strtotime('-1 day'));			
		$getRadDataXray=$radiologyTestOrderModel->find("first",array("fields"=>array("count(RadiologyTestOrder.id) as countRad"),"conditions"=>array("RadiologyTestOrder.radiology_order_date like "=>$getPreviousDate."%","RadiologyTestOrder.is_deleted"=>0))); //date('Y-m-d')			
		return $getRadDataXray['0']['countRad'];
	}

	
	
	/**
	 * function for send SMS to Chairman / Medical Superintendent / Administrator of Total No of Surgery service Patient Daily
	 * @param unknown_type Todays Date
	 * @Mahalaxmi
	 */

	public function smsToSendForSurgeryServiceCount(){
		App::uses('OptAppointment', 'Model');					
		$optAppointmentModel = new OptAppointment(null,null,$this->database);
		$getPreviousDate=date('Y-m-d', strtotime('-1 day'));
		$optAppointmentModel->unbindModel(array('belongsTo' => array('Surgery','DoctorProfile','Initial','SurgerySubcategory','Location','OptTable','Doctor','Opt','Patient')));
		$getSurgeryData=$optAppointmentModel->find("first",array("fields"=>array("count(OptAppointment.id) as countSurgery"),"conditions"=>array("OptAppointment.schedule_date like "=>$getPreviousDate."%","OptAppointment.is_deleted"=>0))); //date('Y-m-d')			
		return $getSurgeryData['0']['countSurgery'];
	}

	/**
	 * function for send SMS to Pallavi,Dr.Murali & Ruby mobile no. of Total No of Surgery service Patient Daily
	 * @param unknown_type Todays Date
	 * @Mahalaxmi
	 */

	public function smsToSendForOTSchedule(){
		App::uses('OptAppointment', 'Model');					
		$optAppointmentModel = new OptAppointment(null,null,$this->database);
		App::uses('Patient', 'Model');					
		$patientModel = new Patient(null,null,$this->database);
		App::uses('Surgery', 'Model');					
		$surgeryModel = new Surgery(null,null,$this->database);
		App::uses('User', 'Model');					
		$userModel = new User(null,null,$this->database);
		App::uses('TariffStandard', 'Model');					
		$tariffStandardModel = new TariffStandard(null,null,$this->database);

		//$getPreviousDate=date('Y-m-d', strtotime('+1 day'));
		//BOF-Mahalaxmi For RGJAY Patient not display PRint Reciept
		$getTariffRgjayId=$tariffStandardModel->getTariffStandardID('RGJAY');		
		//EOF-Mahalaxmi For RGJAY Patient not display PRint Reciept
		$getPreviousDate=date('Y-m-d');
		$optAppointmentModel->unbindModel(array('belongsTo' => array('Surgery','DoctorProfile','Initial','SurgerySubcategory','Location','OptTable','Doctor','Opt','Patient')));
		//RGJAY CONDITION
		$optAppointmentModel->bindModel(array(
				'belongsTo'=>array(
					'Patient'=>array('type'=>'INNER','foreignKey'=>false,
						'conditions'=>array('Patient.id = OptAppointment.patient_id')),
					'Surgery'=>array('type'=>'INNER','foreignKey'=>false,
						'conditions'=>array('Surgery.id = OptAppointment.surgery_id')),
					'User'=>array('type'=>'INNER','foreignKey'=>false,
						'conditions'=>array('User.id = OptAppointment.doctor_id')),
		)));
		$getSurgeryData=$optAppointmentModel->find("all",array("fields"=>array('Surgery.name',"OptAppointment.surgery_id","OptAppointment.doctor_id",'OptAppointment.patient_id','Patient.lookup_name','User.first_name','User.last_name'),"conditions"=>array("OptAppointment.schedule_date like "=>$getPreviousDate."%","OptAppointment.is_deleted"=>0,'Patient.tariff_standard_id'=>$getTariffRgjayId))); //date('Y-m-d')	
	
		if(!empty($getSurgeryData)){
		$textMsg .= date('d M Y',strtotime("today")).", Please check if following RGJAY Pt. case has been approved: ";  // returns "Like DEC-D"
		
		$customArr=array();
		foreach($getSurgeryData as $key=>$getSurgeryDatas){			
			$customArr[$getSurgeryDatas['Patient']['lookup_name']][]=$getSurgeryDatas;		
		}	
		$cnt=1;
		$textMsgArr=array();			
		foreach($customArr as $lookupName=>$customArrs){
			unset($getSurgeryName);			
			foreach($customArrs as $customArrss){		
				
				$customArrss['Surgery']['name'] = str_replace ('&','and', $customArrss['Surgery']['name']);
				$gettFirstName=explode(" ",$customArrss['User']['first_name']);		
				$gettLastName=explode(" ",$customArrss['User']['last_name']);				

				$getSurgeryName[]=$customArrss['Surgery']['name']." under ".$gettFirstName[0]." ".$gettLastName[0];			
			}
			$getFullSurgery=implode(",",$getSurgeryName);	
			//$getFullSergeonNm=implode(",",$getFullSergeonName);	
			$textMsgArr[] .= "(".$cnt."). ".$lookupName." : ".$getFullSurgery;
			$cnt++;
		}
		
		$msgsArrimp=implode(", ",$textMsgArr);
		$textMsg.=$msgsArrimp;	
		
		return $textMsg;
		}
	}
	
	//Send SMS ot appointment Surgery status not updated to Dr Murali And other autherized person -  by Mrunal
	public function sendSurgeryStatusNotUpdated(){
		App::uses('OptAppointment', 'Model');
		App::uses('TariffStandard', 'Model');
		App::uses('Patient', 'Model');
		App::uses('Surgery', 'Model');
			
		$optAppointment = new OptAppointment(null,null,$this->database);
		$tariffStandardName = new TariffStandard(null,null,$this->database);
		$patientModel = new Patient(null,null,$this->database);
		$surgery = new Surgery(null,null,$this->database);
			
		$optAppointment->belongsTo= array();
		
		$optAppointment->bindModel(array(
				'belongsTo' => array(
						'Patient' =>array('type'=>'INNER','foreignKey' => false,'conditions'=>array('Patient.id=OptAppointment.patient_id')),
						'Surgery' =>array('type'=>'INNER','foreignKey' => false,'conditions'=>array('OptAppointment.surgery_id=Surgery.id')),
				)));
		
		$getHospitalName=$this->hospitalName;
		/***BOF-SMS Sending****/
		$userName=Configure::read('user_name');   ///User Name
		$sender_id=Configure::read('sender_id');           // sender id
		$pwd=Configure::read('pwd');               //your SMS gatewayhub account password
		/***EOF-SMS Sending****/
		$rgjayId = $tariffStandardName->getTariffStandardID(rgjay);
		
		$conditions['Patient.is_deleted'] = 0;
		$conditions['Patient.is_discharge'] = 0;
		$conditions['Patient.tariff_standard_id'] = $rgjayId;
		$conditions['OptAppointment.procedure_complete'] = 1;
		$conditions['OptAppointment.is_deleted'] = 0;
		
		$optSurgeryDetails =$optAppointment->find('all',array('fields'=>array('Patient.id','Patient.lookup_name','Patient.age','Patient.sex','Patient.claim_status','OptAppointment.patient_id','OptAppointment.surgery_id',
															'OptAppointment.procedure_complete','OptAppointment.schedule_date','OptAppointment.start_time','OptAppointment.end_time'),
										  					'conditions'=>$conditions
				));
		//debug($optSurgeryDetails);
		$current_date = date('Y-m-d H:i');
		$mobNo = array(9890682577,9373111709,9850341544,9423441926);//9373111709-Murali Sir//9850341544 ---Administrator-Shrikant//9423441926-Pallavi
		foreach($optSurgeryDetails as $optSurgery){ 
			$surgeryEndDateTime = $optSurgery['OptAppointment']['schedule_date']." ".$optSurgery['OptAppointment']['end_time'];
			$diff = StrToTime($current_date) - StrToTime($surgeryEndDateTime);
			$hours = $diff / ( 60 * 60 );
			
			$strTime=strtotime($surgeryEndDateTime);
			if($optSurgery['Patient']['sex']=='male'){$sex = 'm'; }else if($optSurgery['Patient']['sex']=='female'){$sex = 'f';}
			$age=explode(' ', $optSurgery['Patient']['age']);
			
			if(($optSurgery['Patient']['claim_status']!='Surgery (Update)') && ($hours > 12)){ 
				foreach($mobNo as $mob){
					$msgText = 'Pt.'.$optSurgery['Patient']['lookup_name'].'('.$sex.') '.$age[0].' surgery schedule on '.date('d-m-Y H:i',$strTime).' is still under pending status. Action need to be taken.';
					$str = trim(str_replace(' ', '%20', $msgText));
						
					$url=Configure::read('url').'?user='.$userName.'&pwd='.$pwd.'&to='.$mob.'&sid='.$sender_id.'&msg='.$str.'&fl=0&gwid=2';
		
					// create a new cURL resource
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL,$url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_exec($ch);
					curl_close($ch); 
					echo "Message sent Succesfully";
				}
			}
		}
		
	}

	/**
	 * function for send SMS to Patient Daily
	 * @param unknown_type whatever time choose from discharge summary
	 * @Mahalaxmi
	 */
	public function smsToSendForMedicationTime(){
		App::uses('DischargeDrug', 'Model');					
		$dischargeDrugModel = new DischargeDrug(null,null,$this->database);
		App::uses('DischargeSummary', 'Model');					
		$dischargeSummaryModel = new DischargeSummary(null,null,$this->database);
		App::uses('Patient', 'Model');	
		$patientModel = new Patient(null,null,$this->database);
		App::uses('Person', 'Model');	
		$personModel = new Person(null,null,$this->database);
		App::uses('PharmacyItem', 'Model');	
		$pharmacyItemModel = new PharmacyItem(null,null,$this->database);
		App::uses('Configuration', 'Model');	
		$configurationModel = new Configuration(null,null,$this->database);
		App::uses('Message', 'Model');	
		$messageModel = new Message(null,null,$this->database);
		$dischargeDrugModel->unbindModel(array('belongsTo' => array('PharmacyItem')));
		$getMedicationTime=Configure::read('medication_time');
		$dischargeSummaryModel->bindModel(
				array('belongsTo' => array(
						'DischargeDrug' => array('type'=>'INNER','foreignKey'=>false,'conditions'=> array('DischargeDrug.discharge_summaries_id=DischargeSummary.id')),	
						'Patient'=>array('type'=>'INNER','foreignKey'=>false,'conditions'=>array('Patient.id=DischargeSummary.patient_id')),
						'Person'=>array('type'=>'INNER','foreignKey'=>false,'conditions'=>array('Person.id=Patient.person_id')),
						'PharmacyItem'=>array('type'=>'INNER','foreignKey'=>false,'conditions'=>array('PharmacyItem.id=DischargeDrug.drug_id')),
		),
				/*'hasMany' => array(
						'DischargeDrug' => array('foreignKey'=>'discharge_summaries_id','fields'=>array('DischargeDrug.frequency','DischargeDrug.first','DischargeDrug.second','DischargeDrug.third','DischargeDrug.forth','DischargeDrug.dose','DischargeDrug.start_date'),'conditions'=> array('DischargeDrug.isactive'=>1,'DischargeDrug.first <>'=>null,'DischargeDrug.is_sms_checked'=>1)),)*/
				));
		$results = $dischargeSummaryModel->find('all',array('fields'=>array('Person.mobile','DischargeDrug.frequency','DischargeDrug.first','DischargeDrug.second','DischargeDrug.third','DischargeDrug.forth','DischargeDrug.dose','DischargeDrug.start_date','PharmacyItem.name'),'conditions'=>array('OR'=>array('Person.mobile <>'=>null,'Person.mobile <>'=>''),'DischargeSummary.is_sms_check'=>1,'DischargeDrug.isactive'=>1,'DischargeDrug.first <>'=>null,'DischargeDrug.is_sms_checked'=>1,'DischargeDrug.start_date <='=>date('Y-m-d 00:00:00'),'DischargeDrug.end_date >='=>date('Y-m-d 00:00:00'))));		
		#debug($results);
		#debug($dischargeSummaryModel->Patient->getDataSource()->getLog(false, false));exit;	
		$smsActive=$configurationModel->getConfigSmsValue('Medication Remainder','1');	
		if($smsActive){
			$scheduleMedicationText='';
			foreach($results as $key => $value){	
				/*debug($getMedicationTime[$value['DischargeDrug']['first']]);	
				debug($getMedicationTime[$value['DischargeDrug']['second']]);	
				debug($getMedicationTime[$value['DischargeDrug']['third']]);	
				debug($getMedicationTime[$value['DischargeDrug']['forth']]);	*/
				/*debug(date("Y-m-d h:i A",strtotime("-15 minutes",strtotime(date("Y-m-d h:i A", strtotime($getMedicationTime[$value['DischargeDrug']['first']]))))));		
				debug(date("Y-m-d h:i A",strtotime($getMedicationTime[$value['DischargeDrug']['first']])));	*/	
				/*debug(date("Y-m-d h:i A",strtotime("-15 minutes",strtotime(date("Y-m-d h:i A", strtotime($getMedicationTime[$value['DischargeDrug']['first']])))))."+++++++".strtotime(date("Y-m-d h:i A",strtotime("-15 minutes",strtotime(date("Y-m-d h:i A", strtotime($getMedicationTime[$value['DischargeDrug']['first']])))))));		
				debug(date("Y-m-d h:i A")."++++++++".strtotime(date("Y-m-d h:i A")));	*/
				if(strtotime(date("Y-m-d h:i A"))==strtotime(date("Y-m-d h:i A",strtotime("-15 minutes",strtotime(date("Y-m-d h:i A", strtotime($getMedicationTime[$value['DischargeDrug']['first']]))))))){
						$scheduleMedicationText= sprintf(Configure::read('medication_msg'),$value['PharmacyItem']['name'],$getMedicationTime[$value['DischargeDrug']['first']],Configure::read('hosp_details'));													
						$hexMessage = str_replace('%u', '',$messageModel->utf8_to_unicode($scheduleMedicationText));//For Converting Hindi message into Hexa.							
						$messageModel->sendToSms($hexMessage,$value['Person']['mobile'],"Hexa");		//for send to patient							
				}
				if(strtotime(date("Y-m-d h:i A"))==strtotime(date("Y-m-d h:i A",strtotime("-15 minutes",strtotime(date("Y-m-d h:i A", strtotime($getMedicationTime[$value['DischargeDrug']['second']]))))))){
						$scheduleMedicationText= sprintf(Configure::read('medication_msg'),$value['PharmacyItem']['name'],$getMedicationTime[$value['DischargeDrug']['second']],Configure::read('hosp_details'));													
						$hexMessage = str_replace('%u', '',$messageModel->utf8_to_unicode($scheduleMedicationText));//For Converting Hindi message into Hexa.							
						$messageModel->sendToSms($hexMessage,$value['Person']['mobile'],"Hexa");		//for send to patient	
				}
				if(strtotime(date("Y-m-d h:i A"))==strtotime(date("Y-m-d h:i A",strtotime("-15 minutes",strtotime(date("Y-m-d h:i A", strtotime($getMedicationTime[$value['DischargeDrug']['third']]))))))){
						$scheduleMedicationText= sprintf(Configure::read('medication_msg'),$value['PharmacyItem']['name'],$getMedicationTime[$value['DischargeDrug']['third']],Configure::read('hosp_details'));													
						$hexMessage = str_replace('%u', '',$messageModel->utf8_to_unicode($scheduleMedicationText));//For Converting Hindi message into Hexa.							
						$messageModel->sendToSms($hexMessage,$value['Person']['mobile'],"Hexa");		//for send to patient	
				}
				if(strtotime(date("Y-m-d h:i A"))==strtotime(date("Y-m-d h:i A",strtotime("-15 minutes",strtotime(date("Y-m-d h:i A", strtotime($getMedicationTime[$value['DischargeDrug']['forth']]))))))){
						$scheduleMedicationText= sprintf(Configure::read('medication_msg'),$value['PharmacyItem']['name'],$getMedicationTime[$value['DischargeDrug']['forth']],Configure::read('hosp_details'));													
						$hexMessage = str_replace('%u', '',$messageModel->utf8_to_unicode($scheduleMedicationText));//For Converting Hindi message into Hexa.							
						$messageModel->sendToSms($hexMessage,$value['Person']['mobile'],"Hexa");		//for send to patient	
				}
			}
		}
		
	}
	/**
	 * function for send SMS to corresponding Users for Before discharge Take Noc to inform patient
	 * @param unknown_type whatever admission_date choose from Patient
	 * @Mahalaxmi
	 */
	public function smsToSendForDischargeTariffPatient(){
		App::uses('Patient', 'Model');	
		$patientModel = new Patient(null,null,$this->database);
		App::uses('TariffStandard', 'Model');	
		$tariffStandardModel = new TariffStandard(null,null,$this->database);
		App::uses('Message', 'Model');	
		$messageModel = new Message(null,null,$this->database);
		App::uses('Configuration', 'Model');	
		$configurationModel = new Configuration(null,null,$this->database);
		
		//BOF-Mahalaxmi For tariff Patient ids
		$getTariffArr=array(Configure::read('SECR'),Configure::read('CGHS'),Configure::read('ECHS'));
		$getTariffStandardIds=$tariffStandardModel->getTariffStandardIDAll($getTariffArr);
		#debug($getTariffStandardIds);
		$getTariffStandardMpkayId=$tariffStandardModel->getTariffStandardID('MPKAY');
		$getTariffStandardMpkayIds=array('MPKAY'=>$getTariffStandardMpkayId);
		#debug($getTariffStandardMpkayIds);
		$bothTariffIdsArr=array_merge($getTariffStandardIds,$getTariffStandardMpkayIds);
		#debug($tariffStandardModel->getDataSource()->getLog(false, false));exit;	
		#debug($bothTariffIdsArr);
		#exit;
		//EOF-Mahalaxmi For tariff Patient ids
		$patientModel->bindModel(
				array('belongsTo' => array(
						'TariffStandard' => array('type'=>'INNER','foreignKey'=>false,'conditions'=> array('TariffStandard.id=Patient.tariff_standard_id')),
		)));
		$patientData = $patientModel->find('all',array('fields'=>array('Patient.lookup_name','Patient.is_discharge','TariffStandard.name','Patient.tariff_standard_id','Patient.form_received_on'),'conditions'=>array('Patient.tariff_standard_id'=>$bothTariffIdsArr,'Patient.is_discharge'=>0,'Patient.is_deleted'=>0)));
		
		$smsActive=$configurationModel->getConfigSmsValue('NOC Remainder','1');	
		
		if($smsActive){			
			$getFormRecievedOn='';
			foreach ($patientData as $key => $value) {
				$getFormRecievedOn=explode(" ",$value['Patient']['form_received_on']);							
				if($getTariffStandardMpkayId==$value['Patient']['tariff_standard_id']){ //BOF MPKY tariff	
					#debug($value['Patient']['lookup_name']."+++++++".$getFormRecievedOn[0]);
					#debug($value['Patient']['lookup_name']."+++++++".date('Y-m-d')."+++++++++++++++".date('Y-m-d',strtotime('+4 days',strtotime($getFormRecievedOn[0]))));
					if(date('Y-m-d')==date('Y-m-d',strtotime('+4 days',strtotime($getFormRecievedOn[0])))){ //5th day
						$scheduleNocText= sprintf(Configure::read('noc_msg'),'5',$value['Patient']['lookup_name'],$value['TariffStandard']['name'],Configure::read('hosp_details'));																
						$messageModel->sendToSms($scheduleNocText,Configure::read('MPKAY_NOC'));		//for send to patient						
					}
					if(date('Y-m-d')==date('Y-m-d',strtotime('+10 days',strtotime($getFormRecievedOn[0])))){ //11th day
						$scheduleNocText= sprintf(Configure::read('noc_msg'),'11',$value['Patient']['lookup_name'],$value['TariffStandard']['name'],Configure::read('hosp_details'));												
						$messageModel->sendToSms($scheduleNocText,Configure::read('MPKAY_NOC'));		//for send to patient	
					}
					if(date('Y-m-d')==date('Y-m-d',strtotime('+17 days',strtotime($getFormRecievedOn[0])))){ //18th day
						$scheduleNocText= sprintf(Configure::read('noc_msg'),'18',$value['Patient']['lookup_name'],$value['TariffStandard']['name'],Configure::read('hosp_details'));												
						$messageModel->sendToSms($scheduleNocText,Configure::read('MPKAY_NOC'));		//for send to patient	
					}
				}//EOF MPKY tariff

				if(in_array($value['Patient']['tariff_standard_id'], $getTariffStandardIds)){ //BOF SECR,CGHS,ECHS tariff	
					if(date('Y-m-d')==date('Y-m-d',strtotime('+7 days',strtotime($getFormRecievedOn[0])))){ //8th day
						$scheduleNocText= sprintf(Configure::read('noc_msg'),'8',$value['Patient']['lookup_name'],$value['TariffStandard']['name'],Configure::read('hosp_details'));												
						$messageModel->sendToSms($scheduleNocText,Configure::read('SECR_CGHS_ECHS_NOC'));		//for send to patient	
					}
					if(date('Y-m-d')==date('Y-m-d',strtotime('+24 days',strtotime($getFormRecievedOn[0])))){ //25th day
						$scheduleNocText= sprintf(Configure::read('noc_msg'),'25',$value['Patient']['lookup_name'],$value['TariffStandard']['name'],Configure::read('hosp_details'));												
						$messageModel->sendToSms($scheduleNocText,Configure::read('SECR_CGHS_ECHS_NOC'));		//for send to patient	
					}				
				}//EOF SECR,CGHS,ECHS tariff	
			}	
		}

	}
	/**
	 * function for send SMS to Patient Daily
	 * @param unknown_type whatever time choose from discharge summary
	 * @Mahalaxmi
	 */
	public function smsToSendForDocumentUpload(){
		#Configure::write('debug',2) ;
		App::uses('PatientDocument', 'Model');					
		$patientDocumentModel = new PatientDocument(null,null,$this->database);		
		App::uses('Patient', 'Model');	
		$patientModel = new Patient(null,null,$this->database);
		App::uses('Person', 'Model');	
		$personModel = new Person(null,null,$this->database);	
		App::uses('Configuration', 'Model');	
		$configurationModel = new Configuration(null,null,$this->database);
		App::uses('Message', 'Model');	
		$messageModel = new Message(null,null,$this->database);		
		
		
		$patientDocumentModel->bindModel(
				array('belongsTo' => array(						
						'Patient'=>array('type'=>'INNER','foreignKey'=>false,'conditions'=>array('Patient.id=PatientDocument.patient_id')),
						'Person'=>array('type'=>'INNER','foreignKey'=>false,'conditions'=>array('Person.id=Patient.person_id')),
						
		),));
		$results = $patientDocumentModel->find('all',array('fields'=>array('PatientDocument.id','PatientDocument.sms_sent','Patient.lookup_name','Patient.id'),'conditions'=>array('PatientDocument.sms_sent'=>0)));		
		#debug($results);
		//exit;
		#debug($dischargeSummaryModel->Patient->getDataSource()->getLog(false, false));exit;	
		$smsActive=$configurationModel->getConfigSmsValue('External Radiology Request','1');	
		
		if($smsActive){			
			foreach($results as $key => $value){			
				$patientName[$value['Patient']['id']]=$value['Patient']['lookup_name'];			
				$patientDocumentModel->updateAll(array('PatientDocument.sms_sent'=>1),array('PatientDocument.id'=>$value['PatientDocument']['id']));													
			}
			//debug($patientName);
			if(!empty($patientName)){
				$patientLookupName=implode(",",$patientName);
				$showMsg= sprintf(Configure::read('upload'),$patientLookupName);					
				//debug($showMsg);				
				$getResuSms=$messageModel->sendToSms($showMsg,Configure::read('upload_mobile_no')); 	
			}
		}		
	}
}