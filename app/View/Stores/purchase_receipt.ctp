
<style>
.formErrorContent {
	width: 43px !important;
}
</style>
<?php
//echo $this->Html->script('jquery.autocomplete_pharmacy');
//echo $this->Html->css('jquery.autocomplete.css');

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
<?php echo $this->Form->create('PurchaseDetail',array('id'=>'PurchaseDetail'));?>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="90" class="tdLabel2">Voucher. No.<font color='red'>*</font>
		</td>
		<td width="120" class="tdLabel2"><input
			name="PurchaseDetail[vr_no]" type="text"
			class="validate[required, custom[mandatory-enter]]" id="vr_no" 
			value="<?php echo $vr_no;?>" readonly="true"
			style="background-color: #808080" /></td>
		<td width="10">&nbsp;</td>
		<td width="90" class="tdLabel2">Voucher. Dt.<font color='red'>*</font>
		</td>
		<!--<td width="160" class="tdLabel2"><table width="100%" cellpadding="0" by amit-->
		<td width="130" class="tdLabel2"><table width="100%" cellpadding="0"
				cellspacing="0" border="0">
				<tr>
					<td width=""><input name="PurchaseDetail[vr_date]"
						type="text" class="textBoxExpnd date validate[required, custom[mandatory-enter]]"
						id="vr_date"  value="" style="width: 71%;" /></td>
				</tr>
			</table>
		</td>
		<td width="2">&nbsp;</td>
		<td width="90" class="tdLabel2">Party Name<font color="red">*</font>
		</td>
		<td width="150" class="tdLabel2"><input
			name="PurchaseDetail[party_name]" type="text"
			class="textBoxExpnd  validate[required, custom[mandatory-enter]]" id="party_name" 
			value="" style="width: 80%" onkeyup="checkIsPartyRemoved(this)" /><input
			type="hidden" name="PurchaseDetail[party_id]" id="party_id">
		</td>
		<td width="20"><!-- <a id="AddpartyList"
			href="<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "inventory_add_supplier","inventory" => true,"plugin"=>false)); ?>">Party</a> -->
		<?php echo $this->Html->link($this->Html->image('icons/plus_6.png',array('title'=>'Add Party','alt'=>'Add Party')), 'javascript:void(0)', array('escape' => false,'style'=>'float:right;','onclick'=>"getAddSupplier()"));?>
		</td>
		<!--<td width="20">  <a id="partyList"
			href="<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_transaction","inventory" => true,"plugin"=>false)); ?>">Party</a>
		</td>//Pooja-->
		<td width="16">&nbsp;</td>
		<td width="70" class="tdLabel2">Party Code</td>
		<td width="50" class="tdLabel2"><input
			name="PurchaseDetail[party_code]" type="text"
			class="" id="party_code"  value=""
			readonly="true" style="background-color: #808080" />
		</td>
		<td width="16">&nbsp;</td>
		<td width="60" class="tdLabel2">Bill No.<font color='red'>*</font>
		</td>
		<td width="60" class="tdLabel2"><input
			name="PurchaseDetail[bill_no]" type="text"
			class="textBoxExpnd validate[required, custom[mandatory-enter]]" id="bill_no" 
			value="" /></td>
		<td>&nbsp;</td>
	</tr>
</table>
<div class="clr ht5"></div>
<table width="100%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm" id="item-row">
	<tr>
		<th width="40" align="center" valign="top" style="text-align: center;">Sr.No.</th>
		<th width="120" align="center" valign="top" style="text-align: center;">Item Name <font color='red'>*</font>
		<?php //echo $this->Html->link($this->Html->image('icons/plus_6.png'),array('controller'=>'pharmacy','action'=>'inventory_add_supplier',"inventory" => true,'admin'=>false),array('escape' => false,'onclick'=>"getAddSupplier()",'title'=>'Add Party'));
		 echo $this->Html->link($this->Html->image('icons/plus_6.png',array('title'=>'Add Item','alt'=>'Add Item')), 'javascript:void(0)', array('escape' => false,'style'=>'float:right;','onclick'=>"getAddItem()"));?>
	</th>
		<th width="80" align="center" valign="top" style="text-align: center;">Manufacturer</th>
		<th width="30" align="center" valign="top" style="text-align: center;">Pack</th>
		<th width="70" valign="top" style="text-align: center;">Batch No.</th>
		<th width="120" align="center" valign="top" style="text-align: center;">Expiry Date</th>
		<th width="30" valign="top" style="text-align: center;">Qty <font color='red'>*</font></th>
		<th width="30" valign="top" style="text-align: center;">Free</th>
		<th width="30" valign="top" style="text-align: center;">Tax (%)<font color='red'>*</font></th>
		<th width="70" valign="top" style="text-align: center;">MRP</th>
		<th width="70" valign="top" style="text-align: center;">Price</th>
		<th width="80" valign="top" style="text-align: center;">Amount</th>
		<th></th>
	</tr>
	<tr id="row1">
		<td align="center" valign="middle" class="sr_number">1</td>
		<td align="center" valign="middle" width="160"><input name="item_name[]" id="item_name1" type="text"
			class="textBoxExpnd validate[required, custom[mandatory-enter]] item_name"  value="" style="width: 71%;" fieldNo='1' onkeyup="checkIsItemRemoved(this)" /> <input name="item_id[]"
			id="item_id1" type="hidden" value="" /> <a href="#" id="viewDetail1" class='fancy' style="visibility: hidden"><img title="View Item" alt="View Item" src="/getnabh/img/icons/view-icon.png"> </a></td>
		<td align="center" valign="middle"><input name="manufacturer[]" type="text" class="textBoxExpnd " id="manufacturer1"  value="" style="width: 80%;" readonly="true" /></td>
		<td align="center" valign="middle"><input name="pack[]" id="pack_item_name1" type="text" class="textBoxExpnd"  value="" style="width: 50%;" readonly="true" /></td>
		<td align="center" valign="middle"><input name="batch_number[]" id="batch_number1" type="text"
			class="textBoxExpnd validate[required, custom[mandatory-enter]] batch_number"  value="" style="width: 65%;" fieldNo="1" canadd="1" /></td>
		<td valign="middle" style="text-align: center;" width="200">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<td width="135"><input name="expiry_date[]" type="text"
					id="expiry_date1"
					class="textBoxExpnd date validate[required, custom[mandatory-enter]]"
					 value="" style="width: 70%;" />
				</td>
			</tr>
			</table>
		</td>
		<td valign="middle" style="text-align: center;"><input name="qty[]"
			type="text"
			class="textBoxExpnd  quantity validate[required, custom[mandatory-enter]]"
			 value="" id="qty1" style="width: 40%;" fieldNo="1" /><input
			type="hidden" value="" id="stock1"></td>
		<td valign="middle" style="text-align: center;"><input name="free[]"
			type="text" class="textBoxExpnd"  value="" id="free1"
			style="width: 40%;" /></td>
		<td valign="middle" style="text-align: center;"><input name="tax[]"
			value="" type="text"
			class="textBoxExpnd tax  tax" 
			value="" id="tax1" style="width: 40%;" fieldNo="1" /></td>
		<td valign="middle" style="text-align: center;"><input name="mrp[]"
			type="text" class="textBoxExpnd validate[required, custom[mandatory-enter]]"
			 value="" id="mrp1" style="width: 70%;" /></td>
		<td valign="middle" style="text-align: center;"><input name="price[]"
			type="text"
			class="textBoxExpnd validate[required, custom[mandatory-enter]] price"
			 value="" id="price1" style="width: 70%;" fieldNo="1" />
		</td>
		<td valign="middle" style="text-align: center;"><input name="value[]"
			type="text" class="textBoxExpnd value" id="value1" 
			value="" style="width: 80%;" readonly="true" /></td>
			<td valign="middle" style="text-align: center;">
			 <?php
   echo $this->Html->image('icons/cross.png', array('alt' => __('Remove Item', true),'title' => __('Remove Item', true)));
   ?>
			</td>
		<!--<td valign="middle" style="text-align: center;"><a href="#this"
			id="delete row" alt="Remove Item" onclick="deletRow('1');">
			<?php //echo $this->Html->image('icons/cross.png');?></a></td>  by amit jain-->
	</tr>
</table>
<div class="clr ht5"></div>

<div align="right">

	<input name="" type="button" value="Add More" class="blueBtn"
		 onclick="addFields()" />
		<input name="" type="button"

		value="Remove" class="blueBtn"  id="remove-btn"
		style="display: none" onclick="removeRow()" /> 
</div>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td width="440px">&nbsp;</td>
		<td width="60px" align="left">CST : </td>
		<td width="100px"><input name="PurchaseDetail[cst]"
			type="text" class="validate[required, custom[mandatory-enter]]" id="cst" 
			value="" size="12" />
		</td>

		<!-- <td width="170px">Tax : <input name="InventoryPurchaseDetail[tax]"
			type="text" class="validate[required,custom['manadatory-enter']] " id="tax" tabindex="35"
			value="0" size="12" />%
		</td> -->

		<td width="100px" align="right">Total Amount :</td>
		<td width="80px" align="right"><?php echo $this->Session->read('Currency.currency_symbol') ; ?><span
			id="total_amount" style="margin-left: 10px;">0</span><input
			name="PurchaseDetail[total_amount]" id="total_amount_field"
			 value="0" type="hidden" />
		</td>
	</tr>
</table>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
<td width="520px">&nbsp;</td>
		<td width="140px" class="tdLabel2">Payment Mode : <select
			name="PurchaseDetail[payment_mode]" id="payment_mode"><option
					value="cash" selected="selected">Cash</option>
				<option value="credit">Credit</option>
		</select>
		</td>

		<td width="120px"><span class="discount_type_label">Discount in Amount
				By : </span></td>
		<td width="200px"><input type="radio" id="discount_type_fix"
			name="PurchaseDetail[extra_amount_type]" checked="checked"
			value="0" class="radio"> Amount &nbsp; Or <input type="radio"
			id="discount_type_percentage"
			name="InventoryPurchaseDetail[extra_amount_type]" value="1"
			class="radio">&nbsp;Percentage</td>

		<td width="160px" align="right" class="credit_amount"
			style="visibility: hidden">Credit Amount : <input
			name="PurchaseDetail[credit_amount]" type="text"
			class="textBoxExpnd validate[optional, custom[mandatory-enter]]" id="credit_amount"
			value="" style="width: 21%" />
		</td>
	</tr>
</table>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td width="168px" align="right">Enter value : </td>
		<td width="100px"> <input
			name="PurchaseDetail[extra_amount]" type="text"
			class="" id="extra_amount" 
			value="" />
		</td>
	</tr>
</table>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td width="600px">&nbsp;</td>
		<td width="160px">&nbsp;</td>
		<td width="160px">&nbsp;</td>
		<td width="65px">Grand Total 	:</td>
		<td width="80px" align="right"><?php echo $this->Session->read('Currency.currency_symbol') ; ?>&nbsp;<span
			id="grand_total">0</span></td>
	</tr>
</table>
<div class="btns">
	<input name="print" type="submit" value="Print" class="blueBtn"
		 /> <input name="submit" type="submit" value="Submit" id='submit',
		class="blueBtn"  id="submitButton" />
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
			$("#party_code").val("");
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
			$("#expiry_date"+fieldno).val("");
			$("#qty"+fieldno).val("");
			$("#tax"+fieldno).val("");
			$("#value"+fieldno).val("");
			$("#free"+fieldno).val("");
			$("#viewDetail"+fieldno).css("visibility","hidden");
	}

}
	$("#partyList").fancybox({
				'width'				: '75%',
				'height'			: '75%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
	
	function getAddSupplier(){
		$.fancybox({
			'width' : '80%',
			'height' : '80%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'href' : "<?php echo $this->Html->url(array("controller"=>"pharmacy", "action" => "inventory_add_supplier","inventory" => true,'admin'=>false,'?'=>array('flag'=>1))); ?>"

		});
	}
	function getAddItem(){
		$.fancybox({
			'width' : '80%',
			'height' : '80%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'href' : "<?php echo $this->Html->url(array("controller"=>"pharmacy", "action" => "inventory_add_item","inventory" => true,'admin'=>false,'?'=>array('flag'=>1))); ?>"

		});
	}
$( ".date" ).datepicker({
			showOn: "button",
			buttonImage: "/getnabh/img/js_calendar/calendar.gif",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,
			yearRange: '1950',
			dateFormat:'<?php echo $this->General->GeneralDate();?>',

		});



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
           field += '<td align="center" valign="middle"><input name="item_name[]" id="item_name'+number_of_field+'" type="text" class="textBoxExpnd validate[required, custom[mandatory-enter]] item_name"   value="" style="width:70%;" fieldNo="'+number_of_field+'" onkeyup="checkIsItemRemoved(this)"/><input name="item_id[]" id="item_id'+number_of_field+'" type="hidden"   value=""/> <a href="#" id="viewDetail'+number_of_field+'"'+number_of_field+'" class="fancy" style="visibility:hidden;"><img title="View Item" alt="View Item" src="/getnabh/img/icons/view-icon.png"></a></td>';
           field += '<td align="center" valign="middle"><input name="manufacturer[]" readonly="true" id="manufacturer'+number_of_field+'" type="text" class="textBoxExpnd"  value=""  style="width:80%;" autocomplete="off"/></td>';
		   field += '<td align="center" valign="middle"><input name="pack[]" id="pack_item_name'+number_of_field+'" type="text" class="textBoxExpnd "   value=""  style="width:50%;" readonly="true"/></td>';

           field += '<td align="center" valign="middle"><input name="batch_number[]" id="batch_number'+number_of_field+'" type="text" class="textBoxExpnd validate[required, custom[mandatory-enter]] batch_number"   value=""  style="width:65%;" fieldNo="'+number_of_field+'" canadd="1"/></td>';
           field += '<td valign="middle" style="text-align:center;"><table width="100%" cellpadding="0" cellspacing="0" border="0"><td width="135"><input name="expiry_date[]" type="text" id="expiry_date'+number_of_field+'" class="textBoxExpnd date validate[required, custom[mandatory-enter]]"  value="" style="width:70%;" /></td></tr> </table></td>';

           field += ' <td valign="middle" style="text-align:center;"><input name="qty[]" type="text" class="textBoxExpnd quantity validate[required, custom[mandatory-enter]]"   value="" id="qty'+number_of_field+'" style="width:40%;" fieldNo="'+number_of_field+'"/><input type="hidden" value="" id="stock'+number_of_field+'"></td>';

		  field += '<td valign="middle" style="text-align:center;"><input name="free[]" type="text" class="textBoxExpnd"  value="" id="free'+number_of_field+'"  style="width:40%;"/></td>';

		  	  field += '<td valign="middle" style="text-align:center;"><input name="tax[]" value="0" type="text" class="textBoxExpnd validate[required, custom[mandatory-enter]] tax"   value="" id="tax'+number_of_field+'"  style="width:40%;" fieldNo="'+number_of_field+'" /></td>';

           field += '<td valign="middle" style="text-align:center;"><input name="mrp[]" type="text" class="textBoxExpnd validate[required, custom[mandatory-enter]]"  value="" id="mrp'+number_of_field+'" style="width:70%;" /></td>';

           field += '<td valign="middle" style="text-align:center;"><input name="price[]" type="text" class="textBoxExpnd validate[required, custom[mandatory-enter]] price"   value="" id="price'+number_of_field+'" style="width:70%;"   fieldNo="'+number_of_field+'"/></td>';

           field += ' <td valign="middle" style="text-align:center;"><input name="value[]" type="text" class="textBoxExpnd validate[required, custom[mandatory-enter]] value" id="value'+number_of_field+'"   value=""  style="width:80%;" style="width:80%; "  /></td>';

		   if(number_of_field>1)
		     field +='<td valign="middle" style="text-align:center;"> <a href="#this" id="delete row" onclick="deletRow('+number_of_field+');"><?php
  		   echo $this->Html->image('icons/cross.png', array('alt' => __('Remove Item', true),'title' => __('Remove Item', true)));
		   ?></a></td>';
		     
		  field +='  </tr>    ';
      	$("#no_of_fields").val(number_of_field);
		$("#item-row").append(field);
		$("#expiry_date"+number_of_field).datepicker({
			showOn: "button",
			buttonImage: "/getnabh/img/js_calendar/calendar.gif",
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
	$('.item_name'+number_of_field+"formError").remove();
	$('.batch_number'+number_of_field+"formError").remove();
	$('.expiry_date'+number_of_field+"formError").remove();
	$('.qty'+number_of_field+"formError").remove();
	$('.mrp'+number_of_field+"formError").remove();
	$('.price'+number_of_field+"formError").remove();
	$('.value'+number_of_field+"formError").remove();
	$('.tax'+number_of_field+"formError").remove();
	if(number_of_field > 1){
		$("#row"+number_of_field).remove();

		// $("#no_of_fields").val(number_of_field-1); //updated by swapnil
		 
		$("#no_of_fields").val(number_of_field);	
	}
	if (parseInt($("#no_of_fields").val()) == 1){
		$("#remove-btn").css("display","none");
	}
}

/* to show the credit amount field*/
$("#payment_mode").change(function(){
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



$("#extra_amount").blur(function(){
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

$(".radio").click(function(){
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
$(document).on('blur','.quantity',function()
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
    				var $form = $('#PurchaseDetail'),
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
$("#tax").blur(function()
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
$(".price").blur(function()
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
    				var $form = $('#PurchaseDetail'),
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


$(".tax").blur(function()
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
    				var $form = $('#PurchaseDetail'),
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


	// $("#no_of_fields").val(number_of_field-1); updated by swapnil
	
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

 

function selectItemDetail(){

}
$("#submit").click(function(){
	// binds form submission and fields to the validation engine
	var valid=jQuery("#PurchaseDetail").validationEngine('validate');
	if(valid){
		return true;
	}else{
		return false;
	}
	});
	
$(document).ready(function(){
	$('#party_name').autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","InventorySupplier","name",'null',"no",'no',"admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
			 $('#party_id').val(ui.item.id); 
		 },
		 messages: {
		        noResults: '',
		        results: function() {}
		 }
	});

}); 
 /*$('#party_name').focus(function()  {
	$(this).autocomplete(
			"<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","InventorySupplier","name", "admin" => false,"plugin"=>false)); ?>",
			{
				selectFirst: false,
				matchSubset:1,
				matchContains:1,
				onItemSelect:selectItem,
				autoFill:false
			}
		);

	}
		);*/
/*$(".batch_number").live('focus',function()
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




$(document).ready(function(){
	$(document).on("focus",".item_name",(function()
	  {
	  if($("#party_id").val()==""){
	  	alert("Please select Supplier.");
		setTimeout(function() { $("#party_name").focus(); }, 10);
		return false;
	  }
	  	  var t = $(this);
	  	 
	    $(this).autocomplete({
			source:"<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","Product","name", "admin" => false,"plugin"=>false)); ?>",
			extraParams: {supplierID:$("#party_id").val() },
			select: function( event, ui ) {
				selectedId = t.attr('id');
			    var itemID = ui.item.id;
				var fieldno = $("#"+selectedId).attr('fieldNo') ;
				$("#item_id"+fieldno).val(itemID);
				$("#viewDetail"+fieldno).attr('href','view_item/'+itemID+'?popup=true');
				$("#viewDetail"+fieldno).css("visibility","visible");
			 	var currentField = $(this);
				$.ajax({
				  type: "POST",
				  url: "<?php echo $this->Html->url(array("controller" => "Store", "action" => "fetch_rate_for_item","plugin"=>false)); ?>",
				  data: "item_id="+itemID,
				}).done(function( msg ) {
					var ItemDetail = jQuery.parseJSON(msg);
					$("#pack_item_name"+fieldno).val(ItemDetail.Product.pack);
               $("#manufacturer"+fieldno).val(ItemDetail.Product.manufacturer);
               $("#stock"+fieldno).val(ItemDetail.Product.stock);
               $("#batch_number"+fieldno).val(ItemDetail.Product.batch_number);
               
               /* field added by atul */
               $("#tax"+fieldno).val(ItemDetail.Product.tax);
               $("#expiry_date"+fieldno).val(ItemDetail.Product.expiry_date);
					$("#mrp"+fieldno).val(ItemDetail.Product.mrp);
					$("#price"+fieldno).val(ItemDetail.Product.sale_price);
						if(ItemDetail.Product.id==null || ItemDetail.Product.purchase_price=="0" || ItemDetail.Product.purchase_price==""){
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
								  url: "<?php echo $this->Html->url(array("controller" => "Store", "action" => "fetch_rate_for_item","inventory" => true,"plugin"=>false)); ?>",
								  data: "item_id="+itemID,
								}).done(function( msg ) {
									var ItemDetail = jQuery.parseJSON(msg);

									//$("#mrp"+fieldno).val(ItemDetail.PharmacyItemRate.mrp);
									$("#stock"+fieldno).val(ItemDetail.Product.stock);
									$("#batch_number"+fieldno).val(ItemDetail.Product.batch_number);
									$("#expiry_date"+fieldno).val(ItemDetail.Product.expiry_date);
									$("#mrp"+fieldno).val(ItemDetail.Product.mrp);
									$("#price"+fieldno).val(ItemDetail.Product.sale_price);
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
						  url: "<?php echo $this->Html->url(array("controller" => "Store", "action" => "fetch_rate_for_item",'item_id','true',"inventory" => true,"plugin"=>false)); ?>",
						  data: "item_id="+itemID,
						}).done(function( msg ) {
						 	var item = jQuery.parseJSON(msg);
							$("#item_name"+fieldno).val(item.Product.name);
							$("#item_id"+fieldno).val(item.Product.id);
							$("#item_code"+fieldno).val(item.Product.item_code);
				            $("#manufacturer"+fieldno).val(item.Product.manufacturer);
						 	$("#pack"+fieldno).val(item.Product.pack);
							$("#batch_number"+fieldno).val(item.Product.batch_number);
							$("#stockQty"+fieldno).val(item.Product.stock);
							$("#mrp"+fieldno).val(item.Product.mrp);
							$("#rate"+fieldno).val(item.Product.cost_price);


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
			}
	    }); 
	}));
});


</script>
