<?php
class AuditLogPermission extends AppModel {

	public $name = 'AuditLogPermission';
	public $useTable = 'audit_log_permission';
        		
	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }  
    
    public $validate = array(
    		'user_id' => array(
    				'rule' => "notEmpty",
    				'message' => "Please select username."
    		),
    		'model' => array(
    				'rule' => "notEmpty",
    				'message' => "Please select module."
    		)
    		    
    );
}
?>