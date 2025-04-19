<?php
class ReffererDoctor extends AppModel {

	public $name = 'ReffererDoctor';
	public $validate = array(
                'name' => array(
			'rule' => "notEmpty",
			'message' => "Please enter name"
			),
                'description' => array(
			'rule' => "notEmpty",
			'message' => "Please enter description"
			)
                );
			
/**
 * for delete refferer doctor.
 *
 */
      public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }  
      public function deleteReffererDoctor($postData) {
      	$this->id = $postData['pass'][0];
      	$this->data["ReffererDoctor"]["id"] = $postData['pass'][0];
      	$this->data["ReffererDoctor"]["is_deleted"] = '1';
      	$this->save($this->data);
      	return true;
      }
}
?>