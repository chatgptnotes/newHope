<?php 
 header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"pharmacy_".$for."_".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls" );
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
				<td colspan = "10" align="center"><strong>Pharmacy <?php echo ucfirst($for);?> Report</strong></td>
			  </tr>
			  <tr >
				<td colspan = "10" align="center"><strong><?php echo $this->DateFormat->formatDate2Local($from,Configure::read('date_format'), false); ?></strong> to <strong><?php echo $this->DateFormat->formatDate2Local($to,Configure::read('date_format'), false);?></strong></td>
			  </tr>
			  <tr>
			   		<td height="30px" align="center" valign="middle" width="6%"><strong><?php echo __('Sr. No.'); ?></strong></td> 
			  	   	<td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Date'); ?></strong></td> 
				   	<td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Bill Code'); ?></strong></td>					  
				   	<td height="30px" align="center" valign="middle" width="19%"><strong><?php echo __('Patient Name'); ?></strong></td>  
				   	<td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Sale By'); ?></strong></td>				  
 					<td height="30px" align="center" valign="middle" width="15%"><strong><?php echo __('Payment Mode'); ?></strong></td>
 					<td height="30px" align="center" valign="middle" width="5%"><strong><?php echo __('Billed  Amount'); ?></strong></td> 
 					<td height="30px" align="center" valign="middle" width="5%"><strong><?php echo __('Discount (%)'); ?></strong></td> 
 					<td height="30px" align="center" valign="middle" width="5%"><strong><?php echo __('Discount (Amount)'); ?></strong></td> 
 					<td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Amount'); ?></strong></td> 
			   </tr>
			<?php 
			
				  $getTotalDiscountPer=0;
				  $totalDiscountAmt=0;
				  $getTotalFinalAmt=0;
				if(count($reports)>0) {
			    $k = 1; 
					$cnt=1;
	      		foreach($reports as $report){
					$getTotalDiscountPer=$getTotalDiscountPer+round(($report['PharmacySalesBill']['discount']*100)/$report['PharmacySalesBill']['total']);
					$totalDiscountAmt=$totalDiscountAmt+$report['PharmacySalesBill']['discount'];?>
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
							<td align='center' height='17px'><?php echo $report['User']['first_name']." ".$report['User']['last_name']; ?></td>		
							<td align='center' height='17px'><?php echo $report['PharmacySalesBill']['payment_mode']; ?></td>
							<td align='center' height='17px'><?php echo number_format($report['PharmacySalesBill']['total'], 2); ?></td>
							<td align='center' height='17px'><?php echo round(($report['PharmacySalesBill']['discount']*100)/$report['PharmacySalesBill']['total']);
							 ?>%</td>						
							<td align='center' height='17px'><?php echo number_format($report['PharmacySalesBill']['discount'], 2); ?></td>
							
							<td align='center' height='17px'><?php 
						/*	if(empty($report['PharmacySalesBill']['paid_amnt'])){
							$report['PharmacySalesBill']['paid_amnt']=$report['PharmacySalesBill']['total'];
							}*/
							$getAmount=$report['PharmacySalesBill']['total']-$report['PharmacySalesBill']['discount'];
							$getTotalFinalAmt=$getTotalFinalAmt+round($getAmount);
							echo round($getAmount); ?></td>
						</tr>
						<?php if($showItem){?>
					<tr>
						<td align="left" colspan="10">
							<table width="100%" align="center" border="1">
								<tr>
								<td align='center' width="6%">Sr.No.</td>
									<td align='center' width="20%">Item</td>
									<td align='center' width="18%">Code</td>
									<td align='center' width="18%">Quantity</td>
									<td align='center' width="18%">Batch</td>
									<td align='center' width="18%">Expiry Date</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									</tr>
								<?php $inc=1;
										
									foreach($report['PharmacySalesBillDetail'] as $key=>$value){
											?>
										<tr>
												<td align='center'><?php echo $inc;?></td>
												<td align='center'><?php echo $value['item'];?></td>
												<td align='center'><?php echo $value['code'];?></td>
												<td align='center'><?php echo $value['qty'];?></td>
												<td align='center'><?php echo $value['batch_number'];?></td>
												<td align='center'><?php echo $this->DateFormat->formatDate2Local($value['expiry_date'],Configure::read('date_format'));?></td>
 												<td></td>
 												<td></td>
 												<td></td>
 												<td></td>
										</tr>
									<?php $inc++;
										}
								?>
							</table>
						</td>
					</tr>
					<?php }?>
					<!-- <tr style='background:#C4E9FC;'><td colspan="7"></td></tr> -->
			<?php $cnt++;
				}
				
			
?>	
<tr>
	<td align="center" colspan="6"><strong></strong></td>
	<td align="center"><strong><?php echo $this->Number->currency(ceil($totalAmt));?></strong></td>
	<td align="center"><strong></strong></td>
	<td align="center"><strong><?php echo $this->Number->currency(ceil($totalDiscountAmt));?></strong></td>
	<td align="center"><strong><?php echo $this->Number->currency(ceil($getTotalFinalAmt));?></strong></td>
</tr>
<?php if($flagCredit){?>
<tr>
	
	<td align="right" colspan="9"><strong>Total Credit Amount</strong></td>
	<td align="center"><strong><?php echo $this->Number->currency(ceil($totalCreditAmt));?></strong></td>
</tr>
<?php }if($flagCash){?>
<tr>
	<td  align="right" colspan="9"><strong>Total Cash Amount</strong></td>
	<td align="center"><strong><?php echo $this->Number->currency(ceil($totalCashAmt));?></strong></td>
</tr>
<?php }?>
<tr>			
	<td align="right" colspan="9"><strong>Grand Total Amount</strong></td>
	<td align="center"><strong><?php echo $this->Number->currency(ceil($getTotalAmt));?></strong></td>
</tr>
<?php }else{?>
<tr>
<td colspan="10" align="center" style='background:#B4DFF7;'>No Record Found.</td>
</tr>
<?php }?>
</table>