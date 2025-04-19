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
	  	$facilitynamewithreport = 'Total Number Of UID Registrations'; 
	  	$facilityname = "";
	}
	else {
	    $headerString = "by ".$facilityname ;
		$facilitynamewithreport = $facilityname.'-Total Number Of UID Registrations'; 
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

	 
	$k = 0;

	$html ='<div style="margin-top:200px;">&nbsp;<span>Date: '.$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), false).'</span><br><br></div>
			<table border="1" class="table_format"  cellpadding="2" cellspacing="0" width="100%" style="text-align:left;padding-top:50px;">				  
				  <tr class="row_title" style="background-color:#A1B6BE;"> 
				       <td height="30px" align="center" valign="middle" width="7%"><strong>Sr.No.</strong></td>
					   <td height="30px" align="center" valign="middle" width="10%"><strong>Date Of UID Reg.</strong></td>
					   <td height="30px" align="center" valign="middle" width="14%"><strong>Patient ID</strong></td>
					   <td height="30px" align="center" valign="middle" width="13%"><strong>Patient Name</strong></td>  
					   <td height="30px" align="center" valign="middle" width="4%"><strong>Age</strong></td>
					   <td height="30px" align="center" valign="middle" width="4%"><strong>Sex</strong></td>
					   <td height="30px" align="center" valign="middle" width="8%"><strong>Blood Group</strong></td>
					   <td height="30px" align="center" valign="middle" width="10%"><strong>Location</strong></td>
					   <td height="30px" align="center" valign="middle" width="30%"><strong>Address</strong></td>
					    '; 
			   
		 	
		$html .='</tr>';  
	  	 $toggle =0;
	      if(count($reports) > 0) {
			    $k = 1; 
	      		foreach($reports as $pdfData){	
					 $valCnt++;
					$person = $pdfData['Person'];
				 
					$html .= '<tr>
					                <td align="center" height="17px">'.$valCnt.'</td>  
									<td align="center" height="17px">'.$this->DateFormat->formatDate2Local($person["create_time"],Configure::read('date_format')).'</td>
									<td align="center" height="17px">'.$person["patient_uid"].'</td>  
								    <td align="center" height="17px">'.$pdfData[0]["full_name"].'</td>								     
								    <td align="center" height="17px">'.$person["age"].'</td>  
								    <td align="center" height="17px">'.ucfirst($person["sex"]).'</td>
								    <td align="center" height="17px">'.$person["blood_group"].'</td>
								    <td align="center" height="17px">'.$person["city"].'</td>	 
								    <td align="center" height="17px">'.$pdfData[0]["address"].'</td>	
							</tr>' ;
										 
				 
				 $k++; 
			   }

			   $html .='<tr>
							 
							<td height="30px" align="center" valign="bottom" colspan="9"><strong>Total Patients: '.(count($reports)).'</strong></td>											
							
						</tr>';
						  
				 } else {
					$html .=  '<tr>
									<td align="center"   height="17px" colspan="9">No Record Found</td>
									
								</tr>';

				 }
					   		  
	 	$html .= '</table>' ;
		//pr($html);exit;
//pr($html);exit;
	
	// output the HTML content
	$tcpdf->writeHTML($html, true, false, true, false, 'middle');
	 
	// reset pointer to the last page
	$tcpdf->lastPage(); 
   
	//Close and output PDF document
	echo $tcpdf->Output('Total_Number_Of_Registrations'.$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).'.pdf', 'D');
	
?>