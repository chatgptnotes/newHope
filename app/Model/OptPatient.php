<?php
/**
 * OptPatient Model file
 *
 * PHP 5
 *
 * @copyright     Copyright 2013 Drmhope Softwares  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       Hope
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Gulshan Trivedi
*/
class OptPatient extends AppModel {

	public $name = 'OptPatient';
	public $useTable = 'opt_patients';
	public $specific = true;
	
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
			
	}
	
	
}?>