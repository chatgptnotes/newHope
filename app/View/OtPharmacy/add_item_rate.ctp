<style>
.td_second{
	border-left-style:solid; 
	padding-left: 15px; 
	background-color: #404040; 
	color:#ffffff;
	width:5%;
}

.tdAnotherLabel {
    color: #000;
    font-size: 13px;
    padding-left: 7px !important;
   /*  padding-right: 7px !important; */
    padding-top: 5px !important;
    text-align: left;
}
.formFull td{
	padding: 0px 0 ;
}
</style>

<div class="inner_title">

	<h3>
		<?php echo __('OT Pharmacy Management - Add Rate', true); ?>
	</h3>
	
	<div class="clr ht5"></div>
</div>	

<?php echo $this->Form->create('OtPharmacyItemRate',array('id'=>"OtPharmacyItemRate"));?>

<table width="100%"  cellspacing='0' cellpadding='0' >
	<tr>
		<td  valign="top" class="td_second">
		<?php echo $this->element('ot_pharmacy_menu');?>
		</td>

		<td valign="top" style ="top: 0px;">
	<table cellpadding="0" cellspacing="0" align="center" width="60%" class="formFull" >
	<tr>
		<td class="tdAnotherLabel" ><?php echo __('Item Name: '); ?><font color="red">*</font></td>
		<td class="tdAnotherLabel">
			<input type="text" name="OtPharmacyItemRate[name]" id="item_name" class="textBoxExpnd validate[required]" tabindex="1" value="<?php //echo $data['PharmacyItem']['name'];?>" />
			<input type="hidden" name="OtPharmacyItem[item_id]" id="item_id" class="textBoxExpnd validate[required]" tabindex="1" value="<?php //echo $data['PharmacyItem']['id'];?>" />	
		</td>
		<td valign="middle" class="tdAnotherLabel"> <?php echo __('Item Code: ');?> </td>
		<td class="tdAnotherLabel">
			<input type="text" name="item_code" id="item_code" class="textBoxExpnd" tabindex="2" autocomplete="false" value="<?php //echo $data['PharmacyItem']['item_code'];?>" /> 
			<input type="hidden" name="PharmacyItemRate[item_id]" id="item_id" value="<?php //echo $data['PharmacyItem']['id'];?>" />
		</td>
		<td valign="middle" class="tdAnotherLabel"><?php echo __('Batch No: '); ?><font color="red">*</font></td>
		<td class="tdAnotherLabel">
			<input type="text" name="OtPharmacyItemRate[batch_number]"id="batch_number" class="textBoxExpnd validate[required]" tabindex="3" 
			value="<?php //echo $data['PharmacyItemRate']['batch_number'];?>" style="text-align: left" />
		</td>
	</tr>
	<tr>
		<td class="tdAnotherLabel"><?php echo __("Expiry Date: ");?><font color="red">*</font></td>
		<td  class="tdAnotherLabel">
			<?php echo $this->Form->input('OtPharmacyItemRate.expiry_date', array('type'=>'text','name'=>"data[OtPharmacyItemRate][expiry_date]",
							'readonly'=>'readonly', 'size'=>'20','id' => 'expiry_date','class'=>'validate[required,future[NOW]] textBoxExpnd expiry_date','label'=>false));?>
		</td>

		<td valign="middle" class="tdAnotherLabel"><?php echo __("Purcahse Price");?><font color="red">*</font></td>
		<td class="tdAnotherLabel">
			<input type="text" name="OtPharmacyItemRate[purchase_price]" id="purchase_rate" class="textBoxExpnd validate[required,custom[number]]" 
			style="text-align: right" tabindex="5" value="<?php //echo $data['PharmacyItemRate']['purchase_price'];?>" />
			<?php //echo $this->Session->read('Currency.currency_symbol') ; ?></td>
		
		<td class="tdAnotherLabel"><?php echo __("Sale Price: ");?><font color="red">*</font></td>
		<td class="tdAnotherLabel">
			<input type="text" name="OtPharmacyItemRate[sale_price]" id="sale_price" class="textBoxExpnd validate[required,custom[number]]"
			style="text-align: right" tabindex="6" value="<?php //echo $data['PharmacyItemRate']['sale_price'];?>" /> 
			<?php //echo $this->Session->read('Currency.currency_symbol') ; ?>
		</td>
	</tr>
	<tr>
		<td valign="middle" class="tdAnotherLabel"><?php echo __("MRP: ");?><font color="red">*</font></td>
		<td class="tdAnotherLabel">
			<input type="text" name="OtPharmacyItemRate[mrp]" id="mrp_price" class="textBoxExpnd validate[required,custom[number]]" tabindex="7"
			value="<?php //echo $data['PharmacyItemRate']['mrp'];?>" style="text-align: right" /> 
			<span>
			<?php //echo $this->Session->read('Currency.currency_symbol') ; ?>
		</td>
		<td valign="middle" class="tdAnotherLabel"><?php echo __("Stock: ");?><font color="red">*</font></td>
		<td class="tdAnotherLabel"><input type="text" name="OtPharmacyItemRate[stock]" id="stock" class="textBoxExpnd validate[required,custom[number]]" tabindex="8"
			value="<?php //echo $data['PharmacyItemRate']['stock'];?>" style="text-align: right" /> 
		</td>
		
		<td class="tdAnotherLabel" ><?php echo __("Tax%: ");?></td>
		<td class="tdAnotherLabel">
			<input type="text" name="OtPharmacyItemRate[tax]" id="tax" class="textBoxExpnd validate[custom[number]]" tabindex="10"
			value="<?php //echo $data['PharmacyItemRate']['tax'];?>" />
		</td>
	</tr>
	
	<tr>
		<td class="tdAnotherLabel" id="boxSpace"></td>
		<td class="tdAnotherLabel" id="boxSpace"></td>
		<td class="tdAnotherLabel" id="boxSpace"></td>
		<td class="tdAnotherLabel" id="boxSpace"></td>
		<td class="tdAnotherLabel" id="boxSpace"></td>
		
		<td align="right">
			<input name="" type="submit" value="Submit" class="blueBtn" tabindex="9" id="submitButton" />
		</td>
	</tr>
</table>

<table border="0" align="center" class="table_format" cellpadding="0" cellspacing="0" width="80%" >
	<tbody class="">
		<tr class="row_title">
			<td class="table_cell"><strong><?php echo __('Item Name', true); ?></strong></td>
			<td class="table_cell"><strong><?php echo __('Pack', true); ?></strong></td>
			<td class="table_cell"><strong><?php echo __('Batch Number', true); ?></strong></td>
			<td class="table_cell"><strong><?php echo __('Purchase Price', true); ?></strong></td>
			<td class="table_cell"><strong><?php echo __('Sale Price', true); ?></strong></td>
			<td class="table_cell"><strong><?php echo __('MRP', true); ?> </strong></td>
			<td class="table_cell"><strong><?php echo __('Stock', true); ?> </strong></td>
			<td class="table_cell"><strong><?php echo __('Tax', true); ?> </strong></td>
			<td class="table_cell"><strong><?php echo __('Action', true); ?> </strong></td>
		</tr>
		
		<?php 
			$cnt =0;
			if(count($data) > 0) {
		       foreach($data as $itemRateData): 
		       $cnt++;
		?>
		
		<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
			<td class="row_format"><?php echo $itemRateData['OtPharmacyItem']['name']; ?></td>
			<td class="row_format"><?php echo $itemRateData['OtPharmacyItem']['pack']; ?></td>
			<td class="row_format"><?php echo $itemRateData['OtPharmacyItemRate']['batch_number']; ?></td>
			<td class="row_format"><?php echo $itemRateData['OtPharmacyItemRate']['purchase_price']; ?></td>
			<td class="row_format"><?php echo $itemRateData['OtPharmacyItemRate']['sale_price']; ?></td>
			<td class="row_format"><?php echo $itemRateData['OtPharmacyItemRate']['mrp']; ?></td>
			<td class="row_format"><?php echo $itemRateData['OtPharmacyItemRate']['stock']; ?></td>
			<td class="row_format"><?php echo $itemRateData['OtPharmacyItemRate']['tax']; ?></td>
			
			<td class="row_format">
				<?php 
				
				echo $this->Html->link($this->Html->image('icons/view-icon.png', array('title'=> __('View', true),
						'alt'=> __('View', true))), array('controller'=>'Pharmacy','action' => 'view_vat_class', $vatData['VatClass']['id']), array('escape' => false ));
				echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('title'=> __('Edit', true),'id'=>'editVat',
						'alt'=> __('Edit', true))), array('controller'=>'Pharmacy','action' => 'vat',$vatData['VatClass']['id'],"edit"), array('escape' => false ));
				echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('title'=> __('Delete', true),
						'alt'=> __('Delete', true))), array('controller'=>'Pharmacy','action' => 'deleteVatOfClass', $vatData['VatClass']['id']), array('escape' => false ),"Are you sure ?");
				
				 ?>
			</td>
		</tr>
		
		<?php endforeach;
			}?>
		<tr>
		
		</tr>
		</tbody>
	</table>
	</td>
</tr>
</table>

<?php echo $this->Form->end();?>

	
<script>
$(document).ready(function(){

	$("#lookup_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","OtPharmacyItem",'name',"admin" => false,"plugin"=>false)); ?>", 
	{
			width: 80,
			selectFirst: true
	});

	$('#item_name').autocomplete({
		 source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","OtPharmacyItem","name",'null',"no",'no','is_deleted=0',"admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
			 $('#item_id').val(ui.item.id); 
		 },
		 messages: {
		        noResults: '',
		        results: function() {}
		 }
	});

	
	/*$("#item_name").autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","OtPharmacyItem",'name',"admin" => false,"plugin"=>false)); ?>",
		select:	function(event,ui){
			$("#item_code").val(ui.item.item_code);
			$("#item_id").val(ui.item.id);
			},
            messages: {
            noResults: '',
            results: function() {}
    	 }	
	});*/

	$( ".expiry_date" ).datepicker({
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',			 
		dateFormat:'<?php echo $this->General->GeneralDate("");?>',
	    
	});

});
</script>	
	
	