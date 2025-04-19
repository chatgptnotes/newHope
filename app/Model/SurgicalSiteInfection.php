<?php
/**
 * SurgicalSiteInfectionModel file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Hope hospital
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Santosh R. Yadav
 */
class SurgicalSiteInfection extends AppModel {

	public $name = 'SurgicalSiteInfection';
	 public $actsAs = array('Cipher' => array('autoDecypt' => true,'cipher'=>array('operation_type','wound_location','wound_type','asa_scoretype','antimicrobial_prophylaxis'
	 ,'ssi_infection','ssi_micro1','ssi_micro2')));  
	 	
/**
 * association with users table.
 *
 */
	public $belongsTo = array('Patient' => array('className'    => 'Patient',
                                                  'foreignKey'    => 'patient_id'
                                                 )
                                  );
     public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    } 
}
?>