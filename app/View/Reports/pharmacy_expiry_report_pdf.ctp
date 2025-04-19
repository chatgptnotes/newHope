<?php
ob_clean();
	App::import('Vendor','tcpdf/config/lang/eng'); 
	App::import('Vendor','tcpdf/tcpdf');
	$facilityname = ucfirst($this->Session->read("facility"));
	$headerimage = $this->Session->read("header_image");
	$facilitynamewithreport;
	
	if(empty($facilityname)) {
	  	$facilitynamewithreport = 'Pharmacy Expiry Report'; 
	  	$facilityname = "";
	}
	else {
	    $headerString = "by ".$facilityname ;
		$facilitynamewithreport = $facilityname.'-Pharmacy Expiry Report'; 
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
$html = '<table width="100%" cellpadding="2" cellspacing="0" border="1" class="table_format"  style="text-align:left;padding-top:50px;" >
		     <tr style="background-color:#3796CB;color:#FFFFFF;">
				<td colspan = "5" align="center"><strong>'.ucfirst($getLocName).'</strong></td>
			  </tr>
			  <tr>
				<td colspan = "5" align="center"><strong>'.ucfirst($getLocAdd1).' '.ucfirst($getLocAdd2).' '.ucfirst($location_zipcode).','.ucfirst($location_country).'</strong></td>
			  </tr>
			  
		<tr>
				<td colspan = "5" align="center"><strong>Pharmacy Expiry Report</strong></td>
		 </tr>
<tr style="background-color:#3796CB;color:#FFFFFF;">';
if($flagRemaining=="0"){
$html .='<th width="6%" align="center" valign="top">Sr.No.</th>
	<th width="35%" align="center" valign="top">Product Name</th>
	<th width="29%" align="center" valign="top" style="text-align: center;">Batch No. </th>
	<th width="30%" align="center" valign="top" style="text-align: center;">Expiry Date</th>';
}else{
	$html .='<th width="6%" align="center" valign="top">Sr.No.</th>
	<th width="25%" align="center" valign="top">Product Name</th>
	<th width="25%" align="center" valign="top" style="text-align: center;">Batch No. </th>
	<th width="25%" align="center" valign="top" style="text-align: center;">Expiry Date</th>';
}
	 if($flagRemaining){
$html .=' <th width="19%" align="center" valign="top" style="text-align: center;">Days Remaining in Expiry/Expired</th> ';
	 }	
$html .='</tr>';
	$cnt=1;		
$i=0;
if(count($pharmacyItemDetails)>0) {
foreach($pharmacyItemDetails as $key=>$pharmacyItemDetailss){
$i++;
if($i%2 == 0){ 
 	$html .='<tr style="background-color:#E5F4FC;">'; 	
 }else{
 	$html .='<tr>';
 }

$html .='<td align="center">'.$cnt.'</td>
<td align="center">'.$pharmacyItemDetailss['PharmacyItem']['name'].'</td>
<td align="center">'. $pharmacyItemDetailss['PharmacyItemRate']['batch_number'].'</td>
<td align="center">'.$this->DateFormat->formatDate2Local($pharmacyItemDetailss['PharmacyItemRate']['expiry_date'],Configure::read('date_format')).'</td>';
 if($flagRemaining){
				$d_start = new DateTime(date('Y-m-d'));
				$d_end      = new DateTime($pharmacyItemDetailss['PharmacyItemRate']['expiry_date']);
				$diff = $d_start->diff($d_end);	
				$getDays=$diff->days;
				if($getDays=="0"){
					$getDays="Expired";
				}
$html .='<td align="center">'.$getDays.'</td>'; 
 }
$html .='</tr>';
$cnt++;
}
}else{
$html .='<tr>
<td colspan="5" align="center" style="background-color:#E5F4FC;">No Record Found.</td>
</tr>';
}
$html .='</table>'; 
	$tcpdf->writeHTML($html, true, false, true, false, '');
	 
	// reset pointer to the last page
	$tcpdf->lastPage(); 
	
	//Close and output PDF document
	echo $tcpdf->Output('pharmacy_expiry_report '.$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).'.pdf', 'D');
 
 ?>			