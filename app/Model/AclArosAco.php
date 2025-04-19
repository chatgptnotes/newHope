<?php
class AclArosAco extends AppModel {

	public $name = 'AclArosAco';
        public $useTable = 'aros_acos';
    
        public $belongsTo = array(
        'AclAro' => array(
            'className' => 'Acl.AclAro',
            'foreignKey' => 'aro_id',
        ),
        'AclAco' => array(
            'className' => 'Acl.AclAco',
            'foreignKey' => 'aco_id',
        ),
    );
 public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    } 
}