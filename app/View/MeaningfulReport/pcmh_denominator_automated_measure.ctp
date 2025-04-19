<div class="inner_title">
<?php
	  $dateFrom=date("m/d/Y", strtotime($date[0]));
	  $dateTo=date("m/d/Y", strtotime($date[1]));
	 ?>
<h3><?php echo __('PCMH Patient List For ').$provider['DoctorProfile']['doctor_name'].' From '.$dateFrom.' To '.$dateTo; ?></h3>

	<span style="float: right;"><?php	 
echo $this->Html->link('Excel Report',array('controller'=>$this->params->controller,'action'=>$this->params->action,'excel',
'?'=>$this->params->query),array('id'=>'excel_report','class'=>'blueBtn'));
?></span>
</div>

<div>&nbsp;</div>

	<table width="90%" align="center" class="formFull" cellpadding="0" cellspacing="0">
		<?php
		if(!empty($denominatorVal)){
			echo "<tr class='row_gray'>
				<th class='tdLabel'>Sr.no</th>
				<th class='tdLabel'>Patient MRN</th>
				<th class='tdLabel'>Patient Name</th>
	  			<!--<th class='tdLabel'>Mobile No.</th>
				<th class='tdLabel'>City</th>
				<th class='tdLabel'>Email</th>-->
				";
			if($this->params->query['option']=='dob'){
				echo "<th class='tdLabel'>Date Of Birth</th>";
			}else if($this->params->query['option']=='sex'){
				echo "<th class='tdLabel'>Gender</th>";
			
			}else if($this->params->query['option']=='race'){
				echo "<th class='tdLabel'>Race</th>";
			
			}else if($this->params->query['option']=='language'){
				echo "<th class='tdLabel'>Prefered Language </th>";
			
			}else if($this->params->query['option']=='telephone'){
				echo "<th class='tdLabel'>Telephone Number</th>";
			
			}else if($this->params->query['option']=='alter_telephone'){
				echo "<th class='tdLabel'>Alternate Telephone Number</th>";
			
			}else if($this->params->query['option']=='email'){
				echo "<th class='tdLabel'>Email</th>";
			
			}else if($this->params->query['option']=='occupation'){
				echo "<th class='tdLabel'>Patient Occupation</th>";
			
			}else if($this->params->query['option']=='date'){
				echo "<th class='tdLabel'>Date Of Last Visit</th>";
			
			}else if($this->params->query['option']=='legal_guar'){
				echo "<th class='tdLabel'>Legal Guardian/Healthcare Proxy</th>";
			
			}else if($this->params->query['option']=='pri_care_giver'){
				echo "<th class='tdLabel'>Primary Care Giver </th>";
			
			}else if($this->params->query['option']=='adv_dir'){
				echo "<th class='tdLabel'> Advanced Directives</th>";
			
			}else if($this->params->query['option']=='health_info'){
				echo "<th class='tdLabel'>Health Insurance Information</th>";
			
			}else if($this->params->query['option']=='health_care'){
				echo "<th class='tdLabel'>Name and Contact of Other Healthcare Professionals involved in care</th>";
			
			}
			echo "</tr>	";
				$toggle=0;$sr=1;
				foreach($denominatorVal as $data){
					if($toggle == 0) {
					echo "<tr>";
					$toggle = 1;
					}else{
					echo "<tr class='row_gray'>";
					$toggle = 0;
					}
					?>
					<td class='tdLabel'><?php echo $sr;?></td>
					<td class='tdLabel'><?php echo $data['Patient']['patient_id'];?></td>
					<td class='tdLabel'><?php echo $data['Patient']['lookup_name']?></td>
					<!--  <td class='tdLabel'><?php echo $data['Person']['person_local_number']?></td>
					<td class='tdLabel'><?php echo $data['Patient']['city']?></td>
					<td class='tdLabel'><?php echo $data['Person']['person_email_address']?></td> -->
					<?php 
					 if($this->params->query['option']=='dob'){
						if(!empty($data['Person']['dob'])){
							echo "<td class='tdLabel'>".$this->DateFormat->formatDate2Local($data['Person']['dob'],
									Configure::read('date_format'),false)."</td>";
						}else{
							echo "Not Captured";
						}
			}else if($this->params->query['option']=='sex'){
					if(!empty($data['Person']['sex'])){
						echo "<td class='tdLabel'>".$data['Person']['sex']."</td>";
					}else{
						echo "Not Captured";
					}						
			
			}else if($this->params->query['option']=='race'){
				if(!empty($data['Person']['race'])){
					echo "<td class='tdLabel'>".$data['Person']['race']."</td>";
				}else{
					echo "Not Captured";
				}
			
			}else if($this->params->query['option']=='language'){
				if(!empty($data['Person']['preferred_language'])){
					echo "<td class='tdLabel'>".$data['Person']['preferred_language']."</td>";
				}else{
					echo "Not Captured";
				}
			}else if($this->params->query['option']=='telephone'){
				if(!empty($data['Person']['person_local_number'])){
					echo "<td class='tdLabel'>".$data['Person']['person_local_number']."</td>";
				}else{
					echo "Not Captured";
				}
			
			}else if($this->params->query['option']=='alter_telephone'){
				if(!empty($data['Person']['person_local_number_second'])){
					echo "<td class='tdLabel'>".$data['Person']['person_local_number_second']."</td>";
				}else{
					echo "Not Captured";
				}
			
			}else if($this->params->query['option']=='email'){
				if(!empty($data['Person']['person_email_address'])){
					echo "<td class='tdLabel'>".$data['Person']['person_email_address']."</td>";
				}else{
					echo "Not Captured";
				}
			
			}else if($this->params->query['option']=='occupation'){
				if(!empty($data['Person']['occupation'])){
					echo "<td class='tdLabel'>".$data['Person']['occupation']."</td>";
				}else{
					echo "Not Captured";
				}
			
			}else if($this->params->query['option']=='date'){
				if(!empty($data['Person']['sex'])){
					echo "<td class='tdLabel'>".$data['Person']['sex']."</td>";
				}else{
					echo "Not Captured";
				}
			
			}else if($this->params->query['option']=='legal_guar'){
				if(!empty($data['Person']['guar_first_name'])){
					echo "<td class='tdLabel'>".$data['Person']['guar_first_name']."</td>";
				}else{
					echo "Not Captured";
				}
			
			}else if($this->params->query['option']=='pri_care_giver'){
				if(!empty($data['Guardian']['guar_first_name'])){
					echo "<td class='tdLabel'>".$data['Guardian']['guar_first_name']."</td>";
				}else{
					echo "Not Captured";
				}
			
			}else if($this->params->query['option']=='adv_dir'){
				if(!empty($data['AdvanceDirective']['patient_name'])){
					echo "<td class='tdLabel'>".$data['AdvanceDirective']['patient_name']."</td>";
				}else{
					echo "Not Captured";
				}
			
			}else if($this->params->query['option']=='health_info'){
				if(!empty($data['Patient']['insurance_company_name'])){
					echo "<td class='tdLabel'>".$data['Patient']['insurance_company_name']."</td>";
				}else{
					echo "Not Captured";
				}
			
			}else if($this->params->query['option']=='health_care'){
				if(!empty($data['Person']['sex'])){
					echo "<td class='tdLabel'>".$data['Person']['sex']."</td>";
				}else{
					echo "Not Captured";
				}
			}?>
					</tr>
				

		<?php $sr++; } }//end of if	?>
	</table>