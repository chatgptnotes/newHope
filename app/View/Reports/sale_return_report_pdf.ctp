<?php
ob_clean();
	App::import('Vendor','tcpdf/config/lang/eng'); 
	App::import('Vendor','tcpdf/tcpdf');
	$facilityname = ucfirst($this->Session->read("facility"));
	$headerimage = $this->Session->read("header_image");
	$facilitynamewithreport;
	
	if(empty($facilityname)) {
	  	$facilitynamewithreport = 'Pharmacy Sales Return Report'; 
	  	$facilityname = "";
	}
	else {
	    $headerString = "by ".$facilityname ;
		$facilitynamewithreport = $facilityname.'-Pharmacy Sales Return Report'; 
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
					<td colspan = "8" align="center"><strong>'.ucfirst($getLocName).'</strong></td>
	     	   </tr>
	           <tr>
			        <td colspan = "8" align="center"><strong>'.ucfirst($getLocAdd1).' '.ucfirst($getLocAdd2).' '.ucfirst($location_zipcode).','.ucfirst($location_country).'</strong></td>
		       </tr>
			  <tr>
				<td colspan = "8" align="center"><strong>Pharmacy '.ucfirst($for).' Report</strong></td>
			  </tr>
			  <tr>
				<td colspan = "8" align="center"><strong>'.$this->DateFormat->formatDate2Local($from,Configure::read('date_format'), false).'</strong> to <strong>'.$this->DateFormat->formatDate2Local($to,Configure::read('date_format'), false).'</strong></td>
			  </tr>
			  <tr>
			  	   <td height="10px" align="center" valign="middle" width="6%"><strong>'. __('Sr.No.').'</strong></td>
 				   <td height="30px" align="center" valign="middle" width="13%"><strong>'. __('Party Name').'</strong></td>  
				   <td height="30px" align="center" valign="middle" width="15%"><strong>'. __('Take By').'</strong></td>
				   <td height="30px" align="center" valign="middle" width="13%"><strong>'. __('Date').'</strong></td> 
				   <td height="30px" align="center" valign="middle" width="13%"><strong>'.__('Billed Amount').'</strong></td> 
				   <td height="30px" align="center" valign="middle" width="13%"><strong>'.__('Discount (%)').'</strong></td> 
				   <td height="30px" align="center" valign="middle" width="13%"><strong>'. __('Discount (Amount)').'</strong></td> 
  				   <td height="30px" align="center" valign="middle" width="13%"><strong>'. __('Amount').'</strong></td> 
			   </tr>';
			 
				if(count($reports)>0) {
			    $k = 1; 
					
	      		foreach($reports as $report){	
	      			if(!empty($report['InventoryPharmacySalesReturn']['total']))
	      				$getBilledAmt=$report['InventoryPharmacySalesReturn']['total'];
	      			else
	      				$getBilledAmt=$totalreturnBilledAmt[$report['InventoryPharmacySalesReturn']['id']];
	      				
	      			$getGrndBilledAmt=$getGrndBilledAmt+$getBilledAmt;
	      			$getDiscount=$getBilledAmt*($report['InventoryPharmacySalesReturn']['discount']/100);
	      			$totalGrandDis=$totalGrandDis+round($getDiscount);
	      			$getGrandAmt=$getGrandAmt+(round($getBilledAmt)-round($getDiscount));
						$html .= '<tr>';					
 								$html .='<td align="center" height="17px">'.$k.'</td>		
 								<td align="center" height="17px">'. $this->DateFormat->formatDate2Local($report['InventoryPharmacySalesReturn']['create_time'],Configure::read('date_format')).'</td>';
 								if(empty($report['InventoryPharmacySalesReturn']['patient_id']))
									$html .= '<td align="center" height="17px">	 '.$report['InventoryPharmacySalesReturn']['customer_name'].'</td>	';
								else
								$html .= '<td align="center" height="17px">'.$report['Patient']['lookup_name'].' ('.$report['Patient']['patient_id'].')</td>	'; 
							    $html .='<td align="center" height="17px">'. $report['User']['first_name']." ".$report['User']['last_name'].'</td>	
									<td align="center" height="17px">'.number_format($getBilledAmt, 2).'</td>
									<td align="center" height="17px">'.round($report['InventoryPharmacySalesReturn']['discount']).'%</td>
									<td align="center" height="17px">'.number_format($getDiscount, 2).'</td>		
									<td align="center" height="17px">'. round($getBilledAmt-$getDiscount).'</td>
						</tr>';
				if($showItem){
 									
					$html.='<tr>
						<td align="left" colspan="8">
							<table width="100%" align="center" >
								<tr>
									<td align="center">Sr.No.</td>
									<td align="center">Item</td>
									<td align="center">Code</td>	
									<td align="center">Quantity</td>	
									<td align="center">Batch</td> 									
									<td align="center">Expiry Date</td> 
									<td align="center"></td> 
									<td align="center"></td> 
									<td align="center"></td> 
										</tr>';
								 $i=1;
									foreach($report['InventoryPharmacySalesReturnsDetail'] as $key=>$value){ 
										$html .= '<tr>
												<td align="center">'. $i.'</td>
												<td align="center">'. $value['item'].'</td>
												<td align="center">'. $value['code'].'</td>
												<td align="center">'. $value['qty'].'</td>
												<td align="center">'.$value['batch_no'].'</td>
 												<td align="center">'. $this->DateFormat->formatDate2Local($value['expiry_date'],Configure::read('date_format')).'</td>
 												<td align="center"></td> 
 												<td align="center"></td> 
 												<td align="center"></td> 
										</tr>';
										$i++;
									}
								 
							$html .='</table>
						</td>
					</tr>';
				}
					
			 $k++;
				}
				
			}

$html .='<tr>			
	<td align="right" colspan="4"><strong>Grand Total Amount</strong></td>
	<td align="center"><strong>'.round($getGrndBilledAmt).'</strong></td>	
	<td align="center"><strong></strong></td>
	<td align="center"><strong>'.round($totalGrandDis).'</strong></td>
	<td align="center"><strong>'.round($getGrandAmt).'</strong></td>
</tr></table>';
$tcpdf->writeHTML($html, true, false, true, false, '');
	 
	// reset pointer to the last page
	$tcpdf->lastPage(); 
	
	//Close and output PDF document
	echo $tcpdf->Output('pharmacy_sale_return_report '.$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).'.pdf', 'D');
 
 ?>