<?php
	 
	App::import('Vendor','tcpdf/config/lang/eng'); 
	App::import('Vendor','tcpdf/tcpdf');
	
	$facilityname = ucfirst($this->Session->read("facility"));
	$headerimage = $this->Session->read("header_image");
	$facilitynamewithreport;
	
	if(empty($facilityname)) {
	  	$facilitynamewithreport = 'LIST OF '.strtoupper($groupFlag).' TEST'; 
	  	$facilityname = "";
	}
	else {
	    $headerString = "by ".$facilityname ;
		$facilitynamewithreport ='LIST OF '.strtoupper($groupFlag).' TEST'; 
	}

	
	$tcpdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false,false,true);
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
	 
	$k = 0;
 
	$html ='
			<style>
			.boxBorderBot {
				border-bottom: 1px solid #3E474A;
			}
			
			.boxBorder {
				border: 1px solid #3E474A;
				margin-top: 60px;
			}
			
			.tdBorderRtBt {
				border-right: 1px solid #3E474A;
				border-bottom: 1px solid #3E474A;
			}
			
			.tdBorderBt {
				border-bottom: 1px solid #3E474A;
			}
			
			.tdBorderOnlytop {
				border-top: 1px solid #3E474A;
			}
			
			.tdBorderTp {
				border-top: 1px solid #3E474A;
				border-right: 1px solid #3E474A;
			}
			
			.tdBorderRt {
				border-right: 1px solid #3E474A;
			}
			
			.tdBorderTpBt {
				border-bottom: 1px solid #3E474A;
				border-top: 1px solid #3E474A;
			}
			
			.tdBorderTpRt {
				border-top: 1px solid #3E474A;
				border-right: 1px solid #3E474A;
			}
			</style> 
			
			'./*.'<div align="center">LIST OF LABORATORY TESTS</div>.'*/'.
			
			<div> 
				<table width="100%" border="0" cellspacing="0" cellpadding="5" align="center" class="boxBorder" >
					<tr>
					    <td width="30%" align="left" valign="top">Name Of Patient</td>
					    <td width="20%" valign="top">:</td>
					    <td width="50%" align="left" valign="top">'.$patient['PatientInitial']['name']." ".$patient['Patient']['lookup_name'];
						    if($patient['Patient']['vip_chk']=="1"){
						    	$html .='  ( VIP )';
						    }
					    $html .='</td>
					</tr>';

					if($patient['Person']['name_of_ip']!=''){
					$html .=' 
					<tr>
					    <td align="left">Name Of the I. P.</td>
					    <td >:</td>
					    <td align="left">'.$patient['Person']['name_of_ip'].'</td>
					</tr>';
					}
					if($patient['Person']['relation_to_employee']!=''){
					$relation = array('SELF'=>'Self','FAT'=>'Father','MOT'=>'Mother','BRO'=>'Brother','SIS'=>'Sister','WIFE' => 'Wife','HUSBAND'=>'Husband','SON' => 'Son', 'DAU' => 'Daughter','OTHER'=>'other');
					$html .='
					<tr>
					    <td align="left">Relation with I. P.</td>
					    <td >:</td>
					    <td align="left">'.$relation[$patient['Person']['relation_to_employee']].'</td>
					</tr>';
					}

					$html .='
					<tr>
					    <td align="left">Age/Sex</td>
					    <td >:</td>';
						if(!empty($patient['Person']['dob'])){
							$date1 = new DateTime($patient['Person']['dob']);
							$date2 = new DateTime();
							$interval = $date1->diff($date2);
							$date1_explode = explode("-",$patient['Person']['dob']);
							$person_age_year =  $interval->y . " Year";
							$personn_age_month =  $interval->m . " Month";
							$person_age_day = $interval->d . " Day";
							if($person_age_year == 0 && $personn_age_month > 0){
								$age = $interval->m ;
								if($age==1){
									$age=$age . "M";
								}else{
									$age=$age . "M";
								}
							}else if($person_age_year == 0 && $personn_age_month == 0 && $person_age_day > -1){
								$age = $interval->d . " " + 1 ;
								if($age==1){
									$age=$age . "D";
								}else{
									$age=$age . "D";
								}
							}else{
								$age = $interval->y;
								if($age==1){
									$age=$age . "Y";
								}else{
									$age=$age . "Y";
								}
							}
						}
					    $html .='<td align="left">'.$age."/".ucfirst($patient['Person']['sex']).'</td>
					</tr>';

					if(!empty($address)){
					$html .='
					<tr>
					    <td align="left">Address</td>
					    <td >:</td>
					    <td align="left">'.$address.'</td>
					</tr>';
					}
					
					if($patient['Person']['insurance_number']!='' || $patient['Person']['executive_emp_id_no']!='' || $patient['Person']['non_executive_emp_id_no']!=''){
					$html .='
					<tr>
					    <td align="left">Insurance Number/Staff Card No/Pensioner Card No.</td>
					    <td >:</td>';
						if($patient['Person']['insurance_number']!=''){
						$html .='<td align="left">'.$patient['Person']['insurance_number'].'</td>'; 
						}elseif($patient['Person']['executive_emp_id_no']!=''){
						$html .='<td align="left">'.$patient['Person']['executive_emp_id_no'].'</td>';  
						}elseif($patient['Person']['non_executive_emp_id_no']!=''){
						$html .='<td align="left">'.$patient['Person']['non_executive_emp_id_no'].'</td>';  
						}else{
							$html .='<td align="left"></td>';
						}
					$html .='</tr>';
					}
					if($patient['Patient']['date_of_referral']!=''){
					$html .='
					<tr>
					    <td align="left">Date of Referral</td>
					    <td >:</td>';
						if($patient['Patient']['date_of_referral']!=''){
							$html .='<td align="left">'.$this->DateFormat->formatDate2Local($patient['Patient']['date_of_referral'],Configure::read('date_format')).'</td>';
						} 
					$html .='</tr>';
					}
					if($patient['Patient']['form_received_on']!=''){
					$admissionDate = explode(" ",$patient['Patient']['form_received_on']);
					$html .='
					<tr>
					    <td align="left">Date Of Registration</td>
					    <td >:</td>
					    <td align="left">'.$this->DateFormat->formatDate2Local($patient['Patient']['form_received_on'],Configure::read('date_format'),true).'</td>
					</tr>';
					}
					if($finalBillingData['FinalBilling']['discharge_date']!=''){
					$html .='
					<tr>
					    <td align="left">Date Of '.$dynamicText.'</td>
					    <td >:</td>
					    <td align="left">';
						if(isset($finalBillingData['FinalBilling']['discharge_date']) && $finalBillingData['FinalBilling']['discharge_date']!=''){
							$splitDate = explode(" ",$finalBillingData['FinalBilling']['discharge_date']);
							echo $this->DateFormat->formatDate2Local($finalBillingData['FinalBilling']['discharge_date'],Configure::read('date_format'),true);
						}
					    $html.='</td>
					</tr>';
					}
					if($finalBillingData['FinalBilling']['patient_discharge_condition']!=''){
					$html .='
					<tr>
					    <td align="left">Condition of the patient on '.$dynamicText.'</td>
					    <td >:</td>
					    <td align="left">'.$finalBillingData['FinalBilling']['patient_discharge_condition'].'</td>
					</tr>'; 
					}
					if($invoiceMode!='direct'){
					$html .='
					<tr>
					    <td align="left">Invoice No.</td>
					    <td >:</td>
					    <td align="left">'.$billNumber.'</td>
					</tr>';
					}
					if($patient['Patient']['admission_id']!=''){
					$html .='
					<tr>
					    <td align="left">Registration No.</td>
					    <td >:</td>
					    <td align="left">'.$patient['Patient']['admission_id'].'</td>
					</tr>';
					}
					
					if($corporateEmp!=''){
						$hideCGHSCol = '';
					if(strtolower($corporateEmp) == 'private'){
						$hideCGHSCol = 'none' ;
					}
					$html .='
					<tr>
					    <td align="left">Category</td>
					    <td >:</td>
					    <td align="left">'.$tariffData[$patient['Patient']['tariff_standard_id']].'</td>
					</tr>';
					}
					if($primaryConsultant[0]['fullname']!=''){
					$html .='
					<tr>
					    <td align="left">Primary Consultant</td>
					    <td >:</td>
					    <td align="left">'.$primaryConsultant[0]['fullname'].'</td>
					</tr>';
					}
					if($finalBillingData['FinalBilling']['credit_period']!=''){
					$html .='
					<tr>
					    <td align="left">Credit Period (in days)</td>
					    <td >:</td>
					    <td align="left">'.$finalBillingData['FinalBilling']['credit_period'].'</td>
					</tr>';
					}
					if($finalBillingData['FinalBilling']['other_consultant']!=''){
					$html .='
					<tr>
					    <td align="left">Other Consultant Name</td>
					    <td >:</td>
					    <td align="left">'.$finalBillingData['FinalBilling']['other_consultant'].'</td>
					</tr>';
					}
					if(!empty($finalBillingData['FinalBillingOption'])){
						$count = 0 ;
						foreach($finalBillingData['FinalBillingOption'] as $finalOptions){
							$html  =	'<tr>';
							$html .=  '<td align="left" valign="top">'.ucwords($finalOptions['name']).'</td>' ;
							$html .=  '<td valign="top">:</td>';
							$html .=  '<td valign="top">';
							$html .=  ucwords($finalOptions['value']).'</td>';
							$html .=  '</tr>';
							echo $html  ;
							$count++ ;
						}
					}   
			 
			$html .='</table>
			</div>
					
			<div>&nbsp;</div>	
					
			<table width="100%" border="0" cellspacing="0" cellpadding="0" >
			  <tr>
			    <td ><h3>'.ucfirst($groupFlag).'</h3></td>
			  </tr>
			  <tr>
			    <td >&nbsp;</td>
			  </tr>
			  <tr>
 	 			<td >
			    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="boxBorder" style="margin-top: 0px !important">
					<tr >
					  <td align="center" class="tdBorderTp">Sr. No.</td>
					  <td align="center" class="tdBorderTp">Service Name</td>
					  <td align="center" class="tdBorderTp">Date & Time</td>
					  <td align="center" class="tdBorderTp">CGHS Code</td>
					  <td align="center" class="tdBorderTp">Qty</td>
					  <td>Amount</td>
					</tr>'; 
			 
					if($labRate && $groupFlag=='laboratory'){
						$i=1;
						$Cost = 0 ; $t=0;
						foreach($labRate as $labKey=>$labCost){
							if($labCost['LaboratoryTestOrder']['amount'] > 0 ){
								$Cost += $labCost['LaboratoryTestOrder']['amount'] ;
							}else{
								$Cost += $labCost['TariffAmount'][$hosType] ;
							}
							$splitDateIn = explode(" ",$labCost['LaboratoryTestOrder']['create_time']);
							$html .='
									<tr>
								  		<td align="center" valign="" class="tdBorderTp">'.$i++.'</td>
								  		<td class="tdBorderTp">&nbsp;&nbsp;'.$labCost['Laboratory']['name'].'</td>
								  		<td class="tdBorderTp">&nbsp;&nbsp;'.$this->DateFormat->formatDate2Local($labCost['LaboratoryTestOrder']['create_time'],Configure::read('date_format'),true).'</td>
								  		<td align="center" valign="" class="tdBorderTp" >'.$labCost['TariffList']['cghs_code'].'</td>
								  		<td align="center" valign="" class="tdBorderTp">1</td>
								  		<td align="right" valign="" class="tdBorderOnlytop">'.$this->Number->format($labCost['LaboratoryTestOrder']['amount']).'</td>
								  	</tr>';
						}
					}
					
					if($radRate && $groupFlag=='radiology'){
						$j=1;
						$Cost = 0 ; $t=0; //echo '<pre>';print_r($radRate);
						$hosType = ($this->Session->read('hospitaltype')=='NABH')?'nabh_charges':'non_nabh_charges' ;
						foreach($radRate as $radKey=>$radCost){
							if($radCost['RadiologyTestOrder']['amount'] > 0){
								$Cost += $radCost['RadiologyTestOrder']['amount'] ;
								$formatRadCost = $radCost['RadiologyTestOrder']['amount'] ;
							}else{
								$Cost += $radCost['TariffAmount'][$nabhType] ;
								$formatRadCost = $radCost['TariffAmount'][$nabhType] ;
							}
							$splitDateIn = explode(" ",$radCost['RadiologyTestOrder']['create_time']);
							$html .='
									<tr>
								  		<td align="center" valign="" class="tdBorderTp">'.$j++.'</td>
								  		<td class="tdBorderTp">&nbsp;&nbsp;'.$radCost['Radiology']['name'].'</td>
								  		<td class="tdBorderTp">&nbsp;&nbsp;'.$this->DateFormat->formatDate2Local($radCost['RadiologyTestOrder']['create_time'],Configure::read('date_format'),true).'</td>
								  		<td align="center" valign="" class="tdBorderTp" >'.$radCost['TariffList']['cghs_code'].'</td>
								  		<td align="center" valign="" class="tdBorderTp">1</td>
								  		<td align="right" valign="" class="tdBorderOnlytop">'.$this->Number->format($formatRadCost).'</td>
								  	</tr>';
						}
					}
					 
			$html .='<tr>
					  	<td colspan="5" class="tdBorderTp" align="right"><strong>Sub Total</strong></td>
					  	<td class="tdBorderOnlytop" align="right"><strong>'. $Cost.'</strong></td>
				  	</tr>
				</table>
			 </td>
		   </tr>
		</table>';
			 
	 	
	// output the HTML content
	$tcpdf->writeHTML($html, true, false, true, false, 'middle');
	 
	// reset pointer to the last page
	$tcpdf->lastPage(); 
	//$tcpdf->set('encrypted',false);
	//Close and output PDF document
	echo $tcpdf->Output('List_Of_Laboratory_Test'.$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).'.pdf', 'D');
?>     
     