<?php
class ScheduledSurgeryStatusSmsShell extends AppShell {
	public $name = 'SmsApi';
	public $uses = array('SmsApi');
	public $helpers = array('Html','Form', 'Js');
	public $components = array('RequestHandler','Email', 'Session');
	
	public function main() {
		$this->sendSurgeryStatusNotUpdated();
	}
	
	public function sendSurgeryStatusNotUpdated(){
			$this->SmsApi->sendSurgeryStatusNotUpdated();
	}
	
	
}