<div class="inner_title">
<h3><?php echo __('Add Incident Type', true); ?></h3>
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
	jQuery("#Complaintfrm").validationEngine();
	});
	
</script>

<?php 
	      		echo $this->Form->create('IncidentType', array('url'=>array('controller'=>'incidents','action'=>'add'),'id'=>'Complaintfrm','inputDefaults' => array(
															        'label' => false,'div' => false,'error'=>false,'legend'=>false))) ;
?>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="60%"  align="center">
	<tr>
		<td colspan="2" align="center">
		<br>
		</td>
	</tr>
	<tr>
		<td class="form_lables">
		<?php echo __('Incident Type'); ?><font color="red">*</font>
		</td>
		<td >
	        <?php  
			 	 echo $this->Form->input('name', array('type'=>'text','class' => 'textBoxExpnd validate[required,custom[mandatory-enter]]','id' => 'name'));
			 	 
			 	 echo $this->Form->input('id', array('type'=>'hidden'));
			?>
		</td>
	</tr> 
	<tr>
		<td class="form_lables">
		<?php echo __('Description'); ?>
		</td>
		<td >
	        <?php echo $this->Form->textarea('description', array('class' => 'textBoxExpnd','id' => 'description','row'=>'10')); ?>
		</td>
	</tr>
	<tr>
	<td colspan="2" align="center">
	<?php echo $this->Html->link(__('Cancel', true),array('action' => 'index'), array('escape' => false,'class'=>'grayBtn'));?>
	&nbsp;&nbsp;<input type="submit" value="Submit" class="blueBtn">
	</td>
	</tr>
	</table>
<?php echo $this->Form->end();?>

