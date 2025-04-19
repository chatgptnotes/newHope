<?php
/**
 * Document Upload Shell
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
class DocumentUploadCompleteShell extends AppShell {
	public $name = 'DocumentUploadComplete';
	public $uses = array('SmsApi','Session','cakeSession'); 
	public $component = array('Session') ;
	
	public function main() {
		$this->sendToSmsForDocumentUpload();		
	}
	/**
	 * function for send SMS to Patient 
	 * @param unknown_type whatevertime set time.
	 * @Mahalaxmi
	 */
	public function sendToSmsForDocumentUpload(){		
		//Configure::write('debug',2) ;
		$this->uses = array('SmsApi');					
		$this->SmsApi->smsToSendForDocumentUpload(); 		
	}	
}