<style>
#boxspace {
	border-right: 0.3px solid #384144;
	padding-right: 5px;
}
</style>
<center>
	<h1>Result</h1>
</center>

<div style="text-align: right;">
			&nbsp;
			<?php
			$testid = $get_lab_result ['0'] ['LaboratoryResult'] ['laboratory_test_order_id'];
			echo $this->Html->link ( __ ( 'Edit Result' ), array (
					'controller' => 'Laboratories',
					'action' => 'editLabHl7Result',
					$patientData ['Patient'] ['id'],
					$testid 
			), array (
					'class' => 'blueBtn' 
			) );
			?>&nbsp;
    	 <?php
						echo $this->Html->link ( __ ( 'back' ), array (
								'controller' => 'Laboratories',
								'action' => 'labTestHl7List',
								$patientData ['Patient'] ['id'] 
						), array (
								'class' => 'blueBtn' 
						) );
						?>
		
</div>
<div>&nbsp;</div>

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
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Administrative Sex");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $patientData['Person']['sex'];?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Race");?>
		</td>
		<?php
		/*
		 * $races = explode(',',$patientData['Person']['race']);//print_r($races);exit;
		 * $raceString = '';
		 * foreach($races as $rc){
		 * $raceString .= $race[$rc];
		 * }
		 */
		?>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php if(!empty($patientData['Race']['race_name'])){echo $patientData['Race']['race_name'];}else{echo 'Denied to specify';}//$raceString;?>
		</td>
	</tr>
	<!-- 
	 <tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Alt Race");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __($race[4]);?>
		</td> 
	</tr>
	-- -->
	<?php
	
	foreach ( $get_lab_result as $labView12 ) {
		// echo '<pre>';print_r($hl7AdmissionType);exit;
		break;
	}
	?>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Admission Type");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __($hl7AdmissionType[$labView12['LaboratoryResult']['admission_type']]);?>
		</td>
	</tr>

	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Patient Class");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __($hl7PatientClass[$labView12['LaboratoryResult']['patient_class']]);?>
		</td>
	</tr>


	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Admit Date/Time ");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		
		$labView12 ['LaboratoryResult'] ['admit_date_time'] = $this->DateFormat->formatDate2Local ( $labView12 ['LaboratoryResult'] ['admit_date_time'], Configure::read ( 'date_format' ), true );
		echo __ ( $labView12 ['LaboratoryResult'] ['admit_date_time'] );
		?>
		</td>
	</tr>

	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Discharge Date/Time  ");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		
		$labView12 ['LaboratoryResult'] ['discharge_date_time'] = $this->DateFormat->formatDate2Local ( $labView12 ['LaboratoryResult'] ['discharge_date_time'], Configure::read ( 'date_format' ), true );
		echo __ ( $labView12 ['LaboratoryResult'] ['discharge_date_time'] );
		?>
		</td>
	</tr>
</table>


<?php //echo '<pre>';print_r($get_lab_result);exit;?>
<?php

foreach ( $get_lab_result as $labView ) {
	
	?>

<!-- Observation Details Starts -->
<table width="100%" border="0" cellspacing="0" cellpadding="0"
	class="formFull">
	<tr>
		<th colspan="5"><?php echo __("Observation Details") ; ?></th>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><strong><?php echo __("Observation General Information ") ; ?>
		</strong></td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Placer Order Number");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $labView['LaboratoryResult']['ogi_placer_order_number'];?>

		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Filler Order Number");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $labView['LaboratoryResult']['ogi_filler_order_number'];?>

		</td>
	</tr>
	<!-- 
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Placer Group Number");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $labView['LaboratoryResult']['ogi_placer_group_number'];?>

		</td>
	</tr> -->
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><strong><?php echo __("Observation details ") ; ?>
		</strong></td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Universal Service Identifier");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $labView['LoincLnHl7']['name']; ?>
		</td>
	</tr>

	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Observation  Date/Time");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $labView['LaboratoryResult']['od_observation_start_date_time'];?>

		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Observation  End Date/Time");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $labView['LaboratoryResult']['od_observation_end_date_time'];?>

		</td>
	</tr>



	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Relevant Clinical Information");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $labView['LaboratoryResult']['od_relevant_clinical_information'];?>

		</td>
	</tr>

	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><strong><?php echo __("Observation Result Information ") ; ?>
		</strong></td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Result Status");?>
		</td>


		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $labView['ResultStatus0123']['display_name']; ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Result Report/Status change-Date/Time");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $labView['LaboratoryResult']['ori_result_report_status_date_time'];?>

		</td>
	</tr>


	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><strong><?php echo __("Observation Notes") ; ?>
		</strong></td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Notes and Comments");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $labView['LaboratoryResult']['on_notes_comments'];?>

		</td>
	</tr>

</table>




<table width="100%" border="0" cellspacing="0" cellpadding="0"
	class="formFull">
	<tr>
		<th colspan="5"><?php echo __("Specimen Information") ; ?></th>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Entity Identifier");?>
		</td>



		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $labView['LaboratoryResult']['si_entity_identifier'];?>

		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Type");?>
		</td>



		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $specimenTypeSnomedSct[$labView['LaboratoryResult']['si_specimen_type']]; ?>
		</td>
	
	
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Type Modifier");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $labView['PHVS_ModifierOrQualifier_CDC']['description'];?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Activities");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $labView['Specimen_activities']['description'];?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Collection Method");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $specimenTypeSnomedSct[$labView['LaboratoryResult']['si_specimen_col_method']];?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Source Site");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $labView['Body_site_value_set']['description'];?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Source Site Modifier");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $phpvsModifier[$labView['LaboratoryResult']['si_specimen_source_modifier']];?>
		</td>
	</tr>

	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Role");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $labView['Specimen_role']['description'];?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Collection Amount");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $labView['LaboratoryResult']['si_specimen_col_quantity'];?>

		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Collection Units");?>
		</td><?php //echo '<pre>';print_r($get_lab_result);exit;?>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $ucums_option[$labView['LaboratoryResult']['si_specimen_col_amount']];?>
		</td>
	</tr>


	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen date/time");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $labView['LaboratoryResult']['si_start_date_time'];?>

		</td>
	</tr>

	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen End date/time ");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $labView['LaboratoryResult']['si_end_date_time'];?>

		</td>
	</tr>

	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Received Date/Time ");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $labView['LaboratoryResult']['si_received_date_time'];?>

		</td>
	</tr>

</table>

<div>&nbsp;</div>
<div id="labHl7Results">

	<table width="100%" border="0" cellspacing="0" cellpadding="0"
		class="formFull" id="labHl7Results_0">
		<tr>
			<th colspan="10"><?php echo __("Lab Results") ; ?></th>
		</tr>
		<tr>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><b><?php echo __("Observation");?></b>
			</td>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><b><?php echo __("Type");?></b>
			</td>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><b><?php echo __("Result");?></b>
			</td>
			<td width="19%" valign="middle" class="tdLabel UOM" id="boxspace"><b><?php echo __("UCUM Units");?></b>
			</td>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><b><?php echo __("Range");?></b>
			</td>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><b><?php echo __("Abnormal Flag");?></b>
			</td>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><b><?php echo __("Status");?></b>
			</td>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><b><?php echo __("Date/Time of Analysis");?></b>
			</td>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><b><?php echo __("Notes");?></b>
			</td>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><b><?php echo __("Observation Method/Text");?></b>
			</td>
		</tr>
		<?php //echo '<pre>';print_r($labView);exit;?>
		<?php foreach($labView['LaboratoryHl7Result'] as $viewLabHl7){?>
		<tr>

			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $labView['Laboratory']['name'];// $viewLabHl7['observations'];//'hi'.$labView['LoincLnHl7']['name']; ?>
			</td>
			<td width="19%" valign="middle" class="tdLabel TYPE" id="boxspace"><?php echo $units_option[$viewLabHl7['unit']]; ?>
			</td>

			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $viewLabHl7['sn_value']; ?>
				<?php echo $viewLabHl7['result']; ?> <?php echo $viewLabHl7['sn_separator']; ?>
				<?php echo $viewLabHl7['sn_result2']; ?>
			</td>

			<td width="19%" valign="middle" class="tdLabe UOM" id="boxspace"><?php echo $ucums_option[$viewLabHl7['uom']]; ?>
			</td>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $viewLabHl7['range']; ?>
			</td>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $abnormalFlag[$viewLabHl7['abnormal_flag']]; ?>
			</td>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $labResultStatus[$viewLabHl7['status']]; ?>
			</td>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $viewLabHl7['date_time_of_observation']; ?>
			</td>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $viewLabHl7['notes']; ?>
			</td>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $obsMethod_option[$viewLabHl7['observation_method']]; ?>
			</td>
		</tr>
		<tr>
			<td colspan="10"><hr></td>
		</tr>
		<?php  }?>
	</table>
</div>
<div>&nbsp;</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0"
	class="formFull">
	<tr>
		<th width="19%" valign="middle" class="tdLabel" id="boxspace"
			colspan="2"><strong><?php echo __("Observation Notes") ; ?> </strong>
		</th>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><b><?php echo __("Notes and Comments");?></b>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $labView['LaboratoryResult']['re_notes_comments']; ?>
		</td>
	</tr>
</table>
<?php
	break;
}
?>
<div>&nbsp;</div>
<script>
$(function(){
	if($.trim($('.TYPE').html()) == 'Coded with Exceptions'){
		$('.UOM').hide();
	}
});
</script>
