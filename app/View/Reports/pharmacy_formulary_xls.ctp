<?php  
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel"); 
header ("Content-Disposition: attachment; filename=\"Pharmacy Formulary ".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls");
header ("Content-Description: Stock Register" );
ob_clean();
flush();
?> 
	<table  width="100%" cellpadding="0" cellspacing="0" border="" class="tabularForm" border="1">
		<thead>
			<tr height="30px">
				<th valign="middle" align="center" style="text-align:center;" colspan="4"><?php echo "Pharmacy Formulary";?></th>
			</tr>
			<tr height="30px">
				<th width="2%" valign="middle"><?php echo __('Generic'); ?></th>
				<th width="15%" valign="middle"><?php echo __("Product Name"); ?></th>
				<th width="10%" valign="middle"><?php echo __("Pack"); ?></th> 
				<th width="15%" valign="middle"><?php echo __("Manufacturer"); ?></th> 
			</tr>
		</thead> 
		<tbody>
			<?php foreach($result as $key=> $val){ ?>
			<tr>
				<td><?php echo $val['PharmacyItem']['generic']; ?></td>
				<td><?php echo $val['PharmacyItem']['name']; ?></td>
				<td align="center"><?php echo $val['PharmacyItem']['pack']; ?></td>
				<td><?php echo $val['PharmacyItem']['manufacturer']; ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>