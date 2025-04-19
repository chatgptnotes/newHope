<?php
ob_clean();
	App::import('Vendor','tcpdf/config/lang/eng'); 
	App::import('Vendor','tcpdf/tcpdf');
	$facilityname = ucfirst($this->Session->read("facility"));
	$headerimage = $this->Session->read("header_image");
	$facilitynamewithreport;
	
	if(empty($facilityname)) {
	  	$facilitynamewithreport = 'Pharmacy Purchase Report'; 
	  	$facilityname = "";
	}
	else {
	    $headerString = "by ".$facilityname ;
		$facilitynamewithreport = $facilityname.'-Pharmacy Purchase Report'; 
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
	$tcpdf->SetFont('dejavusans', '', 6); 
	$tcpdf->AddPage();  
	$html ='<table border="1" class="table_format"  cellpadding="2" cellspacing="0" width="100%" style="text-align:left;padding-top:50px;">	
			  <tr class="row_title">
				<td colspan = "9" align="center"><strong>Pharmacy '.ucfirst($for).' Report</strong></td>
			  </tr>
			  <tr class="row_title">
				<td colspan = "9" align="center"><strong>'.$this->DateFormat->formatDate2Local($from,Configure::read('date_format'), false).'</strong> to <strong>'.$this->DateFormat->formatDate2Local($to,Configure::read('date_format'), false).'</strong></td>
			  </tr>
			  <tr class="row_title" style="background-color:#A1B6BE;">
					  <td height="10px" align="center" valign="middle" width="4%"><strong>Sr. No.</strong></td>	
				   <td height="30px" align="center" valign="middle" width="8%"><strong>'.__('Purchase Code').'</strong></td>					  
				   <td height="30px" align="center" valign="middle" width="15%"><strong>'.__('Supplier Name').'</strong></td>  
				   <td height="30px" align="center" valign="middle" width="20%"><strong>'.__('Purchase By').'</strong></td>
				   <td height="30px" align="center" valign="middle" width="10%"><strong>'.__('Date').'</strong></td> 
					<td height="30px" align="center" valign="middle" width="8%"><strong>'.__('Bill No.').'</strong></td>
					<td height="30px" align="center" valign="middle" width="5%"><strong>'.__('Payment Mode').'</strong></td>
					<td height="30px" align="center" valign="middle" width="10%"><strong>'.__('Credit Amount').'</strong></td>
					<td height="30px" align="center" valign="middle" width="10%"><strong>'.__('Extra Amount').'</strong></td>
					<td height="30px" align="center" valign="middle" width="10%"><strong>'.__('Total Amount').'</strong></td> 
			   </tr>'; 
	  		if(count($reports)>0) {
			   $k = 1; 
			
	      		foreach($reports as $report){	
									
				 
					$html .='<tr>		
<td align="center" height="17px">'.$k.'</td>					
					    <td align="center" height="17px">'.$report['InventoryPurchaseDetail']['vr_no'].'</td>					   
					    <td align="center" height="17px">'.$report['InventorySupplier']['name'].'</td>
					    <td align="center" height="17px">'.$report['Initial']['name'].''.$report['User']['first_name'].' '.$report['User']['last_name'].'</td>  
						<td align="center" height="17px">'.$this->DateFormat->formatDate2Local($report['InventoryPurchaseDetail']['create_time'],Configure::read('date_format')).'</td>
					    <td align="center" height="17px">'.$report['InventoryPurchaseDetail']['bill_no'].'</td>

						<td align="center" height="17px">'.$report['InventoryPurchaseDetail']['payment_mode'].'</td>
						<td align="center" height="17px">'.$report['InventoryPurchaseDetail']['credit_amount'].'</td>
						<td align="center" height="17px">'.$report['InventoryPurchaseDetail']['extra_amount'].'</td>
						<td align="center" height="17px">'.$report['InventoryPurchaseDetail']['total_amount'].'</td> 
					</tr>
					<tr>
						<td align="center" colspan="10">
							<table width="100%" align="center" style="background-color: #ddd">
								<tr style="background-color:red;">
									<td align="center">Item</td>	<td align="center">Code</td>	<td align="center">Quantity</td>	<td align="center">Batch</td>
									<td align="center">Expiry Date</td>	<td align="center">Price</td>	
										</tr>';
							 
									foreach($report['InventoryPurchaseItemDetail'] as $key=>$value){ 
										$html .='<tr>
												<td align="center">'.$value['item'].'</td>
												<td align="center">'.$value['code'].'</td>
												<td align="center">'.$value['qty'].'</td>
												<td align="center">'.$value['batch_no'].'</td>
												<td align="center">'.$this->DateFormat->formatDate2Local($value['expiry_date'],Configure::read('date_format'),false).'</td>
												<td align="center">'.$value['value'].'</td>
												<td align="center">&nbsp;</td>
										</tr>';
								  }
								 
							$html .='</table>
						</td>
					</tr>
					<tr><td colspan="9"></td></tr>';
					  
				 $k++; 
			   }

			 
			  
			 		  
				 } else {
					 $html .='<tr>
									<td align="center" height="17px" colspan="9" > No Record Found</td>
									
								</tr>';
 
				 }
	   
			   
			   
$html .='</table>';
$tcpdf->writeHTML($html, true, false, true, false, '');
	 
	// reset pointer to the last page
	$tcpdf->lastPage(); 
	
	//Close and output PDF document
	echo $tcpdf->Output('purchase_report '.$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).'.pdf', 'D');
?>