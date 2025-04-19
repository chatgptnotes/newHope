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
	  	$facilitynamewithreport = 'Live Claim Feed'; 
	  	$facilityname = "";
	}
	else {
	    $headerString = "by ".$facilityname ;
		$facilitynamewithreport = $facilityname.'-Live Claim Feed'; 
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
	   
		<table border="1" class="table_format"  cellpadding="0" cellspacing="0" width="100%" style="text-align:left;padding-top:50px;">					  
				  <tr class="row_title" style="background-color:#A1B6BE;">
					  <td height="30px" align="center" valign="middle" width="5%"><strong>Sr.No.</strong></td>
					  <td height="30px" align="center" valign="middle" width="10%"><strong>Patient</strong></td>
					  <td height="30px" align="center" valign="middle" width="10%"><strong>Visit</strong></td>
					  <td height="30px" align="center" valign="middle" width="10%"><strong>Facility</strong></td>
					  <td height="30px" align="center" valign="middle" width="10%"><strong>Provider</strong></td>
					  <td height="30px" align="center" valign="middle" width="4%"><strong>Billed</strong></td>					   
					  <td height="30px" align="center" valign="middle" width="6%"><strong>Allowed</strong></td>
					  <td height="30px" align="center" valign="middle" width="6%"><strong>Ins 1 Paid</strong></td>
					  <td height="30px" align="center" valign="middle" width="10%"><strong>Ins 2 Paid</strong></td>					   
					  <td height="30px" align="center" valign="middle" width="9%"><strong>Pt Paid</strong></td>
					  <td height="30px" align="center" valign="middle" width="10%"><strong>Ins Bal</strong></td>
			 		  <td height="30px" align="center" valign="middle" width="10%"><strong>Ins 1</strong></td>
					  <td height="30px" align="center" valign="middle" width="10%"><strong>Ins 1 Status</strong></td>';
					
			$html .='</tr>';
				  	  $toggle =0;
				      if(count($reports) > 0) {
						   $i = 1;
				      		foreach($reports as $data){
								$html .= '<tr>
								   <td align="center" height="17px" >'.$i.'</td>
								   <td align="center" height="17px" >'.$data["Patient"]["lookup_name"].'</td>
								   <td align="center" height="17px" >'.$this->DateFormat->formatDate2Local($data["Patient"]["form_received_on"],Configure::read('date_format')).'</td>
								   <td align="center" height="17px" >'.$this->Session->read("facility").'</td>
								   <td align="center" height="17px" >'.$data["User"]["first_name"]." ".$data["User"]["last_name"].'</td>
								   <td align="center" height="17px" >'.($data["FinalBilling"]["total_amount"])? $this->Number->currency(ceil($data["FinalBilling"]["total_amount"])):$this->Number->currency(ceil(0)).'</td>
								   <td align="center" height="17px" >'.($data["FinalBilling"]["amount_collected_ins_company"])? $this->Number->currency(ceil($data["FinalBilling"]["amount_collected_ins_company"])):$this->Number->currency(ceil(0)).'</td>
								   <td align="center" height="17px" >'.($data["FinalBilling"]["collected_copay"])? $this->Number->currency(ceil($data["FinalBilling"]["collected_copay"])):$this->Number->currency(ceil(0)).'</td>
								   <td align="center" height="17px" >'.$this->Number->currency(ceil($data["FinalBilling"]["amount_pending_ins_company"] - $data["FinalBilling"]["amount_collected_ins_company"])).'</td> 
								   <td align="center" height="17px" >'.$this->Number->currency(ceil($data["FinalBilling"]["copay"] - $data["FinalBilling"]["collected_copay"])).'</td>
								   <td align="center" height="17px" >'.$data["TariffStandard"]["name"].'</td>	
								   <td align="center" height="17px" >'.$data["FinalBilling"]["claim_status"].'</td>';
								   $html .='</tr>';
							 $i++; 
						   }
						   $html .=' <tr>
										<td height="30px" align="center" valign="middle" colspan="12"><strong>Total Claims : '.($i-1).'</strong></td>											
									 </tr>';
					} else {
						$html .= '<tr>
								<td colspan = "12" align="center" height="30px">No Record Found</td>
								</tr>';
					 }
		$html .= '</table>' ;

	// output the HTML content
	$tcpdf->writeHTML($html, true, false, true, false, '');
	 
	// reset pointer to the last page
	$tcpdf->lastPage(); 
	
	//Close and output PDF document
	echo $tcpdf->Output('Live_Claim_Feed'.$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).'.pdf', 'D');
	
