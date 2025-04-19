<?php
/**
 * WardModel file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Facility.Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 */
class Ward extends AppModel {
	
	public $name = 'Ward';
	
	public $hasMany = array(
        'Room' => array(
            'className'  => 'Room'
        ),
        'ServicesWard' => array(
            'className'  => 'ServicesWard'           
        )
    );
		 public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    } 
	
    
    function getAvailableWards(){
    	$session = new cakeSession();
    	$bedObj = classRegistry::init('Bed');
    	$rooms =$bedObj->getAvailbleRooms() ;
    	if(!empty($rooms)){
    	$this->bindModel(array('hasOne'=>array('Room'=>array('foreignKey'=>'ward_id'))));
    	if($session->read('website.instance')!='vadodara'){
    	     $wardList = $this->find('list',array('fields'=>array('Ward.name'),'conditions'=>array('Room.id in ('.$rooms.')',
    								'Ward.location_id'=>$session->read('locationid')),'group'=>array('Ward.id'),'order'=>'Ward.name','recursive'=>1));
    	}else{
    		$wardList = $this->find('list',array('fields'=>array('Ward.name'),'conditions'=>array('Ward.location_id'=>$session->read('locationid')),
    				               'group'=>array('Ward.id'),'order'=>'Ward.name','recursive'=>1));
    	}
    
    	return $wardList ;
    	}
    	return;
    }
    
    //Return false if ward has any of the bed occupied by patient in any room .
    public function beforeDelete() {
    	$this->bindModel(array(
    							'hasOne'=>array(
    											'Room'=>array('foreignKey'=>'ward_id'),
    											'Bed'=>array('foreignKey'=>false,'conditions'=>array('Bed.room_id=Room.id'))
    											)
    					));
	    $count = $this->find("count", array("conditions" => array("Ward.id" => $this->id,'Bed.patient_id !='=>0),'recursive'=>1));
	    if ($count == 0) {
	        return true;
	    } else {
	        return false;
	    }
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
		$unique_id   = 'W';
		$unique_id  .= ucfirst(substr($hospital,0,1)); //first letter of the hospital name
		$unique_id  .= strtoupper(substr($session->read('location'),0,2));//first 2 letter of d location
		$unique_id  .= date('y'); //year
		$unique_id  .= $month_array[date('n')-1];//first letter of month
		$unique_id  .= date('d');//day
		$unique_id .= $count;
		if($created){
			$this->data['Account']['create_time']=date("Y-m-d H:i:s");
			$this->data['Account']['account_code']=$unique_id;
			$this->data['Account']['status']='Active';
			$this->data['Account']['name']=$this->data['Ward']['name'];
			$this->data['Account']['user_type']='Ward';
			$this->data['Account']['system_user_id']=$this->data['Ward']['id'];
			$this->data['Account']['location_id']=$session->read('locationid');
			$this->data['Account']['accounting_group_id']=$groupId;
			$getAccount->save($this->data['Account']);
		}else{
			$var=$getAccount->find('first',array('fields'=>array('id'),'conditions'=>array('system_user_id'=>$this->data['Ward']['id'],'user_type'=>'Ward','Account.location_id'=>$session->read('locationid'))));
			if(empty($var['Account']['id']))
			{
				$this->data['Account']['account_code']=$unique_id;
				$this->data['Account']['create_time']=date("Y-m-d H:i:s");
				$this->data['Account']['status']='Active';
			}
			$this->data['Account']['name']=$this->data['Ward']['name'];
			$this->data['Account']['user_type']='Ward';
			$this->data['Account']['system_user_id']=($this->data['Ward']['id'])?$this->data['Ward']['id']:$this->id;
			$this->data['Account']['accounting_group_id']=$groupId;
			$this->data['Account']['id']=$var['Account']['id'];
			$this->data['Account']['modify_time']=date("Y-m-d H:i:s");
			$this->data['Account']['location_id'] = $session->read('locationid');
			$getAccount->save($this->data['Account']);
		}
	}
    
	/**
	 * get wardList for daily room  
	 * @return Ambigous <multitype:, NULL, mixed>
	 * @yashwant
	 */
	public function getWardList(){
		$session = new cakeSession();
		return $this->find('list',array('fields'=>array('id','name'),'conditions'=>array('is_active'=>1,'is_deleted'=>0,'location_id'=>$session->read('locationid'))));
	}
	
	/**
	 * for getting ward chrges with respective ward 
	 * @param unknown_type $wardId
	 * @param unknown_type $tariffStandardId
	 * @yashwant
	 */
	public function wardCharges($wardId=null,$tariffStandardId=null){
		$session = new cakeSession();
		$TariffStandard = ClassRegistry::init('TariffStandard');
		
		$hospitalType = $session->read('hospitaltype');
		if($hospitalType=='NABH'){
			$chargeType='nabh_charges';
		}else{
			$chargeType='non_nabh_charges';
		}
		
		$this->unbindModel(array('hasMany' => array('Room','ServicesWard')));
		
		$this->bindModel(array(
				'belongsTo' => array(
						'TariffAmount' =>array('foreignKey' => false,'conditions'=>array('Ward.tariff_list_id=TariffAmount.tariff_list_id','TariffAmount.tariff_standard_id'=>$tariffStandardId )),
				)),false);
		$wardList = $this->find('first',array('fields'=>array('Ward.id','Ward.name','TariffAmount.nabh_charges','TariffAmount.non_nabh_charges'),
				'conditions'=>array('Ward.id'=>$wardId)));
		return $wardList['TariffAmount'][$chargeType];
	}
	
	public function getTariffListID($ward_id=null){
		if(!$ward_id) return false ;
		$result = $this->find('first',array('conditions'=>array('Ward.id'=>$ward_id),'fields'=>array('Ward.tariff_list_id')));
		return $result['Ward']['tariff_list_id'];
	}
	
}