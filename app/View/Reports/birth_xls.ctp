<?php
//header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
//header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"Birth_Report".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls" );
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
   <td colspan = "11" align="center"><h2><?php echo __('Birth Report'); ?></h2></td>
  </tr>
  <tr class="row_title">
   <td height="30px" align="center" valign="middle" width="5%"><strong><?php echo __('Sr.No.'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Date of Reg.'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('MRN'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Mother Name'); ?></strong></td>	
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Father Name'); ?></strong></td>					  
   <td height="30px" align="center" valign="middle" width="20%"><strong><?php echo __('Doctor'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="5%"><strong><?php echo __('Mother Age'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Sex'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Date of Birth'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="15%"><strong><?php echo __('Method of Delivery'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Birth Weight'); ?></strong></td>
  </tr>
  <?php 
        $birthReportCnt=0;
        if(count($getBirthReport) > 0) {
          foreach($getBirthReport as $getBirthReportVal) {
			   $birthReportCnt++;
  ?>
           <tr>				
		    <td align='center' height='17px'><?php echo $birthReportCnt; ?></td>
            <td align='center' height='17px'><?php echo date("d/m/Y", strtotime($this->DateFormat->formatDate2Local($getBirthReportVal['Patient']['form_received_on'],'yyyy/mm/dd',true))); ?></td>
			<td align='center' height='17px'><?php echo $getBirthReportVal['Patient']['admission_id']; ?></td>
	        <td align='center' height='17px'><?php echo $getBirthReportVal['ChildBirth']['mother_name']; ?></td>
	        <td align='center' height='17px'><?php echo $getBirthReportVal['ChildBirth']['father_name']; ?></td>
            <td align='center' height='17px'><?php echo $getBirthReportVal[0]['doctor_name']; ?></td>
            <td align='center' height='17px'><?php echo $getBirthReportVal['Patient']['age']; ?></td>
            <td align='center' height='17px'><?php if($getBirthReportVal['ChildBirth']['sex'] == "Son") echo __("Male"); else echo __("Female");  ?></td>
            <td align='center' height='17px'><?php echo $this->DateFormat->formatDate2Local($getBirthReportVal['ChildBirth']['dob'],Configure::read('date_format'), true) ?></td>
            <td align='center' height='17px'><?php echo $getBirthReportVal['ChildBirth']['method_of_delivery'] ?></td>
            <td align='center' height='17px'><?php echo $getBirthReportVal['ChildBirth']['birth_weight'] ?></td>
           </tr>
 <?php     }
        } else {
 ?>
       <tr>					
        <td align='center' height='17px' colspan="11"><?php echo __('No Record Found'); ?></td>
       </tr>
 <?php
        }
 ?>
          
</table>
		
