<?php
	
	App::import('Vendor','tcpdf/config/lang/eng'); 
	App::import('Vendor','tcpdf/tcpdf');
	$facilityname = ucfirst($this->Session->read("facility"));
	$headerimage = $this->Session->read("header_image");
	$facilitynamewithreport;
	
	if(empty($facilityname)) {
	  	$facilitynamewithreport = 'Private Receivable'; 
	  	$facilityname = "";
	}
	else {
	    $headerString = "by ".$facilityname ;
		$facilitynamewithreport = $facilityname.'-Private Receivable'; 
	}
	$tcpdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	// set document information
	$tcpdf->SetCreator(PDF_CREATOR);
	$tcpdf->SetAuthor($facilityname);
	$tcpdf->SetTitle($facilitynamewithreport);
	$tcpdf->SetSubject('Report');
	//$tcpdf->SetKeywords('TCPDF, PDF, example, test, guide');
	 
	// set default header data
	$tcpdf->SetHeaderData($headerimage, PDF_HEADER_LOGO_WIDTH, $facilitynamewithreport, $headerString, date('d/m/Y'));
	
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

	 
	$html ='<div style="margin-top:200px;">&nbsp;<span>Date: '.date('d/m/Y').'</span><br></div>';
        // get billing cash //
        $html .= '<br /><table border="1" cellpadding="0" cellspacing="0" width="100%">';
        $html .= '<tr><td colspan="10" align="center"><h3>Billing</h3></td></tr>';
          $html .= '<tr class="row_title" style="background-color:#A1B6BE;">
          <td height="30px" align="center" valign="middle" width="5%"><strong>Sr.No.</strong></td>
          <td height="30px" align="center" valign="middle" width="10%"><strong>Date</strong></td>
          <td height="30px" align="center" valign="middle" width="10%"><strong>MRN</strong></td> 
		  <td height="30px" align="center" valign="middle" width="10%"><strong>Patient Name</strong></td>					  
		  <td height="30px" align="center" valign="middle" width="10%"><strong>Patient Type</strong></td> 
		  <td height="30px" align="center" valign="middle" width="10%"><strong>Mobile No</strong></td>
		  <td height="30px" align="center" valign="middle" width="15%"><strong>Address</strong></td>
		  <td height="30px" align="center" valign="middle" width="10%"><strong>Total Amount</strong></td>
		  <td height="30px" align="center" valign="middle" width="10%"><strong>Paid</strong></td>
          <td height="30px" align="center" valign="middle" width="10%"><strong>Balance</strong></td>
		 </tr>';
           $from = strtotime($this->DateFormat->formatDate2STD($this->request->data['from'],Configure::read('date_format'))) ;
           $to =   strtotime($this->DateFormat->formatDate2STD($this->request->data['to'],Configure::read('date_format'))) ;
         
        if(count($getBillingPending) > 0) {  $dateshow = "";
               	$totalAmount = array();
 				$paidSum= array();
	         	  
				foreach($getBillingPending as $getBillingPendingVal) {
				   $dateExp = explode(" ", date("d/m/Y H:i:s", strtotime($getBillingPendingVal['Billing']['date']))); 
		           //display only record those are comes under selected date range 
	               $perDayTime  = strtotime($this->DateFormat->formatDate2STD($dateExp[0],Configure::read('date_format')));
	               
	               
	               $tillPaid 		=  array_sum($paidSum[$getBillingPendingVal['Patient']['id']]) ;
	               $totalAmt  		=  $patientCharges[$getBillingPendingVal['Patient']['id']]['charges']-$tillPaid; 
	               
	               $paidAmt  		=  $getBillingPendingVal[0]['amount'];
	               $paidSum[$getBillingPendingVal['Patient']['id']][] = $paidAmt ;
	               
	              
	               if($perDayTime >= $from && $perDayTime <= $to) {
	               	  
	               	    $billingCnt++;   
		               $totalPaid 		+=  $paidAmt ;
		               $pendingAmt 		=  $totalAmt - $paidAmt ; 
		               
		               //$totalAmount[$getBillingPendingVal['Patient']['id']]= $patientCharges[$getBillingPendingVal['Patient']['id']]['charges'];
		               if(!(array_key_exists($getBillingPendingVal['Patient']['id'],$totalAmount))){
		               		$totalAmount[$getBillingPendingVal['Patient']['id']]= $totalAmt;
		               }
		               $totalBalance[$getBillingPendingVal['Patient']['id']]= $pendingAmt;
					   
	                   
			  		   $html .= '<tr>';
			           $html .= '<td align="center" height="17px">'.$billingCnt.'</td>';
			           $html .= '<td align="center" height="17px">'.$dateExp[0].'</td>';
	                   $html .= '<td align="center" height="17px">'.$getBillingPendingVal['Patient']['admission_id'].'</td>';
	                   $html .= '<td align="center" height="17px">'.$getBillingPendingVal['PatientInitial']['name'].' '.$getBillingPendingVal['Patient']['lookup_name'].'</td>';
	                   $html .= '<td align="center" height="17px">'.$getBillingPendingVal['Patient']['admission_type'].'</td>';
	                   $html .= '<td align="center" height="17px">'.$getBillingPendingVal['Patient']['mobile_phone'].'</td>';
	                   $html .= '<td align="center" height="17px">'.$patientCharges[$getBillingPendingVal['Patient']['id']]['address'].'</td>';
	                   $html .= '<td align="center" height="17px">'.$totalAmt.'</td>';
	                   $html .= '<td align="center" height="17px">'.$paidAmt.'</td>';
	                   $html .= '<td align="center" height="17px">'.$pendingAmt.'</td>';
	                   $html .= '</tr>'; 
	                   $billingDaysTotal += $pendingAmt;
	               	   if($dateshow != $dateExp[0] ) {
		                 	$html .= '<tr>			
		                           <td align="right" valign="middle" height="17px" colspan="7"><strong>Total Pending</strong></td>
		                           <td align="center" valign="middle" height="17px" >&nbsp;</td>
		                           <td align="center" valign="middle" height="17px" >&nbsp;</td>		
			                       <td align="center" valign="middle" height="17px" >'.$billingDaysTotal.'</td>
		                           </tr>';
		                 	$billingDaysTotal = 0;
	                   }
	               }
	               $dateshow = $dateExp[0]; 
	                         
				 }		  
                
        } else {
            $cntBilling = "norecord";
			$html .= '<tr class="row_title" >
          <td colspan="10" align="center">No record found</td>
          </tr>';
        }
		  
        
        if($cntBilling != 'norecord') {
           $total  =array_sum($totalAmount) ;
          
           $totalBalance  = array_sum($totalBalance);
		   $html .= '<tr><td height="30px" align="right" valign="middle" colspan="7"  ><strong>Total </strong>&nbsp;&nbsp;</td>';
           $html .= '<td height="30px" align="center" valign="middle"   ><strong>'.$total.'</strong></td>';
           $html .= '<td height="30px" align="center" valign="middle"  ><strong>'.$totalPaid.'</strong></td>';
           $html .= '<td height="30px" align="center" valign="middle"  ><strong>'.$totalBalance.'</strong></td></tr>';
        }
        
	    $html .= '</table>';
 	
	// output the HTML content
	$tcpdf->writeHTML($html, true, false, true, false, '');
	 
	// reset pointer to the last page
	$tcpdf->lastPage(); 
	  
	//Close and output PDF document
	echo $tcpdf->Output('Payment_Receivable-'.$this->DateFormat->formatDate2Local(date('d-m-Y H:i:s'),Configure::read('date_format'),true).'.pdf', 'D');
	
?>