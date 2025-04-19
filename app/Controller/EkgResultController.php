<?php
/**
 * EkgResultController file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Wards Controller
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Gulshan Trivedi
 */

class EkgResultController extends AppController {
	//
	public $name = 'EkgResult';
	public $uses = array('EkgResult');
	public $helpers = array('Html','Form', 'Js','General');
	public $components = array('RequestHandler','Email', 'Session');
	
	
	
	
}
?>