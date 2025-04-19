<?php
class NosocomialInfection extends AppModel {

	public $name = 'NosocomialInfection';
	/*public $actsAs = array('Cipher' => array('autoDecypt' => true,
			'cipher'=>array('surgical_site_infection','urinary_tract_infection','ventilator_associated_pneumonia','clabsi','thrombophlebitis'
					,'other_nosocomial_infection','mrsa','vre')));*/

	public $specific = true;
/**
*
* save nosocomial infections data
*
**/	
	 public function saveData($data){
	 	$data['NosocomialInfection']['patient_id']	= $data['patient_id'];
	 	$data['NosocomialInfection']['location_id']= AuthComponent::user('location_id');
	 	#$data['NosocomialInfection']['submit_date']= date('Y-m-d');
	 	$data['NosocomialInfection']['created_by']= AuthComponent::user('id');
	 	$data['NosocomialInfection']['create_time']=date("Y-m-d H:i:s");
	 	$data['NosocomialInfection'] = array_merge($data['NosocomialInfection']);
	 	$this->save($data);
	 } 
	 
	 function __construct($id = false, $table = null, $ds = null) {
	 	$session = new cakeSession();
	 	$this->db_name =  $session->read('db_name');
	 	parent::__construct($id, $table, $ds);
	 }
}

