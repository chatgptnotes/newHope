<?php
/**
 * MailTestController file
 *
 * PHP 5
 *
 * @copyright     Copyright 2014 Hope Software Inc.
 * @link          http://www.drmhope.com/
 * @package       MailTest.Controller
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Aditya V. Chitmitwar
 */
class MailTestController extends AppController {

	public $name = 'MailTest';
	public $uses = array('Note','NoteTemplate','NoteTemplateText');
	public $helpers = array('Html','Form', 'Js','DateFormat','RupeesToWords','Number');
	public $components = array('RequestHandler','Email','ImageUpload','DateFormat');

	public function index(){
		echo "hello";
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
	
	
	function autoMailConfig(){
		
		
	}


}