<style>
#boxspace {
	border-right: 0.3px solid #384144;
	padding-right: 5px;
}
</style>
<center>
	<h1>Result

</center>

<?php
echo $this->Form->create ( 'labHl7Result', array (
		'type' => 'file',
		'id' => 'labfrm',
		'inputDefaults' => array (
				'label' => false,
				'legend' => false,
				'fieldset' => false 
		) 
) );
echo $this->Form->hidden ( 'current_time', array (
		'id' => 'current_time' 
) );
?>

</div>
<?php
// echo "<pre>"; print_r($get_lab_result);
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

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $patientData['Person']['dob'];?>
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
	
	$races = explode ( ',', $patientData ['Person'] ['race'] );
	$raceString = '';
	foreach ( $races as $rc ) {
		$raceString .= $race [$rc];
	}
	if ($raceString == ', ') {
		echo $raceString = '';
	}
	
	?>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $raceString[];?>
		</td>
	</tr>

</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0"
	class="formFull">
	<tr>
		<th colspan="5"><?php echo __("Ordering Provider") ; ?></th>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Name");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.labHl7Result.op_name', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'op_name','value'=>$doctorData['User']['first_name'].$doctorData['User']['last_name'])); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Identifier number");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.labHl7Result.op_identifier_number', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'op_identifier_number','value'=>$doctorData['User']['id'])); ?>
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

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.labHl7Result.ogi_placer_order_number', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'ogi_placer_order_number','value'=>$patientData['LaboratoryTestOrder']['order_id'])); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Filler Order Number");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.labHl7Result.ogi_filler_order_number', array('value'=>$labEdit['LaboratoryResult']['ogi_filler_order_number'],'type'=>'text','label'=>false,'style'=>'width:250px','id' => 'ogi_filler_order_number')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Placer Group Number");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.labHl7Result.ogi_placer_group_number', array('value'=>$labEdit['LaboratoryResult']['ogi_placer_group_number'],'type'=>'text','label'=>false,'style'=>'width:250px','id' => 'ogi_placer_group_number')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><strong><?php echo __("Observation details ") ; ?>
		</strong></td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Universal Service Identifier");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
	$pleaseSelect = array (
			'0' => 'Please Select' 
	);
	$loincCode = array_merge ( $pleaseSelect, $loincCode );
	echo $this->Form->input ( $cnt . '.labHl7Result.od_universal_service_identifier', array (
			'value' => $labEdit ['LaboratoryResult'] ['od_universal_service_identifier'],
			'style' => 'width:150px; float:left;',
			'empty' => __ ( 'Please select' ),
			'options' => $loincCode,
			'id' => 'od_universal_service_identifier' 
	) );
	?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Observation  Date/Time");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.labHl7Result.od_observation_start_date_time', array('value'=>$labEdit['LaboratoryResult']['od_observation_start_date_time'],'type'=>'text','label'=>false,'style'=>'width:250px','id' => 'od_observation_start_date_time')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Observation  End Date/Time");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.labHl7Result.od_observation_end_date_time', array('value'=>$labEdit['LaboratoryResult']['od_observation_end_date_time'],'type'=>'text','label'=>false,'style'=>'width:250px','id' => 'od_observation_end_date_time')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Action Code");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
	echo $this->Form->input ( $cnt . '.labHl7Result.od_specimen_action_code', array (
			'value' => $labEdit ['LaboratoryResult'] ['od_specimen_action_code'],
			'style' => 'width:150px; float:left;',
			'options' => $speciemtActionCode0065,
			'empty' => __ ( 'Please select' ),
			'id' => 'od_specimen_action_code' 
	) );
	?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Relevant Clinical Information");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
	echo $this->Form->input ( $cnt . '.labHl7Result.od_relevant_clinical_information', array (
			'value' => $labEdit ['LaboratoryResult'] ['od_relevant_clinical_information'],
			'empty' => 'Please Select',
			'style' => 'width:150px; float:left;',
			'options' => $specimenTypeSnomedSct,
			'id' => 'od_relevant_clinical_information' 
	) );
	?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Relevant Clinical Information Original Text");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.labHl7Result.od_relevent_clinical_information_original_text', array('value'=>$labEdit['LaboratoryResult']['od_relevent_clinical_information_original_text'],'type'=>'text','label'=>false,'style'=>'width:250px','id' => 'od_relevent_clinical_information_original_text')); ?>
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
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><strong><?php echo __("Result copy To") ; ?>
		</strong></td>
	</tr>

	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Prefix/Suffix");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.labHl7Result.rct_prefix', array('value'=>$labEdit['LaboratoryResult']['rct_prefix'],'type'=>'text','label'=>false,'style'=>'width:50px','id' => 'rct_prefix','div'=>false)); ?>
			<?php echo $this->Form->input($cnt.'.labHl7Result.rct_suffix', array('value'=>$labEdit['LaboratoryResult']['rct_suffix'],'type'=>'text','label'=>false,'style'=>'width:50px','id' => 'rct_suffix','div'=>false)); ?>

		</td>
	</tr>

	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("First Name");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.labHl7Result.rct_name', array('value'=>$labEdit['LaboratoryResult']['rct_name'],'type'=>'text','label'=>false,'style'=>'width:250px','id' => 'rct_name')); ?>
		</td>
	</tr>

	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Middle Name");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.labHl7Result.rct_middle_name', array('value'=>$labEdit['LaboratoryResult']['rct_middle_name'],'type'=>'text','label'=>false,'style'=>'width:250px','id' => 'rct_middle_name')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Last Name");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.labHl7Result.rct_last_name', array('value'=>$labEdit['LaboratoryResult']['rct_last_name'],'type'=>'text','label'=>false,'style'=>'width:250px','id' => 'rct_last_name')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Indentifier number");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.labHl7Result.rct_identifier', array('value'=>$labEdit['LaboratoryResult']['rct_identifier'],'type'=>'text','label'=>false,'style'=>'width:250px','id' => 'rct_identifier')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><strong><?php echo __("Result Handling") ; ?>
		</strong></td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Standard");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.labHl7Result.rh_standard', array('value'=>$labEdit['LaboratoryResult']['rh_standard'],'options'=>array(''=>'Please Select','Carbon Copy'=>'Carbon Copy'),'label'=>false,'style'=>'width:250px','id' => 'rh_standard')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Local");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.labHl7Result.rh_local', array('value'=>$labEdit['LaboratoryResult']['rh_local'],'options'=>array(''=>'Please Select','Send Copy'=>'Send Copy'),'label'=>false,'style'=>'width:250px','id' => 'rh_local')); ?>
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
<table width="100%" border="0" cellspacing="0" cellpadding="0"
	class="formFull">
	<tr>
		<th colspan="5"><?php echo __("Timing/Quantity Information") ; ?></th>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Start Date/Time");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.labHl7Result.tqi_start_date_time', array('value'=>$labEdit['LaboratoryResult']['tqi_start_date_time'],'type'=>'text','label'=>false,'style'=>'width:250px','id' => 'tqi_start_date_time')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("End Date/Time");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.labHl7Result.tqi_end_date_time', array('value'=>$labEdit['LaboratoryResult']['tqi_end_date_time'],'type'=>'text','label'=>false,'style'=>'width:250px','id' => 'tqi_end_date_time')); ?>
		</td>
	</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0"
	class="formFull">
	<tr>
		<th colspan="5"><?php echo __("Specimen Information") ; ?></th>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Type");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
	echo $this->Form->input ( $cnt . '.labHl7Result.si_specimen_type', array (
			'value' => $labEdit ['LaboratoryResult'] ['si_specimen_type'],
			'style' => 'width:150px; float:left;',
			'empty' => __ ( 'Please select' ),
			'options' => $specimenTypeSnomedSct,
			'id' => 'si_specimen_type' 
	) );
	?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Original Text");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.labHl7Result.si_specimen_original_text', array('value'=>$labEdit['LaboratoryResult']['si_specimen_original_text'],'type'=>'text','label'=>false,'style'=>'width:250px','id' => 'si_specimen_original_text')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Start date/time");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.labHl7Result.si_start_date_time', array('value'=>$labEdit['LaboratoryResult']['si_start_date_time'],'type'=>'text','label'=>false,'style'=>'width:250px','id' => 'si_start_date_time')); ?>
		</td>
	</tr>
	<tr>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Reject Reason");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
	echo $this->Form->input ( $cnt . '.labHl7Result.si_specimen_reject_reason', array (
			'value' => $labEdit ['LaboratoryResult'] ['si_specimen_reject_reason'],
			'style' => 'width:150px; float:left;',
			'options' => $specimenRejectReason,
			'empty' => __ ( 'Please select' ),
			'id' => 'si_specimen_reject_reason' 
	) );
	?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Reject Reason Original Text");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.labHl7Result.si_reject_reason_original_text', array('value'=>$labEdit['LaboratoryResult']['si_reject_reason_original_text'],'type'=>'text','label'=>false,'style'=>'width:250px','id' => 'si_reject_reason_original_text')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Condition ");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
	echo $this->Form->input ( $cnt . '.labHl7Result.si_specimen_condition', array (
			'value' => $labEdit ['LaboratoryResult'] ['si_specimen_condition'],
			'style' => 'width:150px; float:left;',
			'options' => $specimenConditionReason,
			'empty' => __ ( 'Please select' ),
			'id' => 'si_specimen_condition' 
	) );
	?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Condition Original Text ");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.labHl7Result.si_condition_original_text', array('value'=>$labEdit['LaboratoryResult']['si_condition_original_text'],'type'=>'text','label'=>false,'style'=>'width:250px','id' => 'si_condition_original_text')); ?>
		</td>
	</tr>
</table>

<!-- add more feature working but removed <div>
	<input class="blueBtn" type="button" value="Add More"
		id="labResultButton"> <input class="blueBtn" type="button"
		value="Remove" id="RemoveLabResultButton">
</div> -->
<div>&nbsp;</div>
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
			<th colspan="10"><?php echo __("Lab Results") ; ?></th>
		</tr>
		<tr>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Observation");?>
			</td>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Type");?>
			</td>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Result");?>
			</td>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("UOM");?>
			</td>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Range");?>
			</td>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Abnormal Flag");?>
			</td>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Status");?>
			</td>
		</tr>
		<tr>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		echo $this->Form->input ( $cnt . '.labHl7Result.observation_' . $i, array (
				'value' => $labObx ['observation'],
				'style' => 'width:150px; float:left;',
				'options' => $loincCode,
				'empty' => __ ( 'Please select' ),
				'id' => 'observation_0',
				'selected' => "" 
		) );
		?>
			</td>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		echo $this->Form->input ( $cnt . '.labHl7Result.unit_0', array (
				'value' => $labObx ['unit'],
				'style' => 'width:150px; float:left;',
				'options' => $units_option,
				'empty' => __ ( 'Please select' ),
				'id' => 'unit_0',
				'class' => 'myUnit' 
		) );
		?>
			</td>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><div
					style="display: block" id="observationLabResult_0">
					<?php echo $this->Form->input($cnt.'.labHl7Result.sn_value_'.$i, array('value'=>$labObx['sn_value'],'type'=>'text','label'=>false,'style'=>'width:10px','id' => 'sn_value_0')); ?>
					<?php echo $this->Form->input($cnt.'.labHl7Result.sn_result_'.$i, array('value'=>$labObx['result'],'type'=>'text','label'=>false,'style'=>'width:50px','id' => 'sn_result_0')); ?>
				</div>
				<div id="labCodedObservation_0" style="display: none">
					<?php
		echo $this->Form->input ( $cnt . '.labHl7Result.result_' . $i, array (
				'value' => $labObx ['result'],
				'style' => 'width:150px; float:left;',
				'options' => $specimenTypeSnomedSct,
				'empty' => __ ( 'Please select' ),
				'id' => 'result_0' 
		) );
		?>
				</div></td>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		echo $this->Form->input ( $cnt . '.labHl7Result.uom_' . $i, array (
				'value' => $labObx ['uom'],
				'style' => 'width:150px; float:left;',
				'options' => $ucums_option,
				'empty' => __ ( 'Please select' ),
				'id' => 'uom_0' 
		) );
		?>
			</td>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.labHl7Result.range_'.$i, array('value'=>$labObx['range'],'type'=>'text','label'=>false,'style'=>'width:50px','id' => 'range_0')); ?>
			</td>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		echo $this->Form->input ( $cnt . '.labHl7Result.abnormal_flag_' . $i, array (
				'value' => $labObx ['abnormal_flag'],
				'style' => 'width:150px; float:left;',
				'options' => $abnormalFlag,
				'empty' => __ ( 'Please select' ),
				'id' => 'abnormal_flag_0' 
		) );
		?>
			</td>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		echo $this->Form->input ( $cnt . '.labHl7Result.status_' . $i, array (
				'value' => $labObx ['status'],
				'style' => 'width:150px; float:left;',
				'options' => $labResultStatus,
				'empty' => __ ( 'Please select' ),
				'id' => 'status_0' 
		) );
		?>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td colspan="10"><hr></td>
		</tr>
	</table>
</div>
<?php
		
		$i ++;
	} // --end inner foreach	?>
<table width="100%" border="0" cellspacing="0" cellpadding="0"
	class="formFull">
	<tr>
		<th width="19%" valign="middle" class="tdLabel" id="boxspace"
			colspan="2"><strong><?php echo __("Notes and Comments") ; ?> </strong>
		</th>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Notes and Comments");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.labHl7Result.re_notes_comments', array('value'=>$labEdit['LaboratoryResult']['re_notes_comments'],'type'=>'text','label'=>false,'style'=>'width:250px','id' => 're_notes_comments')); ?>
		</td>
	</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0"
	class="formFull">
	<tr>
		<th width="19%" valign="middle" class="tdLabel" id="boxspace"
			colspan="2"><strong><?php echo __("Send Result To") ; ?> </strong></th>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Send Result To");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.labHl7Result.send_result_to_facility', array('value'=>$labEdit['LaboratoryResult']['send_result_to_facility'],'type'=>'text','label'=>false,'style'=>'width:250px','id' => 'send_result_to_facility')); ?>
		</td>
	</tr>
</table>

<?php echo $this->Form->input($cnt.'.labHl7Result.labcount',array('value'=>count($labEdit['LaboratoryHl7Result']),'type'=>'hidden'));  ?>
</div>
<?php
	
	$cnt ++;
} // --end outer for each
?>
<input class="blueBtn" type=submit value="Submit" name="Submit">

<?php echo $this->Form->end();?>
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
	<?php echo $this->Form->input('uom_0', array('style'=>'width:150px; float:left;','options'=>$ucums_option,'empty'=>__('Please select'), 'id'=>'uom_0'));?>
</div>
<div id="abnflagobs" style="display: none">
	<?php echo $this->Form->input('observation_0', array('style'=>'width:150px; float:left;','options'=>$loincCode,'empty'=>__('Please select'), 'id'=>'observation_0'));?>
</div>
<div id="abnobsmethod" style="display: none">
	<?php echo $this->Form->input('observation_method_0', array('style'=>'width:150px; float:left;','options'=>$obsMethod_option,'empty'=>__('Please select'), 'id'=>'observation_method_0'));?>
</div>
<!-- <div id="result" style="display:none"><?php echo $this->Form->input('result_0', array('style'=>'width:150px; float:left;','options'=>$hl7_coded_observation_option,'empty'=>__('Please select'), 'id'=>'result_0'));?></div>
-->
<div id="myobsflag" style="display: none">
	<?php echo $this->Form->input('result_0', array('style'=>'width:150px; float:left;','options'=>$specimenTypeSnomedSct,'empty'=>__('Please select'), 'id'=>'result_0'));?>
</div>
<script>
jQuery(document).ready(function(){
	var curdate = new Date();
	$("#current_time").val(curdate);
});

var counter=0;
var labText = '<tr><th colspan="10">Lab Results</th></tr><tr><td width="19%" valign="middle" class="tdLabel" id="boxspace">Observation</td><td width="19%" valign="middle" class="tdLabel" id="boxspace">Type</td><td width="19%" valign="middle" class="tdLabel" id="boxspace">Result</td><td width="19%" valign="middle" class="tdLabel" id="boxspace">UOM</td><td width="19%" valign="middle" class="tdLabel" id="boxspace">Range</td><td width="19%" valign="middle" class="tdLabel" id="boxspace">Abnormal Flag</td><td width="19%" valign="middle" class="tdLabel" id="boxspace">Status</td></tr>';
var labInput = '<tr><td width="19%" valign="middle" class="tdLabel" id="boxspace">###ABNOBSFLG###</td><td width="19%" valign="middle" class="tdLabel" id="boxspace">###ABNUNITFLG###</td><td width="19%" valign="middle" class="tdLabel" id="boxspace"><div  style="display:block" id="observationLabResult_0"><?php echo $this->Form->input('sn_value_0', array('type'=>'text','label'=>false,'style'=>'width:10px','id' => 'sn_value_0')); ?><?php echo $this->Form->input('sn_result_0', array('type'=>'text','label'=>false,'style'=>'width:50px','id' => 'sn_result_0')); ?></div><div id="labCodedObservation_0" style="display:none">###ABNRESULT###</div></td><td width="19%" valign="middle" class="tdLabel" id="boxspace">###ABNUOMFLG###</td><td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input("range_0", array("type"=>"text","label"=>false,"style"=>"width:50px","id" => "range")); ?></td><td width="19%" valign="middle" class="tdLabel" id="boxspace">###ABNFLG###</td><td width="19%" valign="middle" class="tdLabel" id="boxspace">###ABNSTATUS###</td></tr>';
var labInput1 = '<tr><td width="19%" valign="middle" class="tdLabel" id="boxspace">###ABNOBSFLG###</td><td width="19%" valign="middle" class="tdLabel" id="boxspace">###ABNUNITFLG###</td><td width="19%" valign="middle" class="tdLabel" id="boxspace"><div  style="display:block" id="observationLabResult_0"><?php echo $this->Form->input('sn_value_0', array('type'=>'text','label'=>false,'style'=>'width:10px','id' => 'sn_value_0')); ?><?php echo $this->Form->input('sn_result_0', array('type'=>'text','label'=>false,'style'=>'width:50px','id' => 'sn_result_0')); ?></div><div id="labCodedObservation_0" style="display:none">###ABNRESULT###</div></td><td width="19%" valign="middle" class="tdLabel" id="boxspace">###ABNUOMFLG###</td><td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input("range_0", array("type"=>"text","label"=>false,"style"=>"width:50px","id" => "range")); ?></td><td width="19%" valign="middle" class="tdLabel" id="boxspace">###ABNFLG###</td><td width="19%" valign="middle" class="tdLabel" id="boxspace">###ABNSTATUS###</td></tr>';


$(function() {
    $("#labResultButton").click(function(event) {
    	ss= "labHl7Results_"+counter ;
		counter++;
		
    	var newCostDiv = $(document.createElement('table')).attr("id",'labHl7Results_'+ counter).attr("class",'formFull');
    	labInput = labInput1;
    	
    	labInput = labInput.replace("###ABNFLG###",$("#abnflag").html()); 
    	labInput = labInput.replace("###ABNRESULT###",$("#myobsflag	").html());
    	labInput = labInput.replace("###ABNSTATUS###",$("#abnflagstatus").html()); 
    	labInput = labInput.replace("###ABNUNITFLG###",$("#abnflagunit").html());
    	labInput = labInput.replace("###ABNUOMFLG###",$("#abnflaguom").html());
    	labInput = labInput.replace("###ABNOBSFLG###",$("#abnflagobs").html());
    	
    	labInput = labInput.replace("observation_0","observation_"+counter); 
		labInput = labInput.replace("unit_0","unit_"+counter);
		labInput = labInput.replace("unit_0","unit_"+counter);
		labInput = labInput.replace("sn_value_0","sn_value_"+counter);
		labInput = labInput.replace("result_0","result_"+counter); 
		labInput = labInput.replace("sn_result_0","sn_result_"+counter);
		labInput = labInput.replace("uom_0","uom_"+counter); 
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
		
		newCostDiv.append(labText);
		newCostDiv.append(labInput);
		
		$(newCostDiv).insertAfter('#'+ss);
		$("#labcount").val(counter);
		
	 });
});


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
			$( "#date_time_of_observation_0" ).datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				changeTime:true,
				showTime: true,  		
				yearRange: '1950',			 
				dateFormat:'dd/mm/yy HH:II:SS',
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

		$(".dt_tm_observation").live("click",function() {
			
			$(this).datepicker({
						changeMonth : true,
						changeYear : true,
						yearRange : '1950',
						dateFormat : 'dd/mm/yy HH:II:SS',
						showOn : 'button',
						buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
						buttonImageOnly : true,
						onSelect : function() {
							$(this).focus();
						}
					});
	});

		$(function() {
		    $(".myUnit").live("change",function(event) {
		    
		    id= $(this).attr("id");
		    if($("#"+id).val()=='CWE'){
		    splitted= id.split("_");
		    $("#observationLabResult_"+splitted[1]).hide();
		    $("#labCodedObservation_"+splitted[1]).show();
		   } 
		   else{
			   splitted= id.split("_");
			    $("#observationLabResult_"+splitted[1]).show();
			    $("#labCodedObservation_"+splitted[1]).hide();
		   }
		});
		});
</script>
