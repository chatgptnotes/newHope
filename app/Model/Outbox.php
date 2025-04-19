<?php

/* Outbox Model
 *
* PHP 5
*
* @copyright     Copyright 2011 KloudData Inc.  (http://www.drmhope.com/)
* @link          http://www.drmhope.com/
* @package       Outbox.Model
* @since         CakePHP(tm) v 2.0
* @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
* @author        Pawan Meshram
*/
class Outbox extends AppModel {
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $name = 'Outbox';



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