<style>
.sub_title {
	background: none repeat scroll 0 0 #D2EBF2;
	color: #31859C !important;
}

.table_format {
	border: 1px solid #4C5E64;
}

.table_format_btm {
	border-top: 1px solid #4C5E64;
	border-right: 1px solid #4C5E64;
	border-bottom: 0px;
	border-left: 1px solid #4C5E64;
	padding-top: 10px;
	padding-left: 4px;;
	padding-right: 5px;
}

.table_format_top {
	border-top: 0px;
	border-right: 1px solid #4C5E64;
	border-bottom: 1px solid #4C5E64;
	border-left: 1px solid #4C5E64;
	padding-left: 10px;
	padding-right: 10px;
}

.heading {
	/*background: -moz-linear-gradient(center top, #3E474A, #343D40) repeat
		scroll 0 0 rgba(0, 0, 0, 0);*/
}

.space {
	
}
</style>
<?php if(!empty($medicalHistory)){ //debug($medicalHistory);?>
<table width="100%" cellpadding="0" cellspacing="0" border="0"
	align='left' class="formFull formFullBorder">


	<?php if(!empty($medicalHistory['PastMedicalHistory']['0']['illness'])){?>
	<tr>
		<td>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"
				align='left' class="formFull formFullBorder table_format_btm">
				<tr>
					<td width="7%" class="heading"><strong><?php echo __("Past Medical History"); ?>
					</strong>
					</td>
					<td width="17%" class="heading"></td>
					<td width="5%" class="heading"></td>
					<td width="5%" class="heading"></td>
					<td width="17%" class="heading"></td>

				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"
				align='left' class="formFull formFullBorder table_format_top">
				<tr>

					<td width="17% !important" class="sub_title"><strong><?php echo __("Problem");?>
					</strong>
					</td>
					<td width="5%" class="sub_title"><strong><?php echo __("Status");?>
					</strong>
					</td>
					<td width="5%" class="sub_title"><strong><?php echo __("Duration");?>
					</strong>
					</td>
					<td width="17%" class="sub_title"><strong><?php echo __("Comment");?>
					</strong>
					</td>
				</tr>
				<?php foreach($medicalHistory['PastMedicalHistory'] as $history){ ?>
				<tr>

					<td><?php echo $history['illness'];?>
					</td>
					<td><?php echo $history['status'];?>
					</td>
					<td><?php echo $history['duration'];?>
					</td>
					<td><?php echo $history['comment'];?>
					</td>
				</tr>
				<?php } ?>
			</table>
		</td>
	</tr>
	<?php }?>


	<?php if(!empty($medicalHistory['PastMedicalRecord']['preventive_care'])){?>
	<tr>

		<td>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"
				align='left' class="formFull formFullBorder table_format_btm">
				<tr>
					<td width="8%" class="heading"><strong><?php echo __("Preventive Care :"); ?>
					</strong>
					</td>
					<td><?php echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$medicalHistory['PastMedicalRecord']['preventive_care'];?>
						<?php // echo $medicalHistory['PastMedicalRecord']['preventive_care'];?>
					</td>
				</tr>
			</table>
		</td>
	</tr>

	<!-- <tr>
	
		<td>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"
				align='left' class="formFull formFullBorder table_format_top">
				<tr>
					<td width="7%" ><strong><?php //echo __("Preventive Care"); ?> </strong>
					</td>
					<td width="44%" class="sub_title"><?php echo $medicalHistory['PastMedicalRecord']['preventive_care'];?>
					</td>
				</tr>
			</table>
		</td>
	</tr> -->
	<?php
}

?>

	<?php if(!empty($medicalHistory['FamilyHistory']['problemf']) || !empty($medicalHistory['FamilyHistory']['problemm']) || !empty($medicalHistory['FamilyHistory']['problemb']) || !empty($medicalHistory['FamilyHistory']['problems']) || !empty($medicalHistory['FamilyHistory']['problemson']) || !empty($medicalHistory['FamilyHistory']['problemd'])){ ?>
	<tr>
		<td>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"
				align='left' class="formFull formFullBorder table_format_btm">
				<tr>
					<td width="3%" class="heading"><strong><?php echo __("Family History"); ?>
					</strong>
					</td>
					<td width="1%" class="heading"></td>
					<td width="8%" class="heading"></td>
					<td width="1%" class="heading"></td>
					<td width="8%" class="heading"></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr class="space">
		<td>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"
				align='left' class="formFull formFullBorder table_format_top">
				<tr>

					<td width="1%" class="sub_title"><strong><?php echo __("Relation");?>
					</strong>
					</td>
					<td width="8%" class="sub_title"><strong><?php echo __("Problem");?>
					</strong>
					</td>
					<td width="1%" class="sub_title"><strong><?php echo __("Status");?>
					</strong>
					</td>
					<td width="8%" class="sub_title"><strong><?php echo __("Comment");?>
					</strong>
					</td>
				</tr>
				<?php if(!empty($medicalHistory['FamilyHistory']['problemf'])){ ?>
				<tr>

					<td><?php echo __("Father");?>
					</td>
					<td><?php echo $medicalHistory['FamilyHistory']['problemf'];?>
					</td>
					<td><?php echo $medicalHistory['FamilyHistory']['statusf'];?>
					</td>
					<td><?php echo $medicalHistory['FamilyHistory']['commentsf'];?>
					</td>
				</tr>
				<?php } ?>

				<?php if(!empty($medicalHistory['FamilyHistory']['problemm'])){ ?>
				<tr>

					<td><?php echo __("Mother");?>
					</td>
					<td><?php echo $medicalHistory['FamilyHistory']['problemm'];?>
					</td>
					<td><?php echo $medicalHistory['FamilyHistory']['statusm'];?>
					</td>
					<td><?php echo $medicalHistory['FamilyHistory']['commentsm'];?>
					</td>
				</tr>
				<?php } ?>

				<?php if(!empty($medicalHistory['FamilyHistory']['problemb'])){ ?>
				<tr>

					<td><?php echo __("Brother");?>
					</td>
					<td><?php echo $medicalHistory['FamilyHistory']['problemb'];?>
					</td>
					<td><?php echo $medicalHistory['FamilyHistory']['statusb'];?>
					</td>
					<td><?php echo $medicalHistory['FamilyHistory']['commentsb'];?>
					</td>
				</tr>
				<?php } ?>

				<?php if(!empty($medicalHistory['FamilyHistory']['problems'])){ ?>
				<tr>

					<td><?php echo __("Sister");?>
					</td>
					<td><?php echo $medicalHistory['FamilyHistory']['problems'];?>
					</td>
					<td><?php echo $medicalHistory['FamilyHistory']['statuss'];?>
					</td>
					<td><?php echo $medicalHistory['FamilyHistory']['commentss'];?>
					</td>
				</tr>
				<?php } ?>

				<?php if(!empty($medicalHistory['FamilyHistory']['problemson'])){ ?>
				<tr>

					<td><?php echo __("Son");?>
					</td>
					<td><?php echo $medicalHistory['FamilyHistory']['problemson'];?>
					</td>
					<td><?php echo $medicalHistory['FamilyHistory']['statusson'];?>
					</td>
					<td><?php echo $medicalHistory['FamilyHistory']['commentsson'];?>
					</td>
				</tr>
				<?php } ?>

				<?php if(!empty($medicalHistory['FamilyHistory']['problemd'])){ ?>
				<tr>

					<td><?php echo __("Daughter");?>
					</td>
					<td><?php echo $medicalHistory['FamilyHistory']['problemd'];?>
					</td>
					<td><?php echo $medicalHistory['FamilyHistory']['statusd'];?>
					</td>
					<td><?php echo $medicalHistory['FamilyHistory']['commentsd'];?>
					</td>
				</tr>
				<?php } ?>
			</table>
		</td>
	</tr>
	<?php } ?>

	<?php  if(!empty($medicalHistory['PastMedicalRecord'])){?>
	<?php if($patientGender == 'Female' or $patientGender == 'female'){?>
	<tr>
		<td>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"
				align='left' class="formFull formFullBorder table_format_btm">
				<tr>
					<td width="14%" class="heading"><strong><?php echo __("Obstetric History"); ?>
					</strong>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"
				align='left' class="formFull formFullBorder table_format_top">
				<tr>
					<td><?php if(!empty($medicalHistory['PastMedicalRecord']['age_menses'])){ ?>
				
				
				<tr>

					<td width="18%"><?php echo __("Age Onset of Menses:");?></td>
					<td><?php echo $medicalHistory['PastMedicalRecord']['age_menses']." Years";?>
					</td>
				</tr>
				<?php } ?>
				<?php if(!empty($medicalHistory['PastMedicalRecord']['length_period'])){ ?>
				<tr>

					<td><?php echo __("Length of Periods:");?></td>
					<td><?php echo $medicalHistory['PastMedicalRecord']['length_period']." Days";?>
					</td>
				</tr>
				<?php } ?>
				<?php if(!empty($medicalHistory['PastMedicalRecord']['days_betwn_period'])){ ?>
				<tr>

					<td><?php echo __('Number of days between Periods:');?></td>
					<td><?php echo $medicalHistory['PastMedicalRecord']['days_betwn_period']." Days";?>
					</td>

				</tr>
				<?php } ?>

				<?php if(!empty($medicalHistory['PastMedicalRecord']['recent_change_period'])){ ?>
				<tr>

					<td><?php echo __('Any recent changes in Periods:');?></td>
					<td><?php echo $medicalHistory['PastMedicalRecord']['recent_change_period'];?>
					</td>

				</tr>
				<?php } ?>

				<?php if(!empty($medicalHistory['PastMedicalRecord']['age_menopause'])){ ?>
				<tr>

					<td><?php echo __('Age at Menopause:');?></td>
					<td><?php echo $medicalHistory['PastMedicalRecord']['age_menopause']." Years";?>
					</td>

				</tr>
				<?php } ?>
			</table>
		</td>
	</tr>
	<?php if(!empty($medicalHistory['PregnancyCount'])){?>
	<tr>
		<td><table width="100%" cellpadding="0" cellspacing="0" border="0"
				align='left' class="formFull formFullBorder table_format_btm">
				<tr>

					<td width="" class="heading"><strong><?php echo __("Number of Pregnancies"); ?>
					</strong>
					</td>
					<td class="heading"></td>
					<td class="heading"></td>
					<td class="heading"></td>
					<td class="heading"></td>
					<td class="heading"></td>
					<td class="heading"></td>
					<td class="heading"></td>
				</tr>
			</table></td>
	</tr>
	<tr>
		<td><table width="100%" cellpadding="0" cellspacing="0" border="0"
				align='left' class="formFull formFullBorder table_format_top">
				<tr>

					<td width="2%" class="sub_title"><strong><?php echo __("Sr. No.");?> </strong>
					</td>
					<td width="4%" class="sub_title"><strong><?php echo __("DOB");?> </strong>
					</td>
					<td width="5%" class="sub_title"><strong><?php echo __("Weight (in lbs)");?>
					</strong>
					</td>
					<td width="5%" class="sub_title"><strong><?php echo __("Baby's Gender");?>
					</strong>
					</td>
					<td width="6%" class="sub_title"><strong><?php echo __("Weeks Pregnant");?>
					</strong>
					</td>
					<td width="4%" class="sub_title"><strong><?php echo __("Type of Delivery");?>
					</strong>
					</td>
					<td width="14%" class="sub_title"><strong><?php echo __("Complications");?>
					</strong>
					</td>
				</tr>
				<?php 
				$counts=0;
				foreach($medicalHistory['PregnancyCount'] as $history){ 
				$counts++;
				?>
				<tr>

					<td><?php echo ($counts);?>
					</td>
					<td><?php echo $this->DateFormat->formatDate2Local($history['date_birth'],Configure::read('date_format'),false);?>
					</td>
					<td><?php echo $history['weight'];?>
					</td>
					<td><?php echo $history['baby_gender'];?>
					</td>
					<td><?php echo $history['week_pregnant'];?>
					</td>
					<td><?php echo $history['type_delivery'];?>
					</td>
					<td><?php echo $history['complication'];?>
					</td>
				</tr>
				<?php }?>
			</table></td>
	</tr>
	<?php }//pregCount?>
	<?php if(!empty($medicalHistory['PastMedicalRecord']['abortions_miscarriage'])){?>
	<tr>
		<td><table width="100%" cellpadding="0" cellspacing="0" border="0"
				align='left' class="formFull formFullBorder table_format">
				<tr>
					<td width="17%" class="heading"><strong><?php echo __('Abortions. Still Births. Miscarriages:');?>
					</strong></td>
					<td><?php echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$medicalHistory['PastMedicalRecord']['abortions_miscarriage'];?>
					</td>
				</tr>
			</table></td>
	</tr>
	<?php } ?>

	<?php if(!empty($medicalHistory['PastMedicalRecord'])){?>
	<tr>
		<td><table width="100%" cellpadding="0" cellspacing="0" border="0"
				align='left' class="formFull formFullBorder table_format">
				<tr>
					<td width="14%" class="heading"><strong><?php echo __('Gynecology History');?>
					</strong></td>
					<td width="21%" class="heading"></td>
					<td class="heading"></td>
				</tr>
				<?php if(!empty($medicalHistory['PastMedicalRecord']['present_symptom'])){?>
				<tr>

					<td width="21%"><?php echo __('Present Symptoms:');?>
					</td>
					<td><?php echo $medicalHistory['PastMedicalRecord']['present_symptom'];?>
					</td>
				</tr>
				<?php } ?>
				<?php if(!empty($medicalHistory['PastMedicalRecord']['past_infection'])){?>
				<tr>

					<td><?php echo __('Past Infections:');?>
					</td>
					<td><?php echo $medicalHistory['PastMedicalRecord']['past_infection'];?>
					</td>
				</tr>
				<?php } ?>
				<?php if(!empty($medicalHistory['PastMedicalRecord']['hx_abnormal_pap'])){?>
				<tr>

					<td>History of abnormal <font class="tooltip"
						title="Papanicolaou smear">PAP smear</font>:
					</td>
					<td><?php echo $medicalHistory['PastMedicalRecord']['hx_abnormal_pap'];?>
					</td>
				</tr>
				<?php } ?>
				<?php if(!empty($medicalHistory['PastMedicalRecord']['hx_cervical_bx'])){?>
				<tr>

					<td><?php echo __('History of cervical biopsy:');?>
					</td>
					<td><?php echo $medicalHistory['PastMedicalRecord']['hx_cervical_bx'];?>
					</td>
				</tr>
				<?php } ?>
				<?php if(!empty($medicalHistory['PastMedicalRecord']['hx_fertility_drug'])){?>
				<tr>

					<td><?php echo __('History of fertility drugs:');?>
					</td>
					<td><?php echo $medicalHistory['PastMedicalRecord']['hx_fertility_drug'];?>
					</td>
				</tr>
				<?php } ?>
				<?php if(!empty($medicalHistory['PastMedicalRecord']['hx_hrt_use'])){?>
				<tr>

					<td>History of <font class="tooltip"
						title="Hormone Replacement Therapy "> HRT </font> use:
					</td>
					<td><?php echo $medicalHistory['PastMedicalRecord']['hx_hrt_use'];?>
					</td>
				</tr>
				<?php } ?>
				<?php if(!empty($medicalHistory['PastMedicalRecord']['hx_irregular_menses'])){?>
				<tr>

					<td><?php echo __('History of irregular menses:');?>
					</td>
					<td><?php echo $medicalHistory['PastMedicalRecord']['hx_irregular_menses'];?>
					</td>
				</tr>
				<?php } ?>
				<?php if(!empty($medicalHistory['PastMedicalRecord']['lmp'])){?>
				<tr>

					<td><font class="tooltip" title="Last Menstrual Period "> L.M.P. </font>:</td>
					<td><?php echo $this->DateFormat->formatDate2Local($medicalHistory['PastMedicalRecord']['lmp'],Configure::read('date_format'),false);?>
					</td>
				</tr>
				<?php } ?>
				<?php if(!empty($medicalHistory['PastMedicalRecord']['symptom_lmp'])){?>
				<tr>

					<td>Symptoms since <font class="tooltip"
						title="Last Menstrual Period "> L.M.P. </font>:
					</td>
					<td><?php echo $medicalHistory['PastMedicalRecord']['symptom_lmp'];?>
					</td>
				</tr>
				<?php } ?>
				<!--  -->
				<tr>
					<td class="heading"><strong><?php echo __('Sexual Activity');?> </strong>
					</td>
					<td class="heading"></td>
					<td class="heading"></td>
				</tr>
				<?php if(!empty($medicalHistory['PastMedicalRecord']['sexually_active'])){?>
				<tr>

					<td><?php echo __('Are you sexually active?');?>
					</td>
					<td><?php echo $medicalHistory['PastMedicalRecord']['sexually_active'];?>
					</td>
				</tr>
				<?php } ?>
				<?php if(!empty($medicalHistory['PastMedicalRecord']['birth_controll'])){?>
				<tr>

					<td><?php echo __('Do you use birth control?');?>
					</td>
					<td><?php echo $medicalHistory['PastMedicalRecord']['birth_controll'];?>
					</td>
				</tr>
				<?php } ?>
				<?php if(!empty($medicalHistory['PastMedicalRecord']['breast_self_exam'])){?>
				<tr>

					<td><?php echo __('Do you do regular Breast self-exam?');?>
					</td>
					<td><?php echo $medicalHistory['PastMedicalRecord']['breast_self_exam'];?>
					</td>
				</tr>
				<?php } ?>
				<?php if(!empty($medicalHistory['PastMedicalRecord']['new_partner'])){?>
				<tr>

					<td><?php echo __('New Partners?');?>
					</td>
					<td><?php echo $medicalHistory['PastMedicalRecord']['new_partner'];?>
					</td>
				</tr>
				<?php } ?>
				<?php if(!empty($medicalHistory['PastMedicalRecord']['partner_notification'])){?>
				<tr>

					<td><?php echo __('Partner Notification :');?>
					</td>
					<td><?php echo ($medicalHistory['PastMedicalRecord']['partner_notification'])? "Yes" : "No";?>
					</td>
				</tr>
				<?php } ?>
				<?php if(!empty($medicalHistory['PastMedicalRecord']['hiv_education'])){?>
				<tr>

					<td><font class="tooltip" title="Human Immunodeficiency Virus"> HIV
					</font> Education Given:</td>
					<td><?php echo $medicalHistory['PastMedicalRecord']['hiv_education'];?>
					</td>
				</tr>
				<?php } ?>
				<?php if(!empty($medicalHistory['PastMedicalRecord']['pap_education'])){?>
				<tr>

					<td><font class="tooltip" title="Papanicolaou"> PAP </font>/<font
						class="tooltip" title="Sexually Transmitted Diseases"> STD </font>
						Education Given:</td>
					<td><?php echo $medicalHistory['PastMedicalRecord']['pap_education'];?>
					</td>
				</tr>
				<?php } ?>
				<?php if(!empty($medicalHistory['PastMedicalRecord']['gyn_referral'])){?>
				<tr>

					<td><font class="tooltip" title="Gynecology"> GYN </font> Referral:</td>
					<td><?php echo $medicalHistory['PastMedicalRecord']['gyn_referral'];?>
					</td>
				</tr>
				<?php } ?>
			</table></td>
	</tr>
	<?php } ?>

	<?php }?>

	<?php } ?>
	<?php if(!empty($medicalHistory['PatientPersonalHistory'])){?>
	<tr>
		<td><table width="100%" cellpadding="0" cellspacing="0" border="0"
				align='left' class="formFull formFullBorder table_format">
				<tr>

					<td class="heading" width="17%"><strong><?php echo __('Social History');?>
					</strong></td>

					<td class="heading" width="65%"></td>
				</tr>
				<tr>

					<td><strong><?php echo __('Smoking:');?> </strong>
					</td>
					<td width="65%"><?php $smokingStatus = ($medicalHistory['PatientPersonalHistory']['smoking'] == 1)? "Yes" : "No"; echo $smokingStatus;?>
					</td>
				</tr>
				<?php if($smokingStatus == 'No' && !empty($medicalHistory['SmokingStatusOncs']['description'])){?>
				<tr>

					<td><?php echo __('Smoking Description:');?>
					</td>
					<td><?php echo $medicalHistory['SmokingStatusOncs']['description'];?>
					</td>
				</tr>
				<?php } ?>
				<?php if($smokingStatus == 'Yes'){?>
				<tr>

					<td><?php echo __('Smoking Quantity:');?>
					</td>
					<td><?php echo __($medicalHistory['PatientPersonalHistory']['smoking_desc']);?>
					</td>
				</tr>
				<tr>

					<td><?php echo __('Smoking Description:');?>
					</td>
					<td><?php echo $medicalHistory['SmokingStatusOncs']['description'];?>
					</td>
				</tr>
				<tr>

					<td><?php echo __('Smoking Detail:');?>
					</td>
					<td><?php echo $medicalHistory['SmokingStatusOncs']['detail'];?>
					</td>
				</tr>
				<?php } ?>

				<tr>

					<td><strong><?php echo __('Alcohol:');?> </strong>
					</td>
					<td><?php $alcoholStatus = ($medicalHistory['PatientPersonalHistory']['alcohol'] == 1)? "Yes" : "No"; echo $alcoholStatus;?>
					</td>
				</tr>
				<?php if($alcoholStatus == 'Yes'){?>
				<tr>

					<td><?php echo __('Alcohol Quantity:');?>
					</td>
					<td><?php echo __($medicalHistory['PatientPersonalHistory']['alcohol_desc']);?>
					</td>
				</tr>
				<tr>

					<td><?php echo __('Alcohol Description:');?>
					</td>
					<td><?php echo $medicalHistory['PatientPersonalHistory']['alcohol_fre'];?>
					</td>
				</tr>
				<?php } ?>

				<tr>

					<td><strong><?php echo __('Substance Use:');?> </strong>
					</td>
					<td><?php $drugsStatus = ($medicalHistory['PatientPersonalHistory']['drugs'] == 1)? "Yes" : "No"; echo $drugsStatus;?>
					</td>
				</tr>
				<?php if($drugsStatus == 'Yes'){?>
				<tr>

					<td><?php echo __('Substance Quantity:');?>
					</td>
					<td><?php echo __($medicalHistory['PatientPersonalHistory']['drugs_desc']);?>
					</td>

				</tr>
				<tr>

					<td><?php echo __('Substance Description:');?>
					</td>
					<td><?php echo $medicalHistory['PatientPersonalHistory']['drugs_fre'];?>
					</td>
				</tr>
				<?php } ?>
				<tr>

					<td><?php echo __('Retired:');?>
					</td>
					<td><?php echo $medicalHistory['PatientPersonalHistory']['retired'];?>
					</td>
				</tr>
				<tr>

					<td><strong><?php echo __('Caffiene Usage:');?> </strong>
					</td>
					<td><?php $tobaccoStatus = ($medicalHistory['PatientPersonalHistory']['tobacco'] == 1)? "Yes" : "No"; echo $tobaccoStatus;?>
					</td>
				</tr>
				<?php if($tobaccoStatus == 'Yes'){?>
				<tr>

					<td><?php echo __('Caffiene Quantity:');?>
					</td>
					<td><?php echo __($medicalHistory['PatientPersonalHistory']['tobacco_desc']);?>
					</td>

				</tr>
				<tr>

					<td><?php echo __('Caffiene Description:');?>
					</td>
					<td><?php echo $medicalHistory['PatientPersonalHistory']['tobacco_fre'];?>
					</td>
				</tr>
				<?php } ?>

				<tr>

					<td><strong><?php echo __('Diet:');?> </strong>
					</td>
					<td><?php $dietStatus = ($medicalHistory['PatientPersonalHistory']['diet'] == 1)? "Non-Veg" : "Veg"; echo $dietStatus;?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<?php } //debug($medicalHistory['ProcedureHistory']);
?>

	<?php if(!empty($medicalHistory['ProcedureHistory'])){?>
	<tr>
		<td><table width="100%" cellpadding="0" cellspacing="0" border="0"
				align='left' class="formFull formFullBorder table_format_btm">
				<tr>
					<td width="6%" class="heading"><strong><?php echo __("Procedure History"); ?>
					</strong>
					</td>
					<td width="6%" class="heading">
					
					<td width="6%" class="heading"></td>
					<td width="6%" class="heading"></td>
					<td width="6%" class="heading"></td>
					<td width="13%" class="heading"></td>
				</tr>
			</table></td>
	</tr>
	<tr>
		<td><table width="100%" cellpadding="0" cellspacing="0" border="0"
				align='left' class="formFull formFullBorder table_format_top">
				<tr>

					<td width="6%" class="sub_title"><strong><?php echo __("Procedure");?>
					</strong>
					</td>
					<td width="6%" class="sub_title" align="center"><strong><?php echo __("Provider");?>
					</strong>
					</td>
					<td width="6%" class="sub_title" align="center"><strong><?php echo __("Age");?> </strong>
					</td>
					<td width="6%" class="sub_title" align="center"><strong><?php echo __("Date");?> </strong>
					</td>
					<td width="13%" class="sub_title" ><strong><?php echo __("Comment");?>
					</strong>
					</td>
				</tr>
				<?php foreach($medicalHistory['ProcedureHistory'] as $history){ ?>
				<tr>
					<td width="13%"><?php echo $procedure_name = !empty($history['procedure'])?$trarifName[trim($history['procedure'])]:$history['procedure_name']  ;?>
					</td>
					<td width="8%" align="center"><?php echo $provider_name = !empty($history['provider'])?$optDoctor[$history['provider']]:$history['provider_name'];?>
					</td>
					<td align="center"><?php echo $history['age_value']." ".$history['age_unit'];?></td>
					<td align="center"><?php echo $this->DateFormat->formatDate2LocalForReport($history['procedure_date'],Configure::read('date_format'),false);?>
					</td>
					<td><?php echo $history['comment'];?></td>
				</tr>
				<?php }?>
				<?php }//PastMedicalRecord ?>
			</table>
		</td>
	</tr>
</table>
<?php } else{?>
<table width="100%" cellpadding="0" cellspacing="0" border="0"
	align='left' class="formFull formFullBorder">
	<tr>
		<td><?php echo __('No data recorded'); ?></td>
	</tr>
</table>
<?php }?>
