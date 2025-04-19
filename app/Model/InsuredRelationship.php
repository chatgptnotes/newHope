
<?php



class InsuredRelationship extends AppModel {
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $name = 'InsuredRelationship';
	var $useTable = 'insured_relationships';	

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
}
?>