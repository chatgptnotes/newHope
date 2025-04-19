
<?php
/**
 * PatientsTrackReport Model
 *
 * PHP 5
 *
 * @copyright     Copyright 2013 drmhope Inc.  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       PatientsTrackReport Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 */
class PatientsTrackReport extends AppModel {

	public $specific = true;
	public $name = 'PatientsTrackReport';
	public $useTable = false;
	public $locationId = '';
	public $patientId = array();


	public function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->locationId = $session->read('locationid');
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}

	public function getAllPatientIds($personId){
		$patientModel = ClassRegistry::init('Patient');
		$patient_ids = array();
		$patientModel->unBindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$patientData = $patientModel->find('all',array('fields'=>array('Patient.id'),'conditions'=>array('Patient.person_id'=>$personId,'Patient.is_deleted'=>0)));
		foreach ($patientData as $patient){
			array_push($patient_ids,$patient['Patient']['id']);
		}
		$this->patientId = $patient_ids;//array('959','960');//
		
	}

	public function insertLabGroup($data=array()){
		$widget= ClassRegistry::init('Widget');
		foreach($data as $key => $labData){
			$insertLabGroup[] = array('title' =>$labData['TestGroup']['name'],'user_id'=>1,'section'=>'Assessment','column_id'=>3,'sort_no'=>2,'application_screen_name'=>'Sbar');
		}
		$widget->saveAll($insertLabGroup);
		return true;
	}
	public function getDiagnosis($patientId){
		$noteDiagnosisModel = ClassRegistry::init('NoteDiagnosis');
			
		$noteDiagnosisModel->bindModel(array(
				'belongsTo'=>array(
						'Note'=>array('foreignKey'=>false,'conditions'=>array('Note.id=NoteDiagnosis.note_id')))));
			
		$noteDiagnoses = $noteDiagnosisModel->find('all',array('fields'=>array('Note.id','NoteDiagnosis.id','NoteDiagnosis.start_dt','NoteDiagnosis.patient_id','NoteDiagnosis.diagnoses_name','NoteDiagnosis.icd_id','NoteDiagnosis.disease_status','NoteDiagnosis.snowmedid'),'conditions' => array('NoteDiagnosis.patient_id' =>$this->patientId,'is_deleted'=>0,'NoteDiagnosis.disease_status !="resolved"' ),'order'=>array('NoteDiagnosis.id DESC')));
		return $noteDiagnoses;
	}

	public function getProblems($patientId){
		$noteProblemModel = ClassRegistry::init('NoteDiagnosis');
		$noteProblem = $noteProblemModel->find('all',array('fields'=>array('NoteDiagnosis.diagnoses_name','NoteDiagnosis.icd_id'),'conditions' => array('NoteDiagnosis.patient_id' =>$this->patientId,'is_deleted'=>0,'disease_status'=>'chronic'),'order'=>array('NoteDiagnosis.id DESC')));
		return $noteProblem;
	}

	public function getAllergies($patientId){

		$newCropAllergyModel = ClassRegistry::init('NewCropAllergies');
		$newCropAllergies = $newCropAllergyModel->find('all',array('fields'=>array('NewCropAllergies.id','NewCropAllergies.name','NewCropAllergies.reaction','NewCropAllergies.patient_uniqueid','NewCropAllergies.AllergySeverityName','NewCropAllergies.status'),
				'conditions' => array('NewCropAllergies.patient_uniqueid' =>$this->patientId,'NewCropAllergies.is_deleted'=>0),'group'=>array('NewCropAllergies.name')));
		return $newCropAllergies;
	}

	public function getMedications($patientId){
		$newCropPrescriptionModel = ClassRegistry::init('NewCropPrescription');////
		$newCropPrescriptionModel->bindModel(array(
				'belongsTo' => array(
						'VaccineDrug' =>array('foreignKey' => false,'conditions'=>array('VaccineDrug.MEDID=NewCropPrescription.drug_id')),
				)));
		$newCropPrescriptions = $newCropPrescriptionModel->find('all',array('fields'=>array('VaccineDrug.MEDID','NewCropPrescription.id','NewCropPrescription.drug_id','NewCropPrescription.description','NewCropPrescription.dose','NewCropPrescription.route','NewCropPrescription.frequency','NewCropPrescription.date_of_prescription','NewCropPrescription.date_of_prescription_1','NewCropPrescription.end_date','NewCropPrescription.PrintLeaflet','NewCropPrescription.patient_uniqueid','NewCropPrescription.DosageForm'),
				'conditions' => array('NewCropPrescription.patient_uniqueid' =>$this->patientId,'NewCropPrescription.archive'=>'N')));
		return $newCropPrescriptions;
	}

	public function getPastMedicals($patientId){
		$pastMedicalHistoryModel = ClassRegistry::init('PastMedicalHistory');
		$pastMedicalHistoryModel->bindModel(array(
				'belongsTo' => array(
						'SnomedMappingMaster'=>array('foreignKey'=>false,
								'conditions' => array('SnomedMappingMaster.sctName=PastMedicalHistory.illness')),
				)));

		$pastMedicalHistory = $pastMedicalHistoryModel->find('all',array('fields'=>array('PastMedicalHistory.illness','PastMedicalHistory.status','PastMedicalHistory.comment','SnomedMappingMaster.referencedComponentId','PastMedicalHistory.no_known_problems'),'conditions' => array('PastMedicalHistory.patient_id' =>$this->patientId),'group'=>array('PastMedicalHistory.illness')));
		return $pastMedicalHistory;
	}

	public function getProcedures($patientId){
		$procedure=ClassRegistry::init("ProcedureHistory");
		$dataProcedure=$procedure->find('all',array('conditions'=>array('ProcedureHistory.patient_id'=>$this->patientId)));
		return $dataProcedure;
	}
	public function getProceduresNote($patientId){
		$procedurePerform=ClassRegistry::init("ProcedurePerform");
		$dataProcedureNote=$procedurePerform->find('all',array('fields'=>array('procedure_name','procedure_date','procedure_note'),'conditions'=>array('ProcedurePerform.patient_id'=>$this->patientId)));
		return $dataProcedureNote;
	}

	public function getVitals($patientId){

		$reviewPatientDetailModel = ClassRegistry::init('ReviewPatientDetail');
		$bmiResultModel = ClassRegistry::init('BmiResult');
		$reviewPatientDetailModel->bindModel(array(
				'belongsTo'=>array(
						'ReviewSubCategory'=>array('foreignKey'=>false,'type'=>'Inner', 'conditions' => array('ReviewSubCategory.id=ReviewPatientDetail.review_sub_categories_id')),
						'ReviewSubCategoriesOption'=>array('foreignKey'=>false,'type'=>'Inner', 'conditions' => array('ReviewSubCategoriesOption.id=ReviewPatientDetail.review_sub_categories_options_id')),
				)), false);

		$getVitals = $reviewPatientDetailModel->find('all', array('fields'=>array('values','ReviewSubCategoriesOption.name','ReviewSubCategoriesOption.unit'),
				'conditions' => array('ReviewSubCategoriesOption.name'=>array('Tem	perature Oral','Temperature Axillary','Temperature Rectal','Pressure Bladder','Apical Heart Rate','Peripheral Pulse','Heart Rate Monitoring',
						'Respiratory Rate','SBP/DBP Cuff','Mean Arterial Pressure Cuff','SBP/DBP Line','Mean Arterial Line','Cerebral Perfusion Pressure (CPP)','Intracranial Pressure (ICP)','Central Venous Pressure (CVP)','SpO2',
						'Oxygen Therapy','Oxygen Flow Rate','FiO2','Weight Measured','Weight Dosing'),
						'ReviewPatientDetail.patient_id' => $this->patientId,'ReviewPatientDetail.edited_on' => NULL),
				'order'=>array( 'ReviewPatientDetail.date DESC, ReviewPatientDetail.hourSlot DESC')));
			
		foreach($getVitals as $key=>$dataVitals){
			$dataMeasureVitals[trim($dataVitals['ReviewSubCategoriesOption']['name'])][]=array('values'=>$dataVitals['ReviewPatientDetail']['values'],
					'unit'=>$dataVitals['ReviewSubCategoriesOption']['unit']);
		}
			
		$bmiResultModel->bindModel(array(
				'hasMany' => array(
						'BmiBpResult' =>array( 'foreignKey'=>'bmi_result_id','order'=>'BmiBpResult.id DESC','limit'=>1)
				)));
		$result1 = $bmiResultModel->find('all', array('conditions'=>array('patient_id'=>$this->patientId),'order'=>array('BmiResult.appointment_id DESC'))); //find vitals outpt.
		foreach($result1 as $key=>$result1){
			
			if($result1['BmiResult']['respiration_volume']=='1'){
				$respirationVolume = 'Labored';
			}else if($result1['BmiResult']['respiration_volume']=='2'){
				$respirationVolume = 'Unlabored';
			}else{
				$respirationVolume = '';
			}
			
			if(!empty($result1['BmiResult']['temperature']) || !empty($result1['BmiResult']['temperature1']) || !empty($result1['BmiResult']['temperature2'])){
				if(!empty($result1['BmiResult']['temperature']) && !empty($result1['BmiResult']['temperature1']) && !empty($result1['BmiResult']['temperature2'])){
					$temperature = $result1['BmiResult']['temperature2'];
					$myoption = $result1['BmiResult']['myoption2'];
				}else if(!empty($result1['BmiResult']['temperature']) && !empty($result1['BmiResult']['temperature1']) && empty($result1['BmiResult']['temperature2'])){
					$temperature = $result1['BmiResult']['temperature1'];
					$myoption = $result1['BmiResult']['myoption1'];
				}else if(!empty($result1['BmiResult']['temperature']) && empty($result1['BmiResult']['temperature1']) && empty($result1['BmiResult']['temperature2'])){
					$temperature = $result1['BmiResult']['temperature'];
					$myoption = $result1['BmiResult']['myoption'];
			    						 }?>
			    		
			    			<?php }else{
			    				$temperature = "";
			    				$myoption = "";
			    			 }
			
			$unserializeCommonPain = unserialize($result1['BmiResult']['common_pain']);
			$lastPain = end($unserializeCommonPain);
			$dataMeasureVitals['Temperature'][] = array('values'=>$temperature,'unit'=>$myoption);
			$dataMeasureVitals['Respiratory Rate'][] = array('values'=>$result1['BmiResult']['respiration'],'unit'=>$respirationVolume);
			$dataMeasureVitals['Weight Measured'][] = array('values'=>$result1['BmiResult']['weight'],'unit'=>$result1['BmiResult']['weight_volume']);
			$dataMeasureVitals['Height'][] = array('values'=>$result1['BmiResult']['height'],'unit'=>$result1['BmiResult']['height_volume']);
			$dataMeasureVitals['Head Circumference'][] = array('values'=>$result1['BmiResult']['head_circumference'],'unit'=>$result1['BmiResult']['head_circumference_volume']);
		//	$dataMeasureVitals['Waist Circumference'][] = array('values'=>$result1['BmiResult']['waist_circumference'],'unit'=>$result1['BmiResult']['waist_circumference_volume']);
			$dataMeasureVitals['Pain Score'][] = array('values'=>$lastPain);
			$dataMeasureVitals['Bmi'][] = array('values'=>$result1['BmiResult']['bmi'],'unit'=>'Kg/m.sq.');

			foreach($result1['BmiBpResult'] as $res){
				
				if(!empty($res['pulse_text']) || !empty($res['pulse_text1']) || !empty($res['pulse_text2'])){
					if(!empty($res['pulse_text']) && !empty($res['pulse_text1']) && !empty($res['pulse_text2'])){
						$pulse_text = $res['pulse_text2'];
						$pulse_volume = $res['pulse_volume2'];
					}else if(!empty($res['pulse_text']) && !empty($res['pulse_text1']) && empty($res['pulse_text2'])){
						$pulse_text = $res['pulse_text1'];
						$pulse_volume = $res['pulse_volume1'];
					}else if(!empty($res['pulse_text']) && empty($res['pulse_text1']) && empty($res['pulse_text2'])){
						$pulse_text = $res['pulse_text'];
						$pulse_volume = $res['pulse_volume'];
					}
				}else{
					$pulse_text = "";
					$pulse_volume = "";
				}
				
				if(!empty($res['systolic']) || !empty($res['systolic1']) || !empty($res['systolic2'])){
					if(!empty($res['systolic']) && !empty($res['systolic1']) && !empty($res['systolic2'])){
						$systolic = $res['systolic2'];
						$diastolic = $res['diastolic2'];
					}else if(!empty($res['systolic']) && !empty($res['systolic1']) && empty($res['systolic2'])){
						$systolic = $res['systolic1'];
						$diastolic = $res['diastolic1'];
					}else if(!empty($res['systolic']) && empty($res['systolic1']) && empty($res['systolic2'])){
						$systolic = $res['systolic'];
						$diastolic = $res['diastolic'];
					}
				}else{
					$systolic = "";
					$diastolic = "";
				}
				
				$dataMeasureVitals['Peripheral Pulse'][] = array('values'=>$pulse_text,'unit'=>$pulse_volume);
				if(!empty($res['systolic'])||!empty($res['diastolic'])){
					$dataMeasureVitals['SBP/DBP Cuff'][] = array('values'=>$systolic.'/'.$diastolic,'unit'=>'mmHg');
				}
			}
		}
		//$this->set('result1',$result1);
		return $dataMeasureVitals;
	}

	public function getLabsName($patientId){
		$laboratoryHl7Result = ClassRegistry::init('LaboratoryHl7Result');
		$laboratoryHl7Result->bindModel(array(
				'belongsTo' => array(
						'LaboratoryResult'=>array('foreignKey'=>false, 'conditions' => array('LaboratoryResult.id=LaboratoryHl7Result.laboratory_result_id')),
						'Laboratory'=>array('foreignKey'=>false, 'conditions' => array('Laboratory.id=LaboratoryResult.laboratory_id')),
						'TestGroup'=>array('foreignKey'=>false, 'conditions' => array('Laboratory.test_group_id=TestGroup.id')),
						'LaboratoryTestOrder'=>array('foreignKey'=>false, 'conditions' => array('LaboratoryResult.laboratory_test_order_id=LaboratoryTestOrder.id')),
				)), 1);
		$getLabsStatusList = $laboratoryHl7Result->find('all', array('conditions' => array('LaboratoryResult.patient_id' => $this->patientId), 'fields' => array('LaboratoryTestOrder.create_time','Laboratory.test_group_id', 'Laboratory.name', 'Laboratory.lonic_code'), 'group' => array('Laboratory.name')));
		return $getLabsStatusList;
	}

	public function getLabsResult($patientId){
		$laboratoryHl7Result = ClassRegistry::init('LaboratoryHl7Result');
		/*$laboratoryResult->bindModel(array(
		 'belongsTo' => array(
		 		'Laboratory'=>array('foreignKey'=>'laboratory_id'),
		 		'TestGroup'=>array('foreignKey'=>false, 'conditions' => array('TestGroup.id=Laboratory.test_group_id')),
		 )));
		$getLabsGroupList = $laboratoryResult->find('all', array('conditions' => array('LaboratoryResult.patient_id' => $this->patientId, 'TestGroup.name NOT' => NULL), 'fields' => array('TestGroup.name', 'TestGroup.id'), 'group' => array('TestGroup.name')));
		*/
		$laboratoryHl7Result->bindModel(array(
				'belongsTo' => array(
						'LaboratoryResult'=>array('foreignKey'=>false, 'conditions' => array('LaboratoryResult.id=LaboratoryHl7Result.laboratory_result_id')),
						'Laboratory'=>array('foreignKey'=>false, 'conditions' => array('Laboratory.id=LaboratoryResult.laboratory_id')),


				)), false);
		$getOrderLabsStatusList = $laboratoryHl7Result->find('all', array('conditions' => array('LaboratoryResult.patient_id' => $this->patientId), 'fields' => array('Laboratory.test_group_id', 'Laboratory.name', 'Laboratory.id', 'Laboratory.lonic_code', 'LaboratoryHl7Result.result', 'LaboratoryHl7Result.observations'), 'order' => array('LaboratoryHl7Result.date_time_of_observation DESC')));
		foreach($getOrderLabsStatusList as $getOrderLabsStatusListVal) {
			$getPastValueWithLaboratory[$getOrderLabsStatusListVal['Laboratory']['test_group_id']][$getOrderLabsStatusListVal['LaboratoryHl7Result']['observations']][] = $getOrderLabsStatusListVal['LaboratoryHl7Result']['result'];
		}
		return $getPastValueWithLaboratory;


	}

	public function getChest($patientId){
		$patientDiagnostics= ClassRegistry::init('RadiologyTestOrder');
		$patientDiagnostics->bindModel(array(
				'belongsTo' => array(
						'Radiology'=>array('foreignKey'=>'radiology_id' ),
				),
				'hasOne' => array(
						'RadiologyResult'=>array('foreignKey'=>'radiology_test_order_id')
				)),false);
		$chest = $patientDiagnostics->find('all',array('fields'=>array('Radiology.name','RadiologyTestOrder.start_date','RadiologyResult.confirm_result'),'conditions'=>array('RadiologyTestOrder.patient_id'=>$this->patientId,'RadiologyResult.confirm_result'=>1)));
		return $chest;

	}
	public function getDiagnostics($patientId){
		$patientDiagnostics= ClassRegistry::init('RadiologyTestOrder');
		$patientDiagnostics->bindModel(array(
				'belongsTo' => array(
						'Radiology'=>array('foreignKey'=>'radiology_id' ),
				),
				'hasOne' => array(
						'RadiologyResult'=>array('foreignKey'=>'radiology_test_order_id')
				)),false);
		$diagnostic = $patientDiagnostics->find('all',array('fields'=>array('Radiology.name','RadiologyTestOrder.start_date','RadiologyResult.confirm_result'),'conditions'=>array('RadiologyTestOrder.patient_id'=>$this->patientId,'RadiologyResult.confirm_result !='=>1)));
		return $diagnostic;
	}

	public function getEkg($patientId){
		$patientEkg = ClassRegistry::init('EKG');
		/* $patientEkg->bindModel(array(
		 'hasOne' => array(
		 		'EkgResult' =>array('foreignKey'=>false,
		 				'conditions'=>array('EkgResult.ekg_id = EKG.id')),
		 )),false); */
		$ekgData = $patientEkg->find('all',array('conditions'=>array('EKG.patient_id'=>$this->patientId)));
		return $ekgData;

	}

	public function getDocuments($patientId){
		$procedure=ClassRegistry::init("ProcedureHistory");
		$dataProcedure=$procedure->find('all',array('conditions'=>array('ProcedureHistory.patient_id'=>$patientId)));
		return $dataProcedure;
	}

	public function getNotes($patientId){
		$noteModel = ClassRegistry::init('Note');
		$noteModel->bindModel(array('belongsTo' => array(
				'Patient' =>array('foreignKey'=>false, 'conditions' => array('Note.patient_id=Patient.id')),
				'User' =>array('foreignKey'=>false, 'conditions' => array('Patient.doctor_id=User.id')),
		)),false);
		$notes = $noteModel->find('all',array('fields'=>array('Note.id','Note.patient_id', 'Note.note', 'Note.note_type', 'Note.created_by', 'Note.note_date', 'Note.sign_note', 'Note.create_time',
				'User.first_name','User.last_name'),
				'conditions' => array('Note.patient_id'=>$this->patientId
				)));
		return $notes;
	}

	//---------
	public function getAdvanceDirective($patientId){
		/* $advanceDirective = ClassRegistry::init('AdvanceDirective');
			$advance=$advanceDirective->find('first',array('fields'=>array('patient_sign'),'conditions'=> array('AdvanceDirective.patient_id'=>$patientId)));
		return $advance ; */
			
		$advanceDirective = ClassRegistry::init('Diagnosis');
		$advanceDirective->bindModel(array('belongsTo' => array(
				'PatientPersonalHistory' =>array('foreignKey'=>false, 'conditions' => array('Diagnosis.id=PatientPersonalHistory.diagnosis_id')),
		)),false);
		$advance=$advanceDirective->find('first',array('fields'=>array('PatientPersonalHistory.diet','PatientPersonalHistory.diet_exp'),
				'conditions'=> array('Diagnosis.patient_id'=>$patientId),'order'=>array('PatientPersonalHistory.id DESC')));
		return $advance ;
			
	}
	public function getFallRiskScore($patientId){
		$reviewPatientDetailModel = ClassRegistry::init('ReviewPatientDetail');
		$reviewPatientDetailModel->bindModel(array(
				'belongsTo'=>array('Patient'=>array('foreignKey'=>'patient_id'),
						'ReviewSubCategory'=>array('type'=>'inner','foreignKey'=>false, 'conditions' => array('ReviewSubCategory.id=ReviewPatientDetail.review_sub_categories_id','ReviewSubCategory.name like "%Fall Risk Scale Morse"')),
						'ReviewSubCategoriesOption'=>array('foreignKey'=>false,'conditions' => array('ReviewSubCategoriesOption.id=ReviewPatientDetail.review_sub_categories_options_id')),
						'ReviewCategory'=>array('foreignKey'=>false, 'conditions' => array('ReviewCategory.id=ReviewSubCategory.review_category_id')),
				)), false);
		$patientFallRiskScore=$reviewPatientDetailModel->find('first',array('fields'=>array('ReviewSubCategoriesOption.name','ReviewPatientDetail.values'),
				'conditions'=>array('ReviewSubCategoriesOption.name'=>array('Fall Risk Score'),'ReviewPatientDetail.patient_id'=>$patientId,'ReviewPatientDetail.edited_on' => NULL),'group'=>array('ReviewSubCategoriesOption.name')));
		return $patientFallRiskScore;
	}
	public function getPainScore($patientId){
		$reviewPatientDetailModel = ClassRegistry::init('ReviewPatientDetail');
		$reviewPatientDetailModel->bindModel(array(
				'belongsTo'=>array('Patient'=>array('foreignKey'=>'patient_id'),
						'ReviewSubCategory'=>array('type'=>'inner','foreignKey'=>false, 'conditions' => array('ReviewSubCategory.id=ReviewPatientDetail.review_sub_categories_id','ReviewSubCategory.name like "%Pain Assessment"')),
						'ReviewSubCategoriesOption'=>array('foreignKey'=>false,'conditions' => array('ReviewSubCategoriesOption.id=ReviewPatientDetail.review_sub_categories_options_id')),
						'ReviewCategory'=>array('foreignKey'=>false, 'conditions' => array('ReviewCategory.id=ReviewSubCategory.review_category_id')),
				)), false);
		$patientPainScore=$reviewPatientDetailModel->find('all',array('fields'=>array('ReviewSubCategoriesOption.name','ReviewPatientDetail.values','ReviewPatientDetail.id'),
				'conditions'=>array('ReviewSubCategoriesOption.name'=>array('Modified FLACC Pain Score','Modified FLACC Emotion','Modified FLACC Movement','Modified FLACC Verbal Cues','Modified FLACC Facial Cues','Modified FLACC Position/Guarding'),
						'ReviewPatientDetail.patient_id'=>$patientId,'ReviewPatientDetail.edited_on' => NULL),'order'=>array('ReviewPatientDetail.id DESC')));
		return $patientPainScore;
	}
	public function getResuscitationStatus($patientId){
		$multipleOrderContaint= ClassRegistry::init('MultipleOrderContaint');
		$multipleOrderContaint->bindModel(array(
				'belongsTo'=>array(
						'PatientOrder'=>array('foreignKey'=>false,'conditions' => array('PatientOrder.id=MultipleOrderContaint.patient_order_id')),
				)), false);
		$resuscitationStatus = $multipleOrderContaint->find('all',array('fields'=>array('MultipleOrderContaint.start_date','MultipleOrderContaint.resuscitation_status','PatientOrder.name'),
				'conditions'=>array('MultipleOrderContaint.patient_id'=>$patientId,'PatientOrder.status' => 'Ordered','PatientOrder.type'=>'cond'),'order'=>array('PatientOrder.id DESC')));
		return $resuscitationStatus;
	}
	public function getActivity($patientId){
		$multipleOrderContaint= ClassRegistry::init('MultipleOrderContaint');
		$multipleOrderContaint->bindModel(array(
				'belongsTo'=>array(
						'PatientOrder'=>array('foreignKey'=>false,'conditions' => array('PatientOrder.id=MultipleOrderContaint.patient_order_id')),
				)), false);
		$getActivities = $multipleOrderContaint->find('all',array('fields'=>array('MultipleOrderContaint.start_date','MultipleOrderContaint.constant_order','PatientOrder.name','MultipleOrderContaint.special_instruction'),
				'conditions'=>array('MultipleOrderContaint.patient_id'=>$patientId,'PatientOrder.status' => 'Ordered','PatientOrder.type'=>'act'),'order'=>array('PatientOrder.id DESC')));
		return $getActivities;
	}
	public function getActivities($patientId){
		$physiotherapyAssessment= ClassRegistry::init('PhysiotherapyAssessment');
		$getActiv = $physiotherapyAssessment->find('all',array('conditions'=>array('PhysiotherapyAssessment.patient_id'=>$patientId)));
		return $getActiv;
	}
	public function getDiet($patientId){
		$multipleOrderContaint= ClassRegistry::init('MultipleOrderContaint');
		$multipleOrderContaint->bindModel(array(
				'belongsTo'=>array(
						'PatientOrder'=>array('foreignKey'=>false,'conditions' => array('PatientOrder.id=MultipleOrderContaint.patient_order_id')),
				)), false);
		$getDiet = $multipleOrderContaint->find('all',array('fields'=>array('MultipleOrderContaint.start_date','PatientOrder.name','MultipleOrderContaint.special_instruction'),
				'conditions'=>array('MultipleOrderContaint.patient_id'=>$patientId,'PatientOrder.status' => 'Ordered','PatientOrder.type'=>'diet'),'order'=>array('PatientOrder.id DESC')));
		return $getDiet;
	}

	public function getSocial($patientId){
		$history = ClassRegistry::init('PatientSmoking');
		$history->bindModel(array(
				'belongsTo' => array(
						'SmokingStatusOncs'=>array('className'=>'SmokingStatusOncs','conditions'=>array('SmokingStatusOncs.id=PatientSmoking.current_smoking_fre'),'foreignKey'=>false),
						'PatientPersonalHistory'=>array('foreignKey'=>false,'conditions'=>array('PatientPersonalHistory.diagnosis_id= PatientSmoking.diagnosis_id'))
				)
		));
		$detail = $history->find('first',array('fields'=>array('PatientSmoking.current_smoking_fre','PatientPersonalHistory.smoking_desc','PatientPersonalHistory.alcohol_desc','PatientPersonalHistory.alcohol_fre',
				'PatientPersonalHistory.drugs_fre','PatientPersonalHistory.drugs_desc','PatientPersonalHistory.tobacco_fre','PatientPersonalHistory.tobacco_desc','PatientPersonalHistory.retired','PatientPersonalHistory.tobacco_fre',
				'PatientPersonalHistory.tobacco_desc','PatientPersonalHistory.diet','PatientPersonalHistory.other_diet','PatientPersonalHistory.diet_exp','PatientPersonalHistory.work','PatientPersonalHistory.military_services',
				'PatientPersonalHistory.militaryservices_yes','PatientPersonalHistory.suicidal_thoughts','PatientPersonalHistory.suicidal_plan'),
				'conditions'=>array('PatientSmoking.patient_id'=>$this->patientId),'order'=>array('PatientSmoking.id DESC')));
		return $detail;
	}

	public function getMeasurementWeight($patientId){
		$reviewPatientDetailModel = ClassRegistry::init('ReviewPatientDetail');
		$reviewPatientDetailModel->bindModel(array(
				'belongsTo'=>array(
						'ReviewSubCategory'=>array('foreignKey'=>false,'type'=>'Inner', 'conditions' => array('ReviewSubCategory.id=ReviewPatientDetail.review_sub_categories_id')),
						'ReviewSubCategoriesOption'=>array('foreignKey'=>false,'type'=>'Inner', 'conditions' => array('ReviewSubCategoriesOption.id=ReviewPatientDetail.review_sub_categories_options_id')),
				)), false);

		$getHtWt = $reviewPatientDetailModel->find('all', array('fields'=>array('values','ReviewSubCategoriesOption.name','ReviewSubCategoriesOption.unit'),
				'conditions' => array('ReviewSubCategoriesOption.name'=>array('Height/Length measurement','Weight Measured','Body Mass Index','Height/Length dosing'
						,'Weight Dosing','Height/Length estimated','Weight Estimated'),'ReviewPatientDetail.patient_id' => $this->patientId,'ReviewPatientDetail.edited_on' => NULL),
				'order'=>array( 'ReviewPatientDetail.date DESC, ReviewPatientDetail.hourSlot DESC')));
		foreach($getHtWt as $key=>$dataHtWt){
			$dataMeasureHtWt[trim($dataHtWt['ReviewSubCategoriesOption']['name'])][]=array('values'=>$dataHtWt['ReviewPatientDetail']['values'],
					'unit'=>$dataHtWt['ReviewSubCategoriesOption']['unit']);
		}
		return $dataMeasureHtWt;
	}

	public function getQxygenationVantilation($patientId){
		$reviewPatientDetailModel = ClassRegistry::init('ReviewPatientDetail');
		$reviewPatientDetailModel->bindModel(array(
				'belongsTo'=>array('Patient'=>array('foreignKey'=>'patient_id'),
						'ReviewSubCategoriesOption'=>array('foreignKey'=>false, 'conditions' => array('ReviewSubCategoriesOption.id=ReviewPatientDetail.review_sub_categories_options_id')),
				)), false);

		$oxygenData=$reviewPatientDetailModel->find('all',array('fields'=>array('ReviewSubCategoriesOption.name','ReviewPatientDetail.date','ReviewPatientDetail.hourSlot','ReviewSubCategoriesOption.id','ReviewPatientDetail.values'),
				'conditions'=>array('ReviewSubCategoriesOption.name'=>array('Respiratory Rate','Oxygen Flow Rate','FiO2','Positive End Expiratory Pressure (PEEP)','Pressure Support Ventilation (PSV)','Ventilator Mode '),
						'ReviewPatientDetail.patient_id'=>$patientId,'ReviewPatientDetail.edited_on' => NULL),'group'=>array('ReviewSubCategoriesOption.name')));
		return $oxygenData;
	}
	public function getLastBloodGases($patientId){
		$laboratoryHl7Result = ClassRegistry::init('LaboratoryHl7Result');
		$laboratoryHl7Result->bindModel(array(
				'belongsTo' => array(
						'LaboratoryResult'=>array('foreignKey'=>false, 'conditions' => array('LaboratoryResult.id=LaboratoryHl7Result.laboratory_result_id')),
						'Laboratory'=>array('foreignKey'=>false, 'conditions' => array('Laboratory.id=LaboratoryResult.laboratory_id')),
						'TestGroup'=>array('foreignKey'=>false, 'conditions' => array('Laboratory.test_group_id=TestGroup.id')),
				)), 1);
		$getOrderLabsStatusList = $laboratoryHl7Result->find('all', array('conditions' => array('LaboratoryResult.patient_id' => $patientId,'TestGroup.name' =>'Blood Gases'), 'fields' => array('Laboratory.test_group_id', 'Laboratory.name', 'Laboratory.id', 'Laboratory.lonic_code','LaboratoryHl7Result.id', 'LaboratoryHl7Result.result', 'LaboratoryResult.id','LaboratoryHl7Result.observations','TestGroup.name'), 'order' => array('LaboratoryHl7Result.date_time_of_observation DESC'),'limit'=>2));
		return $getOrderLabsStatusList;
	}
	public function getPreviousBloodGases($patientId){
		$laboratoryHl7Result = ClassRegistry::init('LaboratoryHl7Result');
		$laboratoryHl7Result->bindModel(array(
				'belongsTo' => array(
						'LaboratoryResult'=>array('foreignKey'=>false, 'conditions' => array('LaboratoryResult.id=LaboratoryHl7Result.laboratory_result_id')),
						'Laboratory'=>array('foreignKey'=>false, 'conditions' => array('Laboratory.id=LaboratoryResult.laboratory_id')),
						'TestGroup'=>array('foreignKey'=>false, 'conditions' => array('Laboratory.test_group_id=TestGroup.id')),
				)), 1);

		$getOrderLabsStatus = $laboratoryHl7Result->find('all', array('conditions' => array('LaboratoryResult.patient_id' => $patientId,'TestGroup.name' =>'Blood Gases'),
				'fields' => array('Laboratory.test_group_id', 'Laboratory.name', 'Laboratory.id', 'Laboratory.lonic_code', 'LaboratoryHl7Result.result', 'LaboratoryHl7Result.observations','TestGroup.name'),
				'order' => array('LaboratoryHl7Result.date_time_of_observation DESC'),'group'=>'Laboratory.id'));
		return $getOrderLabsStatus;
	}




	public function getLabOrders($patientId){

		/* $patientOrderModel = ClassRegistry::init('PatientOrder');
		$patientOrderModel->bindModel(array(
				'belongsTo'=>array('Patient'=>array('foreignKey'=>'patient_id'),
						'User' => array('foreignKey'=>false,'conditions'=>array('User.id=Patient.doctor_id')),
				)), false);
		$patientOrder = $patientOrderModel->find('all',array('fields'=>array('PatientOrder.name','PatientOrder.status','PatientOrder.create_time','PatientOrder.sentence','CONCAT(User.first_name," ", User.last_name) as full_name'),
				'conditions' => array('PatientOrder.patient_id'=>$patientId,'PatientOrder.status' => 'Ordered'))); */
		$LabManagerModel = ClassRegistry::init('LabManager');
		$LabManagerModel->bindModel(array(
				'belongsTo' => array(
						'Laboratory'=>array('foreignKey'=>'laboratory_id','conditions'=>array('Laboratory.is_active'=>1)),
						//'LaboratoryToken'=>array('foreignKey'=>false,'conditions'=>array('LaboratoryToken.laboratory_test_order_id.=LabManager.id')),
				),
				'hasOne' => array( 'LaboratoryResult'=>array('foreignKey'=>'laboratory_test_order_id') ,
						'LaboratoryHl7Result'=>array('foreignKey'=>false,'conditions'=>array('LaboratoryHl7Result.laboratory_result_id=LaboratoryResult.id'))// aditya added bind LaboratoryHl7Result
				)),false);
		
		$patientLabOrder = $LabManagerModel->find('all',array('fields'=>array('LabManager.batch_identifier','LabManager.id','LabManager.start_date','LabManager.patient_id',
						'LabManager.patient_id','LabManager.order_id','Laboratory.id','Laboratory.name','Laboratory.lonic_code'
						,'LaboratoryHl7Result.range','LaboratoryHl7Result.result','LaboratoryHl7Result.status','LaboratoryHl7Result.abnormal_flag','LaboratoryHl7Result.uom','LaboratoryHl7Result.unit','LaboratoryHl7Result.observations')
				,'conditions'=>array('LabManager.patient_id'=>$patientId,'LabManager.is_deleted'=>0),'order' => array('LabManager.id' => 'desc'),'group'=>'LabManager.id'));
		
		return $patientLabOrder;
	}
	public function getRadOrders($patientId){
		$RadManagerModel = ClassRegistry::init('RadiologyTestOrder');
		$RadManagerModel->bindModel(array(
				'belongsTo' => array(
						'RadiologyResult' =>array('foreignKey' => false,'conditions'=>array('RadiologyResult.radiology_test_order_id=RadiologyTestOrder.id')),
						'Radiology' =>array('foreignKey' => false,'conditions'=>array('Radiology.id=RadiologyTestOrder.radiology_id'))
				)));
		$getRadiologyTestOrder = $RadManagerModel->find('all',array('conditions'=>array('RadiologyTestOrder.patient_id'=>$patientId),
				'fields'=>array('Radiology.name','RadiologyResult.id','RadiologyTestOrder.id','RadiologyTestOrder.patient_id','RadiologyTestOrder.batch_identifier','RadiologyResult.img_impression')));
		return $getRadiologyTestOrder;
	}



	public function getLinesTubeDrains($patientId){
		$reviewPatientDetailModel = ClassRegistry::init('ReviewPatientDetail');
		$reviewPatientDetailModel->bindModel(array(
				'belongsTo'=>array('Patient'=>array('foreignKey'=>'patient_id'),
						'ReviewSubCategory'=>array('foreignKey'=>false, 'conditions' => array('ReviewSubCategory.id=ReviewPatientDetail.review_sub_categories_id')),
						//'ReviewSubCategoriesOption'=>array('foreignKey'=>false, 'conditions' => array('ReviewSubCategoriesOption.review_sub_categories_id=ReviewSubCategory.id')),
						'ReviewCategory'=>array('foreignKey'=>false, 'conditions' => array('ReviewCategory.id=ReviewSubCategory.review_category_id')),
				)), false);
		$lineTubeData=$reviewPatientDetailModel->find('all',array('fields'=>array('ReviewSubCategoriesOption.name','ReviewPatientDetail.date','ReviewPatientDetail.hourSlot','ReviewSubCategoriesOption.id','ReviewPatientDetail.values'),
				'conditions'=>array('ReviewSubCategoriesOption.name'=>array('Central Line','Peripheral IV'),'ReviewPatientDetail.patient_id'=>$this->patientId,'ReviewPatientDetail.edited_on' => NULL)));
		return $lineTubeData;
	}

	public function getFlaggedEvents($patientId){
		$reviewPatientDetailModel = ClassRegistry::init('ReviewPatientDetail');
		$reviewPatientDetailModel->bindModel(array(
				'belongsTo'=>array('Patient'=>array('foreignKey'=>'patient_id'),
						'ReviewSubCategory'=>array('foreignKey'=>false, 'conditions' => array('ReviewSubCategory.id=ReviewPatientDetail.review_sub_categories_id')),
						'ReviewSubCategoriesOption'=>array('foreignKey'=>false,'conditions' => array('ReviewSubCategoriesOption.id=ReviewPatientDetail.review_sub_categories_options_id')),
						'ReviewCategory'=>array('foreignKey'=>false, 'conditions' => array('ReviewCategory.id=ReviewSubCategory.review_category_id')),
				)), false);
		$lastThirtyDays = array(date('Y-m-d', strtotime(date('Y-m-d'). ' - 30 day')), date('Y-m-d'));
		$flagData=$reviewPatientDetailModel->find('all',array('fields'=>array('ReviewSubCategoriesOption.name','ReviewPatientDetail.flag_comment','ReviewPatientDetail.flag_date','ReviewPatientDetail.hourSlot','ReviewPatientDetail.actualTime','ReviewPatientDetail.values','ReviewSubCategoriesOption.unit'),
				'conditions'=>array('ReviewPatientDetail.patient_id'=>$patientId,'ReviewPatientDetail.edited_on' => NULL,'ReviewPatientDetail.flag'=>1,'ReviewPatientDetail.is_deleted'=>0,'ReviewPatientDetail.date BETWEEN ? AND ?' => $lastThirtyDays),'order'=>'ReviewPatientDetail.id DESC'));
		return $flagData;
	}

	public function getIntakeOutput($patientId){
		/* $reviewPatientDetailModel = ClassRegistry::init('ReviewPatientDetail');
			$reviewPatientDetailModel->bindModel(array(
					'belongsTo'=>array('Patient'=>array('foreignKey'=>'patient_id'),
							'ReviewSubCategory'=>array('foreignKey'=>false, 'conditions' => array('ReviewSubCategory.id=ReviewPatientDetail.review_sub_categories_id')),
							//'ReviewSubCategoriesOption'=>array('foreignKey'=>false, 'conditions' => array('ReviewSubCategoriesOption.review_sub_categories_id=ReviewSubCategory.id')),
							'ReviewCategory'=>array('foreignKey'=>false, 'conditions' => array('ReviewCategory.id=ReviewSubCategory.review_category_id')),

					)), false); */
		$reviewPatientDetailModel = ClassRegistry::init('ReviewPatientDetail');
		$reviewPatientDetailModel->bindModel(array(
				'belongsTo'=>array('Patient'=>array('foreignKey'=>'patient_id'),
						'ReviewSubCategory'=>array('foreignKey'=>false, 'conditions' => array('ReviewSubCategory.id=ReviewPatientDetail.review_sub_categories_id')),
						'ReviewSubCategoriesOption'=>array('foreignKey'=>false,'conditions' => array('ReviewSubCategoriesOption.id=ReviewPatientDetail.review_sub_categories_options_id')),
						'ReviewCategory'=>array('foreignKey'=>false, 'conditions' => array('ReviewCategory.id=ReviewSubCategory.review_category_id')),
				)), false);

		$lastThreeDays = array(date('Y-m-d', strtotime(date('Y-m-d'). ' - 2 day')), date('Y-m-d'));
		$getMeanIntakeOutput = $reviewPatientDetailModel->find('all', array('conditions' => array('ReviewSubCategory.parameter' => array('intake', 'output'), 'ReviewPatientDetail.patient_id' => $this->patientId, 'ReviewPatientDetail.edited_on' => NULL, 'ReviewPatientDetail.date BETWEEN ? AND ?' => $lastThreeDays), 'fields' => array('ReviewSubCategory.parameter', 'ReviewCategory.name', 'ReviewSubCategory.name',  'SUM(ReviewPatientDetail.values) AS value', 'ReviewPatientDetail.date'),  'group' => array('ReviewSubCategory.parameter', 'ReviewPatientDetail.date')));
		foreach($getMeanIntakeOutput as $getMeanIntakeOutputVal) {
			$getStackMeanIntakeOutput[$getMeanIntakeOutputVal['ReviewSubCategory']['parameter']][$getMeanIntakeOutputVal['ReviewPatientDetail']['date']]  = $getMeanIntakeOutputVal[0]['value'];
		}
		return $getStackMeanIntakeOutput;
	}
	public function getIntakeInner($patientId){
		$reviewPatientDetailModel = ClassRegistry::init('ReviewPatientDetail');
		$reviewPatientDetailModel->bindModel(array(
				'belongsTo'=>array('Patient'=>array('foreignKey'=>'patient_id'),
						'ReviewSubCategory'=>array('foreignKey'=>false, 'conditions' => array('ReviewSubCategory.id=ReviewPatientDetail.review_sub_categories_id')),
						'ReviewSubCategoriesOption'=>array('foreignKey'=>false,'conditions' => array('ReviewSubCategoriesOption.id=ReviewPatientDetail.review_sub_categories_options_id')),
						'ReviewCategory'=>array('foreignKey'=>false, 'conditions' => array('ReviewCategory.id=ReviewSubCategory.review_category_id')),
				)), false);
		$innerIntakeData=$reviewPatientDetailModel->find('all',array('fields'=>array('ReviewSubCategoriesOption.name','ReviewPatientDetail.date','ReviewPatientDetail.hourSlot','ReviewSubCategoriesOption.id','ReviewPatientDetail.values'),
				'conditions'=>array('ReviewSubCategoriesOption.name'=>array('Other Intake Sources','Parenteral','Whole Blood','Packed RBCs','Platelets','Plasma','Gastric','Enteral','Oral Intake Amount','Percent Eaten','Carbohydrate Servings'),'ReviewPatientDetail.patient_id'=>$this->patientId,'ReviewPatientDetail.edited_on' => NULL),'group'=>array('ReviewSubCategoriesOption.name')));
		return $innerIntakeData;
	}
	public function getOutInner($patientId){
		$reviewPatientDetailModel = ClassRegistry::init('ReviewPatientDetail');
		$reviewPatientDetailModel->bindModel(array(
				'belongsTo'=>array('Patient'=>array('foreignKey'=>'patient_id'),
						'ReviewSubCategory'=>array('foreignKey'=>false, 'conditions' => array('ReviewSubCategory.id=ReviewPatientDetail.review_sub_categories_id')),
						'ReviewSubCategoriesOption'=>array('foreignKey'=>false,'conditions' => array('ReviewSubCategoriesOption.id=ReviewPatientDetail.review_sub_categories_options_id')),
						'ReviewCategory'=>array('foreignKey'=>false, 'conditions' => array('ReviewCategory.id=ReviewSubCategory.review_category_id')),
				)), false);
		$innerOutputData=$reviewPatientDetailModel->find('all',array('fields'=>array('ReviewSubCategoriesOption.name','ReviewPatientDetail.date','ReviewPatientDetail.hourSlot','ReviewSubCategoriesOption.id','ReviewPatientDetail.values'),
				'conditions'=>array('ReviewSubCategoriesOption.name'=>array('Urine Voided','Foley Cath Output','Emesis Output','Gastric Tube Outputs','Stool Count',
						'Other Output Sources','Drains and Chest Tubes','Surgical Drain, Tube Outputs','Chest Tube outputs',
						'Continuous Renal Replacement Therapy (CRRT)'),'ReviewPatientDetail.patient_id'=>$this->patientId,'ReviewPatientDetail.edited_on' => NULL),'group'=>array('ReviewSubCategoriesOption.name')));

		return $innerOutputData;
	}
	//-------patient assessment-----
	public function getPatientAssessmentPain($patientId){
		$reviewPatientDetailModel = ClassRegistry::init('ReviewPatientDetail');
		$reviewPatientDetailModel->bindModel(array(
				'belongsTo'=>array('Patient'=>array('foreignKey'=>'patient_id'),
						'ReviewSubCategory'=>array('type'=>'inner','foreignKey'=>false, 'conditions' => array('ReviewSubCategory.id=ReviewPatientDetail.review_sub_categories_id','ReviewSubCategory.name like "%Pain Assessment"')),
						'ReviewSubCategoriesOption'=>array('foreignKey'=>false,'conditions' => array('ReviewSubCategoriesOption.id=ReviewPatientDetail.review_sub_categories_options_id')),
						'ReviewCategory'=>array('foreignKey'=>false, 'conditions' => array('ReviewCategory.id=ReviewSubCategory.review_category_id')),
				)), false);
		$patientAssessmentPain=$reviewPatientDetailModel->find('all',array('fields'=>array('ReviewSubCategoriesOption.name','ReviewPatientDetail.date','ReviewPatientDetail.actualTime','ReviewSubCategoriesOption.id','ReviewPatientDetail.values'),
				'conditions'=>array('ReviewSubCategoriesOption.name'=>array('Location','Pain Present','Preferred Pain Tool','Modified FLACC Emotion','Modified FLACC Movement','Modified FLACC Verbal Cues','Modified FLACC Facial Cues','Modified FLACC Position/Guarding',
						'Modified FLACC Pain Score','Laterality','Quality','Time Pattern','Unable to Self Report','Secondary Pain Site','Additional Pain Sites'),'ReviewPatientDetail.patient_id'=>$patientId,'ReviewPatientDetail.edited_on' => NULL),'group'=>array('ReviewSubCategoriesOption.name')));
		return $patientAssessmentPain;
	}

	public function  getPatientAssessmentNeuro($patientId){
		$reviewPatientDetailModel = ClassRegistry::init('ReviewPatientDetail');
		$reviewPatientDetailModel->bindModel(array(
				'belongsTo'=>array('Patient'=>array('foreignKey'=>'patient_id'),
						'ReviewSubCategory'=>array('type'=>'inner','foreignKey'=>false, 'conditions' => array('ReviewSubCategory.id=ReviewPatientDetail.review_sub_categories_id','ReviewSubCategory.name like "%Neurological"')),
						'ReviewSubCategoriesOption'=>array('foreignKey'=>false,'conditions' => array('ReviewSubCategoriesOption.id=ReviewPatientDetail.review_sub_categories_options_id')),
						'ReviewCategory'=>array('foreignKey'=>false, 'conditions' => array('ReviewCategory.id=ReviewSubCategory.review_category_id')),
				)), false);
		$patientAssessmentNeuro=$reviewPatientDetailModel->find('all',array('fields'=>array('ReviewSubCategoriesOption.name','ReviewPatientDetail.date','ReviewPatientDetail.actualTime','ReviewSubCategoriesOption.id','ReviewPatientDetail.values'),
				'conditions'=>array('ReviewSubCategoriesOption.name'=>array('Neurological Symptoms','Intracranial Pressure','Cerebral Perfusion Pressure','Level of Consciousness','Orientation Assessment','Hallucination Present','Affect /Behavior',
						'Behavior Newborn','Charateristics of Speech','Gag Reflex','Aspiration Risk','CN IX, X Swallowing, Gag Reflex','Facial Symmetry','CN V Facial Sensation','CN VII Facial Expression and Symmetry','CN VIII Hearing','Plantar Reflex',
						'Posture Neuro','Extremity Movement','Pronator drift','Gait','Sleep/Alert Status Newborn','Anterior Fontanel Description','Posterior Fontanel Description','Cry Description','Reflexes Newborn','Tone Newborn','Movement Newborn','Clonus','Ramsay Scale'),
						'ReviewPatientDetail.patient_id'=>$patientId,'ReviewPatientDetail.edited_on' => NULL),'group'=>array('ReviewSubCategoriesOption.name')));
		return $patientAssessmentNeuro;
	}
	public function  getPatientAssessmentRespratory($patientId){
		$reviewPatientDetailModel = ClassRegistry::init('ReviewPatientDetail');
		$reviewPatientDetailModel->bindModel(array(
				'belongsTo'=>array('Patient'=>array('foreignKey'=>'patient_id'),
						'ReviewSubCategory'=>array('type'=>'inner','foreignKey'=>false, 'conditions' => array('ReviewSubCategory.id=ReviewPatientDetail.review_sub_categories_id','ReviewSubCategory.name like "%Respiratory"')),
						'ReviewSubCategoriesOption'=>array('foreignKey'=>false,'conditions' => array('ReviewSubCategoriesOption.id=ReviewPatientDetail.review_sub_categories_options_id')),
						'ReviewCategory'=>array('foreignKey'=>false, 'conditions' => array('ReviewCategory.id=ReviewSubCategory.review_category_id')),
				)), false);
		$patientAssessmentRespratory=$reviewPatientDetailModel->find('all',array('fields'=>array('ReviewSubCategoriesOption.name','ReviewPatientDetail.date','ReviewPatientDetail.actualTime','ReviewSubCategoriesOption.id','ReviewPatientDetail.values'),
				'conditions'=>array('ReviewSubCategoriesOption.name'=>array('Respirations','Cough','Al Lobes Breath Sounds','Left Upper Lobe Breath Sounds','Right Upper Lobe Breath Sounds','Right Middle Lobe Breath Sounds','Left Lower Lobe Breath Sounds','Right Lower Lobe Breath Sounds','Lung Sounds Left','Lung Sounds Right'),
						'ReviewPatientDetail.patient_id'=>$patientId,'ReviewPatientDetail.edited_on' => NULL),'group'=>array('ReviewSubCategoriesOption.name')));
		return $patientAssessmentRespratory;

	}
	public function  getPatientAssessmentCardiovascular($patientId){
		$reviewPatientDetailModel = ClassRegistry::init('ReviewPatientDetail');
		$reviewPatientDetailModel->bindModel(array(
				'belongsTo'=>array('Patient'=>array('foreignKey'=>'patient_id'),
						'ReviewSubCategory'=>array('type'=>'inner','foreignKey'=>false, 'conditions' => array('ReviewSubCategory.id=ReviewPatientDetail.review_sub_categories_id','ReviewSubCategory.name like "%Cardiovascular"')),
						'ReviewSubCategoriesOption'=>array('foreignKey'=>false,'conditions' => array('ReviewSubCategoriesOption.id=ReviewPatientDetail.review_sub_categories_options_id')),
						'ReviewCategory'=>array('foreignKey'=>false, 'conditions' => array('ReviewCategory.id=ReviewSubCategory.review_category_id')),
				)), false);
		$patientAssessmentCardiovascular=$reviewPatientDetailModel->find('all',array('fields'=>array('ReviewSubCategoriesOption.name','ReviewPatientDetail.date','ReviewPatientDetail.actualTime','ReviewSubCategoriesOption.id','ReviewPatientDetail.values'),
				'conditions'=>array('ReviewSubCategoriesOption.name'=>array('Capillary Refill','Heart Rhythm','Cardiac Rhythm','Ectopy Definition','Pacemaker Type','Pacemaker Mode','Pacemaker Rate Setting','Brachial Pulse Bilateral','Radial Pulse,
						Left','Radial Pulse, Right','Radial Pulses Bilateral','Dorsalis Peds Pulse, Left','Dorsalis Peds Pulse, Right','Dorsalis Peds Pulse, Bilateral'),
						'ReviewPatientDetail.patient_id'=>$patientId,'ReviewPatientDetail.edited_on' => NULL),'group'=>array('ReviewSubCategoriesOption.name')));
		return $patientAssessmentCardiovascular;
	}
	public function  getPatientAssessmentGI($patientId){
		$reviewPatientDetailModel = ClassRegistry::init('ReviewPatientDetail');
		$reviewPatientDetailModel->bindModel(array(
				'belongsTo'=>array('Patient'=>array('foreignKey'=>'patient_id'),
						'ReviewSubCategory'=>array('type'=>'inner','foreignKey'=>false, 'conditions' => array('ReviewSubCategory.id=ReviewPatientDetail.review_sub_categories_id','ReviewSubCategory.name like "%Gastrointestinal"')),
						'ReviewSubCategoriesOption'=>array('foreignKey'=>false,'conditions' => array('ReviewSubCategoriesOption.id=ReviewPatientDetail.review_sub_categories_options_id')),
						'ReviewCategory'=>array('foreignKey'=>false, 'conditions' => array('ReviewCategory.id=ReviewSubCategory.review_category_id')),
				)), false);
		$patientAssessmentGI=$reviewPatientDetailModel->find('all',array('fields'=>array('ReviewSubCategoriesOption.name','ReviewPatientDetail.date','ReviewPatientDetail.actualTime','ReviewSubCategoriesOption.id','ReviewPatientDetail.values'),
				'conditions'=>array('ReviewSubCategoriesOption.name'=>array('Abdomen Description','Abdomen Palpation','Bowel Movement Last Date','Bowel Sounds All Quadrants','Bowel Sounds UQ','Bowel Sounds RUQ','Bowel Sounds LLQ','Bowel Sounds RLQ','Enteral Tube Type'),
						'ReviewPatientDetail.patient_id'=>$patientId,'ReviewPatientDetail.edited_on' => NULL),'group'=>array('ReviewSubCategoriesOption.name')));
		return $patientAssessmentGI;
	}

	public function  getPatientAssessmentGU($patientId){
		$reviewPatientDetailModel = ClassRegistry::init('ReviewPatientDetail');
		$reviewPatientDetailModel->bindModel(array(
				'belongsTo'=>array('Patient'=>array('foreignKey'=>'patient_id'),
						'ReviewSubCategory'=>array('type'=>'inner','foreignKey'=>false,'conditions' => array('ReviewSubCategory.id=ReviewPatientDetail.review_sub_categories_id','ReviewSubCategory.name like "%Genitourinary"')),
						'ReviewSubCategoriesOption'=>array('foreignKey'=>false,'conditions' => array('ReviewSubCategoriesOption.id=ReviewPatientDetail.review_sub_categories_options_id')),
						'ReviewCategory'=>array('foreignKey'=>false,'conditions' => array('ReviewCategory.id=ReviewSubCategory.review_category_id')),
				)), false);
		$patientAssessmentGU=$reviewPatientDetailModel->find('all',array('fields'=>array('ReviewPatientDetail.id','ReviewPatientDetail.date',
				'ReviewPatientDetail.actualTime','ReviewPatientDetail.values','ReviewSubCategoriesOption.name','ReviewSubCategoriesOption.id'),
				'conditions'=>array('ReviewSubCategoriesOption.name'=>array('Urinary Elimination','Voiding Difficulties','Urine Description','Urine Color'),
						'ReviewPatientDetail.patient_id'=>$patientId,'ReviewPatientDetail.edited_on' => NULL)));
		return $patientAssessmentGU;
	}

	public function  getPatientAssessmentIntegumentary($patientId){
		$reviewPatientDetailModel = ClassRegistry::init('ReviewPatientDetail');
		$reviewPatientDetailModel->bindModel(array(
				'belongsTo'=>array('Patient'=>array('foreignKey'=>'patient_id'),
						'ReviewSubCategory'=>array('type'=>'inner','foreignKey'=>false, 'conditions' => array('ReviewSubCategory.id=ReviewPatientDetail.review_sub_categories_id','ReviewSubCategory.name like "%Integumentary"')),
						'ReviewSubCategoriesOption'=>array('foreignKey'=>false,'conditions' => array('ReviewSubCategoriesOption.id=ReviewPatientDetail.review_sub_categories_options_id')),
						'ReviewCategory'=>array('foreignKey'=>false, 'conditions' => array('ReviewCategory.id=ReviewSubCategory.review_category_id')),
				)), false);
		$patientAssessmentIntegumentary=$reviewPatientDetailModel->find('all',array('fields'=>array('ReviewSubCategoriesOption.name','ReviewPatientDetail.date','ReviewPatientDetail.actualTime','ReviewSubCategoriesOption.id','ReviewPatientDetail.values'),
				'conditions'=>array('ReviewSubCategoriesOption.name'=>array('Skin Color','Skin Temperature','Skin Turgor','Skin Moisture','Skin Integrity','Mucous Membrane','Mucous Membrane','Diaper Rash Description','Diaper Rash Location','Diaper Rash Treatment'),
						'ReviewPatientDetail.patient_id'=>$patientId,'ReviewPatientDetail.edited_on' => NULL),'group'=>array('ReviewSubCategoriesOption.name')));
		return $patientAssessmentIntegumentary;
	}

	public function  getPatientMentalStatus($patientId){
		$reviewPatientDetailModel = ClassRegistry::init('ReviewPatientDetail');
		$reviewPatientDetailModel->bindModel(array(
				'belongsTo'=>array('Patient'=>array('foreignKey'=>'patient_id'),
						'ReviewSubCategory'=>array('type'=>'inner','foreignKey'=>false, 'conditions' => array('ReviewSubCategory.id=ReviewPatientDetail.review_sub_categories_id','ReviewSubCategory.name like "%Mental Status"')),
						'ReviewSubCategoriesOption'=>array('foreignKey'=>false,'conditions' => array('ReviewSubCategoriesOption.id=ReviewPatientDetail.review_sub_categories_options_id')),
						'ReviewCategory'=>array('foreignKey'=>false, 'conditions' => array('ReviewCategory.id=ReviewSubCategory.review_category_id')),
				)), false);
		$patientMentalStatus=$reviewPatientDetailModel->find('all',array('fields'=>array('ReviewSubCategoriesOption.name','ReviewPatientDetail.date','ReviewPatientDetail.actualTime','ReviewSubCategoriesOption.id','ReviewPatientDetail.values'),
				'conditions'=>array('ReviewSubCategoriesOption.name'=>array('Orientation Assessment','RASS Level','Level of Consciousness','Appearance','Affect /Behavior'),
						'ReviewPatientDetail.patient_id'=>$patientId,'ReviewPatientDetail.edited_on' => NULL),'group'=>array('ReviewSubCategoriesOption.name')));
		return $patientMentalStatus;
	}
	public function  getSwallowScreen($patientId){
		$reviewPatientDetailModel = ClassRegistry::init('ReviewPatientDetail');
		$reviewPatientDetailModel->bindModel(array(
				'belongsTo'=>array('Patient'=>array('foreignKey'=>'patient_id'),
						'ReviewSubCategory'=>array('type'=>'inner','foreignKey'=>false, 'conditions' => array('ReviewSubCategory.id=ReviewPatientDetail.review_sub_categories_id','ReviewSubCategory.name like "%Swallow Screen"')),
						'ReviewSubCategoriesOption'=>array('foreignKey'=>false,'conditions' => array('ReviewSubCategoriesOption.id=ReviewPatientDetail.review_sub_categories_options_id')),
						'ReviewCategory'=>array('foreignKey'=>false, 'conditions' => array('ReviewCategory.id=ReviewSubCategory.review_category_id')),
				)), false);
		$patientSwallowScreen=$reviewPatientDetailModel->find('all',array('fields'=>array('ReviewSubCategoriesOption.name','ReviewPatientDetail.date','ReviewPatientDetail.actualTime','ReviewSubCategoriesOption.id','ReviewPatientDetail.values'),
				'conditions'=>array('ReviewSubCategoriesOption.name'=>array('Administer 90 ml','Administer Sip of W','Suction Set Up','Head of Bed Greater'),
						'ReviewPatientDetail.patient_id'=>$patientId,'ReviewPatientDetail.edited_on' => NULL),'group'=>array('ReviewSubCategoriesOption.name')));
		return $patientSwallowScreen;
	}
	public function  getPupilAssessment($patientId){
		$reviewPatientDetailModel = ClassRegistry::init('ReviewPatientDetail');
		$reviewPatientDetailModel->bindModel(array(
				'belongsTo'=>array('Patient'=>array('foreignKey'=>'patient_id'),
						'ReviewSubCategory'=>array('type'=>'inner','foreignKey'=>false, 'conditions' => array('ReviewSubCategory.id=ReviewPatientDetail.review_sub_categories_id','ReviewSubCategory.name like "%Pupil Assessment"')),
						'ReviewSubCategoriesOption'=>array('foreignKey'=>false,'conditions' => array('ReviewSubCategoriesOption.id=ReviewPatientDetail.review_sub_categories_options_id')),
						'ReviewCategory'=>array('foreignKey'=>false, 'conditions' => array('ReviewCategory.id=ReviewSubCategory.review_category_id')),
				)), false);
		$patientPupilAssessment=$reviewPatientDetailModel->find('all',array('fields'=>array('ReviewSubCategoriesOption.name','ReviewPatientDetail.date','ReviewPatientDetail.actualTime','ReviewSubCategoriesOption.id','ReviewPatientDetail.values'),
				'conditions'=>array('ReviewSubCategoriesOption.name'=>array('Left Pupil Size','Right Pupil Size','Left Pupil Description','Right Pupil Description','PERRLA'),
						'ReviewPatientDetail.patient_id'=>$patientId,'ReviewPatientDetail.edited_on' => NULL),'group'=>array('ReviewSubCategoriesOption.name')));
		return $patientPupilAssessment;
	}
	public function  getMusculoskeletalAssessment($patientId){
		$reviewPatientDetailModel = ClassRegistry::init('ReviewPatientDetail');
		$reviewPatientDetailModel->bindModel(array(
				'belongsTo'=>array('Patient'=>array('foreignKey'=>'patient_id'),
						'ReviewSubCategory'=>array('type'=>'inner','foreignKey'=>false, 'conditions' => array('ReviewSubCategory.id=ReviewPatientDetail.review_sub_categories_id','ReviewSubCategory.name like "%Musculoskeletal Assessment"')),
						'ReviewSubCategoriesOption'=>array('foreignKey'=>false,'conditions' => array('ReviewSubCategoriesOption.id=ReviewPatientDetail.review_sub_categories_options_id')),
						'ReviewCategory'=>array('foreignKey'=>false, 'conditions' => array('ReviewCategory.id=ReviewSubCategory.review_category_id')),
				)), false);
		$patientMusculoskeletalAssessment=$reviewPatientDetailModel->find('all',array('fields'=>array('ReviewSubCategoriesOption.name','ReviewPatientDetail.date','ReviewPatientDetail.actualTime','ReviewSubCategoriesOption.id','ReviewPatientDetail.values'),
				'conditions'=>array('ReviewSubCategoriesOption.name'=>array('Laterality','Range of motion','Symptoms','Abnormality'),
						'ReviewPatientDetail.patient_id'=>$patientId,'ReviewPatientDetail.edited_on' => NULL),'group'=>array('ReviewSubCategoriesOption.name')));
		return $patientMusculoskeletalAssessment;
	}
	public function  getMechanicalVentilation($patientId){
		$reviewPatientDetailModel = ClassRegistry::init('ReviewPatientDetail');
		$reviewPatientDetailModel->bindModel(array(
				'belongsTo'=>array('Patient'=>array('foreignKey'=>'patient_id'),
						'ReviewSubCategory'=>array('type'=>'inner','foreignKey'=>false, 'conditions' => array('ReviewSubCategory.id=ReviewPatientDetail.review_sub_categories_id','ReviewSubCategory.name like "%Mechanical Ventilation"')),
						'ReviewSubCategoriesOption'=>array('foreignKey'=>false,'conditions' => array('ReviewSubCategoriesOption.id=ReviewPatientDetail.review_sub_categories_options_id')),
						'ReviewCategory'=>array('foreignKey'=>false, 'conditions' => array('ReviewCategory.id=ReviewSubCategory.review_category_id')),
				)), false);
		$patientMechanicalVentilation=$reviewPatientDetailModel->find('all',array('fields'=>array('ReviewSubCategoriesOption.name','ReviewPatientDetail.date','ReviewPatientDetail.actualTime','ReviewSubCategoriesOption.id','ReviewPatientDetail.values'),
				'conditions'=>array('ReviewSubCategoriesOption.name'=>array('Pressure Support Ventilation (PSV)','Positive End Expiratory Pressure (PEEP)','Fio2','Tidal Volume','Resuscitation Bag'),
						'ReviewPatientDetail.patient_id'=>$patientId,'ReviewPatientDetail.edited_on' => NULL),'group'=>array('ReviewSubCategoriesOption.name')));
		return $patientMechanicalVentilation;
	}
	public function  getEdemaAssessment($patientId){
		$reviewPatientDetailModel = ClassRegistry::init('ReviewPatientDetail');
		$reviewPatientDetailModel->bindModel(array(
				'belongsTo'=>array('Patient'=>array('foreignKey'=>'patient_id'),
						'ReviewSubCategory'=>array('type'=>'inner','foreignKey'=>false, 'conditions' => array('ReviewSubCategory.id=ReviewPatientDetail.review_sub_categories_id','ReviewSubCategory.name like "%Edema Assessment"')),
						'ReviewSubCategoriesOption'=>array('foreignKey'=>false,'conditions' => array('ReviewSubCategoriesOption.id=ReviewPatientDetail.review_sub_categories_options_id')),
						'ReviewCategory'=>array('foreignKey'=>false, 'conditions' => array('ReviewCategory.id=ReviewSubCategory.review_category_id')),
				)), false);
		$patientEdemaAssessment=$reviewPatientDetailModel->find('all',array('fields'=>array('ReviewSubCategoriesOption.name','ReviewPatientDetail.date','ReviewPatientDetail.actualTime','ReviewSubCategoriesOption.id','ReviewPatientDetail.values'),
				'conditions'=>array('ReviewSubCategoriesOption.name'=>array('Right Ankle Edema','Left Ankle Edema','Bilateral Ankle Edema','Right Lower Leg Edema','Left Lower Leg Edema','Bilateral Lower Leg Edema','Right Upper Leg Edema','Left Upper Leg Edema',
						'Bilateral Upper Leg Edema','Right Leg Edema','Left Leg Edema','Bilateral Leg Edema','Scrotum Edema','Labia Edema','Edema, Sacral','Right Hand Edema','Left Hand Edema','Bilateral Hand Edema','Right Lower Arm Edema','Left Lower Arm Edema',
						'Bilateral Lower Arm Edema','Right Upper Arm Edema','Left Upper Arm Edema','Bilateral Upper Arm Edema','Trunk Edema','Edema'),
						'ReviewPatientDetail.patient_id'=>$patientId,'ReviewPatientDetail.edited_on' => NULL),'group'=>array('ReviewSubCategoriesOption.name')));
		return $patientEdemaAssessment;
	}
	public function  getUrinaryCatheter($patientId){
		$reviewPatientDetailModel = ClassRegistry::init('ReviewPatientDetail');
		$reviewPatientDetailModel->bindModel(array(
				'belongsTo'=>array('Patient'=>array('foreignKey'=>'patient_id'),
						'ReviewSubCategory'=>array('type'=>'inner','foreignKey'=>false, 'conditions' => array('ReviewSubCategory.id=ReviewPatientDetail.review_sub_categories_id','ReviewSubCategory.name like "%Urinary Catheter"')),
						'ReviewSubCategoriesOption'=>array('foreignKey'=>false,'conditions' => array('ReviewSubCategoriesOption.id=ReviewPatientDetail.review_sub_categories_options_id')),
						'ReviewCategory'=>array('foreignKey'=>false, 'conditions' => array('ReviewCategory.id=ReviewSubCategory.review_category_id')),
				)), false);
		$patientUrinaryCatheter=$reviewPatientDetailModel->find('all',array('fields'=>array('ReviewSubCategoriesOption.name','ReviewPatientDetail.date','ReviewPatientDetail.actualTime','ReviewSubCategoriesOption.id','ReviewPatientDetail.values'),
				'conditions'=>array('ReviewSubCategoriesOption.name'=>array('Urine Catheter','Unexpected Response','Patient Indicated Res...','Procedure Response','Procedure Tolerance','Sterile Field','Drainage System','Catheter Secured','Balloon Inflation',
						'Type','Size','Insertion Site','Activity Type','Indications'),
						'ReviewPatientDetail.patient_id'=>$patientId,'ReviewPatientDetail.edited_on' => NULL),'group'=>array('ReviewSubCategoriesOption.name')));
		return $patientUrinaryCatheter;
	}
	public function  getBradenAssessment($patientId){
		$reviewPatientDetailModel = ClassRegistry::init('ReviewPatientDetail');
		$reviewPatientDetailModel->bindModel(array(
				'belongsTo'=>array('Patient'=>array('foreignKey'=>'patient_id'),
						'ReviewSubCategory'=>array('type'=>'inner','foreignKey'=>false, 'conditions' => array('ReviewSubCategory.id=ReviewPatientDetail.review_sub_categories_id','ReviewSubCategory.name like "%Braden Assessment"')),
						'ReviewSubCategoriesOption'=>array('foreignKey'=>false,'conditions' => array('ReviewSubCategoriesOption.id=ReviewPatientDetail.review_sub_categories_options_id')),
						'ReviewCategory'=>array('foreignKey'=>false, 'conditions' => array('ReviewCategory.id=ReviewSubCategory.review_category_id')),
				)), false);
		$patientBradenAssessment=$reviewPatientDetailModel->find('all',array('fields'=>array('ReviewSubCategoriesOption.name','ReviewPatientDetail.date','ReviewPatientDetail.actualTime','ReviewSubCategoriesOption.id','ReviewPatientDetail.values'),
				'conditions'=>array('ReviewSubCategoriesOption.name'=>array('Braden Assessment'),
						'ReviewPatientDetail.patient_id'=>$patientId,'ReviewPatientDetail.edited_on' => NULL),'group'=>array('ReviewSubCategoriesOption.name')));
		return $patientBradenAssessment;
	}
	public function  getFallRiskScaleMorse($patientId){
		$reviewPatientDetailModel = ClassRegistry::init('ReviewPatientDetail');
		$reviewPatientDetailModel->bindModel(array(
				'belongsTo'=>array('Patient'=>array('foreignKey'=>'patient_id'),
						'ReviewSubCategory'=>array('type'=>'inner','foreignKey'=>false, 'conditions' => array('ReviewSubCategory.id=ReviewPatientDetail.review_sub_categories_id','ReviewSubCategory.name like "%Fall Risk Scale Morse"')),
						'ReviewSubCategoriesOption'=>array('foreignKey'=>false,'conditions' => array('ReviewSubCategoriesOption.id=ReviewPatientDetail.review_sub_categories_options_id')),
						'ReviewCategory'=>array('foreignKey'=>false, 'conditions' => array('ReviewCategory.id=ReviewSubCategory.review_category_id')),
				)), false);
		$patientFallRiskScaleMorse=$reviewPatientDetailModel->find('all',array('fields'=>array('ReviewSubCategoriesOption.name','ReviewPatientDetail.date','ReviewPatientDetail.actualTime','ReviewSubCategoriesOption.id','ReviewPatientDetail.values'),
				'conditions'=>array('ReviewSubCategoriesOption.name'=>array('Mental status','Gait/Transferring','IV/Heparin Lock','Ambulatory aid','Secondary diagnosis (More than one medical diagnosis is listed on the patient’s chart)',
						'History of falling; immediate or within 3 months'),
						'ReviewPatientDetail.patient_id'=>$patientId,'ReviewPatientDetail.edited_on' => NULL),'group'=>array('ReviewSubCategoriesOption.name')));
		return $patientFallRiskScaleMorse;
	}


	//-------------EOF patient assessment ----------
	public function getImmunization($patientId){
		$immunization = ClassRegistry::init('Immunization');

		$immunization->bindModel(array(
				'belongsTo' => array(
						'Imunization' =>array('foreignKey' => false,'conditions'=>array('Imunization.id = Immunization.vaccine_type' )),
						'PhvsVaccinesMvx' =>array('foreignKey' => false,'conditions'=>array('PhvsVaccinesMvx.id = Immunization.manufacture_name' )),
						'PhvsMeasureOfUnit' =>array('foreignKey' => false,'conditions'=>array('PhvsMeasureOfUnit.id=Immunization.phvs_unitofmeasure_id')),
				)),false);
		$imu = $immunization->find('all',array('fields'=>array('id','patient_id','Imunization.cpt_description','date','PhvsVaccinesMvx.description','amount','PhvsMeasureOfUnit.value_code','lot_number','manufacture_name','expiry_date'),
				'conditions'=>array('patient_id'=>$patientId,'Immunization.is_deleted'=>0)));
		return $imu;

	}
	//---------Medication----
	public function getScheduled($patientId){
		$newCropPrescriptionModel = ClassRegistry::init('NewCropPrescription');
		$session = new cakeSession();

		$newCropPrescriptionModel->bindModel(array(
				'hasOne'=>array('PatientOrder'=>array('foreignKey'=>false,
						'conditions'=>array('PatientOrder.id=NewCropPrescription.patient_order_id')),
						'Patient' => array('foreignKey'=>false,'conditions'=>array('Patient.id=NewCropPrescription.patient_uniqueid')),
						'User' => array('foreignKey'=>false,'conditions'=>array('User.id=Patient.doctor_id')),
				),));

		$last12Hours = array(date('H', strtotime(date('Y-m-d H:i:s'). ' + 1 hours'))."00",date('H', strtotime(date('Y-m-d H:i:s'). ' + 11 hours')));
		$medData=$newCropPrescriptionModel->find('all',array('fields'=>array('PatientOrder.sentence','NewCropPrescription.id','NewCropPrescription.drug_name',
				'CONCAT(User.first_name," ", User.last_name) as full_name','NewCropPrescription.special_instruction','NewCropPrescription.firstdose',
				'NewCropPrescription.stopdose','NewCropPrescription.end_date','PatientOrder.status'),
				'order'=>array('NewCropPrescription.id DESC'),
				'conditions'=>array('NewCropPrescription.archive'=>'N','prn'=>'0','firstdose <='=>date('Y-m-d H:i:s'),'NewCropPrescription.route NOT'=>'intravenous',
						'NewCropPrescription.patient_uniqueid'=>$patientId,'NewCropPrescription.location_id'=>$session->read('locationid')/* ,'NewCropPrescription.firstdose BETWEEN ? AND ?' => $last12Hours */)));
		return $medData;
	}
	public function getContinuous($patientId){
		$newCropPrescriptionModel = ClassRegistry::init('NewCropPrescription');
		$session = new cakeSession();

		$newCropPrescriptionModel->bindModel(array(
				'hasOne'=>array('PatientOrder'=>array('foreignKey'=>false,
						'conditions'=>array('PatientOrder.id=NewCropPrescription.patient_order_id')),
						'Patient' => array('foreignKey'=>false,'conditions'=>array('Patient.id=NewCropPrescription.patient_uniqueid')),
						'User' => array('foreignKey'=>false,'conditions'=>array('User.id=Patient.doctor_id')),
				),));
		$contiData=$newCropPrescriptionModel->find('all',array('fields'=>array('PatientOrder.sentence','NewCropPrescription.id','NewCropPrescription.drug_name','CONCAT(User.first_name," ", User.last_name) as full_name'
				,'NewCropPrescription.special_instruction','NewCropPrescription.firstdose',
				'NewCropPrescription.stopdose','NewCropPrescription.end_date','PatientOrder.status'),
				'order'=>array('NewCropPrescription.id DESC'),
				'conditions'=>array('archive'=>'N','prn'=>'0','route'=>'intravenous','NewCropPrescription.patient_uniqueid'=>$patientId,
						'NewCropPrescription.location_id'=>$session->read('locationid'))));
		return $contiData;

	}
	public function getPrnUnscheduled($patientId){
		$newCropPrescriptionModel = ClassRegistry::init('NewCropPrescription');
		$session = new cakeSession();

		$newCropPrescriptionModel->bindModel(array(
				'hasOne'=>array('PatientOrder'=>array('foreignKey'=>false,
						'conditions'=>array('PatientOrder.id=NewCropPrescription.patient_order_id')),
						'Patient' => array('foreignKey'=>false,'conditions'=>array('Patient.id=NewCropPrescription.patient_uniqueid')),
						'User' => array('foreignKey'=>false,'conditions'=>array('User.id=Patient.doctor_id')),
				),));


		$prnUnScheduldData=$newCropPrescriptionModel->find('all',array('fields'=>array('PatientOrder.sentence','NewCropPrescription.id','NewCropPrescription.drug_name','CONCAT(User.first_name," ", User.last_name) as full_name'
				,'NewCropPrescription.special_instruction','NewCropPrescription.firstdose','NewCropPrescription.stopdose','NewCropPrescription.end_date','PatientOrder.status'),
				'order'=>array('NewCropPrescription.id DESC'),
				'conditions'=>array('archive'=>'N','prn'=>'1','NewCropPrescription.patient_uniqueid'=>$patientId,'firstdose <='=>date('Y-m-d H:i:s'),
						'NewCropPrescription.location_id'=>$session->read('locationid'))));
		return $prnUnScheduldData;
	}

	//---------Eof MED--------

	public function getMicrobiology($patientId){ //TestGroup
		/* $labModel = ClassRegistry::init('Laboratory');
		 $labModel->bindModel(array('belongsTo' => array(
		 		'TestGroup' =>array('foreignKey'=>false, 'conditions' => array('TestGroup.id=Laboratory.test_group_id')),
		 		'LaboratoryCategory' =>array('foreignKey'=>false, 'conditions' => array('LaboratoryCategory.laboratory_id=Laboratory.id')),
		 		'ServiceCategory' =>array('foreignKey'=>false, 'conditions' => array('ServiceCategory.id=Laboratory.service_group_id')),
		 )),false);
		$dataLab=Configure::read("microbiology");
		$labData=$labModel->find('all',array('fields'=>array('Laboratory.name','TestGroup.name','ServiceCategory.name','LaboratoryCategory.category_name'),'conditions'=>array('TestGroup.name'=>$dataLab)));
		return $labData; */

		$laboratoryTestOrder = ClassRegistry::init('LaboratoryTestOrder');

		$laboratoryTestOrder->bindModel(array(
				'belongsTo' => array(
						'Laboratory'=>array('foreignKey'=>'laboratory_id')),

				'hasOne' => array('LaboratoryResult'=>array('foreignKey'=>'laboratory_test_order_id'),
						'LaboratoryHl7Result'=>array('foreignKey'=>false,
								'conditions'=>array('LaboratoryResult.id =LaboratoryHl7Result.laboratory_result_id')),
						'TestGroup' =>array('foreignKey'=>false, 'conditions' => array('TestGroup.id=Laboratory.test_group_id')),
						'LaboratoryCategory' =>array('foreignKey'=>false, 'conditions' => array('LaboratoryCategory.laboratory_id=Laboratory.id')),
						'ServiceCategory' =>array('foreignKey'=>false, 'conditions' => array('ServiceCategory.id=Laboratory.service_group_id')),
				)));

		$dataLab=Configure::read("microbiology");

		$labResult= $laboratoryTestOrder->find('all',array('fields'=>array('Laboratory.name','LaboratoryHl7Result.observations'
				,'LaboratoryHl7Result.result','LaboratoryHl7Result.uom','LaboratoryHl7Result.range','LaboratoryHl7Result.abnormal_flag',
				'LaboratoryHl7Result.unit','TestGroup.name','ServiceCategory.name','LaboratoryCategory.category_name')
				,'conditions'=>array('LaboratoryTestOrder.patient_id'=>$this->patientId,
						'LaboratoryTestOrder.is_deleted'=>0,'TestGroup.name'=>$dataLab),'group'=>array('LaboratoryTestOrder.laboratory_id')));
		return $labResult;


	}


	public function getPathology($patientId){
		/* $labModel = ClassRegistry::init('Laboratory');
		 $labModel->bindModel(array('belongsTo' => array(
		 		'TestGroup' =>array('foreignKey'=>false, 'conditions' => array('TestGroup.id=Laboratory.test_group_id')),
		 		'LaboratoryCategory' =>array('foreignKey'=>false, 'conditions' => array('LaboratoryCategory.laboratory_id=Laboratory.id')),
		 		'ServiceCategory' =>array('foreignKey'=>false, 'conditions' => array('ServiceCategory.id=Laboratory.service_group_id')),
		 )),false);
		$dataPathology=Configure::read("pathology");
		$labData=$labModel->find('all',array('fields'=>array('Laboratory.name','TestGroup.name','ServiceCategory.name','LaboratoryCategory.category_name'),'conditions'=>array('TestGroup.name'=>$dataPathology)));
		return $labData; */
		$laboratoryTestOrder = ClassRegistry::init('LaboratoryTestOrder');

		$laboratoryTestOrder->bindModel(array(
				'belongsTo' => array(
						'Laboratory'=>array('foreignKey'=>'laboratory_id')),

				'hasOne' => array('LaboratoryResult'=>array('foreignKey'=>'laboratory_test_order_id'),
						'LaboratoryHl7Result'=>array('foreignKey'=>false,
								'conditions'=>array('LaboratoryResult.id =LaboratoryHl7Result.laboratory_result_id')),
						'TestGroup' =>array('foreignKey'=>false, 'conditions' => array('TestGroup.id=Laboratory.test_group_id')),
						'LaboratoryCategory' =>array('foreignKey'=>false, 'conditions' => array('LaboratoryCategory.laboratory_id=Laboratory.id')),
						'ServiceCategory' =>array('foreignKey'=>false, 'conditions' => array('ServiceCategory.id=Laboratory.service_group_id')),
				)));

		$dataPathology=Configure::read("pathology");

		$labResult= $laboratoryTestOrder->find('all',array('fields'=>array('Laboratory.name','LaboratoryHl7Result.observations'
				,'LaboratoryHl7Result.result','LaboratoryHl7Result.uom','LaboratoryHl7Result.range','LaboratoryHl7Result.abnormal_flag',
				'LaboratoryHl7Result.unit','TestGroup.name','ServiceCategory.name','LaboratoryCategory.category_name')
				,'conditions'=>array('LaboratoryTestOrder.patient_id'=>$this->patientId,
						'LaboratoryTestOrder.is_deleted'=>0,'TestGroup.name'=>$dataPathology),'group'=>array('LaboratoryTestOrder.laboratory_id')));
		return $labResult;
	}

	public function getPatientInfo($patientId){
		$patientInfo=ClassRegistry::init('Patient');
		$patientInfo->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));

		$patientInfo->bindModel(array(
				'belongsTo'=>array('Person'=>array('foreignKey'=>false,'conditions'=>array('Patient.person_id=Person.id')),
						'AdvanceDirective'=>array('foreignKey'=>false,'conditions'=>array('AdvanceDirective.patient_id=Patient.id')),
						'Guardian'=>array('foreignKey'=>false,'conditions'=>array('Guardian.person_id=Person.id')),
						'User' => array('foreignKey'=>false,'conditions'=>array('User.id=Patient.doctor_id')),
						'Note'=>array('foreignKey'=>false,'conditions'=>array('Note.patient_id=Patient.id')),
						'Diagnosis'=>array('foreignKey'=>false,'conditions'=>array('Diagnosis.patient_id=Patient.id')),
				)
		));
		$dataInfo=$patientInfo->find('first',array('fields'=>array('Diagnosis.complaints','Note.id','Note.cc','Person.adv_directive','Person.person_local_number_second','AdvanceDirective.patient_id','Guardian.guar_first_name',
				'CONCAT(User.first_name," ", User.last_name) as full_name','Patient.emergency_contact','Guardian.guar_last_name','Guardian.guar_mobile','Guardian.guar_localno'),'conditions'=>array('Patient.id'=>$patientId),'order' => array('Note.id' => 'desc')));
		return $dataInfo;

	}

	public function getPatientFamilyEducation($patientId){
		$newCropPrescriptionModel = ClassRegistry::init('NewCropPrescription');//
		$newCropPrescriptions = $newCropPrescriptionModel->find('all',array('fields'=>array('NewCropPrescription.patient_uniqueid','NewCropPrescription.id','NewCropPrescription.drug_id','NewCropPrescription.description','NewCropPrescription.dose','NewCropPrescription.route','NewCropPrescription.frequency','NewCropPrescription.date_of_prescription','NewCropPrescription.date_of_prescription_1','NewCropPrescription.end_date'),
				'conditions' => array('NewCropPrescription.patient_uniqueid' =>$patientId,'NewCropPrescription.archive'=>'N')));
		return $newCropPrescriptions;
			
		/*$noteDiagnosisModel = ClassRegistry::init('NoteDiagnosis');
			$noteDiagnosisModel->bindModel(array(
					'belongsTo'=>array(
							'Note'=>array('foreignKey'=>false,'conditions'=>array('Note.id=NoteDiagnosis.note_id')))));
			
		$noteDiagnoses = $noteDiagnosisModel->find('all',array('fields'=>array('Note.id','NoteDiagnosis.id','NoteDiagnosis.patient_id','NoteDiagnosis.diagnoses_name','NoteDiagnosis.icd_id','NoteDiagnosis.disease_status'),'conditions' => array('NoteDiagnosis.patient_id' =>$patientId,'is_deleted'=>0,'NoteDiagnosis.disease_status !="resolved"' ),'order'=>array('NoteDiagnosis.id DESC')));
		//return $noteDiagnoses;
			
		$laboratoryHl7Result = ClassRegistry::init('LaboratoryHl7Result');
		$laboratoryHl7Result->bindModel(array(
				'belongsTo' => array(
						'LaboratoryResult'=>array('foreignKey'=>false, 'conditions' => array('LaboratoryResult.id=LaboratoryHl7Result.laboratory_result_id')),
						'Laboratory'=>array('foreignKey'=>false, 'conditions' => array('Laboratory.id=LaboratoryResult.laboratory_id')),
						'TestGroup'=>array('foreignKey'=>false, 'conditions' => array('Laboratory.test_group_id=TestGroup.id')),
				)), 1);
		$getLabsStatusList = $laboratoryHl7Result->find('all', array('conditions' => array('LaboratoryResult.patient_id' => $this->patientId), 'fields' => array('Laboratory.test_group_id', 'Laboratory.name', 'Laboratory.lonic_code'), 'group' => array('Laboratory.name')));
		//return $getLabsStatusList;
			
		$newCropPrescriptions=array_merge($noteDiagnoses,$newCropPrescriptions,$getLabsStatusList);
		return $newCropPrescriptions;*/
	}
	public function getOverdueTask($patientId){
		$medicationAdministeringRecord=ClassRegistry::init('MedicationAdministeringRecord');
		$medicationAdministeringRecord->bindModel(array(
				'belongsTo'=>array('NewCropPrescription'=>array('foreignKey'=>false,'conditions'=>array('NewCropPrescription.id=MedicationAdministeringRecord.new_crop_prescription_id')))));
		$last24hr = array(date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s'). ' - 1 day')), date('Y-m-d H:i:s'));
		$overData=$medicationAdministeringRecord->find('all',array('fields'=>array('NewCropPrescription.drug_name','MedicationAdministeringRecord.performed_datetime'),
				'conditions'=>array('MedicationAdministeringRecord.patient_id'=>$patientId,'MedicationAdministeringRecord.late_reason_flag'=>'1','MedicationAdministeringRecord.is_signed'=>'1',
						'MedicationAdministeringRecord.performed_datetime BETWEEN ? AND ?' => $last24hr)));
		return $overData;
	}

	public function getOverdueTaskLab($patientId){
		$laboratoryTestOrder = ClassRegistry::init('LaboratoryTestOrder');
		$RadiologyTestOrder = ClassRegistry::init('RadiologyTestOrder');
		$dateFormat = ClassRegistry::init('DateFormatComponent');
		/** Lab Code Start*/
		$laboratoryTestOrder->bindModel(array(
				'belongsTo' => array(
						'Laboratory' =>array('foreignKey'=>false,'conditions'=>array('LaboratoryTestOrder.laboratory_id=Laboratory.id')),
						'LaboratoryResult' =>array('foreignKey'=>false,'conditions'=>array('LaboratoryResult.laboratory_test_order_id=LaboratoryTestOrder.id')),
				)));
		$labData = $laboratoryTestOrder->find('all',array('fields'=>array('LaboratoryTestOrder.id','LaboratoryTestOrder.start_date',
				'LaboratoryTestOrder.order_id','LaboratoryResult.id','Laboratory.name'),
				'conditions'=>array("LaboratoryTestOrder.patient_id"=>$patientId)));
		$overdueLab = array();
		foreach($labData as $labRecords){
			$difference = $dateFormat->dateDiff($labRecords['LaboratoryTestOrder']['start_date'],date('Y-m-d H:i:s')) ;
			if(($difference->h >= 23 || $difference->d != 0) && empty($labRecords['LaboratoryResult']['id'])){
				unset($labRecords['LaboratoryResult']);
				$labRecords['LaboratoryTestOrder']['start_date'] = $dateFormat->formatDate2LocalForReport($labRecords['LaboratoryTestOrder']['start_date'],Configure::read('date_format'),false);
				$overdueLab[] = $labRecords;
			}

		} 
		/** end of lab start of Rad */
		$RadiologyTestOrder->bindModel(array(
				'belongsTo' => array(
						'Radiology' =>array('foreignKey'=>false,'conditions'=>array('RadiologyTestOrder.radiology_id=Radiology.id')),
						'RadiologyResult' =>array('foreignKey'=>false,'conditions'=>array('RadiologyResult.radiology_test_order_id=RadiologyTestOrder.id')),
				)));
		$radData = $RadiologyTestOrder->find('all',array('fields'=>array('RadiologyTestOrder.id','RadiologyTestOrder.radiology_order_date',
				'RadiologyTestOrder.order_id','RadiologyResult.id','Radiology.name'),'conditions'=>array("RadiologyTestOrder.patient_id"=>$patientId)));
		$overdueRad = array();
		foreach($radData as $radRecords){
			$difference = $dateFormat->dateDiff($radRecords['RadiologyTestOrder']['radiology_order_date'],date('Y-m-d H:i:s')) ;
			if(($difference->h >= 23 || $difference->d != 0) && empty($radRecords['RadiologyResult']['id'])){
				$radRecords['RadiologyTestOrder']['radiology_order_date'] = $dateFormat->formatDate2LocalForReport($radRecords['RadiologyTestOrder']['radiology_order_date'],Configure::read('date_format'),false);
				$overdueRad[] = $radRecords;
			}

		}
		/** end of Rad */
		return array($overdueLab,$overdueRad);
	}
	public function getRadiologyTestOrder($patientId){
		$radiologyTestOrder = ClassRegistry::init('RadiologyTestOrder');
		$radiologyTestOrder->bindModel(array(
				'belongsTo' => array(
						'RadiologyResult' =>array('foreignKey' => false,'conditions'=>array('RadiologyResult.radiology_test_order_id=RadiologyTestOrder.id')),
						'Radiology' =>array('foreignKey' => false,'conditions'=>array('Radiology.id=RadiologyTestOrder.radiology_id')),
				)));
		$getRadiologyTestOrder=$radiologyTestOrder->find('all',array('conditions'=>array('RadiologyTestOrder.patient_id'=>$patientId),
				'fields'=>array('Radiology.name','RadiologyResult.id','RadiologyTestOrder.id','RadiologyTestOrder.patient_id','RadiologyTestOrder.batch_identifier')));
		return $getRadiologyTestOrder;
	}
	public function getRadiologyResult($patientId){
		$radiologyTestOrder = ClassRegistry::init('RadiologyTestOrder');
		$radiologyResult = ClassRegistry::init('RadiologyResult');
		$radiologyTestOrder->bindModel(array(
				'belongsTo' => array(
						'RadiologyResult' =>array('foreignKey' => false,'conditions'=>array('RadiologyResult.radiology_test_order_id=RadiologyTestOrder.id')),
						'Radiology' =>array('foreignKey' => false,'conditions'=>array('Radiology.id=RadiologyTestOrder.radiology_id')),
				)));
	
		$RadiologyTestOrderIds=$radiologyTestOrder->find('list',array('conditions'=>array('RadiologyTestOrder.patient_id'=>$patientId),
				'fields'=>array('id','id')));
		$radiologyResult->bindModel(array(
				'hasMany'=>array('RadiologyReport' =>array('foreignKey' =>'radiology_result_id'))));
		
		$radiologyResultValues=$radiologyResult->find('all',array('conditions'=>array('RadiologyResult.radiology_test_order_id'=>$RadiologyTestOrderIds)));
		return $radiologyResultValues;
	}
	

	public function getNursingPlansCare($patientId){
		return ;
	}
	
	public function getQualityMeasure($patientId){

		return ;
	}


	public function getActiviies($patientId){

		return ;
	}

	public function getDischargePlan($patientId){

		return ;
	}
	public function getFollowUp($patientId){
		$noteModel = ClassRegistry::init('Note');
		$notes = $noteModel->find('all',array('fields'=>array('Note.id','Note.modify_time', 'Note.plan','Note.create_time'),'conditions' => array('Note.patient_id'=>$this->patientId)));
		return $notes;
	}

	//BOF pankaj
	/**
	 * Function to retrive permissiable sections in patient portal
	 */
	function getPatientHomePage($patient_id=null){
		$patients = ClassRegistry::init('Patient');
		$patients->unbindModel(array('hasMany'=>array('PharmacySalesBill' ,'InventoryPharmacySalesReturn')));
		$permit=$patients->find('first',array('fields'=>array('permissions'),'conditions'=>array('Patient.id'=>$patient_id)));
		return $permit ;
	}

	//function to permissible section to view in CCDA in patient portal
	function getClinicalPermissions($patient_id=null){
		$xmlNote = ClassRegistry::init('XmlNote');
		$xml_id= $xmlNote->find('first',array('fields'=>array('patient_permission'),
				'conditions'=>array('XmlNote.patient_id'=>$patient_id)));
		/*
			if(!empty($xml_id['XmlNote']['patient_permission'])){
		$array = explode('|',$xml_id['XmlNote']['patient_permission']);
		for($i=0;$i<count($array);$i++){
		$xml_id['XmlNote'][$array[$i]] = $array[$i];
		}
		return $xml_id ;
		}  */
		return $xml_id;
	}
	//EOF pankaj
	
	
	public function getPatientDocuments($personId=null,$flag=null,$patientIdSOAP=null){ //PatientDocumentType, User//$patientId from SOAP
		$procedure=ClassRegistry::init("PatientDocument");
		$Note=ClassRegistry::init("Note");
		$procedure->bindModel(array(
				'belongsTo'=>array('PatientDocumentType'=>array('foreignKey'=>false,'conditions'=>array('PatientDocumentType.id=PatientDocument.document_id')),
						'User' => array('foreignKey'=>false,'conditions'=>array('User.id=PatientDocument.sb_registrar')))
		));
		if(empty($this->patientId)){
			 $getEncounterID=$Note->encounterHandler($patientIdSOAP,$personId);
			if(count($getEncounterID)==1){
				$getEncounterID=$getEncounterID['0'];
			} 
		$this->getAllPatientIds($personId);
		} //for soap note call
		if($flag == 'SBAR'){
			$condition = array('PatientDocument.patient_id'=>$this->patientId);
		}else if($flag != 'SBAR'){
			$condition = array('PatientDocument.show_documents'=>'1','PatientDocument.patient_id'=>$getEncounterID);
		}
		$dataProcedure=$procedure->find('all',array('conditions'=>$condition,
				'fields'=>array('id','name','PatientDocumentType.name','date','User.first_name','User.last_name','PatientDocument.comment'
						,'PatientDocument.link','PatientDocument.filename','PatientDocumentType.name')));
		return $dataProcedure;
	}
public function insertAllergies($patient_id=null,$id=null,$data =array()){
		$Allergies=ClassRegistry::init('NewCropAllergies');
		$this->uses=array('NewCropAllergies');
		$session     = new cakeSession();
		$userid 	 = $session->read('userid') ;
		$locationId  = $session->read('locationid') ;
		$this->create();
		$CountOfAllergiesRecord=count($data);
		$deleteAllergyArr=array();
		

		
		$allergyPresent = $Allergies->find('all',array('fields'=>array('id','CompositeAllergyID','note','onset_date'),'conditions' =>array('patient_id'=>$patient_id,'is_deleted'=>'0','is_posted'=>'yes')));
	  
	   foreach($allergyPresent as $key=>$myData){
	   	$testDataNC[]=$myData['NewCropAllergies']['CompositeAllergyID'];
	   	$testDataNCnote[]=$myData['NewCropAllergies']['note'];
	   	$myOnSet=explode(' ',$myData['NewCropAllergies']['onset_date']);
	   	$testDataNConset_date[]=$myOnSet[0];
	   }
	   foreach($data as $dataNC){
	   	$testDataFromNC[]=$dataNC['0'];
	   }
	  
	 
		
		for($cnt=0;$cnt<=count($allergyPresent);$cnt++)		
		{		
			if((!(in_array($testDataNC[$cnt],$testDataFromNC))))
			{	
				   $deleteAllergyArrNewcrop[]=$testDataNC[$cnt];
				
			}
			
		}
		
	
     if(!empty($deleteAllergyArrNewcrop[0]))
     {
     	  $Allergies->updateAll(array('is_deleted' => 1), array('patient_id'=>$patient_id,'is_posted'=>'yes','CompositeAllergyID'=>$deleteAllergyArrNewcrop));
     }
     
    
     
		/*foreach($allergyPresent as $key =>$allergyPresentvalue){
			
		if($allergyPresentvalue['NewCropAllergies']['CompositeAllergyID']==)
			continue;// do not do anything when if it is not posted
	 }*/
		
   //  $Allergies->deleteAll(array('patient_id'=>$patient_id,'is_posted'=>'yes'),false);
		for($counter=0;$counter<$CountOfAllergiesRecord ;$counter++){
			$onset_date=substr($data[$counter]['13'],0,4)."-".substr($data[$counter]['13'],4,2)."-".substr($data[$counter]['13'],6,2);
			//M sir
		$allergyDataCount = $Allergies->find('all',array('fields'=>array('id','is_posted','is_deleted','CompositeAllergyID','status'),
				'conditions' =>array('patient_id'=>$patient_id,'CompositeAllergyID'=> $data[$counter]['0'])));

			if($allergyDataCount[0]['NewCropAllergies']['status']=='N'){
				continue;
			}

			if($allergyDataCount[0]['NewCropAllergies']['is_deleted']=='1'){
					continue;
			}
			
			if($allergyDataCount['NewCropAllergies']['is_posted']=='no')
				continue; // do not update further if is_posted is no
			
			
			if(!empty($allergyDataCount[0]['NewCropAllergies']['id']) ||$allergyDataCount[0]['NewCropAllergies']['id']!='null')
			{
			
				$value['id']= $allergyDataCount[0]['NewCropAllergies']['id'];
			}
		  	elseif(empty($data[$counter]['0']))
			{
				$value['id']="";
				$value['is_posted']= "yes";
				$value['patient_uniqueid']= $id;
				
			}
			else
			{
				$value['id']="";
				$value['is_posted']= "yes";
				$value['patient_uniqueid']= $id;
				
			}
			//ENd
			
			if(empty($value['id']))
				$value['patient_uniqueid']= $id;
			
			$value['is_posted']= "yes";
		
		$value['CompositeAllergyID'] = $data[$counter]['0'] ;
		$value['AllergySourceID']= $data[$counter]['1'];
		$value['AllergyConceptId']= $data[$counter]['3'] ;
		$value['ConceptType']= $data[$counter]['4'] ;
		$value['AllergySeverityTypeId']= $data[$counter]['7'] ;
		$value['AllergySeverityName']= $data[$counter]['8'] ;
		$value['note']= $data[$counter]['9'] ;
		$value['ConceptID']= $data[$counter]['10'] ;
		$value['ConceptTypeId']= $data[$counter]['11'] ;
		$value['name']= $data[$counter]['5'] ;
		$value['allergies_id']= $data[$counter]['2'] ;
		$value['status']= $data[$counter]['6'] ;
		$value['rxnorm']= $data[$counter]['12'] ;
		$value['patient_id']= $patient_id ;
		//$value['patient_uniqueid']= $id ;
		$value['location_id']= $locationId ;
		$value['onset_date']= $onset_date ;
		//debug($testDataNCnote);debug($testDataNConset_date); debug($value);debug($testDataNC); exit;
		/* if(!(in_array($value['CompositeAllergyID'],$testDataNC))){ */
		//if(($value['note']!=$testDataNCnote[$counter]) || $value['onset_date']!=$testDataNConset_date[$counter]){
		$Allergies->save($value);
		//}
		//else{
		//}
	 	$Allergies->id=null;
		}
	}
	

	public function getInitialAssessment($patientId=null){
		$getDiagnosis = ClassRegistry::init('Patient');

		$getDiagnosis->unbindModel(array('hasMany'=>array('PharmacySalesBill' ,'InventoryPharmacySalesReturn')));
		$getDiagnosis->bindModel(array(
				'belongsTo'=>array(
						'Diagnosis'=>array('foreignKey'=>false,'conditions'=>array('Diagnosis.patient_id=Patient.id')),
						'User'=>array('foreignKey'=>false,'conditions'=>array('User.id=Patient.doctor_id')))));

		/* 'hasMany' => array(
		 'Appointment'=>array('foreignKey'=>'patient_id')
		))); */

		$dataDiagnosis=$getDiagnosis->find('all',array('conditions'=>array('Diagnosis.patient_id'=>$this->patientId),
				'fields'=>array('Diagnosis.id','Diagnosis.patient_id','Diagnosis.create_time','Diagnosis.modify_time','CONCAT(User.first_name," ", User.last_name) as dr_full_name')));
		return $dataDiagnosis;

	}
	public function getHospital($patientId=null){
		$getPlanData = ClassRegistry::init('ReferralToHospital');
		/* $getPlanData->bindModel(array(
				'belongsTo' => array(
						'User' =>array('foreignKey' => false,'conditions'=>array('User.id=ReferralToHospital.doctor_id'),'fields'=>array('id')),
						'DoctorProfile' =>array('foreignKey' => false,'conditions'=>array('DoctorProfile.user_id=User.id'),'fields'=>array('doctor_name')),
				)),false); */
		$dataPlan = $getPlanData->find('all',array('conditions'=>array('ReferralToHospital.patient_id'=>$patientId)));
		return $dataPlan;
		
	}
	public function getSpecialist($patientId=null){
		$getPlanData = ClassRegistry::init('ReferralToSpecialist');
		/* $getPlanData->bindModel(array(
				'belongsTo' => array(
						'User' =>array('foreignKey' => false,'conditions'=>array('User.id=ReferralToSpecialist.doctor_id'),'fields'=>array('id')),
						'DoctorProfile' =>array('foreignKey' => false,'conditions'=>array('DoctorProfile.user_id=User.id'),'fields'=>array('doctor_name')),
				)),false); */
		$record_detail = $getPlanData->find('all',array('conditions'=>array('ReferralToSpecialist.patient_id'=>$patientId)));
		return $record_detail;
	
	}
}