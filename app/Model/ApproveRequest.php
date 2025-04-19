<?php
/**
 * 
 * @author Node-7
 *
 */
class ApproveRequest extends AppModel {
	
	public $name = 'ApproveRequest';


	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}

	function saveRequest($data=array()){
		$session = new cakeSession();
		$data['create_time'] = date("Y-m-d H:i:s");
			
		$data['request_by']	 = $session->read('userid');
		$data['location_id'] = $session->read('locationid');
		$data['created_by']	 = $session->read('userid');
		$data['modified_id'] = $session->read('userid');
		return $this->save($data);
	}
		
	function UpdateApprovalStatus($data = array()){
		$updateArray = array('ApproveRequest.is_approved'=>"'$data[is_approved]'",'ApproveRequest.modified_time'=>"'".date("Y-m-d H:i:s")."'") ;
		$this->updateAll($updateArray,array('ApproveRequest.id '=>$data['id']));
	}
		
	function deleteRequest($data = array())
	{
		$session = new cakeSession();
		$val = $this->find('first',array('fields'=>'id','conditions'=>array('ApproveRequest.patient_id'=>$data['patient_id'],
				'ApproveRequest.request_by'=>$session->read('userid'),'ApproveRequest.request_to'=>$data['request_to'],
				'ApproveRequest.type'=>$data['type']),
				'order'=>array('ApproveRequest.id'=>"DESC")));
			
		$this->id = $val['ApproveRequest']['id'];		//primaruy id of approval_request
		$updateArray['is_approved'] = '0';		// unset approval
		$updateArray['is_deleted'] = '1';		// delete
		$this->updateAll($updateArray,array('ApproveRequest.id '=>$val['ApproveRequest']['id']));
	}

}
?>