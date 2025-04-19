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
		<?php echo __("Result");?>
	</h1>
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

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->DateFormat->formatDate2Local($patientData['Person']['dob'],Configure::read('date_format_us'),false);?>
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
		if ($raceString == ', ') {
			echo $raceString = '';
		}
		
		?>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php if(!empty($raceString)){echo $raceString;}else{ echo "Denied to specify";}?>
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
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0"
	class="formFull">
	<tr>
		<th colspan="5"><?php echo __("Ordering Provider") ; ?></th>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Name");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('op_name', array('type'=>'text','label'=>false, 'class'=> 'textBoxExpnd','style'=>'width:250px','id' => 'op_name','value'=>$doctorData['User']['first_name'].$doctorData['User']['last_name'])); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Identifier number");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('op_identifier_number', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'op_identifier_number','value'=>$doctorData['User']['id'])); ?>
		</td>
	</tr>


</table>
<!--  <div>
	<input class="blueBtn" type="button" value="Add More"
		id="labResultButton"> <input class="blueBtn" type="button"
		value="Remove" id="RemoveLabResultButton">
</div> -->
<div id="labHl7Results">
<?php
if ($LabName ['Laboratory'] ['lab_type'] == '2') {
	?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0"
		class="formFull" id="labHl7Results">
		<tr>
			<th colspan="178"><?php echo __("Lab Results") ; ?></th>
		</tr>		
		<?php
	
	$unserializeHistopathologyData = unserialize ( $LabName ['Laboratory'] ['histopathology_data'] );
	$r = 1;
	foreach ( $unserializeHistopathologyData as $key => $getData ) {
		?>
		<tr>
			<td class="tdLabel" valign="middle">
		<?php
		
		echo $this->Form->input ( '', array (
				'name' => "data[labHl7Result1][$key][0]",
				'class' => "",
				'label' => false,
				'div' => false,
				'error' => false,
				'id' => '',
				'value' => $getData [0],
				'type' => 'text',
				'style' => 'width:300px;' 
		) );
		?>
	</td>
			<td class="tdLabel" valign="middle"><?php //echo ('('.$r.')')?>
		  <?php
		
		echo $this->Form->input ( '', array (
				'name' => "data[labHl7Result1][$key][1]",
				'id' => 'histopathology_data_Frst',
				'label' => false,
				'div' => false,
				'error' => false,
				'style' => 'width:682px',
				'type' => 'text',
				'value' => $getData ['1'] 
		) );
		?>     	</td>

		</tr>				
		<?php $r++; }?>				
		
		<tr>
			<td>&nbsp;</td>
		</tr>

		<!--<tr>
			<td colspan="10"><hr></td>
		</tr>-->

	</table><?php }else{?>
<?php if(empty($getPanelSubLab)){?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0"
		class="formFull" id="labHl7Results_0">

		<tr>
			<th colspan="10"><?php echo __("Lab Results") ; ?></th>
		</tr>
		<tr>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Observation");?>
			</td>
			<!-- 
			<td width="10%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Type");?>
			</td>
			 -->
			<td width="10%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Result");?>
			</td>
			<td width="15%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Unit of measure");?>
			</td>
			<td width="10%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Range");?>
			</td>
			<td width="10%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Abnormal Flag");?>
			</td>
			<td width="30%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Status");?>
			</td>
			<!-- 
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Date/Time of observation");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Notes");?>
		</td>
		-->
		</tr>


		<?php //echo '';print_r($hl7_coded_observation_option);exit;?>
		<tr>

			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		// debug($specimenData);
		// pr($LabName);exit;
		// $new_value = $pleaseSelect;
		// array_unshift($new_value,$loincCode, $new_value);
		// echo $this->Form->input('observationDisplay_0', array('style'=>'width:240px; float:left;','id'=>'observationDisplay_0','class'=>'observationCls','value'=>$specimenData['Laboratory']['name'],'readonly'=>'readonly'));//,'value'=>$specimenData['Laboratory']['name'],'readonly'=>'readonly'));
		echo $specimenData ['Laboratory'] ['name'];
		// 'class'=>'observationCls' remove to autocomplete Aditya
		echo $this->Form->hidden ( 'observation_0', array (
				'id' => 'observation_0',
				'value' => $LabName ['Laboratory'] ['lonic_code'] 
		) );
		?>
			</td>
			<td width="10%" valign="middle" class="tdLabel" id="boxspace"><?php
		// echo $this->Form->input('unit_0', array('style'=>'width:150px; float:left;','options'=>$units_option,'empty'=>__('Please select'), 'id'=>'unit_0','class'=>'myUnit'));		?>
			</td>
			<td width="10%" valign="middle" class="tdLabel" id="boxspace"><div
					style="display: block" id="observationLabResult_0">
					<?php echo $this->Form->input('sn_result_0', array('type'=>'text','label'=>false,'style'=>'width:50px','id' => 'sn_result_0')); ?>
				</div>
				<div id="labCodedObservation_0" style="display: none">
					<?php
		echo $this->Form->input ( 'result_0', array (
				'style' => 'width:150px; float:left;',
				'options' => $specimenTypeSnomedSct,
				'empty' => __ ( 'Please select' ),
				'id' => 'result_0' 
		) );
		?>
				</div></td>
			<?php 	//for unit of measures ?>
			<td width="15%" valign="middle" class="tdLabel" id="boxspace"><?php
		echo $this->Form->input ( 'uomDisplay_0', array (
				'class' => 'uomCls',
				'style' => 'width:150px; float:left;',
				'id' => 'uomDisplay_0' . $key 
		) );
		echo $this->Form->hidden ( 'uom_0', array (
				'id' => 'uom_0' 
		) );
		?>
			
			</td> <?php  //for range ?>
			<td width="10%" valign="middle" class="tdLabel" id="boxspace">
			<?php
		
		echo $this->Form->input ( 'range_0', array (
				'type' => 'text',
				'label' => false,
				'style' => 'width:50px' 
		) );
		?>
			</td>
			<td width="40%" valign="middle" class="tdLabel" id="boxspace"><?php
		echo $this->Form->input ( 'abnormal_flagDisplay_0', array (
				'class' => 'abnormalFlagCls',
				'style' => 'width:150px; float:left;',
				'id' => 'abnormal_flagDisplay_0' 
		) );
		echo $this->Form->hidden ( 'abnormal_flag_0', array (
				'id' => 'abnormal_flag_0' 
		) );
		?>
			</td>
			<td width="30%" valign="middle" class="tdLabel" id="boxspace"><?php
		echo $this->Form->input ( 'status_0', array (
				'style' => 'width:150px; float:left;',
				'options' => $labResultStatus,
				'empty' => __ ( 'Please select' ),
				'id' => 'status_0' 
		) );
		// echo $this->Form->input('status_0', array('type'=>'text','label'=>false,'style'=>'width:50px','id' => 'status_0'));		?>
			</td>
			<!-- 
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('date_time_of_observation_0', array('type'=>'text','label'=>false,'style'=>'width:50px','id' => 'date_time_of_observation_0')); ?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php //echo $this->Form->input('notes_0', array('type'=>'text','label'=>false,'style'=>'width:50px','id' => 'notes_0')); ?>
		</td>
		 -->
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>

		<!--<tr>
			<td colspan="10"><hr></td>
		</tr>-->

	</table><?php }?>
	<?php if(!empty($getPanelSubLab)){?>
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0"
		class="formFull" id="labHl7Results_0">
		<tr>
			<th colspan="10"><?php echo __("Lab Results") ; ?></th>
		</tr>
		<tr>
			<td width="19%" valign="middle" class="tdLabel" id=""><?php echo __("Observation");?>
			</td>
			<!-- 
			<td width="10%" valign="middle" class="tdLabel" id=""><?php echo __("Type");?>
			</td>
			 -->
			<td width="10%" valign="middle" class="tdLabel" id=""><?php echo __("Result");?>
			</td>
			<td width="15%" valign="middle" class="tdLabel" id=""><?php echo __("Unit of Measure");?>
			</td>
			<td width="10%" valign="middle" class="tdLabel" id=""><?php echo __("Range");?>
			</td>
			<td width="10%" valign="middle" class="tdLabel" id=""><?php echo __("Abnormal Flag");?>
			</td>
			<td width="30%" valign="middle" class="tdLabel" id=""><?php echo __("Status");?>
			</td>
			<!-- 
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Date/Time of observation");?>
		</td>
		-->
			<td width="30%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Notes");?>
		</td>

		</tr>
		<?php }?>
		
		<?php  foreach($getPanelSubLab as $key=>$subData){?>
			<?php
		// if gender is persent
		
		if ($subData ['LaboratoryParameter'] ['type'] == 'text') {
			$defaultRange = $subData ['LaboratoryParameter'] ['parameter_text'];
		} else {
			if ($subData ['LaboratoryParameter'] ['by_gender_age'] == 'gender') {
				if ($patientData ['Person'] ['sex'] == 'male') { // if male
					$defaultRange = $subData ['LaboratoryParameter'] ['by_gender_male_lower_limit'] . "-" . $subData ['LaboratoryParameter'] ['by_gender_male_upper_limit'];
				} else { // female pArt
					$defaultRange = $subData ['LaboratoryParameter'] ['by_gender_female_lower_limit'] . "-" . $subData ['LaboratoryParameter'] ['by_gender_female_upper_limit'];
				}
			}
			if ($subData ['LaboratoryParameter'] ['by_gender_age'] == 'age') { // by Age
				$calAge = $this->DateFormat->age_from_dob ( $patientData ['Person'] ['dob'] );
				if (($subData ['LaboratoryParameter'] ['by_age_less_years'] == 1) && ($calAge < $subData ['LaboratoryParameter'] ['by_age_num_less_years'])) {
					$defaultRange = $subData ['LaboratoryParameter'] ['by_age_num_less_years_lower_limit'] . "-" . $subData ['LaboratoryParameter'] ['by_age_num_less_years_upper_limit'];
				} elseif (($subData ['LaboratoryParameter'] ['by_age_more_years'] == 1) && ($calAge > $subData ['LaboratoryParameter'] ['by_age_num_more_years'])) {
					$defaultRange = $subData ['LaboratoryParameter'] ['by_age_num_gret_years_lower_limit'] . "-" . $subData ['LaboratoryParameter'] ['by_age_num_gret_years_upper_limit'];
				} else {
					$defaultRange = $subData ['LaboratoryParameter'] ['by_age_between_years_lower_limit'] . "-" . $subData ['LaboratoryParameter'] ['by_age_between_years_upper_limit'];
				}
			}
		}
		?>

		<?php //echo '';print_r($hl7_coded_observation_option);exit;?>
		<tr>
			<td width="19%" valign="middle" class="tdLabel" id=""><?php
		echo $this->Form->input ( '', array (
				'name' => 'Panel[observationDisplay_0][]',
				'style' => 'width:240px; float:left;',
				'id' => 'observationDisplay_0',
				'class' => 'observationCls',
				'value' => $subData ['LaboratoryParameter'] ['name'],
				'readonly' => 'readonly' 
		) ); // ,'value'=>$specimenData['Laboratory']['name'],'readonly'=>'readonly'));
		     // 'class'=>'observationCls' add to autocomplete Aditya
		echo $this->Form->hidden ( '', array (
				'name' => 'Panel[obs_id][]',
				'value' => $subData ['LaboratoryParameter'] ['laboratory_id'],
				'id' => 'observation_0' 
		) );
		?>
			</td>
			<!-- 
			<td width="10%" valign="middle" class="tdLabel" id=""><?php
		echo $this->Form->input ( '', array (
				'name' => 'Panel[unit_0][]',
				'style' => 'width:150px; float:left;',
				'options' => $units_option,
				'empty' => __ ( 'Please select' ),
				'id' => 'unit_0',
				'class' => 'myUnit' 
		) );
		?>
			</td>
			 -->
			<td width="10%" valign="middle" class="tdLabel" id=""><div
					style="display: block" id="observationLabResult_0">
					<?php //echo $this->Form->input('', array('name'=>'Panel[sn_value_0][]','type'=>'text','label'=>false,'style'=>'width:125px','id' => 'sn_value_0'.$key)); ?>
					<?php echo $this->Form->input('', array('name'=>'Panel[sn_value_0][]','class'=>'getBlurId','type'=>'text','label'=>false,'style'=>'width:50px','id' => 'sn_result_0'.$key,'autocomplete'=>'off')); ?>
				</div>
				<div id="labCodedObservation_0" style="display: none">
					<?php
		echo $this->Form->input ( '', array (
				'name' => 'Panel[result_0][]',
				'style' => 'width:150px; float:left;',
				'options' => $specimenTypeSnomedSct,
				'empty' => __ ( 'Please select' ),
				'id' => 'result_0' 
		) );
		?>
				</div></td>

			<td width="15%" valign="middle" class="tdLabel" id=""><?php
		// uomCls classs removed because it is made read only now.
		// echo $optUcums[$subData['LaboratoryParameter']['unit']];
		echo $subData ['LaboratoryParameter'] ['unit'];
		echo $this->Form->hidden ( '', array (
				'name' => 'Panel[uomDisplay_0][]',
				'class' => '',
				'style' => 'width:150px; float:left;',
				'id' => 'uomDisplay_0',
				'value' => $optUcums [$subData ['LaboratoryParameter'] ['unit']] 
		) );
		echo $this->Form->hidden ( 'uom_0', array (
				'name' => 'Panel[uomDisplay_0_id][]',
				'id' => 'uom_0',
				'value' => $subData ['LaboratoryParameter'] ['unit'] 
		) );
		?>
			</td>
			<td width="10%" valign="middle" class="tdLabel" id="">
			<?php
		echo $defaultRange;
		echo $this->Form->hidden ( '', array (
				'name' => 'Panel[range_0][]',
				'type' => 'text',
				'label' => false,
				'style' => 'width:50px',
				'id' => 'range_0' . $key,
				'value' => $defaultRange,
				'readonly' => 'readonly' 
		) );
		?>
			</td>
			<td width="10%" valign="middle" class="tdLabel" id=""><?php
		echo $this->Form->input ( '', array (
				'name' => 'Panel[abnormal_flagDisplay_0][]',
				'class' => '',
				'style' => 'width:150px; float:left;',
				'id' => 'abnormal_flagDisplay_0' . $key,
				'autocomplete' => 'off' 
		) );
		echo $this->Form->hidden ( 'abnormal_flag_0', array (
				'name' => 'Panel[abnormal_flagDisplay_0_id][]',
				'id' => 'abnormal_flag_0' . $key 
		) );
		?>
			</td>
			<td width="30%" valign="middle" class="tdLabel" id=""><?php
		echo $this->Form->input ( '', array (
				'name' => 'Panel[status_0][]',
				'style' => 'width:150px; float:left;',
				'options' => $labResultStatus,
				'empty' => __ ( 'Please select' ),
				'id' => 'status_0' 
		) );
		// echo $this->Form->input('status_0', array('type'=>'text','label'=>false,'style'=>'width:50px','id' => 'status_0'));		?>
			</td>
			<!-- 
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('date_time_of_observation_0', array('type'=>'text','label'=>false,'style'=>'width:50px','id' => 'date_time_of_observation_0')); ?>
		</td>
		 -->
			<td width="19%" valign="middle" class="tdLabel"><?php echo $this->Form->input('notes_0', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'notes_0')); ?>
		</td>

		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
	
	<?php }?>
	</table>
	
	
	
	<?php
	// if($LabName['Laboratory']['lab_type']=='1'){	?>
	<!-- <table width="100%" border="0" cellspacing="0" cellpadding="0"
		class="formFull" id="labHl7Results">		
		<tr>
		<?php
	
	$getRegularData = Configure::read ( 'regular_data' );
	$r = 1;
	foreach ( $getRegularData as $getData ) {
		?>
		<td class="tdLabel" valign="middle"><?php //echo ('('.$r.')')?><?php echo $getData;/*$this->Html->link($getData, 'javascript:void(0)', array('title'=>'Click here to edit insurance','class'=>'newallInsurance','id'=>'newallInsurance_','escape' => false));*/?></td>&nbsp;&nbsp;&nbsp;
							<?php $r++; }?>		
		</tr>
		<tr>
		<?php
	// $gethistopathologyData=Configure::read('histopathology_data');
	$r = 1;
	foreach ( $getRegularData as $key => $getData ) {
		?>
		<td class="tdLabel" valign="middle"><?php //echo ('('.$r.')')?>
		<?php
		echo $this->Form->input ( 'LaboratoryResultRegular.regular_data_' . $r, array (
				'type' => 'text',
				'label' => false,
				'style' => 'width:80px;float:left;',
				'id' => ''/*,'name'=>'histopathology_data_'.$r*/) );
		?></td>&nbsp;&nbsp;&nbsp;
		<?php $r++; }?>		
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>

		<!--<tr>
			<td colspan="10"><hr></td>
		</tr>-->

	</table> <?php //}?>
</div>


<?php }?>




<!-- Observation Details Starts -->
<!-- gaurav 
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

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('ogi_placer_order_number', array('type'=>'text','readonly'=>'readonly','label'=>false,'class'=> 'textBoxExpnd','style'=>'width:250px','id' => 'ogi_placer_order_number','value'=>$patientData['LaboratoryTestOrder']['order_id'])); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Filler Order Number");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		
		if (! empty ( $fillerOderNumber )) {
			$readonly = 'readonly';
		}
		echo $this->Form->input ( 'ogi_filler_order_number', array (
				'value' => $fillerOderNumber,
				'type' => 'text',
				'label' => false,
				'class' => 'textBoxExpnd',
				'readonly' => 'readonly',
				'style' => 'width:250px',
				'id' => 'ogi_filler_order_number',
				'readonly' => $readonly 
		) );
		?>
		</td>
	</tr> gaurav -->
<!-- 
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Placer Group Number");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('ogi_placer_group_number', array('type'=>'text','label'=>false,'style'=>'width:250px', 'class'=> 'textBoxExpnd','id' => 'ogi_placer_group_number')); ?>
		</td>
	</tr> -->

<!-- 
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><strong><?php echo __("Parent Universal Service Identifier ") ; ?></strong></td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Identifier");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('pusi_identifier', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'pusi_identifier')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Text");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('pusi_text', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'pusi_text')); ?>
		</td>
	</tr>
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



<!-- gaurav 

	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><strong><?php echo __("Observation details ") ; ?>
		</strong></td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Universal Service Identifier");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		echo __ ( $LabName ['Laboratory'] ['name'] );
		echo $this->Form->hidden ( 'od_universal_service_identifier', array (
				'id' => 'od_universal_service_identifier',
				'value' => $LabName ['Laboratory'] ['lonic_code'] 
		) );
		// echo $this->Form->input('od_universal_service_identifier', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'od_universal_service_identifier','value'=>$specimenData['Laboratory']['name']));		?>
		</td>
	</tr> gaurav -->
<!--<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Observation Date/Time");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('od_observation_date_time', array('type'=>'text','label'=>false,'style'=>'width:250px', 'class'=> 'textBoxExpnd', 'id' => 'od_observation_date_time')); ?>
		</td>
	</tr>-->
<!-- gaurav<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Observation  Date/Time");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		
		echo $this->Form->input ( 'od_observation_start_date_time', array (
				'type' => 'text',
				'label' => false,
				'class' => 'textBoxExpnd',
				'id' => 'od_observation_start_date_time',
				'value' => $this->DateFormat->formatDate2Local ( $patientData ['LaboratoryTestOrder'] ['start_date'], Configure::read ( 'date_format_us' ), false ) 
		) );
		?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Observation  End Date/Time");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		
		echo $this->Form->input ( 'od_observation_end_date_time', array (
				'type' => 'text',
				'label' => false,
				'class' => 'textBoxExpnd',
				'id' => 'od_observation_end_date_time',
				'value' => $this->DateFormat->formatDate2Local ( date ( 'm/d/y' ), Configure::read ( 'date_format_us' ), false ) 
		) );
		?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Action Code");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		echo $this->Form->input ( 'od_specimen_action_code', array (
				'style' => 'width:269px; float:left;',
				'options' => $speciemtActionCode0065,
				'empty' => __ ( 'Please select' ),
				'class' => 'textBoxExpnd',
				'id' => 'od_specimen_action_code' 
		) );
		// echo $this->Form->input('od_specimen_action_code', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'od_specimen_action_code'));
		// echo $this->Form->input('od_specimen_action_code', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'od_specimen_action_code','value'=>$specimenData['LaboratoryToken']['specimen_action_id']));		?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Relevant Clinical Information");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		// field to display only
		echo $this->Form->input ( 'relevant_clinical_info', array (
				'style' => 'width:253px; float:left;',
				'class' => 'textBoxExpnd',
				'id' => 'relevant_clinical_info',
				'value' => $patientData ['Note'] ['cc'] 
		) );
		// actual field to enter in db
		echo $this->Form->hidden ( 'od_relevant_clinical_information', array (
				'id' => 'od_relevant_clinical_information' 
		) );
		?>
		</td>
	</tr> gaurav  -->
<!-- 
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Alt Relevant Clinical Information");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('od_alt_relevent_clinical_information', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'od_alt_relevent_clinical_information','value'=>$patientData['Note']['cc'])); ?>
		</td>
	</tr>
	-->
<!-- gaurav <tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Relevant Clinical Information Original Text");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('od_relevent_clinical_information_original_text', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'od_relevent_clinical_information_original_text','value'=>$patientData['Note']['cc'])); ?>
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
		echo $this->Form->input ( 'ori_result_status', array (
				'style' => 'width:266px; float:left;',
				'options' => $resultStatus0123,
				'empty' => __ ( 'Please select' ),
				'id' => 'ori_result_status' 
		) );
		// echo $this->Form->input('ori_result_status', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'ori_result_status'));		?>
		</td>
	</tr> gaurav -->
<!--
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Result Report/Status change-Date/Time");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('ori_result_report_status_date_time', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'ori_result_report_status_date_time')); ?>
		</td>
	</tr>
	-->

<!-- gaurav <tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><strong><?php echo __("Result copy To") ; ?>
		</strong></td>
	</tr>

	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Prefix/Suffix");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('rct_prefix', array('type'=>'text','label'=>false,'style'=>'width:50px','id' => 'rct_prefix','div'=>false)); ?>
			<?php echo $this->Form->input('rct_suffix', array('type'=>'text','label'=>false,'style'=>'width:50px','id' => 'rct_suffix','div'=>false)); ?>

		</td>
	</tr>

	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("First Name");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('rct_name', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'rct_name')); ?>
		</td>
	</tr>

	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Middle Name");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('rct_middle_name', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'rct_middle_name')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Last Name");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('rct_last_name', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'rct_last_name')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Indentifier number");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('rct_identifier', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'rct_identifier')); ?>
		</td>
	</tr>





	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><strong><?php echo __("Result Handling") ; ?>
		</strong></td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Standard");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('rh_standard', array('options'=>array(''=>'Please Select','Carbon Copy'=>'Carbon Copy'),'label'=>false,'style'=>'width:250px','id' => 'rh_standard')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Local");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('rh_local', array('options'=>array(''=>'Please Select','Send Copy'=>'Send Copy'),'label'=>false,'style'=>'width:250px','id' => 'rh_local')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><strong><?php echo __("Observation Notes") ; ?>
		</strong></td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Notes and Comments");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('on_notes_comments', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'on_notes_comments')); ?>
		</td>
	</tr>

</table>

gaurav -->
<!-- Observation Details Ends -->

<!-- gaurav

<table width="100%" border="0" cellspacing="0" cellpadding="0"
	class="formFull">
	<tr>
		<th colspan="5"><?php echo __("Timing/Quantity Information") ; ?></th>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Start Date/Time");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('tqi_start_date_time', array('type'=>'text','label'=>false,'class'=> 'textBoxExpnd','id' => 'tqi_start_date_time')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("End Date/Time");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('tqi_end_date_time', array('type'=>'text','label'=>false,'class'=> 'textBoxExpnd','id' => 'tqi_end_date_time')); ?>
		</td>
	</tr>
</table>
 gaurav -->
<!-- OBX Starts -->
<!-- 
<table width="100%" border="0" cellspacing="0" cellpadding="0"
	class="formFull">
	<tr>
		<th colspan="5"><?php //echo __("Result Performing Laboratory") ; ?></th>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php //echo __("Laboratory Name");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php //echo $this->Form->input('rpl_laboratory_name', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'rpl_laboratory_name')); ?>
		</td>
	</tr>
	
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php //echo __("Organization Identifier");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php //echo $this->Form->input('rpl_organization_identifier', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'rpl_organization_identifier')); ?>
		</td>
	</tr>
	
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php //echo __("Director Initial");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		
		// echo $this->Form->input('rpl_initial', array('style'=>'width:150px; float:left;','empty'=>__('Please select'),'options'=>array_combine($initial_option,$initial_option), 'id'=>'rpl_initial'));		?>
		</td>
		
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php //echo __("Director Legal Name");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		
		// echo $this->Form->input('rpl_legal_name', array('style'=>'width:150px; float:left;','empty'=>__('Please select'),'options'=>$nameType_option, 'id'=>'rpl_legal_name'));		?>
		</td>
		
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php //echo __("Director First Name");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php //echo $this->Form->input('rpl_director_name', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'rpl_director_name')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php //echo __("Director Middle Name");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php //echo $this->Form->input('rpl_director_middle_name', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'rpl_director_middle_name')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php //echo __("Director Last Name");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php //echo $this->Form->input('rpl_director_last_name', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'rpl_director_last_name')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php //echo __("Director Suffix");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php //echo $this->Form->input('rpl_director_suffix', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'rpl_director_suffix')); ?>
		</td>
	</tr>
	
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php //echo __("Director identifier");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php //echo $this->Form->input('rpl_director_identifier', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'rpl_director_identifier')); ?>
		</td>
	</tr>
</table>
-->

<!-- OBX ENDS -->
<!-- gaurav 
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
		echo $this->Form->input ( 'specimen_type_disp', array (
				'style' => 'width:150px; float:left;',
				'class' => 'textBoxExpnd',
				'id' => 'specimen_type_disp',
				'value' => $specimenData ['SnomedSctHl7'] ['display_name'] 
		) );
		// for interting value to db
		echo $this->Form->hidden ( 'si_specimen_type', array (
				'id' => 'si_specimen_type',
				'value' => $specimenData ['SnomedSctHl7'] ['code'] 
		) );
		?></td>
	</tr>
	 gaurav -->
<!-- 
	  	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Alt Specimen Type ");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('si_alt_specimen_type', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'si_alt_specimen_type')); ?>
		</td>
	</tr> 
	 -->
<!-- gaurav
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Original Text");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('si_specimen_original_text', array('type'=>'text','label'=>false,'style'=>'width:250px','class'=> 'textBoxExpnd','id' => 'si_specimen_original_text')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Start date/time");?>
		</td>

		<?php //echo $this->DateFormat->formatDate2Local($specimenData['LaboratoryTestOrder']['start_date'],Configure::read('date_format_us'),false); ?>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('si_start_date_time', array('type'=>'text','label'=>false,'style'=>'width:250px','class'=> 'textBoxExpnd','id' => 'si_start_date_time','value'=>  $this->DateFormat->formatDate2Local($specimenData['LaboratoryTestOrder']['start_date'],Configure::read('date_format_us'),false)));?>
		</td>
	</tr>
	<tr>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Reject Reason");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		echo $this->Form->input ( 'si_specimen_reject_reason', array (
				'style' => 'width:150px; float:left;',
				'options' => $specimenRejectReason,
				'empty' => __ ( 'Please select' ),
				'class' => 'textBoxExpnd',
				'id' => 'si_specimen_reject_reason' 
		) );
		// echo $this->Form->input('si_specimen_reject_reason', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'si_specimen_reject_reason'));		?>
		</td>
	</tr>
	gaurav -->
<!-- 
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Alt Specimen Reject Reason");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('si_alt_specimen_reject_reason', array('type'=>'text','label'=>false,'style'=>'width:250px','class'=> 'textBoxExpnd','id' => 'si_alt_specimen_reject_reason')); ?>
		</td>
	</tr>
	-->
<!-- gaurav 
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Reject Reason Original Text");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('si_reject_reason_original_text', array('type'=>'text','label'=>false,'style'=>'width:250px', 'class'=> 'textBoxExpnd','id' => 'si_reject_reason_original_text')); ?>
		</td>
	</tr>


	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Specimen Condition ");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php
		echo $this->Form->input ( 'si_specimen_condition', array (
				'style' => 'width:150px; float:left;',
				'options' => $specimenConditionReason,
				'empty' => __ ( 'Please select' ),
				'class' => 'textBoxExpnd',
				'id' => 'si_specimen_condition' 
		) );
		// echo $this->Form->input('si_specimen_condition', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'si_specimen_condition'));
		// echo $this->Form->input('si_specimen_condition', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'si_specimen_condition','value'=>$specimenData['LaboratoryToken']['specimen_condition_id']));		?>
		</td>
	</tr>
	 gaurav -->
<!-- 
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Alt Specimen Condition ");?>
		</td>
		
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('si_alt_specimen_condition', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'si_alt_specimen_condition')); ?>
		</td>
	</tr>
	-->
<!-- gaurav 
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Condition Original Text ");?>
		</td>

		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('si_condition_original_text', array('type'=>'text','label'=>false,'style'=>'width:250px', 'class'=> 'textBoxExpnd','id' => 'si_condition_original_text')); ?>
		</td>
	</tr>
</table>



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
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('re_notes_comments', array('type'=>'text','label'=>false,'style'=>'width:250px','class'=> 'textBoxExpnd','id' => 're_notes_comments')); ?>
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
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('send_result_to_facility', array('value'=>$send_result_to_facility,'type'=>'text','label'=>false,'style'=>'width:250px', 'class'=> 'textBoxExpnd','id' => 'send_result_to_facility')); ?>
		</td>
	</tr>
</table>
 gaurav -->
<input type=hidden value="0" name="labcount" id="labcount">
<input class="blueBtn" type=submit value="Submit" name="Submit"
	style="float: right; margin-top: 10px;">
<!--  <input class="blueBtn" type=submit
	value="Submit & Add More" name="Submit & Add More"> -->
<?php echo $this->Form->hidden('observation_0', array('id'=>'observation_0','value' => $LabName['Laboratory']['lonic_code']));?>
<?php echo $this->Form->hidden('noteId', array('id' => 'noteId','value'=>$noteId));?>
<?php echo $this->Form->end();?>
<div id="abnflag" style="display: none">
	<?php
	
	echo $this->Form->input ( 'abnormal_flagDisplay_0', array (
			'class' => 'abnormalFlagCls',
			'style' => 'width:150px; float:left;',
			'id' => 'abnormal_flagDisplay_0' 
	) );
	echo $this->Form->hidden ( 'abnormal_flag_0', array (
			'id' => 'abnormal_flag_0' 
	) );
	?>
</div>
<div id="abnflagstatus" style="display: none">
	<?php echo $this->Form->input('status_0', array('style'=>'width:150px; float:left;','options'=>$labResultStatus,'empty'=>__('Please select'), 'id'=>'status_0'));?>
</div>
<div id="abnflagunit" style="display: none">
	<?php echo $this->Form->input('unit_0', array('style'=>'width:150px; float:left;','options'=>$units_option,'empty'=>__('Please select'), 'id'=>'unit_0','class'=>'myUnit'));?>
</div>
<div id="abnflaguom" style="display: none">
	<?php
	
	echo $this->Form->input ( 'uomDisplay_0', array (
			'class' => 'uomCls',
			'style' => 'width:150px; float:left;',
			'id' => 'uomDisplay_0' 
	) );
	echo $this->Form->hidden ( 'uom_0', array (
			'id' => 'uom_0' 
	) );
	?>
</div>
<div id="abnflagobs" style="display: none">
	<?php
	
	echo $this->Form->input ( 'observationDisplay_0', array (
			'class' => 'observationCls',
			'style' => 'width:150px; float:left;',
			'id' => 'observationDisplay_0' 
	) );
	echo $this->Form->hidden ( 'observation_0', array (
			'id' => 'observation_0' 
	) );
	?>
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
var labInput = '<tr><td width="19%" valign="middle" class="tdLabel" id="boxspace">###ABNOBSFLG###</td><td width="19%" valign="middle" class="tdLabel" id="boxspace">###ABNUNITFLG###</td><td width="19%" valign="middle" class="tdLabel" id="boxspace"><div  style="display:block" id="observationLabResult_0"><?php //echo $this->Form->input('sn_value_0', array('type'=>'text','label'=>false,'style'=>'width:10px','id' => 'sn_value_0')); ?><?php echo $this->Form->input('sn_result_0', array('type'=>'text','label'=>false,'style'=>'width:50px','id' => 'sn_result_0')); ?></div><div id="labCodedObservation_0" style="display:none">###ABNRESULT###</div></td><td width="19%" valign="middle" class="tdLabel" id="boxspace">###ABNUOMFLG###</td><td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input("range_0", array("type"=>"text","label"=>false,"style"=>"width:50px","id" => "range")); ?></td><td width="19%" valign="middle" class="tdLabel" id="boxspace">###ABNFLG###</td><td width="19%" valign="middle" class="tdLabel" id="boxspace">###ABNSTATUS###</td></tr>';
var labInput1 = '<tr><td width="19%" valign="middle" class="tdLabel" id="boxspace">###ABNOBSFLG###</td><td width="19%" valign="middle" class="tdLabel" id="boxspace">###ABNUNITFLG###</td><td width="19%" valign="middle" class="tdLabel" id="boxspace"><div  style="display:block" id="observationLabResult_0"><?php //echo $this->Form->input('sn_value_0', array('type'=>'text','label'=>false,'style'=>'width:10px','id' => 'sn_value_0')); ?><?php echo $this->Form->input('sn_result_0', array('type'=>'text','label'=>false,'style'=>'width:50px','id' => 'sn_result_0')); ?></div><div id="labCodedObservation_0" style="display:none">###ABNRESULT###</div></td><td width="19%" valign="middle" class="tdLabel" id="boxspace">###ABNUOMFLG###</td><td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input("range_0", array("type"=>"text","label"=>false,"style"=>"width:50px","id" => "range")); ?></td><td width="19%" valign="middle" class="tdLabel" id="boxspace">###ABNFLG###</td><td width="19%" valign="middle" class="tdLabel" id="boxspace">###ABNSTATUS###</td></tr>';


$(function() {
    $("#labResultButton").click(function(event) {
    	ss= "labHl7Results_"+counter ;
		counter++;
		
    	var newCostDiv = $(document.createElement('table')).attr("id",'labHl7Results_'+ counter).attr("class",'formFull');
    	labInput = labInput1;
    	
    	labInput = labInput.replace("###ABNFLG###",$("#abnflag").html()); 
    	labInput = labInput.replace("###ABNRESULT###",$("#myobsflag	").html());
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

		labInput = labInput.replace(/unit_0/g,"unit_"+counter);
		labInput = labInput.replace(/unit_0/g,"unit_"+counter);
		labInput = labInput.replace(/sn_value_0/g,"sn_value_"+counter);
		labInput = labInput.replace(/result_0/g,"result_"+counter); 
		labInput = labInput.replace(/sn_result_0/g,"sn_result_"+counter);
		
		labInput = labInput.replace(/range_0/g,"range_"+counter); 
		
		labInput = labInput.replace(/status_0/g,"status_"+counter); 
		labInput = labInput.replace(/observationLabResult_0/g,"observationLabResult_"+counter); 
		labInput = labInput.replace(/labCodedObservation_0/g,"labCodedObservation_"+counter); 
		labInput = labInput.replace(/result_0/g,"result_"+counter); 
		labInput = labInput.replace(/result_0/g,"result_"+counter); 
		labInput = labInput.replace(/result_0/g,"result_"+counter); 
		labInput = labInput.replace(/sn_result_0/g,"sn_result_"+counter); 
		labInput = labInput.replace(/sn_result_0/g,"sn_result_"+counter); 
		labInput = labInput.replace(/sn_result_0/g,"sn_result_"+counter);
		labInput = labInput.replace(/date_time_of_observation_0/g,"date_time_of_observation_"+counter);
		labInput = labInput.replace(/date_time_of_observation_0/g,"date_time_of_observation_"+counter);
		//'class'=>'dt_tm_observation',
		
		 
		

		

		newCostDiv.append(labText);
		newCostDiv.append(labInput);
		
		
		
		$(newCostDiv).insertAfter('#'+ss);
		$("#labcount").val(counter);
		
		
		
		
		
    });
});


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
				dateFormat:'<?php echo $this->General->GeneralDate();?>',
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
				minDate: new Date(),			 
				dateFormat:'<?php echo $this->General->GeneralDate();?>',
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
				dateFormat:'<?php echo $this->General->GeneralDate();?>',
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
				dateFormat:'<?php echo $this->General->GeneralDate();?>',
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
				dateFormat:'<?php echo $this->General->GeneralDate();?>',
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
				dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
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
		dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
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
				dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
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
				dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
			});
		
		});

		$(".dt_tm_observation").on("click",function() {
			
			$(this).datepicker({
						changeMonth : true,
						changeYear : true,
						yearRange : '1950',
					//	minDate : new Date(explode[0], explode[1] - 1,
					//			explode[2]),
						dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
						showOn : 'button',
						buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
						buttonImageOnly : true,
						onSelect : function() {
							$(this).focus();
						}
					});
	});

		$(function() {
		    $(".myUnit").on("change",function(event) {
		    
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

		 $(document).ready(function(){
	    	 
				$("#relevant_clinical_info").autocomplete("<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "testcomplete","SnomedSctHl7",'code',"display_name",'null',"admin" => false,"plugin"=>false)); ?>", {
					width: 250,
					selectFirst: true,
					valueSelected:true,
					loadId : 'relevant_clinical_info,od_relevant_clinical_information'
				});
				
				$("#specimen_type_disp").autocomplete("<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "testcomplete","SnomedSctHl7",'code',"display_name",'null',"admin" => false,"plugin"=>false)); ?>", {
					width: 250,
					selectFirst: true,
					valueSelected:true,
					loadId : 'specimen_type_disp,si_specimen_type'
				});

				$('.observationCls')
					.on('focus',function() { 
					$(this).autocomplete("<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "testcomplete","Laboratory",'lonic_code',"name",'null',"admin" => false,"plugin"=>false)); ?>",
						{
						width: 250,
						selectFirst: true,
						valueSelected:true,
						loadId : $(this).attr('id')+','+$(this).attr('id').replace("Display_","_")
						});

				});

				$('.uomCls')
					.on('focus',function() { 
					$(this).autocomplete("<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "testcomplete","Ucums",'code',"display_name",'null',"admin" => false,"plugin"=>false)); ?>",
						{
						width: 250,
						selectFirst: true,
						valueSelected:true,
						loadId : $(this).attr('id')+','+$(this).attr('id').replace("Display_","_")
						});
				});

				$('.abnormalFlagCls')
				.on('focus',function() { 
				$(this).autocomplete("<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "testcomplete","ObservationInterpretation0078",'code',"display_name",'null',"admin" => false,"plugin"=>false)); ?>",
					{
					width: 250,
					selectFirst: true,
					valueSelected:true,
					loadId : $(this).attr('id')+','+$(this).attr('id').replace("Display_","_")
					});
			});

				// color setiing---------------------------------------------------------------->
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
									var tenPerBelow= Math.round((100-(getResult/lowerLimtRange)*100));
							 		if((tenPerBelow<=10) &&(tenPerBelow>=1)){
										 $("#abnormal_flagDisplay_"+idValue[2]).css("color", "#2F72FF");
											// alert("#abnormal_flagDisplay_"+idValue[2]);
										 $("#abnormal_flagDisplay_"+idValue[2]).val("Below low normal");
								 		 $("#abnormal_flag_"+idValue[2]).val("L");
									 } 
									 if((tenPerBelow<=20) && (tenPerBelow >10)){
										 $("#abnormal_flagDisplay_"+idValue[2]).css("color", "#2F72FF");
										 $("#abnormal_flagDisplay_"+idValue[2]).val('Below lower panic limits');
										 $("#abnormal_flag_"+idValue[2]).val("LL");
							 		}
							 		if(tenPerBelow >=30){
										 $("#abnormal_flagDisplay_"+idValue[2]).css("color", "#2F72FF");
										 $("#abnormal_flagDisplay_"+idValue[2]).val('Below absolute low-off instrument scale');
								 		 $("#abnormal_flag_"+idValue[2]).val("<");
									 }
							 		tenPerBelow='';
						 	 }
						  if(parseInt(getResult) > parseInt(upperLimtRange)){
							 // alert('uper');
							  var tenPerAbove= Math.round((100-(upperLimtRange/getResult)*100));
								 if((tenPerAbove<=10) &&(tenPerAbove>=1)){
									 $("#abnormal_flagDisplay_"+idValue[2]).css("color", "#FF803E");		
									 $("#abnormal_flagDisplay_"+idValue[2]).val('Above high normal');
									 $("#abnormal_flag_"+idValue[2]).val("H");
								 } 
								 if((tenPerAbove<=20) && (tenPerAbove >10)){
									 $("#abnormal_flagDisplay_"+idValue[2]).css("color", "#F90223");
									 $("#abnormal_flagDisplay_"+idValue[2]).val('Above upper panic limits');
									 $("#abnormal_flag_"+idValue[2]).val("HH");
								 }
								 if(tenPerAbove >=30){
									 $("#abnormal_flagDisplay_"+idValue[2]).css("color", "#F90223");
									 $("#abnormal_flagDisplay_"+idValue[2]).val('Above absolute high-off instrument scale');
									 $("#abnormal_flag_"+idValue[2]).val(">");
								 }
								 tenPerBelow='';
						  }
						  if((parseInt(getResult) >= parseInt(lowerLimtRange)) && (parseInt(getResult) <= parseInt(upperLimtRange)) ){
							  $("#abnormal_flagDisplay_"+idValue[2]).css("color", "#FFF");
							  $("#abnormal_flagDisplay_"+idValue[2]).val('Normal');
								 $("#abnormal_flag_"+idValue[2]).val("N");
						  }
						  tenPerBelow='';
						  
						 });
				});
				//alert(getId);
				//var id=$('.getBlurId').attr(id);
				//alert(id);
				/* $( "#target" ).blur(function() {
					 alert( "Handler for .blur() called." );
					 }); */
				
		 });
		 
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
