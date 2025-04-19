
<div style="padding: 10px">
	<div class="inner_title">
		<h3>OT Pharmacy Return View</h3>
		<span><?php

		//echo $this->Html->link(__('Back'), array('action' => 'pharmacy_details' ,'sales_return'), array('escape' => false,'class'=>'blueBtn'));
		?>
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

$customer_name = $data['OtPharmacySalesReturn']['customer_name'];

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
			<input name="OtPharmacySalesReturn[person_id]" id="person_id"
				value="" type="hidden" /></td>

			<td>&nbsp;</td>
		</tr>
	</table>
	<div class="clr ht5"></div>
	<table width="100%" cellpadding="0" cellspacing="1" border="0"
		class="tabularForm" id="billDetailTable">
		<tr>
			<th width="30" align="center" valign="top" style="text-align: center;">Sr. No.</th>
			<th width="70" align="center" valign="top" style="text-align: center;">Item Code</th>
			<th width="120" align="center" valign="top" style="text-align: center;">Item Name</th>
			<th width="60" align="center" valign="top" style="text-align: center;">Pack</th>
				
			<th width="60" valign="top" style="text-align: center;">Batch No.</th>
			<th width="60" valign="top" style="text-align: center;">Expiry Date</th>
			<th width="60" valign="top" style="text-align: center;">MRP</th>

			<th width="60" valign="top" style="text-align: center;">Price</th>
			<th width="50" valign="top" style="text-align: center;">Qty</th>
			<th width="80" valign="top" style="text-align: center;">Amount</th>
		</tr>
		<?php
		$grandTotal=0;
		$itemObj = Classregistry::init('OtPharmacyItem');
		$count = 1; 
		foreach($data['OtPharmacySalesReturnDetail'] as $key=>$value){
				$item = $itemObj->find('first',array('conditions' =>array('OtPharmacyItem.id' => $value['item_id'])));
				?>
		<tr id="row1">
			<td align="center" valign="middle" class="sr_number"><?php echo $count;?>
			</td>
			<td align="center" valign="middle">
				<lable name="item_code[]" id="item_code" ><?php echo $item['OtPharmacyItem']['item_code'];?></lable>
			</td>

			<td align="center" valign="middle">
				<lable name="item_name[]" id="item_name" ><?php echo $item['OtPharmacyItem']['name'];?></lable>
			</td>

			<td align="center" valign="middle">
				<lable name="pack[]" id="pack_item_name"><?php echo $item['OtPharmacyItem']['pack'];?></lable>
			</td>
			<td align="center" valign="middle">
				<lable name="batch_number[]" id="batch_number" ><?php echo $value['batch_number'];?></lable>
			</td>

			<td align="center" valign="middle">
				<lable name="expiry_date[]"  id="expiry_date" type="text">	
				<?php echo $this->DateFormat->formatDate2Local($item['OtPharmacyItemRate'][$key]['expiry_date'],Configure::read('date_format'));?>
				</lable>
			</td>
			<td valign="middle" style="text-align: center;">
				<lable name="mrp[]" id="mrp"><?php 
					if(!empty($value['mrp'])){
						echo number_format($value['mrp']/*/(int)$value['pack']*/,2);
					}else{
						echo number_format($item['OtPharmacyItemRate']['mrp']/*/(int)$item['PharmacyItemRate']['pack']*/,2);
					}?></lable>
			</td>


			<td valign="middle" style="text-align: center;">
				<lable name="rate[]" ><?php 
				if(!empty($value['sale_price'])){
						echo number_format($value['sale_price']/(int)$value['pack'],2);
					}else{
						echo number_format($item['OtPharmacyItemRate']['sale_price']/(int)$item['OtPharmacyItemRate']['pack'],2);
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
				$sale_price = (double)$item['OtPharmacyItemRate']['sale_price'];
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
		?>
	</table>

	<div class="clr ht5"></div>
	<table cellpadding="0" cellspacing="0" border="0">
		<td width="800">&nbsp;</td>
		<td width="100" class="tdLabel2">Total Amount :</td>
		<td><span id="total_amount"><?php echo number_format(round($grandTotal),2);?>
		</span></td>
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
