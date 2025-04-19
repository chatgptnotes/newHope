<?php

 /* Result_status_0123 model
*
* PHP 5
*
* @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
* @link          http://www.drmhope.com/
* @package       Result_status_0123 modelel
* @since         CakePHP(tm) v 2.0
* @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
* @author        Aditya Chitmitwar
*/
class Result_status_0123 extends AppModel {
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $name = 'Result_status_0123';

	

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * hasMany associations
	 *
	 * @var array
	*/
	
	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}
}
?>