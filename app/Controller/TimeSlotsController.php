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

class TimeSlotsController extends AppController {

	public $name = 'TimeSlots';
	public $helpers = array('Html','Form', 'Js','DateFormat','General');
	public $components = array('RequestHandler','Email','ImageUpload','DateFormat');
	public $uses = array('TimeSlot',"User","StaffPlan");

	function index(){
                $this->redirect(array('action'=>'monthlyRosterChart'));
		$this->uses=array('Ward','Role');
		$this->set('roles',$this->Role->getRoles());
		$this->set('wards',$this->Ward->getAvailableWards());
	}
	
	function add($id = null){
		$this->uses=array('Ward','Role','User','Room','Configuration');
		if(!empty($this->request->data['TimeSlot'])){
			$this->request->data['TimeSlot']['location_id'] = $this->Session->read('locationid');
			$time =  explode(" ",DateFormatComponent::formatDate2STD($this->request->data["TimeSlot"]['date_from'],Configure::read('date_format')));
			$firstMondayInWeek = strtotime('last sunday', strtotime($time[0]));
			$nextFiveWeekDays = array();
			for ($days = 0; $days <= 6; $days++) {
				$nextFiveWeekDays[] = date('Y-m-d', strtotime(" $days days", $firstMondayInWeek));

			}
			if(isset($this->request->data['TimeSlot']['is_recurring'])){
				$this->request->data['TimeSlot']['monday'] = "0";
				$this->request->data['TimeSlot']['tuesday'] = "0";
				$this->request->data['TimeSlot']['wednesday'] = "0";
				$this->request->data['TimeSlot']['thursday'] = "0";
				$this->request->data['TimeSlot']['friday'] ="0";
				$this->request->data['TimeSlot']['saturday'] = "0";
				$this->request->data['TimeSlot']['sunday'] = "0";
				$timeslot = $this->TimeSlot->find("first",array("conditions"=>array(
						"TimeSlot.user_id"=> $this->request->data['TimeSlot']['user_id'],
						"TimeSlot.ward_id"=> $this->request->data['TimeSlot']['ward_id'],
						"TimeSlot.location_id"=> $this->Session->read('locationid'),
						"TimeSlot.date_from"=> $time[0],
				)));
				$this->request->data['TimeSlot']['date_from'] = $time[0];
				if(!isset($timeslot)){
					;
					$this->request->data['TimeSlot']['created_by'] = $this->Session->read('userid');
					$this->request->data['TimeSlot']['create_time'] = date("Y-m-d H:i:s");
					$this->TimeSlot->create();
				}else{
					$this->request->data['TimeSlot']['modified_by'] = $this->Session->read('userid');
					$this->request->data['TimeSlot']['modify_time'] = date("Y-m-d H:i:s");
					$this->request->data['TimeSlot']['id'] = $timeslot['TimeSlot']['id'];
				}
				$this->TimeSlot->save($this->request->data['TimeSlot']);
			}else{
				for($i =0; $i<count($nextFiveWeekDays);$i++){
					$day = strtolower(date('l', strtotime($nextFiveWeekDays[$i])));
					if (array_key_exists($day, $this->request->data['TimeSlot'])&& $this->request->data['TimeSlot'][$day] == "1" ) {
						echo "<li>1";
						$timeslot = $this->TimeSlot->find("first",array("conditions"=>array(
								"TimeSlot.user_id"=> $this->request->data['TimeSlot']['user_id'],
								"TimeSlot.ward_id"=> $this->request->data['TimeSlot']['ward_id'],
								"TimeSlot.location_id"=> $this->Session->read('locationid'),
								"TimeSlot.date_from"=> $nextFiveWeekDays[$i],
						)));
						$this->request->data['TimeSlot']['date_from'] = $nextFiveWeekDays[$i];
						$this->request->data['TimeSlot']['is_recurring'] = "0";
						if(!isset($timeslot)){
							;
							$this->request->data['TimeSlot']['created_by'] = $this->Session->read('userid');
							$this->request->data['TimeSlot']['create_time'] = date("Y-m-d H:i:s");
							$this->TimeSlot->create();
						}else{
							$this->request->data['TimeSlot']['modified_by'] = $this->Session->read('userid');
							$this->request->data['TimeSlot']['modify_time'] = date("Y-m-d H:i:s");
							$this->request->data['TimeSlot']['id'] = $timeslot['TimeSlot']['id'];

						}
						$this->TimeSlot->save($this->request->data['TimeSlot']);
					}

				}

			}


			$errors = $this->TimeSlot->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
				if($id==null)
					$this->redirect(array('action'=>'add',$this->request->data['TimeSlot']['patient_id']));
				else
					$this->redirect(array('action'=>'add',$id));
			}else {
				$this->Session->setFlash(__('Record added successfully'),'default',array('class'=>'message'));
				$this->redirect(array('action'=>'index',$this->request->data['TimeSlot']['patient_id']));
			}
		}
		//retrieve previous added entry for update
		if(!empty($id)){
			$queryRes = $this->TimeSlot->read(null,$id) ;
			//fetch user name

			$users = $this->User->getUsersByRole($queryRes['TimeSlot']['role_id']) ;
			//Fetch Rooms for selected ward
			$rooms = $this->Room->getAllRooms($queryRes['TimeSlot']['ward_id']) ;

			$this->data  = $queryRes ;


		}
		//Fetch shifts from configuration
		$oldShiftData= $this->Configuration->find('first',array('conditions'=>array('Configuration.name'=>Configure::read('shifts')))); 
		$oldShiftData['Configuration']['value'] = unserialize($oldShiftData['Configuration']['value']);
		$shiftNames = $oldShiftData['Configuration']['value']['ShiftName'];
		$shiftTimes = $oldShiftData['Configuration']['value']['ShiftsTime'];
		foreach($shiftNames as $key=>$shiftList){
			$shifts[$shiftList] = $shiftTimes[$key]['start'].' - '.$shiftTimes[$key]['end'];
		}
		$this->set('shifts',$shifts);
		$this->set(array('users'=>$users));
		$this->set('wards',$this->Ward->getAvailableWards());
		$this->set('roles',$this->Role->getRoles());
	}

	function get_staff_time_chart($role_id,$ward_id,$date = null){
		$this->layout = false;
		$array_for_shift = array(
		 	"morning"=>array("morning","morning","morning","evening","evening","evening","night","night","night"),
				"evening"=>array("evening","evening","evening","night","night","night","morning","morning","morning"),
				"night"=> array("night","night","night","morning","morning","morning","evening","evening","evening")
		);
		$datesofweek = array();
		if($date == null || $date == "null"){
			$date = date("Y-m-d");
		}
		$date =str_replace(" ","",$date);

		if(date("l",strtotime($date)) == "Monday"){
			$firstMondayInWeek =  strtotime($date);
	 }else{
	 	$firstMondayInWeek = strtotime('last Monday', strtotime($date));
	 }
	  
	 $WeekDays = array();
	 $timestampofdate = array();
	 for ($days = 0; $days <= 6; $days++) {
	 	$datesofweek[] =   date('Y-m-d', strtotime("$days day", $firstMondayInWeek));
	 }

		/* for($i=1;$i<=7;$i++){
		 array_push($datesofweek,date('Y-m-d',time()+( $i - date('w'))*24*3600));
		}
		*/

	 $queryRes = $this->TimeSlot->find("all",array("conditions"=>
	 		array("TimeSlot.role_id"=>$role_id,"TimeSlot.ward_id"=>$ward_id,
	 				"TimeSlot.location_id"=>$this->Session->read('locationid')),
	 		"order"=>"TimeSlot.date_from")) ;


	 $timeslot = array();
	 if(count( $queryRes )>0){
		 foreach($datesofweek as $date){
		 	foreach($queryRes as $key=>$value){

		 		$this->User->unbindModel(array( 'belongsTo' => array('City','State','Country','Role')   ));
					$user = $this->User->read(null,$value['TimeSlot']['user_id']);
					$timeslot[$user['User']['id']]['first_name'] = $user['User']['first_name'];
					$timeslot[$user['User']['id']]['last_name'] = $user['User']['last_name'];
					$timeslot[$user['User']['id']]['Initial'] = $user['Initial']['name'];
					$timeslot[$user['User']['id']]['id'] = $user['User']['id'];
					if( $date >= $value['TimeSlot']['date_from'] && $value['TimeSlot']['is_recurring'] == "1" ){
						$date_range = $this->GetDays($value['TimeSlot']['date_from'],$date);
						$index = 0;
						for($i = 0; $i<=$date_range;$i++){
							if(!isset($array_for_shift[$value['TimeSlot']['time_slot']][$index]))
								$index = 0;
							if($i == $date_range)
								$timeslot[$user['User']['id']]['timeslot'][$date] = $array_for_shift[$value['TimeSlot']['time_slot']][$index];
							$index++;
						}
					}else if($date == $value['TimeSlot']['date_from'] && $value['TimeSlot']['is_recurring'] == "0"){
						if($value['TimeSlot']['is_day_of'] == "1")
							$timeslot[$user['User']['id']]['timeslot'][$date] = "off";
						else
							$timeslot[$user['User']['id']]['timeslot'][$date] = $value['TimeSlot']['time_slot'];
					}
					if(!isset($timeslot[$user['User']['id']]['timeslot'][$date]))
						$timeslot[$user['User']['id']]['timeslot'][$date] = "Not Available";

		 	}

		 }


		 foreach($timeslot as $key => $value){
			 foreach($value['timeslot'] as $k => $v){
			 	$this->StaffPlan->unbindModel(array("belongsTo"=>array("User","Initial")));
					$staffPlan = $this->StaffPlan->find("first",array(
							"conditions"=>array(
									"StaffPlan.user_id"=>$key,
									"StaffPlan.location_id"=>$this->Session->read('locationid'),
									"DATE_FORMAT(StaffPlan.starttime, '%Y-%m-%d') <= '".$k."' and DATE_FORMAT(StaffPlan.endtime, '%Y-%m-%d') >='".$k."'" ,
							)
					));
					if($staffPlan) {
						$timeslot[$key]['timeslot'][$k] = "leave";
					}
			 }
		 }
		 $this->set('data',$timeslot);
	 }else{
	 	$this->set('message',"No Data Found.");
	 }
	 $this->set('date',$date);
	}
	public function set_day_off(){
		$this->layout = false;
		if (!empty($this->request->data)) {
			 
			if($this->request->data['remove'] == "1"){
				$this->TimeSlot->updateAll(	array("TimeSlot.is_day_of"=>1),
						array("TimeSlot.role_id"=>$this->request->data['role'],
								"TimeSlot.ward_id"=>$this->request->data['ward'],
								"TimeSlot.location_id"=>$this->Session->read('locationid'),
								"TimeSlot.date_from"=>$this->request->data['date'],
								"TimeSlot.user_id"=>$this->request->data['userid'],
						)
				);

			}else{
				$data['TimeSlot']['date_from'] = $this->request->data['date'];
				$data['TimeSlot']['user_id'] = $this->request->data['userid'];
				$data['TimeSlot']['role_id'] = $this->request->data['role'];
				$data['TimeSlot']['ward_id'] = $this->request->data['ward'];
				$data['TimeSlot']['created_by'] = $this->Session->read('userid');
				$data['TimeSlot']['create_time'] = date("Y-m-d H:i:s");
				$data['TimeSlot']['is_recurring'] = "0";
				$data['TimeSlot']['is_day_of'] = "1";
				$data['TimeSlot']['location_id'] = $this->Session->read('locationid');
				$this->TimeSlot->create();
				$this->TimeSlot->save($data['TimeSlot']);
			}
			$errors = $this->TimeSlot->invalidFields();
			if(!empty($errors)) {
				echo "false";
			}else{
				echo "true";
			}
		}

	 exit;

	}
	private function  GetDays($sStartDate, $sEndDate){
		$date1 = new DateTime($sStartDate);
		$date2 = new DateTime($sEndDate);
		$diff = $date2->diff($date1);
		return $diff->format("%a");
	}
	 
	/**
	 * 
	 * @param unknown_type $id
	 */
	public function add_shifts(){
		$this->set('title_for_layout', __('Add Shifts', true));
		$this->uses=array('Configuration');
		if(isset($this->request->data) && !empty($this->request->data)){
			$this->Configuration->setDutyShift($this->request->data['Configuration']);
		}
		$oldShiftData = $this->Configuration->find('first',array('conditions'=>array('Configuration.name'=>Configure::read('shifts'))));
		$oldShiftData['Configuration']['value'] = unserialize($oldShiftData['Configuration']['value']);
		$this->set('oldShiftData',$oldShiftData);
	}

	/**
	 * function to add duty roster plan for user
	 * @method POST
	 * @author Gaurav Chauriya
	 */
	public function addDutyRoster(){
		$this->layout = 'advance';
		$this->set('title_for_layout', __('Monthly Roster', true));
		$this->uses = array('DutyRoster','Role','Ward');
		$this->set('roles',$this->Role->getRoles());
		$this->set('wards',$this->Ward->getAvailableWards());
		if($this->request->data){
			$this->DutyRoster->createMonthlyRoster($this->request->data['DutyRoster']);
			$this->redirect(array('action'=>'index'));
		}
	}
	/**
	 * function to fetch user list by role 
	 * @param intger $role_id
	 * @author Gaurav Chauriya
	 */
	function getUsersByRole($role_id){
		$this->loadModel('User');
		$this->User->unbindModel(array( 'belongsTo' => array('City','State','Country','Role','Initial')   ));
		
		$this->User->bindModel(array('belongsTo'=>array('Initial' => array('foreignKey' =>'initial_id'))
		));
		$users = $this->User->find('list',array('conditions'=>array('User.location_id' => $this->Session->read('locationid'),'User.role_id' =>$role_id,
   						'User.is_active'=>'1','User.is_deleted'=>0),
				'fields'=>array('full_name'), 'recursive' => 1));
		echo json_encode($users);
		exit;
	}
	
	/**
	 * ajax function to get list of months for which duty start date is set
	 * @method GET
	 * @author Gaurav Chauriya
	 */
	public function getDutyMonthForUser($id){
		//$this->layout = false;
		$this->loadModel('DutyPlan'); 		 
		 $plan = $this->DutyPlan->find('all',array('fields'=>array('id','first_duty_date','first_shift','allow_day_off'),
				'conditions'=>array($this->params->query,'first_duty_date >=' =>date('Y-m-01'),'is_roster_set'=>0,'is_deleted'=>0,'location_id'=>$this->Session->read('locationid'))));
		
		echo json_encode($plan);
		exit;
	
	}
	public function setRosterMonth($id){
		$this->uses = array('DutyPlan');
			
		
	}
	/**
   	 * function to set start date of duty for each month for users
   	 * @method POST
   	 * @author Swati Newale
   	 */
   	public function dutyPlan(){
   		$this->layout = 'advance';
   		$this->set('title_for_layout', __('Duty Plans', true));
   		$this->uses = array('Role','User');
   		$this->set('roles',$this->Role->getRoles());
   	}
   	/**
   	 * function to get user shift start date form
   	 * @author Swati Newale
   	 */
   	public function ajaxGetListOfuser(){
   		//$this->layout = false;
   		$this->uses = array('Role','User','Configuration','DutyPlan');
   		if($this->request->data){
   			$this->DutyPlan->saveDutyPlan($this->request->data);
   			$this->Session->setFlash(__('Duty plan added successfully', true));
   			$this->redirect(array('action'=>'dutyPlan'));
   		}
   		$this->User->unBindModel(array('belongsTo'=>array('City','State','Role','Initial','Country')));
   		$yearCondition = ( $this->params->query['month'] < date('n')  ) ? date('Y') + 1 : date('Y');
   		 
   		$this->User->bindModel(array('belongsTo' => array(
   				'DutyPlan'=>array('foreignKey'=>false ,'conditions'=>array('DutyPlan.user_id= User.id',
   						"DutyPlan.first_duty_date LIKE "=> $yearCondition."-".$this->params->query['month']."-%" )))));
   	
   		$user = $this->User->find('all', array('fields' => array('User.id','User.full_name','DutyPlan.id','DutyPlan.first_duty_date','DutyPlan.first_shift','DutyPlan.allow_day_off','DutyPlan.is_roster_set'), 
   				'conditions' => array('User.location_id' => $this->Session->read('locationid'),'User.role_id' =>$this->params->query['role_id'],
   						'User.is_active'=>'1','User.is_deleted'=>0 )));
   		$oldShiftData= $this->Configuration->find('first',array('conditions'=>array('Configuration.name'=>Configure::read('shifts'))));
   		$oldShiftData['Configuration']['value'] = unserialize($oldShiftData['Configuration']['value']);
   		$shiftNames = $oldShiftData['Configuration']['value']['ShiftName']; 
   		$shiftTimes = $oldShiftData['Configuration']['value']['ShiftsTime'];
   		foreach($shiftNames as $key=>$shiftList){ 
   			$shifts[$shiftList] = $shiftTimes[$key]['start'].' - '.$shiftTimes[$key]['end']; 
   		}
   		$this->set('yearCondition',$yearCondition);
   		$this->set('user',$user);
   		$this->set('shifts',$shifts);
   		$this->render('ajax_get_list_of_user');
   	}

	/**
	 * function to view chart for montly rosters
	 * @method GET
	 * @author Gaurav Chauriya
	 */
public function monthlyRosterChart(){
		$this->layout = 'advance';
                $this->loadModel('Role');
		$this->set('roles',$this->Role->getRoles());
	}
	
	/**
	 * function to view charting
	 * @author Gaurav Chauriya
	 */
	public function monthlyRosterChartView(){
		$this->layout = false;//'advance';// false;
		$this->uses = array('User','Configuration');
		$shiftData= $this->Configuration->find('first',array('conditions'=>array('Configuration.name'=>Configure::read('shifts'))));
		$shiftData['Configuration']['value'] = unserialize($shiftData['Configuration']['value']);
		$shiftNames = $shiftData['Configuration']['value']['ShiftName'];
		if($this->request->data){
			$this->loadModel('DutyRoster');
			$dutyRoster['id'] = $this->request->data['dutyRosterId'];
			if(in_array($this->request->data['shift'], $shiftNames)){
				$dutyRoster['shift'] =  $this->request->data['shift'] ;
				$dutyRoster['day_off'] =  '0';
			}elseif($this->request->data['shift'] == 'dutyONCash'){
				$dutyRoster['duty_on_cash'] = '1';
			}elseif($this->request->data['shift'] == 'removeDutyONCash'){
				$dutyRoster['duty_on_cash'] = '0';
			}else{
				$dutyRoster['day_off'] =  $this->request->data['shift'];
			}
			$this->DutyRoster->save($dutyRoster);
		}
		if($this->params->query){
			$this->loadModel('DutyPlan');
			$this->DutyPlan->updateAll(array('DutyPlan.duty_plan_approved' => "'1'"),array('DutyPlan.first_duty_date LIKE'=>date('Y-m-').'%'));
       }
		$this->User->unBindModel(array('belongsTo'=>array('City','State','Role','Initial','Country')));
		$this->User->bindModel(array(
				'hasOne'=>array(
						'DutyPlan'=>array('foreignKey'=>false,'conditions'=>array('DutyPlan.user_id = User.id'))),
				'hasMany'=>array(
						'DutyRoster'=>array('foreignKey'=>'user_id',
								'fields'=>array('DutyRoster.id','DutyRoster.role_id','DutyRoster.ward_id','DutyRoster.date','DutyRoster.shift','DutyRoster.day_off',
										'DutyRoster.duty_on_cash','DutyRoster.inouttime'),
								'conditions'=>array("DutyRoster.date BETWEEN '".date('Y-m-01')."' AND  '".date('Y-m-t')."'",
										'DutyRoster.location_id'=>$this->Session->read('locationid'),'DutyRoster.is_deleted'=>0)))));
		$rosterData = $this->User->find('all',array('fields'=>array('User.id','User.full_name','DutyPlan.duty_plan_approved'),
				'conditions'=>array('User.location_id'=>$this->Session->read('locationid'),'User.is_deleted'=>0,'User.is_active'=>1,'DutyPlan.first_duty_date LIKE'=>date('Y-m-').'%')));
		$this->set(compact('rosterData'));
		
		foreach($shiftData['Configuration']['value']['ShiftsTime'] as $timeKey=>$timeLimit){
			if(strtotime($shiftData['Configuration']['value']['ShiftsTime'][$timeKey]['start']) > strtotime($shiftData['Configuration']['value']['ShiftsTime'][$timeKey]['end']))
				$endDate = date('Y-m-d', strtotime('+1 day'));
			else 
				$endDate = date('Y-m-d');
			$datetime1 = new DateTime($endDate.' '.$shiftData['Configuration']['value']['ShiftsTime'][$timeKey]['end']);
			$datetime2 = new DateTime(date('Y-m-d ').$shiftData['Configuration']['value']['ShiftsTime'][$timeKey]['start']);
			$interval = $datetime1->diff($datetime2);
			$hour = ( $interval->i != 0 ) ? (int) $interval->h + 0.5 : $interval->h;
			$shiftTimes[strtolower($shiftNames[$timeKey])] = $hour;
			$shiftRange[strtolower($shiftNames[$timeKey])] =  $timeLimit;
		}
		$this->set(compact('shiftNames','shiftTimes','shiftRange'));
		$this->render('ajax_monthly_roster_chart_view');
	}

	/**
	 * function to view new charting
	 * @author Swapnil Sharma 18-02-2016 in hope swati
	 */
	public function newMonthlyRosterChartView(){
		$this->layout = "ajax";//'advance';// false;
		$this->uses = array('User','Configuration');
		$shiftData= $this->Configuration->find('first',array('conditions'=>array('Configuration.name'=>Configure::read('shifts'))));
		$shiftData['Configuration']['value'] = unserialize($shiftData['Configuration']['value']);
		//$shiftNames = $shiftData['Configuration']['value']['ShiftName'];
		$this->loadModel('Shift');
		$shiftNames = $this->Shift->getAllShifts();
	
		if($this->request->data){
			$this->loadModel('DutyRoster');
			//$dutyRoster['id'] = $this->request->data['dutyRosterId'];
			$dutyRoster['user_id'] =  $this->request->data['user_id'];
			$dutyRoster['role_id'] =  $this->request->data['user_role_id'];
			//$dutyRoster['date'] = $this->request->data['Year']."-".$this->request->data['month']."-".$this->request->data['date'];
			$dutyRoster['date'] = $this->request->data['date'];
			$prevData = $this->DutyRoster->find('first',array('conditions'=>array('user_id'=>$this->request->data['user_id'],'date'=>$dutyRoster['date'])));
			if(!empty($prevData['DutyRoster']['id'])){
				$this->DutyRoster->id = $prevData['DutyRoster']['id'];
				$dutyRoster['modified_by'] =  $this->Session->read('userid');
				$dutyRoster['modify_time'] =  date("Y-m-d H:i:s");
			}else{
				$dutyRoster['created_by'] =  $this->Session->read('userid');
			}
	
			$shiftId = array_search($this->request->data['shift'], $shiftNames);
			//if(in_array($this->request->data['shift'], $shiftNames)){
			if(!empty($shiftId)){
				$dutyRoster['shift'] = $shiftId;// $this->request->data['shift'] ;
				$dutyRoster['day_off'] =  '0';
			}elseif($this->request->data['shift'] == 'dutyONCash'){
				$dutyRoster['duty_on_cash'] = '1';
			}elseif($this->request->data['shift'] == 'removeDutyONCash'){
				$dutyRoster['duty_on_cash'] = '0';
			}else{
				$dutyRoster['day_off'] =  $this->request->data['shift'];
			}
			$this->DutyRoster->save($dutyRoster);
		}
	
		$conditions = array();
		$year = date("Y");
		$month = date("m");
	
		if($this->request->data){
			$year = $this->request->data['Year'];
			$month = $this->request->data['month'];
			if(!empty($this->request->data['role_id'])){
				$conditions['User.role_id'] = $this->request->data['role_id'];
			}
		}
		if($this->params->query){
			$year = $this->params->query['Year'];
			$month = $this->params->query['month'];
			if(!empty($this->params->query['role_id'])){
				$conditions['User.role_id'] = $this->params->query['role_id'];
			}
		}
	
		   $firstDate = date('Y-m-01', strtotime("$year-$month"));
           $lastDate = date('Y-m-t', strtotime("$year-$month"));
		
		$dateList = $this->DateFormat->get_date_range($firstDate,$lastDate);
	  
		$leaveTypes = $this->Configuration->getLeaveTypeList();
		$holidays = $this->Configuration->getPublicHolidays($year,$month);
	
		$this->loadModel('DutyRoster');
		$this->DutyRoster->bindModel(array(
				'belongsTo'=>array(
						'User'=>array(
								'foreignKey'=>'user_id',
								'type'=>'inner'
						)
				)
		));
	
		$dailyRosterData = $this->DutyRoster->find('all',array(
				'conditions'=>array($conditions,'DutyRoster.date BETWEEN ? AND ?'=>array($firstDate. "00:00:00",$lastDate.' 23:59:59')),
				'fields'=>'DutyRoster.id, DutyRoster.user_id, DutyRoster.date, DutyRoster.inouttime, DutyRoster.shift, DutyRoster.day_off, DutyRoster.is_present'));
		 
		foreach($dailyRosterData as $key => $val){
			$rosterData[$val['DutyRoster']['user_id']][$val['DutyRoster']['date']] = $val['DutyRoster'];
		}
		$this->set(compact(array('rosterData','firstDate')));
	
		$this->loadModel('Shift');
		//get all Users
		$this->User->belongsTo = array();
		$this->User->bindModel(array(
				'belongsTo'=>array(
						'PlacementHistory'=>array(
								'foreignKey'=>false,
								'type'=>'inner',
								'conditions'=>array('PlacementHistory.user_id = User.id')
						)
				)
		),false);
	
		$users = $this->User->find('all',array(
				'fields'=>array('User.id, CONCAT(User.first_name," ",User.last_name) as full_name, User.role_id', 'PlacementHistory.shifts'),
				'conditions'=>array($conditions,'User.is_deleted'=>'0','PlacementHistory.shifts !='=>'','User.location_id'=>$this->Session->read('locationid')),
				'order'=>array('User.first_name'=>'ASC','User.last_name'=>'ASC')));
	
		$this->set('users',$users);
		$shiftData = $this->Shift->getAllShiftDetails();
	
		foreach($shiftData as $timeKey => $shiftValue){
			$timeDifference = $this->DateFormat->getTimeDifference($shiftValue['Shift']['from_time'],$shiftValue['Shift']['to_time']);
			$shiftTimes[$shiftValue['Shift']['name']] = $timeDifference;
			$shiftRange[$shiftValue['Shift']['name']] =  $timeLimit;
			$shiftAlias[$shiftValue['Shift']['name']] = $shiftValue['Shift']['alias'];
			$shiftStart[$shiftValue['Shift']['name']] =  $shiftValue['Shift']['from_time'];
			$shiftEnd[$shiftValue['Shift']['name']] =  $shiftValue['Shift']['to_time'];
		}
		$this->set('shifts',$this->Shift->getAllShifts());
		$this->loadModel('DutyApproval');
		$isApproved = $this->DutyApproval->checkApproval($year,$month);
		$this->set(compact('shiftNames','shiftTimes','shiftRange','shiftAlias','isApproved','month','year','shiftStart','shiftEnd','leaveTypes','holidays','dateList'));
		$this->render('new_ajax_monthly_roster_chart_view');
	}
	
	
	
	//function to add shifts by Swapnil on 15-02-2016 in hope swati 09-04-2016
	public function shiftsMaster(){
		$this->set('title_for_layout',__(': Shifts Master'));
		$this->layout = "advance";
		$this->uses = array("Shift");
		$results = $this->Shift->find('all',array('conditions'=>array('is_deleted'=>'0')));
		$this->set(compact('results'));
	}
	
	//function to save or update shift
	public function saveShift(){
		$this->autoRender = false;
		$this->layout = "ajax";
		$this->loadModel('Shift');
		if(!empty($this->request->query)){
			if($this->Shift->saveShift($this->request->query)){
				echo "true";
			}else{
				echo "false";
			}
		}else{
			echo "false";
		}
	}
	/**
	 * function to approve roster
	 * @author swatin
	 */
	public function monthlyRosterApproval($date=null,$approval){
		$this->layout = "false";//'advance';// false;
		$this->loadModel('DutyApproval');
		$this->autoRender = false;
		//updated by Swapnil - 20.02.2016
		if(!empty($this->request->query)){
			if($this->DutyApproval->saveDutyApproval($this->request->query['Year'],$this->request->query['month'],$this->request->query['is_approved'])){
				echo "true";
			}
		}
	} 	
	
	
	public function ajaxAttendanceDetail($user_id,$date){
		$this->layout = "ajax";
		$this->uses = array('User','LeaveApproval','Configuration');
		$this->User->bindModel(array(
				'belongsTo'=>array(
						'Location'=>array(
								'primaryKey'=>'location_id'
						)
				)
		));
	
		//$firstDateOfMonth = date('Y-m-01',strtotime($date));
		//$lastDateOfMonth = date('Y-m-t',strtotime($date));
	
		$firstDateOfMonth = date('Y-m-'.Configure::read('payrollFromDate'), strtotime('-1 month', strtotime($date)));
		$lastDateOfMonth = date('Y-m-'.Configure::read('payrollToDate'), strtotime($date));
	
		$userData = $this->User->read(array('CONCAT(User.first_name," ",User.last_name) as full_name','Role.name','Location.name'),$user_id);
		$attendanceData = $this->getAllAttendanceDetail($user_id,$firstDateOfMonth,$lastDateOfMonth);
	
		//get current month leaves of that user
		$this->loadModel('LeaveApproval');
		$leaveDetail = $this->LeaveApproval->getAllLeavesListofUser($user_id,$firstDateOfMonth,$lastDateOfMonth);
	
		//to get leave types
		$this->loadModel('Configuration');
		$leaveTypes = $this->Configuration->getLeaveTypeList();
	
		//get all assigned leaves to that user
		$this->loadModel('EmpLeaveBenefit');
		$userLeaveDetail = $this->EmpLeaveBenefit->getEmpLeaveDetail($user_id);
	
		//get any paid leaves (leaves type wise) of current user
		$paidLeaves = $this->getPaidLeave($user_id,$firstDateOfMonth,$lastDateOfMonth);
	
		//get count of leaves
		$LeavesTaken = $this->getLeaveTypeCount($paidLeaves);
	
		//get previous leaves of current year
		$previousLeaveDetails = $this->getAllPreviousLeave($user_id,$date);
	
		foreach($previousLeaveDetails as $key => $val){
			$previousLeave[$key] = count($val);
		}
	
		//get month holidays
		$publicHoliday = $this->getPublicHolidays($firstDateOfMonth,$lastDateOfMonth);
	
		$this->set(compact(array('attendanceData','userData','leaveDetail','leaveTypes','userLeaveDetail','previousLeave','LeavesTaken','publicHoliday')));
	}
	
	/*
	 * function to update leave approval
	* ajax
	* @author : Swapnil
	* @created : 21.03.2016
	*/
	public function updateAjaxLeaveApproval(){
		$this->autoRender = false;
		$this->loadModel('LeaveApproval');
		if(!empty($this->request->data)){
			$this->LeaveApproval->id = $this->request->data['leave_approval_id'];
			$this->request->data['approved_by'] = $this->Session->read('userid');
			$this->request->data['approved_date'] = date("Y-m-d H:i:s");
			if($this->LeaveApproval->save($this->request->data)){
				echo "true";
			}
		}
	}
	

	//function to add attendance by Swapnil
	public function addAttendance($date=null){
		$this->set('title_for_layout',__(' : Attendance'));
		$this->layout = "advance";
	}
	 
	//function to update in-out timing attendance by Swapnil
	public function updateInOutTime(){
		$this->layout = "ajax";
		$this->autoRender = false;
		$this->loadModel('DutyRoster');
		if(!empty($this->request->query)){
			$data = $this->request->query;
			$dutyData = $this->DutyRoster->find('first',array(
					'fields'=>array('id', 'user_id', 'date', 'intime', 'outime'),
					'conditions'=>array('user_id'=>$data['user_id'],'date'=>$data['date'])));
			$data['intime'] = $data['intime_hour'].":".$data['intime_minute'].":".$data['intime_second'];
			$data['outime'] = $data['outtime_hour'].":".$data['outtime_minute'].":".$data['outtime_second'];
			if(!empty($dutyData)){
				$this->DutyRoster->id = $dutyData['DutyRoster']['id'];
			}
			if($this->DutyRoster->save($data)){
				echo "true";
			}
		}
	}
	/*
	 * function to get the attendance
	* @author : Swapnil
	* @created : 20.02.2016
	*/
	public function getAttendance($date=null,$role_id=null){
		$this->uses = array('User');
		$this->loadModel('Shift');
		$this->layout = "ajax";
		$this->loadModel('Role');
		$this->set('roles',$this->Role->getRoles());
	
		if(empty($date)) $date = date("Y-m-d");
		$conditions = array();
		if(!empty($role_id)){
			$conditions['User.role_id'] = $role_id;
			$this->set(compact('role_id'));
		}
		if(date("Y-m-d",strtotime($date)) > date("Y-m-d")){
			$date = date("Y-m-d");
		}
	
		$firstDateOfMonth = date('Y-m-01',strtotime($date));
		$lastDateOfMonth = date('Y-m-t',strtotime($date));
		$this->loadModel('DutyRoster');
		if(!empty($this->request->query) && $this->request->query['user_id'] != ''){
			$data = $this->request->query;
			$dutyData = $this->DutyRoster->find('first',array(
					'fields'=>array('id', 'user_id', 'date', 'intime', 'outime'),
					'conditions'=>array('user_id'=>$data['user_id'],'date'=>$data['date']/*,'location_id'=>$this->Session->read('locationid')*/)
			));
	
			$data['intime'] = $dutyData['DutyRoster']['intime'];
			$data['outime'] = $dutyData['DutyRoster']['outime'];
	
			if($data['is_intime_check']=='1'){
				$data['intime'] = $data['intime_hour'].":".$data['intime_minute'].":".$data['intime_second'];
			}
			if($data['is_outtime_check']=='1'){
				$data['outime'] = $data['outtime_hour'].":".$data['outtime_minute'].":".$data['outtime_second'];
			}
			 
			$error = false;
			if(!isset($data['is_intime_check']) && !isset($data['is_outtime_check']) && empty($dutyData) && !empty($data['remark'])){
				$error = true;
			}
			if(!empty($data['intime']) && !empty($data['outime'])){
				$data['is_present'] = "N";
			}else{
				$data['is_present'] = "Y";
			}
			$data['is_edited'] = "1";
			$data['location_id'] = $this->Session->read('locationid');
			if(!empty($dutyData)){
				$this->DutyRoster->id = $dutyData['DutyRoster']['id'];
				$data['modified_by'] = $this->Session->read('userid');
				$data['modify_time'] = date("Y-m-d H:i:s");
			}else{
				$data['created_by'] = $this->Session->read('userid');
			}
			if($error==false){
				$this->DutyRoster->save($data);
			}
		}
		//get all Users
		$this->User->belongsTo = array();
		$this->User->bindModel(array(
				'belongsTo'=>array(
						'PlacementHistory'=>array(
								'foreignKey'=>false,
								'type'=>'inner',
								'conditions'=>array('PlacementHistory.user_id = User.id')
						)
				)
		),false);
	
		$users = $this->User->find('all',array(
				'fields'=>array('User.id,User.role_id, CONCAT(User.first_name," ",User.last_name) as full_name', 'PlacementHistory.shifts'),
				'conditions'=>array($conditions,'User.is_deleted'=>'0','PlacementHistory.shifts !='=>''/*,'User.location_id'=>$this->Session->read('locationid')*/),
				'order'=>array('User.first_name'=>'ASC','User.last_name'=>'ASC')));
		 
		$this->set('users',$users);
		$this->set('todayDate',$date);
		$shiftData = $this->Shift->getAllShiftDetails();
		foreach($shiftData as $timeKey => $shiftValue){
			$shiftAlias[$shiftValue['Shift']['name']] = $shiftValue['Shift']['alias'];
		}
		$this->set('shifts',$this->Shift->getAllShifts());
	
		$this->loadModel('DutyRoster');
		$this->DutyRoster->bindModel(array(
				'belongsTo'=>array(
						'User'=>array(
								'foreignKey'=>'user_id',
								'type'=>'inner'
						)
				)
		));
	
		$dailyRosterData = $this->DutyRoster->find('all',array(
				'conditions'=>array($conditions,'DutyRoster.date BETWEEN ? AND ?'=>array($firstDateOfMonth,$lastDateOfMonth)/*,'DutyRoster.location_id'=>$this->Session->read('locationid')*/),
				'fields'=>'DutyRoster.id, DutyRoster.user_id, DutyRoster.date, DutyRoster.inouttime, DutyRoster.shift, DutyRoster.day_off, DutyRoster.is_present, DutyRoster.intime, DutyRoster.outime, DutyRoster.remark'));
	
		foreach($dailyRosterData as $key => $val){
			$rosterData[$val['DutyRoster']['user_id']][$val['DutyRoster']['date']] = $val['DutyRoster'];
		}
		$this->set(compact('rosterData'));
		$this->set(compact(array('attData','shiftData','shiftAlias')));
	}
	
	
	
	/*
	 * function to generate the salary statement either bank statement or cash statement
	* @author : Swapnil
	* @created : 09.03.2016
	*/
	public function generateSalary($statement,$date){
		$this->layout = "advance";
		$this->set('title_for_layout',__(' : Generate Salary'));
		if(empty($date)) $date = date("Y-m-d");
		$this->uses = array('User','HrDetail','SalaryStatement');
		$conditions = array();
	
		if(!empty($this->request->query['year'])){
			$year = $this->request->query['year'];
		}
		if(!empty($this->request->query['month'])){
			$month = $this->request->query['month'];
		}
		if(!empty($this->request->query['statement'])){
			$statement = $this->request->query['statement'];
			$salaryData = $this->getSalaryData($statement,$year,$month);
	
			if(!empty($salaryData)){
				$this->set(compact('salaryData'));
			}else{
				$this->HrDetail->bindModel(array(
						'belongsTo'=>array(
								'User'=>array(
										'type'=>'inner',
										'foreignKey'=>'user_id'
								),
								'Role'=>array(
										'type'=>'inner',
										'foreignKey'=>false,
										'conditions'=>array('User.role_id = Role.id')
								)
						)
				),false);
	
				if($statement == "Bank Statement"){
					$conditions[] = 'HrDetail.account_no IS NOT NULL';
				}else{
					$conditions[] = 'HrDetail.account_no IS NULL';
				}
				$userData = $this->HrDetail->find('all',array(
						'fields'=>array(
								'HrDetail.account_no, HrDetail.bank_name',
								'Role.id, Role.name',
								'User.id, User.username, CONCAT(User.first_name," ",User.last_name) as full_name, User.is_doctor, User.role_id'
						),
						'conditions'=>array(
								$conditions,
								//'HrDetail.account_no IS NOT NULL',
								'HrDetail.is_deleted'=>'0',
								'User.is_active'=>'1',
								'User.is_deleted'=>'0'
						)));
				foreach ($userData as $key => $userDetails){
					//generate salary
					$this->generateStatement($userDetails,$date, array_search($statement, Configure::read('salaryStatement')));
				}
			}
		}
	}
	 
	/*
	 * function to generate the salary
	* @author : Swapnil
	* @created : 09.03.2016
	*/
	public function generateStatement($userDetails, $date, $statement){
		$this->loadModel('SalaryStatement');
		$this->loadModel('SalaryStatementDetail');
		$getEarningDeductionDetails = array();
	
		$firstDateOfMonth = date("Y-m-01",  strtotime($date));
		$lastDateOfMonth = date("Y-m-t",  strtotime($date));
	
		//get all attendance details of current user
		$attendanceDetail = $this->getAllAttendanceDetail($userDetails['User']['id'],$firstDateOfMonth,$lastDateOfMonth);
	
		//get any paid leaves (leaves type wise) of current user
		$paidLeaves = $this->getPaidLeave($userDetails['User']['id'],$firstDateOfMonth,$lastDateOfMonth);
	
		//get count of leaves
		$LeavesTaken = $this->getLeaveTypeCount($paidLeaves);
	
		//total Leaves taken of all leave types
		$totalLeaveTaken = array_sum($LeavesTaken);
	
		//get total lates days
		$totalLateDay = $this->getTotalLateDays($attendanceDetail['worksDetail']['total_late']);
	
		//get count of holidays in current month
		$holidays = $this->getPublicHolidays(date("Y",strtotime($date)),date("m",strtotime($date)));
	
		//calculate number of working days of current month
		$totalWorkingDays = $attendanceDetail['worksDetail']['total_working_days'] - count($holidays);
	
		//calculate number of working days
		$totalHeWorksDay = ($attendanceDetail['worksDetail']['total_works_days'] + $totalLeaveTaken) - $totalLateDay;
	
		//get salary Details (Earning and deduction) of current user
		if($userDetails['Role']['name'] != "Doctor"){
			//for non-doctor
			$salaryDetails = $this->getSalaryDetailsOfNonDoctor($userDetails['User']['id']);
			if(!empty($salaryDetails)){
				$getEarningDeductionDetails = $this->getSalaryEarningDeductionAmount($userDetails, $salaryDetails, $totalWorkingDays, $totalHeWorksDay);
			}
		}else{
			//$salaryDetails = $this->getSalaryDetailsOfDoctor($userDetails['User']['id'],$firstDateOfMonth,$lastDateOfMonth);
		}
		if(!empty($getEarningDeductionDetails['Earning']['Basic']['id'])){
			//Transaction begin
			$ds = $this->SalaryStatement->getdatasource(); //creating dataSource object
			$ds->begin();
			$errorNotExist = false;
	
			$saveData['user_id'] = $userDetails['User']['id'];
			$saveData['created_by'] = $this->Session->read('userid');
			$saveData['from_date'] = date("Y-m-01",  strtotime($date));
			$saveData['to_date'] = date("Y-m-t",  strtotime($date));
			$saveData['salary_type'] = $statement;
	
			$this->SalaryStatement->id = '';
			if($this->SalaryStatement->save($saveData)){
				$errorNotExist = true;
				$salaryStatementId = $this->SalaryStatement->id;
			}
			if ($errorNotExist) {
				//commit trnasaction
				$ds->commit();
				foreach($getEarningDeductionDetails as $key => $earnDeduVal){
					foreach($earnDeduVal as $edKey => $val){
						if($key == "Earning"){
							$saveSalaryDetail['type'] = '1';
						}else{
							$saveSalaryDetail['type'] = '2';
						}
						$saveSalaryDetail['salary_statement_id'] = $salaryStatementId;
						$saveSalaryDetail['earning_deduction_id'] = $val['id'];
						$saveSalaryDetail['amount'] = $val['day_amount'];
						// $this->SalaryStatementDetail->saveAll($saveSalaryDetail);
						$updateData[$key] += $val['day_amount'];
					}
				}
				$this->SalaryStatement->updateAll(array('total_earning'=>$updateData['Earning'],'total_deduction'=>$updateData['Deduction']),array('id'=>$salaryStatementId));
			}else{
				//rollback trnasaction
				$ds->rollback();
			}
		}
	}
	
	
	/*
	 * function to calculate salary amount from basic salary
	* @author : Swapnil
	* @created : 09.03.2016
	*/
	
	public function getSalaryEarningDeductionAmount($userDetails, $salaryDetails, $totalWorkingDays, $totalHeWorksDay){
	
		//basic Salary of month
		$basicSalary = $salaryDetails['Earning']['Basic']['day_amount'];
	
		//get per day basic amount from basic salary
		$basicAmount = $this->getSingleDayBasicAmount($basicSalary,$totalWorkingDays);
	
		//calculate total earning
		$earningAmount = $basicAmount * $totalHeWorksDay;
	
		$salaryDetails['Earning']['Basic']['day_amount'] = round($earningAmount,2);
	
		//calculate Deduction Amount
		$salaryDetails['Deduction'] = $this->deductionAmount($salaryDetails['Deduction'],$basicSalary);
	
		return $salaryDetails;
	}
	
	/*
	 * function to calculate per day amount
	* @params - amount, number_of_days
	* @author : Swapnil
	* @created : 11.03.2016
	*/
	
	public function getSingleDayBasicAmount($amount,$days){
		return round(($amount/$days),2);
	}
	
	/*
	 * function to calculate total late days
	* @params - array of lates
	* @author : Swapnil
	* @created : 11.03.2016
	*/
	
	public function getTotalLateDays($latesArray){
		$totalLateDay = 0;
		if(count($latesArray)>=Configure::read('graceLeave')){
			//deduct grace leave of two days
			$totalLate = count($latesArray) - Configure::read('graceLeave');
			if($totalLate > 0){
				$totalLateDay = $totalLate * Configure::read('perDayDeduction');   //deduct 1/4th per day
			}
		}
		return $totalLateDay;
	}
	
	
	/*
	 * function to calculate deduction amount from basic salary according to role
	* @author : Swapnil
	* @created : 09.03.2016
	*/
	public function deductionAmount($deductions,$amount){
		$total = 0;
		foreach($deductions as $key => $val){
			switch($key){
				case 'PF AS %':
					$result = $amount * 0.02;
					break;
	
				case 'ESI as %':
					$result = $amount * 0.05;
					break;
	
				case 'TDS as %':
					$result = $amount * 0.10;
					break;
	
				default:
					$result = $amount * 0.02;
					break;
			}
			$deductions[$key] = $val;
			$deductions[$key]['day_amount'] = round($result,2);
		}
		return $deductions;
	}
	
	public function getPaySlip($user_id, $date){
		$this->layout = "advance";
		$this->uses = array('DutyRoster','User','Role','Shift','EmpLeaveBenefit');
		$this->loadModel('EmpLeaveBenefit');
		if(empty($date)) $date = date("Y-m-d");
	
		$firstDateOfMonth = date("Y-m-01",  strtotime($date));
		$lastDateOfMonth = date("Y-m-t",  strtotime($date));
	
		//get user details
		$this->User->belongsTo = array();
		$this->User->bindModel(array(
				'belongsTo'=>array(
						'Role'=>array(
								'primaryKey'=>'role_id',
								'type'=>'inner'
						),
						'Location'=>array(
								'primaryKey'=>'location_id',
								'type'=>'inner'
						)
				)
		));
		$userData = $this->User->read(array('User.id','User.role_id','User.full_name','Role.name','Location.name'),$user_id);
	
		//get all attendance details of current user
		$attendanceDetail = $this->getAllAttendanceDetail($user_id,$firstDateOfMonth,$lastDateOfMonth);
	
		//get any paid leaves (leaves type wise) of current user
		$paidLeaves = $this->getPaidLeave($user_id,$firstDateOfMonth,$lastDateOfMonth);
	
		//get count of leaves
		$LeavesTaken = $this->getLeaveTypeCount($paidLeaves);
	
		//total Leaves taken of all leave types
		$totalLeaveTaken = array_sum($LeavesTaken);
	
		//get total lates days
		$totalLateDay = $this->getTotalLateDays($attendanceDetail['worksDetail']['total_late']);
	
		//get count of holidays in current month
		$holidays = $this->getPublicHolidays(date("Y",strtotime($date)),date("m",strtotime($date)));
	
		//calculate number of working days of current month
		$totalWorkingDays = $attendanceDetail['worksDetail']['total_working_days'] - count($holidays);
	
		//calculate number of working days
		$totalHeWorksDay = ($attendanceDetail['worksDetail']['total_works_days'] + $totalLeaveTaken) - $totalLateDay;
	
		//get salary Details (Earning and deduction)
		if($userData['Role']['name'] != "Doctor"){
	
			//for non-doctor
			$salaryDetails = $this->getSalaryDetailsOfNonDoctor($user_id);
	
			if(!empty($salaryDetails)){
				$getEarningDeductionDetails = $this->getSalaryEarningDeductionAmount($userData, $salaryDetails, $totalWorkingDays, $totalHeWorksDay);
			}
		}else{
			//$salaryDetails = $this->getSalaryDetailsOfDoctor($user_id,$firstDateOfMonth,$lastDateOfMonth);
		}
	
		//calculte total allowed leaves of whole months of year of each category
		$leaveMaster = $this->EmpLeaveBenefit->getEmpLeaveDetail($user_id);
	
		//get previous leaves of current year
		$previousLeave = $this->getAllPreviousLeave($user_id,$date);
	
		foreach($leaveMaster as $key => $val){
			$leaveData['Opening'][$key] = $val - count($previousLeave[$key]);
			$leaveData['Credited'][$key] = '0';
			$leaveData['Availed'][$key] = $LeavesTaken[$key];
			$leaveData['Closing'][$key] = $val-$LeavesTaken[$key];
		}
		$this->set(compact(array('holidays','attendanceDetail','userData','getEarningDeductionDetails','totalLeaveTaken','leaveData')));
	}
	
	/*
	 * function to return the public holidays of current month
	* @return (date with holiday)
	* @author : Swapnil
	* @created : 06.03.2016
	*/
	public function getPublicHolidays($fromDate,$toDate){
		$this->loadModel('Configuration');
		$holidayData = $this->Configuration->find('first',array(
				'fields'=>array('Configuration.value'),
				'conditions'=>array('Configuration.name'=>"Holiday")));
		$holiday = unserialize($holidayData['Configuration']['value']);
	
		list($fromYear,$fromMonth,$fromDate) = explode("-", $fromDate);
		list($toYear,$toMonth,$toDate) = explode("-", $toDate);
	
		foreach($holiday[$fromYear]['PH'][$fromMonth] as $fKey => $fVal){
			if($fromDate<=$fKey){
				//$returnArray[$fromYear."-".$fromMonth."-".$fKey] = trim($fVal);
				$returnArray[] = array('date'=>$fromYear."-".$fromMonth."-".$fKey,'holiday'=>trim($fVal));
			}
		}
		foreach($holiday[$toYear]['PH'][$toMonth] as $tKey => $tVal){
			if($toDate>=$tKey){
				//$returnArray[$toYear."-".$toMonth."-".$tKey] = trim($tVal);
				$returnArray[] = array('date'=>$toYear."-".$toMonth."-".$tKey,'holiday'=>trim($tVal));
			}
		}
		//to sort date in ascending order
		$sorted = $this->array_orderby($returnArray, 'date', SORT_ASC);
		foreach ($sorted as $key => $val){
			$returnArr[$val['date']] = $val['holiday'];
		}
		return $returnArr;
	}
	
	
	/*
	 * function to sort
	* @author : swapnil
	* @created : 01.04.2016
	*/
	public function array_orderby()
	{
		$args = func_get_args();
		$data = array_shift($args);
		foreach($args as $n => $field) {
			if(is_string($field)) {
				$tmp = array();
				foreach($data as $key => $row){
					$tmp[$key] = $row[$field];
					$args[$n] = $tmp;
				}
			}
		}
		$args[] = &$data;
		call_user_func_array('array_multisort', $args);
		return array_pop($args);
	}
	
	/*
	 * function to return the number of paid leaves
	* @author : Swapnil
	* @created : 09.03.2016
	*/
	public function getPaidLeave($user_id,$firstDateOfMonth,$lastDateOfMonth){
		$this->loadModel('LeaveApproval');
		$leaveData = $this->LeaveApproval->find('all',array(
				'fields'=>array(
						'LeaveApproval.leave_from','LeaveApproval.leave_type'
				),
				'conditions'=>array($conditions,
						/*'MONTH(LeaveApproval.leave_from)'=>date("m",  strtotime($date)),
						 'YEAR(LeaveApproval.leave_from)'=>date("Y",  strtotime($date)),*/
						'LeaveApproval.leave_from BETWEEN ?AND?'=>array($firstDateOfMonth,$lastDateOfMonth),
						'LeaveApproval.user_id'=>$user_id,
						'LeaveApproval.is_deleted'=>'0',
						'LeaveApproval.is_approved'=>'1')
		));
		foreach($leaveData as $key => $val){
			$returnArr[$val['LeaveApproval']['leave_type']][] = $val['LeaveApproval']['leave_from'];
		}
		return $returnArr;
		/*$cnt = 0;
		 debug($leaveData);
		foreach ($leaveData as $key => $val){
		if(!empty($val['LeaveApproval']['leave_to'])){
		//if to-date is greater than last date of month, then calculate only days till end of the month
		if($val['LeaveApproval']['leave_to'] > $toDate){
		$cnt += $this->DateFormat->getNoOfDays($toDate,$val['LeaveApproval']['leave_from']);
		}else if($val['LeaveApproval']['leave_from'] >= $fromDate){
		$cnt += $this->DateFormat->getNoOfDays($val['LeaveApproval']['leave_to'],$val['LeaveApproval']['leave_from']);
		}else if($val['LeaveApproval']['leave_from'] < $fromDate)
		{
		//if from-date is greater than first day of month, count number of days from first day of month
		$cnt += $this->DateFormat->getNoOfDays($val['LeaveApproval']['leave_to'],$fromDate);
		}
		}else {
		$cnt++;
		}
		}*/
	}
	
	/*
	 * function to return all the attendance Details
	* @return : (no of working days, no of days he/she works, number of lates comes with date and late times)
	* @author : Swapnil
	* @created : 05.03.2016
	*/
	public function getAllAttendanceDetail($user_id,$fromDate,$toDate){
	
		$this->uses = array('DutyRoster','Shift');
		$dailyRosterData = $this->DutyRoster->find('all',array(
				'conditions'=>array(
						'DutyRoster.user_id'=>$user_id,'DutyRoster.date BETWEEN ? AND ?'=>array($fromDate,$toDate),
						'OR'=>array('DutyRoster.intime IS NOT NULL','DutyRoster.outime IS NOT NULL'),
						//'OR'=>array('DutyRoster.day_off'=>'0','DutyRoster.day_off'=>'OFF')
				),
				'fields'=>array('DutyRoster.id, DutyRoster.user_id, DutyRoster.date, DutyRoster.inouttime, DutyRoster.shift, DutyRoster.day_off, DutyRoster.is_present, DutyRoster.intime, DutyRoster.outime, DutyRoster.remark'),
				'order'=>array(
						'DutyRoster.date'=>'ASC'
				)
		));
	
		$time['total_working_days'] = date('t',  strtotime($fromDate));
		$time['total_works_days'] = count($dailyRosterData);
		$shiftData = $this->Shift->getAllShiftDetails();
	
		foreach ($shiftData as $key => $val){
			$shiftDetails[$val['Shift']['id']] = $val['Shift'];
		}
	
		foreach ($dailyRosterData as $key => $val){
			$returnArray[$key]['date'] = $val['DutyRoster']['date'];
			$returnArray[$key]['name'] = $shiftDetails[$val['DutyRoster']['shift']]['name']!=''?$shiftDetails[$val['DutyRoster']['shift']]['name']:$val['DutyRoster']['day_off'];
			$returnArray[$key]['working_time'] = $totalAllotTime[] = $this->DateFormat->getTimeDifference($shiftDetails[$val['DutyRoster']['shift']]['from_time'],$shiftDetails[$val['DutyRoster']['shift']]['to_time']);
			$returnArray[$key]['in_time'] =  $inTime = $val['DutyRoster']['intime'];
			$returnArray[$key]['out_time'] =  $outTime = $val['DutyRoster']['outime'];
			$returnArray[$key]['remark'] =  $val['DutyRoster']['remark'];
			$returnArray[$key]['shift_from'] =  $shiftDetails[$val['DutyRoster']['shift']]['from_time'];
			$returnArray[$key]['shift_to'] =  $shiftDetails[$val['DutyRoster']['shift']]['to_time'];
			$totalWorksTime[] = $returnArray[$key]['totalHeWork'] = $worksHour = $this->DateFormat->getTimeDifference($inTime,$outTime);
			if(strtotime($shiftDetails[$val['DutyRoster']['shift']]['from_time'])<  strtotime($inTime)){
				$totalLateTime[] = $returnArray[$key]['lateHour'] = $lateHours = $this->DateFormat->getTimeDifference($shiftDetails[$val['DutyRoster']['shift']]['from_time'],$inTime);
			}
			if($lateHours>0.15){
				$dayLateMoreThan15Min[$val['DutyRoster']['date']] = $lateHours;
			}
		}
	
		$time['total_late'] = $dayLateMoreThan15Min;
		$time['total_time_has_to_work'] = $this->DateFormat->getTotalTime($totalAllotTime);
		$time['total_time_came_late'] = $this->DateFormat->getTotalTime($totalLateTime);
		$time['total_time_work'] = $this->DateFormat->getTotalTime($totalWorksTime);
	
		return array('worksDetail'=>$time,'allData'=>$returnArray);
	}
	
	public function getSalaryDetailsOfNonDoctor($user_id){
		$this->uses = array('EmployeePayDetail');
		$this->EmployeePayDetail->bindModel(array(
				'belongsTo'=>array(
						'EarningDeduction'=>array(
								'foreignKey'=>false,
								'conditions'=>array(
										'EarningDeduction.id = EmployeePayDetail.earning_deduction_id'
								)
						)
				)
		));
		$data = $this->EmployeePayDetail->find('all',array(
				'fields'=>array(
						'EarningDeduction.id, EarningDeduction.type, EarningDeduction.name, EarningDeduction.payment_mode',
						'EmployeePayDetail.day_amount, EmployeePayDetail.night_amount'
				),
				'conditions'=>array(
						'EmployeePayDetail.user_id'=>$user_id,'EmployeePayDetail.is_applicable'=>'1','EmployeePayDetail.is_deleted'=>'0'
				)
		));
	
		foreach($data as $key => $val){
			$returnArray[$val['EarningDeduction']['type']][$val['EarningDeduction']['name']] = array(
					'id'=>$val['EarningDeduction']['id'],
					'day_amount'=>$val['EmployeePayDetail']['day_amount'],
					'payment_mode'=>$val['EarningDeduction']['payment_mode'],
					'night_amount'=>$val['EmployeePayDetail']['night_amount'] );
		}
		return $returnArray;
	}
	
	
	public function getSalaryDetailsOfDoctor($user_id,$fromDate,$toDate){
		$this->uses = array('EmployeePayDetail');
		//for all OPD Patients
		$returnArray['no_of_opd_done'] = count($this->getNoOfOpdDone($user_id,$fromDate,$toDate));
	}
	
	//function to get the number of OPDs
	public function getNoOfOpdDone($user_id,$fromDate,$toDate){
		$this->uses = array('ServiceBill','Patient');
	
		$this->ServiceBill->bindModel(array(
				"belongsTo"=>array(
						"Patient"=>array(
								"foreignKey"=>false,
								'type'=>'inner',
								'conditions'=>array(
										'Patient.id = ServiceBill.patient_id'
								)
						),
				)
		)) ;
	
		$opdDetail = $this->ServiceBill->find('all',array(
				'fields'=>array(
						'Patient.lookup_name','ServiceBill.id'
				),
				'conditions'=>array(
						'ServiceBill.is_deleted'=>'0','ServiceBill.doctor_id'=>$user_id,'ServiceBill.service_id'=>'5',
						'Patient.discharge_date BETWEEN ?AND?'=>array($fromDate,$toDate),
						'ServiceBill.location_id'=>$this->Session->read('locationid')
				),
				'group'=>array('ServiceBill.id')
		));
	
		return $opdDetail;
	}
	
	public function getLeaveTypeCount($leaves=array()){
		foreach($leaves as $key => $val){
			$returnArr[$key] = count($val);
		}
		return $returnArr;
	}
	
	public function getAllPreviousLeave($userId,$date){
		$this->LoadModel('LeaveApproval');
		$result =  $this->LeaveApproval->getAllPreviousLeave($userId,$date) ;
		return $result;
	}
	
	public function bankStatement($year,$month){
		$this->set('title_for_layout',__(' : Bank Statement'));
	
	}
	
	public function getSalaryData($statement,$year,$month){
		$this->SalaryStatement->bindModel(array(
				'belongsTo'=>array(
						'User'=>array(
								'foreignKey'=>'user_id',
								'type'=>'inner'
						),
						'Role'=>array(
								'foreignKey'=>false,
								'conditions'=>array(
										'User.role_id = Role.id'
								)
						),
						'Location'=>array(
								'foreignKey'=>false,
								'conditions'=>array(
										'User.location_id = Location.id'
								)
						)
				)
		));
	
		$salaryData = $this->SalaryStatement->find('all',array(
				'conditions'=>array(
						'OR'=>array('MONTH(SalaryStatement.from_date)'=>$month,'MONTH(SalaryStatement.to_date)'=>$month),
						'OR'=>array('YEAR(SalaryStatement.from_date)'=>$year,'YEAR(SalaryStatement.to_date)'=>$year),
						'SalaryStatement.salary_type'=>array_search($statement, Configure::read('salaryStatement')),
						'SalaryStatement.is_deleted'=>'0'
				),
				'fields'=>array(
						'SalaryStatement.total_earning, SalaryStatement.total_deduction, SalaryStatement.salary_type',
						'CONCAT(User.first_name," ",User.last_name) as full_name, User.id',
						'Role.name',
						'Location.name'
				)
		));
		return $salaryData;
	}
	
	public function viewAttendance(){
		$this->layout = "advance";
		$this->set('title_for_layout',__(' : User Attendance'));
		$this->loadModel('DutyRoster');
		if(!empty($this->request->query)){
			$userId = $this->request->query['user_id'];
			$year = $this->request->query['year'];
			$totalAttendance = $this->getMonthWiseRecord($this->DutyRoster->getAllAttendanceDetail($userId,$year));
			$this->set(compact('totalAttendance'));
		}
	}
	
	public function getMonthWiseRecord($array){
		for($i =1 ; $i<=12; $i++){
			$returnArr[$i] = $array[str_pad($i,2,0,STR_PAD_LEFT)]!=''?$array[str_pad($i,2,0,STR_PAD_LEFT)]:'0';
		}
		return $returnArr;
	}

}