<?php
	class PharmacyReturnDetail extends AppModel {
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $name = 'PharmacyReturnDetail';
	var $useTable = 'pharmacy_return_details';
	
	public $specific = true;

	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}
}
?>