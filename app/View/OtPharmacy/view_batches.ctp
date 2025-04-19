<div class="inner_title">
	
	<h3>
		&nbsp;<?php echo __('View Item with Batches', true); ?>
	</h3>
	
</div>
<div class="clr ht5"></div>
<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm" id="item-row" style="margin:5px; padding-top:20px;">
	<thead>
		<tr>
			<th width="80" align="center" valign="top" style="text-align: center;">Item Name</td>
			<th width="80" align="center" valign="top" style="text-align: center;">Batch No.</td>
			<th width="60" valign="top" style="text-align: center;">Pack</td>
			<th width="60" valign="top" style="text-align: center;">Expiry Date</td>
			<th width="60" valign="top" style="text-align: center;">MRP</td>
			<th width="60" valign="top" style="text-align: center;">Stock</td>
			<th width="60" valign="top" style="text-align: center;">Stock in (MSU)</td>
		</tr>
	</thead>
	<tbody>
		<?php 
			foreach($datas['OtPharmacyItemRate'] as $data) { 
		?>
		<tr>
			<td width="80" align="center" valign="top" style="text-align: center;"><?php echo $datas['OtPharmacyItem']['name']; ?></td>
			<td width="80" align="center" valign="top" style="text-align: center;"><?php echo !empty($data['batch_number'])?$data['batch_number']:"-"; ?></td>
			<td width="80" align="center" valign="top" style="text-align: center;"><?php echo $pack = (!empty($datas['OtPharmacyItem']['pack']))?$datas['OtPharmacyItem']['pack']:1; ?></td>
			<td width="60" valign="top" style="text-align: center;"><?php 
			if($data['expiry_date']){
				 $expiryDate = $this->DateFormat->formatDate2Local($data['expiry_date'],Configure::read('date_format'),true); 
				 echo !empty($expiryDate)?$expiryDate:"-";
			}
			
			?></td>
			<td width="60" valign="top" style="text-align: center;"><?php echo $data['mrp']; ?></td>
			<td width="60" valign="top" style="text-align: center;"><?php echo $data['stock']; ?></td>
			<td width="60" valign="top" style="text-align: center;"><?php echo $data['stock'] * $pack + $data['loose_stock']; ?></td>
		</tr>
		<?php } //end of foreach?>
		
	</tbody>
</table>