
<div style="padding: 10px">
	<style>
.tdLabel2 {
	font-size: 12px;
}
</style>

	<?php
	echo $this->Html->script('jquery.autocomplete_pharmacy');
	echo $this->Html->css('jquery.autocomplete.css');

	?>


	<div class="inner_title">
		<h3>Purchase Receipt View</h3>
		<span> <?php

		echo $this->Html->link(__('Back'), array('action' => 'purchase_details_list' ,'inventory'=>true), array('escape' => false,'class'=>'blueBtn'));
		?>
		</span>
	</div>
	<div class="clr ht5"></div>


	<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td width="80" class="tdLabel2">Voucher. No.</td>
			<td width="138" class="tdLabel2"><input
				name="InventoryPurchaseDetail[vr_no]" type="text"
				class="textBoxExpnd validate[required]" id="vr_no" tabindex="1"
				value="<?php echo $data['InventoryPurchaseDetail']['vr_no']; ?>"
				readonly="true" /></td>
			<td width="17">&nbsp;</td>
			<td width="80" class="tdLabel2">Voucher. Dt.</td>
			<td width="140" class="tdLabel2"><table width="100%" cellpadding="0"
					cellspacing="0" border="0">
					<tr>
						<td width=""><input name="InventoryPurchaseDetail[vr_date]"
							type="text" class="textBoxExpnd date validate[required]"
							id="vr_date" tabindex="2"
							value="<?php echo $this->DateFormat->formatDate2Local($data['InventoryPurchaseDetail']['vr_date'],Configure::read('date_format'));  ?>"
							style="width: 60%;" readonly="true" /></td>

					</tr>
				</table>
			</td>

			<td width="75" class="tdLabel2">Party Code</td>
			<td width="90" class="tdLabel2"><input
				name="InventoryPurchaseDetail[party_code]" type="text"
				class="textBoxExpnd" id="party_code" tabindex="3"
				value="<?php echo $data['InventorySupplier']['code']; ?>"
				readonly="true" /></td>
			<td width="50">&nbsp;</td>
			<td width="80" class="tdLabel2">Party Name</td>
			<td width="340" class="tdLabel2"><input
				name="InventoryPurchaseDetail[party_name]" type="text"
				class="textBoxExpnd  validate[required]" id="party_name"
				tabindex="4"
				value="<?php echo $data['InventorySupplier']['name']; ?>"
				style="width: 86%" readonly="true" /></td>

			<td width="50" class="tdLabel2">Bill No.</td>
			<td width="60" class="tdLabel2"><input
				name="InventoryPurchaseDetail[bill_no]" type="text"
				class="textBoxExpnd validate[required]" id="bill_no" tabindex="5"
				value="<?php echo $data['InventoryPurchaseDetail']['bill_no']; ?>"
				readonly="true" /></td>
			<td>&nbsp;</td>
		</tr>
	</table>

	<div class="clr ht5"></div>
	<table width="100%" cellpadding="0" cellspacing="1" border="0"
		class="tabularForm" id="billDetailTable">
		<tr>
			<th width="10" align="center" valign="top"
				style="text-align: center;">Sr. No.</th>
			<th width="30" align="center" valign="top"
				style="text-align: center;">Item Code</th>
			<th width="70" align="center" valign="top" style="text-align: center;">Item
				Name</th>
			<th width="50" align="center" valign="top"
				style="text-align: center;">Manufacturer</th>
			<th width="20" align="center" valign="top"
				style="text-align: center;">Pack</th>
			<th width="50" valign="top" style="text-align: center;">Batch No.</th>
			<th width="60" valign="top" style="text-align: center;">Expiry Date</th>
			<th width="40" valign="top" style="text-align: center;">MRP</th>
			<th width="20" valign="top" style="text-align: center;">Tax (%)</th>
			<th width="40" valign="top" style="text-align: center;">Price</th>
			<th width="30" valign="top" style="text-align: center;">Qty</th>
			<th width="60" valign="top" style="text-align: center;">Amount</th>
		</tr>
		<?php
		$grandTotal=0;
		$itemObj = Classregistry::init('PharmacyItem');
		$count = 1;
		foreach($data['InventoryPurchaseItemDetail'] as $key=>$value){
				$item = $itemObj->find('first',array('conditions' =>array('PharmacyItem.id' => $value['item_id'])));
				?>
		<tr id="row1">
			<td align="center" valign="middle" class="sr_number"><?php echo $count;?>
			</td>
			<td align="center" valign="middle"><input name="item_code[]"
				id="item_code" type="text" class="textBoxExpnd" tabindex="6"
				value="<?php echo $item['PharmacyItem']['item_code'];?>"
				style="width: 80%;" fieldNo="" /></td>

			<td align="center" valign="middle"><input name="item_name[]"
				id="item_name" type="text" class="textBoxExpnd" tabindex="6"
				value="<?php echo $item['PharmacyItem']['name'];?>"
				style="width: 90%;" fieldNo="" readonly="true" /></td>
			<td align="center" valign="middle"><input name="manufacturer[]"
				id="manufacturer" type="text" class="textBoxExpnd" tabindex="6"
				value="<?php echo $item['PharmacyItem']['manufacturer'];?>"
				style="width: 90%;" fieldNo="" readonly="true" /></td>
			<td align="center" valign="middle"><input name="pack[]"
				id="pack_item_name" type="text" class="textBoxExpnd " tabindex="7"
				value="<?php echo $item['PharmacyItem']['pack'];?>"
				style="width: 90%;text-align: right;" readonly="true" /></td>
			<td align="center" valign="middle"><input name="batch_number[]"
				id="batch_number" type="text" class="textBoxExpnd" tabindex="8"
				value="<?php echo $value['batch_no'];?>" style="width: 90%;"
				readonly="true" /></td>

			<td align="center" valign="middle"><input name="expiry_date[]"
				id="expiry_date" type="text" class="textBoxExpnd" tabindex="9"
				value="<?php echo $this->DateFormat->formatDate2Local($value['expiry_date'],Configure::read('date_format'))?>"
				style="width: 90%;text-align: center;" readonly="true" /></td>

			<td valign="middle" style="text-align: center;"><input name="mrp[]"
				type="text" class="textBoxExpnd" tabindex="10"
				value="<?php echo $value['mrp'];?>" id="mrp" style="width: 90%;text-align: right;"
				readonly="true" /></td>

			<td valign="middle" style="text-align: center;"><input name="tax[]"
				type="text" class="textBoxExpnd validate[required,number]"
				tabindex="12" value="<?php echo $value['tax'];?>" id="tax"
				style="width: 90%;text-align: right;" readonly="true" /></td>

			<td valign="middle" style="text-align: center;"><input name="rate[]"
				type="text" class="textBoxExpnd " tabindex="11"
				value="<?php echo $value['price'];?>" id="rate" style="width: 90%;"
				readonly="true" /></td>
			<td valign="middle" ><input name="qty[]" 
				type="text"  class="textBoxExpnd quantity validate[required,number]"
				tabindex="12" value="<?php echo $value['qty'];?>" id="qty"
				style="width: 90%;text-align: right;" fieldNo="" readonly="true" /></td>
			<?php
			$qty = (int)$value['qty'];
			$tax = (float)$value['tax'];
			$sale_price = (float)$value['price'];
			$taxamount = (($qty*$sale_price)*$tax)/100;
			$total = (($qty*$sale_price)+$taxamount);
			$grandTotal = $total+$grandTotal;
			?>

			<td valign="middle" style="text-align: center;"><input name="value[]"
				type="text" class="textBoxExpnd value" id="value" tabindex="13"
				value="<?php echo number_format($total,2);?>" style="width: 90%;"
				readonly="true" /></td>
		</tr>

		<?php
		$count++;
		}
		?>
	</table>

	<div class="clr ht5"></div>
	<div class="clr ht5"></div>
	<div class="clr ht5"></div>
	<div class="clr ht5"></div>
	<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<tr>
			<td width="25">&nbsp;</td><!-- CST: is remopved -->
			<td width="50" id='cst'><?php echo $data['InventoryPurchaseDetail']['cst']; ?>
			</td>
			<td width="100">&nbsp;</td>
			<td width="30" align="right">Tax:&nbsp;</td>
			<td width="12" align="right"><?php echo $data['InventoryPurchaseDetail']['tax']; ?>%</td>
			<?php
			if(!empty($data['InventoryPurchaseDetail']['tax'])){
                                    $tax = (float)$data['InventoryPurchaseDetail']['tax'];
                                    $tax_amount = ($grandTotal*$tax)/100;
                                    $grandTotal = $grandTotal+$tax_amount;

                                }
                                ?>
			<td width="30" align="right">Total Amount:&nbsp;</td>
			<td width="50" align="right"><span id="total_amount"><?php echo $this->Number->currency(($grandTotal)); ?>
			</span></td>

		</tr>
	</table>
	<div class="clr ht5"></div>
	<div class="clr ht5"></div>
	<table id="d-type" width="100%">
		<tr>
			<td width="100">Payment Mode:&nbsp;</td>
			<td width="50" id='payment_mode'><?php echo ucfirst($data['InventoryPurchaseDetail']['payment_mode']); ?>
			</td>

			<?php
			if($data['InventoryPurchaseDetail']['payment_mode']=="credit"){
						if($data['InventoryPurchaseDetail']['extra_amount_type']==0){
							$grandTotal = $grandTotal+$data['InventoryPurchaseDetail']['extra_amount'];
							?>
			<td width="150"><span class="discount_type_label">Additional </span>
				Amount:<span id="extra_amount"><?php echo (trim($data['InventoryPurchaseDetail']['extra_amount']) == "" ? "0.00" : round($data['InventoryPurchaseDetail']['extra_amount'],2)); ?>
			</span>
			</td>
			<?php
						}else{
							$grandTotal = $grandTotal+(($data['InventoryPurchaseDetail']['extra_amount']*$grandTotal)/100);

							?>
			<td width="150"><span class="discount_type_label">Additional </span>
				Percentage: <span id="extra_amount"><?php echo (trim($data['InventoryPurchaseDetail']['extra_amount']) == "" ? "0.00" : round($data['InventoryPurchaseDetail']['extra_amount'],2)); ?>
			</span>%</td>
			<?php
						}
					}else{
						if($data['InventoryPurchaseDetail']['extra_amount_type']==0){
							$grandTotal = $grandTotal-$data['InventoryPurchaseDetail']['extra_amount'];

							?>
			<td width="150"><span class="discount_type_label">Discount By </span>
				Amount: <span id="extra_amount"><?php echo (trim($data['InventoryPurchaseDetail']['extra_amount']) == "" ? "0.00" : round($data['InventoryPurchaseDetail']['extra_amount'],2)); ?>
			</span></td>
			<?php
						}else{

							$grandTotal = $grandTotal-(((float)$data['InventoryPurchaseDetail']['extra_amount']*(float)$grandTotal)/100);

							?>
			<td width="150"><span class="discount_type_label">Discount By </span>
				Percentage: <span id="extra_amount"><?php echo (trim($data['InventoryPurchaseDetail']['extra_amount']) == "" ? "0.00" : round($data['InventoryPurchaseDetail']['extra_amount'],2)); ?>
			</span>%</td>
			<?php
						}


					}

					?>

			<td width="200"></td>
			<td width="100"></td>

			<td width="78">Grand Total:</td>
			<td align="right" width="100"><span id="grand_total"><?php  echo $this->Number->currency(($grandTotal));?>
			</span></td>
		</tr>
	</table>


	<div class="clr ht5"></div>
	<div class="clr ht5"></div>
	<div align="right">
		<?php
		$url = Router::url(array("controller" => "pharmacy", "action" => "inventory_print_view",'PurchaseReceipt',$data['InventoryPurchaseDetail']['id'],'inventory'=>true));
		?>

		<input name="print" type="button" value="Print" class="blueBtn"
			tabindex="36"
			onclick="window.open('<?php echo $url;?>','Print','fullscreen=no,height=800px,width=800px,location=0,titlebar=no,toolbar=no',true );" />

	</div>







	<script>
function openPrintWindow(){
window.open('<?php echo Router::url(array("controller" => "pharmacy", "action" => "inventory_print_view",'PurchaseReceipt','inventory'=>true));?>/'+itemID,'Print','fullscreen=no,height=800px,width=800px,location=0,titlebar=no,toolbar=no',true );

}
 $('#vr_no').live('focus',function()
			  {
			    $(this).autocomplete(
		"<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "purchase_details",'true','vr_no',"inventory" => true,"plugin"=>false)); ?>",
		{
			matchSubset:1,
			matchContains:1,
			cacheLength:10,
			onItemSelect:selectItem,

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

		}
	);
});

	/* for auto populate the data */
function selectItem(li) {
	if( li == null ) return alert("No match!");
		itemID = li.extra[0];
		$("#print").show();
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
			$("#extra_amount").html(Math.round(details.InventoryPurchaseDetail.extra_amount));

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
			$("#grand_total").html((total).toFixed(2));

	});
}
function showItemDisplay(itemsDetails){
	 var number_of_field = 1;
	 var itemDetail ='';
	 var total =0;
	 $("#item-row").find("tr:gt(1)").remove();
	$.each(itemsDetails.InventoryPurchaseItemDetail, function() {
	 	 itemDetail = getItemDetail(this.item_id);
		 if($("#row'+number_of_field+'")){
				$("#row"+number_of_field).remove();
			}
		 var field = '';
		 field += '<tr id="row'+number_of_field+'"><td align="center" valign="middle" class="sr_number">'+number_of_field+'</td>';
		 field += '<td align="center" valign="middle"><input name="item_code[]" id="item_code'+number_of_field+'" type="text" class="textBoxExpnd"  tabindex="6" value="'+itemDetail.PharmacyItem.item_code+'" style="width:80%;" fieldNo="'+number_of_field+'"/></td>';
		  field += '<td align="center" valign="middle"><input name="item_name[]" id="item_name'+number_of_field+'" type="text" class="textBoxExpnd"  tabindex="6" value="'+itemDetail.PharmacyItem.name+'" style="width:80%;" fieldNo="'+number_of_field+'"/></td>';

		field += '<td align="center" valign="middle"><input name="pack[]" id="pack_item_name'+number_of_field+'" type="text" class="textBoxExpnd "  tabindex="7"  value="'+itemDetail.PharmacyItem.pack+'"  style="width:80%;" readonly="true"/></td>';

		field += '<td align="center" valign="middle"><input name="batch_number[]" id="batch_number'+number_of_field+'" type="text" class="textBoxExpnd "  tabindex="8" value="'+this.batch_no+'"  style="width:80%;" readonly="true"/></td>';

		field += '<td valign="middle" style="text-align:center;"><input name="expiry_date[]" type="text" id="expiry_date'+number_of_field+'" class="textBoxExpnd" tabindex="9" value="'+this.expiry_date+'" style="width:65%;" readonly="true"/></td>';

		field += ' <td valign="middle" style="text-align:center;"><input name="qty[]" type="text" class="textBoxExpnd"  tabindex="10"  value="'+this.qty+'" id="qty'+number_of_field+'" style="width:70%;" fieldNo="'+number_of_field+'" readonly="true"/></td>';
		field += '<td valign="middle" style="text-align:center;"><input name="free[]" type="text" class="textBoxExpnd"  tabindex="11" value="" id="free'+number_of_field+'" value="'+this.free+'" style="width:80%;" readonly="true"/></td>';

		  	  field += '<td valign="middle" style="text-align:center;"><input name="tax[]" type="text" class="textBoxExpnd validate[required,custom[number]] tax"  tabindex="11" value="'+this.tax+'" id="tax'+number_of_field+'"  style="width:80%;" fieldNo="'+number_of_field+'" readonly="true"/></td>';

		field += '<td valign="middle" style="text-align:center;"><input name="mrp[]" type="text" class="textBoxExpnd"  tabindex="12" value="'+itemDetail.PharmacyItemRate.mrp+'" id="mrp'+number_of_field+'" style="width:80%;" readonly="true"/></td>';

	   field += '<td valign="middle" style="text-align:center;"><input name="price[]" type="text" class="textBoxExpnd"  tabindex="13" value="'+itemDetail.PharmacyItemRate.purchase_price+'" id="price'+number_of_field+'" style="width:80%;" readonly="true" /></td>';
	  		 var qty = parseFloat(this.qty);
			var salePrice = parseFloat(itemDetail.PharmacyItemRate.purchase_price);
			var tax = ((qty*salePrice)*parseFloat(this.tax))/100;
			var Subtotal = salePrice*qty+tax;
	   field += ' <td valign="middle" style="text-align:center;"><input name="value[]" type="text" class="textBoxExpnd" id="value'+number_of_field+'"  tabindex="14" value="'+Subtotal.toFixed(2)+'"  style="width:80%;" readonly="true"/></td> </tr>    ';

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
	 $("#total_amount").html((total+tax).toFixed(2));
	 return total;
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
</script>
</div>
