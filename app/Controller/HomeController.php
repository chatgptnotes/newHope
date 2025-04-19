<?php
/**
 * HomeController file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Home Controller
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 */

class HomeController extends AppController {
	
	public $name = 'Home';
	public $uses = array() ;
	public $components = array('General');
	
	
	function beforeFilter() {
    	$this->Auth->allow('*');
    }
	
	public function contactus(){#echo 'here';exit;
		$this->layout = false;
	}
	
	public function websolutions(){#echo 'here';exit;
		$this->layout = false;
	}
	
	public function winnerbestsolutions(){
		$this->layout = false;
	}
	
	function password_recovery(){ 
		 $this->layout = false;   
		if(!empty($this->request->data)){
			 
			$this->uses =array('UserPassword','FacilityUserMapping','Facility');
			$username = stripslashes($this->request->data['Home']['username']);
			$emailAdd = stripslashes($this->request->data['Home']['email']);
			//$this->User->recursive = -1 ; 
			
			//BOF pankaj
			$getdatabase_name = $this->FacilityUserMapping->find('first',
					array('conditions' => array('FacilityUserMapping.username' => $username )));
			
			$facility = $this->Facility->read(null,$getdatabase_name['Facility']['id']); 
			App::import('Vendor', 'DrmhopeDB');
			
			//BOF check for patient crediatial 
			 
			if(empty($getdatabase_name['Facility']['name'])){
				$usedhospitalid = Configure::read('default_facility_id');
				$getdatabase_name = $this->FacilityUserMapping->find('first',
						array('conditions' => array('FacilityUserMapping.facility_id' => $usedhospitalid)));
				$facility = $this->Facility->read(null,$usedhospitalid);
				 
				if(!empty($getdatabase_name['Facility']['name'])){
					$db_name = preg_replace('/\s+/', '', $facility['FacilityDatabaseMapping']['db_name']);
					$db_connection = new DrmhopeDB($db_name);  
					$personModel = ClassRegistry::init('Person');
					$db_connection->makeConnection($personModel);
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
					
					
					$countdata = $personModel->find('first', array('conditions' => array('Person.patient_uid' => $this->request->data['Home']['username'] ,
							'email'=>$this->request->data['Home']['email'], 'Person.is_deleted' => 0)));
					 
				//	$personModel->save(array('id'=>$countdata['Person']['id'],'email'=>'pankajw@drmhope.com')) ;
					 
					if(!empty($countdata)) {
						$emailAdd = $this->request->data['Home']['email'] ;
						//send email to users with autogenrated password
						$temPass = $this->General->generateRandomBillNo();
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
						$mail->Subject  = 'Password recovery' ;
						
						$message = "Hello ".ucfirst($countdata['Person']['first_name'])." ".$countdata['Person']['last_name']."<br/><br/>";
						$message .= "Your new password :"."\n";
						$message .= "<strong>".$temPass."<strong>" ; 
						
						$mail->Body     = $message;
						$mail->WordWrap = 50;
						$send =  $mail->Send() ; 
						if($send){
							$personModel->save(array('password'=>sha1($temPass),'id'=>$countdata['Person']['id'])) ;
							$this->Session->setFlash(__('New password has been sent to your Email address-'.$emailAdd),true,array('class'=>'message')); 
							$this->redirect($this->referer()) ;
						}else{
							$this->Session->setFlash(__('Please try again'),true,array('class'=>'error'));
							$this->redirect($this->referer()) ;
						}
					}else{
						$this->Session->setFlash(__('No Record Found'),true,array('class'=>'error'));
					 	$this->redirect($this->referer()) ;
					}
				}
				//exit;
			}//EOF patient creadiatial
			
			if(!empty($getdatabase_name['Facility']['name'])){ 
				$db_name = preg_replace('/\s+/', '', $facility['FacilityDatabaseMapping']['db_name']);
				$db_connection = new DrmhopeDB($db_name);
				$db_connection->makeConnection($this->UserPassword); 
				$isMaster = false; 
			} 
			 
			$result = $this->UserPassword->find('first',array('fields'=>array('UserPassword.id'),
					'conditions'=>array('username'=>$username,'UserPassword.email'=>$emailAdd,'UserPassword.is_deleted'=>0)));
		  
			if($result['UserPassword']['id']){
				//send email to users with autogenrated password
				$temPass = $this->General->generateRandomBillNo();
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
				$mail->Subject  = 'Password recovery' ;
				
				$message = "Hello ".ucfirst($username)."<br/><br/>";
				$message .= "Your new password :"."\n";
				$message .= "<strong>".$temPass."<strong>" ; 
				
				$mail->Body     = $message;
				$mail->WordWrap = 50;
				$send =  $mail->Send() ;
				 
				if($send){ 
					//update password
					$this->UserPassword->id = $result['UserPassword']['id'];
					$this->UserPassword->save(array('password'=>$temPass,'first_login'=>'yes')) ;
					$this->Session->setFlash(__('New password has been sent to your Email address-'.$emailAdd),true,array('class'=>'message'));
					$this->updateLoginAttempt($username); //reset all previous login attempts
					$this->redirect($this->referer());
				}
				else{
					$this->Session->setFlash(__('Please try again'),true,array('class'=>'error'));
				}
			}else{
				$this->Session->setFlash(__('Sorry, No match record found'),true,array('class'=>'error'));
			}
				/******************************************************************/
				//$email = new CakeEmail();
				//	$email->from(array($result['Facility']['email'] => $result['Facility']['name']));
				//	$email->to($emailAdd);
				//	$email->subject('Password recovery');
			/*	$message = "Hello ".ucfirst($username)."<br/><br/>";
				$message .= "Your new password :"."\n";
				$message .= "<strong>".$temPass."<strong>" ; 
			//	$sendEmail = $email->send($message);
				
				$to       = $emailAdd;
				$subject  = 'Password recovery';
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'From: '.$facility['Facility']['email'] . "\r\n" .
				    'Reply-To: '.$facility['Facility']['email'] . "\r\n" .
				    'X-Mailer: PHP/' . phpversion(); 
				//EOF Email
				if(mail($to, $subject, $message, $headers)){
					//update password
					$this->UserPassword->id = $result['UserPassword']['id'];
					$this->UserPassword->save(array('password'=>$temPass)) ;
					$this->Session->setFlash(__('New password has been sent to your Email address-'.$emailAdd),true,array('class'=>'message'));
				 	$this->redirect($this->referer());
				}else{
				 	$this->Session->setFlash(__('Please try again'),true,array('class'=>'error'));
				}
			}else{
				 $this->Session->setFlash(__('Sorry, No match record found'),true,array('class'=>'error'));
			}*/
			
		}
		 
	}
	
	
	//reset login attempt after successful login and change password
	function updateLoginAttempt($username){
		$this->loadModel('LoginAttempt') ;
		$currentDateTime =  (array)new DateTime("now", new DateTimeZone(Configure::read('login_attempt_timezone')));
		$currentDateTime =   $currentDateTime['date'] ;
			
		//reset all failed login for logged in user .
		$this->LoginAttempt->updateAll(array('user_login_attempt'=>0,'ip_login_attempt'=>0,'user_last_login'=>"'".$currentDateTime."'",'ip_last_login'=>"'".$currentDateTime."'"),array('username'=>$username)) ;
		//reset all failed login for logged in user IP Address.
		$this->LoginAttempt->updateAll(array('user_login_attempt'=>0,'ip_login_attempt'=>0,'user_last_login'=>"'".$currentDateTime."'",'ip_last_login'=>"'".$currentDateTime."'"),array('ip_address'=>$this->request->clientIp())) ;
			
	}
}
	