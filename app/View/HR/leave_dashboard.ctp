 <?php echo $this->Html->script(array('jquery.blockUI','colResizable-1.4.min'));?>
 <?php echo $this->Html->css(array('colResizable'));?>
<div class="inner_title" style="padding: 2px 8px 4px">
	<h3>
		<?php echo __('Leave Dashboard', true); ?>
	</h3>

</div>
<div class="clr " height="15px">&nbsp;</div>

<?php echo $this->Form->create('LaboratoryTestOrder',array('type'=>"GET",'action'=>'lab_dashboard','default'=>false,'id'=>'HeaderForm','div'=>false,'label'=>false));?>
<table width="100%" cellpadding="0" cellspacing="0" border="0"
	class="formFull" align="center" style="padding: 5px; margin-top: 5px">
	<tr>
		<td width="1%">From:</td>
		<td width="5%"><?php echo $this->Form->input('from', array('id' => 'from_date', 'style'=>'width:110px', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'class'=>'textBoxExpnd enterBtn','readonly'=>'readonly', 'div' => false,'type'=>'text'));?>
		</td>
		<td width="1%">To:</td>
		<td width="5%"><?php echo $this->Form->input('to', array('id' => 'to_date', 'style'=>'width:110px', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'class'=>'textBoxExpnd enterBtn','readonly'=>'readonly', 'div' => false,'type'=>'text'));?>
		</td>
		<td  width="2%">Department:</td> <?php $status = array('Pending'=>'PENDING','SampleTaken'=>'SAMPLE TAKEN',/* 'Completed'=>'COMPLETED', */'PrintTaken'=>'PRINT TAKEN','Provisional'=>'PROVISIONAL','Authenticated'=>'AUTHENTICATED','Recieved'=>'RECEIVED');?>
		<td  width="5%"><?php echo $this->Form->input('status',array('class'=>'textBoxExpnd enterBtn','type'=>'select','options'=>array('empty'=>'Please Select',$status),'div'=>false,'label'=>false));?></td>
		
		
		<td  width="2%">Leave Status:</td> <?php $status = array('Pending'=>'PENDING','SampleTaken'=>'SAMPLE TAKEN',/* 'Completed'=>'COMPLETED', */'PrintTaken'=>'PRINT TAKEN','Provisional'=>'PROVISIONAL','Authenticated'=>'AUTHENTICATED','Recieved'=>'RECEIVED');?>
		<td  width="5%"><?php echo $this->Form->input('status',array('class'=>'textBoxExpnd enterBtn','type'=>'select','options'=>array('empty'=>'Please Select',$status),'div'=>false,'label'=>false));?></td>
		
		<td width="7%">
			<table>
				<tr>
					<td>
						<?php echo $this->Html->image('icons/views_icon.png',array('id'=>'Submit','type'=>'submit','title'=>'Search'));?>			
					</td>
					<td>
						<?php echo $this->Html->image('icons/eraser.png',array('id'=>'resett','title'=>'Reset'));?>	
					</td>
					<!--  <td>
						<?php echo $this->Html->image('icons/print.png',array('id'=>'','title'=>'Print'));?>			
					</td>-->
					<td>
						<?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'index'),array('escape'=>false,'title'=>'Reload current page'));?>			
					</td>
				</tr>
			</table>
		</td>
	</tr>
	</table>

	<table width="100%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm  labTable <!-- resizable sticky-->" id=""
	style="height: 390px; /* overflow: scroll; */">


	<tr class="light fixed">
		<th align="center" valign="top"
			style="text-align: center; padding-left: 5px; padding-right: 5px; width: 10%">Sr.No.</th>
		<th align="center" valign="top"
			style="text-align: center; padding-left: 5px; padding-right: 5px; width: 15%">Employee Name</th>
		<th align="center" valign="top"
			style="text-align: center; padding-left: 5px; padding-right: 5px; width: 15%">Leave Type</th>
	 	<th align="center" valign="top"
			style="text-align: center; padding-left: 5px; padding-right: 5px; width: 15%">From</th>
		<th align="center" valign="top"
			style="text-align: center; padding-left: 5px; padding-right: 5px; width: 15%">To</th>
		<th align="center" valign="top"
			style="text-align: center; padding-left: 5px; padding-right: 5px; width: 15%">Days/Hours</th>
		<th align="center" valign="top"
			style="text-align: center; padding-left: 5px; padding-right: 5px; width: 15%">Status</th>
	</tr>
	
	<tr>
	   <td></td>
	   <td></td>
	   <td></td>
	   <td></td>
	   <td></td>
	   <td></td>
	   <td></td>
	</tr>
</table>
	
	
	<script>	
$(document).ready(function(){
						
		$("#to_date").val($.datepicker.formatDate("dd-mm-yy", new Date()));	
	$("#from_date").datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		changeTime:true,
		showTime: true,
		yearRange: '1950',
		dateFormat:'<?php echo $this->General->GeneralDate();?>'
	});

	$("#to_date").datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		changeTime:true,
		showTime: true,
		yearRange: '1950',
		dateFormat:'<?php echo $this->General->GeneralDate();?>'
	});

	$("#Submit").click(function(){ 
		$.ajax({
			url: '<?php echo $this->Html->url(array('controller'=>'HR','action'=>'leave_dashboard_list'));?>',
			data:$('#HeaderForm').serialize(),
			beforeSend:function(data){
				$('#busy-indicator').show();
			},
			success:function(data){
				$("#records").html(data).fadeIn('slow');
				$('#busy-indicator').hide();
			}
		});
	});

});
	</script>