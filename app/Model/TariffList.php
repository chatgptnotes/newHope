<?php
/**
 * ServiceCategory file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Bed Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Mayank Jain
 */

	
	
	class TariffList extends AppModel {
	
	
	public $name = 'TariffList';
		
	public $specific = true;
			function __construct($id = false, $table = null, $ds = null) {

				if(empty($ds)){
					$session = new cakeSession();
					$this->db_name =  $session->read('db_name');
				}else{
					$this->db_name =  $ds;
				}
				parent::__construct($id, $table, $ds);
   
			}
				
				
			//function to return services of selected service group
	
			function getServiceByGroupId($id=null){

				if(empty($id)) return ; 
				$this->query("SET CHARACTER SET utf8");
				$tariffList = $this->find('list',array('conditions'=>array('service_category_id'=>$id,'is_deleted'=>0),'order'=>array('name DESC')));

				return $tariffList ;
			} 
	
	
				
				
	/**
	 * afterSave function for saving data in account table--Amit
	 *
	 **/
	
	public function afterSave($created){
		//For generating account code for account table
		$session = new CakeSession();
		$getAccount = Classregistry::init('Account');
		$accountingGroup = Classregistry::init('AccountingGroup');
		$getIncomesName = Configure::read('acc_income_group_name');
		$groupId = $accountingGroup->getAccountingGroupID($getIncomesName['direct incomes']);
		$count = $getAccount->find('count',array('conditions'=>array('Account.create_time like'=> "%".date("Y-m-d")."%",'Account.location_id'=>$session->read('locationid'))));
		$count++ ; //count currrent entry also
		if($count==0){
			$count = "001" ;
		}else if($count < 10 ){
			$count = "00$count"  ;
		}else if($count >= 10 && $count <100){
			$count = "0$count"  ;
		}
		$month_array = array('A','B','C','D','E','F','G','H','I','J','K','L');
		//find the Hospital name.
		$hospital = $session->read('facility');
		//creating patient ID
		$unique_id   = 'TL';
		$unique_id  .= ucfirst(substr($hospital,0,1)); //first letter of the hospital name
		$unique_id  .= strtoupper(substr($session->read('location'),0,2));//first 2 letter of d location
		$unique_id  .= date('y'); //year
		$unique_id  .= $month_array[date('n')-1];//first letter of month
		$unique_id  .= date('d');//day
		$unique_id .= $count;
		if($created){
			if($this->data['TariffList']['is_deleted']==1){
				return ; //return if delete
			}
			$this->data['Account']['create_time']=date("Y-m-d H:i:s");
			$this->data['Account']['account_code']=$unique_id;
			$this->data['Account']['status']='Active';
			$this->data['Account']['name']=$this->data['TariffList']['name'];
			$this->data['Account']['user_type']='TariffList';
			$this->data['Account']['system_user_id']=$this->data['TariffList']['id'];
			$this->data['Account']['location_id']=$this->data['TariffList']['location_id'];
			$this->data['Account']['accounting_group_id']=$groupId;
			$getAccount->save($this->data['Account']);
		}else{
			$var=$getAccount->find('first',array('fields'=>array('id'),'conditions'=>array('system_user_id'=>$this->data['TariffList']['id'],'user_type'=>'TariffList','Account.location_id'=>$session->read('locationid'))));
			
			//avoid delete updatation
			if($this->data['TariffList']['is_deleted']==1){
				$getAccount->updateAll(array('is_deleted'=>1), array('Account.system_user_id' => $this->data['TariffList']['id'],'Account.user_type'=>'TariffList','Account.location_id'=>$session->read('locationid')));
				return ;
			}
			if(!empty($this->data['TariffList']['name'])){
				if(empty($var['Account']['id']))
				{
					$this->data['Account']['account_code']=$unique_id;
					$this->data['Account']['create_time']=date("Y-m-d H:i:s");
					$this->data['Account']['status']='Active';
				}
				$this->data['Account']['name']=$this->data['TariffList']['name'];
				$this->data['Account']['user_type']='TariffList';
				$this->data['Account']['system_user_id']=($this->data['TariffList']['id'])?$this->data['TariffList']['id']:$this->id;
				$this->data['Account']['accounting_group_id']=$groupId;
				$this->data['Account']['id']=$var['Account']['id'];
				$this->data['Account']['modify_time']=date("Y-m-d H:i:s");
				$this->data['Account']['location_id'] = $session->read('locationid');
				$getAccount->save($this->data['Account']);
			}
		}
	}
	
	
	//get sevice id by name
	function getServiceIdByName($codeName=null){
		$session = new CakeSession();
		
		if(empty($codeName)) return;
		$tariffListId = $this->find('first',array('fields'=>array('id'),'conditions'=>array('TariffList.code_name'=>$codeName,'TariffList.is_deleted'=>'0',
				'TariffList.location_id'=>$session->read('locationid'))));
		return $tariffListId['TariffList']['id'] ;
		
	}
	
	//get sevice id by name
	function getServiceIdByServiceName($name=null){
		$session = new CakeSession();
	
		if(empty($name)) return;
		$tariffListId = $this->find('first',array('fields'=>array('id'),'conditions'=>array('TariffList.name'=>$name,'TariffList.is_deleted'=>'0',
				'TariffList.location_id'=>$session->read('locationid'))));
		return $tariffListId['TariffList']['id'] ;
	
	}
	public function findfirstRecord($id){
		$session = new CakeSession();
		return $this->find('first',array('fields'=>array('TariffList.name'),'conditions'=>array('TariffList.id'=>$id,'TariffList.is_deleted'=>'0','TariffList.location_id'=>$session->read('locationid'))));
	}
	
	/**
	 * function to get Service details
	 * @param  var $name --> Tariff Name;
	 * @return array
	 * @author  Amit Jain
	 */
	function getServiceDetails($name){
		$session = new CakeSession();
		return $this->find('first',array('fields'=>array('TariffList.id','TariffList.name'),
			'conditions'=>array('TariffList.name'=>$name,'TariffList.is_deleted'=>'0',
					'TariffList.location_id'=>$session->read('locationid'))));
	}
	
	function getServiceCatId($tariffListId){
		$session = new CakeSession();
		return $this->find('first',array('fields'=>array('TariffList.service_category_id'),
				'conditions'=>array('TariffList.id'=>$tariffListId,'TariffList.is_deleted'=>'0',
						'TariffList.location_id'=>$session->read('locationid'))));
	}
}