<div class="inner_title">
<h3>&nbsp; ATTENDANCE REPORT</h3>
<span><?php
   echo $this->Html->link(__('Back to Report'), array('controller'=>'Reports','action' => 'all_report','admin'=>true), array('escape' => false,'class'=>'blueBtn'));
 
?></span>
</div>
<div><?php echo $this->element('report_filter'); ?></div>
<div class="clr">&nbsp;</div>
 <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm" id="container-table">
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
<table width="99%" cellpadding="0" cellspacing="0" border="0" class="tabularForm" style="margin:0px 0px 0px 0px;">
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