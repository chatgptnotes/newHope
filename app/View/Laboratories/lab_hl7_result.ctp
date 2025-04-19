<?php
echo $this->Html->script ( 'jquery.autocomplete' );
echo $this->Html->css ( 'jquery.autocomplete.css' );
?>
<style>
#boxspace {
	border-right: 1px solid #384144;
	padding-right: 5px;
}
</style>
<center>
	<h1>Result</h1>
</center>

<?php //debug($patientData);?>
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
<!-- 
			<table width="100%" border="0" cellspacing="0" cellpadding="0"
	class="formFull">
	<tr>
		<th colspan="5"><?php echo __("Software Information") ; ?></th>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Software Vendor Organization Name");?>
		</td>
		
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __('DrMHope Lab, Inc.');;?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Software Vendor Organization Identifier");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __('123456');;?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Software Vendor Assigning Authority");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __('DrMHope 2.16.840.1.113883.3.9872');?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Software Certified Version or Release Number");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __('1.0');?>
		</td>
	</tr>
	 <tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Software Product Name");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __('DrMHope Lab System');?>
		</td> 
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Software Binary ID");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __('6742874-12');?>
		</td> 
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Software Install Date");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __('09/10/2013');?>
		</td> 
	</tr>
</table>
			
-->

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
		
		$races = explode ( ',', $patientData ['Person'] ['race'] ); // print_r($races);exit;
		$raceString = '';
		foreach ( $races as $rc ) {
			$raceString .= $race [$rc];
		}
		?>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php if(!empty($rc)){echo $rc;}else{echo 'Denied to specify';}?>
		</td>
	</tr>
	<!-- 
	 <tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Alt Race");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __($race[4]);?>
		</td> 
	</tr>
	 -->

	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Patient Class");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		echo $this->Form->input ( 'patient_class', array (
				'style' => 'width:140px; float:left;',
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
		echo $this->Form->input ( 'admission_type', array (
				'style' => 'width:140px; float:left;',
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
		$form_received_on = $this->DateFormat->formatDate2Local ( $patientData ['Patient'] ['form_received_on'], Configure::read ( 'date_format' ) );
		echo $this->Form->input ( 'admit_date_time', array (
				'type' => 'text',
				'label' => false,
				'style' => '',
				'id' => 'admit_date_time',
				'class' => 'textBoxExpnd',
				'value' => $form_received_on,
				'readonly' => 'readonly' 
		) );
		?>
		
		</td>
	</tr>

	<!--  <tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Discharge Date/Time");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		echo $this->Form->input ( 'discharge_date_time', array (
				'type' => 'text',
				'label' => false,
				'style' => '',
				'id' => 'discharge_date_time',
				'class' => 'textBoxExpnd' 
		) );
		?>
		
		</td>  -->
	</tr>

</table>
<!-- Observation Details Starts -->
<table width="100%" border="0" cellspacing="0" cellpadding="0"
	class="formFull">
	<tr>
		<th colspan="5"><?php echo __("Observation Details") ; ?></th>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><strong><?php echo __("Observation General Information ") ; ?></strong></td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Placer Order Number");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('ogi_placer_order_number', array('type'=>'text','label'=>false,'style'=>'','readonly'=>'readonly','id' => 'ogi_placer_order_number','value'=>$patientData['LaboratoryTestOrder']['order_id'])); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Filler Order Number");?>
		</td>
		<?php
		
		if (! empty ( $fillerOderNumber )) {
			$readonly = 'readonly';
		}
		?>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('ogi_filler_order_number', array('value' => $fillerOderNumber,'readonly'=>$readonly,'type'=>'text','label'=>false,'style'=>'','id' => 'ogi_filler_order_number')); ?>
		</td>
	</tr>
	<!-- 
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Placer Group Number");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('ogi_placer_group_number', array('type'=>'text','label'=>false,'style'=>'','id' => 'ogi_placer_group_number')); ?>
		</td>
	</tr> -->
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><strong><?php echo __("Observation details ") ; ?></strong></td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Universal Service Identifier");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		echo __ ( $LabName ['Laboratory'] ['name'] );
		echo $this->Form->hidden ( 'od_universal_service_identifier', array (
				'style' => 'width:140px; float:left;',
				'id' => 'od_universal_service_identifier',
				'value' => $LabName ['Laboratory'] ['lonic_code'] 
		) );
		?></td>
	</tr>
	<!-- 
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Alt Identifier");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('pusi_alt_identifier', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'pusi_alt_identifier')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Alt Text");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('pusi_alt_text', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'pusi_alt_text')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Original Text");?>
		</td>
	
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('pusi_original_text', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'pusi_original_text')); ?>
		</td>
	</tr>
		-->
	<!--<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Observation Date/Time");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('od_observation_date_time', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'od_observation_date_time','class'=>'textBoxExpnd')); ?>
		</td>
	</tr>-->
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Observation  Date/Time");?>
		</td>
		<?php $start_date= $this->DateFormat->formatDate2Local($patientData['LaboratoryTestOrder']['start_date'],Configure::read('date_format'));?>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		
		echo $start_date; /*
		                   * $this->Form->input('od_observation_start_date_time', array('type'=>'text','label'=>false,
		                   * 'style'=>'','id' => 'od_observation_start_date_time','class'=>'textBoxExpnd','value'=>$start_date,'readonly'=>'readonly'));
		                   */
		?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Observation  End Date/Time");?>
		</td>
		<?php $end_date= $this->DateFormat->formatDate2Local(date('m/d/y'),Configure::read('date_format'));?>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		
		echo $end_date; /*
		                 * $this->Form->input('od_observation_end_date_time', array('type'=>'text','label'=>false,'style'=>'',
		                 * 'id' => 'od_observation_end_date_time','class'=>'textBoxExpnd','value'=>$end_date,'readonly'=>'readonly'));
		                 */
		?>
		</td>
	</tr>

	<!-- 
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Action Code");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		echo $this->Form->input ( 'od_specimen_action_code', array (
				'style' => 'width:140px; float:left;',
				'options' => $speciemtActionCode0065,
				'empty' => __ ( 'Please select' ),
				'id' => 'od_specimen_action_code' 
		) );
		// echo $this->Form->input('od_specimen_action_code', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'od_specimen_action_code'));		?>
		</td>
	</tr>
	
	-->

	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Relevant Clinical Information");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('od_relevant_clinical_information', array('type'=>'text','label'=>false,'style'=>'','id' => 'od_relevant_clinical_information','value'=>$patientData['Note']['cc'])); ?>
		</td>
	</tr>

	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><strong><?php echo __("Observation Result Information ") ; ?></strong></td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Result Status");?>
		</td>


		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		echo $this->Form->input ( 'ori_result_status', array (
				'style' => 'width:140px; float:left;',
				'options' => $resultStatus0123,
				'empty' => __ ( 'Please select' ),
				'id' => 'ori_result_status' 
		) );
		// echo $this->Form->input('ori_result_status', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'ori_result_status'));		?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Result Report/Status change-Date/Time");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('ori_result_report_status_date_time', array('type'=>'text','label'=>false,'style'=>'','id' => 'ori_result_report_status_date_time','class'=>'textBoxExpnd')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><strong><?php echo __("Observation Notes") ; ?></strong></td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Notes and Comments");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('on_notes_comments', array('type'=>'text','label'=>false,'style'=>'','id' => 'on_notes_comments')); ?>
		</td>
	</tr>

</table>


<!-- Observation Details Ends -->
<!-- Reason for Study Start -->
<!-- 
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
	<tr>
		<th colspan="5"><?php echo __("Reason for study") ; ?></th>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Identifier");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('reason_for_study_identifier', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'reason_for_study_identifier')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Text");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('reason_for_study_text', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'reason_for_study_text')); ?>
		</td>
	</tr>
	
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Name of Coding System");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('reason_for_study_coding_system', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'reason_for_study_coding_system')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Alternate Identifier");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('reason_for_study_alt_identifier', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'reason_for_study_alt_identifier')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Alternate Text");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('reason_for_study_alt_text', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'reason_for_study_alt_text')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Name of Alternate Coding System");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('reason_for_study_alt_coding_system', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'reason_for_study_alt_coding_system')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Coding system version id");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('reason_for_study_coding_system_id', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'reason_for_study_coding_system_id')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Alternate Coding system version id");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('reason_for_study_alt_coding_system_id', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'reason_for_study_alt_coding_system_id')); ?>
		</td>
	</tr>
</table>
-->
<!--  Ends -->
<!-- 
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
	<tr>
		<th colspan="5"><?php echo __("Principal Result Interpreter") ; ?></th>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("ID Number");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('principal_id', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'principal_id')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Last Name");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('principal_last_name', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'principal_last_name')); ?>
		</td>
	</tr>
	
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("First Name");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('principal_first_name', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'principal_first_name')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Middle Name");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('principal_middle_name', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'principal_middle_name')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Suffix");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('principal_suffix', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'principal_suffix')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Prefix");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		
		echo $this->Form->input ( 'principal_prefix', array (
				'style' => 'width:140px; float:left;',
				'empty' => __ ( 'Please select' ),
				'options' => array_combine ( $initial_option, $initial_option ),
				'id' => 'principal_prefix' 
		) );
		?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Degree");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('principal_edu', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'principal_edu')); ?>
		</td>
	</tr>
</table>

-->

<!-- 
<table width="100%" border="0" cellspacing="0" cellpadding="0"
	class="formFull">
	<tr>
		<th colspan="5"><?php echo __("Timing/Quantity Information") ; ?></th>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Start Date/Time");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('tqi_start_date_time', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'tqi_start_date_time')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("End Date/Time");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('tqi_end_date_time', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'tqi_end_date_time')); ?>
		</td>
	</tr>
</table>
-->

<!-- OBX Starts -->

<!-- 
<table width="100%" border="0" cellspacing="0" cellpadding="0"
	class="formFull">
	<tr>
		<th colspan="5"><?php echo __("Result Performing Laboratory") ; ?></th>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Laboratory Name");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('rpl_laboratory_name', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'rpl_laboratory_name')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Laboratory Name Type");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		
		echo $this->Form->input ( 'rpl_laboratory_legal_name', array (
				'style' => 'width:140px; float:left;',
				'empty' => __ ( 'Please select' ),
				'options' => $nameType_option,
				'id' => 'rpl_laboratory_legal_name' 
		) );
		?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Laboratory Identifier Type");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		
		echo $this->Form->input ( 'rpl_laboratory_identifier_type', array (
				'style' => 'width:140px; float:left;',
				'empty' => __ ( 'Please select' ),
				'options' => $identifier_type_option,
				'id' => 'rpl_laboratory_identifier_type' 
		) );
		?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Organization Identifier");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('rpl_organization_identifier', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'rpl_organization_identifier')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Address Line 1");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('rpl_address', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'rpl_address')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Address Line 2");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('rpl_address_line_2', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'rpl_address_line_2')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Country");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('rpl_country', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'rpl_country','value'=>'USA','readonly'=>'readonly')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("State");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		
		echo $this->Form->input ( 'rpl_state', array (
				'style' => 'width:140px; float:left;',
				'options' => $state_options,
				'id' => 'rpl_state' 
		) );
		?>
		</td>
		
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("City");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('rpl_city', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'rpl_city')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Zip");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('rpl_zip', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'rpl_zip')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Address Type");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		
		echo $this->Form->input ( 'rpl_laboratory_address_type', array (
				'style' => 'width:140px; float:left;',
				'empty' => __ ( 'Please select' ),
				'options' => $address_type_option,
				'id' => 'rpl_laboratory_address_type' 
		) );
		?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Country/Parish Code");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('rpl_parish_code', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'rpl_parish_code')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Director Initial");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		
		echo $this->Form->input ( 'rpl_initial', array (
				'style' => 'width:140px; float:left;',
				'empty' => __ ( 'Please select' ),
				'options' => array_combine ( $initial_option, $initial_option ),
				'id' => 'rpl_initial' 
		) );
		?>
		</td>
		
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Director Legal Name");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		
		echo $this->Form->input ( 'rpl_legal_name', array (
				'style' => 'width:140px; float:left;',
				'empty' => __ ( 'Please select' ),
				'options' => $nameType_option,
				'id' => 'rpl_legal_name' 
		) );
		?>
		</td>
		
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Director First Name");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('rpl_director_name', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'rpl_director_name')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Director Middle Name");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('rpl_director_middle_name', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'rpl_director_middle_name')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Director Last Name");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('rpl_director_last_name', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'rpl_director_last_name')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Director Suffix");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('rpl_director_suffix', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'rpl_director_suffix')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Director Education");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('rpl_director_edu', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'rpl_director_edu')); ?>
		</td>
	</tr>
	
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Director identifier");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('rpl_director_identifier', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'rpl_director_identifier')); ?>
		</td>
	</tr>
</table>

-->

<!-- OBX ENDS -->

<table width="100%" border="0" cellspacing="0" cellpadding="0"
	class="formFull">
	<tr>
		<th colspan="5"><?php echo __("Specimen Information") ; ?></th>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Entity Identifier");?>
		</td>



		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('si_entity_identifier', array('type'=>'text','label'=>false,'style'=>'','id' => 'si_entity_identifier')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Type");?>
		</td>



		<td width="19%" valign="middle" class="tdLabel" id="boxspace">
		<?php
		// field to display only
		echo $this->Form->input ( 'si_specimen_typeDisp', array (
				'style' => '; float:left;',
				'id' => 'si_specimen_typeDisp' 
		) );
		// actual field to enter in db
		echo $this->Form->hidden ( 'si_specimen_type', array (
				'id' => 'si_specimen_type' 
		) );
		?>
		
		</td>
	</tr>

	<!-- 
	  	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Alt Specimen Type ");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('si_alt_specimen_type', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'si_alt_specimen_type')); ?>
		</td>
	</tr> 
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Original Text");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('si_specimen_original_text', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'si_specimen_original_text')); ?>
		</td>
	</tr>
	-->
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Type Modifier");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		echo $this->Form->input ( 'si_specimen_type_modifier', array (
				'style' => 'width:140px; float:left;',
				'options' => $sp_type_modifier_options,
				'empty' => __ ( 'Please select' ),
				'id' => 'si_specimen_type_modifier' 
		) );
		// echo $this->Form->input('si_specimen_type', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'si_specimen_type'));		?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Activities");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		echo $this->Form->input ( 'si_specimen_type_activitiesDisp', array (
				'style' => 'float:left;',
				'id' => 'si_specimen_type_activitiesDisp' 
		) );
		echo $this->Form->hidden ( 'si_specimen_type_activities', array (
				'id' => 'si_specimen_type_activities' 
		) );
		?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Collection Method");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		echo $this->Form->input ( 'si_specimen_col_methodDisp', array (
				'style' => 'float:left;',
				'id' => 'si_specimen_col_methodDisp' 
		) );
		echo $this->Form->hidden ( 'si_specimen_col_method', array (
				'id' => 'si_specimen_col_method' 
		) );
		?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Source Site");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		echo $this->Form->input ( 'si_specimen_source', array (
				'style' => 'width:140px; float:left;',
				'options' => $body_site_options,
				'empty' => __ ( 'Please select' ),
				'id' => 'si_specimen_source' 
		) );
		// echo $this->Form->input('si_specimen_type', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'si_specimen_type'));		?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Source Site Modifier");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		echo $this->Form->input ( 'si_specimen_source_modifier', array (
				'style' => 'width:140px; float:left;',
				'options' => $sp_type_modifier_options,
				'empty' => __ ( 'Please select' ),
				'id' => 'si_specimen_source_modifier' 
		) );
		// echo $this->Form->input('si_specimen_type', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'si_specimen_type'));		?>
		</td>
	</tr>

	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Role");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		echo $this->Form->input ( 'si_specimen_role', array (
				'style' => 'width:140px; float:left;',
				'options' => $specimen_role_options,
				'empty' => __ ( 'Please select' ),
				'id' => 'si_specimen_role' 
		) );
		// echo $this->Form->input('si_specimen_type', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'si_specimen_type'));		?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Collection Amount");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('si_specimen_col_quantity', array('type'=>'text','label'=>false,'style'=>'','id' => 'si_specimen_col_quantity')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Collection Units");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		echo $this->Form->input ( 'si_specimen_col_amountDisp', array (
				'style' => 'float:left;',
				'id' => 'si_specimen_col_amountDisp' 
		) );
		echo $this->Form->hidden ( 'si_specimen_col_amount', array (
				'id' => 'si_specimen_col_amount' 
		) );
		?>
		</td>
	</tr>


	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen date/time");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('si_start_date_time', array('type'=>'text','label'=>false,'style'=>'','id' => 'si_start_date_time','class'=>'textBoxExpnd')); ?>
		</td>
	</tr>

	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen End date/time");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('si_end_date_time', array('type'=>'text','label'=>false,'style'=>'','id' => 'si_end_date_time','class'=>'textBoxExpnd')); ?>
		</td>
	</tr>


	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Received Date/Time");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('si_received_date_time', array('type'=>'text','label'=>false,'style'=>'','id' => 'si_received_date_time','class'=>'textBoxExpnd')); ?>
		</td>
	</tr>

	<!-- 
	<tr>
	
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Reject Reason");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		echo $this->Form->input ( 'si_specimen_reject_reason', array (
				'style' => 'width:140px; float:left;',
				'options' => $specimenRejectReason,
				'empty' => __ ( 'Please select' ),
				'id' => 'si_specimen_reject_reason' 
		) );
		// echo $this->Form->input('si_specimen_reject_reason', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'si_specimen_reject_reason'));		?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Alt Specimen Reject Reason");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('si_alt_specimen_reject_reason', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'si_alt_specimen_reject_reason')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Reject Reason Original Text");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('si_reject_reason_original_text', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'si_reject_reason_original_text')); ?>
		</td>
	</tr>
	
	 
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Condition ");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		echo $this->Form->input ( 'si_specimen_condition', array (
				'style' => 'width:140px; float:left;',
				'options' => $specimenConditionReason,
				'empty' => __ ( 'Please select' ),
				'id' => 'si_specimen_condition' 
		) );
		// echo $this->Form->input('si_specimen_condition', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'si_specimen_condition'));		?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Alt Specimen Condition ");?>
		</td>
		
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('si_alt_specimen_condition', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'si_alt_specimen_condition')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Condition Original Text ");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('si_condition_original_text', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'si_condition_original_text')); ?>
		</td>
	</tr>
	-->
</table>

<!--  <div><input class="blueBtn" type="button" value="Add More" id="labResultButton">
<input class="blueBtn" type="button" value="Remove" id="RemoveLabResultButton">
</div>
-->
<div id="labHl7Results">

	<table width="100%" border="0" cellspacing="0" cellpadding="0"
		class="formFull" id="labHl7Results_0">
		<tr>
			<th colspan="9"><?php echo __("Lab Results") ; ?></th>
		</tr>
		<tr>
			<td valign="middle" class="tdLabel" id="boxspace"><?php echo __("Observation");?>
		</td>
			<td valign="middle" class="tdLabel" id="boxspace"><?php echo __("Type");?>
		</td>
			<td valign="middle" class="tdLabel" id="boxspace"><?php echo __("Result");?>
		</td>
			<td valign="middle" class="tdLabel UOM" id="boxspace"><?php echo __("UCUM Units");?>
		</td>
			<td width="11%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Range");?>
		</td>
			<td valign="middle" class="tdLabel" id="boxspace"><?php echo __("Abnormal Flag");?>
		</td>
			<td valign="middle" class="tdLabel" id="boxspace"><?php echo __("Status");?>
		</td>
			<td valign="middle" class="tdLabel" id="boxspace"><?php echo __("Date/Time of Analysis");?>
		</td>
			<td valign="middle" class="tdLabel" id="boxspace"><?php echo __("Notes");?>
		</td>
		</tr>



		<tr>

			<td valign="middle" class="tdLabel" id="boxspace"><?php
			echo $this->Form->input ( 'observationDisplay_0', array (
					'class' => 'observationCls',
					'style' => 'width:140px; float:left;',
					'readonly' => 'readonly',
					'id' => 'observationDisplay_0',
					'value' => $LabName ['Laboratory'] ['name'] 
			) );
			echo $this->Form->hidden ( 'observation_0', array (
					'id' => 'observation_0',
					'value' => $LabName ['Laboratory'] ['lonic_code'] 
			) );
			?>
		</td>
			<td valign="middle" class="tdLabel" id="boxspace"><?php
			echo $this->Form->input ( 'unit_0', array (
					'style' => 'width:140px; float:left;',
					'options' => $units_option,
					'empty' => __ ( 'Please select' ),
					'id' => 'unit_0',
					'class' => 'myUnit' 
			) );
			?>
		</td>
			<td valign="middle" class="tdLabel" id="boxspace">
				<div id="singleRes_0" style="display: block">Num1:<?php echo $this->Form->input('sn_result_0', array('type'=>'text','label'=>false,'style'=>'width:50px','id' => 'sn_result_0')); ?></div>
				<div style="display: none" id="observationLabResult_0">
					<div>Comparator:<?php echo $this->Form->input('sn_value_0', array('type'=>'text','label'=>false,'style'=>'width:10px','id' => 'sn_value_0')); ?></div>
					<div>Separator:<?php echo $this->Form->input('sn_separator_0', array('type'=>'text','label'=>false,'style'=>'width:50px','id' => 'sn_separator_0')); ?></div>
					<div>Num2:<?php echo $this->Form->input('sn_result2_0', array('type'=>'text','label'=>false,'style'=>'width:50px','id' => 'sn_result2_0')); ?></div>
				</div>
				<div id="labCodedObservation_0" style="display: none"><?php
				echo $this->Form->input ( 'result_0', array (
						'style' => 'width:140px; float:left;',
						'options' => $hl7_coded_observation_option,
						'empty' => __ ( 'Please select' ),
						'id' => 'result_0' 
				) );
				?>
		</div>


			</td>

			<td valign="middle" class="tdLabel UOM" id="boxspace"><?php
			echo $this->Form->input ( 'uomDisplay_0', array (
					'class' => 'uomCls',
					'style' => 'width:140px; float:left;',
					'id' => 'uomDisplay_0' 
			) );
			echo $this->Form->hidden ( 'uom_0', array (
					'id' => 'uom_0' 
			) );
			?>
		</td>
			<td width="11%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('range_0', array('type'=>'text','label'=>false,'style'=>'','id' => 'range_0')); ?>
		</td>
			<td valign="middle" class="tdLabel" id="boxspace"><?php
			echo $this->Form->input ( 'abnormal_flagDisplay_0', array (
					'class' => 'abnormalFlagCls',
					'style' => 'width:140px; float:left;',
					'id' => 'abnormal_flagDisplay_0' 
			) );
			echo $this->Form->hidden ( 'abnormal_flag_0', array (
					'id' => 'abnormal_flag_0' 
			) );
			?>
		</td>
			<td valign="middle" class="tdLabel" id="boxspace"><?php
			echo $this->Form->input ( 'status_0', array (
					'style' => 'width:140px; float:left;',
					'options' => $labResultStatus,
					'empty' => __ ( 'Please select' ),
					'id' => 'status_0' 
			) );
			// echo $this->Form->input('status_0', array('type'=>'text','label'=>false,'style'=>'width:50px','id' => 'status_0'));			?>
		</td>
			<td valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('date_time_of_observation_0', array('type'=>'text','label'=>false,'style'=>'width:100px','id' => 'date_time_of_observation_0','class'=>'textBoxExpnd')); ?>
		</td>
			<td valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('notes_0', array('type'=>'text','label'=>false,'style'=>'width:50px','id' => 'notes_0')); ?>
		</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td valign="middle" class="tdLabel" id="boxspace"><?php echo __("Observation Method/Text");?>
		</td>
		</tr>

		<tr>

			<td valign="middle" class="tdLabel" id="boxspace"><?php
			echo $this->Form->input ( 'observation_methodDisplay_0', array (
					'class' => 'obserMethod',
					'style' => 'width:140px; float:left;',
					'id' => 'observation_methodDisplay_0' 
			) );
			echo $this->Form->hidden ( 'observation_method_0', array (
					'id' => 'observation_method_0' 
			) );
			?>
		</td>
		</tr>
		<tr>
			<td colspan="9"><hr></td>
		</tr>

	</table>
</div>

<!-- 
	<table width="100%" border="0" cellspacing="0" cellpadding="0"
	class="formFull">
<tr>
		<th width="19%" valign="middle" class="tdLabel" id="boxspace" colspan="2"><strong><?php echo __("Observation Notes") ; ?></strong></th>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Notes and Comments");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('re_notes_comments', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 're_notes_comments')); ?>
		</td>
	</tr>
</table>
 -->

<input type=hidden value="0" name="labcount" id="labcount">
<input class="blueBtn" type=submit value="Submit" name="Submit"
	id="submit">
<!--  
<input class="blueBtn" type=submit value="Submit & Add More" name="Submit & Add More" > -->
<?php
echo $this->Form->hidden ( 'labHl7Result.curdate', array (
		'id' => 'curdate' 
) );
echo $this->Form->end ();
?>
<div id="abnflag" style="display: none"><?php

echo $this->Form->input ( 'abnormal_flagDisplay_0', array (
		'class' => 'abnormalFlagCls',
		'style' => 'width:140px; float:left;',
		'id' => 'abnormal_flagDisplay_0' 
) );
echo $this->Form->hidden ( 'abnormal_flag_0', array (
		'id' => 'abnormal_flag_0' 
) );
?></div>
<div id="abnflagstatus" style="display: none"><?php echo $this->Form->input('status_0', array('style'=>'width:140px; float:left;','options'=>$labResultStatus,'empty'=>__('Please select'), 'id'=>'status_0'));?></div>
<div id="abnflagunit" style="display: none"><?php echo $this->Form->input('unit_0', array('style'=>'width:140px; float:left;','options'=>$units_option,'empty'=>__('Please select'), 'id'=>'unit_0','class'=>'myUnit'));?></div>
<div id="abnflaguom" style="display: none"><?php

echo $this->Form->input ( 'uomDisplay_0', array (
		'class' => 'uomCls',
		'style' => 'width:140px; float:left;',
		'id' => 'uomDisplay_0' 
) );
echo $this->Form->hidden ( 'uom_0', array (
		'id' => 'uom_0' 
) );
?></div>
<div id="abnflagobs" style="display: none"><?php

echo $this->Form->input ( 'observationDisplay_0', array (
		'class' => 'observationCls',
		'style' => 'width:140px; float:left;',
		'id' => 'observationDisplay_0' 
) );
echo $this->Form->hidden ( 'observation_0', array (
		'id' => 'observation_0' 
) );
?></div>
<div id="abnobsmethod" style="display: none">
	<?php
	echo $this->Form->input ( 'observation_methodDisplay_0', array (
			'class' => 'obserMethod',
			'style' => 'width:140px; float:left;',
			'id' => 'observation_methodDisplay_0' 
	) );
	echo $this->Form->hidden ( 'observation_method_0', array (
			'id' => 'observation_method_0' 
	) );
	?>
</div>
<div id="result" style="display: none"><?php echo $this->Form->input('result_0', array('style'=>'width:140px; float:left;','options'=>$hl7_coded_observation_option,'empty'=>__('Please select'), 'id'=>'result_0'));?></div>

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
var labInput = '<tr><td width="19%" valign="middle" class="tdLabel" id="boxspace">###ABNOBSFLG###</td><td width="19%" valign="middle" class="tdLabel" id="boxspace">###ABNUNITFLG###</td><td width="19%" valign="middle" class="tdLabel" id="boxspace"><div id="singleRes_0" style="display:block">Num1:<?php echo $this->Form->input('sn_result_0', array('type'=>'text','label'=>false,'style'=>'width:50px','id' => 'sn_result_0')); ?></div><div  style="display:none" id="observationLabResult_0"><div>Comparator:<?php echo $this->Form->input('sn_value_0', array('type'=>'text','label'=>false,'style'=>'width:10px','id' => 'sn_value_0')); ?></div><div>Separator:<?php echo $this->Form->input('sn_separator_0', array('type'=>'text','label'=>false,'style'=>'width:50px','id' => 'sn_separator_0')); ?></div><div>Num2:<?php echo $this->Form->input('sn_result2_0', array('type'=>'text','label'=>false,'style'=>'width:50px','id' => 'sn_result2_0')); ?></div></div><div id="labCodedObservation_0" style="display:none">###ABNRESULT###</div></td><td width="19%" valign="middle" class="tdLabel" id="boxspace">###ABNUOMFLG###</td><td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input("range_0", array("type"=>"text","label"=>false,"style"=>"width:141px","id" => "range")); ?></td><td width="19%" valign="middle" class="tdLabel" id="boxspace">###ABNFLG###</td><td width="19%" valign="middle" class="tdLabel" id="boxspace">###ABNSTATUS###</td></td><td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('date_time_of_observation_0', array('class'=>'date_administered_cal','type'=>'text','label'=>false,'style'=>'width:50px','id' => 'date_time_of_observation_0')); ?></td><td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('notes_0', array('type'=>'text','label'=>false,'style'=>'width:50px','id' => 'notes_0')); ?></td></tr>';
var labInput1 = '<tr><td width="19%" valign="middle" class="tdLabel" id="boxspace">###ABNOBSFLG###</td><td width="19%" valign="middle" class="tdLabel" id="boxspace">###ABNUNITFLG###</td><td width="19%" valign="middle" class="tdLabel" id="boxspace"><div id="singleRes_0" style="display:block">Num1:<?php echo $this->Form->input('sn_result_0', array('type'=>'text','label'=>false,'style'=>'width:50px','id' => 'sn_result_0')); ?></div><div  style="display:none" id="observationLabResult_0"><div>Comparator:<?php echo $this->Form->input('sn_value_0', array('type'=>'text','label'=>false,'style'=>'width:10px','id' => 'sn_value_0')); ?></div><div>Separator:<?php echo $this->Form->input('sn_separator_0', array('type'=>'text','label'=>false,'style'=>'width:50px','id' => 'sn_separator_0')); ?></div><div>Num2:<?php echo $this->Form->input('sn_result2_0', array('type'=>'text','label'=>false,'style'=>'width:50px','id' => 'sn_result2_0')); ?></div></div><div id="labCodedObservation_0" style="display:none">###ABNRESULT###</div></td><td width="19%" valign="middle" class="tdLabel" id="boxspace">###ABNUOMFLG###</td><td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input("range_0", array("type"=>"text","label"=>false,"style"=>"width:50px","id" => "range")); ?></td><td width="19%" valign="middle" class="tdLabel" id="boxspace">###ABNFLG###</td><td width="19%" valign="middle" class="tdLabel" id="boxspace">###ABNSTATUS###</td></td><td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('date_time_of_observation_0', array('class'=>'date_administered_cal','type'=>'text','label'=>false,'style'=>'width:50px','id' => 'date_time_of_observation_0')); ?></td><td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('notes_0', array('type'=>'text','label'=>false,'style'=>'width:50px','id' => 'notes_0')); ?></td></tr>';
//var labInput1 = '<tr><td width="19%" valign="middle" class="tdLabel" id="boxspace">###ABNOBSFLG###</td><td width="19%" valign="middle" class="tdLabel" id="boxspace">###ABNUNITFLG###</td><td width="19%" valign="middle" class="tdLabel" id="boxspace"><div  style="display:block" id="observationLabResult_0"><?php echo $this->Form->input("sn_value_0", array("type"=>"text","label"=>false,"style"=>"width:10px","id" => "sn_value")); ?><?php echo $this->Form->input("sn_result_0", array("type"=>"text","label"=>false,"style"=>"width:50px","id" => "sn_result")); ?></div><div id="labCodedObservation_0" style="display:none">###ABNRESULT###</div></td><td width="19%" valign="middle" class="tdLabel" id="boxspace">###ABNUOMFLG###</td><td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input("range_0", array("type"=>"text","label"=>false,"style"=>"width:50px","id" => "range")); ?></td><td width="19%" valign="middle" class="tdLabel" id="boxspace">###ABNFLG###</td><td width="19%" valign="middle" class="tdLabel" id="boxspace">###ABNSTATUS###</td></td><td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('date_time_of_observation_0', array('class'=>'date_administered_cal','type'=>'text','label'=>false,'style'=>'width:50px','id' => 'date_time_of_observation_0')); ?></td><td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('notes_0', array('type'=>'text','label'=>false,'style'=>'width:50px','id' => 'notes_0')); ?></td></tr>';

var labTextSecond = '<tr><td width="19%" valign="middle" class="tdLabel" id="boxspace">Observation Method/Text</td></tr>';
var labInputSecond = '<tr><td width="19%" valign="middle" class="tdLabel" id="boxspace">###ABNOBSMETHODFLG###</td></tr><tr><td colspan="9"><hr></td></tr>';
var labInputSecond1 = '<tr><td width="19%" valign="middle" class="tdLabel" id="boxspace">###ABNOBSMETHODFLG###</td></tr><tr><td colspan="9"><hr></td></tr>';

//<tr><td width="19%" valign="middle" class="tdLabel" id="boxspace">Observation Method/Text</td><td width="19%" valign="middle" class="tdLabel" id="boxspace">Alternate Identifier</td><td width="19%" valign="middle" class="tdLabel" id="boxspace">Alternate Text</td><td width="19%" valign="middle" class="tdLabel" id="boxspace">Name of Alt. Coding</td><td width="19%" valign="middle" class="tdLabel" id="boxspace">Coding System Version id</td><td width="19%" valign="middle" class="tdLabel" id="boxspace">Alt. Coding System Version id </td><td width="19%" valign="middle" class="tdLabel" id="boxspace">Original Text</td></tr>

$(function() {
    $("#labResultButton").click(function(event) {//alert($("#abnobsmethod").html());
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
    	labInput = labInput.replace(/observationDisplay_0/g,"observationDisplay_"+counter);
    	labInput = labInput.replace(/uom_0/g,"uom_"+counter);
    	labInput = labInput.replace(/uomDisplay_0/g,"uomDisplay_"+counter);
    	labInput = labInput.replace(/abnormal_flag_0/g,"abnormal_flag_"+counter); 
    	labInput = labInput.replace(/abnormal_flagDisplay_0/g,"abnormal_flagDisplay_"+counter);
    	
		labInput = labInput.replace("unit_0","unit_"+counter);
		labInput = labInput.replace("unit_0","unit_"+counter);
		labInput = labInput.replace("sn_value_0","sn_value_"+counter);
		labInput = labInput.replace("result_0","result_"+counter); 
		labInput = labInput.replace("sn_result_0","sn_result_"+counter); 
		labInput = labInput.replace("range_0","range_"+counter); 
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

		labInputSecond = labInputSecond.replace(/observation_method_0/g,"observation_method_"+counter); 
		labInputSecond = labInputSecond.replace(/observation_methodDisplay_0/g,"observation_methodDisplay_"+counter);
		
		
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
    $(".myUnit").live("change",function(event) {
    
    id= $(this).attr("id");
    if($("#"+id).val()=='CWE'){
    splitted= id.split("_");
    $("#observationLabResult_"+splitted[1]).hide();
    $("#labCodedObservation_"+splitted[1]).show();
    $("#singleRes_"+splitted[1]).hide();
    $("#uom_"+splitted[1]).hide();
    $("#observation_method_"+splitted[1]).hide();
    
   } 
   else if($("#"+id).val()=='SN'){
	   splitted= id.split("_");
	    $("#observationLabResult_"+splitted[1]).show();
	    $("#labCodedObservation_"+splitted[1]).hide();
	    $("#singleRes_"+splitted[1]).show();
	    $("#uom_"+splitted[1]).show();
	    $("#observation_method_"+splitted[1]).show();
	    
   }else{
	   splitted= id.split("_");
	    $("#observationLabResult_"+splitted[1]).hide();
	    $("#labCodedObservation_"+splitted[1]).hide();
	    $("#singleRes_"+splitted[1]).show();
	    $("#uom_"+splitted[1]).show();
	    $("#observation_method_"+splitted[1]).show();
   }
});
});



$(".date_administered_cal").live("click",function() {
	
	$(this).datepicker({	
				changeMonth : true,
				changeYear : true,
				yearRange: firstYr+':'+lastYr,
			//	minDate : new Date(explode[0], explode[1] - 1,
			//			explode[2]),
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
		//$("#labHl7Results").remove('labHl7Results'+ '_' + (counter));
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
				minDate: new Date(),	 
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
			 
				$("#si_specimen_typeDisp").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","SnomedSctHl7",'code',"display_name",'null',"admin" => false,"plugin"=>false)); ?>", {
					width: 250,
					selectFirst: true,
					valueSelected:true,
					loadId : 'si_specimen_typeDisp,si_specimen_type'
				});

				$("#si_specimen_type_activitiesDisp").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","Specimen_activities","value_code","description",'null',"admin" => false,"plugin"=>false)); ?>", {
					width: 250,
					selectFirst: true,
					valueSelected:true,
					loadId : 'si_specimen_type_activitiesDisp,si_specimen_type_activities'
				});

				$("#si_specimen_col_methodDisp").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","SnomedSctHl7",'code',"display_name",'null',"admin" => false,"plugin"=>false)); ?>", {
					width: 250,
					selectFirst: true,
					valueSelected:true,
					loadId : 'si_specimen_col_methodDisp,si_specimen_col_method'
				});

				$("#si_specimen_col_amountDisp").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","Ucums",'code',"display_name",'null',"admin" => false,"plugin"=>false)); ?>", {
					width: 250,
					selectFirst: true,
					valueSelected:true,
					loadId : 'si_specimen_col_amountDisp,si_specimen_col_amount'
				});

				$('.observationCls').live('focus',function() { 
				$(this).autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","Laboratory",'lonic_code',"name",'null',"admin" => false,"plugin"=>false)); ?>",
					{
					width: 250,
					selectFirst: true,
					valueSelected:true,
					loadId : $(this).attr('id')+','+$(this).attr('id').replace("Display_","_")
					});
				});

				$('.uomCls').live('focus',function() {
				$(this).autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","Ucums",'code',"display_name",'null',"admin" => false,"plugin"=>false)); ?>",
					{
					width: 250,
					selectFirst: true,
					valueSelected:true,
					loadId : $(this).attr('id')+','+$(this).attr('id').replace("Display_","_")
					});
			});

				$('.abnormalFlagCls')
				.live('focus',function() { 
				$(this).autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","ObservationInterpretation0078",'code',"display_name",'null',"admin" => false,"plugin"=>false)); ?>",
					{
					width: 250,
					selectFirst: true,
					valueSelected:true,
					loadId : $(this).attr('id')+','+$(this).attr('id').replace("Display_","_")
					});
			});

				$('.obserMethod')
				.live('focus',function() { 
				$(this).autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","Hl7ObservationMethod",'value_code','description','null',"admin" => false,"plugin"=>false)); ?>",
					{
					width: 250,
					selectFirst: true,
					valueSelected:true,
					loadId : $(this).attr('id')+','+$(this).attr('id').replace("Display_","_")
					});
			});

		 });//si_specimen_col_amountDisp

		 //For flag claculation
		 $('#range_0').blur(function(){
			var baseValue=parseInt($('#sn_result_0').val());
			var range=$('#range_0').val();
			var splitRange=range.split('-');
			var lowerLimit=parseInt(splitRange['0']);
			var upperLimit=parseInt(splitRange['1']);
		
			if(baseValue < lowerLimit){
				$('#abnormal_flagDisplay_0').val('Below low normal');
				$('#abnormal_flag_0').val('L');
				$('#abnormal_flagDisplay_0').addClass('blue');
				$('#abnormal_flagDisplay_0').removeClass('green');
				$('#abnormal_flagDisplay_0').removeClass('orange');
			}
			else if((baseValue >= lowerLimit) && (baseValue <= upperLimit)){
				$('#abnormal_flagDisplay_0').val('Normal (applies to non-numeric results)');
				$('#abnormal_flag_0').val('N');
				$('#abnormal_flagDisplay_0').addClass('green');
				$('#abnormal_flagDisplay_0').removeClass('blue');
				$('#abnormal_flagDisplay_0').removeClass('orange');
			}
			else{
				$('#abnormal_flagDisplay_0').val('Above high normal');
				$('#abnormal_flag_0').val('H');
				$('#abnormal_flagDisplay_0').addClass('orange');
				$('#abnormal_flagDisplay_0').removeClass('green');
				$('#abnormal_flagDisplay_0').removeClass('blue');
			}
			 });
		 $('#unit_0').change(function(){
			 if($('#unit_0').val() == 'CWE'){
					$('.UOM').hide();
			}else{
				$('.UOM').show();
			}
		});
		 //
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
