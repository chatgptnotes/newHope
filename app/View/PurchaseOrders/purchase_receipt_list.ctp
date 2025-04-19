
<div class="inner_title">
	<h3>
		<?php echo __('Purchase Orders list', true); ?>
	</h3><span>
		<?php
			echo $this->Html->link(__('Add Purchase Order'),array('controller'=>'PurchaseOrders','action'=>'add_order'), array('escape' => false,'class'=>'blueBtn'));
		?>
		
		<?php
			echo $this->Html->link(__('Back'),array('controller'=>'Pharmacy','action'=>'department_store'), array('escape' => false,'class'=>'blueBtn'));
		?>
	</span>
	<div class="clr ht5"></div>
</div>
<div class="clr ht5"></div>
<?php if(!empty($orders)) { ?>


<table width="100%" cellpadding="0" cellspacing="1" border="0" class="table_format" id="item-row">
	<thead>	
		<tr>
			<th width="40" align="center" valign="top" style="text-align: center;">Sr.No.</th>
			<th width="150" align="center" valign="top" style="text-align: center;">Purcahse Order No.</th>
			<th width="120" align="center" valign="top" style="text-align: center;">Supplier</th>
			<th width="60" valign="top" style="text-align: center;">Type</th>
			<th width="80" align="center" valign="top" style="text-align: center;">Status</th>
			<th width="60" valign="top" style="text-align: center;">Contract</th>
			<th width="60" valign="top" style="text-align: center;">Date</th>
			<th width="60" valign="top" style="text-align: center;">Action</th>
		</tr>
	</thead>
	
	<tbody>
		<?php $count = 0; foreach($orders as $purchase) { $count++; ?>
		<tr class="row_gray">
		
			<td> <?php echo $count; ?> </td>
			
			<td> <?php echo $purchase['PurchaseOrder']['purchase_order_number']; ?> </td>
			
			<td> <?php echo $purchase['InventorySupplier']['name']; ?> </td>
			
			<td> <?php echo $purchase['PurchaseOrder']['type']; ?> </td>
			
			<td> <?php echo $purchase['PurchaseOrder']['status']; ?> </td>
			
			<td> <?php if(isset($purchase['PurchaseOrder']['contract_id'])) echo "Yes"; else echo "No"; ?> </td>
			
			<td> <?php echo $this->DateFormat->formatDate2Local($purchase['PurchaseOrder']['create_time'],Configure::read('date_format'),true); ?> </td>
			
			<td> <?php echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('alt' => __('Edit Item', true),'title' => __('Edit Item', true))),array('action'=>'#'), array('escape' => false));?> </td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<?php } else { echo "Sorry, there is no any Purchase Order placed"; }?>

<div class="clr ht5"></div>
