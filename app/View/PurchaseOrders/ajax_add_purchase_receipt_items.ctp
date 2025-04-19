<style>

.widthClass {
    width: 30px;
}
.btwidth{
	width: 70px
}
.man{
	width: 50px
}
.tdColors{
	 border: thin solid red;
}
</style>

<div class="inner_title">
	<h3>
		<?php echo __('Goods Received Notes', true); ?>
	</h3>
	<span>
		<?php
			echo $this->Html->link(__('Back to list'),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn Back-to-List','id'=>'Back-to-List'));
		?>
	</span>
	<div class="clr ht5"></div>
</div>
<div class="clr ht5"></div>
<?php if(!empty($po_details)) { //debug($po_details);?>
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
		<td class="tdLabel2"><font style="font-weight:bold;">Supplier: </font>
			<?php echo $po_details['InventorySupplier']['name']; ?>
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

<?php echo $this->Form->create('',array('id'=>'Purchase-receipt','url'=>array('action'=>'getItems',$po_details['PurchaseOrder']['id'])));?>
<!-- inventory supplier hidden field maintain for accounting  by amit-->
<?php echo $this->Form->hidden('',array('name'=>"data[PurchaseOrder][id]",'value'=>$po_details['PurchaseOrder']['id'])); ?>
<?php echo $this->Form->hidden('',array('name'=>"inventory_supplier_id",'value'=>$po_details['InventorySupplier']['id'])); ?>
<?php echo $this->Form->hidden('',array('name'=>"inventory_supplier_name",'value'=>$po_details['InventorySupplier']['name'])); ?>
<?php echo $this->Form->hidden('',array('name'=>"purchase_order_no",'value'=>$po_details['PurchaseOrder']['purchase_order_number'])); ?>
<?php echo $this->Form->hidden('',array( 'id'=>'orderFor','name'=>"order_for",'value'=>$po_details['PurchaseOrder']['order_for'])); ?>
<table>
	<tr> 
		<td>Party Invoice Number: <font color="red">*</font></td>
		<td><?php echo $this->Form->input('',array('name'=>"data[PurchaseOrder][party_invoice_number]",'type'=>'text','autocomplete'=>off,'placeholder'=>'Party Invoice Number','label'=>false,'id'=>'party_invoice_no','class'=>'textBoxExpnd validate[required] partyNumber','value'=>$po_details['PurchaseOrder']['party_invoice_number'])); ?></td>
		
		<td>Good Received Date:</td>
		<td><?php $date = date("d/m/Y H:i:s"); ?>
		<?php if($this->Session->read('website.instance') == 'vadodara'){ 
			 echo $this->Form->input('',array('name'=>"data[PurchaseOrder][received_date]",'type'=>'text','id'=>'received_back_date','label'=>false,'class'=>'textBoxExpnd validate[required]','value'=>$date));
		}else{
			 echo $this->Form->input('',array('name'=>"data[PurchaseOrder][received_date]",'type'=>'text','id'=>'received_date','label'=>false,'class'=>'textBoxExpnd validate[required]','value'=>$date)); 
		}
		?> 
		</td>
	</tr>
</table>
<div class="clr ht5"></div>
<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm" id="item-row">
	<thead>
		<tr>
			<th valign="top" align="center"  style="text-align: center;">#</th>
			<th valign="top" width="15%" 	align="center"  style="text-align: center;">Product Name</th>
			<th valign="top" align="center"  style="text-align: center;">Manufacturer</th>
			<th valign="top" style="text-align: center;">Pack</th>
			<th valign="top" align="center" width="10%"  style="text-align: center;">Batch No.<font color="red">*</font></th>
			<th valign="top" width="10%" style="text-align: center;">Expiry Date<font color="red">*</font></th>
			<th valign="top" style="text-align: center;">MRP<font color="red">*</font></th>
			<th valign="top" style="text-align: center;">Pur. Price<font color="red">*</font></th>
			<th valign="top" style="text-align: center;">Sale Price<font color="red">*</font></th>
			<th valign="top" width="4%" style="text-align: center;">GST</th>
			<th valign="top" width="4%" style="text-align: center;">SGST</th>
			<th valign="top" width="4%" style="text-align: center;">CGST</th>
			<th valign="top" width="5%" style="text-align: center;">GST Amt.</th>
			<th valign="top" width="3%" style="text-align: center;">Qty. Ord</th>
			<th valign="top" width="3%" style="text-align: center;">Qty. Rec</th>
			<th valign="top" width="3%" style="text-align: center;">Free</th>
			<th valign="top" width="5%" style="text-align: center;">Amount</th>
			
		</tr>
	</thead>
	
	<tbody>
	
		<?php 
		if(!empty($items)) { $count = 0; $totalAmt = 0; $totalGst = 0; //debug($items);
		foreach($items as $key=>$item) { $count++;?>
		
		<tr>
			<td align="center" valign="middle" class="sr_number" ><?php echo $count;?></td>
			
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
					$qty = ($item['PurchaseOrderItem']['quantity_order']);
				?>
			</td>
			
			<td valign="middle">
				<?php
					echo $item['ManufacturerCompany']['name'];
					echo $this->Form->hidden('manufacturer',array('name'=>"data[purchase_order_item][$key][manufacturer]",'value'=>$item['ManufacturerCompany']['name']));
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
					echo $this->Form->input('batch_number',array('type'=>'text','name'=>"data[purchase_order_item][$key][batch_number]",'class'=>'textBoxExpnd validate[required] batch_number','value'=>$item['PurchaseOrderItem']['batch_number'],'id'=>'batch-number_'.$key,'autocomplete'=>'off','div'=>false,'label'=>false,'onClick'=>"this.select();"));
				?>
			</td>
			
			<td valign="middle" style="text-align: center;">
				<?php
				$date = $this->DateFormat->formatDate2local($item['PurchaseOrderItem']['expiry_date'],Configure::read('date_format'));
					echo $this->Form->input('expiry_date',array('type'=>'text','id'=>'expiryDate_'.$key,'name'=>"data[purchase_order_item][$key][expiry_date]",'value'=>$date,'class'=>'textBoxExpnd validate[required] expiry_date btwidth','div'=>false,'autocomplete'=>'off','label'=>false));
					 
				?>
			</td>
			
			<td valign="middle" style="text-align: center;">
				<?php
					if($item['PurchaseOrderItem']['mrp'] == '' || $item['PurchaseOrderItem']['mrp'] == 0){
						$mrp = $item['Product']['mrp'];
					}else{
						$mrp = $item['PurchaseOrderItem']['mrp'];
					}
					echo $this->Form->input('mrp',array('type'=>'text','name'=>"data[purchase_order_item][$key][mrp]",'value'=>$mrp,'id'=>'mrp_'.$key,'class'=>'textBoxExpnd validate[required]','div'=>false,'label'=>false,'autocomplete'=>'off'));
				?>	
			</td>
			
			<td valign="middle" style="text-align: center;" >
				<?php
					if(!empty($item['PurchaseOrder']['contract_id']) && $item['PurchaseOrderItem']['is_contract']==1)
					{
						echo $item['PurchaseOrderItem']['purchase_price'];
						echo $this->Form->hidden('purchase_price',array('name'=>"data[purchase_order_item][$key][purchase_price]",'class'=>'purchasePrice','id'=>'purchasePrice_'.$key,'value'=>$item['PurchaseOrderItem']['purchase_price']));
					}
					else 
					{
						if($item['PurchaseOrderItem']['purchase_price'] == '' || $item['PurchaseOrderItem']['purchase_price'] == 0){
							$purchase_price = $item['Product']['purchase_price'];
						}else{
							$purchase_price = $item['PurchaseOrderItem']['purchase_price'];
						}
						echo $this->Form->input('purchase_price',array('type'=>'text','name'=>"data[purchase_order_item][$key][purchase_price]",'value'=>$purchase_price,'id'=>'purchase-price_'.$key,'class'=>'textBoxExpnd validate[required] purchasePrice','id'=>'purchasePrice_'.$key,'autocomplete'=>'off','div'=>false,'label'=>false)); 
						echo $this->Form->hidden('previous_purchase_price',array('name'=>"data[purchase_order_item][$key][previous_purchase_price]",'value'=>$item['previous_purchase_price'],'id'=>'previous_purchase-price_'.$key,'class'=>'previousPurchasePrice','id'=>'previousPurchasePrice_'.$key,'autocomplete'=>'off','div'=>false,'label'=>false)); 
						echo $this->Form->hidden('is_hike',array('name'=>"data[purchase_order_item][$key][is_hike]",'value'=>'0','id'=>'is_hike_'.$key,'class'=>'isHike','id'=>'isHike_'.$key,'autocomplete'=>'off','div'=>false,'label'=>false)); 
					}
				?>
			</td>
			
			<td valign="middle" style="text-align: center;" >
				<?php 
						$profit_percentage = !empty($item['Product']['profit_percentage'])?$item['Product']['profit_percentage']:0;
						
						if($item['PurchaseOrderItem']['selling_price'] == '' || $item['PurchaseOrderItem']['selling_price'] == 0){
							if($item['Product']['sale_price'] == '' || $item['Product']['sale_price'] == 0){
								$selling_price = $item['PurchaseOrderItem']['mrp'];
							}else{
								$selling_price = $item['Product']['sale_price'] ;
							}
						}else{
							$selling_price = $item['PurchaseOrderItem']['selling_price'];
						}
						
						if($profit_percentage > 0){
							if($websiteConfig['instance'] == 'vadodara'){
								$selling_price = (($purchase_price * $profit_percentage) /100) + $purchase_price;
							}
						}else{
							//$selling_price = $item['PurchaseOrderItem']['mrp'];
						}
						
					echo $this->Form->hidden('profit_percentage',array( 'name'=>"data[purchase_order_item][$key][profit_percentage]",'value'=>$profit_percentage,'id'=>'profitPercentage_'.$key,'class'=>'profitPercentage'));
					echo $this->Form->input('selling_price',array('type'=>'text','name'=>"data[purchase_order_item][$key][selling_price]",'value'=>$selling_price,'id'=>'selling-price_'.$key,'class'=>'textBoxExpnd validate[required]','div'=>false,'label'=>false,'autocomplete'=>'off'));
				?>
			</td>
	
			<?php 
					if($item['PurchaseOrderItem']['tax'] == ''){
						$gst = !empty($item['Product']['tax'])?$item['Product']['tax']:0;
					}else{
						$gst = !empty($item['PurchaseOrderItem']['tax'])?$item['PurchaseOrderItem']['tax']:0;
					}
					$dividedGst = $gst/2 ;
			 ?>
			
			<td valign="middle" style="text-align: center;" >
				<?php 
						echo $this->Form->input('tax',array('type'=>'text','name'=>"data[purchase_order_item][$key][tax]",'value'=>$gst,'id'=>'tax_'.$key,'class'=>'tax textBoxExpnd validate[required]','div'=>false,'label'=>false,'autocomplete'=>'off'));
					 ?>	
			</td>
			<td valign="middle" style="text-align: center;" >
				<?php 
						echo $this->Form->input('sgst',array('type'=>'text','name'=>"data[purchase_order_item][$key][sgst]",'value'=>$dividedGst,'id'=>'sgst_'.$key,'class'=>'sgst textBoxExpnd validate[required]','div'=>false,'label'=>false,'autocomplete'=>'off','readonly'=>true));
					 ?>	
			</td>
			<td valign="middle" style="text-align: center;" >
				<?php 
						echo $this->Form->input('cgst',array('type'=>'cgst','name'=>"data[purchase_order_item][$key][cgst]",'value'=>$dividedGst,'id'=>'cgst_'.$key,'class'=>'cgst textBoxExpnd validate[required]','div'=>false,'label'=>false,'autocomplete'=>'off','readonly'=>true));
			 	?>	
			</td>
			
			<?php
				 if(!empty($item[0]['sumCount'])){
					$qty = $qty - $item[0]['sumCount'];
				} 
			?>
			
		
			<td valign="middle" style="text-align: center;" >
				<?php
					$gstAmount = $qty * (($purchase_price * $gst)/100);
					$totalGst += $gstAmount;
					echo $this->Form->input('vat',array('type'=>'text','name'=>"data[purchase_order_item][$key][vat]",'value'=>$gstAmount,'id'=>'vat_'.$key,'class'=>'textBoxExpnd validate[required] vat','div'=>false,'label'=>false,'autocomplete'=>'off'));
				?>	
			</td>
			
			
			<td valign="middle" style="text-align: center;">
				<?php
					echo $item['PurchaseOrderItem']['quantity_order'];
					echo $this->Form->hidden('quantity_order',array('name'=>"data[purchase_order_item][$key][quantity_order]",
							'value'=>$qty,'id'=>"ordQty_".$key,'class'=>'orderQty'));
					echo $this->Form->hidden('prev_received',array('name'=>"data[purchase_order_item][$key][prev_received]",
					'value'=>$item['PurchaseOrderItem']['quantity_received'],'id'=>"prevRecQty_".$key,'class'=>'prevRecQty'));
					 
				?>
			</td>
			
			<td valign="middle" style="text-align: center;">
				<?php if($item['PurchaseOrderItem']['quantity_order'] > $item[0]['sumCount'] && $item[0]['sumCount'] != 0){ ?>
				<table  style="padding:0px;">
					<tr>
						<td style="padding:0px;"><?php echo $item[0]['sumCount'];//echo $item['PurchaseOrderItem']['quantity_received']; ?>+</td>
						<td style="padding:0px;">
						<?php 
							 echo $this->Form->input('quantity_received',array('type'=>'text','name'=>"data[purchase_order_item][$key][quantity_received]",
							 	'id'=>'quantity-received_'.$key,'value'=>$qty,'autocomplete'=>'off','id'=>'quantity_'.$key,'class'=>'textBoxExpnd quantity',
								'autocomplete'=>'off','div'=>false,'label'=>false));
						?>
						</td>
					</tr>
				</table>
				<?php } else { ?>
				<?php 
					 echo $this->Form->input('quantity_received',array('type'=>'text','name'=>"data[purchase_order_item][$key][quantity_received]",
					 'id'=>'quantity-received_'.$key,'value'=>$qty,'autocomplete'=>'off','id'=>'quantity_'.$key,'class'=>'textBoxExpnd quantity','autocomplete'=>'off','div'=>false,'label'=>false));
						?>
				<?php } ?>
			</td>
			
			<td valign="middle" style="text-align: center;" >
				<?php
					 echo $this->Form->input('free',array('type'=>'text','name'=>"data[purchase_order_item][$key][free]", 'value'=>'','autocomplete'=>'off','id'=>'free_'.$key,'class'=>'textBoxExpnd free','autocomplete'=>'off','div'=>false,'label'=>false));


				?>
			</td>
			
		
			
			<td valign="middle" style="text-align: center;">
				<?php
					$amount = $purchase_price * $qty; 
					$totalAmt += $amount;
					 echo $this->Form->input('amount',array('type'=>'text','name'=>"data[purchase_order_item][$key][amount]",'value'=>$amount,'autocomplete'=>'off','id'=>'amount_'.$key,'class'=>'textBoxExpnd amount','readonly'=>'readonly','autocomplete'=>'off','div'=>false,'label'=>false));

					 echo $this->Form->hidden('current_amount',array('name'=>"data[purchase_order_item][$key][current_amount]",'value'=>'','id'=>'currentAmount_'.$key,'class'=>'currentAmount'));

					 echo $this->Form->hidden('discountAmount',array('name'=>"data[purchase_order_item][$key][discount_amount]",'value'=>0,'class'=>'discountAmount','id'=>'discountAmount_'.$key));
				?>
			</td>
			<!--<td><?php echo $this->Form->input('reason',array('name'=>"data[purchase_order_item][$key][reason]",'type'=>'textarea','class'=>'textBoxExpnd','cols'=>'1','rows'=>'1','div'=>false,'label'=>false,'class'=>'reason','id'=>'reason_'.$key,'style'=>'width:50px;')); ?></td>-->
		</tr>
		<?php }?>
		<?php //End Of For loop
			 echo $this->Form->hidden('no',array('id'=>'no_of_fields','value'=>$count));	
			}else{?>
				<?php echo $this->Form->hidden('no',array('id'=>'no_of_fields','value'=>'1'));?>
		<?php }?>
		
		
		
		<?php  
		 $absolutAmnt = $totalAmt ;
		?>
		<?php  $colspan = 16; ?>
		<tr id = "amountRow">
		<td colspan="<?php echo $colspan; ?>" align="right">
				<table>
					<tr><td>Total:</td></tr>
					<tr><td>Discount:</td></tr> 
					<tr><td>Total SGST:</td></tr>
					<tr><td>Total CGST: </td></tr>
					<tr><td>Net Amount:</td></tr>
					<tr><td>Round Off:</td></tr>
					
				</table>
			</td>
			<td>
				<table align="right">
					<tr><?php //debug($absolutAmnt);debug($totalGst);?>
					<?php $divideGst = $totalGst / 2 ; ?>
						<td style="text-align:right;">
							<?php echo $this->Form->hidden('',array('name'=>"total",'value'=>$absolutAmnt,'id'=>'totalVal')); ?>
							<?php //echo $this->Form->hidden('',array('name'=>"actual_total",'value'=>$absolutAmnt,'id'=>'actualTotal')); ?>
							<?php echo $this->Form->hidden('',array('name'=>"vat",'value'=>$totalGst,'id'=>'totalVat','div'=>false,'label'=>false)); ?>
							<?php echo $this->Form->hidden('',array('name'=>"total_sgst",'value'=>$divideGst,'id'=>'total_sgst','div'=>false,'label'=>false)); ?>
							<?php echo $this->Form->hidden('',array('name'=>"total_cgst",'value'=>$divideGst,'id'=>'total_cgst','div'=>false,'label'=>false)); ?>
							<?php echo $this->Form->hidden('',array('name'=>"net_amount",'value'=>($absolutAmnt+$totalGst),'id'=>'totalNet')); ?>
							<span id="total"><?php echo number_format(($absolutAmnt),2); ?></span>
						</td>
					</tr>
					<tr>
						<td style="text-align:right;">
							<?php echo $this->Form->input('discount',array('name'=>"discount",'value'=>'0','id'=>'totalDiscount','readonly'=>false,'div'=>false,'label'=>false,'style'=>"width:40px")); ?>
						</td>
					</tr>
				
					
					<tr>
						<td style="text-align:right;">
						<span id="displayTotalSgst">
							<?php echo number_format(($divideGst),2);?>
						</span>
						</td>
					</tr>
						<td style="text-align:right;">
						<span id="displayTotalCgst">
							<?php echo number_format(($divideGst),2);?>
						</span>
						</td>
					<tr>
					</tr>
					<tr>
						<td style="text-align:right;">
							<span id="Tnet"><?php $withoutRound = $absolutAmnt+$totalGst; 
							$withRound = round($absolutAmnt+$totalGst); 
							echo  number_format(round($absolutAmnt+$totalGst),2); 
							?></span>
						</td>
					</tr>
					<tr>
						<td style="text-align:right;">
							<span id="tnetWithRound"><?php  $withoutRound = $absolutAmnt+$totalGst; 
								echo number_format(($withoutRound - $withRound),2);
								
							?></span>
						</td>
					</tr>
					
				</table>
			</td>
		</tr>
	</tbody>
</table>


<div align="left" id="add_more" style="display: none;">
	<input name="" type="button" value="Add More" class="blueBtn Add_more" tabindex="36" onclick="addFields()"/>
</div>

<div class="btns">
		<input name="submit" type="submit" value="Submit" class="blueBtn" id="submitButton" />
<?php echo $this->Form->end();

 function calculateGSTAmount($gstPercent,$total){
       
    if(empty($total) || empty($gstPercent)){
    	$gstAmount = 0 ;
   	}else{
   		$gstAmount = ($total/100)*$gstPercent;		
   	}

    return round($gstAmount,2);
}

?>
</div>

<script>


$("#submitButton").click(function(){  
	var valid = jQuery("#purchaseOrder").validationEngine('validate');
	if(valid){
		
	}else{
		return false;
	}
});
// oN ENTER DO NOT SUBMIT FORM
$('#Purchase-receipt').keypress(function(e) {
	  var keyCode = e.keyCode || e.which;
	  if (keyCode === 13) { 
	    e.preventDefault();
	    return false;
	  }
});
	


var Sum = '0.00';
var vat = '0.00';

function displayQty(id)
{ 	 
	  var totalDisc = 0.0;
	  var discountAmount = 0;
	  var idd = $(id).attr('id');
	 
	  var splitted = idd.split("_"); 
	  var purchasePrice = parseFloat($("#purchasePrice_"+splitted[1]).val());
	  var tax = parseFloat(($("#tax_"+splitted[1]).val()!='')?$("#tax_"+splitted[1]).val():0);
	  var ordQty = parseInt(($("#ordQty_"+splitted[1]).val()!='')?$("#ordQty_"+splitted[1]).val():0);
	  var prevRecQty = parseInt(($("#prevRecQty_"+splitted[1]).val()!='')?$("#prevRecQty_"+splitted[1]).val():0);
	  var quantity = parseFloat(($("#quantity_"+splitted[1]).val()!='')?$("#quantity_"+splitted[1]).val():0);
 	  
	 
	  
	 // console.log("amnt"+amnt);
	  

	 

	  $('.discountAmount').each(function() {
		 $(this).val('0') ;	
	  });
		//console.log("vat"+vatt);
	  /*END OF RETURN AMOUNT CALCULATION */
		
  	 if(quantity > (ordQty)){
		  alert("Received qty is greater than Ordered qty"); 
		  $("#quantity_"+splitted[1]).val('');
		  $("#quantity_"+splitted[1]).focus();
		  return false;
	  }
	  
	  var total = quantity * purchasePrice;

	  $("#amount_"+splitted[1]).val(total.toFixed(2));
	  $("#currentAmount_"+splitted[1]).val(total.toFixed(2));
	  var totalVatForQuantity = (total*tax)/100;
	  $("#vat_"+splitted[1]).val(totalVatForQuantity.toFixed(2));
		

		vatt = 0;
	  	$('.vat').each(function() {
		  	if($(this).val() !=''){
				vatt += parseFloat($(this).val());
			}
				
	  	});

		var totalvat = vatt;
		
		//alert(totalvat);
		/* END Of Removing Return amnt  */
		
		var amnt = 0;
	  	$('.amount').each(function() {
			if($(this).val() !=''){
				amnt += parseFloat($(this).val());
			}
	  	}); 
		var Vat = parseFloat(totalvat);
	    $("#total").html((amnt).toFixed(2));
	    $("#totalVal").val((amnt).toFixed(2));
	    $('#totalDiscount').val(totalDisc.toFixed(2));
	    
	    
        $("#totalVat").val((Vat).toFixed(2));			//hold total vat
        var divideGst = Vat / 2 ;
        $("#displayTotalSgst").html((divideGst).toFixed(2));	//hold total vat
		$("#displayTotalCgst").html((divideGst).toFixed(2));	//hold total vat

		$("#total_sgst").val((divideGst).toFixed(2));	//hold total vat
		$("#total_cgst").val((divideGst).toFixed(2));	//hold total vat
     
     
	  	var discount = parseFloat($("#totalDiscount").val() !='' ? $("#totalDiscount").val() : 0);
      	Tnet = ((amnt) + Vat) - discount;
     
      	var roundOff = Tnet - Math.round(Tnet);
	
    
      	$("#Tnet").html(Math.round(Tnet.toFixed(2)));
      	$("#tnetWithRound").html(roundOff.toFixed(2));
      	$("#totalNet").val(Tnet.toFixed(2));	
     	
		Sum = 0;
		vat = 0;
}

$(".quantity, .tax, .purchasePrice").bind('keyup keypress blur input',function(){
	if (/[^0-9\.]/g.test(this.value))
    {
    	 this.value = this.value.replace(/[^0-9\.]/g,'');
    }
});





$(".purchasePrice").bind('keyup keypress blur input',function(){
	displayQty(this);
});

$(".tax").bind('keyup keypress blur input',function(){
	displayQty(this);
});

$(".quantity").bind('keyup',function(){
	var id = $(this).attr('id');
	splitted = id.split('_');
	
	var ordQty = parseInt(($("#ordQty_"+splitted[1]).val()!='')?$("#ordQty_"+splitted[1]).val():0);
	var quantity = parseFloat(($("#quantity_"+splitted[1]).val()!='')?$("#quantity_"+splitted[1]).val():0);
	var prevRecQty = parseInt(($("#prevRecQty_"+splitted[1]).val()!='')?$("#prevRecQty_"+splitted[1]).val():0);
	 
	if(quantity > (ordQty)){
		alert("Received qty is greater than Ordered qty");
		$("#quantity_"+splitted[1]).val('');
		$("#quantity_"+splitted[1]).focus();
	}
	displayQty(this);
});

$(".purchasePrice").bind('keyup keypress blur input',function(){
	if (/[^0-9\.]/g.test(this.value))
    {
    	 this.value = this.value.replace(/[^0-9\.]/g,'');
    }
    calculateSalePrice(this);
});


$(".purchasePrice").on('blur',function(){ 
    var id = $(this).attr('id').split("_")[1];
    var previousPurchasePrice = parseFloat($("#previousPurchasePrice_"+id).val()); 
    if(!isNaN(previousPurchasePrice) && (previousPurchasePrice != 0)){
    var notMoreThnPur = parseFloat((previousPurchasePrice * 0.05) + previousPurchasePrice);
        if($(this).val() >= notMoreThnPur){
            console.log($(this).val() +">="+ notMoreThnPur);
            $("#reason_"+id).addClass('validate[required]');
            console.log("make sure to input reason");
            $("#isHike_"+id).val('1');
        }else{
            $("#reason_"+id).removeClass('validate[required]');
            $("#isHike_"+id).val('0');
        }
    }
});


function calculateSalePrice(id){
	var idd = $(id).attr('id');
  	splitted = idd.split("_");

 	var mrp = parseFloat($("#mrp_"+splitted[1]).val()?$("#mrp_"+splitted[1]).val():0);
  	var purchasePrice = parseFloat($("#purchasePrice_"+splitted[1]).val()?$("#purchasePrice_"+splitted[1]).val():0);
  	var profitPercentage = parseFloat($("#profitPercentage_"+splitted[1]).val()?$("#profitPercentage_"+splitted[1]).val():0);
	//alert(profitPercentage);
	
  	if(profitPercentage != 0){
  		var saleAmount = ((purchasePrice * profitPercentage) /100) + purchasePrice;
  	}else{
  		var saleAmount = mrp;
  	}
  	$("#selling-price_"+splitted[1]).val(saleAmount);
}


function displayTotalNetAmount(id){

	var actualTotalAmount = 0;
	var totalGSTAmount = 0 ;
    $(".currentAmount").each(function() {
	   var id = $(this).attr('id').split('_')[1];
	   var amount = $('#currentAmount_'+id).val();
	   var gstPercent = parseFloat($('#tax_'+id).val());
	   
	   var calculateGSTAmnt = (amount * gstPercent ) / 100 ; 
	 
	   $('#vat_'+id).val(calculateGSTAmnt.toFixed(2));
	   actualTotalAmount += parseFloat(amount);
	   totalGSTAmount += parseFloat(calculateGSTAmnt.toFixed(2));
	});
  
    var divideGst = totalGSTAmount / 2 ;
    $("#totalVat").val((totalGSTAmount).toFixed(2));
    $("#displayTotalSgst").html((divideGst).toFixed(2));	//hold total vat
	$("#displayTotalCgst").html((divideGst).toFixed(2));	//hold total vat

	$("#total_sgst").val((divideGst).toFixed(2));	//hold total vat
	$("#total_cgst").val((divideGst).toFixed(2));	//hold total vat

	var totalVat = totalGSTAmount;
	var totalAmount = parseFloat($("#totalVal").val() !='' ? $("#totalVal").val() : 0);
	var discount = parseFloat($("#totalDiscount").val() !='' ? $("#totalDiscount").val() : 0);
	var totalNet = ( totalAmount - discount ) + totalVat;

	$("#Tnet").html(totalNet.toFixed(2));
	$("#totalNet").val(totalNet.toFixed(2));
	//$('#actualTotal').val(actualTotalAmount);
}


$("#totalDiscount, #totalVat").bind('keyup',function(){
	if (/[^0-9\.]/g.test(this.value))
    {
    	 this.value = this.value.replace(/[^0-9\.]/g,'');
    }
    var theTotal = 0;
    $(".amount").each(function() {
	   var id = $(this).attr('id').split('_')[1];
	   var amount = $('#amount_'+id).val();
	   theTotal += parseInt(amount);
	});
    var totalDiscAmount = $('#totalDiscount').val();

    discPercentage = (totalDiscAmount / theTotal) * 100;

    
    $(".discountAmount").each(function() {
	   var id = $(this).attr('id').split('_')[1];
	   var amount = $('#amount_'+id).val();
	   var discAmnt = (amount * discPercentage) / 100;
	   $('#discountAmount_'+id).val(discAmnt.toFixed(2));
	   var actualAmount = amount - discAmnt ;
	   $("#currentAmount_"+id).val(actualAmount.toFixed(2) );
	});
    
	displayTotalNetAmount(this);
});


$(document).on('keypress','.quantity',function(e) {
	id = $(this).attr('id');
    var count = id.split("_");
    if (e.keyCode==40) {
    	fieldNo = parseInt(count[1])+1;
        $("#quantity_"+fieldNo).focus();
    }
    if (e.keyCode==38) {
    	fieldNo = parseInt(count[1])-1;
        $("#quantity_"+fieldNo).focus();
    }
});

$('.batch_number').bind('input',function() {
    $(this).val($(this).val().toUpperCase());
});

var opt = '';
var optValue = '';

$(document).ready(function(){

	optValue = $.parseJSON('<?php echo ($dataValue); ?>');
	opt = $.parseJSON('<?php echo ($vatAllData); ?>');
	
	$(function()
	{
		$(".expiry_date").datepicker({
			showOn: "both",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,  		
			yearRange: '1950',	
			minDate: new Date(),		 
			dateFormat:'<?php echo $this->General->GeneralDate();?>',
		});
		
		$("#received_date").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif');?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>'
		});

	    $( "#received_back_date" ).datepicker({
	    	showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',
			minDate:  new Date(),
			dateFormat: '<?php echo $this->General->GeneralDate("HH:II:SS");?>',		
	    });
	});
	
});

$(document).on('change',".vatDisplay",function(){
	var id = $(this).attr('id');
	splittedArr = id.split("_");
	var vatVal = this.value;
	console.log(vatVal);
	if(vatVal!=''){
	$.each(optValue, function (key, value) {
		if(key == vatVal){
			$("#tax_"+splittedArr[1]).val(value);
		}
	});
	}else{
		$("#tax_"+splittedArr[1]).val(0);
	}
	displayQty(this);
});

$("#submitButton").on('click',function(event){  
	var valid = jQuery("#Purchase-receipt").validationEngine('validate');
	if(valid == true){
		/*var isExist = false;
		event.preventDefault();
		$.ajax({
		  type: "GET",
		  url: "<?php echo $this->Html->url(array("controller" => "PurchaseOrders", "action" => "checkInvoiceNumber")); ?>"+"/"+$("#party_invoice_no").val(), 
		}).done(function( msg ) {
			var ItemDetail = jQuery.parseJSON(msg); 
			console.log(ItemDetail);
			if(ItemDetail==="1"){
				alert("Something went wrong, please try again"); 
				return false;
			} else if(ItemDetail==="2") {
				alert("Invoice number is already generated!"); 
				return false;
			}else{
				isExist = true; 
				$("#submitButton").hide();
				$("#Purchase-receipt form").submit(); 
				return true;
			}
		});  */ 
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

$(document).ready(function() {
	$(".tax").each(function() {
		var id = $(this).attr('id');
		splitted = id.split("_");
		$('#tax_'+splitted[1]).change(function(){
			var tax = parseFloat($('#tax_'+splitted[1]).val());
			var taxes = [0,5,5.5,6,12,12.5,13.5];
			if ($.inArray(tax, taxes) < 0) { 
				$('#tax_'+splitted[1]).attr('class','tdColors tax textBoxExpnd validate[required]');
				$('#tax_'+splitted[1]).val('');
				$('#submitButton').hide();
			} else if ($.inArray(tax, taxes) >= 0) {
				$('#tax_'+splitted[1]).attr('class','tax textBoxExpnd validate[required]');
				$('#submitButton').show();
			}
		});
	});
});



</script>