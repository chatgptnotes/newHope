<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#orderCategoryfrm").validationEngine();
	});
	
</script>
<div class="inner_title">
<h3><?php echo __('Edit Order Category', true); ?></h3>
<span><?php echo $this->Html->link(__('Back', true),array('controller' => 'OrderCategories', 'action' => 'index','admin'=>true), array('escape' => false,'class'=>'blueBtn'));?>
</span>
</div>
<?php 
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td  align="left" class="error">
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
 
<?php  echo $this->Form->create('OrderCategory',array('type' => 'file','id'=>'orderCategoryfrm','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false,
																								        'legend'=>false,
																								        'fieldset'=>false
																								    )
			));
echo $this->Form->hidden('OrderCategory.id', array('id'=>'id'));
		 ?>
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="padding-top: 10px;padding-bottom: 10px;" align="center">
<tr>
<td>
	<table border="0" cellpadding="0" cellspacing="0" width="50%" class="formFull" style="padding-top: 10px;" align="center">
	<tr>
	<td class="form_lables" align="right">
	<?php echo __('Order Category Name'); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('OrderCategory.order_description', array('class' => 'validate[required,custom[onlyLetterSp]]', 'id' => 'order_description', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));
        ?>
	</td>
	</tr>
	<tr>
	<td class="form_lables" align="right">
	<?php echo __('Status'); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('OrderCategory.status', array('class' => 'validate[required,custom[mandatory-select]', 'id' => 'status', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));
        ?>
	</td>
	</tr>
	
	<tr>
	<td colspan="2" align="center">

	</td>
	</tr>
	</table>
	</td>
	</tr>
	</table>
	<div style="text-align:center;">	<?php
                                		 
                                		echo $this->Form->submit(__('Save'), array('id'=>'save','escape' => false,'class' => 'blueBtn','label' => false,'div' => false,'error'=>false));
                                		
                                		echo $this->Html->link(__('Cancel'), array('action' => 'index','admin'=>true), array('escape' => false,'class' => 'grayBtn'));
                                	?></div>
<?php echo $this->Form->end(); ?>

