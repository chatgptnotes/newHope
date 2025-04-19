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
	jQuery("#tariffstandard").validationEngine();
	});
	
</script>
<div class="inner_title">
	<h3>
		<?php echo __('Add Tariff Standard'); ?>
	</h3>
</div>
<?php echo $this->Form->create('Tariff',array('type' => 'file','id'=>'tariffstandard','inputDefaults' => array(
		'label' => false,
		'div' => false,
		'error' => false,
		'legend'=>false,
		'fieldset'=>false
)
));
?>
<table class="table_format" border="0" cellpadding="0" cellspacing="0"
	width="60%" align="center">

	<tr>
		<td><?php echo __('Name'); ?><font color="red">*</font>
		</td>
		<td><?php 
		echo $this->Form->input('TariffStandard.name', array('class' => 'validate[required,custom[mandatory-enter-only]]', 'id' => 'tariffstandard', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>

	<tr>
		<td><?php echo __('Code Name'); ?>
		</td>
		<td><?php 
		echo $this->Form->input('TariffStandard.code_name', array('class' => '', 'id' => 'code_name', 'label'=> false, 'div' => false, 'error' => false));
		?><i>(For configuration purpose only)</i>
		</td>
	</tr>

	<tr>
		<td><?php echo __('Tariff Standard Type'); ?>
		</td>
		<td><?php 
		$option=array('corporate'=>'Corporate','TPA'=>'TPA');
		echo $this->Form->input('TariffStandard.tariff_standard_type', array('type'=>'select','empty'=>'Please Select','options'=>$option,'class' => '', 'id' => 'tariffType', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center"><?php				    			 
		echo $this->Html->link(__('Cancel'),
						 					array('action' => 'viewStandard'),array('escape' => false,'class'=>'grayBtn'));
					echo "&nbsp;&nbsp;".$this->Form->submit('Submit',array('class'=>'blueBtn','div'=>false));
	    ?>
		</td>
	</tr>
</table>
<?php echo $this->Form->end();?>