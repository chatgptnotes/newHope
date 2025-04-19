<?php
/**
 * Insurance controller
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Accounting Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Mahalaxmi
 */
 

//class InsurancesController extends AppController {
App::import('Controller', 'Billings');
class InsurancesController extends BillingsController {

	public $name = 'Insurances';
	public $uses =null;
	public $helpers = array('Html','Form', 'Js','DateFormat','RupeesToWords','Number','General','JsFusionChart');
	public $components = array('RequestHandler','Email','General');


	////BOF Encounters-@author        Mahalaxmi
	public function addNewEncounter($patient_id=null,$id=null,$type){
		ob_end_clean();
		ob_start("ob_gzhandler");
		$this->patient_info($patient_id);
		$this->uses = array('NewInsurance','State','Encounter','SubClaim','BillingOtherCode','Person','ProcedurePerform','DoctorProfile','Patient','NewInsurance','Department','User','FinalBilling','BillingProfile','DeathCertificate','BmiResult','TariffStandard');

		if($this->request->query['request'] == 'iframe'){
			$this->layout = false;
		}
		$getInsuranceAuth=$this->NewInsurance->find('all',array('fields'=>array('id','pri_is_authorized','sec_is_authorized','tri_is_authorized'),'conditions'=>array('patient_id'=>$patient_id)));
		$this->set('getInsuranceAuth',$getInsuranceAuth);
		$this->Person->bindModel(array(
				'hasOne'=>array(
						'Patient' =>array('foreignKey' => false,
								'conditions'=>array('Patient.person_id=Person.id'),
						),
				)),false);
		$getstateInfo=$this->State->find('list',array('fields'=>array('id','name'),'order' => array('State.name'),'conditions'=>array('State.country_id'=>'2')));
		$getpatientDetials=$this->Person->find('first',array('fields'=>array('Patient.id','sex','Patient.admission_id','Patient.lookup_name'),'conditions'=>array('Patient.id'=>$patient_id)));
		$getWieghtInfo=$this->BmiResult->find('first',array('fields'=>array('weight_result'),'conditions'=>array('BmiResult.patient_id'=>$patient_id)));
		$getExpireInfo=$this->DeathCertificate->find('first',array('fields'=>array('expired_on'),'conditions'=>array('DeathCertificate.patient_id'=>$patient_id)));
		$billingProfileData=$this->BillingProfile->find('list',array('fields'=>array('id','billing_profile_name'),'order' => array('BillingProfile.billing_profile_name')));
		$departments=$this->Department->find('list',array('fields'=>array('id','name'),'order' => array('Department.name'),'conditions'=>array('Department.location_id'=>$this->Session->read('locationid'))));
		$getPatientInfo=$this->Patient->find('first',array('fields'=>array('id','admission_id','lookup_name','form_received_on','discharge_date','form_completed_on'),'order' => array('Patient.lookup_name'),'conditions'=>array('Patient.id'=>$patient_id)));
		$this->set('userMedical',$this->User->getMedicalCoder());
		$this->set('doctors',$this->DoctorProfile->getDoctors());
		//**********************************Procedure Perform CODES***************************************************************************
		$BilCode=$this->BillingOtherCode->find('list',array('fields'=>array('code','name')));
		$this->ProcedurePerform->bindModel(array(
				'belongsTo' => array(
						'TariffList' =>array( 'foreignKey'=>false,'conditions'=>array('ProcedurePerform.snowmed_code=TariffList.cbt')),
						'TariffAmount' =>array( 'foreignKey'=>false,'conditions'=>array('TariffList.id=TariffAmount.tariff_list_id')),
				)),false);
		$getPrData=$this->ProcedurePerform->find('all',array('conditions'=>array('patient_id'=>$patient_id),
				'fields'=>array('TariffList.price_for_private','ProcedurePerform.procedure_name','ProcedurePerform.snowmed_code',
						'ProcedurePerform.modifier1','ProcedurePerform.modifier2','ProcedurePerform.modifier3','ProcedurePerform.modifier4',
						'ProcedurePerform.procedure_to_date','ProcedurePerform.place_service','ProcedurePerform.units','ProcedurePerform.patient_daignosis',
						'ProcedurePerform.procedure_date','TariffAmount.non_nabh_charges')));

		 
		//***********************************************************************************************************************
		$this->set(compact('getstateInfo','BilCode','getPrData','encounterData','patient_id','getPatientInfo','getpatientDetials',
				'departments','cities','users','getCopayDue','billingProfileData','getExpireInfo','getWieghtInfo','getDataInsuranceType'));
		//********************************To set the data form NewInsurance to tab section***********************************************************
		if($type=='add' && empty($this->request->data)){
			$getNewInsurance=$this->NewInsurance->find('all',array('conditions'=>array('OR'=>array('id'=>$id,'refference_id'=>$id)),'fields'=>array('tariff_standard_id','tariff_standard_name')));
			$this->set('getNewInsurance',$getNewInsurance);
			$this->set('newInsuranceId',$id);
		}else{
			//*******************************Edit Case to set Data*****************************************************************************
			$subClaimData = $this->SubClaim->find('first',array('conditions'=>array('SubClaim.encounter_id'=>$id)));
			$this->set(compact('subClaimData'));			
			if($type=='edit' && empty($this->request->data)){
				$this->Encounter->bindModel(array(
						'hasMany'=>array(
								'SubClaim' =>array('foreignKey' => 'encounter_id',
								),
						)),false);
				$getEncounterDetails=$this->Encounter->find('all',array('conditions'=>array('Encounter.id'=>$id)));
				if(!empty($getEncounterDetails['0']['Encounter']['payment_post_date'])){
					$getEncounterDetails['0']['Encounter']['payment_post_date'] = $this->DateFormat->formatDate2Local($getEncounterDetails['0']['Encounter']['payment_post_date'],Configure::read('date_format'),true);
				}
				if(!empty($getEncounterDetails['0']['Encounter']['to_date']))
					$getEncounterDetails['0']['Encounter']['to_date'] = $this->DateFormat->formatDate2Local($getEncounterDetails['0']['Encounter']['to_date'],Configure::read('date_format'));

				if(!empty($getEncounterDetails['0']['Encounter']['service_date'])){
					$getEncounterDetails['0']['Encounter']['service_date'] = $this->DateFormat->formatDate2Local($getEncounterDetails['0']['Encounter']['service_date'],Configure::read('date_format'),true);
				}
				if(!empty($getEncounterDetails['0']['Encounter']['accident_date']))
					$getEncounterDetails['0']['Encounter']['accident_date'] = $this->DateFormat->formatDate2Local($getEncounterDetails['0']['Encounter']['accident_date'],Configure::read('date_format'));

				if(!empty($getEncounterDetails['0']['Encounter']['post_date']))
					$getEncounterDetails['0']['Encounter']['post_date'] = $this->DateFormat->formatDate2Local($getEncounterDetails['0']['Encounter']['post_date'],Configure::read('date_format'));

				if(!empty($getEncounterDetails['0']['Encounter']['date_of_death']))
					$getEncounterDetails['0']['Encounter']['date_of_death'] = $this->DateFormat->formatDate2Local($getEncounterDetails['0']['Encounter']['date_of_death'],Configure::read('date_format'));

				if(!empty($getEncounterDetails['0']['Encounter']['first_contact_date']))
					$getEncounterDetails['0']['Encounter']['first_contact_date'] = $this->DateFormat->formatDate2Local($getEncounterDetails['0']['Encounter']['first_contact_date'],Configure::read('date_format'));

				if(!empty($getEncounterDetails['0']['Encounter']['onset_currrent_date']))
					$getEncounterDetails['0']['Encounter']['onset_currrent_date'] = $this->DateFormat->formatDate2Local($getEncounterDetails['0']['Encounter']['onset_currrent_date'],Configure::read('date_format'));

				if(!empty($getEncounterDetails['0']['Encounter']['last_menstrual_period_date']))
					$getEncounterDetails['0']['Encounter']['last_menstrual_period_date'] = $this->DateFormat->formatDate2Local($getEncounterDetails['0']['Encounter']['last_menstrual_period_date'],Configure::read('date_format'));

				if(!empty($getEncounterDetails['0']['Encounter']['last_seen_date']))
					$getEncounterDetails['0']['Encounter']['last_seen_date'] = $this->DateFormat->formatDate2Local($getEncounterDetails['0']['Encounter']['last_seen_date'],Configure::read('date_format'));

				if(!empty($getEncounterDetails['0']['Encounter']['referral_date']))
					$getEncounterDetails['0']['Encounter']['referral_date'] = $this->DateFormat->formatDate2Local($getEncounterDetails['0']['Encounter']['referral_date'],Configure::read('date_format'));

				if(!empty($getEncounterDetails['0']['Encounter']['similar_illness_date']))
					$getEncounterDetails['0']['Encounter']['similar_illness_date'] = $this->DateFormat->formatDate2Local($getEncounterDetails['0']['Encounter']['similar_illness_date'],Configure::read('date_format'));

				if(!empty($getEncounterDetails['0']['Encounter']['initial_treatment_date']))
					$getEncounterDetails['0']['Encounter']['initial_treatment_date'] = $this->DateFormat->formatDate2Local($getEncounterDetails['0']['Encounter']['initial_treatment_date'],Configure::read('date_format'));

				if(!empty($getEncounterDetails['0']['Encounter']['acute_manifestation_date']))
					$getEncounterDetails['0']['Encounter']['acute_manifestation_date'] = $this->DateFormat->formatDate2Local($getEncounterDetails['0']['Encounter']['acute_manifestation_date'],Configure::read('date_format'));

				if(!empty($getEncounterDetails['0']['Encounter']['hearing_date']))
					$getEncounterDetails['0']['Encounter']['hearing_date'] = $this->DateFormat->formatDate2Local($getEncounterDetails['0']['Encounter']['hearing_date'],Configure::read('date_format'));

				if(!empty($getEncounterDetails['0']['Encounter']['last_xray_date']))
					$getEncounterDetails['0']['Encounter']['last_xray_date'] = $this->DateFormat->formatDate2Local($getEncounterDetails['0']['Encounter']['last_xray_date'],Configure::read('date_format'));

				if(!empty($getEncounterDetails['0']['Encounter']['order_date']))
					$getEncounterDetails['0']['Encounter']['order_date'] = $this->DateFormat->formatDate2Local($getEncounterDetails['0']['Encounter']['order_date'],Configure::read('date_format'));

				if(!empty($getEncounterDetails['0']['Encounter']['not_work_from_date']))
					$getEncounterDetails['0']['Encounter']['not_work_from_date'] = $this->DateFormat->formatDate2Local($getEncounterDetails['0']['Encounter']['not_work_from_date'],Configure::read('date_format'));

				if(!empty($getEncounterDetails['0']['Encounter']['not_work_to_date']))
					$getEncounterDetails['0']['Encounter']['not_work_to_date'] = $this->DateFormat->formatDate2Local($getEncounterDetails['0']['Encounter']['not_work_to_date'],Configure::read('date_format'));

				if(!empty($getEncounterDetails['0']['Encounter']['disability_from_date']))
					$getEncounterDetails['0']['Encounter']['disability_from_date'] = $this->DateFormat->formatDate2Local($getEncounterDetails['0']['Encounter']['disability_from_date'],Configure::read('date_format'));

				if(!empty($getEncounterDetails['0']['Encounter']['disability_to_date']))
					$getEncounterDetails['0']['Encounter']['disability_to_date'] = $this->DateFormat->formatDate2Local($getEncounterDetails['0']['Encounter']['disability_to_date'],Configure::read('date_format'));

				if(!empty($getEncounterDetails['0']['Encounter']['care_from_date']))
					$getEncounterDetails['0']['Encounter']['care_from_date'] = $this->DateFormat->formatDate2Local($getEncounterDetails['0']['Encounter']['care_from_date'],Configure::read('date_format'));

				if(!empty($getEncounterDetails['0']['Encounter']['care_to_date']))
					$getEncounterDetails['0']['Encounter']['care_to_date'] = $this->DateFormat->formatDate2Local($getEncounterDetails['0']['Encounter']['care_to_date'],Configure::read('date_format'));
					
				$this->data=$getEncounterDetails['0'];
			}
			//****************************************Edit form Here******************************************************************************************
			else {
				if(!empty($this->request->data['Encounter']['service_date']))
					$this->request->data['Encounter']['service_date'] = $this->DateFormat->formatDate2STD($this->request->data['Encounter']['service_date'],Configure::read('date_format'));
				if(!empty($this->request->data['Encounter']['to_date']))
					$this->request->data['Encounter']['to_date'] = $this->DateFormat->formatDate2STD($this->request->data['Encounter']['to_date'],Configure::read('date_format'));
				if(!empty($this->request->data['Encounter']['post_date']))
					$this->request->data['Encounter']['post_date'] = $this->DateFormat->formatDate2STD($this->request->data['Encounter']['post_date'],Configure::read('date_format'));
				if(!empty($this->request->data['Encounter']['payment_post_date']))
					$this->request->data['Encounter']['payment_post_date'] = $this->DateFormat->formatDate2STD($this->request->data['Encounter']['payment_post_date'],Configure::read('date_format'));
				if(!empty($this->request->data['Encounter']['date_of_death']))
					$this->request->data['Encounter']['date_of_death'] = $this->DateFormat->formatDate2STD($this->request->data['Encounter']['date_of_death'],Configure::read('date_format'));
				if(!empty($this->request->data['Encounter']['first_contact_date']))
					$this->request->data['Encounter']['first_contact_date'] = $this->DateFormat->formatDate2STD($this->request->data['Encounter']['first_contact_date'],Configure::read('date_format'));
				if(!empty($this->request->data['Encounter']['accident_date']))
					$this->request->data['Encounter']['accident_date'] = $this->DateFormat->formatDate2STD($this->request->data['Encounter']['accident_date'],Configure::read('date_format'));
				if(!empty($this->request->data['Encounter']['onset_currrent_date']))
					$this->request->data['Encounter']['onset_currrent_date'] = $this->DateFormat->formatDate2STD($this->request->data['Encounter']['onset_currrent_date'],Configure::read('date_format'));
				if(!empty($this->request->data['Encounter']['last_menstrual_period_date']))
					$this->request->data['Encounter']['last_menstrual_period_date'] = $this->DateFormat->formatDate2STD($this->request->data['Encounter']['last_menstrual_period_date'],Configure::read('date_format'));
				if(!empty($this->request->data['Encounter']['last_seen_date']))
					$this->request->data['Encounter']['last_seen_date'] = $this->DateFormat->formatDate2STD($this->request->data['Encounter']['last_seen_date'],Configure::read('date_format'));
				if(!empty($this->request->data['Encounter']['referral_date']))
					$this->request->data['Encounter']['referral_date'] = $this->DateFormat->formatDate2STD($this->request->data['Encounter']['referral_date'],Configure::read('date_format'));
				if(!empty($this->request->data['Encounter']['similar_illness_date']))
					$this->request->data['Encounter']['similar_illness_date'] = $this->DateFormat->formatDate2STD($this->request->data['Encounter']['similar_illness_date'],Configure::read('date_format'));
				if(!empty($this->request->data['Encounter']['initial_treatment_date']))
					$this->request->data['Encounter']['initial_treatment_date'] = $this->DateFormat->formatDate2STD($this->request->data['Encounter']['initial_treatment_date'],Configure::read('date_format'));
				if(!empty($this->request->data['Encounter']['acute_manifestation_date']))
					$this->request->data['Encounter']['acute_manifestation_date'] = $this->DateFormat->formatDate2STD($this->request->data['Encounter']['acute_manifestation_date'],Configure::read('date_format'));
				if(!empty($this->request->data['Encounter']['hearing_date']))
					$this->request->data['Encounter']['hearing_date'] = $this->DateFormat->formatDate2STD($this->request->data['Encounter']['hearing_date'],Configure::read('date_format'));
				if(!empty($this->request->data['Encounter']['last_xray_date']))
					$this->request->data['Encounter']['last_xray_date'] = $this->DateFormat->formatDate2STD($this->request->data['Encounter']['last_xray_date'],Configure::read('date_format'));
				if(!empty($this->request->data['Encounter']['order_date']))
					$this->request->data['Encounter']['order_date'] = $this->DateFormat->formatDate2STD($this->request->data['Encounter']['order_date'],Configure::read('date_format'));
				if(!empty($this->request->data['Encounter']['not_work_from_date']))
					$this->request->data['Encounter']['not_work_from_date'] = $this->DateFormat->formatDate2STD($this->request->data['Encounter']['not_work_from_date'],Configure::read('date_format'));
				if(!empty($this->request->data['Encounter']['not_work_to_date']))
					$this->request->data['Encounter']['not_work_to_date'] = $this->DateFormat->formatDate2STD($this->request->data['Encounter']['not_work_to_date'],Configure::read('date_format'));
				if(!empty($this->request->data['Encounter']['disability_from_date']))
					$this->request->data['Encounter']['disability_from_date'] = $this->DateFormat->formatDate2STD($this->request->data['Encounter']['disability_from_date'],Configure::read('date_format'));
				if(!empty($this->request->data['Encounter']['disability_to_date']))
					$this->request->data['Encounter']['disability_to_date'] = $this->DateFormat->formatDate2STD($this->request->data['Encounter']['disability_to_date'],Configure::read('date_format'));
				if(!empty($this->request->data['Encounter']['care_from_date']))
					$this->request->data['Encounter']['care_from_date'] = $this->DateFormat->formatDate2STD($this->request->data['Encounter']['care_from_date'],Configure::read('date_format'));
				if(!empty($this->request->data['Encounter']['care_to_date']))
					$this->request->data['Encounter']['care_to_date'] = $this->DateFormat->formatDate2STD($this->request->data['Encounter']['care_to_date'],Configure::read('date_format'));
				$this->request->data['Encounter']['location_id']=$this->Session->read('locationid');
				$this->request->data['Encounter']['created_by']=$this->Session->read('userid');				
		
				if($this->Encounter->save($this->request->data)){	
				//	$lastInsertID = $this->Encounter->getLastInsertId();
					$check=$this->SubClaim->saveSubClaims($this->request->data);					
					if($check[0]==1){		
					if(empty($this->request->data['Encounter']['id'])){							
							$this->Session->setFlash(__('Encounter saved successfully'),'default',array('class'=>'message'));
							$lastInsertID=$check[1];
							$this->redirect(array('controller'=>'Insurances','action'=>'addBeforeClaim',$patient_id,$lastInsertID,$this->request->data['Encounter']['billing_profile']));
					}else{					
					$this->Session->setFlash(__('Encounter updated successfully'),'default',array('class'=>'message'));
					//debug($this->request->data['Encounter']['billing_profile']);exit;
					//$this->redirect('/Insurances/addBeforeClaim?patientID='.$patient_id.'&id='.$lastInsertID.'&Bprofile='.$this->request->data['Encounter']['billing_profile']);
					$this->redirect(array('controller'=>'Insurances','action'=>'addBeforeClaim',$patient_id,$id,$this->request->data['Encounter']['billing_profile']));
					}
					}else{						
					$this->Session->setFlash('Unable to add your Encounter.');
					}
					//}else{
					//	$lastInsertID = $this->Encounter->getLastInsertID();
					//	$this->Session->setFlash(__('Encounter saved successfully'),true);
					//	$this->redirect(array('action'=>'addBeforeClaim',$patient_id,$lastInsertID));
					//}
				}else{
					$this->Session->setFlash('Unable to add your Encounter.');
				}
			}
		}


		//------------------------------mail code by - AC--------------------------------------------------
		//if(!empty($data['Patient']['email'])){
		// mail functions
		/* App::import('Vendor', 'PHPMailer', array('file' => 'phpmailer/class.phpmailer.php'));

		$mail = new PHPMailer();
		$emailAddress='pankajm@drmhope.com';
		$mail->AddAddress($emailAddress);
		$mail->SetFrom('adityac@drmhope.com', 'Aditya');
		$mail->AddReplyTo('adityac@drmhope.com', 'DrmHope');

		$mail->Subject  = "Sample Mail" ;
		$mail->Body     = "Your Patient has passed the Pre Authorization ";
		$mail->WordWrap = 50;
		$send =  $mail->Send() ;
		if(!$send) {
		$this->set("errors", $errors);
		echo 'Mailer error: ' . $mail->ErrorInfo;
		$this->Session->setFlash(__('Unable to send mail'),'default',array('class'=>'error'));
		} else {
		$this->Session->setFlash(__('Send mail to Primary Care Provider'));
		}
		$sendMails['emailRecords']['id'][]=$data['Patient']['id']; */
		//	}
		//-----------------------------------------------------------EOF--------------------------------------
	}


	public function addBeforeClaim($patient_id=null,$id=null,$bProfile=null){
		//debug($bProfile);exit;
		/*$patient_id=$this->request->query['patientID'];		
		$id1=$this->request->query['id'];
		$bProfile=$this->request->query['Bprofile']; */
		$this->patient_info($patient_id);
		$this->uses = array('Encounter','BillingProfile','BillingOtherCode','SnomedMappingMaster','NdcMaster',
				'TariffList','State','NoteDiagnosis','NewCropPrescription','ProcedurePerform','Note');
		$this->set('patient_id',$patient_id);
		$this->set('id',$id); 	
		//********************************Note id for PDF****************************************************
		$noteId=$this->Note->find('first',array('conditions'=>array('patient_id'=>$patient_id),'fields'=>array('id'),'order'=>array('id'=> 'DESC')));
		//debug($noteId);
		$this->set('noteId',$noteId['Note']['id']);
		//*****************************************************************************************************
		$getstateInfo=$this->State->find('list',array('fields'=>array('id','name'),'order' => array('State.name'),'conditions'=>array('State.country_id'=>'2')));
	
		$this->set('getstateInfo',$getstateInfo);
		//$this->set('getModifiers',$getModifiers);
		// *********************Modifer****************************
		$getModifiers=$this->BillingOtherCode->find('all',array('fields'=>array('id','name'),'conditions'=>array('BillingOtherCode.status'=>'1')));
			$this->set('getModifiers',$getModifiers);
		//*********************EOF***********************************
		//**********************************ICD9 CODES***************************************************************************
		$getNoteDaignosis=$this->NoteDiagnosis->find('all',array('conditions'=>array('patient_id'=>$patient_id,'delete_for_claim'=>'0'),'fields'=>array('id','icd_id','diagnoses_name'),'group'=>array('NoteDiagnosis.icd_id')));
		//debug($getNoteDaignosis);exit;
		$this->set('icd_codes9',$getNoteDaignosis);
		//***********************************************************************************************************************
		//**********************************NDC CODES***************************************************************************
		
		$this->NewCropPrescription->bindModel(array(
				'belongsTo' => array(
						'NdcMaster' =>array( 'foreignKey'=>false,'conditions'=>array('NewCropPrescription.drug_id=NdcMaster.MEDID')),
				)),false);
		
		$getNewCropPrescription=$this->NewCropPrescription->find('all',array('conditions'=>array('patient_uniqueid'=>$patient_id,'delete_for_claim'=>'0'),
				'fields'=>array('NdcMaster.NDC','NdcMaster.MEDID','NdcMaster.LN','id'),'group'=>array('NdcMaster.MEDID')));
		$this->set('ncdCode',$getNewCropPrescription);
		
		//***********************************************************************************************************************
		//***********************************************CPT Codes*****************************************************************
		$this->ProcedurePerform->bindModel(array(
				'belongsTo' => array(
						'TariffList' =>array( 'foreignKey'=>false,'conditions'=>array('ProcedurePerform.snowmed_code=TariffList.cbt')),
						'TariffAmount' =>array( 'foreignKey'=>false,'conditions'=>array('TariffList.id=TariffAmount.tariff_list_id')),
				)),false);
		$getCPT=$this->ProcedurePerform->find('all',array('conditions'=>array('patient_id'=>$patient_id,'ProcedurePerform.code_type'=>'CPT','delete_for_claim'=>'0'),
				'fields'=>array('TariffList.price_for_private','TariffAmount.non_nabh_charges','ProcedurePerform.id','ProcedurePerform.procedure_name','ProcedurePerform.snowmed_code',
						'ProcedurePerform.modifier1','ProcedurePerform.modifier2','ProcedurePerform.modifier3','ProcedurePerform.modifier4')));
		$this->set('cptCode',$getCPT);
		//*************************************************************************************************************************
		//***********************************************HCPCS Codes*****************************************************************
		$this->ProcedurePerform->bindModel(array(
				'belongsTo' => array(
						'TariffList' =>array( 'foreignKey'=>false,'conditions'=>array('ProcedurePerform.snowmed_code=TariffList.cbt')),
						'TariffAmount' =>array( 'foreignKey'=>false,'conditions'=>array('TariffList.id=TariffAmount.tariff_list_id')),
				)),false);
		$getHCPCS=$this->ProcedurePerform->find('all',array('conditions'=>array('patient_id'=>$patient_id,'ProcedurePerform.code_type'=>'hcpcs','delete_for_claim'=>'0'),
				'fields'=>array('TariffList.price_for_private','TariffAmount.non_nabh_charges','ProcedurePerform.id','ProcedurePerform.procedure_name','ProcedurePerform.snowmed_code')));
		
		$this->set('hcpcsCode',$getHCPCS);
		//*************************************************************************************************************************
		if(!empty($this->request->data)){		
		//	debug($this->request->data);exit;
			$this->request->data['Encounter']['location_id']=$this->Session->read('locationid');
			$this->request->data['Encounter']['created_by']=$this->Session->read('userid');
			$this->request->data['Encounter']['created_time']=date('Y-m-d H:i:s');
			
			if(!empty($this->request->data['Encounter']['modifiers1'])){
				$this->request->data['Encounter']['modifiers1'] = implode(',',$this->request->data['Encounter']['modifiers1']);
			}if(!empty($this->request->data['Encounter']['modifiers2'])){
				$this->request->data['Encounter']['modifiers2'] = implode(',',$this->request->data['Encounter']['modifiers2']);
			}if(!empty($this->request->data['Encounter']['modifiers3'])){
				$this->request->data['Encounter']['modifiers3'] = implode(',',$this->request->data['Encounter']['modifiers3']);
			}if(!empty($this->request->data['Encounter']['modifiers4'])){
				$this->request->data['Encounter']['modifiers4'] = implode(',',$this->request->data['Encounter']['modifiers4']);
			}if(!empty($this->request->data['Encounter']['accident_clk'])){
				$this->request->data['Encounter']['accident_clk']= implode('|',$this->request->data['Encounter']['accident_clk']);
			}
		
			//edit icd9Code****--------------------------
			//debug($this->request->data);exit;
			if(!empty($this->request->data['Encounter']['icd9code'])){	
			//	debug($this->request->data['Encounter']['icd9code']);			
				$impldeIcd=implode(',',$this->request->data['Encounter']['icd9code']);
				//debug($impldeIcd); 
				$this->request->data['Encounter']['icd_codes']=$impldeIcd.','.$this->request->data['Encounter']['icd_codes'];
			}
		
			///////////////********************************************************************************************
			//edit ndcCode****--------------------------
		//	debug($this->request->data);exit;
			if(!empty($this->request->data['Encounter']['ndccode'])){
				$impldeNdc=implode(',',$this->request->data['Encounter']['ndccode']);			
			$this->request->data['Encounter']['ndc_codes']=$impldeNdc.','.$this->request->data['Encounter']['ndc_codes'];
			}
			//debug($this->request->data);exit;
			///////////////********************************************************************************************
			//edit apcCode****--------------------------
			
			if(!empty($this->request->data['Encounter']['apccode'])){
				$impldeApc=implode(',',$this->request->data['Encounter']['apccode']);			
			$this->request->data['Encounter']['apc_codes']=$impldeApc.','.$this->request->data['Encounter']['apc_codes'];
			}
			///////////////********************************************************************************************
			//edit apcCode****--------------------------
			if(!empty($this->request->data['Encounter']['hcpcscode'])){
				$impldehpcs=implode(',',$this->request->data['Encounter']['hcpcscode']);			
			$this->request->data['Encounter']['hcpcs_codes']=$impldehpcs.','.$this->request->data['Encounter']['hcpcs_codes'];
			}
			///////////////********************************************************************************************
			//edit CptCode****--------------------------
			if(!empty($this->request->data['Encounter']['cptcode'])){
				$impldeCpt=implode(',',$this->request->data['Encounter']['cptcode']);
			
			$this->request->data['Encounter']['cpt_codes']=$impldeCpt.','.$this->request->data['Encounter']['cpt_codes'];
			}
			if(!empty($this->request->data['Encounter']['modifiers1edit'])){
				$impldeM1edit=implode(',',$this->request->data['Encounter']['modifiers1edit']);
			
			$this->request->data['Encounter']['modifiers1']=$impldeM1edit.','.$this->request->data['Encounter']['modifiers1'];
			}
			if(!empty($this->request->data['Encounter']['modifiers2edit'])){
				$impldeM2edit=implode(',',$this->request->data['Encounter']['modifiers2edit']);
		
			$this->request->data['Encounter']['modifiers2']=$impldeM2edit.','.$this->request->data['Encounter']['modifiers2'];
			}
			if(!empty($this->request->data['Encounter']['modifiers3edit'])){
				$impldeM3edit=implode(',',$this->request->data['Encounter']['modifiers3edit']);
		
			$this->request->data['Encounter']['modifiers3']=$impldeM3edit.','.$this->request->data['Encounter']['modifiers3'];
			}
			if(!empty($this->request->data['Encounter']['modifiers4edit'])){
				$impldeM4edit=implode(',',$this->request->data['Encounter']['modifiers4edit']);
			
			$this->request->data['Encounter']['modifiers4']=$impldeM4edit.','.$this->request->data['Encounter']['modifiers4'];
			}
			///////////////********************************************************************************************
		//debug($this->request->data);exit;
			
			if ($this->Encounter->save($this->request->data)){		
				if(empty($this->request->data['Encounter']['id'])){
				$this->Session->setFlash(__('Encounter saved successfully'),true);
				}else{
					$this->Session->setFlash(__('Encounter updated successfully'),true);
				}
				$this->redirect(array('action'=>'claimManager',$patient_id)); //redirect to second form
			}else{
				$this->Session->setFlash('Unable to add your Encounter.');
			}
		}else{//**************** Edit Case***********************************
			$encounterData = $this->Encounter->find('first',array('conditions'=>array('Encounter.id'=>$id)));
			$this->set('encounterData',$encounterData);

			
			if(!empty($encounterData)){
				
				$encounterData['Encounter']['location_id']=$this->Session->read('locationid');
				$encounterData['Encounter']['modified_by']=$this->Session->read('userid');
				$encounterData['Encounter']['modified_time']=date('Y-m-d H:i:s');
				//**************To get Data for Icd9codes*******************************			
				$getBProfileInfo=$this->BillingProfile->find('first',array('conditions'=>array('BillingProfile.id'=>$bProfile)));
				$this->set('getBProfileInfo',$getBProfileInfo);
			
				if(!empty($encounterData['Encounter']['icd_codes']) || !empty($getBProfileInfo['BillingProfile']['icd_codes'])){
					if(!empty($encounterData['Encounter']['icd_codes'])){
					$expIcd9cides=explode(',',$encounterData['Encounter']['icd_codes']);
					}else{
					$expIcd9cides=explode(',',$getBProfileInfo['BillingProfile']['icd_codes']);
					}				
				/*set::filter($expIcd9cides);
					if(empty($expIcd9cides['0']))
					unset($expIcd9cides['0']);*/
					//debug($expIcd9cides);///exit;
					$getIcdData=$this->SnomedMappingMaster->find('all',array('conditions'=>array('SnomedMappingMaster.icd9code'=>$expIcd9cides),'fields'=>array('icd9name','icd9code','id'),'group' => 'icd9code'));
					//pr($getIcdData);exit;				
					$this->set('getIcdData',$getIcdData);
				}
				//**********************************************************************
				//**************To get Data for Ndccodes*******************************
				if(!empty($encounterData['Encounter']['ndc_codes']) || !empty($getBProfileInfo['BillingProfile']['ndc_codes'])){
					if(!empty($encounterData['Encounter']['ndc_codes'])){
						$expNdccides=explode(',',$encounterData['Encounter']['ndc_codes']);
					}else{
						$expNdccides=explode(',',$getBProfileInfo['BillingProfile']['ndc_codes']);
					}
					//$expNdccides=explode(',',$encounterData['Encounter']['ndc_codes']);
				/*	set::filter($expNdccides);
					if(empty($expNdccides['0']))
						unset($expNdccides['0']);*/
					$getncdDetails = $this->NdcMaster->find('all',array('conditions'=>array('NdcMaster.NDC'=>$expNdccides),'fields'=>array('LN','NDC','LN60','MEDID','id')));
					$this->set('getncdDetails',$getncdDetails);
				}
				//**********************************************************************
				//**************To get Data for Apccodes*******************************			
				if(!empty($encounterData['Encounter']['apc_codes'])){					
					$expApccides=explode(',',$encounterData['Encounter']['apc_codes']);
				/*	set::filter($expApccides);
					if(empty($expApccides['0']))
						unset($expApccides['0']);*/
					$getapcsDetails = $this->TariffList->find('all',array('conditions'=>array('TariffList.apc'=>$expApccides),'fields'=>array('name','short_name','apc','price_for_private')));
					$this->set('getapcsDetails',$getapcsDetails);
				}
				//**********************************************************************
				//**************To get Data for HCPCScodes*******************************
				if(!empty($encounterData['Encounter']['hcpcs_codes'])){
					$exphcpcscides=explode(',',$encounterData['Encounter']['hcpcs_codes']);
				/*	set::filter($exphcpcscides);
					if(empty($exphcpcscides['0']))
						unset($exphcpcscides['0']);*/
					$hcpsDetails = $this->TariffList->find('all',array('conditions'=>array('TariffList.hcpcs'=>$exphcpcscides),'fields'=>array('name','hcpcs','price_for_private')));
					$this->set('hcpsDetails',$hcpsDetails);
				}
				//**********************************************************************
				//**************To get Data for Cptcodes*******************************
				$this->TariffList->bindModel(array(
						'belongsTo'=>array(
								'Encounter'=>array('foreignKey'=>false,'conditions'=>array('TariffList.cbt=Encounter.cpt_codes')))));
				if(!empty($encounterData['Encounter']['cpt_codes'])){
					$expCptcides=explode(',',$encounterData['Encounter']['cpt_codes']);
					/*set::filter($expCptcides);
					if(empty($expCptcides['0']))
						unset($expCptcides['0']);*/
					$getcptDetails = $this->TariffList->find('all',array('conditions'=>array('TariffList.cbt'=>$expCptcides),'fields'=>array('name','cbt','price_for_private','Encounter.modifiers1','Encounter.modifiers2','Encounter.modifiers3','Encounter.modifiers4')));
					$this->set('getcptDetails',$getcptDetails);
				}
				//**********************************************************************
			}
			$this->data = $encounterData;
			///debug($this->data);exit;
			
		}//****************EOF***********************************
	}
	public function billingProfile(){
		ob_end_clean();
		ob_start("ob_gzhandler");
		$this->uses = array('BillingProfile','User','BillingOtherCode');
		$this->layout ="ajax" ;
		$getUserInfo=$this->User->find('first',array('conditions'=>array('User.id'=>$this->Session->read('userid'))));
		// Modifer
		$getModifiers=$this->BillingOtherCode->find('all',array('conditions'=>array('BillingOtherCode.status'=>'1')));
		//EOF
		if(!empty($this->request->data)){
			$this->request->data['BillingProfile']['location_id']=$this->Session->read('locationid');
			$this->request->data['BillingProfile']['created_by']=$this->Session->read('userid');
			$this->request->data['BillingProfile']['created_time']=date('Y-m-d H:i:s');
			//debug($this->request->data);exit;
			if(!empty($this->request->data['BillingProfile']['modifiers1'])){
				$this->request->data['BillingProfile']['modifiers1'] = implode(',',$this->request->data['BillingProfile']['modifiers1']);
			}if(!empty($this->request->data['BillingProfile']['modifiers2'])){
				$this->request->data['BillingProfile']['modifiers2'] = implode(',',$this->request->data['BillingProfile']['modifiers2']);
			}if(!empty($this->request->data['BillingProfile']['modifiers3'])){
				$this->request->data['BillingProfile']['modifiers3'] = implode(',',$this->request->data['BillingProfile']['modifiers3']);
			}if(!empty($this->request->data['BillingProfile']['modifiers4'])){
				$this->request->data['BillingProfile']['modifiers4'] = implode(',',$this->request->data['BillingProfile']['modifiers4']);
			}
		//debug($this->request->data);exit;
			if($this->BillingProfile->save($this->request->data)){
				$this->set('setFlash',1);
				$this->Session->setFlash(__('Profile saved successfully'),true);
			}else{$this->Session->setFlash('Unable to add your Profile.');
			}
		}else{
			$billingProfileData = $this->BillingProfile->find('first',array('conditions'=>array('BillingProfile.id'=>$id)));
			if(!empty($billingProfileData)){
				$billingProfileData['BillingProfile']['location_id']=$this->Session->read('locationid');
				$billingProfileData['BillingProfile']['modified_by']=$this->Session->read('userid');
				$billingProfileData['BillingProfile']['modified_time']=date('Y-m-d H:i:s');
				$this->set('billingProfileData',$billingProfileData);
			}$this->data = $billingProfileData;
		}
		$this->set(compact('getUserInfo','getModifiers'));
	}

	public function deleteCode($modelName,$code,$patient_id){
		$this->uses=array('Encounter');
		//debug($modelName);exit;
		if($modelName=='icd'){
			//debug('hifg');exit;
			$getIcdCode=$this->Encounter->find('all',array('fields'=>array('icd_codes'),'conditions'=>array('patient_id'=>$patient_id)));
			$expCode=explode(',',$getIcdCode['0']['Encounter']['icd_codes']);
			for($i=0;$i<count($expCode);$i++){
				if($i==$code){
					unset ($expCode[$i]);
				}
			}
			$implode_codes=implode(',',$expCode);
			$getIcdCode=$this->Encounter->updateAll(array('icd_codes'=>"'".$implode_codes."'"),array('patient_id'=>$patient_id));
			exit;
		}else if($modelName=='ndc'){
			$getNdcCode=$this->Encounter->find('all',array('fields'=>array('ndc_codes'),'conditions'=>array('patient_id'=>$patient_id)));
			$expNdcCode=explode(',',$getNdcCode['0']['Encounter']['ndc_codes']);
			for($i=0;$i<count($expNdcCode);$i++){
				if($i==$code){
					unset ($expNdcCode[$i]);
				}
			}
			$implode_ndccodes=implode(',',$expNdcCode);
			$getNdcCode=$this->Encounter->updateAll(array('ndc_codes'=>"'".$implode_ndccodes."'"),array('patient_id'=>$patient_id));
			exit;
		}else if($modelName=='apc'){
			$getApcCode=$this->Encounter->find('all',array('fields'=>array('apc_codes'),'conditions'=>array('patient_id'=>$patient_id)));
			$expApcCode=explode(',',$getApcCode['0']['Encounter']['apc_codes']);
			for($i=0;$i<count($expApcCode);$i++){
				if($i==$code){
					unset ($expApcCode[$i]);
				}
			}
			$implode_apccodes=implode(',',$expApcCode);
			$getApcCode=$this->Encounter->updateAll(array('apc_codes'=>"'".$implode_apccodes."'"),array('patient_id'=>$patient_id));
			exit;
		}else if($modelName=='hcpcs'){
			$getHcpcsCode=$this->Encounter->find('all',array('fields'=>array('hcpcs_codes'),'conditions'=>array('patient_id'=>$patient_id)));
			$expHcpcsCode=explode(',',$getHcpcsCode['0']['Encounter']['hcpcs_codes']);
			for($i=0;$i<count($expHcpcsCode);$i++){
				if($i==$code){
					unset ($expHcpcsCode[$i]);
				}
			}
			$implode_hcpcscodes=implode(',',$expHcpcsCode);
			$getHcpcsCode=$this->Encounter->updateAll(array('hcpcs_codes'=>"'".$implode_hcpcscodes."'"),array('patient_id'=>$patient_id));
			exit;
		}else if($modelName=='cpt'){
			$getCptCode=$this->Encounter->find('all',array('fields'=>array('cpt_codes'),'conditions'=>array('patient_id'=>$patient_id)));
			$expCptCode=explode(',',$getCptCode['0']['Encounter']['cpt_codes']);
			for($i=0;$i<count($expCptCode);$i++){
				if($i==$code){
					unset ($expCptCode[$i]);
				}
			}
			$implode_cptcodes=implode(',',$expCptCode);
			$getCptCode=$this->Encounter->updateAll(array('cpt_codes'=>"'".$implode_cptcodes."'"),array('patient_id'=>$patient_id));
			exit;
		}
		else if($modelName=='noteDiagnosis'){
			$this->uses=array('NoteDiagnosis');
			$this->NoteDiagnosis->updateAll(array('delete_for_claim'=>'1'),array('id'=>$code));
			exit;
		}
		else if($modelName=='newcrop_prescription'){
			$this->uses=array('NewCropPrescription');
			$this->NewCropPrescription->updateAll(array('delete_for_claim'=>'1'),array('id'=>$code));
			exit;
		}
		else if($modelName=='procedure_perform'){
			$this->uses=array('ProcedurePerform');
			$this->ProcedurePerform->updateAll(array('delete_for_claim'=>'1'),array('id'=>$code));
			exit;
		}
		else{

		}

	}

	///EOF-Encounters/////////////////////////////////////////////////////////////////////////////////////////////////////

	//********************
	/* Search for cpt code for billing Aditya V. Chitmitwar */
	//********************
	public function icdSearch($code,$chkByName=null){
		$this->layout = 'ajax';
		$this->uses = array('SnomedMappingMaster');
		if(empty($chkByName)){	
			$icdDetails = $this->SnomedMappingMaster->find('first',array('conditions'=>array('SnomedMappingMaster.icd9code'=>$code),'fields'=>array('icdName','icd9code')));
			$name=$icdDetails['SnomedMappingMaster']['icdName'];
			$icd=$icdDetails['SnomedMappingMaster']['icd9code'];
			//=$apcsDetails['Samplea']['price'];			
			echo json_encode(array('name'=>$name,'code'=>$icd));exit;
		}else{
			$this->uses = array('TariffList');
			$apcsDetails = $this->TariffList->find('first',array('conditions'=>array('TariffList.name Like'=>$code.'%')));
			$name=$apcsDetails['TariffList']['name'];
			$apc=$apcsDetails['TariffList']['apc'];
			$price=$apcsDetails['TariffList']['price_for_private'];
			//=$apcsDetails['Samplea']['price'];
			echo json_encode(array('name'=>$name,'code'=>$apc,'price'=>$price));exit;
		}
	}
	public function ndcSearch($code,$chkByName=null){
		$this->layout = 'ajax';
		$this->uses = array('NdcMaster');
		if(empty($chkByName)){
			$ncdDetails = $this->NdcMaster->find('first',array('conditions'=>array('NdcMaster.NDC'=>$code),'fields'=>array('LN','NDC','LN60','MEDID')));
			$name=$ncdDetails['NdcMaster']['LN'];
			$ncd=$ncdDetails['NdcMaster']['NDC'];
			$medid=$ncdDetails['NdcMaster']['MEDID'];
			//=$apcsDetails['Samplea']['price'];
			echo json_encode(array('name'=>$name,'code'=>$ncd,'medid'=>$medid));exit;
		}
		/* if check by name is required use the below code -Aditya
		 * else{
		$this->uses = array('NdcMaster');
		$ncdDetails = $this->NdcMaster->find('first',array('conditions'=>array('NdcMaster.LN'=>$code),'fields'=>array('LN','NDC','LN60','MEDID')));
		$name=$ncdDetails['NdcMaster']['LN'];
		$ncd=$ncdDetails['NdcMaster']['NDC'];
		$medid=$ncdDetails['NdcMaster']['MEDID'];
		//=$apcsDetails['Samplea']['price'];
		echo json_encode(array('name'=>$name,'code'=>$ncd,'medid'=>$medid));exit;

		} */
	}
	public function apcsSearch($code,$chkByName=null){
		$this->layout = 'ajax';
		$this->uses = array('TariffList');
		if(empty($chkByName)){
			$apcsDetails = $this->TariffList->find('first',array('conditions'=>array('TariffList.apc'=>$code),'fields'=>array('name','short_name','apc','price_for_private')));
			$name=$apcsDetails['TariffList']['name'];
			$apc=$apcsDetails['TariffList']['apc'];
			$price=$apcsDetails['TariffList']['price_for_private'];
			//=$apcsDetails['Samplea']['price'];
			echo json_encode(array('name'=>$name,'code'=>$apc,'price'=>$price));exit;
		}
		else{
			$this->uses = array('TariffList');
			$apcsDetails = $this->TariffList->find('first',array('conditions'=>array('TariffList.name Like'=>$code.'%')));
			$name=$apcsDetails['TariffList']['name'];
			$apc=$apcsDetails['TariffList']['apc'];
			$price=$apcsDetails['TariffList']['price_for_private'];
			//=$apcsDetails['Samplea']['price'];
			echo json_encode(array('name'=>$name,'code'=>$apc,'price'=>$price));exit;

		}
	}
	public function hcpcsSearch($code,$chkByName=null){
		$this->layout = 'ajax';
		$this->uses = array('TariffList');
		if(empty($chkByName)){
			$hcpsDetails = $this->TariffList->find('first',array('conditions'=>array('TariffList.hcpcs'=>$code)));
			$name=$hcpsDetails['TariffList']['name'];
			$code=$hcpsDetails['TariffList']['hcpcs'];
			$price=$hcpsDetails['TariffList']['price'];
			echo json_encode(array('name'=>$name,'code'=>$code,'price'=>$price));exit;
		}
		else{
			$hcpsDetails = $this->TariffList->find('first',array('conditions'=>array('TariffList.name Like'=>$code.'%')));
			$name=$hcpsDetails['TariffList']['name'];
			$code=$hcpsDetails['TariffList']['hcpcs'];
			$price=$hcpsDetails['TariffList']['price'];
			echo json_encode(array('name'=>$name,'code'=>$code,'price'=>$price));exit;
		}
	}

	public function searchCpt($code){
		$this->layout = 'ajax';
		$this->uses = array('TariffList');
		$apcsDetails = $this->TariffList->find('first',array('conditions'=>array('TariffList.name Like'=>"%".$code),'fields'=>array('name','cbt','price_for_private')));
		$name=$apcsDetails['TariffList']['name'];
		$cbt=$apcsDetails['TariffList']['cbt'];
		$price=$apcsDetails['TariffList']['price_for_private'];
		echo json_encode(array('name'=>$name,'code'=>$cbt,'price'=>$price));exit;
	}
	// EOF

	//BOF Services for inpatient-Pooja
	public function getIcdServices($patientId = null){
		$this->loadModel('ServiceBill');
		$this->ServiceBill->bindModel(array(
				'belongsTo' => array(
						'Icd10pcMaster' =>array( 'foreignKey'=>false,'conditions'=>array('ServiceBill.tariff_list_id=Icd10pcMaster.id')),
				)),false);

		$icd10Services = $this->ServiceBill->find('all',array('fields'=>array('COUNT(*) AS recordcount','Icd10pcMaster.*'),
				'conditions'=>array('ServiceBill.patient_id'=>$patientId,
						'ServiceBill.location_id'=>$this->Session->read('locationid')),'group'=>'Icd10pcMaster.id'));

		return $icd10Services;
	}
	//EOF Services
	//BOF Denial managment-Pooja
	public function denial_managment($id=null,$rowId=null)
	{
		$this->uses = array('Patient','TariffStandard','FinalBilling','NoteDiagnosis','ClaimTransaction');
		$this->layout = false;

		$this->Patient->unBindModel(array('belongsTo' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id')),
						'FinalBilling' =>array('foreignKey' => false,'conditions'=>array('FinalBilling.patient_id=Patient.id')),
						'TariffStandard' =>array('foreignKey' => 'tariff_standard_id'),

				),
				/*'hasMany' => array(
				 'Billing' =>array('foreignKey' => 'patient_id'),
				),*/
		),false);
		$conditions = array('Patient.location_id'=>$this->Session->read('locationid'),'Patient.id'=>$id);
		$patientData = $this->Patient->find('all',array('fields'=>array('Patient.lookup_name','Patient.form_received_on','User.first_name','User.last_name',
				'FinalBilling.*','TariffStandard.name','Patient.admission_id','Patient.admission_type'),
				'conditions'=> $conditions
		));
		$tariffStandards = $this->TariffStandard->find('list',array('fields'=>array('id','name'),'conditions'=>array('location_id'=>$this->Session->read('locationid'),
				'is_deleted' =>'0'
		)));
		/***************************** Services For IPD patients******************************/

		if($patientData[0]['Patient']['admission_type'] == 'IPD'){
			$servicesData  = $this->getIcdServices($id);
			$this->set('servicesData',$servicesData);
		}
		/***************************** Services For IPD patients Ends*************************/
		/***************************** Diagnosis ******************************/
		$diagnosis=$this->NoteDiagnosis->find('all',array('fields'=>array('NoteDiagnosis.icd_id','NoteDiagnosis.diagnoses_name'),'conditions'=>array('NoteDiagnosis.patient_id'=>$id)));
		/***************************** Diagnosis Ends*************************/

		/***************************** Transcation Details*************************/
		$details=$this->ClaimTransaction->find('all',array('conditions'=>array('ClaimTransaction.patient_id'=>$id,'ClaimTransaction.is_deleted'=>'0')));

		$this->set('diagnosis',$diagnosis);
		$this->set('details',$details);
		$this->set('patientData',$patientData);
		$this->set('currency',$this->Session->read('Currency.currency_symbol'));
		$this->set('tariffStandards',$tariffStandards);

	}

	/**
	 *
	 * @param unknown_type $claimTransactionId
	 */
	function deleteTransaction($claimTransactionId){
		$this->uses = array('ClaimTransaction');
		if($claimTransactionId){
			$this->ClaimTransaction->save(array('id'=>$claimTransactionId,'is_deleted'=>'1'));
			echo $claimTransactionId;
		}exit;
	}

	/**
	 * editErrorManagement
	 * @author Gaurav Chauriya
	 * @copyright DrM Hope Softwares
	 *
	 */
	public function editErrorManagement(){
		ob_end_clean();
		ob_start("ob_gzhandler");
		$this->layout = 'advance' ;
		$this->uses = array('Patient','TariffStandard','Location','User');
		$this->Patient->unBindModel(array('belongsTo' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id')),
						'FinalBilling' =>array('foreignKey' => false,'conditions'=>array('FinalBilling.patient_id=Patient.id')),
						'TariffStandard' =>array('foreignKey' => 'tariff_standard_id'),
						'MedicalCoder' =>array('className'=>'User','foreignKey' => false,'conditions'=>array('MedicalCoder.id=FinalBilling.assigned_coder'))
				)),false);
		$id = 85;
		$this->patient_info($id);
		if($this->request->data){
			$this->request->data = $this->request->data['Billing'];
			if(!empty($this->request->data['service_date'])){
				$serviceDate = trim($this->DateFormat->formatDate2STD(trim($this->request->data['service_date']),Configure::read('date_format')));
				$serviceDate = explode(" ",$serviceDate);
				if(count($serviceDate) > 1)
					$serviceDate = $serviceDate[0];
				$conditions['Patient.form_received_on like'] = "$serviceDate%";
			}
			if(!empty($this->request->data['patient_id']))
				$conditions['Patient.patient_id'] = $this->request->data['patient_id'];

			if(!empty($this->request->data['lookup_name']))
				$conditions['Patient.lookup_name'] = $this->request->data['lookup_name'];

			if(!empty($this->request->data['doctor_id']))
				$conditions['Patient.doctor_id'] = $this->request->data['doctor_id'];

			if(!empty($this->request->data['tariff_standard_id']))
				$conditions['Patient.tariff_standard_id'] = $this->request->data['tariff_standard_id'];

			if(!empty($this->request->data['location_id']))
				$conditions['Patient.location_id'] = $this->request->data['location_id'];

			if(!empty($this->request->data['claim_status']))
				$conditions['FinalBilling.claim_status'] = $this->request->data['claim_status'];

			if(!empty($this->request->data['assigned_coder']))
				$conditions['FinalBilling.assigned_coder'] = $this->request->data['assigned_coder'];

			$andConditions['FinalBilling.claim_status !='] = 'ERA Received';
			if(!empty($conditions))
				$conditions = array('OR'=>$conditions,$andConditions);
			else{
				$conditions = array('Patient.location_id'=>$this->Session->read('locationid'),'FinalBilling.claim_status !=' =>'ERA Received');
			}
		}else{
			$conditions = array('Patient.location_id'=>$this->Session->read('locationid'),'FinalBilling.claim_status !=' =>'ERA Received');
		}
		$patientData = $this->Patient->find('all',array('fields'=>array('Patient.lookup_name','Patient.patient_id','Patient.form_received_on',
				'User.first_name','User.last_name','MedicalCoder.id','MedicalCoder.first_name','MedicalCoder.last_name','FinalBilling.*','TariffStandard.name'),
				'conditions'=> $conditions));
		$tariffStandards = $this->TariffStandard->find('list',array('fields'=>array('id','name'),
				'conditions'=>array('location_id'=>$this->Session->read('locationid'),'is_deleted' =>'0')));
		/*$locations = $this->Location->find('list',array('fields'=>array('id','name'),
		 array('conditions'=>array('is_deleted' => '0','is_active'=>'1'))));*/
		$this->set(compact('tariffStandards','patientData'));
		$this->set('medicalCoder',$this->User->getMedicalCoder());
	}
	/**
	 * claimFollowp
	 *  @author Gaurav Chauriya
	 *  for maintaining followup for coders
	 */
	function claimFollowp($patientId,$finalBillId = null){
		$this->layout = 'ajax';
		$this->uses = array('DumpNote');
		if($this->request->data){
			$this->request->data['claimFollowp']['note'] = serialize($this->request->data['claimFollowp']);
			$this->request->data['claimFollowp']['patient_id'] = $patientId;
			$this->request->data['claimFollowp']['note_tag'] = 'claimFollowp';
			$this->request->data['claimFollowp']['tag_source_id'] = $finalBillId;
			$this->request->data['claimFollowp']['created_by'] = $this->Session->read('userid');
			$this->request->data['claimFollowp']['create_time'] = date('Y-m-d H:i:s');
			$this->DumpNote->saveAll($this->request->data['claimFollowp']);
			$this->set('recordSaved',true);
		}
		$this->set(compact('patientId','finalBillId'));
	}

	/**
	 *  ajax function assignCoder
	 *  @author Gaurav Chauriya
	 */
	function assignCoder(){
		$this->layout = 'ajax';
		$this->uses = array('FinalBilling');
		$this->FinalBilling->saveAll($this->request->data['FinalBilling']);
		exit;
	}

	/**
	 * autoAssignManagement
	 * Smartly assigning claims to coder
	 * @author Gaurav Chauriya
	 */
	function autoAssignManagement(){
		//$this->layout = 'ajax';
		$this->uses = array('FinalBilling');
		$data = $this->FinalBilling->find('list',array('fields'=>array('id'),
				'conditions'=>array('assigned_coder'=>'','claim_status NOT'=>array('','ERA Received'),'location_id'=>$this->Session->read('locationid'))));
		if($data){

			function partition( $list, $p ) {
				$listlen = count( $list );
				$partlen = floor( $listlen / $p );
				$partrem = $listlen % $p;
				$partition = array();
				$mark = 0;
				for ($px = 0; $px < $p; $px++) {
					$incr = ( $px < $partrem ) ? $partlen + 1 : $partlen;
					$partition[ $px ] = array_slice( $list, $mark, $incr );
					$mark += $incr;
				}
				return $partition;
			}
			$coderList = array_keys( unserialize( $this->request->data['coder'] ) );
			$totalCoders = count( $coderList );
			$partition = partition( $data, $totalCoders );
			$cnt = 0;
			foreach( $partition as $finalAray ){
				$inerCnt = 0;
				for($i = 0; $i < count( $finalAray ); $i++){
					$finalArray[ $cnt ][ 'FinalBilling' ][ $inerCnt ][ 'id' ] = $finalAray[ $i ];
					$finalArray[ $cnt ][ 'FinalBilling' ][ $inerCnt ][ 'assigned_coder' ] = $coderList[ $cnt ];
					$inerCnt++;
				}
				$this->FinalBilling->saveAll( $finalArray[ $cnt ][ 'FinalBilling' ] );
				$cnt++;
			}
			$this->Session->setFlash(__(count($data) ." Claims Assigned Sucessfully"),true);
		}else{
			$this->Session->setFlash(__('No Claims Left Unassigned'),true);
		}
		exit;
	}

	public function workflow(){

	}

	//Pankaj M

	public function generateClaim($id=null,$claimtype=null,$payer_selected_id=null,$claim_id=null,$insuranceFileId=null,$count=null){
		$this->autoRender=false;
		//$payer_selected_id="60";
		//$claimNumber="1";
		$ST2=str_pad($claim_id, 9, '0', STR_PAD_LEFT);//9 digit number required : Generated from claim id
		$groupControlNumber=str_pad(rand(10,100).$id, 9, '0', STR_PAD_RIGHT);//Generated from random function and patient id
		//$groupControlNumber=str_pad(date("Ymd"), 9, '0', STR_PAD_RIGHT);//Generated from random function and patient id
		$isaseg13=str_pad(date("Ymd"), 9, '0', STR_PAD_LEFT);//Generated from claim id, patient id and payer selected id : 9 digit number required


		$this->uses = array('Insurance','Location','City','State','Country','Patient','Person','NewInsurance','TariffStandard','Encounter','TariffList','TariffAmount','ProcedurePerform','NoteDiagnosis');
		if($claimtype==1500)
		{
			$controlVersionNumber="00501"; //Interchange control Version Number
			$controlNumber="005010X222A1"; //Interchange control Number  //004010X098A1
		}
		else
		{
			$controlVersionNumber="00401"; //Interchange control Version Number
			$controlNumber="005010X222"; //Interchange control Number
		}
		$zirmed_client_accountid=Configure::read('zirmed_client_accountid')."          ";//length 15 followed by spaces
		$currentdate=date("Ymd");
		$currentdate_ISA=date("ymd");
		$currentTime=date("Hi", time());
		$ackrequest=1;//value can be 0 or 1
		$bht_transactionset_purposecode="00";//value can be 00 - Original, 18 - Reissue
		$bht_reference_identification="Drm".$claim_id.$id.time().$claimtype;//still not clear
		$taxanomy_code="282E00000X";





		//find claim data from encounter table
		$claim_encounter = $this->Encounter->find('first', array('conditions'=>array('Encounter.id'=>$claim_id)));
		//debug($claim_encounter);

		$totalClaimAmount=$claim_encounter["[Encounter"]["payment_amount"]; //Calculated from SUM (charge*units)
		
		$totalClaimAmount="1000";

		//find place
		//$placeOfService=$claim_encounter["[Encounter"]["place_of_facility"];
		$placeOfService="21";

		//find hospital location, state, city
		$hospital_location = $this->Location->find('first', array('fields'=> array('Location.id', 'Location.name','Location.address1','Location.address2','Location.zipcode','Location.city_id','Location.state_id','Location.country_id','Location.phone1','Location.mobile','Location.fax','Location.hospital_npi','Location.hospital_service_tax_no'),'conditions'=>array('Location.id'=>$this->Session->read('locationid'), 'Location.is_active' => 1, 'Location.is_deleted' => 0)));

		$city_location = $this->City->find('first', array('fields'=> array('City.name'),'conditions'=>array('City.id'=>$hospital_location['Location']['city_id'])));

		$state_location = $this->State->find('first', array('fields'=> array('State.state_code'),'conditions'=>array('State.id'=>$hospital_location["Location"]["state_id"])));

		$country_location = $this->Country->find('first', array('fields'=> array('Country.name'),'conditions'=>array('Country.id'=>$hospital_location['Location']['country_id'])));

		$this->Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));

		$UIDpatient_details  = $this->Person->getUIDPatientDetailsByPatientID($id);
		
		$this->loadModel("Facility");
		$this->Facility->unBindModel(array(
				'hasOne'=>array('FacilityDatabaseMapping','FacilityUserMapping')
		));
		
		$facility = $this->Facility->find('first', array('fields'=> array('Facility.id','Facility.name','Facility.address1','Facility.zipcode','Facility.city_id','Facility.state_id'),'conditions'=>array('Facility.is_deleted' => 0, 'Facility.is_active' => 1,'Facility.id' => $this->Session->read("facilityid"))));
		
		$city_facility = $this->City->find('first', array('fields'=> array('City.name'),'conditions'=>array('City.id'=>$facility['Facility']['city_id'])));
		
		$state_facility = $this->State->find('first', array('fields'=> array('State.state_code'),'conditions'=>array('State.id'=>$facility["Facility"]["state_id"])));
		

		//find subscriber country

		$subscriber_countryname = $this->Country->find('first', array('fields'=> array('Country.name'),'conditions'=>array('Country.id'=>$UIDpatient_details['Person']['country'])));
		//subscriber Sex
		$gender=$UIDpatient_details['Person']['sex'];
		if($gender=='Male' or $gender=='M')
			$gendervalue="M";
		else
			$gendervalue="F";

		$patientdob=str_replace("-", "", $UIDpatient_details["Person"]["dob"]);//CCYYMMDD format required


		//debug($UIDpatient_details);


		//find payer information of claim from tariff_standards table
		$payer_details = $this->TariffStandard->find('first', array('fields'=> array('TariffStandard.name','TariffStandard.payer_id','TariffStandard.professional_claims','TariffStandard.institutional_claims','TariffStandard.remits','TariffStandard.eligibility','TariffStandard.claim_status_zirmed','TariffStandard.plot_no','TariffStandard.landmark','TariffStandard.pin_code','TariffStandard.city','TariffStandard.state','TariffStandard.country'),'conditions'=>array('TariffStandard.id'=>$payer_selected_id)));
		//find insurance detail from new_insurances table for patient
		$patient_insurance_details = $this->NewInsurance->find('first', array('fields'=> array('NewInsurance.priority','NewInsurance.relation'),'conditions'=>array('NewInsurance.tariff_standard_id'=>$payer_selected_id,'NewInsurance.patient_id'=>$id)));
		//Generate header array
		$data['ISA']=array("00","          ","00","          ","ZZ",$zirmed_client_accountid,"ZZ",Configure::read('receiver_id')."         ",$currentdate_ISA,$currentTime,"^",$controlVersionNumber,$isaseg13,"1",Configure::read('zirmed_mode'),":");
		$data['GS']=array("HC",trim($zirmed_client_accountid),Configure::read('receiver_id'),$currentdate,$currentTime,$groupControlNumber,"X",$controlNumber);
		$data['ST']=array("837",$ST2,$controlNumber);
		$data['BHT']=array("0019",$bht_transactionset_purposecode,$bht_reference_identification,$currentdate,$currentTime,"CH");
		//$data['REF']=array("87",$controlNumber);

		//generate loop array
		//NM1 SEGMENT EXAMPLE: NM1*41*2*HOSPITAL NAME*****46*HT0000214-002~ :: PER SEGMENT EXAMPLE: PER*IC*JANE DOE*TE*9005555555~
		$loop['1000A']=array("NM1"=>array("41","2",Configure::read('zirmed_client_accountname'),"","","","","46",trim($zirmed_client_accountid)),
				"PER"=>array("IC",Configure::read('zirmed_contact_person'),"EM",Configure::read('zirmed_contact_email')));

		//for 1 claim
		//NM1 SEGMENT EXAMPLE: NM1*40*2*EMIA*****46*HT0000214-001~ ::
		$loop['1000B']=array("NM1"=>array("40","2",Configure::read('receiver_id'),"","","","","46",Configure::read('receiver_id')));
		//HL SEGMENT EXAMPLE: HL*1**20*1~ :: PRV SEGMENT EXAMPLE: PRV*PT*ZZ*1223G0001X~  taxanomy code not clear for last paramater
		$loop['2000A']=array("HL"=>array("1","","20","1"));//,"PRV"=>array("BI","ZZ",$taxanomy_code) -- 1	Code Value 'data at 2000A.PRV' at element '2000A.PRV' is valid in the X12 standard, but not in this HIPAA implementation

		$country_location["Country"]["name"]="US";
		//$hospital_location["Location"]["zipcode"]="123456789";//nine digit zip is required..need to check

		//payer details loop
		//$loop['2100A']=array("NM1"=>array("PR","2",$payer_details["TariffStandard"]["name"],"","","","","PI",$payer_details["TariffStandard"]["payer_id"]));

		//NM1 SEGMENT EXAMPLE: NM1*85*2*MY INSITUTION****XX*1234567890~ :: N3 SEGMENT EXAMPLE: N3*123 MAIN ST~ :: N4 SEGMENT EXAMPLE: N4*ANYTOWN*KY*12345~
		//REF SEGMENT EXAMPLE: REF*SY*123456789~ :: REF SEGMENT EXAMPLE: REF*G2*123456789ABC~ :: REF SEGMENT EXAMPLE: REF*E1*123456~  -- needs to research on REF first segment
		$loop['2010AA']=array("NM1"=>array("85","2",Configure::read('zirmed_client_accountname'),"","","","","XX",$hospital_location["Location"]["hospital_npi"]),
				"N3"=>array($hospital_location["Location"]["address1"]),
				"N4"=>array($city_location["City"]["name"],$state_location["State"]["state_code"],$hospital_location["Location"]["zipcode"]."0000"),
				"REF"=>array("EI",$hospital_location["Location"]["hospital_service_tax_no"])
		);

		/*$loop['2010AB']=array("NM1"=>array("85","2",Configure::read('zirmed_client_accountname'),"","","","","XX",Configure::read('receiver_id')),
		 "N3"=>array($hospital_location["Location"]["address1"]),
				"N4"=>array($city_location["City"]["name"],$state_location["State"]["state_code"],$hospital_location["Location"]["zipcode"],$country_location["Country"]["name"]),
				"REF"=>array("1C",$hospital_location["Location"]["id"])
		);*/

		//"PER"=>array()
		//HL SEGMENT EXAMPLE: HL*2*1*22*1~ :: SBR SEGMENT EXAMPLE: SBR*P**EMIARXD***6***CI~  :: HL segment 1 and 2 are not clear. 2 and 1 values are enetered
		//HL - 4th segment will caontian 0 if isnurance is self and 1 for other

		if($patient_insurance_details["NewInsurance"]["relation"]=="self")
		{
			$HL4seg = "0";
		}
		else
		{
			$HL4seg = "1";
		}
		$loop['2000B']=array("HL"=>array("2","1","22",$HL4seg),"SBR"=>array("P","18","","","","","","","BL"));
		//on 2000B loop N3, n4, DMG is reuired if patient is self insurance
		//end of 1 claim

		//NM1 SEGMENT EXAMPLE: NM1*IL*1*SMITH*JOHN****MI*12345678901~ :: N3 SEGMENT EXAMPLE: N3*123 Main Street~ :: N4 SEGMENT EXAMPLE: N4*Anytown*KY* 1234567890~
		//DMG SEGMENT EXAMPLE: DMG*D8*19470531*M~    :::: NM09 is not clear. Patient ID is put here for now  :: "REF"=>array() - REF is not clear in this loop wether to keep or not

		$UIDpatient_details["Person"]["city"]="Austin";
		$UIDpatient_details["Person"]["state"]="TX";

		$loop['2010BA']=array("NM1"=>array("IL", "1",trim($UIDpatient_details["Person"]["last_name"]),trim($UIDpatient_details["Person"]["first_name"]),trim($UIDpatient_details["Person"]["middle_name"]),"","","MI",trim($UIDpatient_details["Patient"]["patient_id"])),
				"N3"=>array($UIDpatient_details["Person"]["plot_no"]),
				"N4"=>array($UIDpatient_details["Person"]["city"],$UIDpatient_details["Person"]["state"],$UIDpatient_details["Person"]["pin_code"]),
				"DMG"=>array("D8",$patientdob,$gendervalue)
		);

		//2010BA-,$UIDpatient_details["Person"]["landmark"] NM1 SEGMENT EXAMPLE: NM1*PR*2*Educators Insurance*****PI*HT000214-001~ :: N3 SEGMENT EXAMPLE: N3*123 Main Street~ :: N4 SEGMENT EXAMPLE: N4*Anytown*KY* 1234567890~
		// there is much confusion in this loop and its data
		$loop['2010BB']=array("NM1"=>array("PR","2",trim($payer_details["TariffStandard"]["name"]),"","","","","PI",$payer_details["TariffStandard"]["payer_id"])
		);

		//$loop['2010BC']
		//$loop['2010BD'] - Responsible party loop


		//HL SEGMENT EXAMPLE: HL*3*2*23*0~ :: PAT SEGMENT EXAMPLE: PAT*19~
		//HL02 (Patient Hierarchical Parent ID Number) still not clear - Currently hard coded to 2


		//When the Subscriber is the Patient (2000B/SBR-02=18), the Dependent Loop (2000C) must not be present.
		//$loop['2000C']=array("HL"=>array($UIDpatient_details["Patient"]["patient_id"],"2","23","0"),"PAT"=>array("18"));

		//NM1 SEGMENT EXAMPLE: NM1*QC*1*SMITH*JENN****MI*12345678902~ :: N3 SEGMENT EXAMPLE: N3*123 Main Street~ :: N4 SEGMENT EXAMPLE: N4*Anytown*KY* 1234567890~ :: DMG SEGMENT EXAMPLE: DMG*D8*19740531*F~
		/*$loop['2010CA']=array("NM1"=>array("QC","1",$UIDpatient_details["Person"]["last_name"],$UIDpatient_details["Person"]["first_name"],$UIDpatient_details["Person"]["middle_name"],"","","ZZ",$UIDpatient_details["Patient"]["patient_id"]),
		 "N3"=>array($UIDpatient_details["Person"]["plot_no"],$UIDpatient_details["Person"]["landmark"]),
		"N4"=>array($UIDpatient_details["Person"]["city"],$UIDpatient_details["Person"]["state"],$UIDpatient_details["Person"]["pin_code"]),
		"DMG"=>array("D8",$patientdob,$gendervalue),
		"REF"=>array("Y4",$claimNumber)
		);*/

		//CLM SEGMENT EXAMPLE: CLM*123456789*163***11::1*Y*C*Y*Y~ :: DTP SEGMENT EXAMPLE: DTP*96*TM*2005~  :: DTP SEGMENT EXAMPLE: DTP*434*D8*20050113~ :: DTP SEGMENT EXAMPLE: CL1*1*7*30~  :: DTP SEGMENT EXAMPLE: AMT*C5*601.5~ :: DTP SEGMENT EXAMPLE: DTP*96*TM*2005~
		//REF SEGMENT EXAMPLE: REF*EA*123456789~ :: HI SEGMENT EXAMPLE: HI*BK:2005~ :: HI SEGMENT EXAMPLE: HI*DR:321~ :: HI SEGMENT EXAMPLE: HI*BF:V9782~  :: HI SEGMENT EXAMPLE: HI*BP:92795:D8:20070430~
		//HI SEGMENT EXAMPLE: HI*BQ:92795:D8:20070430~ :: DTP SEGMENT EXAMPLE: DTP*472*D8*20070430~
		//This is most imp loop

		//loop 2300 CLM05-1,CLM05-1, CLM05-1


		$CLM051=$placeOfService; //place of service
		$CLM052 ="B";//Facility Code Qualifier :: Hard Coded to 'B'
		$CLM053 ="1";//Claim Frequency Code :: this is to be fetched from claim manager screen
		$claimInsuranceType=$claim_encounter["[Encounter"]["primary_insurance"]; //File with insurance
		if($claimInsuranceType=="P")
			$benefit_accept_assign=$claim_encounter["Encounter"]["primary_benifits_assignment"];
		else if($claimInsuranceType=="S")
			$benefit_accept_assign=$claim_encounter["Encounter"]["sec_benifits_assignment"];
		else
			$benefit_accept_assign=$claim_encounter["Encounter"]["ter_benifits_assignment"];


		$CLM=$placeOfService.":".$CLM052.":".$CLM053;
		$loop2300_clm06=($claim_encounter["Encounter"]["executed_signature_clk"] = '') ? 'N' : 'Y';  //value can be N, Y :: N for provider signature not exist :: Y for provider signature exist :: This will be fetched dynamic later from claim detail page
		$loop2300_clm07="A"; //Claim Provider Accept Assignment :: This is situational or optional
		$loop2300_clm08=($benefit_accept_assign = '') ? 'W' : 'Y'; // value can be W, Y :: Claim Provider Benefits Assignment Certification :: will come dynamicaly from claim detail page
		$loop2300_clm09=($claim_encounter["[Encounter"]["information_signature_clk"] = '') ? 'N' : 'Y'; //Claim Release of Information Code :: value can be Y or N
		//$loop2300_clm10=""; //(Claim Patient Signature Source Code) :: value can be Y or N :: Confusion in this loop value
		//$loop2300_clm11=""; confusion in this value  First parameter is required

		if(!empty($claim_encounter["Encounter"]["onset_currrent_date"]))
			$loop2300_onsetDTP['DTP']=array("431","D8",str_replace("-","",$claim_encounter["Encounter"]["onset_currrent_date"]));

		if(!empty($claim_encounter["Encounter"]["initial_treatment_date"]))
			$loop2300_initialDTP['DTP']=array("454","D8",str_replace("-","",$claim_encounter["Encounter"]["initial_treatment_date"]));

		if(!empty($claim_encounter["Encounter"]["last_seen_date"]))
			$loop2300_lastseenDTP['DTP']=array("304","D8",str_replace("-","",$claim_encounter["Encounter"]["last_seen_date"]));

		if(!empty($claim_encounter["Encounter"]["accident_date"]))
			$loop2300_accidentDTP['DTP']=array("439","D8",str_replace("-","",$claim_encounter["Encounter"]["accident_date"]));

		if(!empty($claim_encounter["Encounter"]["service_date"]))
			$loop2300_admissionDTP['DTP']=array("435","D8",str_replace("-","",$claim_encounter["Encounter"]["service_date"]));

		if(!empty($claim_encounter["Encounter"]["to_date"]))
			$loop2300_dischargeDTP['DTP']=array("096","D8",str_replace("-","",$claim_encounter["Encounter"]["to_date"]));

		if(!empty($claim_encounter["Encounter"]["acute_manifestation_date"]))
			$loop2300_acutemanifestationDTP['DTP']=array("453","D8",str_replace("-","",$claim_encounter["Encounter"]["acute_manifestation_date"]));

		if(!empty($claim_encounter["Encounter"]["last_menstrual_date"]))
			$loop2300_lastmenstrualDTP['DTP']=array("484","D8",str_replace("-","",$claim_encounter["Encounter"]["last_menstrual_date"]));

		if(!empty($claim_encounter["Encounter"]["claim_notes"]))
			$loop2300_NTE['NTE']=array($claim_encounter["Encounter"]["claim_notes_ref_code"],$claim_encounter["Encounter"]["claim_notes"]);

		//diagnosis code
		$getIcdData=$this->NoteDiagnosis->find('all',array('conditions'=>array('patient_id'=>$id,'delete_for_claim'=>'0'),'fields'=>array('id','icd_id','diagnoses_name','diagnosis_type')));
		//debug($getIcdData);
		$loop2300_HI_otherdiagnosis="";
		foreach($getIcdData as $key=>$icdData)
		{


			if($icdData["NoteDiagnosis"]["diagnosis_type"]=="PD")
				$loop2300_HI="BK:".str_replace(".","",$icdData["NoteDiagnosis"]["icd_id"]);
			else
				$loop2300_HI_otherdiagnosis.="*"."BF:".str_replace(".","",$icdData["NoteDiagnosis"]["icd_id"]);

		}
		if(!empty($loop2300_HI_otherdiagnosis))
			$HIloop=$loop2300_HI.$loop2300_HI_otherdiagnosis;
		else
			$HIloop=$loop2300_HI;


		//this is imp, this need to be repeated on the basis principal diag and secondary diag
		$loop2300_HI="BK:".$diagnosisCode;

		//hospital NPI
		if(!empty($hospital_location["Location"]["hospital_npi"]))
		{
			$loop2310C_NPI=$hospital_location["Location"]["hospital_npi"];
		}
			


		//PWK is situational segment ,//AMT is situational segment ,//REF is situational segment
		$loop['2300']=array("CLM"=>array($UIDpatient_details["Person"]["patient_uid"],$totalClaimAmount,"","",$CLM,$loop2300_clm06,$loop2300_clm07,$loop2300_clm08,$loop2300_clm09),"DTP"=>$loop2300_onsetDTP['DTP'],"DTP_1"=>$loop2300_initialDTP['DTP'],"DTP_2"=>$loop2300_lastseenDTP['DTP'],"DTP_3"=>$loop2300_accidentDTP['DTP'],"DTP_4"=>$loop2300_admissionDTP['DTP'],"DTP_5"=>$loop2300_dischargeDTP['DTP'],
				"PWK"=>array(),
				"AMT"=>array(),
				"REF"=>array(),//SERVICE AUTHORIZATION EXCEPTION CODE 2300
				"REF_1"=>array(),//REFERRAL NUMBER 2300
				"REF_2"=>array(),//PRIOR AUTHORIZATION 2300
				"REF_3"=>array(),//PAYER CLAIM CONTROL NUMBER 2300
				"REF_4"=>array(),//CLINICAL LABORATORY IMPROVEMENT AMENDMENT
				"REF_5"=>array(),//MEDICAL RECORD NUMBER 2300
				"NTE"=>$loop2300_NTE['NTE'],//CLAIM NOTE 2300  :: situational
				"CR1"=>array(),//AMBULANCE TRANSPORT INFORMATION 2300 :: situational
				"HI"=>array($HIloop)//AMBULANCE TRANSPORT INFORMATION 2300 :: Required  ABK - ICD 10 CM, BK - ICD9
		);


			
		//NM1 SEGMENT EXAMPLE: NM1*71*1*SMITH*JOHN***XX*1234567890~ :: REF SEGMENT EXAMPLE: REF*SY*123456789~
		// Referring provider loop
		$loop['2310A']=array("NM1"=>array("00","          ","00","          ","ZZ",$zirmed_client_accountid),"PER"=>array("ZZ",Configure::read('receiver_id'),$currentdate,$currentTime,"U",$controlVersionNumber,$controlNumber,"1",Configure::read('zirmed_mode'),">"));

		//This is a situational loop, meaning that it is only used in certain situations.  A common situation is when a provider bills as a part of a group practice.
		// If that was true, the group provider number would appear in loop 2010AA and the individual provider number would appear in loop 2310B.
		$loop['2310B']=array("NM1"=>array("00","          ","00","          ","ZZ",$zirmed_client_accountid),"PER"=>array("ZZ",Configure::read('receiver_id'),$currentdate,$currentTime,"U",$controlVersionNumber,$controlNumber,"1",Configure::read('zirmed_mode'),">"));

		//SERVICE FACILITY LOCATION 2310C  :: Required Loop  :: SBR is situational


		$loop['2310C']=array("NM1"=>array("77","2",$facility["Facility"]["name"],"","","","","XX",$loop2310C_NPI),
				"N3"=>array(trim($facility["Facility"]["address1"])),
				"N4"=>array($city_facility["City"]["name"],$state_facility["State"]["state_code"],$facility["Facility"]["zipcode"]."0000"),
				"REF"=>array("G2",$facility["Facility"]["id"])
		);
		//This loop is used to indicate the facility that services were rendered.  It contains the Facility Name, Address, and Facility ID (if one has been entered).
		$loop['2310D']=array("NM1"=>array("00","          ","00","          ","ZZ",$zirmed_client_accountid),"PER"=>array("ZZ",Configure::read('receiver_id'),$currentdate,$currentTime,"U",$controlVersionNumber,$controlNumber,"1",Configure::read('zirmed_mode'),">"));

		//This loop contains information about a patient's secondary insurance policy.  This does not mean that the secondary insurance company is being billed.  Because of HIPAA ANSI Specifications, the patient's secondary insurance policy information MUST be included.
		// If the patient does not have a secondary insurance policy, this loop will be omitted
		$loop['2330A']=array("NM1"=>array("00","          ","00","          ","ZZ",$zirmed_client_accountid),"PER"=>array("ZZ",Configure::read('receiver_id'),$currentdate,$currentTime,"U",$controlVersionNumber,$controlNumber,"1",Configure::read('zirmed_mode'),">"));

		//This loop contains information about a patient's secondary insurance.  This does not mean that the secondary insurance company is being billed.  Because of HIPAA ANSI Specifications, the patient's secondary insurance policy information MUST be included.
		//  If the patient does not have a secondary insurance policy, this loop will be omitted.
		$loop['2330B']=array("NM1"=>array("00","          ","00","          ","ZZ",$zirmed_client_accountid),"PER"=>array("ZZ",Configure::read('receiver_id'),$currentdate,$currentTime,"U",$controlVersionNumber,$controlNumber,"1",Configure::read('zirmed_mode'),">"));

		//This loop contains information about a patient's secondary insurance.  This does not mean that the secondary insurance company is being billed.  Because of HIPAA ANSI Specifications, the patient's secondary insurance policy information MUST be included.  If the patient does not have a secondary insurance policy, this loop will be omitted.

		//NOTE: This loop is ONLY used when the Patient and the Insured Person are different.
		//In that case, Loop 2330A would show the Insured's name, and loop 2330C would show the Patient's name.
		// This loop contains the same criteria as that of Loop 2010BA.
		$loop['2330C']=array("NM1"=>array("00","          ","00","          ","ZZ",$zirmed_client_accountid),"PER"=>array("ZZ",Configure::read('receiver_id'),$currentdate,$currentTime,"U",$controlVersionNumber,$controlNumber,"1",Configure::read('zirmed_mode'),">"));

		//LX SEGMENT EXAMPLE: LX*1~ :: SV2 SEGMENT EXAMPLE: SV2*300*HC:8019*73.2*UN*1~  :: Required Loop

		//procedure loop
		$this->ProcedurePerform->bindModel(array(
				'belongsTo' => array(
						'TariffList' =>array( 'foreignKey'=>false,'conditions'=>array('ProcedurePerform.snowmed_code=TariffList.cbt')),
						'TariffAmount' =>array( 'foreignKey'=>false,'conditions'=>array('TariffList.id=TariffAmount.tariff_list_id')),
				)),false);
		$getPrData=$this->ProcedurePerform->find('all',array('conditions'=>array('patient_id'=>$id),
				'fields'=>array('TariffList.price_for_private','ProcedurePerform.procedure_name','ProcedurePerform.snowmed_code',
						'ProcedurePerform.modifier1','ProcedurePerform.modifier2','ProcedurePerform.modifier3','ProcedurePerform.modifier4',
						'ProcedurePerform.procedure_to_date','ProcedurePerform.place_service','ProcedurePerform.units','ProcedurePerform.patient_daignosis',
						'ProcedurePerform.procedure_date','TariffAmount.non_nabh_charges')));
		$procedureCount=1;

		foreach($getPrData as $getPrData)
		{

			$loop2400_SV1="HC".":".$getPrData["ProcedurePerform"]["snowmed_code"]; //HC-HCPCS codes // these codes will be fetched dynamically: Currently static 99214 is put

			if(!empty($getPrData["ProcedurePerform"]["modifier1"]))
				$loop2400_SV1.=":".$getPrData["ProcedurePerform"]["modifier1"];

			if(!empty($getPrData["ProcedurePerform"]["modifier2"]))
				$loop2400_SV1.=":".$getPrData["ProcedurePerform"]["modifier2"];

			if(!empty($getPrData["ProcedurePerform"]["modifier3"]))
				$loop2400_SV1.=":".$getPrData["ProcedurePerform"]["modifier3"];

			if(!empty($getPrData["ProcedurePerform"]["modifier4"]))
				$loop2400_SV1.=":".$getPrData["ProcedurePerform"]["modifier4"];

			//$totalProcedureCharges=$totalProcedureCharges+(($getPrData['ProcedurePerform']['units'])*($getPrData['TariffAmount']['non_nabh_charges']));

			$diagnosisPointer=explode(",",$getPrData['ProcedurePerform']['patient_diagnosis']);
			$diagnosisPointer=serialize($diagnosisPointer);
			debug($diagnosisPointer);
			$diagnosispointerString="";
			for($i=0;$i<count($diagnosisPointer);$i++)
			{
				$diagnosispointerString.=$diagnosisPointer[$i].":";
			}

			//from and To service date
				
			$serviceDate=str_replace("-","",$getPrData['ProcedurePerform']['procedure_date']);

			 if(empty($diagnosispointerString))
			 	$diagPointerPresent="*1";
			 
			$loop['2400'][]=array("LX"=>array($procedureCount),
					"SV1"=>array($loop2400_SV1,$getPrData['TariffAmount']['non_nabh_charges'],"UN",$getPrData['ProcedurePerform']['units'],$getPrData['ProcedurePerform']['place_service'],"",rtrim($diagnosispointerString,":").$diagPointerPresent),
					"DTP"=>array("472","D8",$serviceDate)
			);
			$procedureCount++;

		}

		//end of procedure loop
		//debug($insuranceFileId); debug($count);
		if(($insuranceFileId==$count)||(empty($count))){
			$loop['footer']=array(
					"IEA"=>array($count,$isaseg13)
			);

		}
		//"REF"=>array("6R","1134")
		if(($insuranceFileId!=0) ||($insuranceFileId!='saveSingleFile')){
			unset ($data[ISA]);
			//unset ($data[GS]);
		}
		

		$getResult=$this->Insurance->generateClaimHeader($data,$loop,$groupControlNumber);
		
		
		if(trim($insuranceFileId)=='saveSingleFile'){
			$expCurrentDate=explode('/',date("Y/m/d"));
			$fileName=$expCurrentDate['0'].$expCurrentDate['1'].$expCurrentDate['2'].'_patient_'.$id.''.rand(10,100);
			$ediFileName = "files/Edi_files/".$fileName.".CLP";
			$myFileHandle = fopen($ediFileName, 'w') or die("can't open file");
			fwrite($myFileHandle, trim($getResult));
			fclose($ediFileName);
			$this->uses=array('Batch');
			$explogroup_control_number1=explode('GE*1*',$getResult);
			$exploImp1group_control_number1=explode('~',$explogroup_control_number1[1]);
			$group_control_number1=$exploImp1group_control_number1[0];
			
			//find if batch is already there
			
			$batchpresentVal = $this->Batch->find('first', array('fields'=> array('Batch.id'),'conditions'=>array('Batch.patient_ids' => $id)));
			if(!empty($batchpresentVal["Batch"]["id"]))
			{
				$this->Batch->updateAll(array('batch_name'=>"'".$fileName."'",'batch_data'=>"'".trim($getResult)."'",'group_control_number'=>$group_control_number1,
						'member_in_batch'=>'1','patient_ids'=>$id,'is_batch'=>'1','file_created'=>'1','location_id'=>$this->Session->read(locationid),
						'created_time'=>"'".date('Y/m/d H:i:s')."'"),array('id'=>$batchpresentVal["Batch"]["id"]));
				
			}
			else
			{				
			      $this->Batch->save(array('batch_name'=>$fileName,'batch_data'=>trim($getResult),'group_control_number'=>$group_control_number1,
					'member_in_batch'=>'1','patient_ids'=>$id,'is_batch'=>'1','file_created'=>'1','location_id'=>$this->Session->read(locationid),
					'created_time'=>date('Y/m/d H:i:s')));
		     }
		}
		return $getResult;
		//echo $getResult;
		//exit;

	}

	function incorporate_edi($messageType=null)
	{

		//$this->autoRender=false;
		if($messageType=='999')//for 999 incorporation
		{
			$fileData = file_get_contents('files/Edi_files/999downloads/999(4).txt', true);

			$fileDataArr=explode("IK3",$fileData);//this is for error response
			
			if(count($fileDataArr)<=1)
			{
				$fileDataArr=explode("IK5",$fileData);//this is for success response
				$isSuccess=1;
			}
			else 
				$isSuccess=0;
			
			
			if($isSuccess==0)// for error messages
			{
			   foreach ($fileDataArr as $key=>$value)
			   {
				if($key!=0)
					$incorporate999["errors"][]=$value;
				else
					$incorporate999["otherdata"][]=$fileDataArr["0"];
					
			  }
			}
			else //for accepted messages
			{
				foreach ($fileDataArr as $key=>$value)
				{
					
						$incorporate999["otherdata"][]=$fileDataArr["0"];
						
				}
				
			
			}

			//response message count
			$messageCount=count($incorporate999["errors"]);

			$getError=$this->Insurance->generateResponseMessage($incorporate999,$messageCount,$messageType,$isSuccess);
			return $getError;
		}
		else if($messageType=='277')//for 277 incorporation
		{
				
			$fileData = file_get_contents('files/Edi_files/277downloads/277.txt', true);
				
			$fileData=explode("~",$fileData);
				
				
			$getError=$this->Insurance->generateResponseMessage($fileData,$messageCount,$messageType);
			return $getError;
				
				
		}
		else
		{
				
		}


		//debug($incorporate999["otherdata"]);
	}

	//'conditions'=>array('InsuranceAuthorization.end_date >='=>date('Y-m-d')),
	public function insuranceAuthorization($patientId=null){
		//debug($this->request->data);exit;
		//if($this->request->is('ajax')){
		$this->layout = 'ajax' ;
		//}
		$this->set('patientId',$patientId);
		$this->uses = array('InsuranceAuthorization','Patient');
		//$ptid = $this->Patient->find('first',array('fields'=>array('Patient.patient_id'),'conditions'=>array('Patient.id'=>$patientId)));
		$this->InsuranceAuthorization->bindModel(array(
				'belongsTo' => array(
						'TariffList' =>array('foreignKey' => false,'conditions'=>array('TariffList.cbt=InsuranceAuthorization.procedure_code')),
				)),false);
		$activeAuthorizations = $this->InsuranceAuthorization->find('all',array('fields'=>array('InsuranceAuthorization.*','TariffList.name'),
				'conditions'=>array('patient_uid'=>$patientId,'InsuranceAuthorization.end_date >='=>date('Y-m-d'),'expired'=>0)));
		$expiredAuthorizations = $this->InsuranceAuthorization->find('all',array('fields'=>array('InsuranceAuthorization.*','TariffList.name'),
				'conditions'=>array('OR'=>array('patient_uid'=>$patientId,'InsuranceAuthorization.end_date <'=>date('Y-m-d')),array('expired'=>1))));
		$this->set(array('activeAuthorizations'=>$activeAuthorizations,'expiredAuthorizations'=>$expiredAuthorizations));
	}

	//ajax list render
	function ajaxInsuranceAuthorization($patientId){
		$this->layout = 'ajax';
		$this->insuranceAuthorization($patientId) ;
	}

	public function newInsuranceAuthorization($patientId=null,$id=null){
		//debug($this->request->data);exit;//debug($id);exit;
		$this->set('patientId',$patientId);
		$this->layout = 'advance_ajax' ;
		$this->uses = array('InsuranceAuthorization','Patient','InsuranceAuthorization','Patient');
		$this->InsuranceAuthorization->bindModel(array(
				'belongsTo' => array(
						'TariffList' =>array('foreignKey' => false,'conditions'=>array('TariffList.cbt=InsuranceAuthorization.procedure_code')),
				)),false);
		$this->Patient->unBindModel(array('hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		if(!empty($id)){
			$data = $this->InsuranceAuthorization->find('first',array('fields'=>array('InsuranceAuthorization.*','TariffList.name'),
					'conditions'=>array('InsuranceAuthorization.id'=>$id)));
			$this->set(array('data'=>$data,'patientId'=>$patientId));
		}
		
		if($this->request->data){
			//$ptid = $this->Patient->find('first',array('fields'=>array('Patient.patient_id'),'conditions'=>array('Patient.id'=>$patientId)));
			$this->request->data['InsuranceAuthorization']['patient_id']=$patientId;
			$this->request->data['InsuranceAuthorization']['patient_uid']=$patientId;
			$this->request->data['InsuranceAuthorization']['create_time']=date('Y-m-d H:i:s');
			$this->request->data['InsuranceAuthorization']['created_by']=$this->Session->read('userid');
			$this->request->data['InsuranceAuthorization']['location_id']=$this->Session->read('locationid');
			$this->request->data['InsuranceAuthorization']['visit_remaining']=$this->request->data['InsuranceAuthorization']['visit_approved'];
			$this->request->data['InsuranceAuthorization']['procedure_code']=$this->request->data['InsuranceAuthorization']['cbt'];
			$this->request->data['InsuranceAuthorization']['start_date'] = $this->DateFormat->formatDate2STD($this->request->data['InsuranceAuthorization']['start_date'],Configure::read('date_format'));
			$this->request->data['InsuranceAuthorization']['end_date'] = $this->DateFormat->formatDate2STD($this->request->data['InsuranceAuthorization']['end_date'],Configure::read('date_format'));
			if($this->request->data['InsuranceAuthorization']['end_date'] < date('Y-m-d')){
				$this->request->data['InsuranceAuthorization']['expired']='1';
			}else{
				$this->request->data['InsuranceAuthorization']['expired']='0';
			}
			if($this->InsuranceAuthorization->save($this->request->data)){
				$this->Session->setFlash(__('Record Added successfully'),true);
				echo true;
			}else{
				echo false;
			}
			//exit;
		}
		
		//$this->uses = array('InsuranceAuthorization','Patient');
		//$ptid = $this->Patient->find('first',array('fields'=>array('Patient.patient_id'),'conditions'=>array('Patient.id'=>$patientId)));
		
		$activeAuthorizations = $this->InsuranceAuthorization->find('all',array('fields'=>array('InsuranceAuthorization.*','TariffList.name'),
				'conditions'=>array('patient_uid'=>$patientId,'InsuranceAuthorization.end_date >='=>date('Y-m-d'),'expired'=>0)));
		$expiredAuthorizations = $this->InsuranceAuthorization->find('all',array('fields'=>array('InsuranceAuthorization.*','TariffList.name'),
				'conditions'=>array('OR'=>array('patient_uid'=>$patientId,'InsuranceAuthorization.end_date <'=>date('Y-m-d')),array('expired'=>1))));
		$this->set(array('activeAuthorizations'=>$activeAuthorizations,'expiredAuthorizations'=>$expiredAuthorizations));
	}

	public function editInsuranceAuthorization($id=null){
		$this->layout = 'ajax' ;
		$this->uses = array('InsuranceAuthorization','Patient');
		$this->InsuranceAuthorization->bindModel(array(
				'belongsTo' => array(
						'TariffList' =>array('foreignKey' => false,'conditions'=>array('TariffList.cbt=InsuranceAuthorization.procedure_code')),
				)),false);
		$data = $this->InsuranceAuthorization->find('first',array('fields'=>array('InsuranceAuthorization.*','TariffList.name'),
				'conditions'=>array('InsuranceAuthorization.id'=>$id)));
		$this->set(array('data'=>$data,'patientId'=>$data['InsuranceAuthorization']['patient_id']));

		if($this->request->data){
			$this->request->data['InsuranceAuthorization']['modified_by']=date('Y-m-d H:i:s');
			$this->request->data['InsuranceAuthorization']['modified_by']=$this->Session->read('userid');
			$this->request->data['InsuranceAuthorization']['procedure_code']=$this->request->data['InsuranceAuthorization']['cbt'];
			$this->request->data['InsuranceAuthorization']['start_date'] = $this->DateFormat->formatDate2STD($this->request->data['InsuranceAuthorization']['start_date'],Configure::read('date_format'));
			$this->request->data['InsuranceAuthorization']['end_date'] = $this->DateFormat->formatDate2STD($this->request->data['InsuranceAuthorization']['end_date'],Configure::read('date_format'));
			if($this->request->data['InsuranceAuthorization']['end_date'] < date('Y-m-d')){
				$this->request->data['InsuranceAuthorization']['expired']='1';
			}else{
				$this->request->data['InsuranceAuthorization']['expired']='0';
			}
			if($this->InsuranceAuthorization->save($this->request->data)){
				$this->Session->setFlash(__('Record Updated successfully'),true);
				echo true;
				exit;
			}else{
				echo false;
			}
			//exit;
		}
	}

	public function deleteInsuranceAuthorization($id=null,$patientId=null){
			
		if($id){
			$this->uses = array('InsuranceAuthorization');
			$this->InsuranceAuthorization->delete($id);
			$this->Session->setFlash(__('Record has been Deleted successfully'),true);
			$this->redirect(array('action'=>'ajaxInsuranceAuthorization',$patientId));
		}
	}


	//yashwant--- *****work on Account Receivable Managment******//

	public function account_receivable_managment($insurance_company_id=null,$month=null,$amount=null){
		$id = 85;
		$this->patient_info($id);
		$this->set('insurance_company_id',$insurance_company_id);
		$this->set('month',$month);
		$this->set('amount',$amount);
		$this->uses = array('NewInsurance');
		//$this->Patient->unBindModel(array('hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
		$this->NewInsurance->bindModel(array(
				'belongsTo' => array(
						'Patient' =>array('foreignKey' => false,'conditions'=>array('NewInsurance.patient_uid=Patient.patient_id')),
						'Person' =>array('foreignKey' => false,'conditions'=>array('NewInsurance.patient_uid=Person.patient_uid')),
						'TariffStandard' =>array('foreignKey' => false,'conditions'=>array('TariffStandard.id=NewInsurance.tariff_standard_id')),
						'FinalBilling' =>array('foreignKey' => false,'conditions'=>array('FinalBilling.patient_id=NewInsurance.patient_id')),
						'DumpNote' =>array('foreignKey' => false,'conditions'=>array('DumpNote.patient_id=Patient.id'),'order'=>array('DumpNote.patient_id DESC')),
						//'TariffAmount' =>array('foreignKey' => false,'conditions'=>array('TariffAmount.tariff_list_id=ServiceBill.tariff_list_id AND TariffAmount.tariff_standard_id=ServiceBill.tariff_standard_id')),
				//'Billing' =>array('foreignKey' => false ,'conditions'=>array('Patient.id=Billing.patient_id') ),
				),
		));
		$insData = $this->NewInsurance->find('all',array('fields'=>array('Patient.id','Patient.patient_id','Patient.lookup_name','Patient.form_received_on','Person.dob',
				'FinalBilling.total_amount','FinalBilling.claim_status','FinalBilling.copay','FinalBilling.collected_copay','TariffStandard.payer_id','TariffStandard.name',
				'FinalBilling.amount_pending_ins_company','FinalBilling.amount_pending_ins_2_company','FinalBilling.amount_collected_ins_company','FinalBilling.bill_number',
				'FinalBilling.amount_pending_ins_2_company','NewInsurance.insurance_number','NewInsurance.tariff_standard_id','DumpNote.note'),
				'conditions'=>array('NewInsurance.tariff_standard_id'=>$insurance_company_id ),'group'=>array('Patient.id')));
		$this->set('insData',$insData);
	}


	public function detailClaim($patient_id=null){
		$this->layout = false ;
		$this->generateReceipt($patient_id);
	}

	public function accRecevableManagment($insurance_company_id=null,$month=null,$amount=null){
		$this->layout=false;
		$this->set('month',$month);
		$this->set('amount',$amount);
		$this->uses = array('NewInsurance');
		$this->NewInsurance->bindModel(array(
				'belongsTo' => array(
						'Patient' =>array('foreignKey' => false,'conditions'=>array('NewInsurance.patient_uid=Patient.patient_id')),
						'Person' =>array('foreignKey' => false,'conditions'=>array('NewInsurance.patient_uid=Person.patient_uid')),
						'TariffStandard' =>array('foreignKey' => false,'conditions'=>array('TariffStandard.id=NewInsurance.tariff_standard_id')),
						'FinalBilling' =>array('foreignKey' => false,'conditions'=>array('FinalBilling.patient_id=NewInsurance.patient_id')),
						'DumpNote' =>array('foreignKey' => false,'conditions'=>array('DumpNote.patient_id=Patient.id'),'order'=>array('DumpNote.patient_id DESC')),
				),
		));
		$insData = $this->NewInsurance->find('all',array('fields'=>array('Patient.id','Patient.patient_id','Patient.lookup_name','Patient.form_received_on','Person.dob',
				'FinalBilling.total_amount','FinalBilling.claim_status','FinalBilling.copay','FinalBilling.collected_copay','TariffStandard.payer_id','TariffStandard.name',
				'FinalBilling.amount_pending_ins_company','FinalBilling.amount_pending_ins_2_company','FinalBilling.amount_collected_ins_company','FinalBilling.bill_number',
				'FinalBilling.amount_pending_ins_2_company','NewInsurance.insurance_number','NewInsurance.tariff_standard_id','DumpNote.note'),
				'conditions'=>array('NewInsurance.tariff_standard_id'=>$insurance_company_id ),'group'=>array('Patient.id')));
		$this->set('insData',$insData);
	}


	public function acc_recevable_managment_excel($insurance_company_id=null,$month=null,$amount=null){
		$this->set('month',$month);
		$this->set('amount',$amount);
		$this->uses = array('NewInsurance');
		$this->NewInsurance->bindModel(array(
				'belongsTo' => array(
						'Patient' =>array('foreignKey' => false,'conditions'=>array('NewInsurance.patient_uid=Patient.patient_id')),
						'Person' =>array('foreignKey' => false,'conditions'=>array('NewInsurance.patient_uid=Person.patient_uid')),
						'TariffStandard' =>array('foreignKey' => false,'conditions'=>array('TariffStandard.id=NewInsurance.tariff_standard_id')),
						'FinalBilling' =>array('foreignKey' => false,'conditions'=>array('FinalBilling.patient_id=NewInsurance.patient_id')),
						'DumpNote' =>array('foreignKey' => false,'conditions'=>array('DumpNote.patient_id=Patient.id'),'order'=>array('DumpNote.patient_id DESC')),
				),
		));
		$insData = $this->NewInsurance->find('all',array('fields'=>array('Patient.id','Patient.patient_id','Patient.lookup_name','Patient.form_received_on','Person.dob',
				'FinalBilling.total_amount','FinalBilling.claim_status','FinalBilling.copay','FinalBilling.collected_copay','TariffStandard.payer_id','TariffStandard.name',
				'FinalBilling.amount_pending_ins_company','FinalBilling.amount_pending_ins_2_company','FinalBilling.amount_collected_ins_company','FinalBilling.bill_number',
				'FinalBilling.amount_collected_ins_2_company','NewInsurance.insurance_number','NewInsurance.tariff_standard_id','DumpNote.note'),
				'conditions'=>array('NewInsurance.tariff_standard_id'=>$insurance_company_id ),'group'=>array('Patient.id')));
		$this->set('insData',$insData);
		$this->render('acc_recevable_managment_excel','');
	}

	//yashwant---claim balance company----//
	public function claim_balance_company(){
		$id = 85;
		$this->patient_info($id);
		$this->uses = array('FinalBilling');
		$this->FinalBilling->bindModel(array(
				'belongsTo' => array(
						'NewInsurance' =>array('foreignKey' => false,'conditions'=>array('NewInsurance.patient_id=FinalBilling.patient_id')),
						'TariffStandard' =>array('foreignKey' => false,'conditions'=>array('TariffStandard.id=NewInsurance.tariff_standard_id')),
				)),false);
		$reportYear=date('Y');
		$fromdate=$reportYear."-01-01 00:00:00";
		$todate=$reportYear."-12-31 23:59:59";
		$payer_id = trim($this->request->data['payer_id']);
		$ins_company_name = trim($this->request->data['ins_company_name']);
		if(!empty($this->request->data)){
			if(!empty($payer_id) && empty($ins_company_name)){
				$condition = array('FinalBilling.discharge_date >='=>$fromdate,'FinalBilling.discharge_date <='=>$todate,'TariffStandard.payer_id like '=>'%'.$payer_id.'%');
			}
			elseif(empty($payer_id) && !empty($ins_company_name)){
				$condition =array('FinalBilling.discharge_date >='=>$fromdate,'FinalBilling.discharge_date <='=>$todate,'TariffStandard.name'=>$ins_company_name);
					
			}elseif(!empty($payer_id) && !empty($ins_company_name)){
				$condition = array('FinalBilling.discharge_date >='=>$fromdate,'FinalBilling.discharge_date <='=>$todate,'TariffStandard.payer_id like '=>$payer_id,'TariffStandard.name'=>$ins_company_name);
			}else{
				$condition = array('FinalBilling.discharge_date >='=>$fromdate,'FinalBilling.discharge_date <='=>$todate,'FinalBilling.location_id='.$this->Session->read('locationid').' || FinalBilling.location_id=0');
			}

			$this->paginate = array(
					'limit' => '20',
					'group' => 'TariffStandard.name',
					'fields'=>array('TariffStandard.id','TariffStandard.payer_id','TariffStandard.name',
							'SUM(FinalBilling.amount_pending_ins_company) as amount_pending_ins_company ',
							'SUM(FinalBilling.amount_pending_ins_2_company) as amount_pending_ins_2_company',
							'SUM(FinalBilling.amount_collected_ins_company) as amount_collected_ins_company',
							'SUM(FinalBilling.amount_collected_ins_2_company) as amount_collected_ins_2_company',
							'DATE_FORMAT(LAST_DAY(FinalBilling.date),"%d") as DAY','MONTH(FinalBilling.date) as MONTH',
							'((SUM(FinalBilling.amount_pending_ins_company) - SUM(FinalBilling.amount_collected_ins_company)) + (SUM(FinalBilling.amount_pending_ins_2_company) - SUM(FinalBilling.amount_collected_ins_2_company))) as ins_bal'),
					'conditions'=>$condition,
			);
			$insCompanyList = $this->paginate('FinalBilling');
			/* $insCompanyList= $this->FinalBilling->find('all',array('fields'=>array('TariffStandard.id','TariffStandard.payer_id','TariffStandard.name',
			 'SUM(FinalBilling.amount_pending_ins_company) as amount_pending_ins_company ',
					'SUM(FinalBilling.amount_pending_ins_2_company) as amount_pending_ins_2_company',
					'SUM(FinalBilling.amount_collected_ins_company) as amount_collected_ins_company',
					'SUM(FinalBilling.amount_collected_ins_2_company) as amount_collected_ins_2_company',
					'DATE_FORMAT(LAST_DAY(FinalBilling.date),"%d") as DAY','MONTH(FinalBilling.date) as MONTH',
					'((SUM(FinalBilling.amount_pending_ins_company) - SUM(FinalBilling.amount_collected_ins_company)) + (SUM(FinalBilling.amount_pending_ins_2_company) - SUM(FinalBilling.amount_collected_ins_2_company))) as ins_bal'),
					'conditions'=>array('FinalBilling.discharge_date >='=>$fromdate,'FinalBilling.discharge_date <='=>$todate,'OR'=>array(array('TariffStandard.payer_id'=>$payer_id),array('TariffStandard.name'=>$ins_company_name))),
					//'OR'=>array('TariffStandard.payer_id LIKE'=>"$payer_id%",'TariffStandard.name LIKE'=>"$ins_company_name%"),
					'group' => array('TariffStandard.name'))); */
			//debug($insCompanyList);exit;
			$amountIc = 0;
			$count = count($insCompanyList) - 1;
			foreach ($insCompanyList as $key=>$data){
				if($key > 3){
					$amountIc = $amountIc + (int) $data['0']['ins_bal'];
					$var=(int) $data['0']['MONTH'];
					if($key < $count){
						continue;
					}
				}
				if($key < 4){
					$amountIc = $amountIc + (int) $data['0']['ins_bal'];
					$var=(int) $data['0']['MONTH'];
				}else{
					$amountIc = $amountIc + (int) $data['0']['ins_bal'];
					$var=(int) $data['0']['MONTH'];
				}
			}
			$this->set(compact('insCompanyList','amountIc','var'));

		}else{

			$this->paginate = array(
					'limit' => '20',
					'group' => 'TariffStandard.name',
					'fields'=>array('TariffStandard.id','TariffStandard.payer_id','TariffStandard.name',
							'SUM(FinalBilling.amount_pending_ins_company) as amount_pending_ins_company ','SUM(FinalBilling.amount_pending_ins_2_company) as amount_pending_ins_2_company',
							'SUM(FinalBilling.amount_collected_ins_company) as amount_collected_ins_company','SUM(FinalBilling.amount_collected_ins_2_company) as amount_collected_ins_2_company',
							'DATE_FORMAT(LAST_DAY(FinalBilling.date),"%d") as DAY','MONTH(FinalBilling.date) as MONTH',
							'((SUM(FinalBilling.amount_pending_ins_company) - SUM(FinalBilling.amount_collected_ins_company)) + (SUM(FinalBilling.amount_pending_ins_2_company) - SUM(FinalBilling.amount_collected_ins_2_company))) as ins_bal'),
					'conditions'=>array('FinalBilling.discharge_date >='=>$fromdate,'FinalBilling.discharge_date <='=>$todate)
			);
			$insCompanyList = $this->paginate('FinalBilling');
			/* $insCompanyList= $this->FinalBilling->find('all',array('fields'=>array('TariffStandard.id','TariffStandard.payer_id','TariffStandard.name',
			 'SUM(FinalBilling.amount_pending_ins_company) as amount_pending_ins_company ',
					'SUM(FinalBilling.amount_pending_ins_2_company) as amount_pending_ins_2_company',
					'SUM(FinalBilling.amount_collected_ins_company) as amount_collected_ins_company',
					'SUM(FinalBilling.amount_collected_ins_2_company) as amount_collected_ins_2_company',
					'DATE_FORMAT(LAST_DAY(FinalBilling.date),"%d") as DAY','MONTH(FinalBilling.date) as MONTH',
					'((SUM(FinalBilling.amount_pending_ins_company) - SUM(FinalBilling.amount_collected_ins_company)) + (SUM(FinalBilling.amount_pending_ins_2_company) - SUM(FinalBilling.amount_collected_ins_2_company))) as ins_bal'
			),
					'conditions'=>array('FinalBilling.discharge_date >='=>$fromdate,'FinalBilling.discharge_date <='=>$todate),
					'group' => array('TariffStandard.name'))); */
			//debug($insCompanyList);
			$amountIc = 0;
			$count = count($insCompanyList) - 1;
			foreach ($insCompanyList as $key=>$data){
				if($key > 3){
					$amountIc = $amountIc + (int) $data['0']['ins_bal'];
					$var=(int) $data['0']['MONTH'];
					if($key < $count){
						continue;
					}
					if($key < 4){
						$amountIc = $amountIc + (int) $data['0']['ins_bal'];
						$var=(int) $data['0']['MONTH'];
					}else{
						$amountIc = $amountIc + (int) $data['0']['ins_bal'];
						$var=(int) $data['0']['MONTH'];
					}
				}
				$this->set(compact('insCompanyList','amountIc','var'));
			}
		}
	}


	public function search_company($flag=null){
		$searchKey = $this->params->query['q'] ;
		$this->uses = array('FinalBilling');
		$this->FinalBilling->bindModel(array(
				'belongsTo' => array(
						'NewInsurance' =>array('foreignKey' => false,'conditions'=>array('NewInsurance.patient_id=FinalBilling.patient_id')),
						'TariffStandard' =>array('foreignKey' => false,'conditions'=>array('TariffStandard.id=NewInsurance.tariff_standard_id')),
				)),false);
		$reportYear=date('Y');
		$fromdate=$reportYear."-01-01 00:00:00";
		$todate=$reportYear."-12-31 23:59:59";
		$insCompanyList= $this->FinalBilling->find('all',array('fields'=>array('TariffStandard.id','TariffStandard.payer_id','TariffStandard.name',),
				'conditions'=>array('FinalBilling.discharge_date >='=>$fromdate,'FinalBilling.discharge_date <='=>$todate,
						"OR"=>array("TariffStandard.".$flag.' LIKE'=>"%$searchKey%")),'group' => array('TariffStandard.name')));
		foreach ($insCompanyList as $key=>$value) {
			$var=$value['TariffStandard'][$flag];
			//$payer=$value['TariffStandard']['payer_id'];
			echo "$var|$key\n";
		}
		exit;//dont remove this
	}

	public function print_claim_balance_company(){
		$this->layout=false;
		$this->uses = array('FinalBilling');
		$this->FinalBilling->bindModel(array(
				'belongsTo' => array(
						'NewInsurance' =>array('foreignKey' => false,'conditions'=>array('NewInsurance.patient_id=FinalBilling.patient_id')),
						'TariffStandard' =>array('foreignKey' => false,'conditions'=>array('TariffStandard.id=NewInsurance.tariff_standard_id')),
				)),false);
		$reportYear=date('Y');
		$fromdate=$reportYear."-01-01 00:00:00";
		$todate=$reportYear."-12-31 23:59:59";
		$insCompanyList= $this->FinalBilling->find('all',array('fields'=>array('TariffStandard.id','TariffStandard.payer_id','TariffStandard.name',
				'SUM(FinalBilling.amount_pending_ins_company) as amount_pending_ins_company ',
				'SUM(FinalBilling.amount_pending_ins_2_company) as amount_pending_ins_2_company',
				'SUM(FinalBilling.amount_collected_ins_company) as amount_collected_ins_company',
				'SUM(FinalBilling.amount_collected_ins_2_company) as amount_collected_ins_2_company',
				'DATE_FORMAT(LAST_DAY(FinalBilling.date),"%d") as DAY','MONTH(FinalBilling.date) as MONTH',
				'((SUM(FinalBilling.amount_pending_ins_company) - SUM(FinalBilling.amount_collected_ins_company)) + (SUM(FinalBilling.amount_pending_ins_2_company) - SUM(FinalBilling.amount_collected_ins_2_company))) as ins_bal'

		),
				'conditions'=>array('FinalBilling.discharge_date >='=>$fromdate,'FinalBilling.discharge_date <='=>$todate),'group' => array('TariffStandard.name')));
		$amountIc = 0;
		$count = count($insCompanyList) - 1;
		foreach ($insCompanyList as $key=>$data){
			if($key > 3){
				$amountIc = $amountIc + (int) $data['0']['ins_bal'];
				$var=(int) $data['0']['MONTH'];
				if($key < $count){
					continue;
				}
			}
			if($key < 4){
				$amountIc = $amountIc + (int) $data['0']['ins_bal'];
				$var=(int) $data['0']['MONTH'];
			}else{
				$amountIc = $amountIc + (int) $data['0']['ins_bal'];
				$var=(int) $data['0']['MONTH'];
			}
		}
		$this->set(compact('insCompanyList','amountIc','var'));
	}

	public function claim_balance_company_excel(){
		$this->uses = array('FinalBilling');
		$this->FinalBilling->bindModel(array(
				'belongsTo' => array(
						'NewInsurance' =>array('foreignKey' => false,'conditions'=>array('NewInsurance.patient_id=FinalBilling.patient_id')),
						'TariffStandard' =>array('foreignKey' => false,'conditions'=>array('TariffStandard.id=NewInsurance.tariff_standard_id')),
				)),false);
		$reportYear=date('Y');
		$fromdate=$reportYear."-01-01 00:00:00";
		$todate=$reportYear."-12-31 23:59:59";
		$insCompanyList= $this->FinalBilling->find('all',array('fields'=>array('TariffStandard.id','TariffStandard.payer_id','TariffStandard.name',
				'SUM(FinalBilling.amount_pending_ins_company) as amount_pending_ins_company ',
				'SUM(FinalBilling.amount_pending_ins_2_company) as amount_pending_ins_2_company',
				'SUM(FinalBilling.amount_collected_ins_company) as amount_collected_ins_company',
				'SUM(FinalBilling.amount_collected_ins_2_company) as amount_collected_ins_2_company',
				'DATE_FORMAT(LAST_DAY(FinalBilling.date),"%d") as DAY','MONTH(FinalBilling.date) as MONTH',
				'((SUM(FinalBilling.amount_pending_ins_company) - SUM(FinalBilling.amount_collected_ins_company)) + (SUM(FinalBilling.amount_pending_ins_2_company) - SUM(FinalBilling.amount_collected_ins_2_company))) as ins_bal'

		),
				'conditions'=>array('FinalBilling.discharge_date >='=>$fromdate,'FinalBilling.discharge_date <='=>$todate),'group' => array('TariffStandard.name')));
		$amountIc = 0;
		$count = count($insCompanyList) - 1;
		foreach ($insCompanyList as $key=>$data){
			if($key > 3){
				$amountIc = $amountIc + (int) $data['0']['ins_bal'];
				$var=(int) $data['0']['MONTH'];
				if($key < $count){
					continue;
				}
			}
			if($key < 4){
				$amountIc = $amountIc + (int) $data['0']['ins_bal'];
				$var=(int) $data['0']['MONTH'];
			}else{
				$amountIc = $amountIc + (int) $data['0']['ins_bal'];
				$var=(int) $data['0']['MONTH'];
			}
		}
		$this->set(compact('insCompanyList','amountIc','var'));
		$this->render('claim_balance_company_excel','');
	}


	//------yashwant Account receivable by patient------//

	public function account_receivable_patient(){
		$id = 85;
		$this->patient_info($id);
		//debug($this->request->data);//exit;
		$this->uses = array('FinalBilling');
		$this->FinalBilling->bindModel(array(
				'belongsTo' => array(
						'Patient' =>array('foreignKey' => false,'conditions'=>array('Patient.id=FinalBilling.patient_id')),
						'Person' =>array('foreignKey' => false,'conditions'=>array('Patient.patient_id=Person.patient_uid')),
						'DumpNote' =>array('foreignKey' => false,'conditions'=>array('DumpNote.patient_id=Patient.id'),'order'=>array('DumpNote.patient_id DESC')),
				)),false);
		$reportYear=date('Y');
		$fromdate=$reportYear."-01-01 00:00:00";
		$todate=$reportYear."-12-31 23:59:59";
		$patient = $this->request->data['patient'];
		$phone = $this->request->data['phone'];
		if(!empty($this->request->data)){
			if(!empty($patient) && empty($phone)){
				$condition = array('FinalBilling.discharge_date >='=>$fromdate,'FinalBilling.discharge_date <='=>$todate,'Patient.lookup_name like '=>'%'.$patient.'%');
			}
			elseif(empty($patient) && !empty($phone)){
				$condition =array('FinalBilling.discharge_date >='=>$fromdate,'FinalBilling.discharge_date <='=>$todate,'Patient.mobile_phone'=>$phone);
					
			}elseif(!empty($patient) && !empty($phone)){
				$condition = array('FinalBilling.discharge_date >='=>$fromdate,'FinalBilling.discharge_date <='=>$todate,'Patient.lookup_name like '=>$patient,'Patient.mobile_phone'=>$phone);
			}else{
				$condition = array('FinalBilling.discharge_date >='=>$fromdate,'FinalBilling.discharge_date <='=>$todate,'FinalBilling.location_id='.$this->Session->read('locationid').' || FinalBilling.location_id=0');
			}

			$this->paginate = array(
					'limit' => '20',
					'group' => 'Patient.lookup_name',
					'fields'=>array('Patient.lookup_name','Patient.mobile_phone','Person.dob','DumpNote.note',
							'SUM(FinalBilling.amount_pending_ins_company) as amount_pending_ins_company ','SUM(FinalBilling.amount_pending_ins_2_company) as amount_pending_ins_2_company',
							'SUM(FinalBilling.amount_collected_ins_company) as amount_collected_ins_company','SUM(FinalBilling.amount_collected_ins_2_company) as amount_collected_ins_2_company',
							'DATE_FORMAT(LAST_DAY(FinalBilling.date),"%d") as DAY','MONTH(FinalBilling.date) as MONTH',
							'((SUM(FinalBilling.amount_pending_ins_company) - SUM(FinalBilling.amount_collected_ins_company)) + (SUM(FinalBilling.amount_pending_ins_2_company) - SUM(FinalBilling.amount_collected_ins_2_company))) as ins_bal'),
					'conditions'=>$condition,
			);
			$insCompanyList = $this->paginate('FinalBilling');
			$amountIc = 0;
			$count = count($insCompanyList) - 1;
			foreach ($insCompanyList as $key=>$data){
				if($key > 3){
					$amountIc = $amountIc + (int) $data['0']['ins_bal'];
					$var=(int) $data['0']['MONTH'];
					if($key < $count){
						continue;
					}
				}
				if($key < 4){
					$amountIc = $amountIc + (int) $data['0']['ins_bal'];
					$var=(int) $data['0']['MONTH'];
				}else{
					$amountIc = $amountIc + (int) $data['0']['ins_bal'];
					$var=(int) $data['0']['MONTH'];
				}
			}
			$this->set(compact('insCompanyList','amountIc','var'));

		}else{
			$this->paginate = array(
					'limit' => '20',
					'group' => 'Patient.lookup_name',
					'fields'=>array('Patient.lookup_name','Patient.mobile_phone','Person.dob','DumpNote.note',
							'SUM(FinalBilling.amount_pending_ins_company) as amount_pending_ins_company ','SUM(FinalBilling.amount_pending_ins_2_company) as amount_pending_ins_2_company',
							'SUM(FinalBilling.amount_collected_ins_company) as amount_collected_ins_company','SUM(FinalBilling.amount_collected_ins_2_company) as amount_collected_ins_2_company',
							'DATE_FORMAT(LAST_DAY(FinalBilling.date),"%d") as DAY','MONTH(FinalBilling.date) as MONTH',
							'((SUM(FinalBilling.amount_pending_ins_company) - SUM(FinalBilling.amount_collected_ins_company)) + (SUM(FinalBilling.amount_pending_ins_2_company) - SUM(FinalBilling.amount_collected_ins_2_company))) as ins_bal'),
					'conditions'=>array('FinalBilling.discharge_date >='=>$fromdate,'FinalBilling.discharge_date <='=>$todate));
			$insCompanyList = $this->paginate('FinalBilling');
			$amountIc = 0;
			$count = count($insCompanyList) - 1;
			foreach ($insCompanyList as $key=>$data){
				if($key > 3){
					$amountIc = $amountIc + (int) $data['0']['ins_bal'];
					$var=(int) $data['0']['MONTH'];
					if($key < $count){
						continue;
					}
				}
				if($key < 4){
					$amountIc = $amountIc + (int) $data['0']['ins_bal'];
					$var=(int) $data['0']['MONTH'];
				}else{
					$amountIc = $amountIc + (int) $data['0']['ins_bal'];
					$var=(int) $data['0']['MONTH'];
				}
			}
			$this->set(compact('insCompanyList','amountIc','var'));
		}
	}

	public function search_patient($flag=null){
		$searchKey = $this->params->query['q'] ;
		$this->uses = array('FinalBilling');
		$this->FinalBilling->bindModel(array(
				'belongsTo' => array(
						'Patient' =>array('foreignKey' => false,'conditions'=>array('Patient.id=FinalBilling.patient_id')),
						'Person' =>array('foreignKey' => false,'conditions'=>array('Patient.patient_id=Person.patient_uid')),
				)),false);
		$reportYear=date('Y');
		$fromdate=$reportYear."-01-01 00:00:00";
		$todate=$reportYear."-12-31 23:59:59";
		$insCompanyList= $this->FinalBilling->find('all',array('fields'=>array('Patient.lookup_name','Patient.mobile_phone','Person.dob'),
				'conditions'=>array('FinalBilling.discharge_date >='=>$fromdate,'FinalBilling.discharge_date <='=>$todate,
						"OR"=>array("Patient.".$flag.' LIKE'=>"%$searchKey%")),'group' => array('Patient.lookup_name')));
		foreach ($insCompanyList as $key=>$value) {
			$var=$value['Patient'][$flag];
			echo "$var|$key\n";
		}
		exit;//dont remove this
	}

	public function print_account_receivable_patient(){
		$this->layout=false;
		$this->uses = array('FinalBilling');
		$this->FinalBilling->bindModel(array(
				'belongsTo' => array(
						'Patient' =>array('foreignKey' => false,'conditions'=>array('Patient.id=FinalBilling.patient_id')),
						'Person' =>array('foreignKey' => false,'conditions'=>array('Patient.patient_id=Person.patient_uid')),
						'DumpNote' =>array('foreignKey' => false,'conditions'=>array('DumpNote.patient_id=Patient.id'),'order'=>array('DumpNote.patient_id DESC')),
				)),false);
		$reportYear=date('Y');
		$fromdate=$reportYear."-01-01 00:00:00";
		$todate=$reportYear."-12-31 23:59:59";
		$patient = $this->request->data['patient'];
		$phone = $this->request->data['phone'];
		$insCompanyList= $this->FinalBilling->find('all',array('fields'=>array('Patient.lookup_name','Patient.mobile_phone','Person.dob','DumpNote.note',
				'SUM(FinalBilling.amount_pending_ins_company) as amount_pending_ins_company ','SUM(FinalBilling.amount_pending_ins_2_company) as amount_pending_ins_2_company',
				'SUM(FinalBilling.amount_collected_ins_company) as amount_collected_ins_company','SUM(FinalBilling.amount_collected_ins_2_company) as amount_collected_ins_2_company',
				'DATE_FORMAT(LAST_DAY(FinalBilling.date),"%d") as DAY','MONTH(FinalBilling.date) as MONTH',
				'((SUM(FinalBilling.amount_pending_ins_company) - SUM(FinalBilling.amount_collected_ins_company)) + (SUM(FinalBilling.amount_pending_ins_2_company) - SUM(FinalBilling.amount_collected_ins_2_company))) as ins_bal'),
				'conditions'=>array('FinalBilling.discharge_date >='=>$fromdate,'FinalBilling.discharge_date <='=>$todate),
				'group' => array('Patient.lookup_name')));
		$amountIc = 0;
		$count = count($insCompanyList) - 1;
		foreach ($insCompanyList as $key=>$data){
			if($key > 3){
				$amountIc = $amountIc + (int) $data['0']['ins_bal'];
				$var=(int) $data['0']['MONTH'];
				if($key < $count){
					continue;
				}
			}
			if($key < 4){
				$amountIc = $amountIc + (int) $data['0']['ins_bal'];
				$var=(int) $data['0']['MONTH'];
			}else{
				$amountIc = $amountIc + (int) $data['0']['ins_bal'];
				$var=(int) $data['0']['MONTH'];
			}
		}
		$this->set(compact('insCompanyList','amountIc','var'));
	}

	public function account_receivable_patient_excel(){
		$this->uses = array('FinalBilling');
		$this->FinalBilling->bindModel(array(
				'belongsTo' => array(
						'Patient' =>array('foreignKey' => false,'conditions'=>array('Patient.id=FinalBilling.patient_id')),
						'Person' =>array('foreignKey' => false,'conditions'=>array('Patient.patient_id=Person.patient_uid')),
						'DumpNote' =>array('foreignKey' => false,'conditions'=>array('DumpNote.patient_id=Patient.id'),'order'=>array('DumpNote.patient_id DESC')),
				)),false);
		$reportYear=date('Y');
		$fromdate=$reportYear."-01-01 00:00:00";
		$todate=$reportYear."-12-31 23:59:59";
		$patient = $this->request->data['patient'];
		$phone = $this->request->data['phone'];
		$insCompanyList= $this->FinalBilling->find('all',array('fields'=>array('Patient.lookup_name','Patient.mobile_phone','Person.dob','DumpNote.note',
				'SUM(FinalBilling.amount_pending_ins_company) as amount_pending_ins_company ','SUM(FinalBilling.amount_pending_ins_2_company) as amount_pending_ins_2_company',
				'SUM(FinalBilling.amount_collected_ins_company) as amount_collected_ins_company','SUM(FinalBilling.amount_collected_ins_2_company) as amount_collected_ins_2_company',
				'DATE_FORMAT(LAST_DAY(FinalBilling.date),"%d") as DAY','MONTH(FinalBilling.date) as MONTH',
				'((SUM(FinalBilling.amount_pending_ins_company) - SUM(FinalBilling.amount_collected_ins_company)) + (SUM(FinalBilling.amount_pending_ins_2_company) - SUM(FinalBilling.amount_collected_ins_2_company))) as ins_bal'),
				'conditions'=>array('FinalBilling.discharge_date >='=>$fromdate,'FinalBilling.discharge_date <='=>$todate),
				'group' => array('Patient.lookup_name')));
		$amountIc = 0;
		$count = count($insCompanyList) - 1;
		foreach ($insCompanyList as $key=>$data){
			if($key > 3){
				$amountIc = $amountIc + (int) $data['0']['ins_bal'];
				$var=(int) $data['0']['MONTH'];
				if($key < $count){
					continue;
				}
			}
			if($key < 4){
				$amountIc = $amountIc + (int) $data['0']['ins_bal'];
				$var=(int) $data['0']['MONTH'];
			}else{
				$amountIc = $amountIc + (int) $data['0']['ins_bal'];
				$var=(int) $data['0']['MONTH'];
			}
		}
		$this->set(compact('insCompanyList','amountIc','var'));
		$this->render('account_receivable_patient_excel','');
	}

	public function claimManager($id){
		$this->uses = array('Patient','TariffStandard','FinalBilling','Encounter','NewInsurance','SubClaim');
		$this->set('Patients_id',$id);
		if((isset($this->request->data)) && (!empty($this->request->data))){
			//debug($this->request->data);
			//exit;
		}
		$this->NewInsurance->bindModel(array(
				'hasMany' => array(
						'Secondary' =>array('className'=>'NewInsurance',
								'foreignKey'=>'refference_id')),
				'belongsTo' => array(
						'Patient' =>array('foreignKey' => false,'conditions'=>array('NewInsurance.patient_id=Patient.id')),
						'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id')),
						'Encounter' =>array('foreignKey' => false,'conditions'=>array('Encounter.new_insurance_id=NewInsurance.id')),
						'Batch' =>array('foreignKey' => false,'conditions'=>array('Batch.patient_ids=NewInsurance.patient_id'))
						)));	
		
		//'Batch' =>array('foreignKey' => false,'conditions'=>array('Batch.patient_ids=NewInsurance.patient_id'))
				
		$pairData=$this->NewInsurance->find('all',array('conditions'=>array('NewInsurance.patient_id'=>$id,'NewInsurance.refference_id'=>null),
				'fields'=>array('Patient.lookup_name','User.first_name','User.last_name','Patient.id','Encounter.id',
						'NewInsurance.tariff_standard_name','NewInsurance.tariff_standard_id','NewInsurance.patient_id','Encounter.payment_amount',
						'Encounter.file_with','Encounter.new_insurance_id','Batch.file_created','Batch.batch_name')));
		
		//debug($pairData);
		//,'Batch.file_created'
	
		/*if(empty($pairData)){
			debug('hi');
			$pairData=$this->NewInsurance->find('all',array('conditions'=>array('NewInsurance.patient_id'=>$id,'NewInsurance.refference_id'=>null),
					'fields'=>array('Patient.lookup_name','User.first_name','User.last_name','Patient.id','Encounter.id',
							'NewInsurance.tariff_standard_name','NewInsurance.tariff_standard_id','Encounter.payment_amount',
							'Encounter.file_with','Encounter.new_insurance_id','Batch.file_created')));
			
		}*/
	
		$this->set('pairData',$pairData);
	}

	/***********EOF Account Receivable Managment- by yashwant************/



	/***************BOF Comparative analytics- Pooja****************************/

	public function comparative_analytic(){
		$this->uses = array('Encounter','FinalBilling','Billing','Patient','ClaimTransaction');
		//Most unexpected denials graph
		$denials=$this->Encounter->find('all',array('fields'=>array('count(*) as denialCount','Encounter.claim_status_code'),
				'conditions'=>array('Encounter.claim_status LIKE'=>"%".denied."%"),'group'=>array('Encounter.claim_status_code')));

		$this->Billing->bindModel(array(
				'belongsTo' => array(
						'Patient' =>array('foreignKey' => false,'conditions'=>array('Patient.id=Billing.patient_id')),
						//'FinalBilling' =>array('foreignKey' => false,'conditions'=>array('FinalBilling.patient_id=Billing.patient_id')),
				)),false);
			
		$fromDate = date('Y-01-01 00:00:00');
		$toDate = date('Y-12-31 23:59:59');
		$billingConditions = array('DATE_FORMAT(Billing.date, "%Y-%m") BETWEEN ? AND ?' => array($fromDate,$toDate),'Billing.location_id'=>$this->Session->read('locationid'));
		$billingData = $this->Billing->find('all',array('conditions' => $billingConditions,'fields'=>array('Patient.id','Billing.patient_id','Patient.form_received_on','Billing.date')
				,'group' => array('Patient.id'),'order'=>array('Patient.form_received_on DESC')));
		$t1=0;$t2=0;$t3=0;$t4=0;$t5=0;$t6=0;$t7=0;

		//Adjudication graph
		$this->ClaimTransaction->bindModel(array(
				'belongsTo'=>array(
						'ClaimReasonCode'=>array('foreignKey'=>false,'conditions'=>array('ClaimReasonCode.reason_code=ClaimTransaction.claim_reason_code')))));

		$payer=$this->ClaimTransaction->find('all',array('fields'=>array('count(ClaimTransaction.claim_reason_code) as expected','ClaimTransaction.id','ClaimTransaction.claim_reason_code','ClaimReasonCode.id','ClaimReasonCode.reason_code'),'conditions'=>array('ClaimTransaction.claim_status'=>array('Rejection'),'ClaimTransaction.is_deleted'=>'0','ClaimTransaction.claim_reason_code <>'=>null),'group'=>array('ClaimReasonCode.is_expected')));
		$paid=$this->ClaimTransaction->find('all',array('fields'=>array('count(ClaimTransaction.claim_status) as paid','ClaimTransaction.id','ClaimTransaction.claim_reason_code'),'conditions'=>array('ClaimTransaction.claim_status'=>array('Paid'),'ClaimTransaction.is_deleted'=>'0')));
		//debug($paid);exit;
		//For counting the data in specific days interval for payment velocity chart
		foreach($billingData as $velocity)
		{

			$diff=$this->DateFormat->dateDiff($velocity['Patient']['form_received_on'],$velocity['Billing']['date']);
			if($diff->days>=0&&$diff->days<=30){
				$t1=$t1+1;
				$vel['0']=$t1;
			}
			elseif($diff->days>=31&&$diff->days<=60){
				$t2=$t2+1;
				$vel['31']=$t2;
			}
			elseif($diff->days>=61&&$diff->days<=90){
				$t3=$t3+1;
				$vel['61']=$t3;
			}
			elseif($diff->days>=91&&$diff->days<=120){
				$t4=$t4+1;
				$vel['91']=$t4;
			}
			elseif($diff->days>=121&&$diff->days<=150){
				$t5=$t5+1;
				$vel['121']=$t5;
			}
			elseif($diff->days>=151&&$diff->days<=180){
				$t6=$t6+1;
				$vel['151']=$t6;
			}
			elseif($diff->days>180){
				$t7=$t7+1;
				$vel['180+']=$t7;
			}
		}
		// for sorting the array by key
		ksort($vel);
		$this->set('denials',$denials);
		$this->set('velocity',$vel);
		$this->set(compact('paid','payer'));

	}
	/**********************************EOF*****************************/
	//***********************************Claim DashBoard********************************************
	// Author:- Aditya Chitmitwar
	public function claimSubmissionDashBoard(){
		$this->layout = 'advance';
		/* $my_file ="files".DS."claims".DS.claim."_".batch."_".date('Y-m-d').".txt";
			//$getText=file_get_contents($my_file);
		//print_r(strlen($getText));
		$file = fopen($my_file,"r");

		while (! feof ($file))
		{
		if(fgetc!=' ')
			echo fgetc($file);
		else
			echo ("aditya");
		}

		fclose($file);
		exit;
		*/
	}
	public function addBatch(){
		$this->layout=ajax;
		$this->uses=array('NewInsurance','Batch','Encounter','SubClaim','Patient');
		$this->Encounter->bindModel(array(
				'belongsTo' => array(
						'Patient' =>array('foreignKey'=>false,'conditions'=>array('Patient.id=Encounter.patient_id')),
						'NewInsurance' =>array('foreignKey'=>false,'conditions'=>array('NewInsurance.patient_id=Encounter.patient_id')),
						'TariffStandard' =>array('foreignKey'=>false,'conditions'=>array('TariffStandard.id=NewInsurance.tariff_standard_id')),

				)),true);
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				//'order'=>array('Person.create_time' => 'DESC'),
				//'group'=>array('Patient.patient_id'),
				'fields'=>array('Encounter.id','Encounter.primary_insurance','Encounter.claim_type','Encounter.file_with'
				,'Encounter.new_insurance_id','Encounter.patient_id','Patient.lookup_name','Patient.patient_id','Patient.age','Patient.sex','Patient.id','NewInsurance.tariff_standard_id',
				'NewInsurance.tariff_standard_name','TariffStandard.payer_id'),
				'conditions'=>array('Encounter.patient_id !='=>'','Encounter.new_insurance_id !='=> '')
		);
		/* $dashBoard=$this->paginate('Encounter',array('fields'=>array('Encounter.id','Encounter.primary_insurance','Encounter.claim_type','Encounter.file_with'
				,'Encounter.new_insurance_id','Encounter.patient_id','Patient.lookup_name','Patient.patient_id','Patient.age','Patient.sex','Patient.id','NewInsurance.tariff_standard_id',
				'NewInsurance.tariff_standard_name'),'conditions'=>array('Encounter.patient_id !='=>'','Encounter.new_insurance_id !='=> ''),'group'=>array('Patient.patient_id')));
		 */
		$dashBoard=$this->paginate('Encounter');
		$this->set('dashBoard',$dashBoard);
		if(isset($this->request->data) &&(!empty($this->request->data))){
			$cnt=count($this->request->data['checkName']);
			for($i=0;$i<$cnt;$i++){
				if($this->request->data['checkName'][$i]!='0')
					$dataArray[]=$this->request->data['checkName'][$i];
			}
			$member_in_batch=count($dataArray);
			for($j=0;$j<count($dataArray);$j++){
				$expl=explode(',',$dataArray[$j]);
				$patientsIds[]=$expl['0'];
				$returnData=$this->generateClaim($expl['0'],$expl['1'],$expl['2'],$expl['3'],$j,(count($dataArray)-1));
				$batchFileText.=$returnData;
			}
			$explogroup_control_number=explode('GE*1*',$returnData);
			$exploImp1group_control_number=explode('~',$explogroup_control_number[1]);
			$group_control_number=$exploImp1group_control_number[0];
			$patientsIds=implode(',',$patientsIds);
			$expCurrentDate=explode('/',date("Y/m/d"));
			$batch_name=$expCurrentDate['0'].$expCurrentDate['1'].$expCurrentDate['2'].'_Batch'.rand(10,100);
			$this->uses=array('Batch');
			$data['Batch'][batch_name]=$batch_name;
			$data['Batch'][batch_data]=$batchFileText;
			$data['Batch'][group_control_number]=$group_control_nnumber;
			$data['Batch'][member_in_batch]=$member_in_batch;
			$data['Batch'][patient_ids]=$patientsIds;
			$data['Batch'][location_id]=$this->Session->read(locationid);
			$data['Batch'][created_time]=date('Y/m/d H:i:s');
			if($this->Batch->save($data)){
				$this->Session->setFlash(__('Batch Created Successfully'));
				$this->redirect('/Insurances/addBatch');
				$this->Session->setFlash(__('Batch Created Successfully'));
			}
		}
	}
	public function newPayer(){
		$this->layout=ajax;
		$this->uses=array('NewInsurance','TariffStandard');
		$getPayerName=$this->TariffStandard->find('list',array('conditions'=>array(''),'feilds'=>array('TariffStandard.id','TariffStandard.name')));
		$this->set('getPayerName',$getPayerName);
	}
	public function findBatch(){
		$this->layout=ajax;
		$this->uses=array('Batch');
		$this->paginate = array(
				'limit' => 5,
				'order' => array('Batch.id' => 'desc'),
				'conditions'=>array('is_batch'=>'0')
		);
		$getBatch=$this->paginate('Batch');
		//$getBatch=$this->Batch->find('all',array('conditions'=>array('is_batch'=>'0')));
		$this->set('getBatch',$getBatch);
		echo $this->render('find_batch');
		exit;

	}
	public function findPayer(){
		$this->layout=ajax;
		$this->uses=array('Batch');
		$this->paginate = array(
				'limit' => 5,
				'order' => array('Batch.id' => 'desc'),
				'conditions'=>array('is_payer'=>'1')
		);
		$getBatch=$this->paginate('Batch');
		$this->set('getBatch',$getBatch);
		echo $this->render('find_payer');
		exit;
	
	}
	public function patientInBatch($id){
		$this->layout=ajax;
		$this->uses=array('Batch','Patient','NewInsurance');
		$patientInBatch=$this->Batch->find('first',array('conditions'=>array('id'=>$id),'fields'=>array('patient_ids')));
		$explodePatientId=explode(',',$patientInBatch['Batch']['patient_ids']);
		$this->NewInsurance->bindModel(array(
				 'hasMany' => array(
						'Secondary' =>array('className'=>'NewInsurance','foreignKey'=>refference_id)), 
				'belongsTo' => array(
						'Patient' =>array('foreignKey'=>false,'fields'=>array('Patient.lookup_name','Patient.patient_id','Patient.age','Patient.sex'),
								'conditions'=>array('Patient.id=NewInsurance.patient_id')),
				)));
		$getpatientInBatch=$this->NewInsurance->find('all',array('conditions'=>array('NewInsurance.patient_id'=>$explodePatientId,
				'NewInsurance.refference_id'=>''),'group'=>array('NewInsurance.patient_id')));
		$this->set('getpatientInBatch',$getpatientInBatch);
	}
	public function patientInPayer($id){
		$this->layout=ajax;
		$this->uses=array('Batch','Patient','NewInsurance');
		$patientInBatch=$this->Batch->find('first',array('conditions'=>array('id'=>$id),'fields'=>array('patient_ids')));
		$explodePatientId=explode(',',$patientInBatch['Batch']['patient_ids']);
		$this->NewInsurance->bindModel(array(
				'hasMany' => array(
						'Secondary' =>array('className'=>'NewInsurance','foreignKey'=>refference_id)),
				'belongsTo' => array(
						'Patient' =>array('foreignKey'=>false,'fields'=>array('Patient.lookup_name','Patient.patient_id','Patient.age','Patient.sex'),
								'conditions'=>array('Patient.id=NewInsurance.patient_id')),
				)));
		$getpatientInBatch=$this->NewInsurance->find('all',array('conditions'=>array('NewInsurance.patient_id'=>$explodePatientId,
				),'group'=>array('NewInsurance.patient_id')));
		$this->set('getpatientInBatch',$getpatientInBatch);
	}
	public function downloadEdi($fname=null){
		$this->layout = false ;
		$this->autoRender = false ;
		$fname = $fname.".CLP";
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.$fname);
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: '.filesize($fname));
		readfile(Configure::read('generated_edi').$fname);
	}
	
	public function downloadCMSForm1500(){
		$this->layout = false ;
		$this->autoRender = false ;
		$fname = "CMS_Formtest.pdf";
		/* header('Content-Type: application/pdf');
		header('Content-Disposition: attachment; filename='.$fname);
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: '.filesize($fname)); */
		header('Content-type: "application/octet-stream"; charset="utf8"');
		header('Content-disposition: attachment; filename="'.$fname.'"');
		header('Content-Transfer-Encoding: binary');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		ob_clean();
		flush();
		//readfile($zipname);
		readfile("files/".$fname);
	}
	public function readBatch($id){
		$this->layout=ajax;
		$this->autoRender=false;
		$this->uses=array('Batch');
		$readBatch=$this->Batch->find('first',array('conditions'=>array('id'=>$id),'fields'=>array('batch_data','batch_name')));
		if(!empty($readBatch)){
			$ediFileName = "files/Edi_files/".$readBatch['Batch']['batch_name'].'.'.CLP;
			$myFileHandle = fopen($ediFileName, 'w') or die("can't open file");
			fwrite($myFileHandle, $readBatch['Batch']['batch_data']);
			fclose($ediFileName);
			$readBatch=$this->Batch->updateAll(array('file_created'=>'1'),array('id'=>$id));
			return true;;
		}
		else{
			return false;
		}

	}
	public function newPayerList($id=null){
		$this->layout=ajax;
		$this->uses=array('NewInsurance','TariffStandard','Encounter');
		if(empty($this->request->data)){
			$this->NewInsurance->bindModel(array(
					'belongsTo' => array(
							'Patient' =>array('foreignKey'=>false,'conditions'=>array('Patient.id=NewInsurance.patient_id')),
							'Encounter' =>array('foreignKey'=>false,'conditions'=>array('Encounter.patient_id=Patient.id')),
								
					)),true);
			$this->paginate = array(
					'limit' => 5,
					'order' => array('NewInsurance.id' => 'desc'),
					'conditions'=>array('NewInsurance.tariff_standard_id'=>$id),
					'fields'=>array('Encounter.id','Encounter.primary_insurance','Encounter.claim_type','Encounter.file_with'
							,'Encounter.new_insurance_id','Encounter.patient_id','Patient.lookup_name','Patient.patient_id','Patient.age','Patient.sex','Patient.id','NewInsurance.id','NewInsurance.patient_id','NewInsurance.tariff_standard_id',
							'NewInsurance.tariff_standard_name')
			);
			$getPayer=$this->paginate('NewInsurance');
			$this->set('getPayer',$getPayer);
			echo $this->render('new_payer_list');
			exit;
		}
		if(isset($this->request->data) &&(!empty($this->request->data))){
			$cnt=count($this->request->data['checkName']);
			for($i=0;$i<$cnt;$i++){
				if($this->request->data['checkName'][$i]!='0')
					$dataArray[]=$this->request->data['checkName'][$i];
			}
			$member_in_batch=count($dataArray);
			for($j=0;$j<count($dataArray);$j++){
				$expl=explode(',',$dataArray[$j]);
				$patientsIds[]=$expl['0'];
				$returnData=$this->generateClaim($expl['0'],$expl['1'],$expl['2'],$expl['3'],$j,(count($dataArray)-1));	
				$batchFileText.=$returnData;
			}
			$explogroup_control_number=explode('GE*1*',$returnData);
			$exploImp1group_control_number=explode('~',$explogroup_control_number[1]);
			$group_control_number=$exploImp1group_control_number[0];
			$patientsIds=implode(',',$patientsIds);
			$expCurrentDate=explode('/',date("Y/m/d"));
			$batch_name=$expCurrentDate['0'].$expCurrentDate['1'].$expCurrentDate['2'].'_PayarBatch'.rand(10,100);
			$this->uses=array('Batch');
			$data['Batch'][batch_name]=$batch_name;
			$data['Batch'][batch_data]=$batchFileText;
			$data['Batch'][group_control_number]=$group_control_number;
			$data['Batch'][member_in_batch]=$member_in_batch;
			$data['Batch'][patient_ids]=$patientsIds;
			$data['Batch'][is_payer]='1';
			$data['Batch'][location_id]=$this->Session->read(locationid);
			$data['Batch'][created_time]=date('Y/m/d H:i:s');
			if($this->Batch->save($data)){
				$this->Session->setFlash(__('Payer Mapping  Created Successfully'));
				$this->redirect('/Insurances/newPayer');
				$this->Session->setFlash(__('Batch Created Successfully'));
			}
			else{
				$this->Session->setFlash(__('Payer Mapping Failed'));

			}
		}
	}
	
	//**************************************Claim DashBoard EOF***********************************************************************************************************
	public function initialPdf($patient_id){
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
		$this->set('id',$patient_id);
		$this->set('registrar',$this->DoctorProfile->getDoctorByID($diagnosisRec['Diagnosis']['register_sb']));
		$this->set('consultant',$this->DoctorProfile->getDoctorByID($diagnosisRec['Diagnosis']['consultant_sb']));
		$this->render('initial_pdf','pdf');
		
	}
	
	
	public function soapPdf($notes_id=null, $patient_id=null, $search=null) {
	
		$this->uses = array('Hpi','Note','NoteDiagnosis','SuggestedDrug','Template','User','Consultant','icd','Finalization','TemplateTypeContent','NewCropAllergies','PlannedProblem','NewCropPrescription','LaboratoryToken','Laboratory','LaboratoryTestOrder','RadiologyTestOrder','Radiology');
		//$this->layout = 'ajax';
		if (!$notes_id) {
			$this->Session->setFlash(__('Invalid Note', true, array('class'=>'error')));
			$this->redirect(array("controller" => "notes", "action" => "patient_notes"));
		}
		$notesRec = $this->Note->read(null,$notes_id);
		$suggestedDrugRec = $this->SuggestedDrug->find('all',array('fields'=>array('SuggestedDrug.*,PharmacyItem.name,PharmacyItem.pack'),
				'conditions'=>array('note_id'=>$notes_id)));
	
		$this->set('icd_ids',array());
		$count = count($suggestedDrugRec);
	
	
		$icdC = explode('|',$notesRec['Note']['icd']);
		$problemName =array();
		for($i=0;$i<count($icdC);$i++){
			$problemName[] = end(explode('::',$icdC[$i]));
		}
		$visittype = explode('|',$notesRec['Note']['visitid']);
		$visit = $this->Finalization->find('all',array('conditions'=>array('id'=>$visittype)));
	
		//bind for retriving serialized data's value
		/* $this->TemplateTypeContent->bindModel(array(
		 'belongsTo' => array(
		 		'Template' =>array(
		 				'foreignKey'=>false,'conditions'=>array('TemplateTypeContent.template_id=Template.id'))),
				'hasMany'=>array(
						'TemplateSubCategories' =>array(
								'foreignKey'=>'template_id','conditions'=>array('TemplateSubCategories.is_deleted=0')
						))));
	
		$review = $this->TemplateTypeContent->find('all',array('conditions'=>array('note_id'=>$notes_id)));
		$this->set('review',$review); */
	
		//BOF review of system by pooja
		$this->Template->bindModel(array(
				'hasMany' => array(
						'TemplateSubCategories' =>array(
								'foreignKey'=>'template_id','conditions'=>array('TemplateSubCategories.is_deleted=0')
						),
				)));
		$roseData=$this->Template->find('all',array('conditions'=>array('Template.is_deleted=0')));
		$reviewData = $this->TemplateTypeContent->find('list',array('fields'=>array('template_id','template_subcategory_id'),'conditions'=>array('note_id'=>$notes_id))) ;
		$this->set('rosData',$roseData); // category
		$this->set('templateTypeContent',$reviewData); //user selected serialized data
	
		//EOF review of system
	
		$Hpi = $this->TemplateTypeContent->find('list',array('fields'=>array('template_id','template_subcategory_id'),'conditions'=>array('note_id =0'))) ;
		$this->set(compact('Hpi'));
	
		$assesment=$this->NoteDiagnosis->find('list',array('fields'=>array('id','diagnoses_name'),'conditions'=>array('patient_id'=>$patient_id),'order' => array('diagnoses_name ASC')));
		$this->set(compact('assesment'));
	
		$allergies = $this->NewCropAllergies->find('all',array('conditions'=>array('patient_uniqueid'=>$patient_id)));
		$this->set('allergies',$allergies);
	
		$medication = $this->NewCropPrescription->find('all',array('conditions'=>array('patient_uniqueid'=>$patient_id)));
		$this->set('medication',$medication);
	
		$planned = $this->PlannedProblem->find('all',array('conditions'=>array('patient_id'=>$patient_id)));
		$this->set('planned',$planned);
		$this->set('registrar',$this->User->getDoctorByID($notesRec['Note']['sb_registrar']));
		$this->set('consultant',$this->User->getDoctorByID($notesRec['Note']['sb_consultant']));
		$this->set('note', $notesRec);
		$this->set('icddesc', $problemName);
		$this->set('visittyp', $visit); 
		//debug($visit);// pr($visit);
		$this->set('medicines',$suggestedDrugRec);//----------------------//
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
		$this->render('soap_pdf','pdf');
	
	}
		public function hpiPdf($patient_id){
			$this->layout=ajax;
			$this->uses=array('Template','TemplateTypeContent','Hpi','Note');
			$this->patient_info($patient_id);
			//-------------------------------------------------------------------------------------------------------------------
			$this->Template->bindModel(array(
					'hasMany' => array(
							'TemplateSubCategories' =>array(
									'foreignKey'=>'template_id','conditions'=>array('TemplateSubCategories.is_deleted=0')
							),
					)));
			$roseData=$this->Template->find('all',array('conditions'=>array('Template.template_category_id'=>3,'Template.is_deleted=0')));
			$this->set('roseData',$roseData);
			$this->set('templateTypeContent',$this->TemplateTypeContent->find('list',array('fields'=>array('template_id','template_subcategory_id'),'conditions'=>array('patient_id'=>$patient_id))));
			$this->set('patientId',$patient_id);
			//$getSelectedHpi=$this->Hpi->find('all',array('conditions'=>array('patient_id'=>$patient_id)));
			//$this->set('getSelectedHpi',$getSelectedHpi);
			$getChiefComplaints=$this->Note->find('first',array('conditions'=>array('patient_id'=>$patient_id),'fields'=>array('cc')));
			$this->set('getChiefComplaints',$getChiefComplaints);
			//-----------------------------------------------------------------------------------------------------------------------------------------------
				
			if(isset($this->request->data) && !empty($this->request->data)){
				$patientId=$this->request->data['Patient']['patientId'];
				$categoryData=$this->TemplateTypeContent->insertCategory($this->request->data['TemplateTypeContent'],'0',$patientId);
				if($categoryData=='1')
					$this->Session->setFlash(__('HPI Recorded Sucessfully', true));
				$this->redirect('/PatientForms/hpiCall/'.$patient_id);
			}
			$this->render('hpi_pdf','pdf');
	}
	public function eligibilityCheck($patientId){
	$this->uses=array('NewInsurance');
		$this->autoRender=false;
		$this->NewInsurance->updateAll(array('is_eligible'=>'1'),array('patient_id'=>$patientId));
		echo true;exit;
		
	}	
	function updateInsurance(){
		$this->uses=array('Patient');		
		/*if($this->request->data){		
			if(!empty($this->request->data['NewInsurance']['id'])){
				$tariff_standard_name=$this->request->data['NewInsurance']['tariff_standard_name'];
				$insurance_number=$this->request->data['NewInsurance']['insurance_number'];
				$is_formulatory_check=$this->request->data['NewInsurance']['is_formulatory_check'];
				$is_active=$this->request->data['NewInsurance']['is_active'];
				$id=$this->request->data['NewInsurance']['id'];
				$updateArray=array('NewInsurance.id'=>"'$id'",'NewInsurance.tariff_standard_name'=>"'$tariff_standard_name'",'NewInsurance.insurance_number'=>"'$insurance_number'",'NewInsurance.is_formulatory_check'=>"'$is_formulatory_check'",'NewInsurance.is_active'=>"'$is_active'");
				$res = $this->NewInsurance->updateAll($updateArray,array('patient_id'=>$this->request->data['NewInsurance']['patient_id']));
			}else{			
				$this->NewInsurance->save($this->request->data);				
				exit;
			}			
		}*/
		if($this->request->data){			
			$insurance_company_name=$this->request->data['Patient']['insurance_company_name'];			
			$patient_health_plan_id=$this->request->data['Patient']['patient_health_plan_id'];	
			$patient_id=$this->request->data['Patient']['id'];			
			$updateArray['Patient']['insurance_company_name'] = "'$insurance_company_name'";
			$updateArray['Patient']['patient_health_plan_id']="'$patient_health_plan_id'";					
			$res = $this->Patient->updateAll($updateArray['Patient'],array('id'=>$patient_id));			
		}	
		exit;
	}
	
	public function cmsForm1500($id=null,$payer_selected_id=null){
		
	$this->layout='advance_ajax';
		//$payer_selected_id="60";
		//$claimNumber="1";
		$ST2=str_pad($claim_id, 9, '0', STR_PAD_LEFT);//9 digit number required : Generated from claim id
		$groupControlNumber=str_pad(rand(10,100).$id, 9, '0', STR_PAD_RIGHT);//Generated from random function and patient id
		//$groupControlNumber=str_pad(date("Ymd"), 9, '0', STR_PAD_RIGHT);//Generated from random function and patient id
		$isaseg13=str_pad(date("Ymd"), 9, '0', STR_PAD_LEFT);//Generated from claim id, patient id and payer selected id : 9 digit number required
	
	
		$this->uses = array('Insurance','Location','City','State','Country','Patient','Person','NewInsurance','TariffStandard','Encounter','TariffList','TariffAmount','ProcedurePerform','NoteDiagnosis');
		if($claimtype==1500)
		{
			$controlVersionNumber="00501"; //Interchange control Version Number
			$controlNumber="005010X222A1"; //Interchange control Number  //004010X098A1
		}
		else
		{
			$controlVersionNumber="00401"; //Interchange control Version Number
			$controlNumber="005010X222"; //Interchange control Number
		}
		$zirmed_client_accountid=Configure::read('zirmed_client_accountid')."          ";//length 15 followed by spaces
		$currentdate=date("Ymd");
		$currentdate_ISA=date("ymd");
		$currentTime=date("Hi", time());
		$ackrequest=1;//value can be 0 or 1
		$bht_transactionset_purposecode="00";//value can be 00 - Original, 18 - Reissue
		$bht_reference_identification="Drm".$claim_id.$id.time().$claimtype;//still not clear
		$taxanomy_code="282E00000X";
	
	
	
	
	
		//find claim data from encounter table
		$claim_encounter = $this->Encounter->find('first', array('conditions'=>array('Encounter.id'=>$claim_id)));
		//debug($claim_encounter);
	
		//$totalClaimAmount=$claim_encounter["[Encounter"]["payment_amount"]; //Calculated from SUM (charge*units)
	
		//$totalClaimAmount="1000";
	
		//find place
		//$placeOfService=$claim_encounter["[Encounter"]["place_of_facility"];
		$placeOfService="21";
	
		//find hospital location, state, city
		$hospital_location = $this->Location->find('first', array('fields'=> array('Location.id', 'Location.name','Location.address1','Location.address2','Location.zipcode','Location.city_id','Location.state_id','Location.country_id','Location.phone1','Location.mobile','Location.fax','Location.hospital_npi','Location.hospital_service_tax_no'),'conditions'=>array('Location.id'=>$this->Session->read('locationid'), 'Location.is_active' => 1, 'Location.is_deleted' => 0)));
	
		$city_location = $this->City->find('first', array('fields'=> array('City.name'),'conditions'=>array('City.id'=>$hospital_location['Location']['city_id'])));
	
		$state_location = $this->State->find('first', array('fields'=> array('State.state_code'),'conditions'=>array('State.id'=>$hospital_location["Location"]["state_id"])));
	
		$country_location = $this->Country->find('first', array('fields'=> array('Country.name'),'conditions'=>array('Country.id'=>$hospital_location['Location']['country_id'])));
	
		$this->Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
	
		$UIDpatient_details  = $this->Person->getUIDPatientDetailsByPatientID($id);
		
	
		
		
		$this->loadModel("Facility");
		$this->Facility->unBindModel(array(
				'hasOne'=>array('FacilityDatabaseMapping','FacilityUserMapping')
		));
	
		$facility = $this->Facility->find('first', array('fields'=> array('Facility.id','Facility.name','Facility.address1','Facility.zipcode','Facility.city_id','Facility.state_id'),'conditions'=>array('Facility.is_deleted' => 0, 'Facility.is_active' => 1,'Facility.id' => $this->Session->read("facilityid"))));
	
		$city_facility = $this->City->find('first', array('fields'=> array('City.name'),'conditions'=>array('City.id'=>$facility['Facility']['city_id'])));
	
		$state_facility = $this->State->find('first', array('fields'=> array('State.state_code'),'conditions'=>array('State.id'=>$facility["Facility"]["state_id"])));
		
		
		
		
		//find subscriber country
	
		$subscriber_countryname = $this->Country->find('first', array('fields'=> array('Country.name'),'conditions'=>array('Country.id'=>$UIDpatient_details['Person']['country'])));
		//subscriber Sex
		$gender=$UIDpatient_details['Person']['sex'];
		if($gender=='Male' or $gender=='M')
			$gendervalue="M";
		else
			$gendervalue="F";
	
		$patientdob=str_replace("-", "", $UIDpatient_details["Person"]["dob"]);//CCYYMMDD format required
		
		$state_location_patient = $this->State->find('first', array('fields'=> array('State.state_code'),'conditions'=>array('State.id'=>$UIDpatient_details['Person']['state'])));
	
	
		
	
	
		//find payer information of claim from tariff_standards table
		$payer_details = $this->TariffStandard->find('first', array('fields'=> array('TariffStandard.name','TariffStandard.payer_id','TariffStandard.professional_claims','TariffStandard.institutional_claims','TariffStandard.remits','TariffStandard.eligibility','TariffStandard.claim_status_zirmed','TariffStandard.plot_no','TariffStandard.landmark','TariffStandard.pin_code','TariffStandard.city','TariffStandard.state','TariffStandard.country'),'conditions'=>array('TariffStandard.id'=>$payer_selected_id)));
		//find insurance detail from new_insurances table for patient
		$patient_insurance_details = $this->NewInsurance->find('first', array('fields'=> array('NewInsurance.priority','NewInsurance.relation','NewInsurance.subscriber_name','NewInsurance.subscriber_last_name'
				,'NewInsurance.subscriber_dob','NewInsurance.subscriber_gender','NewInsurance.subscriber_security','NewInsurance.subscriber_address1','NewInsurance.subscriber_address2'
				,'NewInsurance.subscriber_country','NewInsurance.subscriber_city','NewInsurance.subscriber_state','NewInsurance.subscriber_zip','NewInsurance.subscriber_primary_phone','NewInsurance.assignment_of_benefits'
				,'NewInsurance.policy_number','NewInsurance.coordination_of_benefits_priority','NewInsurance.realease_information_code','NewInsurance.subscriber_ssn','NewInsurance.insurance_name','NewInsurance.group_number','NewInsurance.tariff_standard_name'),'conditions'=>array('NewInsurance.id'=>$payer_selected_id,'NewInsurance.patient_id'=>$id)));
		
	
		
		$state_location_subscriber = $this->State->find('first', array('fields'=> array('State.state_code'),'conditions'=>array('State.id'=>$patient_insurance_details['NewInsurance']['subscriber_state'])));
		//Generate header array
		$data['ISA']=array("00","          ","00","          ","ZZ",$zirmed_client_accountid,"ZZ",Configure::read('receiver_id')."         ",$currentdate_ISA,$currentTime,"^",$controlVersionNumber,$isaseg13,"1",Configure::read('zirmed_mode'),":");
		$data['GS']=array("HC",trim($zirmed_client_accountid),Configure::read('receiver_id'),$currentdate,$currentTime,$groupControlNumber,"X",$controlNumber);
		$data['ST']=array("837",$ST2,$controlNumber);
		$data['BHT']=array("0019",$bht_transactionset_purposecode,$bht_reference_identification,$currentdate,$currentTime,"CH");
		//$data['REF']=array("87",$controlNumber);
	
		//generate loop array
		//NM1 SEGMENT EXAMPLE: NM1*41*2*HOSPITAL NAME*****46*HT0000214-002~ :: PER SEGMENT EXAMPLE: PER*IC*JANE DOE*TE*9005555555~
		$loop['1000A']=array("NM1"=>array("41","2",Configure::read('zirmed_client_accountname'),"","","","","46",trim($zirmed_client_accountid)),
				"PER"=>array("IC",Configure::read('zirmed_contact_person'),"EM",Configure::read('zirmed_contact_email')));
	
		//for 1 claim
		//NM1 SEGMENT EXAMPLE: NM1*40*2*EMIA*****46*HT0000214-001~ ::
		$loop['1000B']=array("NM1"=>array("40","2",Configure::read('receiver_id'),"","","","","46",Configure::read('receiver_id')));
		//HL SEGMENT EXAMPLE: HL*1**20*1~ :: PRV SEGMENT EXAMPLE: PRV*PT*ZZ*1223G0001X~  taxanomy code not clear for last paramater
		$loop['2000A']=array("HL"=>array("1","","20","1"));//,"PRV"=>array("BI","ZZ",$taxanomy_code) -- 1	Code Value 'data at 2000A.PRV' at element '2000A.PRV' is valid in the X12 standard, but not in this HIPAA implementation
	
		$country_location["Country"]["name"]="US";
		
		$loop['2010AA']=array("NM1"=>array("85","2",Configure::read('zirmed_client_accountname'),"","","","","XX",$hospital_location["Location"]["hospital_npi"]),
				"N3"=>array($hospital_location["Location"]["address1"]),
				"N4"=>array($city_location["City"]["name"],$state_location["State"]["state_code"],$hospital_location["Location"]["zipcode"]."0000"),
				"REF"=>array("EI",$hospital_location["Location"]["hospital_service_tax_no"])
		);
	
	
	
		if($patient_insurance_details["NewInsurance"]["relation"]=="self")
		{
			$HL4seg = "0";
		}
		else
		{
			$HL4seg = "1";
		}
		
		$CLM051=$placeOfService; //place of service
		$CLM052 ="B";//Facility Code Qualifier :: Hard Coded to 'B'
		$CLM053 ="1";//Claim Frequency Code :: this is to be fetched from claim manager screen
		$claimInsuranceType=$claim_encounter["[Encounter"]["primary_insurance"]; //File with insurance
		if($claimInsuranceType=="P")
			$benefit_accept_assign=$claim_encounter["Encounter"]["primary_benifits_assignment"];
		else if($claimInsuranceType=="S")
			$benefit_accept_assign=$claim_encounter["Encounter"]["sec_benifits_assignment"];
		else
			$benefit_accept_assign=$claim_encounter["Encounter"]["ter_benifits_assignment"];
	
	
		$CLM=$placeOfService.":".$CLM052.":".$CLM053;
		$loop2300_clm06=($claim_encounter["Encounter"]["executed_signature_clk"] = '') ? 'N' : 'Y';  //value can be N, Y :: N for provider signature not exist :: Y for provider signature exist :: This will be fetched dynamic later from claim detail page
		$loop2300_clm07="A"; //Claim Provider Accept Assignment :: This is situational or optional
		$loop2300_clm08=($benefit_accept_assign = '') ? 'W' : 'Y'; // value can be W, Y :: Claim Provider Benefits Assignment Certification :: will come dynamicaly from claim detail page
		$loop2300_clm09=($claim_encounter["[Encounter"]["information_signature_clk"] = '') ? 'N' : 'Y'; //Claim Release of Information Code :: value can be Y or N
		
	
		if(!empty($claim_encounter["Encounter"]["onset_currrent_date"]))
			$loop2300_onsetDTP['DTP']=array("431","D8",str_replace("-","",$claim_encounter["Encounter"]["onset_currrent_date"]));
	
		if(!empty($claim_encounter["Encounter"]["initial_treatment_date"]))
			$loop2300_initialDTP['DTP']=array("454","D8",str_replace("-","",$claim_encounter["Encounter"]["initial_treatment_date"]));
	
		if(!empty($claim_encounter["Encounter"]["last_seen_date"]))
			$loop2300_lastseenDTP['DTP']=array("304","D8",str_replace("-","",$claim_encounter["Encounter"]["last_seen_date"]));
	
		if(!empty($claim_encounter["Encounter"]["accident_date"]))
			$loop2300_accidentDTP['DTP']=array("439","D8",str_replace("-","",$claim_encounter["Encounter"]["accident_date"]));
	
		if(!empty($claim_encounter["Encounter"]["service_date"]))
			$loop2300_admissionDTP['DTP']=array("435","D8",str_replace("-","",$claim_encounter["Encounter"]["service_date"]));
	
		if(!empty($claim_encounter["Encounter"]["to_date"]))
			$loop2300_dischargeDTP['DTP']=array("096","D8",str_replace("-","",$claim_encounter["Encounter"]["to_date"]));
	
		if(!empty($claim_encounter["Encounter"]["acute_manifestation_date"]))
			$loop2300_acutemanifestationDTP['DTP']=array("453","D8",str_replace("-","",$claim_encounter["Encounter"]["acute_manifestation_date"]));
	
		if(!empty($claim_encounter["Encounter"]["last_menstrual_date"]))
			$loop2300_lastmenstrualDTP['DTP']=array("484","D8",str_replace("-","",$claim_encounter["Encounter"]["last_menstrual_date"]));
	
		if(!empty($claim_encounter["Encounter"]["claim_notes"]))
			$loop2300_NTE['NTE']=array($claim_encounter["Encounter"]["claim_notes_ref_code"],$claim_encounter["Encounter"]["claim_notes"]);
	
		//diagnosis code
		$getIcdData=$this->NoteDiagnosis->find('all',array('conditions'=>array('patient_id'=>$id,'delete_for_claim'=>'0'),'fields'=>array('id','icd_id','diagnoses_name','diagnosis_type')));
		//debug($getIcdData);
		$loop2300_HI_otherdiagnosis="";
		
		foreach($getIcdData as $key=>$icdData)
		{
	
	
			if($icdData["NoteDiagnosis"]["diagnosis_type"]=="PD")
				$loop2300_HI="BK:".str_replace(".","",$icdData["NoteDiagnosis"]["icd_id"]);
			else
				$loop2300_HI_otherdiagnosis.="*"."BF:".str_replace(".","",$icdData["NoteDiagnosis"]["icd_id"]);
	
		}
		if(!empty($loop2300_HI_otherdiagnosis))
			$HIloop=$loop2300_HI.$loop2300_HI_otherdiagnosis;
		else
			$HIloop=$loop2300_HI;
	
	
		//this is imp, this need to be repeated on the basis principal diag and secondary diag
		$loop2300_HI="BK:".$diagnosisCode;
	
		//hospital NPI
		if(!empty($hospital_location["Location"]["hospital_npi"]))
		{
			$loop2310C_NPI=$hospital_location["Location"]["hospital_npi"];
		}
		
		
		
			//LX SEGMENT EXAMPLE: LX*1~ :: SV2 SEGMENT EXAMPLE: SV2*300*HC:8019*73.2*UN*1~  :: Required Loop
	
		//procedure loop
		$this->ProcedurePerform->bindModel(array(
				'belongsTo' => array(
						'TariffList' =>array( 'foreignKey'=>false,'conditions'=>array('ProcedurePerform.snowmed_code=TariffList.cbt')),
						'TariffAmount' =>array( 'foreignKey'=>false,'conditions'=>array('TariffList.id=TariffAmount.tariff_list_id')),
				)),false);
		$getPrData=$this->ProcedurePerform->find('all',array('conditions'=>array('patient_id'=>$id),
				'fields'=>array('TariffList.price_for_private','ProcedurePerform.procedure_name','ProcedurePerform.snowmed_code',
						'ProcedurePerform.modifier1','ProcedurePerform.modifier2','ProcedurePerform.modifier3','ProcedurePerform.modifier4',
						'ProcedurePerform.procedure_to_date','ProcedurePerform.place_service','ProcedurePerform.units','ProcedurePerform.patient_daignosis',
						'ProcedurePerform.procedure_date','TariffAmount.non_nabh_charges'),'order' => array('ProcedurePerform.id DESC')));
		
		
		$this->set("getPrData",$getPrData);
		$procedureCount=1;
	
		foreach($getPrData as $getPrData)
		{
	
			$loop2400_SV1="HC".":".$getPrData["ProcedurePerform"]["snowmed_code"]; //HC-HCPCS codes // these codes will be fetched dynamically: Currently static 99214 is put
	
			if(!empty($getPrData["ProcedurePerform"]["modifier1"]))
				$loop2400_SV1.=":".$getPrData["ProcedurePerform"]["modifier1"];
	
			if(!empty($getPrData["ProcedurePerform"]["modifier2"]))
				$loop2400_SV1.=":".$getPrData["ProcedurePerform"]["modifier2"];
	
			if(!empty($getPrData["ProcedurePerform"]["modifier3"]))
				$loop2400_SV1.=":".$getPrData["ProcedurePerform"]["modifier3"];
	
			if(!empty($getPrData["ProcedurePerform"]["modifier4"]))
				$loop2400_SV1.=":".$getPrData["ProcedurePerform"]["modifier4"];
	
			//$totalProcedureCharges=$totalProcedureCharges+(($getPrData['ProcedurePerform']['units'])*($getPrData['TariffAmount']['non_nabh_charges']));
	
			$diagnosisPointer=explode(",",$getPrData['ProcedurePerform']['patient_diagnosis']);
			$diagnosisPointer=serialize($diagnosisPointer);
			
			$diagnosispointerString="";
			for($i=0;$i<count($diagnosisPointer);$i++)
			{
			$diagnosispointerString.=$diagnosisPointer[$i].":";
			}
	
			//from and To service date
	
			$serviceDate=str_replace("-","",$getPrData['ProcedurePerform']['procedure_date']);
	
				 if(empty($diagnosispointerString))
				 	$diagPointerPresent="*1";
	
				 	$loop['2400'][]=array("LX"=>array($procedureCount),
						"SV1"=>array($loop2400_SV1,$getPrData['TariffAmount']['non_nabh_charges'],"UN",$getPrData['ProcedurePerform']['units'],$getPrData['ProcedurePerform']['place_service'],"",rtrim($diagnosispointerString,":").$diagPointerPresent),
						"DTP"=>array("472","D8",$serviceDate)
						);
						$procedureCount++;
	
		}
		
	
		
		$this->set(compact('facility','city_facility','state_facility','UIDpatient_details','city_facility','city_location','state_location','country_location','subscriber_countryname','gendervalue','patientdob'
				,'patient_insurance_details','payer_details','placeOfService','benefit_accept_assign','claim_encounter','state_location_patient','getIcdData','hospital_location','state_location_subscriber'));
		//debug($UIDpatient_details);
		
	}
				
	


	/*
	 * Generates pdf of CMS 1500 form
	 * Pooja
	 */
	
	public function cms_pdf(){
		$this->layout = 'pdf'; //this will use the pdf.ctp layout
		$this->render();
	}
	
	public function cmsFormhtml($id=null,$claimtype=null,$payer_selected_id=null,$claim_id=null,$insuranceFileId=null,$count=null){
		
		$this->layout='advance_ajax';
		//$payer_selected_id="60";
		//$claimNumber="1";
		$ST2=str_pad($claim_id, 9, '0', STR_PAD_LEFT);//9 digit number required : Generated from claim id
		$groupControlNumber=str_pad(rand(10,100).$id, 9, '0', STR_PAD_RIGHT);//Generated from random function and patient id
		//$groupControlNumber=str_pad(date("Ymd"), 9, '0', STR_PAD_RIGHT);//Generated from random function and patient id
		$isaseg13=str_pad(date("Ymd"), 9, '0', STR_PAD_LEFT);//Generated from claim id, patient id and payer selected id : 9 digit number required
	
	
		$this->uses = array('Insurance','Location','City','State','Country','Patient','Person','NewInsurance','TariffStandard','Encounter','TariffList','TariffAmount','ProcedurePerform','NoteDiagnosis');
		if($claimtype==1500)
		{
			$controlVersionNumber="00501"; //Interchange control Version Number
			$controlNumber="005010X222A1"; //Interchange control Number  //004010X098A1
		}
		else
		{
			$controlVersionNumber="00401"; //Interchange control Version Number
			$controlNumber="005010X222"; //Interchange control Number
		}
		$zirmed_client_accountid=Configure::read('zirmed_client_accountid')."          ";//length 15 followed by spaces
		$currentdate=date("Ymd");
		$currentdate_ISA=date("ymd");
		$currentTime=date("Hi", time());
		$ackrequest=1;//value can be 0 or 1
		$bht_transactionset_purposecode="00";//value can be 00 - Original, 18 - Reissue
		$bht_reference_identification="Drm".$claim_id.$id.time().$claimtype;//still not clear
		$taxanomy_code="282E00000X";
	
	
	
	
	
		//find claim data from encounter table
		$claim_encounter = $this->Encounter->find('first', array('conditions'=>array('Encounter.id'=>$claim_id)));
		//debug($claim_encounter);
	
		//$totalClaimAmount=$claim_encounter["[Encounter"]["payment_amount"]; //Calculated from SUM (charge*units)
	
		//$totalClaimAmount="1000";
	
		//find place
		//$placeOfService=$claim_encounter["[Encounter"]["place_of_facility"];
		$placeOfService="21";
	
		//find hospital location, state, city
		$hospital_location = $this->Location->find('first', array('fields'=> array('Location.id', 'Location.name','Location.address1','Location.address2','Location.zipcode','Location.city_id','Location.state_id','Location.country_id','Location.phone1','Location.mobile','Location.fax','Location.hospital_npi','Location.hospital_service_tax_no'),'conditions'=>array('Location.id'=>$this->Session->read('locationid'), 'Location.is_active' => 1, 'Location.is_deleted' => 0)));
	
		$city_location = $this->City->find('first', array('fields'=> array('City.name'),'conditions'=>array('City.id'=>$hospital_location['Location']['city_id'])));
	
		$state_location = $this->State->find('first', array('fields'=> array('State.state_code'),'conditions'=>array('State.id'=>$hospital_location["Location"]["state_id"])));
	
		$country_location = $this->Country->find('first', array('fields'=> array('Country.name'),'conditions'=>array('Country.id'=>$hospital_location['Location']['country_id'])));
	
		$this->Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
	
		$UIDpatient_details  = $this->Person->getUIDPatientDetailsByPatientID($id);
		
	
		
		
		$this->loadModel("Facility");
		$this->Facility->unBindModel(array(
				'hasOne'=>array('FacilityDatabaseMapping','FacilityUserMapping')
		));
	
		$facility = $this->Facility->find('first', array('fields'=> array('Facility.id','Facility.name','Facility.address1','Facility.zipcode','Facility.city_id','Facility.state_id'),'conditions'=>array('Facility.is_deleted' => 0, 'Facility.is_active' => 1,'Facility.id' => $this->Session->read("facilityid"))));
	
		$city_facility = $this->City->find('first', array('fields'=> array('City.name'),'conditions'=>array('City.id'=>$facility['Facility']['city_id'])));
	
		$state_facility = $this->State->find('first', array('fields'=> array('State.state_code'),'conditions'=>array('State.id'=>$facility["Facility"]["state_id"])));
		
		
		
		
		//find subscriber country
	
		$subscriber_countryname = $this->Country->find('first', array('fields'=> array('Country.name'),'conditions'=>array('Country.id'=>$UIDpatient_details['Person']['country'])));
		//subscriber Sex
		$gender=$UIDpatient_details['Person']['sex'];
		if($gender=='Male' or $gender=='M')
			$gendervalue="M";
		else
			$gendervalue="F";
	
		$patientdob=str_replace("-", "", $UIDpatient_details["Person"]["dob"]);//CCYYMMDD format required
		
		$state_location_patient = $this->State->find('first', array('fields'=> array('State.state_code'),'conditions'=>array('State.id'=>$UIDpatient_details['Person']['state'])));
	
	
		
	
	
		//find payer information of claim from tariff_standards table
		$payer_details = $this->TariffStandard->find('first', array('fields'=> array('TariffStandard.name','TariffStandard.payer_id','TariffStandard.professional_claims','TariffStandard.institutional_claims','TariffStandard.remits','TariffStandard.eligibility','TariffStandard.claim_status_zirmed','TariffStandard.plot_no','TariffStandard.landmark','TariffStandard.pin_code','TariffStandard.city','TariffStandard.state','TariffStandard.country'),'conditions'=>array('TariffStandard.id'=>$payer_selected_id)));
		//find insurance detail from new_insurances table for patient
		$patient_insurance_details = $this->NewInsurance->find('first', array('fields'=> array('NewInsurance.priority','NewInsurance.relation'),'conditions'=>array('NewInsurance.tariff_standard_id'=>$payer_selected_id,'NewInsurance.patient_id'=>$id)));
		//Generate header array
		$data['ISA']=array("00","          ","00","          ","ZZ",$zirmed_client_accountid,"ZZ",Configure::read('receiver_id')."         ",$currentdate_ISA,$currentTime,"^",$controlVersionNumber,$isaseg13,"1",Configure::read('zirmed_mode'),":");
		$data['GS']=array("HC",trim($zirmed_client_accountid),Configure::read('receiver_id'),$currentdate,$currentTime,$groupControlNumber,"X",$controlNumber);
		$data['ST']=array("837",$ST2,$controlNumber);
		$data['BHT']=array("0019",$bht_transactionset_purposecode,$bht_reference_identification,$currentdate,$currentTime,"CH");
		//$data['REF']=array("87",$controlNumber);
	
		//generate loop array
		//NM1 SEGMENT EXAMPLE: NM1*41*2*HOSPITAL NAME*****46*HT0000214-002~ :: PER SEGMENT EXAMPLE: PER*IC*JANE DOE*TE*9005555555~
		$loop['1000A']=array("NM1"=>array("41","2",Configure::read('zirmed_client_accountname'),"","","","","46",trim($zirmed_client_accountid)),
				"PER"=>array("IC",Configure::read('zirmed_contact_person'),"EM",Configure::read('zirmed_contact_email')));
	
		//for 1 claim
		//NM1 SEGMENT EXAMPLE: NM1*40*2*EMIA*****46*HT0000214-001~ ::
		$loop['1000B']=array("NM1"=>array("40","2",Configure::read('receiver_id'),"","","","","46",Configure::read('receiver_id')));
		//HL SEGMENT EXAMPLE: HL*1**20*1~ :: PRV SEGMENT EXAMPLE: PRV*PT*ZZ*1223G0001X~  taxanomy code not clear for last paramater
		$loop['2000A']=array("HL"=>array("1","","20","1"));//,"PRV"=>array("BI","ZZ",$taxanomy_code) -- 1	Code Value 'data at 2000A.PRV' at element '2000A.PRV' is valid in the X12 standard, but not in this HIPAA implementation
	
		$country_location["Country"]["name"]="US";
		//$hospital_location["Location"]["zipcode"]="123456789";//nine digit zip is required..need to check
	
		//payer details loop
		//$loop['2100A']=array("NM1"=>array("PR","2",$payer_details["TariffStandard"]["name"],"","","","","PI",$payer_details["TariffStandard"]["payer_id"]));
	
		//NM1 SEGMENT EXAMPLE: NM1*85*2*MY INSITUTION****XX*1234567890~ :: N3 SEGMENT EXAMPLE: N3*123 MAIN ST~ :: N4 SEGMENT EXAMPLE: N4*ANYTOWN*KY*12345~
		//REF SEGMENT EXAMPLE: REF*SY*123456789~ :: REF SEGMENT EXAMPLE: REF*G2*123456789ABC~ :: REF SEGMENT EXAMPLE: REF*E1*123456~  -- needs to research on REF first segment
		$loop['2010AA']=array("NM1"=>array("85","2",Configure::read('zirmed_client_accountname'),"","","","","XX",$hospital_location["Location"]["hospital_npi"]),
				"N3"=>array($hospital_location["Location"]["address1"]),
				"N4"=>array($city_location["City"]["name"],$state_location["State"]["state_code"],$hospital_location["Location"]["zipcode"]."0000"),
				"REF"=>array("EI",$hospital_location["Location"]["hospital_service_tax_no"])
		);
	
		/*$loop['2010AB']=array("NM1"=>array("85","2",Configure::read('zirmed_client_accountname'),"","","","","XX",Configure::read('receiver_id')),
		 "N3"=>array($hospital_location["Location"]["address1"]),
				"N4"=>array($city_location["City"]["name"],$state_location["State"]["state_code"],$hospital_location["Location"]["zipcode"],$country_location["Country"]["name"]),
				"REF"=>array("1C",$hospital_location["Location"]["id"])
		);*/
	
		//"PER"=>array()
		//HL SEGMENT EXAMPLE: HL*2*1*22*1~ :: SBR SEGMENT EXAMPLE: SBR*P**EMIARXD***6***CI~  :: HL segment 1 and 2 are not clear. 2 and 1 values are enetered
		//HL - 4th segment will caontian 0 if isnurance is self and 1 for other
	
		if($patient_insurance_details["NewInsurance"]["relation"]=="self")
		{
			$HL4seg = "0";
		}
		else
		{
			$HL4seg = "1";
		}
		
		$CLM051=$placeOfService; //place of service
		$CLM052 ="B";//Facility Code Qualifier :: Hard Coded to 'B'
		$CLM053 ="1";//Claim Frequency Code :: this is to be fetched from claim manager screen
		$claimInsuranceType=$claim_encounter["[Encounter"]["primary_insurance"]; //File with insurance
		if($claimInsuranceType=="P")
			$benefit_accept_assign=$claim_encounter["Encounter"]["primary_benifits_assignment"];
		else if($claimInsuranceType=="S")
			$benefit_accept_assign=$claim_encounter["Encounter"]["sec_benifits_assignment"];
		else
			$benefit_accept_assign=$claim_encounter["Encounter"]["ter_benifits_assignment"];
	
	
		$CLM=$placeOfService.":".$CLM052.":".$CLM053;
		$loop2300_clm06=($claim_encounter["Encounter"]["executed_signature_clk"] = '') ? 'N' : 'Y';  //value can be N, Y :: N for provider signature not exist :: Y for provider signature exist :: This will be fetched dynamic later from claim detail page
		$loop2300_clm07="A"; //Claim Provider Accept Assignment :: This is situational or optional
		$loop2300_clm08=($benefit_accept_assign = '') ? 'W' : 'Y'; // value can be W, Y :: Claim Provider Benefits Assignment Certification :: will come dynamicaly from claim detail page
		$loop2300_clm09=($claim_encounter["[Encounter"]["information_signature_clk"] = '') ? 'N' : 'Y'; //Claim Release of Information Code :: value can be Y or N
		
	
		if(!empty($claim_encounter["Encounter"]["onset_currrent_date"]))
			$loop2300_onsetDTP['DTP']=array("431","D8",str_replace("-","",$claim_encounter["Encounter"]["onset_currrent_date"]));
	
		if(!empty($claim_encounter["Encounter"]["initial_treatment_date"]))
			$loop2300_initialDTP['DTP']=array("454","D8",str_replace("-","",$claim_encounter["Encounter"]["initial_treatment_date"]));
	
		if(!empty($claim_encounter["Encounter"]["last_seen_date"]))
			$loop2300_lastseenDTP['DTP']=array("304","D8",str_replace("-","",$claim_encounter["Encounter"]["last_seen_date"]));
	
		if(!empty($claim_encounter["Encounter"]["accident_date"]))
			$loop2300_accidentDTP['DTP']=array("439","D8",str_replace("-","",$claim_encounter["Encounter"]["accident_date"]));
	
		if(!empty($claim_encounter["Encounter"]["service_date"]))
			$loop2300_admissionDTP['DTP']=array("435","D8",str_replace("-","",$claim_encounter["Encounter"]["service_date"]));
	
		if(!empty($claim_encounter["Encounter"]["to_date"]))
			$loop2300_dischargeDTP['DTP']=array("096","D8",str_replace("-","",$claim_encounter["Encounter"]["to_date"]));
	
		if(!empty($claim_encounter["Encounter"]["acute_manifestation_date"]))
			$loop2300_acutemanifestationDTP['DTP']=array("453","D8",str_replace("-","",$claim_encounter["Encounter"]["acute_manifestation_date"]));
	
		if(!empty($claim_encounter["Encounter"]["last_menstrual_date"]))
			$loop2300_lastmenstrualDTP['DTP']=array("484","D8",str_replace("-","",$claim_encounter["Encounter"]["last_menstrual_date"]));
	
		if(!empty($claim_encounter["Encounter"]["claim_notes"]))
			$loop2300_NTE['NTE']=array($claim_encounter["Encounter"]["claim_notes_ref_code"],$claim_encounter["Encounter"]["claim_notes"]);
	
		//diagnosis code
		$getIcdData=$this->NoteDiagnosis->find('all',array('conditions'=>array('patient_id'=>$id,'delete_for_claim'=>'0'),'fields'=>array('id','icd_id','diagnoses_name','diagnosis_type')));
		//debug($getIcdData);
		$loop2300_HI_otherdiagnosis="";
		
		foreach($getIcdData as $key=>$icdData)
		{
	
	
			if($icdData["NoteDiagnosis"]["diagnosis_type"]=="PD")
				$loop2300_HI="BK:".str_replace(".","",$icdData["NoteDiagnosis"]["icd_id"]);
			else
				$loop2300_HI_otherdiagnosis.="*"."BF:".str_replace(".","",$icdData["NoteDiagnosis"]["icd_id"]);
	
		}
		if(!empty($loop2300_HI_otherdiagnosis))
			$HIloop=$loop2300_HI.$loop2300_HI_otherdiagnosis;
		else
			$HIloop=$loop2300_HI;
	
	
		//this is imp, this need to be repeated on the basis principal diag and secondary diag
		$loop2300_HI="BK:".$diagnosisCode;
	
		//hospital NPI
		if(!empty($hospital_location["Location"]["hospital_npi"]))
		{
			$loop2310C_NPI=$hospital_location["Location"]["hospital_npi"];
		}
		
		
		
			//LX SEGMENT EXAMPLE: LX*1~ :: SV2 SEGMENT EXAMPLE: SV2*300*HC:8019*73.2*UN*1~  :: Required Loop
	
		//procedure loop
		$this->ProcedurePerform->bindModel(array(
				'belongsTo' => array(
						'TariffList' =>array( 'foreignKey'=>false,'conditions'=>array('ProcedurePerform.snowmed_code=TariffList.cbt')),
						'TariffAmount' =>array( 'foreignKey'=>false,'conditions'=>array('TariffList.id=TariffAmount.tariff_list_id')),
				)),false);
		$getPrData=$this->ProcedurePerform->find('all',array('conditions'=>array('patient_id'=>$id),
				'fields'=>array('TariffList.price_for_private','ProcedurePerform.procedure_name','ProcedurePerform.snowmed_code',
						'ProcedurePerform.modifier1','ProcedurePerform.modifier2','ProcedurePerform.modifier3','ProcedurePerform.modifier4',
						'ProcedurePerform.procedure_to_date','ProcedurePerform.place_service','ProcedurePerform.units','ProcedurePerform.patient_daignosis',
						'ProcedurePerform.procedure_date','TariffAmount.non_nabh_charges'),'order' => array('ProcedurePerform.id DESC')));
		
		
		$this->set("getPrData",$getPrData);
		$procedureCount=1;
	
		foreach($getPrData as $getPrData)
		{
	
			$loop2400_SV1="HC".":".$getPrData["ProcedurePerform"]["snowmed_code"]; //HC-HCPCS codes // these codes will be fetched dynamically: Currently static 99214 is put
	
			if(!empty($getPrData["ProcedurePerform"]["modifier1"]))
				$loop2400_SV1.=":".$getPrData["ProcedurePerform"]["modifier1"];
	
			if(!empty($getPrData["ProcedurePerform"]["modifier2"]))
				$loop2400_SV1.=":".$getPrData["ProcedurePerform"]["modifier2"];
	
			if(!empty($getPrData["ProcedurePerform"]["modifier3"]))
				$loop2400_SV1.=":".$getPrData["ProcedurePerform"]["modifier3"];
	
			if(!empty($getPrData["ProcedurePerform"]["modifier4"]))
				$loop2400_SV1.=":".$getPrData["ProcedurePerform"]["modifier4"];
	
			//$totalProcedureCharges=$totalProcedureCharges+(($getPrData['ProcedurePerform']['units'])*($getPrData['TariffAmount']['non_nabh_charges']));
	
			$diagnosisPointer=explode(",",$getPrData['ProcedurePerform']['patient_diagnosis']);
			$diagnosisPointer=serialize($diagnosisPointer);
			debug($diagnosisPointer);
			$diagnosispointerString="";
			for($i=0;$i<count($diagnosisPointer);$i++)
			{
			$diagnosispointerString.=$diagnosisPointer[$i].":";
			}
	
			//from and To service date
	
			$serviceDate=str_replace("-","",$getPrData['ProcedurePerform']['procedure_date']);
	
				 if(empty($diagnosispointerString))
				 	$diagPointerPresent="*1";
	
				 	$loop['2400'][]=array("LX"=>array($procedureCount),
						"SV1"=>array($loop2400_SV1,$getPrData['TariffAmount']['non_nabh_charges'],"UN",$getPrData['ProcedurePerform']['units'],$getPrData['ProcedurePerform']['place_service'],"",rtrim($diagnosispointerString,":").$diagPointerPresent),
						"DTP"=>array("472","D8",$serviceDate)
						);
						$procedureCount++;
	
		}
		
		
		$this->set(compact('facility','city_facility','state_facility','UIDpatient_details','city_facility','city_location','state_location','country_location','subscriber_countryname','gendervalue','patientdob'
				,'patient_insurance_details','payer_details','placeOfService','benefit_accept_assign','claim_encounter','state_location_patient','getIcdData','hospital_location'));
		//debug($UIDpatient_details);
		
	}
	

}