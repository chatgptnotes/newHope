<?php
echo $this->Html->script(array('inline_msg','jquery.selection.js','jquery.fancybox-1.3.4','jquery.blockUI','jquery.contextMenu'));
?>

<?php 
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel"); 
header ("Content-Disposition: attachment; filename=\"Department Request ".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls");
header ("Content-Description: Stock Register" );
ob_clean();
flush();
?>

<table width="100%" cellpadding="0" cellspacing="0" border=""
	class="tabularForm" border="1">
	<thead>
		<tr>
			<td colspan="6" align="center"><b><?php echo "Reports From ".$this->DateFormat->formatDate2Local($fromDate,Configure::read('date_format'),true)." to ".
			$this->DateFormat->formatDate2Local($toDate,Configure::read('date_format'),true); ?></b></td>
		</tr>
		<tr>
			<th width="5px" valign="top" align="center" style="text-align: center;">SNo.</th>
			<th width="51px" valign="top" align="center" style="text-align: center;">DEPARTMENT_NAME</th>
			<th width="51px" valign="top" align="center" style="text-align: center;">GRAND_QUANTIY</th>
			<th width="145px" valign="top" align="center" style="text-align: center;">GRAND_MRP_PRICE</th>
			<th width="48px" valign="top" align="center" style="text-align: center;">GRAND_COST_PRICE</th>
			<th width="66px" valign="top" align="center" style="text-align: center;">GRAND_RATE</th> 
		</tr> 
	</thead>
	<tbody>
	<?php if(count($record)>1){  $count = 0;
			 	foreach($record as $key=>$val): if(!empty($val['qty'])){ $count++;  ?>
	<tr>
		<td align="center" style="text-align:center;"><?php echo $count; ?></td>
		<td align="center" style="text-align:center;"><?php echo $val['department']; ?></td>
		<td align="center" style="text-align:center;"><?php echo number_format($val['qty']); ?></td>
		<td align="center" style="text-align:center;"><?php echo number_format($val['amount']); ?></td>
		<td align="center" style="text-align:center;"><?php echo number_format($val['price']); ?></td>
		<td align="center" style="text-align:center;"><?php echo ''; ?></td>
	</tr>
	<?php } endforeach;?>
	<?php } else { ?>
		<tr>
			<td colspan="6" align="center"><?php echo __("no record found"); ?></td>
		</tr>
	<?php } ?>
	</tbody>
</table>
