<?php
/**
 * MessagesController file
 *
 * PHP 5
 *
 * @copyright     Copyright 2013 drmhope Inc.  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       Messages Controller
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 */


class MessagesController extends AppController {

	public $name = 'Messages';
	public $uses = array('Message');
	public $helpers = array('Html','Form', 'Js','Fck','GibberishAES','General','DateFormat');
	public $components = array('RequestHandler','Email', 'Session','GibberishAES','ScheduleTime');
	public $username;
	public $password;


	public function compose($u_id=null,$id=null,$type=null){ 
		$this->redirect(array('controller'=>'messages','action'=>'compose_new',$u_id,$id,$type,'?'=>$this->params->query));
		if($type=='alert'){
			$this->layout="advance_ajax";
			$this->set('type',$type);			
		}
		$this->set('u_id',$u_id);
		$this->uses = array('User','Person','DoctorChamber','Patient','Message','Inbox','Outbox','Person'); 
		$this->Patient->unBindModel(array('hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')),false);
		$role = $this->Session->read('role') ;
		  
		
		if(empty($id) && (strtolower($role) != strtolower(Configure::read('doctorLabel')))){
			$getRecived=$this->Patient->find('first',array('fields'=>array('lookup_name','id','patient_id'),'conditions'=>array('id'=>$u_id)));
			$this->set('defaultSelection',$getRecived);		
		}else{ 
			$getRecived=$this->Patient->find('list',array('fields'=>array('person_id','lookup_name'),'conditions'=>array('doctor_id'=>$this->Session->read('userid')),'order'=>array('Patient.lookup_name')));
			$this->set('defaultSelection',$getRecived);
		} 
		if($this->Session->read('is_patient') == 1){
			$this->set('username',$this->Session->read('username'));
		}else{
			$this->set('messagePatientId',$this->Session->read('messagePatientId'));
		}
		$role = $this->Session->read('role');
		$this->set('role',strtolower($role));
		
		$users = $this->User->getUsersByRoleName(Configure::read('doctorLabel'));
		asort($users);
		$this->set('users',$users);
			
		if($this->request->data){  
			
			 
			$this->request->data['Compose']['from_name'] = $this->Session->read('first_name'). ' '.$this->Session->read('last_name') ;				
			$this->request->data['Compose']['from'] = $this->Session->read('username');
			 
			$this->request->data['Compose']['created_by'] = $this->Session->read('userid');
			if(!empty($this->request->data['Compose']['send_date'])){
				$this->request->data['Compose']['create_time'] = $this->DateFormat->formatDate2STD($this->request->data["Compose"]['send_date'],Configure::read('date_format_us'));
			}else{
				$this->request->data['Compose']['create_time'] = $this->DateFormat->formatDate2STD(date('m-d-Y H:i:s'),Configure::read('date_format'));
			}
			$this->request->data['Compose']['message'] = $this->request->data['message_enc'];
			if($this->request->data['Compose']['is_ammendment'] == 1){
				$this->request->data['Compose']['subject'] = $this->request->data['Compose']['subject'];
			} 
		 	
			foreach($this->request->data['Compose']['to_new'] as $to){
				if($this->request->data['Compose']['is_patient'] == 0){ //logged in as non patient role
					if($this->request->data['Compose']['to_type']!= 'Staff' && $this->request->data['Compose']['to_type'] != 'Medics'){  
						$toUsername = $this->Person->getUserDetails($to);
						$this->request->data['Compose']['to'] = $toUsername['Person']['patient_uid'];
						$this->request->data['Compose']['to_name'] = $toUsername['Person']['first_name']. ' '.$toUsername['Person']['last_name'] ;
						$this->request->data['Compose']['reference_patient'] = $toUsername['Person']['patient_uid']; 
					}else{
						$toUsername = $this->User->getUserDetails($to);
						$this->request->data['Compose']['to'] = $toUsername['User']['username'];
						$this->request->data['Compose']['to_name'] = $toUsername['User']['first_name']. ' '.$toUsername['User']['last_name'] ;
						$this->request->data['Compose']['reference_patient'] =$this->request->data['Compose']['from'] ;									
					}
					
				}else if($this->request->data['Compose']['is_patient'] == 1){ //logged in as patient role
					
					$toUsername = $this->User->getUserDetails($to); 
					$this->request->data['Compose']['to'] = $toUsername['User']['username'];
					$this->request->data['Compose']['to_name'] = $toUsername['User']['first_name']. ' '.$toUsername['User']['last_name'] ;
					
					//check for doctor's schedule if doc is not available then send reply msg msg to patient
					//find patient id.
					$this->request->data['Compose']['reference_patient'] =$this->request->data['Compose']['from'] ; //set reference patient for patient role
					$getPatientID = $this->Patient->find('first',array('fields'=>array('lookup_name','id','patient_id'),'conditions'=>array('person_id'=>$this->request->data['Compose']['created_by'])));
					$getDocChambersDetails = $this->DoctorChamber->Find('first',array('conditions'=>array('doctor_id'=>$to,
							'DATE_FORMAT(DoctorChamber.starttime, "%Y-%m-%d") '=>date('Y-m-d',strtotime($this->request->data['Compose']['create_time']))),
							'fields'=>array('starttime','endtime')));
						
					$startTime = strtotime($this->DateFormat->formatDate2Local($getDocChambersDetails['DoctorChamber']['starttime'],'yyyy-mm-dd',true));
					$endTime   = strtotime($this->DateFormat->formatDate2Local($getDocChambersDetails['DoctorChamber']['endtime'],'yyyy-mm-dd',true));
					$patientRequestTime = strtotime($this->DateFormat->formatDate2Local($this->request->data['Compose']['create_time'],'yyyy-mm-dd',true));
					$date=$this->DateFormat->formatDate2Local($this->request->data['Compose']['create_time'],Configure::read('date_format'),true);	
					$data['scheduledate']=$date;
					$data['appointment_with']=$to;
					$data['schedule_starttime']=date('H:i:s');
					$data['schedule_endtime']=date('H:i:s');
					$isAppointmentOverlap = $this->ScheduleTime->CheckOverlapBlockTime($data);
					if(!empty($isAppointmentOverlap)){
						
						$this->User->bindModel(array(
								'hasOne' => array('DoctorProfile'=>array('foreignKey'=>'user_id'))));
						$details =  $this->User->find('all',array('fields'=>array('User.first_name','User.last_name','User.id','User.phone1','User.phone2','User.mobile'),'conditions'=>array('Role.name'=>Configure::read("doctorLabel"),
								'User.is_active'=>1,'DoctorProfile.is_deleted'=>0,'DoctorProfile.is_registrar'=>0, 'User.is_deleted'=>0,'User.location_id'=>$this->Session->read('locationid')),
								'order'=>array('User.first_name Asc')));
						$mailHtml= '<ul><h3>List of Doctors and their Contact Details</h3>';
						foreach($details as $doctor){
							if(!empty($doctor['User']['phone1'])){
								$phone=$doctor['User']['phone1'];
							}
							elseif(!empty($doctor['User']['phone2'])){
								$phone=$doctor['User']['phone1'];
							}
							elseif(!empty($doctor['User']['mobile'])){
								$phone=$doctor['User']['mobile'];
							}
							$mailHtml.='<li>'.$doctor['User']['first_name'].' '.$doctor['User']['last_name'] .' - '.$phone.'</li>';
						}
						$mailHtml.='</ul>';
						
						//send reply msg to patient that doctor is not available
						$replyPatient['from'] = $this->request->data['Compose']['to'];
						$replyPatient['to'] = $this->request->data['Compose']['from'];
						$replyPatient['from_name'] = $this->request->data['Compose']['to_name'];
						$replyPatient['to_name'] =  $this->request->data['Compose']['from_name'];
						$replyPatient['subject'] = "Auto reply";
						$replyPatient['type'] = "Normal";
						$replyPatient['message'] = $this->GibberishAES->enc("Auto reply test message".$mailHtml,Configure::read('hashKey'));
						$replyPatient['reference_patient'] = $this->request->data['Compose']['reference_patient'];
						$replyPatient['create_time'] = $this->request->data['Compose']['create_time'] ;
						$replyPatient['is_patient'] = '1';
						$this->Inbox->Save($replyPatient);
						$this->Inbox->id='';
					} //EOF doc check
				}
				 
				if($this->Inbox->Save($this->request->data['Compose'])){
					if($this->Outbox->Save($this->request->data['Compose'])){
						$this->Inbox->id='';
						$this->Outbox->id='';
					} 
				}
			}
			//To manage critical alerts first send mail to nurse
			if($type=='alert'){
				$this->uses=array('Patient');
				if($u_id){
					$this->Patient->updateAll(array('Patient.is_dr_chk' => 1), array('Patient.id' => $u_id));
				}
				$this->redirect(array("controller" => "Appointments", "action" => "appointments_management", "admin" => false));
			}else{
			$this->redirect(array("controller" => "messages", "action" => "inbox", "admin" => false)); 
			}
		}
		
		//BOF forward action 
		if($this->params->query['action']=='outbox_forward'){
			if(empty($this->params->query['messageID'])){
				$this->redirect($this->referer());
			}
			$outbox =  $this->Outbox->find('first',array('conditions'=>array('id'=>$this->params->query['messageID']))); 
			$outbox['Outbox']['message'] = $this->GibberishAES->dec($outbox['Outbox']['message'],Configure::read('hashKey')) ;
			$outbox['Compose'] = $outbox['Outbox'] ;   
			$this->data = $outbox; 
		}else if($this->params->query['action']=='inbox_forward'){
			if(empty($this->params->query['messageID'])){
				$this->redirect($this->referer());
			}
			$inbox =  $this->Inbox->find('first',array('conditions'=>array('id'=>$this->params->query['messageID'])));
			$inbox['Inbox']['message'] = $this->GibberishAES->dec($inbox['Inbox']['message'],Configure::read('hashKey')) ;
			$inbox['Compose'] = $inbox['Inbox'] ;
			$this->data = $inbox;
		}
		 
	}

	public function index($id=null){
		$p_id=$_SESSION['Auth']['User']['patient_uid'];
		$recivePortalData=$this->portal_header($p_id);
		$this->patient_info($id);
		$this->set('id',$id);
		$this->set('recivePortalData',$recivePortalData);
		
	}
	public function inbox($id=null){
		$this->uses = array('Inbox','Patient');
		$getData=$this->Patient->find('first',array('fields'=>array('patient_id'),'conditions'=>array('Patient.id'=>$id)));

		$this->set('u_id',$getData['Patient']['patient_id']);
		if(!empty($getData['Patient']['patient_id'])){
			$this->Session->write('messagePatientId',$getData['Patient']['patient_id']);
		}
		$this->paginate = array(
				'limit' => /*Configure::read('number_of_rows')*/15,
				'order' => array('Inbox.id' => 'DESC'),
				'conditions'=>array('Inbox.to'=>$this->Session->read('username'))
		);
		$this->set('messages',$this->paginate('Inbox'));
		  
		if($this->Session->read('is_patient') == 1){
			$this->set('to_type','Medics');
		}else{
			$this->set('to_type','Patient');
		}
		$this->patient_info($id);
 
	}



	public function replyInbox(){
		if($this->request->data){//echo '<pre>';print_r($this->request->data);exit;
			$this->uses = array('Inbox','Outbox');
			$this->request->data['Inbox']['to'] = $this->request->data['to'];
			$this->request->data['Inbox']['from'] = $this->request->data['from'];
			$this->request->data['Inbox']['message'] = $this->request->data['message'];
			$this->request->data['Inbox']['subject'] = $this->request->data['subject'];
			$this->request->data['Inbox']['created_by'] = $this->Session->read('userid');
			$this->request->data['Inbox']['create_time'] = date('Y-m-d H:i:s');
			$this->request->data['Inbox']['to_name'] = $this->request->data['from_name'];
			$this->request->data['Inbox']['from_name'] = $this->request->data['to_name'];
			$this->request->data['Inbox']['is_ammendment'] = $this->request->data['is_ammendment'];
			$this->request->data['Inbox']['reason'] = $this->request->data['reason'];
				
			if($this->request->data['ammendment_status'] == 'is_denied'){
				$this->request->data['Inbox']['ammendment_status'] = 0;
			}else{
				$this->request->data['Inbox']['ammendment_status'] = 1;
			}
				
			if($this->Inbox->Save($this->request->data['Inbox'])){
				if($this->Outbox->Save($this->request->data['Inbox'])){
					$this->Session->setFlash(__('Message sent successfully'),'default',array('class'=>'message'));
					$this->redirect(array('action'=>'index'));
				}

			}
		}
	}


	public function forwardInbox(){
		if($this->request->data){
			$this->uses = array('Inbox','Outbox','Person','User');
				
			$this->request->data['Inbox']['from'] = $this->request->data['from'];
			$this->request->data['Inbox']['message'] = $this->request->data['message'];
			$this->request->data['Inbox']['subject'] = $this->request->data['subject'];
			$this->request->data['Inbox']['created_by'] = $this->Session->read('userid');
			$this->request->data['Inbox']['create_time'] = date('Y-m-d H:i:s');
			$this->request->data['Inbox']['to_name'] = $this->request->data['from_name'];
			$this->request->data['Inbox']['from_name'] = $this->request->data['to_name'];
			$this->request->data['Inbox']['is_ammendment'] = $this->request->data['is_ammendment'];
			$toArray = explode(",", $this->request->data['to']);
				
			foreach ($toArray as $to){
				if($this->Session->read('is_patient') == 1){
					$toUsername = $this->User->getUserDetails($to);
					$this->request->data['Inbox']['to'] = $toUsername['User']['username'];
					$this->request->data['Inbox']['to_name'] = $toUsername['User']['first_name']. ' '.$toUsername['User']['last_name'] ;
				}else{
					$toUsername = $this->Person->getUserDetails($to);
					$this->request->data['Inbox']['to'] = $toUsername['Person']['patient_uid'];
					$this->request->data['Inbox']['to_name'] = $toUsername['Person']['first_name']. ' '.$toUsername['Person']['last_name'] ;
				}

				if($this->Inbox->Save($this->request->data['Inbox'])){
					if($this->Outbox->Save($this->request->data['Inbox'])){
						$this->Inbox->id='';
						$this->Outbox->id='';
					}

				}
			}
				
			echo 'Message sent successfully';exit;
		}
	}


	public function getUsers($type='medics'){
		if(isset($this->request->data['to_type']) && !empty($this->request->data['to_type'])){
			$type = $this->request->data['to_type'];
		}
		$this->uses = array('User','Person');
		if($type == 'Medics'){
			$users = $this->User->getDoctorsByLocation();//doctors only 
		}else if($type == 'Patient'){
			$users = $this->Person->getAllPatients();
		}
		else if($type == 'Staff'){
			$users=$this->User->getUserStaff();
		}
		else{
			$users=$this->User->getUsers();
		}
		//debug($users);//exit;
		asort($users);
		//$users=array_filter($users);
		//debug($users);exit;
		$this->layout = false ;
		$this->autoRender = false ;
		return json_encode($users);
		exit;
	}


	public function openMessage(){

		if(isset($this->request->data['messageId']) && !empty($this->request->data['messageId'])){
			$this->uses = array('Inbox');
				
			$message = $this->Inbox->find('first',array('conditions'=>array('Inbox.id'=>$this->request->data['messageId'])));
			//$message['Inbox']['message'] = nl2br($message['Inbox']['message']);
				
			$message['Inbox']['message'] = str_replace(" ", "+", $message['Inbox']['message']);
			//$message['Inbox']['subject'] = str_replace(" ", "+", $message['Inbox']['subject']);
				
			$this->Inbox->id = $this->request->data['messageId'];
			$this->Inbox->save(array('is_read'=>1));
			echo json_encode($message);exit;
			//echo '<pre>';print_r($message);exit;
		}
	}

	public function deleteMessage($messageId){
		$this->uses = array('Inbox');
		if($this->Inbox->delete($messageId)){
			$this->Session->setFlash(__('Message deleted successfully'),'default',array('class'=>'message'));
			$this->redirect($this->referer());
		}
	}

	public function outbox(){
		$this->uses = array('Outbox');
		$this->paginate = array(
				'limit' => /*Configure::read('number_of_rows')*/15, 		//by swapnil
				'order' => array('Outbox.id' => 'DESC'),
				'conditions'=>array('from'=>$this->Session->read('username'))
		);
		$this->set('messages',$this->paginate('Outbox'));

		if($this->Session->read('is_patient') == 1){
			$this->set('to_type','Medics');
		}else{
			$this->set('to_type','Patient');
		}


	}


	public function deleteOutboxMessage($messageId){
		$this->uses = array('Outbox');
		if($this->Outbox->delete($messageId)){
			$this->Session->setFlash(__('Message deleted successfully'),'default',array('class'=>'message'));
			$this->redirect(array('action'=>'outbox'));
		}
	}

	public function openOutboxMessage(){
		if(isset($this->request->data['messageId']) && !empty($this->request->data['messageId'])){
			$this->uses = array('Outbox');
				
			$message = $this->Outbox->find('first',array('conditions'=>array('Outbox.id'=>$this->request->data['messageId'])));
			//$message['Outbox']['message'] = nl2br($message['Outbox']['message']);
				
			$message['Outbox']['message'] = str_replace(" ", "+", $message['Outbox']['message']);
			//$message['Outbox']['subject'] = str_replace(" ", "+", $message['Outbox']['subject']);
				
			$this->Outbox->id = $this->request->data['messageId'];
			$this->Outbox->save(array('is_read'=>1));
			echo json_encode($message);
			exit;
		}
	}

	public function forwardOutbox(){
		if($this->request->data){
			$this->uses = array('Inbox','Outbox','Person','User');
			$this->request->data['Inbox']['to'] = $this->request->data['to'];
			$this->request->data['Inbox']['from'] = $this->request->data['from'];
			$this->request->data['Inbox']['message'] = $this->request->data['message'];
			$this->request->data['Inbox']['subject'] = $this->request->data['subject'];
			$this->request->data['Inbox']['created_by'] = $this->Session->read('userid');
			$this->request->data['Inbox']['create_time'] = date('Y-m-d H:i:s');
			//echo '<pre>';print_r($this->request->data['Inbox']);exit;
				
			$this->request->data['Inbox']['to_name'] = $this->request->data['from_name'];
			$this->request->data['Inbox']['from_name'] = $this->request->data['to_name'];
			$this->request->data['Inbox']['is_ammendment'] = $this->request->data['is_ammendment'];
			$toArray = explode(",", $this->request->data['to']);
				
			foreach ($toArray as $to){
				if($this->Session->read('is_patient') == 1){
					$toUsername = $this->User->getUserDetails($to);
					$this->request->data['Inbox']['to'] = $toUsername['User']['username'];
					$this->request->data['Inbox']['to_name'] = $toUsername['User']['first_name']. ' '.$toUsername['User']['last_name'] ;
				}else{
					$toUsername = $this->Person->getUserDetails($to);
					$this->request->data['Inbox']['to'] = $toUsername['Person']['patient_uid'];
					$this->request->data['Inbox']['to_name'] = $toUsername['Person']['first_name']. ' '.$toUsername['Person']['last_name'] ;
				}

				if($this->Inbox->Save($this->request->data['Inbox'])){
					if($this->Outbox->Save($this->request->data['Inbox'])){
						$this->Inbox->id='';
						$this->Outbox->id='';
					}

				}
			}
				
			echo 'Message sent successfully';exit;
		}
	}

	public function createCredentials($patientId,$email,$date){
		$from = Configure::read('mailFrom');
		$this->uses = array('Patient','Person');
	//	if(!empty($patientId)){
			$password = $this->Message->generatePassword(8);
				
			$this->Patient->bindModel(array(
					//'hasOne' => array(
					'belongsTo'=> array(
							'Person' =>array('foreignKey' => 'person_id') ,
					 
							'Guarantor' =>array('foreignKey' => false,'conditions'=>array('Patient.person_id=Guarantor.person_id' ))
					),
			),false);
			$patientData = $this->Patient->find('first',array('conditions'=>array('Patient.id' => $patientId)));
			 
			$this->Person->id = $patientData['Person']['id'];
			$this->Person->save(array('password' => sha1($password),'role_id' => 45,'modify_time'=>date('Y-m-d H:i:s'),'patient_credentials_created_date'=>$date));//hardcoded
			 if(empty($email)){
			 	$email = $patientData['Person']['email'];
			 }
			 $this->username = $patientData['Patient']['patient_id'];
			 $this->password = $password;
			//echo $patientData['Patient']['patient_id'].'<->'.($password); //exit;
			if($this->Message->sendCredentialsOnEmail($patientData['Guarantor']['gau_email'],$email,$from,$patientData['Person']['patient_uid'],$password,$patientData['Person']['first_name'].' '.$patientData['Person']['last_name'])){
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




	public function changepassword(){//echo sha1('password');exit;

		if(!empty($this->request->data)){
			$this->uses=array('Person','User');
			$current_password=sha1($this->request->data['Message']['current_password']);
			$isPatient = $this->Session->read('is_patient');
			if(!empty($isPatient) && $isPatient == 1){
				$getpassword=$this->Person->find('first',array('fields'=>array('Person.password'),'conditions'=>array('Person.patient_uid'=>$this->Session->read('username'))));
				$dbPass = $getpassword['Person']['password'];
			}else{
				$getpassword=$this->User->find('first',array('fields'=>array('User.password'),'conditions'=>array('User.username'=>$this->Session->read('username'))));
				$dbPass = $getpassword['User']['password'];
			}
			//echo $current_password.'<->'.$getpassword['User']['password'];exit;
			if(trim($current_password) == trim($dbPass)){
				$dbPassword = sha1($this->request->data["Message"]["new_password"]);
				if(!empty($isPatient) && $isPatient == 1){
					$this->Person->updateAll(array('password'=>"'".$dbPassword."'"),array('Person.patient_uid' => $this->Session->read('username')));
				}else{
					$this->User->updateAll(array('password'=>"'".$dbPassword."'"),array('User.username' => $this->Session->read('username')));
				}

				$this->Session->setFlash(__("Password Changed Successfully"),'default',array('class'=>'message'));
			}
			else{
				$this->Session->setFlash(__("Password do not Match"),'default',array('class'=>'message'));
			}
			$this->redirect(array('controller'=>'messages','action'=>'index'));
		}

		//debug($getpassword);


	}
	/*public function openMessage(){
	 //$this->request->data['messageId']=1;
	if(isset($this->request->data['messageId']) && !empty($this->request->data['messageId'])){
	$isPatient = $this->request->data['isPatient'];
	if($isPatient==''){
	$isPatient=0;
	}
	$this->uses = array('Inbox');

	if($isPatient == 0){//Medics sends to medics
	$this->Inbox->bindModel(array(
			'hasOne'=>array('From'=>array('foreignKey'=>false,
					'className' => 'User',
					'conditions' => array('Inbox.from=From.id'),
					'fields' => array('first_name','last_name')
			),
					'To'=>array('foreignKey'=>false,
							'className' => 'User',
							'conditions' => array('Inbox.to=To.id'),
							'fields' => array('first_name','last_name')
					),
			)
	));
	}else{//Patient sends to medics
	$this->Inbox->bindModel(array(
			'hasOne'=>array('From'=>array('foreignKey'=>false,
					'className' => 'Person',
					'conditions' => array('Inbox.from=From.id'),
					'fields' => array('first_name','last_name')
			),
					'To'=>array('foreignKey'=>false,
							'className' => 'User',
							'conditions' => array('Inbox.to=To.id'),
							'fields' => array('first_name','last_name')
					),
			)
	));
	}


	$message = $this->Inbox->find('first',array('conditions'=>array('Inbox.id'=>$this->request->data['messageId'])));
	$message['Inbox']['message'] = nl2br($message['Inbox']['message']);

	$this->Inbox->id = $this->request->data['messageId'];
	$this->Inbox->save(array('is_read'=>1));
	echo json_encode($message);exit;
	//echo '<pre>';print_r($message);exit;
	}
	}*/

	public function labResults(){
		//$person_id = 'UHHO13B05001';

		$personId = $this->Session->read('username');
		$patient_id=$this->Session->read('patientId');
		$this->uses = array('Person','Patient','Consultant','User','LabManager','LaboratoryResult','RadiologyTestOrder','RadiologyReport','RadiologyResult','Radiology');
		//$personId = 'UHHO13C15009';
		if(!empty($personId)){
				
			$this->patient_info($patient_id);

			$this->LabManager->bindModel(array(
					'belongsTo' => array(
							'Laboratory'=>array('foreignKey'=>'laboratory_id','conditions'=>array('Laboratory.is_active'=>1)),
							'Patient'=>array('foreignKey'=>'patient_id')
					),
					'hasOne' => array( 'LaboratoryResult'=>array('foreignKey'=>'laboratory_test_order_id') ,
							'LaboratoryToken'=>array('foreignKey'=>'laboratory_test_order_id')
					)),false);

			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'fields'=>array('Patient.admission_id','LaboratoryResult.text','LaboratoryResult.result_publish_date','LaboratoryResult.confirm_result','LabManager.id','LabManager.create_time',
							'LabManager.patient_id','LabManager.order_id','Laboratory.id','Laboratory.name','LaboratoryToken.ac_id','LaboratoryToken.sp_id'),
					'conditions'=>array('LabManager.patient_id ' =>$this->Patient->find('list', array('conditions' => array('Patient.patient_id' => $personId), 'fields'=> array('id'))),'LabManager.is_deleted'=>0),
					'order' => array(
							'LabManager.id' => 'asc'
					),
					'group'=>'LabManager.id'
			);
			$testOrdered   = $this->paginate('LabManager');
				
			$this->set(array('testOrdered'=>$testOrdered));
			//$testOrdered = $this->Cipher->decrypt($testOrdered);
			//echo '<pre>';print_r($testOrdered);exit;
				
		}else{
			$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
			$this->redirect($this->referer());
		}
	}

	public function radResults(){
		$personId = $this->Session->read('username');
		$patient_id=$this->Session->read('patientId');
		$this->uses = array('Person','Patient','Consultant','User','RadioManager','RadiologyResult','RadiologyReport');
		if(!empty($patient_id)){
			$data1 = $this->RadiologyReport->find('all',array('fields'=>array('RadiologyReport.id','RadiologyReport.patient_id','RadiologyReport.file_name','RadiologyReport.description'),
					'conditions'=>array('RadiologyReport.patient_id'=>$patient_id)));
				
			for($a=0;$a<count($data1);$a++){

				$b[]='"'.$this->webroot.'uploads/radiology/'.$data1[$a][RadiologyReport][file_name].'"';
				$c[]='"'.$data1[$a]['RadiologyReport']['description'].'"';
			}
				
			$this->set('data1',$data1);
			$this->set('b',$b);
			$this->set('c',$c);
				
			//BOF referer link
			$sessionReturnString = $this->Session->read('radResultReturn') ;
			$currentReturnString = $this->params->query['return'] ;
			if(($currentReturnString!='') && ($currentReturnString != $sessionReturnString) ){
				$this->Session->write('radResultReturn',$currentReturnString);
			}
			//EOF referer link
			$this->patient_info($patient_id);

			$this->RadioManager->bindModel(array(
					'belongsTo' => array(
							'Radiology'=>array('type'=>'inner','foreignKey'=>'radiology_id','conditions'=>array('Radiology.is_active'=>1)),
							'Patient'=>array('foreignKey'=>'patient_id')
					),
					'hasOne' => array(
							'RadiologyResult'=>array('foreignKey'=>'radiology_test_order_id')
					)),false);
			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'fields'=>array('Patient.admission_id','RadiologyResult.note','RadiologyResult.id', 'RadiologyResult.result_publish_date','RadiologyResult.confirm_result','RadioManager.id','RadioManager.create_time','RadioManager.patient_id','RadioManager.order_id','Radiology.id','Radiology.name'),
					'conditions'=>array('RadioManager.patient_id'=>$this->Patient->find('list', array('conditions' => array('Patient.patient_id' => $personId), 'fields'=> array('id'))),'RadioManager.is_deleted'=>0),
					'order' => array(
							'RadioManager.id' => 'asc'
					),
					'group'=>'RadioManager.id'
			);
			$testOrdered   = $this->paginate('RadioManager');

			$this->set(array('testOrdered'=>$testOrdered));
			/*if($this->Session->read('role')=='doctor'){
			 $this->render('doctor_test_list');
			}*/ //commented by doctyor
		}else{
			$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
			$this->redirect($this->referer());
		}
	}


	public function getMedication(){
		$this->uses = array('Patient');
		$personId = $this->Session->read('username');
		$patient_id=$this->Session->read('patientId');
		//$personId = 'UHHO13C15009';
		$this->patient_info($patient_id);
		$medicationRecords=$this->Patient->get_medication_record($personId);

		$parseMedication =explode('~',$medicationRecords);
		$CountOfMedicationRecords=count($parseMedication);

		for($i=0;$i<$CountOfMedicationRecords;$i++){

			$parsedMedications[] =explode('>>>>',$parseMedication[$i]);
		}

		$this->set('allergiesSpecific',$parsedMedications);
	}

	public function getAllergies(){
		$this->uses = array('Patient');
		$personId = $this->Session->read('username');
		//$personId = 'UHHO13C15009';
		$patient_id=$this->Session->read('patientId');
		$this->patient_info($patient_id);

		$getPatientAllergies=$this->Patient->PatientAllergies($personId);

		$PatientAllergies =explode('~',$getPatientAllergies);

		$CountOfAllergiesRecords=count($PatientAllergies);


		for($i=0;$i<=$CountOfAllergiesRecords;$i++){
			if(!empty($PatientAllergies[$i])){
				$AllergiesSpecific[] =explode('>>>>',$PatientAllergies[$i]);
			}
				

		}//echo '<pre>';print_r($AllergiesSpecific);exit;

		$this->set('setAllergies',$AllergiesSpecific);
	}

	public function getAllData(){
		$patient_id=$this->Session->read('patientId');
		$this->patient_info($patient_id);

		//echo "<pre>";print_r(); exit;
		$this->uses=array('Patient');
		$id=$this->Patient->find('first',array('fields'=>array('id'),'conditions'=>array('Patient.patient_id'=>$_SESSION['Auth']['User']['patient_uid'])));
		$this->set('id',$id['Patient']['id']);
		$this->getCareTeam();
		//$this->getSmokingStatus();

		$this->getAllergies();
		$this->getMedication();

		
		$this->getProcedures();
		$this->getVitalSigns();
		$this->getCarePlan();
		
		$this->getImmunization();
		$this->getProblems();
		
		$inPatient = 1;
		if($inPatient == 1){
			$this->set('isInpatient',1);
			$this->getEncounterInformation();
			$this->getEncounterDiagnosis();
			$this->getDischargeInstruction();
			$this->getCognitiveFunctions();
			$this->getHospitalizationReason();
		}



		//$this->getCarePlan();exit;

		//echo '<pre>';print_r($doctorData);exit;
	}

	public function getImmunization($patient_id=null){
		$personId = $this->Session->read('username');
		$patient_id=$this->Session->read('patientId');
		//$personId = 'UHHO13G02002';
		//$patient_id=$this->Session->read('patientId');
		$this->uses = array('Imunization','Immunization');
		$this->Imunization->bindModel( array(
				'belongsTo' => array(

						'Immunization'=>array('className'=>'Immunization','conditions'=>array('Immunization.vaccine_type=Imunization.cpt_description'),'foreignKey'=>false),

				)

		));
		$description = $this->Immunization->find('list',array('fields' => array('Immunization.vaccine_type'),
				'conditions'=>array('Immunization.patient_id'=>$this->Patient->find('list', array('conditions' => array('Patient.patient_id' => $personId))))));
		$this->set('description',$description);
		//echo '<pre>';print_r($description);exit;

		$this->Imunization->bindModel( array(
				'belongsTo' => array(

						'Immunization'=>array('className'=>'Immunization','conditions'=>array('Immunization.vaccine_type=Imunization.cpt_description'),'foreignKey'=>false),

				)

		));
		$vaccine_type = $this->Imunization->find('all',array('fields' => array('Imunization.cpt_description','Imunization.code_system','Immunization.date'),
				'conditions'=>array('Imunization.cpt_description'=>$description)));
		$this->set('vaccine_type',$vaccine_type);

		//echo '<pre>';print_r($vaccine_type);exit;
	}

	public function getAllDataPdf(){
		$patient_id=$this->Session->read('patientId');
		$this->patient_info($patient_id);


		$this->getCareTeam();
		$this->getSmokingStatus();

		$this->getAllergies();
		$this->getMedication();
		$this->getProblems();
		$this->getProcedures();
		$this->getVitalSigns();
		$this->getCarePlan();
		//$this->getSmokingStatus();
		$inPatient = 1;
		if($inPatient == 1){
			$this->set('isInpatient',1);
			$this->getEncounterInformation();
			$this->getEncounterDiagnosis();
			$this->getDischargeInstruction();
			$this->getCognitiveFunctions();
			$this->getHospitalizationReason();
		}



		//$this->getCarePlan();exit;

		//echo '<pre>';print_r($doctorData);exit;
	}

	public function getSmokingStatus(){
		$personId = $this->Session->read('username');
		//$personId = 'UHHO13G02002';
		$patient_id=$this->Session->read('patientId');
		$this->uses = array('PatientAllergy','PatientPersonalHistory','PatientSmoking','PatientPastHistory','PatientFamilyHistory','SmokingStatusOncs');
		$this->Diagnosis->bindModel( array(
				'belongsTo' => array(
						'PatientSmoking'=>array('className'=>'PatientSmoking','conditions'=>array('Diagnosis.id=PatientSmoking.diagnosis_id'),'foreignKey'=>false),
						'Patient'=>array('foreignKey'=>'patient_id'),
						'SmokingStatusOncs'=>array('className'=>'SmokingStatusOncs','conditions'=>array('PatientSmoking.smoking_fre=SmokingStatusOncs.id'),'foreignKey'=>false),
						'SmokingStatusOncs1'=>array('className'=>'SmokingStatusOncs','conditions'=>array('PatientSmoking.current_smoking_fre=SmokingStatusOncs1.id'),'foreignKey'=>false)
				)

		));



		$diagnosisRec = $this->Diagnosis->find('all',array('fields' => array('Diagnosis.id','Patient.admission_id','PatientSmoking.smoking_fre','PatientSmoking.current_smoking_fre','PatientSmoking.created_date','SmokingStatusOncs1.description','SmokingStatusOncs.description','SmokingStatusOncs1.snomed_id'),
				'conditions'=>array('Diagnosis.patient_id'=>$this->Patient->find('list', array('conditions' => array('Patient.patient_id' => $personId))))));
		$this->set('diagnosisRec',$diagnosisRec);

		//echo '<pre>';print_r($patient_id);exit;

		//echo '<pre>';print_r($diagnosisRec);exit;
	}

	public function getCareTeam(){
		$this->uses = array('Patient','User','Doctor');
		$this->Patient->unBindModel(array('hasMany' => array('PharmacySalesBill', 'InventoryPharmacySalesReturn','Person')));
		$personId = $this->Session->read('username');
		//$personId = 'UHHO13C15009';
		//$patient_id=$this->Session->read('patientId');
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Location'=>array('foreignKey'=>false, 'conditions'=>array('Location.id=Patient.location_id')),
						'User'=>array('foreignKey'=>'doctor_id'),
						'City'=>array('foreignKey'=>false,'conditions'=>array('City.id=User.city_id')),
						'State'=>array('foreignKey'=>false,'conditions'=>array('State.id=User.state_id')),
						'Country'=>array('foreignKey'=>false,'conditions'=>array('Country.id=User.country_id')),
						'Initial'=>array('foreignKey'=>false,'conditions'=>array('Initial.id=User.initial_id')),
				)),false);
		$doctorData = $this->Patient->find('all',array(
				'conditions'=>array('Patient.patient_id' => $personId)));
		$this->set('careTeam',$doctorData);
		//echo '<pre>';print_r($doctorData);exit;
	}

	public function getVitalSigns(){
		$this->uses = array('Note','Patient');
		$personId = $this->Session->read('username');
		//$personId = 'UHHO13C15009';
		//$patient_id=$this->Session->read('patientId');

		$this->Note->bindModel(array(
				'belongsTo' => array(
						'Patient'=>array('foreignKey'=>'patient_id')
				)),false);

		$vitalSigns = $this->Note->find('all',array('fields' => array('temp','bp','wt','ht','bmi','Patient.admission_id'),
				'conditions' => array('Note.patient_id'=>$this->Patient->find('list', array('conditions' => array('Patient.patient_id' => $personId))))));
		$this->set('vitalSigns',$vitalSigns);
		//echo '<pre>';print_r($vitalSigns);exit;
	}


	public function getProcedures(){
		$personId = $this->Session->read('username');
		$patient_id=$this->Session->read('patientId');
		$this->uses = array('Person','Patient','Consultant','User','LabManager','LaboratoryResult','RadiologyTestOrder','RadiologyReport','RadiologyResult','Radiology');
		//$personId = 'UHHO13C15009';
		if(!empty($personId)){

			$this->patient_info($patient_id);

			$this->LabManager->bindModel(array(
					'belongsTo' => array(
							'Laboratory'=>array('foreignKey'=>'laboratory_id','conditions'=>array('Laboratory.is_active'=>1)),
							'Patient'=>array('foreignKey'=>'patient_id')
					),
					'hasOne' => array( 'LaboratoryResult'=>array('foreignKey'=>'laboratory_test_order_id') ,
							'LaboratoryToken'=>array('foreignKey'=>'laboratory_test_order_id')
					)),false);

			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'fields'=>array('LaboratoryToken.lonic_code','LaboratoryToken.sct_concept_id','LaboratoryToken.laboratory_id','Patient.admission_id','LaboratoryResult.text','LaboratoryResult.result_publish_date','LaboratoryResult.confirm_result','LabManager.id','LabManager.create_time',
							'LabManager.patient_id','LabManager.order_id','Laboratory.id','Laboratory.name','LaboratoryToken.ac_id','LaboratoryToken.sp_id','LaboratoryToken.laboratory_id'),
					'conditions'=>array('LabManager.patient_id ' =>$this->Patient->find('list', array('conditions' => array('Patient.patient_id' => $personId), 'fields'=> array('id'))),'LabManager.is_deleted'=>0),
					'order' => array(
							'LabManager.id' => 'asc'
					),
					'group'=>'LabManager.id'
			);
			$testOrdered   = $this->paginate('LabManager');

			$this->set(array('testOrdered'=>$testOrdered));
			//$testOrdered = $this->Cipher->decrypt($testOrdered);
			//echo '<pre>';print_r($testOrdered);exit;

		}else{
			$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
			$this->redirect($this->referer());
		}
		$personId = $this->Session->read('username');
		$patient_id=$this->Session->read('patientId');
		$this->uses = array('Person','Patient','Consultant','User','RadioManager','RadiologyResult','RadiologyReport');
		if(!empty($patient_id)){
			$data1 = $this->RadiologyReport->find('all',array('fields'=>array('RadiologyReport.id','RadiologyReport.patient_id','RadiologyReport.file_name','RadiologyReport.description'),
					'conditions'=>array('RadiologyReport.patient_id'=>$patient_id)));

			for($a=0;$a<count($data1);$a++){

				$b[]='"'.$this->webroot.'uploads/radiology/'.$data1[$a][RadiologyReport][file_name].'"';
				$c[]='"'.$data1[$a]['RadiologyReport']['description'].'"';
			}

			$this->set('data1',$data1);
			$this->set('b',$b);
			$this->set('c',$c);

			//BOF referer link
			$sessionReturnString = $this->Session->read('radResultReturn') ;
			$currentReturnString = $this->params->query['return'] ;
			if(($currentReturnString!='') && ($currentReturnString != $sessionReturnString) ){
				$this->Session->write('radResultReturn',$currentReturnString);
			}
			//EOF referer link
			$this->patient_info($patient_id);

			$this->RadioManager->bindModel(array(
					'belongsTo' => array(
							'Radiology'=>array('type'=>'inner','foreignKey'=>'radiology_id','conditions'=>array('Radiology.is_active'=>1)),
							'Patient'=>array('foreignKey'=>'patient_id')
					),
					'hasOne' => array(
							'RadiologyResult'=>array('foreignKey'=>'radiology_test_order_id')
					)),false);
			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'fields'=>array('RadioManager.sct_concept_id','Patient.admission_id','RadiologyResult.note','RadiologyResult.id', 'RadiologyResult.result_publish_date','RadiologyResult.confirm_result','RadioManager.id','RadioManager.create_time','RadioManager.patient_id','RadioManager.order_id','Radiology.id','Radiology.name'),
					'conditions'=>array('RadioManager.patient_id'=>$this->Patient->find('list', array('conditions' => array('Patient.patient_id' => $personId), 'fields'=> array('id'))),'RadioManager.is_deleted'=>0),
					'order' => array(
							'RadioManager.id' => 'asc'
					),
					'group'=>'RadioManager.id'
			);
			$radTestOrdered   = $this->paginate('RadioManager');

			$this->set(array('radTestOrdered'=>$radTestOrdered));
			//echo '<pre>';print_r($radTestOrdered);exit;
		}else{
			$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
			$this->redirect($this->referer());
		}
	}

	public function getProblems(){
		$personId = $this->Session->read('username');
		$patient_id=$this->Session->read('patientId');
		//$personId = 'UHHO13C15009';
		$this->uses = array('NoteDiagnosis','Patient');
		$problems = $this->NoteDiagnosis->find('all',array('fields' => array('note_id','patient_id','icd_id','start_dt','end_dt','disease_status','created'),
				'conditions' => array('NoteDiagnosis.patient_id'=>$this->Patient->find('list', array('conditions' => array('Patient.patient_id' => $personId))))));
		//echo '<pre>';print_r($problems);exit;

		$host = "sandbox.e-imo.com";
		$port = "42011";
		$timeout = 15;  //timeout in seconds
		$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)
		or die("Unable to create socket\n");

		$result=socket_connect($socket, $host, $port);
		if ($result === false) {
			echo "socket_connect() failed.\nReason: ($result) " .
			socket_strerror(socket_last_error($socket)) . "\n";
		}

		foreach($problems as $key=>$disp){
			$msg_search = "detail^".$disp['NoteDiagnosis']['icd_id']."^1^e0695fe74f6466d0^" . "\r\n";
			if (!socket_write($socket, $msg_search, strlen($msg_search))) {
				echo socket_last_error($socket);
			}
			while ($bytes=socket_read($socket, 100000)) {
				if ($bytes === false) {
					echo
					socket_last_error($socket);
					break;
				}
				if (strpos($bytes, "\r\n") != false) break;
			}
				



			$xmlString="<items>".$bytes."</items>";
			$xmldata = simplexml_load_string($xmlString);
				
			$problems[$key]['NoteDiagnosis']['SnomedName'] = $xmldata->ICD9_SNOMEDCT_IMO->RECORD->FULLYSPECIFIEDNAME;
			$problems[$key]['NoteDiagnosis']['SnomedCode'] = $xmldata->ICD9_SNOMEDCT_IMO->RECORD->SCT_CONCEPT_ID;
				
		}//echo '<pre>';print_r($xmldata);exit;
		socket_close($socket);
		$this->set('problems',$problems);
	}

	public function getCarePlan(){
		$personId = $this->Session->read('username');
		$patient_id=$this->Session->read('patientId');
		//$personId = 'UHHO13C15009';
		$this->uses = array('Note','Patient');
		$this->Note->bindModel(array(
				'belongsTo' => array(
						'Patient'=>array('foreignKey'=>'patient_id')
				)),false);

		$carePlans = $this->Note->find('all',array('fields' => array('plan','Patient.admission_id'),
				'conditions' => array('Note.patient_id'=>$this->Patient->find('list', array('conditions' => array('Patient.patient_id' => $personId))))));
		$this->set('carePlans',$carePlans);
		//echo '<pre>';print_r($carePlans);exit;
	}

	//Inpatient Starts

	public function getEncounterInformation(){
		$personId = $this->Session->read('username');
		$patient_id=$this->Session->read('patientId');
		$this->uses = array('Person','Patient','Facility','Location','Country','State','City');


		$this->Patient->unbindModel(array('hasMany' => array('PharmacySalesBill', 'InventoryPharmacySalesReturn'),
				'belongsTo' => 'Person'));

		$this->Patient->bindModel(array(
				'belongsTo' => array(

						'Location'=>array('foreignKey'=>false, 'conditions'=>array('Location.id=Patient.location_id')),
						'City'=>array('foreignKey'=>false,'conditions'=>array('Location.city_id=City.id')),
						'State'=>array('foreignKey'=>false,'conditions'=>array('Location.state_id=State.id')),
						'Country'=>array('foreignKey'=>false,'conditions'=>array('Location.country_id=Country.id'))
				)),false);

		$encounters = $this->Patient->find('all',array('fields' => array('Location.address1','Location.address2','Location.zipcode','Country.name','State.name','City.name','Patient.location_id','Patient.patient_id','Patient.admission_id','Patient.discharge_date','Patient.form_received_on'),
				'conditions' => array('Patient.id'=>$this->Patient->find('list', array('conditions' => array('Patient.patient_id' => $personId))))));
		$this->set('encountersData',$encounters);
		//echo '<pre>';print_r($encounters);exit;
	}


	public function getCognitiveFunctions(){
		$personId = $this->Session->read('username');
		$patient_id=$this->Session->read('patientId');
		$this->uses = array('DischargeSummary','Patient','CognitiveFunction');
		$this->CognitiveFunction->bindModel(array(
				'belongsTo' => array(
						'Patient'=>array('foreignKey'=>'patient_id')
				)),false);

		$cogNitiveFunctions = $this->CognitiveFunction->find('all',array('fields' => array('CognitiveFunction.cog_name','CognitiveFunction.cog_date',
				'CognitiveFunction.cog_snomed_code','Patient.admission_id'),
				'conditions' => array('CognitiveFunction.patient_id'=>$this->Patient->find('list', array('conditions' => array('Patient.patient_id' => $personId))))));
		$this->set('cogNitiveFunctions',$cogNitiveFunctions);
		//echo '<pre>';print_r($cogNitiveFunctions);exit;

	}


	public function getEncounterDiagnosis(){
		$personId = $this->Session->read('username');
		$patient_id=$this->Session->read('patientId');
		$this->uses = array('NoteDiagnosis','Patient');
		//$personId = 'UHHO13C15009';

		$problems = $this->NoteDiagnosis->find('all',array('fields' => array('note_id','patient_id','icd_id','start_dt','end_dt','disease_status','created'),
				'conditions' => array('NoteDiagnosis.patient_id'=>$this->Patient->find('list', array('conditions' => array('Patient.patient_id' => $personId))))));


		$host = "sandbox.e-imo.com";
		$port = "42011";
		$timeout = 15;  //timeout in seconds
		$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)
		or die("Unable to create socket\n");

		$result=socket_connect($socket, $host, $port);
		if ($result === false) {
			echo "socket_connect() failed.\nReason: ($result) " .
			socket_strerror(socket_last_error($socket)) . "\n";
		}

		foreach($problems as $key=>$disp){
			$msg_search = "detail^".$disp['NoteDiagnosis']['icd_id']."^1^e0695fe74f6466d0^" . "\r\n";
			if (!socket_write($socket, $msg_search, strlen($msg_search))) {
				echo socket_last_error($socket);
			}
			while ($bytes=socket_read($socket, 100000)) {
				if ($bytes === false) {
					echo
					socket_last_error($socket);
					break;
				}
				if (strpos($bytes, "\r\n") != false) break;
			}
			
			$xmlString="<items>".$bytes."</items>";
			$xmldata = simplexml_load_string($xmlString);
				
			$problems[$key]['NoteDiagnosis']['SnomedName'] = $xmldata->ICD9_SNOMEDCT_IMO->RECORD->FULLYSPECIFIEDNAME;
			$problems[$key]['NoteDiagnosis']['SnomedCode'] = $xmldata->ICD9_SNOMEDCT_IMO->RECORD->SCT_CONCEPT_ID;
				
		}
		socket_close($socket);
		$this->set('encounterDiagnosis',$problems);
	}

	public function getDischargeInstruction(){
		$personId = $this->Session->read('username');
		$patient_id=$this->Session->read('patientId');
		$this->uses = array('DischargeSummary','Patient');
		$this->DischargeSummary->bindModel(array(
				'belongsTo' => array(
						'Patient'=>array('foreignKey'=>'patient_id')
				)),false);

		$dischargeInst = $this->DischargeSummary->find('all',array('fields' => array('DischargeSummary.care_plan','Patient.admission_id'),
				'conditions' => array('DischargeSummary.patient_id'=>$this->Patient->find('list', array('conditions' => array('Patient.patient_id' => $personId))))));
		$this->set('dischargeInst',$dischargeInst);
		//echo '<pre>';print_r($dischargeInst);exit;

	}

	public function getHospitalizationReason(){

		$personId = $this->Session->read('username');
		$patient_id=$this->Session->read('patientId');

		$this->uses = array('Diagnosis','Patient');

		$this->Diagnosis->bindModel(array(
				'belongsTo' => array(
						'Patient'=>array('foreignKey'=>'patient_id')
				)),false);



		$hospitalizationReason = $this->Diagnosis->find('all',array('fields' => array('final_diagnosis','Patient.admission_id'),
				'conditions' => array('Diagnosis.patient_id' =>$this->Patient->find('list', array('conditions' => array('Patient.patient_id' => $personId))))));
		$this->set('hospitalizationReason',$hospitalizationReason);


	}
	//-----------for view ccda--------
	public function view_consolidate($id=null){
		$this->layout = false;
		$this->uses =array('XmlNote');
		if($id)
		{
			$result = $this->XmlNote->find('first',array('fields'=>array('filename'),'order'=>array('XmlNote.id DESC'),'limit'=>1,'conditions'=>array('XmlNote.patient_id'=>$id)));

			$this->set(array('xml'=>$result['XmlNote']['filename']));

		}else{
			$this->Session->setFlash(__('Please try again'));
		}
	}

	//To compose ccda email for doctor and patient
	public function composeCcda($id=null,$recipientId=null,$noteId=null){  
		$this->uses =array('XmlNote','TransmittedCcda','Patient','Person','User','Consultant','ReferralToSpecialist');
		
		//BOF check if patient has ccda
		if(!$id) $this->redirect($this->referer()) ;
		
		if($this->params->query['returnUrl']=='compose'){
			$returnUrl = 'compose';
		}else{
			$returnUrl = 'patientList';
		} 
		
		if(!empty($this->params->query['referred_to'])){
			$refer=explode(',',$this->params->query['referred_to']);
			$toMail=$this->Consultant->find('all',array('fields'=>array('Consultant.first_name','Consultant.last_name','Consultant.email','Consultant.id'),'conditions'=>array('first_name '=>$refer)));
			$this->set('toMail',$toMail);	 
			$returnUrl = 'referral'; 
		} 

		$isXmlExist = $this->XmlNote->find('count',array('conditions'=>array('XmlNote.patient_id'=>$id)));
		if(!$isXmlExist && empty($this->request->data['XmlNote'])){ 
			$this->Patient->unBindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn'))); 
			$patient_data = $this->Patient->find('first',array('fields'=>array('Patient.patient_id'),
					'conditions'=>array('Patient.id'=>$id)));
			
			if(!empty($this->params->query['referred_to'])){
				$this->redirect(array('controller'=>'ccda','action'=>'index',$id,$patient_data['Patient']['patient_id'],"yes","yes","null",$returnUrl,'?'=>$this->params->query));  //generate ccda
			}else{
				$this->redirect(array('controller'=>'ccda','action'=>'index',$id,$patient_data['Patient']['patient_id'],"yes","yes","null",$returnUrl));  //generate ccda
			}
		}
		 
		//EOF check if patient has ccda 
		$this->layout = 'advance' ;
		$this->Patient->unBindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
				)),false);
		$patient_data = $this->Patient->find('first',array('fields'=>array('lookup_name','Person.age','Person.dob','Person.sex','Patient.age',),
				'conditions'=>array('Patient.id'=>$id)));
		$role = $this->Session->read('role');
		$this->set('role',$role);
		$expRecipient=explode('|',$recipientId); 
		$getEmails=$this->User->find('all',array('fields'=>array('User.email'),'conditions'=>array('User.id'=>$expRecipient)));
		$this->set('emailAddress',$getEmails); 
		$this->set('noteId',$this->params->query['noteId']);
		if(!empty($this->request->data['XmlNote']))
		{  	
			$this->request->data['XmlNote']['appointment_id']=$_SESSION['apptDoc'];
			if($this->data['XmlNote']['type']=='other'){
			
				$this->TransmittedCcda->insertTransmittedCcda($this->request->data);
				$errors = $this->TransmittedCcda->invalidFields();
				if(!empty($errors)) {
					$this->set("errors", $errors);
				} else {
					$this->Session->setFlash(__('Record saved successfully'),'default',array('class'=>'message'));
					if($this->params->query['returnUrl']=='compose'){
						if(empty($this->request->data['noteId'])){
							$noteId = $this->Session->read('myNoteId');
						}else{
							$noteId = $this->request->data['noteId'] ;
						}
						$this->redirect('/notes/soapNote/'.$this->request->data['XmlNote']['patient_id']."/".$noteId) ;
					}else{
						$this->redirect('/messages/ccdaMessage') ;
					}
				}
			}else if($this->data['XmlNote']['type']=='scnp'){
				$this->TransmittedCcda->insertTransmittedCcda($this->request->data);
				$errors = $this->TransmittedCcda->invalidFields();
				App::import('Vendor', 'PHPMailer', array('file' => 'phpmailer/class.phpmailer.php')); 
				$mail = new PHPMailer(); 
				$mail->IsSMTP();  // telling the class to use SMTP
				$mail->SMTPAuth   = Configure::read('SMTPAuth');
				$mail->Host     = Configure::read('Host'); // SMTP server
				$mail->Port = Configure::read('Port');
				$mail->SMTPSecure = Configure::read('SMTPSecure');
				$mail->SMTPDebug  = 0;
				//Ask for HTML-friendly debug output
				$mail->Debugoutput = Configure::read('Debugoutput');
				$mail->IsHTML(true);//pawan for html body 
				$mail->Username = Configure::read('Username');
				$mail->Password	=Configure::read('Password');
				$mail->AddAddress(trim($this->data['XmlNote']['to']));
				$mail->SetFrom(Configure::read('Username'),ucfirst($this->Session->read('Auth.User.first_name'))." ".ucfirst($this->Session->read('Auth.User.last_name')));
				$mail->AddReplyTo(Configure::read('Username'), 'DrmHope');
					
				$mail->Subject  = $this->data['XmlNote']['subject'] ;
				$mail->Body     = (trim($this->data['XmlNote']['message']))?$this->data['XmlNote']['message']:$this->data['XmlNote']['subject'];
				$mail->WordWrap = 50; 
				if(!empty($this->request->data['XmlNote']['patient_id'])){ 
					$send =  $mail->Send() ; 
					if(!$send) {
						$this->set("errors", $errors);
						echo 'Mailer error: ' . $mail->ErrorInfo;
						exit;
						$this->Session->setFlash(__('Unable to send mail'),'default',array('class'=>'error'));
						$this->redirect($this->referer()) ;
					} else {
						$this->TransmittedCcda->insertTransmittedCcda($this->request->data);
						$errors = $this->TransmittedCcda->invalidFields();
						$this->Session->setFlash(__('Ccda has been transmitted successfully'),'default',array('class'=>'message'));
						if($this->params->query['returnUrl']=='compose'){
							if(empty($this->request->data['noteId'])){
								$noteId = $this->Session->read('myNoteId');
							}else{
								$noteId = $this->request->data['noteId'] ;
							}
							$this->redirect('/notes/soapNote/'.$this->request->data['XmlNote']['patient_id']."/".$noteId) ; 
						}else{
							$this->redirect('/messages/ccdaMessage') ;
						}
					} 
				}else{
					$this->Session->setFlash(__('Please try again'),true,array('class'=>'error'));
					$this->redirect($this->referer()) ;
				}  
			}else if (!empty($this->data['XmlNote']['to']) && ($this->data['XmlNote']['subject'])) {
				App::import('Vendor', 'PHPMailer', array('file' => 'phpmailer/class.phpmailer.php'));
 
				$mail = new PHPMailer();
					
				$mail->IsSMTP();  // telling the class to use SMTP
				$mail->SMTPAuth   = true;
				$mail->Host     = Configure::read('Host'); // SMTP server
				$mail->Port = Configure::read('Port');
				$mail->SMTPSecure = Configure::read('SMTPSecure');
				$mail->SMTPDebug  = 0;
				//Ask for HTML-friendly debug output
				$mail->Debugoutput = 0;
				
				$mail->IsHTML(true);//pawan for html body 
				
				$mail->Username = Configure::read('Username');
				$mail->Password	=Configure::read('Password');
					
				$mail->AddAddress(trim($this->data['XmlNote']['to']));
				$mail->SetFrom(Configure::read('Username'), 'DrmHope');
				$mail->AddReplyTo(Configure::read('Username'), 'DrmHope');					
				$mail->Subject  = $this->data['XmlNote']['subject'] ;
				$mail->Body     = (trim($this->data['XmlNote']['message']))?$this->data['XmlNote']['message']:$this->data['XmlNote']['subject'];  
				$mail->WordWrap = 50;
				# echo '<pre>';print_r($this->request->data) ; exit;
				if(!empty($this->request->data['XmlNote']['patient_id'])){
					$result = $this->XmlNote->find('first',array('fields'=>array('e2_filename','patients_e2_filename'),'order'=>array('XmlNote.id DESC'),'limit'=>1,
							'conditions'=>array('XmlNote.patient_id'=>$this->request->data['XmlNote']['patient_id'])));
					
					$xmlName = (!empty($result['XmlNote']['e2_filename']))?$result['XmlNote']['e2_filename']:$result['XmlNote']['patients_e2_filename'] ;
					
					$sendingXml = $xmlName.".xml" ;
					 
					//temp attachment path
					
				    $path = "files/note_xml/".$sendingXml  ;
				    $this->request->data['XmlNote']['file_name']   = $sendingXml ;
				    
					if((!file_exists($path) || empty($result['XmlNote']['filename'])) && !empty($pathSimple)){ //refereal letter
						$this->Session->setFlash(__('Problem with attached file , Please try again'),true,array('class'=>'error')); 
						$this->redirect($this->referer()) ;
					}else{
						$mail->AddAttachment($path); 
						if(!empty($pathSimple)){
							$mail->AddAttachment($pathSimple);
						}
						$send =  $mail->Send() ;
						//echo "mail status.".$send ; 
						
						if(!$send) {
							$this->set("errors", $errors);
							echo 'Mailer error: ' . $mail->ErrorInfo; 
							$this->Session->setFlash(__('Unable to send mail'),'default',array('class'=>'error'));
							$this->redirect($this->referer()) ;
						} else {
							//$this->TransmittedCcda->insertTransmittedCcda($this->request->data);
							if($this->params->query['referred_to']){
								//if the referal is sent from patient list than to update the is_sent status of ReferralToSpecialist--Pooja
								//$consult=$this->Consultant->find('first',array('fields'=>array('first_name'),'conditions'=>array('first_name'=>$this->request->data['XmlNote']['to'])));
								//$referSpId=$this->ReferralToSpecialist->find('first',array('fields'=>array('ReferralToSpecialist.id'),'conditions'=>array('ReferralToSpecialist.id'=>$this->request->data['XmlNote']['physician_name'],'ReferralToSpecialist.patient_id'=>$id,'ReferralToSpecialist.is_sent=0')));
								
								if($this->request->data['XmlNote']['referralId']){			

									$this->TransmittedCcda->insertTransmittedCcda($this->request->data); // save mail 
									$tansmittedId=$this->TransmittedCcda->getLastInsertID();
									//update referral with last insert id 
									$saveData['ReferralToSpecialist']['id']=$this->request->data['XmlNote']['referralId'];
									$saveData['ReferralToSpecialist']['is_sent']='1'; //update with last insert ID to maintain relation between send referral 
									$saveData['ReferralToSpecialist']['transmitted_ccda_id']=$tansmittedId;
									$saveData['ReferralToSpecialist']['modify_time']=date('Y-m-d H:i:s');
									$this->ReferralToSpecialist->save($saveData);
									
									$this->Session->setFlash(__('Ccda has been transmitted successfully'),'default',array('class'=>'message'));								
									$this->redirect('/Appointments/appointments_management') ;								
								}else{
									$this->Session->setFlash(__('You may have alredy sent mail to this referal. Please try again with other referal'),true,array('class'=>'error'));
									return false;
								}
							}else{
								$this->TransmittedCcda->insertTransmittedCcda($this->request->data);
								$tansmittedId=$this->TransmittedCcda->getLastInsertID();
								
								//update referral with last insert id
								$saveData['ReferralToSpecialist']['id']=$this->request->data['XmlNote']['referralId'];
								$saveData['ReferralToSpecialist']['is_sent']='1'; //update with last insert ID to maintain relation between send referral
								$saveData['ReferralToSpecialist']['transmitted_ccda_id']=$tansmittedId;
								$saveData['ReferralToSpecialist']['create_time']=date('Y-m-d H:i:s');
								$saveData['ReferralToSpecialist']['patient_id']=$this->request->data['XmlNote']['patient_id'];
								$saveData['ReferralToSpecialist']['specialist_name']=$this->request->data['XmlNote']['physician_name'];
								$saveData['ReferralToSpecialist']['referred_to']=$this->request->data['XmlNote']['referral_to'];
								$saveData['ReferralToSpecialist']['reason_of_referral']=$this->request->data['XmlNote']['subject'];
								$this->ReferralToSpecialist->save($saveData);
								//EOF referral 
							}
							$errors = $this->TransmittedCcda->invalidFields();
							$this->Session->setFlash(__('Ccda has been transmitted successfully'),'default',array('class'=>'message'));
							if($this->params->query['returnUrl']=='compose'){
								if(empty($this->request->data['noteId'])){
									$noteId = $this->Session->read('myNoteId');
								}else{
									$noteId = $this->request->data['noteId'] ;
								}
								$this->redirect('/notes/soapNote/'.$this->request->data['XmlNote']['patient_id']."/".$noteId) ;
							}else if($this->params->query['returnUrl']=='patientList'){
								$this->redirect('/messages/patientList') ;
							}else{
								if(strtolower($role)==strtolower(Configure::read('patientLabel'))) {
									$this->redirect('/messages') ;
								}else{
									$this->redirect('/messages/ccdaMessage') ;
								}
							}
						}
					}
				}else{
					$this->Session->setFlash(__('Please try again'),true,array('class'=>'error'));
					$this->redirect($this->referer()) ;
				}  
			}else{
				$this->Session->setFlash(__('Please try again'),true,array('class'=>'error'));
			} 
			if($role == 'admin'){
				$this->redirect(array('action'=>'patientList'));
			}else{
				$this->redirect(array('action'=>'ccdaMessage'));
			}
		}
		
		if(!$id) $this->redirect($this->referer()) ;
		//for reminder email
		if(!empty($this->params->query['transmittedID'])){
			$prevData  = $this->TransmittedCcda->find('first',array('id'=>$this->params->query['transmittedID']));
			$this->set('transmittedData',$prevData);
		}
		//EOF reminder email
		$result = $this->XmlNote->find('first',array('fields'=>array('e2_filename','patients_e2_filename'),'order'=>array('XmlNote.id DESC'),'limit'=>1,
				'conditions'=>array('XmlNote.patient_id'=>$id)));
		 
		$xmlName = (!empty($result['XmlNote']['e2_filename']))?$result['XmlNote']['e2_filename']:$result['XmlNote']['patients_e2_filename'] ;
		$this->set(array('xml'=>$xmlName));
		$this->set(array('simpleLetter'=>$pathSimple));
		$session     = new cakeSession();
		$userid 	 = $session->read('userid') ;
		$locationId  = $session->read('locationid') ;
		$this->set('patient_name',$patient_data['Patient']['lookup_name']);
		/* //**************** Age Calculation
		if($patient_data['Person']['dob'] == '0000-00-00' || $patient_data['Person']['dob'] == ''){
			$age = "";
		}
		else{
			$date1 = new DateTime($patient_data['Person']['dob']);
			$date2 = new DateTime();
				
			$interval = $date1->diff($date2);
			$date1_explode = explode("-",$patient_data['Person']['dob']);
			$person_age_year =  $interval->y . " Year";
			$personn_age_month =  $interval->m . " Month";
			$person_age_day = $interval->d . " Day";
			//print_r($person_age_day);exit;
			if($person_age_year == 0 && $personn_age_month > 0){
				$age = $interval->m . " ".$monthString = ($interval->m > 1) ? "Months" : "Month";
			}
			else if($person_age_year == 0 && $personn_age_month == 0 && $person_age_day > -1){
				$age = $interval->d . " " + 1 . " ".$dayString = ($interval->d > 0) ? "Days" : "Day";
			}
			else if($person_age_year == 0 && $personn_age_month == 0 && $person_age_day == 0){
				$age = "";
			}
			else{
				$age = $interval->y . " ".$yearString = ($interval->y > 1) ? "Years" : "Year";
			}
		}
		$this->set('patient_age',$age);
		
		//*******************EOF AGE */
		$this->set('patient_age',$this->Person->getCurrentAge($patient_data['Person']['dob']));
		
		$this->set('patient_sex',$patient_data['Person']['sex']);
		$this->set('patient_id',$id);
		$this->set('user_id',$userid);
		$this->set('noteId',$noteId);
		$this->set('location_id',$locationId); 
		 
		if(!empty($recipientId) && $recipientId != 'null'){
			$pathSimple = "files/note_xml/".sample."_".myfile."_".$id.".html";
			if (!(file_exists("files/note_xml/".sample."_".myfile."_".$id.".html"))) {
				$this->Session->setFlash(__("Could not Attach file"),'default',array('class'=>'message'));
			}
			// exit;
			$my_file ="files".DS."note_xml".DS.sample."_".myfile."_".$id.".html";
			$handle = fopen($my_file, 'r');
			$dataFile = fread($handle,filesize($my_file));
			//$a=readfile('sample_myfile_'.$id.'.html','files/note_xml/');
			$this->set('dataFile',$dataFile);
			fclose($handle);
			//unlink(WWW_ROOT.$my_file);
			//@unlink(WWW_ROOT.$my_file); // this file should be deleted Aditya comment Before Demo
		
		}
		
	}
	/*
	 * Function for the order to referral/consult
	 */
	public function order_ref($patientId=null){
		if(!empty($patientId)){	
			if (!(file_exists("files/referal_letter/".referal."_".myfile."_".$patientId.".html"))) {					
			$totalDataToSend=$this->request->data['Note']['head'].'<p>'.$this->request->data['Note']['introduction'].$this->request->data['Note']['body'].$this->request->data['Note']['tail'].$this->request->data['Note']['Sincerely'].'<style>
			.classTr{
			background-color:#CCCCCC;
			}
			.classTd{
			color:red;
			}
			</style>';
			$myFileName = "files/referal_letter/".referal."_".myfile."_".$patientId.".html";
			
			$myFileHandle = fopen($myFileName, 'w') or die("can't open file");
			fwrite($myFileHandle, $totalDataToSend);
			fclose($myFileHandle);	
			//End 			
			}
			// exit;
			$pathSimple = "files/referal_letter/".referal."_".myfile."_".$patientId.".html";
			$my_file ="files".DS."referal_letter".DS.referal."_".myfile."_".$patientId.".html";
			$handle = fopen($my_file, 'r');
			$dataFile = fread($handle,filesize($my_file));
			//$a=readfile('sample_myfile_'.$id.'.html','files/note_xml/');
			echo $dataFile;
			//$this->set('dataFile',$dataFile);
			fclose($handle);
			unlink($my_file);
			//unlink(WWW_ROOT.$my_file);
			//@unlink(WWW_ROOT.$my_file); // this file should be deleted Aditya comment Before Demo
		
		}
		exit;
	}
	

	public function ccdaMessage($id=null){

		$session     	= new cakeSession();
		$userid 	 	= $session->read('userid') ;
		$locationId  	= $session->read('locationid') ;
		$this->uses 	= array('TransmittedCcda','XmlNote','Patient');
		$patient_id		= $this->Session->read('patientId');
		$this->set('patient_id',$patient_id);
		$this->set('id',$id);
		
		$role = $this->Session->read('role');
		$this->set('role',$role);
		
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array('TransmittedCcda.id' => 'DESC'),
				'conditions'=>array('TransmittedCcda.created_by'=>$userid, 'TransmittedCcda.location_id'=>$locationId)
		);
		$this->set("dataOfTransmitted",$this->paginate('TransmittedCcda'));
		//to display download ccda button for patient login
		if(strtolower($role)=='patient') {
			$id = $this->Session->read('patientId') ;
			$patientData = $this->Patient->find('first',array('admission_type','conditions'=>array('id'=>$id)));
			$result = $this->XmlNote->find('first',array( 'fields'=>array('filename','e2_filename','patients_e2_filename'),'order'=>array('XmlNote.id DESC'),'limit'=>1,
					'conditions'=>array('XmlNote.patient_id'=>$id)));
			 
			$this->set('hasXml',$result) ;
			$this->set('patient_type',$patientData['Patient']['admission_type']);
		} 
	 
	}

	public function patientList(){

		$this->uses =array('Patient','TransmittedCcda');

		$this->set('data','');
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array(
						'Patient.id' => 'asc'
				)
		);

		$role = $this->Session->read('role');

		$usertype=$this->Session->read('facility',$facility['Facility']['usertype']);

		/* if($usertype ==  'ambulatory'){
		 $this->params->query['type'] = 'OPD' ;
		}else{
		$this->params->query['type'] = 'IPD' ;
		} */


		//Search patient as per the url request
		if(!empty($this->params->query['type'])){
			if(strtolower($this->params->query['type'])=='emergency'){
				$search_key['Patient.admission_type'] = "IPD";
				$search_key['Patient.is_emergency'] = "1";
			}else if($this->params->query['type']=='IPD'){
				$search_key['Patient.admission_type'] = $this->params->query['type'];
				$search_key['Patient.is_emergency'] = "0";
			}else{
				$search_key['Patient.admission_type'] = $this->params->query['type'];
			}
		}
		if(!empty($this->params->query['dept_id'])){
			$search_key['Patient.department_id'] = $this->params->query['dept_id'];
		}
		/* if($this->params->query['patientstatus']=='discharged' || $this->params->query['patientstatus']=='processed') {
			$search_key['Patient.is_discharge'] = 1;//display only non-discharge patient
		} else {
			$search_key['Patient.is_discharge'] = 0;//display only non-discharge patient
		} */
		//EOF patient search as per category

		$search_key['Patient.is_deleted'] = 0;
 
		if(strtolower($role) == strtolower(Configure::read('adminLabel'))){
 
			$search_key['Patient.location_id']=$this->Session->read('locationid');

			$this->Patient->bindModel(array(
					'belongsTo' => array(
							'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id')),
							/*'Initial' =>array('foreignKey' => false,'conditions'=>array('User.initial_id=Initial.id' )),*/
							'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
							/*'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),*/
							'Location' =>array('foreignKey' => 'location_id'),
							'XmlNote'=>array('type'=>'inner','foreignKey'=> false,'conditions'=>array('XmlNote.patient_id=Patient.id'))
					)),false);
		}else if(strtolower($role)==strtolower(Configure::read('doctorLabel'))){
			 
			$search_key['Patient.location_id']=$this->Session->read('locationid');
			$search_key['Patient.doctor_id']=$this->Session->read('userid');
			$this->Patient->bindModel(array(
					'belongsTo' => array(
							'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id' )),
							/*'Initial' =>array('foreignKey' => false,'conditions'=>array('User.initial_id=Initial.id' )),*/
							'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
							/*'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),*/
							'XmlNote'=>array('foreignKey'=> false,'conditions'=>array('XmlNote.patient_id=Patient.id' ))
					)),false);
		}else{
			$search_key['Patient.location_id']=$this->Session->read('locationid');
			$this->Patient->bindModel(array(
					'belongsTo' => array(
							'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id' )),
							/*'Initial' =>array('foreignKey' => false,'conditions'=>array('User.initial_id=Initial.id' )),*/
							'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id' )),
							/*'PatientInitial' =>array('foreignKey' => false,'conditions'=>array('PatientInitial.id =Person.initial_id' )),*/
							'XmlNote'=>array('foreignKey'=> false,'conditions'=>array('XmlNote.patient_id=Patient.id' ))
					)),false);
		}

		 
			// If patient is OPD
			if(!empty($this->params->query)){
				$search_ele = $this->params->query  ;//make it get.
				/* if(!empty($search_ele['lookup_name'])){
					$search_key['Patient.lookup_name like '] = "%".trim($search_ele['lookup_name'])."%" ;
				} */
					if(!empty($search_ele['lookup_name'])){
						$search_ele['lookup_name'] = explode(" ",$search_ele['lookup_name']);
						if(count($search_ele['lookup_name']) > 1){
							$search_key['SOUNDEX(Person.first_name) like'] = "%".soundex(trim($search_ele['lookup_name'][0]))."%";
							$search_key['SOUNDEX(Person.last_name) like'] = "%".soundex(trim($search_ele['lookup_name'][1]))."%";
						}else if(count($search_ele['lookup_name)']) == 0){
							$search_key['OR'] = array(
									'SOUNDEX(Person.first_name)  like'  => "%".soundex(trim($search_ele['lookup_name'][0]))."%",
									'SOUNDEX(Person.last_name)   like'  => "%".soundex(trim($search_ele['lookup_name'][0]))."%");
						}
					}
					if(!empty($search_ele['patient_id'])){
					$search_key['Patient.patient_id like '] = "%".trim($search_ele['patient_id']) ;
				}if(!empty($search_ele['admission_id'])){
					$search_key['Patient.admission_id like '] = "%".trim($search_ele['admission_id']) ;
				}
				// Condition is here
				$conditions = $search_key;
			} 

		 
		// Paginate Data here

		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array('Patient.id' => 'desc'),
				'fields'=> array('Patient.form_received_on','Patient.form_received_on','Patient.discharge_date','CONCAT(Patient.lookup_name) as lookup_name',
						'Patient.id','Patient.patient_id','Patient.admission_id','Patient.mobile_phone','Patient.landline_phone','CONCAT(User.first_name,
						" ",User.last_name) as name',
						/*'User.initial_id',*/ 'Patient.create_time',/*'Initial.name',*/'XmlNote.filename'),
				'conditions'=>$conditions
		);

		$this->set('data',$this->paginate('Patient'));
	}

	
	public function openFancyBox($personId,$patientId){
		$this->layout = false;
		$this->uses = array('Person');		
		$personData = $this->Person->read(null,$personId);
		if($this->request->data){//echo '<pre>';print_r($this->request->data['Person']['patient_credentials_created_date']);exit;
					$date = $this->DateFormat->formatDate2STD($this->request->data['Person']['patient_credentials_created_date'],Configure::read('date_format_us'));
		if($this->request->data['declined']=='1'){
				$updateArray=array('Person.decline_portal'=>"'".date("Y-m-d H:i:s")."'");
				$res = $this->Person->updateAll($updateArray,array('Person.id'=>$personId));
				$this->set('status','no');
				$this->set('success','yes');				
		}else{
			if($this->request->data['declined']=='0'){
			if($this->createCredentials($this->request->data['Person']['patient_id'],$this->request->data['Person']['email_id'],$date)){
				//$this->Session->setFlash(__("Email sent successfully on ".$this->request->data['Person']['email_id']),'default',array('class'=>'message'));
				$mess = "Email sent successfully on ".$this->request->data['Person']['email_id'];
				$this->set('success','yes');
			}else{
				//$this->Session->setFlash(__("Could not send email"),'default',array('class'=>'message'));
				if($this->request->data['Person']['email_id']){
				$mess = "Could not send email ".$this->request->data['Person']['email_id'];
				}
				$this->set('success','yes');
			}			
			$this->set(array('status'=>'status','message'=>$mess,'username'=>$this->username,'password'=>$this->password));
			//$this->redirect(array('controller'=>'messages','action'=>'openFancyBox',$patientId));					
		}
		}
		}
		
		$this->set(array('person_data'=>$personData,'patient_id'=>$patientId));
	}
	
	public function changeLoginDate($patient_id){
		$this->layout = false;
		$this->uses = array('Person');
		if($this->request->data){
			$first_login_date= $this->DateFormat->formatDate2STD($this->request->data['Person']['first_login_date'],Configure::read('date_format_us'));
			$patient_id = $this->request->data['Person']['patient_id'];
			$this->Person->updateAll(
						array('first_login_date' => "'$first_login_date'"),array('Person.patient_uid'=>$patient_id)
				);
			$this->set('message','Login date updated successfully');
		}
		$this->set('patient_id',$patient_id);
	}
	
	public function hl7Mailbox(){
		
	}
	
	public function hl7Inbox(){
		
	}
	
	public function hl7Outbox(){
		
		$this->uses = array('LaboratoryTestOrder');
		$this->LaboratoryTestOrder->bindModel(array(
				'belongsTo' => array(
						'Laboratory'=>array('foreignKey'=>'laboratory_id','conditions'=>array('Laboratory.is_active'=>1,'Laboratory.location_id'=>$this->Session->read('locationid'))),
						'Patient'=>array('foreignKey'=>false,array('conditions'=>array('Patient.id = LaboratoryTestOrder.patient_id'))),
				),
				'hasOne' => array(
						'LaboratoryResult'=>array('foreignKey'=>'laboratory_test_order_id'),
						//		'SpecimenType'=>array('foreignKey'=>false,'conditions'=>array('SpecimenType.id'=>'LaboratoryToken.specimen_type_id')),
				),
				'hasMany' => array(
						'LaboratoryToken'=>array('foreignKey'=>'laboratory_test_order_id'),
						
				),false));
		
		
		$role = strtolower($this->Session->read('role'));
		if($role == Configure::read('doctorLabel')){
			$doctorId = $this->Session->read('userid');
			$cond = array('LaboratoryTestOrder.is_deleted'=>0,'LaboratoryTestOrder.doctor_id'=>$doctorId,'service_provider_id <>'=>'');
		}else{
			$doctorId = '';
			$cond =  array('LaboratoryTestOrder.is_deleted'=>0,'service_provider_id <>'=>'');
		}
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'fields'=>array('LaboratoryTestOrder.batch_identifier','LaboratoryResult.confirm_result','LaboratoryTestOrder.id','LaboratoryTestOrder.start_date',
						'LaboratoryTestOrder.lab_order','LaboratoryTestOrder.lab_order_date','LaboratoryTestOrder.order_id','Laboratory.id','Laboratory.name',
						'Laboratory.lonic_code','Patient.lookup_name','Patient.patient_id','LaboratoryTestOrder.service_provider_id','LaboratoryTestOrder.create_time'),
				'conditions'=>$cond,
				'order' => array(
						'LaboratoryTestOrder.name' => 'asc'
				),
				'group'=>array('LaboratoryTestOrder.order_id')
		);
		$testOrdereds   = $this->paginate('LaboratoryTestOrder');
		$this->set('testOrdereds',$testOrdereds);
		//echo '<pre>';print_r($testOrdered);exit;
	}
	
	public function hl7MessageEncorporation(){
		 
		$this->uses = array('Hl7Result');
		
		$get_Result=$this->Hl7Result->find('all'); 
		
		$this->set('get_Result',$get_Result);
	}
	
	
	public function viewHl7Result($id,$count){
		$this->set('id',$id);
			
		$this->set('count',$count);
		$this->uses=array('Patient','Hl7Result');
		$get_Result=$this->Hl7Result->find('all',array('conditions'=>array('Hl7Result.patient_uid'=>$id)));
		//echo '<pre>';print_r($get_Result);exit;
		$this->set(compact('get_Result'));
	}
	
	public function referalList($id=null){
		$this->layout=false;
		$this->uses=array('DoctorProfile','Department','User');
		$this->DoctorProfile->bindModel( array(
				'belongsTo' => array(
						'User'=>array('conditions'=>array('DoctorProfile.user_id=User.id'),'foreignKey'=>false)
				)
		));
		/* $this->Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn'))); */
		
		$this->patient_info($id); //app function for element
		//	$this->request->data['NewCropAllergies']['location_id']=$this->Session->read('locationid');
		$getDocDetails=$this->DoctorProfile->find('all',
				array('fields'=>array('DoctorProfile.id','DoctorProfile.doctor_name','DoctorProfile.specility_keyword','User.id','User.email'),'order'=>array('DoctorProfile.doctor_name ASC')));
		$this->set('listDoctor',$getDocDetails);
		$getDepartment=$this->Department->find('list',array('fields'=>array('id','name'),'conditions'=>array('location_id'=>$this->Session->read('locationid'),'is_active'=='1'),'order'=>array('name ASC')));
		$this->set('listDepartment',$getDepartment);
		$this->set('id',$id);
		
	}
   public function searchCateDoctor($CateName=null,$id=null){
   	$this->autoRender=false;
   	$this->uses=array('DoctorProfile','Department','User');
   	$getDocDetailsByCat=$this->DoctorProfile->find('all',
   			array('fields'=>array('DoctorProfile.id','DoctorProfile.doctor_name','DoctorProfile.specility_keyword','User.id','User.email'),'conditions'=>array('specility_keyword'=>$CateName)));
   		$this->set('listCat',$getDocDetailsByCat);
   		$this->set('id',$id);
  	 	echo $this->render('search_cate_doctor');
   	    exit;
   }
   public function searchByName($docName=null,$id=null){
   	$this->autoRender=false;
   	$this->uses=array('DoctorProfile','Department','User');
   	$getDocDetailsByName=$this->DoctorProfile->find('all',
   			array('fields'=>array('DoctorProfile.id','DoctorProfile.doctor_name','DoctorProfile.specility_keyword','User.id','User.email'),'conditions'=>array('doctor_name'=>$docName)));
   	$this->set('listCat',$getDocDetailsByName);
   	$this->set('id',$id);
   	echo $this->render('search_cate_doctor');
   	exit;
   }
	/* public function letterDetails($id=null,$recipientId=null){
		debug($id);
		debug($recipientId);
		$this->layout=false;
		$this->uses=array('NewCropPrescription','Note','NoteDiagnosis');
		$getDiagnosis=$this->Note->find('first',array('fields'=>array('temp','ht','wt','bmi','bp'),'conditions'=>array('patient_id'=>$id),'order'=>'create_time DESC'));
		debug($getDiagnosis);
		
		$getMedications=$this->NewCropPrescription->find('all',array('fields'=>array('description'),'conditions'=>array('patient_uniqueid'=>$id)));
		debug($getMedications);
		
		$getMedications=$this->NoteDiagnosis->find('all',array('fields'=>array('description'),'conditions'=>array('patient_uniqueid'=>$id)));
		debug($getMedications);
	} */
   
   
   //update notify status of sent emails
   function updateNotify(){
   	$this->autoRender = false ;
   	$this->layout = false ;
   	if($this->request->data){
   		$this->uses = array('Inbox') ;
   		$ids = explode(",",$this->request->data['ids']);
   		foreach ($ids as $key => $value){
   			$this->Inbox->updateAll(array('notify'=>'"yes"'),array('id'=>$value)) ;
   			$this->Inbox->id ='';
   		}
   	}
   }
   
   //decline to patient portal
   function declinePortal($personid){
   	$this->autoRender = false ;
   	$this->uses = array('Person') ;
   	$this->Person->updateAll(array('Person.decline_portal'=>'"yes"'),array('Person.id' => $personid));
   
   }
   
   // new ctp for compose box by swapnil
	public function compose_new($u_id=null,$id=null,$type=null){ //debug($this->request->data);exit;
		
		if($type=='alert'){
			$this->layout="advance_ajax";
			$this->set('type',$type);			
		}
		$this->set('u_id',$u_id);
		if(!empty($this->params->query['is_refill'])){
			$this->set('is_refill',$this->params->query['is_refill']);
		}
	
		$this->uses = array('User','Person','DoctorChamber','Patient','Message','Inbox','Outbox','Person'); 
		$this->Patient->unBindModel(array('hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')),false);
		$role = $this->Session->read('role') ;
		  
		
		if(empty($id) && (strtolower($role) != strtolower(Configure::read('doctorLabel')))){
			$getRecived=$this->Patient->find('first',array('fields'=>array('lookup_name','id','patient_id'),'conditions'=>array('id'=>$u_id)));
			$this->set('defaultSelection',$getRecived);		
		}else{ 
			$getRecived=$this->Patient->find('list',array('fields'=>array('person_id','lookup_name'),'conditions'=>array('doctor_id'=>$this->Session->read('userid')),'order'=>array('Patient.lookup_name')));
			$this->set('defaultSelection',$getRecived);
		} 
		if($this->Session->read('is_patient') == 1){
			$this->set('username',$this->Session->read('username'));
		}else{
			$this->set('messagePatientId',$this->Session->read('messagePatientId'));
		}
		$role = $this->Session->read('role');
		$this->set('role',strtolower($role));
		
		$users = $this->User->getUsersByRoleName(Configure::read('doctorLabel'));
		asort($users);
		$this->set('users',$users);
		if($this->request->data){  
			if(empty($this->request->data['Compose']['to_new'])){
				$this->Session->setFlash(__('Please Enter Recipient'),'default',array('class'=>'error'));
				$this->redirect($this->referer());
			}
			//debug($this->request->data);exit;
			
			if(!is_array($this->request->data['Compose']['to_new']))	//to convert into array format EOF Swapnil
			{
				$rec = $this->request->data['Compose']['to_new'];
				$to_new = explode(",",$rec);
				$this->request->data['Compose']['to_new'] = $to_new;
			}
			
			$this->request->data['Compose']['from_name'] = $this->Session->read('first_name'). ' '.$this->Session->read('last_name') ;				
			$this->request->data['Compose']['from'] = $this->Session->read('username');
			 
			$this->request->data['Compose']['created_by'] = $this->Session->read('userid');
			if(!empty($this->request->data['Compose']['send_date'])){
				$this->request->data['Compose']['create_time'] = $this->DateFormat->formatDate2STD($this->request->data["Compose"]['send_date'],Configure::read('date_format_us'));
			}else{
				$this->request->data['Compose']['create_time'] = $this->DateFormat->formatDate2STD(date('m-d-Y H:i:s'),Configure::read('date_format'));
			}
			$this->request->data['Compose']['message'] = $this->request->data['message_enc']; // swapping data from temp field to message field
			if($this->request->data['Compose']['is_ammendment'] == 1){
				$this->request->data['Compose']['subject'] = $this->request->data['Compose']['subject'];
			} 
			//debug($this->request->data['Compose']);exit;
			foreach($this->request->data['Compose']['to_new'] as $to){
				if($this->request->data['Compose']['is_patient'] == 0){ //logged in as non patient role
					if($this->request->data['Compose']['to_type']!= 'Staff' && $this->request->data['Compose']['to_type'] != 'Medics'){  
						$toUsername = $this->Person->getUserDetails($to);
						$this->request->data['Compose']['to'] = $toUsername['Person']['patient_uid'];
						$this->request->data['Compose']['to_name'] = $toUsername['Person']['first_name']. ' '.$toUsername['Person']['last_name'] ;
						$this->request->data['Compose']['reference_patient'] = $toUsername['Person']['patient_uid']; 
						
					}else{
						$toUsername = $this->User->getUserDetails($to);
						$this->request->data['Compose']['to'] = $toUsername['User']['username'];
						$this->request->data['Compose']['to_name'] = $toUsername['User']['first_name']. ' '.$toUsername['User']['last_name'] ;
						$this->request->data['Compose']['reference_patient'] =$this->request->data['Compose']['from'] ;									
					}
					
				}else if($this->request->data['Compose']['is_patient'] == 1){ //logged in as patient role
					
					$toUsername = $this->User->getUserDetails($to); 
					$this->request->data['Compose']['to'] = $toUsername['User']['username'];
					$this->request->data['Compose']['to_name'] = $toUsername['User']['first_name']. ' '.$toUsername['User']['last_name'] ;
					
					//check for doctor's schedule if doc is not available then send reply msg msg to patient
					//find patient id.
					$this->request->data['Compose']['reference_patient'] =$this->request->data['Compose']['from'] ; //set reference patient for patient role
					$getPatientID = $this->Patient->find('first',array('fields'=>array('lookup_name','id','patient_id'),'conditions'=>array('person_id'=>$this->request->data['Compose']['created_by'])));
					$getDocChambersDetails = $this->DoctorChamber->Find('first',array('conditions'=>array('doctor_id'=>$to,
							'DATE_FORMAT(DoctorChamber.starttime, "%Y-%m-%d") '=>date('Y-m-d',strtotime($this->request->data['Compose']['create_time']))),
							'fields'=>array('starttime','endtime')));
						
					$startTime = strtotime($this->DateFormat->formatDate2Local($getDocChambersDetails['DoctorChamber']['starttime'],'yyyy-mm-dd',true));
					$endTime   = strtotime($this->DateFormat->formatDate2Local($getDocChambersDetails['DoctorChamber']['endtime'],'yyyy-mm-dd',true));
					$patientRequestTime = strtotime($this->DateFormat->formatDate2Local($this->request->data['Compose']['create_time'],'yyyy-mm-dd',true));
					$date=$this->DateFormat->formatDate2Local($this->request->data['Compose']['create_time'],Configure::read('date_format'),true);	
					$data['scheduledate']=$date;
					$data['appointment_with']=$to;
					$data['schedule_starttime']=date('H:i:s');
					$data['schedule_endtime']=date('H:i:s');
					$isAppointmentOverlap = $this->ScheduleTime->CheckOverlapBlockTime($data);
					if(!empty($isAppointmentOverlap)){
						
						$this->User->bindModel(array(
								'hasOne' => array('DoctorProfile'=>array('foreignKey'=>'user_id'))));
						$details =  $this->User->find('all',array('fields'=>array('User.first_name','User.last_name','User.id','User.phone1','User.phone2','User.mobile'),'conditions'=>array('Role.name'=>Configure::read("doctorLabel"),
								'User.is_active'=>1,'DoctorProfile.is_deleted'=>0,'DoctorProfile.is_registrar'=>0, 'User.is_deleted'=>0,'User.location_id'=>$this->Session->read('locationid')),
								'order'=>array('User.first_name Asc')));
						$mailHtml= '<ul><h3>List of Doctors and their Contact Details</h3>';
						foreach($details as $doctor){
							if(!empty($doctor['User']['phone1'])){
								$phone=$doctor['User']['phone1'];
							}
							elseif(!empty($doctor['User']['phone2'])){
								$phone=$doctor['User']['phone1'];
							}
							elseif(!empty($doctor['User']['mobile'])){
								$phone=$doctor['User']['mobile'];
							}
							$mailHtml.='<li>'.$doctor['User']['first_name'].' '.$doctor['User']['last_name'] .' - '.$phone.'</li>';
						}
						$mailHtml.='</ul>';
						//send reply msg to patient that doctor is not available
						$replyPatient['from'] = $this->request->data['Compose']['to'];
						$replyPatient['to'] = $this->request->data['Compose']['from'];
						$replyPatient['from_name'] = $this->request->data['Compose']['to_name'];
						$replyPatient['to_name'] =  $this->request->data['Compose']['from_name'];
						$replyPatient['subject'] = "Auto reply";
						$replyPatient['type'] = "Normal";
						$replyPatient['message'] = $this->GibberishAES->enc("Auto reply test message".$mailHtml,Configure::read('hashKey'));
						$replyPatient['reference_patient'] = $this->request->data['Compose']['reference_patient'];
						$replyPatient['create_time'] = $this->request->data['Compose']['create_time'] ;
						$replyPatient['is_patient'] = '1';
						$is_refill['is_refill'] =  $this->request->data['Compose']['is_refill'] ;
						$this->Inbox->Save($replyPatient);
						$this->Inbox->id='';
					} //EOF doc check
				}
				if(!empty($this->request->data['ammendment_status'])){
					$this->request->data['Compose']['ammendment_status']= $this->request->data['ammendment_status'] ;
				}
				if($this->Inbox->Save($this->request->data['Compose'])){
					if($this->Outbox->Save($this->request->data['Compose'])){
						$this->Inbox->id='';
						$this->Outbox->id='';
						$this->Session->setFlash(__('Your Message has been sent successfully'),'default',array('class'=>'message'));
					} 
				}
			}
			//To manage critical alerts first send mail to nurse
			if($type=='alert'){
				$this->uses=array('Patient');
				if($u_id){
					$this->Patient->updateAll(array('Patient.is_dr_chk' => 1), array('Patient.id' => $u_id));
				}
				$this->redirect(array("controller" => "Appointments", "action" => "appointments_management", "admin" => false));
			}else{
			$this->redirect(array("controller" => "messages", "action" => "inbox", "admin" => false)); 
			}
		}
		
		//BOF forward action 
		if($this->params->query['action']=='outbox_forward'){
			if(empty($this->params->query['messageID'])){
				$this->redirect($this->referer());
			}
			$outbox =  $this->Outbox->find('first',array('conditions'=>array('id'=>$this->params->query['messageID']))); 
			$outbox['Outbox']['message'] = $this->GibberishAES->dec($outbox['Outbox']['message'],Configure::read('hashKey')) ;
			$outbox['Compose'] = $outbox['Outbox'] ;   
			$this->data = $outbox;
		}else if($this->params->query['action']=='inbox_forward'){
			if(empty($this->params->query['messageID'])){
				$this->redirect($this->referer());
			}
			$inbox =  $this->Inbox->find('first',array('conditions'=>array('id'=>$this->params->query['messageID'])));
			$inbox['Inbox']['message'] = $this->GibberishAES->dec($inbox['Inbox']['message'],Configure::read('hashKey')) ;
			$inbox['Compose'] = $inbox['Inbox'] ;
			
			if(!empty($inbox['Inbox']['is_refill'])){
				$this->uses = array('Note','NewCropPrescription','NewCropAllergies','NoteDiagnosis','Recipient','Patient','User','NoteTemplate','BmiResult');
				$this->BmiResult->bindModel(array('belongsTo'=>array(
						'BmiBpResult'=>array('foreignKey'=>false,'conditions'=>array('BmiResult.id=BmiBpResult.bmi_result_id')))));
				$vitals=$this->BmiResult->find('first',array('fields'=>array('BmiResult.id','BmiResult.height_result','BmiResult.weight_result',
				'BmiResult.bmi','BmiResult.temperature','BmiResult.myoption','BmiResult.temp_source','BmiResult.temperature1','BmiResult.myoption1','BmiResult.temp_source1'
				,'BmiResult.temperature2','BmiResult.myoption2','BmiResult.temp_source2','BmiBpResult.systolic','BmiBpResult.systolic1',
				'BmiBpResult.systolic2','BmiBpResult.diastolic','BmiBpResult.diastolic1','BmiBpResult.diastolic2'),
				'conditions'=>array('BmiResult.patient_id'=>$inbox['Inbox']['is_refill']),'group'=>'BmiResult.patient_id desc'));
				$this->set('vitals',$vitals);
				
				$diagnosis=$this->NoteDiagnosis->find('all',array('fields'=>array('diagnoses_name','start_dt','end_dt'),'conditions'=>array('NoteDiagnosis.patient_id'=>$inbox['Inbox']['is_refill'])));
				$this->set('diagnosis',$diagnosis);
				$personId=$this->Patient->find('first',array('fields'=>array('Patient.person_id'),'conditions'=>array('Patient.id'=>$inbox['Inbox']['is_refill'])));
				$getEncounterID=$this->Note->encounterHandler($patientId,$personId['Patient']['person_id']);
				$getAllegy=$this->Note->getAllergy($getEncounterID);
				$this->set('allergy',$getAllegy);
				
				if(count($getEncounterID)=='1'){
					$getEncounterID=$getEncounterID[0];
				}

				$this->NewCropPrescription->bindModel(array(
						'belongsTo' => array(
								'VaccineDrug' =>array('foreignKey' => false,'conditions'=>array('VaccineDrug.MEDID=NewCropPrescription.drug_id')),
						)));

				$getMedicationRecords=$this->NewCropPrescription->find('all',array('fields'=>array('NewCropPrescription.*','VaccineDrug.MEDID'),'conditions'=>
						array('patient_id'=>$personId['Patient']['person_id'],'patient_uniqueid'=>$getEncounterID,'archive'=>'N')));
				//$medication=$this->NewCropPrescription->find('all',array('fields'=>array('description','date_of_prescription','end_date'),'conditions'=>array('NewCropPrescription.patient_uniqueid'=>$inbox['Inbox']['is_refill'])));
				$this->set('medication',$getMedicationRecords);
				
				$this->Patient->bindModel(array('belongsTo'=>array(
						'Person'=>array('foreignKey'=>false,'conditions'=>array('Patient.person_id=Person.id')))));
				$demographics=$this->Patient->find('first',array('fields'=>array('Patient.lookup_name','Person.dob','Person.sex','Person.age'),'conditions'=>array('Patient.id'=>$inbox['Inbox']['is_refill'])));
				$this->set('demographics',$demographics);
			}
			
			$inbox['Inbox']['to_type']='';
			$inbox['Compose']['to_type']='';
			$this->data = $inbox; 			
			$this->set('mailAction','forward') ;
		}
		
		
		else if($this->params->query['action']=='reply'){
			if(empty($this->params->query['messageID'])){
				$this->redirect($this->referer());
			}
			$inbox =  $this->Inbox->find('first',array('conditions'=>array('id'=>$this->params->query['messageID']))); 
			//debug($inbox);
			//$inbox['Compose'] = $inbox['Inbox'] ;
			
			
			
			$names = explode(" ",$inbox['Inbox']['from_name']);
			$first_name = $names[0];
			$last_name = $names[1];
			
			$inbox['Compose']['subject'] = $inbox['Inbox']['subject'];
			$inbox['Compose']['is_ammendment'] = $inbox['Inbox']['is_ammendment'];
				 
			if($inbox['Inbox']['to_type'] == 'Patients' || $inbox['Inbox']['to_type'] == 'Patient'){ //if rcvr is patient
				$users = $this->User->find('first',array('conditions' => array('User.username' => $inbox['Inbox']['from']),'fields'=>array('id','username','first_name','last_name')));
				$users = $users['User'];
				 
				$inbox['Compose']['to_type'] = $inbox['Inbox']['to_type'];
				$this->set('toType','Medics') ;
			}else{//rcvr is system user 
				if($inbox['Inbox']['is_patient'] == 1){ //mail sent by patient
					$users = $this->Person->find('first',array('conditions' => array('Person.patient_uid' => $inbox['Inbox']['from']),'fields'=>array('id','first_name','last_name')));
					$users = $users['Person']; 
					$inbox['Compose']['to_type'] = 'Patient';
					//$inbox['Inbox']['to_type'] = 'Patient' ;
					$this->set('toType','Patient') ;
				}else{ //by system user
					$users = $this->User->find('first',array('conditions' => array('User.username' => $inbox['Inbox']['from']),
						'fields'=>array('id','username','first_name','last_name')));
					$users = $users['User'];
					$inbox['Compose']['to_type'] = 'Medics';
					$inbox['Inbox']['to_type'] = 'Medics' ; //setu p form data to medics by default
					$this->set('toType','Medics') ;
					 
				}
			}
		
			
			
		/*	if($inbox['Inbox']['is_patient'] == 0 || empty($inbox['Inbox']['is_patient'])){ //logged in as non patient role
					if($inbox['Inbox']['to_type'] == 'Patient'){
						$users = $this->User->find('first',array('conditions' => array('User.username' => $inbox['Inbox']['from']),'fields'=>array('id','username','first_name','last_name')));
						$users = $users['User'];
						echo 'medics n pcp'  ;
					}else  if($inbox['Inbox']['to_type'] == 'Patient'){
						$users = $this->User->find('first',array('conditions' => array('User.username' => $inbox['Inbox']['from']),'fields'=>array('id','username','first_name','last_name')));
						$users = $users['User'];
						echo 'medics n pcp'  ;
					}else{
						$users = $this->Person->find('first',array('conditions' => array('Person.patient_uid' => $inbox['Inbox']['to']),'fields'=>array('id','first_name','last_name')));
						$users = $users['Person']; 
						echo 'patients';								
					} 
				}else if($inbox['Inbox']['is_patient'] == 1){ //logged in as patient role 
						/*$users = $this->User->find('first',array('conditions' => array('User.username' => $inbox['Inbox']['to']),'fields'=>array('id','username','first_name','last_name')));
						$users = $users['User'];*/
					//if($inbox['Inbox']['to_type']!= 'Staff' && $inbox['Inbox']['to_type'] != 'Medics'){  
						/*$users = $this->Person->find('first',array('conditions' => array('Person.patient_uid' => $inbox['Inbox']['from']),'fields'=>array('id','first_name','last_name')));
						$users = $users['Person']; 
					
				
			/*if($inbox['Inbox']['is_patient']==0 || empty($inbox['Inbox']['is_patient'])) //if msg is sent by non patient role
			{
				if($inbox['Inbox']['to_type'] == 'Patient' && $inbox['Inbox']['to_type'] == 'Medics') 
				{ 
					//$users = $this->User->find('first',array('conditions' => array('User.first_name' => $first_name,'User.last_name'=>$last_name),'fields'=>array('id','username','first_name','last_name')));
					$users = $this->User->find('first',array('conditions' => array('User.username' => $inbox['Inbox']['to']),'fields'=>array('id','username','first_name','last_name')));
					$users = $users['User'];
				}
				else 
				{
					$users = $this->Person->find('first',array('conditions' => array('Person.patient_uid' => $inbox['Inbox']['to']),'fields'=>array('id','first_name','last_name')));
					debug($users);
					$users = $users['Person']; 
				}
			}
			else if($inbox['Inbox']['is_patient']==1)
			{
				$inbox['Compose']['to_type'] = "Patient";
				$users = $this->Person->find('first',array('conditions' => array('Person.patient_uid' => $inbox['Inbox']['from']),'fields'=>array('id','first_name','last_name')));
				$users = $users['Person'];
				//$users = $this->User->find('first',array('conditions' => array('User.username' => $inbox['Inbox']['to']),'fields'=>array('id','username','first_name','last_name')));
				//$users = $users['User']; 
			}*/
			
			$this->set("users",$users);
			$this->set("is_reply","reply");		//this is set to remove the recipient autocomplete fields
			$this->data = $inbox; 

		}
		 
	}
	
	public function getUsersDetails($type='medics')
	{
		$this->uses = array('User','Person');
		
		if(!empty($this->request->query)){
			$q = $this->request->query['q'];
		}
		//array('Medics'=>'Provider','Patient'=>'Patient','Staff'=>'Staff');
		if($type == "Medics"){
			$users = $this->User->getDoctorsByKeyword($q);
		}else if($type == "Patient"){
			$users = $this->Person->getAllPatientsByKeyword($q);
		}else if($type == "Staff"){
			$users = $this->User->getUserStaffByKeyword($q);
		}else{
			$users = $this->User->getUsers();
		}
		$this->layout = false ;
		$this->autoRender = false ;
		foreach($users as $key=>$value){
			if(!empty($value))
			$newArray[] = array('name'=>$value,'id'=>$key) ;  
		}
		return json_encode($newArray);
		exit;
	}
	
	
	public function ajax_inbox()
	{
		$this->layout = false;
		$this->layout = "ajax";
		$this->autoRender = false;
		$this->inbox();
		$this->render("ajax_inbox",false);
	}
	
	public function ajax_outbox()
	{
		$this->layout = false;
		$this->layout = "ajax";
		$this->autoRender = false;
		$this->outbox();
		$this->render("ajax_outbox",false);
	}
	
	public function delete_inbox()
	{
		$this->layout = "ajax";
		$this->uses = array('Inbox');
		foreach($this->request->query['data']['message'] as $key => $value)
		{
			if($value==1)
			{
				$this->Inbox->delete($key);	//$key holds messageId to delete the message
				$this->Inbox->id = '' ;
			}
		}
		$this->inbox();
		$this->render("ajax_inbox",false);
	}
	
	public function delete_outbox()
	{
		$this->layout = "ajax";
	    $this->uses = array('Outbox');
		foreach($this->request->query['data']['messageId'] as $key => $value)
		{
			if($value==1)
			{
				$this->Outbox->delete($key);
				$this->Outbox->id = '' ;
			}
		}
		$this->outbox();
		$this->render("ajax_outbox",false);
	}
	
	
	
	public function conversation($patient_id=null) //from power note link
	{
		$this->uses = array('Inbox','Patient');
		$this->layout = "advance_ajax";
		$users = $this->Patient->find('first',array('conditions' => array('Patient.id' => $patient_id)));
		$from = $this->Session->read('username');//logined user
		$to = $users['Patient']['patient_id'];//patient Uid
		
		$message  = $this->Inbox->find('all',array('conditions'=>array(
														'OR'=>array(
																	array('Inbox.to'=>$to,'Inbox.from'=>$from),
																	array('Inbox.to'=>$from,'Inbox.from'=>$to)
																	)
															),
													'order'=>array('Inbox.id'=>"DESC")
									));
		
		$this->set('messages',$message);
		$this->set('to',$to);
		$this->set('from',$from);
	} 
   
	
	public function openReferalOutboxMessage(){
		if(isset($this->request->data['messageId']) && !empty($this->request->data['messageId'])){
			$this->uses = array('TransmittedCcda');
	
			$message = $this->TransmittedCcda->find('first',array('conditions'=>array('TransmittedCcda.id'=>$this->request->data['messageId'])));
			$message['TransmittedCcda']['message'] = strip_tags($message['TransmittedCcda']['message'],'<p><table></table><tr></tr><td></td><style></style><div></div>');
			echo json_encode($message);
			exit;
		}
	}
	/**
	 * @author Mahalaxmi
	 * For Send SMS From Hope2Sms
	 * @param $patientId integer
	 *
	 */
	public function hopeTwoSms(){
		$this->layout="advance";
		$this->uses = array('Patient','TemplateSms','Consultant','CorporateSublocation','GroupSms');
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id','NOT'=>array('Person.mobile'=>null))),
						)));
		$getPatientData = $this->Patient->find('all',array('fields'=>array('Patient.id','Patient.lookup_name','Person.mobile'),'conditions'=>array('Patient.is_deleted'=>0,'Patient.is_discharge'=>0)));
		$this->set(array('getPatientData'=>$getPatientData));
		
		$this->Consultant->virtualFields = array(
				'full_name' => 'CONCAT(Consultant.first_name, " ", Consultant.last_name)'
		);
		$doctorlist= $this->Consultant->find('list', array('fields'=> array('id', 'full_name'),
				'conditions'=>array('Consultant.is_deleted' => 0,'Consultant.location_id' => $this->Session->read('locationid')),'order'=>array('Consultant.id')));
		
		$mergeArray = array('All'=>'All')+$doctorlist;
		$this->set('doctorlist',$mergeArray);
		$corporatesublocations=$this->CorporateSublocation->find('list',array(
						'fields' => array('CorporateSublocation.id','CorporateSublocation.name'), 
						'conditions'=> array('CorporateSublocation.is_deleted' => 0),'order'=>array('CorporateSublocation.name')));
		//debug($corporatesublocations);
		$corporateSub=array();
		foreach($corporatesublocations as $key=>$corporatesublocationss){
			$corporateSub['subLoc_'.$key] = $corporatesublocationss;
		}
		$getGrpList=$this->GroupSms->findGroupList();
		$grpArr=array();
		foreach($getGrpList as $keys=>$getGrpLists){
			$grpArr['grp_'.$keys] = $getGrpLists;
		}		
		$mergeBothArray = array_merge($corporateSub,$grpArr,array('withoutsublocation'=>'Without Sponsors'));	
		//$mergeBothArray = $corporateSub+$grpArr;			
		asort($mergeBothArray);
		
		$this->set('corporatesublocations',$mergeBothArray);
		
		$templateSmsData = $this->TemplateSms->findListArr();
		$this->set(array('templateSmsData'=>$templateSmsData));
		
	}
	/**
	 * @author Mahalaxmi
	 * For Save template SMS From Hope2Sms
	 * @param  integer
	 *
	 */
	public function saveTemplateSms(){		
		$this->autoRender = false;
		$this->Layout = 'ajax';
		$this->uses = array('Patient','TemplateSms');
		$smsaddArr['sms']=$this->request->data['msgTxt'];		
		$smsaddArr['created_by']=$this->Session->read('userid');
		$smsaddArr['create_time']=date('Y-m-d H:i:s');
		$this->TemplateSms->save($smsaddArr);
		$this->TemplateSms->id="";
		//for SMS List After saving message its display on left div
		$templateSmsData=$this->TemplateSms->findListArr();
		$obj = (object) $templateSmsData ;						 
		echo json_encode($obj);exit;
		//for SMS List After saving message its display on left div
	}
	/**
	 * @author Mahalaxmi
	 * For Send SMS From Hope2Sms
	 * @param $patientId integer
	 *
	 */
	public function sendToSmsMultipleDoctor(){
		//Configure::write('debug',2) ;
		$this->uses=array('User','Note','TemplateSms','Consultant','Message','ContactSms','Configuration');
		$this->autoRender = false;
		$this->Layout = 'ajax';	
		$doctorIdMultiple=$this->request->data['chk1Array'];
		if(empty($this->request->data['mobile'])){
			$getDoctorIdSerialize=serialize($this->request->data['chk1Array']);
		}else{
			$getDoctorIdSerialize=$this->request->data['mobile'];
		}
	
		$smsaddArr['sms']=$this->request->data['msgTxt'];
		$smsaddArr['patient_id']=$getDoctorIdSerialize;
		if(empty($this->request->data['smsId'])){
			$smsaddArr['created_by']=$this->Session->read('userid');
			$smsaddArr['create_time']=date('Y-m-d H:i:s');			
		}else{
			$smsaddArr['modify_by']=$this->Session->read('userid');
			$smsaddArr['modified_time']=date('Y-m-d H:i:s');
			$smsaddArr['id']=$this->request->data['smsId'];
		}
		
		$this->TemplateSms->save($smsaddArr);
		
		$getID= $this->TemplateSms->getLastInsertID();
		
		//$this->TemplateSms->id="";
		if(empty($getID))
			$getID=$this->request->data['smsId'];
		/******BOF-Mahalaxmi-After patient reg to  get sms alert for Patient......  ***/
		
		$smsActive=$this->Configuration->getConfigSmsValue('Hope2Sms');	 		
		
		if($smsActive){					
			$msgText= str_replace ('&','and',$this->request->data['msgTxt']);
			$msgText= str_replace ('#','',$this->request->data['msgTxt']);
			if(empty($this->request->data['mobile'])){

			$getDocIDS=explode(",",$doctorIdMultiple);			
			$getDocIDS=array_filter($getDocIDS);		
			
			foreach($getDocIDS as $getDocIDSs){
					$getTextName=explode("-",$getDocIDSs);
					if($getTextName[0]=='group'){
						$flagForDiff=false;
						$getGroupIds[]=$getTextName[1];
					}else if($getTextName[0]=='consultant'){
						$flagForDiff=true;
						$getConsultantIds[]=$getTextName[1];
					}
			}
				
			
			//if($flagForDiff){				
			//For multiple mobile nos.
			//$getConsultantIds=array_unique($getConsultantIds);
			$getConsltantDetails=$this->Consultant->findConsltantDetails($getConsultantIds);
			
			$ret1='';
			foreach($getConsltantDetails as $getConsltantDetailss){
				$showSmsTextConsultant= sprintf(Configure::read('hopeTwoSMS'),$msgText);				
				$ret1 = $this->Message->sendToSms($showSmsTextConsultant,$getConsltantDetailss['Consultant']['mobile']); //For send text respective mobile nos. 
				
			
				if(trim($ret1)==Configure::read('sms_confirmation')){	
				$getFullConsultantName=$getConsltantDetailss['Consultant']['first_name']." ".$getConsltantDetailss['Consultant']['last_name'];
				$showSmsTextReturntoOwner= sprintf(Configure::read('hopeTwoSMSReturnToOwnerForMultiple'),$getFullConsultantName,$getConsltantDetailss['Consultant']['mobile'],$msgText);
				$this->Message->sendToSms($showSmsTextReturntoOwner,Configure::read('hopeTwoSmsManageNo')); //For send text respective mobile nos.
				}
					
			}
			
			$getGroupIdsDetails=$this->ContactSms->findContactAllByIds($getGroupIds);				
				
			$ret2='';
			foreach($getGroupIdsDetails as $getGroupIdsDetailss){
					$showSmsText= sprintf(Configure::read('hopeTwoSMS'),$msgText);						
					$ret2 = $this->Message->sendToSms($showSmsText,$getGroupIdsDetailss['ContactSms']['mobile']); //For send text respective mobile nos. 					
			
				if(trim($ret2)==Configure::read('sms_confirmation')){	
				//$getFullConsultantName=$getGroupIdsDetails['ContactSms']['name'];
				$showSmsTextReturntoOwnerGrp= sprintf(Configure::read('hopeTwoSMSReturnToOwnerForMultiple'),$getGroupIdsDetailss['ContactSms']['name'],$getGroupIdsDetailss['ContactSms']['mobile'],$msgText);						
				$this->Message->sendToSms($showSmsTextReturntoOwnerGrp,$getGroupIdsDetailss['GroupSms']['manager_mobile_no']); //For send text respective mobile nos.
				}					
			}			
			//$getFinalMobileNos=implode(',',$getMobileNosArr);	
			}else{
				//Configure::write('debug',2) ;
					$getFinalMobileNos=$this->request->data['mobile']; //For single mobile Nos.
					$showSmsText= sprintf(Configure::read('hopeTwoSMS'),$msgText);			
					$ret = $this->Message->sendToSms($showSmsText,$getFinalMobileNos); //For send text respective mobile nos. 
				
					if(trim($ret)==Configure::read('sms_confirmation')){	
						$showSmsTextReturntoOwner= sprintf(Configure::read('hopeTwoSMSReturnToOwnerForSingle'),$getFinalMobileNos,$msgText);		
						//debug($showSmsTextReturntoOwner);
						
						$getMobileNoONMe=$this->Message->sendToSms($showSmsTextReturntoOwner,Configure::read('hopeTwoSmsManageNo')); //For send text respective mobile nos.						
					}
			}
			
		}
		//For div leftside of Dashboard
		$templateSmsData=$this->TemplateSms->findListArr();
		$obj = (object) $templateSmsData ;						 
		echo json_encode($obj);exit;		
		/******EOF-Mahalaxmi-After patient reg to  get sms alert for Patient Relative......  ***/
	}
	
	
	public function sendToSmsMultiplePatient($chkArray=null,$textMsg=null,$mobile=null,$smsId=null){
		$this->loadModel('Patient');
		$this->uses=array('User','Note','TemplateSms');
		$this->autoRender = false;
		$this->Layout = 'ajax';
	
		if(empty($mobile)){
			$getPatientIdSerialize=serialize($chkArray);
		}else{
			$getPatientIdSerialize=$mobile;
		}
		$smsaddArr['sms']=$textMsg;
		$smsaddArr['patient_id']=$getPatientIdSerialize;
		if(empty($this->request->data['smsId'])){
			$smsaddArr['created_by']=$this->Session->read('userid');
			$smsaddArr['create_time']=date('Y-m-d H:i:s');
		}else{
			$smsaddArr['modify_by']=$this->Session->read('userid');
			$smsaddArr['modified_time']=date('Y-m-d H:i:s');
			$smsaddArr['id']=$smsId;
		}
	
		$this->TemplateSms->save($smsaddArr);
		$this->TemplateSms->id="";
		
		$getLastInsId=$this->TemplateSms->getLastInsertID();
		if(empty($getLastInsId))
			$getLastInsId=$smsId;
		/******BOF-Mahalaxmi-After patient reg to  get sms alert for Patient......  ***/
		$getEnableFeatureChk=$this->Session->read('sms_feature_chk');
		//if($getEnableFeatureChk){
			if(empty($mobile)){
				$getResult=$this->Patient->sendToSmsMultiplePatient($getLastInsId,'FestivalSms');
			}else{
				$getResult=$this->Patient->sendToSmsSinglePerson($getLastInsId,$mobile,'singleMoNo');
			}
		//}
	debug($getResult);exit;
		/*BOF-Sending Mail- How much Patients got SMS FOR Confirmation Purpose*/
		if(!empty($getResult)){
			$userfullname = $this->User->find('first', array('fields'=> array('User.first_name','User.last_name','User.username'),
					'conditions'=>array('User.is_deleted'=>'0','User.id'=>$this->Session->read('userid'))));
			//username
			$mailData['Patient']=array("patient_id"=>$userfullname["User"]["username"],"lookup_name"=>$userfullname["User"]["first_name"]." ".$userfullname["User"]["last_name"]);
			$msgs="Text sent to the following patients today at ".date("h:i A").".<br/><br/>";
			$subject="Sent SMS to Patients From Hope2Sms";
			$cnt=1;
			foreach($getResult as $key1=>$getPatientNameArrs){
				$msgsArr[$key1]=($cnt).". ".$getPatientNameArrs."</br>";
				$cnt++;
			}
	
			$count=count($msgsArr);
	
			$msgsArrimp=implode("</br>",$msgsArr);
			$msgs.=$msgsArrimp;
			if($count>0)
				$this->Note->sendMail($mailData,$msgs,$subject);
	
			/*EOF-Sending Mail- How much Patients got SMS FOR Confirmation Purpose*/
		}
		echo "Success";
		exit;
		/******EOF-Mahalaxmi-After patient reg to  get sms alert for Patient Relative......  ***/
	}
	/**
	 * @author Mahalaxmi
	 * For Send SMS From Voicecall
	 * @param $patientId integer
	 *
	 */
	public function voiceCall(){
		$this->layout="advance";
		$this->uses = array('User','Patient','TemplateSms');
		$this->User->unbindModel(array(
				'belongsTo' => array('State','City','Country')));
		$this->User->bindModel(array(
				'hasOne' => array('DoctorProfile'=>array('foreignKey'=>'user_id'))));
		$detailsDoc =  $this->User->find('all',array('fields'=>array('User.full_name','User.id','User.mobile'),'conditions'=>array('NOT'=>array('User.mobile'=>null),'Role.name'=>Configure::read("doctorLabel"),
				'User.location_id'=>$this->Session->read('locationid'),'User.is_active'=>1,'DoctorProfile.is_deleted'=>0,'DoctorProfile.is_registrar'=>0, 'User.is_deleted'=>0,'User.is_doctor'=>1),
				'order'=>array('User.first_name Asc')));
		
		$this->set(array('detailsDoc'=>$detailsDoc));
		$templateSmsData = $this->TemplateSms->find('list',array('fields'=>array('TemplateSms.id','TemplateSms.sms'),'order'=>array('TemplateSms.id'=>"DESC")));
		$this->set(array('templateSmsData'=>$templateSmsData));
	
	}
	
	function getDoctors($subLocation){		
		$this->autoRender = false;
		$this->Layout = 'ajax';
		$this->uses = array('Consultant','ContactSms');
		$subLocation=explode(",",$subLocation);	
		$subLocation=array_unique($subLocation);
		
		foreach($subLocation as $subLocations){
			$getId=explode("_",$subLocations);		
			if($getId[0]=="subLoc"){
				$doctorlist= $this->Consultant->find('all', array(
						'fields'=> array('id', 'full_name'),
						'conditions' => array('Consultant.is_deleted' => 0,'Consultant.corporate_sublocation_id'=>$getId[1],'Consultant.location_id' => $this->Session->read('locationid')),
						'order'=>array('Consultant.full_name')));		
				foreach($doctorlist as $key=>$dr){
					$returnArray[] = array('id'=>"consultant-".$dr['Consultant']['id'],'name'=>$dr['Consultant']['full_name']);
				}		
			}else if($getId[0]=="withoutsublocation"){
				$doctorlist= $this->Consultant->find('all', array(
						'fields'=> array('id', 'full_name'),
						'conditions' => array('Consultant.is_deleted' => 0,'Consultant.corporate_sublocation_id'=>null,'Consultant.location_id' => $this->Session->read('locationid')),
						'order'=>array('Consultant.full_name')));	
							
				foreach($doctorlist as $key=>$dr){
					$returnArray[] = array('id'=>"consultant-".$dr['Consultant']['id'],'name'=>$dr['Consultant']['full_name']);
				}		
			}else if($getId[0]=="grp"){			
				$returnArrayss=$this->ContactSms->findContactListByIds($getId[1]);		
				foreach($returnArrayss as $key=>$returnArrays){
					$returnArray[] = array('id'=>"group-".$key,'name'=>$returnArrays);
				}
			}
		}
		//debug($returnArray);
		if(!empty($returnArray))		
			echo json_encode($returnArray);
		else
			echo json_encode("none");
		exit;
		
	}
	
	function getDoctorsList() {
		$this->uses = array('Consultant');
		
		$doctorlist=array();
		$mergeArray=array();
		
		if(!empty($this->params->query['subLocationsDoctor'])) {
			$doctorlist= $this->Consultant->find('list', array(
					'fields'=> array('id', 'full_name'),
					'conditions' => array('Consultant.is_deleted' => 0,'Consultant.corporate_sub_location_id'=>$this->params->query['subLocationsDoctor'],'Consultant.location_id' => $this->Session->read('locationid')),
					'order'=>array('Consultant.full_name')));
			$mergeArray = array('All'=>'ALL')+$doctorlist;
			$this->set('doctorlist',$mergeArray);
			$this->layout = 'ajax';
			$this->redirect(array('controller'=>'Meassages','action'=>'ajaxgetdoctors'));
		} 
	}
	/**
	 * @author Mahalaxmi
	 * For Send SMS From Trigger
	 * @param $patientId integer
	 *
	 */
	 public function smsTrigger(){
		$this->layout=false;		
		$this->loadModel('Configuration');
		$this->set('configurationsSmsData',$this->Configuration->find('first',array('fields'=>array('Configuration.*'),'conditions'=>array('category'=>2,'name'=>Configure::read('sms_configuration_name')))));
	 }
	  public function saveSmsTrigger(){
		$this->autoRender = false;
		$this->Layout = 'ajax';			
		$this->loadModel('Configuration');
	
		if(!empty($this->request->data)){				
			$saveArr['id']=$this->request->data['sms_id'];
			$saveArr['value']=serialize($this->request->data['chk_box']);
			$this->Configuration->save($saveArr);
		}
		echo "Success";
		exit;
	 }
	//BOF-Mahalaxmi for SMS configurations
	 public function smsTitle(){

	 }
	 /**
	 * @author Mahalaxmi
	 * For View Group
	 * @param Null
	 *
	 */
	public function groupIndex($type=null,$groupID=null) {
		$this->layout='advance';
		$this->uses=array('GroupSms','Initial','TariffStandard','CorporateSublocation','City');
		$condition=array('GroupSms.is_deleted' => 0,'GroupSms.location_id'=>$this->Session->read('locationid'));
		if($type=='excel' || $type=='print' && !empty($groupID)){
		
			$this->set('dataCity', $this->City->getCityListId());
			$this->set('initials', $this->Initial->findInitialList());
       		// $this->set('getPrivateTariffID', $this->TariffStandard->getPrivateTariffID());
       	 	$this->set('tariffStandardData', $this->TariffStandard->getAllTariffStandard());
       	 	$this->set('corporateSublocationData', $this->CorporateSublocation->getCorporateSublocationList());
        	$this->GroupSms->bindModel(array(
			'hasMany' => array(
					'ContactSms' =>array('foreignKey' => 'group_id','fields'=>array('ContactSms.*')),					
			)),false);
			$getGroupSms=$this->GroupSms->find('first',array('fields'=>array('GroupSms.*'),'conditions'=>array('GroupSms.id'=>$groupID)));		
			$this->set('data',$getGroupSms);
			$this->autoRender = false;		
			if($type=='print'){									
				$this->layout = 'print_without_header' ;			
				$this->render('contact_sms_print');      
			}		
			if($type=='excel'){					
				$this->layout = false ;
				$this->render('contact_sms_excel');      
			}			      
		}else{
			if(!empty($this->params->query['first_name_search']))
					$condition['GroupSms.name'] = $this->params->query['first_name_search'];
				
			
					$this->paginate = array(
				        'limit' => Configure::read('number_of_rows'),
				        'order' => array(
				            'GroupSms.name' => 'asc'
				        ),
				        'conditions' => $condition,
	   				);
	                $this->set('title_for_layout', __('Corporate Sublocation', true));
	                $this->GroupSms->recursive = 0;
	           
	                $data = $this->paginate('GroupSms');
	                $this->set('data', $data);
	            if($type=='excel'){
					$this->autoRender = false;					
					$this->layout = false ;
					$this->render('group_excel');      
				}
				if($type=='print'){
					$this->autoRender = false;						
					$this->layout = 'print_without_header' ;			
					$this->render('group_print');      
				}
		}        
            
	}

	 /**
	 * @author Mahalaxmi
	 * For View Group
	 * @param Null
	 *
	 */
	public function groupView($id = null,$type=null) {
		$this->uses=array('GroupSms','ContactSms','Initial','TariffStandard','CorporateSublocation','City');
		$this->set('initials', $this->Initial->findInitialList());
       // $this->set('getPrivateTariffID', $this->TariffStandard->getPrivateTariffID());
		$this->set('dataCity', $this->City->getCityListId());
        $this->set('tariffStandardData', $this->TariffStandard->getAllTariffStandard());
        $this->set('corporateSublocationData', $this->CorporateSublocation->getCorporateSublocationList());
		$this->GroupSms->bindModel(array(
				'hasMany' => array(
						'ContactSms' =>array('foreignKey' => 'group_id','fields'=>array('ContactSms.*')),					
				)),false);
		$getGroupSms=$this->GroupSms->find('first',array('fields'=>array('GroupSms.*'),'conditions'=>array('GroupSms.id'=>$id)));		
		$this->set('getGroupSms', $getGroupSms);
        $this->set('title_for_layout', __('View Group', true));
       
		if (!$id) {
			$this->Session->setFlash(__('Invalid Group', true));
			$this->redirect(array("controller" => "Messages", "action" => "groupIndex"));
		}
        
     }

	 /**
	 * @author Mahalaxmi
	 * For Create New Group
	 * @param Null
	 *
	 */
	public function groupAdd() {
		$this->layout='advance';
        $this->uses=array('GroupSms','ContactSms','Initial','TariffStandard','CorporateSublocation');
        $this->set('initials', $this->Initial->findInitialList());
        $this->set('getPrivateTariffID', $this->TariffStandard->getPrivateTariffID());
        $this->set('tariffStandardData', $this->TariffStandard->getAllTariffStandard());
        $this->set('corporateSublocationData', $this->CorporateSublocation->getCorporateSublocationList());
        $this->set('title_for_layout', __('Add Group', true));
                if ($this->request->is('post')) {
						$this->request->data['GroupSms']['name'] = ucfirst($this->request->data['GroupSms']['group_name']);		
                        $this->request->data['GroupSms']['created_time'] = date('Y-m-d H:i:s');
                        $this->request->data['GroupSms']['created_by'] = $this->Auth->user('id');	
						$this->request->data['GroupSms']['location_id'] = $this->Session->read('locationid');	
					    $this->GroupSms->create();							
                        $this->GroupSms->save($this->request->data);	
						$lastInsertId=$this->GroupSms->getLastInsertId();
						$this->request->data['ContactSms']['group_id']=$lastInsertId;					
						$this->ContactSms->saveData($this->request->data);	
                        $errors = $this->GroupSms->invalidFields();
						if(!empty($errors)) {
                           $this->set("errors", $errors);
                        } else {
                           $this->Session->setFlash(__('The Group has been saved', true));
						   $this->redirect(array("controller" => "Messages", "action" => "groupIndex"));
                        }
		}         
                
	}

	 /**
	 * @author Mahalaxmi
	 * For Edit Group
	 * @param $groupId
	 *
	 */
	public function groupEdit($id = null) {
		$this->layout='advance';
		$this->set('title_for_layout', __('Edit Group', true));
		$this->uses=array('GroupSms','ContactSms','Initial','TariffStandard','CorporateSublocation','City');
        $this->set('initials', $this->Initial->findInitialList());
        $this->set('getPrivateTariffID', $this->TariffStandard->getPrivateTariffID());
        $this->set('tariffStandardData', $this->TariffStandard->getAllTariffStandard());
        $this->set('corporateSublocationData', $this->CorporateSublocation->getCorporateSublocationList());
       	if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid Group', true));
                        $this->redirect(array("controller" => "Messages", "action" => "groupIndex"));
		}
        if (!empty($this->request->data) && !empty($this->request->data["GroupSms"]['id'])) {				
        		$this->request->data['GroupSms']['name'] = ucfirst($this->request->data['GroupSms']['group_name']);
                $this->request->data['GroupSms']['modify_time'] = date('Y-m-d H:i:s');
                $this->request->data['GroupSms']['modified_by'] = $this->Auth->user('id');
				$this->request->data['GroupSms']['location_id'] = $this->Session->read('locationid');
                $this->GroupSms->id = $this->request->data["GroupSms"]['id'];	
                $this->GroupSms->save($this->request->data);
                $this->request->data['ContactSms']['group_id']=$this->request->data['GroupSms']['id'];
				
				$this->ContactSms->saveData($this->request->data);	

				$errors = $this->GroupSms->invalidFields();
                if(!empty($errors)) {
                   $this->set("errors", $errors);
                } else {
					$this->Session->setFlash(__('The Group has been updated', true));
					$this->redirect(array("controller" => "Messages", "action" => "groupIndex"));
                }
		} else {
			   $this->data = $this->GroupSms->read(null, $id);
			   $dataContact=$this->ContactSms->find('all',array('fields'=>array('ContactSms.*'),'conditions'=>array('ContactSms.group_id'=>$id)));
			   foreach ($dataContact as $key => $value) {
			   		if(!empty($value['ContactSms']['city_id'])){
			   			//debug($value['ContactSms']['sublocation_id']);
			   			$dataCity[$value['ContactSms']['sublocation_id']]=$this->City->getCitiesLists($value['ContactSms']['sublocation_id']);
			   		}
			   }
			 
			   $this->set(array('dataContact'=>$dataContact,'dataCity'=>$dataCity));
		}
   }


	 /**
	 * @author Mahalaxmi
	 * For Delete Group
	 * @param $groupId
	 *
	 */
	public function groupDelete($id = null) {
		$this->uses = array('GroupSms','ContactSms');
		$this->GroupSms->id = $id;		
		if($this->GroupSms->save(array('is_deleted' => 1))) {
			$updateContactSms['ContactSms']['is_deleted'] = 1;
			$this->ContactSms->updateAll($updateContactSms['ContactSms'],array('ContactSms.group_id'=>$id));			
			$this->Session->setFlash(__('Group deleted'));
			$this->redirect(array('action'=>'groupIndex'));
		}
		$this->Session->setFlash(__('Group was not deleted'));
		$this->redirect(array('action' => 'groupIndex'));
	}
	 /**
	 * @author Mahalaxmi
	 * For Change Status as acitve or inactive
	 * @param Null
	 *
	 */
	function change_status($test_id=null,$status=null){
		
		$this->uses = array('GroupSms','ContactSms');
		if($test_id==''){
			$this->Session->setFlash(__('There is some problem'),'default',array('class'=>'error'));
			$this->redirect($this->referer());
		}
		$this->GroupSms->id = $test_id ;
		$this->GroupSms->save(array('is_active'=>$status));
		$updateContactSms['ContactSms']['is_deleted'] = 1;
		$this->ContactSms->updateAll($updateContactSms['ContactSms'],array('ContactSms.group_id'=>$test_id));	
		$this->Session->setFlash(__('Status has been changed successfully'),'default',array('class'=>'message'));
		$this->redirect($this->referer());
	}
	public function ceomessage(){
		$this->layout="advance";
		$this->set('title_for_layout',__('CEO Message'));
		$this->uses = array('CeoMessage'); 
	
 		$conditions = array();
 		
		if(!empty($this->request->data)){  
			
			$this->request->data['CeoMessage']['created_by'] = $this->Session->read('userid');
			$this->request->data['CeoMessage']['created_time'] = date("Y-m-d");
			$date=$this->DateFormat->formatDate2STD($this->request->data['CeoMessage']['msg_date'],Configure::read('date_format'));
			
			$this->request->data['CeoMessage']['msg_date']= $date ;
			
			$this->CeoMessage->save($this->request->data);
			//debug($this->request->data);exit;
			$this->Session->setFlash(__('Message has been send successfully'),'default',array('class'=>'message'));
			$this->redirect($this->referer());
			
		}
	}
	
	function getTodaysMessage($date=null){ 
		Configure::write('debug',2);
		$this->layout="ajax"; 
		$this->set('date',$date);
		$this->uses = array('CeoMessage');
		$message=$this->CeoMessage->find('all',array(
			'fields'=>array('CeoMessage.id','CeoMessage.message','CeoMessage.created_time','CeoMessage.msg_date'),
			'conditions'=>array('CeoMessage.msg_date' =>$date)));
		$this->set('message',$message); 
	}
	public function ajaxFetchSublocation($corporateId=null){				
		$this->uses = array('CorporateSublocation');
		$selectedCorporateSublocation=$this->CorporateSublocation->getCorporateSublocationList($corporateId);		
		//$obj = (object) $selectedCorporateSublocation ;
		
		if(!empty($selectedCorporateSublocation)){
			echo json_encode($selectedCorporateSublocation);exit;
		}else{
			echo 'empty'; exit;
		}
	}
}
