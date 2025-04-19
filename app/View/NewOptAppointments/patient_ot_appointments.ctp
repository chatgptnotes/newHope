			<h3 style="border-bottom: solid 4px #20B2AA">OT Appointments</h3>
			<!--  <h4><u>OT Appointment Details</u></h4>-->
			<?php if($otAppt){?>
			<div class="visitDetails">
				<table class="infoDiv" cellpadding="0" cellspacing="0">
					<tr>
						<td><b>Surgery Name<b></td>
						<td><b>Surgery Date (Start Time-End Time)</b></td>
						<td><b>Surgeon</b></td>
						<td><b>Status</b></td>
					</tr>
					<?php foreach($otAppt as $details){?>
					<tr>
						<td><?php echo $details['Surgery']['name']?></td>
						<td><?php echo $this->DateFormat->formatDate2Local($details['OptAppointment']['schedule_date'],Configure::read('date_format'),false).' ('.$details['OptAppointment']['start_time'].'-'.$details['OptAppointment']['end_time'].')';?>
						</td>
						<td><?php echo $details['User']['first_name'].' '.$details['User']['last_name'];?>
						</td>
						<td><?php if($details['OptAppointment']['procedure_complete']=='0'){
									echo 'Scheduled';
								}else{
									echo 'Completed';
								}?></td>
					</tr>

					<?php 
					 }?>
				</table>				
			</div>
			<?php }?>
			<div style="padding-left: 10px; float: left">
				<?php //echo $this->Html->link('Go To OT Schedulling',array('controller'=>'NewOptAppointments',),array('escape'=>false,'class'=>'blueBtn'));?>
			</div>
<script>
</script>

