<div class="inner_title">
	<h3>
		<?php echo __('Purchase Order Item List', true); ?>
	</h3>
	<span>
		<?php
			echo $this->Html->link(__('Back'),array('controller'=>'PurchaseOrder','action'=>'purchase_order_list'), array('escape' => false,'class'=>'blueBtn'));
		?>
	</span>
	<div class="clr ht5"></div>
</div>
<div class="clr ht5"></div>
<?php  echo $this->Form->create('purchase_order',array('id'=>'purchaseOrder','onkeypress'=>"return event.keyCode != 13;"));?>
<?php echo $this->Form->hidden('purchase_order_id',array('value'=>$PurchaseOrder['PurchaseOrder']['id']));?>
<table width="" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="70" class="tdLabel2">PO ID: </td>
		<td width="180" class="tdLabel2">
			<?php echo $this->Form->input('purchase_order_number',array('type'=>'text','style'=>"width:100px;",'div'=>false,'label'=>false,'readonly'=>'readonly',
								'class'=>'textBoxExpnd','value'=>$PurchaseOrder['PurchaseOrder']['purchase_order_number']));?>
		<td width="20">&nbsp;</td>
		<td width="120" class="tdLabel2">Order Date: <font color="red">*</font></td>
		<td width="350" class="tdLabel2">
		<?php $date = date("d/m/Y H:i:s"); ?>
		<?php if($websiteConfig['instance'] == 'vadodara'){ 
			echo $this->Form->input('order_date',array('type'=>'text','class'=>'textBoxExpnd validate[required] order_date_no_back','autocomplete'=>'off','id'=>'order_date_no_back','div'=>false,'label'=>false,'value'=>$date));
		}else{
			echo $this->Form->input('order_date',array('type'=>'text','class'=>'textBoxExpnd validate[required] order_date','autocomplete'=>'off','id'=>'orderDate','div'=>false,'label'=>false,'value'=>$date));
		} ?>
		</td>
		
		<td width="20">&nbsp;</td>
		<td width="120" class="tdLabel2">Order For: <font color="red">*</font></td>
		<td width="350" class="tdLabel2">
			<?php echo $this->Form->input('order_for',array('type'=>'select','options'=>$storeLocation,'selected'=>$PurchaseOrder['PurchaseOrder']['order_for'],'class'=>'textBoxExpnd validate[required]','autocomplete'=>'off','div'=>false,'label'=>false,'id'=>'orderFor'));
			?> 
		</td>
		
		<td width="20">&nbsp;</td>
		<td width="80" class="tdLabel2"><!-- Contract:  --></td>
		<td width="350" class="tdLabel2">
			<?php //echo $this->Form->input('contract_id',array('type'=>'select','options'=>array($PurchaseOrder['Contract']['name']),'value'=>$PurchaseOrder['PurchaseOrder']['contract_id'],'class'=>'textBoxExpnd','div'=>false,'label'=>false,'id'=>'contract_name'));
					//echo $this->Form->hidden('contract_id',array('id'=>'contract_id'));
			?> 
		</td>
		
		
		<td width="20">&nbsp;</td>
		<td width="80" class="tdLabel2">Supplier: <font color="red">*</font></td>
		<td width="350" class="tdLabel2">
			<?php echo $this->Form->input('vendor',array('type'=>'text','value'=>$PurchaseOrder['InventorySupplier']['name'],'class'=>'textBoxExpnd validate[required]','div'=>false,'label'=>false,'id'=>'supplier_name','autocomplete'=>'off'));
					echo $this->Form->hidden('supplier_id',array('id'=>'supplier_id','value'=>$PurchaseOrder['InventorySupplier']['id']));
			?> 
		</td>
	
	</tr>
</table>

<div class="clr ht5"></div>

<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm" id="item-row">
	<thead>	
		<tr>
			<!-- <th width="40" align="center" valign="top" style="text-align: center;">Sr.No.</th> -->
			<th width="150" align="center" valign="top" style="text-align: center;">Item Name</th>
			<th width="120" align="center" valign="top" style="text-align: center;">Manufacturer</th>
			<th width="60" valign="top" style="text-align: center;">Pack</th>
			<th width="80" align="center" valign="top" style="text-align: center;">Batch Number</th>
			<th width="60" valign="top" style="text-align: center;">MRP</th>
			<th width="60" valign="top" style="text-align: center;">Purchase Price</th>
			<?php if($websiteConfig['instance'] == 'kanpur'){ ?> 
			<th width="60" valign="top" style="text-align: center;">Vat of Class</th>
			<?php } else { ?>
			<th width="60" valign="top" style="text-align: center;">Tax</th>
			<?php }?>
			<th width="60" valign="top" style="text-align: center;">In Stock</th>
			<th width="60" valign="top" style="text-align: center;">Ordered Quantity</th>
			<th width="60" valign="top" style="text-align: center;">Vat</th>
			<th width="60" valign="top" style="text-align: center;">Amount</th>
			<th width="100" valign="top" style="text-align: center;">Action</th>
		</tr>
	</thead>
	
	<tbody>
	<?php $count = 1; $netTotal = 0; $netVat = 0;
		foreach($items as $key => $item) { $count++;?>
	<tr id="row<?php echo $count;?>">
		<!-- <td align="center" valign="middle" class="sr_number"><?php echo $count;?></td> -->
		
		<td valign="middle">
			<?php
				 echo $this->Form->input('',array('type'=>'text','value'=>$item['Product']['name'],'name'=>"data[purchase_order_item][$key][product_name]",'fieldNo'=>$count,'autocomplete'=>'off','id'=>'item-name_'.$count,'class'=>'textBoxExpnd validate[required] product_name','style'=>"width:100%",'div'=>false,'label'=>false));
				 echo $this->Form->hidden('',array('id'=>'productid_'.$count,'class'=>'product_id','value'=>$item['PurchaseOrderItem']['product_id'],'name'=>"data[purchase_order_item][$key][product_id]"));
				 echo $this->Form->hidden('',array('id'=>'ItisContract_'.$count,'class'=>'ItisContract','value'=>$item['PurchaseOrderItem']['is_contract'],'name'=>"data[purchase_order_item][$key][is_contract]"));
			?>
		</td>
		
		<td align="center" valign="middle">
			<?php
				 echo $this->Form->input('manufacturer',array('type'=>'text','value'=>$item['ManufacturerCompany']['name'],'name'=>"data[purchase_order_item][$key][manufacturer]",'fieldNo'=>$count,'autocomplete'=>'off','id'=>'manufacturer_'.$count,'class'=>'textBoxExpnd manufacturer','style'=>"width:100%",'div'=>false,'label'=>false,'readonly'=>true));
			?>
		</td>
		
		<td align="center" valign="middle">
			<?php
				 echo $this->Form->input('pack',array('type'=>'text','value'=>$item['Product']['pack'],'name'=>"data[purchase_order_item][$key][pack]",'fieldNo'=>$count,'autocomplete'=>'off','id'=>'pack_'.$count,'class'=>'textBoxExpnd pack','style'=>"width:100%",'div'=>false,'label'=>false,'readonly'=>true));
			?>
		</td>
		
		<td valign="middle" style="text-align: center;">
			<?php
				 echo $this->Form->input('batch_number',array('type'=>'text','value'=>$item['PurchaseOrderItem']['batch_number'],'name'=>"data[purchase_order_item][$key][batch_number]",'fieldNo'=>$count,'autocomplete'=>'off','id'=>'batch-number_'.$count,'class'=>'textBoxExpnd batch_number','style'=>"width:100%",'div'=>false,'label'=>false,'readonly'=>true));
			?>
		</td>
		
		
		<td valign="middle" style="text-align: center;">
			<?php
				 echo $this->Form->input('mrp',array('type'=>'text','value'=>$item['PurchaseOrderItem']['mrp'],'name'=>"data[purchase_order_item][$key][mrp]",'fieldNo'=>$count,'autocomplete'=>'off','id'=>'mrp_'.$count,'class'=>'textBoxExpnd mrp','style'=>"width:100%",'div'=>false,'label'=>false,'readonly'=>false));
			?>
		</td>
		
		<td valign="middle" style="text-align: center;">
			<?php
				 echo $this->Form->input('purchase_price',array('type'=>'text','value'=>$item['PurchaseOrderItem']['purchase_price'],'name'=>"data[purchase_order_item][$key][purchase_price]",'fieldNo'=>$count,'autocomplete'=>'off','id'=>'purchasePrice_'.$count,'class'=>'textBoxExpnd purchasePrice','style'=>"width:100%",'div'=>false,'label'=>false,'readonly'=>false));
			?>
		</td>
		
		<td valign="middle" style="text-align: center;">
			<?php
				 echo $this->Form->input('tax',array('type'=>'text','value'=>$item['PurchaseOrderItem']['tax'],'name'=>"data[purchase_order_item][$key][tax]",'fieldNo'=>$count,'autocomplete'=>'off','id'=>'tax_'.$count,'class'=>'textBoxExpnd tax','style'=>"width:100%",'div'=>false,'label'=>false,'readonly'=>false));
			?>
		</td>
		
		<td valign="middle" style="text-align: center;">
			<?php
				 echo $this->Form->input('hav_quantity',array('type'=>'text','value'=>$item['Product']['quantity'],'name'=>"data[purchase_order_item][$key][hav_quantity]",'fieldNo'=>$count,'autocomplete'=>'off','id'=>'havquantity_'.$count,'class'=>'textBoxExpnd havquantity','style'=>"width:100%",'div'=>false,'label'=>false,'readonly'=>'readonly'));
			?>
		</td>
		
		<td valign="middle" style="text-align: center;">
			<?php
				 echo $this->Form->input('quantity_order',array('type'=>'text','value'=>$item['PurchaseOrderItem']['quantity_order'],'name'=>"data[purchase_order_item][$key][quantity_order]",'fieldNo'=>$count,'autocomplete'=>'off','id'=>'quantity_'.$count,'class'=>'textBoxExpnd quantity validate[required]','style'=>"width:100%",'div'=>false,'label'=>false));
			?>
		</td>
		
		<td valign="middle" style="text-align: center;">
			<?php
				$vat = ($item['PurchaseOrderItem']['quantity_order']*$item['PurchaseOrderItem']['purchase_price']*$item['PurchaseOrderItem']['tax'])/100;
				$netVat += $vat;
				 echo $this->Form->input('vat',array('type'=>'text','value'=>$vat,'name'=>"data[purchase_order_item][$key][vat]",'fieldNo'=>$count,'autocomplete'=>'off','id'=>'vat_'.$count,'class'=>'textBoxExpnd vat validate[required]','style'=>"width:100%",'div'=>false,'label'=>false));
			?>
		</td>
		
		<td valign="middle" style="text-align: center;">
			<?php
				$amount = $item['PurchaseOrderItem']['amount'];
				$netTotal += $amount;
				 echo $this->Form->input('amount',array('type'=>'text','value'=>$amount,'name'=>"data[purchase_order_item][$key][amount]",'fieldNo'=>$count,'autocomplete'=>'off','id'=>'amount_'.$count,'readonly'=>'readonly','class'=>'textBoxExpnd amount','style'=>"width:100%",'div'=>false,'label'=>false));
			?>
		</td>
		
		<td>
			<table>
				<tr>
					<td id="isContract_1" style="display:none;">
						<?php echo $this->Html->image('tick.png', array('alt' => 'contract','title'=>'Contract'));?>
					</td>
					
					<td align="right" valign="middle" style="text-align: center;">
						<?php //echo $this->Html->link($this->Html->image('/img/icons/cross.png',array('alt'=>'Delete','title'=>'Delete Row')),array('#'))?>
						<a href="javascript:void(0);" id="delete-row" onclick="deletRow(<?php echo $count;?>);">
						<?php echo $this->Html->image("icons/cross.png",array("alt"=>"Remove Row", "title"=>"Remove Item")); ?> 
						</a>
					</td>			
				</tr>
			</table>
		</td>	
	</tr>
	<?php } ?>
	<tr id="ampoutRow">
		<td colspan="10" valign="middle" align="right">
			<table>
				<tr>
					<td>
						<?php echo __('Total Amount');?>
							<?php echo $this->Form->hidden('total_amount',array('id'=>'total_amount','value'=>$netTotal)); ?>
					</td>
				</tr>
				
				<tr>
					<td>
						<?php echo __('Total Vat');?>
						<?php echo $this->Form->hidden('total_vat',array('id'=>'total_vat','value'=>$netVat)); ?>
					</td>
				</tr>
				
				<tr>
					<td>
						<?php echo __('Net Amount');?>
						<?php echo $this->Form->hidden('net_amount',array('id'=>'net_amount','value'=>$netTotal+$netVat)); ?>
					</td>					
				</tr>
			</table>
		</td>
		
		<td>
			<table>
				<tr>
					<td valign="middle" style="text-align: right;" class="total" id="total">
					<?php echo $netTotal; ?>
					</td>
				</tr>
				
				<tr>
					<td valign="middle" style="text-align: right;" class="Tvat" id="Tvat">
					<?php echo $netVat;?>
					</td>
				</tr>
				
				<tr>
					<td valign="middle" style="text-align: right;" class="Tnet" id="Tnet">
					<?php echo $netTotal+$netVat;?>
					</td>
				</tr>
			</table>	
		</td>
		<td>&nbsp;</td>
	</tr>
	<?php echo $this->Form->hidden('no',array('id'=>'no_of_fields','value'=>$count));?>
	</tbody>
</table>

<div class="btns">
<input name="submit" type="submit" value="Submit" class="blueBtn submitt" id="submitButton" />
	<?php
		//echo $this->Form->submit(__('Update'),array('escape' => false,'class'=>'blueBtn','id'=>'submitButton'))
	?>
</div>
<?php echo $this->Form->end();?>
<div align="left">
	<input name="" type="button" value="Add More" class="blueBtn Add_more" tabindex="36" onclick="addFields()" style="margin-top:10px;" />
	<!-- <input name="" type="button" value="Remove" id="remove-btn" class="blueBtn" tabindex="36" onclick="removeRow()" style="display: none" /> -->
</div>
<script>
var sum = 0;
var vat = 0;
var net = 0;

$('#supplier_name').autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","InventorySupplier","name",'null','no','null',"admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
			 var supplier_id = ui.item.id;
			 $('#supplier_id').val(ui.item.id);
		 },
		 messages: {
	        noResults: '',
	        results: function() {}
		 }
	});



$(document).on('focus',".product_name",function(){
	
	var contract = ($('#contract_name').val()) ? $('#contract_name').val() : null ;
	var supplier_id = ($('#supplier_id').val()) ? $('#supplier_id').val() : null ;
	var orderFor = ($('#orderFor').val()) ? $('#orderFor').val() : null ;
	$('.product_name').autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "PurchaseOrders", "action" => "autocompleteForPO","admin" => false,"plugin"=>false)); ?>"+"/"+supplier_id+"/"+contract+"/"+orderFor,
		 minLength: 1,
		 select: function( event, ui ) {
			console.log(ui);
			var idd = $(this).attr('id');
            splitted = idd.split("_");
            $('#productid_'+splitted[1]).val(ui.item.id);
            $('#manufacturer_'+splitted[1]).val(ui.item.manufacturer);
            $('#pack_'+splitted[1]).val(ui.item.pack);
            $('#havquantity_'+splitted[1]).val(ui.item.quantity);
            $('#batch-number_'+splitted[1]).val(ui.item.batch_number);
            $('#mrp_'+splitted[1]).val(ui.item.mrp);
            $('#purchasePrice_'+splitted[1]).val(ui.item.purchase_price);
            $('#tax_'+splitted[1]).val(ui.item.tax);
            var is_contract = ui.item.is_contract;
            if(is_contract == '1')
            {
            	$('#isContract_'+splitted[1]).show();
            	$('#ItisContract_'+splitted[1]).val(1);
            }
            else
            {
            	$('#isContract_'+splitted[1]).hide();
            	$('#ItisContract_'+splitted[1]).val(0);
            }
		 },
		 messages: {
		        noResults: '',
		        results: function() {
			        }
		 }		
 	});
});





function addFields()
{
	var number_of_field = parseInt($("#no_of_fields").val())+1;
	var amoutRow = $("#ampoutRow");
    var field = '';
    field += '<tr id="row'+number_of_field+'">';
	//field += '<tr id="row'+number_of_field+'"><td align="center" valign="middle" class="sr_number">'+number_of_field+'</td>';
    field += '<td valign="middle"  width="185"><input name="data[purchase_order_item]['+number_of_field+'][product_name]" id="item-name_'+number_of_field+'" type="text" class="textBoxExpnd validate[required] product_name" style="width:100%;" fieldNo="'+number_of_field+'" /><input type="hidden" name="data[purchase_order_item]['+number_of_field+'][product_id]" class="product_id" id="productid_'+number_of_field+'"/> <input type="hidden" name="data[purchase_order_item]['+number_of_field+'][is_contract]" class="ItisContract" id="ItisContract_'+number_of_field+'" value="0"/> </td>';
	field += '<td align="center" valign="middle"><input name="data[purchase_order_item]['+number_of_field+'][manufacturer]" id="manufacturer_'+number_of_field+'" type="text" class="textBoxExpnd" style="width:100%;" readonly="readonly"/></td>';
	field += '<td align="center" valign="middle"><input name="data[purchase_order_item]['+number_of_field+'][pack]" id="pack_'+number_of_field+'" type="text" class="textBoxExpnd" style="width:100%;" readonly="readonly" autocomplete="off"/></td>';
    field += '<td align="center" valign="middle"><input name="data[purchase_order_item]['+number_of_field+'][batch_number]" id="batch-number_'+number_of_field+'" type="text" class="textBoxExpnd batch_number" style="width:100%;" autocomplete="off" readonly="readonly" fieldNo="'+number_of_field+'"/></td>';
    field += '<td align="center" valign="middle"><input name="data[purchase_order_item]['+number_of_field+'][mrp]" id="mrp_'+number_of_field+'" type="text" class="textBoxExpnd" style="width:100%;"  autocomplete="off"/></td>';
    field += '<td valign="middle" style="text-align:center;"><input name="data[purchase_order_item]['+number_of_field+'][purchase_price]" type="text" class="textBoxExpnd purchasePrice" id="purchasePrice_'+number_of_field+'" style="width:100%;" autocomplete="off"/></td>';
    field += '<td valign="middle" style="text-align:center;"><input name="data[purchase_order_item]['+number_of_field+'][tax]" type="text" class="textBoxExpnd tax" id="tax_'+number_of_field+'" style="width:100%;" autocomplete="off" /></td>';
    field += '<td valign="middle" style="text-align:center;"><input name="data[purchase_order_item]['+number_of_field+'][havquantity]" readonly="readonly"  type="text" class="textBoxExpnd havquantity" autocomplete="off" id="havquantity_'+number_of_field+'" style="width:100%;" fieldNo="'+number_of_field+'"/></td>';
    field += '<td valign="middle" style="text-align:center;"><input name="data[purchase_order_item]['+number_of_field+'][quantity_order]" type="text" class="textBoxExpnd quantity validate[required]" id="quantity_'+number_of_field+'" autocomplete="off" style="width:100%;" fieldNo="'+number_of_field+'"/></td>';
    field += '<td valign="middle" style="text-align:center;"><input name="data[purchase_order_item]['+number_of_field+'][vat]" type="text" class="textBoxExpnd vat" fieldNo="'+number_of_field+'" value="" id="vat_'+number_of_field+'" style="width:100%;" readonly="readonly" autocomplete="off"/></td> ';
    field += '<td valign="middle" style="text-align:center;"><input name="data[purchase_order_item]['+number_of_field+'][amount]" type="text" class="textBoxExpnd amount" fieldNo="'+number_of_field+'" value" id="amount_'+number_of_field+'" style="width:100%;" readonly="readonly" autocomplete="off"/></td> ';
	field += '<td valign="middle" style="text-align:center;"> <table> <tr> <td id="isContract_'+number_of_field+'" style="display:none;"> <img title="Contract" alt="Contract" src="/DrmHope/img/tick.png" /> </td> <td> <a href="javascript:void(0);" id="delete-row" onclick="deletRow('+number_of_field+');"><?php echo $this->Html->image("icons/cross.png",array("alt"=>"Remove Row", "title"=>"Remove Item")); ?></a> </td> </tr> </table> </td> ';
	field += '</tr>';
	$("#no_of_fields").val(number_of_field);
	$("#item-row").append(field);
	$("#item-row").append(amoutRow);
	if (parseInt($("#no_of_fields").val()) == 1){
		$("#remove-btn").css("display","none");
	}else{
	$("#remove-btn").css("display","inline");
	}
	$("#item-name_"+number_of_field).focus();
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

$( "#orderDate" ).datepicker({
	showOn: "both",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	yearRange: '1950',			 
	dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',	
});

$( "#order_date_no_back" ).datepicker({
	showOn: "button",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	yearRange: '1950',
	minDate:  new Date(),
	dateFormat: '<?php echo $this->General->GeneralDate("HH:II:SS");?>',		
});


function displayQty(id)
{
      var idd = $(id).attr('id');
	  splitted = idd.split("_");
	  var purchasePrice = parseFloat(($("#purchasePrice_"+splitted[1]).val()!='')?$("#purchasePrice_"+splitted[1]).val():0);
	  var tax = parseFloat(($("#tax_"+splitted[1]).val()!='')?$("#tax_"+splitted[1]).val():0);
	  var quantity = parseFloat(($("#quantity_"+splitted[1]).val()!='')?$("#quantity_"+splitted[1]).val():0);

	  var vatTotal = (purchasePrice*tax)/100;

	  total = quantity * purchasePrice;		//total amount

	  var totalVatForQuantity = quantity * vatTotal;		//for particular product VAT			

	  $("#amount_"+splitted[1]).val(total.toFixed(2));
	  $("#vat_"+splitted[1]).val(totalVatForQuantity.toFixed(2));
	  
	  $('.amount').each(function() { 
		    if(this.value!== undefined  && this.value != ''  ){
			    var fieldNo = $(this).attr('fieldno'); 
	        	sum += parseFloat(this.value);	       
			    vat += parseFloat($("#vat_"+fieldNo).val());	  
	        } 		        				        
	    });
	    
	  $("#total").html(sum.toFixed(2));			//display total
      $("#total_amount").val(sum.toFixed(2));	//hold total
      $("#Tvat").html(vat.toFixed(2));			//display total vat
      $("#total_vat").val(vat.toFixed(2));		//hold total vat

      Tnet = sum + vat;
      $("#Tnet").html(Math.round(Tnet.toFixed(2)));			//display total net amount
      $("#total_net").val(Tnet.toFixed(2));		//hold total net amount
      
		sum = 0;
		vat = 0;
}


$(".quantity, .tax, .purchasePrice").keyup(function(){
	displayQty(this);
});

$('.Add_more').on('click',function(){ 
	$(".quantity, .tax, .purchasePrice").keyup(function(){
		displayQty(this);
	});
});


function deletRow(id){
	var number_of_field = parseInt($("#no_of_fields").val());
	var count = 0;
	$(".product_name").each(function(){
		count++;
	});
	if(count == 1){
		alert("Single row can't delete.");
		return false;
	}
	$("#row"+id).remove();
	//displayQty(this);
	$('.amount').each(function() { 
	    if(this.value!== undefined  && this.value != ''  ){
		    var fieldNo = $(this).attr('fieldno'); 
        	sum += parseFloat(this.value);	       
		    vat += parseFloat($("#vat_"+fieldNo).val());	  
        } 		        				        
    });
    
  $("#total").html(sum.toFixed(2));			//display total
  $("#total_amount").val(sum.toFixed(2));	//hold total
  $("#Tvat").html(vat.toFixed(2));			//display total vat
  $("#total_vat").val(vat.toFixed(2));		//hold total vat

  Tnet = sum + vat;
  $("#Tnet").html(Math.round(Tnet.toFixed(2)));			//display total net amount
  $("#total_net").val(Tnet.toFixed(2));		//hold total net amount
  
	sum = 0;
	vat = 0;
		
	}

$("#submitButton").click(function(){  
	var valid = jQuery("#purchaseOrder").validationEngine('validate');
	if(valid){
		
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

</script>


