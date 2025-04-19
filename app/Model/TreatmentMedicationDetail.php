<?php
/**
 * TreatmentMedicationDetail file
 *
 * PHP 5
 *
 * @author  	Swapnil Sharma
 * @created 	22.12.2015	
 */
class TreatmentMedicationDetail extends AppModel {

	public $name = 'TreatmentMedicationDetail';
	
	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }
}	