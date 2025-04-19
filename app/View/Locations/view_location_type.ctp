<div class="inner_title">
	<h3>
		<div style="float: left">
			&nbsp;
			<?php echo __('View Store Location Details'); ?>
		</div>
		<div style="float: right;">
			<?php
			echo $this->Html->link(__('Back to List'), array('controller'=>'Locations','action' => 'storeLocation'), array('escape' => false,'class'=>'blueBtn'));
			?>
		</div>
	</h3>
	<div class="clr"></div>
</div>

<table border="0" class="table_view_format" cellpadding="0"
	cellspacing="0" width="550" align="center">
	<tr class="first">
		<td class="row_format"><strong> <?php echo __('Location Type')?>
		
		</td>
		<td class="row_format"><?php echo $locationType['LocationType']['name']; ?>
		</td>
	</tr>
	<tr>
		<td class="row_format"><strong> <?php echo __('Stock Rule');  ?>
		
		</td>
		<td class="row_format"><?php  echo $stockRule[$locationType['LocationType']['stock_rule']]; ?>
		</td>
	</tr>
	<tr class="row_gray">
		<td class="row_format"><strong> <?php echo __('Restock Rule');  ?>
		
		</td>
		<td class="row_format"><?php  echo $reStockRule[$locationType['LocationType']['restock_rule']]; ?>
		</td>
	</tr>
	<tr>
		<td class="row_format"><strong> <?php echo __('Transient Assignment Rule');  ?>
		
		</td>
		<td class="row_format"><?php  echo $transientAssignmentRule[$locationType['LocationType']['transient_assignment_rule']]; ?>
		</td>
	</tr>
	<tr class="row_gray">
		<td class="row_format"><strong> <?php echo __('Product Assignment Rule');  ?>
		
		</td>
		<td class="row_format"><?php echo $productAssignmentRule[$locationType['LocationType']['product_assignment_rule']]; ?>
		</td>
	</tr>
	<tr>
		<td class="row_format"><strong> <?php echo __('Inventory Type');  ?>
		
		</td>
		<td class="row_format"><?php  echo $inventoryType[$locationType['LocationType']['inventory_type']];?>
		</td>
	</tr>
	<tr class="row_gray">
		<td class="row_format"><strong> <?php echo __('Consignment Type');  ?>
		
		</td>
		<td class="row_format"><?php echo $consignmentType[$locationType['LocationType']['consignment_type']]; ?>
		</td>
	</tr>
	<tr>
		<td class="row_format"><strong> <?php echo __('Account');  ?>
		
		</td>
		<td class="row_format"><?php  echo ucfirst($locationType['Account']['name']);?>
		</td>
	</tr>
	<tr class="row_gray">
		<td class="row_format"><strong> <?php echo __('Description');  ?>
		
		</td>
		<td class="row_format"><?php 
		echo $locationType['LocationType']['description'];
		?>
		</td>
	</tr>
</table>
