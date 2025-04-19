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
	  	$facilitynamewithreport = 'Daily Credit Card Collection'; 
	  	$facilityname = "";
	}
	else {
	    $headerString = "by ".$facilityname ;
		$facilitynamewithreport = $facilityname.'-Daily Credit Card Collection'; 
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
        // get billing credit //
        $html .= '<br /><table border="1" cellpadding="0" cellspacing="0" width="100%">';
               $html .= '<tr>
                         <td align="center"  colspan="11"><h3>Billing</h3></td>
                         </tr><tr class="row_title" style="background-color:#A1B6BE;">
          <td height="30px" align="center" valign="middle" width="5%"><strong>Sr.No.</strong></td>
          <td height="30px" align="center" valign="middle" width="10%"><strong>Date of Reg.</strong></td>
		  <td height="30px" align="center" valign="middle" width="10%"><strong>MRN</strong></td>
		  <td height="30px" align="center" valign="middle" width="10%"><strong>Patient Name</strong></td>
		  <td height="30px" align="center" valign="middle" width="8%"><strong>Patient Status</strong></td>
		  <td height="30px" align="center" valign="middle" width="5%"><strong>Patient Type</strong></td>
		  <td height="30px" align="center" valign="middle" width="15%"><strong>Address</strong></td>
		  <td height="30px" align="center" valign="middle" width="7%"><strong>Sponsor Name</strong></td>
		  <td height="30px" align="center" valign="middle" width="10%"><strong>Payment Type</strong></td>
		  <td height="30px" align="center" valign="middle" width="10%"><strong>Payment Date</strong></td>
		  <td height="30px" align="center" valign="middle" width="10%"><strong>Amount</strong></td>
		 </tr>';
        if(count($getBillingCredit) > 0) {
               
		$dateshow = "";
		foreach($getBillingCredit as $getBillingCreditVal) {
                  $totalAmount += $getBillingCreditVal['Billing']['amount'];
                  $billingCnt++;
                  $formatted_address = $this->requestAction("/patients/setAddressFormat",array('pass' => array($getBillingCreditVal['Person'])));
				  
                  $dateExp = explode(" ", date("d/m/Y H:i:s", strtotime($this->DateFormat->formatDate2Local($getBillingCreditVal['Billing']['date'],'yyyy/mm/dd', true))));
				  if($getBillingCreditVal['Patient']['admission_type'] == "IPD") {
			        if($getBillingCreditVal['Patient']['is_discharge'] == 1) {  
						$patientstatus =  __('Discharged');
					} else {
						$patientstatus = __('Not Discharged');
					}
		           }
				   if($getBillingCreditVal['Patient']['admission_type'] == "OPD") {
			        if($getBillingCreditVal['Patient']['is_discharge'] == 1) {  
						$patientstatus = __('OP Process Completed');
					} else {
						$patientstatus = __('OP In-Progress');
					}
		           }

				   if($getBillingCreditVal['Corporate']['name']) 
			          $sponsor_name = $getBillingCreditVal['Corporate']['name'];
		           elseif($getBillingCreditVal['InsuranceCompany']['name']) 
					   $sponsor_name = $getBillingCreditVal['InsuranceCompany']['name'];
				   else 
					   $sponsor_name =  __('Private');
                  
                 if($dateshow != $dateExp[0] && $billingCnt!= 1) {
	                 $html .= '<tr>			
	                           <td align="right" height="17px" colspan="10"><strong>Total </strong>&nbsp;</td>		
		                       <td align="center" height="17px">'.$billingDaysTotal.'</td>
	                           </tr>';
	                 $billingDaysTotal = 0;
                 }
		  $html .= '<tr>';
		          $html .= '<td align="center" height="17px">'.$billingCnt.'</td>';
		          $html .= '<td align="center" height="17px">'.date("d/m/Y", strtotime($this->DateFormat->formatDate2Local($getBillingCreditVal['Patient']['form_received_on'],'yyyy/mm/dd', true))).'</td>';
                  $html .= '<td align="center" height="17px">'.$getBillingCreditVal['Patient']['admission_id'].'</td>';
                  $html .= '<td align="center" height="17px">'.$getBillingCreditVal['PatientInitial']['name'].' '.$getBillingCreditVal['Patient']['lookup_name'].'</td>';
				  $html .= '<td align="center" height="17px">'.$patientstatus.'</td>';
                  $html .= '<td align="center" height="17px">'.$getBillingCreditVal['Patient']['admission_type'].'</td>';
                  $html .= '<td align="center" height="17px">'.$formatted_address.'</td>';
				  $html .= '<td align="center" height="17px">'.$sponsor_name.'</td>';
				  $html .= '<td align="center" height="17px">'.$getBillingCreditVal['Billing']['reason_of_payment'].'</td>';
				  $html .= '<td align="center" height="17px">'.$dateExp[0].'</td>';
                  $html .= '<td align="center" height="17px">'.$getBillingCreditVal['Billing']['amount'].'</td>';
                  $html .= '</tr>';
                  $dateshow = $dateExp[0]; $billingDaysTotal += $getBillingCreditVal['Billing']['amount'];
		}
		        $html .= '<tr>			
	                           <td align="right" height="17px" colspan="10"><strong>Total </strong>&nbsp;</td>		
		                       <td align="center" height="17px">'.$billingDaysTotal.'</td>
	                           </tr>';
                
        } else {
            $cntBilling = "norecord";
            $html .= '<tr><td colspan="11" align="center">No record found</td></tr>';
        }
        $html .= '</table>';
        // get pharmacy  credit //
        $html .= '<br /><table border="1" cellpadding="0" cellspacing="0" width="100%">';
               $html .= '<tr>
                         <td align="center"  colspan="11"><h3>Pharmacy</h3></td>
                         </tr><tr class="row_title" style="background-color:#A1B6BE;">
          <td height="30px" align="center" valign="middle" width="5%"><strong>Sr.No.</strong></td>
          <td height="30px" align="center" valign="middle" width="10%"><strong>Date of Reg.</strong></td>
		  <td height="30px" align="center" valign="middle" width="10%"><strong>MRN</strong></td>
		  <td height="30px" align="center" valign="middle" width="10%"><strong>Patient Name</strong></td>
		  <td height="30px" align="center" valign="middle" width="8%"><strong>Patient Status</strong></td>
		  <td height="30px" align="center" valign="middle" width="5%"><strong>Patient Type</strong></td>
		  <td height="30px" align="center" valign="middle" width="15%"><strong>Address</strong></td>
		  <td height="30px" align="center" valign="middle" width="7%"><strong>Sponsor Name</strong></td>
		  <td height="30px" align="center" valign="middle" width="10%"><strong>Payment Type</strong></td>
		  <td height="30px" align="center" valign="middle" width="10%"><strong>Payment Date</strong></td>
		  <td height="30px" align="center" valign="middle" width="10%"><strong>Amount</strong></td>
		 </tr>';
        if(count($getPharmacyCredit) > 0) {
		  
		 $dateshow = "";
		foreach($getPharmacyCredit as $getPharmacyCreditVal) {
                  $totalAmount += $getPharmacyCreditVal['Pharmacy']['total'];
                  $pharmacyCnt++;
                  $formatted_address = $this->requestAction("/patients/setAddressFormat",array('pass' => array($getPharmacyCreditVal['Person'])));
				  
                  $dateExp = explode(" ", date("d/m/Y H:i:s", strtotime($this->DateFormat->formatDate2Local($getPharmacyCreditVal['PharmacySalesBill']['create_time'],'yyyy/mm/dd', true))));

				  if($getPharmacyCreditVal['Patient']['admission_type'] == "IPD") {
			        if($getPharmacyCreditVal['Patient']['is_discharge'] == 1) {  
						$patientstatus =  __('Discharged');
					} else {
						$patientstatus = __('Not Discharged');
					}
		           }
				   if($getPharmacyCreditVal['Patient']['admission_type'] == "OPD") {
			        if($getPharmacyCreditVal['Patient']['is_discharge'] == 1) {  
						$patientstatus = __('OP Process Completed');
					} else {
						$patientstatus = __('OP In-Progress');
					}
		           }
				   if($getPharmacyCreditVal['Corporate']['name']) 
			          $sponsor_name = $getPharmacyCreditVal['Corporate']['name'];
		           elseif($getPharmacyCreditVal['InsuranceCompany']['name']) 
					   $sponsor_name = $getPharmacyCreditVal['InsuranceCompany']['name'];
				   else 
					   $sponsor_name = __('Private');
                  
                 if($dateshow != $dateExp[0] && $pharmacyCnt!= 1) {
	                 $html .= '<tr>			
	                           <td align="right" height="17px" colspan="10"><strong>Total </strong>&nbsp;</td>		
		                       <td align="center" height="17px">'.$pharmacyDaysTotal.'</td>
	                           </tr>';
	                 $pharmacyDaysTotal = 0;
                 } 
		  $html .= '<tr>';
		          $html .= '<td align="center" height="17px">'.$pharmacyCnt.'</td>';
		          $html .= '<td align="center" height="17px">'.date("d/m/Y", strtotime($this->DateFormat->formatDate2Local($getPharmacyCreditVal['Patient']['form_received_on'],'yyyy/mm/dd', true))).'</td>';
                  $html .= '<td align="center" height="17px">'.$getPharmacyCreditVal['PatientInitial']['name'].' '.$getPharmacyCreditVal['Patient']['lookup_name'].'</td>';
				  $html .= '<td align="center" height="17px">'.$patientstatus.'</td>';
                  $html .= '<td align="center" height="17px">'.$getPharmacyCreditVal['Patient']['admission_id'].'</td>';
                  $html .= '<td align="center" height="17px">'.$getPharmacyCreditVal['Patient']['admission_type'].'</td>';
                  $html .= '<td align="center" height="17px">'.$formatted_address.'</td>';
				  $html .= '<td align="center" height="17px">'.$sponsor_name.'</td>';
				  $html .= '<td align="center" height="17px"></td>';
				  $html .= '<td align="center" height="17px">'.$dateExp[0].'</td>';
                  $html .= '<td align="center" height="17px">'.$getPharmacyCreditVal['Pharmacy']['total'].'</td>';
                  $html .= '</tr>';
                  $dateshow = $dateExp[0]; $pharmacyDaysTotal += $getPharmacyCreditVal['Pharmacy']['total'];
		}
		$html .= '<tr>			
	                           <td align="right" height="17px" colspan="10"><strong>Total </strong>&nbsp;</td>		
		                       <td align="center" height="17px">'.$pharmacyDaysTotal.'</td>
	                           </tr>';
               
        } else {
            $cntPharmacy = 'norecord';
            $html .= '<tr>			
	                           <td align="center" height="17px" colspan="11">No record found</td>		
		                       </tr>';
        }
        $html .= '</table>';
        if($cntPharmacy != 'norecord' || $cntBilling != 'norecord') {
           $html .= '<br /><table border="1" cellpadding="0" cellspacing="0" width="100%"><tr><td height="30px" align="right" valign="middle" colspan="10" width="90%"><strong>Total Amount(Billing,Pharmacy) </strong>&nbsp;</td>';
           $html .= '<td height="30px" align="center" valign="middle" width="10%"><strong>'.$totalAmount.'</strong>&nbsp;</td></tr>';
           $html .= '</table>';
        }
        
        
	
	
	// output the HTML content
	$tcpdf->writeHTML($html, true, false, true, false, '');
	 
	// reset pointer to the last page
	$tcpdf->lastPage(); 
	
	//Close and output PDF document
	echo $tcpdf->Output('Daily_Credit_Card_Collection'.$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).'.pdf', 'D');
	
?>