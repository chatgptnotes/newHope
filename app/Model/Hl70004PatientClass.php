<?php
/**
 * Hl70004PatientClass Controller
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Hl70004PatientClass.Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 */
class Hl70004PatientClass extends AppModel {
	
	public $useTable = 'hl7_0004_patient_classes';
	public $name = 'Hl70004PatientClass';
	public $specific = true;
	
	function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }
}
