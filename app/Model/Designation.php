<?php
class Designation extends AppModel {

	public $name = 'Designation';
        		
	public $validate = array(
		'name' => array(
			'rule' => "notEmpty",
			'message' => "Please enter name."
			),
			'name' => array(
							'rule' => "checkUnique",
							'message' => "Designation with this name is already exists.",
							
							),
                );
        
	 public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    } 
	
		public function checkUnique($check){
			$session = new cakeSession();
			if(!empty($this->id)){
				$conditions = array('id !='.$this->id,'location_id'=>$session->read('locationid'),'name'=>$this->data['Designation']['name'],'is_deleted' => 0);
			}else{
				$conditions = array('location_id'=>$session->read('locationid'),'name'=>$this->data['Designation']['name'],'is_deleted' => 0);
			}
           $countUser = $this->find( 'count', array('conditions' => $conditions , 'recursive' => -1));
           if($countUser > 0) {
              return false;
           } else {
              return true;
           }
        }
}
?>