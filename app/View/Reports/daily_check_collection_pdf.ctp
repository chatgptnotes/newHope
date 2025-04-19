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
	  	$facilitynamewithreport = 'Daily Cheque Collection and NEFT Details'; 
	  	$facilityname = "";
	}
	else {
	    $headerString = "by ".$facilityname ;
		$facilitynamewithreport = $facilityname.'- Daily Cheque Collection and NEFT Details'; 
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

	$totalDischarge ='';
	$totalDischargeTime = '';
	$html ='<div style="margin-top:200px;">&nbsp;<span>Date: '.$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), false).'</span><br></div>';
        $totalAmount = 0;
        // get billing check //
        $html .= '<br /><table border="1" cellpadding="0" cellspacing="0" width="100%">';
                $html .= '<tr><td colspan="11" align="center"><h3>Billing</h3></td></tr>';
               $html .= '<tr class="row_title" style="background-color:#A1B6BE;">
          <td height="30px" align="center" valign="middle" width="5%"><strong>Sr.No.</strong></td>
          <td height="30px" align="center" valign="middle" width="10%"><strong>Date of Reg.</strong></td>
		  <td height="30px" align="center" valign="middle" width="10%"><strong>MRN</strong></td>
		  <td height="30px" align="center" valign="middle" width="10%"><strong>Patient Name</strong></td>
		  <td height="30px" align="center" valign="middle" width="5%"><strong>Patient Status</strong></td>
		  <td height="30px" align="center" valign="middle" width="5%"><strong>Patient Type</strong></td>
		  <td height="30px" align="center" valign="middle" width="10%"><strong>Payment Type</strong></td>
		  <td height="30px" align="center" valign="middle" width="10%"><strong>Payment Date</strong></td>
		  <td height="30px" align="center" valign="middle" width="10%"><strong>Mode of Payment</strong></td>
		  <td height="30px" align="center" valign="middle" width="15%"><strong>Payment Number</strong></td>
		  <td height="30px" align="center" valign="middle" width="10%"><strong>Amount</strong></td>
		 </tr>';
        if(count($getBillingCheck) > 0) {
               
		$dateshow = "";
		foreach($getBillingCheck as $getBillingCheckVal) {
                  $totalAmount += $getBillingCheckVal['Billing']['amount'];
                  $billingCnt++;
                  $formatted_address = $this->requestAction("/patients/setAddressFormat",array('pass' => array($getBillingCheckVal['Person'])));
				  
                  $dateExp = explode(" ", date("d/m/Y H:i:s", strtotime($this->DateFormat->formatDate2Local($getBillingCheckVal['Billing']['date'],'yyyy/mm/dd', true))));
				  if($getBillingCheckVal['Patient']['admission_type'] == "IPD") {
			        if($getBillingCheckVal['Patient']['is_discharge'] == 1) {  
						$patientstatus =  __('Discharged');
					} else {
						$patientstatus = __('Not Discharged');
					}
		           }
				   if($getBillingCheckVal['Patient']['admission_type'] == "OPD") {
			        if($getBillingCheckVal['Patient']['is_discharge'] == 1) {  
						$patientstatus = __('OP Process Completed');
					} else {
						$patientstatus = __('OP In-Progress');
					}
		           }
                   if($getBillingCheckVal['Billing']['mode_of_payment'] == "Cheque") {  
						$paymentno = $getBillingCheckVal['Billing']['check_credit_card_number'];
					}
				    if($getBillingCheckVal['Billing']['mode_of_payment'] == "NEFT") {  
						$paymentno = $getBillingCheckVal['Billing']['neft_number'];
					}

                 if($dateshow != $dateExp[0] && $billingCnt!= 1) {
	                 $html .= '<tr>			
	                           <td align="right" height="17px" colspan="10"><strong>Total</strong>&nbsp;&nbsp;</td>		
		                       <td align="center" height="17px">'.$billingDaysTotal.'</td>
	                           </tr>';
	                 $billingDaysTotal = 0;
                 } 
		  $html .= '<tr>';
		          $html .= '<td align="center" height="17px">'.$billingCnt.'</td>';
				  $html .= '<td align="center" height="17px">'.date("d/m/Y", strtotime($this->DateFormat->formatDate2Local($getBillingCheckVal['Patient']['form_received_on'],'yyyy/mm/dd', true))).'</td>';
				  $html .= '<td align="center" height="17px">'.$getBillingCheckVal['Patient']['admission_id'].'</td>';
                  $html .= '<td align="center" height="17px">'.$getBillingCheckVal['PatientInitial']['name'].' '.$getBillingCheckVal['Patient']['lookup_name'].'</td>';
				  $html .= '<td align="center" height="17px">'.$patientstatus.'</td>';
                  $html .= '<td align="center" height="17px">'.$getBillingCheckVal['Patient']['admission_type'].'</td>';
                  $html .= '<td align="center" height="17px">'.$getBillingCheckVal['Billing']['reason_of_payment'].'</td>';
				  $html .= '<td align="center" height="17px">'.$dateExp[0].'</td>';
				  $html .= '<td align="center" height="17px">'.$getBillingCheckVal['Billing']['mode_of_payment'].'</td>';
				  $html .= '<td align="center" height="17px">'.$paymentno.'</td>';
                  $html .= '<td align="center" height="17px">'.$getBillingCheckVal['Billing']['amount'].'</td>';
                  $html .= '</tr>';
                  $dateshow = $dateExp[0]; $billingDaysTotal += $getBillingCheckVal['Billing']['amount'];
		}
		        $html .= '<tr>			
	                           <td align="right" height="17px" colspan="10"><strong>Total</strong>&nbsp;&nbsp;</td>		
		                       <td align="center" height="17px">'.$billingDaysTotal.'</td>
	                           </tr>';
                
        } else {
            $cntBilling = "norecord";
            $html .= '<tr>			
	                           <td align="center" height="17px" colspan="11">No record found</td>		
		                       
	                           </tr>';
        }

		$html .= '</table>';
       if($cntBilling != 'norecord') {
           $html .= '<br /><table border="1" cellpadding="0" cellspacing="0" width="100%"><tr><td height="30px" align="right" valign="middle" colspan="10" width="90%"><strong>Total Amount</strong>&nbsp;&nbsp;</td>';
           $html .= '<td height="30px" align="center" valign="middle" width="10%"><strong>'.$totalAmount.'</strong>&nbsp;</td></tr>';
           $html .= '</table>';
        }
		
        
        
	
	
	// output the HTML content
	$tcpdf->writeHTML($html, true, false, true, false, '');
	 
	// reset pointer to the last page
	$tcpdf->lastPage(); 
	
	//Close and output PDF document
	echo $tcpdf->Output('Daily_Cheque_Collection_and_NEFT_Details'.$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).'.pdf', 'D');
	
?>