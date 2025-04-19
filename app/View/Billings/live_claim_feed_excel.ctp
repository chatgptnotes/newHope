<?php
$searchKey = array("/", " ", ":");
$searchReplace = array("-","_", ".");
$currentDate = str_replace($searchKey, $searchReplace, $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true));
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"Empanelment_Report".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls" );
header ("Content-Description: Generated Report" );
?>
<STYLE type='text/css'>
.tableTd {
	border-width: 0.5pt;
	border: solid;
}

.tableTdContent {
	border-width: 0.5pt;
	border: solid;
}

#titles {
	font-weight: bolder;
}
</STYLE>
<table border='1' class='table_format' cellpadding='0' cellspacing='0'
	width='100%' style='text-align: left; padding-top: 50px;'>
	<tr class="row_title">
		<td colspan="15" align="center"><h2>Live Claim Feed</h2></td>
	</tr>
	<tr class='row_title'>
		<td height='30px' align='center' valign='middle' width='7%'><strong><?php echo __('Sr.No.'); ?>
		</strong></td>
		<td height='30px' align='center' valign='middle' width='7%'><strong><?php echo __('Patient')?>
		</strong></td>
		<td height='30px' align='center' valign='middle'><strong><?php echo __('Visit')?>
		</strong></td>
		<td height='30px' align='center' valign='middle'><strong><?php echo __('Facility'); ?>
		</strong></td>
		<td height='30px' align='center' valign='middle'><strong><?php echo __('Provider'); ?>
		</strong></td>
		<td height='30px' align='center' valign='middle'><strong><?php echo __('Billed'); ?>
		</strong></td>
		<td height='30px' align='center' valign='middle'><strong><?php echo __('Allowed'); ?>
		</strong></td>
		<td height='30px' align='center' valign='middle'><strong><?php echo __('Adjustment'); ?>
		</strong></td>
		<td height='30px' align='center' valign='middle'><strong><?php echo __('Ins 1 Paid'); ?>
		</strong></td>
		<td height='30px' align='center' valign='middle'><strong><?php echo __('Ins 2 Paid'); ?>
		</strong></td>
		<td height='30px' align='center' valign='middle'><strong><?php echo __('Pt Paid'); ?>
		</strong></td>
		<td height='30px' align='center' valign='middle'><strong><?php echo __('Ins Bal'); ?>
		</strong></td>
		<td height='30px' align='center' valign='middle'><strong><?php echo __('Pt Bal'); ?>
		</strong></td>
		<td height='30px' align='center' valign='middle'><strong><?php echo __('Ins 1'); ?>
		</strong></td>
		<td height='30px' align='center' valign='middle'><strong><?php echo __('Ins 1 Status'); ?>
		</strong></td>
	</tr>
	<?php  

	if(count($reports['patientData']) > 0 && $reports['patientData'] != '') {
		   $i = 1;
		   foreach($reports['patientData'] as $data){

?>
	<tr>
		<td align="center" height="17px"><?php echo $i ?></td>
		<td align="center" height="17px"><?php echo $data['Patient']['lookup_name'];?>
		</td>
		<td align="center" height="17px"><?php echo $this->DateFormat->formatDate2Local($data['Patient']['form_received_on'],Configure::read('date_format'),false);?>
		</td>
		<td align="center" height="17px"><?php echo $this->Session->read('facility');?>
		</td>
		<td align="center" height="17px"><?php echo $data['User']['first_name']. ' ' .$data['User']['last_name'];?>
		</td>
		<td align="center" height="17px"><?php echo ($data['FinalBilling']['total_amount'])? $currency.$data['FinalBilling']['total_amount']:$currency.'0';?>
		</td>
		<td align="center" height="17px"></td>
		<td align="center" height="17px"></td>
		<td align="center" height="17px"><?php echo ($data['FinalBilling']['amount_collected_ins_company'])? $currency.((int) $data['FinalBilling']['amount_collected_ins_company']):$currency.'0';?>
		</td>
		<td align="center" height="17px"></td>
		<td align="center" height="17px"><?php echo ($data['FinalBilling']['collected_copay'])? $currency.$data['FinalBilling']['collected_copay']:$currency.'0';?>
		</td>
		<td align="center" height="17px"><?php echo $currency.((int) $data['FinalBilling']['amount_pending_ins_company'] - (int) $data['FinalBilling']['amount_collected_ins_company']);?>
		</td>
		<td align="center" height="17px"><?php echo $currency.((int) $data['FinalBilling']['copay'] - (int) $data['FinalBilling']['collected_copay']);?>
		</td>
		<td align="center" height="17px"><?php echo $data['TariffStandard']['name'];?>
		</td>
		<td align="center" height="17px"><?php echo $data['FinalBilling']['claim_status'];?>
		</td>


		<?php $i++;  
} ?>
	
	
	<tr>
		<td height='30px' align='center' valign='middle' colspan="12"><strong>Total
				Claims :</strong> <?php echo count($reports['patientData']); ?></td>
	</tr>
	<?php	} else { ?>
	<tr>
		<td colspan='12' align='center' height='30px'>No Record Found</td>
	</tr>
	<?php } ?>

</table>
