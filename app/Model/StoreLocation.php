<?php

/** storeLocation Model
 *
 * PHP 5
 *
 * @copyright     Copyright 2014 DrMHope.  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       Languages.Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Gaurav Chauriya
 */
class StoreLocation extends AppModel {
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $name = 'StoreLocation';
	var $useTable = 'store_locations';

	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}
	
	public function saveStoreLocation($requestData = array()){
		$session = new cakeSession();
		if($requestData['id']){
			$requestData['modify_time'] = date('Y-m-d H:i:s');
			$requestData['modified_by'] = $session->read('userid');
			$requestData['location_id'] = $session->read('locationid');
		}else{
			$requestData['create_time'] = date('Y-m-d H:i:s');
			$requestData['created_by'] = $session->read('userid');
			$requestData['location_id'] = $session->read('locationid');
		}	
		$this->save($requestData);
		return $this->id;	
	}
	
	//fucntino to return store location by  code name or by name  
	function getStoreLocationID($code_name=null,$name=null){
		if(!$name && !$code_name) return false ;
		if($code_name){
			 return $this->find('first',
							array('conditions'=>array('StoreLocation.is_deleted' =>'0','StoreLocation.code_name' => $code_name)),
						array('fields'=>array('StoreLocation.id'))) ; 
		}else if($name){
			 return $this->find('first',
						array('conditions'=>array('StoreLocation.is_deleted' =>'0','StoreLocation.name' => $name)),
						array('fields'=>array('StoreLocation.id'))) ; 
		}
	}
	
	function getOtherStore(){
		$data = $this->find('list',array('conditions'=>array('code_name NOT' => array(Configure::read('pharmacyCode'),Configure::read('centralStoreCode')),'is_deleted'=>0)));
		return $data;
	}
	
	function getAllLocationsArray($roleId = null,$conditions=array()){
		$consumabelLocations = array(Configure::read("wardCode"),Configure::read("otCode"));
		$mylocations = $this->find('all',array('fields'=>array('id','name','role_id'),
				'conditions' => array($conditions,'StoreLocation.is_deleted' =>'0','StoreLocation.code_name NOT'=>array(Configure::read("wardCode"),Configure::read("otCode"),
				))));
	
		$returnArray = array();
		foreach($mylocations as $dept){
			$deptRolesArray = explode("|",$dept['StoreLocation']['role_id']);
			if(in_array($roleId,$deptRolesArray)){
				$returnArray[$dept['StoreLocation']['id']] = $dept['StoreLocation']['name'];
			}
		}
		return $returnArray;
	}
	
	//to find id using code_name by swapnil		-05.06.2015
	function getIdbyCodeName($codeName){
		$data = $this->find('first',array('fields'=>array('id'),
				'conditions' => array('StoreLocation.is_deleted' =>'0','StoreLocation.code_name'=>$codeName)));
		return $data['StoreLocation']['id'];
	}
}
?>