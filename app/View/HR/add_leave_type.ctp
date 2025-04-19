
<?php 
echo $this->Html->script('jquery.fancybox-1.3.4');
echo $this->Html->css('jquery.fancybox-1.3.4.css');
?>


<div class="inner_title">
	<h3>
		<?php echo __('Add Leave Type', true); ?>
	</h3>
	<span> <?php
	echo $this->Html->link(__('Back'), array('controller'=>'HR','action'=>'leave_master'), array('escape' => false,'class'=>'blueBtn back'));

	?>
	</span>
</div>

<div class="clr ht5" style="height: 25px"></div>
<?php  echo $this->Form->create('',array('type' => 'file','id'=>'LeaveTypeForm','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false,
																								        'legend'=>false,
																								        'fieldset'=>false
																								    )
			));?>

<table width="100%" border="0"
	cellspacing="0" cellpadding="0" class="table_format" align="center">

		<tr>
			<td align="right"><font color="red">*</font>Leave Type</td>
			<td ><?php echo $this->Form->input('LeaveType.name',
					array('type'=>'text','id'=>'name', 'class'=>" validate[required,custom[mandatory-enter]]",'tabindex'=>1,'div'=>false,'label'=>false,'style'=>'width:150px'));?>
			</td>
	    </tr>
        
        <tr>
	        <td align="right">Maximum Leave </td>
			<td><?php echo $this->Form->input('LeaveType.maximum_leave',
					array('type'=>'text','class'=>" validate[required]",'id'=>'sctName','tabindex'=>4,'div'=>false,'label'=>false,'style'=>'width:150px'));?>
	        </td>
        </tr>
        
        <tr>
	        <td align="right">Is active </td>
			<td><?php echo $this->Form->input('LeaveType.is_active', array('type' => 'checkbox','tabindex'=>5,'class' => '','label' => false,'legend' => false ,'checked'=>'checked' ));?></td>
	    </tr>
	    <tr>
	        <td></td>
			<td><?php echo $this->Html->link(__('Cancel'), array('controller'=>'HR','action' => 'leave_master'), array('escape' => false,'class' => 'grayBtn'));?>
			    <?php echo $this->Form->submit(__('Save'), array('id'=>'save','escape' => false,'class' => 'blueBtn','label' => false,'div' => false,'error'=>false));?>
                                	</td>
	    </tr>
	
</table>

<!-- <div style="text-align:center;padding-top: 10px">	<?php
                                		 
                                		echo $this->Form->submit(__('Save'), array('id'=>'save','escape' => false,'class' => 'blueBtn','label' => false,'div' => false,'error'=>false));
                                		
                                		echo $this->Html->link(__('Cancel'), array('controller'=>'HR','action' => 'leave_master'), array('escape' => false,'class' => 'grayBtn'));
                                	?></div> -->
<?php echo $this->Form->end();?>

<script>






$(document).ready(function(){
	$("#save").click(function(){
		var valid=jQuery("#LeaveTypeForm").validationEngine('validate');
		if(valid){
			return true;
		}else{
			return false;
		}
		});
});


/*End OF Code*/

</script>
