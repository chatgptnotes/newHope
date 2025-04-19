<?php
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment;  filename=\"Total_Concessions".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls");
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
   <td colspan = "11" align="center"><h2>Total Concessions</h2></td>
  </tr>
  <tr class="row_title">
   <td height="30px" align="center" valign="middle" width="5%"><strong><?php echo __('Sr.No.'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="15%"><strong><?php echo __('Date of Reg.'); ?></strong></td>	
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('MRN'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Patient Name'); ?></strong></td> 
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Patient Status'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Patient Type'); ?></strong></td>	
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Mobile No'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Bill Number'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Payment Date'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Total Amount'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Concession Amount'); ?></strong></td>
  </tr>
 <?php
        $totalAmount = 0; 
        $cntConcessions = "";
		$concessionCnt=0;
       
        if(count($getConcessions) > 0) {
          foreach($getConcessions as $getConcessionsVal) {
			      
			      $registrationDate = date("d/m/Y", strtotime($this->DateFormat->formatDate2Local($getConcessionsVal['Patient']['form_received_on'],'yyyy/mm/dd', true)));
				   $paymentDate = date("d/m/Y", strtotime($this->DateFormat->formatDate2Local($getConcessionsVal['FinalBilling']['discharge_date'],'yyyy/mm/dd', true)));
                  $totalAmount += $getConcessionsVal['FinalBilling']['discount_rupees'];
                  $formatted_address = $this->requestAction("/patients/setAddressFormat",array('pass' => array($getConcessionsVal['Person'])));
				  if($getConcessionsVal['FinalBilling']['discount_rupees'] == "" || empty($getConcessionsVal['FinalBilling']['discount_rupees'])) {
					   continue;
				  } else {
					  $concessionCnt++;
				  }
 ?>
           <tr>				
		    <td align='center' height='17px'><?php echo $concessionCnt; ?></td>
			<td align='center' height='17px'><?php echo $registrationDate; ?></td>
			<td align='center' height='17px'><?php echo $getConcessionsVal['Patient']['admission_id'] ?></td>
	        <td align='center' height='17px'><?php echo $getConcessionsVal['PatientInitial']['name'].' '.$getConcessionsVal['Patient']['lookup_name'] ?></td>
			<td align='center' height='17px'>
			 <?php if($getConcessionsVal['Patient']['admission_type'] == "IPD") {
			        if($getConcessionsVal['Patient']['is_discharge'] == 1) {  
						echo __('Discharged');
					} else {
						echo __('Not Discharged');
					}
		           }
				   if($getConcessionsVal['Patient']['admission_type'] == "OPD") {
			        if($getConcessionsVal['Patient']['is_discharge'] == 1) {  
						echo __('OP Process Completed');
					} else {
						echo __('OP In-Progress');
					}
		           }
			?>
			</td>
            <td align='center' height='17px'><?php echo $getConcessionsVal['Patient']['admission_type'] ?></td>
            <td align='center' height='17px'><?php echo $getConcessionsVal['Patient']['mobile_phone'] ?></td>
            <td align='center' height='17px'><?php echo $getConcessionsVal['FinalBilling']['bill_number'] ?></td>
			<td align='center' height='17px'><?php echo $paymentDate; ?></td>
			<td align='center' height='17px'><?php echo $getConcessionsVal['FinalBilling']['total_amount'] ?></td>
            <td align='center' height='17px'><?php echo $getConcessionsVal['FinalBilling']['discount_rupees'] ?></td>
           </tr>
 <?php     }
        } else {
            $cntConcessions = "norecord";
        }
 ?>
 <?php
if($concessionCnt > 0) {
 ?>
 <tr>					
  <td align='right' height='17px' colspan="10"><strong>Total Amount</strong></td>
  <td align='center' height='17px' colspan="1"><strong><?php echo $totalAmount; ?></strong></td>
 </tr>
<?php } ?>
<?php
if($concessionCnt == 0) {
 ?>
 <tr>					
  <td align='center' height='17px' colspan="11">No Record Found</td>
 </tr>
<?php } ?>
           
</table>
		
