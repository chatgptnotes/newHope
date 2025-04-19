<?php
App::uses('CakeSession', 'Model/Datasource');
App::uses('Configuration','Model') ;
class MissmsShell extends AppShell {
	public $name = 'Missms';
	public $uses = array('SmsApi','Session','cakeSession'); 
	public $component = array('Session') ;
	
	public function main() {
		$this->sendMisSms();		
	}
	
	public function sendMisSms(){ 
			$this->uses = array('SmsApi') ;			
		   if($_SERVER['argv'][4]=='first'){
			  	$totalRevenue=$this->SmsApi->smsToSendForTotalRevenue(); //Find Total Revenue		   	
			   	$totalIpdCount=$this->SmsApi->smsToSendForIpdPatient(); //Find Total no of Ipd Patient
				$totalIpdPrivateCount=$this->SmsApi->smsToSendForIpdPrivatePatient(); //Find Total no of Ipd Patient
				$totalIpdRjayCount=$this->SmsApi->smsToSendForIpdRjayPatient(); //Find Total no of Ipd Patient	
				$totalIpdOtherCorporateCount=$this->SmsApi->smsToSendForIpdOtherCorporatePatient(); //Find Total no of Ipd Patient		
				$totalOpdCount=$this->SmsApi->smsToSendForOpdPatient(); //Find Total no of Opd Patient
			   	$totalDischargedCount=$this->SmsApi->smsToSendForDischargePatient(); //Find Total no of Discharge Patient
				$totalDischargedPrivateCount=$this->SmsApi->smsToSendForPrivateDischargePatient(); //Find Total no of Discharge Patient
				$totalDischargedRjayCount=$this->SmsApi->smsToSendForRjayDischargePatient(); //Find Total no of Discharge 
				$totalDischargedOtherCorporateCount=$this->SmsApi->smsToSendForOtherCorporateDischargePatient(); //Find Total no of Discharge Patient
			   	$firstMsgText = date('d M Y',strtotime("yesterday")).
			   	', Total IP Admitted Patients -'.$totalIpdCount.
				', IP Private Admitted Patients -'.$totalIpdPrivateCount.				
				', IP RJAY Admitted Patients -'.$totalIpdRjayCount.						
				', IP Other Corporate Admitted Patients -'.$totalIpdOtherCorporateCount.
			   	', OP Patients -'.$totalOpdCount.			
			   	', Discharge Patients-'.$totalDischargedCount.
				', Private Discharge Patients-'.$totalDischargedPrivateCount.
				', RGJAY Discharge Patients-'.$totalDischargedRjayCount.
				', Other Corporate Discharge Patients-'.$totalDischargedOtherCorporateCount.
			   	' and Total Revenue- Rs.'.number_format($totalRevenue,2);			
				$data = $this->SmsApi->sendToSms($firstMsgText,Configure::read('owner_no')); 			
		   }
		   if($_SERVER['argv'][4]=='second'){//if first sms sent then call second
			   	$totalRadiologyCount=$this->SmsApi->smsToSendRadiologyCount(); //Find Total no of Radiology count			 
				$totalLabServicesCount=$this->SmsApi->smsToSendForLabServiceCount(); //Find Total no of Lab service count	  
				$totalSurgeryCount=$this->SmsApi->smsToSendForSurgeryServiceCount(); //Find Total no of Surgery
				//echo "first sms sent";
				$secondMsgText =  "Service Count- ".date('d M Y',strtotime("yesterday")).
			   	', Laboratory -'.$totalLabServicesCount.			  
			   	', Radiolgy -'.$totalRadiologyCount.		  			
				', Surgery -'.$totalSurgeryCount ;		
				$this->SmsApi->sendToSms($secondMsgText,Configure::read('owner_no')); 
		   } 
			
	}
	
	
}