<?php 
/**
 * Hrdocuments model
 *
 * PHP 5
 *
 * @link          http://www.drmhope.com/
 * @package       HrDetails Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Swati Newale
 */
class HrDocument extends AppModel {

	public $name = 'HrDocument';
	public $useTable = 'hr_documents';
	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}
	/**
	 * @param array $data
	 * @author Swati Newale
	 * @return boolean
	 */
	
}