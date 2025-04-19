<?php
//header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
//header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"Death_Report".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls" );
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
   <td colspan = "10" align="center"><h2><?php echo __('Death Report'); ?></h2></td>
  </tr>
   <tr class="row_title">
   <td height="30px" align="center" valign="middle" width="5%"><strong><?php echo __('Sr.No.'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Date of Reg.'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('MRN'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Patient Name'); ?></strong></td>					  
   <td height="30px" align="center" valign="middle" width="20%"><strong><?php echo __('Doctor'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="5%"><strong><?php echo __('Age'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Sex'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Expired On'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="15%"><strong><?php echo __('Cause of Death'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Date of Issue'); ?></strong></td>
  </tr>
  <?php 
        $deathReportCnt=0;
        if(count($getDeathReport) > 0) {
          foreach($getDeathReport as $getDeathReportVal) {
			   $deathReportCnt++;
  ?>
           <tr>			
		    <td align='center' height='17px'><?php echo $deathReportCnt; ?></td>
			<td align='center' height='17px'><?php echo date("d/m/Y", strtotime($this->DateFormat->formatDate2Local($getDeathReportVal['Patient']['form_received_on'],'yyyy/mm/dd',true))); ?></td>
			<td align='center' height='17px'><?php echo $getDeathReportVal['Patient']['admission_id'] ?></td>
	        <td align='center' height='17px'><?php echo $getDeathReportVal['PatientInitial']['name'].' '.$getDeathReportVal['Patient']['lookup_name'] ?></td>
            <td align='center' height='17px'><?php echo $getDeathReportVal[0]['doctor_name'] ?></td>
            <td align='center' height='17px'><?php echo $getDeathReportVal['Patient']['age'] ?></td>
            <td align='center' height='17px'><?php echo ucfirst($getDeathReportVal['Patient']['sex']) ?></td>
            <td align='center' height='17px'><?php echo $this->DateFormat->formatDate2Local($getDeathReportVal['DeathCertificate']['expired_on'],Configure::read('date_format'), true) ?></td>
            <td align='center' height='17px'><?php echo $getDeathReportVal['DeathCertificate']['cause_of_death'] ?></td>
            <td align='center' height='17px'><?php echo $this->DateFormat->formatDate2Local($getDeathReportVal['DeathCertificate']['date_of_issue'],Configure::read('date_format'), true) ?></td>
           </tr>
 <?php     }
        } else {
 ?>
       <tr>					
        <td align='center' height='17px' colspan="10"><?php echo __('No Record Found'); ?></td>
       </tr>
 <?php
        }
 ?>
        
</table>
		
