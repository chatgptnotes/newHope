<?php 
/**
 * Chats controller
 *
 * Use to add/delete/view chats
 * created : 08.09.2015
 */
class ChatsController extends AppController {

	public $name = 'Chats';
	public $uses = array('Chat');
	public $helpers = array('Html','Form', 'Js','DateFormat');
	public $components = array('RequestHandler','Email','DateFormat','ScheduleTime');

	public function getChats($senderID,$limit=null){
		$this->autoRender = false;
		$myId = $this->Session->read('userid');
		$cond = array('OR'=>array(
								array('msg_to'=>$senderID,'msg_from'=>$myId),
								array('msg_to'=>$myId,'msg_from'=>$senderID)
							)
					);
		
		if(empty($limit)){
			$limit = 10;
		}
		$result = $this->Chat->find('all',array(
					'fields'=>array('msg_to','msg_from', 'message', 'msg_date','is_sent','is_received'),
					'conditions'=>array('is_deleted'=>'0',$cond),
					'order'=>array('id'=>'DESC'),
					'limit'=>$limit));
		$msgCount = $this->Chat->find('count',array('conditions'=>array($cond,'is_deleted'=>'0')));
		$result = array_reverse($result);
		foreach ($result as $key => $val){  
			if($val['Chat']['msg_from'] == $myId){
				$sender = "me";
			}else{
				$sender = "they";
			}
			$returnArr[] = array('msg_sender'=>$sender,'msg'=>$val['Chat']['message'],
							'is_sent'=>$val['Chat']['is_sent'],'is_received'=>$val['Chat']['is_received'],
							'msg_date'=>$this->DateFormat->formatDate2Local($val['Chat']['msg_date'],Configure::read('date_format'),true));
		}
		
		$this->Chat->updateAll(array('is_received'=>'1'),array('is_received'=>0,'msg_to'=>$myId));
		echo json_encode(array('returnData'=>$returnArr,'msgCount'=>$msgCount));
		exit;
	}	
	
	public function saveChats($sendToid){
		$this->autoRender = false;
		$myId = $this->Session->read('userid');
		$saveData = array();
		if(!empty($sendToid)){
			debug($this->request->data['msg']);
			$saveData['msg_to'] = $sendToid;
			$saveData['msg_from'] = $myId;
			$saveData['message'] = $this->request->data['msg'];
			$saveData['is_sent'] = '1';
			$saveData['msg_date'] = date("Y-m-d H:i:s");
			if($this->Chat->save($saveData)){
				echo "saved succss";
			}
		}
	}
	
	public function getUsers($status=null){
		$this->layout = false;
		$this->autoRender = false;
		$this->uses = array('User','UserSession'); 
		$loginedUser = $this->UserSession->getLoggedInUsersInner();
		$userDetails = $this->User->getUsers($this->Session->read('userid'));
		$allUserIds = array_keys($userDetails);
		$unReadMSgCount = $this->Chat->find('all',array(
				'fields'=>array('COUNT(id) as totalCount,msg_from'),
				'conditions'=>array('is_received'=>'0','msg_to'=>$this->Session->read('userid')),
				'group'=>'msg_from'));
		foreach($unReadMSgCount as $msgKey => $msgVal){
			$msgTotalUnreadCount += $msgUnReadCount[$msgVal['Chat']['msg_from']] = $msgVal[0]['totalCount'];
		} 
		$this->set(array('userDetails'=>$userDetails,'loginedUser'=>$loginedUser));
		$returnArr = array();
		if($status == "online"){
			$users = $this->User->getAllUserByIDs($loginedUser);
			foreach($users as $lKey => $lVal){
				if($lKey != $this->Session->read('userid')){
					$returnArr[] = array('is_active'=>'1','msgUnread'=>$msgUnReadCount[$lKey],'id'=>$lKey,'name'=>$lVal);
				}
			} 
		}else if($status == "offline"){
			$users = $this->User->getAllUserByIDs(array_diff($allUserIds, $loginedUser));
			foreach($users as $ofKey => $ofVal){
				$returnArr[] = array('is_active'=>'0','msgUnread'=>$msgUnReadCount[$ofKey],'id'=>$ofKey,'name'=>$ofVal);
			}
		}else if($status == "all"){
			$users = $userDetails;
			foreach($users as $ofKey => $ofVal){ 
				if(in_array($ofKey, $loginedUser)){
					$returnArr[] = array('is_active'=>'1','msgUnread'=>$msgUnReadCount[$ofKey],'id'=>$ofKey,'name'=>$ofVal);
				}else{
					$returnArr[] = array('is_active'=>'0','msgUnread'=>$msgUnReadCount[$ofKey],'id'=>$ofKey,'name'=>$ofVal);
				}
			}
		}
		$returnArr = $this->array_orderby($returnArr,'name');
		echo json_encode(array('returnArr'=>$returnArr,'totalUnreadMsg'=>$msgTotalUnreadCount));
		exit;
	}
	
	//function to sort by swapnil
	public function array_orderby()
	{
		$args = func_get_args();
		$data = array_shift($args);
		foreach($args as $n => $field) {
			if(is_string($field)) {
				$tmp = array();
				foreach($data as $key => $row){
					$tmp[$key] = $row[$field];
					$args[$n] = $tmp;
				}
			}
		}
		$args[] = &$data;
		call_user_func_array('array_multisort', $args);
		return array_pop($args);
	}
	
}