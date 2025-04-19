
<style>
.trShow{
background-color:#ccc;

}
.light:hover {
background-color: #F7F6D9;
text-decoration:none;
    color: #000000; 
}
</style>
<table width="100%" class="formFull formFullBorder">
	<tr class="trShow" >
		<td>Title</td>
	</tr>
	
	
	<tr class="light">
		<?php 
		if(!empty($pastHistory[0]['PastMedicalHistory']['id'])){?>
			<td class="" id="Past_Medical_History_link"><?php  echo $this->Html->link('Past Medical History',array('controller'=>'Diagnoses','action'=>'significantHistory',$patientId,$personId,'#'=>'Past_Medical_History_link'));?></td>
		<?php }?>
	</tr>
	<tr class="light">
		<?php 
		if(!empty($procedureHistory['ProcedureHistory']['id'])){?>
			<td class="" id="Past_Surgical_History_link"><?php  echo $this->Html->link('Past Surgical History',array('controller'=>'Diagnoses','action'=>'significantHistory',$patientId,$personId,'#'=>'Past_Surgical_History_link'));?></td>
		<?php }?>
	</tr>
	<tr class="light">
		<?php 
		if(!empty($getMedicationRecords['NewCropPrescription']['id'])){?>
			<td class="" id="Past_Medication_link"><?php  echo $this->Html->link('Past Medication',array('controller'=>'Diagnoses','action'=>'significantHistory',$patientId,$personId,'#'=>'Past_Medication_link'));?></td>
		<?php }?>
	</tr>
	<tr class="light">
		<?php 
		if(!empty($getPatientSmoking['PatientSmoking']['id'])){?>
			<td class="" id="Social_History_link"><?php  echo $this->Html->link('Social History',array('controller'=>'Diagnoses','action'=>'significantHistory',$patientId,$personId,'#'=>'Social_History_link'));?></td>
		<?php }?>
	</tr>
	<tr class="light">
		<?php 
		if(!empty($getpatientfamilyhistory['FamilyHistory']['id'])){?>
			<td class="" id="Family_History_link"><?php  echo $this->Html->link('Family History',array('controller'=>'Diagnoses','action'=>'significantHistory',$patientId,$personId,'#'=>'Family_History_link'));?></td>
		<?php }?>
	</tr>
<!--  	<tr class="light">
		<?php 
	//	if(!empty($getPastMedicalRecord['PastMedicalRecord']['id'])){?>
			<td class="" id="Obstetric_History_link"><?php // echo $this->Html->link('Obstetric History',array('controller'=>'Diagnoses','action'=>'significantHistory',$patientId));?></td>
		<?php // }?>
	</tr>-->
	<?php if($getSex['Person']['sex'] == 'Female'){?>
	<tr class="light">
		<?php 
		if(!empty($getGynecologyHistory['PastMedicalRecord']['present_symptom']) || !empty($getGynecologyHistory['PastMedicalRecord']['past_infection']) ||
		   !empty($getGynecologyHistory['PastMedicalRecord']['hx_abnormal_pap']) || !empty($getGynecologyHistory['PastMedicalRecord']['hx_abnormal_pap_yes']) ||
		   !empty($getGynecologyHistory['PastMedicalRecord']['last_mammography']) || !empty($getGynecologyHistory['PastMedicalRecord']['last_mammography_yes']) ||
		   !empty($getGynecologyHistory['PastMedicalRecord']['hx_cervical_bx']) || !empty($getGynecologyHistory['PastMedicalRecord']['hx_fertility_drug']) ||
		   !empty($getGynecologyHistory['PastMedicalRecord']['hx_hrt_use']) || !empty($getGynecologyHistory['PastMedicalRecord']['hx_irregular_menses']) ||
		   !empty($getGynecologyHistory['PastMedicalRecord']['lmp']) || !empty($getGynecologyHistory['PastMedicalRecord']['symptom_lmp'])){?>
			<td class="" id="Gynecology_History_link"><?php  echo $this->Html->link('Gynecology History',array('controller'=>'Diagnoses','action'=>'significantHistory',$patientId,$personId,'#'=>'Gynecology_History_link'));?></td>
		<?php }?>
	</tr>
	<?php }?>
	<tr class="light">
		<?php 
		if(!empty($getSexualActivity['PastMedicalRecord']['sexually_active']) || !empty($getSexualActivity['PastMedicalRecord']['birth_controll']) ||
		   !empty($getSexualActivity['PastMedicalRecord']['breast_self_exam']) || !empty($getSexualActivity['PastMedicalRecord']['new_partner']) ||
		   !empty($getSexualActivity['PastMedicalRecord']['partner_notification']) || !empty($getSexualActivity['PastMedicalRecord']['hiv_education']) ||
		   !empty($getSexualActivity['PastMedicalRecord']['pap_education']) || !empty($getSexualActivity['PastMedicalRecord']['gyn_referral'])){?>
			<td class="" id="Sexual_Activity_link"><?php  echo $this->Html->link('Sexual Activity',array('controller'=>'Diagnoses','action'=>'significantHistory',$patientId,$personId,'#'=>'Sexual_Activity_link'));?></td>
		<?php }?>
	</tr>
	
</table>

