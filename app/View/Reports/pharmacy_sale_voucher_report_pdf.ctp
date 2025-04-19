<?php
ob_clean();
	App::import('Vendor','tcpdf/config/lang/eng'); 
	App::import('Vendor','tcpdf/tcpdf');
	$facilityname = ucfirst($this->Session->read("facility"));
	$headerimage = $this->Session->read("header_image");
	$facilitynamewithreport;
	
	if(empty($facilityname)) {
	  	$facilitynamewithreport = 'Monthly Summery Of Sale Vouchers Report'; 
	  	$facilityname = "";
	}
	else {
	    $headerString = "by ".$facilityname ;
		$facilitynamewithreport = $facilityname.'-Monthly Summery Of Sale Vouchers Report'; 
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
$html = '<table border="1" class="table_format"  cellpadding="2" cellspacing="0" width="100%" style="text-align:left;padding-top:50px;">	
			  <tr>
				<td colspan = "5" align="center"><strong>'. __('Monthly Summary Of Sale Vouchers From ').$this->DateFormat->formatDate2Local($from,Configure::read('date_format'), false).'</strong> to <strong>'.$this->DateFormat->formatDate2Local($to,Configure::read('date_format'), false).'</strong></td>
			  </tr>
		      <tr style="background-color:#3796CB;color:#FFFFFF;">				
				   <td height="30px" align="center" valign="middle" width="20%"><strong>'. __('Gross Amt').'</strong></td> 
				   <td height="30px" align="center" valign="middle" width="20%"><strong>'. __('Disc Amt').'</strong></td>					  
				   <td height="30px" align="center" valign="middle" width="20%"><strong>'. __('Total Amt').'</strong></td>  
				   <td height="30px" align="center" valign="middle" width="20%"><strong>'. __('Cash Amt').'</strong></td>				  
 					<td height="30px" align="center" valign="middle" width="20%"><strong>'. __('Credit Amt').'</strong></td> 					
			   </tr>';
			 
				     			
						$html .= '<tr>												
							<td align="center" height="17px">'. $getGrossAmt.'</td>';								
							$html .='<td align="center" height="17px">'. $getTotalDiscAmt.'</td>		
							<td align="center" height="17px">'.$getTotalAmt.'</td>';							
							$html .= '<td align="center" height="17px">'. $totalCashAmt.'</td>							
							<td align="center" height="17px">'. $totalCreditAmt.'</td>
						</tr>';
				$html .= '</table>';

$tcpdf->writeHTML($html, true, false, true, false, '');
	 
	// reset pointer to the last page
	$tcpdf->lastPage(); 
	
	//Close and output PDF document
	echo $tcpdf->Output('Monthly Summery Of Sale Vouchers Report'.$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).'.pdf', 'D');
 
 ?>