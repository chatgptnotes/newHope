<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#InventoryPurchaseReturnInventoryPurchaseReturnForm").validationEngine();
	});

</script>
<style>
.formErrorContent {
	width: 43px !important;
}
</style>
<?php

echo $this->Html->script('jquery.autocomplete_pharmacy');
echo $this->Html->css('jquery.autocomplete.css');

echo $this->Html->script('jquery.fancybox-1.3.4');
echo $this->Html->css('jquery.fancybox-1.3.4.css');
?>
<?php
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

<div class="inner_title">
	<h3>Purchase Return</h3>
	<span><?php
	echo $this->Html->link(__('Back'), array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
	?>
	</span>
</div>
<div class="clr ht5"></div>
<input type="hidden"
	value="1" id="no_of_fields" />
<?php echo $this->Form->create('InventoryPurchaseReturn');?>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="5" class="tdLabel2">Party Code</td>
		<td width="100" class="tdLabel2"><input
			name="InventoryPurchaseReturn[party_code]" type="text"
			class="textBoxExpnd" id="party_code" tabindex="3" value=""
			readonly="true" style="background-color: #808080" /></td>
		<td width="20">&nbsp;</td>
		<td width="80" class="tdLabel2">Party Name<font color="red">*</font>
		</td>
		<td width="150" class="tdLabel2"><input
			name="InventoryPurchaseReturn[party_name]" type="text"
			class="textBoxExpnd  validate[required]" id="party_name" tabindex="4"
			value="" style="width: 80%" /><input type="hidden"
			name="InventoryPurchaseReturn[party_id]" id="party_id"></td>
		<td width="20"><a id="partyList"
			style="cursor: pointer; text-decoration: underline;"
			href="<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_transaction","inventory" => true,"plugin"=>false)); ?>">Party</a>
		</td>

	</tr>
</table>
<div class="clr ht5"></div>
<table width="100%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm" id="item-row">
	<tr>
		<th width="40" align="center" valign="top" style="text-align: center;">Sr.No.</th>
		<th width="" align="center" valign="top" style="text-align: center;">Item Name<font color="red">*</font></th>
		<th width="80" align="center" valign="top" style="text-align: center;">Manufacturer</th>
		<th width="60" align="center" valign="top" style="text-align: center;">Pack</th>
		<th width="100" valign="top" style="text-align: center;">Batch No.<font color="red">*</font></th>
		<th width="120" align="center" valign="top" style="text-align: center;">Expiry Date<font color="red">*</font></th>
		<th width="50" valign="top" style="text-align: center;">Qty<font color="red">*</font></th>
		<th width="50" valign="top" style="text-align: center;">Free</th>
		<th width="50" valign="top" style="text-align: center;">Tax<font color="red">*</font></th>
		<th width="60" valign="top" style="text-align: center;">MRP<font color="red">*</font></th>
		<th width="60" valign="top" style="text-align: center;">Price<font color="red">*</font></th>
		<th width="80" valign="top" style="text-align: center;">Amount<font color="red">*</font></th>
		<th width="10" valign="top" style="text-align: center;">Action</th>
	</tr>
	<tr id="row1">
		<td align="center" valign="middle" class="sr_number">1</td>
		
		<td align="center" valign="middle" width="220">
		<input name="item_name[]" id="item_name1" type="text"
			class="textBoxExpnd validate[required] item_name" tabindex="6"
			value="" style="width: 70%;" fieldNo='1' />
			<a href="#" id="viewDetail1" class='fancy' style="visibility: hidden">
				<img title="View Item" alt="View Item" src="/drmHope/img/icons/view-icon.png"> 
			</a>
		</td>
		<td align="center" valign="middle"><input name="manufacturer[]"
			type="text" class="textBoxExpnd " id="manufacturer1" tabindex="3"
			value="" style="width: 80%;" readonly="true" /></td>
		
		<td align="center" valign="middle">
		<input name="item_id[]"
			id="item_id1" type="hidden" value="" /><input name="pack[]"
			id="pack_item_name1" type="text" class="textBoxExpnd" tabindex="7"
			value="" style="width: 80%;" readonly="true" /></td>

		<td align="center" valign="middle"><input name="batch_number[]"
			id="batch_number1" type="text"
			class="textBoxExpnd validate[required] batch_number" tabindex="8"
			value="" style="width: 80%;" fieldNo="1" /></td>
		<td valign="middle" style="text-align: center;" width="200"><table
				width="100%" cellpadding="0" cellspacing="0" border="0">

				<td width="135"><input name="expiry_date[]" type="text"
					id="expiry_date1"
					class="textBoxExpnd date validate[required,funcCall[checkExpiryDate]]"
					tabindex="9" value="" style="width: 65%;" /></td>

				</tr>
			</table></td>
		<td valign="middle" style="text-align: center;"><input name="qty[]"
			type="text"
			class="textBoxExpnd  quantity validate[required,custom[number]]"
			tabindex="10" value="" id="qty1" style="width: 70%;" fieldNo="1" /><input
			type="hidden" value="" id="stock1"></td>
		<td valign="middle" style="text-align: center;"><input name="free[]"
			type="text" class="textBoxExpnd" tabindex="11" value="" id="free1"
			style="width: 80%;" /></td>
		<td valign="middle" style="text-align: center;"><input name="tax[]"
			type="text"
			class="textBoxExpnd validate[required,custom[number]] tax"
			readonly="true" tabindex="11" value="" id="tax1"
			style="width: 80%; background-color: #808080" fieldNo="1" /></td>
		<td valign="middle" style="text-align: center;"><input name="mrp[]"
			type="text" class="textBoxExpnd validate[required,custom[number]]"
			tabindex="12" value="" id="mrp1"
			style="width: 80%; background-color: #808080" readonly="true" /></td>
		<td valign="middle" style="text-align: center;"><input name="price[]"
			type="text" class="textBoxExpnd validate[required,custom[number]]"
			tabindex="13" value="" id="price1"
			style="width: 80%; background-color: #808080" readonly="true" /></td>
		<td valign="middle" style="text-align: center;"><input name="value[]"
			type="text" class="textBoxExpnd validate[required] value" id="value1"
			tabindex="14" value="" style="width: 80%;" readonly="true" /></td>
		<td valign="middle" style="text-align: center;"><a href="#this"
			id="delete-row" onclick="deletRow('1');"><img title="delete row"
				alt="View Item" src="/drmHope/img/icons/cross.png"> </a></td>
	</tr>
</table>
<div class="clr ht5"></div>
<div align="right">
	<input name="" type="button" value="Add More" class="blueBtn"
		tabindex="36" onclick="addFields()" /><input name="" type="button"
		value="Remove" class="blueBtn" id="remove-btn" style="display: none"
		tabindex="36" onclick="removeRow()" />
</div>
<table id="d-type">
	<tr>
		<td width="200">&nbsp;</td>

		<td width="200">&nbsp;</td>
		<td width="200">&nbsp;</td>
		<td width="200">&nbsp;</td>
		<td width="330">&nbsp;</td>
		
		<td width="100" class="tdLabel2"><?php echo __("Total Amount :"); ?></td>
		<td width="93"><?php echo $this->Session->read('Currency.currency_symbol') ; ?>
			<span id="total_amount">0</span><input
			name="InventoryPurchaseReturn[total_amount]" id="total_amount_field"
			tabindex="35" value="0" type="hidden" /></td>
	</tr>
</table>
<div class="btns">
<!-- 	<input name="print" type="submit" value="Print" class="blueBtn" -->
<!-- 		tabindex="36" /> -->
		
		 <input name="submit" type="submit" value="Submit"
		class="blueBtn" tabindex="37" id="submitButton" />


</div>

<!-- billing activity form end here -->

<?php echo $this->Form->end();?>
<p class="ht5"></p>


<!-- Right Part Template ends here -->
</td>
</table>
<!-- Left Part Template Ends here -->

</div>
</td>
<td width="5%">&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td class="footStrp">&nbsp;</td>
	<td>&nbsp;</td>
</tr>
</table>

<script>

function deletRow(id){
    var number_of_field = parseInt($("#no_of_fields").val());
      if(number_of_field==1){
	 	alert("Single row can't delete.");
	 	return false;
		}
	//$("#row"+id).find("input").remove();
	$("#row"+id).remove();

	 $("#no_of_fields").val(number_of_field);
		var table = $('#item-row');
   				summands = table.find('tr');

					var sr_no = 1;
					summands.each(function ()
					{
							var cell = $(this).find('.sr_number');
							cell.each(function ()
							{
								$(this).html(sr_no);
								sr_no = sr_no+1;
							});

					});
					if (parseInt($("#no_of_fields").val()) == 1){
						$("#remove-btn").css("display","none");
					}
					$('.item_name'+number_of_field+"formError").remove();
	$('.batch_number'+number_of_field+"formError").remove();
	$('.expiry_date'+number_of_field+"formError").remove();
	$('.qty'+number_of_field+"formError").remove();
	$('.mrp'+number_of_field+"formError").remove();
	$('.price'+number_of_field+"formError").remove();
	$('.value'+number_of_field+"formError").remove();
	$('.tax'+number_of_field+"formError").remove();
	/*field = "<td align='center' colspan='12'> Row deleted</td>";
	$("#row"+id).append(field);*/

}
	$("#partyList").fancybox({
				'width'				: '75%',
				'height'			: '75%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
$( ".date" ).datepicker({
			showOn: "button",
			buttonImage: "/drmHope/img/js_calendar/calendar.gif",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,
			yearRange: '1950',
			dateFormat:'<?php echo $this->General->GeneralDate();?>',
			minDate: new Date(),
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
				 "number": {
                    // Number, including positive, negative, and floating decimal. credit: orefalo
                    "regex": /^[\+]?(([0-9]+)([\.,]([0-9]+))?|([\.,]([0-9]+))?)$/,
                    "alertText": "* Invalid format"
                },
				"future":{
				 	"alertText": "Expiry Date should be future date."
				},
				"expirydate":{
				 	"alertText": "Expiry Date should be future date."
				}
            };

        }
    };
    $.validationEngineLanguage.newLang();
})(jQuery);

       function checkExpiryDate(field, rules, i, options){
            var today=new Date();
            var curDate = new Date(today.getFullYear(),today.getMonth(),today.getDate());
            var inputDate = field.val().split("/");
            var inputDate1 = new Date(inputDate[2],eval(inputDate[1]-1),inputDate[0]);
            if (field.val() != "") {
	            if (inputDate1 <= curDate) {
	             return options.allrules.expirydate.alertText;
	            }
	        }

		}

function addFields(){
		   var number_of_field = parseInt($("#no_of_fields").val())+1;
           var field = '';
		   field += '<tr id="row'+number_of_field+'"><td align="center" valign="middle" class="sr_number">'+number_of_field+'</td>';
           field += '<td align="center" valign="middle" width="220"><input name="item_name[]" id="item_name'+number_of_field+'" type="text" class="textBoxExpnd validate[required] item_name"  tabindex="6" value="" style="width:70%;" fieldNo="'+number_of_field+'"/> <a href="#" id="viewDetail'+number_of_field+'"'+number_of_field+'" class="fancy" style="visibility:hidden;"><img title="View Item" alt="View Item" src="/drmHope/img/icons/view-icon.png"></a></td>';
           field += '<td align="center" valign="middle"><input name="manufacturer[]" readonly="true" id="manufacturer'+number_of_field+'" type="text" class="textBoxExpnd"  tabindex="8" value=""  style="width:80%;" autocomplete="off"/></td>';
		   field += ' <input name="item_id[]" id="item_id1" type="hidden"   value=""/><td align="center" valign="middle"><input name="pack[]" id="pack_item_name'+number_of_field+'" type="text" class="textBoxExpnd "  tabindex="7" value=""  style="width:80%;" readonly="true"/></td>';

           field += '<td align="center" valign="middle"><input name="batch_number[]" id="batch_number'+number_of_field+'" type="text" class="textBoxExpnd validate[required] batch_number"  tabindex="8" value=""  style="width:80%;" fieldNo="'+number_of_field+'"/></td>';
           field += '<td valign="middle" style="text-align:center;"><table width="100%" cellpadding="0" cellspacing="0" border="0"><td width="135"><input name="expiry_date[]" type="text" id="expiry_date'+number_of_field+'" class="textBoxExpnd date validate[required,funcCall[checkExpiryDate]]" tabindex="9" value="" style="width:65%;" /></td></tr> </table></td>';

           field += ' <td valign="middle" style="text-align:center;"><input name="qty[]" type="text" class="textBoxExpnd quantity validate[required,custom[number]]"  tabindex="10" value="" id="qty'+number_of_field+'" style="width:70%;" fieldNo="'+number_of_field+'"/><input type="hidden" value="" id="stock'+number_of_field+'"></td>';

		  field += '<td valign="middle" style="text-align:center;"><input name="free[]" type="text" class="textBoxExpnd"  tabindex="11" value="" id="free'+number_of_field+'"  style="width:80%;"/></td>';

		  	  field += '<td valign="middle" style="text-align:center;"><input name="tax[]" type="text" class="textBoxExpnd validate[required,custom[number]] tax" readonly="true" tabindex="11" value="" id="tax'+number_of_field+'"  style="width:80%;background-color:#808080;" fieldNo="'+number_of_field+'"/></td>';

           field += '<td valign="middle" style="text-align:center;"><input name="mrp[]" type="text" class="textBoxExpnd validate[required]"  tabindex="12" value="" id="mrp'+number_of_field+'" style="width:80%;background-color:#808080" readonly="true" /></td>';

           field += '<td valign="middle" style="text-align:center;"><input name="price[]" type="text" class="textBoxExpnd"  tabindex="13" value="" id="price'+number_of_field+'" style="width:80%;background-color:#808080" readonly="true" /></td>';

           field += ' <td valign="middle" style="text-align:center;"><input name="value[]" type="text" class="textBoxExpnd validate[required] value" id="value'+number_of_field+'"  tabindex="14" value=""  style="width:80%;" style="width:80%;background-color:#808080" readonly="true"/></td> ';
		   field +='<td valign="middle" style="text-align:center;"> <a href="#this" id="delete-row" onclick="deletRow('+number_of_field+');"><img title="delete row" alt="View Item" src="/drmHope/img/icons/cross.png" ></a></td>';
		  field +='  </tr>    ';
      	$("#no_of_fields").val(number_of_field);
		$("#item-row").append(field);
		$("#expiry_date"+number_of_field).datepicker({
			showOn: "button",
			buttonImage: "/drmHope/img/js_calendar/calendar.gif",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,
			yearRange: '1950',
			dateFormat:'<?php echo $this->General->GeneralDate();?>',


		});
			if (parseInt($("#no_of_fields").val()) == 1){
						$("#remove-btn").css("display","none");
					}else{
		$("#remove-btn").css("display","inline");
		}
}
function removeRow(){
 	var number_of_field = parseInt($("#no_of_fields").val());
	if(number_of_field > 1){
		$("#row"+number_of_field).remove();

		$("#no_of_fields").val(number_of_field-1);
	}
	if (parseInt($("#no_of_fields").val()) == 1){
		$("#remove-btn").css("display","none");
	}
}

$(".quantity").live('blur',function()
			  {
			   $("#cst").val("");
			   $("#tax").val("");
			   $("#extra_amount").val("");
			   $("#credit_amount").val("");
			  if($(this).val()!=""){
			 	var currentField = $(this);
				var fieldno = currentField.attr('fieldNo') ;
				var qty = currentField.val();
				var stock = parseInt($("#stock"+fieldno).val());
				if(isNaN(qty)||qty.indexOf(".")<0 == false){
					alert("Invalid Quantity");
					currentField.val("");
					setTimeout(function() { currentField.focus(); }, 50);
					$("#submitButton").attr('disabled','disabled')
					return false;
				}else if(qty>stock){
					alert("Stock for "+$("#item_name"+fieldno).val()+" is "+stock);
					currentField.val("");
					setTimeout(function() { currentField.focus(); }, 50);
					$("#submitButton").attr('disabled','disabled');
					return false;
				}else{
					qty = parseInt(qty);
					$("#submitButton").removeAttr('disabled');
				}
				var tax = parseFloat($("#tax"+fieldno).val());
				if(isNaN(tax)){
					//alert("Enter the Tax");
					setTimeout(function() { $("#tax"+fieldno).focus(); }, 50);
					return false;
				}
				var qty =parseFloat($("#qty"+fieldno).val());
                var price = parseFloat($("#price"+fieldno).val());
				var value = price*qty;
				var	sub_total = value+((value*tax)/100);

				$("#value"+fieldno).val((sub_total.toFixed(2)));
				var $form = $('#InventoryPurchaseReturnInventoryPurchaseReturnForm'),
   				$summands = $form.find('.value');

					var sum = 0;
					$summands.each(function ()
					{
						var value = Number($(this).val());
						if (!isNaN(value)) sum += value;
					});

				$("#total_amount_field").val(sum.toFixed(2));
				$("#total_amount").html(sum.toFixed(2));
			 }
			  });
  $(".batch_number").live('blur',function()
  {
     var t = $(this);
     var fieldno = t.attr('fieldNo') ;
    setTimeout(function() { $("#qty"+fieldno).focus(); }, 50);

  });
$(".tax").live('blur',function()
			  {
			   $("#cst").val("");
			   $("#tax").val("");
			   $("#extra_amount").val("");
			   $("#credit_amount").val("");
			  if($(this).val()!=""){
			 	var currentField = $(this);
				var fieldno = currentField.attr('fieldNo') ;
				var tax = currentField.val();
				if(isNaN(tax)||tax == 0){
					alert("Invalid Tax Amount");
					currentField.val("");
					setTimeout(function() { currentField.focus(); }, 50);
					$("#submitButton").attr('disabled','disabled')
					return false;
				}else{
					tax = parseInt(tax);
					$("#submitButton").removeAttr('disabled');
				}
				var qty =parseFloat($("#qty"+fieldno).val());
				if(isNaN(qty)){
					alert("Enter the Quantity");
					setTimeout(function() { $("#qty"+fieldno).focus(); }, 50);
					return false;
				}
                var price = parseFloat($("#price"+fieldno).val());
				var value = price*qty;
				var	sub_total = value+((value*tax)/100);
				$("#value"+fieldno).val((sub_total.toFixed(2)));
				var $form = $('#InventoryPurchaseReturnInventoryPurchaseReturnForm'),
   				$summands = $form.find('.value');

					var sum = 0;
					$summands.each(function ()
					{
						var value = Number($(this).val());
						if (!isNaN(value)) sum += value;
					});

				$("#total_amount_field").val(sum.toFixed(2));
				$("#total_amount").html(sum.toFixed(2));
			 }
			  });

/* load the data from supplier master */
function loadDataFromRate(supplier_id){

	$.ajax({
		  type: "POST",
		  url: "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "view_supplier",null,'true',"inventory" => true,"plugin"=>false)); ?>",
		  data: "id="+supplier_id,
		}).done(function( msg ) {
		 	var supplier = jQuery.parseJSON(msg);
		 	$("#party_code").val(supplier.InventorySupplier.code);

	});


}


	/* for auto populate the data */
function selectItem(li) {
	if( li == null ) return alert("No match!");
		var itemID = li.extra[0];
		$("#party_id").val(itemID);
		loadDataFromRate(itemID);

}
$('.item_name').live('focus',function()
		  {
		  if($("#party_id").val()==""){
		  	alert("Please select Supplier.");
			setTimeout(function() { $("#party_name").focus(); }, 10);
			return false;
		  }
		  	  var t = $(this);
		    $(this).autocomplete(
	"<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","PharmacyItem","name", "admin" => false,"plugin"=>false)); ?>",
	{
		selectFirst: false,
		matchSubset:1,
		matchContains:1,
		autoFill:false,
		extraParams: {supplierID:$("#party_id").val() },
		onItemSelect:function (data1) {
		    selectedId = t.attr('id');
		    var itemID = data1.extra[0];
			var fieldno = $("#"+selectedId).attr('fieldNo') ;
			$("#item_id"+fieldno).val(itemID);
			$("#viewDetail"+fieldno).attr('href','view_item/'+itemID+'?popup=true');
			$("#viewDetail"+fieldno).css("visibility","visible");
		 	var currentField = $(this);
			$.ajax({
			  type: "POST",
			  url: "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_rate_for_item","inventory" => true,"plugin"=>false)); ?>",
			  data: "item_id="+itemID,
			}).done(function( msg ) {
				var ItemDetail = jQuery.parseJSON(msg);
				$("#pack_item_name"+fieldno).val(ItemDetail.PharmacyItem.pack);
              $("#manufacturer"+fieldno).val(ItemDetail.PharmacyItem.manufacturer);
              $("#stock"+fieldno).val(ItemDetail.PharmacyItem.stock);
              $("#batch_number"+fieldno).val(ItemDetail.PharmacyItemRate.batch_number);
              $("#expiry_date"+fieldno).val(ItemDetail.PharmacyItemRate.expiry_date);
				$("#mrp"+fieldno).val(ItemDetail.PharmacyItemRate.mrp);
				$("#tax"+fieldno).val(ItemDetail.PharmacyItemRate.tax);
				$("#price"+fieldno).val(ItemDetail.PharmacyItemRate.sale_price);
					if(ItemDetail.PharmacyItemRate.id==null || ItemDetail.PharmacyItemRate.purchase_price=="0" || ItemDetail.PharmacyItemRate.purchase_price==""){
					 $.fancybox(
						{
						'width'				: '80%',
						'height'			: '100%',
						'autoScale': true,
						'transitionIn': 'fade',
						'transitionOut': 'fade',
						'type': 'iframe',
						'href': '<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "item_rate_master","inventory" => true,"plugin"=>false)); ?>/'+ItemDetail.PharmacyItem.id+'/layout/'+fieldno,
						'onClosed': function (currentArray, currentIndex, currentOpts) {
      					$.ajax({
							  type: "POST",
							  url: "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_rate_for_item","inventory" => true,"plugin"=>false)); ?>",
							  data: "item_id="+itemID,
							}).done(function( msg ) {
								var ItemDetail = jQuery.parseJSON(msg);

								//$("#mrp"+fieldno).val(ItemDetail.PharmacyItemRate.mrp);
								$("#stock"+fieldno).val(ItemDetail.PharmacyItem.stock);
								$("#batch_number"+fieldno).val(ItemDetail.PharmacyItemRate.batch_number);
								$("#expiry_date"+fieldno).val(ItemDetail.PharmacyItemRate.expiry_date);
								$("#mrp"+fieldno).val(ItemDetail.PharmacyItemRate.mrp);
								$("#tax"+fieldno).val(ItemDetail.PharmacyItemRate.tax);
								$("#price"+fieldno).val(ItemDetail.PharmacyItemRate.sale_price);
								//$("#price"+fieldno).val((ItemDetail.PharmacyItemRate.purchase_price));
							});

  					}
						});
						}
		});

			function loadDataFromRate(itemID,selectedId){
				var currentField = $("#"+selectedId);
				var fieldno = currentField.attr('fieldNo') ;
				$.ajax({
					  type: "POST",
					  url: "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_rate_for_item",'item_id','true',"inventory" => true,"plugin"=>false)); ?>",
					  data: "item_id="+itemID,
					}).done(function( msg ) {
					 	var item = jQuery.parseJSON(msg);
						$("#item_name"+fieldno).val(item.PharmacyItem.name);
						$("#item_id"+fieldno).val(item.PharmacyItem.id);
						$("#item_code"+fieldno).val(item.PharmacyItem.item_code);
			            $("#manufacturer"+fieldno).val(item.PharmacyItem.manufacturer);
					 	$("#pack"+fieldno).val(item.PharmacyItem.pack);
						$("#batch_number"+fieldno).val(item.PharmacyItemRate.batch_number);
						$("#stockQty"+fieldno).val(item.PharmacyItem.stock);
						$("#mrp"+fieldno).val(item.PharmacyItemRate.mrp);
						$("#tax"+fieldno).val(ItemDetail.PharmacyItemRate.tax);
						$("#rate"+fieldno).val(item.PharmacyItemRate.cost_price);


				});
					selectedId='';

			}
			$("#viewDetail"+fieldno).fancybox({
					'width'				: '80%',
					'height'			: '100%',
					'autoScale'			: false,
					'transitionIn'		: 'none',
					'transitionOut'		: 'none',
					'type'				: 'iframe'
				});
		},
	}
);
		  });
function selectItemDetail(){

}
 $('#party_name').live('focus',function()  {
	$(this).autocomplete(
			"<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","InventorySupplier","name", "admin" => false,"plugin"=>false)); ?>",
			{
				matchSubset:1,
				matchContains:1,
				cacheLength:10,
				onItemSelect:selectItem,
				autoFill:false
			}
		);

	}
		);
$(".batch_number").live('focus',function()
			  {
			  var t = $(this);

			  var fieldno = t.attr('fieldNo') ;
			 $(this).autocomplete(
		"<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_batch_number_of_item","inventory" => true,"plugin"=>false)); ?>",
		{
			matchSubset:1,
			matchContains:1,
			cacheLength:10,
			onItemSelect:function (data1) {
			$("#expiry_date"+fieldno).val(data1.extra[0]);
            	$.ajax({
        		  type: "GET",
        		  url: "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_rate_from_batch_no","inventory" => true,"plugin"=>false)); ?>",
        		  data: "batchno="+$("#batch_number"+fieldno).val()+"&item_id="+$("#item_id"+fieldno).val()+"&source=purchaseReturn",
        		}).done(function( msg ) {
        		 	var ItemDetail = jQuery.parseJSON(msg);
        		 	//code for else is commented @controller  - gaurav
						if(ItemDetail.InventoryPurchaseItemDetail){
	            		 	$("#mrp"+fieldno).val(ItemDetail.InventoryPurchaseItemDetail.mrp);
	                    	$("#price"+fieldno).val(ItemDetail.InventoryPurchaseItemDetail.price);
							$("#tax"+fieldno).val(ItemDetail.InventoryPurchaseItemDetail.tax);
						}else if(ItemDetail.PharmacyItemRate){
							$("#mrp"+fieldno).val(ItemDetail.PharmacyItemRate.mrp);
	                    	$("#price"+fieldno).val(ItemDetail.PharmacyItemRate.cost_price);
							$("#tax"+fieldno).val(ItemDetail.PharmacyItemRate.tax);
						}
                        setTimeout(function() { $("#qty"+fieldno).focus(); }, 50);
                	});

            },
  	autoFill:false,
		extraParams: {itemId:$("#item_id"+fieldno).val() },
		}
	);

});

</script>
