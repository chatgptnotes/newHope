<?php
/**
 * PackagePermission file
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
class PackagePermission extends AppModel {

	public $name = 'PackagePermission';
	public $specific = true;

	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }

     public function getPermissionLevel(&$packages,$aro){// pr($packages);exit;
	 	$aco = Classregistry::init('Aco');
		$access = array();
	    foreach($packages as $key=>$value){
		 $module = explode(",",$value['PackagePermission']['module_name']);
		 foreach($module as $k => $v ){

				 $access[$v] = array();
					$aco->bindModel(array(
						   "hasMany"=>array(
								'Child' => array(
									'className' => 'Aco',
									'foreignKey' => 'parent_id'  ,
									'conditions' =>array("Child.is_permission_need"=>"1")
        							),
									"AclArosAco"=>array("foreignKey"=>"aco_id")
							),
				));
				$permission = $aco->find("first",array("conditions"=>array("Aco.id"=> $v ) ));
				 foreach($permission['Child'] as $childk => $childv ){
					$child_action_permission = $aco->find("first",array("conditions"=>array("Aco.id"=> $childv['id'],"Aco.is_permission_need"=>1 ) ));
				 	if(count($child_action_permission['Aro'])==0){
						array_push($access[$v],"deny");
					}else{
						array_push($access[$v],$this->checkPermission($child_action_permission['Aro'],$aro));
					}
				 }

			  $result = array_unique($access[$v]);
			  if(count($result) == 0){
			 	 	$controller[$v] = "deny";
			  }else if(count($result) == 1){
					if($result[0] == "not"){
						$controller[$v]  = "not";
					}else if($result[0] == "full"){
						$controller[$v]  = "full";
					}else{
						$controller[$v] = "deny";
					}
			   }else{

					if ( in_array('full', $result) && in_array('deny', $result)) {
						$controller[$v] = "not";
					}else if (in_array('full', $result) && in_array('not', $result)) {
						 $controller[$v] = "not";
					}else if (in_array('deny', $result) && in_array('not', $result)) {
						$controller[$v] = "deny";
					}
			   }

			 }

	   }
	   $access =array();
	     foreach($packages as $key=>$value){
		 $access[$value['PackagePermission']['id']]	= array();
			 $module = explode(",",$value['PackagePermission']['module_name']);
		 	 foreach($module as $k => $v ){
			    array_push($access[$value['PackagePermission']['id']],$controller[$v]);
			 }
		 	//$packages[$key]['permission'];
			  $result = array_unique($access[$value['PackagePermission']['id']]);
			  if(count($result) == 1){
					if($result[0] == "not"){
						$packages[$key]['permission']  = "not";
					}else if($result[0] == "full"){
						$packages[$key]['permission'] = "full";
					}else{
						$packages[$key]['permission'] = "deny";
				   }
			}else{
			  if ( in_array('full', $result) && in_array('deny', $result)) {
					$packages[$key]['permission'] = "not";
			 }else if (in_array('full', $result) && in_array('not', $result)) {
					$packages[$key]['permission'] = "not";
			 }else if (in_array('deny', $result) && in_array('not', $result)) {
						$packages[$key]['permission'] = "deny";
			 } else{
				 $packages[$key]['permission'] = "full";
			 }
			 }
		 }

   }
   public function providePermission($aro,$aco,$permission_type){
		 $aros_acos = Classregistry::init('AclArosAco');
		 $session = new cakeSession();
		 $hospitalMode = $session->read('hospital_permission_mode');
		 foreach($aco as $key => $value){
		 	  $aros_acos->unBindModel(array('belongsTo'=>array('AclAro','AclAco'))); //Added by pankaj to remove error in "table aros not found for model AclAro "
	   	 	  $permission = $aros_acos->find("first",
												array("conditions"=>
													array("AclArosAco.aro_id"=>$aro,"AclArosAco.aco_id"=>$value['id'],'AclArosAco.hospital_mode' =>$hospitalMode)));
			  $data["AclArosAco"]["aro_id"]= $aro;
			  $data["AclArosAco"]["aco_id"]= $value['id'];
			  $data["AclArosAco"]["_delete"]= $permission_type;
			  $data["AclArosAco"]["_create"]= $permission_type;
			  $data["AclArosAco"]["_read"]= $permission_type;
			  $data["AclArosAco"]["_update"]= $permission_type;
			  $data["AclArosAco"]["hospital_mode"]= $session->read('hospital_permission_mode');
			  //print_r($data);exit;
			  if(is_array($permission))
				 $aros_acos->id = $permission["AclArosAco"]['id'];
			  else
				$aros_acos->create();

		      $aros_acos->save($data);

   		}
   }
   public function checkPermission(&$aroArray, $aro,$roleAroID = null){
   	   	$flag = "deny";
   	   if(count($aroArray)>0){
	   		 foreach($aroArray as $childk => $childv ){
			 	if(($childv['Permission']['aro_id'] == $aro)){ 

					if( (($childv['Permission']['_delete'] =="1" && $childv['Permission']['_update']  =="1") &&
							 ($childv['Permission']['_read'] =="1" && $childv['Permission']['_create'] =="1"))){
							   	   	$flag = "full";
					 }else if((($childv['Permission']['_delete'] =="-1" && $childv['Permission']['_update']  =="-1") &&
							 ($childv['Permission']['_read'] =="-1" && $childv['Permission']['_create'] =="-1"))){
					             	$flag = "deny";

					 }
				}else if($roleAroID != null && $roleAroID == $childv['Permission']['aro_id']){
						if( (($childv['Permission']['_delete'] =="1" && $childv['Permission']['_update']  =="1") &&
							 ($childv['Permission']['_read'] =="1" && $childv['Permission']['_create'] =="1"))){
							   	   	$flag = "full";
					 }else if((($childv['Permission']['_delete'] =="-1" && $childv['Permission']['_update']  =="-1") &&
							 ($childv['Permission']['_read'] =="-1" && $childv['Permission']['_create'] =="-1"))){
					             	$flag = "deny";

					 }


				}

			 }
			 return $flag;
	 }

   	}
}