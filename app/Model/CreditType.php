<?php
class CreditType extends AppModel {

	public $name = 'CreditType';
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
 * for delete credit type.
 *
 */
      public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }  
      public function deleteCreditType($postData) {
      	$this->id = $postData['pass'][0];
      	$this->data["CreditType"]["id"] = $postData['pass'][0];
      	$this->data["CreditType"]["is_deleted"] = '1';
      	$this->save($this->data);
      	return true;
      }
	
}
?>