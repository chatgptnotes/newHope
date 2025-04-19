<?php if($camp){ 
	$campData=$camp['0']['CampDetail'];
}else{
	$campData=$parent['0']['CampDetail'];
	  }?>

<table style="border:solid 1px black" cellspacing='0'>
	<tr>
		<td colspan="2" align="left"><b>Name Of Camp :</b><?php echo ucwords(strtolower($campData['camp_name']));?></td>
	    <td colspan="5"><b>Camp Date : </b>
		<?php echo $this->DateFormat->formatDate2Local($campData['camp_date'],Configure::read('date_format'),false)?></td>
	</tr>
	<tr>
		<td colspan="2" align="left"  style="border-bottom: solid 1px black"><b>Camp Venue :</b><?php echo ucwords(strtolower($campData['camp_venue']));?></td>
	    <td colspan="5"  style="border-bottom: solid 1px black"><b>Nature Of Camp: </b>
		<?php echo ucwords(strtolower($campData['camp_nature']));?></td>
	</tr>
	<tr class="headTr">	
		<th width="2%" align="left">Sr no</th>
		<th width="10%" align="left">Name of visitor/participants</th>
		<th width="5%" align="center">Age(in years)</th>
		<th width="5%" align="center">Sex</th>
		<th width="5%" align="left">Mobile No</th>
		<th width="5%" align="left">Address</th>
		<th width="5%" align="left">Remark</th>		
	</tr>
	<?php if($camp){ 
		$j=1;
				foreach($camp as $partData){ ?>
	<tr id="<?php echo "row_$j";?>">
		<td align="center"><?php echo "$j."?></td>
		<td><?php echo ucwords(strtolower($partData['CampParticipantsDetail']['name']));?>
		</td>
		<td align="center"><?php echo $partData['CampParticipantsDetail']['age'];?>
		</td>
		<td align="center"><?php echo $partData['CampParticipantsDetail']['sex'];?>
		</td>
		<td><?php echo $partData['CampParticipantsDetail']['mobile_no']?>
		</td>
		<td><?php echo $partData['CampParticipantsDetail']['address']?>
		</td>
		<td><?php echo $partData['CampParticipantsDetail']['remark']?>
		</td>		
	</tr>
	<?php	$j++;	
}
	}?>
</table>
