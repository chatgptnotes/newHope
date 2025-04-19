<div class="inner_title" >
<?php echo $this->element('ot_pharmacy_menu');?>
	<h3>OT Pharmacy Sales Return</h3>
	<span><?php
	echo $this->Html->link(__('Back'), array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
	?>
	</span>
</div>

<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#OtPharmacySalesReturnForm").validationEngine();
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
<div class="clr ht5"></div>
<?php echo $this->Form->create('OtPharmacySalesReturnForm',array('onkeypress'=>"return event.keyCode != 13;",'id'=>'otSalesReturnfrm'));?>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<!-- <td width="50">&nbsp;</td>
		<td width="45" class="tdLabel2">Patient Code </td>
		<td width="140" class="tdLabel2">
		<input name="OtPharmacySalesReturn[party_code]" type="text" class="textBoxExpnd" id="party_code" value="<?php echo $editReturn['Patient']['admission_id']?>"
			onkeyup="clearField(this)" />
		</td> -->
		
		<td width="45" class="tdLabel2">Patient Name/ID <font color="red">*</font></td>
		<td width="140" class="tdLabel2">
		<input name="OtPharmacySalesReturn[party_name]" type="text" class="textBoxExpnd validate[required]" id="party_name" 
			value="<?php echo $editReturn['Patient']['lookup_name']?>" onkeyup="clearField(this)" />
		<input name="OtPharmacySalesReturn[patient_id]" id="person_id" value="<?php echo $editReturn['Patient']['id']?>" type="hidden" />
	    <input name="ot_pharmacy_sales_bill_id" id="ot_pharmacy_sales_bill_id" value="" type="hidden" /> 
		</td>
		<td width="10">&nbsp;</td>
		<td width="50">&nbsp;</td>
		<td width="45" class="tdLabel2">&nbsp; </td>
		<td width="140" class="tdLabel2">&nbsp;</td>
	</tr>
</table>
<div class="clr ht5"></div>


<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm" id="item-row">
	<tr><td colspan="2"><font color="#ff343"><i>(MSU = Minimum Saleable Unit)</i></font></td></tr>
	<tr>
		<th width="80" align="center" valign="top" style="text-align: center;">Item Name<font color="red">*</font></th>
		<th width="100" valign="top" style="text-align: center;">Quantity<font color="red">*</font></th>
		<th width="50" valign="top" style="text-align: center;">Sold Quantity<font color="red"></font></th>
		<th width="50" valign="top" style="text-align: center;">Pack</th>
		<th width="100" align="center" valign="top" style="text-align: center;">Batch No.<font color="red">*</font></th>
		<th width="150" align="center" valign="top" style="text-align: center;">Expiry Date<font color="red">*</font></th>
		<th width="50" valign="top" style="text-align: center;">MRP<font color="red">*</font></th>
		<th width="50" valign="top" style="text-align: center;">Price<font color="red">*</font></th>
		<?php if(strtolower($this->Session->read('website.instance')) == "vadodara") { ?>
			<th width="50" valign="top" style="text-align: center;">Discount</th>
		<?php } ?>
		<th width="60" valign="top" style="text-align: center;">Amount<font color="red">*</font></th>
		<th width="10" valign="top" style="text-align: center;">#</th>
	</tr>
	
	<?php $cnt=1;
	if(!empty($editReturn)){
		
	foreach($editReturn['OtPharmacySalesReturnsDetail'] as $editItem){?>
		<tr id="<?php echo "row$cnt"?>">
			<td align="center" valign="middle" width="185">
				<input name="OtPharmacySalesReturn[item_id][]" id="item_id1" type="hidden" value="<?php echo $editItem['item_id']?>" style="width: 80%;" />
				<input	name="OtPharmacySalesReturn[item_name][]" type="text" class="textBoxExpnd validate[required] item_name" id="<?php echo "item_name-$cnt"?>"
						value="<?php echo $itemArray[$editItem['item_id']]['item_name']?>" style="width: 70%;" fieldNo="<?php echo $cnt?>"
						onkeyup="checkIsItemRemoved(this)" /> <a href="#" id="viewDetail_1" class='fancy' >
				<img title="View Item" alt="View Item" src="/DrmHope/img/icons/view-icon.png"> </a>
			</td>
			<td valign="middle" style="text-align: center;">
			
			<table>
				<tr>
					<td>
						<input name="qty[]"	type="text" class="textBoxExpnd validate[required,number] quantity" autocomplete="off" id="<?php echo "qty_$cnt"?>" value="<?php echo $editItem['qty']?>" 
							style="width:100%;" fieldNo="<?php echo $cnt?>" /> 
						<input type="hidden" id="<?php echo "stockQty_$cnt"?>" value="<?php echo $itemArray[$editItem['item_id']]['stock']?>" />
						<input type="hidden" id="<?php echo "returnLimit_$cnt"?>" value="0" />
					</td>
					<td>
						<?php 
   							echo $this->Form->input('OtPharmacySalesBill.item_type', array('style'=>'width:60px;','name'=>"itemType[]",'class'=>'textBoxExpnd itemType',
   								'div' => false,'fieldNo'=>"1",'label' => false,'autocomplete'=>'off','id' => 'itemType_'.$cnt,'value'=>$editItem['qty_type'],
   								'options'=>array('Tab'=>'MSU'/*,'Pack'=>'Pack','Unit'=>'Unit'*/))); 
						?>
					</td>
				</tr>
			</table>
				</td>		
				<input name="OtPharmacySalesReturn[oQty][]" type="hidden" class="textBoxExpnd validate[required,number] " id="<?php echo "oQty_$cnt"?>"  value="" style="width: 100%;" fieldNo="<?php echo $cnt?>" readonly="true"/> 
				
				<td valign="middle" style="text-align: center;">
				<input name="OtPharmacySalesReturn[sQty][]" type="text" id="<?php echo "sQty_$cnt"?>"  value="<?php echo $itemArray[$editItem['item_id']]['sold_qty']?>" style="width: 100%;" fieldNo="<?php echo $cnt?>" readonly="true"/> 
				</td>
				<td align="center" valign="middle">
				<input name="OtPharmacySalesReturn[pack][]" type="text" class="textBoxExpnd " id="<?php echo "pack_$cnt"?>"  value="<?php echo $itemArray[$editItem['item_id']]['pack']?>"
					style="width: 100%;" readonly="true" />
				</td>
			
				<td valign="middle" style="text-align: center;">
				<input name="OtPharmacySalesReturn[batch_number][]" type="text" class="textBoxExpnd validate[required] batch_number"
							id="<?php echo "batch_number$cnt"?>" value="<?php echo $editItem['batch_no']?>" style="width: 100%;"
							autocomplete="off" fieldNo="<?php echo $cnt?>" />
				</td>
					
				<?php $expDate=$this->DateFormat->formatDate2Local($editItem['expiry_date'],Configure::read('date_format'),false);?>
		
				<td valign="middle" style="text-align: center;">
				<input name="OtPharmacySalesReturn[expiry_date][]" type="text"  class=" textBoxExpnd validate[required] expiry_date"
						id="<?php echo "expiry_date$cnt"?>" value="<?php echo $expDate?>" style="width: 80%;"
						autocomplete="off" readonly="true" />
				</td>
				<td valign="middle" style="text-align: center;">
				<input name="OtPharmacySalesReturn[mrp][]" type="text" class="textBoxExpnd validate[required,number] mrp" id="<?php echo "mrp_$cnt"?>" fieldNo="<?php echo $cnt?>"
					value="<?php echo $editItem['mrp']?>" style="width: 100%;"  /></td>
		
				<td valign="middle" style="text-align: center;">
				<input name="OtPharmacySalesReturn[rate][]" type="text" class="textBoxExpnd validate[required,number] rate" id="<?php echo "rate_$cnt"?>" fieldNo="<?php echo $cnt?>"
					 value="<?php echo $editItem['sale_price']?>" style="width: 100%;" /></td>
				<?php $amt= $editItem['sale_price'] * $editItem['qty'];?>
				
				<?php if($editItem['qty_type'] == "Tab") { 
					$amt= ($editItem['sale_price'] * $editItem['qty'])/(int)$editItem['pack'];
				}
				?>
				<td valign="middle" style="text-align: center;">
				<input name="value[]" type="text" class="textBoxExpnd validate[required,number] value"
					id="value1"  value="<?php echo $amt?>" style="width: 100%;" />
				</td>
				<td valign="middle" style="text-align: center;">
				<a href="javascript:void(0);" id="delete-row" onclick="deletRow('1');">
				<img title="delete row" alt="delete row" src="/DrmHope/img/icons/cross.png"> </a>
				</td>
			</tr>
			<input type="hidden" value="<?php echo $editItem['qty']?>" name="pre_sold_qty[]" />
		<input type="hidden" value="<?php echo $cnt;?>" id="no_of_fields" />
	<?php $totAmt=$totAmt+$amt;
	$cnt++;}//EOF foreach
}else{?>
<input type="hidden" value="<?php echo $cnt;?>" id="no_of_fields" />
	<tr id="row1">
		<td align="center" valign="middle" width="185">
		<input name="OtPharmacySalesReturn[item_id][]" id="item_id1" type="hidden" value="" class="itemId" fieldNo="1"/>
		
		<input	name="OtPharmacySalesReturn[item_name][]" type="text" class="textBoxExpnd validate[required] item_name" id="item_name-1"
			value="" style="width: 100%;" fieldNo="1" onkeyup="checkIsItemRemoved(this)" /> 
		</td>
		
		<td valign="middle" style="text-align: center; padding:0px;">
			<table >
				<tr>
					<td>
					<input name="OtPharmacySalesReturn[qty][]"	type="text" class="textBoxExpnd validate[required,number] quantity" autocomplete="off" id="qty_1" value="" 
							style="width:100%;" fieldNo="1" readonly="readonly"/> 
					<input type="hidden" id="stockQty1" value="0" autocomplete="off" />
					<input type="hidden" id="returnLimit1" value="0" />
					</td>
					<td>
						<?php 
   							echo $this->Form->input('PharmacySalesBill.item_type', array('style'=>'width:60px;','name'=>"itemType[]",'class'=>'textBoxExpnd itemType',
   								'div' => false,'fieldNo'=>"1",'label' => false,'autocomplete'=>'off','id' => 'itemType_'.$cnt,
   								'options'=>array('Tab'=>'MSU'/*,'Pack'=>'Pack','Unit'=>'Unit'*/))); 
						?>
					</td>
				</tr>
			</table>
		</td>
							
		<input name="OtPharmacySalesReturn[oQty][]" type="hidden" class="textBoxExpnd validate[required,number] "
			id="oQty_1"  value="" style="width: 100%;" fieldNo="1" readonly="true"/> 
		
		<td valign="middle" style="text-align: center;">
		<input name="OtPharmacySalesReturn[sQty][]" type="text" id="sQty_1" class="textBoxExpnd" value="" style="width: 100%;" fieldNo="1" readonly="true"/> 
		</td>
		<td align="center" valign="middle">
		<input name="OtPharmacySalesReturn[pack][]" type="text" class="textBoxExpnd " id="pack_1"  value=""
			style="width: 100%;" readonly="true" />
		</td>
		<td valign="middle" style="text-align: center;" >
			<?php echo $this->Form->input('',array('type'=>'select','options'=>'','class'=>'textBoxExpnd validate[required] batch_number','id'=>'batch_number1', 
					'style'=>"width: 100%",'autocomplete'=>"off" ,"tabindex"=>"9","fieldNo"=>"1",'label'=>false,'name'=>"data[pharmacyItemId][]")); ?>
		</td>
		
		<td valign="middle" style="text-align: center;">
		<input name="OtPharmacySalesReturn[expiry_date][]" type="text" class="textBoxExpnd validate[required] expiry_date"
			 id="expiry_date1" value="" style="width: 80%;" autocomplete="off" readonly="true" />
		</td>
		
		<td valign="middle" style="text-align: center;">
		<input name="OtPharmacySalesReturn[mrp][]" type="text" class="textBoxExpnd validate[required,number] mrp" id="mrp_1" fieldNo="1"
			value="" style="width: 100%;"  />
		</td>
			
		<td valign="middle" style="text-align: center;">
		<input name="OtPharmacySalesReturn[rate][]" type="text" class="textBoxExpnd validate[required,number] rate" id="rate_1" fieldNo="1"
			 value="" style="width: 100%;" />
		</td>
		
		<?php if(strtolower($this->Session->read('website.instance')) == "vadodara") { ?>
		<td valign="middle" style="text-align: center;">
		<input type="hidden" name="OtPharmacySalesReturn[itemWisediscount][]" value="" id="itemWiseDiscount_1"/>
		<input name="OtPharmacySalesReturn[discountAmount][]" type="text" class="textBoxExpnd itemWiseDiscountAmount" id="itemWiseDiscountAmount_1" readonly="readonly" fieldNo="1"
			 value="" style="width: 100%;" />
		</td>
		<?php } ?>
		
		<td valign="middle" style="text-align: center;">
		<input name="value[]" type="text" class="textBoxExpnd validate[required,number] value"
			id="value_1"  value="" style="width: 100%;" />
		</td>
		<td valign="middle" style="text-align: center;">
		<a href="javascript:void(0);" id="delete-row" onclick="deletRow('1');">
			<?php echo $this->Html->image('icons/cross.png',array('title'=>'delete row','alt'=>'delete row')); ?></a>
		</td>
	</tr>
<?php }?>
</table>

<div class="clr ht5"></div>
<div align="right">
	<input name="" type="button" value="Add More" class="blueBtn Add_more" onclick="addFields()" /><input name="" type="button" value="Remove" id="remove-btn" class="blueBtn" 
		onclick="removeRow()" style="display: none" />
</div>
<div class="clr ht5"></div>

<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td align="right"></td>
		<td align="right" class="tdLabel2" width="80%" style="text-align:right">Total Amount :</td>
		<td width="8%" style="text-align:right"><?php echo $this->Session->read('Currency.currency_symbol') ; ?>&nbsp;
		<span id="total_amount"><?php echo isset($totAmt)?$totAmt:'0';?></span>
		<input name="OtPharmacySalesReturn[total]" id="total_amount_field" value="<?php echo isset($totAmt)?$totAmt:'0';?>" type="hidden" /></td>
	</tr>
	
	<tr>
		<td align="right"></td>
		<td class="tdLabel2" style="text-align:right">Total Discount :</td>
		<td style="text-align:right"><?php echo $this->Session->read('Currency.currency_symbol') ; ?>&nbsp;
		<span id="showTotalDiscount">0</span>
		<input type="hidden" id="totalDiscount" name="OtPharmacySalesReturn[discountTotal]" value=""/>
	</td>
	</tr>
	
	<tr>
		<td align="right"></td>
		<td class="tdLabel2" style="text-align:right">Net Amount :</td>
		<td style="text-align:right"><?php echo $this->Session->read('Currency.currency_symbol') ; ?>&nbsp;
		<span id="showNetAmount">0</span>
		</td>
	</tr>
</table>
 
<div class="btns">
	<input name="submit" type="submit" value="Submit" class="blueBtn"  id="submitButton" />
	<?php echo $this->Form->end();?>
</div>


<script>
$(document).ready(function(){
	
	$('#party_name').autocomplete({
		source:	"<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_patient_detail","lookup_name","IPD","inventory" => true,"plugin"=>false)); ?>",
		select:function (event, ui) {
		    $("#ot_pharmacy_sales_bill_id").val("");
			var person_id = ui.item.id;
			$("#person_id").val(person_id);
			$("#party_name").val(ui.item.value);
			$("#item_name-1").focus();
		},
		 messages: {
	        noResults: '',
	        results: function() {}
		 }	
	});

	itemAutoComplete("item_name-1");	//for initial autocomplete// initial autocomplete for item name
});	

	$(".item_name").focus(function(){
		if($("#person_id").val()=="" && $("#ot_pharmacy_sales_bill_id").val() =="")
			{ 
			alert("Please Select Patient First.");
			$("#party_name").focus();
		}
	});

  function clearField(obj){
	if($.trim(obj.value.length)==0){
	$("#party_code").val("");
		$("#party_name").val("");
		$("#total_amount").html("0");
	}
}
  
  function deletRow(id){
      if(number_of_field==1){
	 	alert("Single row can't delete.");
	 	return false;
		}
	$("#row"+id).remove();
	//getTotal(this); 

	var sum = 0; discAmt = 0;
	count = 1;
	$('.value').each(function() { 
	    if(this.value!== undefined  && this.value != ''  ){
        	sum += parseFloat(this.value);	       
        }
		count++;			        				        
    });

	$('.itemWiseDiscount').each(function() { 
	    if(this.value!== undefined  && this.value != ''  ){
        	discAmt += parseFloat(this.value);	       
        }
    });

    $("#totalDiscount").val(discAmt.toFixed(2));
    $("#showTotalDiscount").html(discAmt.toFixed(2));
	$("#total_amount_field").val((sum.toFixed(2)));
	$("#total_amount").html((sum.toFixed(2))); 
	$("#showNetAmount").html((sum - discAmt).toFixed());

	
	/*$("#total_amount_field").val((sum.toFixed(2)));
	$("#total_amount").html((sum.toFixed(2))); */
}
  
   function checkIsItemRemoved(obj){
	var fieldno = $(obj).attr('fieldNo') ;
	if($.trim(obj.value.length)==0){
			$("#item_name-"+fieldno).val("");
			$("#viewDetail_"+fieldno).remove();
			$("#item_id"+fieldno).val("");
			$("#item_code"+fieldno).val("");
            $("#manufacturer"+fieldno).val("");
		 	$("#pack_"+fieldno).val("");
			$("#mrp_"+fieldno).val("");
			$("#rate_"+fieldno).val("");
			$("#stockQty_"+fieldno).val("");
			$("#batch_number"+fieldno).val("");
			$("#expiry_date"+fieldno).val("");
			$("#qty_"+fieldno).val("");
			$("#value_"+fieldno).val("");
			$("#free"+fieldno).val("");
	}
}
   
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
				}
            };

        }
    };
    $.validationEngineLanguage.newLang();
})(jQuery);

	$(document).keypress(('.quantity'),function(e) {
	 	var fieldNo = $(this).attr('fieldNo') ;
	    if (e.keyCode==40) {	//key down
	        $("#quantity_"+fieldNo).focus();
	    } 
	    if(e.keyCode==13){		//key enter
		    if($("#item_id"+fieldNo).val()!=0 || $("#item_id"+fieldNo).val()!=''){
	    		addFields();
		    }
	    } 
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
	
  var number_of_field = 1;
  
	function addFields(){
		if($("#person_id").val()=="")
		{ 
			alert("Please Select Patient First.");
			$("#party_name").focus();
			return false;
		}
			number_of_field = number_of_field+1; 
		 
           var field = '';
		   	field += '<tr id="row'+number_of_field+'"><!--<td align="center" valign="middle" class="sr_number">'+number_of_field+'</td>-->';
		    field += '<td align="center" valign="middle"><input name="OtPharmacySalesReturn[item_id][]" class="itemId" fieldNo="'+number_of_field+'" id="item_id'+number_of_field+'" type="hidden" value=""/><input name="OtPharmacySalesReturn[item_name][]" id="item_name-'+number_of_field+'" type="text" class="textBoxExpnd validate[required,number] item_name"  value="" style="width:100%;" fieldNo="'+number_of_field+'" onkeyup="checkIsItemRemoved(this)"/> <!--<a href="#" id="viewDetail_'+number_of_field+'" class="fancy" style="visibility:hidden;"><img title="View Item" alt="View Item" src="/DrmHope/img/icons/view-icon.png"></a>--></td>';
        	field += '<td style="text-align:center; padding:0px;"><table><tr><td><input name="OtPharmacySalesReturn[qty][]" readonly="readonly" type="text" autocomplete="off" class="textBoxExpnd quantity validate[required,number]"  value="" id="qty_'+number_of_field+'" style="width:100%;" fieldNo="'+number_of_field+'"/> <input type="hidden" value="0" id="stockQtys_'+number_of_field+'"></td><td><select name="itemType[]" fieldNo="'+number_of_field+'", id="itemType_'+number_of_field+'" class="itemType"></option><option value="Tab">MSU<!--<option value="Pack">Pack</option><option value="Unit">Unit</option>--></select> </td></tr></table></td>';
       		field += '<td valign="middle" style="text-align: center;"><input name="OtPharmacySalesReturn[sQty][]" type="text" id="sQty_'+number_of_field+'" value="" style="width: 100%;" fieldNo="'+number_of_field+'" readonly="true"/></td>'
       		field += '<td align="center" valign="middle"><input name="OtPharmacySalesReturn[pack][]" id="pack_'+number_of_field+'" type="text" class="textBoxExpnd "  value=""  style="width:100%;" readonly="true"/></td>';
			field += '<td align="center" valign="middle"><select name="data[pharmacyItemId][]" id="batch_number'+number_of_field+'" class="textBoxExpnd validate[required] batch_number" value=""  style="width:100%;" autocomplete="off" fieldNo="'+number_of_field+'"></select></td>';
			field += '<td align="center" valign="middle"><input name="OtPharmacySalesReturn[expiry_date][]" id="expiry_date'+number_of_field+'" type="text" class="textBoxExpnd validate[required] expiry_date" value=""  style="width:80%;" autocomplete="off"/></td>';
			field += '<td valign="middle" style="text-align:center;"><input name="OtPharmacySalesReturn[mrp][]" fieldNo="'+number_of_field+'" type="text" class="textBoxExpnd validate[required,number] mrp" value="" id="mrp_'+number_of_field+'" style="width:100%;" /></td>';
		   	field += '<td valign="middle" style="text-align:center;"><input name="OtPharmacySalesReturn[rate][]"  fieldNo="'+number_of_field+'" type="text" class="textBoxExpnd validate[required,number] rate" value="" id="rate_'+number_of_field+'" style="width:100%;" /></td>';
		   	"<?php if(strtolower($this->Session->read('website.instance')) == "vadodara") { ?>"
			field += '<td valign="middle" style="text-align:center;"><input type="hidden" name="OtPharmacySalesReturn[itemWisediscount][]" value="" id="itemWiseDiscount_'+number_of_field+'"/><input name="OtPharmacySalesReturn[discountAmount][]" type="text" class="textBoxExpnd itemWiseDiscountAmount" readonly="readonly" id="itemWiseDiscountAmount_'+number_of_field+'" fieldNo="'+number_of_field+'" value="" style="width: 100%;" /></td>'
			"<?php } ?>"
           	field += ' <td valign="middle" style="text-align:center;"><input name="OtPharmacySalesReturn[value][]" type="text" class="textBoxExpnd  validate[required,number] value" id="value_'+number_of_field+'" value=""  style="width:100%;"/></td> ';

			if(number_of_field>=1)
		   	field +='<td valign="middle" style="text-align:center;"> <a href="javascript:void(0);" id="delete-row" onclick="deletRow('+number_of_field+');"><?php echo $this->Html->image("icons/cross.png",array("alt"=>"Remove Row", "title"=>"Remove Item")); ?></a></td>';
		   
		  	field +='</tr>';
		  $("#item-row").append(field);
		  $("#item_name-"+number_of_field).focus();
		  if (number_of_field == 1){
				$("#remove-btn").css("display","none");
			}else{
				$("#remove-btn").css("display","inline");
			}
		  itemAutoComplete("item_name-"+number_of_field);
     
}
	
function removeRow(){
	$('.item_code'+number_of_field+"formError").remove();
	$('.item_name'+number_of_field+"formError").remove();
	$('.batch_number'+number_of_field+"formError").remove();
 	$('.expiry_date'+number_of_field+"formError").remove();
	$('.qty'+number_of_field+"formError").remove();
	$('.value'+number_of_field+"formError").remove();
	$('.rate'+number_of_field+"formError").remove();
	$('.mrp'+number_of_field+"formError").remove();
	if(number_of_field > 1){ 
		$("#row"+number_of_field).remove();
		number_of_field = number_of_field-1;
	}
		if(number_of_field == 1){
		$("#remove-btn").css("display","none");
	}
		var sum = 0; discAmt = 0;
		count = 1;
		$('.value').each(function() { 
		    if(this.value!== undefined  && this.value != ''  ){
	        	sum += parseFloat(this.value);	       
	        }
			count++;			        				        
	    });

		$('.itemWiseDiscountAmount').each(function() { 
		    if(this.value!== undefined  && this.value != ''  ){
	        	discAmt += parseFloat(this.value);	       
	        }
	    });

	    $("#totalDiscount").val(discAmt.toFixed(2));
	    $("#showTotalDiscount").html(discAmt.toFixed(2));
		$("#total_amount_field").val((sum.toFixed(2)));
		$("#total_amount").html((sum.toFixed(2))); 
		$("#showNetAmount").html((sum - discAmt).toFixed());

	    
		/*$("#total_amount_field").val((sum.toFixed(2)));
		$("#total_amount").html((sum.toFixed(2))); */
	
}

function itemAutoComplete(id){
	var patientId  = $("#person_id").val();
	var party_name = $("#party_name").val();
	

	 	src  = "<?php echo $this->Html->url(array("controller" => "OtPharmacy", "action" => "autocomplete_sales_return_item","name","plugin"=>false)); ?>" ;
		$('.item_name').autocomplete({
		source:	function(request, response) {
            $.ajax({
            	dataType: 'json',
                url: src, 
                data: {patientId:$("#person_id").val(),party_name:$("#party_name").val(),term: request.term},
                success: function(data) {
                    response(data);
                }
            });
        }, 
		select:function (event, ui) {
			console.log(ui);
			//selectedId = t.attr('id');
			selectedId = $(this).attr('id');
			loadDataFromRate(ui.item.id,selectedId);
		},
		 messages: {
	        noResults: '',
	        results: function() {}
		 }
		}); 
	}

	/* for auto populate the data */
function selectPatient(li,selectedId) {
	if( li == null ) return alert("No match!");
		var itemID = li.extra[0];
		$("#person_id").val(itemID);
	if(li.extra[1] == "lookup_name")
			$("#party_code").val(li.extra[0]);
		else
			$("#party_name").val(li.extra[0]);
}

 /* get the Item details*/
 function getItemDetail(itemId){
	 var res = '';
 $.ajax({
		  type: "POST",
		  url: "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "view_item","inventory" => true,"plugin"=>false)); ?>",
		  async:false,
		  data: "item_id="+itemId,
		}).done(function( msg ) {
			res =  jQuery.parseJSON(msg);
	});
	return res;
 }
 
function selectItem(li,selectedId) {
	if( li == null ) return alert("No match!");
		var itemID = li.extra[0];
		var currentField = $("#"+selectedId);
		var fieldno = currentField.attr('fieldNo') ;
		$("#viewDetail_"+fieldno).attr('href','view_item/'+itemID+'?popup=true');
		$("#viewDetail_"+fieldno).css("visibility","visible");
		$("#stockQty_"+fieldno).val(li.extra[2]);
		$("#viewDetail_"+fieldno).fancybox({
				'width'				: '80%',
				'height'			: '100%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
		loadDataFromRate(itemID,selectedId);
}

$(".Add_more").click(function(){
	$(".expiry_date").datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		changeTime:true,
		showTime: true,
		yearRange: '1950',
		dateFormat:'<?php echo $this->General->GeneralDate("");?>'
	});
});


/* load the data from supplier master */
function loadDataFromRate(itemID,selectedId){ 
	var flag = false; 
	$(".itemId").each(function(){
		if(itemID === $(this).val()){
			var fieldCount = $(this).attr('fieldNo');
			alert("This Item Is Already Selected"); 
			$('#'+selectedId).val('');
			$('#'+selectedId).focus();
			flag = true;
			return false;
		}
	});
	if(flag == false){
	var patientId  = $("#person_id").val();
	var currentField = $("#"+selectedId);
	var fieldno = currentField.attr('fieldNo') ;
	$.ajax({
		  type: "POST",
		  url: "<?php echo $this->Html->url(array("controller" => "OtPharmacy", "action" => "fetch_rate_for_return_item",'item_id','name','true',"plugin"=>false)); ?>",
		  data: "item_id="+itemID+"&patient_id= "+patientId,
		}).done(function( msg ) {
		 	var item = jQuery.parseJSON(msg); 
		 	console.log(item);
		 	var qty = '';
		 	$("#qty_"+fieldno).val(qty);
		 	$("#item_name-"+fieldno).val(item.OtPharmacyItem.name);
			$("#item_id"+fieldno).val(item.OtPharmacyItem.id);
			$("#item_code"+fieldno).val(item.OtPharmacyItem.item_code);
            $("#pack_"+fieldno).val(item.OtPharmacyItem.pack);
		 	$("#stockQty_"+fieldno).val(item.OtPharmacyItem.stock);
		 	$("#sQty_"+fieldno).val(item.OtPharmacyItem.totalSold); 
		 	$("#itemWiseDiscount_"+fieldno).val(item.OtPharmacyItem.discount); 
		 	
		 	batches= item.OtPharmacyItemRate;
			$("#batch_number"+fieldno+" option").remove();
			if(batches!=''){
				$.each(batches, function(index, value) { 
				    $("#batch_number"+fieldno).append( "<option value='"+value.id+"'>"+value.batch_number+"</option>" );
					if(index==0){
						$("#expiry_date"+fieldno).val(value.expiry_date);
						$("#mrp_"+fieldno).val(value.mrp);
						$("#rate_"+fieldno).val(value.sale_price);
		            }					
				});
			}
			$("#qty_"+fieldno).attr('readonly',false);
			$("#qty_"+fieldno).focus();
		}); 
		selectedId='';
	}
}

	function getTotal(id){
		if($(id)!=""){
		var fieldno = $(id).attr('fieldNo') ;
		var soldQty = parseInt($("#sQty_"+fieldno).val());
		var qty = parseInt($("#qty_"+fieldno).val()!=""?$("#qty_"+fieldno).val():0);
        var price = ($("#rate_"+fieldno).val()!="")?$("#rate_"+fieldno).val():0.00;
        var qtyType = $("#itemType_"+fieldno).val();
        var itemDiscount = parseInt($("#itemWiseDiscount_"+fieldno).val()!=""?$("#itemWiseDiscount_"+fieldno).val():0);
        
		if($('#pack_'+fieldno).val())
			var pack = parseInt($('#pack_'+fieldno).val());  
		else 
			var pack = 1 ; 
			
       if(!isNaN(price)){ 
			if(price<=0){
				price = parseFloat(($("#mrp_"+fieldno).val()!="")?$("#mrp_"+fieldno).val():0.00);
			}
			 
			if(qtyType == "Tab"){				
				var	sub_total = qty*price/pack;
			}else{
				var	sub_total = qty*price;
			}
			var totalWithTax = sub_total;
			if(price != 0 || price !=''){
				$("#value_"+fieldno).val(totalWithTax.toFixed(2));
			}

			var discountValue = (qty * itemDiscount); 
			$("#itemWiseDiscountAmount_"+fieldno).val(discountValue.toFixed(2));
			
			var sum = 0; discAmt = 0;
			count = 1;
			
			$('.itemWiseDiscountAmount').each(function() { 
			    if(this.value!== undefined  && this.value != ''  ){
		        	discAmt += parseFloat(this.value);	       
		        }
		    });
		    
			$('.value').each(function() { 
			    if(this.value!== undefined  && this.value != ''  ){
		        	sum += parseFloat(this.value);	       
		        }
				count++;			        				        
		    });

			$("#totalDiscount").val(discAmt.toFixed(2));
		    $("#showTotalDiscount").html(discAmt.toFixed(2));
		    $("#showNetAmount").html((sum - discAmt).toFixed());
			$("#total_amount_field").val((Math.round(sum.toFixed(2))));
			$("#total_amount").html((Math.round(sum.toFixed(2)))); 
        }
     }
	}


	  $(document).on('keyup',".quantity",function()
	  {
	  	if (/[^0-9\.]/g.test(this.value)){
	      	 this.value = this.value.replace(/[^0-9\.]/g,'');
	      }
	  	checkStockLimit(this);
	  	getTotal(this);
	  });

	  $(document).on('keyup',".mrp",function()
	  {
	  	if (/[^0-9\.]/g.test(this.value)){
	      	 this.value = this.value.replace(/[^0-9\.]/g,'');
	      }
	  	checkStockLimit(this);
	  	getTotal(this);
	  });

	  $(document).on('keyup',".rate",function()
	  {
	  	if (/[^0-9\.]/g.test(this.value)){
	      	 this.value = this.value.replace(/[^0-9\.]/g,'');
	      }
	  	checkStockLimit(this);
	  	getTotal(this);
	  });
	  //.mrp, .rate, #tax, #vat"
	  $(document).on('change',".itemType",function(){
		  checkStockLimit(this);
		  getTotal(this);
	  });

	    
	function checkStockLimit(id){
		if($(id)!=""){
			var fieldno = $(id).attr('fieldNo') ;
			var qty = parseInt($("#qty_"+fieldno).val());
	        var qtyType = $("#itemType_"+fieldno).val();
	    	var soldQty = parseInt($("#sQty_"+fieldno).val());
	    	var pack = parseInt($('#pack_'+fieldno).val());  
	    	if(qtyType != "Tab"){
				soldQty = Math.floor(soldQty/pack);
		    }
	        if(qty > soldQty){
	            alert("Return Quantity Is Greater Than Sold Quantity");
	            $("#qty_"+fieldno).val('');
	            $("#qty_"+fieldno).focus();
	            return false;
	        }
		}
	}

	
 $(".fancy").fancybox({
				'width'				: '80%',
				'height'			: '100%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});


 /*$(document).on('change',".batch_number",function()
 {
 	var t = $(this);
 	var fieldno = t.attr('fieldno') ;
 	$.ajax({
 		type: "GET",
         url: "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "inventory_fetch_batch_for_item","inventory" => true,"plugin"=>false)); ?>",
         data: "itemRate="+$(this).val(),
         success: function(data){
 			var ItemDetail = jQuery.parseJSON(data);
 			//console.log(ItemDetail.PharmacyItemRate);	
 			$("#mrp"+fieldno).val(ItemDetail.PharmacyItemRate.mrp);
 			$("#vat"+fieldno).val(ItemDetail.PharmacyItemRate.vat);
         	$("#rate"+fieldno).val(ItemDetail.PharmacyItemRate.sale_price);
             $("#expiry_date"+fieldno).val(ItemDetail.PharmacyItemRate.expiry_date);
             var itemrateid=$('#batch_number'+fieldno).val();
             var itemID=$('#item_id'+fieldno).val();
 			var editUrl  = "<?php echo $this->Html->url(array('controller'=>'pharmacy','action'=>'edit_item_rate','inventory'=>false))?>";
 			$("#viewDetail"+fieldno).attr('href',editUrl+'/'+'?type=edit&itemId='+itemID+'&item_rate_id='+itemrateid+'&'+'popup=true');
 			getTotal(t);
 		}
 	});
 });*/

 $("#submitButton").click(function(){
		

			var valid=jQuery("#otSalesReturnfrm").validationEngine('validate');
			  
			if(valid){
				$("#submitButton").hide();
				$('#busy-indicator').show();
			}else{
				return false;
			} 
		
	});
 </script>
