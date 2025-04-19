<?php
//header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
//header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
//header ("Content-Disposition: attachment; filename=\"TOR_report_".date('d-m-Y').".xls");
header ("Content-Disposition: attachment; filename=\"RGJAY_Tasks_Report_".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls");
header ("Content-Description: RGJAY Report" );
?>

<STYLE type='text/css'>
	.tableTd {
	   	border-width: 0.5pt; 
		border: solid; 
	}
	.tableTdContent{
		border-width: 0.5pt; 
		border: solid;
	}
	#titles{
		font-weight: bolder;
	}
</STYLE>


<table border='1' class='table_format'  cellpadding='0' cellspacing='0' width='60%' style='text-align:left;padding-top:50px;'>
	  <tr class='row_title'> 
		   <td colspan="9" width="100%" height='30px' align='center' valign='middle'><h2><?php echo __('RGJAY Tasks Report'); ?></h2></td>
	  </tr>
	  
	  
	  <!--section 1-->
	  
	  <tr>
	  	<td colspan="9" width="100%" height="30px" align="left" valign="middle"><h3>Section 1 = Executive Tasks <i>(Pre Auth To Be Completed)</i></h3></td>
	  </tr>
	  				  
	  <tr class='row_title'> 
	  	<td height="30px" align="center" valign="center" width="3%" style="text-align:center;"><strong>No.</strong></td>
	  	<td height="30px" align='center' valign='middle' width="7%"><strong>Team</td>
	  	<td height='30px' align='center' valign='middle' width="20%"><strong>Patient Name</strong></td>
		<td height="30px" align='center' valign='middle' width="10%"><strong>District</strong></td>					   
		<td height="30px" align='center' valign='middle' width="10%"><strong>Case No.</strong></td>  
		<td height="30px" align='center' valign='middle' width="10%"><strong>Hospital No.</strong></td>	
		<td height="30px" align='center' valign='middle' width="10%"><strong>Admission Date</strong></td>					   
		<td colspan="2" height="30px" align='center' valign='middle' width="20%"><strong>Claim Status</strong></td>
		
	</tr>
 	  
 	  <tr>
 	  	<td colspan="9" width="100%" height="30px">
 	  		<table class='table_format' border="1" cellpadding='0' cellspacing='0' width='100%'>
 	  			<?php $i = 1;  foreach($result as $results) {	$claim_status = $results['Patient']['claim_status']; ?>
     	 		<?php if($claim_status == "In Patient Case Registered" || $claim_status == "Preauth Updated"  || $claim_status == "Society Pending" || $claim_status == "TPA Pending" || $claim_status =="Preauth Pending"/*|| $claim_status =="Preauth Updated Cancelled"|| $claim_status == "Sent For Preauthorization"    || $claim_status == "Terminated By TPA" || $claim_status == "Terminated By Society"*/  ) { 	?>
     	 	
 	  			<tr>
 	  				<td height="30px" align="center" valign="center" width="3%" style="text-align:center;">
 	  					<?php echo $i++; ?>
 	  				</td>
 	  				<td height='30px' align='center' valign='middle' width="20%">
 	  					<?php echo $results['Patient']['assigned_to'];?>
 	  				</td>
 	  				<td height="30px" align='center' valign='middle' width="10%">
 	  					<?php echo $results['Patient']['lookup_name'];?>
 	  				</td>
 	  				<td height="30px" align='center' valign='middle' width="10%">
 	  					<?php echo $results['Person']['district'];?>
 	  				</td>
 	  				<td height="30px" align='center' valign='middle' width="10%">
 	  					<?php echo $results['Patient']['case_no'];?>
 	  				</td>
 	  				<td height="30px" align='center' valign='middle' width="10%">
 	  					<?php echo $results['Patient']['hospital_no'];?>
 	  				</td>
 	  				<td height="30px" align='center' valign='middle' width="10%">
 	  					<?php echo $this->DateFormat->formatDate2Local($results['Patient']['form_received_on'],Configure::read('date_format'));?>
 	  				</td>
 	  				<td colspan="2" height="30px" align='center' valign='middle' width="20%">
 	  					<?php echo $results['Patient']['claim_status']; ?>
 	  				</td>
 	  			</tr>
 	  			<?php }} ?>
 	  		</table>
 	  	</td>
 	  </tr>
 	  
 	  <!--section 1 ends here-->
 	  
 	  
 	  <!--section 2-->
	  
	  <tr>
	  	<td colspan="9" width="100%" height="30px" align="left" valign="middle"><h3>&nbsp; Section 2 = Team Doctors task <i>(Treatement Sheet ,OT Notes , DischargeTo be Uploaded)</i></h3></td>
	  </tr>
	  				  
	  <tr class='row_title'> 
	  	<td height="30px" align="center" valign="center" width="3%" style="text-align:center;"><strong>No.</strong></td>
	  	<td height="30px" align='center' valign='middle' width="7%"><strong>Team</td>
	  	<td height='30px' align='center' valign='middle' width="20%"><strong>Patient Name</strong></td>
		<td height="30px" align='center' valign='middle' width="10%"><strong>District</strong></td>					   
		<td height="30px" align='center' valign='middle' width="10%"><strong>Case No.</strong></td>  
		<td height="30px" align='center' valign='middle' width="10%"><strong>Hospital No.</strong></td>	
		<td height="30px" align='center' valign='middle' width="10%"><strong>Admission Date</strong></td>					   
		<td colspan="2" height="30px" align='center' valign='middle' width="20%"><strong>Claim Status</strong></td>
		
	</tr>
 	  
 	  <tr>
 	  	<td colspan="9" width="100%" height="30px">
 	  		<table class='table_format' border="1" cellpadding='0' cellspacing='0' width='100%'>
 	  			<?php $i = 1;  foreach($result as $results) {	$claim_status = $results['Patient']['claim_status']; ?>
     	 		<?php if(/*$claim_status == "Treatment Schedule" ||   || $claim_status == "TPA Approved"||*/$claim_status == "Treatment Schedule"  || $claim_status == "Surgery Update" || $claim_status == "Society Approved" || $claim_status == "Preauth Approved"){ ?>
 	  			<tr>
 	  				<td height="30px" align="center" valign="center" width="3%" style="text-align:center;">
 	  					<?php echo $i++; ?>
 	  				</td>
 	  				<td height='30px' align='center' valign='middle' width="20%">
 	  					<?php echo $results['Patient']['assigned_to'];?>
 	  				</td>
 	  				<td height="30px" align='center' valign='middle' width="10%">
 	  					<?php echo $results['Patient']['lookup_name'];?>
 	  				</td>
 	  				<td height="30px" align='center' valign='middle' width="10%">
 	  					<?php echo $results['Person']['district'];?>
 	  				</td>
 	  				<td height="30px" align='center' valign='middle' width="10%">
 	  					<?php echo $results['Patient']['case_no'];?>
 	  				</td>
 	  				<td height="30px" align='center' valign='middle' width="10%">
 	  					<?php echo $results['Patient']['hospital_no'];?>
 	  				</td>
 	  				<td height="30px" align='center' valign='middle' width="10%">
 	  					<?php echo $this->DateFormat->formatDate2Local($results['Patient']['form_received_on'],Configure::read('date_format'));?>
 	  				</td>
 	  				<td colspan="2" height="30px" align='center' valign='middle' width="20%">
 	  					<?php echo $results['Patient']['claim_status']; ?>
 	  				</td>
 	  			</tr>
 	  			<?php }} ?>
 	  		</table>
 	  	</td>
 	  </tr>
 	  
 	  <!--section 2 ends here-->
 	  
 	  
 	  <!--section 3-->
	  
	  <tr>
	  	<td colspan="9" width="100%" height="30px" align="left" valign="middle"><h3>&nbsp; Section 3 = Executive Tasks 2 <i>(Bills of following patient to be uploaded)</i></h3></td>
	  </tr>
	  				  
	  <tr class='row_title'> 
	  	<td height="30px" align="center" valign="center" width="3%" style="text-align:center;"><strong>No.</strong></td>
	  	<td height="30px" align='center' valign='middle' width="7%"><strong>Team</td>
	  	<td height='30px' align='center' valign='middle' width="20%"><strong>Patient Name</strong></td>
		<td height="30px" align='center' valign='middle' width="10%"><strong>District</strong></td>					   
		<td height="30px" align='center' valign='middle' width="10%"><strong>Case No.</strong></td>  
		<td height="30px" align='center' valign='middle' width="10%"><strong>Hospital No.</strong></td>	
		<td height="30px" align='center' valign='middle' width="10%"><strong>Admission Date</strong></td>					   
		<td colspan="2" height="30px" align='center' valign='middle' width="20%"><strong>Claim Status</strong></td>
		
	</tr>
 	  
 	  <tr>
 	  	<td colspan="9" width="100%" height="30px">
 	  		<table class='table_format' border="1" cellpadding='0' cellspacing='0' width='100%'>
 	  			<?php $i = 1;  foreach($result as $results) {	$claim_status = $results['Patient']['claim_status']; ?>
     	 		<?php if($claim_status == "Discharge Update"  && !empty($results['Patient']['lookup_name'])) { ?>
 	  			<tr>
 	  				<td height="30px" align="center" valign="center" width="3%" style="text-align:center;">
 	  					<?php echo $i++; ?>
 	  				</td>
 	  				<td height='30px' align='center' valign='middle' width="20%">
 	  					<?php echo $results['Patient']['assigned_to'];?>
 	  				</td>
 	  				<td height="30px" align='center' valign='middle' width="10%">
 	  					<?php echo $results['Patient']['lookup_name'];?>
 	  				</td>
 	  				<td height="30px" align='center' valign='middle' width="10%">
 	  					<?php echo $results['Person']['district'];?>
 	  				</td>
 	  				<td height="30px" align='center' valign='middle' width="10%">
 	  					<?php echo $results['Patient']['case_no'];?>
 	  				</td>
 	  				<td height="30px" align='center' valign='middle' width="10%">
 	  					<?php echo $results['Patient']['hospital_no'];?>
 	  				</td>
 	  				<td height="30px" align='center' valign='middle' width="10%">
 	  					<?php echo $this->DateFormat->formatDate2Local($results['Patient']['form_received_on'],Configure::read('date_format'));?>
 	  				</td>
 	  				<td colspan="2" height="30px" align='center' valign='middle' width="20%">
 	  					<?php echo $results['Patient']['claim_status']; ?>
 	  				</td>
 	  			</tr>
 	  			<?php }} ?>
 	  		</table>
 	  	</td>
 	  </tr>
 	  
 	  <!--section 3 ends here-->
 	  
 	  
 	   <!--section 4-->
	  
	  <tr>
	  	<td colspan="9" width="100%" height="30px" align="left" valign="middle"><h3>&nbsp; Section 4 = Team Doctor 2 <i>(Queries To Be Answered)</i></h3></td>
	  </tr>
	  				  
	  <tr class='row_title'> 
	  	<td height="30px" align="center" valign="center" width="3%" style="text-align:center;"><strong>No.</strong></td>
	  	<td height="30px" align='center' valign='middle' width="7%"><strong>Team</td>
	  	<td height='30px' align='center' valign='middle' width="20%"><strong>Patient Name</strong></td>
		<td height="30px" align='center' valign='middle' width="10%"><strong>District</strong></td>					   
		<td height="30px" align='center' valign='middle' width="10%"><strong>Case No.</strong></td>  
		<td height="30px" align='center' valign='middle' width="10%"><strong>Hospital No.</strong></td>	
		<td height="30px" align='center' valign='middle' width="10%"><strong>Admission Date</strong></td>					   
		<td colspan="2" height="30px" align='center' valign='middle' width="20%"><strong>Claim Status</strong></td>
		
	</tr>
 	  
 	  <tr>
 	  	<td colspan="9" width="100%" height="30px">
 	  		<table class='table_format' border="1" cellpadding='0' cellspacing='0' width='100%'>
 	  			<?php $i = 1;  foreach($result as $results) {	$claim_status = $results['Patient']['claim_status']; ?>
     	 		<?php if($claim_status =="CMO Pending(Repudiated)" || $claim_status =="Claim Doctor Pending"/*$claim_status == "CMO Pending Updated(Repudiated)" || $claim_status =="Claim Doctor Pending Updated" || $claim_status =="Claim Doctor Rejected"|| $claim_status =="Claim Rejected by CMO"||  $claim_status == "Claim Doctor Approved" ||
      || $claim_status =="Cancelled By Society"|| $claim_status == "Cancelled By TPA"  || $claim_status == "CMO Approved(Repudiated)" ||  $claim_status == "CMO Rejected(Repudiated)"*/) { ?>
 	  			<tr>
 	  				<td height="30px" align="center" valign="center" width="3%" style="text-align:center;">
 	  					<?php echo $i++; ?>
 	  				</td>
 	  				<td height='30px' align='center' valign='middle' width="20%">
 	  					<?php echo $results['Patient']['assigned_to'];?>
 	  				</td>
 	  				<td height="30px" align='center' valign='middle' width="10%">
 	  					<?php echo $results['Patient']['lookup_name'];?>
 	  				</td>
 	  				<td height="30px" align='center' valign='middle' width="10%">
 	  					<?php echo $results['Person']['district'];?>
 	  				</td>
 	  				<td height="30px" align='center' valign='middle' width="10%">
 	  					<?php echo $results['Patient']['case_no'];?>
 	  				</td>
 	  				<td height="30px" align='center' valign='middle' width="10%">
 	  					<?php echo $results['Patient']['hospital_no'];?>
 	  				</td>
 	  				<td height="30px" align='center' valign='middle' width="10%">
 	  					<?php echo $this->DateFormat->formatDate2Local($results['Patient']['form_received_on'],Configure::read('date_format'));?>
 	  				</td>
 	  				<td colspan="2" height="30px" align='center' valign='middle' width="20%">
 	  					<?php echo $results['Patient']['claim_status']; ?>
 	  				</td>
 	  			</tr>
 	  			<?php }} ?>
 	  		</table>
 	  	</td>
 	  </tr>
 	  
 	  <!--section 4 ends here-->
 	  
 	  
 	  
 	  
 	  
 	  
 	  
 	  
 	  
</table>