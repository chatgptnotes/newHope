<?php
	
	//App::import('Vendor','xtcpdf'); 
	//$tcpdf = new XTCPDF();	
	//ob_clean();
	App::import('Vendor','tcpdf/config/lang/eng'); 
	App::import('Vendor','tcpdf/tcpdf');
	$facilityname = ucfirst($this->Session->read("facility"));
	$headerimage = $this->Session->read("header_image");
	$facilitynamewithreport;
	
	if(empty($facilityname)) {
	  	$facilitynamewithreport = 'Time Taken For Initial Assessment'.' - '.$reportYear;
	  	$facilityname = "";
	}
	else {
	    $headerString = "by ".$facilityname ;
		$facilitynamewithreport = $facilityname.'-Time Taken For Initial Assessment'.' - '.$reportYear; 
	}
	$tcpdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	// set document information
	$tcpdf->SetCreator(PDF_CREATOR);
	$tcpdf->SetAuthor($facilityname);
	$tcpdf->SetTitle($facilitynamewithreport);
	$tcpdf->SetSubject('Report');
	//$tcpdf->SetKeywords('TCPDF, PDF, example, test, guide');
	 
	// set default header data
	$tcpdf->SetHeaderData($headerimage, PDF_HEADER_LOGO_WIDTH, $facilitynamewithreport, $headerString, $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true));
	
	// set header and footer fonts
	$tcpdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$tcpdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
	
	// set default monospaced font
	$tcpdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
	
	//set margins
	$tcpdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$tcpdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$tcpdf->SetFooterMargin(PDF_MARGIN_FOOTER);
	
	//set auto page breaks
	$tcpdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	
	//set image scale factor
	$tcpdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		
	// ---------------------------------------------------------
	
	// set font
	$tcpdf->SetFont('dejavusans', '', 6);

	
	// add a page (required with recent versions of tcpdf)
	$tcpdf->AddPage(); 

	
	$html ='<div style="margin-top:200px;">&nbsp;<span>Date: '.date('d/m/Y').'</span><br></div>
	   
		<table border="1" cellpadding="0" cellspacing="0" width="100%" >	
			
			<tr style="background-color:#A1B6BE;" class="row_title">
				<td height="30px"></td>';
			
			foreach($yaxisArray as $key => $yaxisArrayVal) {
				$html .= '<td height="30px" align="center"><strong>'.$yaxisArrayVal.'</strong></td>';
			}
				$html .= '</tr>
						<tr>
							<td style="padding-left:10px;"><strong>Time Taken For Initial Assessment For  '.$patientType.'</strong></td>';
			foreach($yaxisArray as $key => $yaxisArrayVal) {
				if(@in_array($key, $filterdischargeDeathDateArray)) {
					$html .= '<td align="center">'.$filterdischargeDeathCountArray[$key].'</td>';
				} else {  
					$html .= '<td align="center">0</td>'; 
				}
			}
				$html .= '</tr>
						  <tr>
							<td colspan="13" align="center"><strong>Total Time Taken for Initial Assessment of In Patient:&nbsp;'.$avgTimeTaken.' Hrs.</strong></td>
							
						  </tr>
						</table>';
	//pr($html);exit;
	// output the HTML content
	$tcpdf->writeHTML($html, true, false, true, false, '');
	 
	// reset pointer to the last page
	$tcpdf->lastPage(); 
	
	//Close and output PDF document
	//echo $tcpdf->Output('Initial_Assessment'.$patientType.date('d-m-Y h-i-s').'.pdf', 'D');
	echo $tcpdf->Output('Time_Taken_For_Initial_Assessment'.$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).'.pdf', 'D');
	
?>