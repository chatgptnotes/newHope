<?php
class MicroOrganism extends AppModel {

	public $name = 'MicroOrganism';
 	public $actsAs = array('Cipher' => array('autoDecypt' => true,'cipher'=>array('mrsa','vre')));  
	 
/**
*
* save micro organisms data
*
**/
	public function saveData($data){
                $data['MicroOrganism']['patient_id']	= $data['patient_id'];
		$data['MicroOrganism']['location_id']= AuthComponent::user('location_id');
		#$data['MicroOrganism']['submit_date']= date('Y-m-d');
               	$data['MicroOrganism']['created_by']= AuthComponent::user('id');
		$data['MicroOrganism']['create_time']=date("Y-m-d H:i:s");
                $data['MicroOrganism'] = array_merge($data['MicroOrganism']);
                $this->save($data);
      	}
	 public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    } 
	
}
