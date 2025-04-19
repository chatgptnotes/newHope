
 <div class="inner_title">
 <?php echo $this->element('duty_roster_menu');?>
	<h3>&nbsp; <?php echo __('Shift Master', true); 
	?></h3>
		
	<span><?php  echo $this->Html->link('Back',array("controller"=>"TimeSlots","action"=>"index"),array('escape'=>false,'class'=>'blueBtn')); ?></span>
</div>
<?php for ($i = 0; $i <= 23; $i++) {
						for($min = 0; $min <= 59 ; $min+=30){
							$hour = $i >= 10 ? $i : "0" . $i;
							$minute = $min >= 10 ? $min : "0" . $min;
							$time = $hour.":".$minute;
							$timeSlot[$time] = $time;
						}
					}?>
<?php 
echo $this->Form->create('Configuration',array('type'=>'post','id'=>'AddShiftForm','inputDefaults' => array('label'=>false,'div' =>false,'error' =>false,'legend'=>false,'fieldset'=>false)));?>
<?php echo $this->Form->hidden('id',array('value'=>$oldShiftData['Configuration']['id'])); ?>
<table width="60%" border="0"
	cellspacing="0" cellpadding="0" class="table_format" align="center">
    	<tr id="shifts">
			<td align="right" ><font color="red">*</font>No of shifts</td>
			<td colspan="2"><?php echo $this->Form->input('Configuration.value.no_of_shifts',array('type'=>'text','id'=>'no_shifts','value'=>$oldShiftData['Configuration']['value']['no_of_shifts'], 
					'class'=>" validate[required,custom[mandatory-enter]]",'style'=>'width:150px'));?>
			</td>
	    </tr> 
	    <?php   
	    foreach ($oldShiftData['Configuration']['value']['ShiftName'] as $key=>$values){ 
	    ?>
	    <tr id="repeat" class="newRow">
		    	<td align="right"><?php echo $this->Form->input("Configuration.value.ShiftName.$key",array('type'=>'text','id'=>'shiftName',
		    			 'class'=>" validate[required,custom[mandatory-enter]]",'value'=>$values,'style'=>'width:150px',
		    			'placeholder'=>'Shift Name'));?></td>
		    	<td><?php echo $this->Form->input("Configuration.value.ShiftsTime.$key.start",array('empty'=>__('Start Time'),'options'=>$timeSlot,
		    			'value'=>$oldShiftData['Configuration']['value']['ShiftsTime'][$key]['start'],'id' => 'start_time','class' => 'validate[required,custom[mandatory-select]] textBoxExpnd',
		    			'autocomplete'=>'off','style'=>'width:18%','multiple'=>false))."&nbsp;";
		    		?>
		    		<?php
		    			echo $this->Form->input("Configuration.value.ShiftsTime.$key.end",array('empty'=>__('End Time'),'options'=>$timeSlot,
							'value'=>$oldShiftData['Configuration']['value']['ShiftsTime'][$key]['end'],'id' => 'end_time','class' => 'validate[required,custom[mandatory-select]] textBoxExpnd',
							'autocomplete'=>'off','style'=>'width:18%','multiple'=>false));
		    		?>
		    	</td>
		   
	    </tr>
	    <?php  
		} ?>
	    <tr id="">
			<td align="right"><font color="red">*</font>No of Recurring Days</td>
			<td ><?php echo $this->Form->input('Configuration.value.recurring_days',array('type'=>'text','id'=>'recurrence','value'=>$oldShiftData['Configuration']['value']['recurring_days'],
					'class'=>" validate[required,custom[mandatory-enter]] textBoxExpnd",'style'=>'width:150px'));?>
			</td>
	    </tr>
	    <tr><td height="10%">&nbsp;</td></tr>
	    <tr><td></td>
	        <td><?php echo $this->Html->link(__('Cancel'), array('controller'=>'TimeSlots','action' => 'index'), array('escape' => false,'class' => 'grayBtn')); 
	        echo $this->Form->submit(__('Save'), array('id'=>'save','escape' => false,'class' => 'blueBtn','label' => false,'div' => false,'error'=>false));?></td>
	    </tr>
	    
</table>
<?php echo $this->Form->end();?>
<script>
jQuery(document).ready(function(){


	$("#no_shifts").blur(function() {
       
		$(".newRow").each(function () {
			$(".newRow").remove();
			$("#recurrence").val('');
		});  

		
	   var value = jQuery(this).val();
	   var repeatDiv = jQuery("#repeat");
	   var getrecurring_days=$("#recurring_days").val();
	   for(var i = 0; i < value; i++) {
		   $("#shifts")
			.after($('<tr>').attr({'class':'newRow'})
				.append($('<td>').attr({'align':'right'}).append($('<input>').attr({'id':'test'+i,'placeholder':'Shift Name','class':'validate[required,custom[mandatory-enter]]','type':'text','name':'data[Configuration][value][ShiftName]['+i+']'})))
				.append($('<td>').append($('<select>').attr({'id':'text'+i,'name':'data[Configuration][value][ShiftsTime]['+i+'][start]','autocomplete':'off'}).css({'width':'18%'}))
						         .append($('<select>').attr({'id':'text1'+i,'name':'data[Configuration][value][ShiftsTime]['+i+'][end]','autocomplete':'off'}).css({'width':'18%'})))
				//.append($('<td>'))
	    		);
		   counter = i;
		   getDD();
	   }
	});
$("#save").click(function(){
	return jQuery("#AddShiftForm").validationEngine('validate');
	});
});			


var selectDaysBetween = $.parseJSON('<?php echo json_encode($timeSlot);?>');

var counter = 0;
function getDD(){
	 	$.each(selectDaysBetween, function(key, value) {
	 	 	$('#text'+counter).append(new Option(value , value) );
	 	 	$('#text1'+counter).append(new Option(value , value) );
		});
}

</script>