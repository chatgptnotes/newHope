<?php
$searchKey = array("/", " ", ":");
    $searchReplace = array("-","_", ".");
    $currentDate = str_replace($searchKey, $searchReplace, $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true));
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"Account_Receivable_Managment_Report".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls" );
header ("Content-Description: Generated Report" );
?>
<STYLE type='text/css'>
	.tableTd {
	   	border-width: 0.5pt; 
		border: solid; 
	}
	.tableTdContent{
		border-width: 0.5pt; 
		border: solid;
	}
	#titles{
		font-weight: bolder;
	}
   
</STYLE>
<table border='1' class='table_format'  cellpadding='0' cellspacing='0' width='100%' style='text-align:left;padding-top:50px;'>
	<tr class="row_title">
   		<td colspan = "15" align="center"><h2>Account Receivable By Insurance</h2></td>
   </tr>
	<tr class="row_title">
		<td height='30px' align='center' valign='middle'><strong><?php echo __('Payer Id #')?></strong></td>
		<td height='30px' align='center' valign='middle'><strong><?php echo __('Insurance Company')?></strong></td>
		<td height='30px' align='center' valign='middle'><strong><?php echo __('0-30 Days (in $)')?></strong></td>
		<td height='30px' align='center' valign='middle'><strong><?php echo __('31-60 Days (in $)')?></strong></td>
		<td height='30px' align='center' valign='middle'><strong><?php echo __('61-90 Days (in $)')?></strong></td>
		<td height='30px' align='center' valign='middle'><strong><?php echo __('91-120 Days (in $)')?></strong></td>
		<td height='30px' align='center' valign='middle'><strong><?php echo __('121+ Days (in $)')?></strong></td>
		<td height='30px' align='center' valign='middle'><strong><?php echo __('Total (in $)')?></strong></td>
	</tr>
	<tr>
		<td class="table_cell"><?php echo ($insData[0]['TariffStandard']['payer_id'])? $insData[0]['TariffStandard']['payer_id']:'';?></td>
		<td class="table_cell"><?php echo ($insData[0]['TariffStandard']['name'])? $insData[0]['TariffStandard']['name']:'';?></td>
		<td class="table_cell" align="right"><?php echo ($month=='1')? $this->Number->currency($amount):$this->Number->currency('0');?></td>
		<td class="table_cell" align="right"><?php echo ($month=='2')? $this->Number->currency($amount):$this->Number->currency('0');?></td>
		<td class="table_cell" align="right"><?php echo ($month=='3')? $this->Number->currency($amount):$this->Number->currency('0');?></td>
		<td class="table_cell" align="right"><?php echo ($month=='4')? $this->Number->currency($amount):$this->Number->currency('0');?></td>
		<td class="table_cell" align="right"><?php echo ($month>'4')? $this->Number->currency($amount):$this->Number->currency('0');?></td>
		<td class="table_cell" align="right"><?php echo  $this->Number->currency($amount);?></td>
	</tr>
</table>
<table border='1' class='table_format'  cellpadding='0' cellspacing='0' width='100%' style='text-align:left;padding-top:50px;'>	
  	<tr class="row_title">
   		<td colspan = "16" align="center"></td>
    </tr>
	  <tr class='row_title'>
		   <td height='30px' align='center' valign='middle' width='7%'><strong><?php echo __('Sr.No.'); ?></strong></td>
		   <td height='30px' align='center' valign='middle'><strong><?php echo __('Patient'); ?></strong></td>
		   <td height='30px' align='center' valign='middle'><strong><?php echo __('Visit'); ?></strong></td>
		   <td height='30px' align='center' valign='middle'><strong><?php echo __('Date Of Birth'); ?></strong></td>
		   <td height='30px' align='center' valign='middle'><strong><?php echo __('Ins Id #'); ?></strong></td>
		   <td height='30px' align='center' valign='middle'><strong><?php echo __('Note'); ?></strong></td>		
		   <td height='30px' align='center' valign='middle'><strong><?php echo __('Bill No.'); ?></strong></td>					   
		   <td height='30px' align='center' valign='middle'><strong><?php echo __('Billed (in $)'); ?></strong></td>
		   <td height='30px' align='center' valign='middle'><strong><?php echo __('Ins Resp (in $)'); ?></strong></td>
		   <td height='30px' align='center' valign='middle'><strong><?php echo __('Ins 1 Paid (in $)'); ?></strong></td>		   	   
		   <td height='30px' align='center' valign='middle'><strong><?php echo __('Ins 2 Paid (in $)'); ?></strong></td>
		   <td height='30px' align='center' valign='middle'><strong><?php echo __('Pt Resp (in $)'); ?></strong></td>
		   <td height='30px' align='center' valign='middle'><strong><?php echo __('Pt Paid (in $)'); ?></strong></td>
		   <td height='30px' align='center' valign='middle'><strong><?php echo __('Ins Bal (in $)'); ?></strong></td>
		   <td height='30px' align='center' valign='middle'><strong><?php echo __('Pt Bal (in $)'); ?></strong></td>
		   <td height='30px' align='center' valign='middle'><strong><?php echo __('Status'); ?></strong></td>		   
	 </tr>
 <?php  if(count($insData) > 0 && $insData != '') {
	   $i = 1;
		foreach($insData as $data){	?>
	 <tr>
	 	<td align="center" height="17px" ><?php echo $i;?></td>
		<td align="center" height="17px" ><?php echo $data['Patient']['lookup_name'];?></td>
		<td align="center" height="17px" ><?php echo $this->DateFormat->formatDate2Local($data['Patient']['form_received_on'],Configure::read('date_format'),false);?></td>
		<td align="center" height="17px" ><?php echo $this->DateFormat->formatDate2Local($data['Person']['dob'],Configure::read('date_format'),false);?></td>
		<td align="center" height="17px" ><?php echo $data['NewInsurance']['insurance_number'];?></td>
		<td align="center" height="17px" ><?php echo $data['DumpNote']['note'];?></td>
		<td align="center" height="17px" ><?php echo $data['FinalBilling']['bill_number'];?></td>
		<td align="center" height="17px" align="right"><?php echo ($data['FinalBilling']['total_amount'])? $currency.($data['FinalBilling']['total_amount']):$currency.'0';?></td>
		<td align="center" height="17px" align="right"><?php echo $currency.($data['FinalBilling']['amount_pending_ins_company'] + $data['FinalBilling']['amount_pending_ins_2_company']);?></td>
		<td align="center" height="17px" align="right"><?php echo ($data['FinalBilling']['amount_collected_ins_company'])? $currency.$data['FinalBilling']['amount_collected_ins_company']:$currency.'0';?></td>
		<td align="center" height="17px" align="right"><?php echo ($data['FinalBilling']['amount_pending_ins_2_company'])? $currency.$data['FinalBilling']['amount_pending_ins_2_company']:$currency.'0';?></td>
		<td align="center" height="17px" align="right"><?php echo ($data['FinalBilling']['copay'])? $currency.( $data['FinalBilling']['copay']):$currency.'0';?></td>
		<td align="center" height="17px" align="right"><?php echo ($data['FinalBilling']['collected_copay'])? $currency.$data['FinalBilling']['collected_copay']:$currency.'0';?></td>
		<td align="center" height="17px" align="right"><?php echo $currency.(( $data['FinalBilling']['amount_pending_ins_company'] -  $data['FinalBilling']['amount_collected_ins_company']) + ($data['FinalBilling']['amount_pending_ins_2_company'] -  $data['FinalBilling']['amount_collected_ins_2_company']));?></td>
		<td align="center" height="17px" align="right"><?php echo $currency.( $data['FinalBilling']['copay'] - $data['FinalBilling']['collected_copay']);?></td>
		<td align="center" height="17px" ><?php echo $data['FinalBilling']['claim_status'] ?></td>
	</tr>
<?php $i++;  } ?> 
	<tr>
		 <td height='30px' align='center' valign='middle' colspan="15"><strong>Total Patients :</strong>
		 <?php echo count($insData); ?></td>
	 </tr>
<?php	} else { ?>
		<tr>
			<td colspan = '16' align='center' height='30px'>No Record Found</td>
		</tr>
	 <?php } ?>
</table>