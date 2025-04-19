<?php
class HospitalRate extends AppModel {

	public $name = 'HospitalRate';
    public $specific = true;
    
    public $validate = array(
		'facility_id' => array(
			'rule' => "notEmpty",
			'message' => "Please select hospital."
			),
		'ipd_rate' => array(
			'rule' => "notEmpty",
			'message' => "Please enter IPD rate."
			),
		'opd_rate' => array(
			'rule' => "notEmpty",
			'message' => "Please enter OPD rate."
			),
         'emergency_rate' => array(
			'rule' => "notEmpty",
			'message' => "Please enter emergency rate."
			),
		'facility_id' => array(
			'rule' => array('checkUnique'),
			'on' => 'create',
			'message' => "Hospital rate is already exist."
			)
             
        );
        
public function checkUnique($check){
                //$check will have value: array('username' => 'some-value')
                $extraContions = array('is_deleted' => 0);
                $conditonsval = array_merge($check,$extraContions);
                $countUser = $this->find( 'count', array('conditions' => $conditonsval, 'recursive' => -1) );
                if($countUser >0) {
                  return false;
                } else {
                  return true;
                }
               }
    
	public function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }  
    
}
?>