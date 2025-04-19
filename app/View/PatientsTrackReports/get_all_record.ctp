<?php /* debug($this->params['named']['slug']);
debug($slug);
debug($displayPrint); */?>
<style>
 @media print {
	#printButton {
		display: none;
	}
	footer {page-break-before: always;}
	
	
}
 
body {    
	   /* margin-top: 15mm !important;*/
	    padding: 0 !important;
	}
</style>
 
<table border="0" width="100%" >
<!-- Header for single ENC -->
	<?php  if($this->params['named']['slug']=='true'){?> 
	 
	<thead>
		<!-- Header Code -->
		<!--  <tr>
				<th colspan="8" style="font-size: 13px"><u>PATIENT DETAILS</u></th>
			</tr>
		-->
			<tr>
				<td style="font-size: 13px"><strong>Patient ID : </strong><?php echo $personData['Person']['patient_uid'];?></td>
				<td style="font-size: 13px"><strong>Visit ID : </strong><?php echo $personData['Patient']['admission_id'];?></td>
				<td style="font-size: 13px"><strong>Name : </strong><?php echo $personData['Person']['first_name'] .' '.$personData['Person']['middle_name'].' '.$personData['Person']['last_name'];?></td>
				<td style="font-size: 13px"><strong>DOB : </strong><?php $dob = $this->DateFormat->formatDate2Local($personData['Person']['dob'],Configure::read('date_format_us'),false);echo $dob;?></td>
			</tr>
			<tr>
				<td style="font-size: 13px"><strong>Gender : </strong> <?php echo $personData['Person']['sex'];?></td>	
				<td style="font-size: 13px"><strong>Visit Date : </strong><?php $formReceivedOn = $this->DateFormat->formatDate2Local($personData['Patient']['form_received_on'],Configure::read('date_format_us'),false);echo $formReceivedOn;?></td>
				<?php if(!empty($personData['Person']['landmark']))$space=', ';else $space=' '; ?>
				<?php if(!empty($personData['Person']['pin_code']))$space1=', ';else $space1=' '; ?>
				<td style="font-size: 13px"><strong>Address : </strong><?php echo $personData['Person']['plot_no'].''.$space.''.$personData['Person']['landmark'].', '.$personData['Person']['city'].', '.$personData['State']['name'].', US'.''.$space1.''.$personData['Person']['pin_code'];
				if(!empty($personData['Person']['zip_four']))
					echo " - ".$personData['Person']['zip_four'];?></td>
				<td style="font-size: 13px"><strong>Provider : </strong><?php echo $doctors[$personData['Patient']['doctor_id']];?></td>
			</tr>
			<tr>
				<td colspan="4">
				<hr>
				</td>
			</tr>
			
<!-- Header Code  EOd-->
	</thead>
	<div style="float: right; padding-top: 5px" id="printButton">
		<?php echo $this->Html->link('Print','#',array('onclick'=>'window.print();','class'=>'blueBtn','escape'=>false));?>
	</div>
	<?php }?>
<!--EOF Header Single ENC -->

<!-- 1st encounter Header for Multiple record-->
<?php  if(($slug=='slug' && $displayPrint == true)){?>
	<?php $exploadData = explode(':', $getNoteData['Note']['plan']);
	if(
			(!empty($bmiData)) ||
			(((!empty($getChiefCompalints['Diagnosis']['complaints']) && $getChiefCompalints['Diagnosis']['complaints'] !="" ) || ((!empty($getChiefCompalints['Diagnosis']['nursing_notes']) && $getChiefCompalints['Diagnosis']['nursing_notes'] !="" )) ||((!empty($getChiefCompalints['Diagnosis']['family_tit_bit']) && $getChiefCompalints['Diagnosis']['family_tit_bit'] !="" )) ||((!empty($getChiefCompalints['Diagnosis']['flag_event']) && $getChiefCompalints['Diagnosis']['flag_event'] !="" )))|| (!empty($getNoteData['Note']['subject']) && $getNoteData['Note']['subject']!='')) ||
			((!empty($getNoteData['Note']['subject']) && $getNoteData['Note']['subject']!='') || ($HpiNew != '' && !empty($HpiNew) && !isset($HpiNew))) ||
			(($getNoteData['Note']['ros'] && !empty($getNoteData['Note']['ros']) && $getNoteData['Note']['ros']!='') || ($RosNew != '' && !empty($RosNew)  && !isset($RosNew))) ||
			(!empty($pastMedicalHistory) || !empty($procedureHistoryRec) || !empty($getpatientfamilyhistory) || !empty($diagnosisRec['PatientPersonalHistory']['smoking_fre']) || !empty($getAllergy)) ||
			(!empty($getMedicationHistory)) ||
			(!empty($pastMedicalHistory)) ||
			(!empty($procedureHistoryRec)) ||
			(!empty($getpatientfamilyhistory)) ||
			(/* !empty($diagnosisRec['PatientPersonalHistory']['work']) || */ !empty($getmaritailStatusData) || !empty($diagnosisRec['PatientPersonalHistory']['exercise_frequency'])) ||
			(!empty($diagnosisRec['PatientPersonalHistory']['smoking_fre']) || !empty($diagnosisRec['PatientPersonalHistory']['smoking_desc']) || !empty($diagnosisRec['PatientPersonalHistory']['alchohol_q1']) || !empty($diagnosisRec['PatientPersonalHistory']['alchohol_q2']) || !empty($diagnosisRec['PatientPersonalHistory']['alchohol_q3'])) ||
			(!empty($getAllergy)) ||
			(($getNoteData['Note']['object'] && !empty($getNoteData['Note']['object']) && $getNoteData['Note']['object']!='') || ($peNewData != '' && !empty($peNewData)  && !isset($peNewData))) ||
			(($getNoteData['Note']['assis'] && !empty($getNoteData['Note']['assis']))||!empty($getProblem)||!empty($getMedication)||!empty($getPcare)) ||
			($getNoteData['Note']['assis'] && !empty($getNoteData['Note']['assis'])) ||
			(!empty($getProblem)) ||
			(!empty($getMedication)) ||
			(!empty($getPcare)) ||
			(($exploadData[0] !="" && !empty($exploadData[0])) || !empty($getLab) || !empty($getRad) || !empty($procedureData) || !empty($past_immunization_details)) ||
			($exploadData[0] !="" && !empty($exploadData[0])) ||
			(!empty($getLab)) ||
			(!empty($getRad)) ||
			(!empty($procedureData)) ||
			(!empty($past_immunization_details))
			 		){?>
	<thead>
		<!-- Header Code -->
		<!--  
		<tr>
			<th colspan="8" style="font-size: 13px">PATIENT DETAILS</th>
		</tr>
		-->

		<tr>
			<td style="font-size: 13px"><strong>Patient ID : </strong> <?php echo $personData['Person']['patient_uid'];?>
			</td>
			<td style="font-size: 13px"><strong>Visit ID : </strong> <?php echo $personData['Patient']['admission_id'];?>
			</td>
			<td style="font-size: 13px"><strong>Name : </strong> <?php echo $personData['Person']['first_name'] .' '.$personData['Person']['middle_name'].' '.$personData['Person']['last_name'];?>
			</td>
			<td style="font-size: 13px"><strong>DOB : </strong> <?php $dob = $this->DateFormat->formatDate2Local($personData['Person']['dob'],Configure::read('date_format_us'),false);echo $dob;?>
			</td>
		</tr>
		<tr>
			<td style="font-size: 13px"><strong>Gender : </strong> <?php echo $personData['Person']['sex'];?>
			</td>
			<td style="font-size: 13px"><strong>Visit Date : </strong> <?php $formReceivedOn = $this->DateFormat->formatDate2Local($personData['Patient']['form_received_on'],Configure::read('date_format_us'),false);echo $formReceivedOn;?>
			</td>
			<?php if(!empty($personData['Person']['landmark']))$space=', ';else $space=' '; ?>
			<?php if(!empty($personData['Person']['pin_code']))$space1=', ';else $space1=' '; ?>
			<td style="font-size: 13px"><strong>Address : </strong> <?php echo $personData['Person']['plot_no'].''.$space.''.$personData['Person']['landmark'].', '.$personData['Person']['city'].', '.$personData['State']['name'].', US'.''.$space1.''.$personData['Person']['pin_code'];
			if(!empty($personData['Person']['zip_four']))
				echo " - ".$personData['Person']['zip_four'];?>
			</td>
			<td style="font-size: 13px"><strong>Provider : </strong><?php echo $doctors[$personData['Patient']['doctor_id']];?></td>
		</tr>
		<tr>
				
				
			</tr>
		<!-- Header Code  EOd-->
	</thead>

	<?php }?>
	<div style="float: right; padding-top: 5px" id="printButton">

		<?php echo $this->Html->link('Print','#',array('onclick'=>'window.print();','class'=>'blueBtn','escape'=>false));?>

	</div>
	<?php }?>
<!--EOF  -->
<!--BOF  -->
		 <!-- Header for 2nd page in multipel   -->
			 <?php  if($this->params['named']['slug']=='true' || $slug=='slug'){
			 
			 	$exploadData = explode(':', $getNoteData['Note']['plan']);
			 	if(
			 			(!empty($bmiData)) ||
			 			(((!empty($getChiefCompalints['Diagnosis']['complaints']) && $getChiefCompalints['Diagnosis']['complaints'] !="" ) || ((!empty($getChiefCompalints['Diagnosis']['nursing_notes']) && $getChiefCompalints['Diagnosis']['nursing_notes'] !="" )) ||((!empty($getChiefCompalints['Diagnosis']['family_tit_bit']) && $getChiefCompalints['Diagnosis']['family_tit_bit'] !="" )) ||((!empty($getChiefCompalints['Diagnosis']['flag_event']) && $getChiefCompalints['Diagnosis']['flag_event'] !="" )))|| (!empty($getNoteData['Note']['subject']) && $getNoteData['Note']['subject']!='')) ||
			 			((!empty($getNoteData['Note']['subject']) && $getNoteData['Note']['subject']!='') || ($HpiNew != '' && !empty($HpiNew) && !isset($HpiNew))) ||
			 			(($getNoteData['Note']['ros'] && !empty($getNoteData['Note']['ros']) && $getNoteData['Note']['ros']!='') || ($RosNew != '' && !empty($RosNew)  && !isset($RosNew))) ||
			 			(!empty($pastMedicalHistory) || !empty($procedureHistoryRec) || !empty($getpatientfamilyhistory) || !empty($diagnosisRec['PatientPersonalHistory']['smoking_fre']) || !empty($getAllergy)) ||
			 			(!empty($getMedicationHistory)) ||
			 			(!empty($pastMedicalHistory)) ||
			 			(!empty($procedureHistoryRec)) ||
			 			(!empty($getpatientfamilyhistory)) ||
			 			(/* !empty($diagnosisRec['PatientPersonalHistory']['work']) || */ !empty($getmaritailStatusData) || !empty($diagnosisRec['PatientPersonalHistory']['exercise_frequency'])) ||
			 			(!empty($diagnosisRec['PatientPersonalHistory']['smoking_fre']) || !empty($diagnosisRec['PatientPersonalHistory']['smoking_desc']) || !empty($diagnosisRec['PatientPersonalHistory']['alchohol_q1']) || !empty($diagnosisRec['PatientPersonalHistory']['alchohol_q2']) || !empty($diagnosisRec['PatientPersonalHistory']['alchohol_q3'])) ||
			 			(!empty($getAllergy)) ||
			 			(($getNoteData['Note']['object'] && !empty($getNoteData['Note']['object']) && $getNoteData['Note']['object']!='') || ($peNewData != '' && !empty($peNewData)  && !isset($peNewData))) ||
			 			(($getNoteData['Note']['assis'] && !empty($getNoteData['Note']['assis']))||!empty($getProblem)||!empty($getMedication)||!empty($getPcare)) ||
			 			($getNoteData['Note']['assis'] && !empty($getNoteData['Note']['assis'])) ||
			 			(!empty($getProblem)) ||
			 			(!empty($getMedication)) ||
			 			(!empty($getPcare)) ||
			 			(($exploadData[0] !="" && !empty($exploadData[0])) || !empty($getLab) || !empty($getRad) || !empty($procedureData) || !empty($past_immunization_details)) ||
			 			($exploadData[0] !="" && !empty($exploadData[0])) ||
			 			(!empty($getLab)) ||
			 			(!empty($getRad)) ||
			 			(!empty($procedureData)) ||
			 			(!empty($past_immunization_details))
			 		){
			 	?>
			 	
			 	
			<?php  if(($slug=='slug' && $displayPrint == false)){?>
			<thead>
			<!--  
			<tr>
				<th colspan="8" style="font-size: 13px">PATIENT DETAILS</th>
			</tr>
			-->
			<tr>
			
				<td style="font-size: 13px"><strong>Patient ID : </strong><?php echo $personData['Person']['patient_uid'];?></td>
				<td style="font-size: 13px"><strong>Visit ID : </strong><?php echo $personData['Patient']['admission_id'];?></td>
				<td style="font-size: 13px"><strong>Name : </strong><?php echo $personData['Person']['first_name'] .' '.$personData['Person']['middle_name'].' '.$personData['Person']['last_name'];?></td>
				<td style="font-size: 13px"><strong>Birth Date : </strong><?php $dob = $this->DateFormat->formatDate2Local($personData['Person']['dob'],Configure::read('date_format_us'),false);echo $dob;?></td>
			</tr>
			<tr>
				<td style="font-size: 13px"><strong>Gender : </strong> <?php echo $personData['Person']['sex'];?></td>	
				<td style="font-size: 13px"><strong>Visit Date : </strong><?php $formReceivedOn = $this->DateFormat->formatDate2Local($personData['Patient']['form_received_on'],Configure::read('date_format_us'),false);echo $formReceivedOn;?></td>				<?php if(!empty($personData['Person']['landmark']))$space=', ';else $space=' '; ?>
				<?php if(!empty($personData['Person']['pin_code']))$space1=', ';else $space1=' '; ?>
				<td style="font-size: 13px"><strong>Address : </strong><?php echo $personData['Person']['plot_no'].''.$space.''.$personData['Person']['landmark'].', '.$personData['Person']['city'].', '.$personData['State']['name'].', US'.''.$space1.''.$personData['Person']['pin_code'];
				if(!empty($personData['Person']['zip_four']))
					echo " - ".$personData['Person']['zip_four'];?></td>
				
				<td style="font-size: 13px"><strong>Provider : </strong><?php echo $doctors[$personData['Patient']['doctor_id']];?></td>
			</tr>
			 
			</thead>
			<?php }?>
			 
					 <?php 
					 }
				 }?>
			  <!-- EOF Header for 2nd page in multipel   -->
			   
<!--EOF  -->		
	
	 
	<tr>
		<td colspan="8">
		<?php  if(($this->params['named']['slug']!='true') && $checkBox != 'checkBox' && $slug!='slug'){?>
			<div class="inner_title">
				<h6>
				<?php echo 'Visit ID ( '.$patientFormReceivedOn['Patient']['admission_id'].' ),		Visit Date ( '.$this->DateFormat->formatDate2LocalForReport($patientFormReceivedOn['Patient']['form_received_on'],Configure::read('date_format')).' )';?>
				</h6>
				<span>
					
					<?php echo $this->Html->link('Print','javascript:void(0)',
					array('style'=>'','class'=>'blueBtn','escape' => false,
						'onclick'=>
						"window.open('".$this->Html->url(array('controller'=>"PatientsTrackReports",'action'=>"getAllRecord",$patientId,$personId,$appointmentID,$noteID,"slug"=>'true'))."',
						'_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=1200,height=600,left=200,top=200');")); ?>	</span>
			</div> 
			<?php }?> 
			<?php  if(($slug!='slug') && $checkBox == 'checkBox'){
			$patientIdsArray = implode(',',$patientIdsArray);
			$appointmentIdsArray = implode(',',$appointmentIdsArray);
			$noteIdsArray = implode(',',$noteIdsArray);
			?>
			<div class="inner_title" align="left">
				<h6>
				<?php echo 'Visit ID ( '.$patientFormReceivedOn['Patient']['admission_id'].' ),		Visit Date ( '.$this->DateFormat->formatDate2LocalForReport($patientFormReceivedOn['Patient']['form_received_on'],Configure::read('date_format')).' )';?>
				</h6>
				
					<span style="text-align: left;">
					 <?php if($displayPrint == true){?>
					<button onclick="printForCheckBox('<?php echo $patientIdsArray,$personId,$appointmentIdsArray,$noteIdsArray ?>')" class=blueBtn ><?php echo __('Print');?></button>
					<?php }?>
					</span>
			</div> 
			<?php } ?>
			
		
			<!-- Vitals begin -->
			<?php if(!empty($bmiData)){?>
			<p></p>
			<div class="inner_title" align="left">
				<h3>
					&nbsp;
					<?php echo __('VITALS', true); ?>
				</h3>
			</div>
			<table width="100%" cellpadding="0" cellspacing="1" border="0"
				class="tabularForm resTableConf" id="">
				<thead>
					<tr class="row_title">
						<th class="table_cell"><strong><?php echo __('Temperature', true); ?>
						</strong></th>
						<th class="table_cell"><strong><?php echo __('Blood Pressure', true); ?>
						</strong></th>
						<th class="table_cell"><strong><?php echo __('Heart Rate', true); ?>
						</strong></th>
						<th class="table_cell"><strong><?php echo __('Respiratory Rate', true); ?>
						</strong></th>
					</tr>
				</thead>
				<?php 
				if(!empty($bmiData['BmiResult']['temperature'])){
			$temp1=isset($bmiData['BmiResult']['temperature'])?$bmiData['BmiResult']['temperature'].' '.$bmiData['BmiResult']['myoption']:'';
		}
		if(!empty($bmiData['BmiResult']['temperature1'])){
			$temp2=isset($bmiData['BmiResult']['temperature1'])?$bmiData['BmiResult']['temperature1'].' '.$bmiData['BmiResult']['myoption1']:'';
		}

		if(!empty($bmiData['BmiResult']['temperature2'])){
			$temp3=isset($bmiData['BmiResult']['temperature2'])?$bmiData['BmiResult']['temperature2'].' '.$bmiData['BmiResult']['myoption2']:'';
		}

		if(!empty($bmiData['BmiResult']['respiration'])){
			$respiration=isset($bmiData['BmiResult']['respiration'])?$bmiData['BmiResult']['respiration']:'';
		}
		if(!empty($bmiData['BmiBpResult']['systolic'])){
			$bp1=isset($bmiData['BmiBpResult']['systolic'])?$bmiData['BmiBpResult']['systolic']."/".$bmiData['BmiBpResult']['diastolic'].' '."mmHg":'';
		}
		if(!empty($bmiData['BmiBpResult']['systolic1'])){
			$bp2=isset($bmiData['BmiBpResult']['systolic1'])?$bmiData['BmiBpResult']['systolic1']."/".$bmiData['BmiBpResult']['diastolic1'].' '."mmHg":'';

		}
		if(!empty($bmiData['BmiBpResult']['systolic2'])){
			$bp3=isset($bmiData['BmiBpResult']['systolic2'])?$bmiData['BmiBpResult']['systolic2']."/".$bmiData['BmiBpResult']['diastolic2'].' '."mmHg":'';
		}

		if(!empty($bmiData['BmiBpResult']['pulse_text'])){
			$pulse1=isset($bmiData['BmiBpResult']['pulse_text'])?$bmiData['BmiBpResult']['pulse_text'].' '.'bpm':'';
		}
		if(!empty($bmiData['BmiBpResult']['pulse_text1'])){
			$pulse2=isset($bmiData['BmiBpResult']['pulse_text1'])?$bmiData['BmiBpResult']['pulse_text1'].' '.'bpm':'';
		}
		if(!empty($bmiData['BmiBpResult']['pulse_text2'])){
			$pulse3=isset($bmiData['BmiBpResult']['pulse_text2'])?$bmiData['BmiBpResult']['pulse_text2'].' '.'bpm':'';
		}
		?>
				<tr class='row_gray'>
					<td class="table_cell"><?php   echo  $temp1." ".$temp2." ".$temp3 ; ?>
					</td>
					<td class="table_cell"><?php   echo $bp1." ";echo $bp2." ";echo $bp3." ";?></td>
					<td class="table_cell"><?php   echo $pulse1." ".$pulse2." ".$pulse3;?>
					</td>
					<?php if($respiration){?>
					<td class="table_cell"><?php  echo $respiration." RPM" ?></td>
					<?php }else{?>
					<td class="table_cell"></td>
					<?php }?>

				</tr>
			</table>
			<p></p> <?php }?> 
			<?php if(((!empty($getChiefCompalints['Diagnosis']['complaints']) && $getChiefCompalints['Diagnosis']['complaints'] !="" ) ||
					((!empty($getChiefCompalints['Diagnosis']['nursing_notes']) && $getChiefCompalints['Diagnosis']['nursing_notes'] !="" )) ||
					((!empty($getChiefCompalints['Diagnosis']['family_tit_bit']) && $getChiefCompalints['Diagnosis']['family_tit_bit'] !="" )) ||
					((!empty($getChiefCompalints['Diagnosis']['flag_event']) && $getChiefCompalints['Diagnosis']['flag_event'] !="" )))
					|| (!empty($getNoteData['Note']['subject']) && $getNoteData['Note']['subject']!='')){?>
			<div class="inner_title" align="left">
				<h3>
					&nbsp;
					<?php echo __('SUBJECTIVE', true); ?>
				</h3>
			</div> <?php }?> <?php 
if((((!empty($getChiefCompalints['Diagnosis']['complaints']) && $getChiefCompalints['Diagnosis']['complaints'] !="" ) ||
		((!empty($getChiefCompalints['Diagnosis']['nursing_notes']) && $getChiefCompalints['Diagnosis']['nursing_notes'] !="" )) ||
		((!empty($getChiefCompalints['Diagnosis']['family_tit_bit']) && $getChiefCompalints['Diagnosis']['family_tit_bit'] !="" )) ||
		((!empty($getChiefCompalints['Diagnosis']['flag_event']) && $getChiefCompalints['Diagnosis']['flag_event'] !="" ))))){?>
			<table width="100%" cellpadding="0" cellspacing="1" border="0"
				class="tabularForm resTableConf" id="">
				<thead>
					<tr class='row_title'>
						<th class="row_title" style="width: 30%"><strong><?php echo __('CC:');?>
						</strong>
						</th>
						<th class="row_title" style="width: 30%"><strong><?php echo __('Nursing Notes:');?>
						</strong>
						</th>
						<th class="row_title" style="width: 30%"><strong><?php echo __('Family Personal Notes:');?>
						</strong>
						</th>
						<th class="row_title" style="width: 30%"><strong><?php echo __('Chart Alert:');?>
						</strong>
						</th>
						
					</tr>
				</thead>
				<tr class='row_gray'>
					<td class="row_title"><?php echo  ucfirst($getChiefCompalints['Diagnosis']['complaints']);; ?>
					</td>
					<td class="table_cell"><?php echo  ucfirst($getChiefCompalints['Diagnosis']['nursing_notes']); ?>
					</td>
					<td class="table_cell"><?php echo ucfirst(trim($getChiefCompalints['Diagnosis']['family_tit_bit'])); ?>
					</td>
					<td class="table_cell"><?php echo  ucfirst($getChiefCompalints['Diagnosis']['flag_event']); ?>
					</td>
					
				</tr>
			</table>
			<p></p> <?php }?> <?php 
			$hpiRosSentence = GeneralHelper::createHpiSentence($hpiMasterData,$hpiResultOther,$rosResultOther);
			$HpiNew = $hpiRosSentence['HpiSentence']; 
			$RosNew = $hpiRosSentence['RosSentence'];
			$HpiNew = trim($HpiNew);
			$peNewData = GeneralHelper::createPhysicalExamSentence($hpiMasterData,$peResultOther,$pEButtonsOptionValue);/** function returns Physical Exam sentence */
			?><?php if((!empty($getNoteData['Note']['subject']) && $getNoteData['Note']['subject']!='' && isset($getNoteData['Note']['subject'])) 
					|| $HpiNew != '' && !empty($HpiNew) && isset($HpiNew)){?>
			<table width="100%" cellpadding="0" cellspacing="1" border="0"
				class="tabularForm resTableConf" id="">
				<thead>
					<tr class="row_title">
						<th class="table_cell" width="33%"><strong><?php echo __('HPI:', true); ?>
						</strong></th>
					</tr>
				</thead>

				<tr class='row_gray'>
					<td class="table_cell"><?php echo ucfirst($HpiNew); ?></td>
				</tr>
				<tr class='row_gray'>
					<td class="table_cell"><?php echo ucfirst($getNoteData['Note']['subject']); ?>
					</td>
				</tr>
			</table>
			<p></p>
			<?php }?>
			<?php 
			$RosNew = trim($RosNew);
			if(($getNoteData['Note']['ros'] && !empty($getNoteData['Note']['ros']) && $getNoteData['Note']['ros']!='') || ($RosNew != '' && !empty($RosNew)  && isset($RosNew))){?>
			<table width="100%" cellpadding="0" cellspacing="1" border="0"
				class="tabularForm resTableConf" id="">
				<thead>
					<tr class="row_title">
						<th class="table_cell" width="33%"><strong><?php echo __('ROS:', true); ?>
						</strong></th>
					</tr>
				</thead>
				<?php 

				$hpiRosSentence = GeneralHelper::createHpiSentence($hpiMasterData,$hpiResultOther,$rosResultOther);
				$HpiNew = $hpiRosSentence['HpiSentence']; $RosNew = $hpiRosSentence['RosSentence'];
				$peNewData = GeneralHelper::createPhysicalExamSentence($hpiMasterData,$peResultOther,$pEButtonsOptionValue);/** function returns Physical Exam sentence */
				?>
				<tr class='row_gray'>
					<td class="table_cell"><?php echo ucfirst($RosNew); ?></td>
				</tr>
				<tr class='row_gray'>
					<td class="table_cell"><?php echo ucfirst($getNoteData['Note']['ros']); ?>
					</td>
				</tr>
			</table>
			<p></p> <?php }?> <?php  if(!empty($pastMedicalHistory) || !empty($procedureHistoryRec) || !empty($getpatientfamilyhistory) || !empty($diagnosisRec['PatientPersonalHistory']['smoking_fre']) || !empty($getAllergy)){?>
			<div class="inner_title" align="left">
				<h3>
					&nbsp;
					<?php echo __('PATIENT HISTORY', true); ?>
				</h3>
			</div> <?php }?> <!-- Past Medication Section --> <!--  Medication History -->
			<?php if(!empty($getMedicationHistory)){	
				$route=Configure::read('route_administration');
				$frequency=Configure::read('frequency');
	//$dose=Configure::read('roop'); ?>


			<table width="100%" cellpadding="0" cellspacing="1" border="0"
				class="tabularForm resTableConf" id="container-medication">
				<thead>
					<tr class="row_title">
						<th class="table_cell"><strong><?php echo __('Medication History:', true); ?>
						</strong></th>
						<th class="table_cell"><strong><?php echo __('Direction', true); ?>
						</strong>
						</th>
						<th class="table_cell"><strong><?php echo __('Stop Date/Time', true); ?>
						</strong></th>
						<th class="table_cell"><strong><?php echo __('Refills', true); ?>
						</strong></th>
					</tr>
				</thead>
				<?php 
				$dose = Configure :: read('dose_type');
				foreach($getMedicationHistory as $key=>$medData){
					if($toggle == 0){
				echo "<tr class='row_gray'>";
				$toggle = 1;
			}else{
				echo "<tr>";
				$toggle = 0;
			}?>

				<td class="table_cell"><?php echo ucfirst($medData['NewCropPrescription']['description']);?>
				</td>
				<td class="table_cell"><?php echo "<b>Route:</b> ".$route[$medData['NewCropPrescription']['route']].'  ';echo " <b> Dose:</b>".$dose[$medData['NewCropPrescription']['dose']].'  ';echo " <b> Frequency:</b>".$frequency[$medData['NewCropPrescription']['frequency']];?>
				</td>
				<td class="table_cell"><?php echo $this->DateFormat->formatDate2Local($medData['NewCropPrescription']['stopdose'],Configure::read('date_format')); ?>
				</td>
				<td class="table_cell"><?php echo $medData['NewCropPrescription']['refills'];?>
				</td>
				</tr>
				<?php }?>
			</table>
			<p></p> <?php }?> <!--Eof Past Medication section  --> <!--  Past Medical History -->

			<?php if(!empty($pastMedicalHistory)){?>
			<table width="100%" cellpadding="0" cellspacing="1" border="0"
				class="tabularForm resTableConf" id="container-lab">
				<thead>
					<tr class="row_title">
						<th class="table_cell"><strong><?php echo __('Past Medical History:', true); ?>
						</strong>
						</th>
					</tr>
				</thead>
				<?php if($pastMedicalHistory[0]['PastMedicalHistory']['no_known_problems'] == 1){?>
				<tr>
					<td class="table_cell"><?php echo 'No known problems'; ?></td>
				</tr>
				<?php }else{
					foreach($pastMedicalHistory as $key=>$pastMedicalData){
	if($toggle == 0){
		echo "<tr class='row_gray'>";
		$toggle = 1;
	}else{
		echo "<tr>";
		$toggle = 0;
	}?>
				<td class="table_cell"><?php echo ucfirst(strtolower($pastMedicalData['PastMedicalHistory']['illness'])); ?>
				</td>
				</tr>
				<?php }
}?>
			</table>
			<p></p> <?php }?> <!-- Past Surgical History --> <?php if(!empty($procedureHistoryRec)){?>

			<table width="100%" cellpadding="0" cellspacing="1" border="0"
				class="tabularForm resTableConf" id="container-lab">
				<thead>
					<tr class="row_title">
						<th class="table_cell"><strong><?php echo __('Surgical/Hospitalization:', true); ?>
						</strong></th>
						<th class="table_cell"><strong><?php echo __('Provider', true); ?>
						</strong>
						</th>
						<th class="table_cell"><strong><?php echo __('Date', true); ?> </strong>
						</th>
					</tr>
				</thead>

				<?php if($procedureHistoryRec[0]['ProcedureHistory']['no_surgical'] == 1){?>
				<tr>
					<td class="table_cell" colspan="3"><?php echo 'No past surgical history'; ?>
					</td>
				
				
				<tr>
					<?php }else{
						foreach($procedureHistoryRec as $key=>$procedureHistory){
		if($toggle == 0){
				echo "<tr class='row_gray'>";
				$toggle = 1;
			}else{
				echo "<tr>";
				$toggle = 0;
			}?>
					<td class="table_cell"><?php echo ucfirst(strtolower($procedureHistory['ProcedureHistory']['procedure_name'])); ?>
					</td>
					<td class="table_cell"><?php echo $procedureHistory['ProcedureHistory']['provider_name'] ?>
					</td>
					<td class="table_cell"><?php echo $this->DateFormat->formatDate2Local($procedureHistory['ProcedureHistory']['procedure_date'],Configure::read('date_format'),false);?>
					</td>
				</tr>
				<?php }
}?>



			</table>
			<p></p> <?php }?> <!-- Family History --> <?php if(!empty($getpatientfamilyhistory)){?>
			<table width="100%" cellpadding="0" cellspacing="1" border="0"
				class="tabularForm resTableConf" id="container-lab">
				<thead>
					<tr class="row_title">
						<th class="table_cell" colspan="3"><strong><?php echo __('Family History:', true); ?>
						</strong>
						</th>
					</tr>
					<tr class="row_title">
						<th class="table_cell"><strong><?php echo __('Relation', true); ?>
						</strong>
						</th>
						<th class="table_cell"><strong><?php echo __('Problem', true); ?>
						</strong>
						</th>
					</tr>
				</thead>
				<?php if($getpatientfamilyhistory["FamilyHistory"]['is_positive_family'] == 1){?>
				<tr>
					<td class="table_cell" colspan="3"><?php echo 'No Positive Family History '; ?>
					</td>
				</tr>
				<?php }else{?>
				<?php
				$getpatientfamilyhistory["FamilyHistory"]['problemf']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['problemf']));
				$getpatientfamilyhistory["FamilyHistory"]['statusf']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['statusf']));
				$getpatientfamilyhistory["FamilyHistory"]['commentsf']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['commentsf']));

				$getpatientfamilyhistory["FamilyHistory"]['problemm']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['problemm']));
				$getpatientfamilyhistory["FamilyHistory"]['statusm']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['statusm']));
				$getpatientfamilyhistory["FamilyHistory"]['commentsm']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['commentsm']));

				$getpatientfamilyhistory["FamilyHistory"]['problemb']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['problemb']));
				$getpatientfamilyhistory["FamilyHistory"]['statusb']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['statusb']));
				$getpatientfamilyhistory["FamilyHistory"]['commentsb']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['commentsb']));

				$getpatientfamilyhistory["FamilyHistory"]['problems']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['problems']));
				$getpatientfamilyhistory["FamilyHistory"]['statuss']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['statuss']));
				$getpatientfamilyhistory["FamilyHistory"]['commentss']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['commentss']));

				$getpatientfamilyhistory["FamilyHistory"]['problemson']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['problemson']));
				$getpatientfamilyhistory["FamilyHistory"]['statusson']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['statusson']));
				$getpatientfamilyhistory["FamilyHistory"]['commentsson']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['commentsson']));

				$getpatientfamilyhistory["FamilyHistory"]['problemd']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['problemd']));
				$getpatientfamilyhistory["FamilyHistory"]['statusd']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['statusd']));
				$getpatientfamilyhistory["FamilyHistory"]['commentsd']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['commentsd']));

				$getpatientfamilyhistory["FamilyHistory"]['problemuncle']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['problemuncle']));
				$getpatientfamilyhistory["FamilyHistory"]['statusuncle']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['statusuncle']));
				$getpatientfamilyhistory["FamilyHistory"]['commentsuncle']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['commentsuncle']));

				$getpatientfamilyhistory["FamilyHistory"]['problemaunt']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['problemaunt']));
				$getpatientfamilyhistory["FamilyHistory"]['statusaunt']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['statusaunt']));
				$getpatientfamilyhistory["FamilyHistory"]['commentsaunt']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['commentsaunt']));

				$getpatientfamilyhistory["FamilyHistory"]['problemgrandmother']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['problemgrandmother']));
				$getpatientfamilyhistory["FamilyHistory"]['statusgrandmother']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['statusgrandmother']));
				$getpatientfamilyhistory["FamilyHistory"]['commentsgrandmother']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['commentsgrandmother']));

				$getpatientfamilyhistory["FamilyHistory"]['problemgrandfather']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['problemgrandfather']));
				$getpatientfamilyhistory["FamilyHistory"]['statusgrandfather']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['statusgrandfather']));
				$getpatientfamilyhistory["FamilyHistory"]['commentsgrandfather']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['commentsgrandfather']));
				/*  */

				/*  array_filter starting*/
				$getpatientfamilyhistory["FamilyHistory"]['problemf'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['problemf']));
				$getpatientfamilyhistory['FamilyHistory']['statusf'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['statusf']));
				$getpatientfamilyhistory['FamilyHistory']['commentsf'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['commentsf']));

				$getpatientfamilyhistory['FamilyHistory']['problemm'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['problemm']));
				$getpatientfamilyhistory['FamilyHistory']['statusm'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['statusm']));
				$getpatientfamilyhistory['FamilyHistory']['commentsm'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['commentsm']));

				$getpatientfamilyhistory['FamilyHistory']['problemb'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['problemb']));
				$getpatientfamilyhistory['FamilyHistory']['statusb'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['statusb']));
				$getpatientfamilyhistory['FamilyHistory']['commentsb'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['commentsb']));

				$getpatientfamilyhistory['FamilyHistory']['problems'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['problems']));
				$getpatientfamilyhistory['FamilyHistory']['statuss'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['statuss']));
				$getpatientfamilyhistory['FamilyHistory']['commentss'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['commentss']));

				$getpatientfamilyhistory['FamilyHistory']['problemson'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['problemson']));
				$getpatientfamilyhistory['FamilyHistory']['statusson'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['statusson']));
				$getpatientfamilyhistory['FamilyHistory']['commentsson'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['commentsson']));

				$getpatientfamilyhistory['FamilyHistory']['problemd'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['problemd']));
				$getpatientfamilyhistory['FamilyHistory']['statusd'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['statusd']));
				$getpatientfamilyhistory['FamilyHistory']['commentsd'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['commentsd']));

				$getpatientfamilyhistory['FamilyHistory']['problemuncle'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['problemuncle']));
				$getpatientfamilyhistory['FamilyHistory']['statusuncle'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['statusuncle']));
				$getpatientfamilyhistory['FamilyHistory']['commentsuncle'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['commentsuncle']));

				$getpatientfamilyhistory['FamilyHistory']['problemaunt'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['problemaunt']));
				$getpatientfamilyhistory['FamilyHistory']['statusaunt'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['statusaunt']));
				$getpatientfamilyhistory['FamilyHistory']['commentsaunt'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['commentsaunt']));

				$getpatientfamilyhistory['FamilyHistory']['problemgrandmother'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['problemgrandmother']));
				$getpatientfamilyhistory['FamilyHistory']['statusgrandmother'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['statusgrandmother']));
				$getpatientfamilyhistory['FamilyHistory']['commentsgrandmother'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['commentsgrandmother']));

				$getpatientfamilyhistory['FamilyHistory']['problemgrandfather'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['problemgrandfather']));
				$getpatientfamilyhistory['FamilyHistory']['statusgrandfather'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['statusgrandfather']));
						$getpatientfamilyhistory['FamilyHistory']['commentsgrandfather'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['commentsgrandfather']));?>


				<?php 
				/*Loop For Father  */
				if(isset($getpatientfamilyhistory["FamilyHistory"]['problemf']) && !empty($getpatientfamilyhistory["FamilyHistory"]['problemf'])){
			$countfather=count($getpatientfamilyhistory["FamilyHistory"]['problemf']);
		}
		for($iFather=0;$iFather<$countfather;)
		{
			$problemfather= isset($getpatientfamilyhistory["FamilyHistory"]['problemf'][$iFather])?$getpatientfamilyhistory["FamilyHistory"]['problemf'][$iFather]:'' ;
			$statusfather= isset($getpatientfamilyhistory["FamilyHistory"]['statusf'][$iFather])?$getpatientfamilyhistory["FamilyHistory"]['statusf'][$iFather]:'' ;
			if($iFather==0){
			$father = 'Father';
		}else{
			$father = '';
		}
		?>
				<tr>
					<td class="table_cell"><?php echo $father; ?></td>
					<td class="table_cell"><?php echo $problemfather; ?></td>
				</tr>
				<?php $iFather++; 
}?>


				<?php 
				/*Loop For Mother  */
				if(isset($getpatientfamilyhistory["FamilyHistory"]['problemm']) && !empty($getpatientfamilyhistory["FamilyHistory"]['problemm'])){
			$countMother=count($getpatientfamilyhistory["FamilyHistory"]['problemm']);
		}
		for($iMom=0;$iMom<$countMother;)
		{
			$problemMother= isset($getpatientfamilyhistory["FamilyHistory"]['problemm'][$iMom])?$getpatientfamilyhistory["FamilyHistory"]['problemm'][$iMom]:'' ;
			$statusMother= isset($getpatientfamilyhistory["FamilyHistory"]['statusm'][$iMom])?$getpatientfamilyhistory["FamilyHistory"]['statusm'][$iMom]:'' ;
			if($iMom==0){
			$mother = 'Mother';
		}else{
			$mother = '';
		}
		?>
				<tr>
					<td class="table_cell"><?php echo $mother; ?></td>
					<td class="table_cell"><?php echo $problemMother; ?></td>
				</tr>
				<?php $iMom++; 
}?>


				<?php 
				/*Loop For Brother  */
				if(isset($getpatientfamilyhistory["FamilyHistory"]['problemb']) && !empty($getpatientfamilyhistory["FamilyHistory"]['problemb'])){
			$countBrother=count($getpatientfamilyhistory["FamilyHistory"]['problemb']);
		}
		for($iBro=0;$iBro<$countBrother;)
		{
			$problemBro= isset($getpatientfamilyhistory["FamilyHistory"]['problemb'][$iBro])?$getpatientfamilyhistory["FamilyHistory"]['problemb'][$iBro]:'' ;
			$statusBro= isset($getpatientfamilyhistory["FamilyHistory"]['statusb'][$iBro])?$getpatientfamilyhistory["FamilyHistory"]['statusb'][$iBro]:'' ;
			if($iBro==0){
			$brother = 'Brother';
		}else{
			$brother = '';
		}
		?>
				<tr>
					<td class="table_cell"><?php echo $brother; ?></td>
					<td class="table_cell"><?php echo $problemBro; ?></td>
				</tr>
				<?php $iBro++; 
}?>


				<?php 
				/*Loop For Sister  */
				if(isset($getpatientfamilyhistory["FamilyHistory"]['problems']) && !empty($getpatientfamilyhistory["FamilyHistory"]['problems'])){
			$countSister=count($getpatientfamilyhistory["FamilyHistory"]['problems']);
		}
		for($iSis=0;$iSis<$countSister;)
		{
			$problemSis= isset($getpatientfamilyhistory["FamilyHistory"]['problems'][$iSis])?$getpatientfamilyhistory["FamilyHistory"]['problems'][$iSis]:'' ;
			$statusSis= isset($getpatientfamilyhistory["FamilyHistory"]['statuss'][$iSis])?$getpatientfamilyhistory["FamilyHistory"]['statuss'][$iSis]:'' ;
			if($iSis==0){
			$sister = 'Sister';
		}else{
			$sister = '';
		}
		?>
				<tr>
					<td class="table_cell"><?php echo $sister; ?></td>
					<td class="table_cell"><?php echo $problemSis; ?></td>
				</tr>
				<?php $iSis++; 
}?>

				<?php 
				/*Loop For Son  */
				if(isset($getpatientfamilyhistory["FamilyHistory"]['problemson']) && !empty($getpatientfamilyhistory["FamilyHistory"]['problemson'])){
			$countSon=count($getpatientfamilyhistory["FamilyHistory"]['problemson']);
		}
		for($iSon=0;$iSon<$countSon;)
		{
			$problemSon= isset($getpatientfamilyhistory["FamilyHistory"]['problemson'][$iSon])?$getpatientfamilyhistory["FamilyHistory"]['problemson'][$iSon]:'' ;
			$statusSon= isset($getpatientfamilyhistory["FamilyHistory"]['statusson'][$iSon])?$getpatientfamilyhistory["FamilyHistory"]['statusson'][$iSon]:'' ;
			if($iSon==0){
			$son = 'Son';
		}else{
			$son = '';
		}
		?>
				<tr>
					<td class="table_cell"><?php echo $son; ?></td>
					<td class="table_cell"><?php echo $problemSon; ?></td>
				</tr>
				<?php $iSon++; 
}?>

				<?php 
				/*Loop For Daughter  */
				if(isset($getpatientfamilyhistory["FamilyHistory"]['problemd']) && !empty($getpatientfamilyhistory["FamilyHistory"]['problemd'])){
			$countDaughter=count($getpatientfamilyhistory["FamilyHistory"]['problemd']);
		}
		for($iDaughter=0;$iDaughter<$countDaughter;)
		{
			$problemDaughter= isset($getpatientfamilyhistory["FamilyHistory"]['problemd'][$iDaughter])?$getpatientfamilyhistory["FamilyHistory"]['problemd'][$iDaughter]:'' ;
			$statusDaughter= isset($getpatientfamilyhistory["FamilyHistory"]['statusd'][$iDaughter])?$getpatientfamilyhistory["FamilyHistory"]['statusd'][$iDaughter]:'' ;
			if($iDaughter==0){
			$daughter = 'Daughter';
		}else{
			$daughter = '';
		}
		?>
				<tr>
					<td class="table_cell"><?php echo $daughter; ?></td>
					<td class="table_cell"><?php echo $problemDaughter; ?></td>
				</tr>
				<?php $iDaughter++; 
}?>

				<?php 
				/*Loop For Uncle  */
				if(isset($getpatientfamilyhistory["FamilyHistory"]['problemuncle']) && !empty($getpatientfamilyhistory["FamilyHistory"]['problemuncle'])){
			$countUncle=count($getpatientfamilyhistory["FamilyHistory"]['problemuncle']);
		}
		for($iUncle=0;$iUncle<$countUncle;)
		{
			$problemUncle= isset($getpatientfamilyhistory["FamilyHistory"]['problemuncle'][$iUncle])?$getpatientfamilyhistory["FamilyHistory"]['problemuncle'][$iUncle]:'' ;
			$statusUncle= isset($getpatientfamilyhistory["FamilyHistory"]['statusuncle'][$iUncle])?$getpatientfamilyhistory["FamilyHistory"]['statusuncle'][$iUncle]:'' ;
			if($iUncle==0){
			$uncle = 'Uncle';
		}else{
			$uncle = '';
		}
		?>
				<tr>
					<td class="table_cell"><?php echo $uncle; ?></td>
					<td class="table_cell"><?php echo $problemUncle; ?></td>
				</tr>
				<?php $iUncle++; 
}?>


				<?php 
				/*Loop For Aunt  */
				if(isset($getpatientfamilyhistory["FamilyHistory"]['problemaunt']) && !empty($getpatientfamilyhistory["FamilyHistory"]['problemaunt'])){
			$countAunt=count($getpatientfamilyhistory["FamilyHistory"]['problemaunt']);
		}
		for($iAunt=0;$iAunt<$countAunt;)
		{
			$problemAunt= isset($getpatientfamilyhistory["FamilyHistory"]['problemaunt'][$iAunt])?$getpatientfamilyhistory["FamilyHistory"]['problemaunt'][$iAunt]:'' ;
			$statusAunt= isset($getpatientfamilyhistory["FamilyHistory"]['statusaunt'][$iAunt])?$getpatientfamilyhistory["FamilyHistory"]['statusaunt'][$iAunt]:'' ;
			if($iAunt==0){
			$aunt = 'Aunt';
		}else{
			$aunt = '';
		}
		?>
				<tr>
					<td class="table_cell"><?php echo $aunt; ?></td>
					<td class="table_cell"><?php echo $problemAunt; ?></td>
				</tr>
				<?php $iAunt++; 
}?>


				<?php 
				/*Loop For Grandmother  */
				if(isset($getpatientfamilyhistory["FamilyHistory"]['problemgrandmother']) && !empty($getpatientfamilyhistory["FamilyHistory"]['problemgrandmother'])){
			$countGrandmother=count($getpatientfamilyhistory["FamilyHistory"]['problemgrandmother']);
		}
		for($iGrandmother=0;$iGrandmother<$countGrandmother;)
		{
			$problemGrandmother= isset($getpatientfamilyhistory["FamilyHistory"]['problemgrandmother'][$iGrandmother])?$getpatientfamilyhistory["FamilyHistory"]['problemgrandmother'][$iGrandmother]:'' ;
			$statusGrandmother= isset($getpatientfamilyhistory["FamilyHistory"]['statusgrandmother'][$iGrandmother])?$getpatientfamilyhistory["FamilyHistory"]['statusgrandmother'][$iGrandmother]:'' ;
			if($iGrandmother==0){
			$grandmother = 'Grandmother';
		}else{
			$grandmother = '';
		}
		?>
				<tr>
					<td class="table_cell"><?php echo $grandmother; ?></td>
					<td class="table_cell"><?php echo $problemGrandmother; ?></td>
				</tr>
				<?php $iGrandmother++; 
}?>

				<?php 
				/*Loop For Grandfather  */
				if(isset($getpatientfamilyhistory["FamilyHistory"]['problemgrandfather']) && !empty($getpatientfamilyhistory["FamilyHistory"]['problemgrandfather'])){
			$countGrandfather=count($getpatientfamilyhistory["FamilyHistory"]['problemgrandfather']);
		}
		for($iGrandfather=0;$iGrandfather<$countGrandfather;)
		{
			$problemGrandfather= isset($getpatientfamilyhistory["FamilyHistory"]['problemgrandfather'][$iGrandfather])?$getpatientfamilyhistory["FamilyHistory"]['problemgrandfather'][$iGrandfather]:'' ;
			$statusGrandfather= isset($getpatientfamilyhistory["FamilyHistory"]['statusgrandfather'][$iGrandfather])?$getpatientfamilyhistory["FamilyHistory"]['statusgrandfather'][$iGrandfather]:'' ;
			if($iGrandfather==0){
			$grandmother = 'Grandfather';
		}else{
			$grandmother = '';
		}
		?>
				<tr>
					<td class="table_cell"><?php echo $grandmother; ?></td>
					<td class="table_cell"><?php echo $problemGrandfather; ?></td>
				</tr>
				<?php $iGrandfather++; 
}?>
				<?php }?>
				<!--  end of else-->
			</table>
			<p></p> <?php }?> <!--  Social History --> <?php //debug($diagnosisRec);?>
			<?php if(/* !empty($diagnosisRec['PatientPersonalHistory']['work']) || */ !empty($getmaritailStatusData) || !empty($diagnosisRec['PatientPersonalHistory']['exercise_frequency'])){?>

			<table width="100%" cellpadding="0" cellspacing="1" border="0"
				class="tabularForm resTableConf" id="container-lab">
				<thead>
					<tr class="row_title">
						<th class="table_cell"><strong><?php echo __('Social History:', true); ?>
						</strong></th>
					</tr>
				</thead>
				<tr>
					<td class="table_cell"><?php echo "Marital Status :"?> <?php echo $getmaritailStatusData ?>
					</td>
				</tr>
				<tr>
					<td class="table_cell"><?php echo "Children :"?> <?php echo 'None'?>
					</td>
				</tr>
				<?php if($diagnosisRec['PatientPersonalHistory']['exercise_frequency']!='' || !empty($diagnosisRec['PatientPersonalHistory']['exercise_frequency'])){?>
				<tr>
					<td class="table_cell"><?php echo "Exercise :"?> <?php echo 'Frequency is '. $diagnosisRec['PatientPersonalHistory']['exercise_frequency']?>
					</td>
				</tr>
				<?php }?>

			</table>
			<p></p> <?php }?> <!--  Tobacco/Alcohol/Supplements --> <?php if(!empty($diagnosisRec['PatientPersonalHistory']['smoking_fre']) || !empty($diagnosisRec['PatientPersonalHistory']['smoking_desc']) || !empty($diagnosisRec['PatientPersonalHistory']['alchohol_q1']) || !empty($diagnosisRec['PatientPersonalHistory']['alchohol_q2']) || !empty($diagnosisRec['PatientPersonalHistory']['alchohol_q3'])){?>

			<table width="100%" cellpadding="0" cellspacing="1" border="0"
				class="tabularForm resTableConf" id="container-lab">
				<thead>
					<tr class="row_title">
						<th class="table_cell" colspan="3"><strong><?php echo __('Tobacco/Alcohol/Supplements:', true); ?>
						</strong></th>
					</tr>
				</thead>
				<?php if($diagnosisRec['PatientPersonalHistory']['smoking'] =='1'){
					$smoking_desc = ($diagnosisRec['PatientPersonalHistory']['smoking_desc']=='Since' || $diagnosisRec['PatientPersonalHistory']['smoking_desc']=='')?' ':'Since '.$diagnosisRec['PatientPersonalHistory']['smoking_desc'];
					?>
				<tr>
					<td class="table_cell" colspan="3"><?php echo 'Tobacco :'?> <?php echo $smokingOptions[$diagnosisRec['PatientPersonalHistory']['smoking_fre']] .' '. $smoking_desc ?>
					</td>
				</tr>
				<?php }?>
				<?php if($diagnosisRec['PatientPersonalHistory']['alcohol_score']){?>
				<?php 
				$ques1=array('0'=>'Never','1'=>'Monthly or less','2'=>'2-4 times a month','3'=>'2-3 times a week','4'=>'4 or more times a week');
				$ques2=array('0'=>'Never','1'=>'1 or 2','2'=>'3 or 4','3'=>'5 or 6','4'=>'7 to 9','4'=>'10 or more');
		$ques3=array('0'=>'Never ','1'=>'Less than monthly','2'=>'Monthly ','3'=>'Weekly ','4'=>'Daily or almost daily');?>
				<tr>
					<td class="table_cell" colspan="3"><?php echo "Alcohol :"?> <?php echo $ques2[$diagnosisRec['PatientPersonalHistory']['alchohol_q2']].' drink '.$ques1[$diagnosisRec['PatientPersonalHistory']['alchohol_q1']]?>
					</td>
				</tr>
				<?php }?>
				 
				<?php if($diagnosisRec['PatientPersonalHistory']['tobacco'] =='1'){?>
				<?php if($diagnosisRec['PatientPersonalHistory']['tobacco_fre'] && $diagnosisRec['PatientPersonalHistory']['tobacco_desc'] && $diagnosisRec['PatientPersonalHistory']['another'] ){?>
				<tr>
					<td class="table_cell" colspan="3"><?php echo 'Caffeine Usage :'?>
						<?php echo 'Frequency is '.$diagnosisRec['PatientPersonalHistory']['tobacco_fre'] .' Since '. $diagnosisRec['PatientPersonalHistory']['tobacco_desc'].' ( '.$diagnosisRec['PatientPersonalHistory']['another'] .' ) ' ?>
					</td>
				</tr>
				<?php }?>
				<?php }?>
			</table>
			<p></p> <?php }?> <?php if(!empty($getAllergy[0]['NewCropAllergies']['name'])){?>
			<table width="100%" cellpadding="0" cellspacing="1" border="0"
				class="tabularForm resTableConf" id="container-allergy">
				<thead>
					<tr class="row_title">

						<th class="table_cell"><strong><?php echo __('Allergies:', true); ?>
						</strong>
						</th>
					</tr>
				
				
				<thead>
					<?php foreach($getAllergy as $key=>$algyData){
						if($toggle == 0){
				echo "<tr class='row_gray'>";
				$toggle = 1;
			}else{
				echo "<tr>";
				$toggle = 0;
			}?>
					<td class="table_cell"><?php echo $algyData['NewCropAllergies']['name']; ?>
					</td>
					</tr>
					<?php }?>
			
			</table>
			<p></p> <?php } ?> 
			<?php if(($getNoteData['Note']['object'] && !empty($getNoteData['Note']['object']) && $getNoteData['Note']['object']!='') || ($peNewData != '' && !empty($peNewData)  && isset($peNewData))){?>
			<div class="inner_title" align="left">
				<h3>
					&nbsp;
					<?php echo __('OBJECTIVE', true); ?>
				</h3>
			</div>
			<table width="100%" cellpadding="0" cellspacing="1" border="0"
				class="tabularForm resTableConf" id="">
				<thead>
					<tr class="row_title">
						<th class="table_cell" width="34%"><strong><?php echo __('PE:', true); ?>
						</strong></th>
					</tr>
				</thead>
				<?php 
				//debug($hpiMasterData);

				$hpiRosSentence = GeneralHelper::createHpiSentence($hpiMasterData,$hpiResultOther,$rosResultOther);
				$HpiNew = $hpiRosSentence['HpiSentence']; $RosNew = $hpiRosSentence['RosSentence'];
				$peNewData = GeneralHelper::createPhysicalExamSentence($hpiMasterData,$peResultOther,$pEButtonsOptionValue);/** function returns Physical Exam sentence */
				?>
				<tr class='row_gray'>
					<td class="table_cell"><?php echo ucfirst($peNewData); ?></td>
				</tr>
				<tr class='row_gray'>
					<td class="table_cell"><?php echo ucfirst($getNoteData['Note']['object']); ?>
					</td>
				</tr>
			</table>
			<p></p> <?php }?>
			 <?php if(($getNoteData['Note']['assis'] && !empty($getNoteData['Note']['assis']))||!empty($getProblem)||!empty($getMedication)||!empty($getPcare)){?>
			<div class="inner_title" align="left">
				<h3>
					&nbsp;
					<?php echo __('ASSESSMENT', true); ?>
				</h3>
			</div> <?php }?> <?php if($getNoteData['Note']['assis'] && !empty($getNoteData['Note']['assis'])){?>
			<table width="100%" cellpadding="0" cellspacing="1" border="0"
				class="tabularForm resTableConf" id="">
				<thead>
					<tr class="row_title">
						<th class="table_cell"><strong><?php echo __('Assessment:', true); ?>
						</strong></th>
					</tr>
				</thead>
				<tr class='row_gray'>
					<td class="table_cell"><?php echo ucfirst($getNoteData['Note']['assis']); ?>
					</td>
				</tr>

			</table>
			<p></p> <?php }?> <?php if(!empty($getProblem)){?>

			<table width="100%" cellpadding="0" cellspacing="1" border="0"
				class="tabularForm resTableConf" id="container-problem">
				<thead>
					<tr class="row_title">

						<th class="table_cell"><strong><?php echo __('Diagnoses:', true); ?>
						</strong></th>
						<th class="table_cell"><strong><?php echo __('Record Date', true); ?>
						</strong></th>
					</tr>
				</thead>
				<?php foreach($getProblem as $key=>$problemData){
					if($toggle == 0){
				echo "<tr class='row_gray'>";
				$toggle = 1;
			}else{
				echo "<tr>";
				$toggle = 0;
			}?>
				<td class="table_cell"><?php echo $problemData['NoteDiagnosis']['diagnoses_name']; ?>
				</td>
				<td class="table_cell"><?php echo $this->DateFormat->formatDate2Local($problemData['NoteDiagnosis']['start_dt'],Configure::read('date_format')); ?>
				</td>
				</tr>
				<?php }?>
			</table>
			<p></p> <?php }?> <?php if(!empty($getMedication)){	
				$route=Configure::read('route_administration');
				$frequency=Configure::read('frequency');
	//$dose=Configure::read('roop');
	$dose = Configure :: read('dose_type'); ?>


			<table width="100%" cellpadding="0" cellspacing="1" border="0"
				class="tabularForm resTableConf" id="container-medication">
				<thead>
					<tr class="row_title">
						<th class="table_cell"><strong><?php echo __('Medication Prescribed:', true); ?>
						</strong></th>
						<th class="table_cell"><strong><?php echo __('Direction', true); ?>
						</strong>
						</th>
						<th class="table_cell"><strong><?php echo __('Date of Prescription', true); ?>
						</strong></th>
						<th class="table_cell"><strong><?php echo __('Refills', true); ?>
						</strong></th>
					</tr>
				</thead>
				<?php foreach($getMedication as $key=>$medData){
					if($toggle == 0){
				echo "<tr class='row_gray'>";
				$toggle = 1;
			}else{
				echo "<tr>";
				$toggle = 0;
			}?>

				<td class="table_cell"><?php echo ucfirst($medData['NewCropPrescription']['description']);?>
				</td>
				<td class="table_cell"><?php echo "<b>Route:</b> ".$route[$medData['NewCropPrescription']['route']].'  ';echo " <b> Dose:</b>".$dose[$medData['NewCropPrescription']['dose']].'  ';echo " <b> Frequency:</b>".$frequency[$medData['NewCropPrescription']['frequency']];?>
				</td>
				<td class="table_cell"><?php echo $this->DateFormat->formatDate2Local($medData['NewCropPrescription']['created'],Configure::read('date_format')); ?>
				</td>
				<td class="table_cell"><?php echo $medData['NewCropPrescription']['refills'];?>
				</td>
				</tr>
				<?php }?>
			</table>
			<p></p> <?php }?> <!-- For Other Care --> <?php if(!empty($getPcare)){?>

			<?php
			$nameListCat=array();
			$cnt=0;
			foreach( $getPcare as $careData){
 	$cnt++;
 	foreach($catList as $key=>$maincat){
		if(strtolower($maincat)!='med' && strtolower($maincat)!='rad' && strtolower($maincat)!='lab'){
			if($maincat==$careData['PatientOrder']['type']){
				$nameListCat[$key][$cnt]['name']=$careData['PatientOrder']['name'];
				$nameListCat[$key][$cnt]['type']=$careData['PatientOrder']['type'];
				$nameListCat[$key][$cnt]['status']=$careData['PatientOrder']['status'];
				$nameListCat[$key][$cnt]['id']=$careData['PatientOrder']['id'];
			}
		}
	}
}?>
			<table width="100%" cellpadding="0" cellspacing="1" border="0"
				class="tabularForm resTableConf" id="container-rad">
				<thead>
					<tr class="row_title">
						<th class="table_cell"><strong><?php echo __('Orders:', true); ?> </strong>
						</th>

					</tr>
				</thead>
				<?php foreach($nameListCat as $key=>$careData){ ?>

				<?php   foreach($careData as $care){ 
					if($toggle == 0){
				echo "<tr class='row_gray'>";
				$toggle = 1;
			}else{
				echo "<tr>";
				$toggle = 0;
			}?>
				<td class="table_cell"><?php echo ucfirst($care['name']); ?></td>
				</tr>
				<?php } 
}?>
			</table>
			<p></p> <?php } ?> <?php 
			$exploadData = explode(':', $getNoteData['Note']['plan']);
if(($exploadData[0] !="" && !empty($exploadData[0])) || !empty($getLab) || !empty($getRad) || !empty($procedureData) || !empty($past_immunization_details)){?>
			<div class="inner_title" align="left">
				<h3>
					&nbsp;
					<?php echo __('PLAN', true); ?>
				</h3>
			</div> <?php }?> <?php
			$exploadData = explode(':::', $getNoteData['Note']['plan']);
if($exploadData[0] !="" && !empty($exploadData[0])){?>
			<table width="100%" cellpadding="0" cellspacing="1" border="0"
				class="tabularForm resTableConf" id="">
				<thead>
					<tr class="row_title">
						<th class="table_cell"><strong><?php echo __('Patient Instruction:', true); ?>
						</strong></th>
					</tr>
				</thead>

				<tr class='row_gray'>
					<td class="table_cell"><?php echo ucfirst($exploadData[0]); ?></td>
				</tr>

			</table>
			<p></p> <?php }?> <?php if(!empty($getLab)){?>
			<table width="100%" cellpadding="0" cellspacing="1" border="0"
				class="tabularForm resTableConf" id="container-lab">
				<thead>
					<tr class="row_title">
						<th class="table_cell"><strong><?php echo __('Laboratory:', true); ?>
						</strong>
						</th>
						<th class="table_cell"><strong><?php echo __('Order ID', true); ?>
						</strong>
						</th>
						<th class="table_cell"><strong><?php echo __('Order', true); ?>
						</strong></th>
					</tr>
				</thead>
				<?php foreach($getLab as $key=>$labData){
					if($toggle == 0){
				echo "<tr class='row_gray'>";
				$toggle = 1;
			}else{
				echo "<tr>";
				$toggle = 0;
			}?>
				<td class="table_cell"><?php echo $labData['Laboratory']['name']; ?>
				</td>
				<td class="table_cell"><?php echo $labData['LaboratoryTestOrder']['order_id']; ?>
				</td>
				<td class="table_cell"><?php $expDate=explode(' ',$labData['LaboratoryTestOrder']['start_date']); 
	echo $this->DateFormat->formatDate2Local($expDate['0'],Configure::read('date_format'));?>
				</td>
				</tr>
				<?php }?>
			</table>
			<p></p> <?php }?> <?php if(!empty($getRad)){?>
			<table width="100%" cellpadding="0" cellspacing="1" border="0"
				class="tabularForm resTableConf" id="container-rad">
				<thead>
					<tr class="row_title">
						<th class="table_cell"><strong><?php echo __('Radiologies:', true); ?>
						</strong>
						</th>
						<th class="table_cell"><strong><?php echo __('Order ID', true); ?>
						</strong>
						</th>
						<th class="table_cell"><strong><?php echo __('Order', true); ?>
						</strong>
						
						</td>
					</tr>
				</thead>
				<?php foreach($getRad as $key=>$radData){
					if($toggle == 0){
				echo "<tr class='row_gray'>";
				$toggle = 1;
			}else{
				echo "<tr>";
				$toggle = 0;
			}?>
				<td class="table_cell"><?php echo $radData['Radiology']['name']; ?>
				</td>
				<td class="table_cell"><?php echo $radData['RadiologyTestOrder']['order_id']; ?>
				</td>
				<td class="table_cell"><?php echo $this->DateFormat->formatDate2Local($radData['RadiologyTestOrder']['create_time'],Configure::read('date_format'));?>
				</td>
				</tr>
				<?php }?>
			</table>
			<p></p> <?php } ?> <?php if(!empty($procedureData)){?>
			<div class="inner_title" align="left">
				<h3>
					&nbsp;
					<?php echo __('PROCEDURE PERFORM', true); ?>
				</h3>
			</div>
			<table width="100%" cellpadding="0" cellspacing="1" border="0"
				class="tabularForm resTableConf" id="container-rad">
				<thead>
					<tr class="row_title">
						<th class="table_cell"><strong><?php echo __('Procedure Name:', true); ?>
						</strong></th>
						<th class="table_cell"><strong><?php echo __('Procedure Date', true); ?>
						</strong></th>
						<th class="table_cell"><strong><?php echo __('CPT Code', true); ?>
						</strong>
						
						</td>
					</tr>
				</thead>
				<?php foreach($procedureData as $key=>$procData){
					if($toggle == 0){
				echo "<tr class='row_gray'>";
				$toggle = 1;
			}else{
				echo "<tr>";
				$toggle = 0;
			}?>
				<td class="table_cell"><?php echo $procData['ProcedurePerform']['procedure_name']; ?>
				</td>
				<td class="table_cell"><?php echo $this->DateFormat->formatDate2Local($procData['ProcedurePerform']['procedure_date'],Configure::read('date_format'));?>
				</td>
				<td class="table_cell"><?php echo $procData['ProcedurePerform']['snowmed_code']; ?>
				</td>
				</tr>
				<?php }?>
			</table>
			<p></p> <?php } ?> <!--Immunization  --> <?php if(!empty($past_immunization_details)){?>
			<table width="100%" cellpadding="0" cellspacing="1" border="0"
				class="tabularForm resTableConf" id="container-lab">
				<thead>
					<tr class="row_title">
						<th class="table_cell"><strong><?php echo __('Immunization:', true); ?>
						</strong></th>
						<th class="table_cell"><strong><?php echo __('Administered Amount', true); ?>
						</strong></th>
						<th class="table_cell"><strong><?php echo __('Administration Date', true); ?>
						</strong></th>
						<th class="table_cell"><strong><?php echo __('Vaccine Expiration Date', true); ?>
						</strong></th>
					</tr>
				</thead>
				<?php foreach($past_immunization_details as $key=>$subData){
					if($toggle == 0){
				echo "<tr class='row_gray'>";
				$toggle = 1;
			}else{
				echo "<tr>";
				$toggle = 0;
			}?>
				<td class="table_cell"><?php echo ucfirst(strtolower($subData['Immunization']['vaccine_type'])); ?>
				</td>
				<td class="table_cell"><?php echo $subData['Immunization']['amount'];?>&nbsp;<?php echo $subData['PhvsMeasureOfUnit']['value_code']; ?>
					<?php if(empty($subData['Immunization']['amount'])){
						echo ('Unknown');
					} ?></td>
				<td class="table_cell"><?php echo $this->DateFormat->formatDate2Local($subData['Immunization']['date'],Configure::read('date_format'),true);?>
					<?php if(empty($subData['Immunization']['date'])){
						echo ('Unknown');
					} ?></td>
				<td class="table_cell"><?php echo $this->DateFormat->formatDate2Local($subData['Immunization']['expiry_date'],Configure::read('date_format'),true);?>
					<?php if(empty($subData['Immunization']['expiry_date'])){
						echo ('Unknown');
					}?></td>
				</tr>
				<?php }?>
			</table>
			<p></p> <?php }?>
		</td>
	</tr>
</table>
 <?php  if($this->params['named']['slug']=='true' || $slug=='slug'){
			 
			 	$exploadData = explode(':', $getNoteData['Note']['plan']);
			 	if(
			 			(!empty($bmiData)) ||
			 			(((!empty($getChiefCompalints['Diagnosis']['complaints']) && $getChiefCompalints['Diagnosis']['complaints'] !="" ) || ((!empty($getChiefCompalints['Diagnosis']['nursing_notes']) && $getChiefCompalints['Diagnosis']['nursing_notes'] !="" )) ||((!empty($getChiefCompalints['Diagnosis']['family_tit_bit']) && $getChiefCompalints['Diagnosis']['family_tit_bit'] !="" )) ||((!empty($getChiefCompalints['Diagnosis']['flag_event']) && $getChiefCompalints['Diagnosis']['flag_event'] !="" )))|| (!empty($getNoteData['Note']['subject']) && $getNoteData['Note']['subject']!='')) ||
			 			((!empty($getNoteData['Note']['subject']) && $getNoteData['Note']['subject']!='') || ($HpiNew != '' && !empty($HpiNew) && !isset($HpiNew))) ||
			 			(($getNoteData['Note']['ros'] && !empty($getNoteData['Note']['ros']) && $getNoteData['Note']['ros']!='') || ($RosNew != '' && !empty($RosNew)  && !isset($RosNew))) ||
			 			(!empty($pastMedicalHistory) || !empty($procedureHistoryRec) || !empty($getpatientfamilyhistory) || !empty($diagnosisRec['PatientPersonalHistory']['smoking_fre']) || !empty($getAllergy)) ||
			 			(!empty($getMedicationHistory)) ||
			 			(!empty($pastMedicalHistory)) ||
			 			(!empty($procedureHistoryRec)) ||
			 			(!empty($getpatientfamilyhistory)) ||
			 			(/* !empty($diagnosisRec['PatientPersonalHistory']['work']) || */ !empty($getmaritailStatusData) || !empty($diagnosisRec['PatientPersonalHistory']['exercise_frequency'])) ||
			 			(!empty($diagnosisRec['PatientPersonalHistory']['smoking_fre']) || !empty($diagnosisRec['PatientPersonalHistory']['smoking_desc']) || !empty($diagnosisRec['PatientPersonalHistory']['alchohol_q1']) || !empty($diagnosisRec['PatientPersonalHistory']['alchohol_q2']) || !empty($diagnosisRec['PatientPersonalHistory']['alchohol_q3'])) ||
			 			(!empty($getAllergy)) ||
			 			(($getNoteData['Note']['object'] && !empty($getNoteData['Note']['object']) && $getNoteData['Note']['object']!='') || ($peNewData != '' && !empty($peNewData)  && !isset($peNewData))) ||
			 			(($getNoteData['Note']['assis'] && !empty($getNoteData['Note']['assis']))||!empty($getProblem)||!empty($getMedication)||!empty($getPcare)) ||
			 			($getNoteData['Note']['assis'] && !empty($getNoteData['Note']['assis'])) ||
			 			(!empty($getProblem)) ||
			 			(!empty($getMedication)) ||
			 			(!empty($getPcare)) ||
			 			(($exploadData[0] !="" && !empty($exploadData[0])) || !empty($getLab) || !empty($getRad) || !empty($procedureData) || !empty($past_immunization_details)) ||
			 			($exploadData[0] !="" && !empty($exploadData[0])) ||
			 			(!empty($getLab)) ||
			 			(!empty($getRad)) ||
			 			(!empty($procedureData)) ||
			 			(!empty($past_immunization_details))
			 		){
			 	?>
					<footer>

					</footer>
					 <?php 
					 }
				 }?>
<script>
function printForCheckBox() {
	
	AjaxUrl = "<?php echo $this->Html->url(array('action' => 'getAllCheckedEncounters',$patientIdsArray,$personId,$appointmentIdsArray,$noteIdsArray));?>",
    window.open(AjaxUrl);
}
</script>