<?php
class PoliceForm extends AppModel {

	public $name = 'PoliceForm';
	public $specific = true;
	

	public $belongsTo = array('Patient' => array('className'    => 'Patient',
                                                  'foreignKey'    => 'patient_id'
                                                 )
                              );
        
        public $validate = array(
            'address' => array(
			'rule' => "notEmpty",
			'message' => "Please enter address."
			),
            'taluka' => array(
			'rule' => "notEmpty",
			'message' => "Please enter taluka."
			),
			'district' => array(
			'rule' => "notEmpty",
			'message' => "Please enter district."
			)
                );

   
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }         
			
	
}
?>