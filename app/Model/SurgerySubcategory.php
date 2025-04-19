<?php
class SurgerySubcategory extends AppModel {

	public $name = 'SurgerySubcategory';
	public $belongsTo = array('SurgeryCategory' => array('className'    => 'SurgeryCategory',
                                                  'foreignKey'    => 'surgery_category_id'
                                                 )
                                 );
        public $validate = array(
		        'surgery_id' => array(
			    'rule' => "notEmpty",
			    'message' => "Please select surgery."
			    ),
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
 * for delete surgery subcategory.
 *
 */

      public function deleteSurgerySubcategory($postData) {
      	$this->id = $postData['pass'][0];
      	$this->data["SurgerySubcategory"]["id"] = $postData['pass'][0];
      	$this->data["SurgerySubcategory"]["is_deleted"] = '1';
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