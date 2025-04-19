<?php //$website  = $this->Session->read('website.instance');
//$OtPharmacyData
$totalOtPharmacyCharge = 0;//round($pharmacy_charges[0]['total']);
$paidOtPharmacyCharge =0;// round($pharmacy_charges[0]['paid_amount']);
$discountOtPharmacyCharge =0;// round($pharmacy_charges[0]['discount']);
foreach($OtPharmacyData as $OtPharmacyDataKey=>$OtPharmacyDataValue){
	$totalOtPharmacyCharge=$totalOtPharmacyCharge+round($OtPharmacyDataValue['OTPharmacySalesBill']['total']);
	$paidOtPharmacyCharge=$paidOtPharmacyCharge+round($OtPharmacyDataValue['OTPharmacySalesBill']['paid_amount']);
	$discountOtPharmacyCharge=$discountOtPharmacyCharge+round($OtPharmacyDataValue['OTPharmacySalesBill']['discount']);
}

$totalOtPharmacyReturnCharge = 0;
foreach($OtPharmacyReturnData as $OtPharmacyReturnDataKey=>$OtPharmacyReturnDataValue){
	$totalOtPharmacyReturnCharge=$totalOtPharmacyReturnCharge+round($OtPharmacyReturnDataValue['OtPharmacySalesReturn']['total']);
}

if(!empty($totalOtPharmacyCharge)){?>
<table width="100%" cellpadding="0" cellspacing="1" border="0" style="clear:both" class="tabularForm" id="serviceGridPharmacy">
		<tr class="row_title">
			<th class="table_cell"><strong><?php echo __('Service Name'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Amount'); ?></strong></th>
		</tr>
		 
		<tr>
			<td valign="middle" ><?php echo __("OT Pharmacy Charges");?></td>
			<td valign="middle" style="text-align: right;"><?php echo $totalOtPharmacyCharge;?></td>
		</tr> 
	 
		<tr>
			<td valign="middle" ><?php echo __("OT Pharmacy Return Charges");?></td>
			<td valign="middle" style="text-align: right;"><?php echo $totalOtPharmacyReturnCharge;?></td>
		</tr>
		
		<tr>
			<td valign="middle" align="right" ><?php echo __("Total");?></td>
			<td valign="middle" style="text-align: right;"><?php echo ($totalOtPharmacyCharge-$totalOtPharmacyReturnCharge);?></td>
		</tr>
</table>
<?php }?>
<script>
$("#paymentDetailDiv", parent.document ).hide();//hide payment detail coz payment will done from final only  --yashwant
</script>