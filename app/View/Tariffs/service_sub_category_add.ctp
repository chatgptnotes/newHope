<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#ServiceSubCategory").validationEngine();
	});
	
</script>
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
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#tarifflist").validationEngine();
	});
	
</script>
<div class="inner_title">
	<h3><?php echo __('Add Service Sub Group'); ?></h3>
</div>
<?php echo $this->Form->create('ServiceSubCategory',array('type' => 'file','id'=>'ServiceSubCategory','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false,
																								        'legend'=>false,
																								        'fieldset'=>false
																								    )
			));
			?>
	<table class="table_format" border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
	 
	<tr>
	<td align="right">
	<?php echo __('Name'); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('ServiceSubCategory.name', array('class' => 'validate[required,custom[mandatory-enter-only]]', 'id' => 'name', 'label'=> false, 'div' => false, 'error' => false,'onkeyup'=>'removeSpacesLeft(this.id);','onBlur'=>'removeSpacesRight(this.id);'));
        ?>
	</td>
	</tr>
	
	
	 
	<tr>
		<td align="right">
	<?php echo __('Group'); ?><font color="red">*</font>
	</td>
	<td >
	<?php echo $this->Form->input('ServiceSubCategory.service_category_id', array('style'=>'width:160px','empty'=>'Please Select','options'=>$service_group_category,'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'service_category')); ?>
	</td >
	</tr>
		<tr>
	<td align="right">
	<?php echo __('Is Active'); ?>
	</td>
	<td>
        <?php 
        echo $this->Form->input('ServiceSubCategory.is_view', array( 'id' => 'is_view', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
	<tr>
	<td align="right">
	<?php echo __('Unit'); ?>
	</td>
	<td>
        <?php 
          echo $this->Form->input('ServiceSubCategory.unit', array('type' => 'radio','class' => '','label' => false,'legend' => false ,'options' => array('0'=>'APAM', '1' => 'KCHRC'), 'default' => 0));
        ?>
	</td>
	</tr>
	<tr>
	<td >
	</td >
	<td >
	
		<?php				    			 
					echo $this->Html->link(__('Cancel'),
						 					array('action' => 'service_sub_category_list'),array('escape' => false,'class'=>'grayBtn'));							 
					echo "&nbsp;&nbsp;".$this->Form->submit('Submit',array('class'=>'blueBtn','div'=>false));			
	    ?>	
		
	</td>
	</tr>
	</table>
<?php echo $this->Form->end();?>
