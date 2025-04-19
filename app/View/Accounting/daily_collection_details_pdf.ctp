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
					<td valign="top" colspan="9" style="text-align:center;" align="center"><h2>Daily Cash Collection Detail</h2></td></tr>';
	$getTo=explode(" ",$date);
	$getToFinal = str_replace("/", "-",$getTo[0]);
	$getToFinal=date('jS-M-Y', strtotime($getToFinal));
	$html .= '<tr>
		   			<td valign="top" colspan="9" style="letter-spacing: 0.1em;text-align:center;">'.$getToFinal.'</td>
    			</tr>';
	$html .= '</table>' ;
	$html .='<table width="100%" cellpadding="0" cellspacing="2" border="0" style="padding-top:10px">
				<tr>
					<td>
					<table border="1" class="table_format" cellpadding="0" cellspacing="0" width="100%" style="text-align:left;">				  
						<tr class="row_title" style="background-color:#A1B6BE;"> 
						       <td width="20%" align="center" valign="middle"><strong>User Name</strong></td>
							   <td width="10%" align="center" valign="middle"><strong>Role</strong></td>
								<td width="30%" align="center" valign="center" colspan="3" style="text-align: center">
									<table width="100%" cellpadding="0" cellspacing="0" border="1" class="table_format">
										<tr>
											<td colspan="3" align="center" style="text-align: center"><strong>Collection</strong></td>	
										</tr>
										<tr>
											<td style="text-align: center"><strong>Cash</strong></td>
											<td style="text-align: center"><strong>Cheque</strong></td>
											<td style="text-align: center"><strong>Patient Card</strong></td>
										</tr>
									</table>
								</td> 
								<td width="20%" align="center" valign="center" colspan="2" style="text-align: center">
									<table width="100%" cellpadding="0" cellspacing="1" border="1" 	class="table_format">
										<tr>
											<td colspan="2" style="text-align: center"><strong>Refund</strong></td>	
										</tr>
										<tr>
											<td style="text-align: center"><strong>Cash</strong></td>
											<td style="text-align: center"><strong>Patient Card</strong></td>
										</tr>
									</table>
								</td>  
							   <td width="10%" align="center" valign="middle"><strong>Nett Amount</strong></td>
							   <td width="10%" align="center" valign="middle"><strong>Patient Card Amount</strong></td>'; 
				$html .='</tr>';  
					    $totalCash = 0;
					    foreach($data as $key=> $userData) {
					    	$billingTotal =  set::classicExtract($userData,"Billing.0.Billing.0.total");
							$billingCheque =  set::classicExtract($userData,"Billing.1.Billing.0.total");
							$cardCheque =  set::classicExtract($userData,"PatientCardAliasThree.0.PatientCardAliasThree.0.card_amount_cheque");
							$billRefund = set::classicExtract($userData,"Billing.0.Billing.0.return_total");
							$cardDeposit = set::classicExtract($userData,"PatientCard.0.PatientCard.0.card_total");
							$cardRefund = set::classicExtract($userData,"PatientCardAlias.0.PatientCardAlias.0.card_refund");
							$cardPayment = set::classicExtract($userData,"PatientCardAliasTwo.0.PatientCardAliasTwo.0.card_payment");
							$netCashAmount = $billingTotal - $cardPayment;
							$cardNetAmount = abs($cardPayment);
							$billingChequeTotal = $billingCheque + $cardCheque;
							$billingRefund = round($cardRefund + $billRefund);
							
							if($netCashAmount!=0 || $billingChequeTotal!=0 || $cardDeposit!=0
									|| $billingRefund!=0 || $cardNetAmount!=0 || $cardPayment!=0){
					    		$html .= '<tr>
					    						<td align="left" valign="top" style= "text-align: left;">'.$userData['User']['full_name'].'</td>
					    						<td align="left" valign="top" style= "text-align: left;">'.$userData['Role']['name'].'</td>
					    						<td class="tdLabel"  style= "text-align: center;">';
					    		
					    					$html.= $netCashAmount?$netCashAmount :0;
					    							$totalCash +=  (double) $netCashAmount ; 
					    							
					    					$html .= '</td><td class="tdLabel"  style= "text-align: center;">';
					    					
					    					$html.= $billingChequeTotal?$billingChequeTotal :0;
					    							$totalChequeAmount +=  (double) $billingChequeTotal ; 
					    							
					    					$html .= '</td><td class="tdLabel"  style= "text-align: center;">';
					    				
					    					$html.= $cardDeposit?$cardDeposit :0;
					    							$totalCardAmount +=  (double) $cardDeposit;
					    							
					    					$html .= '</td><td class="tdLabel"  style= "text-align: center;">';
					    				
					    					$html.= $billingRefund?$billingRefund :0;
					    							$totalCashRefund +=  (double) $billingRefund;
					    							
					    					$html .= '</td><td class="tdLabel"  style= "text-align: center;">';
	
					    					$html .= $cardNetAmount?$cardNetAmount :0;
					    							$totalCardRefund +=  (double) $cardNetAmount;
					    							
					    					$html .= '</td><td class="tdLabel"  style= "text-align: center;">';
					    							$netAmount = ($netCashAmount + $cardDeposit - $billingRefund);
					    					$html .= $netAmount;  
					    							$totalNetAmount +=  (double) $netAmount;
					    							
					    					$html .= '</td><td class="tdLabel"  style= "text-align: center;">';
					    							$netCardAmount = ($cardDeposit - $cardNetAmount);
					    					$html .=  $netCardAmount;
					    							 $totalNetCardAmount +=  (double) $netCardAmount; 
					    							 
					    					$html .= "</td></tr>" ;
											}
					   					}
			 				$html .= '</table>' ;
	 				
					 		$html .='<table border="1" class="table_format"  cellpadding="0" cellspacing="0" width="100%" style="text-align:left;">
									<tr class="row_title" style="background-color:#A1B6BE;">
					 					<td width="30%" colspan = "2"></td>
								       <td width="14%" align="center" valign="middle"><strong>Cash Collection</strong></td>
									   <td width="8%" align="center" valign="middle"><strong>Cheque Collection</strong></td>
									   <td width="8%" align="center" valign="middle"><strong>Patient Card Transaction</strong></td>
									   <td width="10%" align="center" valign="middle"><strong>Cash Refund</strong></td>
					 				   <td width="10%" align="center" valign="middle"><strong>Patient Card Refund</strong></td>
					 				   <td width="10%" align="center" valign="middle"><strong>Nett Collection</strong></td>
					 				   <td width="10%" align="center" valign="middle"><strong>Nett Patient Card Transaction</strong></td>';
					 		$html .='</tr>';
					 		
					 		$html .= '<tr>
					 					<td class="tdLabel" colspan="2" style="text-align: right;"><font color="red"><b>Total :</b></font></td>
										<td class="tdLabel" style= "text-align: center;"><font color="red"><b>'.$totalCash.'</b></font></td>
										<td class="tdLabel" style= "text-align: center;"><font color="red"><b>'.$totalChequeAmount.'</b></font></td>
										<td class="tdLabel" style= "text-align: center;"><font color="red"><b>'.$totalCardAmount.'</b></font></td>
										<td class="tdLabel" style= "text-align: center;"><font color="red"><b>'.$totalCashRefund.'</b></font></td>
										<td class="tdLabel" style= "text-align: center;"><font color="red"><b>'.$totalCardRefund.'</b></font></td>
										<td class="tdLabel" style= "text-align: center;"><font color="red"><b>'.$totalNetAmount.'</b></font></td>
										<td class="tdLabel" style= "text-align: center;"><font color="red"><b>'.$totalNetCardAmount.'</b></font></td>
					 				</tr>';
					 		$html .= '</table>' ;
					 $html .='</td>';
	 			$html .='</tr>';
	 		$html .= '</table>' ;
	 		//pr($html);exit;
	// output the HTML content
	$tcpdf->writeHTML($html, true, false, true, false, 'middle');
	 
	// reset pointer to the last page
	$tcpdf->lastPage(); 
   
	//Close and output PDF document
	echo $tcpdf->Output('Daily_Collection_Details_'.$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).'.pdf', 'D');
	
?>