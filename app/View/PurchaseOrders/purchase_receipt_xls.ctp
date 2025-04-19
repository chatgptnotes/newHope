<?php if($this->params->pass[0]=='Print'){?>
<table border="0" class="" cellpadding="0" cellspacing="0" width="100%" style="padding-left:30px;" align="center" >
<tr>
<td colspan="4" align="right">
<div id="printButton">
			  <?php echo $this->Html->link(__('Print', true),'#', array('escape' => false,'class'=>'blueBtn','onclick'=>'window.print();'));?>
			 </div>
		</td>
	</tr>
</table>
<?php } if(!empty($PurchaseOrder)) { ?>

<table width="100%" cellpadding="0" cellspacing="1" border="1" class="tabularForm" id="item-row">
	<thead>	
		<tr class="row_title">
			<td width="1%"  align="center" valign="top" style="text-align: center;" ><b>Sr.No</b></td>
			<td width="10%" align="center" valign="top" style="text-align: center;" ><b>GRN No.</b></td>
			<td width="10%" align="center" valign="top" style="text-align: center;" ><b>PO No.</b></td>
			<td width="10%" align="center" valign="top" style="text-align: center;" ><b>GRN For</b></td>
			<td width="10%" align="center" valign="top" style="text-align: center;" ><b>Party Invoice No</b></td>
			<td width="30%" align="center" valign="top" style="text-align: center;" ><b>Supplier</b></td>
			<td width="15%" align="center" valign="top" style="text-align: center;" ><b>Amount</b></td> 
			<td width="20%" align="center" valign="top" style="text-align: center;" ><b>Received Date</b></td>
		</tr>
	</thead>
	
	<tbody>
	<?php $count = 1?>
		<?php  foreach($PurchaseOrder as $purchase) { 
			 ?>
		<tr>
		
			<td class="text_center ">
				<?php echo $count; ?>
			</td>
			
			<td class="text_center " align="center">
				<?php echo $purchase['PurchaseOrderItem']['grn_no']; ?>
			</td>
			
			<td class="text_center " align="center"> 
				<?php echo $purchase['PurchaseOrder']['purchase_order_number']; ?>
			</td>
			
			<td class="text_center " align="center">
				<?php echo ($purchase['StoreLocation']['name']); ?>
			</td>
			
			<td class="row_format" align="center">
					<?php echo $purchase['PurchaseOrderItem']['party_invoice_number']; ?>
			</td>
				
			<td class="row_format" align="center">
				<?php echo $purchase['InventorySupplier']['name']; ?>
			</td>
			
			<td class="row_format" align="center">
			<?php 
				if($purchaseReturn[$purchase['PurchaseOrderItem']['grn_no']]){ 
				  	$total = $purchase[0]['sum']-$purchaseReturn[$purchase['PurchaseOrderItem']['grn_no']];
				}else{
					$total = $purchase[0]['sum'];
				}

				echo number_format($total,2); 
				$amountTotal +=  (float) $total;?>
			</td>
			
			<td class="text_center row_format" align="center">
				<?php echo $this->DateFormat->formatDate2Local($purchase['PurchaseOrderItem']['received_date'],Configure::read('date_format'),true); ?>
			</td>
			
		</tr>
		<?php  $count++; } ?>
		<tr><td colspan="6" style="text-align: center"><b>TOTAL</b></td>
		<td style="text-align: center" ><b> <?php echo $total=$this->Number->currency($amountTotal);?></b></td><td></td></tr>
	</tbody>
</table>

	
<?php } else { echo "<table width='100%'><tr><td align='center'><strong>No Record Found..!!</strong></td></tr></table>"; }?>

