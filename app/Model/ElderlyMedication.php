<?php

 /* Elderly Medication model
*
* PHP 5
*
* @copyright     Copyright 2013 Drmhope Inc.  (http://www.Drmhope.com/)
* @link          http://www.Drmhope.com/
* @package       ElderlyMedication.Model
* @since         CakePHP(tm) v 2.0
* @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
* @author        Aditya Chitmitwar
*/
class ElderlyMedication extends AppModel {
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $name = 'ElderlyMedication';

	

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