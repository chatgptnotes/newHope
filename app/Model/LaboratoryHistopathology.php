<?php
/**
 * LaboratoryHistopathology model
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.drmhope.com/
 * @package       Laboratory Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Swapnil G.Sharma
 * @functions 	 : insertService(insert/update service data).
 */
class LaboratoryHistopathology extends AppModel {
	public $name = 'LaboratoryHistopathology';
	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		if (empty ( $ds )) {
			$session = new cakeSession ();
			$this->db_name = $session->read ( 'db_name' );
		} else {
			$this->db_name = $ds;
		}
		parent::__construct ( $id, $table, $ds );
	}
}