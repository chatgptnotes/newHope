<style>
.camp {
	width: 55%;
	background: #ffffd0 !important;
	padding: 10px;
	margin-top: 10px;
	border: solid 1px #DFDB2C;
}

.camp td {
	background: none !important;
}

.headTr {
	background: #dfdb2c;
}
</style>
<?php if($camp){ 
	$campData=$camp['0']['CampDetail'];
}else{
		$campData=$parent['0']['CampDetail'];
}?>
<div class="inner_title">
	<h3>Camp Participant Details</h3>
	<span><?php echo $this->Html->link('Generate Excel',array('action'=>'add_camp_participant',$campData['id'],'?'=>'excel=excel'),
			array('id'=>'print','class'=>'blueBtn','escape'=>false));
	echo $this->Html->link('Back',array('action'=>'add_camp_participant',$campData['id']),array('escape'=>false,'class'=>'blueBtn'));?>
	</span>
</div>

<table>
	<tr>
		<th>Name Of Camp :</th>
		<th><?php echo ucwords(strtolower($campData['camp_name']));?></th>
	</tr>
	<tr>
		<th>Camp Date :</th>
		<th><?php echo $this->DateFormat->formatDate2Local($campData['camp_date'],Configure::read('date_format'),false)?>
		</th>
	</tr>
</table>
<table class="camp" cellspacing="0" id="addPatient">
	<tr class="headTr">
		<th>Sr no</th>
		<th>Name of visitor/participants</th>
		<th>Doctor</th>
		<th>Age(in years)</th>
		<th>Sex</th>
		<th>Mobile No</th>
		<th>Address</th>
		<th>Remark</th>
		<th>Ask To Admit</th>
		<th>Investigations</th>		
	</tr>
	<?php if($camp){ 
		$j=1; //debug($camp);exit;
		foreach($camp as $partData){?>
			<tr id="<?php echo "row_$j";?>">
				<td><?php echo "$j."?></td>
				<td><?php echo ucwords(strtolower($partData['CampParticipantsDetail']['name']));?></td>
				<td><?php echo ucwords(strtolower($partData['User']['first_name'].' '.$partData['User']['last_name']));
						?></td>
				<td><?php echo $partData['CampParticipantsDetail']['age'];?></td>
				<td><?php echo ucwords(strtolower($partData['CampParticipantsDetail']['sex']));?></td>
				<td><?php echo $partData['CampParticipantsDetail']['mobile_no'];?></td>
				<td><?php echo ucfirst(strtolower($partData['CampParticipantsDetail']['address']));?></td>
				<td><?php echo ucfirst(strtolower($partData['CampParticipantsDetail']['remark']));?></td>
				<td><?php if($partData['CampParticipantsDetail']['admit_chk']==1){
							echo 'Yes';
						  }else{
							echo 'No';
						   }?></td>
			    <td><?php $pos = strrpos($partData['CampParticipantsDetail']['invt'], ",");
			    if($pos==0)
			   	 echo substr($partData['CampParticipantsDetail']['invt'],1);
			    else echo $partData['CampParticipantsDetail']['invt'];?></td>
			</tr>
	<?php	$j++;	
		}
	 }else{ echo '<tr><td colspan=7>No Participants added</td></tr>';}?>
</table>
