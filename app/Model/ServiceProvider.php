<?php

/**
 * Service model
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Service provider
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pankaj  wanjari
 * @functions 	 :Service Provider(CRED service data).	
 */
class ServiceProvider extends AppModel {
	
	public $name = 'ServiceProvider';
	public $validate = array(
            'name' => array(
			'rule' => "notEmpty",
			'message' => "Please enter service provider name."
			),
			 
		);
		
	  public $specific = true;
	  
	  function __construct($id = false, $table = null, $ds = null) {
	        $session = new cakeSession();
			$this->db_name =  $session->read('db_name');
	        parent::__construct($id, $table, $ds);
      }  
      
	function insertServiceProvider($data=array()){
			$session = new cakeSession();
		    $data['ServiceProvider']['location_id'] = $session->read('locationid');
		    $data['ServiceProvider']['status'] = 1;
			if(empty($data['ServiceProvider']['id'])){
				$data['ServiceProvider']['created_by'] = $session->read('userid');
				$data['ServiceProvider']['create_time'] = date("Y-m-d H:i:s");
			}else{
				$data['ServiceProvider']['modified_by'] = $session->read('userid');
				$data['ServiceProvider']['modify_time'] = date("Y-m-d H:i:s");
			}  
			$result =  $this->save($data['ServiceProvider']); 
			return $result ;
	}
	
	/**@params : category => blood,lab,radiology
	 * return type : array list
	 * cause :  return category wise service provider
	 */
	 
	function getServiceProvider($category=null){
		$session=new CakeSession() ;
		$condition['location_id'] = $session->read('locationid');
		$condition['status'] = 1; //active
		$condition['is_deleted'] = 0;
		if(!empty($category)){
			$condition['category'] = $category ;
		}
		$result = $this->Find('list',array('conditions'=>$condition)) ;	
		return $result; 
	}
	
	/**
	 * afterSave function for saving data in account table--Pooja
	 *
	 **/
	
	 public function afterSave($id=null)
	 {
	 	if(!$this->data['ServiceProvider']['id'] && !$this->data['ServiceProvider']['name']) return ;
	 	//For generating account code for account table
	 	$session = new CakeSession();
      	$getRegistrar = Classregistry::init('Account'); 
      	$count = $getRegistrar->find('count',array('conditions'=>array('Account.create_time like'=> "%".date("Y-m-d")."%",'Account.location_id'=>$session->read('locationid'))));
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
       
      	$serviceProviderID = ($this->data['ServiceProvider']['id'])?$this->data['ServiceProvider']['id']:$this->id;
      	$var=$getRegistrar->find('first',array('fields'=>array('id','account_code'),'conditions'=>array('system_user_id'=>$serviceProviderID,'user_type'=>'ServiceProvider','Account.location_id'=>$session->read('locationid'))));
      	if($var!='')
	 	{
	 		$this->data['Account']['id']=$var['Account']['id'];
	 		$this->data['Account']['modify_time']=date("Y-m-d H:i:s");
	 		if(empty($var['Account']['account_code']))
	 		{
	 			$this->data['Account']['account_code']=$unique_id;
	 		}
	 	
	 	}
	 	else {
	 		$this->data['Account']['create_time']=date("Y-m-d H:i:s");
	 		$this->data['Account']['account_code']=$unique_id;
	 		$this->data['Account']['status']='Active';
	 	}
		$this->data['Account']['name']=$this->data['ServiceProvider']['name'];
		$this->data['Account']['user_type']='ServiceProvider';
		$this->data['Account']['system_user_id']=$this->data['ServiceProvider']['id'];
		$this->data['Account']['location_id']=$session->read('locationid');
		$this->data['Account']['accounting_group_id']=$this->data['ServiceProvider']['accounting_group_id'];
		$getRegistrar->save($this->data['Account']);
	} 
	/**@params : category =>radiology
	 * return type : array list
	 * cause :  return category wise service provider id
	 * @auther Mahalaxmi
	 */
	 
	function getServiceProviderIdByCateggoryAndName($category=null,$serviceProviderName=null){
		$session=new CakeSession() ;		
		$condition=array('location_id'=> $session->read('locationid'),'status'=>1,'is_deleted'=>0);
		if(!empty($category)){
			$condition['category'] = $category;
		}		
		if(!empty($serviceProviderName)){
			$condition['name'] = $serviceProviderName;
		}		
		$result = $this->Find('first',array('fields'=>array('id'),'conditions'=>$condition)) ;			
		return $result['ServiceProvider']['id']; 
	}
	/**@params : category =>radiology
	 * return type : array list
	 * cause :  return category wise service provider id
	 * @auther Mahalaxmi
	 */
	 
	function getServiceProviderIdAllByCateggoryAndName($category=null,$serviceProviderName=array()){
		$session=new CakeSession() ;		
		$condition=array('location_id'=> $session->read('locationid'),'status'=>1,'is_deleted'=>0);
		if(!empty($category)){
			$condition['category'] = $category;
		}		
		if(!empty($serviceProviderName)){
			$condition['name'] = $serviceProviderName;
		}		
		$result = $this->Find('all',array('fields'=>array('id'),'conditions'=>$condition)) ;
		foreach($result as $results){
			$resultArr[$results['ServiceProvider']['id']]=$results['ServiceProvider']['id'];
		}		

		return $resultArr; 
	}
	/**@params : category =>radiology
	 * return type : array list
	 * cause :  return category wise service provider details
	 * @auther Mahalaxmi
	 */
	 
	function getServiceProviderDataByCateggoryAndName($category=null,$serviceProviderName=null){
		$session=new CakeSession() ;		
		$condition=array('location_id'=> $session->read('locationid'),'status'=>1,'is_deleted'=>0);
		if(!empty($category)){
			$condition['category'] = $category;
		}		
		if(!empty($serviceProviderName)){
			$condition['name'] = $serviceProviderName;
		}				
		return $this->Find('first',array('fields'=>array('id','contact_person','contact_no'),'conditions'=>$condition)) ; 
	}
	/**@params : serviceProviderID and fields array
	 * return details
	 * @auther Mahalaxmi
	 */
	 
	function getServiceProviderDetails($serviceProviderID=null,$fields=array()){
		$session=new CakeSession() ;		
		$condition=array('location_id'=> $session->read('locationid'),'status'=>1);				
		if(!empty($serviceProviderID)){
			$condition['id'] = $serviceProviderID;
		}				
		return $this->Find('first',array('fields'=>$fields,'conditions'=>$condition, 'recursive' => 1)) ; 
	}	
}

    ?>