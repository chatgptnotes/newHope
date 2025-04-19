
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#OtPharmacyItemInventoryEditItemForm").validationEngine();
	});

</script>
<?php
echo $this->Html->script('jquery.fancybox-1.3.4');
echo $this->Html->css('jquery.fancybox-1.3.4.css');
if(!empty($errors)) {
?>

<table border="0" cellpadding="0" cellspacing="0" width="60%"
	align="center" style="color: red">
	<tr>
		<td colspan="2" align="center"><?php
		foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
     ?>
		</td>
	</tr>
</table>
<?php } ?>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('OTPharmacy Management - Edit Item', true); ?>
	</h3>
	<span> <?php /*  if(isset($this->params['pass']['1']) && $this->params['pass']['1'] == "apam"){
		echo $this->Html->link(__('Back'), array('action' => 'apam_item_list' ,'inventory'=>true), array('escape' => false,'class'=>'blueBtn'));
	}else{
		echo $this->Html->link(__('Back'), array('action' => 'item_list' ,'list','inventory'=>true), array('escape' => false,'class'=>'blueBtn'));
	} */
	?>
	</span>

</div>
<?php $doseForm = array('Pack'=>'Pack','Inj'=>'Inj','Vial'=>'vial','Syrup'=>'Syrup','Syringe'=>'Syringe'); ?>
<div class="clr ht5"></div>
<?php  
echo $this->Form->create('OtPharmacyItem',array('id'=>'OtPharmacyItemInventoryEditItemForm'));?>
<table width="80%" border="0" cellspacing="0" cellpadding="0" align="center" class="formFull">
	<tr>
		<td valign="middle" class="tdLabel" id="boxSpace">Item Name<font color="red">*</font>
		</td>
		<td>
		<input type="text" name="OtPharmacyItem[name]" id="name" class="textBoxExpnd validate[required]" tabindex="1" 
			value="<?php echo $data['OtPharmacyItem']['name'];?>" />
		<input type="hidden" name="OtPharmacyItem[nameHidden]" id="name" class="textBoxExpnd validate[required]" tabindex="1"
			value="<?php echo $data['OtPharmacyItem']['name'];?>" />
		</td>
		
		<td class="tdLabel" id="boxSpace">Item Code</td>
		<td>
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td width=""><input name="OtPharmacyItem[item_code]" type="text"
						class="textBoxExpnd" id="item_code" tabindex="2" style="width: 82%"
						value="<?php echo $data['OtPharmacyItem']['item_code'];?>" /></td>
				</tr>
			</table>
		</td>
		
		<!--  <td width="100" class="tdLabel" id="boxSpace">Date</td>
		<td width="250">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td width=""><input name="PharmacyItem[date]" type="text"
						class="textBoxExpnd" id="date" tabindex="2" style="width: 82%"
						value="<?php echo $this->DateFormat->formatDate2Local($data['PharmacyItem']['date'],Configure::read('date_format'),true);?>" /></td>
				</tr>
			</table>
		</td>-->
		 
	
	</tr>
		<td class="tdLabel" id="boxSpace">Pack<font color="red">*</font>
		</td>
		<td><table><tr><td width="10%"><input type="text" name="OtPharmacyItem[pack]" id="pack" class="textBoxExpnd validate[required] onlyNumber" tabindex="3" style="width: 90%;" value="<?php echo $data['OtPharmacyItem']['pack'];?>"/></td>
		<td>
		<?php
			echo $this->Form->input('OtPharmacyItem.doseForm',array('type'=>'select','autocomplete'=>"off",'label'=>false,'options'=>$doseForm,'value'=>$data['OtPharmacyItem']['doseForm'],'style'=>"width:56%;"));
		 ?>
		</td></tr></table></td>
	
		<td class="tdLabel" id="boxSpace">Minimum</td>
		<td><input type="text" name="OtPharmacyItem[minimum]" id="minimum"
			class="textBoxExpnd onlyNumber" tabindex="4"
			value="<?php echo $data['OtPharmacyItem']['minimum'];?>" /></td>
	</tr>
	<tr>
		<td valign="middle" class="tdLabel" id="boxSpace">Manufacturer</td>
		<td>
		<input type="text" name="OtPharmacyItem[manufacturer]" id="manufacturer" class="textBoxExpnd" tabindex="5"
			value="<?php echo $data['ManufacturerCompany']['name'];?>" />
			<?php 
				echo $this->Form->hidden('manufacturer_id',array('id'=>'manufacturer_id','value'=>$data['ManufacturerCompany']['name'],'name'=>"OtPharmacyItem[manufacturer_id]")); ?>
			</td>
		
		<td class="tdLabel" id="boxSpace">Maximum</td>
		<td>
		<input type="text" name="OtPharmacyItem[maximum]" id="maximum" class="textBoxExpnd onlyNumber" tabindex="6"
			value="<?php echo $data['OtPharmacyItem']['maximum'];?>" /></td>
	</tr>
	<!--<tr>
	<td class="tdLabel" id="boxSpace">Shelf</td>
		<td><table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td width=""><input type="text" name="PharmacyItem[shelf]"
						id="shelf" class="textBoxExpnd" tabindex="8"
						value="<?php echo $data['OtPharmacyItem']['shelf']; ?>" /></td>

				</tr>
			</table></td>
		<td class="tdLabel" id="boxSpace">Supplier</td>
		<td><input type="text" name="PharmacyItem[supplier_name]" id="search_supplier"
			class="textBoxExpnd" tabindex="10"  
			value="<?php echo $data['InventorySupplier']['name']; ?>"/>
			<?php echo $this->Form->hidden('',array('id'=>'supplier_id','name'=>"OtPharmacyItem[supplier_id]",'value'=>$data['OtPharmacyItem']['supplier_id'])); ?></td>
	</tr>-->
	<tr>
		<td valign="middle" class="tdLabel" id="boxSpace">Generic</td>
		<td><input type="text" name="OtPharmacyItem[generic]" id="generic"
			class="textBoxExpnd" tabindex="9"
			value="<?php echo $data['OtPharmacyItem']['generic'];?>" /></td>
			
		<td valign="middle" class="tdLabel" id="boxSpace">Profit Percent</td>
		<td><input type="text" name="OtPharmacyItem[profit_percentage]" id="profit_percentage" class="textBoxExpnd" tabindex="13" value="<?php echo $data['OtPharmacyItem']['profit_percentage'];?>"/></td>
		<td>%</td> 	
		<!--  <td valign="middle" class="tdLabel" id="boxSpace">Expensive</td>
		<td><?php 
		/* if($data['OtPharmacyItem']['expensive_product'] == 1){
			$checked = "checked";
		}else{
			$checked = "";
		}
		echo $this->Form->input('OtPharmacyItem.expensive_product', array('type' => 'checkbox','class' => '','checked'=>$checked,'label' => false,'legend' => false)); */
		?>
		</td>-->
	
	</tr>
	
	<tr>
		<td valign="middle" class="tdLabel" id="boxSpace"> Reorder Level:</td>
		<td>
			<?php echo $this->Form->input('',array('type'=>'text','class'=>'textBoxExpnd','id'=>'reorder_level','class'=>'vatClass' ,'autocomplete'=>"off",'label'=>false,'name'=>"data[OtPharmacyItem][reorder_level]",'value'=>$data["OtPharmacyItem"]["reorder_level"])); ?>
		</td> 
		
	</tr>
	
<!-- 	<tr>
		<td valign="middle" class="tdLabel" id="boxSpace">Stock</td>
		<td><input type="text" name="PharmacyItem[stock]" id="stock"
			class="textBoxExpnd" tabindex="11"
			value="<?php echo $data['PharmacyItem']['stock'];?>" /></td>
		<td>&nbsp;</td>
		<td valign="middle" class="tdLabel" id="boxSpace">Batch No.</td> -->
<!-- 		<td><input type="text" name="PharmacyItem[batch_number]" id="batch_number" 
<!-- 			class="textBoxExpnd" tabindex="11" 
			value="<?php //echo $data['PharmacyItem']['batch_number'];?>" /></td>
	</tr>-->
 
</table>
 
<!-- biling activity form end here -->
<div class="btns">
	<!-- <input name="" type="button" value="Print" class="blueBtn" tabindex="11"/> -->
	<input name="" type="submit" value="Submit" class="blueBtn" tabindex="11" />

</div>
<?php echo $this->Form->end();?>
<p class="ht5"></p>


<!-- Right Part Template ends here -->
</td>
</table>

<script>

$( "#expiry_date" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,
			yearRange: '1950',
			dateFormat:'<?php echo $this->General->GeneralDate();?>',
		});
$( "#date" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,
			yearRange: '1950',
			dateFormat:'<?php echo $this->General->GeneralDate("HH:II");?>',
		});
(function($){
    $.fn.validationEngineLanguage = function(){
    };
    $.validationEngineLanguage = {
        newLang: function(){
            $.validationEngineLanguage.allRules = {
                "required": { // Add your regex rules here, you can take telephone as an example
                    "regex": "none",
                    "alertText":"Required.",
                    "alertTextCheckboxMultiple": "* Please select an option",
                    "alertTextCheckboxe": "* This checkbox is required"
                },
                "minSize": {
                    "regex": "none",
                    "alertText": "* Minimum ",
                    "alertText2": " characters allowed"
                },
             "email": {
                    // Simplified, was not working in the Iphone browser
                    "regex": /^([A-Za-z0-9_\-\.\'])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,6})$/,
                    "alertText": "* Invalid email address"
                },
				 "phone": {
                    // credit: jquery.h5validate.js / orefalo
                    "regex": /^([\+][0-9]{1,3}[ \.\-])?([\(]{1}[0-9]{2,6}[\)])?([0-9 \.\-\/]{3,20})((x|ext|extension)[ ]?[0-9]{1,4})?$/,
                    "alertText": "* Invalid phone number"
                },
            };

        }
    };
    $.validationEngineLanguage.newLang();
})(jQuery);

$('#search_supplier').autocomplete({	
	   
	 source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","InventorySupplier","name","null","null", "admin" => false,"plugin"=>false)); ?>",
  	 minLength: 1,
  	
	select: function( event, ui ) {
		
		var supply_id = ui.item.id;
		$("#supplier_id").val(supply_id);
		//alert(supply_id) ;
		
	},

	// apply below for avoiding messages
messages:{
	noResults: '',
	results: function() {}
	} 
});



$('#manufacturer').autocomplete({
	source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","ManufacturerCompany","name",'null',"no",'no','is_deleted=0',"admin" => false,"plugin"=>false)); ?>",
	 minLength: 1,
	 select: function( event, ui ) {
		 $('#manufacturer_id').val(ui.item.id); 
	 },
	 messages: {
	        noResults: '',
	        results: function() {}
	 }
});


$(document).on('keyup',".stock, .mrp, .purchase_price, .selling_price",function() {
	if (/[^0-9\.]/g.test(this.value))
    {
    	 this.value = this.value.replace(/[^0-9\.]/g,'');
    }
});

$(document).on('input',"#name, .batch_number",function() {
    $(this).val($(this).val().toUpperCase());
});

$(document).on('input',"#profit_percentage",function() {
	if (/[^0-9\.]/g.test(this.value))
    {
    	 this.value = this.value.replace(/[^0-9\.]/g,'');
    }
    if($("#profit_percentage").val() > 100){
		alert("Please enter valid percentage");
		$("#profit_percentage").val('');
		$("#profit_percentage").focus()
    }
});

$(document).on('input',".onlyNumber",function() {
	if (/[^0-9]/g.test(this.value))
    {
    	this.value = this.value.replace(/[^0-9]/g,'');
    }
	if (this.value.length > 5) this.value = this.value.slice(0,5);
});
 



</script>
