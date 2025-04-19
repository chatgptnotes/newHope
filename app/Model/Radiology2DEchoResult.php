<?php
/**
 * Radiology2DEchoResult Model file
 *
 * PHP 5
 *
 * @copyright     Copyright 2015 Drmhope Softwares  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       Hope
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Atul Chandankhede
*/
class Radiology2DEchoResult extends AppModel {

	public $name = 'Radiology2DEchoResult';
	public $useTable = 'radiology_2d_echo_result';
	public $specific = true;
	
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
			
	}
	
	
}?>
