<?php
/**
 * UsersController file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Hope
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Santosh R. Yadav
 */
class ComputerizedprordersController extends AppController {

	public $name = 'Computerizedprorders';
	//public $uses = array('Hl7Message');
	public $helpers = array('Html','Form', 'Js');
	public $components = array('RequestHandler','Email','Auth','Session', 'Acl','Cookie');

	public function beforeFilter() {

}

public function index()
	{



	}  
  
}
?>