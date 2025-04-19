<?php 
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td colspan="2" align="left"><div class="alert">
   <?php 
     foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
     
   ?></div>
  </td>
 </tr>
</table>
<?php } ?>
 
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#instrumentfrm").validationEngine();
	});
	
</script>
<div class="inner_title">
<h3>&nbsp; <?php echo __('Add Instrument', true); ?></h3>

</div>
<form name="instrumentfrm" id="instrumentfrm" action="<?php echo $this->Html->url(array("controller" => "instruments", "action" => "edit")); ?>" method="post" >
        <?php echo $this->Form->input('DeviceMaster.id', array( 'id' => 'instrumentid', 'label'=> false, 'div' => false, 'error' => false)); ?>
	<table class="table_format"  border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
	<tr>
	<td class="form_lables">
	<?php echo __('Name'); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
           echo $this->Form->input('DeviceMaster.device_name', array('class' => 'validate[required,custom[name]]', 'id' => 'instrumentname', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
	<tr>
	<tr>
	<td class="form_lables">
	<?php echo __('Code'); ?>
	</td>
	<td>
        <?php 
           echo $this->Form->input('DeviceMaster.code_value', array( 'id' => 'instrumentname', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
	<tr>
	<td colspan="2" align="left" style="padding-left:125px;">
	<?php
		echo $this->Html->link(__('Cancel'),array('action' => 'index'),array('escape' => false,'class'=>'grayBtn'));
	?>
	<input type="submit" value="Submit" class="blueBtn">
	</td>
	</tr>
	</table>
</form>