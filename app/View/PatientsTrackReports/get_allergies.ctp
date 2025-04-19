<div class="inner_title">
		<h3 style="padding:0 0 0 20px;">
			<?php echo __('Allergies'); ?>
		</h3>
	
	</div>
<table border="0" class="table_format" cellpadding="0"
				cellspacing="0" width="97%">
				<tr class="row_title">
					<td class="table_cell"><strong>Sr. #</strong></td>
					<td class="table_cell"><strong>Name</strong></td>
					<td class="table_cell"><strong>Reaction</strong></td>
					<td class="table_cell"><strong>Status</strong></td>
					<td class="table_cell"><strong>Severity Level</strong></td>
					<td class="table_cell"><strong>Onset Date</strong></td>
				</tr>
				<?php //debug($allergies_data);exit;
				$count=0;
				$toggle =0;
				$cnt_comm = 0;
				for($counter=0;$counter< count($allergies_data);$counter++){
				//	if($allergies_data[$counter]['NewCropAllergies']['patient_uniqueid'] == $patientId){
					if($toggle == 0) {
							echo "<tr class='row_gray'>";
							$toggle = 1;
						}else{
							echo "<tr>";
							$toggle = 0;
						}
				$count++;$cnt_comm++;	 ?>
				<?php
					if($allergies_data[$counter]['NewCropAllergies']['status'] == 'A'){
						$statusDisplay = 'Active';
					}else{
						$statusDisplay = 'Inactive ';
					}
				
				?>			
					<td class="row_format">&nbsp;<?php echo $count; ?>
					</td>
					<td class="row_format">&nbsp;<?php echo $allergies_data[$counter]['NewCropAllergies']['name']; ?>
					</td>
					<td class="row_format">&nbsp;<?php echo ucwords($allergies_data[$counter]['NewCropAllergies']['reaction']);  ?>
					</td>
					<td class="row_format">&nbsp;<?php echo $statusDisplay;  ?>
					</td>
					<td class="row_format">&nbsp;<?php echo $allergies_data[$counter]['NewCropAllergies']['AllergySeverityName'];  ?>
					</td>
					<?php if(empty($allergies_data[$counter]['NewCropAllergies']['onset_date']) || $allergies_data[$counter]['NewCropAllergies']['onset_date']=='//'){
						$allergies_data[$counter]['NewCropAllergies']['onset_date']='';
					}else{
						$allergies_data[$counter]['NewCropAllergies']['onset_date'] = $this->DateFormat->formatDate2Local($allergies_data[$counter]['NewCropAllergies']['onset_date'],Configure::read('date_format_us'),false);
					}
					?>
					<td class="row_format">&nbsp;<?php echo $allergies_data[$counter]['NewCropAllergies']['onset_date'];  ?>
					</td>
				</tr>
				<tr>
					<td class="row_format" colspan="3"
						style="color: red; display: none; padding-left: 30px;" 'id='cmnt_presc><?php echo $count; ?>'><span></span>
					</td>
				</tr>
				<?php } /* } */?>
			</table>