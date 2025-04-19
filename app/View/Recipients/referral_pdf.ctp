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
		$facilitynamewithreport = 'Fax Referral';
		$facilityname = "";
	}
	else {
		$headerString = "by ".$facilityname ;
		$facilitynamewithreport = $facilityname.'-Fax Referral';
	}
	

	
	$tcpdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	// set document information
	$tcpdf->SetCreator(PDF_CREATOR);
	$tcpdf->SetAuthor($facilityname);
	$tcpdf->SetTitle($facilitynamewithreport);
	$tcpdf->SetSubject('Report','Output');
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

		$html.='<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:10px;">
					<tr>
					<td width="20"></td>
						<td valign="top" colspan="4">Hello'.' '.$recipients["Recipient"]["name"].'<br />
							</td>
					</tr>
					
						<tr>
							<td width="20"></td>
						<td valign="top" colspan="4">I wish to refer patient of mine, to you for an appointment. I have included information pertaining to this patient below to better assist in continuiy of care.<br />
							</td>
						</tr>
						</table>';
				$html.='<table width="80%" class="row_format" border="0.5px" cellspacing="0" style="background-color:#A1B6BE; margin-left:17px; " cellpadding="0" >
<tr class="row_title" ><td><strong>Vital</strong></td><td></td><td></td><td></td><td></td></tr>
						<tr class="" style="padding-bottom:8px;" >
							<td  style="padding-right:5px;">Height:
							 '.$vitals["Note"]["ht"].'</td> 
							<td  style="padding-right:5px;">Weight:
							 '.$vitals["Note"]["wt"].'</td>  
							<td  style="padding-right:5px;"> B.M.I.:
						 '.$vitals["Note"]["bmi"].'</td> 
							<td  style="padding-right:5px;">B.P.:
							'.$vitals["Note"]["bp"].' 
							</td>
							<td  style="padding:10px 5px;">Temp:
							 '.$vitals["Note"]["temp"].' 
							</td>


						</tr>
					</table>';
					$html .='<table><tr><td></td></tr></table>';
					$html .='<table width="80%" class="row_format" border="0.5px" cellspacing="0" style="background-color:#A1B6BE; margin-left:17px;" cellpadding="0" >
						<tr class="row_title" > <td ><strong>Diagnoses</strong></td>
							<td  ><strong>Start </strong></td>
							<td ><strong> Stop</strong></td>
						</tr>';
						 
							if(count($diagnosis) > 0) {
								foreach($diagnosis as $patients){
									$cnt++;
									$html .= '<tr style="padding-bottom:8px;">
											<td  style="padding:10px 5px;">   '. $patients["NoteDiagnosis"]["diagnoses_name"].' </td>
							
							
							<td  style="padding:10px 5px;">    '.$this->DateFormat->formatDate2Local($patients['NoteDiagnosis']['start_dt'],Configure::read('date_format')).' </td>
							
							<td  style="padding:10px 5px;">   '. $this->DateFormat->formatDate2Local($patients['NoteDiagnosis']['end_dt'],Configure::read('date_format')).'  </td>';
		
									}    } else {
						$html .= '<tr>
								<TD colspan="8" align="center">No record found</TD>
			  </tr>';
									}
									$html .='</tr>';
									$html .='</table>';
										
									$html .='<table><tr><td></td></tr></table>
											<table width="80%" class="row_format" border="0.5px" cellspacing="0" style="background-color:#A1B6BE; margin-left:17px;" cellpadding="0" >
									<tr class="row_title" style="padding-bottom:8px;margin-left: 17px;"> <td  style="padding:10px 5px;"><strong>Medication</strong></td>
									
									
									<td  style="padding:10px 5px;"><strong>Start</strong></td>
									<td  style="padding:10px 5px;"><strong>Stop</strong></td>
										
									</tr>';
									$toggle =0;
									if(count($medication) > 0) {
									
										foreach($medication as $patients){
											$cnt++;
											$html .= '<tr padding-bottom:8px;">
													<td  style="padding:10px 5px;"> '. $patients["NewCropPrescription"]["description"].'  </td>
							
							<td  style="padding:10px 5px;">    '.$this->DateFormat->formatDate2Local($patients['NewCropPrescription']['date_of_prescription'],Configure::read('date_format')).'   </td>
							
							<td  style="padding:10px 5px;">    '.$this->DateFormat->formatDate2Local($patients["NewCropPrescription"]["end_date"],Configure::read('date_format')).'  </td>';
											}    } else {
												
												$html .= '<tr>
												<TD colspan="8" align="center">  No record found </TD>
												</tr>';
											}
											$html .= '</tr>';
											$html .= '</table>';
													
											$html .= '<table><tr><td></td></tr></table>
															
											<table width="100%"  class="row_format" border="0" cellspacing="0" cellpadding="0">
											<tr class="row_title"> <td width="50"><strong> Conclusion</strong></td><td></td>
											<td width="25"><strong> </strong></td>
											<td width="25"><strong> </strong></td>
											</tr>
											<tr class="">
											<td width="100%">For follow  up, I would appericiate it if you could</td>
												
											</tr>
											</table>
											<table width="100%" align="right" class="row_format" border="0" cellspacing="0" cellpadding="0">
											<tr  >
											<td width="100%" >Sincerely</td>
											</tr></table>
											<table width="100%" align="right" class="row_format" border="0" cellspacing="0" cellpadding="0">
											<tr >
											<td width="100%" >'.$name['Patient']['lookup_name'].'</td>
												
											</tr>
											
											</table>
											<table width="100%" class="row_format" border="0" cellspacing="0" cellpadding="0">
											<tr >
											</tr>
											<tr class="">
												
											</tr>
											
											</table>
												
												
											</div>
											</td>
											</tr>
											</table>';
											
		
	$tcpdf->writeHTML($html, true, false, true, false, 'middle');
	 
	// reset pointer to the last page
	$tcpdf->lastPage(); 
	$filelocation = Configure::read('generated_fax_path');
	//Close and output PDF document
	
	$tcpdf->Output($filelocation."/".'Fax_referral'.$id.''._.''.$userid.'.pdf', 'F')
	
?>