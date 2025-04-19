<?php
	
	//App::import('Vendor','xtcpdf'); 
	//$tcpdf = new XTCPDF();	
	//ob_clean();
	App::import('Vendor','tcpdf/config/lang/eng'); 
	App::import('Vendor','tcpdf/tcpdf');
	$tcpdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	// set document information
	$tcpdf->SetCreator(PDF_CREATOR);
	$tcpdf->SetAuthor('Hope Hospital');
	$tcpdf->SetTitle('Hope Hospital-Time Taken for Admissions Report');
	$tcpdf->SetSubject('Report');
	//$tcpdf->SetKeywords('TCPDF, PDF, example, test, guide');
	 
	// set default header data
	$tcpdf->SetHeaderData('logo.jpg', PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.'-Time Taken for Admissions Report', PDF_HEADER_STRING, date('d/m/Y'));
	
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

	
	$html ='<div style="margin-top:200px;">&nbsp;<span>Date: '.date('d/m/Y h:i A').'</span><br></div>
	   
		<table border="1" class="table_format"  cellpadding="0" cellspacing="0" width="100%" style="text-align:center;padding-top:50px;">				  
				  <tr class="row_title" style="background-color:#A1B6BE;"> 
				  <td height="30px" align="center" valign="middle"><strong>Date</strong></td>
				   <td height="30px" align="center" valign="middle"><strong>Count</strong></td>';		    
			
			
			$html .='</tr>';
				  	  $toggle =0;
				      if(count($x_ray_report_data) > 0) {
						   $i = 1;
						   $finalWaitingTime ='';
						   $finalremTime ='';
						   $timeCount =0 ;
				      		foreach($x_ray_report_data as $key => $data){	
							
							$html .= "<tr> 
									    <td align='center' height='17px'>".$this->DateFormat->formatDate2Local($data['testDate'],Configure::read('date_format'),true)."</td>	   
									    <td align='center' height='17px'>".$data['testCount']."</td>
									  
									 </tr>";
							 $i++; 
						   }
						  
			}	
					   		  
		  $html .= '</table>' ; 

	
	// output the HTML content
	$tcpdf->writeHTML($html, true, false, true, false, '');
	 
	// reset pointer to the last page
	$tcpdf->lastPage(); 
	
	//Close and output PDF document
	echo $tcpdf->Output('Time-Taken-For-Admission'.date('d-m-Y h.iA').'.pdf', 'D');
	
?>