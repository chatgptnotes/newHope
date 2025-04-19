<?php 
/**
 * DutyRoster model
 *
 * PHP 5
 *
 * @copyright     ----
 * @link          http://www.drmhope.com/
 * @package       Duty Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Gaurav Chauriya
 */
class DutyRoster extends AppModel {

	public $name = 'DutyRoster';
	public $useTable = 'duty_rosters';
	public $specific = true;
	public function __construct($id = false, $table = null, $ds = null) {
		if(empty($ds) && class_exists('cakeSession')){ //added by Mahalaxmi	
			$session = new cakeSession();
			$this->db_name =  $session->read('db_name');
		}else{		
			$this->db_name =  $ds;
		}
		parent::__construct($id, $table, $ds);
	}
	
	/**
	 * function to add monthly plan
	 * @param Array $data
	 * @author Gaurav Chauriya
	 */
	public function createMonthlyRoster( $data = array() ){ 
		$session = new cakeSession(); 
		$configuration = ClassRegistry::init('Configuration');
		$recursiveCount = $configuration->find('first',array('fields'=>'value','conditions'=>array('name'=>configure::read('shifts'))));
		$recursiveCount = unserialize($recursiveCount['Configuration']['value']);
		$recursiveDays = $recursiveCount['recurring_days'];
		$shifts = $recursiveCount['ShiftName'];
		$currentShift = array_search ($data['first_shift'], $shifts);
		$counter = 1; 
		$this->bindModel(array(
				'belongsTo' => array(
						'DutyPlan' =>array('foreignKey' => false,'conditions'=>array('DutyRoster.user_id=DutyPlan.user_id' )),
				)),false);

		$this->DutyPlan->updateAll(array('DutyPlan.is_roster_set'=>'1'), 
				array('DutyPlan.first_duty_date' => $data['duty_month'],'DutyPlan.user_id' => $data['user_id']));
		$shiftDaysManipulation = $data['allow_day_off'] == 'true' ? 1 : 0;
		for($i = strtotime($data['duty_month']) ; $i <= strtotime(date("Y-m-t", strtotime($data['duty_month'])) ) ; $i += (3600 * 24) ){
			$dutyArray[$counter] = array('user_id'=> $data['user_id'],
					'role_id' => $data['role_id'],
					'ward_id' => $data['ward_id'],
					'location_id' => $session->read('locationid'),
					'created_by' => $session->read('userid'),
					'create_time' => date('Y-m-d H:i:s')
			);
			if( ($counter % ($recursiveDays + $shiftDaysManipulation) )  == 0 ){
				$dutyArray[$counter]['date'] = date('Y-m-d',$i);
				if($data['allow_day_off'] == 'true')
					$dutyArray[$counter]['day_off'] = 'OFF';
				$dutyArray[$counter]['shift'] = $shifts[$currentShift];
				if($data['is_recurring'] == 1){
					if(count($shifts)-1 == $currentShift )
						$currentShift = 0;
					else
						$currentShift++;
				}
			}else{
				
				$dutyArray[$counter]['date'] = date('Y-m-d',$i);
				$dutyArray[$counter]['shift'] = $shifts[$currentShift];
				$dutyArray[$counter]['day_off'] = 0;
			}
			$counter++;
		}
		$this->saveAll($dutyArray);
		return true;
	}
	/**
	 * function to add monthly plan
	 * @param Array $data
	 * @author Mahalaxmi
	 */
	public function createMonthlyDutyRoster($month,$year,$data = array()){ 	
		debug($data);
		exit;
		$session = new cakeSession(); 
		$configuration = ClassRegistry::init('Configuration');
		$recursiveCount = $configuration->find('first',array('fields'=>'value','conditions'=>array('name'=>configure::read('shifts'))));
		$recursiveCount = unserialize($recursiveCount['Configuration']['value']);
		$recursiveDays = $recursiveCount['recurring_days'];
		$shifts = $recursiveCount['ShiftName'];
		$currentShift = array_search ($data['first_shift'], $shifts);
		$counter = 1; 
		/*$this->bindModel(array(
				'belongsTo' => array(
						'DutyPlan' =>array('foreignKey' => false,'conditions'=>array('DutyRoster.user_id=DutyPlan.user_id' )),
				)),false);

		$this->DutyPlan->updateAll(array('DutyPlan.is_roster_set'=>'1'), 
				array('DutyPlan.first_duty_date' => $data['duty_month'],'DutyPlan.user_id' => $data['user_id']));*/
		$shiftDaysManipulation = $data['allow_day_off'] == 'true' ? 1 : 0;
		//for($i = strtotime($data['duty_month']) ; $i <= strtotime(date("Y-m-t", strtotime($data['duty_month'])) ) ; $i += (3600 * 24) ){
		$lastDate = 26 - (31 - date('t',strtotime("$year-$month-26")));
		$curDate = strtotime(date('Y-m-d',strtotime('+1 month',date('Y-m-d'))+strtotime("$year-$month-$lastDate")));
				
		for($i = strtotime(date('Y-m-d',strtotime("$year-$month-26")));$i < $curDate;){
					
			$dutyArray[date('Y-m-d',$i)] = array(/*'user_id'=> $data['user_id'],
					'role_id' => $data['role_id'],
					'ward_id' => $data['ward_id'],*/
					'location_id' => $session->read('locationid'),
					'created_by' => $session->read('userid'),
					'create_time' => date('Y-m-d H:i:s')
			);
			if( ($counter % ($recursiveDays + $shiftDaysManipulation) )  == 0 ){
				$dutyArray[date('Y-m-d',$i)]['date'] = date('Y-m-d',date('Y-m-d',$i));
				if($data['allow_day_off'] == 'true')
					$dutyArray[date('Y-m-d',$i)]['day_off'] = 'OFF';
				$dutyArray[date('Y-m-d',$i)]['shift'] = $shifts[$currentShift];
				if($data['is_recurring'] == 1){
					if(count($shifts)-1 == $currentShift )
						$currentShift = 0;
					else
						$currentShift++;
				}
			}else{				
				$dutyArray[date('Y-m-d',$i)]['date'] = date('Y-m-d',$i);
				$dutyArray[date('Y-m-d',$i)]['shift'] = $shifts[$currentShift];
				$dutyArray[date('Y-m-d',$i)]['day_off'] = 0;
			}
			debug($dutyArray);
			$this->save($dutyArray[date('Y-m-d',$i)]);

			$this->id='';
			$i = $i + (3600 * 24);
			$counter++;			
		}
		//exit;
		/*debug($dutyArray);
		exit;*/
		//$this->saveAll($dutyArray);
		return true;
	}
	
	/*
	 * get in time and out time for that day if user is present by amit jain
	*/
	function getInOutTime($userId,$date,$locationId){
		$session = new cakeSession();
		$dutyRosterData = $this->find('first',array('fields'=>array('DutyRoster.id','DutyRoster.inouttime'),
						'conditions'=>array('DutyRoster.user_id'=>$userId,'DutyRoster.date'=>$date,'DutyRoster.location_id'=>$locationId)));
	
		$time['id'] = $dutyRosterData['DutyRoster']['id'];
		
		$inOutTimeSplit = explode('::', $dutyRosterData['DutyRoster']['inouttime']);
		$attdCount = count($inOutTimeSplit);
		if(!empty($attdCount)){
			if($attdCount%2==0){
				$time['in_time'] = $inOutTimeSplit['0'];
				$time['out_time'] = $inOutTimeSplit[$attdCount - 1];
			}else{
				$time['in_time'] = $inOutTimeSplit['0'];
				$time['out_time'] = '';
			}
		}else{
			$time['in_time'] = '';
			$time['out_time'] = '';
		}
		return $time;
	}

	/*
	 * closed user shift by amit jain
	*/
	function closedUserShift(){		
		$getPreviousDate=date('Y-m-d', strtotime('-1 day'));
		$dutyRosterData = $this->find('all',array('fields'=>array('DutyRoster.id','DutyRoster.inouttime'),
				'conditions'=>array('DutyRoster.is_deleted'=>'0','DutyRoster.outime'=>null,'DutyRoster.date'=>$getPreviousDate/*,'DutyRoster.id'=>'4407'*/))); //BOF-MAHALAXMI TO CHANGE 
		foreach ($dutyRosterData as $key=>$data){			
			$inOutTimeSplit = explode('::', $data['DutyRoster']['inouttime']);		
			$lastInTime = array_pop($inOutTimeSplit);				
			$updatedTime = date("H:i:s",strtotime($lastInTime."+14 hours"));			
			$inOutTimeUpdate = $data['DutyRoster']['inouttime']."::".$updatedTime;		
			$updateArr=array('DutyRoster.is_present'=>"'N'",'DutyRoster.remark'=>"'Out time updated from scheduler'",'DutyRoster.missed_punch'=>"'1'",'DutyRoster.outime'=>"'".$updatedTime."'",'DutyRoster.inouttime'=>"'".$inOutTimeUpdate."'");				
			$this->updateAll($updateArr,array('DutyRoster.id'=>$data['DutyRoster']['id']));
			$this->id='';
		}		
		exit;
	}

    /*
     * function to get the logined user
     * @author : Swapnil
     * @created : 12.03.2016
     */
    public function getAllPresentDetails(){
        return $this->find('count',array('conditions'=>array('is_present'=>'Y','date'=>date("Y-m-d"))));
    }
    
    /*
     * function to get all attendance details month wise
     * 
     */
    
    public function getAllAttendanceDetail($userId,$year){
        $result = $this->find('all',array(
            'fields'=>array(
                'COUNT(id) as total_attendance','DATE_FORMAT(date, "%m") AS month_reports'
            ),
            'group'=>array('month_reports'),
            'conditions'=>array(
                'YEAR(date)'=>$year,
                'day_off'=>'0',
                'user_id'=>$userId
            )
        ));
        foreach($result as $key => $val){
            $returnArr[$val[0]['month_reports']] = $val[0]['total_attendance'];
        }
        return $returnArr;
    }
}