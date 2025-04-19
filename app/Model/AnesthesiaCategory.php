<?php
class AnesthesiaCategory extends AppModel {

	public $name = 'AnesthesiaCategory';

	public $validate = array(
			'name' => array(
					'rule' => "notEmpty",
					'message' => "Please enter name."
			),
			'description' => array(
					'rule' => "notEmpty",
					'message' => "Please enter description."
			)

	);

	/**
	 * for delete Anesthesia subcategory.
	 *
	*/

	public function deleteAnesthesiaCategory($postData) {
		$this->id = $postData['pass'][0];
		$this->data["AnesthesiaCategory"]["id"] = $postData['pass'][0];
		$this->data["AnesthesiaCategory"]["is_deleted"] = '1';
		$this->save($this->data);
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