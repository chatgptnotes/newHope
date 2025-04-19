<?php
/**
 * PatientReferralConsultant Model file
 *
 * PHP 5
 *
 * @copyright     Copyright 2016 Drmhope Softwares  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       Hope
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Atul Chandankhede
 */
class PatientReferralConsultant extends AppModel {
	
	 public $name = 'PatientReferralConsultant'; 

	 public $specific = true;
		  function __construct($id = false, $table = null, $ds = null) {
	        $session = new cakeSession();
			$this->db_name =  $session->read('db_name');
	        parent::__construct($id, $table, $ds);
	 }
	 
	function insertPatientReferralConsultant($data=array(),$patientId){
    	$session= new cakeSession();
    	foreach ($data as $key=>$val){
    		$consultData['PatientReferralConsultant']['consultant_id']=$val;
    		$consultData['PatientReferralConsultant']['patient_id']=$patientId;
    		$consultData['PatientReferralConsultant']['created_by'] = $session->read('userid');
    		$consultData['PatientReferralConsultant']['create_time'] = date("Y-m-d H:i:s");
    		$this->save($consultData);
    		$this->id='';
    	}
        
    }
}
