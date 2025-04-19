
<?php echo $this->Html->css(array('jquery.fancybox-1.3.4.css','jquery.autocomplete.css','colResizable.css'));  
 echo $this->Html->script(array('jquery.fancybox-1.3.4','inline_msg.js','jquery.autocomplete.js','colResizable-1.4.min.js')); ?>
<style>
.tableFoot {
	font-size: 11px;
	color: #b0b9ba;
}

.tabularForm td td {
	padding: 0;
}
element.style {
    min-height: 565px;
}
.top-header {
	background: #3e474a;
	height: 60px;
	left: 0;
	right: 0;
	top: 0px;
	margin-top: 10px;
	position: relative;
}
textarea {
	width: 85px;
}
.tdLabel2 img{ float:none !important;}
</style>

<div class="inner_title">
	<h3 > &nbsp; <?php echo __('Inventory Vat Liability Report', true); ?></h3>
	<span>
	<?php
		echo $this->Html->link(__('Generate Excel Sheet'),array('action'=>'vat_liability_report','inventory'=>true,'?'=>array('flag'=>'excel')), array('escape' => false,'class'=>'blueBtn refund-button'));
		echo $this->Html->link(__('Back'), array('controller'=>'pharmacy','action' => 'pharmacy_report','purchase','inventory'=>true), array('escape' => false,'class'=>'blueBtn'));
   ?></span>
</div>

<div class="clr">&nbsp;</div>
<div id="container">                

<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm labTable resizable sticky" id="item-row" style="top:0px;overflow: scroll;">
	<thead>
	<tr>
	    <th width="2%"  align="center" style="text-align:center;">  <?php echo __("Sr.No"); ?></th>
		<th width="12"% align="center" style="text-align:center;">  <?php echo __("Product Name"); ?></th>
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
			<td><?php echo $data['Product']['name']; ?></td>
			<td><?php echo $data['PurchaseOrderItem']['batch_number']; ?></td>
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