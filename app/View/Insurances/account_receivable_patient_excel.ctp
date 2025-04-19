<?php
$searchKey = array("/", " ", ":");
    $searchReplace = array("-","_", ".");
    $currentDate = str_replace($searchKey, $searchReplace, $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true));
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"account_receivable_patient_report".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls" );
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
<table style="border: 1px solid rgb(76, 94, 100); margin: 10px;" width="100%" id="claimTable">
	<tr class="row_title">
   		<td colspan = "10" align="center"><h2>Accounts Receivable By Patient</h2></td>
   </tr>
	<tr class="row_title" style="border: 1px solid rgb(76, 94, 100); margin: 10px;">
		<td style="border: 1px solid rgb(76, 94, 100); margin: 10px;"><strong><?php echo __('Patient')?></strong></td>
		<td style="border: 1px solid rgb(76, 94, 100); margin: 10px;"><strong><?php echo __('Date Of Birth')?></strong></td>
		<td style="border: 1px solid rgb(76, 94, 100); margin: 10px;"><strong><?php echo __('Phone')?></strong></td>
		<td style="border: 1px solid rgb(76, 94, 100); margin: 10px;"><strong><?php echo __('Billing Notes')?></strong></td>
		<td style="border: 1px solid rgb(76, 94, 100); margin: 10px;"><strong><?php echo __('0-30 Days (in $)')?></strong></td>
		<td style="border: 1px solid rgb(76, 94, 100); margin: 10px;"><strong><?php echo __('31-60 Days (in $)')?></strong></td>
		<td style="border: 1px solid rgb(76, 94, 100); margin: 10px;"><strong><?php echo __('61-90 Days (in $)')?></strong></td>
		<td style="border: 1px solid rgb(76, 94, 100); margin: 10px;"><strong><?php echo __('91-120 Days (in $)')?></strong></td>
		<td style="border: 1px solid rgb(76, 94, 100); margin: 10px;"><strong><?php echo __('121+ Days (in $)')?></strong></td>
		<td style="border: 1px solid rgb(76, 94, 100); margin: 10px;"><strong><?php echo __('Total (in $)')?></strong></td>
	</tr>
	<?php  $i=0;
	foreach($insCompanyList as $data){
	if(!empty($data['Patient']['lookup_name'])){?>
	<tr <?php //if($i%2 == 0) echo "class='row_gray'"; ?>>
		<td class="row_format" style="border: 1px solid rgb(76, 94, 100); margin: 10px;"><?php echo ($data['Patient']['lookup_name'])? $data['Patient']['lookup_name']:'';?></td>
		<td class="row_format" style="border: 1px solid rgb(76, 94, 100); margin: 10px;"><?php echo $this->DateFormat->formatDate2Local($data['Person']['dob'],Configure::read('date_format'),false);?></td>
		<td class="row_format" style="border: 1px solid rgb(76, 94, 100); margin: 10px;"><?php echo ($data['Patient']['mobile_phone'])? $data['Patient']['mobile_phone']:'';?></td>
		<td class="row_format" style="border: 1px solid rgb(76, 94, 100); margin: 10px;"><?php echo ($data['DumpNote']['note'])? $data['DumpNote']['note']:'';?></td>
		<td class="row_format" align="right" style="border: 1px solid rgb(76, 94, 100); margin: 10px;"><?php echo ($data['0']['MONTH']=='1')? $this->Number->currency($data['0']['ins_bal']):$this->Number->currency('0');?></td>
		<td class="row_format" align="right" style="border: 1px solid rgb(76, 94, 100); margin: 10px;"><?php echo ($data['0']['MONTH']=='2')? $this->Number->currency($data['0']['ins_bal']):$this->Number->currency('0');?></td>
		<td class="row_format" align="right" style="border: 1px solid rgb(76, 94, 100); margin: 10px;"><?php echo ($data['0']['MONTH']=='3')? $this->Number->currency($data['0']['ins_bal']):$this->Number->currency('0');?></td>
		<td class="row_format" align="right" style="border: 1px solid rgb(76, 94, 100); margin: 10px;"><?php echo ($data['0']['MONTH']=='4')? $this->Number->currency($data['0']['ins_bal']):$this->Number->currency('0');?></td>
		<td class="row_format" align="right" style="border: 1px solid rgb(76, 94, 100); margin: 10px;"><?php echo ($data['0']['MONTH']>'4')? $this->Number->currency($data['0']['ins_bal']):$this->Number->currency('0');?></td>
		<td class="row_format" align="right" style="border: 1px solid rgb(76, 94, 100); margin: 10px;"><?php echo  $this->Number->currency($data['0']['ins_bal']); ?></td>
	</tr>
	<?php } $i++; }?>
</table>