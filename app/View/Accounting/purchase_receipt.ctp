<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#PurchaseReceiptForm").validationEngine();
	});

</script>
<style>
.formErrorContent {
	width: 43px !important;
}
</style>
<?php
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
	<h3>Purchase Receipt</h3>
	<span><?php
	echo $this->Html->link(__('Back'), array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
	?> </span>
</div>
<div class="clr ht5"></div>
<input type="hidden" value="1"
	id="no_of_fields" />
<?php echo $this->Form->create('PurchaseReceipt',array('url'=>Array('controller'=>'Accounting','action'=>'purchase_receipt'),'id'=>'PurchaseReceiptForm',
															'inputDefaults'=>array('div'=>false,'label'=>false,'error'=>false)));
	echo $this->Form->hidden('PurchaseReceipt.id',array('type'=>'text'));?>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td><?php echo __('Voucher. No. :')?> <?php echo $pr_no ?>
			<?php echo $this->Form->hidden('PurchaseReceipt.purchase_receipt_no',array('type'=>'text','id'=>'purchase_receipt_no','value'=>$pr_no)) ?>
		</td>
		
		<td width="10">&nbsp;</td>
		<td ><?php echo __('Voucher. Dt.:')?><font color="red">*</font></td>
		<td><?php echo $this->Form->input('PurchaseReceipt.voucher_date', array('label'=>false,'type'=>'text','class' =>'validate[required,custom[mandatory-enter]] textBoxExpnd','id' => 'voucher_date','readonly'=>'readonly')); ?>
		</td>
		<td width="2">&nbsp;</td>
		
		<td class=""><?php echo __('Party Name :')?><font color="red">*</font> </td><td><?php  echo $this->Form->input('PurchaseReceipt.party_name', array('class'=>'validate[required,custom[mandatory-enter]]','id' => 'party_name','value'=>$this->data['AccountAlias']['name'],'label'=>false)); ?>
		<?php  
		echo $this->Form->hidden('PurchaseReceipt.id',array('type'=>'text'));
		echo $this->Form->hidden('PurchaseReceipt.account_id', array('type'=>'text','id' => 'account_id')); ?>
		</td>
		
		
		<td class=""><?php echo __('Reference No. :')?><font color="red">*</font> </td>
		<td>
		<?php  echo $this->Form->input('PurchaseReceipt.reference_no',array('type'=>'text','id' => 'reference_no'));?>
		</td>
		
		<td>&nbsp;</td>
	</tr>
</table>
<div class="clr ht5"></div>
<table width="100%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm" id="item-row">
	<tr>
		<th width="40" align="center" valign="top" style="text-align: center;">Sr.No.</th>
		<th width="120" align="center" valign="top" style="text-align: center;">Item Name</th>
		<th width="80" align="center" valign="top" style="text-align: center;">Manufacturer</th>
		<th width="20" align="center" valign="top" style="text-align: center;">Pack</th>
		<th width="60" valign="top" style="text-align: center;">Batch No.</th>
		<th width="30" valign="top" style="text-align: center;">Qty</th>
		<th width="20" valign="top" style="text-align: center;">Free</th>
		<th width="20" valign="top" style="text-align: center;">Tax (%)</th>
		<th width="60" valign="top" style="text-align: center;">MRP</th>
		<th width="60" valign="top" style="text-align: center;">Price</th>
		<th width="80" valign="top" style="text-align: center;">Amount</th>
	</tr>
	<tr id="row1">
		<td align="center" valign="middle" class="sr_number">1</td>
		<td align="center" valign="middle" width="200">
										  <?php echo $this->Form->input("PurchaseReceipt.$cnt.item_name",array('id'=>"item_name_$cnt",'type'=>'text','class' =>''));?>
										  <!-- <input name="PurchaseReceipt_item_name[]" id="item_name1" type="text" class="textBoxExpnd validate[required] item_name" tabindex="6" value="" style="width: 65%;" fieldNo='1' onkeyup="checkIsItemRemoved(this)" /> --> 
										   <?php echo $this->Form->hidden("PurchaseReceipt.$cnt.item_id",array('id'=>"item_id_$cnt",'type'=>'hidden','class' =>''));?>
										<!--   <input name="item_id[]" id="item_id1" type="hidden" value="" /><a href="#" id="viewDetail1" class='fancy' style="visibility: hidden"><img title="View Item" alt="View Item" src="/img/icons/view-icon.png"> </a></td>-->
		<td align="center" valign="middle">
			<?php echo  $this->Form->input("PurchaseReceipt.$cnt.manufacturer",array('id'=>"manufacturer_$cnt",'type'=>'input','class' =>'','type'=>'text','autocomplete'=>'off')); ?>
			<!-- <input name="manufacturer[]" type="text" class="textBoxExpnd " id="manufacturer1" tabindex="3" value="" style="width: 80%;" /></td> -->
		<td align="center" valign="middle">
			<?php echo  $this->Form->input("PurchaseReceipt.$cnt.pack",array('id'=>"pack_$cnt",'type'=>'input','class' =>'','type'=>'text','autocomplete'=>'off')); ?>
			<!-- <input name="pack[]" id="pack_item_name1" type="text" class="textBoxExpnd" tabindex="7" value="" style="width: 40%;"  /></td>-->
		<td align="center" valign="middle">
			<?php echo  $this->Form->input("PurchaseReceipt.$cnt.batch_number",array('id'=>"batch_number_$cnt",'type'=>'input','class' =>'','type'=>'text','autocomplete'=>'off')); ?>
			<!-- <input name="batch_number[]" id="batch_number1" type="text" class="textBoxExpnd validate[required] batch_number" tabindex="8" value="" style="width: 80%;" fieldNo="1" canadd="1" /></td> -->
		<td valign="middle" style="text-align: center;">
			<?php echo  $this->Form->input("PurchaseReceipt.$cnt.qty",array('id'=>"qty_$cnt",'type'=>'input','class' =>'','type'=>'text','autocomplete'=>'off')); ?>
			<!-- <input name="qty[]" type="text" class="textBoxExpnd  quantity validate[required,custom[number]]" tabindex="10" value="" id="qty1" style="width: 70%;" fieldNo="1" /><input type="hidden" value="" id="stock1"></td> -->
		<td valign="middle" style="text-align: center;">
			<?php echo  $this->Form->input("PurchaseReceipt.$cnt.free",array('id'=>"free_$cnt",'type'=>'input','class' =>'','type'=>'text','autocomplete'=>'off')); ?>
			<!-- <input name="free[]" type="text" class="textBoxExpnd" tabindex="11" value="" id="free1" style="width: 40%;" /></td> -->
		<td valign="middle" style="text-align: center;">
			<?php echo  $this->Form->input("PurchaseReceipt.$cnt.tax",array('id'=>"tax_$cnt",'type'=>'input','class' =>'','type'=>'text','autocomplete'=>'off')); ?>
			<!-- <input name="tax[]" value="0" type="text" class="textBoxExpnd validate[custom[number]] tax" tabindex="11" value="0" id="tax1" style="width: 40%;" fieldNo="1" /></td> -->
		<td valign="middle" style="text-align: center;">
			<?php echo  $this->Form->input("PurchaseReceipt.$cnt.mrp",array('id'=>"mrp_$cnt",'type'=>'input','class' =>'','type'=>'text','autocomplete'=>'off')); ?>
			<!-- <input name="mrp[]" type="text" class="textBoxExpnd validate[required,custom[number]]" tabindex="12" value="" id="mrp1" style="width: 80%;" /></td> -->
		<td valign="middle" style="text-align: center;">
			<?php echo  $this->Form->input("PurchaseReceipt.$cnt.price",array('id'=>"price_$cnt",'type'=>'input','class' =>'','type'=>'text','autocomplete'=>'off')); ?>
			<!-- <input name="price[]" type="text" class="textBoxExpnd validate[required,custom[number]] price" tabindex="13" value="" id="price1" style="width: 80%;" fieldNo="1" /></td> -->
		<td valign="middle" style="text-align: center;">
			<?php echo  $this->Form->input("PurchaseReceipt.$cnt.value",array('id'=>"value_$cnt",'type'=>'input','class' =>'','type'=>'text','autocomplete'=>'off')); ?>
			<!-- <input name="value[]" type="text" class="textBoxExpnd value" id="value1" tabindex="14"value="" style="width: 80%;" readonly="true" /></td> -->
		<td valign="middle" style="text-align: center;"><a href="#this"id="delete row" onclick="deletRow('1');"><img title="delete row"alt="Remove Product" src="/img/icons/cross.png"> </a></td>
	</tr>
</table>
<div class="clr ht5"></div>

<div align="right">
	<input name="" type="button" value="Add More" class="blueBtn" tabindex="36" onclick="addFields()" />
	<input name="" type="button" value="Remove" class="blueBtn" tabindex="36" id="remove-btn" style="display: none" onclick="removeRow()" />
</div>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td width="440px">&nbsp;</td>

		<td width="60px" align="left">CST : </td>
		<td width="100px"><input name="InventoryPurchaseDetail[cst]"
			type="text" class="validate[custom[number]]" id="cst" tabindex="33"
			value="" size="12" />
		</td>

		<td width="170px">Tax : <input name="InventoryPurchaseDetail[tax]"
			type="text" class="validate[custom[number]] " id="tax" tabindex="35"
			value="0" size="12" />%
		</td>

		<td width="100px" align="right">Total Amount :</td>
		<td width="80px" align="right"><?php echo $this->Session->read('Currency.currency_symbol') ; ?><span
			id="total_amount" style="margin-left: 10px;">0</span><input
			name="InventoryPurchaseDetail[total_amount]" id="total_amount_field"
			tabindex="35" value="0" type="hidden" /></td>

	</tr>
</table>
<div class="clr ht5"></div>

<div class="clr ht5"></div>

<div class="clr ht5"></div>
<div class="clr ht5"></div>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td width="600px">&nbsp;</td>
		<td width="160px">&nbsp;</td>
		<td width="160px">&nbsp;</td>

		<td width="65px">Grand Total 	:</td>
		<td width="80px" align="right"><?php echo $this->Session->read('Currency.currency_symbol') ; ?>&nbsp;
		<span id="grand_total">0</span></td>
	</tr>
</table>
<div class="btns">
	<input name="print" type="submit" value="Print" class="blueBtn"
		tabindex="36" /> <input name="submit" type="submit" value="Submit"
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
//setTimeout(function() { $("#party_name").focus(); }, 50);
  function checkIsPartyRemoved(obj){
	if($.trim(obj.value.length)==0){
			$("#party_id").val("");

	}

}
function checkIsItemRemoved(obj){
	var fieldno = $(obj).attr('fieldNo') ;
	if($.trim(obj.value.length)==0){
			$("#item_name"+fieldno).val("");
			$("#item_id"+fieldno).val("");
			$("#item_code"+fieldno).val("");
            $("#manufacturer"+fieldno).val("");
		 	$("#pack_item_name"+fieldno).val("");
			$("#mrp"+fieldno).val("");
			$("#price"+fieldno).val("");
			$("#stockQty"+fieldno).val("");
			$("#batch_number"+fieldno).val("");
			$("#qty"+fieldno).val("");
			$("#tax"+fieldno).val("");
			$("#value"+fieldno).val("");
			$("#free"+fieldno).val("");
			$("#viewDetail"+fieldno).css("visibility","hidden");
	}

}

(function($){
    $.fn.validationEngineLanguage = function(){
    };
    
    $.validationEngineLanguage.newLang();
})(jQuery);

function addFields(){
		   var number_of_field = parseInt($("#no_of_fields").val())+1;
           var field = '';
		   field += '<tr id="row'+number_of_field+'"><td align="center" valign="middle" class="sr_number">'+number_of_field+'</td>';
           field += '<td align="center" valign="middle"><input name="data[PurchaseReceipt]['+number_of_field+'][item_name]" id="item_name'+number_of_field+'" type="text" class="textBoxExpnd validate[required] item_name"  tabindex="6" value="" style="width:70%;" fieldNo="'+number_of_field+'" onkeyup="checkIsItemRemoved(this)"/>';
           field += '<input name="data[PurchaseReceipt]['+number_of_field+'][item_id]" id="item_id'+number_of_field+'" type="hidden"   value=""/> <a href="#" id="viewDetail'+number_of_field+' class="fancy" style="visibility:hidden;"><img title="View Item" alt="View Item" src="/img/icons/view-icon.png"></a></td>';
           field += '<td align="center" valign="middle"><input name="data[PurchaseReceipt]['+number_of_field+'][manufacturer]" id="manufacturer'+number_of_field+'" type="text" class="textBoxExpnd"  tabindex="8" value=""  style="width:80%;" autocomplete="off"/></td>';
		   field += '<td align="center" valign="middle"><input name="data[PurchaseReceipt]['+number_of_field+'][pack]" id="pack_item_name'+number_of_field+'" type="text" class="textBoxExpnd "  tabindex="7" value=""  style="width:80%;" /></td>';
           field += '<td align="center" valign="middle"><input name="data[PurchaseReceipt]['+number_of_field+'][batch_number]" id="batch_number'+number_of_field+'" type="text" class="textBoxExpnd validate[required] batch_number"  tabindex="8" value=""  style="width:80%;" fieldNo="'+number_of_field+'" canadd="1"/></td>';
           field += ' <td valign="middle" style="text-align:center;"><input name="data[PurchaseReceipt]['+number_of_field+'][qty]" id="qty'+number_of_field+'" type="text" class="textBoxExpnd quantity validate[required,custom[number]]"  tabindex="10" value="" style="width:70%;" fieldNo="'+number_of_field+'"/><input type="hidden" value="" id="stock'+number_of_field+'"></td>';
		   field += '<td valign="middle" style="text-align:center;"><input name="data[PurchaseReceipt]['+number_of_field+'][free]" id="free'+number_of_field+'" type="text" class="textBoxExpnd"  tabindex="11" value=""  style="width:80%;"/></td>';
		   field += '<td valign="middle" style="text-align:center;"><input name="data[PurchaseReceipt]['+number_of_field+'][tax]" id="tax'+number_of_field+'"  value="0" type="text" class="textBoxExpnd validate[custom[number]] tax"  tabindex="11" value="" style="width:80%;" fieldNo="'+number_of_field+'" /></td>';
           field += '<td valign="middle" style="text-align:center;"><input name="data[PurchaseReceipt]['+number_of_field+'][mrp]"  id="mrp'+number_of_field+'" type="text" class="textBoxExpnd validate[required]"  tabindex="12" value="" style="width:80%;" /></td>';
           field += '<td valign="middle" style="text-align:center;"><input name="data[PurchaseReceipt]['+number_of_field+'][price]" id="price'+number_of_field+'" type="text" class="textBoxExpnd validate[required,custom[number]] price"  tabindex="13" value="" style="width:80%;"   fieldNo="'+number_of_field+'"/></td>';
           field += ' <td valign="middle" style="text-align:center;"><input name="data[PurchaseReceipt]['+number_of_field+'][value]" id="value'+number_of_field+'" type="text" class="textBoxExpnd validate[required] value"  tabindex="14" value=""  style="width:80%;" style="width:80%; "  /></td>';
		   if(number_of_field>1)
		   field +='<td valign="middle" style="text-align:center;"><a href="#this" id="delete row" onclick="deletRow('+number_of_field+');"><?php echo $this->Html->image('/img/cross.png');?></a></td>';
		  field +='  </tr>    ';
      	$("#no_of_fields").val(number_of_field);
		$("#item-row").append(field);
	
		if (parseInt($("#no_of_fields").val()) == 1){
						$("#remove-btn").css("display","none");
					}else{
		$("#remove-btn").css("display","inline");
		}
}
function removeRow(){
 	var number_of_field = parseInt($("#no_of_fields").val());
	$('.item_name'+number_of_field+"formError").remove();
	$('.batch_number'+number_of_field+"formError").remove();
	$('.qty'+number_of_field+"formError").remove();
	$('.mrp'+number_of_field+"formError").remove();
	$('.price'+number_of_field+"formError").remove();
	$('.value'+number_of_field+"formError").remove();
	$('.tax'+number_of_field+"formError").remove();
	if(number_of_field > 1){
		$("#row"+number_of_field).remove();

		$("#no_of_fields").val(number_of_field-1);
	}
	if (parseInt($("#no_of_fields").val()) == 1){
		$("#remove-btn").css("display","none");
	}
}

/* to show the credit amount field*/
$("#payment_mode").on('change',function(){
	if(this.value == "credit"){
		$(".credit_amount").css('visibility','visible');
		$(".discount_type_label").html('Add in Amount By');
	}else{
		$(".credit_amount").css('visibility','hidden');
		$(".discount_type_label").html('Discount in Amount By');
	}
	 $("#total_amount_field").val("0");
     $("#grand_total").html("0");

});



$("#extra_amount").on('blur',function(){
			    var grandTotal = '';
			 	var currentField = $(this);
				var total_amount = parseFloat($("#total_amount").html());
				var extraAmount = parseFloat($("#extra_amount").val());
				if(parseInt(extraAmount)<0){
					alert("Amount should be positive");
					$("#submitButton").attr('disabled','disabled')
					return false;
				}
			  if($(this).val()!=""){
				if(total_amount<extraAmount){
					alert("Amount should be smaller than Total amount.");
					$("#submitButton").attr('disabled','disabled')
					return false;
				}
				$("#submitButton").removeAttr('disabled');
				if($("#payment_mode").val() == "credit"){
					if($("#discount_type_fix").is(':checked')=== true)
						{
							grandTotal = total_amount+extraAmount;
						}else{
							grandTotal = total_amount+((total_amount*extraAmount)/100);
						}
				}else{
						if($("#discount_type_fix").is(':checked')=== true)
						{
							grandTotal = total_amount-extraAmount;
						}else{
							grandTotal = total_amount-((total_amount*extraAmount)/100);
						}
				}
				if(isNaN(grandTotal)){
					grandTotal = 0;
				}
				 $("#total_amount_field").val(grandTotal.toFixed(2));
				 $("#grand_total").html(grandTotal.toFixed(2));
			 }else{
				 $("#total_amount_field").val(total_amount.toFixed(2));
				 $("#grand_total").html(total_amount.toFixed(2));
			 }
			  });

$(".radio").on('click',function(){
			    var grandTotal = '';
			 	var currentField = $(this);
				var total_amount = parseFloat($("#total_amount").html());
				var extraAmount = parseFloat($("#extra_amount").val());

			  if($(this).val()!=""){
				if(total_amount<extraAmount){
					alert("Amount should be smaller than Total amount.");
					$("#submitButton").attr('disabled','disabled')
					return false;
				}
				$("#submitButton").removeAttr('disabled');
				if($("#payment_mode").val() == "credit"){
					if($("#discount_type_fix").is(':checked')=== true)
						{
							grandTotal = total_amount+extraAmount;
						}else{
							grandTotal = total_amount+((total_amount*extraAmount)/100);
						}
				}else{
						if($("#discount_type_fix").is(':checked')=== true)
						{
							grandTotal = total_amount-extraAmount;
						}else{
							grandTotal = total_amount-((total_amount*extraAmount)/100);
						}
				}
				if(isNaN(grandTotal)){
					grandTotal = total_amount;
				}
				 $("#total_amount_field").val(grandTotal.toFixed(2));
				 $("#grand_total").html(grandTotal.toFixed(2));
			 }else{
				 $("#total_amount_field").val(total_amount.toFixed(2));
				 $("#grand_total").html(total_amount.toFixed(2));
			 }
			  });
$(".quantity").on('blur',function()
			  {
			   $("#cst").val("");
			   $("#tax").val("0");
			   $("#extra_amount").val("");
			   $("#credit_amount").val("");
			  if($(this).val()!=""){
			 	var currentField = $(this);
				var fieldno = currentField.attr('fieldNo') ;
				var qty = currentField.val();
				var stock = parseInt($("#stock"+fieldno).val());
				if(isNaN(qty)||qty.indexOf(".")<0 == false||parseInt(qty)<0){
					alert("Invalid Quantity");
					currentField.val("");
					setTimeout(function() { currentField.focus(); }, 50);
					$("#submitButton").attr('disabled','disabled')
					return false;
				}else{
					qty = parseInt(qty);
					$("#submitButton").removeAttr('disabled');
				}
				var tax = parseFloat($("#tax"+fieldno).val());
				if(isNaN(tax)){
					alert("Enter the Tax");
					setTimeout(function() { $("#tax"+fieldno).focus(); }, 50);
					return false;
				}
				var qty =parseFloat($("#qty"+fieldno).val());
                var price = parseFloat($("#price"+fieldno).val());

               	if(!isNaN(price)){
                    var value = price*qty;
    				var	sub_total = value+((value*tax)/100);
    				$("#value"+fieldno).val((sub_total.toFixed(2)));
    				var $form = $('#PurchaseReceiptForm'),
       				$summands = $form.find('.value');

    					var sum = 0;
    					$summands.each(function ()
    					{
    						var value = Number($(this).val());
    						if (!isNaN(value)) sum += value;
    					});

    				$("#total_amount_field").val(sum.toFixed(2));
    				$("#total_amount").html(sum.toFixed(2));
    				caluculateGrandTotal();
                }
			 }
			  });
$("#tax").on('blur',function()
	  {
            	var total = parseFloat($("#total_amount_field").val());
                var tax = parseFloat($(this).val());
				if(isNaN(tax)){
					alert("Enter the valid Tax amount.");
					setTimeout(function() { $("#tax").focus(); }, 50);
					return false;
				}
                var tax_value = (total*tax)/100;
                total =tax_value+total;
               	$("#total_amount_field").val(total.toFixed(2));
    			$("#total_amount").html(total.toFixed(2));
                caluculateGrandTotal();
    });
$(".price").on('blur',function()
			  {
			   $("#cst").val("");
			   $("#tax").val("0");
			   $("#extra_amount").val("");
			   $("#credit_amount").val("");
			  if($(this).val()!=""){
			 	var currentField = $(this);
				var fieldno = currentField.attr('fieldNo') ;
				var tax = $("#tax"+fieldno).val();
				if(isNaN(tax) && tax != "0"){
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
                var price = parseFloat(currentField.val());
               	if(!isNaN(price)){
    				var value = price*qty;
    				var	sub_total = value+((value*tax)/100);
    				$("#value"+fieldno).val((sub_total.toFixed(2)));
    				var $form = $('#PurchaseReceiptForm'),
       				$summands = $form.find('.value');

    					var sum = 0;
    					$summands.each(function ()
    					{
    						var value = Number($(this).val());
    						if (!isNaN(value)) sum += value;
    					});

    				$("#total_amount_field").val(sum.toFixed(2));
    				$("#total_amount").html(sum.toFixed(2));
    				caluculateGrandTotal();
                }
			 }
			  });


$(".tax").on('blur',function()
			  {
			   $("#cst").val("");
			   $("#tax").val("0");
			   $("#extra_amount").val("");
			   $("#credit_amount").val("");
			  if($(this).val()!=""){
			 	var currentField = $(this);
				var fieldno = currentField.attr('fieldNo') ;
				var tax = currentField.val();
	           var price = parseFloat($("#price"+fieldno).val());
				if(isNaN(tax) && tax != "0"){
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

               	if(!isNaN(price)){
    				var value = price*qty;
    				var	sub_total = value+((value*tax)/100);
    				$("#value"+fieldno).val((sub_total.toFixed(2)));
    				var $form = $('#PurchaseReceiptForm'),
       				$summands = $form.find('.value');

    					var sum = 0;
    					$summands.each(function ()
    					{
    						var value = Number($(this).val());
    						if (!isNaN(value)) sum += value;
    					});

    				$("#total_amount_field").val(sum.toFixed(2));
    				$("#total_amount").html(sum.toFixed(2));
    				caluculateGrandTotal();
                }
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
function deletRow(id){
	 var number_of_field = parseInt($("#no_of_fields").val());
      if(number_of_field==1){
	 	alert("Single row can't delete.");
	 	return false;
		}
	//$("#row"+id).find("input").remove();
	$("#row"+id).remove();


	 $("#no_of_fields").val(number_of_field-1);
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
	$('.qty'+number_of_field+"formError").remove();
	$('.mrp'+number_of_field+"formError").remove();
	$('.price'+number_of_field+"formError").remove();
	$('.value'+number_of_field+"formError").remove();
	$('.tax'+number_of_field+"formError").remove();
	/*field = "<td align='center' colspan='12'> Row deleted</td>";
	$("#row"+id).append(field);
*/
}

	/* for auto populate the data */
function selectItem(li) {
	if( li == null ) return alert("No match!");
		var party_id = li.extra[0];
		$("#party_id").val(party_id);
		loadDataFromRate(party_id);

}
$( ".item_name" ).on( "click", function() {
 
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
					$("#mrp"+fieldno).val(ItemDetail.PharmacyItemRate.mrp);
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
									$("#mrp"+fieldno).val(ItemDetail.PharmacyItemRate.mrp);
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
 
	//

 $( "#party_name" ).autocomplete({
	 		source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","Account","name",'null',"no",'no',"admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
			 $('#debit_account').val(ui.item.id); 
			 
			
		 	 },
		messages: {
	        noResults: '',
	        results: function() {}
	 }
	});
		
/*$(".batch_number").on('focus',function()
			  {
			  var t = $(this);
			  var fieldno = t.attr('fieldNo') ;
			 $(this).autocomplete(
		"<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_batch_number_of_item","inventory" => true,"plugin"=>false)); ?>",
		{
 			selectFirst:false,
			matchSubset:1,
			matchContains:1,
			onItemSelect:function (data1) {
			//$("#expiry_date"+fieldno).datepicker('disable');
			$("#expiry_date"+fieldno).val(data1.extra[0]);
			},
			autoFill:false,
			extraParams: {itemId:$("#item_id"+fieldno).val() },
		}
	);

});*/
function caluculateGrandTotal(){

 				var grandTotal = '';
				var total_amount = parseFloat($("#total_amount_field").val());
				var extraAmount = parseFloat($("#extra_amount").val());
					if(isNaN(extraAmount)){
					extraAmount = 0;
				}
	 			if(extraAmount>0 ){
				if($("#payment_mode").val() == "credit"){
					if($("#discount_type_fix").is(':checked')=== true)
						{
							grandTotal = total_amount+extraAmount;
						}else{
							grandTotal = total_amount+((total_amount*extraAmount)/100);
						}
				}else{
						if($("#discount_type_fix").is(':checked')=== true)
						{
							grandTotal = total_amount-extraAmount;
						}else{
							grandTotal = total_amount-((total_amount*extraAmount)/100);
						}
				}
				if(isNaN(grandTotal)){
					grandTotal = 0;
				}
				 $("#total_amount_field").val(grandTotal.toFixed(2));
				 $("#grand_total").html(grandTotal.toFixed(2));
			 }else{
				 $("#total_amount_field").val(total_amount.toFixed(2));
				 $("#grand_total").html( total_amount.toFixed(2));
			 }


}
</script>
<!--  gulshan  -->
<script>
$("#voucher_date")
.datepicker(
		{
			showOn : "button",
			buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly : true,
			changeMonth : true,
			changeYear : true,
			yearRange: '-100:' + new Date().getFullYear(),
			//maxDate : new Date(),
			dateFormat:'<?php echo $this->General->GeneralDate();?>',
			onSelect : function() {
				$(this).focus();
				//foramtEnddate(); //is not defined hence commented
			}

		});
</script>
