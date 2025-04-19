<?php 
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"Pharmacy_Stock_&_Sales_Report_".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls" );
header ("Content-Description: Generated Report" );  
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
<table width="100%" cellpadding="2" cellspacing="0" border="1" class="table_format" style="padding-top:10px" >
 <tr style='background:#3796CB;color:#FFFFFF;'>
				<td colspan = "7" align="center"><strong><?php echo ucfirst($getLocName);?></strong></td>
			  </tr>
			  <tr>
				<td colspan = "7" align="center"><strong><?php echo ucfirst($getLocAdd1).' '.ucfirst($getLocAdd2).' '.ucfirst($location_zipcode).','.ucfirst($location_country);?></strong></td>
			  </tr>
			  
<tr style='background:#3796CB;color:#FFFFFF;'>
	<td colspan = "7" align="center"><strong>Pharmacy Stock & Sales Report</strong></td>
</tr>
<tr>
	<td colspan = "7" align="center"><strong><?php echo $this->DateFormat->formatDate2Local($from,Configure::read('date_format'), false); ?></strong> to <strong><?php echo $this->DateFormat->formatDate2Local($to,Configure::read('date_format'), false);?></strong></td>
</tr>
<tr style='background:#3796CB;color:#FFFFFF;'> 
<th width="6%" align="center" valign="top">Sr.No.</th>
	<th width="14%" align="center" valign="top">Product Name</th>		
	<th width="13%" align="center" valign="top" style="text-align: center;">Opening Stock</th>
	<th width="13%" align="center" valign="top" style="text-align: center;">Received Stock</th> 
	<th width="13%" align="center" valign="top" style="text-align: center;">Stock Sold</th>
	<th width="13%" align="center" valign="top" style="text-align: center;">Closing Stock</th>
	<th width="13%" align="center" valign="top" style="text-align: center;">Value</th> 	
</tr>
	
<?php 
if(count($commanPharmacyArr)>0){
$cnt=1;
$i=0;

foreach($commanPharmacyArr as $key=>$pharmacyItemDetailss){

if(empty($pharmacyItemDetailss['PharmacyItem'][0]['name']))
continue;
$i++;
?>
<tr <?php if($i%2 == 0) echo "style='background:#E5F4FC;'"; ?>>
<td align="center"><?php echo $cnt;?></td>
<td align="center"><?php echo $pharmacyItemDetailss['PharmacyItem'][0]['name']; ?></td>
<td align="center"><?php 
$getPurSaleMinus=($pharmacyItemDetailss['PurchaseOrderItem'][0]['new_quantity_received'])-($pharmacyItemDetailss['PharmacySalesBillDetail'][0]['new_qty']);
$getOpeningStock=($pharmacyItemDetailss['PharmacyItem'][0]['pack']*$pharmacyItemDetailss['PharmacyItem'][0]['stock'])-$getPurSaleMinus;
$getOpeningStock1=abs($getOpeningStock);
echo $getOpeningStock1;?></td>
<td align="center"><?php echo $pharmacyItemDetailss['PurchaseOrderItem'][0]['new_quantity_received']; ?>
</td> 
<td align="center"><?php echo $pharmacyItemDetailss['PharmacySalesBillDetail'][0]['new_qty']; ?>
</td>
<td align="center"><?php $getClosingStock=($getOpeningStock1+$pharmacyItemDetailss['PurchaseOrderItem'][0]['new_quantity_received'])-$pharmacyItemDetailss['PharmacySalesBillDetail'][0]['new_qty'];
echo  $getClosingStock;?>
</td>
<td align="center"><?php $getTabValues=((int)$pharmacyItemDetailss['PharmacyItem'][0]['pack'] * $pharmacyItemDetailss['PharmacyItem'][0]['stock']) + $pharmacyItemDetailss['PharmacyItem'][0]['loose_stock'];
$getValue=$pharmacyItemDetailss['PharmacyItem']['0']['new_sale_price']/$pharmacyItemDetailss['PharmacyItem'][0]['pack'];
$getTabFinValue[$key]=round($getTabValues*$getValue);
echo round($getTabValues*$getValue); ?>

</td>
</tr>
<?php $cnt++;
}?>
<tr style='background:#3796CB;color:yellow;'>			
	<td align="right" colspan="6"><strong>Total Value</strong></td>
	<td align="center"><strong><?php $gradTotal=array_sum($getTabFinValue);
echo round($gradTotal)?></strong></td>
</tr>
<?php }else{?>
<tr>
<td colspan="7" align="center" style='background:#B4DFF7;'>No Record Found.
</td>
</tr>
<?php }?>
</table>