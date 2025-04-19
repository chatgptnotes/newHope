<div class="inner_title">
	<h3>
		<?php echo __('Contract', true); ?>
	</h3>
	<span> <?php
	echo $this->Html->link(__('Back'), array('action'=>'index'), array('escape' => false,'class'=>'blueBtn back'));
	?>
	</span>
	<div class="clr ht5"></div>
</div>

<div class="clr ht5"></div>

<?php if(!empty($contracts)) { ?>
<table cellpadding="0" cellspacing="0" border="0">
	<tr>
	<td>
	<table>
		<td class="tdLabel2"><font style="font-weight:bold;">Contract Name: </font> 
			<?php  
				echo $contracts['Contract']['name'];
			?>
		</td>
	
		<td width="20">&nbsp;</td>
		<td class="tdLabel2"><font style="font-weight:bold;">Contract With: </font>
			<?php $cont_type = array(
						'1'=>'Enterprise ('.$this->Session->read("facility").')',
						'2'=>'Company ('.$contracts['Company']['name'].')',
						'3'=>'Facility ('.$contracts['Location']['name'].')');
			
			 if(array_key_exists($contracts['Contract']['contract_type'], $cont_type))
			 {
				echo $cont_type[$contracts['Contract']['contract_type']]; 
			 }
			?>
		</td>
		
		<td width="20">&nbsp;</td>
		<td class="tdLabel2"><font style="font-weight:bold;">Supplier: </font>
			<?php 
				echo $contracts['InventorySupplier']['name'];
			?> 
		</td>
		
		<td width="20">&nbsp;</td>
		<td class="tdLabel2"><font style="font-weight:bold;">Contract Description: </font>
			<?php 
				echo $contracts['Contract']['descriptions']; 
			?>
		</td>
	</table>
	</td>	
	</tr>
	
	
	<tr>
	<td>
	<table>
		<td class="tdLabel2"><font style="font-weight:bold;">Duration: </font>
			<?php 
				echo $contracts['Contract']['start_date']." to ".$contracts['Contract']['end_date']; ?>
		</td>
		
		
		<td width="20">&nbsp;</td>
		<td class="tdLabel2" colspan="3"><font style="font-weight:bold;">PO Amount in Between: </font>
			<?php 
				echo $this->Number->currency( $contracts['Contract']['min_po_amount'])." to ".$this->Number->currency( $contracts['Contract']['max_po_amount']);
			 ?>
		</td>
	</table>	
	</td>		
	</tr>
</table>
<?php } ?>
<div class="clr ht5"></div>

<div class="inner_title">
	<div class="clr ht5"></div>
</div>
<div class="clr ht5"></div>
<?php if(!empty($products)) { ?>
<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm" >
	<thead>
		<tr>
			<th width="40" align="center" valign="top" style="text-align: center;">Sr.No.</th>
			<th width="150" align="center" valign="top" style="text-align: center;">Product Name</th>
			<th width="120" align="center" valign="top" style="text-align: center;">Manufacturer</th>
			<th width="60" valign="top" style="text-align: center;">Pack</th>
			<th width="80" align="center" valign="top" style="text-align: center;">Batch No.</th>
			<th width="60" valign="top" style="text-align: center;">Purchase Price</th>
			<th width="60" valign="top" style="text-align: center;">Contract Purchase Price</th>
		</tr>
	</thead>
	
	<tbody>
		<?php $count = 0; foreach($products as $key=>$product) { ?>
		<tr>
			<td valign="middle" style="text-align: center;">
				<?php echo ++$count; ?>
			</td>
			
			<td valign="middle">
				<?php echo $product['Product']['name'];?>
				<?php echo $this->Form->hidden('product_id',array('id'=>'productId_'.$key,'class'=>'productId','value'=>$product['Product']['id']));?>
			</td>
			
			<td valign="middle">
				<?php echo $product['ManufacturerCompany']['name'];?>
			</td>
			
			<td valign="middle">
				<?php echo $product['Product']['pack'];?>
			</td>
			
			<td valign="middle" style="text-align: center;">
				<?php echo $product['Product']['batch_number'];?>
			</td>
			
			<td valign="middle" style="text-align: center;">
				<?php echo $product['Product']['purchase_price'];?>
			</td>
			
			<td valign="middle" style="text-align: center;">
				<?php 
					echo $product['ContractProduct']['purchase_price'];	
				?>
			</td>
		</tr>
		<?php } //end of foreach loop ?>
	</tbody>
</table>
<?php } else { ?>
	Sorry, there are no any products for this contracts..
<?php } ?>
<div class="clr ht5"></div>