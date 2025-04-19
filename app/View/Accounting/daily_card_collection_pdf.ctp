<?php
	
	//App::import('Vendor','xtcpdf'); 
	//$tcpdf = new XTCPDF();	
	//ob_clean();
	App::import('Vendor','tcpdf/config/lang/eng'); 
	App::import('Vendor','tcpdf/tcpdf');
	
	$headerimage = $this->Session->read("header_image");

	$tcpdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	// set document information
	$tcpdf->SetCreator(PDF_CREATOR);
	
	$tcpdf->SetSubject('Report');
	//$tcpdf->SetKeywords('TCPDF, PDF, example, test, guide');
	 
	// set default header data
	//$tcpdf->SetHeaderData($headerimage, PDF_HEADER_LOGO_WIDTH, $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true));
	
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
	
	$html .='<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%" style="text-align:left;">
				<tr>
					<td valign="top" colspan="5" style="text-align:center;" align="center"><h2>Patient Card</h2></td></tr>';
	$getTo=explode(" ",$date);
	$getToFinal = str_replace("/", "-",$getTo[0]);
	$getToFinal=date('jS-M-Y', strtotime($getToFinal));
	$html .= '<tr>
		   			<td valign="top" colspan="5" style="letter-spacing: 0.1em;text-align:center;">'.$getToFinal.'</td>
    			</tr>';
	$html .= '</table>' ;
	
	$html .='<table border="1" class="table_format" cellpadding="0" cellspacing="0" width="100%" style="text-align:left;">				  
				<tr class="row_title" style="background-color:#A1B6BE;"> 
			       <td width="20%" align="center" valign="middle"><strong>User Name</strong></td>
				   <td width="10%" align="center" valign="middle"><strong>Role</strong></td>
				   <td width="25%" align="center" valign="middle"><strong>Total Revenue</strong></td>
				   <td width="25%" align="center" valign="middle"><strong>Refund Amount</strong></td>
				   <td width="20%" align="center" valign="middle"><strong>Nett Amount</strong></td>'; 
		$html .='</tr>';  
		
		    foreach($data as $key=> $userData) {
		    	if(empty($userData['PatientCard'])) continue ;
		    		$html .= '<tr>
	    						<td align="left" valign="top" style= "text-align: left;">'.$userData['User']['full_name'].'</td>
	    						<td align="left" valign="top" style= "text-align: left;">'.$userData['Role']['name'].'</td>
	    						<td class="tdLabel"  style= "text-align: center;">';
		    		 			$amount = 0;
    								foreach ($userData['PatientCard'] as $key=> $dataArray){
    									if($dataArray['type'] == "deposit"){ 
    										$amount += $dataArray['amount']; }
    									 }
    								$html.= $amount;
    									$totalRevenue +=  (double) $amount;
		    							
		    			$html .= '</td><td class="tdLabel"  style= "text-align: center;">';
		    					$refundAmount = 0;
    								foreach ($userData['PatientCard'] as $key=> $dataArray){
    									if($dataArray['type'] == "refund" || $dataArray['type'] == "Payment"){ 
    										$refundAmount += $dataArray['amount']; } 
    									 }
		    						$html.= $refundAmount ;
		    							$totalRefund +=  (double) $refundAmount;	
		    							
		    			$html .= '</td><td class="tdLabel"  style= "text-align: center;">';
		    							$netAmount = ($amount - $refundAmount);
		    						$html.= $netAmount;
		    							$totalNetAmount +=  (double) $netAmount;
		    					$html .= "</td></tr>" ;
		   					}
		   				
		   			$html .= '<tr>
	    						<td class="tdLabel" colspan="2" style="text-align: right;"><font color="red"><b>Total :</b></font></td>
			   					<td class="tdLabel" style= "text-align: center;"><font color="red"><b>'.$totalRevenue.'</b></font></td>
			   					<td class="tdLabel" style= "text-align: center;"><font color="red"><b>'.$totalRefund.'</b></font></td>
			   					<td class="tdLabel" style= "text-align: center;"><font color="red"><b>'.$totalNetAmount.'</b></font></td>
	    					</tr>' ;
 				$html .= '</table>' ;
	 			
	 		//pr($html);exit;
	// output the HTML content
	$tcpdf->writeHTML($html, true, false, true, false, 'middle');
	 
	// reset pointer to the last page
	$tcpdf->lastPage(); 
   
	//Close and output PDF document
	echo $tcpdf->Output('Patient_Card_'.$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).'.pdf', 'D');
	
?>