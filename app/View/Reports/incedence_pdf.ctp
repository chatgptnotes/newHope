<?php
	
	//App::import("Vendor","xtcpdf"); 
	//$tcpdf = new XTCPDF();	
	//ob_clean();
	App::import("Vendor","tcpdf/config/lang/eng"); 
	App::import("Vendor","tcpdf/tcpdf");
	$facilityname = ucfirst($this->Session->read("facility"));
	$headerimage = $this->Session->read("header_image");
	$facilitynamewithreport;
	
	if(empty($facilityname)) {
	  	$facilitynamewithreport = 'Incidence Report'.' - '.$year;; 
	  	$facilityname = "";
	}
	else {
	    $headerString = "by ".$facilityname ;
		$facilitynamewithreport = $facilityname.'-Incidence Report'.' - '.$year;; 
	}
	$tcpdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, "UTF-8", false);
	// set document information
	$tcpdf->SetCreator(PDF_CREATOR);
	$tcpdf->SetAuthor($facilityname);
	$tcpdf->SetTitle($facilitynamewithreport);
	$tcpdf->SetSubject("Report");
	//$tcpdf->SetKeywords("TCPDF, PDF, example, test, guide");
	 
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
 
	$html ='<div style="margin-top:200px;">&nbsp;<span>Date: '.$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), false).'</span><br></div>';
	$html .= 	 '<table border="1"  cellpadding="0" cellspacing="0" width="100%" style="text-center;padding-top:50px;">';
			 			  
	$html .= '<tr class="row_title" style="background-color:#A1B6BE;">
			   <td height="30px" align="center" valign="middle"><strong>Month</strong></td>		
			   <td height="30px" align="center" valign="middle"><strong>Medication errors</strong></td>' ;
			   
			   foreach($incidentType as $typeName){ 
			   		$html .= '<td height="30px" align="center" valign="middle"><strong>'.$typeName["IncidentType"]["name"].'</strong></td>';
			   }
	$html .="</tr>"; 
	
	$month =array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
	$fullMonth =array("January","February","March","April","May","June","July","August","September","October","November","December");
	$j=0;
	foreach($month as $mon){ 
					$fullMon =  $fullMonth[$j] ;
	$html .='<tr>
					<td align="center" height="17px">'.$fullMon.'</td>
			  		<td align="center" height="17px">'.round($record[$fullMon]["medication_error"]/$discharge[$fullMon],2).'</td>';
	
	foreach($incidentType as $typeName){ 
		$ss = ($discharge[$fullMon]>0)?round($record[$fullMon][$typeName["IncidentType"]["name"]]/$discharge[$fullMon],2):0 ;
		$html .= '<td align="center" height="17px">'.$ss.'</td>';
	}
	 
	$html .="</tr>"; 
		   $j++;
		
				 }  		   		  
	$html .="</table>";

	 
	// output the HTML content
	$tcpdf->writeHTML($html, true, false, true, false, "");
	 
	// reset pointer to the last page
	$tcpdf->lastPage(); 
	
	//Close and output PDF document
	echo $tcpdf->Output("Incidence_Report".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".pdf", "D");
	
?>