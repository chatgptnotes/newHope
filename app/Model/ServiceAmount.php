<?php

/** Service Amount model
*
* PHP 5
*
* @copyright     Copyright 2011 DrmHope Software  (http://www.drmhope.com/)
* @link          http://www.drmhope.com/
* @package       Languages.Model
* @since         CakePHP(tm) v 2.0
* @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
* @author        Pawan Meshram
*/
class ServiceAmount extends AppModel {
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $name = 'ServiceAmount';

	

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