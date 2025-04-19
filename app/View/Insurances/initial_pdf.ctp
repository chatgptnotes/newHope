<?php
	 App::import('Vendor','tcpdf/config/lang/eng'); 
	App::import('Vendor','tcpdf/tcpdf');
	$facilityname = ucfirst($this->Session->read("facility"));
	
	$headerimage = $this->Session->read("header_image");
	$facilitynamewithreport;
	
	if(empty($facilityname)) {
	  	$facilitynamewithreport = 'Registration Report By Referral Doctor'; 
	  	$facilityname = "";
	}
	else {
	    $headerString = "by ".$facilityname ;
		$facilitynamewithreport = $facilityname.'-Initial Assessment Report'; 
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

	/*$getField = explode('|',$fieldName);
	unset($getField[array_pop(array_keys($getField))]);
	$count = count($getField);	
	$k = 0; */
//debug($diagnosis);
	$html ='<div style="margin-top:200px;">&nbsp;<span>Date: '.$this->DateFormat->formatDate2Local(date('Y-m-d'),Configure::read('date_format'), false).'</span><br><br></div>
			<table border="1" class="table_format"  cellpadding="2" cellspacing="0" width="100%" style="text-align:left;padding-top:50px;">				  
				  <tr class="row_title" style="background-color:#A1B6BE;">
				       <td height="30px" align="center" valign="middle" width="6%"><strong>'.__("Sr.No.").'</strong></td>
					   <td height="30px" align="center" valign="middle" width="10%"><strong>'.__("Snomed.").'</strong></td>
					   <td height="30px" align="center" valign="middle" width="13%"><strong>'.__("Name").'</strong></td>'; 
		 	
		$html .='</tr>';  
	  	 $toggle =0;
	
	      if(!empty($diagnosis)) {
			   $k = 1; 
	      		foreach($diagnosis as $pdfData){	
					$explICD=explode('|',$pdfData['ICD_code']);
					$countofrec=count($explICD)-1;
					for($r=0;$r<count($explICD)-1;$r++){
						$expData=explode('::',$explICD[$r]);
						if(!empty($expData)){
					$html .= '<tr>
									<td align="center" height="17px">'.$k.'</td> 
								    <td align="center" height="17px">'.$expData['1'].'</td>
									<td align="center" height="17px">'.$expData['2'].'</td>
							</tr>' ;
					$k++;
						}
	      		}				 
			
			   }

			   $html .=' <tr>
							 
							<td height="30px" align="center" valign="bottom" colspan="12"><strong>Total ICD: '.($k-1).'</strong></td>											
							
						</tr>';
						  
				 } else {
					$html .=  '<tr>
									<td align="center" width="100%" height="17px" colspan="12">No Record Found</td>
									
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
	echo $tcpdf->Output('IntialAssessment'.$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true)."_".$id.'.pdf', 'D');
	
?>