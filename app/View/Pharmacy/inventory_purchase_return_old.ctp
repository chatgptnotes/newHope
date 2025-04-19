  <div style="padding:10px">
<style>
.tdLabel2{
font-size:12px;
}
</style>
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#InventoryPurchaseReturnInventoryPurchaseReturnForm").validationEngine();
	});
	
</script>
<?php
 echo $this->Html->script('jquery.autocomplete_pharmacy');
  echo $this->Html->css('jquery.autocomplete.css');
   echo $this->Html->script('jquery.autocomplete_pharmacy');
  echo $this->Html->css('jquery.autocomplete.css');

?>

                  <div class="inner_title">
                    	<h3>Purchase Return</h3>
                  </div>
                  <div class="clr ht5"></div>
				  <input type="hidden" value="1" id="no_of_fields"/>
				   <?php echo $this->Form->create('InventoryPurchaseReturn');?>
                  <table width="100%" cellpadding="0" cellspacing="0" border="0">
                  	<tr>
                   	  	<td width="45" class="tdLabel2">Vr. No.</td>
                        <td width="80" class="tdLabel2"><input name="InventoryPurchaseDetail[vr_no]" type="text" class="textBoxExpnd validate[required]" id="vr_no" tabindex="1" value=""/></td>
                        <td width="10">&nbsp;</td>
                        <td width="45" class="tdLabel2">Vr. Dt.</td>
                        <td width="140" class="tdLabel2"><table width="100%" cellpadding="0" cellspacing="0" border="0">
                          <tr>
                            <td width=""><input name="InventoryPurchaseDetail[vr_date]" type="text" class="textBoxExpnd date validate[required]" id="vr_date" tabindex="2" value="" style="width:75%; background-color: #808080;" readonly="true"/></td>
                          
                          </tr>
                        </table>
                        </td>
                        <td width="50">&nbsp;</td>
                        <td width="75" class="tdLabel2">Party Code</td>
                        <td width="50" class="tdLabel2"><input name="InventoryPurchaseDetail[party_code]" type="text" class="textBoxExpnd" id="party_code" tabindex="3" value="" readonly="true" style="width:75%; background-color: #808080;"/></td>
                        <td width="50">&nbsp;</td>
                        <td width="80" class="tdLabel2">Party Name</td>
                        <td width="120" class="tdLabel2"><input name="InventoryPurchaseDetail[party_name]" type="text" class="textBoxExpnd  validate[required]" id="party_name" tabindex="4" value="" style="width:80%; background-color: #808080;" readonly="true"/></td>
					
                        <td width="30">&nbsp;</td>
                        <td width="50" class="tdLabel2">Bill No.</td>
                        <td width="80" class="tdLabel2"><input name="InventoryPurchaseDetail[bill_no]" type="text" class="textBoxExpnd validate[required]" id="bill_no" tabindex="5" value="" /></td>
                        <td>&nbsp;</td>
                    </tr>
                  </table>
                  <div class="clr ht5"></div> 
                   <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm" id="item-row">
                  	<tr>
               	  	  	  <th width="40" align="center" valign="top"  style="text-align:center;">Sr. No.</th>
                          <th width="" align="center" valign="top"  style="text-align:center;">Item Name</th>
                          <th width="60" align="center" valign="top"  style="text-align:center;">Pack</th>
                          <th width="60" valign="top" style="text-align:center;">Batch No.</th>
                          <th width="120" align="center" valign="top"  style="text-align:center;">Expiry Date</th>                          
                          <th width="50" valign="top" style="text-align:center;">Qty</th>
                          <th width="50" valign="top" style="text-align:center;">Free</th>
						    <th width="50" valign="top" style="text-align:center;">Tax</th>
                          <th width="60" valign="top" style="text-align:center;">Mrp</th>
                          <th width="60" valign="top" style="text-align:center;">Price</th>
                          <th width="80" valign="top" style="text-align:center;">Value</th>
                     	</tr>
                        <tr id="initialRow">
                          <td align="center" valign="middle" class="sr_number">1</td>
                          <td align="center" valign="middle"><input name="item_name[]" id="item_name1" type="text" class="textBoxExpnd validate[required] item_name"  tabindex="6" value="" style="width:80%;"  fieldNo='1'/></td>
                          <td align="center" valign="middle"><input name="pack[]" id="pack_item_name1" type="text" class="textBoxExpnd"  tabindex="7" value=""  style="width:80%;"  readonly="true"/></td>
                          <td align="center" valign="middle"><input name="batch_number[]" id="batch_number1" type="text" class="textBoxExpnd validate[required]"  tabindex="8" value=""  style="width:80%;"/></td>
                          <td valign="middle" style="text-align:center;"><table width="100%" cellpadding="0" cellspacing="0" border="0">
                       
                              <td width="135"><input name="expiry_date[]" type="text" id="expiry_date1" class="textBoxExpnd date validate[required,expiry_date]" tabindex="9" value="" style="width:65%;" /></td>
                              
                            </tr>
                          </table></td>
                          <td valign="middle" style="text-align:center;"><input name="qty[]" type="text" class="textBoxExpnd  quantity validate[required,custom[number]]"  tabindex="10" value="" id="qty1" style="width:70%;" fieldNo="1"/></td>
                          <td valign="middle" style="text-align:center;"><input name="free[]" type="text" class="textBoxExpnd validate[required]"  tabindex="11" value="" id="free1"  style="width:80%;"/></td>
						     <td valign="middle" style="text-align:center;"><input name="tax[]" type="text" class="textBoxExpnd validate[required,custom[number]] tax"  tabindex="11" value="" id="tax1"  style="width:80%;" fieldNo="1"/></td>
                          <td valign="middle" style="text-align:center;"><input name="mrp[]" type="text" class="textBoxExpnd validate[required,custom[number]]"  tabindex="12" value="" id="mrp1" style="width:80%;"/></td>
                          <td valign="middle" style="text-align:center;"><input name="price[]" type="text" class="textBoxExpnd validate[required,custom[number]]"  tabindex="13" value="" id="price1" style="width:80%;" readonly="true"/></td>
                          <td valign="middle" style="text-align:center;"><input name="value[]" type="text" class="textBoxExpnd value" id="value1"  tabindex="14" value=""  style="width:80%;" readonly="true"/></td>
                    
                     </tr>
                   </table>
                   <div class="clr ht5"></div>
				    
                   <table cellpadding="0" cellspacing="0" border="0">
                   		<tr>
                        	<td width="25" class="tdLabel2">CST</td>
                            <td width="50" id='cst'></td>
                            <td width="2">&nbsp;</td>
                            <td width="35" class="tdLabel2">Tax</td>
                            <td width="25" id='tax'></td>
							 <td width="2">&nbsp;</td>
							<td width="100" class="tdLabel2">Payment Mode : </td>
                            <td width="50" id='payment_mode'></td>
							<td width="100" class="tdLabel2 credit_amount">Credit Amount :</td>
							<td width="50" id="credit_amount">&nbsp;</td>
							<td width="100" class="tdLabel2">Total Amount : </td>
                            <td width="50"> <span id="total_amount">0</span><input name="InventoryPurchaseReturn[total_amount]" type="hidden"  id="grand_amount" value=''/></td>
							
                        </tr>
                   </table>     
				    <table id="d-type">
						<tr>
						
							 
						<td><span class="discount_type_label">Discount </span> Amount &nbsp;<input type="radio" id="discount_type_fix" name="InventoryPurchaseDetail[extra_amount_type]" value="0" readonly="true"></td>
						<td><span class="discount_type_label">Discount </span> Percentage &nbsp;<input type="radio" id="discount_type_percentage" name="InventoryPurchaseDetail[extra_amount_type]" value="1" readonly="true"></td>
						 <td width="50">&nbsp;</td>
						  <td width="50">&nbsp;</td>
                            <td  width="90">Amount:</td>
                            <td width="50"><input name="InventoryPurchaseDetail[extra_amount]" type="text" class="textBoxExpnd" id="extra_amount" tabindex="35" value="" /></td>
						</tr>
					</table>   
					    <table>
						<tr>
						 <td width="445">&nbsp;</td>
						    
						<td>Grand Total:</td><td><span id="grand_total">0</span></td>
						</tr>
					</table>    
             
                   
                   <!-- billing activity form end here -->
               <div class="btns">
                              <input name="print" type="submit" value="Print" class="blueBtn" tabindex="36"/> <input name="submit" type="submit" value="Submit" class="blueBtn" tabindex="37" id="submitButton"/>
							   <?php 
   echo $this->Html->link(__('Back'), array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
   ?>
  
                  </div>    
        <?php echo $this->Form->end();?>                 
<p class="ht5"></p>
                 
                  
                    <!-- Right Part Template ends here -->                </td>
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


(function($){
    $.fn.validationEngineLanguage = function(){
    };
    $.validationEngineLanguage = {
        newLang: function(){
            $.validationEngineLanguage.allRules = {
                "required": { // Add your regex rules here, you can take telephone as an example
                    "regex": "none",
                    "alertText":"required.",
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
				'expiry_date':{
				
				},
            };
            
        }
    };
    $.validationEngineLanguage.newLang();
})(jQuery);
 $('#vr_no').live('focus',function()
			  { 
			    $(this).autocomplete(
		"<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "purchase_details",'true','vr_no',"inventory" => true,"plugin"=>false)); ?>",
		{
			matchSubset:1,
			matchContains:1,
			cacheLength:10,
			onItemSelect:selectItem,
			autoFill:true
		}
	);
}); 
 $('#bill_no').live('focus',function()
			  { 
			    $(this).autocomplete(
		"<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "purchase_details",'true','bill_no',"inventory" => true,"plugin"=>false)); ?>",
		{
			matchSubset:1,
			matchContains:1,
			cacheLength:10,
			onItemSelect:selectItem,
			autoFill:true
		}
	);
}); 	

	/* for auto populate the data */
function selectItem(li) {
	if( li == null ) return alert("No match!");
		var itemID = li.extra[0];
		loadData(itemID);
}		
 
function loadData(itemID){
		$.ajax({
		  type: "POST",
		  url: "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "purchase_details","inventory" => true,"plugin"=>false)); ?>",
		  data: "id="+itemID,
		}).done(function( msg ) {
		 	var details = jQuery.parseJSON(msg);
			var extAmount = 0;
		    $("#vr_date").val(details.InventoryPurchaseDetail.vr_date);
			$("#bill_no").val(details.InventoryPurchaseDetail.bill_no);
			$("#vr_no").val(details.InventoryPurchaseDetail.vr_no);
			$("#party_code").val(details.InventorySupplier.code);
			$("#party_name").val(details.InventorySupplier.name);			
			$("#cst").html(details.InventoryPurchaseDetail.cst);
			$("#tax").html(details.InventoryPurchaseDetail.tax);
			$("#payment_mode").html(details.InventoryPurchaseDetail.payment_mode);
			$("#credit_amount").html(details.InventoryPurchaseDetail.credit_amount);
			var total = parseFloat(showItemDisplay(details));
			$("#grand_amount").val(Math.round(total));
			$("#extra_amount").val(Math.round(details.InventoryPurchaseDetail.extra_amount));
			
			if(details.InventoryPurchaseDetail.payment_mode == "cash"){
				$(".discount_type_label").html("Discount");
				if(details.InventoryPurchaseDetail.extra_amount_type == 0){
					$("#discount_type_fix").attr("checked",'checked');
					if (details.InventoryPurchaseDetail.extra_amount == null)
						details.InventoryPurchaseDetail.extra_amount = 0;
					extAmount = parseFloat(details.InventoryPurchaseDetail.extra_amount);
				}else{
						$("#discount_type_percentage").attr("checked",'checked');
						if (details.InventoryPurchaseDetail.extra_amount == null)
							details.InventoryPurchaseDetail.extra_amount = 1;
						extAmount = parseFloat((total*details.InventoryPurchaseDetail.extra_amount)/100);
					}
					total = total-extAmount;	
			}else{
				$(".discount_type_label").html("Add");
				if(details.InventoryPurchaseDetail.extra_amount_type != 0){
					$("#discount_type_fix").attr("checked",'checked');
					if (details.InventoryPurchaseDetail.extra_amount == null)
						details.InventoryPurchaseDetail.extra_amount = 0;
					extAmount = parseFloat(details.InventoryPurchaseDetail.extra_amount);
				}else{
					$("#discount_type_percentage").attr("checked",'checked');
					if (details.InventoryPurchaseDetail.extra_amount == null)
						details.InventoryPurchaseDetail.extra_amount = 1;
					extAmount = parseFloat((total*details.InventoryPurchaseDetail.extra_amount)/100);					
					}
					total = total+extAmount;
			}
			$("#grand_total").html(Math.round(total));
		
	});
}
function showItemDisplay(itemsDetails){
	 var number_of_field = 1;
	 var itemDetail ='';
	 var total =0;
	$.each(itemsDetails.InventoryPurchaseItemDetail, function() {
	 	 itemDetail = getItemDetail(this.item_id);
		 if($("#row'+number_of_field+'")){
				$("#row"+number_of_field).remove();
			}
		 var field = '';
		 field += '<tr id="row'+number_of_field+'"><td align="center" valign="middle" class="sr_number">'+number_of_field+'</td>';
		 field += '<td align="center" valign="middle"><input name="item_name[]" id="item_name'+number_of_field+'" type="text" class="textBoxExpnd"  tabindex="6" value="'+itemDetail.PharmacyItem.name+'" style="width:80%;" fieldNo="'+number_of_field+'"/></td>';
		 
		field += '<td align="center" valign="middle"><input name="pack[]" id="pack_item_name'+number_of_field+'" type="text" class="textBoxExpnd "  tabindex="7"  value="'+itemDetail.PharmacyItem.pack+'"  style="width:80%;" readonly="true"/></td>'; 
		 
		field += '<td align="center" valign="middle"><input name="batch_number[]" id="batch_number'+number_of_field+'" type="text" class="textBoxExpnd "  tabindex="8" value="'+this.batch_no+'"  style="width:80%;" readonly="true"/></td>';
		
		field += '<td valign="middle" style="text-align:center;"><input name="expiry_date[]" type="text" id="expiry_date'+number_of_field+'" class="textBoxExpnd" tabindex="9" value="'+this.expiry_date+'" style="width:65%;" readonly="true"/></td>'; 
		
		field += ' <td valign="middle" style="text-align:center;"><input name="qty[]" type="text" class="textBoxExpnd quantity validate[required,custom[number]]"  tabindex="10"  value="'+this.qty+'" id="qty'+number_of_field+'" style="width:70%;" fieldNo="'+number_of_field+'"/></td>';
		field += '<td valign="middle" style="text-align:center;"><input name="free[]" type="text" class="textBoxExpnd"  tabindex="11" value="" id="free'+number_of_field+'" value="'+this.free+'" style="width:80%;" readonly="true"/></td>';   
			  
		  	  field += '<td valign="middle" style="text-align:center;"><input name="tax[]" type="text" class="textBoxExpnd validate[required,custom[number]] tax"  tabindex="11" value="'+this.tax+'" id="tax'+number_of_field+'"  style="width:80%;" fieldNo="'+number_of_field+'" readonly="true"/></td>';
			  
		field += '<td valign="middle" style="text-align:center;"><input name="mrp[]" type="text" class="textBoxExpnd"  tabindex="12" value="'+itemDetail.PharmacyItemRate.mrp+'" id="mrp'+number_of_field+'" style="width:80%;" readonly="true"/></td>';
		
	   field += '<td valign="middle" style="text-align:center;"><input name="price[]" type="text" class="textBoxExpnd"  tabindex="13" value="'+itemDetail.PharmacyItemRate.sale_price+'" id="price'+number_of_field+'" style="width:80%;" readonly="true" /></td>';
	  		 var qty = parseFloat(this.qty);
			var salePrice = parseFloat(itemDetail.PharmacyItemRate.sale_price);
			var tax = ((qty*salePrice)*parseFloat(this.tax))/100;
			var Subtotal = salePrice*qty+tax;
	   field += ' <td valign="middle" style="text-align:center;"><input name="value[]" type="text" class="textBoxExpnd value" id="value'+number_of_field+'"  tabindex="14" value="'+Subtotal+'"  style="width:80%;" readonly="true"/></td> </tr>    ';
		   
		$('#initialRow').remove();
		$("#item-row").append(field);
		number_of_field = number_of_field+1;
		total = total+Subtotal;	 
	 });
	 var tax=0;
	 if(itemsDetails.InventoryPurchaseDetail.tax != null)
	 {
	 	tax = ((total*parseFloat(itemsDetails.InventoryPurchaseDetail.tax))/100);
	 }
	 $("#total_amount").html(Math.round(total+tax));
	 return Math.round(total);
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
				if(isNaN(qty)||qty.indexOf(".")<0 == false){
					alert("Invalid Quantity");
					currentField.val("");
					setTimeout(function() { currentField.focus(); }, 50);
					$("#submitButton").attr('disabled','disabled')
					return false;
				}else{
					qty = parseInt(qty);
					$("#submitButton").removeAttr('disabled');
				}			
				var price = parseFloat($("#price"+fieldno).val());			
				var tax = ((qty*price)*parseFloat(parseFloat($("#tax"+fieldno).val())))/100;
				var sub_total = (price*qty)+tax;
				$("#value"+fieldno).val(sub_total);
				var $form = $('#InventoryPurchaseReturnInventoryPurchaseReturnForm'),
   				$summands = $form.find('.value');
					var sum = 0;
					$summands.each(function ()
					{
						var value = Number($(this).val());
						if (!isNaN(value)) sum += value;
					});
			
				$("#total_amount_field").val(Math.round(sum));
				$("#total_amount").html(Math.round(sum));
			 }
			 
			 
			  var grandTotal = '';
			 
				var total_amount = parseFloat($("#total_amount").html());
				var extraAmount = parseFloat($("#extra_amount").val());
		
				
				if($("#payment_mode").html() == "credit"){
					if($("#discount_type_fix").is(':checked')=== true)
						{
							if(isNaN(extraAmount)){
								extraAmount =0;
							}
							grandTotal = total_amount+extraAmount;
						}else{
							if(isNaN(extraAmount)){
								extraAmount =0;
							}
							grandTotal = total_amount+((total_amount*extraAmount)/100);						
						}
				}else{
						if($("#discount_type_fix").is(':checked')=== true)
						{
							if(isNaN(extraAmount)){
								extraAmount =0;
							}
							grandTotal = total_amount-extraAmount;
						}else{
							if(isNaN(extraAmount)){
								extraAmount =0;
							}
							grandTotal = total_amount-((total_amount*extraAmount)/100);						
						}
				}
				if(isNaN(grandTotal)){
					grandTotal = 0;
				}
				 $("#total_amount_field").val(Math.round(grandTotal));
				 $("#grand_total").html(Math.round(grandTotal));
			 
			  });

			  
</script>
 </div> 