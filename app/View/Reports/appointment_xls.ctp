<?php
//header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
//header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"Appointment_Report".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls");
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
<table border="1" class="table_format"  cellpadding="2" cellspacing="0" width="100%" style="text-align:left;padding-top:50px;">	
  <tr class="row_title">
   <td colspan = "12" align="center"><h2><?php echo __('Appointment Report'); ?></h2></td>
  </tr>
  <tr class="row_title">
   <td height="30px" align="center" valign="middle" width="5%"><strong><?php echo __('Sr.No.'); ?></strong></td>	
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Date of Reg.'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('MRN'); ?></strong></td> 
   <td height="30px" align="center" valign="middle" width="15%"><strong><?php echo __('Patient Name'); ?></strong></td>					  
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Visit Type'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Treating Consultant'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="5%"><strong><?php echo __('Age'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Specilty'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Sex'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Appointment Date'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Appointment Start Time'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Appointment End Time'); ?></strong></td>
  </tr>
  <?php $appointCnt=0;
        if(count($getAppointmentReport) > 0) {
          foreach($getAppointmentReport as $getAppointmentReportVal) {
            $appointCnt++;
  ?>
           <tr>			
		    <td align='center' height='17px'><?php echo $appointCnt; ?></td>
			<td align='center' height='17px'><?php echo date("d/m/Y", strtotime($this->DateFormat->formatDate2Local($getAppointmentReportVal['Patient']['form_received_on'],'yyyy/mm/dd',true))); ?></td>
			<td align='center' height='17px'><?php echo $getAppointmentReportVal['Patient']['admission_id'] ?></td>
			<td align='center' height='17px'><?php echo $getAppointmentReportVal['PatientInitial']['name'].' '.$getAppointmentReportVal['Patient']['lookup_name'] ?></td>
            <td align='center' height='17px'><?php echo str_replace("_", " ", $getAppointmentReportVal['TariffList']['name']); ?></td>
            <td align='center' height='17px'><?php echo $getAppointmentReportVal[0]['doctor_name'] ?></td>
            <td align='center' height='17px'><?php echo $getAppointmentReportVal['Patient']['age'] ?></td>
            <td align='center' height='17px'><?php echo $getAppointmentReportVal['Department']['name'] ?></td>
            <td align='center' height='17px'><?php echo ucfirst($getAppointmentReportVal['Patient']['sex']) ?></td>
            <td align='center' height='17px'><?php echo $this->DateFormat->formatDate2Local($getAppointmentReportVal['Appointment']['date'],Configure::read('date_format'), false) ?></td>
            <td align='center' height='17px'><?php echo $getAppointmentReportVal['Appointment']['start_time'] ?></td>
            <td align='center' height='17px'><?php echo $getAppointmentReportVal['Appointment']['end_time'] ?></td>
           </tr>
 <?php    }  ?>
         <tr>
          <td colspan="12" align="center"><?php echo "<strong>". __('Total :')."</strong>". "&nbsp;" .$appointCnt; ?></td>
         </tr>
 <?php
  }else {
 ?>
       <tr>					
        <td align='center' height='17px' colspan="12">No Record Found</td>
       </tr>
 <?php
        }
 ?>
            
</table>
		
