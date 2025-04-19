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
	  	$facilitynamewithreport = 'Particular Incident Report'.' - '.$reportYear; 
	  	$facilityname = "";
	}
	else {
	    $headerString = "by ".$facilityname ;
		$facilitynamewithreport = $facilityname.'-Particular Incident Report'.' - '.$reportYear; 
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

	
	$html ='<div style="margin-top:200px;">&nbsp;<span>Date: '.$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), false).'</span><br></div>
	   
		<table border="1" cellpadding="0" cellspacing="0" width="100%">
				    <tr class="row_title" style="background-color:#A1B6BE;">
					   <td height="30px" align="center" valign="middle" width="5%"><strong>Sr.No.</strong></td>
					   <td height="30px" align="center" valign="middle" width="10%"><strong>Date of Reg.</strong></td>
					   <td height="30px" align="center" valign="middle" width="10%"><strong>MRN</strong></td>					  
					   <td height="30px" align="center" valign="middle" width="10%"><strong>Patient Name</strong></td>  
					   <td height="30px" align="center" valign="middle" width="7%"><strong>Age</strong></td>
					   <td height="30px" align="center" valign="middle" width="7%"><strong>Sex</strong></td>
					   <td height="30px" align="center" valign="middle" width="11%"><strong>Incident Type</strong></td>
					   <td height="30px" align="center" valign="middle" width="15%"><strong>Incident Name</strong></td>
					   <td height="30px" align="center" valign="middle" width="15%"><strong>Incident Date</strong></td>
					   <td height="30px" align="center" valign="middle" width="10%"><strong>Incident Time</strong></td>		  
				   </tr>';
			
			if(!empty($record[0])) {
			   $k = 1; 
			
	      		foreach($record as $patient){
					$html .= '<tr>		
					            <td align="center" height="17px">'.$k.'</td>
								<td align="center" height="17px">'.date("d/m/Y", strtotime($this->DateFormat->formatDate2Local($patient['Patient']['form_received_on'],'yyyy/mm/dd', true))).'</td>
                 				<td align="center" height="17px">'.$patient['Patient']['admission_id'].'</td>
								<td align="center" height="17px">'.$patient['PatientInitial']['name']." ".$patient['Patient']['lookup_name'].'</td>
								<td align="center" height="17px">'.$patient['Person']['age'].'</td>  
								<td align="center" height="17px">'.ucfirst($patient['Person']['sex']).'</td>
								<td align="center" height="17px">'.$incidentType.'</td>';
				if($incidentType == 'medication_error'){
					$html .=	'<td align="center" height="17px">'.$patient['Incident']['medication_error'].'</td>';
				} else {
					$html .=	'<td align="center" height="17px">'.$patient['Incident']['analysis_option'].'</td>';
				}
					$html .= '<td align="center" height="17px">'.$this->DateFormat->formatDate2Local($patient['Incident']['incident_date'],Configure::read('date_format')).'</td>
							  <td align="center" height="17px">'.$patient['Incident']['incident_time'].'</td>';
					$html .= '</tr>';
					$k++; 
				}
				 
				$html .= '<tr> 
							<td height="30px" align="center" valign="bottom" colspan="10"><strong>Total Patients:'.count($record).'</strong></td>							
						</tr>';
			} else {					
				$html .= '<tr> 
							<td height="30px" align="center" valign="bottom" colspan="10">No Record Found</td>							
						</tr>';
			}	
			$html .= '</table>';
	//pr($html);exit;
	// output the HTML content
	$tcpdf->writeHTML($html, true, false, true, false, '');
	 
	// reset pointer to the last page
	$tcpdf->lastPage(); 
	
	//Close and output PDF document
	echo $tcpdf->Output('Particular_Incident_Report'.$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).'.pdf', 'D');
	
?>