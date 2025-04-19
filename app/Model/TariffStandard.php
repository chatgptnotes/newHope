<?php
class TariffStandard extends AppModel {

	public $name = 'TariffStandard'; 	
	public $specific = true;
	
  public function __construct($id = false, $table = null, $ds = null) {
		if(empty($ds)){
			$session = new cakeSession();
			$this->db_name =  $session->read('db_name');
		}else{
			$this->db_name =  $ds;
		}
		parent::__construct($id, $table, $ds);
	}
    //BOF Atul, to fetch the tariffstandard id from tariffstandard name
    function getTariffStandardID($name=null)
    {
    	$result = $this->find("first",array("conditions"=>array("TariffStandard.name"=>Configure::read($name),"TariffStandard.is_deleted"=>'0')));
    	return $result['TariffStandard']['id'];  
    } 
    
    //return private ID
    function getPrivateTariffID($locationId = null){
    	$session = new cakeSession();
    	$locationId = ($locationId) ? $locationId : $session->read('locationid');
    	$privateLabel = Configure::read('privateTariffName') ;    	
    	$result = $this->find("first",array('fields'=>array('TariffStandard.id'),
    			//"conditions"=>array("TariffStandard.name"=>$privateLabel,'TariffStandard.location_id'=>$locationId)));
    	         'conditions'=>array('OR'=>array(array("TariffStandard.code_name"=>$privateLabel,'TariffStandard.location_id'=>$locationId),array("TariffStandard.name"=>$privateLabel,'TariffStandard.location_id'=>$locationId)))));
    	return $result['TariffStandard']['id'];
    } 
    
    /**
     * function to fetch tariffStandardId from PatientId
     * @param interger $patientId
     * @author Gaurav Chauriya
     */
    function getTariffIDByPatientId($patientId = null){
    	$patientObj = Classregistry::init('Patient') ;
    	$result = $patientObj->find("first",array('fields'=>array('Patient.tariff_standard_id'),"conditions"=>array("Patient.id"=>$patientId)));
    	return $result['Patient']['tariff_standard_id'];
    }
	
    //BOF Amit, to fetch the tariffstandard name from tariffstandard id
    function getTariffStandardName($id=null)
    {
    	$session = new cakeSession();
    	$result = $this->find("first",array('fields'=>array('TariffStandard.name'),"conditions"=>array("TariffStandard.id"=>$id,"TariffStandard.is_deleted"=>'0','TariffStandard.location_id'=>$session->read('locationid'))));
    	return $result['TariffStandard']['name'];
    }
    
    //BOF amit jain
    /**
     * afterSave function for saving data in accounting groups table--Amit jain
     *
     **/
    public function afterSave($created)
    {
    	$session = new CakeSession();
    	$accountingGroupObj = Classregistry::init('AccountingGroup');
    	
    	$tariffId = $this->data['TariffStandard']['id'];
    	$id=$accountingGroupObj->find('first',array('fields'=>array('id'),'conditions'=>array('AccountingGroup.system_user_id'=>$tariffId,
    			'AccountingGroup.user_type'=>'TariffStandard','AccountingGroup.location_id'=>$session->read('locationid'),'AccountingGroup.is_deleted'=>'0')));
    	if(!empty($id)){
    		if($this->data['TariffStandard']['is_deleted']=='1'){
    			$accountingGroupObj->updateAll(array('AccountingGroup.is_deleted'=>'1'),array('AccountingGroup.system_user_id' =>$tariffId,
    					'AccountingGroup.user_type'=>'TariffStandard','AccountingGroup.location_id'=>$session->read('locationid')));
    			return ;
    		}
    		$this->data['AccountingGroup']['location_id'] = $session->read('locationid');
    		$this->data['AccountingGroup']['id']=$id['AccountingGroup']['id'];
    		$this->data['AccountingGroup']['name']=$this->data['TariffStandard']['name'];
    		$this->data['AccountingGroup']['code_name']=$this->data['TariffStandard']['code_name'];
    		$this->data['AccountingGroup']['account_type']='Asset';
    		$this->data['AccountingGroup']['modified_time']=date("Y-m-d H:i:s");
    		$this->data['AccountingGroup']['user_type']='TariffStandard';
    		$this->data['AccountingGroup']['system_user_id']=$tariffId;
    		$accountingGroupObj->save($this->data['AccountingGroup']);
    		$accountingGroupObj->id = "";
    	}else{
    		if($this->data['TariffStandard']['is_deleted']=='1'){
    			return ; //return if delete
    		}
    		$this->data['AccountingGroup']['location_id']=$session->read('locationid');
    		$this->data['AccountingGroup']['name']=$this->data['TariffStandard']['name'];
    		$this->data['AccountingGroup']['code_name']=$this->data['TariffStandard']['code_name'];
    		$this->data['AccountingGroup']['account_type']='Asset';
    		$this->data['AccountingGroup']['created_time']=date("Y-m-d H:i:s");
    		$this->data['AccountingGroup']['user_type']='TariffStandard';
    		$this->data['AccountingGroup']['system_user_id']=$this->data['TariffStandard']['id'];
    		$accountingGroupObj->save($this->data['AccountingGroup']);
    		$accountingGroupObj->id = "";
    	}
    	
    	//For generating account code for account table
    	$accountObj = Classregistry::init('Account');
    	$count = $accountObj->find('count',array('conditions'=>array('Account.create_time like'=> "%".date("Y-m-d")."%",'Account.location_id'=>$session->read('locationid'))));
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
    	$unique_id   = 'SE';
    	$unique_id  .= ucfirst(substr($hospital,0,1)); //first letter of the hospital name
    	$unique_id  .= strtoupper(substr($session->read('location'),0,2));//first 2 letter of d location
    	$unique_id  .= date('y'); //year
    	$unique_id  .= $month_array[date('n')-1];//first letter of month
    	$unique_id  .= date('d');//day
    	$unique_id .= $count;
    	 
    	$getIncomesName = Configure::read('acc_income_group_name');
    	$groupId = $accountingGroupObj->getAccountingGroupID($getIncomesName['indirect incomes']);
    	
    	$tariffStandardID = ($this->data['TariffStandard']['id'])?$this->data['TariffStandard']['id']:$this->id;
    	$var = $accountObj->find('first',array('fields'=>array('id','account_code'),
    			'conditions'=>array('system_user_id'=>$tariffStandardID,'user_type'=>Configure::read('SuspenseType'),'Account.location_id'=>$session->read('locationid'))));
    	if($var!=''){
    		$this->data['Account']['id']=$var['Account']['id'];
    		$this->data['Account']['modify_time']=date("Y-m-d H:i:s");
    		if(empty($var['Account']['account_code'])){
    			$this->data['Account']['account_code']=$unique_id;
    		}
    	}else{
    		$this->data['Account']['create_time']=date("Y-m-d H:i:s");
    		$this->data['Account']['account_code']=$unique_id;
    		$this->data['Account']['status']='Active';
    	}
    	$this->data['Account']['name']=$this->data['TariffStandard']['name']."-"."Suspense" ;
    	$this->data['Account']['alias_name']=$this->data['TariffStandard']['name']."-"."Suspense" ;
    	$this->data['Account']['user_type']=Configure::read('SuspenseType');
    	$this->data['Account']['system_user_id']=$this->data['TariffStandard']['id'];
    	$this->data['Account']['location_id']=$session->read('locationid');
    	$this->data['Account']['accounting_group_id']=$groupId;
    	$accountObj->save($this->data['Account']);
    }
	//BOF Mahalaxmi, to fetch the tariffstandard id from tariffstandard name
    function getTariffStandardIDAll($name=array()){
		$session = new CakeSession();	
        $conditions=array("TariffStandard.name"=>$name,"TariffStandard.is_deleted"=>'0');
        $sessionId=$session->read('locationid');
        if(!empty($sessionId)){
            $conditions['TariffStandard.location_id']=$sessionId;
        }else{
            $conditions['TariffStandard.location_id']='1'; //For hope only
        }
    	$result = $this->find("list",array('fields'=>array('name','id'),"conditions"=>$conditions,'order'=>array('TariffStandard.id'=>'ASC')));		
    	return $result;  
    } 
    
    
    /**
     * Function to fetch all the tariffs except private
     * Pooja Gupta
     */
    function getAllCorporateTariffs(){
    	$session = new cakeSession();
    	$res=$this->find('list', array('fields'=> array('id','name'),
    			'conditions' => array('TariffStandard.is_deleted' => 0,
    					'TariffStandard.location_id'=>$session->read('locationid'),
    					'TariffStandard.name NOT'=>'Private')));
    	$result=array_filter($res);
    	$yourArray=array_map('strtolower', $result);// for converting string into lowercase
    	$resultData = array_map('ucwords', $yourArray);//for first letter of string capital
    	return $resultData ;
    }
    
    /**
     * Function to fetch all the tariffs
     * Pooja Gupta
     */
    function getAllTariffStandard(){
    	$session = new cakeSession();
    	$res=$this->find('list', array('fields'=> array('id','name'),
    			'conditions' => array('TariffStandard.is_deleted' => 0,
    					'TariffStandard.location_id'=>$session->read('locationid'),
    			),
    			'order'=>'TariffStandard.name ASC'));
    	$result=array_filter($res);
    	$yourArray=array_map('strtolower', $result);// for converting string into lowercase
    	$resultData = array_map('ucwords', $yourArray);//for first letter of string capital
    	return $resultData ;
    }
    
    //return RGJAY ID
    function getRGJAYTariffID($locationId = null){
    	$session = new cakeSession();
    	$locationId = ($locationId) ? $locationId : $session->read('locationid');
    	$rgjayLabel = Configure::read('RGJAY') ;
    	$result = $this->find("first",array('fields'=>array('TariffStandard.id'),
    			'conditions'=>array('OR'=>array(array("TariffStandard.code_name"=>$rgjayLabel,'TariffStandard.location_id'=>$locationId),
    							array("TariffStandard.name"=>$rgjayLabel,'TariffStandard.location_id'=>$locationId)))));
    	return $result['TariffStandard']['id'];
    }

}