<?php
class InsuranceType extends AppModel {

	public $name = 'InsuranceType';
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
 * for delete insurance type.
 *
 */

      public function deleteInsuranceType($postData) {
      	$this->id = $postData['pass'][0];
      	$this->data["InsuranceType"]["id"] = $postData['pass'][0];
      	$this->data["InsuranceType"]["is_deleted"] = '1';
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