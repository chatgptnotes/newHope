<?php  echo $this->Html->script(array('inline_msg','jquery.blockUI')); ?> 
<div class="inner_title">
	<h3>
		<?php echo __('Send Referral to Specialist', true); ?>
	</h3>
	
</div> 
<?php 
if(!empty($errors)) {
		?>
<table border="0" cellpadding="0" cellspacing="0" width="100%"
	align="center">
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
<div class="clr">&nbsp;</div>
<?php echo $this->Form->create('referal_note',array('id'=>'referal_note','url'=>array('controller'=>'Ccda','action'=>'referral_note',$patientId,'admin'=>false),
		'inputDefaults' => array('label' => false, 'div' => false,'error'=>false )));?>
<table width="25%" align="center" > 
	<tr>
	<td style="text-align: right;">Send referral to <font style="color: red">*</font>
		<td><?php 
		echo $this->Form->input('physician_name',array('type'=>'text','class'=>'validate[required,custom[mandatory-enter]] physician-filter textBoxExpnd','id'=>"physician-filter",
				'autocomplete'=>'off','label'=>false,'div'=>false));
		
		echo $this->Form->hidden('physician_id',array('id'=>'physician_id'));?>
		</td>
	</tr>
	<tr>
	<td style="text-align: right;">Speciality <font style="color: red">*</font></td>
		<td><?php 
			echo $this->Form->input('speciality_name',array('type'=>'text','id'=>'speciality-filter','class'=>'validate[required,custom[mandatory-enter]] textBoxExpnd','div'=>false,'autocomplete'=>'off'));
			echo $this->Form->hidden('speciality_id',array('id'=>'speciality_id'));?>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="right"><?php 
		echo $this->Form->submit('Save',array('class'=>'blueBtn','id'=>'submit','div'=>false)) ;
		//echo $this->Form->button('Sign',array('class'=>'blueBtn','div'=>false,'style'=>'margin-left:5px;')) ;
		?>
		</td>
	</tr> 
	
</table>
<?php 
echo $this->Form->end();
?>  

<script>
jQuery(document).ready(function(){
	$('#submit').click(function() { 
		var validatePerson = jQuery("#referal_note").validationEngine('validate');
		if (validatePerson) {$(this).css('display', 'none');
		parent.$.fancybox.close();
		return true;
		}
		else{			 
		return false;
		}
		});	

							$( "#physician-filter" ).autocomplete({
			 source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","Consultant","first_name",'null',"no",'no',"admin" => false,"plugin"=>false)); ?>" ,
			 minLength: 1,
			 select: function( event, ui ) {
				 $('#physician_id').val(ui.item.id); 
			 },
			 messages: {
			        noResults: '',
			        results: function() {}
			 }
		});  

		$( "#speciality-filter" ).autocomplete({
			 source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","Department","name",'null',"no",'no','is_active=1','name',"admin" => false,"plugin"=>false)); ?>" ,
			 minLength: 1,
			 select: function( event, ui ) {
				 $('#speciality_id').val(ui.item.id); 
			 },
			 messages: {
			        noResults: '',
			        results: function() {}
			 }
		});  
	});
</script>