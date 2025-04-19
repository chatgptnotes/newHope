<?php
class SymptomMaster extends AppModel{
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $name = 'SymptomMaster';
	var $useTable = 'symptom_masters';

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * hasMany associations
	 *
	 * @var array
	 */

	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}
}