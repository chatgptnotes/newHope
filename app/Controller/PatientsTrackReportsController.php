<?php
/**
 * PatientsTrackReportsController file
 *
 * PHP 5
 *
 * @copyright     Copyright 2013 drmhope Inc.  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       PatientsTrackReportsController
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Santosh R. Yadav
 */

class PatientsTrackReportsController extends AppController {

	public $name = 'PatientsTrackReports';
	public $uses = array('NewCropPrescription');
	public $helpers = array('Html','Form', 'Js', 'JsFusionChart','General','DateFormat');
	public $components = array('RequestHandler','Email', 'Session','DateFormat');



	/**
	 * index method
	 *
	 * @param string $id
	 * @return void
	*/
	public function index($patientid){

			
		$this->layout = 'advance' ;
		$this->uses = array('LaboratoryResult', 'ReviewPatientDetail', 'Patient', 'ReviewSubCategory', 'ReviewSubCategoriesOption', 'LaboratoryHl7Result', 'NewCropPrescription');
		$patientuid = $this->Patient->read('patient_id', $patientid);
		$date = $this->request->data['PatientsTrackReport']['date'];
		$splittedDate = explode(" ",$this->DateFormat->formatDate2STDForReport($date,Configure::read('date_format')));

		if(!empty($date)){
			$chartDate= $splittedDate[0];
			$this->set('chartDate',$splittedDate[0]);
		}else{
			$chartDate= date('Y-m-d');
			$this->set('chartDate',''); //set blank
		}
			
		$firstVisitPatientId = $this->Patient->find('first', array('fields' => array('Patient.id'),
				'conditions' => array('Patient.patient_id' => $patientuid['Patient']['patient_id']), 'order' => array('Patient.id DESC')));
		$previousVisitPatientId = $this->Patient->find('first', array('fields' => array('Patient.id'),
				'conditions' => array('Patient.patient_id' => $patientuid['Patient']['patient_id'], 'Patient.id NOT' => $firstVisitPatientId['Patient']['id']), 'order' => array('Patient.id DESC')));
		$this->patient_info($patientid);

		// for labs status report //
		$this->LaboratoryResult->bindModel(array(
				'belongsTo' => array(
						'Laboratory'=>array('foreignKey'=>'laboratory_id'),
						'TestGroup'=>array('foreignKey'=>false, 'conditions' => array('TestGroup.id=Laboratory.test_group_id')),
				)));

		// lab category given to patient //
		$getLabsGroupList = $this->LaboratoryResult->find('all', array(
				'conditions' => array('LaboratoryResult.patient_id' => $patientid, 'TestGroup.name NOT' => NULL),
				'fields' => array('TestGroup.name', 'TestGroup.id'), 'group' => array('TestGroup.name')));

		$this->set('getLabsGroupList', $getLabsGroupList);

		/* $this->LaboratoryHl7Result->bindModel(array(
		 'belongsTo' => array(
		 		'Laboratory'=>array('foreignKey'=>false,
		 				'conditions' => array('Laboratory.lonic_code=LaboratoryHl7Result.observations')),
		 		'LaboratoryResult'=>array('foreignKey'=>false,
		 				'conditions' => array('LaboratoryResult.id=LaboratoryHl7Result.laboratory_result_id')),
		 )), false); */
		$this->LaboratoryHl7Result->bindModel(array(
				'belongsTo' => array(
						'LaboratoryResult'=>array('foreignKey'=>false,
								'conditions' => array('LaboratoryResult.id=LaboratoryHl7Result.laboratory_result_id')),
						'Laboratory'=>array('foreignKey'=>false, 'conditions' => array('Laboratory.id=LaboratoryHl7Result.laboratory_id')),
						'LaboratoryParameter'=>array('foreignKey'=>false, 'conditions' => array('LaboratoryHl7Result.laboratory_parameter_id=LaboratoryParameter.id')),


				)), false);


		// set lab results with past value //
		$getOrderLabsStatusList = $this->LaboratoryHl7Result->find('all', array(
				'conditions' => array('LaboratoryResult.patient_id' => $patientid),
				'fields' => array('LaboratoryParameter.name','LaboratoryParameter.id','Laboratory.test_group_id', 'Laboratory.name',/*'LaboratoryResult.od_universal_service_text',*/'LaboratoryHl7Result.observation_alt_text', 'Laboratory.id', 'Laboratory.lonic_code',
						'LaboratoryHl7Result.result', 'LaboratoryHl7Result.observations','LaboratoryHl7Result.date_time_of_observation'),
				'order' => array('LaboratoryHl7Result.date_time_of_observation DESC')));
		foreach($getOrderLabsStatusList as $getOrderLabsStatusListVal) {
			$getPastValueWithLaboratory[$getOrderLabsStatusListVal['Laboratory']['test_group_id']][$getOrderLabsStatusListVal['LaboratoryParameter']['id']][] = $getOrderLabsStatusListVal['LaboratoryHl7Result']['result'];
		}

		$this->set('getPastValueWithLaboratory', $getPastValueWithLaboratory);
		// get unique lab name given to patient //
		//$getLabsStatusList = $this->LaboratoryHl7Result->find('all', array('conditions' => array('LaboratoryResult.patient_id' => $patientid),
		///		'fields' => array('LaboratoryParameter.name','LaboratoryParameter.id','Laboratory.test_group_id', 'Laboratory.name', 'LaboratoryResult.od_universal_service_text','LaboratoryHl7Result.observation_alt_text','Laboratory.lonic_code'), 'group' => array('LaboratoryHl7Result.observations')));
		$getLabsStatusList = $getOrderLabsStatusList;
		$this->set('getLabsStatusList', $getOrderLabsStatusList);
		//echo '<pre>';print_r($getOrderLabsStatusList);exit;
		// end labs status report //

		$this->ReviewPatientDetail->bindModel(array(
				'belongsTo'=>array(
						'ReviewSubCategory'=>array('foreignKey'=>false, 'conditions' => array('ReviewSubCategory.id=ReviewPatientDetail.review_sub_categories_id', 'ReviewPatientDetail.is_deleted' => 0
						)),
						'ReviewCategory'=>array('foreignKey'=>false, 'conditions' => array('ReviewCategory.id=ReviewSubCategory.review_category_id', 'ReviewPatientDetail.is_deleted' => 0
						)),
						'ReviewSubCategoriesOption'=>array('foreignKey'=>false, 'conditions' => array('ReviewPatientDetail.review_sub_categories_options_id=ReviewSubCategoriesOption.id'
						)),
							
				)), false);
		// respiratory status report for last 6 hours //
		if(!empty($date)){
			//selected date
			$getRespiratoryStatusList = $this->ReviewPatientDetail->find('all', array('conditions' => array('ReviewPatientDetail.patient_id' => $patientid,
					'ReviewPatientDetail.date' => $date ),
					'fields' => array('ReviewCategory.name', 'ReviewSubCategory.name',  'ReviewPatientDetail.values'),
					'order' => array('ReviewCategory.name DESC')) ) ;
		}else{
			//for current date
			if(date('H') >= 6) {
				$dateRange = date('Y-m-d');
				$lastHour = date('H')-6;
				$hourRange1 =  array($lastHour, date('H'));
				$getRespiratoryStatusList = $this->ReviewPatientDetail->find('all', array('conditions' => array('ReviewPatientDetail.patient_id' => $patientid,
						'ReviewPatientDetail.date' => $dateRange, 'ReviewPatientDetail.hourSlot BETWEEN ? AND ?' => $hourRange1),
						'fields' => array('ReviewCategory.name', 'ReviewSubCategory.name',  'ReviewPatientDetail.values'),
						'order' => array('ReviewCategory.name DESC')));
			} else {
				$dateRange = array(date('Y-m-d', strtotime(date('Y-m-d'). ' - 1 day')), date('Y-m-d'));
				$lastHour = 24-(6 - date('H'));
				$hourRange1 =  array($lastHour, 24);
				$hourRange2 = array(1, date('H'));
				$getRespiratoryStatusList = $this->ReviewPatientDetail->find('all', array('conditions' => array('ReviewPatientDetail.patient_id' => $patientid,
						'OR' => array(array('ReviewPatientDetail.date' => $dateRange[0], 'CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $hourRange1),
								array('ReviewPatientDetail.date' => $dateRange[1], 'CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $hourRange2))),
						'fields' => array('ReviewCategory.name', 'ReviewSubCategory.name', 'ReviewSubCategoriesOption.name', 'ReviewPatientDetail.values'),
						'order' => array('ReviewCategory.name DESC')));
			}
		}


		$this->set('getRespiratoryStatusList', $getRespiratoryStatusList);

		// intake/output report //
		$lastThreeDays = array(date('Y-m-d', strtotime($chartDate. ' - 6 day')), $chartDate);
		$getIntakeOutput = $this->ReviewPatientDetail->find('all', array('conditions' => array('ReviewSubCategory.parameter' => array('intake', 'output'),
				'ReviewPatientDetail.patient_id' => $patientid, 'ReviewPatientDetail.edited_on' => NULL,
				'ReviewPatientDetail.date BETWEEN ? AND ?' => $lastThreeDays),
				'fields' => array('ReviewSubCategory.parameter', 'ReviewCategory.name', 'ReviewSubCategory.name', 'ReviewSubCategory.id',
						'SUM(ReviewPatientDetail.values) AS value', 'ReviewPatientDetail.date'),  'order' => array('ReviewSubCategory.name ASC'),
				'group' => array('ReviewPatientDetail.review_sub_categories_id', 'ReviewPatientDetail.date')));
		foreach($getIntakeOutput as $getIntakeOutputVal) {
			$allIntakeOutputStack[$getIntakeOutputVal['ReviewSubCategory']['id']][$getIntakeOutputVal['ReviewPatientDetail']['date']]=$getIntakeOutputVal[0]['value'];
		}
		$this->set('allIntakeOutputStack', $allIntakeOutputStack);
		$allSubCategories = $this->ReviewSubCategory->find('all', array('conditions' => array('ReviewSubCategory.parameter' => array('intake', 'output'))));
		$this->set('allSubCategories', $allSubCategories);
		$getMeanIntakeOutput = $this->ReviewPatientDetail->find('all', array('conditions' => array('ReviewSubCategory.parameter' => array('intake', 'output'),
				'ReviewPatientDetail.patient_id' => $patientid, 'ReviewPatientDetail.edited_on' => NULL,
				'ReviewPatientDetail.date BETWEEN ? AND ?' => $lastThreeDays),
				'fields' => array('ReviewSubCategory.parameter', 'ReviewCategory.name', 'ReviewSubCategory.name',
						'SUM(ReviewPatientDetail.values) AS value', 'ReviewPatientDetail.date'),
				'group' => array('ReviewSubCategory.parameter', 'ReviewPatientDetail.date')));
		foreach($getMeanIntakeOutput as $getMeanIntakeOutputVal) {
			$getStackMeanIntakeOutput[$getMeanIntakeOutputVal['ReviewSubCategory']['parameter']][$getMeanIntakeOutputVal['ReviewPatientDetail']['date']]  = $getMeanIntakeOutputVal[0]['value'];
		}

		$this->set('getStackMeanIntakeOutput', $getStackMeanIntakeOutput);


		$this->ReviewPatientDetail->bindModel(array(
				'belongsTo'=>array('ReviewSubCategoriesOption'=>array('foreignKey'=>'review_sub_categories_options_id'),
				)), false);
		// for respiratory status report //

		// respiratory //
		$latestRespiratoryTime = $this->ReviewPatientDetail->find('all', array('fields' => array('ReviewPatientDetail.hourSlot'),
				'conditions' => array('ReviewPatientDetail.patient_id' => $patientid, 'ReviewPatientDetail.date' => $chartDate,
						'ReviewSubCategory.name' => array(Configure::read('vital_sign'),Configure::read('ventilator_subset')) , 'ReviewPatientDetail.edited_on' => NULL),
				'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) DESC'), 'group' => array('ReviewPatientDetail.hourSlot'), 'limit' => 2));
		$this->set('latestRespiratoryTime', $latestRespiratoryTime);

		$getRespiratory = $this->ReviewPatientDetail->find('all', array('fields' => array('ReviewPatientDetail.hourSlot', 'ReviewPatientDetail.values', 'ReviewSubCategoriesOption.unit'), 'conditions' => array('ReviewPatientDetail.patient_id' => $patientid, 'ReviewPatientDetail.date' => $chartDate, 'ReviewSubCategoriesOption.name' => Configure::read('respiratory_rate'), 'ReviewPatientDetail.edited_on' => NULL), 'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) DESC'), 'limit' => 2));
		$getOxygenTherapy = $this->ReviewPatientDetail->find('all', array('fields' => array('ReviewPatientDetail.hourSlot', 'ReviewPatientDetail.values', 'ReviewSubCategoriesOption.unit'),'conditions' => array('ReviewPatientDetail.patient_id' => $patientid, 'ReviewPatientDetail.date' => $chartDate, 'ReviewSubCategoriesOption.name' => Configure::read('oxygen_therapy'), 'ReviewPatientDetail.edited_on' => NULL), 'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) DESC'), 'limit' => 2));
		$getSpO2 = $this->ReviewPatientDetail->find('all', array('fields' => array('ReviewPatientDetail.hourSlot', 'ReviewPatientDetail.values', 'ReviewSubCategoriesOption.unit'),'conditions' => array('ReviewPatientDetail.patient_id' => $patientid, 'ReviewPatientDetail.date' => $chartDate, 'ReviewSubCategoriesOption.name' => Configure::read('spo2'), 'ReviewPatientDetail.edited_on' => NULL), 'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) DESC'), 'limit' => 2));
		$this->set(compact('getRespiratory', 'getOxygenTherapy', 'getSpO2'));
		//ventilator //
		$getMode = $this->ReviewPatientDetail->find('all', array('fields' => array('ReviewPatientDetail.hourSlot', 'ReviewPatientDetail.values', 'ReviewSubCategoriesOption.unit'),'conditions' => array('ReviewPatientDetail.patient_id' => $patientid, 'ReviewPatientDetail.date' => $chartDate, 'ReviewSubCategoriesOption.name' => Configure::read('ventilator_mode'), 'ReviewPatientDetail.edited_on' => NULL), 'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) DESC'), 'limit' => 2));
		$getTVSet = $this->ReviewPatientDetail->find('all', array('fields' => array('ReviewPatientDetail.hourSlot', 'ReviewPatientDetail.values', 'ReviewSubCategoriesOption.unit'),'conditions' => array('ReviewPatientDetail.patient_id' => $patientid, 'ReviewPatientDetail.date' => $chartDate, 'ReviewSubCategoriesOption.name' => Configure::read('tidal_volume_set'), 'ReviewPatientDetail.edited_on' => NULL), 'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) DESC'), 'limit' => 2));
		$getTVInhaled = $this->ReviewPatientDetail->find('all', array('fields' => array('ReviewPatientDetail.hourSlot', 'ReviewPatientDetail.values', 'ReviewSubCategoriesOption.unit'),'conditions' => array('ReviewPatientDetail.patient_id' => $patientid, 'ReviewPatientDetail.date' => $chartDate, 'ReviewSubCategoriesOption.name' => Configure::read('tidal_volume_inhaled'), 'ReviewPatientDetail.edited_on' => NULL), 'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) DESC'), 'limit' => 2));
		$getTVExhaled = $this->ReviewPatientDetail->find('all', array('fields' => array('ReviewPatientDetail.hourSlot', 'ReviewPatientDetail.values', 'ReviewSubCategoriesOption.unit'),'conditions' => array('ReviewPatientDetail.patient_id' => $patientid, 'ReviewPatientDetail.date' => $chartDate, 'ReviewSubCategoriesOption.name' => Configure::read('tidal_volume_exhaled'), 'ReviewPatientDetail.edited_on' => NULL), 'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) DESC'), 'limit' => 2));
		$getRate = $this->ReviewPatientDetail->find('all', array('fields' => array('ReviewPatientDetail.hourSlot', 'ReviewPatientDetail.values', 'ReviewSubCategoriesOption.unit'),'conditions' => array('ReviewPatientDetail.patient_id' => $patientid, 'ReviewPatientDetail.date' => $chartDate, 'ReviewSubCategoriesOption.name' => Configure::read('rate'), 'ReviewPatientDetail.edited_on' => NULL), 'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) DESC'), 'limit' => 2));
		$getMAwP = $this->ReviewPatientDetail->find('all', array('fields' => array('ReviewPatientDetail.hourSlot', 'ReviewPatientDetail.values', 'ReviewSubCategoriesOption.unit'),'conditions' => array('ReviewPatientDetail.patient_id' => $patientid, 'ReviewPatientDetail.date' => $chartDate, 'ReviewSubCategoriesOption.name' => Configure::read('mean_airway_pressure'), 'ReviewPatientDetail.edited_on' => NULL), 'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) DESC'), 'limit' => 2));
		$getPIP = $this->ReviewPatientDetail->find('all', array('fields' => array('ReviewPatientDetail.hourSlot', 'ReviewPatientDetail.values', 'ReviewSubCategoriesOption.unit'),'conditions' => array('ReviewPatientDetail.patient_id' => $patientid, 'ReviewPatientDetail.date' =>$chartDate, 'ReviewSubCategoriesOption.name' => Configure::read('peak_inspiratory_pressure'), 'ReviewPatientDetail.edited_on' => NULL), 'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) DESC'), 'limit' => 2));
		$getPEEP = $this->ReviewPatientDetail->find('all', array('fields' => array('ReviewPatientDetail.hourSlot', 'ReviewPatientDetail.values', 'ReviewSubCategoriesOption.unit'),'conditions' => array('ReviewPatientDetail.patient_id' => $patientid, 'ReviewPatientDetail.date' => $chartDate, 'ReviewSubCategoriesOption.name' => Configure::read('positive_end'), 'ReviewPatientDetail.edited_on' => NULL), 'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) DESC'), 'limit' => 2));
		$getPS = $this->ReviewPatientDetail->find('all', array('fields' => array('ReviewPatientDetail.hourSlot', 'ReviewPatientDetail.values', 'ReviewSubCategoriesOption.unit'),'conditions' => array('ReviewPatientDetail.patient_id' => $patientid, 'ReviewPatientDetail.date' => $chartDate, 'ReviewSubCategoriesOption.name' => Configure::read('pressure_support'), 'ReviewPatientDetail.edited_on' => NULL), 'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) DESC'), 'limit' => 2));
		$this->set(compact('getMode', 'getTVSet', 'getTVInhaled','getTVExhaled', 'getRate', 'getMAwP','getPIP', 'getPEEP', 'getPS'));

		/***********************************************/
		if(!empty($date)){
			//selected date
			$last12HoursStr = 	array() ;
			$getVSTemperatureOral1 = $this->ReviewPatientDetail->find('all', array('fields' => array('ReviewPatientDetail.values', 'ReviewPatientDetail.hourSlot'),
					'conditions' => array_merge(array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid, 'ReviewPatientDetail.date' => $chartDate,
							'ReviewSubCategoriesOption.name' =>array(Configure::read('temperature_oral'),Configure::read('temperature_axillary'),Configure::read('temperature_rectal')), 'ReviewPatientDetail.edited_on' => NULL,$last12HoursStr)),
					'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC','ReviewSubCategoriesOption.name =' =>"'".Configure::read('temperature_oral')."'".' DESC')));
		}else{
			//for current date
			if(date('H') >= 11) {
				if(date("H")==23)
				{
					$last12Hours = array(11,2300);

				}
				else {
					$last12Hours = array(date('H', strtotime(date('Y-m-d H:i:s'). ' - 11 hours')), date('H', strtotime(date('Y-m-d H:i:s'). ' + 1 hours'))."00");
				}
				$last12HoursStr =  array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $last12Hours ) ;
				$getVSTemperatureOral1 = $this->ReviewPatientDetail->find('all', array('fields' => array('ReviewPatientDetail.values', 'ReviewPatientDetail.hourSlot'),
						'conditions' => array_merge(array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid, 'ReviewPatientDetail.date' => $chartDate,
								'ReviewSubCategoriesOption.name' =>array(Configure::read('temperature_oral'),Configure::read('temperature_axillary'),Configure::read('temperature_rectal')), 'ReviewPatientDetail.edited_on' => NULL,$last12HoursStr)),
						'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC','ReviewSubCategoriesOption.name ='=>"'".Configure::read('temperature_oral')."'".' DESC')));
			} else {
				$dateRange = array(date('Y-m-d', strtotime(date('Y-m-d'). ' - 1 day')), date('Y-m-d'));
				$lastHour = 24-(12 - date('H'));
				//pr($lastHour);
				$hourRange1 =  array($lastHour, 2400);
				$hourRange2 = array(00, date('H').'00');
				$getVSTemperatureOral1 = $this->ReviewPatientDetail->find('all', array('conditions' =>array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid,
						'ReviewSubCategoriesOption.name' =>array(Configure::read('temperature_oral'),Configure::read('temperature_axillary'),Configure::read('temperature_rectal')), 'ReviewPatientDetail.edited_on' => NULL,
						'OR' => array(array('ReviewPatientDetail.date' => $dateRange[0], 'CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $hourRange1),
								array('ReviewPatientDetail.date' => $dateRange[1], 'CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $hourRange2))),'fields' => array('ReviewPatientDetail.values','ReviewPatientDetail.patient_id', 'ReviewPatientDetail.hourSlot'),
						'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC','ReviewSubCategoriesOption.name = '=>"'".Configure::read('temperature_oral')."'".' DESC')));

			}
		}
		/***********************************************/


		/* if(!empty($date)){
			$last12HoursStr = 	array() ;
		}else{
		$last12Hours = array(date('H', strtotime(date('Y-m-d H:i:s'). ' - 11 hours')), date('H', strtotime(date('Y-m-d H:i:s'). ' + 1 hours'))."00");
		$last12HoursStr =  array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $last12Hours ) ;
		} */
		// vital sign graph //
		// Temperature Axillary,Temperature Oral, Temperature Rectal, Temperature Temporal  line //


		foreach($getVSTemperatureOral1 as $getVSTemperatureOral1Val) {
			if(strlen($getVSTemperatureOral1Val['ReviewPatientDetail']['hourSlot']) == 1) {
				$setTimeIndex = "0".$getVSTemperatureOral1Val['ReviewPatientDetail']['hourSlot'].".00";
			} elseif(strlen($getVSTemperatureOral1Val['ReviewPatientDetail']['hourSlot']) == 2) {
				$setTimeIndex = $getVSTemperatureOral1Val['ReviewPatientDetail']['hourSlot'].".00";
			} else {
				$setTimeString = str_split($getVSTemperatureOral1Val['ReviewPatientDetail']['hourSlot'], 2);
				$setTimeIndex = $setTimeString[0].".".$setTimeString[1];
			}
			$getVSTemperatureOral[$setTimeIndex] = $getVSTemperatureOral1Val['ReviewPatientDetail']['values'];
		}
		/* if(!empty($date)){
			//selected date
		$last12HoursStr = 	array() ;
		$getVSTemperatureAuxillary1 = $this->ReviewPatientDetail->find('all', array('fields' => array('ReviewPatientDetail.values', 'ReviewPatientDetail.hourSlot'),
				'conditions' =>array_merge( array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid, 'ReviewPatientDetail.date' => $chartDate,
						'ReviewSubCategoriesOption.name' => Configure::read('temperature_axillary'), 'ReviewPatientDetail.edited_on' => NULL,$last12HoursStr )),
				'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC')));
		}
		else{
		//for current date
		if(date('H') >= 11) {
		if(date("H")==23)
		{
		$last12Hours = array( 11,2300);

		}
		else {
			
		$last12Hours = array(date('H', strtotime(date('Y-m-d H:i:s'). ' - 11 hours')), date('H', strtotime(date('Y-m-d H:i:s'). ' + 1 hours'))."00");
		}
		//$last12Hours = array(date('H', strtotime(date('Y-m-d H:i:s'). ' - 11 hours')), date('H', strtotime(date('Y-m-d H:i:s'). ' + 1 hours'))."00");
		$last12HoursStr =  array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $last12Hours ) ;
		$getVSTemperatureAuxillary1 = $this->ReviewPatientDetail->find('all', array('fields' => array('ReviewPatientDetail.values', 'ReviewPatientDetail.hourSlot'),
				'conditions' =>array_merge( array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid, 'ReviewPatientDetail.date' => $chartDate,
						'ReviewSubCategoriesOption.name' => Configure::read('temperature_axillary'), 'ReviewPatientDetail.edited_on' => NULL,$last12HoursStr )),
				'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC')));
		}
		else {
		$dateRange = array(date('Y-m-d', strtotime(date('Y-m-d'). ' - 1 day')), date('Y-m-d'));
		$lastHour = 24-(12 - date('H'));
		$hourRange1 =  array($lastHour, 24);
		$hourRange2 = array(00, date('H').'00');
		$getVSTemperatureAuxillary1 = $this->ReviewPatientDetail->find('all', array('conditions' =>array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid,
				'ReviewSubCategoriesOption.name' => Configure::read('temperature_axillary'), 'ReviewPatientDetail.edited_on' => NULL,
				'OR' => array(array('ReviewPatientDetail.date' => $dateRange[0], 'CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $hourRange1),
						array('ReviewPatientDetail.date' => $dateRange[1], 'CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $hourRange2))),'fields' => array('ReviewPatientDetail.values','ReviewPatientDetail.patient_id', 'ReviewPatientDetail.hourSlot'),
				'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC')));
			
		}
		}
		foreach($getVSTemperatureAuxillary1 as $getVSTemperatureAuxillary1Val) {
		if(strlen($getVSTemperatureAuxillary1Val['ReviewPatientDetail']['hourSlot']) == 1) {
		$setTimeIndex = "0".$getVSTemperatureAuxillary1Val['ReviewPatientDetail']['hourSlot'].".00";
		} elseif(strlen($getVSTemperatureAuxillary1Val['ReviewPatientDetail']['hourSlot']) == 2) {
		$setTimeIndex = $getVSTemperatureAuxillary1Val['ReviewPatientDetail']['hourSlot'].".00";
		} else {
		$setTimeString = str_split($getVSTemperatureAuxillary1Val['ReviewPatientDetail']['hourSlot'], 2);
		$setTimeIndex = $setTimeString[0].".".$setTimeString[1];
		}
		$getVSTemperatureAuxillary[$setTimeIndex] = $getVSTemperatureAuxillary1Val['ReviewPatientDetail']['values'];
		}
		if(!empty($date)){
		//selected date
		$last12HoursStr = 	array() ;
		$getVSTemperatureRectal1 = $this->ReviewPatientDetail->find('all', array(
				'fields' => array('ReviewPatientDetail.values','ReviewPatientDetail.hourSlot'),
				'conditions' =>array_merge( array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid, 'ReviewPatientDetail.date' => $chartDate,
						'ReviewSubCategoriesOption.name' => Configure::read('temperature_rectal'),
						'ReviewPatientDetail.edited_on' => NULL, $last12HoursStr)), 'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC')));
		}
		else{
		//for current date
		if(date('H') >= 11) {
		if(date("H")==23)
		{
		$last12Hours = array(11,2300);
		}
		else {
			
		$last12Hours = array(date('H', strtotime(date('Y-m-d H:i:s'). ' - 11 hours')), date('H', strtotime(date('Y-m-d H:i:s'). ' + 1 hours'))."00");
		}
		$last12HoursStr =  array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $last12Hours ) ;
		$getVSTemperatureRectal1 = $this->ReviewPatientDetail->find('all', array(
				'fields' => array('ReviewPatientDetail.values','ReviewPatientDetail.hourSlot'),
				'conditions' =>array_merge( array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid, 'ReviewPatientDetail.date' => $chartDate,
						'ReviewSubCategoriesOption.name' => Configure::read('temperature_rectal'),
						'ReviewPatientDetail.edited_on' => NULL, $last12HoursStr)), 'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC')));
		}
		else {
		$dateRange = array(date('Y-m-d', strtotime(date('Y-m-d'). ' - 1 day')), date('Y-m-d'));
		$lastHour = 24-(12 - date('H'));
		//pr($lastHour);
		$hourRange1 =  array($lastHour, 24);
		$hourRange2 = array(00, date('H').'00');
		$getVSTemperatureRectal1 = $this->ReviewPatientDetail->find('all', array('conditions' =>array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid,
				'ReviewSubCategoriesOption.name' => Configure::read('temperature_rectal'), 'ReviewPatientDetail.edited_on' => NULL,
				'OR' => array(array('ReviewPatientDetail.date' => $dateRange[0], 'CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $hourRange1),
						array('ReviewPatientDetail.date' => $dateRange[1], 'CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $hourRange2))),'fields' => array('ReviewPatientDetail.values','ReviewPatientDetail.patient_id', 'ReviewPatientDetail.hourSlot'),
				'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC')));
			
		}
		}

		foreach($getVSTemperatureRectal1 as $getVSTemperatureRectal1Val) {
		if(strlen($getVSTemperatureRectal1Val['ReviewPatientDetail']['hourSlot']) == 1) {
		$setTimeIndex = "0".$getVSTemperatureRectal1Val['ReviewPatientDetail']['hourSlot'].".00";
		} elseif(strlen($getVSTemperatureRectal1Val['ReviewPatientDetail']['hourSlot']) == 2) {
		$setTimeIndex = $getVSTemperatureRectal1Val['ReviewPatientDetail']['hourSlot'].".00";
		} else {
		$setTimeString = str_split($getVSTemperatureRectal1Val['ReviewPatientDetail']['hourSlot'], 2);
		$setTimeIndex = $setTimeString[0].".".$setTimeString[1];
		}
		$getVSTemperatureRectal[$setTimeIndex] = $getVSTemperatureRectal1Val['ReviewPatientDetail']['values'];
		} */
		// Heart Rate Monitoring, Apical Heart Rate line //
		if(!empty($date)){
			//selected date
			$last12HoursStr = 	array() ;
			$getVSHeartRateMonit1 = $this->ReviewPatientDetail->find('all', array(
					'fields' => array('ReviewPatientDetail.values', 'ReviewPatientDetail.hourSlot'),
					'conditions' =>array_merge( array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid,
							'ReviewPatientDetail.date' => $chartDate, 'ReviewSubCategoriesOption.name' =>array(Configure::read('heart_rate_monit'),Configure::read('apical_heart_rate')) ,
						 'ReviewPatientDetail.edited_on' => NULL,$last12HoursStr)), 'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC','ReviewSubCategoriesOption.name ='=>"'".Configure::read('heart_rate_monit')."'".' DESC')));
		}
		else{
			//for current date
			if(date('H') >= 11) {
				if(date("H")==23)
				{
					$last12Hours = array(11,2300);

				}
				else {

					$last12Hours = array(date('H', strtotime(date('Y-m-d H:i:s'). ' - 11 hours')), date('H', strtotime(date('Y-m-d H:i:s'). ' + 1 hours'))."00");
				}
				$last12HoursStr =  array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $last12Hours ) ;
				$getVSHeartRateMonit1 = $this->ReviewPatientDetail->find('all', array(
						'fields' => array('ReviewPatientDetail.values', 'ReviewPatientDetail.hourSlot'),
						'conditions' =>array_merge( array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid,
								'ReviewPatientDetail.date' => $chartDate, 'ReviewSubCategoriesOption.name' =>array(Configure::read('heart_rate_monit'),Configure::read('apical_heart_rate')),
								'ReviewPatientDetail.edited_on' => NULL,$last12HoursStr)), 'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC','ReviewSubCategoriesOption.name ='=>"'".Configure::read('heart_rate_monit')."'".' DESC')));
			}
			else {
				$dateRange = array(date('Y-m-d', strtotime(date('Y-m-d'). ' - 1 day')), date('Y-m-d'));
				$lastHour = 24-(12 - date('H'));
				//pr($lastHour);
				$hourRange1 =  array($lastHour, 24);
				if(date("H")==00)
				{
					$hourRange2 = array(date('H'), 1000);
				}
				else{
					$hourRange2 = array(1, date('H').'00');
				}
				$getVSHeartRateMonit1 = $this->ReviewPatientDetail->find('all', array('conditions' =>array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid,
						'ReviewSubCategoriesOption.name' =>array(Configure::read('heart_rate_monit'),Configure::read('apical_heart_rate')), 'ReviewPatientDetail.edited_on' => NULL,
						'OR' => array(array('ReviewPatientDetail.date' => $dateRange[0], 'CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $hourRange1),
								array('ReviewPatientDetail.date' => $dateRange[1], 'CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $hourRange2))),'fields' => array('ReviewPatientDetail.values','ReviewPatientDetail.patient_id', 'ReviewPatientDetail.hourSlot'),
						'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC','ReviewSubCategoriesOption.name ='=>"'".Configure::read('heart_rate_monit')."'".' DESC')));
					
			}
		}

		foreach($getVSHeartRateMonit1 as $getVSHeartRateMonit1Val) {
			if(strlen($getVSHeartRateMonit1Val['ReviewPatientDetail']['hourSlot']) == 1) {
				$setTimeIndex = "0".$getVSHeartRateMonit1Val['ReviewPatientDetail']['hourSlot'].".00";
			} elseif(strlen($getVSHeartRateMonit1Val['ReviewPatientDetail']['hourSlot']) == 2) {
				$setTimeIndex = $getVSHeartRateMonit1Val['ReviewPatientDetail']['hourSlot'].".00";
			} else {
				$setTimeString = str_split($getVSHeartRateMonit1Val['ReviewPatientDetail']['hourSlot'], 2);
				$setTimeIndex = $setTimeString[0].".".$setTimeString[1];
			}
			$getVSHeartRateMonit[$setTimeIndex] = $getVSHeartRateMonit1Val['ReviewPatientDetail']['values'];
		}
		/* if(!empty($date)){
			//selected date
		$last12HoursStr = 	array() ;
		$getVSApicalHeartRate1 = $this->ReviewPatientDetail->find('all', array(
				'fields' => array('ReviewPatientDetail.values', 'ReviewPatientDetail.hourSlot'),
				'conditions' => array_merge(array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid,
						'ReviewPatientDetail.date' => $chartDate, 'ReviewSubCategoriesOption.name' => Configure::read('apical_heart_rate'),
						'ReviewPatientDetail.edited_on' => NULL,$last12HoursStr)), 'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC','ReviewSubCategoriesOption.name ='=>"'".Configure::read('heart_rate_monit')."'".' DESC')));
		}
		else{
		//for current date
		if(date('H') >= 11) {
		if(date("H")==23)
		{
		$last12Hours = array(11,2300);

		}
		else {
			
		$last12Hours = array(date('H', strtotime(date('Y-m-d H:i:s'). ' - 11 hours')), date('H', strtotime(date('Y-m-d H:i:s'). ' + 1 hours'))."00");
		}
		$last12HoursStr =  array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $last12Hours ) ;
		$getVSApicalHeartRate1 = $this->ReviewPatientDetail->find('all', array(
				'fields' => array('ReviewPatientDetail.values', 'ReviewPatientDetail.hourSlot'),
				'conditions' => array_merge(array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid,
						'ReviewPatientDetail.date' => $chartDate, 'ReviewSubCategoriesOption.name' => Configure::read('apical_heart_rate'),
						'ReviewPatientDetail.edited_on' => NULL,$last12HoursStr)), 'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC')));
		}
		else {
		$dateRange = array(date('Y-m-d', strtotime(date('Y-m-d'). ' - 1 day')), date('Y-m-d'));
		$lastHour = 24-(12 - date('H'));
		//pr($lastHour);
		$hourRange1 =  array($lastHour, 24);
		$hourRange2 = array(00, date('H').'00');
		$getVSApicalHeartRate1 = $this->ReviewPatientDetail->find('all', array('conditions' =>array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid,
				'ReviewSubCategoriesOption.name' => Configure::read('apical_heart_rate'), 'ReviewPatientDetail.edited_on' => NULL,
				'OR' => array(array('ReviewPatientDetail.date' => $dateRange[0], 'CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $hourRange1),
						array('ReviewPatientDetail.date' => $dateRange[1], 'CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $hourRange2))),'fields' => array('ReviewPatientDetail.values','ReviewPatientDetail.patient_id', 'ReviewPatientDetail.hourSlot'),
				'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC')));
			
		}
		}

		foreach($getVSApicalHeartRate1 as $getVSApicalHeartRate1Val) {
		if(strlen($getVSApicalHeartRate1Val['ReviewPatientDetail']['hourSlot']) == 1) {
		$setTimeIndex = "0".$getVSApicalHeartRate1Val['ReviewPatientDetail']['hourSlot'].".00";
		} elseif(strlen($getVSApicalHeartRate1Val['ReviewPatientDetail']['hourSlot']) == 2) {
		$setTimeIndex = $getVSApicalHeartRate1Val['ReviewPatientDetail']['hourSlot'].".00";
		} else {
		$setTimeString = str_split($getVSApicalHeartRate1Val['ReviewPatientDetail']['hourSlot'], 2);
		$setTimeIndex = $setTimeString[0].".".$setTimeString[1];
		}
		$getVSApicalHeartRate[$setTimeIndex] = $getVSApicalHeartRate1Val['ReviewPatientDetail']['values'];
		}
		*/
		// Respiratory Rate line
		if(!empty($date)){
			//selected date
			$last12HoursStr = 	array() ;
			$getVSRespiratoryRate1 = $this->ReviewPatientDetail->find('all', array(
					'fields' => array('ReviewPatientDetail.values', 'ReviewPatientDetail.hourSlot'),
					'conditions' =>array_merge( array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid,
							'ReviewPatientDetail.date' => $chartDate, 'ReviewSubCategoriesOption.name' => Configure::read('respiratory_rate'),
						 'ReviewPatientDetail.edited_on' => NULL,$last12HoursStr)), 'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC')));
		}
		else{
			//for current date
			if(date('H') >= 11) {
				if(date("H")==23)
				{
					$last12Hours = array( 11,2300);

				}
				else {

					$last12Hours = array(date('H', strtotime(date('Y-m-d H:i:s'). ' - 11 hours')), date('H', strtotime(date('Y-m-d H:i:s'). ' + 1 hours'))."00");
				}
				$last12HoursStr =  array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $last12Hours ) ;
				$getVSRespiratoryRate1 = $this->ReviewPatientDetail->find('all', array(
						'fields' => array('ReviewPatientDetail.values', 'ReviewPatientDetail.hourSlot'),
						'conditions' =>array_merge( array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid,
								'ReviewPatientDetail.date' => $chartDate, 'ReviewSubCategoriesOption.name' => Configure::read('respiratory_rate'),
								'ReviewPatientDetail.edited_on' => NULL,$last12HoursStr)), 'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC')));
			}
			else {
				$dateRange = array(date('Y-m-d', strtotime(date('Y-m-d'). ' - 1 day')), date('Y-m-d'));
				$lastHour = 24-(12 - date('H'));
				//pr($lastHour);
				$hourRange1 =  array($lastHour, 24);
				$hourRange2 = array(00, date('H').'00');
				$getVSRespiratoryRate1 = $this->ReviewPatientDetail->find('all', array('conditions' =>array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid,
						'ReviewSubCategoriesOption.name' => Configure::read('respiratory_rate'), 'ReviewPatientDetail.edited_on' => NULL,
						'OR' => array(array('ReviewPatientDetail.date' => $dateRange[0], 'CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $hourRange1),
								array('ReviewPatientDetail.date' => $dateRange[1], 'CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $hourRange2))),'fields' => array('ReviewPatientDetail.values','ReviewPatientDetail.patient_id', 'ReviewPatientDetail.hourSlot'),
						'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC')));
					
			}
		}

		foreach($getVSRespiratoryRate1 as $getVSRespiratoryRate1Val) {
			if(strlen($getVSRespiratoryRate1Val['ReviewPatientDetail']['hourSlot']) == 1) {
				$setTimeIndex = "0".$getVSRespiratoryRate1Val['ReviewPatientDetail']['hourSlot'].".00";
			} elseif(strlen($getVSRespiratoryRate1Val['ReviewPatientDetail']['hourSlot']) == 2) {
				$setTimeIndex = $getVSRespiratoryRate1Val['ReviewPatientDetail']['hourSlot'].".00";
			} else {
				$setTimeString = str_split($getVSRespiratoryRate1Val['ReviewPatientDetail']['hourSlot'], 2);
				$setTimeIndex = $setTimeString[0].".".$setTimeString[1];
			}
			$getVSRespiratoryRate[$setTimeIndex] = $getVSRespiratoryRate1Val['ReviewPatientDetail']['values'];
		}
		// SpO2 line
		if(!empty($date)){
			//selected date
			$last12HoursStr = 	array() ;
			$getVSSpO21 = $this->ReviewPatientDetail->find('all', array(
					'fields' => array('ReviewPatientDetail.values', 'ReviewPatientDetail.hourSlot'),
					'conditions' =>array_merge( array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid,
							'ReviewPatientDetail.date' => $chartDate, 'ReviewSubCategoriesOption.name' => Configure::read('spo2'),
							'ReviewPatientDetail.edited_on' => NULL,$last12HoursStr)),
				 'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC')));
		}
		else{
			//for current date
			if(date('H') >= 11) {
				if(date("H")==23)
				{
					$last12Hours = array( 11,2300);

				}
				else {

					$last12Hours = array(date('H', strtotime(date('Y-m-d H:i:s'). ' - 11 hours')), date('H', strtotime(date('Y-m-d H:i:s'). ' + 1 hours'))."00");
				}
				$last12HoursStr =  array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $last12Hours ) ;
				$getVSSpO21 = $this->ReviewPatientDetail->find('all', array(
						'fields' => array('ReviewPatientDetail.values', 'ReviewPatientDetail.hourSlot'),
						'conditions' =>array_merge( array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid,
								'ReviewPatientDetail.date' => $chartDate, 'ReviewSubCategoriesOption.name' => Configure::read('spo2'),
								'ReviewPatientDetail.edited_on' => NULL,$last12HoursStr)),
						'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC')));
			}
			else {
				$dateRange = array(date('Y-m-d', strtotime(date('Y-m-d'). ' - 1 day')), date('Y-m-d'));
				$lastHour = 24-(12 - date('H'));
				//pr($lastHour);
				$hourRange1 =  array($lastHour, 2400);
				$hourRange2 = array(00, date('H').'00');
				$getVSSpO21 = $this->ReviewPatientDetail->find('all', array('conditions' =>array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid,
						'ReviewSubCategoriesOption.name' => Configure::read('spo2'), 'ReviewPatientDetail.edited_on' => NULL,
						'OR' => array(array('ReviewPatientDetail.date' => $dateRange[0], 'CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $hourRange1),
								array('ReviewPatientDetail.date' => $dateRange[1], 'CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $hourRange2))),'fields' => array('ReviewPatientDetail.values','ReviewPatientDetail.patient_id', 'ReviewPatientDetail.hourSlot'),
						'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC')));
					
			}
		}

		foreach($getVSSpO21 as $getVSSpO21Val) {
			if(strlen($getVSSpO21Val['ReviewPatientDetail']['hourSlot']) == 1) {
				$setTimeIndex = "0".$getVSSpO21Val['ReviewPatientDetail']['hourSlot'].".00";
			} elseif(strlen($getVSSpO21Val['ReviewPatientDetail']['hourSlot']) == 2) {
				$setTimeIndex = $getVSSpO21Val['ReviewPatientDetail']['hourSlot'].".00";
			} else {
				$setTimeString = str_split($getVSSpO21Val['ReviewPatientDetail']['hourSlot'], 2);
				$setTimeIndex = $setTimeString[0].".".$setTimeString[1];
			}
			$getVSSpO2[$setTimeIndex] = $getVSSpO21Val['ReviewPatientDetail']['values'];
		}
		$this->set(compact('getVSTemperatureOral', 'getVSTemperatureAuxillary', 'getVSTemperatureRectal','getVSHeartRateMonit', 'getVSApicalHeartRate', 'getVSRespiratoryRate','getVSSpO2'));
		// hemodynamics graph //
		// Cerebral Perfusion..  line //
		if(!empty($date)){
			//selected date
			$last12HoursStr = 	array() ;
			$getVSCerebralPerfusion1 = $this->ReviewPatientDetail->find('all', array(
					'fields' => array('ReviewPatientDetail.values', 'ReviewPatientDetail.hourSlot'),
					'conditions' => array_merge(array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid,
						 'ReviewPatientDetail.date' => $chartDate, 'ReviewSubCategoriesOption.name' => Configure::read('vital_sign_cerebral_perfusion'),
						 'ReviewPatientDetail.edited_on' => NULL,$last12HoursStr)), 'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC')));
		}
		else{
			//for current date
			if(date('H') >= 11) {
				if(date("H")==23)
				{
					$last12Hours = array(11,2300);

				}
				else {

					$last12Hours = array(date('H', strtotime(date('Y-m-d H:i:s'). ' - 11 hours')), date('H', strtotime(date('Y-m-d H:i:s'). ' + 1 hours'))."00");
				}
				$last12HoursStr =  array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $last12Hours ) ;
				$getVSCerebralPerfusion1 = $this->ReviewPatientDetail->find('all', array(
						'fields' => array('ReviewPatientDetail.values', 'ReviewPatientDetail.hourSlot'),
						'conditions' => array_merge(array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid,
								'ReviewPatientDetail.date' => $chartDate, 'ReviewSubCategoriesOption.name' => Configure::read('vital_sign_cerebral_perfusion'),
								'ReviewPatientDetail.edited_on' => NULL,$last12HoursStr)), 'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC')));
			}
			else {
				$dateRange = array(date('Y-m-d', strtotime(date('Y-m-d'). ' - 1 day')), date('Y-m-d'));
				$lastHour = 24-(12 - date('H'));
				//pr($lastHour);
				$hourRange1 =  array($lastHour, 24);
				$hourRange2 = array(00, date('H').'00');
				$getVSCerebralPerfusion1 = $this->ReviewPatientDetail->find('all', array('conditions' =>array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid,
						'ReviewSubCategoriesOption.name' => Configure::read('vital_sign_cerebral_perfusion'), 'ReviewPatientDetail.edited_on' => NULL,
						'OR' => array(array('ReviewPatientDetail.date' => $dateRange[0], 'CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $hourRange1),
								array('ReviewPatientDetail.date' => $dateRange[1], 'CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $hourRange2))),'fields' => array('ReviewPatientDetail.values','ReviewPatientDetail.patient_id', 'ReviewPatientDetail.hourSlot'),
						'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC')));
					
			}
		}

		foreach($getVSCerebralPerfusion1 as $getVSCerebralPerfusion1Val) {
			if(strlen($getVSCerebralPerfusion1Val['ReviewPatientDetail']['hourSlot']) == 1) {
				$setTimeIndex = "0".$getVSCerebralPerfusion1Val['ReviewPatientDetail']['hourSlot'].".00";
			} elseif(strlen($getVSCerebralPerfusion1Val['ReviewPatientDetail']['hourSlot']) == 2) {
				$setTimeIndex = $getVSCerebralPerfusion1Val['ReviewPatientDetail']['hourSlot'].".00";
			} else {
				$setTimeString = str_split($getVSCerebralPerfusion1Val['ReviewPatientDetail']['hourSlot'], 2);
				$setTimeIndex = $setTimeString[0].".".$setTimeString[1];
			}
			$getVSCerebralPerfusion[$setTimeIndex] = $getVSCerebralPerfusion1Val['ReviewPatientDetail']['values'];
		}

		// Intracranial Pressure line //
		if(!empty($date)){
			//selected date
			$last12HoursStr = 	array() ;
			$getVSIntracranialPressure1 = $this->ReviewPatientDetail->find('all', array(
					'fields' => array('ReviewPatientDetail.values', 'ReviewPatientDetail.hourSlot'),
					'conditions' =>array_merge( array('ReviewPatientDetail.values <>' =>'',
						 'ReviewPatientDetail.patient_id' => $patientid, 'ReviewPatientDetail.date' => $chartDate,
						 'ReviewSubCategoriesOption.name' => Configure::read('vital_sign_intracranial_pressure'),
						 'ReviewPatientDetail.edited_on' => NULL,$last12HoursStr)), 'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC')));
		}
		else{
			//for current date
			if(date('H') >= 11) {
				if(date("H")==23)
				{
					$last12Hours = array( 11,2300);

				}
				else {

					$last12Hours = array(date('H', strtotime(date('Y-m-d H:i:s'). ' - 11 hours')), date('H', strtotime(date('Y-m-d H:i:s'). ' + 1 hours'))."00");
				}
				$last12HoursStr =  array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $last12Hours ) ;
				$getVSIntracranialPressure1 = $this->ReviewPatientDetail->find('all', array(
						'fields' => array('ReviewPatientDetail.values', 'ReviewPatientDetail.hourSlot'),
						'conditions' =>array_merge( array('ReviewPatientDetail.values <>' =>'',
								'ReviewPatientDetail.patient_id' => $patientid, 'ReviewPatientDetail.date' => $chartDate,
								'ReviewSubCategoriesOption.name' => Configure::read('vital_sign_intracranial_pressure'),
								'ReviewPatientDetail.edited_on' => NULL,$last12HoursStr)), 'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC')));
			}
			else {
				$dateRange = array(date('Y-m-d', strtotime(date('Y-m-d'). ' - 1 day')), date('Y-m-d'));
				$lastHour = 24-(12 - date('H'));
				//pr($lastHour);
				$hourRange1 =  array($lastHour, 24);
				$hourRange2 = array(00, date('H').'00');
				$getVSIntracranialPressure1 = $this->ReviewPatientDetail->find('all', array('conditions' =>array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid,
						'ReviewSubCategoriesOption.name' => Configure::read('vital_sign_intracranial_pressure'), 'ReviewPatientDetail.edited_on' => NULL,
						'OR' => array(array('ReviewPatientDetail.date' => $dateRange[0], 'CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $hourRange1),
								array('ReviewPatientDetail.date' => $dateRange[1], 'CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $hourRange2))),'fields' => array('ReviewPatientDetail.values','ReviewPatientDetail.patient_id', 'ReviewPatientDetail.hourSlot'),
						'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC')));
					
			}
		}

		foreach($getVSIntracranialPressure1 as $getVSIntracranialPressure1Val) {
			if(strlen($getVSIntracranialPressure1Val['ReviewPatientDetail']['hourSlot']) == 1) {
				$setTimeIndex = "0".$getVSIntracranialPressure1Val['ReviewPatientDetail']['hourSlot'].".00";
			} elseif(strlen($getVSIntracranialPressure1Val['ReviewPatientDetail']['hourSlot']) == 2) {
				$setTimeIndex = $getVSIntracranialPressure1Val['ReviewPatientDetail']['hourSlot'].".00";
			} else {
				$setTimeString = str_split($getVSIntracranialPressure1Val['ReviewPatientDetail']['hourSlot'], 2);
				$setTimeIndex = $setTimeString[0].".".$setTimeString[1];
			}
			$getVSIntracranialPressure[$setTimeIndex] = $getVSIntracranialPressure1Val['ReviewPatientDetail']['values'];
		}
		// Central Venous Pressure line
		if(!empty($date)){
			//selected date
			$last12HoursStr = 	array() ;
			$getVSCentralVenous1 = $this->ReviewPatientDetail->find('all', array(
					'fields' => array('ReviewPatientDetail.values', 'ReviewPatientDetail.hourSlot'),
					'conditions' =>array_merge( array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid,
							'ReviewPatientDetail.date' => $chartDate, 'ReviewSubCategoriesOption.name' => Configure::read('vital_sign_central_venous'),
						 'ReviewPatientDetail.edited_on' => NULL,$last12HoursStr)),
				 'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC')));
		}
		else{
			//for current date
			if(date('H') >= 11) {
				if(date("H")==23)
				{
					$last12Hours = array(11,2300);

				}
				else {

					$last12Hours = array(date('H', strtotime(date('Y-m-d H:i:s'). ' - 11 hours')), date('H', strtotime(date('Y-m-d H:i:s'). ' + 1 hours'))."00");
				}
				$last12HoursStr =  array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $last12Hours ) ;
				$getVSCentralVenous1 = $this->ReviewPatientDetail->find('all', array(
						'fields' => array('ReviewPatientDetail.values', 'ReviewPatientDetail.hourSlot'),
						'conditions' =>array_merge( array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid,
								'ReviewPatientDetail.date' => $chartDate, 'ReviewSubCategoriesOption.name' => Configure::read('vital_sign_central_venous'),
								'ReviewPatientDetail.edited_on' => NULL,$last12HoursStr)),
						'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC')));
			}
			else {
				$dateRange = array(date('Y-m-d', strtotime(date('Y-m-d'). ' - 1 day')), date('Y-m-d'));
				$lastHour = 24-(12 - date('H'));
				//pr($lastHour);
				$hourRange1 =  array($lastHour, 24);
				$hourRange2 = array(00, date('H').'00');
				$getVSCentralVenous1 = $this->ReviewPatientDetail->find('all', array(
						'conditions' =>array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid,
								'ReviewSubCategoriesOption.name' => Configure::read('vital_sign_central_venous'), 'ReviewPatientDetail.edited_on' => NULL,
								'OR' => array(array('ReviewPatientDetail.date' => $dateRange[0], 'CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $hourRange1),
										array('ReviewPatientDetail.date' => $dateRange[1], 'CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $hourRange2))),
						'fields' => array('ReviewPatientDetail.values','ReviewPatientDetail.patient_id', 'ReviewPatientDetail.hourSlot'),
						'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC')));
					
			}
		}
		foreach($getVSCentralVenous1 as $getVSCentralVenous1Val) {
			if(strlen($getVSCentralVenous1Val['ReviewPatientDetail']['hourSlot']) == 1) {
				$setTimeIndex = "0".$getVSCentralVenous1Val['ReviewPatientDetail']['hourSlot'].".00";
			} elseif(strlen($getVSCentralVenous1Val['ReviewPatientDetail']['hourSlot']) == 2) {
				$setTimeIndex = $getVSCentralVenous1Val['ReviewPatientDetail']['hourSlot'].".00";
			} else {
				$setTimeString = str_split($getVSCentralVenous1Val['ReviewPatientDetail']['hourSlot'], 2);
				$setTimeIndex = $setTimeString[0].".".$setTimeString[1];
			}
			$getVSCentralVenous[$setTimeIndex] = $getVSCentralVenous1Val['ReviewPatientDetail']['values'];
		}
		$this->set(compact('getVSCerebralPerfusion', 'getVSIntracranialPressure', 'getVSCentralVenous'));
		// end hemodynamics graph //

		// vasoactive line graph //
		// NORepinephrine line //

		$getNORepinephrineId=$this->NewCropPrescription->find('list',array('fields'=>array('id'),
				'conditions'=>array('NewCropPrescription.drug_name LIKE'=>"%".Configure::read('continuous_infu_NORepinephrine')."%",
						'NewCropPrescription.patient_uniqueid'=>$patientid,'NewCropPrescription.archive'=>'N')));
		$getNORepinephrineIds=array();
		foreach ($getNORepinephrineId as $primaryId)
		{
			array_push($getNORepinephrineIds,'crop'.$primaryId);
		}
		$getNORepinephrineId=$getNORepinephrineIds;

		if(!empty($date)){
			//selected date
			$last12HoursStr = 	array() ;
			$getNORepinephrine = $this->ReviewPatientDetail->find('all', array(
					'fields' => array('ReviewPatientDetail.values','ReviewPatientDetail.hourSlot'),
					'conditions' =>array_merge( array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid,
						 'ReviewPatientDetail.date' => $chartDate, 'ReviewPatientDetail.review_sub_categories_options_id' => $getNORepinephrineId,
						 'ReviewPatientDetail.edited_on' => NULL,$last12HoursStr)),
				 'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC')));
		}
		else{
			//for current date
			if(date('H') >= 11) {
				if(date("H")==23)
				{
					$last12Hours = array(11,2300);

				}
				else {

					$last12Hours = array(date('H', strtotime(date('Y-m-d H:i:s'). ' - 11 hours')), date('H', strtotime(date('Y-m-d H:i:s'). ' + 1 hours'))."00");
				}
				$last12HoursStr =  array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $last12Hours ) ;
				$getNORepinephrine = $this->ReviewPatientDetail->find('all', array(
						'fields' => array('ReviewPatientDetail.values','ReviewPatientDetail.hourSlot'),
						'conditions' =>array_merge( array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid,
								'ReviewPatientDetail.date' => $chartDate, 'ReviewPatientDetail.review_sub_categories_options_id' => $getNORepinephrineId,
								'ReviewPatientDetail.edited_on' => NULL,$last12HoursStr)),
						'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC')));
			}
			else {
				//for last and current date
				$dateRange = array(date('Y-m-d', strtotime(date('Y-m-d'). ' - 1 day')), date('Y-m-d'));
				$lastHour = 24-(12 - date('H'));
				$hourRange1 =  array($lastHour, 24);
				$hourRange2 = array(00, date('H').'00');

				$getNORepinephrine = $this->ReviewPatientDetail->find('all', array(
						'conditions' =>array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid,
							 'ReviewPatientDetail.review_sub_categories_options_id' => $getNORepinephrineId,'ReviewPatientDetail.edited_on' => NULL,
								'OR' => array(array('ReviewPatientDetail.date' => $dateRange[0], 'CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $hourRange1),
										array('ReviewPatientDetail.date' => $dateRange[1], 'CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $hourRange2))),
						'fields' => array('ReviewPatientDetail.values','ReviewPatientDetail.patient_id', 'ReviewPatientDetail.hourSlot'),
						'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC')));

			}
		}

		foreach($getNORepinephrine as $getNORepinephrineVal) {
			if(strlen($getNORepinephrineVal['ReviewPatientDetail']['hourSlot']) == 1) {
				$setTimeIndex = "0".$getNORepinephrineVal['ReviewPatientDetail']['hourSlot'].".00";
			} elseif(strlen($getNORepinephrineVal['ReviewPatientDetail']['hourSlot']) == 2) {
				$setTimeIndex = $getNORepinephrineVal['ReviewPatientDetail']['hourSlot'].".00";
			} else {
				$setTimeString = str_split($getNORepinephrineVal['ReviewPatientDetail']['hourSlot'], 2);
				$setTimeIndex = $setTimeString[0].".".$setTimeString[1];
			}
			$getVANORepinephrine[$setTimeIndex] = $getNORepinephrineVal['ReviewPatientDetail']['values'];
		}

		// DOPamine line //
		$getDOPamineId=$this->NewCropPrescription->find('list',array(
				'fields'=>array('id'),'conditions'=>array('NewCropPrescription.drug_name LIKE'=>"%".Configure::read('continuous_infu_Dopamine')."%",
						'NewCropPrescription.patient_uniqueid'=>$patientid,'NewCropPrescription.archive'=>'N')));
		$getDOPamineIds=array();
		foreach ($getDOPamineId as $primaryId)
		{
			array_push($getDOPamineIds,'crop'.$primaryId);
		}
		$getDOPamineId=$getDOPamineIds;
		if(!empty($date)){
			//selected date
			$last12HoursStr = 	array() ;
			$getDOPamine = $this->ReviewPatientDetail->find('all', array(
					'fields' => array('ReviewPatientDetail.values','ReviewPatientDetail.hourSlot'),
					'conditions' =>array_merge( array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid,
						 'ReviewPatientDetail.date' => $chartDate, 'ReviewPatientDetail.review_sub_categories_options_id' => $getDOPamineId,
						 'ReviewPatientDetail.edited_on' => NULL,$last12HoursStr)), 'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC')));
		}
		else{
			//for current date
			if(date('H') >= 11) {
				if(date("H")==23)
				{
					$last12Hours = array(11,2300);

				}
				else {

					$last12Hours = array(date('H', strtotime(date('Y-m-d H:i:s'). ' - 11 hours')), date('H', strtotime(date('Y-m-d H:i:s'). ' + 1 hours'))."00");
				}
				$last12HoursStr =  array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $last12Hours ) ;
				$getDOPamine = $this->ReviewPatientDetail->find('all', array(
						'fields' => array('ReviewPatientDetail.values','ReviewPatientDetail.hourSlot'),
						'conditions' =>array_merge( array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid,
								'ReviewPatientDetail.date' => $chartDate, 'ReviewPatientDetail.review_sub_categories_options_id' => $getDOPamineId,
								'ReviewPatientDetail.edited_on' => NULL,$last12HoursStr)), 'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC')));
			}
			else {
				//for last and current date
				$dateRange = array(date('Y-m-d', strtotime(date('Y-m-d'). ' - 1 day')), date('Y-m-d'));
				$lastHour = 24-(12 - date('H'));
				$hourRange1 =  array($lastHour, 24);
				$hourRange2 = array(00, date('H').'00');

				$getDOPamine = $this->ReviewPatientDetail->find('all', array(
						'fields' => array('ReviewPatientDetail.values','ReviewPatientDetail.hourSlot'),
						'conditions' =>array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid,
								'ReviewPatientDetail.review_sub_categories_options_id' => $getDOPamineId,'ReviewPatientDetail.edited_on' => NULL,
								'OR' => array(array('ReviewPatientDetail.date' => $dateRange[0], 'CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $hourRange1),
										array('ReviewPatientDetail.date' => $dateRange[1], 'CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $hourRange2))),
						'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC')));

			}
		}

		foreach($getDOPamine as $getDOPamineVal) {
			if(strlen($getDOPamineVal['ReviewPatientDetail']['hourSlot']) == 1) {
				$setTimeIndex = "0".$getDOPamineVal['ReviewPatientDetail']['hourSlot'].".00";
			} elseif(strlen($getDOPamineVal['ReviewPatientDetail']['hourSlot']) == 2) {
				$setTimeIndex = $getDOPamineVal['ReviewPatientDetail']['hourSlot'].".00";
			} else {
				$setTimeString = str_split($getDOPamineVal['ReviewPatientDetail']['hourSlot'], 2);
				$setTimeIndex = $setTimeString[0].".".$setTimeString[1];
			}
			$getVADOPamine[$setTimeIndex] = $getDOPamineVal['ReviewPatientDetail']['values'];
		}

		$this->set(compact('getVANORepinephrine', 'getVADOPamine'));
		// end vasoactive line graph //

		//vasopressin line graph
		// vasopressin line //
		$getVasopressinId=$this->NewCropPrescription->find('list',array(
				'fields'=>array('id'),'conditions'=>array('NewCropPrescription.drug_name LIKE'=>"%".Configure::read('continuous_infu_Vasopressin')."%",
						'NewCropPrescription.patient_uniqueid'=>$patientid,'NewCropPrescription.archive'=>'N')));
		$getVasopressinIds = array();
		foreach($getVasopressinId as $primaryId){
			array_push($getVasopressinIds, 'crop'.$primaryId);
		}
		$getVasopressinId = $getVasopressinIds;
		if(!empty($date)){
			//selected date
			$last12HoursStr = 	array() ;
			$getVasopressin = $this->ReviewPatientDetail->find('all', array(
					'fields' => array('ReviewPatientDetail.values','ReviewPatientDetail.hourSlot'),
					'conditions' =>array_merge( array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid,
						 'ReviewPatientDetail.date' => $chartDate, 'ReviewPatientDetail.review_sub_categories_options_id' => $getVasopressinId,
							'ReviewPatientDetail.edited_on' => NULL,$last12HoursStr)),
					'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC')));
		}
		else{
			//for current date
			if(date('H') >= 11) {
				if(date("H")==23)
				{
					$last12Hours = array(11,2300);

				}
				else {

					$last12Hours = array(date('H', strtotime(date('Y-m-d H:i:s'). ' - 11 hours')), date('H', strtotime(date('Y-m-d H:i:s'). ' + 1 hours'))."00");
				}
				$last12HoursStr =  array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $last12Hours ) ;
				$getVasopressin = $this->ReviewPatientDetail->find('all', array(
						'fields' => array('ReviewPatientDetail.values','ReviewPatientDetail.hourSlot'),
						'conditions' =>array_merge( array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid,
								'ReviewPatientDetail.date' => $chartDate, 'ReviewPatientDetail.review_sub_categories_options_id' => $getVasopressinId,
								'ReviewPatientDetail.edited_on' => NULL,$last12HoursStr)),
						'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC')));
			}
			else {
				//for last and current date
				$dateRange = array(date('Y-m-d', strtotime(date('Y-m-d'). ' - 1 day')), date('Y-m-d'));
				$lastHour = 24-(12 - date('H'));
				$hourRange1 =  array($lastHour, 24);
				$hourRange2 = array(00, date('H').'00');
				$getVasopressin = $this->ReviewPatientDetail->find('all', array(
						'fields' => array('ReviewPatientDetail.values','ReviewPatientDetail.hourSlot'),
						'conditions' =>array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid,
								'ReviewPatientDetail.review_sub_categories_options_id' => $getVasopressinId,'ReviewPatientDetail.edited_on' => NULL,
								'OR' => array(array('ReviewPatientDetail.date' => $dateRange[0], 'CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $hourRange1),
										array('ReviewPatientDetail.date' => $dateRange[1], 'CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $hourRange2))),
						'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC')));

			}
		}


		foreach($getVasopressin as $getVasopressinVal) {
			if(strlen($getVasopressinVal['ReviewPatientDetail']['hourSlot']) == 1) {
				$setTimeIndex = "0".$getVasopressinVal['ReviewPatientDetail']['hourSlot'].".00";
			} elseif(strlen($getVasopressinVal['ReviewPatientDetail']['hourSlot']) == 2) {
				$setTimeIndex = $getVasopressinVal['ReviewPatientDetail']['hourSlot'].".00";
			} else {
				$setTimeString = str_split($getVasopressinVal['ReviewPatientDetail']['hourSlot'], 2);
				$setTimeIndex = $setTimeString[0].".".$setTimeString[1];
			}
			$getVPVasopressin[$setTimeIndex] = $getVasopressinVal['ReviewPatientDetail']['values'];
		}
		//Esmolol line //
		$getEsmololId=$this->NewCropPrescription->find('list',array('fields'=>array('id'),
				'conditions'=>array('NewCropPrescription.drug_name LIKE'=>"%".Configure::read('continuous_infu_esmolol')."%",
						'NewCropPrescription.patient_uniqueid'=>$patientid,'NewCropPrescription.archive'=>'N')));
		$getEsmololIds = array();
		foreach($getEsmololId as $primaryId){
			array_push($getEsmololIds, 'crop'.$primaryId);
		}
		$getEsmololId = $getEsmololIds;
		if(!empty($date)){
			//selected date
			$last12HoursStr = 	array() ;
			$getEsmolol = $this->ReviewPatientDetail->find('all', array(
					'fields' => array('ReviewPatientDetail.values','ReviewPatientDetail.hourSlot'),
					'conditions' => array_merge(array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid,
						 'ReviewPatientDetail.date' => $chartDate, 'ReviewPatientDetail.review_sub_categories_options_id' => $getEsmololId,
							'ReviewPatientDetail.edited_on' => NULL, $last12HoursStr)),
				 'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC')));
		}
		else{
			//for current date
			if(date('H') >= 11) {
				if(date("H")==23)
				{
					$last12Hours = array(11,2300);

				}
				else {

					$last12Hours = array(date('H', strtotime(date('Y-m-d H:i:s'). ' - 11 hours')), date('H', strtotime(date('Y-m-d H:i:s'). ' + 1 hours'))."00");
				}
				$last12HoursStr =  array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $last12Hours ) ;
				$getEsmolol = $this->ReviewPatientDetail->find('all', array(
						'fields' => array('ReviewPatientDetail.values','ReviewPatientDetail.hourSlot'),
						'conditions' => array_merge(array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid,
								'ReviewPatientDetail.date' => $chartDate, 'ReviewPatientDetail.review_sub_categories_options_id' => $getEsmololId,
								'ReviewPatientDetail.edited_on' => NULL, $last12HoursStr)),
						'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC')));
			}
			else {
				//for last and current date
				$dateRange = array(date('Y-m-d', strtotime(date('Y-m-d'). ' - 1 day')), date('Y-m-d'));
				$lastHour = 24-(12 - date('H'));
				$hourRange1 =  array($lastHour, 24);
				$hourRange2 = array(00, date('H').'00');
				$getEsmolol = $this->ReviewPatientDetail->find('all', array(
						'fields' => array('ReviewPatientDetail.values','ReviewPatientDetail.hourSlot'),
						'conditions' =>array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid,
								'ReviewPatientDetail.review_sub_categories_options_id' => $getEsmololId,'ReviewPatientDetail.edited_on' => NULL,
								'OR' => array(array('ReviewPatientDetail.date' => $dateRange[0], 'CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $hourRange1),
										array('ReviewPatientDetail.date' => $dateRange[1], 'CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $hourRange2))),
						'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC')));

			}
		}

		foreach($getEsmolol as $getEsmololVal) {
			if(strlen($getEsmololVal['ReviewPatientDetail']['hourSlot']) == 1) {
				$setTimeIndex = "0".$getEsmololVal['ReviewPatientDetail']['hourSlot'].".00";
			} elseif(strlen($getEsmololVal['ReviewPatientDetail']['hourSlot']) == 2) {
				$setTimeIndex = $getEsmololVal['ReviewPatientDetail']['hourSlot'].".00";
			} else {
				$setTimeString = str_split($getEsmololVal['ReviewPatientDetail']['hourSlot'], 2);
				$setTimeIndex = $setTimeString[0].".".$setTimeString[1];
			}
			$getVPEsmolol[$setTimeIndex] = $getEsmololVal['ReviewPatientDetail']['values'];
		}
		//Lidocaine line
		$getLidocaineId=$this->NewCropPrescription->find('list',array('fields'=>array('id'),
				'conditions'=>array('NewCropPrescription.drug_name LIKE'=>"%".Configure::read('continuous_infu_Lidocaine')."%",
						'NewCropPrescription.patient_uniqueid'=>$patientid, 'NewCropPrescription.archive'=>'N')));
		$getLidocaineIds = array();
		foreach($getLidocaineId as $primaryId){
			array_push($getLidocaineIds, 'crop'.$primaryId);
		}
		$getLidocaineId = $getLidocaineIds;
		if(!empty($date)){
			//selected date
			$last12HoursStr = 	array() ;
			$getLidocaine = $this->ReviewPatientDetail->find('all', array('fields' => array('ReviewPatientDetail.values',
					'ReviewPatientDetail.hourSlot'),'conditions' => array_merge(array('ReviewPatientDetail.values <>' =>'',
							'ReviewPatientDetail.patient_id' => $patientid, 'ReviewPatientDetail.date' =>$chartDate,
						 'ReviewPatientDetail.review_sub_categories_options_id' => $getLidocaineId,
							'ReviewPatientDetail.edited_on' => NULL, $last12HoursStr)),
					'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC')));
		}
		else{
			//for current date
			if(date('H') >= 11) {
				if(date("H")==23)
				{
					$last12Hours = array(11,2300);

				}
				else {

					$last12Hours = array(date('H', strtotime(date('Y-m-d H:i:s'). ' - 11 hours')), date('H', strtotime(date('Y-m-d H:i:s'). ' + 1 hours'))."00");
				}
				$last12HoursStr =  array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $last12Hours ) ;
				$getLidocaine = $this->ReviewPatientDetail->find('all', array('fields' => array('ReviewPatientDetail.values',
						'ReviewPatientDetail.hourSlot'),'conditions' => array_merge(array('ReviewPatientDetail.values <>' =>'',
								'ReviewPatientDetail.patient_id' => $patientid, 'ReviewPatientDetail.date' =>$chartDate,
								'ReviewPatientDetail.review_sub_categories_options_id' => $getLidocaineId,
								'ReviewPatientDetail.edited_on' => NULL, $last12HoursStr)),
						'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC')));
			}
			else {
				//for last and current date
				$dateRange = array(date('Y-m-d', strtotime(date('Y-m-d'). ' - 1 day')), date('Y-m-d'));
				$lastHour = 24-(12 - date('H'));
				$hourRange1 =  array($lastHour, 24);
				$hourRange2 = array(00, date('H').'00');
				$getLidocaine = $this->ReviewPatientDetail->find('all', array(
						'fields' => array('ReviewPatientDetail.values','ReviewPatientDetail.hourSlot'),
						'conditions' =>array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid,
								'ReviewPatientDetail.review_sub_categories_options_id' => $getLidocaineId,'ReviewPatientDetail.edited_on' => NULL,
								'OR' => array(array('ReviewPatientDetail.date' => $dateRange[0], 'CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $hourRange1),
										array('ReviewPatientDetail.date' => $dateRange[1], 'CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $hourRange2))),
						'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC')));

			}
		}


		foreach($getLidocaine as $getLidocaineVal) {
			if(strlen($getLidocaineVal['ReviewPatientDetail']['hourSlot']) == 1) {
				$setTimeIndex = "0".$getLidocaineVal['ReviewPatientDetail']['hourSlot'].".00";
			} elseif(strlen($getLidocaineVal['ReviewPatientDetail']['hourSlot']) == 2) {
				$setTimeIndex = $getLidocaineVal['ReviewPatientDetail']['hourSlot'].".00";
			} else {
				$setTimeString = str_split($getLidocaineVal['ReviewPatientDetail']['hourSlot'], 2);
				$setTimeIndex = $setTimeString[0].".".$setTimeString[1];
			}
			$getVPLidocaine[$setTimeIndex] = $getLidocaineVal['ReviewPatientDetail']['values'];
		}
		// Propranolol line
		$getPropranololId=$this->NewCropPrescription->find('list',array('fields'=>array('id'),
				'conditions'=>array('NewCropPrescription.drug_name LIKE'=>"%".Configure::read('continuous_infu_Propranolol')."%",
						'NewCropPrescription.patient_uniqueid'=>$patientid,'NewCropPrescription.archive'=>'N')));
		$getPropranololIds=array();
		foreach($getPropranololId as $primaryId)
		{
			array_push($getpropanololIds,'crop'.$primaryId);
		}
		$getPropranololId=$getpropanololIds;
		if(!empty($date)){
			//selected date
			$last12HoursStr = 	array() ;
			$getPropranolol = $this->ReviewPatientDetail->find('all', array(
					'fields' => array('ReviewPatientDetail.values',	'ReviewPatientDetail.hourSlot'),
					'conditions' =>array_merge( array('ReviewPatientDetail.values <>' =>'',
							'ReviewPatientDetail.patient_id' => $patientid, 'ReviewPatientDetail.date' => $chartDate,
							'ReviewPatientDetail.review_sub_categories_options_id' => $getPropranololId,
							'ReviewPatientDetail.edited_on' => NULL,$last12HoursStr)), 'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC')));
		}
		else{
			//for current date
			if(date('H') >= 11) {
				if(date("H")==23)
				{
					$last12Hours = array(11,2300);

				}
				else {

					$last12Hours = array(date('H', strtotime(date('Y-m-d H:i:s'). ' - 11 hours')), date('H', strtotime(date('Y-m-d H:i:s'). ' + 1 hours'))."00");
				}
				$last12HoursStr =  array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $last12Hours ) ;
				$getPropranolol = $this->ReviewPatientDetail->find('all', array(
						'fields' => array('ReviewPatientDetail.values',	'ReviewPatientDetail.hourSlot'),
						'conditions' =>array_merge( array('ReviewPatientDetail.values <>' =>'',
								'ReviewPatientDetail.patient_id' => $patientid, 'ReviewPatientDetail.date' => $chartDate,
								'ReviewPatientDetail.review_sub_categories_options_id' => $getPropranololId,
								'ReviewPatientDetail.edited_on' => NULL,$last12HoursStr)), 'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC')));
			}
			else {
				//for last and current date
				$dateRange = array(date('Y-m-d', strtotime(date('Y-m-d'). ' - 1 day')), date('Y-m-d'));
				$lastHour = 24-(12 - date('H'));
				$hourRange1 =  array($lastHour, 24);
				$hourRange2 = array(00, date('H').'00');
				$getPropranolol = $this->ReviewPatientDetail->find('all', array(
						'fields' => array('ReviewPatientDetail.values','ReviewPatientDetail.hourSlot'),
						'conditions' =>array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid,
								'ReviewPatientDetail.review_sub_categories_options_id' => $getPropranololId,'ReviewPatientDetail.edited_on' => NULL,
								'OR' => array(array('ReviewPatientDetail.date' => $dateRange[0], 'CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $hourRange1),
										array('ReviewPatientDetail.date' => $dateRange[1], 'CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $hourRange2))),
						'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC')));

			}
		}

		foreach($getPropranolol as $getPropranololVal) {
			if(strlen($getPropranololVal['ReviewPatientDetail']['hourSlot']) == 1) {
				$setTimeIndex = "0".$getPropranololVal['ReviewPatientDetail']['hourSlot'].".00";
			} elseif(strlen($getPropranololVal['ReviewPatientDetail']['hourSlot']) == 2) {
				$setTimeIndex = $getPropranololVal['ReviewPatientDetail']['hourSlot'].".00";
			} else {
				$setTimeString = str_split($getPropranololVal['ReviewPatientDetail']['hourSlot'], 2);
				$setTimeIndex = $setTimeString[0].".".$setTimeString[1];
			}
			$getVPPropranolol[$setTimeIndex] = $getPropranololVal['ReviewPatientDetail']['values'];
		}
		//Amiodarone line
		$getAmiodaroneId=$this->NewCropPrescription->find('list',array('fields'=>array('id'),
				'conditions'=>array('NewCropPrescription.drug_name LIKE'=>"%".Configure::read('continuous_infu_Amiodarone')."%",
						'NewCropPrescription.patient_uniqueid'=>$patientid,'NewCropPrescription.archive'=>'N')));
		$getAmiodaroneIds=array();
		foreach($getAmiodaroneId as $primaryId)
		{
			array_push($getAmiodaroneIds,'crop'.$primaryId);
		}
		$getAmiodaroneId=$getAmiodaroneIds;
		if(!empty($date)){
			//selected date
			$last12HoursStr = 	array() ;
			$getAmiodarone = $this->ReviewPatientDetail->find('all', array(
					'fields' => array('ReviewPatientDetail.values','ReviewPatientDetail.hourSlot'),
					'conditions' =>array_merge( array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid,
						 'ReviewPatientDetail.date' => $chartDate, 'ReviewPatientDetail.review_sub_categories_options_id' => $getAmiodaroneId,
						 'ReviewPatientDetail.edited_on' => NULL,$last12HoursStr)),
					'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC')));
		}
		else{
			//for current date
			if(date('H') >= 11) {
				if(date("H")==23)
				{
					$last12Hours = array(11,2300);

				}
				else {

					$last12Hours = array(date('H', strtotime(date('Y-m-d H:i:s'). ' - 11 hours')), date('H', strtotime(date('Y-m-d H:i:s'). ' + 1 hours'))."00");
				}
				$last12HoursStr =  array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $last12Hours ) ;
				$getAmiodarone = $this->ReviewPatientDetail->find('all', array(
						'fields' => array('ReviewPatientDetail.values','ReviewPatientDetail.hourSlot'),
						'conditions' =>array_merge( array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid,
								'ReviewPatientDetail.date' => $chartDate, 'ReviewPatientDetail.review_sub_categories_options_id' => $getAmiodaroneId,
								'ReviewPatientDetail.edited_on' => NULL,$last12HoursStr)),
						'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC')));
			}
			else {
				//for last and current date
				$dateRange = array(date('Y-m-d', strtotime(date('Y-m-d'). ' - 1 day')), date('Y-m-d'));
				$lastHour = 24-(12 - date('H'));
				$hourRange1 =  array($lastHour, 24);
				$hourRange2 = array(00, date('H').'00');
				$getAmiodarone = $this->ReviewPatientDetail->find('all', array(
						'fields' => array('ReviewPatientDetail.values','ReviewPatientDetail.hourSlot'),
						'conditions' =>array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid,
								'ReviewPatientDetail.review_sub_categories_options_id' => $getAmiodaroneId,'ReviewPatientDetail.edited_on' => NULL,
								'OR' => array(array('ReviewPatientDetail.date' => $dateRange[0], 'CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $hourRange1),
										array('ReviewPatientDetail.date' => $dateRange[1], 'CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $hourRange2))),
						'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC')));

			}
		}

		foreach($getAmiodarone as $getAmiodaroneVal) {
			if(strlen($getAmiodaroneVal['ReviewPatientDetail']['hourSlot']) == 1) {
				$setTimeIndex = "0".$getAmiodaroneVal['ReviewPatientDetail']['hourSlot'].".00";
			} elseif(strlen($getAmiodaroneVal['ReviewPatientDetail']['hourSlot']) == 2) {
				$setTimeIndex = $getAmiodaroneVal['ReviewPatientDetail']['hourSlot'].".00";
			} else {
				$setTimeString = str_split($getAmiodaroneVal['ReviewPatientDetail']['hourSlot'], 2);
				$setTimeIndex = $setTimeString[0].".".$setTimeString[1];
			}
			$getVPAmiodarone[$setTimeIndex] = $getAmiodaroneVal['ReviewPatientDetail']['values'];
		}
		//Procainamide line
		$getProcainamideId=$this->NewCropPrescription->find('list',array('fields'=>array('id'),
				'conditions'=>array('NewCropPrescription.drug_name LIKE'=>"%".Configure::read('continuous_infu_Procainamide')."%",
						'NewCropPrescription.patient_uniqueid'=>$patientid,'NewCropPrescription.archive'=>'N')));
		$getProcainamideIds=array();
		foreach($getProcainamideId as $primaryId)
		{
			array_push($getProcainamideIds,'crop'.$primaryId);
		}
		$getProcainamideId=$getProcainamideIds;
		if(!empty($date)){
			//selected date
			$last12HoursStr = 	array() ;
			$getProcainamide = $this->ReviewPatientDetail->find('all', array(
					'fields' => array('ReviewPatientDetail.values','ReviewPatientDetail.hourSlot'),
					'conditions' =>array_merge( array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid,
							'ReviewPatientDetail.date' => $chartDate, 'ReviewPatientDetail.review_sub_categories_options_id' => $getProcainamideId,
						 'ReviewPatientDetail.edited_on' => NULL,$last12HoursStr)), 'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC')));
		}
		else{
			//for current date
			if(date('H') >= 11) {
				if(date("H")==23)
				{
					$last12Hours = array( 11,2300);

				}
				else {

					$last12Hours = array(date('H', strtotime(date('Y-m-d H:i:s'). ' - 11 hours')), date('H', strtotime(date('Y-m-d H:i:s'). ' + 1 hours'))."00");
				}
				$last12HoursStr =  array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $last12Hours ) ;
				$getProcainamide = $this->ReviewPatientDetail->find('all', array(
						'fields' => array('ReviewPatientDetail.values','ReviewPatientDetail.hourSlot'),
						'conditions' =>array_merge( array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid,
								'ReviewPatientDetail.date' => $chartDate, 'ReviewPatientDetail.review_sub_categories_options_id' => $getProcainamideId,
								'ReviewPatientDetail.edited_on' => NULL,$last12HoursStr)), 'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC')));
			}
			else {
				//for last and current date
				$dateRange = array(date('Y-m-d', strtotime(date('Y-m-d'). ' - 1 day')), date('Y-m-d'));
				$lastHour = 24-(12 - date('H'));
				$hourRange1 =  array($lastHour, 24);
				$hourRange2 = array(00, date('H').'00');
				$getProcainamide = $this->ReviewPatientDetail->find('all', array(
						'fields' => array('ReviewPatientDetail.values','ReviewPatientDetail.hourSlot'),
						'conditions' =>array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid,
								'ReviewPatientDetail.review_sub_categories_options_id' => $getProcainamideId,'ReviewPatientDetail.edited_on' => NULL,
								'OR' => array(array('ReviewPatientDetail.date' => $dateRange[0], 'CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $hourRange1),
										array('ReviewPatientDetail.date' => $dateRange[1], 'CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $hourRange2))),
						'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC')));

			}
		}

		foreach($getProcainamide as $getProcainamideVal) {
			if(strlen($getProcainamideVal['ReviewPatientDetail']['hourSlot']) == 1) {
				$setTimeIndex = "0".$getProcainamideVal['ReviewPatientDetail']['hourSlot'].".00";
			} elseif(strlen($getProcainamideVal['ReviewPatientDetail']['hourSlot']) == 2) {
				$setTimeIndex = $getProcainamideVal['ReviewPatientDetail']['hourSlot'].".00";
			} else {
				$setTimeString = str_split($getProcainamideVal['ReviewPatientDetail']['hourSlot'], 2);
				$setTimeIndex = $setTimeString[0].".".$setTimeString[1];
			}
			$getVPProcainamide[$setTimeIndex] = $getProcainamideVal['ReviewPatientDetail']['values'];
		}
			
		$this->set(compact('getVPVasopressin', 'getVPEsmolol', 'getVPLidocaine','getVPPropranolol','getVPAmiodarone','$getVPProcainamide'));
		//end of vasopressin graph
		//Blood Pressure graph
		$getSbpDpbCuffId=$this->ReviewSubCategoriesOption->find('list',array('fields'=>array('id'),
				'conditions'=>array('ReviewSubCategoriesOption.name'=>array(Configure::read('bloodPressure_SbpDbp_cuff'),Configure::read('bloodPressure_SbpDbp_Aline')))));
		$getMeanCuffId=$this->ReviewSubCategoriesOption->find('list',array('fields'=>array('id'),
				'conditions'=>array('ReviewSubCategoriesOption.name'=>array(Configure::read('bloodPressure_mean_cuff'),Configure::read('bloodPressure_mean_Aline')))));
		//$getSbpDpbAlineId=$this->ReviewSubCategoriesOption->find('first',array('fields'=>array('id'),
		//	'conditions'=>array('ReviewSubCategoriesOption.name'=>Configure::read('bloodPressure_SbpDbp_Aline'))));
		//$getMeanAlineId=$this->ReviewSubCategoriesOption->find('first',array('fields'=>array('id'),
		//'conditions'=>array('ReviewSubCategoriesOption.name'=>Configure::read('bloodPressure_mean_Aline'))));
		//debug($getSbpDpbCuffId);exit;

		if(!empty($date)){
			//selected date
			$last12HoursStr = 	array() ;
			$getSbpDbpCuff=$this->ReviewPatientDetail->find('all',array('fields'=>array('ReviewPatientDetail.values','ReviewPatientDetail.hourSlot'),
					'conditions'=>array_merge(array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id'=> $patientid,'ReviewPatientDetail.date'=>$chartDate,
							'ReviewPatientDetail.review_sub_categories_options_id'=>$getSbpDpbCuffId,
							'ReviewPatientDetail.edited_on' => NULL,$last12HoursStr)),
					'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC','ReviewSubCategoriesOption.name='=>"'".Configure::read('bloodPressure_SbpDbp_Aline')."'".' ASC')));
			$getMeanCuff=$this->ReviewPatientDetail->find('all',array('fields'=>array('ReviewPatientDetail.values','ReviewPatientDetail.hourSlot'),
					'conditions'=>array_merge(array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id'=> $patientid,
							'ReviewPatientDetail.date'=>$chartDate,'ReviewPatientDetail.review_sub_categories_options_id'=>$getMeanCuffId,
							'ReviewPatientDetail.edited_on' => NULL,$last12HoursStr)),
					'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC','ReviewSubCategoriesOption.name='=>"'".Configure::read('bloodPressure_mean_Aline')."'".' ASC')));
			/* $getSbpDbpAline=$this->ReviewPatientDetail->find('all',array('fields'=>array('ReviewPatientDetail.values','ReviewPatientDetail.hourSlot'),
			 'conditions'=>array_merge(array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id'=> $patientid,
			 		'ReviewPatientDetail.date'=>$chartDate,'ReviewPatientDetail.review_sub_categories_options_id'=>$getSbpDpbAlineId['ReviewSubCategoriesOption']['id'],
			 		'ReviewPatientDetail.edited_on' => NULL,$last12HoursStr)),
					'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC')));
			$getMeanAline=$this->ReviewPatientDetail->find('all',array('fields'=>array('ReviewPatientDetail.values','ReviewPatientDetail.hourSlot'),
					'conditions'=>array_merge(array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id'=> $patientid,
							'ReviewPatientDetail.date'=>$chartDate,'ReviewPatientDetail.review_sub_categories_options_id'=>$getMeanAlineId['ReviewSubCategoriesOption']['id'],
							'ReviewPatientDetail.edited_on' => NULL,$last12HoursStr)),
					'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC'))); */
		}
		else{
			//for current date
			if(date('H') >= 11) {
				if(date("H")==23)
				{
					$last12Hours = array(11,2300);

				}
				else {

					$last12Hours = array(date('H', strtotime(date('Y-m-d H:i:s'). ' - 11 hours')), date('H', strtotime(date('Y-m-d H:i:s'). ' + 1 hours'))."00");
				}
				$last12HoursStr =  array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $last12Hours ) ;
				$getSbpDbpCuff=$this->ReviewPatientDetail->find('all',array('fields'=>array('ReviewPatientDetail.values','ReviewPatientDetail.hourSlot'),
						'conditions'=>array_merge(array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id'=> $patientid,'ReviewPatientDetail.date'=>$chartDate,
								'ReviewPatientDetail.review_sub_categories_options_id'=>$getSbpDpbCuffId,
								'ReviewPatientDetail.edited_on' => NULL,$last12HoursStr)),
						'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC','ReviewSubCategoriesOption.name='=>"'".Configure::read('bloodPressure_SbpDbp_Aline')."'".' ASC')));
				$getMeanCuff=$this->ReviewPatientDetail->find('all',array('fields'=>array('ReviewPatientDetail.values','ReviewPatientDetail.hourSlot'),
						'conditions'=>array_merge(array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id'=> $patientid,
								'ReviewPatientDetail.date'=>$chartDate,'ReviewPatientDetail.review_sub_categories_options_id'=>$getMeanCuffId,
								'ReviewPatientDetail.edited_on' => NULL,$last12HoursStr)),
						'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC','ReviewSubCategoriesOption.name='=>"'".Configure::read('bloodPressure_mean_Aline')."'".' ASC')));
				/* $getSbpDbpAline=$this->ReviewPatientDetail->find('all',array('fields'=>array('ReviewPatientDetail.values','ReviewPatientDetail.hourSlot'),
				 'conditions'=>array_merge(array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id'=> $patientid,
				 		'ReviewPatientDetail.date'=>$chartDate,'ReviewPatientDetail.review_sub_categories_options_id'=>$getSbpDpbAlineId['ReviewSubCategoriesOption']['id'],
				 		'ReviewPatientDetail.edited_on' => NULL,$last12HoursStr)),
						'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC')));
				$getMeanAline=$this->ReviewPatientDetail->find('all',array('fields'=>array('ReviewPatientDetail.values','ReviewPatientDetail.hourSlot'),
						'conditions'=>array_merge(array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id'=> $patientid,
								'ReviewPatientDetail.date'=>$chartDate,'ReviewPatientDetail.review_sub_categories_options_id'=>$getMeanAlineId['ReviewSubCategoriesOption']['id'],
								'ReviewPatientDetail.edited_on' => NULL,$last12HoursStr)),
						'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC'))); */
			}
			else {
				//for last and current date
				$dateRange = array(date('Y-m-d', strtotime(date('Y-m-d'). ' - 1 day')), date('Y-m-d'));
				$lastHour = 24-(12 - date('H'));
				$hourRange1 =  array($lastHour, 24);
				$hourRange2 = array(00, date('H').'00');
				$getSbpDbpCuff = $this->ReviewPatientDetail->find('all', array(
						'fields' => array('ReviewPatientDetail.values','ReviewPatientDetail.hourSlot'),
						'conditions' =>array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid,
								'ReviewPatientDetail.review_sub_categories_options_id' => $getSbpDpbCuffId,'ReviewPatientDetail.edited_on' => NULL,
								'OR' => array(array('ReviewPatientDetail.date' => $dateRange[0], 'CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $hourRange1),
										array('ReviewPatientDetail.date' => $dateRange[1], 'CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $hourRange2))),
						'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC','ReviewSubCategoriesOption.name='=>"'".Configure::read('bloodPressure_SbpDbp_Aline')."'".' ASC')));

				$getMeanCuff = $this->ReviewPatientDetail->find('all', array(
						'fields' => array('ReviewPatientDetail.values','ReviewPatientDetail.hourSlot'),
						'conditions' =>array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid,
								'ReviewPatientDetail.review_sub_categories_options_id' => $getMeanCuffId,'ReviewPatientDetail.edited_on' => NULL,
								'OR' => array(array('ReviewPatientDetail.date' => $dateRange[0], 'CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $hourRange1),
										array('ReviewPatientDetail.date' => $dateRange[1], 'CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $hourRange2))),
						'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC','ReviewSubCategoriesOption.name='=>"'".Configure::read('bloodPressure_mean_Aline')."'".' ASC')));

				/* $getSbpDbpAline = $this->ReviewPatientDetail->find('all', array(
				 'fields' => array('ReviewPatientDetail.values','ReviewPatientDetail.hourSlot'),
						'conditions' =>array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid,
								'ReviewPatientDetail.review_sub_categories_options_id' => $getSbpDpbAlineId['ReviewSubCategoriesOption']['id'],'ReviewPatientDetail.edited_on' => NULL,
								'OR' => array(array('ReviewPatientDetail.date' => $dateRange[0], 'CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $hourRange1),
										array('ReviewPatientDetail.date' => $dateRange[1], 'CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $hourRange2))),
						'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC')));

				$getMeanAline = $this->ReviewPatientDetail->find('all', array(
						'fields' => array('ReviewPatientDetail.values','ReviewPatientDetail.hourSlot'),
						'conditions' =>array('ReviewPatientDetail.values <>' =>'', 'ReviewPatientDetail.patient_id' => $patientid,
								'ReviewPatientDetail.review_sub_categories_options_id' => $getMeanAlineId['ReviewSubCategoriesOption']['id'],'ReviewPatientDetail.edited_on' => NULL,
								'OR' => array(array('ReviewPatientDetail.date' => $dateRange[0], 'CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $hourRange1),
										array('ReviewPatientDetail.date' => $dateRange[1], 'CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) BETWEEN ? AND ?' => $hourRange2))),
						'order' => array('CAST(ReviewPatientDetail.hourSlot as  UNSIGNED) ASC'))); */

			}
		}


		//debug($getSbpDbpCuff);
		if(!empty($getSbpDbpCuff) && !empty($getMeanCuff))
		{
			foreach($getSbpDbpCuff as $getSbpDbpCuffVal) {
				if(strlen($getSbpDbpCuffVal['ReviewPatientDetail']['hourSlot']) == 1) {
					$setTimeIndex = "0".$getSbpDbpCuffVal['ReviewPatientDetail']['hourSlot'].".00";
				} elseif(strlen($getSbpDbpCuffVal['ReviewPatientDetail']['hourSlot']) == 2) {
					$setTimeIndex = $getSbpDbpCuffVal['ReviewPatientDetail']['hourSlot'].".00";
				} else {
					$setTimeString = str_split($getSbpDbpCuffVal['ReviewPatientDetail']['hourSlot'], 2);
					$setTimeIndex = $setTimeString[0].".".$setTimeString[1];
				}
				$getBPCuff['sbpCuff'][$setTimeIndex] = $getSbpDbpCuffVal['ReviewPatientDetail']['values'];
			}
			foreach($getMeanCuff as $getMeanCuffVal) {
				if(strlen($getMeanCuffVal['ReviewPatientDetail']['hourSlot']) == 1) {
					$setTimeIndex = "0".$getMeanCuffVal['ReviewPatientDetail']['hourSlot'].".00";
				} elseif(strlen($getMeanCuffVal['ReviewPatientDetail']['hourSlot']) == 2) {
					$setTimeIndex = $getMeanCuffVal['ReviewPatientDetail']['hourSlot'].".00";
				} else {
					$setTimeString = str_split($getMeanCuffVal['ReviewPatientDetail']['hourSlot'], 2);
					$setTimeIndex = $setTimeString[0].".".$setTimeString[1];
				}
				$getBPCuff['meanCuff'][$setTimeIndex] = $getMeanCuffVal['ReviewPatientDetail']['values'];
			}

		}
		/*
		 elseif(!empty($getSbpDbpAline) && !empty($getMeanAline))
		 {
		foreach($getSbpDbpAline as $getSbpDbpAlineVal) {
		if(strlen($getSbpDbpAlineVal['ReviewPatientDetail']['hourSlot']) == 1) {
		$setTimeIndex = "0".$getSbpDbpAlineVal['ReviewPatientDetail']['hourSlot'].".00";
		} elseif(strlen($getSbpDbpAlineVal['ReviewPatientDetail']['hourSlot']) == 2) {
		$setTimeIndex = $getSbpDbpAlineVal['ReviewPatientDetail']['hourSlot'].".00";
		} else {
		$setTimeString = str_split($getSbpDbpAlineVal['ReviewPatientDetail']['hourSlot'], 2);
		$setTimeIndex = $setTimeString[0].".".$setTimeString[1];
		}
		$getBPAline['sbpAline'][$setTimeIndex] = $getSbpDbpAlineVal['ReviewPatientDetail']['values'];
		}
		foreach($getMeanAline as $getMeanAlineVal) {
		if(strlen($getMeanAlineVal['ReviewPatientDetail']['hourSlot']) == 1) {
		$setTimeIndex = "0".$getMeanAlineVal['ReviewPatientDetail']['hourSlot'].".00";
		} elseif(strlen($getMeanAlineVal['ReviewPatientDetail']['hourSlot']) == 2) {
		$setTimeIndex = $getMeanAlineVal['ReviewPatientDetail']['hourSlot'].".00";
		} else {
		$setTimeString = str_split($getMeanAlineVal['ReviewPatientDetail']['hourSlot'], 2);
		$setTimeIndex = $setTimeString[0].".".$setTimeString[1];
		}
		$getBPAline['meanAline'][$setTimeIndex] = $getMeanAlineVal['ReviewPatientDetail']['values'];
		}
		} */
		//debug($getBPCuff);
		//debug($getBPAline);
		$this->set(compact('getBPCuff','getBPAline'));
			
		//end of Blood Pressure graph

	}

	/**
	 * @method emarDashboard, Base page for dashboard
	 * @param string $id
	 * @return void
	 * @author Gaurav Chauriya
	 */
	public function emarDashboard($patientId=null){
		ob_end_clean();
		ob_start("ob_gzhandler");
		$this->layout = 'advance';
		$this->uses = array('EmarDashboardSetting','NewCropPrescription','Patient');
		/**  Date vise schedulwe medication search logic start -Aditya**/
		if(isset($this->request->data['dateFrom']) && !empty($this->request->data['dateFrom'])){
			$date=$this->request->data['dateFrom'];
			$expDateTime=explode(' ',$date);
			$expDate=explode('/',$expDateTime['0']);
			$fromDateTime=$expDate['2']."-".$expDate['0']."-".$expDate['1']." ".$expDateTime['1'];
			$this->set('fromDateTime',$fromDateTime);
		}
		/**  Date vise schedulwe medication search logic eod **/

		$data = $this->EmarDashboardSetting->find('all',array('conditions'=>array('EmarDashboardSetting.user_id'=>$this->Session->read('userid'))));
		$this->data =$data;
		$this->set(array('patient_id'=>$patientId,'medicationTiming'=>$medicationTiming));
		$this->Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id')),
				)));
		$admission_type=$this->Patient->find('first',array('conditions'=>array('Patient.id'=>$patientId),
			'fields'=>array('Patient.admission_type','Patient.lookup_name','Person.dob','Person.sex','Patient.admission_id','Person.patient_uid')));
		$this->set("admission_type",$admission_type);

	}

	/**
	 * @method UserViewSetting
	 * @property dashboard settings
	 * @param string fieldName fieldValue
	 * @return void
	 * @author Gaurav Chauriya
	 */
	function userViewSetting($field,$value){
		$this->uses = array('EmarDashboardSetting');
		$existingId = $this->EmarDashboardSetting->find('list',array('fields'=>'user_id','conditions'=>array('user_id'=>$this->Session->read('userid'))));
		if($existingId){
			$this->EmarDashboardSetting->updateAll(array($field=>"'$value'"),array('user_id'=>$existingId));
		}else{
			$this->EmarDashboardSetting->save(array('user_id'=>$this->Session->read('userid'),$field=>$value));
		}
		exit;
	}

	/**
	 * @method ajax dashboardExcelView method
	 * dashboardView in excel sheet format
	 * @param string $id userSetting countOfTd
	 * @return void
	 * @author Gaurav Chauriya
	 */
	function dashboardExcelView($patientId,$setting=null){
		ob_end_clean();
		ob_start("ob_gzhandler");
		$this->layout = 'ajax';
		$this->uses = array('EmarDashboardSetting','Patient','Configuration');
		// To check QR Card reader is ON
		$valie=$this->Configuration->find('first',array('fields'=>array('value'),'conditions'=>array('name'=>'patientWristBandOn')));
		$this->set('isQRON',$valie['Configuration']['value']);
		//EOD
		if(!empty($this->params['named']['dateTime']) && isset($this->params['named']['dateTime'])){
			$dateTimeSearch=$this->params['named']['dateTime'];
		}else{
			$dateTimeSearch='';
		}
		$scheduledMedication = $this->getScheduledMedication($patientId,$this->params['named']['dateTime']);
			
		$prnMedication = $this->getPrnMedication($patientId,$this->params['named']['dateTime']);

		$contineousInfusion = $this->getContineousInfusionMedication($patientId,$this->params['named']['dateTime']);
		
		/*if($existingSetting['0']['EmarDashboardSetting']['discontscheduled']=='1')
		 $disContScheduledMedication = $this->getDisContScheduledMedication($patientId);

		if($existingSetting['0']['EmarDashboardSetting']['future']=='1')
			$futureMedication = $this->getFutureMedication($patientId);

		if($existingSetting['0']['EmarDashboardSetting']['discontprn']=='1')
			$disContPrnMedication = $this->getDisContPrnMedication($patientId);

		if($existingSetting['0']['EmarDashboardSetting']['discontinfusion']=='1')
			$disContineousInfusion = $this->getDisContineousInfusionMedication($patientId);*/

		/*
		 * administered time array
		*/
			
		$this->set('patientId',$patientId);
		$this->set(compact('setting','scheduledMedication','prnMedication','contineousInfusion','futureMedication','disContScheduledMedication',
				'disContPrnMedication','disContineousInfusion','medicationTiming','prescTimeSchedule','prescTimePrn','prescTimeContinuous','dateTimeSearch'));

	}
	/**
	 * @method getScheduledMedication
	 * @param int type $patientId
	 * @return void
	 * @author Gaurav Chauriya
	 */
	private function getScheduledMedication($patientId=null){

		$this->NewCropPrescription->bindModel(array(
				'hasOne'=>array('PatientOrder'=>array('foreignKey'=>false,
						'conditions'=>array('PatientOrder.id=NewCropPrescription.patient_order_id')),
				),
				'hasMany'=>array('MedicationAdministeringRecord'=>array('foreignKey'=>'new_crop_prescription_id',
						'conditions'=>array('MedicationAdministeringRecord.late_reason_flag=0','MedicationAdministeringRecord.admin_note_flag=0',
								"MedicationAdministeringRecord.patient_id=$patientId",'MedicationAdministeringRecord.med_request_flag=0',
								//'performed_datetime <='=>date('Y-m-d H:i:s',strtotime("-1 day"))
						),
						'fields'=>array('MedicationAdministeringRecord.id','MedicationAdministeringRecord.performed_datetime','MedicationAdministeringRecord.dose'),
						'order'=>array('MedicationAdministeringRecord.id DESC')
				),
				),
		));
		$intravenousRoute = configure::read('selected_route_administration');
		return $this->NewCropPrescription->find('all',array('fields'=>array('PatientOrder.sentence','NewCropPrescription.id','NewCropPrescription.drug_name',
				'NewCropPrescription.description','NewCropPrescription.dose','NewCropPrescription.strength','NewCropPrescription.route',
				'NewCropPrescription.firstdose','NewCropPrescription.medication_administering_time'),'order'=>array('NewCropPrescription.id DESC'),
				'conditions'=>array('NewCropPrescription.archive'=>'N','prn'=>'0','firstdose <='=>date('Y-m-d H:i:s'),'NewCropPrescription.route NOT'=>array($intravenousRoute['INTRAVENOUS'],$intravenousRoute['INJECT INTRAMUSCULAR']),
						'NewCropPrescription.patient_uniqueid'=>$patientId,'NewCropPrescription.location_id'=>$this->Session->read('locationid'))));

	}

	/**
	 * @method getPrnMedication
	 * @param int type $patientId
	 * @return void
	 * @author Gaurav Chauriya
	 */
	private function getPrnMedication($patientId=null){

		$this->NewCropPrescription->bindModel(array(
				'hasOne'=>array('PatientOrder'=>array('foreignKey'=>false,
						'conditions'=>array('PatientOrder.id=NewCropPrescription.patient_order_id'))
				),
				'hasMany'=>array('MedicationAdministeringRecord'=>array('foreignKey'=>'new_crop_prescription_id',
						'conditions'=>array('MedicationAdministeringRecord.late_reason_flag=0','MedicationAdministeringRecord.admin_note_flag=0',
								"MedicationAdministeringRecord.patient_id=$patientId",'MedicationAdministeringRecord.med_request_flag=0'),
						'fields'=>array('MedicationAdministeringRecord.id','MedicationAdministeringRecord.performed_datetime','MedicationAdministeringRecord.dose'),
						'order'=>array('MedicationAdministeringRecord.id DESC')
				),

				),
		));
		return $this->NewCropPrescription->find('all',array('fields'=>array('PatientOrder.sentence','NewCropPrescription.id','NewCropPrescription.drug_name',
				'NewCropPrescription.description','NewCropPrescription.dose','NewCropPrescription.strength','NewCropPrescription.route',
				'NewCropPrescription.firstdose','NewCropPrescription.medication_administering_time'),'order'=>array('NewCropPrescription.id DESC'),
				'conditions'=>array('archive'=>'N','prn'=>'1','NewCropPrescription.patient_uniqueid'=>$patientId,'firstdose <='=>date('Y-m-d H:i:s'),
						'NewCropPrescription.location_id'=>$this->Session->read('locationid'))));
	}

	/**
	 * @method getContineousInfusionMedication
	 * @param int type $patientId
	 * @return void
	 * @author Gaurav Chauriya
	 */
	private function getContineousInfusionMedication($patientId=null){

		$this->NewCropPrescription->bindModel(array(
				'hasOne'=>array('PatientOrder'=>array('foreignKey'=>false,
						'conditions'=>array('PatientOrder.id=NewCropPrescription.patient_order_id'))
				),
				'hasMany'=>array('MedicationAdministeringRecord'=>array('foreignKey'=>'new_crop_prescription_id',
						'conditions'=>array('MedicationAdministeringRecord.late_reason_flag=0','MedicationAdministeringRecord.admin_note_flag=0',
								"MedicationAdministeringRecord.patient_id=$patientId",'MedicationAdministeringRecord.med_request_flag=0'),
						'fields'=>array('MedicationAdministeringRecord.id','MedicationAdministeringRecord.performed_datetime','MedicationAdministeringRecord.dose'),
						'order'=>array('MedicationAdministeringRecord.id DESC')
				),

				),
		));
		$intravenousRoute = configure::read('selected_route_administration');
		return $this->NewCropPrescription->find('all',array('fields'=>array('PatientOrder.sentence','NewCropPrescription.id','NewCropPrescription.drug_name',
				'NewCropPrescription.description','NewCropPrescription.dose','NewCropPrescription.strength','NewCropPrescription.route',
				'NewCropPrescription.firstdose','NewCropPrescription.medication_administering_time'),'order'=>array('NewCropPrescription.id DESC'),
				'conditions'=>array('archive'=>'N','prn'=>'0','route'=>array($intravenousRoute['INTRAVENOUS'],$intravenousRoute['INJECT INTRAMUSCULAR']),'NewCropPrescription.patient_uniqueid'=>$patientId,
						'NewCropPrescription.location_id'=>$this->Session->read('locationid'))));
	}

	/**
	 * @method getDisContScheduledMedication
	 * @param int type $patientId
	 * @return void
	 * @author Gaurav Chauriya
	 */
	private function getDisContScheduledMedication($patientId=null){

		$this->NewCropPrescription->bindModel(array(
				'hasOne'=>array('PatientOrder'=>array('foreignKey'=>false,
						'conditions'=>array('PatientOrder.id=NewCropPrescription.patient_order_id')))
		));
		$intravenousRoute = configure::read('selected_route_administration');
		return $this->NewCropPrescription->find('all',array('fields'=>array('PatientOrder.sentence','NewCropPrescription.id','drug_name','description','dose','strength'),
				'conditions'=>array('archive'=>'Y','prn'=>'0','route NOT'=>array($intravenousRoute['INTRAVENOUS'],$intravenousRoute['INJECT INTRAMUSCULAR']),'NewCropPrescription.patient_uniqueid'=>$patientId,
						'NewCropPrescription.location_id'=>$this->Session->read('locationid')),
				'order'=>array('NewCropPrescription.id DESC')));
	}

	/**
	 * @method getFutureMedication
	 * @param int type $patientId
	 * @return void
	 * @author Gaurav Chauriya
	 */
	private function getFutureMedication($patientId=null){

		$this->NewCropPrescription->bindModel(array(
				'hasOne'=>array('PatientOrder'=>array('foreignKey'=>false,
						'conditions'=>array('PatientOrder.id=NewCropPrescription.patient_order_id')))
		));
		return $this->NewCropPrescription->find('all',array('fields'=>array('PatientOrder.sentence','NewCropPrescription.id','NewCropPrescription.drug_name',
				'NewCropPrescription.description','NewCropPrescription.dose','NewCropPrescription.strength','NewCropPrescription.route'),
				'conditions'=>array('archive'=>'N','DATE_FORMAT(firstdose, "%Y-%m-%d") >='=>date('Y-m-d')." 00:00:00",
						'NewCropPrescription.patient_uniqueid'=>$patientId,'NewCropPrescription.location_id'=>$this->Session->read('locationid')),
				'order'=>array('NewCropPrescription.id DESC')));
	}

	/**
	 * @method getDisContPrnMedication
	 * @param int type $patientId
	 * @return void
	 * @author Gaurav Chauriya
	 */
	private function getDisContPrnMedication($patientId=null){

		$this->NewCropPrescription->bindModel(array(
				'hasOne'=>array('PatientOrder'=>array('foreignKey'=>false,
						'conditions'=>array('PatientOrder.id=NewCropPrescription.patient_order_id')))
		));
		return $this->NewCropPrescription->find('all',array('fields'=>array('PatientOrder.sentence','NewCropPrescription.id','drug_name','description','dose','strength'),
				'conditions'=>array('archive'=>'Y','prn'=>'1','NewCropPrescription.patient_uniqueid'=>$patientId,
						'NewCropPrescription.location_id'=>$this->Session->read('locationid')),
				'order'=>array('NewCropPrescription.id DESC')));
	}

	/**
	 * @method getDisContineousInfusionMedication
	 * @param int type $patientId
	 * @return void
	 * @author Gaurav Chauriya
	 */
	private function getDisContineousInfusionMedication($patientId=null){

		$this->NewCropPrescription->bindModel(array(
				'hasOne'=>array('PatientOrder'=>array('foreignKey'=>false,
						'conditions'=>array('PatientOrder.id=NewCropPrescription.patient_order_id')))
		));
		$intravenousRoute = configure::read('selected_route_administration');
		return $this->NewCropPrescription->find('all',array('fields'=>array('PatientOrder.sentence','NewCropPrescription.id','drug_name','description','dose','strength'),
				'conditions'=>array('archive'=>'Y','prn'=>'0','route'=>array($intravenousRoute['INTRAVENOUS'],$intravenousRoute['INJECT INTRAMUSCULAR']),'NewCropPrescription.patient_uniqueid'=>$patientId,
						'NewCropPrescription.location_id'=>$this->Session->read('locationid')),
				'order'=>array('NewCropPrescription.id DESC')));
	}

	/**
	 * @method patientWristBandCheck
	 * @param int type $patientId
	 * @return void
	 * @author Gaurav Chauriya
	 */
	public function patientWristBandCheck($patientId= null,$newCropID=null){
		$this->layout  = 'ajax';
		$this->uses = array('Patient','Configuration');
		
		$this->set('patient_id',$patientId);
		$this->set('newCropID',$newCropID);
		$this->set('date',$this->params->query['date']);
		$this->set('color',$this->params->query['color']);
		if(isset($this->request->data['id']) && !empty($this->request->data['id'])){
			$this->Patient->unBindModel(array(
					'belongsTo' => array('AdvanceDirective','Guardian','User','Diagnosis','PatientInitial'),
					'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
			$this->Patient->bindModel(array(
					'belongsTo'=>array('Person'=>array('foreignKey'=>false,
							'conditions'=>array('Patient.person_id=Person.id')))
			));
			$patientQrFields = $this->Patient->find('all',array('fields'=>array('Patient.patient_id','Patient.lookup_name','Person.dob'),
					'conditions'=>array('Patient.id'=>$patientId)));
			$dob = $this->DateFormat->formatDate2Local($patientQrFields['0']['Person']['dob'],Configure::read('date_format'),false);
			$qrString = $patientQrFields['0']['Patient']['patient_id']."#".$patientQrFields['0']['Patient']['lookup_name']."#".$dob;
			$patientCheck = true;//($qrString == $this->request->data['id']) ? true : false;
			echo $patientCheck."!!".$this->request->data['newCropID']."!!".$this->request->data['date']."!!".$this->request->data['color'];
			exit;

		}else if(isset($this->request->data['id'])){
			echo 'Not scanned';
			exit;
		}

	}

	/**
	 * @method prescribedMedicationList
	 * @param int type $patientId
	 * @return void
	 * @author Gaurav Chauriya
	 */
	function prescribedMedicationList($patientId,$lastInsertedNewCropId=null){
		ob_end_clean();
		ob_start("ob_gzhandler");
		$this->layout = 'ajax';
		$this->uses = array('Patient','EmarDashboardSetting','MedicationAdministeringRecord');
		$this->patient_info($patientId);
		$lastInsertedNewCropId  =  array();
		$intravenousRoute = configure::read('selected_route_administration');
		if($this->request['isAjax']){
			foreach($this->request->data['SignMar'] as $newCropArray){
				$idArray[] = $newCropArray['id'];

			}
			if(!empty($lastInsertedNewCropId)){
				$lastInsertedNewCropId = explode(',',$lastInsertedNewCropId);
				$condition = array('NewCropPrescription.id'=>$idArray,'NewCropPrescription.id NOT '=>$lastInsertedNewCropId,
						'NewCropPrescription.patient_uniqueid'=>$patientId,//'NewCropPrescription.route NOT '=>array($intravenousRoute['INTRAVENOUS'],$intravenousRoute['INJECT INTRAMUSCULAR']),
						'NewCropPrescription.location_id'=>$this->Session->read('locationid'));
			}else{
				$condition = array('NewCropPrescription.id'=>$idArray,'NewCropPrescription.patient_uniqueid'=>$patientId,
						'NewCropPrescription.route NOT'=>array($intravenousRoute['INTRAVENOUS'],$intravenousRoute['INJECT INTRAMUSCULAR']),
						'NewCropPrescription.location_id'=>$this->Session->read('locationid'));
			}

			$medicationData = $this->NewCropPrescription->find('all',array('fields'=>array('id','route','dose','strength'),
					'conditions'=>$condition));
			if(!empty($medicationData)){
				foreach($medicationData as $insertToSign){
					$performed_datetime = date('Y-m-d H:i:s');//$this->DateFormat->formatDate2STD(date("d/m/Y H:i:s"),Configure::read('date_format'));
					$medArray['patient_id'] = $patientId;
					$medArray['new_crop_prescription_id'] = $insertToSign['NewCropPrescription']['id'];
					$medArray['route'] = $insertToSign['NewCropPrescription']['route'];
					$medArray['dose'] = $insertToSign['NewCropPrescription']['dose'];
					$medArray['performed_datetime'] = $performed_datetime;
					$medArray['performed_by'] = $this->Session->read('userid');
					$medArray['form'] = $insertToSign['NewCropPrescription']['strength'];
					$medArray['created_by'] = $this->Session->read('userid');
					$medArray['modified_by'] = $this->Session->read('userid');
					$medArray['create_time'] = date('Y-m-d H:i:s');
					$medArray['modify_time'] = date('Y-m-d H:i:s');
					$medArray['location_id'] = $this->Session->read('locationid');
					$this->MedicationAdministeringRecord->save($medArray);
				}

			}
			$this->MedicationAdministeringRecord->signMedications($patientId,$this->request->data);
		}else{
			$administerNowMeds = $this->EmarDashboardSetting->medToAdministerNow($patientId);
			$prnMedication = $this->getPrnMedication($patientId);
			$contineousInfusion = $this->getContineousInfusionMedication($patientId);
			$this->set(compact('administerNowMeds','prnMedication','contineousInfusion'));
		}
	}

	/**
	 * @method medicationAdministeringRecord
	 * @return void
	 * @author Gaurav Chauriya
	 */
	function medicationAdministeringRecord($patientId=null,$newCropPrescId=null){
		ob_end_clean();
		ob_start("ob_gzhandler");
		$this->layout = false;
		$this->uses = array('MedicationAdministeringRecord');
		$this->set(compact('newCropPrescId'));
		if(!empty($this->request->data['MedicationAdministeringRecord'])){
			$this->request->data['MedicationAdministeringRecord']['performed_datetime'] =
			$this->DateFormat->formatDate2STD($this->request->data['MedicationAdministeringRecord']['performed_datetime'],Configure::read('date_format'));
			if(!empty($this->request->data['MedicationAdministeringRecord']['infused_time'])){
				if($this->request->data['MedicationAdministeringRecord']['inf_time_unit'] == 'hour'){
					$this->request->data['MedicationAdministeringRecord']['inf_volume_hourly'] = number_format(floatval(($this->request->data['MedicationAdministeringRecord']['total_volume']/$this->request->data['MedicationAdministeringRecord']['infused_time'])),2);
				}else{
					$infusedHour = $this->request->data['MedicationAdministeringRecord']['infused_time']/60;
					$this->request->data['MedicationAdministeringRecord']['inf_volume_hourly'] = number_format(floatval($this->request->data['MedicationAdministeringRecord']['total_volume']),2);//($this->request->data['MedicationAdministeringRecord']['total_volume']/$infusedHour));
				}
			}
			$this->MedicationAdministeringRecord->insertRecord($this->request->data);
			$this->set(array('setFlash'=>1,'newCropPrescId'=>$this->request->data['MedicationAdministeringRecord']['new_crop_prescription_id']));
		}
		$this->NewCropPrescription->bindModel(array(
				'hasOne'=>array('PatientOrder'=>array('foreignKey'=>false,
						'conditions'=>array('PatientOrder.id=NewCropPrescription.patient_order_id')))
		));
		$medicationData = $this->NewCropPrescription->find('first',array('fields'=>array('PatientOrder.sentence','id','route','drug_name',
				'description','dose','strength'),
				'conditions'=>array('NewCropPrescription.id'=>$newCropPrescId,'NewCropPrescription.patient_uniqueid'=>$patientId,
						'NewCropPrescription.location_id'=>$this->Session->read('locationid'))));

		$bagCount = $this->MedicationAdministeringRecord->find('count',array('conditions'=>array('MedicationAdministeringRecord.patient_id'=>$patientId,
				'MedicationAdministeringRecord.new_crop_prescription_id'=>$newCropPrescId,'MedicationAdministeringRecord.site !='=>'',
				'MedicationAdministeringRecord.is_signed'=>'1','MedicationAdministeringRecord.location_id'=>$this->Session->read('locationid'))));
		$this->set(compact('medicationData','patientId','bagCount'));

	}

	/**
	 * @method earlyLateReason
	 * @param $patientId
	 * @return void
	 * @author Gaurav Chauriya
	 *
	 */
	public function earlyLateReason($patientId=null,$newCropPrescId=null){
		$this->layout=false;
		$this->uses = array('MedicationAdministeringRecord');
		$newCropPrescId = substr($newCropPrescId,0 , -1);
		$this->set(compact('newCropPrescId'));
		if(!empty($this->request->data['MedicationAdministeringRecord'])){
			$this->request->data['MedicationAdministeringRecord']['late_reason_flag']=1;
			//$this->request->data['MedicationAdministeringRecord']['is_signed']=1;
			$this->request->data['MedicationAdministeringRecord']['performed_by']=$this->Session->read('userid');
			$this->request->data['MedicationAdministeringRecord']['performed_datetime'] =
			$this->DateFormat->formatDate2STD($this->request->data['MedicationAdministeringRecord']['performed_datetime'],Configure::read('date_format'));
			$this->request->data['MedicationAdministeringRecord']['scheduled_datetime'] =
			$this->DateFormat->formatDate2STD($this->request->data['MedicationAdministeringRecord']['scheduled_datetime'],Configure::read('date_format'));
			$this->MedicationAdministeringRecord->insertRecord($this->request->data);
			$this->set(array('setFlash'=>1,'newCropPrescId'=>$this->request->data['MedicationAdministeringRecord']['new_crop_prescription_id'],
					'route'=>$this->request->data['NewCropPrescription']['route']));
		}
		$this->NewCropPrescription->bindModel(array(
				'hasOne'=>array('PatientOrder'=>array('foreignKey'=>false,
						'conditions'=>array('PatientOrder.id=NewCropPrescription.patient_order_id')),
						'MedicationAdministeringRecord'=>array('foreignKey'=>false,
								'conditions'=>array('MedicationAdministeringRecord.new_crop_prescription_id=NewCropPrescription.id'),
								'order'=>array('MedicationAdministeringRecord.id' => 'DESC'))
				)));

		$medicationData = $this->NewCropPrescription->find('first',array('fields'=>array('MedicationAdministeringRecord.comment',
				'MedicationAdministeringRecord.reason','PatientOrder.sentence','NewCropPrescription.route','NewCropPrescription.drug_name',
				'NewCropPrescription.description','NewCropPrescription.dose','NewCropPrescription.strength','NewCropPrescription.strength','NewCropPrescription.id'),
				'conditions'=>array('NewCropPrescription.id'=>$newCropPrescId,'NewCropPrescription.patient_uniqueid'=>$patientId,
						'NewCropPrescription.location_id'=>$this->Session->read('locationid'))));
		//$this->data = $medicationData;
		$this->set(compact('medicationData','patientId'));

	}

	/**
	 * @method contineousInfusionChanges
	 * @param int type $patientId
	 * @return void
	 * @author Gaurav Chauriya
	 */
	public function contineousInfusionChanges($patientId=null,$newCropPrescId=null){

		$this->layout = false;
		$this->uses = array('MedicationAdministeringRecord');
		$this->MedicationAdministeringRecord->bindModel(array(
				'hasOne'=>array(
						'NewCropPrescription'=>array('foreignKey'=>false,
								'conditions'=>array('MedicationAdministeringRecord.new_crop_prescription_id=NewCropPrescription.id')),
						'PatientOrder'=>array('foreignKey'=>false,
								'conditions'=>array('PatientOrder.id=NewCropPrescription.patient_order_id')))
		));
		$medicationData = $this->MedicationAdministeringRecord->find('first',array('fields'=>array('PatientOrder.sentence','NewCropPrescription.description',
				'MedicationAdministeringRecord.id','MedicationAdministeringRecord.performed_datetime','MedicationAdministeringRecord.bag_no',
				'MedicationAdministeringRecord.site','MedicationAdministeringRecord.inf_volume_hourly','MedicationAdministeringRecord.volume',
				'MedicationAdministeringRecord.diluent_volume','MedicationAdministeringRecord.infused_time','MedicationAdministeringRecord.inf_time_unit'),
				'conditions'=>array('MedicationAdministeringRecord.new_crop_prescription_id'=>$newCropPrescId,
						'MedicationAdministeringRecord.patient_id'=>$patientId,'MedicationAdministeringRecord.location_id'=>$this->Session->read('locationid')),
				'order'=>array('MedicationAdministeringRecord.id DESC')));

		$medicationData['MedicationAdministeringRecord']['infuse_vol'] =
		$medicationData['MedicationAdministeringRecord']['volume'] + $medicationData['MedicationAdministeringRecord']['diluent_volume'];
		if($medicationData['MedicationAdministeringRecord']['inf_time_unit'] == 'minutes')
			$medicationData['MedicationAdministeringRecord']['infused_time'] =  $medicationData['MedicationAdministeringRecord']['infused_time']/60;
		$this->set(compact('medicationData','patientId'));
	}

	/**
	 * @method orderInfo
	 * @param int type $patientId
	 * @return void
	 * @author Gaurav Chauriya
	 */
	public function orderInfo($patientId=null,$newCropPrescId=null){
		$this->layout = false;
	}

	/**
	 * @method eventTaskSummary
	 * @param int type $patientId
	 * @return void
	 * @author Gaurav Chauriya
	 */
	public function eventTaskSummary($patientId=null,$newCropPrescId=null){
		$this->layout = false;
	}

	/**
	 * @method referenceManual
	 * @param int type $patientId
	 * @return void
	 * @author Gaurav Chauriya
	 */
	public function referenceManual($patientId=null,$newCropPrescId=null){
		$this->layout = false;
	}

	/**
	 * @method medRequest
	 * @param int type $patientId
	 * @return void
	 * @author Gaurav Chauriya
	 */
	public function medRequest($patientId=null,$newCropPrescId=null){
		$this->layout = false;
		$this->uses = array('MedicationAdministeringRecord');
		if(!empty($this->request->data['MedicationAdministeringRecord'])){
			$this->request->data['MedicationAdministeringRecord']['med_request_flag']=1;
			$this->request->data['MedicationAdministeringRecord']['sign_record']=1;
			$this->MedicationAdministeringRecord->insertRecord($this->request->data);
			$this->set('setFlash','1');
		}
		$this->NewCropPrescription->bindModel(array(
				'hasOne'=>array('PatientOrder'=>array('foreignKey'=>false,
						'conditions'=>array('PatientOrder.id=NewCropPrescription.patient_order_id')),
						'MedicationAdministeringRecord'=>array('foreignKey'=>false,
								'conditions'=>array('MedicationAdministeringRecord.new_crop_prescription_id=NewCropPrescription.id'),
								'order'=>array('MedicationAdministeringRecord.id' => 'DESC'))
				)));

		$medicationData = $this->NewCropPrescription->find('first',array('fields'=>array('MedicationAdministeringRecord.comment',
				'MedicationAdministeringRecord.reason','PatientOrder.sentence','NewCropPrescription.description','NewCropPrescription.id'),
				'conditions'=>array('NewCropPrescription.id'=>$newCropPrescId,'NewCropPrescription.patient_uniqueid'=>$patientId,
						'NewCropPrescription.location_id'=>$this->Session->read('locationid'))));

		$this->set(compact('medicationData','newCropPrescId','patientId'));

	}

	/**
	 * @method rescheduleAdminTime
	 * @param int type $patientId
	 * @return void
	 * @author Gaurav Chauriya
	 */
	public function rescheduleAdminTime($patientId=null,$newCropPrescId=null){
		$this->layout = false;
	}

	/**
	 * @method additionalDose
	 * @param int type $patientId
	 * @return void
	 * @author Gaurav Chauriya
	 */
	public function additionalDose($patientId=null,$newCropPrescId=null){
		$this->layout = false;
	}

	/**
	 * @method adminNote
	 * @param int type $patientId
	 * @return void
	 * @author Gaurav Chauriya
	 */
	public function adminNote($patientId=null,$newCropPrescId=null){
		$this->layout = false;
		$this->uses = array('MedicationAdministeringRecord');

		if(!empty($this->request->data['MedicationAdministeringRecord'])){
			$this->request->data['MedicationAdministeringRecord']['admin_note_flag']=1;
			$this->request->data['MedicationAdministeringRecord']['sign_record']=1;
			$this->MedicationAdministeringRecord->insertRecord($this->request->data);
			$this->set('setFlash','1');
		}
		$this->NewCropPrescription->bindModel(array(
				'hasOne'=>array('PatientOrder'=>array('foreignKey'=>false,
						'conditions'=>array('PatientOrder.id=NewCropPrescription.patient_order_id'))
				)));

		$medicationData = $this->NewCropPrescription->find('first',array('fields'=>array('PatientOrder.sentence','NewCropPrescription.route',
				'NewCropPrescription.drug_name','NewCropPrescription.description','NewCropPrescription.dose','NewCropPrescription.strength',
				'NewCropPrescription.id'),'conditions'=>array('NewCropPrescription.id'=>$newCropPrescId,'NewCropPrescription.patient_uniqueid'=>$patientId,
						'NewCropPrescription.location_id'=>$this->Session->read('locationid'))));

		$this->data = $medicationData;
		$this->set(compact('medicationData','newCropPrescId','patientId'));
	}

	/**
	 * @method alertHistory
	 * @param int type $patientId
	 * @return void
	 * @author Gaurav Chauriya
	 */
	public function alertHistory($patientId=null,$newCropPrescId=null){
		$this->layout = false;
	}

	/**
	 * @method infusionBilling
	 * @param int type $patientId
	 * @return void
	 * @author Gaurav Chauriya
	 */
	public function infusionBilling($patientId=null,$newCropPrescId=null){
		$this->layout = false;
	}

	/**
	 * @method dashboardMedicationList
	 * @internal function to list medication prescribed (for indian instances only)
	 * @param int $patientId
	 * @author Gaurav Chauriya
	 */
	public function dashboardMedicationList($patientId){
		//$this->layout = false;
		$this->set('patientId',$patientId);
		$this->loadModel('NewCropPrescription');
		$this->loadModel('PrescriptionRecord');
		$this->loadModel('EmarDashboardSetting');
		$existingSetting = $this->EmarDashboardSetting->find('all',array('conditions'=>array('user_id'=>$this->Session->read('userid'))));
		$conditions = $this->getSettingConditions($existingSetting,$patientId);
		$this->NewCropPrescription->bindModel(array(
				'belongsTo'=>array(
						'PharmacySalesBill'=>array('foreignKey'=>false,'conditions'=>array('NewCropPrescription.pharmacy_sales_bill_id = PharmacySalesBill.id')),
						'PharmacySalesBillDetail'=>array('foreignKey'=>false,'conditions'=>array('PharmacySalesBillDetail.item_id = NewCropPrescription.drug_id',
								'PharmacySalesBillDetail.pharmacy_sales_bill_id = PharmacySalesBill.id')),
				)));
		$getPreviousMedication=$this->NewCropPrescription->find('all',array('fields'=>array('NewCropPrescription.id','NewCropPrescription.description','NewCropPrescription.day',
				'NewCropPrescription.quantity','NewCropPrescription.dose','NewCropPrescription.DosageForm','NewCropPrescription.dosageValue','NewCropPrescription.strength',
				'NewCropPrescription.route','NewCropPrescription.frequency','NewCropPrescription.prn','NewCropPrescription.firstdose',
				'NewCropPrescription.stopdose','NewCropPrescription.drug_name','NewCropPrescription.date_of_prescription','NewCropPrescription.pharmacy_sales_bill_id',
				'NewCropPrescription.patient_id','PharmacySalesBill.id','PharmacySalesBillDetail.id','PharmacySalesBill.is_received','PharmacySalesBillDetail.qty'),
				'conditions'=>$conditions));
		$administeredCount = $this->PrescriptionRecord->find('all',array('fields'=>array('PrescriptionRecord.id','PrescriptionRecord.new_crop_prescription_id',
				'PrescriptionRecord.quantity','PrescriptionRecord.administered_time','PrescriptionRecord.dose_form')));
		
		foreach($administeredCount as $medications){
			$medicationData[$medications['PrescriptionRecord']['new_crop_prescription_id']][] = 
			$medications['PrescriptionRecord']['quantity'].' '.$medications['PrescriptionRecord']['dose_form'].' - '.
			$this->DateFormat->formatDate2LocalForReport($medications['PrescriptionRecord']['administered_time'],Configure::read('date_format'),true);;
			$medicationQuantity[$medications['PrescriptionRecord']['new_crop_prescription_id']] = 
			floatval($medicationQuantity[$medications['PrescriptionRecord']['new_crop_prescription_id']])  + floatval($medications['PrescriptionRecord']['quantity']);
		}
		$this->set('medicationQuantity',$medicationQuantity);
		$this->set('countOfAdministered',$medicationData);
		$this->set('getPreviousMedication',$getPreviousMedication);
		
	}

	/**
	 * @method administerMedication
	 * @internal function to administer medication (for indian instances only)
	 * @param int $patientId
	 * @author Gaurav Chauriya
	 */
	public function administerMedication($newCropPrescriptionId){
		$this->layout = 'advance_ajax';
		$medicationData=$this->NewCropPrescription->find('first',array('fields'=>array('NewCropPrescription.id','NewCropPrescription.description','NewCropPrescription.patient_uniqueid'),
				'conditions'=>array('NewCropPrescription.id'=>$newCropPrescriptionId)));
		$this->set('medicationData',$medicationData);
	}
	public function returnMed($newCropPrescriptionId){
		$this->layout = 'advance_ajax';
		$medicationData=$this->NewCropPrescription->find('first',array('fields'=>array('NewCropPrescription.id','NewCropPrescription.returnQuantity','NewCropPrescription.returnReason','NewCropPrescription.patient_uniqueid','NewCropPrescription.description'),
				'conditions'=>array('NewCropPrescription.id'=>$newCropPrescriptionId)));
		$this->set('medicationData',$medicationData);
	}
	public function saveAdministerMed(){
		$this->uses = array('PrescriptionRecord');
		$this->PrescriptionRecord->insertPrescriptionRecord($this->request->data);
		exit;
	}
	public function saveReturnMed(){
		$this->uses = array('NewCropPrescription');
		debug($this->request->data);
		$this->NewCropPrescription->updateAll(array('returnQuantity'=>"'".$this->request->data['returnQuantity']."'",'returnReason'=>"'".$this->request->data['returnReason']."'"),array('id'=>$this->request->data['new_crop_prescription_id']));
		
		$log = $this->NewCropPrescription->getDataSource()->getLog(false, false);
		debug($log);
		exit;
	}
	private function getSettingConditions($existingSetting,$patientId){
		$intravenousRoute = configure::read('selected_route_administration');
		$conditions = array('NewCropPrescription.patient_uniqueid'=>$patientId,'NewCropPrescription.is_deleted'=>'0','NewCropPrescription.archive'=>'N',
				'NewCropPrescription.status'=>1,'NewCropPrescription.location_id'=>$this->Session->read('locationid'),'PharmacySalesBill.is_received'=>1);
		if(!$existingSetting['0']['EmarDashboardSetting']['prn'])
			$conditions['NewCropPrescription.prn != '] = '1';
		
		if(!$existingSetting['0']['EmarDashboardSetting']['continfusion'])
			$conditions['NewCropPrescription.route NOT'] = array($intravenousRoute['INTRAVENOUS'],$intravenousRoute['INJECT INTRAMUSCULAR']);
		return $conditions;
	}
	public function inpatientDashboard($patientId){

		//$this->layout = false;
		$this->patient_info($patientId);


		$this->uses = array('Widget','PatientsTrackReport','LaboratoryResult','LaboratoryHl7Result','TariffList','DoctorProfile','Patient');
		$this->PatientsTrackReport->getAllPatientIds($this->patient_details['Person']['id']);
		$userArray = array($this->Session->read('userid'));

		//for inserting newcrop medication into Newcropprescription table
		$get_medication=$this->get_medication_record($this->patient_details['Person']['id'],$patientId);
			
		$CountOfMedicationRecords=count($get_medication);

		for($i=0;$i<$CountOfMedicationRecords;$i++){

			$MedicationSpecific[] = $get_medication[$i];

		}

		if($get_medication['0']!=""){
			$this->Patient->insertPrescription($this->patient_details['Person']['id'],$patientId,$MedicationSpecific);
		}

		//

		//$this->Session->read('userid')
		$currentUserId = 1;

		$columns = $this->Widget->find('all',array('fields' => array('Widget.id','Widget.user_id','Widget.application_screen_name','Widget.column_id',
				'Widget.collapsed','Widget.title'),
				'conditions' => array('Widget.is_deleted'=> 0,'Widget.user_id' => $currentUserId,
						'Widget.application_screen_name' => 'Inpatient Summary'),
				'order' => array('Widget.column_id','Widget.sort_no'),'group'=>array('Widget.title')));
		if(empty($columns) && count($columns < 1)){
			$columns = $this->Widget->find('all',array('fields' => array('Widget.id','Widget.user_id','Widget.application_screen_name',
					'Widget.column_id','Widget.collapsed','Widget.title'),
					'conditions' => array('Widget.is_deleted'=> 0,'Widget.user_id' => 0,'Widget.application_screen_name' => 'Inpatient Summary'),
					'order' => array('Widget.column_id','Widget.sort_no'),'group'=>array('Widget.title')));
		}//pr($columns);exit;
		//echo '<pre>';print_r($this->PatientsTrackReport->getVitals($patientId));exit;

		////////Dynamic labs section/////////

		/*$this->LaboratoryResult->bindModel(array(
		 'belongsTo' => array(
		 		'Laboratory'=>array('foreignKey'=>'laboratory_id'),
		 		'TestGroup'=>array('foreignKey'=>false, 'conditions' => array('TestGroup.id=Laboratory.test_group_id')),

		 )));
		// lab category given to patient //
		$getLabsGroupList = $this->LaboratoryResult->find('all', array('conditions' => array('LaboratoryResult.patient_id' => $patientid, 'TestGroup.name NOT' => NULL), 'fields' => array('TestGroup.name', 'TestGroup.id'), 'group' => array('TestGroup.name')));
		$this->set('getLabsGroupList', $getLabsGroupList);

		$this->LaboratoryHl7Result->bindModel(array(
				'belongsTo' => array(
						'Laboratory'=>array('foreignKey'=>false, 'conditions' => array('Laboratory.lonic_code=LaboratoryHl7Result.observations')),
						'LaboratoryResult'=>array('foreignKey'=>false, 'conditions' => array('LaboratoryResult.id=LaboratoryHl7Result.laboratory_result_id')),

		)), false);
		// set lab results with past value //
		$getOrderLabsStatusList = $this->LaboratoryHl7Result->find('all', array('conditions' => array('LaboratoryResult.patient_id' => $patientid), 'fields' => array('Laboratory.test_group_id', 'Laboratory.name', 'Laboratory.id', 'Laboratory.lonic_code', 'LaboratoryHl7Result.result', 'LaboratoryHl7Result.observations'), 'order' => array('LaboratoryHl7Result.date_time_of_observation DESC')));
		foreach($getOrderLabsStatusList as $getOrderLabsStatusListVal) {
		$getPastValueWithLaboratory[$getOrderLabsStatusListVal['Laboratory']['test_group_id']][$getOrderLabsStatusListVal['LaboratoryHl7Result']['observations']][] = $getOrderLabsStatusListVal['LaboratoryHl7Result']['result'];
		}

		$this->set('getPastValueWithLaboratory', $getPastValueWithLaboratory);
		// get unique lab name given to patient //
		$getLabsStatusList = $this->LaboratoryHl7Result->find('all', array('conditions' => array('LaboratoryResult.patient_id' => $patientid), 'fields' => array('Laboratory.test_group_id', 'Laboratory.name', 'Laboratory.lonic_code'), 'group' => array('LaboratoryHl7Result.observations')));
		$this->set('getLabsStatusList', $getLabsStatusList);*/
		///////EOF labs section////////
		$trarifName=$this->TariffList->find('list',array('fields'=>array('id','name'),'conditions'=>array('is_deleted'=>'0','service_category_id'=>'36')));
		$optDoctor=$this->DoctorProfile->find('list',array('fields'=>array('id','doctor_name')));
		$this->set(array('noteDiagnoses' => $this->PatientsTrackReport->getDiagnosis($patientId),
				'newCropAllergies' => $this->PatientsTrackReport->getAllergies($patientId),
				'newCropPrescriptions' => $this->PatientsTrackReport->getMedications($patientId),
				'getPastMedicals'=> $this->PatientsTrackReport->getPastMedicals($patientId),
				'patientDocuments' => $this->PatientsTrackReport->getDocuments($patientId),
				'diagnosisSurgeries' => $this->PatientsTrackReport->getProcedures($patientId),

				//for lab//
				'getLabsName' => $this->PatientsTrackReport->getLabsName($patientId),
				'getLabsResult' => $this->PatientsTrackReport->getLabsResult($patientId),
				//end of lab//
				'getNotes' => $this->PatientsTrackReport->getNotes($patientId),
				'getVitals' => $this->PatientsTrackReport->getVitals($patientId),
				'getEkg' => $this->PatientsTrackReport->getEkg($patientId),
				'getPatientInfo' => $this->PatientsTrackReport->getPatientInfo($patientId),
				'getFlaggedEvents' => $this->PatientsTrackReport->getFlaggedEvents($patientId),



		));




		//	echo '<pre>';print_r($columns);exit;
		$this->set('trarifName', $trarifName);
		$this->set('optDoctor', $optDoctor);
		$this->set('columns',$columns);
		$this->set('patientId',$patientId);
		$this->set('patientUId',$this->patient_details['Patient']['patient_id']);
		$this->render('sbar');
	}

	public function insertMedicationInfo($id=null){
		//for inserting medication into newcrop by calling newcrop webservice
		$this->layout = "ajax" ;
		$this->patient_info($id);
		$this->uses = array('Patient');
		$patient_id=$this->patient_details['Patient']['patient_id'];

		$get_medication=$this->get_medication_record($patient_id,$id);
			
		$CountOfMedicationRecords=count($get_medication);

		for($i=0;$i<$CountOfMedicationRecords;$i++){

			$MedicationSpecific[] = $get_medication[$i];

		}

		if($get_medication['0']!=""){
			$this->Patient->insertPrescription($patient_id,$id,$MedicationSpecific);
		}

		echo "success";
		exit;
	}

	public function get_medication_record($id=null,$patient_uniqueid=null){

		//find facility id
		$this->loadModel("Facility");
		$this->Facility->unBindModel(array(
				'hasOne'=>array('FacilityDatabaseMapping','FacilityUserMapping')
		));
		$facility = $this->Facility->find('first', array('fields'=> array('Facility.id','Facility.name'),'conditions'=>array('Facility.is_deleted' => 0, 'Facility.is_active' => 1,'Facility.id' => $this->Session->read("facilityid"))));

		$curlData.='<?xml version="1.0" encoding="utf-8"?><soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
				<soap:Body>';

		$curlData.='<GetPatientFullMedicationHistory6 xmlns="https://secure.newcropaccounts.com/V7/webservices">';
		$curlData.= '<credentials>
				<PartnerName>DrMHope</PartnerName>
				<Name>'.Configure::read('uname').'</Name>
						<Password>'.Configure::read('passw').'</Password>
								</credentials>';
		$curlData.=' <accountRequest>
				<AccountId>'.$facility[Facility][name].'</AccountId>
						<SiteId>'.$facility[Facility][id].'</SiteId>
								</accountRequest>';
		$curlData.=' <patientRequest>
				<PatientId>'.$id.'</PatientId>
						</patientRequest>';
		$curlData.='<prescriptionHistoryRequest>
				<StartHistory>2004-01-01T00:00:00.000</StartHistory>
				<EndHistory>2012-01-01T00:00:00.000</EndHistory>
				<PrescriptionStatus>C</PrescriptionStatus>
				<PrescriptionSubStatus>%</PrescriptionSubStatus>
				<PrescriptionArchiveStatus>%</PrescriptionArchiveStatus>
				</prescriptionHistoryRequest>';
		$curlData.=' <patientInformationRequester>
				<UserType>S</UserType>
				<UserId>'.$id.'</UserId>
						</patientInformationRequester>';
		$curlData.=' <patientIdType>string</patientIdType>
				<includeSchema>Y</includeSchema>
				</GetPatientFullMedicationHistory6>
				</soap:Body>
				</soap:Envelope>';
		$url=Configure::read('SOAPUrl');
		$curl = curl_init();
		//echo $curlData;
		curl_setopt ($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl,CURLOPT_TIMEOUT,120);
		//curl_setopt($curl,CURLOPT_ENCODING,'gzip');

		curl_setopt($curl,CURLOPT_HTTPHEADER,array (
		'SOAPAction:"https://secure.newcropaccounts.com/V7/webservices/GetPatientFullMedicationHistory6"',
		'Content-Type: text/xml; charset=utf-8',
		));

		curl_setopt ($curl, CURLOPT_POST, 1);
		curl_setopt ($curl, CURLOPT_POSTFIELDS, $curlData);

		$result = curl_exec($curl);

		curl_close ($curl);
		$xml =simplexml_load_string($result);

		if($result!="")
		{

			$xml->registerXPathNamespace("soap", "http://schemas.xmlsoap.org/soap/envelope/");
			$finalxml=$xml->xpath('//soap:Body');
			$finalxml=$finalxml[0];

			$staus= $finalxml->GetPatientFullMedicationHistory6Response->GetPatientFullMedicationHistory6Result->Status;
			$response= $finalxml->GetPatientFullMedicationHistory6Response->GetPatientFullMedicationHistory6Result->XmlResponse;
			$rowcount= $finalxml->GetPatientFullMedicationHistory6Response->GetPatientFullMedicationHistory6Result->RowCount;
			//for getting patient
			$get_id=$this->Patient->find('all',array('fields'=>array('patient_id'),'conditions'=>array('Patient.id'=>$id)));

			$xmlString= base64_decode($response);

			$xmldata = simplexml_load_string($xmlString);


			//echo "<pre>";print_r($xmldata); exit;
			$xmlArray= array();

			$i=0;
			foreach($xmldata as $xmlDataKey => $xmlDataValue ){
					
					
				$xmlDataValue =  (array) $xmlDataValue;
					
				$xmlArray[$i]['description']=$xmlDataValue['DrugInfo'];
				$xmlArray[$i]['drug_id']=$xmlDataValue['DrugID'];
				$xmlArray[$i]['date_of_prescription']=$xmlDataValue['PrescriptionDate'];
				$xmlArray[$i]['drm_date']=date('Y-m-d');
				$xmlArray[$i]['route']=$xmlDataValue['Route'];
				$xmlArray[$i]['rxnorm']=$xmlDataValue['rxcui'];
				$xmlArray[$i]['archive']=$xmlDataValue['Archive'];
				$xmlArray[$i]['frequency']=$xmlDataValue['DosageFrequencyDescription'];

				$xmlArray[$i]['dose_unit']=$xmlDataValue['DosageForm'];
				$xmlArray[$i]['drug_name']=$xmlDataValue['DrugName'];
				$xmlArray[$i]['refills']=$xmlDataValue['Refills'];
				$xmlArray[$i]['quantity']=$xmlDataValue['Dispense'];
				$xmlArray[$i]['day']=$xmlDataValue['DaysSupply'];
				$xmlArray[$i]['strength']=$xmlDataValue['StrengthUOM'];

				//$xmlArray[$i]['PrintLeaflet']=$xmlDataValue['PrintLeaflet'];
				$xmlArray[$i]['PharmacyType']=$xmlDataValue['PharmacyType'];
				$xmlArray[$i]['PharmacyDetailType']=$xmlDataValue['PharmacyDetailType'];
				$xmlArray[$i]['FinalDestinationType']=$xmlDataValue['FinalDestinationType'];
				$xmlArray[$i]['FinalStatusType']=$xmlDataValue['FinalStatusType'];
				$xmlArray[$i]['DeaGenericNamedCode']=$xmlDataValue['DeaGenericNamedCode'];
				$xmlArray[$i]['DeaClassCode']=$xmlDataValue['DeaClassCode'];

				$xmlArray[$i]['PharmacyNCPDP']=$xmlDataValue['PharmacyNCPDP'];
				$xmlArray[$i]['PharmacyFullInfo']=$xmlDataValue['PharmacyFullInfo'];
				$xmlArray[$i]['DeaLegendDescription']=$xmlDataValue['DeaLegendDescription'];

				$xmlArray[$i]['dose']=$xmlDataValue['DosageNumberTypeID'];
				$xmlArray[$i]['DosageForm']=$xmlDataValue['DosageFormTypeId'];
				$xmlArray[$i]['frequency']=$xmlDataValue['DosageFrequencyTypeID'];
				$xmlArray[$i]['DosageRouteTypeId']=$xmlDataValue['DosageRouteTypeId'];
				$xmlArray[$i]['route']=$xmlDataValue['DosageRouteTypeId'];

				$xmlArray[$i]['PrescriptionNotes']=$xmlDataValue['PrescriptionNotes'];
				$xmlArray[$i]['PharmacistNotes']=$xmlDataValue['PharmacistNotes'];

				if($xmlDataValue['TakeAsNeeded']=='N')
					$pnr='0';
				else
					$pnr='1';
				if($xmlDataValue['DispenseAsWritten']=='N')
					$daw='0';
				else
					$daw='1';
				$xmlArray[$i]['prn']=$pnr;
				$xmlArray[$i]['daw']=$daw;
				$xmlArray[$i]['PrescriptionGuid']=$xmlDataValue['PrescriptionGuid'];
				$i++;
			}


			return $xmlArray;


		}
	}


	public function saveWidget(){
		$this->layout = false;
		/*
		 //$this->layout = false;
		$this->uses = array('Widget');
		$widgetData = json_decode($this->request->data[0],true);
		$widgetData = $widgetData['items'];
			

		foreach($widgetData as $item) {

		$col_id=preg_replace('/[^\d\s]/', '', $item['column']);
		$widget_id=preg_replace('/[^\d\s]/', '', $item['id']);
		if($item['user_id'] != '0')
			$this->Widget->id = $widget_id;
		else
			$this->Widget->id = '';
		$this->Widget->set('column_id',intval($col_id));
		$this->Widget->set('sort_no',intval($item['order']));
		$this->Widget->set('collapsed',intval($item['collapsed']));
		$this->Widget->set('application_screen_name',$item['application_screen_name']);
		$this->Widget->set('title',$item['title']);
		$this->Widget->set('user_id',$this->Session->read('userid'));
		$this->Widget->set('section',$item['section']);
		//$widgetModel->set('application_screen_name',$item->application_screen_name);
		//pr($this->Widget);
		$this->Widget->save();
		$this->Widget->id = '';
		}*/

		exit;
	}

	/**
	 * ajaxGetInputOutputIntake ajax method
	 *
	 * @param string $scaleVal
	 * @return void
	 */
	public function ajaxGetInputOutputIntake($patientid){
		$this->uses = array('ReviewPatientDetail');
		if($this->params['isAjax']) {
			$this->layout = 'ajax';
			$this->ReviewPatientDetail->bindModel(array(
					'belongsTo'=>array('Patient'=>array('foreignKey'=>'patient_id'),
							'ReviewSubCategory'=>array('foreignKey'=>false, 'conditions' => array('ReviewSubCategory.id=ReviewPatientDetail.review_sub_categories_id')),
							'ReviewSubCategoriesOption'=>array('foreignKey'=>false, 'conditions' => array('ReviewSubCategoriesOption.review_sub_categories_id=ReviewSubCategory.id')),
							'ReviewCategory'=>array('foreignKey'=>false, 'conditions' => array('ReviewCategory.id=ReviewSubCategory.review_category_id')),

					)), false);
			// for input/output intake report //
			$lastThreeDays = array(date('Y-m-d', strtotime(date('Y-m-d'). ' - 2 day')), date('Y-m-d'));
			$getInputIntake = $this->ReviewPatientDetail->find('all', array('conditions' => array('ReviewSubCategory.parameter' => array('intake', 'output'), 'ReviewPatientDetail.patient_id' => $patientid, 'ReviewPatientDetail.date BETWEEN ? AND ?' => $lastThreeDays), 'fields' => array('ReviewSubCategory.parameter', 'ReviewCategory.name', 'ReviewSubCategory.name', 'ReviewSubCategoriesOption.name', 'ReviewPatientDetail.values', 'ReviewPatientDetail.date'),  'order' => array('ReviewSubCategory.name DESC'), 'group' => array('ReviewPatientDetail.review_sub_categories_id', 'ReviewPatientDetail.date', 'ReviewPatientDetail.hourSlot')));
			$this->set('getInputIntake', $getInputIntake);
		}
	}

	/**
	 * ajaxGetOtherIntake ajax method
	 *
	 * @param string $scaleVal
	 * @return void
	 */
	public function ajaxGetOtherIntake($patientid){
		if($this->params['isAjax']) {
			$this->layout = 'ajax';
		}
	}

	/**
	 * ajaxGetLabsStatus ajax method
	 *
	 * @param string $scaleVal
	 * @return void
	 */
	public function ajaxGetLabsStatus($patientid){
		$this->uses = array('LaboratoryHl7Result');
		if($this->params['isAjax']) {
			$this->layout = 'ajax';
			$this->LaboratoryHl7Result->bindModel(array(
					'belongsTo'=>array('LaboratoryResult'=>array('foreignKey'=>'laboratory_result_id'),
							'LaboratoryTestOrder'=>array('foreignKey'=>false, 'conditions' => array('LaboratoryTestOrder.id=LaboratoryResult.laboratory_test_order_id')),
							'Laboratory'=>array('foreignKey'=>false, 'conditions' => array('Laboratory.id=LaboratoryTestOrder.laboratory_id')),
							'LaboratoryCategory'=>array('foreignKey'=>false, 'conditions' => array('Laboratory.id=LaboratoryCategory.laboratory_id')),

					)));

			$getLabsStatusList = $this->LaboratoryHl7Result->find('all', array('conditions' => array('LaboratoryResult.patient_id' => $patientid), 'fields' => array('LaboratoryCategory.category_name', 'Laboratory.name', 'LaboratoryHl7Result.observations', 'LaboratoryHl7Result.result', 'LaboratoryHl7Result.sn_result2'),  'order' => array('Laboratory.name DESC')));
			$this->set('getLabsStatusList', $getLabsStatusList);
		}
	}


	/**
	 * ajaxGetRespiratoryStatus ajax method
	 *
	 * @param string $scaleVal
	 * @return void
	 */
	public function ajaxGetRespiratoryStatus($patientid){
		$this->uses = array('ReviewPatientDetail');
		if($this->params['isAjax']) {
			$this->layout = 'ajax';
			// for respiratory status report //
			$this->ReviewPatientDetail->bindModel(array(
					'belongsTo'=>array('Patient'=>array('foreignKey'=>'patient_id'),
							'ReviewSubCategory'=>array('foreignKey'=>false, 'conditions' => array('ReviewSubCategory.id=ReviewPatientDetail.review_sub_categories_id')),
							'ReviewSubCategoriesOption'=>array('foreignKey'=>false, 'conditions' => array('ReviewSubCategoriesOption.review_sub_categories_id=ReviewSubCategory.id')),
							'ReviewCategory'=>array('foreignKey'=>false, 'conditions' => array('ReviewCategory.id=ReviewSubCategory.review_category_id')),

					)));
			$getRespiratoryStatusList = $this->ReviewPatientDetail->find('all', array('fields' => array('ReviewCategory.name', 'ReviewSubCategory.name', 'ReviewSubCategoriesOption.name', 'ReviewPatientDetail.values'),  'order' => array('ReviewCategory.name DESC')));
			$this->set('getRespiratoryStatusList', $getRespiratoryStatusList);
		}
	}

	public function sbar($patientId,$clickedSection=null){
		$this->layout = 'advance' ;
		$this->patient_info($patientId);
		$this->uses = array('Widget','PatientsTrackReport','LaboratoryResult','LaboratoryHl7Result','TariffList','DoctorProfile','SmokingStatusOncs','Patient');
		$this->PatientsTrackReport->getAllPatientIds($this->patient_details['Person']['id']);
		$this->set('personId',$this->patient_details['Person']['id']);
		if(!$clickedSection)$clickedSection='Summary';
		if($clickedSection == 'Situation'){
			$str = 'Situation';
		}else if($clickedSection =='Assessment'){
			$str = 'Assessment';
		}else if($clickedSection =='Recommendation'){
			$str = 'Recommendation';
			//$this->redirect('inpatientDashboard',$patientId);
		}else{
			$str = 'Summary';
		}
		$this->set('section',$str);
		// For setting doctor name in lab order and rad order
		//debug($this->params->named['appt']);
		if(!empty($this->params->named['appt']))
			$this->Session->write('apptDoc',$this->params->named['appt']);
		//EOF
		// for allergy
		$getEncounterID=$this->Patient->getAllPatientIds($this->patient_details['Person']['id']);
		if($getEncounterID[count($getEncounterID)-1]==$patientId)
		{
			$this->getAllergyInfo($patientId,$this->patient_details['Person']['id']);
			//for inserting newcrop medication into Newcropprescription table
			$get_medication=$this->get_medication_record($this->patient_details['Person']['id'],$patientId);

			$CountOfMedicationRecords=count($get_medication);

			for($i=0;$i<$CountOfMedicationRecords;$i++){

				$MedicationSpecific[] = $get_medication[$i];

			}

			if($get_medication['0']!=""){
				$this->Patient->insertPrescription($this->patient_details['Person']['id'],$patientId,$MedicationSpecific);
			}
		}
		$currentUserId = 1;
		if($str =='Summary'){
			$this->uses = array('Widget','TariffList','DoctorProfile');

			$columns = $this->Widget->find('all',array('fields' => array('Widget.id','Widget.user_id','Widget.application_screen_name','Widget.column_id',
					'Widget.collapsed','Widget.title','Widget.section','Widget.is_deleted'),
					'conditions' => array('Widget.is_deleted'=> 0,'Widget.user_id' => $currentUserId,
							'Widget.application_screen_name' => 'Inpatient Summary'),
					'order' => array('Widget.column_id','Widget.sort_no'),'group'=>array('Widget.title')));
			if(empty($columns) && count($columns < 1)){
				$columns = $this->Widget->find('all',array('fields' => array('Widget.id','Widget.user_id','Widget.application_screen_name',
						'Widget.column_id','Widget.collapsed','Widget.title','Widget.section','Widget.is_deleted'),
						'conditions' => array('Widget.is_deleted'=> 0,'Widget.user_id' => 0,'Widget.application_screen_name' => 'Inpatient Summary'),
						'order' => array('Widget.column_id','Widget.sort_no'),'group'=>array('Widget.title')));
			}
		}else{
			$this->uses = array('Widget','TariffList','DoctorProfile');
			$columns = $this->Widget->find('all',array('fields' => array('Widget.id','Widget.user_id','Widget.application_screen_name','Widget.column_id','Widget.collapsed','Widget.title','Widget.section'),
					'conditions' => array('Widget.section'=> $str,'Widget.is_deleted'=> 0,'Widget.user_id' => $currentUserId,'Widget.application_screen_name' => 'Sbar'),
					'order' => array('Widget.column_id','Widget.sort_no'),'group'=>array('Widget.title')));
		}
		// Surgery Group ID //Pawan
		$trarifName=$this->TariffList->find('list',array('fields'=>array('id','name'),'conditions'=>array('is_deleted'=>'0','service_category_id'=>'36')));
		$optDoctor=$this->DoctorProfile->find('list',array('fields'=>array('id','doctor_name')));

		if($str == 'Situation'){
			$this->set(array(
					//-----------     PatientBackground   -----------
					'getAdvanceDirective' => $this->PatientsTrackReport->getAdvanceDirective($patientId),
					'getFallRiskScore' => $this->PatientsTrackReport->getFallRiskScore($patientId),
					'getPainScore' => $this->PatientsTrackReport->getPainScore($patientId),
					'getResuscitationStatus' => $this->PatientsTrackReport->getResuscitationStatus($patientId),
					'getActivities' => $this->PatientsTrackReport->getActivity($patientId),
					'getDiet' => $this->PatientsTrackReport->getDiet($patientId),

					//-----------   EOF PatientBackground   -----------
					'getPastMedicals'=> $this->PatientsTrackReport->getPastMedicals($patientId),
					'diagnosisSurgeries' => $this->PatientsTrackReport->getProcedures($patientId),
					'noteDiagnoses' => $this->PatientsTrackReport->getDiagnosis($patientId),
					'getProblems' => $this->PatientsTrackReport->getProblems($patientId),
					'newCropAllergies' => $this->PatientsTrackReport->getAllergies($patientId),
					'getFlaggedEvents' => $this->PatientsTrackReport->getFlaggedEvents($patientId),
					'getImmunization' => $this->PatientsTrackReport->getImmunization($patientId),
					//----------Medication---------
					'getScheduled' =>$this->PatientsTrackReport->getScheduled($patientId),
					'getContinuous' =>$this->PatientsTrackReport->getContinuous($patientId),
					'getPrnUnscheduled' =>$this->PatientsTrackReport->getPrnUnscheduled($patientId),
					/*'getPrnUnscheduledAvailable' =>$this->PatientsTrackReport->getPrnUnscheduledAvailable($patientId),*/
					//-----------Eof Med-----------
					'patientDocuments' => $this->PatientsTrackReport->getDocuments($patientId),

			));
		}
		if($str == 'Assessment'){
			$this->set(array('getVitals' => $this->PatientsTrackReport->getVitals($patientId),
					'getMeasurementWeight' => $this->PatientsTrackReport->getMeasurementWeight($patientId),
					//----------patient assessment------
					'getPatientAssessmentPain' => $this->PatientsTrackReport->getPatientAssessmentPain($patientId),
					'getPatientAssessmentNeuro' => $this->PatientsTrackReport->getPatientAssessmentNeuro($patientId),
					'getPatientAssessmentRespratory' => $this->PatientsTrackReport->getPatientAssessmentRespratory($patientId),
					'getPatientAssessmentCardiovascular' => $this->PatientsTrackReport->getPatientAssessmentCardiovascular($patientId),
					'getPatientAssessmentGI' => $this->PatientsTrackReport->getPatientAssessmentGI($patientId),
					'getPatientAssessmentGU' => $this->PatientsTrackReport->getPatientAssessmentGU($patientId),
					'getPatientAssessmentIntegumentary' => $this->PatientsTrackReport->getPatientAssessmentIntegumentary($patientId),
					//------new--
					'getPatientMentalStatus' => $this->PatientsTrackReport->getPatientMentalStatus($patientId),
					'getSwallowScreen' => $this->PatientsTrackReport->getSwallowScreen ($patientId),
					'getPupilAssessment' => $this->PatientsTrackReport->getPupilAssessment ($patientId),
					'getMusculoskeletalAssessment' => $this->PatientsTrackReport->getMusculoskeletalAssessment ($patientId),
					'getMechanicalVentilation' => $this->PatientsTrackReport->getMechanicalVentilation ($patientId),
					'getEdemaAssessment' => $this->PatientsTrackReport->getEdemaAssessment ($patientId),
					'getUrinaryCatheter' => $this->PatientsTrackReport->getUrinaryCatheter ($patientId),
					'getBradenAssessment' => $this->PatientsTrackReport->getBradenAssessment($patientId),
					'getFallRiskScaleMorse' => $this->PatientsTrackReport->getFallRiskScaleMorse($patientId),
					/* 'getVitalSigns' => $this->PatientsTrackReport->getVitalSigns($patientId),
					 'getVentilatorSubset' => $this->PatientsTrackReport->getVentilatorSubset($patientId), */
					//----------EOF patient assessment------
					//-----QxygenationVantilation---
					'getQxygenationVantilation' => $this->PatientsTrackReport->getQxygenationVantilation($patientId),
					'getLastBloodGases' => $this->PatientsTrackReport->getLastBloodGases($patientId),
					'getPreviousBloodGases' => $this->PatientsTrackReport->getPreviousBloodGases($patientId),
					//-----------eof QxygenationVantilation-------
					'getLinesTubeDrains' => $this->PatientsTrackReport->getLinesTubeDrains($patientId),
					//---------Intake /Output-----
					'getIntakeOutput' => $this->PatientsTrackReport->getIntakeOutput($patientId),
					'getIntakeInner' => $this->PatientsTrackReport->getIntakeInner($patientId),
					'getOutInner' => $this->PatientsTrackReport->getOutInner($patientId),
					//----------Eof Intake /Output--------

					'getActivities' => $this->PatientsTrackReport->getActivities($patientId),
					//---------for lab----------//
					'getLabsName' => $this->PatientsTrackReport->getLabsName($patientId),
					'getLabsResult' => $this->PatientsTrackReport->getLabsResult($patientId),
					//--------end of lab--------//
					'getMicrobiology' => $this->PatientsTrackReport->getMicrobiology($patientId),
					'getPathology' => $this->PatientsTrackReport->getPathology($patientId),
					//---------		Diagnostics   --------
					/*  'getDiagnostics' => $this->PatientsTrackReport->getDiagnostics($patientId),
						'getChest' => $this->PatientsTrackReport->getChest($patientId),
			'getEkg' => $this->PatientsTrackReport->getEkg($patientId), */
					//'getRadiologyTestOrder' => $this->PatientsTrackReport->getRadiologyTestOrder($patientId),
					//'getRadiologyResult' => $this->PatientsTrackReport->getRadiologyResult($patientId),
					//-------     EOF Diagnostics      ------
			));
			/*
			 ////////Dynamic labs section/////////
			$this->LaboratoryResult->bindModel(array(
					'belongsTo' => array(
							'Laboratory'=>array('foreignKey'=>'laboratory_id'),
							'TestGroup'=>array('foreignKey'=>false, 'conditions' => array('TestGroup.id=Laboratory.test_group_id')),

					)));
			// lab category given to patient //
			$getLabsGroupList = $this->LaboratoryResult->find('all', array('conditions' => array('LaboratoryResult.patient_id' => $patientId, 'TestGroup.name NOT' => NULL), 'fields' => array('TestGroup.name', 'TestGroup.id'), 'group' => array('TestGroup.name')));
			$this->set('getLabsGroupList', $getLabsGroupList);


			$this->LaboratoryResult->unBindModel(array('belongsTo'=>array('Laboratory','TestGroup')));
			$this->LaboratoryResult->recursive = -1;

			$this->LaboratoryHl7Result->bindModel(array(
					'belongsTo' => array(
							'Laboratory'=>array('foreignKey'=>false, 'conditions' => array('Laboratory.lonic_code=LaboratoryHl7Result.observations')),
							'LaboratoryResult'=>array('foreignKey'=>false, 'conditions' => array('LaboratoryResult.id=LaboratoryHl7Result.laboratory_result_id')),

					)), 1);
			// set lab results with past value //
			$getOrderLabsStatusList = $this->LaboratoryHl7Result->find('all', array('conditions' => array('LaboratoryResult.patient_id' => $patientId), 'fields' => array('Laboratory.test_group_id', 'Laboratory.name', 'Laboratory.id', 'Laboratory.lonic_code', 'LaboratoryHl7Result.result', 'LaboratoryHl7Result.observations'), 'order' => array('LaboratoryHl7Result.date_time_of_observation DESC')));
			foreach($getOrderLabsStatusList as $getOrderLabsStatusListVal) {
			$getPastValueWithLaboratory[$getOrderLabsStatusListVal['Laboratory']['test_group_id']][$getOrderLabsStatusListVal['LaboratoryHl7Result']['observations']][] = $getOrderLabsStatusListVal['LaboratoryHl7Result']['result'];
			}


			$this->set('getPastValueWithLaboratory', $getPastValueWithLaboratory);
			//----------------          get unique lab name given to patient       ----------- //
			$getLabsStatusList = $this->LaboratoryHl7Result->find('all', array('conditions' => array('LaboratoryResult.patient_id' => $patientId), 'fields' => array('Laboratory.test_group_id', 'Laboratory.name', 'Laboratory.lonic_code'), 'group' => array('LaboratoryHl7Result.observations')));
			$this->set('getLabsStatusList', $getLabsStatusList);*/
			//--------      EOF labs section       --------------//
		}
		if($str == 'Recommendation'){
			$this->uses = array('SmokingStatusOncs');
			$smokingList=$this->SmokingStatusOncs->find('list',array('fields'=>array('id','description')));
			$this->set(array(
					'getNursingPlansCare' => $this->PatientsTrackReport->getNursingPlansCare($patientId),
					'getSocial' => $this->PatientsTrackReport->getSocial($patientId),
					'getQualityMeasure' => $this->PatientsTrackReport->getQualityMeasure($patientId),
					//---------------        overdueTask ------------
					'getOverdueTask' => $this->PatientsTrackReport->getOverdueTask($patientId),
					'getOverdueTaskLab' => $this->PatientsTrackReport->getOverdueTaskLab($patientId),
					//---------------      eof overdueTask ----------
					//-----------------------BOF patient family education----------
					'getPatientFamilyEducation' => $this->PatientsTrackReport->getPatientFamilyEducation($patientId),
					'noteDiagnoses' => $this->PatientsTrackReport->getDiagnosis($patientId),
					'getLabsName' => $this->PatientsTrackReport->getLabsName($patientId),
					//-------------EOF patient family education-------------
					'getLabOrders' => $this->PatientsTrackReport->getLabOrders($patientId),
					'getRadOrders' => $this->PatientsTrackReport->getRadOrders($patientId),

					'getDischargePlan' => $this->PatientsTrackReport->getDischargePlan($patientId),
					'getFollowUp' => $this->PatientsTrackReport->getFollowUp($patientId),
			));
			$this->set('smokingList', $smokingList);
		}
		if($clickedSection == 'Summary'){

			$optDoctor=$this->DoctorProfile->find('list',array('fields'=>array('id','doctor_name')));
			$this->set(array('noteDiagnoses' => $this->PatientsTrackReport->getDiagnosis($patientId),
					'newCropAllergies' => $this->PatientsTrackReport->getAllergies($patientId),
					'newCropPrescriptions' => $this->PatientsTrackReport->getMedications($patientId),
					'getPastMedicals'=> $this->PatientsTrackReport->getPastMedicals($patientId),
					'getPatientDocuments' => $this->PatientsTrackReport->getPatientDocuments($patientId,'SBAR'),
					'getInitialAssess' => $this->PatientsTrackReport->getInitialAssessment($patientId),
					// BOF procedure
					'diagnosisSurgeries' => $this->PatientsTrackReport->getProcedures($patientId),
					'proceduresNote' => $this->PatientsTrackReport->getProceduresNote($patientId),
					// EOF 	procedure
					//for lab//
					'getLabsName' => $this->PatientsTrackReport->getLabsName($patientId),
					'getLabsResult' => $this->PatientsTrackReport->getLabsResult($patientId),
					//end of lab//
					'getNotes' => $this->PatientsTrackReport->getNotes($patientId),
					'getVitals' => $this->PatientsTrackReport->getVitals($patientId),
					'getEkg' => $this->PatientsTrackReport->getEkg($patientId),
					'getPatientInfo' => $this->PatientsTrackReport->getPatientInfo($patientId),
					'getFlaggedEvents' => $this->PatientsTrackReport->getFlaggedEvents($patientId),
					'getHospital' => $this->PatientsTrackReport->getHospital($patientId),
					'getSpecialist' => $this->PatientsTrackReport->getSpecialist($patientId),



			));

		}
		$this->set('trarifName', $trarifName);
		$this->set('optDoctor', $optDoctor);
		$this->set('columns',$columns);
		$this->set('patientId',$patientId);
		$this->set('patientUId',$this->patient_details['Patient']['patient_id']);
	}


	public function outpatientDashboard($patientId){
		//$this->layout = false;
		$this->patient_info($patientId);

		$this->uses = array('Widget','PatientsTrackReport','LaboratoryResult','LaboratoryHl7Result','TariffList','DoctorProfile');
		$this->PatientsTrackReport->getAllPatientIds($this->patient_details['Person']['id']);
		$userArray = array($this->Session->read('userid'));
		//$this->Session->read('userid')
		$currentUserId = 1;
		$columns = $this->Widget->find('all',array('fields' => array('Widget.id','Widget.user_id','Widget.application_screen_name','Widget.column_id',
				'Widget.collapsed','Widget.title'),
				'conditions' => array('Widget.is_deleted'=> 0,'Widget.user_id' => $currentUserId,
						'Widget.application_screen_name' => 'Inpatient Summary'),
				'order' => array('Widget.column_id','Widget.sort_no'),'group'=>array('Widget.title')));
		if(empty($columns) && count($columns < 1)){
			$columns = $this->Widget->find('all',array('fields' => array('Widget.id','Widget.user_id','Widget.application_screen_name',
					'Widget.column_id','Widget.collapsed','Widget.title'),
					'conditions' => array('Widget.is_deleted'=> 0,'Widget.user_id' => 0,'Widget.application_screen_name' => 'Inpatient Summary'),
					'order' => array('Widget.column_id','Widget.sort_no'),'group'=>array('Widget.title')));
		}
		$trarifName=$this->TariffList->find('list',array('fields'=>array('id','name'),'conditions'=>array('is_deleted'=>'0','service_category_id'=>'36')));
		$optDoctor=$this->DoctorProfile->find('list',array('fields'=>array('id','doctor_name')));
		$this->set(array('noteDiagnoses' => $this->PatientsTrackReport->getDiagnosis($patientId),
				'newCropAllergies' => $this->PatientsTrackReport->getAllergies($patientId),
				'newCropPrescriptions' => $this->PatientsTrackReport->getMedications($patientId),
				'getPastMedicals'=> $this->PatientsTrackReport->getPastMedicals($patientId),
				'patientDocuments' => $this->PatientsTrackReport->getDocuments($patientId),
				'diagnosisSurgeries' => $this->PatientsTrackReport->getProcedures($patientId),
				//for lab//
				'getLabsName' => $this->PatientsTrackReport->getLabsName($patientId),
				'getLabsResult' => $this->PatientsTrackReport->getLabsResult($patientId),
				//end of lab//
				'getNotes' => $this->PatientsTrackReport->getNotes($patientId),
				'getVitals' => $this->PatientsTrackReport->getVitals($patientId),
				'getEkg' => $this->PatientsTrackReport->getEkg($patientId),
				'getPatientInfo' => $this->PatientsTrackReport->getPatientInfo($patientId),
				'getFlaggedEvents' => $this->PatientsTrackReport->getFlaggedEvents($patientId),
		));
		//	echo '<pre>';print_r($columns);exit;
		$this->set('trarifName', $trarifName);
		$this->set('optDoctor', $optDoctor);
		$this->set('columns',$columns);
		$this->set('patientId',$patientId);
		$this->set('patientUId',$this->patient_details['Patient']['patient_id']);

	}
	public function getAllergyInfo($id,$patient_id){
		//$this->layout = false;
		$this->loadModel('Patient');
		$this->loadModel('NewCropAllergies');
		$getPatientAllergies=$this->PatientAllergies($patient_id,$id);
		$patientAllergies =explode('~',$getPatientAllergies);
		$CountOfAllergiesRecords=count($patientAllergies)-1;
		for($i=0;$i<$CountOfAllergiesRecords;$i++){
			$AllergiesSpecific[] =explode('>>>>',$patientAllergies[$i]);
		}

		$this->Patient->insertAllergies($patient_id,$id,$AllergiesSpecific);

		/* $allergies_data=$this->NewCropAllergies->find('all',array('fields'=>array('NewCropAllergies.name'),
		 'conditions'=>array('NewCropAllergies.patient_uniqueid'=>$id,'NewCropAllergies.status !='=>'N', 'NewCropAllergies.is_reconcile'=>0,
		 		'NewCropAllergies.location_id'=>$this->Session->read('locationid')),'group'=>array('NewCropAllergies.name')));
		$this->set('allergies_data',$allergies_data);
		$this->render('get_allergy_info')*/
	}
	public function PatientAllergies($id=null,$patient_uniqueid=null){

		//find facility id
		$this->loadModel("Facility");
		$this->Facility->unBindModel(array(
				'hasOne'=>array('FacilityDatabaseMapping','FacilityUserMapping')
		));
		$facility = $this->Facility->find('first', array('fields'=> array('Facility.id','Facility.name'),'conditions'=>array('Facility.is_deleted' => 0, 'Facility.is_active' => 1,'Facility.id' => $this->Session->read("facilityid"))));

		$curlData.='<?xml version="1.0" encoding="utf-8"?>';
		$curlData.='<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
				<soap:Body>';
		$curlData.='<GetPatientAllergyHistoryV3 xmlns="https://secure.newcropaccounts.com/V7/webservices">';
		$curlData.='<credentials>
				<PartnerName>DrMHope</PartnerName>
				<Name>'.Configure::read('uname').'</Name>
						<Password>'.Configure::read('passw').'</Password>
								</credentials>';
		$curlData.='<accountRequest>
				<AccountId>'.$facility[Facility][name].'</AccountId>
						<SiteId>'.$facility[Facility][id].'</SiteId>
								</accountRequest>';
		$curlData.='<patientRequest>
				<PatientId>'.$id.'</PatientId>
						</patientRequest>';
		$curlData.='<patientInformationRequester>
				<UserType>S</UserType>
				<UserId>'.$id.'</UserId>
						</patientInformationRequester>';
		$curlData.=' </GetPatientAllergyHistoryV3>
				</soap:Body>
				</soap:Envelope>';
		$url=Configure::read('SOAPUrl');
		$curl = curl_init();

		curl_setopt ($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl,CURLOPT_TIMEOUT,120);
		//curl_setopt($curl,CURLOPT_ENCODING,'gzip');

		curl_setopt($curl,CURLOPT_HTTPHEADER,array (
		'SOAPAction:"https://secure.newcropaccounts.com/V7/webservices/GetPatientAllergyHistoryV3"',
		'Content-Type: text/xml; charset=utf-8',
		));

		curl_setopt ($curl, CURLOPT_POST, 1);
		curl_setopt ($curl, CURLOPT_POSTFIELDS, $curlData);

		$result = curl_exec($curl);


		curl_close ($curl);
		if($result!="")
		{
			$xml =simplexml_load_string($result);
			$xml->registerXPathNamespace("soap", "http://schemas.xmlsoap.org/soap/envelope/");
			$finalxml=$xml->xpath('//soap:Body');
			//print_r($finalxml[0]);

			//$finalxml=(array)$finalxml[0];
			//echo  echo $xmldata->ICD9_DEFINITIONS_IMO->RECORD->DEFINITION_TEXT;
			$finalxml=$finalxml[0];
			//	print_r($finalxml);
			//echo $finalxml["GetPatientFullMedicationHistory6Response"]
			$staus= $finalxml->GetPatientAllergyHistoryV3Response->GetPatientAllergyHistoryV3Result->Status;
			$response= $finalxml->GetPatientAllergyHistoryV3Response->GetPatientAllergyHistoryV3Result->XmlResponse;
			$rowcount= $finalxml->GetPatientAllergyHistoryV3Response->GetPatientAllergyHistoryV3Result->RowCount;
			$xmlString= base64_decode($response);

			$xmldata = simplexml_load_string($xmlString);
			if($rowcount>1){
				for($i=0;$i<$rowcount;$i++){

					$newcrop_CompositeAllergyID= $xmldata->Table[$i]->CompositeAllergyID;
					$newcrop_AllergySourceID= $xmldata->Table[$i]->AllergySourceID;
					$newcrop_AllergyId= $xmldata->Table[$i]->AllergyId;
					$newcrop_AllergyConceptId= $xmldata->Table[$i]->AllergyConceptId;
					$newcrop_ConceptType= $xmldata->Table[$i]->ConceptType;
					$newcrop_AllergyName= $xmldata->Table[$i]->AllergyName;
					$newcrop_AllergyStatus= $xmldata->Table[$i]->Status;
					$newcrop_AllergySeverityTypeId= $xmldata->Table[$i]->AllergySeverityTypeId;
					$newcrop_AllergySeverityName= $xmldata->Table[$i]->AllergySeverityName;
					$newcrop_OnsetDate= $xmldata->Table[$i]->OnsetDateCCYYMMDD;
					$newcrop_AllergyReaction= $xmldata->Table[$i]->AllergyNotes;

					$newcrop_ConceptID= $xmldata->Table[$i]->ConceptID;
					$newcrop_ConceptTypeId= $xmldata->Table[$i]->ConceptTypeId;
					$newcrop_rxcui= $xmldata->Table[$i]->rxcui;



					$collectedAllergies= $newcrop_CompositeAllergyID.">>>>".$newcrop_AllergySourceID.">>>>".$newcrop_AllergyId.">>>>".$newcrop_AllergyConceptId.">>>>".
							$newcrop_ConceptType.">>>>".$newcrop_AllergyName.">>>>".$newcrop_AllergyStatus.">>>>".$newcrop_AllergySeverityTypeId.">>>>".
							$newcrop_AllergySeverityName.">>>>".$newcrop_AllergyReaction.">>>>".$newcrop_ConceptID.">>>>".$newcrop_ConceptTypeId.">>>>".
							$newcrop_rxcui.">>>>".$newcrop_OnsetDate.">>>>".$patient_uniqueid."~".$collectedAllergies;

				}
				return $collectedAllergies;

			}
			else{
				$newcrop_CompositeAllergyID= $xmldata->Table->CompositeAllergyID;
				$newcrop_AllergySourceID= $xmldata->Table->AllergySourceID;
				$newcrop_AllergyId= $xmldata->Table->AllergyId;
					
				$newcrop_AllergyConceptId= $xmldata->Table[$i]->AllergyConceptId;
				$newcrop_ConceptType= $xmldata->Table->ConceptType;
				$newcrop_AllergyName= $xmldata->Table->AllergyName;
				$newcrop_AllergyStatus= $xmldata->Table->Status;
				$newcrop_AllergySeverityTypeId= $xmldata->Table->AllergySeverityTypeId;
				$newcrop_AllergySeverityName= $xmldata->Table->AllergySeverityName;
				$newcrop_AllergyReaction= $xmldata->Table->AllergyNotes;
				$newcrop_OnsetDate= $xmldata->Table->OnsetDateCCYYMMDD;
				$newcrop_ConceptID= $xmldata->Table->ConceptID;
				$newcrop_ConceptTypeId= $xmldata->Table->ConceptTypeId;
				$newcrop_rxcui= $xmldata->Table->rxcui;
				if($newcrop_AllergyName!=""){
					//	echo "<pre>"; print_r($newcrop_AllergyName);exit;

					$collectedAllergies= $newcrop_CompositeAllergyID.">>>>".$newcrop_AllergySourceID.">>>>".$newcrop_AllergyId.">>>>".$newcrop_AllergyConceptId.">>>>".
							$newcrop_ConceptType.">>>>".$newcrop_AllergyName.">>>>".$newcrop_AllergyStatus.">>>>".$newcrop_AllergySeverityTypeId.">>>>".
							$newcrop_AllergySeverityName.">>>>".$newcrop_AllergyReaction.">>>>".$newcrop_ConceptID.">>>>".$newcrop_ConceptTypeId.">>>>".
							$newcrop_rxcui.">>>>".$newcrop_OnsetDate.">>>>".$patient_uniqueid."~".$collectedAllergies;
					return $collectedAllergies;

				}

				else{
					return $collectedAllergies="";
				}
				//$collectedAllergies = $newcrop_AllergyId .">>>>".$newcrop_AllergyName."~".$collectedAllergies;

			}

		}
	}
	public function userDocument($id=null){
		$this->layout = 'ajax' ;
		$this->loadModel('PatientDocument');
		$idCardArray=$this->PatientDocument->find('all',array('conditions'=>array('PatientDocument.id'=>$id)));
		$this->set('idCardArray',$idCardArray);

	}
	public function getRad($patientId){
		$this->uses=array('RadiologyTestOrder','RadiologyResult','Patient');
		$this->RadiologyTestOrder->bindModel(array(
				'belongsTo' => array(
						'RadiologyResult' =>array('foreignKey' => false,'conditions'=>array('RadiologyResult.radiology_test_order_id=RadiologyTestOrder.id')),
						'Radiology' =>array('foreignKey' => false,'conditions'=>array('Radiology.id=RadiologyTestOrder.radiology_id')),
				)));
		$this->Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$personIDS = $this->Patient->find('first',array('conditions'=>array('Patient.id'=>$patientId),'fields'=>array('id','person_id')));
		$patientIDS = $this->Patient->getAllPatientIds($personIDS['Patient']['person_id']);
		$getRadiologyTestOrder=$this->RadiologyTestOrder->find('all',array('conditions'=>array('RadiologyTestOrder.patient_id'=>$patientIDS),
				'fields'=>array('Radiology.name','RadiologyResult.id','RadiologyResult.img_impression','RadiologyTestOrder.id','RadiologyTestOrder.patient_id','RadiologyTestOrder.batch_identifier')));

		$RadiologyTestOrderIds=$this->RadiologyTestOrder->find('list',array('conditions'=>array('RadiologyTestOrder.patient_id'=>$patientIDS),
				'fields'=>array('id','id')));

		$this->RadiologyResult->bindModel(array(
				'hasMany'=>array('RadiologyReport' =>array('foreignKey' =>'radiology_result_id'))));

		$RadiologyResultValues=$this->RadiologyResult->find('all',array('conditions'=>array('RadiologyResult.radiology_test_order_id'=>$RadiologyTestOrderIds)));
		$this->set('resultRadiology',$getRadiologyTestOrder);
		$this->set('RadiologyResultValues',$RadiologyResultValues);
		echo $this->render('get_rad');
		exit;
	}
	public function getAllergies($patientId,$personId){
		$this->layout ="advance_ajax";
		$this->uses=array('NewCropAllergies','Patient');
		$getEncounterIDALL=$this->Patient->getAllPatientIds($personId);
		$newCropAllergies = $this->NewCropAllergies->find('all',array('fields'=>array('NewCropAllergies.id','NewCropAllergies.name','NewCropAllergies.reaction','NewCropAllergies.patient_uniqueid','NewCropAllergies.AllergySeverityName','NewCropAllergies.status','NewCropAllergies.onset_date'),
				'conditions' => array('NewCropAllergies.patient_uniqueid' =>$getEncounterIDALL,'NewCropAllergies.is_deleted'=>0),'group'=>array('NewCropAllergies.name')));
		$this->set('allergies_data',$newCropAllergies);
	}
	/** Print Care summary **/
	public function printSummary($personId,$patientId=null){
		$this->layout ="advance";
		$this->uses=array('Patient','Person','Language','Race','Note');
		if($this->request->query['from']=='BackToOPD'){
			$this->set('BackToOPD',$this->request->query['from']);
			$conditionsFilter = $this->request->query['conditionsFilter'];
			$this->Session->write('opd_dashboard_filters',$conditionsFilter);
			$todayOrder = $this->request->query['todayOrder'];
			$this->Session->write('opd_dashboard_order',$todayOrder);
			$opdPageCount = $this->request->query['opdPageCount'];
			$this->Session->write('opd_dashboard_pageCount',$opdPageCount);
		}
		$this->set('noteId',$this->request->query['noteId']);
		$this->set('patientId',$this->request->query['patient_id']);
		 
		$allIDs=$this->Patient->getPatientIDs($personId,'Pending');// PersonId is paased
		foreach ($allIDs as $key => $ids){
			$patientInNotes[]=$ids['Patient']['id'];
		}
		/** Header **/
		$this->Person->bindModel(array(
				'belongsTo' => array(
						'Patient' =>array('foreignKey'=>false,'conditions'=>array('Patient.person_id = Person.id')),
						'State' =>array('foreignKey'=>false,'conditions'=>array('State.id = Person.state')),

				)
		));
		$personData=$this->Person->find('first',array('fields'=>array('Person.id','Person.pin_code','Person.zip_four','Person.first_name','Person.middle_name','Person.last_name','Person.sex','Person.dob','Person.patient_uid','Person.plot_no','Person.landmark','Person.city','Person.ethnicity','Person.preferred_language','Person.race','Patient.admission_id','State.name'),'conditions'=>array('Person.id'=>$personId)));
		$getLanguage=$this->Language->find('list',array('fields'=>array('code','language')));

		$getRace=$this->Race->find('list',array('fields'=>array('value_code','race_name')));

		$this->set('personData',$personData);
		$this->set('language',$getLanguage);
		$this->set('Race',$getRace);
		/**
		 EOD
		 **/
		$this->Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		 $this->Patient->bindModel(array(
				'belongsTo' => array(
						'Note' =>array('foreignKey'=>false,'conditions'=>array('Patient.id = Note.patient_id')),
						'Appointment' =>array('foreignKey'=>false,'conditions'=>array('Patient.id = Appointment.patient_id')),
				)
		));
		
		$enc=$this->Patient->find('all',array('fields'=>array('Patient.id','Patient.form_received_on','Note.id','Note.patient_id','Note.sign_note','Appointment.id','Appointment.date'),
				'conditions'=>array('Patient.id'=>$patientInNotes,'Appointment.status !=' => 'Confirmed with Patient',
		 array(
                 'AND' => array(
                                array('Appointment.status !='=>'Pending'),
                                array('Appointment.status !='=>'Scheduled'),
                                array('Appointment.status !='=>'No-Show'),
                                array('Appointment.status !='=>'Cancelled')
                          )
                 )),
				'order'=>array('Appointment.date ASC')));
		$this->set('allIDs',$enc);
		$this->set('personId',$personId);
		if(!empty($patientId)){
			foreach ($enc as $key => $value) {
				if($value['Note']['patient_id']==$patientId && $value['Note']['sign_note']=='1'){
					$this->set('hideNote',$value['Note']['sign_note']);
					$this->set('soapPatientID',$value['Patient']['id']);
					$this->set('soapNoteID',$value['Note']['id']);
					$this->set('soapApptID',$value['Appointment']['id']);
				}
			}
		}
	}

	/** EOD **/
	function printLabSummary($patient_id){

		$this->LaboratoryResult->bindModel(array(
				'belongsTo' => array(
						'Laboratory'=>array('foreignKey'=>false,'conditions'=>array('Laboratory.is_active'=>1,'Laboratory.id=LaboratoryResult.laboratory_id')),
						'LabManager'=>array('foreignKey'=>false,'type'=>'right','conditions'=>array('LaboratoryResult.laboratory_test_order_id=LabManager.id')),
						'LaboratoryAlias'=>array('className'=>'Laboratory','foreignKey'=>false,'conditions'=>array('LaboratoryAlias.is_active'=>1,'LaboratoryAlias.id=LabManager.laboratory_id')),
				),
				'hasOne' => array(
						'LaboratoryToken'=>array('foreignKey'=>false,'conditions'=>array('LaboratoryResult.laboratory_test_order_id=LaboratoryToken.laboratory_test_order_id')),
				),
				'hasMany' => array(
						'LaboratoryHl7Result'=>array('foreignKey'=>'laboratory_result_id')
				)),false);


		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'fields'=>array('LaboratoryResult.physician_unsolicited_notes','LaboratoryResult.is_unsolicited_order','LaboratoryResult.od_specimen_action_code','LaboratoryResult.od_universal_service_identifier','LaboratoryResult.dhr_laboratory_patient_id',/*'LaboratoryResult.od_universal_service_text',*/'LaboratoryAlias.dhr_order_code','LaboratoryResult.dhr_laboratory_patient_id',/*'LaboratoryResult.od_universal_service_text',*/'LaboratoryResult.id','LaboratoryResult.laboratory_test_order_id','LaboratoryAlias.id','LaboratoryAlias.name','LaboratoryResult.laboratory_id','LaboratoryResult.tqi_start_date_time','LaboratoryResult.od_observation_start_date_time','LaboratoryResult.re_notes_comments','LaboratoryResult.result_publish_date','LaboratoryResult.confirm_result','LabManager.id','LabManager.start_date',
						'LabManager.patient_id','LabManager.order_id','Laboratory.id','Laboratory.name','Laboratory.lonic_code','LaboratoryToken.ac_id','LaboratoryToken.sp_id'
						,'LabManager.start_date'),
				'conditions'=>array('LabManager.patient_id'=>$patient_id,'LabManager.is_deleted'=>0),
				'order' => array(
						'LaboratoryResult.id' => 'desc'
				),
				'group'=>array('LaboratoryResult.id','LabManager.id')
		);
		$testOrdered   = $this->paginate('LaboratoryResult');
		$testOrderList = $testOrderListIsarray = $testOrderResultListIsarray = array();
		foreach($testOrdered as $key=>$value){
			if($value['LaboratoryResult']['id']){
				//$testOrderList[$value['LaboratoryResult']['od_universal_service_identifier']][] = $value['LaboratoryResult']['id'];
				if(in_array($value['LaboratoryResult']['od_universal_service_identifier'], $testOrderList[$value['LaboratoryResult']['od_specimen_action_code']])){
					continue;
				}
					
			}
			$testOrderList[$value['LaboratoryResult']['od_specimen_action_code']][] = $value['LaboratoryResult']['od_universal_service_identifier'];
			array_push($testOrderListIsarray, $value);
			array_push($testOrderResultListIsarray, $value['LaboratoryResult']['id']);

		}
		$testOrdered = $testOrderListIsarray;


		/************************************************* Result Fetch *******************************/
		$this->LaboratoryResult->unbindModel(array('belongsTo' => array('Laboratory','LabManager','LaboratoryAlias'),'hasOne' => array('LaboratoryToken'),'hasMany' => array('LaboratoryHl7Result')));
		$this->LaboratoryResult->bindModel(array(
				'belongsTo' => array(
						'LaboratoryHl7Result1' => array('className'=>'LaboratoryHl7Result','foreignKey' => false,
								'conditions' => array('LaboratoryHl7Result1.laboratory_result_id = LaboratoryResult.id'),
						),
						'Laboratory' => array('className'=>'Laboratory','foreignKey' => false,
								'conditions' => array('Laboratory.id = LaboratoryResult.laboratory_id'),
						),
						'LaboratoryToken' => array('className'=>'LaboratoryToken','foreignKey' => false,
								'conditions' => array('LaboratoryResult.laboratory_test_order_id = LaboratoryToken.laboratory_test_order_id'),
						),
						'LaboratoryTestOrder' => array('className'=>'LaboratoryTestOrder','foreignKey' => false,
								'conditions' => array('LaboratoryTestOrder.id = LaboratoryResult.laboratory_test_order_id'),
						),
						'User' => array('className'=>'User','foreignKey' => false,
								'conditions' => array('LaboratoryTestOrder.created_by = User.id'),
						)
				),
				'hasMany' => array(
						'LaboratoryHl7Result' => array('className'=>'LaboratoryHl7Result','foreignKey' => 'laboratory_result_id',

						))));


			
		$conds = array('LaboratoryResult.id'=>$testOrderResultListIsarray,'LaboratoryResult.patient_id'=>$patient_id);
		$get_lab_result=$this->LaboratoryResult->find('all',array('conditions'=>$conds,'group'=>array('LaboratoryResult.id')));
		$this->set('get_lab_result_main',$get_lab_result);
		$this->PanelMapping->bindModel(array(
				'belongsTo' => array(
						'Laboratory' =>array('foreignKey' => false,'conditions'=>array('PanelMapping.underpanellab_id = Laboratory.id')))
		),false);
		$panelTests = $this->Laboratory->find('list',array('fields'=>array('id','name')));
		$this->set('panelTests',$panelTests);
		$this->set('get_lab_results1',$get_lab_result);//ObservationInterpretation0078
		$this->Patient->unbindModel(array('hasOne' => array('Person')),false);
		$clientInfo=$this->Facility->find('first',array('fields'=>array('Facility.*'),'conditions'=>array('Facility.name'=>$this->Session->read('facility'))));
		$this->set("clientInfo",$clientInfo);
		$this->set('failed',$testId);


		/************************************************* Result Fetch *******************************/


		$this->set(array('testOrdered'=>$testOrdered));
		$this->set('patient_id',$patient_id);
		$this->patient_info($patient_id);
		if($this->patient_details['Person']['alternate_patient_uid']){
			$patientParagonId = $this->patient_details['Person']['alternate_patient_uid'];
		}else{
			$patientParagonId = $this->patient_details['Patient']['patient_id'];
		}
		//$unSolicitedOrders = $this->getFailedOrders($this->Session->read('userid'),$patientParagonId,$this->patient_details['Patient']['id'],true);
		//pr($unSolicitedOrders['1']);exit;
		if($unSolicitedOrders){
			$this->set(array('unSolicitedOrders'=>$unSolicitedOrders['0'],'unSolicitedOrdersTestOrderList'=>$unSolicitedOrders['1']));
		}
	}
	public function getAllRecord($patientId=null,$personId=null,$apptId=null,$noteID=null,$checkBox=null,$patientIdsArray=null,$appointmentIdsArray=null,$noteIdsArray=null,$displayPrint=null){

		$this->layout ="print";
		//$this->layout = advance_ajax;
		//$this->layout = false;
		
		$this->uses=array('Appointment','Person','NewCropAllergies','Immunization','NewCropPrescription','Patient','Note','NoteDiagnosis','BmiResult','Person',
				'LaboratoryTestOrder','PatientSmoking','LaboratoryTestOrder','RadiologyTestOrder','ProcedurePerform','Language','Race',
				'DateFormatComponent','Diagnosis','ReferralToSpecialist','LaboratoryResult','PanelMapping','Laboratory','Patient','Facility','Screening',
				'TemplateTypeContent','Template','PastMedicalHistory','ProcedureHistory','FamilyHistory','PatientPersonalHistory','SmokingStatusOncs','User','PatientOrder','OrderCategory');
		
		if($checkBox == 'checkBox'){
			$this->set("checkBox",$checkBox);
			$this->set("displayPrint",$displayPrint);
			$this->set("patientIdsArray",$patientIdsArray);
			$this->set("appointmentIdsArray",$appointmentIdsArray);
			$this->set("noteIdsArray",$noteIdsArray);
		}
		if($checkBox == 'slug'){
			$this->set("slug",$checkBox);
			$this->set("displayPrint",$displayPrint);
			
		}
		if($this->params->named['slug']=='true' || $checkBox == 'slug'){
			$allIDs=$this->Patient->getPatientIDs($personId);// PersonId is paased
			/**
			 Header
			**/
			$this->Patient->bindModel(array(
					'belongsTo' => array(
							'Person' =>array('foreignKey'=>false,'conditions'=>array('Patient.person_id = Person.id')),
							'State' =>array('foreignKey'=>false,'conditions'=>array('State.id = Person.state')),
							'Appointment' =>array('foreignKey'=>false,'conditions'=>array('Appointment.patient_id = Patient.id')),
		
					)
			));
			$personData=$this->Patient->find('first',array('fields'=>array('Patient.form_received_on','Person.id','Person.first_name','Person.middle_name','Person.last_name','Person.sex',
					'Person.dob','Person.patient_uid','Person.plot_no','Person.landmark','Person.city','Person.ethnicity','Person.preferred_language',
					'Person.race','Person.pin_code','Person.zip_four','Patient.admission_id','State.name','Patient.doctor_id','Appointment.arrived_time','Appointment.id',
					'Appointment.date'),'conditions'=>array('Person.id'=>$personId,'Patient.id'=>$patientId)));
			//$getLanguage=$this->Language->find('list',array('fields'=>array('code','language'),'order'=>array('language DESC')));
			$doctors = $this->User->getAllDoctors();
			$this->set('doctors',$doctors);
			$this->set('personData',$personData);
			//$this->set('language',$getLanguage);
			$this->set('Race',$getRace);
			/**
			 EOD
			**/
		}
		$patientFormReceivedOn=$this->Patient->find('first',array('fields'=>array('Patient.form_received_on','Patient.admission_id'),'conditions'=>array('Patient.id'=>$patientId)));
		$this->set('patientFormReceivedOn',$patientFormReceivedOn);
		$appntID=$this->Appointment->find('first', array('fields'=> array('Appointment.id'),'conditions' => array('Appointment.patient_id' => $patientId),'order'=>array('id DESC')));
		$getChiefCompalints=$this->Diagnosis->getProblemHistory($patientId);// first data
		// for notes Data
		//``hpi
		
		$storedTemplateOptions = $this->TemplateTypeContent->find('all',array('fields'=>array('patient_specific_template','template_subcategory_id','template_id','template_category_id','extra_btn_options'),'conditions'=>array('note_id' =>$noteID,'patient_id'=>$patientId))) ;
		
		$hpiArryAdd='0';
		$rosArryAdd='0';
		$peArryAdd='0';
		foreach($storedTemplateOptions as $key=>$typeArry){
			if($typeArry['TemplateTypeContent']['template_category_id']=='3'){
				$hpiArryAdd++;
			}else if($typeArry['TemplateTypeContent']['template_category_id']=='2'){
				$peArryAdd++;
			}else{
				$rosArryAdd++;
			}
		
		}
		
		
		foreach($storedTemplateOptions as $key=>$value){
			$unserializedMaster =  unserialize($value['TemplateTypeContent']['template_subcategory_id']);// getting master subCategory
			$unserializedPatientSpecific =  unserialize($value['TemplateTypeContent']['patient_specific_template']);// getting other patientSepcific subCategory
		
			// BOF code construct for HPI
			if($hpiArryAdd >'0'){
				if($value['TemplateTypeContent']['template_category_id'] == 3){ // template_category_id =3 is for HPI
					foreach($unserializedMaster as $keyMaster=>$hpivalue){
						if($hpivalue == 1){
							$resultSubCategoryGreen[$keyMaster] =  $keyMaster; // fetch templateSubCategoryId
							$resultTemplateId[$value['TemplateTypeContent']['template_id']] =  $value['TemplateTypeContent']['template_id'];// fetch templateId
						}
					}
				}
				foreach($unserializedPatientSpecific as $otherKey=>$OtherHpivalue){
					if($OtherHpivalue == 1){
						$hpiResultOther[$otherKey] =  $value['TemplateTypeContent']['template_id'];
						$resultTemplateId[$value['TemplateTypeContent']['template_id']] =  $value['TemplateTypeContent']['template_id'];
					}
				}
			}
			/*EOF code construct for HPI */
		
			if($rosArryAdd >'0'){
				/** BOF code construct for ROS */
				if($value['TemplateTypeContent']['template_category_id'] == 1){ // template_category_id =1 is for ROS
		
					foreach($unserializedMaster as $keyRosMaster=>$rosValue){
						if($rosValue == 1){ // for green buttons
							$resultSubCategoryGreen[$keyRosMaster] =  $keyRosMaster; // fetch templateSubCategoryId
							$resultTemplateId[$value['TemplateTypeContent']['template_id']] =  $value['TemplateTypeContent']['template_id'];// fetch templateId
		
						}else if($rosValue ==2){ // for red buttons
							$resultSubCategoryRed[$keyRosMaster] =  $keyRosMaster; // fetch templateSubCategoryId
							$resultTemplateId[$value['TemplateTypeContent']['template_id']] =  $value['TemplateTypeContent']['template_id'];// fetch templateId
		
						}
					}
					foreach($unserializedPatientSpecific as $otherRosKey=>$OtherRosvalue){
						if($OtherRosvalue == 1){
							$rosResultOther[$otherRosKey] =  $value['TemplateTypeContent']['template_id'];
							$rosTemplateId[$value['TemplateTypeContent']['template_id']] =  $value['TemplateTypeContent']['template_id'];
						}
					}
				}
				/** EOF code construct for ROS */
			}
		
			if($peArryAdd >'0'){
				/** BOF code construct for PE*/
				if($value['TemplateTypeContent']['template_category_id'] == 2){ // template_category_id = 2 is for PE
					$unserializedPEButtons =  unserialize($value['TemplateTypeContent']['extra_btn_options']);// getting extra btn optn from PE
					if(!empty($unserializedPEButtons['dropdown_options']))
						$pEButtonsOptionValue[0][$value['TemplateTypeContent']['template_id']] = $unserializedPEButtons['dropdown_options'];
					if(!empty($unserializedPEButtons['extra_textarea_data']))
						$pEButtonsOptionValue[1][$value['TemplateTypeContent']['template_id']] = $unserializedPEButtons['extra_textarea_data'];
					foreach($unserializedMaster as $keyPEMaster=>$peValue){
						if($peValue == 1){ // for green buttons
							$resultSubCategoryGreen[$keyPEMaster] =  $keyPEMaster; // fetch templateSubCategoryId
							$resultTemplateId[$value['TemplateTypeContent']['template_id']] =  $value['TemplateTypeContent']['template_id'];// fetch templateId
		
						}else if($peValue ==2){ // for red buttons
							$resultSubCategoryRed[$keyPEMaster] =  $keyPEMaster; // fetch templateSubCategoryId
							$resultTemplateId[$value['TemplateTypeContent']['template_id']] =  $value['TemplateTypeContent']['template_id'];// fetch templateId
						}
					}
					foreach($unserializedPatientSpecific as $otherPeKey=>$OtherPevalue){
						if($OtherPevalue == 1){// 1 is for green buttons
							$peResultOther[$otherPeKey] =  $value['TemplateTypeContent']['template_id']; // patientSpecific subCategory (subCategory => template_id)
							$resultTemplateId[$value['TemplateTypeContent']['template_id']] =  $value['TemplateTypeContent']['template_id'];
						}
					}
				}
				/** EOF code construct for PE */
			}
		
		}
		$this->patient_info($patientId);
		$getmaritailStatusData=$this->patient_details['Person']['maritail_status'];
		$genderKey = (strtoupper($this->patient_details['Person']['sex']) == 'MALE') ? 2 : 1; // for fetching genderSpecific Templates
		$this->Template->bindModel(array('hasMany'=>array(
				'TemplateSubCategories'=>array('foreignKey'=>'template_id','conditions'=>array("TemplateSubCategories.id" => $resultSubCategoryGreen),
						'fields'=>array('TemplateSubCategories.id','TemplateSubCategories.sub_category_sentence','TemplateSubCategories.sub_category','TemplateSubCategories.extraSubcategoryDesc',
								'TemplateSubCategories.extraSubcategory','TemplateSubCategories.extraSubcategoryDescNeg','TemplateSubCategories.redNotAllowed'),
						'order'=>array('ISNULL(TemplateSubCategories.sort_order), TemplateSubCategories.sort_order ASC' )),
				'TemplateSubCategoriesRed'=>array('className'=>'TemplateSubCategories','foreignKey'=>'template_id',
						'conditions'=>array("TemplateSubCategoriesRed.id" => $resultSubCategoryRed),
						'fields'=>array('TemplateSubCategoriesRed.id','TemplateSubCategoriesRed.sub_category','TemplateSubCategoriesRed.extraSubcategoryDesc',
								'TemplateSubCategoriesRed.extraSubcategory','TemplateSubCategoriesRed.extraSubcategoryDescNeg','TemplateSubCategoriesRed.redNotAllowed'),
								'order'=>array('ISNULL(TemplateSubCategoriesRed.sort_order), TemplateSubCategoriesRed.sort_order ASC' ))
		)));
		$hpiMasterData = $this->Template->find('all',array('fields'=>array('Template.id','Template.sentence','Template.template_category_id','Template.category_name'),
				'conditions'=>array('Template.id '=>$resultTemplateId,'Template.is_female_template'=>array(0,$genderKey)),
				'order'=>array('ISNULL(Template.sort_order), Template.sort_order ASC')));
		
		$this->set(array('hpiMasterData'=>$hpiMasterData,'hpiResultOther'=>$hpiResultOther,'rosResultOther'=>$rosResultOther,'peResultOther'=>$peResultOther,'pEButtonsOptionValue' => $pEButtonsOptionValue)) ;
		
		
		//``eof hpi
		
		
		$getNoteData=$this->Note->find('first',array('fields'=>array('ros','subject','object','assis','positive_id','plan'),'conditions'=>array('id'=>$noteID)));// second Data
		$this->set('getNoteData',$getNoteData);
		
		// for vitals Data
		$this->BmiResult->bindModel(array(
				'belongsTo' => array('BmiBpResult'=>array('conditions'=>array('BmiBpResult.bmi_result_id=BmiResult.id'),'foreignKey'=>false)
				)));
		$bmiData = $this->BmiResult->find('first',array('fields'=>array('temperature','temperature1','temperature2','myoption','myoption1','myoption2','respiration','respiration_volume','BmiBpResult.systolic','BmiBpResult.systolic1',
				'BmiBpResult.systolic2','BmiBpResult.diastolic','BmiBpResult.diastolic1','BmiBpResult.diastolic2','BmiBpResult.pulse_text','BmiBpResult.pulse_text1','BmiBpResult.pulse_text2',
				'BmiBpResult.pulse_volume','BmiBpResult.pulse_volume1','BmiBpResult.pulse_volume2'),
				'conditions'=>array('patient_id'=>$patientId,'appointment_id'=>$apptId)));
		$this->set('bmiData',$bmiData);
		// for prodecure
		$procedureData= $this->ProcedurePerform->find('all',array('fields'=> array('procedure_name','snowmed_code','procedure_date'),
				'conditions'=>array('ProcedurePerform.patient_id'=>$patientId,'ProcedurePerform.appointment_id'=>$apptId,'ProcedurePerform.is_deleted'=>0)));
		$this->set('procedureData',$procedureData);
		
		$getAllergy=$this->NewCropAllergies->getAllergyHistory($patientId,$apptId);
		
		$getMedication=$this->NewCropPrescription->getMedicationHistory($patientId,$apptId);
		$getMedicationHistory=$this->NewCropPrescription->getPastMedicationHistory($patientId,$apptId);
		
		$getLab=$this->LaboratoryTestOrder->getLabHistory($patientId);
		
		$getRad=$this->RadiologyTestOrder->getRadHistory($patientId);
		
		$getProblem=$this->NoteDiagnosis->encounterProblems($patientId,$apptId);
		
		$getBmiResult=$this->BmiResult->getBmiHistory($patientId);
		
		$this->set('getMedication',$getMedication);
		$this->set('getMedicationHistory',$getMedicationHistory);
		$this->set('getAllergy',$getAllergy);
		$this->set('getRad',$getRad);
		$this->set('getLab',$getLab);
		$this->set('getProblem',$getProblem);
		$this->set('getChiefCompalints',$getChiefCompalints);
		$this->set('getBmiResult',$getBmiResult);
		$this->set('getBmiResult',$getBmiResult);
		
		$this->set('appointmentID',$apptId);
		$this->set('personId',$personId);
		$this->set('patientId',$patientId);
		$this->set('noteID',$noteID);
		/*For Immunization  */
		$this->Immunization->bindModel(array(
				'belongsTo' => array(
						'PhvsMeasureOfUnit' =>array('foreignKey' => false,'conditions'=>array('PhvsMeasureOfUnit.id=Immunization.phvs_unitofmeasure_id' )),
						'Imunization' =>array('foreignKey' => false,'conditions'=>array('Imunization.id = Immunization.vaccine_type' )),
				)),false);
		$admin_note = array('1','11');
		$diagnosisRec = $this->Immunization->find('all',array('fields'=>array('admin_note','id','vaccine_type','patient_id','Imunization.cpt_description','date','expiry_date','amount','PhvsMeasureOfUnit.value_code'),
				'conditions'=>array('admin_note'=>$admin_note,'patient_id'=>$patientId,'Immunization.is_deleted'=>0)));
		$this->set('past_immunization_details',$diagnosisRec);
		
		/* Past Medical History */
		$getEncounterId=$this->Note->encounterHandler($patientId,$personId);
		$pastMedicalHistory = $this->PastMedicalHistory->find('all',array('fields'=>array('PastMedicalHistory.illness',
				'PastMedicalHistory.status','PastMedicalHistory.comment','PastMedicalHistory.no_known_problems'/* ,'SnomedMappingMaster.referencedComponentId',
				'PastMedicalHistory.no_known_problems' */),'conditions' => array('PastMedicalHistory.patient_id' =>$getEncounterId),
				'group'=>array('PastMedicalHistory.illness')));
		$this->set('pastMedicalHistory',$pastMedicalHistory);
		
		/* Past Surgical History  */
			
		$procedureHistoryRec = $this->ProcedureHistory->find('all',array('fields'=>array('ProcedureHistory.patient_id','ProcedureHistory.procedure_date','ProcedureHistory.procedure_name','ProcedureHistory.provider_name','ProcedureHistory.no_surgical'),
				'conditions'=>array('ProcedureHistory.patient_id'=>$getEncounterId),'order'=>array('ProcedureHistory.id Asc')));
		$this->set('procedureHistoryRec',$procedureHistoryRec);
		
		/*  Family History  */
		$encounterIdForFamily = end($getEncounterId);
		$getpatientfamilyhistory=$this->FamilyHistory->find('first',array('conditions'=>array('patient_id'=>$encounterIdForFamily)));
		if(empty($getpatientfamilyhistory) && $getpatientfamilyhistory==''){
			$encounterIdForFamily = prev($getEncounterId);
			$getpatientfamilyhistory=$this->FamilyHistory->find('first',array('conditions'=>array('patient_id'=>$encounterIdForFamily)));
		}
		$this->set('getpatientfamilyhistory',$getpatientfamilyhistory);
		
		$this->Diagnosis->bindModel( array(
				'belongsTo' => array(
						'PatientPersonalHistory'=>array('conditions'=>array('Diagnosis.id=PatientPersonalHistory.diagnosis_id'),'foreignKey'=>false, 'order'=>array('PatientSmoking.id DESC'),'limit'=>1),
						'PatientSmoking'=>array('conditions'=>array('Diagnosis.id=PatientSmoking.diagnosis_id'),'foreignKey'=>false),
						//'PatientPastHistory'=>array('conditions'=>array('Diagnosis.id=PatientPastHistory.diagnosis_id'),'foreignKey'=>false),
				)
		));
		
		$diagnosisRec = $this->Diagnosis->find('first',array('fields'=>array('PatientPersonalHistory.id','PatientPersonalHistory.tobacco_desc','PatientPersonalHistory.exercise_frequency',/* 'PatientPersonalHistory.work', */'PatientPersonalHistory.smoking','PatientPersonalHistory.alcohol_score','PatientPersonalHistory.tobacco','PatientPersonalHistory.another','PatientPersonalHistory.drugs_desc',
				'PatientPersonalHistory.smoking_fre','PatientPersonalHistory.smoking_desc','PatientPersonalHistory.alchohol_q1','PatientPersonalHistory.alchohol_q2','PatientPersonalHistory.alchohol_q3','PatientPersonalHistory.tobacco_fre'), 'conditions'=>array('Diagnosis.patient_id'=>$getEncounterId)));
		$this->set('diagnosisRec',$diagnosisRec);
		$this->set('getmaritailStatusData',$getmaritailStatusData);
		$smokingOptions =$this->SmokingStatusOncs->find('list',array('fields'=>array('description')));
		$this->set(compact('smokingOptions'));
		 
		 
		//Other Care
		$getPcare=$this->PatientOrder->find('all',array(
				'conditions'=>array('patient_id'=>$patientId,'note_id'=>$noteID,'appt_id'=>$apptId,'isMultiple'=>'Yes'),
				'fields'=>array('id','name','type','status')));
		$this->set('getPcare',$getPcare);
		 
		$catList=$this->OrderCategory->find('list',array('fields'=>array('order_description','order_alias'),
				'conditions'=>array('is_deleted'=>'0')));
		$this->set('catList',$catList);
		if(($checkBox == 'checkBox') || ($checkBox == 'slug')){
			return $this->render('get_all_record');
		
		}else{
			echo $this->render('get_all_record');
			exit;
		}
		
		
		
	}
}