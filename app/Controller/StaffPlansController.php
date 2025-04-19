<?php
/**
 * StaffPlansController file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Hope hospital
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Santosh R. Yadav
 */
class StaffPlansController extends AppController {

	public $name = 'StaffPlans';
	public $uses = array('StaffPlan');
	public $helpers = array('Html','Form', 'Js');
	public $components = array('RequestHandler','Email','DateFormat', 'ScheduleTime');
	
/**
 * all staff listing
 *
 */	
	
	public function index() {
                $this->loadModel("User");
				$this->paginate = array(
			        'limit' => Configure::read('number_of_rows'),
			        'conditions' => array('User.is_deleted' => 0, 'User.location_id' => $this->Session->read('locationid') , 'Role.name' => array('doctor', 'Doctor'))
   				);
                $this->set('title_for_layout', __('Staff Plan Schedule', true));
                $data = $this->paginate('User');
                $this->set('data', $data);
	}


/**
 * staff plan schedule event
 *
 */
	public function staff_event($id=null,$showCalendarDay=1) {
                $this->uses = array('StaffPlan', 'User');
                $this->set('title_for_layout', __('Add Staff Schedule', true));
                if (!$id) {
			$this->Session->setFlash(__('Invalid id for staff schedule', true));
			$this->redirect(array("action" => "index"));
		}
                if($id) {
		 $allEvent = $this->StaffPlan->find("all", array('conditions' => array('StaffPlan.user_id'=> $id,'StaffPlan.is_deleted '=> 0)));
                 $staffData = $this->User->find("first", array('conditions' => array('User.id'=> $id,'User.is_deleted '=> 0), 'recursive' => -1));
                 $this->set('allEvent', $allEvent);
                 $this->set('staffData', $staffData);
                 $this->set('showCalendarDay', $showCalendarDay);
                }
		
	}

/**
 * staff schedule event save by xmlhttprequest
 *
 */
	public function saveStaffEvent() {
                $this->loadModel("StaffPlan");
                if($this->params['isAjax']) {
                        if(date("Y-m-d", strtotime($this->params->query['scheduledate'])) >= date("Y-m-d")) {
                                $checkDoctorLeave = $this->ScheduleTime->checkDoctorLeavePlan($this->params->query);
                                if($checkDoctorLeave > 0) {
					$this->request->data['StaffPlan']['location_id'] = $this->Session->read("locationid");
					$this->request->data['StaffPlan']['user_id'] = $this->params->query['userid'];
					$this->request->data['StaffPlan']['schedule_date'] = $this->params->query['scheduledate'];
					$this->request->data['StaffPlan']['start_time'] = $this->params->query['starttime'];
					$this->request->data['StaffPlan']['end_time'] = $this->params->query['endtime'];
					$this->request->data['StaffPlan']['purpose'] = $this->params->query['purpose'];
					$this->request->data['StaffPlan']['created_by'] = $this->Auth->user('id');
					$this->request->data['StaffPlan']['create_time'] = date("Y-m-d H:i:s");
					$this->StaffPlan->save($this->request->data);
					$this->Session->setFlash(__('Staff Schedule time has been saved', true));
					exit;
                                } else {
					$this->Session->setFlash(__('You can not select this time.', true));
					exit;
                                }
                        } else {
                                $this->Session->setFlash(__('You can not be save past schedule time', true));
                                exit;
                        }
               } 
       }


/**
 *  update staff schedule event by xmlhttprequest
 *
 */
	public function updateStaffEvent() {
                $this->loadModel("StaffPlan");
                if($this->params['isAjax']) {
                        if(date("Y-m-d", strtotime($this->params->query['scheduledate'])) >= date("Y-m-d")) {
                                $checkDoctorLeave = $this->ScheduleTime->checkDoctorLeavePlan($this->params->query);
                                if($checkDoctorLeave > 0) {
					$this->StaffPlan->id = $this->params->query['id'];
					$this->request->data['StaffPlan']['id'] = $this->params->query['id'];
					$this->request->data['StaffPlan']['schedule_date'] = $this->params->query['scheduledate'];
					$this->request->data['StaffPlan']['start_time'] = $this->params->query['starttime'];
					$this->request->data['StaffPlan']['end_time'] = $this->params->query['endtime'];
					$this->request->data['StaffPlan']['purpose'] = $this->params->query['purpose'];
					$this->request->data['StaffPlan']['modified_by'] = $this->Auth->user('id');
					$this->request->data['StaffPlan']['modify_time'] = date("Y-m-d H:i:s");
					$this->StaffPlan->save($this->request->data);
					$this->Session->setFlash(__('Staff Schedule time has been updated', true));
					exit;
                                } else {
					$this->Session->setFlash(__('You can not select this time.', true));
					exit;
                                }
                        } else {
                                $this->Session->setFlash(__('You can not be save past schedule time', true));
                                exit;
                        }
                }
	}

/**
 * delete staff schedule event by xmlhttprequest
 *
 */
	public function deleteStaffEvent() {
                $this->loadModel("StaffPlan");
                if($this->params['isAjax']) {
			$this->StaffPlan->id = $this->params->query['id'];
			$this->request->data['StaffPlan']['id'] = $this->params->query['id'];
			$this->request->data['StaffPlan']['is_deleted'] = 1;
			$this->request->data['StaffPlan']['modified_by'] = $this->Auth->user('id');
			$this->request->data['StaffPlan']['modify_time '] = date("Y-m-d H:i:s");
                        $this->StaffPlan->save($this->data);
                        $this->Session->setFlash(__('Schedule time deleted', true));
                        exit;
                }
		
	}

/**
 * staff individual schedule event
 *
 */
	public function staff_ownevent($showCalendarDay=1) {
                $this->uses = array('StaffPlan', 'User');
                $this->set('title_for_layout', __('Add Staff Own Schedule', true));
                $allEvent = $this->StaffPlan->find("all", array('conditions' => array('StaffPlan.user_id'=> $this->Auth->user('id'),'StaffPlan.is_deleted '=> 0)));
                $staffData = $this->User->find("first", array('conditions' => array('User.id'=> $this->Auth->user('id'),'User.is_deleted '=> 0), 'recursive' => -1));
                $this->set('allEvent', $allEvent);
                $this->set('staffData', $staffData);
                $this->set('showCalendarDay', $showCalendarDay);
                
        }

/**
 * staff own schedule event save by xmlhttprequest
 *
 */
	public function saveStaffOwnEvent() {
                $this->loadModel("StaffPlan");
                if($this->params['isAjax']) {
                // set userid value //
                $this->params->query['userid'] = $this->Auth->user('id');
                        if(date("Y-m-d", strtotime($this->params->query['scheduledate'])) >= date("Y-m-d")) {
                                $checkDoctorLeave = $this->ScheduleTime->checkDoctorLeavePlan($this->params->query);
                                if($checkDoctorLeave > 0) {
					$this->request->data['StaffPlan']['location_id'] = $this->Session->read("locationid");
					$this->request->data['StaffPlan']['user_id'] = $this->params->query['userid'];
					$this->request->data['StaffPlan']['schedule_date'] = $this->params->query['scheduledate'];
					$this->request->data['StaffPlan']['start_time'] = $this->params->query['starttime'];
					$this->request->data['StaffPlan']['end_time'] = $this->params->query['endtime'];
					$this->request->data['StaffPlan']['purpose'] = $this->params->query['purpose'];
					$this->request->data['StaffPlan']['created_by'] = $this->Auth->user('id');
					$this->request->data['StaffPlan']['create_time'] = date("Y-m-d H:i:s");
					$this->StaffPlan->save($this->request->data);
					$this->Session->setFlash(__('Staff Schedule time has been saved', true));
					exit;
                                } else {
					$this->Session->setFlash(__('You can not select this time.', true));
					exit;
                                }
                        } else {
                                $this->Session->setFlash(__('You can not be save past schedule time', true));
                                exit;
                        }
               }
		
	}
/**
 * ot appointment event 
 *
 */
	public function staffplan() {
             $daysCurrentMondays = date("M d Y", strtotime('monday this week'));
			 $daysCurrentSundays = date("M d Y", strtotime('sunday this week'));
			 $this->set('daysCurrentMondays', $daysCurrentMondays);
			 $this->set('daysCurrentSundays', $daysCurrentSundays);
        }

/**
 * edit staff appointment event 
 *
 */
	public function staffplan_edit() {
             $this->uses = array('StaffPlan','User');
             
             // get opt details //
             $getUserList = $this->User->find('list', array('conditions' => array('User.location_id' => $this->Session->read('locationid'), 'User.is_deleted' => 0, 'User.is_active' => 1), 'fields' => array('User.id', 'User.full_name'), 'recursive' => 1));
             $getStaffPlan =  $this->StaffPlan->find('first', array('conditions' => array('StaffPlan.id' => $_GET["id"])));
                         
             $sarr1 = explode(" ", $this->php2JsTime($this->mySql2PhpTime($this->DateFormat->formatDate2Local($getStaffPlan['StaffPlan']['starttime'],'yyyy-mm-dd', true)))); 
             $earr1 = explode(" ", $this->php2JsTime($this->mySql2PhpTime($this->DateFormat->formatDate2Local($getStaffPlan['StaffPlan']['endtime'],'yyyy-mm-dd', true))));
             $this->set('sarr1', $sarr1);
             $this->set('earr1', $earr1);
             $this->set('getStaffPlan', $getStaffPlan);
             $this->set('getUserList', $getUserList);
	         if(isset($this->params->query['start'])){ 
					 $this->set('startDate', $this->params->query['start']);
			 }
             $this->layout = false;
        }
/**
 * internal url for calender event 
 *
 */
        public function datafeed() {
             header('Content-type:text/javascript;charset=UTF-8');
             $method = $_GET["method"];
             switch ($method) {
               case "add":
                    $ret = $this->addCalendar($_POST["CalendarStartTime"], $_POST["CalendarEndTime"], $_POST["CalendarTitle"], $_POST["IsAllDayEvent"]);
               break;
               case "list":
                    $ret = $this->listCalendar($_POST["showdate"], $_POST["viewtype"]);
               break;
               case "update":
               	   // convert date format to dd-mm-yyyy format //
			       $getStartTime = explode(" ", $_POST["CalendarStartTime"]);
			       $expStartDate = explode("/", $getStartTime[0]);
			       $startTime = $expStartDate[0]."-".$expStartDate[1]."-".$expStartDate[2]." ".$getStartTime[1];
			       $getEndTime = explode(" ", $_POST["CalendarEndTime"]);
			       $expEndDate = explode("/", $getEndTime[0]);
			       $endTime = $expEndDate[0]."-".$expEndDate[1]."-".$expEndDate[2]." ".$getEndTime[1];
                   $ret = $this->updateCalendar($_POST["calendarId"], $this->DateFormat->formatDate2STD($startTime,'mm/dd/yyyy'), $this->DateFormat->formatDate2STD($endTime,'mm/dd/yyyy'));
               break; 
               case "remove":
                   $ret = $this->removeCalendar( $_POST["calendarId"]);
               break;
               case "adddetails":
                   //$st = $_POST["stpartdate"] . " " . $_POST["stparttime"];
		           //$et = $_POST["etpartdate"] . " " . $_POST["etparttime"];
		           $stdst = $_POST["stpartdate"] . " " . $_POST["stparttime"];
				   $stdet = $_POST["etpartdate"] . " " . $_POST["etparttime"];
				   $st =  $this->DateFormat->formatDate2STD($stdst,'mm/dd/yyyy');
				   $et =  $this->DateFormat->formatDate2STD($stdet,'mm/dd/yyyy');
				   if(isset($_GET["id"])){
				        $ret = $this->updateDetailedCalendar($_GET["id"], $st, $et, 
					$_POST["subject"], isset($_POST["is_all_day_event"])?1:0, $_POST["purpose"], 
					$_POST["colorvalue"], $_POST["timezone"], $_POST);
				   }else{
				        $ret = $this->addDetailedCalendar($st, $et,                    
					$_POST["subject"], isset($_POST["is_all_day_event"])?1:0, $_POST["purpose"], 
					 $_POST["colorvalue"], $_POST["timezone"],$_POST);
				  }        
              break; 
           }
           echo json_encode($ret);   exit;   
           
        }

/**
 * add new event calendar 
 *
 */
        public function addCalendar($st, $et, $sub, $ade){
          $this->loadModel('StaffPlan'); 
          $ret = array();
	  try{
           $scheduleDateStart = explode(" ", $this->php2MySqlTime($this->js2PhpTime($st)));
           $scheduleDateEnd = explode(" ", $this->php2MySqlTime($this->js2PhpTime($et)));
           $this->request->data['StaffPlan']['location_id'] = $this->Session->read('locationid');
           $this->request->data['StaffPlan']['schedule_date'] = $scheduleDateStart[0];
           $this->request->data['StaffPlan']['start_time'] = $scheduleDateStart[1];
           $this->request->data['StaffPlan']['end_time'] = $scheduleDateEnd[1];
           $this->request->data['StaffPlan']['created_by'] = $this->Session->read('userid');
           $this->request->data['StaffPlan']['create_time'] = date('Y-m-d H:i:s');
	       $this->request->data['StaffPlan']['subject'] = $sub;
           $this->request->data['StaffPlan']['starttime'] = $this->php2MySqlTime($this->js2PhpTime($st));
           $this->request->data['StaffPlan']['endtime'] = $this->php2MySqlTime($this->js2PhpTime($et));
           $this->request->data['StaffPlan']['is_all_day_event'] = $ade;
	   $checkSave = $this->StaffPlan->save($this->request->data);
	   if(!$checkSave){
	     $ret['IsSuccess'] = false;
	     $ret['Msg'] = "Unable to add this Staff Plan";
	   }else{
	     $ret['IsSuccess'] = true;
	     $ret['Msg'] = 'Staff Plan Added';
	     $ret['Data'] = $this->StaffPlan->getLastInsertID();
	   }
	  }catch(Exception $e){
	   $ret['IsSuccess'] = false;
	   $ret['Msg'] = $e->getMessage();
	  } 
        return $ret;
      }

/**
 * add new event with details
 *
 */
      public function addDetailedCalendar($st, $et, $sub, $ade, $dscr, $color, $tz, $allvar){
         $this->uses = array('StaffPlan'); 
         $ret = array();
	 try{
	 	   if($st > $et) {
            $ret['IsSuccess'] = false;
	        $ret['Msg'] = "Start Date & Time Should Not Be Greater Than End Time";
           } else {
           // check overlap time //
           	$checkOverlapTime = $this->ScheduleTime->checkOverlapForStaffPlan("", $st, $et, $allvar);
           if($checkOverlapTime['leaveoverlap'] == 2 || $checkOverlapTime['appointmentoverlap'] == 2 || $checkOverlapTime['otappointmentoverlap'] == 2) {
             if($checkOverlapTime['leaveoverlap'] == 2) {
              $ret['IsSuccess'] = false;
	          $ret['Msg'] = "Your leave plan is overlap with other leave plan.";
             }
             if($checkOverlapTime['appointmentoverlap'] == 2) {
              $ret['IsSuccess'] = false;
	          $ret['Msg'] = "Your appointment is overlapping with this time";
             }
             if($checkOverlapTime['otappointmentoverlap'] == 2) {
              $ret['IsSuccess'] = false;
	          $ret['Msg'] = "Your OT appointment is overlapping with this time";
             }
           } else {
                   if($ade == 1) {
                    $end_time = date("Y-m-d H:i:s", strtotime($et . '+ 23 hours 59 minutes'));
                   } else {
                    $end_time = $et;
                   }
	           $scheduleDateStart = explode(" ", $st);
	           $scheduleDateEnd = explode(" ", $et);
	           $this->request->data['StaffPlan']['user_id'] = $allvar['user_id'];
	           $this->request->data['StaffPlan']['purpose'] = $dscr;
	           $this->request->data['StaffPlan']['location_id'] = $this->Session->read('locationid');
		       $this->request->data['StaffPlan']['subject'] = $sub;
	           $this->request->data['StaffPlan']['schedule_date'] = $scheduleDateStart[0];
	           $this->request->data['StaffPlan']['start_time'] = $scheduleDateStart[1];
	           $this->request->data['StaffPlan']['end_time'] = $scheduleDateEnd[1];
	           $this->request->data['StaffPlan']['starttime'] = $st;
	           $this->request->data['StaffPlan']['endtime'] = $end_time;
	           $this->request->data['StaffPlan']['is_all_day_event'] = $ade;
	           $this->request->data['StaffPlan']['color'] = $color;
	           $this->request->data['StaffPlan']['created_by'] = $this->Session->read('userid');
	           $this->request->data['StaffPlan']['create_time'] = date('Y-m-d H:i:s');

			   $checkSave = $this->StaffPlan->save($this->request->data);
			   if(!$checkSave){
			     $ret['IsSuccess'] = false;
			     $ret['Msg'] = "Unable to add this Staff Plan";
			   }else{
			     $ret['IsSuccess'] = true;
			     $ret['Msg'] = 'Staff Plan Added';
			     $ret['Data'] = $this->StaffPlan->getLastInsertID();
			   }
           }
           }
	 }catch(Exception $e){
	   $ret['IsSuccess'] = false;
	   $ret['Msg'] = $e->getMessage();
	 } 
			
         return $ret;
     }

/**
 * list event calendar by range.
 *
 */
     public function listCalendarByRange($sd, $ed){
     	
        $this->loadModel('StaffPlan');
	$ret = array();
	$ret['events'] = array();
	$ret["issort"] =true;
	$ret["start"] = $this->php2JsTime($sd);
	$ret["end"] = $this->php2JsTime($ed);
	$ret['error'] = null;
	$sd1 = $this->DateFormat->formatDate2STD($this->php2MySqlTime($sd),Configure::read('date_format_yyyy_mm_dd'));
	$sd = $this->php2MySqlTime($sd);
	$ed = $this->php2MySqlTime($ed);
	//$sd1 = $this->DateFormat->formatDate2STD($this->php2MySqlTime($sd),Configure::read('date_format'));
	//$sd = $this->DateFormat->formatDate2Local($this->php2MySqlTime($sd),Configure::read('date_format'));
	//$ed = $this->DateFormat->formatDate2Local($this->php2MySqlTime($ed),Configure::read('date_format'));
	
    try{
	
	$getList = $this->StaffPlan->find('all', array('conditions' => array('StaffPlan.starttime BETWEEN ? and ?' => array($sd1, $ed),'StaffPlan.location_id' => $this->Session->read('locationid'), 'StaffPlan.is_deleted' => 0)));
	
	foreach($getList as $getListVal) {
         //$realstartDate = $getListVal['StaffPlan']['starttime'];
         //$realendate = $getListVal['StaffPlan']['endtime'];
         //$startDate = strtotime(date("Y-m-d",strtotime($getListVal['StaffPlan']['starttime'])));
     	 //$endDate = strtotime(date("Y-m-d",strtotime($getListVal['StaffPlan']['endtime'])));
     	 $realstartDate = $this->DateFormat->formatDate2Local($getListVal['StaffPlan']['starttime'],Configure::read('date_format_yyyy_mm_dd'));
		 $realendate = $this->DateFormat->formatDate2Local($getListVal['StaffPlan']['endtime'],Configure::read('date_format_yyyy_mm_dd'));
  		 $startDate = strtotime(date("Y-m-d",strtotime($this->DateFormat->formatDate2Local($getListVal['StaffPlan']['starttime'],Configure::read('date_format_yyyy_mm_dd'), true))));
		 $endDate = strtotime(date("Y-m-d",strtotime($this->DateFormat->formatDate2Local($getListVal['StaffPlan']['endtime'],Configure::read('date_format_yyyy_mm_dd'), true))));
		 $datediff = $endDate - $startDate;
	     $totaldaysDiff = floor(abs($endDate - $startDate) / 86400);
         
         $moreThanDay=0;
	     if($totaldaysDiff>0){
		  $moreThanDay = 1;
	     }
	$ret['events'][] = array(
		$getListVal['StaffPlan']['id'],
		$getListVal['StaffPlan']['subject']." (".$getListVal['User']['full_name'].")",
		$this->php2JsTime($this->mySql2PhpTime($this->DateFormat->formatDate2Local($getListVal['StaffPlan']['starttime'],Configure::read('date_format_yyyy_mm_dd'), true))),
		$this->php2JsTime($this->mySql2PhpTime($this->DateFormat->formatDate2Local($getListVal['StaffPlan']['endtime'],Configure::read('date_format_yyyy_mm_dd'), true))),
		//$this->php2JsTime($this->mySql2PhpTime($realstartDate)),
		//$this->php2JsTime($this->mySql2PhpTime($realendate)),
		$getListVal['StaffPlan']['IsAllDayEvent'],
		$moreThanDay, //more than one day event
		//$row->InstanceType,
		0,//Recurring event,
		$getListVal['StaffPlan']['color'],
		1,//editable
		date("m/d/Y H:i",strtotime($this->DateFormat->formatDate2Local($getListVal['StaffPlan']['starttime'],Configure::read('date_format_yyyy_mm_dd'), true))),
		date("m/d/Y H:i",strtotime($this->DateFormat->formatDate2Local($getListVal['StaffPlan']['endtime'],Configure::read('date_format_yyyy_mm_dd'), true)))
	);
	}
		}catch(Exception $e){
	$ret['error'] = $e->getMessage();
	}
        return $ret;
     }

/**
 * list event calendar.
 *
 */
     public function listCalendar($day, $type){
        $phpTime = $this->js2PhpTime($day);
	//echo $phpTime . "+" . $type;
	switch($type){
	case "month":
	$st = mktime(0, 0, 0, date("m", $phpTime), 1, date("Y", $phpTime));
	$et = mktime(0, 0, -1, date("m", $phpTime)+1, 1, date("Y", $phpTime));
	break;
	case "week":
	//suppose first day of a week is monday 
	$monday  =  date("d", $phpTime) - date('N', $phpTime) + 1;
	//echo date('N', $phpTime);
	$st = mktime(0,0,0,date("m", $phpTime), $monday, date("Y", $phpTime));
	$et = mktime(0,0,-1,date("m", $phpTime), $monday+7, date("Y", $phpTime));
	break;
	case "day":
	$st = mktime(0, 0, 0, date("m", $phpTime), date("d", $phpTime), date("Y", $phpTime));
	$et = mktime(0, 0, -1, date("m", $phpTime), date("d", $phpTime)+1, date("Y", $phpTime));
	break;
	}
	//echo $st . "--" . $et; exit;
	return $this->listCalendarByRange($st, $et);
     }

/**
 * update event calendar.
 *
 */
     public function updateCalendar($id, $st, $et){
        $this->loadModel('StaffPlan');
	$ret = array();
	try{
                   if($ade == 1) {
                    //$end_time = date("Y-m-d H:i:s", strtotime($this->php2MySqlTime($this->js2PhpTime($et)) . '+ 23 hours 59 minutes'));
                    $end_time = date("Y-m-d H:i:s", strtotime($et . ' + 23 hours 59 minutes'));
                   } else {
                    //$end_time = $this->php2MySqlTime($this->js2PhpTime($et));
                    $end_time = $et;
                   }
           
           $this->StaffPlan->id = $id;
           //$scheduleDateStart = explode(" ", $this->php2MySqlTime($this->js2PhpTime($st)));
           //$scheduleDateEnd = explode(" ", $this->php2MySqlTime($this->js2PhpTime($et)));
           $scheduleDateStart = explode(" ", $st);
		   $scheduleDateEnd = explode(" ", $et);
           $this->request->data['StaffPlan']['location_id'] = $this->Session->read('locationid');
           $this->request->data['StaffPlan']['schedule_date'] = $scheduleDateStart[0];
           $this->request->data['StaffPlan']['start_time'] = $scheduleDateStart[1];
           $this->request->data['StaffPlan']['end_time'] = $scheduleDateEnd[1];
           $this->request->data['StaffPlan']['modified_by'] = $this->Session->read('userid');
           $this->request->data['StaffPlan']['modify_time'] = date('Y-m-d H:i:s');
	       $this->request->data['StaffPlan']['starttime'] = $st;
           $this->request->data['StaffPlan']['endtime'] = $end_time;
            $checkSave = $this->StaffPlan->save($this->request->data);

	   if(!$checkSave){
	     $ret['IsSuccess'] = false;
	     $ret['Msg'] = "Unable to update this Staff Plan";
	   }else{
	     $ret['IsSuccess'] = true;
	     $ret['Msg'] = 'Staff Plan Updated';
	     
	   }
	}catch(Exception $e){
	   $ret['IsSuccess'] = false;
	   $ret['Msg'] = $e->getMessage();
	}
	return $ret;
    }

/**
 * update detailed event calendar.
 *
 */
    public function updateDetailedCalendar($id, $st, $et, $sub, $ade, $dscr, $color, $tz,$allvar){
        $this->uses = array('StaffPlan','User');
	$ret = array();
	try{
		if($st > $et) {
            $ret['IsSuccess'] = false;
	        $ret['Msg'] = "Start Date & Time Should Not Be Greater Than End Time";
           } else {
           // check overlap time //
           $checkOverlapTime = $this->ScheduleTime->checkOverlapForStaffPlan($id, $st, $et, $allvar);
           if($checkOverlapTime['leaveoverlap'] == 2 || $checkOverlapTime['appointmentoverlap'] == 2 || $checkOverlapTime['otappointmentoverlap'] == 2) {
             if($checkOverlapTime['leaveoverlap'] == 2) {
              $ret['IsSuccess'] = false;
	          $ret['Msg'] = "Your leave plan is overlap with other leave plan.";
             }
             if($checkOverlapTime['appointmentoverlap'] == 2) {
              $ret['IsSuccess'] = false;
	          $ret['Msg'] = "Your appointment is overlapping with this time";
             }
             if($checkOverlapTime['otappointmentoverlap'] == 2) {
              $ret['IsSuccess'] = false;
	          $ret['Msg'] = "Your OT appointment is overlapping with this time";
             }
           } else {
                   if($ade == 1) {
                    //$end_time = date("Y-m-d H:i:s", strtotime($this->php2MySqlTime($this->js2PhpTime($et)) . ' + 23 hours 59 minutes'));
                    $end_time = date("Y-m-d H:i:s", strtotime($et . ' + 23 hours 59 minutes'));
                   } else {
                    //$end_time = $this->php2MySqlTime($this->js2PhpTime($et));
                    $end_time = $et;
                   }
	           //$scheduleDateStart = explode(" ", $this->php2MySqlTime($this->js2PhpTime($st)));
	           //$scheduleDateEnd = explode(" ", $this->php2MySqlTime($this->js2PhpTime($et)));
	           $scheduleDateStart = explode(" ", $st);
			   $scheduleDateEnd = explode(" ", $et);
	           $this->StaffPlan->id = $id;
	           $this->request->data['StaffPlan']['user_id'] = $allvar['user_id'];
	           $this->request->data['StaffPlan']['purpose'] = $dscr;
	           $this->request->data['StaffPlan']['location_id'] = $this->Session->read('locationid');
		       $this->request->data['StaffPlan']['subject'] = $sub;
	           $this->request->data['StaffPlan']['schedule_date'] = $scheduleDateStart[0];
	           $this->request->data['StaffPlan']['start_time'] = $scheduleDateStart[1];
	           $this->request->data['StaffPlan']['end_time'] = $scheduleDateEnd[1];
	           $this->request->data['StaffPlan']['starttime'] = $st;
	           $this->request->data['StaffPlan']['endtime'] = $end_time;
	           $this->request->data['StaffPlan']['is_all_day_event'] = $ade;
	           $this->request->data['StaffPlan']['color'] = $color;
	           $this->request->data['StaffPlan']['modified_by'] = $this->Session->read('userid');
	           $this->request->data['StaffPlan']['modify_time'] = date('Y-m-d H:i:s');
	           $checkSave = $this->StaffPlan->save($this->request->data);
			   if(!$checkSave){
			     $ret['IsSuccess'] = false;
			     $ret['Msg'] = "Unable to update this Staff Plan";
			   }else{
			     $ret['IsSuccess'] = true;
			     $ret['Msg'] = 'Staff Plan Updated';
			     $ret['Data'] = $this->StaffPlan->getLastInsertID();
			   }
           }
           }
	}catch(Exception $e){
	   $ret['IsSuccess'] = false;
	   $ret['Msg'] = $e->getMessage();
	}
	return $ret;
    }


/**
 * remove event calendar.
 *
 */
     public function removeCalendar($id){
        $this->loadModel('StaffPlan');
	$ret = array();
	try{
            $this->request->data['StaffPlan']['id'] = $id;
            $this->request->data['StaffPlan']['is_deleted'] = 1;
            $checkSave = $this->StaffPlan->save($this->request->data);
            if(!$checkSave){
	     $ret['IsSuccess'] = false;
	     $ret['Msg'] = "Unable to delete this Staff Plan";
	    }else{
	     $ret['IsSuccess'] = true;
	     $ret['Msg'] = 'Staff Plan Deleted';
	    }
	}catch(Exception $e){
	   $ret['IsSuccess'] = false;
	   $ret['Msg'] = $e->getMessage();
	}
	return $ret;
     }

/**
 * internal url for for converting js to php time 
 *
 */
        public function js2PhpTime($jsdate){
            if(preg_match('@(\d+)/(\d+)/(\d+)\s+(\d+):(\d+)@', $jsdate, $matches)==1){
              $ret = mktime($matches[4], $matches[5], 0, $matches[1], $matches[2], $matches[3]);
              //echo $matches[4] ."-". $matches[5] ."-". 0  ."-". $matches[1] ."-". $matches[2] ."-". $matches[3];
            }else if(preg_match('@(\d+)/(\d+)/(\d+)@', $jsdate, $matches)==1){
              $ret = mktime(0, 0, 0, $matches[1], $matches[2], $matches[3]);
              //echo 0 ."-". 0 ."-". 0 ."-". $matches[1] ."-". $matches[2] ."-". $matches[3];
            }
            return $ret;
        }

/**
 * internal url for for converting php to js time 
 *
 */
        public function php2JsTime($phpDate){
           //echo $phpDate;
           //return "/Date(" . $phpDate*1000 . ")/";
           return date("m/d/Y H:i", $phpDate);
        }

/**
 * internal url for for converting php to mysql time 
 *
 */
        public function php2MySqlTime($phpDate){
          return date("Y-m-d H:i:s", $phpDate);
        }

/**
 * internal url for for converting php to mysql time 
 *
 */
        public function mySql2PhpTime($sqlDate){
          $arr = date_parse($sqlDate);
          return mktime($arr["hour"],$arr["minute"],$arr["second"],$arr["month"],$arr["day"],$arr["year"]);
        }
/**
*
* generating excel report for staff leave plan
*
*/

public function staff_plan_xls($filterDate = null) {
	$this->uses = array('StaffPlan');
    $expFilterDate = explode("-", $filterDate);
	$from = $this->DateFormat->formatDate2STD(date("Y-m-d", strtotime($expFilterDate[0]))." 00:00:00",Configure::read('date_format'));
	$to = $this->DateFormat->formatDate2STD(date("Y-m-d", strtotime($expFilterDate[1]))." 23:59:59",Configure::read('date_format'));
	$getStaffPlan = $this->StaffPlan->find('all', array('conditions' => array('StaffPlan.location_id' => $this->Session->read('locationid'),'StaffPlan.is_deleted' => 0,'StaffPlan.starttime >=' => $from, 'StaffPlan.endtime <=' => $to), 'order' => array('StaffPlan.starttime')));
	
	$this->set('getStaffPlan', $getStaffPlan);
	$this->render('staff_plan_xls','');
}


}
?>