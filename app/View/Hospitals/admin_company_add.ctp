<?php 
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td colspan="2" align="left">
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

	jQuery("#CompanyAdminCompanyAddForm").validationEngine({
		//alert("hi");
		validateNonVisibleFields: true,
		updatePromptsPosition:true,
		});
	$('#submit')
	.click(
			function() { 
				//alert("hello");
				var validatePerson = jQuery("#CompanyAdminCompanyAddForm").validationEngine('validate');
				//alert(validatePerson);
			/*	if (validatePerson) {$(this).css('display', 'none');}*/
			
			});
});
	/*jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#companyfrm").validationEngine();
	});*/
	
</script>
<div class="inner_title">
	<h3><?php echo __('Add company'); ?></h3>
</div>

<?php echo $this->Form->create('Company');?>

<table class="table_format" border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
	 
	<tr>
	<td>
	<?php echo __('Name'); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->hidden('id'); 
        echo $this->Form->input('name', array('class' => 'validate[required,custom[mandatory-enter]]', 'id' => 'companyname', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
	 
	 
	<tr>
	<td colspan="2" align="center">
		<?php				    			 
					echo $this->Html->link(__('Cancel'),
						 					array('action' => 'index'),array('escape' => false,'class'=>'grayBtn'));							 
					echo "&nbsp;&nbsp;".$this->Form->submit('Submit',array('id'=>'submit','class'=>'blueBtn','div'=>false));			
	    ?>	
		
	</td>
	</tr>
	</table>
</form>