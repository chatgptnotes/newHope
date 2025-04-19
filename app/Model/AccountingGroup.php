<?php 
class AccountingGroup extends AppModel {
	
	public $name = 'AccountingGroup';
	//var $useTable = 'insurance_groups';
	public $specific = true;
	public $useTable = 'accounting_groups';
	
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}
	
	function group_add($data,$id=null){
		$session = new cakeSession();
		$data['AccountingGroup']['location_id']=$session->read('locationid');
		if(!empty($id)){
			$data['AccountingGroup']['id']=$id;
			$data['AccountingGroup']['modified_time']=date("Y-m-d H:i:s");
			$result=$this->save($data['AccountingGroup']);
		}else {
			$old_data = $this->find('count',array('conditions'=>array('AccountingGroup.name'=>trim($data['AccountingGroup']['name']),
					'AccountingGroup.is_deleted'=>0,'AccountingGroup.location_id'=>$session->read('locationid'))));
			if($old_data == 0){
				$data['AccountingGroup']['user_type']='User';
				$data['AccountingGroup']['created_time']=date("Y-m-d H:i:s");
				$result=$this->save($data);
			}else{
				return $result;
			}
		}
		return $result;	
	}
	
	/**
	 * it is only for Corporate company entry in Accounting Group by amit jain. 
	 * @param array $data array of Accounting Group Entry
	 */
	public function insertAccountingGroup($data=array()){
		$session = new CakeSession();
		
		$data['location_id'] = $session->read('locationid') ;
		$data['created_time'] = date('Y-m-d H:i:s') ;
		return $this->save($data) ;
	}
	
	//return id for all config define name by amit jain
	function getAccountingGroupID($name){
		$session = new CakeSession();
		$result = $this->find('first',array('fields'=>array('id'),
				'conditions'=>array('OR'=>array('code_name'=>$name,'name'=>$name),'location_id'=>$session->read('locationid'),'is_deleted'=>0)));
		return $result['AccountingGroup']['id'];
	}
	
	//return Sundry Creditors id by amit jain
	 function getSundryCreditorsID(){
		$session = new CakeSession();
		$sundryCreditorLabel = Configure::read('sundry_creditors') ;
		$result = $this->find("first",array("conditions"=>array("AccountingGroup.name"=>$sundryCreditorLabel,
				'AccountingGroup.location_id'=>$session->read('locationid'),'AccountingGroup.is_deleted'=>0)));
		return $result['AccountingGroup']['id'];
	} 
	
	function getAccountIdByName($name){
		$session = new CakeSession();
		$result = $this->find('list',array('fields'=>array('id'),'conditions'=>array('OR'=>array('AccountingGroup.name'=>$name,
				'AccountingGroup.code_name'=>$name),'AccountingGroup.location_id'=>$session->read('locationid'),'AccountingGroup.is_deleted'=>0)));
		return($result);
	}
	
	//return group id by amit jain
	//$id  = tariffStandard id or corporate sub location id
	//$name = tariffStandard name or corporate sub location name
	function getGroupId($id,$name){
		$session = new CakeSession();
		$subGroupData = $this->find("first",array('fields'=>array('AccountingGroup.id'),
				"conditions"=>array("AccountingGroup.system_user_id"=>$id,'AccountingGroup.user_type'=>$name,
						'AccountingGroup.location_id'=>$session->read('locationid'),'AccountingGroup.is_deleted'=>0)));
		return $subGroupData['AccountingGroup']['id'];
	}
	
	//return group name by id - amit jain
	function getGroupNameById($id){
		$session = new CakeSession();
		$groupData = $this->find("first",array('fields'=>array('AccountingGroup.name'),
				"conditions"=>array("AccountingGroup.id"=>$id,'AccountingGroup.location_id'=>$session->read('locationid'),'AccountingGroup.is_deleted'=>0)));
		return $groupData['AccountingGroup']['name'];
	}
	
	//return parent id by id - amit jain
	function getParentId($id){
		$session = new CakeSession();
		$groupData = $this->find("first",array('fields'=>array('AccountingGroup.parent_id'),
				"conditions"=>array("AccountingGroup.id"=>$id,'AccountingGroup.location_id'=>$session->read('locationid'),'AccountingGroup.is_deleted'=>0)));
		return $groupData['AccountingGroup']['parent_id'];
	}
	/*
	 function for return all groups name by amit jain
	 */
	function getAllGroup(){
		$session = new CakeSession();
		return $this->find('list',array('fields'=>array('AccountingGroup.id','AccountingGroup.name'),
				'conditions'=>array('AccountingGroup.location_id'=>$session->read('locationid'),'AccountingGroup.is_deleted'=>0),
				'order'=>array('AccountingGroup.name'=>'asc')));
	}

	/**
	 * fetch all group data function
	 * By Mahalaxmi
	 * @params location_id, account_type
	 * return result query
	 */
	function getAllGroupByType($location_id=null,$accType=array()){
		$result=$this->find('all',array('fields'=>array('AccountingGroup.id','AccountingGroup.name','AccountingGroup.account_type'),
				'conditions'=>array("AccountingGroup.is_deleted"=>0,'AccountingGroup.location_id'=>$location_id,
						'AccountingGroup.account_type'=>$accType/*,'AccountingGroup.parent_id'=>"0"*/),
				'order' => array ('AccountingGroup.name'=>'ASC')));	
		return $result;
	}

	/**
	 * fetch all group data function
	 * By Mahalaxmi
	 * @params location_id
	 * return result query
	 */
	function getAllGroupDetails($location_id=null,$accType=array()){		
		$accType=array_merge($accType,array('0'=>''));	//Empty as identify for subgroup	
		$result=$this->find('all',array('fields'=>array('AccountingGroup.id','AccountingGroup.name','AccountingGroup.account_type','AccountingGroup.parent_id'),'conditions'=>array('AccountingGroup.account_type'=>$accType,"AccountingGroup.is_deleted"=>0,'AccountingGroup.location_id'=>$location_id),'order' => array ('AccountingGroup.id'=>'ASC')));						
		return $result;
	}		

}
?>