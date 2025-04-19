 <div class="inner_title">
<h3> &nbsp; <?php echo __('Manage Patient Centric Department - Add', true); ?></h3>
	<span style="margin-top:-25px;">

	</span>

</div>
<?php
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td colspan="2" align="left" class="error">
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
		jQuery("#departmentfrm").validationEngine();
	});

</script>

<form name="departmentfrm" id="departmentfrm" action="<?php echo $this->Html->url(array("action" => "add", "admin" => true)); ?>" method="post" >
	<table class="table_format" cellpadding="0" cellspacing="0" width="60%"  align="center">
			<tr>
			<td class="form_lables" align="center">
			<?php echo __('Department Name'); ?><font color="red">*</font>
			</td>
			<td>
		        <?php
		       	 	echo $this->Form->input('PatientCentricDepartment.name', array('class' => 'validate[required,custom[name]]','id'=>'name','label'=> false, 'div' => false, 'error' => false));
		        ?>
			</td>
			</tr>

	<!-- <tr>
			<td class="form_lables" align="center">
			<?php //echo __('Mapped With'); ?>
			</td>
			<td>
		        <?php

					  //echo $this->Form->input('PatientCentricDepartment.linked_with',array('type'=>'select','options'=>array(''=>'--Select--','Ward'=>'Ward','Opt'=>'OT','Chamber'=>'Chambers'),'label'=> false, 'div' => false,));
		        ?>
			</td>
			</tr>-->
	<tr>
		<td>
			 &nbsp;
		</td>
		<td>
			<?php
						echo $this->Html->link(__('Cancel', true), array('action' => 'index'), array('class' => 'grayBtn','escape' => false));

						echo "&nbsp;&nbsp;".$this->Form->submit('Submit',array('class'=>'blueBtn','div'=>false));
		    ?>

		</td>
	</tr>
	</table>
</form>