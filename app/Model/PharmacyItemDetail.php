<?php
class PharmacyItemDetail extends AppModel {

	public $name = 'PharmacyItemDetail';

	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		if(empty($ds)){
        	$session = new cakeSession();
			$this->db_name =  $session->read('db_name');
	 	}else{
	 		$this->db_name =  $ds;
	 	}
		parent::__construct($id, $table, $ds);
	}
	
	function beforeFind(){
		if (isset($this->data[$this->alias]['is_deleted'])) {
			$this->data[$this->alias]['is_deleted'] = 0;
		}
		return true ;
	}
}
?>