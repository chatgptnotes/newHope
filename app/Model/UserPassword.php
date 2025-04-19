<?php
/**
 * 
 *Model used only for updating USER's password
 *@created by :pankaj 
 *@table :User
 */

class UserPassword extends AppModel {

	public $name = 'UserPassword';
	public $useTable = 'users';
	 
	
	
	public function beforeSave() {
		if (isset($this->data[$this->alias]['password'])) {
			$this->data[$this->alias]['password'] = sha1($this->data[$this->alias]['password']);
               	}
		return true;
	}
	 public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    } 
}
	
?>