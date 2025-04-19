<?php 
class OrderSetsController extends AppController {

	public $name = 'OrderSet';
	public $uses = null;
	public $helpers = array('Html','Form', 'Js','DateFormat','General','Number');
	public $components = array('RequestHandler','Email','DateFormat','General');

	public function index(){
		echo ("this index page");
	}
}
?>
