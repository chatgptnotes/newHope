<style>
.textBoxExpnd{
	width: 25%;
}
</style>
<div class="inner_title">
 <?php echo $this->element('duty_roster_menu');?>
	<h3>
		&nbsp;
		<?php echo __($title_for_layout, true); ?>
	</h3>
</div>
<?php
echo $this->Form->create('DutyRoster',array('type' => 'post','id'=>'dutyRosterFrm','url'=>array("controller" => "TimeSlots", "action" => "addDutyRoster"),
		'inputDefaults' => array('label' => false,'div' => false)));

         echo $this->Form->input('id', array('type' => 'hidden'));
    ?>
    <table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%"  align="left" >
	    	<tr>
				<td  class="form_lables" width="40%" align="right" valign="top"><?php echo __('Role'); ?><font color="red">*</font></td>
				<td >
					<?php	echo $this->Form->input('role_id',array('options'=>$roles,'empty'=>__('Please Select'),
							'class'=>'validate[required,custom[mandatory-select]] textBoxExpnd','id'=>'roleId','type'=>'select','autocomplete'=>'off')); ?>
				</td>
		    </tr>
		    <tr>
				<td class="form_lables" align="right" valign="top"><?php echo __('Name'); ?><font color="red">*</font></td>
				<td>
					<?php	echo $this->Form->input('user_id',array('empty'=>__('Please Select'),
							'class'=>'validate[required,custom[mandatory-select]] textBoxExpnd','id'=>'userId','type'=>'select')); ?>
				</td>
		    </tr>
		    <tr>
				<td class="form_lables" align="right" valign="top"><?php echo __('Duty Month'); ?><font color="red">*</font></td>
				<td>
					<?php 
					echo $this->Form->input('duty_month',array('class'=>'validate[required,custom[mandatory-select]] textBoxExpnd','id'=>'dutyMonth','type'=>'select',
						'empty'=>'Please Select','autocomplete'=>'off')); ?>
				</td>
		    </tr>
			<tr>
		    	<td class="form_lables" align="right" valign="top"><?php echo __('Room'); ?><font color="red">*</font></td>
		    	<td><?php
		    			echo $this->Form->input('ward_id', array('empty'=>__('Please Select'),'options'=>$wards,
		    			'id' => 'ward_id','class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','autocomplete'=>'off'));
		    		?>
		    	</td>
		    </tr>
			   <tr>
		    	<td class="form_lables" align="right" valign="top"><?php echo __('Is Recurring'); ?></td>
		    	<td>
		    	<?php echo $this->Form->checkBox('is_recurring',array('id'=>'isRecurring'));?><font color="red">(By selecting this the shift will change after a fixed period of time)</font></td>

		    </tr>
		    <tr>
			<td colspan="2" align="right">
			<?php echo $this->Form->hidden('first_shift',array('id'=>'firstShift'));?>
			<?php echo $this->Form->hidden('allow_day_off',array('id'=>'allowDayOff'));?>
			<?php echo $this->Form->submit (__( 'Save' ),array('id' => 'save','escape' => false,'class' => 'blueBtn','label' => false,'div' => false,'error' => false)); ?>
		   </td>
			</tr>
	</table>
	<?php echo $this->Form->end();?>
<script>
var monthArray = [ "January" , "February" , "March" , "April" , "May" , "June" , "July" , "August" , "September" , "October" , "November" , "December" ];
var parameterArray = [];
$(document).ready(function () {
	jQuery("#dutyRosterFrm").validationEngine();	
	
	$('#roleId').change(function (){
		$.ajax({
				  url: "<?php echo $this->Html->url(array("controller" => 'TimeSlots', "action" => "getUsersByRole", "admin" => false)); ?>"+"/"+$(this).val(),
				  context: document.body,
				  beforeSend:function(){
				    // this is where we append a loading image
				    $('#busy-indicator').show('fast');
				  },
				  success: function(data){
						$('#busy-indicator').hide('slow');
						if(data != ''){
							$('#userId').empty();
						  	userData= $.parseJSON(data);
						  	$('#userId').append( "<option value=''>Please Select</option>" );
						  	$.each(userData, function(val, text) {
							    $('#userId').append(new Option( text , val) );
							})
						}
				  }
		});
	});

	$('#userId').change(function () {
		$.ajax({
			  url: "<?php echo $this->Html->url(array("controller" => 'TimeSlots', "action" => "getDutyMonthForUser", "admin" => false)); ?>",
			  context: document.body,
			  method : 'GET',
			  data : 'user_id='+$(this).val(),
			  beforeSend:function(){
			    // this is where we append a loading image
			    $('#busy-indicator').show('fast');
			  },
			  success: function(data){
					$('#busy-indicator').hide('slow');
					if(data != ''){
						$('#dutyMonth').empty();
					  	userData= $.parseJSON(data);
					  	$('#dutyMonth').append( "<option value=''>Please Select</option>" );
					  	parameterArray = new Array();
					  	$.each(userData, function(index,val) {
							var firstDate = userData[index].DutyPlan.first_duty_date;
						  	var month = new Date(firstDate);
							var month = month.getMonth();
							parameterArray[firstDate] = {
									firstShift : userData[index].DutyPlan.first_shift, 
									allowDayOff : userData[index].DutyPlan.allow_day_off,
								}
							$('#dutyMonth').append(new Option( monthArray[month] , firstDate ) );
						})
					}
			  }
	});
	});
	$('#dutyMonth').change(function () {
		if($(this).val() != ''){
			$('#firstShift').val(parameterArray[$(this).val()].firstShift);
			$('#allowDayOff').val(parameterArray[$(this).val()].allowDayOff);
		}else{
			$('#firstShift').val('');
			$('#allowDayOff').val('');
		}
	});
	
	
});
;
</script>