<style>.row_action img{float:inherit;}
.inner_title{
	padding-bottom: 0px;
}
.table_format {
    padding: 10px;
}
</style>


<?php
/*if(isset($is_layout)){
	echo $this->Html->script(array('jquery-1.5.1.min','validationEngine.jquery',
			'jquery.validationEngine','/js/languages/jquery.validationEngine-en','jquery-ui-1.8.16.custom.min','jquery.ui.widget.js','jquery.ui.mouse.js','jquery.ui.core.js','ui.datetimepicker.3.js','permission.js'));
	echo $this->Html->css(array('datePicker.css','jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','internal_style.css'));
}*/
?>
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#PharmacyItemRateInventoryItemRateMasterForm").validationEngine();
	});

</script>
<?php
//echo $this->Html->script('jquery.autocomplete_pharmacy');
//echo $this->Html->css('jquery.autocomplete.css');
if(!empty($errors)) {
?>

<table border="0" cellpadding="0" cellspacing="0" width="60%"
	align="center">
	<tr>
		<td colspan="2" align="left"><?php
		foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
     ?>
		</td>
	</tr>
</table>
<?php } ?>
<style>
.formErrorContent {
	width: 43px !important;
}

.textBoxExpnd {
	width: 70%;
}
</style>

<div class="inner_title">
	<?php echo $this->element('navigation_menu',array('pageAction'=>'Pharmacy')); ?>
	<h3>
		<?php echo __('Pharmacy Management - Item Rate Master', true); ?>
	</h3>
	<span>
	<?php if($flagForBack!=1){?> 
	<?php
	if(!isset($is_layout))
		echo $this->Html->link(__('Back'), array('controller'=>'Pharmacy','action' => 'view_item_rate','inventory'=>false), array('escape' => false,'class'=>'blueBtn'));
	?>
	<?php }?>
	</span>

</div>
<table border="0" cellpadding="0" cellspacing="0" width="100%"
	class="table-format">

</table>
<div class="clr ht5"></div>
<?php echo $this->Form->create('PharmacyItemRate',array('id'=>'PharmacyItemRateMaster'));?>
<?php
   if(isset($fieldNo)){?>
<input
	type="hidden" name="fieldID" value="<?php echo $fieldNo;  ?>">
<?php }?>
<table width="100%" border="0" cellspacing="0" cellpadding="0"
	class="formFull">
	
	<tr>

		<td width="100" class="tdLabel" id="boxSpace">Item Name<font
			color="red">*</font>
		</td>
		<td width="250"><input type="text" name="item_name" id="item_name"
			class="textBoxExpnd item_name validate[required]" tabindex="1"
			value="<?php echo $data['PharmacyItem']['name'];?>" />
			<input type="hidden" name="item_id" id="item_id"
			class="textBoxExpnd validate[required]" tabindex="1"
			value="<?php echo $data['PharmacyItem']['id'];?>" />	
		</td>
			

		<td width="100" valign="middle" class="tdLabel" id="boxSpace">Item
			Code
		</td>
		<?php if(empty($data['PharmacyItem']['item_code'])){ ?>
			<td width="250"><input type="text" name="item_code" id="item_code"
			class="textBoxExpnd item_code" tabindex="2"
			autocomplete="false"	
			value="<?php echo $data['PharmacyItem']['item_code'];?>" /> 
			<?php echo $this->Form->hidden('',array('name'=>"data[pack]",'value'=>'','id'=>'pack'));?>
		</td>
		<?php }else{ ?>
		<td width="250"><input type="text" name="item_code" id="item_code"
			class="textBoxExpnd" tabindex="2"
			autocomplete="false"
			value="<?php echo $data['PharmacyItem']['item_code'];?>" /> <input
			type="hidden" name="PharmacyItemRate[item_id]" id="item_id"
			value="<?php echo $data['PharmacyItem']['id'];?>" />
		</td>
		<?php } ?>
	</tr>
	<tr>
		<td valign="middle" class="tdLabel" id="boxSpace">Batch No.<font
			color="red">*</font>
		</td>
		<td><input type="text" name="PharmacyItemRate[batch_number]" autocomplete = "off"
			id="batch_number" class=" textBoxExpnd batch_number validate[required]" 
			tabindex="3"
			value="<?php echo $data['PharmacyItemRate']['batch_number'];?>"
			style="text-align: left" /></td>
		
		<td class="tdLabel" id="boxSpace">Expiry Date:<font
			color="red">*</font></td>
		<td class="row_action"><?php echo $this->Form->input('expiry_date', array('type'=>'text','name'=>"data[PharmacyItemRate][expiry_date]",
				'style'=>'width:155px','readonly'=>'readonly', 'size'=>'20','id' => 'expiry_date','tabindex'=>"4",
				'class'=>'validate[required,future[NOW]] textBoxExpnd expiry_date','label'=>false));?>
		</td>

	</tr>
	<tr>
		<td valign="middle" class="tdLabel" id="boxSpace">Pur. Price.<font
			color="red">*</font>
		</td>
		<td><input type="text" name="PharmacyItemRate[purchase_price]"
			id="purchase_rate"
			class="textBoxExpnd onlyNumber validate[required,custom[number]]"
			style="text-align: right" tabindex="5"
			value="<?php echo $data['PharmacyItemRate']['purchase_price'];?>" />
			<?php echo $this->Session->read('Currency.currency_symbol') ; ?></td>
		
		<td class="tdLabel" id="boxSpace">Sale Price<font color="red">*</font>
		</td>
		<td><input type="text" name="PharmacyItemRate[sale_price]"
			id="sale_price"
			class="textBoxExpnd onlyNumber validate[required,custom[number]]"
			style="text-align: right" tabindex="6"
			value="<?php echo $data['PharmacyItemRate']['sale_price'];?>" /> <?php echo $this->Session->read('Currency.currency_symbol') ; ?>
		</td>
		
	</tr>
	<tr>
		<td valign="middle" class="tdLabel" id="boxSpace">MRP<font color="red">*</font>
		</td>
		<td><input type="text" name="PharmacyItemRate[mrp]" id="mrp_price"
			class="textBoxExpnd onlyNumber validate[required,custom[number]]" tabindex="7"
			value="<?php echo $data['PharmacyItemRate']['mrp'];?>"
			style="text-align: right" /> <?php echo $this->Session->read('Currency.currency_symbol') ; ?>
		</td>
	
		<td valign="middle" class="tdLabel" id="boxSpace">Stock(MSU)<font color="red">*</font></td>
		<td><input type="text" name="PharmacyItemRate[stock]" id="stock"
			class="textBoxExpnd onlyNumberNotDecimal validate[required,custom[number]]" tabindex="8"
			value="<?php echo $data['PharmacyItemRate']['stock'];?>"
			style="text-align: right" /> 
			<input type="hidden" name="PharmacyItemRate[loose_stock]" id="loose_stock"
			class="textBoxExpnd onlyNumberNotDecimal validate[required,custom[number]]" tabindex="8"
			value="<?php echo $data['PharmacyItemRate']['loose_stock'];?>"
			style="text-align: right" /> 
		</td>
	
<!-- 		<td class="tdLabel" id="boxSpace">CST</td> -->
<!-- 		<td><input type="text" name="PharmacyItemRate[cst]" id="cst" -->
<!-- 			class="textBoxExpnd validate[custom[number]]" tabindex="6" 
			value="<?php echo $data['PharmacyItemRate']['cst'];?>" /></td>-->
	</tr>
	 

</table>

<!-- billing activity form end here -->
<div class="btns">
	<input name="" type="submit" value="Submit" class="blueBtn"
		tabindex="9" id="submitButton" />


</div>
<?php echo $this->Form->end();?>
<p class="ht5"></p>

<!-- Right Part Template ends here -->
</td>
</table>

<script>
$(document).ready(function(){
	$("#item_name").autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "inventory_autocomplete_pharmacy_items","name","inventory" => true,"plugin"=>false)); ?>",
		select:	function(event,ui){ 
			console.log(ui.item);
				$("#item_code").val(ui.item.item_code);
				$("#item_id").val(ui.item.id);
				$("#pack").val(ui.item.pack);
			},
            messages: {
            noResults: '',
            results: function() {}
    	 }	
	});
});
<?php
if(!isset($is_layout)){
?>

			var $form = $('#PharmacyItemRateInventoryItemRateMasterForm');
   			var	$summands = $form.find(':input');
				$summands.each(function ()
					{
						if($(this).attr("name") == "item_name" || $(this).attr("name") == "item_code"){
							$(this).removeAttr("disabled");
						}else{
						$(this).attr("disabled", "disabled");
						}
					});
<?php
}
?>

$("#submitButton").click(function(){
	var valid = jQuery("#PharmacyItemRateMaster").validationEngine('validate');
	if(valid){
		return true;
	}else{
		return false;
	}
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
               "number": {
                    // Number, including positive, negative, and floating decimal. credit: orefalo
                    "regex": /^[\+]?(([0-9]+)([\.,]([0-9]+))?|([\.,]([0-9]+))?)$/,
                    "alertText": "* Invalid format"
                },


            };

        }
    };
    $.validationEngineLanguage.newLang();
})(jQuery);
/* for auto populate the data */
function selectItem(li) {
	if( li == null ) return alert("No match!");
		var itemID = li.extra[0];
		$("#item_id").val(itemID);
		if(li.extra[2] == "name")
			$("#item_code").val(li.extra[1]);
		else
			$("#item_name").val(li.extra[1]);
		//var ItemValue = li.selectValue;
		$summands.each(function ()
					{
						if($(this).attr("name") == "item_name" || $(this).attr("name") == "item_code"){
							$(this).removeAttr("disabled");
						}else{
							$(this).removeAttr("disabled");
						}
					});


}

	$( "#expiry_date" ).datepicker({
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',	
		minDate:new Date(),		 
		dateFormat:'<?php echo $this->General->GeneralDate("");?>',
        
	});
	
$(document).on('change',"#vat",function(){
	var t = $(this).val();	
});

/* load the data from rate master */
function loadDataFromRate(id){ 
    var batch_no = $("#batch_number").val(); 
     $("#batch_number").val("");
     $("#mrp_price").val("");
     $("#purchase_rate").val("");
     $("#cost_price").val("");
     $("#tax").val("");
     $("#vat").val(""); 
     $("#sale_price").val("");
     $.ajax({
    	  type: "POST",
    	  url: "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_rate_for_item",'item_id','true',"inventory" => true,"plugin"=>false)); ?>",
    	  data: "item_id="+id,
    	}).done(function( msg ) {
    	 	var item = jQuery.parseJSON(msg);
    	 	console.log(item);
    	 	$("#item_name").val(item.PharmacyItem.name);
    		$("#item_id").val(item.PharmacyItem.id);
    		$("#item_code-").val(item.PharmacyItem.item_code);
    		$("#manufacturer").val(item.ManufacturerCompany.name); 
    		$("#pack").val(item.PharmacyItem.pack);
    		batches= item.PharmacyItemRate;
    		if(batches!=''){
    			$.each(batches, function(index, value) { 
    			    $("#batch_number").val(value.batch_number);       				
    					$("#expiry_date").val(value.expiry_date);
    					$("#stock").val(value.stock);
    					$("#mrp_price").val(value.mrp);
    					$("#purchase_rate").val(value.purchase_price);
    					$("#sale_price").val(value.sale_price);
    					$("#cost_price").val(value.cost_price);
    					$("#vat").val(value.vat);
    	            });					
    		}
    });
}

	$(document).on('input',".onlyNumber",function() { 
		if (/[^0-9\.]/g.test(this.value))
	    {
	    	this.value = this.value.replace(/[^0-9\.]/g,'');
	    }
		if (this.value.length > 5) this.value = this.value.slice(0,5);
		if(this.value.split('.').length>2) 
			this.value =this.value.replace(/\.+$/,"");
	});

	$(document).on('input',".onlyNumberNotDecimal",function() {
		if (/[^0-9]/g.test(this.value))
	    {
	    	this.value = this.value.replace(/[^0-9]/g,'');
	    }
		if (this.value.length > 5) this.value = this.value.slice(0,5);
	});

	$(document).on('input',".batch_number,.item_name,.item_code",function() {
		if (/[^0-9 a-z A-Z-\.]/g.test(this.value))
	    {
	    	 this.value = this.value.replace(/[^0-9 a-z A-Z-\.]/g,'');
	    }
	}); 
</script>
