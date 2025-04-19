<?php
	echo $this->Html->script(array('inline_msg','jquery.selection.js','jquery.fancybox-1.3.4','jquery.blockUI','jquery.contextMenu'));
?>

<?php
//header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
//header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
//header ("Content-Disposition: attachment; filename=\"TOR_report_".date('d-m-Y').".xls");
header ("Content-Disposition: attachment; filename=\"Stock Register ".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls");
header ("Content-Description: Stock Register" );
ob_clean();
flush();
?>
  <?php $string = '';
		$string .= $thisData['item_name'];
		$string .= " (";
		$string .= $from;
		$string .= " to ";
		$string .= $to; 
		$string .= ")"; ?>
	<table  width="100%" cellpadding="0" cellspacing="0" border="" class="tabularForm" border="1">
		<thead>
			<tr height="30px">
				<th valign="middle" align="center" style="text-align:center;" colspan="9"><?php echo $string;?></th>
			</tr>
			<tr height="30px">
				<th width="2%" valign="middle" align="center" style="text-align:center;">SNo.</th>
				<th width="15%" valign="middle" align="center" style="text-align:center;">ItemName</th>
				<th width="10%" valign="middle" align="center" style="text-align:center;">Batches</th> 
				<th width="15%" valign="middle" align="center" style="text-align:center;">Trans Date</th>
				<th width="8%" valign="middle" align="center" style="text-align:center;">OpeningStock</th>
				<th width="5%" valign="middle" align="center" style="text-align:center;">Quantity</th>
				<th width="8%" valign="middle" align="center" style="text-align:center;">ClosingStock</th>
				<th width="15%" valign="middle" align="center" style="text-align:center;">Mode</th>
				<th width="15%" valign="middle" align="center" style="text-align:center;">Details</th>
				<th width="15%" valign="middle" align="center" style="text-align:center;">Doctor</th>
			</tr>
		</thead> 
		<tbody>
			<?php
				$i=0; 
				foreach ($record as $records){
					$i++;
			?>
			<tr>
				<td align="left"><?php echo $i;?></td>
				<td align="left"><?php echo $records['name']; ?></td> 
				<td align="center"><?php echo $records['batch_number'];?></td>
				<td align="center"><?php echo $records['create_time'];?></td>
				<td align="center"><?php echo $records['opening_stock'];?></td>
				<td align="center"><?php echo $records['qty'];?></td>
				<td align="center"><?php echo $records['closing_stock'];?></td>
				<td align="center"><?php echo $records['type'];?></td>
				<td style="text-align:left"><?php echo $records['patient_name'];?></td>
				<td style="text-align:left"><?php echo $records['doctor_name'];?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>