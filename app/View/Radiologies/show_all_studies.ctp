<div class="inner_title">
	<h3> &nbsp; <?php echo __('Launch Dicom Viewer', true); ?></h3> 
</div>
<table cellpadding="1" cellspacing="1" style="background-color:#4179E0" width="100%">
	<tr>
		<td colspan="5">&nbsp;</td>
	</tr>
	<tr>
		<td style="color: #fff"><b>Patient Name : </font></b><?php echo $patientData['Patient']['lookup_name'];?></td>
		<td style="color: #fff"><b>Admission ID : </b><?php echo $patientData['Patient']['admission_id'];?></td>
		<td style="color: #fff"><b>Gender : </b><?php echo ucfirst($patientData['Patient']['sex']);?></td>
		<td style="color: #fff"><b>Age : </b><?php echo $patientData['Patient']['age'];?></td>
		<td style="color: #fff"><b>Date of Birth : </b><?php echo date('d/m/Y',strtotime($patientData['Person']['dob']));?></td>
	</tr>
</table>
<table cellpadding="1" cellspacing="1" width="100%">
	<tr>
		<td><b>History : </font></b><?php echo ucfirst($patientData['Note']['subject']);?></td>
	</tr>
</table>
<br>
<table cellpadding="1" cellspacing="1" width="100%" height="20%">
	<tr>
		<td colspan="5" style="text-align: center;"><b>Study list of <?php echo $patientData['Patient']['lookup_name'];?></b></td>
	</tr>
	<tr>  
		<td width="30%"><b>Study</font></b></td>
		
		<td width="30%"><b>Study Date:</b></td>
		<td width="30%"><b>Study Time:</b></td>
		<td width="30%"><b>Description:</b></td>
	</tr>

	<?php
	
	

	foreach($studyAll as $data){
	
	
	$studydate=explode(" ",$data['study_datetime']);
	
	if($_SERVER['HTTP_HOST']=='192.168.1.5:5454')
	{
	   $viewerurl="http://192.168.1.6:8080";
	}
	else
	{
	    $viewerurl="http://117.247.90.119:8080";
	}
	?>
	<tr>
		<td width="30%">
		<?php $otherName=$patientData['Patient']['lookup_name']."_".$patientData['Patient']['age']."_".$data['uuid'];?>
			<a  href="<?php echo $viewerurl?>/weasis-pacs-connector/viewer-applet?studyUID=<?php echo $data['study_iuid']?>" title="Dicom Viewer" onclick="var w = window.open(href, 'webviewPage', 'scrollbars=yes,location=no,menuBar=no,resizable=yes,status=no,toolbar=no'); if(w.blur) w.focus(); return false;" target="_blank"><?php echo "Access ".$data['mods_in_study']?></a>
		</td>
		
		<td width="30%"><?php  echo date('d/m/Y',strtotime($studydate[0]))?></td>
		<td width="30%"><?php echo $studydate[1];?></td>
		<td width="30%"><?php echo $data['study_desc'];?></td>
		

	</tr>
	<?php }?>
</table>
