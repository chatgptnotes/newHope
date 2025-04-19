<?php
/**
 * spot approval for hope hospital
 * @author Node-17
 * Pooja Gupta
 */

class SpotApproval extends AppModel {
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $name = 'SpotApproval';



	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * hasMany associations
	 *
	 * @var array
	 */

	public $specific = true;
	//public $useTable='specimen_role';
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}

}