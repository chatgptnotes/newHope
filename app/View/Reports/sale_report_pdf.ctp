<?php
ob_clean();
	App::import('Vendor','tcpdf/config/lang/eng'); 
	App::import('Vendor','tcpdf/tcpdf');
	$facilityname = ucfirst($this->Session->read("facility"));
	$headerimage = $this->Session->read("header_image");
	$facilitynamewithreport;
	
	if(empty($facilityname)) {
	  	$facilitynamewithreport = 'Pharmacy Sales Report'; 
	  	$facilityname = "";
	}
	else {
	    $headerString = "by ".$facilityname ;
		$facilitynamewithreport = $facilityname.'-Pharmacy Sales Report'; 
	}
	$tcpdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false); 
	$tcpdf->SetCreator(PDF_CREATOR);
	//$tcpdf->SetAuthor('Hope Hospital');
	//$tcpdf->SetTitle('Hope Hospital-Incidence Report');
	$tcpdf->SetSubject('Report'); 
	$tcpdf->SetHeaderData($headerimage, PDF_HEADER_LOGO_WIDTH, $facilitynamewithreport, $headerString, $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true));  
	$tcpdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$tcpdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA)); 
	$tcpdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED); 
	$tcpdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$tcpdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$tcpdf->SetFooterMargin(PDF_MARGIN_FOOTER); 
	$tcpdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM); 
 	$tcpdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 
	$tcpdf->SetFont('dejavusans', '', 8); 
	$tcpdf->AddPage();  
$html = '<table border="1" class="table_format"  cellpadding="2" cellspacing="0" width="100%" style="text-align:left;padding-top:50px;">	
			   <tr>
				<td colspan = "10" align="center"><strong>'.ucfirst($getLocName).'</strong></td>
			  </tr>
			  <tr>
				<td colspan = "10" align="center"><strong>'.ucfirst($getLocAdd1).' '.ucfirst($getLocAdd2).' '.ucfirst($location_zipcode).','.ucfirst($location_country).'</strong></td>
			  </tr>
			 
			  <tr>
				<td colspan = "10" align="center"><strong>Pharmacy '.ucfirst($for).' Report</strong></td>
			  </tr>
			  <tr>
				<td colspan = "10" align="center"><strong>'.$this->DateFormat->formatDate2Local($from,Configure::read('date_format'), false).'</strong> to <strong>'.$this->DateFormat->formatDate2Local($to,Configure::read('date_format'), false).'</strong></td>
			  </tr>
			  <tr>
				<td height="10px" align="center" valign="middle" width="7%"><strong>'. __('Sr.No.').'</strong></td>	
				<td height="30px" align="center" valign="middle" width="10%"><strong>'. __('Date').'</strong></td> 
				<td height="30px" align="center" valign="middle" width="10%"><strong>'. __('Bill Code').'</strong></td>					  
				<td height="30px" align="center" valign="middle" width="20%"><strong>'. __('Patient Name').'</strong></td>  
				<td height="30px" align="center" valign="middle" width="10%"><strong>'. __('Sale By').'</strong></td>				  
 				<td height="30px" align="center" valign="middle" width="10%"><strong>'. __('Payment Mode').'</strong></td>
 				<td height="30px" align="center" valign="middle" width="8%"><strong>'. __('Billed  Amount').'</strong></td> 
 				<td height="30px" align="center" valign="middle" width="7%"><strong>'. __('Discount (%)').'</strong></td> 
 				<td height="30px" align="center" valign="middle" width="8%"><strong>'. __('Discount (Amount)').'</strong></td> 
 				<td height="30px" align="center" valign="middle" width="10%"><strong>'. __('Amount').'</strong></td> 
			  </tr>';
				$getTotalDiscountPer=0;
				$totalDiscountAmt=0;
				$getTotalFinalAmt=0;
				if(count($reports)>0) {
			    $k = 1; 
				
	      		foreach($reports as $report){	
	      			
	      			$getTotalDiscountPer=$getTotalDiscountPer+round(($report['PharmacySalesBill']['discount']*100)/$report['PharmacySalesBill']['total']);
	      			$totalDiscountAmt=$totalDiscountAmt+$report['PharmacySalesBill']['discount'];
						$html .= '<tr>
								<td align="center" height="17px">'.$k.'</td>	
							<td align="center" height="17px">'. $this->DateFormat->formatDate2Local($report['PharmacySalesBill']['create_time'],Configure::read('date_format')).'</td>
												
							<td align="center" height="17px">'. $report['PharmacySalesBill']['bill_code'].'</td>	';		
								if(empty($report['PharmacySalesBill']['patient_id']))
									$html .= '<td align="center" height="17px">	 '.$report['PharmacySalesBill']['customer_name'].'</td>	';
								else
								$html .= '<td align="center" height="17px">'.$report['Patient']['lookup_name'].' ('.$report['Patient']['patient_id'].')</td>	'; 
								$html .='<td align="center" height="17px">'. $report['User']['first_name']." ".$report['User']['last_name'].'</td>		
								<td align="center" height="17px">'. $report['PharmacySalesBill']['payment_mode'].'</td>';
								$html .='<td align="center" height="17px">'.number_format($report['PharmacySalesBill']['total'], 2).'</td>
								<td align="center" height="17px">'. round(($report['PharmacySalesBill']['discount']*100)/$report['PharmacySalesBill']['total']).'%</td>						
								<td align="center" height="17px">'.number_format($report['PharmacySalesBill']['discount'], 2).'</td>';
								//if(empty($report['PharmacySalesBill']['paid_amnt'])){
									$getAmount=$report['PharmacySalesBill']['total']-$report['PharmacySalesBill']['discount'];
								//}
								$getTotalFinalAmt=$getTotalFinalAmt+round($getAmount);
								
								$html .= '<td align="center" height="17px">'. round($getAmount).'</td>
						</tr>';
				if($showItem){
					$html .='<tr>
						<td align="center" colspan="10">
							<table width="100%" align="center">
								<tr>
								<td align="center" width="6%">Sr.No.</td>
								<td align="center" width="22%">Item</td>
								<td align="center" width="18%">Code</td>
								<td align="center" width="18%">Quantity</td>
								<td align="center" width="18%">Batch</td>
								<td align="center" width="18%">Expiry Date</td>
							 	</tr>';
										$i=1;
									foreach($report['PharmacySalesBillDetail'] as $key=>$value){ 
										$html .= '<tr>
												<td align="center">'. $i.'</td>
												<td align="center">'. $value['item'].'</td>
												<td align="center">'. $value['code'].'</td>
												<td align="center">'. $value['qty'].'</td>
												<td align="center">'. $value['batch_number'].'</td>
												<td align="center">'. $this->DateFormat->formatDate2Local($value['expiry_date'],Configure::read('date_format')).'</td>
 												
										</tr>';
									 $i++; }
							 
								 
							$html .='</table>
						</td>
					</tr>';
					}
					$k++;
				}
				
			}
			$totalAmt=round($totalAmt);
			$getTotalDiscountPer=round($getTotalDiscountPer);
			$totalDiscountAmt=round($totalDiscountAmt);
			$getTotalFinalAmt=round($getTotalFinalAmt);
			
	$html .='<tr>
			<td align="center" colspan="6"><strong></strong></td>
			<td align="center"><strong>'.Rs.' '.$totalAmt.'</strong></td>
			<td align="center"><strong></strong></td>
			<td align="center"><strong>'.Rs.' '.$totalDiscountAmt.'</strong></td>
			<td align="center"><strong>'.Rs.' '.$getTotalFinalAmt.'</strong></td>
			</tr>';
if($flagCredit){
	$totalCreditAmt=round($totalCreditAmt);
	$totalCashAmt=round($totalCashAmt);
	$getTotalAmt=round($getTotalAmt);
$html .=' <tr>
	<td align="right" colspan="9"><strong>Total Credit Amount</strong></td>
	<td align="center"><strong>'.Rs.' '.$totalCreditAmt.'</strong></td>
</tr>';
	}if($flagCash){
$html .='<tr  class="row_title">
	<td  align="right" colspan="9"><strong>Total Cash Amount</strong></td>
	<td align="center"><strong>'.Rs.' '.$totalCashAmt.'</strong></td>
</tr>';
	}
$html .='<tr>			
	<td align="right" colspan="9"><strong>Grand Total Amount</strong></td>
	<td align="center"><strong>'.Rs.' '.$getTotalAmt.'</strong></td>
</tr></table>';
$tcpdf->writeHTML($html, true, false, true, false, '');
	 
	// reset pointer to the last page
	$tcpdf->lastPage(); 
	
	//Close and output PDF document
	echo $tcpdf->Output('pharmacy_sale_report '.$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).'.pdf', 'D');
 
 ?>