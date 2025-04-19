<?php 
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"Pharmacy_Purchase_Report_".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls" );
header ("Content-Description: Generated Expiry Report" );
ob_clean();
flush();
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
   .row_title{
		background: #ddd;
	}
	 .rowColor{
   		background-color:gray;
   		border-bottom-color: black;
   }
</STYLE>
<table width="90%" align="center" cellspacing="0" border="1" class="table_format">
<tr style='background:#3796CB;color:#FFFFFF;'>
	<td colspan = "9" align="center"><strong><?php echo ucfirst($getLocName);?></strong></td>
</tr>
<tr>
	<td colspan = "9" align="center"><strong><?php echo ucfirst($getLocAdd1).' '.ucfirst($getLocAdd2).' '.ucfirst($location_zipcode).','.ucfirst($location_country);?></strong></td>
</tr>
			  
<tr style='background:#3796CB;color:#FFFFFF;'>
	<td colspan = "9" align="center"><strong>Pharmacy Purchase Report</strong></td>
</tr>
<tr>
	<td colspan = "9" align="center"><strong><?php echo $this->DateFormat->formatDate2Local($from,Configure::read('date_format'), false); ?></strong> to <strong><?php echo $this->DateFormat->formatDate2Local($to,Configure::read('date_format'), false);?></strong></td>
</tr>
<tr style='background:#3796CB;color:#FFFFFF;'> 
	<th align="center" valign="top">Received Date</th>
	<th align="center" valign="top">Party Name</th>
	<th align="center" valign="top" style="text-align: center;">Party Inv.No </th>
	<th align="center" valign="top" style="text-align: center;">Total Amount</th>
	<th align="center" valign="top" style="text-align: center;">Tax/Vat</th> 
	<th align="center" valign="top" style="text-align: center;">Vat</th> 
	<th align="center" valign="top" style="text-align: center;">Sat</th> 
	<th align="center" valign="top" style="text-align: center;">Discount</th>
	<th align="center" valign="top" style="text-align: center;">Net Amount</th> 
	<!-- <th align="center" valign="top" style="text-align: center;">RoundOff</th> -->
</tr>
	
<?php if(count($allData)>0){
$cnt=1;$i=0;
$total = 0; $rounOff = 0;
$vatTotal=0;$totalVatPer=0;
$totalSatPer=0;$discounTotal = 0;
$Total=0;
foreach($allData as $key=>$data){ 
$i++; 

if($returnArray[$key]){
	$return = $returnArray[$key];
}else{
	$return = 0;
}

$orderDbTotal = $data['total'];				/// discount and return amount is excluded from total
$orderDbDiscount = $data['discount'];
$taxVat = $data['vat'];					// disa
$vat = $orderVat[$key];
$totalAmount = $orderDbTotal+$orderDbDiscount+$return;  		// Actual Total Amount of purchase
$netAmount = $orderDbTotal+$return+$vat; 
?>
<tr <?php if($i%2 == 0) echo "style='background:#E5F4FC;'"; ?>>
<td align="center"><?php echo $this->DateFormat->formatDate2Local($data['received_date'],Configure::read('date_format'), false);?></td>
<td align="center"><?php echo $data['supplier_name'];?></td>
<td align="center"><?php echo $key;?></td>			<!-- Party Invoice Number -->
<td align="center"><?php echo number_format($totalAmount,2);?></td>
<td align="center"><?php echo number_format($vat,2); ?></td> 
<td align="center"><?php echo number_format($data['vat_per'],2); ?></td> 
<td align="center"><?php echo number_format($data['sat_per'],2); ?></td> 
<td align="center"><?php echo number_format($orderDbDiscount,2); ?></td>
<td align="center"><?php echo $roundNet = round($netAmount);
						  $withoutRound = $netAmount; 
						/*  $data=explode(',', $fromDbTotal);
						 foreach($data as $key=>$val){
						 	$result = $result.$val;
						 } */
					?>
</td> 
<!--  <td align="center"><?php echo $roundamnt = number_format($withoutRound-$roundNet,2); ?></td>-->
</tr>
<?php 
	$Total = $Total+$totalAmount;
	$discounTotal = $discounTotal +$orderDbDiscount;
	$vatTotal = $vatTotal+$vat;
	$totalVatPer = $totalVatPer+$data['vat_per'];
	$totalSatPer = $totalSatPer+$data['sat_per'];
	$total = $total+$roundNet;
	  $rounOff = $rounOff+$roundamnt;
 $cnt++;
}?>
<tr style='background:#3796CB;color:#FFFFFF;'>
<td colspan="3" align="right" >Grand Total</td>
<td align="center" ><?php echo number_format($Total,2);?></td>
<td align="center" ><?php echo number_format($vatTotal,2);?></td>
<td align="center" ><?php echo number_format($totalVatPer,2);?></td>
<td align="center" ><?php echo number_format($totalSatPer,2);?></td>
<td align="center" ><?php echo number_format($discounTotal,2);?></td>
<td align="center"><?php echo $total;?></td>
<!-- <td align="center"><?php echo $rounOff;?></td> --> 
</tr>
<?php  }else{?>
<tr>
<td colspan="10" align="center" style='background:#B4DFF7;'>No Record Found.
</td>
</tr>
<?php }?>
</table>