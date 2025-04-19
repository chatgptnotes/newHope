<?php
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment;  filename=\"Card_Patients_Status".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls");
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
   <td colspan = "10" align="center"><h2>Card Patients Status</h2></td>
  </tr>
  <tr class="row_title">
   <td height="30px" align="center" valign="middle" width="5%"><strong><?php echo __('Sr.No.'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="15%"><strong><?php echo __('Date of Reg.'); ?></strong></td>	
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('MRN'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Patient Name'); ?></strong></td> 
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Patient Status'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Patient Type'); ?></strong></td>	
   <td height="30px" align="center" valign="middle" width="20%"><strong><?php echo __('Address'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Sponsor Name'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Status'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Remark'); ?></strong></td>
  </tr>
 <?php
        $statusCnt = 0;    
        if(count($getDetails) > 0) {
          foreach($getDetails as $getDetailsVal) {
			      $statusCnt++;
			      $registrationDate = date("d/m/Y", strtotime($this->DateFormat->formatDate2Local($getDetailsVal['Patient']['form_received_on'],'yyyy/mm/dd', true)));
				  $formatted_address = $this->requestAction("/patients/setAddressFormat",array('pass' => array($getDetailsVal['Person'])));
				  
 ?>
           <tr>				
		    <td align='center' height='17px'><?php echo $statusCnt; ?></td>
			<td align='center' height='17px'><?php echo $registrationDate; ?></td>
			<td align='center' height='17px'><?php echo $getDetailsVal['Patient']['admission_id'] ?></td>
	        <td align='center' height='17px'><?php echo $getDetailsVal['PatientInitial']['name'].' '.$getDetailsVal['Patient']['lookup_name'] ?></td>
			<td align='center' height='17px'>
			 <?php if($getDetailsVal['Patient']['admission_type'] == "IPD") {
			        if($getDetailsVal['Patient']['is_discharge'] == 1) {  
						echo __('Discharged');
					} else {
						echo __('Not Discharged');
					}
		           }
				   if($getDetailsVal['Patient']['admission_type'] == "OPD") {
			        if($getDetailsVal['Patient']['is_discharge'] == 1) {  
						echo __('OP Process Completed');
					} else {
						echo __('OP In-Progress');
					}
		           }
				   if($getDetailsVal['Patient']['corporate_id']) $sponsor_name =  $getDetailsVal['Corporate']['name'];
				   if($getDetailsVal['Patient']['insurance_company_id']) $sponsor_name =  $getDetailsVal['InsuranceCompany']['name'];

			?>
			</td>
            <td align='center' height='17px'><?php echo $getDetailsVal['Patient']['admission_type'] ?></td>
            <td align='center' height='17px'><?php echo $formatted_address; ?></td>
			<td align='center' height='17px'><?php echo $sponsor_name; ?></td>
			<td align='center' height='17px'><?php echo $getDetailsVal['Patient']['status'] ?></td>
            <td align='center' height='17px'><?php echo $getDetailsVal['Patient']['remark'] ?></td>
           </tr>
 <?php     }
        } else {
?>
         <tr>					
          <td align='center' height='17px' colspan="10">No Record Found</td>
         </tr>
<?php
        }
 ?>
 <?php
if($statusCnt > 0) {
 ?>
 <tr>					
  <td align='center' height='17px' colspan="10"><strong>Total Patient:<?php echo $statusCnt ?></strong></td>
 </tr>
<?php } ?>
           
</table>
		
