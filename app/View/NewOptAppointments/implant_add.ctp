<?php 
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="100%"  align="center">
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
 <div class="inner_title">
<h3>&nbsp; <?php echo __('Add Surgical Implant', true); ?></h3>
<span>
<?php
 echo $this->Html->link(__('Back', true),array('controller' => 'NewOptAppointments', 'action' => 'implantIndex', 'admin' => false), array('escape' => false,'class'=>'blueBtn'));
?>
</span>
</div>
<script>
$(document).ready(function(){

	jQuery("#SurgicalImplantfrm").validationEngine({
		//alert("hi");
		validateNonVisibleFields: true,
		updatePromptsPosition:true,
		});
	$('#submit')
	.click(
			function() { 
				//alert("hello");
				var validatePerson = jQuery("#SurgicalImplantfrm").validationEngine('validate');
				//alert(validatePerson);
			/*	if (validatePerson) {$(this).css('display', 'none');}*/
			
			});
});
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	//jQuery("#Surgical Implantfrm").validationEngine();
	});
	
</script>

<form name="ImplantSurgicalfrm" id="ImplantSurgicalfrm" action="<?php echo $this->Html->url(array("controller" => "NewOptAppointments", "action" => "implantAdd")); ?>" method="post" >
	<table class="table_format" border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
	<tr>
	<td>
	<?php echo __('Name'); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('SurgicalImplant.name', array('class' => 'validate[required,custom[name]]', 'id' => 'Surgical Implantname', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
	<tr>
	  <td class="form_lables">
	   <?php echo __('Is Active',true); ?>
	  </td>
	  <td>
	   <?php echo $this->Form->checkbox('SurgicalImplant.is_active', array('checked'=>'checked','id' => 'is_active', 'label'=> false, 'div' => false, 'error' => false));
	   ?>
	  </td>
	 </tr>
	<tr>
	<td colspan="2" align="left" style="padding-left:125px;">
		<?php				    			 
					echo $this->Html->link(__('Cancel'),
						 					array('action' => 'implantIndex'),array('escape' => false,'class'=>'grayBtn'));							 
					echo "&nbsp;&nbsp;".$this->Form->submit('Submit',array('class'=>'blueBtn','div'=>false,'id'=>'submit'));			
	    ?>	
		
	</td>
	</tr>
	</table>
</form>