 <div class="inner_title">
   <h3>Sales Return</h3>
 </div>
 
 <script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#InventoryPharmacySalesReturnInventorySalesReturnForm").validationEngine();
	});
	
</script>
<style>
.formErrorContent{
width:43px !important;
}
</style>
<?php
 echo $this->Html->script('jquery.autocomplete_pharmacy');
  echo $this->Html->css('jquery.autocomplete.css');
echo $this->Html->script('jquery.fancybox-1.3.4');
 echo $this->Html->css('jquery.fancybox-1.3.4.css');
?>
<?php echo $this->Form->create('InventoryPharmacySalesReturn');?>
   <div class="clr ht5"></div>
                  <table width="100%" cellpadding="0" cellspacing="0" border="0">
                  	<tr>
               			
                     
                        <td width="10">&nbsp;</td>
                        <td width="150" class="tdLabel2">Party Code (Customer)</td>
                        <td width="200" class="tdLabel2"><input name="party_code" type="text" class="textBoxExpnd validate[required]" id="party_code" tabindex="3" value="" readonly="true" style="background-color:#808080"/></td>
                        <td width="10">&nbsp;</td>
                        <td width="150" class="tdLabel2">Party Name(Customer)</td>
                        <td width="200" class="tdLabel2"><input name="party_name" class="textBoxExpnd validate[required]" type="text" class="party_name" id="party_name" tabindex="4" value="" readonly="true" style="background-color:#808080"/></td>
                        <!--<td width="50">&nbsp;</td>
                        <td width="45" class="tdLabel2">Cash Credit</td>
                        <td width="80" class="tdLabel2"><input name="textfield6" type="text" class="textBoxExpnd validate[required]" id="textfield6" tabindex="5" value="" readonly='true'/></td>-->
                        <td width="10">&nbsp;</td>
                        <td width="50" class="tdLabel2">Bill No.</td>
                        <td width="120" class="tdLabel2"><input name="bill_no" type="text" class="textBoxExpnd validate[required]" id="bill_no" tabindex="5" value=""/></td>
						<input type="hidden" name="InventoryPharmacySalesReturn[pharmacy_sales_bill_id]" id ="pharmacy_sales_bill_id"/>
                        <td>&nbsp;</td>
                    </tr>
					<tr>
						  <td width="10">&nbsp;</td>
                        <td width="150" class="tdLabel2">Dr. Name: <span id="doctorNameLable"></span></td>
                        
					 </tr>
                  </table>
                  <div class="clr ht5"></div> 
                   <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm" id="billDetailTable">
                  	<tr>
               	  	  	  <th width="40" align="center" valign="top"  style="text-align:center;">Sr. No.</th>
                          <th width="100" align="center" valign="top"  style="text-align:center;">Product Code</th>
                          <th width="" align="center" valign="top"  style="text-align:center;">Product Name</th>
                          <th width="60" align="center" valign="top"  style="text-align:center;">Pack</th>
                          <th width="60" valign="top" style="text-align:center;">Batch No.</th>
						    <th width="60" valign="top" style="text-align:center;">Expiry Date</th>
                          <th width="60" valign="top" style="text-align:center;">Mrp</th>
                          <th width="60" valign="top" style="text-align:center;">Rate</th>
						    <th width="60" valign="top" style="text-align:center;">Tax</th>
                          <th width="50" valign="top" style="text-align:center;">Qty</th>
                          <th width="80" valign="top" style="text-align:center;">Value</th>
                     	</tr>
                     <tr id="initialRow">
					 	<td align="center" valign="middle" class="sr_number">1</td>
						<td align="center" valign="middle"><input type="text" fieldno="1" style="width:80%;" value="" tabindex="6" class="textBoxExpnd" id="item_code1" name="item_code[]"></td>
						<td align="center" valign="middle" witdh="140"><input type="text" readonly="true" fieldno="1" style="width:80%;" value="" tabindex="6" class="textBoxExpnd" id="item_name1" name="item_name[]" readonly="true" ></td>
						<td align="center" valign="middle"><input type="text" readonly="true" style="width:80%;" value="" tabindex="7" class="textBoxExpnd " id="pack_item_name1" name="pack[]"></td>
						<td align="center" valign="middle"><input type="text" readonly="true" style="width:80%;" value="" tabindex="8" class="textBoxExpnd" id="batch_number1" name="batch_number[]" readonly="true" ></td>
						<td align="center" valign="middle"><input type="text" readonly="true" style="width:80%;" value="" tabindex="9" class="textBoxExpnd" id="expiry_date1" name="expiry_date[]" readonly="true" ></td>			
						<td valign="middle" style="text-align:center;"><input type="text" readonly="true" style="width:80%;" id="mrp1" value="" tabindex="10" class="textBoxExpnd" name="mrp[]"></td>						
						<td valign="middle" style="text-align:center;"><input type="text" readonly="true" style="width:80%;" id="rate1" value="" tabindex="11" class="textBoxExpnd " name="rate[]"></td>
							<td valign="middle" style="text-align:center;"><input type="text" readonly="true" style="width:80%;" id="tax1" value="" tabindex="11" class="textBoxExpnd " name="tax[]"></td>
						 <td valign="middle" style="text-align:center;"><input type="text" fieldno="1" style="width:70%;" id="qty1" value="" tabindex="12" class="textBoxExpnd quantity validate[required,number]" name="qty[]" readonly="true" ></td>
						 <td valign="middle" style="text-align:center;"><input type="text" readonly="true" style="width:80%;" value="" tabindex="13" id="value1" class="textBoxExpnd value" name="value[]"></td> </tr>
                   </table>
                   <div class="clr ht5"></div>
                <table cellpadding="0" cellspacing="0" border="0">
                   		<tr class="tax"  style="display:none">
     
                         
                            <td width="35" class="tdLabel2">Tax</td>
                            <td width="80"><input name="tax" type="text" class="textBoxExpnd" id="tax" tabindex="35" value="" readonly='true'/></td>
							 <td width="660">&nbsp;</td>
							<td width="100" class="tdLabel2">Total Amount : </td>
							<td><span id="total_amount">0</span><input name="InventoryPharmacySalesReturn[total]"  id="total_amount_field" tabindex="35" value="0" type="hidden" /></td>
                        </tr>
                   </table>               
                   <div class="btns">
                              <input name="print" type="submit" value="Print" class="blueBtn" tabindex="36"/> <input name="submit" type="submit" value="Submit" class="blueBtn" tabindex="37" id="submitButton"/>
							     <?php 
   echo $this->Html->link(__('Back'), array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
   ?>
                  </div>   
	 <?php echo $this->Form->end();?>     
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
            };
            
        }
    };
    $.validationEngineLanguage.newLang();
})(jQuery);

$("#bill_no").live('focus',function()
			  { 
			  var t = $(this);
			 $(this).autocomplete(
		"<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_bill","bill_code","inventory" => true,"plugin"=>false)); ?>",
		{
			matchSubset:1,
			matchContains:1,
			cacheLength:10,
			onItemSelect:function (data1) {			
				selectItem(data1);
			},
			autoFill:true
		}
	);
			
});

function selectItem(li,selectedId) {
	if( li == null ) return alert("No match!");
		var billId = li.extra[0];
		loadDataFromRate(billId);
	
}	
/* load the data from supplier master */
function loadDataFromRate(billId){
	
	$.ajax({
		  type: "POST",
		  url: "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_sales_details","inventory" => true,"plugin"=>false)); ?>",
		  data: "billId="+billId,
		}).done(function( msg ) {
		 	var bill = jQuery.parseJSON(msg);
			$("#party_name").val(bill.Person.first_name);
			$("#party_code").val(bill.Person.patient_uid);
			$("#doctorNameLable").html(bill.DoctorProfile.doctor_name);
			$("#pharmacy_sales_bill_id").val(bill.PharmacySalesBill.id);
			$(".tax").show();
			$("#tax").val(bill.PharmacySalesBill.tax);
			loadBillItem(bill.PharmacySalesBillDetail);
		
	});
	}
	/* load the data from Bill PharmacySalesBillDetail */
function loadBillItem(billItem){
	 var number_of_field = 1;
	 var itemDetail ='';
	 var total =0;
	 $.each(billItem, function() {
	 		itemDetail = getItemDetail(this.item_id);
			if($("#row'+number_of_field+'")){
				$("#row"+number_of_field).remove();
			}
			  var field = '';
		   field += '<tr id="row'+number_of_field+'"><td class="sr_number">'+number_of_field+'</td>';
		     field += '<td align="center" valign="middle" witdh="75"><input name="item_code[]" id="item_code'+number_of_field+'" type="text" class="textBoxExpnd"  tabindex="6" value="'+itemDetail.PharmacyItem.item_code+'" style="width:60%;" fieldNo="'+number_of_field+'"/><input name="item_id[]" id="item_id'+number_of_field+'" type="hidden"  tabindex="6" value="'+itemDetail.PharmacyItem.id+'"/></td>';
			 
           field += '<td style="width:140px" ><input name="item_name[]" id="item_name'+number_of_field+'" type="text" class="textBoxExpnd"  tabindex="6" value="'+itemDetail.PharmacyItem.name+'" style="width:70%;" fieldNo="'+number_of_field+'" readonly="true"/><a href="view_item/'+itemDetail.PharmacyItem.id+'?popup=true" id="viewDetail'+number_of_field+'" class="fancy" ><img title="View Item" alt="View Item" src="/img/icons/view-icon.png"></a></td>';
		    $("#viewDetail"+number_of_field).fancybox({
				'width'				: '75%',
				'height'			: '75%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
		
		   field += '<td align="center" valign="middle" witdh="75"><input name="pack[]" id="pack_item_name'+number_of_field+'" type="text" class="textBoxExpnd "  tabindex="7" value="'+itemDetail.PharmacyItem.pack+'"  style="width:80%;" readonly="true"/></td>';
          
           
            field += '<td align="center" valign="middle"><input name="batch_number[]" id="batch_number'+number_of_field+'" type="text" class="textBoxExpnd"  tabindex="8" value="'+this.batch_number+'"  style="width:80%;" readonly="true"/></td>';
			
			   field += '<td align="center" valign="middle"><input name="expiry_date[]" id="expiry_date'+number_of_field+'" type="text" class="textBoxExpnd"  tabindex="9" value="'+this.expiry_date +'"  style="width:80%;" readonly="true"/></td>';
			   
		   field += '<td valign="middle" style="text-align:center;" witdh="75"><input name="mrp[]" type="text" class="textBoxExpnd"  tabindex="10" value="'+itemDetail.PharmacyItemRate.mrp+'" id="mrp'+number_of_field+'" style="width:50%;" readonly="true"/></td>';

           field += '<td valign="middle" style="text-align:center;" witdh="75"><input name="rate[]" type="text" class="textBoxExpnd "  tabindex="11" value="'+itemDetail.PharmacyItemRate.sale_price+'" id="rate'+number_of_field+'" style="width:50%;" readonly="true" /></td>';
		        field += '<td valign="middle" style="text-align:center;" witdh="75"><input name="saleTax[]" type="text" class="textBoxExpnd "  tabindex="11" value="'+this.tax+'" id="tax'+number_of_field+'" style="width:50%;" readonly="true" /></td>';
				
		   		 field += ' <td valign="middle" style="text-align:center;" witdh="75"><input name="qty[]" type="text" class="textBoxExpnd quantity validate[required,number]"  tabindex="12" value="'+this.qty+'" id="qty'+number_of_field+'" style="width:50%;" fieldNo="'+number_of_field+'"/><input type="hidden" id="preQty'+number_of_field+'" value="'+this.qty+'" /></td>';
			var qty = parseFloat(this.qty);
			var salePrice = parseFloat(itemDetail.PharmacyItemRate.sale_price);
			var tax = ((qty*salePrice)*parseFloat(this.tax))/100;
			var Subtotal = salePrice*qty+tax;
           field += ' <td style="text-align:center;"><input name="value[]" type="text" class="textBoxExpnd value" id="value'+number_of_field+'"  tabindex="13" value="'+Subtotal+'"  style="width:50%;" readonly="true"/></td> </tr>    ';
     	total = Subtotal;	 
		$('#initialRow').remove();

		$("#billDetailTable").append(field);
		
		 
			number_of_field = number_of_field+1;
	 });
	   var tax = parseFloat($("#tax").val());
	   if(isNaN(tax)){
	     tax = 0
	   }
	 var grandTotal = ((parseFloat(total)*tax)/100)+parseFloat(total);
	 $("#total_amount_field").val(Math.round(grandTotal));
	 $("#total_amount").html(Math.round(grandTotal));
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
		
			  if($(this).val()!=""){
			 	var currentField = $(this);
				var fieldno = currentField.attr('fieldNo') ;
				var qty = currentField.val();
				if(parseInt($("#preQty"+fieldno).val()) < parseInt(qty)){
					alert("Quantity must not be greater than "+$("#preQty"+fieldno).val());
					currentField.val("");
					setTimeout(function() { currentField.focus(); }, 50);
					$("#submitButton").attr('disabled','disabled')
					return false;
				}else{
					$("#submitButton").removeAttr('disabled');
				}
				if(isNaN(qty) || qty.indexOf(".")<0 == false){
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
					tax =0;
				}
				
                var price = parseFloat($("#rate"+fieldno).val());		
				var value = price*qty;		
				var sub_total = value+((value*tax)/100);
		
				$("#value"+fieldno).val(sub_total);
				var $form = $('#InventoryPharmacySalesReturnInventorySalesReturnForm'),
   				$summands = $form.find('.value');
			
					var sum = 0;
					$summands.each(function ()
					{
						var value = Number($(this).val());
						if (!isNaN(value)) sum += value;
					});
				
			 $("#total_amount_field").val(Math.round(sum+((sum*parseFloat($("#tax").val()))/100)));
	 $("#total_amount").html(Math.round(sum+((sum*parseFloat($("#tax").val()))/100)));
			 }
 });

</script>        