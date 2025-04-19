<div style="padding: 10px">
	<div class="inner_title">
		<h3>Sales View</h3>
		<span><?php

		//echo $this->Html->link(__('Back'), array('action' => 'pharmacy_details' ,'inventory'=>true,'sales'), array('escape' => false,'class'=>'blueBtn'));
		?>
		</span>
	</div>

	<?php

	echo $this->Html->script(array(
			'jquery-ui-1.8.16.custom.min','jquery.ui.widget.js','jquery.ui.mouse.js','jquery.ui.core.js','ui.datetimepicker.3.js','permission.js'));
	echo $this->Html->css(array('datePicker.css','jquery-ui-1.8.16.custom','jquery.ui.all.css','internal_style.css'));

	echo $this->Html->script('jquery.autocomplete_pharmacy');
	echo $this->Html->css('jquery.autocomplete.css');
	?>
	<style>
.tdLabel2 {
	font-size: 12px;
}
</style>
	<?php 

	if(!isset($data['Patient']['id'])){

$customer_name = $data['OtPharmacySalesBill']['customer_name'];

}else{
$customer_name  = $data['Patient']['lookup_name'];
}
?>
	<div class="clr ht5"></div>
	<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td width="10">&nbsp;</td>
			<td width="100" class="tdLabel2">Patient Code : </td>
			<td width="125" class="tdLabel2">
				<lable name="party_code" id="party_code"><?php echo $data['Patient']['patient_id']; ?></lable>
			</td>
			<td width="10">&nbsp;</td>
			<td width="113" class="tdLabel2">Patient Name : </td>
			<td width="125" class="tdLabel2">
				<lable name="party_name" class="party_name" id="party_name"><?php echo $customer_name; ?></lable>
			</td>
			<!--<td width="50">&nbsp;</td>
                        <td width="45" class="tdLabel2">Cash Credit</td>
                        <td width="80" class="tdLabel2"><input name="textfield6" type="text" class="textBoxExpnd validate[required]" id="textfield6" tabindex="5" value="<?php echo $data['OtPharmacySalesBill']['payment_mode']; ?>" readonly='true'/></td>-->
			<td width="10">&nbsp;</td>
			<td width="50" class="tdLabel2">Bill No. : </td>
			<td width="120" class="tdLabel2">
				<lable name="bill_no" id="bill_no" ><?php echo $data['OtPharmacySalesBill']['bill_code']; ?></lable>
			</td>
			<td width="10">&nbsp;</td>
			<td width="80" class="tdLabel2">Dr. Name : </td>
			<td width="140" class="tdLabel2">
				<lable type="text" id="doctorNameLable"><?php echo $data['DoctorProfile']['doctor_name']; ?></lable>
			</td>
		</tr>
	</table>
	<div class="clr ht5"></div>
	<table width="100%" cellpadding="0" cellspacing="1" border="0"
		class="tabularForm" id="billDetailTable">
		<tr>
			<th width="40" align="center" valign="top" style="text-align: center;">Sr. No.</th>
			<th width="50" align="center" valign="top" style="text-align: center;">Item Code</th>
			<th width="120" align="center" valign="top" style="text-align: center;">Item Name</th>
			<th width="60" align="center" valign="top" style="text-align: center;">Pack</th>
			<th width="60" valign="top" style="text-align: center;">Batch No.</th>
			<th width="60" valign="top" style="text-align: center;">Expiry Date</th> 
			<th width="60" valign="top" style="text-align: center;">MRP</th>
			<th width="60" valign="top" style="text-align: center;">Price</th>
			<th width="50" valign="top" style="text-align: center;">Quantity</th>
			<th width="80" valign="top" style="text-align: center;">Amount</th>
		</tr>
		<?php
		$grandTotal=0.00;
		$itemObj = Classregistry::init('OtPharmacyItem');
		$count = 1;
		foreach($data['OtPharmacySalesBillDetail'] as $key=>$value){
		$item = $itemObj->find('first',array('conditions' =>array('OtPharmacyItem.id' => $value['item_id']))); 
				?>
		<?php /* foreach($pharmacyRate as $itemRateDetail){
		 foreach($itemRateDetail as $key=>$detail){
		}
		 } */?>
		<tr id="row1">
			<td align="center" valign="middle" class="sr_number"><?php echo $count;?>
			</td>
			<td align="center" valign="middle">
				<lable name="item_code[]" id="item_code"  fieldNo=""><?php echo $item['OtPharmacyItem']['item_code'];?>
			</td>

			<td align="center" valign="middle">
				<lable name="item_name[]" id="item_name" fieldNo=""><?php echo $item['OtPharmacyItem']['name'];?>
			</td>

			<td align="center" valign="middle">
				<lable name="pack[]" id="pack_item_name"><?php echo $item['OtPharmacyItem']['pack'];?></lable>
			</td>
				
			<td align="center" valign="middle"><?php //debug($value);?>
				<lable name="batch_number[]" id="batch_number"><?php echo $value['batch_number'];?>
			</td>

			<td align="center" valign="middle">
				<lable name="expiry_date[]" id="expiry_date"><?php echo $this->DateFormat->formatDate2Local($value['expiry_date'],Configure::read('date_format'));?></lable>
			</td>  
			<?php 
			 	$packType = ($value['qty_type']=="Tab")?"Tabs":"";?>
			<?php
			$qty = (int)$value['qty']; 
			$itemRate = Classregistry::init('OtPharmacyItemRate');
			$rate = $itemRate->find('first',array('conditions' =>array('OtPharmacyItemRate.item_id' => $value['item_id'],'OtPharmacyItemRate.batch_number'=>$value['batch_number'])));
			
			if(!empty($value['sale_price'])){
				$mrp = (float)$value['sale_price'];
				$total = ($qty*$mrp);
			}else if(!empty($value['mrp'])){
				$mrp = (float)$value['mrp'];
				$total = ($qty*$mrp);
			}
			if($packType == "Tabs"){
				$total = $qty*$mrp/(int)$value['pack'];
			}
			$grandTotal = $data['OtPharmacySalesBill']['total'];
			
			?>
			<td valign="middle" style="text-align: center;">
				<lable name="mrp[]" id="mrp"><?php echo $value['mrp']/*/(int)$value['pack']*/;?></lable> 
			</td>
			
			<td valign="middle" style="text-align: center;"><?php //debug((int)$value['pack']);?>
				<lable name="rate[]" id="rate" ><?php echo number_format($value['sale_price']/(int)$value['pack'],2);?></lable>
			</td>
				
			<td valign="middle" style="text-align: center;">
				<lable name="qty[]" id="qty" fieldNo=""><?php echo $value['qty']." ".$packType;?></lable> 
			</td>

			<td valign="middle" style="text-align: center;">
			<?php 
			if($value['qty_type'] == 'Tab'){
					$total = ($value['sale_price']/$value['pack'])*$value['qty'];
				}else if($value['qty_type'] == 'Pack'){
					$total = ($value['sale_price'])*$value['qty'];
				}
				?>
			
				<lable name="value[]" id="value"><?php echo number_format(round($total),2);?></lable>
			</td>
		</tr>

		<?php
		$count++;
		}
		?>
	</table>
	<div class="clr ht5"></div>
	<table cellpadding="0" cellspacing="0" border="0">
		<?php 
		/*$tax = (float)$data['PharmacySalesBill']['tax'];
		$taxamount = ($grandTotal*$tax)/100;*/
		$grandTotal = $grandTotal+$taxamount;
		?>
		<tr>
		<td class="tdLabel2">Mode : </td>
		<td  class="tdLabel2"><?php echo ucfirst($data['OtPharmacySalesBill']['payment_mode']) ;?></td>
		
		<td width="60">&nbsp;</td>
		<td class="tdLabel2">Total Amount : </td>
		<td><span id="total_amount"><?php echo number_format($grandTotal,2);?></span></td>
		<td width="60">&nbsp;</td>
		<td class="tdLabel2">Discount Amount : </td>
		<td style="font-size: 13px;"><lable name="discount" id="discount" ><?php echo number_format($discount = !empty($data['OtPharmacySalesBill']['discount'])?$data['OtPharmacySalesBill']['discount']:0.00,2);?></lable></td>
		<td width="60">&nbsp;</td>
		<td class="tdLabel2">Net Amount : </td>
		<td style="font-size: 13px;"><lable name="net_amount" id="net_amount" ><?php echo number_format($grandTotal - $discount + (($grandTotal*$tax)/100),2);?></lable></td>
		<td width="60">&nbsp;</td>
		</tr>
		
		<tr class="clr ht5" ></tr>
		<?php if(isset($data['OtPharmacySalesBill']['credit_period']) || isset($data['User']['username'])){ ?>
		<tr>
			<td width="70" class="tdLabel2"> Credit Days : </td>
			<td  width="50" class="tdLabel2"><?php echo $data['OtPharmacySalesBill']['credit_period']; ?></td>
			<td width="67" class="tdLabel2">Guarantor : </td>
			<td width="35" class="tdLabel2"><?php  echo $data['User']['username'];?></td>
		</tr>
		<?php }?>
	</table>
	<div class="clr ht5"></div>
	<div class="clr ht5"></div>
<!-- 	<div align="right"> -->
		<?php
// 		$url = Router::url(array("controller" => "pharmacy", "action" => "inventory_print_view",'PharmacySalesBill',$data['PharmacySalesBill']['id'],'inventory'=>true));
// 		?>

<!-- 		<input name="print" type="button" value="Print" class="blueBtn" -->
<!-- 			tabindex="36" 
			onclick="window.open('<?php echo $url;?>','Print','fullscreen=no,height=800px,width=800px,location=0,titlebar=no,toolbar=no',true );" />-->

<!-- 	</div> -->


</div>
