<?php
class MedicalItem extends AppModel {

	public $name = 'MedicalItem';  
        public $validate = array(
		        'name' => array(
			    'rule' => "notEmpty",
			    'message' => "Please enter name."
			    ),
                        'name' => array(
			    'rule' => array('checkUnique'),
			    'message' => "Please enter unique name."
			    ),
			    'ot_item_category_id' => array(
			    'rule' => "notEmpty",
			    'message' => "Please select ot item category."
			    ),
                'description' => array(
			    'rule' => "notEmpty",
			    'message' => "Please enter description."
			    )
		
                );

        public function checkUnique($check) {
                //$check will have value: array('username' => 'some-value')
                if(isset($this->data['OtItem']['id'])) {
                 $extraContions = array('is_deleted' => 0, 'location_id' => AuthComponent::user('location_id'), 'id <>' => $this->data['OtItem']['id']);
                } else {
                 $extraContions = array('is_deleted' => 0, 'location_id' => AuthComponent::user('location_id'));
                }
                $conditonsval = array_merge($check,$extraContions);
                $countOT = $this->find( 'count', array('conditions' => $conditonsval, 'recursive' => -1));
                if($countOT >0) {
                  return false;
                } else {
                  return true;
                }
        }
			
	
      
	public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }
}
?>