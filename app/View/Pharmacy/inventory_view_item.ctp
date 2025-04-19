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
	<span> <?php if(!isset($this->params['pass'][1])){ 
		echo $this->Html->link(__('Back'), array('action' => 'item_list','list' ,'inventory'=>true), array('escape' => false,'class'=>'blueBtn'));
	}
	?>

	</span>

</div>

<div class="clr ht5"></div>
<?php echo $this->Form->create('PharmacyItem');?>
<table width="100%" border="0" cellspacing="0" cellpadding="0"
	class="formFull">
	<tr>
		<td width="100" valign="middle" class="tdLabel" id="boxSpace">Item Name:</td>
		<td width="250"><?php echo $data['PharmacyItem']['name'];?></td>
		<td width="">&nbsp;</td> 
		<td width="100" class="tdLabel" id="boxSpace">Item Code::</td>
		<td width="300">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td width=""><?php  echo $data['PharmacyItem']['item_code'];
					//echo $this->DateFormat->formatDate2Local($data['PharmacyItem']['date'],Configure::read('date_format'),true);?></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class="tdLabel" id="boxSpace">Pack:</td>
		<td><?php echo $data['PharmacyItem']['pack'];?></td>
		<td>&nbsp;</td>
		<td class="tdLabel" id="boxSpace">Minimum:</td>
		<td><?php echo $data['PharmacyItem']['minimum'];?></td>
	</tr>
	<tr>
		<td valign="middle" class="tdLabel" id="boxSpace">Manufacturer:</td>
		<td><?php echo $data['PharmacyItem']['manufacturer'];?></td>
		<td>&nbsp;</td>
		<td class="tdLabel" id="boxSpace">Maximum:</td>
		<td><?php echo $data['PharmacyItem']['maximum'];?></td>
	</tr> 

	<tr>
		<td valign="middle" class="tdLabel" id="boxSpace">Generic:</td>
		<td><?php echo $data['PharmacyItem']['generic'];?></td>
		<td>&nbsp;</td>

		<td valign="middle" class="tdLabel" id="boxSpace">Supplier:</td>
		<td><?php echo $data['InventorySupplier']['name'];?></td>
	</tr>
	<?php if($websiteConfig['instance'] == 'kanpur'){ ?> 
	<tr>
		<td valign="middle" class="tdLabel" id="boxSpace">Vat of Class:</td>
		<td><?php echo $data['VatClass']['vat_of_class'];?></td>
		<td>&nbsp;</td>

		<td valign="middle" class="tdLabel" id="boxSpace"></td>
		<td></td>
	</tr>
	<?php } ?>
</table>

<!-- billing activity form end here -->
<div class="btns"></div>
<?php echo $this->Form->end();?>
<p class="ht5"></p>
<!-- Right Part Template ends here -->
</td>
</table>
