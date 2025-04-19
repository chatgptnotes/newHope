<?php
echo $this->Html->script ( 'jquery.autocomplete' );
echo $this->Html->css ( 'jquery.autocomplete.css' );
?>
<style>
#boxspace {
	border-right: 0.3px solid #384144;
	padding-right: 5px;
}
</style>
<center>
	<h1>
		<?php echo __("Result") ; ?></h1>

</center>

<?php //echo '<pre>';print_r($patientData);exit;?>
<?php

echo $this->Form->create ( 'labHl7Result', array (
		'type' => 'file',
		'id' => 'labfrm',
		'inputDefaults' => array (
				'label' => false,
				'div' => false,
				'error' => false,
				'legend' => false,
				'fieldset' => false 
		) 
) );

?>


<?php

$cnt = 0;
echo $this->Form->hidden ( '0.labHl7Result.resultcount', array (
		'value' => count ( $get_lab_result ) 
) );
foreach ( $get_lab_result as $labEdit ) {
	echo $this->Form->hidden ( $cnt . '.labHl7Result.id', array (
			'value' => $labEdit ['LaboratoryResult'] ['id'] 
	) );
	?>
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
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Date/Time of Birth");?>
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
	
	$races = explode ( ',', $patientData ['Person'] ['race'] );
	$raceString = '';
	foreach ( $races as $rc ) {
		$raceString .= $race [$rc];
	}
	?>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $raceString;?>
		</td>
	
	
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Patient Class");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
	echo $this->Form->input ( $cnt . '.labHl7Result.patient_class', array (
			'value' => $labEdit ['LaboratoryResult'] ['patient_class'],
			'style' => 'width:150px; float:left;',
			'empty' => __ ( 'Please select' ),
			'options' => $hl7PatientClass,
			'id' => 'patient_class' 
	) );
	?>

		</td>
	</tr>

	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Admission Type");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
	
	echo $this->Form->input ( $cnt . '.labHl7Result.admission_type', array (
			'value' => $labEdit ['LaboratoryResult'] ['admission_type'],
			'style' => 'width:150px; float:left;',
			'empty' => __ ( 'Please select' ),
			'options' => $hl7AdmissionType,
			'id' => 'admission_type' 
	) );
	?>

		</td>
	</tr>

	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Admit Date/Time");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
	
	$labEdit ['LaboratoryResult'] ['admit_date_time'] = $this->DateFormat->formatDate2Local ( $labEdit ['LaboratoryResult'] ['admit_date_time'], Configure::read ( 'date_format' ), true );
	echo $this->Form->input ( $cnt . '.labHl7Result.admit_date_time', array (
			'value' => $labEdit ['LaboratoryResult'] ['admit_date_time'],
			'type' => 'text',
			'label' => false,
			'class' => 'textBoxExpnd ',
			'id' => 'admit_date_time' 
	) );
	?>
		</td>
	</tr>

	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Discharge Date/Time");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
	
	$labEdit ['LaboratoryResult'] ['discharge_date_time'] = $this->DateFormat->formatDate2Local ( $labEdit ['LaboratoryResult'] ['discharge_date_time'], Configure::read ( 'date_format' ), true );
	echo $this->Form->input ( $cnt . '.labHl7Result.discharge_date_time', array (
			'value' => $labEdit ['LaboratoryResult'] ['discharge_date_time'],
			'type' => 'text',
			'class' => 'textBoxExpnd ',
			'label' => false,
			'id' => 'discharge_date_time' 
	) );
	?>
		</td>
	</tr>

</table>


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

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.labHl7Result.ogi_placer_order_number', array('disabled' => 'disabled','value'=>$labEdit['LaboratoryResult']['ogi_placer_order_number'],'type'=>'text','label'=>false,'style'=>'width:250px','id' => 'ogi_placer_order_number','value'=>$patientData['LaboratoryTestOrder']['order_id'])); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Filler Order Number");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.labHl7Result.ogi_filler_order_number', array('readonly'=>true,'value'=>$labEdit['LaboratoryResult']['ogi_filler_order_number'],'type'=>'text','label'=>false,'style'=>'width:250px','id' => 'ogi_filler_order_number')); ?>
		</td>
	</tr>
	<!-- 
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Placer Group Number");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.labHl7Result.ogi_placer_group_number', array('value'=>$labEdit['LaboratoryResult']['ogi_placer_group_number'],'type'=>'text','label'=>false,'style'=>'width:250px','id' => 'ogi_placer_group_number')); ?>
		</td>
	</tr> -->
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><strong><?php echo __("Observation details ") ; ?>
		</strong></td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Universal Service Identifier");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
	echo __ ( $patientData ['Laboratory'] ['name'] );
	echo $this->Form->hidden ( $cnt . '.labHl7Result.od_universal_service_identifier', array (
			'value' => $labEdit ['LaboratoryResult'] ['od_universal_service_identifier'],
			'style' => 'width:150px; float:left;',
			'options' => $loincCode,
			'id' => 'od_universal_service_identifier',
			'empty' => 'Please Select' 
	) );
	?>
		</td>
	</tr>

	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Observation  Date/Time");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
	
	echo $labEdit ['LaboratoryResult'] ['od_observation_start_date_time'] = $this->DateFormat->formatDate2Local ( $labEdit ['LaboratoryResult'] ['od_observation_start_date_time'], Configure::read ( 'date_format' ), true );
	/* echo $this->Form->input($cnt.'.labHl7Result.od_observation_start_date_time', array('value'=>$labEdit['LaboratoryResult']['od_observation_start_date_time'],'type'=>'text','label'=>false,'class'=>'textBoxExpnd ','id' => 'od_observation_start_date_time')); */
	?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Observation  End Date/Time");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
	
	echo $labEdit ['LaboratoryResult'] ['od_observation_end_date_time'] = $this->DateFormat->formatDate2Local ( $labEdit ['LaboratoryResult'] ['od_observation_end_date_time'], Configure::read ( 'date_format' ), true );
	/* echo $this->Form->input($cnt.'.labHl7Result.od_observation_end_date_time', array('value'=>$labEdit['LaboratoryResult']['od_observation_end_date_time'],'type'=>'text','label'=>false,'class'=>'textBoxExpnd ','id' => 'od_observation_end_date_time')); */
	?>
		</td>
	</tr>


	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Relevant Clinical Information");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.labHl7Result.od_relevant_clinical_information', array('value'=>$labEdit['LaboratoryResult']['od_relevant_clinical_information'],'type'=>'text','label'=>false,'style'=>'width:250px','id' => 'od_relevant_clinical_information')); ?>
		</td>
	</tr>

	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><strong><?php echo __("Observation Result Information ") ; ?>
		</strong></td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Result Status");?>
		</td>


		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
	echo $this->Form->input ( $cnt . '.labHl7Result.ori_result_status', array (
			'value' => $labEdit ['LaboratoryResult'] ['ori_result_status'],
			'style' => 'width:150px; float:left;',
			'options' => $resultStatus0123,
			'empty' => __ ( 'Please select' ),
			'id' => 'ori_result_status' 
	) );
	?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Result Report/Status change-Date/Time");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
	
	$labEdit ['LaboratoryResult'] ['ori_result_report_status_date_time'] = $this->DateFormat->formatDate2Local ( $labEdit ['LaboratoryResult'] ['ori_result_report_status_date_time'], Configure::read ( 'date_format' ), true );
	echo $this->Form->input ( $cnt . '.labHl7Result.ori_result_report_status_date_time', array (
			'value' => $labEdit ['LaboratoryResult'] ['ori_result_report_status_date_time'],
			'type' => 'text',
			'label' => false,
			'class' => 'textBoxExpnd ',
			'id' => 'ori_result_report_status_date_time' 
	) );
	?>
		</td>
	</tr>

	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><strong><?php echo __("Observation Notes") ; ?>
		</strong></td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Notes and Comments");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.labHl7Result.on_notes_comments', array('value'=>$labEdit['LaboratoryResult']['on_notes_comments'],'type'=>'text','label'=>false,'style'=>'width:250px','id' => 'on_notes_comments')); ?>
		</td>
	</tr>

</table>


<!-- Observation Details Ends -->
<!-- Reason for Study Start -->

<!--  Ends -->


<table width="100%" border="0" cellspacing="0" cellpadding="0"
	class="formFull">
	<tr>
		<th colspan="5"><?php echo __("Specimen Information") ; ?></th>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Entity Identifier");?>
		</td>



		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.labHl7Result.si_entity_identifier', array('value'=>$labEdit['LaboratoryResult']['si_entity_identifier'],'type'=>'text','label'=>false,'style'=>'width:250px','id' => 'si_entity_identifier')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Type");?>
		</td>



		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
	// for display only
	echo $this->Form->input ( $cnt . '.labHl7Result.si_specimen_type_disp', array (
			'style' => 'width:150px; float:left;',
			'class' => 'siType',
			'id' => $cnt . 'si_specimen_type_disp',
			'value' => $labEdit ['siType'] ['display_name'] 
	) );
	// for interting value to db
	echo $this->Form->hidden ( $cnt . '.labHl7Result.si_specimen_type', array (
			'id' => $cnt . 'si_specimen_type',
			'value' => $labEdit ['LaboratoryResult'] ['si_specimen_type'] 
	) );
	?>
		</td>
	</tr>

	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Type Modifier");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
	echo $this->Form->input ( $cnt . '.labHl7Result.si_specimen_type_modifier', array (
			'value' => $labEdit ['LaboratoryResult'] ['si_specimen_type_modifier'],
			'style' => 'width:150px; float:left;',
			'options' => $sp_type_modifier_options,
			'empty' => __ ( 'Please select' ),
			'id' => 'si_specimen_type_modifier' 
	) );
	?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Activities");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
	echo $this->Form->input ( $cnt . '.labHl7Result.si_specimen_type_activities_disp', array (
			'value' => $labEdit ['Specimen_activities'] ['display_name'],
			'style' => 'width:150px; float:left;',
			'class' => 'speciActi',
			'id' => 'si_specimen_type_activities_disp' 
	) );
	echo $this->Form->hidden ( $cnt . '.labHl7Result.si_specimen_type_activities', array (
			'value' => $labEdit ['LaboratoryResult'] ['si_specimen_type_activities'],
			'id' => 'si_specimen_type_activities' 
	) );
	?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Collection Method");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
	echo $this->Form->input ( $cnt . '.labHl7Result.si_specimen_col_method_disp', array (
			'value' => $labEdit ['specimenColMethod'] ['display_name'],
			'style' => 'width:150px; float:left;',
			'class' => 'specimenColMeth',
			'id' => 'si_specimen_col_method_disp' 
	) );
	echo $this->Form->hidden ( $cnt . '.labHl7Result.si_specimen_col_method', array (
			'value' => $labEdit ['LaboratoryResult'] ['si_specimen_col_method'],
			'id' => 'si_specimen_col_method' 
	) );
	?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Source Site");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
	echo $this->Form->input ( $cnt . '.labHl7Result.si_specimen_source', array (
			'value' => $labEdit ['LaboratoryResult'] ['si_specimen_source'],
			'style' => 'width:150px; float:left;',
			'options' => $body_site_options,
			'empty' => __ ( 'Please select' ),
			'id' => 'si_specimen_source' 
	) );
	?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Source Site Modifier");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
	echo $this->Form->input ( $cnt . '.labHl7Result.si_specimen_source_modifier', array (
			'value' => $labEdit ['LaboratoryResult'] ['si_specimen_source_modifier'],
			'style' => 'width:150px; float:left;',
			'options' => $sp_type_modifier_options,
			'empty' => __ ( 'Please select' ),
			'id' => 'si_specimen_source_modifier' 
	) );
	?>
		</td>
	</tr>

	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Role");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
	echo $this->Form->input ( $cnt . '.labHl7Result.si_specimen_role', array (
			'value' => $labEdit ['LaboratoryResult'] ['si_specimen_role'],
			'style' => 'width:150px; float:left;',
			'options' => $specimen_role_options,
			'empty' => __ ( 'Please select' ),
			'id' => 'si_specimen_role' 
	) );
	?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Collection Amount");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.labHl7Result.si_specimen_col_quantity', array('value'=>$labEdit['LaboratoryResult']['si_specimen_col_quantity'],'type'=>'text','label'=>false,'style'=>'width:250px','id' => 'si_specimen_col_quantity')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Collection Units");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
	echo $this->Form->input ( $cnt . '.labHl7Result.si_specimen_col_amount_disp', array (
			'value' => $labEdit ['Ucums'] ['display_name'],
			'style' => 'width:150px; float:left;',
			'class' => 'specColAmm',
			'id' => 'si_specimen_col_amount_disp' 
	) );
	echo $this->Form->hidden ( $cnt . '.labHl7Result.si_specimen_col_amount', array (
			'value' => $labEdit ['LaboratoryResult'] ['si_specimen_col_amount'],
			'id' => 'si_specimen_col_amount' 
	) );
	?>
		</td>
	</tr>


	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen date/time");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
	
	$labEdit ['LaboratoryResult'] ['si_start_date_time'] = $this->DateFormat->formatDate2Local ( $labEdit ['LaboratoryResult'] ['si_start_date_time'], Configure::read ( 'date_format' ), true );
	echo $this->Form->input ( $cnt . '.labHl7Result.si_start_date_time', array (
			'value' => $labEdit ['LaboratoryResult'] ['si_start_date_time'],
			'type' => 'text',
			'label' => false,
			'id' => 'si_start_date_time',
			'class' => 'textBoxExpnd' 
	) );
	?>
		</td>
	</tr>

	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen End date/time");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
	
	$labEdit ['LaboratoryResult'] ['si_end_date_time'] = $this->DateFormat->formatDate2Local ( $labEdit ['LaboratoryResult'] ['si_end_date_time'], Configure::read ( 'date_format' ), true );
	echo $this->Form->input ( $cnt . '.labHl7Result.si_end_date_time', array (
			'value' => $labEdit ['LaboratoryResult'] ['si_end_date_time'],
			'type' => 'text',
			'label' => false,
			'id' => 'si_end_date_time',
			'class' => 'textBoxExpnd' 
	) );
	?>
		</td>
	</tr>


	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Received Date/Time");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
	
	$labEdit ['LaboratoryResult'] ['si_received_date_time'] = $this->DateFormat->formatDate2Local ( $labEdit ['LaboratoryResult'] ['si_received_date_time'], Configure::read ( 'date_format' ), true );
	echo $this->Form->input ( $cnt . '.labHl7Result.si_received_date_time', array (
			'value' => $labEdit ['LaboratoryResult'] ['si_received_date_time'],
			'type' => 'text',
			'label' => false,
			'id' => 'si_received_date_time',
			'class' => 'textBoxExpnd' 
	) );
	?>
		</td>
	</tr>


</table>
<div>&nbsp;</div>
<!--<div>
	 <input class="blueBtn" type="button" value="Add More"
		id="labResultButton"> <input class="blueBtn" type="button"
		value="Remove" id="RemoveLabResultButton"> 
</div>-->
<div id="labHl7Results">
	<?php
	
	$i = 0;
	foreach ( $labEdit ['LaboratoryHl7Result'] as $labObx ) {
		echo $this->Form->input ( $cnt . '.labHl7Result.id_' . $i, array (
				'value' => $labObx ['id'],
				'type' => 'hidden' 
		) );
		?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0"
		class="formFull" id="labHl7Results_0">
		<tr>
			<th colspan="9"><?php echo __("Lab Results") ; ?></th>
		</tr>
		<tr>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Observation");?>
			</td>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Type");?>
			</td>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Result");?>
			</td>
			<td width="19%" valign="middle" class="tdLabel UOM" id="boxspace"><?php echo __("UCUM Units");?>
			</td>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Range");?>
			</td>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Abnormal Falg");?>
			</td>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Status");?>
			</td>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Date/Time of Analysis");?>
			</td>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Notes");?>
			</td>
		</tr>



		<tr>

			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		// old variable to load data $labObx['observations'];
		echo $this->Form->input ( $cnt . '.labHl7Result.observation_' . $i . '_disp', array (
				'value' => $patientData ['Laboratory'] ['name'],
				'style' => 'width:150px; float:left;',
				'class' => 'obser0',
				'id' => 'observation_' . $i . '_disp' 
		) );
		echo $this->Form->hidden ( $cnt . '.labHl7Result.observation_' . $i, array (
				'value' => $patientData ['Laboratory'] ['name'],
				'id' => 'observation_' . $i 
		) );
		?>
			</td>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		echo $this->Form->input ( $cnt . '.labHl7Result.unit_' . $i, array (
				'value' => $labObx ['unit'],
				'style' => 'width:150px; float:left;',
				'options' => $units_option,
				'empty' => __ ( 'Please select' ),
				'id' => 'unit_' . $i,
				'class' => 'myUnit' 
		) );
		if ($labObx ['unit'] == "SN") {
			$res = 'block';
			$val = 'block';
			$sep = 'block';
			$com = 'block';
			$cwe = 'none';
			$obxDrop = 'block';
		} elseif ($labObx ['unit'] == "CWE") {
			$res = 'none';
			$val = 'none';
			$sep = 'none';
			$com = 'none';
			$cwe = 'block';
			$obxDrop = 'none';
		} else {
			$res = 'block';
			$val = 'none';
			$sep = 'none';
			$com = 'block';
			$cwe = 'none';
			$obxDrop = 'block';
		}
		
		?></td>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace">
				<div id="singleRes_0" style="display: <?php echo $res;?>">
					Num1:
					<?php echo $this->Form->input($cnt.'.labHl7Result.sn_result_'.$i, array('value'=>$labObx['result'],'type'=>'text','label'=>false,'style'=>'width:50px','id' => 'sn_result_'.$i)); ?>
				</div>
				<div style="display: <?php echo $val;?>" id="observationLabResult_0">
					<div>
						Comparator:
						<?php echo $this->Form->input($cnt.'.labHl7Result.sn_value_'.$i, array('value'=>$labObx['sn_value'],'type'=>'text','label'=>false,'style'=>'width:10px','id' => 'sn_value_'.$i)); ?>
					</div>
					<div>
						Separator:
						<?php echo $this->Form->input($cnt.'.labHl7Result.sn_separator_'.$i, array('value'=>$labObx['sn_separator'],'type'=>'text','label'=>false,'style'=>'width:50px','id' => 'sn_separator_'.$i)); ?>
					</div>
					<div>
						Num2:
						<?php echo $this->Form->input($cnt.'.labHl7Result.sn_result2_'.$i, array('value'=>$labObx['sn_result2'],'type'=>'text','label'=>false,'style'=>'width:50px','id' => 'sn_result2_'.$i)); ?>
					</div>
				</div>
				<div id="labCodedObservation_0" style="display: <?php echo $cwe;?>">
					<?php
		echo $this->Form->input ( $cnt . '.labHl7Result.result_' . $i, array (
				'value' => $labObx ['result'],
				'style' => 'width:150px; float:left;',
				'options' => $hl7_coded_observation_option,
				'empty' => __ ( 'Please select' ),
				'id' => 'result_' . $i 
		) );
		?>
				</div>


			</td>

			<td width="19%" valign="middle" class="tdLabel UOM" id="boxspace"><?php
		echo $this->Form->input ( $cnt . '.labHl7Result.uom_' . $i . 'disp', array (
				'class' => 'uomRes',
				'value' => $ucums_option [$labObx ['uom']],
				'style' => 'width:150px; float:left;',
				'id' => 'uom_' . $i . '_disp' 
		) );
		echo $this->Form->hidden ( $cnt . '.labHl7Result.uom_' . $i, array (
				'value' => $labObx ['uom'],
				'id' => 'uom_' . $i 
		) );
		?>
			</td>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.labHl7Result.range_'.$i, array('value'=>$labObx['range'],'type'=>'text','label'=>false,'style'=>'width:50px','id' => 'range_'.$i)); ?>
			</td>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		echo $this->Form->input ( $cnt . '.labHl7Result.abnormal_flag_' . $i . '_disp', array (
				'value' => $abnormalFlag [$labObx ['abnormal_flag']],
				'style' => 'width:150px; float:left;',
				'class' => 'abnormalFlg',
				'id' => 'abnormal_flag_' . $i . '_disp' 
		) );
		echo $this->Form->hidden ( $cnt . '.labHl7Result.abnormal_flag_' . $i, array (
				'value' => $labObx ['abnormal_flag'],
				'id' => 'abnormal_flag_' . $i 
		) );
		?>
			</td>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		echo $this->Form->input ( $cnt . '.labHl7Result.status_' . $i, array (
				'value' => $labObx ['status'],
				'style' => 'width:150px; float:left;',
				'options' => $labResultStatus,
				'empty' => __ ( 'Please select' ),
				'id' => 'status_' . $i 
		) );
		?>
			</td>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.labHl7Result.date_time_of_observation_'.$i, array('value'=>$labObx['date_time_of_observation'],'type'=>'text','label'=>false,'style'=>'width:50px','id' => 'date_time_of_observation_'.$i)); ?>
			</td>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.labHl7Result.notes_'.$i, array('value'=>$labObx['notes'],'type'=>'text','label'=>false,'style'=>'width:50px','id' => 'notes_'.$i)); ?>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Observation Method/Text");?>
			</td>
		</tr>

		<tr>

			<td width="19%" valign="middle" class="tdLabel" id="boxspace">
			<?php
		echo $this->Form->input ( $cnt . '.labHl7Result.observation_method_' . $i . '_disp', array (
				'value' => $obsMethod_option [$labObx ['notes']],
				'style' => 'width:150px; float:left;',
				'class' => 'obserMethod',
				'id' => 'observation_method_' . $i . '_disp' 
		) );
		echo $this->Form->hidden ( $cnt . '.labHl7Result.observation_method_' . $i, array (
				'value' => $labObx ['notes'],
				'id' => 'observation_method_' . $i 
		) );
		?>
			</td>
		</tr>
		<tr>
			<td colspan="9"><hr></td>
		</tr>

	</table>
	<?php
		
		$i ++;
	} // --end inner foreach	?>
	<?php echo $this->Form->input($cnt.'.labHl7Result.labcount',array('value'=>count($labEdit['LaboratoryHl7Result']),'type'=>'hidden'));  ?>
</div>
<?php
	
	$cnt ++;
} // --end outer for each
?>


<input class="blueBtn" type=submit value="Submit" name="Submit"
	id="submit">
<!-- <input
	class="blueBtn" type=submit value="Submit & Add More"
	name="Submit & Add More"> -->
<?php
echo $this->Form->hidden ( 'labHl7Result.curdate', array (
		'id' => 'curdate' 
) );
echo $this->Form->end ();
?>
<div id="abnflag" style="display: none">
	<?php echo $this->Form->input('abnormal_flag_0', array('style'=>'width:150px; float:left;','options'=>$abnormalFlag,'empty'=>__('Please select'), 'id'=>'abnormal_flag_0'));?>
</div>
<div id="abnflagstatus" style="display: none">
	<?php echo $this->Form->input('status_0', array('style'=>'width:150px; float:left;','options'=>$labResultStatus,'empty'=>__('Please select'), 'id'=>'status_0'));?>
</div>
<div id="abnflagunit" style="display: none">
	<?php echo $this->Form->input('unit_0', array('style'=>'width:150px; float:left;','options'=>$units_option,'empty'=>__('Please select'), 'id'=>'unit_0','class'=>'myUnit'));?>
</div>
<div id="abnflaguom" style="display: none">
	<?php
	echo $this->Form->input ( $cnt . '.labHl7Result.uom_' . $i . 'disp', array (
			'class' => 'uomRes',
			'value' => $ucums_option [$labObx ['uom']],
			'style' => 'width:150px; float:left;',
			'id' => 'uom_' . $i . '_disp' 
	) );
	echo $this->Form->hidden ( $cnt . '.labHl7Result.uom_' . $i, array (
			'value' => $labObx ['uom'],
			'id' => 'uom_' . $i 
	) );
	?>
</div>
<div id="abnflagobs" style="display: none">
	<?php
	echo $this->Form->input ( 'observation_0_disp', array (
			'style' => 'width:150px; float:left;',
			'class' => 'obser0',
			'id' => 'observation_0_disp' 
	) );
	echo $this->Form->hidden ( 'observation_0', array (
			'id' => 'observation_0' 
	) );
	?>	
</div>
<div id="abnobsmethod" style="display: none">
	<?php echo $this->Form->input('observation_method_0', array('style'=>'width:150px; float:left;','options'=>$obsMethod_option,'empty'=>__('Please select'), 'id'=>'observation_method_0'));?>
	
</div>
<div id="result" style="display: none">
	<?php echo $this->Form->input('result_0', array('style'=>'width:150px; float:left;','options'=>$hl7_coded_observation_option,'empty'=>__('Please select'), 'id'=>'result_0'));?>
</div>





<script>

$('#submit')
.click(
function (){
	var curdate = new Date();
	$("#curdate").val(curdate);
	});
var counter=0;
var firstYr = new Date().getFullYear()-100;
var lastYr = new Date().getFullYear()+10;
var labText = '<tr><th colspan="9">Lab Results</th></tr><tr><td width="19%" valign="middle" class="tdLabel" id="boxspace">Observation</td><td width="19%" valign="middle" class="tdLabel" id="boxspace">Hl7 Units</td><td width="19%" valign="middle" class="tdLabel" id="boxspace">Result</td><td width="19%" valign="middle" class="tdLabel" id="boxspace">UCUM Units</td><td width="19%" valign="middle" class="tdLabel" id="boxspace">Range</td><td width="19%" valign="middle" class="tdLabel" id="boxspace">Abnormal Falg</td><td width="19%" valign="middle" class="tdLabel" id="boxspace">Status</td><td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Date/Time of Analysis");?></td><td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Notes");?></td></tr>';
var labInput = '<tr><td width="19%" valign="middle" class="tdLabel" id="boxspace">###ABNOBSFLG###</td><td width="19%" valign="middle" class="tdLabel" id="boxspace">###ABNUNITFLG###</td><td width="19%" valign="middle" class="tdLabel" id="boxspace"><div id="singleRes_0" style="display:block">Num1:<?php echo $this->Form->input('sn_result_0', array('type'=>'text','label'=>false,'style'=>'width:50px','id' => 'sn_result_0')); ?></div><div  style="display:none" id="observationLabResult_0"><div>Comparator:<?php echo $this->Form->input('sn_value_0', array('type'=>'text','label'=>false,'style'=>'width:10px','id' => 'sn_value_0')); ?></div><div>Separator:<?php echo $this->Form->input('sn_separator_0', array('type'=>'text','label'=>false,'style'=>'width:50px','id' => 'sn_separator_0')); ?></div><div>Num2:<?php echo $this->Form->input('sn_result2_0', array('type'=>'text','label'=>false,'style'=>'width:50px','id' => 'sn_result2_0')); ?></div></div><div id="labCodedObservation_0" style="display:none">###ABNRESULT###</div></td><td width="19%" valign="middle" class="tdLabel" id="boxspace">###ABNUOMFLG###</td><td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input("range_0", array("type"=>"text","label"=>false,"style"=>"width:50px","id" => "range")); ?></td><td width="19%" valign="middle" class="tdLabel" id="boxspace">###ABNFLG###</td><td width="19%" valign="middle" class="tdLabel" id="boxspace">###ABNSTATUS###</td></td><td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('date_time_of_observation_0', array('class'=>'date_administered_cal','type'=>'text','label'=>false,'style'=>'width:50px','id' => 'date_time_of_observation_0')); ?></td><td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('notes_0', array('type'=>'text','label'=>false,'style'=>'width:50px','id' => 'notes_0')); ?></td></tr>';
var labInput1 = '<tr><td width="19%" valign="middle" class="tdLabel" id="boxspace">###ABNOBSFLG###</td><td width="19%" valign="middle" class="tdLabel" id="boxspace">###ABNUNITFLG###</td><td width="19%" valign="middle" class="tdLabel" id="boxspace"><div id="singleRes_0" style="display:block">Num1:<?php echo $this->Form->input('sn_result_0', array('type'=>'text','label'=>false,'style'=>'width:50px','id' => 'sn_result_0')); ?></div><div  style="display:none" id="observationLabResult_0"><div>Comparator:<?php echo $this->Form->input('sn_value_0', array('type'=>'text','label'=>false,'style'=>'width:10px','id' => 'sn_value_0')); ?></div><div>Separator:<?php echo $this->Form->input('sn_separator_0', array('type'=>'text','label'=>false,'style'=>'width:50px','id' => 'sn_separator_0')); ?></div><div>Num2:<?php echo $this->Form->input('sn_result2_0', array('type'=>'text','label'=>false,'style'=>'width:50px','id' => 'sn_result2_0')); ?></div></div><div id="labCodedObservation_0" style="display:none">###ABNRESULT###</div></td><td width="19%" valign="middle" class="tdLabel" id="boxspace">###ABNUOMFLG###</td><td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input("range_0", array("type"=>"text","label"=>false,"style"=>"width:50px","id" => "range")); ?></td><td width="19%" valign="middle" class="tdLabel" id="boxspace">###ABNFLG###</td><td width="19%" valign="middle" class="tdLabel" id="boxspace">###ABNSTATUS###</td></td><td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('date_time_of_observation_0', array('class'=>'date_administered_cal','type'=>'text','label'=>false,'style'=>'width:50px','id' => 'date_time_of_observation_0')); ?></td><td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('notes_0', array('type'=>'text','label'=>false,'style'=>'width:50px','id' => 'notes_0')); ?></td></tr>';

var labTextSecond = '<tr><td width="19%" valign="middle" class="tdLabel" id="boxspace">Observation Method/Text</td></tr>';
var labInputSecond = '<tr><td width="19%" valign="middle" class="tdLabel" id="boxspace">###ABNOBSMETHODFLG###</td></tr><tr><td colspan="9"><hr></td></tr>';
var labInputSecond1 = '<tr><td width="19%" valign="middle" class="tdLabel" id="boxspace">###ABNOBSMETHODFLG###</td></tr><tr><td colspan="9"><hr></td></tr>';


$(function() {
    $("#labResultButton").click(function(event) {
    	ss= "labHl7Results_"+counter ;
		counter++;
		
    	var newCostDiv = $(document.createElement('table')).attr("id",'labHl7Results_'+ counter).attr("class",'formFull');
    	labInput = labInput1;
    	
    	labInput = labInput.replace("###ABNFLG###",$("#abnflag").html()); 
    	labInput = labInput.replace("###ABNRESULT###",$("#result").html());
    	labInput = labInput.replace("###ABNSTATUS###",$("#abnflagstatus").html()); //
    	labInput = labInput.replace("###ABNUNITFLG###",$("#abnflagunit").html());
    	labInput = labInput.replace("###ABNUOMFLG###",$("#abnflaguom").html());
    	labInput = labInput.replace("###ABNOBSFLG###",$("#abnflagobs").html());
    	
    	
    	labInput = labInput.replace(/observation_0/g,"observation_"+counter);
    	labInput = labInput.replace(/observation_0_disp/g,"observation_"+counter+"_disp");
    	labInput = labInput.replace(/uom_0/g,"uom_"+counter); 
		labInput = labInput.replace(/uom_0/g,"uom_"+counter+"_disp"); 
    	 
		labInput = labInput.replace("unit_0","unit_"+counter);
		labInput = labInput.replace("unit_0","unit_"+counter);
		labInput = labInput.replace("sn_value_0","sn_value_"+counter);
		labInput = labInput.replace("result_0","result_"+counter); 
		labInput = labInput.replace("sn_result_0","sn_result_"+counter); 
		
		labInput = labInput.replace("range_0","range_"+counter); 
		labInput = labInput.replace("abnormal_flag_0","abnormal_flag_"+counter); 
		labInput = labInput.replace("status_0","status_"+counter); 
		labInput = labInput.replace("observationLabResult_0","observationLabResult_"+counter); 
		labInput = labInput.replace("labCodedObservation_0","labCodedObservation_"+counter); 
		labInput = labInput.replace("result_0","result_"+counter); 
		labInput = labInput.replace("result_0","result_"+counter); 
		labInput = labInput.replace("result_0","result_"+counter); 
		labInput = labInput.replace("sn_result_0","sn_result_"+counter); 
		labInput = labInput.replace("sn_result_0","sn_result_"+counter); 
		labInput = labInput.replace("sn_result_0","sn_result_"+counter); 

		labInput = labInput.replace("date_time_of_observation_0","date_time_of_observation_"+counter); 
		labInput = labInput.replace("date_time_of_observation_0","date_time_of_observation_"+counter); 

		labInput = labInput.replace("sn_separator_0","sn_separator_"+counter); 
		labInput = labInput.replace("sn_separator_0","sn_separator_"+counter); 

		labInput = labInput.replace("sn_result2_0","sn_result2_"+counter); 
		labInput = labInput.replace("sn_result2_0","sn_result2_"+counter); 

		
		

		labInput = labInput.replace("notes_0","notes_"+counter); 
		labInput = labInput.replace("notes_0","notes_"+counter); 
		labInput = labInput.replace("singleRes_0","singleRes_"+counter); 
		
		
		labInputSecond = labInputSecond1;
		labInputSecond = labInputSecond.replace("###ABNOBSMETHODFLG###",$("#abnobsmethod").html()); 

		labInputSecond = labInputSecond.replace("observation_method_0","observation_method_"+counter); 
		labInputSecond = labInputSecond.replace("observation_method_0","observation_method_"+counter); 

		newCostDiv.append(labText);
		newCostDiv.append(labInput);
		newCostDiv.append(labTextSecond);
		newCostDiv.append(labInputSecond);
		
		
		
		$(newCostDiv).insertAfter('#'+ss);
		$("#labcount").val(counter);
		
		
		
		
		
    });
});


//Test Start

$(function() {
	
		 if($('#unit_0').val() == 'CWE'){
				$('.UOM').hide();
		}else{
			$('.UOM').show();
		}

    $(".myUnit").live("change",function(event) {
    
    id= $(this).attr("id");
    splitted= id.split("_");
    $("#sn_result_"+splitted[1]).val('');
    $("#sn_value_"+splitted[1]).val('');
    $("#sn_separator_"+splitted[1]).val('');
    $("#sn_result2_"+splitted[1]).val('');
    if($("#"+id).val()=='CWE'){
    splitted= id.split("_");

    
    
    
    $("#observationLabResult_"+splitted[1]).hide();
    $("#labCodedObservation_"+splitted[1]).show();
    $("#singleRes_"+splitted[1]).hide();
    $("#uom_"+splitted[1]).hide();
    $(".UOM").hide();
    $("#observation_method_"+splitted[1]).hide();
    
   } 
   else if($("#"+id).val()=='SN'){
	   splitted= id.split("_");
	    $("#observationLabResult_"+splitted[1]).show();
	    $("#labCodedObservation_"+splitted[1]).hide();
	    $("#singleRes_"+splitted[1]).show();
	    $("#uom_"+splitted[1]).show();
	    $(".UOM").show();
	    $("#observation_method_"+splitted[1]).show();
	    
   }else{
	   splitted= id.split("_");
	    $("#observationLabResult_"+splitted[1]).hide();
	    $("#labCodedObservation_"+splitted[1]).hide();
	    $("#singleRes_"+splitted[1]).show();
	    $("#uom_"+splitted[1]).show();
	    $("#observation_method_"+splitted[1]).show();
	    $(".UOM").show();
   }
});
});



$(".date_administered_cal").live("click",function() {
	
	$(this).datepicker({	
				changeMonth : true,
				changeYear : true,
				yearRange: firstYr+':'+lastYr,
			
				dateFormat : 'mm/dd/yy',
				showOn : 'button',
				buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly : true,
				onSelect : function() {
					$(this).focus();
				}
			});
});



//Test End
$(function() {//RemoveLabResultButton
    $("#RemoveLabResultButton").click(function(event) {
    $('#labHl7Results_'+ (counter-1)).nextAll().remove()
		
		counter--;
		
    });
});

$(function() {
			

			$( "#od_observation_date_time" ).datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				changeTime:true,
				showTime: true,  		
				yearRange: '1950',			 
				dateFormat:'yy-mm-dd HH:II:SS',
			});
		
		});
		
$(function() {
			
	
	$( "#od_observation_start_date_time" ).datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		changeTime:true,
		showTime: true,  		
		yearRange: '1950',			 
		dateFormat:'yy-mm-dd HH:II:SS',
	});


			$( "#od_observation_end_date_time" ).datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				changeTime:true,
				showTime: true,  		
				yearRange: '1950',			 
				dateFormat:'yy-mm-dd HH:II:SS',
			});
		
		});
		
$(function() {
			

			$( "#tqi_start_date_time" ).datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				changeTime:true,
				showTime: true,  		
				yearRange: '1950',			 
				dateFormat:'yy-mm-dd HH:II:SS',
			});
		
		});
		
$(function() {
			

			$( "#tqi_end_date_time" ).datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				changeTime:true,
				showTime: true,  		
				yearRange: '1950',			 
				dateFormat:'yy-mm-dd HH:II:SS',
			});
		
		});
		
$(function() {
			

			$( "#si_start_date_time" ).datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				changeTime:true,
				showTime: true,  		
				yearRange: '1950',			 
				dateFormat:'yy-mm-dd HH:II:SS',
			});
		
		});

$(function() {
	

	$( "#si_end_date_time" ).datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		changeTime:true,
		showTime: true,  		
		yearRange: '1950',			 
		dateFormat:'yy-mm-dd HH:II:SS',
	});

});

$(function() {
	

	$( "#si_received_date_time" ).datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		changeTime:true,
		showTime: true,  		
		yearRange: '1950',			 
		dateFormat:'yy-mm-dd HH:II:SS',
	});

});


		
$(function() {
			

			$( "#date_time_of_observation_0" ).datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				changeTime:true,
				showTime: true,  		
				yearRange: '1950',			 
				dateFormat:'yy-mm-dd HH:II:SS',
			});
		
		});//discharge_date_time

$(function() {
			

			$( "#discharge_date_time" ).datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				changeTime:true,
				showTime: true,  		
				yearRange: '1950',			 
				dateFormat:'yy-mm-dd HH:II:SS',
			});
		
		});

$(function() {
	

	$( "#admit_date_time" ).datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		changeTime:true,
		showTime: true,  		
		yearRange: '1950',			 
		dateFormat:'yy-mm-dd HH:II:SS',
	});

});
		
$(function() {
			

			$( "#ori_result_report_status_date_time" ).datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				changeTime:true,
				showTime: true,  		
				yearRange: '1950',			 
				dateFormat:'yy-mm-dd HH:II:SS',
			});
		
		});
		$(function() {
			

			$( ".obs" ).datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				changeTime:true,
				showTime: true,  		
				yearRange: '1950',			 
				dateFormat:'yy-mm-dd HH:II:SS',
			});
		
		});
		$(document).ready(function(){
			 $('.siType').live('focus',function() { 
				$(this).autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","SnomedSctHl7",'code',"display_name",'null',"admin" => false,"plugin"=>false)); ?>",
					{
					width: 250,
					selectFirst: true,
					valueSelected:true,
					loadId : $(this).attr('id')+','+$(this).attr('id').replace("_disp","")
					});
			});

			$('.speciActi').live('focus',function() { 
				$(this).autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","Specimen_activities","value_code","description",'null',"admin" => false,"plugin"=>false)); ?>",
					{
					width: 250,
					selectFirst: true,
					valueSelected:true,
					loadId : $(this).attr('id')+','+$(this).attr('id').replace("_disp","")
					});
				});

			$('.specimenColMeth').live('focus',function() { 
				$(this).autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","SnomedSctHl7",'code',"display_name",'null',"admin" => false,"plugin"=>false)); ?>",
					{
					width: 250,
					selectFirst: true,
					valueSelected:true,
					loadId : $(this).attr('id')+','+$(this).attr('id').replace("_disp","")
					});
			});

			$('.specColAmm').live('focus',function() { 
				$(this).autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","Ucums",'code',"display_name",'null',"admin" => false,"plugin"=>false)); ?>",
					{
					width: 250,
					selectFirst: true,
					valueSelected:true,
					loadId : $(this).attr('id')+','+$(this).attr('id').replace("_disp","")
					});
			});

			$('.obser0').live('focus',function() { 
				$(this).autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","Laboratory",'lonic_code',"name",'null',"admin" => false,"plugin"=>false)); ?>",
					{
					width: 250,
					selectFirst: true,
					valueSelected:true,
					loadId : $(this).attr('id')+','+$(this).attr('id').replace("_disp","")
					});
			});

			$('.uomRes').live('focus',function() { 
				$(this).autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","Ucums",'code',"display_name",'null',"admin" => false,"plugin"=>false)); ?>",
					{
					width: 250,
					selectFirst: true,
					valueSelected:true,
					loadId : $(this).attr('id')+','+$(this).attr('id').replace("_disp","")
					});
			});

			$('.abnormalFlg').live('focus',function() { 
				$(this).autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","ObservationInterpretation0078",'code',"display_name",'null',"admin" => false,"plugin"=>false)); ?>",
					{
					width: 250,
					selectFirst: true,
					valueSelected:true,
					loadId : $(this).attr('id')+','+$(this).attr('id').replace("_disp","")
					});
			});

			$('.obserMethod').live('focus',function() { 
				$(this).autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","Hl7ObservationMethod",'value_code','description','null',"admin" => false,"plugin"=>false)); ?>",
					{
					width: 250,
					selectFirst: true,
					valueSelected:true,
					loadId : $(this).attr('id')+','+$(this).attr('id').replace("_disp","")
					});
			});
		});//obserMethod  Hl7ObservationMethod
		//For flag claculation
		 $('#range_0').blur(function(){
			var baseValue=parseInt($('#sn_result_0').val());
			var range=$('#range_0').val();
			var splitRange=range.split('-');
			var lowerLimit=parseInt(splitRange['0']);
			var upperLimit=parseInt(splitRange['1']);
			if(baseValue < lowerLimit){
				$('#abnormal_flag_0_disp').val('Below low normal');
				$('#abnormal_flag_0').val('L');
				$('#abnormal_flag_0_disp').addClass('blue');
				$('#abnormal_flag_0_disp').removeClass('green');
				$('#abnormal_flag_0_disp').removeClass('orange');
			}
			else if((baseValue >= lowerLimit) && (baseValue <= upperLimit)){
				$('#abnormal_flag_0_disp').val('Normal (applies to non-numeric results)');
				$('#abnormal_flag_0').val('N');
				$('#abnormal_flag_0_disp').addClass('green');
				$('#abnormal_flag_0_disp').removeClass('blue');
				$('#abnormal_flag_0_disp').removeClass('orange');
			}
			else{
				$('#abnormal_flag_0_disp').val('Above high normal');
				$('#abnormal_flag_0').val('H');
				$('#abnormal_flag_0_disp').addClass('orange');
				$('#abnormal_flag_0_disp').removeClass('green');
				$('#abnormal_flag_0_disp').removeClass('blue');
			}
			 });
</script>
<style>
.blue {
	color: blue !important;
}

.green {
	color: green !important;
}

.orange {
	color: orange !important;
}
</style>
