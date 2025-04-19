<section style="margin:10px;">
<table width="100%">
	<tr>
		<td align="left" width="33%"><?php echo $this->Html->image('hope-logo-sm.gif',array()); ?></td>
		<td align="center" width="33%"><font style="font-weight: bold; font-size: 20px;"><?php echo __("TREATMENT SHEET"); ?></font></td>
		<td align="right" width="33%" style="padding-right:15px;">
			<table border="0" style="outline:1px solid" align="right">
				<tr><td><?php echo $patientData['Patient']['lookup_name']." (".$patientData['Patient']['admission_id'].")"; ?></td></tr>
				<tr><td><?php echo $patientData['Patient']['age']."/".ucfirst($patientData['Patient']['sex']); ?></td></tr>
			</table>
			<!--<span style="font-size: 15px; outline: 1px solid; padding:5px 30px 5px 30px;"> STICKER
			</span>-->
		</td>
	</tr>
</table>
<hr>
<table width="100%">
	<tr>
		<td width="53%">
			<table class="tabularForm" cellspacing="0" cellpadding="0" width="100%">
				<tr>
					<td align="left" width="35%"><b><?php echo __('Name of Patient : '); ?></b></td>
					<td align="left"><?php echo $patientData['Patient']['lookup_name']." (".$patientData['Patient']['admission_id'].")"; ?></td>
				</tr> 
				<tr> 
					<td align="left"><b><?php echo __('Date of Admission : '); ?></b></td>
					<td align="left"><?php echo $this->DateFormat->formatDate2Local($patientData['Patient']['form_received_on'],Configure::read('date_format'),true); ?></td>
				</tr>
				<tr>
					<td align="left"><b><?php echo __('Consultant : '); ?></b></td>
					<td align="left"><?php echo $patientData['DoctorProfile']['doctor_name']; ?></td>
				</tr>
				<tr>
					<td align="left"><b><?php echo __('Diagnosis : '); ?></b></td>
					<td align="left" style=" border-bottom: solid #000 1px"></td>
				</tr>
				<tr>
					<td align="left">&nbsp;</td>
					<td align="left" style=" border-bottom: solid #000 1px"></td>
				</tr>
				<tr>
					<td align="left"><b><?php echo __('Date : '); ?></b></td>
					<td align="left"><?php echo $this->DateFormat->formatDate2Local($this->params['pass']['1'],Configure::read('date_format')); ?></td>
				</tr>
			</table>
		</td>
		<td width="2%"></td>
		<td width="45%">
			<table width="100%" class="tabularForm" cellspacing="0" cellpadding="0" border="1">
				<tr>
					<td align="center" colspan="2" width="50%"><b><?php echo __('Previous Day'); ?></b></td>
					<td align="center" width="30%"><b><?php echo __('Invasive Line'); ?></b></td>
					<td align="center" width="20%"><b><?php echo __('Day'); ?></b></td>
				</tr>
				<tr>
					<td width="30%"><b><?php echo __('Intake'); ?></b></td>
					<td width="20%"></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td><b><?php echo __('Output'); ?></b></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td><b><?php echo __('Balance'); ?></b></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td><b><?php echo __('Drainage'); ?></b></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</table>
		</td>
	</tr> 
</table>
<?php $dosage = Configure :: read("route_administration"); ?>

<table width="100%" class="tabularForm" cellspacing="0" cellpadding="0" border="1" style="margin-bottom: 10px;"> 
	<thead>
		<tr height="30px">
			<td align="left" width="2%"><b><?php echo __("Sr.No"); ?></b></td>
			<td align="left" width=""><b><?php echo __("Name of Medication"); ?></b></td>
			<td align="center" width=""><b><?php echo __("Dose"); ?></b></td>
			<td align="center" width=""><b><?php echo __("Route"); ?></b></td>
			<td align="center" width="" colspan="4"><b><?php echo __("Time"); ?></b></td>
			<td align="center" width=""><b><?php echo __("Investigation Advised"); ?></b></td>
		</tr>
	</thead>
	<tbody>
		<?php $cnt =1; $treatmentData = array_values($treatmentData); foreach (range(0,19) as $key => $value) { ?>
		<tr height="30px">
			<td align="left"><?php echo $cnt++; ?></td>
			<td align="left"><?php echo $treatmentData[$value]['PharmacyItem']['name']; ?></td>
			<td align="center"><?php echo $treatmentData[$value]['TreatmentMedicationDetail']['routes']; ?></td>
			<td align="center"><?php echo $dosage[$treatmentData[$value]['TreatmentMedicationDetail']['dosage']]; ?></td>
			<td align="center"><?php //echo $treatmentData[$value]['TreatmentMedicationDetail']['quantity']; ?></td> 
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<?php } ?> 
	</tbody>
</table>

<table width="100%" class="tabularForm" cellspacing="0" cellpadding="0" border="1"> 
	<thead>
		<tr height="30px">
			<td align="center" width="33%"><b><?php echo __("Fluid"); ?></b></td>
			<td align="center" width="33%"><b><?php echo __("Rate"); ?></b></td>
			<td align="center" width="33%"><b><?php echo __("Other Instruction"); ?></b></td>
		</tr>
	</thead>
	<tbody>
		<?php foreach (range(0,2) as $val) {   ?>
		<tr height="30px">
			<td align="left"><?php ?></td>
			<td align="left"><?php ?></td>
			<td align="center"><?php ?></td> 
		</tr>
		<?php } ?> 
	</tbody>
</table>
</section> 

<script>
	window.onload=function(){self.print();} 
</script>