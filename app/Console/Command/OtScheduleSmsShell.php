<?php
/**
 * OtScheduleSmsShell Shell
 *
 * PHP 5
 *
 * @copyright     Copyright 2013 drmhope Inc.  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       SmsApi Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Mahalaxmi 
 */
 

App::uses('CakeSession', 'Model/Datasource');
App::uses('Component', 'Controller');
App::uses('DateFormatComponent', 'Controller/Component');  
class OtScheduleSmsShell extends AppShell {
	public $name = 'OtScheduleSms';
	public $uses = array('SmsApi','Session','cakeSession'); 
	public $component = array('Session') ;
	
	public function main() {
		$this->sendToSmsForOtSchedule();		
	}
	/**
	 * function for send SMS to Dr.Pallavi,Dr.Murali & Ruby Ma'am.
	 * @param unknown_type .
	 * @Mahalaxmi
	 */
	public function sendToSmsForOtSchedule(){		
		$this->uses = array('SmsApi');
		//Configure::write('debug',2) ;		
		$totalScheduleSurgeryText=$this->SmsApi->smsToSendForOTSchedule(); //Find Total Schedule Patient Surgery			
		$getData=$this->SmsApi->sendToSms($totalScheduleSurgeryText,Configure::read('rgjayOtSchedule')); 	
	}	
}