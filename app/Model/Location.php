<?php
/**
 * LocationModel file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Location.Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Santosh R. Yadav
 */
class Location extends AppModel {

	public $name = 'Location';
	public $specific = true;
	
/**
 * Location table binding with city , state, country and facility tables
 *
 */	

        public $belongsTo = array('City' => array('className'    => 'City',
                                                  'foreignKey'    => 'city_id'
                                                 ),
                                  'State' => array('className'    => 'State',
                                                   'foreignKey'    => 'state_id'
                                                 ),
                                  'Country' => array('className'    => 'Country',
                                                     'foreignKey'    => 'country_id'
                                                 ),
                               	 /*  'Facility' => array('className'    => 'Facility',
                                                     'foreignKey'    => 'facility_id'
                                                 )*/
                                 );
/**
 * server side validation
 *
 */
		
	public $validate = array(
               /* 'facility_id' => array(
			'rule' => "notEmpty",
			'message' => "Please select hospital name."
			),*/
		'name' => array(
			'rule' => "notEmpty",
			'message' => "Please enter name."
			),
		'address1' => array(
			'rule' => "notEmpty",
			'message' => "Please enter address."
			),
		'zipcode' => array(
			'rule' => "notEmpty",
			'message' => "Please enter zip."
			),
                'country_id' => array(
			'rule' => "notEmpty",
			'message' => "Please select country."
			),
                'state_id' => array(
			'rule' => "notEmpty",
			'message' => "Please select state."
			),
                'city_id' => array(
			'rule' => "notEmpty",
			'message' => "Please select city."
			),
                'email' => array(
			'rule' => "notEmpty",
			'message' => "Please enter email."
			),
                'phone1' => array(
			'rule' => "notEmpty",
			'message' => "Please enter phone1."
			),
                'mobile' => array(
			'rule' => "notEmpty",
			'message' => "Please enter mobile."
			),
                'fax' => array(
			'rule' => "notEmpty",
			'message' => "Please enter fax."
			),
                'contactperson' => array(
			'rule' => "notEmpty",
			'message' => "Please enter contact person."
			),
                'maxlocations' => array(
			'rule' => "notEmpty",
			'message' => "Please enter maximum locations."
			)
                );
   function __construct($id = false, $table = null, $ds = null) {
       if(empty($ds)){
        	$session = new cakeSession();
			$this->db_name =  $session->read('db_name');
	 	}else{
	 		$this->db_name =  $ds;
	 	}
		parent::__construct($id, $table, $ds);
    } 
	public function getLocationByID($id=null){
		return $this->read('name',$id);
		
	}
	
	public function getLocationDetails($id=null){
		$session = new cakeSession();
		if(empty($_SESSION['db_name'])){
			App::import('Vendor', 'DrmhopeDB');
			$db_connection = new DrmhopeDB('db_hope');
			$db_connection->makeConnection($this);
		}
		return $this->read(array('Location.name','Location.address1','Location.phone1','Location.phone2','Location.zipcode',
		'Location.email','Location.fax'),$id);
	}
	
	public function getCheckoutTime(){
		 $session = new cakeSession();
		 $locId= $session->read('locationid');
		 $result = $this->find('first',array('condition'=>array('Location.id'=>$locId),'fields'=>array('checkout_time')));
		  
		 if($result['Location']['checkout_time']){
		 	return $result['Location']['checkout_time']." hours" ; //initially string was attached  ":00:00"
		 }else{
		 	return "" ; //default checkout time
		 }		  
	}
	
	public function getNonAdminLocations($role_id){
		//find location 
		 
		$result = $this->Find('list',array('fields'=>array('Location.id','Location.name'),
							  			   'conditions'=>array('Location.is_deleted = 0 AND Location.id NOT IN (Select location_id from users where users.role_id=2)'), 
							  			   'recursive'=>-1));
		return $result ;
	}

	public function getLocationIdByName($name){
		if(empty($name)){
			return false;
		}else{
			$data = $this->Find('first',array('conditions'=>array('Location.name'=>$name)));
			return $data['Location']['id'];
		}
		
	}
	
	public function getLocationNameById($id){
		if(empty($id)){
			return false;
		}else{
			$data = $this->Find('first',array('conditions'=>array('Location.id'=>$id)));
			return $data['Location']['name'];
		}
	
	}
	
	public function getLocationIdByHospital(){
		 $session = new CakeSession();
		 $data = $this->Find('list',array('fields'=>array('id','name'),'conditions'=>array('Location.is_deleted'=>0,'Location.is_active'=>1)));
		 return $data;
	}
	/**
	 * Function to Locations List with Corporate
	 * where loaction_id is not null
	 * @param unknown_type loaction_ids
	 * Mahalaxmi
	 */
	public function getLocListIdWithCorporate($data = array()){
		if(!empty($data)){
			$condition=array('is_deleted'=>0,'is_active'=>1,'id'=>$data);
		}else{
			$condition=array('is_deleted'=>0,'is_active'=>1);
		}
		return $this->find('list',array('fields'=>array('id','name'),'conditions'=>$condition,'order'=>array('name')));
	}
	/**
	 * Function to Locations List
	 * where loaction_id is not null
	 * @param unknown_type loaction_ids
	 * Mahalaxmi
	 */
	public function getLocAllId($data = array(),$withCorporate){
		if(!$data) return ;
		$conditions=array('is_deleted'=>0,'is_active'=>1,'id'=>$data);
		if(empty($withCorporate))
			$conditions['created_by <>']=0;
		return $locationsData = $this->find('all',array('fields'=>array('id','name','city_id'),'conditions'=>$conditions,'order'=>array('name')));
	}
	
}
?>