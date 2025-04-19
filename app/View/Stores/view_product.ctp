<div class="inner_title">
	
	<h3>
		&nbsp;<?php echo __('View Product with Batches', true); ?>
	</h3>
	<span> <?php
	//echo $this->Html->link(__('Back'), array('action'=>'index'), array('escape' => false,'class'=>'blueBtn back'));
	?>
	</span>
</div>
<div class="clr ht5"></div>
<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm" id="item-row" style="margin:5px; padding-top:20px;">
	<thead>
		<tr>
			<th width="80" align="center" valign="top" style="text-align: center;">Product Name</td>
			<th width="80" align="center" valign="top" style="text-align: center;">Batch No.</td>
			<th width="60" valign="top" style="text-align: center;">Pack</td>
			<th width="60" valign="top" style="text-align: center;">Expiry Date</td>
			<th width="60" valign="top" style="text-align: center;">MRP</td>
			<th width="60" valign="top" style="text-align: center;">Purchase Price</td>
			<th width="60" valign="top" style="text-align: center;">Selling Price</td>
			<?php if(strtolower($this->Session->read('website.instance')) != 'vadodara') {?>
			<th width="60" valign="top" style="text-align: center;">Tax</td>
			<?php } ?>
			<th width="60" valign="top" style="text-align: center;">Stock</td>
			<th width="60" valign="top" style="text-align: center;">Stock in (MSU)</td>
		</tr>
	</thead>
	<tbody>
		<?php if(count($datas['ProductRate'])>0){ 
			foreach($datas['ProductRate'] as $data) { 
		?>
		<tr>
			<td width="80" align="center" valign="top" style="text-align: center;"><?php echo $datas['Product']['name']; ?></td>
			<td width="80" align="center" valign="top" style="text-align: center;"><?php echo !empty($data['batch_number'])?$data['batch_number']:"-"; ?></td>
			<td width="80" align="center" valign="top" style="text-align: center;"><?php echo $pack = (!empty($datas['Product']['pack']))?$datas['Product']['pack']:1; ?></td>
			<td width="60" valign="top" style="text-align: center;"><?php 
			if($data['expiry_date']){
				 $expiryDate = $this->DateFormat->formatDate2Local($data['expiry_date'],Configure::read('date_format'),true); 
				 echo !empty($expiryDate)?$expiryDate:"-";
			}
			
			?></td>
			<td width="60" valign="top" style="text-align: center;"><?php echo $data['mrp']; ?></td>
			<td width="60" valign="top" style="text-align: center;"><?php echo $data['purchase_price']; ?></td>
			<td width="60" valign="top" style="text-align: center;"><?php echo $data['sale_price']; ?></td>
			<?php if(strtolower($this->Session->read('website.instance')) != 'vadodara') {?>
			<td width="60" valign="top" style="text-align: center;"><?php echo $data['tax']; ?></td>
			<?php } ?>
			<td width="60" valign="top" style="text-align: center;"><?php echo $data['stock']; ?></td>
			<td width="60" valign="top" style="text-align: center;"><?php echo $data['stock'] * $pack + $data['loose_stock']; ?></td>
		</tr>
		<?php } //end of foreach?>
		<?php }else {  ?>
		<tr>
			<td width="80" align="center" valign="top" style="text-align: center;"><?php echo $datas['Product']['name']; ?></td>
			<td width="80" align="center" valign="top" style="text-align: center;"><?php echo !empty($datas['Product']['batch_number'])?$datas['Product']['batch_number']:"-"; ?></td>
			<td width="60" valign="top" style="text-align: center;"><?php echo $pack = (!empty($datas['Product']['pack']))?$datas['Product']['pack']:1; ?></td>
			<td width="60" valign="top" style="text-align: center;"><?php $expiryDate = $this->DateFormat->formatDate2Local($datas['Product']['expiry_date'],Configure::read('date_format'),true); echo !empty($expiryDate)?$expiryDate:"-"; ?></td>
			<td width="60" valign="top" style="text-align: center;"><?php echo !empty($datas['Product']['mrp'])?$datas['Product']['mrp']:"-"; ?></td>
			<td width="60" valign="top" style="text-align: center;"><?php echo !empty($datas['Product']['purchase_price'])?$datas['Product']['purchase_price']:"-"; ?></td>
			<td width="60" valign="top" style="text-align: center;"><?php echo !empty($datas['Product']['sale_price'])?$datas['Product']['sale_price']:"-"; ?></td>
			<?php if(strtolower($this->Session->read('website.instance')) != 'vadodara') {?>
			<td width="60" valign="top" style="text-align: center;"><?php echo !empty($datas['Product']['tax'])?$datas['Product']['tax']:"-"; ?></td>
			<?php }?>
			<td width="60" valign="top" style="text-align: center;"><?php echo !empty($datas['Product']['quantity'])?$datas['Product']['quantity']:0; ?></td>
			<td width="60" valign="top" style="text-align: center;"><?php echo $datas['Product']['stock'] * $pack + $datas['Product']['loose_stock']; ?></td>
			
		</tr>
		<?php }?>
	</tbody>
</table>