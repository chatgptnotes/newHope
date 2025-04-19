<?php
/**
 * ErController file
 *
 * PHP 5
 *
 * @copyright     Copyright 2013 drmhope Inc.  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       ErController
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 */

class ErController extends AppController {
	//
	public $name = 'Er';
	public $uses = null;
	public $helpers = array('Html','Form', 'Js');
	public $components = array('RequestHandler','Email', 'Session');
	
	
	function frondesk_emergency_patient(){
		$this->cacheAction = true ;
	}
	
}