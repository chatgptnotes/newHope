<?php 
/**
 * DutyPlan model
 *
 * PHP 5
 *
 * @link          http://www.drmhope.com/
 * @package       Duty Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Swati Newale
 */
class LeaveType extends AppModel {

	public $name = 'LeaveType';
	public $useTable = 'leave_types';
	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}
	

}