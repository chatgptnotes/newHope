
<div style="padding: 10px">
	<div class="inner_title">
		<h3>View Sales Return</h3>
		<span><?php
		if(empty($this->params['pass'][2])){
			echo $this->Html->link(__('Back'), array('action' => 'pharmacy_details' ,'inventory'=>true,'sales_return'), array('escape' => false,'class'=>'blueBtn'));
		}?>
		</span>
	</div>

	<?php
	echo $this->Html->script(array('jquery-ui-1.8.16.custom.min','jquery.ui.widget.js','jquery.ui.mouse.js','jquery.ui.core.js','ui.datetimepicker.3.js','permission.js'));
	echo $this->Html->css(array('datePicker.css','jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','internal_style.css'));

	echo $this->Html->script('jquery.autocomplete_pharmacy');
	echo $this->Html->css('jquery.autocomplete.css');
	echo $this->Html->script('jquery.fancybox-1.3.4');
	echo $this->Html->css('jquery.fancybox-1.3.4.css');
	?>
	<style>
.tdLabel2 {
	font-size: 12px;
}
</style>
	<?php

	if(!isset($data['Patient']['id'])){

$customer_name = $data['InventoryPharmacySalesReturn']['customer_name'];

}else{
$customer_name  = $data['Patient']['lookup_name'];
}
?>
	<div class="clr ht5"></div>
	<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>


			<td width="10">&nbsp;</td>
			<td width="150" class="tdLabel2">Patient Code (Customer) : </td>
			<td width="200" class="tdLabel2">
				<lable name="party_code" id="party_code" ><?php echo $data['Patient']['patient_id']; ?></lable>
			</td>
			<td width="10">&nbsp;</td>
			<td width="150" class="tdLabel2">Patient Name(Customer) : </td>
			<td width="200" class="tdLabel2">
			<lable name="party_name" id="party_name" ><?php echo $customer_name; ?></lable>
			<input name="InventoryPharmacySalesReturn[person_id]" id="person_id"
				value="" type="hidden" /></td>

			<td>&nbsp;</td>
		</tr>
	</table>
	<div class="clr ht5"></div>
	<table width="100%" cellpadding="0" cellspacing="1" border="0"
		class="tabularForm" id="billDetailTable">
		<tr>
			<th width="30" align="center" valign="top"
				style="text-align: center;">Sr. No.</th>
			<th width="70" align="center" valign="top"
				style="text-align: center;">Item Code</th>
			<th width="120" align="center" valign="top" style="text-align: center;">Item
				Name</th>
			<th width="120" align="center" valign="top"
				style="text-align: center;">Manufacturer</th>
			<th width="60" align="center" valign="top"
				style="text-align: center;">Pack</th>
				
			<th width="60" valign="top" style="text-align: center;">Batch No.</th>
			<th width="60" valign="top" style="text-align: center;">Expiry Date</th>
			<th width="60" valign="top" style="text-align: center;">MRP</th>

			<th width="60" valign="top" style="text-align: center;">Price</th>
			<th width="50" valign="top" style="text-align: center;">Qty</th>
			<th width="80" valign="top" style="text-align: center;">Amount</th>
		</tr>
		<?php
		$grandTotal=0;
		$itemObj = Classregistry::init('PharmacyItem');
		$count = 1; 
		foreach($data['InventoryPharmacySalesReturnsDetail'] as $key=>$value){
				$item = $itemObj->find('first',array('conditions' =>array('PharmacyItem.id' => $value['item_id'])));
				
				/** Added by Mrunal generic name for Item In HOPE- 04-06-2016*/
				if (isset($item['PharmacyItem']['generic'])) {
					$itemName = $item['PharmacyItem']['generic'];
				} else {
					$itemName = $item['PharmacyItem']['name'];
				}
				
				?>
		<tr id="row1">
			<td align="center" valign="middle" class="sr_number"><?php echo $count;?>
			</td>
			<td align="center" valign="middle">
				<lable name="item_code[]" id="item_code" ><?php echo $item['PharmacyItem']['item_code'];?></lable>
			</td>

			<td align="center" valign="middle">
				<lable name="item_name[]" id="item_name" ><?php echo $itemName;?></lable>
			</td>
			<td align="center" valign="middle">
				<lable name="manufacturer[]" id="manufacturer" ><?php echo $item['PharmacyItem']['manufacturer'];?></lable>
			</td>
			<td align="center" valign="middle">
				<lable name="pack[]" id="pack_item_name"><?php echo $item['PharmacyItem']['pack'];?></lable>
			</td>
			<td align="center" valign="middle">
				<lable name="batch_number[]" id="batch_number" ><?php echo $value['batch_no'];?></lable>
			</td>

			<td align="center" valign="middle">
				<lable name="expiry_date[]"  id="expiry_date" type="text">
				<?php echo $this->DateFormat->formatDate2Local($item['PharmacyItemRate']['expiry_date'],Configure::read('date_format'));?>
				</lable>
			</td>
			<td valign="middle" style="text-align: center;">
				<lable name="mrp[]" id="mrp"><?php 
					if(!empty($value['mrp'])){
						echo number_format($value['mrp']/*/(int)$value['pack']*/,2);
					}else{
						echo number_format($item['PharmacyItemRate']['mrp']/*/(int)$item['PharmacyItemRate']['pack']*/,2);
					}?></lable>
			</td>


			<td valign="middle" style="text-align: center;">
				<lable name="rate[]" ><?php 
				if(!empty($value['sale_price'])){
						echo number_format($value['sale_price']/(int)$value['pack'],2);
					}else{
						echo number_format($item['PharmacyItemRate']['sale_price']/(int)$item['PharmacyItemRate']['pack'],2);
					}?></lable>
			</td>
			<td valign="middle" style="text-align: center;">
			<?php $packType = ($value['qty_type']=="Tab")?"MSU":"";?>
				<lable name="qty[]" id="qty"><?php echo $value['qty']." ".$packType;?></lable>
			</td>
			<?php
			$qty = (int)$value['qty'];
			if(!empty($value['sale_price'])){
				$sale_price = (double)$value['sale_price'];
			}else{
				$sale_price = (double)$item['PharmacyItemRate']['sale_price'];
			}
			$total = ($qty*$sale_price) ;
			if($packType == "MSU"){
				$total = $qty*$sale_price/(int)$value['pack'];
			}
			$grandTotal = $total+$grandTotal;			
			?>

			<td valign="middle" style="text-align: center;">
				<lable name="value[]"  id="value" ><?php echo number_format($total,2);?></lable>
			</td>
		</tr>

		<?php
		$count++;
		}
		
		$totalDiscount = !empty($data['InventoryPharmacySalesReturn']['discount'])?$data['InventoryPharmacySalesReturn']['discount']:0;
		
		$getDiscountAmt=$grandTotal*($totalDiscount/100);		
		$netAmount = $grandTotal - round($getDiscountAmt);
		?>
	</table>

	<div class="clr ht5"></div>
	<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<td width="50%">&nbsp;</td>
		<td class="tdLabel2">Total Amount : <?php echo $this->Session->read('Currency.currency_symbol')." ".number_format($grandTotal,2);?></td>
		<td class="tdLabel2">Total Discount : <?php echo $this->Session->read('Currency.currency_symbol')." ".number_format(round($getDiscountAmt),2);?></td>
		<td class="tdLabel2">Net Amount : <?php echo $this->Session->read('Currency.currency_symbol')." ".number_format($netAmount,2);?></td>
		</tr>
	</table>
<!-- 	<div align="right"> -->
		<?php
// 		$url = Router::url(array("controller" => "pharmacy", "action" => "inventory_print_view",'InventoryPharmacySalesReturn',$data['InventoryPharmacySalesReturn']['id'],'inventory'=>true));
// 		?>

<!-- 		<input name="print" type="button" value="Print" class="blueBtn" -->
<!-- 			tabindex="36" 
			onclick="window.open('<?php echo $url;?>','Print','fullscreen=no,height=800px,width=800px,location=0,titlebar=no,toolbar=no',true );" />-->


<!-- 	</div> -->

</div>
