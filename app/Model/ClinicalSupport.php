<?php

 /* Clinical Support model
*
* PHP 5
*
* @copyright     Copyright 2011 Drmhope Inc.  
* @link          http://www.Drmhope.com/
* @package       Clicnical Support model
* @since         CakePHP(tm) v 2.0
* @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
* @author       Aditya Chitmtiwar
*/
class ClinicalSupport extends AppModel {
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $name = 'ClinicalSupport';
	public $usetable= 'clinical_supports';
	//public $actsAs = array('Auditable');
	

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