<?php
ob_clean();
	App::import('Vendor','tcpdf/config/lang/eng'); 
	App::import('Vendor','tcpdf/tcpdf');
	$facilityname = ucfirst($this->Session->read("facility"));
	$headerimage = $this->Session->read("header_image");
	$facilitynamewithreport;
	
	if(empty($facilityname)) {
	  	$facilitynamewithreport = 'Pharmacy Purchase Report'; 
	  	$facilityname = "";
	}
	else {
	    $headerString = "by ".$facilityname ;
		$facilitynamewithreport = $facilityname.'-Pharmacy Purchase Report'; 
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
$html = '<table width="100%" cellpadding="2" cellspacing="0" border="1" class="table_format" style="text-align:left;padding-top:100px;" >
	    <tr style="background-color:#3796CB;color:#FFFFFF;">
			<td colspan = "6" align="center"><strong>'.ucfirst($getLocName).'</strong></td>
		</tr>
		<tr>
			<td colspan = "6" align="center"><strong>'.ucfirst($getLocAdd1).' '.ucfirst($getLocAdd2).' '.ucfirst($location_zipcode).','.ucfirst($location_country).'</strong></td>
		</tr>
		<tr style="background-color:#3796CB;color:#FFFFFF;">
				<td colspan = "6" align="center"><strong>Pharmacy Purchase Report</strong></td>
		 </tr>
		 <tr>
			   <td colspan = "6" align="center"><strong>'.$this->DateFormat->formatDate2Local($from,Configure::read('date_format'), false).'</strong> to <strong>'.$this->DateFormat->formatDate2Local($to,Configure::read('date_format'), false).'</strong></td>
		 </tr>
<tr style="background-color:#3796CB;color:#FFFFFF;"> 
	<th width="6%" align="center" valign="top">Sr.No.</th>
	<th width="26%" align="center" valign="top">Party Name</th>
	<th width="17%" align="center" valign="top" style="text-align: center;">Bill No. </th>
	<th width="17%" align="center" valign="top" style="text-align: center;">Amount</th>
	<th width="17%" align="center" valign="top" style="text-align: center;">Tax Amount</th> 
	<th width="17%" align="center" valign="top" style="text-align: center;">Total</th> 	
</tr>';
if(count($pharmacyItemDetails)>0){
$i=0;
	$cnt=1;		
foreach($pharmacyItemDetails as $key=>$pharmacyItemDetailss){
	$i++;

 if($i%2 == 0){ 
 	$html .='<tr style="background-color:#E5F4FC;">'; 	
 }else{
 	$html .='<tr>';
 }
$html .='<td align="center">'.$cnt.'</td>
<td align="center">'.$pharmacyItemDetailss['InventorySupplier']['name'].'</td>
<td align="center">'.$pharmacyItemDetailss['PurchaseOrderItem']['party_invoice_number'].'</td>
<td align="center">'.$pharmacyItemDetailss['PurchaseOrderItem']['purchase_price'].'</td>
<td align="center">'.round(($pharmacyItemDetailss['PurchaseOrderItem']['tax']*$pharmacyItemDetailss['PurchaseOrderItem']['amount'])/100).'</td> 
<td align="center">'.round($pharmacyItemDetailss['PurchaseOrderItem']['amount']).'</td> 
</tr>';
$cnt++;
}
$html .='<tr  style="background-color:#3796CB;color:#FFFFFF;">
<td colspan="5" align="right">Grand Total</td>
<td align="center">'.round($getGrandTotal).'</td>
</tr>';
}else{
$html .='<tr>
<td colspan="6" align="center" style="background-color:#B4DFF7;">No Record Found.
</td>
</tr>';
}
$html .='</table>'; 
	$tcpdf->writeHTML($html, true, false, true, false, '');
	 
	// reset pointer to the last page
	$tcpdf->lastPage(); 
	
	//Close and output PDF document
	echo $tcpdf->Output('pharmacy_purchase_report'.$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).'.pdf', 'D');
 
 ?>			