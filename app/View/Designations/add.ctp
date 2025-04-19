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
 
<script>
$(document).ready(function(){

	jQuery("#designationfrm").validationEngine({
		//alert("hi");
		validateNonVisibleFields: true,
		updatePromptsPosition:true,
		});
	$('#submit')
	.click(
			function() { 
				//alert("hello");
				var validatePerson = jQuery("#designationfrm").validationEngine('validate');
				//alert(validatePerson);
			/*	if (validatePerson) {$(this).css('display', 'none');}*/
			
			});
});
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	//jQuery("#designationfrm").validationEngine();
	});
	
</script>
<div class="inner_title">
<h3>&nbsp; <?php echo __('Add Designation', true); ?></h3>

</div>
<form name="designationfrm" id="designationfrm" action="<?php echo $this->Html->url(array("controller" => "designations", "action" => "add")); ?>" method="post" >
	<table class="table_format" border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
	<tr>
	<td>
	<?php echo __('Name'); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Designation.name', array('class' => 'validate[required,custom[name]]', 'id' => 'designationname', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
	<tr>
	<td colspan="2" align="left" style="padding-left:125px;">
		<?php				    			 
					echo $this->Html->link(__('Cancel'),
						 					array('action' => 'index'),array('escape' => false,'class'=>'grayBtn'));							 
					echo "&nbsp;&nbsp;".$this->Form->submit('Submit',array('class'=>'blueBtn','div'=>false,'id'=>'submit'));			
	    ?>	
		
	</td>
	</tr>
	</table>
</form>