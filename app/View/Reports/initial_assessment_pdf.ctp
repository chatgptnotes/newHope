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
	  	$facilitynamewithreport = 'Time for Initial Assessment'.' - '.$reportYear; 
	  	$facilityname = "";
	}
	else {
	    $headerString = "by ".$facilityname ;
		$facilitynamewithreport = $facilityname.'-Time for Initial Assessment'.' - '.$reportYear; 
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
					   <td height="30px" align="center" valign="middle" width="20%"><strong>MRN</strong></td>					  
					   <td height="30px" align="center" valign="middle" width="20%"><strong>Patient Name</strong></td>  
					   <td height="30px" align="center" valign="middle" width="10%"><strong>Age</strong></td>
					   <td height="30px" align="center" valign="middle" width="10%"><strong>Sex</strong></td>
					   <td height="30px" align="center" valign="middle" width="10%"><strong>Appointment Date/Time</strong></td>
					   <td height="30px" align="center" valign="middle" width="15%"><strong>Doc.Ini.Ass. Start Time</strong></td>
					   <td height="30px" align="center" valign="middle" width="15%"><strong>Duration(In Min.)</strong></td>					  
				   </tr>';
			
			if(!empty($record[0])) {
			   $k = 1; 
			
	      		foreach($record as $patient){
					$html .= '<tr>				
					            <td align="center" height="17px">'.$k.'</td>
								<td align="center" height="17px">'.$patient['admission_id'].'</td>					   
								<td align="center" height="17px">'.$patient['name'].' '.$patient['lookup_name'].'</td>
								<td align="center" height="17px">'.$patient['age'].'</td>  
								<td align="center" height="17px">'.ucfirst($patient['sex']).'</td>
								<td align="center" height="17px">'.$this->DateFormat->formatDate2Local($patient['apt_date'],Configure::read('date_format')).' '.$patient['apt_start_time'].'</td>';
					$splitDate = explode(' ',$patient['doc_ini_assess_on']);
					$html .= '<td align="center" height="17px">'.$this->DateFormat->formatDate2Local($splitDate[0],Configure::read('date_format')).' '.$splitDate[1].'</td>
							  <td align="center" height="17px">'.$patient['duration'].' Min</td>';
					$html .= '</tr>';
                  $k++;
				}
				$html .= '<tr> 
							<td height="30px" align="center" valign="bottom" colspan="8"><strong>Total Patients:'.count($record).'</strong></td>							
						</tr>';
			} else {					
				$html .= '<tr> 
							<td height="30px" align="center" valign="bottom" colspan="8">No Record Found</td>							
						</tr>';
			}	
			$html .= '</table>';
	//pr($html);exit;
	// output the HTML content
	$tcpdf->writeHTML($html, true, false, true, false, '');
	 
	// reset pointer to the last page
	$tcpdf->lastPage(); 
	
	//Close and output PDF document
	
	echo $tcpdf->Output('Waiting_Time_for_Initial_Assessment_Of_Out-Patient'.$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).'.pdf', 'D');
	
?>