<?php
class EmpLeaveBenefit extends AppModel {

	public $name = 'EmpLeaveBenefit';


	public $specific = true;
	public function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}
	
	function saveEmpLeave($data){
		$session = new CakeSession();
		foreach($data['user_id'] as $eKey=>$emp){
			$emp_detail=$this->find('first',array('conditions'=>array('user_id'=>$emp)));
			if(!empty($emp_detail)){
				$empArr['id']=$emp_detail['EmpLeaveBenefit']['id'];
				$empArr['modified_time']=date('Y-m-d H:i:s');
				$empArr['modified_by']=$session->read('userid');
			}else{
				$empArr['created_time']=date('Y-m-d H:i:s');
				$empArr['created_by']=$session->read('userid');
			}
			$empArr['user_id']=$emp;
			$empArr['role_id']=$data['role_id'];
			$empArr['department_id']=$data[$eKey]['department_id'];
			$empArr['alotted_leaves']=serialize($data['leave'][$emp]);
			$this->save($empArr);
			$this->id='';
		}
		return true;
	}
	
	public function getEmployeeLeaveDetails($emp_id){
		$this->bindModel(array(
				'belongsTo'=>array(
						'LeaveTransaction'=>array('foreignKey'=>false,'conditions'=>array()),
						)));
	}

        public function getEmpLeaveDetail($userId){
            if(empty($userId)) return;
            $result = $this->find('first',array(
                'fields'=>array(
                    'alotted_leaves'
                ),
                'conditions'=>array(
                    'EmpLeaveBenefit.user_id'=>$userId
                )   
            ));
            if(!empty($result)){
                return unserialize($result['EmpLeaveBenefit']['alotted_leaves']);
            }
        }

}?>