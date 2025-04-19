<?php
ob_clean();
	App::import('Vendor','tcpdf/config/lang/eng'); 
	App::import('Vendor','tcpdf/tcpdf');
	$facilityname = ucfirst($this->Session->read("facility"));
	$headerimage = $this->Session->read("header_image");
	$facilitynamewithreport;
	
	if(empty($facilityname)) {
	  	$facilitynamewithreport = 'Pharmacy Sales Collection Report'; 
	  	$facilityname = "";
	}
	else {
	    $headerString = "by ".$facilityname ;
		$facilitynamewithreport = $facilityname.'-Pharmacy Sales Collection Report'; 
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
			  <tr style="background-color:#3796CB;color:#FFFFFF;">
				<td colspan = "5" align="center"><strong>Pharmacy Sales Collection Report</strong></td>
			  </tr>
			  <tr>
				<td colspan = "5" align="center"><strong>'.$this->DateFormat->formatDate2Local($from,Configure::read('date_format'), false).'</strong> to <strong>'.$this->DateFormat->formatDate2Local($to,Configure::read('date_format'), false).'</strong></td>
			  </tr>

			  <tr style="background-color:#3796CB;color:#FFFFFF;">
				<td height="10px" align="center" valign="middle" width="6%"><strong>'. __('Sr.No.').'</strong></td>	
					<td height="30px" align="center" valign="middle" width="23%"><strong>'. __('Date').'</strong></td> 							  
				   <td height="30px" align="center" valign="middle" width="25%"><strong>'. __('Patient Name').'</strong></td>  						  
 					<td height="30px" align="center" valign="middle" width="23%"><strong>'. __('Credit Amount').'</strong></td>
 					<td height="30px" align="center" valign="middle" width="23%"><strong>'. __('Cash Amount').'</strong></td> 
			   </tr>';
			 
				if(count($recordArr)>0) {
			    $k = 0; 
				 $cnt = 1; 
	      		foreach($recordArr as  $key=>$report){	
	      				$html .= '<tr>
								<td align="center" height="17px">'.$cnt.'</td>	
							<td align="center" height="17px">'. $this->DateFormat->formatDate2Local($report['create_time'],Configure::read('date_format')).'</td>';
							if(empty($report['patient_id']))
								$html .= '<td align="center" height="17px">'.$report['customer_name'].'</td>	';
								else
								$html .= '<td align="center" height="17px">'.$report['lookup_name'].'</td>	'; 
							$html .='<td align="center" height="17px">'. $report['credit_amnt'].'</td>';
						
							$html .= '<td align="center" height="17px">'.$report['cash_amnt'].'</td>
						</tr>';			
					$html .='<tr style="background-color:#90D1F4;"><td colspan="5"></td></tr>';
					$k++;
					$totCash[$k]=$report['cash_amnt'];
				  $totCredit[$k]=$report['credit_amnt'];
				$cnt++;
				$k++;
				}
		
$getCashTotal=array_sum($totCash);
$getCreditTotal=array_sum($totCredit);
$grandTotal=$getCashTotal+$getCreditTotal;
$html .='<tr  style="background-color:#3796CB;color:yellow;">	
<td align="right" colspan="3"><strong></strong></td>	
	<td align="center" ><strong>'.round(array_sum($totCredit)).'</strong></td>
	<td align="center"><strong>'.round(array_sum($totCash)).'</strong></td>
</tr>

<tr  style="background-color:#3796CB;color:yellow;">			
	<td align="right" colspan="3"><strong>Grand Total</strong></td>	
	<td align="center" colspan="2"> <strong>'.round($grandTotal).'</strong></td>
</tr>';
}else{
$html .='<tr>
<td colspan="5" align="center" style="background-color:#B4DFF7;">No Record Found.
</td>
</tr>';
}

$html .='</table>';
$tcpdf->writeHTML($html, true, false, true, false, '');
	 
	// reset pointer to the last page
	$tcpdf->lastPage(); 
	
	//Close and output PDF document
	echo $tcpdf->Output('Pharmacy Sales Collection Report '.$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).'.pdf', 'D');
 
 ?>