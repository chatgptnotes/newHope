<?php
/**
 * DiagnosisController file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Diagnosis Controller
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

class DiagnosesController extends AppController {

	public $name = 'Diagnoses';
	public $uses = array('Diagnosis');
	public $helpers = array('Html','Form', 'Js','DateFormat','RupeesToWords','Number','General');
	public $components = array('RequestHandler','Email', 'Session','DateFormat');



	public function index($patient_id=null){

		$this->uses = array('Diagnosis');
		$diagnosisRec = $this->Diagnosis->find('first',array('fields'=>array('id','patient_id','diagnosis'),'conditions'=>array('patient_id'=>$patient_id)));
		$this->set(array('diagnosis'=>$diagnosisRec,'patient_id'=>$patient_id));

	}

	public function add($patient_id=null,$allergyid=null,$allergytype=null,$case=false){
		//debug($this->request->data);exit;
		//ob_end_clean();
		//if(ob_start("ob_gzhandler"));
		
		$this->set('title_for_layout', __('-Patient Diagnosis', true));
		//load model
		$this->uses = array('OtherTreatment','Person','Diagnosis','Configuration','DiagnosisDrug','PastMedicalRecord','PatientPastHistory','PatientPersonalHistory','PatientFamilyHistory','PatientAllergy','Doctor',
				'NewCropPrescription','PregnancyCount','PastMedicalHistory','ProcedureHistory','BmiResult','BmiBpResult','FamilyHistory','SmokingStatusOncs','PatientSmoking');

	
		
		$this->patient_info($patient_id);
		$getEthnicityData=$this->patient_details['Person']['ethnicity'];
		$getmaritailStatusData=$this->patient_details['Person']['maritail_status'];
		$this->set(compact('getEthnicityData','getmaritailStatusData'));
		
		
		//set return page url in session
		//--- New Medication Unit DOSE AND STRENGHT ADD DO NOT REMOVE
		/* debug('route_administration');
		debug(serialize(Configure::read('route_administration')));
		debug('strength');
		debug(serialize(Configure::read('strength')));
		debug('dose_type'); */
		
		if($allergyid=='sbar'){
			$this->set('flag',$allergyid);
		}
		$getConfiguration=$this->Configuration->find('all'); 
		$strenght=unserialize($getConfiguration[0]['Configuration']['value']);
		$dose=unserialize($getConfiguration[1]['Configuration']['value']);
		$route=unserialize($getConfiguration[2]['Configuration']['value']);
		//$str1='<select style="width:80px;" id="dose_type'+counter+'" class="" name="dose_type[]">';
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
		//$this->set('strenght',unserialize($getConfiguration[0]['Configuration']['value']));
		foreach(unserialize($getConfiguration[0]['Configuration']['value']) as $key=>$strenght){
			if(!empty($strenght))
				$strenght_var[$strenght]=$strenght;
		}
		$this->set('strenght',$strenght_var);
		//$this->set('dose',unserialize($getConfiguration[1]['Configuration']['value']));
		foreach(unserialize($getConfiguration[1]['Configuration']['value']) as $key=>$doses){
			if(!empty($doses))
				$dose_var[$doses]=$doses;
		}
		$this->set('dose',$dose_var);
		//$this->set('route',unserialize($getConfiguration[2]['Configuration']['value']));
		foreach(unserialize($getConfiguration[2]['Configuration']['value']) as $key=>$route){
			if(!empty($route))
				$route_var[$route]=$route;
		}
		$this->set('route',$route_var);
		//==========================================================
		//added by pankaj m
		$currentresult = $this->NewCropPrescription->find('all',array('conditions'=>array('patient_uniqueid'=>$patient_id,'archive !='=>'C'))); //find prescription
		
		$this->set('currentresult',$currentresult);
	
		//BOF pankaj
		//If there is previous encounter in our database
		if(empty($this->request->data['Diagnosis']['patient_id'])){
			$this->set('patient_id',$patient_id); // set before change patient id
			$prevID = $this->Diagnosis->getPrevEncounterID($patient_id,$this->patient_details['Patient']['person_id']);
			 
			if(!empty($prevID)) $patient_id = $prevID ;
		}
		//EOF pankaj 
		 
		//BOF referer link
		$sessionReturnString = $this->Session->read('returnPage') ;
		$currentReturnString = $this->params->query['return'] ;
		if(($currentReturnString!='') && ($currentReturnString != $sessionReturnString) ){
			$this->Session->write('returnPage',$currentReturnString);
		}else if($currentReturnString ==''){
			$this->Session->delete('returnPage');
		}
		//EOF referer link
		if(isset($this->request->data) && !empty($this->request->data)){ 
			
			//---------ProcedureHistory
			if(!empty($this->request->data['ProcedureHistory'])){ 
				$procedureHistory = $this->Diagnosis->insertProcedureHistory($this->request->data['ProcedureHistory'],$patient_id);
			}   
			
			//--------current treatment
			if(!empty($this->request->data['NewCropPrescription']) && isset($this->request->data)){
				
				 $this->Diagnosis->insertCurrentTreatment($this->request->data['NewCropPrescription'],$patient_id);
			}
			//$this->NewCropPrescription->insertMedication_order($this->request->data['NewCropPrescription']);
			
			//convert date to DB format
			if(!empty($this->request->data["Diagnosis"]['next_visit'])){
				$this->request->data["Diagnosis"]['next_visit'] = $this->DateFormat->formatDate2STD($this->request->data["Diagnosis"]['next_visit'],Configure::read('date_format'));
			}
			 
			//-------------------
			$this->request->data['PersonalHealth']['disability'] =$this->request->data['Diagnosis']['disability'];
			$this->request->data['PersonalHealth']['effective_date'] =$this->request->data['Diagnosis']['effective_date'];
			$this->request->data['PersonalHealth']['status_option'] =$this->request->data['Diagnosis']['status_option'];


			$impldata = $this->request->data['PersonalHealth'];
			foreach($impldata as $key => $impldata){
				if(substr($key, 0, 10) == 'disability'){
					$disable[] = $impldata;
				}
				if(substr($key, 0, 14) == 'effective_date'){
					$effec_date[] = $impldata;
				}
				if(substr($key, 0, 13) == 'status_option'){
					$stat_opt[] = $impldata;
				}
					
			}
			$disable = implode('|',$disable);
			$effec_date = implode('|',$effec_date);
			$stat_opt = implode('|',$stat_opt);

			$this->request->data['Diagnosis']['disability']=$disable;
			$this->request->data['Diagnosis']['effective_date']=$effec_date;
			$this->request->data['Diagnosis']['status_option']=$stat_opt;

			//---------------
			//insert diagnosis record for a patient
			$diagnosisId = $this->Diagnosis->insertDiagnosis($this->request->data);
			if($diagnosisId){
				//After saving initial assesment change status in appoinment table
				if(!empty($this->request->data['Diagnosis']['appointmentId'])){
				$this->loadModel('Appointment');
				$updateArray = array('Appointment.status'=>"'In-Progress'") ;
				$this->Appointment->updateAll($updateArray,array('Appointment.id '=>$this->request->data['Diagnosis']['appointmentId']));
				}
				
			}
			//**************BOF-OtherTreatment-Mahalaxmi**********************//
			if(!empty($this->request->data['OtherTreatment'])){				
					$this->OtherTreatment->insertOtherTreatment($this->request->data,$patient_id);
			}
			
			//**************EOF-OtherTreatment-Mahalaxmi**********************//
			//---------yash
			//-------vitals---
			//hasMany insert
			$this->BmiResult->bindModel(array(
					'hasMany' => array(
							'BmiBpResult' =>array( 'foreignKey'=>'bmi_result_id')
					)));
			if ($this->request->data['BmiResult'])
			{
				$this->request->data['BmiResult']['patient_id']=$patient_id;
				$this->request->data['BmiResult']['location_id']=$this->Session->read('locationid');
				$this->request->data['BmiResult']['date']=$this->DateFormat->formatDate2STD($this->request->data['Diagnosis']['capture_date'],Configure::read('date_format'));
				if($this->request->data['BmiResult']['id'] != ''){ 
					//delete previous record
					$this->BmiBpResult->deleteAll(array('bmi_result_id'=>$this->request->data['BmiResult']['id'])); //delete all
					$this->request->data['BmiResult']['modified_by']=$this->Session->read('userid');
					$this->request->data['BmiResult']['modified_time']=date("Y-m-d H:i:s");
					$this->BmiResult->save($this->request->data['BmiResult']);
					$bmiBpResult = $this->request->data['BmiBpResult'] ;
					foreach($bmiBpResult as $key=>$value){
						$value['bmi_result_id']=$this->request->data['BmiResult']['id'] ;
						$this->BmiBpResult->saveAll($value);
						$this->BmiBpResult->id='';
					}
					 
				} else {  
					$this->request->data['BmiResult']['patient_id']=$patient_id;
					$this->request->data['BmiResult']['created_by']=$this->Session->read('userid');
					$this->request->data['BmiResult']['created_time']=date("Y-m-d H:i:s");
					$this->request->data['BmiResult']['location_id']=$this->Session->read('locationid');
					$this->request->data['BmiResult']['date']=$this->DateFormat->formatDate2STD($this->request->data['Diagnosis']['capture_date'],Configure::read('date_format'));
					$this->BmiResult->saveAll($this->request->data);
 
				}
			} 
			
			//---pregnancy count--
			if(!empty($this->request->data['pregnancy'])){ 
				$pregnency_count = $this->Diagnosis->insertPregnancyCount($this->request->data['pregnancy'],$patient_id);
			}
			
			//--------
			//---past medical history
			//--------
			
			if(!empty($this->request->data['PastMedicalHistory'])){
				$past_history = $this->Diagnosis->insertPastMedicalHistory($this->request->data['PastMedicalHistory'],$patient_id);
			}
			//--------
			
			//BOF history
			$this->request->data['PatientPastHistory']['diagnosis_id'] = $diagnosisId;
			$this->PatientPastHistory->save($this->request->data['PatientPastHistory']);
			$this->request->data['PatientPersonalHistory']['diagnosis_id'] = $diagnosisId;
			$this->request->data['PatientPersonalHistory']['capture_date'] =$this->DateFormat->formatDate2STD($this->request->data['Diagnosis']['capture_date'],Configure::read('date_format'));
			$this->request->data['PatientSmoking']['diagnosis_id'] = $diagnosisId;
			if(!empty($this->request->data["PatientSmoking"]['pre_from'])){
				$this->request->data["PatientSmoking"]['pre_from'] = $this->DateFormat->formatDate2STD($this->request->data["PatientSmoking"]['pre_from'],Configure::read('date_format'));
				//calculate age on the basis of entered DOB
				//$this->request->data["Person"]['age'] = $this->DateFormat->getAge($this->request->data["Person"]['dob']) ;
					
			}
			if(!empty($this->request->data["PatientSmoking"]['pre_to'])){
				$this->request->data["PatientSmoking"]['pre_to'] = $this->DateFormat->formatDate2STD($this->request->data["PatientSmoking"]['pre_to'],Configure::read('date_format'));
				//calculate age on the basis of entered DOB
				//$this->request->data["Person"]['age'] = $this->DateFormat->getAge($this->request->data["Person"]['dob']) ;
					
			}
			$date = date('Y-m-d h:i:s', time());
			if($this->request->data['PatientSmoking']['current_smoking_fre']==''){
				$this->request->data['PatientSmoking']['current_smoking_fre'] = $this->request->data['PatientSmoking']['smoking_fre2'];
				$this->request->data["PatientSmoking"]['created_date'] = $date; 
				//$this->request->data['PatientSmoking']['current_smoking_fre'] = $this->request->data['PatientSmoking']['current_smoking_fre'];
				// unset($this->request->data['PatientPersonalHistory']['smoking_fre1']);

			}
			else{
				if($this->request->data['PatientSmoking']['smoking_fre2']!=''){
					$this->request->data['PatientSmoking']['smoking_fre'] = $this->request->data['PatientSmoking']['current_smoking_fre'];
					//$this->request->data['PatientSmoking']['current_smoking_fre'] = $this->request->data['SmokingStatusOncs.description'];
					$this->request->data['PatientSmoking']['current_smoking_fre'] = $this->request->data['PatientSmoking']['smoking_fre2'];
					$this->request->data["PatientSmoking"]['created_date'] = $date;
					$this->request->data['PatientSmoking']['current_from'] = $this->request->data['PatientSmoking']['pre_from1'];
					$this->request->data['PatientSmoking']['current_to'] = $this->request->data['PatientSmoking']['pre_to1'];
				}
				else{
					$this->request->data['PatientSmoking']['smoking_fre'] = $this->request->data['PatientSmoking']['smoking_fre'];
					//$this->request->data['PatientSmoking']['current_smoking_fre'] = $this->request->data['SmokingStatusOncs.description'];
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
			
			$this->request->data['PatientFamilyHistory']['diagnosis_id'] = $diagnosisId;
			//$this->PatientFamilyHistory->save($this->request->data['PatientFamilyHistory']);
			/* $this->request->data['PatientAllergy']['diagnosis_id'] = $diagnosisId;
			if($this->request->data['PatientAllergy']['allergies']==0){
				//unset previously added reaction if any
				$this->request->data['PatientAllergy']['from1'] ='';
				$this->request->data['PatientAllergy']['reaction1'] ='' ;
				$this->request->data['PatientAllergy']['from2'] ='';
				$this->request->data['PatientAllergy']['reaction2'] ='';
				$this->request->data['PatientAllergy']['from3'] ='';
				$this->request->data['PatientAllergy']['reaction3'] ='' ;
			} */
			//$this->PatientAllergy->save($this->request->data['PatientAllergy']);
			//$this->FamilyHistory->save($this->request->data['FamilyHistory']);
			
			if($this->request->data['Diagnosis']['id']) {
				$msg='Record Updated Successfully.';
				
			}else{
				$msg='Record Added Successfully.';
			}
			
			if($this->request->data['Diagnosis']['flag']=='sbar'){
				$this->redirect("/PatientsTrackReports/sbar/".$patient_id);
			}else{
				$this->Session->setFlash(__($msg, true));
				$this->redirect(array('controller'=>'appointments','action'=>'appointments_management'));
				//$this->redirect($this->referer());
			}
			

		}else if(empty($patient_id)){
			$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
			$this->redirect($this->referer()); 
		}
		
		$getpatient=$this->PastMedicalRecord->find('all',array('conditions'=>array('patient_id'=>$patient_id)));		
		$getpatientfamilyhistory=$this->FamilyHistory->find('all',array('conditions'=>array('patient_id'=>$patient_id))); 
		$smokingOptions =$this->SmokingStatusOncs->find('list',array('fields'=>array('description')));
				
		$this->set(compact('smokingOptions'));
		$this->set('getpatient',$getpatient);
		$this->set('getpatientfamilyhistory',$getpatientfamilyhistory); 
		
		//check if patient record is exist
		$this->Diagnosis->bindModel( array(
				'belongsTo' => array( 
						/*'PatientAllergy'=>array('conditions'=>array('Diagnosis.id=PatientAllergy.diagnosis_id'),'foreignKey'=>false),*/
						'PatientPersonalHistory'=>array('conditions'=>array('Diagnosis.id=PatientPersonalHistory.diagnosis_id'),'foreignKey'=>false,'order'=>array('PatientSmoking.id DESC'),'limit'=>1),
						'PatientSmoking'=>array('conditions'=>array('Diagnosis.id=PatientSmoking.diagnosis_id'),'foreignKey'=>false),
						'PatientPastHistory'=>array('conditions'=>array('Diagnosis.id=PatientPastHistory.diagnosis_id'),'foreignKey'=>false),
						'FamilyHistory'=>array('conditions'=>array('Diagnosis.patient_id=FamilyHistory.patient_id'),'foreignKey'=>false),
						/*'PatientFamilyHistory'=>array('conditions'=>array('Diagnosis.id=PatientFamilyHistory.diagnosis_id'),'foreignKey'=>false),
						'SmokingStatusOncs'=>array('className'=>'SmokingStatusOncs','conditions'=>array('PatientSmoking.smoking_fre=SmokingStatusOncs.id'),'foreignKey'=>false),
						'SmokingStatusOncs1'=>array('className'=>'SmokingStatusOncs','conditions'=>array('PatientSmoking.current_smoking_fre=SmokingStatusOncs1.id'),'foreignKey'=>false)*/
				)
		));

	  	$diagnosisRec = $this->Diagnosis->find('first',array('conditions'=>array('Diagnosis.patient_id'=>$patient_id))); 	
 
	  	
		//past medical history
		$pastMedicalHistoryRec = $this->PastMedicalHistory->find('all',array('fields'=>array('PastMedicalHistory.illness,PastMedicalHistory.status,PastMedicalHistory.duration,
										PastMedicalHistory.comment'), 'conditions'=>array('patient_id'=>$patient_id),'order'=>array('PastMedicalHistory.id Asc')));
		$this->set('pastHistory',$pastMedicalHistoryRec);		 
	 	if($this->patient_details['Person']['sex']){
			$pregnancyCountRec = $this->PregnancyCount->find('all',array('fields'=>array('PregnancyCount.counts,PregnancyCount.date_birth,PregnancyCount.weight,PregnancyCount.baby_gender,
								PregnancyCount.week_pregnant,PregnancyCount.type_delivery,PregnancyCount.complication'), 'conditions'=>array('patient_id'=>$patient_id),'order'=>array('PregnancyCount.id Asc')));
			$this->set('pregnancyData',$pregnancyCountRec);
			
			
	 	}
		 
	 	///////////////BOF --------OtherTreatment-Mahalaxmi
	 	$getOtherTreatment=$this->OtherTreatment->find('all',array('conditions'=>array('patient_id'=>$patient_id)));
	 	$this->set(compact('getOtherTreatment'));
	 	///////////////EOF --------OtherTreatment-Mahalaxmi
		 
		//BOF --------ProcedureHistory
	 	$this->ProcedureHistory->bindModel( array(
				'belongsTo' => array(
						'DoctorProfile'=>array('foreignKey'=>false,'conditions'=>array('ProcedureHistory.provider=DoctorProfile.id')),
						'TariffList'=>array('foreignKey'=>false,'conditions'=>array('ProcedureHistory.procedure=TariffList.id')),
						)));
	 	
		$procedureHistoryRec = $this->ProcedureHistory->find('all',array('fields'=>array('TariffList.id','TariffList.name','DoctorProfile.id',
				'DoctorProfile.doctor_name','ProcedureHistory.procedure','ProcedureHistory.provider','ProcedureHistory.age_value','ProcedureHistory.age_unit',
				'ProcedureHistory.procedure_date','ProcedureHistory.comment','ProcedureHistory.procedure_name','ProcedureHistory.provider_name'),
				'conditions'=>array('ProcedureHistory.patient_id'=>$patient_id),'order'=>array('ProcedureHistory.id Asc')));	 
		$this->set('procedureHistory',$procedureHistoryRec);
	 	//EOF ProcedureHistory
		 
		$diagnosisDrugRec = $this->DiagnosisDrug->find('all',array('fields'=>array('DiagnosisDrug.mode,DiagnosisDrug.tabs_per_day,DiagnosisDrug.mode,DiagnosisDrug.quantity,
				DiagnosisDrug.tabs_frequency,DiagnosisDrug.first,DiagnosisDrug.second,DiagnosisDrug.third,DiagnosisDrug.forth,
				PharmacyItem.name,PharmacyItem.pack'),'conditions'=>array('diagnosis_id'=>$diagnosisRec['Diagnosis']['id']))); 
		 

		$count = count($diagnosisDrugRec);
		if($diagnosisRec){
			if($count){
				for($i=0;$i<$count;){
					$diagnosisRec['drug'][$i]  = $diagnosisDrugRec[$i]['PharmacyItem']['name'];
					$diagnosisRec['pack'][$i]  = $diagnosisDrugRec[$i]['PharmacyItem']['pack'];
					$diagnosisRec['mode'][$i]  = $diagnosisDrugRec[$i]['DiagnosisDrug']['mode'];
					$diagnosisRec['tabs_per_day'][$i]  = $diagnosisDrugRec[$i]['DiagnosisDrug']['tabs_per_day'];
					$diagnosisRec['tabs_frequency'][$i]  = $diagnosisDrugRec[$i]['DiagnosisDrug']['tabs_frequency'];
					$diagnosisRec['quantity'][$i]  = $diagnosisDrugRec[$i]['DiagnosisDrug']['quantity'];
					$diagnosisRec['first'][$i]  = $diagnosisDrugRec[$i]['DiagnosisDrug']['first'];
					$diagnosisRec['second'][$i]  = $diagnosisDrugRec[$i]['DiagnosisDrug']['second'];
					$diagnosisRec['third'][$i]  = $diagnosisDrugRec[$i]['DiagnosisDrug']['third'];
					$diagnosisRec['forth'][$i]  = $diagnosisDrugRec[$i]['DiagnosisDrug']['forth'];
					$i++;
				}
			}
			//convert date to local format
			if(!empty($diagnosisRec['Diagnosis']['next_visit'])){
				$diagnosisRec['Diagnosis']['next_visit'] = $this->DateFormat->formatDate2Local($diagnosisRec['Diagnosis']['next_visit'],Configure::read('date_format'));
			}
			if(!empty($diagnosisRec['Diagnosis']['register_on'])){
				$diagnosisRec['Diagnosis']['register_on'] = $this->DateFormat->formatDate2Local($diagnosisRec['Diagnosis']['register_on'],Configure::read('date_format'),true);
			}
			if(!empty($diagnosisRec['Diagnosis']['consultant_on'])){
				$diagnosisRec['Diagnosis']['consultant_on'] = $this->DateFormat->formatDate2Local($diagnosisRec['Diagnosis']['consultant_on'],Configure::read('date_format'),true);
			}
			//-----for ccda code------
			if(!empty($diagnosisRec['PatientSmoking']['from'])){
				$diagnosisRec['PatientSmoking']['from'] = $this->DateFormat->formatDate2Local($diagnosisRec['PatientSmoking']['from'],Configure::read('date_format'),true);
			}
			if(!empty($diagnosisRec['PatientSmoking']['to'])){
				$diagnosisRec['PatientSmoking']['to'] = $this->DateFormat->formatDate2Local($diagnosisRec['PatientSmoking']['to'],Configure::read('date_format'),true);
			}
			
			//-----eof ccda code---------

			$this->data = $diagnosisRec ;
		}
		 
		
		//BOF find vitals
		$this->BmiResult->bindModel(array(
				'hasMany' => array(
						'BmiBpResult' =>array( 'foreignKey'=>'bmi_result_id','order'=>'BmiBpResult.id ASC')
				)));
		$result1 = $this->BmiResult->find('first',array('conditions'=>array('patient_id'=>$patient_id))); //find vitals
		$this->set('result1',$result1);
		 
		
		
		//unset($this->request->data); //added by pankaj M since request->data was always coming when intial assesment page is refreshed after clicking on submit button
		//$this->data = $result1 ;
		//EOF find vitals
		//-----past medications-----yashwant
		$pastMedication = $this->NewCropPrescription->find('all',array('conditions'=>array('patient_uniqueid'=>$patient_id,'archive'=>'Y'))); //find past medication
		$this->set('pastMedication',$pastMedication);
}

	public function smoking_detail($patient_id=null){
		$this->set('title_for_layout', __('Smoking status details', true));
		$this->layout=false;
		$this->uses = array('PatientAllergy','PatientPersonalHistory','PatientSmoking','PatientPastHistory','PatientFamilyHistory','SmokingStatusOncs');
		$this->PatientSmoking->bindModel( array(
				'belongsTo' => array(
						'Patient'=>array('foreignKey'=>'patient_id'),
						'SmokingStatusOncs'=>array('className'=>'SmokingStatusOncs','conditions'=>array('SmokingStatusOncs.id=PatientSmoking.current_smoking_fre'),'foreignKey'=>false),
						'SmokingStatusOncs1'=>array('className'=>'SmokingStatusOncs','conditions'=>array('SmokingStatusOncs1.id=PatientSmoking.smoking_fre'),'foreignKey'=>false)

				)

		));
		//echo '<pre>';print_r($patient_id);
		$detail = $this->PatientSmoking->find('first',array('fields'=>array('PatientSmoking.patient_id','PatientSmoking.current_smoking_fre','PatientSmoking.smoking_fre','SmokingStatusOncs.description','SmokingStatusOncs1.description','SmokingStatusOncs.detail','SmokingStatusOncs1.detail','SmokingStatusOncs.snomed_id','SmokingStatusOncs1.snomed_id'),'conditions'=>array('PatientSmoking.patient_id'=>$patient_id),'order'=>array('PatientSmoking.id DESC'),'limit'=>1));
		$this->set('detail',$detail);


		//$sm_detail = $this->SmokingStatusOncs->find('all',array('fields'=>array('SmokingStatusOncs.description'),'condition'=>array('SmokingStatusOncs.description=$detail')));

		//echo '<pre>';print_r($detail);exit;
	}

	public function bmi_chart($patient_id=null) {

		$this->set('title_for_layout', __('Growth Chart', true));
		$this->layout=false;
		$this->uses = array('Diagnosis');
		$this->uses = array('Patient');
		$this->Diagnosis->bindModel( array(
				'belongsTo' => array(
						'Patient'=>array('conditions'=>array('Diagnosis.patient_id=Patient.id'),'foreignKey'=>false),
						'Person'=>array('conditions'=>array('Person.id=Patient.person_id'),'foreignKey'=>false)
				)
		));

		$diagnosis = $this->Diagnosis->find('all',array('fields'=>array('Diagnosis.height,Diagnosis.weight,Diagnosis.patient_id,Patient.age,Person.sex,Patient.lookup_name'),'conditions'=>array('Diagnosis.patient_id'=>$patient_id)));

		$weight = $this->request->data['weight'];
		$age = $this->request->data['weight'];
		$height = $this->request->data['height'];

		$this->set('diagnosis', $diagnosis);
		$this->set('height', $height);
		$this->set('weight', $weight);
		$this->set('bmi',$bmi);
	}



	public function add_ambi($patient_id=null,$allergyid=null,$allergytype=null){
		
		/* debug($this->request->data);
		exit; */
		
		$this->set('title_for_layout', __('-Patient Diagnosis', true));
		//load model
		$this->uses = array('NoteDiagnosis','Patient','DoctorProfile','Person','Diagnosis','DiagnosisDrug','icd','Corporate','InsuranceCompany','Ward','Room','Bed',
				'PatientPastHistory','PatientPersonalHistory','PatientSmoking','PatientFamilyHistory','PatientAllergy','User','Consultant','PregnancyCount','PastMedicalHistory','ProcedureHistory','TariffList',

				'LaboratoryTestOrder','RadiologyTestOrder','RadiologyReport','PastMedicalRecord','FamilyHistory','AllergyLocation','AllergyReaction','DrugAllergy','SmokingStatusOncs','Language');


		
		
		$languages = $this->Language->find('list',array('fields'=>array('code','language')));
		$this->set('languages',$languages);

		$smoking_dates = $this->PatientSmoking->find('first',array('fields'=>array('pre_from','pre_to','current_from','current_to'),'conditions'=>array('patient_id'=>$patient_id),'order'=>array('id'=>'desc')));
		//echo"<pre>";print_r($smoking_dates);//exit;
		$this->set('smoking_dates',$smoking_dates);

		$this->patient_info($patient_id);
		
		
		//---------------- clinical support System----------------------------
		$dataage = $this->Patient->find('all',array('fields'=>array('Patient.age','Patient.sex'),'conditions'=>array('Patient.id'=>$patient_id)));
		$getage=$dataage[0]['Patient']['age'];
		$this->set('data',$getage);
		$this->set('cancer',$allergyid);
		$geticds = $this->NoteDiagnosis->find('all',array('fields'=>array('NoteDiagnosis.diagnoses_name'),'conditions'=>array('NoteDiagnosis.patient_id'=>$patient_id)));

		$noOfId =  count($geticds);
		$string="";
		for($k=0;$k<$noOfId;$k++){
			$string = $geticds[$k][NoteDiagnosis][diagnoses_name] .",". $string;
		}

		$string = str_replace("|",",",$string);
		$string2 = explode(",",$string);

		$cancer= "";
		if(in_array('Malignant tumor of cervix',$string2)||in_array('Ca cervix - screening done (finding)',$string2)){
			$cancer = 'cancer';
		}


		$this->set('role',$_SESSION['role']);

		$this->set('geticds1', $cancer);
		//----------- end of clicnical support---------------------------------
		//set return page url in session
		//BOF referer link
		$data1 = $this->RadiologyReport->find('all',array('fields'=>array('RadiologyReport.id','RadiologyReport.patient_id','RadiologyReport.file_name','RadiologyReport.description'),
				'conditions'=>array('RadiologyReport.patient_id'=>$patient_id,'RadiologyReport.is_deleted'=>'0')));
		for($a=0;$a<count($data1);$a++){
			//$b[]= '"../../uploads/radiology/'.$data1[$a][RadiologyReport][file_name].'"';
			$b[]='"'.$this->webroot.'uploads/radiology/'.$data1[$a][RadiologyReport][file_name].'"';
			$c[]='"'.$data1[$a]['RadiologyReport']['description'].'"';
		}
		$this->set('data1',$data1);
		$this->set('b',$b);
		$this->set('c',$c);

		$sessionReturnString = $this->Session->read('returnPage') ;
		$currentReturnString = $this->params->query['return'] ;
		if(($currentReturnString!='') && ($currentReturnString != $sessionReturnString) ){
			$this->Session->write('returnPage',$currentReturnString);
		}else if($currentReturnString ==''){
			$this->Session->delete('returnPage');
		}
		//EOF referer link
		//----------------------PastMedicalRecord---------------
		$getpatient=$this->PastMedicalRecord->find('all',array('conditions'=>array('patient_id'=>$patient_id)));
		 
		$this->set('getpatient',$getpatient);

		//----------------------------------getpatientfamilyhistory---------------------------------------

		$getpatientfamilyhistory=$this->FamilyHistory->find('all',array('conditions'=>array('patient_id'=>$patient_id)));
		$this->set('getpatientfamilyhistory',$getpatientfamilyhistory);
		//----------------------smoking---------------
		$smokingOptions =    $this->SmokingStatusOncs->find('list',array('fields'=>array('description')));
		$this->set(compact('smokingOptions'));

		//-------
		if(isset($this->request->data) && !empty($this->request->data)){
			

			//---past medical history
			//--------
			if(!empty($this->request->data['PastMedicalHistory'])){
					
				$past_history = $this->Diagnosis->insertPastMedicalHistory($this->request->data['PastMedicalHistory'],$patient_id);
			}
			//--------
			
			//past medical history
			
			//---------yash
			if(!empty($this->request->data['pregnancy'])){
				$pregnency_count = $this->Diagnosis->insertPregnancyCount($this->request->data['pregnancy'],$patient_id);
			}
			//--------
			
			//---------ProcedureHistory
				if(!empty($this->request->data['ProcedureHistory'])){
			
				$procedureHistory = $this->Diagnosis->insertProcedureHistory($this->request->data['ProcedureHistory'],$patient_id);
			}
			

			$this->request->data['Diagnosis']['patient_id']= $patient_id;
			$icdCodes = explode('|',$this->request->data['Diagnosis']['ICD_code']);
			if(count($icdCodes) > 0){
				$icdArrLength  =count($icdCodes);
				unset($icdCodes[$icdArrLength-1]);//empty value is there
				$icdCodes = array_unique($icdCodes);
				$icdCodes = implode("|" ,$icdCodes);
				if($icdCodes !='')
					$icdCodes = $icdCodes.'|';
				$this->request->data['Diagnosis']['ICD_code'] = $icdCodes;
			}

			#pr($icdCodes);exit;
			//convert date to DB format
			if(!empty($this->request->data["Diagnosis"]['next_visit'])){
				$this->request->data["Diagnosis"]['next_visit'] = $this->DateFormat->formatDate2STD($this->request->data["Diagnosis"]['next_visit'],Configure::read('date_format'));
			}
			if(!empty($this->request->data["Diagnosis"]['register_on'])){
				$last_split_date_time =  $this->request->data["Diagnosis"]['register_on'];
				$this->request->data["Diagnosis"]['register_on'] = $this->DateFormat->formatDate2STD($last_split_date_time,Configure::read('date_format'));
			}
			if(!empty($this->request->data["Diagnosis"]['consultant_on'])){
				$last_split_date_time =  $this->request->data["Diagnosis"]['consultant_on'];
				$this->request->data["Diagnosis"]['consultant_on'] = $this->DateFormat->formatDate2STD($last_split_date_time,Configure::read('date_format'));
			}
			
			//$this->PastMedicalRecord->save($this->request->data);
			
			
			//insert diagnosis record for a patient
			$diagnosisId = $this->Diagnosis->insertDiagnosis($this->request->data);

			//BOF history
			$this->request->data['PatientPastHistory']['diagnosis_id'] = $diagnosisId;
			$this->PatientPastHistory->save($this->request->data['PatientPastHistory']);
			$this->request->data['PatientPersonalHistory']['diagnosis_id'] = $diagnosisId;
			$this->request->data['PatientSmoking']['diagnosis_id'] = $diagnosisId;
			if(!empty($this->request->data["PatientSmoking"]['pre_from'])){
				$this->request->data["PatientSmoking"]['pre_from'] = $this->DateFormat->formatDate2STD($this->request->data["PatientSmoking"]['pre_from'],Configure::read('date_format'));
				//calculate age on the basis of entered DOB
				//$this->request->data["Person"]['age'] = $this->DateFormat->getAge($this->request->data["Person"]['dob']) ;
					
			}
			if(!empty($this->request->data["PatientSmoking"]['pre_to'])){
				$this->request->data["PatientSmoking"]['pre_to'] = $this->DateFormat->formatDate2STD($this->request->data["PatientSmoking"]['pre_to'],Configure::read('date_format'));
				//calculate age on the basis of entered DOB
				//$this->request->data["Person"]['age'] = $this->DateFormat->getAge($this->request->data["Person"]['dob']) ;

			}
			// added by vikas
			//$data1 = $this->PatientSmoking->find('all',array('fields'=>array('PatientSmoking.smoking_fre,PatientSmoking.current_smoking_fre'),'conditions'=>array('PatientSmoking.diagnosis_id'=>6)));
			$date = date('Y-m-d h:i:s', time());
			if($this->request->data['PatientSmoking']['current_smoking_fre']==''){
				$this->request->data['PatientSmoking']['current_smoking_fre'] = $this->request->data['PatientSmoking']['smoking_fre2'];
				$this->request->data["PatientSmoking"]['created_date'] = $date;

				//$this->request->data['PatientSmoking']['current_smoking_fre'] = $this->request->data['PatientSmoking']['current_smoking_fre'];
				// unset($this->request->data['PatientPersonalHistory']['smoking_fre1']);

			}
			else{
				if($this->request->data['PatientSmoking']['smoking_fre2']!=''){
					$this->request->data['PatientSmoking']['smoking_fre'] = $this->request->data['PatientSmoking']['current_smoking_fre'];
					//$this->request->data['PatientSmoking']['current_smoking_fre'] = $this->request->data['SmokingStatusOncs.description'];
					$this->request->data['PatientSmoking']['current_smoking_fre'] = $this->request->data['PatientSmoking']['smoking_fre2'];
					$this->request->data["PatientSmoking"]['created_date'] = $date;
					$this->request->data['PatientSmoking']['current_from'] = $this->request->data['PatientSmoking']['pre_from1'];
					$this->request->data['PatientSmoking']['current_to'] = $this->request->data['PatientSmoking']['pre_to1'];
				}
				else{
					$this->request->data['PatientSmoking']['smoking_fre'] = $this->request->data['PatientSmoking']['smoking_fre'];
					//$this->request->data['PatientSmoking']['current_smoking_fre'] = $this->request->data['SmokingStatusOncs.description'];
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
			$this->request->data['PatientFamilyHistory']['diagnosis_id'] = $diagnosisId;
			$this->PatientFamilyHistory->save($this->request->data['PatientFamilyHistory']);
			$this->request->data['PatientAllergy']['diagnosis_id'] = $diagnosisId;
			if($this->request->data['PatientAllergy']['allergies']==0){
				//unset previously added reaction if any
				$this->request->data['PatientAllergy']['from1'] ='';
				$this->request->data['PatientAllergy']['reaction1'] ='' ;
				$this->request->data['PatientAllergy']['from2'] ='';
				$this->request->data['PatientAllergy']['reaction2'] ='';
				$this->request->data['PatientAllergy']['from3'] ='';
				$this->request->data['PatientAllergy']['reaction3'] ='' ;
			}
			$this->PatientAllergy->save($this->request->data['PatientAllergy']);

			//BOF investigation

			//	$this->RadiologyTestOrder->insertTestOrder($this->request->data,'insert');
			//	$this->LaboratoryTestOrder->insertTestOrder($this->request->data,'insert');

			//$this->RadiologyTestOrder->insertTestOrder($this->request->data,'insert');
			//$this->LaboratoryTestOrder->insertTestOrder($this->request->data,'insert');

			//EOF investigation
			//EOF history
			$this->Session->setFlash(__('Record added successfully.', true));
			$this->redirect($this->referer());

		}else if(empty($patient_id)){
			$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
			$this->redirect($this->referer());
		}
		//check if patient record is exist
		$this->Diagnosis->bindModel( array(
				'belongsTo' => array(
						'PatientAllergy'=>array('conditions'=>array('Diagnosis.id=PatientAllergy.diagnosis_id'),'foreignKey'=>false),
						'PatientPersonalHistory'=>array('conditions'=>array('Diagnosis.id=PatientPersonalHistory.diagnosis_id'),'foreignKey'=>false,'order'=>array('PatientSmoking.id DESC'),'limit'=>1),
						'PatientSmoking'=>array('conditions'=>array('Diagnosis.id=PatientSmoking.diagnosis_id'),'foreignKey'=>false),
						'PatientPastHistory'=>array('conditions'=>array('Diagnosis.id=PatientPastHistory.diagnosis_id'),'foreignKey'=>false),
						'PatientFamilyHistory'=>array('conditions'=>array('Diagnosis.id=PatientFamilyHistory.diagnosis_id'),'foreignKey'=>false),
						'SmokingStatusOncs'=>array('className'=>'SmokingStatusOncs','conditions'=>array('PatientSmoking.smoking_fre=SmokingStatusOncs.id'),'foreignKey'=>false),
						'SmokingStatusOncs1'=>array('className'=>'SmokingStatusOncs','conditions'=>array('PatientSmoking.current_smoking_fre=SmokingStatusOncs1.id'),'foreignKey'=>false)
				)
		));
		$diagnosisRec = $this->Diagnosis->find('first',array('conditions'=>array('Diagnosis.patient_id'=>$patient_id)));

		$diagnosisDrugRec = $this->DiagnosisDrug->find('all',array('fields'=>array('DiagnosisDrug.mode,DiagnosisDrug.tabs_per_day,DiagnosisDrug.mode,DiagnosisDrug.quantity,
				DiagnosisDrug.tabs_frequency,DiagnosisDrug.first,DiagnosisDrug.second,DiagnosisDrug.third,DiagnosisDrug.forth,
				PharmacyItem.name,PharmacyItem.pack'),'conditions'=>array('diagnosis_id'=>$diagnosisRec['Diagnosis']['id'])));
		$this->set('icd_ids',array());


		/* if(!empty($diagnosisRec['Diagnosis']['ICD_code'])){
			$splitICD = explode('|',$diagnosisRec['Diagnosis']['ICD_code']);

		$arrLength  =count($splitICD);
		//unset($splitICD[$arrLength-1]);//empty value is there

		$attachedICD = implode(",",$splitICD) ;
		$icdArray  = $this->icd->find('all',array('fields'=>array('id','icd_code','description'),'conditions'=>array("icd.id"=> $attachedICD)));
		$this->set('icd_ids',$icdArray);
		} */
		
		
		//--------
		
		
		$count = count($diagnosisDrugRec);
		if($diagnosisRec){
			if($count){
				for($i=0;$i<$count;){
					$diagnosisRec['drug'][$i]  = $diagnosisDrugRec[$i]['PharmacyItem']['name'];
					$diagnosisRec['pack'][$i]  = $diagnosisDrugRec[$i]['PharmacyItem']['pack'];
					$diagnosisRec['mode'][$i]  = $diagnosisDrugRec[$i]['DiagnosisDrug']['mode'];
					$diagnosisRec['tabs_per_day'][$i]  = $diagnosisDrugRec[$i]['DiagnosisDrug']['tabs_per_day'];
					$diagnosisRec['tabs_frequency'][$i]  = $diagnosisDrugRec[$i]['DiagnosisDrug']['tabs_frequency'];
					$diagnosisRec['quantity'][$i]  = $diagnosisDrugRec[$i]['DiagnosisDrug']['quantity'];
					$diagnosisRec['first'][$i]  = $diagnosisDrugRec[$i]['DiagnosisDrug']['first'];
					$diagnosisRec['second'][$i]  = $diagnosisDrugRec[$i]['DiagnosisDrug']['second'];
					$diagnosisRec['third'][$i]  = $diagnosisDrugRec[$i]['DiagnosisDrug']['third'];
					$diagnosisRec['forth'][$i]  = $diagnosisDrugRec[$i]['DiagnosisDrug']['forth'];
					$i++;
				}
			}
			//convert date to local format
			if(!empty($diagnosisRec['Diagnosis']['next_visit'])){
				$diagnosisRec['Diagnosis']['next_visit'] = $this->DateFormat->formatDate2Local($diagnosisRec['Diagnosis']['next_visit'],Configure::read('date_format'));
			}
			if(!empty($diagnosisRec['Diagnosis']['register_on'])){
				$diagnosisRec['Diagnosis']['register_on'] = $this->DateFormat->formatDate2Local($diagnosisRec['Diagnosis']['register_on'],Configure::read('date_format'),true);
			}
			if(!empty($diagnosisRec['Diagnosis']['consultant_on'])){
				$diagnosisRec['Diagnosis']['consultant_on'] = $this->DateFormat->formatDate2Local($diagnosisRec['Diagnosis']['consultant_on'],Configure::read('date_format'),true);
			}
			$this->data = $diagnosisRec ;

		}

		$drugAllergyRec = $this->DrugAllergy->find('all',array('fields'=>array('DrugAllergy.from1,DrugAllergy.reaction,DrugAllergy.id'),'conditions'=>array('diagnosis_id'=>$patient_id)));

		//for setting location dropdown
		$this->loadmodel("AllergyLocation");
		$allergylocationlist=$this->AllergyLocation->find('list', array('fields'=> array('name', 'name'),'conditions' => array('AllergyLocation.is_deleted' => 0, 'AllergyLocation.is_active' => 1)));
		$this->set('allergylocationlist',$allergylocationlist);

		//for setting reaction dropdown

		$allergyreactionlist=$this->AllergyReaction->find('list', array('fields'=> array('name', 'name'),'conditions' => array('AllergyReaction.is_deleted' => 0, 'AllergyReaction.is_active' => 1)));
		$this->set('allergyreactionlist',$allergyreactionlist);

		//end of code

		//find the view of allergy

		//Drug allergy
		$drugallergy_all=$this->DrugAllergy->find('all',array('fields'=>array('id','from1','reaction','severity','active','allergylocation','startdate','onsets','comments','onsets_date'),'conditions'=>array('DrugAllergy.allergy_type'=>'drug','DrugAllergy.diagnosis_id'=>$patient_id)));
		$this->set("drugallergy_all",$drugallergy_all);

		//Food allergy
		$foodallergy_all=$this->DrugAllergy->find('all',array('fields'=>array('id','from1','reaction','severity','active','allergylocation','startdate','onsets','comments','onsets_date'),'conditions'=>array('DrugAllergy.allergy_type'=>'food','DrugAllergy.diagnosis_id'=>$patient_id)));
		$this->set("foodallergy_all",$foodallergy_all);

		//Environmewnt allergy
		$envallergy_all=$this->DrugAllergy->find('all',array('fields'=>array('id','from1','reaction','severity','active','allergylocation','startdate','onsets','comments','onsets_date'),'conditions'=>array('DrugAllergy.allergy_type'=>'env','DrugAllergy.diagnosis_id'=>$patient_id)));
		$this->set("envallergy_all",$envallergy_all);


		//$this->data = $drugAllergyRec ;
		$this->set('drugallergyrec',$drugAllergyRec);
		$this->set('patient_id',$patient_id);

		//for displaying the edit form on load
		if($allergyid!="" and $allergytype!="")
		{
			if($allergytype=='drug')
			{
				$this->set('displayeditboxdrug',"block");
				$this->set('displayeditboxfood',"none");
				$this->set('displayeditboxenv',"none");

				$drugallergy_data=$this->DrugAllergy->find('all',array('fields'=>array('id','from1','reaction','severity','active','allergylocation','startdate','onsets','comments','onsets_date'),'conditions'=>array('DrugAllergy.allergy_type'=>'drug','DrugAllergy.id'=>$allergyid,'DrugAllergy.diagnosis_id'=>$patient_id)));
				$this->set("drugallergy_data",$drugallergy_data);
				//for setting dryg_allery_id hidden variable
				$this->set("allergy_id",$drugallergy_data["0"]["DrugAllergy"]["id"]);

			}
			else if($allergytype=='food')
			{
				$foodallergy_data=$this->DrugAllergy->find('all',array('fields'=>array('id','from1','reaction','severity','active','allergylocation','startdate','onsets','comments','onsets_date'),'conditions'=>array('DrugAllergy.allergy_type'=>'food','DrugAllergy.id'=>$allergyid,'DrugAllergy.diagnosis_id'=>$patient_id)));
				$this->set("foodallergy_data",$foodallergy_data);

				$this->set('displayeditboxfood',"block");
				$this->set('displayeditboxdrug',"none");
				$this->set('displayeditboxenv',"none");
				$this->set("allergy_id",$foodallergy_data["0"]["DrugAllergy"]["id"]);
			}
			if($allergytype=='env')
			{
				$envallergy_data=$this->DrugAllergy->find('all',array('fields'=>array('id','from1','reaction','severity','active','allergylocation','startdate','onsets','comments','onsets_date'),'conditions'=>array('DrugAllergy.allergy_type'=>'env','DrugAllergy.id'=>$allergyid,'DrugAllergy.diagnosis_id'=>$patient_id)));
				$this->set("envallergy_data",$envallergy_data);

				$this->set('displayeditboxenv',"block");
				$this->set('displayeditboxfood',"none");
				$this->set('displayeditboxdrug',"none");
				$this->set("allergy_id",$envallergy_data["0"]["DrugAllergy"]["id"]);
			}
		}
		else
		{
			$this->set('displayeditboxdrug',"none");
			$this->set('displayeditboxfood',"none");
			$this->set('displayeditboxenv',"none");
			$this->set('doctors',$this->DoctorProfile->getRegistrar());
			$this->set('registrar',$this->DoctorProfile->getDoctors());

		}
		
		
		
		
		
		//--------yash
		$pastMedicalHistoryRec = $this->PastMedicalHistory->find('all',array('fields'=>array('PastMedicalHistory.illness,PastMedicalHistory.status,PastMedicalHistory.duration,
				PastMedicalHistory.comment'),'conditions'=>array('patient_id'=>$patient_id)));
		$this->set('pastHistory',$pastMedicalHistoryRec);
		//---------
			
		//pregnancycount
		//--------yash
		$this->Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$patientGender=$this->Patient->find('first',array('fields'=>array('Patient.sex'),'conditions'=>array('Patient.id'=>$patient_id)));
		$this->set('patientGender',$patientGender);
		
		$pregnancyCountRec = $this->PregnancyCount->find('all',array('fields'=>array('PregnancyCount.counts,PregnancyCount.date_birth,PregnancyCount.weight,PregnancyCount.baby_gender,
				PregnancyCount.week_pregnant,PregnancyCount.type_delivery,PregnancyCount.complication'),
				'conditions'=>array('patient_id'=>$patient_id)));
		$this->set('pregnancyData',$pregnancyCountRec);
			
		//---------
		
		//--------ProcedureHistory
		$procedureHistoryRec = $this->ProcedureHistory->find('all',array('fields'=>array('ProcedureHistory.procedure,ProcedureHistory.provider,ProcedureHistory.age_value,
				ProcedureHistory.age_unit,ProcedureHistory.procedure_date,ProcedureHistory.comment'),'conditions'=>array('patient_id'=>$patient_id)));
		$this->set('procedureHistory',$procedureHistoryRec);
		//---------
				
	}


//--Function to add and edit lab order

	public function save_laborder($patient_id=null,$token_id=null){
		$this->autoRender = false;
		$this->uses = array('LaboratoryTestOrder','LaboratoryToken','Laboratory','Patient','Person','PanelMapping');
		//set validation to check in model
		$this->LaboratoryToken->set($this->request->data["LaboratoryToken"]);
		$this->request->data['Laboratory']["name"] = $this->request->data["LaboratoryToken"]["testname"];
		$this->Laboratory->set($this->request->data['Laboratory']);
		if(!empty($this->request->data["LaboratoryTestOrder"]["start_date"]))
		$startDate  = $this->DateFormat->formatDate2STD($this->request->data["LaboratoryTestOrder"]["start_date"],Configure::read('date_format'));
		
		/*if(!empty($this->request->data["LaboratoryTestOrder"]["end_date"]))
		$endDate  = $this->DateFormat->formatDate2STD($this->request->data["LaboratoryTestOrder"]["end_date"],Configure::read('date_format'));
		*/
		if(!empty($this->request->data["LaboratoryToken"]["collected_date"]))
		$this->request->data["LaboratoryToken"]["collected_date"]  = $this->DateFormat->formatDate2STD($this->request->data["LaboratoryToken"]["collected_date"],Configure::read('date_format_us'));
		if(!empty($this->request->data["LaboratoryToken"]["end_date"]))
		$this->request->data["LaboratoryToken"]["end_date"]  = $this->DateFormat->formatDate2STD($this->request->data["LaboratoryToken"]["end_date"],Configure::read('date_format_us'));
		else 
		$this->request->data["LaboratoryToken"]["end_date"] =  '0000-00-00 00:00:00';
		$skipValidation = false ;
		if(!empty($startDate)){
			$startDateTime = strtotime($startDate) ;
			$currentTime = time();
			if($startDateTime > $currentTime){
				$skipValidation = true ;
			}
		}
		$patientData = $this->Patient->read(array('patient_id','lookup_name','doctor_id'),$patient_id);
		$this->request->data['LaboratoryTestOrder']['doctor_id'] = $patientData['Patient']['doctor_id'];
		/*if($skipValidation){
			$errors2 = $this->Laboratory->invalidFields();
			if(empty($this->request->data["LaboratoryToken"]["testname"])){
				echo "Please enter universal service identifier.";
				exit;
			}
		}else	if(!$this->LaboratoryToken->validates() || !$this->Laboratory->validates() && !$skipValidation){

			$errors1 = $this->LaboratoryToken->invalidFields();
			$errors2 = $this->Laboratory->invalidFields();
			echo trim($errors2['name'][0]."\n".$errors1[collected_date][0]."\n".$errors1[specimen_type_id][0]);
			exit;
		}*/
		//load model
		$this->request->data["LaboratoryToken"]["patient_id"] = $patient_id;
		$this->request->data["LaboratoryTestOrder"]["start_date"] =$startDate;
		if(empty($token_id) || ($token_id == 'undefined')){
			if($this->request->data['LaboratoryTestOrder']['isIMO']=='yes'){
			 $LaboratCheck = $this->Laboratory->find('first',array('fields'=>array('id'),
			// 'conditions'=>array('OR'=>array(array('lonic_code'=>$this->request->data["LaboratoryTestOrder"]["lonic_code"]),
					//array('cpt_code'=>$this->request->data["LaboratoryTestOrder"]["cpt_code"])))
			 'conditions'=>array('name'=>$this->request->data["LaboratoryToken"]["testname"])
			 )); 
			if(empty($LaboratCheck))
			{
				//loinc code not found insert into laboratory table.
				$this->Laboratory->saveAll(array('is_active'=>1,'name'=>$this->request->data["LaboratoryToken"]["testname"],'lonic_code'=>$this->request->data["LaboratoryTestOrder"]["lonic_code"],
						'cpt_code'=>$this->request->data["LaboratoryTestOrder"]["cpt_code"]));
				
				//$log = $this->Laboratory->getDataSource()->getLog(false, false);
				$this->request->data['LaboratoryTestOrder']['lab_id']=$this->Laboratory->getLastInsertId();
				$this->request->data['LaboratoryToken']['laboratory_id']=$this->Laboratory->getLastInsertId();
			}
			else
			{
				// to put update here.
				$this->request->data['LaboratoryTestOrder']['lab_id']=$LaboratCheck['Laboratory']['id'];
				$this->request->data['LaboratoryToken']['laboratory_id']=$LaboratCheck['Laboratory']['id'];
			}
			}
			$this->LaboratoryTestOrder->insertTestOrder($this->request->data,'insert');
			
			// Add the Panel
			//$getDataPanelMapping=$this->PanelMapping->find('all',array('conditions'=>array('PanelMapping.laboratory_id'=>$this->request->data['LaboratoryTestOrder']['lab_id'])));
			if(!empty($getDataPanelMapping)){
			//	$this->LaboratoryTestOrder->insertTestOrderPanel($getDataPanelMapping,$this->request->data);
					
			}
		}else{
			$LaboratTest['name'] = $this->request->data["LaboratoryToken"]["testname"];
			$LaboratTest['test_code'] = $this->request->data["LaboratoryTestOrder"]["testcode"];
			$LaboratTest['lonic_code'] = $this->request->data["LaboratoryTestOrder"]["lonic_code"];
			$LaboratTest['sct_concept_id'] = $this->request->data["LaboratoryTestOrder"]["sct_concept_id"];
			$LaboratTest['cpt_code'] = $this->request->data["LaboratoryTestOrder"]["cpt_code"];
			$LaboratTest['location_id'] = $this->Session->read('locationid');

			//$LaboratCheck = $this->Laboratory->find('first',array('fields'=>array('id'),
				//	'conditions'=>array('lonic_code'=>$LaboratTest['lonic_code'])));
			
			$LaboratCheck = $this->Laboratory->find('first',array('fields'=>array('id'),
					'conditions'=>array('lonic_code'=>$this->request->data["LaboratoryTestOrder"]["lonic_code"])));
				
				
				
			if(empty($LaboratCheck))
			{
				//loinc code not found insert into laboratory table.
				$this->Laboratory->saveAll(array('is_active'=>1,'name'=>$this->request->data["LaboratoryToken"]["testname"],'lonic_code'=>$this->request->data["LaboratoryTestOrder"]["lonic_code"]));
			
				//$log = $this->Laboratory->getDataSource()->getLog(false, false);
				$this->request->data['LaboratoryTestOrder']['lab_id']=$this->Laboratory->getLastInsertId();
				$this->request->data['LaboratoryToken']['laboratory_id']=$this->Laboratory->getLastInsertId();
					
			}
			else
			{
				$this->request->data['LaboratoryTestOrder']['lab_id']=$LaboratCheck['Laboratory']['id'];
				$this->request->data['LaboratoryToken']['laboratory_id']=$LaboratCheck['Laboratory']['id'];
			}
			
			
			$this->request->data['LaboratoryToken']['testname'] = $LaboratCheck['LaboratoryTestOrder']['id'];
			if(empty($this->request->data['LaboratoryToken']['testname'])){
				//$this->Laboratory->saveAll($LaboratTest);
				$radid =	$this->Laboratory->find('first',array('fields'=>array('id'),'order'=>array('Laboratory.id' => 'desc')));
				$this->request->data['LaboratoryToken']['testname'] = $radid['Laboratory']['id'];
			}
			

			$this->LaboratoryToken->query("update laboratory_tokens set
					specimen_type_id='".$this->request->data['LaboratoryToken']['specimen_type_id']."',ac_id='".$this->request->data['LaboratoryToken']['ac_id']."',alt_spec='".$this->request->data['LaboratoryToken']['alt_spec']."',
					laboratory_id='".$this->request->data['LaboratoryTestOrder']['lab_id']."',specimen_rejection_id='".$this->request->data['LaboratoryToken']['specimen_rejection_id']."',specimen_condition_id='".$this->request->data['LaboratoryToken']['specimen_condition_id']."',
					rej_reason_txt='".$this->request->data['LaboratoryToken']['rej_reason_txt']."',collected_date='".$this->request->data['LaboratoryToken']['collected_date']."',bill_type='".$this->request->data['LaboratoryToken']['bill_type']."',
					status='".$this->request->data['LaboratoryToken']['status']."',sample='".$this->request->data['LaboratoryToken']['sample']."',cond_org_txt='".$this->request->data['LaboratoryToken']['cond_org_txt']."',specimen_action_id='".$this->request->data['LaboratoryToken']['specimen_action_id']."',
					end_date='".$this->request->data['LaboratoryToken']['end_date']."',alt_spec_cond='".$this->request->data['LaboratoryToken']['alt_spec_cond']."',account_no='".$this->request->data['LaboratoryToken']['account_no']."' where id='".$token_id."'");

			$this->request->data['LaboratoryTestOrder']['lab_order_date'] =  $this->DateFormat->formatDate2STD($this->request->data["LaboratoryTestOrder"]["lab_order_date"],Configure::read('date_format'));

				
			$this->LaboratoryTestOrder->query("update laboratory_test_orders set service_provider_id='".$this->request->data['LaboratoryTestOrder']['service_provider_id']."',laboratory_id='".$this->request->data['LaboratoryTestOrder']['lab_id']."',start_date='".$this->request->data['LaboratoryTestOrder']['start_date']."',lab_order='".$this->request->data['LaboratoryTestOrder']['lab_order']."',lab_order_date='".$this->request->data['LaboratoryTestOrder']['lab_order_date']."' where id='".$this->request->data['LaboratoryToken']['testOrder_id']."'");
		}
		echo $this->Session->read('facilityu');
		exit;
	}
	/*
	 * only gathers data to load on fields
	*/
	public function edit_laborder($token_id=null){
		$this->autoRender = false;
		//$this->layout = 'ajax';
		$this->uses = array('LaboratoryTestOrder','LaboratoryToken','Laboratory');
		$this->LaboratoryToken->bindModel(array(
				'belongsTo'=>array(
						'Laboratory'=>array(
								'foreignKey'=> false,
								'conditions' => array('Laboratory.id = LaboratoryToken.laboratory_id'),
									
						),
						'LaboratoryTestOrder'=>array(
								'foreignKey'=> false,
								'conditions' => array('LaboratoryTestOrder.id = LaboratoryToken.laboratory_test_order_id'),
									
						)
				)));
		$token_data = $this->LaboratoryToken->find('all',array('fields'=>array('LaboratoryTestOrder.start_date','LaboratoryToken.laboratory_test_order_id',
				'LaboratoryTestOrder.lab_order','LaboratoryTestOrder.lab_order_date','Laboratory.name','Laboratory.cpt_code',
				'Laboratory.sct_concept_id','Laboratory.lonic_code','Laboratory.id','Laboratory.test_code','LaboratoryToken.specimen_type_id',
				'LaboratoryToken.ac_id','LaboratoryToken.collected_date','LaboratoryToken.end_date','LaboratoryToken.status',
				'LaboratoryToken.sample','LaboratoryToken.bill_type','LaboratoryToken.account_no','LaboratoryToken.rej_reason_txt',
				'LaboratoryToken.specimen_condition_id','LaboratoryToken.specimen_rejection_id','LaboratoryToken.alt_spec',
				'LaboratoryToken.alt_spec_cond','LaboratoryToken.cond_org_txt','LaboratoryToken.specimen_action_id','LaboratoryTestOrder.service_provider_id'),
				'conditions'=>array('LaboratoryToken.id'=>$token_id)));
		
		$token_data['0']['LaboratoryTestOrder']['start_date'] = $this->DateFormat->formatDate2Local($token_data['0']['LaboratoryTestOrder']['start_date'],Configure::read('date_format'),false);
		
		$token_data['0']['LaboratoryTestOrder']['lab_order_date'] = $this->DateFormat->formatDate2Local($token_data['0']['LaboratoryTestOrder']['lab_order_date'],Configure::read('date_format_us'),false);
		
		$token_data['0']['LaboratoryToken']['collected_date'] = $this->DateFormat->formatDate2Local($token_data['0']['LaboratoryToken']['collected_date'],Configure::read('date_format_us'),true);
		 
		if(!empty($token_data['0']['LaboratoryToken']['end_date']) && $token_data['0']['LaboratoryToken']['end_date'] !='0000-00-00 00:00:00')
			$token_data['0']['LaboratoryToken']['end_date'] = $this->DateFormat->formatDate2Local($token_data['0']['LaboratoryToken']['end_date'],Configure::read('date_format_us'),true);
		else 
			$token_data['0']['LaboratoryToken']['end_date'] = '';
		
		echo $token_data['0']['LaboratoryToken']['laboratory_test_order_id']."|".$token_data['0']['Laboratory']['name']."|".
				$token_data['0']['LaboratoryToken']['status']."|".$token_data['0']['LaboratoryToken']['sample']."|".
				$token_data['0']['LaboratoryToken']['collected_date']."|".$token_data['0']['LaboratoryToken']['specimen_rejection_id']."|".
				$token_data['0']['LaboratoryToken']['rej_reason_txt']."|".$token_data['0']['LaboratoryToken']['cond_org_txt']."|".
				$token_data['0']['LaboratoryToken']['bill_type']."|".$token_data['0']['Laboratory']['id']."|".
				$token_data['0']['LaboratoryToken']['specimen_type_id']."|".
				$token_data['0']['LaboratoryToken']['alt_spec']."|".$token_data['0']['LaboratoryToken']['ac_id']."|".
				$token_data['0']['LaboratoryToken']['specimen_condition_id']."|".$token_data['0']['LaboratoryToken']['alt_spec_cond']."|".
				$token_data['0']['LaboratoryToken']['account_no']."|".$token_data['0']['LaboratoryToken']['specimen_action_id']."|".
				$token_data['0']['LaboratoryToken']['end_date']."|".
				$token_data['0']['Laboratory']['sct_concept_id']."|".$token_data['0']['Laboratory']['lonic_code']."|".
				$token_data['0']['Laboratory']['cpt_code']."|".$token_data['0']['LaboratoryTestOrder']['start_date']."|".
				$token_data['0']['LaboratoryTestOrder']['lab_order']."|".$token_data['0']['LaboratoryTestOrder']['lab_order_date']."|".
				$token_data['0']['LaboratoryTestOrder']['service_provider_id'];	

	 }


	public function save_radorder($patient_id=null,$radTestOrdId=null){
		$this->autoRender = false;
		$this->uses = array('RadiologyTestOrder','Radiology'); 
		$this->request->data["RadiologyTestOrder"]["id"] = $radTestOrdId;
		$this->request->data["RadiologyTestOrder"]["patient_id"] = $patient_id;
		$this->request->data["RadiologyTestOrder"]["from_assessment"] = '0';

		//check if radiology given exist in radiology test
		$radCheck = $this->Radiology->find('first',array('fields'=>array('id','name','cpt_code','test_code','lonic_code','sct_concept_id'),'conditions'=>array('Radiology.name'=> $this->request->data["RadiologyTestOrder"]["testname"])));
		$log = $this->Radiology->getDataSource()->getLog(false, false);
		
		if(empty($radCheck["Radiology"]["cpt_code"])){
			//cpt code not found insert into radiology table.
			$this->Radiology->saveAll(array('cpt_code'=>$this->request->data["RadiologyTestOrder"]["cpt_code"],'name'=>$this->request->data["RadiologyTestOrder"]["testname"],'sct_concept_id'=>$this->request->data["RadiologyTestOrder"]["sct_concept_id"],'is_active'=>1));
		
			//$log = $this->Laboratory->getDataSource()->getLog(false, false);
			$this->request->data["RadiologyTestOrder"]["sct_concept_id"] = $this->request->data["RadiologyTestOrder"]["sct_concept_id"];
		    $this->request->data["RadiologyTestOrder"]["cpt_code"] = $this->request->data["RadiologyTestOrder"]["cpt_code"];
		    $this->request->data["RadiologyTestOrder"]["testname"] = $this->request->data["RadiologyTestOrder"]["testname"];
		    $this->request->data["RadiologyTestOrder"]["testcode"] = $this->request->data["RadiologyTestOrder"]["cpt_code"];
		}else{
			$this->request->data["RadiologyTestOrder"]["sct_concept_id"] = $this->request->data["RadiologyTestOrder"]["sct_concept_id"];
			$this->request->data["RadiologyTestOrder"]["cpt_code"] = $this->request->data["RadiologyTestOrder"]["cpt_code"];
			$this->request->data["RadiologyTestOrder"]["testname"] = $this->request->data["RadiologyTestOrder"]["testname"];
			$this->request->data["RadiologyTestOrder"]["testcode"] = $this->request->data["RadiologyTestOrder"]["cpt_code"];
		}
		//debug($this->request->data["RadiologyTestOrder"]);exit;
		$this->RadiologyTestOrder->insertRadioTestOrder($this->request->data,'insert');
		echo $this->Session->read('facilityu');
		exit;
	}

	public function edit_radorder($test_id=null){

		$this->autoRender = false;
		$this->uses = array('RadiologyTestOrder','Radiology');

		$this->RadiologyTestOrder->bindModel(array(
				'belongsTo'=>array(
						'Radiology'=>array(
								'foreignKey'=> false,
								'conditions' => array('Radiology.id = RadiologyTestOrder.radiology_id'),
									
						))));

		$test_data = $this->RadiologyTestOrder->find('all',array('fields'=>array('RadiologyTestOrder.service_provider_id','RadiologyTestOrder.start_date','RadiologyTestOrder.is_procedure','RadiologyTestOrder.radiology_order','RadiologyTestOrder.radiology_order_date','Radiology.name','Radiology.cpt_code','Radiology.sct_concept_id','Radiology.lonic_code','Radiology.test_code'),'conditions'=>array('RadiologyTestOrder.id'=>$test_id)));
		$test_data['0']['RadiologyTestOrder']['start_date'] = $this->DateFormat->formatDate2Local($test_data['0']['RadiologyTestOrder']['start_date'],Configure::read('date_format'),false);
		$test_data['0']['RadiologyTestOrder']['radiology_order_date'] = $this->DateFormat->formatDate2Local($test_data['0']['RadiologyTestOrder']['radiology_order_date'],Configure::read('date_format'),false);
		echo $test_data['0']['Radiology']['name']."|".$test_data['0']['Radiology']['test_code']."|".$test_id."|".$test_data['0']['Radiology']['sct_concept_id']."|".$test_data['0']['Radiology']['lonic_code']."|".$test_data['0']['Radiology']['cpt_code']."|".$test_data['0']['RadiologyTestOrder']['start_date']."|".$test_data['0']['RadiologyTestOrder']['is_procedure']."|".$test_data['0']['RadiologyTestOrder']['radiology_order']."|".$test_data['0']['RadiologyTestOrder']['radiology_order_date']."|".$test_data['0']['RadiologyTestOrder']['service_provider_id'];
		exit;
	}


	//function  to save allergy
	public function save_allergy($patient_id=null,$allergytype=null){

		$this->autoRender = false;
		//load model

		$this->uses = array('DrugAllergy','Diagnosis','PharmacyItem');

		$drugResult= $this->PharmacyItem->find('first',array('fields'=>array('id','name'),'conditions'=>array('PharmacyItem.name'=>$this->request->data["Diagnosis"]["allergyfrom"])));

		if($drugResult){
			$drugid = $drugResult['PharmacyItem']['id'];
		}else{
			if($allergytype=='drug')
			{
				$this->PharmacyItem->save(array('name'=>$this->request->data["Diagnosis"]["allergyfrom"]));
				$drugid= $this->PharmacyItem->getInsertID();
			}
			else
			{
				$drugid="";
			}
		}
		//find diagnosis id on the basis of patient id

		$diagnosisid = $this->Diagnosis->find('first',array('fields'=>array('id'),'conditions'=>array('patient_id'=>$patient_id)));
		//print_r("test".$diagnosisid);
		// echo "test".$this->RequestHandler->isAjax();
		//if($this->RequestHandler->isAjax())
		//{
		if($allergytype=='drug')
		{
			if($this->request->data["Diagnosis"]["drug_allergy_id"]=="")
			{
				$reaction_value = implode(',', $this->request->data[Diagnosis][reaction]);
				$this->DrugAllergy->saveAll(array('diagnosis_id'=>$patient_id,'drug_id'=>$drugid,'from1'=>$this->request->data["Diagnosis"]["allergyfrom"],'reaction'=>$reaction_value,'severity'=>$this->request->data["Diagnosis"]["severity"],'active'=>$this->request->data["Diagnosis"]["active"],'allergylocation'=>$this->request->data["Diagnosis"]["allergylocation"],'startdate'=>$this->request->data["Diagnosis"]["startdate"],'onsets'=>$this->request->data["Diagnosis"]["onsets"],'comments'=>$this->request->data["Diagnosis"]["comments"],'onsets_date'=>$this->request->data["Diagnosis"]["onsets_date"],'allergy_type'=>$allergytype));
			}
			else
			{
				$reaction_value = implode(',', $this->request->data[Diagnosis][reaction]);
				$this->DrugAllergy->query("update drug_allergies set diagnosis_id='".$patient_id."',drug_id='".$drugid."',from1='".$this->request->data["Diagnosis"]["allergyfrom"]."',reaction='".$reaction_value."',severity='".$this->request->data["Diagnosis"]["severity"]."',active='".$this->request->data["Diagnosis"]["active"]."' ,allergylocation='".$this->request->data["Diagnosis"]["allergylocation"]."',startdate='".$this->request->data["Diagnosis"]["startdate"]."',onsets='".$this->request->data["Diagnosis"]["onsets"]."',comments='".$this->request->data["Diagnosis"]["comments"]."',onsets_date='".$this->request->data["Diagnosis"]["onsets_date"]."',allergy_type='".$allergytype."' where id='".$this->request->data["Diagnosis"]["drug_allergy_id"]."'");
			}
		}
		if($allergytype=='food')
		{

			if($this->request->data["Diagnosis"]["drug_allergy_id"]=="")
			{
					
				$reaction_value = implode(',', $this->request->data[Diagnosis][foodreaction]);
					

				$this->DrugAllergy->saveAll(array('diagnosis_id'=>$patient_id,'drug_id'=>$drugid,'from1'=>$this->request->data["Diagnosis"]["allergyfromfood"],'reaction'=>$reaction_value,'severity'=>$this->request->data["Diagnosis"]["severityfood"],'active'=>$this->request->data["Diagnosis"]["activefood"],'allergylocation'=>$this->request->data["Diagnosis"]["allergylocationfood"],'startdate'=>$this->request->data["Diagnosis"]["startdatefood"],'onsets'=>$this->request->data["Diagnosis"]["onsetsfood"],'comments'=>$this->request->data["Diagnosis"]["commentsfood"],'onsets_date'=>$this->request->data["Diagnosis"]["onsets_date_food"],'allergy_type'=>$allergytype));
			}
			else
			{
				$reaction_value = implode(',', $this->request->data[Diagnosis][foodreaction]);
				$this->DrugAllergy->query("update drug_allergies set diagnosis_id='".$patient_id."',drug_id='".$drugid."',from1='".$this->request->data["Diagnosis"]["allergyfromfood"]."',reaction='".$reaction_value."',severity='".$this->request->data["Diagnosis"]["severityfood"]."',active='".$this->request->data["Diagnosis"]["activefood"]."' ,allergylocation='".$this->request->data["Diagnosis"]["allergylocationfood"]."',startdate='".$this->request->data["Diagnosis"]["startdatefood"]."',onsets='".$this->request->data["Diagnosis"]["onsetsfood"]."',comments='".$this->request->data["Diagnosis"]["commentsfood"]."',onsets_date='".$this->request->data["Diagnosis"]["onsets_date_food"]."',allergy_type='".$allergytype."' where id='".$this->request->data["Diagnosis"]["drug_allergy_id"]."'");
			}
		}
		if($allergytype=='env')
		{

			if($this->request->data["Diagnosis"]["drug_allergy_id"]=="")
			{
				$reaction_value = implode(',', $this->request->data[Diagnosis][reactionenv]);

				$this->DrugAllergy->saveAll(array('diagnosis_id'=>$patient_id,'drug_id'=>$drugid,'from1'=>$this->request->data["Diagnosis"]["allergyfromenv"],'reaction'=>$reaction_value,'severity'=>$this->request->data["Diagnosis"]["severityenv"],'active'=>$this->request->data["Diagnosis"]["activeenv"],'allergylocation'=>$this->request->data["Diagnosis"]["allergylocationenv"],'startdate'=>$this->request->data["Diagnosis"]["startdateenv"],'onsets'=>$this->request->data["Diagnosis"]["onsetsenv"],'comments'=>$this->request->data["Diagnosis"]["commentsenv"],'onsets_date'=>$this->request->data["Diagnosis"]["onsets_date_env"],'allergy_type'=>$allergytype));
			}
			else
			{
				$reaction_value = implode(',', $this->request->data[Diagnosis][reactionenv]);
				$this->DrugAllergy->query("update drug_allergies set diagnosis_id='".$patient_id."',drug_id='".$drugid."',from1='".$this->request->data["Diagnosis"]["allergyfromenv"]."',reaction='".$reaction_value."',severity='".$this->request->data["Diagnosis"]["severityenv"]."',active='".$this->request->data["Diagnosis"]["activeenv"]."' ,allergylocation='".$this->request->data["Diagnosis"]["allergylocationenv"]."',startdate='".$this->request->data["Diagnosis"]["startdateenv"]."',onsets='".$this->request->data["Diagnosis"]["onsetsenv"]."',comments='".$this->request->data["Diagnosis"]["commentsenv"]."',onsets_date='".$this->request->data["Diagnosis"]["onsets_date_env"]."',allergy_type='".$allergytype."' where id='".$this->request->data["Diagnosis"]["drug_allergy_id"]."'");
			}
		}
		//}
		//echo "hello";
		exit;

	}

	//function to delete allergy
	function delete_drug_allergy($patient_id=null,$allergyid=null,$allergytype=null)
	{
		$this->autoRender = false;
		//load model
		$this->uses = array('DrugAllergy');
		$this->DrugAllergy->deleteAll(array('DrugAllergy.id' => $allergyid), false);
		$this->redirect(array('controller' => 'diagnoses', 'action' => 'add',$patient_id));

	}
	public function getfoodtype(){
		$this->uses = array('FoodAllergyType');
		$data = $this->FoodAllergyType->find('list',array('fields'=> array("name","name"),'conditions' => array("FoodAllergyType.is_active"=>1)));

		$output ="";
		foreach ($data as $key=>$value) {
			$output .=$value."|".$key."\n";
		}
		echo $output;

		exit;
	}
	public function getenvtype(){
		$this->uses = array('EnvAllergy');
		$data = $this->EnvAllergy->find('list',array('fields'=> array("name","name"),'conditions' => array("EnvAllergy.is_active"=>1)));

		$output ="";
		foreach ($data as $key=>$value) {
			$output .=$value."|".$key."\n";
		}
		echo $output;

		exit;
	}

	//function to return ipd code's
	public function icd($patient_id=null){

		$this->set('title_for_layout', __('-Select IPD code.', true));
		$this->layout = false ;
		$this->uses = array('SnomedMappingMaster');
		if($this->request->query){
			$condition = '';
			if(!empty($this->request->query['description'])){
				$condition = array('sctName like'=>"%".$this->request->query['description']."%") ;
			}
			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'conditions'=>$condition ,
					'order' => array('SnomedMappingMaster.id' => 'asc',)
			);
		}else{
			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'order' => array(
							'SnomedMappingMaster.id' => 'asc'
					)
			);
		}
		if(isset($this->request->query['description'])){
			$this->data = array('sctName'=>array('sctName'=>$this->request->query['description']));
		}
		//----------gaurav
		$data = $this->paginate('SnomedMappingMaster');
		$data[0]['SnomedMappingMaster'][patient_id]=$patient_id;
		//pr($data);   // 	pass it to hidden field
		$this->set('data', $data);
		//pr($this->icd->getDatasource());

	}

	public function make_diagnosis($id=null,$icd=null,$note_id=null,$snow_id=null){
		$this->uses = array('NoteDiagnosis');
		$this->layout = 'ajax' ;
		$icd= explode('!!!!',$icd);
		$snomedid = $icd[0];
		$snomedid1 = $icd[1];
		$diagnosis_name = $icd[2];
		if(!empty($this->params->query['close'])){
			$this->set('closeFancy',$this->params->query['close']);
		}
		if($this->params->query[returnUrl]!='callGetProblem'){
		if(!empty($diagnosis_name)){
			if(preg_match('/\s/',$diagnosis_name)){
				$getDianameArray = explode(' ',trim($diagnosis_name)); //Current diagnoses name
			}
			$orCondition .="NoteDiagnosis.patient_id='$id'";
			$searchResultDiagnosis=$this->NoteDiagnosis->find('all' ,array('fields'=>array('NoteDiagnosis.diagnoses_name'),
					'conditions'=>array('NoteDiagnosis.patient_id'=>$id,'is_deleted'=>'0')));
			$cnt = 0;
			foreach($searchResultDiagnosis as $mainData){
				$getDianameArrayJr = explode(' ',trim($mainData['NoteDiagnosis']['diagnoses_name']));
				$smallwordsarray = array(
						'of','a','the','and','an','or','nor','but','is','if','then','else','when',
						'at','from','by','on','off','for','in','out','over','to','into','with'
				);			
				foreach($getDianameArray as $key=>$dataBasics){						
						if (in_array($dataBasics, $smallwordsarray)){
							unset($dataBasics);
						}			
					if(in_array($dataBasics,$getDianameArrayJr)){	    
						$cnt++;
					}
				}//unset($getDianameArrayJr);
				if($cnt >= 2){							
					$matchfnd=1;
					$this->set('matchfnd',$matchfnd);
					break;
					$this->set(compact('cnt'));
				}else{
					$cnt = 0;
					$matchnotfnd=2;
					$this->set('matchnotfnd',$matchnotfnd);
				}
			}
		}
		}
		if(!empty($this->params->query['str'])){
			$this->set('strFav',$this->params->query['str']);
		}
		//EOD
		//redirect in case of edit-aditya
		$this->set('returnUrl',$this->params->query['returnUrl']);
		//EOF
		//***********************IMPORTANT CODE***********************
		if(empty($note_id)){
			$note_id=$icd[3];
		}
		//********************************************
		$icd= $icd[0];
		$this->uses = array('Note','icds','Patient','NoteDiagnosis','DiagnosisMaster','AdverseEventTrigger');
		
		$this->set('patientDetails',$patientDetails);
		
		$edit_makediagnosis=$this->NoteDiagnosis->find('all',array('conditions'=>array('id'=>$note_id)));
		if(!empty($edit_makediagnosis)){
			$edit_makediagnosis['0']['NoteDiagnosis']['start_dt'] = $this->DateFormat->formatDate2Local($edit_makediagnosis['0']['NoteDiagnosis']['start_dt'],Configure::read('date_format'),false);
			$edit_makediagnosis['0']['NoteDiagnosis']['end_dt'] = $this->DateFormat->formatDate2Local($edit_makediagnosis['0']['NoteDiagnosis']['end_dt'],Configure::read('date_format'),false);
			$this->set('edit_makediagnosis',$edit_makediagnosis);
		}
		//debug($icd[0]['icds']['icd_description']);exit;
		$p_name  = $this->Patient->find('all',array('fields'=>array('lookup_name', 'patient_id'),'conditions'=>array('Patient.id'=>$id)));
		$icd1[0][icds][p_name] = $p_name['0']['Patient']['lookup_name'];
		$icd1[0][icds][p_id] = $id;
		$icd1[0][icds][note_id] = $note_id;
		$icd1[0][icds][icd_snomed] = $icd;
		$icd1[0][icds][icd_description] = $diagnosis_name;
		$icd1[0][icds][icd_snomedid] = $snomedid;
		$icd1[0][icds][icd_snomedid1] = $snomedid1;
		$this->set('icd', $icd1);
		$this->set('u_id',$p_name['0']['Patient']['patient_id']);
		//--------------------------------------------aditya snomed code-----------------------------------------------------------------------------------

		$check_diagnosis=$this->NoteDiagnosis->find('all' ,array('conditions'=>array('patient_id'=>$id)));
		foreach($check_diagnosis as $check_diagnosiss){
			$getdata.=$check_diagnosiss['NoteDiagnosis']['icd_id']."|";
		}

		$getdata=explode("|",$getdata);

		if(!empty($this->request->data)){
			$NoteDiagnosis=array();

			if($this->request->data["NoteDiagnosis"]['end_dt'] > $this->request->data["NoteDiagnosis"]['start_dt']){
				$errors= "End Date Should Be Greater then Start Date";
				$this->Session->setFlash($errors,'default',array('class'=>'error'));
				$this->redirect($this->referer());
			}
			if(!empty($edit_makediagnosis)){ // Edit case
				$start_dt= $this->DateFormat->formatDate2STD($this->request->data[start_dt],Configure::read('date_format'));
				$NoteDiagnosis['start_dt'] = substr($start_dt,0,10);

				$end_dt=  $this->DateFormat->formatDate2STD($this->request->data[end_dt],Configure::read('date_format'));
				$NoteDiagnosis['end_dt'] = substr($end_dt,0,10);
				$NoteDiagnosis['comment']=  $this->request->data[comment];
				$NoteDiagnosis['noteId']=  $this->request->data[note_id];
				$NoteDiagnosis['snowmedid']=$this->request->data['make_diagnosis'][snowmedid];
				$NoteDiagnosis['prev_comment']=  $this->request->data[prev_comment];
				$NoteDiagnosis['name']= $this->request->data['make_diagnosis']['name'];
				$NoteDiagnosis['disease_status']=  $this->request->data[disease_status];
				$NoteDiagnosis['terminal']=  $this->request->data[terminal];
				$NoteDiagnosis['diagnosis_type']=  $this->request->data['make_diagnosis'][diagnosis_type];
				$NoteDiagnosis['u_id']= $p_name['0']['Patient']['patient_id'];
				$NoteDiagnosis['preffered_icd9cm']= $this->request->data[preffered_icd9cm];
				$NoteDiagnosis['modified']=date('Y-m-d H:i:s');
				$NoteDiagnosis['modified_by']=$_SESSION['Auth']['User']['id'];
				$NoteDiagnosis['id']=$this->request->data['NoteDiagnosis']['id'];
				$NoteDiagnosis['appointment_id']=$_SESSION['apptDoc'];
				$this->NoteDiagnosis->save($NoteDiagnosis);
				$this->set('closeFancy',$this->request->data['closeFancy']);
				
			}
			else { //Add case
				$start_dt= $this->DateFormat->formatDate2STD($this->request->data[start_dt],Configure::read('date_format'));
				$start_dt = substr($start_dt,0,10);
				$end_dt=  $this->DateFormat->formatDate2STD($this->request->data[end_dt],Configure::read('date_format'));
				$start_dt = substr($start_dt,0,10);
				$comment=  $this->request->data['comment'];
				$noteId=  $this->request->data[note_id];
				$snowmedid=  $icd1[0][icds][icd_snomedid1];
				$prev_comment=  $this->request->data['prev_comment'];
				$name=$icd1[0][icds][icd_description];
				$trim_name=trim($name);
				$preffered_icd9cm= $this->request->data['preffered_icd9cm'];
				$disease_status=  $this->request->data['disease_status'];
				$terminal=  $this->request->data['terminal'];
				$diagnosis_type=  $this->request->data['make_diagnosis']['diagnosis_type'];
				$u_id=$p_name['0']['Patient']['patient_id'];
				$created=date('Y-m-d H:i:s');
				$created_by=$_SESSION['Auth']['User']['id'];
				$appointment_id=$_SESSION['apptDoc'];
					
				//BOF adverse event
				$adverse_event = 0 ;
				$adverseEventTriggerArray  = $this->AdverseEventTrigger->getEventTriggers(array("snowmed"),array("section"=>"problem"));

				if(in_array($snowmedid,$adverseEventTriggerArray)){
					$adverse_event = 1 ;
				}
				//EOF adverse event
				$this->NoteDiagnosis->saveAll(array('start_dt'=>"$start_dt",'end_dt'=>"$end_dt",
						'comment'=>"$comment",'icd_id'=>"$icd",'appointment_id'=>"$appointment_id",'disease_status'=>"$disease_status",'terminal'=>"$terminal",'u_id'=>"$u_id",'diagnoses_name'=>"$trim_name",'preffered_icd9cm'=>"$preffered_icd9cm",
						'created'=>"$created",'created_by'=>"$created_by",'note_id'=>"$noteId",'prev_comment'=>"$prev_comment",'snowmedid'=>"$snowmedid",'patient_id' =>"$id",'adverse_event'=>"$adverse_event",'diagnosis_type'=>"$diagnosis_type"));

				// seen status by aditya
				$this->Note->seenStatus();
				//EOF
				//--------insert note_id ---
				$lastId=$this->NoteDiagnosis->getLastInsertID();
				//$data = $this->Session->read('makeDignosis');
				//$data[] = $lastId;
				$this->set('noteDiagnosisId',$lastId);
				//$this->Session->write('makeDignosis', $data);
				//-eof--
			}//debug($this->request->data);exit;
			if(empty($this->request->data['returnUrl'])){
				$this->set('submitSucess','close');
			}
			else{
				$this->set('submitSucess',$this->request->data['returnUrl']);
			}

		}
		$this->set('backupNoteId',$note_id);
		$this->set('global_note_id',$note_id);
	}
	
	
	//for patient
	public function make_diagnosis_patient($id=null,$icd,$note_id=null,$snow_id=null){

		$this->layout = false ;
		$icd= explode(',',$icd);
			
		$snomedid = $icd[1];
		$diagnosis_name = $icd[2];
		$icd= $icd[0];
			
		$this->uses = array('icds','Patient','NoteDiagnosis','DiagnosisMaster');
		
		$edit_makediagnosis=$this->NoteDiagnosis->find('all',array('conditions'=>array('patient_id'=>$id,'icd_id'=>$icd)));
		$this->set('edit_makediagnosis',$edit_makediagnosis);


		$p_name  = $this->Patient->find('all',array('fields'=>array('lookup_name', 'patient_id'),'conditions'=>array('id'=>$id)));
		$icd1[0][icds][p_name] = $p_name['0']['Patient']['lookup_name'];
		$icd1[0][icds][p_id] = $id;
		$icd1[0][icds][note_id] = $note_id;
		$icd1[0][icds][icd_snomed] = $icd;
		$icd1[0][icds][icd_description] = $diagnosis_name;
		$icd1[0][icds][icd_snomedid] = $snomedid;
		$this->set('icd', $icd1);

		$this->set('u_id',$p_name['0']['Patient']['patient_id']);
		//--------------------------------------------aditya snomed code-----------------------------------------------------------------------------------

		$edit_makediagnosis_count=$this->NoteDiagnosis->find('count' ,array('conditions'=>array('patient_id'=>$id,'icd_id'=>$icd)));
		$edit_makediagnosis=$this->NoteDiagnosis->find('all',array('conditions'=>array('patient_id'=>$id,'icd_id'=>$icd)));
		$this->set('edit_makediagnosis',$edit_makediagnosis);

		$check_diagnosis=$this->NoteDiagnosis->find('all' ,array('conditions'=>array('patient_id'=>$id)));
		foreach($check_diagnosis as $check_diagnosiss){
			$getdata.=$check_diagnosiss['NoteDiagnosis']['icd_id']."|";
		}
		$getdata=explode("|",$getdata);
		if(in_array($icd,$getdata)){
			echo "Patient Diagnosis Already Exists";
			return $this->redirect(array('controller' => 'Diagnoses', 'action' => 'diagnosis_exist',$id));
		}

		if(!empty($this->request->data)){
			if($edit_makediagnosis_count > 0){

				$start_dt= $this->DateFormat->formatDate2STD($this->request->data[start_dt],Configure::read('date_format'));
				$start_dt = substr($start_dt,0,10);

				$end_dt=  $this->DateFormat->formatDate2STD($this->request->data[end_dt],Configure::read('date_format'));
				$end_dt = substr($end_dt,0,10);
				$comment=  $this->request->data[comment];
				$snowmedid=$icd1[0][icds][icd_snomedid];
				$prev_comment=  $this->request->data[prev_comment];
				$name= $icd1[0][icds][icd_description];
				$disease_status=  $this->request->data[disease_status];
				$u_id= $p_name['0']['Patient']['patient_id'];
					
				$preffered_icd9cm= $this->request->data[preffered_icd9cm];

				$this->NoteDiagnosis->updateAll(array('start_dt'=>"'$start_dt'",'end_dt'=>"'$end_dt'",'patient_id'=>"$id",

						'comment'=>"'$comment'",'diagnoses_name'=>"'$name'",'preffered_icd9cm'=>"'$preffered_icd9cm'",
						'prev_comment'=>"'$prev_comment'",'snowmedid'=>"'$snowmedid'",'u_id'=>"'$u_id'",'disease_status'=>"'$disease_status'"),array('patient_id'=>$id,'icd_id'=>$icd));


			}
			else {
				if($icd1[0][icds][icd_description]!=''){

					$start_dt= $this->DateFormat->formatDate2STD($this->request->data[start_dt],Configure::read('date_format'));
					$start_dt = substr($start_dt,0,10);
					$end_dt=  $this->DateFormat->formatDate2STD($this->request->data[end_dt],Configure::read('date_format'));
					$start_dt = substr($start_dt,0,10);
					$comment=  $this->request->data['comment'];
					$snowmedid=  $icd1[0][icds][icd_snomedid];
					$prev_comment=  $this->request->data['prev_comment'];
					$name=$icd1[0][icds][icd_description];
					$trim_name=trim($name);

					$preffered_icd9cm= $this->request->data['preffered_icd9cm'];
					$disease_status=  $this->request->data['disease_status'];
					$u_id=$p_name['0']['Patient']['patient_id'];

					$this->NoteDiagnosis->saveAll(array('start_dt'=>"$start_dt",'end_dt'=>"$end_dt",'patient_id'=>"$id",
							'comment'=>"$comment",'icd_id'=>"$icd",'disease_status'=>"$disease_status",'u_id'=>"$u_id",'diagnoses_name'=>"$trim_name",'preffered_icd9cm'=>"$preffered_icd9cm",
							'prev_comment'=>"$prev_comment",'snowmedid'=>"$snowmedid",'is_reported_patient' =>"1"));

					//--------insert note_id ---
					$lastId=$this->NoteDiagnosis->getLastInsertID();
					$data = $this->Session->read('makeDignosis');
					$data[] = $lastId;

					$this->Session->write('makeDignosis', $data);
					//-eof--
				}
			}
		}
			
	}
	//end of patient

	//------EOF---Gaurav---------
	/**
	 * $perpose print first section page of patient diagnosis form
	 * @param $patient_id
	 * @return unknown_type
	 */

	public function print_first_page($patient_id=null){

		$this->layout = 'print_with_header' ;
		
		$this->set('title_for_layout', __('-Print Patient Diagnosis', true));
		//load model
		$this->uses = array('Patient','Person','Diagnosis','DiagnosisDrug','icd','Bed','BmiResult','BmiBpResult',
				'PatientPastHistory','PatientPersonalHistory','PatientFamilyHistory','PatientAllergy');

		/*$this->Patient->bindModel(array(
		 'belongsTo' => array(
		 		'Initial' =>array('foreignKey'=>'initial_id'),
		 )));
		$patient_details     = $this->Patient->getPatientDetailsByID($patient_id);
		$UIDpatient_details  = $this->Person->getUIDPatientDetailsByPatientID($patient_id);
		$formatted_address   = $this->Patient->setAddressFormat($UIDpatient_details['Person']);
		//retrive bed no and prefix
		$this->Bed->bindModel(array(
				'belongsTo' => array(
						'Room' =>array('foreignKey'=>'room_id'),
				)));
		$bed_no  = $this->Bed->find('first',array('fields'=>array('CONCAT(Room.bed_prefix,Bed.bedno) as bed_no'),'conditions'=>array('Bed.id'=>$patient_details['Patient']['bed_id'],'Bed.location_id'=>$this->Session->read('locationid'))));

		$this->set(array('address'=>$formatted_address,'patient'=>$patient_details,'patientUID'=>$UIDpatient_details['Person']['patient_uid'],'bed'=>$bed_no));
		*/
		$this->patient_info($patient_id);
		//check if patient record is exist
		$this->Diagnosis->bindModel( array(
				'belongsTo' => array(
						'PatientAllergy'=>array('conditions'=>array('Diagnosis.id=PatientAllergy.diagnosis_id'),'foreignKey'=>false),
						'PatientPersonalHistory'=>array('conditions'=>array('Diagnosis.id=PatientPersonalHistory.diagnosis_id'),'foreignKey'=>false),
						'PatientPastHistory'=>array('conditions'=>array('Diagnosis.id=PatientPastHistory.diagnosis_id'),'foreignKey'=>false),
						'PatientFamilyHistory'=>array('conditions'=>array('Diagnosis.id=PatientFamilyHistory.diagnosis_id'),'foreignKey'=>false),
						
						'PastMedicalRecord'=>array('conditions'=>array('PastMedicalRecord.patient_id'=>$patient_id),'foreignKey'=>false),
						'FamilyHistory'=>array('conditions'=>array('FamilyHistory.patient_id'=>$patient_id),'foreignKey'=>false),
						'PatientSmoking'=>array('conditions'=>array('Diagnosis.id=PatientSmoking.diagnosis_id'),'foreignKey'=>false),
						'SmokingStatusOncs'=>array('className'=>'SmokingStatusOncs','conditions'=>array('PatientPersonalHistory.smoking_fre=SmokingStatusOncs.id'),'foreignKey'=>false),
						'SmokingStatusOncs1'=>array('conditions'=>array('PatientSmoking.current_smoking_fre=SmokingStatusOncs1.id'),
										'className'=>'SmokingStatusOncs','foreignKey'=>false),
						'BmiResult'=>array('conditions'=>array('BmiResult.patient_id'=>$patient_id),'foreignKey'=>false),
				),
				'hasMany'=>array(
						'NewCropPrescription'=>array('conditions'=>array('NewCropPrescription.patient_uniqueid'=>$patient_id),'foreignKey'=>false),
						'ProcedureHistory'=>array('conditions'=>array('ProcedureHistory.patient_id'=>$patient_id),'foreignKey'=>false),
						'PregnancyCount'=>array('conditions'=>array('PregnancyCount.patient_id'=>$patient_id),'order'=>array('PregnancyCount.counts Asc'),'foreignKey'=>false),
						'PastMedicalHistory'=>array('conditions'=>array('PastMedicalHistory.patient_id'=>$patient_id),'foreignKey'=>false),)
				
			));
			$diagnosisRec = $this->Diagnosis->find('first',array('fields'=>array('PatientAllergy.*','PatientPersonalHistory.*','PatientPastHistory.*',
					'PatientFamilyHistory.*','PastMedicalRecord.*','FamilyHistory.*','PatientPersonalHistory.*','BmiResult.*',
				'PatientSmoking.*','SmokingStatusOncs.*','SmokingStatusOncs1.*','complaints','lab_report','final_diagnosis'),
					'conditions'=>array('Diagnosis.patient_id'=>$patient_id)));
			//debug($diagnosisRec);//exit;
		$diagnosisDrugRec = $this->DiagnosisDrug->find('all',array('fields'=>array('DiagnosisDrug.mode,DiagnosisDrug.tabs_per_day,DiagnosisDrug.tabs_frequency,DiagnosisDrug.mode,DiagnosisDrug.quantity,PharmacyItem.name,PharmacyItem.pack'),'conditions'=>array('diagnosis_id'=>$diagnosisRec['Diagnosis']['id'])));
		
		
		$this->set('icd_ids',array());

		if(!empty($diagnosisRec['Diagnosis']['ICD_code'])){
			$splitICD = explode('|',$diagnosisRec['Diagnosis']['ICD_code']);
			$arrLength  =count($splitICD);
			unset($splitICD[$arrLength-1]);//empty value is there
			//$attachedICD = implode("::",$splitICD) ;
			$attachedICD = explode("::",$splitICD[0]) ;
			
			$icdArray  = $this->icd->find('all',array('fields'=>array('id','icd_code','description'),'conditions'=>array("id in (".$attachedICD[0].")")));
			$this->set('icd_ids',$icdArray);
		}
		$count = count($diagnosisDrugRec);

		if($diagnosisRec){
			if($count){
				for($i=0;$i<$count;){
					$diagnosisRec['drug'][$i]  = $diagnosisDrugRec[$i]['PharmacyItem']['name'];
					$diagnosisRec['pack'][$i]  = $diagnosisDrugRec[$i]['PharmacyItem']['pack'];
					$diagnosisRec['mode'][$i]  = $diagnosisDrugRec[$i]['DiagnosisDrug']['mode'];
					$diagnosisRec['tabs_per_day'][$i]  = $diagnosisDrugRec[$i]['DiagnosisDrug']['tabs_per_day'];
					$diagnosisRec['tabs_frequency'][$i]  = $diagnosisDrugRec[$i]['DiagnosisDrug']['tabs_frequency'];
					$diagnosisRec['quantity'][$i]  = $diagnosisDrugRec[$i]['DiagnosisDrug']['quantity'];
					$i++;
				}
			}

			//convert date to local format
			if(!empty($diagnosisRec['Diagnosis']['next_visit'])){
				$diagnosisRec['Diagnosis']['next_visit'] = $this->DateFormat->formatDate2Local($diagnosisRec['Diagnosis']['next_visit'],Configure::read('date_format'));
			}
			if(!empty($this->request->data["Diagnosis"]['register_on'])){
				$diagnosisRec['Diagnosis']['register_on'] = $this->DateFormat->formatDate2Local($diagnosisRec['Diagnosis']['register_on'],Configure::read('date_format'));
			}
			if(!empty($this->request->data["Diagnosis"]['consultant_on'])){
				$diagnosisRec['Diagnosis']['consultant_on'] = $this->DateFormat->formatDate2Local($diagnosisRec['Diagnosis']['consultant_on'],Configure::read('date_format'));
			}
			//remove since and frequency word if any
//debug($diagnosisRec);exit;
			$this->set('diagnosis',$diagnosisRec) ;
			
			//my code
/*			$this->ProcedureHistory->bindModel( array(
					'belongsTo' => array(
							'DoctorProfile'=>array('foreignKey'=>false,'conditions'=>array('ProcedureHistory.provider=DoctorProfile.id')),
							'TariffList'=>array('foreignKey'=>false,'conditions'=>array('ProcedureHistory.procedure=TariffList.id')),
					)));
				
			$procedureHistoryRec = $this->ProcedureHistory->find('all',array('fields'=>array('TariffList.id','TariffList.name','DoctorProfile.id',
					'DoctorProfile.doctor_name','ProcedureHistory.procedure','ProcedureHistory.provider','ProcedureHistory.age_value','ProcedureHistory.age_unit',
					'ProcedureHistory.procedure_date','ProcedureHistory.comment','ProcedureHistory.procedure_name','ProcedureHistory.provider_name'),
					'conditions'=>array('ProcedureHistory.patient_id'=>$patient_id),'order'=>array('ProcedureHistory.id Asc')));
				
			$this->set('procedureHistory',$procedureHistoryRec);*/
			
		/*	$preventive_care="Preventive Care :";
			$subjectiveText="";
			$patienttext="The patient ";
			
			if(!empty($diagnosisRec)){
				if(!empty($diagnosisRec['PastMedicalHistory']['0']['illness'])){
					$subjectiveText.="The patient has below illness<br><br>";
					foreach($diagnosisRec['PastMedicalHistory'] as $history){
						if(empty($history['illness']))
							continue;
			
						$subjectiveText.= $history['illness']." and it's status is: ".$history['status']."<br>";
			
					}
			
				}
			}
			echo $subjectiveText;
			//exit;*/
			
		}
	}
	/**
	 * @perpose print second section of patient diagnosis form
	 * @param $patient_id
	 * @return unknown_type
	 */
	public function print_second_page($patient_id=null){
			
		$this->layout = 'print_with_header' ;
		$this->set('title_for_layout', __('-Print Patient Diagnosis', true));
		//load model
		$this->uses = array('SnomedMappingMaster','Patient','Person','Diagnosis','DiagnosisDrug','icd','PatientPastHistory','PatientPersonalHistory',
				'PatientFamilyHistory','PatientAllergy','DoctorProfile', 'Consultant','LaboratoryTestOrder','Laboratory','RadiologyTestOrder','Radiology');
			
		//BOF Laboratory
		$this->LaboratoryTestOrder->bindModel(array(
				'belongsTo' => array('Laboratory'=>array('foreignKey'=>'laboratory_id',
						'conditions'=>array('Laboratory.is_active'=>1,'Laboratory.location_id'=>$this->Session->read('locationid'))),
						'ServiceProvider'=>array('foreignKey'=>'service_provider_id')
				),
				'hasOne' => array('LaboratoryResult'=>array('foreignKey'=>'laboratory_test_order_id')
				)),false);

		$testOrdered= $this->LaboratoryTestOrder->find('all',array('fields'=>array('LaboratoryTestOrder.is_external','LaboratoryResult.confirm_result','LaboratoryTestOrder.id',
				'LaboratoryTestOrder.create_time','LaboratoryTestOrder.order_id','Laboratory.id','Laboratory.name','ServiceProvider.*'),
				'conditions'=>array('LaboratoryTestOrder.patient_id'=>$patient_id,'LaboratoryTestOrder.is_deleted'=>0,'LaboratoryTestOrder.from_assessment'=>1),
				'order' => array('LaboratoryTestOrder.id' => 'asc'),
				'group'=>array('LaboratoryTestOrder.order_id')));
		$this->set("test_ordered",$testOrdered);
		//EOF Laboratory
			
		//BOF Radiology
		$this->RadiologyTestOrder->bindModel(array(
				'belongsTo' => array(
						'Radiology'=>array('foreignKey'=>'radiology_id','conditions'=>array('Radiology.is_active'=>1,'Radiology.location_id'=>$this->Session->read('locationid'))),
						'ServiceProvider'=>array('foreignKey'=>'service_provider_id')
				),
				'hasOne' => array(
						'RadiologyResult'=>array('foreignKey'=>'radiology_test_order_id')
				)),false);
			
		$radiologyTestOrdered= $this->RadiologyTestOrder->find('all',array('fields'=>array('RadiologyTestOrder.is_external','RadiologyResult.confirm_result',
				'RadiologyTestOrder.id','RadiologyTestOrder.create_time'
				,'RadiologyTestOrder.order_id','Radiology.id','Radiology.name','ServiceProvider.*'),
				'conditions'=>array('RadiologyTestOrder.patient_id'=>$patient_id,'RadiologyTestOrder.is_deleted'=>0,'RadiologyTestOrder.from_assessment'=>1),
				'order' => array('RadiologyTestOrder.id' => 'asc'),
				'group'=>array('RadiologyTestOrder.order_id')));
		$this->set("radiologyTestOrdered",$radiologyTestOrdered);
		//EOF Radiology
			
		$this->patient_info($patient_id);
		//check if patient record is exist
		$this->Diagnosis->bindModel( array(
				'belongsTo' => array(
						'PatientAllergy'=>array('conditions'=>array('Diagnosis.id=PatientAllergy.diagnosis_id'),'foreignKey'=>false),
						'PatientPersonalHistory'=>array('conditions'=>array('Diagnosis.id=PatientPersonalHistory.diagnosis_id'),'foreignKey'=>false),
						'PatientPastHistory'=>array('conditions'=>array('Diagnosis.id=PatientPastHistory.diagnosis_id'),'foreignKey'=>false),
						'PatientFamilyHistory'=>array('conditions'=>array('Diagnosis.id=PatientFamilyHistory.diagnosis_id'),'foreignKey'=>false),
						// 'DoctorProfile'=>array('conditions'=>array('DoctorProfile.user_id=Diagnosis.register_sb'),'foreignKey'=>false),
						//  'User'=>array('conditions'=>array('User.id=Diagnosis.consultant_sb'),'foreignKey'=>false)
				)
		));
		$diagnosisRec = $this->Diagnosis->find('first',array('conditions'=>array('patient_id'=>$patient_id)));
			
		$diagnosisDrugRec = $this->DiagnosisDrug->find('all',array('fields'=>array('DiagnosisDrug.mode,DiagnosisDrug.tabs_per_day,DiagnosisDrug.mode,PharmacyItem.name'),'conditions'=>array('diagnosis_id'=>$diagnosisRec['Diagnosis']['id'])));
		$this->set('icd_ids',array());
		$splitIcdNew = array();
		if(!empty($diagnosisRec['Diagnosis']['ICD_code'])){
			$splitICD = explode('|',$diagnosisRec['Diagnosis']['ICD_code']);
			foreach($splitICD as $key=>$splitIcd){
				$first = explode("::",$splitIcd);
				if($first[0]){
					array_push($splitIcdNew, $first[0]);
				}
			}
			//$arrLength  =count($splitICD);
			//unset($splitICD[$arrLength-1]);//empty value is there

			//$attachedICD = implode(",",$splitIcd) ;
			$icdArray  = $this->SnomedMappingMaster->find('all',array('fields'=>array('id as id','mapCategoryValueId as icd_code','sctName as description'),'conditions'=>array('id'=>$splitIcdNew)));
			
			$this->set('icd_ids',$icdArray);
		}
		$count = count($diagnosisDrugRec);

		if($diagnosisRec){
			if($count){
				for($i=0;$i<$count;){
					$diagnosisRec['drug'][$i]  = $diagnosisDrugRec[$i]['PharmacyItem']['name'];
					$diagnosisRec['mode'][$i]  = $diagnosisDrugRec[$i]['DiagnosisDrug']['mode'];
					$diagnosisRec['tabs_per_day'][$i]  = $diagnosisDrugRec[$i]['DiagnosisDrug']['tabs_per_day'];
					$i++;
				}
			}
			//convert date to local format
			if(!empty($diagnosisRec['Diagnosis']['next_visit'])){
				$diagnosisRec['Diagnosis']['next_visit'] = $this->DateFormat->formatDate2Local($diagnosisRec['Diagnosis']['next_visit'],Configure::read('date_format'));
			}
			if(!empty($this->request->data["Diagnosis"]['register_on'])){
				$diagnosisRec['Diagnosis']['register_on'] = $this->DateFormat->formatDate2Local($diagnosisRec['Diagnosis']['register_on'],Configure::read('date_format'));
			}
			if(!empty($this->request->data["Diagnosis"]['consultant_on'])){
				$diagnosisRec['Diagnosis']['consultant_on'] = $this->DateFormat->formatDate2Local($diagnosisRec['Diagnosis']['consultant_on'],Configure::read('date_format'));
			}
			$this->set('diagnosis',$diagnosisRec) ;
		}
		//doctor and registrar name

		$this->set('registrar',$this->DoctorProfile->getDoctorByID($diagnosisRec['Diagnosis']['register_sb']));
		$this->set('consultant',$this->DoctorProfile->getDoctorByID($diagnosisRec['Diagnosis']['consultant_sb']));
			

	}

	//function to print assessment details for OPD only
	function print_opd_assessment($patient_id){
		$this->print_second_page($patient_id);
	}

	/* fetch the prescription details of a patient based on UID*/
	public function get_prescribed_detail(){
		$this->uses = array('Patient','Diagnosis','DischargeDrug','icd','DischargeSummary','Person',"Note",'Person','NewCropPrescription');
		$patient_id = $this->request->data['uid'];
		$result=array();
		$data ='';
		//debug($this->request->data);exit;
		if(isset($this->request->data['id'])){
			$Patient = $this->Patient->find('first',array('conditions'=>array('Patient.admission_id'=>$patient_id,'Patient.location_id'=>$this->Session->read('locationid'),'Patient.is_discharge'=>0,'Patient.is_deleted'=>0)));
			array_push($result,$Patient);
			if($this->request->data['model'] == "Note"){
				$this->Note->bindModel(array('belongsTo' => array(
						'Doctor' =>array('foreignKey'=>'sb_registrar'),
						'Initial' =>array('foreignKey'=>false,"conditions"=>array("Initial.id = Doctor.initial_id"))
				),
						'hasMany' => array(
								'NewCropPrescription' =>array('foreignKey'=>'note_id')
						),
				),false);
				$data = $this->Note->find("first",array("conditions"=>array('Note.id'=>$this->request->data['id'])));
			}else{
					
				$this->Diagnosis->bindModel(array('belongsTo' => array(
						'Patient' =>array('foreignKey'=>'patient_id'),
						'Doctor' =>array('foreignKey'=>'consultant_sb'),
						'Initial' =>array('foreignKey'=>false,"conditions"=>array("Initial.id = Doctor.initial_id"))
				),
						'hasMany' => array(
								'DiagnosisDrug' =>array('foreignKey'=>'diagnosis_id')
						),
				),false);

				$data = $this->Diagnosis->find("first",array('conditions'=>array('Diagnosis.id'=>$this->request->data['id'])));

			}
			array_push($result,$data);
		}else{


			//$this->Person->bindModel(array('belongsTo'=>array('Patient'=>array('foreignKey'=>false,'conditions'=>array("Person.patient_uid=Patient.patient_id")))));
			//$person = $this->Person->find('first', array('conditions'=>array('Person.patient_uid'=>$patient_id,'Patient.is_discharge'=>0)));
			$Patient = $this->Patient->find('first',array('conditions'=>array('Patient.admission_id'=>$patient_id,'Patient.location_id'=>$this->Session->read('locationid'),'Patient.is_discharge'=>0,'Patient.is_deleted'=>0)));
			array_push($result,$Patient);

			$this->Note->bindModel(array('belongsTo' => array(
					'Doctor' =>array('foreignKey'=>'sb_registrar'),
			),
					'hasMany' => array(
							'NewCropPrescription' =>array('foreignKey'=>'note_id')
					),
			),false);
			$data = $this->Note->find("first",array("conditions"=>array('Note.patient_id'=>$Patient['Patient']['id'])));
			array_push($result,$data);


		}

		echo json_encode($result);exit;
	}
	//---------BOF ---Gaurav
	function investigation($patient_id){
		$this->layout= false ;
		$this->uses = array('ServiceProvider','Person','Patient','ServiceProvider','Consultant','User','LaboratoryTestOrder',
				'LaboratoryResult','RadiologyTestOrder','Radiology','Laboratory','SpecimenCondition','SpecimenRejection','SpecimenType','SpecimenAction','LaboratoryToken','EKG');

		// for EKG
		$ekgData  = $this->EKG->find('all',array('conditions'=>array('patient_id'=>$patient_id,'is_deleted'=>0)));
		$this->set('ekgData',$ekgData);
	//$this->data=$ekgData;
		/* $this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'fields'=>array('EKG.id','EKG.history','EKG.cardiac_medication','EKG.pacemaker','EKG.check_one','EKG.assignment_accepted'),
				'conditions'=>array('patient_id'=>$patient_id,'is_deleted'=>0),
			);
		$ekgData   = $this->paginate('EKG'); */
		
		//calling service provider for labs
		$this->set('serviceProviders',$this->ServiceProvider->getServiceProvider('radiology'));
		//BOF code from radiology controller
		$dept  =  isset($this->params->query['dept'])? $this->params->query['dept']:'';
		$testDetails = $this->RadiologyTestOrder->find('count',array('conditions'=>array('patient_id'=>$patient_id,'RadiologyTestOrder.from_assessment'=>0)));
		if($testDetails){
			//BOF new code
			$testArray = $testDetails['RadiologyTestOrder']['radiology_id'];
			$this->RadiologyTestOrder->bindModel(array(
					'belongsTo' => array(
							'Radiology'=>array('foreignKey'=>'radiology_id' ),
					),
					'hasOne' => array(
							'RadiologyResult'=>array('foreignKey'=>'radiology_test_order_id')
					)),false);

			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'fields'=>array('RadiologyTestOrder.batch_identifier','RadiologyResult.confirm_result','RadiologyTestOrder.id','RadiologyTestOrder.create_time','RadiologyTestOrder.start_date','RadiologyTestOrder.status','RadiologyTestOrder.order_id','RadiologyTestOrder.radiology_id','Radiology.name','Radiology.lonic_code','Radiology.cpt_code'),
					'conditions'=>array('RadiologyTestOrder.patient_id'=>$patient_id,'RadiologyTestOrder.is_deleted'=>0,'RadiologyTestOrder.from_assessment'=>0),
					'order' => array(
							'RadiologyTestOrder.name' => 'asc'
					),
					'group'=>array('RadiologyTestOrder.order_id')
			);
			$testOrdered   = $this->paginate('RadiologyTestOrder');
			//	$TestOrderedlabId = implode(',',$this->RadiologyTestOrder->find('list',array('fields'=>array('radiology_id'),'conditions'=>array('RadiologyTestOrder.patient_id'=>$patient_id,'RadiologyTestOrder.is_deleted'=>0,'RadiologyTestOrder.from_assessment'=>1))));

			//	$labTest  = $this->Radiology->find('list',array('fields'=>array('Radiology.id','Radiology.name'),'conditions'=>array('is_active'=>1,'Radiology.location_id'=>$this->Session->read('locationid'))));


			//EOD new code
		}else{
			/*	$labTest  = $this->Radiology->find('list',array('fields'=>array('id','name'),'order'=>'Radiology.name',
			 'conditions'=>array('is_active'=>1,'Radiology.location_id'=>$this->Session->read('locationid'))));*/
			$testOrdered ='';
		}
		$this->set(array('radiology_test_ordered'=>$testOrdered));

		//EOF code form radiology controllerk

		//BOF code for lab listing
		$testDetails = $this->LaboratoryTestOrder->find('count',array('conditions'=>array('patient_id'=>$patient_id)));
		//echo'>>';pr($testDetails);
		//calling service provider for labs
		//$this->set('serviceProviders',$this->ServiceProvider->getServiceProvider('lab'));
		if($testDetails){
			$testArray = $testDetails['LaboratoryTestOrder']['laboratory_id'];
		
			$this->LaboratoryTestOrder->bindModel(array(
					'belongsTo' => array(
							'Laboratory'=>array('foreignKey'=>'laboratory_id',
									'conditions'=>array('Laboratory.is_active'=>1))
							//'conditions'=>array('Laboratory.is_active'=>1,'Laboratory.location_id'=>$this->Session->read('locationid')))
					),
					'hasOne' => array(
							'LaboratoryResult'=>array('foreignKey'=>'laboratory_test_order_id'),
							//		'SpecimenType'=>array('foreignKey'=>false,'conditions'=>array('SpecimenType.id'=>'LaboratoryToken.specimen_type_id')),
					),
					'hasMany' => array(
							'LaboratoryToken'=>array('foreignKey'=>'laboratory_test_order_id'),
							//		'SpecimenType'=>array('foreignKey'=>false,'conditions' => array('LaboratoryToken.specimen_type_id'=>'SpecimenType.id'))
					),false));
			/*$testOrdered = $this->LaboratoryTestOrder->find('list',array('fields'=>array('Laboratory.id','Laboratory.name'),'conditions'=>array('LaboratoryTestOrder.patient_id'=>$patient_id),"recursive" => 1 ));*/

			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'fields'=>array('LaboratoryTestOrder.batch_identifier','LaboratoryResult.confirm_result','LaboratoryTestOrder.id','LaboratoryTestOrder.start_date',
							'LaboratoryTestOrder.lab_order','LaboratoryTestOrder.lab_order_date','LaboratoryTestOrder.order_id','Laboratory.id','Laboratory.name',
							'Laboratory.lonic_code'),
					'conditions'=>array('LaboratoryTestOrder.patient_id'=>$patient_id,'LaboratoryTestOrder.is_deleted'=>0),
					'order' => array(
							'LaboratoryTestOrder.name' => 'asc'
					),
					'group'=>array('LaboratoryTestOrder.order_id')
			);
			$testOrdered   = $this->paginate('LaboratoryTestOrder');
			$TestOrderedlabId = implode(',',$this->LaboratoryTestOrder->find('list',array('fields'=>array('laboratory_id'),'conditions'=>array('LaboratoryTestOrder.patient_id'=>$patient_id,'LaboratoryTestOrder.is_deleted'=>0))));


			//$users = $this->User->find("all",array('fields'=>array('Initial.name','first_name','last_name','Role.name'),'conditions'=>array("(User.is_deleted = '0' and User.location_id = '".$this->Session->read('locationid')."') and (Role.name !='superadmin' and Role.name !='admin')"),'group'=>'User.id'));
			//for($k=0;$k<count($users);$k++){
			//$usernames[] = $users[$k][Initial][name].$users[$k][User][first_name].$users[$k][User][last_name]."(".$users[$k][Role][name].")";
			//}
			$this->set('users', $usernames);


			//$labTest  = $this->Laboratory->find('list',array('fields'=>array('Laboratory.id','Laboratory.name','Laboratory.test_code','lonic_code','sct_concept_id'),'order' => array('Laboratory.name ASC'),'group'=>'Laboratory.name'));
			$radTest  = $this->Radiology->find('list',array('fields'=>array('Radiology.id','Radiology.name','Radiology.test_code','lonic_code','sct_concept_id'),'order' => array('Radiology.name ASC')));
			$spec_rej  = $this->SpecimenRejection->find('list',array('fields'=>array('SpecimenRejection.description','SpecimenRejection.description'),'order' => array('SpecimenRejection.description ASC')));
			$spec_cond  = $this->SpecimenCondition->find('list',array('fields'=>array('SpecimenCondition.description','SpecimenCondition.description'),'order' => array('SpecimenCondition.description ASC')));
			$spec_type  = $this->SpecimenType->find('list',array('fields'=>array('SpecimenType.description','SpecimenType.description'),'order' => array('SpecimenType.description ASC')));
			$spec_action  = $this->SpecimenAction->find('list',array('fields'=>array('SpecimenAction.description','SpecimenAction.description'),'order' => array('SpecimenAction.description ASC')));
			//EOF laboratories

		}else{


			$this->Laboratory->virtualFields =  array('name'=>'CONCAT(Laboratory.name," ",IFNULL(Laboratory.test_code," ")," ",IFNULL(Laboratory.lonic_code," "))') ;


			/* 	$labTest  = $this->Laboratory->find('all',array('fields'=>array('id',$virtualFields),'order'=>'Laboratory.name',
			 'conditions'=>array('is_active'=>1,'Laboratory.location_id'=>$this->Session->read('locationid')))); */

			//$labTest = $this->Laboratory->find('list',array('group'=>'Laboratory.name'));//array('conditions'=>array('is_active'=>1,'Laboratory.location_id'=>$this->Session->read('locationid')))
			//asort($labTest);

			$radTest  = $this->Radiology->find('list',array('fields'=>array('Radiology.id','Radiology.name','Radiology.test_code','lonic_code','sct_concept_id'),'order' => array('Radiology.name ASC')));
			$spec_rej  = $this->SpecimenRejection->find('list',array('fields'=>array('SpecimenRejection.description','SpecimenRejection.description'),'order' => array('SpecimenRejection.description ASC')));
			$spec_cond  = $this->SpecimenCondition->find('list',array('fields'=>array('SpecimenCondition.description','SpecimenCondition.description'),'order' => array('SpecimenCondition.description ASC')));
			$spec_type  = $this->SpecimenType->find('list',array('fields'=>array('SpecimenType.description','SpecimenType.description'),'order' => array('SpecimenType.description ASC')));
			$spec_action  = $this->SpecimenAction->find('list',array('fields'=>array('SpecimenAction.description','SpecimenAction.description'),'order' => array('SpecimenAction.description ASC')));
			$testOrdered ='';
			
		}
		$serviceProviders = $this->ServiceProvider->find('list',array('fields' => array('id','name'),'conditions'=>array('category'=>'lab','location_id'=>$this->Session->read('locationid'),'status'=>1,'is_deleted'=>0)));
		$this->set('serviceProviders',$serviceProviders);
		$this->set(array('test_data'=>$labTest,'rad_data'=>$radTest,'test_ordered'=>$testOrdered));
		$this->set(compact('patient_id','spec_rej','spec_cond','spec_type','spec_action')) ;

	}


	function investigationdashboard($patient_id){


		$this->layout= false ;
		$this->uses = array('Person','Patient','ServiceProvider','Consultant','User','LaboratoryTestOrder',
				'LaboratoryResult','RadiologyTestOrder','Radiology','Laboratory','SpecimenCondition','SpecimenRejection','SpecimenType','SpecimenAction','LaboratoryToken','Hl7Result');


		$this->LaboratoryTestOrder->bindModel(array(
				'belongsTo' => array(
						'LaboratoryToken'=>array('foreignKey'=>false,'conditions'=>array('LaboratoryToken.laboratory_test_order_id=LaboratoryTestOrder.id')))));

		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'fields'=>array('LaboratoryTestOrder.order_id','LaboratoryToken.laboratory_id','LaboratoryTestOrder.create_time'),
				'conditions'=>array('LaboratoryTestOrder.patient_id'=>$patient_id),
				'order' => array(
						'LaboratoryToken.laboratory_id' => 'asc'
				));
		$testOrdered_lab   = $this->paginate('LaboratoryTestOrder');
		$this->set('testOrdered_lab',$testOrdered_lab);


		$this->set(array('radiology_test_data'=>$labTest,'radiology_test_ordered'=>$testOrdered));

		//EOF code form radiology controller

		//BOF code for lab listing
		$testDetails = $this->LaboratoryTestOrder->find('count',array('conditions'=>array('patient_id'=>$patient_id,'LaboratoryTestOrder.from_assessment'=>1)));
		//calling service provider for labs
		$this->set('serviceProviders',$this->ServiceProvider->getServiceProvider('lab'));
		if($testDetails){
			$testArray = $testDetails['LaboratoryTestOrder']['laboratory_id'];
			$this->LaboratoryTestOrder->bindModel(array(
					'belongsTo' => array(
							'Laboratory'=>array('foreignKey'=>'laboratory_id','conditions'=>array('Laboratory.is_active'=>1,'Laboratory.location_id'=>$this->Session->read('locationid')))
					),
					'hasOne' => array(
							'LaboratoryResult'=>array('foreignKey'=>'laboratory_test_order_id'),
							//		'SpecimenType'=>array('foreignKey'=>false,'conditions'=>array('SpecimenType.id'=>'LaboratoryToken.specimen_type_id')),
					),
					'hasMany' => array(
							'LaboratoryToken'=>array('foreignKey'=>'laboratory_test_order_id'),
							//		'SpecimenType'=>array('foreignKey'=>false,'conditions' => array('LaboratoryToken.specimen_type_id'=>'SpecimenType.id'))
					),false));
			/*$testOrdered = $this->LaboratoryTestOrder->find('list',array('fields'=>array('Laboratory.id','Laboratory.name'),'conditions'=>array('LaboratoryTestOrder.patient_id'=>$patient_id),"recursive" => 1 ));*/

			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'fields'=>array('LaboratoryTestOrder.batch_identifier','LaboratoryResult.confirm_result','LaboratoryTestOrder.id','LaboratoryTestOrder.create_time','LaboratoryTestOrder.order_id','Laboratory.id','Laboratory.name'),
					'conditions'=>array('LaboratoryTestOrder.patient_id'=>$patient_id,'LaboratoryTestOrder.is_deleted'=>0,'LaboratoryTestOrder.from_assessment'=>1),
					'order' => array(
							'LaboratoryTestOrder.name' => 'asc'
					),
					'group'=>array('LaboratoryTestOrder.order_id')
			);
			$testOrdered   = $this->paginate('LaboratoryTestOrder');

			$TestOrderedlabId = implode(',',$this->LaboratoryTestOrder->find('list',array('fields'=>array('laboratory_id'),'conditions'=>array('LaboratoryTestOrder.patient_id'=>$patient_id,'LaboratoryTestOrder.is_deleted'=>0))));

			$labTest  = $this->Laboratory->find('list',array('fields'=>array('Laboratory.id','Laboratory.name'),'conditions'=>array('is_active'=>1,'Laboratory.location_id'=>$this->Session->read('locationid'))));
			$spec_rej  = $this->SpecimenRejection->find('list',array('fields'=>array('SpecimenRejection.description','SpecimenRejection.description')));
			$spec_cond  = $this->SpecimenCondition->find('list',array('fields'=>array('SpecimenCondition.description','SpecimenCondition.description')));
			$spec_type  = $this->SpecimenType->find('list',array('fields'=>array('SpecimenType.description','SpecimenType.description')));
			$spec_action  = $this->SpecimenAction->find('list',array('fields'=>array('SpecimenAction.description','SpecimenAction.description')));
			//EOF laboratories

		}else{
			$labTest  = $this->Laboratory->find('list',array('fields'=>array('id','name'),'order'=>'Laboratory.name',
					'conditions'=>array('is_active'=>1,'Laboratory.location_id'=>$this->Session->read('locationid'))));
			$spec_rej  = $this->SpecimenRejection->find('list',array('fields'=>array('SpecimenRejection.description','SpecimenRejection.description')));
			$spec_cond  = $this->SpecimenCondition->find('list',array('fields'=>array('SpecimenCondition.description','SpecimenCondition.description')));
			$spec_type  = $this->SpecimenType->find('list',array('fields'=>array('SpecimenType.description','SpecimenType.description')));
			$spec_action  = $this->SpecimenAction->find('list',array('fields'=>array('SpecimenAction.description','SpecimenAction.description')));
			$testOrdered ='';
		}
		//----------------------------------------- to get lookup name for the Lab_Rad_dashboard-----------------------------------
		$get_lookup_name = $this->Patient->find('first',array('fields'=>array('Patient.lookup_name','Patient_id'),'conditions'=>array('Patient.id'=>$patient_id)));

		$setName=$get_lookup_name[Patient][lookup_name];
		$set_p_id=$get_lookup_name[Patient][Patient_id];

		//-----------------------------------------to get the result in the dashboard-------------------------------------------------------------------------------------------------------------------------------------

		$get_Result=$this->Hl7Result->find('all',array('conditions'=>array('Hl7Result.patient_uid'=>$set_p_id)));

		//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		//------------------------------------------------------------------------------------------
		$this->set(array('test_data'=>$labTest,'test_ordered'=>$testOrdered));
		$this->set(compact('patient_id','spec_rej','spec_cond','spec_type','spec_action','setName','get_Result')) ;


	}
	//--------EOF ----Gaurav
	public function snowmed($patient_id=null,$searchtest=null,$noteId=null,$customFlag=null){	
		$this->set('title_for_layout', __('-Select Snomed CT code.', true));
		$this->layout = ajax ;
        $this->uses = array('DiagnosisMaster','SnomedMappingMaster','Patient');
        $this->set('patientDetails',$patientDetails);
    	
    	if($customFlag=='1'){
     		$this->set('setFlagFrmAltMgt','1');     	
     	}
        if(!empty($patient_id)){
        	$this->set('patient_id',$patient_id);
        	$_SESSION['NoteId']=$noteId;
        }
        //Invetigation
		if(empty($searchtest)){
			
			if(isset($this->request->data['Note']['description'])){
				$this->request->query['description'] = $this->request->data['Note']['description'];
			}
			//$getdata=$this->request->query['description']
			$port = "42011";
		}else if($searchtest!=0){
			$getdata = $searchtest;
			$port = "42045";
		}
		else{
			
		}
		//EOF
		
		if(!empty($this->request->data['Snomed']['description'])){
		
			$getdata= addslashes($this->request->data['Snomed']['description']);
			$noteId=$this->request->data['Snomed']['noteId'];
			
		}
		else{
			
			$getdataIcd9= trim($this->request->data['Snomed']['icd9']);
			$noteId=$this->request->data['DiagnosisMaster']['noteId'];
		
		}
		if(!empty($getdata)){		
			$keyWordExplode=explode(' ',$getdata);
			
			foreach($keyWordExplode as $key=>$value){
				$conditionsString .='SnomedMappingMaster'.".".'icdName'. " LIKE \"%".$value."%\" AND ";
				$conditionsStringOR .='SnomedMappingMaster'.".".'icdName'. " LIKE \"%".$value."%\" OR ";
			}
		
			$conditionsString = rtrim($conditionsString," AND ");
			$conditionsString .=' AND SnomedMappingMaster'.".".'icdName'. " !=' ' ";
			
			$this->paginate = array(
					'limit' => 1000,
					'conditions'=>array($conditionsString));
			$getData   = $this->paginate('SnomedMappingMaster');				
		    $this->set("getData",$getData);
		}
		else if(!empty($getdataIcd9)){
			$this->paginate = array(
					'limit' => 1000,
					'conditions'=>array('SnomedMappingMaster.mapTarget LIKE'=>$getdataIcd9."%",'SnomedMappingMaster.mapTarget !='=>''));
			$getData   = $this->paginate('SnomedMappingMaster');
			$this->set("getData",$getData);
			
		}
		/*else if(!empty($getdataAdv)){
			$keyWordExplode=explode(' ',$getdataAdv);
			foreach($keyWordExplode as $key=>$value){
				$conditionsString .='SnomedMappingMaster'.".".'sctName'. " LIKE \"%".$value."%\" AND ";
				$conditionsStringOR .='SnomedMappingMaster'.".".'sctName'. " LIKE \"%".$value."%\" OR ";
			}
			$conditionsString = rtrim($conditionsString," AND ");
			$conditionsString .=' AND SnomedMappingMaster'.".".'referencedComponentId'. " !=' ' ";
			$this->paginate = array(
					'limit' => 1000,
					'conditions'=>array($conditionsString));
			$getData   = $this->paginate('SnomedMappingMaster');
			//	debug($getData);exit;
			$advanceSearch =true;
			$this->set("getData",$getData);
			$this->set("advanceSearch",$advanceSearch);
				
		}else if(!empty($getdatareferanceComponentId)){		
			$this->paginate = array(
					'limit' => 1000,
					'conditions'=>array('SnomedMappingMaster.referencedComponentId  LIKE'=>$getdatareferanceComponentId."%",'SnomedMappingMaster.icd9code !='=>''));
			$getData   = $this->paginate('SnomedMappingMaster');
			$advanceSearch =true;
			$this->set("getData",$getData);
			$this->set("advanceSearch",$advanceSearch);
			
		}*/
		else if(!empty($getdata_imo)){
			//-----------------------socket connection-----------------------------------------
			 $host ="portal.e-imo.com";
			// $host ="sandbox.e-imo.com";
			 $port = "42011";
			 $timeout = 15;  //timeout in seconds
			$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)
			or die("Unable to create socket\n");
			$result=socket_connect($socket, $host, $port);
			if ($result === false) {
			echo "socket_connect() failed.\nReason: ($result) " .
			socket_strerror(socket_last_error($socket)) . "\n";
			}
			
			$msg = "search^20|||1^".$getdata_imo."^e0695fe74f6466d0^" . "\r\n";
			if (!socket_write($socket, $msg, strlen($msg))) {
			echo socket_last_error($socket);
			}
			/*while ($bytes=socket_read($socket, 100000)) {
			if ($bytes === false) {
			echo socket_last_error($socket);
			break;
			}
			if (strpos($bytes, "\r\n") != false) break;
				
			}*/
			
			sleep(2);
			while($resp = socket_read($socket, 100000)) {
				$str .= $resp;
				if (strpos($str, "\n") !== false) break;
			}
			
			socket_close($socket);
			if(empty($searchtest)){
			
			//$xmlString=$bytes;
			$xmlString=strstr($str, '<?');
			$xmldata = simplexml_load_string($xmlString);
			if(!empty($xmldata)){
			for($i=0;$i<=19;$i++){
			$problemtitle[]= $xmldata->item[$i]['IMO_LEXICAL_CODE'].
					"|".$xmldata->item[$i]['SCT_US_CONCEPT_ID']."|".$xmldata->item[$i]['SNOMED_DESCRIPTION'].
					"|".$xmldata->item[$i]['kndg_code']."|".$xmldata->item[$i]['kndg_title'].
					"|".$xmldata->item[$i]['ICD10CM_CODE']."|".$xmldata->item[$i]['ICD10CM_TITLE'];
			
			}
			$this->set('xmldata',$problemtitle);
			}
			else{
				$this->Session->setFlash(__('Connection Error.',array('class'=>'error')));
				
			}
			}else{
			$xmlString=$bytes;
			$xmldata = simplexml_load_string($xmlString);//echo '<pre>';print_r($xmldata);exit;
			for($i=0;$i<=9;$i++){
			$testdatatitle.= $xmldata->item[$i][title]."|";
			$testdatacode.= $xmldata->item[$i][code]."|";
			$testdataLonicCode.= $xmldata->item[$i][LOINC_CODE]."|";
			$testdataSCTcode.= $xmldata->item[$i][SCT_CONCEPT_ID]."|";
			$testdataCPTcode.= $xmldata->item[$i][CPT_CODE]."|";
			}
			$titleData =  explode('|',$testdatatitle);
			$codeData =  explode('|',$testdatacode);
			$LonicCode =  explode('|',$testdataLonicCode);
			$SctCode = explode('|',$testdataSCTcode);
			$CptCode = explode('|',$testdataCPTcode);
			unset($SctCode[10]);
			unset($titleData[10]);
			unset($codeData[10]);
			
			unset($CptCode[10]);
			unset($LonicCode[10]);
			echo json_encode(array('testTitle' =>$titleData,'testCode'=>$codeData,'SctCode'=>$SctCode,'LonicCode'=>$LonicCode,'CptCode'=>$CptCode));
			$this->set('testdatatitle',$testdatatitle);
			exit;
			}
		}
		else{
			
		}
	}

	//for patient
	public function snowmed_patient($patient_id=null,$searchtest=null){
		//print_r($patient_id);exit;
		$this->set('title_for_layout', __('-Select IPD code.', true));
		$this->layout = false ;

		if(empty($searchtest)){
			if(isset($this->request->data['Note']['description'])){
				$this->request->query['description'] = $this->request->data['Note']['description'];
			}
			$getdata= $this->request->query['description'];
			$port = "42011";
		}else{
			$getdata = $searchtest;
			$port = "42045";
		}
		if(isset($getdata)){
			//-----------------------socket connection-----------------------------------------
			$host ="portal.e-imo.com";
			$timeout = 15;  //timeout in seconds
			$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)
			or die("Unable to create socket\n");
			$result=socket_connect($socket, $host, $port);
			if ($result === false) {
				echo "socket_connect() failed.\nReason: ($result) " .
				socket_strerror(socket_last_error($socket)) . "\n";
			}

			$msg = "search^10|||1^".$getdata."^e0695fe74f6466d0^" . "\r\n";


			if (!socket_write($socket, $msg, strlen($msg))) {
				echo socket_last_error($socket);
			}

			while ($bytes=socket_read($socket, 100000)) {
				if ($bytes === false) {
					echo socket_last_error($socket);
					break;
				}
				if (strpos($bytes, "\r\n") != false) break;
					
			}
			socket_close($socket);
			if(empty($searchtest)){
				$xmlString=$bytes;
				$xmldata = simplexml_load_string($xmlString);
				if(isset($this->request->data['Note']['description'])){
					for($i=0;$i<=19;$i++){
						$problemtitle.= $xmldata->item[$i]['SNOMED_DESCRIPTION']."|";
						$problemUSSnomedCode.= $xmldata->item[$i]['SCT_US_CONCEPT_ID']."|";
						$problemSnomedCode.= $xmldata->item[$i]['SCT_CONCEPT_ID']."|";
					}
					$Problem =  explode('|',$problemtitle);
					$UsSnomed =  explode('|',$problemUSSnomedCode);
					$Snomed =  explode('|',$problemSnomedCode);
					unset($Problem[20]);
					unset($UsSnomed[20]);
					unset($Snomed[20]);

					echo json_encode(array('Problem' =>$Problem,'UsSnomed'=>$UsSnomed,'Snomed'=>$Snomed));


					exit;
				}
				$this->set('xmldata',$xmldata);
			}else{

				$xmlString=$bytes;
				$xmldata = simplexml_load_string($xmlString);//echo '<pre>';print_r($xmldata);exit;
				for($i=0;$i<=9;$i++){
					$testdatatitle.= $xmldata->item[$i][title]."|";
					$testdatacode.= $xmldata->item[$i][code]."|";
					$testdataLonicCode.= $xmldata->item[$i][LOINC_CODE]."|";
					$testdataSCTcode.= $xmldata->item[$i][SCT_CONCEPT_ID]."|";
					$testdataCPTcode.= $xmldata->item[$i][CPT_CODE]."|";
				}
				$titleData =  explode('|',$testdatatitle);
				$codeData =  explode('|',$testdatacode);
				$LonicCode =  explode('|',$testdataLonicCode);
				$SctCode = explode('|',$testdataSCTcode);
				$CptCode = explode('|',$testdataCPTcode);
				unset($SctCode[10]);
				unset($titleData[10]);
				unset($codeData[10]);

				unset($CptCode[10]);
				unset($LonicCode[10]);
				echo json_encode(array('testTitle' =>$titleData,'testCode'=>$codeData,'SctCode'=>$SctCode,'LonicCode'=>$LonicCode,'CptCode'=>$CptCode));


				exit;
			}
		}
		$this->uses = array('DiagnosisMaster');

		$problems  = $this->DiagnosisMaster->find('all',array('fields'=>array('CONCAT(imo_code,"|",icd_id) as code','diagnoses_name')));
		foreach($problems as $listData){
			$icdOptions[$listData['0']['code']] = $listData['DiagnosisMaster']['diagnoses_name'];
		}
		$this->set('icdOptions',$icdOptions);

	}
	//end of patient


	public function snowmed_intervention($patient_id=null,$searchtest=null){
		$this->set('title_for_layout', __('-Select IPD code.', true));
		$this->layout = false ;

		if(empty($searchtest)){
			$getdata= $this->request->query['description'];
			$port = "42011";
		}else{
			$getdata = $searchtest;
			$port = "42045";
		}
		//-----------------------socket connection-----------------------------------------
		$host = "sandbox.e-imo.com";
		$timeout = 15;  //timeout in seconds
		$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)
		or die("Unable to create socket\n");
		$result=socket_connect($socket, $host, $port);
		if ($result === false) {
			echo "socket_connect() failed.\nReason: ($result) " .
			socket_strerror(socket_last_error($socket)) . "\n";
		}
		$msg = "search^10|||1^".$getdata."^e0695fe74f6466d0^" . "\r\n";

		if (!socket_write($socket, $msg, strlen($msg))) {
			echo socket_last_error($socket);
		}

		while ($bytes=socket_read($socket, 100000)) {
			if ($bytes === false) {
				echo socket_last_error($socket);
				break;
			}
			if (strpos($bytes, "\r\n") != false) break;
		}
		socket_close($socket);
		if(empty($searchtest)){
			$xmlString=$bytes;
			$xmldata = simplexml_load_string($xmlString);
			//mmecho"<pre>"; print_r($xmldata);
			$this->set('xmldata',$xmldata);
		}else{

			$xmlString=$bytes;
			$xmldata = simplexml_load_string($xmlString);//echo '<pre>';print_r($xmldata);exit;
			for($i=0;$i<=9;$i++){
				$testdatatitle.= $xmldata->item[$i][title]."|";
				$testdatacode.= $xmldata->item[$i][code]."|";
				$testdataLonicCode.= $xmldata->item[$i][LOINC_CODE]."|";
				$testdataSCTcode.= $xmldata->item[$i][SCT_CONCEPT_ID]."|";
			}
			$titleData =  explode('|',$testdatatitle);
			$codeData =  explode('|',$testdatacode);
			$LonicCode =  explode('|',$testdataLonicCode);
			$SctCode = explode('|',$testdataSCTcode);
			unset($SctCode[10]);
			unset($titleData[10]);
			unset($codeData[10]);

			unset($SctCode[10]);
			unset($LonicCode[10]);
			echo json_encode(array('testTitle' =>$titleData,'testCode'=>$codeData,'SctCode'=>$SctCode,'LonicCode'=>$LonicCode));


			exit;
		}
		$this->uses = array('DiagnosisMaster');
		$problems  = $this->DiagnosisMaster->find('list',array('fields'=>array('imo_code','diagnoses_name')));
		echo"<pre>"; print_r($problems);
		$this->set('icdOptions',$problems);
	}



	public function snowmed_risk($patient_id=null,$searchtest=null){
		$this->set('title_for_layout', __('-Select IPD code.', true));
		$this->layout = false ;

		if(empty($searchtest)){
			$getdata= $this->request->query['description'];
			$port = "42011";
		}else{
			$getdata = $searchtest;
			$port = "42045";
		}
		//-----------------------socket connection-----------------------------------------
		$host = "sandbox.e-imo.com";
		$timeout = 15;  //timeout in seconds
		$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)
		or die("Unable to create socket\n");
		$result=socket_connect($socket, $host, $port);
		if ($result === false) {
			echo "socket_connect() failed.\nReason: ($result) " .
			socket_strerror(socket_last_error($socket)) . "\n";
		}
		$msg = "search^10|||1^".$getdata."^e0695fe74f6466d0^" . "\r\n";

		if (!socket_write($socket, $msg, strlen($msg))) {
			echo socket_last_error($socket);
		}

		while ($bytes=socket_read($socket, 100000)) {
			if ($bytes === false) {
				echo socket_last_error($socket);
				break;
			}
			if (strpos($bytes, "\r\n") != false) break;
		}
		socket_close($socket);
		if(empty($searchtest)){
			$xmlString=$bytes;
			$xmldata = simplexml_load_string($xmlString);
			//mmecho"<pre>"; print_r($xmldata);
			$this->set('xmldata',$xmldata);
		}else{

			$xmlString=$bytes;
			$xmldata = simplexml_load_string($xmlString);//echo '<pre>';print_r($xmldata);exit;
			for($i=0;$i<=9;$i++){
				$testdatatitle.= $xmldata->item[$i][title]."|";
				$testdatacode.= $xmldata->item[$i][code]."|";
				$testdataLonicCode.= $xmldata->item[$i][LOINC_CODE]."|";
				$testdataSCTcode.= $xmldata->item[$i][SCT_CONCEPT_ID]."|";
			}
			$titleData =  explode('|',$testdatatitle);
			$codeData =  explode('|',$testdatacode);
			$LonicCode =  explode('|',$testdataLonicCode);
			$SctCode = explode('|',$testdataSCTcode);
			unset($SctCode[10]);
			unset($titleData[10]);
			unset($codeData[10]);

			unset($SctCode[10]);
			unset($LonicCode[10]);
			echo json_encode(array('testTitle' =>$titleData,'testCode'=>$codeData,'SctCode'=>$SctCode,'LonicCode'=>$LonicCode));


			exit;
		}
		$this->uses = array('DiagnosisMaster');
		$problems  = $this->DiagnosisMaster->find('list',array('fields'=>array('imo_code','diagnoses_name')));

		$this->set('icdOptions',$problems);
	}




	public function familyproblem($id=null,$flag=null){
		$this->set('title_for_layout', __('-Select Snomed CT code.', true));
		$this->layout = 'advance_ajax' ;
		if(!empty($id)){
			$this->Session->write('familyid',$id);
		}
		if(!empty($flag)){
			$this->set("flag",$flag);
		}	
		/*if($id=="")
			{
		echo "BLANK";

		echo $this->Session->read('familyid');
		if($this->Session->read('familyid')!=""){
		echo $this->Session->read('familyid');
		$this->Session->write('familyid',$id);
		}

		}
		else{
		$this->Session->write('familyid',$id);
		echo $this->Session->read('familyid')." "."hello".'<br/>';
		}
		/*if($this->Session->read('familyid')==""){
		echo "hello".'<br/>';
		$this->Session->write('familyid',$id);
		echo $id ."id"."<br/>";
		echo $this->Session->read('familyid') ." "."here2";
		}
		*/
		 $this->uses = array('DiagnosisMaster','SnomedMappingMaster');

		if(empty($searchtest)){
			if(isset($this->request->data['Note']['description'])){
				$this->request->query['description'] = $this->request->data['Note']['description'];
			}
			

			//$getdata=$this->request->query['description']
			$port = "42011";
		}else{
			$getdata = $searchtest;
			$port = "42045";
		}
	if(!empty($this->request->data['Snomed']['description']))
			$getdata= $this->request->data['Snomed']['description'];
		else
			$getdata_imo= $this->request->data['DiagnosisMaster']['imo'];
		if(empty($getdata) && empty($getdata_imo)){
			$getdata = $this->request->data['Note']['description'];
		}
		if(empty($getdata) && empty($getdata_imo)){
			$getdata = $searchtest;
		}
		
		
        if(isset($getdata))
		{
			$getData=$this->SnomedMappingMaster->find('all',array('conditions'=>array('SnomedMappingMaster.is_deleted'=>0,'SnomedMappingMaster.sctName LIKE'=> "%"."".$getdata.""."%")));
			
		    $this->set("getData",$getData);
		    $this->set("data",$getData);
		}
		else if(!empty($getdata_imo)){
			//-----------------------socket connection-----------------------------------------
			$host ="portal.e-imo.com";
			// $host ="sandbox.e-imo.com";
			$port = "42011";
			$timeout = 15;  //timeout in seconds
			$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)
			or die("Unable to create socket\n");
			$result=socket_connect($socket, $host, $port);
			if ($result === false) {
				echo "socket_connect() failed.\nReason: ($result) " .
				socket_strerror(socket_last_error($socket)) . "\n";
			}
				
			$msg = "search^20|||1^".$getdata_imo."^e0695fe74f6466d0^" . "\r\n";
					if (!socket_write($socket, $msg, strlen($msg))) {
					echo socket_last_error($socket);
					}
					/*while ($bytes=socket_read($socket, 100000)) {
					if ($bytes === false) {
					echo socket_last_error($socket);
					break;
					}
					if (strpos($bytes, "\r\n") != false) break;
		
					}*/
						
					sleep(2);
					while($resp = socket_read($socket, 100000)) {
					$str .= $resp;
					if (strpos($str, "\n") !== false) break;
					}
						
					socket_close($socket);
					if(empty($searchtest)){
						
					//$xmlString=$bytes;
						$xmlString=strstr($str, '<?');
						$xmldata = simplexml_load_string($xmlString);
						if(!empty($xmldata)){
						for($i=0;$i<=19;$i++){
						$problemtitle[]= $xmldata->item[$i]['IMO_LEXICAL_CODE'].
								"|".$xmldata->item[$i]['SCT_US_CONCEPT_ID']."|".$xmldata->item[$i]['SNOMED_DESCRIPTION'].
								"|".$xmldata->item[$i]['kndg_code']."|".$xmldata->item[$i]['kndg_title'].
								"|".$xmldata->item[$i]['ICD10CM_CODE']."|".$xmldata->item[$i]['ICD10CM_TITLE'];
									
						}
						$this->set('xmldata',$problemtitle);
						}
						else{
							$this->Session->setFlash(__('Connection Error.',array('class'=>'error')));
		
						}
					}else{
						$xmlString=$bytes;
						$xmldata = simplexml_load_string($xmlString);//echo '<pre>';print_r($xmldata);exit;
						for($i=0;$i<=9;$i++){
						$testdatatitle.= $xmldata->item[$i][title]."|";
						$testdatacode.= $xmldata->item[$i][code]."|";
						$testdataLonicCode.= $xmldata->item[$i][LOINC_CODE]."|";
						$testdataSCTcode.= $xmldata->item[$i][SCT_CONCEPT_ID]."|";
						$testdataCPTcode.= $xmldata->item[$i][CPT_CODE]."|";
					}
					$titleData =  explode('|',$testdatatitle);
					$codeData =  explode('|',$testdatacode);
					$LonicCode =  explode('|',$testdataLonicCode);
					$SctCode = explode('|',$testdataSCTcode);
					$CptCode = explode('|',$testdataCPTcode);
					unset($SctCode[10]);
					unset($titleData[10]);
					unset($codeData[10]);
						
					unset($CptCode[10]);
					unset($LonicCode[10]);
					echo json_encode(array('testTitle' =>$titleData,'testCode'=>$codeData,'SctCode'=>$SctCode,'LonicCode'=>$LonicCode,'CptCode'=>$CptCode));
					$this->set('testdatatitle',$testdatatitle);
					exit;
		}
		}
		else{
				
				}
		/*$problems  = $this->DiagnosisMaster->find('all',array('fields'=>array('CONCAT(imo_code,"|",icd_id) as code','diagnoses_name')));
		foreach($problems as $listData){
			$icdOptions[$listData['0']['code']] = $listData['DiagnosisMaster']['diagnoses_name'];
		}
		$this->set('icdOptions',$icdOptions);*/
		


	}
	
	public function proceduresearch($id=null,$flag=null){ //this is for searching procedure, lab test and radiology test
		$this->set('title_for_layout', __('-Select Snomed CT code.', true));
		$this->layout = ajax ;
		if(!empty($id)){
			$this->Session->write('familyid',$id);
		}
		if(!empty($flag)){
			$this->set("flag",$flag);
		}
		/*if($id=="")
		 {
		echo "BLANK";
	
		echo $this->Session->read('familyid');
		if($this->Session->read('familyid')!=""){
		echo $this->Session->read('familyid');
		$this->Session->write('familyid',$id);
		}
	
		}
		else{
		$this->Session->write('familyid',$id);
		echo $this->Session->read('familyid')." "."hello".'<br/>';
		}
		/*if($this->Session->read('familyid')==""){
		echo "hello".'<br/>';
		$this->Session->write('familyid',$id);
		echo $id ."id"."<br/>";
		echo $this->Session->read('familyid') ." "."here2";
		}
		*/
		$this->uses = array('DiagnosisMaster','SnomedMappingMaster');
	
		
		$port = "42045";
	
		$getdata= $this->request->data['Snomed']['description'];
		$searchtest=$getdata;
		//-----------------------socket connection-----------------------------------------
		$host ="portal.e-imo.com";
			$timeout = 15;  //timeout in seconds
		$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)
		or die("Unable to create socket\n");
		$result=socket_connect($socket, $host, $port);
		if ($result === false) {
		echo "socket_connect() failed.\nReason: ($result) " .
		socket_strerror(socket_last_error($socket)) . "\n";
		}
		
		$msg = "search^40|||1^".$getdata."^e0695fe74f6466d0^" . "\r\n";
	
		if (!socket_write($socket, $msg, strlen($msg))) {
		echo socket_last_error($socket);
		}
	
	     sleep(20);
			while($resp = socket_read($socket, 100000)) {
				$str .= $resp;
				if (strpos($str, "\n") !== false) break;
			}
		socket_close($socket);
		if(empty($searchtest)){
		
	
		$this->set('xmldata',$xmldata);
		$this->set('familyidentifier',$id);
	
		}else{
	
		$xmlString=strstr($str, '<?');
		$xmldata = simplexml_load_string($xmlString);
		
		if(!empty($xmldata)){
			for($i=0;$i<count($xmldata);$i++){
				$procedureData[]= $xmldata->item[$i]['title'].
				"|".$xmldata->item[$i]['CPT_CODE']."|".$xmldata->item[$i]['CPT_DESC_LONG'].
				"|".$xmldata->item[$i]['ICDP_CODE']."|".$xmldata->item[$i]['ICDP_DESC_LONG'].
				"|".$xmldata->item[$i]['ICD10PCS_CODE']."|".$xmldata->item[$i]['ICD10PCS_DESC_LONG'].
				"|".$xmldata->item[$i]['HCPCS_CODE']."|".$xmldata->item[$i]['HCPCS_DESC_LONG'].
				"|".$xmldata->item[$i]['LOINC_CODE']."|".$xmldata->item[$i]['LOINC_DESC_LONG'].
				"|".$xmldata->item[$i]['SCT_CONCEPT_ID']."|".$xmldata->item[$i]['SNOMED_DESCRIPTION']."|".$xmldata->item[$i]['IMO_LEXICAL_CODE'];
					
			}
			$this->set('xmldata',$procedureData);
		
		}
	
	}
	}
	
	public function getSmokingDetails($id){
		$this->uses=array('SmokingStatusOncs');
		$smokingDetail =    $this->SmokingStatusOncs->find('first',array('fields'=>array('id'),'conditions'=>array('SmokingStatusOncs.id'=> $id)));
		echo ($smokingDetail['SmokingStatusOncs']['id']);

		exit;
	}

	public function getLabDetails($id){
		$this->uses=array('Laboratory');
		//$labTest  = $this->Laboratory->find('list',array('fields'=>array('Laboratory.id','Laboratory.name','Laboratory.test_code','ionic_code'),'conditions'=>array('is_active'=>1,'Laboratory.id'=> $id,'Laboratory.location_id'=>$this->Session->read('locationid'))));
		$labTest =    $this->Laboratory->find('first',array('fields'=>array('name','test_code','lonic_code','sct_concept_id'),'conditions'=>array('Laboratory.id'=> $id)));
		echo $labTest['Laboratory']['name']."|".$labTest['Laboratory']['test_code']."|".$labTest['Laboratory']['lonic_code']."|".$labTest['Laboratory']['sct_concept_id'];

		exit;
	}
	public function getRadDetails($id){
		$this->uses=array('Radiology');
		//$labTest  = $this->Laboratory->find('list',array('fields'=>array('Laboratory.id','Laboratory.name','Laboratory.test_code','ionic_code'),'conditions'=>array('is_active'=>1,'Laboratory.id'=> $id,'Laboratory.location_id'=>$this->Session->read('locationid'))));
		$radTest =    $this->Radiology->find('first',array('fields'=>array('id','name','cpt_code','test_code','lonic_code','sct_concept_id'),'conditions'=>array('Radiology.id'=> $id)));
		//print_r($radTest); exit;
		echo json_encode($radTest['Radiology']);
		//echo $radTest['Radiology']['name']."|".$radTest['Radiology']['test_code']."|".$radTest['Radiology']['lonic_code']."|".$radTest['Radiology']['sct_concept_id']."|".$radTest['Radiology']['cpt_code'];

		exit;
	}





	public function viewresult($id=null,$count=null){
		$this->set('id',$id);
			
		$this->set('count',$count);
		$this->uses=array('Patient','Hl7Result');
		$get_Result=$this->Hl7Result->find('all',array('conditions'=>array('Hl7Result.patient_uid'=>$id)));
		//echo '<pre>';print_r($get_Result);exit;
		$this->set(compact('get_Result'));
			
			
			
	}
	public function diagnosis_exist(){
		$this->layout = false ;
	}

	public function sendHl7Message($patientId,$messageId,$patient_id){
		$this->layout = false;
		$this->uses = array('Hl7Result','AmbulatoryResult','Patient');
		$dataSet = $this->Hl7Result->find('all',array('conditions'=>array('patient_uid' =>$patientId )));

		$pData = $this->Patient->read(null,$patient_id);
		$admissionId = $pData['Patient']['admission_id'];
		$patientType = substr($admissionId, 0, 1);
		//echo '<pre>';print_r($patientType);exit;

		if(!empty($this->request->data)){
			$rand = $this->Session->read('randNumber');
			if($rand){
				$this->Session->write('randNumber',($this->Session->read('randNumber') + 1));
			}else{
				$this->Session->write('randNumber',1);
			}//echo '<pre>';print_r($this->request->data);exit;
			//echo '<pre>';print_r($data);exit;
			foreach($dataSet as $dt){
				if($dt['Hl7Result']['id'] == $this->request->data['ambulatoryResult']['messageId']){
					$data = $dt['Hl7Result']['message'];
					break;
				}
			}
			$expData = explode("\n",$data);
			$capData  = explode("|",$expData[0]);
			$capData[2] = "DrMHopeEHR";
			if($patientType == 'O'){
				$capData[3] = "DrMHopeAmbulatory";
			}else
				if($patientType == 'I'){
				$capData[3] = "DrMHopeInpatient";
			}
			$capData[5] = str_replace(" ","",$this->request->data['ambulatoryResult']['namespace_id']);
			$capData[6] = date('YmdHis').'-0500';
			if($patientType == 'O'){
				$capData[9] = "AmbulatoryHope".$this->Session->read('randNumber');
			}else if($patientType == 'I'){
				$capData[9] = "InpatientHope".$this->Session->read('randNumber');
			}
			$capData = implode("|",$capData);
			$expData[0] = $capData;
			$expData = implode("\n",$expData);

			if($this->AmbulatoryResult->save(array('uid' => $this->request->data['ambulatoryResult']['patientUid'],'message' => $expData))){
					
				$outboxModel = ClassRegistry::init('AmbulatoryResultOutbox');
				$myHl7Exp = explode("\n",$expData);
				$myHl7Exp = explode("|",$myHl7Exp[0]);
				$outboxModel->save(array('message'=>$expData,'uid'=>$this->request->data['ambulatoryResult']['patientUid'],'to'=>$myHl7Exp[5],'create_time'=>date('Y-m-d H:i:s')));
					
				$this->Session->setFlash(__('Message sent successfully.', true));
				//$this->redirect(array('controller' => 'diagnoses','action'=>'add',$patientId));
			}else{
				$this->Session->setFlash(__('Could not send message.', true));
			}
		}
		$this->set(array('patientUid'=>$patientId,'itemId'=>$dataSet[$messageId]['Hl7Result']['id'],'message'=>$dataSet[$messageId]['Hl7Result']['message']));

		//echo '<pre>';print_r($data);exit;

	}
	public function search_icd(){
		//$conditionsSearch['SnomedMappingMaster'] = array('location_id'=> $this->Session->read('locationid'));
		
		if(isset($this->request->data) && isset($this->request->data) && $this->request->data['sctName']!=''){
			$conditionsSearch["SnomedMappingMaster"] = array("sctName LIKE" => "%".$this->request->data['sctName']."%");
		}
		$conditionsSearch = $this->postConditions($conditionsSearch);
		
		$this->uses = array('SnomedMappingMaster');
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array('SnomedMappingMaster.sctName' => 'asc'),
				'conditions' => $conditionsSearch
		);
			
		$testData = $this->paginate('SnomedMappingMaster');
		$this->set('testData',$testData);
		
		
	}
	public function icd_add(){
		$this->uses = array('ServiceCategory','TariffList','TestGroup','SnomedMappingMaster') ;
		if(isset($this->request->data) && !empty($this->request->data)){
			
			$data['SnomedMappingMaster']['id']=$this->request->data['Diagnoses']['id'] ;
			$data['SnomedMappingMaster']['tariff_list_id']=$this->request->data['Diagnoses']['tariff_list_id'] ;
			
			//$errors = $this->Diagnoses->invalidFields();
			$this->SnomedMappingMaster->save($data);
			$this->Session->setFlash(__('Diagnoses save successfully'),'default',array('class'=>'message'));
			$this->redirect($this->referer());
		}
		
			$testQuery = $this->SnomedMappingMaster->read('id,sctName,mapTarget,tariff_list_id',$lab_id);
			$this->set('test_name',$testQuery['SnomedMappingMaster']['sctName']);
			$this->data = $testQuery ;
			$this->set('serviceGroup',$this->ServiceCategory->getServiceGroup());
			$tariffList = $this->TariffList->getServiceByGroupId($this->data['Diagnoses']['service_group_id']);
			$this->set('tariffList',$tariffList);
		
		$this->set('serviceGroup',$this->ServiceCategory->getServiceGroup());
		
	
	}
	
	 public function icd_edit($lab_id=null,$category_id=null){
		
		$this->uses = array('ServiceCategory','TariffList','TestGroup','SnomedMappingMaster') ;
		
		if(isset($this->request->data) && !empty($this->request->data)){
		
			if(($this->request->data)){
				//$data['SnomedMappingMaster']['location_id'] = $session->read('locationid');
				$data['SnomedMappingMaster']['id'] = $this->request->data['SnomedMappingMaster']['id'];
				$data['SnomedMappingMaster']['tariff_list_id'] = $this->request->data['SnomedMappingMaster']['tariff_list_id'];
				
				$this->SnomedMappingMaster->save($data);
				$this->Session->setFlash(__('Test record updated successfully'),'default',array('class'=>'message'));
				if($this->request->data['SnomedMappingMaster']['whichAct']=='add-more'){
					$this->redirect(array("action" => "admin_add",$this->SnomedMappingMaster->id));
				}else{
					$this->redirect(array("action" => "icd_edit",$this->request->data['SnomedMappingMaster']['id']));
				}
			}
			$errors = $this->SnomedMappingMaster->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			}
		}
		if(!empty($lab_id)){
			/* if(empty($category_id)){
				$this->SnomedMappingMaster->bindModel(array(
						'hasMany' => array(
								'LaboratoryCategory' =>array('foreignKey' => 'laboratory_id')
						)),false);
			}else if(!empty($category_id)){
				$this->SnomedMappingMaster->bindModel(array(
						'hasOne' => array(
								'LaboratoryCategory' =>array('foreignKey' => false,'conditions'=>array('LaboratoryCategory.id'=>$category_id))),
						'hasMany'=>array(
								'LaboratoryParameter' =>array('foreignKey' => false ,'conditions'=>array('laboratory_categories_id'=>$category_id))
						)),false);
			} */
			$data =  $this->SnomedMappingMaster->read(null,$lab_id);
			$this->set(array('test_id'=>$lab_id,'cat_id'=>$category_id,'data'=>$data));
			$this->set('serviceGroup',$this->ServiceCategory->getServiceGroup());
			$tariffList = $this->TariffList->getServiceByGroupId($data['SnomedMappingMaster']['service_group_id']);
			$this->set('testGroup',$this->TestGroup->getAllGroups('laboratory')) ;
			$this->set('tariffList',$tariffList);
		}
		$advanceData = $this->SnomedMappingMaster->find('first', array('conditions' => array('SnomedMappingMaster.id' => $lab_id)));
		
		$this->set('advanceData',$advanceData);
	}
	
	function icd_delete($id){
		$this->uses = array('SnomedMappingMaster');
		if(!$id) return ;
		if($this->SnomedMappingMaster->delete($id)){
			$this->Session->setFlash(__('Diagnoses deleted successfully'),'default',array('class'=>'message'));
			$this->redirect($this->referer());
		}else{
			$this->Session->setFlash(__('There is some problem'),'default',array('class'=>'error'));
		}
	}
	
	function icd_change_status($test_id=null,$status=null){
		$this->uses = array('SnomedMappingMaster');
		if($test_id==''){
			$this->Session->setFlash(__('There is some problem'),'default',array('class'=>'error'));
			$this->redirect($this->referer());
		}
		$this->SnomedMappingMaster->id = $test_id ;
		$this->SnomedMappingMaster->save(array('is_active'=>$status));
		$this->Session->setFlash(__('Status has been changed successfully'),'default',array('class'=>'message'));
		$this->redirect($this->referer());
	}

	
	

	
	function alcohol_assesment()
	{
		
	}
	
	function alcohol_cessation_assesment()
	{
	
	}
	
	function pastMedicalHistory($patientId=null)
	{
		//$this->layout = 'advance';
		$this->uses= array('Patient','PastMedicalHistory','PatientPersonalHistory','PastMedicalRecord','FamilyHistory',
				'SmokingStatusOncs','PregnancyCount','ProcedureHistory','PatientSmoking','Diagnosis');
		$this->patient_info($patientId);
		$diagnosisId = $this->Diagnosis->find('first',array('fields'=>'id','conditions'=>array('Diagnosis.patient_id'=>$patientId)));
		$this->set('diagnosisId',$diagnosisId);
		
		if(empty($diagnosisId['Diagnosis']['id'])){
			//If there is previous encounter in our database
			$this->set('patientId',$patientId); // set before change patient id
			$prevID = $this->Diagnosis->getPrevEncounterID($patientId,$this->patient_details['Patient']['person_id']);
				
			if(!empty($prevID)) $patientId = $prevID ;		
		}
		
		$pastMedicalHistoryRec = $this->PastMedicalHistory->find('all',array('fields'=>array('PastMedicalHistory.illness','PastMedicalHistory.status',
				'PastMedicalHistory.duration','PastMedicalHistory.comment'),'conditions'=>array('patient_id'=>$patientId)));
		$this->set('pastHistory',$pastMedicalHistoryRec);
		
		$getpatient=$this->PastMedicalRecord->find('all',array('conditions'=>array('patient_id'=>$patientId)));
		$this->set('getpatient',$getpatient);
		
		$getpatientfamilyhistory=$this->FamilyHistory->find('all',array('conditions'=>array('patient_id'=>$patientId)));
		$this->set('getpatientfamilyhistory',$getpatientfamilyhistory);
		
		$smokingOptions = $this->SmokingStatusOncs->find('list',array('fields'=>array('description')));
		$this->set(compact('smokingOptions'));
		
		$pregnancyCountRec = $this->PregnancyCount->find('all',array('fields'=>array('PregnancyCount.counts','PregnancyCount.date_birth',
				'PregnancyCount.weight','PregnancyCount.baby_gender','PregnancyCount.week_pregnant','PregnancyCount.type_delivery',
				'PregnancyCount.complication'),'conditions'=>array('patient_id'=>$patientId)));
		$this->set('pregnancyData',$pregnancyCountRec);
		
		/*$procedureHistoryRec = $this->ProcedureHistory->find('all',array('fields'=>array('ProcedureHistory.procedure','ProcedureHistory.provider',
				'ProcedureHistory.age_value','ProcedureHistory.age_unit','ProcedureHistory.procedure_date','ProcedureHistory.comment'),
				'conditions'=>array('patient_id'=>$patientId)));
		$this->set('procedureHistory',$procedureHistoryRec);*/
		
		//BOF --------ProcedureHistory
		$this->ProcedureHistory->bindModel( array(
				'belongsTo' => array(
						'DoctorProfile'=>array('foreignKey'=>false,'conditions'=>array('ProcedureHistory.provider=DoctorProfile.id')),
						'TariffList'=>array('foreignKey'=>false,'conditions'=>array('ProcedureHistory.procedure=TariffList.id')),
				)));
		 
		$procedureHistoryRec = $this->ProcedureHistory->find('all',array('fields'=>array('TariffList.id','TariffList.name','DoctorProfile.id',
				'DoctorProfile.doctor_name','ProcedureHistory.procedure','ProcedureHistory.provider','ProcedureHistory.age_value','ProcedureHistory.age_unit',
				'ProcedureHistory.procedure_date','ProcedureHistory.comment','ProcedureHistory.procedure_name','ProcedureHistory.provider_name'),
				'conditions'=>array('ProcedureHistory.patient_id'=>$patientId),'order'=>array('ProcedureHistory.id Asc')));
		$this->set('procedureHistory',$procedureHistoryRec);
		//EOF ProcedureHistory
		$this->PatientSmoking->bindModel(array(
				'belongsTo'=>array(
					'PatientPersonalHistory'=>array(
								'conditions'=>array('PatientSmoking.diagnosis_id=PatientPersonalHistory.diagnosis_id'),
								'foreignKey'=>false),
								)));
		$smokingData = $this->PatientSmoking->find('all',array('conditions'=>array('PatientSmoking.patient_id'=>$patientId),'order'=>array('PatientSmoking.id DESC'),'limit'=>1));
		
		$getDataPPH= $this->PatientPersonalHistory->find('all',array('conditions'=>array('PatientPersonalHistory.diagnosis_id'=>$smokingData[0]['PatientSmoking']['diagnosis_id']),'order'=>array('PatientPersonalHistory.id DESC'),'limit'=>1));
		$this->set('getDataPPH',$getDataPPH);
		$this->data=$smokingData['0']; 
	}

	public function alcohal_assesment($id=null,$personId=null,$appointmentID=null,$diagnosis_id=null)
    {
       
        $this->set('pid',$id);
        $this->uses=array('AlcohalAssesment');
		$this->layout='ajax';
        $this->patient_info($id);
       
        
            if(!empty($this->request->data))
            {
                $score=$this->request->data['AlcohalAssesment']['nausea_vomiting']+
                $this->request->data['AlcohalAssesment']['tactile_disturbance']+
                $this->request->data['AlcohalAssesment']['tremor']+
                $this->request->data['AlcohalAssesment']['auditory_disturbances']+
                $this->request->data['AlcohalAssesment']['paroxysmal_sweats']+
                $this->request->data['AlcohalAssesment']['visiul_disturbance']+
                $this->request->data['AlcohalAssesment']['anxiety']+
                $this->request->data['AlcohalAssesment']['headache_fullness']+
                $this->request->data['AlcohalAssesment']['observation']+
                $this->request->data['AlcohalAssesment']['operation_clouding'];
               
                $this->request->data['AlcohalAssesment']['total_score']=$score;
               
                if ($this->AlcohalAssesment->save($this->request->data)) {
                	$this->Session->setFlash(__('Your record has been saved.', true),true,array('class'=>'message'));
                   // $this->redirect(array('controller'=>'Diagnoses','action' => 'alcohal_assesment',$id));
                	$this->set('status','success') ;
                //	$this->redirect(array('controller'=>'Diagnoses','action' => 'significantHistory',$id,$personId,$appointmentID,$diagnosis_id));
                }
                else {
                    $this->Session->setFlash(__('Unable to add your record.', true),true,array('class'=>'error'));
                   // $this->redirect(array('controller'=>'Diagnoses','action' => 'significantHistory',$patient_id,$personId,$appointmentID,$diagnosis_id));
                    $this->set('status','success') ;
                }
                   
            }
       
            else {
                $patients=$this->AlcohalAssesment->find('first',array('conditions'=>array('AlcohalAssesment.patient_id'=>$id)));
                $this->data = $patients;
            }
           
            //}
                 
    }
   
   
    public function alcohal_cessation_assesment($id = null)
        {
           
            $this->uses=array('AlcohalCessationAssesment');
            $this->layout='ajax';
            $this->patient_info($id);
            $this->set('pid',$id);
       
                if(!empty($this->request->data))
                {
                    $this->request->data['AlcohalCessationAssesment']['smoke_again']= implode("|", $this->request->data['AlcohalCessationAssesment']['smoke_again']);   
                    $this->request->data['AlcohalCessationAssesment']['plan_nicotine_replacement']= implode("|", $this->request->data['AlcohalCessationAssesment']['plan_nicotine_replacement']);   
                    $this->request->data['AlcohalCessationAssesment']['quit_now']= implode("|", $this->request->data['AlcohalCessationAssesment']['quit_now']);
                    $this->request->data['AlcohalCessationAssesment']['main_concern_quitting']= implode("|", $this->request->data['AlcohalCessationAssesment']['main_concern_quitting']);
                    $this->request->data['AlcohalCessationAssesment']['situation_smoke']= implode("|", $this->request->data['AlcohalCessationAssesment']['situation_smoke']);
           
                    if($this->request->data['AlcohalCessationAssesment']['nicotine_replacement']=='yes'){
                        $this->request->data['AlcohalCessationAssesment']['nicotine_replacement']=$this->request->data['AlcohalCessationAssesment']['nicotine_txt'];
                    }
                    else{
                        $this->request->data['AlcohalCessationAssesment']['nicotine_replacement']='no';
                    }
           
                    if($this->request->data['AlcohalCessationAssesment']['quit_now']==$this->request->data['AlcohalCessationAssesment']['checkOther']){
                        $this->request->data['AlcohalCessationAssesment']['quit_now_other']=$this->request->data['AlcohalCessationAssesment']['quit_now_other'];
                    }
                    if($this->request->data['AlcohalCessationAssesment']['situation_smoke']==$this->request->data['AlcohalCessationAssesment']['check_temptOther']){
                        $this->request->data['AlcohalCessationAssesment']['situation_smoke_other']=$this->request->data['AlcohalCessationAssesment']['situation_smoke_other'];
                    }
           
                    $qd=$this->request->data['AlcohalCessationAssesment']['quit_date'];
                    $this->request->data['AlcohalCessationAssesment']['quit_date']= $this->DateFormat->formatDate2STD($qd,Configure::read('date_format'));
               
                    //debug($this->request->data); exit;
                    if ($this->AlcohalCessationAssesment->save($this->request->data)) {
                    $this->Session->setFlash('Your record has been saved.');
                    $this->set('status','success') ;
                    }
                    else {
                        $this->Session->setFlash(array('Unable to add your record.','default','class'=>'error'));
                    }
                }else{
                    $patient_all=$this->AlcohalCessationAssesment->find('first',array('conditions'=>array('AlcohalCessationAssesment.patient_id'=>$id)));
                    $patient_all['AlcohalCessationAssesment']['quit_date']= $this->DateFormat->formatDate2Local($patient_all['AlcohalCessationAssesment']['quit_date'],Configure::read('date_format'),true);
                   
                   
                    $this->data = $patient_all;
                }
           
               
       
    }
    
    
    function initialAssessment($patientId=null,$id=null,$appointmentID=null){
    	$this->layout = 'advance' ;
    	$this->uses = array('Immunization','Person','Widget','Diagnosis','Patient','Language',
    		'PharmacyMaster','NoteTemplate','LaboratoryResult','PatientsTrackReport',
    			'NewCropAllergies','Note','NewInsurance','NewCropPrescription','VisitType','Appointment','PhvsImmunizationInformationSource','User');

    	if($this->request->query['from']=='BackToOPD'){
    		$this->set('BackToOPD',$this->request->query['from']);
    		$conditionsFilter = $this->request->query['conditionsFilter'];
    		$this->Session->write('opd_dashboard_filters',$conditionsFilter);
    		$todayOrder = $this->request->query['todayOrder'];
    		$this->Session->write('opd_dashboard_order',$todayOrder);
    		$opdPageCount = $this->request->query['opdPageCount'];
    		$this->Session->write('opd_dashboard_pageCount',$opdPageCount);
    	}
    	if($this->request->query['fromSoapNote']=='fromSoapNote'){
    		$fromSoapNote = 'fromSoapNote';
    		$noteID = $this->request->query['noteID'];
    		$this->set( 'fromSoapNote',$fromSoapNote);
    		$this->set( 'noteID',$noteID);
    	}
    	$doctors = $this->User->getAllDoctors();
    	$this->set('doctors',$doctors);
    	/** to create noteId and other Session things **/
    	if(empty($id) ||  ($id =='')||  ($id =='null') ||  ($id ==null) ){
    		$diagnosisId=$this->Diagnosis->addBlankEntry($patientId,$appointmentID);
    		$this->redirect("/Diagnoses/initialAssessment/".$patientId."/".$diagnosisId."/".$appointmentID.'/?type='.$this->request->query['type']);
    	}

    	/** Elaspse time **/
	    	if(!empty($appointmentID)){
	    		$apptData=$this->Appointment->find('first',array('fields'=>array('id','status','elapsed_time'),'conditions'=>array('id'=>$appointmentID)));
	    			//if($apptData['Appointment']['status']=='Closed'){
	    				$this->set('elaspseData',$apptData);
	    			//}
	    	}
    	/** EOD**/
    	
    	
    	if(is_numeric($appointmentID))
    		$this->Session->write('initialAppointmentID',$appointmentID);
    	if(($appointmentID=='icons'))
    		$this->Session->write('initialAppointmentID','null');
    	
    	if($appointmentID==='ajax-loader_dashboard.gif')
    	{
    		$this->Session->write('appointmentIDSession','null');
    		$this->Session->write('initialAppointmentID','null');
    		$this->set('appointmentID',$this->Session->read('initialAppointmentID'));
    	}else{
    		$this->Session->write('appointmentIDSession',$appointmentID);
    		$this->Session->write('initialAppointmentID',$appointmentID);
    	}
    	 	 
    	if($id!='img'){
    		$this->Session->write('noteIDSession',$id);
    		if(is_numeric($appointmentID))
    			$this->Session->write('appointmentIDSession',$appointmentID);
    		else
    			$this->Session->write('appointmentIDSession','null');
    		 
    	}
    	if($appointmentID!='icons'){
    		$this->Session->write('noteIDSession',$id);
    	
    		if(is_numeric($appointmentID))
    			$this->Session->write('appointmentIDSession',$appointmentID);
    		else
    			$this->Session->write('appointmentIDSession','null');
    	}
    	if($id=='img'){
    		$id=$_SESSION['noteIDSession'];
    	}
    	if($appointmentID=='icons'){
    		//$appointmentID=$_SESSION['appointmentIDSession'];
    		$appointmentID=$this->Session->read('appointmentIDSession');
    	}
    	 
    	$this->layout = 'advance' ;
    	$this->patient_info($patientId);
    	//$this->set('appointmentID',$appointmentID);
    	$this->set('appointmentID',$this->Session->read('initialAppointmentID'));
    	
    	if(!empty($appointmentID)){
    		if($appointmentID != 'img')
    		$this->Session->write('initialAppointmentID',$appointmentID); 
    	} 
    	if($appointmentID == ''){
    		$this->Session->write('initialAppointmentID','');
    		$this->Session->write('initialAppointmentID','null');
    	}

    	if($id != 'Black')
    	$this->Session->write('diagnosesID',$id);
    	
    	$tName=$this->NoteTemplate->find('list',array('fields'=>array('template_name','template_name'),
    			'conditions'=>array('is_deleted'=>'0','template_type'=>array('all','')),
    			'order'=>array('ISNULL(NoteTemplate.sort_order), NoteTemplate.template_name ASC')));
    	$this->set('tName',$tName); 	
    	$currentUserId = 1;
    	if(!empty($this->params->query['type']))
    		$this->Session->write('elpeTym',$this->params->query['type']);
    	
    	
    	$columns = $this->Widget->find('all',array('fields' => array('Widget.id','Widget.user_id','Widget.application_screen_name','Widget.column_id',
    			'Widget.collapsed','Widget.title','Widget.section','Widget.is_deleted'),
    			'conditions' => array('Widget.is_deleted'=> 0,'Widget.user_id' => $currentUserId,
    					'Widget.application_screen_name' => 'Initial Assessment'),
    			'order' => array('Widget.column_id','Widget.sort_no'),'group'=>array('Widget.title')));
    	$this->set('expandBlock',$this->params->query['expand']);
    	$this->Patient->unBindModel(array(
    			'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
    	$getPharmacy=$this->Patient->find('first',array('fields'=>array('Patient.preferred_pharmacy','Patient.patient_health_plan_id',
    		'Patient.insurance_company_name','Patient.pharmacy_master_id','Patient.person_id','Patient.lock','Patient.tariff_standard_id',
    		'Patient.id'),'conditions'=>array('Patient.id'=>$patientId)));
    	$this->set('person_id',$getPharmacy['Patient']['person_id']);
    	$this->set('getInsuance',$getPharmacy);

    	//Encouter Data
    	$getEncounterId=$this->Note->encounterHandler($patientId,$getPharmacy['Patient']['person_id']);
    	if(count($getEncounterId)=='1'){
    		$getEncounterId=$getEncounterId['0'];
    		//$this->Session
    	}$this->Session->write('encounterIdForInitailAsses',$getEncounterId);
    	//EOF
    	
    	
    	$getPharmacyID=$this->Person->find('first',array('fields'=>array('Person.pharmacy_value','Person.id','Person.pharmacy_id'),'conditions'=>array('Person.id'=>$getPharmacy['Patient']['person_id'])));
    	if(!empty($getPharmacyID['Person']['pharmacy_id'])){
    		$this->Patient->updateAll(array('Patient.preferred_pharmacy'=>"'".addslashes($getPharmacyID['Person']['pharmacy_value'])."'",'Patient.pharmacy_master_id'=>"'".$getPharmacyID['Person']['pharmacy_id']."'"),array('Patient.id'=> $patientId));
    		$pharmacyData=$this->PharmacyMaster->find('first',array('fields'=>array('Pharmacy_StoreName','Pharmacy_Address1','Pharmacy_Address2',
    				'Pharmacy_Fax','Pharmacy_Telephone1','Pharmacy_City','Pharmacy_StateAbbr',
    				'Pharmacy_Zip','Pharmacy_NCPDP'),'conditions'=>array('Pharmacy_NCPDP'=>$getPharmacyID['Person']['pharmacy_id'])));
    		 
    		$this->set('pharmacyData',$pharmacyData);
    	}

    	$this->set('personIDforEdit',$getPharmacyID['Person']['id']);
    	
    	
    	$this->set('getPatientPharmacy',$getPharmacy);
    	$getInsurancesData=$this->NewInsurance->find('first',array('fields'=>array('id','tariff_standard_name','insurance_number','is_formulatory_check','is_active'),'conditions'=>array('NewInsurance.patient_id'=>$patientId)));
    	$this->set('getInsurancesData',$getInsurancesData);
    	
    	//*************************get element detials****************************
    	$this->Patient->unBindModel(array(
    			'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
    	$this->Patient->bindModel(array(
    			'belongsTo' => array(
    					'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id')),
    					'Appointment' =>array('foreignKey' => false,'conditions'=>array('Appointment.patient_id=Patient.id')),
    			)));
    	$getElement=$this->Patient->find('first',
    			array('fields'=>array('Appointment.date','Person.create_time','Appointment.start_time','Person.id','Person.preferred_language','Person.sex','Person.age','Person.language','Person.photo','Person.phvs_visit_id',
    					'Appointment.visit_type','Patient.form_received_on','Patient.lookup_name','Person.dob','Patient.admission_type','Patient.doctor_id','Patient.instructions'),'conditions'=>array('Patient.id'=>$patientId)));
    	$getCurrentAge=$this->Person->getCurrentAge($getElement['Person']['dob']);
    	$getElement['Person']['age']=$getCurrentAge;
    	 
    	$this->set('getElement',$getElement);
    	//$vistList=$this->VisitType->find('list',array(fields=>array('id','visit_name')));
		//$this->set('vistList',$vistList);
    	$getLanguage=$this->Language->find('list',array('fields'=>array('code','language')));
    	$this->set('language',$getLanguage);
    	//***********************************EOF***************************************************
    	if(empty($id)|| $id==null){
    		//give another chance to find if diagnosis ID is exist
    		$isDiagosesExist = $this->Diagnosis->find('first',array('conditions'=>array('Diagnosis.patient_id'=>$patientId),'fields'=>array('Diagnosis.id'))) ; 
    		if($isDiagosesExist['Diagnosis']['id']) $id = $isDiagosesExist['Diagnosis']['id']  ; 
    	}
    	
    	//if(!empty($id)){  
    		$getDiagnosisData = $this->Diagnosis->getDiagnosisData($patientId);
    		//$this->Session->write('diagnosesID',$getDiagnosisData['Diagnosis']['id']);
    	//}
    	
    	if(!empty($getDiagnosisData)){
    	
    		$this->set('getDiagnosisData',$getDiagnosisData);
    	}
    	
    	//``
    	if(!empty($this->request->data['Diagnosis'])){
    		$Did=$this->Diagnosis->find('first',array('fields'=>array('id','patient_id','note_id'),'conditions'=>array('patient_id'=>$this->request->data['Diagnosis']['patient_id'])));
    		
    		$family_tit_bit=$this->request->data['Diagnosis']['family_tit_bit'];
    		$complaints=$this->request->data['Diagnosis']['complaints'];
    		if(!empty($Did)){
    			$this->request->data['Diagnosis']['modify_time'] = date("Y-m-d H:i:s");
    			$this->request->data['Diagnosis']['modified_by'] =  $this->Session->read('userid');
    			$this->request->data['Diagnosis']['location_id'] = $this->Session->read('locationid');
    			$this->request->data['Diagnosis']['id']=$Did['Diagnosis']['id'];
    			$this->Diagnosis->save($this->request->data['Diagnosis']);
    			if(($Did['Diagnosis']['note_id'] != "") && !empty($Did['Diagnosis']['note_id']) && isset($Did['Diagnosis']['note_id'])){
    				$this->Note->updateAll(array('cc'=>"'$complaints'",'family_tit_bit'=>"'$family_tit_bit'"),
    						array('Note.id'=>$Did['Diagnosis']['note_id']));
    			}
    		}
    		else{
    			$this->request->data['Diagnosis']['create_time'] = date("Y-m-d H:i:s");
    			$this->request->data['Diagnosis']['created_by']  =  $this->Session->read('userid');
    			$this->request->data['Diagnosis']['location_id'] = $this->Session->read('locationid');
    			$this->Diagnosis->save($this->request->data['Diagnosis']);
    		}

    		
    		
    		$lastinsid=$this->Diagnosis->getInsertId();
    		if(!empty($this->request->data['Diagnosis']['id'])){
    			$this->Session->setFlash(__('Record Updated', true, array('class'=>'message')));
    			$this->redirect(array('action'=>'initialAssessment',$this->request->data['Diagnosis']['patient_id'],$this->request->data['Diagnosis']['id']));
    		}
    		else{
    			$this->set('id',$lastinsid);
    			$this->set('patientId',$this->request->data['Diagnosis']['patient_id']);
    			$this->Session->setFlash(__('Record Saved', true, array('class'=>'message')));
    			$this->redirect(array('action'=>'initialAssessment',$this->request->data['Diagnosis']['patient_id'],$lastinsid));
    		}
    		unset($this->request->data['Diagnosis']);
    	}
    
    	//**********Significant Tests Done/Laboratory Reports
    	
    	/* $this->LaboratoryResult->bindModel(array(
    			'belongsTo'=>array('LaboratoryHl7Result'=>array('foreignKey'=>false,'conditions'=>array('LaboratoryResult.id = LaboratoryHl7Result.laboratory_result_id')),
									'Laboratory'=>array('foreignKey'=>false,'conditions'=>array('LaboratoryResult.laboratory_id = Laboratory.id')))
    	));
    	
    	$labResultData = $this->LaboratoryResult->find('all',array('fields'=>array('Laboratory.name','Laboratory.id','LaboratoryHl7Result.result','LaboratoryHl7Result.uom'),
    			'conditions'=>array('LaboratoryResult.patient_id'=>$patientId))); */
		//*****************EOF Significant Tests Done/Laboratory Reports
    	$this->Patient->unbindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn')));
    	$patientUid = $this->Patient->find('first',array('fields'=>array('patient_id'),'conditions'=>array('id'=>$patientId)));
    	$personid = $this->Patient->find('first',array('fields'=>array('person_id'),'conditions'=>array('id'=>$patientId)));
    	//Encouter Data
    	
    	/* $getEncounterId=$this->Note->encounterHandler($patientId,$personid['Patient']['person_id']);
    	if(count($getEncounterId)=='1'){
    		$getEncounterId=$getEncounterId['0'];
    	} */
    	$getEncounterId=$this->Session->read('encounterIdForInitailAsses');
    	//EOF
    	/*$newCropAllergies=$this->NewCropAllergies->find('all',array('conditions'=>array('NewCropAllergies.is_deleted'=>'0','NewCropAllergies.patient_uniqueid'=>$getEncounterId,'NewCropAllergies.patient_id'=>$personid['Patient']['person_id'],'NewCropAllergies.is_reconcile'=>0,'NewCropAllergies.location_id'=>$this->Session->read('locationid'),'NewCropAllergies.status'=>'A')
    			,'fields'=>array('id','patient_id','patient_uniqueid','name','AllergySeverityName','note','onset_date','allergycheck'),'order' => array('NewCropAllergies.patient_id DESC')));
    	if(empty($newCropAllergies)){
    		$newCropAllergies=$this->NewCropAllergies->find('first',array('conditions'=>array('NewCropAllergies.is_deleted'=>'0','NewCropAllergies.patient_uniqueid'=>$getEncounterId,'NewCropAllergies.patient_id'=>$personid['Patient']['person_id'],'NewCropAllergies.is_reconcile'=>0,'NewCropAllergies.location_id'=>$this->Session->read('locationid'),'NewCropAllergies.allergycheck'=>'1')
    				,'fields'=>array('id','patient_id','patient_uniqueid','name','AllergySeverityName','note','onset_date','allergycheck'),'order' => array('NewCropAllergies.patient_id DESC')));
    	}
    	$this->set('newCropAllergies',$newCropAllergies);*/
    	
    	$newCropPrescription=$this->NewCropPrescription->find('all',array('conditions'=>array('patient_uniqueid'=>$getEncounterId,'archive'=>'N'),'fields'=>array('id','description','patient_uniqueid','patient_id')));
    	if(empty($newCropPrescription)){
    		$newCropPrescription=$this->NewCropPrescription->find('first',array('conditions'=>array('patient_uniqueid'=>$getEncounterId,'uncheck'=>'1'),'fields'=>array('id','description','patient_uniqueid','patient_id','uncheck')));
    	}else{
    		$noMed=$this->NewCropPrescription->find('first',array('conditions'=>array('patient_uniqueid'=>$getEncounterId,'uncheck'=>'1'),'fields'=>array('id','description','patient_uniqueid','patient_id','uncheck')));
    		if($noMed['NewCropPrescription']['description']=='No active medication'){
    			$this->NewCropPrescription->deleteAll(array('NewCropPrescription.patient_uniqueid' => $getEncounterId,'NewCropPrescription.description'=> 'No active medication'));
    		}
    	}
    	$this->set('newCropPrescription',$newCropPrescription);
    	//$this->set('labResultData',$labResultData);
    	$this->set('patientId',$patientId);
    	$this->set('personid',$personid);
    	$this->set('id',$id);
    	$this->set('columns',$columns);
    	$this->set('patientUid',$patientUid);
     
    	if($this->request['isAjax'] == 1){ 
    		$this->layout = 'ajax'; 
    		$this->render('ajax_initial_assessment') ;  //for outerdiv   
    	}
    	
    	
    	/*$this->Immunization->bindModel(array(
    			'belongsTo' => array(
    					'PhvsImmunizationInformationSource' =>array('foreignKey' => false,'conditions'=>array('PhvsImmunizationInformationSource.id = Immunization.admin_note' )),
    			)),false);
    	
    	
    	$this->set('imunizationCount',$this->Immunization->find('first',array('fields'=>'id','conditions'=>array('patient_id'=>$patientId,'is_deleted'=>0,'PhvsImmunizationInformationSource.show_in_soap_note'=>0))));*/
    	 
    }
    
    function systemicExamination($patientId=null,$diagnosesId=null){
    	$this->layout = 'ajax' ;
    	$this->uses = array('Template','TemplateTypeContent');
    	//for insert
    	$initialAssessment = 'Initial Assessment';
    	$cntRoe=0;
    	if(!empty($this->request->data['subCategory_examination'])){
    		//*****************check for patient iD************************
    		if(empty($diagnosesId)){
    			$diagnosesId=$this->Diagnosis->addBlankEntry($patientId);
    		}
    		//*************eof****************************	
    		foreach($this->request->data['subCategory_examination'] as $keyRoe=>$checkDataRoe){
    			if (in_array("1", $checkDataRoe)) {
    				$cntRoe++;
    			}
    		}
    		if($cntRoe>0){
    			$categoryExaminationData=$this->TemplateTypeContent->insertRosExamination($this->request->data['subCategory_examination'],'null',$patientId,$diagnosesId);
    		}
    		$this->Session->setFlash(__('Systemic Examination Added Successfully' ),true,array('class'=>'message'));
    		//$this->redirect("/Diagnoses/initialAssessment/$patientId/$diagnosesId");
    		echo "<script> parent.$.fancybox.close();</script>" ;
    	}
    	//EOF insert
    	//for display
    	$this->Template->bindModel(array(
    			'hasMany' => array('TemplateSubCategories' =>array('foreignKey'=>'template_id','conditions'=>array('TemplateSubCategories.is_deleted=0')))));
    	$roseData=$this->Template->find('all',array('conditions'=>array('Template.template_category_id'=>2,'Template.is_deleted=0')));
    	$this->set('roseData',$roseData);
    	$this->set('flag',$initialAssessment);
    	$this->set('patientId',$patientId);
    	$this->set('diagnosesId',$diagnosesId);
    	$this->set('templateTypeContent',$this->TemplateTypeContent->find('list',array('fields'=>array('template_id','template_subcategory_id'),'conditions'=>array('diagnoses_id'=>$diagnosesId,'patient_id'=>$patientId))));
    }
    function currentTreatment($patientId=null,$id,$patientUid=null,$is_deleted=null,$recID=null,$appointmentID,$personId){
    	$this->layout='advance_ajax';
    	$this->set('patientId',$patientId);

    	$this->uses = array('NewCropPrescription','Configuration','NewCropAllergies','Patient','Note','PharmacyItem');
    	
    	//find newcrop health plan
    	$getHealthPlanId=$this->Patient->find('first',array('fields'=>array('patient_health_plan_id'),'conditions'=>array('id'=>$patientId)));
    	$this->set('patientHealthPlanID',$getHealthPlanId['Patient']['patient_health_plan_id']);
    	
    	//For NEWCRoP
    	$getPersonId=$this->Patient->find('first',array('fields'=>array('person_id'),'conditions'=>array('id'=>$patientId)));
    	$this->set('patientUid',$getPersonId['Patient']['person_id']);
    	//EOF
    	
    	/**bof medication is not present**/
    	
    	if(!empty($this->params->query['flag']) && $this->params->query['flag']=='notPresent'){
    		$this->set('flag',$this->params->query['flag']);
    		$medNotPresent=$this->NewCropPrescription->find('first',array('fields'=>array('NewCropPrescription.drug_name','NewCropPrescription.description'),'conditions'=>array('NewCropPrescription.id'=>$id)));
    	
    		$temp=$this->PharmacyItem->find('list',array('fields'=>array('PharmacyItem.drug_id','PharmacyItem.name'),'conditions'=>array('PharmacyItem.name LIKE'=>'%'.$medNotPresent['NewCropPrescription']['description'].'%'/*,'AllergyMaster.status'=>'A'*/)));
    		$this->set('temp',$temp);
    	}
    	/**eof medication is not present**/
    	
    	/**Deletion of Medication**/
    	if(!empty($recID) && !empty($is_deleted) && $is_deleted=='1'){
    		$this->NewCropPrescription->updateAll(array('NewCropPrescription.archive'=>"'D'"),array('NewCropPrescription.id'=>$recID));
    		exit;
    	}
    	$getConfiguration=$this->Configuration->find('all');
    	$strenght=unserialize($getConfiguration[0]['Configuration']['value']);
    	$route=Configure::read('route_administration');
    	$dose=Configure::read('dose_type');
    	//$str1='<select style="width:80px;" id="dose_type'+counter+'" class="" name="dose_type[]">';
    	
    	//----strenght
    	foreach($strenght as $strenghts){
    		$str.='<option value='.'"'.stripslashes($strenghts).'"'.'>'.$strenghts.'</option>';
    	}
    	$str.='</select>';
    	$this->set('str',$str);
    	foreach(unserialize($getConfiguration[0]['Configuration']['value']) as $key=>$strenght){
    		if(!empty($strenght))
    			$strenght_var[$strenght]=$strenght;
    	}
    	$this->set('strenght',$strenght_var);
    	//--eof strenght
    	//-----rout
    	foreach($route as $key => $routes){
    		$str_route.='<option value='.'"'.stripslashes($key).'"'.'>'.$routes.'</option>';
    	}
    	$str_route.='</select>';
    	$this->set('str_route',$str_route);
    	
    	/* foreach(unserialize($getConfiguration[2]['Configuration']['value']) as $key=>$route){
    		if(!empty($route))
    			$route_var[$route]=$route;
    	} */
    	$this->set('route',$route);
    	//-------eof rout
    	//================================ dose
    	foreach($dose as $keyDose =>$doses){
    		$str_dose.='<option value='.'"'.stripslashes($keyDose).'"'.'>'.$doses.'</option>';
    	}
    	$str_dose.='</select>';
    	$this->set('str_dose',$str_dose);
    	// =======================================end dose
		if(!empty($id))
    	$currentresult = $this->NewCropPrescription->find('all',array('conditions'=>array('id'=>$id,'patient_uniqueid'=>$patientId,'archive'=>'N'))); //find prescription
    	$this->set('currentresult',$currentresult);
    	$this->set('appointmentID',$appointmentID);
    	$this->set('personId',$personId);
    }
   

    public function getMedication($patientId,$patientUid,$personId,$appointmentID){
    	
    	$this->layout = 'ajax' ;
    	$this->uses=array('NewCropPrescription','Patient','Note','Diagnosis','VaccineDrug');
    	$this->set('patientId',$patientId) ;
    	$this->set('patientUid',$patientUid);
    	//Encouter Data
    	$getEncounterId=$this->Note->encounterHandler($patientId,$personId);
    	if(count($getEncounterId)=='1'){
    		$getEncounterId=$getEncounterId['0'];
    	}
    	//EOF

    	$this->NewCropPrescription->bindModel(array(
    			'belongsTo' => array(
    					'VaccineDrug' =>array('foreignKey' => false,'conditions'=>array('VaccineDrug.MEDID=NewCropPrescription.drug_id')),
    			)));
    	$getMedicationRecords=$this->NewCropPrescription->find('all',array('conditions'=>array('patient_id'=>$personId,'patient_uniqueid'=>$getEncounterId,'archive'=>'N'),'fields'=>array('VaccineDrug.MEDID','id','description','is_med_administered','refusetotakeimmunization','drug_id','dose','route','frequency','patient_uniqueid','firstdose','patient_id')));

    	$patient_xml=$this->generateXML_prescription($patientId);
    	
    	if(!empty($getMedicationRecords)){
    		$this->Diagnosis->updateAll(array('no_med_flag'=>'"no"'),array('Diagnosis.patient_id'=> $patientId));
    	}
    	
    	$getcheck=$this->Diagnosis->find('first',array('conditions'=>array('patient_id'=>$patientId),'fields'=>array('id','no_med_flag','patient_id')));
    	$this->set('patient_xml', $patient_xml);
    	$this->set('data',$getMedicationRecords);
    	$this->set('getcheck',$getcheck);
    	$this->set('appointmentID',$appointmentID);

    	echo $this->render('get_medication');
    	exit;
    
    }
    
    function medicationHistory($patientId=null,$id,$patientUid=null,$is_deleted=null,$recID=null,$appointmentID){
    	
    	$this->layout='advance_ajax';
    	$this->set('patientId',$patientId);
    	
    	$this->uses = array('NewCropPrescription','Configuration','Patient');
    	
    	//For NEWCRoP
    	$getPersonId=$this->Patient->find('first',array('fields'=>array('person_id'),'conditions'=>array('id'=>$patientId)));
    	$this->set('patientUid',$getPersonId['Patient']['person_id']);
    	//EOF
    	   
    	/**Deletion of Medication**/
    	if(!empty($recID) && !empty($is_deleted) && $is_deleted=='1'){
    		$this->NewCropPrescription->updateAll(array('NewCropPrescription.archive'=>"'D'"),array('NewCropPrescription.id'=>$recID));
    		exit;
    	}
    	
    	$getConfiguration=$this->Configuration->find('all');
    	$strenght=unserialize($getConfiguration[0]['Configuration']['value']);
    	$route=Configure::read('route_administration');
    	$dose=Configure::read('dose_type');
    	//----strenght
    	foreach($strenght as $strenghts){
    		$str.='<option value='.'"'.stripslashes($strenghts).'"'.'>'.$strenghts.'</option>';
    	}
    	$str.='</select>';
    	$this->set('str',$str);
    	foreach(unserialize($getConfiguration[0]['Configuration']['value']) as $key=>$strenght){
    		if(!empty($strenght))
    			$strenght_var[$strenght]=$strenght;
    	}
    	$this->set('strenght',$strenght_var);
    	//--eof strenght
    	//-----rout
    	foreach($route as $keyRoute => $routes){
    		$str_route.='<option value='.'"'.stripslashes($keyRoute).'"'.'>'.$routes.'</option>';
    	}
    	$str_route.='</select>';
    	$this->set('str_route',$str_route);
    	 
    	/* foreach(unserialize($getConfiguration[2]['Configuration']['value']) as $key=>$route){
    		if(!empty($route))
    			$route_var[$route]=$route;
    	} */
    	$this->set('route',$route);
    	//-------eof rout
    	//================================ dose
    	foreach($dose as $keyDose => $doses){
    		$str_dose.='<option value='.'"'.stripslashes($keyDose).'"'.'>'.$doses.'</option>';
    	}
    	$str_dose.='</select>';
    	$this->set('str_dose',$str_dose);
    	// =======================================end dose
    	//--------medication history
    	if(!empty($this->request->data['NewCropPrescription']) && isset($this->request->data)){
    		$result	= $this->Diagnosis->insertCurrentTreatment($this->request->data['NewCropPrescription'],$patientId);
    		if($result){
    			$this->Session->setFlash(__('Medication Saved Successfully' ),true,array('class'=>'message'));
    			//$this->set('status','success') ;
    		    $apptId = trim($this->Session->read('initialAppointmentID'))  ;

    			$diaId = $this->Session->read('diagnosesID') ;
    			if($diaId=='' || $diaId==null){
    				$diaId = 'null' ;
    			}

    			$this->redirect(array('controller'=>'Diagnoses','action'=>'initialAssessment',$patientId,$diaId,$apptId ,'?'=>array('msg'=>'saved')));
    			//$this->redirect("/Diagnoses/initialAssessment/".$patientId."/".$this->Session->read('diagnosesID')."/".$apptId."?msg=saved");
    		}
    	}
    	//-------------------
    	
    	$currentresult = $this->NewCropPrescription->find('all',array('conditions'=>array('id'=>$id,'patient_uniqueid'=>$patientId,'archive'=>'Y'))); 
    	$this->set('currentresult',$currentresult);
    	$this->set('appointmentID',$appointmentID);
    	$this->set('id',$id);
    }
    public function getMedicationHistory($patientId,$patientUid,$personId,$appointmentID){
    	$this->layout = 'ajax' ;
    	$this->uses=array('NewCropPrescription','Patient','Note');
    	$this->set('patientId',$patientId) ;
    	$this->set('personId',$personId) ;
    	$this->set('patientId',$patientId) ;
    	$this->set('appointmentID',$appointmentID) ;
   		 //Encouter Data
    	$getEncounterId=$this->Note->encounterHandler($patientId,$personId);
    	if(count($getEncounterId)=='1'){
    		$getEncounterId=$getEncounterId['0'];
    	}
    	//EOF
    	$getMedicationRecords=$this->NewCropPrescription->find('all',array('conditions'=>array('patient_uniqueid'=>$getEncounterId,'archive'=>'Y'),'fields'=>array('patient_uniqueid','description','dose','route','frequency','patient_uniqueid','firstdose','patient_id','id','last_dose')));
    	$this->set('data',$getMedicationRecords);
    	echo $this->render('get_medication_history');
    	exit;
    
    }
    
    public function otherTreatment($patientId,$id){
    	$this->layout=advance_ajax;
    	$this->set('patientId',$patientId);
    	$this->uses=array('OtherTreatment');
    	if(!empty($this->request->data['OtherTreatment'])){
	    	//if(!empty($this->request->data['OtherTreatment']['chemotherapy_drug_name']) || !empty($this->request->data['OtherTreatment']['radiation_previous_treatment']) || !empty($this->request->data['OtherTreatment']['receive_chemotherapy_date'])){
	    		$this->OtherTreatment->insertOtherTreatment($this->request->data,$patientId);
	    		$this->set('status','success') ;
	    	//}
    	}
    	
    	$getOtherTreatment=$this->OtherTreatment->find('all',array('conditions'=>array('patient_id'=>$patientId/* ,'id'=>$id */)));
    	$this->set('getOtherTreatment',$getOtherTreatment);
    }
    public function getTreatment($patientId){
    	$this->layout='ajax';
    	$this->uses=array('OtherTreatment');
    	$this->set('patientId',$patientId) ;
    	$getTreatmentRecords=$this->OtherTreatment->find('all',array('conditions'=>array('patient_id'=>$patientId),'fields'=>array('chemotherapy',
    			'chemotherapy_drug_name','first_round_date','radiation_therapy','radiation_previous_treatment','radiation_start_date','receive_chemotherapy_concurrently','receive_chemotherapy_date','karnofsky_score')));
    	$this->set('data',$getTreatmentRecords);
    	echo $this->render('get_treatment');
    	exit;
    
    }

    public function addVital($patient_id,$id,$appointmentID,$arr_time=null){
    	$this->layout=advance_ajax;
    	
    	$this->patient_info($patient_id);
    	$this->set('arr_time',$arr_time);
    	$this->set('appointmentID',$appointmentID);
    	$this->set('patient_id',$patient_id);
    	//debug($this->params->query['noteId']);
    	// by aditya
    	if(!empty($this->params->query['form'])){
    		$this->set('soapFlag',$this->params->query['form']);
    	}
    	if(!empty($this->params->query['noteId'])){
    		$this->set('noteIdFlag',$this->params->query['noteId']);
    	}
    	$this->uses = array('BmiResult','BmiBpResult','Patient');
    	 
    	if ($this->request->data['BmiResult'])
    	{ 
    		//debug($this->request->data);exit;
    		$this->request->data['BmiResult']['appointment_id']=$this->request->data['BmiResult']['appointment_id'];
    		$this->request->data['BmiResult']['patient_id']=$patient_id;
    		$this->request->data['BmiResult']['noteId']=$this->request->data['BmiResult']['noteId'];// add note Id;
    		$this->request->data['BmiResult']['location_id']=$this->Session->read('locationid');
    		$this->request->data['BmiResult']['date']=$this->DateFormat->formatDate2STD($this->request->data['BmiResult']['date'],Configure::read('date_format'));
    		$this->request->data['BmiResult']['temperature_date']=$this->DateFormat->formatDate2STD($this->request->data['BmiResult']['temperature_date'],Configure::read('date_format'));
    		$this->request->data['BmiResult']['temperature_date1']=$this->DateFormat->formatDate2STD($this->request->data['BmiResult']['temperature_date1'],Configure::read('date_format'));
    		$this->request->data['BmiResult']['temperature_date2']=$this->DateFormat->formatDate2STD($this->request->data['BmiResult']['temperature_date2'],Configure::read('date_format'));
    		$this->request->data['BmiResult']['heart_rate_date']=$this->DateFormat->formatDate2STD($this->request->data['BmiResult']['heart_rate_date'],Configure::read('date_format'));
    		$this->request->data['BmiResult']['heart_rate_date1']=$this->DateFormat->formatDate2STD($this->request->data['BmiResult']['heart_rate_date1'],Configure::read('date_format'));
    		$this->request->data['BmiResult']['heart_rate_date2']=$this->DateFormat->formatDate2STD($this->request->data['BmiResult']['heart_rate_date2'],Configure::read('date_format'));
    		$this->request->data['BmiResult']['bp_date']=$this->DateFormat->formatDate2STD($this->request->data['BmiResult']['bp_date'],Configure::read('date_format'));
    		$this->request->data['BmiResult']['bp_date1']=$this->DateFormat->formatDate2STD($this->request->data['BmiResult']['bp_date1'],Configure::read('date_format'));
    		$this->request->data['BmiResult']['bp_date2']=$this->DateFormat->formatDate2STD($this->request->data['BmiResult']['bp_date2'],Configure::read('date_format'));
    		$this->request->data['BmiResult']['htWt_date']=$this->DateFormat->formatDate2STD($this->request->data['BmiResult']['htWt_date'],Configure::read('date_format'));
    		$this->request->data['BmiResult']['rr_date']=$this->DateFormat->formatDate2STD($this->request->data['BmiResult']['rr_date'],Configure::read('date_format'));
    		$this->request->data['BmiResult']['circumference_date']=$this->DateFormat->formatDate2STD($this->request->data['BmiResult']['circumference_date'],Configure::read('date_format'));
    		$this->request->data['BmiResult']['spo_date']=$this->DateFormat->formatDate2STD($this->request->data['BmiResult']['spo_date'],Configure::read('date_format'));
    		//$this->request->data['BmiResult']['pain_date']=$this->DateFormat->formatDate2STD($this->request->data['BmiResult']['pain_date'],Configure::read('date_format'));
    		if($this->request->data['BmiResult']['id'] != ''){
    		//	debug($this->request->data);
    		//	array_filter($this->request->data['BmiResult']['pain_present']);
    		//	array_filter($this->request->data['BmiResult']['common_pain']);
    		//	debug($this->request->data['BmiResult']);exit;
    			//delete previous record
    			$this->BmiBpResult->deleteAll(array('bmi_result_id'=>$this->request->data['BmiResult']['id'])); //delete all
    			$this->request->data['BmiResult']['modified_by']=$this->Session->read('userid');
    			$this->request->data['BmiResult']['modified_time']=date("Y-m-d H:i:s");
    			if($this->request->data['BmiResult']['visible']){
    				$this->request->data['BmiResult']['face_score']=$this->request->data['BmiResult']['visible'];
    			}
    			//pain
    			if(!empty($this->request->data['BmiResult']['pain_date'])){
    				$this->request->data['BmiResult']['pain_date'] = implode("&",$this->request->data['BmiResult']['pain_date']);
    			}
    			 
    			if(!empty($this->request->data['BmiResult']['user_id_pain'])){
    				array_filter($this->request->data['BmiResult']['user_id_pain']);
    				$this->request->data['BmiResult']['user_id_pain'] = serialize($this->request->data['BmiResult']['user_id_pain']);
    			}
    			if(!empty($this->request->data['BmiResult']['pain_present'])){  
    				array_filter($this->request->data['BmiResult']['pain_present']);
    				$this->request->data['BmiResult']['pain_present'] = serialize($this->request->data['BmiResult']['pain_present']);
    			}
    			if(!empty($this->request->data['BmiResult']['location'])){
    				array_filter($this->request->data['BmiResult']['location']);
    				$this->request->data['BmiResult']['location'] = serialize($this->request->data['BmiResult']['location']);
    			}
    			if(!empty($this->request->data['BmiResult']['location1'])){
    				array_filter($this->request->data['BmiResult']['location1']);
    				$this->request->data['BmiResult']['location1'] = serialize($this->request->data['BmiResult']['location1']);
    			}
    			if(!empty($this->request->data['BmiResult']['duration'])){
    				array_filter($this->request->data['BmiResult']['duration']);
    				$this->request->data['BmiResult']['duration'] = serialize($this->request->data['BmiResult']['duration']);
    			}
    			if(!empty($this->request->data['BmiResult']['frequency'])){
    				array_filter($this->request->data['BmiResult']['frequency']);
    				$this->request->data['BmiResult']['frequency'] = serialize($this->request->data['BmiResult']['frequency']);
    			}
    			if(!empty($this->request->data['BmiResult']['preferred_pain_tool'])){
    				array_filter($this->request->data['BmiResult']['preferred_pain_tool']);
    				$this->request->data['BmiResult']['preferred_pain_tool'] = serialize($this->request->data['BmiResult']['preferred_pain_tool']);
    			}
    			if(!empty($this->request->data['BmiResult']['modified_flacc_emotion'])){
    				array_filter($this->request->data['BmiResult']['modified_flacc_emotion']);
    				$this->request->data['BmiResult']['modified_flacc_emotion'] = serialize($this->request->data['BmiResult']['modified_flacc_emotion']);
    			}
    			if(!empty($this->request->data['BmiResult']['modified_flacc_movement'])){
    				array_filter($this->request->data['BmiResult']['modified_flacc_movement']);
    				$this->request->data['BmiResult']['modified_flacc_movement'] = serialize($this->request->data['BmiResult']['modified_flacc_movement']);
    			}
    			if(!empty($this->request->data['BmiResult']['modified_flacc_verbal_cues'])){
    				array_filter($this->request->data['BmiResult']['modified_flacc_verbal_cues']);
    				$this->request->data['BmiResult']['modified_flacc_verbal_cues'] = serialize($this->request->data['BmiResult']['modified_flacc_verbal_cues']);
    			}
    			if(!empty($this->request->data['BmiResult']['modified_flacc_facial_cues'])){
    				array_filter($this->request->data['BmiResult']['modified_flacc_facial_cues']);
    				$this->request->data['BmiResult']['modified_flacc_facial_cues'] = serialize($this->request->data['BmiResult']['modified_flacc_facial_cues']);
    			}
    			if(!empty($this->request->data['BmiResult']['modified_flacc_position_guarding'])){
    				array_filter($this->request->data['BmiResult']['modified_flacc_position_guarding']);
    				$this->request->data['BmiResult']['modified_flacc_position_guarding'] = serialize($this->request->data['BmiResult']['modified_flacc_position_guarding']);
    			}
    			if(!empty($this->request->data['BmiResult']['modified_flacc_pain_score'])){
    				array_filter($this->request->data['BmiResult']['modified_flacc_pain_score']);
    				$this->request->data['BmiResult']['modified_flacc_pain_score'] = serialize($this->request->data['BmiResult']['modified_flacc_pain_score']);
    			}
    			if(!empty($this->request->data['BmiResult']['pain'])){
    				array_filter($this->request->data['BmiResult']['pain']);
    				$this->request->data['BmiResult']['pain'] = serialize($this->request->data['BmiResult']['pain']);
    			}
    			if(!empty($this->request->data['BmiResult']['face_score'])){
    				array_filter($this->request->data['BmiResult']['face_score']);
    				$this->request->data['BmiResult']['face_score'] = serialize($this->request->data['BmiResult']['face_score']);
    			}
    			if(!empty($this->request->data['BmiResult']['common_pain'])){
    				array_filter($this->request->data['BmiResult']['common_pain']);
    			//	debug($this->request->data['BmiResult']['common_pain']);
    				$this->request->data['BmiResult']['common_pain'] = serialize($this->request->data['BmiResult']['common_pain']);
    			}   			

    			$this->BmiResult->save($this->request->data['BmiResult']);
    			$bmiBpResult = $this->request->data['BmiBpResult'] ;
    			//foreach($bmiBpResult as $key=>$value){
    				$this->request->data['BmiBpResult']['bmi_result_id']=$this->request->data['BmiResult']['id'] ;
    				//if(!empty($value['systolic']) && !empty($value['diastolic']) ){
    					$this->BmiBpResult->saveAll($this->request->data['BmiBpResult']);
    					$this->BmiBpResult->id='';
    				//}
    			//}
    			
    			$this->Session->setFlash(__('Vitals Added Successfully' ),true,array('class'=>'message'));
    			if(trim($this->request->data['BmiResult']['fromSoap'])=='soap'){

    				$this->redirect("/Notes/soapNote/".$this->request->data['BmiResult']['patientId']."/".
    				$this->request->data['BmiResult']['noteId']."/appt:".$this->request->data['BmiResult']['appointment_id']);
    			}
    			else if(trim($this->request->data['BmiResult']['fromSoap'])=='IpdDashboard'){
    				$this->redirect("/Users/doctor_dashboard");
    			}
    			else if(trim($this->request->data['BmiResult']['fromSoap'])=='soapIpd'){
    				$this->redirect("/Notes/soapNoteIpd/".$this->request->data['BmiResult']['patientId']."/".
    				$this->request->data['BmiResult']['noteId']);
    			}
    			else if($this->request->data['BmiResult']['returnUrl']=='verifyOrderMedication'){
    			$this->redirect("/Patients/verifyOrderMedication/".$this->request->data['BmiResult']['params1']."/".$this->request->data['BmiResult']['params2']."/".$this->request->data['BmiResult']['params3']."/".$this->request->data['BmiResult']['params4']);
    			}
    			else{

    				if(!empty($this->request->data['BmiResult']['arived_time']))
    					$this->redirect("/Diagnoses/initialAssessment/".$patient_id."/".$id."/".$appointmentID."/".$this->request->data['BmiResult']['arived_time']);
    				else
    					$this->redirect("/Diagnoses/initialAssessment/".$patient_id."/".$id."/".$appointmentID);
    			}
    			
    		} else {
    			$this->request->data['BmiResult']['appointment_id']=$this->request->data['BmiResult']['appointment_id'];
    			$this->request->data['BmiResult']['patient_id']=$this->request->data['BmiResult']['patientId'];
    			$this->request->data['BmiResult']['note_id']=$this->request->data['BmiResult']['noteId'];
    			$this->request->data['BmiResult']['created_by']=$this->Session->read('userid');
    			$this->request->data['BmiResult']['created_time']=date("Y-m-d H:i:s");
    			$this->request->data['BmiResult']['location_id']=$this->Session->read('locationid');
    			if($this->request->data['BmiResult']['visible']){
    				$this->request->data['BmiResult']['face_score']=$this->request->data['BmiResult']['visible'];
    			}
    			//pain
    			if(!empty($this->request->data['BmiResult']['pain_date'])){
    				$this->request->data['BmiResult']['pain_date'] = implode("&",$this->request->data['BmiResult']['pain_date']);
    			}
    			
    			if(!empty($this->request->data['BmiResult']['user_id_pain'])){
    				array_filter($this->request->data['BmiResult']['user_id_pain']);
    				$this->request->data['BmiResult']['user_id_pain'] = serialize($this->request->data['BmiResult']['user_id_pain']);
    			}
    			if(!empty($this->request->data['BmiResult']['pain_present'])){
    				array_filter($this->request->data['BmiResult']['location']);
    				$this->request->data['BmiResult']['pain_present'] = serialize($this->request->data['BmiResult']['pain_present']);
    			}
    			if(!empty($this->request->data['BmiResult']['location'])){
    				array_filter($this->request->data['BmiResult']['location']);
    				$this->request->data['BmiResult']['location'] = serialize($this->request->data['BmiResult']['location']);
    			}
    			if(!empty($this->request->data['BmiResult']['location1'])){
    				array_filter($this->request->data['BmiResult']['location1']);
    				$this->request->data['BmiResult']['location1'] = serialize($this->request->data['BmiResult']['location1']);
    			}
    			if(!empty($this->request->data['BmiResult']['duration'])){
    				array_filter($this->request->data['BmiResult']['duration']);
    				$this->request->data['BmiResult']['duration'] = serialize($this->request->data['BmiResult']['duration']);
    			}
    			if(!empty($this->request->data['BmiResult']['frequency'])){
    				array_filter($this->request->data['BmiResult']['frequency']);
    				$this->request->data['BmiResult']['frequency'] = serialize($this->request->data['BmiResult']['frequency']);
    			}
    			if(!empty($this->request->data['BmiResult']['preferred_pain_tool'])){
    				array_filter($this->request->data['BmiResult']['preferred_pain_tool']);
    				$this->request->data['BmiResult']['preferred_pain_tool'] = serialize($this->request->data['BmiResult']['preferred_pain_tool']);
    			}
    			if(!empty($this->request->data['BmiResult']['modified_flacc_emotion'])){
	    				array_filter($this->request->data['BmiResult']['modified_flacc_emotion']);
    				$this->request->data['BmiResult']['modified_flacc_emotion'] = serialize($this->request->data['BmiResult']['modified_flacc_emotion']);
    			}
    			if(!empty($this->request->data['BmiResult']['modified_flacc_movement'])){
    				array_filter($this->request->data['BmiResult']['modified_flacc_movement']);
    				$this->request->data['BmiResult']['modified_flacc_movement'] = serialize($this->request->data['BmiResult']['modified_flacc_movement']);
    			}
    			if(!empty($this->request->data['BmiResult']['modified_flacc_verbal_cues'])){
    				array_filter($this->request->data['BmiResult']['modified_flacc_verbal_cues']);
    				$this->request->data['BmiResult']['modified_flacc_verbal_cues'] = serialize($this->request->data['BmiResult']['modified_flacc_verbal_cues']);
    			}
    			if(!empty($this->request->data['BmiResult']['modified_flacc_facial_cues'])){
    				array_filter($this->request->data['BmiResult']['modified_flacc_facial_cues']);
    				$this->request->data['BmiResult']['modified_flacc_facial_cues'] = serialize($this->request->data['BmiResult']['modified_flacc_facial_cues']);
    			}
    			if(!empty($this->request->data['BmiResult']['modified_flacc_position_guarding'])){
    				array_filter($this->request->data['BmiResult']['modified_flacc_position_guarding']);
    				$this->request->data['BmiResult']['modified_flacc_position_guarding'] = serialize($this->request->data['BmiResult']['modified_flacc_position_guarding']);
    			}
    			if(!empty($this->request->data['BmiResult']['modified_flacc_pain_score'])){
    				array_filter($this->request->data['BmiResult']['modified_flacc_pain_score']);
    				$this->request->data['BmiResult']['modified_flacc_pain_score'] = serialize($this->request->data['BmiResult']['modified_flacc_pain_score']);
    			}
    			if(!empty($this->request->data['BmiResult']['pain'])){
    				array_filter($this->request->data['BmiResult']['pain']);
    				$this->request->data['BmiResult']['pain'] = serialize($this->request->data['BmiResult']['pain']);
    			}
    			if(!empty($this->request->data['BmiResult']['face_score'])){
    				array_filter($this->request->data['BmiResult']['face_score']);
    				$this->request->data['BmiResult']['face_score'] = serialize($this->request->data['BmiResult']['face_score']);
    			}
    			if(!empty($this->request->data['BmiResult']['common_pain'])){
    				array_filter($this->request->data['BmiResult']['common_pain']);
    				$this->request->data['BmiResult']['common_pain'] = serialize($this->request->data['BmiResult']['common_pain']);
    			}
    			$this->BmiResult->save($this->request->data);
    			$bmiBpResult = $this->request->data['BmiBpResult'] ;
    			
    				$this->request->data['BmiBpResult']['bmi_result_id']=$this->BmiResult->id ; //last insert id
    					$this->BmiBpResult->saveAll($this->request->data['BmiBpResult']);
    					$this->BmiBpResult->id='';
    				
    			$this->Session->setFlash(__('Vitals Added Successfully' ),true,array('class'=>'message'));
    			//$this->set('status','success') ; (for closing fancybox)
    		if(trim($this->request->data['BmiResult']['fromSoap'])=='soap'){
    			$this->redirect("/Notes/soapNote/".$this->request->data['BmiResult']['patientId']."/".$this->request->data['BmiResult']['noteId']."/appt:".$this->request->data['BmiResult']['appointment_id']);
    		}
    		
    		else if(trim($this->request->data['BmiResult']['fromSoap'])=='soapIpd'){
    				$this->redirect("/Notes/soapNoteIpd/".$this->request->data['BmiResult']['patientId']."/".
    				$this->request->data['BmiResult']['noteId']);
    		}
    		else if(trim($this->request->data['BmiResult']['fromSoap'])=='IpdDashboard'){
    			$this->redirect("/Users/doctor_dashboard");
    		}
    		else if($this->request->data['BmiResult']['returnUrl']=='verifyOrderMedication'){
    			$this->redirect("/Patients/verifyOrderMedication/".$this->request->data['BmiResult']['params1']."/".$this->request->data['BmiResult']['params2']."/".$this->request->data['BmiResult']['params3']."/".$this->request->data['BmiResult']['params4']);
    		}else{
    			$this->redirect("/Diagnoses/initialAssessment/".$patient_id."/".$id."/".$appointmentID."/".$this->request->data['BmiResult']['arived_time']);
    			}
    		}
    	}
    	$userName = $this->User->getUsers();
    	$this->set("userName",$userName);
    	
    	$this->BmiResult->bindModel(array(
    			'belongsTo' => array('BmiBpResult'=>array('conditions'=>array('BmiBpResult.bmi_result_id=BmiResult.id'),'foreignKey'=>false)
    			)));
    	
    	/* $this->BmiResult->bindModel(array(
    			'belongsTo' => array(
    					'User'=>array('conditions'=>array('User.id=BmiResult.user_id'),'foreignKey'=>false,'fields'=>array('User.first_name','User.last_name')),
    					'User1'=>array('conditions'=>array('User1.id=BmiResult.user_id1'),'foreignKey'=>false,'className'=>'User','fields'=>array('User1.first_name','User1.last_name')),
    					'User2'=>array('conditions'=>array('User2.id=BmiResult.user_id2'),'foreignKey'=>false,'className'=>'User','fields'=>array('User2.first_name','User2.last_name')),
    					'User3'=>array('conditions'=>array('User3.id=BmiResult.user_id_hw'),'foreignKey'=>false,'className'=>'User','fields'=>array('User3.first_name','User3.last_name')),
    					'User4'=>array('conditions'=>array('User4.id=BmiResult.user_id_hr'),'foreignKey'=>false,'className'=>'User','fields'=>array('User4.first_name','User4.last_name')),
    					'User5'=>array('conditions'=>array('User5.id=BmiResult.user_id_hr1'),'foreignKey'=>false,'className'=>'User','fields'=>array('User5.first_name','User5.last_name')),
    					'User6'=>array('conditions'=>array('User6.id=BmiResult.user_id_hr2'),'foreignKey'=>false,'className'=>'User','fields'=>array('User6.first_name','User6.last_name')),
    					'User7'=>array('conditions'=>array('User7.id=BmiResult.user_id_bp'),'foreignKey'=>false,'className'=>'User','fields'=>array('User7.first_name','User7.last_name')),
    					'User8'=>array('conditions'=>array('User8.id=BmiResult.user_id_bp1'),'foreignKey'=>false,'className'=>'User','fields'=>array('User8.first_name','User8.last_name')),
    					'User9'=>array('conditions'=>array('User9.id=BmiResult.user_id_bp2'),'foreignKey'=>false,'className'=>'User','fields'=>array('User9.first_name','User9.last_name')),
    					'User10'=>array('conditions'=>array('User10.id=BmiResult.user_id_res'),'foreignKey'=>false,'className'=>'User','fields'=>array('User10.first_name','User10.last_name')),
    					'User11'=>array('conditions'=>array('User11.id=BmiResult.user_id_cir'),'foreignKey'=>false,'className'=>'User','fields'=>array('User11.first_name','User11.last_name')),
    					'User12'=>array('conditions'=>array('User12.id=BmiResult.user_id_spo'),'foreignKey'=>false,'className'=>'User','fields'=>array('User12.first_name','User12.last_name')),
    					'User13'=>array('conditions'=>array('User13.id=BmiResult.user_id_pain'),'foreignKey'=>false,'className'=>'User','fields'=>array('User13.first_name','User13.last_name')),
    					'BmiBpResult'=>array('conditions'=>array('BmiBpResult.bmi_result_id=BmiResult.id'),'foreignKey'=>false)
    			))); */
    	if($this->params->query['form']=='soapIpd'){
    		$result1 = $this->BmiResult->find('first',array('conditions'=>array('patient_id'=>$patient_id,'note_id'=>$this->params->query['noteId'])));
    	}
    	else{
    		$result1 = $this->BmiResult->find('first',array('conditions'=>array('patient_id'=>$patient_id,'appointment_id'=>$appointmentID)));
    	}
     	$this->Patient->bindModel( array(
    			'belongsTo' => array(
     					'Person'=>array('conditions'=>array('Person.id=Patient.person_id'),'foreignKey'=>false)
     			)
     	));
    	$patient = $this->Patient->find('first',array('fields'=>array('Person.dob','Patient.person_id','Patient.sex'),'conditions'=>array('Patient.id'=>$patient_id)));
     	$var=$this->DateFormat->dateDiff($patient['Person']['dob'],date('Y-m-d'));
    	$day=$var->days; 
    	$year=$var->y;
    	$this->set('result1',$result1);
    	$this->set('diagnoses_id',$id);
    $this->set(compact('year'));
    }
    
    public function getvital($patient_id,$id,$personId,$appointmentID=null){
    	$this->layout='ajax';
    	$this->uses = array('BmiResult','BmiBpResult','Patient');
    	$this->BmiResult->bindModel(array(
    			'hasMany' => array(
    					'BmiBpResult' =>array( 'foreignKey'=>'bmi_result_id','order'=>'BmiBpResult.id ASC')
    			)));
    	/* $get_vital = $this->BmiResult->find('first',array('conditions'=>array('patient_id'=>$patient_id,'appointment_id'=>$appointmentID),'fields'=>array('BmiResult.patient_id','BmiResult.temperature','BmiResult.temperature1','BmiResult.temperature2','BmiResult.myoption','BmiResult.myoption1','BmiResult.myoption2','BmiResult.height_result','BmiResult.weight_result','BmiResult.bmi'))); //find vitals
    	$this->set('data',$get_vital); */
    	$patientIDS = $this->Patient->getAllPatientIds($personId);
    	$result = $this->BmiResult->find('all', array('conditions'=>array('patient_id'=>$patientIDS),'order'=>array('BmiResult.appointment_id DESC'))); //find vitals outpt.
    	foreach($result as $key=>$result1){
    		 
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
    	$this->set('getVitals',$dataMeasureVitals);
    	$this->set('id',$id);
    	$this->set('appointmentID',$appointmentID);
    	echo $this->render('get_vital');
    	exit;
    }
    
public function significantHistory($patient_id,$personId,$appointmentID,$note_id){
		$this->set('patient_id',$patient_id);
		$this->layout='advance_ajax';
		$this->patient_info($patient_id);
		$this->set("appointment_id",$appointmentID);
		$this->set("note_id",$note_id);
		
		
		//ob_end_clean();
		//if(ob_start("ob_gzhandler"));
		
		$this->set('title_for_layout', __('-Patient Diagnosis', true));
		//load model
		$this->uses = array('NoteDiagnosis','Note','OtherTreatment','Person','Diagnosis','Configuration','DiagnosisDrug','PastMedicalRecord','PatientPastHistory','PatientPersonalHistory','PatientFamilyHistory','PatientAllergy','Doctor',
				'NewCropPrescription','PregnancyCount','PastMedicalHistory','ProcedureHistory','BmiResult','BmiBpResult','FamilyHistory','SmokingStatusOncs','PatientSmoking','AlcohalAssesment','SurgeryCategory');
		
		$privateID = $this->SurgeryCategory->getServiceCategoryID();//retrive service category id
		$this->set('privateID',$privateID);
		$alcohol_fill = $this->AlcohalAssesment->find('first',array('conditions'=>array('AlcohalAssesment.patient_id'=>$patient_id),'fields'=>array('AlcohalAssesment.total_score')));
		$this->set('alcohol_fill',$alcohol_fill);
		$this->patient_info($patient_id);
		$getEthnicityData=$this->patient_details['Person']['ethnicity'];
		$getmaritailStatusData=$this->patient_details['Person']['maritail_status'];
		$this->set(compact('getEthnicityData','getmaritailStatusData'));
		
		
		//set return page url in session
		//--- New Medication Unit DOSE AND STRENGHT ADD DO NOT REMOVE
		/* debug('route_administration');
		 debug(serialize(Configure::read('route_administration')));
		debug('strength');
		debug(serialize(Configure::read('strength')));
		debug('dose_type'); */
		
		if($allergyid=='sbar'){
			$this->set('flag',$allergyid);
		}
		$getConfiguration=$this->Configuration->find('all');
		$strenght=unserialize($getConfiguration[0]['Configuration']['value']);
		$dose=unserialize($getConfiguration[1]['Configuration']['value']);
		$route=unserialize($getConfiguration[2]['Configuration']['value']);
		//$str1='<select style="width:80px;" id="dose_type'+counter+'" class="" name="dose_type[]">';
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
		//$this->set('strenght',unserialize($getConfiguration[0]['Configuration']['value']));
		foreach(unserialize($getConfiguration[0]['Configuration']['value']) as $key=>$strenght){
			if(!empty($strenght))
				$strenght_var[$strenght]=$strenght;
		}
		$this->set('strenght',$strenght_var);
		//$this->set('dose',unserialize($getConfiguration[1]['Configuration']['value']));
		foreach(unserialize($getConfiguration[1]['Configuration']['value']) as $key=>$doses){
			if(!empty($doses))
				$dose_var[$doses]=$doses;
		}
		$this->set('dose',$dose_var);
		//$this->set('route',unserialize($getConfiguration[2]['Configuration']['value']));
		foreach(unserialize($getConfiguration[2]['Configuration']['value']) as $key=>$route){
			if(!empty($route))
				$route_var[$route]=$route;
		}
		$this->set('route',$route_var);
		//==========================================================
		
		
		//BOF pankaj  **** This code is commented by gulshan because of past medical history recordd ..(patient id is over write)
		//If there is previous encounter in our database
		/* if(empty($this->request->data['Diagnosis']['patient_id'])){
		 $this->set('patient_id',$patient_id); // set before change patient id
		$prevID = $this->Diagnosis->getPrevEncounterID($patient_id,$this->patient_details['Patient']['person_id']);
		
		if(!empty($prevID)) $patient_id = $prevID ;
		} */
		//EOF pankaj
		
		//BOF referer link
		$sessionReturnString = $this->Session->read('returnPage') ;
		$currentReturnString = $this->params->query['return'] ;
		if(($currentReturnString!='') && ($currentReturnString != $sessionReturnString) ){
			$this->Session->write('returnPage',$currentReturnString);
		}else if($currentReturnString ==''){
			$this->Session->delete('returnPage');
		}
		//EOF referer link
		if(isset($this->request->data) && !empty($this->request->data)){
				
		
			$this->Diagnosis->addBlankEntry($this->request->data['Diagnosis']['patient_id']); //blank entry
			//---------ProcedureHistory
		
		
		
			if(!empty($this->request->data['ProcedureHistory'])){
				$procedureHistory = $this->Diagnosis->insertProcedureHistory($this->request->data['ProcedureHistory'],$patient_id);
			}
				
			//--------current treatment
			if(!empty($this->request->data['NewCropPrescription']) && isset($this->request->data)){
		
				$this->Diagnosis->insertCurrentTreatment($this->request->data['NewCropPrescription'],$patient_id);
			}
			//$this->NewCropPrescription->insertMedication_order($this->request->data['NewCropPrescription']);
				
			//convert date to DB format
			if(!empty($this->request->data["Diagnosis"]['next_visit'])){
				$this->request->data["Diagnosis"]['next_visit'] = $this->DateFormat->formatDate2STD($this->request->data["Diagnosis"]['next_visit'],Configure::read('date_format'));
			}
				
			//-------------------
			$this->request->data['PersonalHealth']['disability'] =$this->request->data['Diagnosis']['disability'];
			$this->request->data['PersonalHealth']['effective_date'] =$this->request->data['Diagnosis']['effective_date'];
			$this->request->data['PersonalHealth']['status_option'] =$this->request->data['Diagnosis']['status_option'];
				
				
			$impldata = $this->request->data['PersonalHealth'];
			foreach($impldata as $key => $impldata){
				if(substr($key, 0, 10) == 'disability'){
					$disable[] = $impldata;
				}
				if(substr($key, 0, 14) == 'effective_date'){
					$effec_date[] = $impldata;
				}
				if(substr($key, 0, 13) == 'status_option'){
					$stat_opt[] = $impldata;
				}
		
			}
			$disable = implode('|',$disable);
			$effec_date = implode('|',$effec_date);
			$stat_opt = implode('|',$stat_opt);
				
			$this->request->data['Diagnosis']['disability']=$disable;
			$this->request->data['Diagnosis']['effective_date']=$effec_date;
			$this->request->data['Diagnosis']['status_option']=$stat_opt;
				
			//---------------
			//insert diagnosis record for a patient
			$this->request->data['Diagnosis']['positive_tb_date']=$this->DateFormat->formatDate2STD($this->request->data['Diagnosis']['positive_tb_date'],Configure::read('date_format'));
			$diagnosisId = $this->Diagnosis->insertDiagnosis($this->request->data);
			if($diagnosisId){
				//After saving initial assesment change status in appoinment table
				if(!empty($this->request->data['Diagnosis']['appointmentId'])){
					$this->loadModel('Appointment');
					$updateArray = array('Appointment.status'=>"'In-Progress'") ;
					$this->Appointment->updateAll($updateArray,array('Appointment.id '=>$this->request->data['Diagnosis']['appointmentId']));
				}
		
			}
			//**************BOF-OtherTreatment-Mahalaxmi**********************//
			if(!empty($this->request->data['OtherTreatment'])){
				$this->OtherTreatment->insertOtherTreatment($this->request->data,$patient_id);
			}
				
			//**************EOF-OtherTreatment-Mahalaxmi**********************//
			//---------yash
			//-------vitals---
			//hasMany insert
			$this->BmiResult->bindModel(array(
					'hasMany' => array(
							'BmiBpResult' =>array( 'foreignKey'=>'bmi_result_id')
					)));
			if ($this->request->data['BmiResult'])
			{
				$this->request->data['BmiResult']['patient_id']=$patient_id;
				$this->request->data['BmiResult']['location_id']=$this->Session->read('locationid');
				$this->request->data['BmiResult']['date']=$this->DateFormat->formatDate2STD($this->request->data['Diagnosis']['capture_date'],Configure::read('date_format'));
				if($this->request->data['BmiResult']['id'] != ''){
					//delete previous record
					$this->BmiBpResult->deleteAll(array('bmi_result_id'=>$this->request->data['BmiResult']['id'])); //delete all
					$this->request->data['BmiResult']['modified_by']=$this->Session->read('userid');
					$this->request->data['BmiResult']['modified_time']=date("Y-m-d H:i:s");
					$this->BmiResult->save($this->request->data['BmiResult']);
					$bmiBpResult = $this->request->data['BmiBpResult'] ;
					foreach($bmiBpResult as $key=>$value){
						$value['bmi_result_id']=$this->request->data['BmiResult']['id'] ;
						$this->BmiBpResult->saveAll($value);
						$this->BmiBpResult->id='';
					}
						
				} else {
					$this->request->data['BmiResult']['patient_id']=$patient_id;
					$this->request->data['BmiResult']['created_by']=$this->Session->read('userid');
					$this->request->data['BmiResult']['created_time']=date("Y-m-d H:i:s");
					$this->request->data['BmiResult']['location_id']=$this->Session->read('locationid');
					$this->request->data['BmiResult']['date']=$this->DateFormat->formatDate2STD($this->request->data['Diagnosis']['capture_date'],Configure::read('date_format'));
					$this->BmiResult->saveAll($this->request->data);
						
				}
			}
				
			//---pregnancy count--
			if(!empty($this->request->data['pregnancy'])){
				$pregnency_count = $this->Diagnosis->insertPregnancyCount($this->request->data['pregnancy'],$patient_id);
			}
				
			//--------
			//---past medical history
			//--------
			if(!empty($this->request->data['PastMedicalHistory'])){
				$past_history = $this->Diagnosis->insertPastMedicalHistory($this->request->data['PastMedicalHistory'],$patient_id,$appointmentID);
			}
			//--------
				
			//BOF history
			$this->request->data['PatientPastHistory']['diagnosis_id'] = $diagnosisId;
			$this->PatientPastHistory->save($this->request->data['PatientPastHistory']);
			$this->request->data['PatientPersonalHistory']['diagnosis_id'] = $diagnosisId;
			$this->request->data['PatientPersonalHistory']['capture_date'] =$this->DateFormat->formatDate2STD($this->request->data['Diagnosis']['capture_date'],Configure::read('date_format'));
			$this->request->data['PatientSmoking']['diagnosis_id'] = $diagnosisId;
			if(!empty($this->request->data["PatientSmoking"]['pre_from'])){
				$this->request->data["PatientSmoking"]['pre_from'] = $this->DateFormat->formatDate2STD($this->request->data["PatientSmoking"]['pre_from'],Configure::read('date_format'));
				//calculate age on the basis of entered DOB
				//$this->request->data["Person"]['age'] = $this->DateFormat->getAge($this->request->data["Person"]['dob']) ;
		
			}
			if(!empty($this->request->data["PatientSmoking"]['pre_to'])){
				$this->request->data["PatientSmoking"]['pre_to'] = $this->DateFormat->formatDate2STD($this->request->data["PatientSmoking"]['pre_to'],Configure::read('date_format'));
				//calculate age on the basis of entered DOB
				//$this->request->data["Person"]['age'] = $this->DateFormat->getAge($this->request->data["Person"]['dob']) ;
		
			}
			$date = date('Y-m-d h:i:s', time());
			if($this->request->data['PatientSmoking']['current_smoking_fre']==''){
				$this->request->data['PatientSmoking']['current_smoking_fre'] = $this->request->data['PatientSmoking']['smoking_fre2'];
				$this->request->data["PatientSmoking"]['created_date'] = $date;
				//$this->request->data['PatientSmoking']['current_smoking_fre'] = $this->request->data['PatientSmoking']['current_smoking_fre'];
				// unset($this->request->data['PatientPersonalHistory']['smoking_fre1']);
		
			}
			else{
				if($this->request->data['PatientSmoking']['smoking_fre2']!=''){
					$this->request->data['PatientSmoking']['smoking_fre'] = $this->request->data['PatientSmoking']['current_smoking_fre'];
					//$this->request->data['PatientSmoking']['current_smoking_fre'] = $this->request->data['SmokingStatusOncs.description'];
					$this->request->data['PatientSmoking']['current_smoking_fre'] = $this->request->data['PatientSmoking']['smoking_fre2'];
					$this->request->data["PatientSmoking"]['created_date'] = $date;
					$this->request->data['PatientSmoking']['current_from'] = $this->request->data['PatientSmoking']['pre_from1'];
					$this->request->data['PatientSmoking']['current_to'] = $this->request->data['PatientSmoking']['pre_to1'];
				}
				else{
					$this->request->data['PatientSmoking']['smoking_fre'] = $this->request->data['PatientSmoking']['smoking_fre'];
					//$this->request->data['PatientSmoking']['current_smoking_fre'] = $this->request->data['SmokingStatusOncs.description'];
					$this->request->data['PatientSmoking']['current_smoking_fre'] = $this->request->data['PatientSmoking']['current_smoking_fre'];
					$this->request->data["PatientSmoking"]['created_date'] = $date;
					$this->request->data['PatientSmoking']['pre_from'] = $this->request->data['PatientSmoking']['pre_from1'];
					$this->request->data['PatientSmoking']['pre_to'] = $this->request->data['PatientSmoking']['pre_to1'];
					$this->request->data['PatientSmoking']['current_from'] = $this->request->data['PatientSmoking']['current_from1'];
					$this->request->data['PatientSmoking']['current_to'] = $this->request->data['PatientSmoking']['current_to1'];
						
				}
			}
				
			//debug($this->request->data['PatientPersonalHistory']);exit;
			$this->PatientPersonalHistory->save($this->request->data['PatientPersonalHistory']);
			$this->PatientSmoking->save($this->request->data['PatientSmoking']);
				
			//debug($this->request->data); exit;
			$this->request->data['PatientFamilyHistory']['diagnosis_id'] = $diagnosisId;
			$this->PatientFamilyHistory->save($this->request->data['PatientFamilyHistory']);
			$this->request->data['PatientAllergy']['diagnosis_id'] = $diagnosisId;
			if($this->request->data['PatientAllergy']['allergies']==0){
				//unset previously added reaction if any
				$this->request->data['PatientAllergy']['from1'] ='';
				$this->request->data['PatientAllergy']['reaction1'] ='' ;
				$this->request->data['PatientAllergy']['from2'] ='';
				$this->request->data['PatientAllergy']['reaction2'] ='';
				$this->request->data['PatientAllergy']['from3'] ='';
				$this->request->data['PatientAllergy']['reaction3'] ='' ;
			}
			$this->PatientAllergy->save($this->request->data['PatientAllergy']);
			$this->FamilyHistory->save($this->request->data['FamilyHistory']);
				
			if($this->request->data['Diagnosis']['id']) {
				$this->Session->setFlash(__('Record Updated Successfully.', true));
			}else{
				$this->Session->setFlash(__('Record Added Successfully.', true));
			}
			$this->redirect(array('controller'=>'Notes','action'=>'clinicalNote',$patient_id,$appointmentID,$note_id,'?'=>array('isSaveHistory'=>'yes')));
			
		/*	if($this->request->data['Diagnosis']['flag']=='sbar'){
				$this->redirect("/PatientsTrackReports/sbar/".$patient_id);
			}else{
				$this->Session->setFlash(__($msg, true));
				//$this->redirect(array('controller'=>'appointments','action'=>'appointments_management'));
				//	$this->set('status','success') ;
				$this->redirect("/Diagnoses/initialAssessment/".$patient_id."/".$this->Session->read('diagnosesID')."/".$this->Session->read('initialAppointmentID'));
			}
			*/	
				
		}else if(empty($patient_id)){
			$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
			$this->redirect($this->referer());
		}
		//Encouter Data
		$getEncounterId=$this->Note->encounterHandler($patient_id,$personId);
		//debug($getEncounterId);exit;
		if(count($getEncounterId)=='1'){
			$getEncounterId=$getEncounterId['0'];
		}
		//EOF
		$getpatient=$this->PastMedicalRecord->find('all',array('conditions'=>array('patient_id'=>$patient_id)));
		$getpatientfamilyhistory = $this->FamilyHistory->find('all',array('conditions'=>array('patient_id'=>$getEncounterId)));
		$smokingOptions =$this->SmokingStatusOncs->find('list',array('fields'=>array('description')));
		//debug($getpatientfamilyhistory);exit;
		$this->set(compact('smokingOptions'));
		$this->set('getpatient',$getpatient);
		$this->set('getpatientfamilyhistry',$getpatientfamilyhistory);
		
		//check if patient record is exist
		$this->Diagnosis->bindModel( array(
				'belongsTo' => array(
						/*'PatientAllergy'=>array('conditions'=>array('Diagnosis.id=PatientAllergy.diagnosis_id'),'foreignKey'=>false),*/
						'PatientPersonalHistory'=>array('conditions'=>array('Diagnosis.id=PatientPersonalHistory.diagnosis_id'),'foreignKey'=>false,'order'=>array('PatientSmoking.id DESC'),'limit'=>1),
						'PatientSmoking'=>array('conditions'=>array('Diagnosis.id=PatientSmoking.diagnosis_id'),'foreignKey'=>false),
						'PatientPastHistory'=>array('conditions'=>array('Diagnosis.id=PatientPastHistory.diagnosis_id'),'foreignKey'=>false),
						'FamilyHistory'=>array('conditions'=>array('Diagnosis.patient_id=FamilyHistory.patient_id'),'foreignKey'=>false),
						'PatientFamilyHistory'=>array('conditions'=>array('Diagnosis.id=PatientFamilyHistory.diagnosis_id'),'foreignKey'=>false),
						/* 'SmokingStatusOncs'=>array('className'=>'SmokingStatusOncs','conditions'=>array('PatientSmoking.smoking_fre=SmokingStatusOncs.id'),'foreignKey'=>false),
						 'SmokingStatusOncs1'=>array('className'=>'SmokingStatusOncs','conditions'=>array('PatientSmoking.current_smoking_fre=SmokingStatusOncs1.id'),'foreignKey'=>false)*/
				)
		));
		
		$diagnosisRec = $this->Diagnosis->find('first',array('conditions'=>array('Diagnosis.patient_id'=>$patient_id)));
		
		
		//past medical history
		$pastMedicalHistoryRec = $this->PastMedicalHistory->find('all',array('fields'=>array('PastMedicalHistory.*'), 'conditions'=>array('patient_id'=>$getEncounterId),'order'=>array('PastMedicalHistory.patient_id Asc')));
		
		$this->set('pastHistory',$pastMedicalHistoryRec);
		if($this->patient_details['Person']['sex']){
			$pregnancyCountRec = $this->PregnancyCount->find('all',array('fields'=>array('PregnancyCount.counts,PregnancyCount.date_birth,PregnancyCount.weight,PregnancyCount.baby_gender,
											PregnancyCount.week_pregnant,PregnancyCount.type_delivery,PregnancyCount.complication'), 'conditions'=>array('patient_id'=>$patient_id),'order'=>array('PregnancyCount.id Asc')));
			$this->set('pregnancyData',$pregnancyCountRec);
				
			unset($this->request->data); //added by pankaj M since request->data was always coming when intial assesment page is refreshed after clicking on submit button
		}
		
		///////////////BOF --------OtherTreatment-Mahalaxmi
		$getOtherTreatment=$this->OtherTreatment->find('all',array('conditions'=>array('patient_id'=>$patient_id)));
		$this->set(compact('getOtherTreatment'));
		///////////////EOF --------OtherTreatment-Mahalaxmi
		
		//BOF --------ProcedureHistory
		$this->ProcedureHistory->bindModel( array(
				'belongsTo' => array(
						'DoctorProfile'=>array('foreignKey'=>false,'conditions'=>array('ProcedureHistory.provider=DoctorProfile.id')),
						'TariffList'=>array('foreignKey'=>false,'conditions'=>array('ProcedureHistory.procedure=TariffList.id')),
				)));
		
		$procedureHistoryRec = $this->ProcedureHistory->find('all',array('fields'=>array('TariffList.id','TariffList.name','DoctorProfile.id',
				'DoctorProfile.doctor_name','ProcedureHistory.procedure','ProcedureHistory.provider','ProcedureHistory.age_value','ProcedureHistory.age_unit',
				'ProcedureHistory.procedure_date','ProcedureHistory.comment','ProcedureHistory.procedure_name','ProcedureHistory.provider_name','ProcedureHistory.no_surgical'),
				'conditions'=>array('ProcedureHistory.patient_id'=>$patient_id),'order'=>array('ProcedureHistory.id Asc')));
		$this->set('procedureHistory',$procedureHistoryRec);
		//EOF ProcedureHistory
		
		$diagnosisDrugRec = $this->DiagnosisDrug->find('all',array('fields'=>array('DiagnosisDrug.mode,DiagnosisDrug.tabs_per_day,DiagnosisDrug.mode,DiagnosisDrug.quantity,
							DiagnosisDrug.tabs_frequency,DiagnosisDrug.first,DiagnosisDrug.second,DiagnosisDrug.third,DiagnosisDrug.forth,
							PharmacyItem.name,PharmacyItem.pack'),'conditions'=>array('diagnosis_id'=>$diagnosisRec['Diagnosis']['id'])));
		
		
		$count = count($diagnosisDrugRec);
		if($diagnosisRec){
			if($count){
				for($i=0;$i<$count;){
					$diagnosisRec['drug'][$i]  = $diagnosisDrugRec[$i]['PharmacyItem']['name'];
					$diagnosisRec['pack'][$i]  = $diagnosisDrugRec[$i]['PharmacyItem']['pack'];
					$diagnosisRec['mode'][$i]  = $diagnosisDrugRec[$i]['DiagnosisDrug']['mode'];
					$diagnosisRec['tabs_per_day'][$i]  = $diagnosisDrugRec[$i]['DiagnosisDrug']['tabs_per_day'];
					$diagnosisRec['tabs_frequency'][$i]  = $diagnosisDrugRec[$i]['DiagnosisDrug']['tabs_frequency'];
					$diagnosisRec['quantity'][$i]  = $diagnosisDrugRec[$i]['DiagnosisDrug']['quantity'];
					$diagnosisRec['first'][$i]  = $diagnosisDrugRec[$i]['DiagnosisDrug']['first'];
					$diagnosisRec['second'][$i]  = $diagnosisDrugRec[$i]['DiagnosisDrug']['second'];
					$diagnosisRec['third'][$i]  = $diagnosisDrugRec[$i]['DiagnosisDrug']['third'];
					$diagnosisRec['forth'][$i]  = $diagnosisDrugRec[$i]['DiagnosisDrug']['forth'];
					$i++;
				}
			}
			//convert date to local format
			if(!empty($diagnosisRec['Diagnosis']['next_visit'])){
				$diagnosisRec['Diagnosis']['next_visit'] = $this->DateFormat->formatDate2Local($diagnosisRec['Diagnosis']['next_visit'],Configure::read('date_format'));
			}
			if(!empty($diagnosisRec['Diagnosis']['positive_tb_date'])){
				$diagnosisRec['Diagnosis']['positive_tb_date'] = $this->DateFormat->formatDate2Local($diagnosisRec['Diagnosis']['positive_tb_date'],Configure::read('date_format'));
			}
			if(!empty($diagnosisRec['Diagnosis']['register_on'])){
				$diagnosisRec['Diagnosis']['register_on'] = $this->DateFormat->formatDate2Local($diagnosisRec['Diagnosis']['register_on'],Configure::read('date_format'),true);
			}
			if(!empty($diagnosisRec['Diagnosis']['consultant_on'])){
				$diagnosisRec['Diagnosis']['consultant_on'] = $this->DateFormat->formatDate2Local($diagnosisRec['Diagnosis']['consultant_on'],Configure::read('date_format'),true);
			}
			//-----for ccda code------
			if(!empty($diagnosisRec['PatientSmoking']['from'])){
				$diagnosisRec['PatientSmoking']['from'] = $this->DateFormat->formatDate2Local($diagnosisRec['PatientSmoking']['from'],Configure::read('date_format'),true);
			}
			if(!empty($diagnosisRec['PatientSmoking']['to'])){
				$diagnosisRec['PatientSmoking']['to'] = $this->DateFormat->formatDate2Local($diagnosisRec['PatientSmoking']['to'],Configure::read('date_format'),true);
			}
				
			//-----eof ccda code---------
				
			$this->data = $diagnosisRec ;
		}
		
		
		//BOF find vitals
		$this->BmiResult->bindModel(array(
				'hasMany' => array(
						'BmiBpResult' =>array( 'foreignKey'=>'bmi_result_id','order'=>'BmiBpResult.id ASC')
				)));
		$result1 = $this->BmiResult->find('first',array('conditions'=>array('patient_id'=>$patient_id))); //find vitals
		$this->set('result1',$result1);
		
		//commented by pankaj as of no use
		//$currentresult = $this->NewCropPrescription->find('all',array('conditions'=>array('patient_uniqueid'=>$patient_id))); //find prescription
		//$this->set('currentresult',$currentresult);
		//$this->data = $result1 ;
		//EOF find vitals
		//-----past medications-----yashwant
		//$patientIDS = $this->Patient->getAllPatientIds($personId);
		//$pastMedication = $this->NewCropPrescription->find('all',array('conditions'=>array('patient_uniqueid'=>$patientIDS,'archive'=>'Y'))); //find past medication
		//$this->set('pastMedication',$pastMedication);
		$this->set('personId',$personId);

 }
    ///****************************************Template code for INtails Assement************************************
    public function getIntials($templateName){
    	$this->uses=array('NoteTemplate');
    	$getId=$this->NoteTemplate->find('first',array('conditions'=>array('template_name LIKE'=>$templateName.'%'),'fields'=>array('id')));

    	$getCcData=$this->Diagnosis->getTemplateCC($getId['NoteTemplate']['id']);
    	$this->set('cc',$getCcData);
    	$this->set('ccID',$getId['NoteTemplate']['id']);
    	$this->render('get_cc');
    
    	$getSignificantTestsData=$this->Diagnosis->getSignificantTests($getId['NoteTemplate']['id']);
    	$this->set('significantTests',$getSignificantTestsData);
    	$this->set('significantTestsID',$getId['NoteTemplate']['id']);
    	$this->render('get_significant_tests');
 /*    	
    	debug($templateName);
    	debug($getCcData);
    	debug($getSignificantTestsData);exit; */
    	echo $this->render('get_cc')."|~|".$this->render('get_significant_tests');
    	exit;
    }
    //***************************Add Template*******************
    public function addTemplateText($contentType,$templateID,$templateText,$id=null){
    	//$this->autoRender=false;
    	   /*debug($contentType);
    	 debug($templateID);
    	debug($templateText);
    	debug($id); 
    	exit; */
    
    	$this->uses=array('NoteTemplateText');
    	if(!empty($id)){
    		$this->NoteTemplateText->updateAll(array('template_text'=>"'$templateText'"),array('id'=>$id));
    		if($contentType=='ChiefCompalint'){
    			$getCcData=$this->Diagnosis->getTemplateCC($templateID);
    			$this->set('cc',$getCcData);
    			$this->set('ccID',$templateID);
    			echo $this->render('get_cc');
    			exit;
    		}
    		if($contentType=='SignificantTests'){
    			$getSignificantTests=$this->Diagnosis->getSignificantTests($templateID);
    			$this->set('significantTests',$getSignificantTests);
    			$this->set('significantTestsID',$templateID);
    			echo $this->render('get_significant_tests');
    			exit;
    		}
    		
    	}
    	$userId=$_SESSION['Auth']['User']['id'];
    	$locationId=$_SESSION['Auth']['User']['location_id'];
    	//**************check For exists****************************************
    	
    	$checkExist=$this->NoteTemplateText->find('first',array('conditions'=>
    			array('template_text LIKE'=>$templateText.'%','context_type'=>$contentType)
    			,'fields'=>array('id')));
    	$log = $this->Diagnosis->getDataSource()->getLog(false, false);
    	if(!empty($checkExist)){
    		if($contentType=='ChiefCompalint'){
    			$getCcData=$this->Diagnosis->getTemplateCC($templateID);
    			$this->set('cc',$getCcData);
    			echo $this->render('get_cc');
    			exit;
    			
    		}
    		if($contentType=='SignificantTests'){
    			$getSignificantTestsData=$this->Diagnosis->getSignificantTests($templateID);
    			$this->set('significantTests',$getSignificantTestsData);
    			echo $this->render('get_significant_tests');
    			exit;
    		}
    		
    
    	}
    	else{
    		//**********************************************************************
    		
    		$checkSave=$this->NoteTemplateText->save(
    				array('user_id'=>$userId,'location_id'=>$locationId,'context_type'=>$contentType,'template_id'=>$templateID,'template_text'=>$templateText));
    		//debug($checkSave);
    		if($contentType=='ChiefCompalint'){
    			$getCcData=$this->Diagnosis->getTemplateCC($templateID);
    			$this->set('cc',$getCcData);
    			$this->set('ccID',$templateID);
    			echo $this->render('get_cc');
    			exit;
    		}
    		if($contentType=='SignificantTests'){
    			$getSignificantTestsData=$this->Diagnosis->getSignificantTests($templateID);
    			$this->set('significantTests',$getSignificantTestsData);
    			$this->set('significantTestsID',$templateID);
    			echo $this->render('get_significant_tests');
    			exit;
    		}
    		
    	}
    		
    }
    //*****************************************************************************************************************
    
   
    public function deleteTemplateText($id,$template_id,$type){
    	$this->autoRender=false;
    	$this->uses=array('NoteTemplateText');
    	$this->NoteTemplateText->delete(array('id'=>$id));
    	
    	if($type=='ChiefCompalint'){
    		$getCcData=$this->Diagnosis->getTemplateCC($template_id);
    			$this->set('cc',$getCcData);
    			echo $this->render('get_cc');
    			exit;
    	}
    	if($type=='SignificantTests'){
    		$getSignificantTestsData=$this->Diagnosis->getSignificantTests($template_id);
    		$this->set('significantTests',$getSignificantTestsData);
    		echo $this->render('get_significant_tests');
    		exit;
    	}
    	
    }
    public function addTempleteTitle($title){
    	$this->layout=advance;
    	$this->uses=array('NoteTemplate');
    	$data['NoteTemplate']['user_id']=$_SESSION['Auth']['User']['id'];
    	$data['NoteTemplate']['department_id']=$_SESSION['Auth']['User']['department_id'];
    	$data['NoteTemplate']['location_id']=$_SESSION['Auth']['User']['location_id'];
    	$data['NoteTemplate']['template_name']=$title;
    	$data['NoteTemplate']['template_type']='all';
    	$data['NoteTemplate']['is_deleted']='0';
    	if($this->NoteTemplate->save($data['NoteTemplate'])){
    		echo $this->Session->setFlash(__('Title Title have been saved', true, array('class'=>'message')));
    	}
    	else{
    		echo $this->Session->setFlash(__('Please Try Again' ),true,array('class'=>'error'));
    	}
    	exit;
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
    public function searchTemplateText($searchText,$type,$templateId){
    	$this->uses=array('NoteTemplateText');
    	$getSubSearch=$this->NoteTemplateText->find('all',array('conditions'=>
    			array('context_type'=>$type,'template_id'=>$templateId,'template_text LIKE'=>$searchText."%")));
    	$this->set('cc',$getSubSearch);
    	//$this->set('ccID',$templateId);
    	echo $this->render('get_cc');
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

    
function generateXML_prescription($id=null,$appointmentId=null)
	{

		$this->uses = array('Patient','Person','Location','City','State','Country','User','DoctorProfile','NewCropPrescription','NewInsurance','Appointment');

		$this->Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));

		$UIDpatient_details  = $this->Person->getUIDPatientDetailsByPatientID($id);
		
		

		//$LicensedPrescriberName=$this->DoctorProfile->getDoctorByID($UIDpatient_details['Patient']['doctor_id']);
		
		if($this->Session->read(role)=='Primary Care Provider')
		{
		   $LicensedPrescriberName=$this->User->find('first', array('conditions' => array('User.id' => $this->Session->read('userid'))));
		}
		else
		{
			//find doctor id for this appointment
			$doctorId=$this->Appointment->find('first', array('fields'=> array('Appointment.doctor_id'),'conditions' => array('Appointment.id' => $appointmentId)));
			$LicensedPrescriberName=$this->DoctorProfile->getDoctorByID($doctorId);
		}
			
		
		 
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
		
		//find insurance / health plan of patient
		$healthPlan = $this->NewInsurance->find('all', array('fields'=> array('NewInsurance.insurance_name','NewInsurance.insurance_company_id','NewInsurance.insurance_number','NewInsurance.tariff_standard_name'),'conditions'=>array('NewInsurance.patient_id' => $id,'NewInsurance.is_active' => "1")));
		
		
		$hometelephone=str_replace("-", "", $UIDpatient_details['Person']['person_lindline_no']);
		$hometelephone=str_replace("(", "", $hometelephone);
		$hometelephone=str_replace(")", "", $hometelephone);
		$hometelephone=str_replace(" ", "", $hometelephone);
		
		if(empty($facility['Facility']['address1']))
			$facility['Facility']['address1']=Configure::read('company_addr1');
		if(empty($facility['City']['name']))
			$facility['City']['name']=Configure::read('company_city');
		if(empty($facility['State']['state_code']))
			$facility['State']['state_code']=Configure::read('company_state');
		if(empty($facility['Facility']['zipcode']))
			$facility['Facility']['zipcode']=Configure::read('company_zip');
		if(empty($facility['Facility']['phone1']))
			$facility['Facility']['phone1']=Configure::read('company_primary_phone');
		if(empty($facility['Facility']['fax']))
			$facility['Facility']['fax']=Configure::read('company_primary_fax');
		 
		if(empty($LicensedPrescriberName['User']['address1']))
			$LicensedPrescriberName['User']['address1']=Configure::read('doctor_addr1');
		if(empty($city_location_prescriber['0']['City']['name']))
			$city_location_prescriber['0']['City']['name']=Configure::read('doctor_city');
		if(empty($state_location_prescriber['0']['State']['state_code']))
			$state_location_prescriber['0']['State']['state_code']=Configure::read('doctor_state');
		if(empty($LicensedPrescriberName['User']['zipcode']))
			$LicensedPrescriberName['User']['zipcode']=Configure::read('doctor_zip');
		if(empty($LicensedPrescriberName['User']['phone1']))
			$LicensedPrescriberName['User']['phone1']=Configure::read('primaryPhoneNumber');
		if(empty($LicensedPrescriberName['User']['fax']))
			$LicensedPrescriberName['User']['fax']=Configure::read('primaryFaxNumber');
	    if(empty($LicensedPrescriberName['User']['dea']))
			$LicensedPrescriberName['User']['dea']=Configure::read('prescriberDea');
		if(empty($LicensedPrescriberName['User']['npi']))
			$LicensedPrescriberName['User']['npi']=Configure::read('prescriberNpi');
				
		
		

		//find patient state code

		$state_location_patient = $this->State->find('all', array('fields'=> array('State.state_code'),'conditions'=>array('State.id'=>$UIDpatient_details['Person']['state'])));
		//find treating consultant
		if($_SESSION['role']=="Nurse"){ //for nurse
			$strxml='<?xml version="1.0" encoding="utf-8"?>';

			$strxml.='<NCScript xmlns="http://secure.newcropaccounts.com/interfaceV7" xmlns:NCStandard="http://secure.newcropaccounts.com/interfaceV7:NCStandard" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">';
			//Account Credentials
			$strxml.='<Credentials>
					<partnerName>'.Configure::read('partnername').'</partnerName>
							<nam
							e>'.Configure::read('uname').'</name>
									<password>'.Configure::read('passw').'</password>
											<productName>DrmHope Softwares</productName>
											<productVersion>V 1.1</productVersion>
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
																	<primaryPhoneNumber>'.str_replace("-", "", $LicensedPrescriberName['User']['phone1']).'</primaryPhoneNumber>
																			<primaryFaxNumber>'.str_replace("-", "", $LicensedPrescriberName['User']['fax']).'</primaryFaxNumber>
																					<pharmacyContactNumber>'.str_replace("-", "", $LicensedPrescriberName['User']['phone1']).'</pharmacyContactNumber>
																							</Location>';
			$strxml.='<Staff ID="'.$_SESSION['userid'].'">
					<StaffName>
					<last>'.$_SESSION[last_name].'</last>
							<first>'.$_SESSION[first_name].'</first>

									<prefix>'.$_SESSION[initial_name].'</prefix>

											</StaffName>
											</Staff>';

			//Prescribing doctor information
			//<license>StLic1234</license>
			/*$strxml.='<LicensedPrescriber ID="1">
			<LicensedPrescriberName>
			<last>'.$LicensedPrescriberName[DoctorProfile][last_name].'</last>
			<first>'.$LicensedPrescriberName[DoctorProfile][first_name].'</first>
			<middle>'.$LicensedPrescriberName[DoctorProfile][middle_name].'</middle>
			</LicensedPrescriberName>';*/
			// Staff



			/*$strxml.='<dea>AP9010000</dea>';
			 $strxml.='<upin></upin>';
			$strxml.='<licenseState>DC</licenseState>';
			$strxml.='<licenseNumber>12345678</licenseNumber>';
			$strxml.='<npi>1010000002</npi>';
			$strxml.='</LicensedPrescriber>';*/


			//patient information
			$strxml.='<Patient ID="'.$UIDpatient_details['Patient']['id'].'">
					<PatientName>
					<last>'.trim($UIDpatient_details['Person']['last_name']).'</last>
							<first>'.trim($UIDpatient_details['Person']['first_name']).'</first>
									<middle>'.trim($UIDpatient_details['Person']['middle_name']).'</middle>
											</PatientName>
											<medicalRecordNumber>'.$UIDpatient_details['Patient']['id'].'</medicalRecordNumber>
													<PatientAddress>
													<address1>'.$UIDpatient_details['Person']['plot_no'].'</address1>
															<address2>'.$UIDpatient_details['Person']['landmark'].'</address2>
																	<city>'.$UIDpatient_details['Person']['city'].'</city>
																			<state>'.$state_location_patient['0']['State']['state_code'].'</state>
																					<zip>'.$UIDpatient_details['Person']['pin_code'].'</zip>
																							<country>US</country>
																							</PatientAddress>
																							<PatientContact>
																							<homeTelephone>'.$hometelephone.'</homeTelephone>
																									</PatientContact>
																									<PatientCharacteristics>
																									<dob>'.$dob.'</dob>
																											<gender>'.$gendervalue.'</gender>
																													</PatientCharacteristics>';
			
			for($j=0;$j<count($healthPlan);$j++){
						if(!empty($healthPlan[$j]["NewInsurance"]["insurance_number"]))
						{
							$strxml.='<PatientHealthplans>';
					        $strxml.='<healthplanID>'.$healthPlan[$j]["NewInsurance"]["insurance_number"].'</healthplanID>
					        <healthplanTypeID>Summary</healthplanTypeID>
					        <group>Group</group>';
					        $strxml.='</PatientHealthplans>';
						}
						
				
			       }
			       
		          for($k=0;$k<count($healthPlan);$k++){
						if(empty($healthPlan[$k]["NewInsurance"]["insurance_number"]))
						{
							$strxml.='<PatientFreeformHealthplans>
							 <healthplanName>'.$healthPlan[$k]["NewInsurance"]["tariff_standard_name"].'</healthplanName>
							</PatientFreeformHealthplans>';
						}
						
					}

	  

			$strxml.= '</Patient>';

			//find current prescription

			$allMedications=$this->NewCropPrescription->find('all',array('fields'=>array('id','description','date_of_prescription','rxnorm','archive','route',
					'frequency','dose','firstdose','prn','stopdose','patient_uniqueid','drug_id','refills','prn','daw','strength','PrescriptionGuid','is_med_administered','quantity','day','DosageForm','DosageRouteTypeId','PrescriptionNotes','PharmacistNotes'),'conditions'=>array('patient_uniqueid'=>$id,'archive'=>'N')));

			for($i=0;$i<count($allMedications);$i++){
					
				//$patientPrescribedData=$this->NewCropPrescription->find('first',array('fields'=>array('id','description','drug_name','date_of_prescription','rxnorm','archive','route',
				//	'frequency','dose','firstdose','prn','stopdose','patient_uniqueid','drug_id'),'conditions'=>array('patient_uniqueid'=>$patientId,'drug_id'=>$presc_data[$i])));

					
				$externalId=date("Ymd").time().$allMedications[$i]["NewCropPrescription"]["drug_id"].$i.$id.$allMedications[$i]["NewCropPrescription"]["id"];
				$datepresc=str_replace("T"," ",$allMedications[$i]["NewCropPrescription"]["date_of_prescription"]);
				$dateprescFinal=explode(" ",$datepresc);
				$doctorFullName=$LicensedPrescriberName[DoctorProfile][first_name]." ".$LicensedPrescriberName[DoctorProfile][last_name];
				//$sig=$allMedications[$i]["NewCropPrescription"]["drug_name"]." ".$allMedications[$i]["NewCropPrescription"]["frequency"]." ".$allMedications[$i]["NewCropPrescription"]["route"];
				$sig=$allMedications[$i]["NewCropPrescription"]["PrescriptionNotes"];

				if($allMedications[$i]["NewCropPrescription"]["prn"]=='1')
					$prn="Yes";
				else
					$prn="No";

				if($allMedications[$i]["NewCropPrescription"]["daw"]=='1')
					$daw="DispenseAsWritten";
				else
					$daw="SubstitutionAllowed";
				
				
				
				if(empty($allMedications[$i]["NewCropPrescription"]["dose"]))
					$allMedications[$i]["NewCropPrescription"]["dose"]=0;
				
				if(empty($allMedications[$i]["NewCropPrescription"]["DosageForm"]))
					$allMedications[$i]["NewCropPrescription"]["DosageForm"]=0;
				
				if(empty($allMedications[$i]["NewCropPrescription"]["DosageRouteTypeId"]))
					$allMedications[$i]["NewCropPrescription"]["DosageRouteTypeId"]=0;
				
				if(empty($allMedications[$i]["NewCropPrescription"]["frequency"]))
					$allMedications[$i]["NewCropPrescription"]["frequency"]=0;

				$prescriptionGuid=$allMedications[$i]["NewCropPrescription"]["PrescriptionGuid"];
				if(!empty($prescriptionGuid))
				  $strxml.='<OutsidePrescription ID="'.$allMedications[$i]["NewCropPrescription"]["PrescriptionGuid"].'">';
				else
					$strxml.='<OutsidePrescription>';
				
				$strxml.='<externalId>'.$externalId.'</externalId><date>'.str_replace("-","",$dateprescFinal[0]).'</date><doctorName>'.$doctorFullName.'</doctorName><drug>'.$allMedications[$i]["NewCropPrescription"]["drug_name"].'</drug>';
				
				
						$strxml.='<dispenseNumber>'.$allMedications[$i]["NewCropPrescription"]["quantity"].'</dispenseNumber>';
						
						$strxml.='<sig>'.$sig.'</sig><refillCount>'.$allMedications[$i]["NewCropPrescription"]["refills"].'</refillCount><substitution>'.$daw.'</substitution><pharmacistMessage>'.$allMedications[$i]["NewCropPrescription"]["PharmacistNotes"].'</pharmacistMessage><drugIdentifier>'.$allMedications[$i]["NewCropPrescription"]["drug_id"].'</drugIdentifier><drugIdentifierType>FDB</drugIdentifierType><prescriptionType>reconcile</prescriptionType>
						<codifiedSigType>
     <ActionType>0</ActionType>
      <NumberType>'.$allMedications[$i]["NewCropPrescription"]["dose"].'</NumberType>
      <FormType>'.$allMedications[$i]["NewCropPrescription"]["DosageForm"].'</FormType>
      <RouteType>'.$allMedications[$i]["NewCropPrescription"]["DosageRouteTypeId"].'</RouteType>
      <FrequencyType>'.$allMedications[$i]["NewCropPrescription"]["frequency"].'</FrequencyType>
    </codifiedSigType><prn>'.$prn.'</prn>';
						
		if(!empty($allMedications[$i]["NewCropPrescription"]["day"]))
    		$strxml.='<daysSupply>'.$allMedications[$i]["NewCropPrescription"]["day"].'</daysSupply>';
						
	$strxml.='</OutsidePrescription>';
									
			}

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
							<address1>'.$LicensedPrescriberName[User][address1].'</address1>
									<address2>'.$LicensedPrescriberName[User][address2].'</address2>
											<city>'.$city_location_prescriber['0']['City']['name'].'</city>
													<state>'.$state_location_prescriber[0][State][state_code].'</state>
															<zip>'.$LicensedPrescriberName[User][zipcode].'</zip>
																	<country>US</country>
																	</LocationAddress>
																	<primaryPhoneNumber>'.str_replace("-", "", $LicensedPrescriberName['User']['phone1']).'</primaryPhoneNumber>
																			<primaryFaxNumber>'.str_replace("-", "", $LicensedPrescriberName['User']['fax']).'</primaryFaxNumber>
																					<pharmacyContactNumber>'.str_replace("-", "", $LicensedPrescriberName['User']['phone1']).'</pharmacyContactNumber>
																							</Location>';

			//Prescribing doctor information
			$strxml.='<LicensedPrescriber ID="'.$LicensedPrescriberName[User][id].'">
					<LicensedPrescriberName>
					<last>'.$LicensedPrescriberName[User][last_name].'</last>
							<first>'.$LicensedPrescriberName[User][first_name].'</first>
									<middle>'.$LicensedPrescriberName[User][middle_name].'</middle>
											</LicensedPrescriberName>';
			// Staff



			$strxml.='<dea>'.$LicensedPrescriberName[User][dea].'</dea>';
			$strxml.='<upin></upin>';
			$strxml.='<licenseState>'.$state_location_prescriber[0][State][state_code].'</licenseState>';
			//$strxml.='<licenseNumber>'.$LicensedPrescriberName[User][licensure_no].'</licenseNumber>';
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
													<PatientAddress>
													<address1>'.$UIDpatient_details['Person']['plot_no'].'</address1>
															<address2>'.$UIDpatient_details['Person']['landmark'].'</address2>
																	<city>'.$UIDpatient_details['Person']['city'].'</city>
																			<state>'.$state_location_patient['0']['State']['state_code'].'</state>
																					<zip>'.$UIDpatient_details['Person']['pin_code'].'</zip>
																							<country>US</country>
																							</PatientAddress>
																							<PatientContact>
																							<homeTelephone>'.$UIDpatient_details['Person']['person_lindline_no'].'</homeTelephone>
																									</PatientContact>
																									<PatientCharacteristics>
																									<dob>'.$dob.'</dob>
																											<gender>'.$gendervalue.'</gender>
																													</PatientCharacteristics>';
			
					
					for($j=0;$j<count($healthPlan);$j++){
						if(!empty($healthPlan[$j]["NewInsurance"]["insurance_number"]))
						{
							$strxml.='<PatientHealthplans>';
					        $strxml.='<healthplanID>'.$healthPlan[$j]["NewInsurance"]["insurance_number"].'</healthplanID>
					        <healthplanTypeID>Summary</healthplanTypeID>
					        <group>Group</group>';
					        $strxml.='</PatientHealthplans>';
						}
						
				
			       }
			       
		          for($k=0;$k<count($healthPlan);$k++){
						if(empty($healthPlan[$k]["NewInsurance"]["insurance_number"]))
						{
							$strxml.='<PatientFreeformHealthplans>
							 <healthplanName>'.$healthPlan[$k]["NewInsurance"]["tariff_standard_name"].'</healthplanName>
							</PatientFreeformHealthplans>';
						}
						
					}
			       
			      
			
			$strxml.= '</Patient>';

			//find current prescription

			$allMedications=$this->NewCropPrescription->find('all',array('fields'=>array('id','description','date_of_prescription','rxnorm','archive','route',
					'frequency','dose','firstdose','prn','stopdose','patient_uniqueid','drug_id','refills','prn','daw','strength','PrescriptionGuid','quantity','day','DosageForm','DosageRouteTypeId','PrescriptionNotes','PharmacistNotes'),'conditions'=>array('patient_uniqueid'=>$id,'archive'=>'N')));
            
			for($i=0;$i<count($allMedications);$i++){
					
				//$patientPrescribedData=$this->NewCropPrescription->find('first',array('fields'=>array('id','description','drug_name','date_of_prescription','rxnorm','archive','route',
				//	'frequency','dose','firstdose','prn','stopdose','patient_uniqueid','drug_id'),'conditions'=>array('patient_uniqueid'=>$patientId,'drug_id'=>$presc_data[$i])));

					
				$externalId=date("Ymd").time().$allMedications[$i]["NewCropPrescription"]["drug_id"].$i.$id.$allMedications[$i]["NewCropPrescription"]["id"];
				$datepresc=str_replace("T"," ",$allMedications[$i]["NewCropPrescription"]["date_of_prescription"]);
				$dateprescFinal=explode(" ",$datepresc);
				$doctorFullName=$LicensedPrescriberName[User][first_name]." ".$LicensedPrescriberName[User][last_name];
				//$sig=$allMedications[$i]["NewCropPrescription"]["drug_name"]." ".$allMedications[$i]["NewCropPrescription"]["frequency"]." ".$allMedications[$i]["NewCropPrescription"]["route"];
				$sig=$allMedications[$i]["NewCropPrescription"]["PrescriptionNotes"];
				
				
				
				if($allMedications[$i]["NewCropPrescription"]["prn"]=='1')
					$prn="Yes";
				else
					$prn="No";

				if($allMedications[$i]["NewCropPrescription"]["daw"]=='1')
					$daw="DispenseAsWritten";
				else
					$daw="SubstitutionAllowed";
				
				if(empty($allMedications[$i]["NewCropPrescription"]["dose"]))
					$allMedications[$i]["NewCropPrescription"]["dose"]=0;
				
				if(empty($allMedications[$i]["NewCropPrescription"]["DosageForm"]))
					$allMedications[$i]["NewCropPrescription"]["DosageForm"]=0;
				
				if(empty($allMedications[$i]["NewCropPrescription"]["DosageRouteTypeId"]))
					$allMedications[$i]["NewCropPrescription"]["DosageRouteTypeId"]=0;
				
				if(empty($allMedications[$i]["NewCropPrescription"]["frequency"]))
					$allMedications[$i]["NewCropPrescription"]["frequency"]=0;

				$prescriptionGuid=$allMedications[$i]["NewCropPrescription"]["PrescriptionGuid"];
				if(!empty($prescriptionGuid))
				  $strxml.='<OutsidePrescription ID="'.$allMedications[$i]["NewCropPrescription"]["PrescriptionGuid"].'">';
				else
					$strxml.='<OutsidePrescription>';
				
				$strxml.='<externalId>'.$externalId.'</externalId><date>'.str_replace("-","",$dateprescFinal[0]).'</date><doctorName>'.$doctorFullName.'</doctorName><drug>'.$allMedications[$i]["NewCropPrescription"]["drug_name"].'</drug>';
				
				
						$strxml.='<dispenseNumber>'.$allMedications[$i]["NewCropPrescription"]["quantity"].'</dispenseNumber>';
						
						$strxml.='<sig>'.$sig.'</sig><refillCount>'.$allMedications[$i]["NewCropPrescription"]["refills"].'</refillCount><substitution>'.$daw.'</substitution><pharmacistMessage>'.$allMedications[$i]["NewCropPrescription"]["PharmacistNotes"].'</pharmacistMessage><drugIdentifier>'.$allMedications[$i]["NewCropPrescription"]["drug_id"].'</drugIdentifier><drugIdentifierType>FDB</drugIdentifierType><prescriptionType>reconcile</prescriptionType>
						<codifiedSigType>
     <ActionType>0</ActionType>
      <NumberType>'.$allMedications[$i]["NewCropPrescription"]["dose"].'</NumberType>
      <FormType>'.$allMedications[$i]["NewCropPrescription"]["DosageForm"].'</FormType>
      <RouteType>'.$allMedications[$i]["NewCropPrescription"]["DosageRouteTypeId"].'</RouteType>
      <FrequencyType>'.$allMedications[$i]["NewCropPrescription"]["frequency"].'</FrequencyType>
    </codifiedSigType><prn>'.$prn.'</prn>';
						
		if(!empty($allMedications[$i]["NewCropPrescription"]["day"]))
    		$strxml.='<daysSupply>'.$allMedications[$i]["NewCropPrescription"]["day"].'</daysSupply>';
						
	$strxml.='</OutsidePrescription>';
				
			}
			
			$strxml.='</NCScript>';

			//create xml file here
			$ourFileName = "uploads/patient_xml/".$UIDpatient_details['Person']['first_name']."_".$UIDpatient_details['Person']['last_name']."_".$UIDpatient_details['Patient']['id'].".xml";
			//	$ourFileHandle = fopen($ourFileName, 'w') or die("can't open file");
			$ourFileHandle = fopen($ourFileName, 'w')  ;
			fwrite($ourFileHandle, $strxml);
			fclose($ourFileHandle);
			return $strxml;
		}

		else{ //for midlevel subscriber


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
					<user>MidlevelPrescriber</user>
					<role>midlevelPrescriber</role>
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
							<address1>'.$LicensedPrescriberName[User][address1].'</address1>
									<address2>'.$LicensedPrescriberName[User][address2].'</address2>
											<city>'.$city_location_prescriber['0']['City']['name'].'</city>
													<state>'.$state_location_prescriber[0][State][state_code].'</state>
															<zip>'.$LicensedPrescriberName[User][zipcode].'</zip>
																	<country>US</country>
																	</LocationAddress>
																	<primaryPhoneNumber>'.str_replace("-", "", $LicensedPrescriberName['User']['phone1']).'</primaryPhoneNumber>
																			<primaryFaxNumber>'.str_replace("-", "", $LicensedPrescriberName['User']['fax']).'</primaryFaxNumber>
																					<pharmacyContactNumber>'.str_replace("-", "", $LicensedPrescriberName['User']['phone1']).'</pharmacyContactNumber>
																							</Location>';

			//Prescribing doctor information
			$strxml.='<MidlevelPrescriber ID="'.$_SESSION['userid'].'">
					<LicensedPrescriberName>
					<last>'.$_SESSION[last_name].'</last>
							<first>'.$_SESSION[first_name].'</first>

									</LicensedPrescriberName>';
			// Staff



			$strxml.='<dea>'.$LicensedPrescriberName[User][dea].'</dea>';
			$strxml.='<upin></upin>';
			$strxml.='<licenseState>'.$state_location_prescriber[0][State][state_code].'</licenseState>';
			$strxml.='<licenseNumber>'.$LicensedPrescriberName[User][licensure_no].'</licenseNumber>';
			$strxml.='<npi>'.$LicensedPrescriberName[User][npi].'</npi>';
			$strxml.='</LicensedPrescriber>';
			//$strxml.='</LicensedPrescriber>';
			$strxml.='</MidlevelPrescriber>';


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
													<PatientAddress>
													<address1>'.$UIDpatient_details['Person']['plot_no'].'</address1>
															<address2>'.$UIDpatient_details['Person']['landmark'].'</address2>
																	<city>'.$UIDpatient_details['Person']['city'].'</city>
																			<state>'.$state_location_patient['0']['State']['state_code'].'</state>
																					<zip>'.$UIDpatient_details['Person']['pin_code'].'</zip>
																							<country>US</country>
																							</PatientAddress>
																							<PatientContact>
																							<homeTelephone>'.$UIDpatient_details['Person']['person_lindline_no'].'</homeTelephone>
																									</PatientContact>
																									<PatientCharacteristics>
																									<dob>'.$dob.'</dob>
																											<gender>'.$gendervalue.'</gender>
																													</PatientCharacteristics>';

			for($j=0;$j<count($healthPlan);$j++){
						if(!empty($healthPlan[$j]["NewInsurance"]["insurance_number"]))
						{
							$strxml.='<PatientHealthplans>';
					        $strxml.='<healthplanID>'.$healthPlan[$j]["NewInsurance"]["insurance_number"].'</healthplanID>
					        <healthplanTypeID>Summary</healthplanTypeID>
					        <group>Group</group>';
					        $strxml.='</PatientHealthplans>';
						}
						
				
			       }
			       
		          for($k=0;$k<count($healthPlan);$k++){
						if(empty($healthPlan[$k]["NewInsurance"]["insurance_number"]))
						{
							$strxml.='<PatientFreeformHealthplans>
							 <healthplanName>'.$healthPlan[$k]["NewInsurance"]["tariff_standard_name"].'</healthplanName>
							</PatientFreeformHealthplans>';
						}
						
					}
	  
	 
			




			$strxml.= '</Patient>';

			//find current prescription

			$allMedications=$this->NewCropPrescription->find('all',array('fields'=>array('id','description','date_of_prescription','rxnorm','archive','route',
					'frequency','dose','firstdose','prn','stopdose','patient_uniqueid','drug_id','refills','prn','daw','strength','PrescriptionGuid','quantity','day','DosageForm','DosageRouteTypeId','PrescriptionNotes','PharmacistNotes'),'conditions'=>array('patient_uniqueid'=>$id,'archive'=>'N')));

			for($i=0;$i<count($allMedications);$i++){
					
				//$patientPrescribedData=$this->NewCropPrescription->find('first',array('fields'=>array('id','description','drug_name','date_of_prescription','rxnorm','archive','route',
				//	'frequency','dose','firstdose','prn','stopdose','patient_uniqueid','drug_id'),'conditions'=>array('patient_uniqueid'=>$patientId,'drug_id'=>$presc_data[$i])));

					
				$externalId=date("Ymd").time().$allMedications[$i]["NewCropPrescription"]["drug_id"].$i.$id.$allMedications[$i]["NewCropPrescription"]["id"];
				$datepresc=str_replace("T"," ",$allMedications[$i]["NewCropPrescription"]["date_of_prescription"]);
				$dateprescFinal=explode(" ",$datepresc);
				$doctorFullName=$LicensedPrescriberName[DoctorProfile][first_name]." ".$LicensedPrescriberName[DoctorProfile][last_name];
				//$sig=$allMedications[$i]["NewCropPrescription"]["drug_name"]." ".$allMedications[$i]["NewCropPrescription"]["frequency"]." ".$allMedications[$i]["NewCropPrescription"]["route"];
				$sig=$allMedications[$i]["NewCropPrescription"]["PrescriptionNotes"];
				
				if($allMedications[$i]["NewCropPrescription"]["prn"]=='1')
					$prn="Yes";
				else
					$prn="No";

				if($allMedications[$i]["NewCropPrescription"]["daw"]=='1')
					$daw="DispenseAsWritten";
				else
					$daw="SubstitutionAllowed";
				
				
				if(empty($allMedications[$i]["NewCropPrescription"]["dose"]))
					$allMedications[$i]["NewCropPrescription"]["dose"]=0;
				
				if(empty($allMedications[$i]["NewCropPrescription"]["DosageForm"]))
					$allMedications[$i]["NewCropPrescription"]["DosageForm"]=0;
				
				if(empty($allMedications[$i]["NewCropPrescription"]["DosageRouteTypeId"]))
					$allMedications[$i]["NewCropPrescription"]["DosageRouteTypeId"]=0;
				
				if(empty($allMedications[$i]["NewCropPrescription"]["frequency"]))
					$allMedications[$i]["NewCropPrescription"]["frequency"]=0;

				$prescriptionGuid=$allMedications[$i]["NewCropPrescription"]["PrescriptionGuid"];
				if(!empty($prescriptionGuid))
				  $strxml.='<OutsidePrescription ID="'.$allMedications[$i]["NewCropPrescription"]["PrescriptionGuid"].'">';
				else
					$strxml.='<OutsidePrescription>';
				
				$strxml.='<externalId>'.$externalId.'</externalId><date>'.str_replace("-","",$dateprescFinal[0]).'</date><doctorName>'.$doctorFullName.'</doctorName><drug>'.$allMedications[$i]["NewCropPrescription"]["drug_name"].'</drug>';
				
				
						$strxml.='<dispenseNumber>'.$allMedications[$i]["NewCropPrescription"]["quantity"].'</dispenseNumber>';
						
						$strxml.='<sig>'.$sig.'</sig><refillCount>'.$allMedications[$i]["NewCropPrescription"]["refills"].'</refillCount><substitution>'.$daw.'</substitution><pharmacistMessage>'.$allMedications[$i]["NewCropPrescription"]["PharmacistNotes"].'</pharmacistMessage><drugIdentifier>'.$allMedications[$i]["NewCropPrescription"]["drug_id"].'</drugIdentifier><drugIdentifierType>FDB</drugIdentifierType><prescriptionType>reconcile</prescriptionType>
						<codifiedSigType>
     <ActionType>0</ActionType>
      <NumberType>'.$allMedications[$i]["NewCropPrescription"]["dose"].'</NumberType>
      <FormType>'.$allMedications[$i]["NewCropPrescription"]["DosageForm"].'</FormType>
      <RouteType>'.$allMedications[$i]["NewCropPrescription"]["DosageRouteTypeId"].'</RouteType>
      <FrequencyType>'.$allMedications[$i]["NewCropPrescription"]["frequency"].'</FrequencyType>
    </codifiedSigType><prn>'.$prn.'</prn>';
						
		if(!empty($allMedications[$i]["NewCropPrescription"]["day"]))
    		$strxml.='<daysSupply>'.$allMedications[$i]["NewCropPrescription"]["day"].'</daysSupply>';
						
	$strxml.='</OutsidePrescription>';
					
			}


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

    public function getSignificantHistory($patientId,$personId){
    	$this->layout='ajax';
    	
    	
    	$this->uses = array('Patient','PastMedicalHistory','ProcedureHistory','NewCropPrescription','PatientSmoking','FamilyHistory','PastMedicalRecord');
    	$patientIDS = $this->Patient->getAllPatientIds($personId);
    	
    	$this->Patient->unBindModel(array(
    			'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
    	$this->Patient->bindModel(array(
    			'belongsTo' => array(
    					'Person' =>array('foreignKey' => false,'conditions'=>array('Person.id=Patient.person_id')),
    			)));
    	$getSex=$this->Patient->find('first',
    			array('fields'=>array('Person.sex'),'conditions'=>array('Patient.id'=>$patientId)));
    	$this->set('getSex',$getSex);
    	
    	
    	$pastMedicalHistoryRec = $this->PastMedicalHistory->find('all',array('fields'=>array('id'), 'conditions'=>array('patient_id'=>$patientIDS)));
    	$this->set('pastHistory',$pastMedicalHistoryRec);
    	$procedureHistoryRec = $this->ProcedureHistory->find('first',array('fields'=>array('id'),'conditions'=>array('ProcedureHistory.patient_id'=>$patientId)));
    	$this->set('procedureHistory',$procedureHistoryRec);
    	
    	$getMedicationRecords=$this->NewCropPrescription->find('first',array('fields'=>array('id'),'conditions'=>array('patient_uniqueid'=>$patientId,'archive'=>'Y')));
    	$this->set('getMedicationRecords',$getMedicationRecords);
    	
    	$getPatientSmoking=$this->PatientSmoking->find('first',array('fields'=>array('id'),'conditions'=>array('patient_id'=>$patientId)));
    	$this->set('getPatientSmoking',$getPatientSmoking);
    	
    	$getpatientfamilyhistory=$this->FamilyHistory->find('first',array('fields'=>array('id'),'conditions'=>array('patient_id'=>$patientId)));
    	$this->set('getpatientfamilyhistory',$getpatientfamilyhistory);
    	
    	$getPastMedicalRecord=$this->PastMedicalRecord->find('first',array('fields'=>array('id'),'conditions'=>array('patient_id'=>$patientId)));
    	$this->set('getPastMedicalRecord',$getPastMedicalRecord);
    	
    	$getGynecologyHistory=$this->PastMedicalRecord->find('first',array('fields'=>array('id','present_symptom','past_infection','hx_abnormal_pap',
    			'hx_abnormal_pap_yes','last_mammography','last_mammography_yes','hx_cervical_bx','hx_fertility_drug','hx_hrt_use','hx_irregular_menses','lmp','symptom_lmp'),
    			'conditions'=>array('patient_id'=>$patientId)));
    	$this->set('getGynecologyHistory',$getGynecologyHistory);
    	
    	$getSexualActivity=$this->PastMedicalRecord->find('first',array('fields'=>array('id','sexually_active','birth_controll','breast_self_exam','new_partner',
    			'partner_notification','hiv_education','pap_education','gyn_referral'),
    			'conditions'=>array('patient_id'=>$patientId)));
    	$this->set('getSexualActivity',$getSexualActivity);
    	$this->set('patientId',$patientId);
    	$this->set('personId',$personId);
    	echo $this->render('get_significant_history');
    	exit;
    }
    
    public function powerNote($patientId){
    	$this->set('patientId',$patientId);
    	$this->patient_info($patientId);
    	$this->uses = array('Diagnosis','TemplateTypeContent','NewCropPrescription','OtherTreatment','Immunization','BmiResult','BmiBpResult',
    			'Template','TemplateTypeContent','NewCropAllergies','PastMedicalRecord','FamilyHistory','SmokingStatusOncs','Note','PastMedicalHistory',
    			'PregnancyCount','ProcedureHistory','DiagnosisDrug','Patients');
    	$ccDiagnoses = $this->Diagnosis->find('first',array('fields'=>array('complaints','lab_report'),'conditions'=>array('Diagnosis.patient_id'=>$patientId)));
    	$this->set('ccDiagnoses',$ccDiagnoses);
    	//***Medication
    	$getMedicationRecords=$this->NewCropPrescription->find('all',array('conditions'=>array('patient_uniqueid'=>$patientId,'archive'=>'N')));
    	$this->set('getMedicationRecords',$getMedicationRecords);
    	$getMedicationHistory=$this->NewCropPrescription->find('all',array('conditions'=>array('patient_uniqueid'=>$patientId,'archive'=>'Y')));
    	$this->set('getMedicationHistory',$getMedicationHistory);
    	//***EOF Medication
    	//***OtherTreatment
    	$getTreatmentRecords=$this->OtherTreatment->find('first',array('conditions'=>array('patient_id'=>$patientId)));
    	$this->set('getTreatmentRecords',$getTreatmentRecords);
    	//***EOF OtherTreatment
    	//***Immunization
    	$this->Immunization->bindModel(array(
    			'belongsTo' => array(
    					'Imunization' =>array('foreignKey' => false,'conditions'=>array('Imunization.id = Immunization.vaccine_type' )),
    			)),false);
    	$immunizationData = $this->Immunization->find('all',array('fields'=>array('id','patient_id','Imunization.cpt_description','date'),
    			'conditions'=>array('patient_id'=>$patientId,'Immunization.is_deleted'=>0)));
    	$this->set('immunizationData',$immunizationData);
    	//***EOF Immunization
    	//******vitals
    	$this->BmiResult->bindModel(array(
    			'hasMany' => array(
    					'BmiBpResult' =>array( 'foreignKey'=>'bmi_result_id','order'=>'BmiBpResult.id ASC')
    			)));
    	$get_vital = $this->BmiResult->find('first',array('conditions'=>array('patient_id'=>$patientId)));
    	$this->set('get_vital',$get_vital);
    	//******EOF vitals
    	//***Allergy
    	$allergies_data=$this->NewCropAllergies->find('all',array('conditions'=>array('NewCropAllergies.patient_uniqueid'=>$patientId,'NewCropAllergies.is_reconcile'=>0,'NewCropAllergies.location_id'=>$this->Session->read('locationid'))
    			,'order' => array('NewCropAllergies.patient_id DESC')));
    	$this->set('allergies_data',$allergies_data);
    	//***Eof Allergys
    	$roseData=$this->Template->find('all',array('conditions'=>array('Template.is_deleted=0')));
		$reviewData = $this->TemplateTypeContent->find('list',array('fields'=>array('template_id','template_subcategory_id'),'conditions'=>array('patient_id'=>$patientId))) ;
		$this->set('rosData',$roseData); // category
		$this->set('templateTypeContent',$reviewData); //user selected serialized data
    	 
		
		$getpatient=$this->PastMedicalRecord->find('all',array('conditions'=>array('patient_id'=>$patientId)));
		$getpatientfamilyhistory=$this->FamilyHistory->find('first',array('conditions'=>array('patient_id'=>$patientId)));
		$smokingOptions =$this->SmokingStatusOncs->find('list',array('fields'=>array('description')));
		 
		$this->set(compact('smokingOptions'));
		$this->set('getpatient',$getpatient);
		$this->set('getpatientfamilyhistory',$getpatientfamilyhistory);
		
		$getEthnicityData=$this->patient_details['Person']['ethnicity'];
		$getmaritailStatusData=$this->patient_details['Person']['maritail_status'];
		$this->set(compact('getEthnicityData','getmaritailStatusData'));
		
		//check if patient record is exist
		$this->Diagnosis->bindModel( array(
				'belongsTo' => array(
						/*'PatientAllergy'=>array('conditions'=>array('Diagnosis.id=PatientAllergy.diagnosis_id'),'foreignKey'=>false),*/
						'PatientPersonalHistory'=>array('conditions'=>array('Diagnosis.id=PatientPersonalHistory.diagnosis_id'),'foreignKey'=>false,'order'=>array('PatientSmoking.id DESC'),'limit'=>1),
						'PatientSmoking'=>array('conditions'=>array('Diagnosis.id=PatientSmoking.diagnosis_id'),'foreignKey'=>false),
						'PatientPastHistory'=>array('conditions'=>array('Diagnosis.id=PatientPastHistory.diagnosis_id'),'foreignKey'=>false),
						'FamilyHistory'=>array('conditions'=>array('Diagnosis.patient_id=FamilyHistory.patient_id'),'foreignKey'=>false),
						/*'PatientFamilyHistory'=>array('conditions'=>array('Diagnosis.id=PatientFamilyHistory.diagnosis_id'),'foreignKey'=>false),
						 'SmokingStatusOncs'=>array('className'=>'SmokingStatusOncs','conditions'=>array('PatientSmoking.smoking_fre=SmokingStatusOncs.id'),'foreignKey'=>false),
		'SmokingStatusOncs1'=>array('className'=>'SmokingStatusOncs','conditions'=>array('PatientSmoking.current_smoking_fre=SmokingStatusOncs1.id'),'foreignKey'=>false)*/
				)
		));
		 
		$diagnosisRec = $this->Diagnosis->find('first',array('conditions'=>array('Diagnosis.patient_id'=>$patientId)));
		 
		//Encouter Data
		$this->Patient->unbindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$personId=$this->Patient->find('first',array('fields'=>array('Patient.person_id'),'conditions'=>array('Patient.id'=>$patientId)));
		$getEncounterId=$this->Note->encounterHandler($patientId,$personId['Patient']['person_id']);
		if(count($getEncounterId)=='1'){
			$getEncounterId=$getEncounterId['0'];
		}
		//EOF
		//past medical history
		$pastMedicalHistoryRec = $this->PastMedicalHistory->find('all',array('fields'=>array('PastMedicalHistory.*'), 'conditions'=>array('patient_id'=>$getEncounterId),'order'=>array('PastMedicalHistory.id Asc')));
		 
		$this->set('pastHistory',$pastMedicalHistoryRec);
		if($this->patient_details['Person']['sex']){
			$pregnancyCountRec = $this->PregnancyCount->find('all',array('fields'=>array('PregnancyCount.counts,PregnancyCount.date_birth,PregnancyCount.weight,PregnancyCount.baby_gender,
								PregnancyCount.week_pregnant,PregnancyCount.type_delivery,PregnancyCount.complication'), 'conditions'=>array('patient_id'=>$patientId),'order'=>array('PregnancyCount.id Asc')));
			$this->set('pregnancyData',$pregnancyCountRec);
			 
			unset($this->request->data); //added by pankaj M since request->data was always coming when intial assesment page is refreshed after clicking on submit button
		}
		
		///////////////BOF --------OtherTreatment-Mahalaxmi
		$getOtherTreatment=$this->OtherTreatment->find('all',array('conditions'=>array('patient_id'=>$patientId)));
		$this->set(compact('getOtherTreatment'));
		///////////////EOF --------OtherTreatment-Mahalaxmi
		
		//BOF --------ProcedureHistory
		$this->ProcedureHistory->bindModel( array(
				'belongsTo' => array(
						'DoctorProfile'=>array('foreignKey'=>false,'conditions'=>array('ProcedureHistory.provider=DoctorProfile.id')),
						'TariffList'=>array('foreignKey'=>false,'conditions'=>array('ProcedureHistory.procedure=TariffList.id')),
				)));
		
		$procedureHistoryRec = $this->ProcedureHistory->find('all',array('fields'=>array('TariffList.id','TariffList.name','DoctorProfile.id',
				'DoctorProfile.doctor_name','ProcedureHistory.procedure','ProcedureHistory.provider','ProcedureHistory.age_value','ProcedureHistory.age_unit',
				'ProcedureHistory.procedure_date','ProcedureHistory.comment','ProcedureHistory.procedure_name','ProcedureHistory.provider_name'),
				'conditions'=>array('ProcedureHistory.patient_id'=>$patientId),'order'=>array('ProcedureHistory.id Asc')));
		$this->set('procedureHistory',$procedureHistoryRec);
		//EOF ProcedureHistory
		
		$diagnosisDrugRec = $this->DiagnosisDrug->find('all',array('fields'=>array('DiagnosisDrug.mode,DiagnosisDrug.tabs_per_day,DiagnosisDrug.mode,DiagnosisDrug.quantity,
				DiagnosisDrug.tabs_frequency,DiagnosisDrug.first,DiagnosisDrug.second,DiagnosisDrug.third,DiagnosisDrug.forth,
				PharmacyItem.name,PharmacyItem.pack'),'conditions'=>array('diagnosis_id'=>$diagnosisRec['Diagnosis']['id'])));
		
		 
		$count = count($diagnosisDrugRec);
		if($diagnosisRec){
			if($count){
				for($i=0;$i<$count;){
					$diagnosisRec['drug'][$i]  = $diagnosisDrugRec[$i]['PharmacyItem']['name'];
					$diagnosisRec['pack'][$i]  = $diagnosisDrugRec[$i]['PharmacyItem']['pack'];
					$diagnosisRec['mode'][$i]  = $diagnosisDrugRec[$i]['DiagnosisDrug']['mode'];
					$diagnosisRec['tabs_per_day'][$i]  = $diagnosisDrugRec[$i]['DiagnosisDrug']['tabs_per_day'];
					$diagnosisRec['tabs_frequency'][$i]  = $diagnosisDrugRec[$i]['DiagnosisDrug']['tabs_frequency'];
					$diagnosisRec['quantity'][$i]  = $diagnosisDrugRec[$i]['DiagnosisDrug']['quantity'];
					$diagnosisRec['first'][$i]  = $diagnosisDrugRec[$i]['DiagnosisDrug']['first'];
					$diagnosisRec['second'][$i]  = $diagnosisDrugRec[$i]['DiagnosisDrug']['second'];
					$diagnosisRec['third'][$i]  = $diagnosisDrugRec[$i]['DiagnosisDrug']['third'];
					$diagnosisRec['forth'][$i]  = $diagnosisDrugRec[$i]['DiagnosisDrug']['forth'];
					$i++;
				}
			}
			//convert date to local format
			if(!empty($diagnosisRec['Diagnosis']['next_visit'])){
				$diagnosisRec['Diagnosis']['next_visit'] = $this->DateFormat->formatDate2Local($diagnosisRec['Diagnosis']['next_visit'],Configure::read('date_format'));
			}
			if(!empty($diagnosisRec['Diagnosis']['positive_tb_date'])){
				$diagnosisRec['Diagnosis']['positive_tb_date'] = $this->DateFormat->formatDate2Local($diagnosisRec['Diagnosis']['positive_tb_date'],Configure::read('date_format'));
			}
			if(!empty($diagnosisRec['Diagnosis']['register_on'])){
				$diagnosisRec['Diagnosis']['register_on'] = $this->DateFormat->formatDate2Local($diagnosisRec['Diagnosis']['register_on'],Configure::read('date_format'),true);
			}
			if(!empty($diagnosisRec['Diagnosis']['consultant_on'])){
				$diagnosisRec['Diagnosis']['consultant_on'] = $this->DateFormat->formatDate2Local($diagnosisRec['Diagnosis']['consultant_on'],Configure::read('date_format'),true);
			}
			//-----for ccda code------
			if(!empty($diagnosisRec['PatientSmoking']['from'])){
				$diagnosisRec['PatientSmoking']['from'] = $this->DateFormat->formatDate2Local($diagnosisRec['PatientSmoking']['from'],Configure::read('date_format'),true);
			}
			if(!empty($diagnosisRec['PatientSmoking']['to'])){
				$diagnosisRec['PatientSmoking']['to'] = $this->DateFormat->formatDate2Local($diagnosisRec['PatientSmoking']['to'],Configure::read('date_format'),true);
			}
			 
			//-----eof ccda code---------
			 
			$this->data = $diagnosisRec ;
		}
		
    }
    // Allergys 
    public function allallergies($patient_id=null,$id=null,$action=null,$personId=null,$flag=null){
    	$this->uses = array('Language','NewCropAllergies','Patient','Note','icds','DrugAllergy','Diagnosis','AllergyMaster');
    	if(!empty($this->params->query['ajaxFlag'])){
			$this->layout ="ajax" ;
    		$ajaxHold=$this->params->query['ajaxFlag'];
    		echo 	$this->render('allallergies');
    		$this->set('ajaxHold',$ajaxHold);
    		exit;
    	}else{
				$this->layout ="advance_ajax" ;
		}
    	// for no active medication...
		if($this->params->query[controllerFlag]=='Diagnoses'){
    		$allergyCheck=$this->Diagnosis->find('first',array('fields'=>array('Diagnosis.no_allergy_flag'),'conditions'=>array('Diagnosis.patient_id'=>$patient_id)));
    		$this->set('allergyCheck',$allergyCheck['Diagnosis']['no_allergy_flag']);
    	}else if($this->params->query[controllerFlag]=='Notes'){
    		$allergyCheck=$this->Note->find('first',array('fields'=>array('Note.no_allergy_flag'),'conditions'=>array('Note.patient_id'=>$patient_id)));
    		$this->set('allergyCheck',$allergyCheck['Note']['no_allergy_flag']);
    		if(empty($allergyCheck)){
    			$allergyCheck=$this->Diagnosis->find('first',array('fields'=>array('Diagnosis.no_allergy_flag'),'conditions'=>array('Diagnosis.patient_id'=>$patient_id)));
    			$this->set('allergyCheck',$allergyCheck['Diagnosis']['no_allergy_flag']);
    		}
    	}
    	if(!empty($this->params->query[controllerFlag])){
    	$this->set('controllerFlag',$this->params->query[controllerFlag]);
    	}
    	else{
    		//For delete and add allergy problem -aditya(set Controller name)
    		$this->set('controllerFlag',$this->params->query[controllerName]);
    		//EOD
    	}
    	//EOF
    	
    	$uId=$this->Patient->find('first',array('fields'=>array('Patient.person_id'),'conditions'=>array('Patient.id'=>$patient_id)));
    	$this->set('uId',$uId['Patient']['person_id']);
    	if(!empty($personId) || $personId=='null'){
    		$this->set('personId',$personId);
    	}else{
    		$this->set('personId',$this->params->query['personId']);
    	}
    	
    	if($this->request['isAjax']){
    		$this->NewCropAllergies->insertRecord($patient_id,$this->request->data,$action);
    		$status='success';
    		$this->set('status',$status);
    		exit;
    	}

    	if(!empty($this->params->query['allergyAbsent']) && $this->params->query['allergyAbsent']=='notPresent'){
    		$this->set('flag',$this->params->query['allergyAbsent']);
    		$allergy=$this->NewCropAllergies->find('first',array('fields'=>array('NewCropAllergies.name'),'conditions'=>array('NewCropAllergies.id'=>$id)));
    		$temp=$this->AllergyMaster->find('list',array('fields'=>array('AllergyMaster.CompositeAllergyID','AllergyMaster.name'),'conditions'=>array('AllergyMaster.name LIKE'=>'%'.$allergy['NewCropAllergies']['name'].'%','AllergyMaster.status'=>'A')));
    		$this->set('temp',$temp);
    	}
    	
    	
    	if (!empty($this->request->data)){ 
    		//debug($this->request->data);exit;
    		$this->request->data['NewCropAllergies']['location_id']=$this->Session->read('locationid');
    		$this->request->data['NewCropAllergies']['is_posted']='no';
    		$this->request->data['NewCropAllergies']['patient_id']=$this->request->data['NewCropAllergies']['uId'];
    		$this->request->data['NewCropAllergies']['note']=$this->request->data['NewCropAllergies']['reaction'];
    		$onset_date = explode(" ",$this->DateFormat->formatDate2STD($this->request->data["NewCropAllergies"]['onset_date'],Configure::read('date_format')));
    		$this->request->data["NewCropAllergies"]['onset_date']=$onset_date[0];
    		$isAllergyExist=$this->NewCropAllergies->find('first',array('fields'=>'NewCropAllergies.id','conditions'=>array('NewCropAllergies.patient_uniqueid'=>$this->request->data["NewCropAllergies"]['patient_uniqueid'],'NewCropAllergies.name'=>$this->request->data['NewCropAllergies']['name'],'NewCropAllergies.is_deleted'=>0)));
    		if($isAllergyExist['NewCropAllergies']['id'] == '' || !empty($this->request->data['NewCropAllergies']['id'])){
    			if(empty($this->request->data['NewCropAllergies']['CompositeAllergyID'])){
    				$getCId=$this->AllergyMaster->find('first',array('fields'=>array('CompositeAllergyID'),'conditions'=>array('name'=>trim($this->request->data['NewCropAllergies']['name']))));
    				$this->request->data['NewCropAllergies']['CompositeAllergyID']=$getCId['AllergyMaster']['CompositeAllergyID'];
    				
    			}
    			if ($this->NewCropAllergies->save($this->request->data)){
    				if(!empty($this->request->data['NewCropAllergies']['id'])){
    					$this->Session->setFlash(__('Allergy updated successfully'),'default',array('class'=>'message'));
    					$status='success';
    					$this->set('status',$status);
    				}
    				else {  				
    					$this->Session->setFlash(__('Allergy saved successfully'),true);
    					$status='success';
    					$this->set('status',$status);
    				}
    				//$this->redirect(array('action'=>'allallergies',$patient_id));
    			} else {
    				$this->Session->setFlash('Unable to add your Allergy.');
    			}
    		}else{
    			$this->Session->setFlash(__('Allergy already exist'),'default',array('class'=>'error'));
    			$this->redirect(array('action'=>'allallergies',$patient_id));
    		}
    	}
    	else if(!empty($id) && ($id != 0)){
    		
    		$var=$this->NewCropAllergies->find('first',array('fields'=>array('id','name','status','onset_date','reaction','AllergySeverityName','ConceptType','CompositeAllergyID'),
    				'conditions'=>array('NewCropAllergies.id'=>$id)));
    		$this->set(compact('var'));
    		$var['NewCropAllergies']['onset_date'] = $this->DateFormat->formatDate2LocalForReport($var['NewCropAllergies']['onset_date'],Configure::read('date_format_us'),false);
    		$this->request->data=$var;
    		if ($this->request->is('post') || $this->request->is('put')) {
    			$this->NewCropAllergies->id = $id;
    		}
    	}
    	$this->patient_info($patient_id);
    	
    	//$patientUID = $this->Patient->find('first',array('fields'=>array('patient_id'),'conditions'=>array('Patient.id'=> $patient_id)));
    	 if(isset($personId) && !empty($personId)){
    		
    		//Encouter Data
    		$getEncounterId=$this->Note->encounterHandler($patient_id,$personId);
    			if(count($getEncounterId)=='1'){
    				$getEncounterId=$getEncounterId['0'];
    			}
    		//EOF
    		//$patientIdArray = $this->Patient->find('list',array('fields'=>array('id'),'conditions'=>array('Patient.patient_id'=> $patientUid)));
    		$previousEnc = true;
    	}else{
    		//Encouter Data
    		$getEncounterId=$this->Note->encounterHandler($patient_id,$this->params->query['personId']);
    		if(count($getEncounterId)=='1'){
    			$getEncounterId=$getEncounterId['0'];
    			$personId=$this->params->query['personId'];
    		}
    		//EOF
    		$previousEnc = false;
    	} 
		if(empty($this->params->query['personId'])){
			$this->params->query['personId']=$personId;
		}
    	$allergies_data=$this->NewCropAllergies->find('all',array('conditions'=>array('NewCropAllergies.is_deleted'=>0,'NewCropAllergies.patient_uniqueid'=>$getEncounterId,'NewCropAllergies.patient_id'=>$this->params->query['personId'],'NewCropAllergies.is_reconcile'=>0,'NewCropAllergies.location_id'=>$this->Session->read('locationid'),'NewCropAllergies.name !='=>'No active allergies')
    			,'order' => array('NewCropAllergies.patient_id DESC')
    	));
    	$this->set('id',$id);
    	$this->set('allergies_data',$allergies_data);
    	$this->set(array('patientId'=>$patient_id,'previousEnc'=>$previousEnc));
    	
    }
    public function deleteAllergy($patient_id=null,$id=null,$action=null,$patientUid=null){
    	$this->uses = array('NewCropAllergies');
    	$this->request->data['NewCropAllergies']['is_deleted']=1;
    	$this->NewCropAllergies->id= $id;
    	if($this->NewCropAllergies->save($this->request->data['NewCropAllergies'])){
    		$this->Session->setFlash(__('Allergy deleted successfully'),true);
    		$this->redirect(array('controller'=>'Diagnoses', "action" => "allallergies",$patient_id,'null','null',$this->params->query['personId'],'?'=>array('controllerName'=>$this->params->query['controllerName'])));
    	}
    }
    public function getAllergy($patientId=null,$personId=null){
    	
    	$this->layout='ajax';
    	$this->uses=array('NewCropAllergies','Person','Patient','Note');
    	$this->set('patientId',$patientId);
    	//Encouter Data
    	$getEncounterId=$this->Note->encounterHandler($patientId,$personId);
    	if(count($getEncounterId)=='1'){
    		$getEncounterId=$getEncounterId['0'];
    	}
    	//EOF
    	/* $allergies_data=$this->NewCropAllergies->find('all',array('conditions'=>array('NewCropAllergies.patient_uniqueid'=>$patientIDS,'NewCropAllergies.is_reconcile'=>0,'NewCropAllergies.location_id'=>$this->Session->read('locationid'),'NewCropAllergies.is_deleted'=>0,'NewCropAllergies.status'=>'A')
    			,'fields'=>array('id','patient_id','patient_uniqueid','name','AllergySeverityName','note','onset_date'),'order' => array('NewCropAllergies.patient_id DESC'))); */
    	$allergies_data=$this->NewCropAllergies->find('all',array('conditions'=>array('NewCropAllergies.is_deleted'=>0,'NewCropAllergies.patient_uniqueid'=>$getEncounterId,'NewCropAllergies.patient_id'=>$personId,'NewCropAllergies.is_reconcile'=>0,'NewCropAllergies.location_id'=>$this->Session->read('locationid'),'NewCropAllergies.status'=>'A','NewCropAllergies.is_deleted'=>0)
    			,'fields'=>array('name','status','CompositeAllergyID','id','patient_id','patient_uniqueid','AllergySeverityName','note','onset_date'),'order' => array('NewCropAllergies.patient_id DESC')
    	));
    	
    	if(!empty($allergies_data)){
    		$this->Diagnosis->updateAll(array('no_allergy_flag'=>'"no"'),array('Diagnosis.patient_id'=> $patientId));
    	}
    	$getallergycheck=$this->Diagnosis->find('first',array('conditions'=>array('patient_id'=>$patientId),'fields'=>array('id','no_allergy_flag','patient_id')));
    	$this->set('getallergycheck',$getallergycheck);
    	$this->set('data',$allergies_data);
    	echo $this->render('get_allergy');
    	exit;
    
    }
    public function getAllergyTop($patientId,$personId=null){
    	$this->layout='ajax';
    	$this->uses=array('NewCropAllergies','Person','Patient','Note');
    	$this->set('patientId',$patientId) ;
  		//Encouter Data
    	$getEncounterId=$this->Note->encounterHandler($patientId,$personId);
    	if(count($getEncounterId)=='1'){
    		$getEncounterId=$getEncounterId['0'];
    	}
    	//EOF
  	
    	/* $allergies_data=$this->NewCropAllergies->find('all',array('fields'=>array('patient_uniqueid','name'),'conditions'=>array('NewCropAllergies.patient_uniqueid'=>$patientIDS,'NewCropAllergies.is_reconcile'=>0,'NewCropAllergies.location_id'=>$this->Session->read('locationid'),'NewCropAllergies.status'=>'A','NewCropAllergies.is_deleted'=>0)
    			,'order' => array('NewCropAllergies.patient_id DESC'))); */
    	$allergies_data=$this->NewCropAllergies->find('all',array('conditions'=>array('NewCropAllergies.is_deleted'=>0,'NewCropAllergies.patient_uniqueid'=>$getEncounterId,'NewCropAllergies.is_reconcile'=>0,'NewCropAllergies.location_id'=>$this->Session->read('locationid'),'NewCropAllergies.status'=>'A','NewCropAllergies.is_deleted'=>0)
    			,'fields'=>array('id','patient_id','patient_uniqueid','name','AllergySeverityName','note','onset_date'),'order' => array('NewCropAllergies.patient_id DESC')
    	));
    	$this->Patient->bindModel( array(
    			'belongsTo' => array(
    					'Person'=>array('conditions'=>array('Person.id=Patient.person_id'),'foreignKey'=>false)
    			)
    	));
    	$patient = $this->Patient->find('first',array('fields'=>array('Person.dob','Patient.person_id','Patient.sex'),'conditions'=>array('Patient.id'=>$patientId)));
    	$var=$this->DateFormat->dateDiff($patient['Person']['dob'],date('Y-m-d'));
    	$day=$var->days;
    	$year=$var->y;
    	$this->set('year',$year);
    	$this->set('patient',$patient);
    	$this->set('personId',$personId);
    	$this->set('data',$allergies_data);
    	echo $this->render('get_allergy_top');
    	exit;
    
    }
    
    //EOF Allergys 
    
   
    public function postiveCheck($patientId,$id=null){
    	
    	$this->uses = array('Diagnosis');
    	if(empty($id)){
    		$this->Diagnosis->save(array('patient_id'=>$patientId,'positive_id'=>'1'));
    		$lastId=$this->Diagnosis->getLastInsertID();
    		//$this->redirect(array('controller'=>'Diagnoses','action'=>'initialAssessment',$patientId,$lastId));//$this->referer('/Diagnoses/initialAssessment/'.$patientId.'/'.$lastId)
    		echo json_encode(array('patientId'=>$patientId,'id'=>$lastId));
    		exit;
    	}else{
    		$this->Diagnosis->updateAll(array('Diagnosis.positive_id' => '1'), array('Diagnosis.id' => $id));
    		echo json_encode(array('patientId'=>$patientId,'id'=>$id));
    		exit;
    	}
    	
    }
    
    public function hpiCall($patientId,$diagnosesId=null){
    	$this->layout=ajax;
    	$this->uses=array('Template','TemplateTypeContent','Diagnosis');
    	$this->patient_info($patientId);
    		
    	if(isset($this->request->data) && !empty($this->request->data)){
    		$patientId=$this->request->data['TemplateTypeContent']['patientId'];
    		$diagnosesId=$this->request->data['TemplateTypeContent']['diagnosesId'];
    		
    		//*****************check for patient iD************************
    		if(empty($diagnosesId)){
    			$diagnosesId=$this->Diagnosis->addBlankEntry($patientId);
    		}
    		//*************eof****************************
    			
    		foreach($this->request->data['TemplateTypeContent'] as $keyHpi=>$checkDataHpi){
    			if (in_array("1", $checkDataHpi)) {
    				$cntHpi++;
    			}
    		}
    		if($cntHpi>0){
    			$categoryData=$this->TemplateTypeContent->insertCategoryIni($this->request->data['TemplateTypeContent'],$diagnosesId,$patientId);
    		}
    		if($categoryData=='1')
    			$this->Session->setFlash(__('HPI Recorded Sucessfully', true));
    		//	$this->redirect("/Diagnoses/initialAssessment/$patientId/$diagnosesId");
    		echo "<script> parent.$.fancybox.close();</script>" ;
    	}
    	$this->Template->bindModel(array(
    			'hasMany' => array(
    					'TemplateSubCategories' =>array(
    							'foreignKey'=>'template_id','conditions'=>array('TemplateSubCategories.is_deleted=0')
    					),
    			)));
    	$roseData=$this->Template->find('all',array('conditions'=>array('Template.template_category_id'=>3,'Template.is_deleted=0')));
    	$this->set('roseData',$roseData);
    	$templateTypeContent = $this->TemplateTypeContent->find('list',array('fields'=>array('template_id','template_subcategory_id'),'conditions'=>array('patient_id'=>$patientId,'diagnoses_id'=>$diagnosesId)));
    	$this->set('templateTypeContent',$templateTypeContent);
    	$this->set('patientId',$patientId);
    	$this->set('diagnosesId',$diagnosesId);
    }
    
    public function immunization_list($patient_id=null){
    	$this->layout='advance_ajax';
    	$this->uses = array('Imunization','Immunization','PhvsMeasureOfUnit','PhvsVaccinesMvx');
    	$this->Immunization->bindModel(array(
    			'belongsTo' => array(
    					'PhvsMeasureOfUnit' =>array('foreignKey' => false,'conditions'=>array('PhvsMeasureOfUnit.id=Immunization.phvs_unitofmeasure_id' )),
    					'Imunization' =>array('foreignKey' => false,'conditions'=>array('Imunization.id = Immunization.vaccine_type' )),
    					'PhvsVaccinesMvx' =>array('foreignKey' => false,'conditions'=>array('PhvsVaccinesMvx.id = Immunization.manufacture_name' ))
    			)),false);
    	$diagnosisRec = $this->Immunization->find('all',array('fields'=>array('id','patient_id','parent_id','vaccine_type','amount','PhvsVaccinesMvx.description','Imunization.cpt_description','PhvsMeasureOfUnit.value_code','phvs_unitofmeasure_id','lot_number','manufacture_name','date','expiry_date'),'conditions'=>array('patient_id'=>$patient_id,'Immunization.is_deleted'=>0)));
    	$this->set(array('immunization'=>$diagnosisRec,'patient_id'=>$patient_id));
    
    }
    
    public function getImunization($patientId){
    	$this->layout='ajax';
    	$this->uses=array('Immunization');
    	$this->set('patientId',$patientId) ;
    	$this->Immunization->bindModel(array(
				'belongsTo' => array(
						'PhvsMeasureOfUnit' =>array('foreignKey' => false,'conditions'=>array('PhvsMeasureOfUnit.id=Immunization.phvs_unitofmeasure_id' )),
						'Imunization' =>array('foreignKey' => false,'conditions'=>array('Imunization.id = Immunization.vaccine_type' )),
				)),false);
		$diagnosisRec = $this->Immunization->find('all',array('fields'=>array('id','patient_id','Imunization.cpt_description','date','expiry_date','amount','PhvsMeasureOfUnit.value_code'),
				'conditions'=>array('patient_id'=>$patientId,'Immunization.is_deleted'=>0)));
    	$this->set('data',$diagnosisRec);
    	echo $this->render('get_imunization');
    	exit;
    
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
    public function updateEventFlag($patientId){
    	$this->uses=array('Diagnosis');
    	$this->autoRender=false;
    	$getId=$this->Diagnosis->find('first',array('fields'=>array('id'),'conditions'=>array('patient_id'=>$patientId)));
    	
    	if(empty($getId)){
    		$this->Diagnosis->save(array('flag_event'=>$this->request->data['expression'],'patient_id'=>$patientId));
    	}
    	else{
    		$val=$this->request->data['expression'];
    		$this->Diagnosis->updateAll(array('flag_event'=>"'$val'",'patient_id'=>$patientId),array('id'=>$getId['Diagnosis']['id']));
    	}
    	exit;
    	
    }
    public function save_med($id=null){
    	$this->uses = array('NewCropPrescription','Configuration','NewCropAllergies');
    	$changeToIntactive=$this->request->data['NewCropPrescription']['is_active']['0'];
    	
    		if($id!='1'&& $changeToIntactive=='1'){
    			//**********************************INTERACTION CODE*****************************************************************
    			$allDrugId=$this->NewCropPrescription->find('all',array('fields'=>array('drug_id','patient_id'),'conditions'=>array('archive'=>'N','patient_id'=>$this->request->data['NewCropPrescription']['patientUId'])));
    			 
    			$listOfAllergy=$this->NewCropAllergies->find('all',array('fields'=>array('patient_uniqueid','CompositeAllergyID'),'conditions'=>array('patient_id'=>$this->request->data['NewCropPrescription']['patientUId'])));
    			//$getInteraction=$this->NewCropPrescription->drugdruginteracton
    		//	($this->request->data['NewCropPrescription']['drug_id'],$this->request->data['NewCropPrescription']['patientUId'],$allDrugId);/// Drug Drug Interactions
    		//	$getAllergyInteraction=$this->NewCropAllergies->drugAllergyInteraction($listOfAllergy,$this->request->data['NewCropPrescription']['drug_id'],$allDrugId,'fromCT');/// Drug Allergies Interactions
    		}
    		//********************************************************************************************************************
    		if((($getInteraction['rowcount']==0) && ($getAllergyInteraction['rowcount']==0))){
    			$result	= $this->Diagnosis->insertCurrentTreatment($this->request->data['NewCropPrescription']);
    			echo '1';
    			exit;
    		}
    	
    		else{
    			$xmlObj = $getInteraction = $getInteraction['rowDta'];
    			$listNo=1;
    			foreach($xmlObj->DrugInteraction as $key=>$data){
    				$ddInteraction[SeverityLevel][]= (string) $data->SeverityLevel;
    				$ddInteraction[ClinicalEffects][]= (string) $data->ClinicalEffects;
    				$ddInteraction[Drug1][]= (string) $data->Drug1;
    				$ddInteraction[Drug2][]= (string) $data->Drug2;
    				$listIneraction[]='<span style="color:#000">'.$listNo++.') '.(string) $data->Drug1.' has Interaction with '.(string) $data->Drug2.' =></span> '.(string) $data->SeverityLevel.' '.(string) $data->ClinicalEffects;
    			}
    			foreach($getAllergyInteraction['rowDta'] as $listAllergy){
    				$allergyInteraction[]=$listAllergy;
    				
    			}
    			echo json_encode(array('DrugDrug'=>$listIneraction,'Interaction'=>$getAllergyInteraction));exit;
    		}
    	}
    
    //***for no active medication***//
    public function setNoActiveMed($patientid=null,$checkrx=null,$patient_uid=null){
    	$this->autoRender = false ;
    	if($checkrx=='1'){
    		$setNoActive = $this->Diagnosis->setNoActiveMedByNurse($patientid,$checkrx,$patient_uid);
    	}
    	if($checkrx=='0'){
    		$unsetNoActive = $this->Diagnosis->unsetNoActiveMedByNurse($patientid,$checkrx,$patient_uid);
    	}
    }
    
    //***for no active allergy***//
    public function setNoActiveAllergy($patientid=null,$checkall=null,$patient_uid=null){
    	$this->autoRender = false ;
    	if($checkall=='1'){
    		$setNoActiveAll = $this->Diagnosis->setNoActiveAllergyByNurse($patientid,$checkall,$patient_uid);
    	}
    	if($checkall=='0'){
    		$unsetNoActiveAll = $this->Diagnosis->unsetNoActiveAllergyByNurse($patientid,$checkall,$patient_uid);
    	}
    }

    public function pharmacySearch($recID=null){
    	$this->autoRender = false ;
    	$this->uses = array('PharmacyMaster');
    	$getpharmacy=$this->PharmacyMaster->find('first',array('fields'=>array('PharmacyMaster.Pharmacy_Address1','PharmacyMaster.Pharmacy_Address2','PharmacyMaster.Pharmacy_Telephone1',
    			'PharmacyMaster.Pharmacy_Fax','PharmacyMaster.Pharmacy_City','PharmacyMaster.Pharmacy_StateAbbr','PharmacyMaster.Pharmacy_Zip'),
    			'conditions'=>array('Pharmacy_NCPDP'=>$recID)));
    	echo json_encode($getpharmacy['PharmacyMaster']);
    }
    
    
    /**BOF Advance pharmacy search**/
    public function advancePharmacySearch(){
    	$this->layout ="advance_ajax" ;
    	$this->uses=array('PharmacyMaster');
    	
    	if(!empty($this->params->query)){
    		
    		if(!empty($this->params->query['address'])){
    			$search_key['PharmacyMaster.Pharmacy_Address1 like '] = trim($this->params->query['address'])."%" ;
    		}
    		
    		if(!empty($this->params->query['phone'])){
    			$search_key['PharmacyMaster.Pharmacy_Telephone1 like '] = trim($this->params->query['phone'])."%" ;
    		}
    		
    		if(!empty($this->params->query['fax'])){
    			$search_key['PharmacyMaster.Pharmacy_Fax like '] = trim($this->params->query['fax'])."%" ;
    		}
    		
	    	if(!empty($this->params->query['zip'])){
	    		$search_key['PharmacyMaster.Pharmacy_Zip like '] = trim($this->params->query['zip'])."%" ;
	    	}
	    	
	    	if(!empty($this->params->query['city'])){
	    		$search_key['PharmacyMaster.Pharmacy_City like '] = trim($this->params->query['city'])."%" ;
	    	}
	    	
	    	if(!empty($this->params->query['state'])){
	    		$search_key['PharmacyMaster.Pharmacy_StateAbbr like '] = trim($this->params->query['state'])."%" ;
	    	}
	    	$activecondition=array('PharmacyMaster.Pharmacy_Status' => 'A');
	    	$conditions=array($search_key,$activecondition);
	    	$conditions = array_filter($conditions);
	    	if(!empty($conditions)){
		    	$this->paginate = array('limit' => '10',
		    			'fields' => array('PharmacyMaster.Pharmacy_StoreName','PharmacyMaster.Pharmacy_Address1','PharmacyMaster.Pharmacy_Address2',
			    			'PharmacyMaster.Pharmacy_Fax','PharmacyMaster.Pharmacy_Telephone1','PharmacyMaster.Pharmacy_City','PharmacyMaster.Pharmacy_StateAbbr',
			    			'PharmacyMaster.Pharmacy_Zip','PharmacyMaster.Pharmacy_NCPDP'),
		    			'order'=>array('PharmacyMaster.Pharmacy_StoreName' => 'ASC'),
		    			'conditions' => $conditions );
		    	
		    	$allData = $this->paginate('PharmacyMaster');
		    	$this->set('allData',$allData);
	    	}
    	}
    }
    /**BOF Advance pharmacy search**/
    
    public function getFrequentMedication($patientId=null,$healthPlanId=0){
    	$this->layout='ajax';
    	$this->uses=array('NewCropPrescription','PharmacyItem');
    	//******************************Set Frequent medication for doctors ADITYA******************
    	$getMedicationByDoctor=$this->NewCropPrescription->find('list',array('fields'=>array('id','description'),
    			'conditions'=>array('created_by'=>$_SESSION['Auth']['User']['id'])));
    	$oneArray=array_count_values($getMedicationByDoctor);
    	$towArray=array_keys($oneArray);
    	foreach( $towArray as $towArrays){
    		if($oneArray[$towArrays]>2){
    			$frequentMedication[]=$towArrays;
    		}
    	}
    	$frequentMedicationByDoctor=$this->NewCropPrescription->find('all',array('fields'=>array('drug_id','description'),
    			'conditions'=>array('description'=>$frequentMedication),'group'=>array('drug_id')));
    	$this->set('frequentMedicationByDoctor',$frequentMedicationByDoctor);
    	
    	$this->set('patientId',$patientId);
    	$this->set('healthPlanId',$healthPlanId);
    	
    	echo $this->render('get_frequent_medication');
    	exit;
    	//**************************EOD*************************************************************
    }
    
    public function painHtml($counter){
    	$this->layout = false ;
    	$this->set("counter",$counter);
    }
    
    public function getPastMedicalHistory($patient_id,$personId){
		$this->layout = 'ajax' ;
		$this->uses=array('NoteDiagnosis','Note');
		//Encouter Data
		$getEncounterId=$this->Note->encounterHandler($patient_id,$personId);
		if(count($getEncounterId)=='1'){
			$getEncounterId=$getEncounterId['0'];
		}
		//EOF
		
		$pop = array_pop($getEncounterId);
		
		if(count($getEncounterId) < '2'){
			$previousDiagnosis =='';
		}else{
			$previousDiagnosis = $this->NoteDiagnosis->find('all',array('fields'=>array('NoteDiagnosis.id','NoteDiagnosis.note_id,NoteDiagnosis.diagnoses_name,NoteDiagnosis.diagnosis_type,NoteDiagnosis.icd_id,NoteDiagnosis.snowmedid,NoteDiagnosis.patient_id,NoteDiagnosis.terminal'),'conditions'=>array('NoteDiagnosis.patient_id'=>$getEncounterId),'order'=>array('NoteDiagnosis.id DESC')));
		}
		$this->set('previousDiagnosis',$previousDiagnosis);
	}
	
	function updateCC(){
		$this->uses = array('Diagnosis','Note');
			if(!empty($this->request->data['Diagnosis'])){
		//	debug($this->request->data['Diagnosis']);exit;
	    		$Did=$this->Diagnosis->find('first',array('fields'=>array('id','patient_id','note_id'),'conditions'=>array('patient_id'=>$this->request->data['Diagnosis']['patient_id'])));
	    		
	    		$flag_event=$this->request->data['Diagnosis']['flag_event'];
	    		$family_tit_bit=$this->request->data['Diagnosis']['family_tit_bit'];
	    		$complaints=$this->request->data['Diagnosis']['complaints'];
	    		if(!empty($Did)){
	    			$this->request->data['Diagnosis']['modify_time'] = date("Y-m-d H:i:s");
	    			$this->request->data['Diagnosis']['modified_by'] =  $this->Session->read('userid');
	    			$this->request->data['Diagnosis']['location_id'] = $this->Session->read('locationid');
	    			$this->request->data['Diagnosis']['id']=$Did['Diagnosis']['id'];
	    			$this->Diagnosis->save($this->request->data['Diagnosis']);
	    			if(($Did['Diagnosis']['note_id'] != "") && !empty($Did['Diagnosis']['note_id']) && isset($Did['Diagnosis']['note_id'])){
	    				$this->Note->updateAll(array('cc'=>"'$complaints'",'family_tit_bit'=>"'$family_tit_bit'"),
	    						array('Note.id'=>$Did['Diagnosis']['note_id']));
	    			}
	    		}else{
	    			$this->request->data['Diagnosis']['create_time'] = date("Y-m-d H:i:s");
	    			$this->request->data['Diagnosis']['created_by']  =  $this->Session->read('userid');
	    			$this->request->data['Diagnosis']['location_id'] = $this->Session->read('locationid');
	    			$this->Diagnosis->save($this->request->data['Diagnosis']);
	    		}

    		}
		
		exit;
	}
	
	public function getDiagnosis($patient_id,$id=NULL){
				if(!empty($id) && $id!='null'){
					$this->request->data['id']=$id;
					$this->request->data['modify_time']=date('Y-m-d H:i:s');
					$this->request->data['modify_by']=$this->Session->read('userid');
					
				}else{
					$this->request->data['patient_id']=$patient_id;
					$this->request->data['create_time']=date('Y-m-d H:i:s');
					$this->request->data['created_by']=$this->Session->read('userid');
				}
				
				$this->request->data['final_diagnosis']=$this->request->query['diagnosis'];	
				$this->request->data['ICD_code']=$this->request->query['icdCode'];
				$this->Diagnosis->save($this->request->data);	
				$this->Diagnosis->id = '';
				exit;
			}
			
/**
 *
 * @author Atul Chandankhede
 *
 */
public function diagnosisAutocomplete(){
	$this->layout = 'ajax';
	$this->loadModel('SnomedMappingMaster');
	$conditions =array();
	$searchKey = $this->params->query['term'] ;
	
	$conditions["SnomedMappingMaster.icdName like"] = $searchKey.'%';
	$conditions["SnomedMappingMaster.active"] = '1';
	$conditions["SnomedMappingMaster.is_deleted"] = '0';

	$testArray = $this->SnomedMappingMaster->find('all', array(
			'fields'=> array('SnomedMappingMaster.id','SnomedMappingMaster.icdName','SnomedMappingMaster.mapTarget'),
			'conditions'=>$conditions,
			'order'=>array("SnomedMappingMaster.id Desc"),
			'group'=>array("SnomedMappingMaster.mapTarget"),
			'limit'=>Configure::read('number_of_rows')));


	foreach ($testArray as $key=>$value) {
		$returnArray[]=array('id'=>$value['SnomedMappingMaster']['id'],'value'=>$value['SnomedMappingMaster']['icdName'],'icd10Code'=>$value['SnomedMappingMaster']['mapTarget']);
	}

	echo json_encode($returnArray);
	exit;
		
}
			
public function icdAutocomplete(){
	$this->layout = 'ajax';
	$this->loadModel('SnomedMappingMaster');
	$conditions =array();
	$searchKey = $this->params->query['term'] ;

	$conditions["SnomedMappingMaster.mapTarget like"] = $searchKey.'%';
	$conditions["SnomedMappingMaster.active"] = '1';
	$conditions["SnomedMappingMaster.is_deleted"] = '0';
		
	$testArray = $this->SnomedMappingMaster->find('all', array(
			'fields'=> array('SnomedMappingMaster.id','SnomedMappingMaster.icdName','SnomedMappingMaster.mapTarget'),
			'conditions'=>$conditions,
			'order'=>array("SnomedMappingMaster.id Desc"),
			'group'=>array("SnomedMappingMaster.mapTarget"),
			'limit'=>Configure::read('number_of_rows')));
		
		
	foreach ($testArray as $key=>$value) {
		$returnArray[]=array('id'=>$value['SnomedMappingMaster']['id'],'value'=>$value['SnomedMappingMaster']['mapTarget'],'icdName'=>$value['SnomedMappingMaster']['icdName']);
	}
		
	echo json_encode($returnArray);
	exit;
		
}

public function diagnosisKeywordSearch(){
	$this->layout = 'ajax';
	$this->loadModel('Diagnosis');
	$conditions =array();
	$searchKey = $this->params->query['term'] ;

	$conditions["Diagnosis.final_diagnosis like"] = '%'.$searchKey.'%';
	$conditions["Diagnosis.is_deleted"] = '0';

	$testArray = $this->Diagnosis->find('all', array(
			'fields'=> array('Diagnosis.id','Diagnosis.final_diagnosis','Diagnosis.patient_id'),
			'conditions'=>array($conditions,'Diagnosis.final_diagnosis IS NOT NULL','Diagnosis.final_diagnosis NOT'=>''),
			'order'=>array("Diagnosis.final_diagnosis ASC"),
			'group'=>array("Diagnosis.id"),
			'limit'=>Configure::read('number_of_rows')));


	foreach ($testArray as $key=>$value) {
		$returnArray[]=array('id'=>$value['Diagnosis']['id'],'value'=>$value['Diagnosis']['final_diagnosis'],'patient_id'=>$value['Diagnosis']['patient_id']);
	}

	echo json_encode($returnArray);
	exit;

}

public function saveBillingDiagnosis($patient_id,$id=NULL){
	if(!empty($id) && $id!='null'){
		$this->request->data['id']=$id;
		$this->request->data['modify_time']=date('Y-m-d H:i:s');
		$this->request->data['modify_by']=$this->Session->read('userid');
			
	}else{
		$this->request->data['patient_id']=$patient_id;
		$this->request->data['create_time']=date('Y-m-d H:i:s');
		$this->request->data['created_by']=$this->Session->read('userid');
	}

	$this->request->data['actual_diagnosis']=$this->request->query['billing_diagnosis'];
	$this->Diagnosis->save($this->request->data);
	$this->Diagnosis->id = '';
	exit;
}

public function actualDiagnosisSearch(){
	$this->layout = 'ajax';
	$this->loadModel('Diagnosis');
	$conditions =array();
	$searchKey = $this->params->query['term'] ;

	$conditions["Diagnosis.actual_diagnosis like"] = '%'.$searchKey.'%';
	$conditions["Diagnosis.is_deleted"] = '0';

	$testArray = $this->Diagnosis->find('all', array(
			'fields'=> array('Diagnosis.id','Diagnosis.actual_diagnosis','Diagnosis.patient_id'),
			'conditions'=>array($conditions,'Diagnosis.actual_diagnosis IS NOT NULL','Diagnosis.actual_diagnosis NOT'=>''),
			'order'=>array("Diagnosis.actual_diagnosis ASC"),
			'group'=>array("Diagnosis.actual_diagnosis"),
			'limit'=>Configure::read('number_of_rows')));


	foreach ($testArray as $key=>$value) {
		$returnArray[]=array('id'=>$value['Diagnosis']['id'],'value'=>$value['Diagnosis']['actual_diagnosis'],'patient_id'=>$value['Diagnosis']['patient_id']);
	}

	echo json_encode($returnArray);
	exit;

}
	
}///EOF class$patientId