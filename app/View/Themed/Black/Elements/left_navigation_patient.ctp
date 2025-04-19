<style>
.resizeIcon {
	height: 55px;
	width: 55px;
}
</style>
<!-- <div class="tab_dept" id="left-navigation-patient" style="width: 220px">  -->
<div class="tab_dept" id="left-navigation-patient"  >

	<?php if((strtolower($this->request->params['controller']) == 'billings') || ($this->request->params['controller'] == 'Insurances') || ($this->request->params['action'] == 'paymentRecieved')){
		//echo $this->Html->link($this->Html->image('/img/icons/patient_hub/accounts_receivable.PNG'). ' ' . __('Account Receivable Managment'), array('controller'=>'Insurances','action' => 'claim_balance_company'), array('escape' => false,'title'=>'Account Receivable Managment','class'=>"row_modules"));
		//echo $this->Html->link($this->Html->image('/img/icons/patient_hub/accounts_receivable.PNG'). ' ' . __('Account Receivable'), array('controller'=>'Accounting','action' => 'paymentRecieved'), array('escape' => false,'title'=>'Account Receivable','class'=>"row_modules"));
		//echo $this->Html->link($this->Html->image('/img/icons/patient_hub/daysheet_1.PNG'). ' ' . __('Day Sheet Billing'), array('controller'=>'Billings','action' => 'daySheetBilling'), array('escape' => false,'title'=>'Day Sheet Billing','class'=>"row_modules"));
		//echo $this->Html->link($this->Html->image('/img/icons/patient_hub/liveclaimsfeed_1.PNG'). ' ' . __('Live Claims Feed'), array('controller'=>'Billings','action' => 'liveClaimsFeed',$patient['Patient']['id']), array('escape' => false,'title'=>'Live Claims Feed','class'=>"row_modules"));
		//echo $this->Html->link($this->Html->image('/img/icons/patient_hub/transactions_2.PNG'). ' ' . __('Live Claim FeedGraph'), array('controller'=>'Billings','action' => 'liveClaimFeedGraph'), array('escape' => false,'title'=>'Live Claim FeedGraph','class'=>"row_modules"));
		//echo $this->Html->link($this->Html->image('/img/icons/patient_hub/billingsummary_1.PNG'). ' ' . __('Patient Eligibility Check'), array('controller'=>'Billings','action' => 'patientEligibilityCheck',$patient['Patient']['id']), array('escape' => false,'title'=>'Patient Eligibility Check','class'=>"row_modules"));
		//echo $this->Html->link($this->Html->image('/img/icons/patient_hub/billingsummary_1.PNG'). ' ' . __('Edit/Error Management'), array('controller'=>'Insurances','action' => 'editErrorManagement'), array('escape' => false,'title'=>'Edit/Error Management','class'=>"row_modules"));
		//echo $this->Html->link($this->Html->image('/img/icons/patient_hub/billingsummary_1.PNG'). ' ' . __('External Consultant Bill'), array('controller'=>'Billings','action' => 'patient_information',$patient['Patient']['id'],'null',true), array('escape' => false,'title'=>'External Consultant Bill','class'=>"row_modules"));
		//echo $this->Html->link($this->Html->image('/img/icons/patient_hub/claim_submission_2.png'). ' ' . __('Claim Submission-First Scrubbing'), array('controller'=>'Insurances','action' => 'claimManager',$patient['Patient']['id'],true), array('escape' => false,'title'=>'Claim Submission-First Scrubbing','class'=>"row_modules"));
		//echo $this->Html->link($this->Html->image('/img/icons/patient_hub/claim_submission_2.png'). ' ' . __('Cash Book'), array('controller'=>'billings','action' => 'dailyCashBook',true), array('escape' => false,'title'=>'Cash Book','class'=>"row_modules"));
		//echo $this->Html->link($this->Html->image('/img/icons/patient_hub/recievePayment.png'). ' ' . __('Advance Payment'), array('controller'=>'Accounting','action' => 'paymentPosting',true), array('escape' => false,'title'=>'Advance Payment ','class'=>"row_modules"));
	}//else{ ?>
	<!--Row 1 -->
	<?php //if($patient['Patient']['admission_type'] == 'OPD'){?>
	<?php //if($patient['Patient']['is_discharge']==0){?>


	<?php // $usertype=$this->Session->read('facilityu',$facility['Facility']['usertype']); 
	/* if($usertype="ambulatory"){
	 echo $this->Html->link($this->Html->image('/img/icons/patient_hub/initial_assessment2.jpg'). ' ' . __('Initial Assess'), array('controller'=>'diagnoses','action' => 'add_ambi',$patient['Patient']['id']), array('escape' => false,'title'=>'Initial Assessment','class'=>"row_modules"));
			}else{ */
		//echo $this->Html->link($this->Html->image('/img/icons/patient_hub/initial_assessment2.jpg'). ' ' . __('Initial Assess'), array('controller'=>'diagnoses','action' => 'add',$patient['Patient']['id']), array('escape' => false,'title'=>'Initial Assessment','class'=>"row_modules"));
		//}?>

	<?php //}?>

	<?php //echo $this->Js->link($this->Html->image('/img/icons/patient_hub/notes2.jpg',array('id'=>'prescriptionLink')). ' ' . __('SOAP'), array('controller'=>'patients','action' => 'patient_notes',$patient['Patient']['id'],'#list_patient'),
        		// array('escape'=>false,'update' => '#list_content','method'=>'post','complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'title'=>'SOAP','class'=>"row_modules"));?>


	<?php //echo $this->Html->link($this->Html->image('/img/icons/nursing/hipaa.png',array('class'=>'resizeIcon')). ' ' . __('Hipaa Consent'), 
						//array('controller'=>'nursings','action' => 'hippa_consent_list',$patient['Patient']['id']),array('escape' => false,'title'=>'Hipaa Consent','class'=>"row_modules"));	?>

	<?php //echo $this->Html->link($this->Html->image('/img/icons/patient_hub/orderset.png'). ' ' . __('Order Set'), array('controller'=>'MultipleOrderSets','action' => 'orders',$patient['Patient']['id']), array('escape' => false,'title'=>'Order Set','class'=>"row_modules"));	?>


	<?php //echo $this->Js->link($this->Html->image('/img/icons/appoinment_icon.png'). ' ' . __('Add Appt.'), array('controller'=>'appointments','action' => 'appointmentList',$patient['Patient']['id']),
        		 //array('class'=>"row_modules",'escape'=>false,'update' => '#list_content','method'=>'post','complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))));?>

	<?php //echo $this->Html->link($this->Html->image('/img/icons/patient_hub/allergies.png'). ' ' . __('Allergy'), array(), array('onclick'=>"getAllergiesAddEdit();return false;",'escape' => false,'title'=>'Patient Allergy','class'=>"row_modules"));	?>


	<?php //echo $this->Html->link($this->Html->image('/img/icons/patient_hub/advance.jpg'). ' ' . __('Adv. Directive'), array('controller'=>'patients','action' => 'search_advance_directive',$patient['Patient']['id'],$patient['Patient']['admission_id']), array('escape' => false,'title'=>'Advance Directive','class'=>"row_modules"));	?>

	<?php //echo $this->Html->link($this->Html->image('/img/icons/patient_hub/Inpatient-Summary.png'). ' ' . __('Ambulatory Clinical Summary'),
			//array('controller'=>'PatientsTrackReports','action' => 'inpatientDashboard',$patient['Patient']['id']),array('escape' => false,'title'=>'Ambulatory Clinical Summary','class'=>"row_modules"));?>
	
	<?php //echo $this->Html->link($this->Html->image('/img/icons/patient_hub/blood-sugar-monitor-chart.png',array('class'=>'resizeIcon')). ' ' . __('Bld. Sugar Monitoring'), array('controller'=>'nursings','action' => 'blood_sugar_monitoring',$patient['Patient']['id']), array('escape' => false,'title'=>'Blood Sugar Monitoring Chart','class'=>"row_modules"));	?>



	<?php  //echo $this->Html->link($this->Html->image('/img/icons/patient_hub/physiotherapy-assessment-form1.jpg',array('class'=>'resizeIcon')). ' ' . __('Cli. Summary'),'javascript:void(0)', array('id'=>"clinical-summary",'escape' => false,'title'=>'clinical summary','class'=>"row_modules"));?>
	<?php  // echo $this->Html->link($this->Html->image('/img/icons/patient_hub/physiotherapy-assessment-form1.jpg',array('class'=>'resizeIcon')). ' ' . __('Patient Permissions'),'javascript:void(0)', array('id'=>"patient_permissions",'escape' => false,'title'=>'Patient Permissions','class'=>"row_modules"));?>
	<?php // echo $this->Js->link($this->Html->image('/img/icons/patient_hub/physiotherapy-assessment-form1.jpg'). ' ' . __('Clinical Summary'), array('controller'=>'ccda','action' => 'clinical_summary',$patient['Patient']['id'],$patient['Patient']['patient_id']), array('escape'=>false,'update' => '#list_content','method'=>'post','complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'title'=>'Clinical Summary','class'=>"row_modules"));?>


	<?php //$pat_uid = $patient['Patient']['id']; 
		//echo $this->Html->link($this->Html->image('/img/icons/patient_hub/credential.png',array('class'=>'resizeIcon')). ' ' . __('Create Credentials'),'javascript:void(0)', array('onClick'=>"createPatientCredentials('$pat_uid')",'escape' => false,'title'=>'Patient Credentials','class'=>"row_modules"));?>

	<?php //echo $this->Html->link($this->Html->image('/img/icons/patient_hub/dietary_assessment.png',array('class'=>'resizeIcon')). ' ' . __('Dietary Assessment'), array('controller'=>'nursings','action' => 'dietaryAssessment',$patient['Patient']['id']), array('escape' => false,'title'=>'Dietary Assessment','class'=>"row_modules"));?>

	<?php //echo $this->Html->link($this->Html->image('/img/icons/nursing/fall-assessment.jpg',array('class'=>'resizeIcon')). ' ' . __('Fall Assessment'), array('controller'=>'nursings','action' => 'fall_assessment',$patient['Patient']['id']), array('escape' => false,'title'=>'Fall Assessment','class'=>"row_modules"));	?>



	<?php //echo $this->Html->link($this->Html->image('/img/icons/nursing/fall-assessment-summary.jpg',array('class'=>'resizeIcon')). ' ' . __('Fall Summary'), array('controller'=>'nursings','action' => 'fall_assessment_summary',$patient['Patient']['id']), array('escape' => false,'title'=>'Fall Assessment Summary','class'=>"row_modules"));?>

	<?php //echo $this->Html->link($this->Html->image('/img/icons/patient_hub/ICU_Consent.png',array('class'=>'resizeIcon')). ' ' . __('ICU Consent'), array('controller'=>'nursings','action' => 'ventilator_consent_list',$patient['Patient']['id']), array('escape' => false,'title'=>'ICU Consent Form','class'=>"row_modules"));	?>


	<?php //echo $this->Html->link($this->Html->image('/img/icons/patient_hub/IMMUNIZATION.jpg'). ' ' . __('Immunization'), array('controller'=>'imunization','action' => 'index',$patient['Patient']['id'],'?'=>array('return'=>'patientInfo')),
			//array('escape' => false,'title'=>'Immunization','class'=>"row_modules"));?>

	<?php //echo $this->Html->link($this->Html->image('/img/icons/patient_insurance.png'). ' ' . __('Insurance'), array('controller'=>'patients','action' => 'insuranceindex',$patient['Patient']['id']),array('escape' => false,'title'=>'PatientInsurace','class'=>"row_modules"));?>

	<?php //echo $this->Html->link($this->Html->image('/img/icons/patient_hub/ivf.png',array('class'=>'resizeIcon')). ' ' . __('I.V.F.'), array('controller'=>'nursings','action' => 'patient_ivf_list',$patient['Patient']['id']), array('escape' => false,'title'=>'I.V.F.','class'=>"row_modules"));	?>


	<?php ///echo $this->Html->link($this->Html->image('/img/icons/patient_hub/laboratory2.jpg'). ' ' . __('Laboratory Result'), array('controller'=>'laboratories','action' => 'labTestHl7List',$patient['Patient']['id']), array('escape' => false,'title'=>'Laboratory-Result','class'=>"row_modules"));?>


	<?php //echo $this->Html->link($this->Html->image('/img/icons/patient_hub/message.png'). ' ' . __('Messages'), array('controller'=>'messages','action' => 'index',$patient['Patient']['id'],'?'=>array('return'=>'patientInfo')),
			//array('escape' => false,'title'=>'Messages','class'=>"row_modules"));?>


	<?php //echo $this->Html->link($this->Html->image('/img/icons/past_medical_history.png',array('class'=>'resizeIcon')). ' ' . __('Past Med. Hist.'), array('controller'=>'diagnoses','action' => 'pastMedicalHistory',$patient['Patient']['id']), array('escape' => false,'title'=>'Past Medical History','class'=>"row_modules"));	?>

	<?php //echo $this->Html->link($this->Html->image('/img/icons/patient_hub/psychology_history.png',array('class'=>'resizeIcon')). ' ' . __('Psychiatric Evaluation'), array('controller'=>'patientForms','action' => 'psychologyHistory',$patient['Patient']['id']), array('escape' => false,'title'=>'Psychiatric Evaluation','class'=>"row_modules"));	?>
	<?php ///echo $this->Html->link($this->Html->image('/img/icons/physiotherapy-assessment-form.jpg',array('class'=>'resizeIcon')). ' ' . __('Physiotherapy Assessment'), array('controller'=>'nursings','action' => 'physiotherapy_assessment_view',$patient['Patient']['id']), array('escape' => false,'title'=>'Physiotherapy Assessment Form','class'=>"row_modules"));	?>


	<?php //echo $this->Js->link($this->Html->image('/img/icons/patient_hub/quick_note.png',array('id'=>'quicknoteLink','style'=>'width:55px;height:55px;')). ' ' . __('Quick Note'), array('controller'=>'patients','action' => 'orderset',$patient['Patient']['id'],'#list_patient'), array('escape'=>false,'update' => '#list_content','method'=>'post','complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'title'=>'SOAP Notes','class'=>"row_modules"));?>




	<?php //echo $this->Html->link($this->Html->image('/img/icons/patient_hub/radiology2.jpg'). ' ' . __('Radiology Result'), array('controller'=>'radiologies','action' => 'radiology_test_list',$patient['Patient']['id']), array('escape' => false,'title'=>'Radiology','class'=>"row_modules"));	?>


	<?php //echo $this->Html->link($this->Html->image('/img/icons/patient_hub/reconcile.png'). ' ' . __('Reconcile'), array('controller'=>'patients','action' => 'reconcile',$patient['Patient']['id']),array('escape' => false,'title'=>'Reconcile','class'=>"row_modules"));?>


	<?php //echo $this->Html->link($this->Html->image('/img/icons/patient_hub/patient-referral2.jpg'). ' ' . __('Referral'),
				//array('controller'=>'patients','action' => 'patient_referral',$patient['Patient']['id']),array('escape' => false,'title'=>'Patient Referral','class'=>"row_modules"));	?>

	<?php //echo $this->Html->link($this->Html->image('/img/icons/patient_hub/discharge2.jpg'). ' ' . __('Summary By Consultant'), array('controller'=>'billings','action' => 'discharge_summary',$patient['Patient']['id'],'?'=>array('return'=>'patientInfo')),
							 	//array('escape' => false,'title'=>'Summary','class'=>"row_modules"));?>

	<?php //echo $this->Html->link($this->Html->image('/img/icons/patient_hub/tracheostomy.png',array('class'=>'resizeIcon')). ' ' . __('Trach. Consent'), array('controller'=>'nursings','action' => 'tracheostomy_consent_list',$patient['Patient']['id']), array('escape' => false,'title'=>'Tracheostomy Consent Form','class'=>"row_modules"));	?>


	<?php //echo $this->Html->link($this->Html->image('/img/icons/patient_hub/Ventilator.png',array('class'=>'resizeIcon')). ' ' . __('Ventilator Nurse Check List'), array('controller'=>'nursings','action' => 'ventilator_nurse_list',$patient['Patient']['id']), array('escape' => false,'title'=>'Ventilator Nurse Check List','class'=>"row_modules"));	?>

	<?php //echo $this->Html->link($this->Html->image('/img/icons/patient_hub/vital.png'). ' ' . __('Vitals'), array('controller'=>'Notes','action' => 'vital',$patient['Patient']['id']),array('escape' => false,'title'=>'Vitals','class'=>"row_modules"));?>

	<?php //if($patient['Patient']['is_discharge']==0){?>
	<?php //echo $this->Html->link($this->Html->image('/img/icons/patient_hub/patient-survey2.jpg'). ' ' . __('OPD Survey'), array('controller'=>'surveys','action' => 'opd_patient_surveys',$patient['Patient']['id']), array('escape' => false,'title'=>'OPD Patient Survey','class'=>"row_modules"));?>
	<?php //}?>




	<!-- Row 2 -->

	<?php ///} else if($patient['Patient']['admission_type'] == 'IPD'){?>
	<!-- Row 3 -->

	<?php //echo $this->Html->link($this->Html->image('/img/icons/patient_hub/initial_assessment2.jpg'). ' ' . __('Initial Assess'), array('controller'=>'diagnoses','action' => 'add',$patient['Patient']['id']), array('escape' => false,'title'=>'Initial Assessment','class'=>"row_modules"));	?>



	<?php //echo $this->Js->link($this->Html->image('/img/icons/patient_hub/notes2.jpg',array('id'=>'prescriptionLink')). ' ' . __('SOAP'), array('controller'=>'patients','action' => 'patient_notes',$patient['Patient']['id'],'#list_patient'), array('escape'=>false,'update' => '#list_content','method'=>'post','complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'title'=>'SOAP Notes','class'=>"row_modules"));?>



	<?php //echo $this->Html->link($this->Html->image('/img/icons/patient_hub/sbar.png'). ' ' . __('SBAR'),array('controller'=>'PatientsTrackReports','action' => 'sbar',$patient['Patient']['id'],'Situation'),array('escape' => false,'title'=>'SBAR','class'=>"row_modules"));?>



	<?php //echo $this->Html->link($this->Html->image('/img/icons/patient_hub/orderset.png'). ' ' . __('Order Set'), array('controller'=>'MultipleOrderSets','action' => 'orders',$patient['Patient']['id']), array('escape' => false,'title'=>'Order Set','class'=>"row_modules"));	?>



	<?php ///echo $this->Html->link($this->Html->image('/img/icons/patient_hub/laboratory2.jpg'). ' ' . __('Lab. Result'), array('controller'=>'laboratories','action' => 'labTestHl7List',$patient['Patient']['id'],'?'=>array('return'=>'patients')), array('escape' => false,'title'=>'Laboratory-Result','class'=>"row_modules"));?>



	<?php //echo $this->Html->link($this->Html->image('/img/icons/radiology.png',array('class'=>'resizeIcon')). ' ' . __('Rad. Result'), array('controller'=>'radiologies','action' => 'radiology_test_list',$patient['Patient']['id'],'?'=>array('return'=>'nursings')), array('escape' => false,'title'=>'Radiology Result','class'=>"row_modules"));?>



	<?php //echo $this->Html->link($this->Html->image('/img/icons/patient_hub/vital.png'). ' ' . __('Vitals'), array('controller'=>'Notes','action' => 'vital',$patient['Patient']['id']),array('escape' => false,'title'=>'Vitals','class'=>"row_modules"));?>



	<?php //echo $this->Html->link($this->Html->image('/img/icons/interactive_view.png',array('class'=>'resizeIcon')). ' ' . __('Interactive View'), 
					//array('controller'=>'nursings','action' => 'interactive_view',$patient['Patient']['id']),array('escape' => false,'title'=>'Interactive View','class'=>"row_modules"));?>


	<?php //echo $this->Html->link($this->Html->image('/img/icons/emar_dashboard.png',array('class'=>'resizeIcon')). ' ' . __('EMAR Dashboard'), 
					//array('controller'=>'PatientsTrackReports','action' => 'emarDashboard',$patient['Patient']['id']),array('escape' => false,'title'=>'EMAR Dashboard','class'=>"row_modules"));	?>



	<?php //echo $this->Html->link($this->Html->image('/img/icons/patient_hub/advance.jpg'). ' ' . __('Adv. Directive'), array('controller'=>'patients','action' =>  'search_advance_directive',$patient['Patient']['id'],$patient['Patient']['admission_id']), array('escape' => false,'title'=>'Advance Directive','class'=>"row_modules"));	?>



	<?php //echo $this->Html->link($this->Html->image('/img/icons/patient_hub/allergies.png'). ' ' . __('Allergy'), array(), array('onclick'=>"getAllergiesAddEdit();return false;",'escape' => false,'title'=>'Patient Allergy','class'=>"row_modules"));	?>


	<?php //if($patient['Patient']['sex']=='female'){ ?>


	<?php //echo $this->Html->link($this->Html->image('/img/icons/patient_hub/child-birth.jpg'). ' ' . __('Birth'), array('controller'=>'patients','action' => 'child_birth_list',$patient['Patient']['id'],'?'=>array('return'=>'patients')),array('escape' => false,'title'=>'Child Birth','class'=>"row_modules"));?>

	<?php //}?>


	<?php //echo $this->Html->link($this->Html->image('/img/icons/patient_hub/blood-sugar-monitor-chart.png',array('class'=>'resizeIcon')). ' ' . __('Bld. Sugar Monitoring'), array('controller'=>'nursings','action' => 'blood_sugar_monitoring',$patient['Patient']['id']), array('escape' => false,'title'=>'Blood Sugar Monitoring Chart','class'=>"row_modules"));	?>



	<?php //echo $this->Html->link($this->Html->image('/img/icons/patient_hub/blood-requisition2.jpg'). ' ' . __('Bl. Requi.'), array('controller'=>'blood_banks','action' => 'index',$patient['Patient']['id']), array('escape' => false,'title'=>'Blood Requisition','class'=>"row_modules"));	?>



	<?php //echo $this->Html->link($this->Html->image('/img/icons/bld_transfusion_icon.png',array('class'=>'resizeIcon')). ' ' . __('Bld. Transfusion'), array('controller'=>'nursings','action' => 'patient_blood_transfusion_list',$patient['Patient']['id']), array('escape' => false,'title'=>'Blood Transfusion Progress Form','class'=>"row_modules"));	?>



	<?php //echo $this->Html->link($this->Html->image('/img/icons/nursing/observation-chart.jpg',array('class'=>'resizeIcon')). ' ' . __('Chart'), array('controller'=>'nursings','action' => 'observation_chart_list',$patient['Patient']['id']), array('escape' => false,'title'=>'Observation Chart','class'=>"row_modules"));	?>


	<?php //if($patient['Patient']['sex']=='female'){ ?>

	<?php //echo $this->Html->link($this->Html->image('/img/icons/child-birth.jpg',array('class'=>'resizeIcon')). ' ' . __('Child Birth'), array('controller'=>'patients','action' => 'child_birth_list',$patient['Patient']['id'],'?'=>array('return'=>'nursings')),array('escape' => false,'title'=>'Child Birth','class'=>"row_modules"));?>

	<?php //} ?>

	<?php //echo $this->Html->link($this->Html->image('/img/icons/patient_hub/consent-form.png'). ' ' . __('Consent'), array('controller'=>'consents','action' => 'index',$patient['Patient']['id']), array('escape' => false,'title'=>'Consent Form','class'=>"row_modules"));	?>



	<?php ///echo $this->Html->link($this->Html->image('/img/icons/patient_track_report.png',array('class'=>'resizeIcon')). ' ' . __('Critical Care Review'), 
					//array('controller'=>'PatientsTrackReports','action' => 'index',$patient['Patient']['id']),array('escape' => false,'title'=>'Critical Care Review','class'=>"row_modules"));	?>


	<?php // $pat_uid = $patient['Patient']['id']; 
        //echo $this->Html->link($this->Html->image('/img/icons/patient_hub/credential.png',array('class'=>'resizeIcon')). ' ' . __('Create Credentials'),'javascript:void(0)', array('onClick'=>"createPatientCredentials('$pat_uid')",'escape' => false,'title'=>'Patient Credentials','class'=>"row_modules"));?>


	<?php //if(strtolower($patient['FinalBilling']['reason_of_discharge'])=='death')
         //echo $this->Html->link($this->Html->image('/img/icons/patient_hub/DEATHRECORDS.jpg'). ' ' . __('Death Rec.'), array('controller'=>'billings','action' => 'death_summary',$patient['Patient']['id'],'?'=>array('return'=>'patientInfo')),array('escape' => false,'title'=>'Death Records','class'=>"row_modules"));?>



	<?php //echo $this->Html->link($this->Html->image('/img/icons/patient_hub/dietary_assessment.png',array('class'=>'resizeIcon')). ' ' . __('Dietary Assessment'), array('controller'=>'nursings','action' => 'dietaryAssessment',$patient['Patient']['id']), array('escape' => false,'title'=>'Dietary Assessment','class'=>"row_modules"));?>


	<?php ///echo $this->Html->link($this->Html->image('/img/icons/patient-documents.jpg',array('class'=>'resizeIcon')). ' ' . __('Documents'), array('controller'=>'patient_documents','action' => 'index',$patient['Patient']['id']),array('escape' => false,'title'=>'Patient\'s Documents','class'=>"row_modules"));?>

	<?php ///echo $this->Html->link($this->Html->image('/img/icons/patient_hub/quick_note.png',array('id'=>'extraNoteLink','style'=>'width:55px;height:55px;')). ' ' . __('Extra Note'),array('controller'=>'patients','action' => 'listExtraNotes',$patient['Patient']['id']),
				///array('title'=>'Extra Notes','class'=>"row_modules",'escape'=>false));?>

	<?php //echo $this->Html->link($this->Html->image('/img/icons/nursing/fall-assessment.jpg',array('class'=>'resizeIcon')). ' ' . __('Fall Assessment'), array('controller'=>'nursings','action' => 'fall_assessment',$patient['Patient']['id']), array('escape' => false,'title'=>'Fall Assessment','class'=>"row_modules"));	?>



	<?php //echo $this->Html->link($this->Html->image('/img/icons/nursing/fall-assessment-summary.jpg',array('class'=>'resizeIcon')). ' ' . __('Fall Summary'), array('controller'=>'nursings','action' => 'fall_assessment_summary',$patient['Patient']['id']), array('escape' => false,'title'=>'Fall Assessment Summary','class'=>"row_modules"));?>



	<?php //echo $this->Html->link($this->Html->image('/img/icons/patient_hub/faxreferral.png'). ' ' . __('Fax Referral'),array('controller'=>'Recipients','action' => 'search',$patient['Patient']['id']),array('escape' => false,'title'=>'Fax Referral','class'=>"row_modules"));	?>



	<?php //echo $this->Html->link($this->Html->image('/img/icons/bill-invoicing.jpg',array('class'=>'resizeIcon')). ' ' . __('Generate Invoice'), array('controller'=>'nursings','action' => 'addWardCharges',$patient['Patient']['id']), array('escape' => false,'title'=>'Generate Invoice','class'=>"row_modules"));	?>



	<?php //echo $this->Html->link($this->Html->image('/img/icons/nursing/hipaa.png',array('class'=>'resizeIcon')). ' ' . __('Hipaa Consent'),array('controller'=>'nursings','action' => 'hippa_consent_list',$patient['Patient']['id']),array('escape' => false,'title'=>'Hipaa Consent','class'=>"row_modules"));	?>



	<?php //echo $this->Html->link($this->Html->image('/img/icons/hia-assessment.png',array('class'=>'resizeIcon')). ' ' . __('HAI Assessment'), array('controller'=>'hospital_acquire_infections','action' => 'index',$patient['Patient']['id'],'sendTo'=>'nursings'), array('escape' => false,'title'=>'HAI Assessment','class'=>"row_modules"));?>


	<?php //echo $this->Html->link($this->Html->image('/img/icons/patient_hub/ICU_Consent.png',array('class'=>'resizeIcon')). ' ' . __('ICU Consent'), array('controller'=>'nursings','action' => 'ventilator_consent_list',$patient['Patient']['id']), array('escape' => false,'title'=>'ICU Consent Form','class'=>"row_modules"));	?>


	<?php //echo $this->Html->link($this->Html->image('/img/icons/patient_hub/IMMUNIZATION.jpg'). ' ' . __('Immunization'), array('controller'=>'imunization','action' => 'index',$patient['Patient']['id']),array('escape' => false,'title'=>'Immunization','class'=>"row_modules"));?>


	<?php //echo $this->Html->link($this->Html->image('/img/icons/patient_hub/Incident.png'). ' ' . __('Incident'), 
        		//array('controller'=>'incidents','action' => 'add',$patient['Patient']['id'],), array('escape' => false,'title'=>'Incident Form','class'=>"row_modules"));?>

	<?php //echo $this->Html->link($this->Html->image('/img/icons/patient_hub/Inpatient-Summary.png'). ' ' . __('Inpatient Dashboard'),
			//array('controller'=>'PatientsTrackReports','action' => 'inpatientDashboard',$patient['Patient']['id']),array('escape' => false,'title'=>'Inpatient Dashboard','class'=>"row_modules"));?>

	<?php //echo $this->Html->link($this->Html->image('/img/icons/patient_insurance.png'). ' ' . __('Insurance'), 
         		//array('controller'=>'patients','action' => 'insuranceindex',$patient['Patient']['id']),array('escape' => false,'title'=>'PatientInsurace','class'=>"row_modules"));?>


	<?php //echo $this->Html->link($this->Html->image('/img/icons/patient_hub/ivf.png',array('class'=>'resizeIcon')). ' ' . __('I.V.F.'), array('controller'=>'nursings','action' => 'patient_ivf_list',$patient['Patient']['id']), array('escape' => false,'title'=>'I.V.F.','class'=>"row_modules"));	?>



	<?php //echo $this->Html->link($this->Html->image('/img/icons/patient_hub/message.png'). ' ' . __('Messages'), 
        		//array('controller'=>'messages','action' => 'index',$patient['Patient']['id'],'?'=>array('return'=>'patientInfo')),array('escape' => false,'title'=>'Messages','class'=>"row_modules"));?>


	<?php ///echo $this->Html->link($this->Html->image('/img/icons/past_medical_history.png',
			///array('class'=>'resizeIcon')). ' ' . __('Past Med. Hist.'),
       		///array('controller'=>'diagnoses','action' => 'pastMedicalHistory',$patient['Patient']['id']), array('escape' => false,'title'=>'Past Medical History','class'=>"row_modules"));	?>


	<?php ////echo $this->Html->link($this->Html->image('/img/icons/physiotherapy-assessment-form.jpg',array('class'=>'resizeIcon')). ' ' . __('Physiotherapy Assessment'), array('controller'=>'nursings','action' => 'physiotherapy_assessment_view',$patient['Patient']['id']), array('escape' => false,'title'=>'Physiotherapy Assessment Form','class'=>"row_modules"));	?>
	<?php //echo $this->Html->link($this->Html->image('/img/icons/patient_hub/psychology_history.png',array('class'=>'resizeIcon')). ' ' . __('Psychiatric Evaluation'), array('controller'=>'patientForms','action' => 'psychologyHistory',$patient['Patient']['id']), array('escape' => false,'title'=>'Psychiatric Evaluation','class'=>"row_modules"));	?>

	<?php //if($patient['Patient']['is_discharge']==0){ ?>

	<?php ///echo $this->Html->link($this->Html->image('/img/icons/patient_hub/patient-survey2.jpg'). ' ' . __('Pt. Survey'), 
        		///array('controller'=>'surveys','action' => 'patient_surveys',$patient['Patient']['id']), array('escape' => false,'title'=>'IPD Patient Survey','class'=>"row_modules"));?>

	<?php //}?>


	<?php //echo $this->Html->link($this->Html->image('/img/icons/nursing/nursing-quality-indicator.jpg',array('class'=>'resizeIcon')). ' ' . __('Quality Indicators'), array('controller'=>'nursings','action' => 'quality_monitoring_format',$patient['Patient']['id']), array('escape' => false,'title'=>'Nursing Sensitive Quality Indicators Monitoring Format','class'=>"row_modules"));?>



	<?php //echo $this->Js->link($this->Html->image('/img/icons/patient_hub/quick_note.png',array('id'=>'quicknoteLink','style'=>'width:55px;height:55px;')). ' ' . __('Quick Note'),array('controller'=>'patients','action' => 'orderset',$patient['Patient']['id'],'#list_patient'),
										// array('escape'=>false,'update' => '#list_content','method'=>'post','complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'title'=>'SOAP Notes','class'=>"row_modules"));?>



	<?php //echo $this->Html->link($this->Html->image('/img/icons/patient_hub/reconcile.png'). ' ' . __('Reconcile'), array('controller'=>'patients','action' => 'reconcile',$patient['Patient']['id']),array('escape' => false,'title'=>'Reconcile','class'=>"row_modules"));?>





	<?php //echo $this->Html->link($this->Html->image('/img/icons/patient_hub/patient-referral2.jpg'). ' ' . __('Referral'),array('controller'=>'patients','action' => 'patient_referral',$patient['Patient']['id']),array('escape' => false,'title'=>'Patient Referral','class'=>"row_modules"));?>



	<?php // echo $this->Html->link($this->Html->image('/img/icons/nursing/admission-check-list-form.jpg',array('class'=>'resizeIcon')). ' ' . __('Reg. Cheq'), array('controller'=>'nursings','action' => 'admission_checklist',$patient['Patient']['id']), array('escape' => false,'title'=>'Registration Check List Form','class'=>"row_modules"));	?>



	<?php // echo $this->Html->link($this->Html->image('/img/icons/patient_hub/discharge2.jpg'). ' ' . __('Summary'), array('controller'=>'billings','action' => 'discharge_summary',$patient['Patient']['id'],'?'=>array('return'=>'patientInfo')),array('escape' => false,'title'=>'Summary','class'=>"row_modules"));?>



	<?php //echo $this->Js->link($this->Html->image('/img/icons/nursing/prescription.jpg',array('class'=>'resizeIcon','id'=>'doctorPres')). ' ' . __('Today\'s Rx'), array('controller'=>'nursings','action' => 'notes_view',$patient['Patient']['id']), array('escape'=>false,'update' => '#list_content','method'=>'post','complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'title'=>'Today\'s Rx','class'=>"row_modules")); ?>



	<?php //echo $this->Html->link($this->Html->image('/img/icons/patient_hub/tracheostomy.png',array('class'=>'resizeIcon')). ' ' . __('Trach. Consent'), array('controller'=>'nursings','action' => 'tracheostomy_consent_list',$patient['Patient']['id']), array('escape' => false,'title'=>'Tracheostomy Consent Form','class'=>"row_modules"));	?>



	<?php //echo $this->Html->link($this->Html->image('/img/icons/patient_hub/ventilators.png'). ' ' . __('Ventilator'), array('controller'=>'nursings','action' => 'ventilator_doctor_list',$patient['Patient']['id']), array('escape' => false,'title'=>'Ventilator Consent Form','class'=>"row_modules"));	?>



	<?php //echo $this->Html->link($this->Html->image('/img/icons/patient_hub/Ventilator.png',array('class'=>'resizeIcon')). ' ' . __('Ventilator Nurse Check List'), array('controller'=>'nursings','action' => 'ventilator_nurse_list',$patient['Patient']['id']), array('escape' => false,'title'=>'Ventilator Nurse Check List','class'=>"row_modules"));	?>
	<?php // echo $this->Html->link($this->Html->image('/img/icons/patient_hub/physiotherapy-assessment-form1.jpg',array('class'=>'resizeIcon')). ' ' . __('Cli. Summary'),'javascript:void(0)', array('id'=>"clinical-summary",'escape' => false,'title'=>'clinical summary','class'=>"row_modules"));?>
	<?php   //echo $this->Html->link($this->Html->image('/img/icons/patient_hub/physiotherapy-assessment-form1.jpg',array('class'=>'resizeIcon')). ' ' . __('Patient Permissions'),'javascript:void(0)', array('id'=>"patient_permissions",'escape' => false,'title'=>'Patient Permissions','class'=>"row_modules"));?>
	<?php //echo $this->Html->link($this->Html->image('/img/icons/bld_transfusion_icon.png',array('class'=>'resizeIcon')). ' ' . __('Vent. Order'), array('controller'=>'nursings','action' => 'ventilator_order',$patient['Patient']['id']), array('escape' => false,'title'=>'Ventilator/Sedation Order Set','class'=>"row_modules"));	?>



	<?php // }
//}?>

</div>


<script>
	var ajaxcreateCredentialsUrl ="<?php echo $this->Html->url(array("controller" => "messages", "action" => "createCredentials","admin" => false)); ?>"; ;//

	function createPatientCredentials(patientid){

		$
		.fancybox({
			'width' : '50%',
			'height' : '50%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'href' : "<?php echo $this->Html->url(array("controller" => "messages", "action" => "openFancyBox", $patient['Patient']['person_id'],$patient['Patient']['id'])); ?>"
		});
		 
	}
	
	function getAllergiesAddEdit(){
		$.fancybox({
			'width' : '70%',
			'height' : '100%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'onComplete' : function() {
				$("#allergies").css({
					'top' : '20px',

					'bottom' : 'auto',	
					
});
			},
			'href' : "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "allallergies",$patient['Patient']['id'])); ?>"

		});
	}

	$("#clinical-summary").click(function(){
		$ .fancybox({
			'width' : '60%',
			'height' : '125%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'href' : "<?php echo $this->Html->url(array("controller" => "ccda", "action" => "clinical_summary", $patient['Patient']['id'],$patient['Prson']['patient_uid'])); ?>"
		});
	}) ;

	$('#patient_permissions').click(function(){
		$ .fancybox({
			'width' : '60%',
			'height' : '125%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'href' : "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "patient_permissions", $patient['Patient']['id'])); ?>"
		});
	})
	
	</script>
