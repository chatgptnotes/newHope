<?php

//App::import('Vendor','xtcpdf'); 
//$tcpdf = new XTCPDF();	
//ob_clean();
App::import('Vendor', 'tcpdf/config/lang/eng');
App::import('Vendor', 'tcpdf/tcpdf');

$headerimage = $this->Session->read("header_image");

$tcpdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$tcpdf->SetCreator(PDF_CREATOR);

$tcpdf->SetSubject('Report');
//$tcpdf->SetKeywords('TCPDF, PDF, example, test, guide');
// set default header data
//$tcpdf->SetHeaderData($headerimage, PDF_HEADER_LOGO_WIDTH, $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true));
// set header and footer fonts
$tcpdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$tcpdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$tcpdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
/* 	$tcpdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
  $tcpdf->SetHeaderMargin(PDF_MARGIN_HEADER);
  $tcpdf->SetFooterMargin(PDF_MARGIN_FOOTER); */

//set auto page breaks
$tcpdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$tcpdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


// ---------------------------------------------------------
// set font
//$tcpdf->SetFont('dejavusans', '', 8);
$tcpdf->SetFont('times', '', 8);

// add a page (required with recent versions of tcpdf)
$tcpdf->SetPrintHeader(false);
$tcpdf->SetPrintFooter(false);
$tcpdf->AddPage();
$html .='<table width="20%"  border="0" cellspacing="0"  cellpadding="1">';
$html .= '<tr><td colspan="2">--------------------------------------</td></tr>
          <tr><td  align="left">i-STAT EG7+ </td></tr>'; 

$html .= '<tr><td>Pt Name:</td>
              <td>';
$name = explode('-', $data['Patient']['patient_name']);
$html .= $name[0];
$html .=     '</td>';
$html .= '</tr>
            	<tr><td colspan="2" align="center">------------------------------</td></tr>
				<tr>
					 <td align="left">37.0<sup>0</sup> C</td>
				</tr>';
$html .= '<tr>
				<td align="left">pH</td>
				<td>';
$html .= $data['Patient']['pH'];

$html .= '</td></tr><tr>
				 <td align="left">PCO2</td> <td>';
$html .= $data['Patient']['PCO2'];

$html .= '<span>&nbsp;mmHg</span></td>
			</tr><tr>
				 <td align="left">PO2</td><td>';
$html .= $data['Patient']['PO2'];

$html .= '<span>&nbsp;mmHg</span></td>
			</tr><tr>
				 <td align="left">BEecf</td><td>';
$html .= $data['Patient']['BEecf'];
$html .= '<span>&nbsp;mmo l/L</span></td>
			</tr><tr>
				 <td align="left">HCO3</td><td>';
$html .= $data['Patient']['HCO3'];
$html .= '<span>&nbsp;mmo l/L</span></td>
			</tr><tr>
				 <td align="left">TCO2</td><td>';
$html .= $data['Patient']['TCO2'];

$html .= '<span>&nbsp;mmo l/L</span></td>
			</tr><tr>
				 <td align="left">sO2</td><td>';
$html .= $data['Patient']['sO2'];
$html .= '<span>&nbsp;%</span></td>
			</tr>
			<tr><td colspan="2" align="center">--------------------------</td></tr>
			<tr>
				 <td align="left">Na</td><td>';
$html .= $data['Patient']['Na'];
$html .= '<span>&nbsp;mmo l/L</span></td>
			</tr><tr>
				 <td align="left">K</td><td>';
$html .= $data['Patient']['K'];
$html .= '<span>&nbsp;mmo l/L</span></td>
			</tr><tr>
				 <td align="left">iCa</td><td>';
$html .= $data['Patient']['iCa'];
$html .= '<span>&nbsp;mmo l/L</span></td>
			</tr><tr>
				 <td align="left">Hct</td><td>';
$html .= $data['Patient']['Hct'];

$html .= '<span>&nbsp;%PCV</span></td>
			</tr><tr>
				 <td align="left">Hb*</td><td>';
$html .= $data['Patient']['Hb'];
$html .= '<span>&nbsp;g/dl</span></td>
			</tr><tr>
				  <td align="center">*Via Hct</td></tr>
			<tr>
				 <td align="left">CPB: No</td>
			</tr><tr><td>';
$html .= $date;
$html .= '</td></tr>
			<tr>
				 <td align="left">Operator ID:</td>
				 <td align="left"></td>
			</tr>
			<tr>
			      <td align="left">Physician: </td>
				 <td align="left"> __________</td></tr>
			<tr>
				 <td align="left">Lot Number:</td>
			    <td align="left">426W151130236</td>
			</tr>
			<tr>
				 <td align="left">Serial:</td>
			<td align="left">358440</td>
			</tr>
			<tr>
				 <td align="left">Version:</td>
				 <td align="left">JAMS139C</td>
			</tr>
			<tr>
				<td align="left">CLEW:</td>
				 <td align="left">A30</td>
			</tr>
			<tr>
				 <td align="left">Custom:</td>
				 <td align="left">00000000</td>
			</tr>
			<tr><td colspan="2" align="center">------------------------------</td></tr>
			<tr>
				 <td align="left" colspan="2">Reference Ranges</td>
			</tr>
			<tr>
                            <td colspan="2">
                                <table width="100%">
                                    <tr>
                                        <td width="25%" align="left">pH</td>
                                        <td width="20%" align="right">7.130</td>
                                        <td width="20%" align="right">7.410</td>
                                        <td width="5%" align="center"></td>
                                        <td width="30%" align="left"></td>
                                    </tr>  
                                    <tr>
                                        <td align="left">PCO2</td>
                                        <td align="right">41.0</td>
                                        <td align="right">51.0</td>
                                        <td></td>
                                        <td align="left">mmHg</td>
                                    </tr>  
                                    <tr>
                                        <td align="left">PO2</td>
                                        <td align="right">80</td>
                                        <td align="right">105</td>
                                        <td></td>
                                        <td align="left">mmHg</td>
                                    </tr>  
                                    <tr>
                                        <td align="left">BEecf</td>
                                        <td align="right">-6</td>
                                        <td align="right">3</td>
                                        <td></td>
                                        <td align="left">mmo l/L</td>
                                    </tr>  
                                    <tr>
                                        <td align="left">HCO3</td>
                                        <td align="right">12.0</td>
                                        <td align="right">28.0</td>
                                        <td></td>
                                        <td align="left">mmo l/L</td>
                                    </tr>  
                                    <tr>
                                        <td align="left">TCO2</td>
                                        <td align="right">18</td>
                                        <td align="right">29</td>
                                        <td></td>
                                        <td align="left">mmo l/L</td>
                                    </tr>  
                                    <tr>
                                        <td align="left">sO2</td>
                                        <td align="right">48</td>
                                        <td align="right">98</td>
                                        <td></td>
                                        <td align="left">%</td>
                                    </tr>  
                                    <tr>
                                        <td align="left">Na</td>
                                        <td align="right">138</td>
                                        <td align="right">146</td>
                                        <td></td>
                                        <td align="left">mmo l/L</td>
                                    </tr> 
                                    <tr>
                                        <td align="left">K</td>
                                        <td align="right">3.5</td>
                                        <td align="right">4.9</td>
                                        <td></td>
                                        <td align="left">mmo l/L</td>
                                    </tr> 
                                    <tr>
                                        <td align="left">iCa</td>
                                        <td align="right">1.12</td>
                                        <td align="right">1.32</td>
                                        <td></td>
                                        <td align="left">mmo l/L</td>
                                    </tr> 
                                    <tr>
                                        <td align="left">Hct</td>
                                        <td align="right">38</td>
                                        <td align="right">51</td>
                                        <td></td>
                                        <td align="left">%PCV</td>
                                    </tr> 
                                    <tr>
                                        <td align="left">Hb*</td>
                                        <td align="right">12.0</td>
                                        <td align="right">17.0</td>
                                        <td></td>
                                        <td align="left">g/dL</td>
                                    </tr> 
                                </table> 
                            </td>
                        </tr> 
			<tr><td colspan="2">-----------------------------------</td></tr>
			';
$html .= '</table>';

//echo $html;

//	pr($html);exit;
// output the HTML content
$tcpdf->writeHTML($html, true, false, true, false, 'middle');
// reset pointer to the last page
$tcpdf->lastPage();

//Close and output PDF document
echo $tcpdf->Output('Lab_result_'.$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).'.pdf', 'D');
?>
