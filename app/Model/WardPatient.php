<?php
/**
 * WardModel file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Facility.Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 */
class WardPatient extends AppModel {
	
	public $name = 'WardPatient';

		 public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }

    /**
     * Function getWardDetails
     * All Wards transaction on patient
     * @param unknown_type $patient_id
     * @return multitype:
     * Pooja Gupta
     */
    public function getWardDetails($patient_id){
    	$this->bindModel(array('belongsTo'=>array(
    			//'TariffList'=>array('foreignKey'=>false,'conditions'=>array('WardPatientService.tariff_list_id=TariffList.id')),
    			'Ward'=>array('foreignKey'=>false,'conditions'=>array('WardPatient.ward_id=Ward.id')),
    			'Room'=>array('foreignKey'=>false,'conditions'=>array('Room.id=WardPatient.room_id')),
    	)));
    
    	$patientWardUnits =$this->find('all',array('fields'=>array('Ward.name','WardPatient.*','Room.id','Room.name','Room.room_type'),
    			'conditions'=>array('WardPatient.patient_id'=>$patient_id,'WardPatient.is_deleted'=>'0'),
    			'order'=>array('WardPatient.in_date'),
    			'group'=>array('WardPatient.id')));
    	return $patientWardUnits;
    
    }
	
}