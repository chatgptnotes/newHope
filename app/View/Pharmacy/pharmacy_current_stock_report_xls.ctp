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

<!-- <table width="100%" cellpadding="0" cellspacing="1" border="0" class="table_format labTable resizable sticky" id="item-row" style="top:0px;overflow: scroll;"> -->
<table border="1" class="table_format"  cellpadding="2" cellspacing="0" width="100%" style="text-align:left;padding-top:50px;">	
	<thead>
	<tr class="row_title">
	    <th width="2%"  align="center" style="text-align:center;">  <?php echo __("Sr.No"); ?></th>
		<th width="12%" align="center" style="text-align:center;">  <?php echo __("Product Name"); ?></th>
	    <th width="12%" align="center"  style="text-align: center;"><?php echo __("Pack"); ?></th>		 
		<th width="10%" align="center" style="text-align:center;">  <?php echo __("Batch No."); ?></th>
		<th width="8%" align="center"  style="text-align: center;"><?php echo __("Expiry Date"); ?></th>
		<th width="8%" align="center"  style="text-align: center;"><?php echo __("Purchase Price"); ?></th>
		<th width="8%" align="center"  style="text-align: center;"><?php echo __("Sale Price"); ?></th>
		<th width="8%" align="center"  style="text-align: center;"><?php echo __("MRP"); ?></th>
		<th width="8%" align="center"  style="text-align: center;"><?php echo __("Stock"); ?></th>
		<th width="8%" align="center"  style="text-align: center;"><?php echo __("Loose Stock"); ?></th>
		<th width="8%" align="center"  style="text-align: center;"><?php echo __("MSU"); ?></th>
		<th width="8%" align="center"  style="text-align: center;"><?php echo __("Value"); ?></th>
	</tr>
	</thead>
	
	<tbody>
		<?php $count = 0; foreach($result as $data){ $count++;?>
		<tr>
			<td style="text-align:center;"><?php echo $count; ?></td>
			<td style="text-align:center;"><?php echo $data['PharmacyItem']['name']; ?></td>
			<td style="text-align:center;"><?php echo $pack = $data['PharmacyItem']['pack']; ?></td>
			<td style="text-align:center;"><?php echo $data['PharmacyItemRate']['batch_number']; ?></td>
			<td style="text-align:center;"><?php echo $this->DateFormat->formatDate2Local($data['PharmacyItemRate']['expiry_date'],Configure::read('date_format'),true); ?></td>
			<td style="text-align:center;"><?php echo $purchase = $data['PharmacyItemRate']['purchase_price']; ?></td>
			<td style="text-align:center;"><?php echo $sale = $data['PharmacyItemRate']['sale_price']; ?></td>
			<td style="text-align:center;"><?php echo $mrp = $data['PharmacyItemRate']['mrp']; ?></td>
			<td style="text-align:center;"><?php echo $stock = $data['PharmacyItemRate']['stock']; ?></td>
			<td style="text-align:center;"><?php echo $loose_stock = $data['PharmacyItemRate']['loose_stock']; ?></td>
			<td style="text-align:center;"><?php echo $qty = $data[0]['total_stock'];
					$msuPurchase = $purchase / $pack;
					$msuMRP = $mrp / $pack;
					$msuSale = $sale / $pack;
					$value = $msuPurchase * $qty;
					$totalMRP += $msuMRP * $qty;
					$totalSale += $msuSale * $qty;
					$totalPurchase += $msuPurchase * $qty;
					$totalStock += $stock;
					$totalLooseStock += $loose_stock;
					$totalQty += $qty;?></td>
			<td style="text-align:center;"><?php echo $value; $totalValue += $value; ?></td>
		</tr>
		<?php } //end of foreach?>
		<tr>
			<td style="text-align:center;" colspan="5">TOTAL</td>
			<td style="text-align:center;"><?php echo $totalPurchase; ?></td>
			<td style="text-align:center;"><?php echo $totalSale; ?></td>
			<td style="text-align:center;"><?php echo $totalMRP; ?></td>
			<td style="text-align:center;"><?php echo $totalStock; ?></td>
			<td style="text-align:center;"><?php echo $totalLooseStock; ?></td>
			<td style="text-align:center;"><?php echo $totalQty; ?></td>
			<td style="text-align:center;"><?php echo $totalValue; ?></td>
		</tr>
	</tbody>
</table>