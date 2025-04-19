<?php
class OptAppointmentDetail extends AppModel {

	public $name = 'OptAppointmentDetail';
	public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }
    
    public function saveData($data=array()){
    	if(!empty($data)){
    		if($this->save($data)){
    			return true;
    		}
    	}
    }
}
?>