<?php if(!empty($getsubData)){?>
<table border="" class="" cellpadding="0" cellspacing="0" width="100%"
	style="text-align: center;">
	<tr class="row_title">
		<td class="table_cell" align="left" colspan='8'><strong><?php echo __($labName); ?>
		</strong></td>
	</tr>
	<tr class="row_title">
		<td class="table_cell" align="left"><strong><?php echo __('Test Name'); ?>
		</strong></td>
		<td class="table_cell" align="left"><strong><?php echo  __('Code'); ?>
		</strong></td>
		<td class="table_cell" align="left"><strong><?php echo  __('Value'); ?>
		</strong></td>
		<td class="table_cell" align="left" width="10%"><strong><?php echo  __('Unit of measure'); ?>
		</strong></td>
		<td class="table_cell" align="left"><strong><?php echo  __('Reference Range'); ?>
		</strong></td>
		<td class="table_cell" align="left"><strong><?php echo  __('Flag'); ?>
		</strong></td>
		<td class="table_cell" align="left"><strong><?php echo  __('Performed On'); ?>
		</strong></td>
		<!-- <td class="table_cell" align="left"><strong><?php echo  __('Graph'); ?>
		</strong></td> -->
		<!--<td class="table_cell" align="left"><strong><?php echo  __('View Note'); ?>
		</strong></td>-->
		<!-- <td class="table_cell" align="left"><strong><?php echo  __('History'); ?>
		</strong></td>  -->
		<td class="table_cell" align="left"><strong><?php echo  __('Status'); ?>
		</strong></td>

	</tr>
	<?php foreach ($getsubData as $subData){?>
	<tr class="">

		<td class="table_cell" align="left"><strong><?php echo __($subData['Laboratory']['name']); ?>
		</strong></td>
		<td class="table_cell" align="left"><strong><?php echo  __($subData['Laboratory']['lonic_code']); ?>
		</strong></td>
		<td class="table_cell" align="left"><strong><?php echo  __($subData['LaboratoryHl7Result']['result']); ?>
		</strong></td>
		<td class="table_cell" align="left" width="10%"><strong><?php echo  __($subData['LaboratoryHl7Result']['uom']); ?>
		</strong></td>
		<td class="table_cell" align="left"><strong><?php echo  __($subData['LaboratoryHl7Result']['range']); ?>
		</strong></td>
		<?php
		
		if (! empty ( $subData ['LaboratoryHl7Result'] ['abnormal_flag'] )) {
			
			if ($subData ['LaboratoryHl7Result'] ['abnormal_flag'] == ">") {
				$flag = "Above absolute high-off instrument scale";
				$color = "red";
			}
			if ($subData ['LaboratoryHl7Result'] ['abnormal_flag'] == "HH") {
				$flag = "Above upper panic limits";
				$color = "FF803E";
			}
			if ($subData ['LaboratoryHl7Result'] ['abnormal_flag'] == "H") {
				$flag = "Above high normal";
				$color = "FF803E";
			}
			if ($subData ['LaboratoryHl7Result'] ['abnormal_flag'] == "<") {
				$flag = "Below absolute low-off instrument scale";
				$color = "#2F72FF";
			}
			if ($subData ['LaboratoryHl7Result'] ['abnormal_flag'] == "LL") {
				$flag = "Below lower panic limits";
				$color = "#2F72FF";
			}
			if ($subData ['LaboratoryHl7Result'] ['abnormal_flag'] == "L") {
				$flag = "Below low normal";
				$color = "#2F72FF";
			}
			if ($subData ['LaboratoryHl7Result'] ['abnormal_flag'] == "N") {
				$flag = "Normal";
				$color = "#FFF";
			}
		} else {
			echo __ ( 'Pending' );
		}
		?>
		<td class="table_cell" align="left" style="color:<?php echo $color ?>"><strong><?php echo  __($flag); ?>
		</strong></td>
		<td class="table_cell" align="left"><strong><?php echo  __($subData['LaboratoryHl7Result']['date_time_of_observation']); ?>
		</strong></td>
		<!-- <td class="table_cell" align="left"><strong><?php echo  __('Graph'); ?>
		</strong></td> -->
		<!--<td class="table_cell" align="left"><strong><?php echo  __('View Note'); ?>
		</strong></td>-->
		<!-- <td class="table_cell" align="left"><strong><?php echo  __('History'); ?>
		</strong></td>  -->

		</strong>
		</td>
		<?php
		
		if (! empty ( $subData ['LaboratoryHl7Result'] ['status'] )) {
			
			if ($subData ['LaboratoryHl7Result'] ['status'] == "C")
				$status_result = "Record coming over is a correction and thus replaces a final result";
			if ($subData ['LaboratoryHl7Result'] ['status'] == "D")
				$status_result = "Deletes the OBX record";
			if ($subData ['LaboratoryHl7Result'] ['status'] == "F")
				$status_result = "Final results; Can only be changed with a corrected result.";
			if ($subData ['LaboratoryHl7Result'] ['status'] == "I")
				$status_result = "Specimen in lab; results pending";
			if ($subData ['LaboratoryHl7Result'] ['status'] == "N")
				$status_result = "Not asked; used to affirmatively document that the observation identified in the OBX was not sought when the universal service ID in OBR-4 implies that it would be sought.";
			if ($subData ['LaboratoryHl7Result'] ['status'] == "O")
				$status_result = "Order detail description only (no result)";
			if ($subData ['LaboratoryHl7Result'] ['status'] == "P")
				$status_result = "Preliminary results";
			if ($subData ['LaboratoryHl7Result'] ['status'] == "R")
				$status_result = "Results entered -- not verified";
			if ($subData ['LaboratoryHl7Result'] ['status'] == "S")
				$status_result = "Partial results";
			if ($subData ['LaboratoryHl7Result'] ['status'] == "W")
				$status_result = "Post original as wrong, e.g., transmitted for wrong patient";
			if ($subData ['LaboratoryHl7Result'] ['status'] == "X")
				$status_result = "Results cannot be obtained for this observation";
		} else {
			echo __ ( 'Pending' );
		}
		?>
		<td class="table_cell" align="left"><strong><?php echo  __($status_result); ?>
		</strong></td>

	</tr>
	<?php }?>
	</table>
<?php }else{?>
<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%" style="text-align: center;">
	<tr class="row_title">
		<td>Above test is not a panel.</td>
	</tr>
<?php }?>