<style>
.patientHub .patientInfo .heading {
    float: left;
    width: 174px;
}
</style>
<div class="inner_title">
	<h3>
		<?php echo __('Hospital Associated Infections', true); ?>
	</h3>
	<span> <?php 

	$passMaxDate = explode("-", $maxDate);
	echo $this->Html->link('Print','#',
			array('escape' => false,'class' => 'blueBtn', 'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'print_hai',$patient['Patient']['id'],$passMaxDate[2],$passMaxDate[1],$passMaxDate[0]))."', '_blank',
					'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
	echo $this->Html->link(__('Back', true),array('controller'=>'nursings','action' => 'patient_information',$patient['Patient']['id']), array('escape' => false,'class'=>'blueBtn'));
	?>
	</span>
</div>
<div class="patient_info">
	<?php echo $this->element('patient_information');?>
</div>
<div class="clr"></div>
<div
	style="text-align: right;" class="clr inner_title"></div>
<?php 
if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"
	align="center">
	<tr>
		<td colspan="2" align="left" class="error"><?php
		foreach($errors as $errorsval){
			echo $errorsval[0];
			echo "><br />";
		}
		?>
		</td>
	</tr>
</table>
<?php } ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>
			<div class="btns">
				<?php
				echo $this->Html->link(__('Surgical Site Infection'), array('controller'=>'hospital_acquire_infections',
				'action'=> 'surgical_site_infections', $patient["Patient"]["id"]),array('escape' => false,'class'=>'blueBtn'));
				?>
			</div>
		</td>
	</tr>
</table>

<!-- two column table end here -->

<?php $options = array('' => 'Select', 'No' => 'No', 'Yes' => 'Yes'); ?>
<div>&nbsp;</div>
<table width="100%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm">
	<tr>
		<td><?php echo __('Date',true);?><font color="red">*</font></td>
		<td><?php 
		 
		echo $this->Form->input('IntrinsicRiskFactor.date',array('value' => date("m/d/Y",strtotime($maxDate)),'class' => 'validate[required,custom[customrequired]] textBoxExpnd','style'=>'width:120px;','legend'=>false,'label'=>false,'id' => 'intrinsic_date','readonly'=>'readonly'));
		?>
		</td>
	</tr>
</table>
<div class="clr ht5"></div>

<table width="100%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm" id="displayIntrinsicRiskFactorId">
	<tr>
		<th colspan="8"><?php echo __('Intrinsic Risk Factors',true); ?><span
			style="text-align: right; float: right; cursor: pointer;"
			id="editIntrinsicRiskFactor"><?php echo $this->Html->image('icons/edit-icon.png'); ?>
		</span></th>
	</tr>
	<tr>
		<td valign="middle"><?php echo __('Antibiotic',true); ?></td>
		<td valign="middle"><?php 
		echo $getIntrinsic['IntrinsicRiskFactor']['antibiotic'];
		?>
		</td>
		<td valign="middle"><?php echo __('Prophylaxis Therapy',true); ?>
		</td>
		<td valign="middle"><?php 
		echo $getIntrinsic['IntrinsicRiskFactor']['prophylaxis_therapy'];
		?>
		</td>
		<td valign="middle"><?php echo __('Diabetes',true); ?></td>
		<td valign="middle"><?php 
		echo $getIntrinsic['IntrinsicRiskFactor']['diabetes'];
		?>
		</td>
		<td valign="middle"><?php echo __('Alcoholism',true); ?></td>
		<td valign="middle"><?php 
		echo $getIntrinsic['IntrinsicRiskFactor']['alcoholism'];
		?>
		</td>
	</tr>

	<tr>
		<td valign="middle"><?php echo __('Smoking',true); ?>
		</td>
		<td valign="middle"><?php 
		echo $getIntrinsic['IntrinsicRiskFactor']['smoking'];
		?>
		</td>
		<td valign="middle"><?php echo __('Hypertension',true); ?>
		</td>
		<td valign="middle"><?php
		echo $getIntrinsic['IntrinsicRiskFactor']['hypertension'];
		?>
		</td>
		<td valign="middle"><?php echo __('Anaemia',true); ?></td>
		<td valign="middle"><?php 
		echo $getIntrinsic['IntrinsicRiskFactor']['anaemia'];
		?>
		</td>
		<td valign="middle"><?php echo __('Malignancy',true); ?>
		</td>
		<td valign="middle"><?php 
		echo $getIntrinsic['IntrinsicRiskFactor']['malignancy'];
		?>
		</td>
	</tr>

	<tr>
		<td valign="middle"><?php echo __('Trauma',true); ?>
		</td>
		<td valign="middle"><?php 
		echo $getIntrinsic['IntrinsicRiskFactor']['trauma'];
		?>
		</td>
		<td valign="middle"><?php echo __('Cirrhosis',true); ?>
		</td>
		<td valign="middle"><?php
		echo $getIntrinsic['IntrinsicRiskFactor']['cirrhosis'];
		?>
		</td>
		<td valign="middle"><?php echo __('Steroids',true); ?>
		</td>
		<td valign="middle"><?php
		echo $getIntrinsic['IntrinsicRiskFactor']['steroids'];
		?>
		</td>
		<td valign="middle"><?php echo __('Immunosuppression',true); ?>
		</td>
		<td valign="middle"><?php 
		echo $getIntrinsic['IntrinsicRiskFactor']['immunosuppression'];
		?>
		</td>
	</tr>
</table>

<table width="100%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm" id="editIntrinsicRiskFactorId"
	style="display: none;">
	<form name="intrinsicRiskFactorFrm" id="intrinsicRiskFactorFrm"
		action="<?php echo $this->Html->url(array("controller" => "hospital_acquire_infections", "action" => "edit_intrinsic_risk_factor",$patient['Patient']['id'], "admin" => false)); ?>"
		method="post">
		<?php 
		echo $this->Form->input('IntrinsicRiskFactor.patient_id', array('value' => $patient['Patient']['id'], 'type' => 'hidden', 'id' => 'patientid'));
		echo $this->Form->input('IntrinsicRiskFactor.submit_date', array('value' => $maxDate, 'type' => 'hidden'));
		echo $this->Form->input('IntrinsicRiskFactor.id', array('value' => $getIntrinsic['IntrinsicRiskFactor']['id'], 'type' => 'hidden'));
		?>
		<tr>
			<th colspan="8"><?php echo __('Intrinsic Risk Factors',true); ?><span
				style="text-align: right; float: right; cursor: pointer;"
				id="displayIntrinsicRiskFactor"><?php echo $this->Html->image('icons/edit-icon.png'); ?>
			</span></th>
		</tr>
		<tr>
			<td valign="middle"><?php echo __('Antibiotic',true); ?></td>
			<td valign="middle"><?php 
			echo $this->Form->input('IntrinsicRiskFactor.antibiotic', array('default' => $getIntrinsic['IntrinsicRiskFactor']['antibiotic'], 'options' =>$options, 'id' => 'antibiotic', 'label'=> false, 'div' => false, 'error'=> false));
			?>
			</td>
			<td valign="middle"><?php echo __('Prophylaxis Therapy',true); ?>
			</td>
			<td valign="middle"><?php 

			echo $this->Form->input('IntrinsicRiskFactor.prophylaxis_therapy', array('default' => $getIntrinsic['IntrinsicRiskFactor']['prophylaxis_therapy'],'options' => $options, 'id' => 'prophylaxis_therapy', 'label'=> false,'div' => false, 'error' => false));

			?></td>
			<td valign="middle"><?php echo __('Diabetes',true); ?></td>
			<td valign="middle"><?php 

			echo $this->Form->input('IntrinsicRiskFactor.diabetes', array('default' => $getIntrinsic['IntrinsicRiskFactor']['diabetes'], 'options' =>$options, 'id' => 'diabetes', 'label'=> false, 'div' => false, 'error'=> false));

			?>
			</td>
			<td valign="middle"><?php echo __('Alcoholism',true); ?></td>
			<td valign="middle"><?php 

			echo $this->Form->input('IntrinsicRiskFactor.alcoholism', array('default' => $getIntrinsic['IntrinsicRiskFactor']['alcoholism'],  'options' =>$options, 'id' => 'alcoholism', 'label'=> false, 'div' => false, 'error'=> false));

			?>
			</td>
		</tr>

		<tr>
			<td valign="middle"><?php echo __('Smoking',true); ?>
			</td>
			<td valign="middle"><?php 

			echo $this->Form->input('IntrinsicRiskFactor.smoking', array('default' => $getIntrinsic['IntrinsicRiskFactor']['smoking'],  'options' => $options, 'id' => 'smoking', 'label'=> false, 'div' => false, 'error' =>false));

			?>
			</td>
			<td valign="middle"><?php echo __('Hypertension',true); ?>
			</td>
			<td valign="middle"><?php

			echo $this->Form->input('IntrinsicRiskFactor.hypertension', array('default' => $getIntrinsic['IntrinsicRiskFactor']['hypertension'],  'options'=> $options, 'id' => 'hypertension', 'label'=> false, 'div' => false,'error' => false));

			?>
			</td>
			<td valign="middle"><?php echo __('Anaemia',true); ?></td>
			<td valign="middle"><?php 

			echo $this->Form->input('IntrinsicRiskFactor.anaemia', array('default' => $getIntrinsic['IntrinsicRiskFactor']['anaemia'],  'options' =>$options, 'id' => 'anaemia', 'label'=> false, 'div' => false, 'error' =>false));

			?>
			</td>
			<td valign="middle"><?php echo __('Malignancy',true); ?>
			</td>
			<td valign="middle"><?php 

			echo $this->Form->input('IntrinsicRiskFactor.malignancy', array('default' => $getIntrinsic['IntrinsicRiskFactor']['malignancy'],  'options' =>$options, 'id' => 'smoking', 'label'=> false, 'div' => false, 'error' =>false));

			?>
			</td>
		</tr>

		<tr>
			<td valign="middle"><?php echo __('Trauma',true); ?>
			</td>
			<td valign="middle"><?php 

			echo $this->Form->input('IntrinsicRiskFactor.trauma', array('default' => $getIntrinsic['IntrinsicRiskFactor']['trauma'],  'options' =>$options, 'id' => 'trauma', 'label'=> false, 'div' => false, 'error' =>false));

			?>
			</td>
			<td valign="middle"><?php echo __('Cirrhosis',true); ?>
			</td>
			<td valign="middle"><?php

			echo $this->Form->input('IntrinsicRiskFactor.cirrhosis', array('default' => $getIntrinsic['IntrinsicRiskFactor']['cirrhosis'],  'options' =>$options, 'id' => 'cirrhosis', 'label'=> false, 'div' => false, 'error'=> false));

			?>
			</td>
			<td valign="middle"><?php echo __('Steroids',true); ?>
			</td>
			<td valign="middle"><?php

			echo $this->Form->input('IntrinsicRiskFactor.steroids', array('default' => $getIntrinsic['IntrinsicRiskFactor']['steroids'],  'options' =>$options, 'id' => 'steroids', 'label'=> false, 'div' => false, 'error'=> false));

			?>
			</td>
			<td valign="middle"><?php echo __('Immunosuppression',true); ?>
			</td>
			<td valign="middle"><?php 

			echo $this->Form->input('IntrinsicRiskFactor.immunosuppression', array('default' => $getIntrinsic['IntrinsicRiskFactor']['immunosuppression'], 'options' => $options, 'id' => 'immunosuppression', 'label'=> false,'div' => false, 'error' => false));

			?>
			</td>
		</tr>
		<tr>
			<td colspan="8" align="right"><?php echo $this->Form->submit(__('Submit'),
					array('class'=>'blueBtn','div'=>false, 'id' => 'submit_intrisic_risk')); ?>
			</td>
		</tr>

	</form>
</table>

<div>&nbsp;</div>
<div class="clr ht5"></div>
<table width="100%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm" id="displayPatientExposureId">
	<tr>
		<th colspan="4"><?php echo __('Patient Exposure',true); ?><span
			style="text-align: right; float: right; cursor: pointer;"
			id="editPatientExposure"><?php echo $this->Html->image('icons/edit-icon.png'); ?>
		</span></th>
	</tr>

	<tr>
		<td width="250"><?php echo __('Date',true); ?></td>
		<?php 
		for($i=0; $i < count($dateArray); $i++) {
?>
		<td width="100">
			<table width="100" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="75"><?php echo date("m/d/Y", strtotime($dateArray[$i])); ?>
					</td>
					<td width="25" align="right">&nbsp;</td>
				</tr>
			</table>
		</td>
		<?php 
    }
    ?>
	</tr>

	<?php 
	$patientExposure = array('Surgical procedure', 'Urinary catheter', 'Mechanical ventilation', 'Central Line', 'Peripheral Line');
	$patientExposureTableField = array('surgical_procedure', 'urinary_catheter', 'mechanical_ventilation', 'central_line', 'peripheral_line');
	foreach($getPatientExposure as $getPatientExposureVal) {
	       $patientExpSubmitDate[] = $getPatientExposureVal['PatientExposure']['submit_date'];

	       $patientExpStoreWithDate['PatientExposure']['surgical_procedure'][$getPatientExposureVal['PatientExposure']['submit_date']] = $getPatientExposureVal['PatientExposure']['surgical_procedure'];

	       $patientExpStoreWithDate['PatientExposure']['urinary_catheter'][$getPatientExposureVal['PatientExposure']['submit_date']] = $getPatientExposureVal['PatientExposure']['urinary_catheter'];

	       $patientExpStoreWithDate['PatientExposure']['mechanical_ventilation'][$getPatientExposureVal['PatientExposure']['submit_date']] = $getPatientExposureVal['PatientExposure']['mechanical_ventilation'];

	       $patientExpStoreWithDate['PatientExposure']['central_line'][$getPatientExposureVal['PatientExposure']['submit_date']] = $getPatientExposureVal['PatientExposure']['central_line'];

	       $patientExpStoreWithDate['PatientExposure']['peripheral_line'][$getPatientExposureVal['PatientExposure']['submit_date']] = $getPatientExposureVal['PatientExposure']['peripheral_line'];
     }

     for($i=0; $i<count($patientExposure); $i++) {
?>
	<tr>
		<td valign="middle"><?php echo $patientExposure[$i]; ?></td>
		<?php 

		for($j=0; $j < count($dateArray); $j++) {
		  if(in_array($dateArray[$j], $patientExpSubmitDate)) {
        ?>
		<td width="100">
			<table width="100" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="75"><?php echo $patientExpStoreWithDate['PatientExposure'][$patientExposureTableField[$i]][$dateArray[$j]]; ?>
					</td>
					<td width="25" align="right">&nbsp;</td>
				</tr>
			</table>
		</td>
		<?php  
	      } else {
	   ?>
		<td width="100">
			<table width="100" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="75"><?php 
				 if($dateArray[$j] > date("Y-m-d")) {
	              // echo $this->Form->input('PatientExposure.'.$patientExposureTableField[$i].'.'.$dateArray[$j], array('options' => $options, 'id' => $patientExposureTableField[$i], 'label'=> false, 'div' => false, 'error' => false));
	             } else {
					//echo __('No Record Found');
				 }
				 ?>
					</td>
					<td width="25" align="right">&nbsp;</td>
				</tr>
			</table>
		</td>
		<?php 
	      }
	      ?>
		<?php 
	      }
	      ?>
	</tr>
	<?php
	    }
	    ?>

</table>

<table width="100%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm" id="editPatientExposureId" style="display: none;">
	<form name="patientExposureFrm" id="patientExposureFrm"
		action="<?php echo $this->Html->url(array("controller" => "hospital_acquire_infections", "action" => "edit_patient_exposure",$patient['Patient']['id'], "admin" => false)); ?>"
		method="post">
		<?php 
		echo $this->Form->input('PatientExposure1.patient_id', array('value' => $patient['Patient']['id'], 'type' => 'hidden'));
		echo $this->Form->input('PatientExposure1.min_date', array('value' => $minDate, 'type' => 'hidden'));
		echo $this->Form->input('PatientExposure1.max_date', array('value' => $maxDate, 'type' => 'hidden'));
			
		?>
		<tr>
			<th colspan="4"><?php echo __('Patient Exposure',true); ?><span
				style="text-align: right; float: right; cursor: pointer;"
				id="displayPatientExposure"><?php echo $this->Html->image('icons/edit-icon.png'); ?>
			</span></th>
		</tr>

		<tr>
			<td width="250"><?php echo __('Date',true); ?></td>
			<?php 
			for($i=0; $i < count($dateArray); $i++) {
?>
			<td width="100">
				<table width="100" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="75"><?php echo date("m/d/Y", strtotime($dateArray[$i])); ?>
						</td>
						<td width="25" align="right">&nbsp;</td>
					</tr>
				</table>
			</td>
			<?php 
    }
    ?>
		</tr>

		<?php 
		$patientExposure = array('Surgical procedure', 'Urinary catheter', 'Mechanical ventilation', 'Central Line', 'Peripheral Line');
		$patientExposureTableField = array('surgical_procedure', 'urinary_catheter', 'mechanical_ventilation', 'central_line', 'peripheral_line');
		foreach($getPatientExposure as $getPatientExposureVal) {
	       $patientExpSubmitDate[] = $getPatientExposureVal['PatientExposure']['submit_date'];
	        
	       $patientExpStoreWithDate['PatientExposure']['id'][$getPatientExposureVal['PatientExposure']['submit_date']] = $getPatientExposureVal['PatientExposure']['id'];

	       $patientExpStoreWithDate['PatientExposure']['surgical_procedure'][$getPatientExposureVal['PatientExposure']['submit_date']] = $getPatientExposureVal['PatientExposure']['surgical_procedure'];

	       $patientExpStoreWithDate['PatientExposure']['urinary_catheter'][$getPatientExposureVal['PatientExposure']['submit_date']] = $getPatientExposureVal['PatientExposure']['urinary_catheter'];

	       $patientExpStoreWithDate['PatientExposure']['mechanical_ventilation'][$getPatientExposureVal['PatientExposure']['submit_date']] = $getPatientExposureVal['PatientExposure']['mechanical_ventilation'];

	       $patientExpStoreWithDate['PatientExposure']['central_line'][$getPatientExposureVal['PatientExposure']['submit_date']] = $getPatientExposureVal['PatientExposure']['central_line'];

	       $patientExpStoreWithDate['PatientExposure']['peripheral_line'][$getPatientExposureVal['PatientExposure']['submit_date']] = $getPatientExposureVal['PatientExposure']['peripheral_line'];
     }


     for($i=0; $i<count($patientExposure); $i++) {
?>
		<tr>
			<td valign="middle"><?php echo $patientExposure[$i]; ?></td>
			<?php 

			for($j=0; $j < count($dateArray); $j++) {

        ?>
			<td width="100">
				<table width="100" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="75"><?php 
						if($dateArray[$j] >= date("Y-m-d", strtotime($patient['Patient']['form_received_on']))) {
					 echo $this->Form->input('PatientExposure1.id.'.$dateArray[$j], array('value' =>$patientExpStoreWithDate['PatientExposure']['id'][$dateArray[$j]], 'type' => 'hidden'));
					 echo $this->Form->input('PatientExposure1.'.$patientExposureTableField[$i].'.'.$dateArray[$j], array('default' => $patientExpStoreWithDate['PatientExposure'][$patientExposureTableField[$i]][$dateArray[$j]] ,'options' => $options, 'id' => $patientExposureTableField[$i], 'label'=> false, 'div' => false, 'error' => false));
		         }
		         ?>
						</td>
						<td width="25" align="right">&nbsp;</td>
					</tr>
				</table>
			</td>

			<?php 
	      }
	      ?>
		</tr>
		<?php
	    }
	    ?>
		<tr>
			<td colspan="4" align="right"><?php echo $this->Form->submit(__('Submit'),
					array('class'=>'blueBtn','div'=>false)); ?>
			</td>
		</tr>
	</form>
</table>




<div>&nbsp;</div>
<div class="clr ht5"></div>

<table width="100%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm" id="displaySignSymptomId">

	<tr>
		<th colspan="4"><?php echo __('Signs and Symptoms',true); ?><span
			style="text-align: right; float: right; cursor: pointer;"
			id="editSignSymptom"><?php echo $this->Html->image('icons/edit-icon.png'); ?>
		</span></th>
	</tr>

	<tr>
		<td width="250"><?php echo __('Date',true); ?></td>
		<?php 
		for($i=0; $i < count($dateArray); $i++) {
?>
		<td width="100">
			<table width="100" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="75"><?php echo date("m/d/Y", strtotime($dateArray[$i])); ?>
					</td>
					<td width="25" align="right">&nbsp;</td>
				</tr>
			</table>
		</td>
		<?php 
    }
    ?>
	</tr>

	<?php 
	$signSymptom = array('Fever', 'Chills', 'Local Pain', 'Swelling', 'Redness', 'Pus/Discharge', 'Urinary Frequency', 'Respiratory Secretion', 'Dysuria', 'Suprapubic Tenderness', 'Oliguria', 'Pyuria', 'Cough', 'Blood clot', 'Other');
	$signSymptomTableField = array('fever', 'chills', 'local_pain', 'swelling', 'redness', 'pus_discharge', 'urinary_frequency', 'respiratory_secretion', 'dysuria', 'suprapubic_tenderness', 'oliguria', 'pyuria', 'cough', 'blood_clot', 'other');

	foreach($getSignSymptom as $getSignSymptomVal) {
	       $signSymptomSubmitDate[] = $getSignSymptomVal['SignSymptom']['submit_date'];

	       $signSymptomWithDate['SignSymptom']['fever'][$getSignSymptomVal['SignSymptom']['submit_date']] = $getSignSymptomVal['SignSymptom']['fever'];
	       $signSymptomWithDate['SignSymptom']['chills'][$getSignSymptomVal['SignSymptom']['submit_date']] = $getSignSymptomVal['SignSymptom']['chills'];
	       $signSymptomWithDate['SignSymptom']['local_pain'][$getSignSymptomVal['SignSymptom']['submit_date']] = $getSignSymptomVal['SignSymptom']['local_pain'];
	       $signSymptomWithDate['SignSymptom']['swelling'][$getSignSymptomVal['SignSymptom']['submit_date']] = $getSignSymptomVal['SignSymptom']['swelling'];
	       $signSymptomWithDate['SignSymptom']['redness'][$getSignSymptomVal['SignSymptom']['submit_date']] = $getSignSymptomVal['SignSymptom']['redness'];
	       $signSymptomWithDate['SignSymptom']['pus_discharge'][$getSignSymptomVal['SignSymptom']['submit_date']] = $getSignSymptomVal['SignSymptom']['pus_discharge'];
	       $signSymptomWithDate['SignSymptom']['urinary_frequency'][$getSignSymptomVal['SignSymptom']['submit_date']] = $getSignSymptomVal['SignSymptom']['urinary_frequency'];
	       $signSymptomWithDate['SignSymptom']['respiratory_secretion'][$getSignSymptomVal['SignSymptom']['submit_date']] = $getSignSymptomVal['SignSymptom']['respiratory_secretion'];
	       $signSymptomWithDate['SignSymptom']['dysuria'][$getSignSymptomVal['SignSymptom']['submit_date']] = $getSignSymptomVal['SignSymptom']['dysuria'];
	       $signSymptomWithDate['SignSymptom']['suprapubic_tenderness'][$getSignSymptomVal['SignSymptom']['submit_date']] = $getSignSymptomVal['SignSymptom']['suprapubic_tenderness'];
	       $signSymptomWithDate['SignSymptom']['oliguria'][$getSignSymptomVal['SignSymptom']['submit_date']] = $getSignSymptomVal['SignSymptom']['oliguria'];
	       $signSymptomWithDate['SignSymptom']['pyuria'][$getSignSymptomVal['SignSymptom']['submit_date']] = $getSignSymptomVal['SignSymptom']['pyuria'];
	       $signSymptomWithDate['SignSymptom']['cough'][$getSignSymptomVal['SignSymptom']['submit_date']] = $getSignSymptomVal['SignSymptom']['cough'];
	       $signSymptomWithDate['SignSymptom']['blood_clot'][$getSignSymptomVal['SignSymptom']['submit_date']] = $getSignSymptomVal['SignSymptom']['blood_clot'];
	       $signSymptomWithDate['SignSymptom']['other'][$getSignSymptomVal['SignSymptom']['submit_date']] = $getSignSymptomVal['SignSymptom']['other'];

	        
     }

     for($i=0; $i<count($signSymptom); $i++) {
?>
	<tr>
		<td valign="middle"><?php echo $signSymptom[$i]; ?></td>
		<?php 

		for($j=0; $j < count($dateArray); $j++) {
		  if(in_array($dateArray[$j], $signSymptomSubmitDate)) {
        ?>
		<td width="100">
			<table width="100" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="75"><?php echo $signSymptomWithDate['SignSymptom'][$signSymptomTableField[$i]][$dateArray[$j]]; ?>
					</td>
					<td width="25" align="right">&nbsp;</td>
				</tr>
			</table>
		</td>
		<?php  
	      } else {
	   ?>
		<td width="100">
			<table width="100" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="75"><?php 
				 if($dateArray[$j] > date("Y-m-d")) {
	               //echo $this->Form->input('SignSymptom.'.$signSymptomTableField[$i].'.'.$dateArray[$j], array('options' => $options, 'id' => $signSymptomTableField[$i], 'label'=> false, 'div' => false, 'error' => false));
	             } else {
					//echo __('No Record Found');
				 }
				 ?>
					</td>
					<td width="25" align="right">&nbsp;</td>
				</tr>
			</table>
		</td>
		<?php 
	      }
	      ?>
		<?php 
	      }
	      ?>
	</tr>
	<?php
	    }
	    ?>
</table>

<table width="100%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm" id="editSignSymptomId" style="display: none;">
	<form name="signSymptomFrm" id="signSymptomFrm"
		action="<?php echo $this->Html->url(array("controller" => "hospital_acquire_infections", "action" => "edit_sign_symptom",$patient['Patient']['id'], "admin" => false)); ?>"
		method="post">
		<?php 
		echo $this->Form->input('SignSymptom1.patient_id', array('value' => $patient['Patient']['id'], 'type' => 'hidden'));
		echo $this->Form->input('SignSymptom1.min_date', array('value' => $minDate, 'type' => 'hidden'));
		echo $this->Form->input('SignSymptom1.max_date', array('value' => $maxDate, 'type' => 'hidden'));
			
		?>

		<tr>
			<th colspan="4"><?php echo __('Signs and Symptoms',true); ?><span
				style="text-align: right; float: right; cursor: pointer;"
				id="displaySignSymptom"><?php echo $this->Html->image('icons/edit-icon.png'); ?>
			</span></th>
		</tr>

		<tr>
			<td width="250"><?php echo __('Date',true); ?></td>
			<?php 
			for($i=0; $i < count($dateArray); $i++) {
?>
			<td width="100">
				<table width="100" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="75"><?php echo date("d/m/Y", strtotime($dateArray[$i])); ?>
						</td>
						<td width="25" align="right">&nbsp;</td>
					</tr>
				</table>
			</td>
			<?php 
    }
    ?>
		</tr>

		<?php 
		$signSymptom = array('Fever', 'Chills', 'Local Pain', 'Swelling', 'Redness', 'Pus/Discharge', 'Urinary Frequency', 'Respiratory Secretion', 'Dysuria', 'Suprapubic Tenderness', 'Oliguria', 'Pyuria', 'Cough', 'Blood clot', 'Other');
		$signSymptomTableField = array('fever', 'chills', 'local_pain', 'swelling', 'redness', 'pus_discharge', 'urinary_frequency', 'respiratory_secretion', 'dysuria', 'suprapubic_tenderness', 'oliguria', 'pyuria', 'cough', 'blood_clot', 'other');

	 foreach($getSignSymptom as $getSignSymptomVal) {
	       $signSymptomSubmitDate[] = $getSignSymptomVal['SignSymptom']['submit_date'];

	       $signSymptomWithDate['SignSymptom']['fever'][$getSignSymptomVal['SignSymptom']['submit_date']] = $getSignSymptomVal['SignSymptom']['fever'];
	       $signSymptomWithDate['SignSymptom']['chills'][$getSignSymptomVal['SignSymptom']['submit_date']] = $getSignSymptomVal['SignSymptom']['chills'];
	       $signSymptomWithDate['SignSymptom']['local_pain'][$getSignSymptomVal['SignSymptom']['submit_date']] = $getSignSymptomVal['SignSymptom']['local_pain'];
	       $signSymptomWithDate['SignSymptom']['swelling'][$getSignSymptomVal['SignSymptom']['submit_date']] = $getSignSymptomVal['SignSymptom']['swelling'];
	       $signSymptomWithDate['SignSymptom']['redness'][$getSignSymptomVal['SignSymptom']['submit_date']] = $getSignSymptomVal['SignSymptom']['redness'];
	       $signSymptomWithDate['SignSymptom']['pus_discharge'][$getSignSymptomVal['SignSymptom']['submit_date']] = $getSignSymptomVal['SignSymptom']['pus_discharge'];
	       $signSymptomWithDate['SignSymptom']['urinary_frequency'][$getSignSymptomVal['SignSymptom']['submit_date']] = $getSignSymptomVal['SignSymptom']['urinary_frequency'];
	       $signSymptomWithDate['SignSymptom']['respiratory_secretion'][$getSignSymptomVal['SignSymptom']['submit_date']] = $getSignSymptomVal['SignSymptom']['respiratory_secretion'];
	       $signSymptomWithDate['SignSymptom']['dysuria'][$getSignSymptomVal['SignSymptom']['submit_date']] = $getSignSymptomVal['SignSymptom']['dysuria'];
	       $signSymptomWithDate['SignSymptom']['suprapubic_tenderness'][$getSignSymptomVal['SignSymptom']['submit_date']] = $getSignSymptomVal['SignSymptom']['suprapubic_tenderness'];
	       $signSymptomWithDate['SignSymptom']['oliguria'][$getSignSymptomVal['SignSymptom']['submit_date']] = $getSignSymptomVal['SignSymptom']['oliguria'];
	       $signSymptomWithDate['SignSymptom']['pyuria'][$getSignSymptomVal['SignSymptom']['submit_date']] = $getSignSymptomVal['SignSymptom']['pyuria'];
	       $signSymptomWithDate['SignSymptom']['cough'][$getSignSymptomVal['SignSymptom']['submit_date']] = $getSignSymptomVal['SignSymptom']['cough'];
	       $signSymptomWithDate['SignSymptom']['blood_clot'][$getSignSymptomVal['SignSymptom']['submit_date']] = $getSignSymptomVal['SignSymptom']['blood_clot'];
	       $signSymptomWithDate['SignSymptom']['other'][$getSignSymptomVal['SignSymptom']['submit_date']] = $getSignSymptomVal['SignSymptom']['other'];

	        
     }

     for($i=0; $i<count($signSymptom); $i++) {
?>
		<tr>
			<td valign="middle"><?php echo $signSymptom[$i]; ?></td>
			<?php 

			for($j=0; $j < count($dateArray); $j++) {

        ?>

			<td width="100">
				<table width="100" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="75"><?php 
						if($dateArray[$j] >= date("Y-m-d", strtotime($patient['Patient']['form_received_on']))) {
	              	 echo $this->Form->input('SignSymptom1.'.$signSymptomTableField[$i].'.'.$dateArray[$j], array('default' =>  $signSymptomWithDate['SignSymptom'][$signSymptomTableField[$i]][$dateArray[$j]], 'options' => $options, 'label'=> false, 'div' => false, 'error' => false));
			        }
			        ?>
						</td>
						<td width="25" align="right">&nbsp;</td>
					</tr>
				</table>
			</td>

			<?php 
	      }
	      ?>
		</tr>
		<?php
	    }
	    ?>
		<tr>
			<td colspan="4" align="right"><?php echo $this->Form->submit(__('Submit'),
					array('class'=>'blueBtn','div'=>false)); ?>
			</td>
		</tr>
	</form>
</table>

<div>&nbsp;</div>
<div class="clr ht5"></div>

<table width="100%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm" id="displayNosocomialInfectionId">
	<tr>
		<th colspan="2"><?php echo __('Nosocomial Infection',true); ?><span
			style="text-align: right; float: right; cursor: pointer;"
			id="editNosocomialInfection"><?php echo $this->Html->image('icons/edit-icon.png'); ?>
		</span></th>
	</tr>
	<tr>
		<td valign="middle"><?php echo __('Surgical site infection',true); ?>
		</td>
		<td valign="middle" width="180"><?php
		echo $getNosocomialInfections['NosocomialInfection']['surgical_site_infection'];
		?>
		</td>
	</tr>
	<tr>
		<td valign="middle"><?php echo __('Urinary tract infection',true); ?>
		</td>
		<td valign="middle"><?php 
		echo $getNosocomialInfections['NosocomialInfection']['urinary_tract_infection'];
		?>
		</td>
	</tr>
	<tr>
		<td valign="middle"><?php echo __('Ventilator Associated
				Pneumonia',true); ?>
		</td>
		<td valign="middle"><?php 
		echo $getNosocomialInfections['NosocomialInfection']['ventilator_associated_pneumonia'];
		?>
		</td>
	</tr>
	<tr>
		<td valign="middle"><?php echo __('CLABSI',true); ?></td>
		<td valign="middle"><?php 
		echo $getNosocomialInfections['NosocomialInfection']['clabsi'];
		?>
		</td>
	</tr>
	<tr>
		<td valign="middle"><?php echo __('Thrombophlebitis',true); ?></td>
		<td valign="middle"><?php 
		echo $getNosocomialInfections['NosocomialInfection']['thrombophlebitis'];
		?>
		</td>
	</tr>
	<tr>
		<td valign="middle"><?php echo __('Other Nosocomial Infection',true);
		?>
		</td>
		<td valign="middle"><?php  
		echo $getNosocomialInfections['NosocomialInfection']['other_nosocomial_infection'];
		?>
		</td>
	</tr>
</table>

<table width="100%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm" id="editNosocomialInfectionId" id="edit"
	style="display: none;">
	<form name="nosocomialInfectionFrm" id="nosocomialInfectionFrm"
		action="<?php echo $this->Html->url(array("controller" => "hospital_acquire_infections", "action" => "edit_nosocomial_infections",$patient['Patient']['id'], "admin" => false)); ?>"
		method="post">
		<?php 
		echo $this->Form->input('NosocomialInfection.patient_id', array('value' => $patient['Patient']['id'], 'type' => 'hidden'));
		echo $this->Form->input('NosocomialInfection.submit_date', array('value' => $maxDate, 'type' => 'hidden'));
		echo $this->Form->input('NosocomialInfection.id', array('value' => $getNosocomialInfections['NosocomialInfection']['id'], 'type' => 'hidden'));
		?>
		<tr>
			<th colspan="2"><?php echo __('Nosocomial Infection',true); ?> <span
				style="text-align: right; float: right; cursor: pointer;"
				id="displayNosocomialInfection"><?php echo $this->Html->image('icons/edit-icon.png'); ?>
			</span></th>
		</tr>
		<tr>
			<td valign="middle"><?php echo __('Surgical site infection',true); ?>
			</td>
			<td valign="middle" width="180"><?php
			echo $this->Form->input('NosocomialInfection.surgical_site_infection', array('default' => $getNosocomialInfections['NosocomialInfection']['surgical_site_infection'], 'options' => $options, 'id' => 'surgical_site_infection','label'=> false, 'div' => false, 'error' => false));
			?>
			</td>
		</tr>
		<tr>
			<td valign="middle"><?php echo __('Urinary tract infection',true); ?>
			</td>
			<td valign="middle"><?php 
			echo $this->Form->input('NosocomialInfection.urinary_tract_infection', array('default' => $getNosocomialInfections['NosocomialInfection']['urinary_tract_infection'], 'options' => $options, 'id' => 'urinary_tract_infection','label'=> false, 'div' => false, 'error' => false));
			?>
			</td>
		</tr>
		<tr>
			<td valign="middle"><?php echo __('Ventilator Associated
					Pneumonia',true); ?>
			</td>
			<td valign="middle"><?php 
			echo $this->Form->input('NosocomialInfection.ventilator_associated_pneumonia', array('default' => $getNosocomialInfections['NosocomialInfection']['ventilator_associated_pneumonia'], 'options' => $options, 'id' => 'ventilator_associated_pneumonia','label'=> false, 'div' => false, 'error' => false));
			?>
			</td>
		</tr>
		<tr>
			<td valign="middle"><?php echo __('CLABSI',true); ?></td>
			<td valign="middle"><?php 
			echo $this->Form->input('NosocomialInfection.clabsi', array('default' => $getNosocomialInfections['NosocomialInfection']['clabsi'], 'options' => $options, 'id' => 'clabsi', 'label'=> false, 'div' =>false, 'error' => false));
			?>
			</td>
		</tr>
		<tr>
			<td valign="middle"><?php echo __('Thrombophlebitis',true); ?></td>
			<td valign="middle"><?php 
			echo $this->Form->input('NosocomialInfection.thrombophlebitis', array('default' => $getNosocomialInfections['NosocomialInfection']['thrombophlebitis'], 'options' => $options, 'id' => 'thrombophlebitis', 'label'=>false, 'div' => false, 'error' =>false));
			?>
			</td>
		</tr>
		<tr>
			<td valign="middle"><?php echo __('Other Nosocomial Infection',true);
			?>
			</td>
			<td valign="middle"><?php  
			echo $this->Form->input('NosocomialInfection.other_nosocomial_infection', array('default' => $getNosocomialInfections['NosocomialInfection']['other_nosocomial_infection'], 'options' => $options, 'id' => 'other_nosocomial_infection','label'=> false, 'div' =>false, 'error' => false));
			?>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="right"><?php echo $this->Form->submit(__('Submit'),
					array('class'=>'blueBtn','div'=>false)); ?>
			</td>
		</tr>
	</form>
</table>

<div>&nbsp;</div>
<div class="clr ht5"></div>
<table width="100%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm" id="displayMicroOrganismId">
	<tr>
		<th colspan="2"><?php echo __('Micro Organism',true); ?><span
			style="text-align: right; float: right; cursor: pointer;"
			id="editMicroOrganism"><?php echo $this->Html->image('icons/edit-icon.png'); ?>
		</span></th>
	</tr>
	<tr>
		<td valign="middle"><?php echo __('MRSA',true); ?></td>
		<td valign="middle" width="180"><?php echo $getMicroOrganism['MicroOrganism']['mrsa']; ?>
		</td>
	</tr>
	<tr>
		<td valign="middle"><?php echo __('VRE',true); ?></td>
		<td valign="middle"><?php 
		echo $getMicroOrganism['MicroOrganism']['vre'];
		?>
		</td>
	</tr>
</table>

<table width="100%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm" id="editMicroOrganismId" style="display: none;">
	<form name="microOrganismFrm" id="microOrganismFrm"
		action="<?php echo $this->Html->url(array("controller" => "hospital_acquire_infections", "action" => "edit_micro_organism",$patient['Patient']['id'],  "admin" => false)); ?>"
		method="post">
		<?php 
		echo $this->Form->input('MicroOrganism.patient_id', array('value' => $patient['Patient']['id'], 'type' => 'hidden'));
		echo $this->Form->input('MicroOrganism.submit_date', array('value' => $maxDate, 'type' => 'hidden'));
		echo $this->Form->input('MicroOrganism.id', array('value' => $getMicroOrganism['MicroOrganism']['id'], 'type' => 'hidden'));
		?>
		<tr>
			<th colspan="2"><?php echo __('Micro Organism',true); ?><span
				style="text-align: right; float: right; cursor: pointer;"
				id="displayMicroOrganism"><?php echo $this->Html->image('icons/edit-icon.png'); ?>
			</span></th>
		</tr>
		<tr>
			<td valign="middle"><?php echo __('MRSA',true); ?></td>
			<td valign="middle" width="180"><?php 
			echo $this->Form->input('MicroOrganism.mrsa', array('default' => $getMicroOrganism['MicroOrganism']['mrsa'], 'options' =>$options, 'id' => 'mrsa', 'label'=> false, 'div' => false, 'error'=> false));
			?>
			</td>
		</tr>
		<tr>
			<td valign="middle"><?php echo __('VRE',true); ?></td>
			<td valign="middle"><?php 
			echo $this->Form->input('MicroOrganism.vre', array('default' => $getMicroOrganism['MicroOrganism']['vre'],'options' => $options, 'id' => 'vre', 'label'=> false,'div' => false, 'error' => false));
			?>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="right"><?php echo $this->Form->submit(__('Submit'),
					array('class'=>'blueBtn','div'=>false)); ?>
			</td>
		</tr>
	</form>
</table>


<div>&nbsp;</div>
<div class="clr ht5"></div>
<div class="btns">

	<?php 

	if(isset($redirectTo)){
		echo $this->Html->link(__('Cancel'),array('controller'=>'nursings','action'=>'patient_information',$patient['Patient']['id']),array('class'=>'blueBtn','div'=>false));
	} else {
		echo $this->Html->link(__('Cancel'),array('controller'=>'patients','action'=>'patient_information',$patient['Patient']['id']),array('class'=>'blueBtn','div'=>false));
	}
	?>
</div>

<!-- intrinsic_date -->

<script>

jQuery(document).ready(function(){
	$("#editIntrinsicRiskFactor").click(function () {  
        $("#editIntrinsicRiskFactorId").show();
		$("#displayIntrinsicRiskFactorId").hide();
    });
    $("#displayIntrinsicRiskFactor").click(function () { 
        $("#displayIntrinsicRiskFactorId").show();
		$("#editIntrinsicRiskFactorId").hide();
    });
	$("#editNosocomialInfection").click(function () {  
        $("#editNosocomialInfectionId").show();
		$("#displayNosocomialInfectionId").hide();
    });
    $("#displayNosocomialInfection").click(function () { 
        $("#displayNosocomialInfectionId").show();
		$("#editNosocomialInfectionId").hide();
    });

	$("#editMicroOrganism").click(function () {  
        $("#editMicroOrganismId").show();
		$("#displayMicroOrganismId").hide();
    });
    $("#displayMicroOrganism").click(function () { 
        $("#displayMicroOrganismId").show();
		$("#editMicroOrganismId").hide();
    });
	$("#editSignSymptom").click(function () {  
        $("#editSignSymptomId").show();
		$("#displaySignSymptomId").hide();
    });
    $("#displaySignSymptom").click(function () { 
        $("#displaySignSymptomId").show();
		$("#editSignSymptomId").hide();
    });
	$("#editPatientExposure").click(function () {  
        $("#editPatientExposureId").show();
		$("#displayPatientExposureId").hide();
    });
    $("#displayPatientExposure").click(function () { 
        $("#displayPatientExposureId").show();
		$("#editPatientExposureId").hide();
    });

	
	jQuery("#hospitalacquireinfectionfrm").validationEngine();
	$( "#intrinsic_date" ).datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',			 
		dateFormat:'<?php echo $this->General->GeneralDate();?>',
		buttonText:'Date of Incident',
		minDate:new Date(<?php echo date("Y", strtotime($patient['Patient']['form_received_on']))?>,<?php echo date("m", strtotime($patient['Patient']['form_received_on'])) -1?>,<?php echo date("d", strtotime($patient['Patient']['form_received_on']))?>),
		onSelect: function(){
			var dateval = $("#intrinsic_date").val();
			var patientid = $("#patientid").val();
			window.location.href = '<?php echo $this->Html->url('/hospital_acquire_infections/index/'); ?>'+patientid+'/'+dateval;
           // $("#intrinsic_date").action = "<?php echo $this->Html->url('/hospital_acquire_infections/index'); ?>"
			//alert($( "#intrinsic_date" ).val());
		}
	});
	
	

});

</script>


