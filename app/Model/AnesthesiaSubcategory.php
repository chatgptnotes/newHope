<?php
class AnesthesiaSubcategory extends AppModel {

	public $name = 'AnesthesiaSubcategory';
	public $belongsTo = array('AnesthesiaCategory' => array('className'    => 'AnesthesiaCategory',
                                                  'foreignKey'    => 'anesthesia_category_id'
                                                 )
                                 );
        public $validate = array(
		        'anesthesia_id' => array(
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
 * for delete anesthesia subcategory.
 *
 */

      public function deleteAnesthesiaSubcategory($postData) {
      	$this->id = $postData['pass'][0];
      	$this->data["AnesthesiaSubcategory"]["id"] = $postData['pass'][0];
      	$this->data["AnesthesiaSubcategory"]["is_deleted"] = '1';
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