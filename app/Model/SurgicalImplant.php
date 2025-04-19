<?php
/**Mahalaxmi**/
class SurgicalImplant extends AppModel {

	public $name = 'SurgicalImplant';
	public $useTable = 'surgical_implants';
	public $validate = array(
		'name' => array(
			'rule' => "notEmpty",
			'message' => "Please enter name."
			),
			'name' => array(
							'rule' => "checkUnique",
							'message' => "implant name with this name is already exists.",							
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
				$conditions = array('id !='.$this->id,'SurgicalImplant.name'=>$this->data['SurgicalImplant']['name'],'SurgicalImplant.is_deleted' => 0);
			}else{
				$conditions = array('SurgicalImplant.name'=>$this->data['SurgicalImplant']['name'],'SurgicalImplant.is_deleted' => 0);
			}				
           $countUser = $this->find( 'count', array('conditions' => $conditions , 'recursive' => -1));		   
		   if($countUser > 0) {			  
              return false;
           } else {			   
              return true;
           }

      }
	 public function findSurgicalImplantFirst($implantId){
		 return $this->find('first',array('fields'=>array('SurgicalImplant.id','SurgicalImplant.name'),'conditions'=>array('SurgicalImplant.id'=>$implantId,'SurgicalImplant.is_deleted'=>0,'SurgicalImplant.is_active'=>1)));
	 }
	 public function findSurgicalImplantList(){
		 return $this->find('list',array('fields'=>array('SurgicalImplant.id','SurgicalImplant.name'),'conditions'=>array('SurgicalImplant.is_deleted'=>0,'SurgicalImplant.is_active'=>1)));
	 }
	
}