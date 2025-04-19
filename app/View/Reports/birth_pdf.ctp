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
	  	$facilitynamewithreport = 'Birth Report'; 
	  	$facilityname = "";
	}
	else {
	    $headerString = "by ".$facilityname ;
		$facilitynamewithreport = $facilityname.'-Birth Report'; 
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

	$html ='<div style="margin-top:200px;">&nbsp;<span>Date: '.$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), false).'</span><br></div>';
          $html .= '<br /><table border="1" cellpadding="0" cellspacing="0" width="100%">';
          $html .= '<tr class="row_title" style="background-color:#A1B6BE;">
		  <td height="30px" align="center" valign="middle" width="5%"><strong>'. __("Sr.No."). '</strong></td> 
		  <td height="30px" align="center" valign="middle" width="10%"><strong>'. __("Date of Reg."). '</strong></td> 
		  <td height="30px" align="center" valign="middle" width="10%"><strong>'. __("MRN"). '</strong></td> 
		  <td height="30px" align="center" valign="middle" width="10%"><strong>'. __("Mother Name"). '</strong></td>
		  <td height="30px" align="center" valign="middle" width="10%"><strong>'. __("Father Name"). '</strong></td>					  
		  <td height="30px" align="center" valign="middle" width="10%"><strong>'. __("Doctor"). '</strong></td>
          <td height="30px" align="center" valign="middle" width="5%"><strong>'. __("Mother Age"). '</strong></td>
		  <td height="30px" align="center" valign="middle" width="10%"><strong>'. __("Sex"). '</strong></td>
          <td height="30px" align="center" valign="middle" width="10%"><strong>'. __("Date of Birth"). '</strong></td>
          <td height="30px" align="center" valign="middle" width="10%"><strong>'. __("Method of Delivery"). '</strong></td>
          <td height="30px" align="center" valign="middle" width="10%"><strong>'. __("Birth Weight"). '</strong></td>
		 </tr>';
		 $birthReportCnt=0;
       if(count($getBirthReport) > 0) {
		
		foreach($getBirthReport as $getBirthReportVal) {
			$birthReportCnt++;
               if($getBirthReportVal['ChildBirth']['sex'] == "Son") $sex = __("Male");  else $sex =  __("Female");  
		  $html .= '<tr>';
		          $html .= '<td align="center" height="30px">'.$birthReportCnt.'</td>';
				  $html .= '<td align="center" height="30px">'.date("d/m/Y", strtotime($this->DateFormat->formatDate2Local($getBirthReportVal['Patient']['form_received_on'],'yyyy/mm/dd',true))).'</td>';
				  $html .= '<td align="center" height="30px">'.$getBirthReportVal['Patient']['admission_id'].'</td>';
				  $html .= '<td align="center" height="30px">'.$getBirthReportVal['ChildBirth']['mother_name'].'</td>';
                  $html .= '<td align="center" height="30px">'.$getBirthReportVal['ChildBirth']['father_name'].'</td>';
                  $html .= '<td align="center" height="30px">'.$getBirthReportVal[0]['doctor_name'].'</td>';
                  $html .= '<td align="center" height="30px">'.$getBirthReportVal['Patient']['age'].'</td>';
                  $html .= '<td align="center" height="30px">'.$sex.'</td>';
                  $html .= '<td align="center" height="30px">'.$this->DateFormat->formatDate2Local($getBirthReportVal['ChildBirth']['dob'],Configure::read('date_format'), true).'</td>';
                  $html .= '<td align="center" height="17px">'.$getBirthReportVal['ChildBirth']['method_of_delivery'].'</td>';
                  $html .= '<td align="center" height="17px">'.$getBirthReportVal['ChildBirth']['birth_weight'].'</td>';
                  $html .= '</tr>';
		 }
                
        } else {
           $html .= '<tr>';
           $html .= '<td align="center" height="17px" colspan="11">'. __('No Record Found'). '</td>';
           $html .= '</tr>';
        }
        
        $html .= '</table>';
        
        
		
	// output the HTML content
	$tcpdf->writeHTML($html, true, false, true, false, '');
	 
	// reset pointer to the last page
	$tcpdf->lastPage(); 
	
	//Close and output PDF document
	echo $tcpdf->Output('Birth_Report'.$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).'.pdf', 'D');
	
?>