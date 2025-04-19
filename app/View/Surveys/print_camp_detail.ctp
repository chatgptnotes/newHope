
<?php
$camp=$camp['0']['CampDetail'];?>
<table class="camp" cellspacing=0 cellpadding=1>
	<tr class="headTr">
		<th colspan="4">Camp Details Particulars</th>
	</tr>
	<tr>
		<td><b>Camp Name:</b></td>
		<td>
			<?php echo ucwords(strtolower($camp['camp_name']));?>
														
		</td>
		<td><b>Camp Date:</b></td>
		<td>
			<?php echo $this->DateFormat->formatDate2Local($camp['camp_date'],Configure::read('date_format'));?>
															
		</td>
	</tr>
	<tr>
		<td>Nature of Camp:</td>
		<td>
			<?php echo ucwords(strtolower($camp['camp_nature']));?>
		</td>
		<td>Camp Venue:</td>
		<td>
			<?php echo ucwords(strtolower($camp['camp_venue']));?>
		</td>
	</tr>
	<tr>
		<td>Camp days:</td>
		<td>
			<?php echo $camp['camp_days'];?>
															
		</td>
			
	</tr>
	
	<tr>
		<td colspan="4">
			<table width="100%" cellspacing="0">
				<tr class="headTr">
					<th>Name of Doctors</th><th>Name of Nursing Staffs</th>
				</tr>
				<tr>
					<td><?php echo $this->Form->input('doctors_name',array('name'=>'doctors_name','label'=>false,'div'=>false,
																		'type'=>'textarea','rows'=>'5','cols'=>'25','value'=>$camp['doctors_name']))?></td>
					<td><?php echo $this->Form->input('nursing_staff_name',array('name'=>'nursing_staff_name','label'=>false,'div'=>false,
																		'type'=>'textarea','rows'=>'5','cols'=>'25','value'=>$camp['nursing_staff_name']))?></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="4">
			<table width="100%" cellspacing="0">
				<tr class="headTr" >
					<th>Pharmacy Staff</th><th>Pathalogy Staff</th>
				</tr>
				<tr>
					<td><?php echo $this->Form->input('pharmacy_staff',array('name'=>'pharmacy_staff','label'=>false,'div'=>false,
																		'type'=>'textarea','rows'=>'5','cols'=>'25','value'=>$camp['pharmacy_staff']))?></td>
					<td><?php echo $this->Form->input('pathalogy_staff',array('name'=>'pathalogy_staff','label'=>false,'div'=>false,
																		'type'=>'textarea','rows'=>'5','cols'=>'25','value'=>$camp['pathalogy_staff']))?></td>
				</tr>
			</table>
		</td>		
	</tr>
	<tr>
		<td colspan="4">
			<table width="100%" cellspacing="0">
				<tr class="headTr">
					<th>Other Staff</th><th>Organizers</th>
				</tr>
				<tr>
					<td><?php echo $this->Form->input('other_staff',array('name'=>'other_staff','label'=>false,'div'=>false,
																		'type'=>'textarea','rows'=>'5','cols'=>'25','value'=>$camp['other_staff']))?></td>
					<td><?php echo $this->Form->input('organizers_name',array('name'=>'organizers_name','label'=>false,'div'=>false,
																		'type'=>'textarea','rows'=>'5','cols'=>'25','value'=>$camp['organizers_name']))?></td>
				</tr>
			</table>
		</td>		
	</tr>
	<tr>
		<td colspan="4">
			<table width="100%" cellspacing="0">
				<tr class="headTr">
					<th>Drivers Name</th><th>Vehicle Name/No</th>
				</tr>
				<tr>
					<td><?php echo $this->Form->input('driver_name',array('name'=>'driver_name','label'=>false,'div'=>false,
																		'type'=>'textarea','rows'=>'5','cols'=>'25','value'=>$camp['driver_name']))?></td>
				    <td><?php echo $this->Form->input('vehicle_name_no',array('name'=>'vehicle_name_no','label'=>false,'div'=>false,
																		'type'=>'textarea','rows'=>'5','cols'=>'25','value'=>$camp['vehicle_name_no']))?></td>
				</tr>
			</table>
		</td>		
	</tr>
	<tr>
		<td colspan="2">
			<?php $compile=unserialize($camp['compilation']);?>
			<table width="100%" cellspacing="0" id="compile">
				<tr class="headTr">
					<th colspan="1">Compilation</th>
				</tr>
				<tr>
					<td><b>Label</b></td>
					
					<td><b>Value</b></td>
					
				</tr>
					<?php if($compile){ $j=1;
							foreach($compile['label'] as $cKey=>$comData){?>
									<tr id="<?php echo "row_$j"?>">
										<td><?php echo ucwords(strtolower($comData));?>
										</td>
									    <td><?php echo ucwords(strtolower($compile['value'][$cKey]));?></td>
									</tr>
					<?php 		
							}
							$i=$j;
						 	}?>
		</table>
		</td>		
	</tr>
</table>
<script>
window.onload=function(){self.print();} 
</script>
