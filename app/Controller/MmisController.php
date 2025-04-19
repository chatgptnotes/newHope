<?php
/**
 * Mmis controller
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.DMRHOPE.com/
 * @package       Mmis Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 */


class MmisController extends AppController {

	public $name = 'Mmis';
	public $helpers = array('Html','Form', 'Js','DateFormat','RupeesToWords','Number','General','JsFusionChart');
	public $components = array('RequestHandler','Email','General','Number');
	public $useTable = false;
	
	
	function index(){
		
		
	}	
	
	function admin_index(){
	
	
	}
}