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
	  	$facilitynamewithreport = 'Daily Cash Collection'; 
	  	$facilityname = "";
	}
	else {
	    $headerString = "by ".$facilityname ;
		$facilitynamewithreport = $facilityname.'-Daily Cash Collection'; 
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
        // get billing cash //
    if($getBillingCash){
        if(count($getBillingCash) > 0) {
               $html .= '<br /><table border="1" cellpadding="0" cellspacing="0" width="100%">';
               $html .= '<tr>
                         <td align="center"  colspan="11"><h3>Billing</h3></td>
                         </tr>
                         <tr class="row_title" style="background-color:#A1B6BE;">
         
          <td height="30px" align="center" valign="middle" width="10%"><strong>Date of Reg.</strong></td>
		  <td height="30px" align="center" valign="middle" width="10%"><strong>MRN</strong></td>
		  <td height="30px" align="center" valign="middle" width="10%"><strong>Patient Name</strong></td>
		  <td height="30px" align="center" valign="middle" width="8%"><strong>Patient Status</strong></td>
		  <td height="30px" align="center" valign="middle" width="5%"><strong>Patient Type</strong></td>
		  <td height="30px" align="center" valign="middle" width="7%"><strong>Mobile No</strong></td>
		  <td height="30px" align="center" valign="middle" width="10%"><strong>Address</strong></td>
		  <td height="30px" align="center" valign="middle" width="7%"><strong>Payment Type</strong></td>
          <td height="30px" align="center" valign="middle" width="10%"><strong>Collected By</strong></td>
		  <td height="30px" align="center" valign="middle" width="10%"><strong>Payment Date</strong></td>
		  <td height="30px" align="center" valign="middle" width="10%"><strong>Amount</strong></td>
		 </tr>';
		$dateshow = "";
		foreach($getBillingCash as $getBillingCashVal) {
                  $totalAmount += $getBillingCashVal['Billing']['amount'];
                  $billingCnt++;
                  $formatted_address = $this->requestAction("/patients/setAddressFormat",array('pass' => array($getBillingCashVal['Person'])));
				  $dateExp = explode(" ", date("d/m/Y H:i:s", strtotime($this->DateFormat->formatDate2Local($getBillingCashVal['Billing']['date'],'yyyy/mm/dd',true))));

				  if($getBillingCashVal['Patient']['admission_type'] == "IPD") {
			        if($getBillingCashVal['Patient']['is_discharge'] == 1) {  
						$patientstatus =  __('Discharged');
					} else {
						$patientstatus = __('Not Discharged');
					}
		           }
				   if($getBillingCashVal['Patient']['admission_type'] == "OPD") {
			        if($getBillingCashVal['Patient']['is_discharge'] == 1) {  
						$patientstatus = __('OP Process Completed');
					} else {
						$patientstatus = __('OP In-Progress');
					}
		           }
                           if(!$getBillingCashVal['Billing']['amount'])continue;
                  
                 if($dateshow!= '' &&  $dateshow != $dateExp[0] && $billingCnt!= 1) {
	                 $html .= '<tr>			
	                           <td align="right" height="17px" colspan="10"><strong>Total </strong>&nbsp;</td>		
		                       <td align="center" height="17px">'.$billingDaysTotal.'</td>
	                           </tr>';
	                 $billingDaysTotal = 0;
                 } 
           
		  $html .= '<tr>';
		          
		          $html .= '<td align="center" height="17px">'.date("d/m/Y", strtotime($this->DateFormat->formatDate2Local($getBillingCashVal['Patient']['form_received_on'],'yyyy/mm/dd', true))).'</td>';
                  $html .= '<td align="center" height="17px">'.$getBillingCashVal['Patient']['admission_id'].'</td>';
                  $html .= '<td align="center" height="17px">'.$getBillingCashVal['PatientInitial']['name'].' '.$getBillingCashVal['Patient']['lookup_name'].'</td>';
				  $html .= '<td align="center" height="17px">'.$patientstatus.'</td>';
                  $html .= '<td align="center" height="17px">'.$getBillingCashVal['Patient']['admission_type'].'</td>';
				  $html .= '<td align="center" height="17px">'.$getBillingCashVal['Person']['mobile'].'</td>';
                  $html .= '<td align="center" height="17px">'.$formatted_address.'</td>';
				  $html .= '<td align="center" height="17px">'.$getBillingCashVal['Billing']['mode_of_payment'].'</td>';
				  $html .= '<td align="center" height="17px">'.$getBillingCashVal['User']['first_name']." ".$getBillingCashVal['User']['last_name'].'</td>';
				  $html .= '<td align="center" height="17px">'.$dateExp[0].'</td>';
                  $html .= '<td align="center" height="17px">'.$getBillingCashVal['Billing']['amount'].'</td>';
                  $html .= '</tr>';
         $dateshow = $dateExp[0]; $billingDaysTotal += $getBillingCashVal['Billing']['amount'];
		}
		$html .= '<tr>			
	                           <td align="right" height="17px" colspan="10"><strong>Total </strong>&nbsp;</td>		
		                       <td align="center" height="17px">'.$billingDaysTotal.'</td>
	                           </tr>';
                
        } else {
            $cntBilling = "norecord";
            $html .= '<tr>
                         <td align="center"  colspan="10">No Record Found</td>
                         </tr>';
        }
        $html .= '</table>';
        }
        if($getRadiologyTestCash){
        // get radiology test cash //
        $html .= '<br /><table border="1" cellpadding="0" cellspacing="0" width="100%">';
         $html .= '<tr>
                         <td align="center"  colspan="11"><h3>Radiology</h3></td>
                         </tr>
                         <tr class="row_title" style="background-color:#A1B6BE;">
          
          <td height="30px" align="center" valign="middle" width="10%"><strong>Date</strong></td>
		  <td height="30px" align="center" valign="middle" width="10%"><strong>MRN</strong></td>
		  <td height="30px" align="center" valign="middle" width="10%"><strong>Patient Name</strong></td>
		  <td height="30px" align="center" valign="middle" width="8%"><strong>Patient Status</strong></td>
		  <td height="30px" align="center" valign="middle" width="5%"><strong>Patient Type</strong></td>   
		  <td height="30px" align="center" valign="middle" width="7%"><strong>Mobile No</strong></td>
		  <td height="30px" align="center" valign="middle" width="10%"><strong>Address</strong></td>
		  <td height="30px" align="center" valign="middle" width="7%"><strong>Payment Type</strong></td>
           <td height="30px" align="center" valign="middle" width="10%"><strong>Collected By</strong></td>
		  <td height="30px" align="center" valign="middle" width="10%"><strong>Payment Date</strong></td>
		  <td height="30px" align="center" valign="middle" width="10%"><strong>Amount</strong></td>
		 </tr>';
        if(count($getRadiologyTestCash) > 0) {
		
                
		 $dateshow = "";
		foreach($getRadiologyTestCash as $getRadiologyTestCashVal) {
                  $totalAmount += $getRadiologyTestCashVal['RadiologyTestOrder']['paid_amount'];
                  $radiologyCnt++;
                  $formatted_address = $this->requestAction("/patients/setAddressFormat",array('pass' => array($getRadiologyTestCashVal['Person'])));
				  
                  $dateExp = explode(" ", date("d/m/Y H:i:s", strtotime($this->DateFormat->formatDate2Local($getRadiologyTestCashVal['RadiologyTestOrder']['create_time'],'yyyy/mm/dd',true))));
				  if($getRadiologyTestCashVal['Patient']['admission_type'] == "IPD") {
			        if($getRadiologyTestCashVal['Patient']['is_discharge'] == 1) {  
						$patientstatus =  __('Discharged');
					} else {
						$patientstatus = __('Not Discharged');
					}
		           }
				   if($getRadiologyTestCashVal['Patient']['admission_type'] == "OPD") {
			        if($getRadiologyTestCashVal['Patient']['is_discharge'] == 1) {  
						$patientstatus = __('OP Process Completed');
					} else {
						$patientstatus = __('OP In-Progress');
					}
		           }
                   if(!$getRadiologyTestCashVal['RadiologyTestOrder']['paid_amount'])continue;
                 if($dateshow!= '' &&  $dateshow != $dateExp[0] && $radiologyCnt!= 1) {
	                 $html .= '<tr>			
	                           <td align="right" height="17px" colspan="11"><strong>Total </strong>&nbsp;</td>		
		                       <td align="center" height="17px">'.$radiologyDaysTotal.'</td>
	                           </tr>';
	                 $radiologyDaysTotal = 0;
                 } 
		  $html .= '<tr>';
		          
				  $html .= '<td align="center" height="17px">'.date("d/m/Y", strtotime($this->DateFormat->formatDate2Local($getRadiologyTestCashVal['Patient']['form_received_on'],'yyyy/mm/dd', true))).'</td>';
		          $html .= '<td align="center" height="17px">'.$getRadiologyTestCashVal['Patient']['admission_id'].'</td>';
                  $html .= '<td align="center" height="17px">'.$getRadiologyTestCashVal['PatientInitial']['name'].' '.$getRadiologyTestCashVal['Patient']['lookup_name'].'</td>';
				  $html .= '<td align="center" height="17px">'.$patientstatus.'</td>';
                  $html .= '<td align="center" height="17px">'.$getRadiologyTestCashVal['Patient']['admission_type'].'</td>';
                  $html .= '<td align="center" height="17px">'.$getRadiologyTestCashVal['Person']['mobile'].'</td>';
                  $html .= '<td align="center" height="17px">'.$formatted_address.'</td>';
				  $html .= '<td align="center" height="17px">'.$getRadiologyTestCashVal['Billing']['mode_of_payment'].'</td>';
				  $html .= '<td align="center" height="17px">'.$getRadiologyTestCashVal['User']['first_name']." ".$getRadiologyTestCashVal['User']['last_name'].'</td>';
				  $html .= '<td align="center" height="17px">'.$dateExp[0].'</td>';
                  $html .= '<td align="center" height="17px">'.$getRadiologyTestCashVal['RadiologyTestOrder']['paid_amount'].'</td>';
                  $html .= '</tr>';
          $dateshow = $dateExp[0]; $radiologyDaysTotal += $getRadiologyTestCashVal['RadiologyTestOrder']['paid_amount'];
		}
		$html .= '<tr>			
	                           <td align="right" height="17px" colspan="10"><strong>Total </strong>&nbsp;</td>		
		                       <td align="center" height="17px">'.$radiologyDaysTotal.'</td>
	                           </tr>';
                //$html .= '</table>';
        } else {
            $cntRadiology = 'norecord';
            $html .= '<tr>
                         <td align="center"  colspan="10">No Record Found</td>
                         </tr>
                         ';
        }
        $html .= '</table>';
   }
   if($getLaboratoryTestCash){
        // get lab test cash //
        $html .= '<br /><table border="1" cellpadding="0" cellspacing="0" width="100%">';
        $html .= '<tr>
                         <td align="center"  colspan="11"><h3>Laboratory</h3></td>
                         </tr>
                         <tr class="row_title" style="background-color:#A1B6BE;">
          
          <td height="30px" align="center" valign="middle" width="10%"><strong>Date</strong></td>
		  <td height="30px" align="center" valign="middle" width="10%"><strong>MRN</strong></td>
		  <td height="30px" align="center" valign="middle" width="10%"><strong>Patient Name</strong></td>
		  <td height="30px" align="center" valign="middle" width="8%"><strong>Patient Status</strong></td>
		  <td height="30px" align="center" valign="middle" width="5%"><strong>Patient Type</strong></td>  
		  <td height="30px" align="center" valign="middle" width="7%"><strong>Mobile No</strong></td>
		  <td height="30px" align="center" valign="middle" width="10%"><strong>Address</strong></td>
		  <td height="30px" align="center" valign="middle" width="7%"><strong>Payment Type</strong></td>
          <td height="30px" align="center" valign="middle" width="10%"><strong>Collected By</strong></td>
		  <td height="30px" align="center" valign="middle" width="10%"><strong>Payment Date</strong></td>
		  <td height="30px" align="center" valign="middle" width="10%"><strong>Amount</strong></td>
		 </tr>';
        if(count($getLaboratoryTestCash) > 0) {
		               
		 $dateshow = "";
		foreach($getLaboratoryTestCash as $getLaboratoryTestCashVal) {
                  $totalAmount += $getLaboratoryTestCashVal['LaboratoryTestOrder']['paid_amount'];
                  $laboratoryCnt++;
                  $formatted_address = $this->requestAction("/patients/setAddressFormat",array('pass' => array($getLaboratoryTestCashVal['Person'])));
				  
                  $dateExp = explode(" ", date("d/m/Y H:i:s", strtotime($this->DateFormat->formatDate2Local($getLaboratoryTestCashVal['LaboratoryTestOrder']['create_time'],'yyyy/mm/dd',true))));
				   if($getLaboratoryTestCashVal['Patient']['admission_type'] == "IPD") {
			        if($getLaboratoryTestCashVal['Patient']['is_discharge'] == 1) {  
						$patientstatus =  __('Discharged');
					} else {
						$patientstatus = __('Not Discharged');
					}
		           }
				   if($getLaboratoryTestCashVal['Patient']['admission_type'] == "OPD") {
			        if($getLaboratoryTestCashVal['Patient']['is_discharge'] == 1) {  
						$patientstatus = __('OP Process Completed');
					} else {
						$patientstatus = __('OP In-Progress');
					}
		           }
                   if(!$getLaboratoryTestCashVal['LaboratoryTestOrder']['paid_amount'])continue;
                 if($dateshow!= '' &&  $dateshow != $dateExp[0] && $laboratoryCnt!= 1) {
	                 $html .= '<tr>			
	                           <td align="right" height="17px" colspan="10"><strong>Total </strong>&nbsp;</td>		
		                       <td align="center" height="17px">'.$laboratoryDaysTotal.'</td>
	                           </tr>';
	                 $laboratoryDaysTotal = 0;
                 } 
		  $html .= '<tr>';
		         
				  $html .= '<td align="center" height="17px">'.date("d/m/Y", strtotime($this->DateFormat->formatDate2Local($getLaboratoryTestCashVal['Patient']['form_received_on'],'yyyy/mm/dd', true))).'</td>';
		          $html .= '<td align="center" height="17px">'.$getLaboratoryTestCashVal['Patient']['admission_id'].'</td>';
                  $html .= '<td align="center" height="17px">'.$getLaboratoryTestCashVal['PatientInitial']['name'].' '.$getLaboratoryTestCashVal['Patient']['lookup_name'].'</td>';
				  $html .= '<td align="center" height="17px">'.$patientstatus.'</td>';
                  $html .= '<td align="center" height="17px">'.$getLaboratoryTestCashVal['Patient']['admission_type'].'</td>';
                  $html .= '<td align="center" height="17px">'.$getLaboratoryTestCashVal['Person']['mobile'].'</td>';
                  $html .= '<td align="center" height="17px">'.$formatted_address.'</td>';
				  $html .= '<td align="center" height="17px">'.$getLaboratoryTestCashVal['Billing']['mode_of_payment'].'</td>';
				  $html .= '<td align="center" height="17px">'.$getLaboratoryTestCashVal['User']['first_name']." ".$getLaboratoryTestCashVal['User']['last_name'].'</td>';
				  $html .= '<td align="center" height="17px">'.$dateExp[0].'</td>';
                  $html .= '<td align="center" height="17px">'.$getLaboratoryTestCashVal['LaboratoryTestOrder']['paid_amount'].'</td>';
                  $html .= '</tr>';
          $dateshow = $dateExp[0]; $laboratoryDaysTotal += $getLaboratoryTestCashVal['LaboratoryTestOrder']['paid_amount'];
		}
		$html .= '<tr>			
	                           <td align="right" height="17px" colspan="10"><strong>Total </strong>&nbsp;</td>		
		                       <td align="center" height="17px">'.$laboratoryDaysTotal.'</td>
	                           </tr>';
               
        }else {
            $cntLaboratory = 'norecord';
            $html .= '<tr>
                         <td align="center"  colspan="10">No Record Found</td>
                         </tr>
                         ';
        }
   }

        $html .= '</table>';
        if($getPharmacyCash){
        // get pharmacy  cash //
        $html .= '<br /><table border="1" cellpadding="0" cellspacing="0" width="100%">';
        $html .= '<tr>
                         <td align="center"  colspan="11"><h3>Pharmacy</h3></td>
                         </tr>
                         <tr class="row_title" style="background-color:#A1B6BE;">
          
          <td height="30px" align="center" valign="middle" width="10%"><strong>Date</strong></td>
		  <td height="30px" align="center" valign="middle" width="10%"><strong>MRN</strong></td>
		  <td height="30px" align="center" valign="middle" width="10%"><strong>Patient Name</strong></td>
		  <td height="30px" align="center" valign="middle" width="8%"><strong>Patient Status</strong></td>
		  <td height="30px" align="center" valign="middle" width="5%"><strong>Patient Type</strong></td>  
		  <td height="30px" align="center" valign="middle" width="7%"><strong>Mobile No</strong></td>
		  <td height="30px" align="center" valign="middle" width="10%"><strong>Address</strong></td>
		  <td height="30px" align="center" valign="middle" width="7%"><strong>Payment Type</strong></td>
          <td height="30px" align="center" valign="middle" width="10%"><strong>Collected By</strong></td>
		  <td height="30px" align="center" valign="middle" width="10%"><strong>Payment Date</strong></td>
		  <td height="30px" align="center" valign="middle" width="10%"><strong>Amount</strong></td>
		 </tr>';
        if(count($getPharmacyCash) > 0) {
		                
		 $dateshow = "";
		foreach($getPharmacyCash as $getPharmacyCashVal) {
                  $totalAmount += $getPharmacyCashVal['PharmacySalesBill']['total'];
                  $pharmacyCnt++;
                  $formatted_address = $this->requestAction("/patients/setAddressFormat",array('pass' => array($getPharmacyCashVal['Person'])));
				  
                  $dateExp = explode(" ", date("d/m/Y H:i:s", strtotime($this->DateFormat->formatDate2Local($getPharmacyCashVal['PharmacySalesBill']['create_time'],'yyyy/mm/dd', true))));
                  if($getPharmacyCashVal['Patient']['admission_type'] == "IPD") {
			        if($getPharmacyCashVal['Patient']['is_discharge'] == 1) {  
						$patientstatus =  __('Discharged');
					} else {
						$patientstatus = __('Not Discharged');
					}
		           }
				   if($getPharmacyCashVal['Patient']['admission_type'] == "OPD") {
			        if($getPharmacyCashVal['Patient']['is_discharge'] == 1) {  
						$patientstatus = __('OP Process Completed');
					} else {
						$patientstatus = __('OP In-Progress');
					}
		           }
                           if(!$getPharmacyCashVal['PharmacySalesBill']['total'])continue;
                 if($dateshow!= '' &&  $dateshow != $dateExp[0] && $pharmacyCnt!= 1) {
	                 $html .= '<tr>			
	                           <td align="right" height="17px" colspan="10"><strong>Total </strong>&nbsp;</td>		
		                       <td align="center" height="17px">'.$pharmacyDaysTotal.'</td>
	                           </tr>';
	                 $pharmacyDaysTotal = 0;
                 } 
		  $html .= '<tr>';
		          
				  $html .= '<td align="center" height="17px">'.date("d/m/Y", strtotime($this->DateFormat->formatDate2Local($getLaboratoryTestCashVal['Patient']['form_received_on'],'yyyy/mm/dd', true))).'</td>';
		          $html .= '<td align="center" height="17px">'.$getPharmacyCashVal['Patient']['admission_id'].'</td>';
                  $html .= '<td align="center" height="17px">'.$getPharmacyCashVal['PatientInitial']['name'].' '.$getPharmacyCashVal['Patient']['lookup_name'].'</td>';
				  $html .= '<td align="center" height="17px">'.$patientstatus.'</td>';
                  $html .= '<td align="center" height="17px">'.$getPharmacyCashVal['Patient']['admission_type'].'</td>';
                  $html .= '<td align="center" height="17px">'.$getPharmacyCashVal['Person']['mobile'].'</td>';
                  $html .= '<td align="center" height="17px">'.$formatted_address.'</td>';
				  $html .= '<td align="center" height="17px">'.$getPharmacyCashVal['PharmacySalesBill']['payment_mode'].'</td>';
				  $html .= '<td align="center" height="17px">'.$getPharmacyCashVal['User']['first_name']." ".$getPharmacyCashVal['User']['last_name'].'</td>';
				  $html .= '<td align="center" height="17px">'.$dateExp[0].'</td>';
                  $html .= '<td align="center" height="17px">'.$getPharmacyCashVal['PharmacySalesBill']['total'].'</td>';
                  $html .= '</tr>';
          $dateshow = $dateExp[0]; $pharmacyDaysTotal += $getPharmacyCashVal['PharmacySalesBill']['total'];
		}
		 $html .= '<tr>			
	                           <td align="right" height="17px" colspan="10"><strong>Total </strong>&nbsp;</td>		
		                       <td align="center" height="17px">'.$pharmacyDaysTotal.'</td>
	                           </tr>';
              
        } else {
            $cntPharmacy = 'norecord';
            $html .= '<tr>
                         <td align="center"  colspan="10">No Record Found</td>
                         </tr>
                         ';
        }
        $html .= '</table>';
        }
        if($cntPharmacy != 'norecord' || $cntLaboratory != 'norecord' || $cntRadiology != 'norecord' || $cntBilling != 'norecord') {
           $html .= '<br /><table border="1" cellpadding="0" cellspacing="0" width="100%"><tr><td height="30px" align="right" valign="middle" colspan="10" width="90%"><strong>Total Amount</strong>&nbsp;&nbsp;</td>';
           $html .= '<td height="30px" align="center" valign="middle" width="10%"><strong>'.$totalAmount.'</strong></td></tr>';
           $html .= '</table>';
        }
        
       
	
	
	// output the HTML content
	$tcpdf->writeHTML($html, true, false, true, false, '');
	 
	// reset pointer to the last page
	$tcpdf->lastPage(); 
	
	//Close and output PDF document
	echo $tcpdf->Output('Daily_Cash_Collection'.$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).'.pdf', 'D');
	
?>