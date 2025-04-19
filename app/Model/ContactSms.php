<?php
class ContactSms extends AppModel {

	public $name = 'ContactSms';
	public $useTable = 'contact_smses';
	
	public $specific = true;
	public function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}
	public function saveData($data=array()){
		//debug($data);
		$session = new cakeSession();
		if(!empty($data)){
			$this->deleteAll(array('ContactSms.group_id'=>$data['ContactSms']['group_id']));
				$data['contact_name']=array_values($data['contact_name']);
				$data['contact_id']=array_values($data['contact_id']);
				$data['mobile']=array_values($data['mobile']);
				if(!empty($data['initial_id']))
					$data['initial_id']=array_values($data['initial_id']);
				//if(!empty($data['corporate_id']))
				//	$data['corporate_id']=array_values($data['corporate_id']);
				//if(!empty($data['sublocation_id']))
				//	$data['sublocation_id']=array_values($data['sublocation_id']);
				//if(!empty($data['other_info']))
				////	$data['other_info']=array_values($data['other_info']);
				//if(!empty($data['city_id']))
				//	$data['city_id']=array_values($data['city_id']);
				//debug($data);
				//unset($dataArr['corporate_id']);
				foreach($data['contact_name'] as $key=>$datas){
					//debug($data['corporate_id'][$key]);
					$dataArr['id']=$data['contact_id'][$key];
					$dataArr['name']=$datas;
					$dataArr['mobile']=$data['mobile'][$key];	
					if(!empty($data['initial_id'][$key])){
						$dataArr['initial_id']=$data['initial_id'][$key];	
					}
					if(!empty($data['corporate_id'][$key])){						
						$dataArr['corporate_id']=$data['corporate_id'][$key];
					}else{
						$dataArr['corporate_id']=null;
					}
					if(!empty($data['sublocation_id'][$key])){
						$dataArr['sublocation_id']=$data['sublocation_id'][$key];
					}else{
						$dataArr['sublocation_id']=null;
					}
					if(!empty($data['other_info'][$key])){
						$dataArr['other_info']=$data['other_info'][$key];
					}else{
						$dataArr['other_info']=null;
					}
					if(!empty($data['city_id'][$key])){
						$dataArr['city_id']=$data['city_id'][$key];
					}else{
						$dataArr['city_id']=null;
					}
					$dataArr['group_id']=$data['ContactSms']['group_id'];						
					$dataArr['location_id']=$session->read('locationid');	
					
					if(!empty($data['contact_id'][$key])){
						$dataArr['modified_by']=$session->read('userid');
						$dataArr['modified_time']=date('Y-m-d H:i:s');									
					}else{		
						$dataArr['created_by']=$session->read('userid');
						$dataArr['created_time']=date('Y-m-d H:i:s');							
					}      
				//debug($dataArr);
				 $this->save($dataArr);  
				}
				//exit;
				
				
		}
	}
	public function findContactAllByIds($ids){		
		$this->bindModel(array(
				'belongsTo'=>array(
						'GroupSms' =>array('foreignKey' => false,'conditions'=>array('ContactSms.group_id=GroupSms.id' )),			
				)));		
		return $this->find('all',array('fields'=>array('ContactSms.*','GroupSms.*'),'conditions'=>array('ContactSms.id'=>$ids)));
	 }
	 public function findContactListByIds($ids){
		 return $this->find('list',array('fields'=>array('ContactSms.id','ContactSms.name'),'conditions'=>array('ContactSms.group_id'=>$ids)));
	 }

	
}