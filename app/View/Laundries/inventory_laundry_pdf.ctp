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
	  	$facilitynamewithreport = 'Laundry Items Management - Report'; 
	  	$facilityname = "";
	}
	else {
	    $headerString = "by ".$facilityname ;
		$facilitynamewithreport = $facilityname.'- Laundry Items Management - Report'; 
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

	
	$html ='<div style="margin-top:200px;">&nbsp;<span>Date: '.$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), false).'</span><br><br></div>
	   
		<table border="1" class="table_format"  cellpadding="0" cellspacing="0" width="100%" style="text-align:left;padding-top:50px;">				  
				  <tr class="row_title" style="background-color:#A1B6BE;">
					   <td height="30px" align="center" valign="middle" width="7%"><strong>Sr.No.</strong></td>
					   <td height="30px" align="center" valign="middle"><strong>Date</strong></td>
					   <td height="30px" align="center" valign="middle"><strong>Item Code</strong></td>
					   <td height="30px" align="center" valign="middle"><strong>Item Name</strong></td>					   
					   <td height="30px" align="center" valign="middle"><strong>Total Stock</strong></td>
					   <td height="30px" align="center" valign="middle"><strong>Room</strong></td>
					   ';
			if($linenType == 'In Linen'){
				$html .='<td height="30px" align="center" valign="middle"><strong>In Linen</strong></td>';
			} else if($linenType == 'Out Linen'){
				$html .='<td height="30px" align="center" valign="middle"><strong>Out Linen</strong></td>';
			} else {
				$html .='<td height="30px" align="center" valign="middle"><strong>Type</strong></td>';
				$html .='<td height="30px" align="center" valign="middle"><strong>Last Entry</strong></td>';
			}
			$html .='<td height="30px" align="center" valign="middle"><strong>In Stock</strong></td>
					   				   
				  </tr>';
				  	  $toggle =0;
				      if(count($reports) > 0) {
						   $i = 1;
				      		foreach($reports as $pdfData){	
								$ward = ClassRegistry::init('Ward')->field('name',array('Ward.id'=>$pdfData["InstockLaundry"]["ward_id"]));
								$html .= '<tr>
								   <td align="center" height="17px" vlign="middle">'.$i.'</td>
								   <td align="center" height="17px" vlign="middle">'.$this->DateFormat->formatDate2Local($pdfData["InstockLaundry"]["create_time"],Configure::read('date_format'),true).'</td>
								   <td align="center" height="17px" vlign="middle">'.$pdfData["InstockLaundry"]["item_code"].'</td>
								   <td align="center" height="17px" vlign="middle">'.$pdfData["InstockLaundry"]["item_name"].'</td>
								   <td align="center" height="17px" vlign="middle">'.ucfirst($pdfData["InstockLaundry"]["total_quantity"]).'</td>
								   <td align="center" height="17px" vlign="middle">'.ucfirst($ward).'</td>';
								if(!empty($linenType)){
									
									$html .='<td align="center" height="17px" vlign="middle">'.ucfirst($pdfData["InstockLaundry"]["last_entry"]).'</td>';
								} else {  
									$html .='<td align="center" height="17px" vlign="middle">'.ucfirst($pdfData["InstockLaundry"]["type"]).'</td>';
									$html .='<td align="center" height="17px" vlign="middle">'.ucfirst($pdfData["InstockLaundry"]["last_entry"]).'</td>';

								}
								$html .='<td align="center" height="17px" vlign="middle">'.$pdfData["InstockLaundry"]["in_stock"].'</td>					  					   
								   							   
								  </tr>';
							 $i++; 
						   } 
					 } else {
						$html .= '<tr>
								<td colspan = "8" align="center" height="30px">No Record Found For the Selection!</td>
						</tr>';
					 }
					   		  
		$html .= '</table>' ;

	
	// output the HTML content
	$tcpdf->writeHTML($html, true, false, true, false, '');
	 
	// reset pointer to the last page
	$tcpdf->lastPage(); 
	
	//Close and output PDF document
	echo $tcpdf->Output('Laundry_Report'.$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).'.pdf', 'D');
	
?>