<?php
/**
 *  Controller : persons
 *  Use : AEDV- UID_patients
 *  @created by :pankaj wanjari
 *  @created on :07 Dec 2011
 *  functions : add,edit,view,search of UID_patient
 *ic
 **/
class PersonsController extends AppController {

	public $name = 'Persons';
	public $helpers = array('Html','Form', 'Js','DateFormat','General', 'JsFusionChart');
	public $components = array('RequestHandler','Email','ImageUpload','DateFormat','QRCode','GibberishAES');

	public function beforeFilter() {
		$this->Auth->allow('certificate','certificate_form','quickReg','getStateCity','getAgeFromDob','generateQrCode','emergencyReg','emergency_reg','patient_registration','generate_qr','typeformreg');
	}
	public function index(){
			
		//display add patient by default
		$this->redirect(array('action'=>'search'));
	}
	
	
// poonam
public function typeformreg(){
		$this->layout = false ;

		$this->uses = array('Initial','DoctorProfile','Patient','Department','Configuration','NewCropPrescription','TariffStandard',
				'Appointment','State','Account','TariffList','Billing','User','Person','Location','ServiceBill','CouponTransaction');
		App::import('Vendor', 'DrmhopeDB');
		if($this->Session->read('db_name')){
			$db_connection = new DrmhopeDB($this->Session->read('db_name'));
		}else{
			$db_connection = new DrmhopeDB('db_hope');
			$db_connection_hospital = new DrmhopeDB('db_HopeHospital');
		}
		
		$db_connection->makeConnection($this->Initial);
		$db_connection->makeConnection($this->DoctorProfile);
		$db_connection->makeConnection($this->Patient);
		$db_connection->makeConnection($this->Person);
		$db_connection->makeConnection($this->Department);
		$db_connection->makeConnection($this->Configuration);
		$db_connection->makeConnection($this->NewCropPrescription);
		$db_connection->makeConnection($this->TariffStandard);
		$db_connection->makeConnection($this->Appointment);
		$db_connection->makeConnection($this->State);
		$db_connection->makeConnection($this->Account);
		$db_connection->makeConnection($this->TariffList);
		$db_connection->makeConnection($this->Billing);
		$db_connection->makeConnection($this->User);
		$db_connection->makeConnection($this->Location);
		$db_connection->makeConnection($this->ServiceBill);
		$db_connection->makeConnection($this->DateFormat);
		
		if (isset($db_connection_hospital)) {
    $db_connection_hospital->makeConnection($this->DoctorProfile);
    $db_connection_hospital->makeConnection($this->Patient);
    $db_connection_hospital->makeConnection($this->Billing);
    $db_connection_hospital->makeConnection($this->TariffList);
}

		$this->Session->write('istypeformreg',"0");
		$privateID = $this->TariffStandard->getPrivateTariffID();
		//location list
		$locations = $this->Location->find('list',array('fields'=>array('name'),'conditions'=>array('Location.is_active'=>1,'Location.is_deleted'=>0)));
		$this->set(array('privateID'=>$privateID,'locations'=>$locations));
		//debug($this->request->data);die();
		if(!empty($this->request->data["Person"])){
			// staff registration and restrict account creation code added by atul chandankhede
			if($this->request->data["Person"]["is_staff_register"] == '1'){
				$staffName = explode(" ", $this->request->data["Person"]["staff_name"]);
				$this->request->data["Person"]["first_name"] =$staffName[0]; 
				$this->request->data["Person"]["last_name"] =$staffName[1];
				$this->request->data["Patient"]["is_staff_register"] = $this->request->data["Person"]["is_staff_register"];
			}
	
			if(!empty($this->request->data["Person"]['dob'])){
				$dob = $this->request->data["Person"]['dob'];
				$this->request->data["Person"]['dob'] = $this->DateFormat->formatDate2STD($dob,Configure::read('date_format'));
				$years = ($this->request->data["Person"]['age_year'] != '0') ? $this->request->data["Person"]['age_year'].'Y ' : '';
				$months = ($this->request->data["Person"]['age_month'] != '0') ? $this->request->data["Person"]['age_month'].'M ' : '';
				$days = $this->request->data["Person"]['age_day'].'D';
				$this->request->data["Person"]['age'] = $years.$months.$days ;
			}
			$this->Person->begin();
			$lastid = $this->Person->insertPerson($this->request->data,'insert','emregency','typeformreg');
			if(!empty($errors)) {
				$this->set("errors", $errors);
			}else {
				//foto upload by pankaj w
				if(!empty($this->request->data['Person']['upload_image']['name'])){
					//creating runtime image name
					$original_image_extension  = explode(".",$this->request->data['Person']['upload_image']['name']);
					if(!isset($original_image_extension[1])){
						$imagename= "person_".mktime().'.'.$original_image_extension[0];
					}else{
						$imagename= "person_".mktime().'.'.$original_image_extension[1];
					}
					//set new image name to DB
					$this->request->data["Person"]['photo']  = $imagename ;
				}else if(!empty($this->request->data['Person']['web_cam'])){
					$im = imagecreatefrompng($this->request->data['Person']['web_cam']);
					if($im){
						$imagename= "person_".mktime().'.png';
						imagejpeg($im,WWW_ROOT.'/uploads/patient_images/thumbnail/'.$imagename);
						$this->request->data["Person"]['photo']  = $imagename ;
					}else{
						unset($this->request->data["Person"]['photo']);
					}
				}else{
					unset($this->request->data["Person"]['photo']);
				}
				if(!empty($this->request->data['Person']['upload_image']['name'])){
					if($this->request->data['Person']['upload_image']['error']){
						if( $this->request->data['Person']['upload_image']['error']==1 ||
								$this->request->data['Person']['upload_image']['error'] ==2){
							$this->Session->setFlash(__('Max file size 2MB exceeded,Please try again', true),array('class'=>'error'));
						}else{
							$this->Session->setFlash(__('There is problem while uplaoding image,Please try again', true),array('class'=>'error'));
						}
					}else{
						$showError = $this->ImageUpload->uploadFile($this->params,'upload_image','uploads/patient_images',$imagename);
						if(empty($showError)) {
							// making thumbnail of 100X100
							$this->ImageUpload->load($this->request->data['Person']['upload_image']['tmp_name']);
							$this->ImageUpload->resize(100,100);
							$this->ImageUpload->save("uploads/patient_images/thumbnail/".$imagename);
						}
					}
				}
				
				//EOF foto upload
				$latest_insert_id = $this->Person->getInsertId();
				$patient_id   = $this->autoGeneratedPatientID($latest_insert_id,$this->request->data);
				$this->request->data['Person']['id'] = $latest_insert_id ;
				$this->request->data['Person']['patient_uid'] =$patient_id ;
				$this->request->data['Person']['alternate_patient_uid'] =$latest_insert_id ;
				$this->request->data['Person']['payment_category'] = 'cash';
				$this->request->data['Person']['expected_date_del'] = $this->DateFormat->formatDate2STD($this->request->data['Person']['expected_date_del'],Configure::read('date_format'));
				//QR code image generation
				$qrformat =  $this->qrFormat($this->request->data['Person']);
				App::import('Vendor', 'qrcode', array('file' => 'qrcode/qrlib.php'));
				QRcode::png($qrformat, "uploads/qrcodes/$patient_id.png", 'L', 4, 2);

				$this->Person->save($this->request->data);
				$id=$this->Person->find('first',array('fields'=>array('Person.patient_uid'),'order'=>'Person.id DESC'));
			}
			$this->request->data['Patient']['person_id'] = $latest_insert_id;
			$this->request->data['Patient']['patient_id'] =$id['Person']['patient_uid'];
			$this->request->data['Patient']['is_deleted'] = 0;
			
			$this->request->data['Patient']['dob'] = $this->DateFormat->formatDate2STD($dob,Configure::read('date_format'));
			//by pankaj w for vadodara only
			if($this->Session->read('website.instance')=='vadodara'){
				$this->request->data['Patient']['location_id'] = $this->request->data['Person']['location_id'] ;
			}else{
				$this->request->data['Patient']['location_id'] = $this->Session->read('locationid')?$this->Session->read('locationid'):1 ;
			}
			$this->request->data['Patient']['admission_type'] = 'OPD';
			$this->request->data['Patient']['lookup_name']= $this->request->data["Person"]['first_name']." ".$this->request->data["Person"]['last_name'];
			$this->request->data['Patient']['is_emergency'] = 0;
			/** Krupya Hat Lau Naye */
			$formRecievedOn = trim($this->request->data['Patient']['form_received_on']).' '.trim($this->request->data['Person']['start_time']);
			/** aadesha anusar */
			$this->request->data['Patient']['form_received_on'] = $this->DateFormat->formatDate2STD($formRecievedOn,Configure::read('date_format'));
			$this->request->data['Patient']['form_completed_on'] = $this->DateFormat->formatDate2STD($formRecievedOn,Configure::read('date_format'));
			$this->request->data['Patient']['create_time'] = date('Y-m-d H:i:s') ;
			$this->request->data['Patient']['expected_date_del'] = $this->request->data['Person']['expected_date_del'];
			$this->request->data['Patient']['pregnant_week'] = $this->request->data['Person']['pregnant_week'];
			$this->request->data['Patient']['created_by'] = $this->Session->read('userid')?$this->Session->read('userid'):1 ;
			$this->request->data['Patient']['is_discharge']= 0 ;
			$this->request->data['Patient']['sex']= $this->request->data['Person']['sex'];
			$this->request->data['Patient']['age']= $this->request->data['Person']['age'];
			$this->request->data['Patient']['payment_category'] = 'cash';
			$this->request->data['Patient']['coupon_name'] = $this->request->data["Person"]['coupon_name'];
			$this->request->data['Patient']['coupon_amount'] =$this->request->data["Person"]['coupon_amount'];
			$this->request->data['Patient']['initial_id'] =$this->request->data["Person"]['initial_id'];
		
			//BOF-Mahalaxmi For File number added in Patient Table
			$fileNoPatient = $this->Patient->generatePatientFileNo();				
			$this->request->data['Patient']['file_number'] =$fileNoPatient;
			//EOF-Mahalaxmi For File number added in Patient Table
			$admission_id = $this->Patient->autoGeneratedAdmissionID($latest_id,$this->request->data);
			$this->request->data['Patient']['admission_id'] =$admission_id;
			if($this->Patient->save($this->request->data['Patient']))
				$this->Person->commit();
			else
				$this->Person->rollback();

			$latest_id = $this->Patient->getInsertId();
			//add mandatory charges by pankajw
			$this->Account->insertMandatoryServiceCharges($this->request->data,$latest_id); // by yashwant
			//EOF mandatory charges by pankajw
			
			if($this->request->data['Patient']['coupon_name']!='' and Configure::read('Coupon')){
				$this->CouponTransaction->setCouponTransaction($latest_insert_id,$this->request->data['Patient']['coupon_name']);
				if($this->request->data["Patient"]['admission_type'] == "OPD")
					$this->request->data['Patient']['total'] =  $this->CouponTransaction->ApplyCouponDiscount($latest_insert_id,$this->request->data['Patient']['coupon_amount']);
			}
				
			
			
			
			//generate QrCode of admission_id and Patient Name - by Mrunal
			$age = explode(' ', $this->request->data['Patient']['age']);
			$concatedPatientName = $this->request->data['Patient']['lookup_name']." ".$age[0]." ".trim($admission_id);
			$lookup_name_withspace = preg_replace('/[^A-Za-z0-9]/', ' ', $concatedPatientName);
			$this->Patient->getPatientAdmissionIdQR(trim($admission_id),$latest_id);
			$this->Patient->getPatientNameQR($lookup_name_withspace,$latest_id);
			//end Of qrcode
			
			$this->Patient->updateAll(array('Patient.admission_id' => "'$admission_id'",'Patient.account_number' => "'$admission_id'"),array('Patient.id'=>$latest_id));
			//  New QR Code As per EMAR Criteria Requirement
			$qrString = $patient_id;//."#".$this->request->data['Patient']['lookup_name']."#".$dob;
			// generate Text Type QrCode
			//$this->QRCode ->text(trim($qrString));
			// display new QR code image
			//$this->QRCode ->draw(150, "uploads/qrcodes/".$admission_id.".png"); //qr code commneted by pankajw as it is not allow to register offline 
			if($this->request->data['setSoap'])
				$this->NewCropPrescription->insertDrugFromQuickReg($this->request->data,$latest_id);
			$this->set('isquickregsave',"1");
			$this->set('patientId',$latest_id);
			$doctorId = $this->request->data['Patient']['doctor_id'];//gaurav

			// for redirect from registration to billing page-Atul
			/*$this->loadModel('Configuration');
			 $redirect = $this->Configuration->find('first',array('conditions'=>array('name'=>'Redirect From Registration')));
			$previousData = unserialize($redirect['Configuration']['value']);
			if($previousData=='1'){
			$this->request->data['Patient']['person_id'] = $latest_insert_id;
			$this->request->data['Patient']['patient_id'] = $latest_id;
			$this->Appointment->setCurrentAppointment($this->request->data);
			$this->Session->setFlash(__('Record added Successfully', true),true,array('class'=>'message'));
			$this->redirect(array("controller"=>"Billings","action"=>"multiplePaymentModeIpd",$latest_id));
			}*/
			/** Creating New appointment and moving to patient list -- gaurav */
			$this->request->data['Patient']['person_id'] = $latest_insert_id;
// 			debug($latest_id);
			$this->request->data['Patient']['patient_id'] = $latest_id;
// 			debug($this->request->data);die();
			$this->Appointment->setCurrentAppointment($this->request->data);
			if($this->Session->read('website.instance')=='vadodara'){
				/**
				 * For setting up multiple appointment at a time 
				 */
				if($this->request->data['Appointment']){
					$this->Appointment->setMultipleAppointment($this->request->data);
				}
				// For after setting up multiple appointment print multiple OPD print sheet-Atul
			   $docPid[]=($this->request->data['Patient']['doctor_id']);
			   
		       if(!empty($this->request->data['Appointment']['doctor_id'])){
		       	 $doctorAppId=$this->request->data['Appointment']['doctor_id'];
		       }else{
		       	 $doctorAppId[]=$this->request->data['Appointment']['doctor_id'];
		       }
				$doctorIdArray = array_merge($docPid,$doctorAppId);
				$docIDArr=array_filter($doctorIdArray);	
			    $docArray=implode(",", $docIDArr);
	
				// EOF multiple appointment
				if(($this->request->data["Person"]['pay_amt']=='1') && ($this->request->data['Person']['printSheet'] =='1')){
					//function for saving data in billing and accounting
					
					$billId=$this->Billing->saveRegBill($this->request->data);
					
					///End OF code
					$this->Session->setFlash(__('Record added for - <b>'.$patient_id."</b>",true),'default',array('class'=>'stillSuccess','id'=>'stillFlashMessage'),'still');
					$this->redirect(array("controller" => "persons", "action" => "quickReg",'?'=>array('print'=>$billId,"patientId"=>$latest_id,'docId'=>$docArray)));
				
				} else{
					$this->redirect(array("controller" => "persons", "action" => "quickReg",'?'=>array("patientId"=>$latest_id,'docId'=>$docArray)));
				}
			}

        	if ($this->request->data['Person']['capturefingerprint'] == "1") {
            $this->Session->setFlash(__('Record Added Successfully', true), true, array('class' => 'message'));
            $this->redirect(array(
                "controller" => "persons", 
                "action" => "finger_print", 
                $latest_insert_id, 
                'capturefingerprint' => $this->request->data["Person"]['capturefingerprint'], 
                '?' => array('id' => $latest_insert_id)
            ));
        } else {
            // debug($patient_id);exit;
           
            $lastInsertedPersonId = $this->Person->getLastInsertId();
            $lastInsertedPatientId = $this->Patient->getLastInsertId();
            // $lastInseredPatien_uid = 
            
            // Capture the mobile number and next of kin's mobile number
              $mobile_number = isset($this->request->data['Person']['mobile']) ? $this->request->data['Person']['mobile'] : null;
              $first_name = isset($this->request->data['Person']['first_name']) ? $this->request->data['Person']['first_name'] : null;
              $last_name = isset($this->request->data['Person']['last_name']) ? $this->request->data['Person']['last_name'] : null;
              $next_of_kin_name = isset($this->request->data['Person']['next_of_kin_name']) ? $this->request->data['Person']['next_of_kin_name'] : null;
              $next_of_kin_number = isset($this->request->data['Person']['next_of_kin_mobile']) ? $this->request->data['Person']['next_of_kin_mobile'] : null;
        
            if (!empty($mobile_number)) {
                
                $this->Session->setFlash(__('Record Added Successfully. Generating QR Code for mobile and next of kin.', true), true, array('class' => 'message'));
                  $patientid = $lastInsertedPersonId . '/' . $lastInsertedPatientId;
         $user_qr_image_url = 'https://hopesoftwares.com/persons/generateQrCode/' . $patientid;
         $messageStatus = $this->sendWhatsAppMessage($mobile_number, $user_qr_image_url,$first_name,$lastInsertedPersonId,$patient_id);
        //  debug($user_qr_image_url);exit;
                // Redirect to generateQrCode function to generate QR codes and render the view
                $this->redirect(array(
                    "controller" => "persons",
                    "action" => "generateQrCode",
                    $lastInsertedPersonId,
                    $lastInsertedPatientId,
                ));
                 $this->redirect(array("controller" => "appointments", "action" => "appointments_management"));
            } else {
                $this->Session->setFlash(__('Mobile number is required to generate QR Code.', true), true, array('class' => 'error'));
                $this->redirect(array("controller" => "appointments", "action" => "appointments_management"));
            }
        }
        }

		$this->set('newState',$this->State->find('list',array('fields'=>array('id','name'),'conditions'=>array('State.country_id'=>'1'))));
		$getConfiguration=$this->Configuration->find('all');
		$strenght=unserialize($getConfiguration[0]['Configuration']['value']);
		$dose=unserialize($getConfiguration[1]['Configuration']['value']);
		$route=unserialize($getConfiguration[2]['Configuration']['value']);
		foreach($strenght as $strenghts){
			$str.='<option value='.'"'.stripslashes($strenghts).'"'.'>'.$strenghts.'</option>';
		}
		$str.='</select>';
		$this->set('str',$str);
		foreach($dose as $doses){
			$str_dose.='<option value='.'"'.stripslashes($doses).'"'.'>'.$doses.'</option>';
		}
		$str_dose.='</select>';
		$this->set('str_dose',$str_dose);
		foreach($route as $routes){
			$str_route.='<option value='.'"'.stripslashes($routes).'"'.'>'.$routes.'</option>';
		}
		$str_route.='</select>';
		$this->set('str_route',$str_route);
		foreach(unserialize($getConfiguration[0]['Configuration']['value']) as $key=>$strenght){
			if(!empty($strenght))
				$strenght_var[$strenght]=$strenght;
		}
		$this->set('strenght',$strenght_var);
		foreach(unserialize($getConfiguration[1]['Configuration']['value']) as $key=>$doses){
			if(!empty($doses))
				$dose_var[$doses]=$doses;
		}
		$this->set('dose',$dose_var);
		foreach(unserialize($getConfiguration[2]['Configuration']['value']) as $key=>$route){
			if(!empty($route))
				$route_var[$route]=$route;
		}
		/** gaurav */
		foreach($getConfiguration as $allowTimelyQuickReg){
			if($allowTimelyQuickReg['Configuration']['name'] == 'allowTimelyQuickReg')
				$allow = ($allowTimelyQuickReg['Configuration']['value'] == '1') ? true : false;
		}
		Configure :: write('allowTimelyQuickReg', $allow );
		/** EOF*/
		$this->set('route',$route_var);
		
		$this->set('initials',$this->Initial->find('list',array('fields'=>array('name'))));
		if(isset($this->Session) && !empty($this->Session->read('locationid'))){
			$OPCheckUpOptions=$this->TariffList->find('list',array('fields'=>array('id','name'),'conditions'=>array('is_deleted'=>'0','check_status'=>'1','location_id'=>$this->Session->read('locationid')?$this->Session->read('locationid'):1)));
			$this->set('opdoptions',$OPCheckUpOptions);

			//$this->set('doctorlist',$this->DoctorProfile->getDoctors());
			$this->set('doctorlist',$this->User->getOpdDoctors());
			$this->set('tariff',  $this->TariffStandard->find('list',array('order' => array('TariffStandard.name'),'conditions'=>array('is_deleted'=>0,'TariffStandard.location_id'=>$this->Session->read('locationid')?$this->Session->read('locationid'):1))));
			$this->set('departments',$this->Department->find('list',array('fields'=>array('id','name'),'conditions'=>array('Department.location_id'=>$this->Session->read('locationid')?$this->Session->read('locationid'):1),'order' => array('Department.name'))));
			$this->set('online',false);
		}else{
    $this->set('online', true);

    $this->set('doctorlist', [ '56' => 'B K Murali, MS (Orth.)','57' => 'Dr. Ritesh Navkhare, MD','58' => 'Dr. Atul Rajkondawar, MD','59' => 'Dr. Afsal Sheikh, MD' ]);
    $this->set('tariff', ['7' => 'Private','8' => 'General','9' => 'Corporate','10' => 'Insurance-based']);
    $this->set('opdoptions', ['4' => 'Consultation Charges', '5' => 'Follow-up Visit', '6' => 'Emergency Visit','7' => 'Second Opinion']);
    $this->set('departments',['12' => 'Orthopaedics','13' => 'Cardiology','14' => 'General Medicine', '15' => 'Pediatrics','16' => 'Neurology','17' => 'Abdominal or chest conditions']);
}
// when quick register form open in without login show this dropdown code by dinesh tawade
		/** setting searchPerson data to form inputs --gaurav  */
		$searchPersonData = $this->request->data;
		$this->request->data= '';
		if(!$searchPersonData['tariff_standard_id'])
			$searchPersonData['hidden_tariff_standard_id'] = '';
		else
			$searchPersonData['insurance_type_id'] = $searchPersonData['tariff_standard_id'];
		unset($searchPersonData['form_received_on'],$searchPersonData['tariff_standard_id']);
		$this->request->data['Person'] = $searchPersonData;
		$this->data = $this->request->data;
		
		//for set coupon transaction if coupon is applied
		if($this->request->data['Patient']['coupon_name'])
			$this->CouponTransaction->setCouponTransaction($latest_id,$this->request->data['Patient']['coupon_name']);
		//for fingerprint device
		
		$isFingerPrintEnable = $this->Configuration->find('first',array('conditions'=>array('name'=>'isFingerPrintEnable')));
		$this->set('isFingerPrintEnable',$isFingerPrintEnable['Configuration']['value']);
	}

	
	
	
	
// public function quickReg(){
// 		$this->layout = 'advance' ;

// 		$this->uses = array('Initial','DoctorProfile','Patient','Department','Configuration','NewCropPrescription','TariffStandard',
// 				'Appointment','State','Account','TariffList','Billing','User','Person','Location','ServiceBill','CouponTransaction');
// 		App::import('Vendor', 'DrmhopeDB');
// 		if($this->Session->read('db_name')){
// 			$db_connection = new DrmhopeDB($this->Session->read('db_name'));
// 		}else{
// 			$db_connection = new DrmhopeDB('db_hope');
// 		}
		
// 		$db_connection->makeConnection($this->Initial);
// 		$db_connection->makeConnection($this->DoctorProfile);
// 		$db_connection->makeConnection($this->Patient);
// 		$db_connection->makeConnection($this->Person);
// 		$db_connection->makeConnection($this->Department);
// 		$db_connection->makeConnection($this->Configuration);
// 		$db_connection->makeConnection($this->NewCropPrescription);
// 		$db_connection->makeConnection($this->TariffStandard);
// 		$db_connection->makeConnection($this->Appointment);
// 		$db_connection->makeConnection($this->State);
// 		$db_connection->makeConnection($this->Account);
// 		$db_connection->makeConnection($this->TariffList);
// 		$db_connection->makeConnection($this->Billing);
// 		$db_connection->makeConnection($this->User);
// 		$db_connection->makeConnection($this->Location);
// 		$db_connection->makeConnection($this->ServiceBill);
// 		$db_connection->makeConnection($this->DateFormat);

// 		$this->Session->write('isquickregsave',"0");
// 		$privateID = $this->TariffStandard->getPrivateTariffID();
// 		//location list
// 		$locations = $this->Location->find('list',array('fields'=>array('name'),'conditions'=>array('Location.is_active'=>1,'Location.is_deleted'=>0)));
// 		$this->set(array('privateID'=>$privateID,'locations'=>$locations));
// 		//debug($this->request->data);die();
// 		if(!empty($this->request->data["Person"])){
		  
// 			// staff registration and restrict account creation code added by atul chandankhede
// 			if($this->request->data["Person"]["is_staff_register"] == '1'){
// 				$staffName = explode(" ", $this->request->data["Person"]["staff_name"]);
// 				$this->request->data["Person"]["first_name"] =$staffName[0]; 
// 				$this->request->data["Person"]["last_name"] =$staffName[1];
// 				$this->request->data["Patient"]["is_staff_register"] = $this->request->data["Person"]["is_staff_register"];
// 			}
// // 			
			
// 			if(!empty($this->request->data["Person"]['dob'])){
// 				$dob = $this->request->data["Person"]['dob'];
// 				$this->request->data["Person"]['dob'] = $this->DateFormat->formatDate2STD($dob,Configure::read('date_format'));
// 				$years = ($this->request->data["Person"]['age_year'] != '0') ? $this->request->data["Person"]['age_year'].'Y ' : '';
// 				$months = ($this->request->data["Person"]['age_month'] != '0') ? $this->request->data["Person"]['age_month'].'M ' : '';
// 				$days = $this->request->data["Person"]['age_day'].'D';
// 				$this->request->data["Person"]['age'] = $years.$months.$days ;
// 			}
// 			$this->Person->begin();
// 			$lastid = $this->Person->insertPerson($this->request->data,'insert','emregency');
// 			if(!empty($errors)) {
// 				$this->set("errors", $errors);
// 			}else {
// 				//foto upload by pankaj w
// 				if(!empty($this->request->data['Person']['upload_image']['name'])){
// 					//creating runtime image name
// 					$original_image_extension  = explode(".",$this->request->data['Person']['upload_image']['name']);
// 					if(!isset($original_image_extension[1])){
// 						$imagename= "person_".mktime().'.'.$original_image_extension[0];
// 					}else{
// 						$imagename= "person_".mktime().'.'.$original_image_extension[1];
// 					}
// 					//set new image name to DB
// 					$this->request->data["Person"]['photo']  = $imagename ;
// 				}else if(!empty($this->request->data['Person']['web_cam'])){
// 					$im = imagecreatefrompng($this->request->data['Person']['web_cam']);
// 					if($im){
// 						$imagename= "person_".mktime().'.png';
// 						imagejpeg($im,WWW_ROOT.'/uploads/patient_images/thumbnail/'.$imagename);
// 						$this->request->data["Person"]['photo']  = $imagename ;
// 					}else{
// 						unset($this->request->data["Person"]['photo']);
// 					}
// 				}else{
// 					unset($this->request->data["Person"]['photo']);
// 				}
// 				if(!empty($this->request->data['Person']['upload_image']['name'])){
// 					if($this->request->data['Person']['upload_image']['error']){
// 						if( $this->request->data['Person']['upload_image']['error']==1 ||
// 								$this->request->data['Person']['upload_image']['error'] ==2){
// 							$this->Session->setFlash(__('Max file size 2MB exceeded,Please try again', true),array('class'=>'error'));
// 						}else{
// 							$this->Session->setFlash(__('There is problem while uplaoding image,Please try again', true),array('class'=>'error'));
// 						}
// 					}else{
// 						$showError = $this->ImageUpload->uploadFile($this->params,'upload_image','uploads/patient_images',$imagename);
// 						if(empty($showError)) {
// 							// making thumbnail of 100X100
// 							$this->ImageUpload->load($this->request->data['Person']['upload_image']['tmp_name']);
// 							$this->ImageUpload->resize(100,100);
// 							$this->ImageUpload->save("uploads/patient_images/thumbnail/".$imagename);
// 						}
// 					}
// 				}
				
// 				//EOF foto upload
// 				$latest_insert_id = $this->Person->getInsertId();
// 				$patient_id   = $this->autoGeneratedPatientID($latest_insert_id,$this->request->data);
// 				$this->request->data['Person']['id'] = $latest_insert_id ;
// 				$this->request->data['Person']['patient_uid'] =$patient_id ;
// 				$this->request->data['Person']['alternate_patient_uid'] =$latest_insert_id ;
// 				$this->request->data['Person']['payment_category'] = 'cash';
// 				$this->request->data['Person']['expected_date_del'] = $this->DateFormat->formatDate2STD($this->request->data['Person']['expected_date_del'],Configure::read('date_format'));
// 				//QR code image generation
// 				$qrformat =  $this->qrFormat($this->request->data['Person']);
// 				App::import('Vendor', 'qrcode', array('file' => 'qrcode/qrlib.php'));
// 				QRcode::png($qrformat, "uploads/qrcodes/$patient_id.png", 'L', 4, 2);
// 				$this->Person->save($this->request->data);
// 				$id=$this->Person->find('first',array('fields'=>array('Person.patient_uid'),'order'=>'Person.id DESC'));
// 			}
// 			$this->request->data['Patient']['person_id'] = $latest_insert_id;
// 			$this->request->data['Patient']['patient_id'] =$id['Person']['patient_uid'];
// 			$this->request->data['Patient']['is_deleted'] = 0;
			
// 			$this->request->data['Patient']['dob'] = $this->DateFormat->formatDate2STD($dob,Configure::read('date_format'));
// 			//by pankaj w for vadodara only
// 			if($this->Session->read('website.instance')=='vadodara'){
// 				$this->request->data['Patient']['location_id'] = $this->request->data['Person']['location_id'] ;
// 			}else{
// 				$this->request->data['Patient']['location_id'] = $this->Session->read('locationid')?$this->Session->read('locationid'):1 ;
// 			}
// 			$this->request->data['Patient']['admission_type'] = 'OPD';
// 			$this->request->data['Patient']['lookup_name']= $this->request->data["Person"]['first_name']." ".$this->request->data["Person"]['last_name'];
// 			$this->request->data['Patient']['is_emergency'] = 0;
// 			/** Krupya Hat Lau Naye */
// 			$formRecievedOn = trim($this->request->data['Patient']['form_received_on']).' '.trim($this->request->data['Person']['start_time']);
// 			/** aadesha anusar */
// 			$this->request->data['Patient']['form_received_on'] = $this->DateFormat->formatDate2STD($formRecievedOn,Configure::read('date_format'));
// 			$this->request->data['Patient']['form_completed_on'] = $this->DateFormat->formatDate2STD($formRecievedOn,Configure::read('date_format'));
// 			$this->request->data['Patient']['create_time'] = date('Y-m-d H:i:s') ;
// 			$this->request->data['Patient']['expected_date_del'] = $this->request->data['Person']['expected_date_del'];
// 			$this->request->data['Patient']['pregnant_week'] = $this->request->data['Person']['pregnant_week'];
// 			$this->request->data['Patient']['created_by'] = $this->Session->read('userid')?$this->Session->read('userid'):1 ;
// 			$this->request->data['Patient']['is_discharge']= 0 ;
// 			$this->request->data['Patient']['sex']= $this->request->data['Person']['sex'];
// 			$this->request->data['Patient']['age']= $this->request->data['Person']['age'];
// 			$this->request->data['Patient']['payment_category'] = 'cash';
// 			$this->request->data['Patient']['coupon_name'] = $this->request->data["Person"]['coupon_name'];
// 			$this->request->data['Patient']['coupon_amount'] =$this->request->data["Person"]['coupon_amount'];
// 			$this->request->data['Patient']['initial_id'] =$this->request->data["Person"]['initial_id'];

// 			//BOF-Mahalaxmi For File number added in Patient Table
// 			$fileNoPatient = $this->Patient->generatePatientFileNo();				
// 			$this->request->data['Patient']['file_number'] =$fileNoPatient;
// 		if (!$this->Auth->user()) {
//                     $lastPersonId = $latest_insert_id - 1;

//                     $latestAdmission = $this->Patient->find('first', [
//                         'fields' => ['Patient.admission_id'],
//                         'conditions' => ['Patient.person_id' => $lastPersonId],
//                     ]);
//                     if (!empty($latestAdmission['Patient']['admission_id'])) {
//                         $lastAdmissionId = $latestAdmission['Patient']['admission_id'];
//                         preg_match('/(\d+)$/', $lastAdmissionId, $matches);
//                         if (!empty($matches)) {
//                             $numericPart = (int)$matches[1]; // Extract numeric part
//                             $newNumericPart = str_pad($numericPart + 1, strlen($matches[1]), '0', STR_PAD_LEFT);
//                             $admission_id = substr($lastAdmissionId, 0, -strlen($matches[1])) . $newNumericPart;
//                             $existingAdmission = $this->Patient->find('first', [
//                                 'fields' => ['Patient.admission_id'],
//                                 'conditions' => ['Patient.admission_id' => $admission_id],
//                             ]);
                            
//                             if (!empty($existingAdmission['Patient']['admission_id'])) {
//                                 // Increment logic to ensure uniqueness (same approach as above)
//                                 preg_match('/(\d+)$/', $admission_id, $matches);
//                                 $numericPart = (int)$matches[1]; 
//                                 $newNumericPart = str_pad($numericPart + 1, strlen($matches[1]), '0', STR_PAD_LEFT);
//                                 $admission_id = substr($admission_id, 0, -strlen($matches[1])) . $newNumericPart;
                                
//                             }
//                             $this->request->data['Patient']['admission_id'] = $admission_id;
//                         }
//                     }
//                 } else {
//                     // If user is logged in, use auto-generated admission ID
//                     $admission_id = $this->Patient->autoGeneratedAdmissionID($latest_id, $this->request->data);
//                     $this->request->data['Patient']['admission_id'] = $admission_id;
//                 }
                
//                 // Save the data after checking for duplicate
//                 if ($this->Patient->save($this->request->data['Patient'])) {
//                   $this->Person->commit();
//                 } else {
//                     // Handle rollback if saving fails
//                     $this->Person->rollback();
//                 }
// 			$latest_id = $this->Patient->getInsertId();
// 			//add mandatory charges by pankajw
// 			$this->Account->insertMandatoryServiceCharges($this->request->data,$latest_id); // by yashwant
// 			//EOF mandatory charges by pankajw
			
// 			if($this->request->data['Patient']['coupon_name']!='' and Configure::read('Coupon')){
// 				$this->CouponTransaction->setCouponTransaction($latest_insert_id,$this->request->data['Patient']['coupon_name']);
// 				if($this->request->data["Patient"]['admission_type'] == "OPD")
// 					$this->request->data['Patient']['total'] =  $this->CouponTransaction->ApplyCouponDiscount($latest_insert_id,$this->request->data['Patient']['coupon_amount']);
// 			}
				
			
// 			//generate QrCode of admission_id and Patient Name - by Mrunal
// 			$age = explode(' ', $this->request->data['Patient']['age']);
// 			$concatedPatientName = $this->request->data['Patient']['lookup_name']." ".$age[0]." ".trim($admission_id);
// 			$lookup_name_withspace = preg_replace('/[^A-Za-z0-9]/', ' ', $concatedPatientName);
// 			$this->Patient->getPatientAdmissionIdQR(trim($admission_id),$latest_id);
// 			$this->Patient->getPatientNameQR($lookup_name_withspace,$latest_id);
// 			//end Of qrcode
			
// 			$this->Patient->updateAll(array('Patient.admission_id' => "'$admission_id'",'Patient.account_number' => "'$admission_id'"),array('Patient.id'=>$latest_id));
// 			//  New QR Code As per EMAR Criteria Requirement
// 			$qrString = $patient_id;//."#".$this->request->data['Patient']['lookup_name']."#".$dob;
// 			// generate Text Type QrCode
// 			//$this->QRCode ->text(trim($qrString));
// 			// display new QR code image
// 			//$this->QRCode ->draw(150, "uploads/qrcodes/".$admission_id.".png"); //qr code commneted by pankajw as it is not allow to register offline 
// 			if($this->request->data['setSoap'])
// 				$this->NewCropPrescription->insertDrugFromQuickReg($this->request->data,$latest_id);
// 			$this->set('isquickregsave',"1");
// 			$this->set('patientId',$latest_id);
// 			$doctorId = $this->request->data['Patient']['doctor_id'];//gaurav

// 			// for redirect from registration to billing page-Atul
// 			/*$this->loadModel('Configuration');
// 			 $redirect = $this->Configuration->find('first',array('conditions'=>array('name'=>'Redirect From Registration')));
// 			$previousData = unserialize($redirect['Configuration']['value']);
// 			if($previousData=='1'){
// 			$this->request->data['Patient']['person_id'] = $latest_insert_id;
// 			$this->request->data['Patient']['patient_id'] = $latest_id;
// 			$this->Appointment->setCurrentAppointment($this->request->data);
// 			$this->Session->setFlash(__('Record added Successfully', true),true,array('class'=>'message'));
// 			$this->redirect(array("controller"=>"Billings","action"=>"multiplePaymentModeIpd",$latest_id));
// 			}*/
// 			/** Creating New appointment and moving to patient list -- gaurav */
// 			$this->request->data['Patient']['person_id'] = $latest_insert_id;
// 			$this->request->data['Patient']['patient_id'] = $latest_id;
// 			//debug($this->request->data);die();
// 			$this->Appointment->setCurrentAppointment($this->request->data);
// 			if($this->Session->read('website.instance')=='vadodara'){
// 				/**
// 				 * For setting up multiple appointment at a time 
// 				 */
// 				if($this->request->data['Appointment']){
// 					$this->Appointment->setMultipleAppointment($this->request->data);
// 				}
// 				// For after setting up multiple appointment print multiple OPD print sheet-Atul
// 			   $docPid[]=($this->request->data['Patient']['doctor_id']);
			   
// 		       if(!empty($this->request->data['Appointment']['doctor_id'])){
// 		       	 $doctorAppId=$this->request->data['Appointment']['doctor_id'];
// 		       }else{
// 		       	 $doctorAppId[]=$this->request->data['Appointment']['doctor_id'];
// 		       }
// 				$doctorIdArray = array_merge($docPid,$doctorAppId);
// 				$docIDArr=array_filter($doctorIdArray);	
// 			    $docArray=implode(",", $docIDArr);
	
// 				// EOF multiple appointment
// 				if(($this->request->data["Person"]['pay_amt']=='1') && ($this->request->data['Person']['printSheet'] =='1')){
// 					//function for saving data in billing and accounting
					
// 					$billId=$this->Billing->saveRegBill($this->request->data);
					
// 					///End OF code
// 					$this->Session->setFlash(__('Record added for - <b>'.$patient_id."</b>",true),'default',array('class'=>'stillSuccess','id'=>'stillFlashMessage'),'still');
// 					$this->redirect(array("controller" => "persons", "action" => "quickReg",'?'=>array('print'=>$billId,"patientId"=>$latest_id,'docId'=>$docArray)));
				
// 				} else{
// 					$this->redirect(array("controller" => "persons", "action" => "quickReg",'?'=>array("patientId"=>$latest_id,'docId'=>$docArray)));
// 				}
// 			}

//         	if ($this->request->data['Person']['capturefingerprint'] == "1") {
//             $this->Session->setFlash(__('Record Added Successfully', true), true, array('class' => 'message'));
//             $this->redirect(array(
//                 "controller" => "persons", 
//                 "action" => "finger_print", 
//                 $latest_insert_id, 
//                 'capturefingerprint' => $this->request->data["Person"]['capturefingerprint'], 
//                 '?' => array('id' => $latest_insert_id)
//             ));
//         } else {
//             // debug($patient_id);
           
//             $lastInsertedPersonId = $this->Person->getLastInsertId();
//             $lastInsertedPatientId = $this->Patient->getLastInsertId();
//             // $lastInseredPatien_uid = 
//         //       debug($lastInsertedPersonId);
//         //  debug($lastInsertedPatientId);exit;
            
//             // Capture the mobile number and next of kin's mobile number
//               $mobile_number = isset($this->request->data['Person']['mobile']) ? $this->request->data['Person']['mobile'] : null;
//               $first_name = isset($this->request->data['Person']['first_name']) ? $this->request->data['Person']['first_name'] : null;
//               $last_name = isset($this->request->data['Person']['last_name']) ? $this->request->data['Person']['last_name'] : null;
//               $next_of_kin_name = isset($this->request->data['Person']['next_of_kin_name']) ? $this->request->data['Person']['next_of_kin_name'] : null;
//               $next_of_kin_number = isset($this->request->data['Person']['next_of_kin_mobile']) ? $this->request->data['Person']['next_of_kin_mobile'] : null;
        
//             if (!empty($mobile_number)) {
                
//                 $this->Session->setFlash(__('Record Added Successfully. Generating QR Code for mobile and next of kin.', true), true, array('class' => 'message'));
//                   $patientid = $lastInsertedPersonId . '/' . $lastInsertedPatientId;
//          $user_qr_image_url = 'https://hopesoftwares.com/persons/generateQrCode/' . $patientid;
//          $messageStatus = $this->sendWhatsAppMessage($mobile_number, $user_qr_image_url,$first_name,$lastInsertedPersonId,$patient_id);
      
//                 // Redirect to generateQrCode function to generate QR codes and render the view
//                 $this->redirect(array(
//                     "controller" => "persons",
//                     "action" => "generateQrCode",
//                     $lastInsertedPersonId,
//                     $lastInsertedPatientId,
//                 ));
//                  $this->redirect(array("controller" => "appointments", "action" => "appointments_management"));
//             } else {
//                 $this->Session->setFlash(__('Mobile number is required to generate QR Code.', true), true, array('class' => 'error'));
//                 $this->redirect(array("controller" => "appointments", "action" => "appointments_management"));
//             }
//         }
//         }

// 		$this->set('newState',$this->State->find('list',array('fields'=>array('id','name'),'conditions'=>array('State.country_id'=>'1'))));
// 		$getConfiguration=$this->Configuration->find('all');
// 		$strenght=unserialize($getConfiguration[0]['Configuration']['value']);
// 		$dose=unserialize($getConfiguration[1]['Configuration']['value']);
// 		$route=unserialize($getConfiguration[2]['Configuration']['value']);
// 		foreach($strenght as $strenghts){
// 			$str.='<option value='.'"'.stripslashes($strenghts).'"'.'>'.$strenghts.'</option>';
// 		}
// 		$str.='</select>';
// 		$this->set('str',$str);
// 		foreach($dose as $doses){
// 			$str_dose.='<option value='.'"'.stripslashes($doses).'"'.'>'.$doses.'</option>';
// 		}
// 		$str_dose.='</select>';
// 		$this->set('str_dose',$str_dose);
// 		foreach($route as $routes){
// 			$str_route.='<option value='.'"'.stripslashes($routes).'"'.'>'.$routes.'</option>';
// 		}
// 		$str_route.='</select>';
// 		$this->set('str_route',$str_route);
// 		foreach(unserialize($getConfiguration[0]['Configuration']['value']) as $key=>$strenght){
// 			if(!empty($strenght))
// 				$strenght_var[$strenght]=$strenght;
// 		}
// 		$this->set('strenght',$strenght_var);
// 		foreach(unserialize($getConfiguration[1]['Configuration']['value']) as $key=>$doses){
// 			if(!empty($doses))
// 				$dose_var[$doses]=$doses;
// 		}
// 		$this->set('dose',$dose_var);
// 		foreach(unserialize($getConfiguration[2]['Configuration']['value']) as $key=>$route){
// 			if(!empty($route))
// 				$route_var[$route]=$route;
// 		}
// 		/** gaurav */
// 		foreach($getConfiguration as $allowTimelyQuickReg){
// 			if($allowTimelyQuickReg['Configuration']['name'] == 'allowTimelyQuickReg')
// 				$allow = ($allowTimelyQuickReg['Configuration']['value'] == '1') ? true : false;
// 		}
// 		Configure :: write('allowTimelyQuickReg', $allow );
// 		/** EOF*/
// 		$this->set('route',$route_var);
		
// 		$this->set('initials',$this->Initial->find('list',array('fields'=>array('name'))));
// 		if(isset($this->Session) && !empty($this->Session->read('locationid'))){
// 			$OPCheckUpOptions=$this->TariffList->find('list',array('fields'=>array('id','name'),'conditions'=>array('is_deleted'=>'0','check_status'=>'1','location_id'=>$this->Session->read('locationid')?$this->Session->read('locationid'):1)));
// 			$this->set('opdoptions',$OPCheckUpOptions);

// 			//$this->set('doctorlist',$this->DoctorProfile->getDoctors());
// 			$this->set('doctorlist',$this->User->getOpdDoctors());
// 			$this->set('tariff',  $this->TariffStandard->find('list',array('order' => array('TariffStandard.name'),'conditions'=>array('is_deleted'=>0,'TariffStandard.location_id'=>$this->Session->read('locationid')?$this->Session->read('locationid'):1))));
// 			$this->set('departments',$this->Department->find('list',array('fields'=>array('id','name'),'conditions'=>array('Department.location_id'=>$this->Session->read('locationid')?$this->Session->read('locationid'):1),'order' => array('Department.name'))));
// 			$this->set('online',false);
// 		}else{
//     $this->set('online', true);

//     $this->set('doctorlist', [ '56' => 'B K Murali, MS (Orth.)','57' => 'Dr. Ritesh Navkhare, MD','58' => 'Dr. Atul Rajkondawar, MD','59' => 'Dr. Afsal Sheikh, MD' ]);
//     $this->set('tariff', ['7' => 'Private','8' => 'General','9' => 'Corporate','10' => 'Insurance-based']);
//     $this->set('opdoptions', ['4' => 'Consultation Charges', '5' => 'Follow-up Visit', '6' => 'Emergency Visit','7' => 'Second Opinion']);
//     $this->set('departments',['12' => 'Orthopaedics','13' => 'Cardiology','14' => 'General Medicine', '15' => 'Pediatrics','16' => 'Neurology','17' => 'Abdominal or chest conditions']);
// }
// // when quick register form open in without login show this dropdown code by dinesh tawade
// 		/** setting searchPerson data to form inputs --gaurav  */
// 		$searchPersonData = $this->request->data;
// 		$this->request->data= '';
// 		if(!$searchPersonData['tariff_standard_id'])
// 			$searchPersonData['hidden_tariff_standard_id'] = '';
// 		else
// 			$searchPersonData['insurance_type_id'] = $searchPersonData['tariff_standard_id'];
// 		unset($searchPersonData['form_received_on'],$searchPersonData['tariff_standard_id']);
// 		$this->request->data['Person'] = $searchPersonData;
// 		$this->data = $this->request->data;
		
// 		//for set coupon transaction if coupon is applied
// 		if($this->request->data['Patient']['coupon_name'])
// 			$this->CouponTransaction->setCouponTransaction($latest_id,$this->request->data['Patient']['coupon_name']);
// 		//for fingerprint device
		
// 		$isFingerPrintEnable = $this->Configuration->find('first',array('conditions'=>array('name'=>'isFingerPrintEnable')));
// 		$this->set('isFingerPrintEnable',$isFingerPrintEnable['Configuration']['value']);
// 	}
	
public function quickReg(){
		$this->layout = 'advance' ;

		$this->uses = array('Initial','DoctorProfile','Patient','Department','Configuration','NewCropPrescription','TariffStandard',
				'Appointment','State','Account','TariffList','Billing','User','Person','Location','ServiceBill','CompanyName','Staff','CouponTransaction');
		App::import('Vendor', 'DrmhopeDB');
		if($this->Session->read('db_name')){
			$db_connection = new DrmhopeDB($this->Session->read('db_name'));
		}else{
			$db_connection = new DrmhopeDB('db_hope');
			$db_connection_hospital = new DrmhopeDB('db_HopeHospital');
		}
		
		$db_connection->makeConnection($this->Initial);
		$db_connection->makeConnection($this->DoctorProfile);
		$db_connection->makeConnection($this->Patient);
		$db_connection->makeConnection($this->Person);
		$db_connection->makeConnection($this->Department);
		$db_connection->makeConnection($this->Configuration);
		$db_connection->makeConnection($this->NewCropPrescription);
		$db_connection->makeConnection($this->TariffStandard);
		$db_connection->makeConnection($this->Appointment);
		$db_connection->makeConnection($this->State);
		$db_connection->makeConnection($this->Account);
		$db_connection->makeConnection($this->TariffList);
		$db_connection->makeConnection($this->Billing);
		$db_connection->makeConnection($this->User);
		$db_connection->makeConnection($this->Location);
		$db_connection->makeConnection($this->ServiceBill);
		$db_connection->makeConnection($this->DateFormat);
		$db_connection->makeConnection($this->CompanyName);
		$db_connection->makeConnection($this->Staff);
		
		if (isset($db_connection_hospital)) {
    $db_connection_hospital->makeConnection($this->DoctorProfile);
    $db_connection_hospital->makeConnection($this->Patient);
    $db_connection_hospital->makeConnection($this->Billing);
    $db_connection_hospital->makeConnection($this->TariffList);
    $db_connection_hospital->makeConnection($this->CompanyName);
    $db_connection_hospital->makeConnection($this->Staff);
		}
		
		$staffData = $this->Staff->find('all');
		$this->set('staffData', $staffData);
		

		$companyData = $this->CompanyName->find('all');
		$this->set('companyData', $companyData);
		$this->Session->write('isquickregsave',"0");
		$privateID = $this->TariffStandard->getPrivateTariffID();
		//location list
		$locations = $this->Location->find('list',array('fields'=>array('name'),'conditions'=>array('Location.is_active'=>1,'Location.is_deleted'=>0)));
		$this->set(array('privateID'=>$privateID,'locations'=>$locations));
		//debug($this->request->data);die();
		if(!empty($this->request->data["Person"])){
			// staff registration and restrict account creation code added by atul chandankhede
			if($this->request->data["Person"]["is_staff_register"] == '1'){
				$staffName = explode(" ", $this->request->data["Person"]["staff_name"]);
				$this->request->data["Person"]["first_name"] =$staffName[0]; 
				$this->request->data["Person"]["last_name"] =$staffName[1];
				$this->request->data["Patient"]["is_staff_register"] = $this->request->data["Person"]["is_staff_register"];
			}
	
			if(!empty($this->request->data["Person"]['dob'])){
				$dob = $this->request->data["Person"]['dob'];
				$this->request->data["Person"]['dob'] = $this->DateFormat->formatDate2STD($dob,Configure::read('date_format'));
				$years = ($this->request->data["Person"]['age_year'] != '0') ? $this->request->data["Person"]['age_year'].'Y ' : '';
				$months = ($this->request->data["Person"]['age_month'] != '0') ? $this->request->data["Person"]['age_month'].'M ' : '';
				$days = $this->request->data["Person"]['age_day'].'D';
				$this->request->data["Person"]['age'] = $years.$months.$days ;
			}
			$this->Person->begin();
			$lastid = $this->Person->insertPerson($this->request->data,'insert','emregency');
			if(!empty($errors)) {
				$this->set("errors", $errors);
			}else {
				//foto upload by pankaj w
				if(!empty($this->request->data['Person']['upload_image']['name'])){
					//creating runtime image name
					$original_image_extension  = explode(".",$this->request->data['Person']['upload_image']['name']);
					if(!isset($original_image_extension[1])){
						$imagename= "person_".mktime().'.'.$original_image_extension[0];
					}else{
						$imagename= "person_".mktime().'.'.$original_image_extension[1];
					}
					//set new image name to DB
					$this->request->data["Person"]['photo']  = $imagename ;
				}else if(!empty($this->request->data['Person']['web_cam'])){
					$im = imagecreatefrompng($this->request->data['Person']['web_cam']);
					if($im){
						$imagename= "person_".mktime().'.png';
						imagejpeg($im,WWW_ROOT.'/uploads/patient_images/thumbnail/'.$imagename);
						$this->request->data["Person"]['photo']  = $imagename ;
					}else{
						unset($this->request->data["Person"]['photo']);
					}
				}else{
					unset($this->request->data["Person"]['photo']);
				}
				if(!empty($this->request->data['Person']['upload_image']['name'])){
					if($this->request->data['Person']['upload_image']['error']){
						if( $this->request->data['Person']['upload_image']['error']==1 ||
								$this->request->data['Person']['upload_image']['error'] ==2){
							$this->Session->setFlash(__('Max file size 2MB exceeded,Please try again', true),array('class'=>'error'));
						}else{
							$this->Session->setFlash(__('There is problem while uplaoding image,Please try again', true),array('class'=>'error'));
						}
					}else{
						$showError = $this->ImageUpload->uploadFile($this->params,'upload_image','uploads/patient_images',$imagename);
						if(empty($showError)) {
							// making thumbnail of 100X100
							$this->ImageUpload->load($this->request->data['Person']['upload_image']['tmp_name']);
							$this->ImageUpload->resize(100,100);
							$this->ImageUpload->save("uploads/patient_images/thumbnail/".$imagename);
						}
					}
				}
				
				//EOF foto upload
				$latest_insert_id = $this->Person->getInsertId();
				$patient_id   = $this->autoGeneratedPatientID($latest_insert_id,$this->request->data);
				$this->request->data['Person']['id'] = $latest_insert_id ;
				$this->request->data['Person']['patient_uid'] =$patient_id ;
				$this->request->data['Person']['alternate_patient_uid'] =$latest_insert_id ;
				$this->request->data['Person']['payment_category'] = 'cash';
				$this->request->data['Person']['expected_date_del'] = $this->DateFormat->formatDate2STD($this->request->data['Person']['expected_date_del'],Configure::read('date_format'));
				//QR code image generation
				$qrformat =  $this->qrFormat($this->request->data['Person']);
				App::import('Vendor', 'qrcode', array('file' => 'qrcode/qrlib.php'));
				QRcode::png($qrformat, "uploads/qrcodes/$patient_id.png", 'L', 4, 2);

				$this->Person->save($this->request->data);
				$id=$this->Person->find('first',array('fields'=>array('Person.patient_uid'),'order'=>'Person.id DESC'));
			}
			$this->request->data['Patient']['person_id'] = $latest_insert_id;
			$this->request->data['Patient']['patient_id'] =$id['Person']['patient_uid'];
			$this->request->data['Patient']['is_deleted'] = 0;
			
			$this->request->data['Patient']['dob'] = $this->DateFormat->formatDate2STD($dob,Configure::read('date_format'));
			//by pankaj w for vadodara only
			if($this->Session->read('website.instance')=='vadodara'){
				$this->request->data['Patient']['location_id'] = $this->request->data['Person']['location_id'] ;
			}else{
				$this->request->data['Patient']['location_id'] = $this->Session->read('locationid')?$this->Session->read('locationid'):1 ;
			}
			$this->request->data['Patient']['admission_type'] = 'OPD';
			$this->request->data['Patient']['lookup_name']= $this->request->data["Person"]['first_name']." ".$this->request->data["Person"]['last_name'];
			$this->request->data['Patient']['is_emergency'] = 0;
			/** Krupya Hat Lau Naye */
			$formRecievedOn = trim($this->request->data['Patient']['form_received_on']).' '.trim($this->request->data['Person']['start_time']);
			/** aadesha anusar */
			$this->request->data['Patient']['form_received_on'] = $this->DateFormat->formatDate2STD($formRecievedOn,Configure::read('date_format'));
			$this->request->data['Patient']['form_completed_on'] = $this->DateFormat->formatDate2STD($formRecievedOn,Configure::read('date_format'));
			$this->request->data['Patient']['create_time'] = date('Y-m-d H:i:s') ;
			$this->request->data['Patient']['expected_date_del'] = $this->request->data['Person']['expected_date_del'];
			$this->request->data['Patient']['pregnant_week'] = $this->request->data['Person']['pregnant_week'];
			$this->request->data['Patient']['created_by'] = $this->Session->read('userid')?$this->Session->read('userid'):1 ;
			$this->request->data['Patient']['is_discharge']= 0 ;
			$this->request->data['Patient']['sex']= $this->request->data['Person']['sex'];
			$this->request->data['Patient']['age']= $this->request->data['Person']['age'];
			$this->request->data['Patient']['payment_category'] = 'cash';
			$this->request->data['Patient']['coupon_name'] = $this->request->data["Person"]['coupon_name'];
			$this->request->data['Patient']['coupon_amount'] =$this->request->data["Person"]['coupon_amount'];
			$this->request->data['Patient']['initial_id'] =$this->request->data["Person"]['initial_id'];
		
			//BOF-Mahalaxmi For File number added in Patient Table
			$fileNoPatient = $this->Patient->generatePatientFileNo();				
			$this->request->data['Patient']['file_number'] =$fileNoPatient;
			//EOF-Mahalaxmi For File number added in Patient Table
			$admission_id = $this->Patient->autoGeneratedAdmissionID($latest_id,$this->request->data);
			$this->request->data['Patient']['admission_id'] =$admission_id;
			if($this->Patient->save($this->request->data['Patient']))
				$this->Person->commit();
			else
				$this->Person->rollback();

			$latest_id = $this->Patient->getInsertId();
			//add mandatory charges by pankajw
			$this->Account->insertMandatoryServiceCharges($this->request->data,$latest_id); // by yashwant
			//EOF mandatory charges by pankajw
			
			if($this->request->data['Patient']['coupon_name']!='' and Configure::read('Coupon')){
				$this->CouponTransaction->setCouponTransaction($latest_insert_id,$this->request->data['Patient']['coupon_name']);
				if($this->request->data["Patient"]['admission_type'] == "OPD")
					$this->request->data['Patient']['total'] =  $this->CouponTransaction->ApplyCouponDiscount($latest_insert_id,$this->request->data['Patient']['coupon_amount']);
			}
				
			
			
			
			//generate QrCode of admission_id and Patient Name - by Mrunal
			$age = explode(' ', $this->request->data['Patient']['age']);
			$concatedPatientName = $this->request->data['Patient']['lookup_name']." ".$age[0]." ".trim($admission_id);
			$lookup_name_withspace = preg_replace('/[^A-Za-z0-9]/', ' ', $concatedPatientName);
			$this->Patient->getPatientAdmissionIdQR(trim($admission_id),$latest_id);
			$this->Patient->getPatientNameQR($lookup_name_withspace,$latest_id);
			//end Of qrcode
			
			$this->Patient->updateAll(array('Patient.admission_id' => "'$admission_id'",'Patient.account_number' => "'$admission_id'"),array('Patient.id'=>$latest_id));
			//  New QR Code As per EMAR Criteria Requirement
			$qrString = $patient_id;//."#".$this->request->data['Patient']['lookup_name']."#".$dob;
			// generate Text Type QrCode
			//$this->QRCode ->text(trim($qrString));
			// display new QR code image
			//$this->QRCode ->draw(150, "uploads/qrcodes/".$admission_id.".png"); //qr code commneted by pankajw as it is not allow to register offline 
			if($this->request->data['setSoap'])
				$this->NewCropPrescription->insertDrugFromQuickReg($this->request->data,$latest_id);
			$this->set('isquickregsave',"1");
			$this->set('patientId',$latest_id);
			$doctorId = $this->request->data['Patient']['doctor_id'];//gaurav

			// for redirect from registration to billing page-Atul
			/*$this->loadModel('Configuration');
			 $redirect = $this->Configuration->find('first',array('conditions'=>array('name'=>'Redirect From Registration')));
			$previousData = unserialize($redirect['Configuration']['value']);
			if($previousData=='1'){
			$this->request->data['Patient']['person_id'] = $latest_insert_id;
			$this->request->data['Patient']['patient_id'] = $latest_id;
			$this->Appointment->setCurrentAppointment($this->request->data);
			$this->Session->setFlash(__('Record added Successfully', true),true,array('class'=>'message'));
			$this->redirect(array("controller"=>"Billings","action"=>"multiplePaymentModeIpd",$latest_id));
			}*/
			/** Creating New appointment and moving to patient list -- gaurav */
			$this->request->data['Patient']['person_id'] = $latest_insert_id;
// 			debug($latest_id);
			$this->request->data['Patient']['patient_id'] = $latest_id;
// 			debug($this->request->data);die();
			$this->Appointment->setCurrentAppointment($this->request->data);
			if($this->Session->read('website.instance')=='vadodara'){
				/**
				 * For setting up multiple appointment at a time 
				 */
				if($this->request->data['Appointment']){
					$this->Appointment->setMultipleAppointment($this->request->data);
				}
				// For after setting up multiple appointment print multiple OPD print sheet-Atul
			   $docPid[]=($this->request->data['Patient']['doctor_id']);
			   
		       if(!empty($this->request->data['Appointment']['doctor_id'])){
		       	 $doctorAppId=$this->request->data['Appointment']['doctor_id'];
		       }else{
		       	 $doctorAppId[]=$this->request->data['Appointment']['doctor_id'];
		       }
				$doctorIdArray = array_merge($docPid,$doctorAppId);
				$docIDArr=array_filter($doctorIdArray);	
			    $docArray=implode(",", $docIDArr);
	
				// EOF multiple appointment
				if(($this->request->data["Person"]['pay_amt']=='1') && ($this->request->data['Person']['printSheet'] =='1')){
					//function for saving data in billing and accounting
					
					$billId=$this->Billing->saveRegBill($this->request->data);
					
					///End OF code
					$this->Session->setFlash(__('Record added for - <b>'.$patient_id."</b>",true),'default',array('class'=>'stillSuccess','id'=>'stillFlashMessage'),'still');
					$this->redirect(array("controller" => "persons", "action" => "quickReg",'?'=>array('print'=>$billId,"patientId"=>$latest_id,'docId'=>$docArray)));
				
				} else{
					$this->redirect(array("controller" => "persons", "action" => "quickReg",'?'=>array("patientId"=>$latest_id,'docId'=>$docArray)));
				}
			}

        	if ($this->request->data['Person']['capturefingerprint'] == "1") {
            $this->Session->setFlash(__('Record Added Successfully', true), true, array('class' => 'message'));
            $this->redirect(array(
                "controller" => "persons", 
                "action" => "finger_print", 
                $latest_insert_id, 
                'capturefingerprint' => $this->request->data["Person"]['capturefingerprint'], 
                '?' => array('id' => $latest_insert_id)
            ));
        } else {
            // debug($patient_id);exit;
           
            $lastInsertedPersonId = $this->Person->getLastInsertId();
            $lastInsertedPatientId = $this->Patient->getLastInsertId();
            // $lastInseredPatien_uid = 
            
            // Capture the mobile number and next of kin's mobile number
              $mobile_number = isset($this->request->data['Person']['mobile']) ? $this->request->data['Person']['mobile'] : null;
              $first_name = isset($this->request->data['Person']['first_name']) ? $this->request->data['Person']['first_name'] : null;
              $last_name = isset($this->request->data['Person']['last_name']) ? $this->request->data['Person']['last_name'] : null;
              $next_of_kin_name = isset($this->request->data['Person']['next_of_kin_name']) ? $this->request->data['Person']['next_of_kin_name'] : null;
              $next_of_kin_number = isset($this->request->data['Person']['next_of_kin_mobile']) ? $this->request->data['Person']['next_of_kin_mobile'] : null;
        
            if (!empty($mobile_number)) {
                
                $this->Session->setFlash(__('Record Added Successfully. Generating QR Code for mobile and next of kin.', true), true, array('class' => 'message'));
                  $patientid = $lastInsertedPersonId . '/' . $lastInsertedPatientId;
         $user_qr_image_url = 'https://hopesoftwares.com/persons/generateQrCode/' . $patientid;
         $messageStatus = $this->sendWhatsAppMessage($mobile_number, $user_qr_image_url,$first_name,$lastInsertedPersonId,$patient_id);
        //  debug($user_qr_image_url);exit;
                // Redirect to generateQrCode function to generate QR codes and render the view
                $this->redirect(array(
                    "controller" => "persons",
                    "action" => "generateQrCode",
                    $lastInsertedPersonId,
                    $lastInsertedPatientId,
                ));
                 $this->redirect(array("controller" => "appointments", "action" => "appointments_management"));
            } else {
                $this->Session->setFlash(__('Mobile number is required to generate QR Code.', true), true, array('class' => 'error'));
                $this->redirect(array("controller" => "appointments", "action" => "appointments_management"));
            }
        }
        }

		$this->set('newState',$this->State->find('list',array('fields'=>array('id','name'),'conditions'=>array('State.country_id'=>'1'))));
		$getConfiguration=$this->Configuration->find('all');
		$strenght=unserialize($getConfiguration[0]['Configuration']['value']);
		$dose=unserialize($getConfiguration[1]['Configuration']['value']);
		$route=unserialize($getConfiguration[2]['Configuration']['value']);
		foreach($strenght as $strenghts){
			$str.='<option value='.'"'.stripslashes($strenghts).'"'.'>'.$strenghts.'</option>';
		}
		$str.='</select>';
		$this->set('str',$str);
		foreach($dose as $doses){
			$str_dose.='<option value='.'"'.stripslashes($doses).'"'.'>'.$doses.'</option>';
		}
		$str_dose.='</select>';
		$this->set('str_dose',$str_dose);
		foreach($route as $routes){
			$str_route.='<option value='.'"'.stripslashes($routes).'"'.'>'.$routes.'</option>';
		}
		$str_route.='</select>';
		$this->set('str_route',$str_route);
		foreach(unserialize($getConfiguration[0]['Configuration']['value']) as $key=>$strenght){
			if(!empty($strenght))
				$strenght_var[$strenght]=$strenght;
		}
		$this->set('strenght',$strenght_var);
		foreach(unserialize($getConfiguration[1]['Configuration']['value']) as $key=>$doses){
			if(!empty($doses))
				$dose_var[$doses]=$doses;
		}
		$this->set('dose',$dose_var);
		foreach(unserialize($getConfiguration[2]['Configuration']['value']) as $key=>$route){
			if(!empty($route))
				$route_var[$route]=$route;
		}
		/** gaurav */
		foreach($getConfiguration as $allowTimelyQuickReg){
			if($allowTimelyQuickReg['Configuration']['name'] == 'allowTimelyQuickReg')
				$allow = ($allowTimelyQuickReg['Configuration']['value'] == '1') ? true : false;
		}
		Configure :: write('allowTimelyQuickReg', $allow );
		/** EOF*/
		$this->set('route',$route_var);
		
		$this->set('initials',$this->Initial->find('list',array('fields'=>array('name'))));
		if(isset($this->Session) && !empty($this->Session->read('locationid'))){
			$OPCheckUpOptions=$this->TariffList->find('list',array('fields'=>array('id','name'),'conditions'=>array('is_deleted'=>'0','check_status'=>'1','location_id'=>$this->Session->read('locationid')?$this->Session->read('locationid'):1)));
			$this->set('opdoptions',$OPCheckUpOptions);

			//$this->set('doctorlist',$this->DoctorProfile->getDoctors());
			$this->set('doctorlist',$this->User->getOpdDoctors());
			$this->set('tariff',  $this->TariffStandard->find('list',array('order' => array('TariffStandard.name'),'conditions'=>array('is_deleted'=>0,'TariffStandard.location_id'=>$this->Session->read('locationid')?$this->Session->read('locationid'):1))));
			$this->set('departments',$this->Department->find('list',array('fields'=>array('id','name'),'conditions'=>array('Department.location_id'=>$this->Session->read('locationid')?$this->Session->read('locationid'):1),'order' => array('Department.name'))));
			$this->set('online',false);
		}else{
    $this->set('online', true);

    $this->set('doctorlist', [ '56' => 'B K Murali, MS (Orth.)','57' => 'Dr. Ritesh Navkhare, MD','58' => 'Dr. Atul Rajkondawar, MD','59' => 'Dr. Afsal Sheikh, MD' ]);
    $this->set('tariff', ['7' => 'Private','8' => 'General','9' => 'Corporate','10' => 'Insurance-based']);
    $this->set('opdoptions', ['4' => 'Consultation Charges', '5' => 'Follow-up Visit', '6' => 'Emergency Visit','7' => 'Second Opinion']);
    $this->set('departments',['12' => 'Orthopaedics','13' => 'Cardiology','14' => 'General Medicine', '15' => 'Pediatrics','16' => 'Neurology','17' => 'Abdominal or chest conditions']);
}
// when quick register form open in without login show this dropdown code by dinesh tawade
		/** setting searchPerson data to form inputs --gaurav  */
		$searchPersonData = $this->request->data;
		$this->request->data= '';
		if(!$searchPersonData['tariff_standard_id'])
			$searchPersonData['hidden_tariff_standard_id'] = '';
		else
			$searchPersonData['insurance_type_id'] = $searchPersonData['tariff_standard_id'];
		unset($searchPersonData['form_received_on'],$searchPersonData['tariff_standard_id']);
		$this->request->data['Person'] = $searchPersonData;
		$this->data = $this->request->data;
		
		//for set coupon transaction if coupon is applied
		if($this->request->data['Patient']['coupon_name'])
			$this->CouponTransaction->setCouponTransaction($latest_id,$this->request->data['Patient']['coupon_name']);
		//for fingerprint device
		
		$isFingerPrintEnable = $this->Configuration->find('first',array('conditions'=>array('name'=>'isFingerPrintEnable')));
		$this->set('isFingerPrintEnable',$isFingerPrintEnable['Configuration']['value']);
	}

public function generateQrCode($lastInsertedPersonId = null, $lastInsertedPatientId = null)
{
    
    
    $this->uses = array('Person','Patient');
    App::import('Vendor', 'DrmhopeDB');
    
    
    if($this->Session->read('db_name')) {
        
        // $db_connection = new DrmhopeDB($this->Session->read('db_name'));
          $db_connection = $this->Session->read('db_name');
        
    } else {
        $db_connection = new DrmhopeDB('db_hope');
    }
    // $db_connection->makeConnection($this->Patient);
    // $db_connection->makeConnection($this->Person);
    $this->loadModel('Person');
    $this->loadModel('Patient');
      
    
    $personData = $this->Person->find('first', [
        'conditions' => ['Person.id' => $lastInsertedPersonId],
        'fields' => ['Person.first_name', 'Person.last_name','Person.next_of_kin_name', 'Person.next_of_kin_mobile','Person.mobile'],
        'recursive' => -1
    ]);
    
    
    if ($personData) {
        $first_name = $personData['Person']['first_name'];
        $last_name = $personData['Person']['last_name'];
        $next_of_kin_number = $personData['Person']['next_of_kin_mobile'];
        $mobile_number = $personData['Person']['mobile'];
        // debud($personData);exit;
        
        App::import('Vendor', 'qrcode', array('file' => 'qrcode/qrlib.php'));
        $qr_image_path = WWW_ROOT . '/uploads/qrcodes/';
        
        if (!is_writable($qr_image_path)) {
            $this->Session->setFlash(__('QR code directory is not writable.'), 'default', array('class' => 'error'));
            return;
        }
        
        try {
            // Generate User QR Code
            if ($mobile_number) {
                $url_user = "https://admin.emergencyseva.in/public/emergency-sewa?phone=" . $mobile_number . $next_of_kin_number . $first_name . $last_name;
                $user_qr_file = 'QRCode_' . $mobile_number . '.png';
                QRcode::png($url_user, $qr_image_path . $user_qr_file, 'L', 4, 2);
                $this->addTextToImage($qr_image_path . $user_qr_file, $first_name . ' ' . $last_name);
                $user_qr_image = '/uploads/qrcodes/' . $user_qr_file;
                $user_qr_image_url = 'https://hopesoftwares.com/persons/generateQrCode/' . $patientid;
                $user_download_link = Router::url('/uploads/qrcodes/' . $user_qr_file, true);
            }
            
            // Generate Next of Kin QR Code
            if ($next_of_kin_number) {
                $url_next_of_kin = "https://admin.emergencyseva.in/public/emergency-sewa?mobile=" . $mobile_number . "&next_of_kin=" . $next_of_kin_number;
                $next_of_kin_qr_file = 'QRCode_NextOfKin_' . $next_of_kin_number . '.png';
                QRcode::png($url_next_of_kin, $qr_image_path . $next_of_kin_qr_file, 'L', 4, 2);
                $this->addTextToImage($qr_image_path . $next_of_kin_qr_file, $first_name . ' ' . $last_name, 'Ashiwin Dahikar', 'emergency me scan karo');
                $next_of_kin_qr_image = '/uploads/qrcodes/' . $next_of_kin_qr_file;
                $next_of_kin_download_link = Router::url('/uploads/qrcodes/' . $next_of_kin_qr_file, true);
            }
            
            // Call the function to send the WhatsApp message (send the QR code link)
           
// $patient_id
            // Set data to the view
            $this->set(compact('mobile_number', 'first_name', 'last_name', 'next_of_kin_name', 'next_of_kin_number', 'user_qr_image', 'user_download_link', 'next_of_kin_qr_image', 'next_of_kin_download_link'));
            $this->Session->setFlash(__('QR Codes generated successfully and WhatsApp message sent.'));
        } catch (Exception $e) {
            $this->Session->setFlash(__('An error occurred while generating the QR codes: ' . $e->getMessage()), 'default', array('class' => 'error'));
        }
    } else {
        $this->Session->setFlash(__('Mobile number is missing. Unable to generate QR code.'));
        $this->redirect(array('controller' => 'persons', 'action' => 'quickReg'));
    }
}


public function sendWhatsAppMessage($phone, $user_qr_image_url,$first_name,$lastInsertedPersonId,$patient_id)
        {
            $apiUrl = "https://public.doubletick.io/whatsapp/message/template";
            $apiKey = "key_8sc9MP6JpQ"; 
            $loginlink = 'https://hopesoftwares.com';
            
            $payload = [
                "messages" => [
                    [
                        "to" => "+91" . $phone,  
                        "content" => [
                            "templateName" => "eng_uni_qr",  
                            "language" => "en",
                            "templateData" => [
                                "body" => [
                                    "placeholders" => [$first_name, $user_qr_image_url,$loginlink,$patient_id,$lastInsertedPersonId]
                                ]
                            ]
                        ]
                    ]
                ]
            ];
        
            
            // debug($payload);exit;
        
            $ch = curl_init();
            
            // Set cURL options
            curl_setopt($ch, CURLOPT_URL, $apiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Accept: application/json",
                "Content-Type: application/json",
                "Authorization: $apiKey"
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        
            $response = curl_exec($ch);
        
            if(curl_errno($ch)) {
                curl_close($ch);
                return "Error: " . curl_error($ch);
            }
        
            curl_close($ch);
        
            $responseData = json_decode($response, true);
        
            if (isset($responseData['status']) && $responseData['status'] == 'success') {
                return "Message sent successfully!";
            } else {
                return "Error: " . (isset($responseData['message']) ? $responseData['message'] : "Something went wrong.");
            }
        }
// created by dinesh
	public function emergency_reg() {
		$this->layout = false;
	}
	
	
public function emergencyReg() {
    $this->layout = 'advance';

    // Models that need to be used
    $this->uses = array('Initial', 'DoctorProfile', 'Patient', 'Department', 'Configuration', 'NewCropPrescription', 'TariffStandard',
                        'Appointment', 'State', 'Account', 'TariffList', 'Billing', 'User', 'Person', 'Location', 'ServiceBill', 'CouponTransaction');

    // Database connection
    App::import('Vendor', 'DrmhopeDB');
    if ($this->Session->read('db_name')) {
        $db_connection = new DrmhopeDB($this->Session->read('db_name'));
    } else {
        $db_connection = new DrmhopeDB('db_hope');
    }
    
    // Make connections for models
    $models = ['Initial', 'DoctorProfile', 'Patient', 'Person', 'Department', 'Configuration', 'NewCropPrescription', 'TariffStandard', 
                'Appointment', 'State', 'Account', 'TariffList', 'Billing', 'User', 'Location', 'ServiceBill', 'DateFormat'];

    foreach ($models as $model) {
        $db_connection->makeConnection($this->$model);
    }

    $this->Session->write('isquickregsave', "0");

    // Handling form submission from emergency_reg.ctp
    if (!empty($this->request->data['Person'])) {
        $this->Person->begin();

        // Format date of birth
        if (!empty($this->request->data['Person']['dob'])) {
            $dob = $this->request->data['Person']['dob'];
            $this->request->data['Person']['dob'] = $this->DateFormat->formatDate2STD($dob, Configure::read('date_format'));
            $years = ($this->request->data['Person']['age_year'] != '0') ? $this->request->data['Person']['age_year'] . 'Y ' : '';
            $months = ($this->request->data['Person']['age_month'] != '0') ? $this->request->data['Person']['age_month'] . 'M ' : '';
            $days = $this->request->data['Person']['age_day'] . 'D';
            $this->request->data['Person']['age'] = $years . $months . $days;
        }

        // Insert person data
        $lastid = $this->Person->insertPerson($this->request->data, 'insert', 'emergency');
        
        // Error handling
        if (!empty($errors)) {
            $this->set('errors', $errors);
        } else {
            // Handle file uploads (photo or webcam image)
            if (!empty($this->request->data['Person']['upload_image']['name'])) {
                // Handle photo upload
                $imagename = "person_" . mktime() . '.' . pathinfo($this->request->data['Person']['upload_image']['name'], PATHINFO_EXTENSION);
                $this->request->data['Person']['photo'] = $imagename;
                $this->ImageUpload->uploadFile($this->params, 'upload_image', 'uploads/patient_images', $imagename);
                $this->ImageUpload->resize(100, 100);
                $this->ImageUpload->save("uploads/patient_images/thumbnail/" . $imagename);
            }

            // Save QR code for patient
            $latest_insert_id = $this->Person->getInsertId();
            $patient_id = $this->autoGeneratedPatientID($latest_insert_id, $this->request->data);
            $this->request->data['Person']['id'] = $latest_insert_id;
            $this->request->data['Person']['patient_uid'] = $patient_id;
            $this->request->data['Person']['alternate_patient_uid'] = $latest_insert_id;
            $this->request->data['Person']['payment_category'] = 'cash';

            // Generate QR code for the patient
            $qrformat = $this->qrFormat($this->request->data['Person']);
            App::import('Vendor', 'qrcode', array('file' => 'qrcode/qrlib.php'));
            QRcode::png($qrformat, "uploads/qrcodes/$patient_id.png", 'L', 4, 2);

            // Save person data
            $this->Person->save($this->request->data);
            $id = $this->Person->find('first', array('fields' => array('Person.patient_uid'), 'order' => 'Person.id DESC'));

            // Save patient data
            $this->request->data['Patient']['person_id'] = $latest_insert_id;
            $this->request->data['Patient']['patient_id'] = $id['Person']['patient_uid'];
            $this->request->data['Patient']['dob'] = $this->DateFormat->formatDate2STD($dob, Configure::read('date_format'));
            $this->request->data['Patient']['location_id'] = $this->Session->read('locationid') ? $this->Session->read('locationid') : 1;
            $this->request->data['Patient']['admission_type'] = 'OPD';
            $this->request->data['Patient']['lookup_name'] = $this->request->data["Person"]['first_name'] . " " . $this->request->data["Person"]['last_name'];

            // Auto-generate admission ID
            $admission_id = $this->Patient->autoGeneratedAdmissionID($latest_id, $this->request->data);
            $this->request->data['Patient']['admission_id'] = $admission_id;

            if ($this->Patient->save($this->request->data['Patient'])) {
                $this->Person->commit();
            } else {
                $this->Person->rollback();
            }

            // Insert mandatory service charges
            $latest_id = $this->Patient->getInsertId();
            $this->Account->insertMandatoryServiceCharges($this->request->data, $latest_id);

            // Apply coupon if available
            if ($this->request->data['Patient']['coupon_name'] != '') {
                $this->CouponTransaction->setCouponTransaction($latest_insert_id, $this->request->data['Patient']['coupon_name']);
                if ($this->request->data["Patient"]['admission_type'] == "OPD") {
                    $this->request->data['Patient']['total'] = $this->CouponTransaction->ApplyCouponDiscount($latest_insert_id, $this->request->data['Patient']['coupon_amount']);
                }
            }

            // Generate QR code for the admission
            $this->Patient->getPatientAdmissionIdQR(trim($admission_id), $latest_id);
            $this->Patient->getPatientNameQR($this->request->data['Patient']['lookup_name'], $latest_id);
            $this->Patient->updateAll(array('Patient.admission_id' => "'$admission_id'", 'Patient.account_number' => "'$admission_id'"), array('Patient.id' => $latest_id));

            // Redirect after registration
            $this->Session->setFlash(__('Record added Successfully', true), true, array('class' => 'message'));
            $this->redirect(array("controller" => "persons", "action" => "quickReg", '?' => array("patientId" => $latest_id)));
        }
    }

    // Set additional data to be used in the view
    $this->set('newState', $this->State->find('list', array('fields' => array('id', 'name'), 'conditions' => array('State.country_id' => '1'))));
    $getConfiguration = $this->Configuration->find('all');
    $strength = unserialize($getConfiguration[0]['Configuration']['value']);
    $this->set('strength', $strength);
    $this->set('initials', $this->Initial->find('list', array('fields' => array('name'))));
}



/**
 * Function to add text to the QR code image
 */
private function addTextToImage($image_path, $name) {
    // Load the image
    $image = imagecreatefrompng($image_path);
    $black = imagecolorallocate($image, 0, 0, 0);
    $red = imagecolorallocate($image, 255, 0, 0);

    // Set the font path and size
    $font_path = WWW_ROOT . 'fonts/arial.ttf'; // Ensure this path points to your TTF font file
    $font_size = 10;

    // Add the name at the top of the image
    imagettftext($image, $font_size, 0, 10, 20, $black, $font_path, $name);

    // Add the emergency text below the QR code
    $emergency_text = "In case of emergency, please scan this QR code.\nआपातकाल की स्थिति में, कृपया इस QR कोड को स्कैन करें।";
    $y_position = imagesy($image) - 30; // Position text 30 pixels above the bottom of the image
    imagettftext($image, $font_size, 0, 10, $y_position, $red, $font_path, $emergency_text);

    // Save the image back to the path
    imagepng($image, $image_path);
    imagedestroy($image);
}




	public function autoGeneratedAdmissionIDNew($id=null,$patient_info = array()){

		$count = $this->Person->find('count',array('conditions'=>array('Person.create_time like'=> "%".date("Y-m-d")."%",
				/*'Person.location_id'=>$this->Session->read('locationid')*/)));// ---- for same location initial name it creates duplicate uID---gaurav @pankaj
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
		/*$this->loadModel('Location');
		 $this->Location->unbindModel(
		 		array('belongsTo' => array('City','State','Country')));*/

		//$hospital = $this->Location->read('Facility.name,Location.name',$patient_info['Patient']['location_id']);
		$hospital = $this->Session->read('facility');
		//creating patient ID
		$unique_id   = ucfirst(substr($patient_info['Patient']['admission_type'],0,1));
		$unique_id  .= ucfirst(substr($hospital,0,1)); //first letter of the hospital name
		$unique_id  .= strtoupper(substr($this->Session->read('location'),0,2));//first 2 letter of d location
		$unique_id  .= date('y'); //year
		$unique_id  .= $month_array[date('n')-1];//first letter of month
		$unique_id  .= date('d');//day
		$unique_id .= $count;
		return strtoupper($unique_id) ;
	}
	public function createSearchConditions($queryString = null){
		$role = $this->Session->read('role');
		if($this->Session->read('website.instance') != 'vadodara')/** Displaying records from all locations by gaurav */
			$search_key1['Person.location_id'] = $this->Session->read('locationid');
		$search_key1['Person.is_deleted'] = 0;
		$this->request->query = $queryString;
		$search_ele = $this->request->query;
		//debug($search_ele);exit;
		$advanceSearch = false;
		if(!empty($search_ele['first_name'])){
			//sliptup complete name
			$splittedName = explode(" ",$search_ele['first_name']);
			$first_name = $splittedName[0];
			$last_name = $splittedName[count($splittedName)];
			$search_key['Person.first_name like '] = trim($first_name)."%" ;
		}
		if(!empty($this->request->query['last_name'])){
			$search_key['Person.last_name like '] = trim($this->request->query['last_name'])."%" ;
		}
		if($this->request->query['prospect']){
			$search_key['Person.admission_type'] =  "prospect";
			if(isset($this->request->query['prospect_name']) && !empty($this->request->query['prospect_name'])){
				$patientName=explode('-',$this->request->query['prospect_name']);
				$prospectName=explode(' ',$patientName[0]);#debug(end($prospectName));
				$search_key['OR']['Person.first_name LIKE'] =  "%".$prospectName[0]."%";
				$search_key['OR']['Person.last_name LIKE'] =  "%".$prospectName[1]."%";
				
			}
		}else{
			if(isset($this->request->query['patient_name']) && !empty($this->request->query['patient_name'])){
				$patientName=explode('-',$this->request->query['patient_name']);
				$search_key['Patient.lookup_name LIKE'] =  "%".$patientName[0]."%";
			}
			$search_key1['Patient.is_deleted'] = 0;
		}
		if(!empty($this->request->query['ssn_us'])){
			$search_key1['Person.ssn_us like '] = trim($this->request->query['ssn_us'])."%" ;
			$advanceSearch = true;
		}
		if(!empty($this->request->query['middle_name'])){
			$search_key['Person.middle_name like '] = trim($this->request->query['middle_name'])."%" ;
			$advanceSearch = true;
		}
		if(!empty($this->request->query['mrn_no'])){
			$search_key['Patient.admission_id like'] = "%".$this->request->query['mrn_no']."%";
			$advanceSearch = true;
		}
		if(!empty($this->request->query['sex'])){
			$search_key1['Person.sex like '] = $this->request->query['sex']."%" ;
			$advanceSearch = true;
		}
		if(!empty($this->request->query['ethnicity'])){
			$search_key1['Person.ethnicity like '] = $this->request->query['ethnicity']."%" ;
			$advanceSearch = true;
		}
		if(!empty($this->request->query['email'])){
			$search_key1['Person.email like '] = trim($this->request->query['email'])."%" ;
			$advanceSearch = true;
		}
		if(!empty($this->request->query['occupation'])){
			$search_key1['Person.occupation'] = trim($this->request->query['occupation']) ;
			$advanceSearch = true;
		}
		if(!empty($this->request->query['mobile'])){
			$search_key1['Person.mobile like '] = trim($this->request->query['mobile'])."%" ;
			$advanceSearch = true;
		}
		if(!empty($this->request->query['home_phone'])){
			$search_key1['Person.home_phone like '] = trim($this->request->query['home_phone'])."%" ;
			$advanceSearch = true;
		}
		if(!empty($this->request->query['language'])){
			$search_key1['Person.language']= implode(',',$this->request->query['language']) ;
			$advanceSearch = true;
		}
		if(!empty($this->request->query['patient_uid'])){
			$search_key1['Person.patient_uid like '] = $this->request->query['patient_uid'].'%' ;
			$advanceSearch = true;
		}
		if(!empty($this->request->query['race'])){
			$search_key1['Person.race like ']= implode(',',$this->request->query['race']).'%' ;
			$advanceSearch = true;
		}
		if(!empty($this->request->query['dob'])){
			$dob=trim(substr($this->DateFormat->formatDate2STD($this->request->query['dob'],Configure::read('date_format')),0,10));
			$search_key1['Person.dob'] = $dob;
		}

		if(!empty($this->request->query['guar_first_name'])){
			$search_key1['Guardian.guar_first_name like '] = trim($this->request->query['guar_first_name'])."%" ;
			$advanceSearch = true;
		}
		if(!empty($this->request->query['gau_first_name'])){
			$search_key1['Guarantor.gau_first_name like '] = trim($this->request->query['gau_first_name'])."%" ;
			$advanceSearch = true;
		}
		if(!empty($this->request->query['tariff_standard_id'])){
			$search_key1['Person.insurance_type_id like '] = trim($this->request->query['tariff_standard_id'])."%" ;
			$advanceSearch = true;
		}
		//IS Directive
		if($this->request->query['is_directives']=='Y'){
			$dataAdvanceDirective = $this->AdvanceDirective->find('all',array('fields'=>array('id','patient_name'),'conditions'=>array('AdvanceDirective.id <>'=>'')));
			foreach($dataAdvanceDirective as $AdvanceDirdata){
				$patientName[$AdvanceDirdata['AdvanceDirective']['id']]=$AdvanceDirdata['AdvanceDirective']['patient_name'];
			}
			$search_key1['AdvanceDirective.patient_name'] =$patientName;
			$advanceSearch = true;
		}
		if(!empty($this->request->query['form_received_on'])){
			$dobReceivedOn=date('Y-m-d',strtotime($this->request->query['form_received_on']));
			$search_key1['Patient.form_received_on like'] = $dobReceivedOn.'%';
			$advanceSearch = true;
		}
		if(!empty($this->request->query['doctor_id'])){
			$search_key1['Patient.doctor_id'] = $this->request->query['doctor_id'] ;
		}
		if($this->request->query['merge_source']){
			$search_key1['Person.merge_source !='] = '';
			$Unmerge = true;
		}else{
			$Unmerge = false;
		}
		$conditions=array($search_key,$search_key1);
		$conditions = array_filter($conditions);
		return array($conditions,$advanceSearch);

	}
	
	/* only for mrn search  - Atul*/
	public function mrn_search($field=null){
		$this->uses=array('Person','Patient');
		//$this->loadModel('Person');
		$searchKey = $this->params->query['q'];
		$filedOrder = array('admission_id','id');
		$conditions[$field." like"] = "%".$searchKey."%";
		$conditions["Patient.location_id"] =$this->Session->read('locationid');
		$items = $this->Patient->find('list', array('fields'=> $filedOrder,'conditions'=>array($conditions,'Patient.is_deleted' =>'0'),'limit'=>10));
		$output ='';
		foreach ($items as $key=>$value) {
			//echo $value[0]['value']."|".$value['Person']['id'] ."\n" ;
			//$returnArray[] = array('id'=>$key,'value'=>$value);
			$output .= "$key|$value";
			$output .= "\n";
		}
		///echo json_encode($returnArray);
		echo $output;
		exit;//dont remove this
	}
	/* end of function  mrn search  */
public function searchPerson(){
		//debug($this->request->query);exit;
		$this->uses=array('TariffStandard','Patient','Appointment');
		$this->layout = 'advance';
		//***********************************************************************
		if($this->request[isAjax]){
			echo implode(',',array_values($this->request->data['Person']));
			exit;
		}
		
		$this->set('data','');
		$role = $this->Session->read('role');
		//$search_key1['Person.location_id'] = $this->Session->read('locationid');
		//$search_key1['Person.is_deleted'] = 0;
		//$search_key1['Patient.is_deleted'] = 0;
		
		
		if(!empty($this->request->data['Person']['middle_name'])){
			$this->Person->virtualFields = array('full_name' => 'CONCAT(Person.first_name, " ",Person.middle_name," ", Person.last_name)');
		}else{
			$this->Person->virtualFields = array('full_name' => 'CONCAT(Person.first_name, " ", Person.last_name)');
		}
			
		
		if(!empty($this->request->query) && array_filter($this->request->query) && (!isset($this->request->query['pageFrom']))){
			#debug($this->request->query);
			
			$returnArray = $this->createSearchConditions($this->request->query);
			$conditions = $returnArray[0];
			$advanceSearch = $returnArray[1];
			$joinType = ($this->request->query['prospect'] == '1') ? 'LEFT' : 'INNER';//for prospect search - Gaurav Chauriya
			$this->Person->bindModel(array(
					'belongsTo' => array(
							'Patient'=>array('foreignKey'=>false,'conditions'=>array('Person.id=Patient.person_id'),
									'type'=>$joinType /*,'order'=>'Patient.id ASC'*/),
							'DoctorProfile'=>array('foreignKey'=>false,'conditions'=>array('Patient.doctor_id=DoctorProfile.user_id'))
					)
			),false);
			$this->paginate =  array(
					'limit' => Configure::read('number_of_rows'),
					'order'=>array('Patient.id'=>'asc'),
					//'group'=>array('Patient.person_id'),
					'fields'=>array('Person.mobile ','Person.email','Person.ssn_us','Person.id','Person.sex','Person.dob','Person.patient_uid','Person.full_name','Patient.admission_id',
							'Patient.form_received_on','Patient.lookup_name','Patient.is_discharge','Patient.id','Patient.admission_type','DoctorProfile.doctor_name','Person.coupon_name','Person.coupon_name','Person.coupon_amount'),
					'conditions'=>$returnArray,
					'group'=>($this->request->query['prospect'] == '1') ? '' : Array('Patient.person_id','Patient.is_discharge')
			) ;
		
		
			$data = $this->paginate('Person'/*,null,array('fields'=>array('distinct(Patient.id)'))*/);
		
			foreach($data as $records){
				$customData[$records['Person']['id']] = $records;
					
			}
			//}
			$this->set('data',$customData);
			$this->set(compact('Unmerge','hideMergeOption','discharged','advanceSearch'));
			$this->data = array('Person'=>$this->params->query);
			//$this->set('showAdvance','1');
			$this->set('data1','1');
		}else{
			$this->set('data1','2');
		}
		/*	$this->set('race',$this->Race->find('list',array('fields'=>array('value_code','race_name'))));
		 $languages=$this->Language->find('list',array('fields'=>array('code','language'),'order'=>'language DESC'));
		unset($languages['EN'],$languages['HI'],$languages['MR']);
		$keyEnglish = array('EN'=>'English','HI'=>'Hindi','MR'=>'Marathi');
		$languages = $languages+$keyEnglish;
		$languages = array_reverse($languages);
		$this->set('languages',$languages);*/
		$this->set('getDataInsuranceType',$this->TariffStandard->find('list',array('fields'=>array('TariffStandard.id','TariffStandard.name'),'conditions'=>array('TariffStandard.payer_id <>'=>''))));
		
		//for fingerprint device
		$this->loadModel('Configuration');
		$isFingerPrintEnable = $this->Configuration->find('first',array('conditions'=>array('name'=>'isFingerPrintEnable')));
		$this->set('isFingerPrintEnable',$isFingerPrintEnable['Configuration']['value']);
	}

	public function searchPatient(){
		//debug($this->request->query);exit;
		$this->uses=array('TariffStandard','Patient','Appointment');
		$this->layout = 'advance';
		//***********************************************************************
		if($this->request[isAjax]){
			echo implode(',',array_values($this->request->data['Person']));
			exit;
		}

		$this->set('data','');
		//$role = $this->Session->read('role');
		//$search_key1['Person.location_id'] = $this->Session->read('locationid');
		//$search_key1['Person.is_deleted'] = 0;
		//$search_key1['Patient.is_deleted'] = 0;


		if(!empty($this->request->data['Person']['middle_name'])){
			$this->Person->virtualFields = array('full_name' => 'CONCAT(Person.first_name, " ",Person.middle_name," ", Person.last_name)');
		}else{
			$this->Person->virtualFields = array('full_name' => 'CONCAT(Person.first_name, " ", Person.last_name)');
		}
		 
		
		if(!empty($this->request->query) && array_filter($this->request->query) && (!isset($this->request->query['pageFrom']))){ 
			 
			$returnArray = $this->createSearchConditions($this->request->query);
			$conditions = $returnArray[0];
			$advanceSearch = $returnArray[1];
			 
			$this->Person->bindModel(array(
					'belongsTo' => array(
							'Patient'=>array('foreignKey'=>false,'conditions'=>array('Person.id=Patient.person_id','Patient.is_deleted=0'),
									'type'=>'INNER' /*,'order'=>'Patient.id ASC'*/), 
							'DoctorProfile'=>array('foreignKey'=>false,'conditions'=>array('Patient.doctor_id=DoctorProfile.user_id'))
								)
			),false);

			 
			$this->paginate =  array(
					'limit' => Configure::read('number_of_rows'),
					'order'=>array('Patient.id'=>'asc'),
					//'group'=>array('Patient.person_id'),
					'fields'=>array('Person.mobile ','Person.email','Person.ssn_us','Person.id','Person.sex','Person.dob','Person.patient_uid','Person.full_name','Patient.admission_id',
							'Patient.form_received_on','Patient.lookup_name','Patient.is_discharge','Patient.id','Patient.admission_type','DoctorProfile.doctor_name'),
					'conditions'=>$returnArray,
					'group'=>Array('Patient.person_id','Patient.is_discharge')
			) ;
		
		
			$data = $this->paginate('Person'/*,null,array('fields'=>array('distinct(Patient.id)'))*/);
			 
			foreach($data as $records){
				$customData[$records['Person']['id']] = $records;
			
			}	
			//}
			$this->set('data',$customData);
			$this->set(compact('Unmerge','hideMergeOption','discharged','advanceSearch'));
			$this->data = array('Person'=>$this->params->query);
			//$this->set('showAdvance','1');
			$this->set('data1','1');
		}else{
			$this->set('data1','2');
		}
	/*	$this->set('race',$this->Race->find('list',array('fields'=>array('value_code','race_name'))));
		$languages=$this->Language->find('list',array('fields'=>array('code','language'),'order'=>'language DESC'));
		unset($languages['EN'],$languages['HI'],$languages['MR']);
		$keyEnglish = array('EN'=>'English','HI'=>'Hindi','MR'=>'Marathi');
		$languages = $languages+$keyEnglish;
		$languages = array_reverse($languages);
		$this->set('languages',$languages);*/
		$this->set('getDataInsuranceType',$this->TariffStandard->find('list',array('fields'=>array('TariffStandard.id','TariffStandard.name'),'conditions'=>array('TariffStandard.payer_id <>'=>''))));

		//for fingerprint device
		$this->loadModel('Configuration');
		$isFingerPrintEnable = $this->Configuration->find('first',array('conditions'=>array('name'=>'isFingerPrintEnable')));
		$this->set('isFingerPrintEnable',$isFingerPrintEnable['Configuration']['value']);
	}
	

	public function tariffPayerId($tariffStandardId){
		$this->layout = 'ajax';
		$this->uses =array('TariffStandard');
		$getTariffStandardData=$this->TariffStandard->find('first',array('fields'=>array('id','payer_id','HealthplanDetailID'),'conditions'=>array('TariffStandard.id'=>$tariffStandardId)));
		echo json_encode($getTariffStandardData); 
		exit;

	}

public function add() {
		//debug($this->request->data);exit;
		$this->set('title_for_layout', __('-UIDPatient Registration', true));
		//load model
		$this->uses = array('Initial','DoctorProfile','Consultant','City','District','ReffererDoctor','Location','AccountingGroup','MarketingTeam');
		$this->set('initials',$this->Initial->find('list',array('fields'=>array('name'))));
		$this->set('doctors',$this->DoctorProfile->getDoctors());
		$this->set('marketing_teams', $this->MarketingTeam->getMarketingTeamList($this->Session->read('locationid')));
		$this->set('treatmentConsultant',$this->Consultant->find('list',array('CONCAT(Consultant.first_name," ",Consultant.last_name) as name')));
		$this->set('treatmentConsultant',$this->Consultant->find('list',array('CONCAT(Consultant.first_name," ",Consultant.last_name) as name')));
		$this->set('reffererdoctors',$this->ReffererDoctor->find('list',array('conditions' => array('ReffererDoctor.is_deleted' => 0, 'ReffererDoctor.is_referral' => 'Y'), 'fields' => array('ReffererDoctor.id', 'ReffererDoctor.name'))));
		//case summary and patient file
		$this->set('recordLink',$this->Location->find('first',array('fields'=>array('case_summery_link','patient_file'),'conditions'=>array('Location.id'=>$this->Session->read('locationid')),'recursive'=>-1)));
		if(!empty($this->request->data)){

			#debug($this->request->data);exit;
			if(!empty($this->request->data['Person']['upload_image']['name'])){
				//creating runtime image name
				$original_image_extension  = explode(".",$this->request->data['Person']['upload_image']['name']);
				if(!isset($original_image_extension[1])){
					$imagename= "person_".mktime().'.'.$original_image_extension[0];
				}else{
					$imagename= "person_".mktime().'.'.$original_image_extension[1];
				}
				//set new image name to DB
				$this->request->data["Person"]['photo']  = $imagename ;
			}else if(!empty($this->request->data['Person']['web_cam'])){
				$im = imagecreatefrompng($this->request->data['Person']['web_cam']);
				if($im){
					$imagename= "person_".mktime().'.png';
					imagejpeg($im,WWW_ROOT.'/uploads/patient_images/thumbnail/'.$imagename);
					$this->request->data["Person"]['photo']  = $imagename ;
				}else{
					unset($this->request->data["Person"]['photo']);
				}
			}else{
				unset($this->request->data["Person"]['photo']);
			}	


			if ($this->request->data['Person'] ['referral_letter']['name']) {
                    $imgName = explode ( '.', $this->request->data['Person'] ['referral_letter']['name'] );
                    if (! isset ( $imgName [1] )) {
                        $refLetter = "ReferralLetter_" . $imgName [0] . mktime () . '.' . $imgName [0];
                    } else {
                        $refLetter = "ReferralLetter_" . $imgName [0] . mktime () . '.' . $imgName [1];
                    }
                    $folderName = 'referral_letter' ;
                   
                $requiredArray1  = array('data' =>array('PatientDocumentDetail'=>array('referral_letter'=>$this->request->data['Person'] ['referral_letter'])));
                $showError1 = $this->ImageUpload->uploadFile($requiredArray1,'referral_letter','uploads/referral_letter',$refLetter);

              $this->request->data["Person"]['referral_letter']  = $refLetter ;
            }else{
				unset($this->request->data["Person"]['referral_letter']);
			}
			if(!empty($this->request->data["Person"]['expected_date_del']))
			{
				$this->request->data["Person"]['expected_date_del'] = $this->DateFormat->formatDate2STD($this->request->data["Person"]['expected_date_del'],Configure::read('date_format'));

			}

			if(!empty($this->request->data["Person"]['dob'])){
				$this->request->data["Person"]['dob'] = $this->DateFormat->formatDate2STD($this->request->data["Person"]['dob'],Configure::read('date_format'));
				$years = ($this->request->data["Person"]['age_year'] != '0') ? $this->request->data["Person"]['age_year'].'Y ' : '';
				$months = ($this->request->data["Person"]['age_month'] != '0') ? $this->request->data["Person"]['age_month'].'M ' : '';
				$days = $this->request->data["Person"]['age_day'].'D' ;
				$this->request->data["Person"]['age'] = $years.$months.$days;

			}
			// staff registration and restrict account creation code added by atul chandankhede
			if($this->request->data["Person"]["is_staff_register"] == '1'){
				$staffName = explode(" ", $this->request->data["Person"]["staff_name"]);
				$this->request->data["Person"]["first_name"] =$staffName[0]; 
				$this->request->data["Person"]["last_name"] =$staffName[1];
			}
			/* if(!empty($this->request->data["Person"]['']){
					} */
			//if($this->request->data["Person"]['known_fam_physician']=='2'){
			//		$this->request->data["Person"]['doctor_id']  =$this->request->data["Person"]['consultant_id'];
			//		$this->request->data["Person"]['consultant_id'] ='';
			// }
			//$this->request->data["Person"]['non_executive_emp_id_no'] = $this->request->data["Person"]['non_executive_emp_id_no'].$this->request->data["Person"]['suffix'];
		
			$this->request->data['Person']['consultant_id'] = serialize($this->request->data['Person']['consultant_id']); //save
			$this->Person->insertPerson($this->request->data,'insert');
			$errors = $this->Person->invalidFields();

			if(!empty($errors)) {
				$this->set("errors", $errors);
			}else {
				if(!empty($this->request->data['Person']['upload_image']['name'])){
					if($this->request->data['Person']['upload_image']['error']){
						if( $this->request->data['Person']['upload_image']['error']==1 ||
								$this->request->data['Person']['upload_image']['error'] ==2){
							$this->Session->setFlash(__('Max file size 2MB exceeded,Please try again', true),array('class'=>'error'));
						}else{
							$this->Session->setFlash(__('There is problem while uplaoding image,Please try again', true),array('class'=>'error'));
						}
					}else{
						$showError = $this->ImageUpload->uploadFile($this->params,'upload_image','uploads/patient_images',$imagename);

						if(empty($showError)) {
							// making thumbnail of 100X100
							$this->ImageUpload->load($this->request->data['Person']['upload_image']['tmp_name']);
							$this->ImageUpload->resize(100,100);
							$this->ImageUpload->save("uploads/patient_images/thumbnail/".$imagename);

						}
					}
				}

				//BOF updating same record with auto generated patient and admission id
				//insert admission ID and patient ID
				$latest_insert_id = $this->Person->getInsertId();
				$patient_id   = $this->autoGeneratedPatientID($latest_insert_id,$this->request->data);
					
				//unset($this->request->data);//unset the posted data we do not need further once inserted
				$this->request->data['Person']['id'] = $latest_insert_id ;
				$this->request->data['Person']['patient_uid'] =$patient_id ;
					
				//QR code image generation
				$qrformat =  $this->qrFormat($this->request->data['Person']);
				App::import('Vendor', 'qrcode', array('file' => 'qrcode/qrlib.php'));
				QRcode::png($qrformat, "uploads/qrcodes/$patient_id.png", 'L', 4, 2);
				//QR code image generation
				$this->request->data['Person']['first_name']=trim($this->request->data['Person']['first_name']);
				$this->request->data['Person']['last_name']=trim($this->request->data['Person']['last_name']);
		 		
				$this->Person->save($this->request->data);
				//debug($this->request->data);exit;
				$this->Session->setFlash(__('UID Patient Registered Successfully', true));
				
		      
		        $hospitalName =$this->Session->read('facility');
				$mobile=$this->request->data['Person']['mobile'];
				$firstname=$this->request->data['Person']['first_name'];
				$person_id = $this->request->data['Person']['id'];
				$this->sendWhatsAppMessageTemplateHope($mobile, $firstname,$hospitalName, $person_id);

				// if click on submitandregister then go to patient registration form
				if($this->request->data["Person"]['submitandregister']) {
					/* if($this->request->data['Person']['admission_type'] == "LAB"){
					 $this->redirect(array('controller'=>'notes',"action" => "addLab",$latest_insert_id));
					}elseif($this->request->data['Person']['admission_type'] == "RAD"){
					$this->redirect(array('controller'=>'notes',"action" => "addRad",$latest_insert_id));
					} */
					if($this->request->data['Person']['admission_type'] == 'prospect')
						$this->redirect(array("controller" => "persons", "action" => "add"));
					else	
						$this->redirect(array("controller" => "patients", "action" => "add", $latest_insert_id, 'submitandregister' =>$this->request->data["Person"]['submitandregister'],'?'=>array('type'=>$this->data['Person']['admission_type'],'from'=>'UID','is_staff_register'=>$this->request->data["Person"]["is_staff_register"],'is_paragon'=>$this->request->data["Person"]["is_paragon"])));
				}
				// if click on capturefingerprint then go to biometric identification page
				else if($this->request->data["Person"]['capturefingerprint']){
					$this->redirect(array("controller" => "persons", "action" => "finger_print", $latest_insert_id, 'capturefingerprint' =>$this->request->data["Person"]['capturefingerprint'],'?'=>array('type'=>$this->data['Person']['admission_type'])));
				}else if($this->request->data["Person"]['submitandschedule']){
					$this->redirect(array("controller" => "DoctorSchedules", "action" => "doctor_event",'1','0','0',date('Y-m-d'),'personid'=>$latest_insert_id));
				} else {
					$this->redirect(array("controller" => "persons", "action" => "searchPerson",'?'=>array('first_name'=>$this->request->data['Person']['first_name'],'last_name'=>$this->request->data['Person']['last_name'])));
				}
			}
		}
		if(isset($this->params['named']['sendTo'])){
			$this->set('redirectTo',$this->params['named']['sendTo']);
		}
		//by amit jain for accounting group
		/* $this->set('group',$this->AccountingGroup->find('list',array('fields'=>array('id','name'),'conditions'=>array('is_deleted'=>'0'),'order'=>array('name ASC')))); */
	}


	public function edit($id=null){

		$this->set('title_for_layout', __('-UID Patient Registration', true));
		//load model
// 			$hospitalName = "Hope Hospital"; // Setting the hospital name
// 			$contactInfo = "18002330000";
		$this->uses = array('Patient','Initial','DoctorProfile','Consultant','CorporateLocation','Corporate', 'CorporateSublocation', 'InsuranceType', 'InsuranceCompany','CreditType','ReffererDoctor','State');
		$this->set('initials',$this->Initial->find('list',array('fields'=>array('name'))));
		$this->set('doctors',$this->DoctorProfile->getDoctors());
		$this->set('treatmentConsultant',$this->Consultant->find('list',array('CONCAT(Consultant.first_name," ",Consultant.last_name) as name')));
		$this->set('reffererdoctors',$this->ReffererDoctor->find('list',array('conditions' => array('ReffererDoctor.is_deleted' => 0, 'ReffererDoctor.is_referral' => 'Y'), 'fields' => array('ReffererDoctor.id', 'ReffererDoctor.name'))));
		
		if(!empty($this->request->data)){#debug($this->request->data); exit;
			// change corporate location , name and sublocations set to zero if insurance exist in edit and vice versa
			/*  if(isset($this->request->data['Person']['credit_type_id'])) {
			 if($this->request->data['Person']['credit_type_id'] == 1) {
			$this->request->data['Person']['insurance_type_id'] = 0;
			$this->request->data['Person']['insurance_company_id'] = 0;
			}
			if($this->request->data['Person']['credit_type_id'] == 2) {
			$this->request->data['Person']['corporate_location_id'] = 0;
			$this->request->data['Person']['corporate_id'] = 0;
			$this->request->data['Person']['corporate_sublocation_id'] = 0;
			}
			}else {
			$this->request->data['Person']['credit_type_id'] = 0;
			$this->request->data['Person']['insurance_type_id'] = 0;
			$this->request->data['Person']['insurance_company_id'] = 0;
			$this->request->data['Person']['corporate_location_id'] = 0;
			$this->request->data['Person']['corporate_id'] = 0;
			$this->request->data['Person']['corporate_sublocation_id'] = 0;
			} */
			// end corporate location //
			//Unset if these fields has any data assigned already for cash option
			if($data["Person"]['payment_category']=='cash'){
				$data["Person"]['name_of_ip']  = '';
				$data["Person"]['relation_to_employee']  = '';
				$data["Person"]['executive_emp_id_no']  = '';
				$data["Person"]['non_executive_emp_id_no']  = '';
				$data["Person"]['suffix']  = '';
				$data["Person"]['designation']  = '';
				$data["Person"]['insurance_number']  = '';
				$data["Person"]['sponsor_company']  = '';
			}
			//$this->request->data["Person"]['non_executive_emp_id_no'] = $this->request->data["Person"]['non_executive_emp_id_no'].$this->request->data["Person"]['suffix'];


			if ($this->request->data['Person'] ['referral_letter']['name']) {
                    $imgName = explode ( '.', $this->request->data['Person'] ['referral_letter']['name'] );
                    if (! isset ( $imgName [1] )) {
                        $refLetter = "ReferralLetter_" . $imgName [0] . mktime () . '.' . $imgName [0];
                    } else {
                        $refLetter = "ReferralLetter_" . $imgName [0] . mktime () . '.' . $imgName [1];
                    }
                    $folderName = 'referral_letter' ;
                   
                $requiredArray1  = array('data' =>array('PatientDocumentDetail'=>array('referral_letter'=>$this->request->data['Person'] ['referral_letter'])));
                $showError1 = $this->ImageUpload->uploadFile($requiredArray1,'referral_letter','uploads/referral_letter',$refLetter);

              $this->request->data["Person"]['referral_letter']  = $refLetter ;
            }else{
				unset($this->request->data["Person"]['referral_letter']);
			}
			
			if(!empty($this->request->data["Person"]['dob'])){
				$this->request->data["Person"]['dob'] = $this->DateFormat->formatDate2STD($this->request->data["Person"]['dob'],Configure::read('date_format'));
			}
			$data = $this->request->data;
			$this->Person->insertPerson($data,'update');
			$errors = $this->Person->invalidFields();
			if(!empty($this->request->data['Person']['upload_image']['name'])){
				//creating runtime image name
				$original_image_extension  = explode(".",$this->request->data['Person']['upload_image']['name']);
				if(!isset($original_image_extension[1])){
					$imagename= "person_".mktime().'.'.$original_image_extension[0];
				}else{
					$imagename= "person_".mktime().'.'.$original_image_extension[1];
				}
				//set new image name to DB
				$this->request->data["Person"]['photo']  = $imagename ;
			}else{
				unset($this->request->data["Person"]['photo']);
			}

			

			if(!empty($errors)) {
				$this->set("errors", $errors);
			}else {
					
				$admission_data = $this->Person->read('patient_uid,photo',$this->request->data['Person']['id']) ;
					
				if(!empty($this->request->data['Person']['upload_image']['name'])){
					//remove previous image
					if($this->request->data['Person']['upload_image']['error']){
						if( $this->request->data['Person']['upload_image']['error']==1 ||
								$this->request->data['Person']['upload_image']['error'] ==2){
							$this->Session->setFlash(__('Max file size 2MB exceeded,Please try again', true),array('class'=>'error'));
						}else{
							$this->Session->setFlash(__('There is problem while uplaoding image,Please try again', true),array('class'=>'error'));
						}
					}else{
						if($admission_data['Person']['photo']){
							$this->ImageUpload->removeFile($admission_data['Person']['photo'],'uploads/patient_images');
						}

						$showError = $this->ImageUpload->uploadFile($this->params,'upload_image','uploads/patient_images',$imagename);

						if(empty($showError)) {
							// making thumbnail of 100X100
							$this->ImageUpload->load($this->request->data['Person']['upload_image']['tmp_name']);
							$this->ImageUpload->resize(100,100);
							$this->ImageUpload->save("uploads/patient_images/thumbnail/".$imagename);
							if($admission_data['Person']['photo']){
								$this->ImageUpload->removeFile($admission_data['Person']['photo'],'uploads/patient_images/thumbnail/');
							}
						}
					}
				}else if(!empty($this->request->data['Person']['web_cam'])){
					$im = imagecreatefrompng($this->request->data['Person']['web_cam']);
					if($im){
						$imagename= "person_".mktime().'.png';
						$is_uploaded = imagejpeg($im,WWW_ROOT.'/uploads/patient_images/thumbnail/'.$imagename);
						if($is_uploaded){
							$this->request->data["Person"]['photo']  = $imagename ;
							if($admission_data['Person']['photo']){
								$this->ImageUpload->removeFile($admission_data['Person']['photo'],'uploads/patient_images/thumbnail/');
							}
						}
							
					}else{
						unset($this->request->data["Person"]['photo']);
					}
				}
					
				$patient_id = $this->request->data['Person']['patient_uid'];
				//QR code image generation
				$qrformat =  $this->qrFormat($this->request->data['Person']);
				App::import('Vendor', 'qrcode', array('file' => 'qrcode/qrlib.php'));
				unlink("uploads/qrcodes/$patient_id.png");
				QRcode::png($qrformat, "uploads/qrcodes/$patient_id.png", 'L', 4, 2);
				
				if(!empty($this->request->data["Person"]['dob'])){
					$this->request->data["Person"]['dob'] = $this->DateFormat->formatDate2STD($this->request->data["Person"]['dob'],Configure::read('date_format'));
					//calculate age on the basis of entered DOB
					//	$this->request->data["Person"]['age'] = $this->DateFormat->getAge($this->request->data["Person"]['dob']) ;

				}
				//update name in patient table
				$complete_name = ucfirst($this->request->data['Person']['first_name'])." ".ucfirst($this->request->data['Person']['last_name']);
				$years = $this->request->data["Person"]['age_year'].'Y ';
				$months = $this->request->data["Person"]['age_month'].'M ' ;
				$days = $this->request->data["Person"]['age_day'].'D' ;
				$this->request->data["Person"]['age'] = $years.$months.$days ;
				// for updating referral doctor in patient table if we change from person edit form-atul
				//$knw_fam_phys=$this->request->data["Person"]['known_fam_physician'] ;
				//$consultant_id=serialize($this->request->data["Person"]['consultant_id'] );
				$this->Patient->updateAll(array('lookup_name'=>"'".$complete_name."'",'age'=>"'".$this->request->data["Person"]['age']."'",
						'sex'=>"'".$this->request->data["Person"]['sex']."'"/*,'known_fam_physician'=>"'".$knw_fam_phys."'" ,'consultant_id'=>"'".$consultant_id."'" */),array('Patient.person_id'=>$this->request->data['Person']['id']));
				//EOF patient update
				//QR code image generation
			  
			    	$this->request->data["Person"]['expected_date_del'] = $this->DateFormat->formatDate2STD($this->request->data["Person"]['expected_date_del'],Configure::read('date_format'));
			    	//$this->request->data["Person"]['consultant_id'] = serialize($this->request->data["Person"]['consultant_id']);
				if(!empty($this->request->data["Person"]['dob'])){
					$this->request->data["Person"]['dob'] = $this->DateFormat->formatDate2STD($this->request->data["Person"]['dob'],Configure::read('date_format'));
				}
				//debug($this->request->data);die();
				$this->Person->save($this->request->data);
                // Send WhatsApp message
				//sync last registration record with current person's details
				$this->Person->updateSponsorDetails($this->request->data,$id);
				//EOD sync
				$this->Session->setFlash(__('UID Patient Updated Successfully', true));
				if($this->request->data["Person"]['submitandregister']) {
					$this->redirect(array("controller" => "patients", "action" => "add", $id, 'submitandregister' =>$this->request->data["Person"]['submitandregister'],'?'=>array('type'=>$this->data['Person']['admission_type'])));
				}else {
					$this->redirect(array("action" => "patient_information",$id));
				}
			}
		}
		//$data =$this->Person->read(null,$id);
		$this->Person->bindModel(array(
				'belongsTo' => array(
						'State' =>array('foreignKey' => false,'conditions'=>array('State.id=Person.state')),
				)),false);
		$data = $this->Person->find('first',array('conditions'=>array('Person.id'=>$id),'fields'=>array('Person.*','State.name')));
			
		//$data['Person']['uiddate'] = $this->DateFormat->formatDate2Local($data['Person']['uiddate'],Configure::read('date_format'),true);
		//split exe emp id to number and suffix
			
		/*if(strpos($data["Person"]['non_executive_emp_id_no'],'SELF') || $data["Person"]['non_executive_emp_id_no']=='SELF'){
		 $subCount  =  4 ;
		}else{
		$subCount  =  3 ;
		}
		$data["Person"]['suffix']  = substr($data["Person"]['non_executive_emp_id_no'],-$subCount);
		$data["Person"]['non_executive_emp_id_no']  = substr($data["Person"]['non_executive_emp_id_no'],0,strlen($data["Person"]['non_executive_emp_id_no'])-$subCount) ;
		*/
		if(!empty($data['Person']['non_executive_emp_id_no'])){
			$data['Person']['suffix'] = $data['Person']['relation_to_employee'] ;
		}
			
		if(!empty($data["Person"]['dob'])){

			$date1 = new DateTime($data["Person"]['dob']);
			$date2 = new DateTime();
			$interval = $date1->diff($date2);
			$data["Person"]['age_year'] = $interval->y;
			$data["Person"]['age_month'] = $interval->m;
			$data["Person"]['age_day'] = $interval->d;
			$data["Person"]['dob']= $this->DateFormat->formatDate2Local($data["Person"]['dob'],Configure::read('date_format'));
		}


		$this->data = $data;
		$paytypeAry = Configure :: read('SponsorValue');
		//echo $data['Person']['known_fam_physician'];exit;
		// this code is used for ajax drop down payment category //
		$this->set('credittypes',$this->CreditType->find('list',array('fields' => array('CreditType.id','CreditType.name'), 'conditions'=> array('CreditType.is_deleted' => 0))));
		$this->set('corporatelocations',$this->CorporateLocation->find('list',array('fields' => array('CorporateLocation.id','CorporateLocation.name'), 'conditions'=> array('CorporateLocation.credit_type_id' => $paytypeAry[$data['Person']['payment_category']],'CorporateLocation.is_deleted' => 0))));

		$this->set('corporates',$this->Corporate->find('list',array('fields' => array('Corporate.id','Corporate.name'), 'conditions'=> array('Corporate.is_deleted' => 0,'Corporate.corporate_location_id' => $this->data['Person']['corporate_location_id']))));

		$this->set('corporatesublocations',$this->CorporateSublocation->find('list',array('fields' => array('CorporateSublocation.id','CorporateSublocation.name'), 'conditions'=> array('CorporateSublocation.is_deleted' => 0,'CorporateSublocation.corporate_id' => $this->data['Person']['corporate_id']))));

		// for insurance drop down //
		$this->set('insurancetypes',$this->InsuranceType->find('list',array('fields' => array('InsuranceType.id','InsuranceType.name'), 'conditions'=> array('InsuranceType.is_deleted' => 0))));
		$this->set('insurancecompanies',$this->InsuranceCompany->find('list',array('fields' => array('InsuranceCompany.id','InsuranceCompany.name'), 'conditions'=> array('InsuranceCompany.is_deleted' => 0,'InsuranceCompany.insurance_type_id' => $paytypeAry[$data['Person']['payment_category']]))));
		$mergeArray=array();
		$doctorlist=$this->Consultant->find('list',array('fields' => array('Consultant.id','Consultant.full_name'), 'order'=>array('Consultant.first_name ASC')));		
	
		$mergeArray = array('None'=>'None')+$doctorlist;
		$this->set('doctorlist',$mergeArray);
		// for registrar listing //
		$this->set('registrarlist', $this->DoctorProfile->getRegistrar());
		// end //

			
	}
            	private function sendWhatsAppMessageTemplateHope($mobile, $firstname, $hospitalName, $person_id) {
                $contactInfo = "18002330000"; // Contact information
                $apiUrl = "https://public.doubletick.io/whatsapp/message/template";
                $apiKey = "key_8sc9MP6JpQ"; // Replace with your actual API key
            
                // Payload for the API
                $payload = [
                    "messages" => [
                        [
                            "to" => "+91" . $mobile, // Mobile number with country code
                            "content" => [
                                "templateName" => "after_patient_hope",  // Template name from API
                                "language" => "en", // Language code
                                "templateData" => [
                                    "body" => [
                                        "placeholders" => [
                                            $firstname,   // First placeholder: Patient's name
                                            $hospitalName, // Second placeholder: Hospital's name
                                            $person_id,    // Third placeholder: Patient's registration ID
                                            $contactInfo   // Fourth placeholder: Contact information
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ];
            
                // Initialize cURL
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $apiUrl);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    "Accept: application/json",
                    "Content-Type: application/json",
                    "Authorization: $apiKey"
                ]);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            
                // Execute the cURL request
                $response = curl_exec($ch);
            
                // Check for cURL errors
                if (curl_errno($ch)) {
                    curl_close($ch);
                    return "Error: " . curl_error($ch);
                }
            
                curl_close($ch);
            
                // Parse the API response
                $responseData = json_decode($response, true);
                // Check response for success or failure
                if (isset($responseData['messages'][0]['status']) && $responseData['messages'][0]['status'] === 'SUCCESS') {
                    return "Message sent successfully!";
                } else {
                    return "Error: " . (isset($responseData['messages'][0]['errorMessage']) ? $responseData['messages'][0]['errorMessage'] : "Something went wrong.");
                }
            }


	
	
	function insurance_onchange($id){

		//	debug("hello");exit;
		$this->loadModel('InsuranceCompany');
		$parentOption  = $this->InsuranceCompany->find('list',array('fields'=>array('name'),'conditions'=>array('InsuranceCompany.insurance_type_id'=>$id,'InsuranceCompany.is_deleted'=>'0')));
		echo json_encode($parentOption);
		exit;
	}


	//********************BOF-Mahalaxmi************************///
	public function viewImage($imageName){
		$this->layout =false;
		$this->set(compact('imageName'));
	}
	//********************EOF-Mahalaxmi************************///
	/**
	 * Method to delete UIDPatient
	 *
	 * @param id: UIDPatient ID
	 *
	 **/

	function delete($id = null,$UID =null) {

		if($id){
			$this->Person->id = $id;
			if ($this->Person->save(array('is_deleted' => 1))) {
				$this->loadModel('Patient');
				$this->loadModel('WardPatient');
				$this->loadModel('Bed');

				//BOF pankaj
				$patientData = $this->Patient->find('all',array('conditions'=>array('Patient.person_id'=>$id),'fields'=>array('Patient.id')));
					
				foreach($patientData as $patientKey ){
					$patientArr[] = $patientKey['Patient']['id'];


				}
				$inPatient = implode(',',$patientArr);
					
				//EOF pankaj

				$this->Patient->updateAll(
						array('Patient.is_deleted' => 1),
						array('Patient.patient_id' => $UID)
				);
				if(!empty($patientData)){
					$this->WardPatient->updateAll(
							array('WardPatient.is_deleted' => 1),
							array('WardPatient.patient_id in ('.$inPatient.')')
					);
					$this->Bed->updateAll(
							array('Bed.patient_id' => 0),
							array('Bed.patient_id in ('.$inPatient.')')
					);


				}


				$this->Session->setFlash(__('Patient Deleted ','',array('class'=>'message')));
				$this->redirect($this->referer());
			}
		}else{
			$this->Session->setFlash(__('Invalid Operation'),array('class'=>'error'));
			$this->redirect(array('action' => 'index'));
		}
	}

	function search(){
		$this->set('data','');
			
		$role = $this->Session->read('role');
		$search_key['Person.is_deleted'] = 0;
		$search_key['Person.location_id'] = $this->Session->read('locationid');
		//$this->Person->recursive = -1;
		//$this->Person->virtualFields['full_name'] = "";
		$this->Person->virtualFields = array(
				'full_name' => 'CONCAT(Initial.name, " ", Person.first_name, " ", Person.last_name)'
		);
		$this->Person->bindModel(array(
				'belongsTo' => array(
						'Initial' =>array('foreignKey' => false,'conditions'=>array('Initial.id=Person.initial_id')),
						'Patient' =>array('foreignKey'=>false,'conditions'=>array('Patient.person_id = Person.id')),

				)),false);
		if($role == 'admin'){
			//	$search_key['User.facility_id']=$this->Session->read('facilityid');
			/*$this->Person->bindModel(array(
			 'belongsTo' => array(
			 		'User' =>array('foreignKey' => false,'conditions'=>array('User.location_id=Person.location_id')),

			 )),false);  */

		}else{
			$search_key['Person.location_id']=$this->Session->read('locationid');
			//$search_key['Person.admission_type']='OPD';
			/*$this->Person->bindModel(array(
			 'belongsTo' => array(
			 		'User' =>array('foreignKey' => false,'conditions'=>array('User.location_id=Person.location_id')),

			 )),false);*/
		}
			
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order'=>array('Person.create_time' => 'DESC'),
				'group'=>array('Person.id'),
				'fields'=>array('Person.dob','Person.ssn_us','Person.patient_uid','Person.uiddate','Person.full_name','Person.create_time',
						'Person.sex','Person.id','Person.non_executive_emp_id_no','Person.relation_to_employee','Person.executive_emp_id_no',
						'Initial.*','Patient.id','Patient.is_discharge','Patient.is_deleted','Person.admission_type')
		);

		if(!empty($this->request->query)){
			$search_ele = $this->request->query;
			if(!empty($search_ele['first_name'])){
				//sliptup complete name
				$search_ele['first_name'] = explode(" ",$search_ele['first_name']);
				if(count($search_ele['first_name']) > 1){
					$search_key['SOUNDEX(Person.first_name) like'] = "%".soundex(trim($search_ele['first_name'][0]))."%";
					$search_key['SOUNDEX(Person.last_name) like'] = "%".soundex(trim($search_ele['first_name'][1]))."%";
				}else if(count($search_ele['lookup_name)']) == 0){
					$search_key['OR'] = array(
							'SOUNDEX(Person.first_name)  like'  => "%".soundex(trim($search_ele['first_name'][0]))."%",
							'SOUNDEX(Person.last_name)   like'  => "%".soundex(trim($search_ele['first_name'][0]))."%");
				}
			}if(!empty($search_ele['patient_uid'])){
				$search_key['Person.patient_uid like '] = "%".$search_ele['patient_uid'] ;
			}if(!empty($search_ele['non_executive_emp_id_no'])){
				$search_key['Person.non_executive_emp_id_no like '] = "%".$search_ele['non_executive_emp_id_no'] ;
			}if(!empty($search_ele['dob'])){
				$search_key['Person.dob like '] = "%".trim(substr($this->DateFormat->formatDate2STD($search_ele['dob'],Configure::read('date_format')),0,10));
			}if(!empty($search_ele['ssn_us'])){
				$search_key['Person.ssn_us like '] = $this->request->query['ssn_us']."%" ;
			}
			$data = $this->paginate('Person',$search_key);
			$this->set('data', $data);
			$this->data = array('Person'=>$this->params->query);

		}else{
			$data = $this->paginate('Person',array($search_key));
			$this->set('data', $data);
		}
	}


	function search_ambi(){
		$this->set('data','');

		$role = $this->Session->read('role');
		$search_key['Person.is_deleted'] = 0;
		$search_key['Person.location_id'] = $this->Session->read('locationid');
		//$this->Person->recursive = -1;
		//$this->Person->virtualFields['full_name'] = "";
		$this->Person->virtualFields = array(
				'full_name' => 'CONCAT(Initial.name, " ", Person.first_name, " ", Person.last_name)'
		);
		$this->Person->bindModel(array(
				'belongsTo' => array(
						'Initial' =>array('foreignKey' => false,'conditions'=>array('Initial.id=Person.initial_id')),

				)),false);
		if($role == 'admin'){
			//	$search_key['User.facility_id']=$this->Session->read('facilityid');
			/*$this->Person->bindModel(array(
			 'belongsTo' => array(
			 		'User' =>array('foreignKey' => false,'conditions'=>array('User.location_id=Person.location_id')),

			 )),false);  */

		}else{
			$search_key['Person.location_id']=$this->Session->read('locationid');
			/*$this->Person->bindModel(array(
			 'belongsTo' => array(
			 		'User' =>array('foreignKey' => false,'conditions'=>array('User.location_id=Person.location_id')),

			 )),false);*/
		}

		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order'=>array('Person.create_time' => 'DESC'),
				'group'=>array('Person.id'),
				//'fields'=>array('Person.*')
		);
		if(!empty($this->request->query)){
			$search_ele = $this->request->query;

			if(!empty($search_ele['first_name'])){
				//sliptup complete name

				$splittedName = explode(" ",$search_ele['first_name']);
				$first_name = $splittedName[0];
				$last_name = $splittedName[count($splittedName)];
				$search_key['Person.first_name like '] = $first_name."%" ;
				if(!empty($last_name)){
					$search_key['Person.last_name like '] = $last_name."%" ;
				}
			}if(!empty($search_ele['patient_uid'])){
				$search_key['Person.patient_uid like '] = "%".$search_ele['patient_uid'] ;
			}if(!empty($search_ele['non_executive_emp_id_no'])){
				$search_key['Person.non_executive_emp_id_no like '] = "%".$search_ele['non_executive_emp_id_no'] ;
			}
			$data = $this->paginate('Person',$search_key);
			$this->set('data', $data);
			$this->data = array('Person'=>$this->params->query);

		}else{
			$data = $this->paginate('Person',array($search_key));
			$this->set('data', $data);
		}
	}

	function patient_information($id=null) {
		$this->uses=array('Patient','CorporateSublocation','Corporate','Consultant');
		if(!empty($id)){
			$this->Person->bindModel(array(
					'belongsTo' => array(
							'Initial' =>array('foreignKey'=>'initial_id'),
							'Country' =>array('foreignKey'=>'country'),
							'State' =>array('foreignKey'=>'state'))));
			$patient_details  = $this->Person->getPersonDetailsByID($id);
			$sponsorName = $this->CorporateSublocation->getSublocationNameById($patient_details['Person']['corporate_sublocation_id']);
			$corpoName = $this->Corporate->find('first',array(
					'conditions'=>array('Corporate.id'=>$sponsorName['CorporateSublocation']['corporate_id']),
					'fields'=>array('Corporate.name')
					));
			
			$this->set(compact('corpoName'));
			$patientIDS = $this->Patient->getAllPatientIds($id); 
			$consultantName = $this->Patient->getPateintConsultantName($patientIDS);
			$this->set('patientIDS',$patientIDS);
			$this->set('consultantName',$consultantName);
			
			$formatted_address = $this->setAddressFormat($patient_details['Person'],$patient_details['Country'],$patient_details['State']);
			$this->set(array('formatted_address'=>$formatted_address,'patient_details'=>$patient_details,'id'=>$id));
			$this->loadModel('Patient','Consultant');
			$this->Patient->bindModel(array(
					'belongsTo' => array(
							'User' =>array('foreignKey'=>'doctor_id'),
							'Initial' =>array('foreignKey' => false,'conditions'=>array('User.initial_id=Initial.id' )),
							'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
							'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),
					)));
			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'order' => array('Patient.id' => 'asc'),
					'fields'=> array('Patient.id','Patient.lookup_name','Patient.mobile_phone','Patient.admission_type','Patient.landline_phone','CONCAT(User.first_name, " ", User.last_name) as name',
							'Patient.form_received_on','Patient.admission_id','Patient.expected_date_del'),
					'conditions'=>array('Patient.patient_id'=>$patient_details['Person']['patient_uid'],'Patient.is_deleted'=>'0')
			);
			$this->set('data',$this->paginate('Patient'));
		}else{
			$this->redirect(array("controller" => "patients", "action" => "index"));
		}
	}

	function growth_chart($id=null) {
		$this->uses = array('Patient');
		$this->Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		// Bmi For OPD patient
		$this->Patient->bindModel( array(
				'belongsTo' => array(
						'BmiResult'=>array('conditions'=>array('BmiResult.patient_id=Patient.id'),'foreignKey'=>false),
						'Person'=>array('conditions'=>array('Person.id=Patient.person_id'),'foreignKey'=>false)
				)
		));
		$patient = $this->Patient->find('all',array('fields'=>array('Patient.patient_id,Person.dob,Patient.person_id,Patient.id,Patient.age,Person.sex,Patient.lookup_name'),'conditions'=>array('Patient.person_id'=>$id)));
		$this->set(compact('patient','id'));

	}

	function bmi_chart($id=null) {
			
		$this->layout=false;
		$this->set('title_for_layout', __('Growth Chart', true));
		$this->uses = array('Patient','Diagnosis');


		$patient = $this->Patient->find('all',array('fields'=>array('Patient.patient_id,Patient.person_id,Patient.id'),'conditions'=>array('Patient.person_id'=>$id)));
			

		for($k=0;$k<count($patient);$k++){
			$j[]=$patient[$k][Patient][id];
		}
			
		$this->Diagnosis->bindModel( array(
				'belongsTo' => array(
						'Patient'=>array('conditions'=>array('Diagnosis.patient_id=Patient.id'),'foreignKey'=>false),
						'Person'=>array('conditions'=>array('Person.id=Patient.person_id'),'foreignKey'=>false)
				)
		));

		$diagnosis = $this->Diagnosis->find('all',array('fields'=>array('Diagnosis.height,Diagnosis.weight,Diagnosis.bmi,Diagnosis.patient_id,Diagnosis.create_time,
				Patient.age,Person.sex,Patient.lookup_name'),'conditions'=>array('Diagnosis.patient_id'=>$j),'order' => array('Patient.id' => 'asc')));

		$this->set('j',$j);
		$this->set('diagnosis',$diagnosis);
		$this->set('patient', $patient);
		$this->set('height', $height);
		$this->set('weight', $weight);
		$this->set('bmi',$bmi);
	}

	//BMI chart for male age 2 to 20 years
	function bmi_chart_male($id=null) {

		$this->layout=false;
		$this->set('title_for_layout', __('Growth Chart', true));
		$this->uses = array('Patient','BmiResult','ReviewPatientDetail');
			
		$this->Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		// Bmi For OPD patient
		$this->Patient->bindModel( array(
				'belongsTo' => array(
						'BmiResult'=>array('conditions'=>array('BmiResult.patient_id=Patient.id'),'foreignKey'=>false),
						'Person'=>array('conditions'=>array('Person.id=Patient.person_id'),'foreignKey'=>false)
				)
		));

		$diagnosis = $this->Patient->find('all',array('fields'=>array('BmiResult.height,BmiResult.weight,BmiResult.bmi,BmiResult.patient_id,BmiResult.created_time,
				Patient.age,Patient.admission_type,Person.sex,Person.dob,Patient.lookup_name'),'conditions'=>array('Patient.person_id'=>$id,'Patient.is_deleted'=>0,'Patient.admission_type'=>'OPD'),'order' => array('Patient.id' => 'asc')));
			
		foreach($diagnosis as $data)
		{
			$var=$this->DateFormat->dateDiff($data['Person']['dob'],$data['BmiResult']['created_time']);
			$day=$var->days;
			$year[$day]=$var->y;
			$month[$day]=$var->m;
			$patient_name=$data['Patient']['lookup_name'];
			$date[$day]=$data['BmiResult']['created_time'];
			$bmi_Day[$day][]=$data['BmiResult']['bmi'];
		}

		//getting BMI for IPD patient
		$this->Patient->bindModel(array(
				'belongsTo'=>array(
						'ReviewPatientDetail'=>array('conditions'=>array('ReviewPatientDetail.patient_id=Patient.id'),'foreignKey'=>false),
						'ReviewSubCategoriesOption'=>array(
								'conditions'=>array('ReviewSubCategoriesOption.name LIKE'=>"%".Configure::read('interactive_bmi')."%"),'foreignKey'=>false),
						'Person'=>array('conditions'=>array('Person.id=Patient.person_id'),'foreignKey'=>false)
				)));
			
		$diagnosis1 = $this->Patient->find('all',array('fields'=>array('ReviewPatientDetail.values,ReviewPatientDetail.date,
				Patient.age,Patient.admission_type,Person.sex,Person.dob,Patient.lookup_name,ReviewSubCategoriesOption.id'),
				'conditions'=>array('Patient.person_id'=>$id,'ReviewSubCategoriesOption.id=ReviewPatientDetail.review_sub_categories_options_id','Patient.is_deleted'=>0,'ReviewPatientDetail.edited_on IS NULL','Patient.admission_type'=>'IPD'),'order' => array('Patient.id' => 'asc')));
			

		foreach($diagnosis1 as $data)
		{
			$var=$this->DateFormat->dateDiff($data['Person']['dob'],$data['ReviewPatientDetail']['date']);
			$day=$var->days;
			$year[$day]=$var->y;
			$patient_name=$data['Patient']['lookup_name'];
			$month[$day]=$var->m;
			$date[$day]=$data['ReviewPatientDetail']['date'];
			$bmi_Day[$day][]=$data['ReviewPatientDetail']['values'];
		}

		//array for setting the  percentiles of standard dataLines
		$percentile3Array=array('730'=>'14.52095','745' =>'14.50348','776' =>'14.46882','806' =>'14.4346','836' =>'14.40083','867' =>'14.36755','897' =>'14.33478',
				'928' =>'14.30257','958' =>'14.27093','989' =>'14.23989','1019' =>'14.20948','1049' => '14.17972','1080' => '14.15063','1110' => '14.12223',
				'1141' => '14.09453','1171' => '14.06756','1201' => '14.04132','1232' => '14.01582','1262' => '13.99107','1293' => '13.96707','1323' => '13.94383',
				'1354' => '13.92133','1384' => '13.89959','1414' => '13.87858','1445' => '13.85832','1475' => '13.83877','1506' => '13.81995','1536' => '13.80182',
				'1566' => '13.78439','1597' => '13.76763','1627' => '13.75152','1658' => '13.73606','1688' => '13.72123','1719' => '13.70702','1749' => '13.6934',
				'1779' => '13.68036','1810' => '13.6679','1840' => '13.656','1871' => '13.64464','1901' => '13.63383','1931' => '13.62355','1962' => '13.61379',
				'1992' => '13.60456','2023' => '13.59584','2053' => '13.58764','2084' => '13.57996','2114' => '13.57278','2144' => '13.56612','2175' => '13.55998',
				'2205' => '13.55435','2236' => '13.54925','2266' => '13.54467','2296' => '13.54062','2327' => '13.5371','2357' => '13.53412','2388' => '13.53168',
				'2418' => '13.5298','2449' => '13.52846','2479' => '13.52768','2509' => '13.52747','2540' => '13.52782','2570' => '13.52874','2601' => '13.53025',
				'2631' => '13.53233','2661' => '13.535','2692' => '13.53826','2722' => '13.54212','2753' => '13.54657','2783' => '13.55163','2814' => '13.55729',
				'2844' => '13.56356','2874' => '13.57044','2905' => '13.57793','2935' => '13.58604','2966' => '13.59477','2996' => '13.60411','3026' => '13.61408',
				'3057' => '13.62467','3087' => '13.63588','3118' => '13.64771','3148' => '13.66017','3179' => '13.67325','3209' => '13.68696','3239' => '13.70129',
				'3270' => '13.71624','3300' => '13.73182','3331' => '13.74801','3361' => '13.76483','3391' => '13.78227','3422' => '13.80033','3452' => '13.819',
				'3483' => '13.83828','3513' => '13.85818','3544' => '13.87868','3574' => '13.89979','3604' => '13.92151','3635' => '13.94382','3665' => '13.96673',
				'3696' => '13.99024','3726' => '14.01433','3756' => '14.03901',	'3787' => '14.06427','3817' => '14.09011','3848' => '14.11653','3878' => '14.14351',
				'3909' => '14.17106','3939' => '14.19916','3969' => '14.22782','4000' => '14.25703','4030' => '14.28678','4061' => '14.31707','4091' => '14.34789',
				'4121' => '14.37924','4152' => '14.41111','4182' => '14.44349','4213' => '14.47638','4243' => '14.50977','4274' => '14.54365','4304' => '14.57802',
				'4334' => '14.61287','4365' => '14.64819','4395' => '14.68398','4426' => '14.72022','4456' => '14.75692','4486' => '14.79406','4517' => '14.83163',
				'4547' => '14.86963','4578' => '14.90804','4608' => '14.94687','4639' => '14.98609','4669' => '15.02571','4699' => '15.06571','4730' => '15.10609',
				'4760' => '15.14683','4791' => '15.18793','4821' => '15.22938','4851' => '15.27116','4882' => '15.31327','4912' => '15.3557','4943' => '15.39843',
				'4973' => '15.44147','5004' => '15.48479','5034' => '15.52839','5064' => '15.57226','5095' => '15.61638','5125' => '15.66076','5156' => '15.70536',
				'5186' => '15.75019','5216' => '15.79524','5247' => '15.84049','5277' => '15.88593','5308' => '15.93155','5338' => '15.97734','5369' => '16.02329',
				'5399' => '16.06939','5429' => '16.11562','5460' => '16.16198','5490' => '16.20844','5521' => '16.25501','5551' => '16.30166','5581' => '16.34839',
				'5612' => '16.39519','5642' => '16.44203','5673' => '16.48892','5703' => '16.53583','5734' => '16.58276','5764' => '16.62969','5794' => '16.67661',
				'5825' => '16.72351','5855' => '16.77038','5886' => '16.8172','5916' => '16.86396','5946' => '16.91065','5977' => '16.95725','6007' => '17.00375',
				'6038' => '17.05015','6068' => '17.09642','6099' => '17.14256','6129' => '17.18854','6159' => '17.23437','6190' => '17.28002','6220' => '17.32548',
				'6251' => '17.37074','6281' => '17.41579','6311' => '17.46061','6342' => '17.50518','6372' => '17.54951','6403' => '17.59356','6433' => '17.63734',
				'6464' => '17.68082','6494' => '17.72399','6524' => '17.76683','6555' => '17.80934','6585' => '17.8515','6616' => '17.89329','6646' => '17.93471',
				'6676' => '17.97573','6707' => '18.01634','6737' => '18.05652','6768' => '18.09626','6798' => '18.13555','6829' => '18.17437','6859' => '18.2127',
				'6889' => '18.25052','6920' => '18.28782','6950' => '18.32459','6981' => '18.3608','7011' => '18.39643','7041' => '18.43148','7072' => '18.46591',
				'7102' => '18.49972','7133' => '18.53287','7163' => '18.56536','7194' => '18.59716','7224' => '18.62825','7254' => '18.65861','7285' => '18.68822',
				'7300' => '18.70274','7315' => '18.71706');
		$percentile5Array=array('730'=>'14.73732','745'=>'14.71929','776'=>'14.68361','806'=>'14.64843','836'=>'14.61379','867'=>'14.57969',
				'897'=>'14.54615','928'=>'14.51319','958'=>'14.48084','989'=>'14.44909','1019'=>'14.41798','1049'=>'14.3875',
				'1080'=>'14.35767',	'1110'=>'14.32851',	'1141'=>'14.30002','1171'=>'14.27222','1201'=>'14.2451','1232'=>'14.21868','1262'=>'14.19297',
				'1293'=>'14.16796','1323'=>'14.14367','1354'=>'14.12009','1384'=>'14.09723','1414'=>'14.07509','1445'=>'14.05366',
				'1475'=>'14.03296',	'1506'=>'14.01296','1536'=>'13.99367','1566'=>'13.97509','1597'=>'13.95722',
				'1627'=>'13.94003','1658'=>'13.92353','1688'=>'13.90771','1719'=>'13.89257','1749'=>'13.87809','1779'=>'13.86426',
				'1810'=>'13.85108','1840'=>'13.83855','1871'=>'13.82665','1901'=>'13.81537','1931'=>'13.80472','1962'=>'13.79469',
				'1992'=>'13.78527','2023'=>'13.77646','2053'=>'13.76825','2084'=>'13.76065','2114'=>'13.75364','2144'=>'13.74724',
				'2175'=>'13.74144','2205'=>'13.73624','2236'=>'13.73164','2266'=>'13.72764','2296'=>'13.72424','2327'=>'13.72145','2357'=>'13.71927',
				'2388'=>'13.71769','2418'=>'13.71672','2449'=>'13.71637','2479'=>'13.71663','2509'=>'13.71751','2540'=>'13.71901',
				'2570'=>'13.72113','2601'=>'13.72387','2631'=>'13.72724','2661'=>'13.73124','2692'=>'13.73587','2722'=>'13.74113','2753'=>'13.74702','2783'=>'13.75355',
				'2814'=>'13.76071','2844'=>'13.76852','2874'=>'13.77695','2905'=>'13.78603','2935'=>'13.79575','2966'=>'13.8061',
				'2996'=>'13.8171','3026'=>'13.82873','3057'=>'13.84101','3087'=>'13.85392','3118'=>'13.86747','3148'=>'13.88166',
				'3179'=>'13.89648','3209'=>'13.91194','3239'=>'13.92804','3270'=>'13.94476','3300'=>'13.96212','3331'=>'13.9801',
				'3361'=>'13.99871','3391'=>'14.01795','3422'=>'14.0378','3452'=>'14.05828','3483'=>'14.07937','3513'=>'14.10107',
				'3544'=>'14.12338','3574'=>'14.1463','3604'=>'14.16982','3635'=>'14.19394','3665'=>'14.21866','3696'=>'14.24396',
				'3726'=>'14.26985','3756'=>'14.29633','3787'=>'14.32338','3817'=>'14.35101','3848'=>'14.3792','3878'=>'14.40796','3909'=>'14.43727','3939'=>'14.46714','3969'=>'14.49756',
				'4000'=>'14.52852','4030'=>'14.56001','4061'=>'14.59203','4091'=>'14.62458','4121'=>'14.65765','4152'=>'14.69122','4182'=>'14.72531',
				'4213'=>'14.75989','4243'=>'14.79496','4274'=>'14.83052','4304'=>'14.86655','4334'=>'14.90306','4365'=>'14.94002','4395'=>'14.97745',
				'4426'=>'15.01532','4456'=>'15.05363','4486'=>'15.09238','4517'=>'15.13155','4547'=>'15.17113','4578'=>'15.21113','4608'=>'15.25152',
				'4639'=>'15.2923','4669'=>'15.33347','4699'=>'15.37501','4730'=>'15.41692','4760'=>'15.45918','4791'=>'15.50179','4821'=>'15.54474','4851'=>'15.58801',
				'4882'=>'15.63161','4912'=>'15.67551','4943'=>'15.71971','4973'=>'15.7642','5004'=>'15.80897','5034'=>'15.85401','5064'=>'15.89931',
				'5095'=>'15.94486','5125'=>'15.99065','5156'=>'16.03667','5186'=>'16.0829','5216'=>'16.12934','5247'=>'16.17598','5277'=>'16.2228','5308'=>'16.2698',
				'5338'=>'16.31696','5369'=>'16.36427','5399'=>'16.41172','5429'=>'16.4593','5460'=>'16.507','5490'=>'16.55481','5521'=>'16.60271','5551'=>'16.6507','5581'=>'16.69875',
				'5612'=>'16.74687','5642'=>'16.79503','5673'=>'16.84323','5703'=>'16.89146','5734'=>'16.93969','5764'=>'16.98792','5794'=>'17.03615','5825'=>'17.08434','5855'=>'17.1325','5886'=>'17.18061',
				'5916'=>'17.22865','5946'=>'17.27662','5977'=>'17.3245','6007'=>'17.37229','6038'=>'17.41995','6068'=>'17.46749','6099'=>'17.51489',
				'6129'=>'17.56214','6159'=>'17.60923','6190'=>'17.65613','6220'=>'17.70284','6251'=>'17.74935','6281'=>'17.79564','6311'=>'17.8417','6342'=>'17.88751','6372'=>'17.93306',
				'6403'=>'17.97834','6433'=>'18.02333','6464'=>'18.06802','6494'=>'18.11239','6524'=>'18.15644','6555'=>'18.20014','6585'=>'18.24349','6616'=>'18.28646',
				'6646'=>'18.32904','6676'=>'18.37122','6707'=>'18.41299','6737'=>'18.45432','6768'=>'18.4952','6798'=>'18.53562','6829'=>'18.57556','6859'=>'18.615','6889'=>'18.65393','6920'=>'18.69233',
				'6950'=>'18.73019','6981'=>'18.76748','7011'=>'18.8042','7041'=>'18.84031','7072'=>'18.87581','7102'=>'18.91068','7133'=>'18.94489','7163'=>'18.97844',
				'7194'=>'19.01129','7224'=>'19.04343','7254'=>'19.07484','7285'=>'19.10551','7300'=>'19.12055','7315'=>'19.1354');
		$percentile10Array=array('730'=>'15.09033','745'=>'15.07117','776'=>'15.03336','806'=>'14.9962','836'=>'14.95969','867'=>'14.92385','897'=>'14.88866','928'=>'14.85414','958'=>'14.82027',
				'989'=>'14.78707','1019'=>'14.75453','1049'=>'14.72264','1080'=>'14.69142','1110'=>'14.66086','1141'=>'14.63096','1171'=>'14.60173',
				'1201'=>'14.57316','1232'=>'14.54527','1262'=>'14.51805','1293'=>'14.49151','1323'=>'14.46566','1354'=>'14.4405','1384'=>'14.41604','1414'=>'14.39229',
				'1445'=>'14.36926','1475'=>'14.34695','1506'=>'14.32537','1536'=>'14.30453','1566'=>'14.28444','1597'=>'14.2651','1627'=>'14.24651','1658'=>'14.22868',
				'1688'=>'14.21162','1719'=>'14.19532','1749'=>'14.17979','1779'=>'14.16503','1810'=>'14.15103','1840'=>'14.1378','1871'=>'14.12534','1901'=>'14.11363',
				'1931'=>'14.10268','1962'=>'14.09249','1992'=>'14.08305','2023'=>'14.07436','2053'=>'14.06642','2084'=>'14.05921','2114'=>'14.05274','2144'=>'14.04701','2175'=>'14.042',
				'2205'=>'14.03772','2236'=>'14.03417','2266'=>'14.03134','2296'=>'14.02922','2327'=>'14.02783','2357'=>'14.02714','2388'=>'14.02717','2418'=>'14.02791',
				'2449'=>'14.02935','2479'=>'14.0315','2509'=>'14.03435','2540'=>'14.03791','2570'=>'14.04216','2601'=>'14.04711','2631'=>'14.05276','2661'=>'14.0591',
				'2692'=>'14.06613','2722'=>'14.07386','2753'=>'14.08228','2783'=>'14.09138','2814'=>'14.10116','2844'=>'14.11163','2874'=>'14.12279','2905'=>'14.13462','2935'=>'14.14712',
				'2966'=>'14.1603','2996'=>'14.17416','3026'=>'14.18868','3057'=>'14.20387','3087'=>'14.21972','3118'=>'14.23624','3148'=>'14.25341','3179'=>'14.27124','3209'=>'14.28972',
				'3239'=>'14.30884','3270'=>'14.32862','3300'=>'14.34903','3331'=>'14.37008','3361'=>'14.39177','3391'=>'14.41409','3422'=>'14.43703','3452'=>'14.46059','3483'=>'14.48478',
				'3513'=>'14.50957','3544'=>'14.53498','3574'=>'14.56099','3604'=>'14.5876','3635'=>'14.61481','3665'=>'14.6426','3696'=>'14.67098','3726'=>'14.69994',
				'3756'=>'14.72948','3787'=>'14.75958','3817'=>'14.79025','3848'=>'14.82148','3878'=>'14.85326','3909'=>'14.88558','3939'=>'14.91845','3969'=>'14.95184',
				'4000'=>'14.98577','4030'=>'15.02022','4061'=>'15.05519','4091'=>'15.09066','4121'=>'15.12664','4152'=>'15.16311','4182'=>'15.20007','4213'=>'15.23751','4243'=>'15.27543',
				'4274'=>'15.31381','4304'=>'15.35265','4334'=>'15.39195','4365'=>'15.43169','4395'=>'15.47187','4426'=>'15.51248','4456'=>'15.5535','4486'=>'15.59495','4517'=>'15.6368',
				'4547'=>'15.67904','4578'=>'15.72168','4608'=>'15.7647','4639'=>'15.80809','4669'=>'15.85184','4699'=>'15.89595','4730'=>'15.94041','4760'=>'15.9852',
				'4791'=>'16.03032','4821'=>'16.07576','4851'=>'16.12151','4882'=>'16.16756','4912'=>'16.21391','4943'=>'16.26054','4973'=>'16.30743','5004'=>'16.3546',
				'5034'=>'16.40201','5064'=>'16.44967','5095'=>'16.49756','5125'=>'16.54568','5156'=>'16.594','5186'=>'16.64254','5216'=>'16.69126','5247'=>'16.74017','5277'=>'16.78924',
				'5308'=>'16.83848','5338'=>'16.88787','5369'=>'16.9374','5399'=>'16.98706','5429'=>'17.03683','5460'=>'17.08672','5490'=>'17.1367',
				'5521'=>'17.18676','5551'=>'17.23689','5581'=>'17.28709','5612'=>'17.33734','5642'=>'17.38763','5673'=>'17.43794','5703'=>'17.48827','5734'=>'17.53861',
				'5764'=>'17.58893','5794'=>'17.63924','5825'=>'17.68951','5855'=>'17.73974','5886'=>'17.78991','5916'=>'17.84001','5946'=>'17.89003',
				'5977'=>'17.93995','6007'=>'17.98977','6038'=>'18.03947','6068'=>'18.08904','6099'=>'18.13846','6129'=>'18.18773','6159'=>'18.23682',
				'6190'=>'18.28573','6220'=>'18.33444','6251'=>'18.38294','6281'=>'18.43121','6311'=>'18.47925','6342'=>'18.52703','6372'=>'18.57455',
				'6403'=>'18.62179','6433'=>'18.66873','6464'=>'18.71537','6494'=>'18.76168','6524'=>'18.80766','6555'=>'18.85328','6585'=>'18.89854',
				'6616'=>'18.94342','6646'=>'18.98791','6676'=>'19.03198','6707'=>'19.07563','6737'=>'19.11884','6768'=>'19.16159','6798'=>'19.20387',
				'6829'=>'19.24567','6859'=>'19.28696','6889'=>'19.32773','6920'=>'19.36797','6950'=>'19.40766','6981'=>'19.44678','7011'=>'19.48531',
				'7041'=>'19.52325','7072'=>'19.56057','7102'=>'19.59726','7133'=>'19.6333','7163'=>'19.66867','7194'=>'19.70335','7224'=>'19.73733','7254'=>'19.7706',
				'7285'=>'19.80312','7300'=>'19.8191','7315'=>'19.83489');
		$percentile25Array=array('730'=>'15.74164','745'=>'15.71963','776'=>'15.67634','806'=>'15.63403','836'=>'15.59268','867'=>'15.55226','897'=>'15.51275','928'=>'15.47414',
				'958'=>'15.43639','989'=>'15.39951','1019'=>'15.36345','1049'=>'15.32822','1080'=>'15.29379','1110'=>'15.26016','1141'=>'15.22731','1171'=>'15.19523','1201'=>'15.16392',
				'1232'=>'15.13337','1262'=>'15.10359','1293'=>'15.07458','1323'=>'15.04633','1354'=>'15.01886','1384'=>'14.99218','1414'=>'14.96629','1445'=>'14.9412','1475'=>'14.91694','1506'=>'14.89351',
				'1536'=>'14.87093','1566'=>'14.84921','1597'=>'14.82838','1627'=>'14.80844','1658'=>'14.78941','1688'=>'14.7713','1719'=>'14.75414','1749'=>'14.73792','1779'=>'14.72266',
				'1810'=>'14.70836','1840'=>'14.69504','1871'=>'14.68269','1901'=>'14.67133','1931'=>'14.66094','1962'=>'14.65154','1992'=>'14.64312','2023'=>'14.63567','2053'=>'14.6292','2084'=>'14.62369',
				'2114'=>'14.61914','2144'=>'14.61555','2175'=>'14.6129','2205'=>'14.6112','2236'=>'14.61042','2266'=>'14.61057','2296'=>'14.61163','2327'=>'14.61359','2357'=>'14.61645','2388'=>'14.6202','2418'=>'14.62483',
				'2449'=>'14.63032','2479'=>'14.63668','2509'=>'14.64389','2540'=>'14.65194','2570'=>'14.66082','2601'=>'14.67054','2631'=>'14.68107','2661'=>'14.69241','2692'=>'14.70455','2722'=>'14.71749','2753'=>'14.73121','2783'=>'14.74571',
				'2814'=>'14.76099','2844'=>'14.77703','2874'=>'14.79382','2905'=>'14.81136','2935'=>'14.82965','2966'=>'14.84867','2996'=>'14.86841','3026'=>'14.88888','3057'=>'14.91006',
				'3087'=>'14.93194','3118'=>'14.95453','3148'=>'14.9778','3179'=>'15.00176','3209'=>'15.0264','3239'=>'15.05172','3270'=>'15.07769','3300'=>'15.10433','3331'=>'15.13161','3361'=>'15.15954',
				'3391'=>'15.1881','3422'=>'15.2173','3452'=>'15.24712','3483'=>'15.27755','3513'=>'15.30859','3544'=>'15.34024','3574'=>'15.37248','3604'=>'15.40531','3635'=>'15.43872','3665'=>'15.4727','3696'=>'15.50725',
				'3726'=>'15.54236','3756'=>'15.57803','3787'=>'15.61424','3817'=>'15.65099','3848'=>'15.68826','3878'=>'15.72607','3909'=>'15.76439','3939'=>'15.80322','3969'=>'15.84255','4000'=>'15.88237','4030'=>'15.92268','4061'=>'15.96347',
				'4091'=>'16.00473','4121'=>'16.04646','4152'=>'16.08864','4182'=>'16.13127','4213'=>'16.17434','4243'=>'16.21784','4274'=>'16.26177','4304'=>'16.30612','4334'=>'16.35087','4365'=>'16.39603','4395'=>'16.44158','4426'=>'16.48751',
				'4456'=>'16.53382','4486'=>'16.5805','4517'=>'16.62754','4547'=>'16.67494','4578'=>'16.72267','4608'=>'16.77074','4639'=>'16.81914','4669'=>'16.86786','4699'=>'16.91689','4730'=>'16.96621','4760'=>'17.01583',
				'4791'=>'17.06574','4821'=>'17.11592','4851'=>'17.16636','4882'=>'17.21706','4912'=>'17.26801','4943'=>'17.3192','4973'=>'17.37062','5004'=>'17.42227','5034'=>'17.47412','5064'=>'17.52618','5095'=>'17.57843','5125'=>'17.63086',
				'5156'=>'17.68347','5186'=>'17.73624','5216'=>'17.78917','5247'=>'17.84225','5277'=>'17.89546','5308'=>'17.9488','5338'=>'18.00225','5369'=>'18.05581','5399'=>'18.10947','5429'=>'18.16322','5460'=>'18.21704','5490'=>'18.27093','5521'=>'18.32488',
				'5551'=>'18.37887','5581'=>'18.4329','5612'=>'18.48696','5642'=>'18.54102','5673'=>'18.5951','5703'=>'18.64916','5734'=>'18.70321','5764'=>'18.75723','5794'=>'18.81121','5825'=>'18.86514','5855'=>'18.919','5886'=>'18.97279','5916'=>'19.0265','5946'=>'19.08011',
				'5977'=>'19.13361','6007'=>'19.187','6038'=>'19.24025','6068'=>'19.29335','6099'=>'19.3463','6129'=>'19.39908','6159'=>'19.45168','6190'=>'19.50409','6220'=>'19.55629','6251'=>'19.60827','6281'=>'19.66002','6311'=>'19.71153','6342'=>'19.76278','6372'=>'19.81376',
				'6403'=>'19.86445','6433'=>'19.91485','6464'=>'19.96493','6494'=>'20.01469','6524'=>'20.06412','6555'=>'20.11319','6585'=>'20.1619','6616'=>'20.21022','6646'=>'20.25816','6676'=>'20.30569','6707'=>'20.35279','6737'=>'20.39947','6768'=>'20.44569','6798'=>'20.49145','6829'=>'20.53674','6859'=>'20.58153',
				'6889'=>'20.62582','6920'=>'20.66959','6950'=>'20.71283','6981'=>'20.75552','7011'=>'20.79766','7041'=>'20.83922','7072'=>'20.88019','7102'=>'20.92056','7133'=>'20.96032','7163'=>'20.99946',
				'7194'=>'21.03795','7224'=>'21.07579','7254'=>'21.11296','7285'=>'21.14946','7300'=>'21.16745','7315'=>'21.18526');
		$percentile50Array=array('730'=>'16.57503','745'=>'16.54777','776'=>'16.49443','806'=>'16.4426','836'=>'16.39224','867'=>'16.34334','897'=>'16.29584',
				'928'=>'16.24972','958'=>'16.20495','989'=>'16.1615','1019'=>'16.11933','1049'=>'16.07843','1080'=>'16.03876','1110'=>'16.0003','1141'=>'15.96304',
				'1171'=>'15.92695','1201'=>'15.89203','1232'=>'15.85824','1262'=>'15.82559','1293'=>'15.79406','1323'=>'15.76364','1354'=>'15.73434','1384'=>'15.70614',
				'1414'=>'15.67904','1445'=>'15.65305','1475'=>'15.62817','1506'=>'15.60441','1536'=>'15.58176','1566'=>'15.56025','1597'=>'15.53987','1627'=>'15.52065',
				'1658'=>'15.50258','1688'=>'15.48569','1719'=>'15.46998','1749'=>'15.45546','1779'=>'15.44214','1810'=>'15.43003','1840'=>'15.41914','1871'=>'15.40947',
				'1901'=>'15.40103','1931'=>'15.39382','1962'=>'15.38783','1992'=>'15.38307','2023'=>'15.37953','2053'=>'15.37721',
				'2084'=>'15.37609','2114'=>'15.37618','2144'=>'15.37745','2175'=>'15.37991','2205'=>'15.38353','2236'=>'15.38831','2266'=>'15.39423','2296'=>'15.40127',
				'2327'=>'15.40943','2357'=>'15.41869','2388'=>'15.42902','2418'=>'15.44042','2449'=>'15.45288','2479'=>'15.46636','2509'=>'15.48087','2540'=>'15.49637',
				'2570'=>'15.51287','2601'=>'15.53034','2631'=>'15.54876','2661'=>'15.56812','2692'=>'15.58841','2722'=>'15.60961','2753'=>'15.63171','2783'=>'15.65469',
				'2814'=>'15.67853','2844'=>'15.70323','2874'=>'15.72877','2905'=>'15.75513','2935'=>'15.78231','2966'=>'15.81029','2996'=>'15.83905','3026'=>'15.86858',
				'3057'=>'15.89888','3087'=>'15.92992','3118'=>'15.96169','3148'=>'15.99419','3179'=>'16.02741','3209'=>'16.06132','3239'=>'16.09591','3270'=>'16.13119',
				'3300'=>'16.16712','3331'=>'16.20371','3361'=>'16.24094','3391'=>'16.2788','3422'=>'16.31728','3452'=>'16.35637','3483'=>'16.39606','3513'=>'16.43633',
				'3544'=>'16.47718','3574'=>'16.5186','3604'=>'16.56057','3635'=>'16.60309','3665'=>'16.64614','3696'=>'16.68972','3726'=>'16.73381','3756'=>'16.7784',
				'3787'=>'16.8235','3817'=>'16.86907','3848'=>'16.91512','3878'=>'16.96164','3909'=>'17.00862','3939'=>'17.05604','3969'=>'17.1039','4000'=>'17.15218',
				'4030'=>'17.20089','4061'=>'17.25','4091'=>'17.29951','4121'=>'17.34942','4152'=>'17.3997','4182'=>'17.45036','4213'=>'17.50138','4243'=>'17.55276',
				'4274'=>'17.60448','4304'=>'17.65653','4334'=>'17.70892','4365'=>'17.76162','4395'=>'17.81463','4426'=>'17.86795','4456'=>'17.92155','4486'=>'17.97544',
				'4517'=>'18.02961','4547'=>'18.08404','4578'=>'18.13873','4608'=>'18.19367','4639'=>'18.24884','4669'=>'18.30426','4699'=>'18.35989','4730'=>'18.41574',
				'4760'=>'18.4718','4791'=>'18.52805','4821'=>'18.5845','4851'=>'18.64113','4882'=>'18.69793','4912'=>'18.75489','4943'=>'18.81202','4973'=>'18.86929',
				'5004'=>'18.9267','5034'=>'18.98424','5064'=>'19.04191','5095'=>'19.0997','5125'=>'19.15759','5156'=>'19.21558','5186'=>'19.27366','5216'=>'19.33182',
				'5247'=>'19.39006','5277'=>'19.44837','5308'=>'19.50673','5338'=>'19.56514','5369'=>'19.6236','5399'=>'19.68208','5429'=>'19.7406','5460'=>'19.79912',
				'5490'=>'19.85766','5521'=>'19.9162','5551'=>'19.97473','5581'=>'20.03324','5612'=>'20.09172','5642'=>'20.15017','5673'=>'20.20858','5703'=>'20.26694',
				'5734'=>'20.32524','5764'=>'20.38346','5794'=>'20.44162','5825'=>'20.49968','5855'=>'20.55765','5886'=>'20.61551','5916'=>'20.67326','5946'=>'20.73089',
				'5977'=>'20.78839','6007'=>'20.84574','6038'=>'20.90294','6068'=>'20.95999','6099'=>'21.01686','6129'=>'21.07356','6159'=>'21.13007','6190'=>'21.18638',
				'6220'=>'21.24248','6251'=>'21.29836','6281'=>'21.35402','6311'=>'21.40944','6342'=>'21.46461','6372'=>'21.51952','6403'=>'21.57417','6433'=>'21.62854',
				'6464'=>'21.68262','6494'=>'21.7364','6524'=>'21.78988','6555'=>'21.84304','6585'=>'21.89587','6616'=>'21.94836','6646'=>'22.00051','6676'=>'22.05229',
				'6707'=>'22.10371','6737'=>'22.15476','6768'=>'22.20541','6798'=>'22.25567','6829'=>'22.30553','6859'=>'22.35497','6889'=>'22.40399','6920'=>'22.45257',
				'6950'=>'22.50072','6981'=>'22.54841','7011'=>'22.59565','7041'=>'22.64243','7072'=>'22.68873','7102'=>'22.73456','7133'=>'22.7799','7163'=>'22.82474',
				'7194'=>'22.86909','7224'=>'22.91293','7254'=>'22.95626','7285'=>'22.99908','7300'=>'23.02029','7315'=>'23.04138');
		$percentile75Array=array('730'=>'17.55719','745'=>'17.52129','776'=>'17.45135','806'=>'17.38384','836'=>'17.31871','867'=>'17.25593','897'=>'17.19546','928'=>'17.13726',
				'958'=>'17.0813','989'=>'17.02753','1019'=>'16.97592','1049'=>'16.92645','1080'=>'16.87907','1110'=>'16.83376','1141'=>'16.79048','1171'=>'16.7492','1201'=>'16.70988',
				'1232'=>'16.67251','1262'=>'16.63704','1293'=>'16.60345','1323'=>'16.5717','1354'=>'16.54177','1384'=>'16.51364','1414'=>'16.48726','1445'=>'16.46262','1475'=>'16.4397',
				'1506'=>'16.41846','1536'=>'16.39889','1566'=>'16.38097','1597'=>'16.36468','1627'=>'16.35001','1658'=>'16.33693','1688'=>'16.32545','1719'=>'16.31554','1749'=>'16.3072',
				'1779'=>'16.30042','1810'=>'16.29518','1840'=>'16.29148','1871'=>'16.28932','1901'=>'16.28868','1931'=>'16.28955','1962'=>'16.29192','1992'=>'16.29578','2023'=>'16.30113',
				'2053'=>'16.30794','2084'=>'16.3162','2114'=>'16.3259','2144'=>'16.33702','2175'=>'16.34955','2205'=>'16.36346','2236'=>'16.37875','2266'=>'16.39537','2296'=>'16.41333',
				'2327'=>'16.4326','2357'=>'16.45315','2388'=>'16.47496','2418'=>'16.49801','2449'=>'16.52229','2479'=>'16.54776','2509'=>'16.5744','2540'=>'16.60219','2570'=>'16.63112',
				'2601'=>'16.66114','2631'=>'16.69225','2661'=>'16.72442','2692'=>'16.75763','2722'=>'16.79185','2753'=>'16.82707','2783'=>'16.86325','2814'=>'16.90039','2844'=>'16.93845',
				'2874'=>'16.97742','2905'=>'17.01727','2935'=>'17.05799','2966'=>'17.09955','2996'=>'17.14193','3026'=>'17.18512','3057'=>'17.22909','3087'=>'17.27383','3118'=>'17.31932',
				'3148'=>'17.36552','3179'=>'17.41244','3209'=>'17.46005','3239'=>'17.50833','3270'=>'17.55726','3300'=>'17.60683','3331'=>'17.65702','3361'=>'17.7078','3391'=>'17.75918',
				'3422'=>'17.81112','3452'=>'17.86361','3483'=>'17.91664','3513'=>'17.9702','3544'=>'18.02425','3574'=>'18.07879','3604'=>'18.13381','3635'=>'18.18929','3665'=>'18.24521',
				'3696'=>'18.30156','3726'=>'18.35833','3756'=>'18.4155','3787'=>'18.47306','3817'=>'18.53099','3848'=>'18.58928','3878'=>'18.64792','3909'=>'18.70689','3939'=>'18.76619',
				'3969'=>'18.82579','4000'=>'18.8857','4030'=>'18.94588','4061'=>'19.00634','4091'=>'19.06706','4121'=>'19.12803','4152'=>'19.18924','4182'=>'19.25067','4213'=>'19.31232',
				'4243'=>'19.37417','4274'=>'19.43622','4304'=>'19.49845','4334'=>'19.56086','4365'=>'19.62342','4395'=>'19.68614','4426'=>'19.74901','4456'=>'19.812','4486'=>'19.87512',
				'4517'=>'19.93836','4547'=>'20.0017','4578'=>'20.06514','4608'=>'20.12866','4639'=>'20.19227','4669'=>'20.25594','4699'=>'20.31968','4730'=>'20.38347','4760'=>'20.44731',
				'4791'=>'20.51119','4821'=>'20.5751','4851'=>'20.63903','4882'=>'20.70298','4912'=>'20.76694','4943'=>'20.8309','4973'=>'20.89486','5004'=>'20.9588','5034'=>'21.02272',
				'5064'=>'21.08663','5095'=>'21.15049','5125'=>'21.21433','5156'=>'21.27811','5186'=>'21.34185','5216'=>'21.40554','5247'=>'21.46916','5277'=>'21.53272','5308'=>'21.5962',
				'5338'=>'21.65961','5369'=>'21.72294','5399'=>'21.78618','5429'=>'21.84932','5460'=>'21.91237','5490'=>'21.97532','5521'=>'22.03816','5551'=>'22.10089','5581'=>'22.1635',
				'5612'=>'22.226','5642'=>'22.28837','5673'=>'22.35061','5703'=>'22.41272','5734'=>'22.47469','5764'=>'22.53652','5794'=>'22.59821','5825'=>'22.65976','5855'=>'22.72115',
				'5886'=>'22.78239','5916'=>'22.84346','5946'=>'22.90438','5977'=>'22.96514','6007'=>'23.02572','6038'=>'23.08614','6068'=>'23.14638','6099'=>'23.20645','6129'=>'23.26633',
				'6159'=>'23.32604','6190'=>'23.38556','6220'=>'23.4449','6251'=>'23.50404','6281'=>'23.563','6311'=>'23.62176','6342'=>'23.68033','6372'=>'23.7387','6403'=>'23.79687',
				'6433'=>'23.85484','6464'=>'23.91261','6494'=>'23.97018','6524'=>'24.02754','6555'=>'24.0847','6585'=>'24.14166','6616'=>'24.19841','6646'=>'24.25495','6676'=>'24.31129',
				'6707'=>'24.36742','6737'=>'24.42335','6768'=>'24.47907','6798'=>'24.53459','6829'=>'24.58991','6859'=>'24.64502','6889'=>'24.69994','6920'=>'24.75466','6950'=>'24.80919',
				'6981'=>'24.86352','7011'=>'24.91767','7041'=>'24.97163','7072'=>'25.02542','7102'=>'25.07902','7133'=>'25.13246','7163'=>'25.18572','7194'=>'25.23883','7224'=>'25.29179',
				'7254'=>'25.34459','7285'=>'25.39725','7300'=>'25.42353','7315'=>'25.44978');
		$percentile85Array=array('730'=>'18.16219','745'=>'18.11955','776'=>'18.03668','806'=>'17.957','836'=>'17.88047','867'=>'17.80704','897'=>'17.73667','928'=>'17.66932','958'=>'17.60495',
				'989'=>'17.54351','1019'=>'17.48496','1049'=>'17.42927','1080'=>'17.37639','1110'=>'17.32627','1141'=>'17.27889','1171'=>'17.23419','1201'=>'17.19213','1232'=>'17.15266','1262'=>'17.11575',
				'1293'=>'17.08135','1323'=>'17.04941','1354'=>'17.01988','1384'=>'16.99272','1414'=>'16.96789','1445'=>'16.94533','1475'=>'16.92501','1506'=>'16.90688','1536'=>'16.89089','1566'=>'16.87701',
				'1597'=>'16.86519','1627'=>'16.8554','1658'=>'16.8476','1688'=>'16.84176','1719'=>'16.83784','1749'=>'16.8358','1779'=>'16.83563','1810'=>'16.83729','1840'=>'16.84076','1871'=>'16.846','1901'=>'16.853',
				'1931'=>'16.86173','1962'=>'16.87217','1992'=>'16.88428','2023'=>'16.89805','2053'=>'16.91346','2084'=>'16.93048','2114'=>'16.94909','2144'=>'16.96925','2175'=>'16.99096','2205'=>'17.01418','2236'=>'17.03888',
				'2266'=>'17.06505','2296'=>'17.09265','2327'=>'17.12166','2357'=>'17.15206','2388'=>'17.1838','2418'=>'17.21688','2449'=>'17.25126','2479'=>'17.28691','2509'=>'17.3238','2540'=>'17.36192','2570'=>'17.40122',
				'2601'=>'17.44168','2631'=>'17.48329','2661'=>'17.52599','2692'=>'17.56978','2722'=>'17.61462','2753'=>'17.66049','2783'=>'17.70736','2814'=>'17.7552','2844'=>'17.80398','2874'=>'17.85369','2905'=>'17.90429',
				'2935'=>'17.95575','2966'=>'18.00807','2996'=>'18.0612','3026'=>'18.11512','3057'=>'18.16981','3087'=>'18.22525','3118'=>'18.28141','3148'=>'18.33827','3179'=>'18.3958','3209'=>'18.45398','3239'=>'18.5128',
				'3270'=>'18.57222','3300'=>'18.63222','3331'=>'18.69279','3361'=>'18.7539','3391'=>'18.81554','3422'=>'18.87767','3452'=>'18.94028','3483'=>'19.00336','3513'=>'19.06688','3544'=>'19.13081','3574'=>'19.19516',
				'3604'=>'19.25988','3635'=>'19.32497','3665'=>'19.39041','3696'=>'19.45618','3726'=>'19.52226','3756'=>'19.58864','3787'=>'19.6553','3817'=>'19.72222','3848'=>'19.78938','3878'=>'19.85678','3909'=>'19.92439',
				'3939'=>'19.9922','3969'=>'20.06019','4000'=>'20.12835','4030'=>'20.19667','4061'=>'20.26514','4091'=>'20.33373','4121'=>'20.40243','4152'=>'20.47124','4182'=>'20.54013','4213'=>'20.6091','4243'=>'20.67814',
				'4274'=>'20.74722','4304'=>'20.81635','4334'=>'20.88551','4365'=>'20.95468','4395'=>'21.02386','4426'=>'21.09304','4456'=>'21.1622','4486'=>'21.23134','4517'=>'21.30045','4547'=>'21.36951','4578'=>'21.43852',
				'4608'=>'21.50748','4639'=>'21.57636','4669'=>'21.64517','4699'=>'21.71389','4730'=>'21.78252','4760'=>'21.85104','4791'=>'21.91946','4821'=>'21.98777','4851'=>'22.05596','4882'=>'22.12402','4912'=>'22.19194',
				'4943'=>'22.25973','4973'=>'22.32737','5004'=>'22.39487','5034'=>'22.46221','5064'=>'22.52939','5095'=>'22.5964','5125'=>'22.66325','5156'=>'22.72993','5186'=>'22.79643','5216'=>'22.86275','5247'=>'22.92889',
				'5277'=>'22.99485','5308'=>'23.06062','5338'=>'23.12619','5369'=>'23.19158','5399'=>'23.25677','5429'=>'23.32177','5460'=>'23.38657','5490'=>'23.45117','5521'=>'23.51557','5551'=>'23.57978','5581'=>'23.64378',
				'5612'=>'23.70758','5642'=>'23.77119','5673'=>'23.83459','5703'=>'23.89779','5734'=>'23.9608','5764'=>'24.02361','5794'=>'24.08622','5825'=>'24.14864','5855'=>'24.21087','5886'=>'24.27291','5916'=>'24.33476',
				'5946'=>'24.39642','5977'=>'24.4579','6007'=>'24.5192','6038'=>'24.58033','6068'=>'24.64128','6099'=>'24.70207','6129'=>'24.76269','6159'=>'24.82315','6190'=>'24.88346','6220'=>'24.94362','6251'=>'25.00363',
				'6281'=>'25.0635','6311'=>'25.12324','6342'=>'25.18286','6372'=>'25.24235','6403'=>'25.30173','6433'=>'25.361','6464'=>'25.42017','6494'=>'25.47925','6524'=>'25.53824','6555'=>'25.59716','6585'=>'25.65601',
				'6616'=>'25.71481','6646'=>'25.77355','6676'=>'25.83225','6707'=>'25.89093','6737'=>'25.94958','6768'=>'26.00823','6798'=>'26.06687','6829'=>'26.12553','6859'=>'26.18422','6889'=>'26.24294','6920'=>'26.30171',
				'6950'=>'26.36054','6981'=>'26.41945','7011'=>'26.47844','7041'=>'26.53753','7072'=>'26.59675','7102'=>'26.65609','7133'=>'26.71558','7163'=>'26.77522','7194'=>'26.83505','7224'=>'26.89507','7254'=>'26.9553',
				'7285'=>'27.01575','7300'=>'27.04607','7315'=>'27.07645');
		$percentile90Array=array('730'=>'18.60948','745'=>'18.56111','776'=>'18.4673','806'=>'18.37736','836'=>'18.29125','867'=>'18.20892','897'=>'18.13031','928'=>'18.05538','958'=>'17.98408',
				'989'=>'17.91635','1019'=>'17.85215','1049'=>'17.79143','1080'=>'17.73414','1110'=>'17.68022','1141'=>'17.62963','1171'=>'17.58231','1201'=>'17.5382','1232'=>'17.49725','1262'=>'17.45941','1293'=>'17.42462',
				'1323'=>'17.39282','1354'=>'17.36395','1384'=>'17.33795','1414'=>'17.31477','1445'=>'17.29434','1475'=>'17.27661','1506'=>'17.26151','1536'=>'17.24899','1566'=>'17.23899','1597'=>'17.23145','1627'=>'17.22632',
				'1658'=>'17.22354','1688'=>'17.22306','1719'=>'17.22483','1749'=>'17.2288','1779'=>'17.23493','1810'=>'17.24315','1840'=>'17.25344','1871'=>'17.26575','1901'=>'17.28003','1931'=>'17.29625','1962'=>'17.31437',
				'1992'=>'17.33435','2023'=>'17.35616','2053'=>'17.37975','2084'=>'17.4051','2114'=>'17.43217','2144'=>'17.46092','2175'=>'17.49133','2205'=>'17.52335','2236'=>'17.55696','2266'=>'17.59212','2296'=>'17.6288',
				'2327'=>'17.66696','2357'=>'17.70658','2388'=>'17.74762','2418'=>'17.79004','2449'=>'17.83382','2479'=>'17.87892','2509'=>'17.92532','2540'=>'17.97296','2570'=>'18.02183','2601'=>'18.0719','2631'=>'18.12312',
				'2661'=>'18.17548','2692'=>'18.22893','2722'=>'18.28344','2753'=>'18.33899','2783'=>'18.39554','2814'=>'18.45306','2844'=>'18.51152','2874'=>'18.57089','2905'=>'18.63115','2935'=>'18.69225','2966'=>'18.75418',
				'2996'=>'18.8169','3026'=>'18.88038','3057'=>'18.94459','3087'=>'19.00952','3118'=>'19.07512','3148'=>'19.14137','3179'=>'19.20825','3209'=>'19.27573','3239'=>'19.34378','3270'=>'19.41238','3300'=>'19.48149',
				'3331'=>'19.5511','3361'=>'19.62118','3391'=>'19.69171','3422'=>'19.76266','3452'=>'19.83401','3483'=>'19.90573','3513'=>'19.97781','3544'=>'20.05021','3574'=>'20.12292','3604'=>'20.19592','3635'=>'20.26919',
				'3665'=>'20.3427','3696'=>'20.41643','3726'=>'20.49036','3756'=>'20.56448','3787'=>'20.63877','3817'=>'20.7132','3848'=>'20.78775','3878'=>'20.86242','3909'=>'20.93718','3939'=>'21.01201','3969'=>'21.0869',
				'4000'=>'21.16183','4030'=>'21.23679','4061'=>'21.31175','4091'=>'21.38671','4121'=>'21.46165','4152'=>'21.53655','4182'=>'21.61141','4213'=>'21.6862','4243'=>'21.76091','4274'=>'21.83554','4304'=>'21.91006',
				'4334'=>'21.98447','4365'=>'22.05876','4395'=>'22.1329','4426'=>'22.2069','4456'=>'22.28075','4486'=>'22.35442','4517'=>'22.42791','4547'=>'22.50122','4578'=>'22.57433','4608'=>'22.64724','4639'=>'22.71993',
				'4669'=>'22.7924','4699'=>'22.86465','4730'=>'22.93666','4760'=>'23.00842','4791'=>'23.07994','4821'=>'23.15121','4851'=>'23.22221','4882'=>'23.29295','4912'=>'23.36342','4943'=>'23.43362','4973'=>'23.50354',
				'5004'=>'23.57318','5034'=>'23.64253','5064'=>'23.7116','5095'=>'23.78038','5125'=>'23.84887','5156'=>'23.91706','5186'=>'23.98496','5216'=>'24.05257','5247'=>'24.11987','5277'=>'24.18689','5308'=>'24.25361',
				'5338'=>'24.32003','5369'=>'24.38616','5399'=>'24.452','5429'=>'24.51755','5460'=>'24.58281','5490'=>'24.64778','5521'=>'24.71247','5551'=>'24.77688','5581'=>'24.84102','5612'=>'24.90489','5642'=>'24.96848',
				'5673'=>'25.03182','5703'=>'25.0949','5734'=>'25.15773','5764'=>'25.22032','5794'=>'25.28267','5825'=>'25.34478','5855'=>'25.40668','5886'=>'25.46835','5916'=>'25.52982','5946'=>'25.59109','5977'=>'25.65217',
				'6007'=>'25.71306','6038'=>'25.77379','6068'=>'25.83436','6099'=>'25.89477','6129'=>'25.95504','6159'=>'26.01519','6190'=>'26.07522','6220'=>'26.13515','6251'=>'26.19498','6281'=>'26.25474','6311'=>'26.31443',
				'6342'=>'26.37407','6372'=>'26.43368','6403'=>'26.49326','6433'=>'26.55284','6464'=>'26.61243','6494'=>'26.67204','6524'=>'26.73169','6555'=>'26.79141','6585'=>'26.8512','6616'=>'26.91109','6646'=>'26.97108',
				'6676'=>'27.03121','6707'=>'27.09149','6737'=>'27.15194','6768'=>'27.21259','6798'=>'27.27344','6829'=>'27.33452','6859'=>'27.39585','6889'=>'27.45746','6920'=>'27.51936','6950'=>'27.58159','6981'=>'27.64415',
				'7011'=>'27.70707','7041'=>'27.77039','7072'=>'27.83411','7102'=>'27.89828','7133'=>'27.9629','7163'=>'28.02801','7194'=>'28.09363','7224'=>'28.15978','7254'=>'28.2265','7285'=>'28.29381','7300'=>'28.3277',
				'7315'=>'28.36174');
		$percentile95Array=array('730'=>'19.33801','745'=>'19.2789','776'=>'19.16466','806'=>'19.05567','836'=>'18.95187','867'=>'18.85317','897'=>'18.75949','928'=>'18.67078','958'=>'18.58695','989'=>'18.50792','1019'=>'18.43363',
				'1049'=>'18.364','1080'=>'18.29895','1110'=>'18.23842','1141'=>'18.18231','1171'=>'18.13057','1201'=>'18.08311','1232'=>'18.03986','1262'=>'18.00074','1293'=>'17.96568','1323'=>'17.93459','1354'=>'17.90741','1384'=>'17.88405',
				'1414'=>'17.86444','1445'=>'17.8485','1475'=>'17.83614','1506'=>'17.8273','1536'=>'17.82189','1566'=>'17.81983','1597'=>'17.82104','1627'=>'17.82544','1658'=>'17.83295','1688'=>'17.84349','1719'=>'17.85699','1749'=>'17.87335','1779'=>'17.89252',
				'1810'=>'17.9144','1840'=>'17.93893','1871'=>'17.96602','1901'=>'17.99562','1931'=>'18.02764','1962'=>'18.06201','1992'=>'18.09868','2023'=>'18.13758','2053'=>'18.17863','2084'=>'18.22179','2114'=>'18.26698','2144'=>'18.31416','2175'=>'18.36325',
				'2205'=>'18.41421','2236'=>'18.46699','2266'=>'18.52152','2296'=>'18.57775','2327'=>'18.63564','2357'=>'18.69513','2388'=>'18.75617','2418'=>'18.81872','2449'=>'18.88272','2479'=>'18.94814','2509'=>'19.01491','2540'=>'19.083','2570'=>'19.15236',
				'2601'=>'19.22295','2631'=>'19.29471','2661'=>'19.36761','2692'=>'19.44161','2722'=>'19.51666','2753'=>'19.59272','2783'=>'19.66974','2814'=>'19.74769','2844'=>'19.82652','2874'=>'19.9062','2905'=>'19.98668','2935'=>'20.06793','2966'=>'20.1499',
				'2996'=>'20.23256','3026'=>'20.31587','3057'=>'20.39979','3087'=>'20.48429','3118'=>'20.56933','3148'=>'20.65487','3179'=>'20.74089','3209'=>'20.82733','3239'=>'20.91417','3270'=>'21.00138','3300'=>'21.08893','3331'=>'21.17677','3361'=>'21.26488',
				'3391'=>'21.35323','3422'=>'21.44178','3452'=>'21.53051','3483'=>'21.61938','3513'=>'21.70837','3544'=>'21.79745','3574'=>'21.88659','3604'=>'21.97576','3635'=>'22.06494','3665'=>'22.15409','3696'=>'22.2432','3726'=>'22.33224','3756'=>'22.42118',
				'3787'=>'22.51','3817'=>'22.59868','3848'=>'22.68719','3878'=>'22.77551','3909'=>'22.86363','3939'=>'22.95151','3969'=>'23.03915','4000'=>'23.12651','4030'=>'23.21358','4061'=>'23.30035','4091'=>'23.38679','4121'=>'23.47289','4152'=>'23.55863',
				'4182'=>'23.644','4213'=>'23.72897','4243'=>'23.81354','4274'=>'23.89769','4304'=>'23.98141','4334'=>'24.06469','4365'=>'24.1475','4395'=>'24.22985','4426'=>'24.31172','4456'=>'24.3931','4486'=>'24.47397','4517'=>'24.55434','4547'=>'24.6342',
				'4578'=>'24.71352','4608'=>'24.79232 ','4639'=>'24.87058','4669'=>'24.94829','4699'=>'25.02545','4730'=>'25.10206','4760'=>'25.17811','4791'=>'25.2536','4821'=>'25.32853','4851'=>'25.40289','4882'=>'25.47668','4912'=>'25.5499','4943'=>'25.62256',
				'4973'=>'25.69464','5004'=>'25.76616','5034'=>'25.83712','5064'=>'25.90751','5095'=>'25.97734','5125'=>'26.04662','5156'=>'26.11535','5186'=>'26.18353','5216'=>'26.25117','5247'=>'26.31828','5277'=>'26.38485','5308'=>'26.45091','5338'=>'26.51646',
				'5369'=>'26.58151','5399'=>'26.64606','5429'=>'26.71014','5460'=>'26.77374','5490'=>'26.83688','5521'=>'26.89958','5551'=>'26.96184','5581'=>'27.02368','5612'=>'27.08511','5642'=>'27.14616','5673'=>'27.20683','5703'=>'27.26714','5734'=>'27.3271',
				'5764'=>'27.38675','5794'=>'27.44609','5825'=>'27.50514','5855'=>'27.56393','5886'=>'27.62247','5916'=>'27.68078','5946'=>'27.7389','5977'=>'27.79683','6007'=>'27.85461','6038'=>'27.91225','6068'=>'27.96979','6099'=>'28.02724','6129'=>'28.08464',
				'6159'=>'28.142','6190'=>'28.19937','6220'=>'28.25676','6251'=>'28.3142','6281'=>'28.37173','6311'=>'28.42937','6342'=>'28.48716','6372'=>'28.54513','6403'=>'28.6033','6433'=>'28.66171','6464'=>'28.72041','6494'=>'28.77941','6524'=>'28.83875',
				'6555'=>'28.89848','6585'=>'28.95862','6616'=>'29.01921','6646'=>'29.0803','6676'=>'29.14191','6707'=>'29.20409','6737'=>'29.26687','6768'=>'29.3303','6798'=>'29.39442','6829'=>'29.45926','6859'=>'29.52487','6889'=>'29.5913','6920'=>'29.65857',
				'6950'=>'29.72674','6981'=>'29.79585','7011'=>'29.86595','7041'=>'29.93707','7072'=>'30.00927','7102'=>'30.08258','7133'=>'30.15706','7163'=>'30.23276','7194'=>'30.30971','7224'=>'30.38797','7254'=>'30.46758','7285'=>'30.54859','7300'=>'30.58964',
				'7315'=>'30.63106');
		$percentile97Array=array('730'=>'19.85986','745'=>'19.79194','776'=>'19.66102','806'=>'19.53658','836'=>'19.41849','867'=>'19.30665','897'=>'19.20097','928'=>'19.10132','958'=>'19.00761','989'=>'18.91973','1019'=>'18.83758','1049'=>'18.76106','1080'=>'18.69006',
				'1110'=>'18.62449','1141'=>'18.56425','1171'=>'18.50924','1201'=>'18.45938','1232'=>'18.41456','1262'=>'18.37469','1293'=>'18.33969','1323'=>'18.30947','1354'=>'18.28393','1384'=>'18.263','1414'=>'18.24658','1445'=>'18.23459','1475'=>'18.22694','1506'=>'18.22354',
				'1536'=>'18.22431','1566'=>'18.22915','1597'=>'18.23799','1627'=>'18.25071','1658'=>'18.26725','1688'=>'18.2875','1719'=>'18.31136','1749'=>'18.33875','1779'=>'18.36957','1810'=>'18.40373','1840'=>'18.44112','1871'=>'18.48166','1901'=>'18.52525',
				'1931'=>'18.57179','1962'=>'18.6212','1992'=>'18.67337','2023'=>'18.72823','2053'=>'18.78569','2084'=>'18.84564','2114'=>'18.90802','2144'=>'18.97273','2175'=>'19.03969','2205'=>'19.10882','2236'=>'19.18005','2266'=>'19.25329',
				'2296'=>'19.32847','2327'=>'19.40551','2357'=>'19.48434','2388'=>'19.5649','2418'=>'19.6471','2449'=>'19.73089','2479'=>'19.81619','2509'=>'19.90294','2540'=>'19.99107','2570'=>'20.08052','2601'=>'20.17123','2631'=>'20.26314',
				'2661'=>'20.35618','2692'=>'20.45031','2722'=>'20.54545','2753'=>'20.64155','2783'=>'20.73856','2814'=>'20.83643','2844'=>'20.93509','2874'=>'21.03449','2905'=>'21.13459','2935'=>'21.23532','2966'=>'21.33665','2996'=>'21.43852',
				'3026'=>'21.54088','3057'=>'21.64368','3087'=>'21.74689','3118'=>'21.85044','3148'=>'21.9543','3179'=>'22.05842','3209'=>'22.16276','3239'=>'22.26727','3270'=>'22.37192','3300'=>'22.47666','3331'=>'22.58145','3361'=>'22.68625',
				'3391'=>'22.79103','3422'=>'22.89575','3452'=>'23.00036','3483'=>'23.10484','3513'=>'23.20915','3544'=>'23.31326','3574'=>'23.41712','3604'=>'23.52071','3635'=>'23.624','3665'=>'23.72696','3696'=>'23.82955','3726'=>'23.93175',
				'3756'=>'24.03353','3787'=>'24.13486','3817'=>'24.23571','3848'=>'24.33606','3878'=>'24.43589','3909'=>'24.53516','3939'=>'24.63386','3969'=>'24.73197','4000'=>'24.82945','4030'=>'24.9263','4061'=>'25.02249','4091'=>'25.11801',
				'4121'=>'25.21283','4152'=>'25.30693','4182'=>'25.40031','4213'=>'25.49294','4243'=>'25.58481','4274'=>'25.67591','4304'=>'25.76623','4334'=>'25.85575','4365'=>'25.94446','4395'=>'26.03234','4426'=>'26.11941','4456'=>'26.20563',
				'4486'=>'26.29101','4517'=>'26.37553','4547'=>'26.4592','4578'=>'26.54201','4608'=>'26.62395','4639'=>'26.70501','4669'=>'26.78521','4699'=>'26.86453','4730'=>'26.94297','4760'=>'27.02054','4791'=>'27.09724','4821'=>'27.17307',
				'4851'=>'27.24802','4882'=>'27.32211','4912'=>'27.39534','4943'=>'27.46771','4973'=>'27.53924','5004'=>'27.60992','5034'=>'27.67977','5064'=>'27.74879','5095'=>'27.817','5125'=>'27.88441','5156'=>'27.95102','5186'=>'28.01686',
				'5216'=>'28.08193','5247'=>'28.14624','5277'=>'28.20983','5308'=>'28.27269','5338'=>'28.33484','5369'=>'28.39632','5399'=>'28.45712','5429'=>'28.51728','5460'=>'28.57682','5490'=>'28.63575','5521'=>'28.6941','5551'=>'28.75189',
				'5581'=>'28.80915','5612'=>'28.8659','5642'=>'28.92217','5673'=>'28.97798','5703'=>'29.03337','5734'=>'29.08835','5764'=>'29.14297','5794'=>'29.19725','5825'=>'29.25123','5855'=>'29.30493','5886'=>'29.35838','5916'=>'29.41164',
				'5946'=>'29.46472','5977'=>'29.51767','6007'=>'29.57051','6038'=>'29.6233','6068'=>'29.67606','6099'=>'29.72885','6129'=>'29.78169','6159'=>'29.83463','6190'=>'29.88771','6220'=>'29.94097','6251'=>'29.99447','6281'=>'30.04824',
				'6311'=>'30.10232','6342'=>'30.15677','6372'=>'30.21164','6403'=>'30.26696','6433'=>'30.3228','6464'=>'30.3792','6494'=>'30.4362','6524'=>'30.49387','6555'=>'30.55225','6585'=>'30.6114','6616'=>'30.67137','6646'=>'30.73222',
				'6676'=>'30.794','6707'=>'30.85677','6737'=>'30.92058','6768'=>'30.9855','6798'=>'31.05158','6829'=>'31.11888','6859'=>'31.18746','6889'=>'31.25739','6920'=>'31.32872','6950'=>'31.40152','6981'=>'31.47585','7011'=>'31.55178',
				'7041'=>'31.62937','7072'=>'31.70868','7102'=>'31.78979','7133'=>'31.87275','7163'=>'31.95764','7194'=>'32.04453','7224'=>'32.13348','7254'=>'32.22457','7285'=>'32.31787','7300'=>'32.36537','7315'=>'32.41344');
		// end of array
		$this->set(compact('percentile3Array','percentile5Array','percentile10Array','percentile25Array','percentile50Array','percentile75Array','percentile85Array','percentile90Array','percentile95Array','percentile97Array'));
		$this->set('j',$j);
		$this->set('diagnosis',$diagnosis);
		$this->set('bmi_array',$bmi_Day);
		$this->set(compact('year','month','date','patient_name'));
		$this->set('patient', $patient);

	}

	//end of bmi chart male
	//BMI chart for female age 2 to 20 years
	function bmi_chart_female($id=null) {
			
		$this->layout=false;
		$this->set('title_for_layout', __('Growth Chart', true));
		$this->uses = array('Patient','BmiResult','ReviewPatientDetail');
		//Getting BMI for OPD patient
		$this->Patient->bindModel( array(
				'belongsTo' => array(
						'BmiResult'=>array('conditions'=>array('BmiResult.patient_id=Patient.id'),'foreignKey'=>false),
						'Person'=>array('conditions'=>array('Person.id=Patient.person_id'),'foreignKey'=>false)
				)
		));


		$diagnosis = $this->Patient->find('all',array('fields'=>array('BmiResult.height,BmiResult.weight,BmiResult.bmi,BmiResult.patient_id,BmiResult.created_time,
				Patient.age,Patient.admission_type,Person.sex,Person.dob,Patient.lookup_name'),'conditions'=>array('Patient.person_id'=>$id,'Patient.is_deleted'=>0,'Patient.admission_type'=>'OPD'),'order' => array('Patient.id' => 'asc')));
			
		foreach($diagnosis as $data)
		{
			$var=$this->DateFormat->dateDiff($data['Person']['dob'],$data['BmiResult']['created_time']);
			$day=$var->days;
			$year[$day]=$var->y;
			$month[$day]=$var->m;
			$patient_name=$data['Patient']['lookup_name'];
			$date[$day]=$data['BmiResult']['created_time'];
			$bmi_Day[$day][]=$data['BmiResult']['bmi'];
		}

		//Getting BMI for IPD Patient
		$this->Patient->bindModel(array(
				'belongsTo'=>array(
						'ReviewPatientDetail'=>array('conditions'=>array('ReviewPatientDetail.patient_id=Patient.id'),'foreignKey'=>false),
						'ReviewSubCategoriesOption'=>array(
								'conditions'=>array('ReviewSubCategoriesOption.name LIKE'=>"%".Configure::read('interactive_bmi')."%"),'foreignKey'=>false),
						'Person'=>array('conditions'=>array('Person.id=Patient.person_id'),'foreignKey'=>false)
				)));
			
		$diagnosis1 = $this->Patient->find('all',array('fields'=>array('ReviewPatientDetail.values,ReviewPatientDetail.date,
				Patient.age,Patient.admission_type,Person.sex,Person.dob,Patient.lookup_name,ReviewSubCategoriesOption.id'),
				'conditions'=>array('Patient.person_id'=>$id,'ReviewSubCategoriesOption.id=ReviewPatientDetail.review_sub_categories_options_id','Patient.is_deleted'=>0,'ReviewPatientDetail.edited_on IS NULL','Patient.admission_type'=>'IPD'),'order' => array('Patient.id' => 'asc')));
			
		foreach($diagnosis1 as $data)
		{
			$var=$this->DateFormat->dateDiff($data['Person']['dob'],$data['ReviewPatientDetail']['date']);
			$day=$var->days;
			$year[$day]=$var->y;
			$date[$day]=$data['ReviewPatientDetail']['date'];
			$patient_name=$data['Patient']['lookup_name'];
			$month[$day]=$var->m;
			$bmi_Day[$day][]=$data['ReviewPatientDetail']['values'];
		}
			
		//array for setting the  percentiles standard dataLines
		$percentile3Array=array('730'=>'14.14735','745'=>'14.13226','776'=>'14.10241','806'=>'14.07297','836'=>'14.04396','867'=>'14.01538','897'=>'13.98723','928'=>'13.9595','958'=>'13.93221',
				'989'=>'13.90536','1019'=>'13.87893','1049'=>'13.85295','1080'=>'13.82741','1110'=>'13.8023','1141'=>'13.77763','1171'=>'13.75341','1201'=>'13.72964','1232'=>'13.70631','1262'=>'13.68343','1293'=>'13.66101',
				'1323'=>'13.63905','1354'=>'13.61756','1384'=>'13.59654','1414'=>'13.57599','1445'=>'13.55592','1475'=>'13.53635','1506'=>'13.51728','1536'=>'13.4987','1566'=>'13.48065','1597'=>'13.46311',
				'1627'=>'13.4461','1658'=>'13.42963','1688'=>'13.4137','1719'=>'13.39833','1749'=>'13.38352','1779'=>'13.36927','1810'=>'13.35561','1840'=>'13.34252','1871'=>'13.33003','1901'=>'13.31814',
				'1931'=>'13.30685','1962'=>'13.29618','1992'=>'13.28612','2023'=>'13.27668','2053'=>'13.26788','2084'=>'13.2597','2114'=>'13.25217','2144'=>'13.24528','2175'=>'13.23904','2205'=>'13.23345','2236'=>'13.22851',
				'2266'=>'13.22423','2296'=>'13.22062','2327'=>'13.21766','2357'=>'13.21538','2388'=>'13.21376','2418'=>'13.21281','2449'=>'13.21253','2479'=>'13.21293','2509'=>'13.214','2540'=>'13.21574',
				'2570'=>'13.21816','2601'=>'13.22125','2631'=>'13.22502','2661'=>'13.22946','2692'=>'13.23458','2722'=>'13.24037','2753'=>'13.24683','2783'=>'13.25397','2814'=>'13.26177','2844'=>'13.27025',
				'2874'=>'13.27939','2905'=>'13.28919','2935'=>'13.29966','2966'=>'13.31079','2996'=>'13.32257','3026'=>'13.33502','3057'=>'13.34811','3087'=>'13.36185','3118'=>'13.37624','3148'=>'13.39126','3179'=>'13.40693',
				'3209'=>'13.42323','3239'=>'13.44016','3270'=>'13.45772','3300'=>'13.4759','3331'=>'13.4947','3361'=>'13.51411','3391'=>'13.53412','3422'=>'13.55474','3452'=>'13.57596','3483'=>'13.59777','3513'=>'13.62017',
				'3544'=>'13.64315','3574'=>'13.6667','3604'=>'13.69082','3635'=>'13.7155','3665'=>'13.74074','3696'=>'13.76653','3726'=>'13.79287','3756'=>'13.81974','3787'=>'13.84714','3817'=>'13.87506','3848'=>'13.9035',
				'3878'=>'13.93244','3909'=>'13.96188','3939'=>'13.99182','3969'=>'14.02224','4000'=>'14.05314','4030'=>'14.0845','4061'=>'14.11633','4091'=>'14.1486','4121'=>'14.18132','4152'=>'14.21447','4182'=>'14.24805','4213'=>'14.28204',
				'4243'=>'14.31643','4274'=>'14.35122','4304'=>'14.3864','4334'=>'14.42195','4365'=>'14.45788','4395'=>'14.49415','4426'=>'14.53078','4456'=>'14.56773','4486'=>'14.60502',
				'4517'=>'14.64262','4547'=>'14.68052','4578'=>'14.71871','4608'=>'14.75718','4639'=>'14.79592','4669'=>'14.83492','4699'=>'14.87417','4730'=>'14.91365','4760'=>'14.95335',
				'4791'=>'14.99326','4821'=>'15.03336','4851'=>'15.07365','4882'=>'15.11411','4912'=>'15.15473','4943'=>'15.19549','4973'=>'15.23639','5004'=>'15.2774','5034'=>'15.31852',
				'5064'=>'15.35972','5095'=>'15.40101','5125'=>'15.44235','5156'=>'15.48374','5186'=>'15.52517','5216'=>'15.56661','5247'=>'15.60805',
				'5277'=>'15.64949','5308'=>'15.69089','5338'=>'15.73225','5369'=>'15.77356','5399'=>'15.81478','5429'=>'15.85592','5460'=>'15.89695','5490'=>'15.93785','5521'=>'15.97862',
				'5551'=>'16.01923','5581'=>'16.05966','5612'=>'16.0999','5642'=>'16.13993','5673'=>'16.17973','5703'=>'16.21929','5734'=>'16.25859','5764'=>'16.2976','5794'=>'16.33631',
				'5825'=>'16.37471','5855'=>'16.41277','5886'=>'16.45047','5916'=>'16.4878','5946'=>'16.52473','5977'=>'16.56124','6007'=>'16.59733','6038'=>'16.63295','6068'=>'16.66811',
				'6099'=>'16.70276','6129'=>'16.7369','6159'=>'16.77051','6190'=>'16.80356','6220'=>'16.83603','6251'=>'16.8679','6281'=>'16.89915','6311'=>'16.92975','6342'=>'16.95969','6372'=>'16.98894',
				'6403'=>'17.01749','6433'=>'17.0453','6464'=>'17.07236','6494'=>'17.09864','6524'=>'17.12413','6555'=>'17.14879','6585'=>'17.1726','6616'=>'17.19555','6646'=>'17.2176','6676'=>'17.23874',
				'6707'=>'17.25894','6737'=>'17.27818','6768'=>'17.29643','6798'=>'17.31367','6829'=>'17.32987','6859'=>'17.34501','6889'=>'17.35907','6920'=>'17.37203','6950'=>'17.38385',
				'6981'=>'17.39451','7011'=>'17.40399','7041'=>'17.41226','7072'=>'17.4193','7102'=>'17.42508','7133'=>'17.42958','7163'=>'17.43278','7194'=>'17.43465',
				'7224'=>'17.43515','7254'=>'17.43427','7285'=>'17.43199','7300'=>'17.43031','7315'=>'17.42827');
		$percentile5Array=array('730'=>'14.39787','745'=>'14.38019','776'=>'14.34527','806'=>'14.31097','836'=>'14.27728','867'=>'14.2442','897'=>'14.21175','928'=>'14.17992','958'=>'14.14871','989'=>'14.11813',
				'1019'=>'14.08818','1049'=>'14.05885','1080'=>'14.03016','1110'=>'14.00209','1141'=>'13.97466','1171'=>'13.94786','1201'=>'13.92169','1232'=>'13.89615','1262'=>'13.87124','1293'=>'13.84697',
				'1323'=>'13.82333','1354'=>'13.80033','1384'=>'13.77796','1414'=>'13.75624','1445'=>'13.73516','1475'=>'13.71472','1506'=>'13.69493','1536'=>'13.67579','1566'=>'13.65731','1597'=>'13.63948',
				'1627'=>'13.62231','1658'=>'13.6058','1688'=>'13.58997','1719'=>'13.5748','1749'=>'13.56031','1779'=>'13.54649','1810'=>'13.53336','1840'=>'13.52091','1871'=>'13.50915','1901'=>'13.49808','1931'=>'13.4877',
				'1962'=>'13.47802','1992'=>'13.46903','2023'=>'13.46075','2053'=>'13.45317','2084'=>'13.4463','2114'=>'13.44013','2144'=>'13.43467','2175'=>'13.42991','2205'=>'13.42587','2236'=>'13.42254',
				'2266'=>'13.41992','2296'=>'13.41801','2327'=>'13.41681','2357'=>'13.41632','2388'=>'13.41654','2418'=>'13.41748','2449'=>'13.41912','2479'=>'13.42147','2509'=>'13.42453','2540'=>'13.42829','2570'=>'13.43276',
				'2601'=>'13.43793','2631'=>'13.4438','2661'=>'13.45037','2692'=>'13.45764','2722'=>'13.4656','2753'=>'13.47425','2783'=>'13.48359','2814'=>'13.49362','2844'=>'13.50432','2874'=>'13.51571',
				'2905'=>'13.52777','2935'=>'13.5405','2966'=>'13.5539','2996'=>'13.56797','3026'=>'13.58269','3057'=>'13.59807','3087'=>'13.6141','3118'=>'13.63077','3148'=>'13.64809','3179'=>'13.66605',
				'3209'=>'13.68463','3239'=>'13.70384','3270'=>'13.72368','3300'=>'13.74413','3331'=>'13.76519','3361'=>'13.78685','3391'=>'13.80911','3422'=>'13.83197',
				'3452'=>'13.85541','3483'=>'13.87943','3513'=>'13.90402','3544'=>'13.92918','3574'=>'13.9549','3604'=>'13.98118','3635'=>'14.008','3665'=>'14.03535',
				'3696'=>'14.06324','3726'=>'14.09166','3756'=>'14.12059','3787'=>'14.15003','3817'=>'14.17997','3848'=>'14.21041','3878'=>'14.24133','3909'=>'14.27272','3939'=>'14.30459',
				'3969'=>'14.33691','4000'=>'14.36969','4030'=>'14.4029','4061'=>'14.43656','4091'=>'14.47063','4121'=>'14.50512','4152'=>'14.54002','4182'=>'14.57531','4213'=>'14.61099','4243'=>'14.64705',
				'4274'=>'14.68347','4304'=>'14.72025','4334'=>'14.75737','4365'=>'14.79484','4395'=>'14.83262','4426'=>'14.87073','4456'=>'14.90914','4486'=>'14.94784',
				'4517'=>'14.98682','4547'=>'15.02607','4578'=>'15.06559','4608'=>'15.10535','4639'=>'15.14535','4669'=>'15.18558','4699'=>'15.22602','4730'=>'15.26666','4760'=>'15.30749','4791'=>'15.34849',
				'4821'=>'15.38966','4851'=>'15.43098','4882'=>'15.47244','4912'=>'15.51403','4943'=>'15.55572','4973'=>'15.59752','5004'=>'15.63941','5034'=>'15.68136','5064'=>'15.72338','5095'=>'15.76544',
				'5125'=>'15.80753','5156'=>'15.84964','5186'=>'15.89175','5216'=>'15.93385','5247'=>'15.97592','5277'=>'16.01795','5308'=>'16.05992','5338'=>'16.10183','5369'=>'16.14364','5399'=>'16.18536',
				'5429'=>'16.22696','5460'=>'16.26842','5490'=>'16.30974','5521'=>'16.35089','5551'=>'16.39185','5581'=>'16.43262','5612'=>'16.47318','5642'=>'16.51351','5673'=>'16.55358','5703'=>'16.5934',
				'5734'=>'16.63293','5764'=>'16.67216','5794'=>'16.71107','5825'=>'16.74965','5855'=>'16.78787','5886'=>'16.82573','5916'=>'16.8632','5946'=>'16.90025','5977'=>'16.93689',
				'6007'=>'16.97308','6038'=>'17.0088','6068'=>'17.04404','6099'=>'17.07879','6129'=>'17.11301','6159'=>'17.14669','6190'=>'17.17981','6220'=>'17.21234','6251'=>'17.24429','6281'=>'17.2756',
				'6311'=>'17.30628','6342'=>'17.3363','6372'=>'17.36564','6403'=>'17.39427','6433'=>'17.42218','6464'=>'17.44935','6494'=>'17.47576','6524'=>'17.50137','6555'=>'17.52618','6585'=>'17.55015',
				'6616'=>'17.57328','6646'=>'17.59553','6676'=>'17.61689','6707'=>'17.63733','6737'=>'17.65683','6768'=>'17.67537','6798'=>'17.69293','6829'=>'17.70948','6859'=>'17.725','6889'=>'17.73946','6920'=>'17.75286',
				'6950'=>'17.76515','6981'=>'17.77632','7011'=>'17.78635','7041'=>'17.79521','7072'=>'17.80288','7102'=>'17.80934','7133'=>'17.81456','7163'=>'17.81852','7194'=>'17.82119','7224'=>'17.82256','7254'=>'17.82259',
				'7285'=>'17.82127','7300'=>'17.82009','7315'=>'17.81856');
		$percentile10Array=array('730' =>'15.09033','745' =>'15.07117','776' =>'15.03336','806' =>'14.9962','836' =>'14.95969','867' =>'14.92385','897' =>'14.88866','928' =>'14.85414','958' =>'14.82027',
				'989' =>'14.78707','1019' =>'14.75453','1049' =>'14.72264','1080' =>'14.69142','1110' =>'14.66086','1141' =>'14.63096','1171' =>'14.60173','1201' =>'14.57316','1232' =>'14.54527','1262' =>'14.51805',
				'1293' =>'14.49151','1323' =>'14.46566','1354' =>'14.4405','1384' =>'14.41604','1414' =>'14.39229','1445' =>'14.36926','1475' =>'14.34695','1506' =>'14.32537','1536' =>'14.30453','1566' =>'14.28444',
				'1597' =>'14.2651','1627' =>'14.24651','1658' =>'14.22868','1688' =>'14.21162','1719' =>'14.19532','1749' =>'14.17979','1779' =>'14.16503','1810' =>'14.15103','1840' =>'14.1378','1871' =>'14.12534',
				'1901' =>'14.11363','1931' =>'14.10268','1962' =>'14.09249','1992' =>'14.08305','2023' =>'14.07436','2053' =>'14.06642','2084' =>'14.05921','2114' =>'14.05274','2144' =>'14.04701','2175' =>'14.042',
				'2205' =>'14.03772','2236' =>'14.03417','2266' =>'14.03134','2296' =>'14.02922','2327' =>'14.02783','2357' =>'14.02714','2388' =>'14.02717','2418' =>'14.02791','2449' =>'14.02935','2479' =>'14.0315',
				'2509' =>'14.03435','2540' =>'14.03791','2570' =>'14.04216','2601' =>'14.04711','2631' =>'14.05276','2661' =>'14.0591','2692' =>'14.06613','2722' =>'14.07386','2753' =>'14.08228','2783' =>'14.09138',
				'2814' =>'14.10116','2844' =>'14.11163','2874' =>'14.12279','2905' =>'14.13462','2935' =>'14.14712','2966' =>'14.1603','2996' =>'14.17416','3026' =>'14.18868','3057' =>'14.20387','3087' =>'14.21972',
				'3118' =>'14.23624','3148' =>'14.25341','3179' =>'14.27124','3209' =>'14.28972','3239' =>'14.30884','3270' =>'14.32862','3300' =>'14.34903','3331' =>'14.37008','3361' =>'14.39177','3391' =>'14.41409',
				'3422' =>'14.43703','3452' =>'14.46059','3483' =>'14.48478','3513' =>'14.50957','3544' =>'14.53498','3574' =>'14.56099','3604' =>'14.5876','3635' =>'14.61481','3665' =>'14.6426','3696' =>'14.67098',
				'3726' =>'14.69994','3756' =>'14.72948','3787' =>'14.75958','3817' =>'14.79025','3848' =>'14.82148','3878' =>'14.85326','3909' =>'14.88558',
				'3939' =>'14.91845','3969' =>'14.95184','4000' =>'14.98577','4030' =>'15.02022','4061' =>'15.05519','4091' =>'15.09066','4121' =>'15.12664','4152' =>'15.16311',
				'4182' =>'15.20007','4213' =>'15.23751','4243' =>'15.27543','4274' =>'15.31381','4304' =>'15.35265','4334' =>'15.39195','4365' =>'15.43169','4395' =>'15.47187',
				'4426' =>'15.51248','4456' =>'15.5535','4486' =>'15.59495','4517' =>'15.6368','4547' =>'15.67904','4578' =>'15.72168','4608' =>'15.7647','4639' =>'15.80809','4669' =>'15.85184',
				'4699' =>'15.89595','4730' =>'15.94041','4760' =>'15.9852','4791' =>'16.03032','4821' =>'16.07576','4851' =>'16.12151','4882' =>'16.16756','4912' =>'16.21391','4943' =>'16.26054',
				'4973' =>'16.30743','5004' =>'16.3546','5034' =>'16.40201','5064' =>'16.44967','5095' =>'16.49756','5125' =>'16.54568','5156' =>'16.594','5186' =>'16.64254','5216' =>'16.69126',
				'5247' =>'16.74017','5277' =>'16.78924','5308' =>'16.83848','5338' =>'16.88787','5369' =>'16.9374','5399' =>'16.98706','5429' =>'17.03683','5460' =>'17.08672','5490' =>'17.1367',
				'5521' =>'17.18676','5551' =>'17.23689','5581' =>'17.28709','5612' =>'17.33734','5642' =>'17.38763','5673' =>'17.43794','5703' =>'17.48827','5734' =>'17.53861','5764' =>'17.58893',
				'5794' =>'17.63924','5825' =>'17.68951','5855' =>'17.73974','5886' =>'17.78991','5916' =>'17.84001','5946' =>'17.89003','5977' =>'17.93995','6007' =>'17.98977','6038' =>'18.03947',
				'6068' =>'18.08904','6099' =>'18.13846','6129' =>'18.18773','6159' =>'18.23682','6190' =>'18.28573','6220' =>'18.33444','6251' =>'18.38294','6281' =>'18.43121','6311' =>'18.47925',
				'6342' =>'18.52703','6372' =>'18.57455','6403' =>'18.62179','6433' =>'18.66873','6464' =>'18.71537','6494' =>'18.76168','6524' =>'18.80766','6555' =>'18.85328','6585' =>'18.89854',
				'6616' =>'18.94342','6646' =>'18.98791','6676' =>'19.03198','6707' =>'19.07563','6737' =>'19.11884','6768' =>'19.16159','6798' =>'19.20387','6829' =>'19.24567','6859' =>'19.28696',
				'6889' =>'19.32773','6920' =>'19.36797','6950' =>'19.40766','6981' =>'19.44678','7011' =>'19.48531','7041' =>'19.52325','7072' =>'19.56057','7102' =>'19.59726',
				'7133' =>'19.6333','7163' =>'19.66867','7194' =>'19.70335','7224' =>'19.73733','7254' =>'19.7706','7285' =>'19.80312','7300' =>'19.8191','7315' =>'19.83489');
		$percentile25Array=array('730' =>'15.74164','745' =>'15.71963','776' =>'15.67634','806' =>'15.63403','836' =>'15.59268','867' =>'15.55226','897' =>'15.51275','928' =>'15.47414',
				'958' =>'15.43639','989' =>'15.39951','1019' =>'15.36345','1049' =>'15.32822','1080' =>'15.29379','1110' =>'15.26016','1141' =>'15.22731','1171' =>'15.19523','1201' =>'15.16392',
				'1232' =>'15.13337','1262' =>'15.10359','1293' =>'15.07458','1323' =>'15.04633','1354' =>'15.01886','1384' =>'14.99218','1414' =>'14.96629','1445' =>'14.9412','1475' =>'14.91694',
				'1506' =>'14.89351','1536' =>'14.87093','1566' =>'14.84921','1597' =>'14.82838','1627' =>'14.80844','1658' =>'14.78941','1688' =>'14.7713','1719' =>'14.75414','1749' =>'14.73792',
				'1779' =>'14.72266','1810' =>'14.70836','1840' =>'14.69504','1871' =>'14.68269','1901' =>'14.67133','1931' =>'14.66094','1962' =>'14.65154','1992' =>'14.64312','2023' =>'14.63567',
				'2053' =>'14.6292','2084' =>'14.62369','2114' =>'14.61914','2144' =>'14.61555','2175' =>'14.6129','2205' =>'14.6112','2236' =>'14.61042','2266' =>'14.61057','2296' =>'14.61163',
				'2327' =>'14.61359','2357' =>'14.61645','2388' =>'14.6202','2418' =>'14.62483','2449' =>'14.63032','2479' =>'14.63668','2509' =>'14.64389','2540' =>'14.65194','2570' =>'14.66082',
				'2601' =>'14.67054','2631' =>'14.68107','2661' =>'14.69241','2692' =>'14.70455','2722' =>'14.71749','2753' =>'14.73121','2783' =>'14.74571','2814' =>'14.76099','2844' =>'14.77703',
				'2874' =>'14.79382','2905' =>'14.81136','2935' =>'14.82965','2966' =>'14.84867','2996' =>'14.86841','3026' =>'14.88888','3057' =>'14.91006','3087' =>'14.93194','3118' =>'14.95453',
				'3148' =>'14.9778','3179' =>'15.00176','3209' =>'15.0264','3239' =>'15.05172','3270' =>'15.07769','3300' =>'15.10433','3331' =>'15.13161','3361' =>'15.15954','3391' =>'15.1881','3422' =>'15.2173',
				'3452' =>'15.24712','3483' =>'15.27755','3513' =>'15.30859','3544' =>'15.34024','3574' =>'15.37248','3604' =>'15.40531','3635' =>'15.43872','3665' =>'15.4727','3696' =>'15.50725','3726' =>'15.54236',
				'3756' =>'15.57803','3787' =>'15.61424','3817' =>'15.65099','3848' =>'15.68826','3878' =>'15.72607','3909' =>'15.76439','3939' =>'15.80322','3969' =>'15.84255','4000' =>'15.88237','4030' =>'15.92268',
				'4061' =>'15.96347','4091' =>'16.00473','4121' =>'16.04646','4152' =>'16.08864','4182' =>'16.13127','4213' =>'16.17434','4243' =>'16.21784','4274' =>'16.26177','4304' =>'16.30612','4334' =>'16.35087',
				'4365' =>'16.39603','4395' =>'16.44158','4426' =>'16.48751','4456' =>'16.53382','4486' =>'16.5805','4517' =>'16.62754','4547' =>'16.67494','4578' =>'16.72267','4608' =>'16.77074',
				'4639' =>'16.81914','4669' =>'16.86786','4699' =>'16.91689','4730' =>'16.96621','4760' =>'17.01583','4791' =>'17.06574','4821' =>'17.11592','4851' =>'17.16636','4882' =>'17.21706',
				'4912' =>'17.26801','4943' =>'17.3192','4973' =>'17.37062','5004' =>'17.42227','5034' =>'17.47412','5064' =>'17.52618','5095' =>'17.57843','5125' =>'17.63086','5156' =>'17.68347',
				'5186' =>'17.73624','5216' =>'17.78917','5247' =>'17.84225','5277' =>'17.89546','5308' =>'17.9488','5338' =>'18.00225','5369' =>'18.05581','5399' =>'18.10947','5429' =>'18.16322','5460' =>'18.21704',
				'5490' =>'18.27093','5521' =>'18.32488','5551' =>'18.37887','5581' =>'18.4329','5612' =>'18.48696','5642' =>'18.54102','5673' =>'18.5951','5703' =>'18.64916','5734' =>'18.70321',
				'5764' =>'18.75723','5794' =>'18.81121','5825' =>'18.86514','5855' =>'18.919','5886' =>'18.97279','5916' =>'19.0265','5946' =>'19.08011','5977' =>'19.13361','6007' =>'19.187',
				'6038' =>'19.24025','6068' =>'19.29335','6099' =>'19.3463','6129' =>'19.39908','6159' =>'19.45168','6190' =>'19.50409','6220' =>'19.55629','6251' =>'19.60827','6281' =>'19.66002','6311' =>'19.71153','6342' =>'19.76278',
				'6372' =>'19.81376','6403' =>'19.86445','6433' =>'19.91485','6464' =>'19.96493','6494' =>'20.01469','6524' =>'20.06412','6555' =>'20.11319','6585' =>'20.1619','6616' =>'20.21022',
				'6646' =>'20.25816','6676' =>'20.30569','6707' =>'20.35279','6737' =>'20.39947','6768' =>'20.44569','6798' =>'20.49145','6829' =>'20.53674','6859' =>'20.58153',
				'6889' =>'20.62582','6920' =>'20.66959','6950' =>'20.71283','6981' =>'20.75552','7011' =>'20.79766','7041' =>'20.83922','7072' =>'20.88019','7102' =>'20.92056','7133' =>'20.96032',
				'7163' =>'20.99946','7194' =>'21.03795','7224' =>'21.07579','7254' =>'21.11296','7285' =>'21.14946','7300' =>'21.16745','7315' =>'21.18526');
		$percentile50Array=array('730' =>'16.57503','745' =>'16.54777','776' =>'16.49443','806' =>'16.4426','836' =>'16.39224','867' =>'16.34334','897' =>'16.29584','928' =>'16.24972','958' =>'16.20495',
				'989' =>'16.1615','1019' =>'16.11933','1049' =>'16.07843','1080' =>'16.03876','1110' =>'16.0003','1141' =>'15.96304','1171' =>'15.92695','1201' =>'15.89203','1232' =>'15.85824','1262' =>'15.82559','1293' =>'15.79406',
				'1323' =>'15.76364','1354' =>'15.73434','1384' =>'15.70614','1414' =>'15.67904','1445' =>'15.65305','1475' =>'15.62817','1506' =>'15.60441','1536' =>'15.58176','1566' =>'15.56025','1597' =>'15.53987','1627' =>'15.52065',
				'1658' =>'15.50258','1688' =>'15.48569','1719' =>'15.46998','1749' =>'15.45546','1779' =>'15.44214','1810' =>'15.43003','1840' =>'15.41914','1871' =>'15.40947','1901' =>'15.40103','1931' =>'15.39382','1962' =>'15.38783',
				'1992' =>'15.38307','2023' =>'15.37953','2053' =>'15.37721','2084' =>'15.37609','2114' =>'15.37618','2144' =>'15.37745','2175' =>'15.37991','2205' =>'15.38353','2236' =>'15.38831','2266' =>'15.39423','2296' =>'15.40127',
				'2327' =>'15.40943','2357' =>'15.41869','2388' =>'15.42902','2418' =>'15.44042','2449' =>'15.45288','2479' =>'15.46636','2509' =>'15.48087','2540' =>'15.49637','2570' =>'15.51287','2601' =>'15.53034',
				'2631' =>'15.54876','2661' =>'15.56812','2692' =>'15.58841','2722' =>'15.60961','2753' =>'15.63171','2783' =>'15.65469','2814' =>'15.67853','2844' =>'15.70323','2874' =>'15.72877','2905' =>'15.75513',
				'2935' =>'15.78231','2966' =>'15.81029','2996' =>'15.83905','3026' =>'15.86858','3057' =>'15.89888','3087' =>'15.92992','3118' =>'15.96169','3148' =>'15.99419','3179' =>'16.02741','3209' =>'16.06132','3239' =>'16.09591',
				'3270' =>'16.13119','3300' =>'16.16712','3331' =>'16.20371','3361' =>'16.24094','3391' =>'16.2788','3422' =>'16.31728','3452' =>'16.35637','3483' =>'16.39606','3513' =>'16.43633','3544' =>'16.47718','3574' =>'16.5186',
				'3604' =>'16.56057','3635' =>'16.60309','3665' =>'16.64614','3696' =>'16.68972','3726' =>'16.73381','3756' =>'16.7784','3787' =>'16.8235','3817' =>'16.86907',
				'3848' =>'16.91512','3878' =>'16.96164','3909' =>'17.00862','3939' =>'17.05604','3969' =>'17.1039','4000' =>'17.15218','4030' =>'17.20089','4061' =>'17.25','4091' =>'17.29951',
				'4121' =>'17.34942','4152' =>'17.3997','4182' =>'17.45036','4213' =>'17.50138','4243' =>'17.55276','4274' =>'17.60448','4304' =>'17.65653','4334' =>'17.70892','4365' =>'17.76162','4395' =>'17.81463',
				'4426' =>'17.86795','4456' =>'17.92155','4486' =>'17.97544','4517' =>'18.02961','4547' =>'18.08404','4578' =>'18.13873','4608' =>'18.19367','4639' =>'18.24884','4669' =>'18.30426','4699' =>'18.35989','4730' =>'18.41574','4760' =>'18.4718',
				'4791' =>'18.52805','4821' =>'18.5845','4851' =>'18.64113','4882' =>'18.69793','4912' =>'18.75489','4943' =>'18.81202','4973' =>'18.86929','5004' =>'18.9267','5034' =>'18.98424','5064' =>'19.04191',
				'5095' =>'19.0997','5125' =>'19.15759','5156' =>'19.21558','5186' =>'19.27366','5216' =>'19.33182','5247' =>'19.39006','5277' =>'19.44837','5308' =>'19.50673','5338' =>'19.56514',
				'5369' =>'19.6236','5399' =>'19.68208','5429' =>'19.7406','5460' =>'19.79912','5490' =>'19.85766','5521' =>'19.9162','5551' =>'19.97473','5581' =>'20.03324','5612' =>'20.09172','5642' =>'20.15017',
				'5673' =>'20.20858','5703' =>'20.26694','5734' =>'20.32524','5764' =>'20.38346','5794' =>'20.44162','5825' =>'20.49968','5855' =>'20.55765','5886' =>'20.61551','5916' =>'20.67326',
				'5946' =>'20.73089','5977' =>'20.78839','6007' =>'20.84574','6038' =>'20.90294','6068' =>'20.95999','6099' =>'21.01686','6129' =>'21.07356','6159' =>'21.13007','6190' =>'21.18638','6220' =>'21.24248',
				'6251' =>'21.29836','6281' =>'21.35402','6311' =>'21.40944','6342' =>'21.46461','6372' =>'21.51952','6403' =>'21.57417','6433' =>'21.62854','6464' =>'21.68262','6494' =>'21.7364','6524' =>'21.78988',
				'6555' =>'21.84304','6585' =>'21.89587','6616' =>'21.94836','6646' =>'22.00051','6676' =>'22.05229','6707' =>'22.10371','6737' =>'22.15476','6768' =>'22.20541','6798' =>'22.25567','6829' =>'22.30553','6859' =>'22.35497',
				'6889' =>'22.40399','6920' =>'22.45257','6950' =>'22.50072','6981' =>'22.54841','7011' =>'22.59565','7041' =>'22.64243','7072' =>'22.68873','7102' =>'22.73456','7133' =>'22.7799','7163' =>'22.82474','7194' =>'22.86909',
				'7224' =>'22.91293','7254' =>'22.95626','7285' =>'22.99908','7300' =>'23.02029','7315' =>'23.04138');
		$percentile75Array=array('730' =>'17.55719','745' =>'17.52129','776' =>'17.45135','806' =>'17.38384','836' =>'17.31871','867' =>'17.25593','897' =>'17.19546','928' =>'17.13726','958' =>'17.0813','989' =>'17.02753',
				'1019' =>'16.97592','1049' =>'16.92645','1080' =>'16.87907','1110' =>'16.83376','1141' =>'16.79048','1171' =>'16.7492','1201' =>'16.70988','1232' =>'16.67251','1262' =>'16.63704','1293' =>'16.60345','1323' =>'16.5717',
				'1354' =>'16.54177','1384' =>'16.51364','1414' =>'16.48726','1445' =>'16.46262','1475' =>'16.4397','1506' =>'16.41846','1536' =>'16.39889','1566' =>'16.38097','1597' =>'16.36468','1627' =>'16.35001','1658' =>'16.33693',
				'1688' =>'16.32545','1719' =>'16.31554','1749' =>'16.3072','1779' =>'16.30042','1810' =>'16.29518','1840' =>'16.29148','1871' =>'16.28932','1901' =>'16.28868','1931' =>'16.28955','1962' =>'16.29192',
				'1992' =>'16.29578','2023' =>'16.30113','2053' =>'16.30794','2084' =>'16.3162','2114' =>'16.3259','2144' =>'16.33702','2175' =>'16.34955','2205' =>'16.36346','2236' =>'16.37875','2266' =>'16.39537',
				'2296' =>'16.41333','2327' =>'16.4326','2357' =>'16.45315','2388' =>'16.47496','2418' =>'16.49801','2449' =>'16.52229','2479' =>'16.54776','2509' =>'16.5744','2540' =>'16.60219','2570' =>'16.63112','2601' =>'16.66114',
				'2631' =>'16.69225','2661' =>'16.72442','2692' =>'16.75763','2722' =>'16.79185','2753' =>'16.82707','2783' =>'16.86325','2814' =>'16.90039','2844' =>'16.93845','2874' =>'16.97742','2905' =>'17.01727','2935' =>'17.05799',
				'2966' =>'17.09955','2996' =>'17.14193','3026' =>'17.18512','3057' =>'17.22909','3087' =>'17.27383','3118' =>'17.31932','3148' =>'17.36552','3179' =>'17.41244','3209' =>'17.46005','3239' =>'17.50833',
				'3270' =>'17.55726','3300' =>'17.60683','3331' =>'17.65702','3361' =>'17.7078','3391' =>'17.75918','3422' =>'17.81112','3452' =>'17.86361','3483' =>'17.91664','3513' =>'17.9702','3544' =>'18.02425','3574' =>'18.07879',
				'3604' =>'18.13381','3635' =>'18.18929','3665' =>'18.24521','3696' =>'18.30156','3726' =>'18.35833','3756' =>'18.4155','3787' =>'18.47306','3817' =>'18.53099','3848' =>'18.58928','3878' =>'18.64792','3909' =>'18.70689',
				'3939' =>'18.76619','3969' =>'18.82579','4000' =>'18.8857','4030' =>'18.94588','4061' =>'19.00634','4091' =>'19.06706','4121' =>'19.12803',
				'4152' =>'19.18924','4182' =>'19.25067','4213' =>'19.31232','4243' =>'19.37417','4274' =>'19.43622','4304' =>'19.49845','4334' =>'19.56086','4365' =>'19.62342',
				'4395' =>'19.68614','4426' =>'19.74901','4456' =>'19.812','4486' =>'19.87512','4517' =>'19.93836','4547' =>'20.0017',
				'4578' =>'20.06514','4608' =>'20.12866','4639' =>'20.19227','4669' =>'20.25594','4699' =>'20.31968','4730' =>'20.38347','4760' =>'20.44731',
				'4791' =>'20.51119','4821' =>'20.5751','4851' =>'20.63903','4882' =>'20.70298','4912' =>'20.76694','4943' =>'20.8309','4973' =>'20.89486',
				'5004' =>'20.9588','5034' =>'21.02272','5064' =>'21.08663','5095' =>'21.15049','5125' =>'21.21433','5156' =>'21.27811','5186' =>'21.34185','5216' =>'21.40554',
				'5247' =>'21.46916','5277' =>'21.53272','5308' =>'21.5962','5338' =>'21.65961','5369' =>'21.72294','5399' =>'21.78618','5429' =>'21.84932',
				'5460' =>'21.91237','5490' =>'21.97532','5521' =>'22.03816','5551' =>'22.10089','5581' =>'22.1635','5612' =>'22.226','5642' =>'22.28837','5673' =>'22.35061',
				'5703' =>'22.41272','5734' =>'22.47469','5764' =>'22.53652','5794' =>'22.59821',
				'5825' =>'22.65976','5855' =>'22.72115','5886' =>'22.78239','5916' =>'22.84346','5946' =>'22.90438',
				'5977' =>'22.96514','6007' =>'23.02572','6038' =>'23.08614','6068' =>'23.14638','6099' =>'23.20645','6129' =>'23.26633','6159' =>'23.32604',
				'6190' =>'23.38556','6220' =>'23.4449','6251' =>'23.50404','6281' =>'23.563','6311' =>'23.62176','6342' =>'23.68033','6372' =>'23.7387','6403' =>'23.79687',
				'6433' =>'23.85484','6464' =>'23.91261','6494' =>'23.97018','6524' =>'24.02754','6555' =>'24.0847','6585' =>'24.14166','6616' =>'24.19841','6646' =>'24.25495',
				'6676' =>'24.31129','6707' =>'24.36742','6737' =>'24.42335','6768' =>'24.47907','6798' =>'24.53459','6829' =>'24.58991','6859' =>'24.64502','6889' =>'24.69994',
				'6920' =>'24.75466','6950' =>'24.80919','6981' =>'24.86352','7011' =>'24.91767','7041' =>'24.97163','7072' =>'25.02542','7102' =>'25.07902','7133' =>'25.13246',
				'7163' =>'25.18572','7194' =>'25.23883','7224' =>'25.29179','7254' =>'25.34459','7285' =>'25.39725','7300' =>'25.42353','7315' =>'25.44978');
		$percentile85Array=array('730' =>'18.16219','745' =>'18.11955','776' =>'18.03668','806' =>'17.957','836' =>'17.88047','867' =>'17.80704','897' =>'17.73667','928' =>'17.66932',
				'958' =>'17.60495','989' =>'17.54351','1019' =>'17.48496','1049' =>'17.42927','1080' =>'17.37639','1110' =>'17.32627','1141' =>'17.27889','1171' =>'17.23419',
				'1201' =>'17.19213','1232' =>'17.15266','1262' =>'17.11575','1293' =>'17.08135','1323' =>'17.04941','1354' =>'17.01988','1384' =>'16.99272','1414' =>'16.96789','1445' =>'16.94533',
				'1475' =>'16.92501','1506' =>'16.90688','1536' =>'16.89089','1566' =>'16.87701','1597' =>'16.86519','1627' =>'16.8554','1658' =>'16.8476','1688' =>'16.84176','1719' =>'16.83784',
				'1749' =>'16.8358','1779' =>'16.83563','1810' =>'16.83729','1840' =>'16.84076','1871' =>'16.846','1901' =>'16.853','1931' =>'16.86173','1962' =>'16.87217','1992' =>'16.88428','2023' =>'16.89805',
				'2053' =>'16.91346','2084' =>'16.93048','2114' =>'16.94909','2144' =>'16.96925','2175' =>'16.99096','2205' =>'17.01418','2236' =>'17.03888',
				'2266' =>'17.06505','2296' =>'17.09265','2327' =>'17.12166','2357' =>'17.15206','2388' =>'17.1838','2418' =>'17.21688','2449' =>'17.25126',
				'2479' =>'17.28691','2509' =>'17.3238','2540' =>'17.36192','2570' =>'17.40122','2601' =>'17.44168','2631' =>'17.48329',
				'2661' =>'17.52599','2692' =>'17.56978','2722' =>'17.61462','2753' =>'17.66049','2783' =>'17.70736','2814' =>'17.7552','2844' =>'17.80398',
				'2874' =>'17.85369','2905' =>'17.90429','2935' =>'17.95575','2966' =>'18.00807','2996' =>'18.0612','3026' =>'18.11512',
				'3057' =>'18.16981','3087' =>'18.22525','3118' =>'18.28141','3148' =>'18.33827','3179' =>'18.3958','3209' =>'18.45398','3239' =>'18.5128',
				'3270' =>'18.57222','3300' =>'18.63222','3331' =>'18.69279','3361' =>'18.7539','3391' =>'18.81554','3422' =>'18.87767','3452' =>'18.94028',
				'3483' =>'19.00336','3513' =>'19.06688','3544' =>'19.13081','3574' =>'19.19516','3604' =>'19.25988','3635' =>'19.32497','3665' =>'19.39041',
				'3696' =>'19.45618','3726' =>'19.52226','3756' =>'19.58864','3787' =>'19.6553','3817' =>'19.72222','3848' =>'19.78938','3878' =>'19.85678',
				'3909' =>'19.92439','3939' =>'19.9922','3969' =>'20.06019','4000' =>'20.12835','4030' =>'20.19667','4061' =>'20.26514','4091' =>'20.33373',
				'4121' =>'20.40243','4152' =>'20.47124','4182' =>'20.54013','4213' =>'20.6091','4243' =>'20.67814','4274' =>'20.74722','4304' =>'20.81635',
				'4334' =>'20.88551','4365' =>'20.95468','4395' =>'21.02386','4426' =>'21.09304','4456' =>'21.1622','4486' =>'21.23134','4517' =>'21.30045',
				'4547' =>'21.36951','4578' =>'21.43852','4608' =>'21.50748','4639' =>'21.57636','4669' =>'21.64517','4699' =>'21.71389','4730' =>'21.78252',
				'4760' =>'21.85104','4791' =>'21.91946','4821' =>'21.98777','4851' =>'22.05596','4882' =>'22.12402','4912' =>'22.19194','4943' =>'22.25973',
				'4973' =>'22.32737','5004' =>'22.39487','5034' =>'22.46221','5064' =>'22.52939','5095' =>'22.5964','5125' =>'22.66325','5156' =>'22.72993',
				'5186' =>'22.79643','5216' =>'22.86275','5247' =>'22.92889','5277' =>'22.99485','5308' =>'23.06062','5338' =>'23.12619','5369' =>'23.19158','5399' =>'23.25677',
				'5429' =>'23.32177','5460' =>'23.38657','5490' =>'23.45117','5521' =>'23.51557','5551' =>'23.57978','5581' =>'23.64378','5612' =>'23.70758',
				'5642' =>'23.77119','5673' =>'23.83459','5703' =>'23.89779','5734' =>'23.9608','5764' =>'24.02361','5794' =>'24.08622','5825' =>'24.14864',
				'5855' =>'24.21087','5886' =>'24.27291','5916' =>'24.33476','5946' =>'24.39642','5977' =>'24.4579','6007' =>'24.5192','6038' =>'24.58033','6068' =>'24.64128',
				'6099' =>'24.70207','6129' =>'24.76269','6159' =>'24.82315','6190' =>'24.88346','6220' =>'24.94362','6251' =>'25.00363','6281' =>'25.0635',
				'6311' =>'25.12324','6342' =>'25.18286','6372' =>'25.24235','6403' =>'25.30173','6433' =>'25.361','6464' =>'25.42017','6494' =>'25.47925','6524' =>'25.53824',
				'6555' =>'25.59716','6585' =>'25.65601','6616' =>'25.71481','6646' =>'25.77355','6676' =>'25.83225','6707' =>'25.89093','6737' =>'25.94958',
				'6768' =>'26.00823','6798' =>'26.06687','6829' =>'26.12553','6859' =>'26.18422','6889' =>'26.24294','6920' =>'26.30171','6950' =>'26.36054','6981' =>'26.41945',
				'7011' =>'26.47844','7041' =>'26.53753','7072' =>'26.59675','7102' =>'26.65609','7133' =>'26.71558','7163' =>'26.77522','7194' =>'26.83505',
				'7224' =>'26.89507','7254' =>'26.9553','7285' =>'27.01575','7300' =>'27.04607','7315' =>'27.07645');
		$percentile90Array=array('730' =>'18.60948','745' =>'18.56111','776' =>'18.4673','806' =>'18.37736','836' =>'18.29125',
				'867' =>'18.20892','897' =>'18.13031','928' =>'18.05538','958' =>'17.98408','989' =>'17.91635','1019' =>'17.85215','1049' =>'17.79143',
				'1080' =>'17.73414','1110' =>'17.68022','1141' =>'17.62963','1171' =>'17.58231','1201' =>'17.5382','1232' =>'17.49725','1262' =>'17.45941',
				'1293' =>'17.42462','1323' =>'17.39282','1354' =>'17.36395','1384' =>'17.33795','1414' =>'17.31477','1445' =>'17.29434','1475' =>'17.27661',
				'1506' =>'17.26151','1536' =>'17.24899','1566' =>'17.23899','1597' =>'17.23145','1627' =>'17.22632','1658' =>'17.22354','1688' =>'17.22306','1719' =>'17.22483',
				'1749' =>'17.2288','1779' =>'17.23493','1810' =>'17.24315','1840' =>'17.25344','1871' =>'17.26575','1901' =>'17.28003','1931' =>'17.29625','1962' =>'17.31437',
				'1992' =>'17.33435','2023' =>'17.35616','2053' =>'17.37975','2084' =>'17.4051','2114' =>'17.43217','2144' =>'17.46092','2175' =>'17.49133','2205' =>'17.52335',
				'2236' =>'17.55696','2266' =>'17.59212','2296' =>'17.6288','2327' =>'17.66696','2357' =>'17.70658','2388' =>'17.74762','2418' =>'17.79004','2449' =>'17.83382','2479' =>'17.87892',
				'2509' =>'17.92532','2540' =>'17.97296','2570' =>'18.02183','2601' =>'18.0719','2631' =>'18.12312','2661' =>'18.17548','2692' =>'18.22893','2722' =>'18.28344',
				'2753' =>'18.33899','2783' =>'18.39554','2814' =>'18.45306','2844' =>'18.51152','2874' =>'18.57089','2905' =>'18.63115',
				'2935' =>'18.69225','2966' =>'18.75418','2996' =>'18.8169','3026' =>'18.88038','3057' =>'18.94459','3087' =>'19.00952','3118' =>'19.07512',
				'3148' =>'19.14137','3179' =>'19.20825','3209' =>'19.27573','3239' =>'19.34378','3270' =>'19.41238','3300' =>'19.48149','3331' =>'19.5511',
				'3361' =>'19.62118','3391' =>'19.69171','3422' =>'19.76266','3452' =>'19.83401','3483' =>'19.90573','3513' =>'19.97781','3544' =>'20.05021',
				'3574' =>'20.12292','3604' =>'20.19592','3635' =>'20.26919','3665' =>'20.3427','3696' =>'20.41643','3726' =>'20.49036','3756' =>'20.56448',
				'3787' =>'20.63877','3817' =>'20.7132','3848' =>'20.78775','3878' =>'20.86242','3909' =>'20.93718','3939' =>'21.01201','3969' =>'21.0869',
				'4000' =>'21.16183','4030' =>'21.23679','4061' =>'21.31175','4091' =>'21.38671','4121' =>'21.46165',
				'4152' =>'21.53655','4182' =>'21.61141','4213' =>'21.6862','4243' =>'21.76091','4274' =>'21.83554','4304' =>'21.91006',
				'4334' =>'21.98447','4365' =>'22.05876','4395' =>'22.1329','4426' =>'22.2069','4456' =>'22.28075','4486' =>'22.35442','4517' =>'22.42791',
				'4547' =>'22.50122','4578' =>'22.57433','4608' =>'22.64724','4639' =>'22.71993','4669' =>'22.7924','4699' =>'22.86465',
				'4730' =>'22.93666','4760' =>'23.00842','4791' =>'23.07994','4821' =>'23.15121','4851' =>'23.22221','4882' =>'23.29295',
				'4912' =>'23.36342','4943' =>'23.43362','4973' =>'23.50354','5004' =>'23.57318','5034' =>'23.64253','5064' =>'23.7116','5095' =>'23.78038',
				'5125' =>'23.84887','5156' =>'23.91706','5186' =>'23.98496','5216' =>'24.05257','5247' =>'24.11987','5277' =>'24.18689','5308' =>'24.25361',
				'5338' =>'24.32003','5369' =>'24.38616','5399' =>'24.452','5429' =>'24.51755','5460' =>'24.58281','5490' =>'24.64778','5521' =>'24.71247',
				'5551' =>'24.77688','5581' =>'24.84102','5612' =>'24.90489','5642' =>'24.96848','5673' =>'25.03182','5703' =>'25.0949','5734' =>'25.15773',
				'5764' =>'25.22032','5794' =>'25.28267','5825' =>'25.34478','5855' =>'25.40668','5886' =>'25.46835','5916' =>'25.52982','5946' =>'25.59109',
				'5977' =>'25.65217','6007' =>'25.71306','6038' =>'25.77379','6068' =>'25.83436','6099' =>'25.89477','6129' =>'25.95504',
				'6159' =>'26.01519','6190' =>'26.07522','6220' =>'26.13515','6251' =>'26.19498','6281' =>'26.25474','6311' =>'26.31443','6342' =>'26.37407',
				'6372' =>'26.43368','6403' =>'26.49326','6433' =>'26.55284','6464' =>'26.61243','6494' =>'26.67204','6524' =>'26.73169','6555' =>'26.79141',
				'6585' =>'26.8512','6616' =>'26.91109','6646' =>'26.97108','6676' =>'27.03121','6707' =>'27.09149','6737' =>'27.15194','6768' =>'27.21259',
				'6798' =>'27.27344','6829' =>'27.33452','6859' =>'27.39585','6889' =>'27.45746','6920' =>'27.51936','6950' =>'27.58159','6981' =>'27.64415',
				'7011' =>'27.70707','7041' =>'27.77039','7072' =>'27.83411','7102' =>'27.89828','7133' =>'27.9629','7163' =>'28.02801','7194' =>'28.09363',
				'7224' =>'28.15978','7254' =>'28.2265','7285' =>'28.29381','7300' =>'28.3277','7315' =>'28.36174');
		$percentile95Array=array('730' =>'19.33801','745' =>'19.2789','776' =>'19.16466','806' =>'19.05567','836' =>'18.95187','867' =>'18.85317',
				'897' =>'18.75949','928' =>'18.67078','958' =>'18.58695','989' =>'18.50792','1019' =>'18.43363','1049' =>'18.364','1080' =>'18.29895','1110' =>'18.23842',
				'1141' =>'18.18231','1171' =>'18.13057','1201' =>'18.08311','1232' =>'18.03986','1262' =>'18.00074','1293' =>'17.96568','1323' =>'17.93459','1354' =>'17.90741',
				'1384' =>'17.88405','1414' =>'17.86444','1445' =>'17.8485','1475' =>'17.83614','1506' =>'17.8273','1536' =>'17.82189','1566' =>'17.81983',
				'1597' =>'17.82104','1627' =>'17.82544','1658' =>'17.83295','1688' =>'17.84349','1719' =>'17.85699','1749' =>'17.87335','1779' =>'17.89252','1810' =>'17.9144',
				'1840' =>'17.93893','1871' =>'17.96602','1901' =>'17.99562','1931' =>'18.02764','1962' =>'18.06201','1992' =>'18.09868','2023' =>'18.13758','2053' =>'18.17863',
				'2084' =>'18.22179','2114' =>'18.26698','2144' =>'18.31416','2175' =>'18.36325','2205' =>'18.41421','2236' =>'18.46699','2266' =>'18.52152','2296' =>'18.57775',
				'2327' =>'18.63564','2357' =>'18.69513','2388' =>'18.75617','2418' =>'18.81872','2449' =>'18.88272','2479' =>'18.94814','2509' =>'19.01491',
				'2540' =>'19.083','2570' =>'19.15236','2601' =>'19.22295','2631' =>'19.29471','2661' =>'19.36761','2692' =>'19.44161','2722' =>'19.51666',
				'2753' =>'19.59272','2783' =>'19.66974','2814' =>'19.74769','2844' =>'19.82652','2874' =>'19.9062','2905' =>'19.98668','2935' =>'20.06793','2966' =>'20.1499','2996' =>'20.23256',
				'3026' =>'20.31587','3057' =>'20.39979','3087' =>'20.48429','3118' =>'20.56933','3148' =>'20.65487','3179' =>'20.74089','3209' =>'20.82733','3239' =>'20.91417',
				'3270' =>'21.00138','3300' =>'21.08893','3331' =>'21.17677','3361' =>'21.26488','3391' =>'21.35323','3422' =>'21.44178','3452' =>'21.53051','3483' =>'21.61938',
				'3513' =>'21.70837','3544' =>'21.79745','3574' =>'21.88659','3604' =>'21.97576','3635' =>'22.06494','3665' =>'22.15409','3696' =>'22.2432','3726' =>'22.33224','3756' =>'22.42118',
				'3787' =>'22.51','3817' =>'22.59868','3848' =>'22.68719','3878' =>'22.77551','3909' =>'22.86363','3939' =>'22.95151','3969' =>'23.03915','4000' =>'23.12651',
				'4030' =>'23.21358','4061' =>'23.30035','4091' =>'23.38679','4121' =>'23.47289','4152' =>'23.55863','4182' =>'23.644','4213' =>'23.72897','4243' =>'23.81354',
				'4274' =>'23.89769','4304' =>'23.98141','4334' =>'24.06469','4365' =>'24.1475','4395' =>'24.22985','4426' =>'24.31172','4456' =>'24.3931',
				'4486' =>'24.47397','4517' =>'24.55434','4547' =>'24.6342','4578' =>'24.71352','4608' =>'24.79232','4639' =>'24.87058','4669' =>'24.94829',
				'4699' =>'25.02545','4730' =>'25.10206','4760' =>'25.17811','4791' =>'25.2536','4821' =>'25.32853','4851' =>'25.40289','4882' =>'25.47668',
				'4912' =>'25.5499','4943' =>'25.62256','4973' =>'25.69464','5004' =>'25.76616','5034' =>'25.83712','5064' =>'25.90751','5095' =>'25.97734','5125' =>'26.04662',
				'5156' =>'26.11535','5186' =>'26.18353','5216' =>'26.25117','5247' =>'26.31828','5277' =>'26.38485','5308' =>'26.45091','5338' =>'26.51646','5369' =>'26.58151',
				'5399' =>'26.64606','5429' =>'26.71014','5460' =>'26.77374','5490' =>'26.83688','5521' =>'26.89958','5551' =>'26.96184','5581' =>'27.02368','5612' =>'27.08511',
				'5642' =>'27.14616','5673' =>'27.20683','5703' =>'27.26714','5734' =>'27.3271','5764' =>'27.38675','5794' =>'27.44609','5825' =>'27.50514','5855' =>'27.56393',
				'5886' =>'27.62247','5916' =>'27.68078','5946' =>'27.7389','5977' =>'27.79683','6007' =>'27.85461','6038' =>'27.91225','6068' =>'27.96979','6099' =>'28.02724','6129' =>'28.08464',
				'6159' =>'28.142','6190' =>'28.19937','6220' =>'28.25676','6251' =>'28.3142','6281' =>'28.37173','6311' =>'28.42937','6342' =>'28.48716','6372' =>'28.54513','6403' =>'28.6033',
				'6433' =>'28.66171','6464' =>'28.72041','6494' =>'28.77941','6524' =>'28.83875','6555' =>'28.89848','6585' =>'28.95862','6616' =>'29.01921','6646' =>'29.0803','6676' =>'29.14191',
				'6707' =>'29.20409','6737' =>'29.26687','6768' =>'29.3303','6798' =>'29.39442','6829' =>'29.45926','6859' =>'29.52487','6889' =>'29.5913','6920' =>'29.65857','6950' =>'29.72674',
				'6981' =>'29.79585','7011' =>'29.86595','7041' =>'29.93707','7072' =>'30.00927','7102' =>'30.08258','7133' =>'30.15706','7163' =>'30.23276','7194' =>'30.30971',
				'7224' =>'30.38797','7254' =>'30.46758','7285' =>'30.54859','7300' =>'30.58964','7315' =>'30.63106');
		$percentile97Array=array('730' =>'19.33801','745' =>'19.2789','776' =>'19.16466','806' =>'19.05567','836' =>'18.95187','867' =>'18.85317','897' =>'18.75949',
				'928' =>'18.67078','958' =>'18.58695','989' =>'18.50792','1019' =>'18.43363','1049' =>'18.364','1080' =>'18.29895','1110' =>'18.23842','1141' =>'18.18231','1171' =>'18.13057',
				'1201' =>'18.08311','1232' =>'18.03986','1262' =>'18.00074','1293' =>'17.96568','1323' =>'17.93459','1354' =>'17.90741','1384' =>'17.88405','1414' =>'17.86444',
				'1445' =>'17.8485','1475' =>'17.83614','1506' =>'17.8273','1536' =>'17.82189','1566' =>'17.81983','1597' =>'17.82104','1627' =>'17.82544','1658' =>'17.83295','1688' =>'17.84349',
				'1719' =>'17.85699','1749' =>'17.87335','1779' =>'17.89252','1810' =>'17.9144','1840' =>'17.93893','1871' =>'17.96602','1901' =>'17.99562',
				'1931' =>'18.02764','1962' =>'18.06201','1992' =>'18.09868','2023' =>'18.13758','2053' =>'18.17863','2084' =>'18.22179','2114' =>'18.26698','2144' =>'18.31416',
				'2175' =>'18.36325','2205' =>'18.41421','2236' =>'18.46699','2266' =>'18.52152','2296' =>'18.57775','2327' =>'18.63564','2357' =>'18.69513','2388' =>'18.75617',
				'2418' =>'18.81872','2449' =>'18.88272','2479' =>'18.94814','2509' =>'19.01491','2540' =>'19.083','2570' =>'19.15236','2601' =>'19.22295','2631' =>'19.29471','2661' =>'19.36761',
				'2692' =>'19.44161','2722' =>'19.51666','2753' =>'19.59272','2783' =>'19.66974','2814' =>'19.74769','2844' =>'19.82652','2874' =>'19.9062','2905' =>'19.98668','2935' =>'20.06793','2966' =>'20.1499',
				'2996' =>'20.23256','3026' =>'20.31587','3057' =>'20.39979','3087' =>'20.48429','3118' =>'20.56933','3148' =>'20.65487','3179' =>'20.74089','3209' =>'20.82733','3239' =>'20.91417',
				'3270' =>'21.00138','3300' =>'21.08893','3331' =>'21.17677','3361' =>'21.26488','3391' =>'21.35323','3422' =>'21.44178','3452' =>'21.53051','3483' =>'21.61938','3513' =>'21.70837','3544' =>'21.79745',
				'3574' =>'21.88659','3604' =>'21.97576','3635' =>'22.06494','3665' =>'22.15409','3696' =>'22.2432','3726' =>'22.33224','3756' =>'22.42118','3787' =>'22.51','3817' =>'22.59868','3848' =>'22.68719',
				'3878' =>'22.77551','3909' =>'22.86363','3939' =>'22.95151','3969' =>'23.03915','4000' =>'23.12651','4030' =>'23.21358','4061' =>'23.30035','4091' =>'23.38679','4121' =>'23.47289','4152' =>'23.55863',
				'4182' =>'23.644','4213' =>'23.72897','4243' =>'23.81354','4274' =>'23.89769','4304' =>'23.98141','4334' =>'24.06469','4365' =>'24.1475','4395' =>'24.22985','4426' =>'24.31172','4456' =>'24.3931',
				'4486' =>'24.47397','4517' =>'24.55434','4547' =>'24.6342','4578' =>'24.71352','4608' =>'24.79232','4639' =>'24.87058','4669' =>'24.94829','4699' =>'25.02545','4730' =>'25.10206','4760' =>'25.17811','4791' =>'25.2536',
				'4821' =>'25.32853','4851' =>'25.40289','4882' =>'25.47668','4912' =>'25.5499','4943' =>'25.62256','4973' =>'25.69464','5004' =>'25.76616','5034' =>'25.83712','5064' =>'25.90751','5095' =>'25.97734',
				'5125' =>'26.04662','5156' =>'26.11535','5186' =>'26.18353','5216' =>'26.25117','5247' =>'26.31828','5277' =>'26.38485','5308' =>'26.45091','5338' =>'26.51646','5369' =>'26.58151','5399' =>'26.64606','5429' =>'26.71014',
				'5460' =>'26.77374','5490' =>'26.83688','5521' =>'26.89958','5551' =>'26.96184','5581' =>'27.02368','5612' =>'27.08511','5642' =>'27.14616','5673' =>'27.20683',
				'5703' =>'27.26714','5734' =>'27.3271','5764' =>'27.38675','5794' =>'27.44609','5825' =>'27.50514','5855' =>'27.56393','5886' =>'27.62247','5916' =>'27.68078','5946' =>'27.7389',
				'5977' =>'27.79683','6007' =>'27.85461','6038' =>'27.91225','6068' =>'27.96979','6099' =>'28.02724','6129' =>'28.08464','6159' =>'28.142','6190' =>'28.19937','6220' =>'28.25676','6251' =>'28.3142','6281' =>'28.37173',
				'6311' =>'28.42937','6342' =>'28.48716','6372' =>'28.54513','6403' =>'28.6033','6433' =>'28.66171','6464' =>'28.72041','6494' =>'28.77941','6524' =>'28.83875','6555' =>'28.89848',
				'6585' =>'28.95862','6616' =>'29.01921','6646' =>'29.0803','6676' =>'29.14191','6707' =>'29.20409','6737' =>'29.26687','6768' =>'29.3303','6798' =>'29.39442','6829' =>'29.45926','6859' =>'29.52487',
				'6889' =>'29.5913','6920' =>'29.65857','6950' =>'29.72674','6981' =>'29.79585','7011' =>'29.86595','7041' =>'29.93707','7072' =>'30.00927','7102' =>'30.08258','7133' =>'30.15706','7163' =>'30.23276','7194' =>'30.30971',
				'7224' =>'30.38797','7254' =>'30.46758','7285' =>'30.54859','7300' =>'30.58964','7315' =>'30.63106');
		//end of array
		$this->set(compact('percentile3Array','percentile5Array','percentile10Array','percentile25Array','percentile50Array','percentile75Array','percentile85Array','percentile90Array','percentile95Array','percentile97Array'));
		$this->set('diagnosis',$diagnosis);
		$this->set('bmi_array',$bmi_Day);
		$this->set(compact('year','month','date','patient_name'));

	}
	//end of bmi chart female
	public function bmi_weightforage_female($id=null) {
			
		$this->layout=false;
		$this->set('title_for_layout', __('Growth Chart', true));
		$this->uses = array('Patient','BmiResult','ReviewPatientDetail');
		//Getting Data for OPD patient
		$this->Patient->bindModel( array(
				'belongsTo' => array(
						'BmiResult'=>array('conditions'=>array('BmiResult.patient_id=Patient.id'),'foreignKey'=>false),
						'Person'=>array('conditions'=>array('Person.id=Patient.person_id'),'foreignKey'=>false)
				)
		));

		$diagnosis = $this->Patient->find('all',array('fields'=>array('BmiResult.height,BmiResult.weight,BmiResult.weight_volume,BmiResult.weight_result,BmiResult.bmi,BmiResult.patient_id,BmiResult.created_time,
				Patient.age,Patient.admission_type,Person.sex,Person.dob,Patient.lookup_name'),'conditions'=>array('Patient.person_id'=>$id,'Patient.is_deleted'=>0,'Patient.admission_type'=>'OPD'),'order' => array('Patient.id' => 'asc')));
		//debug($diagnosis);
		foreach($diagnosis as $data)
		{
			$var=$this->DateFormat->dateDiff($data['Person']['dob'],$data['BmiResult']['created_time']);
			$day=$var->days;
			$year[$day]=$var->y;
			$month[$day]=$var->m;
			$date[$day]=$data['BmiResult']['created_time'];
			$patient_name=$data['Patient']['lookup_name'];
			//Weight should be in "KG ONLY"
			if($data['BmiResult']['weight_volume']=='Kg')
			{
				$bmi_Day[$day][]=$data['BmiResult']['weight'];

			}
			elseif(strtolower($data['BmiResult']['weight_volume'])=='lbs')
			{
				$weight=explode(" ",$data['BmiResult']['weight_result']);
				$bmi_Day[$day][]=$weight[0];
			}
		}
		//Getting data for IPD patient
		$this->Patient->bindModel(array(
				'belongsTo'=>array(
						'ReviewPatientDetail'=>array('conditions'=>array('ReviewPatientDetail.patient_id=Patient.id'),'foreignKey'=>false),
						'ReviewSubCategoriesOption'=>array(
								'conditions'=>array('ReviewSubCategoriesOption.name LIKE'=>"%".Configure::read('bmi_weight_measured')."%"),'foreignKey'=>false),
						'Person'=>array('conditions'=>array('Person.id=Patient.person_id'),'foreignKey'=>false)
				)));
		$diagnosis1 = $this->Patient->find('all',array('fields'=>array('ReviewPatientDetail.values,ReviewPatientDetail.date,
				Patient.age,Patient.admission_type,Person.sex,Person.dob,Patient.lookup_name,ReviewSubCategoriesOption.id'),
				'conditions'=>array('Patient.person_id'=>$id,'ReviewSubCategoriesOption.id=ReviewPatientDetail.review_sub_categories_options_id','Patient.is_deleted'=>0,'ReviewPatientDetail.edited_on IS NULL','Patient.admission_type'=>'IPD'),'order' => array('Patient.id' => 'asc')));

		foreach($diagnosis1 as $data)
		{
			$var=$this->DateFormat->dateDiff($data['Person']['dob'],$data['ReviewPatientDetail']['date']);
			$day=$var->days;
			$year[$day]=$var->y;
			$date[$day]=$data['ReviewPatientDetail']['date'];
			$patient_name=$data['Patient']['lookup_name'];
			$month[$day]=$var->m;
			$bmi_Day[$day][]=$data['ReviewPatientDetail']['values'];
		}
		//Array for setting Standard datalines
		$percentile3Array=array('730'=>'9.985668','745'=>'10.04881','776'=>'10.17173','806'=>'10.29079','836'=>'10.40664','867'=>'10.5199','897'=>'10.63112','928'=>'10.74078','958'=>'10.84935','989'=>'10.95722',
				'1019'=>'11.06475','1049'=>'11.17225','1080'=>'11.28','1110'=>'11.38824','1141'=>'11.49718','1171'=>'11.607','1201'=>'11.71783','1232'=>'11.82981','1262'=>'11.94304','1293'=>'12.05757','1323'=>'12.17348',
				'1354'=>'12.2908','1384'=>'12.40954','1414'=>'12.52972','1445'=>'12.65132','1475'=>'12.77432','1506'=>'12.89869','1536'=>'13.02441','1566'=>'13.15141','1597'=>'13.27965','1627'=>'13.40907','1658'=>'13.53962',
				'1688'=>'13.67121','1719'=>'13.80381','1749'=>'13.93732','1779'=>'14.0717','1810'=>'14.20687','1840'=>'14.34277','1871'=>'14.47934','1901'=>'14.61652','1931'=>'14.75426','1962'=>'14.8925','1992'=>'15.03119',
				'2023'=>'15.1703','2053'=>'15.30978','2084'=>'15.44961','2114'=>'15.58975','2144'=>'15.73018','2175'=>'15.87089','2205'=>'16.01186','2236'=>'16.1531','2266'=>'16.2946','2296'=>'16.43638','2327'=>'16.57843','2357'=>'16.7208',
				'2388'=>'16.86349','2418'=>'17.00654','2449'=>'17.14998','2479'=>'17.29386','2509'=>'17.43821','2540'=>'17.5831','2570'=>'17.72858','2601'=>'17.8747','2631'=>'18.02152','2661'=>'18.16912','2692'=>'18.31757','2722'=>'18.46693',
				'2753'=>'18.61729','2783'=>'18.76871','2814'=>'18.92129','2844'=>'19.07511','2874'=>'19.23024','2905'=>'19.38678','2935'=>'19.54481','2966'=>'19.70442','2996'=>'19.86568',
				'3026'=>'20.0287','3057'=>'20.19355','3087'=>'20.36032','3118'=>'20.5291','3148'=>'20.69997','3179'=>'20.873','3209'=>'21.04828','3239'=>'21.22589','3270'=>'21.40589','3300'=>'21.58837','3331'=>'21.77338',
				'3361'=>'21.96099','3391'=>'22.15126','3422'=>'22.34426','3452'=>'22.54002','3483'=>'22.73861','3513'=>'22.94006','3544'=>'23.14441','3574'=>'23.3517','3604'=>'23.56195','3635'=>'23.77519','3665'=>'23.99143',
				'3696'=>'24.21068','3726'=>'24.43296','3756'=>'24.65826','3787'=>'24.88657','3817'=>'25.11788','3848'=>'25.35217','3878'=>'25.58941','3909'=>'25.82958','3939'=>'26.07263','3969'=>'26.31852','4000'=>'26.56719',
				'4030'=>'26.81859','4061'=>'27.07265','4091'=>'27.3293','4121'=>'27.58846','4152'=>'27.85004','4182'=>'28.11395','4213'=>'28.38009','4243'=>'28.64837','4274'=>'28.91866','4304'=>'29.19086','4334'=>'29.46484',
				'4365'=>'29.74046','4395'=>'30.0176','4426'=>'30.29612','4456'=>'30.57588','4486'=>'30.85671','4517'=>'31.13848','4547'=>'31.42101','4578'=>'31.70415','4608'=>'31.98774','4639'=>'32.27159','4669'=>'32.55554',
				'4699'=>'32.8394','4730'=>'33.12301','4760'=>'33.40617','4791'=>'33.6887','4821'=>'33.97042','4851'=>'34.25114','4882'=>'34.53066','4912'=>'34.80881','4943'=>'35.08539','4973'=>'35.36022','5004'=>'35.63309',
				'5034'=>'35.90384','5064'=>'36.17227','5095'=>'36.4382','5125'=>'36.70144','5156'=>'36.96182','5186'=>'37.21916','5216'=>'37.4733','5247'=>'37.72405','5277'=>'37.97127','5308'=>'38.21478','5338'=>'38.45445','5369'=>'38.69012',
				'5399'=>'38.92165','5429'=>'39.14891','5460'=>'39.37177','5490'=>'39.59012','5521'=>'39.80385','5551'=>'40.01284','5581'=>'40.21702','5612'=>'40.4163','5642'=>'40.6106','5673'=>'40.79986',
				'5703'=>'40.98403','5734'=>'41.16306','5764'=>'41.33692','5794'=>'41.50559','5825'=>'41.66907','5855'=>'41.82734','5886'=>'41.98043','5916'=>'42.12835','5946'=>'42.27115','5977'=>'42.40886',
				'6007'=>'42.54155','6038'=>'42.66928','6068'=>'42.79212','6099'=>'42.91017','6129'=>'43.02352','6159'=>'43.13227','6190'=>'43.23654','6220'=>'43.33646','6251'=>'43.43215','6281'=>'43.52374','6311'=>'43.61137',
				'6342'=>'43.69521','6372'=>'43.77538','6403'=>'43.85205','6433'=>'43.92537','6464'=>'43.9955','6494'=>'44.06258','6524'=>'44.12679','6555'=>'44.18826','6585'=>'44.24715','6616'=>'44.3036','6646'=>'44.35775','6676'=>'44.40973',
				'6707'=>'44.45965','6737'=>'44.50764','6768'=>'44.55377','6798'=>'44.59815','6829'=>'44.64082','6859'=>'44.68185','6889'=>'44.72126','6920'=>'44.75906','6950'=>'44.79521','6981'=>'44.82969','7011'=>'44.8624','7041'=>'44.89324',
				'7072'=>'44.92205','7102'=>'44.94866','7133'=>'44.97281','7163'=>'44.99424','7194'=>'45.0126','7224'=>'45.02752','7254'=>'45.03852','7285'=>'45.0451','7300'=>'45.04655');
		$percentile5Array=array('730'=>'10.21027','745'=>'10.27483','776'=>'10.40066','806'=>'10.52274','836'=>'10.64171','867'=>'10.75819','897'=>'10.87273','928'=>'10.98581','958'=>'11.09789','989'=>'11.20934','1019'=>'11.32054','1049'=>'11.43177',
				'1080'=>'11.54332','1110'=>'11.65542','1141'=>'11.76826','1171'=>'11.88202','1201'=>'11.99685','1232'=>'12.11284','1262'=>'12.23011','1293'=>'12.34871','1323'=>'12.4687','1354'=>'12.59011','1384'=>'12.71297','1414'=>'12.83726',
				'1445'=>'12.96298','1475'=>'13.09012','1506'=>'13.21864','1536'=>'13.3485','1566'=>'13.47966','1597'=>'13.61206','1627'=>'13.74566','1658'=>'13.8804','1688'=>'14.01621','1719'=>'14.15303','1749'=>'14.29081','1779'=>'14.42947','1810'=>'14.56897',
				'1840'=>'14.70924','1871'=>'14.85022','1901'=>'14.99186','1931'=>'15.13412','1962'=>'15.27694','1992'=>'15.42029','2023'=>'15.56413','2053'=>'15.70843','2084'=>'15.85316','2114'=>'15.99831','2144'=>'16.14385','2175'=>'16.28977','2205'=>'16.43608',
				'2236'=>'16.58277','2266'=>'16.72986','2296'=>'16.87736','2327'=>'17.02528','2357'=>'17.17365','2388'=>'17.3225','2418'=>'17.47187','2449'=>'17.6218','2479'=>'17.77232','2509'=>'17.9235','2540'=>'18.07539','2570'=>'18.22805','2601'=>'18.38153',
				'2631'=>'18.53591','2661'=>'18.69124','2692'=>'18.84762','2722'=>'19.00511','2753'=>'19.16378','2783'=>'19.32373','2814'=>'19.48502','2844'=>'19.64775','2874'=>'19.81199','2905'=>'19.97783','2935'=>'20.14535','2966'=>'20.31464','2996'=>'20.48579',
				'3026'=>'20.65887','3057'=>'20.83397','3087'=>'21.01117','3118'=>'21.19055','3148'=>'21.37219','3179'=>'21.55616','3209'=>'21.74253','3239'=>'21.93138','3270'=>'22.12277','3300'=>'22.31677','3331'=>'22.51343','3361'=>'22.71282','3391'=>'22.91497',
				'3422'=>'23.11994','3452'=>'23.32778','3483'=>'23.53851','3513'=>'23.75217','3544'=>'23.96879','3574'=>'24.18838','3604'=>'24.41097','3635'=>'24.63656','3665'=>'24.86516','3696'=>'25.09677','3726'=>'25.33137','3756'=>'25.56895','3787'=>'25.80949',
				'3817'=>'26.05297','3848'=>'26.29934','3878'=>'26.54856','3909'=>'26.8006','3939'=>'27.05539','3969'=>'27.31287','4000'=>'27.57298','4030'=>'27.83564','4061'=>'28.10077','4091'=>'28.36829','4121'=>'28.63809','4152'=>'28.91009','4182'=>'29.18417',
				'4213'=>'29.46022','4243'=>'29.73813','4274'=>'30.01776','4304'=>'30.299','4334'=>'30.5817','4365'=>'30.86573','4395'=>'31.15094','4426'=>'31.43718','4456'=>'31.7243','4486'=>'32.01214','4517'=>'32.30053','4547'=>'32.58932','4578'=>'32.87832',
				'4608'=>'33.16738','4639'=>'33.4563','4669'=>'33.74492','4699'=>'34.03306','4730'=>'34.32053','4760'=>'34.60715','4791'=>'34.89274','4821'=>'35.17711','4851'=>'35.46007','4882'=>'35.74145','4912'=>'36.02105','4943'=>'36.2987','4973'=>'36.57421','5004'=>'36.84739',
				'5034'=>'37.11808','5064'=>'37.3861','5095'=>'37.65127','5125'=>'37.91342','5156'=>'38.17238','5186'=>'38.428','5216'=>'38.68012','5247'=>'38.92858','5277'=>'39.17324','5308'=>'39.41396','5338'=>'39.6506','5369'=>'39.88303','5399'=>'40.11114',
				'5429'=>'40.3348','5460'=>'40.55392','5490'=>'40.76839','5521'=>'40.97812','5551'=>'41.18304','5581'=>'41.38308','5612'=>'41.57816','5642'=>'41.76824','5673'=>'41.95328','5703'=>'42.13324','5734'=>'42.3081','5764'=>'42.47785','5794'=>'42.64249',
				'5825'=>'42.80203','5855'=>'42.95649','5886'=>'43.1059','5916'=>'43.25031','5946'=>'43.38976','5977'=>'43.52432','6007'=>'43.65406','6038'=>'43.77907','6068'=>'43.89944','6099'=>'44.01527','6129'=>'44.12666','6159'=>'44.23375','6190'=>'44.33665',
				'6220'=>'44.4355','6251'=>'44.53044','6281'=>'44.62161','6311'=>'44.70917','6342'=>'44.79326','6372'=>'44.87405','6403'=>'44.95168','6433'=>'45.02633','6464'=>'45.09815','6494'=>'45.16729','6524'=>'45.23391',
				'6555'=>'45.29817','6585'=>'45.3602','6616'=>'45.42015','6646'=>'45.47815','6676'=>'45.53431','6707'=>'45.58875','6737'=>'45.64157','6768'=>'45.69284','6798'=>'45.74262','6829'=>'45.79097',
				'6859'=>'45.8379','6889'=>'45.88343','6920'=>'45.92751','6950'=>'45.97009','6981'=>'46.0111','7011'=>'46.0504','7041'=>'46.08784','7072'=>'46.12322','7102'=>'46.1563','7133'=>'46.18678','7163'=>'46.21432',
				'7194'=>'46.23851','7224'=>'46.25891','7254'=>'46.27498','7285'=>'46.28612','7300'=>'46.28963');
		$percentile10Array=array('730'=>'10.57373','745'=>'10.64076','776'=>'10.77167','806'=>'10.89899','836'=>'11.02338','867'=>'11.14545','897'=>'11.26575','928'=>'11.38474','958'=>'11.50288','989'=>'11.62054','1019'=>'11.73806','1049'=>'11.85574','1080'=>'11.97384','1110'=>'12.09259',
				'1141'=>'12.21216','1171'=>'12.33273','1201'=>'12.45442','1232'=>'12.57735','1262'=>'12.70158','1293'=>'12.8272','1323'=>'12.95423','1354'=>'13.08271','1384'=>'13.21265','1414'=>'13.34405','1445'=>'13.47689','1475'=>'13.61116','1506'=>'13.74682',
				'1536'=>'13.88384','1566'=>'14.02217','1597'=>'14.16176','1627'=>'14.30257','1658'=>'14.44453','1688'=>'14.5876','1719'=>'14.73172','1749'=>'14.87683','1779'=>'15.02287','1810'=>'15.16981','1840'=>'15.31758','1871'=>'15.46614','1901'=>'15.61545','1931'=>'15.76547','1962'=>'15.91616',
				'1992'=>'16.06749','2023'=>'16.21943','2053'=>'16.37197','2084'=>'16.52509','2114'=>'16.67878','2144'=>'16.83304','2175'=>'16.98787','2205'=>'17.14327','2236'=>'17.29926','2266'=>'17.45586','2296'=>'17.61309','2327'=>'17.77097','2357'=>'17.92956','2388'=>'18.08887',
				'2418'=>'18.24897','2449'=>'18.40989','2479'=>'18.5717','2509'=>'18.73445','2540'=>'18.89819','2570'=>'19.063','2601'=>'19.22895','2631'=>'19.3961','2661'=>'19.56453','2692'=>'19.73432','2722'=>'19.90554','2753'=>'20.07828','2783'=>'20.25261','2814'=>'20.42863','2844'=>'20.6064',
				'2874'=>'20.78601','2905'=>'20.96755','2935'=>'21.15111','2966'=>'21.33675','2996'=>'21.52456','3026'=>'21.71462','3057'=>'21.907','3087'=>'22.10179','3118'=>'22.29905','3148'=>'22.49884','3179'=>'22.70125','3209'=>'22.90633','3239'=>'23.11413',
				'3270'=>'23.32471','3300'=>'23.53813','3331'=>'23.75442','3361'=>'23.97364','3391'=>'24.19581','3422'=>'24.42096','3452'=>'24.64912','3483'=>'24.88031','3513'=>'25.11454','3544'=>'25.35181','3574'=>'25.59214','3604'=>'25.83551','3635'=>'26.08191','3665'=>'26.33132',
				'3696'=>'26.58372','3726'=>'26.83907','3756'=>'27.09734','3787'=>'27.35848','3817'=>'27.62244','3848'=>'27.88915','3878'=>'28.15856','3909'=>'28.43059','3939'=>'28.70516','3969'=>'28.98218','4000'=>'29.26156','4030'=>'29.54321','4061'=>'29.827',
				'4091'=>'30.11285','4121'=>'30.40062','4152'=>'30.69019','4182'=>'30.98143','4213'=>'31.27421','4243'=>'31.56838','4274'=>'31.86381','4304'=>'32.16034','4334'=>'32.45781','4365'=>'32.75608','4395'=>'33.05496','4426'=>'33.3543','4456'=>'33.65394',
				'4486'=>'33.95368','4517'=>'34.25336','4547'=>'34.55281','4578'=>'34.85183','4608'=>'35.15025','4639'=>'35.44789','4669'=>'35.74455','4699'=>'36.04006','4730'=>'36.33424','4760'=>'36.62688','4791'=>'36.91782','4821'=>'37.20687','4851'=>'37.49385','4882'=>'37.77858',
				'4912'=>'38.06087','4943'=>'38.34057','4973'=>'38.61748','5004'=>'38.89145','5034'=>'39.16232','5064'=>'39.42991','5095'=>'39.69408','5125'=>'39.95467','5156'=>'40.21154','5186'=>'40.46454','5216'=>'40.71356','5247'=>'40.95845','5277'=>'41.19909','5308'=>'41.43538',
				'5338'=>'41.66721','5369'=>'41.89448','5399'=>'42.1171','5429'=>'42.33498','5460'=>'42.54806','5490'=>'42.75627','5521'=>'42.95955','5551'=>'43.15786','5581'=>'43.35116','5612'=>'43.53942','5642'=>'43.72263','5673'=>'43.90078','5703'=>'44.07388','5734'=>'44.24193','5764'=>'44.40496',
				'5794'=>'44.563','5825'=>'44.71609','5855'=>'44.8643','5886'=>'45.00768','5916'=>'45.14631','5946'=>'45.28027','5977'=>'45.40964','6007'=>'45.53455','6038'=>'45.65509','6068'=>'45.77138','6099'=>'45.88355','6129'=>'45.99174','6159'=>'46.09608','6190'=>'46.19672','6220'=>'46.29382',
				'6251'=>'46.38753','6281'=>'46.47801','6311'=>'46.56543','6342'=>'46.64995','6372'=>'46.73174','6403'=>'46.81097','6433'=>'46.8878','6464'=>'46.9624','6494'=>'47.03493','6524'=>'47.10554','6555'=>'47.17437','6585'=>'47.24158','6616'=>'47.30728','6646'=>'47.3716','6676'=>'47.43464',
				'6707'=>'47.4965','6737'=>'47.55724','6768'=>'47.61693','6798'=>'47.67559','6829'=>'47.73323','6859'=>'47.78983','6889'=>'47.84535','6920'=>'47.89972','6950'=>'47.9528','6981'=>'48.00447','7011'=>'48.05453',
				'7041'=>'48.10274','7072'=>'48.14882','7102'=>'48.19244','7133'=>'48.23321','7163'=>'48.27069','7194'=>'48.30438','7224'=>'48.3337','7254'=>'48.358','7285'=>'48.37657','7300'=>'48.38346');
		$percentile25Array=array('730'=>'11.23357','745'=>'11.30567','776'=>'11.44697','806'=>'11.58501','836'=>'11.72047','867'=>'11.85392','897'=>'11.98592','928'=>'12.11692','958'=>'12.24735','989'=>'12.37757','1019'=>'12.50791',
				'1049'=>'12.63865','1080'=>'12.77001','1110'=>'12.90222','1141'=>'13.03542','1171'=>'13.16977','1201'=>'13.30538','1232'=>'13.44234','1262'=>'13.58071','1293'=>'13.72054','1323'=>'13.86186','1354'=>'14.00469','1384'=>'14.14902',
				'1414'=>'14.29485','1445'=>'14.44217','1475'=>'14.59093','1506'=>'14.74112','1536'=>'14.89269','1566'=>'15.0456','1597'=>'15.19981','1627'=>'15.35527','1658'=>'15.51193','1688'=>'15.66975','1719'=>'15.82868','1749'=>'15.98868',
				'1779'=>'16.14971','1810'=>'16.31173','1840'=>'16.47471','1871'=>'16.63861','1901'=>'16.80342','1931'=>'16.9691','1962'=>'17.13565','1992'=>'17.30305','2023'=>'17.4713','2053'=>'17.6404','2084'=>'17.81035','2114'=>'17.98118','2144'=>'18.15288',
				'2175'=>'18.32549','2205'=>'18.49904','2236'=>'18.67356','2266'=>'18.84908','2296'=>'19.02566','2327'=>'19.20334','2357'=>'19.38217','2388'=>'19.56221','2418'=>'19.74353','2449'=>'19.9262','2479'=>'20.11027','2509'=>'20.29582',
				'2540'=>'20.48293','2570'=>'20.67168','2601'=>'20.86215','2631'=>'21.05441','2661'=>'21.24855','2692'=>'21.44467','2722'=>'21.64283','2753'=>'21.84313','2783'=>'22.04564','2814'=>'22.25047','2844'=>'22.45768','2874'=>'22.66736',
				'2905'=>'22.8796','2935'=>'23.09446','2966'=>'23.31203','2996'=>'23.53237','3026'=>'23.75556','3057'=>'23.98166','3087'=>'24.21073','3118'=>'24.44283','3148'=>'24.67802','3179'=>'24.91634','3209'=>'25.15783','3239'=>'25.40252','3270'=>'25.65046',
				'3300'=>'25.90167','3331'=>'26.15616','3361'=>'26.41394','3391'=>'26.67503','3422'=>'26.93942','3452'=>'27.20709','3483'=>'27.47805','3513'=>'27.75225','3544'=>'28.02968','3574'=>'28.31029','3604'=>'28.59403','3635'=>'28.88087','3665'=>'29.17072',
				'3696'=>'29.46353','3726'=>'29.75922','3756'=>'30.0577','3787'=>'30.35888','3817'=>'30.66267','3848'=>'30.96895','3878'=>'31.27762','3909'=>'31.58856','3939'=>'31.90163','3969'=>'32.21671','4000'=>'32.53364','4030'=>'32.8523',
				'4061'=>'33.17252','4091'=>'33.49415','4121'=>'33.81701','4152'=>'34.14096','4182'=>'34.4658','4213'=>'34.79137','4243'=>'35.11747','4274'=>'35.44394','4304'=>'35.77056','4334'=>'36.09716','4365'=>'36.42354','4395'=>'36.7495',
				'4426'=>'37.07485','4456'=>'37.39937','4486'=>'37.72288','4517'=>'38.04517','4547'=>'38.36604','4578'=>'38.68529','4608'=>'39.00272','4639'=>'39.31812','4669'=>'39.63131','4699'=>'39.94209','4730'=>'40.25026','4760'=>'40.55564','4791'=>'40.85805',
				'4821'=>'41.15729','4851'=>'41.45321','4882'=>'41.74562','4912'=>'42.03435','4943'=>'42.31926','4973'=>'42.60018','5004'=>'42.87697','5034'=>'43.14949','5064'=>'43.4176','5095'=>'43.68119','5125'=>'43.94012','5156'=>'44.1943',
				'5186'=>'44.44363','5216'=>'44.688','5247'=>'44.92735','5277'=>'45.1616','5308'=>'45.39069','5338'=>'45.61455','5369'=>'45.83316','5399'=>'46.04647','5429'=>'46.25446','5460'=>'46.45712','5490'=>'46.65445','5521'=>'46.84646',
				'5551'=>'47.03316','5581'=>'47.21458','5612'=>'47.39077','5642'=>'47.56176','5673'=>'47.72763','5703'=>'47.88844','5734'=>'48.04426','5764'=>'48.1952','5794'=>'48.34134','5825'=>'48.48279','5855'=>'48.61968','5886'=>'48.75212','5916'=>'48.88026','5946'=>'49.00422',
				'5977'=>'49.12417','6007'=>'49.24026','6038'=>'49.35265','6068'=>'49.46152','6099'=>'49.56702','6129'=>'49.66936','6159'=>'49.7687','6190'=>'49.86524','6220'=>'49.95916','6251'=>'50.05066','6281'=>'50.13993','6311'=>'50.22716','6342'=>'50.31253',
				'6372'=>'50.39624','6403'=>'50.47847','6433'=>'50.5594','6464'=>'50.63919','6494'=>'50.71802','6524'=>'50.79603','6555'=>'50.87336','6585'=>'50.95014','6616'=>'51.02649','6646'=>'51.10249','6676'=>'51.17823','6707'=>'51.25375','6737'=>'51.32908',
				'6768'=>'51.40422','6798'=>'51.47916','6829'=>'51.55381','6859'=>'51.6281','6889'=>'51.70189','6920'=>'51.77499','6950'=>'51.8472','6981'=>'51.91825','7011'=>'51.98781','7041'=>'52.05553','7072'=>'52.12097','7102'=>'52.18364','7133'=>'52.243',
				'7163'=>'52.29842','7194'=>'52.34921','7224'=>'52.3946','7254'=>'52.43376','7285'=>'52.46576','7300'=>'52.47876');
		$percentile50Array=array('730'=>'12.05504','745'=>'12.13456','776'=>'12.29102','806'=>'12.44469','836'=>'12.59622','867'=>'12.74621','897'=>'12.89517','928'=>'13.04357','958'=>'13.19181','989'=>'13.34023','1019'=>'13.48913',
				'1049'=>'13.63877','1080'=>'13.78937','1110'=>'13.94108','1141'=>'14.09407','1171'=>'14.24844','1201'=>'14.40429','1232'=>'14.56168','1262'=>'14.72064','1293'=>'14.88121','1323'=>'15.04341','1354'=>'15.20721','1384'=>'15.37263','1414'=>'15.53962','1445'=>'15.70817',
				'1475'=>'15.87824','1506'=>'16.04978','1536'=>'16.22277','1566'=>'16.39715','1597'=>'16.57289','1627'=>'16.74994','1658'=>'16.92827','1688'=>'17.10783','1719'=>'17.28859','1749'=>'17.47052','1779'=>'17.65361','1810'=>'17.83782',
				'1840'=>'18.02314','1871'=>'18.20956','1901'=>'18.39709','1931'=>'18.58571','1962'=>'18.77545','1992'=>'18.96631','2023'=>'19.15831','2053'=>'19.35149','2084'=>'19.54588','2114'=>'19.74151','2144'=>'19.93843','2175'=>'20.1367',
				'2205'=>'20.33636','2236'=>'20.53748','2266'=>'20.74013','2296'=>'20.94438','2327'=>'21.1503','2357'=>'21.35797','2388'=>'21.56748','2418'=>'21.77891','2449'=>'21.99235','2479'=>'22.20789','2509'=>'22.42562','2540'=>'22.64564','2570'=>'22.86804',
				'2601'=>'23.09293','2631'=>'23.32039','2661'=>'23.55052','2692'=>'23.78342','2722'=>'24.01918','2753'=>'24.25789','2783'=>'24.49965','2814'=>'24.74454','2844'=>'24.99264','2874'=>'25.24403','2905'=>'25.4988','2935'=>'25.75702',
				'2966'=>'26.01874','2996'=>'26.28404','3026'=>'26.55298','3057'=>'26.82559','3087'=>'27.10193','3118'=>'27.38203','3148'=>'27.66593','3179'=>'27.95365','3209'=>'28.24521','3239'=>'28.5406','3270'=>'28.83984','3300'=>'29.14291',
				'3331'=>'29.4498','3361'=>'29.76048','3391'=>'30.07493','3422'=>'30.39308','3452'=>'30.7149','3483'=>'31.04032','3513'=>'31.36928','3544'=>'31.70168','3574'=>'32.03745','3604'=>'32.37649','3635'=>'32.71868','3665'=>'33.06392',
				'3696'=>'33.41208','3726'=>'33.76303','3756'=>'34.11663','3787'=>'34.47272','3817'=>'34.83116','3848'=>'35.19176','3878'=>'35.55437','3909'=>'35.9188','3939'=>'36.28486','3969'=>'36.65236','4000'=>'37.02111','4030'=>'37.39089',
				'4061'=>'37.76149','4091'=>'38.1327','4121'=>'38.5043','4152'=>'38.87605','4182'=>'39.24775','4213'=>'39.61914','4243'=>'39.99','4274'=>'40.36009','4304'=>'40.72918','4334'=>'41.09701','4365'=>'41.46336','4395'=>'41.82798','4426'=>'42.19063',
				'4456'=>'42.55108','4486'=>'42.90909','4517'=>'43.26442','4547'=>'43.61683','4578'=>'43.96612','4608'=>'44.31204','4639'=>'44.65437','4669'=>'44.99291','4699'=>'45.32745','4730'=>'45.65777','4760'=>'45.98369','4791'=>'46.30501','4821'=>'46.62155',
				'4851'=>'46.93314','4882'=>'47.23962','4912'=>'47.54083','4943'=>'47.83661','4973'=>'48.12685','5004'=>'48.41141','5034'=>'48.69018','5064'=>'48.96305','5095'=>'49.22993','5125'=>'49.49075','5156'=>'49.74544','5186'=>'49.99394',
				'5216'=>'50.23621','5247'=>'50.47222','5277'=>'50.70196','5308'=>'50.92541','5338'=>'51.14259','5369'=>'51.35353','5399'=>'51.55825','5429'=>'51.75681','5460'=>'51.94926','5490'=>'52.13568','5521'=>'52.31616','5551'=>'52.4908','5581'=>'52.6597','5612'=>'52.82299',
				'5642'=>'52.98079','5673'=>'53.13327','5703'=>'53.28056','5734'=>'53.42284','5764'=>'53.56028','5794'=>'53.69307','5825'=>'53.82138','5855'=>'53.94544','5886'=>'54.06543','5916'=>'54.18158','5946'=>'54.29411','5977'=>'54.40324','6007'=>'54.50921',
				'6038'=>'54.61224','6068'=>'54.71257','6099'=>'54.81044','6129'=>'54.9061','6159'=>'54.99978','6190'=>'55.09172','6220'=>'55.18217','6251'=>'55.27135','6281'=>'55.35951','6311'=>'55.44686','6342'=>'55.53362','6372'=>'55.62001',
				'6403'=>'55.70624','6433'=>'55.79248','6464'=>'55.87892','6494'=>'55.96573','6524'=>'56.05305','6555'=>'56.141','6585'=>'56.2297','6616'=>'56.31922','6646'=>'56.40963','6676'=>'56.50096','6707'=>'56.5932','6737'=>'56.68633','6768'=>'56.78026',
				'6798'=>'56.8749','6829'=>'56.9701','6859'=>'57.06565','6889'=>'57.16132','6920'=>'57.2568','6950'=>'57.35176','6981'=>'57.44578','7011'=>'57.5384','7041'=>'57.6291','7072'=>'57.71728',
				'7102'=>'57.80227','7133'=>'57.88334','7163'=>'57.95967','7194'=>'58.0304','7224'=>'58.09453','7254'=>'58.15104','7285'=>'58.19877','7300'=>'58.21897');
		$percentile75Array=array('730'=>'12.98667','745'=>'13.07613','776'=>'13.25293','806'=>'13.42753','836'=>'13.60059','867'=>'13.77271','897'=>'13.9444','928'=>'14.11611','958'=>'14.28823','989'=>'14.46106','1019'=>'14.63491','1049'=>'14.80998',
				'1080'=>'14.98647','1110'=>'15.16452','1141'=>'15.34425','1171'=>'15.52574','1201'=>'15.70905','1232'=>'15.89422','1262'=>'16.08126','1293'=>'16.27016','1323'=>'16.46093','1354'=>'16.65353','1384'=>'16.84793','1414'=>'17.04408',
				'1445'=>'17.24195','1475'=>'17.44149','1506'=>'17.64265','1536'=>'17.84537','1566'=>'18.04961','1597'=>'18.25533','1627'=>'18.46249','1658'=>'18.67105','1688'=>'18.88097','1719'=>'19.09224','1749'=>'19.30483','1779'=>'19.51874','1810'=>'19.73395',
				'1840'=>'19.95048','1871'=>'20.16834','1901'=>'20.38753','1931'=>'20.6081','1962'=>'20.83007','1992'=>'21.05349','2023'=>'21.2784','2053'=>'21.50486','2084'=>'21.73294','2114'=>'21.96271','2144'=>'22.19425','2175'=>'22.42763',
				'2205'=>'22.66294','2236'=>'22.90029','2266'=>'23.13976','2296'=>'23.38146','2327'=>'23.6255','2357'=>'23.87199','2388'=>'24.12103','2418'=>'24.37274','2449'=>'24.62725','2479'=>'24.88466','2509'=>'25.14509','2540'=>'25.40866',
				'2570'=>'25.67549','2601'=>'25.94569','2631'=>'26.21937','2661'=>'26.49666','2692'=>'26.77764','2722'=>'27.06244','2753'=>'27.35114','2783'=>'27.64385','2814'=>'27.94066','2844'=>'28.24165','2874'=>'28.54689','2905'=>'28.85648','2935'=>'29.17046',
				'2966'=>'29.4889','2996'=>'29.81185','3026'=>'30.13934','3057'=>'30.47142','3087'=>'30.80811','3118'=>'31.14942','3148'=>'31.49536','3179'=>'31.84592','3209'=>'32.20108','3239'=>'32.56084','3270'=>'32.92513','3300'=>'33.29393',
				'3331'=>'33.66717','3361'=>'34.04479','3391'=>'34.4267','3422'=>'34.81282','3452'=>'35.20305','3483'=>'35.59726','3513'=>'35.99535','3544'=>'36.39717','3574'=>'36.80259','3604'=>'37.21144','3635'=>'37.62356',
				'3665'=>'38.03878','3696'=>'38.45691','3726'=>'38.87775','3756'=>'39.30111','3787'=>'39.72676','3817'=>'40.15449','3848'=>'40.58407','3878'=>'41.01526','3909'=>'41.44782','3939'=>'41.88148','3969'=>'42.316','4000'=>'42.75111','4030'=>'43.18655',
				'4061'=>'43.62203','4091'=>'44.05728','4121'=>'44.49201','4152'=>'44.92595','4182'=>'45.3588','4213'=>'45.79028','4243'=>'46.22009','4274'=>'46.64794','4304'=>'47.07354','4334'=>'47.49661','4365'=>'47.91684','4395'=>'48.33396','4426'=>'48.74767',
				'4456'=>'49.15771','4486'=>'49.56378','4517'=>'49.96562','4547'=>'50.36297','4578'=>'50.75555','4608'=>'51.14313','4639'=>'51.52544','4669'=>'51.90225','4699'=>'52.27334','4730'=>'52.63847','4760'=>'52.99745','4791'=>'53.35007',
				'4821'=>'53.69614','4851'=>'54.03549','4882'=>'54.36794','4912'=>'54.69335','4943'=>'55.01159','4973'=>'55.32252','5004'=>'55.62603','5034'=>'55.92203','5064'=>'56.21044','5095'=>'56.49119','5125'=>'56.76423','5156'=>'57.02954',
				'5186'=>'57.28708','5216'=>'57.53687','5247'=>'57.77893','5277'=>'58.01327','5308'=>'58.23994','5338'=>'58.45903','5369'=>'58.67061','5399'=>'58.87477','5429'=>'59.07164','5460'=>'59.26135','5490'=>'59.44404','5521'=>'59.61988',
				'5551'=>'59.78905','5581'=>'59.95173','5612'=>'60.10814','5642'=>'60.2585','5673'=>'60.40303','5703'=>'60.54199','5734'=>'60.67562','5764'=>'60.8042','5794'=>'60.928','5825'=>'61.04731','5855'=>'61.16241','5886'=>'61.2736','5916'=>'61.3812',
				'5946'=>'61.48549','5977'=>'61.58681','6007'=>'61.68546','6038'=>'61.78176','6068'=>'61.87602','6099'=>'61.96856','6129'=>'62.05968','6159'=>'62.1497','6190'=>'62.23891','6220'=>'62.32761','6251'=>'62.41609','6281'=>'62.50462',
				'6311'=>'62.59347','6342'=>'62.68289','6372'=>'62.77311','6403'=>'62.86437','6433'=>'62.95684','6464'=>'63.05073','6494'=>'63.1462','6524'=>'63.24336','6555'=>'63.34234','6585'=>'63.4432','6616'=>'63.546','6646'=>'63.65074','6676'=>'63.7574',
				'6707'=>'63.86593','6737'=>'63.9762','6768'=>'64.08808','6798'=>'64.20136','6829'=>'64.3158','6859'=>'64.4311','6889'=>'64.54692','6920'=>'64.66283','6950'=>'64.77838','6981'=>'64.89303','7011'=>'65.00619','7041'=>'65.1172','7072'=>'65.22534',
				'7102'=>'65.32981','7133'=>'65.42974','7163'=>'65.52419','7194'=>'65.61215','7224'=>'65.69252','7254'=>'65.76413','7285'=>'65.82574','7300'=>'65.85238');
		$percentile90Array=array('730'=>'13.93766','745'=>'14.03902','776'=>'14.24017','806'=>'14.43984','836'=>'14.63873','867'=>'14.83743','897'=>'15.03646','928'=>'15.23626','958'=>'15.43719','989'=>'15.63957','1019'=>'15.84365','1049'=>'16.04963','1080'=>'16.25767',
				'1110'=>'16.46789','1141'=>'16.68038','1171'=>'16.89519','1201'=>'17.11235','1232'=>'17.33186','1262'=>'17.55371','1293'=>'17.77788','1323'=>'18.00432','1354'=>'18.23298','1384'=>'18.46379','1414'=>'18.69671','1445'=>'18.93166',
				'1475'=>'19.16858','1506'=>'19.40739','1536'=>'19.64805','1566'=>'19.89048','1597'=>'20.13464','1627'=>'20.38048','1658'=>'20.62795','1688'=>'20.87704','1719'=>'21.1277','1749'=>'21.37993','1779'=>'21.63373','1810'=>'21.88909','1840'=>'22.14604',
				'1871'=>'22.4046','1901'=>'22.6648','1931'=>'22.92668','1962'=>'23.19031','1992'=>'23.45574','2023'=>'23.72305','2053'=>'23.99232','2084'=>'24.26364','2114'=>'24.5371','2144'=>'24.81282','2175'=>'25.09089','2205'=>'25.37145',
				'2236'=>'25.65461','2266'=>'25.94051','2296'=>'26.22926','2327'=>'26.52102','2357'=>'26.81591','2388'=>'27.11407','2418'=>'27.41566','2449'=>'27.7208','2479'=>'28.02965','2509'=>'28.34233','2540'=>'28.659','2570'=>'28.97979','2601'=>'29.30484',
				'2631'=>'29.63426','2661'=>'29.9682','2692'=>'30.30677','2722'=>'30.65008','2753'=>'30.99825','2783'=>'31.35137','2814'=>'31.70954','2844'=>'32.07286','2874'=>'32.44138','2905'=>'32.8152','2935'=>'33.19435','2966'=>'33.5789','2996'=>'33.96887',
				'3026'=>'34.36431','3057'=>'34.76522','3087'=>'35.17161','3118'=>'35.58347','3148'=>'36.00078','3179'=>'36.42352','3209'=>'36.85164','3239'=>'37.28507','3270'=>'37.72376','3300'=>'38.16762','3331'=>'38.61656','3361'=>'39.07046','3391'=>'39.52921',
				'3422'=>'39.99268','3452'=>'40.46071','3483'=>'40.93316','3513'=>'41.40984','3544'=>'41.89057','3574'=>'42.37517','3604'=>'42.86342','3635'=>'43.35511','3665'=>'43.85001','3696'=>'44.34788','3726'=>'44.84847','3756'=>'45.35152','3787'=>'45.85676',
				'3817'=>'46.36392','3848'=>'46.87271','3878'=>'47.38283','3909'=>'47.894','3939'=>'48.40589','3969'=>'48.9182','4000'=>'49.43061','4030'=>'49.9428','4061'=>'50.45443','4091'=>'50.96519','4121'=>'51.47473','4152'=>'51.98272','4182'=>'52.48882',
				'4213'=>'52.9927','4243'=>'53.49402','4274'=>'53.99244','4304'=>'54.48762','4334'=>'54.97925','4365'=>'55.46697','4395'=>'55.95048','4426'=>'56.42944','4456'=>'56.90354','4486'=>'57.37247','4517'=>'57.83593','4547'=>'58.29361','4578'=>'58.74524',
				'4608'=>'59.19053','4639'=>'59.62921','4669'=>'60.06103','4699'=>'60.48572','4730'=>'60.90306','4760'=>'61.31281','4791'=>'61.71477','4821'=>'62.10874','4851'=>'62.49452','4882'=>'62.87195','4912'=>'63.24088','4943'=>'63.60115','4973'=>'63.95264',
				'5004'=>'64.29525','5034'=>'64.62889','5064'=>'64.95347','5095'=>'65.26895','5125'=>'65.57527','5156'=>'65.87243','5186'=>'66.16042','5216'=>'66.43925','5247'=>'66.70897','5277'=>'66.96961','5308'=>'67.22127','5338'=>'67.46402','5369'=>'67.69798',
				'5399'=>'67.92327','5429'=>'68.14006','5460'=>'68.3485','5490'=>'68.54877','5521'=>'68.74109','5551'=>'68.92566','5581'=>'69.10273','5612'=>'69.27255','5642'=>'69.43538','5673'=>'69.59151','5703'=>'69.74124','5734'=>'69.88487','5764'=>'70.02272',
				'5794'=>'70.15513','5825'=>'70.28244','5855'=>'70.40499','5886'=>'70.52314','5916'=>'70.63725','5946'=>'70.7477','5977'=>'70.85484','6007'=>'70.95905','6038'=>'71.06071','6068'=>'71.16017','6099'=>'71.2578',
				'6129'=>'71.35395','6159'=>'71.44899','6190'=>'71.54326','6220'=>'71.63707','6251'=>'71.73076','6281'=>'71.82463','6311'=>'71.91896','6342'=>'72.01403','6372'=>'72.11008','6403'=>'72.20733','6433'=>'72.306','6464'=>'72.40626',
				'6494'=>'72.50825','6524'=>'72.61209','6555'=>'72.71787','6585'=>'72.82563','6616'=>'72.9354','6646'=>'73.04714','6676'=>'73.1608','6707'=>'73.27626','6737'=>'73.39338','6768'=>'73.51197','6798'=>'73.63178','6829'=>'73.75253',
				'6859'=>'73.87389','6889'=>'73.99546','6920'=>'74.1168','6950'=>'74.23744','6981'=>'74.35682','7011'=>'74.47435','7041'=>'74.58939','7072'=>'74.70121','7102'=>'74.80907','7133'=>'74.91215','7163'=>'75.00958','7194'=>'75.10041','7224'=>'75.18367',
				'7254'=>'75.25831','7285'=>'75.32321','7300'=>'75.35165');
		$percentile95Array=array('730'=>'14.56636','745'=>'14.67659','776'=>'14.89587','806'=>'15.11428','836'=>'15.33249','867'=>'15.55113','897'=>'15.7707','928'=>'15.99164','958'=>'16.21432','989'=>'16.43904','1019'=>'16.66605','1049'=>'16.89553','1080'=>'17.12762',
				'1110'=>'17.36244','1141'=>'17.60006','1171'=>'17.8405','1201'=>'18.08377','1232'=>'18.32988','1262'=>'18.57877','1293'=>'18.83042','1323'=>'19.08475','1354'=>'19.34169','1384'=>'19.60118','1414'=>'19.86313',
				'1445'=>'20.12746','1475'=>'20.39409','1506'=>'20.66293','1536'=>'20.93393','1566'=>'21.20699','1597'=>'21.48207','1627'=>'21.7591','1658'=>'22.03803','1688'=>'22.31884','1719'=>'22.60148','1749'=>'22.88594','1779'=>'23.17222',
				'1810'=>'23.46031','1840'=>'23.75024','1871'=>'24.04202','1901'=>'24.3357','1931'=>'24.63133','1962'=>'24.92897','1992'=>'25.22868','2023'=>'25.53055','2053'=>'25.83467','2084'=>'26.14113','2114'=>'26.45005','2144'=>'26.76154','2175'=>'27.07573','2205'=>'27.39274',
				'2236'=>'27.71272','2266'=>'28.0358','2296'=>'28.36213','2327'=>'28.69185','2357'=>'29.02513','2388'=>'29.36212','2418'=>'29.70296','2449'=>'30.04782','2479'=>'30.39685','2509'=>'30.75021','2540'=>'31.10804','2570'=>'31.47049','2601'=>'31.83771',
				'2631'=>'32.20984','2661'=>'32.58701','2692'=>'32.96935','2722'=>'33.35698','2753'=>'33.75001','2783'=>'34.14856','2814'=>'34.55271','2844'=>'34.96256','2874'=>'35.37818','2905'=>'35.79964','2935'=>'36.22699','2966'=>'36.66029','2996'=>'37.09956',
				'3026'=>'37.54482','3057'=>'37.99609','3087'=>'38.45335','3118'=>'38.91658','3148'=>'39.38577','3179'=>'39.86086','3209'=>'40.34179','3239'=>'40.82849','3270'=>'41.32088','3300'=>'41.81885','3331'=>'42.32229','3361'=>'42.83107','3391'=>'43.34505','3422'=>'43.86408',
				'3452'=>'44.38798','3483'=>'44.91658','3513'=>'45.44968','3544'=>'45.98708','3574'=>'46.52854','3604'=>'47.07385','3635'=>'47.62276','3665'=>'48.17501','3696'=>'48.73033','3726'=>'49.28846','3756'=>'49.84911','3787'=>'50.41198',
				'3817'=>'50.97677','3848'=>'51.54317','3878'=>'52.11086','3909'=>'52.67951','3939'=>'53.2488','3969'=>'53.81837','4000'=>'54.3879','4030'=>'54.95703','4061'=>'55.52542','4091'=>'56.09271','4121'=>'56.65855','4152'=>'57.22257','4182'=>'57.78443',
				'4213'=>'58.34376','4243'=>'58.90022','4274'=>'59.45344','4304'=>'60.00308','4334'=>'60.54878','4365'=>'61.0902','4395'=>'61.62701','4426'=>'62.15887','4456'=>'62.68544','4486'=>'63.20642','4517'=>'63.72148',
				'4547'=>'64.23032','4578'=>'64.73264','4608'=>'65.22816','4639'=>'65.71661','4669'=>'66.19771','4699'=>'66.67121','4730'=>'67.13688','4760'=>'67.59448','4791'=>'68.04379','4821'=>'68.48463','4851'=>'68.91679','4882'=>'69.34011',
				'4912'=>'69.75442','4943'=>'70.1596','4973'=>'70.5555','5004'=>'70.94203','5034'=>'71.31908','5064'=>'71.68659','5095'=>'72.04449','5125'=>'72.39275','5156'=>'72.73133','5186'=>'73.06023','5216'=>'73.37946','5247'=>'73.68906','5277'=>'73.98906',
				'5308'=>'74.27953','5338'=>'74.56056','5369'=>'74.83223','5399'=>'75.09468','5429'=>'75.34802','5460'=>'75.59243','5490'=>'75.82805','5521'=>'76.05507','5551'=>'76.2737','5581'=>'76.48415','5612'=>'76.68664','5642'=>'76.88142','5673'=>'77.06875',
				'5703'=>'77.2489','5734'=>'77.42214','5764'=>'77.58878','5794'=>'77.74911','5825'=>'77.90345','5855'=>'78.05211','5886'=>'78.19542','5916'=>'78.33372','5946'=>'78.46734','5977'=>'78.59661','6007'=>'78.72189','6038'=>'78.84351','6068'=>'78.96181',
				'6099'=>'79.07713','6129'=>'79.18979','6159'=>'79.30012','6190'=>'79.40845','6220'=>'79.51506','6251'=>'79.62027','6281'=>'79.72434','6311'=>'79.82755','6342'=>'79.93015','6372'=>'80.03235','6403'=>'80.13439','6433'=>'80.23643','6464'=>'80.33866',
				'6494'=>'80.4412','6524'=>'80.54417','6555'=>'80.64766','6585'=>'80.75172','6616'=>'80.85638','6646'=>'80.96163','6676'=>'81.06744','6707'=>'81.17373','6737'=>'81.28039','6768'=>'81.3873','6798'=>'81.49427','6829'=>'81.60109','6859'=>'81.70752','6889'=>'81.81326',
				'6920'=>'81.91801','6950'=>'82.02139','6981'=>'82.12303','7011'=>'82.22248','7041'=>'82.31928','7072'=>'82.41292','7102'=>'82.50285','7133'=>'82.58851','7163'=>'82.66927','7194'=>'82.74448','7224'=>'82.81345','7254'=>'82.87546','7285'=>'82.92975','7300'=>'82.95375');
		$percentile97Array=array('730'=>'15.00156','745'=>'15.11839','776'=>'15.35122','806'=>'15.58363','836'=>'15.81632','867'=>'16.0499','897'=>'16.28491','928'=>'16.52176','958'=>'16.76085','989'=>'17.00245','1019'=>'17.24681','1049'=>'17.49412','1080'=>'17.7445','1110'=>'17.99807','1141'=>'18.25487',
				'1171'=>'18.51494','1201'=>'18.77826','1232'=>'19.04483','1262'=>'19.31458','1293'=>'19.58748','1323'=>'19.86343','1354'=>'20.14237','1384'=>'20.4242','1414'=>'20.70884','1445'=>'20.99619',
				'1475'=>'21.28616','1506'=>'21.57866','1536'=>'21.8736','1566'=>'22.1709','1597'=>'22.4705','1627'=>'22.77232','1658'=>'23.07631','1688'=>'23.38243','1719'=>'23.69063','1749'=>'24.0009','1779'=>'24.31322','1810'=>'24.62758','1840'=>'24.94401',
				'1871'=>'25.26252','1901'=>'25.58315','1931'=>'25.90595','1962'=>'26.23096','1992'=>'26.55827','2023'=>'26.88796','2053'=>'27.2201','2084'=>'27.55481','2114'=>'27.8922','2144'=>'28.23237','2175'=>'28.57547','2205'=>'28.92162','2236'=>'29.27096',
				'2266'=>'29.62364','2296'=>'29.97981','2327'=>'30.33962','2357'=>'30.70323','2388'=>'31.0708','2418'=>'31.44249','2449'=>'31.81846','2479'=>'32.19887','2509'=>'32.58389','2540'=>'32.97366','2570'=>'33.36833','2601'=>'33.76807',
				'2631'=>'34.17302','2661'=>'34.5833','2692'=>'34.99906','2722'=>'35.42042','2753'=>'35.8475','2783'=>'36.2804','2814'=>'36.71922','2844'=>'37.16406','2874'=>'37.61498','2905'=>'38.07207','2935'=>'38.53537','2966'=>'39.00492','2996'=>'39.48077','3026'=>'39.96292','3057'=>'40.45138',
				'3087'=>'40.94614','3118'=>'41.44718','3148'=>'41.95447','3179'=>'42.46794','3209'=>'42.98755','3239'=>'43.5132','3270'=>'44.0448','3300'=>'44.58226','3331'=>'45.12543','3361'=>'45.67419','3391'=>'46.22839','3422'=>'46.78786','3452'=>'47.35242','3483'=>'47.92187','3513'=>'48.49603',
				'3544'=>'49.07465','3574'=>'49.65753','3604'=>'50.2444','3635'=>'50.83502','3665'=>'51.42913','3696'=>'52.02644','3726'=>'52.62666','3756'=>'53.22951','3787'=>'53.83467','3817'=>'54.44183','3848'=>'55.05067','3878'=>'55.66086','3909'=>'56.27207','3939'=>'56.88395',
				'3969'=>'57.49615','4000'=>'58.10833','4030'=>'58.72013','4061'=>'59.33118','4091'=>'59.94114','4121'=>'60.54964','4152'=>'61.15631','4182'=>'61.7608','4213'=>'62.36274','4243'=>'62.96178','4274'=>'63.55756','4304'=>'64.14972','4334'=>'64.73791','4365'=>'65.32179','4395'=>'65.90103',
				'4426'=>'66.47528','4456'=>'67.04422','4486'=>'67.60754','4517'=>'68.16491','4547'=>'68.71605','4578'=>'69.26067','4608'=>'69.79847','4639'=>'70.32919','4669'=>'70.85258','4699'=>'71.36839','4730'=>'71.87638','4760'=>'72.37633','4791'=>'72.86804','4821'=>'73.35131','4851'=>'73.82597',
				'4882'=>'74.29185','4912'=>'74.7488','4943'=>'75.19669','4973'=>'75.6354','5004'=>'76.06483','5034'=>'76.48488','5064'=>'76.89549','5095'=>'77.2966','5125'=>'77.68817','5156'=>'78.07017','5186'=>'78.44259','5216'=>'78.80544','5247'=>'79.15873','5277'=>'79.50251','5308'=>'79.83682','5338'=>'80.16173',
				'5369'=>'80.4773','5399'=>'80.78364','5429'=>'81.08083','5460'=>'81.36901','5490'=>'81.6483','5521'=>'81.91883','5551'=>'82.18076','5581'=>'82.43425','5612'=>'82.67946','5642'=>'82.91657','5673'=>'83.14578','5703'=>'83.36727','5734'=>'83.58126','5764'=>'83.78795','5794'=>'83.98755','5825'=>'84.18029',
				'5855'=>'84.36639','5886'=>'84.54608','5916'=>'84.7196','5946'=>'84.88718','5977'=>'85.04905','6007'=>'85.20546','6038'=>'85.35663','6068'=>'85.50282','6099'=>'85.64425','6129'=>'85.78117','6159'=>'85.91379','6190'=>'86.04235','6220'=>'86.16706','6251'=>'86.28815','6281'=>'86.40583','6311'=>'86.52029',
				'6342'=>'86.63173','6372'=>'86.74034','6403'=>'86.84629','6433'=>'86.94976','6464'=>'87.05088','6494'=>'87.14981','6524'=>'87.24667','6555'=>'87.34157','6585'=>'87.43462','6616'=>'87.5259','6646'=>'87.61548','6676'=>'87.70342','6707'=>'87.78975','6737'=>'87.87449','6768'=>'87.95764','6798'=>'88.03918',
				'6829'=>'88.11907','6859'=>'88.19726','6889'=>'88.27366','6920'=>'88.34817','6950'=>'88.42066','6981'=>'88.491','7011'=>'88.55903','7041'=>'88.62455','7072'=>'88.68734','7102'=>'88.74718','7133'=>'88.80382','7163'=>'88.85697',
				'7194'=>'88.90635','7224'=>'88.95164','7254'=>'88.99253','7285'=>'89.02867','7300'=>'89.04485');
		//end of array
		$this->set(compact('percentile3Array','percentile5Array','percentile10Array','percentile25Array','percentile50Array','percentile75Array','percentile85Array','percentile90Array','percentile95Array','percentile97Array'));
		$this->set('diagnosis',$diagnosis);
		$this->set('bmi_array',$bmi_Day);
		$this->set(compact('year','month','date','patient_name'));
	}
	public function bmi_weightforage_male($id=null) {

		$this->layout=false;
		$this->set('title_for_layout', __('Growth Chart', true));
		$this->uses = array('Patient','BmiResult','ReviewPatientDetail');
		//Getting data For OPD patient
		$this->Patient->bindModel( array(
				'belongsTo' => array(
						'BmiResult'=>array('conditions'=>array('BmiResult.patient_id=Patient.id'),'foreignKey'=>false),
						'Person'=>array('conditions'=>array('Person.id=Patient.person_id'),'foreignKey'=>false)
				)
		));

		$diagnosis = $this->Patient->find('all',array('fields'=>array('BmiResult.height,BmiResult.weight,BmiResult.weight_volume,BmiResult.weight_result,BmiResult.bmi,BmiResult.patient_id,BmiResult.created_time,
				Patient.age,Patient.admission_type,Person.sex,Person.dob,Patient.lookup_name'),'conditions'=>array('Patient.person_id'=>$id,'Patient.is_deleted'=>0,'Patient.admission_type'=>'OPD'),'order' => array('Patient.id' => 'asc')));
		foreach($diagnosis as $data)
		{
			$var=$this->DateFormat->dateDiff($data['Person']['dob'],$data['BmiResult']['created_time']);
			$day=$var->days;
			$year[$day]=$var->y;
			$month[$day]=$var->m;
			$date[$day]=$data['BmiResult']['created_time'];
			$patient_name=$data['Patient']['lookup_name'];
			//Weight should be in "KG ONLY"
			if($data['BmiResult']['weight_volume']=='Kg')
			{
				$bmi_Day[$day][]=$data['BmiResult']['weight'];

			}
			elseif(strtolower($data['BmiResult']['weight_volume'])=='lbs')
			{
				$weight=explode(" ",$data['BmiResult']['weight_result']);
				$bmi_Day[$day][]=$weight[0];

			}
		}
		//Getting Dta for IPD patient
		$this->Patient->bindModel(array(
				'belongsTo'=>array(
						'ReviewPatientDetail'=>array('conditions'=>array('ReviewPatientDetail.patient_id=Patient.id'),'foreignKey'=>false),
						'ReviewSubCategoriesOption'=>array(
								'conditions'=>array('ReviewSubCategoriesOption.name LIKE'=>"%".Configure::read('bmi_weight_measured')."%"),'foreignKey'=>false),
						'Person'=>array('conditions'=>array('Person.id=Patient.person_id'),'foreignKey'=>false)
				)));
		$diagnosis1 = $this->Patient->find('all',array('fields'=>array('ReviewPatientDetail.values,ReviewPatientDetail.date,
				Patient.age,Patient.admission_type,Person.sex,Person.dob,Patient.lookup_name,ReviewSubCategoriesOption.id'),
				'conditions'=>array('Patient.person_id'=>$id,'ReviewSubCategoriesOption.id=ReviewPatientDetail.review_sub_categories_options_id','Patient.is_deleted'=>0,'ReviewPatientDetail.edited_on IS NULL','Patient.admission_type'=>'IPD'),'order' => array('Patient.id' => 'asc')));
			
			
		foreach($diagnosis1 as $data)
		{
			$var=$this->DateFormat->dateDiff($data['Person']['dob'],$data['ReviewPatientDetail']['date']);
			$day=$var->days;
			$year[$day]=$var->y;
			$date[$day]=$data['ReviewPatientDetail']['date'];
			$patient_name=$data['Patient']['lookup_name'];
			$month[$day]=$var->m;
			$bmi_Day[$day][]=$data['ReviewPatientDetail']['values'];
		}

		//array for setting standard data lines
		$percentile3Array=array('730'=>'10.38209','745'=>'10.44144','776'=>'10.55847','806'=>'10.6738','836'=>'10.78798','867'=>'10.90147','897'=>'11.01466','928'=>'11.12787','958'=>'11.24135','989'=>'11.3553','1019'=>'11.46988','1049'=>'11.58521','1080'=>'11.70137','1110'=>'11.81842','1141'=>'11.93639','1171'=>'12.05529','1201'=>'12.17512',
				'1232'=>'12.29587','1262'=>'12.41751','1293'=>'12.54001','1323'=>'12.66334','1354'=>'12.78746','1384'=>'12.91234','1414'=>'13.03792','1445'=>'13.16419','1475'=>'13.29111','1506'=>'13.41864','1536'=>'13.54675','1566'=>'13.67543','1597'=>'13.80466','1627'=>'13.93441','1658'=>'14.06467','1688'=>'14.19544','1719'=>'14.32672','1749'=>'14.4585',
				'1779'=>'14.59079','1810'=>'14.72359','1840'=>'14.85692','1871'=>'14.99078','1901'=>'15.1252','1931'=>'15.26018','1962'=>'15.39575','1992'=>'15.53193','2023'=>'15.66872','2053'=>'15.80617','2084'=>'15.94427','2114'=>'16.08306','2144'=>'16.22255','2175'=>'16.36276','2205'=>'16.5037','2236'=>'16.64539','2266'=>'16.78785',
				'2296'=>'16.93107','2327'=>'17.07507','2357'=>'17.21986','2388'=>'17.36543','2418'=>'17.5118','2449'=>'17.65895','2479'=>'17.80689','2509'=>'17.9556','2540'=>'18.10509','2570'=>'18.25535','2601'=>'18.40637','2631'=>'18.55813','2661'=>'18.71062','2692'=>'18.86385','2722'=>'19.01778',
				'2753'=>'19.17243','2783'=>'19.32776','2814'=>'19.48379','2844'=>'19.6405','2874'=>'19.79788','2905'=>'19.95594','2935'=>'20.11467','2966'=>'20.27408','2996'=>'20.43418','3026'=>'20.59497','3057'=>'20.75647','3087'=>'20.91869','3118'=>'21.08166','3148'=>'21.2454','3179'=>'21.40994',
				'3209'=>'21.57532','3239'=>'21.74156','3270'=>'21.90873','3300'=>'22.07685','3331'=>'22.24599','3361'=>'22.4162','3391'=>'22.58754','3422'=>'22.76008','3452'=>'22.93388','3483'=>'23.10902','3513'=>'23.28558','3544'=>'23.46364','3574'=>'23.64329','3604'=>'23.8246',
				'3635'=>'24.00769','3665'=>'24.19264','3696'=>'24.37956','3726'=>'24.56855','3756'=>'24.75971','3787'=>'24.95315','3817'=>'25.14898','3848'=>'25.34731','3878'=>'25.54826','3909'=>'25.75195','3939'=>'25.95847','3969'=>'26.16796','4000'=>'26.38051','4030'=>'26.59626','4061'=>'26.81531',
				'4091'=>'27.03777','4121'=>'27.26376','4152'=>'27.49337','4182'=>'27.72672','4213'=>'27.9639','4243'=>'28.20501','4274'=>'28.45015','4304'=>'28.69939','4334'=>'28.95283','4365'=>'29.21053','4395'=>'29.47257','4426'=>'29.739','4456'=>'30.00988','4486'=>'30.28525','4517'=>'30.56516','4547'=>'30.84962',
				'4578'=>'31.13865','4608'=>'31.43227','4639'=>'31.73046','4669'=>'32.03321','4699'=>'32.3405','4730'=>'32.65229','4760'=>'32.96852','4791'=>'33.28913','4821'=>'33.61404','4851'=>'33.94317','4882'=>'34.27642','4912'=>'34.61365','4943'=>'34.95475','4973'=>'35.29956','5004'=>'35.64794','5034'=>'35.99969',
				'5064'=>'36.35464','5095'=>'36.71259','5125'=>'37.07331','5156'=>'37.43658','5186'=>'37.80215','5216'=>'38.16976','5247'=>'38.53916','5277'=>'38.91004','5308'=>'39.28212','5338'=>'39.65509','5369'=>'40.02863','5399'=>'40.40241','5429'=>'40.77608','5460'=>'41.14932','5490'=>'41.52175','5521'=>'41.89302',
				'5551'=>'42.26275','5581'=>'42.63058','5612'=>'42.99612','5642'=>'43.35899','5673'=>'43.71882','5703'=>'44.07523','5734'=>'44.42784','5764'=>'44.77629','5794'=>'45.1202','5825'=>'45.45922','5855'=>'45.79301','5886'=>'46.12122','5916'=>'46.44354','5946'=>'46.75967','5977'=>'47.06932','6007'=>'47.37223',
				'6038'=>'47.66815','6068'=>'47.95687','6099'=>'48.23819','6129'=>'48.51195','6159'=>'48.778','6190'=>'49.03625','6220'=>'49.28662','6251'=>'49.52905','6281'=>'49.76354','6311'=>'49.9901','6342'=>'50.2088','6372'=>'50.4197','6403'=>'50.62293','6433'=>'50.81862','6464'=>'51.00695','6494'=>'51.18811','6524'=>'51.36232','6555'=>'51.52982',
				'6585'=>'51.69086','6616'=>'51.84574','6646'=>'51.99472','6676'=>'52.13808','6707'=>'52.27612','6737'=>'52.40911','6768'=>'52.53731','6798'=>'52.66098','6829'=>'52.78032','6859'=>'52.89553','6889'=>'53.00674','6920'=>'53.11402','6950'=>'53.21739','6981'=>'53.31679','7011'=>'53.41207','7041'=>'53.50297','7072'=>'53.58913',
				'7102'=>'53.67003','7133'=>'53.74501','7163'=>'53.81325','7194'=>'53.87373','7224'=>'53.92519','7254'=>'53.96614','7285'=>'53.99482','7300'=>'54.00392');
		$percentile5Array=array('730'=>'10.64009','745'=>'10.70051','776'=>'10.81958','806'=>'10.93681','836'=>'11.0528','867'=>'11.16803','897'=>'11.28293','928'=>'11.39782','958'=>'11.513','989'=>'11.62869',
				'1019'=>'11.74508','1049'=>'11.8623','1080'=>'11.98046','1110'=>'12.09962','1141'=>'12.21984','1171'=>'12.34115','1201'=>'12.46354','1232'=>'12.58701','1262'=>'12.71154','1293'=>'12.8371','1323'=>'12.96366','1354'=>'13.09119','1384'=>'13.21963',
				'1414'=>'13.34895','1445'=>'13.47911','1475'=>'13.61006','1506'=>'13.74176','1536'=>'13.87418','1566'=>'14.00727','1597'=>'14.14102','1627'=>'14.2754','1658'=>'14.41037','1688'=>'14.54593','1719'=>'14.68205','1749'=>'14.81872','1779'=>'14.95595',
				'1810'=>'15.09371','1840'=>'15.23202','1871'=>'15.37087','1901'=>'15.51027','1931'=>'15.65023','1962'=>'15.79076','1992'=>'15.93186','2023'=>'16.07356','2053'=>'16.21586','2084'=>'16.35879','2114'=>'16.50235','2144'=>'16.64657','2175'=>'16.79146','2205'=>'16.93704',
				'2236'=>'17.08332','2266'=>'17.23031','2296'=>'17.37804','2327'=>'17.52651','2357'=>'17.67574','2388'=>'17.82572','2418'=>'17.97649','2449'=>'18.12803','2479'=>'18.28036','2509'=>'18.43348','2540'=>'18.5874','2570'=>'18.74211','2601'=>'18.89763','2631'=>'19.05395','2661'=>'19.21107',
				'2692'=>'19.369','2722'=>'19.52773','2753'=>'19.68727','2783'=>'19.84762','2814'=>'20.00878','2844'=>'20.17076','2874'=>'20.33357','2905'=>'20.4972','2935'=>'20.66168','2966'=>'20.82702','2996'=>'20.99322','3026'=>'21.16032','3057'=>'21.32832','3087'=>'21.49726',
				'3118'=>'21.66716','3148'=>'21.83805','3179'=>'22.00997','3209'=>'22.18296','3239'=>'22.35705','3270'=>'22.5323','3300'=>'22.70876','3331'=>'22.88648','3361'=>'23.06551','3391'=>'23.24593','3422'=>'23.42779','3452'=>'23.61117',
				'3483'=>'23.79613','3513'=>'23.98277','3544'=>'24.17115','3574'=>'24.36137','3604'=>'24.55351','3635'=>'24.74766','3665'=>'24.94392','3696'=>'25.14238','3726'=>'25.34314','3756'=>'25.54631','3787'=>'25.75198','3817'=>'25.96027','3848'=>'26.17126','3878'=>'26.38509',
				'3909'=>'26.60184','3939'=>'26.82163','3969'=>'27.04457','4000'=>'27.27076','4030'=>'27.50031','4061'=>'27.73332','4091'=>'27.96989','4121'=>'28.21013','4152'=>'28.45412','4182'=>'28.70197','4213'=>'28.95376','4243'=>'29.20958','4274'=>'29.4695','4304'=>'29.7336',
				'4334'=>'30.00195','4365'=>'30.2746','4395'=>'30.55162','4426'=>'30.83304','4456'=>'31.11891','4486'=>'31.40925','4517'=>'31.70409','4547'=>'32.00343','4578'=>'32.30727','4608'=>'32.61561','4639'=>'32.92842','4669'=>'33.24567',
				'4699'=>'33.56731','4730'=>'33.89329','4760'=>'34.22353','4791'=>'34.55796','4821'=>'34.89647','4851'=>'35.23896','4882'=>'35.58531','4912'=>'35.93538','4943'=>'36.28902','4973'=>'36.64606','5004'=>'37.00634','5034'=>'37.36965','5064'=>'37.7358','5095'=>'38.10456',
				'5125'=>'38.47571','5156'=>'38.849','5186'=>'39.22417','5216'=>'39.60097','5247'=>'39.97909','5277'=>'40.35826','5308'=>'40.73817','5338'=>'41.11851','5369'=>'41.49895','5399'=>'41.87917','5429'=>'42.25882','5460'=>'42.63757','5490'=>'43.01506','5521'=>'43.39093','5551'=>'43.76482',
				'5581'=>'44.13638','5612'=>'44.50523','5642'=>'44.87102','5673'=>'45.23338','5703'=>'45.59196','5734'=>'45.9464','5764'=>'46.29635','5794'=>'46.64147','5825'=>'46.98144','5855'=>'47.31593','5886'=>'47.64464','5916'=>'47.96727','5946'=>'48.28356','5977'=>'48.59325','6007'=>'48.89609',
				'6038'=>'49.19189','6068'=>'49.48044','6099'=>'49.76158','6129'=>'50.03518','6159'=>'50.30112','6190'=>'50.55931','6220'=>'50.80971','6251'=>'51.05229','6281'=>'51.28706','6311'=>'51.51404','6342'=>'51.73333','6372'=>'51.94499','6403'=>'52.14918','6433'=>'52.34603','6464'=>'52.53572','6494'=>'52.71847',
				'6524'=>'52.8945','6555'=>'53.06406','6585'=>'53.2274','6616'=>'53.38481','6646'=>'53.53657','6676'=>'53.68296','6707'=>'53.82428','6737'=>'53.96079','6768'=>'54.09278','6798'=>'54.22046','6829'=>'54.34408','6859'=>'54.46381','6889'=>'54.57977','6920'=>'54.69205',
				'6950'=>'54.80066','6981'=>'54.90552','7011'=>'55.00648','7041'=>'55.10328','7072'=>'55.19552','7102'=>'55.2827','7133'=>'55.36413','7163'=>'55.43897','7194'=>'55.50617','7224'=>'55.56447','7254'=>'55.61236','7285'=>'55.64807','7300'=>'55.66071');
		$percentile10Array=array('730'=>'11.05266','745'=>'11.1149','776'=>'11.23747','806'=>'11.35806','836'=>'11.47728','867'=>'11.59567','897'=>'11.71368','928'=>'11.8317','958'=>'11.95005','989'=>'12.069','1019'=>'12.18875','1049'=>'12.30948','1080'=>'12.43132','1110'=>'12.55436','1141'=>'12.67868','1171'=>'12.80431','1201'=>'12.93128',
				'1232'=>'13.05959','1262'=>'13.18923','1293'=>'13.32017','1323'=>'13.45238','1354'=>'13.58581','1384'=>'13.72043','1414'=>'13.85618','1445'=>'13.99301','1475'=>'14.13086','1506'=>'14.26968','1536'=>'14.40943','1566'=>'14.55004','1597'=>'14.69148','1627'=>'14.8337','1658'=>'14.97666','1688'=>'15.12032','1719'=>'15.26465','1749'=>'15.40962',
				'1779'=>'15.55521','1810'=>'15.70139','1840'=>'15.84814','1871'=>'15.99546','1901'=>'16.14334','1931'=>'16.29176','1962'=>'16.44074','1992'=>'16.59026','2023'=>'16.74033','2053'=>'16.89096','2084'=>'17.04215','2114'=>'17.19393','2144'=>'17.34629','2175'=>'17.49926','2205'=>'17.65285','2236'=>'17.80708','2266'=>'17.96197',
				'2296'=>'18.11754','2327'=>'18.2738','2357'=>'18.43077','2388'=>'18.58848','2418'=>'18.74695','2449'=>'18.9062','2479'=>'19.06624','2509'=>'19.2271','2540'=>'19.3888','2570'=>'19.55136','2601'=>'19.71479','2631'=>'19.87913','2661'=>'20.04438','2692'=>'20.21057','2722'=>'20.37771','2753'=>'20.54584','2783'=>'20.71496',
				'2814'=>'20.88511','2844'=>'21.05629','2874'=>'21.22855','2905'=>'21.4019','2935'=>'21.57637','2966'=>'21.75198','2996'=>'21.92878','3026'=>'22.10678','3057'=>'22.28602','3087'=>'22.46654','3118'=>'22.64838','3148'=>'22.83157','3179'=>'23.01617','3209'=>'23.20222','3239'=>'23.38976','3270'=>'23.57885','3300'=>'23.76955',
				'3331'=>'23.96192','3361'=>'24.15601','3391'=>'24.35189','3422'=>'24.54962','3452'=>'24.74929','3483'=>'24.95096','3513'=>'25.1547','3544'=>'25.3606','3574'=>'25.56874','3604'=>'25.77921','3635'=>'25.99208','3665'=>'26.20745','3696'=>'26.42541','3726'=>'26.64604','3756'=>'26.86945','3787'=>'27.09573','3817'=>'27.32496','3848'=>'27.55726',
				'3878'=>'27.7927','3909'=>'28.0314','3939'=>'28.27343','3969'=>'28.51891','4000'=>'28.76791','4030'=>'29.02052','4061'=>'29.27685','4091'=>'29.53696','4121'=>'29.80095','4152'=>'30.06888','4182'=>'30.34084','4213'=>'30.61689','4243'=>'30.8971','4274'=>'31.18151','4304'=>'31.4702','4334'=>'31.76319','4365'=>'32.06052','4395'=>'32.36224','4426'=>'32.66834',
				'4456'=>'32.97885','4486'=>'33.29378','4517'=>'33.6131','4547'=>'33.93681','4578'=>'34.26488','4608'=>'34.59726','4639'=>'34.93391','4669'=>'35.27477','4699'=>'35.61976','4730'=>'35.96879','4760'=>'36.32176','4791'=>'36.67857','4821'=>'37.03908','4851'=>'37.40317','4882'=>'37.77067','4912'=>'38.14143',
				'4943'=>'38.51526','4973'=>'38.89198','5004'=>'39.27138','5034'=>'39.65325','5064'=>'40.03736','5095'=>'40.42347','5125'=>'40.81133','5156'=>'41.20067','5186'=>'41.59121','5216'=>'41.98269','5247'=>'42.37479','5277'=>'42.76722','5308'=>'43.15967','5338'=>'43.55182','5369'=>'43.94334','5399'=>'44.3339','5429'=>'44.72317',
				'5460'=>'45.1108','5490'=>'45.49646','5521'=>'45.8798','5551'=>'46.26048','5581'=>'46.63815','5612'=>'47.01247','5642'=>'47.3831','5673'=>'47.74972','5703'=>'48.11199','5734'=>'48.46959','5764'=>'48.82222','5794'=>'49.16956','5825'=>'49.51134','5855'=>'49.84727','5886'=>'50.17709','5916'=>'50.50055',
				'5946'=>'50.81743','5977'=>'51.12752','6007'=>'51.43062','6038'=>'51.72656','6068'=>'52.0152','6099'=>'52.29642','6129'=>'52.57011','6159'=>'52.8362','6190'=>'53.09465','6220'=>'53.34544','6251'=>'53.58858','6281'=>'53.82409','6311'=>'54.05205','6342'=>'54.27255','6372'=>'54.4857','6403'=>'54.69165','6433'=>'54.89058',
				'6464'=>'55.08267','6494'=>'55.26814','6524'=>'55.44723','6555'=>'55.6202','6585'=>'55.78731','6616'=>'55.94884','6646'=>'56.10508','6676'=>'56.25633','6707'=>'56.40286','6737'=>'56.54495','6768'=>'56.68288','6798'=>'56.81689','6829'=>'56.94719','6859'=>'57.07396','6889'=>'57.19732','6920'=>'57.31737','6950'=>'57.43409',
				'6981'=>'57.54742','7011'=>'57.6572','7041'=>'57.76315','7072'=>'57.86488','7102'=>'57.96187','7133'=>'58.05343','7163'=>'58.13869','7194'=>'58.21662','7224'=>'58.28594','7254'=>'58.34515','7285'=>'58.39247','7300'=>'58.41105');
		$percentile25Array=array('730'=>'11.78598','745'=>'11.85182','776'=>'11.98142','806'=>'12.10889','836'=>'12.23491','867'=>'12.36007','897'=>'12.4849','928'=>'12.60983','958'=>'12.73523','989'=>'12.86144','1019'=>'12.9887','1049'=>'13.11723','1080'=>'13.24721','1110'=>'13.37875','1141'=>'13.51197','1171'=>'13.64693','1201'=>'13.78366','1232'=>'13.92218','1262'=>'14.0625',
				'1293'=>'14.20458','1323'=>'14.3484','1354'=>'14.49391','1384'=>'14.64105','1414'=>'14.78977','1445'=>'14.93998','1475'=>'15.09163','1506'=>'15.24463','1536'=>'15.39892','1566'=>'15.55441','1597'=>'15.71103','1627'=>'15.86872','1658'=>'16.0274','1688'=>'16.18701','1719'=>'16.34748','1749'=>'16.50877','1779'=>'16.67081','1810'=>'16.83356',
				'1840'=>'16.99698','1871'=>'17.16103','1901'=>'17.32567','1931'=>'17.49088','1962'=>'17.65664','1992'=>'17.82293','2023'=>'17.98974','2053'=>'18.15706','2084'=>'18.32489','2114'=>'18.49324','2144'=>'18.66211','2175'=>'18.83151','2205'=>'19.00147','2236'=>'19.17199','2266'=>'19.34311','2296'=>'19.51485','2327'=>'19.68724','2357'=>'19.86032',
				'2388'=>'20.03413','2418'=>'20.20871','2449'=>'20.38409','2479'=>'20.56032','2509'=>'20.73745','2540'=>'20.91553','2570'=>'21.0946','2601'=>'21.27471','2631'=>'21.45592','2661'=>'21.63828','2692'=>'21.82185','2722'=>'22.00666','2753'=>'22.19278','2783'=>'22.38027','2814'=>'22.56917','2844'=>'22.75955','2874'=>'22.95145','2905'=>'23.14493','2935'=>'23.34005',
				'2966'=>'23.53686','2996'=>'23.73542','3026'=>'23.93579','3057'=>'24.13801','3087'=>'24.34216','3118'=>'24.54828','3148'=>'24.75645','3179'=>'24.9667','3209'=>'25.17912','3239'=>'25.39375','3270'=>'25.61067','3300'=>'25.82993','3331'=>'26.05161','3361'=>'26.27576','3391'=>'26.50246','3422'=>'26.73177','3452'=>'26.96376','3483'=>'27.19851',
				'3513'=>'27.43609','3544'=>'27.67657','3574'=>'27.92001','3604'=>'28.16651','3635'=>'28.41613','3665'=>'28.66894','3696'=>'28.92502','3726'=>'29.18446','3756'=>'29.44731','3787'=>'29.71365','3817'=>'29.98357','3848'=>'30.25713','3878'=>'30.53439','3909'=>'30.81543','3939'=>'31.10032','3969'=>'31.38912','4000'=>'31.68189','4030'=>'31.97868',
				'4061'=>'32.27955','4091'=>'32.58454','4121'=>'32.89371','4152'=>'33.20709','4182'=>'33.52472','4213'=>'33.84662','4243'=>'34.17281','4274'=>'34.5033','4304'=>'34.83811','4334'=>'35.17724','4365'=>'35.52066','4395'=>'35.86837','4426'=>'36.22034','4456'=>'36.57653','4486'=>'36.9369','4517'=>'37.30138','4547'=>'37.66991',
				'4578'=>'38.04241','4608'=>'38.4188','4639'=>'38.79897','4669'=>'39.18281','4699'=>'39.5702','4730'=>'39.96099','4760'=>'40.35506','4791'=>'40.75222','4821'=>'41.15232','4851'=>'41.55516','4882'=>'41.96056','4912'=>'42.3683','4943'=>'42.77818','4973'=>'43.18995','5004'=>'43.60337','5034'=>'44.01821','5064'=>'44.43419','5095'=>'44.85104','5125'=>'45.26849',
				'5156'=>'45.68625','5186'=>'46.10402','5216'=>'46.52151','5247'=>'46.9384','5277'=>'47.35437','5308'=>'47.76912','5338'=>'48.18232','5369'=>'48.59365','5399'=>'49.00279','5429'=>'49.40941','5460'=>'49.81318','5490'=>'50.21378','5521'=>'50.61091','5551'=>'51.00423','5581'=>'51.39346',
				'5612'=>'51.77827','5642'=>'52.15839','5673'=>'52.53352','5703'=>'52.90339','5734'=>'53.26773','5764'=>'53.6263','5794'=>'53.97886','5825'=>'54.32518','5855'=>'54.66505','5886'=>'54.99828','5916'=>'55.3247','5946'=>'55.64414','5977'=>'55.95647','6007'=>'56.26158','6038'=>'56.55935','6068'=>'56.84971','6099'=>'57.13261','6129'=>'57.408',
				'6159'=>'57.67589','6190'=>'57.93627','6220'=>'58.18918','6251'=>'58.43468','6281'=>'58.67285','6311'=>'58.9038','6342'=>'59.12764','6372'=>'59.34454','6403'=>'59.55466','6433'=>'59.75819','6464'=>'59.95536','6494'=>'60.14639','6524'=>'60.33153','6555'=>'60.51105','6585'=>'60.68521','6616'=>'60.85431','6646'=>'61.01862',
				'6676'=>'61.17846','6707'=>'61.33409','6737'=>'61.4858','6768'=>'61.63386','6798'=>'61.77851','6829'=>'61.91997','6859'=>'62.05842','6889'=>'62.19399','6920'=>'62.32678','6950'=>'62.4568','6981'=>'62.58399','7011'=>'62.70822','7041'=>'62.82922','7072'=>'62.94664','7102'=>'63.06','7133'=>'63.16863',
				'7163'=>'63.27175','7194'=>'63.36835','7224'=>'63.45727','7254'=>'63.53709','7285'=>'63.60618','7300'=>'63.63611');
		$percentile50Array=array('730'=>'12.67076','745'=>'12.74154','776'=>'12.88102','806'=>'13.01842','836'=>'13.1545','867'=>'13.2899','897'=>'13.42519','928'=>'13.56088','958'=>'13.69738','989'=>'13.83505',
				'1019'=>'13.97418','1049'=>'14.11503','1080'=>'14.2578','1110'=>'14.40263','1141'=>'14.54965','1171'=>'14.69893','1201'=>'14.85054','1232'=>'15.00449','1262'=>'15.16078','1293'=>'15.3194','1323'=>'15.4803','1354'=>'15.64343',
				'1384'=>'15.80873','1414'=>'15.9761','1445'=>'16.14548','1475'=>'16.31677','1506'=>'16.48986','1536'=>'16.66468','1566'=>'16.8411','1597'=>'17.01904','1627'=>'17.19839','1658'=>'17.37906','1688'=>'17.56096','1719'=>'17.744','1749'=>'17.92809',
				'1779'=>'18.11316','1810'=>'18.29912','1840'=>'18.48592','1871'=>'18.6735','1901'=>'18.8618','1931'=>'19.05077','1962'=>'19.24037','1992'=>'19.43058','2023'=>'19.62136','2053'=>'19.8127','2084'=>'20.00459','2114'=>'20.19703','2144'=>'20.39002',
				'2175'=>'20.58357','2205'=>'20.7777','2236'=>'20.97243','2266'=>'21.16779','2296'=>'21.36383','2327'=>'21.56058','2357'=>'21.75811','2388'=>'21.95645','2418'=>'22.15567','2449'=>'22.35584','2479'=>'22.55702','2509'=>'22.7593','2540'=>'22.96273','2570'=>'23.16742','2601'=>'23.37343',
				'2631'=>'23.58086','2661'=>'23.78979','2692'=>'24.00031','2722'=>'24.21251','2753'=>'24.42648','2783'=>'24.64231','2814'=>'24.8601','2844'=>'25.07992','2874'=>'25.30189','2905'=>'25.52607','2935'=>'25.75257','2966'=>'25.98146','2996'=>'26.21284','3026'=>'26.44679',
				'3057'=>'26.68339','3087'=>'26.92273','3118'=>'27.16489','3148'=>'27.40995','3179'=>'27.65797','3209'=>'27.90904','3239'=>'28.16324','3270'=>'28.42064','3300'=>'28.6813','3331'=>'28.9453','3361'=>'29.21271','3391'=>'29.48359','3422'=>'29.758','3452'=>'30.03602','3483'=>'30.3177','3513'=>'30.60311',
				'3544'=>'30.8923','3574'=>'31.18533','3604'=>'31.48225','3635'=>'31.78312','3665'=>'32.08799','3696'=>'32.3969','3726'=>'32.70991','3756'=>'33.02704','3787'=>'33.34835','3817'=>'33.67387','3848'=>'34.00363','3878'=>'34.33766','3909'=>'34.67599','3939'=>'35.01864','3969'=>'35.36562',
				'4000'=>'35.71695','4030'=>'36.07263','4061'=>'36.43266','4091'=>'36.79704','4121'=>'37.16577','4152'=>'37.53881','4182'=>'37.91616','4213'=>'38.29777','4243'=>'38.68361','4274'=>'39.07364','4304'=>'39.46781','4334'=>'39.86604','4365'=>'40.26828','4395'=>'40.67444','4426'=>'41.08443','4456'=>'41.49817',
				'4486'=>'41.91555','4517'=>'42.33644','4547'=>'42.76073','4578'=>'43.18828','4608'=>'43.61896','4639'=>'44.05259','4669'=>'44.48903','4699'=>'44.92809','4730'=>'45.3696','4760'=>'45.81336','4791'=>'46.25917','4821'=>'46.70681','4851'=>'47.15606','4882'=>'47.60669','4912'=>'48.05847',
				'4943'=>'48.51113','4973'=>'48.96443','5004'=>'49.4181','5034'=>'49.87187','5064'=>'50.32546','5095'=>'50.77859','5125'=>'51.23096','5156'=>'51.68229','5186'=>'52.13226','5216'=>'52.58059','5247'=>'53.02696','5277'=>'53.47107','5308'=>'53.91261','5338'=>'54.35128','5369'=>'54.78677',
				'5399'=>'55.21878','5429'=>'55.64701','5460'=>'56.07116','5490'=>'56.49096','5521'=>'56.90611','5551'=>'57.31634','5581'=>'57.72139','5612'=>'58.121','5642'=>'58.51492','5673'=>'58.90293','5703'=>'59.2848','5734'=>'59.66033','5764'=>'60.02932','5794'=>'60.39159','5825'=>'60.74699','5855'=>'61.09537',
				'5886'=>'61.4366','5916'=>'61.77057','5946'=>'62.09719','5977'=>'62.41639','6007'=>'62.72809','6038'=>'63.03228','6068'=>'63.32892','6099'=>'63.61802','6129'=>'63.89959','6159'=>'64.17367','6190'=>'64.44032','6220'=>'64.69961','6251'=>'64.95165','6281'=>'65.19653','6311'=>'65.4344','6342'=>'65.6654','6372'=>'65.8897',
				'6403'=>'66.10749','6433'=>'66.31897','6464'=>'66.52437','6494'=>'66.7239','6524'=>'66.91784','6555'=>'67.10642','6585'=>'67.28993','6616'=>'67.46863','6646'=>'67.64281','6676'=>'67.81277','6707'=>'67.97877','6737'=>'68.14111','6768'=>'68.30005','6798'=>'68.45585','6829'=>'68.60872','6859'=>'68.75889','6889'=>'68.90653',
				'6920'=>'69.05176','6950'=>'69.19467','6981'=>'69.33527','7011'=>'69.47351','7041'=>'69.60926','7072'=>'69.74228','7102'=>'69.87224','7133'=>'69.99869','7163'=>'70.12104','7194'=>'70.23857','7224'=>'70.3504','7254'=>'70.45546','7285'=>'70.55252','7300'=>'70.59761');
		$percentile75Array=array('730'=>'13.63692','745'=>'13.71386','776'=>'13.8659','806'=>'14.01623','836'=>'14.16567','867'=>'14.31493','897'=>'14.46462','928'=>'14.61527','958'=>'14.76732','989'=>'14.92117','1019'=>'15.07711','1049'=>'15.23541',
				'1080'=>'15.39628','1110'=>'15.55987','1141'=>'15.7263','1171'=>'15.89565','1201'=>'16.06797','1232'=>'16.24326','1262'=>'16.42153','1293'=>'16.60273','1323'=>'16.78682','1354'=>'16.97373','1384'=>'17.16336','1414'=>'17.35564','1445'=>'17.55044','1475'=>'17.74767','1506'=>'17.9472',
				'1536'=>'18.14892','1566'=>'18.3527','1597'=>'18.55842','1627'=>'18.76598','1658'=>'18.97524','1688'=>'19.1861','1719'=>'19.39846','1749'=>'19.6122','1779'=>'19.82724','1810'=>'20.04348','1840'=>'20.26086','1871'=>'20.47929','1901'=>'20.69871','1931'=>'20.91907','1962'=>'21.14031','1992'=>'21.36242','2023'=>'21.58534',
				'2053'=>'21.80908','2084'=>'22.0336','2114'=>'22.25893','2144'=>'22.48505','2175'=>'22.712','2205'=>'22.93978','2236'=>'23.16845','2266'=>'23.39803','2296'=>'23.62858','2327'=>'23.86016','2357'=>'24.09284','2388'=>'24.32667','2418'=>'24.56175','2449'=>'24.79815','2479'=>'25.03598',
				'2509'=>'25.27531','2540'=>'25.51626','2570'=>'25.75894','2601'=>'26.00344','2631'=>'26.24988','2661'=>'26.49839','2692'=>'26.74907','2722'=>'27.00204','2753'=>'27.25743','2783'=>'27.51535','2814'=>'27.77593','2844'=>'28.03928','2874'=>'28.30554','2905'=>'28.5748','2935'=>'28.84718','2966'=>'29.12281','2996'=>'29.40179',
				'3026'=>'29.68422','3057'=>'29.97021','3087'=>'30.25986','3118'=>'30.55326','3148'=>'30.85051','3179'=>'31.15169','3209'=>'31.45689','3239'=>'31.76618','3270'=>'32.07964','3300'=>'32.39734','3331'=>'32.71933','3361'=>'33.04569','3391'=>'33.37646','3422'=>'33.7117','3452'=>'34.05144','3483'=>'34.39573','3513'=>'34.7446',
				'3544'=>'35.09808','3574'=>'35.4562','3604'=>'35.81896','3635'=>'36.1864','3665'=>'36.55851','3696'=>'36.93529','3726'=>'37.31675','3756'=>'37.70287','3787'=>'38.09365','3817'=>'38.48906','3848'=>'38.88907','3878'=>'39.29366','3909'=>'39.7028','3939'=>'40.11642','3969'=>'40.5345','4000'=>'40.95697','4030'=>'41.38377','4061'=>'41.81484','4091'=>'42.2501',
				'4121'=>'42.68947','4152'=>'43.13287','4182'=>'43.5802','4213'=>'44.03137','4243'=>'44.48627','4274'=>'44.94478','4304'=>'45.40679','4334'=>'45.87218','4365'=>'46.3408','4395'=>'46.81253','4426'=>'47.28721','4456'=>'47.7647','4486'=>'48.24483','4517'=>'48.72744','4547'=>'49.21236','4578'=>'49.6994','4608'=>'50.18839',
				'4639'=>'50.67913','4669'=>'51.17143','4699'=>'51.66508','4730'=>'52.15987','4760'=>'52.65558','4791'=>'53.152','4821'=>'53.64889','4851'=>'54.14603','4882'=>'54.64318','4912'=>'55.1401','4943'=>'55.63653','4973'=>'56.13224','5004'=>'56.62696','5034'=>'57.12044','5064'=>'57.61241','5095'=>'58.10262','5125'=>'58.5908','5156'=>'59.07667',
				'5186'=>'59.55998','5216'=>'60.04046','5247'=>'60.51782','5277'=>'60.99182','5308'=>'61.46217','5338'=>'61.92862','5369'=>'62.3909','5399'=>'62.84876','5429'=>'63.30195','5460'=>'63.75019','5490'=>'64.19328','5521'=>'64.63096','5551'=>'65.063','5581'=>'65.48919','5612'=>'65.90932','5642'=>'66.32318','5673'=>'66.73059','5703'=>'67.13136','5734'=>'67.52534','5764'=>'67.91236',
				'5794'=>'68.29229','5825'=>'68.665','5855'=>'69.03038','5886'=>'69.38833','5916'=>'69.73878','5946'=>'70.08164','5977'=>'70.41688','6007'=>'70.74445','6038'=>'71.06433','6068'=>'71.37652','6099'=>'71.68103','6129'=>'71.97788','6159'=>'72.26711','6190'=>'72.54879','6220'=>'72.82297','6251'=>'73.08975','6281'=>'73.34922','6311'=>'73.60152',
				'6342'=>'73.84675','6372'=>'74.08507','6403'=>'74.31664','6433'=>'74.54164','6464'=>'74.76024','6494'=>'74.97267','6524'=>'75.17912','6555'=>'75.37983','6585'=>'75.57503','6616'=>'75.76499','6646'=>'75.94994','6676'=>'76.13018','6707'=>'76.30597','6737'=>'76.47759','6768'=>'76.64533','6798'=>'76.80948','6829'=>'76.97031','6859'=>'77.12809','6889'=>'77.2831','6920'=>'77.4356',
				'6950'=>'77.5858','6981'=>'77.73392','7011'=>'77.88014','7041'=>'78.02461','7072'=>'78.16742','7102'=>'78.30863','7133'=>'78.44824','7163'=>'78.58618','7194'=>'78.72234','7224'=>'78.8565','7254'=>'78.98839','7285'=>'79.11762','7300'=>'79.18111');
		$percentile90Array=array('730'=>'14.5834','745'=>'14.66716','776'=>'14.83332','806'=>'14.99848','836'=>'15.16351','867'=>'15.32917','897'=>'15.4961','928'=>'15.66485','958'=>'15.83588','989'=>'16.00958','1019'=>'16.18624','1049'=>'16.36612','1080'=>'16.5494','1110'=>'16.73623','1141'=>'16.9267','1171'=>'17.12085',
				'1201'=>'17.3187','1232'=>'17.52025','1262'=>'17.72545','1293'=>'17.93424','1323'=>'18.14654','1354'=>'18.36226','1384'=>'18.58128','1414'=>'18.80348','1445'=>'19.02875','1475'=>'19.25695','1506'=>'19.48794','1536'=>'19.7216','1566'=>'19.95779','1597'=>'20.19637','1627'=>'20.43722','1658'=>'20.68022','1688'=>'20.92526','1719'=>'21.17222',
				'1749'=>'21.421','1779'=>'21.67152','1810'=>'21.92369','1840'=>'22.17744','1871'=>'22.4327','1901'=>'22.68943','1931'=>'22.94758','1962'=>'23.20712','1992'=>'23.46802','2023'=>'23.73029','2053'=>'23.99391','2084'=>'24.2589','2114'=>'24.52527','2144'=>'24.79305','2175'=>'25.06229','2205'=>'25.33302','2236'=>'25.6053','2266'=>'25.87919',
				'2296'=>'26.15477','2327'=>'26.4321','2357'=>'26.71128','2388'=>'26.99239','2418'=>'27.27553','2449'=>'27.56081','2479'=>'27.84832','2509'=>'28.13817','2540'=>'28.43049','2570'=>'28.72538','2601'=>'29.02298','2631'=>'29.3234','2661'=>'29.62676','2692'=>'29.9332','2722'=>'30.24283','2753'=>'30.55579','2783'=>'30.8722','2814'=>'31.19218','2844'=>'31.51586',
				'2874'=>'31.84335','2905'=>'32.17478','2935'=>'32.51025','2966'=>'32.84988','2996'=>'33.19377','3026'=>'33.54202','3057'=>'33.89472','3087'=>'34.25197','3118'=>'34.61384','3148'=>'34.98041','3179'=>'35.35176','3209'=>'35.72793','3239'=>'36.10899','3270'=>'36.49499','3300'=>'36.88596','3331'=>'37.28193','3361'=>'37.68294','3391'=>'38.08898','3422'=>'38.50008','3452'=>'38.91622',
				'3483'=>'39.33741','3513'=>'39.76363','3544'=>'40.19484','3574'=>'40.63103','3604'=>'41.07214','3635'=>'41.51813','3665'=>'41.96894','3696'=>'42.42452','3726'=>'42.88478','3756'=>'43.34967','3787'=>'43.81908','3817'=>'44.29292','3848'=>'44.77111','3878'=>'45.25354','3909'=>'45.7401','3939'=>'46.23066','3969'=>'46.72512','4000'=>'47.22334','4030'=>'47.72519','4061'=>'48.23054',
				'4091'=>'48.73924','4121'=>'49.25114','4152'=>'49.76611','4182'=>'50.28397','4213'=>'50.80458','4243'=>'51.32778','4274'=>'51.85339','4304'=>'52.38125','4334'=>'52.91119','4365'=>'53.44304','4395'=>'53.97661','4426'=>'54.51174','4456'=>'55.04825','4486'=>'55.58594','4517'=>'56.12464','4547'=>'56.66416','4578'=>'57.20431','4608'=>'57.74492',
				'4639'=>'58.28578','4669'=>'58.82671','4699'=>'59.36752','4730'=>'59.90801','4760'=>'60.448','4791'=>'60.98729','4821'=>'61.52569','4851'=>'62.063','4882'=>'62.59903','4912'=>'63.13359','4943'=>'63.66648','4973'=>'64.1975','5004'=>'64.72647','5034'=>'65.25318','5064'=>'65.77745','5095'=>'66.29907','5125'=>'66.81785',
				'5156'=>'67.33359','5186'=>'67.84611','5216'=>'68.3552','5247'=>'68.86067','5277'=>'69.36233','5308'=>'69.85999','5338'=>'70.35345','5369'=>'70.84252','5399'=>'71.32701','5429'=>'71.80674','5460'=>'72.2815','5490'=>'72.75113','5521'=>'73.21544','5551'=>'73.67424','5581'=>'74.12736','5612'=>'74.57462','5642'=>'75.01586','5673'=>'75.4509',
				'5703'=>'75.87959','5734'=>'76.30176','5764'=>'76.71726','5794'=>'77.12595','5825'=>'77.52768','5855'=>'77.92233','5886'=>'78.30977','5916'=>'78.68987','5946'=>'79.06252','5977'=>'79.42763','6007'=>'79.78509','6038'=>'80.13483','6068'=>'80.47676','6099'=>'80.81082','6129'=>'81.13696',
				'6159'=>'81.45512','6190'=>'81.76528','6220'=>'82.06741','6251'=>'82.3615','6281'=>'82.64755','6311'=>'82.92558','6342'=>'83.1956','6372'=>'83.45768','6403'=>'83.71185','6433'=>'83.9582','6464'=>'84.19682','6494'=>'84.42781','6524'=>'84.6513','6555'=>'84.86744','6585'=>'85.0764','6616'=>'85.27837','6646'=>'85.47356','6676'=>'85.66221',
				'6707'=>'85.8446','6737'=>'86.02101','6768'=>'86.19177','6798'=>'86.35725','6829'=>'86.51781','6859'=>'86.6739','6889'=>'86.82597','6920'=>'86.97452','6950'=>'87.12008','6981'=>'87.26324','7011'=>'87.40462','7041'=>'87.54488','7072'=>'87.68474','7102'=>'87.82495','7133'=>'87.96634','7163'=>'88.10976','7194'=>'88.25614',
				'7224'=>'88.40645','7254'=>'88.56175','7285'=>'88.72311','7300'=>'88.80644');
		$percentile95Array=array('730'=>'15.18777','745'=>'15.2763','776'=>'15.45242','806'=>'15.62819','836'=>'15.8045','867'=>'15.98214','897'=>'16.16177','928'=>'16.34395','958'=>'16.52915','989'=>'16.71773','1019'=>'16.91','1049'=>'17.10619','1080'=>'17.30646','1110'=>'17.51093','1141'=>'17.71965','1171'=>'17.93265','1201'=>'18.14992',
				'1232'=>'18.37141','1262'=>'18.59705','1293'=>'18.82675','1323'=>'19.06041','1354'=>'19.29789','1384'=>'19.53907','1414'=>'19.78381','1445'=>'20.03197','1475'=>'20.28339','1506'=>'20.53795','1536'=>'20.79548','1566'=>'21.05586','1597'=>'21.31896','1627'=>'21.58464','1658'=>'21.8528','1688'=>'22.12331','1719'=>'22.3961','1749'=>'22.67106','1779'=>'22.94813',
				'1810'=>'23.22723','1840'=>'23.50833','1871'=>'23.79136','1901'=>'24.07632','1931'=>'24.36317','1962'=>'24.65192','1992'=>'24.94257','2023'=>'25.23514','2053'=>'25.52965','2084'=>'25.82615','2114'=>'26.12468','2144'=>'26.4253','2175'=>'26.72807','2205'=>'27.03308','2236'=>'27.34039','2266'=>'27.6501',
				'2296'=>'27.9623','2327'=>'28.27709','2357'=>'28.59457','2388'=>'28.91486','2418'=>'29.23806','2449'=>'29.56428','2479'=>'29.89365','2509'=>'30.22628','2540'=>'30.56228','2570'=>'30.90178','2601'=>'31.24489','2631'=>'31.59174','2661'=>'31.94243','2692'=>'32.29708','2722'=>'32.65581','2753'=>'33.01871','2783'=>'33.38591','2814'=>'33.75749',
				'2844'=>'34.13355','2874'=>'34.5142','2905'=>'34.8995','2935'=>'35.28955','2966'=>'35.68443','2996'=>'36.08419','3026'=>'36.4889','3057'=>'36.89862','3087'=>'37.3134','3118'=>'37.73327','3148'=>'38.15826','3179'=>'38.58841','3209'=>'39.02372','3239'=>'39.46421','3270'=>'39.90987','3300'=>'40.36069','3331'=>'40.81665','3361'=>'41.27773','3391'=>'41.74388',
				'3422'=>'42.21507','3452'=>'42.69124','3483'=>'43.17232','3513'=>'43.65825','3544'=>'44.14895','3574'=>'44.64432','3604'=>'45.14428','3635'=>'45.64872','3665'=>'46.15753','3696'=>'46.6706','3726'=>'47.1878','3756'=>'47.70901','3787'=>'48.23408','3817'=>'48.76288','3848'=>'49.29526','3878'=>'49.83107','3909'=>'50.37016','3939'=>'50.91236','3969'=>'51.45752','4000'=>'52.00546','4030'=>'52.55602',
				'4061'=>'53.10903','4091'=>'53.66432','4121'=>'54.22171','4152'=>'54.78102','4182'=>'55.34208','4213'=>'55.9047','4243'=>'56.46873','4274'=>'57.03397','4304'=>'57.60024','4334'=>'58.16739','4365'=>'58.73522','4395'=>'59.30357','4426'=>'59.87226','4456'=>'60.44112','4486'=>'61.00999',
				'4517'=>'61.57871','4547'=>'62.1471','4578'=>'62.715','4608'=>'63.28226','4639'=>'63.84873','4669'=>'64.41424','4699'=>'64.97865','4730'=>'65.54182','4760'=>'66.10359','4791'=>'66.66382','4821'=>'67.22238','4851'=>'67.77913','4882'=>'68.33393','4912'=>'68.88665',
				'4943'=>'69.43717','4973'=>'69.98535','5004'=>'70.53106','5034'=>'71.07419','5064'=>'71.61461','5095'=>'72.15219','5125'=>'72.68681','5156'=>'73.21836','5186'=>'73.7467','5216'=>'74.27172','5247'=>'74.7933','5277'=>'75.3113','5308'=>'75.82561','5338'=>'76.3361','5369'=>'76.84263','5399'=>'77.34509','5429'=>'77.84332','5460'=>'78.3372',
				'5490'=>'78.82659','5521'=>'79.31134','5551'=>'79.7913','5581'=>'80.26632','5612'=>'80.73625','5642'=>'81.20093','5673'=>'81.66019','5703'=>'82.11386','5734'=>'82.56177','5764'=>'83.00375','5794'=>'83.43962','5825'=>'83.8692','5855'=>'84.29229','5886'=>'84.70871','5916'=>'85.11828','5946'=>'85.5208','5977'=>'85.91607','6007'=>'86.30392','6038'=>'86.68415',
				'6068'=>'87.05657','6099'=>'87.42099','6129'=>'87.77725','6159'=>'88.12516','6190'=>'88.46456','6220'=>'88.79528','6251'=>'89.11718','6281'=>'89.43011','6311'=>'89.73396','6342'=>'90.02861','6372'=>'90.31396','6403'=>'90.58994','6433'=>'90.85649','6464'=>'91.11358','6494'=>'91.3612','6524'=>'91.59938','6555'=>'91.82817','6585'=>'92.04765','6616'=>'92.25795',
				'6646'=>'92.45925','6676'=>'92.65175','6707'=>'92.83572','6737'=>'93.01148','6768'=>'93.17941','6798'=>'93.33994','6829'=>'93.49361','6859'=>'93.64099','6889'=>'93.78276','6920'=>'93.91968','6950'=>'94.05261','6981'=>'94.18252','7011'=>'94.31046','7041'=>'94.43765','7072'=>'94.5654','7102'=>'94.69517','7133'=>'94.82857',
				'7163'=>'94.96735','7194'=>'95.11344','7224'=>'95.26894','7254'=>'95.43613','7285'=>'95.61749','7300'=>'95.71431');
		$percentile97Array=array('730'=>'15.59648','745'=>'15.68841','776'=>'15.8717','806'=>'16.05514','836'=>'16.23967','867'=>'16.42609','897'=>'16.61508','928'=>'16.8072','958'=>'17.00291','989'=>'17.2026','1019'=>'17.40654',
				'1049'=>'17.61495','1080'=>'17.82797','1110'=>'18.0457','1141'=>'18.26818','1171'=>'18.49539','1201'=>'18.72731','1232'=>'18.96385','1262'=>'19.20492','1293'=>'19.45041','1323'=>'19.70017','1354'=>'19.95407','1384'=>'20.21195','1414'=>'20.47366','1445'=>'20.73903','1475'=>'21.00793','1506'=>'21.28018','1536'=>'21.55565',
				'1566'=>'21.83419','1597'=>'22.11568','1627'=>'22.39999','1658'=>'22.68702','1688'=>'22.97667','1719'=>'23.26885','1749'=>'23.56349','1779'=>'23.86054','1810'=>'24.15995','1840'=>'24.46169','1871'=>'24.76575','1901'=>'25.07212','1931'=>'25.38081','1962'=>'25.69185','1992'=>'26.00527','2023'=>'26.32111','2053'=>'26.63944',
				'2084'=>'26.96033','2114'=>'27.28386','2144'=>'27.6101','2175'=>'27.93916','2205'=>'28.27115','2236'=>'28.60616','2266'=>'28.94432','2296'=>'29.28574','2327'=>'29.63055','2357'=>'29.97888','2388'=>'30.33083','2418'=>'30.68656','2449'=>'31.04617','2479'=>'31.4098','2509'=>'31.77756','2540'=>'32.14959','2570'=>'32.52599','2601'=>'32.90689',
				'2631'=>'33.29238','2661'=>'33.68257','2692'=>'34.07755','2722'=>'34.47742','2753'=>'34.88226','2783'=>'35.29215','2814'=>'35.70715','2844'=>'36.12732','2874'=>'36.55271','2905'=>'36.98338','2935'=>'37.41935','2966'=>'37.86065','2996'=>'38.30731','3026'=>'38.75932','3057'=>'39.2167','3087'=>'39.67943','3118'=>'40.14749','3148'=>'40.62087',
				'3179'=>'41.09952','3209'=>'41.5834','3239'=>'42.07247','3270'=>'42.56665','3300'=>'43.06589','3331'=>'43.5701','3361'=>'44.0792','3391'=>'44.5931','3422'=>'45.11169','3452'=>'45.63487','3483'=>'46.16253','3513'=>'46.69454','3544'=>'47.23077','3574'=>'47.77109','3604'=>'48.31536','3635'=>'48.86343','3665'=>'49.41515','3696'=>'49.97037','3726'=>'50.52892','3756'=>'51.09064',
				'3787'=>'51.65537','3817'=>'52.22293','3848'=>'52.79314','3878'=>'53.36584','3909'=>'53.94084','3939'=>'54.51797','3969'=>'55.09704','4000'=>'55.67787','4030'=>'56.26029','4061'=>'56.84411','4091'=>'57.42915','4121'=>'58.01524','4152'=>'58.60219','4182'=>'59.18983','4213'=>'59.77799','4243'=>'60.3665','4274'=>'60.95519','4304'=>'61.5439','4334'=>'62.13246','4365'=>'62.72072',
				'4395'=>'63.30853','4426'=>'63.89573','4456'=>'64.48219','4486'=>'65.06776','4517'=>'65.65231','4547'=>'66.2357','4578'=>'66.81782','4608'=>'67.39854','4639'=>'67.97776','4669'=>'68.55535','4699'=>'69.13122','4730'=>'69.70526','4760'=>'70.27738','4791'=>'70.84748','4821'=>'71.41549','4851'=>'71.98133','4882'=>'72.5449',
				'4912'=>'73.10614','4943'=>'73.66498','4973'=>'74.22134','5004'=>'74.77517','5034'=>'75.32641','5064'=>'75.87498','5095'=>'76.42083','5125'=>'76.9639','5156'=>'77.50413','5186'=>'78.04146','5216'=>'78.57582','5247'=>'79.10716','5277'=>'79.63542','5308'=>'80.1605','5338'=>'80.68236','5369'=>'81.2009','5399'=>'81.71605','5429'=>'82.2277','5460'=>'82.73579','5490'=>'83.24017','5521'=>'83.74075','5551'=>'84.23741','5581'=>'84.73','5612'=>'85.21839',
				'5642'=>'85.70242','5673'=>'86.18192','5703'=>'86.65673','5734'=>'87.12663','5764'=>'87.59143','5794'=>'88.05093','5825'=>'88.50487','5855'=>'88.95303','5886'=>'89.39516','5916'=>'89.83098','5946'=>'90.26024','5977'=>'90.68264','6007'=>'91.0979','6038'=>'91.50571','6068'=>'91.90578','6099'=>'92.29779','6129'=>'92.68144','6159'=>'93.05643','6190'=>'93.42244','6220'=>'93.77917','6251'=>'94.12633','6281'=>'94.46364','6311'=>'94.79081',
				'6342'=>'95.10761','6372'=>'95.41379','6403'=>'95.70913','6433'=>'95.99346','6464'=>'96.26661','6494'=>'96.52847','6524'=>'96.77894','6555'=>'97.01799','6585'=>'97.24564','6616'=>'97.46194','6646'=>'97.66704','6676'=>'97.86111','6707'=>'98.04443','6737'=>'98.21733','6768'=>'98.38026','6798'=>'98.53375',
				'6829'=>'98.67844','6859'=>'98.81509','6889'=>'98.94455','6920'=>'99.06786','6950'=>'99.18615','6981'=>'99.30075','7011'=>'99.41315','7041'=>'99.52501','7072'=>'99.63819','7102'=>'99.75477','7133'=>'99.87706','7163'=>'100.0076','7194'=>'100.1492','7224'=>'100.3048',
				'7254'=>'100.4779','7285'=>'100.6721','7300'=>'100.7784');
		//end of array
		$this->set(compact('percentile3Array','percentile5Array','percentile10Array','percentile25Array','percentile50Array','percentile75Array','percentile85Array','percentile90Array','percentile95Array','percentile97Array'));
		$this->set('diagnosis',$diagnosis);
		$this->set('bmi_array',$bmi_Day);
		$this->set(compact('year','month','date','patient_name'));
	}
	public function bmi_statureforage_male($id=null) {
			
		$this->layout=false;
		$this->set('title_for_layout', __('Growth Chart', true));
		$this->uses = array('Patient','BmiResult','ReviewPatientDetail');
		//Getting data for opd patient
		$this->Patient->bindModel( array(
				'belongsTo' => array(
						'BmiResult'=>array('conditions'=>array('BmiResult.patient_id=Patient.id'),'foreignKey'=>false),
						'Person'=>array('conditions'=>array('Person.id=Patient.person_id'),'foreignKey'=>false)
				)
		));

		$diagnosis = $this->Patient->find('all',array('fields'=>array('BmiResult.height,BmiResult.height_result,BmiResult.weight,BmiResult.bmi,BmiResult.patient_id,BmiResult.created_time,
				Patient.age,Patient.admission_type,Person.sex,Person.dob,Patient.lookup_name'),'conditions'=>array('Patient.person_id'=>$id,'Patient.is_deleted'=>0,'Patient.admission_type'=>'OPD'),'order' => array('Patient.id' => 'asc')));
			
		foreach($diagnosis as $data)
		{
			$var=$this->DateFormat->dateDiff($data['Person']['dob'],$data['BmiResult']['created_time']);
			$day=$var->days;
			$year[$day]=$var->y;
			$month[$day]=$var->m;
			$date[$day]=$data['BmiResult']['created_time'];
			$patient_name=$data['Patient']['lookup_name'];
			$height=explode(' ',$data['BmiResult']['height_result']);
			$bmi_Day[$day][]=$height[0];
		}
		//Getting data for ipd patient
		$this->Patient->bindModel(array(
				'belongsTo'=>array(
						'ReviewPatientDetail'=>array('conditions'=>array('ReviewPatientDetail.patient_id=Patient.id'),'foreignKey'=>false),
						'ReviewSubCategoriesOption'=>array(
								'conditions'=>array('ReviewSubCategoriesOption.name LIKE'=>"%".Configure::read('bmi_height_measured')."%"),'foreignKey'=>false),
						'Person'=>array('conditions'=>array('Person.id=Patient.person_id'),'foreignKey'=>false)
				)));
		$diagnosis1 = $this->Patient->find('all',array('fields'=>array('ReviewPatientDetail.values,ReviewPatientDetail.date,
				Patient.age,Patient.admission_type,Person.sex,Person.dob,Patient.lookup_name,ReviewSubCategoriesOption.id'),
				'conditions'=>array('Patient.person_id'=>$id,'ReviewSubCategoriesOption.id=ReviewPatientDetail.review_sub_categories_options_id','ReviewPatientDetail.edited_on IS NULL','Patient.is_deleted'=>0,'Patient.admission_type'=>'IPD'),'order' => array('Patient.id' => 'asc')));
			
			
			
		foreach($diagnosis1 as $data)
		{
			$var=$this->DateFormat->dateDiff($data['Person']['dob'],$data['ReviewPatientDetail']['date']);
			$day=$var->days;
			$year[$day]=$var->y;
			$date[$day]=$data['ReviewPatientDetail']['date'];
			$patient_name=$data['Patient']['lookup_name'];
			$month[$day]=$var->m;
			$bmi_Day[$day][]=$data['ReviewPatientDetail']['values'];
		}
		//array for setting data for standard datalines
		$percentile3Array=array('730'=>'79.91084','745'=>'80.26037','776'=>'81.00529','806'=>'81.73416','836'=>'82.44846','867'=>'83.14945','897'=>'83.83819','928'=>'84.51558','958'=>'85.18238','989'=>'85.83925','1019'=>'86.48678','1049'=>'87.12552','1080'=>'87.75597','1110'=>'88.37864','1141'=>'88.93297','1171'=>'89.47916','1201'=>'90.01766','1232'=>'90.54891','1262'=>'91.07337','1293'=>'91.59152',
				'1323'=>'92.10382','1354'=>'92.61073','1384'=>'93.11271','1414'=>'93.61022','1445'=>'94.10371','1475'=>'94.59361','1506'=>'95.08035','1536'=>'95.56435','1566'=>'96.046','1597'=>'96.52568','1627'=>'97.00376','1658'=>'97.48058','1688'=>'97.95648','1719'=>'98.43175','1749'=>'98.90667','1779'=>'99.38151','1810'=>'99.8565','1840'=>'100.3318',
				'1871'=>'100.8077','1901'=>'101.2843','1931'=>'101.7618','1962'=>'102.2401','1992'=>'102.7195','2023'=>'103.2','2053'=>'103.6815','2084'=>'104.1642','2114'=>'104.6479','2144'=>'105.1326','2175'=>'105.6183','2205'=>'106.1048','2236'=>'106.5921','2266'=>'107.0799','2296'=>'107.5682','2327'=>'108.0566','2357'=>'108.5451','2388'=>'109.0335','2418'=>'109.5214',
				'2449'=>'110.0086','2479'=>'110.495','2509'=>'110.9801','2540'=>'111.4638','2570'=>'111.9459','2601'=>'112.4259','2631'=>'112.9036','2661'=>'113.3789','2692'=>'113.8513','2722'=>'114.3206','2753'=>'114.7867','2783'=>'115.2491','2814'=>'115.7077','2844'=>'116.1623','2874'=>'116.6127','2905'=>'117.0587','2935'=>'117.5',
				'2966'=>'117.9366','2996'=>'118.3683','3026'=>'118.7949','3057'=>'119.2165','3087'=>'119.633','3118'=>'120.0442','3148'=>'120.4502','3179'=>'120.851','3209'=>'121.2467','3239'=>'121.6372','3270'=>'122.0228','3300'=>'122.4034','3331'=>'122.7793','3361'=>'123.1506','3391'=>'123.5175','3422'=>'123.8803','3452'=>'124.2391','3483'=>'124.5943',
				'3513'=>'124.9462','3544'=>'125.295','3574'=>'125.6413','3604'=>'125.9852','3635'=>'126.3272','3665'=>'126.6678','3696'=>'127.0073','3726'=>'127.3462','3756'=>'127.6851','3787'=>'128.0243','3817'=>'128.3643','3848'=>'128.7058','3878'=>'129.0491','3909'=>'129.3949','3939'=>'129.7436','3969'=>'130.0958','4000'=>'130.452','4030'=>'130.8127','4061'=>'131.1785','4091'=>'131.5498',
				'4121'=>'131.9272','4152'=>'132.311','4182'=>'132.7018','4213'=>'133.1','4243'=>'133.5059','4274'=>'133.9199','4304'=>'134.3423','4334'=>'134.7733','4365'=>'135.2132','4395'=>'135.6621','4426'=>'136.1202','4456'=>'136.5875','4486'=>'137.064','4517'=>'137.5496','4547'=>'138.0442','4578'=>'138.5477','4608'=>'139.0597','4639'=>'139.5799','4669'=>'140.108','4699'=>'140.6435',
				'4730'=>'141.1858','4760'=>'141.7345','4791'=>'142.2889','4821'=>'142.8482','4851'=>'143.4118','4882'=>'143.9788','4912'=>'144.5483','4943'=>'145.1196','4973'=>'145.6915','5004'=>'146.2633','5034'=>'146.8339','5064'=>'147.4023','5095'=>'147.9674','5125'=>'148.5284','5156'=>'149.0842','5186'=>'149.6338','5216'=>'150.1763',
				'5247'=>'150.7107','5277'=>'151.2363','5308'=>'151.7521','5338'=>'152.2575','5369'=>'152.7517','5399'=>'153.2342','5429'=>'153.7043','5460'=>'154.1615','5490'=>'154.6056','5521'=>'155.036','5551'=>'155.4526','5581'=>'155.8552','5612'=>'156.2436','5642'=>'156.6178','5673'=>'156.9777','5703'=>'157.3235','5734'=>'157.6551','5764'=>'157.9729','5794'=>'158.277','5825'=>'158.5676',
				'5855'=>'158.845','5886'=>'159.1095','5916'=>'159.3614','5946'=>'159.6011','5977'=>'159.829','6007'=>'160.0455','6038'=>'160.2508','6068'=>'160.4456','6099'=>'160.63','6129'=>'160.8046','6159'=>'160.9697','6190'=>'161.1258','6220'=>'161.2733','6251'=>'161.4125','6281'=>'161.5438','6311'=>'161.6676','6342'=>'161.7843','6372'=>'161.8942',
				'6403'=>'161.9977','6433'=>'162.0951','6464'=>'162.1866','6494'=>'162.2727','6524'=>'162.3537','6555'=>'162.4297','6585'=>'162.5011','6616'=>'162.5681','6646'=>'162.631','6676'=>'162.69','6707'=>'162.7453','6737'=>'162.7972','6768'=>'162.8458','6798'=>'162.8914','6829'=>'162.9341','6859'=>'162.9741','6889'=>'163.0115',
				'6920'=>'163.0465','6950'=>'163.0793','6981'=>'163.11','7011'=>'163.1387','7041'=>'163.1656','7072'=>'163.1907','7102'=>'163.2142','7133'=>'163.2361','7163'=>'163.2566','7194'=>'163.2757',
				'7224'=>'163.2936','7254'=>'163.3103','7285'=>'163.3259','7300'=>'163.3333');
		$percentile5Array=array('730'=>'80.72977','745'=>'81.08868','776'=>'81.83445','806'=>'82.56406','836'=>'83.27899','867'=>'83.98045','897'=>'84.66948',
				'928'=>'85.34694','958'=>'86.01357','989'=>'86.66999','1019'=>'87.3168','1049'=>'87.95452','1080'=>'88.58366','1110'=>'89.20473','1141'=>'89.77301','1171'=>'90.33306',
				'1201'=>'90.88532','1232'=>'91.43025','1262'=>'91.96832','1293'=>'92.49999','1323'=>'93.0257','1354'=>'93.54592','1384'=>'94.06109','1414'=>'94.57166','1445'=>'95.07806','1475'=>'95.5807',
				'1506'=>'96.08','1536'=>'96.57635','1566'=>'97.07013','1597'=>'97.5617','1627'=>'98.05141','1658'=>'98.53958','1688'=>'99.02654','1719'=>'99.51256','1749'=>'99.99791','1779'=>'100.4828','1810'=>'100.9676',
				'1840'=>'101.4523','1871'=>'101.9372','1901'=>'102.4225','1931'=>'102.9082','1962'=>'103.3945','1992'=>'103.8814','2023'=>'104.369','2053'=>'104.8574','2084'=>'105.3466','2114'=>'105.8364','2144'=>'106.327','2175'=>'106.8182',
				'2205'=>'107.3099','2236'=>'107.8021','2266'=>'108.2946','2296'=>'108.7873','2327'=>'109.2801','2357'=>'109.7727','2388'=>'110.2649','2418'=>'110.7566','2449'=>'111.2476','2479'=>'111.7375',
				'2509'=>'112.2263','2540'=>'112.7135','2570'=>'113.1991','2601'=>'113.6827','2631'=>'114.1642','2661'=>'114.6431','2692'=>'115.1194','2722'=>'115.5927','2753'=>'116.0629','2783'=>'116.5297','2814'=>'116.9928',
				'2844'=>'117.4521','2874'=>'117.9074','2905'=>'118.3585','2935'=>'118.8053','2966'=>'119.2475','2996'=>'119.6851','3026'=>'120.1179','3057'=>'120.5459','3087'=>'120.969','3118'=>'121.3872','3148'=>'121.8004',
				'3179'=>'122.2086','3209'=>'122.6119','3239'=>'123.0103','3270'=>'123.4039','3300'=>'123.7928','3331'=>'124.1771','3361'=>'124.5569','3391'=>'124.9325','3422'=>'125.304','3452'=>'125.6717','3483'=>'126.0358','3513'=>'126.3966',
				'3544'=>'126.7544','3574'=>'127.1096','3604'=>'127.4624','3635'=>'127.8132','3665'=>'128.1625','3696'=>'128.5106','3726'=>'128.8579','3756'=>'129.2051','3787'=>'129.5524','3817'=>'129.9004','3848'=>'130.2496','3878'=>'130.6005','3909'=>'130.9536',
				'3939'=>'131.3094','3969'=>'131.6686','4000'=>'132.0316','4030'=>'132.399','4061'=>'132.7714','4091'=>'133.1491','4121'=>'133.5329','4152'=>'133.9232','4182'=>'134.3205','4213'=>'134.7252','4243'=>'135.1378','4274'=>'135.5588','4304'=>'135.9885',
				'4334'=>'136.4271','4365'=>'136.8751','4395'=>'137.3326','4426'=>'137.7998','4456'=>'138.2769','4486'=>'138.7638','4517'=>'139.2605','4547'=>'139.767','4578'=>'140.2831','4608'=>'140.8085','4639'=>'141.3429',
				'4669'=>'141.8859','4699'=>'142.4369','4730'=>'142.9955','4760'=>'143.5608','4791'=>'144.1322','4821'=>'144.7089','4851'=>'145.29','4882'=>'145.8746','4912'=>'146.4615','4943'=>'147.0498','4973'=>'147.6385','5004'=>'148.2262','5034'=>'148.812',
				'5064'=>'149.3947','5095'=>'149.9731','5125'=>'150.5461','5156'=>'151.1127','5186'=>'151.6717','5216'=>'152.2221','5247'=>'152.763','5277'=>'153.2935','5308'=>'153.8127','5338'=>'154.32','5369'=>'154.8147','5399'=>'155.2961','5429'=>'155.7638',
				'5460'=>'156.2174','5490'=>'156.6566','5521'=>'157.0811','5551'=>'157.4907','5581'=>'157.8853','5612'=>'158.265','5642'=>'158.6298','5673'=>'158.9798','5703'=>'159.315','5734'=>'159.6359','5764'=>'159.9425','5794'=>'160.2352','5825'=>'160.5143',
				'5855'=>'160.7802','5886'=>'161.0332','5916'=>'161.2738','5946'=>'161.5023','5977'=>'161.7191','6007'=>'161.9247','6038'=>'162.1196','6068'=>'162.3041','6099'=>'162.4786','6129'=>'162.6437','6159'=>'162.7997','6190'=>'162.947','6220'=>'163.086','6251'=>'163.2172',
				'6281'=>'163.3409','6311'=>'163.4575','6342'=>'163.5673','6372'=>'163.6708','6403'=>'163.7682','6433'=>'163.8598','6464'=>'163.9461','6494'=>'164.0272','6524'=>'164.1034','6555'=>'164.1751','6585'=>'164.2424','6616'=>'164.3057','6646'=>'164.3651',
				'6676'=>'164.4209','6707'=>'164.4733','6737'=>'164.5224','6768'=>'164.5686','6798'=>'164.6119','6829'=>'164.6526','6859'=>'164.6907','6889'=>'164.7265','6920'=>'164.76','6950'=>'164.7915','6981'=>'164.821','7011'=>'164.8487','7041'=>'164.8746','7072'=>'164.8989','7102'=>'164.9217',
				'7133'=>'164.9431','7163'=>'164.9631','7194'=>'164.9819','7224'=>'164.9995','7254'=>'165.016','7285'=>'165.0315','7300'=>'165.0389');
		$percentile10Array=array('730'=>'81.99171','745'=>'82.36401','776'=>'83.11387','806'=>'83.84716','836'=>'84.56534','867'=>'85.26962','897'=>'85.96098','928'=>'86.64027','958'=>'87.3082','989'=>'87.9654',
				'1019'=>'88.61244','1049'=>'89.24986','1080'=>'89.87816','1110'=>'90.49789','1141'=>'91.08608','1171'=>'91.66589','1201'=>'92.23779','1232'=>'92.80225','1262'=>'93.35972','1293'=>'93.91068','1323'=>'94.45556','1354'=>'94.99482',
				'1384'=>'95.52888','1414'=>'96.05817','1445'=>'96.5831','1475'=>'97.10407','1506'=>'97.62147','1536'=>'98.13566','1566'=>'98.64701','1597'=>'99.15585','1627'=>'99.6625','1658'=>'100.1673','1688'=>'100.6705','1719'=>'101.1723',
				'1749'=>'101.6731','1779'=>'102.173','1810'=>'102.6723','1840'=>'103.1712','1871'=>'103.6697','1901'=>'104.1682','1931'=>'104.6666','1962'=>'105.1651','1992'=>'105.6638','2023'=>'106.1627','2053'=>'106.6619','2084'=>'107.1614','2114'=>'107.6611','2144'=>'108.1612',
				'2175'=>'108.6614','2205'=>'109.1619','2236'=>'109.6624','2266'=>'110.1629','2296'=>'110.6633','2327'=>'111.1634','2357'=>'111.6631','2388'=>'112.1623','2418'=>'112.6608','2449'=>'113.1583','2479'=>'113.6548',
				'2509'=>'114.1499','2540'=>'114.6436','2570'=>'115.1356','2601'=>'115.6257','2631'=>'116.1136','2661'=>'116.5992','2692'=>'117.0822','2722'=>'117.5625','2753'=>'118.0398','2783'=>'118.5139','2814'=>'118.9847','2844'=>'119.4519','2874'=>'119.9153',
				'2905'=>'120.3749','2935'=>'120.8305','2966'=>'121.2819','2996'=>'121.729','3026'=>'122.1716','3057'=>'122.6099','3087'=>'123.0435','3118'=>'123.4726','3148'=>'123.897','3179'=>'124.3168','3209'=>'124.7319','3239'=>'125.1425',
				'3270'=>'125.5485','3300'=>'125.9501','3331'=>'126.3473','3361'=>'126.7402','3391'=>'127.1291','3422'=>'127.514','3452'=>'127.8953','3483'=>'128.273','3513'=>'128.6474','3544'=>'129.0189','3574'=>'129.3876','3604'=>'129.754','3635'=>'130.1183','3665'=>'130.4809',
				'3696'=>'130.8422','3726'=>'131.2026','3756'=>'131.5625','3787'=>'131.9224','3817'=>'132.2828','3848'=>'132.6441','3878'=>'133.0068','3909'=>'133.3714','3939'=>'133.7386','3969'=>'134.1089','4000'=>'134.4828','4030'=>'134.8608','4061'=>'135.2437','4091'=>'135.6318','4121'=>'136.026',
				'4152'=>'136.4266','4182'=>'136.8343','4213'=>'137.2496','4243'=>'137.673','4274'=>'138.105','4304'=>'138.5461','4334'=>'138.9968','4365'=>'139.4573','4395'=>'139.928','4426'=>'140.4091','4456'=>'140.9009','4486'=>'141.4034','4517'=>'141.9167','4547'=>'142.4407','4578'=>'142.9752',
				'4608'=>'143.52','4639'=>'144.0746','4669'=>'144.6388','4699'=>'145.2117','4730'=>'145.7928','4760'=>'146.3813','4791'=>'146.9763','4821'=>'147.5767','4851'=>'148.1815','4882'=>'148.7896','4912'=>'149.3998','4943'=>'150.0107','4973'=>'150.621','5004'=>'151.2295','5034'=>'151.8348',
				'5064'=>'152.4355','5095'=>'153.0304','5125'=>'153.6181','5156'=>'154.1975','5186'=>'154.7674','5216'=>'155.3268','5247'=>'155.8746','5277'=>'156.4099','5308'=>'156.9319','5338'=>'157.4399','5369'=>'157.9334','5399'=>'158.4118','5429'=>'158.8747','5460'=>'159.3218',
				'5490'=>'159.7529','5521'=>'160.168','5551'=>'160.5669','5581'=>'160.9498','5612'=>'161.3167','5642'=>'161.6679','5673'=>'162.0035','5703'=>'162.3239','5734'=>'162.6294','5764'=>'162.9204','5794'=>'163.1973','5825'=>'163.4605','5855'=>'163.7104','5886'=>'163.9476','5916'=>'164.1725','5946'=>'164.3856',
				'5977'=>'164.5873','6007'=>'164.7782','6038'=>'164.9587','6068'=>'165.1292','6099'=>'165.2903','6129'=>'165.4424','6159'=>'165.586','6190'=>'165.7214','6220'=>'165.8491','6251'=>'165.9694','6281'=>'166.0828','6311'=>'166.1897','6342'=>'166.2903',
				'6372'=>'166.3851','6403'=>'166.4743','6433'=>'166.5583','6464'=>'166.6373','6494'=>'166.7116','6524'=>'166.7816','6555'=>'166.8474','6585'=>'166.9094','6616'=>'166.9676','6646'=>'167.0224','6676'=>'167.074','6707'=>'167.1224','6737'=>'167.168','6768'=>'167.2109',
				'6798'=>'167.2513','6829'=>'167.2892','6859'=>'167.325','6889'=>'167.3585','6920'=>'167.3902','6950'=>'167.4199','6981'=>'167.4479','7011'=>'167.4742','7041'=>'167.499','7072'=>'167.5224','7102'=>'167.5444','7133'=>'167.5651','7163'=>'167.5846',
				'7194'=>'167.6029','7224'=>'167.6203','7254'=>'167.6366','7285'=>'167.6519','7300'=>'167.6593');
		$percentile25Array=array('730'=>'84.10289','745'=>'84.49471','776'=>'85.25888','806'=>'86.00517','836'=>'86.73507','867'=>'87.44977','897'=>'88.15028','928'=>'88.83745','958'=>'89.51202','989'=>'90.17464','1019'=>'90.82592','1049'=>'91.46645','1080'=>'92.0968','1110'=>'92.71756','1141'=>'93.3344','1171'=>'93.94268','1201'=>'94.54291','1232'=>'95.13557',
				'1262'=>'95.72115','1293'=>'96.30009','1323'=>'96.87286','1354'=>'97.43989','1384'=>'98.00159','1414'=>'98.55838','1445'=>'99.11064','1475'=>'99.65875','1506'=>'100.2031','1536'=>'100.7439','1566'=>'101.2817','1597'=>'101.8166','1627'=>'102.3491','1658'=>'102.8792','1688'=>'103.4074','1719'=>'103.9339','1749'=>'104.4588',
				'1779'=>'104.9825','1810'=>'105.505','1840'=>'106.0265','1871'=>'106.5472','1901'=>'107.0673','1931'=>'107.5868','1962'=>'108.1058','1992'=>'108.6244','2023'=>'109.1427','2053'=>'109.6607','2084'=>'110.1785','2114'=>'110.696','2144'=>'111.2132','2175'=>'111.7302',
				'2205'=>'112.2469','2236'=>'112.7631','2266'=>'113.2789','2296'=>'113.7942','2327'=>'114.3089','2357'=>'114.8229','2388'=>'115.336','2418'=>'115.8481','2449'=>'116.3592','2479'=>'116.869','2509'=>'117.3774','2540'=>'117.8842','2570'=>'118.3893','2601'=>'118.8926','2631'=>'119.3938','2661'=>'119.8927',
				'2692'=>'120.3893','2722'=>'120.8833','2753'=>'121.3746','2783'=>'121.863','2814'=>'122.3483','2844'=>'122.8305','2874'=>'123.3092','2905'=>'123.7845','2935'=>'124.2562','2966'=>'124.7242','2996'=>'125.1882','3026'=>'125.6484','3057'=>'126.1045','3087'=>'126.5565','3118'=>'127.0044','3148'=>'127.4481',
				'3179'=>'127.8876','3209'=>'128.3228','3239'=>'128.7539','3270'=>'129.1807','3300'=>'129.6035','3331'=>'130.0222','3361'=>'130.4369','3391'=>'130.8477','3422'=>'131.2548','3452'=>'131.6584','3483'=>'132.0585','3513'=>'132.4555','3544'=>'132.8495','3574'=>'133.2407','3604'=>'133.6295','3635'=>'134.0161',
				'3665'=>'134.4008','3696'=>'134.7841','3726'=>'135.1663','3756'=>'135.5477','3787'=>'135.9288','3817'=>'136.3101','3848'=>'136.692','3878'=>'137.075','3909'=>'137.4597','3939'=>'137.8466','3969'=>'138.2362','4000'=>'138.6292','4030'=>'139.0262','4061'=>'139.4278','4091'=>'139.8346','4121'=>'140.2472','4152'=>'140.6664',
				'4182'=>'141.0928','4213'=>'141.5269','4243'=>'141.9694','4274'=>'142.4209','4304'=>'142.882','4334'=>'143.3532','4365'=>'143.835','4395'=>'144.3277','4426'=>'144.8317','4456'=>'145.3473','4486'=>'145.8746','4517'=>'146.4137','4547'=>'146.9645','4578'=>'147.5269','4608'=>'148.1005',
				'4639'=>'148.6849','4669'=>'149.2795','4699'=>'149.8836','4730'=>'150.4962','4760'=>'151.1165','4791'=>'151.7433','4821'=>'152.3754','4851'=>'153.0113','4882'=>'153.6498','4912'=>'154.2892','4943'=>'154.928','4973'=>'155.5647','5004'=>'156.1977','5034'=>'156.8253','5064'=>'157.4462','5095'=>'158.0587',
				'5125'=>'158.6615','5156'=>'159.2532','5186'=>'159.8327','5216'=>'160.3988','5247'=>'160.9506','5277'=>'161.4872','5308'=>'162.0078','5338'=>'162.5118','5369'=>'162.9988','5399'=>'163.4685','5429'=>'163.9205','5460'=>'164.3547','5490'=>'164.7713','5521'=>'165.1701','5551'=>'165.5514',
				'5581'=>'165.9154','5612'=>'166.2625','5642'=>'166.5929','5673'=>'166.9072','5703'=>'167.2057','5734'=>'167.489','5764'=>'167.7576','5794'=>'168.012','5825'=>'168.2528','5855'=>'168.4805','5886'=>'168.6958','5916'=>'168.8991','5946'=>'169.0911','5977'=>'169.2722','6007'=>'169.4431','6038'=>'169.6041','6068'=>'169.756',
				'6099'=>'169.8991','6129'=>'170.0339','6159'=>'170.1608','6190'=>'170.2804','6220'=>'170.3931','6251'=>'170.4991','6281'=>'170.599','6311'=>'170.693','6342'=>'170.7816','6372'=>'170.865','6403'=>'170.9436','6433'=>'171.0176','6464'=>'171.0873','6494'=>'171.1529','6524'=>'171.2148','6555'=>'171.2732','6585'=>'171.3282','6616'=>'171.3801',
				'6646'=>'171.429','6676'=>'171.4752','6707'=>'171.5188','6737'=>'171.5599','6768'=>'171.5988','6798'=>'171.6355','6829'=>'171.6701','6859'=>'171.7029','6889'=>'171.7339','6920'=>'171.7632','6950'=>'171.791','6981'=>'171.8172','7011'=>'171.8421',
				'7041'=>'171.8657','7072'=>'171.888','7102'=>'171.9091','7133'=>'171.9292','7163'=>'171.9483','7194'=>'171.9663','7224'=>'171.9835','7254'=>'171.9998','7285'=>'172.0153','7300'=>'172.0227');
		$percentile50Array=array('730'=>'86.4522','745'=>'86.86161','776'=>'87.65247','806'=>'88.42326','836'=>'89.17549','867'=>'89.91041','897'=>'90.62908','928'=>'91.33242','958'=>'92.02127','989'=>'92.69638','1019'=>'93.35847','1049'=>'94.00823','1080'=>'94.64637','1110'=>'95.27359',
				'1141'=>'95.91475','1171'=>'96.54734','1201'=>'97.17191','1232'=>'97.78898','1262'=>'98.39903','1293'=>'99.00254','1323'=>'99.59998','1354'=>'100.1918','1384'=>'100.7783','1414'=>'101.36','1445'=>'101.9373','1475'=>'102.5105','1506'=>'103.0799','1536'=>'103.6459',
				'1566'=>'104.2087','1597'=>'104.7687','1627'=>'105.3262','1658'=>'105.8813','1688'=>'106.4343','1719'=>'106.9855','1749'=>'107.535','1779'=>'108.083','1810'=>'108.6296','1840'=>'109.1751','1871'=>'109.7196','1901'=>'110.2631','1931'=>'110.8058','1962'=>'111.3477','1992'=>'111.889',
				'2023'=>'112.4296','2053'=>'112.9696','2084'=>'113.509','2114'=>'114.0479','2144'=>'114.5861','2175'=>'115.1238','2205'=>'115.6609','2236'=>'116.1973','2266'=>'116.7329','2296'=>'117.2678','2327'=>'117.8018','2357'=>'118.3348','2388'=>'118.8668','2418'=>'119.3977','2449'=>'119.9272','2479'=>'120.4554',
				'2509'=>'120.9821','2540'=>'121.5072','2570'=>'122.0305','2601'=>'122.552','2631'=>'123.0714','2661'=>'123.5886','2692'=>'124.1035','2722'=>'124.616','2753'=>'125.1259','2783'=>'125.6331','2814'=>'126.1374','2844'=>'126.6388','2874'=>'127.137','2905'=>'127.632','2935'=>'128.1237','2966'=>'128.6119','2996'=>'129.0966',
				'3026'=>'129.5777','3057'=>'130.055','3087'=>'130.5286','3118'=>'130.9983','3148'=>'131.4641','3179'=>'131.926','3209'=>'132.384','3239'=>'132.8381','3270'=>'133.2882','3300'=>'133.7345','3331'=>'134.1769','3361'=>'134.6155','3391'=>'135.0504','3422'=>'135.4818','3452'=>'135.9097',
				'3483'=>'136.3343','3513'=>'136.7557','3544'=>'137.1742','3574'=>'137.5899','3604'=>'138.0032','3635'=>'138.4143','3665'=>'138.8234','3696'=>'139.231','3726'=>'139.6373','3756'=>'140.0427','3787'=>'140.4477','3817'=>'140.8527','3848'=>'141.2582','3878'=>'141.6646','3909'=>'142.0725','3939'=>'142.4824','3969'=>'142.8949',
				'4000'=>'143.3107','4030'=>'143.7304','4061'=>'144.1545','4091'=>'144.5838','4121'=>'145.019','4152'=>'145.4607','4182'=>'145.9097','4213'=>'146.3665','4243'=>'146.832','4274'=>'147.3066','4304'=>'147.7911','4334'=>'148.2859','4365'=>'148.7917','4395'=>'149.3088','4426'=>'149.8376','4456'=>'150.3784','4486'=>'150.9313',
				'4517'=>'151.4964','4547'=>'152.0735','4578'=>'152.6624','4608'=>'153.2627','4639'=>'153.8738','4669'=>'154.4951','4699'=>'155.1255','4730'=>'155.7642','4760'=>'156.4099','4791'=>'157.0612','4821'=>'157.7168','4851'=>'158.3751','4882'=>'159.0344','4912'=>'159.6931','4943'=>'160.3493','4973'=>'161.0015',
				'5004'=>'161.6478','5034'=>'162.2865','5064'=>'162.9161','5095'=>'163.535','5125'=>'164.1418','5156'=>'164.7352','5186'=>'165.314','5216'=>'165.8771','5247'=>'166.4236','5277'=>'166.9528','5308'=>'167.4641','5338'=>'167.9571','5369'=>'168.4313','5399'=>'168.8867','5429'=>'169.3231','5460'=>'169.7405','5490'=>'170.1393','5521'=>'170.5195',
				'5551'=>'170.8815','5581'=>'171.2257','5612'=>'171.5525','5642'=>'171.8626','5673'=>'172.1563','5703'=>'172.4343','5734'=>'172.6972','5764'=>'172.9456','5794'=>'173.1801','5825'=>'173.4014','5855'=>'173.6101','5886'=>'173.8067','5916'=>'173.992','5946'=>'174.1665','5977'=>'174.3308','6007'=>'174.4854','6038'=>'174.631','6068'=>'174.768','6099'=>'174.8969',
				'6129'=>'175.0182','6159'=>'175.1323','6190'=>'175.2398','6220'=>'175.341','6251'=>'175.4362','6281'=>'175.5259','6311'=>'175.6104','6342'=>'175.6901','6372'=>'175.7652','6403'=>'175.836','6433'=>'175.9028','6464'=>'175.9658','6494'=>'176.0254','6524'=>'176.0816','6555'=>'176.1348',
				'6585'=>'176.185','6616'=>'176.2326','6646'=>'176.2776','6676'=>'176.3202','6707'=>'176.3606','6737'=>'176.3989','6768'=>'176.4352','6798'=>'176.4697','6829'=>'176.5024','6859'=>'176.5335','6889'=>'176.563','6920'=>'176.5911','6950'=>'176.6179',
				'6981'=>'176.6433','7011'=>'176.6676','7041'=>'176.6907','7072'=>'176.7127','7102'=>'176.7337','7133'=>'176.7538','7163'=>'176.773','7194'=>'176.7913','7224'=>'176.8088','7254'=>'176.8255',
				'7285'=>'176.8415','7300'=>'176.8492');
		$percentile75Array=array('730'=>'88.80525','745'=>'89.22805','776'=>'90.05675','806'=>'90.8626','836'=>'91.64711','867'=>'92.41159','897'=>'93.15719','928'=>'93.88496','958'=>'94.59585','989'=>'95.2908','1019'=>'95.97068','1049'=>'96.63637','1080'=>'97.28875','1110'=>'97.9287','1141'=>'98.58525','1171'=>'99.23358','1201'=>'99.87426',
				'1232'=>'100.5078','1262'=>'101.1348','1293'=>'101.7556','1323'=>'102.3708','1354'=>'102.9807','1384'=>'103.5858','1414'=>'104.1865','1445'=>'104.7831','1475'=>'105.3759','1506'=>'105.9654','1536'=>'106.5518','1566'=>'107.1354','1597'=>'107.7165','1627'=>'108.2953','1658'=>'108.872','1688'=>'109.4469','1719'=>'110.0201','1749'=>'110.5919',
				'1779'=>'111.1623','1810'=>'111.7316','1840'=>'112.2998','1871'=>'112.8671','1901'=>'113.4335','1931'=>'113.9992','1962'=>'114.5641','1992'=>'115.1284','2023'=>'115.6921','2053'=>'116.2551','2084'=>'116.8176','2114'=>'117.3794','2144'=>'117.9407','2175'=>'118.5012','2205'=>'119.0611','2236'=>'119.6203','2266'=>'120.1786','2296'=>'120.7361',
				'2327'=>'121.2926','2357'=>'121.848','2388'=>'122.4024','2418'=>'122.9555','2449'=>'123.5073','2479'=>'124.0576','2509'=>'124.6064','2540'=>'125.1535','2570'=>'125.6987','2601'=>'126.2421','2631'=>'126.7834','2661'=>'127.3225','2692'=>'127.8594','2722'=>'128.3937','2753'=>'128.9256','2783'=>'129.4547','2814'=>'129.981','2844'=>'130.5044',
				'2874'=>'131.0247','2905'=>'131.5419','2935'=>'132.0559','2966'=>'132.5664','2996'=>'133.0736','3026'=>'133.5771','3057'=>'134.0771','3087'=>'134.5734','3118'=>'135.066','3148'=>'135.5548','3179'=>'136.0397','3209'=>'136.5209','3239'=>'136.9982','3270'=>'137.4717','3300'=>'137.9414',
				'3331'=>'138.4073','3361'=>'138.8696','3391'=>'139.3282','3422'=>'139.7833','3452'=>'140.235','3483'=>'140.6835','3513'=>'141.1289','3544'=>'141.5713','3574'=>'142.0111','3604'=>'142.4484','3635'=>'142.8835','3665'=>'143.3168','3696'=>'143.7484','3726'=>'144.1789','3756'=>'144.6085','3787'=>'145.0377','3817'=>'145.4669',
				'3848'=>'145.8965','3878'=>'146.3272','3909'=>'146.7593','3939'=>'147.1936','3969'=>'147.6305','4000'=>'148.0707','4030'=>'148.5147','4061'=>'148.9633','4091'=>'149.4172','4121'=>'149.8769','4152'=>'150.3433','4182'=>'150.8169','4213'=>'151.2984','4243'=>'151.7885','4274'=>'152.2878','4304'=>'152.7969','4334'=>'153.3164',
				'4365'=>'153.8466','4395'=>'154.3881','4426'=>'154.941','4456'=>'155.5056','4486'=>'156.0819','4517'=>'156.6699','4547'=>'157.2694','4578'=>'157.88','4608'=>'158.5012','4639'=>'159.1324','4669'=>'159.7725','4699'=>'160.4207','4730'=>'161.0758','4760'=>'161.7364','4791'=>'162.401','4821'=>'163.0682','4851'=>'163.7363',
				'4882'=>'164.4035','4912'=>'165.0681','4943'=>'165.7283','4973'=>'166.3823','5004'=>'167.0284','5034'=>'167.665','5064'=>'168.2905','5095'=>'168.9033','5125'=>'169.5022','5156'=>'170.0859','5186'=>'170.6535','5216'=>'171.2039','5247'=>'171.7364','5277'=>'172.2504','5308'=>'172.7455',
				'5338'=>'173.2213','5369'=>'173.6778','5399'=>'174.1148','5429'=>'174.5324','5460'=>'174.9309','5490'=>'175.3105','5521'=>'175.6716','5551'=>'176.0146','5581'=>'176.34','5612'=>'176.6483','5642'=>'176.9402','5673'=>'177.2163','5703'=>'177.4771','5734'=>'177.7234','5764'=>'177.9558','5794'=>'178.175','5825'=>'178.3815','5855'=>'178.5762',
				'5886'=>'178.7595','5916'=>'178.9321','5946'=>'179.0946','5977'=>'179.2476','6007'=>'179.3915','6038'=>'179.5271','6068'=>'179.6547','6099'=>'179.7748','6129'=>'179.888','6159'=>'179.9946','6190'=>'180.095','6220'=>'180.1896','6251'=>'180.2789','6281'=>'180.3631','6311'=>'180.4426','6342'=>'180.5176','6372'=>'180.5885','6403'=>'180.6555',
				'6433'=>'180.7189','6464'=>'180.7789','6494'=>'180.8357','6524'=>'180.8895','6555'=>'180.9405','6585'=>'180.9889','6616'=>'181.0348','6646'=>'181.0784','6676'=>'181.1199','6707'=>'181.1593','6737'=>'181.1968','6768'=>'181.2325','6798'=>'181.2666','6829'=>'181.299','6859'=>'181.33','6889'=>'181.3595','6920'=>'181.3877','6950'=>'181.4147',
				'6981'=>'181.4405','7011'=>'181.4651','7041'=>'181.4887','7072'=>'181.5113','7102'=>'181.533','7133'=>'181.5538','7163'=>'181.5737','7194'=>'181.5928','7224'=>'181.6111','7254'=>'181.6287','7285'=>'181.6456','7300'=>'181.6538');
		$percentile90Array=array('730'=>'90.92619','745'=>'91.35753','776'=>'92.22966','806'=>'93.07608','836'=>'93.89827','867'=>'94.69757','897'=>'95.47522','928'=>'96.23239','958'=>'96.97022','989'=>'97.68978','1019'=>'98.39218','1049'=>'99.07848','1080'=>'99.74979','1110'=>'100.4072','1141'=>'101.069','1171'=>'101.7234','1201'=>'102.3709',
				'1232'=>'103.012','1262'=>'103.6473','1293'=>'104.2771','1323'=>'104.9021','1354'=>'105.5225','1384'=>'106.1387','1414'=>'106.7513','1445'=>'107.3604','1475'=>'107.9665','1506'=>'108.5698','1536'=>'109.1706','1566'=>'109.7693','1597'=>'110.366','1627'=>'110.9609','1658'=>'111.5543','1688'=>'112.1464','1719'=>'112.7374','1749'=>'113.3273','1779'=>'113.9164',
				'1810'=>'114.5047','1840'=>'115.0924','1871'=>'115.6795','1901'=>'116.2661','1931'=>'116.8522','1962'=>'117.438','1992'=>'118.0234','2023'=>'118.6084','2053'=>'119.1931','2084'=>'119.7774','2114'=>'120.3613','2144'=>'120.9447','2175'=>'121.5277','2205'=>'122.1101','2236'=>'122.6918','2266'=>'123.2729','2296'=>'123.8532','2327'=>'124.4327','2357'=>'125.0111','2388'=>'125.5884',
				'2418'=>'126.1646','2449'=>'126.7394','2479'=>'127.3128','2509'=>'127.8846','2540'=>'128.4547','2570'=>'129.023','2601'=>'129.5893','2631'=>'130.1535','2661'=>'130.7154','2692'=>'131.275','2722'=>'131.8321','2753'=>'132.3865','2783'=>'132.9381','2814'=>'133.4868','2844'=>'134.0325','2874'=>'134.5751','2905'=>'135.1144','2935'=>'135.6504','2966'=>'136.1829',
				'2996'=>'136.7118','3026'=>'137.2371','3057'=>'137.7587','3087'=>'138.2765','3118'=>'138.7905','3148'=>'139.3006','3179'=>'139.8069','3209'=>'140.3093','3239'=>'140.8077','3270'=>'141.3023','3300'=>'141.793','3331'=>'142.28','3361'=>'142.7632','3391'=>'143.2428','3422'=>'143.7188','3452'=>'144.1915','3483'=>'144.661','3513'=>'145.1273',
				'3544'=>'145.5909','3574'=>'146.0518','3604'=>'146.5103','3635'=>'146.9668','3665'=>'147.4214','3696'=>'147.8747','3726'=>'148.3268','3756'=>'148.7782','3787'=>'149.2294','3817'=>'149.6808','3848'=>'150.1329','3878'=>'150.5861','3909'=>'151.041','3939'=>'151.4982','3969'=>'151.9583','4000'=>'152.4218','4030'=>'152.8894','4061'=>'153.3617','4091'=>'153.8394',
				'4121'=>'154.323','4152'=>'154.8133','4182'=>'155.3109','4213'=>'155.8164','4243'=>'156.3303','4274'=>'156.8532','4304'=>'157.3857','4334'=>'157.928','4365'=>'158.4807','4395'=>'159.0439','4426'=>'159.6179','4456'=>'160.2026','4486'=>'160.7981','4517'=>'161.4041','4547'=>'162.0203','4578'=>'162.6462','4608'=>'163.2811','4639'=>'163.9243','4669'=>'164.5748','4699'=>'165.2314',
				'4730'=>'165.893','4760'=>'166.5581','4791'=>'167.2253','4821'=>'167.8929','4851'=>'168.5594','4882'=>'169.2231','4912'=>'169.8822','4943'=>'170.535','4973'=>'171.1798','5004'=>'171.8151','5034'=>'172.4393','5064'=>'173.0509','5095'=>'173.6486','5125'=>'174.2313','5156'=>'174.7978','5186'=>'175.3473','5216'=>'175.879','5247'=>'176.3923',
				'5277'=>'176.8868','5308'=>'177.3622','5338'=>'177.8183','5369'=>'178.2551','5399'=>'178.6727','5429'=>'179.0712','5460'=>'179.451','5490'=>'179.8124','5521'=>'180.1559','5551'=>'180.482','5581'=>'180.7912','5612'=>'181.0841','5642'=>'181.3614','5673'=>'181.6236','5703'=>'181.8715','5734'=>'182.1056','5764'=>'182.3267','5794'=>'182.5353','5825'=>'182.7322','5855'=>'182.9179',
				'5886'=>'183.0931','5916'=>'183.2583','5946'=>'183.414','5977'=>'183.5609','6007'=>'183.6995','6038'=>'183.8302','6068'=>'183.9535','6099'=>'184.0699','6129'=>'184.1797','6159'=>'184.2835','6190'=>'184.3815','6220'=>'184.4741','6251'=>'184.5617','6281'=>'184.6446','6311'=>'184.723','6342'=>'184.7972','6372'=>'184.8676','6403'=>'184.9343','6433'=>'184.9975',
				'6464'=>'185.0576','6494'=>'185.1146','6524'=>'185.1687','6555'=>'185.2202','6585'=>'185.2692','6616'=>'185.3159','6646'=>'185.3603','6676'=>'185.4026','6707'=>'185.443','6737'=>'185.4815','6768'=>'185.5182','6798'=>'185.5534','6829'=>'185.5869','6859'=>'185.619','6889'=>'185.6497','6920'=>'185.6791','6950'=>'185.7073','6981'=>'185.7343','7011'=>'185.7601','7041'=>'185.7849',
				'7072'=>'185.8087','7102'=>'185.8316','7133'=>'185.8535','7163'=>'185.8746','7194'=>'185.8949','7224'=>'185.9144','7254'=>'185.9331','7285'=>'185.9512','7300'=>'185.9599');
		$percentile95Array=array('730'=>'92.19688','745'=>'92.63177','776'=>'93.53407','806'=>'94.40885','836'=>'95.25754','867'=>'96.08149','897'=>'96.88198','928'=>'97.66027','958'=>'98.41758','989'=>'99.15514','1019'=>'99.87416','1049'=>'100.5759','1080'=>'101.2615','1110'=>'101.9324','1141'=>'102.593','1171'=>'103.247','1201'=>'103.8948','1232'=>'104.537',
				'1262'=>'105.1739','1293'=>'105.8061','1323'=>'106.434','1354'=>'107.0579','1384'=>'107.6784','1414'=>'108.2956','1445'=>'108.9101','1475'=>'109.522','1506'=>'110.1317','1536'=>'110.7394','1566'=>'111.3454','1597'=>'111.95','1627'=>'112.5533','1658'=>'113.1555','1688'=>'113.7568','1719'=>'114.3574','1749'=>'114.9575','1779'=>'115.557','1810'=>'116.1561',
				'1840'=>'116.755','1871'=>'117.3536','1901'=>'117.9521','1931'=>'118.5505','1962'=>'119.1487','1992'=>'119.7469','2023'=>'120.345','2053'=>'120.943','2084'=>'121.5408','2114'=>'122.1384','2144'=>'122.7359','2175'=>'123.333','2205'=>'123.9297','2236'=>'124.526','2266'=>'125.1217','2296'=>'125.7168',
				'2327'=>'126.3111','2357'=>'126.9045','2388'=>'127.4969','2418'=>'128.0882','2449'=>'128.6782','2479'=>'129.2668','2509'=>'129.8538','2540'=>'130.4392','2570'=>'131.0226','2601'=>'131.6041','2631'=>'132.1834','2661'=>'132.7605','2692'=>'133.335','2722'=>'133.907','2753'=>'134.4763','2783'=>'135.0426','2814'=>'135.606','2844'=>'136.1662','2874'=>'136.7231',
				'2905'=>'137.2767','2935'=>'137.8267','2966'=>'138.3731','2996'=>'138.9159','3026'=>'139.4548','3057'=>'139.9899','3087'=>'140.5211','3118'=>'141.0484','3148'=>'141.5716','3179'=>'142.0908','3209'=>'142.6061','3239'=>'143.1173','3270'=>'143.6245','3300'=>'144.1278','3331'=>'144.6272','3361'=>'145.1228','3391'=>'145.6148','3422'=>'146.1032','3452'=>'146.5882','3483'=>'147.0699',
				'3513'=>'147.5486','3544'=>'148.0245','3574'=>'148.4979','3604'=>'148.9689','3635'=>'149.438','3665'=>'149.9053','3696'=>'150.3714','3726'=>'150.8365','3756'=>'151.301','3787'=>'151.7655','3817'=>'152.2303','3848'=>'152.696','3878'=>'153.1631','3909'=>'153.6321','3939'=>'154.1035','3969'=>'154.578','4000'=>'155.0562','4030'=>'155.5386',
				'4061'=>'156.0258','4091'=>'156.5186','4121'=>'157.0174','4152'=>'157.5229','4182'=>'158.0356','4213'=>'158.5562','4243'=>'159.0851','4274'=>'159.6228','4304'=>'160.1697','4334'=>'160.7262','4365'=>'161.2924','4395'=>'161.8686','4426'=>'162.4549','4456'=>'163.0511','4486'=>'163.6571','4517'=>'164.2726','4547'=>'164.8972','4578'=>'165.5302','4608'=>'166.1711',
				'4639'=>'166.8187','4669'=>'167.4723','4699'=>'168.1305','4730'=>'168.7923','4760'=>'169.4561','4791'=>'170.1205','4821'=>'170.784','4851'=>'171.445','4882'=>'172.1018','4912'=>'172.7528','4943'=>'173.3965','4973'=>'174.0312','5004'=>'174.6554','5034'=>'175.2677','5064'=>'175.8668','5095'=>'176.4515','5125'=>'177.0206','5156'=>'177.5733','5186'=>'178.1088',
				'5216'=>'178.6264','5247'=>'179.1256','5277'=>'179.6061','5308'=>'180.0676','5338'=>'180.5102','5369'=>'180.9338','5399'=>'181.3385','5429'=>'181.7247','5460'=>'182.0927','5490'=>'182.4429','5521'=>'182.7757','5551'=>'183.0918','5581'=>'183.3916','5612'=>'183.6757','5642'=>'183.9449','5673'=>'184.1997','5703'=>'184.4408','5734'=>'184.6687','5764'=>'184.8843',
				'5794'=>'185.0879','5825'=>'185.2804','5855'=>'185.4623','5886'=>'185.6341','5916'=>'185.7965','5946'=>'185.9498','5977'=>'186.0948','6007'=>'186.2318','6038'=>'186.3613','6068'=>'186.4837','6099'=>'186.5995','6129'=>'186.7091','6159'=>'186.8128','6190'=>'186.911','6220'=>'187.004','6251'=>'187.0922','6281'=>'187.1757','6311'=>'187.255','6342'=>'187.3302','6372'=>'187.4016',
				'6403'=>'187.4694','6433'=>'187.5338','6464'=>'187.5951','6494'=>'187.6534','6524'=>'187.7088','6555'=>'187.7617','6585'=>'187.812','6616'=>'187.86','6646'=>'187.9057','6676'=>'187.9494','6707'=>'187.9911','6737'=>'188.0309','6768'=>'188.069','6798'=>'188.1054','6829'=>'188.1402','6859'=>'188.1736','6889'=>'188.2055','6920'=>'188.236','6950'=>'188.2653','6981'=>'188.2934','7011'=>'188.3204','7041'=>'188.3462',
				'7072'=>'188.3711','7102'=>'188.3949','7133'=>'188.4178','7163'=>'188.4399','7194'=>'188.461','7224'=>'188.4814','7254'=>'188.501','7285'=>'188.5198','7300'=>'188.529');
		$percentile97Array=array('730'=>'93.02265','745'=>'93.45923','776'=>'94.38278','806'=>'95.27762','836'=>'96.14512','867'=>'96.98663','897'=>'97.80345','928'=>'98.59691','958'=>'99.36828','989'=>'100.1189','1019'=>'100.8501','1049'=>'101.5631','1080'=>'102.2593','1110'=>'102.9402','1141'=>'103.5983',
				'1171'=>'104.2503','1201'=>'104.8967','1232'=>'105.538','1262'=>'106.1747','1293'=>'106.8071','1323'=>'107.4357','1354'=>'108.0609','1384'=>'108.683','1414'=>'109.3024','1445'=>'109.9193','1475'=>'110.5342','1506'=>'111.1473','1536'=>'111.7588','1566'=>'112.369','1597'=>'112.9781','1627'=>'113.5863','1658'=>'114.1937',
				'1688'=>'114.8006','1719'=>'115.4072','1749'=>'116.0134','1779'=>'116.6194','1810'=>'117.2254','1840'=>'117.8314','1871'=>'118.4374','1901'=>'119.0435','1931'=>'119.6498','1962'=>'120.2562','1992'=>'120.8627','2023'=>'121.4694','2053'=>'122.0761','2084'=>'122.6829','2114'=>'123.2897','2144'=>'123.8965','2175'=>'124.5031','2205'=>'125.1095','2236'=>'125.7156',
				'2266'=>'126.3212','2296'=>'126.9263','2327'=>'127.5307','2357'=>'128.1344','2388'=>'128.7371','2418'=>'129.3387','2449'=>'129.9391','2479'=>'130.5381','2509'=>'131.1356','2540'=>'131.7314','2570'=>'132.3253','2601'=>'132.9172','2631'=>'133.507','2661'=>'134.0943','2692'=>'134.6792','2722'=>'135.2615','2753'=>'135.8409','2783'=>'136.4173','2814'=>'136.9906','2844'=>'137.5607',
				'2874'=>'138.1274','2905'=>'138.6906','2935'=>'139.2502','2966'=>'139.806','2996'=>'140.358','3026'=>'140.9062','3057'=>'141.4503','3087'=>'141.9904','3118'=>'142.5263','3148'=>'143.0582','3179'=>'143.586','3209'=>'144.1096','3239'=>'144.6291','3270'=>'145.1445','3300'=>'145.656','3331'=>'146.1634','3361'=>'146.6671','3391'=>'147.167','3422'=>'147.6633',
				'3452'=>'148.1562','3483'=>'148.6459','3513'=>'149.1325','3544'=>'149.6163','3574'=>'150.0977','3604'=>'150.5767','3635'=>'151.0539','3665'=>'151.5294','3696'=>'152.0038','3726'=>'152.4773','3756'=>'152.9504','3787'=>'153.4235','3817'=>'153.8972','3848'=>'154.3718','3878'=>'154.848','3909'=>'155.3263','3939'=>'155.8072','3969'=>'156.2913',
				'4000'=>'156.7792','4030'=>'157.2715','4061'=>'157.7688','4091'=>'158.2717','4121'=>'158.7806','4152'=>'159.2964','4182'=>'159.8193','4213'=>'160.35','4243'=>'160.889','4274'=>'161.4365','4304'=>'161.993','4334'=>'162.5588','4365'=>'163.1339','4395'=>'163.7185','4426'=>'164.3126','4456'=>'164.916','4486'=>'165.5285','4517'=>'166.1497','4547'=>'166.7791','4578'=>'167.416',
				'4608'=>'168.0596','4639'=>'168.7091','4669'=>'169.3634','4699'=>'170.0213','4730'=>'170.6817','4760'=>'171.343','4791'=>'172.004','4821'=>'172.663','4851'=>'173.3186','4882'=>'173.9691','4912'=>'174.6131','4943'=>'175.249','4973'=>'175.8753','5004'=>'176.4906','5034'=>'177.0935','5064'=>'177.6829','5095'=>'178.2575','5125'=>'178.8165','5156'=>'179.3589','5186'=>'179.884',
				'5216'=>'180.3913','5247'=>'180.8804','5277'=>'181.3509','5308'=>'181.8027','5338'=>'182.2358','5369'=>'182.6503','5399'=>'183.0463','5429'=>'183.4242','5460'=>'183.7842','5490'=>'184.127','5521'=>'184.4528','5551'=>'184.7624','5581'=>'185.0562','5612'=>'185.3349','5642'=>'185.599','5673'=>'185.8493','5703'=>'186.0863','5734'=>'186.3107','5764'=>'186.5231','5794'=>'186.724',
				'5825'=>'186.9142','5855'=>'187.0941','5886'=>'187.2643','5916'=>'187.4254','5946'=>'187.5779','5977'=>'187.7222','6007'=>'187.8588','6038'=>'187.9881','6068'=>'188.1106','6099'=>'188.2267','6129'=>'188.3368','6159'=>'188.4411','6190'=>'188.54','6220'=>'188.6338','6251'=>'188.7229','6281'=>'188.8075','6311'=>'188.8878','6342'=>'188.9642','6372'=>'189.0368','6403'=>'189.1058',
				'6433'=>'189.1715','6464'=>'189.234','6494'=>'189.2936','6524'=>'189.3503','6555'=>'189.4044','6585'=>'189.456','6616'=>'189.5052','6646'=>'189.5522','6676'=>'189.5971','6707'=>'189.6399','6737'=>'189.6809','6768'=>'189.7201','6798'=>'189.7575','6829'=>'189.7934','6859'=>'189.8277','6889'=>'189.8606','6920'=>'189.8922',
				'6950'=>'189.9224','6981'=>'189.9513','7011'=>'189.9791','7041'=>'190.0058','7072'=>'190.0314','7102'=>'190.056','7133'=>'190.0797','7163'=>'190.1024','7194'=>'190.1242','7224'=>'190.1452','7254'=>'190.1654','7285'=>'190.1849','7300'=>'190.1943');
		//end of array
		$this->set(compact('percentile3Array','percentile5Array','percentile10Array','percentile25Array','percentile50Array','percentile75Array','percentile85Array','percentile90Array','percentile95Array','percentile97Array'));
		$this->set('diagnosis',$diagnosis);
		$this->set('bmi_array',$bmi_Day);
		$this->set(compact('year','month','date','patient_name'));

	}
	public function bmi_statureforage_female($id=null) {
			
		$this->layout=false;
		$this->set('title_for_layout', __('Growth Chart', true));
		$this->uses = array('Patient','BmiResult');
		$this->Patient->bindModel( array(
				'belongsTo' => array(
						'BmiResult'=>array('conditions'=>array('BmiResult.patient_id=Patient.id'),'foreignKey'=>false),
						'Person'=>array('conditions'=>array('Person.id=Patient.person_id'),'foreignKey'=>false)
				)
		));

		$diagnosis = $this->Patient->find('all',array('fields'=>array('BmiResult.height,BmiResult.height_result,BmiResult.weight,BmiResult.bmi,BmiResult.patient_id,BmiResult.created_time,
				Patient.age,Patient.admission_type,Person.sex,Person.dob,Patient.lookup_name'),'conditions'=>array('Patient.person_id'=>$id,'Patient.is_deleted'=>0,'Patient.admission_type'=>'OPD'),'order' => array('Patient.id' => 'asc')));
			
		foreach($diagnosis as $data)
		{
			$var=$this->DateFormat->dateDiff($data['Person']['dob'],$data['BmiResult']['created_time']);
			$day=$var->days;
			$year[$day]=$var->y;
			$month[$day]=$var->m;
			$date[$day]=$data['BmiResult']['created_time'];
			$patient_name=$data['Patient']['lookup_name'];
			$height=explode(' ',$data['BmiResult']['height_result']);
			$bmi_Day[$day][]=$height[0];
		}
		$this->Patient->bindModel(array(
				'belongsTo'=>array(
						'ReviewPatientDetail'=>array('conditions'=>array('ReviewPatientDetail.patient_id=Patient.id'),'foreignKey'=>false),
						'ReviewSubCategoriesOption'=>array(
								'conditions'=>array('ReviewSubCategoriesOption.name LIKE'=>"%".Configure::read('bmi_height_measured')."%"),'foreignKey'=>false),
						'Person'=>array('conditions'=>array('Person.id=Patient.person_id'),'foreignKey'=>false)
				)));
		$diagnosis1 = $this->Patient->find('all',array('fields'=>array('ReviewPatientDetail.values,ReviewPatientDetail.date,
				Patient.age,Patient.admission_type,Person.sex,Person.dob,Patient.lookup_name,ReviewSubCategoriesOption.id'),
				'conditions'=>array('Patient.person_id'=>$id,'ReviewSubCategoriesOption.id=ReviewPatientDetail.review_sub_categories_options_id','ReviewPatientDetail.edited_on IS NULL','Patient.is_deleted'=>0,'Patient.admission_type'=>'IPD'),'order' => array('Patient.id' => 'asc')));

		foreach($diagnosis1 as $data)
		{
			$var=$this->DateFormat->dateDiff($data['Person']['dob'],$data['ReviewPatientDetail']['date']);
			$day=$var->days;
			$year[$day]=$var->y;
			$date[$day]=$data['ReviewPatientDetail']['date'];
			$patient_name=$data['Patient']['lookup_name'];
			$month[$day]=$var->m;
			$bmi_Day[$day][]=$data['ReviewPatientDetail']['values'];
		}
		$percentile3Array=array('730'=>'78.43754','745'=>'78.82133','776'=>'79.60198','806'=>'80.37555','836'=>'81.1357','867'=>'81.87746','897'=>'82.59712','928'=>'83.29206','958'=>'83.96065','989'=>'84.6021','1019'=>'85.2163','1049'=>'85.80379','1080'=>'86.36557','1110'=>'86.90307',
				'1141'=>'87.43482','1171'=>'87.95945','1201'=>'88.4785','1232'=>'88.9933','1262'=>'89.50502','1293'=>'90.01466','1323'=>'90.52307','1354'=>'91.031','1384'=>'91.53905','1414'=>'92.04774','1445'=>'92.55748','1475'=>'93.06862','1506'=>'93.58141','1536'=>'94.09605','1566'=>'94.61267',
				'1597'=>'95.13134','1627'=>'95.65211','1658'=>'96.17495','1688'=>'96.69982','1719'=>'97.22663','1749'=>'97.75525','1779'=>'98.28555','1810'=>'98.81735','1840'=>'99.35047','1871'=>'99.8847','1901'=>'100.4198','1931'=>'100.9555','1962'=>'101.4916','1992'=>'102.0279','2023'=>'102.564','2053'=>'103.0996',
				'2084'=>'103.6346','2114'=>'104.1685','2144'=>'104.7012','2175'=>'105.2323','2205'=>'105.7615','2236'=>'106.2886','2266'=>'106.8132','2296'=>'107.3351','2327'=>'107.8541','2357'=>'108.3698','2388'=>'108.882','2418'=>'109.3905','2449'=>'109.8949','2479'=>'110.3952','2509'=>'110.8909','2540'=>'111.3821',
				'2570'=>'111.8684','2601'=>'112.3496','2631'=>'112.8257','2661'=>'113.2963','2692'=>'113.7615','2722'=>'114.2211','2753'=>'114.6749','2783'=>'115.123','2814'=>'115.5651','2844'=>'116.0012','2874'=>'116.4314','2905'=>'116.8555','2935'=>'117.2737','2966'=>'117.6858','2996'=>'118.092','3026'=>'118.4924','3057'=>'118.8869',
				'3087'=>'119.2757','3118'=>'119.659','3148'=>'120.037','3179'=>'120.4097','3209'=>'120.7775','3239'=>'121.1405','3270'=>'121.4991','3300'=>'121.8537','3331'=>'122.2044','3361'=>'122.5518','3391'=>'122.8963','3422'=>'123.2384','3452'=>'123.5785','3483'=>'123.9173','3513'=>'124.2553','3544'=>'124.5933','3574'=>'124.932',
				'3604'=>'125.2721','3635'=>'125.6144','3665'=>'125.9599','3696'=>'126.3095','3726'=>'126.6641','3756'=>'127.0248','3787'=>'127.3926','3817'=>'127.7687','3848'=>'128.1541','3878'=>'128.5499','3909'=>'128.9573','3939'=>'129.3772','3969'=>'129.8106','4000'=>'130.2585','4030'=>'130.7217','4061'=>'131.2006','4091'=>'131.6958',
				'4121'=>'132.2074','4152'=>'132.7354','4182'=>'133.2795','4213'=>'133.8388','4243'=>'134.4125','4274'=>'134.9993','4304'=>'135.5973','4334'=>'136.2047','4365'=>'136.8191','4395'=>'137.4381','4426'=>'138.0588','4456'=>'138.6784','4486'=>'139.2941','4517'=>'139.9028','4547'=>'140.5019','4578'=>'141.0885','4608'=>'141.6602',
				'4639'=>'142.2148','4669'=>'142.7504','4699'=>'143.2654','4730'=>'143.7584','4760'=>'144.2287','4791'=>'144.6756','4821'=>'145.0987','4851'=>'145.4981','4882'=>'145.874','4912'=>'146.2269','4943'=>'146.5573','4973'=>'146.866','5004'=>'147.1539','5034'=>'147.4219','5064'=>'147.6712','5095'=>'147.9026','5125'=>'148.1173',
				'5156'=>'148.3164','5186'=>'148.5009','5216'=>'148.6717','5247'=>'148.8299','5277'=>'148.9764','5308'=>'149.1121','5338'=>'149.2377','5369'=>'149.3542','5399'=>'149.4622','5429'=>'149.5623','5460'=>'149.6553','5490'=>'149.7416','5521'=>'149.8219','5551'=>'149.8967','5581'=>'149.9663','5612'=>'150.0312','5642'=>'150.0918',
				'5673'=>'150.1484','5703'=>'150.2014','5734'=>'150.251','5764'=>'150.2975','5794'=>'150.3412','5825'=>'150.3823','5855'=>'150.4209','5886'=>'150.4573','5916'=>'150.4917','5946'=>'150.5241','5977'=>'150.5547','6007'=>'150.5837','6038'=>'150.6111',
				'6068'=>'150.6372','6099'=>'150.6619','6129'=>'150.6854','6159'=>'150.7077','6190'=>'150.7289','6220'=>'150.7491','6251'=>'150.7684','6281'=>'150.7868','6311'=>'150.8044','6342'=>'150.8211','6372'=>'150.8372','6403'=>'150.8525','6433'=>'150.8672','6464'=>'150.8812','6494'=>'150.8947','6524'=>'150.9076',
				'6555'=>'150.92','6585'=>'150.9319','6616'=>'150.9433','6646'=>'150.9542','6676'=>'150.9647','6707'=>'150.9749','6737'=>'150.9846','6768'=>'150.9939','6798'=>'151.0029','6829'=>'151.0115','6859'=>'151.0198','6889'=>'151.0279','6920'=>'151.0356','6950'=>'151.043','6981'=>'151.0501',
				'7011'=>'151.057','7041'=>'151.0636','7072'=>'151.07','7102'=>'151.0762','7133'=>'151.0821','7163'=>'151.0879','7194'=>'151.0934','7224'=>'151.0987','7254'=>'151.1038','7285'=>'151.1088','7300'=>'151.1112');
		$percentile5Array=array('730'=>'79.25982','745'=>'79.64777','776'=>'80.44226','806'=>'81.22666','836'=>'81.9954','867'=>'82.74411','897'=>'83.46957','928'=>'84.16953','958'=>'84.84264','989'=>'85.4883','1019'=>'86.10656','1049'=>'86.69803','1080'=>'87.26379','1110'=>'87.80528',
				'1141'=>'88.34236','1171'=>'88.87256','1201'=>'89.39733','1232'=>'89.91797','1262'=>'90.43559','1293'=>'90.95115','1323'=>'91.46549','1354'=>'91.97932','1384'=>'92.49325','1414'=>'93.00778','1445'=>'93.52333','1475'=>'94.04022','1506'=>'94.55872','1536'=>'95.07903','1566'=>'95.60128','1597'=>'96.12555',
				'1627'=>'96.65189','1658'=>'97.18029','1688'=>'97.71069','1719'=>'98.24303','1749'=>'98.77719','1779'=>'99.31303','1810'=>'99.85039','1840'=>'100.3891','1871'=>'100.9289','1901'=>'101.4696','1931'=>'102.011','1962'=>'102.5529','1992'=>'103.0948','2023'=>'103.6367','2053'=>'104.1782','2084'=>'104.7191','2114'=>'105.259',
				'2144'=>'105.7976','2175'=>'106.3348','2205'=>'106.8701','2236'=>'107.4033','2266'=>'107.9342','2296'=>'108.4624','2327'=>'108.9877','2357'=>'109.5099','2388'=>'110.0285','2418'=>'110.5435','2449'=>'111.0545','2479'=>'111.5613','2509'=>'112.0638','2540'=>'112.5616','2570'=>'113.0546','2601'=>'113.5427',
				'2631'=>'114.0256','2661'=>'114.5031','2692'=>'114.9752','2722'=>'115.4418','2753'=>'115.9026','2783'=>'116.3577','2814'=>'116.8069','2844'=>'117.2502','2874'=>'117.6875','2905'=>'118.1189','2935'=>'118.5443','2966'=>'118.9638','2996'=>'119.3774','3026'=>'119.7852','3057'=>'120.1873','3087'=>'120.5838',
				'3118'=>'120.9748','3148'=>'121.3606','3179'=>'121.7413','3209'=>'122.1171','3239'=>'122.4884','3270'=>'122.8555','3300'=>'123.2186','3331'=>'123.5782','3361'=>'123.9347','3391'=>'124.2885','3422'=>'124.6402','3452'=>'124.9902','3483'=>'125.3393','3513'=>'125.688','3544'=>'126.0371','3574'=>'126.3872',
				'3604'=>'126.7392','3635'=>'127.094','3665'=>'127.4524','3696'=>'127.8154','3726'=>'128.184','3756'=>'128.5591','3787'=>'128.9419','3817'=>'129.3334','3848'=>'129.7346','3878'=>'130.1467','3909'=>'130.5705','3939'=>'131.0071','3969'=>'131.4573','4000'=>'131.9218','4030'=>'132.4013','4061'=>'132.8962','4091'=>'133.4067','4121'=>'133.9328',
				'4152'=>'134.4742','4182'=>'135.0304','4213'=>'135.6004','4243'=>'136.1831','4274'=>'136.7769','4304'=>'137.3801','4334'=>'137.9905','4365'=>'138.6058','4395'=>'139.2236','4426'=>'139.841','4456'=>'140.4554','4486'=>'141.064','4517'=>'141.6641','4547'=>'142.253','4578'=>'142.8283','4608'=>'143.3877','4639'=>'143.9294',
				'4669'=>'144.4516','4699'=>'144.953','4730'=>'145.4325','4760'=>'145.8894','4791'=>'146.3232','4821'=>'146.7338','4851'=>'147.1213','4882'=>'147.4859','4912'=>'147.8281','4943'=>'148.1487','4973'=>'148.4483','5004'=>'148.7279','5034'=>'148.9885','5064'=>'149.2309','5095'=>'149.4562','5125'=>'149.6655',
				'5156'=>'149.8598','5186'=>'150.04','5216'=>'150.2072','5247'=>'150.3621','5277'=>'150.5059','5308'=>'150.6392','5338'=>'150.7629','5369'=>'150.8777','5399'=>'150.9843','5429'=>'151.0833','5460'=>'151.1754','5490'=>'151.2611','5521'=>'151.341','5551'=>'151.4154','5581'=>'151.4848',
				'5612'=>'151.5497','5642'=>'151.6103','5673'=>'151.6671','5703'=>'151.7203','5734'=>'151.7702','5764'=>'151.8171','5794'=>'151.8612','5825'=>'151.9027','5855'=>'151.9418','5886'=>'151.9787','5916'=>'152.0135','5946'=>'152.0465','5977'=>'152.0776','6007'=>'152.1072','6038'=>'152.1352','6068'=>'152.1617',
				'6099'=>'152.187','6129'=>'152.211','6159'=>'152.2339','6190'=>'152.2556','6220'=>'152.2764','6251'=>'152.2962','6281'=>'152.3151','6311'=>'152.3332','6342'=>'152.3504','6372'=>'152.3669','6403'=>'152.3827','6433'=>'152.3979','6464'=>'152.4124','6494'=>'152.4263','6524'=>'152.4396','6555'=>'152.4524','6585'=>'152.4647',
				'6616'=>'152.4765','6646'=>'152.4878','6676'=>'152.4987','6707'=>'152.5092','6737'=>'152.5192','6768'=>'152.5289','6798'=>'152.5382','6829'=>'152.5472','6859'=>'152.5558','6889'=>'152.5641','6920'=>'152.5721','6950'=>'152.5798','6981'=>'152.5873','7011'=>'152.5944','7041'=>'152.6013',
				'7072'=>'152.6079','7102'=>'152.6143','7133'=>'152.6205','7163'=>'152.6265','7194'=>'152.6322','7224'=>'152.6377','7254'=>'152.6431','7285'=>'152.6482','7300'=>'152.6507');
		$percentile10Array=array('730'=>'80.52476','745'=>'80.91946','776'=>'81.73541','806'=>'82.53699','836'=>'83.31968','867'=>'84.07998','897'=>'84.81532','928'=>'85.52398','958'=>'86.205','989'=>'86.85807','1019'=>'87.48344','1049'=>'88.08186','1080'=>'88.6545','1110'=>'89.20285','1141'=>'89.74875','1171'=>'90.28811','1201'=>'90.82228',
				'1232'=>'91.35246','1262'=>'91.87972','1293'=>'92.40497','1323'=>'92.92901','1354'=>'93.45252','1384'=>'93.97609','1414'=>'94.50021','1445'=>'95.02528','1475'=>'95.55164','1506'=>'96.07954','1536'=>'96.60918','1566'=>'97.14072','1597'=>'97.67423','1627'=>'98.20976','1658'=>'98.74731','1688'=>'99.28686','1719'=>'99.82832','1749'=>'100.3716',
				'1779'=>'100.9165','1810'=>'101.463','1840'=>'102.0109','1871'=>'102.5599','1901'=>'103.1098','1931'=>'103.6604','1962'=>'104.2115','1992'=>'104.7628','2023'=>'105.3141','2053'=>'105.865','2084'=>'106.4154','2114'=>'106.9648','2144'=>'107.5131','2175'=>'108.0599','2205'=>'108.605','2236'=>'109.148','2266'=>'109.6888','2296'=>'110.227',
				'2327'=>'110.7623','2357'=>'111.2944','2388'=>'111.8232','2418'=>'112.3483','2449'=>'112.8696','2479'=>'113.3867','2509'=>'113.8995','2540'=>'114.4077','2570'=>'114.9112','2601'=>'115.4097','2631'=>'115.9031','2661'=>'116.3913','2692'=>'116.874','2722'=>'117.3512','2753'=>'117.8228','2783'=>'118.2886','2814'=>'118.7486','2844'=>'119.2028',
				'2874'=>'119.6511','2905'=>'120.0935','2935'=>'120.53','2966'=>'120.9607','2996'=>'121.3855','3026'=>'121.8047','3057'=>'122.2182','3087'=>'122.6263','3118'=>'123.0291','3148'=>'123.4268','3179'=>'123.8196','3209'=>'124.2078','3239'=>'124.5916','3270'=>'124.9715','3300'=>'125.3478','3331'=>'125.7208','3361'=>'126.0911','3391'=>'126.4592',
				'3422'=>'126.8255','3452'=>'127.1907','3483'=>'127.5554','3513'=>'127.9203','3544'=>'128.2861','3574'=>'128.6537','3604'=>'129.0238','3635'=>'129.3973','3665'=>'129.7752','3696'=>'130.1584','3726'=>'130.5479','3756'=>'130.9446','3787'=>'131.3496','3817'=>'131.7639','3848'=>'132.1885','3878'=>'132.6243','3909'=>'133.0721',
				'3939'=>'133.5329','3969'=>'134.0072','4000'=>'134.4955','4030'=>'134.9983','4061'=>'135.5157','4091'=>'136.0476','4121'=>'136.5937','4152'=>'137.1534','4182'=>'137.7259','4213'=>'138.31','4243'=>'138.9043','4274'=>'139.507','4304'=>'140.1161','4334'=>'140.7295','4365'=>'141.3448','4395'=>'141.9594','4426'=>'142.5709','4456'=>'143.1767','4486'=>'143.7741','4517'=>'144.3607','4547'=>'144.9342',
				'4578'=>'145.4925','4608'=>'146.0338','4639'=>'146.5564','4669'=>'147.059','4699'=>'147.5405','4730'=>'148.0002','4760'=>'148.4376','4791'=>'148.8525','4821'=>'149.2449','4851'=>'149.615','4882'=>'149.9633','4912'=>'150.2902','4943'=>'150.5966','4973'=>'150.8831','5004'=>'151.1507','5034'=>'151.4003','5064'=>'151.6329','5095'=>'151.8494','5125'=>'152.0508',
				'5156'=>'152.2381','5186'=>'152.4121','5216'=>'152.5738','5247'=>'152.7241','5277'=>'152.8638','5308'=>'152.9936','5338'=>'153.1143','5369'=>'153.2266','5399'=>'153.3312','5429'=>'153.4286','5460'=>'153.5193','5490'=>'153.604','5521'=>'153.683','5551'=>'153.7569','5581'=>'153.826','5612'=>'153.8907','5642'=>'153.9513','5673'=>'154.0082','5703'=>'154.0616','5734'=>'154.1119',
				'5764'=>'154.1592','5794'=>'154.2037','5825'=>'154.2457','5855'=>'154.2854','5886'=>'154.3229','5916'=>'154.3584','5946'=>'154.3919','5977'=>'154.4238','6007'=>'154.454','6038'=>'154.4827','6068'=>'154.51','6099'=>'154.5359','6129'=>'154.5607','6159'=>'154.5842','6190'=>'154.6067','6220'=>'154.6281','6251'=>'154.6486','6281'=>'154.6681','6311'=>'154.6868','6342'=>'154.7047','6372'=>'154.7218',
				'6403'=>'154.7382','6433'=>'154.754','6464'=>'154.769','6494'=>'154.7835','6524'=>'154.7974','6555'=>'154.8107','6585'=>'154.8235','6616'=>'154.8358','6646'=>'154.8476','6676'=>'154.859','6707'=>'154.8699','6737'=>'154.8804','6768'=>'154.8905','6798'=>'154.9003','6829'=>'154.9096','6859'=>'154.9187','6889'=>'154.9273','6920'=>'154.9357',
				'6950'=>'154.9438','6981'=>'154.9516','7011'=>'154.959','7041'=>'154.9663','7072'=>'154.9732','7102'=>'154.9799','7133'=>'154.9864','7163'=>'154.9926','7194'=>'154.9986','7224'=>'155.0044','7254'=>'155.01','7285'=>'155.0154','7300'=>'155.0181');
		$percentile25Array=array('730'=>'82.63524','745'=>'83.04213','776'=>'83.8943','806'=>'84.72592','836'=>'85.53389','867'=>'86.31589','897'=>'87.07028','928'=>'87.79609','958'=>'88.49291','989'=>'89.16084','1019'=>'89.80045','1049'=>'90.4127','1080'=>'90.99891','1110'=>'91.56066','1141'=>'92.12298',
				'1171'=>'92.67925','1201'=>'93.2307','1232'=>'93.7784','1262'=>'94.32334','1293'=>'94.86634','1323'=>'95.40817','1354'=>'95.94946','1384'=>'96.49076','1414'=>'97.03254','1445'=>'97.57519','1475'=>'98.11905','1506'=>'98.66436','1536'=>'99.21132','1566'=>'99.76009','1597'=>'100.3108','1627'=>'100.8634','1658'=>'101.418',
				'1688'=>'101.9745','1719'=>'102.5329','1749'=>'103.093','1779'=>'103.6549','1810'=>'104.2182','1840'=>'104.7829','1871'=>'105.3488','1901'=>'105.9156','1931'=>'106.4831','1962'=>'107.0512','1992'=>'107.6194','2023'=>'108.1877','2053'=>'108.7556','2084'=>'109.323','2114'=>'109.8895',
				'2144'=>'110.4549','2175'=>'111.0189','2205'=>'111.5812','2236'=>'112.1415','2266'=>'112.6996','2296'=>'113.255','2327'=>'113.8077','2357'=>'114.3572','2388'=>'114.9034','2418'=>'115.446','2449'=>'115.9847','2479'=>'116.5193','2509'=>'117.0496','2540'=>'117.5754','2570'=>'118.0964','2601'=>'118.6125','2631'=>'119.1235',
				'2661'=>'119.6293','2692'=>'120.1297','2722'=>'120.6246','2753'=>'121.1138','2783'=>'121.5974','2814'=>'122.0753','2844'=>'122.5473','2874'=>'123.0135','2905'=>'123.4739','2935'=>'123.9285','2966'=>'124.3774','2996'=>'124.8207','3026'=>'125.2584','3057'=>'125.6906','3087'=>'126.1177','3118'=>'126.5396','3148'=>'126.9568',
				'3179'=>'127.3694','3209'=>'127.7777','3239'=>'128.1822','3270'=>'128.5831','3300'=>'128.9808','3331'=>'129.3759','3361'=>'129.7689','3391'=>'130.1603','3422'=>'130.5506','3452'=>'130.9406','3483'=>'131.3309','3513'=>'131.7223','3544'=>'132.1156','3574'=>'132.5115','3604'=>'132.9109',
				'3635'=>'133.3147','3665'=>'133.7239','3696'=>'134.1394','3726'=>'134.562','3756'=>'134.9929','3787'=>'135.4328','3817'=>'135.8826','3848'=>'136.3433','3878'=>'136.8154','3909'=>'137.2997','3939'=>'137.7967','3969'=>'138.3067','4000'=>'138.83','4030'=>'139.3664',
				'4061'=>'139.9157','4091'=>'140.4775','4121'=>'141.051','4152'=>'141.6352','4182'=>'142.2288','4213'=>'142.8304','4243'=>'143.4381','4274'=>'144.0501','4304'=>'144.6641','4334'=>'145.278','4365'=>'145.8893',
				'4395'=>'146.4958','4426'=>'147.0949','4456'=>'147.6845','4486'=>'148.2623','4517'=>'148.8263','4547'=>'149.3747','4578'=>'149.9059','4608'=>'150.4184','4639'=>'150.9113','4669'=>'151.3835','4699'=>'151.8346','4730'=>'152.2642','4760'=>'152.6721','4791'=>'153.0584',
				'4821'=>'153.4234','4851'=>'153.7674','4882'=>'154.0911','4912'=>'154.3951','4943'=>'154.6801','4973'=>'154.947','5004'=>'155.1966','5034'=>'155.4298','5064'=>'155.6475','5095'=>'155.8507','5125'=>'156.0401','5156'=>'156.2167','5186'=>'156.3813','5216'=>'156.5348','5247'=>'156.6778',
				'5277'=>'156.8112','5308'=>'156.9356','5338'=>'157.0517','5369'=>'157.16','5399'=>'157.2612','5429'=>'157.3558','5460'=>'157.4443','5490'=>'157.5271','5521'=>'157.6047','5551'=>'157.6775','5581'=>'157.7458','5612'=>'157.8099','5642'=>'157.8702','5673'=>'157.927','5703'=>'157.9804','5734'=>'158.0308',
				'5764'=>'158.0784','5794'=>'158.1234','5825'=>'158.1659','5855'=>'158.2061','5886'=>'158.2442','5916'=>'158.2803','5946'=>'158.3146','5977'=>'158.3472','6007'=>'158.3782','6038'=>'158.4077','6068'=>'158.4357','6099'=>'158.4625','6129'=>'158.4879','6159'=>'158.5123','6190'=>'158.5355','6220'=>'158.5577',
				'6251'=>'158.5789','6281'=>'158.5992','6311'=>'158.6187','6342'=>'158.6373','6372'=>'158.6551','6403'=>'158.6722','6433'=>'158.6886','6464'=>'158.7043','6494'=>'158.7194','6524'=>'158.7339','6555'=>'158.7478','6585'=>'158.7612',
				'6616'=>'158.774','6646'=>'158.7864','6676'=>'158.7983','6707'=>'158.8097','6737'=>'158.8207','6768'=>'158.8313','6798'=>'158.8415','6829'=>'158.8514','6859'=>'158.8608','6889'=>'158.8699','6920'=>'158.8787','6950'=>'158.8872','6981'=>'158.8953','7011'=>'158.9032',
				'7041'=>'158.9107','7072'=>'158.918','7102'=>'158.9251','7133'=>'158.9319','7163'=>'158.9384','7194'=>'158.9447','7224'=>'158.9508','7254'=>'158.9567','7285'=>'158.9624','7300'=>'158.9651');
		$percentile50Array=array('730'=>'84.97556','745'=>'85.39732','776'=>'86.29026','806'=>'87.15714','836'=>'87.99602','867'=>'88.80551','897'=>'89.58477','928'=>'90.33342','958'=>'91.05154','989'=>'91.73964','1019'=>'92.39854','1049'=>'93.02945','1080'=>'93.63382','1110'=>'94.21336',
				'1141'=>'94.79643','1171'=>'95.37392','1201'=>'95.94693','1232'=>'96.51645','1262'=>'97.08337','1293'=>'97.64848','1323'=>'98.21247','1354'=>'98.77593','1384'=>'99.3394','1414'=>'99.90331','1445'=>'100.4681','1475'=>'101.0339','1506'=>'101.6012','1536'=>'102.17','1566'=>'102.7406',
				'1597'=>'103.313','1627'=>'103.8873','1658'=>'104.4635','1688'=>'105.0415','1719'=>'105.6213','1749'=>'106.2029','1779'=>'106.7861','1810'=>'107.3707','1840'=>'107.9566','1871'=>'108.5436','1901'=>'109.1316','1931'=>'109.7202','1962'=>'110.3092','1992'=>'110.8984','2023'=>'111.4876',
				'2053'=>'112.0764','2084'=>'112.6646','2114'=>'113.2519','2144'=>'113.838','2175'=>'114.4226','2205'=>'115.0055','2236'=>'115.5863','2266'=>'116.1648','2296'=>'116.7406','2327'=>'117.3136','2357'=>'117.8833','2388'=>'118.4496','2418'=>'119.0123','2449'=>'119.571','2479'=>'120.1254','2509'=>'120.6755',
				'2540'=>'121.221','2570'=>'121.7617','2601'=>'122.2974','2631'=>'122.8279','2661'=>'123.3531','2692'=>'123.8728','2722'=>'124.387','2753'=>'124.8956','2783'=>'125.3985','2814'=>'125.8956','2844'=>'126.3869','2874'=>'126.8724','2905'=>'127.3522','2935'=>'127.8263',
				'2966'=>'128.2947','2996'=>'128.7576','3026'=>'129.2152','3057'=>'129.6675','3087'=>'130.1148','3118'=>'130.5574','3148'=>'130.9954','3179'=>'131.4293','3209'=>'131.8593','3239'=>'132.2859','3270'=>'132.7094','3300'=>'133.1304','3331'=>'133.5493','3361'=>'133.9667','3391'=>'134.3832','3422'=>'134.7995',
				'3452'=>'135.2163','3483'=>'135.6342','3513'=>'136.054','3544'=>'136.4766','3574'=>'136.9027','3604'=>'137.3333','3635'=>'137.7691','3665'=>'138.2112','3696'=>'138.6602','3726'=>'139.1172','3756'=>'139.5829','3787'=>'140.0581','3817'=>'140.5435','3848'=>'141.0397','3878'=>'141.5472','3909'=>'142.0664',
				'3939'=>'142.5974','3969'=>'143.1404','4000'=>'143.695','4030'=>'144.2609','4061'=>'144.8376','4091'=>'145.424','4121'=>'146.0192','4152'=>'146.6217','4182'=>'147.23','4213'=>'147.8424','4243'=>'148.4569','4274'=>'149.0714','4304'=>'149.6839','4334'=>'150.292','4365'=>'150.8936','4395'=>'151.4866','4426'=>'152.0687',
				'4456'=>'152.6381','4486'=>'153.193','4517'=>'153.7317','4547'=>'154.2529','4578'=>'154.7555','4608'=>'155.2385','4639'=>'155.7012','4669'=>'156.1432','4699'=>'156.5643','4730'=>'156.9644','4760'=>'157.3437','4791'=>'157.7025','4821'=>'158.0411','4851'=>'158.3603','4882'=>'158.6606','4912'=>'158.9427','4943'=>'159.2075',
				'4973'=>'159.4557','5004'=>'159.6882','5034'=>'159.9058','5064'=>'160.1094','5095'=>'160.2997','5125'=>'160.4777','5156'=>'160.6441','5186'=>'160.7995','5216'=>'160.9449','5247'=>'161.0808','5277'=>'161.2079','5308'=>'161.3268','5338'=>'161.4381','5369'=>'161.5423','5399'=>'161.6399','5429'=>'161.7315','5460'=>'161.8174','5490'=>'161.898',
				'5521'=>'161.9738','5551'=>'162.045','5581'=>'162.112','5612'=>'162.1752','5642'=>'162.2347','5673'=>'162.2908','5703'=>'162.3439','5734'=>'162.394','5764'=>'162.4414','5794'=>'162.4862','5825'=>'162.5287','5855'=>'162.569','5886'=>'162.6072','5916'=>'162.6435','5946'=>'162.6781','5977'=>'162.7109','6007'=>'162.7421','6038'=>'162.7719',
				'6068'=>'162.8002','6099'=>'162.8273','6129'=>'162.8531','6159'=>'162.8778','6190'=>'162.9013','6220'=>'162.9238','6251'=>'162.9454','6281'=>'162.966','6311'=>'162.9858','6342'=>'163.0047','6372'=>'163.0228','6403'=>'163.0402','6433'=>'163.0569','6464'=>'163.0729','6494'=>'163.0882','6524'=>'163.103','6555'=>'163.1172','6585'=>'163.1308',
				'6616'=>'163.1439','6646'=>'163.1565','6676'=>'163.1686','6707'=>'163.1802','6737'=>'163.1914','6768'=>'163.2022','6798'=>'163.2126','6829'=>'163.2226','6859'=>'163.2322','6889'=>'163.2415','6920'=>'163.2504','6950'=>'163.259','6981'=>'163.2673','7011'=>'163.2753',
				'7041'=>'163.283','7072'=>'163.2904','7102'=>'163.2976','7133'=>'163.3045','7163'=>'163.3111','7194'=>'163.3175','7224'=>'163.3237','7254'=>'163.3297','7285'=>'163.3354','7300'=>'163.3383');
		$percentile75Array=array('730'=>'87.31121','745'=>'87.74918','776'=>'88.68344','806'=>'89.58751','836'=>'90.46018','867'=>'91.30065','897'=>'92.10859','928'=>'92.88403','958'=>'93.62741','989'=>'94.33951','1019'=>'95.0214','1049'=>'95.67446','1080'=>'96.30029','1110'=>'96.90071','1141'=>'97.50724','1171'=>'98.10855','1201'=>'98.70568','1232'=>'99.29957',
				'1262'=>'99.89104','1293'=>'100.4808','1323'=>'101.0696','1354'=>'101.6579','1384'=>'102.2462','1414'=>'102.835','1445'=>'103.4247','1475'=>'104.0154','1506'=>'104.6075','1536'=>'105.2012','1566'=>'105.7965','1597'=>'106.3936','1627'=>'106.9925','1658'=>'107.5933','1688'=>'108.1958','1719'=>'108.8001','1749'=>'109.406','1779'=>'110.0134','1810'=>'110.6222',
				'1840'=>'111.2321','1871'=>'111.8431','1901'=>'112.4548','1931'=>'113.0671','1962'=>'113.6797','1992'=>'114.2923','2023'=>'114.9048','2053'=>'115.5167','2084'=>'116.1278','2114'=>'116.7379','2144'=>'117.3466','2175'=>'117.9537','2205'=>'118.5588','2236'=>'119.1616','2266'=>'119.7619','2296'=>'120.3594','2327'=>'120.9537','2357'=>'121.5447','2388'=>'122.132','2418'=>'122.7154',
				'2449'=>'123.2946','2479'=>'123.8695','2509'=>'124.4397','2540'=>'125.0051','2570'=>'125.5655','2601'=>'126.1207','2631'=>'126.6706','2661'=>'127.215','2692'=>'127.7539','2722'=>'128.287','2753'=>'128.8144','2783'=>'129.3359','2814'=>'129.8516','2844'=>'130.3615','2874'=>'130.8656','2905'=>'131.364',
				'2935'=>'131.8567','2966'=>'132.3438','2996'=>'132.8255','3026'=>'133.302','3057'=>'133.7734','3087'=>'134.2401','3118'=>'134.7023','3148'=>'135.1604','3179'=>'135.6146','3209'=>'136.0654','3239'=>'136.5132','3270'=>'136.9585','3300'=>'137.4018','3331'=>'137.8437','3361'=>'138.2847','3391'=>'138.7256','3422'=>'139.1669',
				'3452'=>'139.6094','3483'=>'140.0538','3513'=>'140.501','3544'=>'140.9516','3574'=>'141.4065','3604'=>'141.8665','3635'=>'142.3324','3665'=>'142.8051','3696'=>'143.2852','3726'=>'143.7735','3756'=>'144.2707','3787'=>'144.7773','3817'=>'145.2938','3848'=>'145.8206','3878'=>'146.3579','3909'=>'146.9059','3939'=>'147.4643','3969'=>'148.0329',
				'4000'=>'148.6111','4030'=>'149.1984','4061'=>'149.7937','4091'=>'150.3959','4121'=>'151.0036','4152'=>'151.6153','4182'=>'152.2293','4213'=>'152.8438','4243'=>'153.4568','4274'=>'154.0662','4304'=>'154.67','4334'=>'155.2663','4365'=>'155.8529',
				'4395'=>'156.428','4426'=>'156.9899','4456'=>'157.5369','4486'=>'158.0677','4517'=>'158.581','4547'=>'159.0758','4578'=>'159.5513','4608'=>'160.007','4639'=>'160.4425','4669'=>'160.8576','4699'=>'161.2524','4730'=>'161.627','4760'=>'161.9818','4791'=>'162.3172',
				'4821'=>'162.6338','4851'=>'162.9321','4882'=>'163.2129','4912'=>'163.477','4943'=>'163.725','4973'=>'163.9577','5004'=>'164.1761','5034'=>'164.3808','5064'=>'164.5726','5095'=>'164.7523','5125'=>'164.9206','5156'=>'165.0783','5186'=>'165.226','5216'=>'165.3644','5247'=>'165.4941','5277'=>'165.6157',
				'5308'=>'165.7297','5338'=>'165.8366','5369'=>'165.9369','5399'=>'166.0312','5429'=>'166.1197','5460'=>'166.2029','5490'=>'166.2812','5521'=>'166.3549','5551'=>'166.4244','5581'=>'166.4898','5612'=>'166.5516','5642'=>'166.6099','5673'=>'166.6649','5703'=>'166.717','5734'=>'166.7663',
				'5764'=>'166.8129','5794'=>'166.8571','5825'=>'166.899','5855'=>'166.9388','5886'=>'166.9766','5916'=>'167.0125','5946'=>'167.0466','5977'=>'167.0791','6007'=>'167.11','6038'=>'167.1395','6068'=>'167.1676','6099'=>'167.1944','6129'=>'167.22','6159'=>'167.2444','6190'=>'167.2677','6220'=>'167.29','6251'=>'167.3114',
				'6281'=>'167.3318','6311'=>'167.3514','6342'=>'167.3701','6372'=>'167.3881','6403'=>'167.4053','6433'=>'167.4218','6464'=>'167.4376','6494'=>'167.4528','6524'=>'167.4674','6555'=>'167.4814','6585'=>'167.4948','6616'=>'167.5078','6646'=>'167.5202','6676'=>'167.5321',
				'6707'=>'167.5436','6737'=>'167.5546','6768'=>'167.5653','6798'=>'167.5755','6829'=>'167.5853','6859'=>'167.5948','6889'=>'167.6039','6920'=>'167.6127','6950'=>'167.6211','6981'=>'167.6293','7011'=>'167.6371','7041'=>'167.6446','7072'=>'167.6519','7102'=>'167.6589','7133'=>'167.6657','7163'=>'167.6722','7194'=>'167.6785',
				'7224'=>'167.6845','7254'=>'167.6904','7285'=>'167.696','7300'=>'167.6987');
		$percentile90Array=array('730'=>'89.40951','745'=>'89.86316','776'=>'90.83505','806'=>'91.77421','836'=>'92.67969','867'=>'93.55097','897'=>'94.38793','928'=>'95.19083','958'=>'95.9603','989'=>'96.69729','1019'=>'97.40303','1049'=>'98.07904','1080'=>'98.72705','1110'=>'99.34899','1141'=>'99.97896','1171'=>'100.604','1201'=>'101.2251','1232'=>'101.8432',
				'1262'=>'102.459','1293'=>'103.0732','1323'=>'103.6866','1354'=>'104.2996','1384'=>'104.9128','1414'=>'105.5264','1445'=>'106.141','1475'=>'106.7567','1506'=>'107.3737','1536'=>'107.9924','1566'=>'108.6127','1597'=>'109.2347','1627'=>'109.8585','1658'=>'110.4841','1688'=>'111.1114','1719'=>'111.7404','1749'=>'112.3709',
				'1779'=>'113.0028','1810'=>'113.6359','1840'=>'114.2701','1871'=>'114.9052','1901'=>'115.5408','1931'=>'116.1768','1962'=>'116.813','1992'=>'117.449','2023'=>'118.0845','2053'=>'118.7193','2084'=>'119.3531','2114'=>'119.9855','2144'=>'120.6163','2175'=>'121.2452','2205'=>'121.8718','2236'=>'122.4959','2266'=>'123.1171','2296'=>'123.7352',
				'2327'=>'124.3499','2357'=>'124.9608','2388'=>'125.5678','2418'=>'126.1705','2449'=>'126.7688','2479'=>'127.3623','2509'=>'127.951','2540'=>'128.5345','2570'=>'129.1127','2601'=>'129.6855','2631'=>'130.2526','2661'=>'130.814','2692'=>'131.3696','2722'=>'131.9194','2753'=>'132.4631','2783'=>'133.0009','2814'=>'133.5328','2844'=>'134.0587','2874'=>'134.5787',
				'2905'=>'135.093','2935'=>'135.6015','2966'=>'136.1046','2996'=>'136.6024','3026'=>'137.095','3057'=>'137.5828','3087'=>'138.066','3118'=>'138.545','3148'=>'139.0201','3179'=>'139.4918','3209'=>'139.9604','3239'=>'140.4265','3270'=>'140.8906','3300'=>'141.3532','3331'=>'141.8149','3361'=>'142.2764','3391'=>'142.7382','3422'=>'143.2012','3452'=>'143.666','3483'=>'144.1333',
				'3513'=>'144.6039','3544'=>'145.0785','3574'=>'145.5579','3604'=>'146.0429','3635'=>'146.5341','3665'=>'147.0322','3696'=>'147.5379','3726'=>'148.0517','3756'=>'148.5741','3787'=>'149.1054','3817'=>'149.646','3848'=>'150.196','3878'=>'150.7552','3909'=>'151.3236','3939'=>'151.9008','3969'=>'152.4861','4000'=>'153.079','4030'=>'153.6783','4061'=>'154.283','4091'=>'154.8918',
				'4121'=>'155.5032','4152'=>'156.1156','4182'=>'156.7273','4213'=>'157.3365','4243'=>'157.9413','4274'=>'158.5398','4304'=>'159.1302','4334'=>'159.7107','4365'=>'160.2796','4395'=>'160.8353','4426'=>'161.3764','4456'=>'161.9016','4486'=>'162.4097','4517'=>'162.8999','4547'=>'163.3715','4578'=>'163.8239','4608'=>'164.2568','4639'=>'164.6701','4669'=>'165.0637','4699'=>'165.4378','4730'=>'165.7928',
				'4760'=>'166.1289','4791'=>'166.4466','4821'=>'166.7467','4851'=>'167.0296','4882'=>'167.2961','4912'=>'167.5469','4943'=>'167.7826','4973'=>'168.0042','5004'=>'168.2122','5034'=>'168.4075','5064'=>'168.5907','5095'=>'168.7626','5125'=>'168.9239','5156'=>'169.0751',
				'5186'=>'169.217','5216'=>'169.3501','5247'=>'169.4749','5277'=>'169.5921','5308'=>'169.7022','5338'=>'169.8055','5369'=>'169.9026','5399'=>'169.9939','5429'=>'170.0798','5460'=>'170.1606','5490'=>'170.2366','5521'=>'170.3083','5551'=>'170.3759','5581'=>'170.4396','5612'=>'170.4997','5642'=>'170.5566','5673'=>'170.6103',
				'5703'=>'170.6611','5734'=>'170.7091','5764'=>'170.7546','5794'=>'170.7978','5825'=>'170.8387','5855'=>'170.8775','5886'=>'170.9144','5916'=>'170.9494','5946'=>'170.9827','5977'=>'171.0144','6007'=>'171.0446','6038'=>'171.0733','6068'=>'171.1007','6099'=>'171.1268','6129'=>'171.1517','6159'=>'171.1754','6190'=>'171.1981','6220'=>'171.2198','6251'=>'171.2405','6281'=>'171.2604',
				'6311'=>'171.2793','6342'=>'171.2975','6372'=>'171.3149','6403'=>'171.3315','6433'=>'171.3475','6464'=>'171.3628','6494'=>'171.3775','6524'=>'171.3915','6555'=>'171.405','6585'=>'171.418','6616'=>'171.4304','6646'=>'171.4424','6676'=>'171.4538','6707'=>'171.4649','6737'=>'171.4755','6768'=>'171.4856','6798'=>'171.4954','6829'=>'171.5049','6859'=>'171.5139',
				'6889'=>'171.5226','6920'=>'171.531','6950'=>'171.5391','6981'=>'171.5468','7011'=>'171.5543','7041'=>'171.5615','7072'=>'171.5684','7102'=>'171.5751','7133'=>'171.5815','7163'=>'171.5877','7194'=>'171.5937',
				'7224'=>'171.5994','7254'=>'171.6049','7285'=>'171.6103','7300'=>'171.6129');
		$percentile95Array=array('730'=>'90.66355','745'=>'91.12707','776'=>'92.12168','806'=>'93.08254','836'=>'94.00873','867'=>'94.89974','897'=>'95.75551','928'=>'96.57635','958'=>'97.36295','989'=>'98.11632','1019'=>'98.83778','1049'=>'99.52891','1080'=>'100.1915','1110'=>'100.8276','1141'=>'101.4726','1171'=>'102.1129','1201'=>'102.7494','1232'=>'103.383','1262'=>'104.0144','1293'=>'104.6444','1323'=>'105.2736','1354'=>'105.9025',
				'1384'=>'106.5316','1414'=>'107.1613','1445'=>'107.7919','1475'=>'108.4238','1506'=>'109.057','1536'=>'109.6918','1566'=>'110.3283','1597'=>'110.9665','1627'=>'111.6066','1658'=>'112.2483','1688'=>'112.8917','1719'=>'113.5368','1749'=>'114.1833','1779'=>'114.8312','1810'=>'115.4802','1840'=>'116.1301','1871'=>'116.7808','1901'=>'117.432','1931'=>'118.0834','1962'=>'118.7348','1992'=>'119.3858','2023'=>'120.0362',
				'2053'=>'120.6857','2084'=>'121.334','2114'=>'121.9807','2144'=>'122.6256','2175'=>'123.2684','2205'=>'123.9086','2236'=>'124.5461','2266'=>'125.1804','2296'=>'125.8114','2327'=>'126.4387','2357'=>'127.062','2388'=>'127.6811','2418'=>'128.2957','2449'=>'128.9056','2479'=>'129.5105','2509'=>'130.1103','2540'=>'130.7047','2570'=>'131.2936','2601'=>'131.8768','2631'=>'132.4542','2661'=>'133.0256','2692'=>'133.5911',
				'2722'=>'134.1505','2753'=>'134.7038','2783'=>'135.251','2814'=>'135.7922','2844'=>'136.3273','2874'=>'136.8565','2905'=>'137.3798','2935'=>'137.8975','2966'=>'138.4097','2996'=>'138.9166','3026'=>'139.4184','3057'=>'139.9155','3087'=>'140.4082','3118'=>'140.8968',
				'3148'=>'141.3817','3179'=>'141.8633','3209'=>'142.3422','3239'=>'142.8188','3270'=>'143.2937','3300'=>'143.7674','3331'=>'144.2406','3361'=>'144.7139','3391'=>'145.1879','3422'=>'145.6634','3452'=>'146.141','3483'=>'146.6215','3513'=>'147.1056','3544'=>'147.594','3574'=>'148.0874','3604'=>'148.5865','3635'=>'149.092',
				'3665'=>'149.6044','3696'=>'150.1242','3726'=>'150.652','3756'=>'151.188','3787'=>'151.7325','3817'=>'152.2856','3848'=>'152.8473','3878'=>'153.4174','3909'=>'153.9955','3939'=>'154.5812','3969'=>'155.1737','4000'=>'155.7721','4030'=>'156.3755','4061'=>'156.9825','4091'=>'157.5918','4121'=>'158.202','4152'=>'158.8115','4182'=>'159.4185',
				'4213'=>'160.0213','4243'=>'160.6182','4274'=>'161.2075','4304'=>'161.7874','4334'=>'162.3564','4365'=>'162.9129','4395'=>'163.4555','4426'=>'163.983','4456'=>'164.4943','4486'=>'164.9885','4517'=>'165.4648','4547'=>'165.9227','4578'=>'166.3618','4608'=>'166.7819','4639'=>'167.1829',
				'4669'=>'167.5648','4699'=>'167.9278','4730'=>'168.2723','4760'=>'168.5987','4791'=>'168.9074','4821'=>'169.199','4851'=>'169.4742','4882'=>'169.7335','4912'=>'169.9777','4943'=>'170.2074','4973'=>'170.4234','5004'=>'170.6263','5034'=>'170.817','5064'=>'170.9959','5095'=>'171.1639','5125'=>'171.3216','5156'=>'171.4696','5186'=>'171.6085','5216'=>'171.7388',
				'5247'=>'171.8611','5277'=>'171.976','5308'=>'172.0839','5338'=>'172.1853','5369'=>'172.2806','5399'=>'172.3701','5429'=>'172.4544','5460'=>'172.5337','5490'=>'172.6084','5521'=>'172.6787','5551'=>'172.7451','5581'=>'172.8076','5612'=>'172.8667','5642'=>'172.9225','5673'=>'172.9752','5703'=>'173.025','5734'=>'173.0722','5764'=>'173.1168',
				'5794'=>'173.1591','5825'=>'173.1992','5855'=>'173.2373','5886'=>'173.2734','5916'=>'173.3077','5946'=>'173.3402','5977'=>'173.3712','6007'=>'173.4007','6038'=>'173.4288','6068'=>'173.4555','6099'=>'173.481','6129'=>'173.5053','6159'=>'173.5284','6190'=>'173.5505','6220'=>'173.5716','6251'=>'173.5918','6281'=>'173.6111','6311'=>'173.6295','6342'=>'173.6471','6372'=>'173.664',
				'6403'=>'173.6802','6433'=>'173.6956','6464'=>'173.7104','6494'=>'173.7246','6524'=>'173.7382','6555'=>'173.7513','6585'=>'173.7638','6616'=>'173.7758','6646'=>'173.7873','6676'=>'173.7984','6707'=>'173.809','6737'=>'173.8192','6768'=>'173.829',
				'6798'=>'173.8384','6829'=>'173.8474','6859'=>'173.8561','6889'=>'173.8645','6920'=>'173.8725','6950'=>'173.8802','6981'=>'173.8877','7011'=>'173.8948','7041'=>'173.9017','7072'=>'173.9083','7102'=>'173.9147','7133'=>'173.9208','7163'=>'173.9267','7194'=>'173.9324',
				'7224'=>'173.9379','7254'=>'173.9432','7285'=>'173.9482','7300'=>'173.9507');
		$percentile97Array=array('730'=>'91.47729','745'=>'91.94741','776'=>'92.95685','806'=>'93.93209','836'=>'94.87215','867'=>'95.77649','897'=>'96.64505','928'=>'97.47814','958'=>'98.27646','989'=>'99.04107','1019'=>'99.77332','1049'=>'100.4748','1080'=>'101.1474','1110'=>'101.7931','1141'=>'102.4485',
				'1171'=>'103.0991','1201'=>'103.746','1232'=>'104.3901','1262'=>'105.032','1293'=>'105.6727','1323'=>'106.3126','1354'=>'106.9523','1384'=>'107.5922','1414'=>'108.2328','1445'=>'108.8744','1475'=>'109.5172','1506'=>'110.1614','1536'=>'110.8073','1566'=>'111.4548','1597'=>'112.1041','1627'=>'112.7552','1658'=>'113.4079',
				'1688'=>'114.0624','1719'=>'114.7184','1749'=>'115.3759','1779'=>'116.0347','1810'=>'116.6945','1840'=>'117.3552','1871'=>'118.0166','1901'=>'118.6783','1931'=>'119.3402','1962'=>'120.0019','1992'=>'120.6632','2023'=>'121.3238','2053'=>'121.9832','2084'=>'122.6413','2114'=>'123.2977','2144'=>'123.9521','2175'=>'124.6042','2205'=>'125.2536',
				'2236'=>'125.9','2266'=>'126.5432','2296'=>'127.1827','2327'=>'127.8184','2357'=>'128.45','2388'=>'129.0771','2418'=>'129.6996','2449'=>'130.3171','2479'=>'130.9295','2509'=>'131.5365','2540'=>'132.138','2570'=>'132.7338','2601'=>'133.3238','2631'=>'133.9077','2661'=>'134.4857','2692'=>'135.0574','2722'=>'135.623',
				'2753'=>'136.1824','2783'=>'136.7356','2814'=>'137.2826','2844'=>'137.8236','2874'=>'138.3585','2905'=>'138.8876','2935'=>'139.411','2966'=>'139.9289','2996'=>'140.4415','3026'=>'140.9492','3057'=>'141.4521','3087'=>'141.9507','3118'=>'142.4454','3148'=>'142.9364','3179'=>'143.4244','3209'=>'143.9098','3239'=>'144.393',
				'3270'=>'144.8747','3300'=>'145.3555','3331'=>'145.8359','3361'=>'146.3167','3391'=>'146.7984','3422'=>'147.2818','3452'=>'147.7676','3483'=>'148.2564','3513'=>'148.7491','3544'=>'149.2461','3574'=>'149.7484','3604'=>'150.2564','3635'=>'150.7707','3665'=>'151.292','3696'=>'151.8205','3726'=>'152.3568','3756'=>'152.9011','3787'=>'153.4534',
				'3817'=>'154.0139','3848'=>'154.5824','3878'=>'155.1586','3909'=>'155.742','3939'=>'156.3321','3969'=>'156.928','4000'=>'157.5288','4030'=>'158.1335','4061'=>'158.7407','4091'=>'159.3491','4121'=>'159.9571','4152'=>'160.5633','4182'=>'161.166','4213'=>'161.7634','4243'=>'162.3541','4274'=>'162.9363','4304'=>'163.5084','4334'=>'164.069','4365'=>'164.6167',
				'4395'=>'165.1503','4426'=>'165.6685','4456'=>'166.1706','4486'=>'166.6555','4517'=>'167.1228','4547'=>'167.572','4578'=>'168.0027','4608'=>'168.4147','4639'=>'168.808','4669'=>'169.1827','4699'=>'169.5391',
				'4730'=>'169.8773','4760'=>'170.1979','4791'=>'170.5013','4821'=>'170.7881','4851'=>'171.0587','4882'=>'171.314','4912'=>'171.5544','4943'=>'171.7807','4973'=>'171.9935','5004'=>'172.1936','5034'=>'172.3816','5064'=>'172.5582','5095'=>'172.7239','5125'=>'172.8796','5156'=>'173.0257','5186'=>'173.1628','5216'=>'173.2915','5247'=>'173.4124',
				'5277'=>'173.5258','5308'=>'173.6324','5338'=>'173.7326','5369'=>'173.8267','5399'=>'173.9152','5429'=>'173.9984','5460'=>'174.0768','5490'=>'174.1505','5521'=>'174.22','5551'=>'174.2855','5581'=>'174.3472','5612'=>'174.4055','5642'=>'174.4606','5673'=>'174.5125','5703'=>'174.5617',
				'5734'=>'174.6082','5764'=>'174.6522','5794'=>'174.6938','5825'=>'174.7333','5855'=>'174.7708','5886'=>'174.8063','5916'=>'174.84','5946'=>'174.8721','5977'=>'174.9025','6007'=>'174.9314','6038'=>'174.959','6068'=>'174.9852','6099'=>'175.0102','6129'=>'175.034','6159'=>'175.0567','6190'=>'175.0783',
				'6220'=>'175.099','6251'=>'175.1187','6281'=>'175.1376','6311'=>'175.1556','6342'=>'175.1728','6372'=>'175.1892','6403'=>'175.205','6433'=>'175.2201','6464'=>'175.2345','6494'=>'175.2483','6524'=>'175.2616','6555'=>'175.2742','6585'=>'175.2864','6616'=>'175.2981','6646'=>'175.3093','6676'=>'175.32','6707'=>'175.3303',
				'6737'=>'175.3402','6768'=>'175.3497','6798'=>'175.3588','6829'=>'175.3675','6859'=>'175.376','6889'=>'175.384','6920'=>'175.3918','6950'=>'175.3993','6981'=>'175.4064','7011'=>'175.4133','7041'=>'175.42','7072'=>'175.4264','7102'=>'175.4325','7133'=>'175.4384',
				'7163'=>'175.4441','7194'=>'175.4496','7224'=>'175.4548','7254'=>'175.4599','7285'=>'175.4648','7300'=>'175.4671');
		$this->set(compact('percentile3Array','percentile5Array','percentile10Array','percentile25Array','percentile50Array','percentile75Array','percentile85Array','percentile90Array','percentile95Array','percentile97Array'));
		$this->set('diagnosis',$diagnosis);
		$this->set('bmi_array',$bmi_Day);
		$this->set(compact('year','month','date','patient_name'));
	}
	public function bmi_infants_weightforlength_male($id=null)
	{
		//debug($id);
		$this->layout=false;
		$this->set('title_for_layout', __('Growth Chart', true));
		$this->uses = array('Patient','BmiResult');
		$this->Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$this->Patient->bindModel( array(
				'belongsTo' => array(
						'BmiResult'=>array('conditions'=>array('BmiResult.patient_id=Patient.id'),'foreignKey'=>false),
						'Person'=>array('conditions'=>array('Person.id=Patient.person_id'),'foreignKey'=>false)
				)
		));

		$diagnosis = $this->Patient->find('all',array('fields'=>array('BmiResult.height,BmiResult.height_result,BmiResult.weight,BmiResult.weight_volume,BmiResult.bmi,BmiResult.patient_id,BmiResult.created_time,
				Patient.age,Patient.admission_type,Person.sex,Person.dob,Patient.lookup_name'),'conditions'=>array('Patient.person_id'=>$id,'Patient.is_deleted'=>0,'Patient.admission_type'=>'OPD'),'order' => array('Patient.id' => 'asc')));
		foreach($diagnosis as $data)
		{
			$varDate=$this->DateFormat->dateDiff($data['Person']['dob'],$data['BmiResult']['created_time']);
			$var=explode(" ",$data['BmiResult']['height_result']);
			//converting the height into mm
			$height=$var[0]*10;
			//----------------------
			$height_array[$height]=$var[0];
			$year[$height]=$varDate->y;
			$month[$height]=$varDate->m;
			$date[$height]=$data['BmiResult']['created_time'];
			$patient_name=$data['Patient']['lookup_name'];
			if($data['BmiResult']['weight_volume']=='Kg')
			{
				$bmi_Day[$height][]=$data['BmiResult']['weight'];

			}
			elseif($data['BmiResult']['weight_volume']=='lbs')
			{
				$weight=explode(" ",$data['BmiResult']['weight_result']);
				$bmi_Day[$height][]=$weight[0];
			}
			$i++;
		}
		$this->Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$this->Patient->bindModel(array(
				'belongsTo'=>array(
						'ReviewPatientDetail'=>array('conditions'=>array('ReviewPatientDetail.patient_id=Patient.id'),'foreignKey'=>false),
						'ReviewSubCategoriesOption'=>array(
								'conditions'=>array('ReviewSubCategoriesOption.name LIKE'=>"%".Configure::read('bmi_weight_measured')."%"),'foreignKey'=>false),
						'Person'=>array('conditions'=>array('Person.id=Patient.person_id'),'foreignKey'=>false)
				)));
		$diagnosis1 = $this->Patient->find('all',array('fields'=>array('ReviewPatientDetail.values,ReviewPatientDetail.date,
				Patient.age,Patient.admission_type,Person.sex,Person.dob,Patient.lookup_name,ReviewSubCategoriesOption.id'),
				'conditions'=>array('Patient.person_id'=>$id,'ReviewSubCategoriesOption.id=ReviewPatientDetail.review_sub_categories_options_id','ReviewPatientDetail.edited_on IS NULL','Patient.is_deleted'=>0,'Patient.admission_type'=>'IPD'),'order' => array('Patient.id' => 'asc')));

		$this->Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));

		$this->Patient->bindModel(array(
				'belongsTo'=>array(
						'ReviewPatientDetail'=>array('conditions'=>array('ReviewPatientDetail.patient_id=Patient.id'),'foreignKey'=>false),
						'ReviewSubCategoriesOption'=>array(
								'conditions'=>array('ReviewSubCategoriesOption.name LIKE'=>"%".Configure::read('bmi_height_measured')."%"),'foreignKey'=>false),
						'Person'=>array('conditions'=>array('Person.id=Patient.person_id'),'foreignKey'=>false)
				)));
		$diagnosis2 = $this->Patient->find('all',array('fields'=>array('ReviewPatientDetail.values,ReviewPatientDetail.date,
				Patient.age,Patient.admission_type,Person.sex,Person.dob,Patient.lookup_name,ReviewSubCategoriesOption.id'),
				'conditions'=>array('Patient.person_id'=>$id,'ReviewSubCategoriesOption.id=ReviewPatientDetail.review_sub_categories_options_id','ReviewPatientDetail.edited_on IS NULL','Patient.is_deleted'=>0,'Patient.admission_type'=>'IPD'),'order' => array('Patient.id' => 'asc')));
		$i=0;
		foreach($diagnosis1 as $data)
		{
			$height=$diagnosis2[$i]['ReviewPatientDetail']['values']*10;//Converting height in centimeter
			$height_array[$height]=$diagnosis2[$i]['ReviewPatientDetail']['values'];
			$var=$this->DateFormat->dateDiff($data['Person']['dob'],$data['ReviewPatientDetail']['date']);
			$year[$height]=$var->y;
			$date[$height]=$data['ReviewPatientDetail']['date'];
			$patient_name=$data['Patient']['lookup_name'];
			$month[$day]=$var->m;
			$bmi_Day[$height][]=$data['ReviewPatientDetail']['values'];
			$i++;
		}

		$percentile3Array=array('450'=>'1.597029','455'=>'1.702957','465'=>'1.918742','475'=>'2.139283','485'=>'2.364026','495'=>'2.592431','505'=>'2.823967','515'=>'3.058104','525'=>'3.294322','535'=>'3.53211','545'=>'3.770975',
				'555'=>'4.010448','565'=>'4.250088','575'=>'4.489486','585'=>'4.728267','595'=>'4.966097','605'=>'5.202677','615'=>'5.437748','625'=>'5.671089','635'=>'5.902516','645'=>'6.131881','655'=>'6.359068',
				'665'=>'6.583998','675'=>'6.806616','685'=>'7.026901','695'=>'7.244856','705'=>'7.46051','715'=>'7.673914','725'=>'7.88514','735'=>'8.094285','745'=>'8.301459','755'=>'8.506795','765'=>'8.710439',
				'775'=>'8.912556','785'=>'9.113322','795'=>'9.312931','805'=>'9.511587','815'=>'9.709506','825'=>'9.906918','835'=>'10.10406','845'=>'10.30118','855'=>'10.49853','865'=>'10.69638','875'=>'10.89501',
				'885'=>'11.09468','895'=>'11.29567','905'=>'11.49829','915'=>'11.70281','925'=>'11.90954','935'=>'12.11877','945'=>'12.33079','955'=>'12.54591','965'=>'12.76442','975'=>'12.98661','985'=>'13.21277',
				'995'=>'13.4432','1005'=>'13.67815','1015'=>'13.9179','1025'=>'14.1627','1035'=>'14.41278');
		$percentile5Array=array('450'=>'1.690594','455'=>'1.792955','465'=>'2.003061','475'=>'2.219514','485'=>'2.441422','495'=>'2.667982','505'=>'2.898464','515'=>'3.132187','525'=>'3.368517',
				'535'=>'3.60686','545'=>'3.846658','555'=>'4.087392','565'=>'4.328585','575'=>'4.569795','585'=>'4.810625','595'=>'5.050717','605'=>'5.289754','615'=>'5.52746',
				'625'=>'5.763596','635'=>'5.997962','645'=>'6.230396','655'=>'6.460765','665'=>'6.688975','675'=>'6.914958','685'=>'7.138676','695'=>'7.360121','705'=>'7.579308',
				'715'=>'7.796275','725'=>'8.011085','735'=>'8.223823','745'=>'8.434591','755'=>'8.643512','765'=>'8.850726','775'=>'9.056391','785'=>'9.260678','795'=>'9.463776',
				'805'=>'9.665884','815'=>'9.867216','825'=>'10.068','835'=>'10.26846','845'=>'10.46885','855'=>'10.66943','865'=>'10.87044','875'=>'11.07217',
				'885'=>'11.27489','895'=>'11.47887','905'=>'11.68439','915'=>'11.89175','925'=>'12.10123','935'=>'12.31313','945'=>'12.52772','955'=>'12.74531',
				'965'=>'12.96617','975'=>'13.19061','985'=>'13.41889','995'=>'13.65129','1005'=>'13.88809','1015'=>'14.12954','1025'=>'14.3759','1035'=>'14.62739');
		$percentile10Array=array('450'=>'1.830303','455'=>'1.928805','465'=>'2.132607','475'=>'2.344442','485'=>'2.563171','495'=>'2.787763','505'=>'3.017289','515'=>'3.250908',
				'525'=>'3.487856','535'=>'3.727435','545'=>'3.969008','555'=>'4.211993','565'=>'4.45586','575'=>'4.700128','585'=>'4.944362','595'=>'5.188173','605'=>'5.431217',
				'615'=>'5.67319','625'=>'5.913829','635'=>'6.152907','645'=>'6.390239','655'=>'6.625668','665'=>'6.859076','675'=>'7.090373','685'=>'7.3195','695'=>'7.546426',
				'705'=>'7.771148','715'=>'7.993688','725'=>'8.214092','735'=>'8.432429','745'=>'8.648791','755'=>'8.863288','765'=>'9.076053','775'=>'9.287233','785'=>'9.496996',
				'795'=>'9.705524','805'=>'9.913012','815'=>'10.11967','825'=>'10.32573','835'=>'10.53141','845'=>'10.73696','855'=>'10.94264','865'=>'11.1487',
				'875'=>'11.35541','885'=>'11.56304','895'=>'11.77186','905'=>'11.98216','915'=>'12.19422','925'=>'12.40832','935'=>'12.62473','945'=>'12.84375',
				'955'=>'13.06565','965'=>'13.2907','975'=>'13.51919','985'=>'13.75137','995'=>'13.98752','1005'=>'14.22789','1015'=>'14.47272','1025'=>'14.72227','1035'=>'14.97676');
		$percentile25Array=array('450'=>'2.053702','455'=>'2.149314','465'=>'2.348353','475'=>'2.556834','485'=>'2.773594','495'=>'2.997515','505'=>'3.227549','515'=>'3.462736',
				'525'=>'3.702195','535'=>'3.94513','545'=>'4.190816','555'=>'4.438598','565'=>'4.687883','575'=>'4.938134','585'=>'5.188867','595'=>'5.439648','605'=>'5.690087',
				'615'=>'5.939837','625'=>'6.188595','635'=>'6.436094','645'=>'6.682104','655'=>'6.926433','665'=>'7.168923','675'=>'7.409447','685'=>'7.647914','695'=>'7.884259',
				'705'=>'8.118452','715'=>'8.350489','725'=>'8.580393','735'=>'8.808215','745'=>'9.034032','755'=>'9.257943','765'=>'9.48007','775'=>'9.700557','785'=>'9.919568',
				'795'=>'10.13728','805'=>'10.3539','815'=>'10.56964','825'=>'10.78473','835'=>'10.9994','845'=>'11.2139','855'=>'11.4285','865'=>'11.64347','875'=>'11.85907',
				'885'=>'12.07558','895'=>'12.29329','905'=>'12.51247','915'=>'12.73341','925'=>'12.95639','935'=>'13.18168','945'=>'13.40955','955'=>'13.64028','965'=>'13.87412',
				'975'=>'14.11134','985'=>'14.35217','995'=>'14.59685','1005'=>'14.84563','1015'=>'15.09871','1025'=>'15.35633','1035'=>'15.61869');
		$percentile50Array=array('450'=>'2.289758','455'=>'2.386172','465'=>'2.587098','475'=>'2.797953','485'=>'3.01768','495'=>'3.245226','505'=>'3.479568','515'=>'3.71974',
				'525'=>'3.964838','535'=>'4.214033','545'=>'4.466563','555'=>'4.721731','565'=>'4.978904','575'=>'5.237505','585'=>'5.497009','595'=>'5.75694',
				'605'=>'6.016867','615'=>'6.276401','625'=>'6.535196','635'=>'6.792942','645'=>'7.04937','655'=>'7.304249','665'=>'7.557382','675'=>'7.80861','685'=>'8.05781',
				'695'=>'8.304892','705'=>'8.549803','715'=>'8.79252','725'=>'9.033055','735'=>'9.271449','745'=>'9.507774','755'=>'9.742129','765'=>'9.974642','775'=>'10.20546',
				'785'=>'10.43477','795'=>'10.66275','805'=>'10.88963','815'=>'11.11563','825'=>'11.34101','835'=>'11.56604','845'=>'11.79097','855'=>'12.01611','865'=>'12.24174',
				'875'=>'12.46816','885'=>'12.69567','895'=>'12.92459','905'=>'13.1552','915'=>'13.38782','925'=>'13.62274','935'=>'13.86026','945'=>'14.10065','955'=>'14.3442',
				'965'=>'14.59115','975'=>'14.84177','985'=>'15.09629','995'=>'15.35493','1005'=>'15.6179','1015'=>'15.88539','1025'=>'16.1576','1035'=>'16.43469');
		$percentile75Array=array('450'=>'2.515339','455'=>'2.615766','465'=>'2.824925','475'=>'3.044241','485'=>'3.272646','495'=>'3.509104','505'=>'3.752613','515'=>'4.002224',
				'525'=>'4.25704','535'=>'4.516224','545'=>'4.779003','555'=>'5.04466','565'=>'5.312536','575'=>'5.582027','585'=>'5.852575','595'=>'6.123672','605'=>'6.394852',
				'615'=>'6.665693','625'=>'6.935815','635'=>'7.204879','645'=>'7.472584','655'=>'7.738675','665'=>'8.002935','675'=>'8.265185','685'=>'8.525292','695'=>'8.783156',
				'705'=>'9.038722','715'=>'9.291971','725'=>'9.542919','735'=>'9.791619','745'=>'10.03816','755'=>'10.28266','765'=>'10.52527','775'=>'10.76616','785'=>'11.00555',
				'795'=>'11.24366','805'=>'11.48074','815'=>'11.71706','825'=>'11.95292','835'=>'12.18862','845'=>'12.42449','855'=>'12.66085','865'=>'12.89804',
				'875'=>'13.13642','885'=>'13.37634','895'=>'13.61816','905'=>'13.86223','915'=>'14.10891','925'=>'14.35855','935'=>'14.61149','945'=>'14.86807',
				'955'=>'15.1286','965'=>'15.3934','975'=>'15.66275','985'=>'15.93692','995'=>'16.21616','1005'=>'16.5007','1015'=>'16.79074','1025'=>'17.08647','1035'=>'17.38804');
		$percentile90Array=array('450'=>'2.710847','455'=>'2.817045','465'=>'3.038263','475'=>'3.270147','485'=>'3.511467','495'=>'3.761072','505'=>'4.017882','515'=>'4.280885',
				'525'=>'4.549132','535'=>'4.821742','545'=>'5.097891','555'=>'5.376818','565'=>'5.657821','575'=>'5.940251','585'=>'6.223516','595'=>'6.507073','605'=>'6.790428','615'=>'7.073138',
				'625'=>'7.354808','635'=>'7.635088','645'=>'7.913678','655'=>'8.190324','665'=>'8.464818','675'=>'8.736999','685'=>'9.006749','695'=>'9.273997','705'=>'9.538712',
				'715'=>'9.800906','725'=>'10.06063','735'=>'10.31798','745'=>'10.57307','755'=>'10.82606','765'=>'11.07716','775'=>'11.32658','785'=>'11.57457','795'=>'11.82142',
				'805'=>'12.06742','815'=>'12.31291','825'=>'12.55822','835'=>'12.80374','845'=>'13.04983','855'=>'13.2969','865'=>'13.54536','875'=>'13.79564',
				'885'=>'14.04815','895'=>'14.30335','905'=>'14.56167','915'=>'14.82356','925'=>'15.08946','935'=>'15.35982','945'=>'15.63508','955'=>'15.91565','965'=>'16.20197',
				'975'=>'16.49444','985'=>'16.79345','995'=>'17.09937','1005'=>'17.41255','1015'=>'17.7333','1025'=>'18.06192','1035'=>'18.39868');
		$percentile95Array=array('450'=>'2.824861','455'=>'2.935329','465'=>'3.165635','475'=>'3.407201','485'=>'3.658641','495'=>'3.918675','505'=>'4.186113','515'=>'4.459846',
				'525'=>'4.738836','535'=>'5.02212','545'=>'5.308799','555'=>'5.598043','565'=>'5.889087','575'=>'6.18123','585'=>'6.473835','595'=>'6.766328','605'=>'7.058196',
				'615'=>'7.348985','625'=>'7.638301','635'=>'7.925804','645'=>'8.211214','655'=>'8.494298','665'=>'8.77488','675'=>'9.052831','685'=>'9.32807','695'=>'9.600563',
				'705'=>'9.870317','715'=>'10.13738','725'=>'10.40185','735'=>'10.66385','745'=>'10.92355','755'=>'11.18113','765'=>'11.43684','775'=>'11.69094','785'=>'11.94372',
				'795'=>'12.19549','805'=>'12.4466','815'=>'12.69742','825'=>'12.94833','835'=>'13.19976','845'=>'13.45214','855'=>'13.70591','865'=>'13.96154','875'=>'14.21951',
				'885'=>'14.48032','895'=>'14.74447','905'=>'15.01249','915'=>'15.28489','925'=>'15.56221','935'=>'15.84499','945'=>'16.13377','955'=>'16.42909','965'=>'16.7315',
				'975'=>'17.04155','985'=>'17.35976','995'=>'17.68666','1005'=>'18.02279','1015'=>'18.36864','1025'=>'18.72469','1035'=>'19.09143');
		$percentile97Array=array('450'=>'2.897809','455'=>'3.011338','465'=>'3.24824','475'=>'3.496935','485'=>'3.755928','495'=>'4.023835','505'=>'4.299369','515'=>'4.581326',
				'525'=>'4.868586','535'=>'5.160095','545'=>'5.454877','555'=>'5.752027','565'=>'6.050711','575'=>'6.350174','585'=>'6.649733','595'=>'6.948783','605'=>'7.246792','615'=>'7.543303',
				'625'=>'7.837924','635'=>'8.130333','645'=>'8.420274','655'=>'8.707544','665'=>'8.991999','675'=>'9.273547','685'=>'9.552146','695'=>'9.827798','705'=>'10.10055',
				'715'=>'10.37048','725'=>'10.63773','735'=>'10.90245','745'=>'11.16484','755'=>'11.42513','765'=>'11.68357','775'=>'11.94047','785'=>'12.19614','795'=>'12.45094',
				'805'=>'12.70522','815'=>'12.95941','825'=>'13.21392','835'=>'13.46919','845'=>'13.7257','855'=>'13.98393','865'=>'14.2444','875'=>'14.50763','885'=>'14.77417',
				'895'=>'15.04457','905'=>'15.31941','915'=>'15.5993','925'=>'15.88482','935'=>'16.17661','945'=>'16.4753','955'=>'16.78152','965'=>'17.09595','975'=>'17.41925',
				'985'=>'17.7521','995'=>'18.09519','1005'=>'18.44921','1015'=>'18.81488','1025'=>'19.19291','1035'=>'19.584');

		$this->set(compact('percentile3Array','percentile5Array','percentile10Array','percentile25Array','percentile50Array','percentile75Array','percentile85Array','percentile90Array','percentile95Array','percentile97Array'));
		$this->set('diagnosis',$diagnosis);
		$this->set('bmi_array',$bmi_Day);
		$this->set('height',$height_array);
		$this->set(compact('year','month','date','patient_name'));

	}
	public function bmi_infants_weightforlength_female($id=null)
	{
		$this->layout=false;
		$this->set('title_for_layout', __('Growth Chart', true));
		$this->uses = array('Patient','BmiResult');
		$this->Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$this->Patient->bindModel( array(
				'belongsTo' => array(
						'BmiResult'=>array('conditions'=>array('BmiResult.patient_id=Patient.id'),'foreignKey'=>false),
						'Person'=>array('conditions'=>array('Person.id=Patient.person_id'),'foreignKey'=>false)
				)
		));

		$diagnosis = $this->Patient->find('all',array('fields'=>array('BmiResult.height,BmiResult.height_result,BmiResult.weight,BmiResult.weight_volume,BmiResult.bmi,BmiResult.patient_id,BmiResult.created_time,
				Patient.age,Patient.admission_type,Person.sex,Person.dob,Patient.lookup_name'),'conditions'=>array('Patient.person_id'=>$id,'Patient.is_deleted'=>0,'Patient.admission_type'=>'OPD'),'order' => array('Patient.id' => 'asc')));
		foreach($diagnosis as $data)
		{
			$varDate=$this->DateFormat->dateDiff($data['Person']['dob'],$data['BmiResult']['created_time']);
			$var=explode(" ",$data['BmiResult']['height_result']);
			//converting the height into mm
			$height=$var[0]*10;
			//----------------------
			$height_array[$height]=$var[0];
			$year[$height]=$varDate->y;
			$month[$height]=$varDate->m;
			$date[$height]=$data['BmiResult']['created_time'];
			$patient_name=$data['Patient']['lookup_name'];
			if($data['BmiResult']['weight_volume']=='Kg')
			{
				$bmi_Day[$height][]=$data['BmiResult']['weight'];

			}
			elseif($data['BmiResult']['weight_volume']=='lbs')
			{
				$weight=explode(" ",$data['BmiResult']['weight_result']);
				$bmi_Day[$height][]=$weight[0];
			}
			$i++;
		}
		$this->Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$this->Patient->bindModel(array(
				'belongsTo'=>array(
						'ReviewPatientDetail'=>array('conditions'=>array('ReviewPatientDetail.patient_id=Patient.id'),'foreignKey'=>false),
						'ReviewSubCategoriesOption'=>array(
								'conditions'=>array('ReviewSubCategoriesOption.name LIKE'=>"%".Configure::read('bmi_weight_measured')."%"),'foreignKey'=>false),
						'Person'=>array('conditions'=>array('Person.id=Patient.person_id'),'foreignKey'=>false)
				)));
		$diagnosis1 = $this->Patient->find('all',array('fields'=>array('ReviewPatientDetail.values,ReviewPatientDetail.date,
				Patient.age,Patient.admission_type,Person.sex,Person.dob,Patient.lookup_name,ReviewSubCategoriesOption.id'),
				'conditions'=>array('Patient.person_id'=>$id,'ReviewSubCategoriesOption.id=ReviewPatientDetail.review_sub_categories_options_id','ReviewPatientDetail.edited_on IS NULL','Patient.is_deleted'=>0,'Patient.admission_type'=>'IPD'),'order' => array('Patient.id' => 'asc')));

		$this->Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));

		$this->Patient->bindModel(array(
				'belongsTo'=>array(
						'ReviewPatientDetail'=>array('conditions'=>array('ReviewPatientDetail.patient_id=Patient.id'),'foreignKey'=>false),
						'ReviewSubCategoriesOption'=>array(
								'conditions'=>array('ReviewSubCategoriesOption.name LIKE'=>"%".Configure::read('bmi_height_measured')."%"),'foreignKey'=>false),
						'Person'=>array('conditions'=>array('Person.id=Patient.person_id'),'foreignKey'=>false)
				)));
		$diagnosis2 = $this->Patient->find('all',array('fields'=>array('ReviewPatientDetail.values,ReviewPatientDetail.date,
				Patient.age,Patient.admission_type,Person.sex,Person.dob,Patient.lookup_name,ReviewSubCategoriesOption.id'),
				'conditions'=>array('Patient.person_id'=>$id,'ReviewSubCategoriesOption.id=ReviewPatientDetail.review_sub_categories_options_id','ReviewPatientDetail.edited_on IS NULL','Patient.is_deleted'=>0,'Patient.admission_type'=>'IPD'),'order' => array('Patient.id' => 'asc')));
		$i=0;
		foreach($diagnosis1 as $data)
		{
			$height=$diagnosis2[$i]['ReviewPatientDetail']['values']*10;//Converting height in centimeter
			$height_array[$height]=$diagnosis2[$i]['ReviewPatientDetail']['values'];
			$var=$this->DateFormat->dateDiff($data['Person']['dob'],$data['ReviewPatientDetail']['date']);
			$year[$height]=$var->y;
			$date[$height]=$data['ReviewPatientDetail']['date'];
			$patient_name=$data['Patient']['lookup_name'];
			$month[$day]=$var->m;
			$bmi_Day[$height][]=$data['ReviewPatientDetail']['values'];
			$i++;
		}
		$percentile3Array=array('450'=>'1.613026','455'=>'1.723754','465'=>'1.946461','475'=>'2.170805','485'=>'2.396674','495'=>'2.623846','505'=>'2.852008','515'=>'3.08078',
				'525'=>'3.309743','535'=>'3.538486','545'=>'3.766648','555'=>'3.993949','565'=>'4.220196','575'=>'4.445271','585'=>'4.669111','595'=>'4.891683','605'=>'5.112971',
				'615'=>'5.332968','625'=>'5.551666','635'=>'5.769061','645'=>'5.985144','655'=>'6.199913','665'=>'6.413362','675'=>'6.625492','685'=>'6.836308','695'=>'7.045821','705'=>'7.254048',
				'715'=>'7.461016','725'=>'7.66676','735'=>'7.871329','745'=>'8.074782','755'=>'8.277191','765'=>'8.478641','775'=>'8.679234','785'=>'8.879084','795'=>'9.078323','805'=>'9.277093','815'=>'9.475554',
				'825'=>'9.673875','835'=>'9.872237','845'=>'10.07083','855'=>'10.26985','865'=>'10.46949','875'=>'10.66996','885'=>'10.87145','895'=>'11.07415','905'=>'11.27826','915'=>'11.48393',
				'925'=>'11.69135','935'=>'11.90066','945'=>'12.11201','955'=>'12.32555','965'=>'12.54142','975'=>'12.75976','985'=>'12.98073','995'=>'13.20451','1005'=>'13.43129','1015'=>'13.66128',
				'1025'=>'13.89473','1035'=>'14.13193');
		$percentile5Array=array('450'=>'1.695309','455'=>'1.805223','465'=>'2.026496','475'=>'2.249555','485'=>'2.474214','495'=>'2.700267','505'=>'2.927479','515'=>'3.155581',
				'525'=>'3.384267','535'=>'3.613206','545'=>'3.842082','555'=>'4.070614','565'=>'4.298576','575'=>'4.525795','585'=>'4.752144','595'=>'4.977525','605'=>'5.201863','615'=>'5.425097',
				'625'=>'5.647175','635'=>'5.868052','645'=>'6.08769','655'=>'6.306059','665'=>'6.523134','675'=>'6.738899','685'=>'6.953346','695'=>'7.166475','705'=>'7.378297',
				'715'=>'7.588833','725'=>'7.798112','735'=>'8.006179','745'=>'8.213088','755'=>'8.418904','765'=>'8.623706','775'=>'8.827587','785'=>'9.03065','795'=>'9.233013',
				'805'=>'9.434804','815'=>'9.636167','825'=>'9.837254','835'=>'10.03823','845'=>'10.23927','855'=>'10.44056','865'=>'10.6423','875'=>'10.84467','885'=>'11.0479',
				'895'=>'11.25218','905'=>'11.45773','915'=>'11.66476','925'=>'11.87348','935'=>'12.0841','945'=>'12.2968','955'=>'12.5118','965'=>'12.72929','975'=>'12.94946',
				'985'=>'13.17252','995'=>'13.39868','1005'=>'13.62816','1015'=>'13.8612','1025'=>'14.09807','1035'=>'14.33903');
		$percentile10Array=array('450'=>'1.824645','455'=>'1.932851','465'=>'2.151303','475'=>'2.37216','485'=>'2.595089','495'=>'2.819827','505'=>'3.046163','515'=>'3.273901','525'=>'3.502832',
				'535'=>'3.732716','545'=>'3.963283','555'=>'4.194251','565'=>'4.425349','575'=>'4.656327','585'=>'4.886965','595'=>'5.11707','605'=>'5.346478','615'=>'5.575047','625'=>'5.802652',
				'635'=>'6.029191','645'=>'6.254575','655'=>'6.478732','665'=>'6.701606','675'=>'6.923153','685'=>'7.143346','695'=>'7.362171','705'=>'7.579625','715'=>'7.795721',
				'725'=>'8.010485','735'=>'8.223954','745'=>'8.436179','755'=>'8.64722','765'=>'8.857151','775'=>'9.066055','785'=>'9.274029','795'=>'9.481178','805'=>'9.687617',
				'815'=>'9.893474','825'=>'10.09889','835'=>'10.30401','845'=>'10.509','855'=>'10.71403','865'=>'10.9193','875'=>'11.12501','885'=>'11.33138','895'=>'11.53864','905'=>'11.74703',
				'915'=>'11.95681','925'=>'12.16825','935'=>'12.38161','945'=>'12.59718','955'=>'12.81522','965'=>'13.03602','975'=>'13.25983','985'=>'13.48694','995'=>'13.71761','1005'=>'13.9521',
				'1015'=>'14.1907','1025'=>'14.43368','1035'=>'14.68133');
		$percentile25Array=array('450'=>'2.047708','455'=>'2.151844','465'=>'2.36396','475'=>'2.580565','485'=>'2.800986','495'=>'3.024686','505'=>'3.251251','515'=>'3.480372','525'=>'3.711802',
				'535'=>'3.945306','545'=>'4.180623','555'=>'4.417444','565'=>'4.655423','575'=>'4.894195','585'=>'5.133399','595'=>'5.372695','605'=>'5.611774','615'=>'5.85036',
				'625'=>'6.088213','635'=>'6.325127','645'=>'6.560927','655'=>'6.795472','665'=>'7.028648','675'=>'7.260367','685'=>'7.490568','695'=>'7.719212','705'=>'7.946282',
				'715'=>'8.171783','725'=>'8.395736','735'=>'8.61818','745'=>'8.839171','755'=>'9.058777','765'=>'9.277079','775'=>'9.494173','785'=>'9.710161','795'=>'9.925158',
				'805'=>'10.13929','815'=>'10.35269','825'=>'10.5655','835'=>'10.77788','845'=>'10.99001','855'=>'11.20206','865'=>'11.41424',
				'875'=>'11.62678','885'=>'11.83991','895'=>'12.0539','905'=>'12.26903','915'=>'12.48563','925'=>'12.70401','935'=>'12.92454','945'=>'13.14758','955'=>'13.3735',
				'965'=>'13.60268','975'=>'13.83551','985'=>'14.07234','995'=>'14.31354','1005'=>'14.55946','1015'=>'14.8104','1025'=>'15.06669','1035'=>'15.32861');
		$percentile50Array=array('450'=>'2.305397','455'=>'2.403257','465'=>'2.60602','475'=>'2.817114','485'=>'3.035356','495'=>'3.259693','505'=>'3.48922','515'=>'3.723195',
				'525'=>'3.961035','535'=>'4.20227','545'=>'4.446476','555'=>'4.69322','565'=>'4.942029','575'=>'5.192403','585'=>'5.44383','595'=>'5.695813','605'=>'5.94789',
				'615'=>'6.19964','625'=>'6.450696','635'=>'6.700737','645'=>'6.949494','655'=>'7.196745','665'=>'7.442314','675'=>'7.686067','685'=>'7.927909','695'=>'8.167784',
				'705'=>'8.405667','715'=>'8.641566','725'=>'8.87552','735'=>'9.10759','745'=>'9.337865','755'=>'9.566453','765'=>'9.793482','775'=>'10.0191','785'=>'10.24346',
				'795'=>'10.46675','805'=>'10.68916','815'=>'10.91087','825'=>'11.13211','835'=>'11.35309','845'=>'11.57406','855'=>'11.79525','865'=>'12.01692','875'=>'12.23935',
				'885'=>'12.46282','895'=>'12.68764','905'=>'12.91413','915'=>'13.14264','925'=>'13.37354','935'=>'13.60723','945'=>'13.84412','955'=>'14.08465','965'=>'14.32925','975'=>'14.57837',
				'985'=>'14.83246','995'=>'15.09192','1005'=>'15.35716','1015'=>'15.62855','1025'=>'15.90641','1035'=>'16.19104');
		$percentile75Array=array('450'=>'2.573066','455'=>'2.662836','465'=>'2.85389','475'=>'3.058703','485'=>'3.275452','495'=>'3.502419','505'=>'3.738025','515'=>'3.980868','525'=>'4.229754',
				'535'=>'4.483694','545'=>'4.741844','555'=>'5.003448','565'=>'5.267777','575'=>'5.534119','585'=>'5.801773','595'=>'6.070071','605'=>'6.338391',
				'615'=>'6.606172','625'=>'6.872915','635'=>'7.138193','645'=>'7.401643','655'=>'7.662975','665'=>'7.921956','675'=>'8.178421','685'=>'8.432257',
				'695'=>'8.683408','705'=>'8.931871','715'=>'9.177686','725'=>'9.42094','735'=>'9.66176','745'=>'9.900312','755'=>'10.13679','765'=>'10.37143',
				'775'=>'10.60449','785'=>'10.83625','795'=>'11.06702','805'=>'11.29712','815'=>'11.5269','825'=>'11.7567','835'=>'11.98689','845'=>'12.21785',
				'855'=>'12.44994','865'=>'12.68355','875'=>'12.91906','885'=>'13.15685','895'=>'13.3973','905'=>'13.64079','915'=>'13.88771','925'=>'14.13845',
				'935'=>'14.39342','945'=>'14.65302','955'=>'14.91769','965'=>'15.18785','975'=>'15.46392','985'=>'15.74635','995'=>'16.03553','1005'=>'16.33184',
				'1015'=>'16.63564','1025'=>'16.94721','1035'=>'17.2668');
		$percentile90Array=array('450'=>'2.822212','455'=>'2.903176','465'=>'3.081735','475'=>'3.280281','485'=>'3.496305','495'=>'3.727426','505'=>'3.971396',
				'515'=>'4.226124','525'=>'4.489708','535'=>'4.760456','545'=>'5.036873','555'=>'5.317644','565'=>'5.601587','575'=>'5.887634','585'=>'6.174807',
				'595'=>'6.462217','605'=>'6.749065','615'=>'7.034645','625'=>'7.318342','635'=>'7.599636','645'=>'7.878098','655'=>'8.153389','665'=>'8.425257',
				'675'=>'8.69353','685'=>'8.958117','695'=>'9.219002','705'=>'9.476239','715'=>'9.729947','725'=>'9.98031','735'=>'10.22757','745'=>'10.47201',
				'755'=>'10.71399','765'=>'10.95388','775'=>'11.19212','785'=>'11.42918','795'=>'11.66555','805'=>'11.90175','815'=>'12.13833',
				'825'=>'12.37586','835'=>'12.6149','845'=>'12.85604','855'=>'13.09985','865'=>'13.34691','875'=>'13.59779','885'=>'13.85303',
				'895'=>'14.11317','905'=>'14.37871','915'=>'14.65014','925'=>'14.92791','935'=>'15.21246','945'=>'15.50421','955'=>'15.80353','965'=>'16.11078',
				'975'=>'16.42632','985'=>'16.75044','995'=>'17.08343','1005'=>'17.42553','1015'=>'17.77692','1025'=>'18.13775','1035'=>'18.50808');
		$percentile95Array=array('450'=>'2.974944','455'=>'3.049956','465'=>'3.220173','475'=>'3.414702','485'=>'3.630585','495'=>'3.86503','505'=>'4.1154','515'=>'4.379201',
				'525'=>'4.654076','535'=>'4.937829','545'=>'5.228445','555'=>'5.524113','565'=>'5.823224','575'=>'6.124359',
				'585'=>'6.426274','595'=>'6.727879','605'=>'7.028227','615'=>'7.326504','625'=>'7.62202','635'=>'7.914203','645'=>'8.202596',
				'655'=>'8.486851','665'=>'8.766723','675'=>'9.042068','685'=>'9.312833','695'=>'9.579059','705'=>'9.840866','715'=>'10.09846','725'=>'10.35211',
				'735'=>'10.60217','745'=>'10.84905','755'=>'11.09321','765'=>'11.33518','775'=>'11.57552','785'=>'11.81486','795'=>'12.05383',
				'805'=>'12.29314','815'=>'12.53347','825'=>'12.77557','835'=>'13.02018','845'=>'13.26804','855'=>'13.51992','865'=>'13.77656','875'=>'14.0387',
				'885'=>'14.30705','895'=>'14.5823','905'=>'14.86511','915'=>'15.1561','925'=>'15.45584','935'=>'15.76484','945'=>'16.08357','955'=>'16.41242',
				'965'=>'16.75173','975'=>'17.10178','985'=>'17.46277','995'=>'17.83483','1005'=>'18.21805','1015'=>'18.61241','1025'=>'19.01784','1035'=>'19.43416');
		$percentile97Array=array('450'=>'3.07556','455'=>'3.146436','465'=>'3.310893','475'=>'3.502713','485'=>'3.718623','495'=>'3.95557','505'=>'4.210682','515'=>'4.481218',
				'525'=>'4.764536','535'=>'5.058091','545'=>'5.359481','555'=>'5.666498','565'=>'5.977172','575'=>'6.289779','585'=>'6.602836',
				'595'=>'6.915076','605'=>'7.225424','615'=>'7.532981','625'=>'7.836998','635'=>'8.136875','645'=>'8.432145','655'=>'8.722464',
				'665'=>'9.007608','675'=>'9.287465','685'=>'9.56203','695'=>'9.831396','705'=>'10.09575','715'=>'10.35537',
				'725'=>'10.61061','735'=>'10.86191','745'=>'11.10976','755'=>'11.35475','765'=>'11.5975','775'=>'11.83868','785'=>'12.07903',
				'795'=>'12.31932','805'=>'12.56035','815'=>'12.80295','825'=>'13.04798','835'=>'13.29632','845'=>'13.54884','855'=>'13.80645',
				'865'=>'14.07003','875'=>'14.34047','885'=>'14.61861','895'=>'14.90532','905'=>'15.20138','915'=>'15.50755','925'=>'15.82453',
				'935'=>'16.15296','945'=>'16.49337','955'=>'16.84623','965'=>'17.2119','975'=>'17.59064','985'=>'17.98258','995'=>'18.38778',
				'1005'=>'18.80615','1015'=>'19.23752','1025'=>'19.68159','1035'=>'20.13796');
		$this->set(compact('percentile3Array','percentile5Array','percentile10Array','percentile25Array','percentile50Array','percentile75Array','percentile85Array','percentile90Array','percentile95Array','percentile97Array'));
		$this->set('diagnosis',$diagnosis);
		$this->set('bmi_array',$bmi_Day);
		$this->set('height',$height_array);
		$this->set(compact('year','month','date','patient_name'));
	}
	public function bmi_infants_weightforage($id=null) {
		$this->layout=false;
		$this->set('title_for_layout', __('Growth Chart', true));
		$this->uses = array('Patient','BmiResult','ReviewPatientDetail');
		$this->Patient->bindModel( array(
				'belongsTo' => array(
						'BmiResult'=>array('conditions'=>array('BmiResult.patient_id=Patient.id'),'foreignKey'=>false),
						'Person'=>array('conditions'=>array('Person.id=Patient.person_id'),'foreignKey'=>false)
				)
		));

		$diagnosis = $this->Patient->find('all',array('fields'=>array('BmiResult.height,BmiResult.weight,BmiResult.weight_volume,BmiResult.weight_result,BmiResult.bmi,BmiResult.patient_id,BmiResult.created_time,
				Patient.age,Patient.admission_type,Person.sex,Person.dob,Patient.lookup_name'),'conditions'=>array('Patient.person_id'=>$id,'Patient.is_deleted'=>0,'Patient.admission_type'=>'OPD'),'order' => array('Patient.id' => 'asc')));
			
		foreach($diagnosis as $data)
		{
			$var=$this->DateFormat->dateDiff($data['Person']['dob'],$data['BmiResult']['created_time']);
			$day=$var->days;
			$year[$day]=$var->y;
			$month[$day]=$var->m;
			$date[$day]=$data['BmiResult']['created_time'];
			$patient_name=$data['Patient']['lookup_name'];
			if($data['BmiResult']['weight_volume']=='Kg')
			{
				$bmi_Day[$day][]=$data['BmiResult']['weight'];
			}
			elseif($data['BmiResult']['weight_volume']=='lbs')
			{
				$weight=explode(" ",$data['BmiResult']['weight_result']);
				$bmi_Day[$day][]=$weight[0];
			}
		}
		$this->Patient->bindModel(array(
				'belongsTo'=>array(
						'ReviewPatientDetail'=>array('conditions'=>array('ReviewPatientDetail.patient_id=Patient.id'),'foreignKey'=>false),
						'ReviewSubCategoriesOption'=>array(
								'conditions'=>array('ReviewSubCategoriesOption.name LIKE'=>"%".Configure::read('bmi_weight_measured')."%"),'foreignKey'=>false),
						'Person'=>array('conditions'=>array('Person.id=Patient.person_id'),'foreignKey'=>false)
				)));
		$diagnosis1 = $this->Patient->find('all',array('fields'=>array('ReviewPatientDetail.values,ReviewPatientDetail.date,
				Patient.age,Patient.admission_type,Person.sex,Person.dob,Patient.lookup_name,ReviewSubCategoriesOption.id'),
				'conditions'=>array('Patient.person_id'=>$id,'ReviewSubCategoriesOption.id=ReviewPatientDetail.review_sub_categories_options_id','ReviewPatientDetail.edited_on IS NULL','Patient.is_deleted'=>0,'Patient.admission_type'=>'IPD'),'order' => array('Patient.id' => 'asc')));

		foreach($diagnosis1 as $data)
		{
			$var=$this->DateFormat->dateDiff($data['Person']['dob'],$data['ReviewPatientDetail']['date']);
			$day=$var->days;
			$year[$day]=$var->y;
			$date[$day]=$data['ReviewPatientDetail']['date'];
			$patient_name=$data['Patient']['lookup_name'];
			$month[$day]=$var->m;
			$bmi_Day[$day][]=$data['ReviewPatientDetail']['values'];
		}

		//array for setting the  percentiles standard data
		$percentile3Array=array('0'=>'2.414112','15'=>'2.756917','45'=>'3.402293','75'=>'3.997806','105'=>'4.547383','135'=>'5.054539','165'=>'5.5225','195'=>'5.954272',
				'225'=>'6.352668','255'=>'6.720328','285'=>'7.059732','315'=>'7.373212','345'=>'7.662959','375'=>'7.93103','405'=>'8.179356','435'=>'8.409744','465'=>'8.623887',
				'495'=>'8.82337','525'=>'9.009668','555'=>'9.18416','585'=>'9.348127','615'=>'9.50276','645'=>'9.649162','675'=>'9.788355','705'=>'9.921281','735'=>'10.04881','765'=>'10.17173',
				'795'=>'10.29079','825'=>'10.40664','855'=>'10.5199','885'=>'10.63112','915'=>'10.74078','945'=>'10.84935','975'=>'10.95722','1005'=>'11.06475','1035'=>'11.17225',
				'1065'=>'11.28','1080'=>'11.33404');
		$percentile5Array=array('0'=>'2.547905','15'=>'2.894442','45'=>'3.54761','75'=>'4.150639','105'=>'4.707123','135'=>'5.220488','165'=>'5.693974',
				'195'=>'6.130641','225'=>'6.533373','255'=>'6.904886','285'=>'7.247736','315'=>'7.564327','345'=>'7.856916','375'=>'8.127621','405'=>'8.378425','435'=>'8.611186',
				'465'=>'8.827638','495'=>'9.029399','525'=>'9.21798','555'=>'9.394782','585'=>'9.56111','615'=>'9.71817','645'=>'9.867081','675'=>'10.00887','705'=>'10.1445',
				'735'=>'10.27483','765'=>'10.40066','795'=>'10.52274','825'=>'10.64171','855'=>'10.75819','885'=>'10.87273','915'=>'10.98581','945'=>'11.09789','975'=>'11.20934',
				'1005'=>'11.32054','1035'=>'11.43177','1065'=>'11.54332','1080'=>'11.59929');
		$percentile10Array=array('0'=>'2.747222','15'=>'3.101767','45'=>'3.770157','75'=>'4.387042','105'=>'4.955926','135'=>'5.480295','165'=>'5.96351','195'=>'6.408775',
				'225'=>'6.819122','255'=>'7.197414','285'=>'7.546342','315'=>'7.868436','345'=>'8.166069','375'=>'8.44146','405'=>'8.696684','435'=>'8.93368','465'=>'9.154251',
				'495'=>'9.360079','525'=>'9.552723','555'=>'9.73363','585'=>'9.90414','615'=>'10.06549','645'=>'10.21882','675'=>'10.36518','705'=>'10.50553','735'=>'10.64076',
				'765'=>'10.77167','795'=>'10.89899','825'=>'11.02338','855'=>'11.14545','885'=>'11.26575','915'=>'11.38474','945'=>'11.50288','975'=>'11.62054','1005'=>'11.73806',
				'1035'=>'11.85574','1065'=>'11.97384','1080'=>'12.03312');
		$percentile25Array=array('0'=>'3.064865','15'=>'3.437628','45'=>'4.138994','75'=>'4.78482','105'=>'5.379141','135'=>'5.925888','165'=>'6.428828','195'=>'6.891533','225'=>'7.317373',
				'255'=>'7.709516','285'=>'8.070932','315'=>'8.4044','345'=>'8.712513','375'=>'8.997692','405'=>'9.262185','435'=>'9.508085','465'=>'9.737329','495'=>'9.951715','525'=>'10.1529',
				'555'=>'10.34241','585'=>'10.52167','615'=>'10.69196','645'=>'10.85446','675'=>'11.01027','705'=>'11.16037','735'=>'11.30567','765'=>'11.44697','795'=>'11.58501','825'=>'11.72047',
				'855'=>'11.85392','885'=>'11.98592','915'=>'12.11692','945'=>'12.24735','975'=>'12.37757','1005'=>'12.50791','1035'=>'12.63865','1065'=>'12.77001','1080'=>'12.836');
		$percentile50Array=array('0'=>'3.399186','15'=>'3.797528','45'=>'4.544777','75'=>'5.230584','105'=>'5.859961','135'=>'6.437588','165'=>'6.96785','195'=>'7.454854','225'=>'7.902436','255'=>'8.314178',
				'285'=>'8.693418','315'=>'9.043262','345'=>'9.366594','375'=>'9.666089','405'=>'9.944226','435'=>'10.20329','465'=>'10.44541','495'=>'10.67251','525'=>'10.88639','555'=>'11.08868',
				'585'=>'11.2809','615'=>'11.4644','645'=>'11.64043','675'=>'11.81014','705'=>'11.97454','735'=>'12.13456','765'=>'12.29102','795'=>'12.44469','825'=>'12.59622','855'=>'12.74621','885'=>'12.89517',
				'915'=>'13.04357','945'=>'13.19181','975'=>'13.34023','1005'=>'13.48913','1035'=>'13.63877','1065'=>'13.78937','1080'=>'13.86507');
		$percentile75Array=array('0'=>'3.717519','15'=>'4.145594','45'=>'4.946766','75'=>'5.680083','105'=>'6.351512','135'=>'6.966524','165'=>'7.53018','195'=>'8.047178','225'=>'8.521877',
				'255'=>'8.958324','285'=>'9.360271','315'=>'9.731193','345'=>'10.07431','375'=>'10.39258','405'=>'10.68874','435'=>'10.96532','465'=>'11.22463','495'=>'11.46878','525'=>'11.69972',
				'555'=>'11.91921','585'=>'12.12887','615'=>'12.33016','645'=>'12.52439','675'=>'12.71277','705'=>'12.89636','735'=>'13.07613','765'=>'13.25293','795'=>'13.42753','825'=>'13.60059',
				'855'=>'13.77271','885'=>'13.9444','915'=>'14.11611','945'=>'14.28822','975'=>'14.46106','1005'=>'14.63491','1035'=>'14.80998','1065'=>'14.98647','1080'=>'15.07529');
		$percentile90Array=array('0'=>'3.992572','15'=>'4.450126','45'=>'5.305632','75'=>'6.087641','105'=>'6.80277','135'=>'7.457119','165'=>'8.056331','195'=>'8.605636','225'=>'9.109878',
				'255'=>'9.573546','285'=>'10.00079','315'=>'10.39545','345'=>'10.76106','375'=>'11.10089','405'=>'11.41792','435'=>'11.71491','465'=>'11.99438','495'=>'12.25862','525'=>'12.50974',
				'555'=>'12.74964','585'=>'12.98004','615'=>'13.2025','645'=>'13.41844','675'=>'13.62911','705'=>'13.83564','735'=>'14.03902','765'=>'14.24017','795'=>'14.43984','825'=>'14.63873',
				'855'=>'14.83743','885'=>'15.03646','915'=>'15.23626','945'=>'15.43719','975'=>'15.63957','1005'=>'15.84365','1035'=>'16.04963',
				'1065'=>'16.25767','1080'=>'16.3625');
		$percentile95Array=array('0'=>'4.152637','15'=>'4.628836','45'=>'5.519169','75'=>'6.332837','105'=>'7.076723','135'=>'7.757234','165'=>'8.38033','195'=>'8.951544',
				'225'=>'9.476009','255'=>'9.95848','285'=>'10.40335','315'=>'10.8147','345'=>'11.19625','375'=>'11.55145','405'=>'11.88348','435'=>'12.19522','465'=>'12.48934',
				'495'=>'12.76825','525'=>'13.03415','555'=>'13.28904','585'=>'13.53473','615'=>'13.77284','645'=>'14.00484','675'=>'14.23205','705'=>'14.45561','735'=>'14.67659',
				'765'=>'14.89587','795'=>'15.11428','825'=>'15.33249','855'=>'15.55113','885'=>'15.7707','915'=>'15.99164','945'=>'16.21432','975'=>'16.43904','1005'=>'16.66605',
				'1035'=>'16.89553','1065'=>'17.12762','1080'=>'17.24469');
		$percentile97Array=array('0'=>'4.254922','15'=>'4.743582','45'=>'5.657379','75'=>'6.492574','105'=>'7.256166','135'=>'7.95473','165'=>'8.594413',
				'195'=>'9.180938','225'=>'9.719621','255'=>'10.21539','285'=>'10.6728','315'=>'11.09607','345'=>'11.48908','375'=>'11.85539','405'=>'12.19829',
				'435'=>'12.52078','465'=>'12.82561','495'=>'13.11527','525'=>'13.39204','555'=>'13.65799','585'=>'13.91497','615'=>'14.16467','645'=>'14.40858',
				'675'=>'14.64807','705'=>'14.88432','735'=>'15.11839','765'=>'15.35122','795'=>'15.58363','825'=>'15.81632','855'=>'16.0499','885'=>'16.28491',
				'915'=>'16.52176','945'=>'16.76085','975'=>'17.00245','1005'=>'17.24681','1035'=>'17.49412','1065'=>'17.7445','1080'=>'17.87089');
		//end of array
		$this->set(compact('percentile3Array','percentile5Array','percentile10Array','percentile25Array','percentile50Array','percentile75Array','percentile85Array','percentile90Array','percentile95Array','percentile97Array'));
		$this->set('diagnosis',$diagnosis);
		$this->set('bmi_array',$bmi_Day);
		$this->set(compact('year','month','date','patient_name'));
	}

	function bmi_infants_weightforage_male($id=null){
		$this->layout=false;
		$this->set('title_for_layout', __('Growth Chart', true));
		$this->uses = array('Patient','BmiResult','ReviewPatientDetail');
		$this->Patient->bindModel( array(
				'belongsTo' => array(
						'BmiResult'=>array('conditions'=>array('BmiResult.patient_id=Patient.id'),'foreignKey'=>false),
						'Person'=>array('conditions'=>array('Person.id=Patient.person_id'),'foreignKey'=>false)
				)
		));

		$diagnosis = $this->Patient->find('all',array('fields'=>array('BmiResult.height,BmiResult.weight,BmiResult.weight_volume,BmiResult.weight_result,BmiResult.bmi,BmiResult.patient_id,BmiResult.created_time,
				Patient.age,Patient.admission_type,Person.sex,Person.dob,Patient.lookup_name'),'conditions'=>array('Patient.person_id'=>$id,'Patient.is_deleted'=>0,'Patient.admission_type'=>'OPD'),'order' => array('Patient.id' => 'asc')));
			
		foreach($diagnosis as $data)
		{
			$var=$this->DateFormat->dateDiff($data['Person']['dob'],$data['BmiResult']['created_time']);
			$day=$var->days;
			$year[$day]=$var->y;
			$month[$day]=$var->m;
			$date[$day]=$data['BmiResult']['created_time'];
			$patient_name=$data['Patient']['lookup_name'];
			if($data['BmiResult']['weight_volume']=='Kg')
			{
				$bmi_Day[$day][]=$data['BmiResult']['weight'];
			}
			elseif($data['BmiResult']['weight_volume']=='lbs')
			{
				$weight=explode(" ",$data['BmiResult']['weight_result']);
				$bmi_Day[$day][]=$weight[0];
			}
		}
		$this->Patient->bindModel(array(
				'belongsTo'=>array(
						'ReviewPatientDetail'=>array('conditions'=>array('ReviewPatientDetail.patient_id=Patient.id'),'foreignKey'=>false),
						'ReviewSubCategoriesOption'=>array(
								'conditions'=>array('ReviewSubCategoriesOption.name LIKE'=>"%".Configure::read('bmi_weight_measured')."%"),'foreignKey'=>false),
						'Person'=>array('conditions'=>array('Person.id=Patient.person_id'),'foreignKey'=>false)
				)));
		$diagnosis1 = $this->Patient->find('all',array('fields'=>array('ReviewPatientDetail.values,ReviewPatientDetail.date,
				Patient.age,Patient.admission_type,Person.sex,Person.dob,Patient.lookup_name,ReviewSubCategoriesOption.id'),
				'conditions'=>array('Patient.person_id'=>$id,'ReviewSubCategoriesOption.id=ReviewPatientDetail.review_sub_categories_options_id','ReviewPatientDetail.edited_on IS NULL','Patient.is_deleted'=>0,'Patient.admission_type'=>'IPD'),'order' => array('Patient.id' => 'asc')));

		foreach($diagnosis1 as $data)
		{
			$var=$this->DateFormat->dateDiff($data['Person']['dob'],$data['ReviewPatientDetail']['date']);
			$day=$var->days;
			$year[$day]=$var->y;
			$date[$day]=$data['ReviewPatientDetail']['date'];
			$patient_name=$data['Patient']['lookup_name'];
			$month[$day]=$var->m;
			$bmi_Day[$day][]=$data['ReviewPatientDetail']['values'];
		}

		$percentile3Array=array('0'=>'2.355451','15'=>'2.799549','45'=>'3.614688','75'=>'4.342341','105'=>'4.992898','135'=>'5.575169','165'=>'6.096775','195'=>'6.56443','225'=>'6.984123','255'=>'7.361236',
				'285'=>'7.700624','315'=>'8.006677','345'=>'8.283365','375'=>'8.534275','405'=>'8.762649','435'=>'8.971407',
				'465'=>'9.16318','495'=>'9.340328','525'=>'9.504964','555'=>'9.658975','585'=>'9.804039','615'=>'9.941645',
				'645'=>'10.07311','675'=>'10.19957','705'=>'10.32206','735'=>'10.44144','765'=>'10.55847','795'=>'10.6738','825'=>'10.78798',
				'855'=>'10.90147','885'=>'11.01466','915'=>'11.12787','945'=>'11.24135','975'=>'11.3553','1005'=>'11.46988','1035'=>'11.58521',
				'1065'=>'11.70137','1080'=>'11.75978');
		$percentile5Array=array('0'=>'2.526904','15'=>'2.964656','45'=>'3.774849','75'=>'4.503255','105'=>'5.157412','135'=>'5.744752',
				'165'=>'6.272175','195'=>'6.745993','225'=>'7.171952','255'=>'7.555287','285'=>'7.900755','315'=>'8.212684','345'=>'8.495',
				'375'=>'8.751264','405'=>'8.984701','435'=>'9.198222','465'=>'9.394454','495'=>'9.575757','525'=>'9.744251','555'=>'9.90183',
				'585'=>'10.05019','615'=>'10.19082','645'=>'10.32507','675'=>'10.4541','705'=>'10.57895','735'=>'10.70051',
				'765'=>'10.81958','795'=>'10.93681','825'=>'11.0528','855'=>'11.16803','885'=>'11.28293','915'=>'11.39782',
				'945'=>'11.513','975'=>'11.62869','1005'=>'11.74508','1035'=>'11.8623','1065'=>'11.98046','1080'=>'12.03991');
		$percentile10Array=array('0'=>'2.773802','15'=>'3.20951','45'=>'4.020561','75'=>'4.754479','105'=>'5.416803','135'=>'6.013716',
				'165'=>'6.551379','195'=>'7.035656','225'=>'7.472021','255'=>'7.865533','285'=>'8.220839','315'=>'8.542195','345'=>'8.833486',
				'375'=>'9.098246','405'=>'9.339688','435'=>'9.560722','465'=>'9.763982','495'=>'9.95184','525'=>'10.12643','555'=>'10.28968',
				'585'=>'10.4433','615'=>'10.58881','645'=>'10.72759','675'=>'10.86084','705'=>'10.98963','735'=>'11.1149','765'=>'11.23747',
				'795'=>'11.35806','825'=>'11.47728','855'=>'11.59567','885'=>'11.71368','915'=>'11.8317','945'=>'11.95005','975'=>'12.069',
				'1005'=>'12.18875','1035'=>'12.30948','1065'=>'12.43132','1080'=>'12.49268');
		$percentile25Array=array('0'=>'3.150611','15'=>'3.597396','45'=>'4.428873','75'=>'5.183378','105'=>'5.866806','135'=>'6.484969','165'=>'7.043627',
				'195'=>'7.548346','225'=>'8.004399','255'=>'8.416719','285'=>'8.789882','315'=>'9.12811','345'=>'9.435279','375'=>'9.714942','405'=>'9.970338',
				'435'=>'10.20442','465'=>'10.41986','495'=>'10.6191','525'=>'10.80433','555'=>'10.97753','585'=>'11.14047','615'=>'11.29477','645'=>'11.44185',
				'675'=>'11.58298','705'=>'11.7193','735'=>'11.85182','765'=>'11.98142','795'=>'12.10889','825'=>'12.23491','855'=>'12.36007','885'=>'12.4849',
				'915'=>'12.60983','945'=>'12.73523','975'=>'12.86144','1005'=>'12.9887','1035'=>'13.11723','1065'=>'13.24721',
				'1080'=>'13.31278');
		$percentile50Array=array('0'=>'3.530203','15'=>'4.003106','45'=>'4.879525','75'=>'5.672889','105'=>'6.391392','135'=>'7.041836','165'=>'7.630425','195'=>'8.162951',
				'225'=>'8.644832','255'=>'9.08112','285'=>'9.4765','315'=>'9.835308','345'=>'10.16154','375'=>'10.45885','405'=>'10.73063','435'=>'10.97992','465'=>'11.20956',
				'495'=>'11.42207','525'=>'11.61978','555'=>'11.80478','585'=>'11.97897','615'=>'12.14404','645'=>'12.30154','675'=>'12.45283','705'=>'12.59913',
				'735'=>'12.74154','765'=>'12.88102','795'=>'13.01842','825'=>'13.1545','855'=>'13.2899','885'=>'13.42519','915'=>'13.56088',
				'945'=>'13.69738','975'=>'13.83505','1005'=>'13.97418','1035'=>'14.11503','1065'=>'14.2578','1080'=>'14.32994');
		$percentile75Array=array('0'=>'3.879077','15'=>'4.387423','45'=>'5.327328','75'=>'6.175598','105'=>'6.942217','135'=>'7.635323','165'=>'8.262033','195'=>'8.828786',
				'225'=>'9.34149','255'=>'9.805593','285'=>'10.22612','315'=>'10.60772','345'=>'10.95466','375'=>'11.27087','405'=>'11.55996',
				'435'=>'11.82524','465'=>'12.06973','495'=>'12.29617','525'=>'12.50708','555'=>'12.70473','585'=>'12.89117','615'=>'13.06825','645'=>'13.23765',
				'675'=>'13.40086','705'=>'13.5592','735'=>'13.71386','765'=>'13.8659','795'=>'14.01623','825'=>'14.16567','855'=>'14.31493',
				'885'=>'14.46462','915'=>'14.61527','945'=>'14.76732','975'=>'14.92117','1005'=>'15.07711',
				'1035'=>'15.23541','1065'=>'15.39628','1080'=>'15.47772');
		$percentile90Array=array('0'=>'4.172493','15'=>'4.718161','45'=>'5.728153','75'=>'6.638979','105'=>'7.460702','135'=>'8.202193','165'=>'8.871384','195'=>'9.475466',
				'225'=>'10.02101','255'=>'10.51406','285'=>'10.96017','315'=>'11.36445','345'=>'11.7316','375'=>'12.06595','405'=>'12.37145','435'=>'12.65175','465'=>'12.91015',
				'495'=>'13.14969','525'=>'13.37311','555'=>'13.5829','585'=>'13.78133','615'=>'13.97042','645'=>'14.15201','675'=>'14.32772','705'=>'14.499',
				'735'=>'14.66716','765'=>'14.83332','795'=>'14.99848','825'=>'15.16351','855'=>'15.32917','885'=>'15.4961','915'=>'15.66485',
				'945'=>'15.83588','975'=>'16.00958','1005'=>'16.18624','1035'=>'16.36612','1065'=>'16.5494','1080'=>'16.64237');
		$percentile95Array=array('0'=>'4.340293','15'=>'4.91013','45'=>'5.967102','75'=>'6.921119','105'=>'7.781401','135'=>'8.556813','165'=>'9.255615',
				'195'=>'9.885436','225'=>'10.45331','255'=>'10.96574','285'=>'11.42868','315'=>'11.84763','345'=>'12.22766','375'=>'12.5734','405'=>'12.88911',
				'435'=>'13.17867','465'=>'13.44564','495'=>'13.69325','525'=>'13.92444','555'=>'14.14187','585'=>'14.34795','615'=>'14.54484','645'=>'14.73448','675'=>'14.91861',
				'705'=>'15.09876','735'=>'15.2763','765'=>'15.45242','795'=>'15.62819','825'=>'15.8045','855'=>'15.98214','885'=>'16.16177',
				'915'=>'16.34395','945'=>'16.52915','975'=>'16.71773','1005'=>'16.91',
				'1035'=>'17.10619','1065'=>'17.30646','1080'=>'17.40816');
		$percentile97Array=array('0'=>'4.446488','15'=>'5.032625','45'=>'6.121929','75'=>'7.10625','105'=>'7.993878','135'=>'8.793444','165'=>'9.513307',
				'195'=>'10.16135','225'=>'10.74492','255'=>'11.27084','285'=>'11.74538','315'=>'12.17436','345'=>'12.56308','375'=>'12.91645','405'=>'13.23893',
				'435'=>'13.53462','465'=>'13.80724','495'=>'14.06019','525'=>'14.29655','555'=>'14.51909','585'=>'14.73034','615'=>'14.93256','645'=>'15.12777',
				'675'=>'15.31777','705'=>'15.50418','735'=>'15.68841','765'=>'15.8717','795'=>'16.05514','825'=>'16.23967',
				'855'=>'16.42609','885'=>'16.61508','915'=>'16.8072','945'=>'17.00291','975'=>'17.2026','1005'=>'17.40654',
				'1035'=>'17.61495','1065'=>'17.82797','1080'=>'17.93625');
		$this->set(compact('percentile3Array','percentile5Array','percentile10Array','percentile25Array','percentile50Array','percentile75Array','percentile85Array','percentile90Array','percentile95Array','percentile97Array'));
		$this->set('diagnosis',$diagnosis);
		$this->set('bmi_array',$bmi_Day);
		$this->set(compact('year','month','date','patient_name'));

	}

	public function bmi_infants_lengthforage_female($id=null) {
		$this->layout=false;
		$this->set('title_for_layout', __('Growth Chart', true));
		$this->uses = array('Patient','BmiResult','ReviewPatientDetail');

			
		$this->Patient->bindModel( array(
				'belongsTo' => array(
						'BmiResult'=>array('conditions'=>array('BmiResult.patient_id=Patient.id'),'foreignKey'=>false),
						'Person'=>array('conditions'=>array('Person.id=Patient.person_id'),'foreignKey'=>false)
				)
		));

		$diagnosis = $this->Patient->find('all',array('fields'=>array('BmiResult.height,BmiResult.height_result,BmiResult.weight,BmiResult.weight_volume,BmiResult.weight_result,BmiResult.bmi,BmiResult.patient_id,BmiResult.created_time,
				Patient.age,Patient.admission_type,Person.sex,Person.dob,Patient.lookup_name'),'conditions'=>array('Patient.person_id'=>$id,'Patient.is_deleted'=>0,'Patient.admission_type'=>'OPD'),'order' => array('Patient.id' => 'asc')));
			
		foreach($diagnosis as $data)
		{
			$var=$this->DateFormat->dateDiff($data['Person']['dob'],$data['BmiResult']['created_time']);
			$day=$var->days;
			$year[$day]=$var->y;
			$month[$day]=$var->m;
			$date[$day]=$data['BmiResult']['created_time'];
			$patient_name=$data['Patient']['lookup_name'];
			$bmi_Day[$day][]=$data['BmiResult']['height_result'];
		}
		$this->Patient->bindModel(array(
				'belongsTo'=>array(
						'ReviewPatientDetail'=>array('conditions'=>array('ReviewPatientDetail.patient_id=Patient.id'),'foreignKey'=>false),
						'ReviewSubCategoriesOption'=>array(
								'conditions'=>array('ReviewSubCategoriesOption.name LIKE'=>"%".Configure::read('bmi_height_measured')."%"),'foreignKey'=>false),
						'Person'=>array('conditions'=>array('Person.id=Patient.person_id'),'foreignKey'=>false)
				)));
		$diagnosis1 = $this->Patient->find('all',array('fields'=>array('ReviewPatientDetail.values,ReviewPatientDetail.date,
				Patient.age,Patient.admission_type,Person.sex,Person.dob,Patient.lookup_name,ReviewSubCategoriesOption.id'),
				'conditions'=>array('Patient.person_id'=>$id,'ReviewSubCategoriesOption.id=ReviewPatientDetail.review_sub_categories_options_id','ReviewPatientDetail.edited_on IS NULL','Patient.is_deleted'=>0,'Patient.admission_type'=>'IPD'),'order' => array('Patient.id' => 'asc')));

		foreach($diagnosis1 as $data)
		{
			$var=$this->DateFormat->dateDiff($data['Person']['dob'],$data['ReviewPatientDetail']['date']);
			$day=$var->days;
			$year[$day]=$var->y;
			$date[$day]=$data['ReviewPatientDetail']['date'];
			$patient_name=$data['Patient']['lookup_name'];
			$month[$day]=$var->m;
			$bmi_Day[$day][]=$data['ReviewPatientDetail']['values'];
		}
		//array for setting the  percentiles standard data
		$percentile3Array=array('0'=>'45.09488','15'=>'47.46916','45'=>'50.95701','75'=>'53.62925','105'=>'55.8594','135'=>'57.8047','165'=>'59.54799','195'=>'61.13893','225'=>'62.60993','255'=>'63.98348',
				'285'=>'65.2759','315'=>'66.49948','345'=>'67.66371','375'=>'68.77613','405'=>'69.8428','435'=>'70.86874','465'=>'71.85807','495'=>'72.81433','525'=>'73.74047','555'=>'74.63908','585'=>'75.51237','615'=>'76.36229','645'=>'77.19056',
				'675'=>'77.99868','705'=>'78.78801','735'=>'79.55974','765'=>'80.33998','795'=>'81.11332','825'=>'81.87334','855'=>'82.61506','885'=>'83.33473','915'=>'84.02972','945'=>'84.69837',
				'975'=>'85.33987','1005'=>'85.95413','1035'=>'86.54167','1065'=>'87.10349','1080'=>'87.2');
		$percentile5Array=array('0'=>'45.57561','15'=>'47.96324','45'=>'51.47996','75'=>'54.17907','105'=>'56.43335','135'=>'58.40032','165'=>'60.16323','195'=>'61.77208','225'=>'63.25958','255'=>'64.64845',
				'285'=>'65.9552','315'=>'67.19226','345'=>'68.36925','375'=>'69.4938','405'=>'70.57207','435'=>'71.60911','465'=>'72.60914','495'=>'73.57571','525'=>'74.51184','555'=>'75.42012','585'=>'76.30282',
				'615'=>'77.16191','645'=>'77.9991','675'=>'78.81595','705'=>'79.61381','735'=>'80.39391','765'=>'81.18804','795'=>'81.97223','825'=>'82.74084','855'=>'83.48951',
				'885'=>'84.21496','915'=>'84.91494','945'=>'85.58809','975'=>'86.23379','1005'=>'86.85208','1035'=>'87.44359','1065'=>'88.00937','1080'=>'88.2');
		$percentile10Array=array('0'=>'46.33934','15'=>'48.74248','45'=>'52.29627','75'=>'55.03144','105'=>'57.31892','135'=>'59.31633','165'=>'61.10726','195'=>'62.7421','225'=>'64.25389','255'=>'65.66559','285'=>'66.99394','315'=>'68.25154',
				'345'=>'69.44814','375'=>'70.59149','405'=>'71.68784','435'=>'72.74233','465'=>'73.75924','495'=>'74.74217','525'=>'75.6942','555'=>'76.61797','585'=>'77.51576','615'=>'78.38958','645'=>'79.2412','675'=>'80.07216','705'=>'80.88385','735'=>'81.67752',
				'765'=>'82.49318','795'=>'83.29459','825'=>'84.07717','855'=>'84.83741','885'=>'85.57273','915'=>'86.28139','945'=>'86.96242','975'=>'87.6155',
				'1005'=>'88.24089','1035'=>'88.83932','1065'=>'89.41196','1080'=>'89.6');
		$percentile25Array=array('0'=>'47.68345','15'=>'50.09686','45'=>'53.69078','75'=>'56.47125','105'=>'58.80346','135'=>'60.84386','165'=>'62.6759','195'=>'64.35005','225'=>'65.89952','255'=>'67.34745','285'=>'68.7107','315'=>'70.00202',
				'345'=>'71.23128','375'=>'72.40633','405'=>'73.53349','435'=>'74.61799','465'=>'75.66416','495'=>'76.67568','525'=>'77.65565','555'=>'78.60678','585'=>'79.53138','615'=>'80.4315','645'=>'81.30893','675'=>'82.16525','705'=>'83.00187',
				'735'=>'83.82007','765'=>'84.67209','795'=>'85.5036','825'=>'86.31151','855'=>'87.09346','885'=>'87.84783','915'=>'88.57362','945'=>'89.27042','975'=>'89.93835',
				'1005'=>'90.57795','1035'=>'91.1902','1065'=>'91.77639','1080'=>'91.9');
		$percentile50Array=array('0'=>'49.2864','15'=>'51.68358','45'=>'55.28613','75'=>'58.09382','105'=>'60.45981','135'=>'62.5367','165'=>'64.40633','195'=>'66.11842','225'=>'67.70574','255'=>'69.19124','285'=>'70.59164','315'=>'71.91962',
				'345'=>'73.18501','375'=>'74.39564','405'=>'75.55785','435'=>'76.67686','465'=>'77.75701','495'=>'78.80198','525'=>'79.81492','555'=>'80.79852','585'=>'81.75512','615'=>'82.68679','645'=>'83.59532','675'=>'84.48233','705'=>'85.34924',
				'735'=>'86.19732','765'=>'87.09026','795'=>'87.95714','825'=>'88.79602','855'=>'89.60551','885'=>'90.38477','915'=>'91.13342','945'=>'91.85154','975'=>'92.53964','1005'=>'93.19854','1035'=>'93.82945','1065'=>'94.43382','1080'=>'94.6');
		$percentile75Array=array('0'=>'51.0187','15'=>'53.36362','45'=>'56.93136','75'=>'59.74045','105'=>'62.1233','135'=>'64.22507','165'=>'66.12418','195'=>'67.8685','225'=>'69.48975','255'=>'71.01019',
				'285'=>'72.44614','315'=>'73.80997','345'=>'75.11133','375'=>'76.35791','405'=>'77.55594','435'=>'78.71058','465'=>'79.82613','495'=>'80.90623','525'=>'81.95399','555'=>'82.97211','585'=>'83.96292',
				'615'=>'84.92846','645'=>'85.87054','675'=>'86.79077','705'=>'87.69056','735'=>'88.57121','765'=>'89.50562','795'=>'90.40982','825'=>'91.28258','855'=>'92.12313',
				'885'=>'92.93113','915'=>'93.70662','945'=>'94.45005','975'=>'95.16218','1005'=>'95.84411','1035'=>'96.49721','1065'=>'97.12307','1080'=>'97.3');
		$percentile90Array=array('0'=>'52.7025','15'=>'54.96222','45'=>'58.45612','75'=>'61.24306','105'=>'63.62648','135'=>'65.74096','165'=>'67.65995','195'=>'69.42868','225'=>'71.07731','255'=>'72.62711','285'=>'74.09378','315'=>'75.48923',
				'345'=>'76.82282','375'=>'78.10202','405'=>'79.3329','435'=>'80.5205','465'=>'81.66903','495'=>'82.78208','525'=>'83.86269','555'=>'84.91353','585'=>'85.93689','615'=>'86.93481','645'=>'87.90908','675'=>'88.86127','705'=>'89.79282',
				'735'=>'90.70499','765'=>'91.67718','795'=>'92.61658','825'=>'93.52227','855'=>'94.39371','885'=>'95.23082','915'=>'96.03385','945'=>'96.80343','975'=>'97.54052','1005'=>'98.24636','1035'=>'98.92246','1065'=>'99.57056','1080'=>'99.7');
		$percentile95Array=array('0'=>'53.77291','15'=>'55.96094','45'=>'59.38911','75'=>'62.15166','105'=>'64.52875','135'=>'66.64653','165'=>'68.57452','195'=>'70.35587',
				'225'=>'72.01952','255'=>'73.58601','285'=>'75.0705','315'=>'76.4846','345'=>'77.83742','375'=>'79.13625','405'=>'80.38705','435'=>'81.59475','465'=>'82.7635','495'=>'83.89683',
				'525'=>'84.99774','555'=>'86.06887','585'=>'87.11249','615'=>'88.13061','645'=>'89.125','675'=>'90.09723','705'=>'91.04873','735'=>'91.98074','765'=>'92.97574',
				'795'=>'93.93693','825'=>'94.86339','855'=>'95.75464','885'=>'96.61061','915'=>'97.43164','945'=>'98.2184','975'=>'98.97193',
				'1005'=>'99.69353','1035'=>'100.3848','1065'=>'101.0475','1080'=>'101.2');
		$percentile97Array=array('0'=>'54.49527','15'=>'56.62728','45'=>'60.00338','75'=>'62.74547','105'=>'65.11577','135'=>'67.23398','165'=>'69.16668','195'=>'70.95545','225'=>'72.62835',
				'255'=>'74.20532','285'=>'75.70118','315'=>'77.12729','345'=>'78.49257','375'=>'79.80419','405'=>'81.06801','435'=>'82.28891','465'=>'83.47098','495'=>'84.6177','525'=>'85.73205',
				'555'=>'86.81663','585'=>'87.8737','615'=>'88.90526','645'=>'89.91305','675'=>'90.89866','705'=>'91.86347','735'=>'92.80876','765'=>'93.81864','795'=>'94.79426','825'=>'95.73464',
				'855'=>'96.63928','885'=>'97.50808','915'=>'98.34139','945'=>'99.13993','975'=>'99.90473','1005'=>'100.6372','1035'=>'101.3388','1065'=>'102.0116','1080'=>'102.4');
		//end of array
		$this->set(compact('percentile3Array','percentile5Array','percentile10Array','percentile25Array','percentile50Array','percentile75Array','percentile85Array','percentile90Array','percentile95Array','percentile97Array'));
		$this->set('diagnosis',$diagnosis);
		$this->set('bmi_array',$bmi_Day);
		$this->set(compact('year','month','date','patient_name'));

	}
	function bmi_infants_lengthforage_male($id=null){

		$this->layout=false;
		$this->set('title_for_layout', __('Growth Chart', true));
		$this->uses = array('Patient','BmiResult','ReviewPatientDetail');
		$this->Patient->bindModel( array(
				'belongsTo' => array(
						'BmiResult'=>array('conditions'=>array('BmiResult.patient_id=Patient.id'),'foreignKey'=>false),
						'Person'=>array('conditions'=>array('Person.id=Patient.person_id'),'foreignKey'=>false)
				)
		));

		$diagnosis = $this->Patient->find('all',array('fields'=>array('BmiResult.height,BmiResult.height_result,BmiResult.weight,BmiResult.weight_volume,BmiResult.weight_result,BmiResult.bmi,BmiResult.patient_id,BmiResult.created_time,
				Patient.age,Patient.admission_type,Person.sex,Person.dob,Patient.lookup_name'),'conditions'=>array('Patient.person_id'=>$id,'Patient.is_deleted'=>0,'Patient.admission_type'=>'OPD'),'order' => array('Patient.id' => 'asc')));
			
		foreach($diagnosis as $data)
		{
			$var=$this->DateFormat->dateDiff($data['Person']['dob'],$data['BmiResult']['created_time']);
			$day=$var->days;
			$year[$day]=$var->y;
			$month[$day]=$var->m;
			$date[$day]=$data['BmiResult']['created_time'];
			$patient_name=$data['Patient']['lookup_name'];
			$bmi_Day[$day][]=$data['BmiResult']['height_result'];
		}
		$this->Patient->bindModel(array(
				'belongsTo'=>array(
						'ReviewPatientDetail'=>array('conditions'=>array('ReviewPatientDetail.patient_id=Patient.id'),'foreignKey'=>false),
						'ReviewSubCategoriesOption'=>array(
								'conditions'=>array('ReviewSubCategoriesOption.name LIKE'=>"%".Configure::read('bmi_height_measured')."%"),'foreignKey'=>false),
						'Person'=>array('conditions'=>array('Person.id=Patient.person_id'),'foreignKey'=>false)
				)));
		$diagnosis1 = $this->Patient->find('all',array('fields'=>array('ReviewPatientDetail.values,ReviewPatientDetail.date,
				Patient.age,Patient.admission_type,Person.sex,Person.dob,Patient.lookup_name,ReviewSubCategoriesOption.id'),
				'conditions'=>array('Patient.person_id'=>$id,'ReviewSubCategoriesOption.id=ReviewPatientDetail.review_sub_categories_options_id','ReviewPatientDetail.edited_on IS NULL','Patient.is_deleted'=>0,'Patient.admission_type'=>'IPD'),'order' => array('Patient.id' => 'asc')));

		foreach($diagnosis1 as $data)
		{
			$var=$this->DateFormat->dateDiff($data['Person']['dob'],$data['ReviewPatientDetail']['date']);
			$day=$var->days;
			$year[$day]=$var->y;
			$date[$day]=$data['ReviewPatientDetail']['date'];
			$patient_name=$data['Patient']['lookup_name'];
			$month[$day]=$var->m;
			$bmi_Day[$day][]=$data['ReviewPatientDetail']['values'];
		}
		$percentile3Array=array('0'=>'44.9251','15'=>'47.97812','45'=>'52.19859','75'=>'55.26322','105'=>'57.73049','135'=>'59.82569','165'=>'61.66384',
				'195'=>'63.31224','225'=>'64.81395','255'=>'66.19833','285'=>'67.48635','315'=>'68.6936','345'=>'69.832','375'=>'70.91088','405'=>'71.9377',
				'435'=>'72.91853','465'=>'73.85839','495'=>'74.76147','525'=>'75.63132','555'=>'76.47096','585'=>'77.283','615'=>'78.06971',
				'645'=>'78.83308','675'=>'79.57485','705'=>'80.29656','735'=>'80.99959','765'=>'81.74464','795'=>'82.47365','825'=>'83.18812',
				'855'=>'83.88931','885'=>'84.57826','915'=>'85.25589','945'=>'85.92294','975'=>'86.58009','1005'=>'87.22791',
				'1035'=>'87.86696','1065'=>'88.49774','1080'=>'88.6');
		$percentile5Array=array('0'=>'45.56841','15'=>'48.55809','45'=>'52.72611','75'=>'55.77345','105'=>'58.23744','135'=>'60.33647','165'=>'62.18261',
				'195'=>'63.84166','225'=>'65.35584','255'=>'66.75398','285'=>'68.05675','315'=>'69.27949','345'=>'70.43397','375'=>'71.52941','405'=>'72.57318',
				'435'=>'73.5713','465'=>'74.52871','495'=>'75.44958','525'=>'76.33742','555'=>'77.19523','585'=>'78.0256','615'=>'78.83077','645'=>'79.61271',
				'675'=>'80.37315','705'=>'81.11363','735'=>'81.83552','765'=>'82.58135','795'=>'83.31105','825'=>'84.02609',
				'855'=>'84.72769','885'=>'85.41688','915'=>'86.09452','945'=>'86.76134','975'=>'87.41799','1005'=>'88.06503',
				'1035'=>'88.70301','1065'=>'89.33242','1080'=>'89.5');
		$percentile10Array=array('0'=>'46.55429','15'=>'49.4578','45'=>'53.55365','75'=>'56.57772','105'=>'59.0383','135'=>'61.1441','165'=>'63.00296',
				'195'=>'64.67854','225'=>'66.21181','255'=>'67.63088','285'=>'68.95591','315'=>'70.20192','345'=>'71.38046','375'=>'72.50055','405'=>'73.56946',
				'435'=>'74.59309','465'=>'75.57634','495'=>'76.5233','525'=>'77.43742','555'=>'78.32168','585'=>'79.17863','615'=>'80.01048','645'=>'80.81919',
				'675'=>'81.60646','705'=>'82.37381','735'=>'83.12259','765'=>'83.87245','795'=>'84.60576','825'=>'85.32399','855'=>'86.02833','885'=>'86.71978',
				'915'=>'87.39917','945'=>'88.06723','975'=>'88.72457','1005'=>'89.37177','1035'=>'90.00937',
				'1065'=>'90.63786','1080'=>'90.7');
		$percentile25Array=array('0'=>'48.18937','15'=>'50.97919','45'=>'54.9791','75'=>'57.9744','105'=>'60.43433','135'=>'62.55409','165'=>'64.43546',
				'195'=>'66.13896','225'=>'67.70375','255'=>'69.15682','285'=>'70.51761','315'=>'71.80065','345'=>'73.01712','375'=>'74.17581','405'=>'75.2838',
				'435'=>'76.34685','465'=>'77.36973','495'=>'78.35646','525'=>'79.31042','555'=>'80.23453','585'=>'81.13131','615'=>'82.00292','645'=>'82.85129',
				'675'=>'83.67811','705'=>'84.48487','735'=>'85.2729','765'=>'86.03703','795'=>'86.78329','825'=>'87.51317','855'=>'88.22788',
				'885'=>'88.9284','915'=>'89.6156','945'=>'90.2902','975'=>'90.95287','1005'=>'91.60421','1035'=>'92.24482','1065'=>'92.87525','1080'=>'92.95');
		$percentile50Array=array('0'=>'49.98888','15'=>'52.69598','45'=>'56.62843','75'=>'59.60895','105'=>'62.077','135'=>'64.21686','165'=>'66.12531',
				'195'=>'67.86018','225'=>'69.45908','255'=>'70.94804','285'=>'72.34586','315'=>'73.66665','345'=>'74.9213','375'=>'76.11838',
				'405'=>'77.2648','435'=>'78.36622','465'=>'79.42734','495'=>'80.45209','525'=>'81.44384','555'=>'82.40544','585'=>'83.33938',
				'615'=>'84.24783','645'=>'85.1327','675'=>'85.99565','705'=>'86.83818','735'=>'87.66161','765'=>'88.45247','795'=>'89.22326',
				'825'=>'89.97549','855'=>'90.71041','885'=>'91.42908','915'=>'92.13242','945'=>'92.82127','975'=>'93.49638',
				'1005'=>'94.15847','1035'=>'94.80823','1065'=>'95.44637','1080'=>'95.6');
		$percentile75Array=array('0'=>'51.77126','15'=>'54.44054','45'=>'58.35059','75'=>'61.33788','105'=>'63.82543','135'=>'65.99131','165'=>'67.92935',
				'195'=>'69.69579','225'=>'71.32735','255'=>'72.84947','285'=>'74.2806','315'=>'75.63462','345'=>'76.92224','375'=>'78.15196',
				'405'=>'79.33061','435'=>'80.4638','465'=>'81.5562','495'=>'82.61174','525'=>'83.63377','555'=>'84.62515','585'=>'85.58837',
				'615'=>'86.52562','645'=>'87.43879','675'=>'88.32957','705'=>'89.19948','735'=>'90.04985','765'=>'90.8787','795'=>'91.68468',
				'825'=>'92.46929','855'=>'93.23385','885'=>'93.97951','915'=>'94.70732','945'=>'95.41824','975'=>'96.11319',
				'1005'=>'96.79307','1035'=>'97.45873','1065'=>'98.11108','1080'=>'98.3');
		$percentile90Array=array('0'=>'53.36153','15'=>'56.03444','45'=>'59.9664','75'=>'62.98158','105'=>'65.49858','135'=>'67.69405',
				'165'=>'69.66122','195'=>'71.45609','225'=>'73.11525','255'=>'74.6641','285'=>'76.1211','315'=>'77.50016','345'=>'78.81202',
				'375'=>'80.0652','405'=>'81.2666','435'=>'82.42185','465'=>'83.53568','495'=>'84.61204','525'=>'85.65431','555'=>'86.66541',
				'585'=>'87.64786','615'=>'88.60385','645'=>'89.53533','675'=>'90.44402','705'=>'91.33143','735'=>'92.19893','765'=>'93.07143',
				'795'=>'93.91817','825'=>'94.74064','855'=>'95.54016','885'=>'96.318','915'=>'97.07531','945'=>'97.81324',
				'975'=>'98.53287','1005'=>'99.23531','1035'=>'99.92162','1065'=>'100.5929','1080'=>'100.7');
		$percentile95Array=array('0'=>'54.30721','15'=>'56.99908','45'=>'60.96465','75'=>'64.00789','105'=>'66.54889','135'=>'68.76538',
				'165'=>'70.75128','195'=>'72.56307','225'=>'74.23767','255'=>'75.80074','285'=>'77.27095','315'=>'78.66234','345'=>'79.98578',
				'375'=>'81.2499','405'=>'82.46167','435'=>'83.6268','465'=>'84.75006','495'=>'85.83547','525'=>'86.88645','555'=>'87.90595',
				'585'=>'88.89652','615'=>'89.86038','645'=>'90.79951','675'=>'91.71563','705'=>'92.61031','735'=>'93.48491','765'=>'94.38775',
				'795'=>'95.263','825'=>'96.1121','855'=>'96.93639','885'=>'97.73717','915'=>'98.51569','945'=>'99.27318',
				'975'=>'100.0109','1005'=>'100.73','1035'=>'101.4318','1065'=>'102.1174','1080'=>'102.3');
		$percentile97Array=array('0'=>'54.919','15'=>'57.62984','45'=>'61.62591','75'=>'64.69241','105'=>'67.2519','135'=>'69.48354','165'=>'71.48218',
				'195'=>'73.30488','225'=>'74.98899','255'=>'76.56047','285'=>'78.03819','315'=>'79.43637','345'=>'80.76602','375'=>'82.03585',
				'405'=>'83.25292','435'=>'84.42302','465'=>'85.55095','495'=>'86.64078','525'=>'87.69597','555'=>'88.7195','585'=>'89.71393',
				'615'=>'90.68153','645'=>'91.62428','675'=>'92.54392','705'=>'93.44203','735'=>'94.31998','765'=>'95.24419','795'=>'96.13962',
				'825'=>'97.00763','855'=>'97.84957','885'=>'98.66677','915'=>'99.46052','945'=>'100.2321','975'=>'100.9829',
				'1005'=>'101.7142','1035'=>'102.4274','1065'=>'103.1237','1080'=>'103.4');
		$this->set(compact('percentile3Array','percentile5Array','percentile10Array','percentile25Array','percentile50Array','percentile75Array','percentile85Array','percentile90Array','percentile95Array','percentile97Array'));
		$this->set('diagnosis',$diagnosis);
		$this->set('bmi_array',$bmi_Day);
		$this->set(compact('year','month','date','patient_name','day'));

	}
	//headCircumference
	function bmi_infants_headcircumference_male($id=null){
		$this->layout=false;
		$this->set('title_for_layout', __('Growth Chart', true));
		$this->uses = array('Patient','BmiResult');

			
		$this->Patient->bindModel( array(
				'belongsTo' => array(
						'BmiResult'=>array('conditions'=>array('BmiResult.patient_id=Patient.id'),'foreignKey'=>false),
						'Person'=>array('conditions'=>array('Person.id=Patient.person_id'),'foreignKey'=>false)
				)
		));


		$diagnosis = $this->Patient->find('all',array('fields'=>array('BmiResult.height,BmiResult.weight,BmiResult.head_circumference,BmiResult.bmi,BmiResult.patient_id,BmiResult.created_time,
				Patient.age,Person.sex,Person.dob,Patient.lookup_name'),'conditions'=>array('Patient.person_id'=>$id,'Patient.is_deleted'=>0,'Patient.admission_type'=>'OPD'),'order' => array('Patient.id' => 'asc')));

		foreach($diagnosis as $data)
		{
			$var=$this->DateFormat->dateDiff($data['Person']['dob'],$data['BmiResult']['created_time']);
			$day=$var->days;
			$year[$day]=$var->y;
			$month[$day]=$var->m;
			$patient_name=$data['Patient']['lookup_name'];
			$bmi_Day[$day][]=$data['BmiResult']['head_circumference'];
		}
		$this->Patient->bindModel(array(
				'belongsTo'=>array(
						'ReviewPatientDetail'=>array('conditions'=>array('ReviewPatientDetail.patient_id=Patient.id'),'foreignKey'=>false),
						'ReviewSubCategoriesOption'=>array(
								'conditions'=>array('ReviewSubCategoriesOption.name LIKE'=>"%".Configure::read('bmi_head_circumference')."%"),'foreignKey'=>false),
						'Person'=>array('conditions'=>array('Person.id=Patient.person_id'),'foreignKey'=>false)
				)));
		$diagnosis1 = $this->Patient->find('all',array('fields'=>array('ReviewPatientDetail.values,ReviewPatientDetail.date,
				Patient.age,Patient.admission_type,Person.sex,Person.dob,Patient.lookup_name,ReviewSubCategoriesOption.id'),
				'conditions'=>array('Patient.person_id'=>$id,'ReviewSubCategoriesOption.id=ReviewPatientDetail.review_sub_categories_options_id','ReviewPatientDetail.edited_on IS NULL','Patient.is_deleted'=>0,'Patient.admission_type'=>'IPD'),'order' => array('Patient.id' => 'asc')));

		foreach($diagnosis1 as $data)
		{
			$var=$this->DateFormat->dateDiff($data['Person']['dob'],$data['ReviewPatientDetail']['date']);
			$day=$var->days;
			$year[$day]=$var->y;
			$date[$day]=$data['ReviewPatientDetail']['date'];
			$patient_name=$data['Patient']['lookup_name'];
			$month[$day]=$var->m;
			$bmi_Day[$day][]=$data['ReviewPatientDetail']['values'];
		}
		$percentile3Array=array('0'=>'31.48762','15'=>'33.25006','45'=>'35.78126','75'=>'37.5588','105'=>'38.89944','135'=>'39.95673','165'=>'40.81642','195'=>'41.53109','225'=>'42.13521','255'=>'42.65253',
				'285'=>'43.10009','315'=>'43.49049','345'=>'43.83332','375'=>'44.136','405'=>'44.40441','435'=>'44.64328','465'=>'44.85646',
				'495'=>'45.04712','525'=>'45.2179','555'=>'45.37104','585'=>'45.50843','615'=>'45.63169','645'=>'45.74221','675'=>'45.84121',
				'705'=>'45.92974','735'=>'46.00872','765'=>'46.07898','795'=>'46.14124','825'=>'46.19614','855'=>'46.24425','885'=>'46.2861',
				'915'=>'46.32214','945'=>'46.3528','975'=>'46.37844','1005'=>'46.39942','1035'=>'46.41605','1065'=>'46.4286','1080'=>'46.43344');
		$percentile5Array=array('0'=>'32.14881','15'=>'33.83392','45'=>'36.26428','75'=>'37.97959','105'=>'39.27893','135'=>'40.30766','165'=>'41.14714',
				'195'=>'41.84742','225'=>'42.44134','255'=>'42.95162','285'=>'43.39458','315'=>'43.7823','345'=>'44.12399',
				'375'=>'44.42679','405'=>'44.69639','435'=>'44.93733','465'=>'45.15333','495'=>'45.34746','525'=>'45.52229',
				'555'=>'45.67997','585'=>'45.82234','615'=>'45.95096','645'=>'46.06719','675'=>'46.17221','705'=>'46.26704',
				'735'=>'46.35259','765'=>'46.42963','795'=>'46.49889','825'=>'46.56098','855'=>'46.61646','885'=>'46.66583',
				'915'=>'46.70954','945'=>'46.74801','975'=>'46.78159','1005'=>'46.81061','1035'=>'46.8354','1065'=>'46.85621','1080'=>'46.86521');
		$percentile10Array=array('0'=>'33.08389','15'=>'34.67253','45'=>'36.97377','75'=>'38.60724','105'=>'39.85123','135'=>'40.84114','165'=>'41.65291',
				'195'=>'42.3333','225'=>'42.91311','255'=>'43.41365','285'=>'43.85025','315'=>'44.23432','345'=>'44.57454','375'=>'44.87767',
				'405'=>'45.14908','435'=>'45.3931','465'=>'45.61325','495'=>'45.81245','525'=>'45.99315','555'=>'46.15739',
				'585'=>'46.30692','615'=>'46.44325','645'=>'46.56767','675'=>'46.68129','705'=>'46.78511','735'=>'46.87997',
				'765'=>'46.96663','795'=>'47.04578','825'=>'47.11801','855'=>'47.18385','885'=>'47.24379','915'=>'47.29824',
				'945'=>'47.34761','975'=>'47.39225','1005'=>'47.43247','1035'=>'47.46857','1065'=>'47.50081','1080'=>'47.51556');
		$percentile25Array=array('0'=>'34.46952','15'=>'35.93987','45'=>'38.07878','75'=>'39.60637','105'=>'40.77713','135'=>'41.71483','165'=>'42.48889',
				'195'=>'43.14204','225'=>'43.70245','255'=>'44.18964','285'=>'44.61764','315'=>'44.99694','345'=>'45.33549','375'=>'45.63952',
				'405'=>'45.91398','435'=>'46.16284','465'=>'46.38937','495'=>'46.59626','525'=>'46.78578','555'=>'46.95981',
				'585'=>'47.11999','615'=>'47.26769','645'=>'47.40413','675'=>'47.53035','705'=>'47.64724','735'=>'47.75563',
				'765'=>'47.85621','795'=>'47.94962','825'=>'48.0364','855'=>'48.11707','885'=>'48.19206','915'=>'48.26178','945'=>'48.3266',
				'975'=>'48.38684','1005'=>'48.44281','1035'=>'48.49479','1065'=>'48.54301','1080'=>'48.56578');
		$percentile50Array=array('0'=>'35.81367','15'=>'37.19361','45'=>'39.20743','75'=>'40.65233','105'=>'41.76517','135'=>'42.66116','165'=>'43.40489',
				'195'=>'44.0361','225'=>'44.58097','255'=>'45.05761','285'=>'45.47908','315'=>'45.85506','345'=>'46.19295','375'=>'46.49853',
				'405'=>'46.77638','435'=>'47.03018','465'=>'47.26295','495'=>'47.47721','525'=>'47.67504','555'=>'47.85821','585'=>'48.02822',
				'615'=>'48.18637','645'=>'48.33377','675'=>'48.4714','705'=>'48.60011','735'=>'48.72065','765'=>'48.83367','795'=>'48.93976',
				'825'=>'49.03945','855'=>'49.13321','885'=>'49.22146','915'=>'49.30458','945'=>'49.38292','975'=>'49.45678',
				'1005'=>'49.52645','1035'=>'49.59218','1065'=>'49.65423','1080'=>'49.68394');
		$percentile75Array=array('0'=>'37.00426','15'=>'38.32125','45'=>'40.24987','75'=>'41.63968','105'=>'42.71455','135'=>'43.58358','165'=>'44.30801',
				'195'=>'44.92555','225'=>'45.46104','255'=>'45.93166','285'=>'46.34979','315'=>'46.72463','345'=>'47.06318','375'=>'47.37091',
				'405'=>'47.65214','435'=>'47.91038','465'=>'48.14848','495'=>'48.36881','525'=>'48.57336','555'=>'48.76379','585'=>'48.94153',
				'615'=>'49.10781','645'=>'49.2637','675'=>'49.4101','705'=>'49.54784','735'=>'49.67762','765'=>'49.80008',
				'795'=>'49.91578','825'=>'50.02521','855'=>'50.12883','885'=>'50.22705','915'=>'50.32023','945'=>'50.40869','975'=>'50.49275',
				'1005'=>'50.57267','1035'=>'50.6487','1065'=>'50.72108','1080'=>'50.75597');
		$percentile90Array=array('0'=>'37.97379','15'=>'39.24989','45'=>'41.12605','75'=>'42.48436','105'=>'43.53902','135'=>'44.39472',
				'165'=>'45.11034','195'=>'45.72225','225'=>'46.25443','255'=>'46.72349','285'=>'47.14142','315'=>'47.51714','345'=>'47.85744',
				'375'=>'48.16763','405'=>'48.45191','435'=>'48.71371','465'=>'48.95578','495'=>'49.18045','525'=>'49.38963','555'=>'49.58497',
				'585'=>'49.76786','615'=>'49.93948','645'=>'50.10089','675'=>'50.25298','705'=>'50.39655','735'=>'50.53229',
				'765'=>'50.66082','795'=>'50.78269','825'=>'50.89839','855'=>'51.00836','885'=>'51.113','915'=>'51.21268',
				'945'=>'51.3077','975'=>'51.39837','1005'=>'51.48496','1035'=>'51.56771','1065'=>'51.64686','1080'=>'51.68514');
		$percentile95Array=array('0'=>'38.51574','15'=>'39.77262','45'=>'41.62581','75'=>'42.97189','105'=>'44.01984','135'=>'44.87197',
				'165'=>'45.58593','195'=>'46.19736','225'=>'46.72983','255'=>'47.1997','285'=>'47.6188','315'=>'47.99592',
				'345'=>'48.33781','375'=>'48.64972','405'=>'48.93584','435'=>'49.19955','465'=>'49.44362','495'=>'49.67034',
				'525'=>'49.88166','555'=>'50.07919','585'=>'50.26432','615'=>'50.43825','645'=>'50.60203','675'=>'50.75654','705'=>'50.90258',
				'735'=>'51.04085','765'=>'51.17196','795'=>'51.29647','825'=>'51.41485','855'=>'51.52756','885'=>'51.63499',
				'915'=>'51.73749','945'=>'51.83539','975'=>'51.92898','1005'=>'52.01853','1035'=>'52.10429',
				'1065'=>'52.18646','1080'=>'52.22628');
		$percentile97Array=array('0'=>'38.85417','15'=>'40.10028','45'=>'41.94138','75'=>'43.28181','105'=>'44.32733','135'=>'45.17877',
				'165'=>'45.893','195'=>'46.50524','225'=>'47.0388','255'=>'47.5099','285'=>'47.93027','315'=>'48.30867',
				'345'=>'48.65181','375'=>'48.96494','405'=>'49.25225','435'=>'49.51712','465'=>'49.76233','495'=>'49.99018',
				'525'=>'50.20261','555'=>'50.40125','585'=>'50.58751','615'=>'50.76259','645'=>'50.92752','675'=>'51.08322',
				'705'=>'51.23047','735'=>'51.36998','765'=>'51.50236','795'=>'51.62817','825'=>'51.7479','855'=>'51.86198',
				'885'=>'51.97081','915'=>'52.07475','945'=>'52.17413','975'=>'52.26923','1005'=>'52.36032','1035'=>'52.44764',
				'1065'=>'52.53143','1080'=>'52.57205');
		$this->set(compact('percentile3Array','percentile5Array','percentile10Array','percentile25Array','percentile50Array','percentile75Array','percentile85Array','percentile90Array','percentile95Array','percentile97Array'));
		$this->set('diagnosis',$diagnosis);
		$this->set('bmi_array',$bmi_Day);
		$this->set(compact('year','month','date','patient_name'));

	}
	function bmi_infants_headcircumference_female($id=null){
		$this->layout=false;
		$this->set('title_for_layout', __('Growth Chart', true));
		$this->uses = array('Patient','BmiResult');

		$this->Patient->bindModel( array(
				'belongsTo' => array(
						'BmiResult'=>array('conditions'=>array('BmiResult.patient_id=Patient.id'),'foreignKey'=>false),
						'Person'=>array('conditions'=>array('Person.id=Patient.person_id'),'foreignKey'=>false)
				)
		));


		$diagnosis = $this->Patient->find('all',array('fields'=>array('BmiResult.height,BmiResult.weight,BmiResult.head_circumference,BmiResult.bmi,BmiResult.patient_id,BmiResult.created_time,
				Patient.age,Person.sex,Person.dob,Patient.lookup_name'),'conditions'=>array('Patient.person_id'=>$id,'Patient.is_deleted'=>0,'Patient.admission_type'=>'OPD'),'order' => array('Patient.id' => 'asc')));

		foreach($diagnosis as $data)
		{
			$var=$this->DateFormat->dateDiff($data['Person']['dob'],$data['BmiResult']['created_time']);
			$day=$var->days;
			$year[$day]=$var->y;
			$month[$day]=$var->m;
			$patient_name=$data['Patient']['lookup_name'];
			$bmi_Day[$day][]=$data['BmiResult']['head_circumference'];
		}

		$this->Patient->bindModel(array(
				'belongsTo'=>array(
						'ReviewPatientDetail'=>array('conditions'=>array('ReviewPatientDetail.patient_id=Patient.id'),'foreignKey'=>false),
						'ReviewSubCategoriesOption'=>array(
								'conditions'=>array('ReviewSubCategoriesOption.name LIKE'=>"%".Configure::read('bmi_head_circumference')."%"),'foreignKey'=>false),
						'Person'=>array('conditions'=>array('Person.id=Patient.person_id'),'foreignKey'=>false)
				)));
		$diagnosis1 = $this->Patient->find('all',array('fields'=>array('ReviewPatientDetail.values,ReviewPatientDetail.date,
				Patient.age,Patient.admission_type,Person.sex,Person.dob,Patient.lookup_name,ReviewSubCategoriesOption.id'),
				'conditions'=>array('Patient.person_id'=>$id,'ReviewSubCategoriesOption.id=ReviewPatientDetail.review_sub_categories_options_id','ReviewPatientDetail.edited_on IS NULL','Patient.is_deleted'=>0,'Patient.admission_type'=>'IPD'),'order' => array('Patient.id' => 'asc')));
		//debug($data['Patient']['lookup_name']);
		foreach($diagnosis1 as $data)
		{
			$var=$this->DateFormat->dateDiff($data['Person']['dob'],$data['ReviewPatientDetail']['date']);
			$day=$var->days;
			$year[$day]=$var->y;
			$date[$day]=$data['ReviewPatientDetail']['date'];
			$patient_name=$data['Patient']['lookup_name'];
			//debug($patient_name);
			$month[$day]=$var->m;
			$bmi_Day[$day][]=$data['ReviewPatientDetail']['values'];
		}
		$percentile3Array=array('0'=>'31.9302','15'=>'33.38071','45'=>'35.48627','75'=>'36.9855','105'=>'38.13114','135'=>'39.04619',
				'165'=>'39.7996','195'=>'40.43379','225'=>'40.97672','255'=>'41.44768','285'=>'41.86058','315'=>'42.22575','345'=>'42.55105',
				'375'=>'42.8426','405'=>'43.10526','435'=>'43.34294','465'=>'43.55883','495'=>'43.75558','525'=>'43.93539','555'=>'44.10013',
				'585'=>'44.25137','615'=>'44.39047','645'=>'44.51861','675'=>'44.6368','705'=>'44.74593','735'=>'44.84678','765'=>'44.94005',
				'795'=>'45.02634','825'=>'45.1062','855'=>'45.18011','885'=>'45.24852','915'=>'45.31181','945'=>'45.37035','975'=>'45.42444',
				'1005'=>'45.4744','1035'=>'45.52047','1065'=>'45.56291','1080'=>'45.58284');
		$percentile5Array=array('0'=>'32.2509','15'=>'33.68744','45'=>'35.7756','75'=>'37.26522','105'=>'38.40561','135'=>'39.31814','165'=>'40.07086',
				'195'=>'40.70567','225'=>'41.25016','255'=>'41.7234','285'=>'42.13913','315'=>'42.50755','345'=>'42.83643','375'=>'43.13182','405'=>'43.39853',
				'435'=>'43.64042','465'=>'43.86066','495'=>'44.06186','525'=>'44.2462','555'=>'44.41553','585'=>'44.57142','615'=>'44.71521',
				'645'=>'44.84806','675'=>'44.97099','705'=>'45.08487','735'=>'45.19047','765'=>'45.2885','795'=>'45.37954','825'=>'45.46415',
				'855'=>'45.5428','885'=>'45.61594','915'=>'45.68394','945'=>'45.74718','975'=>'45.80596','1005'=>'45.86058','1035'=>'45.9113','1065'=>'45.95837',
				'1080'=>'45.98061');
		$percentile10Array=array('0'=>'32.75949','15'=>'34.17346','45'=>'36.23326','75'=>'37.70685','105'=>'38.83814','135'=>'39.74588','165'=>'40.49672',
				'195'=>'41.13171','225'=>'41.67787','255'=>'42.15391','285'=>'42.5733','315'=>'42.94604','345'=>'43.27977','375'=>'43.58043','405'=>'43.85274',
				'435'=>'44.1005','465'=>'44.32682','495'=>'44.53428','525'=>'44.72501','555'=>'44.90085','585'=>'45.06333','615'=>'45.21378','645'=>'45.35334',
				'675'=>'45.48301','705'=>'45.60367','735'=>'45.71608','765'=>'45.82092','795'=>'45.91878','825'=>'46.01021','855'=>'46.09568','885'=>'46.17562',
				'915'=>'46.25043','945'=>'46.32044','975'=>'46.38599','1005'=>'46.44736','1035'=>'46.50481','1065'=>'46.55859','1080'=>'46.58417');
		$percentile25Array=array('0'=>'33.65187','15'=>'35.02508','45'=>'37.03282','75'=>'38.47603','105'=>'39.58905','135'=>'40.48611','165'=>'41.23136','195'=>'41.86435',
				'225'=>'42.41113','255'=>'42.88978','285'=>'43.31329','315'=>'43.69135','345'=>'44.03133','375'=>'44.33899','405'=>'44.61891','435'=>'44.87476',
				'465'=>'45.10959','495'=>'45.32587','525'=>'45.5257','555'=>'45.71086','585'=>'45.88284','615'=>'46.04295','645'=>'46.19229','675'=>'46.33184','705'=>'46.46246',
				'735'=>'46.58489','765'=>'46.6998','795'=>'46.80778','825'=>'46.90935','855'=>'47.00499','885'=>'47.09511','915'=>'47.18009','945'=>'47.2603',
				'975'=>'47.33603','1005'=>'47.40757','1035'=>'47.47518','1065'=>'47.53911','1080'=>'47.56976');
		$percentile50Array=array('0'=>'34.71156','15'=>'36.03454','45'=>'37.97672','75'=>'39.38013','105'=>'40.46774','135'=>'41.34841','165'=>'42.08335','195'=>'42.71034','225'=>'43.25429',
				'255'=>'43.7325','285'=>'44.15743','315'=>'44.53837','345'=>'44.88241','375'=>'45.19508','405'=>'45.48078','435'=>'45.74308','465'=>'45.98487','495'=>'46.20858',
				'525'=>'46.41622','555'=>'46.6095','585'=>'46.78989','615'=>'46.95863','645'=>'47.11681','675'=>'47.26538','705'=>'47.40516','735'=>'47.53688','765'=>'47.66118',
				'795'=>'47.77865','825'=>'47.88979','855'=>'47.99506','885'=>'48.09488','915'=>'48.18961','945'=>'48.2796','975'=>'48.36515','1005'=>'48.44654',
				'1035'=>'48.52402','1065'=>'48.59783','1080'=>'48.63342');
		$percentile75Array=array('0'=>'35.85124','15'=>'37.11807','45'=>'38.98533','75'=>'40.34145','105'=>'41.39732','135'=>'42.25604','165'=>'42.97566','195'=>'43.59207',
				'225'=>'44.12897','255'=>'44.60282','285'=>'45.0255','315'=>'45.40587','345'=>'45.75072','375'=>'46.06532','405'=>'46.3539',
				'435'=>'46.61986','465'=>'46.86599','495'=>'47.0946','525'=>'47.30765','555'=>'47.50676','585'=>'47.69335','615'=>'47.86861','645'=>'48.0336',
				'675'=>'48.18923','705'=>'48.33629','735'=>'48.47548','765'=>'48.60743','795'=>'48.7327','825'=>'48.85178','855'=>'48.9651','885'=>'49.07308',
				'915'=>'49.17607','945'=>'49.2744','975'=>'49.36836','1005'=>'49.45823','1035'=>'49.54425','1065'=>'49.62665','1080'=>'49.66656');
		$percentile90Array=array('0'=>'36.9535','15'=>'38.16405','45'=>'39.95459','75'=>'41.26063','105'=>'42.28153','135'=>'43.11489','165'=>'43.81575','195'=>'44.41815',
				'225'=>'44.94461','255'=>'45.41078','285'=>'45.82799','315'=>'46.20466','345'=>'46.54726','375'=>'46.86084','405'=>'47.14942',
				'435'=>'47.41624','465'=>'47.66399','495'=>'47.89487','525'=>'48.11074','555'=>'48.31317','585'=>'48.50351','615'=>'48.6829',
				'645'=>'48.85236','675'=>'49.01276','705'=>'49.16486','735'=>'49.30933','765'=>'49.44677','795'=>'49.57773',
				'825'=>'49.70266','855'=>'49.822','885'=>'49.93613','915'=>'50.0454','945'=>'50.15012','975'=>'50.25058','1005'=>'50.34704',
				'1035'=>'50.43974','1065'=>'50.52889','1080'=>'50.5722');
		$percentile95Array=array('0'=>'37.65138','15'=>'38.82535','45'=>'40.56517','75'=>'41.83732','105'=>'42.83396','135'=>'43.64924','165'=>'44.3363',
				'195'=>'44.92803','225'=>'45.44619','255'=>'45.90591','285'=>'46.31815','315'=>'46.69106','345'=>'47.0309',
				'375'=>'47.34255','405'=>'47.62991','435'=>'47.89613','465'=>'48.1438','495'=>'48.37505','525'=>'48.5917','555'=>'48.79526',
				'585'=>'48.98703','615'=>'49.16814','645'=>'49.33955','675'=>'49.50211','705'=>'49.65657','735'=>'49.80358',
				'765'=>'49.94373','795'=>'50.07751','825'=>'50.20541','855'=>'50.32783','885'=>'50.44514','915'=>'50.55769','945'=>'50.66578',
				'975'=>'50.76968','1005'=>'50.86965','1035'=>'50.96593','1065'=>'51.05872','1080'=>'51.10387');
		$percentile97Array=array('0'=>'38.1211','15'=>'39.27006','45'=>'40.97482','75'=>'42.22321','105'=>'43.2026','135'=>'44.00486',
				'165'=>'44.68183','195'=>'45.26563','225'=>'45.77751','255'=>'46.23224','285'=>'46.64053','315'=>'47.01035',
				'345'=>'47.3478','375'=>'47.65766','405'=>'47.94373','435'=>'48.20911','465'=>'48.4563','495'=>'48.68741','525'=>'48.90419',
				'555'=>'49.10814','585'=>'49.30052','615'=>'49.48244','645'=>'49.65484','675'=>'49.81854','705'=>'49.97429','735'=>'50.12271',
				'765'=>'50.26437','795'=>'50.39978','825'=>'50.5294','855'=>'50.65362','885'=>'50.77281','915'=>'50.88731',
				'945'=>'50.99741','975'=>'51.10338','1005'=>'51.20547','1035'=>'51.30392','1065'=>'51.39892','1080'=>'51.44519');

		$this->set(compact('percentile3Array','percentile5Array','percentile10Array','percentile25Array','percentile50Array','percentile75Array','percentile85Array','percentile90Array','percentile95Array','percentile97Array'));
		$this->set('diagnosis',$diagnosis);
		$this->set('bmi_array',$bmi_Day);
		$this->set(compact('year','month','date','patient_name'));
	}

	/*
	 * function patient_search
	*
	* */
	function patient_search($searchType=null){
		$this->layout =false ;
		$this->set('title_for_layout', __('-Search UIDpatient', true));
		$this->set('data','');
		$role = $this->Session->read('role');
		// $this->Person->recursive = 0;
		$search_key['Person.is_deleted'] = 0;
		//select all inpatient's UID
		$this->uses  =array('Patient');
		$inpatientUID = $this->Patient->find('all',array('fields'=>'patient_id','conditions'=>array('Patient.is_discharge'=>0,'Patient.is_deleted'=>0),'group'=>'Patient.patient_id','order'=>'patient_id DESC'));
		$patientUIDArr =array();
		foreach($inpatientUID as $key=>$value ){
			if($value['Patient']['patient_id'] !=''){
				$patientUIDArr[] = $value['Patient']['patient_id'];
			}
		}
		if(!empty($patientUIDArr)){
			$search_key["NOT"] = array("Person.patient_uid" => $patientUIDArr);
		}
		/*if($role == 'admin'){
		 $this->Person->bindModel(array(
		 		'belongsTo' => array(
		 				'Location'=>array('type'=>'inner','foreignKey'=>'location_id','conditions'=>array("Location.facility_id=".$this->Session->read('facilityid'))),
		 		)),false);
		}else{*/
		$search_key['Person.location_id']=$this->Session->read('locationid');
			
		$this->Person->bindModel(array(
				'belongsTo' => array(
						'Location'=>array('type'=>'inner','foreignKey'=>'location_id'),
						'Initial' =>array('foreignKey' => false,'conditions'=>array('Initial.id=Person.initial_id')),
						'Account'=>array('foreignKey'=>false,'conditions'=>array('Account.system_user_id=Person.id')),
				)),false);
		//}
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array(
						'Person.id' => 'Desc'
				),
				'group'=>'Person.id',
				'fields'=>array('Person.*','Initial.name','Account.balance')
		);
		if($searchType)
			$search_key['Person.admission_type'] = $searchType;
		if(!empty($this->request->query)){
			$search_ele = $this->request->query ;

			if(!empty($search_ele['first_name'])){
				$search_key['Person.first_name like '] = "%".$search_ele['first_name']."%" ;
			}if(!empty($search_ele['last_name'])){
				$search_key['Person.last_name like '] = "%".$search_ele['last_name'] ;
			}if(!empty($search_ele['patient_id'])){
				$search_key['Person.patient_uid like '] = "%".$search_ele['patient_id'] ;
			}


			$data = $this->paginate('Person',$search_key);
			$this->set('data', $data);
			$this->data =array('Person'=>$search_ele);
		}else{
			$data = $this->paginate('Person',array($search_key));
			$this->set('data', $data);
		}
			
	}

	//function to print QR card
	function qr_card($id=null){
		//no need of layout
		$this->layout  = false ;
		$this->set('title_for_layout', __('-Print QR Card', true));
		if(!empty($id)){
			$this->uses = array('Facility','Consultant','DoctorProfile');
			$this->Person->bindModel(array(
					'belongsTo' => array(
							'Initial' =>array(
									'foreignKey'=>'initial_id'
							)
					)));
			$patient_details  = $this->Person->getPersonDetailsByID($id);

			$docName='';

			if($patient_details['Person']['known_fam_physician']==Configure ::read('referralforregistrar')){
				$docDetails = $this->DoctorProfile->getDoctorByID($patient_details['Person']['registrar_id']);
				$docName = $docDetails['DoctorProfile']['doctor_name'];
			}else if(!empty($patient_details['Person']['known_fam_physician'])){
				$docDetails = $this->Consultant->getConsultantByID($patient_details['Person']['consultant_id']);
				$docName = $docDetails['Consultant']['full_name'];
			}


			//corporate name
			$this->loadModel('Corporate');
			$this->loadModel('InsuranceCompany');
			if($patient_details['Person']['credit_type_id'] == 1){
				$corporateEmp = $this->Corporate->getCorporateByID($patient_details['Person']['corporate_id']);
			}else if($patient_details['Person']['credit_type_id'] == 2){
				$corporateEmp = $this->InsuranceCompany->getInsuranceCompanyByID($patient_details['Person']['insurance_company_id']);
			}else{
				$corporateEmp ='Private';
			}
			//corporate name


			$formatted_address = $this->setAddressFormat($patient_details['Person']);
			$this->set('company',$corporateEmp);
			$this->set('address',$formatted_address);
			$this->set('person',$patient_details);
			$this->set('id',$id);
			$this->set('doctor_name',$docName);
			$this->set('hospital',$this->Facility->read('name',$this->Session->read('facilityid')));

		}else{
			$this->redirect(array("controller" => "patients", "action" => "index"));
		}
	}
	/**
	 * Called after inserting patient data
	 *
	 * @param id:latest patient table ID
	 * @param patient_info(array): patient details as posted from patinet registration form
	 * @return patient ID
	 **/
	function autoGeneratedPatientID($id=null,$patient_info = array()){
		$count = $this->Person->find('count',array('conditions'=>array('Person.create_time like'=> "%".date("Y-m-d")."%",
				/*'Person.location_id'=>$this->Session->read('locationid')*/)));// ---- for same location initial name it creates duplicate uID---gaurav @pankaj
		if( strtolower( $this->Session->read('website.instance') ) == 'hope' ){
			if($count==0){
				$count = "001" ;
			}else if($count < 10 ){
				$count = "00$count" ;
			}else if($count >= 10 && $count <100){
				$count = "0$count" ;
			}
			$month_array = array('A','B','C','D','E','F','G','H','I','J','K','L');
			
			//creating patient ID
			$unique_id = 'U';
			$facility = $this->Session->read('facility');
			$location = $this->Session->read('location');
			$unique_id .= substr($facility,0,1); //first letter of the hospital name
			$unique_id .= substr($location,0,2);//first 2 letter of d location
			$unique_id .= date('y'); //year
			$unique_id .= $month_array[date('n')-1];//first letter of month
			$unique_id .= date('d');//day
			$unique_id .= $count;
		}else if($this->Session->read('website.instance')=='vadodara'){
			
			//vadodara UID Format MSA-15 51 (MSA-year count of person table)
			$countPerson = $this->Person->find('count');
			$unique_id='MSA'.date('y');
			$unique_id.='/'.$countPerson;
		}
		else{
			$this->loadModel('Configuration');
			$prefix = $this->Configuration->find('first',array('conditions'=>array('name'=>'Prefix')));
			$previousData = unserialize($prefix['Configuration']['value']);
			$inArray = array_key_exists('u_id',$previousData);
			if($inArray){
				$prefix = $previousData['u_id'];  // for reference go to configuration controller in index (); ***gulshan
			}
			$count = $this->Person->find('count',array('conditions'=>array('Person.create_time like'=> "%".date("Y-m-d")."%",
					'Person.admission_type'=>$this->request->data['Person']['admission_type'])));
			
			if($count < 10){
				$count = "0$count";
			}else{
				$count = "$count";
			}
		/*	if($count==0){
				$count = "000001" ;
			}else if($count < 10 ){
				$count = "00000$count"  ;
			}else if($count >= 10 && $count <100){
				$count = "0000$count"  ;
			}else if($count >= 100 && $count <1000){
				$count = "000$count"  ;
			}else if($count >= 1000 && $count <10000){
				$count = "00$count"  ;
			}else if($count >= 10000 && $count <100000){
				$count = "0$count"  ;
			}else if($count >= 100000 && $count <1000000){
				$count = "$count"  ;
			}*/
			if($this->request->data['Person']['admission_type']=="IPD"){
				
				$unique_id   = $prefix.'-'.'I'.'-'.date('d').'-'.date('m').'-'.date('y').'-'.$count;
				
			}else if($this->request->data['Person']['admission_type']=="OPD"){
				$unique_id   = $prefix.'-'.'O'.'-'.date('d').'-'.date('m').'-'.date('y').'-'.$count;	
							
			}else if($this->request->data['Person']['admission_type']=="RAD"){
				$unique_id   = $prefix.'-'.'R'.'-'.date('d').'-'.date('m').'-'.date('y').'-'.$count;
				
			}else if($this->request->data['Person']['admission_type']=="LAB"){
				$unique_id   = $prefix.'-'.'L'.'-'.date('d').'-'.date('m').'-'.date('y').'-'.$count;	
			}else
				$unique_id   = $prefix.'-'.'E'.'-'.date('d').'-'.date('m').'-'.date('y').'-'.$count;
	
		}
		return strtoupper($unique_id) ;
			
	}

	function qrFormat($patient_details){
			
		$formatted_address = $this->setAddressFormat($patient_details); // temp comment
		$qr_format  = $patient_details['first_name']." ".$patient_details['last_name']." ;" ;
		$qr_format .= " Patient ID:".$patient_details['patient_uid']." ;" ;

		if(isset($patient_details['email'])){
			$e =$patient_details['email'];
		}

		if(isset($patient_details['mobile'])){
			$mp =$patient_details['mobile'];
		}
		if(isset($patient_details['blood_group'])){
			$bg =$patient_details['blood_group'];
		}
		if(isset($patient_details['relative_name'])){
			$relativeName =  $patient_details['relative_name'];
		}

		if(isset($patient_details['relative_phone'])){
			$mobileno =  $patient_details['relative_phone'];
		}

		if(isset($patient_details['family_phy_con_no'])){
			$doctorPhone =  $patient_details['family_phy_con_no'];
		}


		if(isset($patient_details['allergies'])){
			$alle =$patient_details['allergies'];
		}

		if($patient_details['known_fam_physician']==Configure ::read('referralforregistrar')){
			$docDetails = $this->DoctorProfile->getDoctorByID($patient_details['registrar_id']);
			$docName = $docDetails['DoctorProfile']['doctor_name'];
		}else if(!empty($patient_details['known_fam_physician'])){
			$docDetails = $this->Consultant->getConsultantByID($patient_details['consultant_id']);
			$docName = $docDetails['Consultant']['full_name'];
		}

		$qr_format .= " Age/Sex: ".$patient_details['age']."/".ucfirst($patient_details['sex']);
		$qr_format .= ($bg)?" Blood Group: ".$bg." ;" :'';
			
		$qr_format .= ($e)?" Email: ".$e." ;":'' ;
		$qr_format .= ($mp)?" Mobile no: ".$mp." ;":'' ;

		if($patient_details['case_summery_link'] != ''){
			$qr_format .= "; Case Summary Link: ".$patient_details['case_summery_link']." ;" ;
		}
		if($patient_details['patient_file'] != ''){
			$qr_format .= "; Patient File: ".$patient_details['patient_file']." ;" ;
		}

		$qr_format .= ($relativeName)?" Relative's Name: ".$relativeName." ;":'' ;
		$qr_format .= ($mobileno)?" Relative's Phone: ".$mobileno." ;":'' ;
		$qr_format .= ($docName)?" Family Physician : ".$docName." ;":'' ;
		$qr_format .= ($doctorPhone)?" Family Physician Phone: ".$doctorPhone." ;":'' ;


		//corporate name
		$this->loadModel('Corporate');
		$this->loadModel('InsuranceCompany');
		if($patient_details['credit_type_id'] == 1){
			$corporateEmp = $this->Corporate->getCorporateByID($patient_details['corporate_id']);
		}else if($patient_details['credit_type_id'] == 2){
			$corporateEmp = $this->InsuranceCompany->getInsuranceCompanyByID($patient_details['insurance_company_id']);
		}else{
			$corporateEmp ='Private';
		}
		$qr_format .= ($corporateEmp)?" Category: ".$corporateEmp." ;":'' ;
		//corporate name

		$qr_format .= ($alle)?" Allergies: ".$alle." ;":'' ;
		$instructions = array('Diabetic'=>'Diabetic- If found Unconscious give sugar/sweet/chocolate.','Epileptic'=>'Epileptic- In case of attack/fit turn patient to one side & refrain from feeding.','High Blood Pressure'=>'High Blood Pressure- If found unconscious or paralyzed, turn patient to one side & refrain from feeding.','Low Blood Pressure'=>'Low Blood Pressure- In case of vertigo keep head in low position & take plenty of fluids.','Cardiac Problem'=>'Cardiac Problem- In case of symtoms like chest pain or sweating administer Tablet Disprin & sublingual Tablet Sorbitrate.','Asthma'=>'Asthma- In case of acute attack administer 2 puffs of Scroflo inhaler & shift to hospital.');
		if(!empty($patient_details['instruction']))
			$qr_format .= " Instruction: ".$instructions[$patient_details['instruction']]." ;" ;

		$qr_format .=  "Address ".str_replace("<br/>","",$formatted_address) ; //temp comment
			
		return $qr_format ;
	}

	//converting dates to db format in post data of patient add form
	function convertingDatetoSTD($data=array()){
			
		if(!empty($data['review_on'])){
			$last_split_date_time =  $data['review_on'];
			$this->request->data["Patient"]['review_on'] = $this->DateFormat->formatDate2STD($last_split_date_time,Configure::read('date_format'));
		}
		if(!empty($data['doc_ini_assess_on'])){
			$last_split_date_time =  $data['doc_ini_assess_on'];
			$this->request->data["Patient"]['doc_ini_assess_on'] = $this->DateFormat->formatDate2STD($last_split_date_time,Configure::read('date_format'));
		}
		if(!empty($data['nurse_assess_on'])){
			$last_split_date_time =  $data['nurse_assess_on'];
			$this->request->data["Patient"]['nurse_assess_on'] = $this->DateFormat->formatDate2STD($last_split_date_time,Configure::read('date_format'));
		}
		if(!empty($data['nutritional_assess_on'])){
			$last_split_date_time =  $data['nutritional_assess_on'];
			$this->request->data["Patient"]['nutritional_assess_on'] = $this->DateFormat->formatDate2STD($last_split_date_time,Configure::read('date_format'));
		}
		if(!empty($data['discharge_intimation_on'])){
			$last_split_date_time =  $data['discharge_intimation_on'];
			$this->request->data["Patient"]['discharge_intimation_on'] = $this->DateFormat->formatDate2STD($last_split_date_time,Configure::read('date_format'));
		}
		if(!empty($data['final_intimation_on'])){
			$last_split_date_time =  $data['final_intimation_on'];
			$this->request->data["Patient"]['final_intimation_on'] = $this->DateFormat->formatDate2STD($last_split_date_time,Configure::read('date_format'));
		}
	}

	function convertingDatetoLocal($data =array()){
		if(!empty($data['review_on'])){
			$data['review_on'] = $this->DateFormat->formatDate2Local($data['review_on'],Configure::read('date_format'),true);
		}
		if(!empty($data['doc_ini_assess_on'])){
			$data['doc_ini_assess_on'] = $this->DateFormat->formatDate2Local($data['doc_ini_assess_on'],Configure::read('date_format'),true);
		}
		if(!empty($data['nurse_assess_on'])){
			$data['nurse_assess_on'] = $this->DateFormat->formatDate2Local($data['nurse_assess_on'],Configure::read('date_format'),true);
		}
		if(!empty($data['nutritional_assess_on'])){
			$data['nutritional_assess_on'] = $this->DateFormat->formatDate2Local($data['nutritional_assess_on'],Configure::read('date_format'),true);
		}
		if(!empty($data['discharge_intimation_on'])){
			$data['discharge_intimation_on'] = $this->DateFormat->formatDate2Local($data['discharge_intimation_on'],Configure::read('date_format'),true);
		}
		if(!empty($data['final_intimation_on'])){
			$data['final_intimation_on'] = $this->DateFormat->formatDate2Local($data['final_intimation_on'],Configure::read('date_format'),true);
		}
		if(!empty($data['discharge_date'])){
			$data['discharge_date'] = $this->DateFormat->formatDate2Local($data['discharge_date'],Configure::read('date_format'));
		}

		$finalArr['Patient'] = $data ;
		return $finalArr  ;
	}

	//function to return formatted the complete address
	/* @params : array of patient details
	 *
	* */
	function setAddressFormat($patient_details=array(),$country=array(),$state=array()){
		$format = '';

		if(!empty($patient_details['plot_no']))
			$format .= $patient_details['plot_no']."";
		if(!empty($patient_details['plot_no']))
			$format .= ',';
		if(!empty($patient_details['landmark']))
			$format .= ucwords($patient_details['landmark'])." ";

		if(!empty($patient_details['plot_no']) || !empty($patient_details['landmark']))
			$format .= "<br/>" ;

		if(!empty($patient_details['city']))
			$format .= ucfirst($patient_details['city']);
		if(!empty($patient_details['city']))
			$format .= ',';
		if(!empty($patient_details['taluka']))
			$format .= ucfirst($patient_details['taluka']);

		if((!empty($patient_details['city']) && !empty($patient_details['taluka'])) && (!empty($patient_details['district']) || !empty($patient_details['state'])))
			$format .= ",<br/>" ;

		if(!empty($patient_details['district']))
			$format .= ucfirst($patient_details['district']);

		if(!empty($patient_details['district']) && !empty($patient_details['state']))
			$format .= "," ;

		if(!empty($state['name']))
			$format .= ' '.$state['name'];

		if(!empty($patient_details['state']) && !empty($patient_details['pin_code']))
			$format .= "-" ;
		else
			$format .= "<br/>" ;

		if(!empty($patient_details['pin_code']))
			$format .= $patient_details['pin_code'];

		if(!empty($country['name']))
			$format .= ', '.$country['name'];

		//pr($format);exit;
		return $format ;
	}
	function qrcode(){
		//$this->layout = false ;
		//App::import("Vendor","qrcode/qrlib.php");
		//App::import('Vendor', 'qrcode', array('file' => 'qrcode/qrlib.php'));
		// QRcode::png('Pawan Meshram', 'uploads/qrcodes/test.png', 'L', 4, 2);
	}

	function getCorporateLocationList() {
		$this->loadModel('CorporateLocation');
		$this->loadModel('InsuranceType');
		if($this->params['isAjax']) {
			$paycatid = $this->params->query['paymentCategoryId'];
			if($paycatid == "2") {
				$this->set('insurancetypelist', $this->InsuranceType->find('all', array('fields'=> array('id', 'name'),'conditions' => array('InsuranceType.is_deleted' => 0, 'InsuranceType.credit_type_id' => $paycatid),'order' => array('TRIM(InsuranceType.name)'))));
				$this->render('ajaxgetinsurancetypes');
			}else if($paycatid == "1") {
				$this->set('corporatelocationlist', $this->CorporateLocation->find('all', array('fields'=> array('id', 'name'),'conditions' => array('CorporateLocation.is_deleted' => 0, 'CorporateLocation.credit_type_id' => $paycatid,
						'CorporateLocation.location_id'=>$this->Session->read('locationid')),'order' => array('TRIM(CorporateLocation.name)'))));
				$this->render('ajaxgetcorporatelocations');
			}

			$this->layout = 'ajax';
		}
	}

	/**
	 * get insurance type by xmlhttprequest
	 *
	 */
	function getInsuranceTypeList() {
		$this->loadModel('InsuranceType');
		if($this->params['isAjax']) {
			$this->set('insurancetypelist', $this->InsuranceType->find('all', array('fields'=> array('id', 'name'),'conditions' => array('InsuranceType.is_deleted' => 0,'InsuranceType.credit_type_id' => $this->params->query['paymentCategoryId']),'order' => array('TRIM(InsuranceType.name)'))));
			$this->layout = 'ajax';
			$this->render('ajaxgetinsurancetypes');
		}
	}


	/**
	 * get insurance company by xmlhttprequest
	 *
	 */
	function getInsuranceCompanyList() {
		$this->loadModel('InsuranceCompany');
		if($this->params['isAjax']) {
			$this->set('insurancecompanylist', $this->InsuranceCompany->find('all', array('fields'=> array('id', 'name'),'conditions' => array('InsuranceCompany.is_deleted' => 0,
					'InsuranceCompany.insurance_type_id' => $this->params->query['insurancetypeid'],'InsuranceCompany.location_id'=>$this->Session->read('locationid')),'order' => array('TRIM(InsuranceCompany.name)'))));
			$this->layout = 'ajax';
			$this->render('ajaxgetinsurancecompanies');
		}
	}

	/**
	 * get corporate by xmlhttprequest
	 *
	 */
	function getCorporateList() {
		$this->loadModel('Corporate');
		if($this->params['isAjax']) {
			$this->set('corporatelist', $this->Corporate->find('all', array('fields'=> array('id', 'name'),
					'conditions' => array('Corporate.is_deleted' => 0,'Corporate.location_id'=>$this->Session->read('locationid'),'Corporate.corporate_location_id' => $this->params->query['ajaxcorporatelocationid']), 'order' => array('TRIM(Corporate.name)'))));
			$this->layout = 'ajax';
			$this->render('ajaxgetcorporate');
		}
	}

	/**
	 * get corporate by xmlhttprequest
	 *
	 */
	function getCorporateSublocList() {
		$this->loadModel('CorporateSublocation');
		if($this->params['isAjax']) {
			$this->set('corporatesulloclist', $this->CorporateSublocation->find('all', array('fields'=> array('id', 'name'),
					'conditions' => array('CorporateSublocation.is_deleted' => 0,'CorporateSublocation.corporate_id' => $this->params->query['ajaxcorporateid']),'order' => array('TRIM(CorporateSublocation.name)'))));
			$this->layout = 'ajax';
			$this->render('ajaxgetcorporatesubloc');
		}
	}

	/**
	 * get payment type by xmlhttprequest
	 *
	 */
	function getPaymentType() {
		$this->loadModel('CorporateLocation');
		$this->loadModel('InsuranceType');
		$this->loadModel('InsuranceCompany');
		if($this->params['isAjax']) {
			$paytype = $this->params->query['paymentType'];
			$paytypeAry = Configure :: read('SponsorValue');

			if($paytype == "Insurance company") {
				$this->set('insurancecompanylist', $this->InsuranceCompany->find('all', array('fields'=> array('id', 'name'),'conditions' => array('InsuranceCompany.is_deleted' => 0,
						'InsuranceCompany.insurance_type_id' => $paytypeAry[$paytype],'InsuranceCompany.location_id'=>$this->Session->read('locationid')),'order' => array('TRIM(InsuranceCompany.name)'))));
				$this->render('ajaxgetinsurancecompanies');
			}
			else if($paytype == "Corporate") {
				//	debug($paytypeAry[$paytype]);
				$this->set('corporatelocationlist', $this->CorporateLocation->find('all', array('fields'=> array('id', 'name'),'conditions' => array('CorporateLocation.is_deleted' => 0, 'CorporateLocation.credit_type_id' => $paytypeAry[$paytype],
						'CorporateLocation.location_id'=>$this->Session->read('locationid')),'order' => array('TRIM(CorporateLocation.name)'))));
				$this->render('ajaxgetcorporatelocations');
			}
			else if($paytype == "TPA") {
				$this->set('insurancecompanylist', $this->InsuranceCompany->find('all', array('fields'=> array('id', 'name'),'conditions' => array('InsuranceCompany.is_deleted' => 0,
						'InsuranceCompany.insurance_type_id' => $paytypeAry[$paytype],'InsuranceCompany.location_id'=>$this->Session->read('locationid')),'order' => array('TRIM(InsuranceCompany.name)'))));
				$this->render('ajaxgetinsurancecompanies');
			}
			else{
				$this->render('/Persons/ajaxgetcashtype');
			}
			$this->layout = 'ajax';
		}

	}

	function getDoctorsList() {
		$this->uses = array('Consultant', 'DoctorProfile','Person');
		
			$doctorlist=array();
			$mergeArray=array();
			if($this->params->query['familyknowndoctor'] == Configure :: read('referralforregistrar')) {
				$doctorlist=$this->DoctorProfile->getRegistrar();				
				$mergeArray = array('None'=>'None')+$doctorlist;
				$this->set('doctorlist',$mergeArray);
				$this->layout = 'ajax';
				$this->render('/Persons/ajaxgetregistrar');
			} elseif(!empty($this->params->query['familyknowndoctor'])) {
				if($this->params->query['familyknowndoctor']==7){
					$CampDate= $this->Consultant->find('list', array('fields'=> array('id', 'camp_date'),'conditions' => array('Consultant.is_deleted' => 0, 'Consultant.refferer_doctor_id' => $this->params->query['familyknowndoctor'], 'Consultant.location_id' => $this->Session->read('locationid')),'order'=>array('Consultant.id')));				
					foreach($CampDate as $key => $val){
						$doctorlist[$key] = $this->DateFormat->formatDate2Local($val,Configure::read('date_format'),false);
					}
				}else{
					$doctorlist= $this->Consultant->find('list', array('fields'=> array('id', 'full_name'),'conditions' => array('Consultant.is_deleted' => 0, 'Consultant.refferer_doctor_id' => $this->params->query['familyknowndoctor'], 'Consultant.location_id' => $this->Session->read('locationid')),'order'=>array('Consultant.full_name')));
				}
				$mergeArray = array('None'=>'None')+$doctorlist;
				$this->set('doctorlist',$mergeArray);				
				$this->layout = 'ajax';
				$this->render('/Persons/ajaxgetdoctors');
			} else {
				// this is for blank ctp //
				$this->layout = 'ajax';
				$this->render('/Persons/ajaxgetcashtype');
			}
	// }
	}
	//BOF pankaj
	//function to capture image from web camera
	function webcam(){
		$this->layout ='ajax';
			
		/*if(isset($_POST['image'])){

		if ($_POST['type'] == "pixel") {
		// input is in format 1,2,3...|1,2,3...|...
		$im = imagecreatetruecolor(100, 100);

		foreach (explode("|", $_POST['image']) as $y => $csv) {
		foreach (explode(";", $csv) as $x => $color) {
		imagesetpixel($im, $x, $y, $color);
		}
		}
		} else {
		// input is in format: data:image/png;base64,...
		$im = imagecreatefrompng($_POST['image']);
		}
		// Copy
		if($im){

		//save image resource in session
		$this->Session->write('image_src',$_POST['image']);
		echo $this->Session->read('image_src');
			
		//$res= imagejpeg($im,WWW_ROOT.'/uploads/upload.jpg');
		}
		}
		echo $this->Session->read('image_src');*/
			
	}
	function webcam_insurance_card(){
		$this->layout ='ajax';

			
	}

	function webcam_test(){
		if(isset($_POST['image'])){

			if ($_POST['type'] == "pixel") {
				// input is in format 1,2,3...|1,2,3...|...
				$im = imagecreatetruecolor(100, 100);

				foreach (explode("|", $_POST['image']) as $y => $csv) {
					foreach (explode(";", $csv) as $x => $color) {
						imagesetpixel($im, $x, $y, $color);
					}
				}
			} else {
				// input is in format: data:image/png;base64,...
				$im = imagecreatefrompng($_POST['image']);
			}
			// Copy
			if($im){
				$res= imagejpeg($im,WWW_ROOT.'/uploads/upload.jpg');
			}
		}

			
	}

	function tt(){
			
		$filename = date('YmdHis') . '.jpg';
		echo "panakjh";
		$result = file_put_contents( WWW_ROOT.'/uploads/'.$filename, file_get_contents('php://input') );
		if (!$result) {
			print "ERROR: Failed to write data to $filename, check permissions\n";
			exit();
		}

		$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/' . $filename;
		print "$url\n";
			
	}

	function uid_autocomplete(){
		$location_id = $this->Session->read('locationid');
		$this->layout = "ajax";
		$patientArray = $this->Person->find('all', array('fields'=> array('id,CONCAT(Person.first_name," ",Person.last_name) as name'),
				'conditions'=>array('is_deleted'=>0,'location_id'=>$location_id,
						'first_name like "'.$this->params->query['q'].'%" || last_name like "'.$this->params->query['q'].'%"')));
			
		foreach ($patientArray as $key=>$value) {

			echo $value[0]['name']."|".$value['Person']['id']."\n";

		}
		exit;//dont remove this
	}
	//swa
	function getMotherData($id){

		$this->Person->bindModel(array(
				'belongsTo' => array(
						'Initial' =>array('foreignKey'=>'initial_id'),
						'Country' =>array('foreignKey'=>'country'),
						'State' =>array('foreignKey'=>'state'))),false);
		
		
		$personData = $this->Person->find('first',array('fields'=>array('plot_no','landmark','pin_code','zip_four','district','taluka','country','email','state','city','mobile','middle_name','relative_name'),
				
				'conditions'=>array('Person.id'=>$id)));
		echo json_encode($personData);
		exit;
		
	}

	function getSmartPhrase(){
		$this->layout = "ajax";
		$this->uses = array('SmartPhrase');
		if(is_array($this->params->query['q'])){
			$this->params->query['q'] = $this->params->query['q'][0];
		}
		$smartPhrases = $this->SmartPhrase->find('all', array('fields'=> array('phrase','phrase_text'),
				'conditions'=>array('phrase like "'.$this->params->query['q'].'%"')));

		foreach ($smartPhrases as $key=>$smartPhrase) {
			$smartPhrase['SmartPhrase']['phrase_text'] = $bodytag = str_replace("\n", "~~~~~", $smartPhrase['SmartPhrase']['phrase_text']);
			echo $smartPhrase['SmartPhrase']['phrase']."|".$smartPhrase['SmartPhrase']['phrase_text']."\n";

		}
		exit;//dont remove this
	}
	//EOF pankaj

	/** @For merging to common records in Person table
	 * @author	Gaurav Chauriya
	 *
	 */
	function mergeEmpiList(){
		$this->set('data','');
			
		$role = $this->Session->read('role');
		$search_key['Person.is_deleted'] = 0;
		$search_key['Person.location_id'] = $this->Session->read('locationid');
		$this->Person->virtualFields = array(
				'full_name' => 'CONCAT(Initial.name, " ", Person.first_name, ",", Person.last_name)'
		);
		$this->Person->bindModel(array(
				'belongsTo' => array(
						'Initial' =>array('foreignKey' => false,'conditions'=>array('Initial.id=Person.initial_id')),

				)),false);
		if($role != 'admin'){
			$search_key['Person.location_id']=$this->Session->read('locationid');

		}
			
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order'=>array('Person.create_time' => 'DESC'),
				'group'=>array('Person.id'),
		);
		if(!empty($this->request->query)){
			$search_ele = $this->request->query;

			if(!empty($search_ele['first_name'])){
				//sliptup complete name

				$splittedName = explode(" ",$search_ele['first_name']);
				$first_name = $splittedName[0];
				$last_name = $splittedName[count($splittedName)];
				$search_key['Person.first_name like '] = $first_name."%" ;
				if(!empty($last_name)){
					$search_key['Person.last_name like '] = $last_name."%" ;
				}
			}if(!empty($search_ele['patient_uid'])){
				$search_key['Person.patient_uid like '] = "%".$search_ele['patient_uid'] ;
			}if(!empty($search_ele['non_executive_emp_id_no'])){
				$search_key['Person.non_executive_emp_id_no like '] = "%".$search_ele['non_executive_emp_id_no'] ;
			}
			$data = $this->paginate('Person',$search_key);
			$this->set('data', $data);
			$this->data = array('Person'=>$this->params->query);

		}else{
			$data = $this->paginate('Person',array($search_key));
			$this->set('data', $data);
		}


	}
	function mergeEmpi($data=null){
		$this->uses = array('Person','Patient');
		$this->layout = false;
		$this->set('data',$data);
		$personId = explode(',',$data);
		$this->Person->bindModel(array(
				'hasMany' => array(
						'Patient' =>array('foreignKey' => 'person_id','fields'=>array('id','patient_id')),
				)),false);
		$this->Person->bindModel(array(
				'belongsTo' => array(
						'Initial' =>array('foreignKey' => false,'conditions'=>array('Initial.id=Person.initial_id')),
				)),false);
		$personRecord = $this->Person->find('all',array('fields'=>array('Person.id','initial_id','first_name','middle_name','last_name','name_type','suffix1',
				'dob','sex','maritail_status','blood_group','allergies','known_fam_physician','registrar_id','ssn_us',
				'mrn_number','birth_order','multiple_birth_indicator','professional_suffix','ethnicity','alt_ethinicity','language',
				'race','alt_race','P_comm','religion','plot_no','landmark','pin_code','zip_four','fax','country','state','city','patient_portal',
				'nationality','person_address_type_first','person_parish_code_first','consultant_id','Initial.name')//,'status')
				,'conditions'=>array('Person.id'=>$personId)));
		$this->set('personRecord',$personRecord);
		foreach($personRecord as $personArray){
			foreach($personArray['Patient'] as $patientArray){
				$patientId[] = $patientArray['id'];
				$patientUniqueId[] = $patientArray['patient_id'];
			}
		}

		if(!empty($this->request->data['Person'])){

			foreach($this->request->data['Person'] as $key=>$personData){
				$reqArray[$key] = ($personData=='#') ? '' :$personData;
			}
			$this->request->data['Person'] = $reqArray;
			for($i=0;$i<count($personId);$i++){
				$this->Person->updateAll(array('is_deleted'=>'1'),array('Person.id'=>$personId[$i]));
			}
			$lastId=$this->Person->insertPerson($this->request->data,'insert');
			$patient_id   = $this->autoGeneratedPatientID($lastId,$this->request->data);
			$mergeSource = implode('|',$personId);
			$this->Person->updateAll(array('patient_uid'=>"'$patient_id'",'merge_source'=>"'$mergeSource'",'is_deleted'=>'0'),array('Person.id'=>$lastId));
			for($i=0;$i<count($patientId);$i++){
				$this->Patient->updateAll(array('person_id'=>$lastId,'patient_id'=>"'$patient_id'"),array('Patient.id'=>$patientId[$i]));
			}
			$first_name = $this->request->data['Person']['first_name'];
			$last_name = $this->request->data['Person']['last_name'];
			unset($this->request->data);
			$this->data = $facny=true;
			$this->set('message',"Merge sucessful with EMPI ".$patient_id." for patient named ".$first_name.",".$last_name);
		}


	}


	/**
	 * Called By Ajax Request
	 */
	function smartMerge($data= null){
		$this->uses = array('Person','Patient');

		$person = explode(',',$data);
		$this->Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$personRecord = $this->Patient->find('all',array('fields'=>array('id','patient_id','person_id'),'conditions'=>array('Patient.person_id'=>$person)));

		foreach($personRecord as $personArray){
			$patientId[] = $personArray['Patient']['id'];
			$patientUniqueId[] = $personArray['Patient']['patient_id'];
			$personId[] = $personArray['Patient']['person_id'];
			//$this->Person->updateAll(array('is_deleted'=>'1'),array('id'=>$personArray['Patient']['person_id']));
		}
		$this->Person->updateAll(array('is_deleted'=>'1'),array('Person.id'=>$person));
		$personData = $this->Person->read(null,max($personId));
		unset($this->Person->data) ;
		unset($personData['Person']['id'],$personData['Person']['patient_uid'],$personData['Person']['create_time'],$personData['Person']['created_by'],
				$personData['Person']['modified_by'],$personData['Person']['modify_time']);
		$personData['Person']['is_deleted'] = '0';
		$lastId=$this->Person->insertPerson($personData,'insert');
		$patient_id   = $this->autoGeneratedPatientID($lastId,$personData);
		$mergeSource = implode('|',$person);
		$this->Person->updateAll(array('patient_uid'=>"'$patient_id'",'merge_source'=>"'$mergeSource'"),array('Person.id'=>$lastId));
		for($i=0;$i<count($patientId);$i++){
			$this->Patient->updateAll(array('person_id'=>$lastId['lastinsid'],'patient_id'=>"'$patient_id'"),array('Patient.id'=>$patientId[$i]));
		}
		$this->Session->setFlash(__("Merge Sucessful With EMPI ".$patient_id." for patient named ".$personData['Person']['first_name'].",".$personData['Person']['last_name'], true));
		exit;
	}

	function unMergePerson(){

		$personId= array_values($this->request->data['Person']);
		$mergedPerson = $this->Person->find('all',array('fields'=>array('merge_source'),'conditions'=>array('Person.id'=>$personId)));
		for($i=0;$i<=count($mergedPerson);$i++){
			$allRecord .= "|".$mergedPerson[$i]['Person']['merge_source']."|";
		}
		$findRecord= array_values(array_unique(array_filter(explode('|',$allRecord))));
		$this->Person->updateAll(array('is_deleted'=>'0'),array('Person.id'=>$findRecord));
		$this->Person->updateAll(array('merge_source'=>null,'is_deleted'=>'1'),array('Person.id'=>$personId));
		exit;
	}

	/////------BOF pt. quick registration------//
	function quickPatientRagistration($person_id=null){
		$this->layout = 'advance_ajax' ;
		$this->uses = array('Configuration','Department','Person','Patient','NewCropPrescription','Note','Appointment','User');
		if(!empty($this->params->query['flag'])){
			$this->set('flag',$this->params->query['flag']);
		}
		if(!empty($this->params->query['sign'])){
			$this->set('sign',$this->params->query['sign']);
		}
		if(!empty($this->params->query['patientID'])){
			$this->set('patientID',$this->params->query['patientID']);
		}
		if(!empty($this->params->query['signBy'])){
			$userSign=$this->User->find('first',array('fields'=>array('User.username','User.first_name','User.last_name'),'conditions'=>array('User.id'=>$this->params->query['signBy'])));
			$this->set('userSign',$userSign);
		}
		if($this->request->data){
			$this->request->data['Patient']['form_received_on']=$this->DateFormat->formatDate2STD($this->request->data['Patient']['form_received_on'],Configure::read('date_format'));
			$this->request->data['Patient']['create_time'] = date('Y-m-d H:i:s') ;
			$this->request->data['Patient']['created_by'] = $this->Session->read('userid');
			$this->request->data['Patient']['is_discharge']= 0 ;
			$this->request->data['Patient']['is_discharge']= 0 ;
			if($this->request->data['Patient']['age'] == null){
				$this->request->data['Patient']['age'] = 0 ;
			}

			$this->Patient->save($this->request->data['Patient']);
			$errors = $this->Patient->invalidFields();
			$latest_id = $this->Patient->getInsertId();

			$admission_id = $this->Patient->autoGeneratedAdmissionID($latest_id,$this->request->data);
			$this->Patient->updateAll(array('Patient.admission_id' => "'$admission_id'"),array('Patient.id'=>$latest_id));
			$this->request->data['Patient']['patient_id']= $latest_id ; //For appointment
			$this->Appointment->setCurrentAppointment($this->request->data);
			$this->NewCropPrescription->insertDrugFromQuickReg($this->request->data,$latest_id); //insert treatment adviced in newCropPrescrition

			$patientVal=$this->Patient->find('first',array('fields'=>array('Patient.*'),'conditions'=>array('Patient.id'=>$latest_id)));
			$userVal=$this->User->find('first',array('fields'=>array('User.username','CONCAT(User.first_name," ",User.last_name) as lookup_name'),'conditions'=>array('User.id'=>$this->request->data['Patient']['doctor_id'])));

			$mailData['Patient']=array("patient_id"=>$userVal["User"]["username"],"lookup_name"=>$userVal['0']['lookup_name']);

			//$msgs="Please click on below quick note link of ".$patientVal["Patient"]["lookup_name"]."<br/><br/>";
			$msgs="";
			$msgs.="<a href=".Router::url('/')."Persons/quickPatientRagistration/".$patientVal["Patient"]['person_id']."?patientID=".$patientVal["Patient"]['id']."&sign=toSign&from=".$this->Session->read('userid')." >Click here to view quick note for ".$patientVal["Patient"]["lookup_name"]."</a><br/><br/>";
			$subject="Quick note created for ".$patientVal["Patient"]["lookup_name"];

			$this->Note->sendMail($mailData,$msgs,$subject);

			if($this->Session->read('role')=='Medical Assistant' || $this->Session->read('role')=='Nurse'){
				$this->Session->setFlash(__('Note sent to physician by mail for signing.', true));
			}
			//$this->Session->setFlash(__('Record added Successfully', true));
			$this->redirect(array("controller" => "appointments", "action" => "appointments_management"));
		}else{

			$this->set('departments',$this->Department->find('list',array('fields'=>array('id','name'))));
			$this->Person->bindModel(array(
					'belongsTo' => array(
							'Patient'=>array('foreignKey'=>false,'conditions'=>array('Person.id=Patient.person_id')),
							'DoctorProfile'=>array('foreignKey'=>false,'conditions'=>array('DoctorProfile.user_id=Patient.doctor_id')),
					)
			),false);
			$pesonData=$this->Person->find('first',array('fields'=>array('Person.id','Person.location_id','Person.first_name','Person.middle_name',
					'Person.last_name','Person.age','Person.sex','Person.patient_uid','Patient.id','Patient.mode_communication','Patient.doctor_id',
					'DoctorProfile.doctor_name'),
					'conditions'=>array('Person.id'=>$person_id)));
			$this->data = $pesonData;
			$this->set('pesonData',$pesonData);

			$drugRec=$this->NewCropPrescription->find('all',array('fields'=>array('NewCropPrescription.*'),
					'conditions'=>array('NewCropPrescription.patient_id'=>$person_id,'NewCropPrescription.patient_uniqueid'=>$this->params->query['patientID'],'NewCropPrescription.archive'=>'N')));
			$this->set('currentresult',$drugRec);

			$patientVal=$this->Patient->find('first',array('fields'=>array('Patient.mode_communication','Patient.advice','Patient.other_mode_communication','Patient.doctor_id'),'conditions'=>array('Patient.id'=>$this->params->query['patientID'])));
			$this->set('adviceRec',$patientVal['Patient']);

			$getuser=$this->User->find('first',array('fields'=>array('User.username','User.first_name','User.last_name','User.id'),'conditions'=>array('User.id'=>$patientVal['Patient']['doctor_id'])));
			$this->set('getuser',$getuser['User']);

			//--- New Medication Unit DOSE AND STRENGHT ADD DO NOT REMOVE Aditya
			$getConfiguration=$this->Configuration->find('all');
			$strenght=unserialize($getConfiguration[0]['Configuration']['value']);
			$route=Configure::read('route_administration');
			$dose=Configure::read('dose_type');
			//$str1='<select style="width:80px;" id="dose_type'+counter+'" class="" name="dose_type[]">';

			//----strenght
			foreach($strenght as $strenghts){
				$str.='<option value='.'"'.stripslashes($strenghts).'"'.'>'.$strenghts.'</option>';
			}
			$str.='</select>';
			$this->set('str',$str);
			foreach(unserialize($getConfiguration[0]['Configuration']['value']) as $key=>$strenght){
				if(!empty($strenght))
					$strenght_var[$strenght]=$strenght;
			}
			$this->set('strenght',$strenght_var);
			//--eof strenght
			//-----rout
			foreach($route as $key => $routes){
				$str_route.='<option value='.'"'.stripslashes($key).'"'.'>'.$routes.'</option>';
			}
			$str_route.='</select>';
			$this->set('str_route',$str_route);

			/* foreach(unserialize($getConfiguration[2]['Configuration']['value']) as $key=>$route){
			 if(!empty($route))
				$route_var[$route]=$route;
			} */
			$this->set('route',$route);
			//-------eof rout
			//================================ dose
			foreach($dose as $keyDose =>$doses){
				$str_dose.='<option value='.'"'.stripslashes($keyDose).'"'.'>'.$doses.'</option>';
			}
			$str_dose.='</select>';
			$this->set('str_dose',$str_dose);
			// =======================================end dose
		}
	}///-------EOF pt. quick reg.--------///

	function signNote(){
		$this->autoRender = false ;
		$this->uses=array('Note','User','Patient');
		$date= date("Y-m-d H:i:s");
		//debug($date);exit;
		//$date=$this->DateFormat->formatDate2STD($date,Configure::read('date_format'));
		$updateArray = array('Note.cosign_physician'=>'1',
				'Note.cosign_physician_user_id'=>"'".$this->params->query['doctorID']."'",
				'Note.cosign_datetime'=>"'".$date."'",
				'Note.modified_by'=>"'".$this->params->query['doctorID']."'",
				'Note.modify_time'=>"'".$date."'") ;
		$this->Note->updateAll($updateArray,array('Note.patient_id'=>$this->params->query['patientID']));

		$patientData=$this->Patient->find('first',array('fields'=>array('Patient.person_id','Patient.lookup_name'),'conditions'=>array('Patient.id'=>$this->params->query['patientID'])));
		$userData=$this->User->find('first',array('fields'=>array('User.username','CONCAT(User.first_name," ",User.last_name) as lookup_name'),'conditions'=>array('User.id'=>$this->params->query['from'])));

		$mailData['Patient']=array("patient_id"=>$userData["User"]["username"],"lookup_name"=>$userData['0']['lookup_name']);
		//$msgs="Please click on below quick note link of ".$patientData["Patient"]["lookup_name"]."<br/><br/>";
		$msgs="";
		$msgs.="<a href=".Router::url('/')."Persons/quickPatientRagistration/".$patientData["Patient"]['person_id']."?patientID=".$this->params->query['patientID']."&signDone=yes&signBy=".$this->params->query['doctorID']." >Click here to view quick note for ".$patientData["Patient"]["lookup_name"]."</a><br/><br/>";
		$subject="Quick note signed for ".$patientData["Patient"]["lookup_name"];
			
		$this->Note->sendMail($mailData,$msgs,$subject);

		if($this->Session->read('role')=='Primary Care Provider'){
			$this->Session->setFlash(__('Signed note sent back to MA by mail.', true));
		}
		$this->redirect(array("controller" => "appointments", "action" => "appointments_management"));
	}

	/* for biometric identification */
	Public function finger_print(){
		$someData = $this->Person->find('first', array('fields'=>array('Person.patient_uid','Person.full_name'),'conditions' => array('Person.id' => $this->request->params['pass'][0])));

		//debug($someData);exit;
		$this->set('someData', $someData);


	}

	Public function getStateCity($pinCode){
		$this->layout = 'ajax';
		$this->uses=array('PinCode','State','City');
		if(empty($this->Session->read('db_name'))){
			App::import('Vendor', 'DrmhopeDB');
			$db_connection = new DrmhopeDB('db_hope');
			$db_connection->makeConnection($this->PinCode);
			$db_connection->makeConnection($this->State);
			$db_connection->makeConnection($this->City);
		}	
		$this->PinCode->bindModel(array(
				'belongsTo' => array(
						'State'=>array('foreignKey'=>false,'conditions'=>array('State.name=PinCode.state_name'),
						)),false));

		$zipData = $this->PinCode->find("first",array("fields"=>array("id","city_name","state_name","State.id",'State.name'),
				'conditions'=>array('pincode'=>$pinCode)));
		echo json_encode(array('zip'=>$zipData));
			
		exit;

	}

	Public function getTariffAmount($tariffListId,$doctor_id=NULL,$tariffStandardId=NULL){
		$this->layout = 'ajax';
		$this->uses=array('DoctorProfile','TariffStandard','TariffList','TariffCharge');
		if(!empty($tariffListId)){
			$this->TariffCharge->bindModel(array(
					'belongsTo' => array(
							'TariffStandard'=>array('foreignKey'=>false,'conditions'=>array('TariffStandard.id=TariffCharge.tariff_standard_id')),
							'User'=>array('foreignKey'=>false,'conditions'=>array('User.id=TariffCharge.doctor_id')),
							'TariffList'=>array('foreignKey'=>false,'conditions'=>array('TariffList.id=TariffCharge.tariff_list_id')),
					),false));
			$conditions['TariffCharge.tariff_list_id']=$tariffListId;
			if(!empty($doctor_id)){
				$conditions['TariffCharge.doctor_id']=$doctor_id;
				$conditions['TariffCharge.start <=']=date('H').':00:00';
				$conditions['TariffCharge.end >=']=date('H').':00:00';
				$conditions['TariffCharge.'.strtolower(date('l'))]='1';
			}
			if(!empty($tariffStandardId))
				$conditions['TariffCharge.tariff_standard_id']=$tariffStandardId;

			$chargeData = $this->TariffCharge->find('first',array('fields'=>array('TariffCharge.id','User.location_id',
					'TariffCharge.nabh_charges','TariffCharge.non_nabh_charges'),
					'conditions'=>array($conditions)));
			if(!empty($chargeData)){
				echo json_encode(array('charges'=>$chargeData));
			}else{
				$conditions='';
				$this->loadModel('TariffAmount');
				$this->TariffAmount->bindModel(array(
						'belongsTo' => array(
								'TariffStandard'=>array('foreignKey'=>false,'conditions'=>array('TariffStandard.id=TariffAmount.tariff_standard_id')),
								'TariffList'=>array('foreignKey'=>false,'conditions'=>array('TariffList.id=TariffAmount.tariff_list_id')),
						),false));
				$conditions['TariffAmount.tariff_list_id']=$tariffListId;
				if(!empty($tariffStandardId))
					$conditions['TariffAmount.tariff_standard_id']=$tariffStandardId;

				$chargeData = $this->TariffAmount->find('first',array('fields'=>array('TariffAmount.id',
						'TariffAmount.nabh_charges','TariffAmount.non_nabh_charges'),
						'conditions'=>array($conditions)));
				echo json_encode(array('charges'=>$chargeData));
			}
		}
		exit;
	}

	/**
	 * function to calculate Y m D form date
	 */
	public function getAgeFromDob(){
		$dob = $this->DateFormat->formatDate2STD($this->params->query['dob'],Configure::read('date_format'));
		$date1 = new DateTime($dob);
		$date2 = new DateTime();
		$interval = $date1->diff($date2);
		echo  json_encode(array($interval->y,$interval->m,$interval->d));
		exit;
	}

	/**
	 * function to calculate Date form Y m d
	 */
	public function getDobFromAge(){
		$year = ($this->params->query['years']) ? $this->params->query['years'] : 0;
		$month = ($this->params->query['months']) ? $this->params->query['months'] : 0;
		$day = ($this->params->query['days']) ? $this->params->query['days'] : 0;
		$dob = strtotime(date('Y-m-d')." -$year years -$month months -$day days");
		$date = date("Y-m-d", $dob);
		echo trim($this->DateFormat->formatDate2Local($date,Configure::read('date_format'),false));
		exit;
	}
	/**
	 * function for coupon validations by swati
	 */
	function couponValidate($val,$serviceId = null){
		$this->uses = array('ServiceCategory');
		$this->loadModel('Coupon');
		$couponData = $this->Coupon->find('first',array('fields'=>array('Coupon.id','Coupon.valid_date_from','Coupon.valid_date_to','Coupon.coupon_amount','Coupon.sevices_available','Coupon.type'),
				'conditions'=>array('Coupon.is_deleted = 0',"BINARY Coupon.batch_name = '$val'",'Coupon.branch'=>$this->Session->read('locationid'),'Coupon.type'=>'Privilege Card','Coupon.status !='=>1,'Coupon.parent_id !='=>0)));
		$seviceAvailable = explode(',',$couponData['Coupon']['sevices_available']);
		
		$serviceCategoryID = $this->ServiceCategory->getServiceGroupId(Configure::read('mandatoryservices'));
		
		if($couponData){
				$msg = 'Card Available';			
		}else{
			$error = $error.'Invalid Card';
		}
		if(!empty($couponData) && in_array($serviceCategoryID,$seviceAvailable)){
			$couponAMT = unserialize($couponData['Coupon']['coupon_amount']);
			$couponAMTType = $couponAMT[$serviceCategoryID]['type'];
			$couponAMTValue = $couponAMT[$serviceCategoryID]['value'];
			$amt = ($couponAMTType =='Percentage') ? $couponAMTValue.'%' : $couponAMTValue.'.00' ;
		}
		if($error)
			echo json_encode(array($error));
		else
			echo json_encode(array($msg,$amt));
		exit;
	}

	public function printSticker($id=null){
		//no need of layout
		$this->layout  = false ;
		$this->loadmodel('Patient');
		App::import('Vendor','tcpdf/barcodes');
		if(!empty($id)){
			$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Initial' =>array(
								'foreign_key'=>'initial_id'
						)
				)));
			$this->uses=array('Facility');
			$facility_details = $this->Facility->read('name',$this->Session->read('facilityid'));
			$patient_details  = $this->Patient->getPatientDetailsByID($id);
			$formatted_address = $this->setAddressFormat($patient_details['Patient']);
			$patientAge= $this->getAge($patient_details['Person']['dob']);

			$this->set('address',$formatted_address);
			$this->set('facilityDetails',$facility_details);
			$this->set('patient',$patient_details);
			$this->set('id',$id);
			$this->set('patientAge',$patientAge);

		}else{
			$this->redirect(array("controller" => "patients", "action" => "index"));
		}
	}

	        function import_patient(){
		$this->layout  = 'advance' ;
		$this->uses = array('TariffStandard','Tariff');
			$website=$this->Session->read("website.instance");
			App::import ( 'Vendor', 'reader' );
			$this->set ( 'title_for_layout', __ ( 'Patient- Export Data', true ) );
			if ($this->request->is ( 'post' )) { // pr($this->request->data);
				if ($this->request->data ['importData'] ['import_file'] ['error'] != "0") {
					$this->Session->setFlash ( __ ( 'Please Upload the file' ), 'default', array (
							'class' => 'error' 
					) );
					$this->redirect ( array (
							"controller" => "Laboratories",
							"action" => "import_data",
							"admin" => false 
					) );
				}
				/*
				 * if($this->request->data['importData']['import_file']['size'] > "1000000"){
				 * $this->Session->setFlash(__('Size exceed Please upload 1 MB size file.'), 'default', array('class' => 'error'));
				 * $this->redirect(array("controller" => "Tariffs", "action" => "import_data","admin"=>true));
				 * }
				 */

				 ini_set('memory_limit', -1);
		            ini_set('max_input_vars', 10000);
		            set_time_limit(0);
		            $path = WWW_ROOT . 'uploads/import/' . $this->request->data['importData']['import_file']['name'];
		            move_uploaded_file($this->request->data['importData']['import_file']['tmp_name'], $path);
		            App::import('Vendor', 'PHPExcel_IOFactory', array('file' => 'PHPExcel' . DS . 'IOFactory.php'));
		            $objPHPExcel = PHPExcel_IOFactory::load($path);
		            $data = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
				
				$is_uploaded = $this->Person->importPatients($data);
				if ($is_uploaded == true) {
					unlink ( $path );
					$this->Session->setFlash ( __ ( 'Data imported sucessfully' ), 'default', array (
							'class' => 'message' 
					) );
					$this->redirect ( array (
							"controller" => "Persons",
							"action" => "import_patient",
							"admin" => false 
					) );
				} else {
					unlink ( $path );
					$this->Session->setFlash ( __ ( 'Error Occured Please check your Excel sheet.' ), 'default', array (
							'class' => 'error' 
					) );
					$this->redirect ( array (
							"controller" => "Persons",
							"action" => "import_patient",
							"admin" => false 
					) );
				}
			}
	}
	
     public function desposition_hub($patientId, $personId) {
    // Disable layout if this is intended
    $this->layout = false;
    $this->uses = array('Initial','DoctorProfile','Patient','Department','Configuration','NewCropPrescription','TariffStandard',
				'Appointment','State','Account','TariffList','Billing','User','Person','Location','ServiceBill','CouponTransaction'.'DischargeSummary','disposition');
			
		App::import('Vendor', 'DrmhopeDB');
		if($this->Session->read('db_name')){
			$db_connection = new DrmhopeDB($this->Session->read('db_name'));
		}else{
			$db_connection = new DrmhopeDB('db_hope');
		}
            		$db_connection->makeConnection($this->Initial);
            		$db_connection->makeConnection($this->DoctorProfile);
            		$db_connection->makeConnection($this->DischargeSummary);
            		$db_connection->makeConnection($this->Patient);
            		$db_connection->makeConnection($this->Person);
            		$db_connection->makeConnection($this->Department);
            		$db_connection->makeConnection($this->Configuration);
            		$db_connection->makeConnection($this->NewCropPrescription);
            		$db_connection->makeConnection($this->TariffStandard);
            		$db_connection->makeConnection($this->Appointment);
            		$db_connection->makeConnection($this->State);
            		$db_connection->makeConnection($this->Account);
            		$db_connection->makeConnection($this->TariffList);
            		$db_connection->makeConnection($this->Billing);
            		$db_connection->makeConnection($this->User);
            		$db_connection->makeConnection($this->Location);
            		$db_connection->makeConnection($this->ServiceBill);
            		$db_connection->makeConnection($this->DateFormat);
                // Fetch the patient overview with necessary fields
                       $desposition_hub = $this->Patient->find('all', array(
                        'fields' => array(
                            'Patient.admission_type', 
                            'Patient.lookup_name',
                            'Patient.discharge_date',
                            'Patient.department_id',
                            'Patient.id',
                             'Person.first_name',
                            'Person.last_name',
                            'Person.mobile',
                            'Person.id',// Fetch mobile from the Person model
                            'Patient.doctor_id'      // Fetch doctor ID
                        ),
                        'joins' => array(
                            array(
                                'table' => 'persons',   // Table name of the Person model
                                'alias' => 'Person',    // Alias for the Person table
                                'type' => 'INNER',      // Join type
                                'conditions' => array(
                                    'Patient.person_id = Person.id'  // Join the persons table on person_id
                                )
                            )
                        ),
                        'conditions' => array(
                            'Patient.id' => $patientId  // Condition for patient ID
                        )
                    ));
                // debug($desposition_hub);exit;
                $this->set('desposition_hub', $desposition_hub);
            
            }
            
            
            
            
            public function saveDisposition() {
    $this->uses = array(
        'Initial', 'DoctorProfile', 'Patient', 'Department', 'Configuration', 'NewCropPrescription', 'TariffStandard',
        'Appointment', 'State', 'Account', 'TariffList', 'Billing', 'User', 'Person', 'Location', 'ServiceBill',
        'CouponTransaction', 'DischargeSummary', 'Disposition' // Use 'Disposition' model
    );
    App::import('Vendor', 'DrmhopeDB');

    // Set up DB connection
    if ($this->Session->read('db_name')) {
        $db_connection = new DrmhopeDB($this->Session->read('db_name'));
    } else {
        $db_connection = new DrmhopeDB('db_hope');
    }
    $db_connection->makeConnection($this->Initial);
    $db_connection->makeConnection($this->DoctorProfile);
    $db_connection->makeConnection($this->DischargeSummary);
    $db_connection->makeConnection($this->Patient);
    $db_connection->makeConnection($this->Person);
    $db_connection->makeConnection($this->Department);
    $db_connection->makeConnection($this->Configuration);
    $db_connection->makeConnection($this->NewCropPrescription);
    $db_connection->makeConnection($this->TariffStandard);
    $db_connection->makeConnection($this->Appointment);
    $db_connection->makeConnection($this->State);
    $db_connection->makeConnection($this->Account);
    $db_connection->makeConnection($this->TariffList);
    $db_connection->makeConnection($this->Billing);
    $db_connection->makeConnection($this->User);
    $db_connection->makeConnection($this->Location);
    $db_connection->makeConnection($this->ServiceBill);
    $db_connection->makeConnection($this->DateFormat);

    if ($this->request->is('post')) {
        // Debugging incoming data

        // Prepare the data for insertion into the 'disposition' table
        $data = array(
            'Disposition' => array(
                'person_id' => $this->request->data['patient_id'], // Foreign key to Person or Patient table
                'disposition' => $this->request->data['disposition'],
                'sub_disposition' => $this->request->data['sub_disposition'],
                'outcome' => $this->request->data['outcome'],
                'follow_up_date' => $this->request->data['follow_up_date'],
                'follow_up_action' => $this->request->data['follow_up_action'],
                'created_at' => date('Y-m-d H:i:s'), // Optional: Add a timestamp for when the entry was created
                'call_assigned_to' => $this->request->data['call_assigned_to'], // Call Assigned To Field
                'call_timestamp' => $this->request->data['call_timestamp'], // Call Timestamp
                'remark' => $this->request->data['remark']
            )
        );

        // Attempt to save the new disposition record
        if ($this->Disposition->save($data)) {
            $this->Session->setFlash(__('Disposition added successfully', true), true, array('class' => 'message'));
        } else {
            $this->Flash->error(__('Unable to save data. Please try again.'));
            debug($this->Disposition->validationErrors); // Debug validation errors if save fails
        }

        // Redirect as necessary (change 'persons' to the correct controller if needed)
        $this->redirect(array("controller" => "persons", "action" => "patient_overview"));
    }
}

              public function save_dispositiondata() {
    $this->autoRender = false;
    $this->loadModel('Disposition');
    $this->uses = array(
        'Initial', 'DoctorProfile', 'Patient', 'Department', 'Configuration', 'NewCropPrescription', 'TariffStandard',
        'Appointment', 'State', 'Account', 'TariffList', 'Billing', 'User', 'Person', 'Location', 'ServiceBill',
        'CouponTransaction', 'DischargeSummary', 'Disposition' // Use 'Disposition' model
    );
    App::import('Vendor', 'DrmhopeDB');

    if ($this->Session->read('db_name')) {
        $db_connection = new DrmhopeDB($this->Session->read('db_name'));
    } else {
        $db_connection = new DrmhopeDB('db_hope');
    }

    $models = [
        'Initial', 'DoctorProfile', 'DischargeSummary', 'Patient', 'Person', 'Department', 'Configuration', 'NewCropPrescription', 
        'TariffStandard', 'Appointment', 'State', 'Account', 'TariffList', 'Billing', 'User', 'Location', 'ServiceBill', 'DateFormat'
    ];
    $db_connection->makeConnection($this->$models);

    if ($this->request->data) {
        $database = $this->request->data('database');
        $DBconn = new DrmhopeDB($database);
        $DBconn->makeConnection($this->Disposition);

        $today = date('Y-m-d');
        $data = [
            'person_id' => $this->request->data['person_id'],
            'patient_id' => $this->request->data['patient_id'],
            'mobile' => $this->request->data['mobile'],
            'budget_amount' => $this->request->data['budget_amount'],
            'patien_name' => $this->request->data['patient_name'],
            'disposition' => $this->request->data['disposition'],
            'sub_disposition' => $this->request->data['sub_disposition'],
            'doctor' => $this->request->data['doctor'],
            'created_at' => date('Y-m-d H:i:s'),
            'call_assigned_to' => $this->request->data['call_assigned_to'],
            'diagnosis' => $this->request->data['diagnosis'],
            'admission_type' => $this->request->data['admission_type'],
            'department' => $this->request->data['department'],
            'queue_date' => $this->request->data['queue_date'],
            'review_date' => $this->request->data['review_date'],
            'remark' => $this->request->data['remark'], 
            'follow_up_date' => $today,
        ];

        if ($this->Disposition->save($data)) {
            // After saving disposition, update the 'is_call' field in the 'Patient' table
            $patientId = $this->request->data['patient_id']; // Get the patient ID
             $DBconn->makeConnection($this->Patient);
            $this->Patient->id = $patientId;
          
            if ($this->Patient->saveField('is_call', 1)) {
                // Set a success message and redirect
                //   debug($patientId);exit;
                $this->Session->setFlash(__('Data saved successfully and call status updated.'));
                $this->redirect(['controller' => 'persons', 'action' => 'patient_overview']);
            } else {
                $this->Session->setFlash(__('Error updating the patient call status.'));
            }
        } else {
            $this->Session->setFlash(__('Error saving disposition data.'));
        }
    }
}

public function patient_registration(){
		$this->layout = false;

		$this->uses = array('Initial','DoctorProfile','Patient','Department','Configuration','NewCropPrescription','TariffStandard',
				'Appointment','State','Account','TariffList','Billing','User','Person','Location','ServiceBill','CouponTransaction');
		App::import('Vendor', 'DrmhopeDB');
		if($this->Session->read('db_name')){
			$db_connection = new DrmhopeDB($this->Session->read('db_name'));
		}else{
			$db_connection = new DrmhopeDB('db_hope');
		}
		
		$db_connection->makeConnection($this->Initial);
		$db_connection->makeConnection($this->DoctorProfile);
		$db_connection->makeConnection($this->Patient);
		$db_connection->makeConnection($this->Person);
		$db_connection->makeConnection($this->Department);
		$db_connection->makeConnection($this->Configuration);
		$db_connection->makeConnection($this->NewCropPrescription);
		$db_connection->makeConnection($this->TariffStandard);
		$db_connection->makeConnection($this->Appointment);
		$db_connection->makeConnection($this->State);
		$db_connection->makeConnection($this->Account);
		$db_connection->makeConnection($this->TariffList);
		$db_connection->makeConnection($this->Billing);
		$db_connection->makeConnection($this->User);
		$db_connection->makeConnection($this->Location);
		$db_connection->makeConnection($this->ServiceBill);
		$db_connection->makeConnection($this->DateFormat);

		$this->Session->write('isquickregsave',"0");
		$privateID = $this->TariffStandard->getPrivateTariffID();
		//location list
		$locations = $this->Location->find('list',array('fields'=>array('name'),'conditions'=>array('Location.is_active'=>1,'Location.is_deleted'=>0)));
		$this->set(array('privateID'=>$privateID,'locations'=>$locations));
		//debug($this->request->data);die();
		if(!empty($this->request->data["Person"])){
		  debug($this->request->data["Person"]);exit;
			// staff registration and restrict account creation code added by atul chandankhede
			if($this->request->data["Person"]["is_staff_register"] == '1'){
				$staffName = explode(" ", $this->request->data["Person"]["staff_name"]);
				$this->request->data["Person"]["first_name"] =$staffName[0]; 
				$this->request->data["Person"]["last_name"] =$staffName[1];
				$this->request->data["Patient"]["is_staff_register"] = $this->request->data["Person"]["is_staff_register"];
			}
// 			
			
			if(!empty($this->request->data["Person"]['dob'])){
				$dob = $this->request->data["Person"]['dob'];
				$this->request->data["Person"]['dob'] = $this->DateFormat->formatDate2STD($dob,Configure::read('date_format'));
				$years = ($this->request->data["Person"]['age_year'] != '0') ? $this->request->data["Person"]['age_year'].'Y ' : '';
				$months = ($this->request->data["Person"]['age_month'] != '0') ? $this->request->data["Person"]['age_month'].'M ' : '';
				$days = $this->request->data["Person"]['age_day'].'D';
				$this->request->data["Person"]['age'] = $years.$months.$days ;
			}
			$this->Person->begin();
			$lastid = $this->Person->insertPerson($this->request->data,'insert','emregency');
			if(!empty($errors)) {
				$this->set("errors", $errors);
			}else {
				//foto upload by pankaj w
				if(!empty($this->request->data['Person']['upload_image']['name'])){
					//creating runtime image name
					$original_image_extension  = explode(".",$this->request->data['Person']['upload_image']['name']);
					if(!isset($original_image_extension[1])){
						$imagename= "person_".mktime().'.'.$original_image_extension[0];
					}else{
						$imagename= "person_".mktime().'.'.$original_image_extension[1];
					}
					//set new image name to DB
					$this->request->data["Person"]['photo']  = $imagename ;
				}else if(!empty($this->request->data['Person']['web_cam'])){
					$im = imagecreatefrompng($this->request->data['Person']['web_cam']);
					if($im){
						$imagename= "person_".mktime().'.png';
						imagejpeg($im,WWW_ROOT.'/uploads/patient_images/thumbnail/'.$imagename);
						$this->request->data["Person"]['photo']  = $imagename ;
					}else{
						unset($this->request->data["Person"]['photo']);
					}
				}else{
					unset($this->request->data["Person"]['photo']);
				}
				if(!empty($this->request->data['Person']['upload_image']['name'])){
					if($this->request->data['Person']['upload_image']['error']){
						if( $this->request->data['Person']['upload_image']['error']==1 ||
								$this->request->data['Person']['upload_image']['error'] ==2){
							$this->Session->setFlash(__('Max file size 2MB exceeded,Please try again', true),array('class'=>'error'));
						}else{
							$this->Session->setFlash(__('There is problem while uplaoding image,Please try again', true),array('class'=>'error'));
						}
					}else{
						$showError = $this->ImageUpload->uploadFile($this->params,'upload_image','uploads/patient_images',$imagename);
						if(empty($showError)) {
							// making thumbnail of 100X100
							$this->ImageUpload->load($this->request->data['Person']['upload_image']['tmp_name']);
							$this->ImageUpload->resize(100,100);
							$this->ImageUpload->save("uploads/patient_images/thumbnail/".$imagename);
						}
					}
				}
				
				//EOF foto upload
				$latest_insert_id = $this->Person->getInsertId();
				$patient_id   = $this->autoGeneratedPatientID($latest_insert_id,$this->request->data);
				$this->request->data['Person']['id'] = $latest_insert_id ;
				$this->request->data['Person']['patient_uid'] =$patient_id ;
				$this->request->data['Person']['alternate_patient_uid'] =$latest_insert_id ;
				$this->request->data['Person']['payment_category'] = 'cash';
				$this->request->data['Person']['expected_date_del'] = $this->DateFormat->formatDate2STD($this->request->data['Person']['expected_date_del'],Configure::read('date_format'));
				//QR code image generation
				$qrformat =  $this->qrFormat($this->request->data['Person']);
				App::import('Vendor', 'qrcode', array('file' => 'qrcode/qrlib.php'));
				QRcode::png($qrformat, "uploads/qrcodes/$patient_id.png", 'L', 4, 2);

				$this->Person->save($this->request->data);
				$id=$this->Person->find('first',array('fields'=>array('Person.patient_uid'),'order'=>'Person.id DESC'));
			}
			$this->request->data['Patient']['person_id'] = $latest_insert_id;
			$this->request->data['Patient']['patient_id'] =$id['Person']['patient_uid'];
			$this->request->data['Patient']['is_deleted'] = 0;
			
			$this->request->data['Patient']['dob'] = $this->DateFormat->formatDate2STD($dob,Configure::read('date_format'));
			//by pankaj w for vadodara only
			if($this->Session->read('website.instance')=='vadodara'){
				$this->request->data['Patient']['location_id'] = $this->request->data['Person']['location_id'] ;
			}else{
				$this->request->data['Patient']['location_id'] = $this->Session->read('locationid')?$this->Session->read('locationid'):1 ;
			}
			$this->request->data['Patient']['admission_type'] = 'OPD';
			$this->request->data['Patient']['lookup_name']= $this->request->data["Person"]['first_name']." ".$this->request->data["Person"]['last_name'];
			$this->request->data['Patient']['is_emergency'] = 0;
			/** Krupya Hat Lau Naye */
			$formRecievedOn = trim($this->request->data['Patient']['form_received_on']).' '.trim($this->request->data['Person']['start_time']);
			/** aadesha anusar */
			$this->request->data['Patient']['form_received_on'] = $this->DateFormat->formatDate2STD($formRecievedOn,Configure::read('date_format'));
			$this->request->data['Patient']['form_completed_on'] = $this->DateFormat->formatDate2STD($formRecievedOn,Configure::read('date_format'));
			$this->request->data['Patient']['create_time'] = date('Y-m-d H:i:s') ;
			$this->request->data['Patient']['expected_date_del'] = $this->request->data['Person']['expected_date_del'];
			$this->request->data['Patient']['pregnant_week'] = $this->request->data['Person']['pregnant_week'];
			$this->request->data['Patient']['created_by'] = $this->Session->read('userid')?$this->Session->read('userid'):1 ;
			$this->request->data['Patient']['is_discharge']= 0 ;
			$this->request->data['Patient']['sex']= $this->request->data['Person']['sex'];
			$this->request->data['Patient']['age']= $this->request->data['Person']['age'];
			$this->request->data['Patient']['payment_category'] = 'cash';
			$this->request->data['Patient']['coupon_name'] = $this->request->data["Person"]['coupon_name'];
			$this->request->data['Patient']['coupon_amount'] =$this->request->data["Person"]['coupon_amount'];
			$this->request->data['Patient']['initial_id'] =$this->request->data["Person"]['initial_id'];
		
			//BOF-Mahalaxmi For File number added in Patient Table
			$fileNoPatient = $this->Patient->generatePatientFileNo();				
			$this->request->data['Patient']['file_number'] =$fileNoPatient;
			//EOF-Mahalaxmi For File number added in Patient Table
			$admission_id = $this->Patient->autoGeneratedAdmissionID($latest_id,$this->request->data);
			$this->request->data['Patient']['admission_id'] =$admission_id;
			if($this->Patient->save($this->request->data['Patient']))
				$this->Person->commit();
			else
				$this->Person->rollback();

			$latest_id = $this->Patient->getInsertId();
			//add mandatory charges by pankajw
			$this->Account->insertMandatoryServiceCharges($this->request->data,$latest_id); // by yashwant
			//EOF mandatory charges by pankajw
			
			if($this->request->data['Patient']['coupon_name']!='' and Configure::read('Coupon')){
				$this->CouponTransaction->setCouponTransaction($latest_insert_id,$this->request->data['Patient']['coupon_name']);
				if($this->request->data["Patient"]['admission_type'] == "OPD")
					$this->request->data['Patient']['total'] =  $this->CouponTransaction->ApplyCouponDiscount($latest_insert_id,$this->request->data['Patient']['coupon_amount']);
			}
				
			
			
			
			//generate QrCode of admission_id and Patient Name - by Mrunal
			$age = explode(' ', $this->request->data['Patient']['age']);
			$concatedPatientName = $this->request->data['Patient']['lookup_name']." ".$age[0]." ".trim($admission_id);
			$lookup_name_withspace = preg_replace('/[^A-Za-z0-9]/', ' ', $concatedPatientName);
			$this->Patient->getPatientAdmissionIdQR(trim($admission_id),$latest_id);
			$this->Patient->getPatientNameQR($lookup_name_withspace,$latest_id);
			//end Of qrcode
			
			$this->Patient->updateAll(array('Patient.admission_id' => "'$admission_id'",'Patient.account_number' => "'$admission_id'"),array('Patient.id'=>$latest_id));
			//  New QR Code As per EMAR Criteria Requirement
			$qrString = $patient_id;//."#".$this->request->data['Patient']['lookup_name']."#".$dob;
			// generate Text Type QrCode
			//$this->QRCode ->text(trim($qrString));
			// display new QR code image
			//$this->QRCode ->draw(150, "uploads/qrcodes/".$admission_id.".png"); //qr code commneted by pankajw as it is not allow to register offline 
			if($this->request->data['setSoap'])
				$this->NewCropPrescription->insertDrugFromQuickReg($this->request->data,$latest_id);
			$this->set('isquickregsave',"1");
			$this->set('patientId',$latest_id);
			$doctorId = $this->request->data['Patient']['doctor_id'];//gaurav

			// for redirect from registration to billing page-Atul
			/*$this->loadModel('Configuration');
			 $redirect = $this->Configuration->find('first',array('conditions'=>array('name'=>'Redirect From Registration')));
			$previousData = unserialize($redirect['Configuration']['value']);
			if($previousData=='1'){
			$this->request->data['Patient']['person_id'] = $latest_insert_id;
			$this->request->data['Patient']['patient_id'] = $latest_id;
			$this->Appointment->setCurrentAppointment($this->request->data);
			$this->Session->setFlash(__('Record added Successfully', true),true,array('class'=>'message'));
			$this->redirect(array("controller"=>"Billings","action"=>"multiplePaymentModeIpd",$latest_id));
			}*/
			/** Creating New appointment and moving to patient list -- gaurav */
			$this->request->data['Patient']['person_id'] = $latest_insert_id;
			$this->request->data['Patient']['patient_id'] = $latest_id;
			//debug($this->request->data);die();
			$this->Appointment->setCurrentAppointment($this->request->data);
			if($this->Session->read('website.instance')=='vadodara'){
				/**
				 * For setting up multiple appointment at a time 
				 */
				if($this->request->data['Appointment']){
					$this->Appointment->setMultipleAppointment($this->request->data);
				}
				// For after setting up multiple appointment print multiple OPD print sheet-Atul
			   $docPid[]=($this->request->data['Patient']['doctor_id']);
			   
		       if(!empty($this->request->data['Appointment']['doctor_id'])){
		       	 $doctorAppId=$this->request->data['Appointment']['doctor_id'];
		       }else{
		       	 $doctorAppId[]=$this->request->data['Appointment']['doctor_id'];
		       }
				$doctorIdArray = array_merge($docPid,$doctorAppId);
				$docIDArr=array_filter($doctorIdArray);	
			    $docArray=implode(",", $docIDArr);
	
				// EOF multiple appointment
				if(($this->request->data["Person"]['pay_amt']=='1') && ($this->request->data['Person']['printSheet'] =='1')){
					//function for saving data in billing and accounting
					
					$billId=$this->Billing->saveRegBill($this->request->data);
					
					///End OF code
					$this->Session->setFlash(__('Record added for - <b>'.$patient_id."</b>",true),'default',array('class'=>'stillSuccess','id'=>'stillFlashMessage'),'still');
					$this->redirect(array("controller" => "persons", "action" => "quickReg",'?'=>array('print'=>$billId,"patientId"=>$latest_id,'docId'=>$docArray)));
				
				} else{
					$this->redirect(array("controller" => "persons", "action" => "quickReg",'?'=>array("patientId"=>$latest_id,'docId'=>$docArray)));
				}
			}

        	if ($this->request->data['Person']['capturefingerprint'] == "1") {
            $this->Session->setFlash(__('Record Added Successfully', true), true, array('class' => 'message'));
            $this->redirect(array(
                "controller" => "persons", 
                "action" => "finger_print", 
                $latest_insert_id, 
                'capturefingerprint' => $this->request->data["Person"]['capturefingerprint'], 
                '?' => array('id' => $latest_insert_id)
            ));
        } else {
            // debug($patient_id);exit;
           
            $lastInsertedPersonId = $this->Person->getLastInsertId();
            $lastInsertedPatientId = $this->Patient->getLastInsertId();
            // $lastInseredPatien_uid = 
            
            // Capture the mobile number and next of kin's mobile number
              $mobile_number = isset($this->request->data['Person']['mobile']) ? $this->request->data['Person']['mobile'] : null;
              $first_name = isset($this->request->data['Person']['first_name']) ? $this->request->data['Person']['first_name'] : null;
              $last_name = isset($this->request->data['Person']['last_name']) ? $this->request->data['Person']['last_name'] : null;
              $next_of_kin_name = isset($this->request->data['Person']['next_of_kin_name']) ? $this->request->data['Person']['next_of_kin_name'] : null;
              $next_of_kin_number = isset($this->request->data['Person']['next_of_kin_mobile']) ? $this->request->data['Person']['next_of_kin_mobile'] : null;
        
            if (!empty($mobile_number)) {
                
                $this->Session->setFlash(__('Record Added Successfully. Generating QR Code for mobile and next of kin.', true), true, array('class' => 'message'));
                  $patientid = $lastInsertedPersonId . '/' . $lastInsertedPatientId;
         $user_qr_image_url = 'https://hopesoftwares.com/persons/generateQrCode/' . $patientid;
         $messageStatus = $this->sendWhatsAppMessage($mobile_number, $user_qr_image_url,$first_name,$lastInsertedPersonId,$patient_id);
        //  debug($user_qr_image_url);exit;
                // Redirect to generateQrCode function to generate QR codes and render the view
                $this->redirect(array(
                    "controller" => "persons",
                    "action" => "generateQrCode",
                    $lastInsertedPersonId,
                    $lastInsertedPatientId,
                ));
                 $this->redirect(array("controller" => "appointments", "action" => "appointments_management"));
            } else {
                $this->Session->setFlash(__('Mobile number is required to generate QR Code.', true), true, array('class' => 'error'));
                $this->redirect(array("controller" => "appointments", "action" => "appointments_management"));
            }
        }
        }

		$this->set('newState',$this->State->find('list',array('fields'=>array('id','name'),'conditions'=>array('State.country_id'=>'1'))));
		$getConfiguration=$this->Configuration->find('all');
		$strenght=unserialize($getConfiguration[0]['Configuration']['value']);
		$dose=unserialize($getConfiguration[1]['Configuration']['value']);
		$route=unserialize($getConfiguration[2]['Configuration']['value']);
		foreach($strenght as $strenghts){
			$str.='<option value='.'"'.stripslashes($strenghts).'"'.'>'.$strenghts.'</option>';
		}
		$str.='</select>';
		$this->set('str',$str);
		foreach($dose as $doses){
			$str_dose.='<option value='.'"'.stripslashes($doses).'"'.'>'.$doses.'</option>';
		}
		$str_dose.='</select>';
		$this->set('str_dose',$str_dose);
		foreach($route as $routes){
			$str_route.='<option value='.'"'.stripslashes($routes).'"'.'>'.$routes.'</option>';
		}
		$str_route.='</select>';
		$this->set('str_route',$str_route);
		foreach(unserialize($getConfiguration[0]['Configuration']['value']) as $key=>$strenght){
			if(!empty($strenght))
				$strenght_var[$strenght]=$strenght;
		}
		$this->set('strenght',$strenght_var);
		foreach(unserialize($getConfiguration[1]['Configuration']['value']) as $key=>$doses){
			if(!empty($doses))
				$dose_var[$doses]=$doses;
		}
		$this->set('dose',$dose_var);
		foreach(unserialize($getConfiguration[2]['Configuration']['value']) as $key=>$route){
			if(!empty($route))
				$route_var[$route]=$route;
		}
		/** gaurav */
		foreach($getConfiguration as $allowTimelyQuickReg){
			if($allowTimelyQuickReg['Configuration']['name'] == 'allowTimelyQuickReg')
				$allow = ($allowTimelyQuickReg['Configuration']['value'] == '1') ? true : false;
		}
		Configure :: write('allowTimelyQuickReg', $allow );
		/** EOF*/
		$this->set('route',$route_var);
		
		$this->set('initials',$this->Initial->find('list',array('fields'=>array('name'))));
		if(isset($this->Session) && !empty($this->Session->read('locationid'))){
			$OPCheckUpOptions=$this->TariffList->find('list',array('fields'=>array('id','name'),'conditions'=>array('is_deleted'=>'0','check_status'=>'1','location_id'=>$this->Session->read('locationid')?$this->Session->read('locationid'):1)));
			$this->set('opdoptions',$OPCheckUpOptions);

			//$this->set('doctorlist',$this->DoctorProfile->getDoctors());
			$this->set('doctorlist',$this->User->getOpdDoctors());
			$this->set('tariff',  $this->TariffStandard->find('list',array('order' => array('TariffStandard.name'),'conditions'=>array('is_deleted'=>0,'TariffStandard.location_id'=>$this->Session->read('locationid')?$this->Session->read('locationid'):1))));
			$this->set('departments',$this->Department->find('list',array('fields'=>array('id','name'),'conditions'=>array('Department.location_id'=>$this->Session->read('locationid')?$this->Session->read('locationid'):1),'order' => array('Department.name'))));
			$this->set('online',false);
		}else{
    $this->set('online', true);

    $this->set('doctorlist', [ '56' => 'B K Murali, MS (Orth.)','57' => 'Dr. Ritesh Navkhare, MD','58' => 'Dr. Atul Rajkondawar, MD','59' => 'Dr. Afsal Sheikh, MD' ]);
    $this->set('tariff', ['7' => 'Private','8' => 'General','9' => 'Corporate','10' => 'Insurance-based']);
    $this->set('opdoptions', ['4' => 'Consultation Charges', '5' => 'Follow-up Visit', '6' => 'Emergency Visit','7' => 'Second Opinion']);
    $this->set('departments',['12' => 'Orthopaedics','13' => 'Cardiology','14' => 'General Medicine', '15' => 'Pediatrics','16' => 'Neurology','17' => 'Abdominal or chest conditions']);
}
// when quick register form open in without login show this dropdown code by dinesh tawade
		/** setting searchPerson data to form inputs --gaurav  */
		$searchPersonData = $this->request->data;
		$this->request->data= '';
		if(!$searchPersonData['tariff_standard_id'])
			$searchPersonData['hidden_tariff_standard_id'] = '';
		else
			$searchPersonData['insurance_type_id'] = $searchPersonData['tariff_standard_id'];
		unset($searchPersonData['form_received_on'],$searchPersonData['tariff_standard_id']);
		$this->request->data['Person'] = $searchPersonData;
		$this->data = $this->request->data;
		
		//for set coupon transaction if coupon is applied
		if($this->request->data['Patient']['coupon_name'])
			$this->CouponTransaction->setCouponTransaction($latest_id,$this->request->data['Patient']['coupon_name']);
		//for fingerprint device
		
		$isFingerPrintEnable = $this->Configuration->find('first',array('conditions'=>array('name'=>'isFingerPrintEnable')));
		$this->set('isFingerPrintEnable',$isFingerPrintEnable['Configuration']['value']);
	}
	
// 	public function generate_qr(){
// 	    	$this->layout = false ;
// 	}
	
	public function generate_qr(){
	    	$this->layout = false ;
	    	debug($this->request->data);exit;

		$this->uses = array('Initial','DoctorProfile','Patient','Department','Configuration','NewCropPrescription','TariffStandard',
				'Appointment','State','Account','TariffList','Billing','User','Person','Location','ServiceBill','CouponTransaction');
		App::import('Vendor', 'DrmhopeDB');
		if($this->Session->read('db_name')){
			$db_connection = new DrmhopeDB($this->Session->read('db_name'));
		}else{
			$db_connection = new DrmhopeDB('db_hope');
		}
		
		$db_connection->makeConnection($this->Initial);
		$db_connection->makeConnection($this->DoctorProfile);
		$db_connection->makeConnection($this->Patient);
		$db_connection->makeConnection($this->Person);
		$db_connection->makeConnection($this->Department);
		$db_connection->makeConnection($this->Configuration);
		$db_connection->makeConnection($this->NewCropPrescription);
		$db_connection->makeConnection($this->TariffStandard);
		$db_connection->makeConnection($this->Appointment);
		$db_connection->makeConnection($this->State);
		$db_connection->makeConnection($this->Account);
		$db_connection->makeConnection($this->TariffList);
		$db_connection->makeConnection($this->Billing);
		$db_connection->makeConnection($this->User);
		$db_connection->makeConnection($this->Location);
		$db_connection->makeConnection($this->ServiceBill);
		$db_connection->makeConnection($this->DateFormat);

		$this->Session->write('isquickregsave',"0");
		$privateID = $this->TariffStandard->getPrivateTariffID();
		//location list
		$locations = $this->Location->find('list',array('fields'=>array('name'),'conditions'=>array('Location.is_active'=>1,'Location.is_deleted'=>0)));
		$this->set(array('privateID'=>$privateID,'locations'=>$locations));
		//debug($this->request->data);die();
		if(!empty($this->request->data["Person"])){
		  debug(($this->request->data["Person"]));exit;
			// staff registration and restrict account creation code added by atul chandankhede
			if($this->request->data["Person"]["is_staff_register"] == '1'){
				$staffName = explode(" ", $this->request->data["Person"]["staff_name"]);
				$this->request->data["Person"]["first_name"] =$staffName[0]; 
				$this->request->data["Person"]["last_name"] =$staffName[1];
				$this->request->data["Patient"]["is_staff_register"] = $this->request->data["Person"]["is_staff_register"];
			}
// 			
			
			if(!empty($this->request->data["Person"]['dob'])){
				$dob = $this->request->data["Person"]['dob'];
				$this->request->data["Person"]['dob'] = $this->DateFormat->formatDate2STD($dob,Configure::read('date_format'));
				$years = ($this->request->data["Person"]['age_year'] != '0') ? $this->request->data["Person"]['age_year'].'Y ' : '';
				$months = ($this->request->data["Person"]['age_month'] != '0') ? $this->request->data["Person"]['age_month'].'M ' : '';
				$days = $this->request->data["Person"]['age_day'].'D';
				$this->request->data["Person"]['age'] = $years.$months.$days ;
			}
			$this->Person->begin();
			$lastid = $this->Person->insertPerson($this->request->data,'insert','emregency');
			if(!empty($errors)) {
				$this->set("errors", $errors);
			}else {
				//foto upload by pankaj w
				if(!empty($this->request->data['Person']['upload_image']['name'])){
					//creating runtime image name
					$original_image_extension  = explode(".",$this->request->data['Person']['upload_image']['name']);
					if(!isset($original_image_extension[1])){
						$imagename= "person_".mktime().'.'.$original_image_extension[0];
					}else{
						$imagename= "person_".mktime().'.'.$original_image_extension[1];
					}
					//set new image name to DB
					$this->request->data["Person"]['photo']  = $imagename ;
				}else if(!empty($this->request->data['Person']['web_cam'])){
					$im = imagecreatefrompng($this->request->data['Person']['web_cam']);
					if($im){
						$imagename= "person_".mktime().'.png';
						imagejpeg($im,WWW_ROOT.'/uploads/patient_images/thumbnail/'.$imagename);
						$this->request->data["Person"]['photo']  = $imagename ;
					}else{
						unset($this->request->data["Person"]['photo']);
					}
				}else{
					unset($this->request->data["Person"]['photo']);
				}
				if(!empty($this->request->data['Person']['upload_image']['name'])){
					if($this->request->data['Person']['upload_image']['error']){
						if( $this->request->data['Person']['upload_image']['error']==1 ||
								$this->request->data['Person']['upload_image']['error'] ==2){
							$this->Session->setFlash(__('Max file size 2MB exceeded,Please try again', true),array('class'=>'error'));
						}else{
							$this->Session->setFlash(__('There is problem while uplaoding image,Please try again', true),array('class'=>'error'));
						}
					}else{
						$showError = $this->ImageUpload->uploadFile($this->params,'upload_image','uploads/patient_images',$imagename);
						if(empty($showError)) {
							// making thumbnail of 100X100
							$this->ImageUpload->load($this->request->data['Person']['upload_image']['tmp_name']);
							$this->ImageUpload->resize(100,100);
							$this->ImageUpload->save("uploads/patient_images/thumbnail/".$imagename);
						}
					}
				}
				
				//EOF foto upload
				$latest_insert_id = $this->Person->getInsertId();
				$patient_id   = $this->autoGeneratedPatientID($latest_insert_id,$this->request->data);
				$this->request->data['Person']['id'] = $latest_insert_id ;
				$this->request->data['Person']['patient_uid'] =$patient_id ;
				$this->request->data['Person']['alternate_patient_uid'] =$latest_insert_id ;
				$this->request->data['Person']['payment_category'] = 'cash';
				$this->request->data['Person']['expected_date_del'] = $this->DateFormat->formatDate2STD($this->request->data['Person']['expected_date_del'],Configure::read('date_format'));
				//QR code image generation
				$qrformat =  $this->qrFormat($this->request->data['Person']);
				App::import('Vendor', 'qrcode', array('file' => 'qrcode/qrlib.php'));
				QRcode::png($qrformat, "uploads/qrcodes/$patient_id.png", 'L', 4, 2);

				$this->Person->save($this->request->data);
				
				$id=$this->Person->find('first',array('fields'=>array('Person.patient_uid'),'order'=>'Person.id DESC'));
			}
			$this->request->data['Patient']['person_id'] = $latest_insert_id;
			$this->request->data['Patient']['patient_id'] =$id['Person']['patient_uid'];
			$this->request->data['Patient']['is_deleted'] = 0;
			
			$this->request->data['Patient']['dob'] = $this->DateFormat->formatDate2STD($dob,Configure::read('date_format'));
			//by pankaj w for vadodara only
			if($this->Session->read('website.instance')=='vadodara'){
				$this->request->data['Patient']['location_id'] = $this->request->data['Person']['location_id'] ;
			}else{
				$this->request->data['Patient']['location_id'] = $this->Session->read('locationid')?$this->Session->read('locationid'):1 ;
			}
			$this->request->data['Patient']['admission_type'] = 'OPD';
			$this->request->data['Patient']['lookup_name']= $this->request->data["Person"]['first_name']." ".$this->request->data["Person"]['last_name'];
			$this->request->data['Patient']['is_emergency'] = 0;
			/** Krupya Hat Lau Naye */
			$formRecievedOn = trim($this->request->data['Patient']['form_received_on']).' '.trim($this->request->data['Person']['start_time']);
			/** aadesha anusar */
			$this->request->data['Patient']['form_received_on'] = $this->DateFormat->formatDate2STD($formRecievedOn,Configure::read('date_format'));
			$this->request->data['Patient']['form_completed_on'] = $this->DateFormat->formatDate2STD($formRecievedOn,Configure::read('date_format'));
			$this->request->data['Patient']['create_time'] = date('Y-m-d H:i:s') ;
			$this->request->data['Patient']['expected_date_del'] = $this->request->data['Person']['expected_date_del'];
			$this->request->data['Patient']['pregnant_week'] = $this->request->data['Person']['pregnant_week'];
			$this->request->data['Patient']['created_by'] = $this->Session->read('userid')?$this->Session->read('userid'):1 ;
			$this->request->data['Patient']['is_discharge']= 0 ;
			$this->request->data['Patient']['sex']= $this->request->data['Person']['sex'];
			$this->request->data['Patient']['age']= $this->request->data['Person']['age'];
			$this->request->data['Patient']['payment_category'] = 'cash';
			$this->request->data['Patient']['coupon_name'] = $this->request->data["Person"]['coupon_name'];
			$this->request->data['Patient']['coupon_amount'] =$this->request->data["Person"]['coupon_amount'];
			$this->request->data['Patient']['initial_id'] =$this->request->data["Person"]['initial_id'];

			//BOF-Mahalaxmi For File number added in Patient Table
			$fileNoPatient = $this->Patient->generatePatientFileNo();				
			$this->request->data['Patient']['file_number'] =$fileNoPatient;
		if (!$this->Auth->user()) {
                    // debug($latest_insert_id);
                    $lastPersonId = $latest_insert_id - 1;
                    // debug($lastPersonId);
                    
                    // Fetch the last admission ID for the person
                    $latestAdmission = $this->Patient->find('first', [
                        'fields' => ['Patient.admission_id'],
                        'conditions' => ['Patient.person_id' => $lastPersonId],
                    ]);
                    // debug($latestAdmission);
                    
                    if (!empty($latestAdmission['Patient']['admission_id'])) {
                        $lastAdmissionId = $latestAdmission['Patient']['admission_id'];
                        // debug($lastAdmissionId);
                        
                        // Numeric part nikalna aur increment karna
                        preg_match('/(\d+)$/', $lastAdmissionId, $matches);
                        if (!empty($matches)) {
                            $numericPart = (int)$matches[1]; // Extract numeric part
                            $newNumericPart = str_pad($numericPart + 1, strlen($matches[1]), '0', STR_PAD_LEFT);
                            $admission_id = substr($lastAdmissionId, 0, -strlen($matches[1])) . $newNumericPart;
                            // debug($admission_id);
                            
                            // Check if the generated admission ID already exists
                            $existingAdmission = $this->Patient->find('first', [
                                'fields' => ['Patient.admission_id'],
                                'conditions' => ['Patient.admission_id' => $admission_id],
                            ]);
                            
                            // If admission ID already exists, increment it further
                            if (!empty($existingAdmission['Patient']['admission_id'])) {
                                // Increment logic to ensure uniqueness (same approach as above)
                                preg_match('/(\d+)$/', $admission_id, $matches);
                                $numericPart = (int)$matches[1]; 
                                $newNumericPart = str_pad($numericPart + 1, strlen($matches[1]), '0', STR_PAD_LEFT);
                                $admission_id = substr($admission_id, 0, -strlen($matches[1])) . $newNumericPart;
                                // debug($admission_id); // New unique admission ID
                            }
                
                            // Set the admission ID to be saved
                            $this->request->data['Patient']['admission_id'] = $admission_id;
                        }
                    }
                } else {
                    // If user is logged in, use auto-generated admission ID
                    $admission_id = $this->Patient->autoGeneratedAdmissionID($latest_id, $this->request->data);
                    $this->request->data['Patient']['admission_id'] = $admission_id;
                }
                
                // Save the data after checking for duplicate
                if ($this->Patient->save($this->request->data['Patient'])) {
                    debug($admission_id);
                } else {
                    // Handle rollback if saving fails
                    $this->Person->rollback();
                }
			$latest_id = $this->Patient->getInsertId();
			//add mandatory charges by pankajw
			$this->Account->insertMandatoryServiceCharges($this->request->data,$latest_id); // by yashwant
			//EOF mandatory charges by pankajw
			
			if($this->request->data['Patient']['coupon_name']!='' and Configure::read('Coupon')){
				$this->CouponTransaction->setCouponTransaction($latest_insert_id,$this->request->data['Patient']['coupon_name']);
				if($this->request->data["Patient"]['admission_type'] == "OPD")
					$this->request->data['Patient']['total'] =  $this->CouponTransaction->ApplyCouponDiscount($latest_insert_id,$this->request->data['Patient']['coupon_amount']);
			}
				
			
			//generate QrCode of admission_id and Patient Name - by Mrunal
			$age = explode(' ', $this->request->data['Patient']['age']);
			$concatedPatientName = $this->request->data['Patient']['lookup_name']." ".$age[0]." ".trim($admission_id);
			$lookup_name_withspace = preg_replace('/[^A-Za-z0-9]/', ' ', $concatedPatientName);
			$this->Patient->getPatientAdmissionIdQR(trim($admission_id),$latest_id);
			$this->Patient->getPatientNameQR($lookup_name_withspace,$latest_id);
			//end Of qrcode
			
			$this->Patient->updateAll(array('Patient.admission_id' => "'$admission_id'",'Patient.account_number' => "'$admission_id'"),array('Patient.id'=>$latest_id));
			//  New QR Code As per EMAR Criteria Requirement
			$qrString = $patient_id;//."#".$this->request->data['Patient']['lookup_name']."#".$dob;
			// generate Text Type QrCode
			//$this->QRCode ->text(trim($qrString));
			// display new QR code image
			//$this->QRCode ->draw(150, "uploads/qrcodes/".$admission_id.".png"); //qr code commneted by pankajw as it is not allow to register offline 
			if($this->request->data['setSoap'])
				$this->NewCropPrescription->insertDrugFromQuickReg($this->request->data,$latest_id);
			$this->set('isquickregsave',"1");
			$this->set('patientId',$latest_id);
			$doctorId = $this->request->data['Patient']['doctor_id'];//gaurav

			// for redirect from registration to billing page-Atul
			/*$this->loadModel('Configuration');
			 $redirect = $this->Configuration->find('first',array('conditions'=>array('name'=>'Redirect From Registration')));
			$previousData = unserialize($redirect['Configuration']['value']);
			if($previousData=='1'){
			$this->request->data['Patient']['person_id'] = $latest_insert_id;
			$this->request->data['Patient']['patient_id'] = $latest_id;
			$this->Appointment->setCurrentAppointment($this->request->data);
			$this->Session->setFlash(__('Record added Successfully', true),true,array('class'=>'message'));
			$this->redirect(array("controller"=>"Billings","action"=>"multiplePaymentModeIpd",$latest_id));
			}*/
			/** Creating New appointment and moving to patient list -- gaurav */
			$this->request->data['Patient']['person_id'] = $latest_insert_id;
			$this->request->data['Patient']['patient_id'] = $latest_id;
			//debug($this->request->data);die();
			$this->Appointment->setCurrentAppointment($this->request->data);
			if($this->Session->read('website.instance')=='vadodara'){
				/**
				 * For setting up multiple appointment at a time 
				 */
				if($this->request->data['Appointment']){
					$this->Appointment->setMultipleAppointment($this->request->data);
				}
				// For after setting up multiple appointment print multiple OPD print sheet-Atul
			   $docPid[]=($this->request->data['Patient']['doctor_id']);
			   
		       if(!empty($this->request->data['Appointment']['doctor_id'])){
		       	 $doctorAppId=$this->request->data['Appointment']['doctor_id'];
		       }else{
		       	 $doctorAppId[]=$this->request->data['Appointment']['doctor_id'];
		       }
				$doctorIdArray = array_merge($docPid,$doctorAppId);
				$docIDArr=array_filter($doctorIdArray);	
			    $docArray=implode(",", $docIDArr);
	
				// EOF multiple appointment
				if(($this->request->data["Person"]['pay_amt']=='1') && ($this->request->data['Person']['printSheet'] =='1')){
					//function for saving data in billing and accounting
					
					$billId=$this->Billing->saveRegBill($this->request->data);
					
					///End OF code
					$this->Session->setFlash(__('Record added for - <b>'.$patient_id."</b>",true),'default',array('class'=>'stillSuccess','id'=>'stillFlashMessage'),'still');
					$this->redirect(array("controller" => "persons", "action" => "quickReg",'?'=>array('print'=>$billId,"patientId"=>$latest_id,'docId'=>$docArray)));
				
				} else{
					$this->redirect(array("controller" => "persons", "action" => "quickReg",'?'=>array("patientId"=>$latest_id,'docId'=>$docArray)));
				}
			}

        	if ($this->request->data['Person']['capturefingerprint'] == "1") {
            $this->Session->setFlash(__('Record Added Successfully', true), true, array('class' => 'message'));
            $this->redirect(array(
                "controller" => "persons", 
                "action" => "finger_print", 
                $latest_insert_id, 
                'capturefingerprint' => $this->request->data["Person"]['capturefingerprint'], 
                '?' => array('id' => $latest_insert_id)
            ));
        } else {
            // debug($patient_id);
           
            $lastInsertedPersonId = $this->Person->getLastInsertId();
            $lastInsertedPatientId = $this->Patient->getLastInsertId();
            // $lastInseredPatien_uid = 
        //       debug($lastInsertedPersonId);
        //  debug($lastInsertedPatientId);exit;
            
            // Capture the mobile number and next of kin's mobile number
              $mobile_number = isset($this->request->data['Person']['mobile']) ? $this->request->data['Person']['mobile'] : null;
              $first_name = isset($this->request->data['Person']['first_name']) ? $this->request->data['Person']['first_name'] : null;
              $last_name = isset($this->request->data['Person']['last_name']) ? $this->request->data['Person']['last_name'] : null;
              $next_of_kin_name = isset($this->request->data['Person']['next_of_kin_name']) ? $this->request->data['Person']['next_of_kin_name'] : null;
              $next_of_kin_number = isset($this->request->data['Person']['next_of_kin_mobile']) ? $this->request->data['Person']['next_of_kin_mobile'] : null;
        
            if (!empty($mobile_number)) {
                
                $this->Session->setFlash(__('Record Added Successfully. Generating QR Code for mobile and next of kin.', true), true, array('class' => 'message'));
                  $patientid = $lastInsertedPersonId . '/' . $lastInsertedPatientId;
         $user_qr_image_url = 'https://hopesoftwares.com/persons/generateQrCode/' . $patientid;
         $messageStatus = $this->sendWhatsAppMessage($mobile_number, $user_qr_image_url,$first_name,$lastInsertedPersonId,$patient_id);
      
                // Redirect to generateQrCode function to generate QR codes and render the view
                $this->redirect(array(
                    "controller" => "persons",
                    "action" => "generateQrCode",
                    $lastInsertedPersonId,
                    $lastInsertedPatientId,
                ));
                 $this->redirect(array("controller" => "appointments", "action" => "appointments_management"));
            } else {
                $this->Session->setFlash(__('Mobile number is required to generate QR Code.', true), true, array('class' => 'error'));
                $this->redirect(array("controller" => "appointments", "action" => "appointments_management"));
            }
        }
        }

		$this->set('newState',$this->State->find('list',array('fields'=>array('id','name'),'conditions'=>array('State.country_id'=>'1'))));
		$getConfiguration=$this->Configuration->find('all');
		$strenght=unserialize($getConfiguration[0]['Configuration']['value']);
		$dose=unserialize($getConfiguration[1]['Configuration']['value']);
		$route=unserialize($getConfiguration[2]['Configuration']['value']);
		foreach($strenght as $strenghts){
			$str.='<option value='.'"'.stripslashes($strenghts).'"'.'>'.$strenghts.'</option>';
		}
		$str.='</select>';
		$this->set('str',$str);
		foreach($dose as $doses){
			$str_dose.='<option value='.'"'.stripslashes($doses).'"'.'>'.$doses.'</option>';
		}
		$str_dose.='</select>';
		$this->set('str_dose',$str_dose);
		foreach($route as $routes){
			$str_route.='<option value='.'"'.stripslashes($routes).'"'.'>'.$routes.'</option>';
		}
		$str_route.='</select>';
		$this->set('str_route',$str_route);
		foreach(unserialize($getConfiguration[0]['Configuration']['value']) as $key=>$strenght){
			if(!empty($strenght))
				$strenght_var[$strenght]=$strenght;
		}
		$this->set('strenght',$strenght_var);
		foreach(unserialize($getConfiguration[1]['Configuration']['value']) as $key=>$doses){
			if(!empty($doses))
				$dose_var[$doses]=$doses;
		}
		$this->set('dose',$dose_var);
		foreach(unserialize($getConfiguration[2]['Configuration']['value']) as $key=>$route){
			if(!empty($route))
				$route_var[$route]=$route;
		}
		/** gaurav */
		foreach($getConfiguration as $allowTimelyQuickReg){
			if($allowTimelyQuickReg['Configuration']['name'] == 'allowTimelyQuickReg')
				$allow = ($allowTimelyQuickReg['Configuration']['value'] == '1') ? true : false;
		}
		Configure :: write('allowTimelyQuickReg', $allow );
		/** EOF*/
		$this->set('route',$route_var);
		
		$this->set('initials',$this->Initial->find('list',array('fields'=>array('name'))));
		if(isset($this->Session) && !empty($this->Session->read('locationid'))){
			$OPCheckUpOptions=$this->TariffList->find('list',array('fields'=>array('id','name'),'conditions'=>array('is_deleted'=>'0','check_status'=>'1','location_id'=>$this->Session->read('locationid')?$this->Session->read('locationid'):1)));
			$this->set('opdoptions',$OPCheckUpOptions);

			//$this->set('doctorlist',$this->DoctorProfile->getDoctors());
			$this->set('doctorlist',$this->User->getOpdDoctors());
			$this->set('tariff',  $this->TariffStandard->find('list',array('order' => array('TariffStandard.name'),'conditions'=>array('is_deleted'=>0,'TariffStandard.location_id'=>$this->Session->read('locationid')?$this->Session->read('locationid'):1))));
			$this->set('departments',$this->Department->find('list',array('fields'=>array('id','name'),'conditions'=>array('Department.location_id'=>$this->Session->read('locationid')?$this->Session->read('locationid'):1),'order' => array('Department.name'))));
			$this->set('online',false);
		}else{
    $this->set('online', true);

    $this->set('doctorlist', [ '56' => 'B K Murali, MS (Orth.)','57' => 'Dr. Ritesh Navkhare, MD','58' => 'Dr. Atul Rajkondawar, MD','59' => 'Dr. Afsal Sheikh, MD' ]);
    $this->set('tariff', ['7' => 'Private','8' => 'General','9' => 'Corporate','10' => 'Insurance-based']);
    $this->set('opdoptions', ['4' => 'Consultation Charges', '5' => 'Follow-up Visit', '6' => 'Emergency Visit','7' => 'Second Opinion']);
    $this->set('departments',['12' => 'Orthopaedics','13' => 'Cardiology','14' => 'General Medicine', '15' => 'Pediatrics','16' => 'Neurology','17' => 'Abdominal or chest conditions']);
}
// when quick register form open in without login show this dropdown code by dinesh tawade
		/** setting searchPerson data to form inputs --gaurav  */
		$searchPersonData = $this->request->data;
		$this->request->data= '';
		if(!$searchPersonData['tariff_standard_id'])
			$searchPersonData['hidden_tariff_standard_id'] = '';
		else
			$searchPersonData['insurance_type_id'] = $searchPersonData['tariff_standard_id'];
		unset($searchPersonData['form_received_on'],$searchPersonData['tariff_standard_id']);
		$this->request->data['Person'] = $searchPersonData;
		$this->data = $this->request->data;
		
		//for set coupon transaction if coupon is applied
		if($this->request->data['Patient']['coupon_name'])
			$this->CouponTransaction->setCouponTransaction($latest_id,$this->request->data['Patient']['coupon_name']);
		//for fingerprint device
		
		$isFingerPrintEnable = $this->Configuration->find('first',array('conditions'=>array('name'=>'isFingerPrintEnable')));
		$this->set('isFingerPrintEnable',$isFingerPrintEnable['Configuration']['value']);
	}
	
	
public function patient_overview() {
// 		$this->layout = false;
$this->layout = 'advance';
$this->loadModel('Disposition');
		$this->uses = array('Patient', 'DoctorProfile', 'Person', 'Department', 'DischargeSummary', 'Disposition','FinalBilling');
		App::import('Vendor', 'DrmhopeDB');
		$hopeDB = new DrmhopeDB('db_HopeHospital');
		$ayushmanDB = new DrmhopeDB('db_Ayushman');
		$hopeDB->makeConnection($this->Patient);
		$hopeDB->makeConnection($this->DoctorProfile);
		$hopeDB->makeConnection($this->Disposition);
		$hopeDB->makeConnection($this->DischargeSummary);
		$hopeDB->makeConnection($this->FinalBilling);
		$ayushmanDB->makeConnection($this->Department);
    	$today = date('Y-m-d'); 
		$startDate = isset($this->request->query['start_date']) ? $this->request->query['start_date'] : '';
		$endDate   = isset($this->request->query['end_date']) ? $this->request->query['end_date'] : '';	
	if (!empty($startDate) && !empty($endDate)) {
    $conditionsDate = array(
        'OR' => array(
            array(
                'Patient.admission_type' => 'IPD',
                'DATE(Patient.discharge_date) >=' => $startDate,
                'DATE(Patient.discharge_date) <=' => $endDate,
                // Agar yahan extra conditions apply karni ho to add karein
                'Disposition.review_date !=' => $today,
                'FinalBilling.reason_of_discharge !=' => 'Death'
            ),
            array(
                'Patient.admission_type' => 'OPD',
                'DATE(Patient.create_time) >=' => $startDate,
                'DATE(Patient.create_time) <=' => $endDate,
                // Agar yahan extra conditions apply karni ho to add karein
                'Disposition.review_date !=' => $today,
                'FinalBilling.reason_of_discharge !=' => 'Death'
            )
        )
    );
} else {
    // Default functionality: use the last 5 days
    $fiveDaysAgo = date('Y-m-d', strtotime('-5 days'));

$conditionsDate = array(
    'OR' => array(
        // IPD group: Saare conditions true hone chahiye
        array(
            'Patient.admission_type' => 'IPD',
            'DATE(Patient.discharge_date)' => $fiveDaysAgo,
             'Patient.is_call' => '',
            // 'Disposition.review_date !=' => $today,
            'FinalBilling.reason_of_discharge !=' => 'Death'
        )
        ,
        // // OPD group: Saare conditions true hone chahiye
        array(
            'Patient.admission_type' => 'OPD',
            'Patient.is_call' => '',
            'DATE(Patient.create_time)' => $fiveDaysAgo
            // 'Disposition.review_date !=' => $today
        )
    )
);

}

// 			debug($conditionsDate);
		$hopePatients = $this->Patient->find('all', array(
			'fields' => array(
				'Patient.admission_type', 'Patient.id', 'Person.id', 'Patient.discharge_date','Patient.create_time', 'Patient.create_time',
				'Person.first_name', 'Person.mobile', 'Person.last_name', 'Department.name', 'DischargeSummary.reason_of_discharge','DischargeSummary.final_diagnosis',
				'Disposition.budget_amount', 'Disposition.queue_date', 'Disposition.review_date', 'Disposition.disposition', 'Disposition.sub_disposition',
				'Disposition.remark', 'Disposition.call_assigned_to', 'DispositionList.name AS disposition_name',
				'SubDispositionList.name AS sub_disposition_name','FinalBilling.patient_id','FinalBilling.reason_of_discharge','Person.relationship_manager'
			),
			'conditions' => $conditionsDate,
			'joins' => array(
				array(
					'table' => 'persons',
					'alias' => 'Person',
					'type' => 'LEFT',
					'conditions' => array('Patient.person_id = Person.id')
				),
				array(
					'table' => 'departments',
					'alias' => 'Department',
					'type' => 'LEFT',
					'conditions' => array('Patient.department_id = Department.id')
				),
				array(
					'table' => 'discharge_summaries',
					'alias' => 'DischargeSummary',
					'type' => 'LEFT',
					'conditions' => array('Patient.id = DischargeSummary.patient_id')
				),
				array(
					'table' => '(SELECT * FROM despositions AS DispositionLatest WHERE id IN (
									SELECT MAX(id) FROM despositions GROUP BY patient_id
								))',
					'alias' => 'Disposition',
					'type' => 'LEFT',
					'conditions' => array('Patient.id = Disposition.patient_id')
				),
				array(
					'table' => 'disposition_list',
					'alias' => 'DispositionList',
					'type' => 'LEFT',
					'conditions' => array('Disposition.disposition = DispositionList.id')
				),
				array(
					'table' => 'sub_disposition_list',
					'alias' => 'SubDispositionList',
					'type' => 'LEFT',
					'conditions' => array('Disposition.sub_disposition = SubDispositionList.id')
				),				
				array(
					'table' => 'final_billings', 
					'alias' => 'FinalBilling',
					'type' => 'LEFT',
					'conditions' => array('FinalBilling.patient_id = Patient.id') // Join condition using patient_id as foreign key
				)
			)
		));
// 		debug($hopePatients);exit;
		foreach ($hopePatients as &$patient) {
			$patient['Patient']['hospital_name'] = 'db_HopeHospital';
			$patient['Patient']['database'] = 'db_HopeHospital';
		}
		$ayushmanDB->makeConnection($this->Patient);
		$newPatients = $this->Patient->find('all', array(
			'fields' => array(
				'Patient.admission_type', 'Patient.id', 'Person.id', 'Patient.discharge_date', 'Patient.create_time',
				'Person.first_name', 'Person.mobile', 'Person.last_name', 'Department.name', 'DischargeSummary.reason_of_discharge',
				'Disposition.budget_amount', 'Disposition.queue_date', 'Disposition.review_date', 'Disposition.disposition', 'Disposition.sub_disposition',
				'Disposition.call_assigned_to', 'DispositionList.name AS disposition_name',
				'SubDispositionList.name AS sub_disposition_name','FinalBilling.patient_id','FinalBilling.reason_of_discharge','Person.relationship_manager'
			),
			'conditions' => $conditionsDate,
			'joins' => array(
				array(
					'table' => 'persons',
					'alias' => 'Person',
					'type' => 'LEFT',
					'conditions' => array('Patient.person_id = Person.id')
				),
				array(
					'table' => 'departments',
					'alias' => 'Department',
					'type' => 'LEFT',
					'conditions' => array('Patient.department_id = Department.id')
				),
				array(
					'table' => 'discharge_summaries',
					'alias' => 'DischargeSummary',
					'type' => 'LEFT',
					'conditions' => array('Patient.id = DischargeSummary.patient_id')
				),
				array(
					'table' => '(SELECT * FROM despositions AS DispositionLatest WHERE id IN (SELECT MAX(id) FROM despositions GROUP BY patient_id ))',
					'alias' => 'Disposition',
					'type' => 'LEFT',
					'conditions' => array('Patient.id = Disposition.patient_id')
				),
				array(
					'table' => 'disposition_list',
					'alias' => 'DispositionList',
					'type' => 'LEFT',
					'conditions' => array('Disposition.disposition = DispositionList.id')
				),
				array(
					'table' => 'sub_disposition_list',
					'alias' => 'SubDispositionList',
					'type' => 'LEFT',
					'conditions' => array('Disposition.sub_disposition = SubDispositionList.id')
				),
				array(
					'table' => 'final_billings', 
					'alias' => 'FinalBilling',
					'type' => 'LEFT',
					'conditions' => array('FinalBilling.patient_id = Patient.id') // Join condition using patient_id as foreign key
				)
			)
		));
		foreach ($newPatients as &$patient) {
			$patient['Patient']['hospital_name'] = 'db_Ayushman';
			$patient['Patient']['database'] = 'db_Ayushman';
		}
		$this->loadModel('DispositionList');
		$this->loadModel('SubDispositionList');
		$dispositions = $this->DispositionList->find('all');
		$this->set('dispositions', $dispositions);	
		$allPatients = array_merge($hopePatients, $newPatients);
		$this->set('patient_overview', $allPatients);
		
		$this->loadModel('FinalBilling');
		$this->loadModel('Patient');
		$page = isset($this->request->query['page']) ? $this->request->query['page'] : 1;
		$perPage = ''; 
		$limit = $perPage;
		$offset = ($page - 1) * $perPage;
		$finalPaymentData = $this->FinalBilling->find('all', array(
			'fields' => array(
				'FinalBilling.id', 'FinalBilling.patient_id', 'FinalBilling.reason_of_discharge', // Final payment table columns
				'Patient.id', 'Patient.lookup_name' // Patient table columns
			),
			'joins' => array(
				array(
					'table' => 'patients', 
					'alias' => 'Patient',
					'type' => 'LEFT',
					'conditions' => array('FinalBilling.patient_id = Patient.id') // Join condition using patient_id as foreign key
				)
			),
			'limit' => $limit,
			'offset' => $offset,
			'order' => array('FinalBilling.id' => 'ASC')
		));
		$totalRecords = $this->FinalBilling->find('count');
		$totalPages = ceil($totalRecords / $perPage);
		$this->set('finalPaymentData', $finalPaymentData);
		$this->set('currentPage', $page);
		$this->set('totalPages', $totalPages);

		$this->getPatients();
		$this->call_history();
		//  debug($getdata);exit;
		$this->render('patient_overview');
		
	}

	public function getPatients() {
		$this->layout = false;
		$this->loadModel('Disposition');
		$this->uses = array('Patient', 'DoctorProfile', 'Person', 'Department', 'DischargeSummary', 'Disposition','FinalBilling');
		
		// Define connections
		App::import('Vendor', 'DrmhopeDB');
		
		// Database connections
		$hopeDB = new DrmhopeDB('db_HopeHospital');
		$ayushmanDB = new DrmhopeDB('db_Ayushman');
		
		// Connect models to respective databases
		$hopeDB->makeConnection($this->Patient);
		$hopeDB->makeConnection($this->DoctorProfile);
		$hopeDB->makeConnection($this->Disposition);
		$hopeDB->makeConnection($this->DischargeSummary);
		$hopeDB->makeConnection($this->FinalBilling);
		$ayushmanDB->makeConnection($this->Department);
		
		$today = date('Y-m-d'); 
		
		// Check if date filters are provided (using GET parameters)
		$startDate = isset($this->request->query['start_date']) ? $this->request->query['start_date'] : '';
		$endDate   = isset($this->request->query['end_date']) ? $this->request->query['end_date'] : '';
		
		if (!empty($startDate) && !empty($endDate)) {
			// Use the provided date range for filtering
			$conditionsDate = array(
				'OR' => array(
					array(
						'Patient.admission_type' => 'IPD',
						'DATE(Patient.discharge_date) >=' => $startDate,
						'DATE(Patient.discharge_date) <=' => $endDate
					),
					array(
						'Patient.admission_type' => 'OPD',
						'DATE(Patient.create_time) >=' => $startDate,
						'DATE(Patient.create_time) <=' => $endDate
					)
				)
			);
		} else {
			// Default functionality: use the last 5 days
			$fiveDaysAgo = date('Y-m-d', strtotime('-5 days'));
			$conditionsDate = array(
				'OR' => array(
					array('Patient.admission_type' => 'IPD', 'DATE(Patient.discharge_date)' => $fiveDaysAgo),
					array('Patient.admission_type' => 'OPD', 'DATE(Patient.create_time)' => $fiveDaysAgo)
				)
			);
		}
		
		// Fetching Hope Hospital patients
		$hopePatients = $this->Patient->find('all', array(
			'fields' => array(
				'Patient.id AS patient_id', 'Person.id AS person_id', 'Person.first_name', 'Person.mobile', 'Person.last_name',
				'Patient.admission_type', 'Department.name AS department_name', 'FinalBilling.reason_of_discharge','FinalBilling.create_time',
				'Disposition.budget_amount', 'Disposition.queue_date', 'Disposition.review_date', 'Disposition.disposition',
				'Disposition.sub_disposition', 'Disposition.remark', 'Disposition.call_assigned_to',
				'DispositionList.name AS disposition_name', 'SubDispositionList.name AS sub_disposition_name','Patient.create_time','Patient.id','Person.relationship_manager'
			),
			// 'conditions' => $conditionsDate,
			'joins' => array(
				array(
					'table' => 'persons',
					'alias' => 'Person',
					'type' => 'LEFT',
					'conditions' => array('Patient.person_id = Person.id')
				),
				array(
					'table' => 'departments',
					'alias' => 'Department',
					'type' => 'LEFT',
					'conditions' => array('Patient.department_id = Department.id')
				),
				array(
					'table' => 'discharge_summaries',
					'alias' => 'DischargeSummary',
					'type' => 'LEFT',
					'conditions' => array('Patient.id = DischargeSummary.patient_id')
				),
				array(
					'table' => '(SELECT * FROM despositions AS DispositionLatest WHERE id IN (
									SELECT MAX(id) FROM despositions GROUP BY patient_id
								))',
					'alias' => 'Disposition',
					'type' => 'LEFT',
					'conditions' => array('Patient.id = Disposition.patient_id')
				),
				array(
					'table' => 'disposition_list',
					'alias' => 'DispositionList',
					'type' => 'LEFT',
					'conditions' => array('Disposition.disposition = DispositionList.id')
				),
				array(
					'table' => 'sub_disposition_list',
					'alias' => 'SubDispositionList',
					'type' => 'LEFT',
					'conditions' => array('Disposition.sub_disposition = SubDispositionList.id')
				),
				array(
					'table' => 'final_billings',
					'alias' => 'FinalBilling',
					'type' => 'LEFT',
					'conditions' => array('Patient.id = FinalBilling.patient_id')
				)
			)
		));
		// debug($hopePatients);exit;
		foreach ($hopePatients as &$patient) {
			$patient['Patient']['hospital_name'] = 'db_HopeHospital';
			$patient['Patient']['database'] = 'db_HopeHospital';
		}
	
		// Fetching Ayushman Hospital patients
		$ayushmanDB->makeConnection($this->Patient);
		$newPatients = $this->Patient->find('all', array(
			'fields' => array(
				'Patient.id AS patient_id', 'Person.id AS person_id', 'Person.first_name', 'Person.mobile', 'Person.last_name',
				'Patient.admission_type', 'Department.name AS department_name', 'FinalBilling.reason_of_discharge','FinalBilling.create_time',
				'Disposition.budget_amount', 'Disposition.queue_date', 'Disposition.review_date', 'Disposition.disposition',
				'Disposition.sub_disposition', 'Disposition.remark', 'Disposition.call_assigned_to',
				'DispositionList.name AS disposition_name', 'SubDispositionList.name AS sub_disposition_name','Patient.create_time','Patient.id','Person.relationship_manager'
			),
			// 'conditions' => $conditionsDate,
			'joins' => array(
				array(
					'table' => 'persons',
					'alias' => 'Person',
					'type' => 'LEFT',
					'conditions' => array('Patient.person_id = Person.id')
				),
				array(
					'table' => 'departments',
					'alias' => 'Department',
					'type' => 'LEFT',
					'conditions' => array('Patient.department_id = Department.id')
				),
				array(
					'table' => 'discharge_summaries',
					'alias' => 'DischargeSummary',
					'type' => 'LEFT',
					'conditions' => array('Patient.id = DischargeSummary.patient_id')
				),
				array(
					'table' => '(SELECT * FROM despositions AS DispositionLatest WHERE id IN (SELECT MAX(id) FROM despositions GROUP BY patient_id ))',
					'alias' => 'Disposition',
					'type' => 'LEFT',
					'conditions' => array('Patient.id = Disposition.patient_id')
				),
				array(
					'table' => 'disposition_list',
					'alias' => 'DispositionList',
					'type' => 'LEFT',
					'conditions' => array('Disposition.disposition = DispositionList.id')
				),
				array(
					'table' => 'sub_disposition_list',
					'alias' => 'SubDispositionList',
					'type' => 'LEFT',
					'conditions' => array('Disposition.sub_disposition = SubDispositionList.id')
				)
				,
				array(
					'table' => 'final_billings',
					'alias' => 'FinalBilling',
					'type' => 'LEFT',
					'conditions' => array('Patient.id = FinalBilling.patient_id')
				)
			)
		));
		// debug($newPatients);exit;
	
		foreach ($newPatients as &$patient) {
			$patient['Patient']['hospital_name'] = 'db_Ayushman';
			$patient['Patient']['database'] = 'db_Ayushman';
		}
	
		// Merging both hospital's patients into one list
		$allPatients_new = array_merge($hopePatients, $newPatients);
		// debug($allPatients);exit;
		$this->set('patient_overview_getpatient', $allPatients_new);
	
		// // Returning the patients as JSON response
		// echo json_encode(['patients' => $allPatients]);
		// exit;
	}
	public function getSubDispositions($dispositionId) {
		$this->loadModel('SubDispositionList'); 
		$subDispositions = $this->SubDispositionList->find('all', [
// 			'conditions' => ['SubDispositionList.disposition_id' => $dispositionId]
		]);
	
// 	debug($subDispositions);exit;
		// Return JSON response
		echo json_encode(array_map(function ($item) {
			return [
				'id' => $item['SubDispositionList']['id'],
				'name' => $item['SubDispositionList']['name']
			];
		}, $subDispositions));
		exit;
	}

	
	
	public function addCompany() {

		$this->autoRender = false;
	
		if ($this->request->is('ajax')) {
			$companyName = $this->request->data('company_name');
	
			$this->loadModel('CompanyName'); // Load the CompanyName model
			$data = ['company_name' => $companyName]; // Use `company_name` column
	
			if ($this->CompanyName->save($data)) {
				echo json_encode([
					'status' => 'success',
					'id' => $this->CompanyName->id,
					'company_name' => $companyName // Correct key for the response
				]);
			} else {
				echo json_encode([
					'status' => 'error',
					'message' => 'Unable to save the company.'
				]);
			}
		}
	}
	
	public function getCompanies() {
		$this->autoRender = false;
		$this->loadModel('CompanyName');
		$companies = $this->CompanyName->find('all', [
			'fields' => ['CompanyName.company_name']
		]);
	
		if (!empty($companies)) {
			$result = [];
			foreach ($companies as $company) {
				$result[] = [
					'company_name' => $company['CompanyName']['company_name']
				];
			}
	//  debug($result);exit;
			echo json_encode([
				'status' => 'success',
				'companies' => $result
			]);
		} else {
			echo json_encode([
				'status' => 'error',
				'message' => 'No companies found.'
			]);
		}
	}
	
	public function getDesignations() {
		$this->autoRender = false;
	
		$this->loadModel('CompanyDesignation'); // Load the CompanyDesignation model
	
		$designations = $this->CompanyDesignation->find('all', [
			'fields' => ['id', 'designation']
		]);
	
		if (!empty($designations)) {
			$result = [];
			foreach ($designations as $designation) {
				$result[] = [
					'id' => $designation['CompanyDesignation']['id'],
					'name' => $designation['CompanyDesignation']['designation']
				];
			}
			// debug($result);exit;
			echo json_encode([
				'status' => 'success',
				'designations' => $result
			]);
		} else {
			echo json_encode([
				'status' => 'error',
				'message' => 'No designations found.'
			]);
		}
	}
	
	public function save_new_disposition() {
		if ($this->request->is('post')) {
			$this->loadModel('DispositionList');
			$this->loadModel('SubDispositionList');
	
			$data = $this->request->data;
			
			$hospitalName = $data['hospital_name'];
			$dispositionName = $data['disposition_name'];
			$subDispositions = $data['sub_disposition'];
	
			// Start Transaction
			$dataSource = $this->DispositionList->getDataSource();
			$dataSource->begin();
			debug($data);
			try {
				// Save Disposition
				$this->DispositionList->create();
				$this->DispositionList->save([
					'hospital' => $hospitalName,
					'name' => $dispositionName
				]);
				$dispositionId = $this->DispositionList->id;
	
				// Save Sub-Dispositions
				foreach ($subDispositions as $subDispositionName) {
					if (!empty($subDispositionName)) {
						$this->SubDispositionList->create();
						$this->SubDispositionList->save([
							'disposition_id' => $dispositionId,
							'name' => $subDispositionName
						]);
					}
				}
				
				// Commit Transaction
				$dataSource->commit();
				$this->Session->setFlash(__('Record added Successfully', true));
				// $this->Flash->success('Disposition and Sub-Dispositions added successfully.');
				// debug($dispositionId);exit;
			} catch (Exception $e) {
				exit;
				// Rollback Transaction
				$dataSource->rollback();
				$this->Flash->error('An error occurred: ' . $e->getMessage());
			}
	
			// Redirect to a relevant page
			return $this->redirect(['action' => 'patient_overview']);
		}
	}
	
	public function download_excel_data() {
		$this->autoRender = false; // Disable view rendering
		$this->response->type('application/vnd.ms-excel');
		$this->response->download('data_export_' . date('Y-m-d') . '.xls');
	
		// Load required models
		$this->loadModel('Disposition');
		$this->loadModel('DispositionList');
		$this->loadModel('Patient');
	
		// Get date range from POST request
		$startDate = $this->request->data['start_date'];
		$endDate = $this->request->data['end_date'];
	
		// Fetch data based on date range
		$data = $this->Disposition->find('all', array(
			'fields' => array(
				'Disposition.call_assigned_to',
				'Disposition.created_at',
				'Disposition.mobile',
				'Disposition.patien_name',
				// 'Disposition.location',
				'Disposition.remark',
				'Disposition.queue_date',
				'IFNULL(DispositionList.name, "Unknown") AS disposition_name' // Handle NULL disposition names
			),
			'conditions' => array(
				'DATE(Disposition.created_at) >=' => $startDate,
				'DATE(Disposition.created_at) <=' => $endDate
			),
			'joins' => array(
				array(
					'table' => 'disposition_list', // Name of the table where disposition names are stored
					'alias' => 'DispositionList',
					'type' => 'LEFT',
					'conditions' => array(
						'Disposition.disposition = DispositionList.id' // Match IDs to get names
					)
				)
			),
			'order' => array('Disposition.created_at' => 'ASC')
		));
	
		// Debug to verify data
		// debug($data); exit;
	
		// Write data to Excel format
		$output = "Sr No\tAgent\tDate\tDisposition\tPhone\tCustomer Name\tDetail Feedback\tTaken Follow Up\n";
		$srNo = 1;
		foreach ($data as $record) {
			$output .= $srNo++ . "\t" .
					   h($record['Disposition']['call_assigned_to']) . "\t" .
					   h($record['Disposition']['created_at']) . "\t" .
					   h($record[0]['disposition_name']) . "\t" . // Fetch disposition name
					   h($record['Disposition']['mobile']) . "\t" .
					   h($record['Disposition']['patien_name']) . "\t" .
					   //h($record['Disposition']['location']) . "\t" .
					   h($record['Disposition']['remark']) . "\t" .
					   h($record['Disposition']['queue_date']) . "\n";
		}
	
		// Set response body
		$this->response->body($output);
		return $this->response;
	}
	
	public function updateDischargeReason() {
		$this->autoRender = false;
		$this->layout = false;
	
		if ($this->request->is('post')) {
			$patientId = $this->request->data['patient_id'];
			$hospitalName = $this->request->data['hospital_name'];
			$reason = $this->request->data['reason_of_discharge'];
	
			// Log the database being used and the patient details
			debug('Database Connection: ' . $hospitalName); // Logs the database name (e.g., 'db_HopeHospital')
			debug('Patient ID: ' . $patientId); // Logs the patient ID
			debug('Reason of Discharge: ' . $reason); // Logs the discharge reason
	
			// Import Vendor and set up DB connection
			App::import('Vendor', 'DrmhopeDB');
			$database_connection = new DrmhopeDB($hospitalName);
			$database_connection->makeConnection($this->FinalBilling);
	
			// debug($database_connection);
			// Load DischargeSummary model and switch to the correct database connection
			$this->loadModel('DischargeSummary');
			$this->FinalBilling->setDataSource($hospitalName);
	
			// Fetch the patient record from the correct database
			$patient = $this->FinalBilling->find('first', [
				'conditions' => ['FinalBilling.patient_id' => $patientId]
			]);
			if ($patient) {
				$this->FinalBilling->id = $patient['FinalBilling']['id'];
	
				// Attempt to update the discharge reason
				if ($this->FinalBilling->save(['reason_of_discharge' => $reason])) {

					// debug('Patient Data: ' . print_r($patient, true)); // Log the fetched patient details
			
			// Halt execution here to review the debug output
			// exit; // Prevents
					$this->Session->setFlash(__('Death added successfully', true), true, array('class' => 'message'));
					echo json_encode(['success' => true, 'message' => 'Discharge reason updated successfully!']);
				} else {
					$this->Session->setFlash(__('Death Data Not added ', true), true, array('class' => 'message'));
					echo json_encode(['success' => false, 'message' => 'Failed to update discharge reason.']);
				}
			} else {
				$this->Session->setFlash(__('Patient not found', true), true, array('class' => 'message'));
				echo json_encode(['success' => false, 'message' => 'Patient not found.']);
			}
		}
	}
	

	public function get_finall_payment_data() {
		$this->loadModel('FinalBilling');
		$this->loadModel('Patient');
		$page = isset($this->request->query['page']) ? $this->request->query['page'] : 1;
		$perPage = 10; 
		$limit = $perPage;
		$offset = ($page - 1) * $perPage;
		$finalPaymentData = $this->FinalBilling->find('all', array(
			'fields' => array(
				'FinalBilling.id', 'FinalBilling.patient_id', 'FinalBilling.reason_of_discharge', // Final payment table columns
				'Patient.id', 'Patient.lookup_name' // Patient table columns
			),
			'joins' => array(
				array(
					'table' => 'patients', 
					'alias' => 'Patient',
					'type' => 'LEFT',
					'conditions' => array('FinalBilling.patient_id = Patient.id') // Join condition using patient_id as foreign key
				)
			),
			'limit' => $limit,
			'offset' => $offset,
			'order' => array('FinalBilling.id' => 'ASC')
		));
		$totalRecords = $this->FinalBilling->find('count');
		$totalPages = ceil($totalRecords / $perPage);
		$this->set('finalPaymentData', $finalPaymentData);
		$this->set('currentPage', $page);
		$this->set('totalPages', $totalPages);
	}
	
	
	
	// public function updateReasonOfDischarge() {
	// 	$this->autoRender = false;
	
	// 	if ($this->request->is('post')) {
	// 		// Get the data from the request
	// 		// debug($this->request->data);
	// 		$paymentId = $this->request->data['payment_id'];
	// 		$patientId = $this->request->data['patient_id'];
	// 		$reason = $this->request->data['reason_of_discharge'];
	
	// 		// Load the FinalBilling model to update the reason
	// 		$this->loadModel('FinalBilling');
	
	// 		// Establish connection to db_HopeHospital using DrmhopeDB model (or custom DB connection setup)
	// 		App::import('Vendor', 'DrmhopeDB');
	// 		$hopeDB = new DrmhopeDB('db_HopeHospital'); // assuming DrmhopeDB is a class that connects to db_HopeHospital
	// //  debug($hopeDB);
	// 		// Use the established connection for FinalBilling model
	// 		$hopeDB->makeConnection($this->FinalBilling); // Connecting to the FinalBilling table in the db_HopeHospital
	
	// 		// Find the payment record by payment ID from db_HopeHospital
	// 		$payment = $this->FinalBilling->findById($paymentId);
	
			
	// 		if ($payment) {
	// 			// Update the reason of discharge
	// 			$payment['FinalBilling']['reason_of_discharge'] = $reason;
				
	// 			if ($this->FinalBilling->save($payment)) {
	// 				// Return success response
	// 				// debug($payment);exit;
	// 				echo json_encode(['success' => true]);
	// 			} else {
	// 				// Return failure response
	// 				echo json_encode(['success' => false]);
	// 			}
	// 		} else {
	// 			echo json_encode(['success' => false, 'message' => 'Payment record not found in db_HopeHospital.']);
	// 		}
	// 	}
	// }
	
	public function updateReasonOfDischarge() {
		$this->autoRender = false;
		$this->response->type('json');
		    $this->uses = array('Patient', 'DoctorProfile', 'Person', 'Department', 'DischargeSummary', 'Disposition','FinalBilling','SubDispositionList','DispositionList');

	
		if ($this->request->is('post')) {
			$patientId = isset($this->request->data['patient_id']) ? trim($this->request->data['patient_id']) : '';
			$hospitalName = isset($this->request->data['hospital_name']) ? trim($this->request->data['hospital_name']) : '';
			$reason = isset($this->request->data['reason_of_discharge']) ? trim($this->request->data['reason_of_discharge']) : '';
			if (empty($hospitalName) || empty($patientId) || empty($reason)) {
				echo json_encode(['status' => 'error', 'message' => 'Invalid input data']);
				return;
			}
			try {
				App::import('Vendor', 'DrmhopeDB');
				$hopeDB = new DrmhopeDB($hospitalName);
			
			} catch (Exception $e) {
				echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
				return;
			}
	
			$hopeDB->makeConnection($this->FinalBilling);
			$patientBilling = $this->FinalBilling->find('first', [
				'conditions' => ['FinalBilling.patient_id' => $patientId]
				// 'fields' => ['FinalBilling.id']
			]);
			// debug($patientBilling);exit;
	
			if (!$patientBilling) {
				echo json_encode(['status' => 'error', 'message' => 'Patient billing record not found']);
				return;
			}
	
			// **Step 4: Update the Reason of Discharge Securely**
			$this->FinalBilling->id = $patientBilling['FinalBilling']['id'];
			if ($this->FinalBilling->saveField('reason_of_discharge', htmlspecialchars($reason, ENT_QUOTES, 'UTF-8'))) {
				echo json_encode(['status' => 'success', 'message' => 'Updated successfully']);
			} else {
				echo json_encode(['status' => 'error', 'message' => 'Failed to update']);
			}
			return;
		}
	}
	
	public function getPatientsAjax() {
		$this->autoRender = false;
		$this->response->type('json');
	
		$this->loadModel('Patient');
	
		// **Server-side Pagination Variables**
		$limit = $_POST['length'];  // Number of records per page
		$start = $_POST['start'];   // Offset
		$orderColumnIndex = $_POST['order'][0]['column'];
		$orderDirection = $_POST['order'][0]['dir']; // asc or desc
	
		// **Mapping Column Index to Database Fields**
		$columns = ['Patient.id', 'Person.first_name', 'Patient.hospital_name', 'Patient.create_time', 
					'FinalBilling.create_time', 'Person.mobile', '', '', 'Disposition.create_time', ''];
	
		$orderColumn = $columns[$orderColumnIndex];
	
		// **Fetching Patient Data with Pagination**
		$patients = $this->Patient->find('all', [
			'contain' => ['Person', 'FinalBilling', 'Disposition'],
			'limit' => $limit,
			'offset' => $start,
			'order' => [$orderColumn => $orderDirection]
		]);
	
		// **Fetching Total Record Count**
		$totalRecords = $this->Patient->find('count');
	
		// **Format Data for DataTables**
		$data = [];
		$srNo = $start + 1;
		foreach ($patients as $patient) {
			$data[] = [
				"srNo" => $srNo++,
				"name" => h($patient['Person']['first_name'] . ' ' . $patient['Person']['last_name']),
				"hospital_name" => h($patient['Patient']['hospital_name']),
				"create_time" => h($patient['Patient']['create_time']),
				"discharge_time" => h($patient['FinalBilling']['create_time']),
				"mobile" => h($patient['Person']['mobile']),
				"relationship_manager" => "Ashwin Dahikar",
				"view" => '<span class="badge badge-primary">View</span>',
				"add" => '<span class="badge badge-info">Add</span>',
				"called_on" => h($patient['Disposition']['create_time']),
				"update_reason" => '<select class="form-control reason_of_discharge" data-patient-id="' . $patient['Patient']['id'] . '" data-hospital-name="' . h($patient['Patient']['hospital_name']) . '">
							<option value="">Select Reason</option>
							<option value="Recovered">Recovered</option>
							<option value="Transferred">Transferred</option>
							<option value="Left Against Medical Advice (LAMA)">Left Against Medical Advice (LAMA)</option>
							<option value="Expired">Expired</option>
						</select>
						<button class="btn btn-success btn-sm update-discharge" data-patient-id="' . $patient['Patient']['id'] . '">
							<i class="fas fa-check"></i> Update
						</button>'
			];
		}
	
		// **Return JSON Data**
		echo json_encode([
			"draw" => intval($_POST['draw']),
			"recordsTotal" => $totalRecords,
			"recordsFiltered" => $totalRecords,
			"data" => $data
		]);
	}
	
	
	
public function getPatientDetails() {
    $this->autoRender = false; // No CakePHP View rendering
    $this->layout = 'ajax';

    if ($this->request->is('post')) {
        $patientId = $this->request->data['patient_id'];
        $hospitalName = $this->request->data['hospital_name'];

        $this->loadModel('Patient'); // Load Patient Model if not already loaded

        $patient = $this->Patient->find('first', array(
            'conditions' => array(
                'Patient.id' => $patientId,
                'Patient.hospital_name' => $hospitalName
            ),
            'fields' => array(
                'Patient.id', 'Patient.hospital_name', 'Patient.create_time',
                'Person.first_name', 'Person.last_name', 'Person.mobile',
                'FinalBilling.create_time', 'Disposition.create_time'
            ),
            'joins' => array(
                array(
                    'table' => 'persons',
                    'alias' => 'Person',
                    'type' => 'LEFT',
                    'conditions' => array('Person.id = Patient.person_id')
                ),
                array(
                    'table' => 'final_billings',
                    'alias' => 'FinalBilling',
                    'type' => 'LEFT',
                    'conditions' => array('FinalBilling.patient_id = Patient.id')
                ),
                array(
                    'table' => 'dispositions',
                    'alias' => 'Disposition',
                    'type' => 'LEFT',
                    'conditions' => array('Disposition.patient_id = Patient.id')
                )
            )
        ));

        if ($patient) {
            echo json_encode(array(
                "success" => true,
                "name" => $patient['Person']['first_name'] . " " . $patient['Person']['last_name'],
                "hospital" => $patient['Patient']['hospital_name'],
                "visited_date" => $patient['Patient']['create_time'],
                "discharge_date" => isset($patient['FinalBilling']['create_time']) ? $patient['FinalBilling']['create_time'] : 'N/A',
                "mobile" => $patient['Person']['mobile'],
                "relationship_manager" => "Ashwin Dahikar",
                "disposition_date" => isset($patient['Disposition']['create_time']) ? $patient['Disposition']['create_time'] : 'N/A'
            ));
        } else {
            echo json_encode(array("success" => false));
        }
    }
}


    public function fetchDispositionData() {
    $this->autoRender = false;
    $this->response->type('json');
    $this->uses = array('Patient', 'DoctorProfile', 'Person', 'Department', 'DischargeSummary', 'Disposition','FinalBilling','SubDispositionList','DispositionList');

    if ($this->request->is('post')) {
        $patientId = isset($this->request->data['patient_id']) ? trim($this->request->data['patient_id']) : '';
        $hospitalName = isset($this->request->data['hospital_name']) ? trim($this->request->data['hospital_name']) : '';

        if (empty($hospitalName) || empty($patientId)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid input data']);
            return;
        }

        try {
            App::import('Vendor', 'DrmhopeDB');
            $hopeDB = new DrmhopeDB($hospitalName);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
            return;
        }

        // Connect to the hospital database
        $hopeDB->makeConnection($this->Disposition);
        $hopeDB->makeConnection($this->DispositionList);
        $hopeDB->makeConnection($this->SubDispositionList);

        // Fetch dispositions
        $dispositions = $this->Disposition->find('all', [
            'conditions' => ['Disposition.patient_id' => $patientId],
            'fields' => [
                'Disposition.created_at',
                'Disposition.patien_name',
                'Disposition.disposition',
                'Disposition.sub_disposition',
                'Disposition.outcome',
                'Disposition.follow_up_date',
                'Disposition.remark',
                 'Disposition.budget_amount',
                'Disposition.queue_date',
                'Disposition.call_assigned_to',
                'DispositionList.name AS disposition_name',  
                'SubDispositionList.name AS sub_disposition_name' 
            ],
            'joins' => [
                [
                    'table' => 'disposition_list',
                    'alias' => 'DispositionList',
                    'type' => 'LEFT',
                    'conditions' => ['DispositionList.id = Disposition.disposition']
                ],
                [
                    'table' => 'sub_disposition_list',
                    'alias' => 'SubDispositionList',
                    'type' => 'LEFT',
                    'conditions' => ['Disposition.sub_disposition = SubDispositionList.id']
                ]
            ]
        ]);

        if (!empty($dispositions)) {
            $result = [];
            foreach ($dispositions as $row) {
                $result[] = [
                    'date' => $row['Disposition']['created_at'],
                    'patient_name' => $row['Disposition']['patien_name'],
                    'disposition' => $row['Disposition']['disposition'],
                    'sub_disposition' => $row['Disposition']['sub_disposition'],
                    'disposition_name' => $row['DispositionList']['disposition_name'],  
                    'sub_disposition_name' => $row['SubDispositionList']['sub_disposition_name'], 
                    'outcome' => $row['Disposition']['outcome'],
                    'follow_up_date' => $row['Disposition']['follow_up_date'],
                    'remark' => $row['Disposition']['remark'],
                    'call_assigned_to' => $row['Disposition']['call_assigned_to'],
                     'queue_date' => $row['Disposition']['queue_date'],
                     'budget_amount' => $row['Disposition']['budget_amount']
                     
                ];
            }
            echo json_encode(['status' => 'success', 'data' => $result]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No disposition records found']);
        }
        return;
    }
}


public function call_history() {
    $this->autoRender = false;
    $this->loadModel('Disposition');
    		$this->uses = array('Patient', 'DoctorProfile', 'Person', 'Department', 'DischargeSummary', 'Disposition','FinalBilling','SubDispositionList','DispositionList');

    App::import('Vendor', 'DrmhopeDB');
    $hopeDB = new DrmhopeDB('db_HopeHospital');
    $ayushmanDB = new DrmhopeDB('db_Ayushman');
    $selected_date = isset($this->request->data['selected_date']) ? $this->request->data['selected_date'] : date('Y-m-d');
    $formatted_date = date('Y-m-d', strtotime($selected_date));
    $hopeDB->makeConnection($this->Disposition);
    $hopeDB->makeConnection($this->DispositionList);
    $hopeDB->makeConnection($this->SubDispositionList);
      $conditions = [];
    if ($formatted_date) {
        $conditions['Disposition.follow_up_date'] = $formatted_date; // Apply filter if a date is selected
    }
    $today = date('Y-m-d');
    $call_history_hope = $this->Disposition->find('all', [
            'conditions' => ['Disposition.follow_up_date' => $conditions],
            'fields' => [
                'Disposition.created_at',
                'Disposition.patien_name',
                'Disposition.disposition',
                'Disposition.sub_disposition',
                'Disposition.outcome',
                'Disposition.follow_up_date',
                'Disposition.remark',
                 'Disposition.budget_amount',
                'Disposition.queue_date',
                'Disposition.call_assigned_to',
                'DispositionList.name AS disposition_name',  
                'SubDispositionList.name AS sub_disposition_name' 
            ],
            'joins' => [
                [
                    'table' => 'disposition_list',
                    'alias' => 'DispositionList',
                    'type' => 'LEFT',
                    'conditions' => ['DispositionList.id = Disposition.disposition']
                ],
                [
                    'table' => 'sub_disposition_list',
                    'alias' => 'SubDispositionList',
                    'type' => 'LEFT',
                    'conditions' => ['Disposition.sub_disposition = SubDispositionList.id']
                ]
            ]
        ]);
    $ayushmanDB->makeConnection($this->Disposition);
    $ayushmanDB->makeConnection($this->DispositionList);
    $ayushmanDB->makeConnection($this->SubDispositionList);
    $call_history_ayushman = $this->Disposition->find('all', [
            'conditions' => ['Disposition.follow_up_date' => $conditions],
            'fields' => [
                'Disposition.created_at',
                'Disposition.patien_name',
                'Disposition.disposition',
                'Disposition.sub_disposition',
                'Disposition.outcome',
                'Disposition.follow_up_date',
                'Disposition.remark',
                 'Disposition.budget_amount',
                'Disposition.queue_date',
                'Disposition.call_assigned_to',
                'DispositionList.name AS disposition_name',  
                'SubDispositionList.name AS sub_disposition_name' 
            ],
            'joins' => [
                [
                    'table' => 'disposition_list',
                    'alias' => 'DispositionList',
                    'type' => 'LEFT',
                    'conditions' => ['DispositionList.id = Disposition.disposition']
                ],
                [
                    'table' => 'sub_disposition_list',
                    'alias' => 'SubDispositionList',
                    'type' => 'LEFT',
                    'conditions' => ['Disposition.sub_disposition = SubDispositionList.id']
                ]
            ]
        ]);
        
    $allPatients_call_history = array_merge($call_history_hope, $call_history_ayushman);
    $this->set('allPatients_call_history', $allPatients_call_history);
    $this->set('selected_date', $selected_date);
}

	
	public function certificate_form(){
        $this->layout = false; 
        $this->loadModel('FirstAidCertificate');
        App::import('Vendor', 'DrmhopeDB', array('file' => 'DrmhopeDB.php'));

        if ($this->Session->read('db_name')) {
            $db_connection = new DrmhopeDB($this->Session->read('db_name'));
        } else {
            $db_connection = new DrmhopeDB('db_hope');
        }

        $db_connection->makeConnection($this->FirstAidCertificate);

		if ($this->request->is('post')) {
			$this->FirstAidCertificate->create(); 
			// debug($this->request->data);
			
			$data = array(
				'FirstAidCertificate' => array(
					'certificate_number' => $this->FirstAidCertificate->find('count') + 1001,
					'candidate_name' => $this->request->data['FirstAidCertificate']['candidateName'],
					'guardian_name' => $this->request->data['FirstAidCertificate']['guardianName'],
					'training_center' => $this->request->data['FirstAidCertificate']['center'],
					'exam_date' => $this->request->data['FirstAidCertificate']['examDate']['year'] . '-' . $this->request->data['FirstAidCertificate']['examDate']['month'] . '-' . $this->request->data['FirstAidCertificate']['examDate']['day'],
					'mobile' => $this->request->data['FirstAidCertificate']['mobile'],
					'place' => $this->request->data['FirstAidCertificate']['place'],
					'relation' => $this->request->data['FirstAidCertificate']['relation']
				)
			);
			
			// debug($data);
			// exit;
			if ($this->FirstAidCertificate->save($data)) {
				$lastInsertedId = $this->FirstAidCertificate->getLastInsertID(); // Get last inserted ID
				$this->redirect(array('controller' => 'persons', 'action' => 'certificate', $lastInsertedId));
			} else {
				$this->Session->setFlash(__('Failed to save data. Please try again.'), 'default', array('class' => 'message error'));
			}
          }	
        }
    



public function certificate($id = null) {
	$this->layout = false;
	$this->loadModel('FirstAidCertificate');
	App::import('Vendor', 'DrmhopeDB', array('file' => 'DrmhopeDB.php'));

        if ($this->Session->read('db_name')) {
            $db_connection = new DrmhopeDB($this->Session->read('db_name'));
        } else {
            $db_connection = new DrmhopeDB('db_hope');
        }

        $db_connection->makeConnection($this->FirstAidCertificate);
		
	$certificateData = $this->FirstAidCertificate->find('first', array(
        'conditions' => array('FirstAidCertificate.id' => $id)
    ));
	$this->set('certificateData', $certificateData);
	// debug($certificateData);exit;
}
	
}
?>