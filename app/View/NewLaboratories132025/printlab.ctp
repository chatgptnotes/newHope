<!DOCTYPE style PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<!-- <html moznomarginboxes mozdisallowselectionprint>
-->
<html moznomarginboxes mozdisallowselectionprint>
<head>
<title></title>
<style>
body {
	margin: 0px;
	padding: 0px;
}

@media print {
	#printButton {
		display: none;
	}
}

@page print { #
	printButton {display: none;
}

}
@page {
	size: auto;
	width: 94%;
	margin-left: auto;
	margin-right: auto;
	margin-top: 60mm;
	/* content: "Page " counter(page) " of " counter(pages); */
}

@page :first {
	size: auto;
	width: 94%;
	margin-left: auto;
	margin-right: auto;
	margin-top: 60mm;
}

table.labFooter tr {
	display: block;
}

table.labFooter td, table.labFooter th {
	display: inline-block;
}

#labFooter {
	display: table-footer-group;
}

#labFooter:after {
	counter-increment: page;
	content: counter(page);
}

/*@page {
		
		#printLabFooter {
        position: fixed;
        bottom: 0; 
		display: block;
		float:right;
		margin-top:-400px;
		}
       
    
}*/
</style>
</head>
<body>

<?php $orderId = $this->params->query['testOrderId'];?>
<div style="text-align: right;" id="printButton">
		&nbsp;

		<table align='right'>
			<tr>
			<?php
			
			if ($from != 'Preview') {
				//commented by Swapnil - no such authenticated user available in Hope  - 13.01.2015
				/*if (in_array ( $this->Session->read ( 'userid' ), $authenticated ) || $this->Session->read ( 'role' ) == 'External Radiologist') {*/
					?>
			<td>
				<?php echo $this->Html->link('Print','#',array('onclick'=>'window.print();','class'=>'blueBtn','escape'=>false,'id'=>'print'));?>	
			</td>
			<?php }else{?>
				<td id="">
								<?php echo $this->Html->link('Print','#',array('onclick'=>'','class'=>'grayBtn','escape'=>false,'id'=>''));?>
							</td>
			<?php }//}?>
		</tr>
		</table>

	</div>
	<div class="mainLabPrintDiv" id="mainLabPrintDiv" align="center">
		<table border="0" width="100%">
			<thead>
				<tr>
					<td>
						<table width="100%" border="0" align="center" cellspacing="0"
							cellpadding="0" class="formFull"
							style="margin: 0px; padding: 0px; border-top: 1px solid; border-left: 0px solid; border-right: 0px solid; padding-bottom: 0px; margin-bottom: 0px">
							<tr>
								<td valign="top">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="left"><?php echo __("Patient Name :");?>
					</td>
											<td><?php echo ucwords($patientData['Patient']['lookup_name']) ; ?>
					</td>
										</tr>
										<tr>
											<td align="left"><?php echo __("Patient ID :");?>
					</td>
											<td><?php echo $patientData['Person']['patient_uid']; ?>
					</td>
										</tr>
										<tr>
											<td align="left"><?php echo __("Ref By :");?>
					</td>
											<td><?php echo strtoupper($this->Session->read('location_name')) ; ?>
					</td>
										</tr>
				<?php if($patientData['Patient']['admission_type'] == 'IPD'){?>
				<tr>
											<td align="left"><?php echo __("Ward Name :");?>
					</td>
											<td><?php echo $patientData['Ward']['name'] ; ?>
					</td>
										</tr>
				<?php }?>
				<?php //if($getPanelSubLab[0]['Laboratory']['lab_type'] == '2'){?>
				 <tr>
											<td align="left"><?php echo __("Sample Received :");?>
					</td>
											<td><?php //echo $this->DateFormat->formatDate2Local($getPanelSubLab[0]['LaboratoryTestOrder']['sample_received'],Configure::read('date_format_us'),true);
											echo $this->DateFormat->formatDate2Local($getPanelSubLab[0]['LaboratoryResult']['report_date'],Configure::read('date_format_us'),true);
											?></td>
										</tr>
				<?php //}?>
				<tr>
											<td align="left"><?php echo __("Request No.:");?>
					</td>
											<td><?php echo $getPanelSubLab[0]['LaboratoryTestOrder']['req_no'];?></td>
										</tr>
									</table>
								</td>

								<td valign="top" align="right">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="left"><?php echo __("Age/Sex :");?>
					</td>
											<td><?php echo $patientData['Patient']['age'].__(" Yrs / ").ucfirst($patientData['Person']['sex']);?></td>
										</tr>

										<tr>
											<td align="left"><?php echo __("MRN NO :");?>
					</td>
											<td><?php echo $patientData['Patient']['admission_id']; ?>
					</td>
										</tr>

										<tr>
											<td align="left"><?php echo __("Report Date :");?>
					</td>
											<td><?php echo $this->DateFormat->formatDate2Local($getPanelSubLab[0]['LaboratoryResult']['report_date'],Configure::read('date_format_us'),true);?></td>
										</tr>
				<?php if($patientData['Patient']['admission_type'] == 'IPD'){?>
				<tr>
											<td align="left"><?php echo __("Bed No :");?>
					</td>
											<td><?php echo $patientData['Room']['name'];?> <?php echo $patientData['Bed']['bedno'];?></td>
										</tr>
				<?php }?>
				<tr>
											<td align="left"><?php echo __("Consultant Name :");?>
					</td>
											<td><?php echo $doctorData['User']['first_name'].$doctorData['User']['last_name'];?></td>
										</tr>
										<tr>
											<td align="left"><?php echo __("Provisional Diagnosis :");?>
					</td>
											<td>
					<?php
					$provDiagnosis = '';
					foreach ( $diagnosesName as $key => $newData ) {
						?>
					
					<?php
						
						if ($key < count ( $diagnosesName ) - 1) {
							$provDiagnosis .= $newData ['NoteDiagnosis'] ['diagnoses_name'] . ', ';
						} else {
							$provDiagnosis .= $newData ['NoteDiagnosis'] ['diagnoses_name'] . '.';
						}
						?>
					
					<?php
					}
					echo trim ( $provDiagnosis, "," )?>
					</td>
										</tr>

									</table>

								</td>

							</tr>
						</table>
					</td>
				</tr>
			</thead>
			<tbody>
<?php
$lastReportDepartmentName = '';
// echo count($getPanelSubLab);exit;
// pr($getPanelSubLab['1']);exit;
?>
<!--  For Regular section-->
<?php

if ($getPanelSubLab ['0'] ['Laboratory'] ['lab_type'] != 2) {
	
	foreach ( $getPanelSubLab as $key => $subData ) {
		?>


<?php
		$stls = "";
		$stl = '';
		if ($key == 0)
			$stl = "margin-bottom:2px;";
		$printReportHeader = 'No';
		$isStartOfReport = true;
		if (empty ( $lastReportDepartmentName )) {
			$lastReportDepartmentName = $subData ['TestGroup'] ['name'];
			$printReportHeader = 'Yes';
			$isStartOfReport = false;
		} else {
			if ($lastReportDepartmentName != $subData ['TestGroup'] ['name']) {
				$lastReportDepartmentName = $subData ['TestGroup'] ['name'];
				$printReportHeader = 'Yes';
			}
		}
		
		if (strtoupper (trim( $subData ['TestGroup'] ['name']))== 'SEROLOGY') {
			
			if($printReportHeader =='Yes'){
				$repHeader = ($lastReportDepartmentName) ? $lastReportDepartmentName : $subData ['Laboratory'] ['name'];
			?>
			<tr>
									<td colspan="3">
										<h2 align="center" style="text-decoration: underline;line-height:5px;padding-top:9px;margin-bottom:16px;<?php echo $stl;?>">
<?php
					
					echo __ ( "Report on " ) . $repHeader;
					?>
</h2>
									</td>

								</tr>
								<?php }?>
<tr>
					<td><div class="pagePrintCount" style="page-break-inside: avoid;">
							<table width="100%" border="0" cellspacing="0" cellpadding="3"
								style="margin: 0 auto; font-size: 12px;">
<?php
			$j = 0;$initSero =0;
			$prArray = $subData ['LaboratoryParameter'];
			usort ( $prArray, create_function ( '$a, $b', 'if ($a["id"] == $b["id"]) return 0; return ($a["id"] < $b["id"]) ? -1 : 1;' ) );
			$subData ['LaboratoryParameter'] = $prArray;
			foreach ( $subData ['LaboratoryParameter'] as $paraKey => $value ) {
				?>
				
				<?php
				
				if ($printReportHeader == 'Yes') {
					if ($isStartOfReport) {
						?>
						
				<!-- <tr><td style="border-bottom: 1px solid;line-height:5px;padding-top:10px;padding-bottom:2px" colspan="3">&nbsp;</td></tr> -->
				<?php }?>
				
				<?php //if($key==0){?>
				
				
				<?php }//}?>
				<?php if($initSero == 0){?>
				<tr>
									<td valign="middle" class="tdLabel" id="" colspan="2" style="font-size: 16px;"><b><?php echo $subData ['Laboratory'] ['name'];?></b>
									</td>
									
								</tr>
				<?php }?>
		<tr>
									<td width="40%" valign="middle" class="tdLabel" id="" ><b style="padding-left: 10px;"><?php echo $value['name'];?></b>
									</td>
									<td width="" valign="middle" class="tdLabel" id="" style="font-weight:bold;font-size:14px">
			<?php
				echo ': ' . $subData ['LaboratoryHl7Result'] [$paraKey] ['result'];
				?>
			</td>
								</tr>
								
		
		<?php if($subData['LaboratoryResult']['text']){?>
		<tr>
			<td colspan="2"><table style="padding-top:10px;">
			<tr>
									<td width="" valign="middle" class="tdLabel" id=""><b><?php echo ($subData['Laboratory']['notes_display_text'])?$subData['Laboratory']['notes_display_text']:__("Comments:");?>
			</b></td>
									<td width="" valign="top" class="tdLabel" id="">
			
			<?php
			$labNotes = explode("\r\n",$subData ['LaboratoryResult'] ['text']);
				//echo '' . str_replace ( "\r\n", "<BR>&nbsp;&nbsp;", $subData ['LaboratoryResult'] ['text'] );
				foreach($labNotes as $noteKey=>$noteValue){
				if(!empty($noteValue))
					echo "<span style='line-height:22px'>".$noteValue."</span><br>";
				}
				?>
			
			</td></tr></table></td>

								</tr>
		
		
		<?php }?>
		
	
<?php
$initSero++;
			}
			?>
			<?php if($subData ['Laboratory'] ['test_method']){?>
			<tr>
			<td colspan="2"><table>
			<tr>
									<td width="" valign="top" class="tdLabel" id=""><b><?php echo __('Method');?>
			</b></td>
									<td width="" valign="middle" class="tdLabel" id="">
			
			<?php
			$labMethod = explode("\r\n",$subData ['Laboratory'] ['test_method']);
				//echo '' . str_replace ( "\r\n", "<BR>&nbsp;&nbsp;", $subData ['LaboratoryResult'] ['test_method'] );
				foreach($labMethod as $noteKey=>$noteValue){
				if(!empty($noteValue))
					echo "<span style='line-height:22px'>".$noteValue."</span><br>";
				}
				?>
			
			</td>

								</tr>
								
								</table></td></tr>
								<?php }?>
			
	<?php if($subData['LaboratoryResult']['text']){?>
		<tr>
									<td width="20%" valign="middle" class="tdLabel" id=""><b><?php echo $subData['Laboratory']['notes_display_text'];?></b>
									</td>
									<td width="" valign="middle" class="tdLabel" id="">
			<?php
			$labNotes = explode("\r\n",$subData ['LaboratoryResult'] ['text']);
				//echo '' . str_replace ( "\r\n", "<BR>&nbsp;&nbsp;", $subData ['LaboratoryResult'] ['text'] );
				foreach($labNotes as $noteKey=>$noteValue){
				if(!empty($noteValue))
					echo "<span style='line-height:22px'>".$noteValue."</span><br>";
				}
				?>
			</td>

								</tr>
		<?php
			}
			if ($printReportHeader == 'Yes') {
				?>
	<!--  <tr><td style="border-bottom: 1px solid;line-height:5px;padding-top:10px" colspan="3">&nbsp;</td></tr>-->
	<?php }?>
		</table>
						</div></td>
				</tr>
	
<?php
		} else {
			if ($key != 0)
				$stls = "padding-top:9px;";
			?>
<tr>
					<td><div style="page-break-inside: avoid;" class="pagePrintCount">
							<table width="100%" border="0" cellspacing="0" cellpadding="3"
								style="margin: 0 auto; font-size: 12px;">
	<?php
			$repHeader = ($lastReportDepartmentName) ? $lastReportDepartmentName : $subData ['Laboratory'] ['name'];
			if ($printReportHeader == 'Yes') {
				if ($isStartOfReport) {
					if ($key == 0) {
						$stylss = 'padding-top:5px;';
						
						?>
					
				<tr>
									<td style="<?php echo $styl;?>line-height:5px;padding-top:10px;padding-bottom:2px" colspan="3">&nbsp;</td>
								</tr>
				<?php
					} else
						$stylss = '';
				}
				if ($key == 0)
					$stylss = 'padding-top:5px;';
				else
					$stylss = 'padding-top:5px;';
				?>
				<tr>
									<td colspan="3">
										<h2 align="center" style="text-decoration: underline;line-height:5px;margin-bottom:16px;<?php echo $stls.$stylss;?>">
<?php
				
				echo __ ( "Report on " ) . $repHeader;
				?>
</h2>
									</td>

								</tr>
				<?php }?>
				<?php if($printReportHeader == 'Yes'){?>
<tr>
									<td style="border-top: 1px solid; line-height: 1px;"
										colspan="3">&nbsp;</td>
								</tr>
								<tr>
									<td style="font-weight: bold; width: 45%"><?php echo __("INVESTIGATION");?></td>
									<td style="font-weight: bold;width:27% "><?php echo __("OBSERVED VALUE");?></td>
									<td style="font-weight: bold;width:27%"><?php echo __("NORMAL RANGE");?></td>
								</tr>
								<tr>
									<td style="border-bottom: 1px solid; line-height: 1px;"
										colspan="3">&nbsp;</td>
								</tr>
	 <?php }?>

	<?php
			$laboratoryName = $subData ['Laboratory'] ['name'];
			foreach ( $subData ['LaboratoryCategory'] as $labCatKey => $labCatValue ) {
				$isPrinted = 1;
				?>
				
				<tr>
									<td>
				<?php
				
				if ($subData ['Laboratory'] ['name'] && $labCatKey == 0) {
					// echo "<td style='padding-left:10px;'><b><i>".ucwords($subData['Laboratory']['name'])."<i></b></td>";
				} else {
					// echo "<td>&nbsp;</td>";
				}
				?>
				</td>
								</tr>	
				<?php
				$prArray = $subData ['LaboratoryParameter'];
				usort ( $prArray, create_function ( '$a, $b', 'if ($a["id"] == $b["id"]) return 0; return ($a["id"] < $b["id"]) ? -1 : 1;' ) );
				$subData ['LaboratoryParameter'] = $prArray;
				$initCount = 0;
				foreach ( $subData ['LaboratoryParameter'] as $paraKey => $value ) {
					$resultByRangeActive = false;
					$defaultRange = '';
					if ($value ['laboratory_categories_id'] == $labCatValue ['id']) {
						// echo $paraKey;
						if ($value ['type'] == 'text') {
							$defaultRange = $value ['parameter_text'];
						} else {
							if ($value ['by_gender_age'] == 'gender') {
								if ($patientData ['Person'] ['sex'] == 'male') { // if male
									$defaultRange = $value ['by_gender_male_lower_limit'] . " - " . $value ['by_gender_male_upper_limit'];
								} else { // female pArt
									$defaultRange = $value ['by_gender_female_lower_limit'] . " - " . $value ['by_gender_female_upper_limit'];
								}
							}
							if ($value ['by_gender_age'] == 'age') { // by Age
								$calAge = $this->DateFormat->age_from_dob ( $patientData ['Person'] ['dob'] );
								if (($value ['by_age_less_years'] == 1) && ($calAge < $value ['by_age_num_less_years'])) {
									$defaultRange = $value ['by_age_num_less_years_lower_limit'] . " - " . $value ['by_age_num_less_years_upper_limit'];
								} elseif (($value ['by_age_more_years'] == 1) && ($calAge > $value ['by_age_num_more_years'])) {
									$defaultRange = $value ['by_age_num_gret_years_lower_limit'] . " - " . $value ['by_age_num_gret_years_upper_limit'];
								} else {
									$defaultRange = $value ['by_age_between_years_lower_limit'] . " - " . $value ['by_age_between_years_upper_limit'];
								}
							}
							if ($value ['by_gender_age'] == 'range') { // by Range
							                                           // $defaultRange = '> '.$value['by_range_less_than_limit']. ' ' .$value['by_range_less_than_interpretation'].'<br>< '.$value['by_range_greater_than_limit'].' '.$value['by_range_greater_than_interpretation'];
								$defaultRange .= ($value ['by_range_less_than_limit']) ? '< ' . $value ['by_range_less_than_limit'] : ' ';
								$defaultRange .= ($value ['by_range_less_than_interpretation']) ? ' ' . $value ['by_range_less_than_interpretation'] . '<br>' : '<br>';
								$defaultRange .= ($value ['by_range_greater_than_limit']) ? '> ' . $value ['by_range_greater_than_limit'] : ' ';
								$defaultRange .= ($value ['by_range_greater_than_interpretation']) ? ' ' . $value ['by_range_greater_than_interpretation'] . '<br>' : '<br>';
								$defaultRange .= ($value ['by_range_between_lower_limit']) ? $value ['by_range_between_lower_limit'] . ' - ' : ' ';
								$defaultRange .= ($value ['by_range_between_upper_limit']) ? $value ['by_range_between_upper_limit'] : ' ';
								$defaultRange .= ($value ['by_range_between_interpretation']) ? ' ' . $value ['by_range_between_interpretation'] : '';
							}
						}
						if ($subData ['LaboratoryHl7Result'] [$paraKey] [abnormal_flag] == 'L') {
							$flag = 'Below low normal';
						} else if ($subData ['LaboratoryHl7Result'] [$paraKey] [abnormal_flag] == 'LL') {
							$flag = "Below lower panic limits";
						} else if ($subData ['LaboratoryHl7Result'] [$paraKey] [abnormal_flag] == '<') {
							$flag = "Below absolute low-off instrument scale";
						} else if ($subData ['LaboratoryHl7Result'] [$paraKey] [abnormal_flag] == 'H') {
							$flag = "Above high normal";
						} else if ($subData ['LaboratoryHl7Result'] [$paraKey] [abnormal_flag] == 'HH') {
							$flag = "Above upper panic limits";
						} else if ($subData ['LaboratoryHl7Result'] [$paraKey] [abnormal_flag] == '>') {
							$flag = "Above absolute high-off instrument scale";
						} else if ($subData ['LaboratoryHl7Result'] [$paraKey] [abnormal_flag] == 'N') {
							$flag = "Normal";
						}
						
						if (empty ( $defaultResultParam )) {
							if ($value ['type'] == 'text') {
								if ($value ['is_multiple_options']) {
									$isMultiple = true;
									$defaultRange = '';
								}
							}
						}
						$defaultRange = trim($defaultRange);
						?>
	<?php if($subData['LaboratoryHl7Result'][$paraKey]['result']){?>
		<?php if($initCount ==0){?>
		<tr>
									<td width="" valign="middle" class="tdLabel" id=""
										style="width: 45%; font-size: 16px;" colspan="2"><b>
			<?php echo $subData['Laboratory']['name'];?>
		</b></td>
								</tr>
		<?php } ?>
		<tr>
									<td width="" valign="middle" class="tdLabel" id=""
										style="width: 45%;">
										<div style="padding-left: 10px;">
											<div>
												<b><i>
				<?php
							if ($isPrinted) {
								echo $labCatValue ['category_name'];
								$isPrinted = 0;
								if ($labCatValue ['is_category']) {
									$isPrintedFirstTime = '<div style="padding-top:8px;">&nbsp;</div>';
									$isPrintedFirstTimeStyle = "padding-top:8px;";
								}
							}
							?>
			</i></b>
											</div>
											<div style="padding-left:25px;<?php echo $isPrintedFirstTimeStyle;?>" >
			<?php
							if ($labCatValue ['is_category']) {
								echo $value ['name']; // attribute name
							}
							?>
				</div>
										</div>
									</td>

									<td width="" valign="middle" class="tdLabel" id="" style="width:27% <?php echo $isPrintedFirstTimeStyle;?>">
				<?php
							$unitData = ($optUcums [$value ['unit']]) ? $optUcums [$value ['unit']] : $value ['unit_txt'];
							echo $isPrintedFirstTime . $subData ['LaboratoryHl7Result'] [$paraKey] ['result'] . " " . $unitData . "";
							
							?>
			</td>
									<td width="" valign="middle" class="tdLabel" id="" style="width:27% <?php echo $isPrintedFirstTimeStyle;?>">
				<?php
							
							echo $isPrintedFirstTime . $defaultRange . " " . $unitData;
							$isPrintedFirstTime = '';
							$isPrintedFirstTimeStyle = '';
							?>
			</td>
								</tr>
		<?php } ?>
		<?php
						
						$laboratoryName = '';
						$j ++;
						unset ( $value ['id'] );
					} // End of Laboratory Parameter
					$initCount ++;
				} // End of if
			}
			?>
			<?php if($subData ['Laboratory'] ['test_method']){?>
			<tr>
			<td colspan="2"><table>
			<tr>
									<td width="20%" valign="middle" class="tdLabel" id=""><b><?php echo __('Method');?>
			</b></td>
									<td width="" valign="middle" class="tdLabel" id="">
			<?php
			$labMethod = explode("\r\n",$subData ['Laboratory'] ['test_method']);
				//echo '' . str_replace ( "\r\n", "<BR>&nbsp;&nbsp;", $subData ['LaboratoryResult'] ['test_method'] );
				foreach($labMethod as $noteKey=>$noteValue){
				if(!empty($noteValue))
					echo "<span style='line-height:22px'>".$noteValue."</span><br>";
				}
				?>
			</td>

								</tr>
								
								</table></td></tr>
								<?php }?>
		
		<?php if($subData['LaboratoryResult']['text']){?>
		<tr>
			<td colspan="2"><table  style="padding-top:10px;">
			<tr>
									<td width="" valign="middle" class="tdLabel" id="" style=""><b><?php echo ($subData['Laboratory']['notes_display_text'])?$subData['Laboratory']['notes_display_text']:__("Comments:");?>
			</b></td>
									<td width="" valign="top" class="tdLabel" id="">
			
			<?php
			$labNotes = explode("\r\n",$subData ['LaboratoryResult'] ['text']);
				//echo '' . str_replace ( "\r\n", "<BR>&nbsp;&nbsp;", $subData ['LaboratoryResult'] ['text'] );
				foreach($labNotes as $noteKey=>$noteValue){
				if(!empty($noteValue))
					echo "<span style='line-height:22px'>".$noteValue."</span><br>";
				}
				?>
			
			</td></tr></table></td>

								</tr>
								<!--
								<tr>
									<td style="border-bottom: 1px solid; line-height: 1px;"
										colspan="3">&nbsp;</td>
								</tr>-->
		<?php
			}
			// if($printReportHeader == 'Yes'){
			?>
		<!--  <tr><td style="border-bottom: 1px solid;line-height:5px;padding-top:10px" colspan="3">&nbsp;</td></tr>-->
		<?php // }?>
		</table>
						</div></td>
				</tr>
		
		<?php
		} // End of Laboratory Main Loop
		?>
		
<?php
		$lastReportDepartmentName = ($subData ['TestGroup'] ['name']) ? $subData ['TestGroup'] ['name'] : $subData ['Laboraory'] ['name'];
	} // end of serology
	?>
		


<?php }else{?>

<!--  END OF Regular section-->

				<!-- Start of Histology  -->
				<table width="100%" border="0" cellspacing="0" cellpadding="4"
					style="margin: 0 auto; font-size: 12px; line-height: 25px;">

					<h2 align="center"
						style="text-decoration: underline; line-height: 5px; padding-top: 9px; margin-bottom: 16px;">
			<?php  echo ucwords($getPanelSubLab[0]['Laboratory']['name'])?>
		  </h2>
		<?php foreach($getPanelSubLab[0]['LaboratoryParameter'] as $key => $value){
		
			if(!$getPanelSubLab[0]['LaboratoryHl7Result'][$key]['observations']) continue ; //added to skip head without data
			
			?>
		
		<tr>
						<td><b><u><?php echo $value['name']?></u></b></td>
					</tr>
					<tr>
						<td style="padding-left: 20px" width="20%"><?php echo $getPanelSubLab[0]['LaboratoryHl7Result'][$key]['observations']?></td>
					</tr>
		
	<?php }?>
		<tr>
						<td align="center"><?php echo ("-------------------------------End Of Report----------------------------");?></td>
					</tr>
				</table>

<?php }?>
<!-- END OF Histology -->

			</tbody>

			<tfoot>
<tr>
									<td 
										colspan="3"><hr style="border: 1px solid; line-height: 1px;"></td>
								</tr>
				<tr>
					<td>
						<?php if($getPanelSubLab[0]['Laboratory']['lab_type'] == '2'){?>
						<table width="100%" class="labFooter" style="float: right">
							<tr>
								<td align="right"  width='100%'>  
								<p
													style="line-height: 1px; padding-top: 25px; padding-right: 37px;"><?php echo  strtoupper(Configure::read('pathology_doctor_authority_name_sec'));?></p>
												<p
													style="line-height: 1px; padding-top: 5px; padding-right: 20px;"><?php echo  strtoupper(Configure::read('pathology_doctor_authority_designation_sec'));?></p>
								
								</td> 
							</tr>
						</table>
						<?php }else{?>
						<table width="100%" class="labFooter" style="float: right">
							<tr>
								<td align="left" width='50%'>  
								<p
													style="line-height: 1px; padding-top: 25px; padding-right: 20px;"><?php echo  strtoupper(Configure::read('pathology_doctor_authority_name_sec'));?></p>
												<p
													style="line-height: 1px; padding-top: 5px; padding-right: 20px;"><?php echo  strtoupper(Configure::read('pathology_doctor_authority_designation_sec'));?></p>
								
								</td>
								<td align="right" width='47%'>
									<table>
										<tr>			 
											<td width="100%" align="right">
												<p
													style="line-height: 1px; padding-top: 25px; padding-right: 58px;"><?php echo  strtoupper(Configure::read('pathology_doctor_authority_name'));?></p>
												<p
													style="line-height: 1px; padding-top: 5px; padding-right: 20px;"><?php echo  strtoupper(Configure::read('pathology_doctor_authority_designation'));?></p>
											</td>
					 
										</tr>
									</table>
								</td>
							</tr>
						</table>
						<?php } ?>
					</td>
				</tr>
			</tfoot>
		</table>
	</div>

	<script>
	$('#print').click(function(){
		$.ajax({
			  type : "POST",
			  url: "<?php echo $this->Html->url(array("controller" => "new_laboratories", "action" => "isPrint",$orderId)); ?>",
			  beforeSend:function(){
				  $('#busy-indicator').show();
			  }, 	  		  
			  success: function(data){
				  $('#busy-indicator').hide();
			  },
		});
	});		

	$( document ).ready(function() {
		var counter =1;
		$( ".pagePrintCount" ).each(function( index ) {
			console.log(counter);
			counter++;
		});
	});
</script>

</body>
</html>
