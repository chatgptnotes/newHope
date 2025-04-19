<?php
//SpecimenActionCode0065

class ObservationResultStatus0085 extends AppModel {
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $name = 'ObservationResultStatus0085';



	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * hasMany associations
	 *
	 * @var array
	 */

	public $specific = true;
	public $useTable='observation_result_status_0085';
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}

}