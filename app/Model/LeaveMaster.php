<?php
class LeaveMaster extends AppModel {

	public $name = 'LeaveMaster';


	public $specific = true;
	public function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}

	public function getLeaveDetails($conditions){
		$user=ClassRegistry::init('User');
		$Role=ClassRegistry::init('Role');
		if($conditions['User.id']){
			$user->unbindModel(array('belongsTo'=>array('City','State','Country')));
			$user->bindModel(array('belongsTo'=>array(
						'EmpLeaveBenefit'=>array('foreignKey'=>false,'conditions'=>array('User.id=EmpLeaveBenefit.user_id')),
						'Role'=>array('foreignKey'=>false,'conditions'=>array('User.role_id=Role.id')),
						'LeaveMaster'=>array('foreignKey'=>false,
							'conditions'=>array('LeaveMaster.role_id=Role.id')),
					)));
			$model='User';
			$modelData=$user;
			
		}else{		
			$Role->bindModel(array(
					'belongsTo'=>array(
							'LeaveMaster'=>array('foreignKey'=>false,
									'conditions'=>array('LeaveMaster.role_id=Role.id')),
							'EmpLeaveBenefit'=>array('foreignKey'=>false,
									'conditions'=>array('Role.id=EmpLeaveBenefit.role_id')),
							)),false);
			$model='Role';
			$modelData=$Role;
		}
		
		$leaveDetails=$modelData->find('all',array('conditions'=>array($conditions)));
		
		if($model=='User'){
			$roleLeaves['role_id']=$leaveDetails['0']['Role']['id'];
			$roleLeaves['role_name']=$leaveDetails['0']['Role']['name'];
			$roleLeaves['leaves']=$leaveDetails['0']['LeaveMaster']['leaves_alotted'];
			$i=0;
			foreach($leaveDetails as $key=>$emp){
				$user_leaves[$i]['user_id']=$emp['User']['id'];
				$user_leaves[$i]['department_id']=$emp['User']['department_id'];
				$user_leaves[$i]['name']= $emp['User']['first_name'].' '.$emp['User']['last_name'];
				$user_leaves[$i]['leaves']=$emp['EmpLeaveBenefit']['alotted_leaves'];
				$i++;
			}
		}else{
			$roleLeaves['role_id']=$leaveDetails['0']['Role']['id'];
			$roleLeaves['role_name']=$leaveDetails['0']['Role']['name'];
			$roleLeaves['leaves']=$leaveDetails['0']['LeaveMaster']['leaves_alotted'];
			$i=0;
			foreach($leaveDetails['0']['User'] as $key=>$emp){
				$user_leaves[$i]['user_id']=$emp['id'];
				$user_leaves[$i]['department_id']=$emp['department_id'];
				$user_leaves[$i]['name']= $emp['first_name'].' '.$emp['last_name'];
				$user_leaves[$i]['leaves']=$leaveDetails[$key]['EmpLeaveBenefit']['alotted_leaves'];
				$i++;
			}
			
		}
		$leaveDetail['role_leave']=$roleLeaves;
		$leaveDetail['user_leaves']=$user_leaves;
		return $leaveDetail;
	}
	
	/**
	 * function to save data in leave master
	 * @param unknown_type $data
	 */
	function saveRoleLeave($data){
		$session=new CakeSession();
		$prevData=$this->find('first',array('conditions'=>array('role_id'=>$data['role_id'])));
		if(!empty($prevData)){
			$this->save(array(
					'id'=>$prevData['LeaveMaster']['id'],
					'role_id'=>$data['role_id'],
					'leaves_alotted'=>serialize($data['leave']),
					'location_id'=>$session->read('locationid'),
					'modified_by'=>$session->read('userid'),
					'modified_time'=>date('Y-m-d H:i:s'),
			));
		}else{
			$this->save(array(
					'role_id'=>$data['role_id'],
					'leaves_alotted'=>serialize($data['leave']),
					'location_id'=>$session->read('locationid'),
					'created_by'=>$session->read('userid'),
					'created_time'=>date('Y-m-d H:i:s'),
				));
		}
	}

}?>