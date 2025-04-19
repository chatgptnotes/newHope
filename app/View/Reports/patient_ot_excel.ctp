<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"Total_Surgery_Report". $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls" );
header ("Content-Description: Generated Report" );
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
<?php $fromDate = $this->DateFormat->formatDate2Local($from,Configure::read('date_format'), false);
	  $toDate = $this->DateFormat->formatDate2Local($to,Configure::read('date_format'), false);

	  if($sergeryId){
	  	$surgeryname = $sergeryList[$sergeryId];
	  }
	  if($sergery_type){
	  	$surType = ucfirst($sergery_type);
	  }
	  if($department){
	  	$deptName = $departments[$department];
	  }
	  if($doctor){
	  	$doctorName = $doctorList[$doctor];
	  }
	  
?>
<table border='1' class='table_format'  cellpadding='0' cellspacing='0' width='100%' style='text-align:left;padding-top:50px;'>		
  <tr class="row_title">
   <td colspan = "14" align="center"><h2>Total Surgery Report-<?php echo $fromDate." To ".$toDate." ".$surType." ".$surgeryname." ".$deptName." ".$doctorName?></h2></td>
  </tr>
	  <tr class='row_title'>
		   <td height='30px' align='center' valign='middle' width='5%'><strong><?php echo __('Sr.No.'); ?></strong></td>
		   <td height='30px' align='center' valign='middle'><strong><?php echo __('Date Of Reg.'); ?></strong></td>
		   <td height='30px' align='center' valign='middle'><strong><?php echo __('MRN'); ?></strong></td>
		   <td height='30px' align='center' valign='middle'><strong><?php echo __('Patient Name'); ?></strong></td>
		   <td height='30px' align='center' valign='middle'><strong><?php echo __('Age'); ?></strong></td>					   
		   <td height='30px' align='center' valign='middle'><strong><?php echo __('Sex'); ?></strong></td>
		   <td height='30px' align='center' valign='middle'><strong><?php echo __('Surgery Type'); ?></strong></td>
		   <td height='30px' align='center' valign='middle'><strong><?php echo __('Surgery'); ?></strong></td>
		   <td height='30px' align='center' valign='middle'><strong><?php echo __('Surgeon'); ?></strong></td>
		  <!--  <td height='30px' align='center' valign='middle'><strong><?php echo __('Room No.'); ?></strong></td> -->
		   <td height='30px' align='center' valign='middle'><strong><?php echo __('Surgery Date'); ?></strong></td>
		   <td height='30px' align='center' valign='middle'><strong><?php echo __('OT In Date & Time'); ?></strong></td>
		   <td height='30px' align='center' valign='middle'><strong><?php echo __('OT Out Date & Time'); ?></strong></td>
		   <td height='30px' align='center' valign='middle'><strong><?php echo __('Procedure Complete'); ?></strong></td>
						   
	 </tr>
 <?php  
 $toggle =0;
	  if(count($reports) > 0) {
		   $i = 1;
		  
			foreach($reports as $pdfData){	
			//$Anaetesist = ClassRegistry::init('DoctorProfile')->field('doctor_name',array('DoctorProfile.user_id'=>$pdfData['OptAppointment']['department_id']));
			
?>
	<tr>
	<td align='center' height='17px'><?php echo $i ?></td>
	   <td align='center' height='17px'><?php echo $this->DateFormat->formatDate2Local($pdfData['Patient']['form_received_on'],Configure::read('date_format'), false); ?></td>
	   <td align='center' height='17px'><?php echo $pdfData['Patient']['admission_id']; ?> </td>
	   <td align='center' height='17px'><?php echo $pdfData['PatientInitial']['name']." ".$pdfData['Patient']['lookup_name']; ?></td>
	   <td align='center' height='17px'><?php echo $pdfData['Patient']['age']; ?> </td>
	   <td align='center' height='17px'><?php echo ucfirst($pdfData['Patient']['sex']); ?> </td>
	   <td align='center' height='17px'><?php echo ucfirst($pdfData['OptAppointment']['operation_type']); ?> </td>
	   <td align='center' height='17px'><?php echo ucfirst($pdfData['Surgery']['name']); ?> </td>
	   <td align='center' height='17px'><?php echo $pdfData['Initial']['name'].' '.$pdfData['DoctorProfile']['doctor_name']; ?> </td>
	  <!--  <td align='center' height='17px'><?php echo $pdfData['Opt']['name']; ?> </td> -->
	   <td align='center' height='17px'><?php echo 
	   	$this->DateFormat->formatDate2Local($pdfData['OptAppointment']['starttime'],Configure::read('date_format'), false); 

	    ?> </td>
	   
	   <td align='center' height='17px'><?php echo $this->DateFormat->formatDate2Local($pdfData['OptAppointment']['starttime'],Configure::read('date_format'), true); ?></td>
	   <td align='center' height='17px'><?php echo $this->DateFormat->formatDate2Local($pdfData['OptAppointment']['endtime'],Configure::read('date_format'), true); ?></td>
	   <td align='center' height='17px'><?php if($pdfData['OptAppointment']['procedure_complete'] == 1) echo __('Yes'); else echo __('No'); ?></td>	
	 </tr>
					
<?php $i++;  } ?>
	<tr>
		<td height="30px" align="center" valign="middle" colspan="14"><strong>Total Patients:</strong><?php echo $i-1;?></td>											
		
	 </tr>
<?php } else { ?>
		<tr>
			<td colspan = '14' align='center' height='30px'>No Record Found For the Selection!</td>
		</tr>
	 <?php } ?>
			   		  
</table>
