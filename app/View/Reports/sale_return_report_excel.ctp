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
   .row_title{
		background: #ddd;
	}
	 .rowColor{
   		background-color:gray;
   		border-bottom-color: black;
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
			  <tr>
				<td colspan = "10" align="center"><strong><?php echo $this->DateFormat->formatDate2Local($from,Configure::read('date_format'), false); ?></strong> to <strong><?php echo $this->DateFormat->formatDate2Local($to,Configure::read('date_format'), false);?></strong></td>
			  </tr>
			  <tr>
				  <td height="10px" align="center" valign="middle" width="5%"><strong><?php echo __('Sr.No.'); ?></strong></td>	
				   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Bill No.'); ?></strong></td>
				   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Date'); ?></strong></td>	  
				   <td height="30px" align="center" valign="middle" width="15%"><strong><?php echo __('Party Name'); ?></strong></td>  
				   <td height="30px" align="center" valign="middle" width="13%"><strong><?php echo __('Mode'); ?></strong></td> 
				   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Take By'); ?></strong></td>	
				   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Billed Amount'); ?></strong></td> 
				   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Discount (%)'); ?></strong></td> 
				   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Discount (Amount)'); ?></strong></td> 			   
  					<td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Amount'); ?></strong></td> 
			   </tr>
			<?php
			 if(count($reports)>0) {
			    $k = 1; 
			    $totalGrandDis=0;
			    $getGrandAmt=0;
	      		foreach($reports as $report){	
									
					?>
						<tr>
 							<td align='center' height='17px'><?php echo  $k; ?></td>	
 							<?php if($report['InventoryPharmacySalesReturn']['is_deleted'] == 1){?>
 							<td align='center' height='17px'><?php echo $report['InventoryPharmacySalesReturn']['bill_code']." (Deleted)";?></td>
 							<?php }else{?>
 							<td align='center' height='17px'><?php echo $report['InventoryPharmacySalesReturn']['bill_code'];?></td>
 							<?php }?>
 							<td align='center' height='17px'><?php echo $this->DateFormat->formatDate2Local($report['InventoryPharmacySalesReturn']['create_time'],Configure::read('date_format')); ?></td>
 							<td align='center' height='17px'>							
							<?php
								if(empty($report['InventoryPharmacySalesReturn']['patient_id']))
									echo $report['InventoryPharmacySalesReturn']['customer_name'];
								else
									echo $report['Patient']['lookup_name']." (".$report['Patient']['patient_id'].")";
							?> 
							</td>	
							<td align='center' height='17px'><?php echo $report['InventoryPharmacySalesReturn']['payment_mode'];?></td>
							<td align='center' height='17px'><?php echo $report['User']['first_name']." ".$report['User']['last_name']; ?></td>	
							<td align='center' height='17px'><?php 
							if(!empty($report['InventoryPharmacySalesReturn']['total']))
								$getBilledAmt=$report['InventoryPharmacySalesReturn']['total'];
							else
								$getBilledAmt=$totalreturnBilledAmt[$report['InventoryPharmacySalesReturn']['id']];
							echo number_format($getBilledAmt, 2);
							$getGrndBilledAmt=$getGrndBilledAmt+$getBilledAmt; ?></td>
							<td align='center' height='17px'><?php echo round($report['InventoryPharmacySalesReturn']['discount']); ?>%</td>
							<td align='center' height='17px'><?php 
							$getDiscount=$getBilledAmt*($report['InventoryPharmacySalesReturn']['discount']/100);
							$totalGrandDis=$totalGrandDis+$getDiscount;
							echo number_format($getDiscount, 2); ?></td>	
							<td align='center' height='17px'><?php 
							//echo number_format($totalreturnAmt[$report['InventoryPharmacySalesReturn']['id']],2);
							echo round($getBilledAmt-$getDiscount);
							$getGrandAmt=$getGrandAmt+($getBilledAmt-$getDiscount); ?></td>
						</tr>
						<?php if($showItem){?>
					<tr>
						<td align="left" colspan="9">
							<table width="100%" align="center" border="1">
								<tr>
									<td align='center' width="6%">Sr.No.</td>
									<td align='center' width="20%">Item</td>
									<td align='center' width="18%" >Code</td>
									<td align='center' width="17%">Quantity</td>	
									<td align='center' width="17%">Batch</td>
									<td align='center' width="17%">Expiry Date</td> 
									<td align='center' ></td> 
									<td align='center' ></td> 
									<td align='center' ></td> 
										</tr>
								<?php $inc=1;
									foreach($report['InventoryPharmacySalesReturnsDetail'] as $key=>$value){?>
										<tr>
												<td align='center'><?php echo $inc;?></td>
												<td align='center'><?php echo $value['item'];?></td>
												<td align='center'><?php echo $value['code'];?></td>
												<td align='center'><?php echo $value['qty'];?></td>
												<td align='center'><?php echo $value['batch_no'];?></td>
												<td align='center'><?php echo $this->DateFormat->formatDate2Local($value['expiry_date'],Configure::read('date_format'));?></td>
 												<td align='center'></td>
 												<td align='center'></td>
 												<td align='center'></td>
										</tr>
									<?php $inc++;
											}
								?>
							</table>
						</td>
					</tr>
					<?php }?>
					
			<?php
			$k++;
				}
				
			}
?>	

<tr>			
	<td align="right" colspan="6"><strong>Grand Total Amount</strong></td>
	<td align="center"><strong><?php echo $this->Number->currency(ceil($getGrndBilledAmt));?></strong></td>
	<td align="center"><strong></strong></td>
	<td align="center"><strong><?php echo $this->Number->currency(ceil($totalGrandDis));?></strong></td>
	<td align="center"><strong><?php echo $this->Number->currency(ceil($getGrandAmt));?></strong></td>
</tr>
<?php if($this->Session->read('locationid')=='26'){?>
<tr>
	<td align="right" colspan="8"><strong><?php echo __('Cash Return:')?></strong></td>
	<td align="center"><strong>
	<?php
		  $cashFrmSales = $salesData[0][0]['directRefund'];
		  $cashFrmDirect = $frmBilling[0][0]['returnedCash'];
		  $cashReturned = $cashFrmSales+$cashFrmDirect;
		  echo $this->Number->currency(ceil($cashReturned));
	?></strong></td>
	
</tr>
<tr>
	<td align="right" colspan="8"><strong><?php echo __('Credit Return:')?></strong></td>
	<td align="center"><strong>
	<?php $retunedCreditAmnt = $getGrandAmt-$cashReturned;
		  echo $this->Number->currency(ceil($retunedCreditAmnt));
	?></strong></td>
</tr> 
<?php }?>
</table>