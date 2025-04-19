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
	<table width="90%" align="center" class="formFull" cellpadding="0" cellspacing="0">
		<?php
		if(!empty($numeratorVal)){
			echo "<tr class='row_gray'>
				<th class='tdLabel'>Sr.no</th>
				<th class='tdLabel'>Patient MRN</th>
				<th class='tdLabel'>Patient Name</th>
	  			<!--<th class='tdLabel'>Mobile No.</th>
				<th class='tdLabel'>City</th>
				<th class='tdLabel'>Email</th>-->
				</tr>	";
				$toggle=0;$sr=1;
				foreach($numeratorVal as $data){
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
					</tr>
				

		<?php $sr++; } }//end of if	?>
	</table>