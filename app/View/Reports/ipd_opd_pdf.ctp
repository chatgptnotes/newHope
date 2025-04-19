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
	  	$facilitynamewithreport = 'Time Taken for Admissions Report'; 
	  	$facilityname = "";
	}
	else {
	    $headerString = "by ".$facilityname ;
		$facilitynamewithreport = $facilityname.'-Time Taken for Admissions Report'; 
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

	
	$html ='<div style="margin-top:200px;">&nbsp;<span>Date: '.$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), false).'</span><br></div>
	   
		<table border="1" class="table_format"  cellpadding="0" cellspacing="0" width="100%" style="text-align:center;padding-top:50px;">				  
				  <tr class="row_title" style="background-color:#A1B6BE;"> 
				   <td height="30px" align="center" valign="middle"><strong>Sr.No.</strong></td>
				   <td height="30px" align="center" valign="middle"><strong>Date of Reg.</strong></td>
				   <td height="30px" align="center" valign="middle"><strong>MRN</strong></td>
				   <td height="30px" align="center" valign="middle"><strong>Patient Name</strong></td>		    
				   <td height="30px" align="center" valign="middle"><strong>Patient Type</strong></td>
				   <td height="30px" align="center" valign="middle"><strong>Com/Pvt</strong></td>
				   <td height="30px" align="center" valign="middle"><strong>Form Received</strong></td>
				   <td height="30px" align="center" valign="middle"><strong>Reg Completed Time</strong></td>
				   <td height="30px" align="center" valign="middle"><strong>Time Taken For Reg</strong></td>
			<!--   <td height="30px" align="center" valign="middle"><strong>Doctor Attend Time</strong></td>
				   <td height="30px" align="center" valign="middle"><strong>Start of Nursing Assessment</strong></td>
				   <td height="30px" align="center" valign="middle"><strong>End of Nursing Assessment</strong></td> -->';
				   
			
			$html .='</tr>';
				  	  $toggle =0;
				      if(count($reports) > 0) {
						   $i = 1;
						   $finalWaitingTime ='';
						   $finalremTime ='';
						   $timeCount =0 ;
				      		foreach($reports as $pdfData){	
								$excelDataChanged= $pdfData['Patient'];	
								
							 
								$waiting_time ='';
								$finalTime='';
								$timeTaken ='';
				      		if(!empty($excelDataChanged['form_completed_on']) && !empty($excelDataChanged['form_received_on'])){
							 		//$timeTaken = strtotime($excelDataChanged['create_time'])-strtotime($excelDataChanged['form_received_on']) ;
				 					$datetime1 = new DateTime($excelDataChanged['form_completed_on']);
									$datetime2 = new DateTime($excelDataChanged['form_received_on']);
									$interval = $datetime1->diff($datetime2);
									//EOF cal
									$timeDay 	= $interval->days;
									$timeDaySec = $timeDay*3600*24;
									$timeHr 	= $interval->h;
									$timeHrSec 	= $timeHr*3600;
									$timeMin 	= $interval->i;
									$timeMinSec = $timeMin*60;
									$timeSecSec	= $interval->s ;
									$timeSec 	= $interval->s;
									
								 	$finalremTime +=  (int)$timeDaySec+(int)$timeHrSec+(int)$timeMinSec+(int)$timeSecSec;
									$finalTime =  $timeDay." days ".$timeHr." hours ".$timeMin." minutes ".$timeSec." seconds " ;
				  					$timeCount++ ;
							} 
							 		
							if(!empty($excelDataChanged['doc_ini_assess_on']) && !empty($excelDataChanged['form_received_on'])){
						   		 	//$waiting_time = strtotime($excelDataChanged['doc_ini_assess_on']) - strtotime($excelDataChanged['create_time'])  ;
						   		 	$datetime1 = new DateTime($excelDataChanged['doc_ini_assess_on']);
									$datetime2 = new DateTime($excelDataChanged['form_received_on']);
									$interval = $datetime1->diff($datetime2);						
									//EOF cal
									$timeDay = $interval->days." day ";
									$timeHr = $interval->h." hr ";
									$timeMin = $interval->i." min ";
									$timeSec = $interval->s." sec ";
									$waiting_time =  $timeDay." ".$timeHr." ".$timeMin." ".$timeSec ;
							}
							 
							$corporate ='';
				   			if($excelDataChanged['credit_type_id']==1) $corporate = 'Corporate';
							else if ($excelDataChanged['credit_type_id']==2) $corporate= 'Insurance';
                                    $doc_ini_assess_on = isset($excelDataChanged['doc_ini_assess_on'])?$this->DateFormat->formatDate2Local($excelDataChanged['doc_ini_assess_on'],Configure::read('date_format'),true):'';
                     				$nurse_assess_on =  isset($excelDataChanged['nurse_assess_on'])?$this->DateFormat->formatDate2Local($excelDataChanged['nurse_assess_on'],Configure::read('date_format')):"";
                     				$nurse_assess_end_on =  isset($excelDataChanged['nurse_assess_end_on'])?$this->DateFormat->formatDate2Local($excelDataChanged['nurse_assess_end_on'],Configure::read('date_format')):"";
				 
							$html .= '<tr> 
							            <td align="center" height="17px">'.$i .'</td>
									    <td align="center" height="17px">'.$this->DateFormat->formatDate2Local($excelDataChanged['form_received_on'],Configure::read('date_format')).'</td>	   
									    <td align="center" height="17px">'.$excelDataChanged['admission_id'].'</td>
										 <td align="center" height="17px">'.$pdfData['PatientInitial']['name'].' '.$excelDataChanged['lookup_name'].'</td>
									   	<td align="center" height="17px">'.$excelDataChanged['admission_type'].'</td>
									   	<td align="center" height="17px">'.$pdfData['TariffStandard']['name'] .'</td>
									    <td align="center" height="17px">'.$this->DateFormat->formatDate2Local($excelDataChanged["form_received_on"] ,Configure::read('date_format'),true).'</td>	   	
	   									<td align="center" height="17px">'.$this->DateFormat->formatDate2Local($excelDataChanged["create_time"] ,Configure::read('date_format'),true).'</td>
									   	<td align="center" height="17px">'.$finalTime.'</td>	   	
								<!--   	<td align="center" height="17px">'.$doc_ini_assess_on.'</td>
									   	<td align="center" height="17px">'.$nurse_assess_on.'</td>
									   	<td align="center" height="17px">'.$nurse_assess_end_on.'</td> -->
									   	
									 </tr>';
							 $i++; 
						   }
						  
					 } else {
						$html .= '<tr>
								<td colspan = "12" align="center" height="30px">No Record Found For the Selection!</td>
						</tr>';
					 }
					   $finalremTime =  $finalremTime /$timeCount ; 
						//BOF 
							$days = (int) ($finalremTime/86400);
							$finalremTime = $finalremTime-($days*86400);
							$hours = (int)($finalremTime/3600);
							$finalremTime = $finalremTime-($hours*3600);
							$minutes = (int)($finalremTime/60);
							$finalremTime =(int) $finalremTime-($minutes*60);
						//EOF			
						$avgtime = ($days>0)?$days."Days ":"0 Days " ;
						$avgtime .= ($hours>0)?$hours."Hrs ":"0 Hrs " ; 
						$avgtime .= ($minutes>0)?$minutes."Minutes ":"0 Minutes " ;  	
						$avgtime .= ($finalremTime>0)?$finalremTime."Sec ":"0 sec " ;
			
					 $html .=' <tr>
								<td height="30px" align="center" valign="middle" colspan="12"><strong>Average Time Taken for Admissions</strong>: '.$avgtime.'</td>					
							</tr>';
					   		  
		  $html .= '</table>' ; 

	
	// output the HTML content
	$tcpdf->writeHTML($html, true, false, true, false, '');
	 
	// reset pointer to the last page
	$tcpdf->lastPage(); 
	
	//Close and output PDF document
	echo $tcpdf->Output('Time-Taken-For-Admission'.$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).'.pdf', 'D');
	
?>