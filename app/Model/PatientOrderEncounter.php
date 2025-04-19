<?php

 /* PatientOrderEncounter model
*
* PHP 5
*
* @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
* @link          http://www.klouddata.com/
* @package       Languages.Model
* @since         CakePHP(tm) v 2.0
* @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
* @author        Mahalaxmi
*/
class PatientOrderEncounter extends AppModel {
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $name = 'PatientOrderEncounter';
	public $specific = true;	
		
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}
}
?>