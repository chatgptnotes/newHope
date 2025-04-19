<?php
/**
 * Support controller
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Radiology Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author       
 * $function 	  :AEVD
 */
class SupportsController extends AppController {

	public $name = 'Supports';
	public $uses = array('Support','HttpSocket', 'Network/Http');	 

	public $components = array('ImageUpload');
	public $helpers = array('Html','Form', 'Js','DateFormat','RupeesToWords','Number','General');
	
	
	function web_chat(){
		
		
		header('Content-type:text/javascript;charset=UTF-8');
		 
		 
		
		
	}
}