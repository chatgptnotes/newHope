<?php
class StaffPlan extends AppModel {

	public $name = 'StaffPlan';
	public $belongsTo = array('User' => array('className'    => 'User',
                                                  'foreignKey'    => 'user_id'
                                                 ),
                              'Initial' => array('className'    => 'Initial',
                                                  'foreignKey'    => false,
                                                   'conditions' => array('Initial.id=User.initial_id')
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