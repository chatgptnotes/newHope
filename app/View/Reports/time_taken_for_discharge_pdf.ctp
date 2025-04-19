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
	  	$facilitynamewithreport = 'Time Taken For Discharge'.' - '.$reportYear;
	  	$facilityname = "";
	}
	else {
	    $headerString = "by ".$facilityname ;
		$facilitynamewithreport = $facilityname.'-Time Taken For Discharge'.' - '.$reportYear;
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
	$html ='<div style="margin-top:200px;">&nbsp;<span>Date: '.$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), false).'</span><br></div>
	   
		<table border="1" cellpadding="0" cellspacing="0" width="100%">				  
				<tr class="row_title" style="background-color:#A1B6BE;">
				   <td height="30px" align="center" valign="middle" width="5%"><strong>Sr.No.</strong></td>
				   <td height="30px" align="center" valign="middle" width="10%"><strong>Date of Reg.</strong></td>
				   <td height="30px" align="center" valign="middle" width="15%"><strong>MRN</strong></td>					  
				   <td height="30px" align="center" valign="middle" width="20%"><strong>Name</strong></td>  
				   <td height="30px" align="center" valign="middle" width="10%"><strong>Age</strong></td>
				   <td height="30px" align="center" valign="middle" width="10%"><strong>Sex</strong></td>
				   <td height="30px" align="center" valign="middle" width="15%"><strong>Discharge Date</strong></td>
				   <td height="30px" align="center" valign="middle" width="15%"><strong>Discharge Time</strong></td>
			  			  
				 </tr>';
			
			if(!empty($record[0])) {
			   $k = 1; 
			
	      		foreach($record as $patient){
					$html .= '<tr>				
					            <td align="center" height="17px">'.$k.'</td>	
								<td align="center" height="17px">'.date("d/m/Y", strtotime($this->DateFormat->formatDate2Local($patient['Patient']['form_received_on'],'yyyy/mm/dd',true))).'</td>	
								<td align="center" height="17px">'.$patient['Patient']['admission_id'].'</td>					   
								<td align="center" height="17px">'.$patient['PatientInitial']['name'].' '.$patient['Patient']['lookup_name'].'</td>
								<td align="center" height="17px">'.$patient['Person']['age'].'</td>  
								<td align="center" height="17px">'.ucfirst($patient['Person']['sex']).'</td>';
								
							$splitDate = explode(' ',$patient['DischargeSummary']['review_on']);
					$html .= '<td align="center" height="17px">'.$this->DateFormat->formatDate2Local($patient['DischargeSummary']['review_on'],Configure::read('date_format'),true).'</td>';
					
						$totalDischarge = abs(strtotime($patient['FinalBilling']['discharge_date'])-strtotime($patient['DischargeSummary']['review_on']));			
						$totalDischargeTime = round($totalDischarge/60,2);
								//BOF pankaj
							$datetime1 = new DateTime($patient['FinalBilling']['discharge_date']);
							$datetime2 = new DateTime($patient['DischargeSummary']['review_on']);
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
							
							$finalTime =  $timeDay." days ".$timeHr." hours ".$timeMin." minutes ".$timeSec." seconds " ;//EOF pankaj
					$html .= '<td align="center" height="17px">'.$finalTime.'</td>';
					$html .= '</tr>';
				}				
				//BOF avg
			 $finalremTime =  $finalremTime /(int)count($record) ; 
			//BOF 
				$days = (int) ($finalremTime/86400);
				$finalremTime = $finalremTime-($days*86400);
				$hours = (int)($finalremTime/3600);
				$finalremTime = $finalremTime-($hours*3600);
				$minutes = (int)($finalremTime/60);
				$finalremTime =(int) $finalremTime-($minutes*60);
			//EOF			
			$avgtime = ($days>0)?$days."Days ":"0 Days " ;
			$avgtime .= ($hours>0)?$hours."hrs ":"0 Hrs " ; 
			$avgtime .= ($minutes>0)?$minutes."Minutes ":"0 Minutes " ;  	
			$avgtime .= ($finalremTime>0)?$finalremTime."Sec ":"0 sec " ;
				//EOF avg
							
				$html .= '<tr> 
							<td height="30px" align="center" valign="bottom" colspan="8"><strong>Total Patients:'.count($record).'</strong></td>							
						</tr> 
						<tr> 
							<td height="30px" align="center" valign="bottom" colspan="8"><strong>Average Time Taken For Each Patient : '.$avgtime.' Min.</strong></td>					 		
						</tr>';
		    } else {
				$html .= '<tr> 
							<td height="30px" align="center" valign="bottom" colspan="8"><strong>No Record Found!</strong></td>							
						</tr>'; 
			}	
			$html .= '</table>';
	//pr($html);exit;
	// output the HTML content
	$tcpdf->writeHTML($html, true, false, true, false, '');
	 
	// reset pointer to the last page
	$tcpdf->lastPage(); 
	
	//Close and output PDF document
	//echo $tcpdf->Output('Time_taken_Discharge'.date('d-m-Y h:i:s').'.pdf', 'D');
	echo $tcpdf->Output('Time_Taken_For_Discharge'.$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).'.pdf', 'D');
	
?>