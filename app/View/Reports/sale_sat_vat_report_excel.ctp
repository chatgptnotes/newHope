<?php 
 header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"pharmacy_".$for."_sat_vat_report".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls" );
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

<table border="1" class="table_format"  cellpadding="2" cellspacing="0" width="100%" style="text-align:left;padding-top:50px;">	
			  <tr>
				<td colspan = "10" align="center"><strong><?php echo ucfirst($getLocName);?></strong></td>
			  </tr>
			  <tr>
				<td colspan = "10" align="center"><strong><?php echo ucfirst($getLocAdd1).' '.ucfirst($getLocAdd2).' '.ucfirst($location_zipcode).','.ucfirst($location_country);?></strong></td>
			  </tr>
			  
			  <tr>
				<td colspan = "10" align="center"><strong>Pharmacy <?php echo ucfirst($for);?> VAT & SAT Report</strong></td>
			  </tr>
			  <tr >
				<td colspan = "10" align="center"><strong><?php echo $this->DateFormat->formatDate2Local($from,Configure::read('date_format'), false); ?></strong> to <strong><?php echo $this->DateFormat->formatDate2Local($to,Configure::read('date_format'), false);?></strong></td>
			  </tr>
			  <tr>
			   		<td height="30px" align="center" valign="middle" width="6%"><strong><?php echo __('Sr. No.'); ?></strong></td> 
			  	   	<td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Date'); ?></strong></td> 
				   	<td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Bill Code'); ?></strong></td>					  
				   	<td height="30px" align="center" valign="middle" width="19%"><strong><?php echo __('Patient Name'); ?></strong></td>  
				   	<td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Net Billed Amount
'); ?></strong></td>				  
 					<td height="30px" align="center" valign="middle" width="15%"><strong><?php echo __('VAT @12.5%'); ?></strong></td>
 					<td height="30px" align="center" valign="middle" width="5%"><strong><?php echo __('SAT @1.5%'); ?></strong></td> 
 					<td height="30px" align="center" valign="middle" width="5%"><strong><?php echo __('VAT @4%'); ?></strong></td> 
 					<td height="30px" align="center" valign="middle" width="5%"><strong><?php echo __('SAT @1%'); ?></strong></td> 
 					<td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Total Tax'); ?></strong></td> 
			   </tr>
			<?php 
			
				  $getTotalDiscountPer=0;
				  $totalDiscountAmt=0;
				  $getTotalFinalAmt=0;
				  $getSumOfTaxGrand=0;
				  $grandVatFourteen=0;
				  $grandSatFourteen=0;
				  $grandVatFive=0;
				  $grandSatFive=0;
				if(count($reports)>0) {
			    $k = 1; 
					$cnt=1;
	      		foreach($reports as $report){
					$getSumOfTax=$report['PharmacySalesBill']['vat_fourteen']+$report['PharmacySalesBill']['sat_fourteen']+$report['PharmacySalesBill']['vat_five']+$report['PharmacySalesBill']['sat_five'];

					$getSumOfTaxGrand=$getSumOfTaxGrand+$getSumOfTax;
					$getTotalDiscountPer=$getTotalDiscountPer+round(($report['PharmacySalesBill']['discount']*100)/$report['PharmacySalesBill']['total']);
					$totalDiscountAmt=$totalDiscountAmt+$report['PharmacySalesBill']['discount'];
					$grandVatFourteen=$grandVatFourteen+$report['PharmacySalesBill']['vat_fourteen'];
					$grandSatFourteen=$grandSatFourteen+$report['PharmacySalesBill']['sat_fourteen'];
					$grandVatFive=$grandVatFive+$report['PharmacySalesBill']['vat_five'];
					$grandSatFive=$grandSatFive+$report['PharmacySalesBill']['sat_five'];?>
						<tr>
							<td align='center' height='17px'><?php echo $cnt;?></td>
							<td align='center' height='17px'><?php echo $this->DateFormat->formatDate2Local($report['PharmacySalesBill']['create_time'],Configure::read('date_format')); ?></td>
												
							<td align='center' height='17px'><?php echo $report['PharmacySalesBill']['bill_code']; ?></td>		
							<td align='center' height='17px'>							
							<?php
								if(empty($report['PharmacySalesBill']['patient_id']))
									echo $report['PharmacySalesBill']['customer_name'];
								else
									echo $report['Patient']['lookup_name']." (".$report['Patient']['patient_id'].")";
							?> 
							</td>	
							<td align='center' height='17px'><?php 
							$getAmount=$report['PharmacySalesBill']['total']-$report['PharmacySalesBill']['discount'];
							$getTotalFinalAmt=$getTotalFinalAmt+round($getAmount);
							echo round($getAmount); 
							$getGrandNetAmt=$getGrandNetAmt+$getAmount;?></td>		
							<td align='center' height='17px'><?php echo number_format($report['PharmacySalesBill']['vat_fourteen'], 2);?></td>
							<td align='center' height='17px'><?php echo number_format($report['PharmacySalesBill']['sat_fourteen'], 2); ?></td>
							<td align='center' height='17px'><?php echo number_format($report['PharmacySalesBill']['vat_five'], 2); ?></td>						
							<td align='center' height='17px'><?php echo number_format($report['PharmacySalesBill']['sat_five'], 2); ?></td>
							
							<td align='center' height='17px'><?php echo number_format($getSumOfTax, 2); 
						 ?></td>
						</tr>
					
			<?php 
			$cnt++;
				}
				
			
?>	
<tr>
	<td align="center" colspan="4"><strong></strong></td>
	<td align="center"><strong><?php echo number_format($getGrandNetAmt, 2);?></strong></td>
	<td align="center"><strong><?php echo number_format($grandVatFourteen, 2);?></strong></td>
	<td align="center"><strong><?php echo number_format($grandSatFourteen, 2);?></strong></td>
	<td align="center"><strong><?php echo number_format($grandVatFive, 2);?></strong></td>
	<td align="center"><strong><?php echo number_format($grandSatFive, 2);?></strong></td>
	<td align="center"><strong><?php echo number_format($getSumOfTaxGrand, 2);?></strong></td>
</tr>
<?php //if($flagCredit){?>
<!--<tr>
	
	<td align="right" colspan="9"><strong>Total Credit Amount</strong></td>
	<td align="center"><strong><?php echo $this->Number->currency(ceil($totalCreditAmt));?></strong></td>
</tr>-->
<?php //}if($flagCash){?>
<!--<tr>
	<td  align="right" colspan="9"><strong>Total Cash Amount</strong></td>
	<td align="center"><strong><?php echo $this->Number->currency(ceil($totalCashAmt));?></strong></td>
</tr>-->
<?php //}?>
<!--<tr>			
	<td align="right" colspan="9"><strong>Grand Total Amount</strong></td>
	<td align="center"><strong><?php echo $this->Number->currency(ceil($getTotalAmt));?></strong></td>
</tr>-->
<?php }else{?>
<tr>
<td colspan="10" align="center" style='background:#B4DFF7;'>No Record Found.</td>
</tr>
<?php }?>
</table>