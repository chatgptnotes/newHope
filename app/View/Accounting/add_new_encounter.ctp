<?php 
echo $this->Html->script(array('jquery-1.5.1.min.js','jquery.validationEngine','/js/languages/jquery.validationEngine-en',
		'jquery-ui-1.8.16.custom.min','ui.datetimepicker.3.js'));
	 echo $this->Html->css(array('internal_style.css','jquery-ui-1.8.16.custom','validationEngine.jquery.css',));
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
 
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#encounterFrm").validationEngine();
	});
	
</script>

<div class="inner_title">
	<h3><?php echo __('Add New Encounter'); ?></h3>
	<span><?php  echo $this->Html->link('Back',array("controller"=>"tariffs","action"=>"viewStandard"),array('escape'=>false,'class'=>'blueBtn','title'=>'Back')); ?></span>
	
</div>
<?php echo $this->Form->create('Encounter',array('type' => 'file','id'=>'encounterFrm','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false,
																								        'legend'=>false,
																								        'fieldset'=>false
																								    )
			));
echo $this->Form->hidden('Encounter.patient_id',array('value'=>$patient_id));
			?>
	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="formFull" style="padding-top: 10px;" align="center">
	
	<tr>
	<td class="tdLabel" id="boxSpace" width="25%">
	<?php echo __('Claim Type'); ?><font color="red">*</font>
	</td>
	<td width="25%">
        <?php 
        echo $this->Form->input('Encounter.claim_type', array('class' => 'textBoxExpnd validate[required,custom[mandatory-select]] ','empty'=>__('Please Select'), 'id' => 'claim_type','options'=>array('Professional(CMS-500)'=>'Professional(CMS-500)'), 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td >
	<td width="25%">
	</td>
	<td width="25%">
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
	<?php echo __('Primary Insurance'); ?>
	</td>
	<td width="25%"><?php 
        echo $this->Form->input('Encounter.primary_insurance', array('class' => 'textBoxExpnd','type'=>'text', 'id' => 'primary_insurance','value'=>$getInsuranceNo['NewInsurance']['insurance_number'], 'label'=> false, 'div' => false, 'error' => false,'placeholder'=>'','readonly'=>'readonly'));
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
        echo $this->Form->input('Encounter.assigned_coder', array('class' => 'textBoxExpnd', 'id' => 'assigned_coder','empty'=>__('Please Select'),'options'=>$users, 'label'=> false, 'div' => false, 'error' => false,'placeholder'=>''));
        ?>	
	</td>
	</tr>	
		
	<tr class="row_title">			
	<td class="tdLabel" id="boxSpace" width="19%" align="left" colspan="4">
	<strong><?php echo __('Dates'); ?></strong>
	</td>	
	</tr>	
	
	<tr>	
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Service Date'); ?><font color="red">*</font>
	</td>
	<td width="25%">
        <?php 
          	$getadmitDate=$getPatientInfo['Patient']['form_received_on'] = $this->DateFormat->formatDate2Local($getPatientInfo['Patient']['form_received_on'],Configure::read('date_format'));

          	echo $this->Form->input('Encounter.service_date', array('type'=>'text', 'id' => 'service_date', 'label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly','class'=>'textBoxExpnd validate[required,custom[mandatory-date]] ','value'=>$getadmitDate));
        ?>  
	</td>
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Post Date'); ?>
	</td>
	<td width="25%"> <?php 
        echo $this->Form->input('Encounter.post_date', array('type'=>'text', 'id' => 'post_date', 'label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly','class'=>'textBoxExpnd'));
        ?>        
	</td>
	</tr>
	
	<tr>	
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('To Date(Optional)'); ?>
	</td>
	<td width="25%">
       <?php 	$getdischargeDate=$getPatientInfo['Patient']['discharge_date'] = $this->DateFormat->formatDate2Local($getPatientInfo['Patient']['discharge_date'],Configure::read('date_format'));
        echo $this->Form->input('Encounter.to_date', array('type'=>'text', 'id' => 'to_date', 'label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly','class'=>'textBoxExpnd','value'=>$getdischargeDate));
        ?>		
	</td>
	<td class="tdLabel" id="boxSpace" width="25%">
	<?php echo __('Batch No'); ?></td>
	<td width="25%"><?php 
        echo $this->Form->input('Encounter.batch_no', array('class' => 'textBoxExpnd','type'=>'text', 'id' => 'batch_no','label'=> false, 'div' => false, 'error' => false,'placeholder'=>''));
        ?>
    </td>
    </tr>	
	
	<tr class="row_title">			
	<td class="tdLabel" id="boxSpace" width="19%" align="left" colspan="4">
	<strong><?php echo __('Provider'); ?></strong>
	</td>	
	</tr>	
	
	 <tr>	
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Scheduling Provider'); ?>
	</td>
	<td width="25%">
        <?php  //debug($doctors);exit;
        echo $this->Form->input('Encounter.scheduling_provider', array('class' => 'textBoxExpnd','empty'=>__('Please Select'),'options'=>$doctors, 'id' => 'scheduling_provider', 'label'=> false, 'div' => false, 'error' => false));
        //actual field to enter in db
       // echo $this->Form->hidden('Encounter.scheduling_provider', array('type'=>'text','id'=>'scheduling_provider','value'=>''));
        ?>
        
	</td>
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Referring Provider'); ?>
	</td>
	<td width="25%"><?php 
        echo $this->Form->input('Encounter.referring_provider', array('class' => 'textBoxExpnd', 'type'=>'text','id' => 'referring_provider', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>	
	</tr>
	
	<tr>	
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Rendering Provider'); ?>
	</td>
	<td width="25%">
        <?php 
        echo $this->Form->input('Encounter.rendering_provider', array('class' => 'textBoxExpnd','empty'=>__('Please Select'),'options'=>$doctors, 'id' => 'rendering_provider', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	<td class="tdLabel" id="boxSpace" width="25%">
	<?php echo __('Location/Department'); ?></td>
	<td width="25%"><?php 
        echo $this->Form->input('Encounter.location_dept', array('class' => 'textBoxExpnd','empty'=>__('Please Select'),'options'=>$departments, 'id' => 'location_dept','label'=> false, 'div' => false, 'error' => false,'placeholder'=>''));
        ?>
    </td>
	</tr>
	
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Supervising Provider'); ?>
	</td>
	<td width="25%">
        <?php 
        echo $this->Form->input('Encounter.supervising_provider', array('class' => 'textBoxExpnd','empty'=>__('Please Select'),'options'=>$doctors, 'id' => 'supervising_provider', 'label'=> false, 'div' => false, 'error' => false,'placeholder'=>''));
        ?>
	</td>
	<td class="tdLabel" id="boxSpace" width="25%">
	<?php echo __('Place of Service/Facility'); ?></td>
	<td width="25%"><?php 
        echo $this->Form->input('Encounter.place_of_facility', array('class' => 'textBoxExpnd','empty'=>__('Please Select'),'options'=>$cities, 'id' => 'place_of_facility','label'=> false, 'div' => false, 'error' => false,'placeholder'=>''));
        ?>   
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
        <?php //debug($getCopayDue['FinalBilling']['copay']);exit;
        echo $this->Form->input('Encounter.copay_due', array('class' => 'textBoxExpnd','type'=>'text', 'id' => 'copay_due', 'label'=> false, 'div' => false, 'error' => false,'placeholder'=>''));
        ?>
	</td>
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Payment Posted Date'); ?>
	</td>
	<td width="25%"><?php 
        echo $this->Form->input('Encounter.payment_post_date', array('type'=>'text', 'id' => 'payment_post_date', 'label'=> false, 'div' => false, 'error' => false,'placeholder'=>'','readonly'=>'readonly','class'=>'textBoxExpnd'));
        ?>
	</td>	
	</tr>
	
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Payment Amount'); ?>
	</td>
	<td width="25%">
        <?php 
        echo $this->Form->input('Encounter.payment_amount', array('class' => '','type'=>'text', 'id' => 'payment_amount', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:160px;','placeholder'=>''));
        ?>
        <?php 
        echo $this->Form->input('Encounter.payment_amount_type', array('class' => '','empty'=>__('Select'),'options'=>array('Cash'=>'Cash','Check'=>'Check','Debit'=>'Debit','Creadit Card'=>'Creadit Card','Amex'=>'Amex','Visa'=>'Visa','Master Card'=>'Master Card','Discover'=>'Discover','Other'=>'Other','Square'=>'Square'), 'id' => 'payment_amount_type', 'label'=> false, 'div' => false, 'error' => false,'placeholder'=>'','style'=>'width:168px;'));
        ?>
	</td>
		<td class="tdLabel" id="boxSpace" width="25%">
	<?php echo __('Billing Profile'); ?></td>
	<td width="25%"><?php 
        echo $this->Form->input('Encounter.billing_profile', array('class' => '','empty'=>__('Select'),'options'=>'', 'id' => 'billing_profile','label'=> false, 'div' => false, 'error' => false,'placeholder'=>'','style'=>'width:300px;'));
        ?>
      <span>   <?php 
  echo $this->Html->link($this->Html->image('icons/cross.png',array('title'=>'Delete','alt'=>'Delete')), array('action' => 'addNewEncounter', $tariff['TariffStandard']['id']), array('escape' => false,'style'=>'float:right;'),__('Are you sure?', true));
 //echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('title'=>'Edit','alt'=>'Edit')), array('action' => 'addNewEncounter', $tariff['TariffStandard']['id']), array('escape' => false,'style'=>'float:right;')); 
  echo $this->Html->link($this->Html->image('icons/add-icon.gif',array('title'=>'Add','alt'=>'Add')), array('action' => 'addNewEncounter', $tariff['TariffStandard']['id']), array('escape' => false,'style'=>'float:right;'));
  ?>
  </span> 	
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
	
	<td valign="top"  class="tdLabel" id="boxSpace"><strong><?php echo __('Mod1'); ?></strong>
	</td>
	
	<td valign="top"  class="tdLabel" id="boxSpace"><strong><?php echo __('Units'); ?></strong>
	</td>
	
	<td valign="top"  class="tdLabel" id="boxSpace"><strong><?php echo __('Unit Charge'); ?></strong>
	</td>
	
	<td valign="top"  class="tdLabel" id="boxSpace"><strong><?php echo __('Total Charge'); ?></strong>
	</td>
	
	<td valign="top"  class="tdLabel" id="boxSpace"><strong><?php echo __('Diag1'); ?></strong>
	</td>
	
	<td valign="top"  class="tdLabel" id="boxSpace"><strong><?php echo __('Concur.Proc.'); ?></strong>
	</td>
	
	<td valign="top"  class="tdLabel" id="boxSpace"><strong><?php echo __('Start Time'); ?></strong>
	</td>
	
	<td valign="top"  class="tdLabel" id="boxSpace"><strong><?php echo __('Patient Resp'); ?></strong>
	</td>
	</tr>
	<tr>
	<td valign="top"  class="tdLabel" id="boxSpace">
	</td>
	
	<td valign="top"  class="tdLabel" id="boxSpace">
	</td>
	
	<td valign="top"  class="tdLabel" id="boxSpace">
	</td>
	
	<td valign="top"  class="tdLabel" id="boxSpace">
	</td>
	
	<td valign="top"  class="tdLabel" id="boxSpace">
	</td>
	
	<td valign="top"  class="tdLabel" id="boxSpace">
	</td>
	
	<td valign="top"  class="tdLabel" id="boxSpace">
	</td>
	
	<td valign="top"  class="tdLabel" id="boxSpace">
	</td>
	
	<td valign="top"  class="tdLabel" id="boxSpace">
	</td>
	
	<td valign="top"  class="tdLabel" id="boxSpace">
	</td>
	
	<td valign="top"  class="tdLabel" id="boxSpace">
	</td>
	</tr>
	</table>
	</td>
	</tr>
	</table>
	<div class="btns">
		<?php
		echo "&nbsp;&nbsp;".$this->Form->submit('Save',array('class'=>'blueBtn','div'=>false,'title'=>'Save'));
				/*	echo "&nbsp;&nbsp;".$this->Form->submit('Save for Review',array('class'=>'blueBtn','div'=>false,'id'=>'submit','title'=>'Save for Review'));	
					echo "&nbsp;&nbsp;".$this->Form->submit('Approve',array('class'=>'blueBtn','div'=>false,'id'=>'submit','title'=>'Approve'));
					echo $this->Html->link(__('Cancel'),array('action' => 'addBeforeClaim'),array('escape' => false,'class'=>'grayBtn','title'=>'Cancel'));
					echo "&nbsp;&nbsp;".$this->Form->submit('Check Codes..',array('class'=>'blueBtn','div'=>false,'id'=>'submit','title'=>'Check Codes..'));
	   */ ?>	
		</div>
		<?php echo $this->Form->end(); ?>
<script>

$(document).ready(function(){
	$('#claim_type').focus();
	
	$("#service_date,#to_date,#post_date,#payment_post_date")
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
	 
</script>
