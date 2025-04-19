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
		<?php echo __('Result');?>







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
echo $this->Form->hidden ( 'labHl7Resulttime.current_time', array (
		'id' => 'current_time' 
) );
// echo "<pre>";print_r($patientData);
?>


<table width="100%" border="0" cellspacing="0" cellpadding="0"
	class="formFull">
	<tr>
		<th colspan="5"><?php echo __("Patient Information") ; ?></th>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Patient Name");?>
		</td>


		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $patientData[0]['Person']['first_name'].' ' .$patientData[0]['Person']['last_name'];?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Date/Time of Birth");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		
		$patientData [0] ['Person'] ['dob'] = $this->DateFormat->formatDate2Local ( $patientData [0] ['Person'] ['dob'], Configure::read ( 'date_format' ) );
		echo $patientData [0] ['Person'] ['dob'];
		?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Administrative Sex");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $patientData[0]['Person']['sex'];?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Race");?>
		</td>
		<?php
		// debug($race[$patientData[0]['Person']['race']]);//exit;
		if (! empty ( $patientData [0] ['Person'] ['race'] )) {
			$races = explode ( ',', $patientData [0] ['Person'] ['race'] );
			
			$raceString = '';
			foreach ( $races as $rc ) {
				$raceString .= $race [$rc];
			}
			
			/*
			 * if($raceString == ', '){
			 * echo $raceString = '';
			 * }
			 */
		}
		
		?>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		// echo $rc;
		echo $race [$patientData [0] ['Person'] ['race']];
		?>
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

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $doctorData['User']['first_name']." ".$doctorData['User']['last_name']; ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Identifier number");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $doctorData['User']['id']; ?>
		</td>
	</tr>


</table>
<?php

$cnt = 0; // debug($patientData);exit;
foreach ( $patientData [0] ['LaboratoryHl7Result'] as $labNameView ) {
	$idLabView [] = $labNameView ['laboratory_id'];
}
$model = ClassRegistry::init ( 'Laboratory' );
$LabName = $model->find ( 'all', array (
		'fields' => array (
				'id',
				'name' 
		),
		'conditions' => array (
				'id' => $idLabView 
		) 
) );
$i = 0;

foreach ( $patientData as $patientData ) {
	echo $this->Form->hidden ( $cnt . '.LaboratoryResult.id', array (
			'type' => 'text',
			'value' => $patientData ['LaboratoryResult'] ['id'] 
	) );
	?>
<?php

	$counter = 0;
	foreach ( $patientData ['LaboratoryHl7Result'] as $key => $resultData ) {
		
		if ($patientData ['LaboratoryHl7Result'] [$key] ['laboratory_id'] != '') {
			echo $this->Form->hidden ( $cnt . '.' . $counter . '.LaboratoryHl7Result.id', array (
					'type' => 'text',
					'value' => $resultData ['id'] 
			) );
			?>
<div id="labHl7Results">

	<table width="100%" border="0" cellspacing="0" cellpadding="0"
		class="formFull" id="labHl7Results_0">
		<tr>
			<th colspan="10"><?php echo __("Lab Results") ; ?></th>
		</tr>
		<tr>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Observation");?>
			</td>
			<td width="10%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Type");?>
			</td>
			<td width="10%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Result");?>
			</td>
			<td width="15%" valign="middle" class="tdLabel UOM" id="boxspace"><?php echo __("UOM");?>
			</td>
			<td width="10%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Range");?>
			</td>
			<td width="10%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Abnormal Flag");?>
			</td>
			<td width="30%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Status");?>
			</td>

		</tr>
		<tr>

			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
			// old variable to load data $loincCode);
			echo $this->Form->input ( $cnt . '.' . $counter . '.LaboratoryHl7Result.observationsDisp', array (
					'style' => 'width:240px; float:left;',
					'value' => $LabName [$i] ['Laboratory'] ['name'],
					'class' => 'obser',
					'id' => $cnt . $counter . 'observation_Disp' 
			) );
			echo $this->Form->hidden ( $cnt . '.' . $counter . '.LaboratoryHl7Result.observations', array (
					'value' => $patientData ['Laboratory'] ['lonic_code'],
					'id' => $cnt . $counter . 'observation_0' 
			) );
			$i ++;
			?>
			</td>
			<td width="10%" valign="middle" class="tdLabel" id="boxspace"><?php
			echo $this->Form->input ( $cnt . '.' . $counter . '.LaboratoryHl7Result.unit', array (
					'style' => 'width:150px; float:left;',
					'selected' => $resultData ['unit'],
					'options' => $units_option,
					'empty' => __ ( 'Please select' ),
					'id' => 'unit_0',
					'class' => 'myUnit' 
			) );
			?>
			</td>
			<td width="10%" valign="middle" class="tdLabel" id="boxspace"><?php
			
			if ($resultData ['unit'] == 'CWE') {
				$obs = 'none';
				$res = 'block';
				$snResVal = '';
				$resultVal = $resultData ['result'];
			} else {
				$res = 'none';
				$obs = 'block';
				$snResVal = $resultData ['result'];
				$resultVal = '';
			}
			?>
				<div style="display: <?php echo $obs?>" id="observationLabResult_0">
					<?php echo $this->Form->input($cnt.'.'.$counter.'.LaboratoryHl7Result.sn_value', array('value' => $resultData['sn_value'],'type'=>'text','label'=>false,'style'=>'width:10px','id' => 'sn_value_0')); ?>
					<?php echo $this->Form->input($cnt.'.'.$counter.'.LaboratoryHl7Result.sn_result', array('value' => $snResVal,'type'=>'text','label'=>false,'style'=>'width:50px','id' => 'sn_result_0'.$key,'class'=>'getBlurId')); ?>
				</div>
				<div id="labCodedObservation_0" style="display: <?php echo $res ?>">
					<?php
			echo $this->Form->input ( $cnt . '.' . $counter . '.LaboratoryHl7Result.sn_value', array (
					'style' => 'width:150px; float:left;',
					'value' => $resultData ['sn_value'],
					'class' => 'getBlurId',
					'id' => 'result_Disp_0' . $key 
			) );
			echo $this->Form->hidden ( $cnt . '.' . $counter . '.LaboratoryHl7Result.result', array (
					'value' => $resultVal,
					'id' => 'result_0' 
			) );
			?>
				</div></td>

			<td width="15%" valign="middle" class="tdLabel" id="boxspace"><?php
			echo $this->Form->input ( $cnt . '.' . $counter . '.LaboratoryHl7Result.uomDisp', array (
					'style' => 'width:150px; float:left;',
					'value' => $ucums_option [$resultData ['uom']],
					'class' => 'uomCls',
					'id' => $cnt . $counter . 'uom_Disp' 
			) );
			echo $this->Form->hidden ( $cnt . '.' . $counter . '.LaboratoryHl7Result.uom', array (
					'value' => $resultData ['uom'],
					'id' => $cnt . $counter . 'uom_0' 
			) );
			?>
			</td>
			<td width="10%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.'.$counter.'.LaboratoryHl7Result.range', array('value' => $resultData['range'],'type'=>'text','label'=>false,'style'=>'width:50px','id' => 'range_0'.$key)); ?>
			</td>
			<td width="10%" valign="middle" class="tdLabel" id="boxspace"><?php
			if ($abnormalFlag [$resultData ['abnormal_flag']] == 'Below absolute low-off instrument scale' || $abnormalFlag [$resultData ['abnormal_flag']] == 'Below lower panic limits' || $abnormalFlag [$resultData ['abnormal_flag']] == 'Below low normal') {
				$textColor = '#2F72FF';
			} else if ($abnormalFlag [$resultData ['abnormal_flag']] == 'Above upper panic limits' || $abnormalFlag [$resultData ['abnormal_flag']] == 'Above high normal') {
				$textColor = '#FF803E';
			} else if ($abnormalFlag [$resultData ['abnormal_flag']] == 'Normal (applies to non-numeric results)') {
				$textColor = '#FFF';
			} else {
				$textColor = '#F90223';
			}
			echo $this->Form->input ( $cnt . '.' . $counter . '.LaboratoryHl7Result.abnormal_flagDisp', array (
					'style' => 'width:150px; float:left;',
					'value' => $abnormalFlag [$resultData ['abnormal_flag']],
					'class' => 'abnormalFlag',
					'id' => 'abnormal_flag_Disp_0' . $key,
					'style' => 'color:' . $textColor 
			) );
			echo $this->Form->hidden ( $cnt . '.' . $counter . '.LaboratoryHl7Result.abnormal_flag', array (
					'value' => $resultData ['abnormal_flag'],
					'id' => 'abnormal_flag_0' . $counter 
			) );
			?>
			</td>
			<td width="30%" valign="middle" class="tdLabel" id="boxspace"><?php
			echo $this->Form->input ( $cnt . '.' . $counter . '.LaboratoryHl7Result.status', array (
					'style' => 'width:150px; float:left;',
					'value' => $resultData ['status'],
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
			
			$counter ++;
		}
	} // end of inner foreach	?>

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

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.LaboratoryResult.ogi_placer_order_number', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'ogi_placer_order_number','value'=>$patientData['LaboratoryTestOrder']['order_id'])); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Filler Order Number");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.LaboratoryResult.ogi_filler_order_number', array('value' => $patientData['LaboratoryResult']['ogi_filler_order_number'],'type'=>'text','label'=>false,'style'=>'width:250px','id' => 'ogi_filler_order_number')); ?>
		</td>
	</tr>
	<!-- 
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Placer Group Number");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.LaboratoryResult.ogi_placer_group_number', array('value' => $patientData['LaboratoryResult']['ogi_placer_group_number'],'type'=>'text','label'=>false,'style'=>'width:250px','id' => 'ogi_placer_group_number')); ?>
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
	echo $this->Form->hidden ( $cnt . '.LaboratoryResult.od_universal_service_identifier', array (
			'id' => 'od_universal_service_identifier',
			'value' => $patientData ['Laboratory'] ['lonic_code'] 
	) );
	?></td>
	</tr>

	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Observation  Date/Time");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
	
	$patientData ['LaboratoryResult'] ['od_observation_start_date_time'] = $this->DateFormat->formatDate2Local ( $patientData ['LaboratoryResult'] ['od_observation_start_date_time'], Configure::read ( 'date_format' ), true );
	echo $this->Form->input ( $cnt . '.LaboratoryResult.od_observation_start_date_time', array (
			'type' => 'text',
			'label' => false,
			'class' => 'textBoxExpnd',
			'value' => $patientData ['LaboratoryResult'] ['od_observation_start_date_time'],
			'id' => 'od_observation_start_date_time' 
	) );
	?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Observation  End Date/Time");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
	
	$patientData ['LaboratoryResult'] ['od_observation_end_date_time'] = $this->DateFormat->formatDate2Local ( $patientData ['LaboratoryResult'] ['od_observation_end_date_time'], Configure::read ( 'date_format' ), true );
	echo $this->Form->input ( $cnt . '.LaboratoryResult.od_observation_end_date_time', array (
			'type' => 'text',
			'label' => false,
			'value' => $patientData ['LaboratoryResult'] ['od_observation_end_date_time'],
			'id' => 'od_observation_end_date_time',
			'class' => 'textBoxExpnd' 
	) );
	?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Action Code");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
	echo $this->Form->input ( $cnt . '.LaboratoryResult.od_specimen_action_code', array (
			'style' => 'width:150px; float:left;',
			'value' => $patientData ['LaboratoryResult'] ['od_specimen_action_code'],
			'empty' => __ ( 'Please select' ),
			'options' => $speciemtActionCode0065,
			'id' => 'od_specimen_action_code' 
	) );
	?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Relevant Clinical Information");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
	echo $this->Form->input ( $cnt . '.LaboratoryResult.od_relevant_clinical_info', array (
			'style' => 'width:150px; float:left;',
			'class' => 'ClinicalInfo',
			'id' => $cnt . 'od_relevant_clinical_info',
			'value' => $patientData ['SnomedSctHl7'] ['display_name'] 
	) );
	echo $this->Form->hidden ( $cnt . '.LaboratoryResult.od_relevant_clinical_information', array (
			'id' => $cnt . 'od_relevant_clinical_information',
			'value' => $patientData ['LaboratoryResult'] ['od_relevant_clinical_information'] 
	) );
	?>
		</td>
	</tr>

	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Relevant Clinical Information Original Text");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.LaboratoryResult.od_relevent_clinical_information_original_text', array('value' => $patientData['LaboratoryResult']['od_relevent_clinical_information_original_text'],'type'=>'text','label'=>false,'style'=>'width:250px','id' => 'od_relevent_clinical_information_original_text')); ?>
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
	echo $this->Form->input ( $cnt . '.LaboratoryResult.ori_result_status', array (
			'style' => 'width:150px; float:left;',
			'value' => $patientData ['LaboratoryResult'] ['ori_result_status'],
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

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.LaboratoryResult.rct_prefix', array('value' => $patientData['LaboratoryResult']['rct_prefix'],'type'=>'text','label'=>false,'style'=>'width:50px','id' => 'rct_prefix','div'=>false)); ?>
			<?php echo $this->Form->input($cnt.'.LaboratoryResult.rct_suffix', array('value' => $patientData['LaboratoryResult']['rct_suffix'],'type'=>'text','label'=>false,'style'=>'width:50px','id' => 'rct_suffix','div'=>false)); ?>

		</td>
	</tr>

	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("First Name");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.LaboratoryResult.rct_name', array('value' => $patientData['LaboratoryResult']['rct_name'],'type'=>'text','label'=>false,'style'=>'width:250px','id' => 'rct_name')); ?>
		</td>
	</tr>

	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Middle Name");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.LaboratoryResult.rct_middle_name', array('value' => $patientData['LaboratoryResult']['rct_middle_name'],'type'=>'text','label'=>false,'style'=>'width:250px','id' => 'rct_middle_name')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Last Name");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.LaboratoryResult.rct_last_name', array('value' => $patientData['LaboratoryResult']['rct_last_name'],'type'=>'text','label'=>false,'style'=>'width:250px','id' => 'rct_last_name')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Indentifier number");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.LaboratoryResult.rct_identifier', array('value' => $patientData['LaboratoryResult']['rct_identifier'],'type'=>'text','label'=>false,'style'=>'width:250px','id' => 'rct_identifier')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><strong><?php echo __("Result Handling") ; ?>
		</strong></td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Standard");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.LaboratoryResult.rh_standard', array('value' => $patientData['LaboratoryResult']['rh_standard'],'options'=>array(''=>'Please Select','Carbon Copy'=>'Carbon Copy'),'label'=>false,'style'=>'width:250px','id' => 'rh_standard')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Local");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.LaboratoryResult.rh_local', array('value' => $patientData['LaboratoryResult']['rh_local'],'options'=>array(''=>'Please Select','Send Copy'=>'Send Copy'),'label'=>false,'style'=>'width:250px','id' => 'rh_local')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><strong><?php echo __("Observation Notes") ; ?>
		</strong></td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Notes and Comments");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.LaboratoryResult.on_notes_comments', array('value' => $patientData['LaboratoryResult']['on_notes_comments'],'type'=>'text','label'=>false,'style'=>'width:250px','id' => 'on_notes_comments')); ?>
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
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.LaboratoryResult.tqi_start_date_time', array('value' => $patientData['LaboratoryResult']['tqi_start_date_time'],'type'=>'text','label'=>false,'id' => 'tqi_start_date_time','class'=>'textBoxExpnd')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("End Date/Time");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.LaboratoryResult.tqi_end_date_time', array('value' => $patientData['LaboratoryResult']['tqi_end_date_time'],'type'=>'text','label'=>false,'id' => 'tqi_end_date_time','class'=>'textBoxExpnd')); ?>
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
	// for display only
	echo $this->Form->input ( $cnt . '.LaboratoryResult.specimen_type_disp', array (
			'style' => 'width:150px; float:left;',
			'class' => 'siType',
			'id' => $cnt . 'si_specimen_type_disp',
			'value' => $patientData ['siType'] ['display_name'] 
	) );
	// for interting value to db
	echo $this->Form->hidden ( $cnt . '.LaboratoryResult.si_specimen_type', array (
			'id' => $cnt . 'si_specimen_type_',
			'value' => $patientData ['LaboratoryResult'] ['si_specimen_type'] 
	) );
	?></td>
	</tr>

	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Original Text");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.LaboratoryResult.si_specimen_original_text', array('value' => $patientData['LaboratoryResult']['si_specimen_original_text'],'type'=>'text','label'=>false,'style'=>'width:250px','id' => 'si_specimen_original_text')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Start date/time");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.LaboratoryResult.si_start_date_time', array('value' => $patientData['LaboratoryResult']['si_start_date_time'],'type'=>'text','label'=>false,'id' => 'si_start_date_time','class'=>'textBoxExpnd')); ?>
		</td>
	</tr>
	<tr>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Reject Reason");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
	echo $this->Form->input ( $cnt . '.LaboratoryResult.si_specimen_reject_reason', array (
			'style' => 'width:150px; float:left;',
			'value' => $patientData ['LaboratoryResult'] ['si_specimen_reject_reason'],
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

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.LaboratoryResult.si_reject_reason_original_text', array('value' => $patientData['LaboratoryResult']['si_reject_reason_original_text'],'type'=>'text','label'=>false,'style'=>'width:250px','id' => 'si_reject_reason_original_text')); ?>
		</td>
	</tr>


	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Condition ");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
	echo $this->Form->input ( $cnt . '.LaboratoryResult.si_specimen_condition', array (
			'style' => 'width:150px; float:left;',
			'value' => $patientData ['LaboratoryResult'] ['si_specimen_condition'],
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

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.LaboratoryResult.si_condition_original_text', array('value' => $patientData['LaboratoryResult']['si_condition_original_text'],'type'=>'text','label'=>false,'style'=>'width:250px','id' => 'si_condition_original_text')); ?>
		</td>
	</tr>
</table>

<!-- <div><input class="blueBtn" type="button" value="Add More" id="labResultButton">
<input class="blueBtn" type="button" value="Remove" id="RemoveLabResultButton">
</div>-->

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
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.LaboratoryResult.re_notes_comments', array('value' => $patientData['LaboratoryResult']['re_notes_comments'],'type'=>'text','label'=>false,'style'=>'width:250px','id' => 're_notes_comments')); ?>
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
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input($cnt.'.LaboratoryResult.send_result_to_facility', array('value' => $patientData['LaboratoryResult']['send_result_to_facility'],'type'=>'text','label'=>false,'style'=>'width:250px','id' => 'send_result_to_facility')); ?>
		</td>
	</tr>
</table>
<div class="inner_title"></div>
<?php
	
	$cnt ++;
} // end of foreach?>
<input type=hidden value="0" name="labcount" id="labcount">
<input class="blueBtn" type=submit value="Submit" name="Submit">
<?php echo $this->Form->end();?>
<!--<div id="abnflag" style="display:none"><?php echo $this->Form->input('abnormal_flag_0', array('style'=>'width:150px; float:left;','options'=>$abnormalFlag,'empty'=>__('Please select'), 'id'=>'abnormal_flag_0'));?></div>
<div id="abnflagstatus" style="display:none"><?php echo $this->Form->input('status_0', array('style'=>'width:150px; float:left;','options'=>$labResultStatus,'empty'=>__('Please select'), 'id'=>'status_0'));?></div>
<div id="abnflagunit" style="display:none"><?php echo $this->Form->input('unit_0', array('style'=>'width:150px; float:left;','options'=>$units_option,'empty'=>__('Please select'), 'id'=>'unit_0','class'=>'myUnit'));?></div>
<div id="abnflaguom" style="display:none"><?php echo $this->Form->input('uom_0', array('style'=>'width:150px; float:left;','options'=>$ucums_option,'empty'=>__('Please select'), 'id'=>'uom_0'));?></div>
<div id="abnflagobs" style="display:none"><?php echo $this->Form->input('observation_0', array('style'=>'width:150px; float:left;','options'=>$loincCode,'empty'=>__('Please select'), 'id'=>'observation_0'));?></div>
<div id="abnobsmethod" style="display:none"><?php echo $this->Form->input('observation_method_0', array('style'=>'width:150px; float:left;','options'=>$obsMethod_option,'empty'=>__('Please select'), 'id'=>'observation_method_0'));?></div>
 <div id="result" style="display:none"><?php echo $this->Form->input('result_0', array('style'=>'width:150px; float:left;','options'=>$hl7_coded_observation_option,'empty'=>__('Please select'), 'id'=>'result_0'));?></div>
-->
<div id="myobsflag" style="display: none">
	<?php echo $this->Form->input('result_0', array('style'=>'width:150px; float:left;','options'=>$specimenTypeSnomedSct,'empty'=>__('Please select'), 'id'=>'result_0'));?>
</div>
<script>
jQuery(document).ready(function(){
	var curdate = new Date();
	$("#current_time").val(curdate);
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

		 $(document).ready(function(){

			 $('.ClinicalInfo')
				.live('focus',function() {  
				$(this).autocomplete("<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "testcomplete","SnomedSctHl7",'code',"display_name",'null',"admin" => false,"plugin"=>false)); ?>",
					{
					width: 250,
					selectFirst: true,
					valueSelected:true,
					loadId : $(this).attr('id')+','+$(this).attr('id').replace("info","information")
					});

			});

			 $('.siType')
				.live('focus',function() { 
				$(this).autocomplete("<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "testcomplete","SnomedSctHl7",'code',"display_name",'null',"admin" => false,"plugin"=>false)); ?>",
					{
					width: 250,
					selectFirst: true,
					valueSelected:true,
					loadId : $(this).attr('id')+','+$(this).attr('id').replace("disp","")
					});

			});

			/* $('.obser')
				.live('focus',function() { 
				$(this).autocomplete("<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "testcomplete","Laboratory",'lonic_code',"name",'null',"admin" => false,"plugin"=>false)); ?>",
					{
					width: 250,
					selectFirst: true,
					valueSelected:true,
					loadId : $(this).attr('id')+','+$(this).attr('id').replace("Disp","0")
					});

			});*/

			 $('.uomCls')
				.live('focus',function() { 
				$(this).autocomplete("<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "testcomplete","Ucums","code","display_name",'null',"admin" => false,"plugin"=>false)); ?>",
					{
					width: 250,
					selectFirst: true,
					valueSelected:true,
					loadId : $(this).attr('id')+','+$(this).attr('id').replace("Disp","0")
					});

			});

			 $('.abnormalFlag')
				.live('focus',function() { 
				$(this).autocomplete("<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "testcomplete","ObservationInterpretation0078","code","display_name",'null',"admin" => false,"plugin"=>false)); ?>",
					{
					width: 250,
					selectFirst: true,
					valueSelected:true,
					loadId : $(this).attr('id')+','+$(this).attr('id').replace("Disp","0")
					});

			});

			 $('.resultValCls')
				.live('focus',function() { 
				$(this).autocomplete("<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "testcomplete","ObservationInterpretation0078","code","display_name",'null',"admin" => false,"plugin"=>false)); ?>",
					{
					width: 250,
					selectFirst: true,
					valueSelected:true,
					loadId : $(this).attr('id')+','+$(this).attr('id').replace("Disp","0")
					});

			});
		});
		
		 $('.getBlurId').change(function(){
				var getId=$(this).attr('id');
				$( "#"+getId+"" ).blur(function() {
					  var idValue = getId.split("_"); 	
					  var getResult=$("#"+getId+"").val();
					  var rangeValue=$('#range_'+idValue[2]+'').val();
					  rangeValue=rangeValue.split("-"); 
					  var lowerLimtRange=rangeValue['0'];
					  var upperLimtRange=rangeValue['1'];
					  if(parseInt(getResult) < parseInt(lowerLimtRange)){
						  var tenPerBelow= Math.round(((getResult/lowerLimtRange)*100));
						 if((tenPerBelow<=10) &&(tenPerBelow>=1)){
							 $("#abnormal_flag_Disp_"+idValue[2]).css("color", "#2F72FF");
							 $("#abnormal_flag_Disp_"+idValue[2]).val("Below low normal");
							 $("#abnormal_flag_"+idValue[2]).val("L");
							
						 } 
						 if((tenPerBelow<=20) && (tenPerBelow >10)){
							 $("#abnormal_flag_Disp_"+idValue[2]).css("color", "#2F72FF");
							 $("#abnormal_flag_Disp_"+idValue[2]).val('Below lower panic limits');
							 $("#abnormal_flag_"+idValue[2]).val("LL");
						 }
						 if(tenPerBelow >=30){
							 $("#abnormal_flag_Disp_"+idValue[2]).css("color", "#2F72FF");
							 $("#abnormal_flag_Disp_"+idValue[2]).val('Below absolute low-off instrument scale');
							 $("#abnormal_flag_"+idValue[2]).val("<");
						 }
						
						 tenPerBelow='';
						
					  }
					  if(parseInt(getResult) > parseInt(upperLimtRange)){			  
						  var tenPerAbove= Math.round(100-((upperLimtRange/getResult)*100));
							 if((tenPerAbove<=10) &&(tenPerAbove>=1)){
								 $("#abnormal_flag_Disp_"+idValue[2]).css("color", "#FF803E");
								 $("#abnormal_flag_Disp_"+idValue[2]).val('Above high normal');
								 $("#abnormal_flag_"+idValue[2]).val("H");
							 } 
							 if((tenPerAbove<=20) && (tenPerAbove >10)){
								 $("#abnormal_flag_Disp_"+idValue[2]).css("color", "#F90223");
								 $("#abnormal_flag_Disp_"+idValue[2]).val('Above upper panic limits');
								 $("#abnormal_flag_"+idValue[2]).val("HH");
							 }
							 if(tenPerAbove >=30){
								 $("#abnormal_flag_Disp_"+idValue[2]).css("color", "#F90223");
								 $("#abnormal_flag_Disp_"+idValue[2]).val('Above absolute high-off instrument scale');
								 $("#abnormal_flag_"+idValue[2]).val(">");
							 }
							 tenPerBelow='';
					  }
					  if((parseInt(getResult)>= parseInt(lowerLimtRange)) && (parseInt(getResult)<= parseInt(lowerLimtRange)) ){
						  alert('mod');
							 $("#abnormal_flag_Disp_"+idValue[2]).css("color", "#FFF");
						  	 $("#abnormal_flag_Disp_"+idValue[2]).val('Normal');
							 $("#abnormal_flag_"+idValue[2]).val("N");
							 tenPerBelow='';
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
