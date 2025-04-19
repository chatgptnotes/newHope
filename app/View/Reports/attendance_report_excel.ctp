<?php 
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"ATTENDANCE_REPORT".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls" );
header ("Content-Description: Generated Expiry Report" );
ob_clean();
flush();
?>
<table width="100%" cellpadding="0" cellspacing="1" border="1">
			<tr>
				<td colspan = "7" align="center" height="400px"><h2><strong>ATTENDANCE REPORT</strong></h2></td>
				<td align="left" colspan ="2" ><strong>PRINT DATE & TIME : <?php echo $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true);?></strong></td>
			
			</tr>
			<?php if(!empty($this->params->query['location_id'])){?>
			<tr>
				<td colspan = "9" align="center" height="400px"><strong>LOCATION NAME:<?php 
				foreach($this->params->query['location_id'] as $locIds){
					$locNameArr[$locations[$locIds]]=strtoupper($locations[$locIds]);					
				}	
				?>
				<?php echo implode(",",$locNameArr);?></strong></td>			
			</tr>
			<?php }?>
			
		
			<tr>
				<td colspan = "9" align="center"><strong><?php 
			if(!empty($from)){
			echo "CREATED FROM: ";?>
			
			<?php echo $this->DateFormat->formatDate2Local($from,Configure::read('date_format'), false);
			} ?></strong> 
			<?php if(!empty($to)){?>
			TO <strong><?php echo $this->DateFormat->formatDate2Local($to,Configure::read('date_format'), false);
			}?></strong></td>		
			</tr>
 </table>
<table width="100%" cellpadding="0" cellspacing="1" border="1" id="container-table"> 
	<thead>
		<tr>
			<th width="5%" valign="top" align="left" style="text-align:left;">SR.NO.</th>
			<th width="15%" valign="top"  align="left" style="text-align:left;">USER NAME</th>
			<th width="15%" valign="top" align="left" style="text-align:left;">DATE</th>
			<th width="15%" valign="top" align="left" style="text-align:left;">INTIME</th>
			<th width="10%" valign="top" align="left" style="text-align:left;">OUTTIME</th>
			<th width="15%" valign="top" align="left" style="text-align:left;">LOCATION</th>
			<th width="10%" valign="top" align="left" style="text-align:left;">CREATED BY</th>	
			<th width="10%" valign="top" align="left" style="text-align:left;">MISPUNCH</th>	
			<th width="10%" valign="top" align="left" style="text-align:left;">REMARK</th>		
		</tr>
	</thead>
	<?php 
	if(!empty($getLocName)){
		
foreach($getLocName as $keyLoc=>$getLocNames){	
	if(empty($getAttendanceArr[$keyLoc]))
		continue;
	?>
	<tr>	
	<td colspan="2" style="font-weight:bold;"><?php echo strtoupper($getLocNames);?></td>	
	<td  style="font-weight:bold;"></td>
	<td  style="font-weight:bold;"></td>
	<td  style="font-weight:bold;"></td>
	<td  style="font-weight:bold;"></td>
	<td  style="font-weight:bold;"></td>	
	<td  style="font-weight:bold;"></td>	
	<td  style="font-weight:bold;"></td>	
	</tr>
	<?php 
	if(!empty($getAttendanceArr[$keyLoc])){?>
	
	<?php 	
	$i=0;
	$getCount=count($getAttendanceArr[$keyLoc]);
	foreach($getAttendanceArr[$keyLoc] as $key2=>$dutyRosterData){		
		$i++; ?>		
	<tr>    	
		<td align="left" style="text-align:left;" valign="top"><?php echo $i; ?></td>
		<td align="left" style="text-align:left;" valign="top"><?php echo strtoupper($dutyRosterData['User']['first_name']." ".$dutyRosterData['User']['last_name']);?></td>
		<td align="left" style="text-align:left;" valign="top"><?php echo $form_received_on = $this->DateFormat->formatDate2Local($dutyRosterData['DutyRoster']['date'],Configure::read('date_format')); //date of Inout time.	?></td>
		<td align="left" style="text-align:left;" valign="top"><?php 		
		echo $dutyRosterData['DutyRoster']['intime']; ?></td>		
		<td align="left" style="text-align:left;" valign="top"><?php echo $dutyRosterData['DutyRoster']['outime'];?></td>
		<td align="left" style="text-align:left;" valign="top"><?php echo strtoupper($dutyRosterData['Location']['name']); ?></td>		
		<td align="left" style="text-align:left;" valign="top"><?php echo strtoupper($dutyRosterData['UserAlias']['first_name']." ".$dutyRosterData['UserAlias']['last_name']); ?></td>	
		<td align="left" style="text-align:left;" valign="top"><?php
		if($dutyRosterData['DutyRoster']['missed_punch']=='0')
			echo 'N';
		else if($dutyRosterData['DutyRoster']['missed_punch']=='1')
			echo 'Y';?>
		</td>
		<td align="left" style="text-align:left;" valign="top"><?php echo strtoupper($dutyRosterData['DutyRoster']['remark']); ?></td>	
	</tr>
	<?php }
	}
	?>
<tr>	
	<td align="left" colspan="2" style="font-weight:bold;">TOTAL  <?php echo strtoupper($getLocNames);?>  RECORDS <?php echo $getCount;
		$getGrndCnt=$getGrndCnt+$getCount;?>   </td>	
	<td  style="color:RED !important;font-weight:bold;" align="left"></td>
	<td  style="color:RED !important;font-weight:bold;" align="left"></td>
	<td  style="color:RED !important;font-weight:bold;" align="left"></td>
	<td  style="color:RED !important;font-weight:bold;" align="left"></td>		
	<td  style="color:RED !important;font-weight:bold;" align="left"></td>		
	<td  style="color:RED !important;font-weight:bold;" align="left"></td>	
	<td  style="color:RED !important;font-weight:bold;" align="left"></td>	
</tr>
<?php 
}?>

<?php  }else{  ?>
  <tr>
   <TD colspan="9" align="center" style='background:#E5F4FC;color:Red !important;font-weight:bold;'><?php echo __('NO RECORD FOUND', true); ?>.</TD>
  </tr> 
<?php }?>
</table>
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="tabularForm" style="margin:0px 0px 0px 0px;">
<tr>		
	<td  align="left" colspan="2" style="color:RED !important;font-weight:bold;">TOTAL SUMMARY RECORDS <?php echo $getGrndCnt;?></td>		
	<td  style="color:RED !important;font-weight:bold;" align="left"></td>
	<td  style="color:RED !important;font-weight:bold;" align="left"></td>
	<td  style="color:RED !important;font-weight:bold;" align="left"></td>
	<td  style="color:RED !important;font-weight:bold;" align="left"></td>	
	<td  style="color:RED !important;font-weight:bold;" align="left"></td>	
	<td  style="color:RED !important;font-weight:bold;" align="left"></td>	
	<td  style="color:RED !important;font-weight:bold;" align="left"></td>	
</tr>
</table>