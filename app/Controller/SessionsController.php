<?php
class SessionsController extends AppController {
	public $name = 'Sessions';
	public $uses = null;
	public $helpers = array('Html', 'Form');
	
	function index(){
		$this->layout =false ;
		$this->render('index');
	}
	function login() {
	  
	 }
	function logout() {
	 	$this->redirect($this->Auth->logout());
	 }
	function home(){
		$this->layout =false ;
		$this->render('home');
	}
	
}
?>