<div class="inner_title">
	<h3>Lab Result</h3>
</div>


<div class="clr ht5"></div>
<?php
echo $this->element ( 'patient_information' );
echo $this->Form->create ( 'LaboratoryResult', array (
		'url' => array (
				'controller' => 'laboratories',
				'action' => 'lab_result',
				$patient_id 
		),
		'id' => 'labResultfrm',
		'inputDefaults' => array (
				'label' => false,
				'div' => false,
				'error' => false 
		) 
) );

// echo $this->Form->hidden('laboratory_categories_id',array('value'=>$this->data['Laboratory']['category_id']));
?>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td height=lab_result "30" class="tdLabel2">Specimen ID:  <?php echo strtoupper($token['LaboratoryToken']['sp_id']); ?></td>
		<td class="tdLabel2">Accession ID:  <?php echo strtoupper($token['LaboratoryToken']['ac_id']);?></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>
<div class="clr ht5"></div>
<table width="100%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm">

	<tr>
		<th>&nbsp;</th>
		<th width="250" style="text-align: center;"><strong>VALUE</strong></th>
		<th width="120" style="text-align: center;"><strong>NORMAL RANGE</strong></th>
		<th width="90" style="text-align: center;"><strong>UNITS</strong></th>
		<th width="90" style="text-align: center;"><strong>STATUS</strong></th>
	</tr>
	                     	<?php
																							// pr($test_atrributes);
																							// loop through all attributes of selected test
																							
																							$statusArr = array (
																									'normal' => 'Normal',
																									'abnormal' => 'Abnormal' 
																							);
																							if (isset ( $test_atrributes )) {
																								
																								foreach ( $test_atrributes as $k => $data ) {
																									$parameterData = $data ['LaboratoryParameter'];
																									$catData = $data ['LaboratoryCategory'];
																									$resultData = $data ['LaboratoryResult'];
																									
																									echo "<tr><th>";
																									echo strtoupper ( $catData ['category_name'] );
																									$catId = $catData ['id'];
																									
																									echo "</th></tr>";
																									foreach ( $parameterData as $key => $dataKey ) {
																										echo "<tr>";
																										echo "<td>" . $dataKey ['name'] . "</td>";
																										$resultId = isset ( $resultData [$key] ['id'] ) ? $resultData [$key] ['id'] : '';
																										$resultText = isset ( $resultData [$key] ['id'] ) ? $resultData [$key] ['text'] : '';
																										$resultValue = isset ( $resultData [$key] ['id'] ) ? $resultData [$key] ['value'] : '';
																										$resultStatus = isset ( $resultData [$key] ['id'] ) ? $resultData [$key] ['status'] : '';
																										
																										if ($resultStatus == 'ABNORMAL') {
																											$color = 'red';
																										} else {
																											$color = '';
																										}
																										
																										echo $this->Form->hidden ( '', array (
																												'name' => "data[LaboratoryResult][$catId][$key][laboratory_categories_id]",
																												'value' => $catId 
																										) );
																										echo $this->Form->hidden ( '', array (
																												'name' => "data[LaboratoryResult][$catId][$key][id]",
																												'value' => $resultId 
																										) );
																										echo $this->Form->hidden ( '', array (
																												'name' => "data[LaboratoryResult][$catId][$key][laboratory_id]",
																												'value' => $lab_id 
																										) );
																										echo $this->Form->hidden ( '', array (
																												'name' => "data[LaboratoryResult][$catId][$key][laboratory_parameter_id]",
																												'value' => $dataKey ['id'] 
																										) );
																										
																										if ($dataKey ['type'] == 'text') {
																											echo "<td colspan='4'>";
																											echo $resultText;
																											echo "</td>";
																										} else {
																											if ($dataKey ['by_gender_age'] == 'gender') { // by gender
																												if (strtolower ( $sex ) == 'male') {
																													$lower = $dataKey ['by_gender_male_lower_limit'];
																													$upper = $dataKey ['by_gender_male_upper_limit'];
																												} else { // female
																													$lower = $dataKey ['by_gender_female_lower_limit'];
																													$upper = $dataKey ['by_gender_female_upper_limit'];
																												}
																											} else { // by age
																												$foundRange = false;
																												if ($dataKey ['by_age_less_years'] == 1) {
																													if ($age < $dataKey ['by_age_num_less_years']) {
																														$lower = $dataKey ['by_age_num_less_years_lower_limit'];
																														$upper = $dataKey ['by_age_num_less_years_upper_limit'];
																														$foundRange = true;
																													}
																												}
																												if ($dataKey ['by_age_more_years'] == 1 && ! ($foundRange)) {
																													if ($age > $dataKey ['by_age_num_more_years']) {
																														$lower = $dataKey ['by_age_num_gret_years_lower_limit'];
																														$upper = $dataKey ['by_age_num_gret_years_upper_limit'];
																														$foundRange = true;
																													}
																												}
																												if ($dataKey ['by_age_between_years'] == 1 && ! ($foundRange)) {
																													if (($age >= $dataKey ['by_age_between_num_less_years']) && ($age <= $dataKey ['by_age_between_num_gret_years'])) {
																														$lower = $dataKey ['by_age_between_years_lower_limit'];
																														$upper = $dataKey ['by_age_between_years_upper_limit'];
																														$foundRange = true;
																													}
																												}
																											}
																											echo "<td style='color:$color'>";
																											echo $resultValue;
																											echo "</td>";
																											echo "<td style='text-align:center;'>" . $lower . " – " . $upper . "</td>";
																											echo $this->Form->hidden ( '', array (
																													'name' => "data[LaboratoryResult][$catId][$key][range]",
																													'value' => $lower . "-" . $upper 
																											) );
																											echo "<td style='text-align:center;'>" . $dataKey ['unit'] . "</td>";
																											echo "<td style='text-align:center;color:$color'>";
																											echo $resultStatus;
																											echo "</td>";
																										}
																										echo "</tr>";
																									}
																								}
																							}
																							?> 
	                   </table>
<!-- billing activity form end here -->
<div>&nbsp;</div>
<div class="btns">
               			<?php
																		echo $this->Html->link ( __ ( 'Cancel' ), array (
																				'controller' => 'laboratories',
																				'action' => 'lab_test_list',
																				$patient_id 
																		), array (
																				'escape' => false,
																				'class' => 'grayBtn' 
																		) );
																		?>
						&nbsp;&nbsp;<input type="Submit" value="Save" class="blueBtn">

</div>
<?php echo $this->Form->end();	 ?>


<script>
 		jQuery(document).ready(function(){
			// binds form submission and fields to the validation engine
			jQuery("#labResultfrm").validationEngine();		 
		});
 </script>