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
	  	$facilitynamewithreport = 'Total Discharge Report'; 
	  	$facilityname = "";
	}
	else {
	    $headerString = "by ".$facilityname ;
		$facilitynamewithreport = $facilityname.'-Total Discharge Report'; 
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
			   <td height="30px" align="center" valign="middle" width="13%"><strong>Date Of Reg.</strong></td>	
			   <td height="30px" align="center" valign="middle" width="15%"><strong>MRN</strong></td>
			   <td height="30px" align="center" valign="middle" width="15%"><strong>Patient Name</strong></td>
			   <td height="30px" align="center" valign="middle" width="10%"><strong>Patient Type</strong></td>
			   <td height="30px" align="center" valign="middle" width="10%"><strong>Sponsor Name</strong></td>
			   <td height="30px" align="center" valign="middle" width="10%"><strong>Discharge Date</strong></td>
			   <td height="30px" align="center" valign="middle" width="10%"><strong>Reason of Discharge</strong></td>
               <td height="30px" align="center" valign="middle" width="10%"><strong>Amount</strong></td>
               <td height="30px" align="center" valign="middle" width="10%"><strong>Amount Paid</strong></td>
           	  <td height="30px" align="center" valign="middle" width="10%"><strong>Total Outstanding</strong></td>';
			
			$html .='</tr>';
				  	  $toggle =0;
					 $totalAmount=0;				 
				      if(count($reports) > 0) {
						   $i = 1;
				      		foreach($reports as $pdfData){	
                                                  $totalAmount +=$pdfData['FinalBilling']['total_amount'];	
												  if(!empty($pdfData['Corporate']['name'])) $patient_org = $pdfData['Corporate']['name']; 
		                                          elseif(!empty($pdfData['InsuranceCompany']['name'])) $patient_org =  $pdfData['InsuranceCompany']['name'];
												  else $patient_org = __('Private');
				      			if(!empty($pdfData['Patient']['create_time'])){							
									$html .= '<tr>
											   <td align="center" height="17px" >'.$i.'</td>
											   <td align="center" height="17px" >'.$this->DateFormat->formatDate2Local($pdfData['Patient']['form_received_on'],Configure::read('date_format')).'</td>';
	
									$html .= '<td align="center" height="17px" >'.$pdfData['Patient']['admission_id'].'</td>';
								    $html .=	 '<td align="center" height="17px" >'.$pdfData['PatientInitial']['name']." ".$pdfData['Patient']['lookup_name'].'</td>
											     <td align="center" height="17px" >'.$pdfData['Patient']['admission_type'].'</td>';
									$html .= '<td align="center" height="17px" >'.$patient_org.'</td>';
								   
								$html .='<td align="center" height="17px" >'.date('d-m-Y h:i A',strtotime($pdfData['FinalBilling']['discharge_date'])).'</td>
									   <td align="center" height="17px" >'.$pdfData['FinalBilling']['reason_of_discharge'].'</td>
                                                                           <td align="center" height="17px" >'.$pdfData['FinalBilling']['total_amount'].'</td>';
                                $html .='<td align="center" height="17px" >'.$pdfData['FinalBilling']['reason_of_discharge'].'</td>
                                                                           <td align="center" height="17px" >'.$pdfData['FinalBilling']['amount_paid'].'</td>';
                                $html .='<td align="center" height="17px" >'.$pdfData['FinalBilling']['reason_of_discharge'].'</td>
                                                                           <td align="center" height="17px" >'.$pdfData['FinalBilling']['total_amount']-$pdfData['FinalBilling']['amount_paid'].'</td>';
                                $totalPaid +=$pdfData['FinalBilling']['amount_paid'];
                                                                
									
									
									$html .='</tr>';
								 $i++; 
				      			}
						   }
						   $balnce=$totalAmount-$totalPaid;
						    $html .=' <tr>
										
										<td height="30px" align="right" colspan="8" valign="middle" ><strong>Total Amount</strong>&nbsp;</td>											
										<td align="center" height="17px">'.$totalAmount.'</td>
										<td align="center" height="17px">'.$totalPaid.'</td>
										<td align="center" height="17px">'.$balnce.'</td>	
									   </tr>';
						  
					 } else {
						$html .= '<tr>
								<td colspan = "9" align="center" height="30px">No Record Found</td>
						</tr>';
					 }
					   		  
		$html .= '</table>' ;

	
	// output the HTML content
	$tcpdf->writeHTML($html, true, false, true, false, '');
	 
	// reset pointer to the last page
	$tcpdf->lastPage(); 
	
	//Close and output PDF document
	//echo $tcpdf->Output('PatientDischargeReport_'.date('d-m-Y h.iA').'.pdf', 'D');
	echo $tcpdf->Output('Total_Discharge_Report'.$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).'.pdf', 'D');
	
?>