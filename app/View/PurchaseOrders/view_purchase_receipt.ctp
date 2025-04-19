<div class="inner_title">
	<h3>
		<?php echo __('Goods Received Item List', true); ?>
	</h3>
	<span>
		<?php
			echo $this->Html->link(__('Back'),array('controller'=>'PurchaseOrder','action'=>'purchase_receipt_list'), array('escape' => false,'class'=>'blueBtn'));
		?>
	</span>
	<div class="clr ht5"></div>
</div>
<div class="clr ht5"></div>

<table width="" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td class="tdLabel2"><font style="font-weight:bold;">Purchase Order Number:</font> <?php echo $PurchaseOrder['PurchaseOrder']['purchase_order_number'];?></td>
		<td class="tdLabel2" width="30">&nbsp;</td>
		<td class="tdLabel2"><font style="font-weight:bold;">Supplier:</font> <?php echo $PurchaseOrder['InventorySupplier']['name'];?> </td>
		<td class="tdLabel2" width="30">&nbsp;</td>
		<td class="tdLabel2"><font style="font-weight:bold;">Type:</font> <?php echo $PurchaseOrder['PurchaseOrder']['type'];?> </td>
		<td class="tdLabel2" width="30">&nbsp;</td>
		<td class="tdLabel2"><font style="font-weight:bold;">Status:</font> <?php echo $PurchaseOrder['PurchaseOrder']['status'];?> </td>
		<td class="tdLabel2" width="30">&nbsp;</td>
		<td class="tdLabel2"><font style="font-weight:bold;">Date of Order:</font> <?php echo $this->DateFormat->formatDate2Local($PurchaseOrder['PurchaseOrder']['create_time'],Configure::read('date_format'),true); ?> </td>
		<td class="tdLabel2" width="30">&nbsp;</td>
		<td class="tdLabel2"><font style="font-weight:bold;">Date of Received:</font> <?php echo $this->DateFormat->formatDate2Local($PurchaseOrder['PurchaseOrder']['create_time'],Configure::read('date_format'),true); ?> </td>
	</tr>
</table>

<div class="clr ht5"></div>

<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm" id="item-row">
	<thead>	
		<tr>
			<th width="40" align="center" valign="top" style="text-align: center;">Sr.No.</th>
			<th width="150" align="center" valign="top" style="text-align: center;">Item Name</th>
			<th width="120" align="center" valign="top" style="text-align: center;">Manufacturer</th>
			<th width="60" valign="top" style="text-align: center;">Pack</th>
			<th width="80" align="center" valign="top" style="text-align: center;">Batch Number</th>
			<th width="60" valign="top" style="text-align: center;">Expiry Date</th>
			<th width="60" valign="top" style="text-align: center;">Purchase Price</th>
			<th width="60" valign="top" style="text-align: center;">MRP</th>
			<th width="60" valign="top" style="text-align: center;">Selling Price</th>
			<th width="60" valign="top" style="text-align: center;">Quantity Ordered</th>
			<th width="60" valign="top" style="text-align: center;">Quantity Received</th>
			<th width="60" valign="top" style="text-align: center;">Amount</th>
		</tr>
	</thead>
	
	<tbody>
		<?php $count = 0; $total=0; foreach($items as $item) { $count++; ?>
		<tr class="ho">
		
			<td>
				<?php echo $count; ?>
			</td>
			
			<td>
				<?php echo $item['Product']['name']; ?>
			</td>
			
			<td>
				<?php echo $item['ManufacturerCompany']['name']; ?>
			</td>
			
			<td>
				<?php echo $item['Product']['pack']; ?>
			</td>
			
			<td>
				<?php echo $item['PurchaseOrderItem']['batch_number']; ?>
			</td>
			
			<td style="text-align:center">
				<?php echo $item['PurchaseOrderItem']['expiry_date']; ?>
			</td>
			
			<td style="text-align:center">
				<?php echo $item['PurchaseOrderItem']['purchase_price']; ?>
			</td>
			
			<td style="text-align:center">
				<?php echo $item['PurchaseOrderItem']['mrp']; ?>
			</td>
			
			<td style="text-align:center">
				<?php echo $item['PurchaseOrderItem']['selling_price']; ?>
			</td>
			
			<td style="text-align:center">
				<?php echo $item['PurchaseOrderItem']['quantity_order']; ?>
			</td>
			
			<td style="text-align:center">
				<?php echo $item['PurchaseOrderItem']['quantity_received']; ?>
			</td>
			
			<td style="text-align:right">
				<?php echo $total = $total + ($item['PurchaseOrderItem']['purchase_price'] * $item['PurchaseOrderItem']['quantity_received']); ?>
			</td>
			<?php //$total = $total + $item['PurchaseOrderItem']['amount']; ?>
		</tr>
		<?php } ?>
		
		<tr>
			<td align="right" colspan="11">
				<?php echo __("Total Amount");?>
			</td>

			<td align="right">
				<?php echo $total;?>
			</td>
		</tr>
	</tbody>
</table>

<div class="btns">
	<?php
		echo $this->Html->link(__('Back'),array('controller'=>'PurchaseOrders','action'=>'purchase_order_list'), array('escape' => false,'class'=>'blueBtn'));
	?>
</div>

