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
		<th width="10%" align="center" style="text-align:center;">  <?php echo __("Batch No."); ?></th>
		<th width="8%" align="center" style="text-align:center;">  <?php echo __("Vat of Class"); ?></th>		 
		<th width="8%" align="center"  style="text-align: center;"><?php echo __("Purchase Vat"); ?></th>
		<th width="8%" align="center"  style="text-align: center;"><?php echo __("Purchase Sat"); ?></th>
		<th width="8%" align="center"  style="text-align: center;"><?php echo __("Purchase Qty"); ?></th>
		<th width="8%" align="center"  style="text-align: center;"><?php echo __("Amount"); ?></th>
		<th width="8%" align="center"  style="text-align: center;"><?php echo __("Vat Amt."); ?></th>
		<th width="8%" align="center"  style="text-align: center;"><?php echo __("Net Amt."); ?></th>
	    <th width="12%" align="center"  style="text-align: center;"><?php echo __("Purchase Date"); ?></th>		 
	</tr>
	</thead>
	
	<tbody>
		<?php $count = 0; foreach($result as $data){ $count++;?>
		<tr>
			<td style="text-align:center;"><?php echo $count; ?></td>
			<td style="text-align:center;"><?php echo $data['Product']['name']; ?></td>
			<td style="text-align:center;"><?php echo $data['PurchaseOrderItem']['batch_number']; ?></td>
			<td style="text-align:center;"><?php echo $data['VatClass']['vat_of_class']; ?></td>
			<td style="text-align:center;"><?php echo $vatPercent = $data['VatClass']['vat_percent']; ?></td>
			<td style="text-align:center;"><?php echo $satPercent = $data['VatClass']['sat_percent']; ?></td>
			<td style="text-align:center;"><?php echo $qty = $data['PurchaseOrderItem']['quantity_received']; ?></td>
			<td style="text-align:center;"><?php echo $amount = $data['PurchaseOrderItem']['purchase_price'] * $qty; ?></td>
			<td style="text-align:center;"><?php echo $vatAmount = ($amount * ($vatPercent + $satPercent)) / 100; ?></td>
			<td style="text-align:center;"><?php echo $netAmount = $amount + $vatAmount; ?></td>
			<td style="text-align:center;"><?php echo $this->DateFormat->formatDate2Local($data['PurchaseOrder']['received_date'],Configure::read('date_format'),true); ?></td>
		</tr>
		<?php } //end of foreach?>
	</tbody>
</table>