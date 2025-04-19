<?php 
App::uses('AppModel', 'Model');
/**
 * Emar dashboard Model
 * @copyright     Copyright 2013 DrM Hope Software.  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       Medication Prescription Schedules
 * @since         CakePHP(tm) v 5.4.3
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Gaurav Chauriya
*/

class EmarDashboardSetting extends AppModel {

	public $name = 'EmarDashboardSetting';
	//var $useTable = 'emar_dashboard_settings';
	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}

	public function __call($method, $arguments) {
		return true;
	}
	/**
	 * key => frequency Id in config frequency array
	 * value => no of hours for frequency ex. key => 2 is Daily and value 24 is 24hours
	 */
	public $frequencyHours = array("2"=>"24","4"=>"24","5"=>"12","6"=>"8","7"=>"6","25"=>"1","29"=>"2","28"=>"3","8"=>"4","9"=>"6","10"=>"8","11"=>"12","26"=>"48","23"=>"72",
        "14"=>"168","15"=>"336","16"=>"504","12"=>"48","27"=>"84","20"=>"56","22"=>"5040","18"=>"24","19"=>"24","35"=>"24","31"=>"24","32"=>"24","34"=>"24",
		"35"=>"24","36"=>"12","37"=>"12","38"=>"336","39"=>"48","40"=>"168","41"=>"24","42"=>"24","43"=>"24","44"=>"24");

	function medicationSchedule($patientId=null){
		$session = new cakeSession();
		$NewCropPrescription = ClassRegistry::init('NewCropPrescription');
		$MedicationAdministeringRecord = ClassRegistry::init('MedicationAdministeringRecord');

		$NewCropPrescription->bindModel(array(
				'hasMany'=>array('MedicationAdministeringRecord'=>array('foreignKey'=>'new_crop_prescription_id',
						'conditions'=>array('MedicationAdministeringRecord.late_reason_flag=0','MedicationAdministeringRecord.admin_note_flag=0',
						 	"MedicationAdministeringRecord.patient_id=$patientId",'MedicationAdministeringRecord.med_request_flag=0',
								'performed_datetime >='=>date('Y-m-d H:i:s',strtotime("-2 day"))
						),
						'fields'=>'MedicationAdministeringRecord.performed_datetime'))
		));

		$medFrequency = $NewCropPrescription->find('all',array('fields'=>array('NewCropPrescription.drug_name','NewCropPrescription.frequency',
				'NewCropPrescription.firstdose'),
				'conditions'=>array('archive'=>'N'/*,'prn'=>'0'*/,'NewCropPrescription.patient_uniqueid'=>$patientId,'firstdose <='=>date('Y-m-d H:i:s',strtotime("+1 day")),
						'NewCropPrescription.location_id'=>$session->read('locationid'))));

		$dayArray = array(date('Y-m-d'),date('Y-m-d',strtotime("-1 day")),date('Y-m-d',strtotime("+1 day")));
		$dayArray2 = array(date('Y-m-d'),date('Y-m-d',strtotime("-1 day")),date('Y-m-d',strtotime("+1 day")));
		$scheduleDrugTimes = array();
		$frequency = Configure::read('frequency');//debug($frequency);
		foreach($medFrequency as $freqTime){

			//$freqTime['NewCropPrescription']['firstdose'] = DateFormatComponent::formatDate2Local($freqTime['NewCropPrescription']['firstdose'],Configure::read('date_format'),true);
			switch(strtoupper($frequency[$freqTime['NewCropPrescription']['frequency']])) {
				/*case "as directed":
					$timeArray[]='as directed';
				break;*/
				case "DAILY":
				case "DAILY AFTER DINNER EXCEPT SUNDAY":
				case "ONCE A DAY AFTER DINNER":
				case "ONCE A DAY BEFORE BREAKFAST":
				case "DAILY AFTER BREAKFAST":
				case "DAILY AST":
				case "NIGHTLY":
				case "EVERY NIGHT AT BEDTIME":
					/*$timeArray[0][] = $freqTime['NewCropPrescription']['drug_name'];
					 $timeArray[1][] = $freqTime['NewCropPrescription']['drug_name'];
					 $timeArray[2][] = $freqTime['NewCropPrescription']['drug_name'];*/

					$timeArray[0][] = $dayArray['0']." ".substr($freqTime['NewCropPrescription']['firstdose'], 11, -3);
					$scheduleDrugTimes[$freqTime['NewCropPrescription']['drug_name']] [] = $dayArray['0']." ".substr($freqTime['NewCropPrescription']['firstdose'], 11, -3);

					$timeArray[1][] = $dayArray['1']." ".substr($freqTime['NewCropPrescription']['firstdose'], 11, -3);
					$scheduleDrugTimes[$freqTime['NewCropPrescription']['drug_name']] [] = $dayArray['1']." ".substr($freqTime['NewCropPrescription']['firstdose'], 11, -3);

					$timeArray[2][] = $dayArray['2']." ".substr($freqTime['NewCropPrescription']['firstdose'], 11, -3);
					$scheduleDrugTimes[$freqTime['NewCropPrescription']['drug_name']] [] = $dayArray['2']." ".substr($freqTime['NewCropPrescription']['firstdose'], 11, -3);

					break;
				case "TWICE A DAY":
				case "TWICE A DAY BEFORE MEALS":
				case "TWICE A DAY AFTER MEALS":
				case "EVERY 12 HOURS":
					foreach($dayArray as $key=>$days){
						//$timeArray[$key][] = $freqTime['NewCropPrescription']['drug_name'];

						$time = strtotime(substr($freqTime['NewCropPrescription']['firstdose'], 11, -3)) + 3600*12;
						$timeArray[$key][] = $days." ".substr($freqTime['NewCropPrescription']['firstdose'], 11, -3);
						$scheduleDrugTimes[$freqTime['NewCropPrescription']['drug_name']] [] = $days." ".substr($freqTime['NewCropPrescription']['firstdose'], 11, -3);
						$timeArray[$key][] = $days." ".date('H:i', $time);
						$scheduleDrugTimes[$freqTime['NewCropPrescription']['drug_name']] [] = $days." ".date('H:i', $time);
					}
					break;
				case "THRICE A DAY":
					foreach($dayArray as $key=>$days){
						if(strtotime($freqTime['NewCropPrescription']['firstdose'])<strtotime($dayArray2[$key]." ".date('H:i:s'))){
							//$timeArray[$key][] = $freqTime['NewCropPrescription']['drug_name'];

							$timeArray[$key][] = $days." ".substr($freqTime['NewCropPrescription']['firstdose'], 11, -3);
							$scheduleDrugTimes[$freqTime['NewCropPrescription']['drug_name']] [] = $days." ".substr($freqTime['NewCropPrescription']['firstdose'], 11, -3);

							$time1 = date('H:i', strtotime(substr($freqTime['NewCropPrescription']['firstdose'], 11, -3)) + 3600*8);
							$timeArray[$key][] = $days." ".$time1;
							$scheduleDrugTimes[$freqTime['NewCropPrescription']['drug_name']] [] = $days." ".$time1;

							$time2 = date('H:i', strtotime($time1) + 3600*8);
							$timeArray[$key][] = $days." ".$time2;
							$scheduleDrugTimes[$freqTime['NewCropPrescription']['drug_name']] [] = $days." ".$time2;
						}
					}
					break;
				case "FOUR TIMES A DAY":
					foreach($dayArray as $key=>$days){
						//$timeArray[$key][] = $freqTime['NewCropPrescription']['drug_name'];

						$timeArray[$key][] = $days." ".substr($freqTime['NewCropPrescription']['firstdose'], 11, -3);
						$scheduleDrugTimes[$freqTime['NewCropPrescription']['drug_name']] [] = $days." ".substr($freqTime['NewCropPrescription']['firstdose'], 11, -3);

						$time1 = date('H:i', strtotime(substr($freqTime['NewCropPrescription']['firstdose'], 11, -3)) + 3600*6);
						$timeArray[$key][] = $days." ".$time1;
						$scheduleDrugTimes[$freqTime['NewCropPrescription']['drug_name']] [] = $days." ".$time1;

						$time2 = date('H:i', strtotime($time1) + 3600*6);
						$timeArray[$key][] = $days." ".$time2;
						$scheduleDrugTimes[$freqTime['NewCropPrescription']['drug_name']] [] = $days." ".$time2;

						$time3 = date('H:i', strtotime($time2) + 3600*6);
						$timeArray[$key][] = $days." ".$time3;
						$scheduleDrugTimes[$freqTime['NewCropPrescription']['drug_name']] [] = $days." ".$time3;
					}
					break;
				case "EVERY 1 HOUR":
					foreach($dayArray as $key=>$days){
						//$timeArray[$key][] = $freqTime['NewCropPrescription']['drug_name'];
						if(strtotime($freqTime['NewCropPrescription']['firstdose'])<strtotime($dayArray2[$key]." ".date('H:i:s'))){
							if(substr($freqTime['NewCropPrescription']['firstdose'], 0, -9) == $dayArray2[$key]){
								$cntVal= intval(substr($freqTime['NewCropPrescription']['firstdose'], 11, -6));
							}else{
								$cntVal = 0;
							}$incre=0;
							for($i=$cntVal;$i<=23;$i++){
								$timeCntr = date('H:i',strtotime(substr($freqTime['NewCropPrescription']['firstdose'], 11, -3))+3600*$incre);
								$timeArray[$key][] = $days." ".$timeCntr;
								$scheduleDrugTimes[$freqTime['NewCropPrescription']['drug_name']] [] = $days." ".$timeCntr;
								$incre++;
							}
						}
					}
					break;
				case "Every 2 hours":
					foreach($dayArray as $key=>$days){
						//$timeArray[$key][] = $freqTime['NewCropPrescription']['drug_name'];

						if(strtotime($freqTime['NewCropPrescription']['firstdose'])<strtotime($dayArray2[$key]." ".date('H:i:s'))){
							if(substr($freqTime['NewCropPrescription']['firstdose'], 0, -9) == $dayArray2[$key]){
								$cntVal= intval(substr($freqTime['NewCropPrescription']['firstdose'], 11, -6));
							}else{
								$cntVal = 0;
							}$incre=0;
							for($i=$cntVal;$i<=23;$i+=2){
								$timeCntr = date('H:i',strtotime(substr($freqTime['NewCropPrescription']['firstdose'], 11, -3))+3600*$incre);
								$timeArray[$key][] = $days." ".$timeCntr;
								$scheduleDrugTimes[$freqTime['NewCropPrescription']['drug_name']] [] = $days." ".$timeCntr;
								$incre+=2;
							}
						}
					}
					break;
				case "EVERY 3 HOURS":
					foreach($dayArray as $key=>$days){
						//$timeArray[$key][] = $freqTime['NewCropPrescription']['drug_name'];

						if(strtotime($freqTime['NewCropPrescription']['firstdose'])<strtotime($dayArray2[$key]." ".date('H:i:s'))){
							if(substr($freqTime['NewCropPrescription']['firstdose'], 0, -9) == $dayArray2[$key]){
								$cntVal= intval(substr($freqTime['NewCropPrescription']['firstdose'], 11, -6));
							}else{
								$cntVal = 0;
							}$incre=0;
							for($i=$cntVal;$i<=23;$i+=3){
								$timeCntr = date('H:i',strtotime(substr($freqTime['NewCropPrescription']['firstdose'], 11, -3))+3600*$incre);
								$timeArray[$key][] = $days." ".$timeCntr;
								$scheduleDrugTimes[$freqTime['NewCropPrescription']['drug_name']] [] = $days." ".$timeCntr;
								$incre+=3;
							}
						}
					}
					break;
				case "EVERY 4 HOURS":
					foreach($dayArray as $key=>$days){
						//$timeArray[$key][] = $freqTime['NewCropPrescription']['drug_name'];
							
						if(strtotime($freqTime['NewCropPrescription']['firstdose'])<strtotime($dayArray2[$key]." ".date('H:i:s'))){
							if(substr($freqTime['NewCropPrescription']['firstdose'], 0, -9) == $dayArray2[$key]){
								$cntVal= intval(substr($freqTime['NewCropPrescription']['firstdose'], 11, -6));
							}else{
								$cntVal = 0;
							}$incre=0;
							for($i=$cntVal;$i<=23;$i+=4){
								$timeCntr = date('H:i',strtotime(substr($freqTime['NewCropPrescription']['firstdose'], 11, -3))+3600*$incre);
								$timeArray[$key][] = $days." ".$timeCntr;
								$scheduleDrugTimes[$freqTime['NewCropPrescription']['drug_name']] [] = $days." ".$timeCntr;
								$incre+=4;
							}
						}
					}
					break;
				case "EVERY 6 HOURS":
					foreach($dayArray as $key=>$days){
						//$timeArray[$key][] = $freqTime['NewCropPrescription']['drug_name'];
							
						if(strtotime($freqTime['NewCropPrescription']['firstdose'])<strtotime($dayArray2[$key]." ".date('H:i:s'))){
							if(substr($freqTime['NewCropPrescription']['firstdose'], 0, -9) == $dayArray2[$key]){
								$cntVal= intval(substr($freqTime['NewCropPrescription']['firstdose'], 11, -6));
							}else{
								$cntVal = 0;
							}$incre=0;
							for($i=$cntVal;$i<=23;$i+=6){
								$timeCntr = date('H:i',strtotime(substr($freqTime['NewCropPrescription']['firstdose'], 11, -3))+3600*$incre);
								$timeArray[$key][] = $days." ".$timeCntr;
								$scheduleDrugTimes[$freqTime['NewCropPrescription']['drug_name']] [] = $days." ".$timeCntr;
								$incre+=6;
							}
						}
					}
					break;
				case "EVERY 8 HOURS":
					foreach($dayArray as $key=>$days){
						//$timeArray[$key][] = $freqTime['NewCropPrescription']['drug_name'];

						if(strtotime($freqTime['NewCropPrescription']['firstdose'])<strtotime($dayArray2[$key]." ".date('H:i:s'))){
							if(substr($freqTime['NewCropPrescription']['firstdose'], 0, -9) == $dayArray2[$key]){
								$cntVal= intval(substr($freqTime['NewCropPrescription']['firstdose'], 11, -6));
							}else{
								$cntVal = 0;
							}$incre=0;
							for($i=$cntVal;$i<=23;$i+=8){
								$timeCntr = date('H:i',strtotime(substr($freqTime['NewCropPrescription']['firstdose'], 11, -3))+3600*$incre);
								$timeArray[$key][] = $days." ".$timeCntr;
								$scheduleDrugTimes[$freqTime['NewCropPrescription']['drug_name']] [] = $days." ".$timeCntr;
								$incre+=8;
							}
						}
					}
					break;
				

				case "EVERY 48 HOURS":
				case "ALTERNATE DAY":
				case "EVERY OTHER DAY":
					$doseDate = $freqTime['NewCropPrescription']['firstdose'];
					//here 3600*48 = 2days
					while (strtotime(date('Y-m-d H:i:s')) >= strtotime($doseDate)) {
						if(date('Y-m-d',strtotime($doseDate))==$dayArray['2']){
							//$timeArray['2'][] = $freqTime['NewCropPrescription']['drug_name'];

							$timeArray['2'][] = date('Y-m-d H:i',strtotime($doseDate));
							$scheduleDrugTimes[$freqTime['NewCropPrescription']['drug_name']] [] = date('Y-m-d H:i',strtotime($doseDate));
						}else if(date('Y-m-d',strtotime($doseDate))==$dayArray['1']){
							////$timeArray['1'][] = $freqTime['NewCropPrescription']['drug_name'];

							$timeArray['1'][] = date('Y-m-d H:i',strtotime($doseDate));
							$scheduleDrugTimes[$freqTime['NewCropPrescription']['drug_name']] [] = date('Y-m-d H:i',strtotime($doseDate));
						}else if(date('Y-m-d',strtotime($doseDate))==$dayArray['0']){
							////$timeArray['0'][] = $freqTime['NewCropPrescription']['drug_name'];

							$timeArray['0'][] = date('Y-m-d H:i',strtotime($doseDate));
							$scheduleDrugTimes[$freqTime['NewCropPrescription']['drug_name']] [] = date('Y-m-d H:i',strtotime($doseDate));
						}
						$doseDate = date('Y-m-d H:i:s', strtotime($doseDate) + 3600*48);
					}
					ksort($timeArray);
					break;
				case "EVERY 72 HOURS":
					$doseDate = $freqTime['NewCropPrescription']['firstdose'];
					//here 3600*72 = 3days
					while (strtotime(date('Y-m-d H:i:s')) >= strtotime($doseDate)) {
						if(date('Y-m-d',strtotime($doseDate))==$dayArray['2']){
							//$timeArray['2'][] = $freqTime['NewCropPrescription']['drug_name'];

							$timeArray['2'][] = date('Y-m-d H:i',strtotime($doseDate));
							$scheduleDrugTimes[$freqTime['NewCropPrescription']['drug_name']] [] = date('Y-m-d H:i',strtotime($doseDate));
						}else if(date('Y-m-d',strtotime($doseDate))==$dayArray['1']){
							//$timeArray['1'][] = $freqTime['NewCropPrescription']['drug_name'];

							$timeArray['1'][] = date('Y-m-d H:i',strtotime($doseDate));
							$scheduleDrugTimes[$freqTime['NewCropPrescription']['drug_name']] [] = date('Y-m-d H:i',strtotime($doseDate));
						}else if(date('Y-m-d',strtotime($doseDate))==$dayArray['0']){
							////$timeArray['0'][] = $freqTime['NewCropPrescription']['drug_name'];

							$timeArray['0'][] = date('Y-m-d H:i',strtotime($doseDate));
							$scheduleDrugTimes[$freqTime['NewCropPrescription']['drug_name']] [] = date('Y-m-d H:i',strtotime($doseDate));
						}
						$doseDate = date('Y-m-d H:i:s', strtotime($doseDate) + 3600*72);
					}
					ksort($timeArray);
					break;
				case "EVERY 1 WEEK":
				case "ONCE A WEEK ON SUNDAY AFTER DINNER":
					$doseDate = $freqTime['NewCropPrescription']['firstdose'];
					//here 3600*168 = 1 week
					while (strtotime(date('Y-m-d H:i:s')) >= strtotime($doseDate)) {
						if(date('Y-m-d',strtotime($doseDate))==$dayArray['2']){
							//$timeArray['2'][] = $freqTime['NewCropPrescription']['drug_name'];

							$timeArray['2'][] = date('Y-m-d H:i',strtotime($doseDate));
							$scheduleDrugTimes[$freqTime['NewCropPrescription']['drug_name']] [] = date('Y-m-d H:i',strtotime($doseDate));
						}else if(date('Y-m-d',strtotime($doseDate))==$dayArray['1']){
							//$timeArray['1'][] = $freqTime['NewCropPrescription']['drug_name'];

							$timeArray['1'][] = date('Y-m-d H:i',strtotime($doseDate));
							$scheduleDrugTimes[$freqTime['NewCropPrescription']['drug_name']] [] = date('Y-m-d H:i',strtotime($doseDate));
						}else if(date('Y-m-d',strtotime($doseDate))==$dayArray['0']){
							//$timeArray['1'][] = $freqTime['NewCropPrescription']['drug_name'];

							$timeArray['0'][] = date('Y-m-d H:i',strtotime($doseDate));
							$scheduleDrugTimes[$freqTime['NewCropPrescription']['drug_name']] [] = date('Y-m-d H:i',strtotime($doseDate));
						}
						$doseDate = date('Y-m-d H:i:s', strtotime($doseDate)+3600*168);
					}
					ksort($timeArray);
					break;
				case "EVERY 2 WEEKS":
				case "FORTNIGHTLY":
					$doseDate = $freqTime['NewCropPrescription']['firstdose'];
					//here 3600*336 = 2 week
					while (strtotime(date('Y-m-d H:i:s')) >= strtotime($doseDate)) {
						if(date('Y-m-d',strtotime($doseDate))==$dayArray['2']){
							//$timeArray['2'][] = $freqTime['NewCropPrescription']['drug_name'];

							$timeArray['2'][] = date('Y-m-d H:i',strtotime($doseDate));
							$scheduleDrugTimes[$freqTime['NewCropPrescription']['drug_name']] [] = date('Y-m-d H:i',strtotime($doseDate));
						}else if(date('Y-m-d',strtotime($doseDate))==$dayArray['1']){
							//$timeArray['1'][] = $freqTime['NewCropPrescription']['drug_name'];

							$timeArray['1'][] = date('Y-m-d H:i',strtotime($doseDate));
							$scheduleDrugTimes[$freqTime['NewCropPrescription']['drug_name']] [] = date('Y-m-d H:i',strtotime($doseDate));
						}else if(date('Y-m-d',strtotime($doseDate))==$dayArray['0']){
							////$timeArray['0'][] = $freqTime['NewCropPrescription']['drug_name'];

							$timeArray['0'][] = date('Y-m-d H:i',strtotime($doseDate));
							$scheduleDrugTimes[$freqTime['NewCropPrescription']['drug_name']] [] = date('Y-m-d H:i',strtotime($doseDate));
						}
						$doseDate = date('Y-m-d H:i:s', strtotime($doseDate) + 3600*336);
					}
					ksort($timeArray);
					break;
				case "EVERY 3 WEEKS":
					$doseDate = $freqTime['NewCropPrescription']['firstdose'];
					//here 3600*504 = 3 week
					while (strtotime(date('Y-m-d H:i:s')) >= strtotime($doseDate)) {
						if(date('Y-m-d',strtotime($doseDate))==$dayArray['2']){
							//$timeArray['2'][] = $freqTime['NewCropPrescription']['drug_name'];

							$timeArray['2'][] = date('Y-m-d H:i',strtotime($doseDate));
							$scheduleDrugTimes[$freqTime['NewCropPrescription']['drug_name']] [] = date('Y-m-d H:i',strtotime($doseDate));
						}else if(date('Y-m-d',strtotime($doseDate))==$dayArray['1']){
							//$timeArray['1'][] = $freqTime['NewCropPrescription']['drug_name'];

							$timeArray['1'][] = date('Y-m-d H:i',strtotime($doseDate));
							$scheduleDrugTimes[$freqTime['NewCropPrescription']['drug_name']] [] = date('Y-m-d H:i',strtotime($doseDate));
						}else if(date('Y-m-d',strtotime($doseDate))==$dayArray['0']){
							//$timeArray['0'][] = $freqTime['NewCropPrescription']['drug_name'];

							$timeArray['0'][] = date('Y-m-d H:i',strtotime($doseDate));
							$scheduleDrugTimes[$freqTime['NewCropPrescription']['drug_name']] [] = date('Y-m-d H:i',strtotime($doseDate));
						}
						$doseDate = date('Y-m-d H:i:s', strtotime($doseDate) + 3600*504);
					}
					ksort($timeArray);
					break;
				
				case "2 TIMES WEEKLY":
					$doseDate = $freqTime['NewCropPrescription']['firstdose'];
					//here 3600*84 = week hrs/2
					while (strtotime(date('Y-m-d H:i:s')) >= strtotime($doseDate)) {
						if(date('Y-m-d',strtotime($doseDate))==$dayArray['2']){
							//$timeArray['2'][] = $freqTime['NewCropPrescription']['drug_name'];

							$timeArray['2'][] = date('Y-m-d H:i',strtotime($doseDate));
							$scheduleDrugTimes[$freqTime['NewCropPrescription']['drug_name']] [] = date('Y-m-d H:i',strtotime($doseDate));
						}else if(date('Y-m-d',strtotime($doseDate))==$dayArray['1']){
							//$timeArray['1'][] = $freqTime['NewCropPrescription']['drug_name'];

							$timeArray['1'][] = date('Y-m-d H:i',strtotime($doseDate));
							$scheduleDrugTimes[$freqTime['NewCropPrescription']['drug_name']] [] = date('Y-m-d H:i',strtotime($doseDate));
						}else if(date('Y-m-d',strtotime($doseDate))==$dayArray['0']){
							////$timeArray['0'][] = $freqTime['NewCropPrescription']['drug_name'];

							$timeArray['0'][] = date('Y-m-d H:i',strtotime($doseDate));
							$scheduleDrugTimes[$freqTime['NewCropPrescription']['drug_name']] [] = date('Y-m-d H:i',strtotime($doseDate));
						}
						$doseDate = date('Y-m-d H:i:s', strtotime($doseDate) + 3600*84);
					}
					ksort($timeArray);
					break;
				case "3 TIMES WEEKLY":
					$doseDate = $freqTime['NewCropPrescription']['firstdose'];
					//here 3600*56 = week hrs/3
					while (strtotime(date('Y-m-d H:i:s')) >= strtotime($doseDate)) {
						if(date('Y-m-d',strtotime($doseDate))==$dayArray['2']){
							//$timeArray['2'][] = $freqTime['NewCropPrescription']['drug_name'];

							$timeArray['2'][] = date('Y-m-d H:i',strtotime($doseDate));
							$scheduleDrugTimes[$freqTime['NewCropPrescription']['drug_name']] [] = date('Y-m-d H:i',strtotime($doseDate));
						}else if(date('Y-m-d',strtotime($doseDate))==$dayArray['1']){
							//$timeArray['1'][] = $freqTime['NewCropPrescription']['drug_name'];

							$timeArray['1'][] = date('Y-m-d H:i',strtotime($doseDate));
							$scheduleDrugTimes[$freqTime['NewCropPrescription']['drug_name']] [] = date('Y-m-d H:i',strtotime($doseDate));
						}else if(date('Y-m-d',strtotime($doseDate))==$dayArray['0']){
							////$timeArray['0'][] = $freqTime['NewCropPrescription']['drug_name'];

							$timeArray['0'][] = date('Y-m-d H:i',strtotime($doseDate));
							$scheduleDrugTimes[$freqTime['NewCropPrescription']['drug_name']] [] = date('Y-m-d H:i',strtotime($doseDate));
						}
						$doseDate = date('Y-m-d H:i:s', strtotime($doseDate) + 3600*56);
					}
					ksort($timeArray);
					break;
				case "ONCE A MONTH":
					$doseDate = $freqTime['NewCropPrescription']['firstdose'];
					//here 3600*5040 = 1 month
					while (strtotime(date('Y-m-d H:i:s')) >= strtotime($doseDate)) {
						if(date('Y-m-d',strtotime($doseDate))==$dayArray['2']){
							//$timeArray['2'][] = $freqTime['NewCropPrescription']['drug_name'];

							$timeArray['2'][] = date('Y-m-d H:i',strtotime($doseDate));
							$scheduleDrugTimes[$freqTime['NewCropPrescription']['drug_name']] [] = date('Y-m-d H:i',strtotime($doseDate));
						}else if(date('Y-m-d',strtotime($doseDate))==$dayArray['1']){
							////$timeArray['1'][] = $freqTime['NewCropPrescription']['drug_name'];

							$timeArray['1'][] = date('Y-m-d H:i',strtotime($doseDate));
							$scheduleDrugTimes[$freqTime['NewCropPrescription']['drug_name']] [] = date('Y-m-d H:i',strtotime($doseDate));
						}else if(date('Y-m-d',strtotime($doseDate))==$dayArray['0']){
							//$timeArray['0'][] = $freqTime['NewCropPrescription']['drug_name'];

							$timeArray['0'][] = date('Y-m-d H:i',strtotime($doseDate));
							$scheduleDrugTimes[$freqTime['NewCropPrescription']['drug_name']] [] = date('Y-m-d H:i',strtotime($doseDate));
						}
						$doseDate = date('Y-m-d H:i:s',strtotime($doseDate)+3600*5040);
					}
					ksort($timeArray);
					break;
				default: /** STAT , NOW  */
					$timeArray[0][] = $dayArray['0']." ".substr($freqTime['NewCropPrescription']['firstdose'], 11, -3);
					$scheduleDrugTimes[$freqTime['NewCropPrescription']['drug_name']] [] = $dayArray['0']." ".substr($freqTime['NewCropPrescription']['firstdose'], 11, -3);

					$timeArray[1][] = $dayArray['1']." ".substr($freqTime['NewCropPrescription']['firstdose'], 11, -3);
					$scheduleDrugTimes[$freqTime['NewCropPrescription']['drug_name']] [] = $dayArray['1']." ".substr($freqTime['NewCropPrescription']['firstdose'], 11, -3);

					$timeArray[2][] = $dayArray['2']." ".substr($freqTime['NewCropPrescription']['firstdose'], 11, -3);
					$scheduleDrugTimes[$freqTime['NewCropPrescription']['drug_name']] [] = $dayArray['2']." ".substr($freqTime['NewCropPrescription']['firstdose'], 11, -3);

					break;
			}

			/*
			 * calculation for administered medication
			*/
			if(!empty($freqTime['MedicationAdministeringRecord'])){
				for($countVar=0;$countVar<count($freqTime['MedicationAdministeringRecord']);$countVar++){
					$performed_datetime = DateFormatComponent::formatDate2Local($freqTime['MedicationAdministeringRecord'][$countVar]['performed_datetime'],Configure::read('date_format'),true);
					$performed_datetime = substr(DateFormatComponent::formatDate2STDForReport($performed_datetime,Configure::read('date_format')),0 , 16 );
					$timeArray['3'][] = $performed_datetime;
				}
			}

			/*****************/
		}
		/**
		 * sorting array values in ASC order
		 */
		$key=0;
		foreach($timeArray as $arrayTime){
			for($i=0;$i<count($arrayTime);$i++){
				$timeOrd[$key][] = strtotime($arrayTime[$i]);
			}
			$key++;
		}
		for($i=0;$i<count($timeOrd);$i++){
			//Returns sorted array
			array_multisort($timeOrd[$i], SORT_DESC, $timeArray[$i]);
			//Returns unique values in array
			$timeArray[$i] = array_unique($timeArray[$i]);
		}
		$key=0;
		foreach($scheduleDrugTimes as $aryKey=>$DrugTimes){
			for($i=0;$i<count($DrugTimes);$i++){
				$drugOrd[$key][] = strtotime($DrugTimes[$i]);
			}
			$schKey[] =  $aryKey;
			$key++;
		}
		for($i=0;$i<count($drugOrd);$i++){
			//Returns sorted array
			array_multisort($drugOrd[$i], SORT_DESC, $scheduleDrugTimes[$schKey[$i]]);
		}

		return array($timeArray,$scheduleDrugTimes);

	}

	function medToAdministerNow($patientId=null){
		$session = new cakeSession();
		$NewCropPrescription = ClassRegistry::init('NewCropPrescription');
		$MedicationAdministeringRecord = ClassRegistry::init('MedicationAdministeringRecord');
		$NewCropPrescription->bindModel(array(
				'hasOne'=>array('PatientOrder'=>array('foreignKey'=>false,
						'conditions'=>array('PatientOrder.id=NewCropPrescription.patient_order_id')))
		));
		$intravenousRoute = configure::read('selected_route_administration');
		$scheduledMed = $NewCropPrescription->find('all',array('fields'=>array('PatientOrder.sentence','id','drug_name','frequency','route',
				'firstdose','medication_administering_time'),
				'conditions'=>array('archive'=>'N','prn'=>'0','firstdose <='=>date('Y-m-d H:i:s'),'route NOT'=>array($intravenousRoute['INTRAVENOUS'],$intravenousRoute['INJECT INTRAMUSCULAR']),
						'NewCropPrescription.patient_uniqueid'=>$patientId,'NewCropPrescription.location_id'=>$session->read('locationid')),
				'order'=>array('NewCropPrescription.id DESC')));
		//debug($scheduledMed);//$cnt=0;
		foreach($scheduledMed as $checkTime){
			$firstDose = DateFormatComponent::formatDate2Local($checkTime['NewCropPrescription']['firstdose'],Configure::read('date_format'),true);
			$medicationAdministeringTime = DateFormatComponent::formatDate2Local($checkTime['NewCropPrescription']['medication_administering_time'],Configure::read('date_format'),true);
			
			$medHour = $this->frequencyHours[$checkTime['NewCropPrescription']['frequency']];
			$timeResult = $this->getScheduleOverdueMedications($firstDose,$medicationAdministeringTime,$medHour);

			if(!empty($timeResult['0'])){
				// $adminMed['0'] array for scheduled medication
				$adminMed['0'][$checkTime['NewCropPrescription']['drug_name']]['0'] = $checkTime['PatientOrder']['sentence'];
				$adminMed['0'][$checkTime['NewCropPrescription']['drug_name']]['1'] = $timeResult['0'];
				$adminMed['0'][$checkTime['NewCropPrescription']['drug_name']]['2'] = $checkTime['NewCropPrescription']['id'];
				$adminMed['0'][$checkTime['NewCropPrescription']['drug_name']]['3'] = $checkTime['NewCropPrescription']['route'];
			}else if(!empty($timeResult['1'])){
				// $adminMed['1'] array for overdue medication
				$adminMed['1'][$checkTime['NewCropPrescription']['drug_name']]['0'] = $checkTime['PatientOrder']['sentence'];
				$adminMed['1'][$checkTime['NewCropPrescription']['drug_name']]['1'] = $timeResult['1'];
				$adminMed['1'][$checkTime['NewCropPrescription']['drug_name']]['2'] = $checkTime['NewCropPrescription']['id'];
				$adminMed['1'][$checkTime['NewCropPrescription']['drug_name']]['3'] = $checkTime['NewCropPrescription']['route'];
			}
			$cnt++;
		}

		return $adminMed;
	}
	private function getScheduleOverdueMedications($firstDose,$lastAdministeredTime,$hourCounter){

		//echo $firstDose.'<br>';

		if( strtotime($firstDose) < strtotime('-3 days')){
			$ThreeDaysBackTime = round(abs(strtotime($firstDose)-strtotime('-3 days'))/(3600*24)) ;
			$firstDose = date('Y-m-d H:i:s',strtotime($firstDose) + ((3600*24)*$ThreeDaysBackTime));
		}
		for($i = strtotime($firstDose);$i<= strtotime(date('Y-m-d H:i:s',strtotime("$hourCounter hours")));$i+=3600*$hourCounter){
			$curentPrescTimeArr[] = date("Y-m-d H:i:s",$i);
		}
		//pr($curentPrescTimeArr);
		$curentPrescTime = array_pop($curentPrescTimeArr);
		$lastPrescTime = array_pop($curentPrescTimeArr);
		$currentTime = strtotime(date('Y-m-d H:i:s'));
		$nextPrescTime = $curentPrescTime+(3600*$hourCounter);

		//echo $curentPrescTime.'NEW----1---'.$lastAdministeredTime.'-----------'.$lastPrescTime.'----------'.$currentTime.'<br><br>';
			
		//$scheduleLimit =  strtotime(date('Y-m-d H:i:s',strtotime('+1 hour')));

		$lastAdministeredTime = strtotime($lastAdministeredTime);
		$lastPrescTime = strtotime($lastPrescTime);

		$preMinutesTime = explode(" ",$curentPrescTime);
		$preMinutesTime = $preMinutesTime[1];
		$preMinutesTime = explode(":",$preMinutesTime);
		$preMinutesTime = ((int) $preMinutesTime[1] * 60) + (int) $preMinutesTime[2];

		$curentPrescTime = strtotime($curentPrescTime);

		$currMinutesTime = explode(" ",date("Y-m-d H:i:s"));
		$currMinutesTime = $currMinutesTime[1];
		$currMinutesTime = explode(":",$currMinutesTime);
		$currMinutesTime = ((int) $currMinutesTime[1] * 60) + (int) $currMinutesTime[2];

		$secondLastPrescTime = $lastPrescTime - (3600*$hourCounter);
		//echo $currMinutesTime.' => '.$preMinutesTime.'<br>';

		//echo date("Y-m-d H:i:s",$lastPrescTime).'NEW---2----'.date("Y-m-d H:i:s",$lastAdministeredTime).'-----------'.date("Y-m-d H:i:s",$lastPrescTime).'----------'.strtotime(date('Y-m-d H:i:s')).'<br><br>';
		//echo $secondLastPrescTime.'---'.$curentPrescTime.'NEW----3---'.$lastAdministeredTime.'-----------'.$lastPrescTime.'----------'.strtotime(date('Y-m-d H:i:s')).'<br><br>';

		if($currMinutesTime >= $preMinutesTime){
			$lastPrescTimeTemp = $curentPrescTime;
			$curentPrescTime = $lastPrescTime;
			$lastPrescTime = array_pop($curentPrescTimeArr);
			$lastPrescTime = strtotime($lastPrescTime);
			if($lastAdministeredTime > $lastPrescTime){
				$lastPrescTime  = $curentPrescTime;
				$curentPrescTime  = $lastPrescTimeTemp;
			}
			$secondLastPrescTime = $lastPrescTime - (3600*$hourCounter);
			/*echo date("Y-m-d H:i:s",$lastPrescTime).'NEW----4---'.date("Y-m-d H:i:s",$lastAdministeredTime).'-----------'.date("Y-m-d H:i:s",$lastPrescTime).'----------'.strtotime(date('Y-m-d H:i:s')).'<br><br>';
			 echo date("Y-m-d H:i:s",$secondLastPrescTime).'NEW----5---'.date("Y-m-d H:i:s",$curentPrescTime).'-----------'.date("Y-m-d H:i:s",$lastAdministeredTime).'----------'.date('Y-m-d H:i:s',$lastPrescTime).'-----'.strtotime(date('Y-m-d H:i:s')).'<br><br>';
			echo $secondLastPrescTime.'---'.$curentPrescTime.'NEW---6--'.$lastAdministeredTime.'-----'.$lastPrescTime.'-----'.strtotime(date('Y-m-d H:i:s')).'<br><br>';
			*/
			//echo '1---'. date("Y-m-d H:i:s",$lastAdministeredTime).' < '.date("Y-m-d H:i:s",$lastPrescTime).' && '.date("Y-m-d H:i:s",$lastAdministeredTime).' < '.date("Y-m-d H:i:s",$secondLastPrescTime).'<br><br>';
			//echo '2---'. date("Y-m-d H:i:s",$lastAdministeredTime).' > '.date("Y-m-d H:i:s",$secondLastPrescTime).' && '.date("Y-m-d H:i:s",$currentTime).' <= '.date("Y-m-d H:i:s",$curentPrescTime).' && '.date("Y-m-d H:i:s",$lastAdministeredTime).' < '.date("Y-m-d H:i:s",$lastPrescTime).' && '.date("Y-m-d H:i:s",$lastAdministeredTime).' <= '.date("Y-m-d H:i:s",$curentPrescTime).'<br><br>';

			if(($lastAdministeredTime < $lastPrescTime) && (($lastAdministeredTime < $secondLastPrescTime))){
				//echo 'overdue IN';
				$returnArray['1']=date("Y-m-d H:i:s",$lastPrescTime);
				return  $returnArray;
				//(($lastAdministeredTime > $secondLastPrescTime) && ($lastAdministeredTime <= $lastPrescTime))
			}else
				if(($lastAdministeredTime > $secondLastPrescTime) && ($currentTime <= $curentPrescTime) && (($lastAdministeredTime < $lastPrescTime) && ($lastAdministeredTime <= $curentPrescTime))){
				//echo 'scheduled IN';
			$returnArray['0']=date('H:i',$curentPrescTime);
			return $returnArray;
			}
		}else{
			//echo '3---'. date("Y-m-d H:i:s",$lastAdministeredTime).' < '.date("Y-m-d H:i:s",$lastPrescTime).' && '.date("Y-m-d H:i:s",$lastAdministeredTime).' < '.date("Y-m-d H:i:s",$secondLastPrescTime).'<br><br>';
			//echo '4---'. date("Y-m-d H:i:s",$lastAdministeredTime).' > '.date("Y-m-d H:i:s",$secondLastPrescTime).' && '.date("Y-m-d H:i:s",$currentTime).' <= '.date("Y-m-d H:i:s",$curentPrescTime).' && '.date("Y-m-d H:i:s",$lastAdministeredTime).' < '.date("Y-m-d H:i:s",$lastPrescTime).' && '.date("Y-m-d H:i:s",$lastAdministeredTime).' <= '.date("Y-m-d H:i:s",$curentPrescTime).'<br><br>';
			if(($lastAdministeredTime < $lastPrescTime) && (($lastAdministeredTime < $secondLastPrescTime))){
				//echo 'overdue';
				$returnArray['1']=date("Y-m-d H:i:s",$lastPrescTime);
				return  $returnArray;
				//(($lastAdministeredTime > $secondLastPrescTime) && ($lastAdministeredTime <= $lastPrescTime))
			}else
				if(($lastAdministeredTime > $secondLastPrescTime) && ($currentTime <= $curentPrescTime) && (($lastAdministeredTime < $lastPrescTime) && ($lastAdministeredTime <= $curentPrescTime))){
				//echo 'scheduled';
			$returnArray['0']=date('H:i',$curentPrescTime);
			return $returnArray;
			}
		}
		//exit;
	}

}
?>