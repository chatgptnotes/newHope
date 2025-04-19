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

<?php if(!empty($po_details)) { ?>
<table cellpadding="0" cellspacing="0" border="0">
	<tr>
	<td>
	<table>
		<td class="tdLabel2"><font style="font-weight:bold;">Purchase Order Number: </font> 
			<?php  
				echo $po_details['PurchaseOrder']['purchase_order_number'];
			?>
		</td>
		
		<td class="tdLabel2"><font style="font-weight:bold;">GRN Numberxfd: </font> 
			<?php  
				echo $receipt_items[0]['PurchaseOrderItem']['grn_no'];
			?>
		</td>
	
		<td class="tdLabel2"><font style="font-weight:bold;">Party Invoice Number: </font> 
			<?php  
				echo $receipt_items[0]['PurchaseOrderItem']['party_invoice_number'];
			?>
		</td>
		
		<td width="20">&nbsp;</td>
		<td class="tdLabel2"><font style="font-weight:bold;">Supplier: </font>
			<?php echo $po_details['InventorySupplier']['name']; ?>
		</td>
		
		<td width="20">&nbsp;</td>
		<td class="tdLabel2"><font style="font-weight:bold;">Order Created Date: </font>
			<?php 
				echo $this->DateFormat->formatDate2Local($po_details['PurchaseOrder']['order_date'],Configure::read('date_format'),true); ?>
		</td>
		
		<?php if(!empty($po_details['PurchaseOrder']['create_time'])) { ?>
		<td width="20">&nbsp;</td>
		<td class="tdLabel2"><font style="font-weight:bold;">Goods Received Date: </font>
			<?php 
				echo $this->DateFormat->formatDate2Local($receipt_items[0]['PurchaseOrderItem']['received_date'],Configure::read('date_format'),true); ?>
		</td>
		<?php } ?>
	</table>
	</td>	
	</tr>
</table>
<?php }  ?>

<div class="clr ht5"></div>

<?php echo $this->Form->create('',array('id'=>'Purchase-receipt'));?>
<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm" id="item-row">
	<thead>
		<tr>
			<th width="40" align="center" valign="top" style="text-align: center;">Sr.No.</th>
			<th width="100" align="center" valign="top" style="text-align: center;">Product Name</th>
			<th width="100" align="center" valign="top" style="text-align: center;">Manufacturer</th>
			<th width="60" valign="top" style="text-align: center;">Pack</th>
			<th width="80" align="center" valign="top" style="text-align: center;">Batch No.</th>
			<th width="60" valign="top" style="text-align: center;">Expiry Date</th>
			<th width="60" valign="top" style="text-align: center;">MRP</th>
			<th width="60" valign="top" style="text-align: center;">Purchase Price</th>
			<th width="60" valign="top" style="text-align: center;">Selling Price</th>
			<?php if($websiteConfig['instance']=='kanpur'){?>
			<th width="60" valign="top" style="text-align: center;">Vat of class</th>
			<?php }else{?>
			<th width="60" valign="top" style="text-align: center;">Tax</th>
			<?php }?>
			<th width="60" valign="top" style="text-align: center;">Quantity Ordered</th>
			<th width="60" valign="top" style="text-align: center;">Quantity Received</th>
			<th width="20" valign="top" style="text-align: center;">Free</th>
			<th width="80" valign="top" style="text-align: center;">Amount</th>
		</tr>
	</thead>
	<?php //debug($receipt_items);?>
	<tbody>
		<?php $count=0; $total = 0; $vatTotal = 0; foreach($receipt_items as $key=>$item) { $count++; ?>
		<tr>
			<td align="center" valign="middle" class="sr_number"><?php echo $count;?></td>
			
			<td valign="middle">
				<?php
					echo $item['Product']['name'];
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
				?>
			</td>
			
			<td valign="middle" style="text-align: center;">
				<?php
					echo $item['PurchaseOrderItem']['batch_number'];
				?>
			</td>
			
			<td valign="middle" style="text-align: center;">
				<?php
					if($item['PurchaseOrderItem']['expiry_date'] != '0000-00-00' || $item['PurchaseOrderItem']['expiry_date'] !='')
					{
						echo $this->DateFormat->formatDate2Local($item['PurchaseOrderItem']['expiry_date'],Configure::read('date_format'),true);
					}
					else 
					{
						echo $this->DateFormat->formatDate2Local($item['Product']['expiry_date'],Configure::read('date_format'),true);
					}
				?>
			</td>
			
			<td valign="middle" style="text-align: center;" id="mrp_<?php echo $key;?>">
				<?php
					if(!empty($item['PurchaseOrderItem']['mrp']))
						echo $item['PurchaseOrderItem']['mrp'];
					else 
						echo $item['Product']['mrp'];
				?>	
			</td>
			
			<td valign="middle" style="text-align: center;" id="mrp_<?php echo $key;?>">
				<?php
					$purcahse_price = $item['Product']['purchase_price'];
					if(!empty($item['PurchaseOrder']['contract_id']) && $item['PurchaseOrderItem']['is_contract']==1)
					{
						$purcahse_price = $item['PurchaseOrderItem']['purchase_price'];
					}
					else 
					{
						$purcahse_price = $item['PurchaseOrderItem']['purchase_price'];
					}
					echo $purcahse_price;
				?>
			</td>
			
			<td valign="middle" style="text-align: center;" id="mrp_<?php echo $key;?>">
				<?php 
					if(!empty($item['PurchaseOrderItem']['selling_price']))
						echo $item['PurchaseOrderItem']['selling_price'];
					else 
						echo $item['Product']['sale_price'];
				?>
			</td>
			
			<?php if($websiteConfig['instance']=='kanpur'){?>
			<td valign="middle" style="text-align: center;" id="vatOfClass_<?php echo $key;?>">
				<?php
					if(!empty($item['PurchaseOrderItem']['vat_class_id']))
						$tax = $item['VatClass']['vat_percent'] + $item['VatClass']['sat_percent'];
						echo $item['VatClass']['vat_of_class'];
				?>
			</td>
			<?php }else{?>
			
			<td valign="middle" style="text-align: center;" id="tax_<?php echo $key;?>">
				<?php 
					if(!empty($item['PurchaseOrderItem']['tax']))
						$tax = $item['PurchaseOrderItem']['tax'];
					else 
						$tax = $item['Product']['tax'];
						echo $tax;
				?>
			</td>
			<?php }?>
			
				<?php 
					 $vat = ($purcahse_price * $tax/100) * $item['PurchaseOrderItem']['quantity_received'];
					 
					$vatTotal += $vat; 
					
				?>

			<td valign="middle" style="text-align: center;">
				<?php
					echo ($item['PurchaseOrderItem']['quantity_order']);
				?>
			</td>
			
			<td valign="middle" style="text-align: center;">
				<?php
					echo ($item['PurchaseOrderItem']['quantity_received']);
				?>
			</td>
			
			<td valign="middle" style="text-align: center;">
				<?php echo !empty($item['PurchaseOrderItem']['free'])?$item['PurchaseOrderItem']['free']:"-";?>
			</td>
			
			<td valign="middle" style="text-align: right;">
				<?php
				if(!empty($item['PurchaseOrderItem']['quantity_received'])){
					$amount = $item['PurchaseOrderItem']['amount'];
					echo number_format($amount,2);
				}
				?>
				
			</td>
			
			</tr>
			<?php $total = $total + $amount; 
				
				} //foreach ends here ?>
				
				<?php if(count($returnItem)>0){
					
					?>
			<tr id = "rowCheck">
				<td colspan = "14" style="font-weight: bold;">
					<?php echo __("RETURN"); ?>
				</td>
			</tr>
			<tr id = "rowReturn">
				<th width="10" align="center" valign="top" style="text-align: center;">#</th>
				<th width="100" align="center" valign="top" style="text-align: center;">Product Name</th>
				<th width="100" align="center" valign="top" style="text-align: center;">Manufacturer</th>
				<th width="20" valign="top" style="text-align: center;">Pack</th>
				<th width="40" align="center" valign="top" style="text-align: center;">Batch No.<font color="red">*</font></th>
				<th width="100" valign="top" style="text-align: center;" colspan="1">Expiry Date<font color="red">*</font></th>
				<th width="40" valign="top" style="text-align: center;">MRP<font color="red">*</font></th>
				<th width="40" valign="top" style="text-align: center;">Pur. Price<font color="red">*</font></th>
				<th width="40" valign="top" style="text-align: center;">Sale Price<font color="red">*</font></th>
				<th width="10" valign="top" style="text-align: center;">Return Qty</th>
				<th width="30" valign="top" style="text-align: center;" colspan="3">Remark</th>
				<?php if($this->Session->read('website.instance') == 'kanpur') { 
				?> 
				<!--  <th width="10" valign="top" style="text-align: center;">Discount</th>-->
				<?php } ?> 
				<th width="60" valign="top" style="text-align: center;">Amount</th>
			</tr>
			<?php  $tCount = $count; 
				foreach($returnItem as $key=>$item){ $tCount++;
			?>
			
			<tr class="row" id = "row<?php echo $cnt;?>">
				<td align="center" valign="middle" class="sr_number" ><?php echo $tCount;?></td>
				<td valign="middle">
					<?php
						echo $item['Product']['name'];
						echo $this->Form->hidden('',array('name'=>"data[purchase_return][$cnt][product_id]",'value'=>$item['Product']['id'],'fieldno'=>"1"));
						echo $this->Form->hidden('',array('name'=>"data[purchase_return][$cnt][id]",'value'=>$item['PurchaseOrderItem']['id'],'fieldno'=>"1"));
						echo $this->Form->hidden('',array('name'=>"data[purchase_return][$cnt][grn_no]",'value'=>$item['PurchaseOrderItem']['grn_no'],'fieldno'=>"1"));
						echo $this->Form->hidden('',array('id'=>"productName_1",'class'=>'product_name','name'=>"data[purchase_return][$cnt][name]",'value'=>$item['Product']['name'],'fieldno'=>"1"));
						
						$qty = ($item['PurchaseOrderItem']['quantity_order']);
					?>
				</td>
				
				<td valign="middle">
					<?php
						echo $item['ManufacturerCompany']['name'];
						echo $this->Form->hidden('',array('id'=>"manufacturer_".$cnt,'name'=>"data[purchase_return][$cnt][manufacturer]",'value'=>$item['ManufacturerCompany']['name'],'fieldno'=>"1"));
					?>
				</td>
				
				<td align="center" valign="middle">
					<?php
						echo $item['PurchaseReturn']['pack'];
						echo $this->Form->hidden('',array( 'id'=>"pack_".$cnt,'name'=>"data[purchase_return][$cnt][pack]",'value'=>$item['PurchaseReturn']['pack'],'fieldno'=>"1"));
					?>
				</td>
				
				<td valign="middle" style="text-align: center;">
					<?php
						echo $item['PurchaseReturn']['batch_number'];
						echo $this->Form->hidden('',array('id'=>"batch-number_".$cnt,'type'=>'text','name'=>"data[purchase_return][$cnt][batch_number]",'class'=>'textBoxExpnd validate[required] batch_number','value'=>$item['PurchaseReturn']['batch_number'],'autocomplete'=>'off','div'=>false,'label'=>false,'style'=>"width:100%",'fieldno'=>"1"));
					?>
				</td>
				
				<td valign="middle" style="text-align: center;" colspan="1" >
					<?php
						echo $date = $this->DateFormat->formatDate2local($item['PurchaseReturn']['expiry_date'],Configure::read('date_format'));
						echo $this->Form->hidden('',array('type'=>'text','id'=>'expiryDate_'.$cnt,'name'=>"data[purchase_return][$cnt][expiry_date]",'value'=>$date,'class'=>'textBoxExpnd validate[required] expiry_date','div'=>false,'autocomplete'=>'off','label'=>false,'style'=>"width:80%",'fieldno'=>"1"));
						 
					?>
				</td>
				
				<td valign="middle" style="text-align: center;">
					<?php
						echo $mrp = $item['PurchaseOrderItem']['mrp'];
						echo $this->Form->hidden('',array('type'=>'text','name'=>"data[purchase_return][$cnt][mrp]",'value'=>$mrp,'id'=>'mrp_'.$cnt,'class'=>'textBoxExpnd validate[required]','div'=>false,'label'=>false,'style'=>"width:100%",'autocomplete'=>'off','fieldno'=>"1"));
					?>	
				</td>
				
				<td valign="middle" style="text-align: center;" >
					<?php
						echo $purchase_price = $item['PurchaseOrderItem']['purchase_price'];
							
						echo $this->Form->hidden('',array('type'=>'text','name'=>"data[purchase_return][$cnt][purchase_price]",'value'=>$purchase_price,'class'=>'textBoxExpnd validate[required] purchasePrice','id'=>'purchasePrice_'.$cnt,'autocomplete'=>'off','div'=>false,'label'=>false,'style'=>"width:100%",'fieldno'=>"1")); 
						
					?>
				</td>
				
				<td valign="middle" style="text-align: center;" >
					<?php 
						echo $selling_price = $item['PurchaseOrderItem']['selling_price'];
						echo $this->Form->hidden('',array('type'=>'text','name'=>"data[purchase_return][$cnt][selling_price]",'value'=>$selling_price,'id'=>'selling-price_'.$cnt,'class'=>'textBoxExpnd validate[required]','div'=>false,'label'=>false,'autocomplete'=>'off','style'=>"width:100%",'fieldno'=>"1"));
					?>
				</td>
		
				<td valign="middle" style="text-align: center;">
					<?php
						echo $returnQty = $item['PurchaseReturn']['return_quantity'];
						echo $this->Form->hidden('',array('type'=>'text','id'=>"returnQty_".$cnt,'name'=>"data[purchase_return][$cnt][return_qty]",'value'=>$returnQty,'class'=>'returnQty','label'=>false,'fieldno'=>"1"));
					?>
				</td>
				
				<td valign="middle" style="text-align: center;" colspan="3">
					<?php
					     echo $remark = $item['PurchaseReturn']['remark'];
						 echo $this->Form->hidden('',array('type'=>'text','name'=>"data[purchase_return][$cnt][remark]", 'value'=>$remark,'autocomplete'=>'off','id'=>'remark_'.$cnt,'class'=>'textBoxExpnd remark','autocomplete'=>'off','style'=>"width:100%",'div'=>false,'label'=>false,'fieldno'=>"1"));
					?>
				</td>
				
				<td valign="middle" style="text-align: center;">
					<?php
						echo $returnAmount = $purchase_price * $returnQty; 
						$totalRetAmnt += $returnAmount; 
						echo $this->Form->hidden('',array('type'=>'text','name'=>"data[purchase_return][$cnt][returnAmount]",'value'=>$returnAmount,'autocomplete'=>'off','id'=>'returnAmount_'.$cnt,'class'=>'textBoxExpnd returnAmount','readonly'=>'readonly','autocomplete'=>'off','style'=>"width:100%",'div'=>false,'label'=>false,'fieldno'=>"1"));
					?>
				</td>
				<?php  $returnVat = $item['PurchaseReturn']['vat'];?>
			</tr>
			<?php $totalReturnVat = $totalReturnVat + $returnVat;}
				 
			?>
			<?php 
				}?>
			<tr>
				<td colspan="13" align="right">	
					<table>
						<tr>
							<td>Gross Amount:</td>
						</tr>
						<tr>
							<td>Total GST:</td>
						</tr>
						
						<tr>
							<td>Total Discount:</td>
						</tr>
						
						<?php if($totalReturnVat!=0 || $totalReturnVat!=''){?>
						<tr>
							<td>Total Return Vat:</td>
						</tr>
						<?php }?>
						<tr>
							<td>Net Amount:</td>
						</tr>
						<tr>
							<td>Rounded Amnt:</td>
						</tr>
					</table>
				</td>
				<?php //debug($item['PurchaseOrderItem']);?>
				<td style="text-align: right;">	
					<table align="right">
						<tr>
							<td style="text-align: right;"><?php echo $fromDbTotal = number_format($po_details['PurchaseOrder']['total'],2);?></td>
						</tr>
						<tr>
							<td style="text-align: right;">
							<?php $fromDbVat = $po_details['PurchaseOrder']['vat'];
								echo number_format(($fromDbVat),2); 
							 ?>
							</td>
						</tr>
						<?php if(strtolower($this->Session->read('website.instance')) != "vadodara") { ?>
						<tr>
							<td style="text-align: right;"><?php 
							$discTotal = $po_details['PurchaseOrder']['discount'];
							echo number_format(($discTotal),2); ?></td>
						</tr>
						<?php } ?>
						<?php if($totalReturnVat!=0 || $totalReturnVat!=''){?> 
						<tr>
							<td style="text-align: right;"><?php echo $totalReturnVat;?></td>
						</tr>
						<?php }?>
						<tr>
							<td style="text-align: right;"><?php
							$data=explode(',', $fromDbTotal);
							foreach($data as $key=>$val){
								$result = $result.$val;
							}
							$totnet = $result + $fromDbVat; 
							$withRound = round($totnet-$totalReturnVat);
							$withoutRound = $totnet-$totalReturnVat;
							echo number_format(round($totnet-$totalReturnVat-$discTotal),2); 
							?></td>
						</tr>
						<tr>
							<td style="text-align: right;"><?php 
							echo number_format($withoutRound - $withRound, 2);
							?></td>
						</tr>
					</table>
				</td>
			</tr>
	</tbody>
</table>

<div class="clr ht5"></div>
<div class="btns">
	<!--<input name="submit" type="submit" value="Submit" class="blueBtn" id="submitButton" />-->
<?php echo $this->Form->end();?>
</div>


<div class="btns">
	<?php
		
	?>
</div>


<script>


$(".quantity").blur(function(){
	//alert("yoyo");
	  if($(this).val()!=""){
		  if($(this).val() == 0)
		  {
			  alert("please enter atleast product");
		  }
		  else
		  {
			  var idd = $(this).attr('id');
			  splitted = idd.split("_");
			  var purchasePrice = $("#purchasePrice_"+splitted[1]).val();
			  var total = $(this).val()*purchasePrice;
			  //alert(purchasePrice);
			  $("#amount_"+splitted[1]).val(total);
	          
		  }
	  }
});

$(document).ready(function(){
	
	$(function()
	{
		$(".expiry_date1").datepicker({
			showOn: "button",
			buttonImage: "/getnabh/img/js_calendar/calendar.gif",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			dateFormat:'<?php echo $this->General->GeneralDate();?>'
		});
	});
	
});


$("#submitButton").click(function(){

	var valid = jQuery("#Purchase-receipt").validationEngine('validate');
	if(valid){
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




</script>