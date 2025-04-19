<style type="text/css">
iframe {
  border-top: #ccc 1px solid;
  border-right: #ccc 1px solid;
  border-left: #ccc 1px solid;
  border-bottom: #ccc 1px solid;
} 
</style>
<div class="inner_title">
<h3><?php echo __('Biometric Identification', true); ?></h3>
</div>


<form name="fingerprint" id="fingerprint" action="<?php echo $this->Html->url(array("controller" => "Persons", "action" => "finger_print")); ?>" method="post" >
	<table border="0"  cellpadding="0" cellspacing="0" width="90%"  align="center">
	<tr><td>&nbsp;</td></tr>
		<tr>
		
			<td valign="bottom" align="left" width="40%">
			
			
			<applet CODEBASE="<?php echo Configure::read('appletUrl')?>/files/FDxSDKProforJavav1.3rev386"
  code     = "applet.JSGDApplet.class"
  name     = "JSGDApplet"
  archive  = "AppletDemo.jar,mysql-connector-java-5.1.6-bin.jar"
  width    = "550"
  height   = "550"
  hspace   = "0"
  vspace   = "0"
  align    = "middle">

<PARAM name="codebase_lookup" value="false">
<PARAM name="created_by" value="<?php echo  $this->Session->read("userid")?>">
</applet>
			</td>
			<td valign="top" width="50%"><table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm" id="container-table">
 <thead>
		<tr>
			<th width="5%" valign="top" align="left" style="text-align:left;">Sr.No.</th>
			<th width="15%" valign="top" style="text-align:left;">User Name</th>
			<th width="20%" valign="top" align="left" style="text-align:left;">Date</th>
			<th width="20%" valign="top" align="left" style="text-align:left;">Intime</th>
			<th width="20%" valign="top" align="left" style="text-align:left;">Outtime</th>
			<th width="20%" valign="top" align="left" style="text-align:left;">Mispunch?</th>
			<th width="20%" valign="top" align="left" style="text-align:left;">Manual Punch?</th>
			<th width="20%" valign="top" align="left" style="text-align:left;">Reason for Manual/missed Punch</th>
			<th width="20%" valign="top" align="left" style="text-align:left;">Location</th>		
		</tr>
	</thead>
	<?php 
	if(!empty($getLocName)){
		
foreach($getLocName as $keyLoc=>$getLocNames){	
	if(empty($getAttendanceArr[$keyLoc]))
		continue;
	?>
	
	<?php 
	if(!empty($getAttendanceArr[$keyLoc])){?>
	
	<?php 	
	$i=0;
	$getCount=count($getAttendanceArr[$keyLoc]);
	foreach($getAttendanceArr[$keyLoc] as $key2=>$dutyRosterData){		
		$i++; 
		
		?>
		
	<tr>    	
		<td align="left" style="text-align:left;" valign="top"><?php echo $i; ?></td>
		<td align="left" style="text-align:left;" valign="top"><?php echo ucfirst($dutyRosterData['User']['first_name']." ".$dutyRosterData['User']['last_name']);?></td>
		<td align="left" style="text-align:left;" valign="top"><?php echo $form_received_on = $this->DateFormat->formatDate2Local($dutyRosterData['DutyRoster']['date'],Configure::read('date_format')); //date of Inout time.	?></td>
		<td align="left" style="text-align:left;" valign="top"><?php 		
		echo $dutyRosterData['DutyRoster']['intime']; ?></td>		
		<td align="left" style="text-align:left;" valign="top"><?php echo $dutyRosterData['DutyRoster']['outime'];?></td>
		<td align="left" style="text-align:left;" valign="top"><?php if($dutyRosterData['DutyRoster']['missed_punch']=='0')
			echo 'N';
		else if($dutyRosterData['DutyRoster']['missed_punch']=='1')
			echo 'Y'; ?></td>
		<td align="left" style="text-align:left;" valign="top"><?php if($dutyRosterData['DutyRoster']['is_edited']=='0')
			echo 'N';
		else if($dutyRosterData['DutyRoster']['is_edited']=='1')
			echo 'Y'; ?></td>
		<td align="left" style="text-align:left;" valign="top"><?php echo $dutyRosterData['DutyRoster']['remark']; ?></td>
		<td align="left" style="text-align:left;" valign="top"><?php echo $dutyRosterData['Location']['name']; ?></td>
				
	</tr>
	<?php }
	}
	?>
<tr>	
	<td align="left" colspan="2" style="font-weight:bold;">Total  <?php echo $getLocNames;?>  Records <?php echo $getCount;
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
   <TD colspan="6" align="center" style='background:#E5F4FC;color:Red !important;font-weight:bold;'><?php echo __('No record found', true); ?>.</TD>
  </tr> 
<?php }?>
</table></td>
		</tr>

		<tr>
	<td colspan="2" align="center" style="padding-top: 10px;padding-left: 12%">
	
	
	</td>
	
	</tr>
	
	</table>
</form>