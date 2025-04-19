<table border="0"    cellpadding="0" cellspacing="2" width="100%" style="text-align:center;">
	<tr>
		<th colspan="">Patient Name</th>
		<th>Schedule Time</th>
		<th>Time Remaining</th>
		<th>Token Number</th>
	</tr>
	<?php foreach($data as $key=>$newData){
	if($key%2==0){
$color='#D2EBF2';//#D2EBF2
}else{
$color='white';//white
}
		?>
	<tr bgcolor="<?php echo $color ?>">
	<td  height="50"><?php echo $newData['patientName'];?></td>
	<td  height="50"><?php echo $newData['start_time'];?></td>
	<td  height="50"><?php echo $newData['remain_time'];?></td>
	<td  height="50"><?php echo $key+1+10;?></td>
	</tr> 
	<?php }?>
		<?php if(empty($data)){?>
	<tr bgcolor="#D2EBF2">
	<td colspan="4"  height="50"><?php echo "No Appointment Schedule."?></td>
	</tr>
	<?php }?>
</table>