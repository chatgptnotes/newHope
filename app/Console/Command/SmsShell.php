<?php
class SmsShell extends AppShell {
	public $name = 'SmsApi';
	public $uses = array('SmsApi');
	public $helpers = array('Html','Form', 'Js');
	public $components = array('RequestHandler','Email', 'Session');
	//public $admissionId;
	//public $patientUid;
	
	public function main() {
		//$this->sendToSmsPatientBdayWish($type); //commented by w
		$this->sendSmsRGJAYPatient($type);
		
	}
	
	public function sendToSmsPatientBdayWish($type){
			$this->SmsApi->sendToSmsPatientBdayWish('Bday');
	}
	
	public function sendSmsRGJAYPatient($type){
		$this->SmsApi->sendSmsRGJAYPatient('RGJAYASON');
	}
}