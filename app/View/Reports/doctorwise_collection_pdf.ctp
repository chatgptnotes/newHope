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
	  	$facilitynamewithreport = 'Doctor Wise Billing'; 
	  	$facilityname = "";
	}
	else {
	    $headerString = "by ".$facilityname ;
		$facilitynamewithreport = $facilityname.'-Doctor Wise Billing'; 
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

	
	$html ='<div style="margin-top:200px;">&nbsp;<span>Date: '.$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), false).'</span><br></div>';
        $totalAmount = 0;
        // get doctor wise collection //
		$html .= '<br /><table border="1" cellpadding="0" cellspacing="0" width="100%">';
               $html .= '<tr class="row_title" style="background-color:#A1B6BE;">
			   <td height="30px" align="center" valign="middle" width="5%"><strong>Sr.No.</strong></td>
               <td height="30px" align="center" valign="middle" width="10%"><strong>Date of Reg.</strong></td>
               <td height="30px" align="center" valign="middle" width="15%"><strong>Registration ID</strong></td>
               <td height="30px" align="center" valign="middle" width="15%"><strong>Patient Name</strong></td>
               <td height="30px" align="center" valign="middle" width="10%"><strong>Patient Status</strong></td>
               <td height="30px" align="center" valign="middle" width="5%"><strong>Patient Type</strong></td>  
               <td height="30px" align="center" valign="middle" width="10%"><strong>Consultant Type</strong></td>
               <td height="30px" align="center" valign="middle" width="10%"><strong>Consultant</strong></td>
               <td height="30px" align="center" valign="middle" width="10%"><strong>Payment Date</strong></td>
               <td height="30px" align="center" valign="middle" width="10%"><strong>Amount</strong></td>
               </tr>';
        if(count($getDoctorWiseCollection) > 0) {
          
               
		
		foreach($getDoctorWiseCollection as $getDoctorWiseCollectionVal) {
                  $cntCollection++;
				  $registration_date = date("d/m/Y", strtotime($this->DateFormat->formatDate2Local($getDoctorWiseCollectionVal['Patient']['form_received_on'],'yyyy/mm/dd',true)));
				  $payment_date = date("d/m/Y", strtotime($this->DateFormat->formatDate2Local($getDoctorWiseCollectionVal['ConsultantBilling']['date'],'yyyy/mm/dd',true)));
                  $totalAmount += $getDoctorWiseCollectionVal['ConsultantBilling']['amount'];
                  if($getDoctorWiseCollectionVal['Patient']['admission_type'] == "IPD") {
			        if($getDoctorWiseCollectionVal['Patient']['is_discharge'] == 1) {  
						$patientstatus =  __('Discharged');
					} else {
						$patientstatus = __('Not Discharged');
					}
		           }
				   if($getDoctorWiseCollectionVal['Patient']['admission_type'] == "OPD") {
			        if($getDoctorWiseCollectionVal['Patient']['is_discharge'] == 1) {  
						$patientstatus = __('OP Process Completed');
					} else {
						$patientstatus = __('OP In-Progress');
					}
		           }
				   if(!empty($getDoctorWiseCollectionVal['ConsultantBilling']['doctor_id'])) { 
			         $consultanttype =  __(Configure::read('doctor'));
					 $consultantname =  $getDoctorWiseCollectionVal['Initial']['name'].' '.$getDoctorWiseCollectionVal['DoctorProfile']['doctor_name'];
			       }
				   if(!empty($getDoctorWiseCollectionVal['ConsultantBilling']['consultant_id'])) { 
			         $consultanttype =   __('External Consultant');
					 $consultantname = $getDoctorWiseCollectionVal['InitialAlias']['name'].' '.$getDoctorWiseCollectionVal['Consultant']['first_name'].' '.$getDoctorWiseCollectionVal['Consultant']['last_name'];
			       }
				   

		  $html .= '<tr>';
		          $html .= '<td align="center" height="17px">'.$cntCollection.'</td>';
				  $html .= '<td align="center" height="17px">'.$registration_date.'</td>';
				  $html .= '<td align="center" height="17px">'.$getDoctorWiseCollectionVal['Patient']['admission_id'].'</td>';
                  $html .= '<td align="center" height="17px">'.$getDoctorWiseCollectionVal['PatientInitial']['name'].' '.$getDoctorWiseCollectionVal['Patient']['lookup_name'].'</td>';
				  $html .= '<td align="center" height="17px">'.$patientstatus.'</td>';
                  $html .= '<td align="center" height="17px">'.$getDoctorWiseCollectionVal['Patient']['admission_type'].'</td>';
                  $html .= '<td align="center" height="17px">'.$consultanttype.'</td>';
                  $html .= '<td align="center" height="17px">'.$consultantname.'</td>';
				  $html .= '<td align="center" height="17px">'.$payment_date.'</td>';
                  $html .= '<td align="center" height="17px">'.$getDoctorWiseCollectionVal['ConsultantBilling']['amount'].'</td>';
                  $html .= '</tr>';
		}
               
        } else {
             $cntDoctorWiseCollection = "norecord";
			  $html .= '<tr><td align="center" height="17px" colspan="10">No Record Found</td></tr>';
        }
		 if($cntDoctorWiseCollection != 'norecord') {
          $html .= '<tr><td align="right" height="17px" colspan="9" width="90%"><strong>Total</strong>&nbsp;&nbsp;</td><td align="center" width="10%">'.$totalAmount.'</td></tr>';
		 }
		 $html .= '</table>';

		
        
       	
	
	// output the HTML content
	$tcpdf->writeHTML($html, true, false, true, false, '');
	 
	// reset pointer to the last page
	$tcpdf->lastPage(); 
	
	//Close and output PDF document
	echo $tcpdf->Output('Doctor_Wise_Billing'.$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).'.pdf', 'D');
	
?>