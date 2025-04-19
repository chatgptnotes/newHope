<?php 
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"pharmacy_Gross_Profit_Report_".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls" );
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
	<td colspan = "9" align="center"><strong><?php echo ucfirst($getLocName);?></strong></td>
</tr>
<tr>
	<td colspan = "9" align="center"><strong><?php echo ucfirst($getLocAdd1).' '.ucfirst($getLocAdd2).' '.ucfirst($location_zipcode).','.ucfirst($location_country);?></strong></td>
</tr>
			  
<tr >
	<td colspan = "9" align="center"><strong>Pharmacy Gross Profit Report</strong></td>
</tr>
<tr>
	<td colspan = "9" align="center"><strong><?php echo $this->DateFormat->formatDate2Local($from,Configure::read('date_format'), false); ?></strong> to <strong><?php echo $this->DateFormat->formatDate2Local($to,Configure::read('date_format'), false);?></strong></td>
</tr>
<tr style='background:#3796CB;color:#FFFFFF;'> 
	<th width="6%" align="center" valign="top">Sr.No.</th>
	<th width="18%" align="center" valign="top">Sold Item</th> 
	<th width="15%" align="center" valign="top" style="text-align: center;">Purchase Per Piece </th>
	<th width="15%" align="center" valign="top" style="text-align: center;">Purchase Price </th>
	<th width="15%" align="center" valign="top" style="text-align: center;">Sale Per Piece</th>
	<th width="15%" align="center" valign="top" style="text-align: center;">Sale Price</th>
	<th width="15%" align="center" valign="top" style="text-align: center;">Quantity</th>
	<th width="15%" align="center" valign="top" style="text-align: center;">Rupees Wise Profit</th> 
	<th width="15%" align="center" valign="top" style="text-align: center;">% Wise Profit</th> 	
</tr>
	
<?php 
if(count($itemArr)>0){
$cnt=1;
$i=0;

foreach($itemArr as $key=>$itemArrs){	
$i++;
?>
<tr>
<td align="left"><?php echo $cnt;?>
</td>
<td align="left"><?php echo $itemArrs['PharmacyItem']['name'];//echo $pharmacyItems[$key]['PharmacyItem']['name'];?></td>

<?php
/*  $purchaseAmt=0;
	  $saleAmt=0;
	  $qtySum=0;
		$countQty=count($itemArrs);		 */
//foreach($itemArrs as $keyPurchase=>$itemArrsPurchase){			
			/* $purchaseAmt=$purchaseAmt+$itemArrsPurchase['purchase'];
			$purchaseSumAmt=$purchaseAmt+($itemArrsPurchase['purchase']/$pharmacyItems[$key]['PharmacyItem']['pack']);

			$saleAmt=$saleAmt+$itemArrsPurchase['sale'];
			$saleSumAmt=$saleAmt+($itemArrsPurchase['sale']/$pharmacyItems[$key]['PharmacyItem']['pack']);
			$qtySum=$qtySum+$itemArrsPurchase['qty']; */
//	}
	?>
	<td align="right"><?php 
	echo $singlePurchasePrice = round($itemArrs['PharmacyItemRate']['purchase_price']/$itemArrs['PharmacyItem']['pack'],2);
	/* $getPurchaseAvg=($purchaseSumAmt/$countQty);
	echo $getPurchaseAvg; */?></td>

<td align="right"><?php 
	echo $totalPurchase = round($singlePurchasePrice * $itemArrs[0]['qtySum'],2);
//$getPurchaseSingle=$itemArrs*$pharmacyItemDetailss['PurchaseOrderItem']['quantity_received'];
	// $getPurchaseSingle=($purchaseAmt/$pharmacyItems[$key]['PharmacyItem']['pack'])*$qtySum;
	$getPurchasePriceTotal=$getPurchasePriceTotal+$totalPurchase ;
//echo $getPurchaseSingle; */?></td>

<td align="right"><?php
	echo $singleSalePrice = round($itemArrs['PharmacyItemRate']['mrp']/$itemArrs['PharmacyItem']['pack'],2);
	/* $getSaleAvg=($saleSumAmt/$countQty);
	echo $getSaleAvg; */?></td>
<td align="right"><?php 
//$getSalingSingle=($saleAmt/$pharmacyItems[$key]['PharmacyItem']['pack'])*$qtySum;
//$getSalingSingle=$pharmacyItemDetailss['PurchaseOrderItem']['selling_price']*$pharmacyItemDetailss['PurchaseOrderItem']['quantity_received'];
//echo $getSalingSingle; 
echo $totalSales = round($singleSalePrice * $itemArrs[0]['qtySum'],2);
$getSellingPriceTotal=$getSellingPriceTotal+$totalSales;
?></td>
<td align="center"><?php echo $itemArrs[0]['qtySum'];//echo $qtySum; ?>
</td> 
<td align="right"><?php echo round($totalSales - $totalPurchase,2);//echo ($getSalingSingle-$getPurchaseSingle); ?>
</td> 
<td align="right"><?php $getPercentageProfit=(($totalSales-$totalPurchase)/$totalPurchase)*100; 
echo number_format($getPercentageProfit,2)."%";?>
</td> 
</tr>
<?php $cnt++;
}?>
<tr style='background:#3796CB;color:yellow;'>	
	<td	 align="center"><strong></strong></td>	
	<td	 align="center"><strong></strong></td>
	<td	 align="center"><strong></strong></td>
	<td align="right"><strong><?php echo round($getPurchasePriceTotal,2);?></strong></td>
	<td	 align="center"><strong></strong></td>
	<td align="right"><strong><?php echo round($getSellingPriceTotal,2);?></strong></td>
	<td	 align="center"><strong></strong></td>
	<td align="right"><strong><?php echo round($getSellingPriceTotal-$getPurchasePriceTotal,2);?></strong></td>
	<td align="right"><strong><?php $grandPerProfitAmt=(($getSellingPriceTotal-$getPurchasePriceTotal)/$getPurchasePriceTotal)*100;
echo  number_format($grandPerProfitAmt,2);?>%</strong></td>
</tr>

<?php }else{?>
<tr>
<td colspan="9" align="center" style='background:#B4DFF7;'>No Record Found.
</td>
</tr>
<?php }?>
</table>