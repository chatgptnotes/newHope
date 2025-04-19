<?php
	
	//App::import('Vendor','xtcpdf'); 
	//$tcpdf = new XTCPDF();	
	//ob_clean();
	App::import('Vendor','tcpdf/config/lang/eng'); 
	App::import('Vendor','tcpdf/tcpdf');
	$tcpdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	// set document information
	$tcpdf->SetCreator(PDF_CREATOR);
	$tcpdf->SetAuthor('Hope Hospital');
	$tcpdf->SetTitle('Hope Hospital-Patient Report');
	$tcpdf->SetSubject('Report');
	//$tcpdf->SetKeywords('TCPDF, PDF, example, test, guide');
	 
	// set default header data
	$tcpdf->SetHeaderData('logo.jpg', PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.'-Patient Report', PDF_HEADER_STRING);
	
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
	$html ='<div style="margin-top:200px;">&nbsp;<span>Date: '.date('d/m/Y h:i A').'</span><br><br></div>
			<table border="1" class="table_format"  cellpadding="2" cellspacing="0" width="100%" style="text-align:left;padding-top:50px;">				  
				  <tr class="row_title">
					   <td ><strong>Patient ID</strong></td>
					   <td ><strong>MRN</strong></td>
					   <td ><strong>Patient Name</strong></td>					   
					   <td ><strong>Age</strong></td>
					   <td ><strong>Sex</strong></td>
					   <td ><strong>Registration Type</strong></td>				   
				  </tr>';
				  	  $toggle =0;
				      if(count($pdfData) > 0) {
				      		foreach($pdfData as $patients){				      					
								$html .= '<tr>		  
								   <td >'.$patients["Patient"]["patient_id"].'</td>
								   <td >'.$patients["Patient"]["admission_id"].'</td>
								   <td >'.ucfirst($patients["Patient"]["lookup_name"]).'</td>
								   <td >'.$patients["Person"]["age"].'</td>
								   <td >'.ucfirst($patients["Person"]["sex"]).'</td>						   
								   <td >'.$patients["Patient"]["admission_type"].'</td>								   
								  </tr>';
					   } 
					 			}
					   		  
		$html .= '</table>' ;

	
	// output the HTML content
	$tcpdf->writeHTML($html, true, false, true, false, '');
	 
	// reset pointer to the last page
	$tcpdf->lastPage(); 
	
	//Close and output PDF document
	echo $tcpdf->Output('patients_report.pdf', 'D');
	
?>