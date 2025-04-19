<?php
/**
 * PatientBloodSugarMonitoring Model file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       PatientBloodSugarMonitoring Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Mayank Jain
 */
class PatientBloodSugarMonitoring extends AppModel {
	
	public $name = 'PatientBloodSugarMonitoring';
	public $useTable= "patient_blood_sugar_monitoring";
	
	public $actsAs = array('Cipher' => array('autoDecypt' => true,'cipher'=>array('blood_sugar','treatment')));  
	 
	 public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }

	
	
}