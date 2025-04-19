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
		$facilitynamewithreport = $facilityname.'-HPI Report'; 
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
	$html;
	$html.='<div> HPI Reports</div>';
	$toggle =0;
	if(!empty($note)) {
		$html.='<div style="margin-top:200px;">&nbsp;<span>Date: '.$this->DateFormat->formatDate2Local(date('Y-m-d'),Configure::read('date_format'), false).'</span><br><br></div>
			<table border="1" class="table_format"  cellpadding="2" cellspacing="0" width="100%" style="text-align:left;padding-top:50px;">
				  <tr class="row_title" style="background-color:#A1B6BE;">
					   <td height="30px" align="center" valign="middle" width="10%"><strong>'.__("Body Area(s) Involved").'</strong></td>
					   <td height="30px" align="center" valign="middle" width="13%"><strong>'.__("Condition").'</strong></td>
					   	<td height="30px" align="center" valign="middle" width="10%"><strong>'.__("Mechanism of Onset").'</strong></td>
					   <td height="30px" align="center" valign="middle" width="13%"><strong>'.__("Description of onset of complaint").'</strong></td>
					   <td height="30px" align="center" valign="middle" width="13%"><strong>'.__("Current Symptoms ").'</strong></td>
					<td height="30px" align="center" valign="middle" width="13%"><strong>'.__("Location ").'</strong></td>
					 <td height="30px" align="center" valign="middle" width="13%"><strong>'.__("Quality ").'</strong></td>
					 <td height="30px" align="center" valign="middle" width="13%"><strong>'.__("Level of impairment Due to Symptoms (Resting)").'</strong></td>
					<td height="30px" align="center" valign="middle" width="13%"><strong>'.__("Level Impairment Due to Symptoms (With Activity) ").'</strong></td>
					<td height="30px" align="center" valign="middle" width="13%"><strong>'.__("Duration ").'</strong></td>
					<td height="30px" align="center" valign="middle" width="13%"><strong>'.__("Timing ").'</strong></td>
					<td height="30px" align="center" valign="middle" width="13%"><strong>'.__("Context ").'</strong></td>
					<td height="30px" align="center" valign="middle" width="13%"><strong>'.__("Assoc Signs and Symptoms").'</strong></td>
							<td height="30px" align="center" valign="middle" width="13%"><strong>'.__("Radiation").'</strong></td>
									<td height="30px" align="center" valign="middle" width="13%"><strong>'.__("Headaches").'</strong></td>
											<td height="30px" align="center" valign="middle" width="13%"><strong>'.__("Weakness").'</strong></td>
													<td height="30px" align="center" valign="middle" width="13%"><strong>'.__("Other Assoc Signs and Symptoms").'</strong></td>';
	
		$html .='</tr>';
		$k = 1;
	/* 	foreach($note as $pdfData){
	
			$html .= '<tr>
								    <td align="center" height="17px">'.$pdfData['cc'].'</td>
									<td align="center" height="17px">'.$pdfData['subject'].'</td>
									<td align="center" height="17px">'.$pdfData['object'].'</td>
									<td align="center" height="17px">'.$pdfData['assis'].'</td>
							</tr>' ;
			$k++;
	
		} */
		foreach($roseData as  $dataRose =>$datakey) {
		
			$g++ ;
			$newId= "reset-input-examination".$g;
			$newName ="data[subCategory_examination][".trim($datakey['Template']['id'])."]" ;
			//	debug($templateTypeContent[$datakey['Template']['category_name']]);
	
			$html .='<tr class="" style="margin-top: 10px; width: 100%;">
				<td class="row_format" style="border-bottom: 1px solid #424A4D; background:#3A5057;"><label><b>'. $datakey['Template']['category_name'].'
					</b> </label> </td>'.$selectedOptions=unserialize($templateTypeContent[$datakey['Template']['id']]);
					//debug($selectedOptions);
					foreach($datakey['TemplateSubCategories'] as $sub =>$subkey) {
					$subCategory=$selectedOptions[$subkey['id']];
					$color ='' ;
					//if($datakey['Template']['id']==27) pr($selectedOptions) ; 
					if($subCategory == '1' ){
						$rosChked="checked";
						 $subText=$subCategory;
						 $color='green';
					}elseif( $subCategory == '2' ){
						 $rosChked=""; 
						 $color='red';
						} else{
					 $rosChked=""; }
				
				$html .='<td class="radio_check" id="radiocheck"
					style="width: 100%; display: inline; border-bottom: 1px solid #424A4D; padding:0 0 0 10px;">';
					$name = "data[TemplateTypeContent][".$datakey['Template']['id']."][".$subkey['id']."]".'</td>';
		
				
				 $display = ($subkey['sub_category'] == 'OTHER' && $rosChked == 'checked')? 'block': 'none';
			 } 
				$html .='<td style="display:'. $display.'"'. 'id='.$datakey['Template']['id'].'</td>';
				$subText="";
			$html .='</tr>';
			 }
			$html .='<tr>
				<td>
				</td>
			</tr>';
			
	}
	else {
		$html .=  '<tr>
									<td align="center" width="100%" height="17px" colspan="12">No Record Found</td>
			
								</tr>';
	
	}
	$html .= '</table>' ;
	 $tcpdf->writeHTML($html, true, false, true, false, 'middle');
	// reset pointer to the last page
	$tcpdf->lastPage(); 
	
	//Close and output PDF document
	echo $tcpdf->Output('SOAP'.$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true)."_".'1'.'.pdf', 'D');
	
?>