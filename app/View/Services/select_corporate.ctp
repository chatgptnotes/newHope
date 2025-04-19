<div class="inner_title">
  <h3><?php echo __('Add Service') ?></h3>
 </div>
<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="650"  align="center">
	<tr>
	<td colspan="2" align="center">
	<br>
	</td>
	</tr>
	<tr>
		<td width="250" class="form_lables" valign="middle">
		<?php echo __('Corporate Company'); ?> 
		<?php echo $this->Form->create('Service',array('type' => 'file','id'=>'corporatefrm','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false,
																								        'legend'=>false,
																								        'fieldset'=>false
																								    )
			));
			?>
		</td>
		<td> 
	       <?php echo $this->Form->input('Service.corporate_id', array('div' => false,'label' => false,'empty'=>__('Please select'),'options'=>$corporates,'class' => 'validate[required,custom[mandatory-select]] textBox','id' => 'corporate_id')); ?>
	        
		</td>
		<td colspan="1" align="left">
   <input class="blueBtn" type="submit" value="Show">
   <?php echo $this->Form->end(); ?>
   </td>
	</tr>
	</table>