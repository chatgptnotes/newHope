<?php
	 ob_end_clean();
	//App::import('Vendor','xtcpdf'); 
	//$tcpdf = new XTCPDF();	
	//ob_clean();
	App::import('Vendor','tcpdf/config/lang/eng'); 
	App::import('Vendor','tcpdf/tcpdf');
	
	$facilityname = ucfirst($hospitalname['Facility']['name']);
	$headerimage = $this->Session->read("header_image");
	$facilitynamewithreport;
	
	if(empty($facilityname)) {
	  	$facilitynamewithreport = 'Invoice'; 
	  	$facilityname = "";
	}
	else {
		$facilitynamewithreport = $facilityname.'-Invoice'; 
	}

	
	$tcpdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	// set document information
	$tcpdf->SetCreator(PDF_CREATOR);
	$tcpdf->SetAuthor($facilityname);
	$tcpdf->SetTitle($facilitynamewithreport);
	$tcpdf->SetSubject('Report');
	//$tcpdf->SetKeywords('TCPDF, PDF, example, test, guide');
	 
	// set default header data
	//$tcpdf->SetHeaderData($headerimage, PDF_HEADER_LOGO_WIDTH, $facilitynamewithreport, 'by'. $facilityname, $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true));
	 
	// set header and footer fonts
	$tcpdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$tcpdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
	
	// set default monospaced font
	$tcpdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
	
	//set margins
	//$tcpdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	//$tcpdf->SetHeaderMargin(PDF_MARGIN_HEADER);
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

	/*$getField = explode('|',$fieldName);
	unset($getField[array_pop(array_keys($getField))]);
	$count = count($getField);	*/
	$k = 0;
    $treatment_type =  array('4' => 'First Consultation','5' => 'Follow-Up Consultation', '6' => 'Preventive Health Check-up', '7' => 'Vaccination', '8' => 'Pre-Employment Check-up', '9' => 'Pre Policy Check up');
    $totalAmount1 = ($getIpdRaterecord*$getHospitalRate['HospitalRate']['ipd_rate']);
    $totalAmount2 = ($getOpdRaterecord*$getHospitalRate['HospitalRate']['opd_rate']);
    $totalAmount3 = ($getEmergencyRaterecord*$getHospitalRate['HospitalRate']['emergency_rate']);
    $totalNetAmount = ($totalAmount1+$totalAmount2+$totalAmount3);
    //$html ='<div style="margin-top:200px;"><strong>Location</strong>:'.$locationName.'</strong><br />'.$showFromDate.'&nbsp;&nbsp;To&nbsp;&nbsp;'.$showToDate.'<br /><br /></div>';
    $html ='<div style="margin-top:200px;text-align:center"><h3>'.$facilityname.' '. __("Hospital Invoice"). '</h3></div>'; 
     
	$html .='<table border="1" class="table_format"  cellpadding="2" cellspacing="0" width="100%" style="text-align:left;padding-top:50px;">				  
				  <tr class="row_title">
				       <td height="30px" align="center" valign="middle" width="20%"><strong>'. __("Category"). '</strong></td>
					   <td height="30px" align="center" valign="middle" width="20%"><strong>'. __("Total MRN"). '</strong></td>
					   <td height="30px" align="center" valign="middle" width="20%"><strong>'. __("Rate"). '</strong></td>
					   <td height="30px" align="center" valign="middle" width="40%"><strong>'. __("Total Amount"). '</strong></td>'; 
      	$html .='</tr>';  
      	$html .= "<tr>
					                <td align='center' height='17px'>".__("IPD")."</td>  
								    <td align='center' height='17px'>".$getIpdRaterecord."</td>
								    <td align='center' height='17px'>".$getHospitalRate['HospitalRate']['ipd_rate']."</td>
								    <td align='center' height='17px'>".$totalAmount1."</td></tr>";
      	$html .= "<tr>
					                <td align='center' height='17px'>".__("OPD")."</td>  
								    <td align='center' height='17px'>".$getOpdRaterecord."</td>
								    <td align='center' height='17px'>".$getHospitalRate['HospitalRate']['opd_rate']."</td>
								    <td align='center' height='17px'>".$totalAmount2."</td></tr>";
      	$html .= "<tr>
					                <td align='center' height='17px'>".__("Emergency")."</td>  
								    <td align='center' height='17px'>".$getEmergencyRaterecord."</td>
								    <td align='center' height='17px'>".$getHospitalRate['HospitalRate']['emergency_rate']."</td>
								    <td align='center' height='17px'>".$totalAmount3."</td></tr>";
      	 $html .=' <tr>
							 
							<td height="15px" align="right" valign="bottom" colspan="3"><strong>Total Amount:</strong></td>											
							<td height="15px" align="left" valign="bottom" >'.$totalNetAmount.'</td>
						</tr>';
      	$html .='</table><br />'; 
      	 
		$html .=	'<table border="1" class="table_format"  cellpadding="2" cellspacing="0" width="100%" style="text-align:left;padding-top:50px;">				  
				  <tr class="row_title">
				       <td height="30px" align="center" valign="middle" width="12%"><strong>'. __("MRN"). '</strong></td>
					   <td height="30px" align="center" valign="middle" width="10%"><strong>'. __("Patient ID"). '</strong></td>
					   <td height="30px" align="center" valign="middle" width="9%"><strong>'. __("Date Of Reg."). '</strong></td>
					   <td height="30px" align="center" valign="middle" width="12%"><strong>'. __("Patient Name"). '</strong></td>  
					   <td height="30px" align="center" valign="middle" width="8%"><strong>'. __("Age"). '</strong></td>
					   <td height="30px" align="center" valign="middle" width="8%"><strong>'. __("Sex"). '</strong></td>
					   <td height="30px" align="center" valign="middle" width="8%"><strong>'. __("Blood Group"). '</strong></td>
					   <td height="30px" align="center" valign="middle" width="8%"><strong>'. __("Patient Type"). '</strong></td>
					   <td height="30px" align="center" valign="middle" width="8%"><strong>'. __("City/Town"). '</strong></td>
                       <td height="30px" align="center" valign="middle" width="8%"><strong>'. __("Specilty"). '</strong></td>
					   <td height="30px" align="center" valign="middle" width="9%"><strong>'. __("Doctor"). '</strong></td>'; 
                
		 	
		$html .='</tr>';  
	  	 $toggle =0;
	
	      if(count($reports[0]) > 0) {
			   $k = 1; 
	      		foreach($reports as $pdfData){	
	      			 
					$patient = $pdfData['Patient'];
					$person = $pdfData['Person'];
					$doctor = $pdfData['DoctorProfile'];
                                        if(isset($pdfData['FinalBilling'])){ 
						$finalBillingPart = $pdfData['FinalBilling'];
					}
                                        // if you select fields of finalbilling table //
                                        $finalBillingFields = array('bill_number', 'total_amount', 'amount_paid', 'discount_rupees', 'amount_pending');
					$html .= "<tr>
					                <td align='center' height='17px'>".$patient['admission_id']."</td>  
								    <td align='center' height='17px'>".$patient['patient_id']."</td>	   
								    <td align='center' height='17px'>".$this->DateFormat->formatDate2Local($patient['form_received_on'],Configure::read('date_format'))."</td>
								    <td align='center' height='17px'>".$getInitialname[$person['initial_id']].' '.$patient['lookup_name']."</td>
								    <td align='center' height='17px'>".$person['age']."</td>  
								    <td align='center' height='17px'>".ucfirst($person['sex'])."</td>
								    <td align='center' height='17px'>".$person['blood_group']."</td>";
									if($patient['is_emergency'] == 1 AND $patient['admission_type'] == 'IPD'){									
										$html .= "<td align='center' height='17px'>".__('Emergency')."</td>";
									} else {
										$html .= "<td align='center' height='17px'>".$patient['admission_type']."</td>";
									}

									$html.="
									<td align='center' height='17px'>".$person['city']."</td>
                                    <td align='center' height='17px'>".$pdfData['Department']['deptname']."</td>
								    <td align='center' height='17px'>".$pdfData[0]['doctor_name']."</td>
							</tr>" ;
										 
					/*$i = 0;
					for($i = 0; $i<$count; $i++){
						if($getField[$i] != ''){
							// Get the location name in stead ot id
							if($getField[$i] == 'location_id'){
								$facility_id = ClassRegistry::init('Location')->field('facility_id,',array('Location.id'=>$pdfData['Person'][$getField[$i]]));
								$facility_name = ClassRegistry::init('Facility')->field('name',array('Facility.id'=>$facility_id));
								$location_name = ClassRegistry::init('Location')->field('name',array('Location.id'=>$pdfData['Person'][$getField[$i]]));
	
								$html .= '<td height="30px" align="center" valign="middle">'.$facility_name.', '.$location_name.'</td>';
							}else {
								$html .= '<td height="30px" align="center" valign="middle">'.$pdfData['Person'][$getField[$i]].'</td>';
							}
						}
					}	*/						
					
					 
				 $k++; 
			   }

			   $html .=' <tr>
							 
							<td height="30px" align="center" valign="bottom" colspan="11"><strong>Total Patients: '.(count($reports)).'</strong></td>											
							
						</tr>';
						  
				 } else {
					$html .=  '<tr>
									<td align="center" width="100%" height="17px" colspan="11">No Record Found</td>
									
								</tr>';

				 }
					   		  
		$html .= '</table>' ;
		
		//pr($html);exit;
//pr($html);exit;
	
	// output the HTML content
	$tcpdf->writeHTML($html, true, false, true, false, 'middle');
	 
	// reset pointer to the last page
	$tcpdf->lastPage(); 
	
	//Close and output PDF document
	echo $tcpdf->Output('Hospital_Invoices_'.$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).'.pdf', 'D');
	
?>