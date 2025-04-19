<?php
	
	//App::import('Vendor','xtcpdf'); 
	//$tcpdf = new XTCPDF();	
	//ob_clean();
	App::import('Vendor','tcpdf/config/lang/eng'); 
	App::import('Vendor','tcpdf/tcpdf');
	
	$headerimage = $this->Session->read("header_image");

	$tcpdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	// set document information
	$tcpdf->SetCreator(PDF_CREATOR);
	
	$tcpdf->SetSubject('Report');
	//$tcpdf->SetKeywords('TCPDF, PDF, example, test, guide');
	 
	// set default header data
	$tcpdf->SetHeaderData($headerimage, PDF_HEADER_LOGO_WIDTH, $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true));
	
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
	$html .='<table border="1" class="table_format" cellpadding="0" cellspacing="0" width="100%" style="text-align:left;">
				<tr>
					<td valign="top" colspan="13" style="text-align:center;" align="center"><h2>Nurse Outstanding Report</h2></td>';
	$html .='</tr></table>';
	
	$html .='<table border="1" class="table_format" cellpadding="0" cellspacing="0" width="100%" style="text-align:left;">	
				<tr> 
					<td width="10%" align="center" valign="top" style="text-align: left;"><strong>Ward/Bed No</strong></td> 
					<td width="10%" align="center" valign="top" style="text-align: center;"><strong>Patient ID</strong></td> 
					<td width="10%" align="center" valign="top" style="text-align: center;"><strong>Patient Name</strong></td> 
					<td width="5%" align="center" valign="top" style="text-align: center;"><strong>Patient Type</strong></td> 
					<td width="5%" align="center" valign="top" style="text-align: center;"><strong>Mobile No</strong></td>
					<td width="8%" align="center" valign="top" style="text-align: center;"><strong>Consultant</strong></td>
					<td width="6%" align="center" valign="top" style="text-align: center;"><strong>Admission Date</strong></td>
					<td width="8%" align="center" valign="top" style="text-align: center;"><strong>Bill Amount</strong></td>
					<td width="6%" align="center" valign="top" style="text-align: center;"><strong>Discount Amount</strong></td>
					<td width="8%" align="center" valign="top" style="text-align: center;"><strong>Amount Paid</strong></td>
					<td width="8%" align="center" valign="top" style="text-align: center;"><strong>Amount Due</strong></td>
					<td width="8%" align="center" valign="top" style="text-align: center;"><strong>Pay Card</strong></td>
					<td width="8%" align="center" valign="top" style="text-align: center;"><strong>Pay Amount</strong></td>';
		$html .='</tr>';  
		
		$totalSurgeryAmount = '';
		$cardiologist='';
		$asstSurgeonTwoCharge='';
		$asstSurgeonOneCharge='';
		$anaesthesiaCost='';
			
		foreach($surgeryDetails as $key => $surgeryData){
			foreach($surgeryData as $key => $surgery){
				if($surgery['start'] !='' && is_array($surgery)) {
		
					$anaesthesiaCost = ($surgery['anaesthesist'] != '') ? $surgery['anaesthesist_cost'] : 0;
					$asstSurgeonOneCharge = ($surgery['asst_surgeon_one'] != '') ? $surgery['asst_surgeon_one_charge'] : 0;
					$asstSurgeonTwoCharge = ($surgery['asst_surgeon_two'] != '') ? $surgery['asst_surgeon_two_charge'] : 0;
					$cardiologist = ($surgery['cardiologist'] != '') ? $surgery['cardiologist_charge'] : 0;
					$totalSurgeryAmount[$surgeryData['patient_id']][] = $surgery['cost'] + $anaesthesiaCost + $surgery['ot_charges'] + $surgery['surgeon_cost'] + $asstSurgeonOneCharge +
					$asstSurgeonTwoCharge + $cardiologist + $surgery['ot_assistant'] + $surgery['extra_hour_charge'] + array_sum($surgery['ot_extra_services']) ;
				}
			}
		}
			
		foreach ($patientDetails as $key=> $data){
			$patientTotal='';
			if(is_array($totalSurgeryAmount[$data['Patient']['id']])){
				$patientTotal = array_sum($totalSurgeryAmount[$data['Patient']['id']]);
			}
			$finalTotalAmount = round(array_sum($totalSurgeryAmount[$data['Patient']['id']])+$data['total_amount']);
			$amountDue = round($finalTotalAmount-($data['amount_paid']+$data['amount_discount']));
			$payAmount = round($amountDue - $data['card_balance']);
				
			if($payAmount>'0'){
				$bgclass='pending_payment';
			}else{
				$bgclass='';
			}
		    	$html .= '<tr>
		    				<td class ='.$bgclass.' align="left" valign="top" style= "text-align: left;">'.$data['Ward']['name'].'/'.$data['Room']['bed_prefix'].$data['Bed']['bedno'].'</td>
							<td class ='.$bgclass.' align="left" valign="top" style= "text-align: left;">'.$data['Patient']['patient_id'].'</td>
							<td class ='.$bgclass.' align="left" valign="top" style= "text-align: left;">'.$data['Patient']['lookup_name'].'</td>
							<td class ='.$bgclass.' align="left" valign="top" style= "text-align: left;">'.$data['TariffStandard']['name'].'</td>
							<td class ='.$bgclass.' align="left" valign="top" style= "text-align: left;">'.$data['Person']['mobile'].'</td>
							<td class ='.$bgclass.' align="left" valign="top" style= "text-align: left;">'.$data['DoctorProfile']['doctor_name'].'</td>
							<td class ='.$bgclass.' align="left" valign="top" style= "text-align: left;">';
		    					$date = $data['Patient']['form_received_on']=$this->DateFormat->formatDate2Local($data['Patient']['form_received_on'],
		    							Configure::read('date_format'),false);
									$html.=$date;
				$html .= '</td><td class ='.$bgclass.' style= "text-align: center;">';
		    					$html.= round($finalTotalAmount);
		    							$totalRevenue +=  (double) round($finalTotalAmount); 
		    							
		    	$html .= '</td><td class='.$bgclass.' style= "text-align: center;">';
		    					$html.= round($data['amount_discount']);
										$totalDiscount +=  (double) round($data['amount_discount']);
		    							
		    	$html .= '</td><td class='.$bgclass.' style= "text-align: center;">';
		    					$html.= round($data['amount_paid']);
		    							$totalPaidAmount +=  (double) round($data['amount_paid']);
		    							
		    	$html .= '</td><td class='.$bgclass.' style= "text-align: center;">';
		    					$html.= round($amountDue);
										$totalAmountDue +=  (double) round($amountDue);
										
				$html .= '</td><td class='.$bgclass.' style= "text-align: center;">';
								$html.= round($data['card_balance']);
										$totalCardBalance +=  (double) round($data['card_balance']);
										
				$html .= '</td><td class='.$bgclass.' style= "text-align: center;">';
										$html.= round($payAmount);
										$totalPayAmount +=  (double) round($payAmount);
		    	$html .= "</td></tr>" ;
		}
		   				
		   		$html .= '<tr>
    						<td class="tdLabel" colspan="7" style="text-align: right;"><font color="red"><b>Total :</b></font></td>
		   					<td class="tdLabel" style= "text-align: center;"><font color="red"><b>'.$totalRevenue.'</b></font></td>
		   					<td class="tdLabel" style= "text-align: center;"><font color="red"><b>'.$totalDiscount.'</b></font></td>
		   					<td class="tdLabel" style= "text-align: center;"><font color="red"><b>'.$totalPaidAmount.'</b></font></td>
		   					<td class="tdLabel" style= "text-align: center;"><font color="red"><b>'.$totalAmountDue.'</b></font></td>
		   					<td class="tdLabel" style= "text-align: center;"><font color="red"><b>'.$totalCardBalance.'</b></font></td>
		   					<td class="tdLabel" style= "text-align: center;"><font color="red"><b>'.$totalPayAmount.'</b></font></td>
	    				</tr>' ;
 			$html .= '</table>' ;
	 			
	 		//pr($html);exit;
	// output the HTML content
	$tcpdf->writeHTML($html, true, false, true, false, 'middle');
	 
	// reset pointer to the last page
	$tcpdf->lastPage(); 
   
	//Close and output PDF document
	echo $tcpdf->Output('Nurse_Outstanding_Report_'.$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).'.pdf', 'D');
	
?>