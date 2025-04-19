<?php
/**
 * UsersController file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Hope
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Santosh R. Yadav
 */
class UsersController extends AppController {

	public $name = 'Users';
	public $uses = array('User','Person');
	public $helpers = array('Html','Form', 'Js','General','JsFusionChart');
	public $components = array('RequestHandler','Email','Cookie','ImageUpload','QRCode','dateFormat','GibberishAES','General');

	/* public function beforeFilter() {
	  
	if ($this->request->data['User']['logintype']=='Patient') {
	$this->Auth->userModel = 'Person';
	$this->Auth->allow("common");
	}
	}  */
	public function beforeFilter() {

		parent::beforeFilter(); //to allow appcontrollers beforeFilter
		$this->Auth->allow('changeConfig');
	}

	public function frondesk_patient(){
		$this->autoRender = false ;
		switch($this->params->query['type']){
			case "opd":
				$this->render('frondesk_opd_patient');
				break;
			case "ipd":
				$this->render('frondesk_ipd_patient');
				break;
			case "emergency":
				$this->render('frondesk_emergency_patient');
				break;
		}
	}
	public function doctor_patient(){
		switch($this->params->query['type']){
			case "opd":
				$this->render('doctor_opd_patient');
				break;
			case "ipd":
				$this->render('doctor_ipd_patient');
				break;
			case "emergency":
				$this->render('doctor_emergency_patient');
				break;
		}
	}
	public function admin_menu(){
			
		$this->cacheAction = array(
				'admin_menu' => 5000
		);
			
		switch($this->params->query['type']){
			case "master":
				$this->render('master_menu');
				break;
			case "ipd":
				$this->render('doctor_ipd_patient');
				break;
			case "emergency":
				$this->render('doctor_emergency_patient');
				break;
		}
	}
	public function common(){
			
		$this->uses = array('DoctorProfile');
		//$this->autoRender = false ;
		$rolename = $this->Session->read('role');
			

		if($rolename == "superadmin"){
			$this->render('common');

		}else if((strtolower($rolename) == strtolower(Configure::read('doctorLabel'))) or
				(strtolower($rolename) == strtolower(Configure::read('adminLabel')))){


			// for ambulatory redirect to appointment
			/* if(strtolower($this->Session->read('facility_type')) == 'clinic'){
				$this->opd_dashboard() ; //for clinic
			}else{
			$this->doctor_dashboard(); //for hospitals
			} */

			//$this->opd_dashboard() ;

			//$this->render('doctor_dashboard');
		}else if(strtolower($_SESSION['role']) == Configure::read('patientLabel')){

			//$this->render('common');
			$p_id=$_SESSION['Auth']['User']['patient_uid'];
			$recivePortalData=$this->portal_header($p_id);

			$this->set('recivePortalData',$recivePortalData);
			//$this->redirect(array('controller'=>'PatientAccess','action'=>'portal_home'));
			//$this->render('/PatientAccess/portal_home');
			//$this->redirect("/PatientAccess/portal_home/");
		}else if((strtolower($rolename) == strtolower(trim(Configure::read('medicalAssistantLabel')))) or
				(strtolower($rolename) == strtolower(trim(Configure::read('nurseLabel'))))) {
			//$this->redirect("/Appointments/appointments_management/"); //
			//$this->redirect("/users/opd_dashboard");

		}else if((strtolower($rolename) == strtolower(trim(Configure::read('receptionistLabel'))))) {
			//$this->redirect("/Appointments/appointments_management/"); //
			//$this->redirect("/users/opd_dashboard");
		}else {
			//$this->render('common');
			//$this->chartdashboard();
			//$this->render('chart_dashboard');
		}

		$this->redirect('/Landings/');
	}

	public function superadmin_login(){
		$this->redirect("/users/login");
	}

public function login_landing(){
   $this->layout  = false ;
	}
	public function admin_login(){
		$this->redirect("/users/login");
	}


	public function login() {
		$this->uses=array('User','Person');
		$userid = $this->Session->read('userid');
// 		debug($userid);exit;
		
			if (isset($this->request->data['login_as_patient'])) {
			$username = $this->request->data['User']['username'];
			$password = $this->request->data['User']['password'];
			$this->loadModel('Person');
			//Fetching person row using UID and password
			$dbo = ConnectionManager::getDataSource('test');
			$query = 'SELECT * FROM persons WHERE patient_uid = :username AND id = :password';
			$params = array('username' => $username, 'password' => $password);
			$results = $dbo->query($query, $params);
// 			debug($results);exit;
			$person_id = $results[0]['persons']['id'];
			$query_to_fetch_patient = 'SELECT * FROM patients WHERE patient_id = :username';
			$params = array('username' => $username);
			$patient_query_result = $dbo->query($query_to_fetch_patient, $params);
			$patient_id = $patient_query_result[0]['patients']['id'];
			if($patient_id && $person_id){
				//Setting Session
				$this->Session->write('db_name','db_hope');
				$this->Session->write('userid','1');
				$this->Session->write('role','Admin');
				$this->Session->write('role_code_name','Admin');
				$this->Session->write('roleid','2');
				$this->Session->write('patient_logged_in',true);
				$this->Session->write('patient_id',$patient_id);
				$this->Session->write('person_id',$person_id);
				$this->Auth->login($results);
				//Generating redirection URL for patient details page
				$redirect_url = '/Patients/new_patient_hub/'.$patient_id.'/'.$person_id;
				$this->redirect($redirect_url);
				//   debug($patient_id);exit;
			}
			else{
				$this->Session->destroy();
				$this->Session->setFlash(__('Incorrect Patient ID or Password'),'default',array('class'=>'error'));
				$this->redirect('/');
			}
			

		}	
			
		if($userid) $this->redirect('/Landings/') ; //To prevent login page if user is logged in by pankaj

		
		//fetch hospital array for dispplaying in slect hospital drop down on login form  Added by Pankaj M
		$this->loadModel("Facility");
		$this->loadModel("DoctorProfile");

		//$this->loadModel("UserHypegpsWeb");
		//$userData  = $this->UserHypegpsWeb->find('first');
		//debug($userData['UserHypegpsWeb']);die();


		// $this->set('doctorlist', $this->Consultant->find('all', array('fields'=> array('id', 'full_name'),'conditions' => array('Consultant.is_deleted' => 0, 'Consultant.refferer_doctor_id' => $this->params->query['familyknowndoctor'], 'Consultant.location_id' => $this->Session->read('locationid')),'order'=>array('Consultant.first_name'))));
		
		$hospitallist=$this->Facility->find('list', array('fields'=> array('id', 'name'),'conditions' => array('Facility.is_deleted' => 0, 'Facility.is_active' => 1)));
		
		//debug($this->data);
		$this->set('hospitallist',$hospitallist);

		
		if (!empty($this->data['Contacts']['name'])) {
			$this->set('successMessage', 'Email sent successfully.');
			$emailAdd = $this->data['Contacts']['email'] ;
			//send email to users with autogenrated password
			//$temPass = $this->General->generateRandomBillNo();
			//BOF Email
			App::import('Vendor', 'PHPMailer', array('file' => 'phpmailer/class.phpmailer.php'));
			$mail = new PHPMailer();
			$mail->IsSMTP();  // telling the class to use SMTP
			//$mail->SMTPAuth   = true;
			$mail->Host     = Configure::read('mailHost'); // SMTP server
			$mail->Port =Configure::read('mailPort');
			$mail->SMTPDebug  = 2;
			$mail->IsHTML(true); //allow html mail
			//Ask for HTML-friendly debug output
			$mail->Debugoutput = Configure::read('Debugoutput');
			$mail->AddAddress($emailAdd);
			$mail->SetFrom(Configure::read('mailFrom'), 'DrmHope');
			$mail->AddReplyTo(Configure::read('mailFrom'), 'DrmHope');
			$mail->Subject  = 'DRM Hope - Contact Us' ;
				
			$message = "Hello, <br/><br/>";
			$message = "Name : ".ucfirst($this->data['Contacts']['name'])."<br/><br/>";
			$message = "Email : ".$this->data['Contacts']['email']."<br/><br/>";
			$message = "Phone : ".$this->data['Contacts']['mobile']."<br/><br/>";
			$message = "Message : ".$this->data['Contacts']['message']."<br/><br/>";
			$message =ucfirst($this->data['Contacts']['name'])." want to tieup with DRMHope Software.<br/><br/>";
			$mail->Body     = $message;
			$mail->WordWrap = 50;
			$send =  $mail->Send() ;
			if($send){
				$this->Session->setFlash(__('Email has been sent successfully!'), 'default', array(), 'auth');
				$this->set('successMessage', 'Email sent successfully.');
			}
		}else if ($this->request->is('post') && !empty($this->request->data['User']['username'])) {
			
			$logintype=$this->request->data['User']['logintype'];
			$this->request->data['User']['hospital_id'] = Configure::read('default_facility_id');
			$usedhospitalid=$this->request->data['User']['hospital_id'];
			//Hospital Login

			/* separate database - check the database name*/
			$this->loadModel("FacilityUserMapping");
			$this->loadModel("Facility");
			$getdatabase_name = $this->FacilityUserMapping->find('first',
					array('conditions' => array('FacilityUserMapping.username' => $this->request->data['User']['username'],'FacilityUserMapping.username' => $this->request->data['User']['username'])));
			
			if($getdatabase_name || strtolower($this->request->data['User']['username'])=='superadmin'){
				$this->request->data['User']['logintype'] = 'Hospital';
				$facility = $this->Facility->read(null,$getdatabase_name['Facility']['id']);

				if($this->request->data['User']['username'] !="superadmin" && $facility['FacilityDatabaseMapping']['is_active'] !=1 && $facility['Facility']['is_active']!=1){
					$this->Session->setFlash(__('Your Hospital is not Active Completely.'), 'default', array('class' => 'error'));

					$this->redirect($this->referer());
				}
				App::import('Vendor', 'DrmhopeDB');
				
				if(!empty($getdatabase_name['Facility']['name'])){


					$db_name = preg_replace('/\s+/', '', $facility['FacilityDatabaseMapping']['db_name']);
					$db_connection = new DrmhopeDB($db_name);
					$db_connection->makeConnection($this->User);
					$this->Session->write('db_name',$db_name);
					$this->Session->write('facilityid',$facility['Facility']['id']);
					$this->Session->write('facility',$facility['Facility']['name']);

					//  $this->Session->write('facilityu',$facility['Facility']['usertype']);

					$this->Session->write('facilityu',$facility['Facility']['usertype']);
					$this->Session->write('facility_type',$facility['Facility']['facility_type']);

					$this->Session->write('facility_logo',$facility['Facility']['logo']);
					$this->Session->write('discharge_from_ed',$facility['Facility']['discharge_from_ed']);
 
					//--global date format
					$this->Session->write('dateformat',$facility['Facility']['require_dateformat']);
					$isMaster = false;

				}else{

					$defaultconfig = ConnectionManager::getDataSource('default')->config;
					$this->Session->write('db_name',$defaultconfig['database']);
					//for superadmin make a dumo copy
					$this->Session->write('dateformat',Configure::read('date_format'));
					$isMaster = true;
				}
					
				// for emergency user //
				if(!$isMaster){
					$isEmergency = $this->User->find('first', array('fields' => array('User.is_emergency'), 'conditions' => array('User.username' => $this->request->data['User']['username'],
							'User.password' => sha1($this->request->data['User']['password']),'User.is_deleted' => 0,'User.is_active' => 1,'User.is_emergency' => 1)));
				}
					
				if(strtolower($this->request->data['User']['username'])=='superadmin'){ //to avoid first_login check (not required for superadmin)
					$countdata = $this->User->find('first', array('fields'=>array('User.is_active','User.id' ),'conditions' => array('User.username' => $this->request->data['User']['username'],
							'User.password' => sha1($this->request->data['User']['password']),'User.is_deleted' => 0)));
				}else{
					if(isset($isEmergency) && $isEmergency['User']['is_emergency'] == 1) {
						$countdata = $this->User->find('first', array('fields'=>array('User.is_active','User.id','first_login' ),'conditions' => array('User.username' => $this->request->data['User']['username'],
								'User.password' => sha1($this->request->data['User']['password']),'User.is_deleted' => 0  )));
					} else {
						$countdata = $this->User->find('first', array('fields'=>array('User.is_active','User.id','first_login' ),'conditions' => array('User.username' => $this->request->data['User']['username'],
								'User.password' => sha1($this->request->data['User']['password']),'User.is_deleted' => 0)));
					}
				}
				$attemptCheckVar = false ;
				//check for previous attempt
				if(empty($countdata['User']['id'])){
					$attemptCheckVar = true ;
				}
				$attemptCheck = $this->checkAtttempt() ;
				//EOF login attempt
				if(!empty($facility['Facility']['timezone'])){
					$this->Session->write('timezone',$facility['Facility']['timezone']);//temp set to indiann time
				}else{
					$this->Session->write('timezone','+05:30');//temp set to indiann time
				}
					
				if(!empty($countdata['User']['id'])  && ($countdata['User']['is_active']==1) &&  ($attemptCheck['iplogin']=='success' &&  $attemptCheck['userlogin']=='success')) {
					if($this->request->data['User']['username'] !="superadmin"){
						$this->User->bindModel(array(
								'belongsTo'=>array(
										'Department' => array('className'    => 'Department',
												'foreignKey'    => 'department_id',
												'fields'	=> array('Department.name')
										),)));
					}

					$this->request->data = $this->User->find('first',
							array('conditions' =>
									array('User.username' => $this->request->data['User']['username'],
											'User.password' => sha1($this->request->data['User']['password']),
									)));

					/*	if($this->request->data['User']){
					 debug($this->request->data['User']);exit;
					}*/

					if(isset($this->request->data['User']['location_id'])){
						$this->loadModel("Location");
						$db_connection->makeConnection($this->Location);
						// $returnUrl =  $this->request->data['User']['return'] ;
						$getOtherInfo = $this->Location->find('first', array('conditions' => array('Location.id' => $this->request->data['User']['location_id'])));

						//Gaurav (To fetch duty plan for user)
							/*$this->loadModel("DutyRoster");
							$dutyDataToday = $this->DutyRoster->find('first',array('fields'=>array('duty_on_cash'),'conditions'=>array('DutyRoster.date'=>date("Y-m-d"),'DutyRoster.user_id'=>$this->request->data['User']['id'])));
							$this->Session->write('duty_on_cash',$dutyDataToday['DutyRoster']['duty_on_cash']);*/
						//Gaurav (To fetch duty plan for user)
						
						//Configuration variable for website -- Pooja
						$this->loadModel('Configuration');
						$website_service_type=$this->Configuration->find('first',array('conditions'=>array('Configuration.name'=>'website')));
						$websiteConfig=unserialize($website_service_type['Configuration']['value']);
						$this->Session->write('website',$websiteConfig);
						//EOF configuration variable

						$this->loadModel('Configuration');
						$instance=$this->Configuration->find('first',array('conditions'=>array('Configuration.name'=>'instance')));
						
						$this->Session->write('instance',$instance['Configuration']['value']);
							
						//check if the previous login is of same location
						$this->checkLocation($getOtherInfo['Location']['id']);
						//EOF cookie cross check
						$this->Session->write('hospitaltype',$getOtherInfo['Location']['accreditation']);
						$this->Session->write('location',$getOtherInfo['Location']['name']);
						$this->Session->write('discharge_text_footer',$getOtherInfo['Location']['footer_text_discharge']);
						$this->Session->write('locationid',$getOtherInfo['Location']['id']);
						$this->Session->write('second_location_id',$this->request->data['User']['second_location_id']);//pawan to manage hospital & clinic
						$this->Session->write('footer',$getOtherInfo['Location']['footer']);
						$this->Session->write('location_phone',$getOtherInfo['Location']['phone1']);
						$this->Session->write('preferences',$getOtherInfo['Facility']['preference']);

						$this->Session->write('location_name',$getOtherInfo['Location']['name']);
						if(/*$_SERVER['SERVER_NAME']==Configure::read('sms_test_host_name') || */$_SERVER['SERVER_NAME']==Configure::read('sms_host_name') || $_SERVER['SERVER_NAME']==Configure::read('sms_external_host_name')){
							$this->Session->write('sms_feature_chk',$getOtherInfo['Location']['sms_feature_chk']);			
						}
						$this->Session->write('location_address1',$getOtherInfo['Location']['address1']);
						$this->Session->write('location_address2',$getOtherInfo['Location']['address2']);
						$this->Session->write('location_zipcode',$getOtherInfo['Location']['zipcode']);
						$this->Session->write('location_country',$getOtherInfo['Country']['name']);
						$this->Session->write('location_state',$getOtherInfo['State']['state_code']);
						$this->Session->write('location_city',$getOtherInfo['City']['name']);
						$this->Session->write('location_phone1',$getOtherInfo['Location']['phone1']);
						$this->Session->write('hospital_permission_mode',$getOtherInfo['Location']['hospital_type']);

						//BOF currency setting
						$this->setCurrencySession($getOtherInfo['Location']['currency_id']);
						//EOF currency
					}
					$this->Session->write('department',$this->request->data['Department']['name']);
					$this->Session->write('departmentid',$this->request->data['User']['department_id']);
					$this->Session->write('role',$this->request->data['Role']['name']);
					$this->Session->write('role_code_name',$this->request->data['Role']['code_name']);
					$this->loadModel("Role");
					$this->Role->unBindModel(array(
							'hasMany' => array('User')));
					$getDoctorRoleId = $this->Role->find('first',array('fields'=>array('id'),'conditions'=>array('Role.name'=>Configure::read('doctor'))));
					$accessableRoles = $this->Role->find('list',array('fields'=>array('name','name'),'conditions'=>array('OR'=>array('Role.id'=>unserialize($this->request->data['Role']['accessable_role']),
							'Role.name'=>$this->request->data['Role']['name']))));
					//For location
					if($this->request->data['Role']['name'] != Configure::read('superAdminLabel')){
						$accessableLocation = $this->Location->find('list',array('fields'=>array('name','name'),'conditions'=>array('is_deleted'=>0,'is_active'=>1)));
						$this->Session->write('accessableLocation',$accessableLocation);
					}
					$this->Session->write('doctorRoleId',$getDoctorRoleId['Role']['id']);
					$this->Session->write('roleid',$this->request->data['Role']['id']);
					$this->Session->write('accessableRoles',$accessableRoles);
					$this->Session->write('userid',$this->request->data['User']['id']);
					$this->Session->write('initial_name',$this->request->data['Initial']['name']);
					$this->Session->write('first_name',$this->request->data['User']['first_name']);
					$this->Session->write('last_name',$this->request->data['User']['last_name']);
					$this->Session->write('email',$this->request->data['User']['person_email_address']);
					$this->Session->write('local_no',$this->request->data['Person']['person_local_number']);
					$this->Session->write('plot_no',$this->request->data['Person']['plot_no']);
					$this->Session->write('username',$this->request->data['User']['username']);
					$this->Session->write('user_photo',$this->request->data['User']['photo']);
					//check it the thumbnail is there
					if(file_exists("uploads/hospital/thumbnail/".$getOtherInfo['Location']['header_image']))
						$pathVar = "/uploads/hospital/thumbnail/".$getOtherInfo['Location']['header_image'] ;
					else
						$pathVar = "/uploads/image/".$getOtherInfo['Location']['header_image'] ;

					$this->Session->write('header_image',$pathVar);
					//EOF header image
					$lastLoginDate = $this->DateFormat->formatDate2STD(date("Y-m-d H:i:s"),'yyyy/mm/dd');

					$this->Session->write('last_login_billing',$lastLoginDate);
					//billing invoice info
					$this->Session->write('billing_footer_name',$getOtherInfo['Location']['billing_footer_name']);
					$this->Session->write('hospital_service_tax_no',$getOtherInfo['Location']['hospital_service_tax_no']);
					$this->Session->write('hospital_pan_no',$getOtherInfo['Location']['hospital_pan_no']);
					//BOF hospital permission by pankaj
					$this->setHospitalPermission();
					//EOF hospital permission by pankaj
					
					if($this->Auth->login($this->request->data['User'])) {
						//date_default_timezone_set($this->Session->read('timezone'));//user's time zone
						$this->User->id = $this->Auth->user('id');
						if(!empty($this->request->data['User']['last_login'])){
								
							$this->Session->write('last_login',$this->DateFormat->formatDate2STD($this->request->data['User']['last_login']),true);
							$this->User->saveField('last_login', $this->DateFormat->formatDate2STD(date("Y-m-d H:i:s"),'yyyy/mm/dd'),array('callbacks' => false));
								
						}

						//	exit;
						$this->User->saveField('last_login_billing', $lastLoginDate,array('callbacks' => false));
						//BOF pankaj // commented by pankaj because loading dashboard is manageable for previosly visited url
						/* if($this->Session->check('Config.redirect')){
						 $redirectUrl =$this->Session->read('Config.redirect');
						$this->Session->delete('Config.redirect');
						$this->redirect($redirectUrl);
						} */
						//EOF pankaj
						//redirect to department
						/* 	if($this->Session->read('facility_type') == 'clinic'){
						 //$this->redirect("/Appointments/appointments_management/");
						$this->redirect("/users/opd_dashboard");
						exit;
						}else{ */
						if($this->Session->read('website.instance')=='hope'){
							//BOF check handover cashier authorization by amit jain
							$this->loadModel("CashierBatch");
							$cashierCount = $this->CashierBatch->find('count');
							if($cashierCount > '0'){
								if(strtolower($this->Session->read('role')) == Configure::read('cashier_role')){
									$getCashierId = $this->CashierBatch->find('first',array('fields'=>array('CashierBatch.cashier_id'),
													'conditions'=>array('CashierBatch.date NOT'=>null,'CashierBatch.type'=>'Cashier'),
													'order' => array('CashierBatch.id' => 'DESC')));
									if($getCashierId['CashierBatch']['cashier_id'] == $this->Session->read('userid')){
										$getCashierDate = $this->CashierBatch->find('first',array('fields'=>array('CashierBatch.date'),
														'conditions'=>array('CashierBatch.type'=>'Cashier'),
														'order' => array('CashierBatch.id' => 'DESC')));
										if($getCashierDate['CashierBatch']['date'] != null || !empty($getCashierDate['CashierBatch']['date'])){
											$cashierData = array();
											$cashierData['user_id'] = $this->Session->read('userid');
											$cashierData['start_transaction_date'] = date("Y-m-d H:i:s");
											$this->CashierBatch->save($cashierData);
											$this->CashierBatch->id='';
										}
										return $this->redirect(array('controller'=>'Accounting','action'=>'cashier_open'));
									}else{
										$this->Session->destroy();
										$this->Session->setFlash(__('You have not Authorized to Access Please contact Admin'), 'default', array('class' => 'error'));
									}
								}else if(strtolower($this->Session->read('role')) == Configure::read('account_manager')){
									$getAgentId = $this->CashierBatch->find('first',array('fields'=>array('CashierBatch.user_id'),
											'conditions'=>array('CashierBatch.date'=>null,'CashierBatch.type'=>'Agent'),
											'order' => array('CashierBatch.id' => 'DESC')));
									
									if($getAgentId['CashierBatch']['user_id'] != $this->Session->read('userid')){
										$cashierData = array();
										$cashierData['user_id'] = $this->Session->read('userid');
										$cashierData['start_transaction_date'] = date("Y-m-d H:i:s");
										$cashierData['type'] = 'Agent';
										$this->CashierBatch->save($cashierData);
										$this->CashierBatch->id='';
									}
									$this->redirect("/Landings/");
								}
							}else{
								if(strtolower($this->Session->read('role')) == Configure::read('cashier_role')){
									$cashierData = array();
									$cashierData['user_id'] = $this->Session->read('userid');
									$cashierData['start_transaction_date'] = date("Y-m-d H:i:s");
									$this->CashierBatch->save($cashierData);
									$this->CashierBatch->id='';
								}
							}
							//EOF cashier
						}
						//BOF login attempt
						$passExpiry = strtotime($this->request->data['User']['password_expiry']." +90 days") ;
						$this->updateLoginAttempt();
						//EOF login attempt

						$today = strtotime(date('Y-m-d'));
						/*if(($this->request->data['User']['first_login']=='yes') || ($today > $passExpiry)){ //check password expiry for 90 days
							if(($today > $passExpiry)){
								if($this->Session->read('website.instance')!='kanpur'){
								   $this->Session->setFlash(__('Your password has expired'), 'default', array('class' => 'error'));
								}
							}
							if($this->Session->read('website.instance')!='kanpur'){
							   $this->redirect("/users/change_password/forceChange");  //force user to change password on first signon
							}
							else
								$this->redirect("/Landings/");
						}else{*/
							$this->redirect("/Landings/");
						//}
						exit;
						//}
					}
					
					
				}else{
					$this->Session->destroy();
					//$this->User->id = $countdata['User']['id']; //set id
					//$this->User->save(array('last_login_billing'=>$lastLoginDate)); //commeted by pankaj
					$attemptResult = $this->checkLoginAttempts() ;
					if($attemptResult =='success'){
						if($countdata['User']['id'] != '' && $countdata['User']['is_active']==0){
							$this->Session->setFlash(__('Your account is not activated or may be temporarily blocked. Contact administrator'), 'default', array('class' => 'error'));
						}else{
							$this->Session->setFlash(__('Username or password is incorrect'), 'default', array('class' => 'error'));
						}
					}
					//backup msg if above went wrong somewhere.
					//$this->Session->setFlash(__('username or password is incorrect'), 'default', array('class' => 'error'));
				}
			}else{
				
				$logintype=$this->request->data['User']['logintype'];
				$this->request->data['User']['hospital_id'] = Configure::read('default_facility_id');
				$usedhospitalid=$this->request->data['User']['hospital_id'];
				$this->request->data['User']['logintype'] = 'Patient';
				$this->loadModel("FacilityUserMapping");
				$this->loadModel("Facility");
				$getdatabase_name = $this->FacilityUserMapping->find('first',
						array('conditions' => array('FacilityUserMapping.facility_id' => $usedhospitalid)));

				$facility = $this->Facility->read(null,$usedhospitalid);
				

				/*if($this->request->data['User']['username'] !="superadmin" && $facility['FacilityDatabaseMapping']['is_active'] !=1 && $facility['Facility']['is_active']!=1){
				 $this->Session->setFlash(__('Your Hospital is not Active Completely.'), 'default', array('class' => 'error'));

				$this->redirect($this->referer());
				}*/
				App::import('Vendor', 'DrmhopeDB');

				if(!empty($getdatabase_name['Facility']['name'])){
					$db_name = preg_replace('/\s+/', '', $facility['FacilityDatabaseMapping']['db_name']);
					$db_connection = new DrmhopeDB($db_name);
					$db_connection->makeConnection($this->User);
					$this->Session->write('db_name',$db_name);
					$this->Session->write('facilityid',$facility['Facility']['id']);
					$this->Session->write('facility',$facility['Facility']['name']);
					$this->Session->write('facility_logo',$facility['Facility']['logo']);
					//--global date format
					$this->Session->write('dateformat',$facility['Facility']['require_dateformat']);
				}else{
                                    $this->redirect("/Landings/index");
                                }
				if(!empty($facility['Facility']['timezone'])){
					$this->Session->write('timezone',$facility['Facility']['timezone']);//temp set to indiann time
				}else{
					$this->Session->write('timezone','+05:30');//temp set to indiann time
					//$this->Session->write('timezone',$facility['timezone']);

				}
				$this->loadModel('Person');
				$countdata = $this->Person->find('count', array('conditions' => array('Person.patient_uid' => $this->request->data['User']['username'],
						'Person.password' => sha1($this->request->data['User']['password']),'Person.is_deleted' => 0)));
					
				if($countdata > 0) {
					$this->request->data = $this->Person->find('first',
							array('conditions' =>
									array('Person.patient_uid' => $this->request->data['User']['username'],
											'Person.password' => sha1($this->request->data['User']['password']),
											'Person.is_deleted' => 0)));

					$this->Person->id = $this->request->data['Person']['id'];
					if(empty($this->request->data['Person']['first_login_date'])){
						$firstLoginDate = date('Y-m-d H:i:s');
						$this->Person->save(array('is_first_login' => 1,'first_login_date' => $firstLoginDate));
					}else{
						$this->Person->save(array('is_first_login' => 1));
					}
					//debug($this->request->data);
					//find role name
					$this->loadModel("Role");
					$rolename = $this->Role->find('first', array('conditions' => array('Role.name' => Configure::read('patientLabel'))));
					//debug("test".$rolename["Role"]["name"]);
					//pr($rolename);exit;


					if(isset($this->request->data['Person']['location_id'])){
						$this->loadModel("Location");
						$db_connection->makeConnection($this->Location);
						// $returnUrl =  $this->request->data['User']['return'] ;
						$getOtherInfo = $this->Location->find('first', array('conditions' => array('Location.id' => $this->request->data['Person']['location_id'])));
							
						//exit;

							
						//check if the previous login is of same location
						$this->checkLocation($getOtherInfo['Location']['id']);
						//EOF cookie cross check
						$this->Session->write('hospitaltype',$getOtherInfo['Location']['accreditation']);
						$this->Session->write('location',$getOtherInfo['Location']['name']);
						$this->Session->write('discharge_text_footer',$getOtherInfo['Location']['footer_text_discharge']);
						$this->Session->write('locationid',$getOtherInfo['Location']['id']);
						if(/*$_SERVER['SERVER_NAME']==Configure::read('sms_test_host_name') ||*/ $_SERVER['SERVER_NAME']==Configure::read('sms_host_name') || $_SERVER['SERVER_NAME']==Configure::read('sms_external_host_name')){
							$this->Session->write('sms_feature_chk',$getOtherInfo['Location']['sms_feature_chk']);			
						}						
						$this->Session->write('footer',$getOtherInfo['Location']['footer']);
						$this->Session->write('location_phone',$getOtherInfo['Location']['phone1']);
						$this->Session->write('preferences',$getOtherInfo['Facility']['preference']);
						//BOF currency setting
						$this->setCurrencySession($getOtherInfo['Location']['currency_id']);
						//EOF currency
					}
					$this->Session->write('role',$rolename["Role"]["name"]);
					$this->Session->write('roleid',$rolename["Role"]["id"]);
					$this->Session->write('userid',$this->request->data['Person']['id']);
					$this->Session->write('initial_name',$this->request->data['Initial']['name']);
					$this->Session->write('first_name',$this->request->data['Person']['first_name']);
					$this->Session->write('last_name',$this->request->data['Person']['last_name']);
					$this->Session->write('email',$this->request->data['Person']['person_email_address']);
					$this->Session->write('local_no',$this->request->data['Person']['person_local_number']);
					$this->Session->write('plot_no',$this->request->data['Person']['plot_no']);
					$this->Session->write('username',$this->request->data['Person']['patient_uid']);
					$this->Session->write('person_photo',$this->request->data['Person']['photo']);
					//check it the thumbnail is there
					if(file_exists("uploads/hospital/thumbnail/".$getOtherInfo['Location']['header_image']))
						$pathVar = "/uploads/hospital/thumbnail/".$getOtherInfo['Location']['header_image'] ;
					else
						$pathVar = "/uploads/image/".$getOtherInfo['Location']['header_image'] ;

					$this->Session->write('header_image',$pathVar);
					//EOF header image

					$this->uses = array('Patient');
					$this->Session->write('is_patient',1);
					$this->Patient->unbindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn')));
					$patientData = $this->Patient->find('first',array('conditions' => array('person_id' => $this->Session->read('userid')),'fields'=> array('id','is_discharge'),'order'=>'id desc'));
					$this->Session->write('isPatientDischarged',$patientData['Patient']['is_discharge']);
					$this->Session->write('patientId',$patientData['Patient']['id']);



					/*if(isset($this->request->data['client_time_zone']) && !empty($this->request->data['client_time_zone'])){
					 $this->Session->write('timezone',$this->request->data['client_time_zone']);//temp set to indiann time
					}else{
					$this->Session->write('timezone','+05:30');//temp set to indiann time
					}*/


					$this->Session->write('last_login',$this->DateFormat->formatDate2STD($this->request->data['User']['last_login'],Configure::read('date_format')));
					//$this->Session->write('last_login_billing',$this->request->data['User']['last_login_billing']);
					//billing invoice info
					$this->Session->write('billing_footer_name',$getOtherInfo['Location']['billing_footer_name']);
					$this->Session->write('hospital_service_tax_no',$getOtherInfo['Location']['hospital_service_tax_no']);
					$this->Session->write('hospital_pan_no',$getOtherInfo['Location']['hospital_pan_no']);
					//BOF hospital permission by pankaj
					$this->setHospitalPermission();
					//EOF hospital permission by pankaj
					if($this->Auth->login($this->request->data['Person'])) {
						//DEBUG("hello");
						//debug($this->Auth->user());
						//$this->chartdashboard();
						//$this->render('chart_dashboard');
						//exit;
							
						//date_default_timezone_set($this->Session->read('timezone'));//user's time zone
						//$this->Person->id = $this->Auth->user('id');
						//echo $this->DateFormat->datetime(date("Y-m-d H:i:s"),true);exit;
						//$this->Person->saveField('last_login', date("Y-m-d H:i:s"),array('callbacks' => false));
						//BOF pankaj
						/*if($this->Session->check('Config.redirect')){
						 $redirectUrl =$this->Session->read('Config.redirect');
						$this->Session->delete('Config.redirect');
						$this->redirect($redirectUrl);
						}*/
						//EOF pankaj
						//$this->Session->write('Auth.User',$this->Auth->user('id'));
						//$this->redirect("/persons/patient_information/".$this->Auth->user('id'));
						//header("location:http://localhost/cakephp/persons/patient_information/".$this->Auth->user('id'));
						//$this->redirect(array('controller'=>'PatientAccess','action'=>'portal_home'));
							
					}
					//$this->redirect('Landings');
					$this->redirect(array('controller'=>'Landings','action'=>'index'));
				}else{
					$this->Session->destroy();
					$this->Session->setFlash(__('username or password is incorrect'), 'default', array('class' => 'error'));
				}
			}



		}

		$this->layout =false ;
		//if($userid)
		//$this->redirect("/users/common/");
	}

	/*public function login() {
	  
	$this->uses=array('User','Person');
	$userid = $this->Session->read('userid');
	if($userid) $this->redirect('common') ;
	//fetch hospital array for dispplaying in slect hospital drop down on login form  Added by Pankaj M
	$this->loadModel("Facility");
	$this->loadModel("DoctorProfile");
	// $this->set('doctorlist', $this->Consultant->find('all', array('fields'=> array('id', 'full_name'),'conditions' => array('Consultant.is_deleted' => 0, 'Consultant.refferer_doctor_id' => $this->params->query['familyknowndoctor'], 'Consultant.location_id' => $this->Session->read('locationid')),'order'=>array('Consultant.first_name'))));

	$hospitallist=$this->Facility->find('list', array('fields'=> array('id', 'name'),'conditions' => array('Facility.is_deleted' => 0, 'Facility.is_active' => 1)));
	$this->set('hospitallist',$hospitallist);

	if ($this->request->is('post')) {
	$logintype=$this->request->data[User][logintype];

	$usedhospitalid=$this->request->data[User][hospital_id];
	//Hospital Login
	if($logintype=='Hospital')
	{
	/ * separate database - check the database name* /
	$this->loadModel("FacilityUserMapping");
	$this->loadModel("Facility");
	$getdatabase_name = $this->FacilityUserMapping->find('first',
			array('conditions' => array('FacilityUserMapping.username' => $this->request->data['User']['username'],'FacilityUserMapping.username' => $this->request->data['User']['username'])));


	$facility = $this->Facility->read(null,$getdatabase_name['Facility']['id']);

	if($this->request->data['User']['username'] !="superadmin" && $facility['FacilityDatabaseMapping']['is_active'] !=1 && $facility['Facility']['is_active']!=1){
	$this->Session->setFlash(__('Your Hospital is not Active Completely.'), 'default', array('class' => 'error'));

	$this->redirect($this->referer());
	}
	App::import('Vendor', 'DrmhopeDB');


	if(!empty($getdatabase_name['Facility']['name'])){


	$db_name = preg_replace('/\s+/', '', $facility['FacilityDatabaseMapping']['db_name']);
	$db_connection = new DrmhopeDB($db_name);
	$db_connection->makeConnection($this->User);
	$this->Session->write('db_name',$db_name);
	$this->Session->write('facilityid',$facility['Facility']['id']);
	$this->Session->write('facility',$facility['Facility']['name']);

	//  $this->Session->write('facilityu',$facility['Facility']['usertype']);

	$this->Session->write('facilityu',$facility['Facility']['usertype']);
	$this->Session->write('facility_type',$facility['Facility']['facility_type']);

	$this->Session->write('facility_logo',$facility['Facility']['logo']);
	$this->Session->write('discharge_from_ed',$facility['Facility']['discharge_from_ed']);
	//--global date format
	$this->Session->write('dateformat',$facility['Facility']['require_dateformat']);
	$isMaster = false;

	}else{

	$defaultconfig = ConnectionManager::getDataSource('default')->config;
	$this->Session->write('db_name',$defaultconfig['database']);
	//for superadmin make a dumo copy
	$this->Session->write('dateformat',Configure::read('date_format'));
	$isMaster = true;
	}

	// for emergency user //
	if(!$isMaster){
	$isEmergency = $this->User->find('first', array('fields' => array('User.is_emergency'), 'conditions' => array('User.username' => $this->request->data['User']['username'],
			'User.password' => sha1($this->request->data['User']['password']),'User.is_deleted' => 0,'User.is_active' => 1,'User.is_emergency' => 1)));
	}
	if(isset($isEmergency) && $isEmergency['User']['is_emergency'] == 1) {
	$countdata = $this->User->find('count', array('conditions' => array('User.username' => $this->request->data['User']['username'],
			'User.password' => sha1($this->request->data['User']['password']),'User.is_deleted' => 0,'User.is_active' => 1, 'User.expiary_date >=' => date('Y-m-d H:i:s'))));
	} else {
	$countdata = $this->User->find('count', array('conditions' => array('User.username' => $this->request->data['User']['username'],
			'User.password' => sha1($this->request->data['User']['password']),'User.is_deleted' => 0,'User.is_active' => 1)));
	}

	if($countdata > 0) {


	if($this->request->data['User']['username'] !="superadmin"){
	$this->User->bindModel(array(
			'belongsTo'=>array(
					'Department' => array('className'    => 'Department',
							'foreignKey'    => 'department_id',
							'fields'	=> array('Department.name')
					),)));
	}

	$this->request->data = $this->User->find('first',
			array('conditions' =>
					array('User.username' => $this->request->data['User']['username'],
							'User.password' => sha1($this->request->data['User']['password']),
							'User.is_deleted' => 0,'User.is_active' => 1)));



	if(isset($this->request->data['User']['location_id'])){
	$this->loadModel("Location");
	$db_connection->makeConnection($this->Location);
	// $returnUrl =  $this->request->data['User']['return'] ;
	$getOtherInfo = $this->Location->find('first', array('conditions' => array('Location.id' => $this->request->data['User']['location_id'])));


	//check if the previous login is of same location
	$this->checkLocation($getOtherInfo['Location']['id']);
	//EOF cookie cross check
	$this->Session->write('hospitaltype',$getOtherInfo['Location']['accreditation']);
	$this->Session->write('location',$getOtherInfo['Location']['name']);
	$this->Session->write('discharge_text_footer',$getOtherInfo['Location']['footer_text_discharge']);
	$this->Session->write('locationid',$getOtherInfo['Location']['id']);
	$this->Session->write('second_location_id',$this->request->data['User']['second_location_id']);//pawan to manage hospital & clinic
	$this->Session->write('footer',$getOtherInfo['Location']['footer']);
	$this->Session->write('location_phone',$getOtherInfo['Location']['phone1']);
	$this->Session->write('preferences',$getOtherInfo['Facility']['preference']);
	//BOF currency setting
	$this->setCurrencySession($getOtherInfo['Location']['currency_id']);
	//EOF currency
	}
	$this->Session->write('department',$this->request->data['Department']['name']);
	$this->Session->write('departmentid',$this->request->data['User']['department_id']);
	$this->Session->write('role',$this->request->data['Role']['name']);
	$this->loadModel("Role");
	$this->Role->unBindModel(array(
			'hasMany' => array('User')));
	$getDoctorRoleId = $this->Role->find('first',array('fields'=>array('id'),'conditions'=>array('Role.name'=>Configure::read('doctor'))));
	$this->Session->write('doctorRoleId',$getDoctorRoleId['Role']['id']);
	$this->Session->write('roleid',$this->request->data['Role']['id']);
	$this->Session->write('userid',$this->request->data['User']['id']);
	$this->Session->write('initial_name',$this->request->data['Initial']['name']);
	$this->Session->write('first_name',$this->request->data['User']['first_name']);
	$this->Session->write('last_name',$this->request->data['User']['last_name']);
	$this->Session->write('email',$this->request->data['User']['email']);
	$this->Session->write('username',$this->request->data['User']['username']);
	//check it the thumbnail is there
	if(file_exists("uploads/hospital/thumbnail/".$getOtherInfo['Location']['header_image']))
		$pathVar = "/uploads/hospital/thumbnail/".$getOtherInfo['Location']['header_image'] ;
	else
		$pathVar = "/uploads/image/".$getOtherInfo['Location']['header_image'] ;

	$this->Session->write('header_image',$pathVar);
	//EOF header image
	//pr($facility);exit;
	if(!empty($facility['Facility']['timezone'])){
	$this->Session->write('timezone',$facility['Facility']['timezone']);//temp set to indiann time
	}else{
	$this->Session->write('timezone','+05:30');//temp set to indiann time
	//$this->Session->write('timezone',$facility['timezone']);

	}

	$lastLoginDate = $this->DateFormat->formatDate2STD(date("Y-m-d H:i:s"),'yyyy/mm/dd');
	$this->Session->write('last_login',$this->DateFormat->formatDate2STD($this->request->data['User']['last_login']));
	$this->Session->write('last_login_billing',$lastLoginDate);
	//billing invoice info
	$this->Session->write('billing_footer_name',$getOtherInfo['Location']['billing_footer_name']);
	$this->Session->write('hospital_service_tax_no',$getOtherInfo['Location']['hospital_service_tax_no']);
	$this->Session->write('hospital_pan_no',$getOtherInfo['Location']['hospital_pan_no']);
	//BOF hospital permission by pankaj
	$this->setHospitalPermission();
	//EOF hospital permission by pankaj
	if($this->Auth->login($this->request->data['User'])) {
	//date_default_timezone_set($this->Session->read('timezone'));//user's time zone
	$this->User->id = $this->Auth->user('id');
	//echo $this->DateFormat->datetime(date("Y-m-d H:i:s"),true);exit;
	$this->User->saveField('last_login', $this->DateFormat->formatDate2STD(date("Y-m-d H:i:s"),'yyyy/mm/dd'),array('callbacks' => false));
	$this->User->saveField('last_login_billing', $lastLoginDate,array('callbacks' => false));
	//BOF pankaj
	if($this->Session->check('Config.redirect')){
	$redirectUrl =$this->Session->read('Config.redirect');
	$this->Session->delete('Config.redirect');
	$this->redirect($redirectUrl);
	}
	//EOF pankaj

	//redirect to department


	/* 	if($this->Session->read('facility_type') == 'clinic'){
	//$this->redirect("/Appointments/appointments_management/");
	$this->redirect("/users/opd_dashboard");
	exit;
	}else{ * /

	$this->redirect("/Landings/");
	exit;
	//}

	}

	}else{
	$this->Session->destroy();
	$this->Session->setFlash(__('username or password is incorrect'), 'default', array('class' => 'error'));
	}

	}
	else
	{//Person Login

	/* separate database - check the database name* /
	$this->loadModel("FacilityUserMapping");
	$this->loadModel("Facility");
	$getdatabase_name = $this->FacilityUserMapping->find('first',
			array('conditions' => array('FacilityUserMapping.facility_id' => $usedhospitalid)));
	//debug($getdatabase_name);

	$facility = $this->Facility->read(null,$usedhospitalid);


	/*if($this->request->data['User']['username'] !="superadmin" && $facility['FacilityDatabaseMapping']['is_active'] !=1 && $facility['Facility']['is_active']!=1){
	$this->Session->setFlash(__('Your Hospital is not Active Completely.'), 'default', array('class' => 'error'));

	$this->redirect($this->referer());
	}* /
	App::import('Vendor', 'DrmhopeDB');


	if(!empty($getdatabase_name['Facility']['name'])){


	$db_name = preg_replace('/\s+/', '', $facility['FacilityDatabaseMapping']['db_name']);
	$db_connection = new DrmhopeDB($db_name);
	$db_connection->makeConnection($this->User);
	$this->Session->write('db_name',$db_name);
	$this->Session->write('facilityid',$facility['Facility']['id']);
	$this->Session->write('facility',$facility['Facility']['name']);
	$this->Session->write('facility_logo',$facility['Facility']['logo']);
	//--global date format
	$this->Session->write('dateformat',$facility['Facility']['require_dateformat']);
	}
	if(isset($this->request->data['client_time_zone']) && !empty($this->request->data['client_time_zone'])){
	$this->Session->write('timezone',$this->request->data['client_time_zone']);//temp set to indiann time
	}else{
	$this->Session->write('timezone','+05:30');//temp set to indiann time
	}
	$this->loadModel('Person');
	$countdata = $this->Person->find('count', array('conditions' => array('Person.patient_uid' => $this->request->data['User']['username'],
			'Person.password' => sha1($this->request->data['User']['password']),'Person.is_deleted' => 0)));


	if($countdata > 0) {
	$this->request->data = $this->Person->find('first',
			array('conditions' =>
					array('Person.patient_uid' => $this->request->data['User']['username'],
							'Person.password' => sha1($this->request->data['User']['password']),
							'Person.is_deleted' => 0)));
	$this->Person->id = $this->request->data['Person']['id'];
	if(empty($this->request->data['Person']['first_login_date'])){
	$firstLoginDate = date('Y-m-d H:i:s');
	$this->Person->save(array('is_first_login' => 1,'first_login_date' => $firstLoginDate));
	}else{
	$this->Person->save(array('is_first_login' => 1));
	}
	//debug($this->request->data);
	//find role name
	$this->loadModel("Role");
	$rolename = $this->Role->find('first', array('conditions' => array('Role.id' => $this->request->data['Person']['role_id'])));
	//debug("test".$rolename["Role"]["name"]);
	//pr($rolename);exit;


	if(isset($this->request->data['Person']['location_id'])){
	$this->loadModel("Location");
	$db_connection->makeConnection($this->Location);
	// $returnUrl =  $this->request->data['User']['return'] ;
	$getOtherInfo = $this->Location->find('first', array('conditions' => array('Location.id' => $this->request->data['Person']['location_id'])));

	//exit;

	//check if the previous login is of same location
	$this->checkLocation($getOtherInfo['Location']['id']);
	//EOF cookie cross check
	$this->Session->write('hospitaltype',$getOtherInfo['Location']['accreditation']);
	$this->Session->write('location',$getOtherInfo['Location']['name']);
	$this->Session->write('discharge_text_footer',$getOtherInfo['Location']['footer_text_discharge']);
	$this->Session->write('locationid',$getOtherInfo['Location']['id']);
	$this->Session->write('footer',$getOtherInfo['Location']['footer']);
	$this->Session->write('location_phone',$getOtherInfo['Location']['phone1']);
	$this->Session->write('preferences',$getOtherInfo['Facility']['preference']);
	//BOF currency setting
	$this->setCurrencySession($getOtherInfo['Location']['currency_id']);
	//EOF currency
	}
	$this->Session->write('role',$rolename["Role"]["name"]);
	$this->Session->write('roleid',$this->request->data['Person']['role_id']);
	$this->Session->write('userid',$this->request->data['Person']['id']);
	$this->Session->write('initial_name',$this->request->data['Initial']['name']);
	$this->Session->write('first_name',$this->request->data['Person']['first_name']);
	$this->Session->write('last_name',$this->request->data['Person']['last_name']);
	$this->Session->write('email',$this->request->data['Person']['email']);
	$this->Session->write('username',$this->request->data['Person']['patient_uid']);
	//check it the thumbnail is there
	if(file_exists("uploads/hospital/thumbnail/".$getOtherInfo['Location']['header_image']))
		$pathVar = "/uploads/hospital/thumbnail/".$getOtherInfo['Location']['header_image'] ;
	else
		$pathVar = "/uploads/image/".$getOtherInfo['Location']['header_image'] ;

	$this->Session->write('header_image',$pathVar);
	//EOF header image

	$this->uses = array('Patient');
	$this->Session->write('is_patient',1);
	$this->Patient->unbindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn')));
	$patientData = $this->Patient->find('first',array('conditions' => array('person_id' => $this->Session->read('userid')),'fields'=> array('id','is_discharge'),'order'=>'id desc'));
	$this->Session->write('isPatientDischarged',$patientData['Patient']['is_discharge']);
	$this->Session->write('patientId',$patientData['Patient']['id']);



	/*if(isset($this->request->data['client_time_zone']) && !empty($this->request->data['client_time_zone'])){
	$this->Session->write('timezone',$this->request->data['client_time_zone']);//temp set to indiann time
	}else{
	$this->Session->write('timezone','+05:30');//temp set to indiann time
	}* /


	$this->Session->write('last_login',$this->DateFormat->formatDate2STD($this->request->data['User']['last_login'],Configure::read('date_format')));
	//$this->Session->write('last_login_billing',$this->request->data['User']['last_login_billing']);
	//billing invoice info
	$this->Session->write('billing_footer_name',$getOtherInfo['Location']['billing_footer_name']);
	$this->Session->write('hospital_service_tax_no',$getOtherInfo['Location']['hospital_service_tax_no']);
	$this->Session->write('hospital_pan_no',$getOtherInfo['Location']['hospital_pan_no']);
	//BOF hospital permission by pankaj
	$this->setHospitalPermission();
	//EOF hospital permission by pankaj
	if($this->Auth->login($this->request->data['Person'])) {
	//DEBUG("hello");
	//debug($this->Auth->user());
	//$this->chartdashboard();
	//$this->render('chart_dashboard');
	//exit;

	//date_default_timezone_set($this->Session->read('timezone'));//user's time zone
	//$this->Person->id = $this->Auth->user('id');
	//echo $this->DateFormat->datetime(date("Y-m-d H:i:s"),true);exit;
	//$this->Person->saveField('last_login', date("Y-m-d H:i:s"),array('callbacks' => false));
	//BOF pankaj
	/*if($this->Session->check('Config.redirect')){
	$redirectUrl =$this->Session->read('Config.redirect');
	$this->Session->delete('Config.redirect');
	$this->redirect($redirectUrl);
	}* /
	//EOF pankaj
	//$this->Session->write('Auth.User',$this->Auth->user('id'));
	//$this->redirect("/persons/patient_information/".$this->Auth->user('id'));
	//header("location:http://localhost/cakephp/persons/patient_information/".$this->Auth->user('id'));
	//$this->redirect(array('controller'=>'PatientAccess','action'=>'portal_home'));

	}

	}else{
	$this->Session->destroy();
	$this->Session->setFlash(__('username or password is incorrect'), 'default', array('class' => 'error'));
	}

	}
	}

	$this->layout =false ;
	//if($userid)
		//$this->redirect("/users/common/");
	}*/

	// login function testing


	public function login2() {
		//echo sha1('12345');
		$userid = $this->Session->read('userid');
		if ($this->request->is('post')) {

			#pr($this->request->data);
		}

		$this->layout =false ;
		if($userid)
			$this->redirect("/users/common/");
	}

	// function logout
	public function logout($fromWhere=false) {
		$this->loadModel("Billing");
		//$this->Auth->logout();
		if($this->Session->read('website.instance')=='hope'){
			 $login_role = strtolower($this->Session->read('role')) == Configure::read('cashier_role')  ||  strtolower($this->Session->read('role')) == 'account manager' ;
		}else{
			$login_role = '';
		}
		if(($login_role) && ($fromWhere == false)){
			$this->redirect(array("controller" => "billings", "action" => "dailyCashBook",'true', "admin" => false));
		}
		$this->Auth->logout();
		//remove session permission
		if($this->Session->read('role') != "superadmin" && $this->Session->read('role') != ""){
			$this->uses = array('SessionPermission');
			$this->SessionPermission->delete($_COOKIE['CAKEPHP']) ;
			$this->SessionPermission->deleteAll(array('expiry <='=>strtotime("-2 days"))) ; //for old pending entries
		}

		$this->Session->destroy();
		if($this->Session->read('website.instance')=='kanpur'){
			$fromWhere=false;
			 
		}
		/*if($fromWhere=='expired'){
			$this->Session->setFlash(__('Your License has been expired, Please contact administrator'), 'default', array('class' => 'error'));
		}*/
		return $this->redirect("/");
	}

	/**
	 * users listing by admin url
	 *
	 */

	public function admin_index($active) {
	
// 	debug('aswin');exit;
		$this->uses = array( 'Role','Configuration');
		$this->set('title_for_layout', __('Admin - Manage Users', true));
		$this->User->unbindModel(array('belongsTo'=>array('City','State','Country')));
		$this->User->bindModel(array('belongsTo' => array('Location' => array('foreignKey'=>'location_id'),
				'Initial' => array('foreignKey'=>'initial_id')
				,'Role' => array('className' => 'Role','foreignKey'    => 'role_id'))),false);
		
		$this->request->data=$this->params->query;
		$locationID = $this->Session->read('locationid');
		$searchUserName='';
		if($this->params['pass']['0']=='0' || $this->params['pass']['0']=='1'|| $this->params['pass']['0']=='2' || $this->params['pass']['0']=='3'){
			$activeFlag=$this->params['pass']['0'];
			$this->set("activeFlag",$activeFlag);
		}
  
		if(isset($this->request->data) && isset($this->request->data) && $this->request->data['first_name']!=''){
			$searchFirstName = $this->request->data['first_name'];
		}
		if(isset($this->request->data) && isset($this->request->data) && $this->request->data['last_name']!=''){
			$searchLastName = $this->request->data['last_name'];
		}
		if(isset($this->request->data) && $this->request->data['role']!=''){
			$searchByRole = $this->request->data['role'];
		}

		/*if($locationID==1){
			$condition = array('User.is_deleted' => 0, 'Role.name <>' => 'superadmin','User.is_emergency' => 0);
		}else{*/
		//}
		 if($this->Session->read('website.instance')=='vadodara'){
		 	$condition = array('User.is_deleted' => 0/*, 'Role.name <>' => 'superadmin'*/,'User.is_emergency' => 0);
		 }else{
			$condition = array('User.is_deleted' => 0, 'Role.name <>' => 'superadmin','Location.id'=>$locationID,'User.is_emergency' => 0);
		 }
		
		if(!empty($searchFirstName)){
			$searchConditions = array('User.first_name LIKE ' => '%'.$searchFirstName.'%');
			$condition = array_merge($searchConditions,$condition);
		}
		if(!empty($searchLastName)){
			$searchConditions = array('User.last_name LIKE ' => '%'.$searchLastName.'%');
			$condition = array_merge($searchConditions,$condition);
		}
		if(!empty($searchByRole)){
			$searchConditions = array('User.role_id' => $searchByRole);
			$condition = array_merge($searchConditions,$condition);
		}
// 		debug($condition)
		if($active=='1'){
			$this->paginate = array('limit' => Configure::read('number_of_rows'),
					'fields' => array('User.*','Role.name', 'Location.name','Initial.name'),
					'order'=>array('User.first_name' => 'ASC'),
					'conditions' => array($condition,'User.is_active' => '1') );
		}elseif($active=='0'){
			$this->paginate = array('limit' => Configure::read('number_of_rows'),
					'fields' => array('User.*','Role.name', 'Location.name','Initial.name'),
					'order'=>array('User.first_name' => 'ASC'),
					'conditions' => array($condition,'User.is_active' => '0') );
		}elseif($this->params->pass['0']=='3'){
			$this->paginate = array('limit' => Configure::read('number_of_rows'),
					'fields' => array('User.*','Role.name', 'Location.name','Initial.name'),
					'order'=>array('User.first_name' => 'ASC'),
					'conditions' => array($condition,'User.is_guarantor' => '1') );

		}elseif($this->params->pass['0']=='2'){
			$this->paginate = array('limit' => Configure::read('number_of_rows'),
					'fields' => array('User.*','Role.name', 'Location.name','Initial.name'),
					'order'=>array('User.first_name' => 'ASC'),
					'conditions' => array($condition,'User.is_authorized_for_discount' => '1') );
		}

		else{
			$this->paginate = array('limit' => Configure::read('number_of_rows'),
					'fields' => array('User.*','Role.name', 'Location.name','Initial.name'),
					'order'=>array('User.first_name' => 'ASC'),
					'conditions' => $condition );
		}
		$this->set('roles',$this->Role->getCoreRoles());
		$this->User->unbindModel(array('belongsTo'=>array('City','State','Country')));
		$data = $this->paginate('User');
		$this->set('data', $data);
		
		//check if fingerprint is enable or not
		$fingerPrint = $this->Configuration->find('first',array('conditions'=>array('name'=>'isfingerPrintSupportEnable'),'fields'=>array('value')));
		$this->set('isfingerPrintSupportEnable',$fingerPrint['Configuration']['value']);
	}

	/**
	 * users view by admin url
	 *
	 */
	public function admin_view($id = null,$emer=null) {
		$this->set('title_for_layout', __('Admin - User Detail', true));
		if($this->params->query['activeFlag']=='0'||$this->params->query['activeFlag']=='1'  || $this->params->query['activeFlag']=='2' ||$this->params->query['activeFlag']=='3'){
			$activeFlag=$this->params->query['activeFlag'];
			$this->set('activeFlag',$activeFlag);
		}

		if (!$id) {
			$this->Session->setFlash(__('Invalid Superadmin', true));
			$this->redirect(array("controller" => "users", "action" => "index", "admin" => true));
		}
		if (!$id && $emer) {
			$this->Session->setFlash(__('Invalid Superadmin', true));
			$this->redirect(array("controller" => "AuditLogs", "action" => "emergency_access", "admin" => true));
		}
		$this->uses =array('Designation','LicensureType');
		$this->User->bindModel(array('belongsTo' => array('Designation' => array('foreignKey'=>'designation_id'),
				'Location' => array('foreignKey'=>'location_id'),
				'Role' => array('className' => 'Role','foreignKey'    => 'role_id'),
				'DoctorProfile' => array('className' => 'DoctorProfile','foreignKey'    => false, 'conditions' => array('DoctorProfile.user_id=User.id')),
				'Department' => array('className' => 'Department','foreignKey'    => false, 'conditions' => array('Department.id=DoctorProfile.department_id')),
				'LicensureType'=>array('foreignKey'=>false,'conditions'=>array('LicensureType.id=User.licensure_type'))
		)),false);
		$data  =$this->User->read(null, $id);
		$this->set(array('user'=> $data,'emer'=>$emer));
		$this->set('userData',$data);  //add it for viewing doctodata //
		//$this->set('licenture',$userData);
		//debug($data);exit;
		$fields = array('full_name');
		$this->User->recursive =-1 ;
		$this->set(array('createdBy'=>$this->User->getUserByID($data['User']['created_by'],$fields),'modifiedBy'=>$this->User->getUserByID($data['User']['modified_by'],$fields)));
	}

	/**
	 * users add by admin url
	 *
	 */
	public function admin_add() {
	   
		App::import('Vendor', 'signature_to_image');
		$this->uses = array('City','Ward', 'Country', 'State', 'Role','Shift', 'Initial', 'Location', 'Designation','NameType','Department','AccountingGroup','LicensureType','TestGroup','Configuration','HrDetail');
		$this->set('title_for_layout', __('Admin - Add New User', true));
		
		//BOF for accounting external charges and hospital charges sharing for consultant jv by amit jain
			if(!empty($this->request->data['Service']['external_charges'])){
				$doctorName = $this->request->data['User']['first_name']." ".$this->request->data['User']['last_name'];
						$this->request->data['Service']['name']=$doctorName;
						$dataService = $this->request->data['Service'];
						$this->request->data['User']['doctor_commision'] = $dataNew  = serialize($dataService);
			}
		//EOF by amit jain	
			$allShiftData = $this->Shift->getAllShifts();
			$this->set(compact(array('allShiftData','allShiftData')));
			
		if (!empty($this->request->data)) {
			if(!empty($this->request->data["User"]["sign"])) {
				$signImage = sigJsonToImage($this->request->data["User"]["sign"],array('imageSize'=>array(320, 150)));
				$signpadfile = date('U').'.png';
				imagepng($signImage, WWW_ROOT.'signpad'.DS.$signpadfile);
				$this->request->data['User']["sign"] = $signpadfile;
			}
		if(!empty($this->request->data["User"]["other_location_id"])) {
				/** Adding comma before and after to make it searchable otherLocation*/
				$this->request->data['User']["other_location_id"] = ','.implode(',',$this->request->data['User']["other_location_id"]).',';
			} 
			if(!empty($this->request->data["User"]["ward_id"])) {
				/** Adding comma before and after to make it searchable wardId*/
				$this->request->data['User']["ward_id"] = ','.implode(',',$this->request->data['User']["ward_id"]).',';
			} 
			//debug($this->request->data); exit;
			//checking unique email address.
			/*$emailCount = $this->User->find('count',
			 array('conditions'=>array('User.email'=>$this->request->data['User']['email'],
			 		'User.is_deleted'=>0,'User.location_id'=>$this->Session->read('locationid'))));
			*/
			$this->loadModel("FacilityUserMapping");
			$emailCount = $this->FacilityUserMapping->find('count',
					array('conditions'=>array('FacilityUserMapping.username'=>$this->request->data['User']['username'])));
			if(!empty($this->request->data['User']['upload_image']['name'])){
				//creating runtime image name
				$original_image_extension  = explode(".",$this->request->data['User']['upload_image']['name']);
				if(!isset($original_image_extension[1])){
					$imagename= "user_".mktime().'.'.$original_image_extension[0];
				}else{
					$imagename= "user_".mktime().'.'.$original_image_extension[1];
				}

				//set new image name to DB
				$this->request->data["User"]['photo']  = $imagename ;

				if(!empty($this->request->data['User']['upload_image']['name'])){
					if($this->request->data['User']['upload_image']['error']){
						if( $this->request->data['User']['upload_image']['error']==1 ||
								$this->request->data['User']['upload_image']['error'] ==2){
							$this->Session->setFlash(__('Max file size 2MB exceeded,Please try again', true),array('class'=>'error'));
						}else{
							$this->Session->setFlash(__('There is problem while uplaoding image,Please try again', true),array('class'=>'error'));
						}
					}else{
						$upData['data']['User']  =  $this->params['data']['User'];
						$showError = $this->ImageUpload->uploadFile($upData,'upload_image','uploads'.DS.'user_images',$imagename);
						if(empty($showError)) {
							// making thumbnail of 100X100
							$this->ImageUpload->load($this->request->data['User']['upload_image']['tmp_name']);
							$this->ImageUpload->resize(100,100);
							$this->ImageUpload->save("uploads/user_images/".$imagename);

						}
					}
				}
				if(!empty($imagename))
					$this->request->data["User"]['photo']  = $imagename ;
			}
			
			
			if($emailCount == 0){
				if(empty($this->request->data["User"]["location_id"])){
					$this->request->data["User"]["location_id"] = $this->Session->read('locationid');
				}

				$this->request->data["User"]["create_time"] = date("Y-m-d H:i:s");
				$this->request->data["User"]["modify_time"] = date("Y-m-d H:i:s");
				$this->request->data["User"]["created_by"] = $this->Session->read('userid');
				$this->request->data["User"]["modified_by"] = $this->Session->read('userid');
				$this->request->data["User"]["email"] = trim($this->request->data["User"]["email"]);
				$this->request->data["User"]["username"] = trim($this->request->data["User"]["username"]);
				//-----User QR Card for Id Card
				$qrString = $this->request->data["User"]["username"]."  ".
						$this->request->data['User']['first_name']." ".$this->request->data['User']['last_name'];
				// generate Text Type QrCode
				$this->QRCode ->text($qrString);
				// display new QR code image
				$this->QRCode ->draw(150, "uploads/userqrcodes/".$this->request->data["User"]["username"].".png");
					
				
				//-----------------------------
				//converting date to DB format and giving default epiration date
				if(empty($this->request->data['User']['expiration_date'])){
					$date=date('Y-m-d',strtotime("today"." +20 years")); //increment by 20 years
					$this->request->data['User']['expiration_date']=$date;
					$this->request->data['User']['exp_date_set_system']='yes';
				}else{

					$this->request->data['User']['expiration_date'] = $this->DateFormat->formatDate2STD($this->request->data['User']['expiration_date'],Configure::read('date_format'));
					$this->request->data['User']['exp_date_set_system']='no';

				}
				$this->request->data["User"]['dob'] = $this->DateFormat->formatDate2STD($this->request->data["User"]['dob'],Configure::read('date_format'));
				// send automatic password generated mail //
				/*	$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
				 $count = mb_strlen($chars);
				for ($i = 0, $result = ''; $i < 8; $i++) {
				$index = rand(0, $count - 1);
				$result .= mb_substr($chars, $index, 1);
				}
				$this->request->data["User"]['password'] = $result;*/
				//debug($this->request->data['User']);
				//pankaj
				$city_id = $this->City->checkIsCityAvailable($this->request->data['User']['city_id'],$this->request->data['User']['state_id']);
				//debug($city_id);
				$this->request->data['User']['city_id'] = $city_id ? $city_id : NULL ; //city id instead of name coming from user form
				//debug($this->request->data['User']);;
				//exit;
				//EOF pankaj

				$this->User->create();
				$this->request->data['User']['password_expiry'] = date('Y-m-d') ;
				$this->request->data['User']['first_login'] = 'yes' ; //force user to change password after first sign on
					
				if($this->request->data["User"]["password"] == $this->request->data["User"]["conf_password"]){
					$this->request->data["User"]["password_expiry"] = date('Y-m-d'); //set password creation date			
					$this->User->save($this->request->data);
					$last_user = $this->User->getInsertId();
					if($this->User->id)
						$this->User->updateAll(array('User.alternate_id'=>$this->User->id),array('User.id'=>$this->User->id));
					//mapping to master table
					$this->loadModel("FacilityUserMapping");
					$this->FacilityUserMapping->save(array(
							'role_id'=>$this->request->data["User"]["role_id"],
							'facility_id'=>$this->Session->read('facilityid'),
							'username'=>$this->request->data["User"]["username"],
					));
					if(!empty($this->request->data['HrDetail']) and $this->params->query['newUser']!="ls"){	

						$this->request->data['HrDetail']['user_id']=$last_user;
						$this->request->data['HrDetail']['type_of_user']=Configure::read('UserType');
						$this->HrDetail->saveData($this->request->data);
					}
					//insert into
					//EOF mapping
					$errors = $this->User->invalidFields();
				}else{
					$errors = array(array('0'=>'Sorry! password is not matching. Please enter matching passwords.'))	;
				}

			}else{
				$errors = array(array('0'=>'Username is already taken elsewhere in the application.'))	;
			}

			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
				// send auto generated mail to user // no auto generation, now send entered password.
				//$this->User->sendUserPasswordMail($this->request->data, $this->request->data["User"]['password']); //no need to send email as we are giving password field on add form.
				
				if($this->request->data['User']['capturefingerprint']=="1")
				{
					$this->Session->setFlash(__('The User has been saved', true));		   
				    $this->redirect(array("controller" => "users", "action" => "finger_print",$last_user,'?'=>$last_user, "admin" => false));
				}
				else
               {
				   $this->Session->setFlash(__('The User has been saved', true));
				   $this->redirect(array("controller" => "users", "action" => "index", "admin" => true,'?'=>$this->params->query));
				}
			}
		}
		$this->set('tempState',$this->State->find('list', array('fields'=> array('id', 'name'),'conditions'=>array('State.country_id'=>'1'),'order' => array('State.name'))));
		$this->set('group',$this->AccountingGroup->getAllGroup());
		$this->set('groupId',$this->AccountingGroup->getAccountingGroupID(Configure::read('sundry_creditors')));
		$this->set('cities', $this->City->find('list', array('fields'=> array('id', 'name'),'order' => array('City.name'))));
		$this->set('states', $this->State->find('list', array('fields'=> array('id', 'name'),'order' => array('State.name'))));
		$this->set('countries', $this->Country->find('list', array('fields'=> array('id', 'name'),'order' => array('Country.name DESC'))));
		$licenture= $this->LicensureType->find('list', array('fields'=> array('id', 'name'),'order' => array('LicensureType.name')));
		//$this->set('roles', $this->Role->find('list', array('fields'=> array('id', 'name'),'conditions' => array('Role.name !=' => 'superadmin'))));
		$this->set('roles',$this->Role->getCoreRoles());
		$this->set('departments',$this->Department->find('list',array('fields'=>array('id','name'),'order' => array('Department.name ASC'),'group'=>'Department.name')));

		$this->set('locations', $this->Location->find('list', array('fields'=> array('id', 'name'),'order' => array('Location.name'),'conditions' => array('Location.is_deleted' => 0,'Location.is_active' => 1))));
		$this->set('initials', $this->Initial->find('list', array('fields'=> array('id', 'name'))));
			

		$this->set('designations', $this->Designation->find('list', array('order' => array('Designation.name'),'fields'=> array('id', 'name'), 'conditions' => array('Designation.location_id' => $this->Session->read('locationid'), 'Designation.is_deleted' => 0))));
		$name_type = $this->NameType->find('list',array('fields'=>array('value_code','description')));
		$this->set('name_type',$name_type);
		$this->set('licenture',$licenture);
		// added for to read address from configuration 
		$hospitalAddress = $this->Configuration->find('first',array('conditions'=>array('name'=>'hospitalAddress'),'fields'=>array('value')));
		$hospAddr=unserialize($hospitalAddress['Configuration']['value']);
		$this->set('hospAddr',$hospAddr);
		
		//$data = $this->convertingDatetoLocal($data);
		//check if fingerprint is enable or not
		$fingerPrint = $this->Configuration->find('first',array('conditions'=>array('name'=>'isfingerPrintSupportEnable'),'fields'=>array('value')));
		$this->set('isfingerPrintSupportEnable',$fingerPrint['Configuration']['value']);
		$this->set ( 'testGroup', $this->TestGroup->getAllGroups ( 'laboratory' ) );

	}

	/**
	 * users edit by admin url
	 *
	 */
	public function admin_edit($id = null,$emer=null) {
		
		//Configure::write('debug',2); 
		//debug($this->request->data);exit;
		
		App::import('Vendor', 'signature_to_image');

		$this->uses = array('HrDetail','City', 'Country','PlacementHistory', 'State', 'Role', 'Initial', 'Location', 'Designation','Department','DoctorProfile','NameType','AccountingGroup','LicensureType','LoginAttempt','TestGroup','Configuration');
		$this->set('title_for_layout', __('Admin - Edit Location Detail', true));
		$this->User->id = $id;
		//BOF for accounting external charges and hospital charges sharing for consultant jv by amit jain
			if(!empty($this->request->data['Service']['external_charges'])){
				$doctorName = $this->request->data['User']['first_name']." ".$this->request->data['User']['last_name'];
						$this->request->data['Service']['name']=$doctorName;
						$dataService = $this->request->data['Service'];
						$this->request->data['User']['doctor_commision'] = $dataNew  = serialize($dataService);
			}
		//EOF by amit jain	
		
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid User', true));
			if($this->Session->read('role') == configure::read('adminLabel'))
				$this->redirect(array("controller" => "users", "action" => "index", "admin" => true));
			else
				$this->redirect(array("controller" => "Landings", "action" => "index", "admin" => false));
		}
		if (!$id && $emer) {
			$this->Session->setFlash(__('Invalid Superadmin', true));
			$this->redirect(array("controller" => "AuditLogs", "action" => "emergency_access", "admin" => true));
		}
		//by swatin to fetch shiftData
		$this->loadModel('Shift');
		$allShiftData = $this->Shift->getAllShifts();
		$this->set(compact(array('allShiftData','allShiftData')));

		if (!empty($this->request->data)) {
			//BOF pankaj check login attempt
			if($this->request->data['User']['password'] != "") {
				$checkUser = $this->User->find('first', array('conditions' => array('User.id'=>$id),'field'=>array('previous_password')));
				$previousPassword = array();
				if(!empty($checkUser['User']['previous_password']))
					$previousPassword  = unserialize($checkUser['User']['previous_password']) ;

				if(in_array($this->request->data['User']['password'],$previousPassword)){
					$currentDateTime =  (array)new DateTime("now", new DateTimeZone(Configure::read('login_attempt_timezone')));
					$currentDateTime =   $currentDateTime['date'] ;
					$this->Session->setFlash(__('You can not set password from last 3 entered password'),'default',array('class'=>'error'));
					$this->redirect($this->referer()) ;
				}
			}
		
			//debug($this->request->data);
			if($this->request->data['User']['direct_email'] != "") {
				$this->Session->write('Auth.User.direct_email',$this->request->data['User']['direct_email']);
			}
			//EOF pankaj check login attempt

			$this->request->data['User']['id']=$id;
			//checking unique email address.
			// check if password is left blank //
			if(!empty($this->request->data['User']['upload_image']['name'])){
				//creating runtime image name
				$original_image_extension  = explode(".",$this->request->data['User']['upload_image']['name']);
				if(!isset($original_image_extension[1])){
					$imagename= "user_".mktime().'.'.$original_image_extension[0];
				}else{
					$imagename= "user_".mktime().'.'.$original_image_extension[1];
				}
				//set new image name to DB
				$this->request->data["User"]['photo']  = $imagename ;
					
				if(!empty($this->request->data['User']['upload_image']['name'])){
					if($this->request->data['User']['upload_image']['error']){
						if( $this->request->data['User']['upload_image']['error']==1 ||
								$this->request->data['User']['upload_image']['error'] ==2){
							$this->Session->setFlash(__('Max file size 2MB exceeded,Please try again', true),array('class'=>'error'));
						}else{
							$this->Session->setFlash(__('There is problem while uplaoding image,Please try again', true),array('class'=>'error'));
						}
					}else{
						$showError = $this->ImageUpload->uploadFile($this->params,'upload_image','uploads/user_images',$imagename);
							
						if(empty($showError)) {
							// making thumbnail of 100X100
							$this->ImageUpload->load($this->request->data['User']['upload_image']['tmp_name']);
							$this->ImageUpload->resize(100,100);
							$this->ImageUpload->save("uploads/user_images/thumbnail/".$imagename);
						}
					}
				}
				if(!empty($imagename))
					$this->request->data["User"]['photo']  = $imagename ;
			}

			if($this->request->data['User']['password'] == "") {
				unset($this->request->data['User']['password']);
				unset($this->request->data['User']['conf_password']);
			}else{
				if(count($previousPassword)==3) unset($previousPassword[0]); //unset first entry cause we need to check last entries only
				$this->request->data['User']['previous_password'] =	serialize(array_merge($previousPassword,array($this->request->data['User']['password']))) ;

				//$this->request->data["User"]["password_expiry"] = date('Y-m-d');
			}

			$this->request->data["User"]["modified_by"] = $this->Session->read('userid');
			$this->request->data["User"]["modify_time"] = date("Y-m-d H:i:s");
			$this->request->data["User"]["dob"] = $this->DateFormat->formatDate2STD($this->request->data["User"]['dob'],Configure::read('date_format'));
			if(empty($this->request->data['User']['expiration_date'])){
				$date=date('Y-m-d',strtotime("today"." +20 years")); //increment by 20 years
				$this->request->data["User"]['expiration_date']=$date;
				$this->request->data["User"]['exp_date_set_system']='yes';
			}else{
				$this->request->data["User"]['expiration_date'] = $this->DateFormat->formatDate2STD($this->request->data["User"]['expiration_date'],Configure::read('date_format'));
				$this->request->data["User"]['exp_date_set_system']='no';
			}

			//$this->request->data["User"]["expiration_date"] = $this->DateFormat->formatDate2STD($this->request->data["User"]['expiration_date'],Configure::read('date_format'));
			$this->request->data["User"]["department_id"] = $this->request->data['DoctorProfile']['department_id'];
			//-----User QR Card for Id Card
			$qrString = $this->request->data["User"]["username"]."  ".
					$this->request->data['User']['first_name']." ".$this->request->data['User']['last_name'];
			// generate Text Type QrCode
			$this->QRCode ->text($qrString);
			// display new QR code image
			$this->QRCode ->draw(150, "uploads/userqrcodes/".$this->request->data["User"]["username"].".png");
			//pr($this->request->data);exit;
			//-----------------------------
			//check password should not be fromprevious enrtries
			$prevPassword = $this->User->find('first',array('conditions'=>array('User.id'=>$id),'fields'=>array('previous_password')));
			$prevPasswordVal = unserialize($prevPassword['User']['previous_password']) ;
			if(in_array($this->request->data['User']['password'])){
				$errors = array(array('0'=>'This password is already used  , try another one.'))	;
			}
			//EOF previous check

			//BOF panakj
			if(!empty($this->request->data["User"]["password_expiry"])){ //while commeting this block uncomment above line of password_expiry line
				$this->request->data["User"]["password_expiry"] = $this->DateFormat->formatDate2STD($this->request->data["User"]['password_expiry'],Configure::read('date_format'));
			}
			//EOF pankaj

			if($this->request->data["User"]["password"] == $this->request->data["User"]["conf_password"] && empty($errors)){
				//pankaj
				$city_id = $this->City->checkIsCityAvailable($this->request->data['User']['city_id'],$this->request->data['User']['state_id']);
				$this->request->data['User']['city_id'] = $city_id ; //city id instead of name coming from user form
				//EOF pankaj
				$this->request->data['DoctorProfile']['id']=$this->request->data['DoctorProfile']['idUpdate'];
				unset($this->request->data['DoctorProfile']['idUpdate']);
				//	debug($this->request->data);exit;
				// By aditya to save image
				if(!empty($this->request->data['User']['sign'])) {
					$signImage = sigJsonToImage($this->request->data['User']['sign'],array('imageSize'=>array(320, 150)));
					$signpadfile = date('U').'.png';
					imagepng($signImage, WWW_ROOT.'signpad'.DS.$signpadfile);
					$this->request->data['User']['sign'] = $signpadfile;
				}else{ 
					unset($this->request->data['User']['sign']);
				}
				// EOD
				
				if($this->request->data['User']['other_location_id']){
					$this->request->data['User']["other_location_id"] = ','.implode(',',$this->request->data['User']["other_location_id"]).',';
				}
				if($this->request->data['User']['ward_id']){
					$this->request->data['User']['ward_id'] =  ','.implode(',',$this->request->data['User']["ward_id"]).',';
				}
				$this->User->save($this->request->data); 
				
				if(!empty($this->request->data['HrDetail']) && !empty($id) and $this->params->query['newUser']!="ls"){					
						$this->request->data['HrDetail']['user_id']=$id;
						$this->request->data['HrDetail']['type_of_user']=Configure::read('UserType');					
						$this->HrDetail->saveData($this->request->data);
				}
				//$this->DoctorProfile->save($this->request->data);
				$errors = $this->User->invalidFields();
			} else {
				if(empty($errors))
					$errors = array(array('0'=>'Sorry! password is not matching. Please enter matching passwords.'))	;
				else
					$errors = array(array('1'=>'Sorry! password is not matching. Please enter matching passwords.'))	;
			}

			if(!empty($errors)) {
				$this->set("errors", $errors);

			} else {

				$this->updateLoginAttempt(); //rest login attempts

				$this->Session->setFlash(__('The User has been saved', true));
				if($emer == 'emer'){
					$this->redirect(array("controller" => "AuditLogs", "action" => "emergency_access", "admin" => true));
				}else{
					if($this->Session->read('role') == configure::read('adminLabel')){
						if($this->params->query['activeFlag']=='0' || $this->params->query['activeFlag']=='1'){
							$this->redirect(array("controller" => "users", "action" => "index",$this->params->query['activeFlag'], "admin" => true));
						}else{
							$this->redirect(array("controller" => "users", "action" => "index", "admin" => true,'?'=>$this->params->query));
						}
					}else{
						$this->redirect(array("controller" => "Landings", "action" => "index", "admin" => false));
					}
				}
			}
		}
		//	if (empty($this->request->data)) {
		$data = $this->User->read(null, $id) ;
		$data['User']['dob'] = $this->DateFormat->formatDate2Local($data['User']['dob'],Configure::read('date_format'));
		$data['User']['expiary_date'] = $this->DateFormat->formatDate2Local($data['User']['expiary_date'],Configure::read('date_format'), true);
		$data['User']['expiration_date'] = $this->DateFormat->formatDate2Local($data['User']['expiration_date'],Configure::read('date_format'), false);
		//BOF panakj
		if(!empty($data['User']['password_expiry'])){
			$data['User']['password_expiry'] = $this->DateFormat->formatDate2STD($data['User']['password_expiry'],Configure::read('date_format'));
		}
		//EOF pankaj

		$this->User->bindModel(array(
				'belongsTo' => array(
						'State' =>array('foreignKey' => false,'conditions'=>array('State.id=User.state_id')),
						'City' =>array('foreignKey' => false,'conditions'=>array('City.id=User.city_id')),
				)),false);
		$data = $this->User->find('first',array('conditions'=>array('User.id'=>$id),'fields'=>array('User.*','State.name','City.name','Role.name')));
		$this->request->data = $data;
		// get doctordata //
		$this->set('userData',$data);
		
		//BOF-Mahalaxmi for Fetch the hrdetails
		$this->set('hrDetails',$this->HrDetail->findFirstHrDetails($id,Configure::read('UserType')));
		//BOF-SwatiN for Fetch the Placement History data(shifts)
		$this->set('shiftData',$this->PlacementHistory->findUserShiftID($id));
		//EOF-Mahalaxmi for Fetch the hrdetails
		//$this->set('userData',$licenture);
		//$this->set('')
		// get department //

		$this->set('dept', $this->Department->find('list', array('order' => array('Department.name'),'fields'=> array('id', 'name'), 'conditions' => array('Department.location_id' => $this->Session->read('locationid'), 'Department.is_active' => 1))));
		$ss= $this->DoctorProfile->find('first', array('conditions' => array('DoctorProfile.user_id'=> $this->request->data['User']['id']), 'fields' => array('DoctorProfile.id','DoctorProfile.department_id', 'DoctorProfile.is_surgeon','DoctorProfile.is_opd_allow','DoctorProfile.is_registrar'))) ;
		$this->set('ss', $ss);
		$this->set('getDepartment', $this->DoctorProfile->find('first', array('conditions' => array('DoctorProfile.user_id'=> $this->request->data['User']['id']), 'fields' => array('DoctorProfile.department_id'))));
		//}


		$this->set('id', $id);
		$this->set('emer', $emer);
		$this->set('group',$this->AccountingGroup->getAllGroup());
		$this->set('groupId',$this->AccountingGroup->getAccountingGroupID(Configure::read('sundry_creditors')));
		//for doctor commision
		$this->set('commission',$this->User->find('first',array('fields'=>array('User.doctor_commision'),'conditions'=>array('User.id'=>$id))));
		//$this->set('cities', $this->City->find('list', array('fields'=> array('id', 'name'),'conditions'=>array('id'=>$data['User']['city_id']),'order' => array('City.name'))));
		$this->set('states', $this->State->find('list', array('fields'=> array('id', 'name'),'conditions'=>array('country_id'=>$data['User']['country_id']),'order' => array('State.name'))));
		$this->set('countries', $this->Country->find('list', array('fields'=> array('id', 'name'),'order' => array('Country.name'))));
		//$licenture =$this->LicentureType->find('list', array('fields'=> array('id', 'name'),'order' => array('LicentureType.name')));
		$licenture= $this->LicensureType->find('list', array('fields'=> array('id', 'name'),'order' => array('LicensureType.name')));
		$this->set('roles',$this->Role->getCoreRoles());
	//	$this->set('roles',$this->Role->find('list', array('order' => array('Role.name'),'fields'=> array('id', 'name'),'conditions' =>array('Role.is_deleted' => 0, 'Role.name !='=>"superadmin",'Role.name !=' =>Configure::read('patientLabel'),'location_id'=>$data['User']['location_id']) )));
		$this->set('departments',$this->Department->find('list',array('fields'=>array('id','name'),'order' => array('Department.name'),'group'=>'Department.name')));
		$this->set('locations', $this->Location->find('list', array('order' => array('Location.name'),'fields'=> array('id', 'name'),'conditions' => array('Location.is_deleted' => 0,'Location.is_active' => 1/*,'facility_id'=>$this->Session->read('facilityid')*/))));
		$this->set('initials', $this->Initial->find('list', array('fields'=> array('id', 'name'))));
		$this->set('designations', $this->Designation->find('list', array('order' => array('Designation.name'),'fields'=> array('id', 'name'), 'conditions' => array('Designation.location_id' => $this->Session->read('locationid'), 'Designation.is_deleted' => 0))));
		$name_type = $this->NameType->find('list',array('fields'=>array('value_code','description')));
		$this->set('name_type',$name_type);
		//$this->set('licenture',$licenture);
		$this->set('licenture',$licenture);
		//$this->set('licenture',$data);
		$this->set ( 'testGroup', $this->TestGroup->getAllGroups ( 'laboratory' ) );
	}

	/**
	 * users delete by admin url
	 *
	 */
	public function admin_delete($id = null) {
		$this->loadModel("DoctorProfile");
		$this->set('title_for_layout', __('Admin - Delete User', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for User', true));
			$this->redirect(array("controller" => "users", "action" => "index", "admin" => true));
		}
		if (!empty($id)) {

			//$this->User->id = $id;
			/* $this->request->data["User"]["id"] = $id;

			$this->request->data["User"]["is_deleted"] = "1";

			$this->User->save($this->request->data);*/
			$currentUser = $this->User->find('first',array('conditions'=>array('User.id'=>$id)));

			$this->loadModel("FacilityUserMapping");

			if(!empty($currentUser['User']['username'])){
				$masterCheck= $this->FacilityUserMapping->deleteAll(array('username'=>$currentUser['User']['username']));

			}else{
				$masterCheck = false ;
			}

			if($masterCheck){
				//$this->User->delete($id);
				$this->request->data["User"]["id"] = $id;
				$this->request->data["User"]["is_deleted"] = "1";
				$this->User->save($this->request->data);
				$this->Session->setFlash(__('User deleted', true));
			}else{
				$this->Session->setFlash(__('There is problem , please try again', true));
			}
			$this->redirect(array("controller" => "users", "action" => "index", "admin" => true));

		}else {
			$this->Session->setFlash(__('This user is associated with other details so you can not be deleted this user', true));
			$this->redirect(array("controller" => "users", "action" => "index", "admin" => true));
		}
	}

	/**
	 * users listing by superadmin url
	 *
	 */

	public function superadmin_index() {
		$this->set('title_for_layout', __('Superadmin - Manage Users', true));
		$this->loadModel("FacilityUserMapping");
		$this->paginate = array(
				'conditions' => array('FacilityUserMapping.role_id' => 2),
				'group'=>array('FacilityUserMapping.facility_id'));
		$data = $this->paginate('FacilityUserMapping');
		$this->set('data', $data);
	}

	/**
	 * users view by superadmin url
	 *
	 */
	public function superadmin_view($id = null,$user_name = null) {
		$this->set('title_for_layout', __('Superadmin - User Detail', true));
		if (!$id && !$user_name) {
			$this->Session->setFlash(__('Invalid User', true));
			$this->redirect(array("controller" => "users", "action" => "index", "superadmin" => true));
		}
		$this->loadModel("Facility");
		$this->loadModel("Role");
		$this->loadModel("Initial");
		$this->loadModel("City");
		App::import('Vendor', 'DrmhopeDB');
		$data = $this->Facility->read(null, $id);
		$db_connection = new DrmhopeDB($data['FacilityDatabaseMapping']['db_name']);
		$db_connection->makeConnection($this->User);
		$db_connection->makeConnection($this->Initial);
		$db_connection->makeConnection($this->City);
		$this->set('facilitiesdata', $data);
		$this->set('user', $this->User->find('first', array('conditions' => array('User.username' => $user_name))));
	}


	/**
	 * users add by superadmin url
	 *
	 */
	public function superadmin_add() {
		$this->uses=array('City','Country','State','Role','Initial','Facility','Location');
		$this->set('title_for_layout', __('Superadmin - Add New User', true));
		if (!empty($this->request->data)) {
			/* Separate database - add user and mapped it with it's respective database*/

			$this->loadModel("FacilityUserMapping");
			App::import('Vendor', 'DrmhopeDB');
			$facility_db = $this->Facility->find('first',
					array('conditions' => array('Facility.id' =>
							$this->request->data["User"]["facility_id"])));

			$db_connection = new DrmhopeDB($facility_db['FacilityDatabaseMapping']['db_name']);
			$db_connection->makeConnection($this->User);
			$db_connection->makeConnection($this->Acl->Aro);
			$db_connection->makeConnection($this->Location);
			/********************************************************************************/
			$this->Role->unbindModel(array("hasMany"=>array("User")));
			$roleDetails =$this->Role->find('first',array('conditions' => array('Role.name' => 'admin')));//hack
			$this->request->data["User"]["role_id"] = $roleDetails['Role']['id'];

			$isAdminCreated = $this->User->find('all',array('fields'=>array("id"),'conditions' => array( 'role_id' => $roleDetails['Role']['id'],'User.is_deleted' => 0)));

			$userName = $this->FacilityUserMapping->find('all',array('conditions' => array('FacilityUserMapping.username' => $this->request->data['User']['username'])));
			
			if(count($userName) > 0){
				$this->Session->setFlash(__('Username already exists', true),'default',array('class'=> 'error'));
			}else{

				if(count($isAdminCreated) > 0){
					#pr($isAdminCreated);exit;
					$this->Session->setFlash(__('Admin already created', true),'default',array('class'=> 'error'));

				}else{
					$location = $this->Location->find("first");
					 // search default location for user
					$this->request->data["User"]["create_time"] = date("Y-m-d H:i:s");
					$this->request->data["User"]["modify_time"] = date("Y-m-d H:i:s");
					$this->request->data["User"]["created_by"] = $this->Session->read('userid');
					$this->request->data["User"]["location_id"] = $location['Location']['id'];

					// send automatic password generated mail //
					$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
					$count = mb_strlen($chars);
					for ($i = 0, $result = ''; $i < 8; $i++) {
						$index = rand(0, $count - 1);
						$result .= mb_substr($chars, $index, 1);
					}
					$this->request->data["User"]['password'] = $result;

					$dataArr = $this->request->data['User'];
					
					$this->User->create();
					$this->User->save($dataArr);
					$errors = $this->User->invalidFields();
					if(!empty($errors)) {
						$this->set("errors", $errors);
					} else {
						$this->User->virtualFields = array();
						$parent = $this->User->parentNode();
						$parent = $this->User->node($parent);
						$node = $this->User->node();
						$aro = $node[0];
						$aro['Aro']['parent_id'] = $parent[0]['Aro']['id'];
						$this->Acl->Aro->save($aro);
						$this->FacilityUserMapping->save(array('facility_id' =>
								$this->request->data["User"]["facility_id"],
								'role_id'=>$this->request->data["User"]["role_id"],
								'username'=>$this->request->data["User"]["username"]));
						//$this->User->sendUserPasswordMail($this->request->data, $result);
						$this->Session->setFlash(__('The User has been saved', true));
						$this->redirect(array("controller" => "Users", "action" => "index", "superadmin" => true));
					}
				}
			}
		}
		
		$this->set('cities', $this->City->find('list', array('fields'=> array('id', 'name'))));
		$this->set('states', $this->State->find('list', array('fields'=> array('id', 'name'))));
		$this->set('countries', $this->Country->find('list', array('fields'=> array('id', 'name'))));

		
		//$this->set('roles', $this->Role->find('list', array('fields'=> array('id', 'name'),'conditions' => array('Role.name <>' => 'superadmin'))));
		//superadmin shud add admin role only
		$this->set('roles', $this->Role->find('list', array('fields'=> array('id', 'name'),'conditions' => array('Role.name ' => 'admin'))));
		$this->set('initials', $this->Initial->find('list', array('fields'=> array('id', 'name'))));

		$this->set('facilities', $this->Facility->find('all',array('conditions' =>
				array('Facility.is_deleted' => 0,'Facility.is_active' => 1,"FacilityDatabaseMapping.is_active"=>1),'group'=>array('Facility.id'))));
	}

	/**
	 * users edit by superadmin url
	 *
	 */
	public function superadmin_edit($id = null,$user_name = null) {
		$this->loadModel("City");
		$this->loadModel("Country");
		$this->loadModel("State");
		$this->loadModel("Role");
		$this->loadModel("Location");
		$this->loadModel("Initial");
		$this->loadModel("Facility");
		App::import('Vendor', 'DrmhopeDB');
		$data = $this->Facility->read(null, $id);
		$db_connection = new DrmhopeDB($data['FacilityDatabaseMapping']['db_name']);
		$db_connection->makeConnection($this->User);
		$db_connection->makeConnection($this->Initial);
		$db_connection->makeConnection($this->Location);
		$db_connection->makeConnection($this->Role);
		$db_connection->makeConnection($this->State);
		$db_connection->makeConnection($this->Country);
		$db_connection->makeConnection($this->City);
		$this->set('title_for_layout', __('Superadmin - Edit User Detail', true));
		$this->User->id = $id;
		if (!$id && empty($this->request->data) && !$user_name) {
			$this->Session->setFlash(__('Invalid User', true));
			$this->redirect(array("controller" => "users", "action" => "index", "superadmin" => true));
		}
		if (!empty($this->request->data)) {

			$this->request->data["User"]["modified_by"] = $this->Session->read('userid');
			if($this->request->data['User']['password'] == "" || empty($this->request->data['User']['password'])) {
				unset($this->request->data['User']['password']);
				unset($this->request->data['User']['conf_password']);
			} else {

				$this->request->data["User"]["password"] = sha1($this->request->data["User"]["password"]);
			}

			$this->User->save($this->request->data,array('callbacks'=>false));
			$errors = $this->User->invalidFields();


			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
				$this->Session->setFlash(__('The User has been saved', true));
				$this->redirect(array("controller" => "users", "action" => "index", "superadmin" => true));
			}
		}
		$this->request->data = $this->User->find('first', array('conditions' => array('User.username' => $user_name)));
		$this->set('user', $this->request->data);
		$this->set('cities', $this->City->find('list', array('fields'=> array('id', 'name'))));
		$this->set('states', $this->State->find('list', array('fields'=> array('id', 'name'))));
		$this->set('countries', $this->Country->find('list', array('fields'=> array('id', 'name'))));
		$this->set('roles', $this->Role->find('list', array('fields'=> array('id', 'name'),'conditions' => array('Role.name <>' => 'superadmin'))));
		$this->set('locations', $this->Location->find('list', array('fields'=> array('id', 'name'),'conditions' => array('Location.is_deleted' => 0,'Location.is_active' => 1))));
		$this->set('initials', $this->Initial->find('list', array('fields'=> array('id', 'name'))));
		$this->set('facility', $this->Facility->read(null, $id));
	}

	/**
	 * users delete by superadmin url
	 *
	 */
	public function superadmin_delete($id = null) {
		$this->loadModel("DoctorProfile");
		$this->set('title_for_layout', __('Superadmin - Delete User', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for User', true));
			$this->redirect(array("controller" => "users", "action" => "index", "superadmin" => true));
		}
		if (!empty($id)) {
			$this->User->id = $id;
			$this->request->data["User"]["id"] = $id;
			$this->request->data["User"]["is_deleted"] = "1";
			$roleType = $this->User->read('Role.name', $id);
			if(strtolower($roleType) == strtolower("Treating Consultant")) {
				$this->DoctorProfile->updateAll(array('DoctorProfile.is_deleted' => 1), array('DoctorProfile.user_id' => $id));
			}
			$this->User->save($this->request->data);
			$this->Session->setFlash(__('User deleted', true));
			$this->redirect(array("controller" => "users", "action" => "index", "superadmin" => true));
		}else {
			$this->Session->setFlash(__('This user is associated with other details so you can not be deleted this user', true));
			$this->redirect(array("controller" => "users", "action" => "index", "superadmin" => true));
		}
	}

	function superadmin_getLocations($hospital_id=null){
		$this->loadModel("Location");
		$location_array = array(''=>__('Please select'));
		$location_array1 = $this->Location->find('list', array('fields'=> array('id', 'name'),'conditions'=>array('facility_id'=>$hospital_id, 'Location.is_active' => 1, 'Location.is_deleted' => 0)));
		echo json_encode($location_array+$location_array1);
		exit;
	}

	function superadmin_getRoles($location_id=null){
		$this->loadModel("Role");
		$location_array = array(''=>__('Please select'));
		$location_array1 = $this->Role->find('list', array('fields'=> array('id', 'name'),'conditions'=>array('location_id'=>$location_id, 'name <>' =>  'superadmin')));
		echo json_encode($location_array+$location_array1);
		exit;
	}
	//function to check username availability
	function superadmin_ajaxValidateUsername(){
		$this->autoRender =false ;

		$username = $this->params->query['fieldValue'];
		if($username == ''){
			return;
		}
		$count = $this->User->find('count',array('conditions'=>array('Username'=>$username,'User.is_deleted' => 0)));
		if(!$count){
			return json_encode(array('username',true,'alertTextOk')) ;
		}else return json_encode(array('username',false,'alertText')) ;

		exit;
	}

	//function to check username availability
	function admin_ajaxValidateUsername(){
		$this->layout = 'ajax';
		$this->autoRender =false ;
		$username = $this->params->query['fieldValue'];
		if($username == ''){
			return;
		}
		$username = $this->params->query['fieldValue'];
		$count = $this->User->find('count',array('conditions'=>array('Username'=>$username,'User.is_deleted' => 0)));
		if(!$count){
			return json_encode(array('username',true,'alertTextOk')) ;
		}else return json_encode(array('username',false,'alertText')) ;

		exit;
	}

	/**
	 * get department type by xmlhttprequest
	 *
	 */
	public function getDepartment() {
		$this->uses = array('Department', 'Role');

		$checkRoleType = $this->Role->find('first', array('conditions' => array('Role.id' => $this->params->query['roletype']), 'fields' => array('Role.name'), 'recursive' => -1));
		//if($this->params['isAjax']) {
		if($checkRoleType['Role']['name'] == Configure::read('doctorLabel') || $checkRoleType['Role']['name'] == Configure::read('RegistrarLabel')) {

			$this->set('departmenttypelist', $this->Department->find('all', array('fields'=> array('id', 'name'),'order'=>array('name ASC'),'conditions' => array('Department.is_active' => 1, 'Department.location_id' => $this->Session->read('locationid')))));
			$this->layout = 'ajax';
			$this->render('/Users/ajaxgetdepartments');
		}else{
			$this->layout = 'ajax';
			$this->render('/Users/ajaxgetnull');
		}
		// }
	}

	/**
	 *
	 *  chart dashboard showing basic chart graph
	 *
	 */
	public function chartdashboard() {

		$this->uses = array('Person', 'Patient', 'PatientSurvey');
		$this->loadModel('UserDashboardChart');
		$userDashboardChart = $this->UserDashboardChart->find('all', array('conditions' => array('UserDashboardChart.user_id' => $this->Auth->user('id')), 'order' => array('UserDashboardChart.ordervalue ASC')));
		$this->set('userDashboardChart', $userDashboardChart);//exit;

		$reportYear = date('Y');
		$fromDate = $reportYear."-01-01"; // set first date of current year
		$toDate = $reportYear."-12-31"; // set last date of current year

		// patient registration query //
		$patientRegCount = $this->Person->find('all', array('fields' => array('COUNT(*) AS patientregcount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'Person.patient_uid', 'Person.location_id', 'Person.id', 'Person.is_deleted'), 'group' => array("month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('Person.is_deleted' => 0, 'Person.location_id' => $this->Session->read('locationid')), 'recursive' => -1));
		foreach($patientRegCount as $patientRegCountVal) {
			$filterPatientRegDateArray[] = $patientRegCountVal[0]['month_reports'];
			$filterPatientRegCountArray[$patientRegCountVal[0]['month_reports']] = $patientRegCountVal[0]['patientregcount'];
		}
		$this->filterPatientRegDateArray =$filterPatientRegDateArray;
		$this->filterPatientRegCountArray =$filterPatientRegCountArray;
		$this->set('filterPatientRegDateArray', isset($filterPatientRegDateArray)?$filterPatientRegDateArray:"");
		$this->set('filterPatientRegCountArray', isset($filterPatientRegCountArray)?$filterPatientRegCountArray:0);

		// empanelment report query //
		$cashCount = $this->Patient->find('all', array('fields' => array('COUNT(*) AS cashcount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'Patient.payment_category', 'Patient.location_id', 'Patient.id', 'Patient.is_deleted'), 'group' => array("month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('Patient.admission_type' => 'IPD', 'Patient.payment_category' => 'cash', 'Patient.is_deleted' => 0, 'Patient.location_id' => $this->Session->read('locationid')), 'recursive' => -1));
		foreach($cashCount as $cashCountVal) {
			$filterCashDateArray[] = $cashCountVal[0]['month_reports'];
			$filterCashCountArray[$cashCountVal[0]['month_reports']] = $cashCountVal[0]['cashcount'];
		}
		$this->filterCashDateArray=$filterCashDateArray;
		$this->filterCashCountArray=$filterCashCountArray;
		$this->set('filterCashDateArray', isset($filterCashDateArray)?$filterCashDateArray:"");
		$this->set('filterCashCountArray', isset($filterCashCountArray)?$filterCashCountArray:0);

		$cardCount = $this->Patient->find('all', array('fields' => array('COUNT(*) AS cardcount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'Patient.payment_category', 'Patient.location_id', 'Patient.id', 'Patient.is_deleted'), 'group' => array("month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('Patient.admission_type' => 'IPD', 'Patient.payment_category' => 'card', 'Patient.is_deleted' => 0, 'Patient.location_id' => $this->Session->read('locationid')), 'recursive' => -1));
		foreach($cardCount as $cardCountVal) {
			$filterCardDateArray[] = $cardCountVal[0]['month_reports'];
			$filterCardCountArray[$cardCountVal[0]['month_reports']] = $cardCountVal[0]['cardcount'];
		}
		//debug($filterCardCountArray);
		$this->filterCardDateArray=$filterCardDateArray;
		$this->filterCardCountArray=$filterCardCountArray;
		$this->set('filterCardDateArray', isset($filterCardDateArray)?$filterCardDateArray:"");
		$this->set('filterCardCountArray', isset($filterCardCountArray)?$filterCardCountArray:0);
		// opd patient survey query //

		/*$takenTimeRegCount = $this->Patient->find('all', array('fields' => array('AVG((TIME_TO_SEC(TIMEDIFF(form_completed_on,form_received_on)))/60) AS takentimeregcount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'Patient.location_id', 'Patient.id', 'Patient.is_deleted'), 'group' => array("month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('Patient.is_deleted' => 0, 'Patient.location_id' => $this->Session->read('locationid')), 'recursive' => -1));
		 foreach($takenTimeRegCount as $takenTimeRegCountVal) {
		$filterTakenTimeDateArray[] = $takenTimeRegCountVal[0]['month_reports'];
		$filterTakenTimeCountArray[$takenTimeRegCountVal[0]['month_reports']] = $takenTimeRegCountVal[0]['takentimeregcount'];
		}
		$this->set('filterTakenTimeDateArray', isset($filterTakenTimeDateArray)?$filterTakenTimeDateArray:"");
		$this->set('filterTakenTimeCountArray', isset($filterTakenTimeCountArray)?$filterTakenTimeCountArray:0);*/
		$this->cleanliness_survey($fromDate,$toDate);
		$this->service_survey($fromDate,$toDate);
		$this->satisfaction_survey($fromDate,$toDate);
		$this->recommendation_survey($fromDate,$toDate);

		// patient OPD query //
		$opdCount = $this->Patient->find('all', array('fields' => array('COUNT(*) AS patientopdcount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'Patient.admission_type', 'Patient.location_id', 'Patient.id', 'Patient.is_deleted'), 'group' => array("month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('Patient.admission_type' => 'OPD', 'Patient.is_deleted' => 0, 'Patient.location_id' => $this->Session->read('locationid')), 'recursive' => -1));
		foreach($opdCount as $opdCountVal) {
			$filterOpdDateArray[] = $opdCountVal[0]['month_reports'];
			$filterOpdCountArray[$opdCountVal[0]['month_reports']] = $opdCountVal[0]['patientopdcount'];
		}
		$this->filterOpdDateArray=$filterOpdDateArray;
		$this->filterOpdCountArray=$filterOpdCountArray;
		$this->set('filterOpdDateArray', isset($filterOpdDateArray)?$filterOpdDateArray:"");
		$this->set('filterOpdCountArray', isset($filterOpdCountArray)?$filterOpdCountArray:0);
		// patient IPD query //
		$ipdCount = $this->Patient->find('all', array('fields' => array('COUNT(*) AS patientipdcount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'Patient.admission_type', 'Patient.location_id', 'Patient.id', 'Patient.is_deleted'), 'group' => array("month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('Patient.admission_type' => 'IPD', 'Patient.is_deleted' => 0, 'Patient.location_id' => $this->Session->read('locationid')), 'recursive' => -1));
		//debug($ipdCount);
		foreach($ipdCount as $ipdCountVal) {

			$filterIpdDateArray[] = $ipdCountVal[0]['month_reports'];
			$filterIpdCountArray[$ipdCountVal[0]['month_reports']] = $ipdCountVal[0]['patientipdcount'];
		}
		//debug($filterIpdDateArray);
		$this->filterIpdDateArray=$filterIpdDateArray;
		$this->filterIpdCountArray = $filterIpdCountArray ;
		$this->set('filterIpdDateArray', isset($filterIpdDateArray)?$filterIpdDateArray:"");
		$this->set('filterIpdCountArray', isset($filterIpdCountArray)?$filterIpdCountArray:0);

		while($toDate > $fromDate) {
			$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
			$expfromdate = explode("-", $fromDate);
			$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
		}

		$this->set('yaxisArray', $yaxisArray);
		$this->set('reportYear', $reportYear);

		//$this->render('chart_dashboard') ;


		/*
		 $this->loadModel('UserDashboardChart');
		$userDashboardChart = $this->UserDashboardChart->find('all', array('conditions' => array('UserDashboardChart.user_id' => $this->Auth->user('id')), 'order' => array('UserDashboardChart.ordervalue ASC')));
		$this->set('userDashboardChart', $userDashboardChart);
		$this->render('chart_dashboard') ; */

	}


	public function chart_dashboard(){
		$this->loadModel('UserDashboardChart');
		$userDashboardChart = $this->UserDashboardChart->find('all', array('conditions' => array('UserDashboardChart.user_id' => $this->Auth->user('id')), 'order' => array('UserDashboardChart.ordervalue ASC')));
		$this->set('userDashboardChart', $userDashboardChart);
	}
	/**
	 *
	 *  doctor dashboard showing basic chart graph
	 *
	 */
	private function doctordashboard() {
		$fromDate = date("Y")."-01-01"; // set first date of current year
		$toDate = date("Y")."-12-31";
		$this->incidentReport();
		$this->haiReport();
		$this->losReport();
		$this->opdPatientSurveyReport();
		// common for all monthly wise report //
		while($toDate > $fromDate) {
			$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
			$expfromdate = explode("-", $fromDate);
			$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
		}
		$this->set('yaxisArray', $yaxisArray);
	}

	/**
	 *
	 *  length of stay report chart graph
	 *
	 */
	private function losReport($fromDate=NULL, $toDate=NULL) {
		$this->uses = array('Patient', 'FinalBilling');
		$reportYear = date("Y");
		$fromDate = $reportYear."-01-01"; // set first date of current year
		$toDate = $reportYear."-12-31";
		$ipdCount = $this->Patient->find('all', array('fields' => array('COUNT(*) AS ipdcount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'Patient.admission_type', 'Patient.location_id', 'Patient.id'), 'group' => array("month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('Patient.admission_type'=> 'IPD', 'Patient.location_id' => $this->Session->read('locationid'))));

		foreach($ipdCount as $ipdCountVal) {
			$filterIpdDateArray[] = $ipdCountVal[0]['month_reports'];
			$filterIpdCountArray[$ipdCountVal[0]['month_reports']] = $ipdCountVal[0]['ipdcount'];
		}
		$this->set('filterIpdDateArray', isset($filterIpdDateArray)?$filterIpdDateArray:"");
		$this->set('filterIpdCountArray', isset($filterIpdCountArray)?$filterIpdCountArray:0);

		$dischargeDeathCount = $this->FinalBilling->find('all', array('fields' => array('COUNT(*) AS dischargedeathcount', 'DATE_FORMAT(discharge_date, "%M-%Y") AS month_reports', 'DATE_FORMAT(discharge_date, "%Y-%m-%d") AS discharge_date', 'FinalBilling.location_id', 'FinalBilling.id'), 'group' => array("month_reports  HAVING  discharge_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('FinalBilling.location_id' => $this->Session->read('locationid'), 'FinalBilling.reason_of_discharge' =>  array('Recovered', 'DAMA','Death'))));

		foreach($dischargeDeathCount as $dischargeDeathCountVal) {
			$filterdischargeDeathDateArray[] = $dischargeDeathCountVal[0]['month_reports'];
			$filterdischargeDeathCountArray[$dischargeDeathCountVal[0]['month_reports']] = $dischargeDeathCountVal[0]['dischargedeathcount'];
		}
		$this->set('filterdischargeDeathDateArray', isset($filterdischargeDeathDateArray)?$filterdischargeDeathDateArray:"");
		$this->set('filterdischargeDeathCountArray', isset($filterdischargeDeathCountArray)?$filterdischargeDeathCountArray:0);
	}

	/**
	 *
	 *  patient survey report chart graph
	 *
	 */
	private function opdPatientSurveyReport() {
		$this->uses = array('PatientSurvey');
		$reportYear = date("Y");
		$fromDate = $reportYear."-01-01"; // set first date of current year
		$toDate = $reportYear."-12-31"; // set last date of current year
		$this->cleanliness_survey($fromDate,$toDate);
		$this->service_survey($fromDate,$toDate);
		$this->satisfaction_survey($fromDate,$toDate);
		$this->recommendation_survey($fromDate,$toDate);
		// end //

	}

	/**
	 *
	 *  hai report chart graph
	 *
	 */
	private function haiReport() {
		$this->uses = array('NosocomialInfection', 'PatientExposure', 'FinalBilling');
		$reportYear = date("Y");
		$fromDate = $reportYear."-01-01"; // set first date of current year
		$toDate = $reportYear."-12-31"; // set last date of current year
		$this->hai_allreports($fromDate,$toDate);
		$dischargeDeathCount = $this->FinalBilling->find('all', array('fields' => array('COUNT(*) AS dischargedeathcount', 'DATE_FORMAT(discharge_date, "%M-%Y") AS month_reports', 'DATE_FORMAT(discharge_date, "%Y-%m-%d") AS discharge_date', 'FinalBilling.location_id', 'FinalBilling.id'), 'group' => array("month_reports  HAVING  discharge_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('FinalBilling.location_id' => $this->Session->read('locationid'), 'FinalBilling.reason_of_discharge' =>  array('Recovered', 'DAMA','Death'))));

		foreach($dischargeDeathCount as $dischargeDeathCountVal) {
			$filterdischargeDeathDateArray[] = $dischargeDeathCountVal[0]['month_reports'];
			$filterdischargeDeathCountArray[$dischargeDeathCountVal[0]['month_reports']] = $dischargeDeathCountVal[0]['dischargedeathcount'];
		}
		$this->set('filterdischargeDeathDateArray', isset($filterdischargeDeathDateArray)?$filterdischargeDeathDateArray:"");
		$this->set('filterdischargeDeathCountArray', isset($filterdischargeDeathCountArray)?$filterdischargeDeathCountArray:0);
	}
	/**
	 *
	 *  incident chart graph
	 *
	 */
	private function incidentReport() {
		$this->uses = array('Incident','FinalBilling');

		$format = $this->request->data['Report']['format'];
		$search_ele  = $this->request->data['Report'];
		$this->Incident->bindModel(array(
				'belongsTo' => array(
						'Location' =>array('foreignKey' => 'location_id'),
						'FinalBilling'=>array('foreignKey'=>false,'conditions'=>array('FinalBilling.patient_id=Incident.patient_id',"reason_of_discharge != '' "))
				)),false);
		$search_key = array('Incident.location_id'=>$this->Session->read('locationid'));

		$search_key = array('Incident.incident_date >='=>date("Y")."-01-01",'Incident.incident_date <='=>date("Y")."-12-31");


		$fields =array('medication_error','analysis_option','incident_date','FinalBilling.reason_of_discharge');
		$record = $this->Incident->find('all',array('fields'=>$fields,'conditions'=>$search_key));

		$discharge = $this->FinalBilling->find('all',array('fields'=>array('monthname(discharge_date) as month,year(discharge_date) as year ,count(*) as count'),'conditions'=>array("reason_of_discharge != ''"),'group'=>array('MONTH( discharge_date ) , YEAR( discharge_date )')));

		if(!empty($discharge)){

			//discharge count
			$monthCount = array();

			foreach($discharge as $key =>$disMonth){
				$monthCount[$disMonth[0]['month']]  = $disMonth[0]['count'] ;

			}
			$m = 1 ;
			$f = 1;
			$fa = 1;
			$s =1 ;
			$in =1 ;

			foreach($record as $pdfData){

				if(!empty($pdfData['FinalBilling']['reason_of_discharge'])){
					$medication_error = $pdfData['Incident']['medication_error'];
					$analysis_option  = $pdfData['Incident']['analysis_option'];
					$month =date('M',strtotime($pdfData['Incident']['incident_date'])) ;
					$error = array();

					if(!empty($medication_error)){
						$error[$month] = $m;
						$m++ ;
					}
					if($analysis_option=='tranfusion error'){
						$fusionJan[$month] = $f;
						$f++ ;
					}
					if($analysis_option=='patient fall'){
						$fallJan[$month] = $fa;
						$fa++ ;
					}
					if($analysis_option=='bed sores') {
						$soreJan[$month]= $s;
						$s++ ;
					}
					if($analysis_option=='needle stick injury'){
						$injuryJan[$month] = $in;
						$in++ ;
					}
				}
			}

			$month =array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
			$fullMonth =array('Jan'=>'January','Feb'=>'February','Mar'=>'March','Apr'=>'April','May'=>'May','Jun'=>'June','Jul'=>'July','Aug'=>'August','Sep'=>'September','Oct'=>'October','Nov'=>'November','Dec'=>'December');

			foreach($month as $mon){

				$fullMonthCount = $monthCount[$fullMonth[$mon]] ;
				if($fullMonthCount > 0 ){

					$medicationErrorArray[$fullMonth[$mon]]  = ($error[$mon]/$fullMonthCount)*100;
					$fusionArray[$fullMonth[$mon]]			 = ($fusionJan[$mon]/$fullMonthCount)*100;
					$fallArray[$fullMonth[$mon]]			 = ($fallJan[$mon]/$fullMonthCount)*100;
					$soreArray[$fullMonth[$mon]]			 = ($soreJan[$mon]/$fullMonthCount)*100;
					$injuryArray[$fullMonth[$mon]]			 = ($injuryJan[$mon]/$fullMonthCount)*100;
				}
			}


			$this->set(array('medicationArray'=>$medicationErrorArray,'fusionArray'=>$fusionArray,'fallArray'=>$fallArray,'soreArray'=>$soreArray,'injuryArray'=>$injuryArray));
		}
		//retrive the last yr in db
		$this->Incident->recursive = -1 ;
		$last = $this->Incident->find('first',array('fields'=>array('incident_date'),'order'=>'incident_date desc'));
		$this->set('endyear',date('Y',strtotime($last['Incident']['incident_date']))) ;
		$this->set('pdfData',$last);


	}

	/**
	 * hospital acquire infections survey all record reports (default page, yearly report by cases and rate)
	 *
	 */

	private function hai_allreports($fromDate=null,$toDate=null) {
		if(empty($fromDate) && empty($toDate)) {
			$fromDate = date("Y")."-01-01"; // set first date of current year
			$toDate = date("Y")."-12-31";
		}
		$ssiCount = $this->NosocomialInfection->find('all', array('fields' => array('COUNT(*) AS ssicount', 'DATE_FORMAT(submit_date, "%M-%Y") AS month_reports', 'NosocomialInfection.surgical_site_infection', 'submit_date', 'NosocomialInfection.location_id', 'NosocomialInfection.id'), 'conditions' => array('NosocomialInfection.location_id' => $this->Session->read('locationid'), 'NosocomialInfection.surgical_site_infection' => 'Yes','NosocomialInfection.submit_date BETWEEN ? AND ?' => array($fromDate, $toDate)), 'group' => array('surgical_site_infection', 'month_reports')));
		foreach($ssiCount as $ssiCountVal) {
			$filterSsiDateArray[] = $ssiCountVal[0]['month_reports'];
			$filterSsiCountArray[$ssiCountVal[0]['month_reports']] = $ssiCountVal[0]['ssicount'];
		}
		$this->set('filterSsiDateArray', isset($filterSsiDateArray)?$filterSsiDateArray:"");
		$this->set('filterSsiCountArray', isset($filterSsiCountArray)?$filterSsiCountArray:0);

		$spCount = $this->PatientExposure->find('all', array('fields' => array('COUNT(*) AS spcount', 'DATE_FORMAT(submit_date, "%M-%Y") AS month_reports', 'PatientExposure.surgical_procedure', 'submit_date', 'PatientExposure.location_id', 'PatientExposure.id'), 'conditions' => array('PatientExposure.location_id' => $this->Session->read('locationid'), 'PatientExposure.surgical_procedure' => 'Yes','PatientExposure.submit_date BETWEEN ? AND ?' => array($fromDate, $toDate)), 'group' => array('surgical_procedure', 'month_reports')));
		foreach($spCount as $spCountVal) {
			$filterSpDateArray[] = $spCountVal[0]['month_reports'];
			$filterSpCountArray[$spCountVal[0]['month_reports']] = $spCountVal[0]['spcount'];
		}
		$this->set('filterSpDateArray', isset($filterSpDateArray)?$filterSpDateArray:"");
		$this->set('filterSpCountArray', isset($filterSpCountArray)?$filterSpCountArray:0);


		$vapCount = $this->NosocomialInfection->find('all', array('fields' => array('COUNT(*) AS vapcount', 'DATE_FORMAT(submit_date, "%M-%Y") AS month_reports', 'NosocomialInfection.ventilator_associated_pneumonia', 'submit_date', 'NosocomialInfection.location_id', 'NosocomialInfection.id'), 'conditions' => array('NosocomialInfection.location_id' => $this->Session->read('locationid'), 'NosocomialInfection.ventilator_associated_pneumonia' => 'Yes','NosocomialInfection.submit_date BETWEEN ? AND ?' => array($fromDate, $toDate)), 'group' => array('ventilator_associated_pneumonia', 'month_reports')));
		foreach($vapCount as $vapCountVal) {
			$filterVapDateArray[] = $vapCountVal[0]['month_reports'];
			$filterVapCountArray[$vapCountVal[0]['month_reports']] = $vapCountVal[0]['vapcount'];
		}
		$this->set('filterVapDateArray', isset($filterVapDateArray)?$filterVapDateArray:"");
		$this->set('filterVapCountArray', isset($filterVapCountArray)?$filterVapCountArray:0);

		$mvCount = $this->PatientExposure->find('all', array('fields' => array('COUNT(*) AS mvcount', 'DATE_FORMAT(submit_date, "%M-%Y") AS month_reports', 'PatientExposure.mechanical_ventilation', 'submit_date', 'PatientExposure.location_id', 'PatientExposure.id'), 'conditions' => array('PatientExposure.location_id' => $this->Session->read('locationid'), 'PatientExposure.mechanical_ventilation' => 'Yes','PatientExposure.submit_date BETWEEN ? AND ?' => array($fromDate, $toDate)), 'group' => array('mechanical_ventilation', 'month_reports')));
		foreach($mvCount as $mvCountVal) {
			$filterMvDateArray[] = $mvCountVal[0]['month_reports'];
			$filterMvCountArray[$mvCountVal[0]['month_reports']] = $mvCountVal[0]['mvcount'];
		}

		$this->set('filterMvDateArray', isset($filterMvDateArray)?$filterMvDateArray:"");
		$this->set('filterMvCountArray', isset($filterMvCountArray)?$filterMvCountArray:0);

		$utiCount = $this->NosocomialInfection->find('all', array('fields' => array('COUNT(*) AS uticount', 'DATE_FORMAT(submit_date, "%M-%Y") AS month_reports', 'NosocomialInfection.urinary_tract_infection', 'submit_date', 'NosocomialInfection.location_id', 'NosocomialInfection.id'), 'conditions' => array('NosocomialInfection.location_id' => $this->Session->read('locationid'), 'NosocomialInfection.urinary_tract_infection' => 'Yes','NosocomialInfection.submit_date BETWEEN ? AND ?' => array($fromDate, $toDate)), 'group' => array('urinary_tract_infection', 'month_reports')));
		foreach($utiCount as $utiCountVal) {
			$filterUtiDateArray[] = $utiCountVal[0]['month_reports'];
			$filterUtiCountArray[$utiCountVal[0]['month_reports']] = $utiCountVal[0]['uticount'];
		}
		$this->set('filterUtiDateArray', isset($filterUtiDateArray)?$filterUtiDateArray:"");
		$this->set('filterUtiCountArray', isset($filterUtiCountArray)?$filterUtiCountArray:0);

		$ucCount = $this->PatientExposure->find('all', array('fields' => array('COUNT(*) AS uccount', 'DATE_FORMAT(submit_date, "%M-%Y") AS month_reports', 'PatientExposure.urinary_catheter', 'submit_date', 'PatientExposure.location_id', 'PatientExposure.id'), 'conditions' => array('PatientExposure.location_id' => $this->Session->read('locationid'), 'PatientExposure.urinary_catheter' => 'Yes','PatientExposure.submit_date BETWEEN ? AND ?' => array($fromDate, $toDate)), 'group' => array('urinary_catheter', 'month_reports')));
		foreach($ucCount as $ucCountVal) {
			$filterUcDateArray[] = $ucCountVal[0]['month_reports'];
			$filterUcCountArray[$ucCountVal[0]['month_reports']] = $ucCountVal[0]['uccount'];
		}
		$this->set('filterUcDateArray', isset($filterUcDateArray)?$filterUcDateArray:"");
		$this->set('filterUcCountArray', isset($filterUcCountArray)?$filterUcCountArray:0);

		$bsiCount = $this->NosocomialInfection->find('all', array('fields' => array('COUNT(*) AS bsicount', 'DATE_FORMAT(submit_date, "%M-%Y") AS month_reports', 'NosocomialInfection.clabsi', 'submit_date', 'NosocomialInfection.location_id', 'NosocomialInfection.id'), 'conditions' => array('NosocomialInfection.location_id' => $this->Session->read('locationid'), 'NosocomialInfection.clabsi' => 'Yes','NosocomialInfection.submit_date BETWEEN ? AND ?' => array($fromDate, $toDate)), 'group' => array('clabsi', 'month_reports')));
		foreach($bsiCount as $bsiCountVal) {
			$filterBsiDateArray[] = $bsiCountVal[0]['month_reports'];
			$filterBsiCountArray[$bsiCountVal[0]['month_reports']] = $bsiCountVal[0]['bsicount'];
		}
		$this->set('filterBsiDateArray', isset($filterBsiDateArray)?$filterBsiDateArray:"");
		$this->set('filterBsiCountArray', isset($filterBsiCountArray)?$filterBsiCountArray:0);

		$clCount = $this->PatientExposure->find('all', array('fields' => array('COUNT(*) AS clcount', 'DATE_FORMAT(submit_date, "%M-%Y") AS month_reports', 'PatientExposure.central_line', 'submit_date', 'PatientExposure.location_id', 'PatientExposure.id'), 'conditions' => array('PatientExposure.location_id' => $this->Session->read('locationid'), 'PatientExposure.central_line' => 'Yes','PatientExposure.submit_date BETWEEN ? AND ?' => array($fromDate, $toDate)), 'group' => array('central_line', 'month_reports')));
		foreach($clCount as $clCountVal) {
			$filterClDateArray[] = $clCountVal[0]['month_reports'];
			$filterClCountArray[$clCountVal[0]['month_reports']] = $clCountVal[0]['clcount'];
		}
		$this->set('filterClDateArray', isset($filterClDateArray)?$filterClDateArray:"");
		$this->set('filterClCountArray', isset($filterClCountArray)?$filterClCountArray:0);

		$thromboCount = $this->NosocomialInfection->find('all', array('fields' => array('COUNT(*) AS thrombocount', 'DATE_FORMAT(submit_date, "%M-%Y") AS month_reports', 'NosocomialInfection.thrombophlebitis', 'submit_date', 'NosocomialInfection.location_id', 'NosocomialInfection.id'), 'conditions' => array('NosocomialInfection.location_id' => $this->Session->read('locationid'), 'NosocomialInfection.thrombophlebitis' => 'Yes','NosocomialInfection.submit_date BETWEEN ? AND ?' => array($fromDate, $toDate)), 'group' => array('thrombophlebitis', 'month_reports')));
		foreach($thromboCount as $thromboCountVal) {
			$filterThromboDateArray[] = $thromboCountVal[0]['month_reports'];
			$filterThromboCountArray[$thromboCountVal[0]['month_reports']] = $thromboCountVal[0]['thrombocount'];
		}
		$this->set('filterThromboDateArray', isset($filterThromboDateArray)?$filterThromboDateArray:"");
		$this->set('filterThromboCountArray', isset($filterThromboCountArray)?$filterThromboCountArray:0);

		$plCount = $this->PatientExposure->find('all', array('fields' => array('COUNT(*) AS plcount', 'DATE_FORMAT(submit_date, "%M-%Y") AS month_reports', 'PatientExposure.peripheral_line', 'submit_date', 'PatientExposure.location_id', 'PatientExposure.id'), 'conditions' => array('PatientExposure.location_id' => $this->Session->read('locationid'), 'PatientExposure.peripheral_line' => 'Yes','PatientExposure.submit_date BETWEEN ? AND ?' => array($fromDate, $toDate)), 'group' => array('peripheral_line', 'month_reports')));
		foreach($plCount as $plCountVal) {
			$filterPlDateArray[] = $plCountVal[0]['month_reports'];
			$filterPlCountArray[$plCountVal[0]['month_reports']] = $plCountVal[0]['plcount'];
		}
		$this->set('filterPlDateArray', isset($filterPlDateArray)?$filterPlDateArray:"");
		$this->set('filterPlCountArray', isset($filterPlCountArray)?$filterPlCountArray:0);

		$otherCount = $this->NosocomialInfection->find('all', array('fields' => array('COUNT(*) AS othercount', 'DATE_FORMAT(submit_date, "%M-%Y") AS month_reports', 'NosocomialInfection.other_nosocomial_infection', 'submit_date', 'NosocomialInfection.location_id', 'NosocomialInfection.id'), 'conditions' => array('NosocomialInfection.location_id' => $this->Session->read('locationid'), 'NosocomialInfection.other_nosocomial_infection' => 'Yes','NosocomialInfection.submit_date BETWEEN ? AND ?' => array($fromDate, $toDate)), 'group' => array('other_nosocomial_infection', 'month_reports')));
		foreach($otherCount as $otherCountVal) {
			$filterOtherDateArray[] = $otherCountVal[0]['month_reports'];
			$filterOtherCountArray[$otherCountVal[0]['month_reports']] = $otherCountVal[0]['othercount'];
		}
		$this->set('filterOtherDateArray', isset($filterOtherDateArray)?$filterOtherDateArray:"");
		$this->set('filterOtherCountArray', isset($filterOtherCountArray)?$filterOtherCountArray:0);
	}




	/**
	 *
	 * cleanliness survey report query
	 *
	 **/

	private function cleanliness_survey($fromDate=NULL, $toDate=NULL) {
		$stAgreeCleanCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS stagreeanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("question_id, month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Strongly Agree', 'PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.survey_category' => 'cleanliness', 'PatientSurvey.patient_type' => 'OPD'), 'recursive' => -1));

		foreach($stAgreeCleanCount as $stAgreeCleanCountVal) {
			$stAgreeDateCleanArray[] = $stAgreeCleanCountVal[0]['month_reports'];
			$stAgreeQuestIdCleanArray[] = $stAgreeCleanCountVal['PatientSurvey']['question_id'];
			$stAgreeAnsCountCleanArray[$stAgreeCleanCountVal['PatientSurvey']['question_id']][$stAgreeCleanCountVal[0]['month_reports']] = $stAgreeCleanCountVal[0]['stagreeanscount'];
		}
		$this->stAgreeDateCleanArray=$stAgreeDateCleanArray;
		$this->stAgreeQuestIdCleanArray=$stAgreeQuestIdCleanArray;
		$this->stAgreeAnsCountCleanArray=$stAgreeAnsCountCleanArray;
		$this->set('stAgreeDateCleanArray', isset($stAgreeDateCleanArray)?$stAgreeDateCleanArray:"");
		$this->set('stAgreeQuestIdCleanArray', isset($stAgreeQuestIdCleanArray)?$stAgreeQuestIdCleanArray:"");
		$this->set('stAgreeAnsCountCleanArray', isset($stAgreeAnsCountCleanArray)?$stAgreeAnsCountCleanArray:0);

		$agreeCleanCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS agreeanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("question_id, month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Agree', 'PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.survey_category' => 'cleanliness', 'PatientSurvey.patient_type' => 'OPD'), 'recursive' => -1));

		foreach($agreeCleanCount as $agreeCleanCountVal) {
			$agreeDateCleanArray[] = $agreeCleanCountVal[0]['month_reports'];
			$agreeQuestIdCleanArray[] = $agreeCleanCountVal['PatientSurvey']['question_id'];
			$agreeAnsCountCleanArray[$agreeCleanCountVal['PatientSurvey']['question_id']][$agreeCleanCountVal[0]['month_reports']] = $agreeCleanCountVal[0]['agreeanscount'];
		}
		$this->set('agreeDateCleanArray', isset($agreeDateCleanArray)?$agreeDateCleanArray:"");
		$this->set('agreeQuestIdCleanArray', isset($agreeQuestIdCleanArray)?$agreeQuestIdCleanArray:"");
		$this->set('agreeAnsCountCleanArray', isset($agreeAnsCountCleanArray)?$agreeAnsCountCleanArray:0);

		$nandAnsCleanCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS nandanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("question_id, month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Neither Agree Nor  Disagree', 'PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.survey_category' => 'cleanliness', 'PatientSurvey.patient_type' => 'OPD'), 'recursive' => -1));

		foreach($nandAnsCleanCount as $nandAnsCleanCountVal) {
			$nandDateCleanArray[] = $nandAnsCleanCountVal[0]['month_reports'];
			$nandQuestIdCleanArray[] = $nandAnsCleanCountVal['PatientSurvey']['question_id'];
			$nandAnsCountCleanArray[$nandAnsCleanCountVal['PatientSurvey']['question_id']][$nandAnsCleanCountVal[0]['month_reports']] = $nandAnsCleanCountVal[0]['nandanscount'];
		}
		$this->nandDateCleanArray=$nandDateCleanArray;
		$this->nandQuestIdCleanArray=$nandQuestIdCleanArray;
		$this->nandAnsCountCleanArray=$nandAnsCountCleanArray;
		$this->set('nandDateCleanArray', isset($nandDateCleanArray)?$nandDateCleanArray:"");
		$this->set('nandQuestIdCleanArray', isset($nandQuestIdCleanArray)?$nandQuestIdCleanArray:"");
		$this->set('nandAnsCountCleanArray', isset($nandAnsCountCleanArray)?$nandAnsCountCleanArray:0);

		$disagreeAnsCleanCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS disagreeanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("question_id, month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Disagree', 'PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.survey_category' => 'cleanliness', 'PatientSurvey.patient_type' => 'OPD'), 'recursive' => -1));

		foreach($disagreeAnsCleanCount as $disagreeAnsCleanCountVal) {
			$disgreeDateCleanArray[] = $disagreeAnsCleanCountVal[0]['month_reports'];
			$disgreeQuestIdCleanArray[] = $disagreeAnsCleanCountVal['PatientSurvey']['question_id'];
			$disgreeAnsCountCleanArray[$disagreeAnsCleanCountVal['PatientSurvey']['question_id']][$disagreeAnsCleanCountVal[0]['month_reports']] = $disagreeAnsCleanCountVal[0]['disagreeanscount'];
		}
		$this->disgreeDateCleanArray=$disgreeDateCleanArray;
		$this->disgreeQuestIdCleanArray=$disgreeQuestIdCleanArray;
		$this->disgreeAnsCountCleanArray=$disgreeAnsCountCleanArray;
		$this->set('disgreeDateCleanArray', isset($disgreeDateCleanArray)?$disgreeDateCleanArray:"");
		$this->set('disgreeQuestIdCleanArray', isset($disgreeQuestIdCleanArray)?$disgreeQuestIdCleanArray:"");
		$this->set('disgreeAnsCountCleanArray', isset($disgreeAnsCountCleanArray)?$disgreeAnsCountCleanArray:0);

		$stdAnsCleanCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS stdanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("question_id, month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Strongly Disagree', 'PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.survey_category' => 'cleanliness', 'PatientSurvey.patient_type' => 'OPD'), 'recursive' => -1));

		foreach($stdAnsCleanCount as $stdAnsCleanCountVal) {
			$stdDateCleanArray[] = $stdAnsCleanCountVal[0]['month_reports'];
			$stdQuestIdCleanArray[] = $stdAnsCleanCountVal['PatientSurvey']['question_id'];
			$stdAnsCountCleanArray[$stdAnsCleanCountVal['PatientSurvey']['question_id']][$stdAnsCleanCountVal[0]['month_reports']] = $stdAnsCleanCountVal[0]['stdanscount'];
		}
		$this->stdDateCleanArray=$stdDateCleanArray;
		$this->stdQuestIdCleanArray=$stdQuestIdCleanArray;
		$this->stdAnsCountCleanArray=$stdAnsCountCleanArray;
		$this->set('stdDateCleanArray', isset($stdDateCleanArray)?$stdDateCleanArray:"");
		$this->set('stdQuestIdCleanArray', isset($stdQuestIdCleanArray)?$stdQuestIdCleanArray:"");
		$this->set('stdAnsCountCleanArray', isset($stdAnsCountCleanArray)?$stdAnsCountCleanArray:0);


	}

	/**
	 *
	 * service survey report query
	 *
	 **/

	private function service_survey($fromDate=NULL, $toDate=NULL) {
		$stAgreeServiceCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS stagreeanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("question_id, month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Strongly Agree', 'PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.survey_category' => 'service', 'PatientSurvey.patient_type' => 'OPD'), 'recursive' => -1));

		foreach($stAgreeServiceCount as $stAgreeServiceCountVal) {
			$stAgreeDateServiceArray[] = $stAgreeServiceCountVal[0]['month_reports'];
			$stAgreeQuestIdServiceArray[] = $stAgreeServiceCountVal['PatientSurvey']['question_id'];
			$stAgreeAnsCountServiceArray[$stAgreeServiceCountVal['PatientSurvey']['question_id']][$stAgreeServiceCountVal[0]['month_reports']] = $stAgreeServiceCountVal[0]['stagreeanscount'];
		}
		$this->set('stAgreeDateServiceArray', isset($stAgreeDateServiceArray)?$stAgreeDateServiceArray:"");
		$this->set('stAgreeQuestIdServiceArray', isset($stAgreeQuestIdServiceArray)?$stAgreeQuestIdServiceArray:"");
		$this->set('stAgreeAnsCountServiceArray', isset($stAgreeAnsCountServiceArray)?$stAgreeAnsCountServiceArray:0);

		$agreeServiceCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS agreeanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("question_id, month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Agree', 'PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.survey_category' => 'service', 'PatientSurvey.patient_type' => 'OPD'), 'recursive' => -1));

		foreach($agreeServiceCount as $agreeServiceCountVal) {
			$agreeDateServiceArray[] = $agreeServiceCountVal[0]['month_reports'];
			$agreeQuestIdServiceArray[] = $agreeServiceCountVal['PatientSurvey']['question_id'];
			$agreeAnsCountServiceArray[$agreeServiceCountVal['PatientSurvey']['question_id']][$agreeServiceCountVal[0]['month_reports']] = $agreeServiceCountVal[0]['agreeanscount'];
		}
		$this->set('agreeDateServiceArray', isset($agreeDateServiceArray)?$agreeDateServiceArray:"");
		$this->set('agreeQuestIdServiceArray', isset($agreeQuestIdServiceArray)?$agreeQuestIdServiceArray:"");
		$this->set('agreeAnsCountServiceArray', isset($agreeAnsCountServiceArray)?$agreeAnsCountServiceArray:0);

		$nandAnsServiceCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS nandanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("question_id, month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Neither Agree Nor  Disagree', 'PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.survey_category' => 'service', 'PatientSurvey.patient_type' => 'OPD'), 'recursive' => -1));

		foreach($nandAnsServiceCount as $nandAnsServiceCountVal) {
			$nandDateServiceArray[] = $nandAnsServiceCountVal[0]['month_reports'];
			$nandQuestIdServiceArray[] = $nandAnsServiceCountVal['PatientSurvey']['question_id'];
			$nandAnsCountServiceArray[$nandAnsServiceCountVal['PatientSurvey']['question_id']][$nandAnsServiceCountVal[0]['month_reports']] = $nandAnsServiceCountVal[0]['nandanscount'];
		}
		$this->set('nandDateServiceArray', isset($nandDateServiceArray)?$nandDateServiceArray:"");
		$this->set('nandQuestIdServiceArray', isset($nandQuestIdServiceArray)?$nandQuestIdServiceArray:"");
		$this->set('nandAnsCountServiceArray', isset($nandAnsCountServiceArray)?$nandAnsCountServiceArray:0);

		$disagreeAnsServiceCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS disagreeanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("question_id, month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Disagree', 'PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.survey_category' => 'service', 'PatientSurvey.patient_type' => 'OPD'), 'recursive' => -1));

		foreach($disagreeAnsServiceCount as $disagreeAnsServiceCountVal) {
			$disgreeDateServiceArray[] = $disagreeAnsServiceCountVal[0]['month_reports'];
			$disgreeQuestIdServiceArray[] = $disagreeAnsServiceCountVal['PatientSurvey']['question_id'];
			$disgreeAnsCountServiceArray[$disagreeAnsServiceCountVal['PatientSurvey']['question_id']][$disagreeAnsServiceCountVal[0]['month_reports']] = $disagreeAnsServiceCountVal[0]['disagreeanscount'];
		}
		$this->set('disgreeDateServiceArray', isset($disgreeDateServiceArray)?$disgreeDateServiceArray:"");
		$this->set('disgreeQuestIdServiceArray', isset($disgreeQuestIdServiceArray)?$disgreeQuestIdServiceArray:"");
		$this->set('disgreeAnsCountServiceArray', isset($disgreeAnsCountServiceArray)?$disgreeAnsCountServiceArray:0);

		$stdAnsServiceCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS stdanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("question_id, month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Strongly Disagree', 'PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.survey_category' => 'service', 'PatientSurvey.patient_type' => 'OPD'), 'recursive' => -1));

		foreach($stdAnsServiceCount as $stdAnsServiceCountVal) {
			$stdDateServiceArray[] = $stdAnsServiceCountVal[0]['month_reports'];
			$stdQuestIdServiceArray[] = $stdAnsServiceCountVal['PatientSurvey']['question_id'];
			$stdAnsCountServiceArray[$stdAnsServiceCountVal['PatientSurvey']['question_id']][$stdAnsServiceCountVal[0]['month_reports']] = $stdAnsServiceCountVal[0]['stdanscount'];
		}
		$this->set('stdDateServiceArray', isset($stdDateServiceArray)?$stdDateServiceArray:"");
		$this->set('stdQuestIdServiceArray', isset($stdQuestIdServiceArray)?$stdQuestIdServiceArray:"");
		$this->set('stdAnsCountServiceArray', isset($stdAnsCountServiceArray)?$stdAnsCountServiceArray:0);


	}

	/**
	 *
	 * satisfaction survey report query
	 *
	 **/

	private function satisfaction_survey($fromDate=NULL, $toDate=NULL) {
		$stAgreeSatisCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS stagreeanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("question_id, month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Strongly Agree', 'PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.survey_category' => 'satisfaction', 'PatientSurvey.patient_type' => 'OPD'), 'recursive' => -1));

		foreach($stAgreeSatisCount as $stAgreeSatisCountVal) {
			$stAgreeDateSatisArray[] = $stAgreeSatisCountVal[0]['month_reports'];
			$stAgreeQuestIdSatisArray[] = $stAgreeSatisCountVal['PatientSurvey']['question_id'];
			$stAgreeAnsCountSatisArray[$stAgreeSatisCountVal['PatientSurvey']['question_id']][$stAgreeSatisCountVal[0]['month_reports']] = $stAgreeSatisCountVal[0]['stagreeanscount'];
		}
		$this->set('stAgreeDateSatisArray', isset($stAgreeDateSatisArray)?$stAgreeDateSatisArray:"");
		$this->set('stAgreeQuestIdSatisArray', isset($stAgreeQuestIdSatisArray)?$stAgreeQuestIdSatisArray:"");
		$this->set('stAgreeAnsCountSatisArray', isset($stAgreeAnsCountSatisArray)?$stAgreeAnsCountSatisArray:0);

		$agreeSatisCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS agreeanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("question_id, month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Agree', 'PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.survey_category' => 'satisfaction', 'PatientSurvey.patient_type' => 'OPD'), 'recursive' => -1));

		foreach($agreeSatisCount as $agreeSatisCountVal) {
			$agreeDateSatisArray[] = $agreeSatisCountVal[0]['month_reports'];
			$agreeQuestIdSatisArray[] = $agreeSatisCountVal['PatientSurvey']['question_id'];
			$agreeAnsCountSatisArray[$agreeSatisCountVal['PatientSurvey']['question_id']][$agreeSatisCountVal[0]['month_reports']] = $agreeSatisCountVal[0]['agreeanscount'];
		}
		$this->set('agreeDateSatisArray', isset($agreeDateSatisArray)?$agreeDateSatisArray:"");
		$this->set('agreeQuestIdSatisArray', isset($agreeQuestIdSatisArray)?$agreeQuestIdSatisArray:"");
		$this->set('agreeAnsCountSatisArray', isset($agreeAnsCountSatisArray)?$agreeAnsCountSatisArray:0);

		$nandAnsSatisCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS nandanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("question_id, month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Neither Agree Nor  Disagree', 'PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.survey_category' => 'satisfaction', 'PatientSurvey.patient_type' => 'OPD'), 'recursive' => -1));

		foreach($nandAnsSatisCount as $nandAnsSatisCountVal) {
			$nandDateSatisArray[] = $nandAnsSatisCountVal[0]['month_reports'];
			$nandQuestIdSatisArray[] = $nandAnsSatisCountVal['PatientSurvey']['question_id'];
			$nandAnsCountSatisArray[$nandAnsSatisCountVal['PatientSurvey']['question_id']][$nandAnsSatisCountVal[0]['month_reports']] = $nandAnsSatisCountVal[0]['nandanscount'];
		}
		$this->set('nandDateSatisArray', isset($nandDateSatisArray)?$nandDateSatisArray:"");
		$this->set('nandQuestIdSatisArray', isset($nandQuestIdSatisArray)?$nandQuestIdSatisArray:"");
		$this->set('nandAnsCountSatisArray', isset($nandAnsCountSatisArray)?$nandAnsCountSatisArray:0);

		$disagreeAnsSatisCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS disagreeanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("question_id, month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Disagree', 'PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.survey_category' => 'satisfaction', 'PatientSurvey.patient_type' => 'OPD'), 'recursive' => -1));

		foreach($disagreeAnsSatisCount as $disagreeAnsSatisCountVal) {
			$disgreeDateSatisArray[] = $disagreeAnsSatisCountVal[0]['month_reports'];
			$disgreeQuestIdSatisArray[] = $disagreeAnsSatisCountVal['PatientSurvey']['question_id'];
			$disgreeAnsCountSatisArray[$disagreeAnsSatisCountVal['PatientSurvey']['question_id']][$disagreeAnsSatisCountVal[0]['month_reports']] = $disagreeAnsSatisCountVal[0]['disagreeanscount'];
		}
		$this->set('disgreeDateSatisArray', isset($disgreeDateSatisArray)?$disgreeDateSatisArray:"");
		$this->set('disgreeQuestIdSatisArray', isset($disgreeQuestIdSatisArray)?$disgreeQuestIdSatisArray:"");
		$this->set('disgreeAnsCountSatisArray', isset($disgreeAnsCountSatisArray)?$disgreeAnsCountSatisArray:0);

		$stdAnsSatisCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS stdanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("question_id, month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Strongly Disagree', 'PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.survey_category' => 'satisfaction', 'PatientSurvey.patient_type' => 'OPD'), 'recursive' => -1));

		foreach($stdAnsSatisCount as $stdAnsSatisCountVal) {
			$stdDateSatisArray[] = $stdAnsSatisCountVal[0]['month_reports'];
			$stdQuestIdSatisArray[] = $stdAnsSatisCountVal['PatientSurvey']['question_id'];
			$stdAnsCountSatisArray[$stdAnsSatisCountVal['PatientSurvey']['question_id']][$stdAnsSatisCountVal[0]['month_reports']] = $stdAnsSatisCountVal[0]['stdanscount'];
		}
		$this->set('stdDateSatisArray', isset($stdDateSatisArray)?$stdDateSatisArray:"");
		$this->set('stdQuestIdSatisArray', isset($stdQuestIdSatisArray)?$stdQuestIdSatisArray:"");
		$this->set('stdAnsCountSatisArray', isset($stdAnsCountSatisArray)?$stdAnsCountSatisArray:0);


	}

	/**
	 *
	 * recommendation survey report query
	 *
	 **/

	private function recommendation_survey($fromDate=NULL, $toDate=NULL) {
		$stAgreeRecomCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS stagreeanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("question_id, month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Strongly Agree', 'PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.survey_category' => 'recommendation', 'PatientSurvey.patient_type' => 'OPD'), 'recursive' => -1));

		foreach($stAgreeRecomCount as $stAgreeRecomCountVal) {
			$stAgreeDateRecomArray[] = $stAgreeRecomCountVal[0]['month_reports'];
			$stAgreeQuestIdRecomArray[] = $stAgreeRecomCountVal['PatientSurvey']['question_id'];
			$stAgreeAnsCountRecomArray[$stAgreeRecomCountVal['PatientSurvey']['question_id']][$stAgreeRecomCountVal[0]['month_reports']] = $stAgreeRecomCountVal[0]['stagreeanscount'];
		}
		$this->stAgreeDateRecomArray=$stAgreeDateRecomArray;
		$this->stAgreeQuestIdRecomArray=$stAgreeQuestIdRecomArray;
		$this->stAgreeAnsCountRecomArray=$stAgreeAnsCountRecomArray;
		$this->set('stAgreeDateRecomArray', isset($stAgreeDateRecomArray)?$stAgreeDateRecomArray:"");
		$this->set('stAgreeQuestIdRecomArray', isset($stAgreeQuestIdRecomArray)?$stAgreeQuestIdRecomArray:"");
		$this->set('stAgreeAnsCountRecomArray', isset($stAgreeAnsCountRecomArray)?$stAgreeAnsCountRecomArray:0);

		$agreeRecomCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS agreeanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("question_id, month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Agree', 'PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.survey_category' => 'recommendation', 'PatientSurvey.patient_type' => 'OPD'), 'recursive' => -1));

		foreach($agreeRecomCount as $agreeRecomCountVal) {
			$agreeDateRecomArray[] = $agreeRecomCountVal[0]['month_reports'];
			$agreeQuestIdRecomArray[] = $agreeRecomCountVal['PatientSurvey']['question_id'];
			$agreeAnsCountRecomArray[$agreeRecomCountVal['PatientSurvey']['question_id']][$agreeRecomCountVal[0]['month_reports']] = $agreeRecomCountVal[0]['agreeanscount'];
		}
		$this->set('agreeDateRecomArray', isset($agreeDateRecomArray)?$agreeDateRecomArray:"");
		$this->set('agreeQuestIdRecomArray', isset($agreeQuestIdRecomArray)?$agreeQuestIdRecomArray:"");
		$this->set('agreeAnsCountRecomArray', isset($agreeAnsCountRecomArray)?$agreeAnsCountRecomArray:0);

		$nandAnsRecomCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS nandanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("question_id, month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Neither Agree Nor  Disagree', 'PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.survey_category' => 'recommendation', 'PatientSurvey.patient_type' => 'OPD'), 'recursive' => -1));

		foreach($nandAnsRecomCount as $nandAnsRecomCountVal) {
			$nandDateRecomArray[] = $nandAnsRecomCountVal[0]['month_reports'];
			$nandQuestIdRecomArray[] = $nandAnsRecomCountVal['PatientSurvey']['question_id'];
			$nandAnsCountRecomArray[$nandAnsRecomCountVal['PatientSurvey']['question_id']][$nandAnsRecomCountVal[0]['month_reports']] = $nandAnsRecomCountVal[0]['nandanscount'];
		}
		$this->set('nandDateRecomArray', isset($nandDateRecomArray)?$nandDateRecomArray:"");
		$this->set('nandQuestIdRecomArray', isset($nandQuestIdRecomArray)?$nandQuestIdRecomArray:"");
		$this->set('nandAnsCountRecomArray', isset($nandAnsCountRecomArray)?$nandAnsCountRecomArray:0);

		$disagreeAnsRecomCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS disagreeanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("question_id, month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Disagree', 'PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.survey_category' => 'recommendation', 'PatientSurvey.patient_type' => 'OPD'), 'recursive' => -1));

		foreach($disagreeAnsRecomCount as $disagreeAnsRecomCountVal) {
			$disgreeDateRecomArray[] = $disagreeAnsRecomCountVal[0]['month_reports'];
			$disgreeQuestIdRecomArray[] = $disagreeAnsRecomCountVal['PatientSurvey']['question_id'];
			$disgreeAnsCountRecomArray[$disagreeAnsRecomCountVal['PatientSurvey']['question_id']][$disagreeAnsRecomCountVal[0]['month_reports']] = $disagreeAnsRecomCountVal[0]['disagreeanscount'];
		}
		$this->set('disgreeDateRecomArray', isset($disgreeDateRecomArray)?$disgreeDateRecomArray:"");
		$this->set('disgreeQuestIdRecomArray', isset($disgreeQuestIdRecomArray)?$disgreeQuestIdRecomArray:"");
		$this->set('disgreeAnsCountRecomArray', isset($disgreeAnsCountRecomArray)?$disgreeAnsCountRecomArray:0);

		$stdAnsRecomCount = $this->PatientSurvey->find('all', array('fields' => array('COUNT(*) AS stdanscount', 'DATE_FORMAT(create_time, "%M-%Y") AS month_reports', 'DATE_FORMAT(create_time, "%Y-%m-%d") AS register_date', 'PatientSurvey.question_id', 'PatientSurvey.location_id', 'PatientSurvey.id'), 'group' => array("question_id, month_reports  HAVING  register_date BETWEEN '{$fromDate}' AND '{$toDate}'"), 'conditions' => array('PatientSurvey.answer' => 'Strongly Disagree', 'PatientSurvey.location_id' => $this->Session->read('locationid'), 'PatientSurvey.survey_category' => 'recommendation', 'PatientSurvey.patient_type' => 'OPD'), 'recursive' => -1));

		foreach($stdAnsRecomCount as $stdAnsRecomCountVal) {
			$stdDateRecomArray[] = $stdAnsRecomCountVal[0]['month_reports'];
			$stdQuestIdRecomArray[] = $stdAnsRecomCountVal['PatientSurvey']['question_id'];
			$stdAnsCountRecomArray[$stdAnsRecomCountVal['PatientSurvey']['question_id']][$stdAnsRecomCountVal[0]['month_reports']] = $stdAnsRecomCountVal[0]['stdanscount'];
		}
		$this->set('stdDateRecomArray', isset($stdDateRecomArray)?$stdDateRecomArray:"");
		$this->set('stdQuestIdRecomArray', isset($stdQuestIdRecomArray)?$stdQuestIdRecomArray:"");
		$this->set('stdAnsCountRecomArray', isset($stdAnsCountRecomArray)?$stdAnsCountRecomArray:0);


	}

	/*
	 *
	* change password function
	*
	*/
	public function change_password($action=null) {
		$this->loadModel('User');
		$this->loadModel('LoginAttempt');
		if($action == 'forceChange') $this->layout = 'advance_ajax' ; //for force change password no need to display layout.

		$checkUser = $this->User->find('first', array('conditions' => array('User.username' => $this->request->data['User']['username'],
				'User.password' =>sha1(trim($this->request->data['User']['password'])))));
		$previousPassword = array();
		if(!empty($checkUser['User']['previous_password']))
			$previousPassword  = unserialize($checkUser['User']['previous_password']) ;
			
		$currentDateTime =  (array)new DateTime("now", new DateTimeZone(Configure::read('login_attempt_timezone')));
		$currentDateTime =   $currentDateTime['date'] ;
			
		if($this->request->is('post') && !in_array($this->request->data['User']['newpassword'],$previousPassword)) {
			if(trim($this->request->data['User']['password']) != trim($this->request->data['User']['newpassword'])) {
				//$checkUser = $this->User->find('count', array('conditions' => array('User.username' => $this->request->data['User']['username'], 'User.password' =>sha1(trim($this->request->data['User']['password'])))));
				if(!empty($checkUser['User']['id'])) {
					$this->User->id = AuthComponent::user('id');
					$this->request->data['User']['password'] = $this->request->data['User']['newpassword'];
					$this->request->data['User']['password_expiry'] = date('Y-m-d') ;
					$this->request->data['User']['first_login'] = 'no' ;
					if(count($previousPassword)==3) unset($previousPassword[0]); //unset first entry cause we need to check last entries only
					$this->request->data['User']['previous_password'] =	serialize(array_merge($previousPassword,array($this->request->data['User']['password']))) ;

					$this->User->save($this->request->data);
					//BOF pankaj
					//reset all failed login for logged in user .
					$this->LoginAttempt->updateAll(array('user_login_attempt'=>0,'ip_login_attempt'=>0,'user_last_login'=>"'".$currentDateTime."'",'ip_last_login'=>"'".$currentDateTime."'"),array('username'=>$this->request->data['User']['username'])) ;
					//reset all failed login for logged in user IP Address.
					$this->LoginAttempt->updateAll(array('user_login_attempt'=>0,'ip_login_attempt'=>0,'user_last_login'=>"'".$currentDateTime."'",'ip_last_login'=>"'".$currentDateTime."'"),array('ip_address'=>$this->request->clientIp())) ;
					//EOF pankaj
					$this->Session->setFlash(__('Your password has been changed successfully.'),'default',array('class'=>'message'));
					$this->redirect("/Landings") ;
				} else {
					$this->Session->setFlash(__('Enter correct current password.'),'default',array('class'=>'error'));
				}
			} else {
				$this->Session->setFlash(__('Refrain from using current password.'),'default',array('class'=>'error'));
			}
		}else if(in_array($this->request->data['User']['newpassword'],$previousPassword)){
			$this->Session->setFlash(__('Do not reuse last 3 passwords.'),'default',array('class'=>'error'));
		}
		$this->request->data = null;
	}

	function ajaxlogin(){
		$this->layout =false ;
	}

	//arg : location id of current user
	function checkLocation($currentLoc){
		if($this->Cookie->read('location_id')){
			$lastCookie = $this->Cookie->read('location_id');
			if($lastCookie != $currentLoc){ //check last logged in user's location id with current user.
				$this->Session->delete('Config.redirect');	//flush last visited url n let the used redirect to welcome screen
				$this->Cookie->write('location_id',$currentLoc, $encrypt = false, $expires = null);//maintain locationid
			}
		}else{
			$this->Cookie->write('location_id',$currentLoc, $encrypt = false, $expires = null);//maintain locationid
		}
	}

	function getUsersByRole($role_id){
		$this->layout = false ;
		$this->autoRender = false ;
		return json_encode($this->User->getUsersByRole($role_id));
		exit;
	}

	//Doctor dashboard
	function doctor_dashboard(){
	
		//to redirect billing manager and cashier to new ipd dashboard
		if($this->Session->read('role')==Configure::read('billing_manager_role')|| strtolower($this->Session->read('role'))==Configure::read('cashier_role')){
			//$this->redirect(array('Controller'=>'Billings','action'=>'doctor_dashboard'));
			$this->redirect('/Billings/doctor_dashboard');
		}else if($this->Session->read('website.instance')=='vadodara' &&($this->Session->read('role')!=Configure::read('doctorLabel') || $this->Session->read('role')!=Configure::read('nurseLabel'))){
			
		}else{
			$slidesArray = array('slideone','slidetwo','slidethree','slidefour','slidefive'); 
			$is_exist = in_array($this->params->query['type'], $slidesArray);
			if($is_exist == 1){
				$this->layout = 'advance_ajax';
			}else{
				$this->layout = 'advance';
			}
			$doctors = $this->User->getDoctorsByLocation($this->Session->read('locationid'));
			$this->set(array('data'=>$data,'doctors'=>$doctors,'nurses'=>$nurses,'is_exist'=>$is_exist,'slidesArray'=>$slidesArray));
			$this->render('doctor_dashboard') ;
		}


	}

	//Ajax rendering for dashboard patient list
	function dashboard_patient_list(){
		//$this->allowDRM('Billings',array('multiplePaymentModeIpd'));
		//$this->layout = 'ajax' ;
		$this->uses = array('Patient','LaboratoryTestOrder','NoteDiagnosis','NewCropPrescription','EKG','RadiologyTestOrder',
				'LaboratoryResult','RadiologyResult','Person','ReviewSubCategoriesOption','ReviewPatientDetail','Appointment','Notes','TariffStandard');
		$this->Patient->unBindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn')));

		 
		$this->Patient->bindModel(array(
				'belongsTo'=>array(
						'Ward'=>array('foreignKey'=>'ward_id','type'=>'inner'),
						'Room'=>array('foreignKey'=>'room_id'),
						'Bed'=>array('foreignKey'=>'bed_id'),
						'Diagnosis'=>array('foreignKey'=>false,'conditions'=>array('Diagnosis.patient_id=Patient.id','Diagnosis.is_discharge'=>0)),
						'Note'=>array('foreignKey'=>false,
								'conditions'=>array('Note.patient_id=Patient.id')),//,'order'=>array('Note.id'=>'DESC')
						'Person'=>array('foreignKey'=>false,'conditions'=>array('Patient.patient_id = Person.patient_uid')),
						'Billing'=>array('foreignKey'=>false,'conditions'=>array('Patient.id = Billing.patient_id')),
						'OptAppointment'=>array('foreignKey'=>false,
								'conditions'=>array('Patient.id = OptAppointment.patient_id'),
								'fields'=> array('OptAppointment.patient_id','Patient.*')),
						'TariffStandard' => array('primary_key'=>false,
								'conditions'=> array('TariffStandard.id=Patient.tariff_standard_id'),
								'fields'=> array('TariffStandard.name','TariffStandard.id','Patient.*')),
						"BillingAlias"=>array('className'=>'Billing',"foreignKey"=>false ,
								'conditions'=>array('BillingAlias.patient_id=Patient.id','BillingAlias.payment_category'=>$paymentCategoryId['ServiceCategory']['id'])),
						'CorporateSublocation' => array('foreignKey'=>false,
								'conditions'=> array('CorporateSublocation.id=Patient.corporate_sublocation_id')),
									
				)),false);

		$rolename = $this->Session->read('role');
		//bof vikas
		$this->Person->bindModel(array(
				'belongsTo'=>array('Patient'=>array('type'=>'INNER','foreignKey'=>false,'conditions'=>array('Patient.patient_id = Person.patient_uid'))),
		));
		$this->Person->bindModel(array(
				'belongsTo'=>array('Appointment'=>array('type'=>'INNER','foreignKey'=>false,'conditions'=>array('Appointment.person_id = Person.id')))
		));


		//eof vikas

	if(!empty($this->request->data['User']['All Doctors']) || !empty($this->params->query['doctor_id']) || (strtolower($rolename) == strtolower(Configure::read('doctorLabel')))){
			if(strtolower($rolename) == strtolower(Configure::read('doctorLabel'))){
				$userId = $this->Session->read('userid');
			}else if(!empty($this->params->query['doctor_id'])){
				$userId = $this->params->query['doctor_id'];
				$this->set('paginateArg',$this->params->query['doctor_id']);
			}else{
				$userId = $this->request->data['User']['All Doctors'];
				$this->set('paginateArg',$this->request->data['User']['All Doctors']);
			}
			$conditions = array('Patient.location_id'=>$this->Session->read('locationid'),'Patient.doctor_id'=>$userId,'Patient.is_deleted'=>0, 'Patient.is_discharge'=>'0') ;
		}else{
			$conditions = array('Patient.location_id'=>$this->Session->read('locationid'),'Patient.is_deleted'=>0) ;
		}

		if(!empty($this->params->query['dateFrom'])){
			$from = $this->DateFormat->formatDate2STD($this->params->query['dateFrom'],Configure::read('date_format'))." 00:00:00";

		}
		if(!empty($this->params->query['dateTo'])){
			$to = $this->DateFormat->formatDate2STD($this->params->query['dateTo'],Configure::read('date_format'))." 23:59:59";
		}

		if(!empty($this->params->query['data']['User']['Discharged']) && $this->params->query['data']['User']['Discharged']==1 ){
			//if discharge chekbox is checked condition on discharge date
			if($to)
				$conditions['Patient.discharge_date <='] = $to;
			if($from)
				$conditions['Patient.discharge_date >='] = $from;
		}else{
			if($to)
				$conditions['Patient.form_received_on <='] = $to;
			if($from)
				$conditions['Patient.form_received_on >='] = $from;
		}
		//Should not show discharged patient on patient list .. will be seen only in search...
		if(empty($this->request->data['User']['Patient Name']) && empty($this->params->query['doctorsId']) && empty($this->params->query['dateTo']) && empty($this->params->query['dateFrom']) && empty($this->request->data['User']['Discharged']))
			$conditions['Patient.is_discharge']='0';

	if($this->request->data['User']['Discharged']==1 && isset($this->request->data['User']['Patient Name'])){
		$patientName=explode('-',$this->request->data['User']['Patient Name']);
		$conditions['Patient.lookup_name LIKE'] =  "%".$patientName[0]."%";
	 	$conditions['Patient.location_id']=$this->Session->read('locationid');
	 	$this->request->data['Patient']['is_deleted']=0;
	 	$conditions['Patient.is_discharge']=1;
	 	$order='Patient.discharge_date ASC' ;
	 	
	 }else if(isset($this->request->data['User']['Patient Name'])){
	 	$patientName=explode('-',$this->request->data['User']['Patient Name']);
	 	$conditions['Patient.lookup_name LIKE'] =  "%".$patientName[0]."%";
	 	$conditions['Patient.is_discharge']='0';
	 	$order='Ward.sort_order ASC';
	}else{
	 	$conditions['Patient.is_discharge']='0';
	}

	 if($this->params->query['doctorsId']){
	 	 
	 	$docArray=explode('_',$this->params->query['doctorsId']);
	 	$docArray=implode(',',$docArray);
	 	if(!empty($docArray)){
	 		unset($conditions['Patient.doctor_id']);
	 		$selectedDoctors = ('Patient.doctor_id IN ('.$docArray.")");
	 	}
	 	$rt='1';
	 	$this->set('rtSelect',$rt);
	 }
	 /** Soap Note lated **/
		//$conditions['Note.compelete_note'] ='0';
		/** **/
	 if($this->params->pass['0']=='print'){
	 	$limit='1000';
	 }else{
	 	$limit='10';
	 }
	 $this->paginate = array(
				'limit' => $limit,
				'fields'=> array('Patient.id','Patient.lookup_name','Patient.sex','Ward.name','Room.bed_prefix','Bed.bedno','Patient.age',
						'Patient.form_received_on','Patient.mobile_phone','Patient.patient_id','Patient.corporate_sublocation_id','Diagnosis.id','Patient.person_id','Patient.dashboard_status',
						'Note.id','Note.sign_note','Billing.total_amount',
						'Billing.amount_paid','Billing.amount_pending','Billing.patient_id','Patient.is_discharge',
						'Patient.admission_id','Patient.form_received_on','Patient.clearance',
						'Patient.nurse_id','Patient.doctor_id','Person.sex','Person.dob','Person.vip_chk','Note.id','Note.sign_note','OptAppointment.id',
						'OptAppointment.patient_id','OptAppointment.procedure_complete',/*,'Appointment.purpose'*/'Patient.discharge_date',
						'TariffStandard.name','CorporateSublocation.name',
						'SUM(BillingAlias.total_amount) as aliasTotal','SUM(BillingAlias.amount) as aliasPaid','Person.mobile',),
	 		/*'order'=>array('Ward.sort_order'),*/
				'conditions'=>array($conditions,$selectedDoctors),'order' => $order /*by atul*/,
				'group'=>('Patient.id'));
		$data = $this->paginate('Patient') ;
		if(!empty($data)){
			foreach($data as $patientKey => $patientValue){
				$ids[] = $patientValue['Patient']['id'] ;
				$customArray[$patientValue['Patient']['id']]['Patient'] = $patientValue ;
				$customArray[$patientValue['Patient']['id']]['Patient']['Patient']['patient_age'] = $this->General->convertYearsMonthsToDaysSeparate($patientValue['Patient']['age']); // get exact age -
			}
			$idsStr = implode(",",$ids) ;

			$labOrderData = $this->LaboratoryTestOrder->find('all',array('fields'=>array('Count(*) as lab','patient_id'),
					'conditions'=>array("LaboratoryTestOrder.patient_id IN ($idsStr)"),
					'group'=>array('LaboratoryTestOrder.patient_id')));

			$radOrderData = $this->RadiologyTestOrder->find('all',array('fields'=>array('Count(*) as rad','patient_id'),
					'conditions'=>array("RadiologyTestOrder.patient_id IN ($idsStr)"),
					'group'=>array('RadiologyTestOrder.patient_id')));

			$noteDiagnosisData = $this->NoteDiagnosis->find('all',array('fields'=>array('NoteDiagnosis.diagnoses_name','NoteDiagnosis.patient_id'),
					'conditions'=>array("NoteDiagnosis.patient_id IN ($idsStr)"),'order'=>array('NoteDiagnosis.id DESC') ));

			$medData = $this->NewCropPrescription->find('all',array('fields'=>array('Count(NewCropPrescription.drug_name) as med','patient_uniqueid'),
					'conditions'=>array('NewCropPrescription.archive'=>"N", "NewCropPrescription.patient_uniqueid IN ($idsStr)"),
					'group'=>array('NewCropPrescription.patient_id')));

			/*$ekgData = $this->EKG->find('all',array('fields'=>array('Count(*) as ekg','patient_id'),'conditions'=>array("EKG.patient_id IN ($idsStr)"),
					'group'=>array('EKG.patient_id')));*/

			$labResultData = $this->LaboratoryResult->find('all',array('fields'=>array('Count(*) as labResult','patient_id'),
					'conditions'=>array("LaboratoryResult.patient_id IN ($idsStr)"),
					'group'=>array('LaboratoryResult.patient_id')));

			$radResultData = $this->RadiologyResult->find('all',array('fields'=>array('Count(*) as radResult','patient_id'),
					'conditions'=>array("RadiologyResult.patient_id IN ($idsStr)"),
					'group'=>array('RadiologyResult.patient_id')));

			$this->ReviewPatientDetail->bindModel(array(
					'belongsTo'=>array(
							'ReviewSubCategoriesOption'=>array('foreignKey'=>false,
									'conditions'=>array('ReviewPatientDetail.review_sub_categories_options_id = ReviewSubCategoriesOption.id'),
							))),false);
			/*$vitalsData = $this->ReviewPatientDetail->find('all',array('fields'=>array('DISTINCT (ReviewSubCategoriesOption.name) AS name',
					'ReviewPatientDetail.patient_id','ReviewPatientDetail.values','ReviewSubCategoriesOption.unit'),
					'conditions'=>array("ReviewPatientDetail.patient_id IN ($idsStr)",//'ReviewPatientDetail.date' => date('Y-m-d'),
							'ReviewSubCategoriesOption.name' => Configure::read('vitals_for_tracking_board'),'ReviewPatientDetail.edited_on' => NULL),
					'order'=>array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC' )
			));*/

			foreach($labOrderData as $labKey => $labValue){
				$customArray[$labValue['LaboratoryTestOrder']['patient_id']]['LaboratoryTestOrder'] = $labValue[0] ;
			}
			foreach($radOrderData as $labKey => $labValue){
				$customArray[$labValue['RadiologyTestOrder']['patient_id']]['RadiologyTestOrder'] = $labValue[0] ;
			}
			foreach($noteDiagnosisData as $labKey => $labValue){
				$customArray[$labValue['NoteDiagnosis']['patient_id']]['NoteDiagnosis']  =  $labValue['NoteDiagnosis']  ;
			}
			foreach($medData as $labKey => $labValue){
				$customArray[$labValue['NewCropPrescription']['patient_uniqueid']]['NewCropPrescription'] = $labValue[0] ;
			}
			foreach($ekgData as $labKey => $labValue){
				$customArray[$labValue['EKG']['patient_id']]['EKG'] = $labValue[0] ;
			}
			foreach($labResultData as $labKey => $labValue){
				$customArray[$labValue['LaboratoryResult']['patient_id']]['LaboratoryResult'] = $labValue[0] ;
			}
			foreach($radResultData as $labKey => $labValue){
				$customArray[$labValue['RadiologyResult']['patient_id']]['RadiologyResult'] = $labValue[0] ;
			}
			/*foreach($vitalsData as $vitals){
				$customArray[$vitals['ReviewPatientDetail']['patient_id']]['vitalData'][$vitals['ReviewSubCategoriesOption']['name']] =
				$vitals['ReviewPatientDetail']['values'].' '.$vitals['ReviewSubCategoriesOption']['unit'] ;
			}*/
			$doctors = $this->User->getDoctorsByLocation($this->Session->read('locationid'));
			$nurses  = $this->User->getUsersByRoleName(Configure::read('nurseLabel')) ;
		}
		$this->set(array('data'=>$customArray,'doctors'=>$doctors,'nurses'=>$nurses));
		
	}
	
	//For Dashboard SlideShow
	public function ipd_dashboard_icu_ward_slide_one($type){
		$this->uses = array('Patient','LaboratoryTestOrder','NoteDiagnosis','NewCropPrescription','EKG','RadiologyTestOrder',
				'LaboratoryResult','RadiologyResult','Person','ReviewSubCategoriesOption','ReviewPatientDetail','Appointment','Notes','TariffStandard');
		$this->Patient->unBindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		
			
		$this->Patient->bindModel(array(
				'belongsTo'=>array(
						'Ward'=>array('foreignKey'=>'ward_id','type'=>'inner'),
						'Room'=>array('foreignKey'=>'room_id'),
						'Bed'=>array('foreignKey'=>'bed_id'),
						'Diagnosis'=>array('foreignKey'=>false,'conditions'=>array('Diagnosis.patient_id=Patient.id','Diagnosis.is_discharge'=>0)),
						'Note'=>array('foreignKey'=>false,
								'conditions'=>array('Note.patient_id=Patient.id')),//,'order'=>array('Note.id'=>'DESC')
						'Person'=>array('foreignKey'=>false,'conditions'=>array('Patient.patient_id = Person.patient_uid')),
						'Billing'=>array('foreignKey'=>false,'conditions'=>array('Patient.id = Billing.patient_id')),
						'OptAppointment'=>array('foreignKey'=>false,
								'conditions'=>array('Patient.id = OptAppointment.patient_id'),
								'fields'=> array('OptAppointment.patient_id','Patient.*')),
						'TariffStandard' => array('primary_key'=>false,
								'conditions'=> array('TariffStandard.id=Patient.tariff_standard_id'),
								'fields'=> array('TariffStandard.name','TariffStandard.id','Patient.*')),
						"BillingAlias"=>array('className'=>'Billing',"foreignKey"=>false ,
								'conditions'=>array('BillingAlias.patient_id=Patient.id','BillingAlias.payment_category'=>$paymentCategoryId['ServiceCategory']['id'])),
						'CorporateSublocation' => array('foreignKey'=>false,
								'conditions'=> array('CorporateSublocation.id=Patient.corporate_sublocation_id')),
							
				)),false);
		
		$rolename = $this->Session->read('role');
		//bof vikas
		$this->Person->bindModel(array(
				'belongsTo'=>array('Patient'=>array('type'=>'INNER','foreignKey'=>false,'conditions'=>array('Patient.patient_id = Person.patient_uid'))),
		));
		$this->Person->bindModel(array(
				'belongsTo'=>array('Appointment'=>array('type'=>'INNER','foreignKey'=>false,'conditions'=>array('Appointment.person_id = Person.id')))
		));
		
		
		//eof vikas
		$conditions = array('Patient.location_id'=>$this->Session->read('locationid'),'Patient.is_deleted'=>0) ;
		
		//Should not show discharged patient on patient list .. will be seen only in search...
		if(empty($this->request->data['User']['Patient Name']) && empty($this->params->query['doctorsId']) && empty($this->params->query['dateTo']) && empty($this->params->query['dateFrom']) && empty($this->params->query['data']['User']['Discharged']))
			$conditions['Patient.is_discharge']='0';
		
		$order='Patient.form_received_on DESC';
		if($type == 'slideone'){	// FOR ICU & RICU WARD
			$conditions['Ward.ward_type'] = 'ICU';
		}else if($type == 'slidetwo'){ // FOR Special Ward
			$conditions['Ward.name'] = 'Special Ward';
		}else if($type == 'slidethree'){	//FOR General ward
			$conditions['Ward.id'] = 22;
		}else if($type == 'slidefour'){	//FOR General ward
			$conditions['Ward.id'] = 29;
		}else if($type == 'slidefive'){	//FOR General ward
			$conditions['Ward.id'] = 30;
		}
		
		/** Soap Note lated **/
		//$conditions['Note.compelete_note'] ='0';
		/** **/
		if($this->params->pass['0']=='print'){
			$limit='1000';
		}else{
			$limit='10';
		}
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'fields'=> array('Patient.id','Patient.lookup_name','Patient.sex','Ward.name','Room.bed_prefix','Bed.bedno','Patient.age',
						'Patient.form_received_on','Patient.corporate_sublocation_id','Diagnosis.id','Patient.person_id','Note.id','Note.sign_note','Billing.total_amount',
						'Billing.amount_paid','Billing.amount_pending','Billing.patient_id','Patient.is_discharge','Patient.admission_id',
						'Patient.admission_id','Patient.form_received_on','Patient.clearance',
						'Patient.nurse_id','Patient.doctor_id','Person.sex','Person.dob','Person.vip_chk','Note.id','Note.sign_note',
						'OptAppointment.patient_id','OptAppointment.procedure_complete',/*,'Appointment.purpose'*/'Patient.discharge_date',
						'TariffStandard.name','CorporateSublocation.name',
						'SUM(BillingAlias.total_amount) as aliasTotal','SUM(BillingAlias.amount) as aliasPaid'),
				/*'order'=>array('Ward.sort_order'),*/
				'conditions'=>array($conditions),'order' => $order /*by atul*/,
				'group'=>('Patient.id'));
		$data = $this->paginate('Patient') ;
			//debug($data);
		if(!empty($data)){
			foreach($data as $patientKey => $patientValue){
				$ids[] = $patientValue['Patient']['id'] ;
				$customArray[$patientValue['Patient']['id']]['Patient'] = $patientValue ;
			}
			$idsStr = implode(",",$ids) ;
		
			$labOrderData = $this->LaboratoryTestOrder->find('all',array('fields'=>array('Count(*) as lab','patient_id'),
					'conditions'=>array("LaboratoryTestOrder.patient_id IN ($idsStr)"),
					'group'=>array('LaboratoryTestOrder.patient_id')));
		
			$radOrderData = $this->RadiologyTestOrder->find('all',array('fields'=>array('Count(*) as rad','patient_id'),
					'conditions'=>array("RadiologyTestOrder.patient_id IN ($idsStr)"),
					'group'=>array('RadiologyTestOrder.patient_id')));
		
			$noteDiagnosisData = $this->NoteDiagnosis->find('all',array('fields'=>array('NoteDiagnosis.diagnoses_name','NoteDiagnosis.patient_id'),
					'conditions'=>array("NoteDiagnosis.patient_id IN ($idsStr)"),'order'=>array('NoteDiagnosis.id DESC') ));
		
			$medData = $this->NewCropPrescription->find('all',array('fields'=>array('Count(NewCropPrescription.drug_name) as med','patient_uniqueid'),
					'conditions'=>array('NewCropPrescription.archive'=>"N", "NewCropPrescription.patient_uniqueid IN ($idsStr)"),
					'group'=>array('NewCropPrescription.patient_id')));
		
			$labResultData = $this->LaboratoryResult->find('all',array('fields'=>array('Count(*) as labResult','patient_id'),
					'conditions'=>array("LaboratoryResult.patient_id IN ($idsStr)"),
					'group'=>array('LaboratoryResult.patient_id')));
		
			$radResultData = $this->RadiologyResult->find('all',array('fields'=>array('Count(*) as radResult','patient_id'),
					'conditions'=>array("RadiologyResult.patient_id IN ($idsStr)"),
					'group'=>array('RadiologyResult.patient_id')));
		
			$this->ReviewPatientDetail->bindModel(array(
					'belongsTo'=>array(
							'ReviewSubCategoriesOption'=>array('foreignKey'=>false,
									'conditions'=>array('ReviewPatientDetail.review_sub_categories_options_id = ReviewSubCategoriesOption.id'),
							))),false);
			
			
			$doctors = $this->User->getDoctorsByLocation($this->Session->read('locationid'));
			$nurses  = $this->User->getUsersByRoleName(Configure::read('nurseLabel')) ;
		}
		$this->set(array('data'=>$customArray,'doctors'=>$doctors,'nurses'=>$nurses));
		
		
	}

	//update level and status of patient from dashboard screen
	function dashboard_update($field=null,$patientID = null){
		if(!$patientID || !$field) echo "Unable to process your request" ;
		$this->uses = array('Patient');
		//$patientArray['id'] = $patientID ;
		if($field=='level'){
			$patientArray['dashboard_level'] = $this->request->data['value'];
		/*}else if($field == 'status'){
			$patientArray['dashboard_status'] = "'".$this->request->data['value']."'";*/
		}else if($field == 'nurse'){
			$patientArray['nurse_id'] = "'".$this->request->data['value']."'";
		}else if($field == 'doctor'){
			$patientArray['doctor_id'] = "'".$this->request->data['value']."'";
		}
		$result = $this->Patient->updateAll($patientArray,array('id'=>$patientID));
		if(!$result) echo "Please try again" ;
		exit;
	}

	public function admin_userIdCard($id=null){
		$this->uses = array('facility_user_mappings','facilities');
		//no need of layout
		$this->layout  = false ;
		$this->set('title_for_layout', __('-Print QR Card', true));
		if(!empty($id)){
			$this->User->unbindModel(array(
					'belongsTo'=>array('City','State','Country')));
			$this->User->bindModel(array(
					'belongsTo'=>array('Department' => array('foreignKey'    => 'department_id')
			  )));
			$userDetails = $this->User->find('first',array('fields'=>array('username','photo','Initial.name','first_name','last_name','Role.name','Department.name'),
					'conditions'=>array('User.id'=>$id,'User.is_deleted'=>0)));
			$this->facility_user_mappings->bindModel(array(
					'belongsTo'=>array(
							'facilities' => array('foreignKey'    => 'facility_id'),
							'states' => array('foreignKey'    => false,
									'conditions'=>array('states.id=facilities.state_id')),
							'countries' => array('foreignKey'    => false,
									'conditions'=>array('countries.id=facilities.country_id')))));
			$facilityId =	$this->facility_user_mappings->find('first',array('fields'=>array('facility_id','facilities.address1','countries.name',
					'states.name','facilities.phone1','facilities.zipcode','facilities.name'),
					'conditions'=>array('facility_user_mappings.username'=>$userDetails['User']['username'])));

			$idCardArray = array(
					'userName' => $userDetails['User']['username'],
					'completeName'=>$userDetails['Initial']['name']." ".$userDetails['User']['first_name']." ".$userDetails['User']['last_name'],
					'department'=>$userDetails['Department']['name'],
					'role'=>$userDetails['Role']['name'],
					'facilityName'=>$facilityId['facilities']['name'],
					'facilityAddress'=>$facilityId['facilities']['address1'].", ".$facilityId['states']['name']." -".$facilityId['facilities']['zipcode'].", ".$facilityId['countries']['name'],
					'facilityPhone'=>$facilityId['facilities']['phone1'],
					'userPhoto'=>$userDetails['User']['photo']
			);
			$this->set(compact('idCardArray'));
			//debug($idCardArray);
			//debug($userDetails);
		}

	}

	function setHospitalPermission(){
		$facility = $this->Session->read('facilityid');
		if($facility){
			$this->uses = array('AssignedModulePermission');
			$this->AssignedModulePermission->bindModel(array(
					"belongsTo" =>array(
							"ModulePermission"=>array("foreignKey"=>'module_permission_id')
					)
			));

			$result = $this->AssignedModulePermission->find('all',array('conditions'=>array('AssignedModulePermission.facility_id'=>$facility),
					'fields'=>array('ModulePermission.module')));
			foreach($result as $key=>$value){
				if($value['ModulePermission']['module']=='Nursing'){
					$resetArray[]='Nursings' ; //extra cond due to controller name change.
				}
				$resetArray[]= $value['ModulePermission']['module'];
			}
			$this->Session->write('module_permissions',$resetArray);
		}
	}

	//customize drag and drop chart code by Santosh Sir//


	/**
	 * customized user dashboard chart method
	 *
	 *
	 * @return void
	 */
	public function customize_chart_dashboard(){
		$this->loadModel('UserDashboardChart');
		$userDashboardChart = $this->UserDashboardChart->find('all', array('conditions' => array('UserDashboardChart.user_id' => $this->Auth->user('id')), 'order' => array('UserDashboardChart.ordervalue ASC')));
		$this->set('userDashboardChart', $userDashboardChart);

	}

	/**
	 * save customized user dashboard chart method
	 *
	 *
	 * @return void
	 */
	public function save_customize_chart_dashboard(){
		$this->loadModel('UserDashboardChart');
		if($this->request->is('post') || $this->request->is('put')) {
			$this->UserDashboardChart->deleteAll(array('UserDashboardChart.user_id' => $this->Auth->user('id')));
			foreach($this->request->data['chartname'] as $key => $val) {
				$this->UserDashboardChart->create();
				$this->request->data['UserDashboardChart']['user_id'] = $this->Auth->user('id');
				$this->request->data['UserDashboardChart']['chartname'] = $key;
				$this->request->data['UserDashboardChart']['ordervalue'] = $val;
				$this->request->data['UserDashboardChart']['create_time'] = date('Y-m-d H:i:s');
				$this->request->data['UserDashboardChart']['modify_time'] = date('Y-m-d H:i:s');
				$this->request->data['UserDashboardChart']['created_by'] = $this->Auth->user('id');
				$this->request->data['UserDashboardChart']['modified_by'] = $this->Auth->user('id');
				$this->UserDashboardChart->save($this->request->data);
				$this->UserDashboardChart->id = false;
			}
			$this->Session->setFlash(__('The dashboard chart has been saved'));
			$this->redirect(array('controller'=>'users','action'=>'customize_chart_dashboard'));
		}
	}

	/**
	 * customized user dashboard chart
	 * used to show customized user dashboard chart
	 * called by ajax request
	 *
	 */
	public function  createCustomizeChart() {
		$this->chartdashboard();
		$this->setYaxisArray();
		$chartypeid = $this->params->query['charttypeid'];

		if($chartypeid == "chart1") {
			$this->totalNumberOfUIDPatient();
		}
		if($chartypeid == "chart2") {
			$this->ipdPatientCashCard();
		}
		if($chartypeid == "chart3") {
			$this->OpdPatientSurvey();
		}
		if($chartypeid == "chart4") {
			$this->totalNumberOfIpdOpd();
		}
		if($this->request->is('ajax')){
			exit;
		}
	}

	/**
	 * customized user dashboard chart
	 * used to make array of x axis co-ordinate
	 * called by ajax request
	 *
	 */
	public function setYaxisArray() {
		$fromDate = date("Y")."-01-01"; // set first date of current year
		$toDate = date("Y")."-12-31";
		while($toDate > $fromDate) {
			$yaxisArray[date("F-Y", strtotime($fromDate))] = date("F", strtotime($fromDate));
			$expfromdate = explode("-", $fromDate);
			$fromDate = date("Y-m-d", strtotime(date("Y-m-d", mktime(0, 0, 0, $expfromdate[1]+1, $expfromdate[2], $expfromdate[0]))));
		}
			
		return $yaxisArray;
	}

	/**
	 * customized user dashboard chart
	 * used to set x axis co-ordinate
	 * called by ajax request
	 *
	 */
	public function setXaxisChartValue() {
		$yaxisArray = $this->setYaxisArray();
		$monthIndex = 0;
		foreach($yaxisArray as $yaxisArrayVal) {
			$arrData[$monthIndex][1]  = date("M", strtotime($yaxisArrayVal));
			$monthIndex++;
		}

		return $arrData;
	}

	/**
	 * customized user dashboard chart
	 * used to get number of UID patient
	 * called by ajax request
	 *
	 */
	public function totalNumberOfUIDPatient() {
		$yaxisArray = $this->setYaxisArray();
		$arrData = $this->setXaxisChartValue();
			
		$patientRegCountIndex=0;
		foreach($yaxisArray as $key => $yaxisArrayVal) {
			if(@in_array($key, $this->filterPatientRegDateArray)) {
				$arrData[$patientRegCountIndex][2] = $this->filterPatientRegCountArray[$key];
			} else {
				$arrData[$patientRegCountIndex][2] = 0;
			}
			$patientRegCountIndex++;
		}
		//Initialize <chart> element
		$strPatientRegXML = '<chart caption="Total Number of UID Patient Registration" xAxisName="Months" yAxisName="UID Patient Registration Count"  showValues="0" decimalPrecision="0"  bgColor="#394245" baseFontColor="ffffff"  divLineColor="4e6168" hoverCapBgColor="1B1B1B" legendBgColor="1B1B1B" canvasBgColor="1B1B1B"  toolTipBgColor="1B1B1B" plotGradientColor="" canvasBaseColor="#1B1B1B" use3DLighting="0">';
		$strPatientRegCategories = '<categories >';
		$strDataPatientRegCount = '<dataset seriesName="Patient Registration Count" color="AFD8F8">';
		foreach ($arrData as $arSubData) {
			$strPatientRegCategories .= '<category name="' . $arSubData[1] . '" />';
			$strDataPatientRegCount .= '<set value="' . $arSubData[2] . '" />';
		}
		$strPatientRegCategories .= '</categories>';
		$strDataPatientRegCount .= '</dataset>';
		$strPatientRegXML .= $strPatientRegCategories . $strDataPatientRegCount . '</chart>';

		$totalNumberOfUIDPatientChart = '<script>';
		$totalNumberOfUIDPatientChart .= 'var datastring = \''.$strPatientRegXML.'\';';
		$totalNumberOfUIDPatientChart .= '</script>';
		$totalNumberOfUIDPatientChart .= '<div id="totalNumberOfUIDPatientChart" align="center">FusionCharts</div>';
		$totalNumberOfUIDPatientChart .= '<script type="text/javascript">';
		$totalNumberOfUIDPatientChart .= 'FusionCharts.setCurrentRenderer("JavaScript");';
		$totalNumberOfUIDPatientChart .= 'var chart  = new FusionCharts("/fusionx_charts/MSColumn3D.swf", "chartdiv1", "400", "300", "0", "1");';
		$totalNumberOfUIDPatientChart .= 'chart.setXMLData(datastring);';
		$totalNumberOfUIDPatientChart .= 'chart.render("totalNumberOfUIDPatientChart");';
		$totalNumberOfUIDPatientChart .= '</script>';
		echo $totalNumberOfUIDPatientChart;
	}

	/**
	 * customized user dashboard chart
	 * used to get number of IPD and OPD patient related to cash and credit card
	 * called by ajax request
	 *
	 */
	public function ipdPatientCashCard() {
		$yaxisArray = $this->setYaxisArray();
		$arrData = $this->setXaxisChartValue();
		$cardCountIndex=0;
		foreach($yaxisArray as $key => $yaxisArrayVal) {
			if(@in_array($key, $this->filterCardDateArray)) {
				$arrData[$cardCountIndex][3] = $this->filterCardCountArray[$key];
			} else {
				$arrData[$cardCountIndex][3] = 0;
			}
			$cardCountIndex++;
		}
		$cashCountIndex=0;

		foreach($yaxisArray as $key => $yaxisArrayVal) {
			if(@in_array($key, $this->filterCashDateArray)) {
				$arrData[$cashCountIndex][2] = $this->filterCashCountArray[$key];
			} else {

				$arrData[$cashCountIndex][2] = 0;
			}
			$cashCountIndex++;
		}
		$strEmpanelXML = '<chart caption="Total Number of IPD Patient Cash/Card" xAxisName="Months" yAxisName="IPD Patient Cash/Card Count"  showValues="0" decimalPrecision="0"  bgColor="#394245" baseFontColor="ffffff"  divLineColor="4e6168" hoverCapBgColor="1B1B1B" legendBgColor="1B1B1B" canvasBgColor="1B1B1B"  toolTipBgColor="1B1B1B" plotGradientColor="" canvasBaseColor="#1B1B1B" use3DLighting="0">';
		$strEmpanelCategories = '<categories fontColor="ffffff">';
		$strDataEmpanelCashCount = '<dataset seriesName="Cash Count" color="AFD8F8">';
		$strDataEmpanelCardCount = '<dataset seriesName="Card Count" color="F6BD0F">';
		foreach ($arrData as $arSubData) {
			$strEmpanelCategories .= '<category name="' . $arSubData[1] . '" />';
			$strDataEmpanelCashCount .= '<set value="' . $arSubData[2] . '" />';
			$strDataEmpanelCardCount .= '<set value="' . $arSubData[3] . '" />';
		}
		$strEmpanelCategories .= '</categories>';
		$strDataEmpanelCashCount .= '</dataset>';
		$strDataEmpanelCardCount .= '</dataset>';
		$strEmpanelXML .= $strEmpanelCategories . $strDataEmpanelCashCount . $strDataEmpanelCardCount  . '</chart>';

		$totalNumberOfIpdPatientCashCardChart = '<script>';
		$totalNumberOfIpdPatientCashCardChart .= 'var datastring = \''.$strEmpanelXML.'\';';
		$totalNumberOfIpdPatientCashCardChart .= '</script>';
		$totalNumberOfIpdPatientCashCardChart .= '<div id="totalNumberOfIpdPatientCashCardChart" align="center">FusionCharts</div>';
		$totalNumberOfIpdPatientCashCardChart .= '<script type="text/javascript">';
		$totalNumberOfIpdPatientCashCardChart .= 'FusionCharts.setCurrentRenderer("JavaScript");';
		$totalNumberOfIpdPatientCashCardChart .= 'var chart  = new FusionCharts("/fusionx_charts/MSColumn3D.swf", "chartdiv2", "400", "300", "0", "1");';
		$totalNumberOfIpdPatientCashCardChart .= 'chart.setXMLData(datastring);';
		$totalNumberOfIpdPatientCashCardChart .= 'chart.render("totalNumberOfIpdPatientCashCardChart");';
		$totalNumberOfIpdPatientCashCardChart .= '</script>';

		echo  $totalNumberOfIpdPatientCashCardChart;
	}

	/**
	 * customized user dashboard chart
	 * used to display patient survey chart
	 * called by ajax request
	 *
	 */
	public function OpdPatientSurvey() {
		$yaxisArray = $this->setYaxisArray();
		$arrData = $this->setXaxisChartValue();
		$questions[1] = 'The cleanliness and comfort in the waiting area met my expectation?';
		$questions[2] = 'Toilets were clean and well maintained?';
		$questions[3] = 'All my doubts were answered by reception staff?';
		$questions[4] = 'Staff ensured that privacy of my information was maintained?';
		$questions[5] = 'I was seen at the appointment time by the doctor?';
		$questions[6] = 'I was guided for the doctor\'s consulation?';
		$questions[7] = 'I was taken in for my investigation at the appointed time?';
		$questions[8] = 'I was well informed about the procedure?';
		$questions[9] = 'I was informed about collecting report days and timing?';
		$questions[10] = 'Billing procedure was completed in 5 minute?';
		$questions[11] = 'I received my investigation reports at the scheduled time?';
		$questions[12] = 'I was able to get all the medicine in th Hospital pharmacy prescribed by the doctor?';
		$questions[13] = 'Reception Staff was polite,respectful and friendly with me?';
		$questions[14] = 'I was able to find my way to the investigation room easily?';
		$questions[15] = 'My personal privacy was maintained during  investigation?';
		$questions[16] = 'I was given full attention by the doctor?';
		$questions[17] = 'All my querries were answered by the doctor?';
		$questions[18] = 'I would recommend this hospital to others?';
		$questions[19] = 'Overall I am satisfied with the OPD services received in Hope Hospital?';
		$questionArray = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19');
		$cleanlinessQid = array('1', '2');
		$serviceQid = array('3', '4', '5', '6', '7', '8', '9', '10', '11', '12');
		$satisfactionQid = array('13', '14', '15', '16', '17');
		$recommendationQid = array('18', '19');

		// for calculating total score //
		$totalScore=0;
		$totalStrongAgree = 0;
		$totalAgree = 0;
		$totalNand = 0;
		$totalDisagree = 0;
		$totalStDisagree = 0;
		$highestCent = 0;
		for($i=1; $i <20; $i++) {
			foreach($yaxisArray as $key => $yaxisArrayVal) {
				// for strong agree answer plus cleanliness parameter //
				if(@in_array($i, $this->stAgreeQuestIdCleanArray)) {
					if(@in_array($key, array_keys($this->stAgreeAnsCountCleanArray[$i]))) {
						$totalStrongAgree = $this->stAgreeAnsCountCleanArray[$i][$key]*5;
					} else {
						$totalStrongAgree = 0;
					}
				}
				// for strong agree answer plus service parameter //
				elseif(@in_array($i, $this->stAgreeQuestIdServiceArray)) {
					if(@in_array($key, array_keys($this->stAgreeAnsCountServiceArray[$i]))) {
						$totalStrongAgree = $this->stAgreeAnsCountServiceArray[$i][$key]*5;
					} else {
						$totalStrongAgree = 0;
					}
				}
				// for strong agree answer plus satisfaction parameter //
				elseif(@in_array($i, $this->stAgreeQuestIdSatisArray)) {
					if(@in_array($key, array_keys($this->stAgreeAnsCountSatisArray[$i]))) {
						$totalStrongAgree = $this->stAgreeAnsCountSatisArray[$i][$key]*5;
					} else {
						$totalStrongAgree = 0;
					}
				}
				// for strong agree answer plus recommendation parameter //
				elseif(@in_array($i, $this->stAgreeQuestIdRecomArray)) {
					if(@in_array($key, array_keys($this->stAgreeAnsCountRecomArray[$i]))) {
						$totalStrongAgree = $this->stAgreeAnsCountRecomArray[$i][$key]*5;
					} else {
						$totalStrongAgree = 0;
					}
				}
				else {
					$totalStrongAgree = 0;
				}
					
				// for  agree answer plus cleanliness parameter//
				if(@in_array($i, $this->agreeQuestIdCleanArray)) {
					if(@in_array($key, array_keys($this->agreeAnsCountCleanArray[$i]))) {
						$totalAgree = $this->agreeAnsCountCleanArray[$i][$key]*4;
					} else {
						$totalAgree = 0;
					}
				}
				// for agree answer plus service parameter //
				elseif(@in_array($i, $this->agreeQuestIdServiceArray)) {
					if(@in_array($key, array_keys($this->agreeAnsCountServiceArray[$i]))) {
						$totalAgree = $this->agreeAnsCountServiceArray[$i][$key]*4;
					} else {
						$totalAgree = 0;
					}
				}
				// for agree answer plus satisfaction parameter //
				elseif(@in_array($i, $this->agreeQuestIdSatisArray)) {
					if(@in_array($key, array_keys($this->agreeAnsCountSatisArray[$i]))) {
						$totalAgree = $this->agreeAnsCountSatisArray[$i][$key]*4;
					} else {
						$totalAgree = 0;
					}
				}
				// for  agree answer plus recommendation parameter //
				elseif(@in_array($i, $this->agreeQuestIdRecomArray)) {
					if(@in_array($key, array_keys($this->agreeAnsCountRecomArray[$i]))) {
						$totalAgree = $this->agreeAnsCountRecomArray[$i][$key]*4;
					} else {
						$totalAgree = 0;
					}
				}
				else {
					$totalAgree = 0;
				}
					
				// for neither agree nor disagree answer plus cleanliness //
				if(@in_array($i, $this->nandQuestIdCleanArray)) {
					if(@in_array($key, array_keys($this->nandAnsCountCleanArray[$i]))) {
						$totalNand = $this->nandAnsCountCleanArray[$i][$key]*3;
					} else {
						$totalNand = 0;
					}
				}
				// for neither agree nor disagree answer plus service parameter //
				elseif(@in_array($i, $this->nandQuestIdServiceArray)) {
					if(@in_array($key, array_keys($this->nandAnsCountServiceArray[$i]))) {
						$totalNand = $this->nandAnsCountServiceArray[$i][$key]*3;
					} else {
						$totalNand = 0;
					}
				}
				// for neither agree nor disagree answer plus satisfaction parameter //
				elseif(@in_array($i, $this->nandQuestIdSatisArray)) {
					if(@in_array($key, array_keys($this->nandAnsCountSatisArray[$i]))) {
						$totalNand = $this->nandAnsCountSatisArray[$i][$key]*3;
					} else {
						$totalNand = 0;
					}
				}
				// for neither agree nor disagree plus recommendation parameter //
				elseif(@in_array($i, $this->nandQuestIdRecomArray)) {
					if(@in_array($key, array_keys($this->nandAnsCountRecomArray[$i]))) {
						$totalNand = $this->nandAnsCountRecomArray[$i][$key]*3;
					} else {
						$totalNand = 0;
					}
				}
				else {
					$totalNand = 0;
				}
					
				// for disagree answer plus cleanliness//
				if(@in_array($i, $this->disgreeQuestIdCleanArray)) {
					if(@in_array($key, array_keys($this->disgreeAnsCountCleanArray[$i]))) {
						$totalDisagree = $this->disgreeAnsCountCleanArray[$i][$key]*2;
						//echo $disgreeAnsCountCleanArray[$i][$key];
					} else {
						//echo "0";
						$totalDisagree = 0;
					}
				}
				// for strong agree answer plus service parameter //
				elseif(@in_array($i, $this->disgreeQuestIdServiceArray)) {
					if(@in_array($key, array_keys($this->disgreeAnsCountServiceArray[$i]))) {
						$totalDisagree = $this->disgreeAnsCountServiceArray[$i][$key]*2;
					} else {
						$totalDisagree = 0;
					}
				}
				// for strong agree answer plus satisfaction parameter //
				elseif(@in_array($i, $this->disgreeQuestIdSatisArray)) {
					if(@in_array($key, array_keys($this->disgreeAnsCountSatisArray[$i]))) {
						$totalDisagree = $this->disgreeAnsCountSatisArray[$i][$key]*2;
					} else {
						$totalDisagree = 0;
					}
				}
				// for strong agree answer plus recommendation parameter //
				elseif(@in_array($i, $this->disgreeQuestIdRecomArray)) {
					if(@in_array($key, array_keys($this->disgreeAnsCountRecomArray[$i]))) {
						$totalDisagree = $this->disgreeAnsCountRecomArray[$i][$key]*2;
					} else {
						$totalDisagree = 0;
					}
				}
				else {
					$totalDisagree = 0;
				}
					
				// for strong disagree answer plus cleanliness//
				if(@in_array($i, $this->stdQuestIdCleanArray)) {
					if(@in_array($key, array_keys($this->stdAnsCountCleanArray[$i]))) {
						$totalStDisagree = $this->stdAnsCountCleanArray[$i][$key]*1;
					} else {
						$totalStDisagree = 0;
					}
				}
				// for strong disagree answer plus service parameter //
				elseif(@in_array($i, $this->stdQuestIdServiceArray)) {
					if(@in_array($key, array_keys($this->stdAnsCountServiceArray[$i]))) {
						$totalStDisagree = $this->stdAnsCountServiceArray[$i][$key]*1;
					} else {
						$totalStDisagree = 0;
					}
				}
				// for strong disagree answer plus satisfaction parameter //
				elseif(@in_array($i, $this->stdQuestIdSatisArray)) {
					if(@in_array($key, array_keys($this->stdAnsCountSatisArray[$i]))) {
						$totalStDisagree = $stdAnsCountSatisArray[$i][$key]*1;
					} else {
						$totalStDisagree = 0;
					}
				}
				// for strong disagree answer plus recommendation parameter //
				elseif(@in_array($i, $this->stdQuestIdRecomArray)) {
					if(@in_array($key, array_keys($this->stdAnsCountRecomArray[$i]))) {
						$totalStDisagree = $this->stdAnsCountRecomArray[$i][$key]*1;
					} else {
						$totalStDisagree = 0;
					}
				}
				else {
					$totalStDisagree = 0;
				}

				// cent avg calculation //
				$totalScore = ($totalStrongAgree + $totalAgree + $totalNand + $totalDisagree + $totalStDisagree);
				$highestCent = ($totalScore/(70*5))*100;
				if(in_array($i, $cleanlinessQid)) {
					$cleanlinessRate[$i]['cleanliness'][$key] = $highestCent;
				}
				if(in_array($i, $serviceQid)) {
					$serviceRate[$i]['service'][$key] = $highestCent;
				}
				if(in_array($i, $satisfactionQid)) {
					$satisfactionRate[$i]['satisfaction'][$key] = $highestCent;
				}
				if(in_array($i, $recommendationQid)) {
					$recommendationRate[$i]['recommendation'][$key] = $highestCent;
				}
					
				$totalScore=0;
				$totalStrongAgree = 0;
				$totalAgree = 0;
				$totalNand = 0;
				$totalDisagree = 0;
				$totalStDisagree = 0;
				$highestCent = 0;
			} // close for for axis array

		} // close for questionid array

		// for cleanliness parameter //
		$cleanlinessCountIndex=0;
		foreach($yaxisArray as $key => $yaxisArrayVal) {
			$totalCleanlinessRate =   (($cleanlinessRate[1]['cleanliness'][$key] + $cleanlinessRate[2]['cleanliness'][$key])/2);

			if($totalCleanlinessRate > 0) {
				$arrData[$cleanlinessCountIndex][2] = $totalCleanlinessRate;
			} else {
				$arrData[$cleanlinessCountIndex][2] = 0;
			}
			$cleanlinessCountIndex++;
		}

		// for service parameter //
		$serviceCountIndex=0;
		foreach($yaxisArray as $key => $yaxisArrayVal) {
			$totalServiceRate =   (($serviceRate[3]['service'][$key] + $serviceRate[4]['service'][$key] + $serviceRate[5]['service'][$key] + $serviceRate[6]['service'][$key] + $serviceRate[7]['service'][$key] + $serviceRate[8]['service'][$key] + $serviceRate[9]['service'][$key] + $serviceRate[10]['service'][$key] + $serviceRate[11]['service'][$key] + $serviceRate[12]['service'][$key])/10);
			if($totalServiceRate > 0) {
				$arrData[$serviceCountIndex][3] = $totalServiceRate;
			} else {
				$arrData[$serviceCountIndex][3] = 0;
			}
			$serviceCountIndex++;
		}
		// for satisfaction parameter //
		$satisfactionCountIndex=0;
		foreach($yaxisArray as $key => $yaxisArrayVal) {
			$totalSatisfactionRate =   (($satisfactionRate[13]['satisfaction'][$key] + $satisfactionRate[14]['satisfaction'][$key] + $satisfactionRate[15]['satisfaction'][$key] + $satisfactionRate[16]['satisfaction'][$key] + $satisfactionRate[17]['satisfaction'][$key])/5);
			if($totalSatisfactionRate > 0) {
				$arrData[$satisfactionCountIndex][4] = $totalSatisfactionRate;
			} else {
				$arrData[$satisfactionCountIndex][4] = 0;
			}
			$satisfactionCountIndex++;
		}
		// for recommendation parameter //
		$recommendationCountIndex=0;
		foreach($yaxisArray as $key => $yaxisArrayVal) {
			$totalRecommendationRate =   (($recommendationRate[18]['recommendation'][$key] + $recommendationRate[19]['recommendation'][$key])/2);
			if($totalRecommendationRate > 0) {
				$arrData[$recommendationCountIndex][5] = $totalRecommendationRate;
			} else {
				$arrData[$recommendationCountIndex][5] = 0;
			}
			$recommendationCountIndex++;
		}

		//Initialize <chart> element
		$strOpdPatientXML = '<chart caption="OPD Patient Survey" xAxisName="Months" yAxisName="Rate"  showValues="0" decimalPrecision="1"  numberSuffix="%" bgColor="#394245" baseFontColor="ffffff"  divLineColor="4e6168" hoverCapBgColor="1B1B1B" legendBgColor="1B1B1B" canvasBgColor="1B1B1B"  toolTipBgColor="1B1B1B" plotGradientColor="" canvasBaseColor="#1B1B1B" use3DLighting="0">';
		$strOpdPatientCategories = '<categories fontColor="ffffff">';
		$strDataCleanliness = '<dataset seriesName="Cleanliness" color="AFD8F8">';
		$strDataService = '<dataset seriesName="Service" color="F6BD0F">';
		$strDataSatisfaction = '<dataset seriesName="Satisfaction" color="CCCC00">';
		$strDataRecommendation = '<dataset seriesName="Recommendation" color="FF9933">';
		foreach ($arrData as $arSubData) {
			$strOpdPatientCategories .= '<category name="' . $arSubData[1] . '" />';
			$strDataCleanliness .= '<set value="' . $arSubData[2] . '" />';
			$strDataService .= '<set value="' . $arSubData[3] . '" />';
			$strDataSatisfaction .= '<set value="' . $arSubData[4] . '" />';
			$strDataRecommendation .= '<set value="' . $arSubData[5] . '" />';
		}

		$strOpdPatientCategories .= '</categories>';
		$strDataCleanliness .= '</dataset>';
		$strDataService .= '</dataset>';
		$strDataSatisfaction .= '</dataset>';
		$strDataRecommendation .= '</dataset>';
		$strOpdPatientSurveyXML .= $strOpdPatientXML. $strOpdPatientCategories . $strDataCleanliness . $strDataService . $strDataSatisfaction . $strDataRecommendation ."</chart>";

		$opdPatientSurveyChart = '<script>';
		$opdPatientSurveyChart .= 'var datastring = \''.$strOpdPatientSurveyXML.'\';';
		$opdPatientSurveyChart .= '</script>';
		$opdPatientSurveyChart .= '<div id="opdPatientSurveyChart" align="center">FusionCharts</div>';
		$opdPatientSurveyChart .= '<script type="text/javascript">';
		$opdPatientSurveyChart .= 'FusionCharts.setCurrentRenderer("JavaScript");';
		$opdPatientSurveyChart .= 'var chart  = new FusionCharts("/fusionx_charts/MSColumn3D.swf", "chartdiv3", "400", "300", "0", "1");';
		$opdPatientSurveyChart .= 'chart.setXMLData(datastring);';
		$opdPatientSurveyChart .= 'chart.render("opdPatientSurveyChart");';
		$opdPatientSurveyChart .= '</script>';

		echo  $opdPatientSurveyChart;
	}

	/**
	 * customized user dashboard chart
	 * used to get number of IPD and OPD patient
	 * called by ajax request
	 *
	 */
	public function totalNumberOfIpdOpd() {
		$yaxisArray = $this->setYaxisArray();
		$arrData = $this->setXaxisChartValue();
		$patientOpdCountIndex=0;
		//debug($filterOpdDateArray);
		//debug($filterIpdDateArray);
		foreach($yaxisArray as $key => $yaxisArrayVal) {
			if(@in_array($key, $this->filterOpdDateArray)) {
				$arrData[$patientOpdCountIndex][2] = $this->filterOpdCountArray[$key];
			} else {
				$arrData[$patientOpdCountIndex][2] = 0;
			}
			$patientOpdCountIndex++;
		}
		$patientIpdCountIndex=0;

		foreach($yaxisArray as $key => $yaxisArrayVal) {
			//debug($key);
			if(@in_array($key,$this->filterIpdDateArray)) {
				$arrData[$patientIpdCountIndex][3] = $this->filterIpdCountArray[$key];
				//debug($this->filterIpdCountArray[$yaxisArrayVal]) ;
			} else {
				$arrData[$patientIpdCountIndex][3] = 0;
			}
			$patientIpdCountIndex++;
		}

		//Initialize <chart> element
		$strPatientOpdXML = '<chart caption="Total Number of OPD/IPD" xAxisName="Months" yAxisName="Patient OPD/IPD Count"  showValues="0" decimalPrecision="0"  bgColor="#394245" baseFontColor="ffffff"  divLineColor="4e6168" hoverCapBgColor="1B1B1B" legendBgColor="1B1B1B" canvasBgColor="1B1B1B"  toolTipBgColor="1B1B1B" plotGradientColor="" canvasBaseColor="#1B1B1B" use3DLighting="0">';
		$strPatientOpdCategories = '<categories fontColor="ffffff">';
		$strDataPatientOpdCount = '<dataset seriesName="Patient OPD Count" color="AFD8F8">';
		$strDataPatientIpdCount = '<dataset seriesName="Patient IPD Count" color="F6BD0F">';
		foreach ($arrData as $arSubData) {
			$strPatientOpdCategories .= '<category name="' . $arSubData[1] . '" />';
			$strDataPatientOpdCount .= '<set value="' . $arSubData[2] . '" />';
			$strDataPatientIpdCount .= '<set value="' . $arSubData[3] . '" />';
		}
		$strPatientOpdCategories .= '</categories>';
		$strDataPatientOpdCount .= '</dataset>';
		$strDataPatientIpdCount .= '</dataset>';
		$strPatientOpdXML .= $strPatientOpdCategories . $strDataPatientOpdCount . $strDataPatientIpdCount . '</chart>';

		$totalNoOfOpdIpdChart = '<script>';
		$totalNoOfOpdIpdChart .= 'var datastring = \''.$strPatientOpdXML.'\';';
		$totalNoOfOpdIpdChart .= '</script>';
		$totalNoOfOpdIpdChart .= '<div id="totalNoOfOpdIpdChart" align="center">FusionCharts</div>';
		$totalNoOfOpdIpdChart .= '<script type="text/javascript">';
		$totalNoOfOpdIpdChart .= 'FusionCharts.setCurrentRenderer("JavaScript");';
		$totalNoOfOpdIpdChart .= 'var chart  = new FusionCharts("/fusionx_charts/MSColumn3D.swf", "chartdiv4", "400", "300", "0", "1");';
		$totalNoOfOpdIpdChart .= 'chart.setXMLData(datastring);';
		$totalNoOfOpdIpdChart .= 'chart.render("totalNoOfOpdIpdChart");';
		$totalNoOfOpdIpdChart .= '</script>';

		echo $totalNoOfOpdIpdChart;
	}

	public function changeConfig($mode = '0'){

		require(APP.DS.'Config'.DS.'core.php');
		$contents = file_get_contents('..'.DS.'Config'.DS.'core.php');
		if($mode == '0'){
			$contents = str_replace("Configure::write('debug',2);","Configure::write('debug',0);",$contents);
			$contents = str_replace("Configure::write('debug',1);","Configure::write('debug',0);",$contents);
			file_put_contents('..'.DS.'Config'.DS.'core.php',$contents);

		}else{
			$contents = str_replace("Configure::write('debug',0);","Configure::write('debug',2);",$contents);
			file_put_contents('..'.DS.'Config'.DS.'core.php',$contents);
		}
		$this->redirect("/");
	}

	/*
	 * User Autocomplete returns first and last name
	* Condition on both first an d last name
	*/

	function user_autocomplete(){
		$location_id = $this->Session->read('locationid');
		$this->layout = "ajax";
		$patientArray = $this->User->find('all', array('fields'=> array('User.id,CONCAT(User.first_name," ",User.last_name) as name'),
				'conditions'=>array('User.is_deleted'=>0,'User.location_id'=>$location_id,
						'first_name like "'.$this->params->query['term'].'%" || last_name like "'.$this->params->query['term'].'%"')));
		$returnArray = array();
		foreach ($patientArray as $key=>$value) {
			$returnArray[] = array( 'id'=>$value['User']['id'],
					'value'=>$value[0]['name']) ;
		}
		echo json_encode($returnArray);
		exit;//dont remove this
	}

	function changeHospitalMode($hospitalMode){
		$this->uses = array('User');
		if(!empty($hospitalMode)){
			$modes = Configure::read('hospital_mode');
			if (in_array($hospitalMode, $modes)) {
				$this->Session->write('hospital_default_mode',ucfirst($hospitalMode));
			}
		}
		$userData = $this->User->read(array('location_id','second_location_id'),$this->Session->read('userid'));
		//print_r($userData['User']['second_location_id']);exit;
		if($hospitalMode == 'Hospital'){
			if(!empty($userData['User']['second_location_id']))
				$this->Session->write('locationid',$userData['User']['second_location_id']);//location_number
		}else if($hospitalMode == 'Clinic'){
			if(!empty($userData['User']['location_id']))
				$this->Session->write('locationid',$userData['User']['location_id']);
		}

		$this->redirect("/users/common");
	}

	/////////***************** OPD DashBoard **************///////////
	//OPD dashboard



	function opd_dashboard(){
		//Doctors
		$this->layout = 'advance' ;
		$doctors = $this->User->getDoctorsByLocation($this->Session->read('locationid'));
		$this->set(array('data'=>$data,'doctors'=>$doctors,'nurses'=>$nurses));
		$this->render('opd_dashboard') ;
	}


	//Ajax rendering for dashboard patient list
	function opd_dashboard_patient_list(){
		
		$this->uses = array('Patient','LaboratoryTestOrder','NoteDiagnosis','NewCropPrescription','EKG','RadiologyTestOrder','BmiResult','Person',
				'LaboratoryResult','RadiologyResult','Person','ReviewSubCategoriesOption','ReviewPatientDetail','LaboratoryHl7Result','Appointment');
		$this->Patient->unBindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn')));
			
		$rolename = $this->Session->read('role');
		//bof vikas
		$this->Patient->bindModel(array(
				'belongsTo'=>array('Person'=>array('type'=>'INNER','foreignKey'=>false,'conditions'=>array('Patient.patient_id = Person.patient_uid')),
						'Appointment'=>array('type'=>'INNER','foreignKey'=>false,'conditions'=>array('Appointment.patient_id = Patient.id'))),
		));
		$this->Patient->bindModel(array(
				'belongsTo'=>array('Appointment'=>array('type'=>'INNER','foreignKey'=>false,'conditions'=>array('Appointment.patient_id = Patient.id'))),
		));


		//eof vikas
		if(!empty($this->request->data['User']['All Doctors']) || !empty($this->params->query['doctor_id']) || (strtolower($rolename) == strtolower(Configure::read('doctorLabel')))){
			if(strtolower($rolename) == strtolower(Configure::read('doctorLabel'))){
				$userId = $this->Session->read('userid');
			}else if(!empty($this->params->query['doctor_id'])){
				$userId = $this->params->query['doctor_id'];
				$this->set('paginateArg',$this->params->query['doctor_id']);
			}else{
				$userId = $this->request->data['User']['All Doctors'];
				$this->set('paginateArg',$this->request->data['User']['All Doctors']);
			}
			$conditions = array('Patient.location_id'=>$this->Session->read('locationid'),'Patient.doctor_id'=>$userId,'Patient.is_deleted'=>0,'Patient.is_discharge'=>0) ;
		} else if(strtolower($rolename) == strtolower(Configure::read('nurseLabel'))){
			$conditions = array('Patient.nurse_id'=>$this->Session->read('userid'),'Patient.location_id'=>$this->Session->read('locationid'),'Patient.is_deleted'=>0,'Patient.is_discharge'=>0) ;
		} else{
			$conditions = array('Patient.location_id'=>$this->Session->read('locationid'),'Patient.is_deleted'=>0,'Patient.is_discharge'=>0) ;
		}
		if(isset($this->request->data['User']['Patient Name']) && !empty($this->request->data['User']['Patient Name'])){
			$conditions['Patient.lookup_name LIKE'] =  "%".$this->request->data['User']['Patient Name']."%";
		}
		//$conditions['Patient.admission_type'] = "OPD";
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'fields'=> array('Patient.id','Patient.lookup_name','Patient.sex','Patient.form_received_on','Patient.admission_id',
						'Patient.dashboard_level','Patient.dashboard_status','Patient.nurse_id','Patient.doctor_id','Person.sex','Person.dob',
						'Appointment.purpose','Patient.is_dr_chk'),
				'conditions'=>$conditions ,'order' => array('Patient.form_received_on' => 'DESC'));
		$data = $this->paginate('Patient') ;
			
		if(!empty($data)){
			foreach($data as $patientKey => $patientValue){
				$ids[] = $patientValue['Patient']['id'] ;
				$patientValue['Patient']['age'] = $this->Person->getCurrentAge($patientValue['Person']['dob']);
				$customArray[$patientValue['Patient']['id']]['Patient'] = $patientValue ;
			}
			$idsStr = implode(",",$ids) ;

			$labOrderData = $this->LaboratoryTestOrder->find('all',array('fields'=>array('Count(*) as lab','patient_id'),
					'conditions'=>array("LaboratoryTestOrder.patient_id IN ($idsStr)"),
					'group'=>array('LaboratoryTestOrder.patient_id')));

			$radOrderData = $this->RadiologyTestOrder->find('all',array('fields'=>array('Count(*) as rad','patient_id'),
					'conditions'=>array("RadiologyTestOrder.patient_id IN ($idsStr)"),
					'group'=>array('RadiologyTestOrder.patient_id')));

			$noteDiagnosisData = $this->NoteDiagnosis->find('all',array('fields'=>array('NoteDiagnosis.diagnoses_name','NoteDiagnosis.patient_id'),
					'conditions'=>array("NoteDiagnosis.patient_id IN ($idsStr)"),'order'=>array('NoteDiagnosis.id DESC') ));

			$medData = $this->NewCropPrescription->find('all',array('fields'=>array('Count(NewCropPrescription.drug_name) as med','patient_uniqueid'),
					'conditions'=>array('NewCropPrescription.archive'=>"N", "NewCropPrescription.patient_uniqueid IN ($idsStr)"),
					'group'=>array('NewCropPrescription.patient_id')));

			$ekgData = $this->EKG->find('all',array('fields'=>array('Count(*) as ekg','patient_id'),'conditions'=>array("EKG.patient_id IN ($idsStr)"),
					'group'=>array('EKG.patient_id')));

			$this->LaboratoryResult->bindModel(array(
					'belongsTo'=>array('LaboratoryHl7Result'=>array('foreignKey'=>false,'conditions'=>array('LaboratoryResult.id = LaboratoryHl7Result.laboratory_result_id')))
			));

			$labResultData = $this->LaboratoryResult->find('all',array('fields'=>array('Count(*) as labResult','patient_id',
					'LaboratoryHl7Result.abnormal_flag'), 'conditions'=>array("LaboratoryResult.patient_id IN ($idsStr)"),
					'group'=>array('LaboratoryHl7Result.laboratory_result_id')));

			$radResultData = $this->RadiologyResult->find('all',array('fields'=>array('Count(*) as radResult','patient_id'),
					'conditions'=>array("RadiologyResult.patient_id IN ($idsStr)"),
					'group'=>array('RadiologyResult.patient_id')));

			$this->ReviewPatientDetail->bindModel(array(
					'belongsTo'=>array(
							'ReviewSubCategoriesOption'=>array('foreignKey'=>false,
									'conditions'=>array('ReviewPatientDetail.review_sub_categories_options_id = ReviewSubCategoriesOption.id'),
							))),false);
			/** Vitals From IV Initial Assessment */
			$vitalsDataFromIV = $this->ReviewPatientDetail->find('all',array('fields'=>array('DISTINCT (ReviewSubCategoriesOption.name) AS name',
					'ReviewPatientDetail.patient_id','ReviewPatientDetail.values','ReviewSubCategoriesOption.unit'),
					'conditions'=>array("ReviewPatientDetail.patient_id IN ($idsStr)",//'ReviewPatientDetail.date' => date('Y-m-d'),
		 				'ReviewSubCategoriesOption.name' => Configure::read('vitals_for_tracking_board'),'ReviewPatientDetail.edited_on' => NULL),
					'order'=>array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC' )
			));
			$this->BmiResult->bindModel(array(
					'belongsTo' => array(
							'BmiBpResult' =>array('foreignKey' => false,'conditions'=>array('BmiResult.id =BmiBpResult.bmi_result_id' )),
					)));
			$vitalsDataFromInitialAssessment = $this->BmiResult->find('all',array('fields'=>array('BmiResult.id','BmiResult.temperature',
					'BmiResult.myoption','BmiResult.patient_id','BmiResult.equal_value','BmiResult.respiration',
					'BmiBpResult.id','BmiBpResult.pulse_text','BmiBpResult.systolic','BmiBpResult.diastolic'),
					'conditions'=>array("BmiResult.patient_id IN ($idsStr)"),'group'=>'BmiResult.patient_id'));

			foreach($labOrderData as $labKey => $labValue){
				$customArray[$labValue['LaboratoryTestOrder']['patient_id']]['LaboratoryTestOrder'] = $labValue[0] ;
			}
			foreach($radOrderData as $labKey => $labValue){
				$customArray[$labValue['RadiologyTestOrder']['patient_id']]['RadiologyTestOrder'] = $labValue[0] ;
			}
			foreach($noteDiagnosisData as $labKey => $labValue){
				$customArray[$labValue['NoteDiagnosis']['patient_id']]['NoteDiagnosis']  =  $labValue['NoteDiagnosis']  ;
			}
			foreach($medData as $labKey => $labValue){
				$customArray[$labValue['NewCropPrescription']['patient_uniqueid']]['NewCropPrescription'] = $labValue[0] ;
			}
			foreach($ekgData as $labKey => $labValue){
				$customArray[$labValue['EKG']['patient_id']]['EKG'] = $labValue[0] ;
			}

			//reset lab array
			foreach($labResultData as $labKey => $labValue){
				$prevCnt =  ($customArray[$labValue['LaboratoryResult']['patient_id']]['LaboratoryResult']['labResult'])?$customArray[$labValue['LaboratoryResult']['patient_id']]['LaboratoryResult']['labResult']:0 ;
				if($labValue['LaboratoryHl7Result']['abnormal_flag']=='A'){ //abnormal test  result
					$customArray[$labValue['LaboratoryResult']['patient_id']]['LaboratoryResult']['abnormal'] =  'A' ;
				}if($labValue['LaboratoryHl7Result']['abnormal_flag']=='H'){ //abnormal test  result
					$customArray[$labValue['LaboratoryResult']['patient_id']]['LaboratoryResult']['abnormal'] =  'H' ;
				}if($labValue['LaboratoryHl7Result']['abnormal_flag']=='L'){ //abnormal test  result
					$customArray[$labValue['LaboratoryResult']['patient_id']]['LaboratoryResult']['abnormal'] =  'L' ;
				}
				$customArray[$labValue['LaboratoryResult']['patient_id']]['LaboratoryResult']['labResult'] = (int)$prevCnt+(int)$labValue[0]['labResult'] ;
			}

			foreach($radResultData as $labKey => $labValue){
				$customArray[$labValue['RadiologyResult']['patient_id']]['RadiologyResult'] = $labValue[0] ;
			}

			foreach($vitalsDataFromIV as $vitals){
				$customArray[$vitals['ReviewPatientDetail']['patient_id']]['vitalData'][$vitals['ReviewSubCategoriesOption']['name']] =
				$vitals['ReviewPatientDetail']['values'].' '.$vitals['ReviewSubCategoriesOption']['unit'] ;
			}
			foreach($vitalsDataFromInitialAssessment as $vitals){
				if(!$customArray[$vitals['BmiResult']['patient_id']]['vitalData']){// if vital not taken from IV
					if($vitals['BmiResult']['myoption'] == 'C'){
						$temperature = $vitals['BmiResult']['temperature'];
					}else{
						$centigrate =  explode(' ',$vitals['BmiResult']['equal_value']);
						$temperature = $centigrate['0'];
					}
					if($temperature)
						$customArray[$vitals['BmiResult']['patient_id']]['vitalData']['Temperature Oral '] = $temperature.' DegC' ;
					if($vitals['BmiResult']['respiration'])
						$customArray[$vitals['BmiResult']['patient_id']]['vitalData']['Respiratory Rate '] = $vitals['BmiResult']['respiration'].' br/min' ;
					if($vitals['BmiBpResult']['pulse_text'])
						$customArray[$vitals['BmiResult']['patient_id']]['vitalData']['Peripheral Pulse '] = $vitals['BmiBpResult']['pulse_text'].' bpm' ;
					if($vitals['BmiBpResult']['systolic'] && $vitals['BmiBpResult']['systolic'])
						$customArray[$vitals['BmiResult']['patient_id']]['vitalData']['SBP/DBP Cuff '] = $vitals['BmiBpResult']['systolic'].'/'.$vitals['BmiBpResult']['diastolic'].' mmHg' ;
				}
			}

			$doctors = $this->User->getDoctorsByLocation($this->Session->read('locationid'));
			$nurses  = $this->User->getUsersByRoleName(Configure::read('nurseLabel')) ;
		}
		$this->set(array('data'=>$customArray,'doctors'=>$doctors,'nurses'=>$nurses));
	}
	public function dr_chk($id){
		$this->uses=array('Patient');
		if($id){
			$this->Patient->updateAll(array('Patient.is_dr_chk' => 1), array('Patient.id' => $id));
			//$this->redirect($this->referer());
			exit;
		}
	}

	//failed login attempts by IP or username
	public function checkLoginAttempts(){
			
		//BOF login attempt
		$this->loadModel('LoginAttempt') ;
		$ip = $this->request->clientIp(false);
		$ipData = $this->LoginAttempt->Find('first',array('conditions'=>array('ip_address'=>$ip)));//fetch ip
		$currentDateTime =  (array)new DateTime("now", new DateTimeZone(Configure::read('login_attempt_timezone')));
		$currentDateTime = $currentDateTime['date'] ;
		$isUserExist = $this->User->find('count',array('conditions'=>array('username'=>$this->request->data['User']['username'])));//fetch user is already exist or not
		$userFailed = false ;
		$ipFailed = false ;
		if($isUserExist > 0){ //log username attempts
			$usernameData = $this->LoginAttempt->Find('first',array('conditions'=>array('username'=>$this->request->data['User']['username'])));

			$userDataLog['id']=$usernameData['LoginAttempt']['id'] ;
			$userDataLog['username'] = $this->request->data['User']['username'] ;
			$userDataLog['user_ip_address'] = $ip ;
			$userDataLog['user_login_attempt'] = $usernameData['LoginAttempt']['user_login_attempt'] +1 ;
			$userDataLog['ip_login_attempt']  = $usernameData['LoginAttempt']['ip_login_attempt']+1 ; //adding failed attempt
			$userDataLog['ip_last_login'] = $currentDateTime ;

			//$userLoginTimeDiff = $this->dateFormat->dateDiff(date('Y-m-d H:i:s'),$usernameData['LoginAttempt']['user_last_login']);//fetch username
			$to_time = strtotime($currentDateTime);
			$from_time = strtotime($usernameData['LoginAttempt']['user_last_login']);
			$userLoginTimeDiff =  round(abs($to_time - $from_time) / 60) ;

			if($usernameData['LoginAttempt']['user_login_attempt'] > 4 && ($userLoginTimeDiff < 15)){
				$this->Session->setFlash(__('This Account has been blocked for 15 Minutes.'), 'default', array('class' => 'error'));
				if($usernameData['LoginAttempt']['id']==''){
					$userDataLog['user_last_login'] =$currentDateTime ;
				}
				$userFailed= true;
			}

			if(!$userFailed && $usernameData['LoginAttempt']['user_login_attempt'] >4){ //reset last login time if timespan crossse 15 min from last attempt
				$userDataLog['user_last_login'] =$currentDateTime ;
				$userDataLog['user_login_attempt'] = 0 ;
				$userDataLog['ip_login_attempt']  = 0 ; //reset all atttempts
			}else if($usernameData['LoginAttempt']['id']==''){ //for first attempt enter current time
				$userDataLog['user_last_login'] =$currentDateTime ;
			}

			$this->LoginAttempt->save($userDataLog); //save username failed attempt
			$this->LoginAttempt->id = '' ;
		}
			
		if(!empty($ipData)) {
			$this->LoginAttempt->id= $ipData['LoginAttempt']['id'];
		} //update for same IP
		else $this->LoginAttempt->id = ''; //set empty for new entry for IP

		$ipDataLog['ip_login_attempt']  = $ipData['LoginAttempt']['ip_login_attempt']+1 ; //adding failed attempt
		$ipDataLog['ip_last_login'] = $currentDateTime ;
		$ipDataLog['ip_address'] = $ip ;

			
		$ip_to_time = strtotime($currentDateTime);
		$ip_from_time = strtotime($ipData['LoginAttempt']['ip_last_login']);
		$ipLoginTimeDiff =  round((abs($ip_to_time - $ip_from_time) / 60)/60,2) ;
			
		if($ipDataLog['ip_login_attempt'] > 50 && ($ipLoginTimeDiff  < 1)){
			$this->Session->setFlash(__('This IP has been blocked for an hour .'), 'default', array('class' => 'error'));
			$ipFailed = true  ;
			if(!$ipData['LoginAttempt']['id']){
				$ipData['ip_last_login'] = $currentDateTime ;
			}
		}

		if(!$ipData['LoginAttempt']['id'] && !$ipFailed){
			$ipDataLog['user_last_login'] = $currentDateTime ;
		}

		$this->LoginAttempt->save($ipDataLog ); //logging IP attempt

		if($ipFailed || $userFailed){
			return "fail" ;
		}

		return 'success' ;
		//EOF login attempt
	}

	public function checkAtttempt(){
		$this->loadModel('LoginAttempt');
		$checkUserAttempt = $this->LoginAttempt->find('first',array('conditions'=>array('username'=>$this->request->data['User']['username']))); //user data
		$checkIpAttempt = $this->LoginAttempt->find('first',array('conditions'=>array('username'=>$this->request->clientIp()))); //ip data
		$currentDateTime =  (array)new DateTime("now", new DateTimeZone(Configure::read('login_attempt_timezone')));
		$currentDateTime = $currentDateTime['date'] ;
		//calculate ip last login time diff
		$ip_to_time = strtotime($currentDateTime);
		$ip_from_time = strtotime($checkIpAttempt['LoginAttempt']['ip_last_login']);
		$ipLoginTimeDiff =  round((abs($ip_to_time - $ip_from_time) / 60)/24) ; //calc hours
			
		//calculate user last login time diff
		$to_time = strtotime($currentDateTime);
		$from_time = strtotime($checkUserAttempt['LoginAttempt']['user_last_login']);
		//echo (($to_time - $from_time))/60 ."dfdff<br>" ;
		$userLoginTimeDiff =  floor(abs($to_time - $from_time)/60) ; //calc hours
			
		$failedArea = array();
		if($ipDataLog['ip_login_attempt'] > 50 && ($ipLoginTimeDiff  < 1)){
			$this->Session->setFlash(__('This IP has been blocked for an hour .'), 'default', array('class' => 'error'));
			$failedArea =  array('iplogin'=>'failed') ;
		}else{
			$failedArea =  array('iplogin'=>'success') ;
		}
		$failedArea1 =array();
		if($checkUserAttempt['LoginAttempt']['user_login_attempt'] > 4 && ($userLoginTimeDiff < 15)){
			$this->Session->setFlash(__('This Account has been blocked for 30 Minutes .'), 'default', array('class' => 'error'));
			$failedArea1=  array('userlogin'=>'failed') ;
		}else{
			$failedArea1=  array('userlogin'=>'success') ;
		}
		return array_merge($failedArea,$failedArea1) ;
			
	}


	//reset login attempt after successful login and change password
	function updateLoginAttempt(){
		$this->loadModel('LoginAttempt') ;
		$currentDateTime =  (array)new DateTime("now", new DateTimeZone(Configure::read('login_attempt_timezone')));
		$currentDateTime =   $currentDateTime['date'] ;
			
		//reset all failed login for logged in user .
		$this->LoginAttempt->updateAll(array('user_login_attempt'=>0,'ip_login_attempt'=>0,'user_last_login'=>"'".$currentDateTime."'",'ip_last_login'=>"'".$currentDateTime."'"),array('username'=>$this->request->data['User']['username'])) ;
		//reset all failed login for logged in user IP Address.
		$this->LoginAttempt->updateAll(array('user_login_attempt'=>0,'ip_login_attempt'=>0,'user_last_login'=>"'".$currentDateTime."'",'ip_last_login'=>"'".$currentDateTime."'"),array('ip_address'=>$this->request->clientIp())) ;
			
	}
	public function addGuarantor($id=null) {
		$this->uses = array('PatientGaurantor','City','State','Country');
		if(!empty($this->request->data)){
			//$this->request->data["PatientGaurantor"]['dob'] = $this->DateFormat->formatDate2STD($this->request->data["PatientGaurantor"]['dob'],Configure::read('date_format'));

			if(empty($this->request->data['PatientGaurantor']['id'])){
				$this->request->data['PatientGaurantor']['created_by']=$this->Session->read('userid');
				$this->request->data['PatientGaurantor']['create_time']=date("Y-m-d H:i:s");
					
			}else{
				$this->request->data['PatientGaurantor']['modified_by']=$this->Session->read('userid');
				$this->request->data['PatientGaurantor']['modified_time']=date("Y-m-d H:i:s");
					
			}
			$this->request->data["PatientGaurantor"]["location_id"] = $this->Session->read('locationid');

			$this->PatientGaurantor->save($this->request->data);
			if(empty($this->request->data['PatientGaurantor']['id'])){
				$this->Session->setFlash(__('Guarantor saved successfully', true));
			}else{
				$this->Session->setFlash(__('Guarantor updated successfully', true));
			}
			$this->redirect(array("controller" => "Users", "action" => "indexGuarantor", "admin" => false));
		}
		$this->set('tempState',$this->State->find('list', array('fields'=> array('id', 'name'),'conditions'=>array('State.country_id'=>'1'),'order' => array('State.name'))));
		$this->set('cities', $this->City->find('list', array('fields'=> array('id', 'name'),'order' => array('City.name'))));
		$this->set('states', $this->State->find('list', array('fields'=> array('id', 'name'),'order' => array('State.name'))));
		$this->set('countries', $this->Country->find('list', array('fields'=> array('id', 'name'),'order' => array('Country.name DESC'))));
		$getPatientGaurantor = $this->PatientGaurantor->find('first',array('conditions'=>array('PatientGaurantor.id'=>$id)));
		//debug($getPatientGaurantor);
		//if(!empty($getPatientGaurantor['PatientGaurantor']['dob'])){
		//debug($getPatientGaurantor['PatientGaurantor']['dob']);
		//$getPatientGaurantor['PatientGaurantor']['dob']=$this->DateFormat->formatDate2Local($getPatientGaurantor['PatientGaurantor']['dob'],Configure::read('date_format'),false);
		//debug($getPatientGaurantor['PatientGaurantor']['dob']);
		//}
		//debug($getPatientGaurantor);exit;
		$this->data=$getPatientGaurantor;
	}
	public function indexGuarantor() {
		$this->uses = array('PatientGaurantor');
		//$getPatientGaurantor = $this->PatientGaurantor->find('all',array('conditions'=>array('is_deleted'=>0))); //PatientGaurantor data
		//	$getPatientGaurantor = $this->paginate('PatientGaurantor');

		if(empty($searchtest)){
			if(isset($this->request->data['PatientGaurantor']['first_name'])){
				$this->request->query['first_name'] = $this->request->data['PatientGaurantor']['first_name'];
			}
			$port = "42011";
			if(isset($this->request->data['PatientGaurantor']['last_name'])){
				$this->request->query['last_name'] = $this->request->data['PatientGaurantor']['last_name'];
			}
			$port = "42011";
		}else{
			$getdata = $searchtest;
			$port = "42045";
		}
		$getdata=$this->request->data['PatientGaurantor']['first_name'];
		$getdata1=$this->request->data['PatientGaurantor']['last_name'];
		if(isset($getdata)|| $getdata=='' || isset($getdata1)|| $getdata1=='' ){
			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'order' => array(
							'PatientGaurantor.first_name' => 'asc',
					),'conditions'=>array('PatientGaurantor.first_name LIKE'=> "%"."".$getdata.""."%",'PatientGaurantor.last_name LIKE'=> "%"."".$getdata1.""."%",'PatientGaurantor.is_deleted'=>0)
			);
			$data = $this->paginate('PatientGaurantor');
			if($this->request['isAjax'] == 1){
				echo json_encode($data);exit;
			}
		}
		$this->set('data', $data);
	}
	public function deleteGuarantor($id = null) {
		$this->uses = array('PatientGaurantor');
		$this->request->data['PatientGaurantor']['is_deleted']=1;
		$this->PatientGaurantor->id= $id;
		if($this->PatientGaurantor->save($this->request->data['PatientGaurantor'])){
			$this->Session->setFlash(__('Guarantor deleted successfully'),true);
			$this->redirect(array("controller" => "Users", "action" => "indexGuarantor"));
		}
	}

	public function profitDepartment(){
			
		$this->uses = array('Department','Patient','FinalBilling');
		if(!empty($this->request->query)){
			if($this->request->query['from_date']!=''){
				$this->request->query['from_date'] = $this->DateFormat->formatDate2STDForReport($this->request->query['from_date'],Configure::read('date_format'))." 00:00:00";
				$this->request->query['to_date'] = $this->DateFormat->formatDate2STDForReport($this->request->query['to_date'],Configure::read('date_format'))." 23:59:59";
				//$conditions['Billing'] = array('date BETWEEN ? AND ?'=> array(trim($this->request->data['Patient']['from_date']),trim($this->request->data['Patient']['to_date'])));
			}

			$this->Patient->bindModel(array('belongsTo' => array(
					'FinalBilling' =>array('foreignKey'=>false, 'conditions' => array('FinalBilling.patient_id=Patient.id AND date BETWEEN "'.$this->request->query['from_date'].'" AND "'.$this->request->query['to_date'].'"')),
					'Department' =>array('type'=>'RIGHT','foreignKey'=>false, 'conditions' => array('Department.id=Patient.department_id')),

			)),false);


			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					//	'conditions' =>$conditions,
					'group'=>array('Department.name'),
					'fields'=>array('Department.name','Patient.id','FinalBilling.total_amount','sum(total_amount) AS ctotal')//,'group'=>array('Department.name')
			);

			$data = $this->paginate('Patient');
			$this->set('data', $data);
			$this->set('queryString',$this->request->query);
		}
	}
	public function profitPhysician(){

		$this->uses = array('DoctorProfile','Patient','FinalBilling');
		if(!empty($this->request->query)){
			if($this->request->query['from_date']!=''){
				$this->request->query['from_date'] = $this->DateFormat->formatDate2STDForReport($this->request->query['from_date'],Configure::read('date_format'))." 00:00:00";
				$this->request->query['to_date'] = $this->DateFormat->formatDate2STDForReport($this->request->query['to_date'],Configure::read('date_format'))." 23:59:59";
				//$conditions['Billing'] = array('date BETWEEN ? AND ?'=> array(trim($this->request->data['Patient']['from_date']),trim($this->request->data['Patient']['to_date'])));
			}

			$this->Patient->bindModel(array('belongsTo' => array(
					'FinalBilling' =>array('foreignKey'=>false, 'conditions' => array('FinalBilling.patient_id=Patient.id AND date BETWEEN "'.$this->request->query['from_date'].'" AND "'.$this->request->query['to_date'].'"'),'type'=>'Inner'),
					'DoctorProfile' =>array('type'=>'RIGHT','foreignKey'=>false, 'conditions' => array('DoctorProfile.user_id=Patient.doctor_id')),
					'User' =>array('foreignKey'=>false, 'conditions' => array('DoctorProfile.user_id=User.id')),

			)),false);


			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'group'=>array('DoctorProfile.doctor_name'),
					'fields'=>array('DoctorProfile.doctor_name','Patient.id','FinalBilling.total_amount as my_amount','FinalBilling.date','User.profit_sharing','sum(FinalBilling.total_amount*(User.profit_sharing/100)) AS ctotal')
			);

			$data = $this->paginate('Patient');
			$this->set('data', $data);	//pr($data);//exit;

			$this->set('queryString',$this->request->query);
		}

	}


	public function admin_appraisal()
	{
		$this->layout = "advance";
		$this->loadModel("Department");
		$this->loadModel("Appraisal");
		$this->set('departments',$this->Department->DepartmentList());
		if(!empty($this->request->data))
		{
			$this->request->data[appraisal][formA] = serialize($this->request->data[questions][A]);
			$this->request->data[appraisal][formB] = serialize($this->request->data[questions][B]);
			$this->request->data[appraisal][create_time] = date("Y-m-d H:i:s");
			$this->Appraisal->save($this->request->data[appraisal]);
		}
	}

	/*** BOF clearance by doctor--Atul**/
	public function clearance()
	{
		$this->uses = array('Patient');
		if($this->request['isAjax']){
				$role = $this->Session->read('role');
			$result = $this->Patient->find('first',array('fields'=>array('Patient.clearance'),
					'conditions'=>array('Patient.id'=>$this->request->data['patientId'])));
			$var=unserialize($result['Patient']['clearance']);
			if($role == Configure::read('doctorLabel')){
				$var[$this->request->data['patientId']]['doctor'] = $this->request->data['Patient']['clearance'][$this->request->data['patientId']]['doctor'] ;
				$var[$this->request->data['patientId']]['doctor_username'] = $this->Session->read('username');
				$var[$this->request->data['patientId']]['doctor_date'] = date('Y-m-d H:i:s');
			}elseif ($role== Configure::read('pharmacyManager')){
				$var[$this->request->data['patientId']]['pharmacy'] = $this->request->data['Patient']['clearance'][$this->request->data['patientId']]['pharmacy'] ;
				$var[$this->request->data['patientId']]['pharmacy_username'] = $this->Session->read('username');
				$var[$this->request->data['patientId']]['pharmacy_date'] = date('Y-m-d H:i:s');
			}elseif ($role== Configure::read('nurseLabel')){
				$var[$this->request->data['patientId']]['nurse'] = $this->request->data['Patient']['clearance'][$this->request->data['patientId']]['nurse'] ;
				$var[$this->request->data['patientId']]['nurse_username'] = $this->Session->read('username');
				$var[$this->request->data['patientId']]['nurse_date'] = date('Y-m-d H:i:s');
			}elseif ($role== Configure::read('radManager')){
				$var[$this->request->data['patientId']]['radiology'] = $this->request->data['Patient']['clearance'][$this->request->data['patientId']]['radiology'] ;
				$var[$this->request->data['patientId']]['rad_username'] = $this->Session->read('username');
				$var[$this->request->data['patientId']]['rad_date'] = date('Y-m-d H:i:s');
			}elseif ($role== Configure::read('labManager')){
				$var[$this->request->data['patientId']]['laboratory'] = $this->request->data['Patient']['clearance'][$this->request->data['patientId']]['laboratory'] ;
				$var[$this->request->data['patientId']]['lab_username'] = $this->Session->read('username');
				$var[$this->request->data['patientId']]['lab_date'] = date('Y-m-d H:i:s');
			}/* elseif ($role== Configure::read('frontOfficeLabel')){
				$var[$this->request->data['patientId']]['frontoffice'] = $this->request->data['Patient']['clearance'][$this->request->data['patientId']]['frontoffice'] ;
				$var[$this->request->data['patientId']]['front_username'] = $this->Session->read('username');
				$var[$this->request->data['patientId']]['front_date'] = date('Y-m-d H:i:s');
			} */
			$clearance = serialize($var);
			$this->Patient->UpdateAll(array('clearance'=>"'".$clearance."'"),array('id'=>$this->request->data['patientId']));
			$this->Session->setFlash(__('Clearance given sucessfully'), 'default', array('class' => 'message'));
			exit;
		}

		if(!empty($this->request->query['lookup_name'])){
			$search_key['Patient.lookup_name like '] = trim($this->request->query['lookup_name'])."%" ;
			
		}
	 $cond=array('OR'=>array(array('Patient.is_discharge'=>'0','Patient.is_deleted'=>'0','Patient.admission_type'=>'IPD',
						'Patient.location_id' => $this->Session->read('locationid'),'Patient.is_doc_clearance_chk'=>1)),$search_key);
		
		$this->paginate = array(
				'limit' => '10',
				'conditions'=>$cond,
				'order'=>('Patient.id DESC'),
				'fields'=>array('Patient.id', 'Patient.admission_type','Patient.lookup_name','Patient.location_id','Patient.clearance')
		);
		
		$data = $this->paginate('Patient');
		$this->set('data', $data);	//pr($data);//exit;
		/*$data = $this->Patient->find('all',array('fields'=>array('Patient.id', 'Patient.admission_type','Patient.lookup_name','Patient.location_id','Patient.clearance'),
				'conditions'=>array('OR'=>array(array('Patient.is_discharge'=>'0','Patient.is_deleted'=>'0','Patient.admission_type'=>'IPD',
						'Patient.location_id' => $this->Session->read('locationid'),'Patient.is_doc_clearance_chk'=>1)),$search_key),'order'=>('Patient.id DESC')));*/
		//debug($data);
		//$this->set('data',$data);

	}

	public function clear()
	{
		$this->uses = array('Patient','User','Note','Role');
		if($this->request['isAjax']){
			$this->request->data['Patient']['clearance'][$this->request->data['patientId']]['doctor_username'] = $this->Session->read('username');
			$this->request->data['Patient']['clearance'][$this->request->data['patientId']]['doctor_date'] = date('Y-m-d H:i:s');
			$clearance = serialize($this->request->data['Patient']['clearance']);
			$this->Patient->UpdateAll(array('clearance'=>"'".$clearance."'",'Patient.is_doc_clearance_chk'=>1),array('id'=>$this->request->data['patientId']));
			//$nurse_id=$this->request->data['nurseId'];

			/** Added for to send mail to nurse ,lab manager and rad manager and pharamcy manager-Atul**/
			$role=$this->Role->getStaffRoles();
			foreach ($role as $key=>$staffRole){
				$userId[] = $staffRole['Role']['id'];

			}
			$staff = $this->User->find('all', array('fields'=> array('User.id','User.first_name','User.last_name','User.username'),
					'conditions'=>array('User.role_id' =>$userId)));
			//debug($staff);
			foreach ($staff as $key=>$staffId)
			{
				/*$userfullname = $this->User->find('all', array('fields'=> array('User.first_name','User.last_name','User.username'),
				 'conditions'=>array('User.id' =>array($nurse_id,$staffId['User']['id']))));*/
				$userfullnameVal=$staffId["User"]["first_name"]." ".$staffId["User"]["last_name"];
					
				$mailData['Patient']=array("patient_id"=>$staffId["User"]["username"],"lookup_name"=>$userfullnameVal);
				$clrId = $this->request->data['patientId'];
				$patient_name = $this->request->data['patientname'];
				$msgs.="<a href=".Router::url('/')."Users/clearance/".$clrId.">Click here to view clearance</a><br/><br/>";
				$subject="Request for clearance $patient_name.";
				$this->Note->sendMail($mailData,$msgs,$subject);
				$msgs = '';
			}
			exit;

		}

		/* 	$data = $this->Patient->find('all',array('fields'=>array('Patient.id', 'Patient.admission_type','Patient.lookup_name','Patient.location_id','Patient.clearance'),
		 'conditions'=>array('OR'=>array(array('Patient.is_discharge'=>'0','Patient.is_deleted'=>'0','Patient.admission_type'=>'IPD',
		 		'Patient.location_id' => $this->Session->read('locationid'))),$search_key),'order'=>('Patient.id DESC')));
		$this->set('data',$data); */

	}
	/***EOF Clearance-Atul ***/
	public function marketing_team($id=null)
	{
		$this->uses=array('MarketingTeam');
	
		if($this->request->data){
		  // 	debug($this->request->data);exit;
			if(!empty($id)){
				$this->request->data['MarketingTeam']['id']=$id;
				$this->request->data['MarketingTeam']['modified']=date('Y-m-d H:i:s');
			}else{
				$this->request->data['MarketingTeam']['created']=date('Y-m-d H:i:s');
			}
			$this->request->data['MarketingTeam']['location_id']=$this->Session->read('locationid');
			$this->MarketingTeam->Save($this->request->data);
		}
		
		if(!empty($id)){
			$edit=$this->MarketingTeam->find('all',array('conditions'=>array('id'=>$id,'is_deleted'=>'0','location_id'=>$this->Session->read('locationid'))));
			$this->data=$edit;
		}
		$company=$this->MarketingTeam->find('all',array('conditions'=>array('is_deleted'=>'0','location_id'=>$this->Session->read('locationid'))));
		//debug($company);
		
		$this->set('company',$company);
		
	}
	
		public function deleteTeam($id){
			$this->uses=array('MarketingTeam');
			if(!empty($id)){
				$date=date('Y-m-d H:i:s');
				$updateArray=array('is_deleted'=>"'1'",'modified'=>"'$date'");
				$this->MarketingTeam->updateAll($updateArray,array('id'=>$id));
			}
			$this->redirect($this->referer());
		}
		
	
	/***EOF marketing team -swatin ***/
		
 /*  function admin_getLocationwiseRole($location=null){
			$this->layout  = 'ajax';
			$this->autoRender= false;
			$this->loadModel('Role');
			$accessLocList = $this->Role->find('list',array('fields'=> array('id','name'),'order' => array('Role.name ASC'),
					'conditions'=>array('NOT'=>array('name'=>array(configure::read('patientLabel'),configure::read('superAdminLabel'),configure::read('adminLabel'))),'Role.location_id'=>$location)));
			echo json_encode($accessLocList);
				
		}*/
		
		/* for biometric identification */
	Public function finger_print(){
	
		$someData = $this->User->find('first', array('fields'=>array('User.id','User.first_name','User.last_name'),'conditions' => array('User.id' => $this->request->params['pass'][0])));
		$this->set('someData', $someData);
		
		
	}
/**
	 * Staff Auth
	 * **/
	Public function staffAuthentication(){
		$this->uses = array('DutyRoster','Location','City');
		$conditions=array('DutyRoster.is_deleted'=>0);
		$conditions['DutyRoster.location_id']=$this->Session->read('locationid');
		$getLocName=$this->Location->getLocListIdWithCorporate($this->Session->read('locationid'));
		$this->set(array('getLocName'=>$getLocName));
	
		$from=date('Y-m-d')." 00:00:00";
		$to=date('Y-m-d')." 23:59:59";
		$conditions['DutyRoster.date >='] = $from;
		$conditions['DutyRoster.date <='] = $to;
	
		$this->DutyRoster->bindModel(array(
				'belongsTo' => array(
						'User'=>array("foreignKey"=>false, 'conditions'=>array('User.id = DutyRoster.user_id')),
						'Location'=>array("foreignKey"=>false, 'conditions'=>array('Location.id = DutyRoster.location_id')),
				)));
	
		$dutyRosterData  = $this->DutyRoster->find('all',array('fields'=>array('Location.name','DutyRoster.user_id','User.first_name','User.last_name','DutyRoster.date','DutyRoster.intime','DutyRoster.outime','DutyRoster.location_id','DutyRoster.missed_punch','DutyRoster.remark','DutyRoster.is_edited'),'conditions'=>$conditions,'order'=>array('DutyRoster.id')));
			
		//EOF-For Detailed Report
		$getAttendanceArr=array();
		foreach($dutyRosterData as $dutyRosterDatas){
			
			$getAttendanceArr[$dutyRosterDatas['DutyRoster']['location_id']][]=$dutyRosterDatas;
			$time[$dutyRosterDatas['DutyRoster']['location_id']][$dutyRosterDatas['DutyRoster']['user_id']] = $this->DutyRoster->getInOutTime($dutyRosterDatas['DutyRoster']['user_id'],$dutyRosterDatas['DutyRoster']['date'],$dutyRosterDatas['DutyRoster']['location_id']);
		}
		$this->set(array('getAttendanceArr'=>$getAttendanceArr,'from'=>$from,'to'=>$to,'time'=>$time));
		$someData = $this->User->find('first', array('fields'=>array('User.id','User.first_name','User.last_name'),'conditions' => array('User.id' => $this->request->params['pass'][0])));
		$this->set('someData', $someData);
	
	
	}
	
	
	/**
	 * 
	 */
	public function admin_employee_add($userId=null) {
		//debug($this->request->data); exit;
		$this->layout = 'advance';
		$this->uses = array('Initial','Role', 'Location', 'Designation','Department','TestGroup','AccountingGroup','Configuration','HrDetail','Users','Account',
				'EarningDeduction','Ward','SerializeDataConfiguration','DoctorProfile','HrDocument','PlacementHistory','CadreMaster','LevelGradeMaster','EmployeePayDetail');
		$this->set('title_for_layout', __('Admin - Add New User', true));
		
		//$oldShiftData= $this->Configuration->find('first',array('conditions'=>array('Configuration.name'=>array(Configure::read('shifts'),Configure::read('DoctorShifts')))));
		//$shifts = $this->Configuration->getConfiguration('shifts',$this->Session->read('locationid')); //debug($shifts);
		
		/* $shiftNames = $shifts['ShiftName'];   //debug($shiftNames);
		$shiftTimes = $shifts['ShiftsTime']; //debug($shiftTimes);
		
		foreach($shiftNames as $key=>$shiftList){
			$allShiftData[$shiftTimes[$key]['start'].'-'.$shiftTimes[$key]['end']] = $shiftList;
		}
		
		 $doctorShifts = $this->Configuration->getConfiguration('DoctorShifts',$this->Session->read('locationid'));
		 
		$doctorShiftNames = $doctorShifts['ShiftName'];
		$doctorShiftTimes = $doctorShifts['ShiftsTime'];
		
		foreach($doctorShiftNames as $key=>$dShiftList){
			$doctorShiftData[$doctorShiftTimes[$key]['start'].'-'.$doctorShiftTimes[$key]['end']] =$dShiftList;
		} */
		
                //overwrite allshiftdata by Swapnil 16.02.2016
                $this->loadModel('Shift');
                $allShiftData = $this->Shift->getAllShifts(); 
		$this->set(compact(array('allShiftData','doctorShiftData')));
		
		$this->set('departments',$this->Department->find('list',array('fields'=>array('id','name'),'order' => array('Department.name ASC'),'group'=>'Department.name')));
        $this->set('cadres',$this->CadreMaster->find('list',array('fields'=>array('id','name'),'conditions'=>array('is_deleted'=>0))));
        $grades = $this->LevelGradeMaster->find('all',array('fields'=>array('id','grade','level'),'conditions'=>array('is_deleted'=>0)));
        $greades = $level = array();
         foreach ($grades as $key=>$value){
         	$greades[] = $value['LevelGradeMaster']['grade'];
			$level[] = $value['LevelGradeMaster']['level'];
         } //debug($greades);
        //debug($level);
        $this->set(compact('greades','level'));
		$this->set('locations', $this->Location->find('list', array('fields'=> array('id', 'name'),'order' => array('Location.name'),'conditions' => array('Location.is_deleted' => 0,'Location.is_active' => 1))));
		$this->set('initials', $this->Initial->find('list', array('fields'=> array('id', 'name'))));
			
		$this->set('roles',$this->Role->getCoreRoles());
		$this->set('designations', $this->Designation->find('list', array('order' => array('Designation.name'),'fields'=> array('id', 'name'), 'conditions' => array('Designation.location_id' => $this->Session->read('locationid'), 'Designation.is_deleted' => 0))));
		$this->set('group',$this->AccountingGroup->find('list',array('fields'=>array('id','name'),'conditions'=>array('is_deleted'=>'0','location_id'=>$this->Session->read('locationid')),'order'=>array('name ASC'))));
		$this->set('groupId',$this->AccountingGroup->getAccountingGroupID(Configure::read('sundry_creditors')));
		
		if($userId){
	        $this->User->bindModel(array(
				'belongsTo' =>array( 
					'HrDetail' => array('foreignKey' => false,'conditions'=>array('HrDetail.user_id=User.id','HrDetail.is_deleted'=>0,"HrDetail.type_of_user"=>Configure::read('UserType')))
					)));
			$editData = $this->User->find('first',array('conditions'=>array('User.id'=>$userId/* ,'User.location_id'=>$this->Session->read('locationid')*/)));
			
			$serializeData = $this->SerializeDataConfiguration->find('all',array('conditions'=>array('SerializeDataConfiguration.subject_id'=>$editData['HrDetail']['id'],
					'SerializeDataConfiguration.subject_name'=>'HrDetail')));
			
			
			
			$hrData = $this->HrDocument->find('all',array('conditions'=>array('HrDocument.user_id'=>$userId,'HrDocument.location_id'=>$this->Session->read('locationid')),
					'fields'=>array('HrDocument.file_name','HrDocument.document_type','HrDocument.Certificate_details','HrDocument.user_id','HrDocument.location_id','HrDocument.create_time')));
			
			$fields = array('full_name');
				
			$this->set(array('createdBy'=>$this->User->getUserByID($editData['User']['created_by'],$fields)));
			
			$placementHistoryData = $this->PlacementHistory->find('all',array('conditions'=>array('PlacementHistory.user_id'=>$editData['User']['id'])));
					
			$this->set('hrData',$hrData);
			
			foreach ($placementHistoryData as $key =>$value){ 
				$reportingManager[] = $value['PlacementHistory']['reporting_manager'];
				$placementHistoryData[$key]['PlacementHistory']['shifts'] = $value['PlacementHistory']['shifts'];
				$placementHistoryData[$key]['PlacementHistory']['cadre_from_date'] = $this->DateFormat->formatDate2Local($value['PlacementHistory']['cadre_from_date'],Configure::read('date_format'),false);
				$placementHistoryData[$key]['PlacementHistory']['cadre_to_date'] = $this->DateFormat->formatDate2Local($value['PlacementHistory']['cadre_to_date'],Configure::read('date_format'),false);
			} 
			$manager = $this->User->find('list',array('fields'=>array('full_name'),'conditions'=>array('User.id'=>$reportingManager)));
			$this->set('manager',$manager);
			$this->set('placementHisData',$placementHistoryData);
			
			foreach ($serializeData as $key =>$value){
				
			/*	if($value['SerializeDataConfiguration']['object_name'] == 'qualification_detail')
			 		$editData['HrDetail']['qualification_detail']  = unserialize($value['SerializeDataConfiguration']['data']) ; */
				 
				if($value['SerializeDataConfiguration']['object_name'] == 'company_assets')
					$editData['HrDetail']['company_assets']  = unserialize($value['SerializeDataConfiguration']['data']) ;
				
				if($value['SerializeDataConfiguration']['object_name'] == 'appraisal_history')
					$editData['HrDetail']['appraisal_history']  = unserialize($value['SerializeDataConfiguration']['data']) ;
				
				if($value['SerializeDataConfiguration']['object_name'] == 'family_member')
					$editData['HrDetail']['family_member']  = unserialize($value['SerializeDataConfiguration']['data']) ;
				if($value['SerializeDataConfiguration']['object_name'] == 'personnel_issues')
					$editData['HrDetail']['personnel_issues']  = unserialize($value['SerializeDataConfiguration']['data']) ;
			}
	          
	        //$data['SerializeDataConfiguration']['qualification_detail'] = unserialize($data['SerializeDataConfiguration']['qualification_detail']);
	        $data['SerializeDataConfiguration']['appraisal_history'] = unserialize($data['SerializeDataConfiguration']['appraisal_history']);
			$data['SerializeDataConfiguration']['company_assets'] = unserialize($data['SerializeDataConfiguration']['company_assets']);
			$data['SerializeDataConfiguration']['family_member'] = unserialize($data['SerializeDataConfiguration']['family_member']);
			$data['SerializeDataConfiguration']['personnel_issues'] = unserialize($data['SerializeDataConfiguration']['personnel_issues']);
	                
			$editData = $this->convertingDatetoLocal($editData);
			
			if($editData)
	        	$editData['User']['other_location_id'] = explode(',',$editData['User']['other_location_id']);
		    	$editData['User']['ward_id'] = explode(',',$editData['User']['ward_id']);
				
			$this->data= $editData;
			
			$payDetailDates = $this->EmployeePayDetail->find('all', array('fields' => array('EmployeePayDetail.id','EmployeePayDetail.user_id','EmployeePayDetail.pay_application_date','EmployeePayDetail.user_salary'),
					'conditions' => array('EmployeePayDetail.user_id'=>$userId,'EmployeePayDetail.pay_application_date IS not null'),
					'group'=>array('EmployeePayDetail.pay_application_date'),'order'=>array('EmployeePayDetail.id'=>'asc')));
	       // debug($userId);
		//	debug($payDetailDates);
			$this->set('payDetailDate',$payDetailDates);
	         
	        $ss = $this->DoctorProfile->find('first', array('conditions' => array('DoctorProfile.user_id'=> $editData['User']['id']),
	        		'fields' => array('DoctorProfile.id','DoctorProfile.department_id', 'DoctorProfile.is_surgeon','DoctorProfile.is_opd_allow' /*,
	        				'DoctorProfile.is_registrar'*/)));
			$this->set('ss',$ss);
			$this->set('data',$editData);
		}
		
                /** BOF Tab 7 */
		$this->EarningDeduction->bindModel(array(
				'hasOne' =>array(
						'EmployeePayDetail' => array('foreignKey' => false,
								'conditions'=>array('EmployeePayDetail.earning_deduction_id = EarningDeduction.id',
										"EmployeePayDetail.hr_detail_id" => $editData['HrDetail']['id'],
										'EmployeePayDetail.pay_application_date <='=>date('Y-m-d')),
								))));
		$earnindAndDeduction = $this->EarningDeduction->find('all',array('fields'=>array('id','type','name','is_ward_service','is_doctor','service_category_id',
				'EmployeePayDetail.is_applicable','EmployeePayDetail.print_in_pay_slip','EmployeePayDetail.user_salary','EmployeePayDetail.id','EmployeePayDetail.pay_application_date','EmployeePayDetail.earning_deduction_id','EmployeePayDetail.service_category_id','EmployeePayDetail.ward_charges','EmployeePayDetail.day_amount','EmployeePayDetail.night_amount'),
				'conditions'=>array('EarningDeduction.is_deleted'=>0/*,'EarningDeduction.location_id'=>$this->Session->read('locationid')*/),
				'order'=>array('EmployeePayDetail.pay_application_date'=>'desc'),
				'group'=>array('EarningDeduction.id')));
		
		$this->set('earnindAndDeduction' , $earnindAndDeduction);
				
		$this->set('wards' , $this->Ward->getWardList());
		$this->set('bankNames' , $this->Account->getBankNameList());
		$this->set('userId',$userId);
		/** EOF Tab 7 */
	}//swa
	public function convertingDatetoLocal($data){
                if(!empty($data['User']['dob']))
                        $data['User']['dob'] = $this->DateFormat->formatDate2Local($data['User']['dob'],Configure::read('date_format'));
                if(!empty($data['HrDetail']['thumb_impression_registed']))
                        $data['HrDetail']['thumb_impression_registed'] = $this->DateFormat->formatDate2Local($data['HrDetail']['thumb_impression_registed'],Configure::read('date_format'));
                if(!empty($data['HrDetail']['date_of_join']))
                        $data['HrDetail']['date_of_join'] = $this->DateFormat->formatDate2Local($data['HrDetail']['date_of_join'],Configure::read('date_format'));
                if(!empty($data['HrDetail']['month_year_appraisal']))
                        $data['HrDetail']['month_year_appraisal'] = $this->DateFormat->formatDate2Local($data['HrDetail']['month_year_appraisal'],Configure::read('date_format'));
                if(!empty($data['HrDetail']['date_of_resignation']))
                        $data['HrDetail']['date_of_resignation'] = $this->DateFormat->formatDate2Local($data['HrDetail']['date_of_resignation'],Configure::read('date_format'));
                if(!empty($data['HrDetail']['payment_date']))
                        $data['HrDetail']['payment_date'] = $this->DateFormat->formatDate2Local($data['HrDetail']['payment_date'],Configure::read('date_format'));
                if(!empty($data['HrDetail']['relieving_letter_issued_date']))
                        $data['HrDetail']['relieving_letter_issued_date'] = $this->DateFormat->formatDate2Local($data['HrDetail']['relieving_letter_issued_date'],Configure::read('date_format'));
                if(!empty($data['HrDetail']['date_of_relieving']))
                        $data['HrDetail']['date_of_relieving'] = $this->DateFormat->formatDate2Local($data['HrDetail']['date_of_relieving'],Configure::read('date_format'));
                if(!empty($data['HrDetail']['experience_letter_issued_on']))
                        $data['HrDetail']['experience_letter_issued_on'] = $this->DateFormat->formatDate2Local($data['HrDetail']['experience_letter_issued_on'],Configure::read('date_format'));
                if(!empty($data['HrDetail']['gratuily_closed_on']))
                        $data['HrDetail']['gratuily_closed_on'] = $this->DateFormat->formatDate2Local($data['HrDetail']['gratuily_closed_on'],Configure::read('date_format'));
                if(!empty($data['HrDetail']['esi_closed_date']))
                        $data['HrDetail']['esi_closed_date'] = $this->DateFormat->formatDate2Local($data['HrDetail']['esi_closed_date'],Configure::read('date_format'));
                if(!empty($data['HrDetail']['pf_date']))
                        $data['HrDetail']['pf_date'] = $this->DateFormat->formatDate2Local($data['HrDetail']['pf_date'],Configure::read('date_format'));
                if(!empty($data['HrDetail']['valid_till']))
                        $data['HrDetail']['valid_till'] = $this->DateFormat->formatDate2Local($data['HrDetail']['valid_till'],Configure::read('date_format'));
                if(!empty($data['HrDetail']['starts_on']))
                        $data['HrDetail']['starts_on'] = $this->DateFormat->formatDate2Local($data['HrDetail']['starts_on'],Configure::read('date_format'));
                if(!empty($data['HrDetail']['ends_on']))
                        $data['HrDetail']['ends_on'] = $this->DateFormat->formatDate2Local($data['HrDetail']['ends_on'],Configure::read('date_format'));
                if(!empty($data['HrDetail']['probation_complition_date']))
                        $data['HrDetail']['probation_complition_date'] = $this->DateFormat->formatDate2Local($data['HrDetail']['probation_complition_date'],Configure::read('date_format'));
                if(!empty($data['HrDetail']['last_working_days']))
                        $data['HrDetail']['last_working_days'] = $this->DateFormat->formatDate2Local($data['HrDetail']['last_working_days'],Configure::read('date_format'));
                if(!empty($data['HrDetail']['pay_application_date']))
                        $data['HrDetail']['pay_application_date'] = $this->DateFormat->formatDate2Local($data['HrDetail']['pay_application_date'],Configure::read('date_format'));
                return $data;
	}
	// import User
	public function admin_import_data(){
		configure::write('debug',2);
		App::import('Vendor', 'reader');
		$this->set('title_for_layout', __('Tariff- Export Data', true));
		if ($this->request->is('post')) { //pr($this->request->data);
			if($this->request->data['importData']['import_file']['error'] !="0"){
				$this->Session->setFlash(__('Please Upload the file'), 'default', array('class' => 'error'));
				$this->redirect(array("controller" => "Users", "action" => "import_data","admin"=>true));
			}
			/*if($this->request->data['importData']['import_file']['size'] > "1000000"){
			 $this->Session->setFlash(__('Size exceed Please upload 1 MB size file.'), 'default', array('class' => 'error'));
			$this->redirect(array("controller" => "Tariffs", "action" => "import_data","admin"=>true));
			}*/
			
			$data = new Spreadsheet_Excel_Reader();
			$data->setOutputEncoding('CP1251');
			ini_set('memory_limit',-1);
			ini_set('max_input_vars',6000);
			ini_set('max_execution_time',180);
			set_time_limit(0);
			$path = WWW_ROOT.'uploads/import/'. $this->request->data['importData']['import_file']['name'];
			move_uploaded_file($this->request->data['importData']['import_file']['tmp_name'],$path );
			chmod($data->path,777);
			$data = new Spreadsheet_Excel_Reader($path);
			$is_uploaded = $this->User->importDataHope($data);
	
	
			if($is_uploaded == true){
				unlink( $path );
				$this->Session->setFlash(__('Data imported sucessfully'), 'default', array('class' => 'message'));
				$this->redirect(array("controller" => "Users", "action" => "import_data","admin"=>true));
			}else{
				unlink( $path );
				$this->Session->setFlash(__('Error Occured Please check your Excel sheet.'), 'default', array('class' => 'error'));
				$this->redirect(array("controller" => "Users", "action" => "import_data","admin"=>true));
			}
	
		}
	
	}
	/**
	 * function to include admin role list on user creation if location does not have admin
	 * @author gaurav chauriya
	 */
	public function getAdmin($locationId){
		$this->uses = array('Role');
		$this->autoRender = false;
		$this->User->unbindModel(array('belongsTo'=>array('City','State','Country','Initial')));
	
		$adminExist = $this->User->find('count',array('conditions'=>array('User.location_id'=>$locationId,'User.is_deleted'=>'0','is_active'=>'1',
				'Role.name'=>Configure::read('adminLabel')),'callbacks'=>false));
		if(!$adminExist){
			$this->Role->unBindModel(array('hasMany' => array('User')));
			$admin = $this->Role->find('first',array('fields'=>array('id','name'),'conditions'=>array('name'=>Configure::read('adminLabel')/*,'location_id'=>$this->Session->read('locationid')*/)));
		}else{
			$admin['Role']['name'] = false;
		}
		return json_encode($admin['Role']);
	}
	/**
	 * function to get User list of all location
	 * @author Swapnil Sharma
	 */
	public function getUserList(){
		$this->layout = 'ajax';
		$this->autoRender =false ;
		$this->uses = array('User');
		$term = $this->request->query['term'];
		$userList = $this->User->getAllUsers($term);
		echo json_encode($userList);
		exit;
	}

	
	function dashboard_status_update($patientID = null ,$optAptId = null){
		if(!$patientID) echo "Unable to process your request" ;
		$this->uses = array('Patient','OptAppointment');
		$field = $this->request->data['value'];
		
		if($field == 'Admitted'){
			$patientArray['dashboard_status'] = "'".$field."'";
		}else if($field == 'Posted For Surgery' && !empty($optAptId)){
			$patientArray['dashboard_status'] = "'".$field."'";
			$procedureArray['procedure_complete'] = "0";
			$this->OptAppointment->updateAll($procedureArray,array('OptAppointment.id'=>$optAptId));
		}else if($field == 'Operated' && !empty($optAptId)){
			$patientArray['dashboard_status'] = "'".$field."'";
			$procedureArray['procedure_complete'] = "1";
			$this->OptAppointment->updateAll($procedureArray,array('OptAppointment.id'=>$optAptId));
		}else if($field == 'Discharged'){
			$patientArray['dashboard_status'] = "'".$field."'";
		}
		$result = $this->Patient->updateAll($patientArray,array('id'=>$patientID));
		
		if(!$result) echo "Please try again" ;
		exit;
	}

	/**
	 * function to show data on date
	 * @author swatin
	 * */
	function showEmployeePayDetailData($date,$userId){
		$this->layout = 'ajax';
		$newdate = $this->DateFormat->formatDate2STD($date,'yyyy/mm/dd');
		$this->loadModel('EarningDeduction');
		$this->EarningDeduction->bindModel(array(
				'hasOne' =>array(
						'EmployeePayDetail' => array('foreignKey' => false,
								'conditions'=>array('EmployeePayDetail.user_id' => $userId,'EmployeePayDetail.earning_deduction_id = EarningDeduction.id',
										/*"EmployeePayDetail.hr_detail_id" => $editData['HrDetail']['id']*/)))
		));
		$earnindAndDeductions = $this->EarningDeduction->find('all',array('fields'=>array('id','type','name','is_ward_service','is_doctor','service_category_id',
				'EmployeePayDetail.is_applicable','EmployeePayDetail.id','EmployeePayDetail.print_in_pay_slip','EmployeePayDetail.earning_deduction_id','EmployeePayDetail.service_category_id','EmployeePayDetail.ward_charges','EmployeePayDetail.day_amount','EmployeePayDetail.night_amount','EmployeePayDetail.pay_application_date'),
				'conditions'=>array('EarningDeduction.is_deleted'=>0,'EarningDeduction.location_id'=>$this->Session->read('locationid'),"EmployeePayDetail.pay_application_date" => $newdate)));
	
		if(!empty($earnindAndDeductions)){
			foreach($earnindAndDeductions as $key=>$value){
	
				$earnindAndDeductions[$key]['EmployeePayDetail']['ward_charges'] = unserialize($value['EmployeePayDetail']['ward_charges']);
			}
			//debug($earnindAndDeductions); //exit;
			echo json_encode($earnindAndDeductions);
		}
		exit;
	}

	/**
	 * function to generate Hr Employee Code
	 * @param  text $roleName --> Role name
	 * @param  int $roleId --> Role Id;
	 * @return  HR code which is like "HH/HRM/OT-02"
	 * @author  Amit Jain
	 * @date 20-05-2016
	 */
	/* public function getHrCode($roleName,$roleId){
		$this->layout=ajax;
		$this->autorender=false;
		$finalHrCode = $this->User->generateHrCode($roleName,$roleId);
		echo json_encode($finalHrCode);
		exit;
	} */
	
	/**
	* function to check Employee Code availability
	* @author  Amit Jain
	* @date 20-05-2016
	*/
	function ajaxValidateEmployeeId($hr_code,$userId=null){
		$this->layout = 'ajax';
		$this->autoRender =false ;
		if($hr_code == ''){
			return false;
		}
		if(!empty($userId)){
			$conditions['User.id !='] = $userId;
		}
		$count = $this->User->find('count',array('conditions'=>array('User.hr_code'=>$hr_code,'User.is_deleted'=>0,$conditions)));
		return $count;
		exit;
	}

	// function dataseed($db_name){
	// 	//debug($db_name);die();
	// 	$database_details = new DATABASE_CONFIG();
	// 	try {
	// 		$dbh = new PDO("mysql:host=".$database_details->default['host'].";port=".$database_details->default['port'].";dbname=".$db_name."", $database_details->default['login'], $database_details->default['password']);
	// 	} catch (PDOException $e) {
	// 		echo 'Connection failed: ' . $e->getMessage();
	// 	}
	// 	$sql_schema = file_get_contents(APP.'Vendor/hope_data.sql');
	// 	//debug($sql_schema);
		
	// 	//die();
	// 	$dbh->exec($sql_schema);
	// 	$dbh = null;
	// 	return 'done';
	// 	exit;
	// }

	function dataseed($db_name){
		$database_details = new DATABASE_CONFIG();
		$servername = $database_details->default['host'];
		$username = $database_details->default['login'];
		$password = $database_details->default['password'];
		$dbname = $db_name;
		$port = $database_details->default['port'];

		try {
			// Create PDO connection
			$conn = new PDO("mysql:host=$servername;port=$port;dbname=$dbname", $username, $password);

			// Set error mode to exception
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// Load .sql file contents
			//$sql = file_get_contents(APP.'Vendor/hope_data.sql');
			$sql = file_get_contents(APP.'Config/Schema/database_structure.sql');

			// Execute multiple queries
			$conn->exec($sql);

			echo "SQL file loaded successfully";
			
		} catch(PDOException $e) {
			echo "Error loading SQL file: " . $e->getMessage();
		}

		// Close connection
		$conn = null;
		die();
	}
}
?>
