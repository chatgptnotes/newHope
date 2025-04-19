<div class="inner_title">
	<h3>
		<?php echo __('Purchase Order Item List', true); ?>
	</h3>
	<span>
		<?php
			echo $this->Html->link(__('Back'),array('controller'=>'PurchaseOrder','action'=>'purchase_order_list'), array('escape' => false,'class'=>'blueBtn'));
		?>
	</span>
	<div class="clr ht5"></div>
</div>
<div class="clr ht5"></div>

<table width="" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td class="tdLabel2"><font style="font-weight:bold;">Purchase Order Number:</font> <?php echo $PurchaseOrder['PurchaseOrder']['purchase_order_number'];?></td>
		<td class="tdLabel2" width="30">&nbsp;</td>
		<td class="tdLabel2"><font style="font-weight:bold;">Purchase Order For:</font><?php echo ($PurchaseOrder['StoreLocation']['name']);?></td>
		<td class="tdLabel2" width="30">&nbsp;</td>
		<td class="tdLabel2"><font style="font-weight:bold;">Supplier:</font> <?php echo $PurchaseOrder['InventorySupplier']['name'];?> </td>
		<td class="tdLabel2" width="30">&nbsp;</td>
		<td class="tdLabel2"><font style="font-weight:bold;">Status:</font> <?php echo $PurchaseOrder['PurchaseOrder']['status'];?> </td>
		<td class="tdLabel2" width="30">&nbsp;</td>
		<td class="tdLabel2"><font style="font-weight:bold;">Date of Order:</font> <?php echo $this->DateFormat->formatDate2Local($PurchaseOrder['PurchaseOrder']['create_time'],Configure::read('date_format'),true); ?> </td>
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
			<th width="60" valign="top" style="text-align: center;">MRP</th>
			<th width="60" valign="top" style="text-align: center;">Purchase Price</th>
			<?php if(strtolower($this->Session->read('website.instance')) == 'kanpur'){ ?> 
			<th width="60" valign="top" style="text-align: center;">Vat of Class</th>
			<?php } else if(strtolower($this->Session->read('website.instance')) == 'hope') { ?>
			<th width="60" valign="top" style="text-align: center;">Tax</th>
			<?php }?>
			<th width="60" valign="top" style="text-align: center;">Quantity Ordered</th>
			<th width="60" valign="top" style="text-align: center;">Amount</th>
		</tr>
	</thead>
	
	<tbody>
		<?php $count = 0; $total=0; $totalVat = 0; foreach($items as $item) { $count++; ?>
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
				<?php  echo $purchase_price = $item['PurchaseOrderItem']['mrp']; ?>
			</td>
			
			<td style="text-align:center">
				<?php  echo $purchase_price = $item['PurchaseOrderItem']['purchase_price']; ?>
			</td>
			<?php $qty =  $item['PurchaseOrderItem']['quantity_order']; 
				if(strtolower($this->Session->read('website.instance')) == 'kanpur'){ ?> 
			<td style="text-align:center">
			<?php echo $item['VatClass']['vat_of_class'];
					$vat = $item['VatClass']['sat_percent'] + $item['VatClass']['vat_percent'];
					$vatAmt = ($qty * $purchase_price * $vat) /100;
					$totalVat += $vatAmt; ?>
			</td>
			<?php } else if(strtolower($this->Session->read('website.instance')) == 'hope') { ?>
			<td style="text-align:center">
			<?php echo $tax = $item['PurchaseOrderItem']['tax'];
					$vatAmt = ($qty * $purchase_price * $tax) /100;
					$totalVat += $vatAmt; ?>
			</td>
			<?php }?> 
			
			<td style="text-align:center">
				<?php echo $qty; ?>
			</td>
			
			<td style="text-align:right">
				<?php echo number_format(round($item['PurchaseOrderItem']['amount']),2); ?>
			</td>
			<?php $total = $total + $item['PurchaseOrderItem']['amount']; ?>
		</tr>
		<?php } 
		
		if(strtolower($this->Session->read('website.instance')) == 'vadodara') $colspan = 8; else $colspan = 9; ?>
		<tr>
		<td colspan="<?php echo $colspan; ?>" valign="middle" align="right">
			<table style="text-align:right" align="right">
				<tr>
					<td>
						<?php echo __('Total Amount');?>
					</td>
				</tr>
				<?php if(strtolower($this->Session->read('website.instance')) != 'vadodara'){ ?> 
				<tr>
					<td>
						<?php echo __('Total Tax');?>
					</td>
				</tr>
				
				<tr>
					<td>
						<?php echo __('Net Amount');?>
					</td>					
				</tr>
				<?php }?>
			</table>
		</td>
		
		<td>
			<table style="text-align:right" align="right">
				<tr>
					<td align="right" style="text-align: right;" class="total" id="total">
					<?php echo number_format(round($total),2);?>
					</td>
				</tr>
				<?php if(strtolower($this->Session->read('website.instance')) != 'vadodara'){ ?> 
				<tr>
					<td align="right"  style="text-align: right;" class="Tvat" id="Tvat">
					<?php echo number_format(round($totalVat),2); ?>
					</td>
				</tr>
				
				<tr>
					<td align="right" style="text-align: right;" class="Tnet" id="Tnet">
					<?php echo number_format(round($total + $totalVat),2);?>
					</td>
				</tr>
				<?php }?>
			</table>	
		</td>
		</tr>
	</tbody>
</table>

<div class="btns">
	<?php
		echo $this->Html->link(__('Back'),array('controller'=>'PurchaseOrders','action'=>'purchase_order_list'), array('escape' => false,'class'=>'blueBtn'))
		."&nbsp;";
		//echo $this->Html->link(__('Print'),array('controller'=>'PurchaseOrders','action'=>'purchase_order_list',$PurchaseOrder['PurchaseOrder']['id']), array('escape' => false,'class'=>'blueBtn'));
		
		echo $this->Html->link('Print','javascript:void(0)',array('escape' => false,'class'=>'blueBtn printButton','onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'PurchaseOrders','action'=>'printPurchaseOrder',
$PurchaseOrder['PurchaseOrder']['id']))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200'); return false;"));
		
	?>
</div>

