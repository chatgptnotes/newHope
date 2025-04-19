<?php
class PatientExposure extends AppModel {

	public $name = 'PatientExposure';
	/*public $actsAs = array('Cipher' => array('autoDecypt' => true,'cipher'=>array('surgical_procedure','urinary_catheter','mechanical_ventilation','central_line','peripheral_line'))); */ 
	 
/**
*
* save patient exposure data
*
**/	
 public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    } 
	public function saveData($data) {
                $data['PatientExposure']['patient_id']	= $data['patient_id'];
		$data['PatientExposure']['location_id']= AuthComponent::user('location_id');
		#$data['PatientExposure']['submit_date']= date('Y-m-d');
               	$data['PatientExposure']['created_by']= AuthComponent::user('id');
		$data['PatientExposure']['create_time']=date("Y-m-d H:i:s");
                $data['PatientExposure'] = array_merge($data['PatientExposure']);
                $this->save($data);
	}
	
	
}