<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#ServiceCategory").validationEngine();
	});
	
</script>
<?php 
if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"
	align="center">
	<tr>
		<td colspan="2" align="left"><?php 
		foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }

     ?></td>
	</tr>
</table>
<?php } ?>

<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#tarifflist").validationEngine();
	});
	
</script>
<div class="inner_title">
	<h3>
		<?php echo __('Add Service Group'); ?>
	</h3>
</div>
<?php echo $this->Form->create('ServiceCategory',array('type' => 'file','id'=>'ServiceCategory','inputDefaults' => array(
		'label' => false,
		'div' => false,
		'error' => false,
		'legend'=>false,
		'fieldset'=>false
)
));
?>
<table class="table_format" border="0" cellpadding="0" cellspacing="0" width="60%" align="center">
	<tr>
		<td align="right"><?php echo __('Name'); ?><font color="red">*</font> </td>
		<td><?php echo $this->Form->input('ServiceCategory.name', array('class' => 'validate[required,custom[mandatory-enter-only]]', 'id' => 'name', 'label'=> false, 'div' => false,
				 'error' => false,'onkeyup'=>'removeSpacesLeft(this.id);','onBlur'=>'removeSpacesRight(this.id);'));?></td>
	</tr>
	<tr>
		<td align="right"><?php echo __('Alias'); ?><font color="red">*</font></td>
		<td><?php echo $this->Form->input('ServiceCategory.alias', array('class' => 'validate[required,custom[mandatory-enter-only]]', 'id' => 'alias', 'label'=> false, 
				'div' => false, 'error' => false,'onkeyup'=>'removeSpacesLeft(this.id);','onBlur'=>'removeSpacesRight(this.id);'));?></td>
	</tr>
	<tr>
		<td align="right"><?php echo __('Service Type'); ?></td>
		<td><?php echo $this->Form->input('ServiceCategory.service_type', array('id' => 'service_type', 'label'=> false, 'div' => false,'style'=>'width:140px;',
			 'error' => false,'options'=>array(''=>'Please Select','Both'=>'Both','IPD'=>'IPD','OPD'=>'OPD	')));?>
		</td>
	</tr>

	<tr>
		<td align="right"><?php echo __('Is Active'); ?></td>
		<td><?php echo $this->Form->input('ServiceCategory.is_view', array( 'id' => 'is_view', 'label'=> false, 'div' => false, 'error' => false,'class' => ''));?></td>
	</tr>
	
	<tr>
		<td align="right"><?php echo __('Is Enable For Nursing'); ?> </td>
		<td><?php echo $this->Form->input('ServiceCategory.is_enable_for_nursing', array('type' => 'checkbox', 'id' => 'is_enable_for_nursing', 'label'=> false,
				 'div' => false, 'error' => false));?>
		</td>
	</tr>

	<tr>
		<td></td>
		<td><?php	echo $this->Html->link(__('Cancel'),array('action' => 'service_category_list'),array('escape' => false,'class'=>'grayBtn'));							 
				echo "&nbsp;&nbsp;".$this->Form->submit('Submit',array('class'=>'blueBtn','div'=>false));?>
		</td>
	</tr>
</table>
<?php echo $this->Form->end();?>
<script>
$(document).ready(function(){
	$("#is_enable_for_nursing").click(function(){
		if($(this).is(":checked")){
			var serviceType=$('#service_type').val();
			res = serviceType.toLowerCase();
			if(res==''){
				alert("Select service type first.");
				$(this).attr('checked',false);
			}else if(res=='opd'){
				alert("Nursing is not for OPD, select another service type.");
				$(this).attr('checked',false);
			}
		}
	});


	/*$("#is_view").click(function(){
		if($(this).is(":checked")){
			if($('#service_type').val()==''){
				alert("Select service type first.");
				$(this).attr('checked',false);
			} 
		}
	});*/
});
</script>
