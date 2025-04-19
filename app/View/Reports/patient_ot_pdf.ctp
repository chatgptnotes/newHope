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
	  	$facilitynamewithreport = 'Total Surgery Report'; 
	  	$facilityname = "";
	}
	else {
	    $headerString = "by ".$facilityname ;
		$facilitynamewithreport = $facilityname.'-Total Surgery Report'; 
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

	
	$html ='<div style="margin-top:200px;">&nbsp;<span>Date: '.$this->DateFormat->formatDate2Local(date('Y-m-d'),Configure::read('date_format'), false).'</span><br><br></div>
	   
		<table border="1" class="table_format"  cellpadding="0" cellspacing="0" width="100%" style="text-align:left;padding-top:50px;">				  
			<tr class="row_title" style="background-color:#A1B6BE;">
				<td height="30px" align="center" valign="middle" width="5%"><strong>Sr.No.</strong></td>
				<td height="30px" align="center" valign="middle" width="8%"><strong>Date Of Reg.</strong></td>
				<td height="30px" align="center" valign="middle" width="10%"><strong>MRN</strong></td>
				<td height="30px" align="center" valign="middle" width="6%"><strong>Patient Name</strong></td>
				<td height="30px" align="center" valign="middle" width="5%"><strong>Age</strong></td>					   
				<td height="30px" align="center" valign="middle" width="5%"><strong>Sex</strong></td>
				<td height="30px" align="center" valign="middle" width="6%"><strong>Surgery Type</strong></td>
				<td height="30px" align="center" valign="middle" width="6%"><strong>Surgery</strong></td>
				<td height="30px" align="center" valign="middle" width="6%"><strong>Surgeon</strong></td>
				<!--<td height="30px" align="center" valign="middle" width="4%"><strong>Room No.</strong></td>-->
				<td height="30px" align="center" valign="middle" width="10%"><strong>Surgery Date</strong></td>
				<td height="30px" align="center" valign="middle" width="10%"><strong>OT In Date & Time</strong></td>
				<td height="30px" align="center" valign="middle" width="10%"><strong>OT Out Date & Time</strong></td>
				<td height="30px" align="center" valign="middle" width="9%"><strong>Procedure Complete</strong></td>';
			
			$html .='</tr>';
				  	  $toggle =0;
					 				 
				      if(count($reports) > 0) {
						   $i = 1;
				      		foreach($reports as $pdfData){	
								//$Anaetesist = ClassRegistry::init('DoctorProfile')->field('doctor_name',array('DoctorProfile.user_id'=>$pdfData['OptAppointment']['department_id']));
								if($pdfData['OptAppointment']['procedure_complete'] == 1) {
								 $procedureStatus = __('Yes');
								} else {
								 $procedureStatus = __('No');
								}
								$html .= '<tr>
								   <td align="center" height="17px" >'.$i.'</td>
								   <td align="center" height="17px" >'.$this->DateFormat->formatDate2Local($pdfData['Patient']['form_received_on'],Configure::read('date_format')).'</td>
								   <td align="center" height="17px" >'.$pdfData['Patient']['admission_id'].'</td>
								   <td align="center" height="17px" >'.$pdfData['PatientInitial']['name'].' '.$pdfData['Patient']['lookup_name'].'</td>
								   <td align="center" height="17px" >'.$pdfData['Patient']['age'].'</td>
								   <td align="center" height="17px" >'.ucfirst($pdfData['Patient']['sex']).'</td>
								   <td align="center" height="17px" >'.ucfirst($pdfData['OptAppointment']['operation_type']).'</td>
								   <td align="center" height="17px" >'.ucfirst($pdfData['Surgery']['name']).'</td>
								   <td align="center" height="17px" >'.$pdfData['Initial']['name'].' '.$pdfData['DoctorProfile']['doctor_name'].'</td>
								  <!-- <td align="center" height="17px" >'.$pdfData['Opt']['name'].'</td>-->
								   <td align="center" height="17px" >'.$this->DateFormat->formatDate2Local($pdfData['OptAppointment']['starttime'],Configure::read('date_format'), true).'</td>
								   <td align="center" height="17px" >'.$this->DateFormat->formatDate2Local($pdfData['OptAppointment']['starttime'],Configure::read('date_format'), true).'</td>
								   <td align="center" height="17px" >'.$this->DateFormat->formatDate2Local($pdfData['OptAppointment']['endtime'],Configure::read('date_format'), true).'</td>								  
								   <td align="center" height="17px" >'.$procedureStatus.'</td>';
								
								
								$html .='</tr>';
							 $i++; 
						   }
						    $html .=' <tr>
										<td height="30px" align="center" valign="middle" colspan="14" ><strong>Total Patients</strong>'.($i-1).'</td>											
									 </tr>';
						  
					 } else {
						$html .= '<tr>
								<td colspan = "14" align="center" height="30px">No Record Found</td>
						</tr>';
					 }
					   		  
		$html .= '</table>' ;

	
	// output the HTML content
	$tcpdf->writeHTML($html, true, false, true, false, '');
	 
	// reset pointer to the last page
	$tcpdf->lastPage(); 
	$searchKey = array("/", " ", ":");
    $searchReplace = array("-","_", ".");
    $currentDate = str_replace($searchKey, $searchReplace, $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'), Configure::read('date_format'), true));
	//Close and output PDF document
	echo $tcpdf->Output('Total_Surgery_Report'.$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'), Configure::read('date_format'), true).'.pdf', 'D');
	
?>