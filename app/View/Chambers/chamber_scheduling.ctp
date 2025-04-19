<style>
#doctor_id{
  border-radius: 25px;
  height: 22px;
  text-align: left;
  width: 10% !important;
}
</style>
<div class="inner_title">
<h3><?php echo __('Examination Room', true); ?></h3>
 <!-- <span>
 	<?php
 		//echo $this->Html->link(__('Allocate Examination Room', true),array('controller' => 'chambers', 'action' => 'index'), 
 		//array('escape' => false,'class'=>'blueBtn'));
 	 ?>
 </span> -->
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
 
<?php echo $this->Form->create('Chamber',array('controller'=>'Chamber','action'=>'index','type'=>'get','id'=>'Chamberfrm','admin'=>true));?>

	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%"  align="center"> 
	<tr>
		<td class=" " width="50%">
			<?php echo __('Select Doctor'); ?> 
		 
	        <?php 
	        	echo $this->Form->input('Chamber.doctor_id', array('empty'=>__('Please select'),'class' => 'validate[required,custom[mandatory-select]]' , 
	        	'label'=> false, 'div' => false, 'error' => false,'id'=>'doctor_id'));
	        ?>
		</td>
	 <!-- 
		<td class=" " width="50%">
			<?php //echo __('Select Examination Room'); ?> 
		 
	        <?php 
	        	//echo $this->Form->input('Chamber.chamber_id', array('empty'=>__('Please select'),'class' => 'validate[required,custom[mandatory-select]]',
	        	// 'label'=> false, 'div' => false, 'error' => false,'id'=>'chamber_id','style'=>'width:50%;')  );
	        ?>
		</td>
	</tr>  -->
	<!--<tr>
	<td colspan="2" align="center">
	<?php echo $this->Html->link(__('Cancel', true),array('action' => 'index'), array('escape' => false,'class'=>'grayBtn'));?>
	&nbsp;&nbsp;<input type="submit" value="Submit" class="blueBtn">
	</td>
	</tr>
	--></table>
<?php echo $this->Form->end();?>
<script>
	jQuery(document).ready(function(){
		$("#doctor_id,#chamber_id").change(function(){
			//if($(this).val() != ''){
				$('#Chamberfrm').submit();
			//}
		}); 
	});
	
</script>