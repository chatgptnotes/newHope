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
	jQuery("#surgicalImplantFrm").validationEngine();
	});
	
</script>
 <div class="inner_title">
<h3>&nbsp; <?php echo __('Edit Surgical Implant', true); ?></h3>
<span>
<?php
 echo $this->Html->link(__('Back', true),array('controller' => 'NewOptAppointments', 'action' => 'implantIndex', 'admin' => false), array('escape' => false,'class'=>'blueBtn'));
?>
</span>
</div>
<form name="surgicalImplantFrm" id="surgicalImplantFrm" action="<?php echo $this->Html->url(array("controller" => "NewOptAppointments", "action" => "implantEdit")); ?>" method="post" >
        <?php echo $this->Form->hidden('SurgicalImplant.id', array( 'id' => 'SurgicalImplantid', 'label'=> false, 'div' => false, 'error' => false)); ?>
	<table class="table_format"  border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
	<tr>
	<td class="form_lables">
	<?php echo __('Name'); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
           echo $this->Form->input('SurgicalImplant.name', array('class' => 'validate[required,custom[name]]', 'id' => 'name', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
	<tr>
	  <td class="form_lables">
	   <?php echo __('Is Active',true); ?></td>
	  <td>
	   <?php echo $this->Form->checkbox('SurgicalImplant.is_active', array('checked'=>'checked','id' => 'is_active', 'label'=> false, 'div' => false, 'error' => false));
	   ?>
	  </td>
	 </tr>
	<tr>
	<td colspan="2" align="left" style="padding-left:125px;">
	<?php
		echo $this->Html->link(__('Cancel'),array('action' => 'implantIndex'),array('escape' => false,'class'=>'grayBtn'));
	?>
	<input type="submit" value="Submit" class="blueBtn">
	</td>
	</tr>
	</table>
</form>