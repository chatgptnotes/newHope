<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment;  filename=\"Party_wise_purchase_report".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true)
.".xls");
header ("Content-Description: Party wise purchase Report" );
ob_clean();
flush();
?>
 

<table width="100%" cellpadding="0" cellspacing="1" border="1" class="table_format">
 <tr style='background:#3796CB;color:#FFFFFF;'>
				<td colspan = "5" align="center"><strong><?php echo ucfirst($getLocName);?></strong></td>
			  </tr>
			  <tr>
				<td colspan = "5" align="center"><strong><?php echo ucfirst($getLocAdd1).' '.ucfirst($getLocAdd2).' '.ucfirst($location_zipcode).','.ucfirst($location_country);?></strong></td>
			  </tr>
			  
	<tr>
	<td colspan = "5" align="center"><strong>Party Wise Purchase Report</strong></td>
	</tr>
	<tr style='background:#3796CB;color:#FFFFFF;'>
	     <th width="6%"  align="center" style="text-align:center;">Sr.No.</th>
		<th width="25%"  align="center" style="text-align:center;"> Name Of Supplier</th>

		<th width="25%"  align="center" style="text-align:center;"> Product Name</th>
		<th width="25%"  align="center" style="text-align:center;"> Purchase Price</th>
		<th width="25%"  align="center" style="text-align:center;"> Mrp</th>

		<th width="23%"  align="center"  style="text-align:center;"> Bill NO</th>
		<th width="23%"  align="center"  style="text-align:center;"> Total amount</th>		
	    <th width="23%"  align="center"  style="text-align:center;"> Date</th>
	</tr>
	<?php 
		$i=1; 
		foreach($reports as $result){ 
		$total = $result['PurchaseOrder']['net_amount'];
		$val1 = $val1 + $total;
	 ?>
		<tr <?php if($i%2 == 0) echo "style='background:#E5F4FC;'"; ?>>
    		<td align="center" style="text-align:center;">
    			<?php echo $i;?>
    		</td>
			<td align="center" style="text-align:center;">
				<?php echo $result['InventorySupplier']['name']; ?>
		    </td>
		    <td align="center" style="text-align:center;">
				<?php echo $result['Product']['name']; ?>
		    </td>
		    <td align="center" style="text-align:center;">
				<?php echo $result['PurchaseOrderItem']['purchase_price']; ?>
		    </td>
		    <td align="center" style="text-align:center;">
				<?php echo $result['PurchaseOrderItem']['mrp']; ?>
		    </td>
		    
			<td align="center"	style="text-align:center;">
			     	<?php echo $result['PurchaseOrder']['party_invoice_number']; ?>
		     </td>
			     	
		    <td align="center"	style="text-align:center;">
			     	<?php echo $result['PurchaseOrder']['net_amount'];  ?>
			 </td>
	     
			<td align="center"  style="text-align: center;">
				<?php $date = $this->DateFormat->formatDate2Local($result['PurchaseOrder']['order_date'],Configure::read('date_format'));
				     echo $date;  ?>
			   </td>
	  </tr> 
	<?php   $i++;}  ?>
	<tr style='background:#3796CB;color:yellow;'>
	<td  align="center"  style="text-align: center;font-weight:bold;" colspan="3">Total Amount Receivable </td>	 
   <td align="center" style="text-align: center; font-weight:bold;"> <?php echo  round($val1);?></td>
   <td align="center" style="text-align: center; font-weight:bold;"></td>
   </tr>
</table>
