<?php
/**
 * noteTemplatesController file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       noteTemplates.Controller
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Santosh R. Yadav
 */
class PatientremindersController extends AppController {

	public $name = 'Patientreminders';
	public $uses = array('Note','NoteTemplate','NoteTemplateText');
	public $helpers = array('Html','Form', 'Js','DateFormat','RupeesToWords','Number','General');
	public $components = array('RequestHandler','Email','ImageUpload','DateFormat','GibberishAES');
	
	public function main() {
		
	
	}

	//sending reminders to patient
	public function sendPatientReminder(){
	
		
	}
	
	public function sendToPatient($flag=null)
	{
		$this->uses=array('Patient','Appointment','Person','ReminderPatientList');
		$this->autoRender = false ;
		$reminders=Configure::read('reminders');
		$this->Person->bindModel(array(
				'belongsTo' => array('Patient' => array('foreignKey'=>false, conditions => array('Person.id=Patient.person_id')),
				'ReminderPatientList' => array('foreignKey'=>false, conditions => array('Person.id=ReminderPatientList.person_id',"ReminderPatientList.reminder_sent_for"=>$flag)),
				)),false);
		
		if($flag=='cancer')
		{
		   $bothage = array('21','65');
		   $search_key['Patient.age BETWEEN ? AND ? '] =$bothage;
		   $search_key['Patient.sex like '] =trim('female')."%" ;
		}
		if($flag=='smoking')
		{
			$search_key['Patient.age >=']  = 18 ;
		}
		if($flag=='highbp')
		{
			$search_key['Patient.age >=']  = 18 ;
		}
		
		$conditions=array($search_key);
		$conditions = array_filter($conditions);
		$data = $this->Person->find('all',array('fields'=>array('Person.first_name','Person.last_name','Patient.sex','Patient.age','Patient.patient_id','Patient.lookup_name','Person.id','Person.person_email_address','ReminderPatientList.reminder_followup_taken'),
				array('conditions' => array($conditions)),'order' => array('Person.id' => 'DESC'),'group' => array('Person.id')));
		
		
		
		foreach($data as $mailsendlistdata){
			
									
			$currentDate= date('Y-m-d h:i:s');
			if(empty($mailsendlistdata["ReminderPatientList"]["reminder_followup_taken"]) or $mailsendlistdata["ReminderPatientList"]["reminder_followup_taken"]=='No')
			{
				if(!(empty($mailsendlistdata["Patient"]["patient_id"])) || $mailsendlistdata["Patient"]["patient_id"]!=0)
				{
					
			       $reminder[]=array('person_id'=>$mailsendlistdata["Person"]["id"],'reminder_sent_for'=>$flag,'reminder_sent_date'=>$currentDate,'reminder_followup_taken'=>'No');
			       $sendReminders=$this->Note->sendMail_reminder($mailsendlistdata,$reminders[$flag],$reminders[$flag]);
				}
			  
			}
			
				//$sendMails['emailRecords']['email'][]=$data['Patient']['email'];
				/*if(!empty($data['Patient']['email'])){
					// mail functions
					App::import('Vendor', 'PHPMailer', array('file' => 'phpmailer/class.phpmailer.php'));
		
					$mail = new PHPMailer();
					$emailAddress='adityac@drmhope.com';
					$mail->AddAddress($emailAddress);
					$mail->SetFrom('gauravc@drmhope.com', 'Gaurav');
					$mail->AddReplyTo('cmd@drmhope.com', 'DrmHope');
		
					$mail->Subject  = "Sample Mail" ;
					$mail->Body     = "Cholesterol screening alerts";
					$mail->WordWrap = 50;
					$send =  $mail->Send() ;
					if(!$send) {
						debug($send);
						exit;
						$this->set("errors", $errors);
						echo 'Mailer error: ' . $mail->ErrorInfo;
						$this->Session->setFlash(__('Unable to send mail'),'default',array('class'=>'error'));
					} else {
		
						echo 'sucess';
						$this->Session->setFlash(__('Send mail'));
					}
					$sendMails['emailRecords']['id'][]=$data['Patient']['id'];
				}*/
			
		}
		
		$saveReminder = $this->ReminderPatientList->saveAll($reminder);		
		$this->Session->setFlash(__('Reminders sent succesfully for '.$reminders[$flag]),'default',array('class'=>'message'));
		$this->redirect(array('action'=>'sendPatientReminder'));
					
	}
	
		
	public function cholesterolScreening(){
		$this->uses=array('Patient','LaboratoryResult','LaboratoryHl7Result','Laboratory');
		$fail=0;
		$success=0;
		$this->Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$getLaBId=$this->Laboratory->find('list',array('fields'=>array('name','id'),'conditions'=>array('name like'=>'Cholesterol in LDL%')));
		$this->LaboratoryResult->bindModel(array(
				'belongsTo' => array(
						'Patient' =>array('foreignKey'=>'patient_id')),
				'hasMany' => array(
						'LaboratoryHl7Result' =>array('foreignKey'=>'laboratory_result_id')),
		));
		$getcholesterolScreeningRecords=$this->LaboratoryResult->find('all',array('fields'=>array('Patient.age','Patient.email','Patient.id','LaboratoryResult.laboratory_id'),
				'conditions'=>array('LaboratoryResult.laboratory_id'=>$getLaBId,'Patient.age >='=>19)));
		foreach($getcholesterolScreeningRecords as $data){
			if($data['LaboratoryHl7Result'][0]['abnormal_flag']=='N'){
				$sendMails['emailRecords']['email'][]=$data['Patient']['email'];
				if(!empty($data['Patient']['email'])){
					// mail functions
					App::import('Vendor', 'PHPMailer', array('file' => 'phpmailer/class.phpmailer.php'));
	
					$mail = new PHPMailer();
					$emailAddress='adityac@drmhope.com';
					$mail->AddAddress($emailAddress);
					$mail->SetFrom('gauravc@drmhope.com', 'Gaurav');
					$mail->AddReplyTo('cmd@drmhope.com', 'DrmHope');
	
					$mail->Subject  = "Sample Mail" ;
					$mail->Body     = "Cholesterol screening alerts";
					$mail->WordWrap = 50;
					$send =  $mail->Send() ;
					if(!$send) {
						debug($send);
						exit;
						$this->set("errors", $errors);
						echo 'Mailer error: ' . $mail->ErrorInfo;
						$this->Session->setFlash(__('Unable to send mail'),'default',array('class'=>'error'));
					} else {
	
						echo 'sucess';
						$this->Session->setFlash(__('Send mail'));
					}
					$sendMails['emailRecords']['id'][]=$data['Patient']['id'];
				}
			}
		}
	
	
			
	
	}
	public function bloodGlucose(){
	
		$this->uses=array('Patient','LaboratoryResult','LaboratoryHl7Result','Laboratory');
		$fail=0;
		$success=0;
		$this->autorender=false;
		$this->Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$getLaBId=$this->Laboratory->find('list',array('fields'=>array('name','id'),'conditions'=>array('id'=>'46167')));
		$this->LaboratoryResult->bindModel(array(
				'belongsTo' => array(
						'Patient' =>array('foreignKey'=>'patient_id')),
				'hasMany' => array(
						'LaboratoryHl7Result' =>array('foreignKey'=>'laboratory_result_id')),
		));
		$getbloodGlucoseRecords=$this->LaboratoryResult->find('all',array('fields'=>array('Patient.age','Patient.email','Patient.id','LaboratoryResult.laboratory_id'),
				'conditions'=>array('LaboratoryResult.laboratory_id'=>$getLaBId,'Patient.age >='=>19)));
		/* 	debug($getbloodGlucoseRecords);
		 exit; */
		foreach($getbloodGlucoseRecords as $data){
			if($data['LaboratoryHl7Result'][0]['abnormal_flag']=='N'){
				$sendMails['emailRecords']['email'][]=$data['Patient']['email'];
				if(!empty($data['Patient']['email'])){
					debug($data['Patient']['email']);
					// mail functions
					App::import('Vendor', 'PHPMailer', array('file' => 'phpmailer/class.phpmailer.php'));
	
					$mail = new PHPMailer();
					$emailAddress='adityac@drmhope.com';
					$mail->AddAddress($emailAddress);
					$mail->SetFrom('gauravc@drmhope.com', 'Gaurav');
					$mail->AddReplyTo('cmd@drmhope.com', 'DrmHope');
	
					$mail->Subject  = "Sample Mail" ;
					$mail->Body     = "Blood Glucose alerts";
					$mail->WordWrap = 50;
					$send =  $mail->Send() ;
					if(!$send) {
	
						$this->set("errors", $errors);
						echo 'Mailer error: ' . $mail->ErrorInfo;
						$this->Session->setFlash(__('Unable to send mail'),'default',array('class'=>'error'));
					} else {
	
						echo 'sucess';
						$this->Session->setFlash(__('Send mail'));
					}
					$sendMails['emailRecords']['id'][]=$data['Patient']['id'];
				}
			}
		}
	
	}
	
	
	function autoMailConfig()
	{
		$this->uses=array('AutoemailConfiguration');
		//get all configurable data
		$getAutoMailConfigData=$this->AutoemailConfiguration->find('all',array('fields'=>array('AutoemailConfiguration.screening','AutoemailConfiguration.age_limit','AutoemailConfiguration.repeat','AutoemailConfiguration.recommendation_text'),
				'conditions'=>array('AutoemailConfiguration.status'=>'1')));
		$this->set('getAutoMailConfigData',$getAutoMailConfigData);
	
	
	
	}

	
	
	
	
}





?>