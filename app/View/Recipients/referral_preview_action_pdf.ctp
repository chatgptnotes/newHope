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

	$html='<div class="section" id="subjective">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			class="formFull formFullBorder">
			<tr>
				
				<td width="70%" align="left" valign="top">

					<table width="100%" border="0" cellspacing="0" cellpadding="0">
					
					<tr>
							<td width="20"></td>
							<td valign="top" colspan="4"> Hello Steve Buckner<br />
								
							</td>

					</tr>
					
						<tr>
							<td width="20"></td>
						<td valign="top" colspan="4">I wish to refer patient of mine, to you for an appointment. I have included information pertaining to this patient below to better assist in continuiy of care.<br />
								
							</td>


						</tr>
						</table>';
						$html.='<table width="100%" class="row_format" border="0" cellspacing="0" cellpadding="0">
<tr class="row_title"><td><strong>Vital</strong></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr class="">
							<td width="30">Height:</td>
							<td width="30"> '.$vitals["Note"]["ht"].'</td> 
							<td width="30">Weight:</td>
							<td width="30"> '.$vitals["Note"]["wt"].'</td>  
							<td width="30"> B.M.I.:</td>
							<td width="30"> '.$vitals["Note"]["bmi"].'</td> 
							<td width="40">Blood Pressure:</td>
							<td width="40"> '.$vitals["Note"]["bp"].' 
							</td>
							<td width="30">Temp:</td>
							<td width="30"> '.$vitals["Note"]["temp"].' 
							</td>


						</tr>
					</table>
					
					<table width="100%" class="row_format" border="0" cellspacing="0" cellpadding="0">
						<tr class="row_title"> <td width="50"><strong>Diagnoses</strong></td><td></td>
							<td width="25"><strong>Start </strong></td>
							<td width="25"><strong> Stop</strong></td>
						</tr>';
							$html .='</tr>';  
							if(count($diagnosis) > 0) {
								foreach($diagnosis as $patients){
									$cnt++;
									$html .= '<tr>
											<td width="40">   '. $patients["NoteDiagnosis"]["diagnoses_name"].' </td>
							<td width="30">360.0  //  $this->Form->input("height", array("id" => "subjective_desc" ,"label"=>false,));  </td>
							
							<td width="30">    '.$patients["NoteDiagnosis"]["start_dt"].' </td>
							
							<td width="30">   '. $patients["NoteDiagnosis"]["end_dt"].'  </td>';
		
									}    } else {
						$html .= '<tr>
								<TD colspan="8" align="center">No record found</TD>
			  </tr>';
									}
									$html .='</tr>';
									$html .='</table>';
										
									$html .='<table width="100%" class="row_format" border="0" cellspacing="0" cellpadding="0">
									<tr class="row_title"> <td width="60"><strong>Medication</strong></td><td></td>
									
									
									<td width="40"><strong>Start</strong></td>
									<td width="30"><strong>Stop</strong></td>
										
									</tr>';
									$toggle =0;
									if(count($medication) > 0) {
									
										foreach($medication as $patients){
											$cnt++;
											$html .= '<tr>
													<td width="60"> '. $patients["NewCropPrescription"]["description"].'  </td>
							
							<td width="40">    '.$patients["NewCropPrescription"]["date_of_prescription"].'   </td>
							
							<td width="30">    '.$patients["NewCropPrescription"]["end_date"].'  </td>';
											}    } else {
												
												$html .= '<tr>
												<TD colspan="8" align="center">  No record found </TD>
												</tr>';
											}
											$html .= '</tr>
											</table>
											<table width="100%" class="row_format" border="0" cellspacing="0" cellpadding="0">
											<tr class="row_title"> <td width="50"><strong> Conclusion</strong></td><td></td>
											<td width="25"><strong> </strong></td>
											<td width="25"><strong> </strong></td>
											</tr>
											<tr class="">
											<td width="100%">For follow  up, I would appericiate it if you could</td>
												
											</tr>
											</table>
											<table width="100%" class="row_format" border="0" cellspacing="0" cellpadding="0">
											<tr style="width:20%; float:right", >
											<td width="100%" >Sincerely</td>
											</tr>
											<tr style="width:20%; float:right">
											<td width="100%" >XYZ</td>
												
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
											</table>
											</div>' ;
									//echo $html;exit;
//pr($html);exit;
	
	// output the HTML content
	$tcpdf->writeHTML($html, true, false, true, false, 'middle');
	 
	// reset pointer to the last page
	$tcpdf->lastPage(); 
	//$searchKey = array("/", " ", ":");
	//$searchReplace = array("-","_", ".");
   
	//Close and output PDF document
	echo $tcpdf->Output('Fax_Report'.$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).'.pdf', 'D');
	
?>