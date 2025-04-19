<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#guarantorfrm").validationEngine();
	});
	
</script>
<div class="inner_title">
<h3><?php echo __('Add Guarantor', true); ?></h3>
</div>
<?php 
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td  align="left" class="error">
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
 
<?php  echo $this->Form->create('PatientGaurantor',array('type' => 'file','id'=>'guarantorfrm','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false,
																								        'legend'=>false,
																								        'fieldset'=>false
																								    )
			));
echo $this->Form->hidden('PatientGaurantor.id', array('id'=>'id'));
		 ?>
	<table border="0" cellpadding="0" cellspacing="0" width="50%" class="formFull" style="padding-top: 10px;" align="center">
	<tr>
	<td class="form_lables" align="right">
	<?php echo __('First Name'); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('PatientGaurantor.first_name', array('class' => 'validate[required,custom[onlyLetterSp]]', 'id' => 'first_name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));
        ?>
	</td>
	</tr>
	<tr>
	<td class="form_lables" align="right">
	<?php echo __('Last Name'); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('PatientGaurantor.last_name', array('class' => 'validate[required,custom[onlyLetterSp]]', 'id' => 'last_name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));
        ?>
	</td>
	</tr>
	<tr>
	<td class="form_lables" align="right">
	<?php echo __('Relationship with Patient'); ?>
	</td>
	<td>
        <?php 
        echo $this->Form->input('PatientGaurantor.relationship', array('type'=>'textaraea','class' => '', 'id' => 'relationship', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));
        ?>
	</td>
	</tr>
	<tr>
	<td class="form_lables" align="right">
	<?php echo __('Gender'); ?>
	</td>
	<td>
        <?php  echo $this->Form->input('PatientGaurantor.sex', array('options'=> array('M' => 'Male', 'F' => 'Female'), 'empty' => 'Select Gender','class' => ' textBoxExpnd','id' => 'sex'));
        ?>
	</td>
	</tr>
	<!-- <tr>
	<td class="form_lables" align="right">
	<?php echo __('Date of Birth'); ?>
	</td>
	<td>	<?php 
        echo $this->Form->input('PatientGaurantor.dob', array('type'=>'text','class' => '', 'id' => 'dob', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off','readonly' => 'readonly'));
        ?>
	</td>
	</tr> -->
	<tr>
		<td class="form_lables" align="right"><?php echo __('Country',true); ?></td>
		<td><?php 
		echo $this->Form->input('PatientGaurantor.country', array('options' => $countries,'empty' => 'Select Country','selected'=>'1' ,'id' => 'customcountry', 'class' => ' textBoxExpnd',
			'label'=> false, 'div' => false, 'error' => false,
			'onchange'=> $this->Js->request(array('controller'=>'users','action' => 'get_state_city','reference'=>'State',
			'admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
			'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
			'async' => true, 'update' => '#changeStates', 'data' => '{reference_id:$("#customcountry").val()}', 'dataExpression' => true, 'div'=>false)))); ?>
		</td>
	</tr>
	<tr>
		<td class="form_lables" align="right"><?php echo __('State',true); ?></td>
		<td id="changeStates"><?php 
		echo $this->Form->input('PatientGaurantor.state', array('options'=>$tempState,'selected'=>'19' ,'id' => 'customstate', 'label'=> false, 'div' => false, 'error' => false,'empty'=>'Select State','class' => ' textBoxExpnd '));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables" align="right"><?php echo __('City',true); ?>
		<td><?php echo $this->Form->input('PatientGaurantor.city', array('type'=>'text','id' => 'city','label'=> false,'class' =>'textBoxExpnd','value' =>Configure::read('doctor_city'))); ?>
		</td>
	</tr>
	<tr>
	<td class="form_lables" align="right">
	<?php echo __('Address'); ?>
	</td>
	<td>
        <?php 
        echo $this->Form->textarea('PatientGaurantor.address', array('class' => '', 'id' => 'address', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));
        ?>
	</td>
	</tr>
		<tr>
	<td class="form_lables" align="right">
	<?php echo __('Zip Code'); ?>
	</td>
	<td>
        <?php 
        echo $this->Form->input('PatientGaurantor.zip_code', array('class' => 'validate[optional,custom[onlyNumber,minSize[6]]]','Maxlength'=>'6', 'id' => 'zip_code', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));
        ?>
	</td>
	</tr>
	<tr>
	<td colspan="2" align="center">

	</td>
	</tr>
	</table>
	<div style="text-align:center;">	<?php
                                		 
                                		echo $this->Form->submit(__('Save'), array('id'=>'save','escape' => false,'class' => 'blueBtn','label' => false,'div' => false,'error'=>false));
                                		
                                		echo $this->Html->link(__('Cancel'), array('action' => 'index'), array('escape' => false,'class' => 'grayBtn'));
                                	?></div>
<?php echo $this->Form->end(); ?>

<script>
$(document).ready(function(){
	 $("#dob").datepicker({	
     	
 		changeMonth : true,
 		changeYear : true, 
 		minDate: new Date(),
 		dateFormat : '<?php echo $this->General->GeneralDate('');?>',
 		showOn : 'button',
 		buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
 		buttonImageOnly : true,
 		onSelect : function() {
 			$(this).focus();
 		}
 	});
});
</script>