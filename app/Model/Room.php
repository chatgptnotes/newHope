<?php
/**
 * RoomModel file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Room Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 */
class Room extends AppModel {
	
	public $name = 'Room';
	
	public $hasMany = array(
        'Bed' => array(
            'className'  => 'Bed',
			'dependent'=>true
        )
    );
	 public $specific = true;
	 function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }

	//Return false if ward has any of the bed occupied by patient in any room .
    public function beforeDelete() {    	
    	$this->bindModel(array('hasOne'=>array('Bed'=>array('foreignKey'=>'room_id'))));
	    $count = $this->find("count", array("conditions" => array("Room.id" => $this->id,'Bed.patient_id !='=>0),'recursive'=>1));
	    if ($count == 0) {
	        return true;
	    } else {
	        return false;
	    }
	}
	//return ward rooms
	function getAllRooms($ward_id=null){
		if(empty($ward_id)) return ;
		
		$rooms = $this->find('list', array('fields'=> array('id', 'name'),
			'conditions'=>array('ward_id'=>$ward_id)));
		 
		return $rooms ;
	
	}

   // enter the record for maintaining history //
   /*
   public function beforeSave($options = array()) {
	   $getdata = $this->find('first', array('conditions' => array('Room.id' => $this->data['Room']['id'])));
       $this->data['RoomUpdateHistory']['ward_id'] = $getdata['Room']['ward_id'];
	   $this->data['RoomUpdateHistory']['location_id'] = $getdata['Room']['location_id'];
	   $this->data['RoomUpdateHistory']['name'] = $getdata['Room']['name'];
	   $this->data['RoomUpdateHistory']['bed_prefix'] = $getdata['Room']['bed_prefix'];
	   $this->data['RoomUpdateHistory']['no_of_beds'] = $getdata['Room']['no_of_beds'];
	   $this->data['RoomUpdateHistory']['is_active'] = $getdata['Room']['is_active'];
	   $this->data['RoomUpdateHistory']['created_by'] = AuthComponent::user('id');
	   $this->data['RoomUpdateHistory']['create_time'] = date("Y-m-d H:i:s");
	   
	   Classregistry::init('RoomUpdateHistory')->save($this->data['RoomUpdateHistory']);
	   return true;
   }*/
	
	/**
	 * for rooms mapped with ward ID
	 * @param unknown_type $wardId
	 * @yashwant
	 */
	public function getRooms($wardId=null){
		return($this->find('list',array('fields'=>array('id','name'),'conditions'=>array('ward_id'=>$wardId))));
	}

	
	/**
	 * for all active rooms
	 * @return Ambigous <multitype:, NULL, mixed>
	 * @yashwant
	 */
	
	public function getRoomList(){
		$session     = new cakeSession();
		return($this->find('list',array('fields'=>array('id','name'),'conditions'=>array('is_active'=>1,'location_id'=>$session->read('locationid')))));
	}
}
	