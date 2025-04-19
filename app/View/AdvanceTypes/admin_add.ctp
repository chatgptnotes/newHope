<div class="inner_title">
<h3><?php echo __('Add Adavance Type', true); ?></h3>
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
 
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#typefrm").validationEngine();
	});
	
</script>
<?php echo $this->Form->create('AdvanceType',array('id'=>'typefrm','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false,
																								        'legend'=>false,
																								        'fieldset'=>false
																								    )));
																								    ?>
 	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="60%"  align="center">
	<tr>
	<td colspan="2" align="center">
	<br>
	</td>
	</tr>
		 <tr>
			<td class="form_lables">
			<?php echo __('Type'); ?><font color="red">*</font>
			</td>
			<td >
		        <?php 
		         echo $this->Form->hidden('id');
				 echo $this->Form->input('type', array('class' => 'validate[required,custom[mandatory-enter]]', 'id' => 'type', 'label'=> false, 'div' => false, 'error' => false));
				
		        ?>
			</td>
		 </tr>
		 <tr>
			<td class="form_lables">
			<?php echo __('Standard Amount'); ?><font color="red">*</font>
			</td>
			<td >
		        <?php 
		       
				 echo $this->Form->input('standard_amount', array('type'=>'text','class' => 'validate[required,custom[mandatory-enter]]', 'id' => 'standard_amount', 'label'=> false, 'div' => false, 'error' => false,'style'=>'text-align:right'));
				
		        ?>
			</td>
		</tr>
		<tr>
			<td class="form_lables">
			<?php echo __('Active'); ?>
			</td>
			<td >
		        <?php 
		       
				 echo $this->Form->input('is_active', array( 'options'=>array('Active'=>'Active','InActive'=>'InActive'),'id' => 'is_active', 'label'=> false, 'div' => false, 'error' => false)) ;
				
		        ?>
			</td>
		</tr>		 
	<tr>
	<td colspan="2" align="center">
	<?php echo $this->Html->link(__('Cancel'),array('action' => 'index'), array('escape' => false,'class'=>'grayBtn')); ?>
	&nbsp;&nbsp;<input type="submit" value="Submit" class="blueBtn">
	</td>
	</tr>
	</table>
</form> 