<?php
	App::import('Vendor','tcpdf/config/lang/eng'); 
	App::import('Vendor','tcpdf/tcpdf');
	$facilityname = ucfirst($this->Session->read("facility"));
	$headerimage = $this->Session->read("header_image");
	$facilitynamewithreport;
	
	if(empty($facilityname)) {
	  	$facilitynamewithreport = 'Total Concessions'; 
	  	$facilityname = "";
	}
	else {
	    $headerString = "by ".$facilityname ;
		$facilitynamewithreport = $facilityname.'-Total Concessions'; 
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
	    $html .= '<br /><table border="1" cellpadding="0" cellspacing="0" width="100%">';
         $html .= '<tr class="row_title" style="background-color:#A1B6BE;">
		          <td height="30px" align="center" valign="middle" width="5%"><strong>Sr.No.</strong></td>
                  <td height="30px" align="center" valign="middle" width="10%"><strong>Date of Reg.</strong></td>	
                  <td height="30px" align="center" valign="middle" width="10%"><strong>MRN</strong></td>
                  <td height="30px" align="center" valign="middle" width="10%"><strong>Patient Name</strong></td> 
                  <td height="30px" align="center" valign="middle" width="10%"><strong>Patient Status</strong></td>
                  <td height="30px" align="center" valign="middle" width="10%"><strong>Patient Type</strong></td>	
                  <td height="30px" align="center" valign="middle" width="8%"><strong>Mobile No</strong></td>
                  <td height="30px" align="center" valign="middle" width="7%"><strong>Bill Number</strong></td>
                  <td height="30px" align="center" valign="middle" width="10%"><strong>Payment Date</strong></td>
				  <td height="30px" align="center" valign="middle" width="10%"><strong>Total Amount</strong></td>
                  <td height="30px" align="center" valign="middle" width="10%"><strong>Concession Amount</strong></td>
                  </tr>';
        if(count($getConcessions) > 0) {
          
        $totalAmount = 0;
        $cntConcessions = "";
        $concessionCnt=0;     
		
		foreach($getConcessions as $getConcessionsVal) {
			      
			      $registrationDate = date("d/m/Y", strtotime($this->DateFormat->formatDate2Local($getConcessionsVal['Patient']['form_received_on'],'yyyy/mm/dd', true)));
				  $paymentDate = date("d/m/Y", strtotime($this->DateFormat->formatDate2Local($getConcessionsVal['FinalBilling']['discharge_date'],'yyyy/mm/dd', true)));
                  $totalAmount += $getConcessionsVal['FinalBilling']['discount_rupees'];
                  $formatted_address = $this->requestAction("/patients/setAddressFormat",array('pass' => array($getConcessionsVal['Person'])));
				  if($getConcessionsVal['FinalBilling']['discount_rupees'] == "" || empty($getConcessionsVal['FinalBilling']['discount_rupees'])) {
					   continue;
				  }else {
					  $concessionCnt++;
				  }
				  if($getConcessionsVal['Patient']['admission_type'] == "IPD") {
			        if($getConcessionsVal['Patient']['is_discharge'] == 1) {  
						$patientstatus =  __('Discharged');
					} else {
						$patientstatus = __('Not Discharged');
					}
		           }
				   if($getConcessionsVal['Patient']['admission_type'] == "OPD") {
			        if($getConcessionsVal['Patient']['is_discharge'] == 1) {  
						$patientstatus = __('OP Process Completed');
					} else {
						$patientstatus = __('OP In-Progress');
					}
		           }
		  $html .= '<tr>';
		          $html .= '<td align="center" height="17px">'.$concessionCnt.'</td>';
				  $html .= '<td align="center" height="17px">'.$registrationDate.'</td>';
				  $html .= '<td align="center" height="17px">'.$getConcessionsVal["Patient"]["admission_id"].'</td>';
                  $html .= '<td align="center" height="17px">'.$getConcessionsVal["PatientInitial"]["name"].' '.$getConcessionsVal["Patient"]["lookup_name"].'</td>';
				  $html .= '<td align="center" height="17px">'.$patientstatus.'</td>';
                  $html .= '<td align="center" height="17px">'.$getConcessionsVal["Patient"]["admission_type"].'</td>';
                  $html .= '<td align="center" height="17px">'.$getConcessionsVal["Patient"]["mobile_phone"].'</td>';
                  $html .= '<td align="center" height="17px">'.$getConcessionsVal["FinalBilling"]["bill_number"].'</td>';
				  $html .= '<td align="center" height="17px">'.$paymentDate.'</td>';
				  $html .= '<td align="center" height="17px">'.$getConcessionsVal["FinalBilling"]["total_amount"].'</td>';
                  $html .= '<td align="center" height="17px">'.$getConcessionsVal["FinalBilling"]["discount_rupees"].'</td>';
                  $html .= '</tr>';
		}
                
        } else {
            $cntConcessions == "norecord";
			
        }
        if($concessionCnt == 0) {
			$html .= '<tr><td align="center" height="17px" colspan="11">No Record Found</td></tr>';
		}
        if($concessionCnt > 0) {
           $html .= '<tr>';
           $html .= '<td height="30px" align="right" valign="middle" width="90%" colspan="10"><strong>Total Amount</strong>&nbsp;&nbsp;</td>';
           $html .= '<td height="30px" align="center" valign="middle" width="10%"><strong>'.$totalAmount.'</strong></td>';
           $html .= '</tr>';
        }
       $html .= '</table>';
	
	
	// output the HTML content
	$tcpdf->writeHTML($html, true, false, true, false, '');
	 
	// reset pointer to the last page
	$tcpdf->lastPage(); 
	
	//Close and output PDF document
	echo $tcpdf->Output('Total_Concessions'.$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).'.pdf', 'D');
	
?>