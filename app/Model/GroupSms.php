<?php
/**Mahalaxmi**/
class GroupSms extends AppModel {

	public $name = 'GroupSms';
	public $useTable = 'group_smses';
	public $validate = array(
		'name' => array(
			'rule' => "notEmpty",
			'message' => "Please enter Group."
			),
			'name' => array(
							'rule' => "checkUnique",
							'message' => "Group with this name is already exists.",							
							),
                );
	public $specific = true;
	public function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}
	public function saveData($data=array()){
		if(!empty($data)){			
				$this->save($data);	
				return $this->getLastInsertId();
		}
	}
	public function checkUnique($check){	
			if(!empty($this->id)){
				$conditions = array('id !='.$this->id,'GroupSms.name'=>$this->data['GroupSms']['name'],'GroupSms.is_deleted' => 0);
			}else{
				$conditions = array('GroupSms.name'=>$this->data['GroupSms']['name'],'GroupSms.is_deleted' => 0);
			}				
           $countUser = $this->find( 'count', array('conditions' => $conditions , 'recursive' => -1));		   
		   if($countUser > 0) {			  
              return false;
           } else {			   
              return true;
           }

      }
	 public function findGroupList(){
		 return $this->find('list',array('fields'=>array('GroupSms.id','GroupSms.name'),'conditions'=>array('GroupSms.is_deleted'=>0,'GroupSms.is_active'=>1)));
	 }
	
}