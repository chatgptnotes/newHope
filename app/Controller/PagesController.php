<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('AppController', 'Controller');


/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Pages';

/**
 * Default helper
 *
 * @var array
 */
	public $helpers = array('Html', 'Session');

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();

/**
 * Displays a view
 *
 * @param mixed What page to display
 * @return void
 */
	
/*
 * this is for online registration by amit jain 
 */
	public $components = array('RequestHandler','Email','ImageUpload','DateFormat','QRCode','GibberishAES');
	
	public function beforeFilter() {
		
		$this->Auth->allow('display', 'cloud_computing', 'story_so_far','sms_registration','online_registration');
	}
	
	public function display() {
		$this->theme = false;
		$this->layout = 'cms';
		$path = func_get_args();
		$count = count($path);
		if (!$count) {
			$this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		//debug($path);die();
		$this->set(compact('page', 'subpage', 'title_for_layout','online_registration'));
		$this->render(implode('/', $path));
		
	}
	
	public function smime(){
		App::uses('CakeEmail', 'Network/Email');
		$Email = new CakeEmail('gmail');
		$Email->from(array('santoshy@drmhope.com' => 'DrmHope'));
		$Email->to('pankajw@drmhope.com');
		$Email->subject('Test Email');
		//$file =  file_get_contents(WWW_ROOT.'img'.DS.'Vinod Yaduwanshi_UHHO13C15009_single.xml') ;
		 
		//$Email->attachments(WWW_ROOT.'img'.DS.'Vinod Yaduwanshi_UHHO13C15009_single.xml');
		//$Email->addAttachments($file);
		/* $Email->attachments(array(
				'single.xml' => array(
						'file' => WWW_ROOT.'img'.DS.'Vinod Yaduwanshi_UHHO13C15009_single.xml',
						'mimetype' => 'application/xml',
						'contentId' => 'test1'
				)
		)); */
		
		
		#####################################################################################

		$data = "
		
        This email is Encrypted!
		
        You must have my certificate to view this email!
		
        pankaj pakaj pankaj";
		
		$fp = fopen("C:\msg.txt", "w");
		fwrite($fp, $data);
		fclose($fp);
		
		$headersArr = array("To" => "pankajw@drmhope.com",
				"From" => "pankajw@drmhope.com",
				"Subject" => "A signed and encrypted message.",
				'Content-type'=> "application/xml; charset=iso-8859-1",
				'MIME-Version:'=>'1.0');
		
		
		
		openssl_pkcs7_sign("C:\msg.txt", "C:\signed.txt", "file://c:/ccda/local/local_cert.pem",array("file://c:/ccda/local/local_key.key","hope"), $headersArr);
		// Get the public key certificate.
		$pubkey = file_get_contents("file://c:/ccda/local/local_cert.pem");
		
		//encrypt the message, now put in the headers.
		openssl_pkcs7_encrypt("C:\signed.txt", "C:\enc.txt",$pubkey,$headersArr,0,1);
		
		
		$Email->attachments(array(
				'patient.txt' => array(
						//'file' => WWW_ROOT.'img'.DS.'Vinod Yaduwanshi_UHHO13C15009_single.xml',
						'file'=>"C:\enc.txt",
						'mimetype' => 'application/text',
						'contentId' => 'test1'
				)
		));
		 
		
		$data = file_get_contents("C:\enc.txt");
		
		// separate header and body, to use with mail function
		//  unfortunate but required, else we have two sets of headers
		//  and the email client doesn't decode the attachment
		$parts = explode("\n\n", $data, 2); 
		
		$Email->setHeaders($parts[0]);
		$sent = $Email->send($parts[1]);
		if($sent) {
			echo "sent";
		} else {
			echo "fail";
		}
		exit;
		
	}
	
	public function sms_registration(){
		$this->layout=false;
		
	}
	
	public function online_registration4(){
		debug('hi');die();
		$this->set('title_for_layout', __('-UIDPatient Registration', true)); 
		//set database conenctino for online ref
		App::import('Vendor', 'DrmhopeDB');
		 //Configure::read('online_reg');
		
		//$dataSource = ConnectionManager::getDataSource('online_reg');
		//debug($dataSource);
		//$db_connection = new DrmhopeDB($dataSource->config['database']);
		//$db_connection->makeConnection($this->Page); 
		//$this->Session->write('db_name',$dataSource->config['database']); 
		//EOF online reg db settings
		
		$online = Configure::read('online_reg');
		$db_connection = new DrmhopeDB($online['database']);
		$db_connection->makeConnection($this->Page);
		
		$this->Session->write('db_name',$online['database']);
		
    	//load model    	
    	$this->uses = array('Initial','DoctorProfile','Consultant','City','District','ReffererDoctor','Location','Person');      
    	$this->set('initials',$this->Initial->find('list',array('fields'=>array('name'))));    
    	$this->set('doctors',$this->DoctorProfile->getDoctors()); 
    	$this->set('treatmentConsultant',$this->Consultant->find('list',array('CONCAT(Consultant.first_name," ",Consultant.last_name) as name')));
		$this->set('reffererdoctors',$this->ReffererDoctor->find('list',array('conditions' => array('ReffererDoctor.is_deleted' => 0, 'ReffererDoctor.is_referral' => 'Y'), 'fields' => array('ReffererDoctor.id', 'ReffererDoctor.name'))));
		//case summary and patient file
		$this->set('recordLink',$this->Location->find('first',array('fields'=>array('case_summery_link','patient_file'),'conditions'=>array('Location.id'=>$this->Session->read('locationid')),'recursive'=>-1)));
		//debug($this->request->data);
		//exit;
    	if(!empty($this->request->data)){ 
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
    		 //pr($this->request->data);exit;
    			//check other date field
          		$this->request->data['Person']['dob'] = $this->DateFormat->formatDate2STD($this->request->data['Person']['dob'],Configure::read('date_format'));
				//calculate age on the basis of entered DOB
				$this->request->data['Person']['age'] = $this->DateFormat->getAge($this->request->data['Person']['dob']) ;
			 
		   //if($this->request->data["Person"]['known_fam_physician']=='2'){
		   //		$this->request->data["Person"]['doctor_id']  =$this->request->data["Person"]['consultant_id']; 
		   //		$this->request->data["Person"]['consultant_id'] ='';
		   // } 
            //$this->request->data["Person"]['non_executive_emp_id_no'] = $this->request->data["Person"]['non_executive_emp_id_no'].$this->request->data["Person"]['suffix']; 	
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
		 		//debug($this->request->data);exit;
            	$this->Person->save($this->request->data); 
            	//$this->Session->setFlash(__('Registration Successful', true));
            	$mess = "Registration Successful"."<br>"."Email sent successfully on ".$this->request->data['Person']['email'];
            	//$this->Session->setFlash(__($mess, true));
            	$this->Session->setFlash(__($mess ),'default',array('class'=>'message'));
            	if($this->request->data['Person']['email']){
            	if($this->createCredentials($this->request->data['Person']['id'],$this->request->data['Person']['email'])){
            		//$this->Session->setFlash(__("Email sent successfully on ".$this->request->data['Person']['email_id']),'default',array('class'=>'message'));
            		$mess = "Email sent successfully on ".$this->request->data['Person']['email'];
            		$this->Session->setFlash(__($mess, true));
            	}
            	}else{
            		//$this->Session->setFlash(__("Could not send email"),'default',array('class'=>'message'));
            			$mess = "Could not send email ".$this->request->data['Person']['email'];
            			$this->Session->setFlash(__($mess, true));
            	}
            	
            	//debug($this->request->data);exit;
        		 {
             	 	$this->redirect(array("controller"=>"Users","action" => "/"));
                }
            }  	 
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
	
	
		//$patient_info=array('Patient'=>array('first_name'=>'Pankaj','admission_type'=>'IPD','location_id'=>1));
		//$this->loadModel('Patient');
		$count = $this->Person->find('count',array('conditions'=>array('Person.create_time like'=> "%".date("Y-m-d")."%",
				/*'Person.location_id'=>$this->Session->read('locationid')*/)));// ---- for same location initial name it creates duplicate uID---gaurav @pankaj
	
		if($count==0){
			$count = "001" ;
		}else if($count < 10 ){
			$count = "00$count"  ;
		}else if($count >= 10 && $count <100){
			$count = "0$count"  ;
		}
			
		$month_array = array('A','B','C','D','E','F','G','H','I','J','K','L');
		//find the Hospital name.
		$this->loadModel('Location');
		$this->Location->unbindModel(
				array('belongsTo' => array('City','State','Country'))
		);
	
		#$hospital = $this->Location->read('Facility.name,Location.name',$this->Session->read('locationid'));
			
		//creating patient ID
		$unique_id   = 'U';
		$facility = $this->Session->read('facility');
		$location = $this->Session->read('location');
		$unique_id  .= substr($facility,0,1); //first letter of the hospital name
		$unique_id  .= substr($location,0,2);//first 2 letter of d location
		$unique_id  .= date('y'); //year
		$unique_id  .= $month_array[date('n')-1];//first letter of month
		$unique_id  .= date('d');//day
		$unique_id .= $count;
	
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
	
	
	public function createCredentials($patientId,$email){
		$from = Configure::read('mailFrom');
		$this->uses = array('Patient','Person','Message');
		//	if(!empty($patientId)){
		$password = $this->Message->generatePassword(8);
	
		$patientData = $this->Person->find('first',array('conditions'=>array('Person.id' => $patientId)));
	
		$this->Person->id = $patientData['Person']['id'];
		$this->Person->save(array('password' => sha1($password),'role_id' => 45,'modify_time'=>date('Y-m-d H:i:s')));//hardcoded
		if(empty($email)){
			$email = $patientData['Person']['email'];
		}
		$this->username = $patientData['Person']['id'];
		$this->password = $password;
		//echo $patientData['Patient']['patient_id'].'<->'.($password); //exit;
		if($this->Message->sendCredentialsOnEmail($email,$from,$patientData['Person']['patient_id'],$password,$patientData['Person']['first_name'].' '.$patientData['Person']['last_name'])){
			return true;;
	
		}else{
			return false;
		}
	
		//$this->redirect(array('controller'=>'patients','action'=>'patient_information',$patientId));
	
		//}else{
		//$this->Session->setFlash(__('Patient id can not be null'),'default',array('class'=>'message'));
		//	$this->redirect(array('controller'=>'patients','action'=>'patient_information'));
		//}
	}

	
}
