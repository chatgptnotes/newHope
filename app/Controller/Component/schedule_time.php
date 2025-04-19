<?php
/**
 * ScheduleTimeComponent file
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
class ScheduleTimeComponent extends Component {

	/**
	 * check doctor schedule overlapping time for doctor appointment
	 *
	 */

	public function checkDoctorSchedule($getPostValue=null) {
		// first check by appointment table if there is overlapping between two time //
		$getPostValStartTime = strtotime($getPostValue['schedule_starttime']);
		$getPostValEndTime = strtotime($getPostValue['schedule_endtime']);
		$appointment = Classregistry::init('Appointment');
		$checkOverlapTime['appointment'] = 1;

		/*if($getPostValue['id']) {
		 $getAppointment = $appointment->find('all', array('conditions' => array('Appointment.date' => $getPostValue['scheduledate'], 'Appointment.appointment_with' => $getPostValue['appointment_with'], 'Appointment.is_deleted' => 0, 'Appointment.id <>' => $getPostValue['id']), 'recursive' => -1));
		} else {
		$getAppointment = $appointment->find('all', array('conditions' => array('Appointment.date' => $getPostValue['scheduledate'], 'Appointment.appointment_with' => $getPostValue['appointment_with'], 'Appointment.is_deleted' => 0), 'recursive' => -1));
		}

		foreach($getAppointment as $getAppointmentVal) {
		$startTime = strtotime($getAppointmentVal['Appointment']['start_time']);
		$endTime = strtotime($getAppointmentVal['Appointment']['end_time']);
		if($getPostValStartTime >= $startTime && $getPostValEndTime <= $endTime) {
		$checkOverlapTime['appointment'] = 2;
		}
		if($getPostValStartTime <= $startTime && $getPostValEndTime >= $endTime) {
		$checkOverlapTime['appointment'] = 2;
		}
		if($getPostValStartTime <= $startTime && $getPostValEndTime <= $endTime && !($getPostValEndTime <= $startTime)) {
		$checkOverlapTime['appointment'] = 2;
		}
		if($getPostValStartTime >= $startTime && !($getPostValStartTime >= $endTime)  && $getPostValEndTime >= $endTime) {
		$checkOverlapTime['appointment'] = 2;
		}
			
		}*/
		// get appointment date with time //
		$appointmentStartDateTime = $getPostValue['scheduledate']." ".$getPostValue['schedule_starttime'];
		$appointmentEndDateTime = $getPostValue['scheduledate']." ".$getPostValue['schedule_endtime'];
		$startDateTime = strtotime($appointmentStartDateTime);
		$endDateTime = strtotime($appointmentEndDateTime);
		// first check by staffplan table if there is overlapping between two time //
		$staffplan = Classregistry::init('StaffPlan');
		$getStaffPlan = $staffplan->find('all', array('conditions' => array('StaffPlan.user_id' => $getPostValue['doctor_userid'], 'StaffPlan.is_deleted' => 0), 'recursive' => -1));
		$checkOverlapTime['staffplan'] = 1;
		foreach($getStaffPlan as $getStaffPlanVal) {
			$startTime = strtotime($getStaffPlanVal['StaffPlan']['starttime']);
			$endTime = strtotime($getStaffPlanVal['StaffPlan']['endtime']);
			if($startDateTime >= $startTime && $endDateTime <= $endTime) {
				$checkOverlapTime['staffplan'] = 2;
			}
			if($startDateTime <= $startTime && $endDateTime >= $endTime) {
				$checkOverlapTime['staffplan'] = 2;
			}
			if($startDateTime <= $startTime && $endDateTime <= $endTime && !($endDateTime <= $startTime)) {
				$checkOverlapTime['staffplan'] = 2;
			}
			if($startDateTime >= $startTime && !($endDateTime >= $endTime)  && $endDateTime >= $endTime) {
				$checkOverlapTime['staffplan'] = 2;
			}

		}

		// check doctor overlapping in ot appointment  //
		$optAppointment = Classregistry::init('OptAppointment');
		$getOptAppointment = $optAppointment->find('all', array('conditions' => array('OptAppointment.doctor_id' => $getPostValue['doctor_userid'], 'OptAppointment.is_deleted' => 0), 'recursive' => -1));

		$checkOverlapTime['doctoroptappointment'] = 1;
		foreach($getOptAppointment as $getOptAppointmentVal) {
			$startTime = strtotime($getOptAppointmentVal['OptAppointment']['starttime']);
			$endTime = strtotime($getOptAppointmentVal['OptAppointment']['endtime']);
			if($startDateTime >= $startTime && $endDateTime <= $endTime) {
				$checkOverlapTime['doctoroptappointment'] = 2;
			}
			if($startDateTime <= $startTime && $endDateTime >= $endTime) {
				$checkOverlapTime['doctoroptappointment'] = 2;
			}
			if($startDateTime <= $startTime && $endDateTime <= $endTime && !($endDateTime <= $startTime)) {
				$checkOverlapTime['doctoroptappointment'] = 2;
			}
			if($startDateTime >= $startTime && !($endDateTime >= $endTime)  && $endDateTime >= $endTime) {
				$checkOverlapTime['doctoroptappointment'] = 2;
			}

		}

		// check anaesthesia doctor overlapping in ot appointment  //
		$optAppointment = Classregistry::init('OptAppointment');
		$getOptAppointment = $optAppointment->find('all', array('conditions' => array('OptAppointment.department_id' => $getPostValue['doctor_userid'], 'OptAppointment.is_deleted' => 0), 'recursive' => -1));
		$checkOverlapTime['anaesthesiaoptappointment'] = 1;
		foreach($getOptAppointment as $getOptAppointmentVal) {
			$startTime = strtotime($getOptAppointmentVal['OptAppointment']['starttime']);
			$endTime = strtotime($getOptAppointmentVal['OptAppointment']['endtime']);
			if($startDateTime >= $startTime && $endDateTime <= $endTime) {
				$checkOverlapTime['anaesthesiaoptappointment'] = 2;
			}
			if($startDateTime <= $startTime && $endDateTime >= $endTime) {
				$checkOverlapTime['anaesthesiaoptappointment'] = 2;
			}
			if($startDateTime <= $startTime && $endDateTime <= $endTime && !($endDateTime <= $startTime)) {
				$checkOverlapTime['anaesthesiaoptappointment'] = 2;
			}
			if($startDateTime >= $startTime && !($endDateTime >= $endTime)  && $endDateTime >= $endTime) {
				$checkOverlapTime['anaesthesiaoptappointment'] = 2;
			}

		}

		return $checkOverlapTime;
	}


	/**
	 * check doctor schedule overlapping time for OT with new calendar(wdcalendar)
	 *
	 **/

	public function checkOverlapForOT($getIdValue=null, $getStValue=null, $getEtValue=null, $allVar=null) {
		$checkOverlapTime = array();
		$getPostValStartTime = strtotime($getStValue);
		$getPostValEndTime = strtotime($getEtValue);
		$scheduleDateStart = explode(" ", $getStValue);
		$optappointment = Classregistry::init('OptAppointment');
		$getOptAppointment = $optappointment->find('all', array('conditions' => array('OptAppointment.opt_id' => $allVar['opt_id'],'OptAppointment.schedule_date'=>$scheduleDateStart[0],
		'OptAppointment.opt_table_id' => $allVar['opt_table_id'], 'OptAppointment.is_deleted' => 0, 'OptAppointment.id <>' => $getIdValue), 'recursive' => -1));

		$checkOverlapTime['optappointment'] = 1;
		foreach($getOptAppointment as $getOptAppointmentVal) {
			if($getOptAppointmentVal['OptAppointment']['starttime'] != "" || $getOptAppointmentVal['OptAppointment']['starttime'] != null || $getOptAppointmentVal['OptAppointment']['endtime'] != "" || $getOptAppointmentVal['OptAppointment']['endtime'] != null) {
					
				$startTime = strtotime($getOptAppointmentVal['OptAppointment']['starttime']);
				$endTime = strtotime($getOptAppointmentVal['OptAppointment']['endtime']);

				if($getPostValStartTime >= $startTime && $getPostValEndTime <= $endTime) {
					$checkOverlapTime['optappointment'] = 2;
				}
				if($getPostValStartTime <= $startTime && $getPostValEndTime >= $endTime) {
					$checkOverlapTime['optappointment'] = 2;
				}
				if($getPostValStartTime <= $startTime && $getPostValEndTime <= $endTime && !($getPostValEndTime <= $startTime)) {
					$checkOverlapTime['optappointment'] = 2;
				}
				if($getPostValStartTime >= $startTime && !($getPostValStartTime >= $endTime)  && $getPostValEndTime >= $endTime) {
					$checkOverlapTime['optappointment'] = 2;
				}
			}
		}
		// check for doctor is already appointment or not //
		//BOF-Mahalaxmi for doctorID		
		foreach ($allVar['data']['surgery']['doctor_id'] as $key => $value) {			
			foreach ($value as $subKey => $subValue) {
				$doctorId[]=$subValue;							
			}
		}
		//EOF-Mahalaxmi for doctorID	

		$getSurgeonAppointment = $optappointment->find('all', array('conditions' => array('OptAppointment.doctor_id' => $doctorId, 'OptAppointment.is_deleted' => 0,'OptAppointment.id <>' => $getIdValue,'OptAppointment.schedule_date'=>$scheduleDateStart[0]), 'recursive' => -1));
		
		$checkOverlapTime['surgeonoverlap'] = 1;
		foreach($getSurgeonAppointment as $getSurgeonAppointmentVal) {
			if($getSurgeonAppointmentVal['OptAppointment']['starttime'] != "" || $getSurgeonAppointmentVal['OptAppointment']['starttime'] != null || $getSurgeonAppointmentVal['OptAppointment']['endtime'] != "" || $getSurgeonAppointmentVal['OptAppointment']['endtime'] != null) {					
				$startTime = strtotime($getSurgeonAppointmentVal['OptAppointment']['starttime']);
				$endTime = strtotime($getSurgeonAppointmentVal['OptAppointment']['endtime']);
				if($getPostValStartTime >= $startTime && $getPostValEndTime <= $endTime) {
					$checkOverlapTime['surgeonoverlap'] = 2;
				}
				if($getPostValStartTime <= $startTime && $getPostValEndTime >= $endTime) {
					$checkOverlapTime['surgeonoverlap'] = 2;
				}
				if($getPostValStartTime <= $startTime && $getPostValEndTime <= $endTime && !($getPostValEndTime <= $startTime)) {
					$checkOverlapTime['surgeonoverlap'] = 2;
				}
				if($getPostValStartTime >= $startTime && !($getPostValStartTime >= $endTime)  && $getPostValEndTime >= $endTime) {
					$checkOverlapTime['surgeonoverlap'] = 2;
				}
			}
		}
		// check for anaesthesia doctor is already appointment or not //
		/*if($allVar['department_id']) {
			$getAnaesthesiaAppointment = $optappointment->find('all', array('conditions' => array('OptAppointment.department_id' => $allVar['department_id'],
			'OptAppointment.is_deleted' => 0, 'OptAppointment.id <>' => $getIdValue,'OptAppointment.schedule_date'=>$scheduleDateStart[0]), 'recursive' => -1));
			debug($getAnaesthesiaAppointment);
			$checkOverlapTime['anaesthesiaoverlap'] = 1;
			foreach($getAnaesthesiaAppointment as $getAnaesthesiaAppointmentVal) {
				if($getAnaesthesiaAppointmentVal['OptAppointment']['starttime'] != "" || $getAnaesthesiaAppointmentVal['OptAppointment']['starttime'] != null || $getAnaesthesiaAppointmentVal['OptAppointment']['endtime'] != "" || $getAnaesthesiaAppointmentVal['OptAppointment']['endtime'] != null) {

					$startTime = strtotime($getAnaesthesiaAppointmentVal['OptAppointment']['starttime']);
					$endTime = strtotime($getAnaesthesiaAppointmentVal['OptAppointment']['endtime']);

					if($getPostValStartTime >= $startTime && $getPostValEndTime <= $endTime) {
						$checkOverlapTime['anaesthesiaoverlap'] = 2;
					}
					if($getPostValStartTime <= $startTime && $getPostValEndTime >= $endTime) {
						$checkOverlapTime['anaesthesiaoverlap'] = 2;
					}
					if($getPostValStartTime <= $startTime && $getPostValEndTime <= $endTime && !($getPostValEndTime <= $startTime)) {
						$checkOverlapTime['anaesthesiaoverlap'] = 2;
					}
					if($getPostValStartTime >= $startTime && !($getPostValStartTime >= $endTime)  && $getPostValEndTime >= $endTime) {
						$checkOverlapTime['anaesthesiaoverlap'] = 2;
					}
				}
			}
		}*/

		// check if surgeon leaving plan is set or not //
		$staffplan = Classregistry::init('StaffPlan');
		$getStaffPlanSurgeon = $staffplan->find('all', array('conditions' => array('StaffPlan.user_id' => $allVar['doctor_id'], 'StaffPlan.is_deleted' => 0), 'recursive' => -1));
		$checkOverlapTime['surgeon'] = 1;

		foreach($getStaffPlanSurgeon as $getStaffPlanSurgeonVal) {
			if($getStaffPlanSurgeonVal['StaffPlan']['starttime'] != "" && $getStaffPlanSurgeonVal['StaffPlan']['starttime'] != null && $getStaffPlanSurgeonVal['StaffPlan']['endtime'] != "" && $getStaffPlanSurgeonVal['StaffPlan']['endtime'] != null) {
				$startTime = strtotime($getStaffPlanSurgeonVal['StaffPlan']['starttime']);
				$endTime = strtotime($getStaffPlanSurgeonVal['StaffPlan']['endtime']);
				if($getPostValStartTime >= $startTime && $getPostValEndTime <= $endTime) {
					$checkOverlapTime['surgeon'] = 2;
				}
				if($getPostValStartTime <= $startTime && $getPostValEndTime >= $endTime) {
					$checkOverlapTime['surgeon'] = 2;
				}
				if($getPostValStartTime <= $startTime && $getPostValEndTime <= $endTime && !($getPostValEndTime <= $startTime)) {
					$checkOverlapTime['surgeon'] = 2;
				}
				if($getPostValStartTime >= $startTime && !($getPostValStartTime >= $endTime)  && $getPostValEndTime >= $endTime) {
					$checkOverlapTime['surgeon'] = 2;
				}
			}
		}

		// check if anaesthesia leaving plan is set or not  //
		$getStaffPlanAnaesthesia = $staffplan->find('all', array('conditions' => array('StaffPlan.user_id' => $allVar['department_id'], 'StaffPlan.is_deleted' => 0), 'recursive' => -1));
		$checkOverlapTime['anaesthesia'] = 1;
		foreach($getStaffPlanAnaesthesia as $getStaffPlanAnaesthesiaVal) {
			if($getStaffPlanAnaesthesiaVal['StaffPlan']['starttime'] != "" && $getStaffPlanAnaesthesiaVal['StaffPlan']['starttime'] != null && $getStaffPlanAnaesthesiaVal['StaffPlan']['endtime'] != "" && $getStaffPlanAnaesthesiaVal['StaffPlan']['endtime'] != null) {

				$startTime = strtotime($getStaffPlanAnaesthesiaVal['StaffPlan']['starttime']);
				$endTime = strtotime($getStaffPlanAnaesthesiaVal['StaffPlan']['endtime']);
				if($getPostValStartTime >= $startTime && $getPostValEndTime <= $endTime) {
					$checkOverlapTime['anaesthesia'] = 2;
				}
				if($getPostValStartTime <= $startTime && $getPostValEndTime >= $endTime) {
					$checkOverlapTime['anaesthesia'] = 2;
				}
				if($getPostValStartTime <= $startTime && $getPostValEndTime <= $endTime && !($getPostValEndTime <= $startTime)) {
					$checkOverlapTime['anaesthesia'] = 2;
				}
				if($getPostValStartTime >= $startTime && !($getPostValStartTime >= $endTime)  && $getPostValEndTime >= $endTime) {
					$checkOverlapTime['anaesthesia'] = 2;
				}
			}

		}

		// check if appointment is exist for doctor //
		/**
		*commented by gaurav .. OT has nothing to do with OPD Appointment
		*/
		/*$appointment = Classregistry::init('Appointment');
		$getAppointment = $appointment->find('all', array('conditions' => array('Appointment.doctor_id' => $allVar['doctor_id'],'Appointment.date'=>$scheduleDateStart[0],
		'Appointment.is_deleted' => 0), 'recursive' => -1));

		$checkOverlapTime['surgeon_appointment'] = 1;
		foreach($getAppointment as $getAppointmentVal) {
			if($getAppointmentVal['Appointment']['start_time'] != "" || $getAppointmentVal['Appointment']['start_time'] != null || $getAppointmentVal['Appointment']['end_time'] != "" || $getAppointmentVal['Appointment']['end_time'] != null) {
				$startAppDateTime = $getAppointmentVal['Appointment']['date']." ".$getAppointmentVal['Appointment']['start_time'];
				$endAppDateTime = $getAppointmentVal['Appointment']['date']." ".$getAppointmentVal['Appointment']['end_time'];
				$startTime = strtotime($startAppDateTime);
				$endTime = strtotime($endAppDateTime);

				if($getPostValStartTime >= $startTime && $getPostValEndTime <= $endTime) {
					$checkOverlapTime['surgeon_appointment'] = 2;
				}
				if($getPostValStartTime <= $startTime && $getPostValEndTime >= $endTime) {
					$checkOverlapTime['surgeon_appointment'] = 2;
				}
				if($getPostValStartTime <= $startTime && $getPostValEndTime <= $endTime && !($getPostValEndTime <= $startTime)) {
					$checkOverlapTime['surgeon_appointment'] = 2;
				}
				if($getPostValStartTime >= $startTime && !($getPostValStartTime >= $endTime)  && $getPostValEndTime >= $endTime) {
					$checkOverlapTime['surgeon_appointment'] = 2;
				}
			}
		}*/

		// check if appointment is exist for anaesthesia //
		/**
		*commented by gaurav .. OT has nothing to do with OPD Appointment
		*/
		/*$appointment = Classregistry::init('Appointment');
		$getAppointment = $appointment->find('all', array('conditions' => array('Appointment.doctor_id' => $allVar['department_id'],'Appointment.date'=>$scheduleDateStart[0],
		'Appointment.is_deleted' => 0), 'recursive' => -1));

		$checkOverlapTime['anaesthesia_appointment'] = 1;
		foreach($getAppointment as $getAppointmentVal) {
			if($getAppointmentVal['Appointment']['start_time'] != "" || $getAppointmentVal['Appointment']['start_time'] != null || $getAppointmentVal['Appointment']['end_time'] != "" || $getAppointmentVal['Appointment']['end_time'] != null) {
					
				$startAppDateTime = $getAppointmentVal['Appointment']['date']." ".$getAppointmentVal['Appointment']['start_time'];
				$endAppDateTime = $getAppointmentVal['Appointment']['date']." ".$getAppointmentVal['Appointment']['end_time'];
				$startTime = strtotime($startAppDateTime);
				$endTime = strtotime($endAppDateTime);

				if($getPostValStartTime >= $startTime && $getPostValEndTime <= $endTime) {
					$checkOverlapTime['anaesthesia_appointment'] = 2;
				}
				if($getPostValStartTime <= $startTime && $getPostValEndTime >= $endTime) {
					$checkOverlapTime['anaesthesia_appointment'] = 2;
				}
				if($getPostValStartTime <= $startTime && $getPostValEndTime <= $endTime && !($getPostValEndTime <= $startTime)) {
					$checkOverlapTime['anaesthesia_appointment'] = 2;
				}
				if($getPostValStartTime >= $startTime && !($getPostValStartTime >= $endTime)  && $getPostValEndTime >= $endTime) {
					$checkOverlapTime['anaesthesia_appointment'] = 2;
				}
			}
		}*/

		return $checkOverlapTime;
	}

	/**
	 * check staff plan overlapping time for OT with new calendar(wdcalendar)
	 *
	 **/

	public function checkOverlapForStaffPlan($getIdValue=null, $getStValue=null, $getEtValue=null, $allVar=null) {
		$checkOverlapTime = array();
		$getPostValStartTime = strtotime($getStValue);
		$getPostValEndTime = strtotime($getEtValue);

		// check for doctor is already OT appointment or not //
		$optappointment = Classregistry::init('OptAppointment');
		$getSurgeonAppointment = $optappointment->find('all', array('conditions' => array('OR' => array('OptAppointment.doctor_id' => $allVar['user_id'],'OptAppointment.department_id' => $allVar['user_id'] ), 'OptAppointment.is_deleted' => 0), 'recursive' => -1));

		$checkOverlapTime['otappointmentoverlap'] = 1;
		foreach($getSurgeonAppointment as $getSurgeonAppointmentVal) {
			if($getSurgeonAppointmentVal['OptAppointment']['starttime'] != "" || $getSurgeonAppointmentVal['OptAppointment']['starttime'] != null || $getSurgeonAppointmentVal['OptAppointment']['endtime'] != "" || $getSurgeonAppointmentVal['OptAppointment']['endtime'] != null) {
					
				$startTime = strtotime($getSurgeonAppointmentVal['OptAppointment']['starttime']);
				$endTime = strtotime($getSurgeonAppointmentVal['OptAppointment']['endtime']);

				if($getPostValStartTime >= $startTime && $getPostValEndTime <= $endTime) {
					$checkOverlapTime['otappointmentoverlap'] = 2;
				}
				if($getPostValStartTime <= $startTime && $getPostValEndTime >= $endTime) {
					$checkOverlapTime['otappointmentoverlap'] = 2;
				}
				if($getPostValStartTime <= $startTime && $getPostValEndTime <= $endTime && !($getPostValEndTime <= $startTime)) {
					$checkOverlapTime['otappointmentoverlap'] = 2;
				}
				if($getPostValStartTime >= $startTime && !($getPostValStartTime >= $endTime)  && $getPostValEndTime >= $endTime) {
					$checkOverlapTime['otappointmentoverlap'] = 2;
				}
			}
		}

		// check staff plan overlapping itself //
		$staffplan = Classregistry::init('StaffPlan');
		$getStaffPlanSurgeon = $staffplan->find('all', array('conditions' => array('StaffPlan.user_id' => $allVar['user_id'], 'StaffPlan.is_deleted' => 0, 'StaffPlan.id <>' => $getIdValue), 'recursive' => -1));
		$checkOverlapTime['leaveoverlap'] = 1;

		foreach($getStaffPlanSurgeon as $getStaffPlanSurgeonVal) {
			if($getStaffPlanSurgeonVal['StaffPlan']['starttime'] != "" && $getStaffPlanSurgeonVal['StaffPlan']['starttime'] != null && $getStaffPlanSurgeonVal['StaffPlan']['endtime'] != "" && $getStaffPlanSurgeonVal['StaffPlan']['endtime'] != null) {
				$startTime = strtotime($getStaffPlanSurgeonVal['StaffPlan']['starttime']);
				$endTime = strtotime($getStaffPlanSurgeonVal['StaffPlan']['endtime']);
				if($getPostValStartTime >= $startTime && $getPostValEndTime <= $endTime) {
					$checkOverlapTime['leaveoverlap'] = 2;
				}
				if($getPostValStartTime <= $startTime && $getPostValEndTime >= $endTime) {
					$checkOverlapTime['leaveoverlap'] = 2;
				}
				if($getPostValStartTime <= $startTime && $getPostValEndTime <= $endTime && !($getPostValEndTime <= $startTime)) {
					$checkOverlapTime['leaveoverlap'] = 2;
				}
				if($getPostValStartTime >= $startTime && !($getPostValStartTime >= $endTime)  && $getPostValEndTime >= $endTime) {
					$checkOverlapTime['leaveoverlap'] = 2;
				}
			}
		}

		// check for doctor is already appointment or not //
		$appointment = Classregistry::init('Appointment');
		$getSurgeonAppointment = $appointment->find('all', array('conditions' => array('Appointment.doctor_id' => $allVar['user_id'], 'Appointment.is_deleted' => 0), 'recursive' => -1));

		$checkOverlapTime['appointmentoverlap'] = 1;
		foreach($getSurgeonAppointment as $getSurgeonAppointmentVal) {
			if($getSurgeonAppointmentVal['Appointment']['start_time'] != "" || $getSurgeonAppointmentVal['Appointment']['start_time'] != null || $getSurgeonAppointmentVal['Appointment']['end_time'] != "" || $getSurgeonAppointmentVal['Appointment']['end_time'] != null) {
				$startAppDateTime = $getSurgeonAppointmentVal['Appointment']['date']." ".$getSurgeonAppointmentVal['Appointment']['start_time'];
				$endAppDateTime = $getSurgeonAppointmentVal['Appointment']['date']." ".$getSurgeonAppointmentVal['Appointment']['end_time'];
				$startTime = strtotime($startAppDateTime);
				$endTime = strtotime($endAppDateTime);
					
				if($getPostValStartTime >= $startTime && $getPostValEndTime <= $endTime) {
					$checkOverlapTime['appointmentoverlap'] = 2;
				}
				if($getPostValStartTime <= $startTime && $getPostValEndTime >= $endTime) {
					$checkOverlapTime['appointmentoverlap'] = 2;
				}
				if($getPostValStartTime <= $startTime && $getPostValEndTime <= $endTime && !($getPostValEndTime <= $startTime)) {
					$checkOverlapTime['appointmentoverlap'] = 2;
				}
				if($getPostValStartTime >= $startTime && !($getPostValStartTime >= $endTime)  && $getPostValEndTime >= $endTime) {
					$checkOverlapTime['appointmentoverlap'] = 2;
				}
			}
		}

		return $checkOverlapTime;
	}

	/**
	 * CheckExistingBlockTime to decide update or add event for doctor_chambers
	 * @param array $blockData
	 * @author gaurav Chauriya
	 */
	function CheckOverlapBlockTime($blockData = array()){

		$doctorChamber = Classregistry::init('DoctorChamber');
		$doctorProfile = Classregistry::init('DoctorProfile');
		$scheduleDate = explode(' ',DateFormatComponent::formatDate2STD($blockData['scheduledate'],Configure::read('date_format')));
		$getChamber = $doctorChamber->find('all', array('fields'=>array('start_time','end_time','is_blocked'),
				'conditions' => array('DATE_FORMAT(starttime, "%Y-%m-%d")' => $scheduleDate['0'],
						'DoctorChamber.doctor_id' => $blockData['appointment_with'], 'DoctorChamber.is_deleted' => 0)));
		$getProfile = $doctorProfile->find('first', array('fields'=>array('starthours','endhours','doctor_name'),
				'conditions' => array('DoctorProfile.user_id' => $blockData['appointment_with'],'DoctorProfile.is_deleted' => 0,'DoctorProfile.is_active'=> 1)));
		$overlapTime = false;
		$scheduleStartTime = strtotime($blockData['schedule_starttime']);
		$scheduleEndTime = strtotime($blockData['schedule_endtime']);
		foreach($getChamber as $getChamberVal) {
			if($getChamberVal['DoctorChamber']['is_blocked']){
				$startTime = strtotime($getChamberVal['DoctorChamber']['start_time']);
				$endTime = strtotime($getChamberVal['DoctorChamber']['end_time']);

				if($scheduleStartTime >= $startTime && $scheduleEndTime <= $endTime) {
					$overlapTime = true;
				}
				if($scheduleStartTime <= $startTime && $scheduleEndTime >= $endTime) {
					$overlapTime = true;
				}
				if($scheduleStartTime <= $startTime && $scheduleEndTime <= $endTime && !($scheduleEndTime <= $startTime)) {
					$overlapTime = true;
				}
				if($scheduleStartTime >= $startTime && !($scheduleStartTime >= $endTime)  && $scheduleEndTime >= $endTime) {
					$overlapTime = true;
				}
			}
		}
		/** DoctorProfile busy hour checking*/
		$configStartHours = Configure::read('calendar_start_time');
		$startHours = ($getProfile['DoctorProfile']['starthours']) ? $getProfile['DoctorProfile']['starthours'] : $configStartHours.':00';
		$BlockStartHours = strtotime($scheduleDate['0'].' '.$startHours);
		$startAppt = strtotime($scheduleDate['0'].' '.$blockData['schedule_starttime']);

		$configEndHours = Configure::read('calendar_end_time');
		$endStartHours = ($getProfile['DoctorProfile']['endhours']) ? $getProfile['DoctorProfile']['endhours'] : $configEndHours.':00';
		$BlockEndHours = strtotime($scheduleDate['0'].' '.$endStartHours);
		$endAppt = strtotime($scheduleDate['0'].' '.$blockData['schedule_endtime']);

		if($startAppt < $BlockStartHours){
			$overlapTime = true;
		}
		if($startAppt > $BlockEndHours){
			$overlapTime = true;
		}
		if($endAppt > $BlockEndHours){
			$overlapTime = true;
		}

		return $overlapTime;
	}

	public function getInvalidateOtTime($allvar){
		$scheduleDate = DateFormatComponent::formatDate2STD($allvar['stpartdate'],'mm/dd/yyyy');
		$scheduleDateTime =  explode(" ", $scheduleDate);
		$scheduleDateTime = trim($scheduleDateTime[0])." ".trim($allvar['stparttime']);
		
		if($allvar['ot_in_date']) {
			$allvar['ot_in_date'] =  DateFormatComponent::formatDate2STD($allvar['ot_in_date'],'mm/dd/yyyy');
			$allvar['ot_in_date'] = explode(" ", $allvar['ot_in_date']);
			$otInDate = trim($allvar['ot_in_date'][0])." ".trim($allvar['otintime']);
		}
		if($allvar['incision_date']) {
			$allvar['incision_date'] =  DateFormatComponent::formatDate2STD($allvar['incision_date'],'mm/dd/yyyy');
			$allvar['incision_date'] = explode(" ", $allvar['incision_date']);
			$incisionDate = trim($allvar['incision_date'][0])." ".trim($allvar['incisiontime']);
		}
		if($allvar['skin_closure_date']) {
			$allvar['skin_closure_date'] =  DateFormatComponent::formatDate2STD($allvar['skin_closure_date'],'mm/dd/yyyy');
			$allvar['skin_closure_date'] = explode(" ", $allvar['skin_closure_date']);
			$skinClosureDate = trim($allvar['skin_closure_date'][0])." ".trim($allvar['skinclosure']);
		}
		if($allvar['out_date']) {
			$allvar['out_date'] =  DateFormatComponent::formatDate2STD($allvar['out_date'],'mm/dd/yyyy');
			$allvar['out_date'] = explode(" ", $allvar['out_date']);
			$outDate = trim($allvar['out_date'][0])." ".trim($allvar['outtime']);
		}
		
		if($otInDate > $outDate)
			$otTime['Msg'] = "Ot In Date & Time Should Not Be Greater Than Out Time";
		//if($otInDate == $outDate && $allvar['procedurecomplete'] == 1 )
	//		$otTime['Msg'] = "Ot In Date & Time Should Not Be Equal To Out Time";
		//else 
		if($incisionDate > $skinClosureDate)
			$otTime['Msg'] = "Incision Date & Time Should Not Be Greater Than Skin Closure Time";
		else if($incisionDate > $outDate)
			$otTime['Msg'] = "Incision Date & Time Should Not Be Greater Than Ot Out Time";
		else if($incisionDate > $skinClosureDate)
			$otTime['Msg'] = "Incision Date & Time Should Not Be Greater Than Skin Closure Time";
		else if($skinClosureDate > $outDate)
			$otTime['Msg'] = "Skin Closure Date & Time Should Not Be Greater Than Ot Out Time";
		/*if($otInDate < $scheduleDateTime && $otInDate)
			$otTime['Msg'] = "Ot In Date & Time Should Not Be Less Than Schedule Time";*/
		
		$otTime['isInvalidate'] = ($otTime['Msg']) ? true : false;
		return $otTime;
	}

}