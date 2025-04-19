<?php
//header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
//header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment;  filename=\"Daily_Cheque_Collection_and_NEFT_Details".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls");
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
   <td colspan = "11" align="center"><h2>Daily Cheque Collection and NEFT Details</h2></td>
  </tr>
  <tr class="row_title">
   <td colspan = "11" align="center"><h3>Billing</h3></td>
  </tr>
  <tr class="row_title">
   <td height="30px" align="center" valign="middle" width="5%"><strong><?php echo __('Sr.No.'); ?></strong></td>
          <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Date of Reg.'); ?></strong></td>
		  <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('MRN'); ?></strong></td>
		  <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Patient Name'); ?></strong></td>
		  <td height="30px" align="center" valign="middle" width="5%"><strong><?php echo __('Patient Status'); ?></strong></td>
		  <td height="30px" align="center" valign="middle" width="5%"><strong><?php echo __('Patient Type'); ?></strong></td>
		  <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Payment Type'); ?></strong></td>
		  <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Payment Date'); ?></strong></td>
		  <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Mode of Payment'); ?></strong></td>
		  <td height="30px" align="center" valign="middle" width="15%"><strong><?php echo __('Payment Number'); ?></strong></td>
		  <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Amount'); ?></strong></td>

   
  </tr>
  <?php $totalAmount = 0; ?>
 <?php 
        // get billing check //
        if(count($getBillingCheck) > 0) {
          $dateshow = "";
          foreach($getBillingCheck as $getBillingCheckVal) {
                  $totalAmount += $getBillingCheckVal['Billing']['amount'];
                  $billingCnt++;
                  $formatted_address = $this->requestAction("/patients/setAddressFormat",array('pass' => array($getBillingCheckVal['Person'])));
				  
                  $dateExp = explode(" ", date("d/m/Y H:i:s", strtotime($this->DateFormat->formatDate2Local($getBillingCheckVal['Billing']['date'],'yyyy/mm/dd', true))));
 ?>
  <?php 
             if($dateshow != $dateExp[0] && $billingCnt!= 1) {
             
           ?>
            <tr>			
             <td align='right' height='17px' colspan="10"><strong><?php echo  __('Total'); ?></strong></td>		
	         <td align='center' height='17px'><?php echo $billingDaysTotal ?></td>
            </tr>
           <?php
                 $billingDaysTotal = 0;
               } 
               
           ?>
           <tr>			
            <td align='center' height='17px'><?php echo $billingCnt ?></td>
			<td align='center' height='17px'><?php echo date("d/m/Y", strtotime($this->DateFormat->formatDate2Local($getBillingCheckVal['Patient']['form_received_on'],'yyyy/mm/dd', true))) ?></td>
            <td align='center' height='17px'><?php echo $getBillingCheckVal['Patient']['admission_id'] ?></td>		
	        <td align='center' height='17px'><?php echo $getBillingCheckVal['PatientInitial']['name'].' '.$getBillingCheckVal['Patient']['lookup_name'] ?></td>
			<td align='center' height='17px'>
			 <?php if($getBillingCheckVal['Patient']['admission_type'] == "IPD") {
			        if($getBillingCheckVal['Patient']['is_discharge'] == 1) {  
						echo __('Discharged');
					} else {
						echo __('Not Discharged');
					}
		           }
				   if($getBillingCheckVal['Patient']['admission_type'] == "OPD") {
			        if($getBillingCheckVal['Patient']['is_discharge'] == 1) {  
						echo __('OP Process Completed');
					} else {
						echo __('OP In-Progress');
					}
		           }

				   if($getBillingCheckVal['Billing']['mode_of_payment'] == "Cheque") {  
						$paymentno = $getBillingCheckVal['Billing']['check_credit_card_number'];
					}
				    if($getBillingCheckVal['Billing']['mode_of_payment'] == "NEFT") {  
						$paymentno = $getBillingCheckVal['Billing']['neft_number'];
					}
			?>
			</td>
			<td align='center' height='17px'><?php echo $getBillingCheckVal['Patient']['admission_type'] ?></td>
			<td align='center' height='17px'><?php echo $getBillingCheckVal['Billing']['reason_of_payment']; ?></td>
			<td align='center' height='17px'><?php echo $dateExp[0] ?></td>
			<td align='center' height='17px'><?php echo $getBillingCheckVal['Billing']['mode_of_payment']; ?></td>
			<td align='center' height='17px'><?php echo $paymentno; ?></td>
            <td align='center' height='17px'><?php echo $getBillingCheckVal['Billing']['amount']; ?></td>
           </tr>
           <?php  $dateshow = $dateExp[0]; $billingDaysTotal += $getBillingCheckVal['Billing']['amount']; ?>
 <?php     } ?>
 <tr>			
             <td align='right' height='17px' colspan="10"><strong><?php echo  __('Total'); ?></strong></td>		
	         <td align='center' height='17px'><?php echo $billingDaysTotal ?></td>
            </tr>
 <?php       } else {            $cntBilling = "norecord"; ?>
            <tr>			
             <td align='center' height='17px' colspan="11"><?php echo  __('No record found'); ?></td>		
	        </tr>
 <?php
        }
 ?>
 </table>
 <?php
if($cntBilling != 'norecord') {
 ?>
 <table border="1" class="table_format"  cellpadding="2" cellspacing="0" width="100%" style="text-align:left;padding-top:50px;">
 <tr>					
  <td align='right' height='17px' colspan="10"><strong>Total Amount</strong></td>
  <td align='center' height='17px' colspan="1"><strong><?php echo $totalAmount; ?></strong></td>
 </tr>
 </table>
<?php } ?>
           

		
