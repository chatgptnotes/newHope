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
	  	$facilitynamewithreport = 'Total Registration Report'; 
	  	$facilityname = "";
	}
	else {
	    $headerString = "by ".$facilityname ;
		$facilitynamewithreport = $facilityname.'-Total Registration Report'; 
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

	/*$getField = explode('|',$fieldName);
	unset($getField[array_pop(array_keys($getField))]);
	$count = count($getField);	*/
	$k = 0;
    $treatment_type =  array('4' => 'First Consultation','5' => 'Follow-Up Consultation', '6' => 'Preventive Health Check-up', '7' => 'Vaccination', '8' => 'Pre-Employment Check-up', '9' => 'Pre Policy Check up');
	$html ='<div style="margin-top:200px;">&nbsp;<span>Date: '.$this->DateFormat->formatDate2Local(date('Y-m-d'),Configure::read('date_format'), false).'</span><br><br></div>
			<table border="1" class="table_format"  cellpadding="2" cellspacing="0" width="100%" style="text-align:left;padding-top:50px;">				  
				  <tr class="row_title" style="background-color:#A1B6BE;">
				       <td height="30px" align="center" valign="middle" width="5%"><strong>'. __("Sr.No."). '</strong></td>
					    <td height="30px" align="center" valign="middle" width="10%"><strong>'. __("Date Of Reg."). '</strong></td>
					   <td height="30px" align="center" valign="middle" width="15%"><strong>'. __("MRN"). '</strong></td>
					   <td height="30px" align="center" valign="middle" width="10%"><strong>'. __("Patient ID"). '</strong></td>
					   <td height="30px" align="center" valign="middle" width="10%"><strong>'. __("Patient Name"). '</strong></td>  
					   <td height="30px" align="center" valign="middle" width="5%"><strong>'. __("Age"). '</strong></td>
					   <td height="30px" align="center" valign="middle" width="10%"><strong>'. __("Sex"). '</strong></td>
					   <td height="30px" align="center" valign="middle" width="5%"><strong>'. __("Blood Group"). '</strong></td>
					   <td height="30px" align="center" valign="middle" width="10%"><strong>'. __("Patient Type"). '</strong></td>
					   <td height="30px" align="center" valign="middle" width="10%"><strong>'. __("Location"). '</strong></td>
                       <td height="30px" align="center" valign="middle" width="10%"><strong>'. __("Doctor"). '</strong></td>'; 
                
		 	
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
					$html .= '<tr>
					                <td align="center" height="17px">'.$k.'</td> 
									<td align="center" height="17px">'.$this->DateFormat->formatDate2Local($patient['form_received_on'],Configure::read('date_format')).'</td>
									<td align="center" height="17px">'.$patient['admission_id'].'</td>  
								    <td align="center" height="17px">'.$patient['patient_id'].'</td>	   
								    <td align="center" height="17px">'.$pdfData['PatientInitial']['name'].' '.$patient['lookup_name'].'</td>
								    <td align="center" height="17px">'.$person['age'].'</td>  
								    <td align="center" height="17px">'.ucfirst($person['sex']).'</td>
								    <td align="center" height="17px">'.$person['blood_group'].'</td>';
									if($patient['is_emergency'] == 1 AND $patient['admission_type'] == 'IPD'){									
										$html .= '<td align="center" height="17px">'.__('Emergency').'</td>';
									} else {
										$html .= '<td align="center" height="17px">'.$patient['admission_type'].'</td>';
									}

									$html.='
									<td align="center" height="17px">'.$person['city'].'</td>
                                    <td align="center" height="17px">'.$pdfData[0]['doctor_name'].'</td>
							</tr>' ;
										 
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
	echo $tcpdf->Output('Total_Registration_Report'.$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).'.pdf', 'D');
	
?>