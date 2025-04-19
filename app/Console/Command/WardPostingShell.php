<?php
/**
 * WardPosting file
 *
 * PHP 5
 * 
 *
 * @copyright     Copyright 2015 drmhope Inc.  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       ScheduleJobsShell
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pankaj Wanjari
 */
App::uses ( 'ConnectionManager', 'Model' );
App::uses ( 'AppModel', 'Model' );
App::uses ( 'Component', 'Controller' );

App::uses ( 'WardPatient', 'Model' );
App::uses ( 'OptAppointment', 'Model' );
App::uses ( 'Location', 'Model' );
App::uses ( 'TariffList', 'Model' );
App::uses ( 'Surgery', 'Model' );
App::uses ( 'User', 'Model' );
App::uses ( 'Initial', 'Model' );
// App::uses('Anaesthesist', 'Model');
App::uses ( 'DoctorProfile', 'Model' );
App::uses ( 'TariffAmount', 'Model' );

App::uses ( 'Patient', 'Model' );
App::uses ( 'WardPatientService', 'Model' );
App::uses ( 'ServiceCategory', 'Model' );
App::uses ( 'DateFormatComponent', 'Controller/Component' );
App::uses ( 'ServiceSubCategory', 'Model' );
App::uses ( 'CakeSession', 'Model/Datasource' );

App::uses ( 'Surgeon', 'Model' );
App::uses ( 'User', 'Model' );
App::uses ( 'Ward', 'Model' );

error_reporting ( ~ E_NOTICE && ~ E_WARNING );
class WardPostingShell extends AppShell {
	public $wards = array ();
	public $hospitalType = '';
	public function main() { 
		$this->postWardUnits (); 
	}
	
	// bof pankaj for ward posting
	// function to post daily ward units by pankaj w
	function postWardUnits() {
		// $dataSource = ConnectionManager::getDataSource('default');
		$dbconfig = ConnectionManager::getDataSource ( 'defaultHospital' )->config;
		$this->database = $dbconfig ['database'];
		// for daily room charges
		$locationModel = new Location ( null, null, $this->database );
		$locationModel->unBindModel ( array (
				'belongsTo' => array (
						'City',
						'State',
						'Country' 
				) 
		) );
		$patientModel = new Patient ( null, null, $this->database );
		$WardPatientServiceModel = new WardPatientService ( null, null, $this->database );
		$serviceModel = new ServiceCategory ( null, null, $this->database );
		$serviceSubCategoryModel = new ServiceSubCategory ( null, null, $this->database );
		
		$dateFormatComponent = new DateFormatComponent ( new ComponentCollection () );
		$cakeSessionObj = new CakeSession ();
		$this->getWardList (); // set ward list
		$locations = $locationModel->find ( 'all', array (
				'fields' => array (
						'id',
						'name',
						'accreditation' 
				),
				'conditions' => array (
						'Location.is_active' => 1,
						'Location.is_deleted' => 0 
				) 
		) );
		
		foreach ( $locations as $locationKey => $locationsVal ) {
			$cakeSessionObj->write ( 'locationid', $locationsVal ['Location'] ['id'] ); // write location id in sessino to use for normal function added in models
			$serviceCategoryId = $serviceModel->getServiceGroupId ( 'RoomTariff', $locationsVal ['Location'] ['id'] ); // find room tariff service category
			$patientModel->recursive = 0;
			$patients = $patientModel->find ( 'all', array (
					'fields' => array (
							'Patient.id',
							'Patient.tariff_standard_id',
							'Patient.lookup_name' 
					),
					'conditions' => array (
							'Patient.admission_type' => 'IPD',
							'Patient.is_discharge' => 0,
							'Patient.location_id' => $locationsVal ['Location'] ['id'],
							'Patient.is_deleted' => 0  							 
					) 
			) ); // BOF collecting checkout hrs
			$config_hrs = $this->getCheckoutTime ();
			// EOD collecting hrs
			$this->hospitalType = $locationsVal ['Location'] ['accreditation'];
			foreach ( $patients as $patientKey => $patientVal ) {
				$roomTariff = $this->getDay2DayCharges ( $patientVal ['Patient'] ['id'], $patientVal ['Patient'] ['tariff_standard_id'], false, $locationsVal ['Location'] ['id'], $config_hrs, $locationsVal ['Location'] ['accreditation'] );
				// extra element add for testinf purpose
				$roomTariff ['Patient'] ['name'] = $patientVal ['Patient'] ['lookup_name'];
				// echo $patientVal['Patient']['id']."\n" ;
				// delete already added service for ward
				// check for current day service if added previous by chance
				$WardPatientServiceModel->deleteAll ( array (
						'WardPatientService.patient_id' => $patientVal ['Patient'] ['id'],
						'DATE_FORMAT(WardPatientService.date,"%Y-%m-%d")' => date ( 'Y-m-d' ) 
				) );
				
				if (is_array ( $roomTariff )) {
					foreach ( $roomTariff ['day'] as $key => $value ) {
						// split date time
						$splittedInTime = explode ( " ", $value ['in'] ); 
						// if(strtotime($splittedInTime[0])==strtotime(date('d-m-Y',strtotime('Yesterday')))){//for today only
						if (strtotime ( $splittedInTime [0] ) == strtotime ( date ( 'd-m-Y' ) )) { // for today only
							/**
							 * *******************************************************
							 */
							// check if patient is corporate post their charges according to class from admission data
							$patientCorporateClassCharges = false;							
							if ($patientVal ['Patient'] ['tariff_standard_id'] != 7) { // if patient is not private
								$patientCorporateClassCharges = $this->getCorporateClassWard ( $patientVal ['Patient'] ['id'], $value ['ward_id'] );
							}
							/**
							 * ******************************************************
							 */
							
							$insertArray [] = array (
									'date' => $dateFormatComponent->formatDate2STD ( $splittedInTime [0], Configure::read ( 'date_format' ) ),
									'location_id' => $locationsVal ['Location'] ['id'],
									'tariff_standard_id' => $patientVal ['Patient'] ['tariff_standard_id'], // no need to add this
									'create_time' => date ( 'Y-m-d H:i:s' ),
									'created_by' => 2, // as system user
									'patient_id' => $patientVal ['Patient'] ['id'],
									'tariff_list_id' => $value ['service_id'],
									'amount' =>  ($patientCorporateClassCharges)?$patientCorporateClassCharges:$value ['cost'],
									'ward_id' => $value ['ward_id'],
									'service_id' => $serviceCategoryId 
							) // service group id
;
							 
						}
					} // EOF roomtariff foreach
				} // EOF IF
				$collectAllPatientData [] = $roomTariff;
				$roomTariff = '';
			} // EOF patient foreach
		}
		if ($insertArray) {
			$WardPatientServiceModel->saveAll ( $insertArray );
			$WardPatientServiceModel->id = '';
		}
	}
	function getDay2DayCharges($id = null, $tariffStandardId = null, $applyPackageCondition = false, $location_id = null, $config_hrs = null, $hospitalType = null) {
		// spl_autoload_register(array('App','load')) ;
		$locationModel = new Location ( null, null, $this->database );
		$wardPatientModel = new WardPatient ( null, null, $this->database );
		$optAppointmentModel = new OptAppointment ( null, null, $this->database );
		
		$tariffModelModel = new TariffList ( null, null, $this->database );
		$surgeryModel = new Surgery ( null, null, $this->database );
		$optAppointmentModel = new OptAppointment ( null, null, $this->database );
		
		$locationModel = new Location ( null, null, $this->database );
		// $wardPatientModel = new Anaesthesist(null,null,$this->database);
		$doctorProfileModel = new DoctorProfile ( null, null, $this->database );
		$tariffAmountModel = new TariffAmount ( null, null, $this->database );
		$userModel = new User ( null, null, $this->database );
		$userModel = new Ward ( null, null, $this->database );
		$dateFormatComponent = new DateFormatComponent ( new ComponentCollection () );
		
		// making sergery array
		$optAppointmentModel->unbindModel ( array (
				'belongsTo' => array (
						'Initial',
						'Patient',
						'Location',
						'Opt',
						'OptTable',
						'Surgery',
						'SurgerySubcategory',
						'Doctor',
						'DoctorProfile' 
				) 
		) );
		$optAppointmentModel->bindModel ( array (
				'belongsTo' => array (
						'TariffList' => array (
								'foreignKey' => 'tariff_list_id',
								'type' => 'LEFT',
								'conditions' => array (
										'TariffList.is_deleted' => 0 
								) 
						),
						'DoctorProfile' => array (
								'className' => 'DoctorProfile',
								'foreignKey' => false,
								'type' => 'LEFT',
								'conditions' => array (
										'DoctorProfile.user_id=OptAppointment.doctor_id' 
								) 
						),
						'TariffAmount' => array (
								'foreignKey' => false,
								'conditions' => array (
										'TariffAmount.tariff_list_id=OptAppointment.tariff_list_id',
										'TariffAmount.tariff_standard_id' => $tariffStandardId 
								) 
						),
						'Surgery' => array (
								'foreignKey' => 'surgery_id' 
						) 
				) 
		)
		 );
		
		$surgery_Data = $optAppointmentModel->find ( 'all', array (
				'conditions' => array(/*'OptAppointment.location_id'=>$locationKey,*/
						'OptAppointment.is_deleted' => 0,
						'OptAppointment.patient_id' => $id,
						'OptAppointment.is_false_appointment' => 0 
				),
				/**
				 * is_false_appointment == 0 means non packaged ot
				 */
				'fields' => array (
						"OptAppointment.*",
						'DoctorProfile.doctor_name',
						'TariffList.*',
						'TariffAmount.*' 
				),
				'order' => 'OptAppointment.schedule_date Asc',
				'group' => 'OptAppointment.id',
				'recursive' => 1 
		) );
		/**
		 * ******************** Surgery Data Starts *****************************
		 */
		if ($hospitalType == 'NABH') {
			$chargeType = 'nabh_charges';
		} else {
			$chargeType = 'non_nabh_charges';
		}
		$surgeries = array ();
		foreach ( $surgery_Data as $uniqueSurgery ) {
			// convert date to local format
			$sugeryDate = $dateFormatComponent->formatDate2Local ( $uniqueSurgery ['OptAppointment'] ['starttime'], 'yyyy-mm-dd', true );
			$sugeryEndDate = $dateFormatComponent->formatDate2Local ( $uniqueSurgery ['OptAppointment'] ['endtime'], 'yyyy-mm-dd', true );
			$surgeries [] = array (
					'name' => $uniqueSurgery ['Surgery'] ['name'],
					'surgeryScheduleDate' => $sugeryDate,
					'surgeryScheduleEndDate' => $sugeryEndDate,
					/* 'surgeryAmount'=>$uniqueSurgery['TariffAmount'][$chargeType], */
					'surgeryAmount' => $uniqueSurgery ['OptAppointment'] ['surgery_cost'],
					'unitDays' => $uniqueSurgery ['TariffAmount'] ['unit_days'],
					'cghs_nabh' => $uniqueSurgery ['TariffList'] ['cghs_nabh'],
					'cghs_non_nabh' => $uniqueSurgery ['TariffList'] ['cghs_non_nabh'],
					'cghs_code' => $uniqueSurgery ['TariffList'] ['cghs_code'],
					'moa_sr_no' => $uniqueSurgery ['TariffAmount'] ['moa_sr_no'],
					'doctor' => $uniqueSurgery ['Initial'] ['name'] . $uniqueSurgery ['Surgeon'] ['doctor_name'],
					'doctor_education' => $uniqueSurgery ['Surgeon'] ['education'],
					'anaesthesist' => $uniqueSurgery ['AnaeInitial'] ['name'] . $uniqueSurgery ['Anaesthesist'] ['doctor_name'],
					'anaesthesist_education' => $uniqueSurgery ['Anaesthesist'] ['education'],
					'anaesthesist_cost' => $uniqueSurgery ['OptAppointment'] ['anaesthesia_cost'],
					'ot_charges' => $uniqueSurgery ['OptAppointment'] ['ot_charges'] 
			)
			;
		}
		// EOF making serugery array
		if (empty ( $location_id )) {
			$location_id = $locationKey;
		}
		
		$wardPatientModel->bindModel ( array (
				'belongsTo' => array (
						'Ward' => array (
								'foreignKey' => 'ward_id' 
						),
						'TariffAmount' => array (
								'foreignKey' => false,
								'conditions' => array (
										'Ward.tariff_list_id=TariffAmount.tariff_list_id',
										'TariffAmount.tariff_standard_id' => $tariffStandardId 
								) 
						),
						'TariffList' => array (
								'foreignKey' => false,
								'conditions' => array (
										'TariffAmount.tariff_list_id=TariffList.id' 
								) 
						) 
				) 
		), false );
		$wardData = $wardPatientModel->find ( 'all', array (
				'group' => array (
						'WardPatient.id' 
				),
				'conditions' => array (
						'patient_id' => $id,/*'WardPatient.location_id'=>$location_id,*/'WardPatient.is_deleted' => '0' 
				),
				'fields' => array (
						'WardPatient.*',
						'TariffList.id',
						'TariffList.cghs_code,TariffAmount.moa_sr_no,TariffAmount.nabh_charges,
						TariffAmount.non_nabh_charges,TariffAmount.unit_days',
						'Ward.name',
						'Ward.id' 
				) 
		) );
		// array walk of ward Detail
		$dayArr = array ();
		$wardDayCount = 0;
		$calDays = $this->calculateWardDays ( $wardData, $surgeries, $config_hrs, $hospitalType );
		$dayArr = $calDays ['dayArr'];
		$surgeryDays = $calDays ['surgeryData'];
		$daysBeforeAfterSurgeries = array ();
		$j = 0;
		if (! empty ( $surgeryDays ['sugeryValidity'] )) {
			foreach ( $dayArr ['day'] as $dayArrKey => $daySubArr ) {
				$last = end ( $daysBeforeAfterSurgeries );
				$splitDaySubArr = explode ( " ", $daySubArr ['out'] );
				foreach ( $surgeryDays ['sugeryValidity'] as $key => $value ) {
					$surgeryStartDate = explode ( " ", $value ['start'] );
					$surgeryEndDate = explode ( " ", $value ['end'] );
					if ($value ['validity'] > 1) { // for surgery package days greater than 1
						$reducedByOneDay = $surgeryStartDate [0];
						for($v = 0; $v < $value ['validity']; $v ++) {
							if (strtotime ( $splitDaySubArr [1] ) <= strtotime ( $surgeryStartDate [1] )) {
								$dayArrKeyIncreased = $dayArrKey + 1;
							} else {
								$dayArrKeyIncreased = $dayArrKey;
							}
							if (strtotime ( $splitDaySubArr [0] ) == strtotime ( $reducedByOneDay . "+$v Days" )) {
								if (! isset ( $surgeryDays ['sugeryValidity'] [$key] ['start'] )) {
									$surgeryDays ['sugeryValidity'] [$key] ['start'] = $dayArr ['day'] [$dayArrKey] ['in'];
								}
								unset ( $dayArr ['day'] [$dayArrKeyIncreased] );
							}
						}
						// EOF loop
					}
				}
				$j ++;
			}
		}
		/*
		 * if(is_array($dayArr['day']) && !empty($dayArr['day'])){
		 * $lastDay = end($dayArr['day']) ;
		 * foreach($dayArr['day'] as $dayArrKey =>$daySubArr){
		 *
		 * if($f<=count($dayArr['day'])){
		 *
		 * //For multiple surgeries for single day(charges)
		 * if((count($dayArr['day'])==1) && (is_array($surgeryDays['sugeryValidity']))){
		 * $combo[] = $daySubArr ;
		 * foreach($surgeryDays['sugeryValidity'] as $surgeryKey){
		 * $combo[] = $surgeryKey ;
		 * }
		 * }else{
		 * if($f ==0)$combo[] = $daySubArr ;
		 * //EOF multiple surgery
		 * $splitDaySubArr = explode(" ",$daySubArr['out']);
		 * //to insert surgeries between ward days
		 * foreach($surgeryDays['sugeryValidity'] as $surgeryKey=> $surgeryValue){
		 * if(strtotime($splitDaySubArr[0]." ".$config_hrs) > strtotime($surgeryValue['start'])
		 * || (
		 * (strtotime($lastDay['out']) <= strtotime($surgeryValue['start'])) &&
		 * (strtotime(date('Y-m-d H:i:s'))>=strtotime($surgeryValue['start'])) &&
		 * ($daySubArr['out'] == $lastDay['out'])
		 * )
		 * ){
		 * $combo[] = $surgeryValue ; //for single surgery
		 * //unset added surgery
		 *
		 * //unset($dayArr['day'][$dayArrKey]);
		 * unset($surgeryDays['sugeryValidity'][$surgeryKey]);
		 * }
		 * }
		 * if($f >0 && !empty($dayArr['day'][$dayArrKey])) $combo[] = $dayArr['day'][$dayArrKey] ;
		 *
		 * }
		 * $f++;
		 * }else{
		 * $combo[] = $daySubArr ;
		 * }
		 * }
		 * }
		 */
		// commented becuase 5:30 hours added already in above logic
		foreach ( $dayArr ['day'] as $dayKey => $singleDay ) {
			if (! empty ( $singleDay ['in'] )) {
				$dayArr ['day'] [$dayKey] ['in'] = $dateFormatComponent->formatDate2STD ( $singleDay ['in'], Configure::read ( 'date_format' ) );
			}
			if (! empty ( $singleDay ['out'] )) {
				$dayArr ['day'] [$dayKey] ['out'] = $dateFormatComponent->formatDate2STD ( $singleDay ['out'], Configure::read ( 'date_format' ) );
			}
		}
		return $dayArr;
	}
	
	// function to calculate ward days
	// by pankaj
	function calculateWardDays($wardData = array(), $surgeries = array(), $config_hrs, $hospitalType) {
		$dateFormatComponentModel = new DateFormatComponent ( new ComponentCollection () );
		foreach ( $wardData as $wardKey => $wardValue ) {
			// Date Converting to Local b4 calculation
			if (! empty ( $wardValue ['WardPatient'] ['in_date'] )) {
				$wardValue ['WardPatient'] ['in_date'] = $dateFormatComponentModel->formatDate2Local ( $wardValue ['WardPatient'] ['in_date'], 'yyyy-mm-dd', true );
			}
			if (! empty ( $wardValue ['WardPatient'] ['out_date'] )) {
				$wardValue ['WardPatient'] ['out_date'] = $dateFormatComponentModel->formatDate2Local ( $wardValue ['WardPatient'] ['out_date'], 'yyyy-mm-dd', true );
			}
			$currDateUTC = $dateFormatComponentModel->formatDate2Local ( date ( 'Y-m-d H:i:s' ), 'yyyy-mm-dd', true );
			// EOF date change
			// Bed cost
			
			if ($hospitalType == 'NABH') {
				$charge = ( int ) $wardValue ['TariffAmount'] ['nabh_charges'];
			} else {
				$charge = ( int ) $wardValue ['TariffAmount'] ['non_nabh_charges'];
			}
			// EOF bed cost
			$surgeryDays = $this->getSurgeryArray ( $surgeries, $wardValue ['WardPatient'] ['in_date'], $wardValue ['WardPatient'] ['out_date'], $config_hrs );
			$surgeryFirstDate = explode ( " ", $surgeryDays ['sugeryValidity'] [0] ['start'] );
			$lastKey = end ( $surgeryDays ['sugeryValidity'] );
			$surgeryLastDate = explode ( " ", $lastKey ['end'] );
			if (! empty ( $wardValue ['WardPatient'] ['out_date'] )) {
				$slpittedIn = explode ( " ", $wardValue ['WardPatient'] ['in_date'] );
				// if checkout timing is 24 hours then set time to default in time
				if ($config_hrs == '24 hours') {
					$config_hrs = $slpittedIn [1];
				}
				// EOF config check
				$slpittedOut = explode ( " ", $wardValue ['WardPatient'] ['out_date'] );
				$interval = $dateFormatComponentModel->dateDiff ( $slpittedIn [0], $slpittedOut [0] );
				
				$days = $interval->days; // to match with the date_diiff fucntion result as of 24hr day diff
				$hrInterval = $dateFormatComponentModel->dateDiff ( $wardValue ['WardPatient'] ['in_date'], $wardValue ['WardPatient'] ['out_date'] ); // for hr calculation
				if ($days > 0) {
					$dayArrCount = count ( $dayArr ['day'] );
					for($i = 0; $i <= $days; $i ++) {
						$nextDate = date ( 'Y-m-d H:i:s', strtotime ( $wardValue ['WardPatient'] ['in_date'] . $i . " days" ) );
						// Code to add one day before 10 AM
						$firstDate10 = date ( 'Y-m-d H:i:s', strtotime ( $slpittedIn [0] . " $config_hrs" ) );
						// check if the shift of ward is between 4 hours to avoid that ward charges
						if ($i != 0 && $hrInterval->h < 4 && $hrInterval->d == 0 && $hrInterval->m == 0 && $hrInterval->y == 0) {
							// $dayArr['day'][$dayArrCount-1]['out'] = $wardValue['WardPatient']['out_date'] ;
							// echo "line8474";
							continue; // no need maintain data below 4 hours
						}
						// to avoid if diff is less than 4 hours between closing time and in time
						$closingInterval = $dateFormatComponentModel->dateDiff ( $wardValue ['WardPatient'] ['in_date'], $firstDate10 ); // for hr calculation
						if ($i != 0 && $closingInterval->h < 4 && $closingInterval->d == 0 && $closingInterval->m == 0 && $closingInterval->y == 0) {
							
							// $dayArr['day'][$dayArrCount-1]['out'] = $wardValue['WardPatient']['out_date'];
							// echo "line8482"; //commneted for raju thakare
							// continue ; //no need maintain data below 4 hours
						}
						
						if ($i == 0 && strtotime ( $wardValue ['WardPatient'] ['in_date'] ) < strtotime ( $firstDate10 )) {
							/*
							 * $dayArr['day'][] = array('cghs_code'=>$wardValue['TariffList']['cghs_code'],
							 * 'cghs_nabh'=>$wardValue['TariffList']['cghs_nabh'],
							 * 'cghs_non_nabh'=>$wardValue['TariffList']['cghs_non_nabh'],
							 * 'moa_sr_no'=>$wardValue['TariffAmount']['moa_sr_no'],
							 * 'apply_in_a_day'=>$wardValue['TariffList']['apply_in_a_day'],
							 * "in"=>date('Y-m-d H:i:s',strtotime($slpittedIn[0].' -1 days '.$config_hrs)),
							 * "out"=>$firstDate10,'cost'=>$charge,'ward'=>$wardValue['Ward']['name']) ;
							 */
						}
						
						// checking for greater price of same day
						if (($dayArrCount > 0) && ($i == 0) && ($dayArr ['day'] [$dayArrCount - 1] ['out'] == $wardValue ['WardPatient'] ['in_date']) && ($hrInterval->h >= 4 || $hrInterval->d > 0)) {
							
							if ($dayArr ['day'] [$dayArrCount - 1] ['cost'] < $charge) {
								$dayArr ['day'] [$dayArrCount - 1] ['cost'] = $charge;
								$dayArr ['day'] [$dayArrCount - 1] ['ward'] = $wardValue ['Ward'] ['name'];
								$dayArr ['day'] [$dayArrCount - 1] ['ward_id'] = $wardValue ['Ward'] ['id'];
								$dayArr ['day'] [$dayArrCount - 1] ['service_id'] = $wardValue ['TariffList'] ['id'];
							}
							// echo "line8508";
							continue;
						}
						
						// EOF cost check
						
						if ((strtotime ( $nextDate ) >= strtotime ( $wardValue ['WardPatient'] ['out_date'] )) || ($i == $days)) {
							if ($i > 0) {
								$firstOutDate10 = date ( 'Y-m-d H:i:s', strtotime ( $slpittedOut [0] . " " . $config_hrs ) );
								// start of skip day if discharged b4 10 AM
								if (strtotime ( $wardValue ['WardPatient'] ['out_date'] ) < strtotime ( $firstOutDate10 )) {
									continue;
								}
								// end of skip day if discharged b4 10 AM
								$tempOutDate = strtotime ( $slpittedIn [0] . $i . " days $config_hrs" );
							} else {
								$tempOutDate = strtotime ( $wardValue ['WardPatient'] ['in_date'] );
							}
							
							// skip if hour diff is less than 4 hours
							// check for in n out time diff (if the diff less than 4 hours then skip this iteration)
							$inConvertedDate = date ( 'Y-m-d H:i:s', $tempOutDate );
							$outConvertedDate = $wardValue ['WardPatient'] ['out_date'];
							
							$shortTimeDiff = $dateFormatComponentModel->dateDiff ( $inConvertedDate, $outConvertedDate );
							
							// $i cond added for below example
							/**
							 * suppose admission on 22:00 and checkout timing is 00:00 then charges should be applied for that day
							 * but this is not true for ward shuffling added by pankaj
							 */
							
							if ($i != 0 && ($shortTimeDiff->h > 0 || $shortTimeDiff->i > 0) && $shortTimeDiff->h < 4 && $shortTimeDiff->d == 0 && $shortTimeDiff->m == 0 && $shortTimeDiff->y == 0) {
								// echo "line8541";
								continue;
							}
							// skip if hour diff is less than 4 hours
							
							$dayArr ['day'] [] = array (
									'cghs_code' => $wardValue ['TariffList'] ['cghs_code'],
									'moa_sr_no' => $wardValue ['TariffAmount'] ['moa_sr_no'],
									"in" => date ( 'Y-m-d H:i:s', $tempOutDate ),
									"out" => $wardValue ['WardPatient'] ['out_date'],
									'cost' => $charge,
									'ward' => $wardValue ['Ward'] ['name'],
									'ward_id' => $wardValue ['Ward'] ['id'],
									'service_id' => $wardValue ['TariffList'] ['id'] 
							);
						} else if ((strtotime ( $nextDate ) <= strtotime ( $wardValue ['WardPatient'] ['out_date'] ))) {
							
							if ($i == 0) {
								// if($days==1)
								$tempOutDate = strtotime ( $slpittedIn [0] . "1 days $config_hrs" );
								// else
								// $tempOutDate = strtotime($slpittedIn[0].$i." days $config_hrs");
							} else {
								$tempOutDate = strtotime ( $wardValue ['WardPatient'] ['in_date'] . $i . " days" );
							}
							
							// check for in n out time diff (if the diff less than 4 hours then skip this iteration)
							$inConvertedDate = date ( 'Y-m-d H:i:s', strtotime ( $wardValue ['WardPatient'] ['in_date'] . $i . " days" ) );
							$outConvertedDate = date ( 'Y-m-d H:i:s', $tempOutDate );
							
							// echo "<br/>";
							$shortTimeDiff = $dateFormatComponentModel->dateDiff ( $inConvertedDate, $outConvertedDate );
							
							// $i cond added for below example
							/**
							 * suppose admission on 22:00 and checkout timing is 00:00 then charges should be applied for that day
							 * but this is not true for ward shuffling added by pankaj
							 */
							
							if ($i != 0 && ($shortTimeDiff->h > 0 || $shortTimeDiff->i > 0) && $shortTimeDiff->h < 4 && $shortTimeDiff->d == 0 && $shortTimeDiff->m == 0 && $shortTimeDiff->y == 0) {
								// echo "line8574";
								continue;
							}
							
							$dayArr ['day'] [] = array (
									'cghs_code' => $wardValue ['TariffList'] ['cghs_code'],
									'moa_sr_no' => $wardValue ['TariffAmount'] ['moa_sr_no'],
									"in" => $inConvertedDate,
									"out" => $outConvertedDate,
									'cost' => $charge,
									'ward' => $wardValue ['Ward'] ['name'],
									'ward_id' => $wardValue ['Ward'] ['id'],
									'service_id' => $wardValue ['TariffList'] ['id'] 
							);
						}
					}
				} else if ($hrInterval->h >= 4) {
					$nextDate = date ( 'Y-m-d H:i:s', strtotime ( $wardValue ['WardPatient'] ['in_date'] ) );
					// checking for greater price of same day
					
					if (is_array ( $wardData [$wardKey + 1] )) {
						if ($hospitalType == 'NABH') {
							$nextCharge = ( int ) $wardData [$wardKey + 1] ['TariffAmount'] ['nabh_charges'];
						} else {
							$nextCharge = ( int ) $wardData [$wardKey + 1] ['TariffAmount'] ['non_nabh_charges'];
						}
						// check if the patient has stays more than 4hr our in next shifted ward
						$slpittedInForNext = explode ( " ", $wardData [$wardKey + 1] ['WardPatient'] ['in_date'] );
						if (! empty ( $wardData [$wardKey + 1] ['WardPatient'] ['out_date'] ))
							$slpittedOutForNext = explode ( " ", $wardData [$wardKey + 1] ['WardPatient'] ['out_date'] );
						else
							// $slpittedOutForNext = explode(" ",$currDateUTC) ;
							$slpittedOutForNext = explode ( " ", $wardValue ['WardPatient'] ['out_date'] );
						
						$intervaForNext = $dateFormatComponentModel->dateDiff ( $slpittedInForNext [0], $slpittedOutForNext [0] );
						if ($intervaForNext->days > 0 || $intervaForNext->h >= 4)
							if ($nextCharge > $charge)
								continue;
						// EOF check
					} // EOF cost check
					
					if (strtotime ( $nextDate ) > strtotime ( $wardValue ['WardPatient'] ['out_date'] )) {
						if (is_array ( $wardData [$wardKey + 1] )) {
							$dayArr ['day'] [] = array (
									'cghs_code' => $wardValue ['TariffList'] ['cghs_code'],
									'moa_sr_no' => $wardValue ['TariffAmount'] ['moa_sr_no'],
									"in" => $wardValue ['WardPatient'] ['in_date'],
									"out" => $wardData [$wardKey] ['WardPatient'] ['out_date'],
									'cost' => $charge,
									'ward' => $wardValue ['Ward'] ['name'],
									'ward_id' => $wardValue ['Ward'] ['id'],
									'service_id' => $wardValue ['TariffList'] ['id'] 
							);
						} else {
							$dayArr ['day'] [] = array (
									'cghs_code' => $wardValue ['TariffList'] ['cghs_code'],
									'moa_sr_no' => $wardValue ['TariffAmount'] ['moa_sr_no'],
									"in" => $wardValue ['WardPatient'] ['in_date'],
									"out" => $wardValue ['WardPatient'] ['out_date'],
									'cost' => $charge,
									'ward' => $wardValue ['Ward'] ['name'],
									'ward_id' => $wardValue ['Ward'] ['id'],
									'service_id' => $wardValue ['TariffList'] ['id'] 
							);
						}
					} else {
						$dayArr ['day'] [] = array (
								'cghs_code' => $wardValue ['TariffList'] ['cghs_code'],
								'moa_sr_no' => $wardValue ['TariffAmount'] ['moa_sr_no'],
								"in" => $wardValue ['WardPatient'] ['in_date'],
								"out" => date ( 'Y-m-d H:i:s', strtotime ( $wardValue ['WardPatient'] ['out_date'] ) ),
								'cost' => $charge,
								'ward' => $wardValue ['Ward'] ['name'],
								'ward_id' => $wardValue ['Ward'] ['id'],
								'service_id' => $wardValue ['TariffList'] ['id'] 
						);
					}
				} else {
					// if($hrInterval->h < 4) continue ; //to skip same day ward shifting charges for less than 4 hours
					// check out date should less than indate for dday 1 adminission
					$dayArrCountEX = count ( $dayArr ['day'] );
					// check if the shift of ward is between 4 hours to avoid that ward charges
					if ($hrInterval->h < 4 && $hrInterval->d == 0 && $hrInterval->m == 0 && $hrInterval->y == 0 && $i != 0) { // for first $i cond
						if ($dayArrCountEX > 0)
							$dayArr ['day'] [$dayArrCountEX - 1] ['out'] = $wardValue ['WardPatient'] ['out_date']; // to correct same day charge compare for makiing previous and currnt day n time
								                                                                                 // echo "test2";
						continue; // no need maintain data below 4 hours
					}
					
					if (($dayArr ['day'] [$dayArrCountEX - 1] ['out'] == $wardValue ['WardPatient'] ['in_date'])) {
						if ($dayArr ['day'] [$dayArrCountEX - 1] ['cost'] < $charge) {
							$dayArr ['day'] [$dayArrCountEX - 1] ['cost'] = $charge;
							$dayArr ['day'] [$dayArrCountEX - 1] ['ward'] = $wardValue ['Ward'] ['name'];
							$dayArr ['day'] [$dayArrCountEX - 1] ['ward_id'] = $wardValue ['Ward'] ['id'];
							$dayArr ['day'] [$dayArrCountEX - 1] ['service_id'] = $wardValue ['TariffList'] ['id'];
						}
						$dayArr ['day'] [$dayArrCountEX - 1] ['out'] = $wardValue ['WardPatient'] ['out_date']; // so that we can compare out and in date to skip charge for same day
						continue;
					}
					
					$dayArr ['day'] [] = array (
							'cghs_code' => $wardValue ['TariffList'] ['cghs_code'],
							'cghs_nabh' => $wardValue ['TariffList'] ['cghs_nabh'],
							'cghs_non_nabh' => $wardValue ['TariffList'] ['cghs_non_nabh'],
							'moa_sr_no' => $wardValue ['TariffAmount'] ['moa_sr_no'],
							'apply_in_a_day' => $wardValue ['TariffList'] ['apply_in_a_day'],
							"in" => $wardValue ['WardPatient'] ['in_date'], // started day from checkout hrs
							"out" => $wardValue ['WardPatient'] ['out_date'],
							'cost' => $charge,
							'ward' => $wardValue ['Ward'] ['name'],
							'ward_id' => $wardValue ['Ward'] ['id'],
							'service_id' => $wardValue ['TariffList'] ['id'] 
					);
				}
			} else {
				$slpittedIn = explode ( " ", $wardValue ['WardPatient'] ['in_date'] );
				// if checkout timing is 24 hours then set time to default in time
				if ($config_hrs == '24 hours') {
					$config_hrs = $slpittedIn [1];
				}
				// EOF config check
				$interval = $dateFormatComponentModel->dateDiff ( $slpittedIn [0], date ( 'Y-m-d' ) );
				$hrInterval = $dateFormatComponentModel->dateDiff ( $wardValue ['WardPatient'] ['in_date'], $currDateUTC ); // for hr calculation
				$days = $interval->days; // to match with the date_diiff fucntion result as of 24hr day diff
				$dayArrCount = count ( $dayArr ['day'] );
				$firstDate10 = date ( 'Y-m-d H:i:s', strtotime ( $slpittedIn [0] . " " . $config_hrs ) );
				
				if ($days > 0) {
					for($i = 0; $i <= $days; $i ++) {
						$nextDate = date ( 'Y-m-d H:i:s', strtotime ( $wardValue ['WardPatient'] ['in_date'] . $i . " days" ) );
						
						if ($i == 0 && strtotime ( $wardValue ['WardPatient'] ['in_date'] ) < strtotime ( $firstDate10 )) {
							$dayArr ['day'] [] = array (
									'cghs_code' => $wardValue ['TariffList'] ['cghs_code'],
									'cghs_nabh' => $wardValue ['TariffList'] ['cghs_nabh'],
									'cghs_non_nabh' => $wardValue ['TariffList'] ['cghs_non_nabh'],
									'moa_sr_no' => $wardValue ['TariffAmount'] ['moa_sr_no'],
									'apply_in_a_day' => $wardValue ['TariffList'] ['apply_in_a_day'],
									"in" => date ( 'Y-m-d H:i:s', strtotime ( $slpittedIn [0] . ' -1 day ' . $config_hrs ) ),
									"out" => $firstDate10,
									'cost' => $charge,
									'ward' => $wardValue ['Ward'] ['name'],
									'ward_id' => $wardValue ['Ward'] ['id'],
									'service_id' => $wardValue ['TariffList'] ['id'] 
							);
						}
						
						// checking for greater price of same day
						if (($dayArrCount > 0) && ($i == 0) && ($dayArr ['day'] [$dayArrCount - 1] ['out'] == $wardValue ['WardPatient'] ['in_date'])) {
							
							if ($dayArr ['day'] [$dayArrCount - 1] ['cost'] < $charge) {
								$dayArr ['day'] [$dayArrCount - 1] ['cost'] = $charge;
								$dayArr ['day'] [$dayArrCount - 1] ['ward'] = $wardValue ['Ward'] ['name'];
								$dayArr ['day'] [$dayArrCount - 1] ['ward_id'] = $wardValue ['Ward'] ['id'];
								$dayArr ['day'] [$dayArrCount - 1] ['service_id'] = $wardValue ['TariffList'] ['id'];
							}
							continue;
						}
						
						// EOF cost check
						
						if ((strtotime ( $nextDate ) >= strtotime ( $currDateUTC )) || ($i == $days)) { // change || to && for hours diff
							
							if ($i > 0) {
								$tempOutDate = strtotime ( $slpittedIn [0] . $i . " days $config_hrs" );
							} else {
								$tempOutDate = strtotime ( $wardValue ['WardPatient'] ['in_date'] );
							}
							
							if ($tempOutDate < strtotime ( $currDateUTC )) {
								// if cond to handle mid hours case
								// like if the starts at 6pm then the last day count should be upto 6pm
								// and skip the count after 6pm
								$dayArr ['day'] [] = array (
										'cghs_code' => $wardValue ['TariffList'] ['cghs_code'],
										'cghs_nabh' => $wardValue ['TariffList'] ['cghs_nabh'],
										'cghs_non_nabh' => $wardValue ['TariffList'] ['cghs_non_nabh'],
										'moa_sr_no' => $wardValue ['TariffAmount'] ['moa_sr_no'],
										'apply_in_a_day' => $wardValue ['TariffList'] ['apply_in_a_day'],
										"in" => date ( 'Y-m-d H:i:s', $tempOutDate ),
										"out" => $currDateUTC,
										'cost' => $charge,
										'ward' => $wardValue ['Ward'] ['name'],
										'ward_id' => $wardValue ['Ward'] ['id'],
										'service_id' => $wardValue ['TariffList'] ['id'] 
								);
							}
						} else {
							
							// commented below line for correcting out date for first array element
							if ($i == 0) {
								// if($days==1)
								$tempOutDate = strtotime ( $slpittedIn [0] . "1 days $config_hrs" );
								// else
								// $tempOutDate = strtotime($slpittedIn[0].$i." days $config_hrs");
							} else {
								$g = $i + 1;
								$tempOutDate = strtotime ( $wardValue ['WardPatient'] ['in_date'] . $g . " days" );
							}
							
							// BOF pankaj
							// check if the previous entry is of same day
							/*
							 * $previousIn = explode(" ",$dayArr['day'][$dayArrCount-1]['in']);
							 * $currentIn = explode(" ",$wardValue['WardPatient']['in_date']);
							 *
							 * if($previousIn[0]==$currentIn[0]){ pr($dayArr['day']);
							 * $dayArr['day'][$dayArrCount-1]['cost'] = $charge ;
							 * $dayArr['day'][$dayArrCount-1]['ward'] = $wardValue['Ward']['name'] ;
							 * $dayArr['day'][$dayArrCount-1]['out']=date('Y-m-d H:i:s',$tempOutDate) ;
							 * continue;
							 * }
							 */
							
							// EOF pankaj
							$dayArr ['day'] [] = array (
									'cghs_code' => $wardValue ['TariffList'] ['cghs_code'],
									'cghs_nabh' => $wardValue ['TariffList'] ['cghs_nabh'],
									'cghs_non_nabh' => $wardValue ['TariffList'] ['cghs_non_nabh'],
									'moa_sr_no' => $wardValue ['TariffAmount'] ['moa_sr_no'],
									'apply_in_a_day' => $wardValue ['TariffList'] ['apply_in_a_day'],
									"in" => date ( 'Y-m-d H:i:s', strtotime ( $wardValue ['WardPatient'] ['in_date'] . $i . " days" ) ),
									"out" => date ( 'Y-m-d H:i:s', $tempOutDate ),
									'cost' => $charge,
									'ward' => $wardValue ['Ward'] ['name'],
									'ward_id' => $wardValue ['Ward'] ['id'],
									'service_id' => $wardValue ['TariffList'] ['id'] 
							);
						}
					}
				} else if ($hrInterval->h >= 4 || $wardDayCount == 0) {
					$nextDate = date ( 'Y-m-d H:i:s', strtotime ( $wardValue ['WardPatient'] ['in_date'] ) );
					// checking for greater price of same day
					// EOF cost check
					
					if (($dayArrCount > 0) && ($dayArr ['day'] [$dayArrCount - 1] ['out'] == $wardValue ['WardPatient'] ['in_date'])) {
						if ($dayArr ['day'] [$dayArrCount - 1] ['cost'] < $charge) {
							$dayArr ['day'] [$dayArrCount - 1] ['cost'] = $charge;
							$dayArr ['day'] [$dayArrCount - 1] ['ward'] = $wardValue ['Ward'] ['name'];
							$dayArr ['day'] [$dayArrCount - 1] ['ward_id'] = $wardValue ['Ward'] ['id'];
							$dayArr ['day'] [$dayArrCount - 1] ['service_id'] = $wardValue ['TariffList'] ['id'];
						}
						continue;
					}
					if (strtotime ( $nextDate ) > strtotime ( $currDateUTC )) {
						$dayArr ['day'] [] = array (
								'cghs_code' => $wardValue ['TariffList'] ['cghs_code'],
								'moa_sr_no' => $wardValue ['TariffAmount'] ['moa_sr_no'],
								'in' => date ( 'Y-m-d H:i:s', strtotime ( $wardValue ['WardPatient'] ['in_date'] ) ),
								"out" => $currDateUTC,
								'cost' => $charge,
								'ward' => $wardValue ['Ward'] ['name'],
								'ward_id' => $wardValue ['Ward'] ['id'],
								'service_id' => $wardValue ['TariffList'] ['id'] 
						);
					} else {
						$dayArr ['day'] [] = array (
								'cghs_code' => $wardValue ['TariffList'] ['cghs_code'],
								'moa_sr_no' => $wardValue ['TariffAmount'] ['moa_sr_no'],
								"in" => date ( 'Y-m-d H:i:s', strtotime ( $wardValue ['WardPatient'] ['in_date'] ) ),
								"out" => date ( 'Y-m-d H:i:s', strtotime ( $wardValue ['WardPatient'] ['in_date'] ) ),
								'cost' => $charge,
								'ward' => $wardValue ['Ward'] ['name'],
								'ward_id' => $wardValue ['Ward'] ['id'],
								'service_id' => $wardValue ['TariffList'] ['id'] 
						);
					}
				}
			}
			$wardDayCount ++;
		}
		
		return array (
				'dayArr' => $dayArr,
				'surgeryData' => $surgeryDays 
		);
	}
	
	// retrun surgerical duration
	function getSurgeryArray($subArray = array(), $in_date, $out_date, $config_hrs) {
		$sergerySlot = array ();
		$conservativeDays = array ();
		$dateFormatComponentModel = new DateFormatComponent ( new ComponentCollection () );
		
		// if checkout timing is 24 hours then set time to default in time
		if ($config_hrs == '24 hours') {
			$slpittedIn = explode ( " ", $in_date );
			$config_hrs = $slpittedIn [1];
		}
		// EOF config check
		// EOD collecting hrs
		
		if (! empty ( $subArray )) {
			foreach ( $subArray as $key => $value ) {
				
				$slittedValiditiyDate = explode ( " ", $value ['surgeryScheduleDate'] );
				// reduced 1day if time is before config hours
				if (strtotime ( $slittedValiditiyDate [0] . " " . $config_hrs ) > strtotime ( $value ['surgeryScheduleDate'] ) && $value ['unitDays'] > 1) {
					$reducedValidity = $value ['unitDays'] - 1;
				} else {
					if (strtotime ( $slittedValiditiyDate [0] . " " . $config_hrs ) > strtotime ( $value ['surgeryScheduleDate'] ))
						$reducedValidity = 0;
					else
						$reducedValidity = $value ['unitDays'];
				}
				// EOF config hours check
				$sergeryValidityDate = date ( 'Y-m-d H:i:s', strtotime ( $slittedValiditiyDate [0] . $reducedValidity . " days $config_hrs" ) );
				if ($key > 0) {
					$lastKey = end ( $sergerySlot );
					if (strtotime ( $lastKey ['end'] ) > strtotime ( $sergeryValidityDate )) {
						$sergerySlot [$key] = array (
								'start' => $value ['surgeryScheduleDate'],
								'end' => $lastKey ['end'],
								'name' => $value ['name'],
								'cost' => $value ['surgeryAmount'],
								'validity' => $value ['unitDays'],
								'moa_sr_no' => $value ['moa_sr_no'],
								'cghs_nabh' => $value ['cghs_nabh'],
								'cghs_non_nabh' => $value ['cghs_non_nabh'],
								'cghs_code' => $value ['cghs_code'],
								'doctor' => $value ['doctor'],
								'doctor_education' => $value ['doctor_education'],
								'anaesthesist' => $value ['anaesthesist'],
								'anaesthesist_education' => $value ['anaesthesist_education'],
								'anaesthesist_cost' => $value ['anaesthesist_cost'],
								'ot_charges' => $value ['ot_charges'],
								'opt_id' => $value ['opt_id'],
								'paid_amount' => $value ['paid_amount'],
								/**
								 * gaurav
								 */
								'surgeon_cost' => $value ['surgeon_cost'],
								'asst_surgeon_one' => $value ['asst_surgeon_one'],
								'asst_surgeon_one_charge' => $value ['asst_surgeon_one_charge'],
								'asst_surgeon_two' => $value ['asst_surgeon_two'],
								'asst_surgeon_two_charge' => $value ['asst_surgeon_two_charge'],
								'cardiologist' => $value ['cardiologist'],
								'cardiologist_charge' => $value ['cardiologist_charge'],
								'ot_assistant' => $value ['ot_assistant'] 
						);
					} else {
						// BOF checking the diff between the two sergery validity
						$slpittedStart = explode ( " ", $value ['surgeryScheduleDate'] );
						$slpittedEnd = explode ( " ", $lastKey ['end'] );
						$interval = $dateFormatComponentModel->dateDiff ( $slpittedEnd [0], $slpittedStart [0] );
						$extraDays = $this->is_In_Out_Before_10_AM ( $value ['surgeryScheduleDate'] );
						$remainingDays = $interval->days - $extraDays;
						if ($remainingDays > 0) {
							// include next day till 10AM in sergery package validity
							$nextDayTill10AM = date ( 'Y-m-d H:i:s', strtotime ( $slpittedEnd [0] . "0 days $config_hrs" ) );
							if (strtotime ( $nextDayTill10AM ) <= strtotime ( $value ['surgeryScheduleDate'] )) {
								for($c = 1; $c < $remainingDays; $c ++) {
									if (strtotime ( $nextDayTill10AM ) <= strtotime ( $value ['surgeryScheduleDate'] )) {
										$conservativeDays [$key] [] = array (
												'in' => $nextDayTill10AM,
												'out' => date ( 'Y-m-d H:i:s', strtotime ( $nextDayTill10AM . $c . ' days' ) ) 
										);
										$nextDayTill10AM = date ( 'Y-m-d H:i:s', strtotime ( $nextDayTill10AM . '1 days' ) );
									}
								}
							}
						}
						// EOF validity check
						$sergerySlot [$key] = array (
								'start' => $value ['surgeryScheduleDate'],
								'end' => $sergeryValidityDate,
								'name' => $value ['name'],
								'cost' => $value ['surgeryAmount'],
								'validity' => $value ['unitDays'],
								'moa_sr_no' => $value ['moa_sr_no'],
								'cghs_nabh' => $value ['cghs_nabh'],
								'cghs_non_nabh' => $value ['cghs_non_nabh'],
								'cghs_code' => $value ['cghs_code'],
								'doctor' => $value ['doctor'],
								'doctor_education' => $value ['doctor_education'],
								'anaesthesist' => $value ['anaesthesist'],
								'anaesthesist_education' => $value ['anaesthesist_education'],
								'anaesthesist_cost' => $value ['anaesthesist_cost'],
								'ot_charges' => $value ['ot_charges'],
								'opt_id' => $value ['opt_id'],
								'paid_amount' => $value ['paid_amount'],
								/**
								 * gaurav
								 */
								'surgeon_cost' => $value ['surgeon_cost'],
								'asst_surgeon_one' => $value ['asst_surgeon_one'],
								'asst_surgeon_one_charge' => $value ['asst_surgeon_one_charge'],
								'asst_surgeon_two' => $value ['asst_surgeon_two'],
								'asst_surgeon_two_charge' => $value ['asst_surgeon_two_charge'],
								'cardiologist' => $value ['cardiologist'],
								'cardiologist_charge' => $value ['cardiologist_charge'],
								'ot_assistant' => $value ['ot_assistant'] 
						);
					}
				} else {
					if ($value ['unitDays'] > 1) { // for single surgery as a package to set proper end calculated on the basis of validity period
						$sergerySlot [$key] = array (
								'start' => $value ['surgeryScheduleDate'],
								'end' => $sergeryValidityDate,
								'name' => $value ['name'],
								'cost' => $value ['surgeryAmount'],
								'validity' => $value ['unitDays'],
								'moa_sr_no' => $value ['moa_sr_no'],
								'cghs_nabh' => $value ['cghs_nabh'],
								'cghs_non_nabh' => $value ['cghs_non_nabh'],
								'cghs_code' => $value ['cghs_code'],
								'doctor' => $value ['doctor'],
								'doctor_education' => $value ['doctor_education'],
								'anaesthesist' => $value ['anaesthesist'],
								'anaesthesist_education' => $value ['anaesthesist_education'],
								'anaesthesist_cost' => $value ['anaesthesist_cost'],
								'ot_charges' => $value ['ot_charges'],
								'opt_id' => $value ['opt_id'],
								'paid_amount' => $value ['paid_amount'],
								/**
								 * gaurav
								 */
								'surgeon_cost' => $value ['surgeon_cost'],
								'asst_surgeon_one' => $value ['asst_surgeon_one'],
								'asst_surgeon_one_charge' => $value ['asst_surgeon_one_charge'],
								'asst_surgeon_two' => $value ['asst_surgeon_two'],
								'asst_surgeon_two_charge' => $value ['asst_surgeon_two_charge'],
								'cardiologist' => $value ['cardiologist'],
								'cardiologist_charge' => $value ['cardiologist_charge'],
								'ot_assistant' => $value ['ot_assistant'] 
						);
					} else {
						$sergerySlot [$key] = array (
								'start' => $value ['surgeryScheduleDate'],
								// 'end'=>$sergeryValidityDate,
								'end' => $value ['surgeryScheduleEndDate'],
								'name' => $value ['name'],
								'cost' => $value ['surgeryAmount'],
								'validity' => $value ['unitDays'],
								'moa_sr_no' => $value ['moa_sr_no'],
								'cghs_nabh' => $value ['cghs_nabh'],
								'cghs_non_nabh' => $value ['cghs_non_nabh'],
								'cghs_code' => $value ['cghs_code'],
								'doctor' => $value ['doctor'],
								'doctor_education' => $value ['doctor_education'],
								'anaesthesist' => $value ['anaesthesist'],
								'anaesthesist_education' => $value ['anaesthesist_education'],
								'anaesthesist_cost' => $value ['anaesthesist_cost'],
								'ot_charges' => $value ['ot_charges'],
								'opt_id' => $value ['opt_id'],
								'paid_amount' => $value ['paid_amount'],
								/**
								 * gaurav
								 */
								'surgeon_cost' => $value ['surgeon_cost'],
								'asst_surgeon_one' => $value ['asst_surgeon_one'],
								'asst_surgeon_one_charge' => $value ['asst_surgeon_one_charge'],
								'asst_surgeon_two' => $value ['asst_surgeon_two'],
								'asst_surgeon_two_charge' => $value ['asst_surgeon_two_charge'],
								'cardiologist' => $value ['cardiologist'],
								'cardiologist_charge' => $value ['cardiologist_charge'],
								'ot_assistant' => $value ['ot_assistant'] 
						);
					}
				}
			}
		}
		
		return array (
				'sugeryValidity' => $sergerySlot,
				'conservativeDays' => $conservativeDays 
		);
	}
	function getCheckoutTime($locId) {
		$locationModel = new Location ( null, null, $this->database );
		$result = $locationModel->find ( 'first', array (
				'condition' => array (
						'Location.id' => $locId 
				),
				'fields' => array (
						'checkout_time' 
				) 
		) );
		
		if ($result ['Location'] ['checkout_time']) {
			return $result ['Location'] ['checkout_time'] . " hours"; // initially string was attached ":00:00"
		} else {
			return ""; // default checkout time
		}
	}
	
	// function to check whether the patient added before 10AM and
	function is_In_Out_Before_10_AM($inDate = null, $outDate = null, $surgeryDate = null) {
		$days = 0;
		if (! empty ( $inDate )) {
			if (strlen ( $inDate ) > 10) {
				$entryHr = substr ( $inDate, - 8, 2 );
				$days = ($entryHr >= 10) ? 0 : 1;
			}
		}
		if (! empty ( $outDate )) {
			// if(empty($surgeryDate)){
			if (strlen ( $inDate ) > 10) {
				$entryHr = substr ( $outDate, - 8, 2 );
				$days += ($entryHr <= 10) ? 0 : 1;
			}
			// }
		}
		return ( int ) $days;
	}
	
	// function to check if patient has any class assigned or not
	function getCorporateClassWard($patient_id = null, $ward_id = null) {
		if (! $patient_id || ! $ward_id)
			return false;
		$patientModel = new Patient ( null, null, $this->database );
		$wardModel = new Ward ( null, null, $this->database );
		$tariffAmountModel = new TariffAmount ( null, null, $this->database );
		$wardModel->recursive = 0 ;
		$checkIsICU = $wardModel->find ( 'first', array (
				'fields',
				array (
						'conditions' => array (
								'Ward.id' => $ward_id 
						) 
				) 
		) );
		if ($checkIsICU ['Ward'] ['ward_type'] == 'ICU')
			return false; // no need change for icu ward
		$patientData = $patientModel->find ( 'first', array (
				'fields' => array (
						'Patient.corporate_status',
						'Patient.tariff_standard_id' 
				),
				'conditions' => array (
						'Patient.id' => $patient_id 
				) 
		) );
		$statusArray = Configure::read ( 'corporateStatus' );
		$patientStatus = $statusArray [$patientData ['Patient'] ['corporate_status']];
		if ($patientData ['Patient'] ['corporate_status']) {
			$wardList = $this->wards;
			switch ($patientStatus) {
				case 'General' :
					$searchword = 'General';
					break;
				case 'Shared' :
					$searchword = 'Sharing';
					break;
				case 'Special' :
					$searchword = 'Special';
					break;
			}
			 
			$classWard = '';
			 
			foreach ( $wardList as $key => $value ) { // iterate over ward data				 
				if (strpos($value, $searchword) !== false ) {
					$classWard = $key;
					break; // that's it
				}
			}
			if (! $classWard)
				return false; // for any other case return false
			$wardModel->bindModel ( array (
					'belongsTo' => array (
							'TariffAmount' => array (
									'foreignKey' => false,
									'conditions' => array (
											'Ward.tariff_list_id=TariffAmount.tariff_list_id',
											'TariffAmount.tariff_standard_id' => $patientData ['Patient'] ['tariff_standard_id'] 
									) 
							) 
					) 
			), false );
			$classCharges = $wardModel->find ('first',array('conditions'=>array('Ward.id'=>$classWard),
					'fields'=>array('TariffAmount.nabh_charges','TariffAmount.non_nabh_charges'))); 
			if($this->hospitalType=='NABH'){
				return $classCharges['TariffAmount']['nabh_charges'] ;
			}else{
				return $classCharges['TariffAmount']['non_nabh_charges'] ;
			}
		} else {
			return false; // continue with basic flow
		}
	}
	
	// list of all wards
	function getWardList() {
		$wardModel = new Ward ( null, null, $this->database );
		$wardModel->recursive = -1 ;
		$this->wards = $wardModel->find ( 'list', array (
				'fields' => array (
						'id',
						'name' 
				),
				'conditions' => array (
						'is_deleted=0' 
				) 
		) ); 
	}
}