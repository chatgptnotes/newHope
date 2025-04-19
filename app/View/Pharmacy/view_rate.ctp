<?php
if(isset($this->params->query['popup'])){
	echo $this->Html->css(array('datePicker.css','jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','internal_style.css'));
	echo "<style>.blueBtn{ display:none;}</style>";
}
?>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Pharmacy Management - View Item', true); ?>
	</h3>
	<span> <?php 
	echo $this->Html->link(__('Back'), array('controller'=>'Pharmacy','action' => 'view_item_rate'), array('escape' => false,'class'=>'blueBtn'));
	?>

	</span>

</div>

<div class="clr ht5"></div>
<?php echo $this->Form->create('PharmacyItem');?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
	<tr>
		<td width="100" valign="middle" class="tdLabel" id="boxSpace">Item Name:</td>
		<td width="250"><?php echo $itemDetails['PharmacyItem']['name'];?></td>
		<td width="">&nbsp;</td>
		
		<td width="100" class="tdLabel" id="boxSpace">Item Code:</td>
		<td width="250"><?php echo $itemDetails['PharmacyItem']['item_code'];?></td>
		<td width="">&nbsp;</td>	
	</tr>

	<tr>
		<td class="tdLabel" id="boxSpace">Batch No:</td>
		<td><?php echo $itemDetails['PharmacyItemRate']['batch_number'];?></td>
		<td>&nbsp;</td>
		
		<td class="tdLabel" id="boxSpace">Expiry Date:</td>
		<td><?php echo $this->DateFormat->formatDate2Local($itemDetails['PharmacyItemRate']['expiry_date'],Configure::read('date_format'),true);?></td>
	</tr>
	<tr>
		<td valign="middle" class="tdLabel" id="boxSpace">Pur.Price:</td>
		<td><?php echo $itemDetails['PharmacyItemRate']['purchase_price'];?></td>
		<td>&nbsp;</td>
		
		<!--<td class="tdLabel" id="boxSpace">CST:</td>
		<td><?php echo $itemDetails['PharmacyItemRate']['cst'];?></td>-->
		
		<td valign="middle" class="tdLabel" id="boxSpace">Sale Price:</td>
		<td><?php echo $itemDetails['PharmacyItemRate']['sale_price'];?></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td class="tdLabel" valign="middle" id="boxSpace">Cost Price:</td>
		<td><?php echo $itemDetails['PharmacyItemRate']['cost_price'];?></td>
		
		<td>&nbsp;</td>
		<td valign="middle" class="tdLabel" id="boxSpace">Stock:</td>
		<td><?php echo $itemDetails['PharmacyItemRate']['stock'];?></td>
		<td>&nbsp;</td>

	</tr>

	<tr>
		<td valign="middle" class="tdLabel" id="boxSpace">MRP:</td>
		<td><?php echo $itemDetails['PharmacyItemRate']['mrp'];?></td>
		<td>&nbsp;</td>

		<td valign="middle" class="tdLabel" id="boxSpace">Tax:</td>
		<td><?php echo $itemDetails['PharmacyItemRate']['tax'];?></td>

	</tr>
	
</table>

<!-- billing activity form end here -->
<div class="btns"></div>
<?php echo $this->Form->end();?>
<p class="ht5"></p>


<!-- Right Part Template ends here -->
</td>
</table>
