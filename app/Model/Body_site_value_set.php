<?php
//SpecimenActionCode0065

class Body_site_value_set extends AppModel {
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $name = 'Body_site_value_set';



	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * hasMany associations
	 *
	 * @var array
	 */

	public $specific = true;
	public $useTable='body_site_value_set';
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}

}