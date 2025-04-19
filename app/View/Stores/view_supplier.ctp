
<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Store Management - View Supplier', true); ?>
	</h3>
	<span> <?php 
	echo $this->Html->link(__('Back'), array('action' => 'supplierList'), array('escape' => false,'class'=>'blueBtn'));
	?>
	</span>

</div>

<div class="clr ht5"></div>
<table width="100%" border="0" cellspacing="0" cellpadding="0"
	class="formFull">
	<tr>
		<td width="100" valign="middle" class="tdLabel" id="boxSpace">Supplier
			Name:</td>
		<td width="250"><?php echo $data['InventorySupplier']['name'];?></td>
		<td width="">&nbsp;</td>
		<td class="tdLabel" id="boxSpace">CST:</td>
		<td width="250">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td><?php echo $data['InventorySupplier']['cst'];?></td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<td width="100" class="tdLabel" id="boxSpace">Supplier Code:</td>
		<td width=""><?php echo $data['InventorySupplier']['code'];?></td>
		<td>&nbsp;</td>
		<td valign="middle" class="tdLabel" id="boxSpace">ST. No.:</td>
		<td><?php echo $data['InventorySupplier']['stax_no'];?></td>
	</tr>
	<tr>
		<td class="tdLabel" id="boxSpace"> Supplier Type</td>
		<td>
		<?php  echo $data['InventorySupplier']['supplier_type']; ?>
		</td>
	</tr>
	<tr>
		<td class="tdLabel" id="boxSpace">Phone:</td>
		<td><?php echo $data['InventorySupplier']['phone'];?></td>
		<td>&nbsp;</td>
		<td width="100" class="tdLabel" id="boxSpace">Address:</td>
		<td width=""><?php echo $data['InventorySupplier']['address'];?></td>

	</tr>
	<tr>
		<td valign="middle" class="tdLabel" id="boxSpace">Credit Limit:</td>
		<td><?php echo $data['InventorySupplier']['credit_limit'];?></td>
		<td>&nbsp;</td>
		<td class="tdLabel" id="boxSpace">Credit Day:</td>
		<td><table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td width=""><?php echo $data['InventorySupplier']['credit_day'];?>
					</td>

				</tr>
			</table></td>
	</tr>
	<tr>

		<td valign="middle" class="tdLabel" id="boxSpace">Email:</td>
		<td><?php echo $data['InventorySupplier']['email'];?></td>

		<td>&nbsp;</td>
		<td valign="middle" class="tdLabel" id="boxSpace">Bank or Branch:</td>
		<td><?php echo $data['InventorySupplier']['bank'];?></td>

	</tr>
	<tr>
		<td class="tdLabel" id="boxSpace">Pin:</td>
		<td><?php echo $data['InventorySupplier']['pin'];?></td>

		<td>&nbsp;</td>
		<td valign="middle" class="tdLabel" id="boxSpace">Mobile:</td>
		<td><?php echo $data['InventorySupplier']['mobile'];?></td>


	</tr>
	<tr>

		<td valign="middle" class="tdLabel" id="boxSpace">DL No.:</td>
		<td><?php echo $data['InventorySupplier']['dl_no'];?></td>

		<td>&nbsp;</td>

	</tr>
	<tr>

		<td>&nbsp;</td>

	</tr>
	</tr>
</table>

<!-- billing activity form end here -->
<div class="btns"></div>
<?php echo $this->Form->end();?>
<p class="ht5"></p>


<!-- Right Part Template ends here -->
</td>
</table>
