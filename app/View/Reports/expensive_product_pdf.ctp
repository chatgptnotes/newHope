<?php
	
	//App::import('Vendor','xtcpdf'); 
	//$tcpdf = new XTCPDF();	
	//ob_clean();
	App::import('Vendor','tcpdf/config/lang/eng'); 
	App::import('Vendor','tcpdf/tcpdf');
	
	$facilityname = ucfirst($this->Session->read("facility"));
	//$headerimage = $this->Session->read("header_image");
	$facilitynamewithreport;
	
	if(empty($facilityname)) {
	  	$facilitynamewithreport = 'Expensive Product Report'; 
	  	$facilityname = "";
	}
	else {
	    $headerString = "by ".$facilityname ;
		$facilitynamewithreport = $facilityname.'-Expensive Product Report'; 
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
	
	
	// -------------------------------------------------
	
	// set font
	$tcpdf->SetFont('dejavusans', '', 9);
	
	// add a page (required with recent versions of tcpdf)
	$tcpdf->AddPage(); 

	$html .='<div width="100px" style="margin-top:200px;">&nbsp;<span>Date: '.$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), false).'</span><br><br></div>';
	$html .='<table border="1" class="table_format"  cellpadding="2" cellspacing="0" width="600px" style="text-align:left;padding-top:50px;">';				  
	$html .='<tr class="row_title" style="background-color:#A1B6BE;">'; 
	 $html .='<td height="30px" align="center" valign="middle">Sr.No</td>';
	$html .=' <td height="30px" align="center" valign="middle" >Product Name</td>';
     $html .='<td height="30px" align="center" valign="middle" >Stock</td>';		
		$html .='</tr>';  
		$i=0;
		foreach($reports as $result)
		 {       $i++;
					$html .= '<tr>';					              
    		$html .= '<td align="center" height="17px">'.$i.'</td>';
			$html .= '<td align="center" height="17px">';
						if(!empty($result['PharmacyItem']['name'])){
							$name = $result['PharmacyItem']['name'];
						}else{
							$name = $result["Product"]["name"];
						}
			$html .= $name;
			$html .='</td>';
			$html .= '<td align="center" height="17px">';
						if(!empty($result['PharmacyItem']['stock'])){
							$stock = $result['PharmacyItem']['stock'];
						}else{
							$stock = $result["Product"]["quantity"];
						}
			$html .= $stock;
			$html .='</td></tr>';
				}
	
	 	$html .= '</table>' ;
		//pr($html);exit;
//pr($html);exit;
	
	// output the HTML content
	$tcpdf->writeHTML($html, true, false, true, false, 'middle');
	 
	// reset pointer to the last page
	$tcpdf->lastPage(); 
   
	//Close and output PDF document
	echo $tcpdf->Output('expensive_product_report'.$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).'.pdf', 'D');
	
?>