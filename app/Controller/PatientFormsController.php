<?php
/**
 * FormsController file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Wards Controller
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 */

class PatientFormsController extends AppController {

	public $name = 'PatientForms';
	public $helpers = array('Html','Form', 'Js','General','JsFusionChart');
	public $components = array('RequestHandler','Email', 'Session','GibberishAES');
	public $uses = array('PatientForm', 'FormQuestion', 'FormAnswer','PatientDataForms');


	function getForm($formType = '', $patientFormId=''){#echo '';exit;
		$this->set('patientFormType',$formType);
		$this->set('patientFormId',$patientFormId);
		$PatientFormData = $this->FormQuestion->find('all', array('conditions' => array('FormQuestion.is_active' => 1, 'FormQuestion.patient_form_id' => $patientFormId)));
		$this->set('PatientFormData',$PatientFormData);
		#echo '<pre>';print_r($formQuestionData);exit;
	}

	function __formataPatientFormData($data,$patient_id,$questionNo,$PatientFormId){
		foreach($data as $key => $value){
			$this->PatientDataForms->id = '';
			$questionNo = str_replace("incident", "", $questionNo);
			$this->PatientDataForms->save(array('form_question_id' =>$questionNo,
					'data' => $value, 'patient_id' => $patient_id,
					'patient_form_id' => $PatientFormId));
		}
	}


	function patientFormSave(){
		#echo '<pre>';print_r($this->request->data);exit;
		$PatientFormId = $this->request->data['patient_form_id'];//temp
		#$PatientFormId =2;//temp
		$patient_id = $this->request->data['patient_id'];
		foreach($this->request->data as $key => $value){
			if(is_array($value)){
				$this->__formataPatientFormData($value,$patient_id,$key,$PatientFormId);
			}else{
				$questionNo = str_replace("incedent", "", $key);
				$this->PatientDataForms->id = '';
				$this->PatientDataForms->save(array('form_question_id' =>$questionNo,
						'data' => $value, 'patient_id' => $patient_id,
						'patient_form_id' => $PatientFormId));
			}

		}
		$this->redirect('/PatientForms/viewPatientFormData/'.$PatientFormId.'/'.$patient_id);
	}

	function viewPatientFormData($patientFormId= '', $patientId){
		#echo '<pre>';print_r($this->);exit;
		$PatientFormData = $this->PatientDataForms->find('all', array('conditions' => array('PatientDataForms.patient_form_id' => $patientFormId,'patient_id'=>$patientId)));
		$PatientFormQuestionData = $this->FormQuestion->find('all', array('conditions' => array('FormQuestion.is_active' => 1, 'FormQuestion.patient_form_id' => $patientFormId)));
		$this->set('formQuestions',$PatientFormQuestionData);
		$this->set('formAnswers',$PatientFormData);
		$this->set('patient_form_nr',$patientFormId);
		$this->set('patient_nr',$patientId);

		if(count($PatientFormData) == 0){
			$form = $this->PatientForm->find('first',array('conditions' =>array('PatientForm.id'=>$patientFormId)));
			$this->Session->setFlash(__('No record found.', true));
			$this->redirect(array("controller" => "PatientForms", "action" => "getForm",$form['PatientForm']['name'],$patientFormId));
		}


	}

	function searchPatientForm(){
		$this->redirect('/PatientForms/viewPatientFormData/'.$this->request->data['PatientForm']['patientFormId'].'/'.$this->request->data['PatientForm']['patient_id_search']);
	}

	function printPatientForm($patientFormId= '', $patientId){
		$this->layout = false;
		if($patientId!='' && $patientFormId !=''){
			$PatientFormData = $this->PatientDataForms->find('all', array('conditions' => array('PatientDataForms.patient_form_id' => $patientFormId,'patient_id'=>$patientId)));
			$PatientFormQuestionData = $this->FormQuestion->find('all', array('conditions' => array('FormQuestion.is_active' => 1, 'FormQuestion.patient_form_id' => $patientFormId)));
			$this->set('formQuestions',$PatientFormQuestionData);
			$this->set('formAnswers',$PatientFormData);
			if(count($PatientFormData) == 0){
				$form = $this->PatientForm->find('first',array('conditions' =>array('PatientForm.id'=>$patientFormId)));
				$this->Session->setFlash(__('No record found.', true));
				$this->redirect(array("controller" => "PatientForms", "action" => "getForm",$form['PatientForm']['name'],$patientFormId));
			}
		}
	}
	public function hpiCall($patient_id,$noteId=null,$apptId){
		$this->layout='advance_ajax';
		$this->uses=array('Template','TemplateTypeContent','Note','Diagnosis','NoteTemplate');
		if(!$this->params->query['note_Template']){/** for showing General Examination as default */
			$this->params->query['note_Template'] = 199; /** 968 is NoteTemplateId for general Examination */
		}
		if($this->params->query['note_Template']){
			//to show the lower body of the page
			$this->set('showDialog','1');
			//**************************************************************
			//-------------------------------------------------------------------------------------------------------------------
			$this->Template->bindModel(array(
					'hasMany' => array(
							'TemplateSubCategories' =>array(
									'foreignKey'=>'template_id' ,'conditions'=>array('TemplateSubCategories.is_deleted=0',
											'TemplateSubCategories.note_template_id'=>$this->params->query['note_Template']),
									'order'=>array('ISNULL(TemplateSubCategories.sort_order), TemplateSubCategories.sort_order ASC')
							),
					)));
			$roseData=$this->Template->find('all',array('conditions'=>array('Template.template_category_id'=>3,'Template.is_deleted'=>0),'order'=>array('ISNULL(Template.sort_order), Template.sort_order ASC')));
			$this->set('roseData',$roseData);
		}
		$this->set('templateTypeContent',$this->TemplateTypeContent->find('list',array('fields'=>array('template_id','template_subcategory_id'),'conditions'=>array('patient_id'=>$patient_id,'note_id'=>$noteId))));
		$this->set('patientSpecificTemplate',$this->TemplateTypeContent->find('list',array('fields'=>array('template_id','patient_specific_template'),'conditions'=>array('patient_id'=>$patient_id,'note_id'=>$noteId))));
		$this->set('hpiIdentified',$this->TemplateTypeContent->find('first',array('fields'=>array('hpi_identified'),'conditions'=>array('patient_id'=>$patient_id/*,'diagnoses_id'=>$dId['Diagnosis']['id']*/),'order'=>array('id DESC'))));
			


		$this->set('patientId',$patient_id);
		if(!empty($noteId)){
			$this->set('noteId',$noteId);
		}

		//-----------------------------------------------------------------------------------------------------------------------------------------------
		if(isset($this->request->data) && !empty($this->request->data)){
			$patientId=$this->request->data['Patient']['patientId'];
			$noteId=$this->request->data['Patient']['noteId'];
			$diagnosisId=$this->request->data['Patient']['DiagnosisId'];
			$hpiIdentified=$this->request->data['TemplateType']['hpi_identified'];
			//*****************check for patient iD************************
			if(empty($noteId)){
				$noteId=$this->addBlankNote($patientId);
			}
			//*************eof****************************
			/*foreach($this->request->data['TemplateTypeContent'] as $keyHpi=>$checkDataHpi){
			if (in_array("1", $checkDataHpi)) {
			$cntHpi++;
			}
			}*/
			$note_template_id=$this->request->data['TemplateType']['note_template_id'];

			//if($cntHpi>0){
			$categoryData=$this->TemplateTypeContent->insertCategoryHPI($this->request->data['TemplateTypeContent'],$noteId,$patientId,'no',$diagnosisId,$note_template_id,$hpiIdentified);
			//}
			$this->set('noteIdClose',$noteId);
			$this->redirect("/notes/soapNote/".$patientId."/".$noteId);
		}

		$tName=$this->NoteTemplate->find('list',array('fields'=>array('id','template_name'),'conditions'=>array('is_deleted'=>'0','template_type'=>array('all','')),'order'=>array('ISNULL(NoteTemplate.sort_order), NoteTemplate.sort_order ASC')));
		//debug($tName);
		$this->set('tName',$tName);
	}
	//Function for psychology history of patient
	//@author Mahalaxmi
	public function psychologyHistory($patient_id=null){
		$this->uses = array('PsychologyHistory','Patient','NewCropPrescription','Configuration','Diagnosis',
				'PatientSmoking','PatientPersonalHistory','SmokingStatusOncs');
		$this->patient_info($patient_id);


		$getConfigueMedication=$this->Configuration->find('all');
		$strenght=unserialize($getConfigueMedication[0]['Configuration']['value']);
		$dose=unserialize($getConfigueMedication[1]['Configuration']['value']);
		$route=unserialize($getConfigueMedication[2]['Configuration']['value']);
		foreach($strenght as $strenghts){
			$str.='<option value='.'"'.stripslashes($strenghts).'"'.'>'.$strenghts.'</option>';
		}
		$str.='</select>';
		$this->set('str',$str);
		//================================ dose
		foreach($dose as $doses){
			$str_dose.='<option value='.'"'.stripslashes($doses).'"'.'>'.$doses.'</option>';
		}
		$str_dose.='</select>';
		$this->set('str_dose',$str_dose);
		// =======================================end dose
		//============================== route
		foreach($route as $routes){
			$str_route.='<option value='.'"'.stripslashes($routes).'"'.'>'.$routes.'</option>';
		}
		$str_route.='</select>';
		$this->set('str_route',$str_route);
		//================= end dose
		$this->set('strenght',unserialize($getConfigueMedication[0]['Configuration']['value']));
		$this->set('dose',unserialize($getConfigueMedication[1]['Configuration']['value']));
		$this->set('route',unserialize($getConfigueMedication[2]['Configuration']['value']));
		$smokingOptions =    $this->SmokingStatusOncs->find('list',array('fields'=>array('description')));
		$this->set(compact('smokingOptions','patient_id'));
		//==========================================================
		if($this->request->data){
			if(!empty($this->request->data['PsychologyHistory']['date_of_assessment']))
				$this->request->data['PsychologyHistory']['date_of_assessment'] = $this->DateFormat->formatDate2STD($this->request->data['PsychologyHistory']['date_of_assessment'],Configure::read('date_format'));
			if(!empty($this->request->data['PsychologyHistory']['effective_date']))
				$this->request->data['PsychologyHistory']['effective_date'] = $this->DateFormat->formatDate2STD($this->request->data['PsychologyHistory']['effective_date'],Configure::read('date_format'));
			if(!empty($this->request->data['PsychologyHistory']['inpatient_date1']))
				$this->request->data['PsychologyHistory']['inpatient_date1'] = $this->DateFormat->formatDate2STD($this->request->data['PsychologyHistory']['inpatient_date1'],Configure::read('date_format'));
			if(!empty($this->request->data['PsychologyHistory']['inpatient_date2']))
				$this->request->data['PsychologyHistory']['inpatient_date2'] = $this->DateFormat->formatDate2STD($this->request->data['PsychologyHistory']['inpatient_date2'],Configure::read('date_format'));
			if(!empty($this->request->data['PsychologyHistory']['proj_discharge_date']))
				$this->request->data['PsychologyHistory']['proj_discharge_date'] = $this->DateFormat->formatDate2STD($this->request->data['PsychologyHistory']['proj_discharge_date'],Configure::read('date_format'));
			if(!empty($this->request->data['PsychologyHistory']['last_date']))
				$this->request->data['PsychologyHistory']['last_date'] = $this->DateFormat->formatDate2STD($this->request->data['PsychologyHistory']['last_date'],Configure::read('date_format'));

			$this->request->data['PsychologyHistory']['location_id']=$this->Session->read('locationid');

			$this->request->data['PsychologyHistory']['created_by']=$this->Session->read('userid');
			$this->request->data['PsychologyHistory']['create_time']=date('Y-m-d H:i:s');

			$this->PsychologyHistory->save($this->request->data['PsychologyHistory']);
			if(!empty($this->request->data['PsychologyHistory']['id']))
				$lastInsertId = $this->request->data['PsychologyHistory']['id'];
			else
				$lastInsertId= $this->PsychologyHistory->getLastInsertID();

			$this->request->data['NewCropPrescription']['psychology_history_id']=$lastInsertId;
			$this->request->data['PatientPersonalHistory']['psychology_history_id']=$lastInsertId;
			$this->request->data['PatientSmoking']['psychology_history_id']=$lastInsertId;

			if(!empty($this->request->data['NewCropPrescription'])){
				$this->Diagnosis->insertCurrentTreatment($this->request->data['NewCropPrescription'],$patient_id);
			}

			if(!empty($this->request->data["PatientSmoking"]['pre_from'])){
				$this->request->data["PatientSmoking"]['pre_from'] = $this->DateFormat->formatDate2STD($this->request->data["PatientSmoking"]['pre_from'],Configure::read('date_format'));
			}
			if(!empty($this->request->data["PatientSmoking"]['pre_to'])){
				$this->request->data["PatientSmoking"]['pre_to'] = $this->DateFormat->formatDate2STD($this->request->data["PatientSmoking"]['pre_to'],Configure::read('date_format'));
			}
			$date = date('Y-m-d h:i:s', time());
			if($this->request->data['PatientSmoking']['current_smoking_fre']==''){
				$this->request->data['PatientSmoking']['current_smoking_fre'] = $this->request->data['PatientSmoking']['smoking_fre2'];
				$this->request->data["PatientSmoking"]['created_date'] = $date;
			}
			else{
				if($this->request->data['PatientSmoking']['smoking_fre2']!=''){
					$this->request->data['PatientSmoking']['smoking_fre'] = $this->request->data['PatientSmoking']['current_smoking_fre'];
					$this->request->data['PatientSmoking']['current_smoking_fre'] = $this->request->data['PatientSmoking']['smoking_fre2'];
					$this->request->data["PatientSmoking"]['created_date'] = $date;
					$this->request->data['PatientSmoking']['current_from'] = $this->request->data['PatientSmoking']['pre_from1'];
					$this->request->data['PatientSmoking']['current_to'] = $this->request->data['PatientSmoking']['pre_to1'];
				}
				else{
					$this->request->data['PatientSmoking']['smoking_fre'] = $this->request->data['PatientSmoking']['smoking_fre'];
					$this->request->data['PatientSmoking']['current_smoking_fre'] = $this->request->data['PatientSmoking']['current_smoking_fre'];
					$this->request->data["PatientSmoking"]['created_date'] = $date;
					$this->request->data['PatientSmoking']['pre_from'] = $this->request->data['PatientSmoking']['pre_from1'];
					$this->request->data['PatientSmoking']['pre_to'] = $this->request->data['PatientSmoking']['pre_to1'];
					$this->request->data['PatientSmoking']['current_from'] = $this->request->data['PatientSmoking']['current_from1'];
					$this->request->data['PatientSmoking']['current_to'] = $this->request->data['PatientSmoking']['current_to1'];

				}
			}

			$this->PatientPersonalHistory->save($this->request->data['PatientPersonalHistory']);
			$this->PatientSmoking->save($this->request->data['PatientSmoking']);
			if (!empty($lastInsertId)){

				$this->Session->setFlash(__('Information saved successfully'),true);
				$this->redirect($this->referer());
			} else {
				$this->Session->setFlash('Unable to add your Information.');
			}
		}else
			$this->PsychologyHistory->bindModel(array(
					'hasMany' => array(
							'NewCropPrescription' =>array('foreignKey'=>'psychology_history_id','fields'=>array('*'),
							)),
					'hasOne'=>array(
							'PatientSmoking' =>array('foreignKey' => false,
									'conditions'=>array('PatientSmoking.psychology_history_id = PsychologyHistory.id'),
							),
							'PatientPersonalHistory' =>array('foreignKey' => false,
									'conditions'=>array('PatientPersonalHistory.psychology_history_id = PsychologyHistory.id'),
							),
					)),false);

		$psychologyHistoryData = $this->PsychologyHistory->find('first',array('fields'=>array('PsychologyHistory.*','PatientSmoking.*','PatientPersonalHistory.*'),
				'conditions'=>array('PsychologyHistory.patient_id'=>$patient_id),
				'order'=>'PsychologyHistory.id DESC'));
		if(!empty($psychologyHistoryData)){

			if(!empty($psychologyHistoryData['PsychologyHistory']['date_of_assessment']))
				$psychologyHistoryData['PsychologyHistory']['date_of_assessment'] = $this->DateFormat->formatDate2Local($psychologyHistoryData['PsychologyHistory']['date_of_assessment'],Configure::read('date_format'));
			if(!empty($psychologyHistoryData['PsychologyHistory']['effective_date']))
				$psychologyHistoryData['PsychologyHistory']['effective_date'] = $this->DateFormat->formatDate2Local($psychologyHistoryData['PsychologyHistory']['effective_date'],Configure::read('date_format'));
			if(!empty($psychologyHistoryData['PsychologyHistory']['inpatient_date1']))
				$psychologyHistoryData['PsychologyHistory']['inpatient_date1'] = $this->DateFormat->formatDate2Local($psychologyHistoryData['PsychologyHistory']['inpatient_date1'],Configure::read('date_format'));
			if(!empty($psychologyHistoryData['PsychologyHistory']['inpatient_date2']))
				$psychologyHistoryData['PsychologyHistory']['inpatient_date2'] = $this->DateFormat->formatDate2Local($psychologyHistoryData['PsychologyHistory']['inpatient_date2'],Configure::read('date_format'));
			if(!empty($psychologyHistoryData['PsychologyHistory']['proj_discharge_date']))
				$psychologyHistoryData['PsychologyHistory']['proj_discharge_date'] = $this->DateFormat->formatDate2Local($psychologyHistoryData['PsychologyHistory']['proj_discharge_date'],Configure::read('date_format'));
			if(!empty($psychologyHistoryData['PsychologyHistory']['last_date']))
				$psychologyHistoryData['PsychologyHistory']['last_date'] = $this->DateFormat->formatDate2Local($psychologyHistoryData['PsychologyHistory']['last_date'],Configure::read('date_format'));
			$this->request->data['PsychologyHistory']['modified_by']=$this->Session->read('userid');
			$this->request->data['PsychologyHistory']['modify_time']=date('Y-m-d H:i:s');

			$this->set('psychologyHistoryData',$psychologyHistoryData);
		}

		$this->data = $psychologyHistoryData;

	}


	//===========================This function is to reconcile the medication ---Aditya Chitmitwar=============================================
	public function reconcile($patient_id){
		$this->set('patient_id',$patient_id);

	}
	public function AdmissionReconciliation(){
		//exit;
		$this->uses=array('NewCropPrescription');
		if(isset($this->params->query['patient_id']) && !empty($this->params->query['patient_id'])){

			$patient_id=$this->params->query[patient_id];
			$getDrug=$this->NewCropPrescription->findDurgForPatient($patient_id);
			$this->set('admission',$getDrug);
			$this->render('admission_reconciliation');

		}
		//$this->loadModel('CorporateSublocation');
		/* if($this->params['isAjax']) {
			$this->set('corporatesulloclist', $this->CorporateSublocation->find('all', array('fields'=> array('id', 'name'),
					'conditions' => array('CorporateSublocation.is_deleted' => 0,'CorporateSublocation.corporate_id' => $this->params->query['ajaxcorporateid']),'order'=>array('name'))));
		$this->layout = 'ajax';
		$this->render('ajaxgetcorporatesubloc');
		} */
		/* if(isset($this->request->data['AdmissionReconciliation']['patient_id']) && !empty($this->request->data['AdmissionReconciliation']['patient_id'])){
			$patient_id=$this->request->data['AdmissionReconciliation']['patient_id'];
		$getDrug=$this->NewCropPrescription->findDurgForPatient($patient_id);
		$this->set('admission',$getDrug);
		$this->set('patient_id',$patient_id);
		$this->render('reconcile');
		} */
	}

	/** function power notes **/
	public function power_note($notes_id=null, $patient_id=null, $search=null) {
		$this->uses = array('Audit','Note','NoteDiagnosis','Template','Consultant','icd','Finalization','BmiResult','BmiBpResult','ReferralToSpecialist',
				'TemplateTypeContent','NewCropAllergies','PlannedProblem','NewCropPrescription','LaboratoryToken','Laboratory',
				'LaboratoryTestOrder','RadiologyTestOrder','Radiology','ProcedurePerform','TransmittedCcda','Patient','PatientsTrackReport','Diagnosis','User');
		//debug(($this->request->params['named']['header']));exit;
		if($this->request->params['named']['header']!='show'){
			$this->layout = 'advance_ajax';
			//debug('hi');
		}
		if(!empty($this->params->query['returnUrl'])){
			$this->set('returnUrl',$this->params->query['returnUrl']);

		}
		$this->patient_info($patient_id);
		// Eounter code Aditya
		$getEncounterID=$this->Note->encounterHandler($patient_id,$this->patient_details['Person']['id']);
		if(count($getEncounterID)==1){
			$getEncounterID=$getEncounterID['0'];
		}
		if(!empty($this->params->query['appointmentId'])){
			$this->set('appointmentId',$this->params->query['appointmentId']);
		}
		//EOF
		// Setting the  sreachKey
		$this->set('sreachKey',$this->params->query['sreachKey']);
		//EOD
		$procedure_perform  = $this->ProcedurePerform->find('all',array('fields'=>array('procedure_name','procedure_date','procedure_date'),'conditions'=>array('patient_id'=>$patient_id,'is_deleted'=>'0')));
		$this->set('procedure_perform',$procedure_perform);
		//IMPORTANT FOR HPI ,ROS, ROE aditya
		$getDiagnosisId=$this->Diagnosis->find('first',array('fields'=>array('id','complaints'),'conditions'=>array('patient_id'=>$patient_id,'appointment_id'=>$_SESSION['apptDoc'])));;
		//EOF
		$this->set(array('getPatientDocuments'=>$this->PatientsTrackReport->getPatientDocuments($this->patient_details['Patient']['person_id'],'null',$patient_id)));
			
			
		if (!$notes_id) {
			$this->Session->setFlash(__('Invalid Note', true, array('class'=>'error')));
			$this->redirect(array("controller" => "notes", "action" => "patient_notes"));
		}
		$notesRec = $this->Note->read(null,$notes_id);
		/*$icdC = explode('|',$notesRec['Note']['icd']);
		 $problemName =array();
		for($i=0;$i<count($icdC);$i++){
		$problemName[] = end(explode('::',$icdC[$i]));
		}
			
		$visittype = explode('|',$notesRec['Note']['visitid']);
		$visit = $this->Finalization->find('all',array('conditions'=>array('id'=>$visittype)));*/
		/** starting Template sentences BOF */
		$storedTemplateOptions = $this->TemplateTypeContent->find('all',array('fields'=>array('patient_specific_template','template_subcategory_id',
				'template_id','template_category_id','extra_btn_options'),
				'conditions'=>array('note_id' =>$notes_id,'patient_id'=>$patient_id))) ;

		foreach($storedTemplateOptions as $key=>$value){
			$unserializedMaster =  unserialize($value['TemplateTypeContent']['template_subcategory_id']);/** getting master subCategory */
			$unserializedPatientSpecific =  unserialize($value['TemplateTypeContent']['patient_specific_template']);/** getting other patientSepcific subCategory */
			/** BOF code construct for HPI */
			if($value['TemplateTypeContent']['template_category_id'] == 3){ /** template_category_id =3 is for HPI */
				foreach($unserializedMaster as $keyMaster=>$hpivalue){
					if($hpivalue == 1){
						$resultSubCategoryGreen[$keyMaster] =  $keyMaster; /** fetch templateSubCategoryId */
						$resultTemplateId[$value['TemplateTypeContent']['template_id']] =  $value['TemplateTypeContent']['template_id'];/** fetch templateId */
					}
				}
				foreach($unserializedPatientSpecific as $otherKey=>$OtherHpivalue){
					if($OtherHpivalue == 1){ /** 1 is for green buttons */
						$hpiResultOther[$otherKey] =  $value['TemplateTypeContent']['template_id']; /** patientSpecific subCategory (subCategory => template_id) */
						$resultTemplateId[$value['TemplateTypeContent']['template_id']] =  $value['TemplateTypeContent']['template_id'];
					}
				}
			}
			/** EOF code construct for HPI */
			/** BOF code construct for ROS */
			if($value['TemplateTypeContent']['template_category_id'] == 1){ /** template_category_id =1 is for ROS */
				foreach($unserializedMaster as $keyRosMaster=>$rosValue){
					if($rosValue == 1){ /** for green buttons */
						$resultSubCategoryGreen[$keyRosMaster] =  $keyRosMaster; /** fetch templateSubCategoryId */
						$resultTemplateId[$value['TemplateTypeContent']['template_id']] =  $value['TemplateTypeContent']['template_id'];/** fetch templateId */

					}else if($rosValue ==2){ /** for red buttons */
						$resultSubCategoryRed[$keyRosMaster] =  $keyRosMaster; /** fetch templateSubCategoryId */
						$resultTemplateId[$value['TemplateTypeContent']['template_id']] =  $value['TemplateTypeContent']['template_id'];/** fetch templateId */
					}
				}
				foreach($unserializedPatientSpecific as $otherRosKey=>$OtherRosvalue){
					if($OtherRosvalue == 1){/** 1 is for green buttons */
						$rosResultOther[$otherRosKey] =  $value['TemplateTypeContent']['template_id']; /** patientSpecific subCategory (subCategory => template_id) */
						$resultTemplateId[$value['TemplateTypeContent']['template_id']] =  $value['TemplateTypeContent']['template_id'];
					}
				}
			}
			/** EOF code construct for ROS */
			/** BOF code construct for PE */
			if($value['TemplateTypeContent']['template_category_id'] == 2){ /** template_category_id = 2 is for PE */
				$unserializedPEButtons =  unserialize($value['TemplateTypeContent']['extra_btn_options']);/** getting extra btn optn from PE */
				if(!empty($unserializedPEButtons['dropdown_options']))
					$pEButtonsOptionValue[0][$value['TemplateTypeContent']['template_id']] = $unserializedPEButtons['dropdown_options'];
				if(!empty($unserializedPEButtons['extra_textarea_data']))
					$pEButtonsOptionValue[1][$value['TemplateTypeContent']['template_id']] = $unserializedPEButtons['extra_textarea_data'];
				foreach($unserializedMaster as $keyPEMaster=>$peValue){
					if($peValue == 1){ /** for green buttons */
						$resultSubCategoryGreen[$keyPEMaster] =  $keyPEMaster; /** fetch templateSubCategoryId */
						$resultTemplateId[$value['TemplateTypeContent']['template_id']] =  $value['TemplateTypeContent']['template_id'];/** fetch templateId */
							
					}else if($peValue ==2){ /** for red buttons */
						$resultSubCategoryRed[$keyPEMaster] =  $keyPEMaster; /** fetch templateSubCategoryId */
						$resultTemplateId[$value['TemplateTypeContent']['template_id']] =  $value['TemplateTypeContent']['template_id'];/** fetch templateId */
					}
				}
				foreach($unserializedPatientSpecific as $otherPeKey=>$OtherPevalue){
					if($OtherPevalue == 1){/** 1 is for green buttons */
						$peResultOther[$otherPeKey] =  $value['TemplateTypeContent']['template_id']; /** patientSpecific subCategory (subCategory => template_id) */
						$resultTemplateId[$value['TemplateTypeContent']['template_id']] =  $value['TemplateTypeContent']['template_id'];
					}
				}
			}
			/** EOF code construct for PE */

		}
		$genderKey = (strtoupper($this->patient_details['Person']['sex']) == 'MALE') ? 2 : 1; /** for fetching genderSpecific Templates */
		$this->Template->bindModel(array('hasMany'=>array(
				'TemplateSubCategories'=>array('foreignKey'=>'template_id','conditions'=>array("TemplateSubCategories.id" => $resultSubCategoryGreen),
						'fields'=>array('TemplateSubCategories.id','TemplateSubCategories.sub_category','TemplateSubCategories.extraSubcategoryDesc',
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
		/** EOF Template sentences */
		$assesment=$this->NoteDiagnosis->find('list',array('fields'=>array('id','diagnoses_name'),
				'conditions'=>array('patient_id'=>$patient_id),'order' => array('diagnoses_name ASC')));
		$this->set(compact('assesment'));
			
		// Allergy----------------------------->
		//$getEncounterID $this->patient_details['Person']['id']
		$allergies = $this->NewCropAllergies->find('all',array('conditions'=>array('patient_uniqueid'=>$getEncounterID,'patient_id'=>$this->patient_details['Person']['id'],'status'=>'A','is_deleted'=>'0')));
		$this->set('allergies',$allergies);
		// medication--------------------------->
		$this->NewCropPrescription->bindModel(array(
				'belongsTo' => array(
						'VaccineDrug' =>array('foreignKey' => false,'conditions'=>array('VaccineDrug.MEDID=NewCropPrescription.drug_id')),
				)));
		$medication = $this->NewCropPrescription->find('all',array(
				'conditions'=>array('patient_uniqueid'=>$getEncounterID,'patient_id'=>$this->patient_details['Person']['id'],
						'archive'=>'N'),'fields'=>array('NewCropPrescription.drug_name','NewCropPrescription.archive',
								'NewCropPrescription.is_med_administered','NewCropPrescription.refusetotakeimmunization'
								,'NewCropPrescription.description','VaccineDrug.MEDID')));
		$this->set('medication',$medication);
			
		$planned = $this->PlannedProblem->find('all',array('conditions'=>array('patient_id'=>$patient_id)));
			
		//BOF pankaj fetch referrals
		$this->ReferralToSpecialist->bindModel(array(
				'belongsTo' => array(
						'TransmittedCcda'=>array('foreignKey'=>false,'conditions'=>array('TransmittedCcda.id=ReferralToSpecialist.transmitted_ccda_id'))
				)));
		$ccdaResult = $this->ReferralToSpecialist->find('all',array('conditions'=>array(/*'TransmittedCcda.created_by'=>$this->Session->read('userid'),*/'ReferralToSpecialist.patient_id'=>$patient_id)));
		$this->set('ccdaData',$ccdaResult);
		//EOF fetch referals
		$this->set('planned',$planned);
		/* $this->set('registrar',$this->User->getDoctorByID($notesRec['Note']['sb_registrar']));
		 $this->set('consultant',$this->User->getDoctorByID($notesRec['Note']['sb_consultant'])); */
			
		if(!empty($notesRec['Note']['attestation_details'])){
			$notesRec['Note']  = array_merge($notesRec['Note'],unserialize($notesRec['Note']['attestation_details']));
		}
			
		if(!empty($notesRec['Note']['resident_notes'])){
			$notesRec['Note']  = array_merge($notesRec['Note'],unserialize($notesRec['Note']['resident_notes']));
		}
			
		$this->data  = $notesRec ;// by pankaj
		$this->set('note', $notesRec);
		$this->set('cc', $getDiagnosisId);//
		//$this->set('icddesc', $problemName);
		//$this->set('visittyp', $visit); // pr($visit);
		//$this->set('medicines',$suggestedDrugRec);//----------------------//
		$this->set(array('patientid'=> $patient_id,'search'=>$search));
			
		$this->LaboratoryToken->bindModel(array('belongsTo' => array(
				'Laboratory' =>array('foreignKey'=>false, 'conditions' => array('LaboratoryToken.laboratory_id=Laboratory.id')),
				'LaboratoryTestOrder' =>array('foreignKey'=>false, 'conditions' => array('LaboratoryTestOrder.laboratory_id=LaboratoryToken.laboratory_id')),
		)),false);
			
		$lab_data= $this->LaboratoryToken->find('all',array('conditions'=>array('LaboratoryToken.patient_id'=>$patient_id,'LaboratoryTestOrder.is_deleted'=>'0'),'group'=>'Laboratory.name'));
		$this->set('lab_data',$lab_data);
			
		$this->RadiologyTestOrder->bindModel(array('belongsTo' => array(
				'Radiology' =>array('foreignKey'=>false, 'conditions' => array('RadiologyTestOrder.radiology_id=Radiology.id')),
		)),false);
			
		$rad_data= $this->RadiologyTestOrder->find('all',array('conditions'=>array('RadiologyTestOrder.patient_id'=>$patient_id,'RadiologyTestOrder.is_deleted'=>'0'),'group'=>'Radiology.name'));
		$this->set('rad_data',$rad_data);
			
		$this->set('patient_id',$patient_id);
		$this->set('notesId',$notes_id);
			
		/// for vitals
		/*	$this->Patient->unBindModel(array(
		 'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'BmiResult' =>array('foreignKey' => false,'conditions'=>array('Patient.id=BmiResult.patient_id' )),
						'BmiBpResult' =>array('foreignKey' => false,'conditions'=>array('BmiResult.id =BmiBpResult.bmi_result_id' ),'order'=>array('BmiBpResult.id DESC')),
				)));
		$admissionDateAndVitals = $this->Patient->find('all',array('fields'=>array('Patient.form_received_on','BmiResult.temperature','BmiResult.myoption',
				'BmiResult.equal_value','BmiResult.temperature','BmiResult.respiration','BmiResult.date',
				'BmiBpResult.pulse_text','BmiBpResult.systolic','BmiBpResult.diastolic',
				'BmiResult.chief_complaint','BmiResult.pain','BmiResult.location','BmiResult.duration','BmiResult.frequency','BmiResult.spo'
				,'BmiResult.sposelect'),
				'conditions'=>array('Patient.id'=>$patient_id),'limit'=>'1'));
		$assessmentVitals = array('temp'=>$admissionDateAndVitals['0']['BmiResult']['temperature'],'rr'=>$admissionDateAndVitals['0']['BmiResult']['respiration'],
		'pr'=>$admissionDateAndVitals['0']['BmiBpResult']['pulse_text'],'bp'=>$admissionDateAndVitals['0']['BmiBpResult']['systolic']."/".$admissionDateAndVitals['0']['BmiBpResult']['diastolic'],
		//'cc'=>$admissionDateAndVitals['0']['BmiResult']['chief_complaint'],
		'note_date'=>$admissionDateAndVitals['0']['BmiResult']['date'],
		'spo2'=>$admissionDateAndVitals['0']['BmiResult']['spo'],
		'location'=>$admissionDateAndVitals['0']['BmiResult']['location'],
		'duration'=>$admissionDateAndVitals['0']['BmiResult']['duration'],
		'pain'=>$admissionDateAndVitals['0']['BmiResult']['pain'],
		'frequency'=>$admissionDateAndVitals['0']['BmiResult']['frequency'],
		'spo'=>$admissionDateAndVitals['0']['BmiResult']['sposelect'],
		'pulse_text'=>$admissionDateAndVitals['0']['BmiBpResult']['pulse_text']


		);
		$this->set('noteVitals',$admissionDateAndVitals);
		*/
		$this->BmiResult->bindModel(array(
		'belongsTo' => array('BmiBpResult'=>array('conditions'=>array('BmiBpResult.bmi_result_id=BmiResult.id'),'foreignKey'=>false)
		)));
		$admissionDateAndVitals = $this->BmiResult->find('first',array('fields'=>array('temperature','temperature1','temperature2','myoption','myoption1','myoption2','respiration','respiration_volume','BmiBpResult.systolic','BmiBpResult.systolic1',
				'BmiBpResult.systolic2','BmiBpResult.diastolic','BmiBpResult.diastolic1','BmiBpResult.diastolic2','BmiBpResult.pulse_text','BmiBpResult.pulse_text1','BmiBpResult.pulse_text2',
				'BmiBpResult.pulse_volume','BmiBpResult.pulse_volume1','BmiBpResult.pulse_volume2'),
				'conditions'=>array('patient_id'=>$patient_id,'appointment_id'=>$_SESSION['apptDoc'])));
		$this->set('noteVitals',$admissionDateAndVitals);
		
		/* $this->render('power_note_new');
		 exit; */
		/** **/

			
		function refillrx($id)//for eprescribing
		{
			$patient_xml=$this->generateXML_refillrx($id);
			$this->set('patient_xml', $patient_xml);
			$this->layout = false ;

		}

		function generateXML_refillrx($id=null)
		{

			$this->uses = array('Patient','Person','Location','City','State','Country','User','DoctorProfile','NewCropPrescription');

			$this->Patient->unBindModel(array(
					'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));

			$UIDpatient_details  = $this->Person->getUIDPatientDetailsByPatientID($id);

			$LicensedPrescriberName=$this->DoctorProfile->getDoctorByID($UIDpatient_details['Patient']['doctor_id']);


			//$LicensedPrescriberName=explode(" ",$LicensedPrescriberName[0][fullname]);

			$gender=$UIDpatient_details['Person']['sex'];
			if($gender=='Male' or $gender=='M')
				$gendervalue="M";
			else
				$gendervalue="F";


			$dob=str_replace("-", "", $UIDpatient_details['Person']['dob']);

			//find facility id
			$this->loadModel("Facility");
			$this->Facility->unBindModel(array(
					'hasOne'=>array('FacilityDatabaseMapping','FacilityUserMapping')
			));
			$facility = $this->Facility->find('first', array('fields'=> array('Facility.id','Facility.name','Facility.alias','Facility.address1','Facility.address2','Facility.zipcode','Facility.phone1','Facility.phone2','Facility.fax','Facility.city_id','Facility.state_id','Facility.country_id'),'conditions'=>array('Facility.is_deleted' => 0, 'Facility.is_active' => 1,'Facility.id' => $this->Session->read("facilityid"))));

			//find hospital location
			$hospital_location = $this->Location->find('all', array('fields'=> array('Location.id', 'Location.name','Location.address1','Location.address2','Location.zipcode','Location.city_id','Location.state_id','Location.country_id','Location.phone1','Location.mobile','Location.fax'),'conditions'=>array('Location.id'=>$this->Session->read('locationid'), 'Location.is_active' => 1, 'Location.is_deleted' => 0)));

			//find city and state and country

			$city_location = $this->City->find('all', array('fields'=> array('City.name'),'conditions'=>array('City.id'=>$hospital_location['0']['Location']['city_id'])));
			$state_location = $this->State->find('all', array('fields'=> array('State.name'),'conditions'=>array('State.id'=>$hospital_location['0']['Location']['state_id'])));

			$state_location_prescriber = $this->State->find('all', array('fields'=> array('State.state_code'),'conditions'=>array('State.id'=>$LicensedPrescriberName[User][state_id])));

			$city_location_prescriber = $this->City->find('all', array('fields'=> array('City.name'),'conditions'=>array('City.id'=>$LicensedPrescriberName[User][city_id])));


			$country_location = $this->Country->find('all', array('fields'=> array('Country.name'),'conditions'=>array('Country.id'=>$hospital_location['0']['Location']['country_id'])));


			//find patient state code

			$state_location_patient = $this->State->find('all', array('fields'=> array('State.state_code'),'conditions'=>array('State.id'=>$UIDpatient_details['Person']['state'])));
			//find treating consultant
			if($_SESSION['role']=="Nurse"){ //for nurse
				$strxml='<?xml version="1.0" encoding="utf-8"?>';

				$strxml.='<NCScript xmlns="http://secure.newcropaccounts.com/interfaceV7" xmlns:NCStandard="http://secure.newcropaccounts.com/interfaceV7:NCStandard" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">';
				//Account Credentials
				$strxml.='<Credentials>
						<partnerName>'.Configure::read('partnername').'</partnerName>
								<name>'.Configure::read('uname').'</name>
										<password>'.Configure::read('passw').'</password>
												<productName>SuperDuperSoftware</productName>
												<productVersion>V5.3</productVersion>
												</Credentials>';

				//User type
				$strxml.='<UserRole>
						<user>Staff</user>
						<role>nurse</role>
						</UserRole>';

				//Newcrop page name
				$strxml.='<Destination>
						<requestedPage>compose</requestedPage>
						</Destination>';
				//Account id can hospital id and location
				$strxml.='<Account ID="'.$facility['Facility']['name'].'">
						<accountName>'.$facility['Facility']['alias'].'</accountName>
								<siteID>'.$facility['Facility']['id'].'</siteID>
										<AccountAddress>
										<address1>'.$facility['Facility']['address1'].'</address1>
												<address2>'.$facility['Facility']['address2'].'</address2>
														<city>'.$facility['City']['name'].'</city>
																<state>'.$facility['State']['state_code'].'</state>
																		<zip>'.$facility['Facility']['zipcode'].'</zip>
																				<country>US</country>
																				</AccountAddress>
																				<accountPrimaryPhoneNumber>'.$facility['Facility']['phone1'].'</accountPrimaryPhoneNumber>
																						<accountPrimaryFaxNumber>'.$facility['Facility']['fax'].'</accountPrimaryFaxNumber>
																								</Account>';

				//Diffrent hospital location
				$strxml.='<Location ID="'.$hospital_location['0']['Location']['id'].'">
						<locationName>'.$hospital_location['0']['Location']['name'].'</locationName>
								<LocationAddress>
								<address1>'.$LicensedPrescriberName['User']['address1'].'</address1>
										<address2>'.$LicensedPrescriberName['User']['address2'].'</address2>
												<city>'.$city_location_prescriber['0']['City']['name'].'</city>
														<state>'.$state_location_prescriber['0']['State']['state_code'].'</state>
																<zip>'.$LicensedPrescriberName['User']['zipcode'].'</zip>
																		<country>US</country>
																		</LocationAddress>
																		<primaryPhoneNumber>'.Configure::read('primaryPhoneNumber').'</primaryPhoneNumber>
																				<primaryFaxNumber>'.Configure::read('primaryFaxNumber').'</primaryFaxNumber>
																						<pharmacyContactNumber>'.Configure::read('primaryPhoneNumber').'</pharmacyContactNumber>
																								</Location>';
				$strxml.='<Staff ID="'.$_SESSION['userid'].'">
						<StaffName>
						<last>'.$_SESSION[last_name].'</last>
								<first>'.$_SESSION[first_name].'</first>

										<prefix>'.$_SESSION[initial_name].'</prefix>

												</StaffName>
												</Staff>';




				//patient information
				$strxml.='<Patient ID="'.$UIDpatient_details['Patient']['id'].'">
						<PatientName>
						<last>'.trim($UIDpatient_details['Person']['last_name']).'</last>
								<first>'.trim($UIDpatient_details['Person']['first_name']).'</first>
										<middle>'.trim($UIDpatient_details['Person']['middle_name']).'</middle>
												</PatientName>
												<medicalRecordNumber>'.$UIDpatient_details['Patient']['id'].'</medicalRecordNumber>
														<memo></memo>
														<PatientAddress>
														<address1>'.$UIDpatient_details['Person']['plot_no'].'</address1>
																<address2>'.$UIDpatient_details['Person']['landmark'].'</address2>
																		<city>'.$UIDpatient_details['Person']['city'].'</city>
																				<state>'.$state_location_patient['0']['State']['state_code'].'</state>
																						<zip>'.$UIDpatient_details['Person']['pin_code'].'</zip>
																								<country>US</country>
																								</PatientAddress>
																								<PatientContact>
																								<homeTelephone>'.$UIDpatient_details['Person']['home_phone'].'</homeTelephone>
																										</PatientContact>
																										<PatientCharacteristics>
																										<dob>'.$dob.'</dob>
																												<gender>'.$gendervalue.'</gender>
																														</PatientCharacteristics>';

				$strxml.='<PatientHealthplans>
						<healthplanID>12</healthplanID>
						<healthplanTypeID>Summary</healthplanTypeID>
						<group>Group</group>
						</PatientHealthplans>';




				$strxml.= '</Patient>';



				$strxml.='</NCScript>';

				//create xml file here
				$ourFileName = "uploads/patient_xml/".$UIDpatient_details['Person']['first_name']."_".$UIDpatient_details['Person']['last_name']."_".$UIDpatient_details['Patient']['id'].".xml";
				//	$ourFileHandle = fopen($ourFileName, 'w') or die("can't open file");
				$ourFileHandle = fopen($ourFileName, 'w')  ;
				fwrite($ourFileHandle, $strxml);
				fclose($ourFileHandle);
				return $strxml;
			}
			else if($_SESSION['role']=="Admin" or $_SESSION['role']=="Primary Care Provider"){
				$strxml='<?xml version="1.0" encoding="utf-8"?>';

				$strxml.='<NCScript xmlns="http://secure.newcropaccounts.com/interfaceV7" xmlns:NCStandard="http://secure.newcropaccounts.com/interfaceV7:NCStandard" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">';
				//Account Credentials
				$strxml.='<Credentials>
						<partnerName>'.Configure::read('partnername').'</partnerName>
								<name>'.Configure::read('uname').'</name>
										<password>'.Configure::read('passw').'</password>
												<productName>SuperDuperSoftware</productName>
												<productVersion>V5.3</productVersion>
												</Credentials>';

				//User type
				$strxml.='<UserRole>
						<user>LicensedPrescriber</user>
						<role>doctor</role>
						</UserRole>';

				//Newcrop page name
				$strxml.='<Destination>
						<requestedPage>renewal</requestedPage>
						</Destination>';
				//Account id can hospital id and location
				$strxml.='<Account ID="'.$facility['Facility']['name'].'">
						<accountName>'.$facility['Facility']['alias'].'</accountName>
								<siteID>'.$facility['Facility']['id'].'</siteID>
										<AccountAddress>
										<address1>'.$facility['Facility']['address1'].'</address1>
												<address2>'.$facility['Facility']['address2'].'</address2>
														<city>'.$facility['City']['name'].'</city>
																<state>'.$facility['State']['state_code'].'</state>
																		<zip>'.$facility['Facility']['zipcode'].'</zip>
																				<country>US</country>
																				</AccountAddress>
																				<accountPrimaryPhoneNumber>'.$facility['Facility']['phone1'].'</accountPrimaryPhoneNumber>
																						<accountPrimaryFaxNumber>'.$facility['Facility']['fax'].'</accountPrimaryFaxNumber>
																								</Account>';

				//Diffrent hospital location
				$strxml.='<Location ID="'.$hospital_location['0']['Location']['id'].'">
						<locationName>'.$hospital_location['0']['Location']['name'].'</locationName>
								<LocationAddress>
								<address1>'.$LicensedPrescriberName[User][address1].'</address1>
										<address2>'.$LicensedPrescriberName[User][address2].'</address2>
												<city>'.$city_location_prescriber['0']['City']['name'].'</city>
														<state>'.$state_location_prescriber[0][State][state_code].'</state>
																<zip>'.$LicensedPrescriberName[User][zipcode].'</zip>
																		<country>US</country>
																		</LocationAddress>
																		<primaryPhoneNumber>'.Configure::read('primaryPhoneNumber').'</primaryPhoneNumber>
																				<primaryFaxNumber>'.Configure::read('primaryFaxNumber').'</primaryFaxNumber>
																						<pharmacyContactNumber>'.Configure::read('primaryPhoneNumber').'</pharmacyContactNumber>
																								</Location>';

				//Prescribing doctor information
				$strxml.='<LicensedPrescriber ID="'.$LicensedPrescriberName[User][id].'">
						<LicensedPrescriberName>
						<last>'.$LicensedPrescriberName[DoctorProfile][last_name].'</last>
								<first>'.$LicensedPrescriberName[DoctorProfile][first_name].'</first>
										<middle>'.$LicensedPrescriberName[DoctorProfile][middle_name].'</middle>
												</LicensedPrescriberName>';
				// Staff



				$strxml.='<dea>'.$LicensedPrescriberName[User][dea].'</dea>';
				$strxml.='<upin></upin>';
				$strxml.='<licenseState>'.$state_location_prescriber[0][State][state_code].'</licenseState>';
				$strxml.='<licenseNumber>'.$LicensedPrescriberName[User][licensure_no].'</licenseNumber>';
				$strxml.='<npi>'.$LicensedPrescriberName[User][npi].'</npi>';
				$strxml.='</LicensedPrescriber>';
				/*$strxml.='<Staff ID="DEMOST1"><StaffName>
				 <last>Jackson</last><first>Nurse</first>
				<middle>J</middle><prefix>Mr.</prefix><suffix>Jr</suffix>
				</StaffName><license>StLic1234</license></Staff>';*/

				//patient information
				$strxml.='<Patient ID="'.$UIDpatient_details['Patient']['id'].'">
						<PatientName>
						<last>'.trim($UIDpatient_details['Person']['last_name']).'</last>
								<first>'.trim($UIDpatient_details['Person']['first_name']).'</first>
										<middle>'.trim($UIDpatient_details['Person']['middle_name']).'</middle>
												</PatientName>
												<medicalRecordNumber>'.$UIDpatient_details['Patient']['id'].'</medicalRecordNumber>
														<memo></memo>
														<PatientAddress>
														<address1>'.$UIDpatient_details['Person']['plot_no'].'</address1>
																<address2>'.$UIDpatient_details['Person']['landmark'].'</address2>
																		<city>'.$UIDpatient_details['Person']['city'].'</city>
																				<state>'.$state_location_patient['0']['State']['state_code'].'</state>
																						<zip>'.$UIDpatient_details['Person']['pin_code'].'</zip>
																								<country>US</country>
																								</PatientAddress>
																								<PatientContact>
																								<homeTelephone>'.$UIDpatient_details['Person']['home_phone'].'</homeTelephone>
																										</PatientContact>
																										<PatientCharacteristics>
																										<dob>'.$dob.'</dob>
																												<gender>'.$gendervalue.'</gender>
																														</PatientCharacteristics>';

				$strxml.='<PatientHealthplans>
						<healthplanID>12</healthplanID>
						<healthplanTypeID>Summary</healthplanTypeID>
						<group>Group</group>
						</PatientHealthplans>';
				/*$strxml.='<PatientFreeformHealthplans>

				<healthplanName>BCBS/TEXAS (HCSC)</healthplanName>
				</PatientFreeformHealthplans>';

				<healthplanName>BCBS/TEXAS (HCSC)</healthplanName>
				</PatientFreeformHealthplans>';*/





				$strxml.= '</Patient>';
					
				$strxml.='<PrescriptionRenewalResponse>
						<!-- The renewal request identifier comes from web method GetAllRenewalRequests in Update1 web services-->
						<renewalRequestIdentifier>cbf51649-ce3c-44b8-8f91-6fda121a353d</renewalRequestIdentifier>
						<responseCode>Undetermined</responseCode>
						</PrescriptionRenewalResponse>
						<OutsidePrescription ID="390593d3-7157-494e-8acf-95830e0aa209">
						<externalId>8EC90F03-29EF-4F54-A09D-14223C8BCD92</externalId>
						<date>20080507</date>
						<dispenseNumber>30</dispenseNumber>
						<sig>1 Oral, QD (Daily)</sig>
						<refillCount>1</refillCount>
						<substitution>SubstitutionAllowed</substitution>
						<!--Accupril 10mg-->
						<drugIdentifier>247110</drugIdentifier>
						<drugIdentifierType>FDB</drugIdentifierType>
						<prescriptionType>Reconcile</prescriptionType>
						</OutsidePrescription>
						';

				//find current prescription

				/*$allMedications=$this->NewCropPrescription->find('all',array('fields'=>array('id','description','date_of_prescription','rxnorm','archive','route',
				 'frequency','dose','firstdose','prn','stopdose','patient_uniqueid','drug_id','refills','prn','daw','strength','PrescriptionGuid'),'conditions'=>array('patient_uniqueid'=>$id,'archive'=>'N')));

				for($i=0;$i<count($allMedications);$i++){

				//$patientPrescribedData=$this->NewCropPrescription->find('first',array('fields'=>array('id','description','drug_name','date_of_prescription','rxnorm','archive','route',
						//	'frequency','dose','firstdose','prn','stopdose','patient_uniqueid','drug_id'),'conditions'=>array('patient_uniqueid'=>$patientId,'drug_id'=>$presc_data[$i])));


				$externalId=date("Ymd").time().$allMedications[$i]["NewCropPrescription"]["drug_id"].$i.$id.$allMedications[$i]["NewCropPrescription"]["id"];
				$datepresc=str_replace("T"," ",$allMedications[$i]["NewCropPrescription"]["date_of_prescription"]);
				$dateprescFinal=explode(" ",$datepresc);
				$doctorFullName=$LicensedPrescriberName[DoctorProfile][first_name]." ".$LicensedPrescriberName[DoctorProfile][last_name];
				$sig=$allMedications[$i]["NewCropPrescription"]["drug_name"]." ".$allMedications[$i]["NewCropPrescription"]["frequency"]." ".$allMedications[$i]["NewCropPrescription"]["route"];

				if($allMedications[$i]["NewCropPrescription"]["prn"]=='1')
					$prn="Yes";
				else
					$prn="No";

				if($allMedications[$i]["NewCropPrescription"]["daw"]=='1')
					$daw="DispenseAsWritten";
				else
					$daw="SubstitutionAllowed";

				$prescriptionGuid=$allMedications[$i]["NewCropPrescription"]["PrescriptionGuid"];
				$strxml.='<OutsidePrescription ID="prescriptionGuid"><externalId>'.$externalId.'</externalId><date>'.str_replace("-","",$dateprescFinal[0]).'</date><doctorName>'.$doctorFullName.'</doctorName><drug>'.$allMedications[$i]["NewCropPrescription"]["drug_name"].'</drug><dispenseNumber></dispenseNumber><sig>'.$sig.'</sig><refillCount>'.$allMedications[$i]["NewCropPrescription"]["refills"].'</refillCount><substitution>'.$daw.'</substitution><drugIdentifier>'.$allMedications[$i]["NewCropPrescription"]["drug_id"].'</drugIdentifier><drugIdentifierType>FDB</drugIdentifierType><prescriptionType>reconcile</prescriptionType><prn>'.$prn.'</prn></OutsidePrescription>';

				}*/

				$strxml.='</NCScript>';

				//create xml file here
				$ourFileName = "uploads/patient_xml/".$UIDpatient_details['Person']['first_name']."_".$UIDpatient_details['Person']['last_name']."_".$UIDpatient_details['Patient']['id'].".xml";
				//	$ourFileHandle = fopen($ourFileName, 'w') or die("can't open file");
				$ourFileHandle = fopen($ourFileName, 'w')  ;
				fwrite($ourFileHandle, $strxml);
				fclose($ourFileHandle);
				return $strxml;
			}



		}
	}
	//=====================EOF============================================
	public function addBlankNote($patientId){
		$this->uses=array('Note');

		$this->Note->save(array('patient_id'=>$patientId));
		$noteId=$this->Note->getLastInsertID();
		return $noteId;

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
				$newcrop_rxcui= $xmldata->Table->rxcui;;
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
				$xmlArray[$i]['strength']=$xmlDataValue['DosageFormTypeId'];

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


	public function addAttestationData($patient_id=null,$noteId=null){
		$this->uses=array('Note');
		if(!empty($this->request->data)){
			$attestation_details=serialize($this->request->data['Note']);
			$this->Note->updateAll( array('Note.attestation_details'=>"'".$attestation_details."'"),array('Note.id'=>$noteId));
		}
		exit;
	}

	



}
