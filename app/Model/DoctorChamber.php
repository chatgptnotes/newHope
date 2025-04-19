<?php
/**
 * Diagnosis file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Hope hospital
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pankaj wanajari
 */
class DoctorChamber extends AppModel {

	public $name = 'DoctorChamber';


	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}

	public function getDoctorsSchedule($doctorArray=array(),$date){
		//$doctorChamberModel = ClassRegistry::init('DoctorChamber');
		$cond = '';
		$days = Configure::read('calendar_days_to_show');
		$session = new cakeSession();
		$endDate = date("Y-m-d", strtotime($date. ' + ' . $days . ' days'));
		$dateRange = array($date,$endDate);
		if(is_array($doctorArray) && $doctorArray){
			$docAry = implode(',',array_keys($doctorArray));
			$cond = "DoctorChamber.doctor_id IN ($docAry)";
		}//debug($docAry);
		$this->bindModel(array(
				'hasOne' => array('DoctorProfile'=>array('foreignKey'=>false,'conditions'=>array('DoctorChamber.doctor_id = DoctorProfile.user_id')))));
		$data = $this->find('all',array('fields'=>array('DoctorProfile.starthours','DoctorProfile.endhours','DoctorProfile.user_id','doctor_id','start_time','end_time','is_blocked','purpose',
				'DATE_FORMAT(starttime, "%Y") as start_year','DATE_FORMAT(starttime, "%m") as start_month','DATE_FORMAT(starttime, "%d") as start_day',
				'DATE_FORMAT(starttime, "%Y-%m-%d") as start_date','DATE_FORMAT(endtime, "%Y-%m-%d") as end_date'),
				'conditions'=>array($cond,'DoctorChamber.location_id'=>$session->read('locationid'),'DoctorChamber.is_deleted'=>'0','DoctorProfile.is_active'=> 1,
						'DATE_FORMAT(starttime, "%Y-%m-%d") BETWEEN ? AND ?'=>$dateRange),
				'order'=>array('DATE_FORMAT(starttime, "%Y-%m-%d")')));
		return $data;
	}

	public function prepareDoctorSchedule($doctorArray=array(),$date,$allDoctor = array()){
		$configStartHours = Configure::read('calendar_start_time');
		$configEndHours = Configure::read('calendar_end_time');
		$data = $this->getDoctorsSchedule($doctorArray,$date);
		if(count($allDoctor) == 1){
			$doctorTimes[0] = $allDoctor;
		}else{$doctorTimes = $allDoctor;
		}
			
		$freebusys = '';
		foreach($doctorArray as $doctorKey => $doctorValue){
			$userId = array_search($doctorKey, array_keys($doctorArray));
			$freebusys .= '{"start": new Date('. date('Y', strtotime('-6 months')) .', '. (int) (date('m', strtotime('-6 months')) -1 ) .', '. date('d', strtotime('-6 months')) .', '. $configStartHours .'), "end": new Date('. date('Y', strtotime('+6 months')) .', '. (int) (date('m', strtotime('+6 months')) -1 ) .', '. date('d', strtotime('+6 months')) .', '. $configEndHours .', 00), "free": true, userId: ['. $userId .']},'."\n";
		}
			
		foreach($data as $key=>$value){
			$startHours = ($value['DoctorProfile']['starthours']) ? substr($value['DoctorProfile']['starthours'],0,2) : $configStartHours;
			$endHours = ($value['DoctorProfile']['endhours']) ? substr($value['DoctorProfile']['endhours'],0,2) : $configEndHours;
			$doctorId = $value['DoctorChamber']['doctor_id'];
			$isBlocked = ($value['DoctorChamber']['is_blocked']) ? 'true' : 'false';
			$message =  (!$value['DoctorChamber']['is_blocked']) ? '"message": "'.$value['DoctorChamber']['purpose'].'",' : '';
			$userId = array_search($doctorId, array_keys($doctorArray));
			$freebusys .= '{"start": new Date('. $value['0']['start_year'] .', '. (int) ($value['0']['start_month'] -1 ) .', '. $value['0']['start_day'] .', ' . substr($value['DoctorChamber']['start_time'], 0,2).', ' . substr($value['DoctorChamber']['start_time'], -2).' ), "end": new Date('. $value['0']['start_year'] .', '. (int) ($value['0']['start_month'] -1 ) .', '. $value['0']['start_day'] .', '. substr($value['DoctorChamber']['end_time'], 0,2) .', '. substr($value['DoctorChamber']['end_time'], -2) .'), "free": false, "is_blocked": '.$isBlocked.','.$message.' userId: ['. $userId .']},'."\n";
		}

		foreach($doctorTimes as $timeKey=>$timeValue){

			$startHours = ($timeValue['DoctorProfile']['starthours']) ? substr($timeValue['DoctorProfile']['starthours'],0,2) : $configStartHours;
			$endHours = ($timeValue['DoctorProfile']['endhours']) ? substr($timeValue['DoctorProfile']['endhours'],0,2) : $configEndHours;
			$doctorId = $timeValue['DoctorProfile']['user_id'];

			$userId = array_search($doctorId, array_keys($doctorArray));

			if(((int)$startHours - (int)$configStartHours) != 0){
				//for($i=0;$i<=29;$i++){ //this loop is for previous next button it carries calculation for 30 days
					//for starting calender block hours
					$freebusys .= '{"start": new Date('. date('Y'/*, strtotime(+$i.' days')*/) .', '. (int) (date('m'/*, strtotime(+$i.' days')*/) -1 ) .', '. date('d'/*, strtotime(+$i.' days')*/) .', '. $configStartHours .'), "end": new Date('. date('Y'/*, strtotime(+$i.' days')*/) .', '. (int) (date('m'/*, strtotime(+$i.' days')*/) -1 ) .', '. date('d'/*, strtotime(+$i.' days')*/) .', '. $startHours .', 00), "free": false, "is_blocked": true, userId: ['. $userId .']},'."\n";
				//}
			}
			if(((int)$endHours - (int)$configEndHours) != 0){
				//for($i=0;$i<=29;$i++){
					//for ending calender block hours
					$freebusys .= '{"start": new Date('. date('Y') .', '. (int) (date('m') -1 ) .', '. date('d') .', '. $endHours .'), "end": new Date('. date('Y') .', '. (int) (date('m') -1 ) .', '. date('d') .', '. $configEndHours .', 00), "free": false, "is_blocked": true, userId: ['. $userId .']},'."\n";
				//}
			}
		}
		
		return $freebusys;
	}


}
?>