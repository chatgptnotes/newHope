<?php
/**
 * PatientBloodTransfusion Model file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       PatientBloodTransfusion Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Mayank Jain
 */
class PatientBloodTransfusion extends AppModel {
	
	public $name = 'PatientBloodTransfusion';
	public $useTable ='patient_blood_transfusion_form';
	public $actsAs = array('Cipher' => array('autoDecypt' => true,'cipher'=>array('tranfusion_note','systemic_examination','bag_no'
	 ,'clot_or_turbidity','premedication_given','other_detail','adverse_events','action_taken')));  
	 
 	 public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }

	
	
}