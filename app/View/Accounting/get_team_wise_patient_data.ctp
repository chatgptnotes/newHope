<style>
.tabularForm {
    background: none repeat scroll 0 0 #d2ebf2 !important;
}
.tabularForm td {
	background: none repeat scroll 0 0 #fff !important;
    color: #000 !important;
    font-size: 13px;
    padding: 3px 8px;
}
.subHead{
	display:none;
}
.headRow{
	cursor:pointer;
}
</style>

<div class="inner_title">
	<h3>
		<?php echo __('Team', true); echo "- $team"; ?>
	</h3>
</div>

<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
	<tr> 
		<th><?php echo __("Patient Name");?></th>
		<th><?php echo __("Tariff");?></th>
		<th style="text-align : right;"><?php echo __("Total Amount Received");?></th>
	</tr>
	<?php foreach($billingData as $teamKey=>$data){ ?>
	<tr>
		<td><?php echo $data['Patient']['lookup_name']; ?></td>
		<td><?php echo $data['TariffStandard']['name']; ?></td>
		<td style="text-align : right;">
			<?php 
			$netAmount = $data['0']['total_amount']-$data['0']['total_refund_amount'];
			 echo $netAmount;
			$totalAmount += $netAmount; ?>
		</td>
	</tr>
	<?php } ?>
	<tr> 
		<td colspan="2"><font color="red"><b><?php echo __("Total");?></b></font></td>
		<td style="text-align : right;"><font color="red"><b><?php echo $totalAmount; ?></b></font></td>
	</tr>
</table>