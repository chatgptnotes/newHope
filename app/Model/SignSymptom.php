<?php
class SignSymptom extends AppModel {

	public $name = 'SignSymptom';
	 public $actsAs = array('Cipher' => array('autoDecypt' => true,'cipher'=>array('fever','chills','local_pain','swelling','redness'
	 ,'pus_discharge','urinary_frequency','respiratory_secretion','dysuria','suprapubic_tenderness','oliguria','pyuria','cough','other')));  
	 
/**
*
* save sign symptom data
*
**/
	public function saveData($data) {
                $data['SignSymptom']['patient_id']	= $data['patient_id'];
		$data['SignSymptom']['location_id']= AuthComponent::user('location_id');
		#$data['SignSymptom']['submit_date']= date('Y-m-d');
               	$data['SignSymptom']['created_by']= AuthComponent::user('id');
		$data['SignSymptom']['create_time']=date("Y-m-d H:i:s");
                $data['SignSymptom'] = array_merge($data['SignSymptom']);
                $this->save($data);
	}
	
	 public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    } 
}
