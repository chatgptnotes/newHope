<?php
ob_clean();
	App::import('Vendor','tcpdf/config/lang/eng'); 
	App::import('Vendor','tcpdf/tcpdf');
	$facilityname = ucfirst($this->Session->read("facility"));
	$headerimage = $this->Session->read("header_image");
	$facilitynamewithreport;
	
	if(empty($facilityname)) {
	  	$facilitynamewithreport = 'Pharmacy Gross Profit Report'; 
	  	$facilityname = "";
	}
	else {
	    $headerString = "by ".$facilityname ;
		$facilitynamewithreport = $facilityname.'-Pharmacy Gross Profit Report'; 
	}
	$tcpdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false); 
	$tcpdf->SetCreator(PDF_CREATOR);
	//$tcpdf->SetAuthor('Hope Hospital');
	//$tcpdf->SetTitle('Hope Hospital-Incidence Report');
	$tcpdf->SetSubject('Report'); 
	$tcpdf->SetHeaderData($headerimage, PDF_HEADER_LOGO_WIDTH, $facilitynamewithreport, $headerString, $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true));  
	$tcpdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$tcpdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA)); 
	$tcpdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED); 
	$tcpdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$tcpdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$tcpdf->SetFooterMargin(PDF_MARGIN_FOOTER); 
	$tcpdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM); 
 	$tcpdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 
	$tcpdf->SetFont('dejavusans', '', 8); 
	$tcpdf->AddPage();  
$html = '<table width="100%" cellpadding="2" cellspacing="0" border="1" class="table_format" style="padding-top:10px" >
		 <tr style="background-color:#3796CB;color:#FFFFFF;">
				<td colspan = "9" align="center"><strong>'.ucfirst($getLocName).'</strong></td>
			  </tr>
			  <tr>
				<td colspan = "9" align="center"><strong>'.ucfirst($getLocAdd1).' '.ucfirst($getLocAdd2).' '.ucfirst($location_zipcode).','.ucfirst($location_country).'</strong></td>
			  </tr>
			 <tr style="background-color:#3796CB;color:#FFFFFF;">
				<td colspan = "9" align="center"><strong>Pharmacy Gross Profit Report Report</strong></td>
			  </tr>
			  <tr>
				<td colspan = "9" align="center"><strong>'.$this->DateFormat->formatDate2Local($from,Configure::read('date_format'), false).'</strong> to <strong>'.$this->DateFormat->formatDate2Local($to,Configure::read('date_format'), false).'</strong></td>
			  </tr>
<tr style="background-color:#3796CB;color:#FFFFFF;"> 
<th width="6%" align="center" valign="top">Sr.No.</th>	
	<th width="14%" align="center" valign="top">Sold Item</th> 
	<th width="12%" align="center" valign="top" style="text-align: center;">Purchase Per Piece </th>
	<th width="12%" align="center" valign="top" style="text-align: center;">Purchase Price </th>
	<th width="12%" align="center" valign="top" style="text-align: center;">Sale Per Piece</th>
	<th width="11%" align="center" valign="top" style="text-align: center;">Sale Price</th>
	<th width="11%" align="center" valign="top" style="text-align: center;">Quantity</th>
	<th width="11%" align="center" valign="top" style="text-align: center;">Rupees Wise Profit</th> 
	<th width="11%" align="center" valign="top" style="text-align: center;">% Wise Profit</th> 		
</tr>';
if(count($itemArr)>0){
$i=0;
	$cnt=1;		
foreach($itemArr as $key=>$itemArrs){
	$i++;

 if($i%2 == 0){ 
 	$html .='<tr style="background-color:#E5F4FC;">'; 	
 }else{
 	$html .='<tr>';
 }

$singlePurchasePrice = round($itemArrs['PharmacyItemRate']['purchase_price']/$itemArrs['PharmacyItem']['pack'],2);
$totalPurchase = round($singlePurchasePrice * $itemArrs[0]['qtySum'],2);
$getPurchasePriceTotal=$getPurchasePriceTotal+$totalPurchase ;
$singleSalePrice = round($itemArrs['PharmacyItemRate']['mrp']/$itemArrs['PharmacyItem']['pack'],2);
$totalSales = round($singleSalePrice * $itemArrs[0]['qtySum'],2);
$getSellingPriceTotal=$getSellingPriceTotal+$totalSales;
$getPercentageProfit=(($totalSales-$totalPurchase)/$totalPurchase)*100; 

$html .='<td align="center">'.$cnt.'</td>
<td align="center">'.$itemArrs['PharmacyItem']['name'].'</td>
<td align="center">'.$singlePurchasePrice.'</td>
<td align="center">'.$totalPurchase.'</td>
<td align="center">'.$singleSalePrice.'</td>
<td align="center">'.$totalSales.'</td> 
<td align="center">'.$itemArrs[0]['qtySum'].'</td>
<td align="center">'.round($totalSales - $totalPurchase,2).'</td>
<td align="center">'.number_format($getPercentageProfit,2).'%</td>
</tr>';
$cnt++;
}

$html .='<tr style="background-color:#3796CB;color:yellow;">	
	<td	 align="center"><strong></strong></td>
	<td	 align="center"><strong></strong></td>
	<td	 align="center"><strong></strong></td>
	<td align="center"><strong>'.round($getPurchasePriceTotal,2).'</strong></td>
	<td	 align="center"><strong></strong></td>
	<td align="center"><strong>'.round($getSellingPriceTotal,2).'</strong></td>
	<td	 align="center"><strong></strong></td>
	<td align="center"><strong>'.round($getSellingPriceTotal-$getPurchasePriceTotal,2).'</strong></td>
	<td align="center"><strong>'.number_format($getPercentageProfit,2).'%</strong></td>
</tr>';
}else{
$html .='<tr>
<td colspan="9" align="center" style="background-color:#B4DFF7;">No Record Found.
</td>
</tr>';
}
$html .='</table>'; 
	$tcpdf->writeHTML($html, true, false, true, false, '');
	 
	// reset pointer to the last page
	$tcpdf->lastPage(); 
	
	//Close and output PDF document
	echo $tcpdf->Output('Pharmacy_Gross_Profit_Report '.$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).'.pdf', 'D');
 
 ?>			