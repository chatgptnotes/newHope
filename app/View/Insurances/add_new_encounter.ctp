<?php 
echo $this->Html->script(array('jquery-1.5.1.min','jquery.validationEngine','/js/languages/jquery.validationEngine-en',
		'jquery-ui-1.10.2.js','jquery.fancybox-1.3.4'));
	 echo $this->Html->css(array('internal_style.css','home-slider.css','ibox.css','jquery.fancybox-1.3.4.css','jquery.autocomplete.css'));
?>


<?php 
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td colspan="2" align="left">
   <?php 
     foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
     
   ?>
  </td>
 </tr>
</table>
<?php } ?>
 <style>
.ui-widget-content {
    background: none;
    border: 0px solid #AAAAAA;
    
}
a {
    color: #FFFFFF !important;
    font-size: 13px;
    text-decoration: none;
}
</style>
  <script>
  $(function() {
	    $( "#tabs" ).tabs();
	  });
    </script>
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#encounterFrm").validationEngine();
	});
	
</script>

<div class="inner_title">
				<h3>
				<?php echo __('Add New Encounter'); ?>
			</h3>
			<span align="right"> <?php echo $this->Html->link(__('Back', true),array('controller' => 'patients', 'action' => 'insuranceindex',$patient_id), array('escape' => false,'class'=>'blueBtn'));?>
	</span>
</div>
<?php echo $this->element('patient_information');?>
<?php echo $this->Form->create('Encounter',array('type' => 'file','id'=>'encounterFrm','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false,
																								        'legend'=>false,
																								        'fieldset'=>false
																								    )
			));
echo $this->Form->hidden('Encounter.patient_id',array('value'=>$patient_id));
echo $this->Form->hidden('Encounter.id',array('value'=>$getEncounterDetails['0']['Encounter']['id']));
echo $this->Form->hidden('Encounter.new_insurance_id',array('value'=>$newInsuranceId));
		?>
	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="formFull" style="padding-top: 10px;" align="center">
	
	<tr>
	<td class="tdLabel" id="boxSpace" width="25%">
	<?php echo __('Claim Type'); ?><font color="red">*</font>
	</td>
	<td width="25%">
        <?php 
        echo $this->Form->input('Encounter.claim_type', array('style'=>'width:348px;','class' => 'validate[required,custom[mandatory-select]] ','empty'=>__('Please Select'), 'id' => 'claim_type','options'=>array('Professional(CMS-1500)'=>'Professional(CMS-1500)'),'selected'=>$getEncounterDetails['0']['Encounter']['claim_type'], 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td >
	<td class="tdLabel" id="boxSpace" width="25%">
	<?php echo __('Batch No'); ?></td>
	<td width="25%"><?php 
        echo $this->Form->input('Encounter.batch_no', array('class' => 'textBoxExpnd','type'=>'text', 'id' => 'batch_no','label'=> false, 'div' => false, 'error' => false,'placeholder'=>''));
        ?>
    </td>	
	</tr>
	
		
	<tr class="row_title">			
	<td class="tdLabel" id="boxSpace" width="19%" align="left" colspan="4">
	<strong><?php echo __('Patient'); ?></strong>
	</td>	
	</tr>	
	 
	 <tr>
	 <td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Visit ID'); ?>
	</td>
	<td width="25%">
        <?php
        echo $this->Form->input('Encounter.visit_id', array('class' => 'textBoxExpnd','type'=>'text', 'id' => 'visit_id', 'label'=> false, 'div' => false, 'error' => false,'value'=>$getPatientInfo['Patient']['admission_id'],'readonly'=>'readonly'));
        ?>	
	</td>
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('File With'); ?><font color="red">*</font> 
	</td>
	<td width="25%"><?php 
        echo $this->Form->input('Encounter.primary_insurance', array('class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','empty'=>__('Please Select'), 'id' => 'primary_insurance','options'=>array('P'=>'Primary','S'=>'Secondary','T'=>'Tertiary'), 'label'=> false, 'div' => false, 'error' => false,'placeholder'=>'','readonly'=>'readonly'));
        ?>       
	</td>	
	</tr>
	
	<tr>	
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Name'); ?>
	</td>
	<td width="25%">
        <?php 
        echo $this->Form->input('Encounter.name', array('class' => 'textBoxExpnd','type'=>'text', 'id' => 'name', 'label'=> false, 'div' => false, 'error' => false,'value'=>$getPatientInfo['Patient']['lookup_name'],'readonly'=>'readonly'));
        ?>	
	</td>
	<td class="tdLabel" id="boxSpace" width="25%">
	<?php echo __('Pre Authorization Approval No.'); ?></td>
	<td width="25%"><?php 
        echo $this->Form->input('Encounter.approval_no', array('class' => 'textBoxExpnd','type'=>'text', 'id' => 'approval_no','label'=> false, 'div' => false, 'error' => false,'placeholder'=>''));
        ?>
    </td>
	</tr>
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Case'); ?>
	</td>
	<td width="25%">
        <?php 
        echo $this->Form->input('Encounter.case', array('class' => 'textBoxExpnd','type'=>'text', 'id' => 'case', 'label'=> false, 'div' => false, 'error' => false,'placeholder'=>''));
        ?>	
	</td>
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Assigned Coder'); ?>
	</td>
	<td width="25%">
        <?php 
        echo $this->Form->input('Encounter.assigned_coder', array('style'=>'width:348px;','class' => 'textBoxExpnd', 'id' => 'assigned_coder','empty'=>__('Please Select'),'options'=>$userMedical, 'label'=> false, 'div' => false, 'error' => false,'placeholder'=>''));
        ?>	
	</td>
	</tr>
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Prescreening For Bundling'); ?>
	</td>
	<td width="25%">
        <?php echo $this->Form->input('Encounter.budling_clck', array('type'=>'checkbox','id' => 'budling_clck','label'=>false,'title'=>'')); ?>
	</td>
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Prescreening For Medical Necessity Requirement'); ?>
	</td>
	<td width="25%">
       <?php echo $this->Form->input('Encounter.necessity_clck', array('type'=>'checkbox','id' => 'necessity_clck','label'=>false,'title'=>'')); ?>
	</td>
	</tr>		
	<tr class="row_title">			
	<td class="tdLabel" id="boxSpace" width="19%" align="left" colspan="4">
	<strong><?php echo __('Payment'); ?></strong>
	</td>	
	</tr>	
	
	<tr>	
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Copay Due'); ?>
	</td>
	<td width="25%">
        <?php
        echo $this->Form->input('Encounter.copay_due', array('class' => 'textBoxExpnd','type'=>'text', 'id' => 'copay_due', 'label'=> false, 'div' => false, 'error' => false,'placeholder'=>''));
        ?>
	</td>
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Payment Posted Date'); ?>
	</td>
	<td width="25%"><?php 
        echo $this->Form->input('Encounter.payment_post_date', array('type'=>'text', 'id' => 'payment_post_date', 'label'=> false, 'div' => false, 'error' => false,'placeholder'=>'','readonly'=>'readonly','class'=>'textBoxExpnd common_dateCls'));
        ?>
	</td>	
	</tr>
	
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Payment Amount'); ?>
	</td>
	<td width="25%">
        <?php 
        echo $this->Form->input('Encounter.payment_amount', array('class' => '','type'=>'text', 'id' => 'payment_amount', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:160px;'));
        ?>
        <?php 
        echo $this->Form->input('Encounter.payment_amount_type', array('class' => '','empty'=>__('Please Select'),'options'=>array('Cash'=>'Cash','Check'=>'Check','Debit'=>'Debit','Creadit Card'=>'Creadit Card','Amex'=>'Amex','Visa'=>'Visa','Master Card'=>'Master Card','Discover'=>'Discover','Other'=>'Other','Square'=>'Square'), 'id' => 'payment_amount_type', 'label'=> false, 'div' => false, 'error' => false,'placeholder'=>'','style'=>'width:168px;'));
        ?>
	</td>
	<td colspan="2">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td class="tdLabel" id="boxSpace" width="45%">
	<?php echo __('Billing Profile'); ?></td>
	<td width="2%"><?php 
        echo $this->Form->input('Encounter.billing_profile', array('class' => '','empty'=>__('Please Select'),'options'=>$billingProfileData, 'id' => 'billing_profile','label'=> false, 'div' => false, 'error' => false,'placeholder'=>'','style'=>'width:286px;'));
        ?></td>
     <td width="10%" style="padding-right:52px;"><?php 
  //echo $this->Html->link($this->Html->image('icons/cross.png',array('title'=>'Delete','alt'=>'Delete')), array('action' => 'addNewEncounter', $tariff['TariffStandard']['id']), array('escape' => false,'style'=>'float:right;'),__('Are you sure?', true));
 //echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('title'=>'Edit','alt'=>'Edit')), array('action' => 'addNewEncounter', $tariff['TariffStandard']['id']), array('escape' => false,'style'=>'float:right;')); 
  echo $this->Html->link($this->Html->image('icons/add-icon.gif',array('title'=>'Add','alt'=>'Add')), 'javascript:void(0)', array('escape' => false,'style'=>'float:right;','onclick'=>"getBillingProfile('$patient_id')"));
 
  ?>
	</td>
	</tr>
	</table>
	</td>
	<!-- <td class="tdLabel" id="boxSpace" width="25%">
	<?php //echo __('Payment Profile'); ?></td>
	<td width="25%"><?php 
       // echo $this->Form->input('Encounter.payment_profile', array('class' => 'textBoxExpnd','empty'=>__('Select'),'options'=>'', 'id' => 'payment_profile','label'=> false, 'div' => false, 'error' => false,'placeholder'=>''));
        ?>
    </td>	
	</tr> -->
	
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Payment Notes'); ?>
	</td>
	<td width="25%">
        <?php 
        echo $this->Form->input('Encounter.payment_note', array('class' => 'textBoxExpnd','type'=>'textarea', 'id' => 'payment_note', 'label'=> false, 'div' => false, 'error' => false,'rows'=>'2'));
        ?>
	</td>

	</tr>
	
	<!-- <tr>
	<td class="tdLabel" id="boxSpace" width="25%"></td>
	<td width="25%"></td>
	<td class="tdLabel" id="boxSpace" width="25%">
	<?php //echo __('Billing Pick List'); ?></td>
	<td width="25%"><?php 
     // echo "&nbsp;&nbsp;".$this->Form->submit('Choose Codes From Pick List',array('class'=>'blueBtn','div'=>false,'id'=>'submit','title'=>'Choose Codes From Pick List'));
        ?>
    </td>
	</tr>	 -->
	
	<!-- Tab Code -->
	<tr>
	<td colspan="4">
	<table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td>
	<div id="tabs" class="container" style="padding-top:10px;">
  	<ul class="tabs">
    <li class="tab-link bg_color" data-tab="tab-1" ><a href="#tabs-1">Dates</a></li>
    <li class="tab-link bg_color" data-tab="tab-2" ><a href="#tabs-2">Patient</a></li>
    <li class="tab-link bg_color" data-tab="tab-3"><a href="#tabs-3">Property And Casualty</a></li>
    <li class="tab-link bg_color" data-tab="tab-4" ><a href="#tabs-4">Primary</a></li>
    <li class="tab-link bg_color" data-tab="tab-5" ><a href="#tabs-5">Secondary</a></li>
      <li class="tab-link bg_color" data-tab="tab-10" ><a href="#tabs-11">Tertiary</a></li>
    <li class="tab-link bg_color" data-tab="tab-6"><a href="#tabs-6">Claim Notes</a></li>   
    <li class="tab-link bg_color" data-tab="tab-7"><a href="#tabs-7">Providers</a></li>  
    <li class="tab-link bg_color" data-tab="tab-8"><a href="#tabs-8">Ambulance</a></li>   
    <li class="tab-link bg_color" data-tab="tab-9"><a href="#tabs-9">Contract</a></li> 
    <li class="tab-link bg_color" data-tab="tab-10"><a href="#tabs-10">Vision</a></li>  
  	</ul>
 	<!-- Dates -->
  	<div id="tabs-1" style="padding-top:5px;" class="tab-content current">
  	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="formFull">
  	<!-- <tr>	
  	<td class="tdLabel " id="boxSpace" width="25%"><?php echo __('Service Date'); ?><font color="red">*</font>
  	</td>
  	<td width="25%">
        <?php 
          	$getadmitDate=$getPatientInfo['Patient']['form_received_on'] = $this->DateFormat->formatDate2LocalForReport($getPatientInfo['Patient']['form_received_on'],Configure::read('date_format'));
          	echo $this->Form->input('Encounter.service_date', array('type'=>'text', 'id' => 'service_date', 'label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly','class'=>'textBoxExpnd validate[required,custom[mandatory-date]] common_dateCls ','value'=>$getadmitDate));
        ?>  
	</td>
	<td class="tdLabel " id="boxSpace" width="25%"><?php echo __('Post Date'); ?>
	</td>
	<td width="25%"><?php 
        echo $this->Form->input('Encounter.post_date', array('type'=>'text', 'id' => 'post_date', 'label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly','class'=>'textBoxExpnd common_dateCls'));
        ?>        
	</td>
	</tr>
	
	<tr>	
	<td class="tdLabel " id="boxSpace" width="25%"><?php echo __('To Date(Optional)'); ?>
	</td>
	<td width="25%"><?php $getdischargeDate=$getPatientInfo['Patient']['discharge_date'] = $this->DateFormat->formatDate2Local($getPatientInfo['Patient']['discharge_date'],Configure::read('date_format'));
        echo $this->Form->input('Encounter.to_date', array('type'=>'text', 'id' => 'to_date', 'label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly','class'=>'textBoxExpnd common_dateCls','value'=>$getdischargeDate));
        ?>		
	</td>
	<td class="tdLabel" id="boxSpace" width="25%">
	</td>
	<td width="25%">
    </td>
    </tr> -->
    <tr>
    <td width="33%" valign="top" style="padding-left:7px;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="formFull" >
  	<tr class="row_title">
	<td class="tdLabel" id="boxSpace" width="19%" align="left" colspan="2" >
	<strong><?php echo __('Illness,Injury or Pregnancy'); ?></strong>
	</td>
	</tr>	
	<tr>
	<td class="tdLabel " id="boxSpace" width="55%"><?php echo __('Accident'); ?>
  	</td>
  	<td width="25%">
        <?php	echo $this->Form->input('Encounter.accident_date', array('type'=>'text', 'id' => 'accident_date', 'label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly','class'=>'textBoxExpnd common_dateCls '));
        ?>  
	</td>
	</tr>
	<tr>
	<td class="tdLabel " id="boxSpace" width="55%"><?php echo __('Onset of Currrent'); ?>
  	</td>
  	<td width="25%">
        <?php echo $this->Form->input('Encounter.onset_currrent_date', array('type'=>'text', 'id' => 'onset_currrent_date', 'label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly','class'=>'textBoxExpnd common_dateCls '));
        ?>  
	</td>
	</tr>
	<tr>
	<?php if(strtolower($getpatientGender['Person']['sex'])=='female'){?>
	<td class="tdLabel " id="boxSpace" width="55%"><?php echo __('Last Menstrual Period'); ?>
  	</td>
  	<td width="25%"><?php echo $this->Form->input('Encounter.last_menstrual_period_date', array('type'=>'text', 'id' => 'last_menstrual_period_date', 'label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly','class'=>'textBoxExpnd common_dateCls '));
        ?>  
	</td>
	<?php }?>
	</tr>
	</table>
    </td>
    <td>
    </td>
   	<td width="33%" valign="top">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="formFull">
  	<tr class="row_title">
	<td class="tdLabel" id="boxSpace" width="19%" align="left" colspan="2" >
	<strong><?php echo __('Patient,Treatment Dates'); ?></strong>
	</td>
	</tr>
	<tr>
	<td class="tdLabel " id="boxSpace" width="55%"><?php echo __('Last Seen Date'); ?>
  	</td>
  	<td width="25%">
        <?php $getdismrnDate=$getPatientInfo['Patient']['discharge_date'] = $this->DateFormat->formatDate2Local($getPatientInfo['Patient']['discharge_date'],Configure::read('date_format'));
          	  echo $this->Form->input('Encounter.last_seen_date', array('type'=>'text', 'id' => 'last_seen_date', 'label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly','class'=>'textBoxExpnd common_dateCls ','value'=>$getdismrnDate));
        ?>  
	</td>
	</tr>
	<tr>
	<td class="tdLabel " id="boxSpace" width="55%" style="border-bottom: 1px solid #3E474A;"><?php echo __('Referral Date'); ?>
  	</td>
  	<td width="25%" style="border-bottom: 1px solid #3E474A;">
        <?php echo $this->Form->input('Encounter.referral_date', array('type'=>'text', 'id' => 'referral_date', 'label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly','class'=>'textBoxExpnd common_dateCls '));
        ?>  
	</td>
	</tr>
	<tr>
	<td class="tdLabel " id="boxSpace" width="55%"><?php echo __('Similar Illness Date'); ?>
  	</td>
  	<td width="25%">
        <?php echo $this->Form->input('Encounter.similar_illness_date', array('type'=>'text', 'id' => 'similar_illness_date', 'label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly','class'=>'textBoxExpnd common_dateCls '));
        ?>  
	</td>
	</tr>
	<tr>
	<td class="tdLabel " id="boxSpace" width="55%"><?php echo __('Initial Treatment/Visit Date'); ?>
  	</td>
  	<td width="25%">
        <?php $getinitialDate=$getPatientInfo['Patient']['form_completed_on'] = $this->DateFormat->formatDate2Local($getPatientInfo['Patient']['form_completed_on'],Configure::read('date_format'));
         echo $this->Form->input('Encounter.initial_treatment_date', array('type'=>'text', 'id' => 'initial_treatment_date', 'label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly','class'=>'textBoxExpnd common_dateCls ','value'=>$getinitialDate));
        ?>  
	</td>
	</tr>
	<tr>
	<td class="tdLabel " id="boxSpace" width="55%" style="border-bottom: 1px solid #3E474A;"><?php echo __('Acute Manifestation'); ?>
  	</td>
  	<td width="25%" style="border-bottom: 1px solid #3E474A;">
        <?php echo $this->Form->input('Encounter.acute_manifestation_date', array('type'=>'text', 'id' => 'acute_manifestation_date', 'label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly','class'=>'textBoxExpnd common_dateCls '));
        ?>  
	</td>
	</tr>
	<tr>
	<td class="tdLabel " id="boxSpace" width="55%"><?php echo __('Hearing/Vision Rx'); ?>
  	</td>
  	<td width="25%">
        <?php echo $this->Form->input('Encounter.hearing_date', array('type'=>'text', 'id' => 'hearing_date', 'label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly','class'=>'textBoxExpnd common_dateCls '));
        ?>  
	</td>
	</tr>
	<tr>
	<td class="tdLabel " id="boxSpace" width="55%"><?php echo __('Last X-Ray'); ?>
  	</td>
  	<td width="25%">
        <?php echo $this->Form->input('Encounter.last_xray_date', array('type'=>'text', 'id' => 'last_xray_date', 'label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly','class'=>'textBoxExpnd common_dateCls '));
        ?>  
	</td>
	</tr>
	<tr>
	<td class="tdLabel " id="boxSpace" width="55%"><?php echo __('Order Date'); ?>
  	</td>
  	<td width="25%">
        <?php echo $this->Form->input('Encounter.order_date', array('type'=>'text', 'id' => 'order_date', 'label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly','class'=>'textBoxExpnd common_dateCls '));
        ?>  
	</td>
	</tr>
	</table>
    </td>
     <td>
    </td>
    <td width="33%" valign="top" style="padding-right:7px;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="formFull" >
  	<tr class="row_title">
	<td class="tdLabel" id="boxSpace" width="19%" align="left" colspan="4" >
	<strong><?php echo __('Hospital,Disability Dates'); ?></strong>
	</td>
	</tr>
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%"><?php echo __('Not Work From'); ?>
  	</td>  
  	<td width="32%">
        <?php echo $this->Form->input('Encounter.not_work_from_date', array('type'=>'text', 'id' => 'not_work_from_date', 'label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly','class'=>'textBoxExpnd common_dateCls '));
        ?>  
	</td>
		<td width="5%"><?php echo __('To'); ?>
  	</td>
	<td width="30%">
        <?php echo $this->Form->input('Encounter.not_work_to_date', array('type'=>'text', 'id' => 'not_work_to_date', 'label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly','class'=>'textBoxExpnd common_dateCls '));
        ?>  
	</td>
	</tr>
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%"><?php echo __('Disability From'); ?>
  	</td>  
  	<td width="32%">
        <?php echo $this->Form->input('Encounter.disability_from_date', array('type'=>'text', 'id' => 'disability_from_date', 'label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly','class'=>'textBoxExpnd common_dateCls '));
        ?>  
	</td>
		<td width="5%"><?php echo __('To'); ?>
  	</td>
	<td width="30%">
        <?php echo $this->Form->input('Encounter.disability_to_date', array('type'=>'text', 'id' => 'disability_to_date', 'label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly','class'=>'textBoxExpnd common_dateCls '));
        ?>  
	</td>
	</tr>
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%"><?php echo __('Hospital From'); ?>
  	</td>  
  	<td width="32%">
        <?php 
        //$getadmitDate=$getPatientInfo['Patient']['form_received_on'] = $this->DateFormat->formatDate2LocalForReport($getPatientInfo['Patient']['form_received_on'],Configure::read('date_format'));
       echo $this->Form->input('Encounter.service_date', array('type'=>'text', 'id' => 'service_date', 'label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly','class'=>'textBoxExpnd common_dateCls ','value'=>$getPatientInfo['Patient']['form_received_on']));
        ?>  
	</td>
		<td width="5%"><?php echo __('To'); ?>
  	</td>
	<td width="30%">
       <?php $getdischargeDate=$getPatientInfo['Patient']['discharge_date'] = $this->DateFormat->formatDate2Local($getPatientInfo['Patient']['discharge_date'],Configure::read('date_format'));
        echo $this->Form->input('Encounter.to_date', array('type'=>'text', 'id' => 'to_date', 'label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly','class'=>'textBoxExpnd common_dateCls','value'=>$getdischargeDate));
        ?>		
	</td>
	</tr>
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%"><?php echo __('Care From'); ?>
  	</td>  
  	<td width="32%">
        <?php echo $this->Form->input('Encounter.care_from_date', array('type'=>'text', 'id' => 'care_from_date', 'label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly','class'=>'textBoxExpnd common_dateCls '));
        ?>  
	</td>
		<td width="5%"><?php echo __('To'); ?>
  	</td>
	<td width="30%">
        <?php echo $this->Form->input('Encounter.care_to_date', array('type'=>'text', 'id' => 'care_to_date', 'label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly','class'=>'textBoxExpnd common_dateCls '));
        ?>  
	</td>
	</tr>
	</table>
    </td>
    </tr>    
    </table>	
  	</div>
  	
  	<!-- Patient -->
  	<div id="tabs-2" class="tab-content" style="padding-top:5px;">
  	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="formFull">
  	<tr>	
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Date of Death'); ?>
	</td>
	<td width="25%">
        <?php 
          	$getdeathDate=$getExpireInfo['DeathCertificate']['expired_on'] = $this->DateFormat->formatDate2Local($getExpireInfo['DeathCertificate']['expired_on'],Configure::read('date_format'));
          	echo $this->Form->input('Encounter.date_of_death', array('type'=>'text', 'id' => 'date_of_death', 'label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly','class'=>'textBoxExpnd common_dateCls','value'=>$getdeathDate));
        ?>  
	</td>
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Weight'); ?>
	</td>
	<td width="25%"> <?php echo $this->Form->input('Encounter.weight_result', array('type'=>'text', 'id' => 'weight_result', 'label'=> false, 'div' => false, 'error' => false,'class'=>'textBoxExpnd','value'=>$getWieghtInfo['BmiResult']['weight_result']));
        ?>        
	</td>
	</tr>
	
	<tr>	
	<td class="tdLabel " id="boxSpace" width="25%"> <?php echo $this->Form->input('Encounter.pregnant_clck', array('type'=>'checkbox','id' => 'pregnant_clck','label'=>false,'title'=>'','value'=>'Y','hiddenField'=>false)); ?>
	<?php echo __('Pregnant'); ?>
	</td>
	<td width="25%">      
	</td>
	<td class="tdLabel " id="boxSpace" width="25%">	
	</td>
	<td width="25%"> 
	</td>
	</tr>	  
	</table>
  </div>
  
  <!-- Property And Casualty -->
  <div id="tabs-3" class="tab-content" style="padding-top:5px;">
   <table border="0" cellpadding="0" cellspacing="0" width="100%" class="formFull">
  	<tr>	
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Claim Number'); ?>
	</td>
	<td width="25%">
        <?php 
        echo $this->Form->input('Encounter.claim_number', array('type'=>'text', 'id' => 'claim_number', 'label'=> false, 'div' => false, 'error' => false,'class'=>'textBoxExpnd','value'=>$this->request->data['Encounter']['id'],'readonly'=>'readonly'));
        ?>        
	</td>
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Contact Name'); ?>
	</td>
	<td width="25%"> <?php 
        echo $this->Form->input('Encounter.contact_name', array('type'=>'text', 'id' => 'contact_name', 'label'=> false, 'div' => false, 'error' => false,'class'=>'textBoxExpnd'));
        ?>        
	</td>
	</tr>
	
	<tr>	
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Contact Phone'); ?>
	</td>
	<td width="25%">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
  	<tr>	
	<td>
        <?php echo $this->Form->input('Encounter.contact_phone', array('type'=>'text', 'id' => 'contact_phone', 'label'=> false, 'div' => false, 'error' => false,'class'=>'textBoxExpnd','style'=>'width:153px;'));
        ?> 	
        </td>
        <td> <?php echo __('Ex.'); ?>
        </td>
        <td>
         <?php echo $this->Form->input('Encounter.contact_ex', array('type'=>'text', 'id' => 'contact_ex', 'label'=> false, 'div' => false, 'error' => false,'class'=>'textBoxExpnd','style'=>'width:100px;'));
        ?>  
        </td>
        </tr>
        </table>      
	</td>
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Patient Id Type'); ?>
	</td>
	<td width="25%">    
	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="formFull">
  	<tr>	
	<td  width="25%">
	<?php  $options=array('DNS'=>'Do Not Send','MIN'=>'Member Id No.','SSN'=>'Social Security No.');
		   $attributes=array('legend'=>false,'empty'=>'Please Select', 'label'=> false, 'div' => false, 'error' => false,'value'=>$selected);
           echo $this->Form->radio('Encounter.patient_id_type',$options,$attributes);
	?>
	</td>
	</tr>
	</table>
	</td>
	</tr>	
	
	<tr>	
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('First Contact Date'); ?>
	</td>
	<td width="25%">
        <?php 
            	echo $this->Form->input('Encounter.first_contact_date', array('type'=>'text', 'id' => 'first_contact_date', 'label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly','class'=>'textBoxExpnd common_dateCls'));
        ?>  
	</td>
	<td class="tdLabel " id="boxSpace" width="25%">	
	</td>
	<td width="25%"> 
	</td>
	</tr>  
	<tr>
	<td colspan="2" style="padding-left: 5px">
	 <table border="0" cellpadding="0" cellspacing="0" width="100%" class="formFull">
  	<tr class="row_title">
	<td class="tdLabel" id="boxSpace" width="19%" align="left" colspan="4" >
	<strong><?php echo __('Service Facility'); ?></strong>
	</td>
	</tr>	
	<tr>
	<td class="tdLabel " id="boxSpace" width="50%"><?php echo __('Contact'); ?>
  	</td>
  	<td width="50%">
        <?php	echo $this->Form->input('Encounter.service_contact', array('type'=>'text', 'id' => 'service_contact', 'label'=> false, 'div' => false, 'error' => false,'class' => 'textBoxExpnd'));
        ?>  
	</td>
	</tr>
	<tr>
	<td class="tdLabel " id="boxSpace" width="50%">
	<?php echo __('Phone'); ?>
  	</td>
  	<td width="50%">
  	<table border="0" cellpadding="0" cellspacing="0" width="100%">
  	<tr>	
	<td>
         <?php echo $this->Form->input('Encounter.service_phone', array('type'=>'text', 'id' => 'service_phone', 'label'=> false, 'div' => false, 'error' => false,'class' => 'textBoxExpnd','style'=>'width:153px'));
        ?> 
        </td>
        <td> <?php echo __('Ex.'); ?>
        </td>
        <td>
        <?php echo $this->Form->input('Encounter.service_extension', array('type'=>'text', 'id' => 'service_extension', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:100px'));
        ?>
        </td>
        </tr>
        </table>   	
    </td>
	</tr>
	</table>
	</td>
	</tr>
	</table>
  </div>
  
  <!-- Primary -->
   <div id="tabs-4" class="tab-content" style="padding-top:5px;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="formFull"> 
  	<tr>	
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Policy'); ?>
	</td>
	<td width="25%">
        <?php 
        echo $getNewInsurance['0']['NewInsurance']['tariff_standard_name'].$this->Form->hidden('SubClaim.primary_policy', array('style'=>'width:348px;','value' =>$getNewInsurance['0']['NewInsurance']['tariff_standard_id'],'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Route'); ?>
	</td>
	<td width="25%">
	 <?php $options=array('Paper'=>'Paper','Electronic'=>'Electronic');
		   $attributes=array('legend'=>false,'empty'=>'Please Select', 'label'=> false,'selected'=>$subClaimData['SubClaim']['primary_route'],'div' => false, 'error' => false,'default' => 'Electronic');
           echo $this->Form->radio('Encounter.primary_route',$options,$attributes);
	?>
	</td>
	</tr>
	
	<tr>	
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php //if($getEncounterDetails['0']['SubClaim']['0']['information_signature_clk']=='Y')
		if($subClaimData['SubClaim']['primary_route']=='Y')
		$checkedPriRoute='checked';
	 echo $this->Form->input('Encounter.information_signature_clk', array('type'=>'checkbox','id' => 'information_signature_clk','checked'=>$checkedPriRoute,'label'=>false,'title'=>'','value'=>'Y','hiddenField'=>false)); ?>
	<?php echo __('Release of Information Signature'); ?>
	</td>

	<td width="25%"><?php //if($getEncounterDetails['0']['SubClaim']['0']['executed_signature_clk']=='Y')
	 if($subClaimData['SubClaim']['executed_signature_clk']=='Y')
		$checkedExeSignClk='checked';
	echo $this->Form->input('Encounter.executed_signature_clk', array('type'=>'checkbox','id' => 'executed_signature_clk','checked'=>$checkedExeSignClk,'label'=>false,'title'=>'','value'=>'Y','hiddenField'=>false)); ?>
	<?php echo __('Signature Executed For Patient'); ?>
     
	</td>
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php  echo __('Benifits Assignment'); ?>
	</td>
	<td width="25%">
        <?php 
        echo $this->Form->input('Encounter.primary_benifits_assignment', array('style'=>'width:348px;','class' => '','empty'=>'Please Select', 'id' => 'primary_benifits_assignment','value'=>$subClaimData['SubClaim']['primary_benifits_assignment'],'options'=>array('Y'=>'Yes','N'=>'No'), 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
    </tr>
    
    </table>	
  </div>
   <!-- Secondary -->
   <div id="tabs-11" class="tab-content" style="padding-top:5px;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="formFull">
    	<tr>	
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Policy'); ?>
	</td>
	<td width="25%">
        <?php 
        echo $getNewInsurance['2']['NewInsurance']['tariff_standard_name'].$this->Form->hidden('Encounter.secondary_policy', array('style'=>'width:348px;', 'id' => 'secondary_policy','value'=>$getNewInsurance['2']['NewInsurance']['tariff_standard_id'], 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Route'); ?>
	</td>
	<td width="25%">
	 <?php $options=array('Paper'=>'Paper','Electronic'=>'Electronic');
		   $attributes=array('legend'=>false,'empty'=>'Please Select', 'label'=> false, 'div' => false, 'error' => false,'default' => 'Electronic');
           echo $this->Form->radio('Encounter.secondary_route',$options,$attributes);
	?>
	</td>
	</tr>
   <tr>	
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php if($getEncounterDetails['0']['SubClaim']['1']['information_signature_clk']=='Y')
		$checked='checked';
	echo $this->Form->input('Encounter.sec_information_signature_clk', array('type'=>'checkbox','checked'=>$checked,'id' => 'sec_information_signature_clk','label'=>false,'title'=>'','value'=>'Y','hiddenField'=>false)); ?>
	<?php echo __('Release of Information Signature'); ?>
	</td>
	<td width="25%"><?php if($getEncounterDetails['0']['SubClaim']['1']['executed_signature_clk']=='Y')
		$checked='checked';
	echo $this->Form->input('Encounter.sec_executed_signature_clk', array('type'=>'checkbox','id' => 'sec_executed_signature_clk','checked'=>$checked,'label'=>false,'title'=>'','value'=>'Y','hiddenField'=>false)); ?>
	<?php echo __('Signature Executed For Patient'); ?>
     
	</td>
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Benifits Assignment'); ?>
	</td>
	<td width="25%">
        <?php
        echo $this->Form->input('Encounter.sec_benifits_assignment', array('style'=>'width:348px;','class' => '','empty'=>'Please Select','value'=>$getInsuranceAuth['1']['NewInsurance']['sec_is_authorized'], 'id' => 'sec_benifits_assignment','options'=>array('Y'=>'Yes','N'=>'No'), 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
    </tr>
    </table>
  </div>
    <!-- Tertiary -->
  <div id="tabs-5" class="tab-content" style="padding-top:5px;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="formFull">
    	<tr>	
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Policy'); ?>
	</td>
	<td width="25%">
        <?php 
        echo $getNewInsurance['1']['NewInsurance']['tariff_standard_name'].$this->Form->hidden('Encounter.secondary_policy', array('style'=>'width:348px;', 'id' => 'secondary_policy', 'value'=>$getNewInsurance['1']['NewInsurance']['tariff_standard_id'],'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Route'); ?>
	</td>
	<td width="25%">
	 <?php $options=array('Paper'=>'Paper','Electronic'=>'Electronic');
		   $attributes=array('legend'=>false,'empty'=>'Please Select', 'label'=> false, 'div' => false, 'error' => false,'default' => 'Electronic');
           echo $this->Form->radio('Encounter.secondary_route',$options,$attributes);
	?>
	</td>
	</tr>
   <tr>	
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo $this->Form->input('Encounter.sec_information_signature_clk', array('type'=>'checkbox','id' => 'sec_information_signature_clk','label'=>false,'title'=>'','value'=>'Y','hiddenField'=>false)); ?>
	<?php echo __('Release of Information Signature'); ?>
	</td>
	<td width="25%"><?php echo $this->Form->input('Encounter.sec_executed_signature_clk', array('type'=>'checkbox','id' => 'sec_executed_signature_clk','label'=>false,'title'=>'','value'=>'Y','hiddenField'=>false)); ?>
	<?php echo __('Signature Executed For Patient'); ?>
     
	</td>
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Benifits Assignment'); ?>
	</td>
	<td width="25%">
        <?php 
        echo $this->Form->input('Encounter.tri_benifits_assignment', array('style'=>'width:348px;','class' => '','empty'=>'Please Select', 'id' => 'tri_benifits_assignment','value'=>$getInsuranceAuth['2']['NewInsurance']['tri_is_authorized'],'options'=>array('Y'=>'Yes','N'=>'No'), 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
    </tr>
    </table>
  </div>
   <!-- Claim Notes -->
   <div id="tabs-6" class="tab-content" style="padding-top:5px;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="formFull">
    	<tr>	
	<td class="tdLabel " id="boxSpace" width="25%"><?php echo __('Claim Notes'); ?>
	</td>
    <td width="25%"><?php echo $this->Form->input('Encounter.claim_notes', array('type'=>'textarea', 'id' => 'claim_notes', 'label'=> false, 'div' => false, 'error' => false,'class'=>'textBoxExpnd','rows'=>'4'));
        ?> 	
    </td>        	
	<td class="tdLabel " id="boxSpace" width="25%"><?php echo __('Note Reference Code'); ?>
	</td>
	<td width="25%"><?php echo $this->Form->input('Encounter.claim_notes_ref_code', array('style'=>'width:348px;','id' =>'file_with','empty'=>__('Please Select'),'options'=>Configure::read('claim_notes_ref_code'), 'label'=> false, 'div' => false, 'error' => false));?>
	</td>
    </tr>
    <tr>	
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('File With'); ?>
	</td>
	<td width="25%">
        <?php 
        echo $this->Form->input('Encounter.file_with', array('style'=>'width:348px;','class' => ' ', 'id' => 'file_with','options'=>array('Primary'=>'Primary','Secondary'=>'Secondary','Tertiary'=>'Tertiary'), 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Accept Assignment'); ?>
	</td>
	<td width="25%">
	  <?php 
        echo $this->Form->input('Encounter.accept_assignment', array('style'=>'width:348px;','class' => '','empty'=>__('Please Select'), 'id' => 'accept_assignment','options'=>array('Y'=>'Yes','N'=>'No'), 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
    </table>
  </div> 
  <!-- Providers -->
   <div id="tabs-7" class="tab-content" style="padding-top:5px;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="formFull">
    <tr>	
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Rendering Provider'); ?>
	</td>
	<td width="25%">
        <?php 
        echo $this->Form->input('Encounter.rendering_provider', array('style'=>'width:348px;','class' => 'textBoxExpnd','empty'=>__('Please Select'),'options'=>$doctors, 'id' => 'rendering_provider', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	<td class="tdLabel" id="boxSpace" width="25%">
	<?php echo __('Place of Service/Facility'); ?></td>
	<td width="25%"><?php 
        echo $this->Form->input('Encounter.place_of_facility', array('style'=>'width:348px;','class' => 'textBoxExpnd','empty'=>__('Please Select'),'options'=>Configure::read('place_service_code'), 'id' => 'place_of_facility','label'=> false, 'div' => false, 'error' => false,'placeholder'=>''));
        ?>   
	</td>
	</tr>
	 <tr>	
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Referring Provider'); ?>
	</td>
	<td width="25%"><?php 
        echo $this->Form->input('Encounter.referring_provider', array('class' => 'textBoxExpnd', 'type'=>'text','id' => 'referring_provider', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>	
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Supervising Provider'); ?>
	</td>
	<td width="25%">
        <?php 
        echo $this->Form->input('Encounter.supervising_provider', array('style'=>'width:348px;','class' => 'textBoxExpnd','empty'=>__('Please Select'),'options'=>$doctors, 'id' => 'supervising_provider', 'label'=> false, 'div' => false, 'error' => false,'placeholder'=>''));
        ?>
	</td>
	</tr>
	 <tr>	
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Scheduling Provider'); ?>
	</td>
	<td width="25%">
        <?php  echo $this->Form->input('Encounter.scheduling_provider', array('style'=>'width:348px;','class' => 'textBoxExpnd','empty'=>__('Please Select'),'options'=>$doctors, 'id' => 'scheduling_provider', 'label'=> false, 'div' => false, 'error' => false));
        ?>        
	</td>	
	<td class="tdLabel" id="boxSpace" width="25%">
	<?php echo __('Location/Department'); ?></td>
	<td width="25%"><?php 
        echo $this->Form->input('Encounter.location_dept', array('style'=>'width:348px;','class' => 'textBoxExpnd','empty'=>__('Please Select'),'options'=>$departments, 'id' => 'location_dept','label'=> false, 'div' => false, 'error' => false,'placeholder'=>''));
        ?>
    </td>
	</tr>	
    </table>
  </div> 
  <!-- Ambulance -->
  <div id="tabs-8" class="tab-content" style="padding-top:5px;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="formFull">
   	<tr>
	<td width="50%" style="padding-left: 5px;padding-right: 2px;" valign="top">
	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="formFull" >
  	<tr class="row_title">
	<td class="tdLabel" id="boxSpace" width="19%" align="left" colspan="2" >
	<strong><?php echo __('Pick-Up Address'); ?></strong>
	</td>
	</tr>	
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%"><?php echo __('Street'); ?>
  	</td>
  	<td width="25%">
        <?php 
        echo $this->Form->input('Encounter.pick_street', array('type'=>'text', 'id' => 'pick_street', 'label'=> false, 'div' => false, 'error' => false,'class'=>'textBoxExpnd'));
        ?>       
	</td>
	</tr>
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%"><?php echo __('Street2'); ?>
  	</td>
  	<td width="25%">
        <?php 
        echo $this->Form->input('Encounter.pick_street2', array('type'=>'text', 'id' => 'pick_street2', 'label'=> false, 'div' => false, 'error' => false,'class'=>'textBoxExpnd'));
        ?>       
	</td>
	</tr>
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%"><?php echo __('State'); ?>
  	</td>
  	<td width="25%">
        <?php 
        echo $this->Form->input('Encounter.ambulance_state', array('id' => 'ambulance_state','empty'=>__('Please Select'),'options'=>$getstateInfo, 'label'=> false, 'div' => false, 'error' => false,'class'=>'textBoxExpnd'));
        ?>       
	</td>
	</tr>
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%"><?php echo __('City'); ?>
  	</td>
  	<td width="25%">
        <?php 
        echo $this->Form->input('Encounter.pick_city', array('type'=>'text', 'id' => 'pick_city', 'label'=> false, 'div' => false, 'error' => false,'class'=>'textBoxExpnd'));
        ?>       
	</td>
	</tr>	
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%"><?php echo __('Zip Code'); ?>
  	</td>
  	<td width="25%">
        <?php 
        echo $this->Form->input('Encounter.zip_code', array('type'=>'text', 'id' => 'zip_code', 'label'=> false, 'div' => false, 'error' => false,'class'=>'textBoxExpnd'));
        ?>       
	</td>
	</tr>
	</table>
	<table><tr><td></td></tr></table>
	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="formFull" >
	<tr class="row_title">
	<td class="tdLabel" id="boxSpace" width="19%" align="left" colspan="2" >
	<strong><?php echo __('Drop-Off'); ?></strong>
	</td>
	</tr>	
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%"><?php echo __('Street'); ?>
  	</td>
  	<td width="25%">
        <?php 
        echo $this->Form->input('Encounter.drop_street', array('type'=>'text', 'id' => 'drop_street', 'label'=> false, 'div' => false, 'error' => false,'class'=>'textBoxExpnd'));
        ?>       
	</td>
	</tr>
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%"><?php echo __('Street2'); ?>
  	</td>
  	<td width="25%">
        <?php 
        echo $this->Form->input('Encounter.drop_street2', array('type'=>'text', 'id' => 'drop_street2', 'label'=> false, 'div' => false, 'error' => false,'class'=>'textBoxExpnd'));
        ?>       
	</td>
	</tr>
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%"><?php echo __('State'); ?>
  	</td>
  	<td width="25%">
        <?php 
        echo $this->Form->input('Encounter.drop_state', array('id' => 'drop_state','empty'=>__('Please Select'),'options'=>$getstateInfo, 'label'=> false, 'div' => false, 'error' => false,'class'=>'textBoxExpnd'));
        ?>       
	</td>
	</tr>
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%"><?php echo __('City'); ?>
  	</td>
  	<td width="25%">
        <?php 
        echo $this->Form->input('Encounter.drop_city', array('type'=>'text', 'id' => 'drop_city', 'label'=> false, 'div' => false, 'error' => false,'class'=>'textBoxExpnd'));
        ?>       
	</td>
	</tr>
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%"><?php echo __('Zip Code'); ?>
  	</td>
  	<td width="25%">
        <?php 
        echo $this->Form->input('Encounter.drop_zip_code', array('type'=>'text', 'id' => 'drop_zip_code', 'label'=> false, 'div' => false, 'error' => false,'class'=>'textBoxExpnd'));
        ?>       
	</td>
	</tr>
	</table>
	</td>
	<td width="50%" style="padding-right: 5px;padding-left: 2px;" valign="top">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
  	<tr>
	<td colspan="2" >
	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="formFull" >
  	<tr class="row_title">
	<td class="tdLabel" id="boxSpace" width="19%" align="left" colspan="2" >
	<strong><?php echo __('Ambulance Certification'); ?></strong>
	</td>
	</tr>	
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%"><?php echo __('Admitted to a Hospital'); ?>
  	</td>
  	<td width="25%">    
	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="formFull">
  	<tr>	
	<td  width="25%">
	<?php  $options=array('DNS'=>'Do Not Send','N'=>'No','Y'=>'Yes');
		   $attributes=array('legend'=>false,'empty'=>'Please Select', 'label'=> false, 'div' => false, 'error' => false);
           echo $this->Form->radio('Encounter.admitted_to_a_hospital',$options,$attributes);
	?>
	</td>
	</tr>	
	</table>
	</td>
	</tr>	
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%"><?php echo __('Moved by Stretcher'); ?>
  	</td>
  	<td width="25%">    
	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="formFull">
  	<tr>	
	<td  width="25%">
	<?php  $options=array('DNS'=>'Do Not Send','N'=>'No','Y'=>'Yes');
		   $attributes=array('legend'=>false,'empty'=>'Please Select', 'label'=> false, 'div' => false, 'error' => false);
           echo $this->Form->radio('Encounter.moved_by_stretcher',$options,$attributes);
	?>
	</td>
	</tr>	
	</table>
	</td>
	</tr>	
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%"><?php echo __('Unconsious or in Shock'); ?>
  	</td>
  	<td width="25%">    
	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="formFull">
  	<tr>	
	<td  width="25%">
	<?php  $options=array('DNS'=>'Do Not Send','N'=>'No','Y'=>'Yes');
		   $attributes=array('legend'=>false,'empty'=>'Please Select', 'label'=> false, 'div' => false, 'error' => false);
           echo $this->Form->radio('Encounter.unconsious_or_in_shock',$options,$attributes);
	?>
	</td>
	</tr>	
	</table>
	</td>
	</tr>	
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%"><?php echo __('Transported in an Emergency Situation'); ?>
  	</td>
  	<td width="25%">    
	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="formFull">
  	<tr>	
	<td  width="25%">
	<?php  $options=array('DNS'=>'Do Not Send','N'=>'No','Y'=>'Yes');
		   $attributes=array('legend'=>false,'empty'=>'Please Select', 'label'=> false, 'div' => false, 'error' => false);
           echo $this->Form->radio('Encounter.transported_in_an_emergency_situation',$options,$attributes);
	?>
	</td>
	</tr>	
	</table>
	</td>
	</tr>	
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%"><?php echo __('Physically Restrained'); ?>
  	</td>
  	<td width="25%">    
	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="formFull">
  	<tr>	
	<td  width="25%">
	<?php  $options=array('DNS'=>'Do Not Send','N'=>'No','Y'=>'Yes');
		   $attributes=array('legend'=>false,'empty'=>'Please Select', 'label'=> false, 'div' => false, 'error' => false);
           echo $this->Form->radio('Encounter.physically_restrained',$options,$attributes);
	?>
	</td>
	</tr>	
	</table>
	</td>
	</tr>	
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%"><?php echo __('Visible Hemorrhaging'); ?>
  	</td>
  	<td width="25%">    
	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="formFull">
  	<tr>	
	<td  width="25%">
	<?php  $options=array('DNS'=>'Do Not Send','N'=>'No','Y'=>'Yes');
		   $attributes=array('legend'=>false,'empty'=>'Please Select', 'label'=> false, 'div' => false, 'error' => false);
           echo $this->Form->radio('Encounter.visible_hemorrhaging',$options,$attributes);
	?>
	</td>
	</tr>	
	</table>
	</td>
	</tr>	
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%"><?php echo __('Medically Necessary'); ?>
  	</td>
  	<td width="25%">    
	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="formFull">
  	<tr>	
	<td  width="25%">
	<?php  $options=array('DNS'=>'Do Not Send','N'=>'No','Y'=>'Yes');
		   $attributes=array('legend'=>false,'empty'=>'Please Select', 'label'=> false, 'div' => false, 'error' => false);
           echo $this->Form->radio('Encounter.medically_necessary',$options,$attributes);
	?>
	</td>
	</tr>	
	</table>
	</td>
	</tr>	
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%"><?php echo __('Confined to a Bed or Chair'); ?>
  	</td>
  	<td width="25%">    
	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="formFull">
  	<tr>	
	<td  width="25%">
	<?php  $options=array('DNS'=>'Do Not Send','N'=>'No','Y'=>'Yes');
		   $attributes=array('legend'=>false,'empty'=>'Please Select', 'label'=> false, 'div' => false, 'error' => false);
           echo $this->Form->radio('Encounter.confined_to_a_bed',$options,$attributes);
	?>
	</td>
	</tr>	
	</table>	
	</td>
	</tr>		
	</table>
	</td>
	</tr>
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%"><?php echo __('Transport Reason'); ?>
  	</td>
  	<td width="25%">
        <?php 
        echo $this->Form->input('Encounter.transport_reason', array('type'=>'text', 'id' => 'transport_reason', 'label'=> false, 'div' => false, 'error' => false,'class'=>'textBoxExpnd'));
        ?>       
	</td>
	</tr>
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%"><?php echo __('Transport Distance(Miles)'); ?>
  	</td>
  	<td width="25%">
        <?php 
        echo $this->Form->input('Encounter.transport_distance', array('type'=>'text', 'id' => 'transport_reason', 'label'=> false, 'div' => false, 'error' => false,'class'=>'textBoxExpnd'));
        ?>       
	</td>
	</tr>	 
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%"><?php echo __('Round Trip Description'); ?>
  	</td>
  	<td width="25%">
        <?php 
        echo $this->Form->input('Encounter.transport_description', array('type'=>'text', 'id' => 'transport_reason', 'label'=> false, 'div' => false, 'error' => false,'class'=>'textBoxExpnd'));
        ?>       
	</td>
	</tr>	 
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%"><?php echo __('Stretcher Purpose'); ?>
  	</td>
  	<td width="25%">
        <?php 
        echo $this->Form->input('Encounter.stretcher_purpose', array('type'=>'text', 'id' => 'transport_reason', 'label'=> false, 'div' => false, 'error' => false,'class'=>'textBoxExpnd'));
        ?>       
	</td>
	</tr>	 
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%"><?php echo __('Patient Weight(Pounds)'); ?>
  	</td>
  	<td width="25%">
        <?php 
        echo $this->Form->input('Encounter.patient_weight', array('type'=>'text', 'id' => 'transport_reason', 'label'=> false, 'div' => false, 'error' => false,'class'=>'textBoxExpnd'));
        ?>       
	</td>
	</tr>	 	 
	</table>	
	</td>
	</tr>	  
    </table>
  </div> 
  <!-- Contract -->
  <div id="tabs-9" class="tab-content" style="padding-top:5px;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="formFull">
    <tr>	
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Type'); ?>
	</td>
	<td width="25%">
        <?php 
        echo $this->Form->input('Encounter.contract_type', array('class' => 'textBoxExpnd','empty'=>__('Please Select'),'options'=>'', 'id' => 'contract_type', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	<td class="tdLabel" id="boxSpace" width="25%">
	<?php echo __('Amount'); ?></td>
	<td width="25%"><?php 
        echo $this->Form->input('Encounter.contract_amount', array('class' => 'textBoxExpnd', 'id' => 'contract_amount','label'=> false, 'div' => false, 'error' => false,'placeholder'=>''));
        ?>   
	</td>
	</tr>
	 <tr>	
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Percentage'); ?>
	</td>
	<td width="25%"><?php 
        echo $this->Form->input('Encounter.contract_percentage', array('class' => 'textBoxExpnd', 'type'=>'text','id' => 'contract_percentage', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>	
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Code'); ?>
	</td>
	<td width="25%">
        <?php 
        echo $this->Form->input('Encounter.contract_code', array('class' => 'textBoxExpnd', 'id' => 'contract_code', 'label'=> false, 'div' => false, 'error' => false,'placeholder'=>''));
        ?>
	</td>
	</tr>
	 <tr>	
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Discount Percentage'); ?>
	</td>
	<td width="25%">
        <?php  echo $this->Form->input('Encounter.discount_percentage', array('type'=>'text','class' => 'textBoxExpnd', 'id' => 'discount_percentage', 'label'=> false, 'div' => false, 'error' => false));
        ?>        
	</td>	
	<td class="tdLabel" id="boxSpace" width="25%">
	<?php echo __('Version'); ?></td>
	<td width="25%"><?php 
        echo $this->Form->input('Encounter.discount_version', array('class' => 'textBoxExpnd', 'id' => 'discount_version','label'=> false, 'div' => false, 'error' => false,'placeholder'=>''));
        ?>
    </td>
	</tr>	
    </table>
  </div>
  <!-- Vision -->
  <div id="tabs-10" class="tab-content" style="padding-top:5px;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="formFull">
   	<tr>
	<td width="50%" style="padding-left: 5px;padding-right: 2px;" valign="top">
	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="formFull" >
  	<tr class="row_title">
	<td class="tdLabel" id="boxSpace" width="19%" align="left" colspan="2" >
	<strong><?php echo __('Spectacle Lenses'); ?></strong>
	</td>
	</tr>	
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%"><?php echo __('Replacement:Loss or Theft'); ?>
  	</td>
  	<td width="25%">    
	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="formFull">
  	<tr>	
	<td  width="25%">
	<?php  $options=array('DNS'=>'Do Not Send','N'=>'No','Y'=>'Yes');
		   $attributes=array('legend'=>false,'empty'=>'Please Select', 'label'=> false, 'div' => false, 'error' => false);
           echo $this->Form->radio('Encounter.spect_replace_Loss_or_theft',$options,$attributes);
	?>
	</td>
	</tr>	
	</table>
	</td>
	</tr>	
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%"><?php echo __('Replacement:Breakage or Damage'); ?>
  	</td>
  	<td width="25%">    
	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="formFull">
  	<tr>	
	<td  width="25%">
	<?php  $options=array('DNS'=>'Do Not Send','N'=>'No','Y'=>'Yes');
		   $attributes=array('legend'=>false,'empty'=>'Please Select', 'label'=> false, 'div' => false, 'error' => false);
           echo $this->Form->radio('Encounter.spect_replace_breakage_or_damage',$options,$attributes);
	?>
	</td>
	</tr>	
	</table>
	</td>
	</tr>	
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%"><?php echo __('Replacement:Patient Preference'); ?>
  	</td>
  	<td width="25%">    
	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="formFull">
  	<tr>	
	<td  width="25%">
	<?php  $options=array('DNS'=>'Do Not Send','N'=>'No','Y'=>'Yes');
		   $attributes=array('legend'=>false,'empty'=>'Please Select', 'label'=> false, 'div' => false, 'error' => false);
           echo $this->Form->radio('Encounter.spect_replace_patient_preference',$options,$attributes);
	?>
	</td>
	</tr>	
	</table>
	</td>
	</tr>	
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%"><?php echo __('Replacement:Medical Reason'); ?>
  	</td>
  	<td width="25%">    
	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="formFull">
  	<tr>	
	<td  width="25%">
	<?php  $options=array('DNS'=>'Do Not Send','N'=>'No','Y'=>'Yes');
		   $attributes=array('legend'=>false,'empty'=>'Please Select', 'label'=> false, 'div' => false, 'error' => false);
           echo $this->Form->radio('Encounter.spect_replace_medical_reason',$options,$attributes);
	?>
	</td>
	</tr>	
	</table>
	</td>
	</tr>	
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%"><?php echo __('General Standard of 20 Dregree OR .5 Diopter Sphere OR Cylinder Change Met'); ?>
  	</td>
  	<td width="25%">    
	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="formFull">
  	<tr>	
	<td  width="25%">
	<?php  $options=array('DNS'=>'Do Not Send','N'=>'No','Y'=>'Yes');
		   $attributes=array('legend'=>false,'empty'=>'Please Select', 'label'=> false, 'div' => false, 'error' => false);
           echo $this->Form->radio('Encounter.spect_cylinder',$options,$attributes);
	?>
	</td>
	</tr>	
	</table>
	</td>
	</tr>	
	</table>
	<table><tr><td></td></tr></table>
	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="formFull">
	<tr class="row_title">
	<td class="tdLabel" id="boxSpace" width="19%" align="left" colspan="2" >
	<strong><?php echo __('Spectacle Frames'); ?></strong>
	</td>
	</tr>	
		<tr>
	<td class="tdLabel " id="boxSpace" width="25%"><?php echo __('Replacement:Loss or Theft'); ?>
  	</td>
  	<td width="25%">    
	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="formFull">
  	<tr>	
	<td  width="25%">
	<?php  $options=array('DNS'=>'Do Not Send','N'=>'No','Y'=>'Yes');
		   $attributes=array('legend'=>false,'empty'=>'Please Select', 'label'=> false, 'div' => false, 'error' => false);
           echo $this->Form->radio('Encounter.frame_replace_Loss_or_theft',$options,$attributes);
	?>
	</td>
	</tr>	
	</table>
	</td>
	</tr>	
		<tr>
	<td class="tdLabel " id="boxSpace" width="25%"><?php echo __('Replacement:Breakage or Damage'); ?>
  	</td>
  	<td width="25%">    
	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="formFull">
  	<tr>	
	<td  width="25%">
	<?php  $options=array('DNS'=>'Do Not Send','N'=>'No','Y'=>'Yes');
		   $attributes=array('legend'=>false,'empty'=>'Please Select', 'label'=> false, 'div' => false, 'error' => false);
           echo $this->Form->radio('Encounter.frame_replace_breakage_or_damage',$options,$attributes);
	?>
	</td>
	</tr>	
	</table>
	</td>
	</tr>	
	</table>			
	</td>
	<td width="50%" style="padding-right: 5px;padding-left: 2px;" valign="top">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
  	<tr>
	<td colspan="2">
	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="formFull" >
  	<tr class="row_title">
	<td class="tdLabel" id="boxSpace" width="19%" align="left" colspan="2" >
	<strong><?php echo __('Contact Lenses'); ?></strong>
	</td>
	</tr>	
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%"><?php echo __('Replacement:Loss or Theft'); ?>
  	</td>
  	<td width="25%">    
	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="formFull">
  	<tr>	
	<td  width="25%">
	<?php  $options=array('DNS'=>'Do Not Send','N'=>'No','Y'=>'Yes');
		   $attributes=array('legend'=>false,'empty'=>'Please Select', 'label'=> false, 'div' => false, 'error' => false);
           echo $this->Form->radio('Encounter.contact_replace_Loss_or_theft',$options,$attributes);
	?>
	</td>
	</tr>	
	</table>
	</td>
	</tr>	
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%"><?php echo __('Replacement:Breakage or Damage'); ?>
  	</td>
  	<td width="25%">    
	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="formFull">
  	<tr>	
	<td  width="25%">
	<?php  $options=array('DNS'=>'Do Not Send','N'=>'No','Y'=>'Yes');
		   $attributes=array('legend'=>false,'empty'=>'Please Select', 'label'=> false, 'div' => false, 'error' => false);
           echo $this->Form->radio('Encounter.contact_replace_breakage_or_damage',$options,$attributes);
	?>
	</td>
	</tr>	
	</table>
	</td>
	</tr>	
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%"><?php echo __('Replacement:Patient Preference'); ?>
  	</td>
  	<td width="25%">    
	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="formFull">
  	<tr>	
	<td  width="25%">
	<?php  $options=array('DNS'=>'Do Not Send','N'=>'No','Y'=>'Yes');
		   $attributes=array('legend'=>false,'empty'=>'Please Select', 'label'=> false, 'div' => false, 'error' => false);
           echo $this->Form->radio('Encounter.contact_replace_patient_preference',$options,$attributes);
	?>
	</td>
	</tr>	
	</table>
	</td>
	</tr>	
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%"><?php echo __('Replacement:Medical Reason'); ?>
  	</td>
  	<td width="25%">    
	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="formFull">
  	<tr>	
	<td  width="25%">
	<?php  $options=array('DNS'=>'Do Not Send','N'=>'No','Y'=>'Yes');
		   $attributes=array('legend'=>false,'empty'=>'Please Select', 'label'=> false, 'div' => false, 'error' => false);
           echo $this->Form->radio('Encounter.contact_replace_medical_reason',$options,$attributes);
	?>
	</td>
	</tr>	
	</table>
	</td>
	</tr>	
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%"><?php echo __('General Standard of 20 Dregree OR .5 Diopter Sphere OR Cylinder Change Met'); ?>
  	</td>
  	<td width="25%">    
	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="formFull">
  	<tr>	
	<td width="25%">
	<?php  $options=array('DNS'=>'Do Not Send','N'=>'No','Y'=>'Yes');
		   $attributes=array('legend'=>false,'empty'=>'Please Select', 'label'=> false, 'div' => false, 'error' => false);
           echo $this->Form->radio('Encounter.contact_cylinder',$options,$attributes);
	?>
	</td>
	</tr>	
	</table>
	</td>
	</tr>	
	</table>
	</td>
	</tr>	
	</table>	
	</td>
	</tr>	  
    </table>
  </div>  
  </div>
  </td></tr></table>
  </td>
	</tr>
	
	<tr class="row_title">			
	<td class="tdLabel" id="boxSpace" width="19%" align="left" colspan="4">
	<strong><?php echo __('Procedures'); ?></strong>
	</td>	
	</tr>	
	
	<tr>
	<td colspan="4"  valign="top">		
	<table style="border: 1px solid #4C5E64;" width="100%">
	<tr class='row_title'>
	<td valign="top"  class="tdLabel" id="boxSpace"><strong><?php echo __('From'); ?></strong>
	</td>
	
	<td valign="top"  class="tdLabel" id="boxSpace"><strong><?php echo __('To'); ?></strong>
	</td>
	
	<td valign="top"  class="tdLabel" id="boxSpace"><strong><?php echo __('Procedure'); ?></strong>
	</td>
	
	<td valign="top"  class="tdLabel" id="boxSpace"><strong><?php echo __('Modifier1'); ?></strong>
	</td>
	<td valign="top"  class="tdLabel" id="boxSpace"><strong><?php echo __('Modifier2'); ?></strong>
	</td>
	<td valign="top"  class="tdLabel" id="boxSpace"><strong><?php echo __('Modifier3'); ?></strong>
	</td>
	<td valign="top"  class="tdLabel" id="boxSpace"><strong><?php echo __('Modifier4'); ?></strong>
	</td>
	
	<td valign="top"  class="tdLabel" id="boxSpace"><strong><?php echo __('Units'); ?></strong>
	</td>
	
	<td valign="top"  class="tdLabel" id="boxSpace"><strong><?php echo __('Unit Charge'); ?></strong>
	</td>
	
	<td valign="top"  class="tdLabel" id="boxSpace"><strong><?php echo __('Total Charge'); ?></strong>
	</td>
	
	<td valign="top"  class="tdLabel" id="boxSpace"><strong><?php echo __('Diagnosis'); ?></strong>
	</td>
	
	<!--  <td valign="top"  class="tdLabel" id="boxSpace"><strong><?php //echo __('Concur.Proc.'); ?></strong>
	</td>
	
	<td valign="top"  class="tdLabel" id="boxSpace"><strong><?php //echo __('Start Time'); ?></strong>
	</td>
	
	<td valign="top"  class="tdLabel" id="boxSpace"><strong><?php //echo __('Patient Resp'); ?></strong>
	</td>-->
	</tr>
	<?php $total=0;foreach($getPrData as $getPrData){?>
	<tr>
	<td valign="top"  class="tdLabel" id="boxSpace"><?php  if(!empty($getPrData['ProcedurePerform']['procedure_date']))echo $this->DateFormat->formatDate2Local($getPrData['ProcedurePerform']['procedure_date'],Configure::read('date_format'));?>
	</td>
	
	<td valign="top"  class="tdLabel" id="boxSpace"><?php if(!empty($getPrData['ProcedurePerform']['procedure_to_date']))echo $this->DateFormat->formatDate2Local($getPrData['ProcedurePerform']['procedure_to_date'],Configure::read('date_format'));?>
	</td>
	<td valign="top"  class="tdLabel" id="boxSpace"><?php echo $getPrData['ProcedurePerform']['snowmed_code'].":".$getPrData['ProcedurePerform']['procedure_name']; ?>
	</td>
	<td valign="top"  class="tdLabel" id="boxSpace" width='10%'><?php  if(!empty($getPrData['ProcedurePerform']['modifier1']))echo$getPrData['ProcedurePerform']['modifier1'].":".$BilCode[$getPrData['ProcedurePerform']['modifier1']];?>
	</td>
	
	<td valign="top"  class="tdLabel" id="boxSpace" width='10%'><?php if(!empty($getPrData['ProcedurePerform']['modifier2']))echo $getPrData['ProcedurePerform']['modifier2'].":".$BilCode[$getPrData['ProcedurePerform']['modifier2']];?>
	</td>
	
	<td valign="top"  class="tdLabel" id="boxSpace" width='10%'><?php if(!empty($getPrData['ProcedurePerform']['modifier3']))echo $getPrData['ProcedurePerform']['modifier3'].":".$BilCode[$getPrData['ProcedurePerform']['modifier3']];?>
	</td>
	
	<td valign="top"  class="tdLabel" id="boxSpace" width='10%'><?php if(!empty($getPrData['ProcedurePerform']['modifier4']))echo $getPrData['ProcedurePerform']['modifier4'].":".$BilCode[$getPrData['ProcedurePerform']['modifier4']];?>
	</td>
	
	<td valign="top"  class="tdLabel" id="boxSpace"><?php echo $getPrData['ProcedurePerform']['units'];?>
	</td>
	
	<td valign="top"  class="tdLabel" id="boxSpace"><?php echo $getPrData['TariffAmount']['non_nabh_charges'];?>
	</td>
	
	<td valign="top"  class="tdLabel" id="boxSpace"><?php echo $this->Number->currency(($getPrData['ProcedurePerform']['units'])*($getPrData['TariffAmount']['non_nabh_charges']));
	$total=$total+(($getPrData['ProcedurePerform']['units'])*($getPrData['TariffAmount']['non_nabh_charges']));?>
	</td>
	
	<td valign="top"  class="tdLabel" id="boxSpace"><?php if(!empty($getPrData['ProcedurePerform']['patient_daignosis'])){
		$expDat=explode(',',$getPrData['ProcedurePerform']['patient_daignosis']);$cnt=1;
	for($i=0;$i<count($expDat);$i++) {
		echo $cnt.') '.$expDat[$i].'<br/>';
		$cnt++;}}?>
	</td>
	</tr>
	<?php }?>
	
	</table>
	</td>
	</tr>
	</table>
	<div class="btns">
		<?php
		echo "&nbsp;&nbsp;".$this->Form->submit('Next',array('class'=>'blueBtn','div'=>false,'title'=>'Next'));
				/*	echo "&nbsp;&nbsp;".$this->Form->submit('Save for Review',array('class'=>'blueBtn','div'=>false,'id'=>'submit','title'=>'Save for Review'));	
					echo "&nbsp;&nbsp;".$this->Form->submit('Approve',array('class'=>'blueBtn','div'=>false,'id'=>'submit','title'=>'Approve'));
					echo $this->Html->link(__('Cancel'),array('action' => 'addBeforeClaim'),array('escape' => false,'class'=>'grayBtn','title'=>'Cancel'));
					echo "&nbsp;&nbsp;".$this->Form->submit('Check Codes..',array('class'=>'blueBtn','div'=>false,'id'=>'submit','title'=>'Check Codes..'));
	   */ ?>	
		</div>
		<?php echo $this->Form->end(); ?>
<script>

$(document).ready(function(){
	$('#payment_amount').val('<?php echo $total;?>');
	$('#primary_insurance').click(function(){
		 $("select option[value='S']").attr('disabled',true);
		 $("select option[value='T']").attr('disabled',true);
	});
		
	$('#claim_type').focus();
	$(".common_dateCls")
	.datepicker(
			{
			showOn : "button",
			buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly : true,
			changeMonth : true,
			changeYear : true,
			dateFormat:'<?php echo $this->General->GeneralDate();?>',
			onSelect : function() {
			$(this).focus();
			}

		});		
	 });



function getBillingProfile(){
	$.fancybox({
		'width' : '100%',
		'height' : '50%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'href' : "<?php echo $this->Html->url(array("controller"=>"Insurances", "action" => "billingProfile")); ?>"

	});
}
	 
</script>
