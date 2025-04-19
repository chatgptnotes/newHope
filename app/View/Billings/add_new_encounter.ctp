<?php echo $this->Html->script(array('ui.datetimepicker.3.js'));?>

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
	jQuery("#tariffstandard").validationEngine();
	});
	
</script>

<div class="inner_title">
	<h3><?php echo __('Add New Encounter'); ?></h3>
	<span><?php  echo $this->Html->link('Back',array("controller"=>"tariffs","action"=>"viewStandard"),array('escape'=>false,'class'=>'blueBtn','title'=>'Back')); ?></span>
	
</div>
<?php echo $this->Form->create('tariffstandard',array('type' => 'file','id'=>'tariffstandard','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false,
																								        'legend'=>false,
																								        'fieldset'=>false
																								    )
			));
			?>
	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="formFull" style="padding-top: 10px;" align="center">
	
	<tr>
	<td class="tdLabel" id="boxSpace" width="25%">
	<?php echo __('Claim Type'); ?><font color="red">*</font>
	</td>
	<td width="25%">
        <?php 
        echo $this->Form->input('TariffStandard.claim_type', array('class' => 'textBoxExpnd validate[required,custom[mandatory-select]] ','empty'=>__('Please Select'), 'id' => 'claim_type','options'=>array('Professional(CMS-500)'=>'Professional(CMS-500)'), 'label'=> false, 'div' => false, 'error' => false));
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
        echo $this->Form->input('TariffStandard.visit_id', array('class' => 'textBoxExpnd','type'=>'text', 'id' => 'visit_id', 'label'=> false, 'div' => false, 'error' => false,'placeholder'=>''));
        ?>	
	</td>
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Primary Insurance'); ?>
	</td>
	<td width="25%"><?php 
        echo $this->Form->input('TariffStandard.primary_insurance', array('class' => 'textBoxExpnd','type'=>'text', 'id' => 'primary_insurance', 'label'=> false, 'div' => false, 'error' => false,'placeholder'=>''));
        ?>
	</td>	
	</tr>
	
	<tr>	
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Name'); ?>
	</td>
	<td width="25%">
        <?php 
        echo $this->Form->input('TariffStandard.name', array('class' => 'textBoxExpnd','type'=>'text', 'id' => 'name', 'label'=> false, 'div' => false, 'error' => false,'placeholder'=>''));
        ?>	
	</td>
	<td class="tdLabel" id="boxSpace" width="25%">
	<?php echo __('Pre Authorization Approval No.'); ?></td>
	<td width="25%"><?php 
        echo $this->Form->input('TariffStandard.approval_no', array('class' => 'textBoxExpnd','type'=>'text', 'id' => 'approval_no','label'=> false, 'div' => false, 'error' => false,'placeholder'=>''));
        ?>
    </td>
	</tr>
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Case'); ?>
	</td>
	<td width="25%">
        <?php 
        echo $this->Form->input('TariffStandard.case', array('class' => 'textBoxExpnd','type'=>'text', 'id' => 'case', 'label'=> false, 'div' => false, 'error' => false,'placeholder'=>''));
        ?>	
	</td>
	<td class="tdLabel " id="boxSpace" width="25%">
	</td>
	<td width="25%">
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
        echo $this->Form->input('TariffStandard.service_date', array('type'=>'text', 'id' => 'service_date', 'label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly','class'=>'textBoxExpnd'));
        ?>  
	</td>
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Post Date'); ?>
	</td>
	<td width="25%"> <?php 
        echo $this->Form->input('TariffStandard.post_date', array('type'=>'text', 'id' => 'post_date', 'label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly','class'=>'textBoxExpnd'));
        ?>        
	</td>
	</tr>
	
	<tr>	
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('To Date(Optional)'); ?>
	</td>
	<td width="25%">
       <?php 
        echo $this->Form->input('TariffStandard.to_date', array('type'=>'text', 'id' => 'to_date', 'label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly','class'=>'textBoxExpnd'));
        ?>		
	</td>
	<td class="tdLabel" id="boxSpace" width="25%">
	<?php echo __('Batch No.'); ?></td>
	<td width="25%"><?php 
        echo $this->Form->input('TariffStandard.cpt_codes', array('class' => 'textBoxExpnd','type'=>'text', 'id' => 'cpt_codes','label'=> false, 'div' => false, 'error' => false,'placeholder'=>''));
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
        <?php 
        echo $this->Form->input('TariffStandard.scheduling_provider', array('class' => 'textBoxExpnd','empty'=>__('Select'),'options'=>'', 'id' => 'scheduling_provider', 'label'=> false, 'div' => false, 'error' => false,'placeholder'=>''));
        ?>
	</td>
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Referring Provider'); ?>
	</td>
	<td width="25%"><?php 
        echo $this->Form->input('TariffStandard.referring_provider', array('class' => 'textBoxExpnd','empty'=>__('Select'),'options'=>'', 'id' => 'referring_provider', 'label'=> false, 'div' => false, 'error' => false,'placeholder'=>''));
        ?>
	</td>	
	</tr>
	
	<tr>	
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Rendering Provider'); ?>
	</td>
	<td width="25%">
        <?php 
        echo $this->Form->input('TariffStandard.referring_provider', array('class' => 'textBoxExpnd','empty'=>__('Select'),'options'=>'', 'id' => 'ndc_codes', 'label'=> false, 'div' => false, 'error' => false,'placeholder'=>''));
        ?>
	</td>
	<td class="tdLabel" id="boxSpace" width="25%">
	<?php echo __('Location/Department'); ?></td>
	<td width="25%"><?php 
        echo $this->Form->input('TariffStandard.cpt_codes', array('class' => 'textBoxExpnd','empty'=>__('Select'),'options'=>'', 'id' => 'cpt_codes','label'=> false, 'div' => false, 'error' => false,'placeholder'=>''));
        ?>
    </td>
	</tr>
	
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Supervising Provider'); ?>
	</td>
	<td width="25%">
        <?php 
        echo $this->Form->input('TariffStandard.ndc_codes', array('class' => 'textBoxExpnd','empty'=>__('Select'),'options'=>'', 'id' => 'ndc_codes', 'label'=> false, 'div' => false, 'error' => false,'placeholder'=>''));
        ?>
	</td>
	<td class="tdLabel" id="boxSpace" width="25%">
	<?php echo __('Place of Service/Facility'); ?></td>
	<td width="25%"><?php 
        echo $this->Form->input('TariffStandard.cpt_codes', array('class' => 'textBoxExpnd','empty'=>__('Select'),'options'=>'', 'id' => 'cpt_codes','label'=> false, 'div' => false, 'error' => false,'placeholder'=>''));
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
        <?php 
        echo $this->Form->input('TariffStandard.icd_codes', array('class' => 'textBoxExpnd','type'=>'text', 'id' => 'icd_codes', 'label'=> false, 'div' => false, 'error' => false,'placeholder'=>''));
        ?>
	</td>
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Payment Posted Date'); ?>
	</td>
	<td width="25%"><?php 
        echo $this->Form->input('TariffStandard.payment_post_date', array('type'=>'text', 'id' => 'payment_post_date', 'label'=> false, 'div' => false, 'error' => false,'placeholder'=>'','readonly'=>'readonly','class'=>'textBoxExpnd'));
        ?>
	</td>	
	</tr>
	
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Payment Amount'); ?>
	</td>
	<td width="25%">
        <?php 
        echo $this->Form->input('TariffStandard.ndc_codes', array('class' => '','type'=>'text', 'id' => 'ndc_codes', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:160px;','placeholder'=>''));
        ?>
        <?php 
        echo $this->Form->input('TariffStandard.cpt_codes', array('class' => '','empty'=>__('Select'),'options'=>array('Cash'=>'Cash','Check'=>'Check','Debit'=>'Debit','Creadit card'=>'Creadit card','Amex'=>'Amex','Visa'=>'Visa','Master Card'=>'Master Card','Discover'=>'Discover','Other'=>'Other','Square'=>'Square'), 'id' => 'cpt_codes', 'label'=> false, 'div' => false, 'error' => false,'placeholder'=>'','style'=>'width:168px;'));
        ?>
	</td>
	<td class="tdLabel" id="boxSpace" width="25%">
	<?php echo __('Payment Profile'); ?></td>
	<td width="25%"><?php 
        echo $this->Form->input('TariffStandard.cpt_codes', array('class' => 'textBoxExpnd','empty'=>__('Select'),'options'=>'', 'id' => 'cpt_codes','label'=> false, 'div' => false, 'error' => false,'placeholder'=>''));
        ?>
    </td>	
	</tr>
	
	<tr>
	<td class="tdLabel " id="boxSpace" width="25%">
	<?php echo __('Payment Notes'); ?>
	</td>
	<td width="25%">
        <?php 
        echo $this->Form->input('TariffStandard.ndc_codes', array('class' => 'textBoxExpnd','type'=>'text', 'id' => 'ndc_codes', 'label'=> false, 'div' => false, 'error' => false,'placeholder'=>''));
        ?>
	</td>
	<td class="tdLabel" id="boxSpace" width="25%">
	<?php echo __('Billing Profile'); ?></td>
	<td width="25%"><?php 
        echo $this->Form->input('TariffStandard.cpt_codes', array('class' => '','empty'=>__('Select'),'options'=>'', 'id' => 'cpt_codes','label'=> false, 'div' => false, 'error' => false,'placeholder'=>'','style'=>'width:300px;'));
        ?>
      <span>   <?php 
  echo $this->Html->link($this->Html->image('icons/cross.png',array('title'=>'Delete','alt'=>'Delete')), array('action' => 'addNewEncounter', $tariff['TariffStandard']['id']), array('escape' => false,'style'=>'float:right;'),__('Are you sure?', true));
 echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('title'=>'Edit','alt'=>'Edit')), array('action' => 'addNewEncounter', $tariff['TariffStandard']['id']), array('escape' => false,'style'=>'float:right;')); 
  echo $this->Html->link($this->Html->image('icons/add-icon.gif',array('title'=>'Add','alt'=>'Add')), array('action' => 'addNewEncounter', $tariff['TariffStandard']['id']), array('escape' => false,'style'=>'float:right;'));
  ?>
  </span> 	
	</td>
	</tr>
	
	<tr>
	<td class="tdLabel" id="boxSpace" width="25%"></td>
	<td width="25%"></td>
	<td class="tdLabel" id="boxSpace" width="25%">
	<?php echo __('Billing Pick List'); ?></td>
	<td width="25%"><?php 
      echo "&nbsp;&nbsp;".$this->Form->submit('Choose Codes From Pick List',array('class'=>'blueBtn','div'=>false,'id'=>'submit','title'=>'Choose Codes From Pick List'));
        ?>
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
		echo "&nbsp;&nbsp;".$this->Form->submit('Save as Draft',array('class'=>'blueBtn','div'=>false,'id'=>'submit','title'=>'Save as Draft'));
					echo "&nbsp;&nbsp;".$this->Form->submit('Save for Review',array('class'=>'blueBtn','div'=>false,'id'=>'submit','title'=>'Save for Review'));	
					echo "&nbsp;&nbsp;".$this->Form->submit('Approve',array('class'=>'blueBtn','div'=>false,'id'=>'submit','title'=>'Approve'));
					echo $this->Html->link(__('Cancel'),array('action' => 'addBeforeClaim'),array('escape' => false,'class'=>'grayBtn','title'=>'Cancel'));
					echo "&nbsp;&nbsp;".$this->Form->submit('Check Codes..',array('class'=>'blueBtn','div'=>false,'id'=>'submit','title'=>'Check Codes..'));
	    ?>	
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
