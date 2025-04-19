<style>.row_action img{float:inherit;}</style>


<?php
if(isset($is_layout)){
	echo $this->Html->script(array('jquery-1.5.1.min','validationEngine.jquery',
			'jquery.validationEngine','/js/languages/jquery.validationEngine-en','jquery-ui-1.8.16.custom.min','jquery.ui.widget.js','jquery.ui.mouse.js','jquery.ui.core.js','ui.datetimepicker.3.js','permission.js'));
	echo $this->Html->css(array('datePicker.css','jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','internal_style.css'));
}
?>
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#PharmacyItemRateInventoryItemRateMasterForm").validationEngine();
	});	

</script>
<?php
echo $this->Html->script('jquery.autocomplete_pharmacy');
echo $this->Html->css('jquery.autocomplete.css');
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
	<h3>
		&nbsp;
		<?php echo __('Pharmacy Management - Item Rate Master', true); ?>
	</h3>
	<span>
	<?php if($flagForBack!=1){?> 
	<?php
	if(!isset($is_layout))
		echo $this->Html->link(__('Back'), array('controller'=>'Pharmacy','action' => 'view_item_rate','inventory'=>false), array('escape' => false,'class'=>'blueBtn'));
	?>
	<?php } ?>
	</span>

</div>
<table border="0" cellpadding="0" cellspacing="0" width="100%"
	class="table-format">

</table>
<div class="clr ht5"></div>
<?php echo $this->Form->create('PharmacyItemRate',array('id'=>'ItemRateMasterForm'));?>


<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
	<tr>

		<td width="100" class="tdLabel" id="boxSpace">Item Name<font
			color="red">*</font>
		</td>
		<td width="250"><input type="text" name="item_name" id="item_name"
			class="textBoxExpnd validate[required]" tabindex="1"
			value="<?php echo $itemDetails['PharmacyItem']['name'];?>" /></td>

		<td width="100" valign="middle" class="tdLabel" id="boxSpace">Item
			Code
		</td>
		<td width="250"><input type="text" name="item_code" id="item_code"
			class="textBoxExpnd" tabindex="2"
			autocomplete="false"
			value="<?php echo $itemDetails['PharmacyItem']['item_code'];?>" /> <input
			type="hidden" name="PharmacyItemRate[item_id]" id="item_id"
			value="<?php echo $itemDetails['PharmacyItem']['id'];?>" />
			<input
			type="hidden" name="PharmacyItemRate[id]" id="item_id"
			value="<?php echo $itemDetails['PharmacyItemRate']['id'];?>" />
		</td>
	</tr>
	<tr>
		<td valign="middle" class="tdLabel" id="boxSpace">Batch No.<font
			color="red">*</font>
		</td>
		<td><input type="text" name="PharmacyItemRate[batch_number]"
			id="batch_number" class="textBoxExpnd validate[required]"
			tabindex="3"
			value="<?php echo $itemDetails['PharmacyItemRate']['batch_number'];?>"
			style="text-align: left" /></td>
		
		<td class="tdLabel" id="boxSpace">Expiry Date:<font
			color="red">*</font></td>
			
		<td width=""><input name="PharmacyItemRate[expiry_date]" type="text"
						class="textBoxExpnd" id="expiry_date" tabindex="4" style="width: 50%"
						value="<?php echo $this->DateFormat->formatDate2Local($itemDetails['PharmacyItemRate']['expiry_date'],Configure::read('date_format'),true);?>" />
			</td>

	</tr>
	<tr>
		<td valign="middle" class="tdLabel" id="boxSpace">Pur. Price.<font
			color="red">*</font>
		</td>
		<td><input type="text" name="PharmacyItemRate[purchase_price]"
			id="purchase_rate"
			class="textBoxExpnd validate[required,custom[number]]"
			style="text-align: right" tabindex="5"
			value="<?php echo !empty($itemDetails['PharmacyItemRate']['purchase_price'])?$itemDetails['PharmacyItemRate']['purchase_price']:'';?>" />
			<?php echo $this->Session->read('Currency.currency_symbol') ; ?></td>
		
		
		<td class="tdLabel" id="boxSpace">Sale Price<font color="red">*</font>
		</td>
		<td><input type="text" name="PharmacyItemRate[sale_price]"
			id="sale_price"
			class="textBoxExpnd validate[required,custom[number]]"
			style="text-align: right" tabindex="6"
			value="<?php echo !empty($itemDetails['PharmacyItemRate']['sale_price'])?$itemDetails['PharmacyItemRate']['sale_price']:'';?>" /> <?php echo $this->Session->read('Currency.currency_symbol') ; ?>
		</td>
		
<!-- 		<td class="tdLabel" id="boxSpace">CST</td> -->
<!-- 		<td><input type="text" name="PharmacyItemRate[cst]" id="cst" -->
<!-- 			class="textBoxExpnd validate[custom[number]]" tabindex="6" 
			value="<?php echo $itemDetails['PharmacyItemRate']['cst'];?>" /></td>-->
	</tr>
	<tr>
		<td valign="middle" class="tdLabel" id="boxSpace">Cost Price
		</td>
		<td><input type="text" name="PharmacyItemRate[cost_price]"
			id="cost_price"
			class="textBoxExpnd validate[custom[number]]" tabindex="7"
			style="text-align: right"
			value="<?php echo !empty($itemDetails['PharmacyItemRate']['cost_price'])?$itemDetails['PharmacyItemRate']['cost_price']:'';?>" /> <?php echo $this->Session->read('Currency.currency_symbol') ; ?>
		</td>
		
		<td valign="middle" class="tdLabel" id="boxSpace">Stock (MSU) </td>
		<td>
			<input type="hidden" name="PharmacyItemRate[pack]" id="pack" value="<?php echo $itemDetails['PharmacyItem']['pack']; ?>"/>
			<input type="hidden" name="PharmacyItemRate[loose_stock]" id="pack" value="<?php echo $itemDetails['PharmacyItemRate']['loose_stock']; ?>"/>
			<input type="text" name="PharmacyItemRate[stock]" id="stock"
			class="textBoxExpnd validate[custom[number]]" tabindex="8"
			value="<?php echo $msu = ($itemDetails['PharmacyItem']['pack'] * $itemDetails['PharmacyItemRate']['stock'])+ $itemDetails['PharmacyItemRate']['loose_stock'];?>"
			style="text-align: right" readonly /> 
			<input type="hidden" name="PharmacyItemRate[stockHiddn]" id="stockHiddn"
			class="textBoxExpnd validate[custom[number]]" tabindex="8"
			value="<?php echo $msu;?>"
			style="text-align: right" />
			
		</td>
		
	</tr>
	<tr>
		<td valign="middle" class="tdLabel" id="boxSpace">MRP<font color="red">*</font>
		</td>
		<td><input type="text" name="PharmacyItemRate[mrp]" id="mrp_price"
			class="textBoxExpnd validate[required,custom[number]]" tabindex="9"
			value="<?php echo !empty($itemDetails['PharmacyItemRate']['mrp'])?$itemDetails['PharmacyItemRate']['mrp']:'';?>"
			style="text-align: right" /> <?php echo $this->Session->read('Currency.currency_symbol') ; ?>
		</td>
		<?php if($websiteConfig['instance'] == 'kanpur'){ ?>
		
		<td class="tdLabel" id="boxSpace"> Vat Class </td>
		<td><?php //debug($itemDetails); ?>
			<?php echo $this->Form->input('',array('type'=>'select','class'=>'textBoxExpnd','id'=>'vat','calss'=>'vatClass', 'style'=>"width: 23%",'empty'=>'Please select','autocomplete'=>"off",'label'=>false,'name'=>"data[PharmacyItemRate][vat_class_id]",'options'=>$vatData,'value'=>$itemDetails['PharmacyItemRate']['vat_class_id'])); ?>
		</td>
		<?php }else{ ?>
		<td class="tdLabel" id="boxSpace">Tax%</td>
		<td><input type="text" name="PharmacyItemRate[tax]" id="tax"
			class="textBoxExpnd validate[custom[number]]" tabindex="10"
			value="<?php echo !empty($itemDetails['PharmacyItemRate']['tax'])?$itemDetails['PharmacyItemRate']['tax']:'';?>" /></td>
		<?php } ?>
		


	</tr>

</table>

<!-- billing activity form end here -->
<div class="btns">
	<input name="" type="submit" value="Submit" class="blueBtn"
		tabindex="9" id="submitButton"/>


</div>
<?php echo $this->Form->end();?>
<p class="ht5"></p>

<!-- Right Part Template ends here -->
</td>
</table>
<script>
<?php
if(!isset($is_layout)){ ?>
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
<?php } ?>

$("#submitButton").click(function(){
	var valid = jQuery("#ItemRateMasterForm").validationEngine('validate');
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
$("#item_code").focus(function(){
	$(this).autocomplete(
		"<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "autocomplete_item","item_code","inventory" => true,"plugin"=>false)); ?>",
		{
			matchSubset:1,
			matchContains:1,
			cacheLength:10,
			onItemSelect:selectItem,
			autoFill:false,
		     extraParams: {
                    list: 'all'
                },
		}
	);
	});
	$("#item_name").focus(function(){
	$(this).autocomplete(
		"<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "autocomplete_item","name","inventory" => true,"plugin"=>false)); ?>",
		{
			matchSubset:1,
			matchContains:1,
			cacheLength:10,
  	        onItemSelect:selectItem,
			autoFill:false,
			extraParams: {
                    list: 'all'
                },
		}
	);
	});
	$( "#expiry_date" ).datepicker({
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',			 
		dateFormat:'<?php echo $this->General->GeneralDate("");?>',
        
	});

$("#batch_number").focus(function()
			  {


			 $(this).autocomplete(
		"<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_batch_number_of_item","inventory" => true,"plugin"=>false)); ?>",
		{
			matchSubset:1,
			matchContains:1,
			onItemSelect:loadDataFromRate,
			autoFill:false,
			extraParams: {itemId:$("#item_id").val() },
		}
	);

});

/* load the data from rate master */
function loadDataFromRate(li){ 
	           var batch_no = $("#batch_number").val();
               // $("#expiry_date").val(li.extra[0]);
    	       $("#mrp_price").val("");
            	$("#purchase_rate").val("");
    	 	     $("#cost_price").val("");
    		 	$("#tax").val("");
    		 	$("#cst").val("");
    		 	$("#sale_price").val("");
    	$.ajax({
		  type: "GET",
		  url: "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_rate_from_batch_no","inventory" => true,"plugin"=>false)); ?>",
		  data: "batchno="+batch_no+"&item_id="+$("#item_id").val(),
		}).done(function( msg ) {
		 	var ItemDetail = jQuery.parseJSON(msg);
            if(ItemDetail.PharmacyItemRate){ 
    		 	$("#mrp_price").val(ItemDetail.PharmacyItemRate.mrp); 
            	$("#purchase_rate").val(ItemDetail.PharmacyItemRate.purchase_price);
    	 	     $("#cost_price").val(ItemDetail.PharmacyItemRate.cost_price);
    		 	$("#tax").val(ItemDetail.PharmacyItemRate.tax);
    		 	$("#cst").val(ItemDetail.PharmacyItemRate.cst);
    		 	$("#sale_price").val(ItemDetail.PharmacyItemRate.sale_price);
            }else{
            	//$("#mrp_price").val(ItemDetail.InventoryPurchaseItemDetail.mrp);
        	      // $("#purchase_rate").val(ItemDetail.InventoryPurchaseItemDetail.price);

            }

	});
    	
}
</script>
