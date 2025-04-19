<style>
#boxspace {
	border-right: 0.3px solid #384144;
	padding-right: 5px;
}
</style>
<style>
#printButton {
	position: relative !important;
}

.abnormalResult {
	color: red;
}
</style>



<center>
	<h1>Result</h1>
</center>
<?php //echo "<pre>"; print_r($testid);?>
<div style="text-align: right;">
	&nbsp;
	<?php
	/*
	 * if(empty($noteId)){
	 * $testid = $get_lab_result['0']['LaboratoryResult']['laboratory_test_order_id'];
	 * echo $this->Html->link(__('Edit Result'), array('controller'=>'Laboratories','action' => 'editLabTestResultLri',$testid,$patientData['Patient']['id']),array('class'=>'blueBtn'));
	 * }
	 */
	?>
	<style>
#printButton {
	position: relative !important;
}
</style>
	<table align='right'>
		<tr>
			<td>
			<?php
			
			if ($this->params->query ['from'] == 'list') {
				echo $this->Html->link ( Back, array (
						'controller' => 'Laboratories',
						'action' => 'labTestHl7List',
						$this->params->query ['patientId'] 
				), array (
						'escape' => false,
						'class' => 'blueBtn' 
				) );
			}
			?>
			</td>
			<td id="printButton">
				<?php echo $this->Html->link('Print','#',array('onclick'=>'window.print();','class'=>'blueBtn','escape'=>false));?>	
			</td>
		</tr>
	</table>
	<!--  
	<?php //if($this->params->query['from']=='list'){?>
	<div>
	
		<?php
		// echo $this->Html->link(Back,array('controller'=>'Laboratories','action'=>'labTestHl7List',$this->params->query['patientId']),array('escape'=>false,'class'=>'blueBtn'));
		?>
	</div>
	<?php //"&nbsp;"?>
	<?php //}?>
   <div style="float:right;" id="printButton">
		<?php //echo $this->Html->link('Print','#',array('onclick'=>'window.print();','class'=>'blueBtn','escape'=>false));?>
	</div>
	-->
</div>
<div>&nbsp;</div>


<table width="100%" border="0" cellspacing="0" cellpadding="0"
	class="formFull"
	style="margin: 0px; padding: 0px; border-bottom: 5px solid;">
	<tr>
		<td width="50%">
			<table width="100%" border="0" cellspacing="0" cellpadding="0"
				style="margin: 0px; margin-left: 25px;">
				<tr>
					<td><h3>
							<?php echo $patientData['Person']['first_name'].' ' .$patientData['Person']['last_name'];?>
						</h3></td>
				</tr>
				<tr>
					<td><?php
					if ($patientData ['Person'] ['person_city_code']) {
						echo $this->General->formatPhone ( $patientData ['Person'] ['person_city_code'] . $patientData ['Person'] ['person_local_number'] );
						if ($patientData ['Person'] ['person_city_code'])
							echo 'X' . $patientData ['Person'] ['person_extension'];
					} else {
						$patientData ['Person'] ['person_lindline_no'];
					}
					?>
					</td>
				</tr>
			</table>
		</td>
		<td width="50%">
			<table width="100%" border="0" cellspacing="0" cellpadding="0"
				style="margin-right: 25px;" align="right">
				<tr>
					<td align="right"><?php
					echo $this->Session->read ( 'location_name' ) . '<br>';
					if ($this->Session->read ( 'location_address2' ))
						$address2 = ', ' . $this->Session->read ( 'location_address2' ) . '';
					else
						$address2 = '';
					if ($clientInfo ['State'] ['name'])
						$state = ', ' . $clientInfo ['State'] ['name'] . ', ';
					else
						$state = '';
					echo $this->Session->read ( 'location_address1' ) . $address2 . '<br>' . $clientInfo ['City'] ['name'] . $state . $clientInfo ['Facility'] ['zipcode'] . '<br>';
					echo $this->General->formatPhone ( $this->Session->read ( 'location_phone1' ) );
					?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0"
				style="margin-left: 25px;">
				<tr>
					<td align="left" width="25%"><?php echo __("DrM Patient ID :");?>
					</td>
					<td><?php echo $patientData['Person']['patient_uid']; ?>
					</td>
				</tr>

				<tr>
					<td align="left"><?php echo __("MRI NO :");?>
					</td>
					<td><?php echo $patientData['Patient']['admission_id']; ?>
					</td>
				</tr>
				<tr>
					<td align="left"><?php echo __("DOB");?>
					</td>
					<td><?php
					
					echo $this->DateFormat->formatDate2Local ( $patientData ['Person'] ['dob'], Configure::read ( 'date_format' ) );
					?>
					</td>
				</tr>
				<tr>
					<td align="left"><?php echo __("Gender");?>
					</td>
					<td><?php echo $patientData['Person']['sex'];?></td>
				</tr>

			</table>
		</td>
		<td width="50%">
			<table width="100%" border="0" cellspacing="0" cellpadding="0"
				style="margin-right: 25px;">
				<tr>
					<td align="right"
						style="padding: 25px; padding-right: 25px; font-size: 18px;"><?php
						echo __ ( "FINAL RESULT" );
						?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<?php //pr($get_lab_result);//pr(unserialize($get_lab_result['LaboratoryToken']['question']));?>
<?php $reportDone = false;?>
<table width="100%" border="0" cellspacing="0" cellpadding="0"
	style="margin: 0 auto; border-bottom: 1px solid; font-size: 12px; line-height: 25px; padding: 10px 0;">
	<tr>
		<td width="12%"><?php echo __("Accession ID:");?></td>
		<td style="width: 15%;"><?php echo $get_lab_result_main['LaboratoryTestOrder']['order_id'];?>
		</td>
		<td width="10%"><?php echo __("Lab Ref#:");?></td>
		<td><?php echo ($get_lab_result['LaboratoryResult']['ogi_placer_group_number'])?$get_lab_result['LaboratoryResult']['ogi_placer_group_number']:'';?></td>
	</tr>
	<tr>
		<td><?php echo __("Specimen Source:");?></td>
		<td><?php
		
		echo ($get_lab_result_main ['LaboratoryTestOrder'] ['specimen_type_option']) ? $get_lab_result_main ['LaboratoryTestOrder'] ['specimen_type_option'] : 'Not Available';
		if (empty ( $get_lab_result_main ['LaboratoryTestOrder'] ['specimen_type_option'] )) {
			$desSpec = 'Not Available';
		} else {
			$desSpec = $get_lab_result_main ['LaboratoryTestOrder'] ['specimen_type_option'];
		}
		?>
		</td>
		<td><?php echo __("Specimen Description:");?></td>
		<td><?php echo ($get_lab_result_main['LaboratoryTestOrder']['specimen_description'])?$get_lab_result_main['LaboratoryTestOrder']['specimen_description']:$desSpec;?>
		</td>
	</tr>
</table>
<table width="50%" border="0" cellspacing="0" cellpadding="0"
	style="margin: 0 auto; font-size: 12px; line-height: 25px; padding: 10px 0; float: left">
	<tr>
		<td width="50%"><?php echo __("Coll. Date:");?></td>
		<td width="50%" style="float: left"><?php echo ($get_lab_result_main['LaboratoryTestOrder']['lab_order_date'])?$this->DateFormat->formatDate2Local($get_lab_result_main['LaboratoryTestOrder']['lab_order_date'],Configure::read('date_format'),true):''; ?>
		</td>
	</tr>
	<tr>
		<td width="50%"><?php echo __("Order Date:");?></td>
		<td width="50%"><?php echo ($get_lab_result_main['LaboratoryTestOrder']['start_date'])?$this->DateFormat->formatDate2Local($get_lab_result_main['LaboratoryTestOrder']['start_date'],Configure::read('date_format'),true):'';?>
		</td>
	</tr>
	<tr>
		<td><?php echo __("Report:");?></td>
		<td><?php echo ($get_lab_result['LaboratoryResult']['od_observation_start_date_time'])?date("m/d/Y g:i A",strtotime($get_lab_result['LaboratoryResult']['od_observation_start_date_time'])):'';?>
		</td>
	</tr>
	<tr>
		<td width="50%"><?php echo __("Received:");?></td>
		<td><?php echo ($get_lab_result['LaboratoryResult']['od_observation_date_time'])?date("m/d/Y g:i A",strtotime($get_lab_result['LaboratoryResult']['od_observation_date_time'])):'';?>
		</td>
	</tr>

</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0"
	style="margin: 0 auto; border-bottom: 1px solid; font-size: 12px; float: left">
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0"
	style="margin: 0 auto; border-bottom: 1px solid; font-size: 12px; line-height: 25px; padding: 10px 0;">
	<tr>
		<td width="10%"><?php echo __("Requesting Physician:");?></td>
		<td width="15%"><?php echo $get_lab_result_main['LaboratoryResult']['op_name']; ?>
		</td>
		<td width="10%"><?php echo __("Ordering Physician:");?></td>
		<td><?php echo $get_lab_result_main['LaboratoryResult']['op_name']; ?>
		</td>
	</tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0"
	style="margin: 0 auto; padding-top: 15px">
	<tr>
		<td><h2>
				<?php
				if (($get_lab_result_main ['LaboratoryResult'] ['od_universal_service_text']))
					echo $get_lab_result_main ['LaboratoryResult'] ['od_universal_service_text'];
				else
					echo $get_lab_result ['Laboratory'] ['name'];
				?>
			</h2></td>
	</tr>
</table>

<!-- CULTURE & SENSITIVITY REPORT STARTS -->

<?php if(stripos(strtolower($get_lab_result['Laboratory']['name']), 'culture') || stripos(strtolower($get_lab_result['Laboratory']['name']), 'sensitivity')){?>
<table width="100%" border="0" cellspacing="0" cellpadding="0"
	style="margin: 0 auto; border-bottom: 1px solid; font-size: 12px; line-height: 25px; padding: 10px 0;">
	<tr>
		<td valign="top" width="5%"><?php //echo $get_lab_result['LaboratoryHl7Result']['0']['Laboratory']['name'];?>
		</td>
		<?php $reportArray = explode("\\.br\\",$get_lab_result['LaboratoryHl7Result1']['result']);?>
		<?php //debug($reportArray);?>
		<td width="15%"><?php
	for($i = 0; $i <= count ( $reportArray ); $i ++) {
		$resExpl = explode ( "{{break}}", $reportArray [$i] );
		foreach ( $resExpl as $resExplKey => $resExplValue ) {
			// echo __($resExplValue)."<br>";
		}
	}
	?>
		</td>
	</tr>
	<?php foreach($get_lab_result['LaboratoryHl7Result'] as $labView){ ?>
	<?php if(strtolower($labView['LaboratoryHl7Result']['observations']) == 'organism'){?>
	<tr>
		<td><?php echo __($labView['LaboratoryHl7Result']['observations']);?></td>
		<td><?php
			$resExpl = explode ( "{{break}}", $labView ['LaboratoryHl7Result'] ['result'] );
			foreach ( $resExpl as $resExplKey => $resExplValue ) {
				// echo __($resExplValue)."<br>";
			}
			?></td>
	</tr>
	<?php }?>
	<?php }?>
</table>
<?php }?>

<!-- CULTURE & SENSITIVITY REPORT ENDS -->



<!-- CULTURE & SENSITIVITY REPORT STARTS REAL -->

<?php //debug($get_lab_result);?>
<?php if(stripos(strtolower($get_lab_result['Laboratory']['name']), 'culture') || stripos(strtolower($get_lab_result['Laboratory']['name']), 'sensitivity')){ ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0"
	style="margin: 0 auto; font-size: 12px;">
	<tr>
		<td><h4><?php echo __("Final - Approved ").date("m/d/Y g:i A",strtotime($get_lab_result['LaboratoryResult']['od_observation_start_date_time']));?></h4></td>
	</tr>
</table>
<table width="100%" border="0" cellspacing="12" cellpadding="0"
	style="margin: 0 auto; padding-top: 5px; font-size: 12px;">
	<tr>
		<td width="30%" style="font-weight: bold;"><?php echo __("Comments:");?>
		</td>
	</tr>
	<?php $loopCount = 0; ?>
	<?php
	
	foreach ( $get_lab_result ['LaboratoryHl7Result'] as $labView ) {
		if ($labView ['LaboratoryHl7Result'] ['is_sensitivity'] == 1) {
			$isSensitivity = true;
			break;
		}
		?>
	<?php
		
		if ($loopCount == 0) {
			// $loopCount++;
			// continue;
		} else {
			$loopCount ++;
		}
		?>
	<tr>
		<td><?php
		if ($labView ['LaboratoryHl7Result'] ['observation_alt_text']) {
			echo ucfirst ( $labView ['Laboratory'] ['name'] );
		}
		if ($labView ['Laboratory'] ['name']) {
			echo ucfirst ( $labView ['Laboratory'] ['name'] );
		} else {
			echo ucfirst ( $labView ['LaboratoryHl7Result'] ['observations'] );
		}
		?></td>
		<td><?php
		// print_r($labView['LaboratoryHl7Result']['result']);exit;
		$resExpl = explode ( "{{break}}", $labView ['LaboratoryHl7Result'] ['result'] );
		foreach ( $resExpl as $resExplKey => $resExplValue ) {
			echo __ ( $resExplValue ) . "<br>";
		}
		?></td>
		<td><?php echo __($labView['LaboratoryHl7Result']['abnormal_flag']);?>
		</td>
	</tr>

	<?php } ?>

</table>
<?php $reportDone = true;?>
<?php } ?>

<!-- CULTURE & SENSITIVITY REPORT ENDS -->


<?php if($get_lab_result['Laboratory']['name'] == 'Pathology Cytology (Non-Gyn) Request' || $get_lab_result['Laboratory']['name'] == 'Pathology Tissue Request' || $get_lab_result['Laboratory']['name'] == 'Liquid Based Pap'|| $get_lab_result['Laboratory']['lab_type'] == '2'){?>
<table width="100%" border="0" cellspacing="6" cellpadding="0"
	style="margin: 0 auto; padding-top: 5px; font-size: 12px;">
	<?php
	foreach ( $get_lab_result ['LaboratoryHl7Result'] as $labViewText ) {
		if (stripos ( strtolower ( $labViewText ['LaboratoryHl7Result'] ['result'] ), 'accession number:' ) !== false) {
			echo '<tr><td style="height:20px;">&nbsp;</td></tr>';
		}
		if ($labViewText ['LaboratoryHl7Result'] ['result'] == 'DIAGNOSIS') {
			// echo '<tr><td style="height:20px;>&nbsp;</td></tr>';
		}
		if (stripos ( strtolower ( $labViewText ['LaboratoryHl7Result'] ['result'] ), 'clinical history' ) !== false) {
			echo '<tr><td style="height:20px;">&nbsp;</td></tr>';
		}
		if (stripos ( strtolower ( $labViewText ['LaboratoryHl7Result'] ['result'] ), 'specimen(s) source' ) !== false) {
			echo '<tr><td style="height:20px;">&nbsp;</td></tr>';
		}
		if (stripos ( strtolower ( $labViewText ['LaboratoryHl7Result'] ['result'] ), 'gross description' ) !== false) {
			echo '<tr><td style="height:20px;">&nbsp;</td></tr>';
		}
		if (stripos ( strtolower ( $labViewText ['LaboratoryHl7Result'] ['result'] ), 'microscopic description' ) !== false) {
			echo '<tr><td style="height:20px;">&nbsp;</td></tr>';
		}
		$resExpl = explode ( "{{break}}", $labViewText ['LaboratoryHl7Result'] ['result'] );
		foreach ( $resExpl as $resExplKey => $resExplValue ) {
			echo '<tr><td>' . str_replace ( " ", "&nbsp;", $resExplValue ) . '</td></tr>';
		}
	}
	?>
	<!-- BOF-for histopathology_data Mahalaxmi -->

<?php
	
	$getUnserializeData = unserialize ( $get_lab_result_main ['LaboratoryResult'] ['histopathology_data'] );
	?>
<table width="100%" border="0" cellspacing="0" cellpadding="0"
		style="margin: 0 auto; border-bottom: 1px solid; border-top: 1px solid; font-size: 12px; line-height: 25px; padding: 10px 0;">
<?php foreach($getUnserializeData as $datas){?>
<tr>
			<td width="10%"><strong><?php echo $datas['0']; ?></strong></td>
			<td width="90%" style="padding-left: 10px;"><?php echo $datas['1']; ?></td>
		</tr>
<?php }?>
</table>
	<!-- EOF-for histopathology_data Mahalaxmi -->
</table>
<?php
} else if ($get_lab_result ['LaboratoryHl7Result1'] ['unit'] == 'CWE' && ! $reportDone) {
	?>
<table width="100%" border="0" cellspacing="0" cellpadding="0"
	style="margin: 0 auto; padding-top: 5px; font-size: 12px;">
	<tr>
		<td width="30%" style="font-weight: bold;"><?php echo __("NAME");?></td>
		<td style="font-weight: bold;"><?php echo __("VALUE");?></td>
	</tr>
	<?php foreach($get_lab_result['LaboratoryHl7Result'] as $labView){ ?>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td width="30%"><?php echo $labView['LaboratoryHl7Result']['status']." ".$labResultStatus[$labView['LaboratoryHl7Result']['status']];?>
		</td>
		<td><?php echo __("SEE BELOW FOR REPORT");?></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2">- <?php
		$resExpl = explode ( "{{break}}", $labView ['LaboratoryHl7Result'] ['result'] );
		foreach ( $resExpl as $resExplKey => $resExplValue ) {
			echo $resExplValue;
		}
		?>
		</td>
	</tr>
	<?php $finalResult .= ($labView['LaboratoryHl7Result']['status'] == 'F') ? $resExplValue."</br>" : '';?>
	<?php } ?>
	<tr>
		<td>&nbsp;</td>
		<td><?php echo __($finalResult);?></td>
	</tr>
</table>

<?php }else{ ?>
<?php if(!$reportDone || $isSensitivity == true){?>

<!-- Sensitivity Header Starts-->
<?php if($isSensitivity == true){?>
<table width="100%" border="0" cellspacing="0" cellpadding="0"
	style="margin: 0 auto; padding-top: 15px">
	<tr>
		<td><h2>
				<?php echo __("Sensitivity Analysis"); ?>
			</h2></td>
	</tr>
</table>

<?php }?>
<!-- Sensitivity Header End-->

<table width="100%" border="0" cellspacing="0" cellpadding="5"
	style="margin: 0 auto; font-size: 12px;">
	<tr>
		<td><h4><?php echo __("Final - Approved ").date("m/d/Y g:i A",strtotime($get_lab_result['LaboratoryResult']['od_observation_start_date_time']));?></h4></td>
	</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="4"
	style="margin: 0 auto; font-size: 12px; line-height: 25px;">
	<?php if($isSensitivity == true){?>
		<tr>
		<td width="30%" style="font-weight: bold;">&nbsp;</td>
		<td style="font-weight: bold;">&nbsp;</td>
		<td style="font-weight: bold;"><?php echo __("Interpretation");?></td>
		<td style="font-weight: bold;">&nbsp;</td>
	</tr>
	<?php }else{?>
		<tr>
		<td width="30%" style="font-weight: bold;"><?php echo __("TEST");?></td>
		<td style="font-weight: bold;"><?php echo __("RESULT");?></td>
		<td style="font-weight: bold;"><?php echo __("REFERENCE");?></td>
		<td style="font-weight: bold;"><?php echo __("UNIT");?></td>
	</tr>
	<?php }?>
	<?php
		foreach ( $get_lab_result ['LaboratoryHl7Result'] as $labView ) {
			if ($isSensitivity == true) {
				if ($labView ['LaboratoryHl7Result'] ['is_sensitivity'] == 0) {
					continue;
				}
			}
			$idLabView [] = $labNameView ['laboratory_id'];
			if ((($labView ['LaboratoryHl7Result'] ['laboratory_id'] != '') || ($labView ['LaboratoryHl7Result'] ['status'] != '')) || ($isSensitivity == true)) {
				$viewLabHl7 = $labView;
				// to display Name of panel subtest
				$countOfLab = count ( $get_lab_result ['LaboratoryHl7Result'] );
				?>
			
	<tr>
		<td width="30%"><?php
				if ($countOfLab > 1) {
					if ($viewLabHl7 ['LaboratoryHl7Result'] ['observation_alt_text'])
						$labTestName = $viewLabHl7 ['LaboratoryHl7Result'] ['observation_alt_text'];
					else
						$labTestName = $panelTests [$viewLabHl7 ['LaboratoryHl7Result'] ['laboratory_id']];
				} else {
					if ($viewLabHl7 ['LaboratoryHl7Result'] ['observation_alt_text'])
						$labTestName = $viewLabHl7 ['LaboratoryHl7Result'] ['observation_alt_text'];
					else
						$labTestName = $get_lab_result ['Laboratory'] ['name'];
				}
				
				if ($labView ['LaboratoryHl7Result'] ['is_sensitivity'] == 1) {
					if (stripos ( strtolower ( $labView ['LaboratoryHl7Result'] ['observations'] ), 'organism' ) !== false) {
						$labTestName = $labView ['LaboratoryHl7Result'] ['observations'];
					}
				}
				
				if (empty ( $viewLabHl7 ['LaboratoryHl7Result'] ['result'] ))
					continue;
				
				echo ($labTestName) ? ucfirst ( $labTestName ) : '&nbsp';
				?></td>
		<td><table style="font-size: 12px">
				<tr><?php
				$isAbnormal = $viewLabHl7 ['LaboratoryHl7Result'] ['abnormal_flag'];
				if (! empty ( $isAbnormal ) && (strtoupper ( $isAbnormal ) != 'N')) {
					
					if ($viewLabHl7 ['LaboratoryHl7Result'] ['abnormal_flag'] == 'L') {
						$flag = 'Below low normal';
					} else if ($viewLabHl7 ['LaboratoryHl7Result'] ['abnormal_flag'] == 'LL') {
						$flag = "Below lower panic limits";
					} else if ($viewLabHl7 ['LaboratoryHl7Result'] ['abnormal_flag'] == '<') {
						$flag = "Below absolute low-off instrument scale";
					} else if ($viewLabHl7 ['LaboratoryHl7Result'] ['abnormal_flag'] == 'H') {
						$flag = "Above high normal";
					} else if ($viewLabHl7 ['LaboratoryHl7Result'] ['abnormal_flag'] == 'HH') {
						$flag = "Above upper panic limits";
					} else if ($viewLabHl7 ['LaboratoryHl7Result'] ['abnormal_flag'] == '>') {
						$flag = "Above absolute high-off instrument scale";
					} else if ($viewLabHl7 ['LaboratoryHl7Result'] ['abnormal_flag'] == 'N') {
						$flag = "Normal";
					}
					echo '<td class="abnormalResult" style="display:inline;float:left;font-weight:bold;width:15px;">' . $flag . '</td>';
					$abnormalColor = 'color:red;font-weight:bold';
				} else {
					echo '<td style="display:inline;float:left;width:15px;"></td>';
					$abnormalColor = '';
				}
				
				echo '<td style="display:inline;float:left;' . $abnormalColor . '">';
				$resExpl = explode ( "{{break}}", $viewLabHl7 ['LaboratoryHl7Result'] ['result'] );
				foreach ( $resExpl as $resExplKey => $resExplValue ) {
					echo $resExplValue;
				}
				
				echo '</td>';
				?>
		</tr>
			</table></td>
		<td><?php echo ($viewLabHl7['LaboratoryHl7Result']['range'])?$viewLabHl7['LaboratoryHl7Result']['range']:'&nbsp;';?>
		</td>

		<!-- 
		<td><?php
				
				$range = explode ( '-', $viewLabHl7 ['LaboratoryHl7Result'] ['range'] );
				$lowrange = $range ['0'];
				$uprange = $range ['1'];
				if ($viewLabHl7 ['LaboratoryHl7Result'] ['result'] > $uprange) {
					$showRange = 'C';
				} else if ($viewLabHl7 ['LaboratoryHl7Result'] ['result'] < $lowrange) {
					$showRange = 'A';
				}
				echo $showRange;
				?></td>
		 -->
		<td><?php echo ($viewLabHl7['LaboratoryHl7Result']['uom'])?$viewLabHl7['LaboratoryHl7Result']['uom']:'&nbsp;';?>
		</td>
	</tr>
	<?php
				$expNotes = explode ( "{{break}}", $viewLabHl7 ['LaboratoryHl7Result'] ['notes'] );
				foreach ( $expNotes as $key => $value ) {
					?>
		<tr>
		<td colspan="4"
			style="padding-left: 20px; font-size: 13px; font-style: italic"><?php echo $value;?></td>
	</tr>
	<?php
				}
				$value = '';
			}
		}
		?>
</table>
<?php }?>
<?php }?>



<table width="20%" border="0" cellspacing="0" cellpadding="0"
	class="formFull"
	style="font-size: 12px; padding: 0px 9px; margin-top: 10px;"
	align="right">
	<tr>
		<td>Doctor Signature</td>
	</tr>
	<tr>
		<td width="50%"><?php echo $this->Html->image('/signpad/'.$userSignImage, array('alt' => 'Signature', 'title' => 'Signature', 'width' => '320', 'height' => '150','style'=>'text-align:right'));?>
		</td>
	</tr>
</table>














<!-- 
<table width="100%" border="0" cellspacing="0" cellpadding="0"
	class="formFull">
	<tr>
		<th colspan="5"><?php echo __("Patient Information") ; ?></th>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Patient Name");?>
		</td>


		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $patientData['Person']['first_name'].' ' .$patientData['Person']['last_name'];?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Date of Birth");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		
		$patientData ['Person'] ['dob'] = $this->DateFormat->formatDate2Local ( $patientData ['Person'] ['dob'], Configure::read ( 'date_format' ) );
		echo $patientData ['Person'] ['dob'];
		?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Gender");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $patientData['Person']['sex'];?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Race");?>
		</td>
		<?php
		/*
		 * $races = explode(',',$patientData['Person']['race']);
		 * $raceString = '';
		 * foreach($races as $rc){
		 * $raceString .= $race[$rc];
		 * }
		 */
		?>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		// if(!empty($patientData['Person']['race'])){echo $patientData['Person']['race'];}else{ echo 'Denied to specify';} //$patientData['Race']['race_name'];//$raceString;
		if (! empty ( $race [$patientData ['Person'] ['race']] )) {
			echo $race [$patientData ['Person'] ['race']];
		} else {
			echo 'Denied to specify';
		} // $patientData['Race']['race_name'];//$raceString;		?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Ethnicity");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		$ethn = explode ( ":", $patientData ['Person'] ['ethnicity'] );
		if (! empty ( $ethn ['1'] )) {
			echo $ethn ['1'];
		} // $patientData['Race']['race_name'];//$raceString;		?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Allergies");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		foreach ( $allergies_data as $allergy ) {
			$allergies .= $allergy ['NewCropAllergies'] ['name'] . ', ';
		}
		echo rtrim ( $allergies, ", " );
		;
		?>
		</td>
	</tr>
	
	</table>
	<table width="100%" border="0" cellspacing="0" cellpadding="0"
	class="formFull">
	<tr>
		<th colspan="5"><?php echo __("Lab Information") ; ?></th>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Universal Service Identifier");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $get_lab_result['Laboratory']['name']; ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Filler Order Number");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $get_lab_result['LaboratoryResult']['ogi_filler_order_number']; ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Placer Order Number");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		
		echo $get_lab_result ['LaboratoryToken'] ['ac_id'];
		?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Date/Time of Observation");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		
		echo $this->DateFormat->formatDate2Local ( $get_lab_result ['LaboratoryHl7Result'] ['0'] ['date_time_of_observation'], Configure::read ( 'date_format' ), true );
		?>
		</td>
	</tr>
	
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Ordering Provider");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		
		echo $get_lab_result ['LaboratoryToken'] ['primary_care_pro'];
		?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Responsible Observer");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		
		echo $get_lab_result ['LaboratoryResult'] ['rct_name'] . ' ' . $get_lab_result ['LaboratoryResult'] ['rct_last_name'];
		?>
		</td>
	</tr>
</table>

<?php

?>

<table width="100%" border="0"
	cellspacing="0" cellpadding="0" class="formFull" id="labHl7Results_0">
	<tr>
		<th colspan="10"><?php echo __("Lab Results") ; ?></th>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><b><?php echo __("Observation");?>
		</b>
		</td>
		<td width="10%" valign="middle" class="tdLabel" id="boxspace"><b><?php echo __("Type");?>
		</b>
		</td>
		<td width="10%" valign="middle" class="tdLabel" id="boxspace"><b><?php echo __("Result");?>
		</b>
		</td>
		<td width="15%" valign="middle" class="tdLabel" id="boxspace"><b><?php echo __("UOM");?>
		</b>
		</td>
		<td width="15%" valign="middle" class="tdLabel" id="boxspace"><b><?php echo __("Range");?>
		</b>
		</td>
		<td width="15%" valign="middle" class="tdLabel" id="boxspace"><b><?php echo __("Abnormal Flag");?>
		</b>
		</td>
		<td width="20%" valign="middle" class="tdLabel" id="boxspace"><b><?php echo __("Status");?>
		</b>
		</td>
	</tr>

	<?php
	function getLabName($panelTests, $labId) {
		foreach ( $panelTests as $test ) {
			if ($test ['Laboratory'] ['id'] == $labId) {
				return $test ['Laboratory'] ['name'];
			}
		}
	}
	
	foreach ( $get_lab_result ['LaboratoryHl7Result'] as $labView ) {
		
		$idLabView [] = $labNameView ['laboratory_id'];
		
		if (($labView ['laboratory_id'] != '') || ($labView ['status'] != '')) {
			
			$viewLabHl7 = $labView;
			// to display Name of panel subtest
			$countOfLab = count ( $get_lab_result ['LaboratoryHl7Result'] );
			?>
	<tr>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
			// $labTestName = getLabName($panelTests,$viewLabHl7['laboratory_id']);
			if ($countOfLab > 1) {
				$labTestName = $panelTests [$viewLabHl7 ['LaboratoryHl7Result'] ['laboratory_id']];
			} else {
				$labTestName = $get_lab_result ['Laboratory'] ['name'];
			}
			echo ($labTestName) ? $labTestName : '&nbsp';
			
			?>
		</td>
		<td width="10%" valign="middle" class="tdLabel" id="boxspace"><?php echo ($units_option[$viewLabHl7['unit']])?$units_option[$viewLabHl7['unit']]:'&nbsp;';  ?>

		</td>
		<td width="10%" valign="middle" class="tdLabel" id="boxspace"><?php echo ($viewLabHl7['sn_value'])?$viewLabHl7['sn_value']:'&nbsp;'; ?>
			<?php echo $viewLabHl7['result']; ?>
		</td>

		<td width="15%" valign="middle" class="tdLabel" id="boxspace"><?php
			if ($ucums_option [$viewLabHl7 ['uom']]) {
				$uniteUOM = $ucums_option [$viewLabHl7 ['uom']];
			} else {
				$uniteUOM = $viewLabHl7 ['uom'];
			}
			echo ($uniteUOM) ? $uniteUOM : '&nbsp;';
			?>

		</td>
		<td width="15%" valign="middle" class="tdLabel" id="boxspace"><?php
			
			echo ($viewLabHl7 ['range']) ? $viewLabHl7 ['range'] : '&nbsp;';
			if ($abnormalFlag [$viewLabHl7 ['abnormal_flag']] == 'Below absolute low-off instrument scale' || $abnormalFlag [$viewLabHl7 ['abnormal_flag']] == 'Below lower panic limits' || $abnormalFlag [$viewLabHl7 ['abnormal_flag']] == 'Below low normal') {
				$textColor = '#2F72FF';
			} else if ($abnormalFlag [$viewLabHl7 ['abnormal_flag']] == 'Above upper panic limits' || $abnormalFlag [$viewLabHl7 ['abnormal_flag']] == 'Above high normal') {
				$textColor = '#FF803E';
			} else if ($abnormalFlag [$viewLabHl7 ['abnormal_flag']] == 'Normal') {
				$textColor = '#000';
			} else {
				$textColor = '#F90223';
			}
			?>
		</td>
		<td width="15%" valign="middle" class="tdLabel" id="boxspace"  style='color:<?php echo $textColor ?>'>
			<?php
			echo ($abnormalFlag [$viewLabHl7 ['abnormal_flag']]) ? $abnormalFlag [$viewLabHl7 ['abnormal_flag']] : '&nbsp;';
			?>
		</td>
		<td width="20%" valign="middle" class="tdLabel" id="boxspace"><?php echo $labResultStatus[$viewLabHl7['status']]; ?>
		</td>
	</tr>
	<?php
		}
	}
	?>


</table>
 -->
