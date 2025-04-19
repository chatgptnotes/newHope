<?php
/**
 * Hl7TextMessagesController file
 *
 * PHP 5
 *
 * @copyright     Copyright 2013 drmhope Inc.  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       Hl7TextMessagesController Controller
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 */

class Hl7TextMessagesController extends AppController {
	
	public $name = 'Hl7TextMessages';
	public $uses = array();
	public $helpers = array('Html','Form', 'Js','Fck','GibberishAES','General');
	public $components = array('RequestHandler','Email', 'Session');
	
	public function index($id=null){
	  
		$this->uses = array('AmbulatoryResult','Patient');
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array('AmbulatoryResult.id' => 'DESC')
		);
		$this->set('messages',$this->paginate('AmbulatoryResult'));
		//echo'<pre>';print_r($this->paginate('AmbulatoryResult'));
		
	}
	
	public function hl7AdtMailbox(){
	
	}
	
	public function hl7ImmunizationMailbox(){
	
	}
	
	public function hl7ImmunizationInbox(){
	
	}
	
	public function hl7AdtInbox(){
	
	}
	
	public function hl7LabMessages(){
		$this->uses = array('Hl7Message');
		$model = ClassRegistry::init('Hl7Message');
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array('Hl7Message.id' => 'DESC'),
				'conditions'=>array("Hl7Message.message_from = 'LAB_RESULT_ELR' OR Hl7Message.message_from = 'LAB_RESULT_LRI' OR Hl7Message.message_from='LAB_RESULT_EDIT_LRI' OR Hl7Message.message_from='LAB_RESULT_EDIT_ELR'")
				
		);
		$this->set('messages',$this->paginate('Hl7Message'));
	}
	
	public function outbox(){
		$this->uses = array('Hl7Message');
		$model = ClassRegistry::init('Hl7Message');
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array('Hl7Message.id' => 'DESC')
		);
		$this->set('messages',$this->paginate('Hl7Message'));
	}
	
	public function immunizationOutbox(){
		$this->uses = array('Hl7Message');
		$model = ClassRegistry::init('Hl7Message');
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array('Hl7Message.id' => 'DESC'),
				'conditions' => array('message_from'=>'IMMUNIZATION')
		);
		$this->set('messages',$this->paginate('Hl7Message'));
	}
	
	public function adtOutbox(){
		$this->uses = array('Hl7Message');
		$model = ClassRegistry::init('Hl7Message');
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array('Hl7Message.id' => 'DESC'),
				'conditions' => array("message_from = 'A03' OR message_from='A04' OR message_from='A08' OR message_from='A01'")
		);
		$this->set('messages',$this->paginate('Hl7Message'));
	}
	
	
	public function openMessage(){
	
		if(isset($this->request->data['messageId']) && !empty($this->request->data['messageId'])){
			$this->uses = array('AmbulatoryResult');
				
			$message = $this->AmbulatoryResult->find('first',array('conditions'=>array('AmbulatoryResult.id'=>$this->request->data['messageId'])));
			//$message['Inbox']['message'] = nl2br($message['Inbox']['message']);
				
			//$message['Inbox']['AmbulatoryResult'] = str_replace(" ", "+", $message['AmbulatoryResult']['message']);
			$message['AmbulatoryResult']['message'] = str_replace("\n", "<br>", $message['AmbulatoryResult']['message']);
				
			$this->AmbulatoryResult->id = $this->request->data['messageId'];
			$this->AmbulatoryResult->save(array('is_read'=>1));
			echo json_encode($message);exit;
			//echo '<pre>';print_r($message);exit;
		}
	}
	
	public function openOutboxMessage(){
		if(isset($this->request->data['messageId']) && !empty($this->request->data['messageId'])){
			$this->uses = array('Hl7Message');
				
			$message = $this->Hl7Message->find('first',array('conditions'=>array('Hl7Message.id'=>$this->request->data['messageId'])));
			//$message['Outbox']['message'] = nl2br($message['Outbox']['message']);
				
			//$message['AmbulatoryResultOutbox']['message'] = str_replace(" ", "+", $message['AmbulatoryResultOutbox']['message']);
			//$message['Outbox']['subject'] = str_replace(" ", "+", $message['Outbox']['subject']);
			$message['Hl7Message']['message'] = str_replace("\n", "<br>", $message['Hl7Message']['message']);
			$this->Hl7Message->id = $this->request->data['messageId'];
			$this->Hl7Message->save(array('is_read'=>1));
			echo json_encode($message);exit;
		}
		
	}
	
	public function openAdtOutboxMessage(){
		if(isset($this->request->data['messageId']) && !empty($this->request->data['messageId'])){
			$this->uses = array('Hl7Message');
	
			$message = $this->Hl7Message->find('first',array('conditions'=>array('Hl7Message.id'=>$this->request->data['messageId'])));
			//$message['Outbox']['message'] = nl2br($message['Outbox']['message']);
	
			//$message['AmbulatoryResultOutbox']['message'] = str_replace(" ", "+", $message['AmbulatoryResultOutbox']['message']);
			//$message['Outbox']['subject'] = str_replace(" ", "+", $message['Outbox']['subject']);
			$message['Hl7Message']['message'] = str_replace("\n", "<br>", $message['Hl7Message']['message']);
			$this->Hl7Message->id = $this->request->data['messageId'];
			$this->Hl7Message->save(array('is_read'=>1));
			echo json_encode($message);exit;
		}
	
	}
	
	public function openImmunizationOutboxMessage(){
		if(isset($this->request->data['messageId']) && !empty($this->request->data['messageId'])){
			$this->uses = array('Hl7Message');
	
			$message = $this->Hl7Message->find('first',array('conditions'=>array('Hl7Message.id'=>$this->request->data['messageId'])));
			//$message['Outbox']['message'] = nl2br($message['Outbox']['message']);
	
			//$message['AmbulatoryResultOutbox']['message'] = str_replace(" ", "+", $message['AmbulatoryResultOutbox']['message']);
			//$message['Outbox']['subject'] = str_replace(" ", "+", $message['Outbox']['subject']);
			$message['Hl7Message']['message'] = str_replace("\n", "<br>", $message['Hl7Message']['message']);
			$this->Hl7Message->id = $this->request->data['messageId'];
			$this->Hl7Message->save(array('is_read'=>1));
			echo json_encode($message);exit;
		}
	
	}
	
	public function compose($id=null){
		
		if($this->request->data){echo '<pre>';print_r($this->request->data['Compose']);exit;
			$this->uses = array('Hl7Message','Inbox','Outbox','Person','User');
	
	
			$this->request->data['Compose']['message_from'] = "DrmHope Lab Manager" ;
			$this->request->data['Compose']['create_time'] = date('Y-m-d H:i:s');
			
			$this->Hl7Message->Save($this->request->data['Compose']);
			
			$this->redirect(array("controller" => "Laboratories", "action" => "index", "admin" => false));
			//echo '<pre>';print_r($this->request->data['Compose']);exit;
		}
	}
}