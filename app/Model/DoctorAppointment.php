<?php
class DoctorAppointment extends AppModel {

	public $name = 'DoctorAppointment';
	var $useTable = 'appointments';	

	public $belongsTo = array('Patient' => array('className'    => 'Patient',
                                                  'foreignKey'    => 'patient_id'
                                                 ),
                                  'Location' => array('className'    => 'Location',
                                                   'foreignKey'    => 'location_id'
                                                 ),
                                  'Doctor' => array('className'    => 'Doctor',
                                                     'foreignKey'    => 'doctor_id'
                                                 ),
                                  'Department' => array('className'    => 'Department',
                                                     'foreignKey'    => 'department_id'
                                                 )
                                  );
	      public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }  
       
}
?>