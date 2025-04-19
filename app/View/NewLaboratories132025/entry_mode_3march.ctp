<?php
		echo $this->Html->script ( array (
				'jquery.fancybox-1.3.4',
				'jquery.tooltipster.min.js' 
		) );
		echo $this->Html->css ( array (
				'jquery.fancybox-1.3.4.css',
				'tooltipster.css' 
		) );
		
		?>
<?php

		$orderId = $this->params->query ['testOrderId'];
		// debug($orderId);exit;
		?>
<?php echo $this->Html->script('ckeditor/ckeditor'); ?>
<style>
.red {
	color: red !important;
}

.orange {
	color: orange !important;
}

.green {
	color: green !important;
}

/*----- Tabs -----*/
.tabs {
	width: 100%;
	display: inline-block;
}

/*----- Tab Links -----*/
/* Clearfix */
.tab-links:after {
	display: block;
	clear: both;
	content: '';
}

.tab-links li {
	margin: 0px 5px;
	float: left;
	list-style: none;
}

.tab-links a {
	padding: 9px 15px;
	display: inline-block;
	border-radius: 3px 3px 0px 0px;
	background: #7FB5DA;
	font-size: 16px;
	font-weight: 600;
	color: #4c4c4c;
	transition: all linear 0.15s;
}

.tab-links a:hover {
	background: #a7cce5;
	text-decoration: none;
}

li.active a, li.active a:hover {
	background: #fff;
	color: #4c4c4c;
}

/*----- Content of Tabs -----*/
.tab-content {
	padding: 15px;
	border-radius: 3px;
	box-shadow: -1px 1px 1px rgba(0, 0, 0, 0.15);
	background: #fff;
}

.tab {
	display: none;
}

.tab.active {
	display: block;
}

.tdLabellableCustom {
	color: #000;
	font-size: 14px;
}

.errorAbnormal {
	border: 1px solid red;
}
</style>

<?php

echo $this->Form->create ( 'LaboratoryResult', array (
		'type' => 'file',
		'id' => 'labfrm',
		'inputDefaults' => array (
				'label' => false,
				'legend' => false,
				'fieldset' => false 
		) 
) );

?>
<div style="width: 90%; margin-top: 10px; margin-right: auto">
	<table width="100%" border="0" cellspacing="0" cellpadding="0"
		style="border-right: 1px solid; border-top: 1px solid; border-left: 1px solid; margin-left: auto; margin-right: auto;">
		<tr>
			<td align="" valign="middle" class="tdLabellableCustom "
				id="boxspace"><b><?php echo __("Patient Name :");?></b></td>
			<td align="" valign="middle" class="lableCustom" id="boxspace"><?php echo $patientData['Patient']['lookup_name'];?>
		</td>
			<td align="" valign="middle" class="tdLabellableCustom "
				id="boxspace"><b><?php echo __("Age/Sex :");?></b></td>
			<td align="" valign="middle" class="lableCustom" id="boxspace"><?php echo $patientData['Patient']['age'].' / '.ucfirst($patientData['Person']['sex']);?>
		</td>
			<td align="" valign="middle" class="tdLabellableCustom "
				id="boxspace"><b><?php echo __("Type :");?></b></td>
			<td align="" valign="middle" class="lableCustom" id="boxspace"><?php echo $patientData['Patient']['admission_type'].' / '.strtoupper($patientData['TariffStandard']['name']);?>
		</td>
			<td align="" valign="middle" class="tdLabellableCustom "
				id="boxspace"><b><?php echo __("Ref By :");?></b></td>
			<td align="" valign="middle" class="lableCustom" id="boxspace"><?php echo ucwords($doctorData['User']['first_name']. ' ' .$doctorData['User']['last_name']);?>
		</td>
		</tr>

	</table>
<?php
// debug($prevResultArray);//exit;
if ($getPanelSubLab ['0'] ['Laboratory'] ['lab_type'] != 2) {
	
	?>
<!-- Non Histopathology Test starts -->
	<table width="100%" border="0" cellspacing="0" cellpadding="0"
		class="formFull" id="">
		<tr>
			<th colspan="10">
				<?php
				$reportDate = $this->DateFormat->formatDate2Local($getPanelSubLab[0]['LaboratoryResult']['report_date'],Configure::read('date_format'),true);
	$i = 0;
	echo __ ( "Lab Results" );
	if (! empty ( $authUser )) { // $authUser = all uathenticated usesr
		$login_user = $this->Session->read ( 'userid' ); // logined user
		if (in_array ( $login_user, $authUser )) {
			$disabled = false;
		} else {
			$disabled = true;
		}
	}
	echo $this->Form->input ( '', array (
			'name' => "LaboratoryResult[$i][is_authenticate]",
			'type' => 'checkbox',
			'div' => false,
			'label' => false,
			'style' => "margin-left:50px;",
			'disabled' => $disabled,
			'id' => 'isAuthenticateChecked',
			'class' => 'isAuthenticate' 
	) );
	?> Authenticated Result
	
	<?php echo $this->Form->input('from', array(
					'id' => 'report_date', 
					'name' => "LaboratoryResult[$i][report_date]",
					'label'=> false, 
					'value' =>$reportDate ,
					'div' => false, 
					'error' => false,
					'autocomplete'=>false,
					'class'=>'textBoxExpnd',
					'readonly'=>'readonly', 
					'div' => false,
					'type'=>'text',
					'title'=>'From'),false);
			?>
		</th>
		</tr>
		
		
		<?php
	// if(!empty($getPanelSubLab[0]['LaboratoryResult']['id'])||isset($getPanelSubLab[0]['LaboratoryResult']['id'])){
	// $this->Form->hidden('',array('id'=>'forChk','val'=>'1'));
	
	foreach ( $getPanelSubLab as $key => $subData ) {  
		$j = 0;
		// if($subData['Laboratory']['name']){ //laboratory name
		
		// /}
		//exit;
		
		if (strtoupper ( trim($subData ['TestGroup'] ['name']) ) == 'SEROLOGY') {
			?>
			<tr>
			<td width="" valign="middle" class="tdLabel" id=""><b><?php echo $subData['Laboratory']['name'];?></b>
			</td>
			<?php
			
			$prArray = $subData ['LaboratoryParameter'];
			usort ( $prArray, create_function ( '$a, $b', 'if ($a["id"] == $b["id"]) return 0; return ($a["id"] < $b["id"]) ? -1 : 1;' ) );
			$subData ['LaboratoryParameter'] = $prArray;
			foreach ( $subData ['LaboratoryParameter'] as $paraKey => $value ) {
				?>
		
		
		
		
		
		
		
		
		
		<tr>
			<td width="" valign="middle" class="tdLabel" id=""><span
				style="padding-left: 10px;"><?php echo $value['name'];?></span></td>
			<td width="" valign="middle" class="tdLabel" id=""><b><?php
				
				echo $this->Form->hidden ( '', array (
						'name' => "LaboratoryResult[$i][laboratory_id]",
						'value' => $subData ['Laboratory'] ['id'] 
				) );
				echo $this->Form->hidden ( '', array (
						'name' => "LaboratoryResult[$i][patient_id]",
						'value' => $subData ['LaboratoryTestOrder'] ['patient_id'] 
				) );
				echo $this->Form->hidden ( '', array (
						'name' => "LaboratoryResult[$i][laboratory_test_order_id]",
						'value' => $subData ['LaboratoryTestOrder'] ['id'] 
				) );
				echo $this->Form->hidden ( '', array (
						'name' => "LaboratoryResult[$i][user_id]",
						'value' => $doctorData ['User'] ['id'] 
				) );
				echo $this->Form->hidden ( '', array (
						'name' => "LaboratoryResult[$i][create_time]",
						'value' => date ( "Y-m-d H:i:s" ) 
				) );
				echo $this->Form->hidden ( '', array (
						'name' => "LaboratoryResult[$i][id]",
						'value' => $subData ['LaboratoryResult'] ['id']/* $subData['LaboratoryHl7Result'][$paraKey]['laboratory_result_id'] */) );
				echo $this->Form->hidden('', array('name'=>"LaboratoryResult[$i][is_authenticate]",'value'=>$subData ['LaboratoryResult'] ['is_authenticate'],'id'=>'isAuthenticate','class'=>'isAuthenticate'));
				echo $this->Form->hidden('', array('name'=>"LaboratoryResult[$i][report_date]",'value'=>$subData ['LaboratoryResult'] ['report_date'],'class'=>'reportDate'));
				echo $this->Form->hidden ( '', array (
						'name' => "LaboratoryResult[$i][op_name]",
						'value' => $doctorData ['User'] ['first_name'] . $doctorData ['User'] ['last_name'] 
				) );
				
				echo $this->Form->input ( '', array (
						'div' => false,
						'name' => "LaboratoryHl7Result[$i][$j][result]",
						'value' => ($subData ['LaboratoryHl7Result'] [$paraKey] ['result']) ? $subData ['LaboratoryHl7Result'] [$paraKey] ['result'] : $value ['parameter_text'],
						'class' => 'formulaId_' . $value ["id"] . ' getBlurId getVal validate[required,custom[mandatory-enter]] ' . $classNames,
						'type' => 'text',
						'label' => false,
						'style' => 'width:150px',
						'id' => "result-" . $i . _ . $j,
						'autocomplete' => 'off' 
				) ) . ' ' . $unitData;
				echo $this->Form->hidden ( '', array (
						'id' => "formulaCalc_" . $value ["id"],
						'name' => "LaboratoryHl7Result[$i][$j][formulaCalc]",
						'value' => $value ['formula'] 
				) );
				echo $this->Form->hidden ( '', array (
						'name' => "LaboratoryHl7Result[$i][$j][laboratory_parameter_id]",
						'value' => $value ['id'] 
				) );
				echo $this->Form->hidden ( '', array (
						'name' => "LaboratoryHl7Result[$i][$j][laboratory_test_order_id]",
						'value' => $subData ['LaboratoryTestOrder'] ['id'] 
				) );
				echo $this->Form->hidden ( '', array (
						'name' => "LaboratoryHl7Result[$i][$j][laboratory_id]",
						'value' => $value ['laboratory_id'] 
				) );
				echo $this->Form->hidden ( '', array (
						'name' => "LaboratoryHl7Result[$i][$j][id]",
						'value' => $subData ['LaboratoryHl7Result'] [$paraKey] ['id'] 
				) );
				$unitData = '';
				?></b>
			<?php
				$prevResultsString = implode ( " | ", $prevResultArray [$value ['id']] );
				$prevResultsString = trim ( trim ( $prevResultsString ), "|" );
				
				if ($prevResultsString) {
					$prevResultsString = "<b>" . $prevResultsString . "</b>";
					?>
			<span style="float: right; padding-right: 200px">
			<?php
					echo $this->Html->image ( 'icons/laboratory_result_icon.png', array (
							'width' => '16',
							'height' => '16',
							'class' => 'tooltip',
							'title' => $prevResultsString 
					) );
					?>
			</span>
			<?php
				}
				$prevResultsString = '';
				?>
			</td>
		</tr>
				<?php
				$j ++;
			}
			$i ++;
			
			// if($subData['Laboratory']['notes_display_text']){
			if ($subData ['LaboratoryResult'] ['text']) {
				$isOpinion = 'checked';
				$isOpinionDisplay = 'display:block';
			} else {
				$isOpinion = '';
				$isOpinionDisplay = 'display:none';
			}
			?>
				
				<tr>
			<td width="" valign="middle" class="tdLabel" id=""><b>
				<?php
			
			echo ($subData ['Laboratory'] ['notes_display_text']) ? $subData ['Laboratory'] ['notes_display_text'] : __ ( 'Comments' );
			echo $this->Form->input ( '', array (
					'checked' => $isOpinion,
					'name' => "LaboratoryResult[$i][is_opinion]",
					'value' => $subData ['Laboratory'] ['opinion'],
					'type' => 'checkbox',
					'div' => false,
					'label' => false,
					'style' => "margin-left:14px;",
					'id' => 'isOpinion_' . $subData ['Laboratory'] ['id'],
					'class' => 'isOpinion' 
			) );
			?></b></td>
			<td width="" valign="middle" class="tdLabel" id="" colspan="2">
				<?php
			echo $this->Form->input ( '', array (
					'style' => $isOpinionDisplay,
					'rows' > '4',
					'columns' => '4',
					'name' => "LaboratoryResult[$i][text]",
					'value' => ($subData ['LaboratoryResult'] ['text']) ? $subData ['LaboratoryResult'] ['text'] : $subData ['Laboratory'] ['notes'],
					'type' => 'textarea',
					'div' => false,
					'label' => false,
					'id' => 'opinion_' . $subData ['Laboratory'] ['id'],
					'class' => 'opinion' 
			) );
			?>
				</td>
		</tr>
				
				<?php //}?>
			<?php
		} else {
			?>
		<tr>
			<td width="28%" valign="middle" class="tdLabel" id=""><b><?php echo __("INVESTIGATION");?></b>
			</td>
			<td width="32%" valign="middle" class="tdLabel" id=""><b><?php echo __("OBSERVED VALUE");?></b>
			</td>
			<td width="30%" valign="middle" class="tdLabel" id=""><b><?php echo __("NORMAL RANGE");?></b>
			</td>
		</tr>
		
<?php
			// echo '<pre>';print_r($subData);
			$laboratoryName = $subData ['Laboratory'] ['name'];
			
			foreach ( $subData ['LaboratoryCategory'] as $labCatKey => $labCatValue ) {
				$isPrinted = 1;
				?>
				
				
				<?php
				$prArray = $subData ['LaboratoryParameter'];
				usort ( $prArray, create_function ( '$a, $b', 'if ($a["id"] == $b["id"]) return 0; return ($a["id"] < $b["id"]) ? -1 : 1;' ) );
				$subData ['LaboratoryParameter'] = $prArray;
				foreach ( $subData ['LaboratoryParameter'] as $paraKey => $value ) {
					// debug($value);exit;
					$defaultRange = '';
					echo $this->Form->hidden ( '', array (
							'name' => "LaboratoryHl7Result[$i][$j][laboratory_parameter_id]",
							'value' => $value ['id'] 
					) );
					echo $this->Form->hidden ( '', array (
							'name' => "LaboratoryHl7Result[$i][$j][laboratory_test_order_id]",
							'value' => $subData ['LaboratoryTestOrder'] ['id'] 
					) );
					echo $this->Form->hidden ( '', array (
							'name' => "LaboratoryHl7Result[$i][$j][laboratory_id]",
							'value' => $value ['laboratory_id'] 
					) );
					echo $this->Form->hidden ( '', array (
							'name' => "LaboratoryHl7Result[$i][$j][id]",
							'value' => $subData ['LaboratoryHl7Result'] [$paraKey] ['id'] 
					) );
					
					if ($value ['laboratory_categories_id'] == $labCatValue ['id']) {
						// echo $paraKey;
						
						if ($value ['type'] == 'text') {
							if ($subData ['Laboratory'] ['lab_type'] != 2) {
								$defaultRange = $value ['parameter_text'];
							} else {
								$defaultRange = $value ['parameter_text_histo'];
							}
						} else {
							if ($value ['by_gender_age'] == 'gender') {
								if ($patientData ['Person'] ['sex'] == 'male') { // if male
									$defaultRange = $value ['by_gender_male_lower_limit'] . " - " . $value ['by_gender_male_upper_limit'];
									$defaultResultParam = $value ['by_gender_male_default_result'];
								} else { // female pArt
									$defaultRange = $value ['by_gender_female_lower_limit'] . " - " . $value ['by_gender_female_upper_limit'];
									$defaultResultParam = $value ['by_gender_female_default_result'];
								}
							}
							if ($value ['by_gender_age'] == 'age') { // by Age
								$calAge = $this->DateFormat->age_from_dob ( $patientData ['Person'] ['dob'] );
								if (($value ['by_age_less_years'] == 1) && ($calAge < $value ['by_age_num_less_years'])) {
									$defaultRange = $value ['by_age_num_less_years_lower_limit'] . " - " . $value ['by_age_num_less_years_upper_limit'];
									$defaultResultParam = $value ['by_age_num_less_years_default_result'];
								} elseif (($value ['by_age_more_years'] == 1) && ($calAge > $value ['by_age_num_more_years'])) {
									$defaultRange = $value ['by_age_num_gret_years_lower_limit'] . "  -" . $value ['by_age_num_gret_years_upper_limit'];
									$defaultResultParam = $value ['by_age_num_gret_years_default_result'];
								} else {
									$defaultRange = $value ['by_age_between_years_lower_limit'] . " - " . $value ['by_age_between_years_upper_limit'];
									$defaultResultParam = $value ['by_age_between_years_default_result'];
								}
								$defaultResultParam = rtrim ( trim ( $defaultResultParam ), "-" );
							}
							// pr($value);//exit;
							if ($value ['by_gender_age'] == 'range') { // by Range
							                                           // $defaultRange = '> '.$value['by_range_less_than_limit']. ' ' .$value['by_range_less_than_interpretation'].'<br>< '.$value['by_range_greater_than_limit'].' '.$value['by_range_greater_than_interpretation'];
								$defaultRange .= ($value ['by_range_less_than_limit']) ? '< ' . $value ['by_range_less_than_limit'] : ' ';
								$defaultRange .= ($value ['by_range_less_than_interpretation']) ? ' - ' . $value ['by_range_less_than_interpretation'] . '<br>' : '<br>';
								$defaultRange .= ($value ['by_range_greater_than_limit']) ? '> ' . $value ['by_range_greater_than_limit'] : ' ';
								$defaultRange .= ($value ['by_range_greater_than_interpretation']) ? ' - ' . $value ['by_range_greater_than_interpretation'] . '<br>' : '<br>';
								$defaultRange .= ($value ['by_range_between_lower_limit']) ? $value ['by_range_between_lower_limit'] . ' - ' : ' ';
								$defaultRange .= ($value ['by_range_between_upper_limit']) ? $value ['by_range_between_upper_limit'] : ' ';
								$defaultRange .= ($value ['by_range_between_interpretation']) ? ' - ' . $value ['by_range_between_interpretation'] : '';
							}
							$defaultRangeBck = trim ( $defaultRange );
							$defaultRange = rtrim ( trim ( $defaultRange ), "-" );
						}
						?>
	
		<tr>

			<td width="" valign="middle" class="tdLabel" id="">
				<div>
				<?php
						if ($isPrinted) {
							echo "<i><b>" . $labCatValue ['category_name'] . "</b></i>";
							$isPrinted = 0;
							if ($labCatValue ['is_category']) {
								$isPrintedFirstTime = '<div style="padding-top:8px;">&nbsp;</div>';
								$isPrintedFirstTimeStyle = "padding-top:6px";
							}
						}
						?>
			</div>
				<div style="padding-left:20px;<?php echo $isPrintedFirstTimeStyle;?>">
			
			<?php
						// if($laboratoryName){ //laboratory name
			echo $this->Form->hidden ( '', array (
					'name' => "LaboratoryResult[$i][is_authenticate]",
					'value' => $subData ['Laboratory'] ['id'],
					'type' => 'text'
			) );
			
						echo $this->Form->hidden ( '', array (
								'name' => "LaboratoryResult[$i][laboratory_id]",
								'value' => $subData ['Laboratory'] ['id'],
								'type' => 'text' 
						) );
						echo $this->Form->hidden ( '', array (
								'name' => "LaboratoryResult[$i][patient_id]",
								'value' => $subData ['LaboratoryTestOrder'] ['patient_id'],
								'type' => 'text' 
						) );
						echo $this->Form->hidden ( '', array (
								'name' => "LaboratoryResult[$i][laboratory_test_order_id]",
								'value' => $subData ['LaboratoryTestOrder'] ['id'],
								'type' => 'text' 
						) );
						echo $this->Form->hidden ( '', array (
								'name' => "LaboratoryResult[$i][user_id]",
								'value' => $doctorData ['User'] ['id'],
								'type' => 'text' 
						) );
						echo $this->Form->hidden ( '', array (
								'name' => "LaboratoryResult[$i][create_time]",
								'value' => date ( "Y-m-d H:i:s" ),
								'type' => 'text' 
						) );
						echo $this->Form->hidden ( '', array (
								'name' => "LaboratoryResult[$i][id]",
								'value' => $subData ['LaboratoryResult'] ['id'],
								'type' => 'text'/* $subData['LaboratoryHl7Result'][$paraKey]['laboratory_result_id'] */) );
						echo $this->Form->hidden('', array('name'=>"LaboratoryResult[$i][is_authenticate]",'value'=>$subData ['LaboratoryResult'] ['is_authenticate'],'id'=>'isAuthenticate','class'=>'isAuthenticate'));
						echo $this->Form->hidden('', array('name'=>"LaboratoryResult[$i][report_date]",'value'=> $subData ['LaboratoryResult'] ['report_date'],'class'=>'reportDate'));
						echo $this->Form->hidden ( '', array (
								'name' => "LaboratoryResult[$i][op_name]",
								'value' => $doctorData ['User'] ['first_name'] . $doctorData ['User'] ['last_name'],
								'type' => 'text' 
						) );
						
						// }
						
						if ($labCatValue ['is_category']) {
							echo $value ['name']; // attribute name
						}
						echo $this->Form->hidden ( '', array (
								'name' => "LaboratoryHl7Result[$i][$j][laboratory_parameter_id]",
								'value' => $value ['id'],
								'type' => 'text' 
						) );
						echo $this->Form->hidden ( '', array (
								'name' => "LaboratoryHl7Result[$i][$j][laboratory_test_order_id]",
								'value' => $subData ['LaboratoryTestOrder'] ['id'],
								'type' => 'text' 
						) );
						echo $this->Form->hidden ( '', array (
								'name' => "LaboratoryHl7Result[$i][$j][laboratory_id]",
								'value' => $value ['laboratory_id'],
								'type' => 'text' 
						) );
						echo $this->Form->hidden ( '', array (
								'name' => "LaboratoryHl7Result[$i][$j][id]",
								'value' => $subData ['LaboratoryHl7Result'] [$paraKey] ['id'],
								'type' => 'text' 
						) )?>
			
			</div>
			</td>

			<td width="" valign="middle" class="tdLabel" id=""><div style="display: block;<?php echo $isPrintedFirstTimeStyle;?>" id="">
			<?php echo $isPrintedFirstTime;?>
				<?php
						$unitData = ($optUcums [$value ['unit']]) ? $optUcums [$value ['unit']] : $value ['unit_txt'];
						// echo $this->Form->hidden('',array('id'=>'attrName-'.$i._.$j,'class'=>'attrName','value'=>$value['name']));
						$className = $str = str_replace ( ' ', '_', $value ['name'] );
						$classNames = $str = str_replace ( '.', '_', $className );
						if ($value ['is_mandatory'] == '1') {
							$requiredClass = "validate[required,custom[mandatory-enter]]";
						} else {
							$requiredClass = "";
						}
						$isMultiple = false;
						if (empty ( $defaultResultParam )) {
							if ($value ['type'] == 'text') {
								if ($value ['is_multiple_options']) {
									$isMultiple = true;
									$defaultRange = '';
									$splitString = explode ( ",", $value ['parameter_text'] );
									$opArr = array ();
									foreach ( $splitString as $key => $val ) {
										$opArr [str_replace ( '"', "'", $val )] = str_replace ( '"', "'", $val );
									}
									$defaultResultParam = $value ['parameter_text'];
								} else {
									$defaultResultParam = $value ['parameter_text'];
								}
								// print_r($opArr);exit;
							}
						}
						// pr($subData['LaboratoryHl7Result']);exit;
						
						if ($isMultiple) {
							echo $this->Form->input ( '', array (
									'options' => $opArr,
									'empty' => 'Please Select',
									'div' => false,
									'name' => "LaboratoryHl7Result[$i][$j][result]",
									'value' => ($subData ['LaboratoryHl7Result'] [$paraKey] ['result']) ? $subData ['LaboratoryHl7Result'] [$paraKey] ['result'] : $defaultResultParam,
									'class' => 'formulaId_' . $value ["id"] . ' getBlurId getVal ' . $classNames . ' ' . $requiredClass,
									'type' => 'select',
									'label' => false,
									'id' => "result-" . $i . _ . $j,
									'autocomplete' => 'off',
									'style="100%"' 
							) );
							echo $this->Form->hidden ( '', array (
									'id' => "formulaCalc_" . $value ["id"],
									'name' => "LaboratoryHl7Result[$i][$j][formulaCalc]",
									'value' => $value ['formula'] 
							) );
						} else {
							$defaultRangeBck = explode ( " - ", $defaultRangeBck );
							if (($subData ['LaboratoryHl7Result'] [$paraKey] ['result'] < $defaultRangeBck [0]) || ($subData ['LaboratoryHl7Result'] [$paraKey] ['result'] > $defaultRangeBck [1]))
								$classNames .= ' errorAbnormal';
							echo $this->Form->input ( '', array (
									'div' => false,
									'name' => "LaboratoryHl7Result[$i][$j][result]",
									'value' => ($subData ['LaboratoryHl7Result'] [$paraKey] ['result']) ? $subData ['LaboratoryHl7Result'] [$paraKey] ['result'] : $defaultResultParam,
									'class' => 'formulaId_' . $value ["id"] . ' getBlurId getVal ' . $classNames . ' ' . $requiredClass,
									'type' => 'text',
									'label' => false,
									'style' => 'width:100px;',
									'id' => "result-" . $i . _ . $j,
									'autocomplete' => 'off' 
							) ) . ' ' . $unitData;
							echo $this->Form->hidden ( '', array (
									'id' => "formulaCalc_" . $value ["id"],
									'name' => "LaboratoryHl7Result[$i][$j][formulaCalc]",
									'value' => $value ['formula'] 
							) );
						}
						
						?> 
						<?php
						$prevResultsString = implode ( " | ", $prevResultArray [$value ['id']] );
						$prevResultsString = trim ( trim ( $prevResultsString ), "|" );
						if ($prevResultsString) {
							$prevResultsString = "<b>" . $prevResultsString . "</b>";
							?>
			
			<span style="float: right; padding-right: 200px">
			<?php
							echo $this->Html->image ( 'icons/laboratory_result_icon.png', array (
									'width' => '16',
									'height' => '16',
									'class' => 'tooltip',
									'title' => $prevResultsString 
							) );
							?>
			</span>
			<?php
						}
						$prevResultsString = '';
						?>
				</div></td>




			<td width="" valign="middle" class="tdLabel" id="" style="<?php echo $isPrintedFirstTimeStyle;?>">
			<?php echo $isPrintedFirstTime;?>
			<?php
						echo $defaultRange . ' ' . $unitData;
						echo $this->Form->hidden ( 'Laboratory.calcRange', array (
								'label' => false,
								'div' => false,
								'id' => 'calcRange-' . $i . _ . $j,
								'value' => $defaultRange 
						) );
						echo $this->Form->hidden ( '', array (
								'name' => "LaboratoryHl7Result[$i][$j][range]",
								'label' => false,
								'id' => 'range-' . $i . _ . $j,
								'value' => $defaultRange,
								'readonly' => 'readonly' 
						) );
						if ($value ['type'] != 'text')
							echo $this->Form->hidden ( 'abnormal_flagDisplay', array (
									'name' => "LaboratoryHl7Result[$i][$j][abnormal_flagDisplay]",
									'class' => '',
									'style' => 'width:150px; float:left;',
									'id' => 'abnormal_flagDisplay-' . $i . _ . $j,
									'autocomplete' => 'off' 
							) );
						echo $this->Form->hidden ( 'abnormal_flag', array (
								'name' => "LaboratoryHl7Result[$i][$j][abnormal_flag]",
								'id' => 'abnormal_flag-' . $i . _ . $j,
								'class' => 'abnormal_flag',
								'value' => $subData ['LaboratoryHl7Result'] [$paraKey] ['abnormal_flag'] 
						) );
						?>
			<?php echo $this->Form->hidden('',array('name'=>"LaboratoryHl7Result[$i][$j][is_authenticate]",'type'=>'text','label'=>false,'id'=>'is_authenticate-'.$i._.$j,'class'=>'is_authenticate_class','value'=>$subData['LaboratoryHl7Result'][$paraKey]['is_authenticate']))?>
		
			</td>

		</tr>
		<?php
						
						$laboratoryName = '';
						$isPrintedFirstTime = '';
						$defaultRange = '';
						$unitData = '';
						$j ++;
						unset ( $value ['id'] );
					} // End of Laboratory Parameter
				} // End of if
				?>
			
			<?php
			}
			// if($subData['Laboratory']['notes_display_text']){
			if ($subData ['LaboratoryResult'] ['text']) {
				$isOpinion = 'checked';
				$isOpinionDisplay = 'display:block';
				$isDisabledDisplay = '';
			} else {
				$isOpinion = '';
				$isOpinionDisplay = 'display:none';
				$isDisabledDisplay = 'disabled';
			}
			?>
				
				<tr>
			<td width="" valign="middle" class="tdLabel" id=""><b>
				<?php
			
			echo ($subData ['Laboratory'] ['notes_display_text']) ? $subData ['Laboratory'] ['notes_display_text'] : __ ( 'Comments' );
			echo $this->Form->input ( '', array (
					'checked' => $isOpinion,
					'name' => "LaboratoryResult[$i][is_opinion]",
					'value' => $subData ['Laboratory'] ['opinion'],
					'type' => 'checkbox',
					'div' => false,
					'label' => false,
					'style' => "margin-left:14px;",
					'id' => 'isOpinion_' . $subData ['Laboratory'] ['id'],
					'class' => 'isOpinion' 
			) );
			?></b></td>
			<td width="" valign="middle" class="tdLabel" id="" colspan="2">
				<?php
			echo $this->Form->input ( '', array (
					'disabled' => $isDisabledDisplay,
					'style' => $isOpinionDisplay,
					'rows' > '4',
					'columns' => '4',
					'name' => "LaboratoryResult[$i][text]",
					'value' => ($subData ['LaboratoryResult'] ['text']) ? $subData ['LaboratoryResult'] ['text'] : $subData ['Laboratory'] ['notes'],
					'type' => 'textarea',
					'div' => false,
					'label' => false,
					'id' => 'opinion_' . $subData ['Laboratory'] ['id'],
					'class' => 'opinion' 
			) );
			?>
				</td>
		</tr>
				<?php //}?>
		<?php
			
			$i ++;
		} // end of serology departent check
		?>
		<tr>
			<td
				style="border-bottom: 1px solid; line-height: 5px; padding-top: 10px"
				colspan="4">&nbsp;</td>
		</tr>
		<?php
	} // End of Laboratory Main Loop
	  // }else{	?>
<tr>
			<td colspan="8" align="center">	<?php	//echo __('There is no attributes');?></td>
		</tr>
		<?php
	// }
	?>
	<!-- Browse buton -->
		<tr>
			<td><?php
	foreach ( $dataLabImg as $temData ) {
		if ($temData ['PatientDocument'] ['filename']) {
			$id = $temData ['PatientDocument'] ['id'];
			echo "<p id=" . "icd_" . $id . " style='padding:0px 10px;'>";
			$replacedText = $temData ['PatientDocument'] ['filename'];
			echo $this->Html->link ( $replacedText, '/uploads/laboratory/' . $temData ['PatientDocument'] ['filename'], array (
					'escape' => false,
					'target' => '__blank',
					'style' => 'text-decoration:underline;' 
			) );
			echo $this->Html->link ( $this->Html->image ( '/img/icons/cross.png' ), array (
					'action' => 'delete_report',
					$temData ['PatientDocument'] ['patient_id'],
					$id,
					$orderId 
			), array (
					'escape' => false,
					"align" => "right",
					"id" => "$id",
					"title" => "Remove",
					"style" => "cursor: pointer;",
					"alt" => "Remove",
					"class" => "radio_eraser" 
			), 'Are you sure ?' );
			echo "</p>";
		}
	}
	?>            
			</td>
		</tr>
		<tr>
			<td>
				<table id='addTr'>
					<tr>
						<td>
							<?php echo $this->Form->input('',array('name'=>'data[PatientDocument][file_name][]','type'=>'file','class' => 'browse','id'=>'browse_1'));?>
						</td>

					</tr>
				</table>

			</td>
		</tr>
		<tr>
			<td><input type="button" class="grayBtn" id="addButton"
				value="Add more"> <input type="button" class="grayBtn"
				id="removeButton" value="Remove" style="display: none;"></td>
		</tr>
	</table>

	<!-- Non Histopathology Test ends -->

<?php
}
if ($getPanelSubLab ['0'] ['Laboratory'] ['lab_type'] == 2) {
	?>

<!--  Histopathology Test start -->
<?php
	
	foreach ( $getPanelSubLab as $keyHisto => $histoData ) {
		
		$labType = $histoData ['Laboratory'] ['lab_type']?>
<div class="inner_title">
		<h3>
		<?php echo __('Service Request Search', true); ?>
	</h3>
	</div>

	<div class="tabs">
		<!-- Navigation header -->
		<ul class="tab-links">
	    	<?php
		
		$count = 1;
		foreach ( $histoData ['LaboratoryParameter'] as $keyParas => $tab ) {
			if ($count == 1) {
				$class = "active";
			} else {
				$class = "";
			}
			?>
	        <?php //foreach ($result['LaboratoryParameter'] as $keyParas => $tab){?>
	        <li class="<?php echo $class; ?>"><a
				href="#tab<?php echo $count;?>">
	        		<?php echo $tab['name']; //for displaying the tab or attribute?>	
	        	</a></li>
	        <?php //}?>
	   		<?php
			
			$count = $count + 1;
		}
		?> 
	    </ul>
		<!-- Navigation header End -->
 	
 	
	<?php
		// echo $this->Form->create('',array('id'=>'Save-Form'));
		echo $this->Form->create ( 'LaboratoryResult', array (
				'type' => 'file',
				'id' => 'labfrm',
				'inputDefaults' => array (
						'label' => false,
						'legend' => false,
						'fieldset' => false 
				) 
		) );
		?>
		<?php
		
		if (! empty ( $authUser )) { // $authUser = all uathenticated usesr
			$login_user = $this->Session->read ( 'userid' ); // logined user
			if (in_array ( $login_user, $authUser )) {
				$disabled = false;
			} else {
				$disabled = true;
			}
		}
		?>
	
		<?php echo $this->Form->input('LaboratoryResult.is_authenticate',array('type'=>'checkbox','div'=>false,'label'=>false,'style'=>"margin-left:50px;",'disabled'=>$disabled,'checked'=>$histoData['LaboratoryResult']['is_authenticate']));?> Authenticated Result
 	 <div class="tab-content">
        <?php
		
		$count = 1;
		foreach ( $histoData ['LaboratoryParameter'] as $keyParas => $tab ) {
			$histoResult = $histoData ['LaboratoryHl7Result'] [$keyParas];
			// debug($histoResult);
			?>
        		
	    	<?php if($keyParas==0) { $class = "active"; } else { $class = "";} ?>
        	<?php $id = $tab['id'];?>
	        <div id="tab<?php echo $count;?>"
				class="tab <?php echo $class; ?>">
	        	<?php
			
			echo $this->Form->hidden ( 'lab_type', array (
					'id' => 'lab_type',
					'type' => 'text',
					'value' => $labType 
			) );
			echo $this->Form->hidden ( 'laboratory_id', array (
					'id' => 'laboratory_id',
					'type' => 'text',
					'value' => $tab ['laboratory_id'] 
			) );
			echo $this->Form->hidden ( 'laboratory_test_order_id', array (
					'id' => 'laboratory_test_order_id',
					'type' => 'text',
					'value' => $histoData ['LaboratoryTestOrder'] ['patient_id'] 
			) );
			echo $this->Form->hidden ( 'patient_id', array (
					'id' => 'patient_id',
					'type' => 'text',
					'value' => $histoData ['LaboratoryTestOrder'] ['patient_id'] 
			) );
			
			echo $this->Form->hidden ( 'LaboratoryResult.id', array (
					'id' => 'id',
					'type' => 'text',
					'value' => $histoData ['LaboratoryResult'] ['id'] 
			) );
			
			echo $this->Form->hidden ( 'laboratory_test_order_id', array (
					'id' => 'laboratory_test_order_id',
					'type' => 'text',
					'value' => $this->params->query ['testOrderId'] 
			) );
			echo $this->Form->hidden ( '', array (
					'name' => "data[LaboratoryHl7Result][$id]",
					'value' => $histoResult ['id'] 
			) );
			echo $this->Form->textarea ( '', array (
					'value' => ($histoResult ['observations']) ? $histoResult ['observations'] : $tab ['parameter_text_histo'],
					'name' => "data[LaboratoryParameter][$id]",
					'class' => 'ckeditor' 
			) );
			?> 
	        </div>
	    	<?php $count = $count+1; } ?>
	 </div>
	 
		 <?php echo $this->Form->end();?>
 </div>

<?php
	} // end of foreach
}
?>  

<div class="clr ht5"></div>

	<table align="center">
		<tr>
			<td>
			<?php
			echo $this->Form->submit ( __ ( 'Save' ), array (
					'id' => 'save',
					'escape' => false,
					'class' => 'blueBtn',
					'label' => false,
					'div' => false,
					'error' => false 
			) ) . "&nbsp";
			// echo $this->Html->link('Preview',array('controller'=>'new_laboratories','action'=>'printLab','?'=>array('testOrderId'=> $orderId,'from'=>'Preview')), array('escape' => false,'class'=>'blueBtn','id'=>'Preview'))
			// ."&nbsp";
			echo $this->Html->link ( 'Back', array (
					'controller' => 'NewLaboratories',
					'action' => 'index',
					1 
			), array (
					'class' => 'blueBtn',
					'div' => false,
					'label' => false 
			) ) . "&nbsp";
			echo $this->Html->link ( __ ( 'Preview & Print' ), 'javascript:void(0)', array (
					'id' => 'print',
					'escape' => false,
					'class' => 'blueBtn' 
			) ) . "&nbsp";
			echo $this->Html->link ( 'Download Files', array (
					'controller' => 'new_laboratories',
					'action' => 'download',
					$getPanelSubLab ['0'] ['LaboratoryTestOrder'] ['patient_id'] 
			), array (
					'class' => 'blueBtn',
					'div' => false,
					'label' => false 
			) );
			?>	
		</td>
		</tr>
	</table>

	<div class="clr ht5"></div>
</div>

<!--  Histopathology Test ends -->


<!--  <input class="blueBtn" type=submit value="Submit" name="Submit" style="float:right; margin-top:10px;">-->
<?php //echo $this->Html->link('Back',array('controller'=>'new_laboratories','action'=>'index'),array('class'=>'blueBtn','div'=>false,'label'=>false,'style'=>'float:right',))."&nbsp";?>


<script>
	var formElementIds = new Array();
	jQuery(document).ready(function() {
		if('<?php echo empty ($getPanelSubLab[0]['LaboratoryResult']['report_date']) || $getPanelSubLab[0]['LaboratoryResult']['report_date']=='0000-00-00 00:00:00'?>'){
			 $("#report_date").val($.datepicker.formatDate("dd/mm/yy HH:II:SS", new Date()));
			 $(".reportDate").val($.datepicker.formatDate("dd/mm/yy HH:II:SS", new Date()));
		}
	        $("#report_date").datepicker({
	            showOn: "button",
	            buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	            buttonImageOnly: true,
	            changeMonth: true,
	            changeYear: true,
	            changeTime: true,
	            showTime: true,
	            yearRange: '1950',
	            dateFormat: '<?php echo $this->General->GeneralDate('HH:II:SS');?>'
	        });

	        $("#report_date").change(function(){
				var reportDate = $(this).val();
				$(".reportDate").val(reportDate);

		    });

	        
		$('.tooltip').tooltipster({
	 		interactive:true,
	 		position:"right", 
	 	});
		jQuery("#labfrm").validationEngine();
	    jQuery('.tabs .tab-links a').on('click', function(e)  {
	        var currentAttrValue = jQuery(this).attr('href');
	        
	        // Show/Hide Tabs
	        jQuery('.tabs ' + currentAttrValue).show().siblings().hide();
	 
	        // Change/remove current tab to active
	        jQuery(this).parent('li').addClass('active').siblings().removeClass('active');
	        e.preventDefault();
	    });
	    
	    $("form :input").each(function(){
		    if($( "#"+$(this).attr('id') ).hasClass( "getVal" )){
	    		formElementIds.push($(this).attr('id'));
		    }
	    });
	});

	$("#save").click(function(){
		//var val = $("#forChk").val();
		//if(val == '1'){
		//alert('hi');
		
			$("#labfrm").submit();
		//}else{
		//	return false;
		//}
	});
</script>
<!-- /*change*/ -->
<script>
		var globalTrigger = '';  
		var tabIndex = 1;
		/*$('.getBlurId').change(function(){
			if(globalTrigger){
				var getId = globalTrigger;
			}else{
				var getId = $(this).attr('id');
			}
			
			$( "#"+getId+"" ).on('change',function() {
				//alert('gulshan');
					var idValue = getId.split("-"); 
				    var getResult=$("#"+getId+"").val();
					if(getResult==''){
						$("#abnormal_flag-"+idValue[1]).val("");
						 $("#abnormal_flagDisplay-"+idValue[1]).val("");
					}else{
					    var rangeValue=$('#range-'+idValue[1]+'').val();
					     rangeValue=rangeValue.split("-"); 
					    var lowerLimtRange=rangeValue['0'];
					    var upperLimtRange=rangeValue['1'];
					    $("#abnormal_flagDisplay-"+idValue[1]).removeClass();
					  		if(parseInt(getResult) < parseInt(lowerLimtRange)){
								var tenPerBelow= Math.round((100-(getResult/lowerLimtRange)*100));
						 		if((tenPerBelow<=10) &&(tenPerBelow>=1)){
									// $("#abnormal_flagDisplay-"+idValue[1]).css("color", "#2F72FF");
			
									 $("#abnormal_flagDisplay-"+idValue[1]).addClass('orange');
									 // alert("#abnormal_flagDisplay_"+idValue[2]);
									 $("#abnormal_flagDisplay-"+idValue[1]).val("Below low normal");
							 		 $("#abnormal_flag-"+idValue[1]).val("L");
								 } 
								 if((tenPerBelow<=20) && (tenPerBelow >10)){
									// $("#abnormal_flagDisplay-"+idValue[1]).css("color", "#2F72FF");
									 $("#abnormal_flagDisplay-"+idValue[1]).addClass('orange');
									 $("#abnormal_flagDisplay-"+idValue[1]).val('Below lower panic limits');
									 $("#abnormal_flag-"+idValue[1]).val("LL");
						 		}
						 		if(tenPerBelow >=30){
									 //$("#abnormal_flagDisplay-"+idValue[1]).css("color", "#2F72FF");
									 $("#abnormal_flagDisplay-"+idValue[1]).addClass('orange');
									 $("#abnormal_flagDisplay-"+idValue[1]).val('Below absolute low-off instrument scale');
							 		 $("#abnormal_flag-"+idValue[1]).val("<");
								 }
						 		tenPerBelow='';
					 	 }
					  if(parseInt(getResult) > parseInt(upperLimtRange)){
						  var tenPerAbove= Math.round((100-(upperLimtRange/getResult)*100));
							 if((tenPerAbove<=10) &&(tenPerAbove>=1)){
								 //$("#abnormal_flagDisplay-"+idValue[1]).css("color", "#FF803E");	
								 $("#abnormal_flagDisplay-"+idValue[1]).addClass('red');
								 $("#abnormal_flagDisplay-"+idValue[1]).val('Above high normal');
								 $("#abnormal_flag-"+idValue[1]).val("H");
							 } 
							 if((tenPerAbove<=20) && (tenPerAbove >10)){
								 //$("#abnormal_flagDisplay-"+idValue[1]).css("color", "#F90223");
								 $("#abnormal_flagDisplay-"+idValue[1]).addClass('red');
								 $("#abnormal_flagDisplay-"+idValue[1]).val('Above upper panic limits');
								 $("#abnormal_flag-"+idValue[1]).val("HH");
							 }
							 if(tenPerAbove >=30){
								// $("#abnormal_flagDisplay-"+idValue[1]).css("color", "#F90223");
								$("#abnormal_flagDisplay-"+idValue[1]).addClass('red');
								$("#abnormal_flagDisplay-"+idValue[1]).val('Above absolute high-off instrument scale');
								 $("#abnormal_flag-"+idValue[1]).val(">");
							 }
							 tenPerBelow='';
					  }
					  if((parseInt(getResult) >= parseInt(lowerLimtRange)) && (parseInt(getResult) <= parseInt(upperLimtRange)) ){
						  $("#abnormal_flagDisplay-"+idValue[1]).addClass('green');
						  $("#abnormal_flagDisplay-"+idValue[1]).val('Normal');
						  
							 $("#abnormal_flag-"+idValue[1]).val("N");
					  }
					  tenPerBelow='';
					}
				 });
			globalTrigger="";
		});*/

		
$("#isAuthenticateChecked").change(function(){	//if Authenticate result checked is true, set hidden value of is_authenticate to 1
	if($(this).is(':checked',true)){
		$(".isAuthenticate").val(1);
		$(".is_authenticate_class").val(1);
	}else{
		$(".isAuthenticate").val('');
		$(".is_authenticate_class").val('');
	}
});

$(".isOpinion").change(function(){	
	var currId = $(this).attr('id');
	currId = currId.split("_");
	if($(this).is(':checked',true)){
		$("#opinion_"+currId[1]).attr('disabled',false);
		$("#opinion_"+currId[1]).delay(400).fadeIn(400);
		
	}else{
		$("#opinion_"+currId[1]).attr('disabled',true);
		$("#opinion_"+currId[1]).delay(400).fadeOut(400);	
		}
});

$(document).ready(function(){
	var idd = '';
	
	 $('.abnormal_flag').each(function() {
		 idd = $(this).attr('id');
		 new_id = idd.split("-");
		 $("#abnormal_flagDisplay-"+new_id[1]).val(getAbnormalField(this.value));	//DISLPLAY TEXT
		 $("#abnormal_flagDisplay-"+new_id[1]).addClass(getColor(this.value));		//ADD FONT COLOR
	 });
	 var valData = '';
	 $('.is_authenticate_class').each(function(){
			val = $(this).val();
			if(val){
				valData = 1;
				return false;
			}
	 });
	 if(valData){
			$("#isAuthenticateChecked").attr('checked', true);
		}else{
			$("#isAuthenticateChecked").attr('checked', false);
		}
});

function getAbnormalField(symbol)
{
	var msg = '';
	switch(symbol)
	{
		case "L": 	msg = "Below low normal";	break;
		case "LL": 	msg = "Below lower panic limits"; break;
		case "<":	msg = "Below absolute low-off instrument scale"; break;
		case "H":	msg = "Above high normal"; break;
		case "HH": 	msg = "Above upper panic limits"; break;
		case ">":	msg = "Above absolute high-off instrument scale"; break;
		case "N": 	msg = "Normal"; break;		 
	}
	return msg;
}

function getColor(symbol)
{
	var color = '';
	switch(symbol)
	{
		case "L": case "LL": case "<":	
			color = "orange"; break;
		case "H": case "HH": case ">":	
			color = "red"; break;
		case "N": 
			color = "green"; break;		 
	}
	return color;
}
	
	var PCV = '', RCC = '', HB = '';
	refund_amount = ($('#refund_amount').val() != '') ? parseInt($("#refund_amount").val()) : 0;
	
	/*$(".getVal").blur(function(){

		clas = $(this).attr('class');
		var new_class  = clas.split(' ');	//splitt by space
		//alert(new_class[3]);
		if(new_class[2] == "Red_Cell_Count"){
			
			RCC = $(this).val();
			//RCC = parseFloat(RCC);
			//RCC= RCC.toFixed(2);
			$(".Mean_Cell_Volume").val("");
			$(".Mean_Cell_Hemoglobin ").val("");
		}
		if(new_class[2] == "Packed_Cell_Volume"){
			PCV = $(this).val();
			//PCV = parseFloat(PCV);
			//PCV= PCV.toFixed(2);
			$(".Mean_Cell_Volume").val("");
			$(".Mean_Cell_He_Concentration").val("");
		}
		if(new_class[2] == "Haemoglobin"){
			HB = $(this).val();
			//HB = parseFloat(HB);
			//HB= HB.toFixed(2);
			$(".Mean_Cell_Haemoglobin").val("");
			$(".Mean_Cell_He_Concentration").val("");
		}
	// calling
		if(PCV!='' && RCC!=''){
			getMCV(PCV,RCC);
		}
		if(RCC!='' && HB!=''){
			getMCH(RCC,HB);
		}
		if(HB!='' && PCV!=''){
			getMCHP(PCV,HB);
		}
	});*/

	function getMCV(PCV,RCC){
		MCV = (PCV/RCC)*10;
		if(MCV){
			$(".Mean_Cell_Volume").val("");

			var getId=$(".Mean_Cell_Volume").attr('id');
			globalTrigger = getId;
			MCV = parseFloat(MCV);
			MCV= MCV.toFixed(2);
			$(".Mean_Cell_Volume").val(MCV);
			$(".getBlurId").trigger('change');
		}
	}

	function getMCH(RCC,HB){
		MCH = (HB*10)/RCC;
		if(MCH){
			$(".Mean_Cell_Haemoglobin").val("");

			var getId=$(".Mean_Cell_Haemoglobin").attr('id');
			globalTrigger = getId;
			MCH = parseFloat(MCH);
			MCH= MCH.toFixed(2);
			$(".Mean_Cell_Haemoglobin").val(MCH);
			$(".getBlurId").trigger('change');
		}
	}
	function getMCHP(PCV,HB){
		MCHP = (HB/PCV)*100;
		if(MCHP){
			$(".Mean_Cell_He_Concentration").val("");

			var getId=$(".Mean_Cell_He_Concentration").attr('id');
			globalTrigger = getId;
			MCHP = parseFloat(MCHP);
			MCHP= MCHP.toFixed(2);
			$(".Mean_Cell_He_Concentration").val(MCHP);
			$(".getBlurId").trigger('change');
		}
	}
	
	$('#print').click(function(){
		var validatePerson = jQuery("#labfrm").validationEngine('validate'); 
	 	if(!validatePerson){
		 	return false;
		}
		  	data = $('#labfrm').serialize();
				AjaxUrl = "<?php echo $this->Html->url(array('controller' => 'new_laboratories', 'action' => 'entryMode'));?>";
				$.ajax({
					type : "POST",
					data : data,
					url  : AjaxUrl,
					beforeSend:function(data){
						$('#busy-indicator').show();
					},
					success:function(data){
						$('#busy-indicator').hide();
				var printUrl='<?php echo $this->Html->url(array('controller' => 'new_laboratories', 'action' => 'printLab','?'=>array('testOrderId'=>$orderId)));?>';
				var entryUrl='<?php echo $this->Html->url(array('controller' => 'new_laboratories', 'action' => 'entryMode','?'=>array('testOrderId'=>$orderId)));?>';
				var openWin =window.open(printUrl, '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');
				window.location.href =entryUrl;
				}	
				}); 
	});
	
	$('#Preview').click(function(){
		$.fancybox({
			
			'width' : '100%',
			'height' : '100%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'hideOnOverlayClick':false,
			'showCloseButton':true,
			
			'href' : "<?php echo $this->Html->url(array('controller' => 'new_laboratories', 'action' => 'printLab','?'=>array('testOrderId'=>$orderId,'from'=>'Preview')));?>",
					
			
		});
	});
	var counter = 2;
	$('#addButton').click(function(){
		$("#addTr")
		.append($('<tr>').attr({'id':'newBrowseRow_'+counter,'class':'newBrowseRow'})
    		.append($('<td>').append($('<input>').attr({'id':'browse_'+counter,'class':'browse','type':'file','name':'data[PatientDocument][file_name][]'})))
    		.append($('<td>').append($('<img>').attr('src',"<?php echo $this->webroot ?>theme/Black/img/cross.png")
					.attr({'class':'removeButton','id':'removeButton_'+counter,'title':'Remove current row'}).css('float','right')))
			)	
			counter++;
		
	});
	$(document).on('click','.removeButton', function() {
		currentId=$(this).attr('id');
		splitedId=currentId.split('_');
		ID=splitedId['1'];
		$("#newBrowseRow_"+ID).remove();
		 
 });
	$(".getBlurId").keydown(
		    function(e)
		    {    
			    var currEleId = $(this).attr('id');
			    var key = formElementIds.getKey(currEleId);
		        if (e.keyCode == 40) {
		        	key++;
		        	if($("#"+formElementIds[key]) !== undefined)
		        		$("#"+formElementIds[key]).focus();
		        		/* $(".getBlurId").trigger("focus"); */
		   		}
		        if (e.keyCode == 38) {   
		        	key--;   
		        	if($("#"+formElementIds[key]) !== undefined)
		        		$("#"+formElementIds[key]).focus();
		        		/* $(".getBlurId").trigger("focus"); */
		   		}
		    }
		);

	
	/* $(".getBlurId")
    	.focus(function () { $(this).select(); } ); */
    	
	function calculateResult(id){
    		var className = $("#"+id).attr('class');    
    		className = className.split(" ");
    		id = className[0];
    		id = id.split("_");
    		var isNotBlank = true;
    		var formula = $("#formulaCalc_"+id[1]).val();
    		if(formula !="" && formula !== undefined){
    			var formulaText = formula.split(" ");
    			var newFormula = '';
    			jQuery.each( formulaText, function( i, val ) {
    				var numRegex = "{{[0-9]";
    				var formulaRegex = "{{.formulaId";
    				var operatorRegex = "{{[()+*/.-]}}";
    				var re = new RegExp(numRegex, 'g');
    				val = val.trim();
    				if(val.match(re)){
    					val = val.replace(new RegExp("{{", 'g'), "Number(");
    					val = val.replace(new RegExp("}}", 'g'), ")");
    				}

    				var re = new RegExp(operatorRegex, 'g');
    				if(val.match(re)){
    					val = val.replace(new RegExp("{{", 'g'), "");
    					val = val.replace(new RegExp("}}", 'g'), "");
    				}
    				
    				var re = new RegExp(formulaRegex, 'g');
    				if(val.match(re)){
    					val = val.replace(new RegExp("{{", 'g'), "Number($('");
    					val = val.replace(new RegExp("}}", 'g'), "').val())");
    					var valNew = val.replace(new RegExp("Number", 'g'), "");
    					if(eval(valNew) == '' || eval(valNew) === undefined){
    						val = val.replace(new RegExp("Number"+valNew, 'g'), valNew);
    						isNotBlank = false;
    					}
    					
    				} 
    				newFormula += val;
    			});

    			if(isNotBlank){
        			var calc = eval(newFormula);
    				$(".formulaId_"+id[1]).val(calc.toFixed(2));
    			}else{
    				$(".formulaId_"+id[1]).val("");
    			}
    		}
    }
	/* $(".getBlurId").blur(function(e){
		calculateResult($(this).attr('id'));
	}); */

    $(".getBlurId").blur(function(e){
	    $( ".getBlurId" ).each(function( index ) {
	    	calculateResult($(this).attr('id'));

	    	var id = $(this).attr("id");
			id = id.split("-");
	    	var ranges = $("#calcRange-"+id[1]).val();
	    	if(ranges != '' && ranges !== undefined){
	    		ranges = ranges.split(" - ");
		    	var value = $(this).val();
		    	var lowerRange = ranges[0].trim();
		    	var upperRange = ranges[1].trim();
		    	if((lowerRange !== undefined && lowerRange != '') && (upperRange !== undefined && upperRange != '')){
		    		value = Number(value);
		    		if(value < lowerRange || value >  upperRange){
						$(this).addClass("errorAbnormal");
					}else{
						$(this).removeClass("errorAbnormal");
					}
		    	} 
		    	
	    	}
		});
    });		
	 //$(this).attr('tabindex', n++);

</script>
