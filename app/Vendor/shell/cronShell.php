<?php class CronShell extends Shell {
 
	//var $uses = array('model1','model2');
 
	/**
	 * the main function is kicked off like a contructor
	 *
	 */
	function main() {
	//public function cholesterolScreening(){
		$this->uses=array('Patient','LaboratoryResult','LaboratoryHl7Result','Laboratory');
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
				$sendMails['emailRecords']['id'][]=$data['Patient']['id'];	
			}
		}
		$emailAddress=implode(',',$sendMails['emailRecords']['email']);
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
		
					$this->set("errors", $errors);
					echo 'Mailer error: ' . $mail->ErrorInfo;
					$this->log($mail->ErrorInfo, date('Y-m-d'));
					//$this->Session->setFlash(__('Unable to send mail'),'default',array('class'=>'error'));
				} else {
		
					echo 'sucess';
					//$this->Session->setFlash(__('Send mail'));
				}
			
		
	//}
	}
 
	function otherFunction() {
		$content = 'This is content from otherFunction.';
 
		return $content;
	}
}
?>