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
class ServiceCategory extends AppModel {
	
	public $name = 'ServiceCategory';
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

    public $hasMany = array(
		'ServiceSubCategory' => array(
		'className' => 'ServiceSubCategory',
		'dependent' => true,
		'foreignKey' => 'service_category_id',
		)
	); 
	
	
	function getServiceGroup(){
		$session = new CakeSession();
		$res = $this->find("list",array('fields'=>array('id','alias'),"conditions"=>array("ServiceCategory.is_deleted=0 AND
	    (ServiceCategory.location_id=".$session->read('locationid')." OR ServiceCategory.location_id=0)"),'order'=>array('ServiceCategory.alias ASC')));
		$result=array_filter($res);
		$yourArray=array_map('strtolower', $result);// for converting string into lowercase 
		$resultData = array_map('ucwords', $yourArray);//for first letter of string capital
		return $resultData ;
	}
	//PAWAN 
	function getServiceGroupWithAllLocation(){
		$session = new CakeSession();
		$result = $this->find("list",array('fields'=>array('id','alias'),"conditions"=>array("ServiceCategory.is_deleted=0")));
		 return $result ;
	}
	
	//2nd argument by pankaj w
	function getServiceGroupId($name=null,$location_id=null){
		Classregistry::init('ServiceCategory')->unBindModel(array('hasMany' => array('ServiceSubCategory')));
		if($name==Configure::read('mandatoryservices')){// do not remove, as we hav kept location ID for mandatory service=0  --yashwant
			$result = $this->find("first",array("conditions"=>array("ServiceCategory.name"=>Configure::read($name))));
		}else{
			if(!$location_id){
				$session = new CakeSession();
				$location_id =  $session->read('locationid') ; 
			}
			$result = $this->find("first",array("conditions"=>array("ServiceCategory.name"=>Configure::read($name),'location_id'=>$location_id)));
		}
		if($result){
			return $result['ServiceCategory']['id'];
		}else{
			return 0;
		}
	}
	
	
 	//get pharmacy category ID
	function getPharmacyId(){
		$session = new cakeSession();
		$locationId = $session->read('locationid');
		/* if(strtolower($session->read('website.instance')) == "kanpur"){	
			if($locationId == 25){			//25 for Roman Pharma
				$fromLocation = 1;			//1  for Globus Clinic
			}else if($locationId == 26){	//26 for Roman Pharma Extension
				$fromLocation = 22;			//22 for Globus Hospital
			}
		}else */{
			$fromLocation = $locationId;	//current location
		}
		
		$pharmacyLabel = Configure::read('pharmacyservices') ; 
		$result = $this->find("first",array("conditions"=>array("ServiceCategory.name"=>$pharmacyLabel,'ServiceCategory.location_id'=>$fromLocation)));
		if(!$result['ServiceCategory']['id']){
			$result = $this->find("first",array("conditions"=>array("ServiceCategory.name"=>$pharmacyLabel,'ServiceCategory.location_id'=>$locationId)));
		}
		return $result['ServiceCategory']['id'];
	}
	
	public function getServiceCategoryName($id=null){
		$session = new cakeSession();
		$locationId = $session->read('locationid');
		return $result = $this->find("first",array("conditions"=>array("ServiceCategory.id"=>$id,'ServiceCategory.location_id'=>$locationId)));
	}
	
	//get Ot Pharmacy Id
	function getOtPharmacyId(){
		$session = new cakeSession();
		$locationId = $session->read('locationid');
	
		$fromLocation = $locationId;	//current location
	
	
		$otPharmacyLabel = Configure::read('otpharmacyservices') ;
		$result = $this->find("first",array("conditions"=>array("ServiceCategory.name"=>$otPharmacyLabel,'ServiceCategory.location_id'=>$fromLocation)));
		if(!$result['ServiceCategory']['id']){
			$result = $this->find("first",array("conditions"=>array("ServiceCategory.name"=>$otPharmacyLabel,'ServiceCategory.location_id'=>$locationId)));
		}
		return $result['ServiceCategory']['id'];
	}

	//by atul - to get the id by name
	function getServiceGroupIdbyName($name=null){
		$cond = array();
		if(!empty($name)){
			$cond['ServiceCategory.name'] = $name;
		}
		$result = $this->find("first",array("conditions"=>array($cond,"ServiceCategory.is_deleted"=>0)));
		if($result){
			return $result['ServiceCategory']['id'];
		}else{
			return 0;
		}
	}
	
	//2nd argument by pankaj w
	function getServiceGroupIdFromAlias($name=null,$location_id=null){
		Classregistry::init('ServiceCategory')->unBindModel(array('hasMany' => array('ServiceSubCategory')));
		if($name==Configure::read('mandatoryservices')){// do not remove, as we hav kept location ID for mandatory service=0  --yashwant
			$result = $this->find("first",array("conditions"=>array("ServiceCategory.alias"=>Configure::read($name))));
		}else{
			if(!$location_id){
				$session = new CakeSession();
				$location_id =  $session->read('locationid') ;
			}
			$result = $this->find("first",array("conditions"=>array("ServiceCategory.alias"=>Configure::read($name),'location_id'=>$location_id)));
		}
		if($result){
			return $result['ServiceCategory']['id'];
		}else{
			return 0;
		}
	}
}