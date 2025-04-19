<?php
class IntrinsicRiskFactor extends AppModel {

	public $name = 'IntrinsicRiskFactor';
	 public $actsAs = array('Cipher' => array('autoDecypt' => true,'cipher'=>array('antibiotic','prophylaxis_therapy','diabetes','alcoholism','smoking'
	 ,'hypertension','anaemia','malignancy','trauma','cirrhosis','steroids','immunosuppression')));  
	 
/**
*
* save intrinsic risk factor data
*
**/	
	public function saveData($data){
                $data['IntrinsicRiskFactor']['patient_id']	= $data['patient_id'];
		$data['IntrinsicRiskFactor']['location_id']= AuthComponent::user('location_id');
		#$data['IntrinsicRiskFactor']['submit_date']= date('Y-m-d');
               	$data['IntrinsicRiskFactor']['created_by']= AuthComponent::user('id');
		$data['IntrinsicRiskFactor']['create_time']=date("Y-m-d H:i:s");
                $data['IntrinsicRiskFactor'] = array_merge($data['IntrinsicRiskFactor']);
                $this->save($data);
	}
	
 public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    } 	
}