<?php
class ChildBirth extends AppModel {

	  public $name = 'ChildBirth';
        		
	  public $validate = array(
		    'name' => array(
			'rule' => "notEmpty",
			'message' => "Please enter name."
			),
		    'dob' => array(
			'rule' => "notEmpty",
			'message' => "Please enter date of birth."
			),
			'mother_name' => array(
			'rule' => "notEmpty",
			'message' => "Please enter mother name."
			),
			'father_name' => array(
			'rule' => "notEmpty",
			'message' => "Please enter father name."
			),
			'sex' => array(
			'rule' => "notEmpty",
			'message' => "Please select sex."
			),
			'dob' => array(
			'rule' => "notEmpty",
			'message' => "Please enter date of birth."
			),
      );
        
	  public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
		        $session = new cakeSession();
				$this->db_name =  $session->read('db_name');
		        parent::__construct($id, $table, $ds);  
      }
      
      /*function to insert n update child birth entry
      *@params : post array
      *@return : true/false
      **/
	  public function insertChildBirth($data = array()){
	  		 
	  		 $session = new cakeSession();
        	if($data['ChildBirth']['id']) {
	                $data['ChildBirth']['id'] = $data['ChildBirth']['id'];
	                $data['ChildBirth']['modified_by'] = $session->read('userid');
	                $data['ChildBirth']['modify_time'] = date('Y-m-d H:i:s');
            } else {
                $data['ChildBirth']['created_by'] = $session->read('userid');
                $data['ChildBirth']['create_time'] = date('Y-m-d H:i:s');
            }
            $data["ChildBirth"]['location_id'] = $session->read('locationid');
            $dob_date_time =  $data['ChildBirth']['dob'];
            $data["ChildBirth"]['dob'] = DateFormatComponent::formatDate2STD($dob_date_time,Configure::read('date_format')) ;
            return $this->save($data);
      }  
}
?>