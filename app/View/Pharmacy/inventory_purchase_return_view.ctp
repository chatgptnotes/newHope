
<div
	style="padding: 10px">
	<style>
.tdLabel2 {
	font-size: 12px;
}
</style>

	<?php 
	echo $this->Html->script('jquery.autocomplete_pharmacy');
	echo $this->Html->css('jquery.autocomplete.css');


	?>

	<?php
	if(isset($data)){
?>
	<div class="inner_title">
		<h3>Purchase Return View</h3>
		<span><?php
		echo $this->Html->link(__('Back'), array('action' => 'purchase_return' ,'inventory'=>true), array('escape' => false,'class'=>'blueBtn'));
		?> </span>
	</div>
	<div class="clr ht5"></div>
	<input type="hidden" value="1" id="no_of_fields" />

	<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>

			<td width="75" class="tdLabel2">Party Code</td>
			<td width="100" class="tdLabel2"><input
				name="InventoryPurchaseDetail[party_code]" type="text"
				class="textBoxExpnd" id="party_code" tabindex="3"
				value="<?php  echo $data['InventorySupplier']['code'] ;?>"
				readonly="true" /></td>
			<td width="50">&nbsp;</td>
			<td width="80" class="tdLabel2">Party Name</td>
			<td width="120" class="tdLabel2"><input
				name="InventoryPurchaseDetail[party_name]" type="text"
				class="textBoxExpnd  validate[required]" id="party_name"
				tabindex="4"
				value="<?php  echo $data['InventorySupplier']['name'] ;?>"
				style="width: 80%" readonly="true" /></td>

		</tr>
	</table>
	<div class="clr ht5"></div>

	<table width="100%" cellpadding="0" cellspacing="1" border="0"
		class="tabularForm" id="item-row">
		<tr>

			<th width="40" align="center" valign="top"
				style="text-align: center;">Sr. No.</th>
			<th width="120" align="center" valign="top"
				style="text-align: center;">Product Code</th>
			<th width="100" align="center" valign="top"
				style="text-align: center;">Product Name</th>
			<th width="80" align="center" valign="top"
				style="text-align: center;">Manufacturer</th>
			<th width="60" align="center" valign="top"
				style="text-align: center;">Pack</th>
			<th width="100" valign="top" style="text-align: center;">Batch No.</th>
			<th width="120" align="center" valign="top"
				style="text-align: center;">Expiry Date</th>
			<th width="50" valign="top" style="text-align: center;">Qty</th>



			<th width="60" valign="top" style="text-align: center;">Price</th>
			<th width="50" valign="top" style="text-align: center;">Tax</th>
			<th width="80" valign="top" style="text-align: center;">Amount</th>

		</tr>
		<?php
		$grandTotal=0;
		$itemObj = Classregistry::init('PharmacyItem');
		$count = 1;
		foreach($data['InventoryPurchaseReturnItem'] as $key=>$value){
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
				style="width: 80%;" fieldNo="" readonly="true" /></td>
			<td align="center" valign="middle"><input name="manufacturer[]"
				id="manufacturer" type="text" class="textBoxExpnd" tabindex="6"
				value="<?php echo $item['PharmacyItem']['manufacturer'];?>"
				style="width: 80%;" fieldNo="" readonly="true" /></td>




			<td align="center" valign="middle"><input name="pack[]"
				id="pack_item_name" type="text" class="textBoxExpnd " tabindex="7"
				value="<?php echo $item['PharmacyItem']['pack'];?>"
				style="width: 80%;" readonly="true" /></td>
			<td align="center" valign="middle"><input name="batch_number[]"
				id="batch_number" type="text" class="textBoxExpnd" tabindex="8"
				value="<?php echo $value['batch_no'];?>" style="width: 80%;"
				readonly="true" /></td>

			<td align="center" valign="middle"><input name="expiry_date[]"
				id="expiry_date" type="text" class="textBoxExpnd" tabindex="9"
				value="<?php echo $this->DateFormat->formatDate2Local($value['expiry_date'],Configure::read('date_format'));?>"
				style="width: 80%;" readonly="true" /></td>

			<td valign="middle" style="text-align: center;"><input name="qty[]"
				type="text" class="textBoxExpnd" tabindex="10"
				value="<?php echo $value['qty'];?>" id="qty" style="width: 80%;"
				readonly="true" /></td>
			<td valign="middle" style="text-align: center;"><input name="rate[]"
				type="text" class="textBoxExpnd " tabindex="11"
				value="<?php echo $item['PharmacyItemRate']['purchase_price'];?>"
				id="rate" style="width: 80%;" readonly="true" /></td>

			<td valign="middle" style="text-align: center;"><input name="tax[]"
				type="text" class="textBoxExpnd validate[required,number]"
				tabindex="12" value="<?php echo $value['tax'];?>" id="tax"
				style="width: 80%;" readonly="true" /></td>


			<?php
			$qty = (int)$value['qty'];
			$tax = (double)$value['tax'];
			$sale_price = (double)$item['PharmacyItemRate']['purchase_price'];
			$taxamount = (($qty*$sale_price)*$tax)/100;
			$total = (($qty*$sale_price)+$taxamount);
			$grandTotal = $total+$grandTotal;
			?>

			<td valign="middle" style="text-align: center;"><input name="value[]"
				type="text" class="textBoxExpnd value" id="value" tabindex="13"
				value="<?php echo $total;?>" style="width: 80%;" readonly="true" />
			</td>
		</tr>

		<?php
		$count++;
		}
		?>
	</table>

	<div class="clr ht5"></div>
	<table cellpadding="0" cellspacing="0" border="0" align="right">

		<td width="660">&nbsp;</td>
		<td width="100" class="tdLabel2">Total Amount :</td>
		<td><span id="total_amount"><?php echo  $this->Number->currency(number_format($grandTotal,2));?>
		</span></td>
		</tr>
	</table>
	<div class="clr ht5"></div>
	<div class="clr ht5"></div>
	<div align="right">
		<?php
		$url = Router::url(array("controller" => "pharmacy", "action" => "inventory_print_view",'InventoryPurchaseReturn',$data['InventoryPurchaseReturn']['id'],'inventory'=>true));
		?>

		<input name="print" type="button" value="Print" class="blueBtn"
			tabindex="36"
			onclick="window.open('<?php echo $url;?>','Print','fullscreen=no,height=800px,width=800px,location=0,titlebar=no,toolbar=no',true );" />

	</div>
	<?php
}else{
?>
	<div class="inner_title">
		<h3>Purchase Return View</h3>
		<span>
		<?php
			echo $this->Html->link(__('Back'), array('action' => 'index' ,'inventory'=>true), array('escape' => false,'class'=>'blueBtn'));
		?>
		</span>
	</div>
	<div class="clr ht5"></div>
	<input type="hidden" value="1" id="no_of_fields" />

	<table width="90%"  align="center" cellpadding="0" cellspacing="0" border="0">
		<tr>

			<td width="5" class="tdLabel2">Party Code</td>
			<td width="100" class="tdLabel2"><input
				name="InventoryPurchaseDetail[party_code]" type="text"
				class="textBoxExpnd" id="party_code" tabindex="3" value=""
				onkeyup="checkIsItemRemoved(this)" /></td>
			<td width="50">&nbsp;</td>
			<td width="8" class="tdLabel2">Party Name</td>
			<td width="120" class="tdLabel2"><input
				name="InventoryPurchaseDetail[party_name]" type="text"
				class="textBoxExpnd  validate[required]" id="party_name"
				tabindex="4" value="" style="width: 80%"
				onkeyup="checkIsItemRemoved(this)" /></td>

		</tr>
	</table>
	<div class="clr ht5"></div>
	<?php echo $this->Form->create('InventoryPurchaseReturn');?>
	<table width="90%" align="center" cellpadding="0" cellspacing="1" border="0"
		class="tabularForm" id="item-row">
		<tr>

			<th width="5%" align="center" valign="top"
				style="text-align: center;">Sr. No.</th>
			<th width="20%" align="center" valign="top"
				style="text-align: center;">Date</th>
			<th width="20%" align="center" valign="top" style="text-align: center;">Total
				(<?php echo $this->Session->read('Currency.currency_symbol') ; ?>)
			</th>
			<th width="10%" align="center" valign="top"
				style="text-align: center;">Details</th>


		</tr>
		<tr id="initialRow">
		
		
		<tr id="row">
			<td align="center" valign="middle" class="sr_number">1</td>
			<td align="center" valign="middle" class="sr_number"></td>
			<td align="center" valign="middle"></td>

			<td align="center" valign="middle"></td>



		</tr>
	</table>


<!-- 	<p class="ht5"></p> -->
<!-- 	<div align="right"> -->
		<?php
// 		echo $this->Html->link(__('Back'), array('action' => 'index' ,'inventory'=>true), array('escape' => false,'class'=>'blueBtn'));
// 		?>
<!-- 	</div> -->

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

<?php
}?>

<script>

function checkIsItemRemoved(obj){

	if($.trim(obj.value.length)==0){
			$(obj).val("");
			$("#party_code").val("");
		 var number_of_field = 1;
		 $("#item-row").find("tr:gt(1)").remove();
		var field="";
		  	 field += '<tr id="row'+number_of_field+'"><td align="center" valign="middle" class="sr_number">'+number_of_field+'</td>';
		    field += '<td align="center" valign="middle" class="sr_number" width="100"></td>';
           field += '<td align="center" valign="middle"></td>';

		   field += '<td align="center" valign="middle"></td>';

           field += '<td align="center" valign="middle"></td>';

           field += '</tr>    ';
		$("#no_of_fields").val(number_of_field);
		$("#item-row").append(field);
		$("#total_amount").html("0");
	}

}
 $('#party_name').live('focus',function()  {
	$(this).autocomplete(
			"<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","InventorySupplier","name","0","yes", "admin" => false,"plugin"=>false)); ?>",
			{
				matchSubset:1,
				matchContains:1,
				cacheLength:10,
				onItemSelect:selectSupplier,
				extraParams: {allSupplier:'1' },
				autoFill:false
			}
		);

	}
		);
  $('#party_code').live('focus',function()  {
	$(this).autocomplete(
			"<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","InventorySupplier","code","0","yes", "admin" => false,"plugin"=>false)); ?>",
			{
				matchSubset:1,
				matchContains:1,
				cacheLength:10,
				onItemSelect:selectSupplier,
				extraParams: {allSupplier:'1' },
				autoFill:false
			}
		);

	}
		);

	/* for auto populate the data */
function selectSupplier(li) {
	if( li == null ) return alert("No match!");
		var supplierId = li.extra[0];

			$.ajax({
			  type: "get",
			  url: "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "view_supplier","inventory" => true,"plugin"=>false)); ?>/"+supplierId+"/true",

			}).done(function( msg ) {
				var supplier = jQuery.parseJSON(msg);
				$("#party_name").val(supplier.InventorySupplier.name);
			    $("#party_code").val(supplier.InventorySupplier.code);

		});

		loadData(supplierId);
}

	function loadData(supplierId){
			$.ajax({
			  type: "POST",
			  url: "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "purchase_return_details","inventory" => true,"plugin"=>false)); ?>",
			  data: "supplierId="+supplierId,
			}).done(function( msg ) {
				var purchaseReturnDetails = jQuery.parseJSON(msg);
				$("#item-row").find("tr:gt(1)").remove();
				$("#no_of_fields").val("1");
				if(purchaseReturnDetails!="")
					addFields(purchaseReturnDetails);
				else{
					$("#total_amount").html("0");
				 	$("#item-row").find("tr:gt(1)").remove();
					 field = '<tr id="row1"><td align="center" valign="middle" class="sr_number" colspan="12">No Data Found.</td></tr>';
					$("#item-row").append(field);
					}

		});

	}

function addFields(returnDetails){
	  var number_of_field = parseInt($("#no_of_fields").val());
      var field = '';
	   $("#item-row").find("tr:gt(1)").remove();
	  $.each(returnDetails, function() {
		  	 field += '<tr id="row'+number_of_field+'"><td align="center" valign="middle" class="sr_number">'+number_of_field+'</td>';
		    field += '<td align="center" valign="middle" class="sr_number">'+this.InventoryPurchaseReturn.create_time+'</td>';
           field += '<td align="center" valign="middle">'+this.InventoryPurchaseReturn.total_amount+'</td>';

		   field += '<td align="center" valign="middle"><a href="<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "inventory_purchase_return_item_details","inventory" => true,"plugin"=>false)); ?>/'+this.InventoryPurchaseReturn.id+'" id="viewDetail'+number_of_field+'" class="fancy" ><img title="View Item" alt="View Item" src="/drmHope/img/icons/view-icon.png"></a></td>';



           field += '</tr>    ';

      	number_of_field = number_of_field+1;


		$("#no_of_fields").val(number_of_field);
	 });
	 	$("#item-row").append(field);


}


</script>
</div>
