<?php
	echo $this->Html->script(array('inline_msg','jquery.selection.js','jquery.fancybox-1.3.4','jquery.blockUI','jquery.contextMenu'));
?>

<?php
//header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
//header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
//header ("Content-Disposition: attachment; filename=\"TOR_report_".date('d-m-Y').".xls");
header ("Content-Disposition: attachment; filename=\"Current Stock ".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls");
header ("Content-Description: Current Stock" );
ob_clean();
flush();
?>



		<table width="100%" class="tabularForm" cellpadding="0" cellspacing="0" border="1" >
			<tr class='row_title'> 
			   <td colspan="11" width="100%" height='30px' align='center' valign='middle'>
			   		<h2><?php echo __('Current Stock'); ?></h2>
			   </td>
	  		</tr>
				<tr>
					<thead>
					
						<th width="5px" valign="top" style="text-align:center;">SNo.</th>
						<th width="70px" valign="top" style="text-align:center;">Item Name</th>
						<th width="60px" valign="top" style="text-align:center;">Cur.Stock</th>
						<th width="65px" valign="top" style="text-align:center;">ToatalC</th>
						<th width="60px" valign="top" style="text-align:center;">BatchNo.</th>
						<th width="65px" valign="top" style="text-align:center;">ExpiryDate</th>
						<th width="60px" valign="top" style="text-align:center;">ReOrder</th>
						<th width="60px" valign="top" style="text-align:center;">PurPrice</th>
						<th width="51px" valign="top" style="text-align:center;">MRP</th>
						<th width="65px" valign="top" style="text-align:center;">TotalPrice</th>
						<th width="51px" valign="top" style="text-align:center;">TotalSale</th>
					
					</thead>
				</tr>
				<?php 
					$i=0;
					foreach ($record as $records){
					$i++;	
				?>
				<tr>
					<td align="center"><?php echo $i;?></td>
					<td align="center"><?php echo $records['Product']['name'];?></td>
					<td align="center"><?php echo $records['PurchaseOrderItem']['stock_available'];?></td>
					<td align="center"><?php echo $records['Product']['maximum'];?></td>
					<td align="center"><?php echo $records['PurchaseOrderItem']['batch_number'];?></td>
					<td align="center"><?php echo $records['PurchaseOrderItem']['expiry_date'];?></td>
					<td align="center"><?php echo $records['Product']['reorder_level'];?></td>
					<td align="center"><?php echo $records['PurchaseOrderItem']['purchase_price'];?></td>
					<td align="center"><?php echo $records['PurchaseOrderItem']['mrp'];?></td>
					<td align="center"><?php echo $records['PurchaseOrderItem']['amount'];?></td>
					<td align="center"><?php echo '0.00';?></td>
				</tr>
				<?php }?>
			</table>
		
	
	

<script>

	 			
</script>
		