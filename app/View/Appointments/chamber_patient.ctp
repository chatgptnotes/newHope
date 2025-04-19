<div style="float: left; display:none;">
	<table border="0" cellpadding="0" cellspacing="2" width="100%"
		style="text-align: center;">
		<tr>
			<th colspan="">Patient Name</th>
			<th>Schedule Time</th>
			<th>Status</th>
			<th>Token Number</th>
		</tr>
		<?php $currentToken = true;?>
		<?php foreach($data as $key=>$newData){
			if($key%2==0){
							$color='#D2EBF2';//#D2EBF2
						}else{
							$color='white';//white
						}
			$status = ($newData['status'] == 'Ready') ? 'Next In Line' : $newData['status'];
						?>
		<tr bgcolor="<?php echo $color ?>">
			<td height="50"><?php echo $newData['patientName'];?></td>
			<td height="50"><?php echo $newData['start_time'];?></td>
			<td height="50"><?php echo $status;?></td> 
			<td height="50"><?php echo $newData['token_no']; ?></td>
		</tr>
		<?php if($currentToken && $newData['status'] != "Seen"){?>
		<?php $currentTokenNo = $newData['token_no']; ?>
		<?php $currentPatient = $newData['patientName'];?>
		<?php $nextToken = $data[$key+1]['token_no'];?>
		<?php $nextPatient = $data[$key+1]['patientName'];?>
		<?php $currentToken = false;?>
		<?php }?>
		<?php }?>
		<?php if(empty($data)){?>
		<tr bgcolor="#D2EBF2">
			<td colspan="4" height="50"><?php echo "No Appointment Schedule."?></td>
		</tr>
		<?php }?>
	</table>
</div>
<div style="width: 100%; height: 85%; float: right;">
	<table border="0" cellpadding="0" cellspacing="2" width="100%"
		style="text-align: center;">
		<tr>
			<th colspan="2" width="50%" style="font-size: 25px;">In-Progress</th>
		</tr>
		<tr bgcolor="#D2EBF2">
			<td height="300" colspan=""
				style="color: green;"><span style="font-size: 200px;"><?php echo $currentTokenNo;?><br/>
			</span> <span style="font-size: 40px;"><?php echo $currentPatient;?>
			</span></td>
		</tr>
		<tr>
			<th colspan="" width="50%" style="font-size: 25px;">Next</th>
		</tr>
		<tr bgcolor="#D2EBF2">
			<td height="300" colspan="" style="color: red;"><span style="font-size: 200px;"><?php echo $nextToken;?><br/>
			</span> <span style="font-size: 40px;"><?php echo $nextPatient;?>
			</span></td>
		</tr>
	</table>
</div>


