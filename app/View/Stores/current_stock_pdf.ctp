<?php
ob_clean();
	App::import('Vendor','tcpdf/config/lang/eng'); 
	App::import('Vendor','tcpdf/tcpdf');  
	
	if(!empty($heading)) {
	  	$facilitynamewithreport = $heading; 
	} 
	
	$tcpdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false); 
	$tcpdf->SetCreator(PDF_CREATOR);
	//$tcpdf->SetAuthor('Hope Hospital');
	//$tcpdf->SetTitle('Hope Hospital-Incidence Report');
	$tcpdf->SetSubject('Report'); 
	//$tcpdf->SetHeaderData('', PDF_HEADER_LOGO_WIDTH, $facilitynamewithreport, $heading, $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true));  
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
	
$html = '<table border="1" class="table_format"  cellpadding="0" cellspacing="0" width="100%" style="text-align:left;padding-top:50px;">
	<tr>
		<td colspan="5" align="center"  width="100%">
			<table border="0" class="" cellpadding="0" cellspacing="0" width="100%">
				<tr>
	            	<td style="font-size: 15px;text-align: left;font-weight: bold; " class="">
						<div style="float:left">
							<img src="'.$this->web_root."img/icons/MSA.jpg".'" width="50" height="50"/>
						</div>
					</td>
	            	<td style="font-size: 20px;font-family:Times New Roman, Georgia, Serif;text-align:center;font-weight: bold;" valign="middle">
						KAILASH CANCER HOSPITAL & RESEARCH CENTRE <br> AND AKSHAR PURSHOTTAM AROGYA MANDIR <br> 
	            	    P.O. Goraj,Waghodia,Vadodara-391760. Ph:02653-961300.<br>Fax:02668-268048
					</td>
					<td style="font-size: 15px;text-align: right;font-weight: bold; " valign="bottom" class="">
						<div style="float:right">
							<img src="'.$this->web_root."img/icons/KCHRC.jpg".'" width="50" height="50"/>
						</div>
					</td>  
		        </tr>
			</table>
		</td>
	</tr>
	<tr class="row_title">
	<td colspan="5" width="100%" height="30px" align="center" valign="middle"><h2>'.$heading.'</h2></td>
		  </tr>
		  <tr class="row_title"> 
		  	<td height="30px" align="center" valign="center" width="5%" style="text-align:center;"><strong>Sr.No</strong></td>
		  	<td height="30px" align="center" valign="middle" width="35%"><strong>Item Name</strong></td>
		  	<td height="30px" align="center" valign="middle" width="20%"><strong>Current Stock</strong></td>
			<td height="30px" align="center" valign="middle" width="20%"><strong>Maximum Order Limit</strong></td>
			<td height="30px" align="center" valign="middle" width="20%"><strong>Reorder Level</strong></td>					   
		</tr>';
	if(!empty($productList)){ $temp = '';  
		$count=0;  foreach($productList as $product){  
$temp .='<tr> 
			<td style="text-align:center;">'.++$count.'</td>
			<td>';
				if(!empty($product["PharmacyItem"]["name"]))
					$name=$product["PharmacyItem"]["name"];
				else if(!empty($product["Product"]["name"]))
					$name=$product["Product"]["name"];
				else if(!empty($product["OtPharmacyItem"]["name"]))
					$name = $product["OtPharmacyItem"]["name"];
$temp .= 	$name;
$temp .= 	"</td>";
$temp .=    '<td style="text-align:center">';
				 if(!empty($product["PharmacyItem"]["stock"]))
					$qty=$product["PharmacyItem"]["stock"];
				else if(!empty($product["Product"]["quantity"]))
					$qty=$product["Product"]["quantity"];
				else if(!empty($product["OtPharmacyItem"]["stock"]))
					$qty=$product["OtPharmacyItem"]["stock"];
				else $qty="0"; 
$temp .= 	$qty;
$temp .= 	"</td>"; 
$temp .=	'<td style="text-align:center">'; 
				if(!empty($product["PharmacyItem"]["maximum"]))
					$max=$product["PharmacyItem"]["maximum"];
				else if(!empty($product["Product"]["maximum"]))
					$max=$product["Product"]["maximum"];
				else if(!empty($product["OtPharmacyItem"]["maximum"]))
					$max=$product["OtPharmacyItem"]["maximum"];
				else $max="0";
$temp .= 	$max;
$temp .= 	"</td>";
$temp .=	'<td style="text-align:center">';
				if(!empty($product["PharmacyItem"]["reorder_level"]))
					$reorder=$product["PharmacyItem"]["reorder_level"];
				else if(!empty($product["Product"]["reorder_level"]))
					$reorder=$product["Product"]["reorder_level"];
				else if(!empty($product["OtPharmacyItem"]["reorder_level"]))
					$reorder=$product["OtPharmacyItem"]["reorder_level"];
				else $reorder=0;
$temp .= 	$reorder;
$temp .= 	"</td>"; 
$temp .= 	'</tr>';
		} 
	}else {
//$html .=   $temp."<tr><td colspan=4 align=center>No Records found!</td></tr>";
	}
$html .= 	$temp."</table>";
	//	echo $html; exit;
ob_clean();
	$tcpdf->writeHTML($html, true, false, true, false, '');
	 
	// reset pointer to the last page
	$tcpdf->lastPage(); 
	
	//Close and output PDF document
	echo $tcpdf->Output(/* $heading."". */$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).'.pdf', 'D');
 
 ?>			