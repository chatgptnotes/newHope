<style>
.resizeIcon{
width:55px;
height:55px;
}
</style>
	<div class="interIconLink">
		<div class="icon">
			<?php echo $this->Html->link($this->Html->image('/img/icons/nursing/admission-check-list-form.jpg',array('class'=>'resizeIcon')), array('controller'=>'nursings','action' => 'admission_checklist',$patient['Patient']['id']), array('escape' => false,'title'=>'Registration Check List Form'));	?>
		</div>
		<div class="iconLink">Reg. Cheq</div>
	</div>
	<div class="interIconLink">
		<div class="icon">
			<?php echo $this->Html->link($this->Html->image('/img/icons/patient_hub/tracheostomy.png',array('class'=>'resizeIcon')), array('controller'=>'nursings','action' => 'tracheostomy_consent_list',$patient['Patient']['id']), array('escape' => false,'title'=>'Tracheostomy Consent Form'));	?>
		</div>
		<div class="iconLink">
			<?php echo __('Trach. Consent');?>
		</div>

	</div>
	<div class="interIconLink">
		<div class="icon">
			<?php echo $this->Html->link($this->Html->image('/img/icons/patient_hub/ICU_Consent.png',array('class'=>'resizeIcon')), array('controller'=>'nursings','action' => 'ventilator_consent_list',$patient['Patient']['id']), array('escape' => false,'title'=>'ICU Consent Form'));	?>
		</div>
		<div class="iconLink">
			<?php echo __('ICU Consent');?>
		</div>
	</div>

	<div class="interIconLink">
		<div class="icon">
			<?php echo $this->Html->link($this->Html->image('/img/icons/patient_hub/Ventilator.png',array('class'=>'resizeIcon')), array('controller'=>'nursings','action' => 'ventilator_nurse_list',$patient['Patient']['id']), array('escape' => false,'title'=>'Ventilator Nurse Check List'));	?>
		</div>
		<div class="iconLink">
			<?php echo __('Ventilator Nurse Check List');?>
		</div>
	</div>

	<!-- <div class="interIconLink">
			<div class="icon"><?php echo $this->Html->link($this->Html->image('/img/icons/nursing/nursing-assessment.jpg',array('class'=>'resizeIcon')), array('controller'=>'nursings','action' => 'assessment_first_admission',$patient['Patient']['id']), array('escape' => false,'title'=>'Nursing Assessment'));	?></div>
			<div class="iconLink">Nursing Assessment</div>
	   </div> -->

	<div class="interIconLink">
		<div class="icon">
			<?php echo $this->Html->link($this->Html->image('/img/icons/nursing/observation-chart.jpg',array('class'=>'resizeIcon')), array('controller'=>'nursings','action' => 'observation_chart_list',$patient['Patient']['id']), array('escape' => false,'title'=>'Observation Chart'));	?>
		</div>
		<div class="iconLink">Chart</div>
	</div>

	<?php // if($role == 'Nurse'){ ?>
	<!-- created as non js link -->
	<div class="interIconLink">
		<div class="icon">
			<?php 
			echo $this->Js->link($this->Html->image('/img/icons/nursing/prescription.jpg',array('class'=>'resizeIcon','id'=>'doctorPres')), array('controller'=>'nursings','action' => 'notes_view',$patient['Patient']['id']), array('escape'=>false,'update' => '#list_content','method'=>'post','complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'title'=>'Today\'s Rx')); ?>
		</div>
		<div class="iconLink">Today's Rx</div>

	</div>
	<?php //  } ?>
	<!-- <div class="interIconLink">
		<div class="icon">
			<?php 
			echo $this->Js->link($this->Html->image('/img/icons/nursing/prescription.jpg',array('id'=>'doctorPres')), array('controller'=>'nursings','action' => 'notes_list',$patient['Patient']['id']), array('escape'=>false,'update' => '#list_content','method'=>'post','complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'title'=>'Doctors Prescription')); ?>
		</div>
		<div class="iconLink">Doctor's Prescription</div>

	</div>
	<div class="interIconLink">
		<div class="icon">
			<?php echo $this->Html->link($this->Html->image('/img/icons/laboratory.png',array('class'=>'resizeIcon')), array('controller'=>'laboratories','action' => 'lab_test_list',$patient['Patient']['id'],'?'=>array('return'=>'nursings')), array('escape' => false,'title'=>'Laboratory-Result'));?>
		</div>
		<div class="iconLink">Laboratory Result</div>
	</div> -->

	<div class="interIconLink">
		<div class="icon">
			<?php echo $this->Html->link($this->Html->image('/img/icons/radiology.png',array('class'=>'resizeIcon')), array('controller'=>'radiologies','action' => 'radiology_test_list',$patient['Patient']['id'],'?'=>array('return'=>'nursings')), array('escape' => false,'title'=>'Radiology Result'));?>
		</div>
		<div class="iconLink">Rad. Result</div>
	</div>
	<div class="interIconLink">

		<div class="icon">
			<?php echo $this->Html->link($this->Html->image('/img/icons/nursing/nursing-quality-indicator.jpg',array('class'=>'resizeIcon')), array('controller'=>'nursings','action' => 'quality_monitoring_format',$patient['Patient']['id']), array('escape' => false,'title'=>'Nursing Sensitive Quality Indicators Monitoring Format'));?>
		</div>
		<div class="iconLink">Quality Indicators</div>
	</div>


	<div class="interIconLink">
		<div class="icon">
			<?php echo $this->Html->link($this->Html->image('/img/icons/nursing/fall-assessment.jpg',array('class'=>'resizeIcon')), array('controller'=>'nursings','action' => 'fall_assessment',$patient['Patient']['id']), array('escape' => false,'title'=>'Fall Assessment'));	?>
		</div>
		<div class="iconLink">Fall Assessment</div>
	</div>

	<div class="interIconLink">
		<div class="icon">
			<?php echo $this->Html->link($this->Html->image('/img/icons/nursing/fall-assessment-summary.jpg',array('class'=>'resizeIcon')), array('controller'=>'nursings','action' => 'fall_assessment_summary',$patient['Patient']['id']), array('escape' => false,'title'=>'Fall Assessment Summary'));?>
		</div>
		<div class="iconLink">Fall Summary</div>
	</div>

	<div class="interIconLink">
		<div class="icon">
			<?php echo $this->Html->link($this->Html->image('/img/icons/hia-assessment.png',array('class'=>'resizeIcon')), array('controller'=>'hospital_acquire_infections','action' => 'index',$patient['Patient']['id'],'sendTo'=>'nursings'), array('escape' => false,'title'=>'HAI Assessment'));?>
		</div>
		<div class="iconLink">HAI Assessment</div>
	</div>
	<?php if($this->params->query['type'] == 'IPD'){?>
	 <div class="interIconLink">
			<div class="icon">
				<?php echo $this->Html->link($this->Html->image('/img/icons/nursing/hipaa.png',array('class'=>'resizeIcon')), 
						array('controller'=>'nursings','action' => 'hippa_consent_list',$patient['Patient']['id']), 
						array('escape' => false,'title'=>'Hipaa Consent'));	?>
			</div>
			<div class="iconLink">
				<?php echo __('Hipaa Consent');?>
			</div>
		</div> <?php }?>
	<div class="interIconLink">
		<div class="icon">
			<?php echo $this->Html->link($this->Html->image('/img/icons/patient_hub/dietary_assessment.png',array('class'=>'resizeIcon')), array('controller'=>'nursings','action' => 'dietaryAssessment',$patient['Patient']['id']), array('escape' => false,'title'=>'Dietary Assessment'));?>
		</div>
		<div class="iconLink">Dietary Assessment</div>
	</div>

	<div class="interIconLink">
		<div class="icon">
			<?php echo $this->Html->link($this->Html->image('/img/icons/bill-invoicing.jpg',array('class'=>'resizeIcon')), array('controller'=>'nursings','action' => 'addWardCharges',$patient['Patient']['id']), array('escape' => false,'title'=>'Generate Invoice'));	?>
		</div>
		<div class="iconLink">
			<?php echo __('Generate Invoice');?>
		</div>
	</div>
	<div class="interIconLink">
		<div class="icon">
			<?php echo $this->Html->link($this->Html->image('/img/icons/physiotherapy-assessment-form.jpg',array('class'=>'resizeIcon')), array('controller'=>'nursings','action' => 'physiotherapy_assessment_view',$patient['Patient']['id']), array('escape' => false,'title'=>'Physiotherapy Assessment Form'));	?>
		</div>
		<div class="iconLink">
			<?php echo __('Physiotherapy Assessment');?>
		</div>
	</div>
	<div class="interIconLink">
		<div class="icon">
			<?php echo $this->Html->link($this->Html->image('/img/icons/patient_hub/blood-sugar-monitor-chart.png',array('class'=>'resizeIcon')), array('controller'=>'nursings','action' => 'blood_sugar_monitoring',$patient['Patient']['id']), array('escape' => false,'title'=>'Blood Sugar Monitoring Chart'));	?>
		</div>
		<div class="iconLink">
			<?php echo __('Bld. Sugar Monitoring');?>
		</div>
	</div>
	<div class="interIconLink">
		<div class="icon">
			<?php echo $this->Html->link($this->Html->image('/img/icons/bld_transfusion_icon.png',array('class'=>'resizeIcon')), array('controller'=>'nursings','action' => 'patient_blood_transfusion_list',$patient['Patient']['id']), array('escape' => false,'title'=>'Blood Transfusion Progress Form'));	?>
		</div>
		<div class="iconLink">
			<?php echo __('Bld. Transfusion');?>
		</div>
	</div>
	<div class="interIconLink">
		<div class="icon">
			<?php echo $this->Html->link($this->Html->image('/img/icons/patient_hub/ivf.png',array('class'=>'resizeIcon')), array('controller'=>'nursings','action' => 'patient_ivf_list',$patient['Patient']['id']), array('escape' => false,'title'=>'I.V.F.'));	?>
		</div>
		<div class="iconLink">
			<?php echo __('I.V.F.');?>
		</div>
	</div>
	<div class="interIconLink">
		<div class="icon">
			<?php echo $this->Html->link($this->Html->image('/img/icons/patient-outward-inner.jpg',array('class'=>'resizeIcon')),array('action' => 'medication_record',$patient['Patient']['id']), array('escape' => false,'title' => 'Rx Record')); ?>
		</div>
		<div class="iconLink">
			<?php echo __('Rx Record'); ?>
		</div>
	</div>

	<?php if($patient['Patient']['sex']=='female'){ ?>
	<div class="interIconLink">
		<div class="icon">
			<?php echo $this->Html->link($this->Html->image('/img/icons/child-birth.jpg',array('class'=>'resizeIcon')), array('controller'=>'patients','action' => 'child_birth_list',$patient['Patient']['id'],'?'=>array('return'=>'nursings')),
						 	array('escape' => false,'title'=>'Child Birth'));?>
		</div>
		<div class="iconLink">
			<?php echo __('Child Birth'); ?>
		</div>
	</div>
	<div class="interIconLink">
		<div class="icon">
			<?php echo $this->Html->link($this->Html->image('/img/icons/patient-documents.jpg',array('class'=>'resizeIcon')), array('controller'=>'patient_documents','action' => 'index',$patient['Patient']['id']),array('escape' => false,'title'=>'Patient\'s Documents'));?>
		</div>
		<div class="iconLink">
			<?php echo __('Patient\'s Documents'); ?>
		</div>
	</div>
	<?php } ?>
	<?php if($role != 'Nurse'){ ?>
	<!--  <div class="interIconLink">
		<div class="icon">
			<?php //echo $this->Html->link($this->Html->image('/img/icons/police-form.jpg',array('class'=>'resizeIcon')), array('controller'=>'patients','action' => 'police_forms',$patient['Patient']['id'],'?'=>array('return'=>'patientInfo')),
					//array('escape' => false,'title'=>'Police Form'));?>
		</div>
		<div class="iconLink">
			<?php //echo __('Police Form'); ?>
		</div>
	</div>-->
	<?php } ?>
	<div class="interIconLink">
		<div class="icon">
			<?php echo $this->Html->link($this->Html->image('/img/icons/bld_transfusion_icon.png',array('class'=>'resizeIcon')), array('controller'=>'nursings','action' => 'ventilator_order',$patient['Patient']['id']), array('escape' => false,'title'=>'Ventilator/Sedation Order Set'));	?>
		</div>
		<div class="iconLink">
			<?php echo __('Vent. Order');?>
		</div>
	</div>
	<div class="interIconLink">
		<div class="icon">
			<?php echo $this->Html->link($this->Html->image('/img/icons/interactive_view.png',array('class'=>'resizeIcon')), 
					array('controller'=>'nursings','action' => 'interactive_view',$patient['Patient']['id']), 
					array('escape' => false,'title'=>'Interactive View'));	?>
		</div>
		<div class="iconLink">
			<?php echo __('Interactive View');?>
		</div>
	</div>
	<div class="interIconLink">
		<div class="icon">
			<?php echo $this->Html->link($this->Html->image('/img/icons/emar_dashboard.png',array('class'=>'resizeIcon')), 
					array('controller'=>'PatientsTrackReports','action' => 'emarDashboard',$patient['Patient']['id']), 
					array('escape' => false,'title'=>'EMAR Dashboard'));	?>
		</div>
		<div class="iconLink">
			<?php echo __('EMAR Dashboard');?>
		</div>
	</div>
	<div class="interIconLink">
		<div class="icon">
			<?php echo $this->Html->link($this->Html->image('/img/icons/patient_track_report.png',array('class'=>'resizeIcon')), 
					array('controller'=>'PatientsTrackReports','action' => 'index',$patient['Patient']['id']), 
					array('escape' => false,'title'=>'Critical Care Review'));	?>
		</div>
		<div class="iconLink">
			<?php echo __('Critical Care Review');?>
		</div>
	</div>

