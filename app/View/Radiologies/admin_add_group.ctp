<div class="inner_title">
			<h3><?php echo __('Add Radiology Sub Specialty', true); ?></h3>
			<span>
	<?php
 		echo $this->Html->link(__('Back', true),array( 'action' => 'view_groups'), array('escape' => false,'class'=>'blueBtn'));
  	?>
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
		<?php 
			   
				echo $this->Form->create('TestGroup',array('url'=>array('controller'=>'radiologies','action'=>'add_group'),'id'=>'testgroupfrm', 'inputDefaults' => array('label' => false,'div' => false)));
				echo $this->Form->hidden('TestGroup.id');
			?>	
				<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="500px" >
					 
						 <tr>
						  <td><?php echo __('Sub Specialty Name');?>:<font color='red'>*</font></td>
						  <td>						  		
						     		<?php echo $this->Form->input('name', array('type'=>'text','class' => 'validate[required,custom[mandatory-enter]]','id' => 'customdescription')); ?>
						  </td>
						 			 
						  <td class="row_format" align="right" colspan="2">
						   <?php
								echo $this->Form->submit(__('Submit'), array('label'=> false,'div' => false,'error' => false,'class'=>'blueBtn' ));
						   ?>
						  </td>
						 </tr>	
				</table>	
		 <?php echo $this->Form->end();    ?>	
		 
		 <script> 	 jQuery("#testgroupfrm").validationEngine();						 
						 
			 
</script>