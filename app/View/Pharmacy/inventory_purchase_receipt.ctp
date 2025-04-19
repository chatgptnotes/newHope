<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#InventoryPurchaseDetailInventoryPurchaseReceiptForm").validationEngine();
	});

</script>
<style>
.formErrorContent {
	width: 43px !important;
}
.amt_table td{ font-size:13px !important;}
.credit_amount {
     float: left;
    margin-top: 20px;
    width: 41%;
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
	<h3>Purchase Receipt</h3>
	<span><?php
	echo $this->Html->link(__('Back'), array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
	?> </span>
</div>
<div class="clr ht5"></div>
<input type="hidden" value="1"
	id="no_of_fields" />
<?php echo $this->Form->create('InventoryPurchaseDetail');?>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="100" class="tdLabel2">Voucher. No.<font color='red'>*</font>
		</td>
		<td width="150" class="tdLabel2"><input
			name="InventoryPurchaseDetail[vr_no]" type="text"
			class="textBoxExpnd validate[required]" id="vr_no" tabindex="1"
			value="<?php echo $vr_no;?>" readonly="true"
			style="background-color: #808080" /></td>
		<td width="10">&nbsp;</td>
		<td width="100" class="tdLabel2">Voucher. Dt. <font color='red'>*</font>
		</td>
		<td width="160" class="tdLabel2"><table width="100%" cellpadding="0"
				cellspacing="0" border="0">
				<tr>
					<td width=""><input name="InventoryPurchaseDetail[vr_date]"
						type="text" class="textBoxExpnd date validate[required]"
						id="vr_date" tabindex="2" value="" style="width: 71%;" /></td>

				</tr>
			</table>
		</td>
		<td width="2">&nbsp;</td>
		<td width="100" class="tdLabel2">Party Name<font color="red">*</font>
		</td>
		<td width="150" class="tdLabel2"><input
			name="InventoryPurchaseDetail[party_name]" type="text"
			class="textBoxExpnd  validate[required]" id="party_name" tabindex="4"
			value="" style="width: 80%" onkeyup="checkIsPartyRemoved(this)" />
			<input type="hidden" name="InventoryPurchaseDetail[party_id]" id="party_id">
		</td>
		
		<!-- added by mrunal -->
		<td width="20"><!-- <a id="AddpartyList"
			href="<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "inventory_add_supplier","inventory" => true,"plugin"=>false)); ?>">Party</a> -->
		<?php echo $this->Html->link($this->Html->image('icons/plus_6.png',array('title'=>'Add Party','alt'=>'Add Party')), 'javascript:void(0)', array('escape' => false,'style'=>'float:right;','onclick'=>"getAddSupplier()"));?>
		</td>
		
		<td width="2">&nbsp;</td>
		<td width="20"><a id="partyList"
			href="<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_transaction","inventory" => true,"plugin"=>false)); ?>">Party</a>
		</td>
		<td width="16">&nbsp;</td>	
	
		<td width="80" class="tdLabel2">Party Code</td>
		<td width="100" class="tdLabel2"><input name="InventoryPurchaseDetail[party_code]" type="text"
			class="textBoxExpnd" id="party_code" tabindex="3" value=""
			readonly="true" style="background-color: #808080" /></td>
		
		<td width="2">&nbsp;</td>
		<td width="60" class="tdLabel2">Bill No.<font color='red'>*</font>
		</td>
		<td width="150" class="tdLabel2"><input
			name="InventoryPurchaseDetail[bill_no]" type="text"
			class="textBoxExpnd validate[required]" id="bill_no" tabindex="5"
			value="<?php echo $bill_no?>" /></td>
		<td>&nbsp;</td>
		
		
	</tr>
</table>
<div class="clr ht5"></div>
<table width="100%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm" id="item-row">
	<tr>
		<th width="40" align="center" valign="top" style="text-align: center;">Sr.
			No.</th>
		<th  align="center" valign="top"
			style="text-align:center;" width="100">Item Name <font color='red'>*</font>
			<?php 
		 		echo $this->Html->link($this->Html->image('icons/plus_6.png',
				array('title'=>'Add Item','alt'=>'Add Item')), 'javascript:void(0)', array('escape' => false,'style'=>'float:right;','onclick'=>"getAddItem()"));
			?>
		</th>
		<th width="50" align="center" valign="top" style="text-align: center;">Manufacturer</th>
		<th width="50" align="center" valign="top" style="text-align: center;">Pack</th>
		<th width="50" valign="top" style="text-align: center;">Batch No.</th>
		<th width="70" align="center" valign="top"
			style="text-align: center;">Expiry Date</th>
		<th width="40" valign="top" style="text-align: center;">Qty</th>
		<th width="40" valign="top" style="text-align: center;">Free</th>
		<th width="40" valign="top" style="text-align: center;">Tax (%)</th>
		<th width="60" valign="top" style="text-align: center;">MRP</th>
		<th width="60" valign="top" style="text-align: center;">Price</th>
		<th width="80" valign="top" style="text-align: center;">Amount</th>
		<th width="20" valign="top" style="text-align: center;">Action</th>
	</tr>
	<tr id="row1">
		<td align="center" valign="middle" class="sr_number">1</td>
		<td align="center" valign="middle" width="112">
			<input name="item_name[]" id="item_name1" type="text"
				class="textBoxExpnd validate[required] item_name" tabindex="6"
				value="" style="width: 80%;text-align: " fieldNo='1'
				onkeyup="checkIsItemRemoved(this)" /> 
				
			<input name="item_id[]"
				id="item_id1" type="hidden" value="" /> 
				<a href="#" id="viewDetail1" class='fancy' style="visibility: hidden">
				<img title="View Item" alt="View Item" src="/drmHope/img/icons/view-icon.png"> </a>
		</td>
		<td align="center" valign="middle" width="60"><input name="manufacturer[]"
			type="text" class="textBoxExpnd " id="manufacturer1" tabindex="3"
			value="" style="width: 90%;" readonly="true" />
		</td>
		
		<td align="center" valign="middle"><input name="pack[]"
			id="pack_item_name1" type="text" class="textBoxExpnd" tabindex="7"
			value="" style="width: 90%;" readonly="true" />
		</td>
			
		<td align="center" valign="middle">
			<input name="batch_number[]" id="batch_number1" type="text"
			class="textBoxExpnd validate[required] batch_number" tabindex="8"
			value="" style="width: 90%;" fieldNo="1" canadd="1" />
		</td>
		
		<td valign="middle" align="center" width="150">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td width="135"><input name="expiry_date[]" type="text"
					id="expiry_date1"
					class="textBoxExpnd date validate[funcCall[checkExpiryDate],required]"
					tabindex="9" value="" style="width: 70%;" />
				</td>
			</tr>
			</table>
		</td>
			
		<td valign="middle" style="text-align: center;"><input name="qty[]"
			type="text"
			class="textBoxExpnd  quantity validate[required,custom[number]]"
			tabindex="10" value="" id="qty1" style="width: 90%;" fieldNo="1" />
			<input type="hidden" value="" id="stock1">
		</td>
		
		<td valign="middle" style="text-align: center;"><input name="free[]"
			type="text" class="textBoxExpnd" tabindex="11" value="" id="free1"
			style="width: 90%;" />
		</td>
		
		<td valign="middle" style="text-align: center;">
			<input name="tax[]"  type="text"
			class="textBoxExpnd validate[custom[number]] tax" tabindex="11"
			value="" id="tax1" style="width: 90%;" fieldNo="1" />
		</td>
		<td valign="middle" style="text-align: center;"><input name="mrp[]"
			type="text" class="textBoxExpnd validate[required,custom[number]]"
			tabindex="12" value="" id="mrp1" style="width: 80%;" />
		</td>
		
		<td valign="middle" style="text-align: center;"><input name="price[]"
			type="text"
			class="textBoxExpnd validate[required,custom[number]] price"
			tabindex="13" value="" id="price1" style="width: 80%;" fieldNo="1" />
		</td>
		<td valign="middle" style="text-align: center;"><input name="value[]"
			type="text" class="textBoxExpnd value" id="value1" tabindex="14"
			value="" style="width: 80%;" readonly="true" /></td>
		<td valign="middle" style="text-align: center;"><a href="#this"
			id="delete row" onclick="deletRow('1');"><img title="delete row"
				alt="Remove " src="/drmHope/img/icons/cross.png"> </a></td>
	</tr>
</table>
<div class="clr ht5"></div>

<div align="right">
	<input name="" type="button" value="Add More" class="blueBtn"
		tabindex="36" onclick="addFields()" /><input name="" type="button"
		value="Remove" class="blueBtn" tabindex="36" id="remove-btn"
		style="display: none" onclick="removeRow()" />
</div>
<div class="clr ht5"></div>
<table cellpadding="0" cellspacing="0" border="0" width="100%" class="amt_table">
	<tr>
		

<!-- 		<td width="4%" align="left">CST : </td> -->
<!-- 		<td width="5%"><input name="InventoryPurchaseDetail[cst]" -->
<!-- 			type="text" class="validate[custom[number]]" id="cst" tabindex="33" -->
<!-- 			value="" size="12" /> -->
<!-- 		</td> -->

	
		

	</tr>
</table>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
<table cellpadding="0" cellspacing="0" border="0" width="60%" class="amt_table" align="center" style="border:1px solid #ccc;padding:10px;">
	<tr>

		<td width="16%" class="tdLabel2">Payment Mode : 
		<select
			name="InventoryPurchaseDetail[payment_mode]" id="payment_mode">
				<option value="cash" selected="selected">Cash</option>
				<option value="credit">Credit</option>
				<option value="creditCard">Credit Card</option>
				<option value="cheque">Cheque</option>
				<option value="neft">NEFT</option>
		</select>
		</td>
		<td width="40%" align="right">Total Amount :</td>
		<td width="6%" align="left" colspan="2"><?php echo $this->Session->read('Currency.currency_symbol') ; ?>&nbsp;<span
			id="total_amount" style="margin-left:3px; float:left;margin-right: 9px;">0</span>&nbsp;&nbsp;&nbsp;<input
			name="InventoryPurchaseDetail[total_amount]" id="total_amount_field"
			tabindex="35" value="0" type="hidden" /></td>
    </tr>
    <tr>
<!--       <td width="13%" align="left" class=""
			style="visibility: hidden">Credit Per :  -->
<!-- 			<input name="InventoryPurchaseDetail[credit_amount]" type="text" -->
<!-- 			class="textBoxExpnd validate[custom[number]]" id="" 
			tabindex="35" value="" style="width:48%; float:right;" />-->
<!-- 		</td> -->
    
    <tr id="creditDaysInfo" class="creditDaysInfo" style="visibility: hidden">
	  	<td height="35" class="tdLabel2" width="5%"> 
	  		Credit Period :<br /> (in days)
	  		 <span><?php echo $this->Form->input('InventoryPurchaseDetail.credit_period',array('type'=>'text','legend'=>false,'id' => 'credit_period','label'=>false,'id' => 'credit_period'));?></span>
	  	</td>
	  			   
	  	<td> 
             <lable> 
             	<span> 
              		<?php  echo __('Guarantor :'); ?> 
             	</span> 
		            <?php 
 		            	echo $this->Form->input('InventoryPurchaseDetail.guarantor_id',array('empty'=>'Please select','id'=>'guarantor_id','options'=>$userName, 'label'=> false,'style'=> 'width:200px'));
 		            ?>
 		     </lable> 
		
 	  	</td> 

   </tr> 
    </tr>
    <tr id="paymentInfoCreditCard" class="paymentInfoCreditCard" style=" display: none;">
	  	 <td colspan="2" class="tdLabel2"> 
		  	<table width="100%" > 
			    <tr>
				    <td width="25%">Bank Name</td>
				    <td><?php echo $this->Form->input('InventoryPurchaseDetail.bank_name',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'BN_paymentInfoCreditCard'));?></td>
				</tr>
				    <tr>
				    <td>Account No.</td>
				    <td><?php echo $this->Form->input('InventoryPurchaseDetail.account_number',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'AN_paymentInfoCreditCard'));?></td>
				</tr>
				    <tr>
				    <td>Cheque/Credit Card No.</td>
				    <td><?php echo $this->Form->input('InventoryPurchaseDetail.credit_card_no',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'card_check_number'));?></td>
			    </tr>
			</table>
	    </td>
   </tr>
   <tr id="neft-area" class="neft-area" style="visibility: hidden">
	  	<td  colspan="2" class="tdLabel2"> 
		  	<table width="100%"> 
			    <tr>
				    <td width="15%">Bank Name</td>
				    <td><?php echo $this->Form->input('InventoryPurchaseDetail.bank_name',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'BN_neftArea'));?></td>
				</tr>
				    <tr>
				    <td>Account No.</td>
				    <td><?php echo $this->Form->input('InventoryPurchaseDetail.account_number',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'AN_neftArea'));?></td>
				</tr> 
			    <tr>
				    <td>NEFT No.</td>
				    <td><?php echo $this->Form->input('InventoryPurchaseDetail.neft_number',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'neft_number'));?></td>
				</tr>
				    <tr>
				    <td>NEFT Date</td>
				    <td><?php echo $this->Form->input('InventoryPurchaseDetail.neft_date',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'neft_date','style'=>'width:150px;'));?></td>
				</tr>
		    </table>
	    </td>
  </tr> 
  	<tr>
		<td width="88%"><span class="discount_type_label">Discount in Amount By : </span>
		<input type="radio" id="discount_type_fix"
			name="InventoryPurchaseDetail[extra_amount_type]" checked="checked"
			value="0" class="radio"> Amount &nbsp; Or <input type="radio"
			id="discount_type_percentage"
			name="InventoryPurchaseDetail[extra_amount_type]" value="1"
			class="radio">&nbsp;Percentage
		</td>

		<td width="14%" > Enter value : &nbsp;</td>
		
		<td width="100px"> <input
			name="InventoryPurchaseDetail[extra_amount]" type="text"
			class="validate[custom[number]]" id="extra_amount" tabindex="35"
			value="" />
		</td>
	</tr>
	<tr>
		<td width="14%" style="padding-top:10px;">Tax : <input name="InventoryPurchaseDetail[tax]"
			type="text" class="validate[custom[number]] " id="tax" tabindex="35"
			value="0" size="12" />%
		</td>
		
		<td width="31%" align="left" colspan="2" style="padding-top:10px;">Grand Total 	:
		<span id="grand_total" style="">0</span>
		&nbsp;<?php echo $this->Session->read('Currency.currency_symbol') ; ?>
		</td>
		
	</tr>
	
	<tr>
		
	</tr>
</table>
<div class="clr ht5"></div>

<div class="btns">

  <input name="submit" type="submit" value="Submit"
		class="blueBtn" tabindex="37" id="submitButton" />
</div>
</table>




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
			showOn: "both",
			buttonImage: "/drmHope/img/js_calendar/calendar.gif",
			buttonImageOnly: true,
			buttonText: "Calendar",
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,
			yearRange: '1950',
			dateFormat:'<?php echo $this->General->GeneralDate();?>',
			onSelect : function() {
				$(".date").validationEngine("hide");   
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
				"expirydate":{
				 	"alertText": "Date should be future date."
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
var number_of_field = 1;
function addFields(){
	number_of_field = number_of_field+1; 
           var field = '';
		   field += '<tr id="row'+number_of_field+'"><td align="center" valign="middle" class="sr_number">'+number_of_field+'</td>';
           field += '<td align="center" valign="middle"><input name="item_name[]" id="item_name'+number_of_field+'" type="text" class="textBoxExpnd validate[required] item_name"  tabindex="6" value="" style="width:80%;" fieldNo="'+number_of_field+'" onkeyup="checkIsItemRemoved(this)"/><input name="item_id[]" id="item_id'+number_of_field+'" type="hidden"   value=""/> <a href="#" id="viewDetail'+number_of_field+'"'+number_of_field+'" class="fancy" style="visibility:hidden;"><img title="View Item" alt="View Item" src="/drmHope/img/icons/view-icon.png"></a></td>';
           field += '<td align="center" valign="middle"><input name="manufacturer[]" readonly="true" id="manufacturer'+number_of_field+'" type="text" class="textBoxExpnd"  tabindex="8" value=""  style="width:90%;" autocomplete="off"/></td>';
		   field += '<td align="center" valign="middle"><input name="pack[]" id="pack_item_name'+number_of_field+'" type="text" class="textBoxExpnd "  tabindex="7" value=""  style="width:90%;" readonly="true"/></td>';

           field += '<td align="center" valign="middle"><input name="batch_number[]" id="batch_number'+number_of_field+'" type="text" class="textBoxExpnd validate[required] batch_number"  tabindex="8" value=""  style="width:90%;" fieldNo="'+number_of_field+'" canadd="1"/></td>';
           field += '<td valign="middle" style="text-align:center;"><table width="100%" cellpadding="0" cellspacing="0" border="0"><td width="135"><input name="expiry_date[]" type="text" id="expiry_date'+number_of_field+'" class="textBoxExpnd date validate[required,funcCall[checkExpiryDate]]" tabindex="9" value="" style="width:70%;" /></td></tr> </table></td>';

           field += ' <td valign="middle" style="text-align:center;"><input name="qty[]" type="text" class="textBoxExpnd quantity validate[required,custom[number]]"  tabindex="10" value="" id="qty'+number_of_field+'" style="width:90%;" fieldNo="'+number_of_field+'"/><input type="hidden" value="" id="stock'+number_of_field+'"></td>';

		  field += '<td valign="middle" style="text-align:center;"><input name="free[]" type="text" class="textBoxExpnd"  tabindex="11" value="" id="free'+number_of_field+'"  style="width:90%;"/></td>';

		  	  field += '<td valign="middle" style="text-align:center;"><input name="tax[]" value="0" type="text" class="textBoxExpnd validate[custom[number]] tax"  tabindex="11" value="" id="tax'+number_of_field+'"  style="width:90%;" fieldNo="'+number_of_field+'" /></td>';

           field += '<td valign="middle" style="text-align:center;"><input name="mrp[]" type="text" class="textBoxExpnd validate[required]"  tabindex="12" value="" id="mrp'+number_of_field+'" style="width:80%;" /></td>';

           field += '<td valign="middle" style="text-align:center;"><input name="price[]" type="text" class="textBoxExpnd validate[required,custom[number]] price"  tabindex="13" value="" id="price'+number_of_field+'" style="width:80%;"   fieldNo="'+number_of_field+'"/></td>';

           field += ' <td valign="middle" style="text-align:center;"><input name="value[]" type="text" class="textBoxExpnd validate[required] value" id="value'+number_of_field+'"  tabindex="14" value=""  style="width:80%;" style="width:80%; "  /></td>';
			
		   if(number_of_field>=1)
		     field +='<td valign="middle" style="text-align:center;"> <a href="#this" id="delete row" onclick="deletRow('+number_of_field+');"><img title="delete row" alt="Remove Item" src="/drmHope/img/icons/cross.png" ></a></td>';
		    

		  field +='  </tr>    ';
      	$("#item-row").append(field);
		$(".date").datepicker({
			showOn: "both",
			buttonImage: "/drmHope/img/js_calendar/calendar.gif",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,
			yearRange: '1950',
			dateFormat:'<?php echo $this->General->GeneralDate();?>',
			
			onSelect : function() {
				$(".date").validationEngine("hide");   
			}
		});
		
		if (number_of_field == 1){
						$("#remove-btn").css("display","none");
					}else{
		$("#remove-btn").css("display","inline");
		}
}
function removeRow(){
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

		number_of_field = number_of_field-1;
	}
	if (number_of_field == 1){
		$("#remove-btn").css("display","none");
	}
}

/* to show the credit amount field*/
$("#payment_mode").live('change',function(){
	if(this.value == "credit"){
		$(".creditDaysInfo").css('visibility','visible');
		$(".paymentInfoCreditCard").hide();
		$(".neft-area").css('visibility','hidden');
		$(".discount_type_label").html('Discount in Amount By :');
		
	}else 
	if(this.value == "creditCard" || this.value == "cheque"){
		$(".creditDaysInfo").css('visibility','hidden');
		$("#paymentInfoCreditCard").show();
		$(".neft-area").css('visibility','hidden');
		$(".discount_type_label").html('Discount in Amount By :');
		
	}else
	if(this.value == "neft"){
		$(".neft-area").css('visibility','visible');
		$(".creditDaysInfo").css('visibility','hidden');
		$("#paymentInfoCreditCard").hide();
		$(".discount_type_label").html('Discount in Amount By :');
	}else{
		$(".neft-area").css('visibility','hidden');
		$(".creditDaysInfo").css('visibility','hidden');
		$("#paymentInfoCreditCard").hide;
		$(".discount_type_label").html('Discount in Amount By :');
	}
	
	
});

$("#BN_paymentInfoCreditCard").live('keyup change blur',function(){
	
	$("#BN_neftArea").val($(this).val());
	 
});
$("#AN_paymentInfoCreditCard").live('keyup change blur',function(){
	$("#AN_neftArea").val($(this).val());
});
$("#card_check_number").live('keyup change blur',function(){
	$("#card_neftArea").val($(this).val());
});



$("#extra_amount").live('blur',function(){
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
							grandTotal = total_amount+extraAmount; alert(grandTotal);
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

$(".radio").live('click',function(){
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

					

$(".quantity").live('blur',function()
			  {
			   $("#cst").val("");
			   $("#tax").val("0");
			   $("#extra_amount").val("");
			   //$("#credit_amount").val("");
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
    				var $form = $('#InventoryPurchaseDetailInventoryPurchaseReceiptForm'),
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
			  
$("#tax").live('blur',function()
	  {        
				if($("#extra_amount").val()==""){
					alert("Please enter Discount Amount");
					return false;
				}
	  			
	  			total = 0;
            	var total = parseFloat($("#total_amount_field").val());  
            	         	
                var tax = parseFloat($(this).val());
				if(isNaN(tax) && tax != "0"){
					alert("Enter the valid Tax amount.");
					setTimeout(function() { $("#tax").focus(); }, 50);
					return false;
				}
                var tax_value = (total*tax)/100;
                total =tax_value+total;
                //alert("tax_value"+tax_value+", tax="+tax+", total="+total); 
                $("#total_amount_field").val(total.toFixed(2));
    			//$("#total_amount").val(total.toFixed(2));
    			
                caluculateGrandTotal();
             
                
    });
    

   
  
$("#cst").live('blur',function()
		  {
	            	var total = parseFloat($("#total_amount_field").val());
	                var cst = parseFloat($(this).val());//alert(cst);
					if(isNaN(cst)){
						alert("Enter the valid CST amount.");
						setTimeout(function() { $("#cst").focus(); }, 50);
						return false;
					}
	                var cst_value = (total*cst)/100;
	                total =cst_value+total;
	               	$("#total_amount_field").val(total.toFixed(2));
	    			$("#total_amount").html(total.toFixed(2));
	                caluculateGrandTotal();
	    });
$(".price").live('blur',function()
			  {
			   $("#cst").val("");
			   $("#tax").val("0");
			   $("#extra_amount").val("");
			   //$("#credit_amount").val("");
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
					//alert("Enter the Quantity");
					//setTimeout(function() { $("#qty"+fieldno).focus(); }, 50);
					return false;
				}
                var price = parseFloat(currentField.val());
               	if(!isNaN(price)){
    				var value = price*qty;
    				var	sub_total = value+((value*tax)/100);
    				$("#value"+fieldno).val((sub_total.toFixed(2)));
    				var $form = $('#InventoryPurchaseDetailInventoryPurchaseReceiptForm'),
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



$(".tax").live('blur',function()
			  {
			   $("#cst").val("");
			   $("#tax").val("0");
			   $("#extra_amount").val("");
			   //$("#credit_amount").val("");
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
    				var $form = $('#InventoryPurchaseDetailInventoryPurchaseReceiptForm'),
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
	  if(number_of_field==1){
	 	alert("Single row can't delete.");
	 	return false;
		}
	//$("#row"+id).find("input").remove();
	
	 $("#row"+id).remove(); 

	//number_of_field = number_of_field-1;;
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
					number_of_field--;
					if (number_of_field == 1){
						$("#remove-btn").css("display","none");
						
					}
					
					
	/*$('.item_name'+number_of_field+"formError").remove();
	$('.batch_number'+number_of_field+"formError").remove();
	$('.expiry_date'+number_of_field+"formError").remove();
	$('.qty'+number_of_field+"formError").remove();
	$('.mrp'+number_of_field+"formError").remove();
	$('.price'+number_of_field+"formError").remove();
	$('.value'+number_of_field+"formError").remove();
	$('.tax'+number_of_field+"formError").remove();*/
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
 $('.item_name').live('focus',function()
			  {
			  if($("#party_id").val()==""){
			  	alert("Please select Party Name.");
				//setTimeout(function() { $("#party_name").focus(); });
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
					$("#price"+fieldno).val(ItemDetail.PharmacyItemRate.purchase_price);
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
									$("#price"+fieldno).val(ItemDetail.PharmacyItemRate.purchase_price);
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
				selectFirst: false,
				matchSubset:1,
				matchContains:1,
				onItemSelect:selectItem,
				autoFill:false
			}
		);

	}
		);
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
 				var total_amount = 0;
 				//var total_amount = parseFloat($("#total_amount").html());
 				//alert(total_amount);
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
				 //alert(total_amount);
				 $("#total_amount_field").val(total_amount.toFixed(2));
				 $("#grand_total").html(total_amount.toFixed(2));
			 }


}
</script>
