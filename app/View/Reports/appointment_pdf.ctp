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
	  	$facilitynamewithreport = 'Appointment Report'; 
	  	$facilityname = "";
	}
	else {
	    $headerString = "by ".$facilityname ;
		$facilitynamewithreport = $facilityname.'-Appointment Report'; 
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
          <td height="30px" align="center" valign="middle" width="5%"><strong>MRN</strong></td>  
		  <td height="30px" align="center" valign="middle" width="10%"><strong>Date of Reg.</strong></td>  
		  <td height="30px" align="center" valign="middle" width="10%"><strong>MRN</strong></td>  
		  <td height="30px" align="center" valign="middle" width="10%"><strong>Patient Name</strong></td>
		  <td height="30px" align="center" valign="middle" width="5%"><strong>Visit Type</strong></td>
		  <td height="30px" align="center" valign="middle" width="10%"><strong>Treating Consultant</strong></td>
          <td height="30px" align="center" valign="middle" width="5%"><strong>Age</strong></td>
		  <td height="30px" align="center" valign="middle" width="10%"><strong>Specilty</strong></td>
          <td height="30px" align="center" valign="middle" width="5%"><strong>Sex</strong></td>
          <td height="30px" align="center" valign="middle" width="10%"><strong>Appointment Date</strong></td>
          <td height="30px" align="center" valign="middle" width="10%"><strong>Appointment Start Time</strong></td>
          <td height="30px" align="center" valign="middle" width="10%"><strong>Appointment End Time</strong></td>
		 </tr>';
       $appointCnt=0;
       if(count($getAppointmentReport) > 0) {
		
		foreach($getAppointmentReport as $getAppointmentReportVal) {
                 $appointCnt++;
		  $html .= '<tr>';
		          $html .= '<td align="center" height="17px">'.$appointCnt.'</td>';
				  $html .= '<td align="center" height="17px">'.date("d/m/Y", strtotime($this->DateFormat->formatDate2Local($getAppointmentReportVal['Patient']['form_received_on'],'yyyy/mm/dd',true))).'</td>';
				   $html .= '<td align="center" height="17px">'.$getAppointmentReportVal['Patient']['admission_id'].'</td>';
                  $html .= '<td align="center" height="17px">'.$getAppointmentReportVal['PatientInitial']['name'].' '.$getAppointmentReportVal['Patient']['lookup_name'].'</td>';
                  $html .= '<td align="center" height="17px">'.str_replace("_", " ", $getAppointmentReportVal['TariffList']['name']).'</td>';
                  $html .= '<td align="center" height="17px">'.$getAppointmentReportVal[0]['doctor_name'].'</td>';
                  $html .= '<td align="center" height="17px">'.$getAppointmentReportVal['Patient']['age'].'</td>';
                  $html .= '<td align="center" height="17px">'.$getAppointmentReportVal['Department']['name'].'</td>';
                  $html .= '<td align="center" height="17px">'.ucfirst($getAppointmentReportVal['Patient']['sex']).'</td>';
                  $html .= '<td align="center" height="17px">'.$this->DateFormat->formatDate2Local($getAppointmentReportVal['Appointment']['date'],Configure::read('date_format'), false).'</td>';
                  $html .= '<td align="center" height="17px">'.$getAppointmentReportVal['Appointment']['start_time'].'</td>';
                  $html .= '<td align="center" height="17px">'.$getAppointmentReportVal['Appointment']['end_time'].'</td>';
                  $html .= '</tr>';
		 }
            $html .= '<tr>';
            $html .= '<td colspan="12" align="center"><strong>'.__('Total').'&nbsp;</strong>'.$appointCnt.'</td>';
            $html .= '</tr>';     
        } else {
           $html .= '<tr>';
           $html .= '<td align="center" height="17px" colspan="12">No Record Found</td>';
           $html .= '</tr>';
        }
        $html .= '</table>';
        
	
	
	// output the HTML content
	$tcpdf->writeHTML($html, true, false, true, false, '');
	 
	// reset pointer to the last page
	$tcpdf->lastPage(); 
	
	//Close and output PDF document
	echo $tcpdf->Output('Appointment_Report'.$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).'.pdf', 'D');
	
?>