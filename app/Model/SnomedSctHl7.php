<?php
//SpecimenActionCode0065

class SnomedSctHl7 extends AppModel {
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $name = 'SnomedSctHl7';



	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * hasMany associations
	 *
	 * @var array
	 */

	public $specific = true;
	public $useTable='snomed_sct_hl7';
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}

}