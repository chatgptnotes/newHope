<style>
    
a.blueBtn {
	padding: 4px 3px;
}

.interIconLink .iconLink {
	min-height: 40px;
	line-height: 1;
}

.interIconLink {
	height: 82px;
}

.patient-info-btn{
	height:23px;
}
.newqr-btn{
	background: #FF0000;
}
</style>

<?php
//BOF print OPD patient sheet
 if(isset($this->params->query['registration']) && $this->params->query['registration']=='done'){
		echo "<script>var win = window.open('".$this->Html->url(array('action'=>'opd_patient_detail_print',$patient['Patient']['id']))."', '_blank',
											'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  </script>"  ;
		?>
<script>
	if (!win)
		alert("Please enabled popups to continue.");
	else {
		win.onload = function() {
			setTimeout(function() {
				if (win.screenX === 0) {
					alert("Please enabled popups to continue.");
				} else {
					// close the test window if popups are allowed.
					//window.location='<?php echo $this->Html->url(array('action'=>'patient_information',$patient['Patient']['id']));?>' ;  
				}
			}, 0);
		};
	}
</script>
<?php }
//EOF print OPD patinet sheet

echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));
	 echo $this->Html->script(array('jquery.fancybox-1.3.4'));?>
<div class="inner_title">
	<?php 
	$complete_name  = $patient[0]['lookup_name'] ;
	//echo __('Set Appoinment For-')." ".$complete_name;
	?>
	<h3>
		&nbsp;
		<?php echo __('Patient Information-')." ".$complete_name ?>
	</h3>
	<span> <?php 

	if(isset($patient['Patient']['is_emergency']) AND $patient['Patient']['is_emergency'] == 1){
			echo $this->Html->link(__('Search Patient'),array('controller'=>'patients','action' => 'search','searchFor'=>'emergency','?'=>array('type'=>'emergency')), array('escape' => false,'class'=>'blueBtn'));
		} else {
			if(!empty($this->params->query) && (!isset($this->params->query['registration']))){
				echo $this->Html->link(__('Search Patient'),array('controller'=>'patients','action' => 'search','?'=>$this->params->query), array('escape' => false,'class'=>'blueBtn'));
			}else{
				echo $this->Html->link(__('Search Patient'),array('controller'=>'patients','action' => 'search','?'=>array('type'=>$patient['Patient']['admission_type'])), array('escape' => false,'class'=>'blueBtn'));
			}
		}
		?>
	</span>
</div>

<?php

if(!empty($errors)) {
	?>
<table border="0" cellpadding="0" cellspacing="0" width="60%" align="center">
	<tr>
		<td colspan="2" align="left" class="error"><?php 
		foreach($errors as $errorsval){
	         echo $errorsval[0];
	         echo "<br />";
	     }
	     ?>
		</td>
	</tr>
</table>
<?php } ?>

<div class="inner_left">
	<?php echo $this->element('patient_information');//&& $patient['Patient']['is_discharge']==0  ?> 
	<div id='rxframeid'
		style='position: relative; display: none; align: center; top: 0px; overflow: hidden;'>
		<div style="overflow: hidden;">
			<a href="javascript:void(0)"
				onclick="javascript:closeRx();"
				title="Close"><img
				style="position: absolute; top: -2px; right: 52px;"
				src="<?php echo $this->webroot?>img/fancy/fancy_close.png"
				alt="Close" title="Close" /> </a>
		</div>
		<iframe name="aframe" id="aframe" frameborder="0" onload="load();"></iframe>
	</div>
	 
	<table style="width:100%"  >
	 	<tr> 
		<td valign="top" height="" class="" style="width:80%;">
		<div class="internalIcon">
			<?php if($patient['Patient']['admission_type'] == 'OPD'){?>
			<!-- <div class="tdLabel2">OPD</div> -->
	
			<?php if($patient['Patient']['is_discharge']==0){?>
			<div class="interIconLink">
				<div class="icon">
					<?php  echo $this->Js->link($this->Html->image('/img/icons/patient_hub/appoinment.jpg'), array('controller'=>'appointments','action' => 'appointmentList',$patient['Patient']['id']), array('escape'=>false,'update' => '#list_content','method'=>'post','complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))));
	
						   //echo $this->Html->link($this->Html->image('/img/icons/appointment.png'), array('controller'=>'appointments','action' => 'appointmentList',$patient['Patient']['id']),array('update' => '#list_content','method'=>'post','complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))),array('escape' => false,'title'=>'Add Appt.'));?>
				</div>
				<div class="iconLink">Add Appt.</div>
			</div>
			<?php } ?>
			<div class="interIconLink">
				<div class="icon">

					<?php echo $this->Html->link($this->Html->image('/img/icons/patient_insurance.png'), array('controller'=>'patients','action' => 'insuranceindex',$patient['Patient']['id']),array('escape' => false,'title'=>'PatientInsurace'));?>

					
				</div>
				<div class="iconLink">
					<?php echo __('Patient Insurance'); ?>
				</div>
			</div>
			<div class="interIconLink">
				<div class="icon">
					<?php $usertype=$this->Session->read('facilityu',$facility['Facility']['usertype']); 
					if($usertype="ambulatory"){
							echo $this->Html->link($this->Html->image('/img/icons/patient_hub/initial_assessment2.jpg'), array('controller'=>'diagnoses','action' => 'add_ambi',$patient['Patient']['id']), array('escape' => false,'title'=>'Initial Assessment'));
				}
				else{
							echo $this->Html->link($this->Html->image('/img/icons/patient_hub/initial_assessment2.jpg'), array('controller'=>'diagnoses','action' => 'add',$patient['Patient']['id']), array('escape' => false,'title'=>'Initial Assessment'));
				}
				?>
	
				</div>
				<div class="iconLink">Initial Assessment</div>
			</div>
			<div class="interIconLink">
				<div class="icon">
					<?php 
					echo $this->Js->link($this->Html->image('/img/icons/patient_hub/notes2.jpg',array('id'=>'prescriptionLink')), array('controller'=>'patients','action' => 'patient_notes',$patient['Patient']['id'],'#list_patient'), array('escape'=>false,'update' => '#list_content','method'=>'post','complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'title'=>'Charts'));
						
					?>
				</div>
				<div class="iconLink">Charts</div>
	
			</div>
			<?php if($patient['Patient']['is_discharge']==0){?>
			<div class="interIconLink">
	
				<div class="icon">
					<?php echo $this->Html->link($this->Html->image('/img/icons/patient_hub/request-diagnostic.png'), array('controller'=>'laboratories','action' => 'lab_order',$patient['Patient']['id'],'?'=>array('return'=>'hub')), array('escape' => false,'title'=>'Request Diagnostic Test'));?>
				</div>
				<div class="iconLink">Test Order</div>
			</div>
			<?php } ?>
			<div class="interIconLink">
				<div class="icon">
					<?php echo $this->Html->link($this->Html->image('/img/icons/patient_hub/laboratory2.jpg'), array('controller'=>'laboratories','action' => 'labTestHl7List',$patient['Patient']['id']), array('escape' => false,'title'=>'Laboratory-Result'));?>
				</div>
				<div class="iconLink">Laboratory Result</div>
			</div>
	
			<div class="interIconLink">
				<div class="icon">
					<?php echo $this->Html->link($this->Html->image('/img/icons/patient_hub/radiology2.jpg'), array('controller'=>'radiologies','action' => 'radiology_test_list',$patient['Patient']['id']), array('escape' => false,'title'=>'Radiology'));	?>
				</div>
				<div class="iconLink">Radiology Result</div>
			</div>
			<?php if($patient['Patient']['is_discharge']==0){?>
			<div class="interIconLink">
				<div class="icon">
					<?php echo $this->Html->link($this->Html->image('/img/icons/patient_hub/patient-survey2.jpg'), array('controller'=>'surveys','action' => 'opd_patient_surveys',$patient['Patient']['id']), array('escape' => false,'title'=>'OPD Patient Survey'));?>
				</div>
				<div class="iconLink">OPD Patient Survey</div>
			</div>
			<?php } ?>
			<!--  <div class="interIconLink">
				<div class="icon">
					<?php //echo $this->Html->link($this->Html->image('/img/icons/police-form.jpg'), array('controller'=>'patients','action' => 'police_forms',$patient['Patient']['id'],'?'=>array('return'=>'patientInfo')),
							 	//array('escape' => false,'title'=>'Police Form'));?>
				</div>
				<div class="iconLink">
					<?php //echo __('Police Form'); ?>
				</div>
			</div>-->
			<div class="interIconLink">
				<div class="icon">
					<?php //echo $this->Html->link($this->Html->image('/img/icons/credentials inner.png',array('width'=>'64px','height'=>'64px')), array('controller'=>'messages','action' => 'createCredentials',$patient['Patient']['id'],'?'=>array('return'=>'patientInfo')),
					//array('escape' => false,'title'=>'Create Patient Credentials'));
					//echo $this->Html->image('/img/icons/credentials inner.png',array('alt'=>'Create Patient Credentials','title'=>'Create Patient Credentials','onClick'=>"javascript:createPatientCredentials('$patient_id')"));
					echo '<a href="#">';
					$pat_uid = $patient['Patient']['id'];
					echo $this->Html->image('/img/icons/patient_hub/credentialpng.jpg',array('alt'=>'Create Patient Credentials','title'=>'Create Patient Credentials','onClick'=>"createPatientCredentials('$pat_uid')"));
					echo '</a>';
					?>
				</div>
				<div class="iconLink">
					<?php echo __('Create Patient Credentials'); ?>
				</div>
			</div>
	
			<div class="interIconLink">
				<div class="icon">
					<?php echo $this->Html->link($this->Html->image('/img/icons/patient_hub/IMMUNIZATION.jpg'), array('controller'=>'imunization','action' => 'index',$patient['Patient']['id'],'?'=>array('return'=>'patientInfo')),
							 	array('escape' => false,'title'=>'Immunization'));?>
				</div>
				<div class="iconLink">
					<?php echo __('Immunization'); ?>
				</div>
			</div>
	
			<div class="interIconLink">
				<div class="icon">
					<?php echo $this->Html->link($this->Html->image('/img/icons/patient_hub/MESSAGE.jpg'), array('controller'=>'messages','action' => 'index',$patient['Patient']['id'],'?'=>array('return'=>'patientInfo')),
							 	array('escape' => false,'title'=>'Messages'));?>
	
				</div>
				<div class="iconLink">
					<?php echo __('Messages'); ?>
				</div>
			</div>
			<div class="interIconLink">
				<div class="icon">
					<?php // echo $this->Js->link($this->Html->image('/img/icons/patient_hub/physiotherapy-assessment-form1.jpg'), array('controller'=>'ccda','action' => 'clinical_summary',$patient['Patient']['id'],$patient['Patient']['patient_id']), array('escape'=>false,'update' => '#list_content','method'=>'post','complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'title'=>'Clinical Summary'));?>
	
	
				</div>
				<div class="iconLink">
					<?php echo __('Clinical Summary'); ?>
				</div>
			</div>
			<div class="interIconLink">
				<div class="icon">
					<?php echo $this->Html->link($this->Html->image('/img/icons/patient_hub/patient-referral2.jpg'),
							array('controller'=>'patients','action' => 'patient_referral',$patient['Patient']['id']),
					array('escape' => false,'title'=>'Patient Referral'));	?>
				</div>
				<div class="iconLink">
					<?php echo __('Patient Referral');?>
				</div>
			</div>
			<div class="interIconLink">
				<div class="icon">
					<?php echo $this->Html->link($this->Html->image('/img/icons/patient_hub/reconcile.png'), array('controller'=>'patients','action' => 'reconcile',$patient['Patient']['id']),array('escape' => false,'title'=>'Reconcile'));?>
				</div>
				<div class="iconLink">
					<?php echo __('Reconcile'); ?>
				</div>
			</div>
			
			<div class="interIconLink">
				<div class="icon">
					<?php echo $this->Html->link($this->Html->image('/img/icons/patient_hub/discharge2.jpg'), array('controller'=>'billings','action' => 'discharge_summary',$patient['Patient']['id'],'?'=>array('return'=>'patientInfo')),
							 	array('escape' => false,'title'=>'Summary'));?>
				</div>
				<div class="iconLink">
					<?php echo __('Summary By Consultant'); ?>
				</div>
			</div>
			<div class="clr ht5">&nbsp;</div>
	
	
			<div>&nbsp;</div>
			<?php } else if($patient['Patient']['admission_type'] == 'IPD'){?>
			<!-- <div class="tdLabel2">IPD</div> -->
	
	
			<div class="interIconLink">
				<div class="icon">
					<?php echo $this->Html->link($this->Html->image('/img/icons/patient_hub/consent-form.png'), array('controller'=>'consents','action' => 'index',$patient['Patient']['id']), array('escape' => false,'title'=>'Consent Form'));	?>
				</div>
				<div class="iconLink">Consent</div>
			</div>
			<div class="interIconLink">
				<div class="icon">
					<?php echo $this->Html->link($this->Html->image('/img/icons/patient_hub/tracheostomy-consent2.jpg'), array('controller'=>'nursings','action' => 'tracheostomy_consent_list',$patient['Patient']['id']), array('escape' => false,'title'=>'Tracheostomy Consent Form'));	?>
				</div>
				<div class="iconLink">
					<?php echo __('Trac. Consent');?>
				</div>
	
			</div>
			<div class="interIconLink">
				<div class="icon">

					<?php echo $this->Html->link($this->Html->image('/img/icons/patient_insurance.png'), array('controller'=>'patients','action' => 'insuranceindex',$patient['Patient']['id']),array('escape' => false,'title'=>'PatientInsurace'));?>

					
				</div>
				<div class="iconLink">
					<?php echo __('Patient Insurance'); ?>
				</div>
			</div>
			<div class="interIconLink">
				<div class="icon">
					<?php echo $this->Html->link($this->Html->image('/img/icons/patient_hub/ventilator-consent2.jpg'), array('controller'=>'nursings','action' => 'ventilator_consent_list',$patient['Patient']['id']), array('escape' => false,'title'=>'Ventilator Consent Form'));	?>
				</div>
				<div class="iconLink">
					<?php echo __('ICU Consent');?>
				</div>
			</div>
			<div class="interIconLink">
				<div class="icon">
					<?php echo $this->Html->link($this->Html->image('/img/icons/patient_hub/ventilator-consent2.jpg'), array('controller'=>'nursings','action' => 'ventilator_doctor_list',$patient['Patient']['id']), array('escape' => false,'title'=>'Ventilator Consent Form'));	?>
				</div>
				<div class="iconLink">
					<?php echo __('Ventilator');?>
				</div>
			</div>
			<div class="interIconLink">
				<div class="icon">
					<?php echo $this->Html->link($this->Html->image('/img/icons/patient_hub/initial_assessment2.jpg'), array('controller'=>'diagnoses','action' => 'add',$patient['Patient']['id']), array('escape' => false,'title'=>'Initial Assessment'));	?>
				</div>
				<div class="iconLink">Initial Assess</div>
			</div>
	
			<div class="interIconLink">
				<div class="icon">
					<?php 
					echo $this->Js->link($this->Html->image('/img/icons/patient_hub/notes2.jpg',array('id'=>'prescriptionLink')), array('controller'=>'patients','action' => 'patient_notes',$patient['Patient']['id'],'#list_patient'), array('escape'=>false,'update' => '#list_content','method'=>'post','complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'title'=>'SOAP Notes'));
						
					?>
				</div>
				<div class="iconLink">SOAP</div>
	
			</div>
			<?php // if($patient['Patient']['is_discharge']==0){?>
			<!-- <div class="interIconLink">
				<div class="icon">
					<?php // echo $this->Html->link($this->Html->image('/img/icons/patient_hub/request-diagnostic2.jpg'), array('controller'=>'laboratories','action' => 'lab_order',$patient['Patient']['id'],'?'=>array('return'=>'hub')), array('escape' => false,'title'=>'Request Diagnostic Test'));?>
				</div>
				<div class="iconLink">Test Order</div>
			</div> -->
			<?php // } ?>
			<div class="interIconLink">
				<div class="icon">
					<?php echo $this->Html->link($this->Html->image('/img/icons/patient_hub/laboratory2.jpg'), array('controller'=>'laboratories','action' => 'labTestHl7List',$patient['Patient']['id'],'?'=>array('return'=>'patients')), array('escape' => false,'title'=>'Laboratory-Result'));?>
				</div>
				<div class="iconLink">Lab. Result</div>
			</div>
	
			<div class="interIconLink">
				<div class="icon">
					<?php echo $this->Html->link($this->Html->image('/img/icons/patient_hub/radiology2.jpg'), array('controller'=>'radiologies','action' => 'radiology_test_list',$patient['Patient']['id'],'?'=>array('return'=>'patients')), array('escape' => false,'title'=>'Radiology'));?>
				</div>
				<div class="iconLink">Rad. Result</div>
			</div>
	
			<div class="interIconLink">
				<div class="icon">
					<?php echo $this->Html->link($this->Html->image('/img/icons/patient_hub/hia-assessment2.jpg'), array('controller'=>'hospital_acquire_infections','action' => 'index',$patient['Patient']['id']), array('escape' => false, 'title'=>'HAI Assessment', 'alt'=>'HAI Assessment'));?>
				</div>
				<div class="iconLink">HAI Assess.</div>
			</div>
			<?php if($patient['Patient']['is_discharge']==0){ ?>
			<div class="interIconLink">
				<div class="icon">
					<?php echo $this->Html->link($this->Html->image('/img/icons/patient_hub/patient-survey2.jpg'), array('controller'=>'surveys','action' => 'patient_surveys',$patient['Patient']['id']), array('escape' => false,'title'=>'IPD Patient Survey'));?>
				</div>
				<div class="iconLink">Pt. Survey</div>
			</div>
			<?php } ?>
			
			<div class="interIconLink">
				<div class="icon">
					<?php echo $this->Html->link($this->Html->image('/img/icons/patient_hub/incident-form2.jpg'), array('controller'=>'incidents','action' => 'add',$patient['Patient']['id'],), array('escape' => false,'title'=>'Incident Form'));?>
				</div>
				<div class="iconLink">Incident</div>
			</div>
			
			<div class="interIconLink">
				<div class="icon">
					<?php echo $this->Html->link($this->Html->image('/img/icons/patient_hub/dietary-assessment.jpg'), array('controller'=>'nursings','action' => 'dietaryAssessment',$patient['Patient']['id'],'patients'), array('escape' => false,'title'=>'Dietary Assessment'));?>
				</div>
				<div class="iconLink">Diet Assess</div>
			</div>
			
			<?php if($patient['Patient']['sex']=='female'){ ?>
			<div class="interIconLink">
				<div class="icon">
					<?php echo $this->Html->link($this->Html->image('/img/icons/patient_hub/child-birth.jpg'), array('controller'=>'patients','action' => 'child_birth_list',$patient['Patient']['id'],'?'=>array('return'=>'patients')),
							 	array('escape' => false,'title'=>'Child Birth'));?>
				</div>
				<div class="iconLink">
					<?php echo __('Birth'); ?>
				</div>
			</div>
			<?php } ?>
	
	
			<div class="interIconLink">
				<div class="icon">
					<?php echo $this->Html->link($this->Html->image('/img/icons/patient_hub/blood-sugar-monitor-chart2.jpg'), array('controller'=>'nursings','action' => 'blood_sugar_monitoring',$patient['Patient']['id']), array('escape' => false,'title'=>'Blood Sugar Monitoring Chart'));	?>
				</div>
				<div class="iconLink">
					<?php echo __('Bl. Sugar');?>
				</div>
			</div>
			<div class="interIconLink">
				<div class="icon">
					<?php echo $this->Html->link($this->Html->image('/img/icons/patient_hub/blood-requisition2.jpg'), array('controller'=>'blood_banks','action' => 'index',$patient['Patient']['id']), array('escape' => false,'title'=>'Blood Requisition'));	?>
				</div>
				<div class="iconLink">
					<?php echo __('Bl. Requi');?>
				</div>
			</div>
			<div class="interIconLink">
				<div class="icon">
					<?php echo $this->Html->link($this->Html->image('/img/icons/patient_hub/blood-transfusion2.jpg'), array('controller'=>'nursings','action' => 'patient_blood_transfusion_list',$patient['Patient']['id']), array('escape' => false,'title'=>'Blood Transfusion Progress Form'));	?>
				</div>
				<div class="iconLink">
					<?php echo __('B.T. Progress');?>
				</div>
			</div>
	
			<div class="interIconLink">
				<div class="icon">
					<?php echo $this->Html->link($this->Html->image('/img/icons/patient_hub/ivf2.jpg'), array('controller'=>'nursings','action' => 'patient_ivf_list',$patient['Patient']['id']), array('escape' => false,'title'=>'I.V.F.'));	?>
				</div>
				<div class="iconLink">
					<?php echo __('I.V.F.');?>
				</div>
			</div>
			<div class="interIconLink">
				<div class="icon">
					<?php echo $this->Html->link($this->Html->image('/img/icons/patient_hub/patient-referral2.jpg'),
							array('controller'=>'patients','action' => 'patient_referral',$patient['Patient']['id']),
					array('escape' => false,'title'=>'Patient Referral'));	?>
				</div>
				<div class="iconLink">
					<?php echo __('Referral');?>
				</div>
			</div>
	
			<div class="interIconLink">
				<div class="icon">
					<?php echo $this->Html->link($this->Html->image('/img/icons/patient_hub/patient-documents2.jpg'), array('controller'=>'patient_documents','action' => 'index',$patient['Patient']['id']),array('escape' => false,'title'=>'Patient\'s Documents'));?>
				</div>
				<div class="iconLink">
					<?php echo __('Pt. Doc.'); ?>
				</div>
			</div>
			<div class="interIconLink">
				<div class="icon">
					<?php echo $this->Html->link($this->Html->image('/img/icons/patient_hub/discharge2.jpg'), array('controller'=>'billings','action' => 'discharge_summary',$patient['Patient']['id'],'?'=>array('return'=>'patientInfo')),
							 	array('escape' => false,'title'=>'Summary'));?>
				</div>
				<div class="iconLink">
					<?php echo __('Summary'); ?>
				</div>
			</div>
	<!--  	<div class="interIconLink">
				<div class="icon">
					<?php //echo $this->Html->link($this->Html->image('/img/icons/patient_hub/police-form2.jpg'), array('controller'=>'patients','action' => 'police_forms',$patient['Patient']['id'],'?'=>array('return'=>'patientInfo')),
							 	//array('escape' => false,'title'=>'Police Form'));?>
				</div>
				<div class="iconLink">
					<?php //echo __('Police'); ?>
				</div>
			</div>-->
			<div class="interIconLink">
				<div class="icon">
					<?php echo $this->Html->link($this->Html->image('/img/icons/patient_hub/DEATHRECORDS.jpg'), array('controller'=>'billings','action' => 'death_summary',$patient['Patient']['id'],'?'=>array('return'=>'patientInfo')),
							 	array('escape' => false,'title'=>'Death Records'));?>
	
				</div>
				<div class="iconLink">
					<?php echo __('Death Rec.'); ?>
				</div>
	
			</div>
	
	<?php if(!empty($advanceData['AdvanceDirective']['person1_name']) ){ ?>
			<div class="interIconLink">
				<div class="icon">
					<?php echo $this->Html->link($this->Html->image('/img/icons/patient_hub/advance.jpg'), array('controller'=>'patients','action' =>'search_advance_directive',$patient['Patient']['id'],$patient['Patient']['admission_id']), array('escape' => false,'title'=>'Advance Directive'));	?>
				</div>
				<div class="iconLink">
					<?php echo __('Adv. Directive'); ?>
				</div>
			</div>
	<?php }else{?>
		<div class="interIconLink">
				<div class="icon">
					<?php echo $this->Html->link($this->Html->image('/img/icons/patient_hub/advance.jpg'), array('controller'=>'patients','action' =>  'advance_directive',$patient['Patient']['id'],$patient['Patient']['admission_id']), array('escape' => false,'title'=>'Advance Directive'));	?>
				</div>
				<div class="iconLink">
					<?php echo __('Adv. Directive'); ?>
				</div>
			</div>
					<?php }?>		
	
			<div class="interIconLink">
				<div class="icon">
					<?php //echo $this->Html->link($this->Html->image('/img/icons/credentialpng.jpg',array('width'=>'64px','height'=>'64px')), array('controller'=>'messages','action' => 'createCredentials',$patient['Patient']['id'],'?'=>array('return'=>'patientInfo')),
	
					///array('escape' => false,'title'=>'Create Patient Credentials'));
					echo '<a href="#">';
					$pat_uid = $patient['Patient']['id'];
					echo $this->Html->image('/img/icons/patient_hub/credentialpng.jpg',array('alt'=>'Create Patient Credentials','title'=>'Create Patient Credentials','onClick'=>"createPatientCredentials('$pat_uid')"));
					echo '</a>';
					?>
	
				</div>
				<div class="iconLink">
					<?php echo __('Pt.Credential'); ?>
				</div>
			</div>
	
			<div class="interIconLink">
				<div class="icon">
					<?php echo $this->Html->link($this->Html->image('/img/icons/patient_hub/MESSAGE.jpg'), array('controller'=>'messages','action' => 'index',$patient['Patient']['id'],'?'=>array('return'=>'patientInfo')),
							 	array('escape' => false,'title'=>'Messages'));?>
	
				</div>
				<div class="iconLink">
					<?php echo __('Messages'); ?>
				</div>
			</div>
	
			<div class="interIconLink">
				<div class="icon">
					<?php echo $this->Html->link($this->Html->image('/img/icons/patient_hub/IMMUNIZATION.jpg'), array('controller'=>'imunization','action' => 'index',$patient['Patient']['id']),array('escape' => false,'title'=>'Immunization'));?>
				</div>
				<div class="iconLink">
					<?php echo __('Immunization'); ?>
				</div>
			</div>
	
			<div class="interIconLink">
				<div class="icon">
					<?php echo $this->Html->link($this->Html->image('/img/icons/patient_hub/reconcile.png'), array('controller'=>'patients','action' => 'reconcile',$patient['Patient']['id']),array('escape' => false,'title'=>'Reconcile'));?>
				</div>
				<div class="iconLink">
					<?php echo __('Reconcile'); ?>
				</div>
			</div>
	
	
	
			<?php } ?>
	
			<div class="interIconLink">
				<div class="icon">
					<?php echo $this->Html->link($this->Html->image('/img/icons/patient_hub/MESSAGE.jpg'), array('controller'=>'patients','action' => 'meaningful_dashboard',$patient['Patient']['id'],'?'=>array('return'=>'patientInfo')),
							 	array('escape' => false,'title'=>'Messages'));?>
	
	
				</div>
				<div class="iconLink">
					<?php echo __('MeaningFull DashBoard'); ?>
				</div>
			</div>
	
	
	
	
		</div>
		</td>
		<td>
			<?php    if($this->Session->read('role') !='doctor'){ ?>
				<div id="fun_btns">
					<table>
						<tr>
							<td><div class="patient-info-btn">
							
							<?php $usertype=$this->Session->read('facilityu',$facility['Facility']['usertype']);
								
							if($usertype=='hospital' || $usertype==''){
												echo $this->Html->link(__('Edit Patient'),
												    array('action'=>'edit',$id,'?'=>$this->params->query),
												    array('escape' => false,'class'=>'blueBtn'));
													}
													else{
															echo $this->Html->link(__('Edit Patient'),
												    		array('action'=>'edit_ambi',$id,'?'=>$this->params->query),
												   		    array('escape' => false,'class'=>'blueBtn','div'=>true));
														}
														?></div></td>
							</tr><tr><td ><div class="patient-info-btn"><?php
			
							echo $this->Html->link(__('Past Visits'),
												    "/persons/patient_information/".$patient['Patient']['person_id'],
												    array('escape' => false,'class'=>'blueBtn'));
											?>
							</div></td>
							</tr><tr>
							<td><div class="patient-info-btn"><?php
							echo $this->Html->link(__('Wrist Band'),
												     '#',
												     array('escape' => false,'class'=>'blueBtn','onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'wrist_band',$id))."', '_blank',
												           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=1000,height=100,left=400,top=400');  return false;"));
				   							?>
							</div></td>
							<?php if($patient['Patient']['admission_type'] == 'OPD' && $isToken){ ?>
							</tr><tr><td><div class="patient-info-btn"><?php
							echo $this->Html->link(__('View Token'),
												     '#',
												     array('escape' => false,'class'=>'blueBtn','onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'print_token',$id))."', '_blank',
												           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=600,left=400,top=300,height=300');  return false;"));
				   							?>
							</div></td>
							<?php } ?>
							</tr><tr><td><div class="patient-info-btn"><?php
							
							echo $this->Html->link(__('QR Card') ,
												     '#',
												     array('escape' => false,'class'=>'blueBtn','onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'qr_card',$id))."', '_blank',
												           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=600,left=400,top=300,height=300');  return false;"));
				   							?>
							</div></td>
							</tr>
							<tr id = 'medication-Qr'><td><div class="patient-info-btn"><?php
							//$style = $this->Session->read('newQRMedication') == true ? "blueBtn newqr-btn" : "blueBtn";
							
							echo $this->Html->link(__('QR Medication') ,
												     '#',
												     array('escape' => false,'class'=>'blueBtn','id'=>'qrmedication','onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'qr_medication',$id))."', '_blank',
												           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=600,left=400,top=300,height=300');  return false;"));
				   							?>
							</div></td>
							</tr>
							<tr><td><div class="patient-info-btn"><?php
							echo $this->Html->link(__('QR Sticker') ,
												     '#',
												     array('escape' => false,'class'=>'blueBtn','onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'qr_sticker_print',$id))."', '_blank',
												           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=800,left=400,top=300,height=800');  return false;"));
				   							?>
							</div></td>
						<!-- 	<td><?php
							echo $this->Html->link(__('Print Sheet'),
												     '#',
												     array('escape' => false,'class'=>'blueBtn','onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'opd_patient_detail_print',$id))."', '_blank',
												           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,left=200,top=200,height=800');  return false;"));
				   							?>
							</td>  blueBtn_hl7-->
							<?php echo $this->Form->create('User', array('type' => 'post','url' => 'https://secure.newcropaccounts.com/InterfaceV7/RxEntry.aspx','target'=>'aframe'));?>
							</tr><tr><td><?php echo $this->Form->submit('Rx', array('class'=> 'blueBtn', 'id'=>'Rx', 'label'=> false,'div' => false)); ?>
			
							 </td></tr> 
			
							<!-- medication & allergi checkbox added by vikas -->
							<td ><?php 	if($medication==0 ){?> <?php echo $this->Form->checkbox('NewCropPrescription.uncheck',array('id'=>'uncheck','style'=>'float:left','onclick'=>"javascript:save_checkinfo();"));?>
							<label style="width:auto;padding-top:3px;text-align:left;" >No Active Med</label> <?php }?> <?php 	if($allergy==0 ){?></td>
							</tr>
							<tr><td ><?php echo $this->Form->checkbox('NewCropAllergies.allergycheck',array('id'=>'allergycheck','style'=>'float:left ','onclick'=>"javascript:save_checkallergy();"));?>
							<label style="width:auto;padding-top:3px;text-align:left;"  >No Active Allergies</label></td>
							<?php }?> 
						<!-- <tr>
							<td align="center"><div
									style="text-align: center; margin: 15px 0px 0px 5px; display: none;"
									class="loader">
									<?php echo $this->Html->image('indicator.gif'); ?>
								</div></td>
						</tr> -->
						<tr>
							<td colspan="8" style="display: none"><textarea id="RxInput"
									name="RxInput" rows="33" cols="79">
									<?php echo $patient_xml?>
								</textarea></td>
						</tr>
			
			   
						<?php echo $this->Form->end();?>
			
			
						</tr>
					</table>
				</div>
				<?php }else{ ?>
				<div id="fun_btns">
					<table>
						<tr>
							<td><?php
							echo $this->Html->link(__('Edit Patient Information'),
												    array('action'=>'edit',$id,'?'=>$this->params->query),
												    array('escape' => false,'class'=>'blueBtn'));
											?>
							</td>
							<td><?php
							echo $this->Html->link(__('Previous Visit Details'),
												    "/persons/patient_information/".$patient['Patient']['person_id'],
												    array('escape' => false,'class'=>'blueBtn'));
											?>
							</td>
						</tr>
					</table>
				</div>
				<?php } ?>
		</td>
		</tr>
	</table>
	<?php echo $this->Js->writeBuffer();?>
<script>
	jQuery(document)
			.ready(
					function() {
						$('#dischargebyconsultant')
								.click(
										function() {
											$
													.fancybox({
														'width' : '80%',
														'height' : '90%',
														'autoScale' : true,
														'transitionIn' : 'fade',
														'transitionOut' : 'fade',
														'type' : 'iframe',
														'href' : "<?php echo $this->Html->url(array("controller" => "patients", "action" => "child_birth", $patient['Patient']['id'])); ?>"
													});

										});
						$("#prescriptionLink").click(function() {

							window.location.href = "#list_content";

						});

					});

	jQuery(document).click(function() {
		$("a").click(function() {
			$("form").validationEngine('hide');
		});

	});


</script>