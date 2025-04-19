<?php
class OtItemCategory extends AppModel {

	public $name = 'OtItemCategory';
	
        
        public $validate = array(
		        'name' => array(
			    'rule' => "notEmpty",
			    'message' => "Please enter name."
			    ),
                'name' => array(
			    'rule' => array('checkUnique'),
			    'message' => "Please enter unique name."
			    ),
                'description' => array(
			    'rule' => "notEmpty",
			    'message' => "Please enter description."
			    )
		
                );

        public function checkUnique($check) {
                //$check will have value: array('username' => 'some-value')
                if(isset($this->data['OtItemCategory']['id'])) {
                 $extraContions = array('is_deleted' => 0, 'location_id' => AuthComponent::user('location_id'), 'id <>' => $this->data['OtItemCategory']['id']);
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