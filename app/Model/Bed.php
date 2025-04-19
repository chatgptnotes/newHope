<?php
/**
 * WardModel file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Bed Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 */
class Bed extends AppModel {
	
	public $name = 'Bed';
	
	  
	
	//public function insertBed($wardData=array(),$bedId=null,$wardId=null,$patientId=null,$action = 'insert'){
	public function insertBed($wardData=array(),$data=array(),$action = 'insert'){
		#pr($wardData);exit;		
		$session = new cakeSession();
	 	$this->unbindModel(array('belongsTo'=>array('Ward','Patient')));
	 	
		$data["Bed"]["bedno"] = $wardData['Room']['bed_prefix'].$data["Bed"]["bed_id"];
		 
		if($action=='insert'){
			$data["Bed"]["create_time"] =date("Y-m-d H:i:s");
			$data["Bed"]["created_by"] =  $session->read('userid');
		}else{
			$data["Bed"]["modify_time"] = date("Y-m-d H:i:s");
	    	$data["Bed"]["modified_by"] =  $session->read('userid')    ;
		}   
	    #pr($data);exit;        
		$this->save($data);	  
	}
	public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }

    function getAvailbleRooms(){
    	$session = new cakeSession(); 
    	$rooms =  $this->Find('all',array('fields'=>array('room_id','room_id','Bed.released_date'),
    									  'conditions'=>array('Bed.patient_id=0 and Bed.under_maintenance=0' /*and Bed.is_released=0*/ ,
    									  'Bed.location_id'=>$session->read('locationid')) ));
		 
    	foreach($rooms as $bedRoom){
    		/* $convertDate = strtotime($bedRoom['Bed']['released_date']);
			$currentTime = time();
			$minus = $currentTime - $convertDate ; 
			$intoMin = round(($minus)/60) ;
			if($intoMin > 45){ */
    			$roomIdArray[$bedRoom['Bed']['room_id']]= $bedRoom['Bed']['room_id']  ;
			//}
    	} 
    	/*if($roomId){
    		$roomId = substr($roomId,0,-1);
    	}*/
    	 
    	$roomId  = implode(',',$roomIdArray);//string with "," seperated room ids
    	 
    	return $roomId; 
    }
    
    function getPatientByBedId($id){
    			$countUser = $this->find('find', array('conditions' => array('id'=>$id),'fields'=>array('patient_id')));
                if(!empty($countUser['Bed']['patient_id'])) {
                  return false;
                } else {
                  return true;
                }
    }
    
	function getPatientsByRoom($id){
		$this->bindModel(array('hasOne'=>array('Patient'=>array('type'=>'INNER','foreignKey'=>'bed_id','conditions'=>array('Patient.is_deleted=0','Patient.is_discharge=0'))),
						       'belongsTo'=>array('Room'=>array('foreignKey'=>'room_id'))));
	 
		$result = $this->find('all',array('conditions'=>array('Bed.room_id'=>$id,),
								'fields'=>array('Patient.id','Patient.lookup_name','CONCAT(Room.bed_prefix,Bed.bedno) as bedno'))) ;
		return $result ;
	}
}