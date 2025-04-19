 <?php

class Recipient extends AppModel {

	public $name = 'Recipient';
	var $useTable = 'recipients';

	public $validate = array(
			'name' => array(
					'rule' => "notEmpty",
					'message' => "Please enter name."
			)
	);

	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}

}
?>
