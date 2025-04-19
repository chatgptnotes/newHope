<div class="inner_title">
	<h3>
		<?php echo __('Edit Goods Received Notes', true); ?>
	</h3>
	<span>
		<?php
			echo $this->Html->link(__('Back to list'),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn Back-to-List','id'=>'Back-to-List'));
		?>
	</span>
	<div class="clr ht5"></div>
</div>
<div class="clr ht5"></div>
<?php echo $this->Form->create('',array('id'=>'Purchase-receipt','url'=>array('action'=>'editGrn',$po_details['PurchaseOrder']['id'])));?>
<?php if(!empty($po_details)) { ?>
<table cellpadding="0" cellspacing="0" border="0">
	<tr>
	<td>
	<table>
		<tr>
		<td class="tdLabel2"><font style="font-weight:bold;">Purchase Order Number: </font> 
			<?php echo $po_details['PurchaseOrder']['purchase_order_number']; ?>
		</td>
		
		<td width="10">&nbsp;</td>
		<td class="tdLabel2"><font style="font-weight:bold;">Purchase Order For: </font> 
			<?php echo ($po_details['StoreLocation']['name']);?>
		</td>
	
		
		<td width="10">&nbsp;</td>
		<td class="tdLabel2"><font style="font-weight:bold;"><!--Type: --></font>
			<?php echo $po_details['PurchaseOrder']['type']; ?>
		</td>
		
		<td width="10">&nbsp;</td>
		<td class="tdLabel2"><font style="font-weight:bold;">Order Created Date: </font>
			<?php 
				echo $this->DateFormat->formatDate2Local($po_details['PurchaseOrder']['create_time'],Configure::read('date_format'),true); ?>
		</td>
		</tr>
	</table>
	</td>	
	</tr>
</table>
<?php }  ?>

<div class="clr ht5"></div>

<!-- inventory supplier hidden field maintain for accounting  by amit-->
<?php 
	echo $this->Form->hidden('',array('name'=>"data[PurchaseOrder][id]",'value'=>$po_details['PurchaseOrder']['id']));
	echo $this->Form->hidden('',array('name'=>"purchase_order_no",'value'=>$po_details['PurchaseOrder']['purchase_order_number']));
	echo $this->Form->hidden('',array('name'=>"order_for",'value'=>$po_details['PurchaseOrder']['order_for']));
?>
<table>
	<tr> 
		<td>Party Invoice Number: <font color="red">*</font></td>
		<td><?php echo $this->Form->input('',array('name'=>"data[PurchaseOrder][party_invoice_number]",'type'=>'text','autocomplete'=>false,'placeholder'=>'Party Invoice Number','label'=>false,'class'=>'textBoxExpnd validate[required]','value'=>$po_details['PurchaseOrder']['party_invoice_number'])); ?></td>
		
		<td>Good Received Date:</td>
		<td><?php  
		if(!empty($items[0]['PurchaseOrderItem']['received_date'])){
			 $date = $this->DateFormat->formatDate2local($items[0]['PurchaseOrderItem']['received_date'],Configure::read('date_format'),true);
		}else{
			$date = date("d/m/Y H:i:s"); 
		}?>
		<?php   
			echo $this->Form->input('',array('name'=>"data[PurchaseOrder][received_date]",'type'=>'text','id'=>'received_date','label'=>false,'class'=>'textBoxExpnd validate[required]','value'=>$date));
		?> 
		</td>
		<td width="10">&nbsp;</td>
		<td>Supplier:</td>
		<td><?php echo $this->Form->input('PurchaseOrder.supplier_name',array('value'=>$po_details['InventorySupplier']['name'],'id'=>'suppliername','div'=>false,'label'=>false,'class'=>'textBoxExpnd validate[required]')); 
				echo $this->Form->hidden('PurchaseOrder.supplier_id',array('value'=>$po_details['InventorySupplier']['id'],'id'=>'supplierid')); ?> </td>
		
	</tr>
</table>
<div class="clr ht5"></div>
<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm" id="item-row">
	<thead>
		<tr>
			<th width="10" align="center" valign="top" style="text-align: center;">#</th>
			<th width="100" align="center" valign="top" style="text-align: center;">Product Name</th>
			<th width="100" align="center" valign="top" style="text-align: center;">Manufacturer</th>
			<th width="20" valign="top" style="text-align: center;">Pack</th>
			<th width="40" align="center" valign="top" style="text-align: center;">Batch No.<font color="red">*</font></th>
			<th width="100" valign="top" style="text-align: center;">Expiry Date<font color="red">*</font></th>
			<th width="40" valign="top" style="text-align: center;">MRP<font color="red">*</font></th>
			<th width="40" valign="top" style="text-align: center;">Pur. Price<font color="red">*</font></th>
			<th width="40" valign="top" style="text-align: center;">Sale Price<font color="red">*</font></th>
			<!--<th width="20" valign="top" style="text-align: center;">Qty. Ord</th>-->
			<th width="20" valign="top" style="text-align: center;">Qty. Rec</th>
			<th width="10" valign="top" style="text-align: center;">Free</th>
			<th width="60" valign="top" style="text-align: center;">Amount</th>
		</tr>
	</thead>
	
	<tbody>
		<?php $count=0; $totalAmt = 0; $totalVat = 0; foreach($items as $key=>$item) { $count++;?>
		<tr>
			<td align="center" valign="middle" class="sr_number"><?php echo $count;?></td>
			
			<td valign="middle">
				<?php
					echo $item['Product']['name']; 
					echo $this->Form->hidden('',array('name'=>"data[purchase_order_item][$key][product_id]",'value'=>$item['Product']['id']));
					echo $this->Form->hidden('',array('name'=>"data[purchase_order_item][$key][id]",'value'=>$item['PurchaseOrderItem']['id']));
					echo $this->Form->hidden('',array('name'=>"data[purchase_order_item][$key][name]",'value'=>$item['Product']['name']));
					echo $this->Form->hidden('',array('name'=>"data[purchase_order_item][$key][item_code]",'value'=>$item['Product']['product_code']));
					echo $this->Form->hidden('',array('name'=>"data[purchase_order_item][$key][supplier_id]",'value'=>$item['Product']['supplier_id']));
					echo $this->Form->hidden('',array('name'=>"data[purchase_order_item][$key][cost_price]",'value'=>$item['Product']['cost_price']));
					echo $this->Form->hidden('',array('name'=>"data[purchase_order_item][$key][cst]",'value'=>$item['Product']['cst']));
					echo $this->Form->hidden('',array('name'=>"data[purchase_order_item][$key][tax]",'value'=>$item['PurchaseOrderItem']['tax']));
					$qty = ($item['PurchaseOrderItem']['quantity_received']);
				?>
			</td>
			
			<td valign="middle">
				<?php
					echo $item['ManufacturerCompany']['name'];
				?>
			</td>
			
			<td align="center" valign="middle">
				<?php
					echo $item['Product']['pack'];
					echo $this->Form->hidden('pack',array('name'=>"data[purchase_order_item][$key][pack]",'value'=>$item['Product']['pack']));
				?>
			</td>
			
			<td valign="middle" style="text-align: center;">
				<?php
					echo $item['PurchaseOrderItem']['batch_number'];
					echo $this->Form->hidden('batch_number',array('name'=>"data[purchase_order_item][$key][batch_number]",'class'=>'textBoxExpnd validate[required] batch_number','value'=>$item['PurchaseOrderItem']['batch_number'],'id'=>'batch-number_'.$key));
				?>
			</td>
			
			<td valign="middle" style="text-align: center;">
				<?php
					echo $date = $this->DateFormat->formatDate2local($item['PurchaseOrderItem']['expiry_date'],Configure::read('date_format'));
					//echo $this->Form->input('expiry_date',array('type'=>'text','id'=>'expiryDate_'.$key,'name'=>"data[purchase_order_item][$key][expiry_date]",'value'=>$date,'class'=>'textBoxExpnd validate[required] expiry_date','div'=>false,'autocomplete'=>'off','label'=>false,'style'=>"width:80%"));
				?>
			</td>
			
			<td valign="middle" style="text-align: center;">
				<?php 
					$mrp = $item['PurchaseOrderItem']['mrp'];
					echo $this->Form->input('mrp',array('type'=>'text','name'=>"data[purchase_order_item][$key][mrp]",'value'=>$mrp,'id'=>'mrp_'.$key,'class'=>'textBoxExpnd validate[required]','div'=>false,'label'=>false,'style'=>"width:100%",'autocomplete'=>'off'));
				?>	
			</td>
			
			<td valign="middle" style="text-align: center;" >
				<?php
					$purchase_price = $item['PurchaseOrderItem']['purchase_price'];
					echo $this->Form->input('purchase_price',array('type'=>'text','name'=>"data[purchase_order_item][$key][purchase_price]",'value'=>$purchase_price,'id'=>'purchase-price_'.$key,'class'=>'textBoxExpnd validate[required] purchasePrice','id'=>'purchasePrice_'.$key,'autocomplete'=>'off','div'=>false,'label'=>false,'style'=>"width:100%")); 
				?>
			</td>
			
			<td valign="middle" style="text-align: center;" >
				<?php 
					$selling_price = $item['PurchaseOrderItem']['selling_price'];
					echo $this->Form->input('selling_price',array('type'=>'text','name'=>"data[purchase_order_item][$key][selling_price]",'value'=>$selling_price,'id'=>'selling-price_'.$key,'class'=>'textBoxExpnd validate[required]','div'=>false,'label'=>false,'autocomplete'=>'off','style'=>"width:100%"));
				?>
			</td>
			
			<td valign="middle" style="text-align: center;">
				<?php
					echo $qty;
					echo $this->Form->hidden('quantity_received',array('name'=>"data[purchase_order_item][$key][quantity_received]",'value'=>$qty,'id'=>'qtyReceived_'.$key));
				?>
			</td>
			
			<td valign="middle" style="text-align: center;">
				<?php
					echo !empty($item['PurchaseOrderItem']['free'])?$item['PurchaseOrderItem']['free']:"-";
				?>
			</td>
			
			<td valign="middle" style="text-align: center;">
				<?php
					$amount = $purchase_price * $qty; 
					$totalAmt += $amount;
					 echo $this->Form->input('amount',array('type'=>'text','name'=>"data[purchase_order_item][$key][amount]",'value'=>$amount,'autocomplete'=>'off','id'=>'amount_'.$key,'class'=>'textBoxExpnd amount','readonly'=>'readonly','autocomplete'=>'off','style'=>"width:100%",'div'=>false,'label'=>false));
				?>
			</td>
			
		</tr>
		<?php }?>
		<?php if($this->Session->read('website.instance') == 'vadodara') $colspan = 11; else $colspan = 11; ?>
		<tr>
			<td colspan="<?php echo $colspan; ?>" align="right">
				<table>
					<tr><td>Total:</td></tr>
					<?php if(strtolower($this->Session->read('website.instance')) != "vadodara"){ ?>
					<tr><td>Total Tax:</td></tr>
					<?php if(strtolower($this->Session->read('website.instance')) == "hope"){ ?><tr><td>Discount:</td></tr> <?php } ?>
					<tr><td>Net Amount:</td></tr>
					<?php } ?>
				</table>
			</td>
			<td>
				<table align="right">
					<tr>
						<td style="text-align:right;">
							<?php echo $this->Form->hidden('net_amount',array('name'=>"net_amount",'value'=>($totalAmt),'id'=>'totalNet')); ?>
							<span id="total"><?php echo number_format(round($totalAmt),2); ?></span>
						</td>
					</tr>
					<?php if(strtolower($this->Session->read('website.instance')) != "vadodara"){ ?>
					<tr>
						<td style="text-align:right;">
						<span id="displayTotalVat">
							<?php echo number_format(round($totalVat),2);?>
						</span>
						</td>
					</tr>
					<?php if(strtolower($this->Session->read('website.instance')) == "hope"){ ?><tr>
						<td style="text-align:right;">
							<?php echo $this->Form->input('discount',array('name'=>"discount",'value'=>'0','id'=>'totalDiscount','div'=>false,'label'=>false,'style'=>"width:40px")); ?>
						</td>
					</tr>
					<?php }?>
					<tr>
						<td>
							<span id="Tnet"><?php echo number_format(round($totalAmt+$totalVat),2); ?></span>
						</td>
					</tr>
					<?php }?>
				</table>
			</td>
		</tr>
	</tbody>
</table>

<div class="clr ht5"></div>
<div class="btns">
		<input name="submit" type="submit" value="Submit" class="blueBtn" id="submitButton" />
<?php echo $this->Form->end();?>
</div>

<script>

var vat = '0.00';
function displayQty(id)
{
	  var sum = '0.00' ;
	  var idd = $(id).attr('id');
	  splitted = idd.split("_");
	 
	  var purchasePrice = parseFloat($("#purchasePrice_"+splitted[1]).val()!=''?$("#purchasePrice_"+splitted[1]).val():0); 
	  var quantity = parseInt(($("#qtyReceived_"+splitted[1]).val()!='')?$("#qtyReceived_"+splitted[1]).val():0);

	  console.log(quantity+" * "+purchasePrice);
	  var total = quantity * purchasePrice;
	 
	  $("#amount_"+splitted[1]).val(total.toFixed(2)); 

		count = 0;
		$('.amount').each(function() {
			var amount = $(this).val();
		    if(amount !=''){
	        	sum = parseFloat(sum)+parseFloat(amount); 	    
	        } 			        				        
	    });
	    console.log(sum);
	  $("#total").html(sum.toFixed(2)); 
      $("#Tnet").html(Math.round(sum.toFixed(2)));			//display total net amount
      $("#totalNet").val(sum.toFixed(2));		//hold total net amount
		sum = 0;
		vat = 0;
}

$(".purchasePrice").bind('keyup keypress blur input',function(){
	if (/[^0-9\.]/g.test(this.value))
    {
    	 this.value = this.value.replace(/[^0-9\.]/g,'');
    }
});

$(".purchasePrice").bind('keyup keypress blur input',function(){
	displayQty(this);
});

$(document).ready(function(){ 
	$(function()
	{
		$("#received_date").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif');?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			maxDate:  new Date(),
			dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>'
		});
	});

});

$("#submitButton").click(function(){
	var valid = jQuery("#Purchase-receipt").validationEngine('validate');
	if(valid == true){
		$("#submitButton").hide();
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
                "number": {
                    // Number, including positive, negative, and floating decimal. credit: orefalo
                    "regex": /^[\+]?(([0-9]+)([\.,]([0-9]+))?|([\.,]([0-9]+))?)$/,
                    "alertText": "* Numbers Only"
                }
            };

        }
    };
    $.validationEngineLanguage.newLang();
})(jQuery);

/// DO NOT SUBMIT FORM ON ENTER PRESS BUTTON
$('#Purchase-receipt').keypress(function(e) {
	  var keyCode = e.keyCode || e.which;
	  if (keyCode === 13) { 
	    e.preventDefault();
	    return false;
	  }
});

</script>