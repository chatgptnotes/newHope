<?php
ob_clean();
	App::import('Vendor','tcpdf/config/lang/eng'); 
	App::import('Vendor','tcpdf/tcpdf');
	$facilityname = ucfirst($this->Session->read("facility"));
	$headerimage = $this->Session->read("header_image");
	$facilitynamewithreport;
	
	if(empty($facilityname)) {
	  	$facilitynamewithreport = 'Pharmacy Stock & Sales Report'; 
	  	$facilityname = "";
	}
	else {
	    $headerString = "by ".$facilityname ;
		$facilitynamewithreport = $facilityname.'-Pharmacy Stock & Sales Report'; 
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
$html = '<table width="100%" cellpadding="2" cellspacing="0" border="1" class="table_format"  style="text-align:left;padding-top:50px;">
		 <tr style="background-color:#3796CB;color:#FFFFFF;">
			<td colspan = "7" align="center"><strong>'.ucfirst($getLocName).'</strong></td>
	     </tr>
	     <tr>
			<td colspan = "7" align="center"><strong>'.ucfirst($getLocAdd1).' '.ucfirst($getLocAdd2).' '.ucfirst($location_zipcode).','.ucfirst($location_country).'</strong></td>
		 </tr>
		<tr>
				<td colspan = "7" align="center"><strong>Pharmacy Stock & Sales Report</strong></td>
		 </tr>
<tr style="background-color:#3796CB;color:#FFFFFF;"> 
<th width="6%" align="center" valign="top">Sr.No.</th>
	<th width="23%" align="center" valign="top">Product Name</th>		
	<th width="14%" align="center" valign="top" style="text-align: center;">Opening Stock</th>
	<th width="14%" align="center" valign="top" style="text-align: center;">Received Stock</th> 
	<th width="14%" align="center" valign="top" style="text-align: center;">Stock Sold</th>
	<th width="14%" align="center" valign="top" style="text-align: center;">Closing Stock</th>
	<th width="15%" align="center" valign="top" style="text-align: center;">Value</th> 	
</tr>';
if(count($commanPharmacyArr)>0){
$i=0;
	$cnt=1;		
foreach($commanPharmacyArr as $key=>$pharmacyItemDetailss){
	$i++;

 if($i%2 == 0){ 
 	$html .='<tr style="background-color:#E5F4FC;">'; 	
 }else{
 	$html .='<tr>';
 }
$getPurSaleMinus=($pharmacyItemDetailss['PurchaseOrderItem'][0]['new_quantity_received'])-($pharmacyItemDetailss['PharmacySalesBillDetail'][0]['new_qty']);
$getOpeningStock=($pharmacyItemDetailss['PharmacyItem'][0]['pack']*$pharmacyItemDetailss['PharmacyItem'][0]['stock'])-$getPurSaleMinus;
$getOpeningStock1=abs($getOpeningStock);
$getClosingStock=($getOpeningStock1+$pharmacyItemDetailss['PurchaseOrderItem'][0]['new_quantity_received'])-$pharmacyItemDetailss['PharmacySalesBillDetail'][0]['new_qty'];

 $getTabValues=((int)$pharmacyItemDetailss['PharmacyItem'][0]['pack'] * $pharmacyItemDetailss['PharmacyItem'][0]['stock']) + $pharmacyItemDetailss['PharmacyItem'][0]['loose_stock'];
$getValue=$pharmacyItemDetailss['PharmacyItem']['0']['new_sale_price']/$pharmacyItemDetailss['PharmacyItem'][0]['pack'];
$getTabFinValue[$key]=round($getTabValues*$getValue);


 $html .='<td align="center">'.$cnt.'</td>
<td align="center">'.$pharmacyItemDetailss['PharmacyItem'][0]['name'].'</td>
<td align="center">'.$getOpeningStock1.'</td>
<td align="center">'.$pharmacyItemDetailss['PurchaseOrderItem'][0]['new_quantity_received'].'</td>
<td align="center">'.$pharmacyItemDetailss['PharmacySalesBillDetail'][0]['new_qty'].'</td> 
<td align="center">'.$getClosingStock.'</td> 
<td align="center">'.round($getTabValues*$getValue).'</td>
</tr>';
$cnt++;
}
$gradTotal=array_sum($getTabFinValue);
$html .='<tr style="background-color:#3796CB;color:yellow;">			
	<td align="right" colspan="6"><strong>Total Value</strong></td>
	<td align="center"><strong>'.round($gradTotal).'</strong></td>
	</tr>';
}else{
$html .='<tr>
<td colspan="7" align="center" style="background-color:#B4DFF7;">No Record Found.
</td>
</tr>';
}
$html .='</table>'; 
	$tcpdf->writeHTML($html, true, false, true, false, '');
	 
	// reset pointer to the last page
	$tcpdf->lastPage(); 
	
	//Close and output PDF document
	echo $tcpdf->Output('Pharmacy_Stock_&_Sales_Report'.$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).'.pdf', 'D');
 
 ?>			