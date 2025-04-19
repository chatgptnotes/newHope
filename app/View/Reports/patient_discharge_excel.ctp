<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"Total_Discharge_Report".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls" );
header ("Content-Description: Generated Report" );
ob_clean();
flush();
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
<table border='1' class='table_format'  cellpadding='0' cellspacing='0' width='100%' style='text-align:left;padding-top:50px;'>		
<tr class="row_title">
   <td colspan = "14" align="center"><h2><?php echo __('Total Discharge Report'); ?></h2></td>
  </tr>
	  <tr class='row_title'>
		   <td height='30px' align='center' valign='middle' width='7%'><strong>Sr.No.</strong></td>
		   <td height='30px' align='center' valign='middle'><strong>Discharge Date</strong></td>
		   <td height='30px' align='center' valign='middle'><strong>Date Of Admission.</strong></td>	
		   <td height='30px' align='center' valign='middle'><strong><?php echo __("MRN")?></strong></td>
		   <td height='30px' align='center' valign='middle'><strong>Patient Name</strong></td>
		   <td height='30px' align='center' valign='middle'><strong>Patient Type</strong></td>
		   <td height='30px' align='center' valign='middle'><strong>Corporate Name</strong></td>
		   <td height='30px' align='center' valign='middle'><strong>Address</strong></td>
		   
		  <!-- <td height='30px' align='center' valign='middle'><strong>Reason of Discharge</strong></td>-->
           <td height='30px' align='center' valign='middle'><strong>Total Amount</strong></td>
           <td height='30px' align='center' valign='middle'><strong>Amount Paid</strong></td>
           <td height='30px' align='center' valign='middle'><strong>Discount</strong></td>
           <td height='30px' align='center' valign='middle'><strong>Total Outstanding</strong></td>
           <td height='30px' align='center' valign='middle'><strong>Percentage</strong></td>
           <td height='30px' align='center' valign='middle'><strong>Date Of Submission</strong></td>
           <td height='30px' align='center' valign='middle'><strong>Date Of Payment</strong></td>
						   
	 </tr>
 <?php  
 $toggle =0;
	  if(count($reports) > 0) {
		   $i = 1;
	 $totalAmount =0;  
	foreach($reports as $pdfData) {	
		
         // $totalAmount +=$pdfData['FinalBilling']['total_amount'];
		 $patPaid=$patDis=$patTotal=$balanceAmt=0;
		 $totalAmount +=round($patientBill['Total'][$pdfData['Patient']['id']]);
		 $amtPaid +=round($patientBill['FinalPaid'][$pdfData['Patient']['id']]-$patientBill['FinalRefund'][$pdfData['Patient']['id']]);
		 $amtDiscount +=round($patientBill['FinalDiscount'][$pdfData['Patient']['id']]);
			if(!empty($pdfData['Patient']['create_time'])){
		?>
		<tr>
		<td align='center' height='17px'><?php echo $i ?></td>
		<td align='center' height='17px'><?php echo $this->DateFormat->formatDate2Local($pdfData['Patient']['discharge_date'],Configure::read('date_format'));?> </td>
		   <td align='center' height='17px'><?php echo $this->DateFormat->formatDate2Local($pdfData['Patient']['form_received_on'],Configure::read('date_format')); ?></td>
		   <td align='center' height='17px'><?php echo $pdfData['Patient']['admission_id']; ?> </td>
		   <td align='center' height='17px'><?php echo $pdfData['PatientInitial']['name']." ".$pdfData['Patient']['lookup_name']; ?></td>
		   <td align='center' height='17px'><?php echo $pdfData['Patient']['admission_type']; ?></td>
		   <td align='center' height='17px'>
		    <?php 
			      if(!empty($pdfData['Corporate']['name'])) echo $pdfData['Corporate']['name']; 
		          elseif(!empty($pdfData['InsuranceCompany']['name'])) echo $pdfData['InsuranceCompany']['name'];
		          //by swapnil to display the patient tariff
		          else echo  $pdfData['TariffStandard']['name'];
				  //else echo __('Private');
		    ?>
		   </td>
		   
		   	<td align='center' height='17px'><?php echo $pdfData['Person']['city']; ?></td>
            <td align='center' height='17px'><?php //echo $pdfData['FinalBilling']['total_amount'];

            	if($pdfData['TariffStandard']['id'] == 7 ){
            		echo $patTotal=round($patientBill['Total'][$pdfData['Patient']['id']]);
            	}else{
            		echo $patTotal=round($pdfData['FinalBilling']['hospital_invoice_amount']);
            	}
                   	 ?></td>
           	<td align='center' height='17px'><?php echo $patPaid=round($patientBill['FinalPaid'][$pdfData['Patient']['id']]-$patientBill['FinalRefund'][$pdfData['Patient']['id']]);?></td>
           	<td align='center' height='17px'><?php echo $patDis=round($patientBill['FinalDiscount'][$pdfData['Patient']['id']]);?></td>
           	<td align='center' height='17px'><?php //echo $pdfData['FinalBilling']['total_amount'];
           	$balanceAmt=round($patTotal-$patPaid-$patDis);
           	echo $balanceAmt; 
           	$totalBal +=$balanceAmt;
           	 ?></td>

           	 <td align='center' height='17px'>
           	 	<?php if($pdfData['Person']['vip_chk'] == 1){
           	 		echo "20%";
           	 	}else{
           	 		echo "80%";
           	 	}

           	 		?></td>
     	 		<td align='center' height='17px'><?php echo $pdfData['FinalBilling']['dr_claim_date']; ?></td>
     	 		<td align='center' height='17px'><?php echo $this->DateFormat->formatDate2Local($pdfData['FinalBilling']['date'],Configure::read('date_format')) ?></td>
		 </tr>
					
<?php $i++; 
			} 
		} ?>
	<tr>
		
		<td height="30px" align="right" colspan="8" valign="middle" ><strong>Total Amount</strong></td>											
		<td align="center" height="17px"><?php echo $totalAmount;?></td>
		<td align="center" height="17px"><?php echo $amtPaid;?></td>
		<td align="center" height="17px"><?php echo $amtDiscount;?></td>
		<td align="center" height="17px"><?php echo round($totalBal);?></td>	
	 </tr>
<?php } else { ?>
		<tr>
			<td colspan = '9' align='center' height='30px'>No Record Found</td>
		</tr>
<?php } ?>
			   		  
</table>
