<?php
App::uses('CakeEmail', 'Network/Email');
//App::uses('HttpSocket', 'Network/Http');

class ContactsController extends AppController {
	var $name = 'Contacts';
	var $uses = null;
	var $useTable = false;
	var $components = array( 'Cookie', 'Session');
	var $helpers = array('Html', 'Form', 'Js');

	
	public function beforeFilter() {
		$this->Auth->allow('index');
	}
	
	public function index() {
		
  		$this->theme= false;
  		$this->layout = 'cms';
  		if ($this->request->is('post')) {
  			$this->set('successMessage', 'Email sent successfully.');
  			$email = new CakeEmail('default');
  	
  			// set variables
  			$email->viewVars(array('name' => $this->data['Contacts']['name'], 'email' => $this->data['Contacts']['email'],
  					'mobile' => $this->data['Contacts']['mobile'], 'address' => $this->data['Contacts']['address'],
  					'message' => $this->data['Contacts']['message']
  			));
  		
  			$email->template('contactform');
  			$email->emailFormat('html');
  			$email->to(array('cmd@hopehospital.com'));
			$email->bcc(array('salimkhan123@gmail.com'));
  			$email->from(array('info@drmhope.com' => 'DRM Hope'));
  			$email->subject('DRM Hope - Contact Us');
  			
  			if($email->send()){
  				$this->Session->setFlash(__('Email has been sent successfully!'), 'default', array(), 'auth');
  				//unset($this->data);
  				$this->set('successMessage', 'Email sent successfully.');
  			}
  			
  			
  		}
	
	}
}
?>