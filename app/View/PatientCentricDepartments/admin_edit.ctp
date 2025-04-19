<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#departmentfrm").validationEngine();
	});

</script>
<div class="inner_title">
	<h3>&nbsp; <?php echo __('Manage Patient Centric Department - Edit', true); ?></h3>
</div>
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
<form name="departmentfrm" id="departmentfrm" action="<?php echo $this->Html->url(array("action" => "edit", "admin" => true)); ?>" method="post" >
	<table class="table_format"  border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
		 <?php
 		        echo $this->Form->input('PatientCentricDepartment.id', array('class' => 'validate[required,custom[name]]', 'id' => 'name', 'label'=> false, 'div' => false, 'error' => false));
		        ?>
		<tr>
			<td class="form_lables" class="form_lables" align="center">
			<?php echo __('Department Name'); ?><font color="red">*</font>
			</td>
			<td>
		        <?php
 		        echo $this->Form->input('PatientCentricDepartment.name', array('class' => 'validate[required,custom[name]]', 'id' => 'name', 'label'=> false, 'div' => false, 'error' => false));
		        ?>
			</td>
		</tr>
		<!--  <tr>
			<td class="form_lables" align="center">
			<?php //echo __('Mapped With'); ?>
			</td>
			<td>
		        <?php

					  //echo $this->Form->input('PatientCentricDepartment.linked_with',array('type'=>'select','options'=>array(''=>'--Select--','Ward'=>'Ward','Opt'=>'OT','Chambers'=>'Chambers'),'label'=> false, 'div' => false,));
		        ?>
			</td>
			</tr>-->

	<tr>
	<td colspan="2" align="center">
		<?php
					echo $this->Html->link(__('Cancel'),
						 					array('action' => 'index'),array('escape' => false,'class'=>'grayBtn'));
					echo "&nbsp;&nbsp;".$this->Form->submit('Submit',array('class'=>'blueBtn','div'=>false));
	    ?>

	</td>
	</tr>
	</table>
</form>