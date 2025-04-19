<?php 
/**
 * Chambers controller
 *
 * Use to create/edit/view/delete roles
 * created : 26 July
 */
class ChambersController extends AppController {

	public $name = 'Chambers';
	public $uses = array('Chamber');
	public $helpers = array('Html','Form', 'Js','DateFormat');
	public $components = array('RequestHandler','Email','DateFormat','ScheduleTime');

	public function admin_index() {
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array(
						'Chamber.name' => 'asc'
				),
				'conditions'=>array('location_id'=>$this->Session->read('locationid'),'is_deleted'=>0)
		);
		$this->set('title_for_layout', __('Manage Chamber', true));
		$data = $this->paginate('Chamber');
		$this->set('data', $data);
	}

	//function to add city
	public function admin_add($id=null) {
		$this->set('title_for_layout', __('- Add Chamber', true));
		if (!empty($this->data)) {
			$this->Chamber->insertChmaber($this->request->data);
			$errors = $this->Chamber->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
				$this->Session->setFlash(__('Chamber has been added successfully'),'default',array('class'=>'message'));
				$this->redirect(array("action" => "index", "admin" => true));
			}
		}
		if($id){
			$this->data = $this->Chamber->read(null,$id);
		}

	} //EOF of function add
		
	//function to delete role
	public function admin_delete($id = null) {
		$this->set('title_for_layout', __('- Delete Chamber', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Chamber'),'default',array('class'=>'error'));
			$this->redirect($this->referer());
		}
		$this->Chamber->id = $id ;
		if ($this->Chamber->save(array('is_deleted'=>1))) {
			$this->Session->setFlash(__('Chamber successfully deleted'),'default',array('class'=>'message'));
			$this->redirect($this->referer());
		}else{
			$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
			$this->redirect($this->referer());
		}
	}

	function chamber_scheduling(){
		$this->uses = array('DoctorProfile','DoctorChamber');
		$doctorList  = $this->DoctorProfile->getDoctors();
		$chamberList = $this->Chamber->getChamberList();
		 
		$this->set(array('doctors'=>$doctorList,'chambers'=>$chamberList));
	}

	function index(){
		//check if the doctor and chamber selected
		/*if(empty($this->params->query['doctor_id']) || empty($this->params->query['chamber_id'])
				||!isset($this->params->query['doctor_id']) || !isset($this->params->query['chamber_id'])
		){
		$this->Session->setFlash(__('Please select doctor and chamber.'),'default',array('class'=>'error'));
			
		$this->redirect($this->referer());
		}*/
		//for dropdown
		$this->layout = 'advance';
		$this->uses = array('DoctorProfile','DoctorChamber');
		$doctorList  = $this->DoctorProfile->getDoctors();
		$chamberList = $this->Chamber->getChamberList();
		 
		$this->set(array('doctors'=>$doctorList,'chambers'=>$chamberList));
		//for dropdown
		$doctor = $this->DoctorProfile->getDoctorByID($this->params->query['doctor_id']);
			
		if($this->params->query['chamber_id']){
			$chamber = $this->Chamber->getChambers($this->params->query['chamber_id']);
			$this->set('chamber_name',$chamber[0]['Chamber']['name']);
		}
		$this->set(array('doctor_name'=>$doctor['DoctorProfile']['doctor_name']));
	}

	function edit_chamber(){

		$this->uses = array('Chamber','DoctorProfile','DoctorChamber');

		// get opt details //
		$doctor_id = $this->params->query['doctor_id'];
		$chamber_id= $this->params->query['chamber_id'];
		 
		$getStaffPlan =  $this->DoctorChamber->find('first', array('conditions' => array('DoctorChamber.id' => $_GET["id"],'DoctorChamber.is_deleted'=>0)));
		 
		$getDoctorList = $this->DoctorProfile->getDoctors();
		$getChamberList = $this->Chamber->find('list',array('fields'=>array('id','name'),'conditions'=>array('Chamber.location_id'=>$this->Session->read('locationid'),'Chamber.is_deleted'=>0)));
		 
		//$sarr1 = explode(" ", $this->php2JsTime($this->mySql2PhpTime($getStaffPlan['DoctorChamber']['starttime'])));
		// $earr1 = explode(" ", $this->php2JsTime($this->mySql2PhpTime($getStaffPlan['DoctorChamber']['endtime'])));

		$sarr1 = explode(" ",$this->php2JsTime($this->mySql2PhpTime(
				$this->DateFormat->formatDate2LocalForReport($getStaffPlan['DoctorChamber']['starttime'],Configure::read('date_format'),true))));
		$earr1 = explode(" ",$this->php2JsTime($this->mySql2PhpTime(
				$this->DateFormat->formatDate2LocalForReport($getStaffPlan['DoctorChamber']['endtime'],Configure::read('date_format'),true))));
		 
		//$earr1[0] = date("j/n/Y", strtotime($earr1[0]));
		 
		$this->set('sarr1', $sarr1);
		$this->set('earr1', $earr1);
		$this->set('getStaffPlan', $getStaffPlan);
		$this->set(array('getDoctorList'=>$getDoctorList,'getChamberList'=>$getChamberList));
		if(isset($this->params->query['start'])){
			$this->set('startDate', $this->params->query['start']);
		}
		$this->set();
		$this->layout = false;
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
				$ret = $this->updateCalendar($_POST["calendarId"], $_POST["CalendarStartTime"], $_POST["CalendarEndTime"]);
				break;
			case "remove":
				$ret = $this->removeCalendar( $_POST["calendarId"]);
				break;
			case "adddetails":
				 
				$st = $_POST["stpartdate"] . " " . $_POST["stparttime"];
				$et = $_POST["stpartdate"] . " " . $_POST["etparttime"];
				
				//if(!isset($_GET["id"]))
				//	$_GET["id"] = $this->ScheduleTime->CheckOverlapBlockTime($_POST["stparttime"]);
				/* $stdst = $_POST["stpartdate"] . " " . $_POST["stparttime"];
					$stdet = $_POST["etpartdate"] . " " . $_POST["etparttime"];
				$st =  $this->DateFormat->formatDate2STD($stdst,Configure::read('date_format'));
				$et =  $this->DateFormat->formatDate2STD($stdet,Configure::read('date_format'));*/

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
		$this->loadModel('DoctorChamber');
		$ret = array();
		try{

			$scheduleDateStart = explode(" ", $this->php2MySqlTime($this->js2PhpTime($st)));
			$scheduleDateEnd = explode(" ", $this->php2MySqlTime($this->js2PhpTime($et)));
			$this->request->data['DoctorChamber']['location_id'] = $this->Session->read('locationid');
			$this->request->data['DoctorChamber']['schedule_date'] = $scheduleDateStart[0];
			$this->request->data['DoctorChamber']['start_time'] = $scheduleDateStart[1];
			$this->request->data['DoctorChamber']['end_time'] = $scheduleDateEnd[1];
			$this->request->data['DoctorChamber']['created_by'] = $this->Session->read('userid');
			$this->request->data['DoctorChamber']['create_time'] = date('Y-m-d H:i:s');
			$this->request->data['DoctorChamber']['subject'] = $sub;
			$this->request->data['DoctorChamber']['starttime'] = $this->DateFormat->formatDate2STDForReport($st,Configure::read('date_format'));
			$this->request->data['DoctorChamber']['endtime']   = $this->DateFormat->formatDate2STDForReport($et,Configure::read('date_format'));
			$this->request->data['DoctorChamber']['is_all_day_event'] = $ade;

			$checkSave = $this->DoctorChamber->save($this->request->data);
			if(!$checkSave){
				$ret['IsSuccess'] = false;
				$ret['Msg'] = "Unable to add this Chamber Plan";
			}else{
				$ret['IsSuccess'] = true;
				$ret['Msg'] = 'Chamber Plan Added';
				$ret['Data'] = $this->DoctorChamber->getLastInsertID();
			}
		}catch(Exception $e){
			$ret['IsSuccess'] = false;
			$ret['Msg'] = $e->getMessage();
		}
		return $ret;
	}

	/**
	 * update event calendar.
	 *
	 */
	public function updateCalendar($id, $st, $et){
		$this->loadModel('DoctorChamber');
		$ret = array();
		try{
			$this->DoctorChamber->id = $id;
			$scheduleDateStart = explode(" ", $this->php2MySqlTime($this->js2PhpTime($st)));
			$scheduleDateEnd = explode(" ", $this->php2MySqlTime($this->js2PhpTime($et)));
			$this->request->data['DoctorChamber']['location_id'] = $this->Session->read('locationid');
			$this->request->data['DoctorChamber']['schedule_date'] = $scheduleDateStart[0];
			$this->request->data['DoctorChamber']['start_time'] = $scheduleDateStart[1];
			$this->request->data['DoctorChamber']['end_time'] = $scheduleDateEnd[1];
			$this->request->data['DoctorChamber']['modified_by'] = $this->Session->read('userid');
			$this->request->data['DoctorChamber']['modify_time'] = date('Y-m-d H:i:s');
			$this->request->data['DoctorChamber']['starttime'] = $this->DateFormat->formatDate2STDForReport($st,Configure::read('date_format'));
			$this->request->data['DoctorChamber']['endtime']   = $this->DateFormat->formatDate2STDForReport($et,Configure::read('date_format'));
			$checkSave = $this->DoctorChamber->save($this->request->data);

			if(!$checkSave){
				$ret['IsSuccess'] = false;
				$ret['Msg'] = "Unable to update this Chamber Plan";
			}else{
				$ret['IsSuccess'] = true;
				$ret['Msg'] = 'Chamber Plan Updated';

			}
		}catch(Exception $e){
			$ret['IsSuccess'] = false;
			$ret['Msg'] = $e->getMessage();
		}
		return $ret;
	}

	/**
	 * list event calendar.
	 *
	 */
	public function listCalendar($day, $type){
		$phpTime = $this->js2PhpTime($day);
			
		switch($type){
			case "month":
				$st = mktime(0, 0, 0, date("m", $phpTime), 1, date("Y", $phpTime));
				$et = mktime(0, 0, -1, date("m", $phpTime)+1, 1, date("Y", $phpTime));
				break;
			case "week":
				//suppose first day of a week is monday
				$monday  =  date("d", $phpTime) - date('N', $phpTime) + 1;
					
				$st = mktime(0,0,0,date("m", $phpTime), $monday, date("Y", $phpTime));
				$et = mktime(0,0,-1,date("m", $phpTime), $monday+7, date("Y", $phpTime));
				break;
			case "day":
				$st = mktime(0, 0, 0, date("m", $phpTime), date("d", $phpTime), date("Y", $phpTime));
				$et = mktime(0, 0, -1, date("m", $phpTime), date("d", $phpTime)+1, date("Y", $phpTime));
				break;
		}
			
		return $this->listCalendarByRange($st, $et);
	}

	 
	/**
	 * list event calendar by range.
	 *
	 */
	public function listCalendarByRange($sd, $ed){
		$this->loadModel('DoctorChamber');
		$this->loadModel('DoctorProfile');
		$this->loadModel('Chamber');
		$ret = array();
		$ret['events'] = array();
		$ret["issort"] =true;
		$ret["start"] = $this->php2JsTime($sd);
		$ret["end"] = $this->php2JsTime($ed);
		$ret['error'] = null;
		$sd1 = $this->DateFormat->formatDate2STDForReport($this->php2MySqlTime($sd),Configure::read('date_format_yyyy_mm_dd')); //use of STD for +5:30 issue
		$sd = $this->php2MySqlTime($sd);
		$ed = $this->php2MySqlTime($ed);
		//echo $sd1; echo $ed; exit;
		try{
			$doctor_id   = $_GET['doctor_id'] ;
			$chamber_id  = $_GET['chamber_id'] ;
			$condition['DoctorChamber.location_id'] = $this->Session->read('locationid') ;
			$condition['DoctorChamber.is_deleted'] = 0 ;
				
			if(!empty($doctor_id)){
				$condition['DoctorChamber.doctor_id']=$doctor_id;
			}
			if(!empty($chamber_id)){
				$condition['DoctorChamber.chamber_id']=$chamber_id ;
			}
			$condition['DoctorChamber.starttime BETWEEN ? and ?'] = array($sd1, $ed);
			$getList = $this->DoctorChamber->find('all', array('conditions' => $condition));

			foreach($getList as $getListVal) {
					
				$realstartDate = $this->DateFormat->formatDate2LocalForReport($getListVal['DoctorChamber']['starttime'],Configure::read('date_format'),true);
				$realendate = $this->DateFormat->formatDate2LocalForReport($getListVal['DoctorChamber']['endtime'],Configure::read('date_format'),true);
				 
				//  $realendate = $getListVal['DoctorChamber']['endtime'];
				$startDate = strtotime($this->DateFormat->formatDate2LocalForReport($getListVal['DoctorChamber']['starttime'],Configure::read('date_format'),true));
				$endDate = strtotime($this->DateFormat->formatDate2LocalForReport($getListVal['DoctorChamber']['endtime'],Configure::read('date_format'),true));
				$datediff = $endDate - $startDate;
				$totaldaysDiff = floor(abs($endDate - $startDate) / 86400);

				$moreThanDay=0;
				if($totaldaysDiff>0){
					$moreThanDay = 1;
				}
				//doctor and chamber name
				$doctor = $this->DoctorProfile->getDoctorByID($getListVal['DoctorChamber']['doctor_id']);
				//$chamber = $this->Chamber->getChambers($getListVal['DoctorChamber']['chamber_id']);


				///EOF doctor and chamber name
				$ret['events'][] = array(
						$getListVal['DoctorChamber']['id'],
						'',
						$this->php2JsTime($this->mySql2PhpTime($realstartDate)),
						$this->php2JsTime($this->mySql2PhpTime($realendate)),
						$getListVal['DoctorChamber']['is_all_day_event'],
						$moreThanDay, //more than one day event
						//$row->InstanceType,
						0,//Recurring event,
						$getListVal['DoctorChamber']['color'],
						1,//editable
						date("d/m/Y H:i",strtotime($realstartDate)),
						date("d/m/Y H:i",strtotime($realendate)),
						$doctor['DoctorProfile']['doctor_name']//."(".$chamber[0]['Chamber']['name'].")",
				);

			}
		}catch(Exception $e){
			$ret['error'] = $e->getMessage();
		}
			
		return $ret;
	}

	/**
	 * update detailed event calendar.
	 *
	 */
	public function updateDetailedCalendar($id, $st, $et, $sub, $ade, $dscr, $color, $tz,$allvar){//echo 'update';exit;
		$this->uses = array('DoctorChamber');
		$ret = array();
		try{
			//BOF pankaj
			if(empty($et)) $et = $st; //as start and end date is same
			$weekArray = array("sunday","monday","tuesday","wednesday","thursday","friday","saturday");
			//select exiting chamber id
			$existData = $this->DoctorChamber->Find('first',array('fields'=>array('chamber_id'),'conditions'=>array('id'=>$id)));
			//EOF selection
			//is recurring
			if($allvar['is_recurring'] == 1){
				//add recurring month
				//$convertStartDate = $this->DateFormat->formatDate2STD($allvar['stpartdate']." ".$allvar['stparttime'],Configure::read('date_format'));
				//$convertStartDate = $this->DateFormat->formatDate2STDForReport($allvar['stpartdate'],Configure::read('date_format'))." ".$allvar['stparttime'];
				//$convertStartDate = $this->DateFormat->formatDate2STD($allvar['stpartdate']." ".$allvar['stparttime'],Configure::read('date_format'));
				$convertStartDate = $this->DateFormat->formatDate2STDForReport($allvar['stpartdate'],Configure::read('date_format'))." ".$allvar['stparttime'];
					
				$recurringUpto  = $allvar['recurring_month']+1;
				$convertStartDateSplit = explode(" ",$convertStartDate);

				//Remove if anything is added  after updated date to Start new recurring from newly selected date
				$lastDateTime = strtotime($convertStartDate."+$recurringUpto months") ;
				$convertEndDateSplit =   date('Y-m-d',$lastDateTime) ; //last week date of selected date
				//Remove if anything is added  after updated date to Start new recurring from newly selected date
				if(empty($allvar['recurring_identifier'])){
					$this->DoctorChamber->deleteAll(array("DoctorChamber.starttime >="=>$this->DateFormat->formatDate2STDForReport($convertStartDate,'yyyy-mm-dd'),
							"DATE_FORMAT(DoctorChamber.starttime,'%Y-%m-%d') <= "=>$convertEndDateSplit,
							'DoctorChamber.recurring_identifier IS NULL','DoctorChamber.doctor_id'=>$allvar['doctor_id'],
							'DoctorChamber.chamber_id'=>$existData['DoctorChamber']['chamber_id'] ));
				}else{
					$checkChamberStatus =	$this->DoctorChamber->deleteAll(array("DoctorChamber.starttime >="=>$this->DateFormat->formatDate2STDForReport($convertStartDate,'yyyy-mm-dd'),
							"DATE_FORMAT(DoctorChamber.starttime,'%Y-%m-%d') <= "=>$convertEndDateSplit,
							'DoctorChamber.recurring_identifier'=>$allvar['recurring_identifier'],'DoctorChamber.doctor_id'=>$allvar['doctor_id'],
							'DoctorChamber.chamber_id'=>$existData['DoctorChamber']['chamber_id'] ));

				}
				//EOF delete

					
				$lastDate  = date('Y-m-d',$lastDateTime);
				$dayCount= $this->DateFormat->dateDiff($convertStartDateSplit[0],$lastDate);
				$days   = $dayCount->days ;
				$noOfWeeks= ceil($days/7) ; //no of week comes between selected date range
				$nextWeek = $convertStartDate ;
				$j=0;
				$keyCheck =  $allvar['weekdays'] ;
				$recurring_identifier = strtotime("today") ;
				$skipFirstEntry =true ;
				for($w=0;$w<$noOfWeeks;$w++){
					reset($allvar['weekdays']);
					//foreach($allvar['weekdays'] as $key=>$value){
					for($f=0;$f<7;$f++){

						$value = $allvar['weekdays'][$f];
					  
						//For local conversion
						//$changeToLocal = $this->DateFormat->formatDate2Local($nextWeek,Configure::read('date_format'),true);
						$changeToLocal = $nextWeek;
						$endDate = explode(" ",$changeToLocal);
						//EOF
						//$endDate = explode(" ",$nextWeek);
						$endDateTime = $endDate[0]." ".$allvar['etparttime'] ;
						//check if the selected date's weekday has been selected or not
						//if($j==0 && $f==0){
						$isWeekDaySelected =  array_search(strtolower(date('l',strtotime($nextWeek))),$weekArray);
						 
						if(!in_array($isWeekDaySelected,$keyCheck)){
							$skipFirstEntry = false ; //skip selected date's entry as its weekday is not selected.
						}else{
							$skipFirstEntry = true ;
						}
						/*}else{
						 $skipFirstEntry = true ;
						}*/  //EOF check
						if($skipFirstEntry){
							$data[]['DoctorChamber'] = array('doctor_id' => $allvar['doctor_id'] ,
									'chamber_id'=> $allvar['chamber_id'],
									'purpose'=> $dscr,
									'is_blocked'=> $allvar['is_blocked'],
									'location_id'=> $this->Session->read('locationid'),
									'subject'=> $sub,
									'start_time'=> $allvar['stparttime'],
									'end_time'=> $allvar['etparttime'],
									'starttime'=> $this->DateFormat->formatDate2STDForReport($nextWeek,'yyyy-mm-dd'),
									'endtime'=> $this->DateFormat->formatDate2STDForReport($endDateTime,'yyyy-mm-dd'),
									'color'=> $color,
									'created_by'=> $this->Session->read('userid'),
									'create_time'=> date('Y-m-d H:i:s'),
									'is_all_day_event'=>$allvar['is_all_day_event'],
									'weekdays'=>serialize($allvar['weekdays']),
									'is_recurring'=>$allvar['is_recurring'],
									'recurring_month'=>$allvar['recurring_month'],
									'recurring_identifier'=>$recurring_identifier, //for grouping all recurring entries
							);
						}
						/* if($j==0 && $value !=0){
						 $arrayKey =  array_search(strtolower(date('l',strtotime($nextWeek))),$weekArray);
						$k=0 ;
						if(in_array($arrayKey,$keyCheck)){
						while(($keyCheck[key($keyCheck)] != $arrayKey)){
						next($allvar['weekdays']);
						next($keyCheck);
						if($k==5) {reset($allvar['weekdays']); $k=0;}
						if($k==5) {reset($keyCheck); $k=0 ;}
						$k++ ;
						}
						}
						$j++ ;
						} */
		 		  
						/* if($value !=0 ){
						 $nextWeek = $this->DateFormat->formatDate2Local($nextWeek,Configure::read('date_format'),true);
						}else{*/
						/* 	$nextWeekTime = strtotime("$nextWeek  next ".$weekArray[$value]) ;
						 $sameWeekSatTime = strtotime("$convertStartDate  next ".$weekArray[6]) ;
						$nextWeekDateOnly =   date('d-m-Y',$sameWeekSatTime)." ".$allvar['stparttime'];*/

						//echo "\n";
						//if($nextWeekTime >= $sameWeekSatTime && $w==0){
						$nextWeekTime = strtotime("$nextWeek  next day") ;
						$nextWeekDateOnly =   date('m/d/Y',$nextWeekTime);
						/*}else{
						 $nextWeekTime = strtotime("$nextWeek  next ".$weekArray[$value]) ;
						echo $nextWeekDateOnly =   date('d-m-Y',$nextWeekTime);
						 
						}*/

						$nextWeek =   $this->DateFormat->formatDate2STDForReport($nextWeekDateOnly,Configure::read('date_format'))." ".$allvar['stparttime'];
						//}

						if(strtotime($nextWeek) > $lastDateTime) break ;
						}

					}

				}else if(is_array($allvar['weekdays']) && !empty($allvar['weekdays'])){
					 
					//$convertStartDate = $this->DateFormat->formatDate2STD($allvar['stpartdate']." ".$allvar['stparttime'],Configure::read('date_format'));
					$convertStartDate = $this->DateFormat->formatDate2STDForReport($allvar['stpartdate']." ".$allvar['stparttime'],Configure::read('date_format'));
			   
					$nextWeek = $convertStartDate ;
					$convertStartDateSplit = explode(" ",$convertStartDate);
			   
					$convertEndDateSplit =   date('Y-m-d',strtotime("$nextWeek next ".$weekArray[end($allvar['weekdays'])])) ; //last week date of selected date

					//Remove if anything is added  after updated date to Start new recurring from newly selected date
					if(empty($allvar['recurring_identifier'])){
						$this->DoctorChamber->deleteAll(array("DoctorChamber.starttime >="=>$convertStartDate,
								"DATE_FORMAT(DoctorChamber.starttime,'%Y-%m-%d') <= "=>$convertEndDateSplit,
								'DoctorChamber.recurring_identifier IS NULL','DoctorChamber.doctor_id'=>$allvar['doctor_id'],
								'DoctorChamber.chamber_id'=>$existData['DoctorChamber']['chamber_id'] ));
					}else{
						$this->DoctorChamber->deleteAll(array("DoctorChamber.starttime >="=>$convertStartDate,
								"DATE_FORMAT(DoctorChamber.starttime,'%Y-%m-%d') <= "=>$convertEndDateSplit,
								'DoctorChamber.recurring_identifier'=>$allvar['recurring_identifier'],'DoctorChamber.doctor_id'=>$allvar['doctor_id'],
								'DoctorChamber.chamber_id'=>$existData['DoctorChamber']['chamber_id'] ));
					}

					//EOF delete

					 
					foreach($allvar['weekdays'] as $key => $value){
							
						if($key != 0 ){
							 
							$nextWeek =   $this->DateFormat->formatDate2STDForReport(date('m/d/Y',strtotime("$nextWeek ".$weekArray[$value]))." ".$allvar['stparttime'],Configure::read('date_format'));
							$endDateWeek =    $this->DateFormat->formatDate2STDForReport(date('m/d/Y',strtotime("$nextWeek ".$weekArray[$value]))." ".$allvar['etparttime'],Configure::read('date_format'));

						}else{
							$nextWeek =   $this->DateFormat->formatDate2STDForReport($allvar['stpartdate']." ".$allvar['stparttime'],Configure::read('date_format'));
							$endDateWeek =   $this->DateFormat->formatDate2STDForReport($allvar['stpartdate']." ".$allvar['etparttime'],Configure::read('date_format'));
						}
			  		
						//For local conversion
						//$changeToLocal = $this->DateFormat->formatDate2Local($endDate,Configure::read('date_format'),true);
						$changeToLocal = $endDate;

						$endDate = explode(" ",$changeToLocal);
						//EOF

						$endDateTime = $endDate[0]." ".$allvar['etparttime'] ;
						$data[]['DoctorChamber'] = array('doctor_id' => $allvar['doctor_id'] ,
								'chamber_id'=> $allvar['chamber_id'],
								'purpose'=> $dscr,
								'is_blocked'=> $allvar['is_blocked'],
								'location_id'=> $this->Session->read('locationid'),
								'subject'=> $sub,
								'start_time'=> $allvar['stparttime'],
								'end_time'=> $allvar['etparttime'],
								'starttime'=> $nextWeek,
								'endtime'=> $endDateWeek,
								'color'=> $color,
								'created_by'=> $this->Session->read('userid'),
								'create_time'=> date('Y-m-d H:i:s'),
								'is_all_day_event'=>$allvar['is_all_day_event'],
								'weekdays'=>serialize($allvar['weekdays']));

					}
						
				}else{
					//for selected date booking.
					$convertStartDate = $this->DateFormat->formatDate2STDForReport($allvar['stpartdate']." ".$allvar['stparttime'],Configure::read('date_format'));
					$nextWeek = $convertStartDate ;
					$endDate = explode(" ",$nextWeek);
					//$endDateTime = $endDate[0]." ".$allvar['etparttime'] ;
					$convertStartDateNonUTC = $this->DateFormat->formatDate2STDForReport($allvar['stpartdate'],Configure::read('date_format'));
					if($allvar['is_all_day_event']==1){
						$endDateTime = date("m/d/Y H:i:s",strtotime($convertStartDateNonUTC." 23:59:59"));
					}else{
						$endDateTime = $convertStartDateNonUTC." ".$allvar['etparttime'] ;
					}
					$data[]['DoctorChamber'] = array(
							'id'=>$id,
							'doctor_id' => $allvar['doctor_id'] ,
							'chamber_id'=> $allvar['chamber_id'],
							'purpose'=> $dscr,
							'is_blocked'=> $allvar['is_blocked'],
							'location_id'=> $this->Session->read('locationid'),
							'subject'=> $sub,
							'start_time'=> $allvar['stparttime'],
							'end_time'=> $allvar['etparttime'],
							'starttime'=> $nextWeek,
							'endtime'=> $this->DateFormat->formatDate2STDForReport($endDateTime,Configure::read('date_format_yyyy_mm_dd')),
							'color'=> $color,
							'created_by'=> $this->Session->read('userid'),
							'create_time'=> date('Y-m-d H:i:s'),
							'is_all_day_event'=>$allvar['is_all_day_event']);
					 



				}//
				//EOF pankaj
				 
					
				$checkSave = $this->DoctorChamber->saveAll($data);
				 
				 
				if(!$checkSave){
					$ret['IsSuccess'] = false;
					$ret['Msg'] = "Unable to update this Chamber Plan";
				}else{
					$ret['IsSuccess'] = true;
					$ret['Msg'] = 'Chamber Plan Updated';
					$ret['Data'] = $this->DoctorChamber->getLastInsertID();
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

			$this->uses = array('DoctorChamber');
			$ret = array();
		 try{

		 	//BOF pankaj
		 	if(empty($et)) $et = $st; //as start and end date is same
		 	$weekArray = array("sunday","monday","tuesday","wednesday","thursday","friday","saturday");
		 	//is recurring

		 	if($allvar['is_recurring'] == 1){
		 		//add recurring month
					//  $convertStartDate = $this->DateFormat->formatDate2STD($allvar['stpartdate']." ".$allvar['stparttime'],Configure::read('date_format'));
		 		$convertStartDate = $this->DateFormat->formatDate2STDForReport($allvar['stpartdate'],Configure::read('date_format'))." ".$allvar['stparttime'];
		 		$recurringUpto  = $allvar['recurring_month']+1;
		 		$convertStartDateSplit = explode(" ",$convertStartDate);
		 		$lastDateTime = strtotime($convertStartDate."+$recurringUpto months") ;
		 		$lastDate  = date('Y-m-d',$lastDateTime);
		 		$dayCount= $this->DateFormat->dateDiff($convertStartDateSplit[0],$lastDate);
		 		$days   = $dayCount->days ;
		 		$noOfWeeks= ceil($days/7) ; //no of week comes between selected date range
		 		$nextWeek = $convertStartDate ;
		 		$j=0;
		 		$keyCheck =  $allvar['weekdays'] ;
		 		$recurring_identifier = strtotime("today") ;
		 		$skipFirstEntry = true ;

		 		for($w=0;$w<$noOfWeeks;$w++){
		 			reset($allvar['weekdays']);
		 				
		 			for($f=0;$f<7;$f++){

		 				$value = $allvar['weekdays'][$f];
		 				 
		 				//For local conversion
		 				//$changeToLocal = $this->DateFormat->formatDate2Local($nextWeek,Configure::read('date_format'),true);
		 				$changeToLocal = $nextWeek;
		 				$endDate = explode(" ",$changeToLocal);

		 				//EOF
		 				//$endDate = explode(" ",$nextWeek);
		 				$endDateTime = $endDate[0]." ".$allvar['etparttime'] ;
		 				//check if the selected date's weekday has been selected or not
		 				//if($j==0 && $f==0){
		 				$isWeekDaySelected =  array_search(strtolower(date('l',strtotime($nextWeek))),$weekArray);
		 				 
		 				if(!in_array($isWeekDaySelected,$keyCheck)){
		 					$skipFirstEntry = false ; //skip selected date's entry as its weekday is not selected.
		 				}else{
		 					$skipFirstEntry = true ;
		 				}
		 				/*}else{
		 				 $skipFirstEntry = true ;
		 				}*/  //EOF check
		 				 
		 				if($skipFirstEntry){
		 					$data[]['DoctorChamber'] = array('doctor_id' => $allvar['doctor_id'] ,
		 							'chamber_id'=> $allvar['chamber_id'],
		 							'purpose'=> $dscr,
		 							'is_blocked'=> $allvar['is_blocked'],
		 							'location_id'=> $this->Session->read('locationid'),
		 							'subject'=> $sub,
		 							'start_time'=> $allvar['stparttime'],
		 							'end_time'=> $allvar['etparttime'],
		 							'starttime'=> $this->DateFormat->formatDate2STDForReport($nextWeek,'yyyy-mm-dd'),
		 							'endtime'=> $this->DateFormat->formatDate2STDForReport($endDateTime,'yyyy-mm-dd'),
		 							'color'=> $color,
		 							'created_by'=> $this->Session->read('userid'),
		 							'create_time'=> date('Y-m-d H:i:s'),
		 							'is_all_day_event'=>$allvar['is_all_day_event'],
		 							'weekdays'=>serialize($allvar['weekdays']),
		 							'is_recurring'=>$allvar['is_recurring'],
		 							'recurring_month'=>$allvar['recurring_month'],
		 							'recurring_identifier'=>$recurring_identifier, //for grouping all recurring entries
		 					);
		 				}

		 				/* if($j==0 && $value !=0){
		 				 $arrayKey =  array_search(strtolower(date('l',strtotime($nextWeek))),$weekArray);
		 				$k=0 ;
		 				if(in_array($arrayKey,$keyCheck)){
		 				while(($keyCheck[key($keyCheck)] != $arrayKey)){
		 				next($allvar['weekdays']);
		 				next($keyCheck);
		 				if($k==5) {reset($allvar['weekdays']); $k=0;}
		 				if($k==5) {reset($keyCheck); $k=0 ;}
		 				$k++ ;
		 				}
		 				}
		 				$j++ ;
		 				} */
		 				 
		 				/* if($value !=0 ){
		 				 $nextWeek = $this->DateFormat->formatDate2Local($nextWeek,Configure::read('date_format'),true);
		 				}else{*/
		 				/* 	$nextWeekTime = strtotime("$nextWeek  next ".$weekArray[$value]) ;
		 				 $sameWeekSatTime = strtotime("$convertStartDate  next ".$weekArray[6]) ;
		 				$nextWeekDateOnly =   date('d-m-Y',$sameWeekSatTime)." ".$allvar['stparttime'];*/

		 				//echo "\n";
		 				//if($nextWeekTime >= $sameWeekSatTime && $w==0){
		 				$nextWeekTime = strtotime("$nextWeek  next day") ;
		 				$nextWeekDateOnly =   date('m/d/Y',$nextWeekTime);
		 				/*}else{
		 				 $nextWeekTime = strtotime("$nextWeek  next ".$weekArray[$value]) ;
		 				echo $nextWeekDateOnly =   date('d-m-Y',$nextWeekTime);
		 				 
		 				}*/

		 				$nextWeek =   $this->DateFormat->formatDate2STDForReport($nextWeekDateOnly,Configure::read('date_format'))." ".$allvar['stparttime'];
		 				//}

		 				if(strtotime($nextWeek) > $lastDateTime) break ;
		 				}
		 					
		 			}
		 			
		 		}else if(is_array($allvar['weekdays']) && !empty($allvar['weekdays'])){

		 			$convertStartDate = $this->DateFormat->formatDate2STDForReport($allvar['stpartdate'],Configure::read('date_format'))." ".$allvar['stparttime'];
		 			$nextWeek = $convertStartDate ;
		 			foreach($allvar['weekdays'] as $key=>$value){
		 				 
		 				if($key != 0 ){
		 					$nextWeek =   $this->DateFormat->formatDate2STDForReport(date('m/d/Y',strtotime("$nextWeek ".$weekArray[$value]))." ".$allvar['stparttime'],Configure::read('date_format'));
		 					$endDateWeek =    $this->DateFormat->formatDate2STDForReport(date('m/d/Y',strtotime("$nextWeek ".$weekArray[$value]))." ".$allvar['etparttime'],Configure::read('date_format'));
		 				}else{
		 					$nextWeek =   $this->DateFormat->formatDate2STDForReport($allvar['stpartdate']." ".$allvar['stparttime'],Configure::read('date_format'));
		 					$endDateWeek =   $this->DateFormat->formatDate2STDForReport($allvar['stpartdate']." ".$allvar['etparttime'],Configure::read('date_format'));
		 				}
		 				$endDate = explode(" ",$nextWeek);

		 				//$nextWeek =   $this->DateFormat->formatDate2STD(date('d-m-Y',strtotime("$nextWeek ".$weekArray[$value]))." $endDate[1]",Configure::read('date_format'));
		 				$endDateTime = $endDate[0]." ".$allvar['etparttime'] ;
		 				$data[]['DoctorChamber'] = array('doctor_id' => $allvar['doctor_id'] ,
		 						'chamber_id'=> $allvar['chamber_id'],
		 						'purpose'=> $dscr,
		 						'is_blocked'=> $allvar['is_blocked'],
		 						'location_id'=> $this->Session->read('locationid'),
		 						'subject'=> $sub,
		 						'start_time'=> $allvar['stparttime'],
		 						'end_time'=> $allvar['etparttime'],
		 						'starttime'=> $nextWeek,
		 						'endtime'=> $endDateWeek,
		 						'color'=> $color,
		 						'created_by'=> $this->Session->read('userid'),
		 						'create_time'=> date('Y-m-d H:i:s'),
		 						'is_all_day_event'=>$allvar['is_all_day_event'],
		 						'weekdays'=>serialize($allvar['weekdays']));
		 					
		 			}
		 		}else{
		 			//for selected date booking.
		 			$convertStartDate = $this->DateFormat->formatDate2STDForReport($allvar['stpartdate']." ".$allvar['stparttime'],Configure::read('date_format'));
		 			$nextWeek = $convertStartDate ;
		 			$endDate = explode(" ",$nextWeek);
		 			$convertStartDate = $this->DateFormat->formatDate2STDForReport($allvar['stpartdate'],Configure::read('date_format'));
	  		  
		 			if($allvar['is_all_day_event']==1){
		 				$endDateTime = date("m/d/Y H:i:s",strtotime($convertStartDate." 23:59:59"));
		 			}else{
		 				$endDateTime = $convertStartDate." ".$allvar['etparttime'] ;
		 			}

		 			$data[]['DoctorChamber'] = array('doctor_id' => $allvar['doctor_id'] ,
		 					'chamber_id'=> $allvar['chamber_id'],
		 					'purpose'=> $dscr,
		 					'location_id'=> $this->Session->read('locationid'),
		 					'subject'=> $sub,
		 					'start_time'=> $allvar['stparttime'],
		 					'end_time'=> $allvar['etparttime'],
		 					'starttime'=> $nextWeek,
		 					'endtime'=> $this->DateFormat->formatDate2STDForReport($endDateTime,Configure::read('date_format_yyyy_mm_dd')),
		 					'color'=> $color,
		 					'created_by'=> $this->Session->read('userid'),
		 					'create_time'=> date('Y-m-d H:i:s'),
		 					'is_all_day_event'=>$allvar['is_all_day_event'],
		 					'is_blocked'=>$allvar['is_blocked']);

		 		}
		 		//EOF pankaj

		 			
		 		$checkSave = $this->DoctorChamber->saveAll($data);
		 		if(!$checkSave){
		 			$ret['IsSuccess'] = false;
		 			$ret['Msg'] = "Unable to add this Chamber";
		 		}else{
		 			$ret['IsSuccess'] = true;
		 			$ret['Msg'] = 'Chamber Plan Added';
		 			$ret['Data'] = $this->DoctorChamber->getLastInsertID();
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
		 	$this->loadModel('DoctorChamber');
		 	$ret = array();
		 	try{
		 		$this->request->data['DoctorChamber']['id'] = $id;
		 		$this->request->data['DoctorChamber']['is_deleted'] = 1;
		 		$checkSave = $this->DoctorChamber->save($this->request->data);
		 		if(!$checkSave){
		 			$ret['IsSuccess'] = false;
		 			$ret['Msg'] = "Unable to delete this Chamber Plan";
		 		}else{
		 			$ret['IsSuccess'] = true;
		 			$ret['Msg'] = 'Chamber Plan Deleted';
		 		}
		 	}catch(Exception $e){
		 		$ret['IsSuccess'] = false;
		 		$ret['Msg'] = $e->getMessage();
		 	}
		 	return $ret;
		 }
		}