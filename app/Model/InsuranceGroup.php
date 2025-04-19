<?php 
class InsuranceGroup extends AppModel {
	
	
	public $name = 'InsuranceGroup';
	//var $useTable = 'insurance_groups';
	public $specific = true;
	public $useTable = 'insurance_groups';
	
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}
	
	function group_add($data,$id=null){
		$session = new cakeSession();
		
		$data['InsuranceGroup']['location_id']=$session->read('locationid');
		if(!empty($id))
		{
			$data['InsuranceGroup']['modified_time']=date("Y-m-d H:i:s");
			$result=$this->update($data,array('conditions'=>array('InsuranceGroup.id'=>$id)));
		
		}else {
			$data['InsuranceGroup']['created_time']=date("Y-m-d H:i:s");
			$result=$this->save($data);
		}
		return $result;	
		
	}
}
?>

