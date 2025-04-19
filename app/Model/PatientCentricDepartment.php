<?php
class PatientCentricDepartment extends AppModel {

	public $name = 'PatientCentricDepartment';
    public $specific = true;
	public $validate = array(
    'name' => array(
        'isUnique' => array(
                'rule' => 'isUnique',
                'message' => 'Department Name must be unique.'
        	)
    	)
	);

	function isUnique() {
 	$session = new cakeSession();
		return ($this->find('count', array('conditions' => array('name' => $this->data['PatientCentricDepartment']['name'],"location_id" => $session->read('locationid'),"is_deleted"=>0))) ==0);
	}
	function __construct($id = false, $table = null, $ds = null) {
	        $session = new cakeSession();
			$this->db_name =  $session->read('db_name');
	        parent::__construct($id, $table, $ds);
    }


}
?>