<?php
class Opt extends AppModel {

	public $name = 'Opt';
	
        
        public $validate = array(
		        'number' => array(
			    'rule' => "notEmpty",
			    'message' => "Please enter number."
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
                if(isset($this->data['Opt']['id'])) {
                 $extraContions = array('is_deleted' => 0, 'location_id' => AuthComponent::user('location_id'), 'id <>' => $this->data['Opt']['id']);
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
			
	
/**
 * for delete Opt.
 *
 */

      public function deleteOpt($postData) {
      	$this->id = $postData['pass'][0];
      	$this->data["Opt"]["id"] = $postData['pass'][0];
      	$this->data["Opt"]["is_deleted"] = '1';
      	$this->save($this->data);
      	return true;
      }	
      
	public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }
    
    
    function getOtRoomList(){
    	return $this->find('list',array('conditions'=>array('is_deleted'=>0),'fields'=>array('id','name')));
    }
}
?>