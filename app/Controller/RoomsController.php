<?php
/**
 * RoomsController file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Rooms Controller
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 */

class RoomsController extends AppController {
	
	public $name = 'Rooms';	
	public $helpers = array('Html','Form', 'Js','DateFormat');	 
	public $components = array('RequestHandler','Email','ImageUpload','DateFormat');
	public $uses = array('Room','Bed','Ward');
	
	function index($wardId=null){
		$wardData = $this->Ward->read(null,$wardId);			
		
		$wardName =$wardData['Ward']['name'];		
		$this->paginate = array(
			        'limit' => Configure::read('number_of_rows'),
			        'order' => array(
			            'Room.name' => 'asc'
			        ),
			        'conditions' => array('Room.ward_id' => $wardId,'Room.location_id' => $this->Session->read('locationid'))
   				);
		
		$this->set('title_for_layout', __('Manage Rooms', true));
		$data = $this->paginate('Room');
		//pr($data);exit;
		$this->set(array('wardName'=>$wardName,'ward_id'=>$wardId,'data'=>$data));
	}
	
	function addRoom($ward_id=null){
		$this->uses = array('Bed','Ward');
		if(!empty($this->request->data)){
			$old_data = $this->Room->find('count',array('conditions'=>array('name'=>$this->request->data['Room']['name'],'location_id' => $this->Session->read('locationid') ) ));
			
			if($old_data){
				$this->set('ward_id',$this->request->data['Room']['ward_id']);
				$this->Session->setFlash(__('This Room is already exist.'),'default',array('class'=>'error'));
				return false;
			}
			$wardData = $this->Ward->read(null,$ward_id);
			$noOfRooms = $wardData['Ward']['no_of_rooms'];
			$noOfRoomsOccupied = count($wardData['Room']);
			if($noOfRoomsOccupied < $noOfRooms){ 
				$this->request->data["Room"]["create_time"] = date("Y-m-d H:i:s");
				$this->request->data["Room"]["created_by"] =  $this->Auth->user('id');
				$this->request->data["Room"]['location_id'] = $this->Session->read('locationid');				

				if($this->Room->save($this->request->data)){
					for($i=1;$i<=$this->request->data['Room']['no_of_beds'];$i++){
						$data['Room']['room_id'] = $this->Room->id;
						$data['Room']['location_id'] = $this->Session->read('locationid');
						$data['Room']['created_by'] = $this->Session->read('userid');
						$data['Room']['modified_by'] = $this->Session->read('userid');
						$data['Room']['create_time'] = date('Y-m-d H:i:s');
						$data['Room']['modify_time'] = date('Y-m-d H:i:s');
						$data['Room']['bedno'] = $i;
						$this->Bed->save($data['Room']);
						$this->Bed->id='';
					}
				}
			}else{
				$this->Session->setFlash(__('Max Rooms created.'),'default',array('class'=>'error'));
			}
			$this->redirect(array("controller" => "rooms", "action" => "index",$this->request->data['Room']['ward_id']));
		}else{
			$this->set('ward_id',$ward_id);
			
		}
	}
		
	function editRoom($room_id=null,$ward_id=null){
		if(!empty($this->request->data)){
			$this->request->data["Room"]["modify_time"] = date("Y-m-d H:i:s");
			$this->request->data["Room"]["modified_by"] =  $this->Auth->user('id');
			$this->request->data["Room"]['location_id'] = $this->Session->read('locationid');
			$this->Room->save($this->request->data);
			$this->redirect(array("controller" => "rooms", "action" => "index",$this->request->data['Room']['ward_id']));
		}else{
			$this->set('room_id',$room_id);
			$this->set('ward_id',$ward_id);
			$this->request->data = $this->Room->read(null, $room_id);
		}
	}	
	
	function delete($room_id=null){
		if (!$room_id) {
			$this->Session->setFlash(__('Invalid id for Room'),'default',array('class'=>'error'));
			$this->redirect(array("controller" => "rooms", "action" => "index", "admin" => false));
		}
		/*$this->uses =array('Bed');
		//check if room exist 
		$beds = $this->Bed->find('count',array('conditions'=>array('room_id'=>$room_id))); 
		if($beds == 0){*/
			if ($this->Room->delete($room_id)) {
				$this->Session->setFlash(__('Room successfully deleted'),'default',array('class'=>'message'));
				$this->redirect($this->referer());
			}else{
				$this->Session->setFlash(__('There is patient(s) admitted in seleted room, Please check and try again.'),'default',array('class'=>'error'));
				$this->redirect($this->referer());
			}
		/*}else{
			$this->Session->setFlash(__('Please remove beds associated with the selected room and try again.'),'default',array('class'=>'error'));
			$this->redirect($this->referer());
		}*/
	}
	
	function getRooms($wardId=null){
		$this->layout = 'ajax';
		$this->autoRender =false ;
		if($wardId != ''){
			$this->uses = array('Bed');
			$roomsFilter = $this->Bed->getAvailbleRooms() ;
			$rooms = $this->Room->find('list', array('fields'=> array('id', 'name'),
			'conditions'=>array('ward_id'=>$wardId,'Room.id in ('.$roomsFilter.')','location_id' => $this->Session->read('locationid'))));
			echo json_encode($rooms);
			exit;
		}else{
			exit ;
		}
	}
	
	/*function getBeds($room_id = null,$current_bed=null){
		$this->Room->id = $room_id;
		$data = $this->Room->find('first', array('conditions' => array('Room.id' => $room_id)));
		
		$bedPrefix = $data['Room']['bed_prefix'];
		$noOfBeds = $data['Room']['no_of_beds'];
		$bedData = $this->Bed->find('all', array('fields'=> array('bedno'),'conditions' => array('Bed.room_id' => $room_id,'location_id' => $this->Session->read('locationid'))));
		
		$filledArray=array();
		foreach($bedData as $value){
			array_push($filledArray, $value['Bed']['bedno']);
		}$emptyBeds = array();
		for($i=1; $i<=$noOfBeds;$i++){
			if(!in_array($i, $filledArray)){
				$emptyBeds[$i] = $bedPrefix.$i;		
			}
			if($current_bed != null){
				if($i == $current_bed){
					$emptyBeds[$i] = $bedPrefix.$i;		
				}
			}
		}
		
		echo json_encode($emptyBeds);
			exit;
	}*/
	
function getBeds($room_id = null,$current_bed=null){
		$this->Room->id = $room_id;
		$data = $this->Room->find('first', array('conditions' => array('Room.id' => $room_id)));
		
		$bedPrefix = $data['Room']['bed_prefix'];
		$noOfBeds = $data['Room']['no_of_beds'];

		//$bedData = $this->Bed->find('all', array('conditions' => array('Bed.room_id' => $room_id,'location_id' => $this->Session->read('locationid'))));

		if($current_bed==null){
			$bedData = $this->Bed->find('all', array('conditions' => array('Bed.room_id' => $room_id,'Bed.patient_id =0','location_id' => $this->Session->read('locationid'),'under_maintenance'=>0/*,'is_released'=>0*/)));
		}else{
			$bedData = $this->Bed->find('all', array('conditions' => array('Bed.room_id' => $room_id,'Bed.patient_id =0 || Bed.id='.$current_bed,'location_id' => $this->Session->read('locationid'),'under_maintenance'=>0/*,'is_released'=>0*/)));	
		}

		
		
		$emptyBeds = array();
		 
		foreach($bedData as $bed){		
			//BOF pankaj
			if(!empty($bed['Bed']['released_date'])){
				 $convertDate = strtotime($bed['Bed']['released_date']);
	             $currentTime = mktime();
	             $minus = $currentTime - $convertDate ; 
	             $intoMin = round(($minus)/60) ;
				 //if($intoMin > 45){
					$emptyBeds[$bed['Bed']['id']]=$bedPrefix.$bed['Bed']['bedno'];
				// }
			}else{
				$emptyBeds[$bed['Bed']['id']]=$bedPrefix.$bed['Bed']['bedno'];
			} 	 
			//EOF pankaj
			
		}
		echo json_encode($emptyBeds);
		exit;	 
	}
	
	public function add($wardId = null){
		$this->uses = array('Location','Bed','Ward');
		$wardData = $this->Ward->read(null,$wardId);			
		$noOfRooms = $wardData['Ward']['no_of_rooms'];
		$noOfRoomsOccupied = count($wardData['Room']);
 	
		if($noOfRoomsOccupied >= $noOfRooms && !empty($wardId)){  
 
			$this->Session->setFlash(__('Max Rooms created.'),'default',array('class'=>'error'));
			$this->redirect(array("controller" => "rooms", "action" => "index",$wardId));
		} else {
			if(!empty($this->request->data)){	
				// commented by atul on 13/03/2015
			/*	$isExist = $this->Room->find('count',array('conditions'=>array('Room.name'=>$this->request->data['Room']['name'] 
    													   ,'Room.location_id'=>$this->Session->read('locationid')))) ;
    		 	if($isExist){
    		 		$this->Session->setFlash(__('Room name already exist.'),true,array('class'=>'error'));
					$this->redirect($this->referer());
    		 	}*/
				$this->request->data['Room']['created_by']=$this->Session->read('userid');
				$this->request->data['Room']['modified_by']=$this->Session->read('userid');
				$this->request->data['Room']['create_time']=date("Y-m-d H:i:s");
				$this->request->data['Room']['modify_time']=date("Y-m-d H:i:s");
				$this->request->data['Room']['is_active']=1;
				$this->request->data["Room"]['ward_id'] = $wardId;
				$this->request->data['Room']['location_id']=$this->Session->read('locationid');
				if($this->Room->save($this->request->data['Room'])){
					for($i=1;$i<=$this->request->data['Room']['no_of_beds'];$i++){
						$data['Room']['room_id'] = $this->Room->id;
						$data['Room']['location_id'] = $this->Session->read('locationid');
						$data['Room']['created_by'] = $this->Session->read('userid');
						$data['Room']['modified_by'] = $this->Session->read('userid');
						$data['Room']['create_time'] = date('Y-m-d H:i:s');
						$data['Room']['modify_time'] = date('Y-m-d H:i:s');
						$data['Room']['bedno'] = $i;
						$this->Bed->save($data['Room']);
						$this->Bed->id='';
					}
					$this->Session->setFlash(__('Room Created Successfully', true));
					$this->redirect(array("controller" => "rooms", "action" => "index",$wardId));	
				}
						
			 }
			
		}
		$this->set('wardId',$wardId);
		$wardName = $wardData['Ward']['name'];
		$this->set(compact('wardName'));		
		
	}
	
	
	public function edit($room_id='',$ward_id=''){#echo $ward_id;exit;
		$this->uses = array('Location','Ward','Bed');
		$this->Room->unbindModel(array(
 				'hasMany' => array( 											 
					'Bed'
    	)),false);
    	$this->Ward->unbindModel(array(
 				'hasMany' => array( 											 
					'Room'
    	)),false);
        //pr($this->request->data);exit;
    	if($this->request->data){
    		$this->request->data['Room']['modified_by'] = $this->Session->read('userid');
    		$this->request->data['Room']['modify_time'] = date('Y-m-d H:i:s');
    		$room_id = $this->request->data['Room']['id'];
    		$roomDetails = $this->Room->read(null,$room_id);
    		$oldNoOfBeds = $roomDetails['Room']['no_of_beds'];
    		$newNoOfBeds = $this->request->data['Room']['no_of_beds'];
    		// commented by atul on 13/03/2015
    		/*$isExist = $this->Room->find('count',array('conditions'=>array('Room.name'=>$this->request->data['Room']['name'],
    		'Room.id !='=>$room_id,'Room.location_id'=>$this->Session->read('locationid')))) ;
    		
    		if($isExist){
    			$this->Session->setFlash(__('Room name already exist '),'default',array('class'=>'error'));
    			$this->redirect($this->referer());
    		}*/
    		
    		if($newNoOfBeds < $oldNoOfBeds){
    			$this->Session->setFlash(__('You can not decrease beds from room'),'default',array('class'=>'error'));
    			$this->redirect(array("controller" => "rooms", "action" => "edit",$room_id));
    		}
    			#pr($this->request->data);exit;
    		if($this->Room->save($this->request->data)){ 			
    			
    			if($newNoOfBeds > $oldNoOfBeds){
    				for($i=$oldNoOfBeds+1;$i<=$newNoOfBeds;$i++){
						$data['Room']['room_id'] = $this->Room->id;
						$data['Room']['location_id'] = $this->Session->read('locationid');
						$data['Room']['created_by'] = $this->Session->read('userid');
						$data['Room']['modified_by'] = $this->Session->read('userid');
						$data['Room']['create_time'] = date('Y-m-d H:i:s');
						$data['Room']['modify_time'] = date('Y-m-d H:i:s');
						$data['Room']['bedno'] = $i;
						$this->Bed->save($data['Room']);
						$this->Bed->id='';
					}
    			}
    			$this->Session->setFlash(__('Room Updated Successfully', true));
    			$this->redirect(array("controller" => "rooms", "action" => "index",$roomDetails['Room']['ward_id']));
    			
    		}
    		
    		
    	}
		$roomDetails = $this->Room->read(null,$room_id);
		$wards = $this->Ward->find('list',array('conditions'=>array('location_id'=>$roomDetails['Room']['location_id'])));
		
		$this->set('roomDetails',$roomDetails);
		$this->data  = $roomDetails ;
		$this->set('wards',$wards);
		$wardDetails =$this->Ward->read(null,$roomDetails['Room']['ward_id']);
		$this->set('wardDetails',$wardDetails);
		//pr($wardDetails);exit;
		$wardName = $wardDetails['Ward']['name'];
		$this->set('room_id',$room_id);
		$this->set('ward_id',$ward_id);
		$this->set('wardName',$wardName);
	}
	function getAllRooms($ward_id){
		$this->layout = false ;
		$this->autoRender = false ;
		return json_encode($this->Room->getAllRooms($ward_id)) ;
		exit;
	}
	
}