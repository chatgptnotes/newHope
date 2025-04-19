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
					<td valign="top" colspan="2" style="text-align:center;" align="center"><h2>Daily Collection</h2></td></tr>';
				$getTo=explode(" ",$date);
				$getToFinal = str_replace("/", "-",$getTo[0]);
				$getToFinal=date('jS-M-Y', strtotime($getToFinal));
		$html .= '<tr>
		   			<td valign="top" colspan="2" style="letter-spacing: 0.1em;text-align:center;">'.$getToFinal.'</td>
    			</tr>';
 		$html .= '</table>' ;
	
	$html .='<table border="1" class="table_format" cellpadding="0" cellspacing="0" width="100%" style="text-align:left;">				  
				<tr class="row_title" style="background-color:#A1B6BE;"> 
			       <td width="25%" align="center" valign="middle"><strong>User Name</strong></td>
				   <td width="15%" align="center" valign="middle"><strong>Role</strong></td>
				   <td width="15%" align="center" valign="middle"><strong>Total Revenue</strong></td>
				   <td width="15%" align="center" valign="middle"><strong>Refund Amount</strong></td>
				   <td width="15%" align="center" valign="middle"><strong>Discount</strong></td>
				   <td width="15%" align="center" valign="middle"><strong>Nett Amount</strong></td>'; 
		$html .='</tr>';  
		
		    foreach($data as $key=> $userData) {
		     		$billingTotal =  set::classicExtract($userData,"Billing.0.Billing.0.total");
					$billingRefund = set::classicExtract($userData,"Billing.0.Billing.0.return_total");
					$billingDiscount = set::classicExtract($userData,"Billing.0.Billing.0.total_discount");
					$cardDeposit = set::classicExtract($userData,"PatientCard.0.PatientCard.0.card_total");
					$cardRefund = set::classicExtract($userData,"PatientCardAlias.0.PatientCardAlias.0.card_refund");
					$cardPayment = set::classicExtract($userData,"PatientCardAliasTwo.0.PatientCardAliasTwo.0.card_payment");
					$netCashAmount = $billingTotal + $cardDeposit - $cardPayment;
					$netRefundAmt = abs($billingRefund + $cardRefund);
					if($billingTotal!=0 || $billingRefund!=0 || $billingDiscount!=0
							|| $cardDeposit!=0 || $cardRefund!=0 || $cardPayment!=0){
		    		$html .= '<tr>
	    						<td align="left" valign="top" style= "text-align: left;">'.$userData['User']['full_name'].'</td>
	    						<td align="left" valign="top" style= "text-align: left;">'.$userData['Role']['name'].'</td>
	    						<td class="tdLabel"  style= "text-align: center;">';
		    					$html.= $netCashAmount ?$netCashAmount :0;
		    							$totalRevenue +=  (double) $netCashAmount ; 
		    							
		    			$html .= '</td><td class="tdLabel"  style= "text-align: center;">';
		    					$html.= $netRefundAmt ?$netRefundAmt :0;
		    							$totalRefund +=  (double) $netRefundAmt;
		    							
		    			$html .= '</td><td class="tdLabel"  style= "text-align: center;">';
		    					$html.= $billingDiscount ?$billingDiscount :0 ;
		    							$totalDiscount +=  (double) $billingDiscount;
		    							
		    			$html .= '</td><td class="tdLabel"  style= "text-align: center;">';
		    						$netAmount = ($netCashAmount - $netRefundAmt);
		    						$html.= $netAmount;
		    						$totalNetAmount +=  (double) $netAmount;			 
		    					$html .= "</td></tr>" ;
		   					}
		    			}
		   			$html .= '<tr>
	    						<td class="tdLabel" colspan="2" style="text-align: right;"><font color="red"><b>Total :</b></font></td>
			   					<td class="tdLabel" style= "text-align: center;"><font color="red"><b>'.$totalRevenue.'</b></font></td>
			   					<td class="tdLabel" style= "text-align: center;"><font color="red"><b>'.$totalRefund.'</b></font></td>
			   					<td class="tdLabel" style= "text-align: center;"><font color="red"><b>'.$totalDiscount.'</b></font></td>
			   					<td class="tdLabel" style= "text-align: center;"><font color="red"><b>'.$totalNetAmount.'</b></font></td>
	    					</tr>' ;
 				$html .= '</table>' ;
	 			
	 		//pr($html);exit;
	// output the HTML content
	$tcpdf->writeHTML($html, true, false, true, false, 'middle');
	 
	// reset pointer to the last page
	$tcpdf->lastPage(); 
   
	//Close and output PDF document
	echo $tcpdf->Output('Daily_Collection_'.$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).'.pdf', 'D');
	
?>