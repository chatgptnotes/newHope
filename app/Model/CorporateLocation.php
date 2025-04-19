<?php
class CorporateLocation extends AppModel {

	public $name = 'CorporateLocation';
	
        
        public $validate = array(
                'name' => array(
			'rule' => "notEmpty",
			'message' => "Please enter name."
			),
                'description' => array(
			'rule' => "notEmpty",
			'message' => "Please enter description."
			),
		
                );
			
	
/**
 * for delete corporate location.
 *
 */
      public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }  
      public function deleteCorporateLocation($postData) {
      	$this->id = $postData['pass'][0];
      	$this->data["CorporateLocation"]["id"] = $postData['pass'][0];
      	$this->data["CorporateLocation"]["is_deleted"] = '1';
      	$this->save($this->data);
      	return true;
      }	
}
?>