<?php
	if($type=='excel'){ 
		//BOF excel
		
		//header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
		//header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
	  	header ("Cache-Control: no-cache, must-revalidate");
		header ("Pragma: no-cache");
		header ("Content-type: application/vnd.ms-excel");
		//header ("Content-Disposition: attachment; filename=\"Complaints_report_".date('d-m-Y').".xls");
		header ("Content-Disposition: attachment; filename=\"Complaints_Report".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls");
		header ("Content-Description: Complaints Report" ); 
		?>
		<?php //echo $content_for_layout ?> 
		
		<STYLE type='text/css'>
			.tableTd {
			   	border-width: 0.5pt; 
				border: solid; 
			}
			.tableTdContent{
				border-width: 0.5pt; 
				border: solid;
			}
			#titles{
				font-weight: bolder;
			}
		   
		</STYLE>
		<table border='1' class='table_format'  cellpadding='0' cellspacing='0' width='100%' style='text-align:left;padding-top:50px;'>
			  <tr class='row_title'> 
				   <td colspan="5" width="100%" height='30px' align='center' valign='middle'><h2><?php echo __('Complaints Report').' - '.$year; ?></h2></td>
			  </tr>
			  				  
			  <tr class='row_title'> 
			        <td height="30px" align="center" valign="middle"><strong>Sr.No.</strong></td>	
				   <td height="30px" align="center" valign="middle"><strong>Month</strong></td>					   
				   <td height="30px" align="center" valign="middle"><strong>Total Complaints</strong></td>
				   <td height="30px" align="center" valign="middle"><strong>Total Complaints Resolved</strong></td>
				   <td height="30px" align="center" valign="middle"><strong>Average Resolutaion Time Taken </strong></td> 
			  </tr>
		 	  <?php
			    $complaintCnt=0;
			    if(count($complaintData) > 0) {
		 	  	foreach($complaintData as $monKey=>$mon){
                    $complaintCnt++;
				 	$monthName = $mon[0]['month'] ;
				?> 
					<tr>
					    <td align='center' height='17px'><?php echo $complaintCnt ; ?></td>
						<td align='center' height='17px'><?php echo $monthName ; ?></td>
						<td align='center' height='17px'><?php echo $mon[0]['count'] ; ?></td>
						<td align="center" height="17px"><?php echo $complaintResolvedData[$monKey][0]['count'] ?></td>
						<td align="center" height="17px"><?php echo $this->DateFormat->getTimeStringFormSec(array_sum($timeTaken[$monthName])/count($timeTaken[$monthName]))?> 
						</td>
					 </tr> 
				<?php } } else { ?>
				  <tr > 
				   <td colspan="5"  align='center' valign='middle'>No Record Found</td>
			  </tr>
				<?php } ?>
		</table>
<?php 
	}else if($type=='pdf'){
		 
		//App::import('Vendor','xtcpdf'); 
		//$tcpdf = new XTCPDF();	
		//ob_clean();
		App::import('Vendor','tcpdf/config/lang/eng'); 
		App::import('Vendor','tcpdf/tcpdf');
		$facilityname = ucfirst($this->Session->read("facility"));
	$headerimage = $this->Session->read("header_image");
	$facilitynamewithreport;
	
	if(empty($facilityname)) {
	  	$facilitynamewithreport = 'Complaints Report'.' - '.$year;
	  	$facilityname = "";
	}
	else {
	    $headerString = "by ".$facilityname ;
		$facilitynamewithreport = $facilityname.'-Complaints Report'.' - '.$year;
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
		   
			<table border="1" class="table_format"  cellpadding="2" cellspacing="0" width="100%" style="text-align:left;padding-top:50px;">			
					  
				<tr class="row_title" style="background-color:#A1B6BE;">
				   <td height="30px" align="center" valign="middle"><strong>Sr.No.</strong></td>
				   <td height="30px" align="center" valign="middle"><strong>Month</strong></td>					   
				   <td height="30px" align="center" valign="middle"><strong>Total Complaints</strong></td>
				   <td height="30px" align="center" valign="middle"><strong>Total Complaints Resolved</strong></td>
				   <td height="30px" align="center" valign="middle"><strong>Average Resolutaion Time Taken </strong></td> </tr>';
				    $complaintCnt=0;
				 if(count($complaintData) > 0) {
				 foreach($complaintData as $monKey=>$mon){
					$complaintCnt++;
				 	$monthName = $mon[0]['month'] ;
				 	 
					$html .='<tr>
					            <td align="center" height="17px">'.$complaintCnt.'</td>
								<td align="center" height="17px">'.$monthName.'</td>
								<td align="center" height="17px">'.$mon[0]['count'].'</td>
								<td align="center" height="17px">'.$complaintResolvedData[$monKey][0]['count'].'</td>
								<td align="center" height="17px">'.$this->DateFormat->getTimeStringFormSec(array_sum($timeTaken[$monthName])/count($timeTaken[$monthName])).' 
						</td>
					 </tr> ';
				  }
				 } else {
                   $html .='<tr><td colspan="5" align="center">No Record Found</td></tr>';
				 }
				 $html .='</table>' ;
	 
		
		// output the HTML content
		$tcpdf->writeHTML($html, true, false, true, false, '');
		 
		// reset pointer to the last page
		$tcpdf->lastPage(); 
		
		//Close and output PDF document
		//echo $tcpdf->Output('Complaints_report_'.date('d-m-Y').'.pdf', 'D');
		echo $tcpdf->Output('Complaints_Report'.$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).'.pdf', 'D');
		
	 
	}else if($type=='chart'){
		App::import('Vendor', 'fusion_charts'); 
		echo $this->Html->script(array('/fusioncharts/fusioncharts'));
	?>
		<div class="inner_title">
		<h3><?php echo __('Complaints', true).' - '.$year; ?></h3>
		</div>
		<div class="clr ht5"></div>
		 <div>
		    <?php
			$graph= new FusionCharts(); 
		
				
			//Initialize <graph> element
			$strXML = "<graph caption='Complaints received and resolved per month' xaxisname='Months' yaxisname='Count'  yAxisMaxValue='20' decimalPrecision='0'  numberSuffix=''   >";
		 
			//Initialize <categories> element - necessary to generate a multi-series chart
			$strCategories = "<categories>";
			
			//Initiate <dataset> elements
			$strDataSSI = "<dataset seriesName='Total Complaints' color='AFD8F8'>"; 
			$strDataResolved = "<dataset seriesName='Resolved Complaints' color='F6BD0F'>"; 
		     
		 	$monthIndex = 0;
		 	foreach($complaintData as $monKey=>$mon){
				 
				$arrData[$mon[0]['month']][1] = $mon[0]['month'];
		 		$arrData[$mon[0]['month']][2] = $mon[0]['count'];
		 		$arrData[$mon[0]['month']][3] = $complaintResolvedData[$monKey][0]['count'];
		 	}
			
			//Iterate through the data  
			foreach ($arrData as $arSubData) {
		        //Append <category name='...' /> to strCategories
		        $strCategories .= "<category name='" . $arSubData[1] . "' />";
		        //Add <set value='...' /> to both the datasets
		        $strDataSSI .= "<set value='" . $arSubData[2] . "' />";
		        $strDataResolved .= "<set value='" . $arSubData[3] . "' />";
			}
			
			//Close <categories> element
			$strCategories .= "</categories>";
			
			//Close <dataset> elements
		    $strDataSSI .= "</dataset>";
		     $strDataResolved .="</dataset>";
		
			
			//Assemble the entire XML now
			$strXML .= $strCategories.$strDataSSI.$strDataResolved. "</graph>";
			
			//Create the chart - Column 3D Chart with data from strXML variable using dataXML method
			echo $graph->renderChart($this->Html->url("/fusioncharts/FCF_MSColumn3D.swf"), "", $strXML, "myNext", 800, 500);
		        
		   ?>
		  </div> 
		  <?php 
		  	//BOF chart for time taken ?>
		  		 
				<div class="clr ht5"></div>
				 <div>
				    <?php
					 $graph1= new FusionCharts();	
					//Initialize <graph> element
					$strXML1 = "<graph caption='Time taken for Complaint resolution(In min)' xaxisname='Months' yaxisname='Minutes'  yAxisMaxValue='100' decimalPrecision='0'  numberSuffix=''   >";
				 
					//Initialize <categories> element - necessary to generate a multi-series chart
					$strCategories1 = "<categories>";
					
					//Initiate <dataset> elements
					$strDataSSI1 = "<dataset seriesName='Time taken for complaint resolution' color='AFD8F8'>"; 
					 
				     
				 	$monthIndex = 0;
				 	foreach($complaintData as $monKey=>$mon){
				 		$monthName = $mon[0]['month'];
						$avgTime1 = (array_sum($timeTaken[$monthName])/count($timeTaken[$monthName]))/60;
						$arrData1[$mon[0]['month']][1] = $mon[0]['month'];
				 		$arrData1[$mon[0]['month']][2] = $avgTime1; 
				 	} 
				 
					//Iterate through the data  
					foreach ($arrData1 as $arSubData1) {
				        //Append <category name='...' /> to strCategories
				        $strCategories1 .= "<category name='" . $arSubData1[1] . "' />";
				        //Add <set value='...' /> to both the datasets
				        $strDataSSI1 .= "<set value='" . $arSubData1[2] . "' />";
				         
					}
					
					//Close <categories> element
					$strCategories1 .= "</categories>";
					
					//Close <dataset> elements
				    $strDataSSI1 .= "</dataset>";
				      
				
					
					//Assemble the entire XML now
					$strXML1 .= $strCategories1.$strDataSSI1. "</graph>";
					
					//Create the chart - Column 3D Chart with data from strXML variable using dataXML method
					echo $graph1->renderChart($this->Html->url("/fusioncharts/FCF_MSColumn3D.swf"), "", $strXML1, "myNext1", 900, 500);
				        
				   ?>
				  </div> 
				  <?php   
		  	//EOF chart for time taken
		  ?>         
		   <div class="btns" style="padding-right: 105px;">
		           <?php echo $this->Html->link(__('Back'),array('controller'=>'reports','action'=>'complaints', 'admin'=>true),array('class'=>'grayBtn','div'=>false)); ?>
		   </div>
	<?php 
		}
		//EOF excel
?>