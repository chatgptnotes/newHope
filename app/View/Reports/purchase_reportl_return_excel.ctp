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
   .table_format{
   		text-align:left;
   		padding-top:50px;
   }
   .row_title{
		background: #ddd;
	}
	.rowColor{
   		background-color:gray;
   		border-bottom-color: black;
   }
</STYLE>
<table border="1" class="table_format"  cellpadding="2" cellspacing="0" width="100%" >	
			  <tr class="row_title">
				<td colspan = "5" align="center"><h2>Pharmacy <?php echo ucfirst($for);?> Report</h2></td>
			  </tr>
			  <tr class="row_title">
				<td colspan = "5" align="center"><strong><?php echo $this->DateFormat->formatDate2Local($from,Configure::read('date_format'), false); ?></strong> to <strong><?php echo $this->DateFormat->formatDate2Local($to,Configure::read('date_format'), false);?></strong></td>
			  </tr>
			  <tr class="row_title">
				  	<td height="10px" align="center" valign="middle" width="12%"><strong>Sr. No.</strong></td>				  
				   <td height="30px" align="left" valign="middle" ><strong><?php echo __('Supplier Name'); ?></strong></td>  
				   <td height="30px" align="center" valign="middle" ><strong><?php echo __('Return By'); ?></strong></td>
				   <td height="30px" align="center" valign="middle"  ><strong><?php echo __('Date'); ?></strong></td> 
						<td height="30px" align="center" valign="middle"  ><strong><?php echo __('Total Amount'); ?></strong></td> 
			   </tr>
			   
		<?php  
			
	  		if(count($reports)>0) {
			   $k = 1; 
			
	      		foreach($reports as $report){	
									
					?>
					<tr>		
						 <td align='center' height='17px'><?php echo  $k; ?></td>	
 					    <td align='left' height='17px'><?php echo $report['InventorySupplier']['name']; ?></td>
					    <td align='center' height='17px'><?php echo $report['Initial']['name']." ".$report['User']['first_name']." ".$report['User']['last_name']; ?></td>  
						<td align='center' height='17px'><?php echo $this->DateFormat->formatDate2Local($report['InventoryPurchaseReturn']['create_time'],Configure::read('date_format')); ?></td>
					   
						<td align='center' height='17px'><?php echo number_format($report['InventoryPurchaseReturn']['total_amount'],2); ?></td> 
					</tr>
					<tr>
						<td align="left" width="100%" colspan="9">
							<table width="100%" align="center" style="background-color: #ddd">
								<tr class="rowColor">
									<td align='center'>Item</td>	<td align='center'>Code</td>	<td align='center'>Quantity</td>	<td align='center'>Batch</td>
									<td align='center'>Expiry Date</td>	<td align='center'>Price</td>	<td></td> <td></td> <td></td>
										</tr>
								<?php
									foreach($report['InventoryPurchaseReturnItem'] as $key=>$value){?>
										<tr>
												<td align='center'><?php echo $value['item'];?></td>
												<td align='center'><?php echo $value['code'];?></td>
												<td align='center'><?php echo $value['qty'];?></td>
												<td align='center'><?php echo $value['batch_no'];?></td>
												<td align='center'><?php echo $this->DateFormat->formatDate2Local($value['expiry_date'],Configure::read('date_format'), false);?></td>
												<td align='center'><?php echo number_format($value['value'],2);?></td>
												<td></td> <td></td> <td></td>
										</tr>
									<?php }
								?>
							</table>
						</td>
					</tr>
					<tr><td colspan="5"></td> </tr>
					<?php   
				 $k++; 
			   }

			  ?>
			  
				<?php 		  
				 } else {
					?> <tr>
									<td align="center" height="17px" colspan="9" > No Record Found</td>
									
								</tr>
<?php 
				 }
		?>			   
			   
			   
			   
</table>