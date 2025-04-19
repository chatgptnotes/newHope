<?php if($status == "success"){?>
	<script> 
			jQuery(document).ready(function() { 
			parent.$.fancybox.close(); 
		});
	</script>
<?php  } ?>
<style>
	#navc,#navc ul {
		padding: 5px 0 5px 0;
		margin: 0;
		list-style: none;
		font: 15px verdana, sans-serif;
		border-color: #000;
		border-width: 1px 2px 2px 1px;
		background: #374043;
		position: relative;
		z-index: 200;
	}

	.date_class {
		float: left;
		padding: 5px 20px 0 0;
	}

	.tddate img {
		float: inherit;
	}

	#navc {
		height: 35px;
		padding: 0;
		width: 350px;
		margin-left: -7px;
	}

	#navc li {
		float: left;
	}

	#navc li li {
		float: none;
		background: #fff;
	}

	#treatment .tdLabel {
		padding: 0px !important;
	}

	.accordionCust div.section {
		padding: 0px !important;
	}

	* html #navc li li {
		float: left;
	}

	.tddate img {
		float: inherit;
	}

	#navc li a {
		display: block;
		float: left;
		color: #fff;
		margin: 0 25px 0 10px;
		height: 35px;
		line-height: 12px;
		text-decoration: none;
		white-space: nowrap;
		font-size: 14px;
	}

	#navc li li a {
		height: 20px;
		line-height: 20px;
		float: none;
	}

	#navc ul {
		position: absolute;
		left: -9999px;
		top: -9999px;
	}

	* html #navc ul {
		width: 1px;
	}

	#navc li:hover li:hover>ul {
		left: -15px;
		margin-left: 100%;
		top: -1px;
	}

	#navc li:hover>ul ul {
		position: absolute;
		left: -9999px;
		top: -9999px;
		width: auto;
	}

	#navc li:hover>a {
		color: #fff;
	}

	.patientHub .patientInfo .content {
		float: left;
		padding: 0 0 0 20px !important;
	}

	.patient_info .ui-widget-content {
		background: none;
	}

	#swap_investigation {
		color: #FFFFFF;
	}

	#provisional_dignosis {
		width: 1000px;
	}

	#swap_investigation_ekg {
		color: #FFFFFF;
	}

	.showTr {
		display: block;
	}

	.hideTr {
		display: none;
	}

	.inner_title span {
		float: right;
		margin: -26px 14px !important;
		padding: 0;
	}
</style>

<?php 
	echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));
	echo $this->Html->script(array('slides.min.jquery.js?ver=1.1.9',
		'jquery.isotope.min.js?ver=1.5.03','jquery.custom.js?ver=1.0','ibox.js','jquery.fancybox-1.3.4'));
	echo $this->Html->Script('ui.datetimepicker.3.js');
	echo $this->Html->script(array('jquery.autocomplete','jquery.ui.accordion.js','stuHover.js','jquery.selection.js'));
	echo $this->Html->css(array('jquery.autocomplete.css','skeleton.css'));
?>
<script type="text/javascript">
 
window.history.forward();
function noBack()
{
    window.history.forward();
}

jQuery(document).ready(function() {
	getPastMedicalHistory();
	var height, weight, bmi, message;
	jQuery.fn.checkBMI = function(){
		// on load set bmi
		height = jQuery("#height").val();
		weight = jQuery("#weight").val();
		bmi1 = weight / (height * height)*703;
		bmi = bmi1.toFixed(2);
		if(height==0){}
		else{
		if(isNaN(height) || isNaN(weight))
			 jQuery("#bmi").val("");
			else
			 jQuery("#bmi").val(bmi);	
		}
		/*
		Underweight: Less than 18.5
		Normal: 18.6 to 23
		Overweight:  23.1 to 30
		Obese : More than 30
		*/	
		if(bmi < 18.5) {
			document.getElementById('id1').value='Underweight' ;
			message = "Underweight";
		} else if(bmi > 18.5 && bmi<=23) {
			document.getElementById('id1').value='Normal' ;
			message = "Normal";
		} else if(bmi >= 23.1 && bmi<=30) {
			document.getElementById('id1').value='Overweight' ;
			message = "Overweight";
		} else if(bmi >= 30) {
			document.getElementById('id1').value='Obese' ;
			message = "Obese";
		}
		jQuery("#bmiStatus").html(message);
	};
	jQuery("#bmi").checkBMI();
	jQuery('#height, #weight').change(function() {
		jQuery("#bmi").checkBMI();
	});
});
</script>
 
<?php 
	echo $this->Form->create('Diagnosis',array('id'=>'diagnosisfrm','url'=>array('controller'=>'Diagnoses','action'=>'significantHistory',$patient_id,$personId,$appointment_id,$diagnosis_id),'inputDefaults' => array( 'label' => false, 'div' => false, 'error'=>false )));
?>
<div class="inner_title">
	<h3 style="font-size: 13px; margin-left: 15px;">
		<?php  echo __('History'); ?>
	</h3>
	<span>
		<?php 
			$cancelBtnUrl =  array('controller'=>'Diagnoses','action'=>'initialAssessment',$patient_id,$diagnosis_id,$appointment_id,'?'=>array('expand'=>'History'));
		 	if($this->params->named['slug']!=true){
				echo $this->Html->link(__('Cancel'),$cancelBtnUrl,array('class'=>'blueBtn','div'=>false));
				echo $this->Form->submit(__('Submit'), array('class'=>'blueBtn','div'=>false,'id'=>'submit_diagno'));
			}
		?>
	</span>
</div>
<div>
	<table width="60%" class="formFull formFullBorder">
		<tr>
			<td width="10%" align="right">
				<b><?php echo __('Name :')?> </b>
			</td>
			<td align="left">
				<?php echo $patientDetails['Patient']['lookup_name'];?>
			</td>
			<td>&nbsp;&nbsp;&nbsp;</td>
			<td width="10%" align="right"><b><?php echo __('Gender :')?> </b></td>
			<td align="left"><?php echo ucfirst($patientDetails['Person']['sex']);?>
			</td>
			<td>&nbsp;&nbsp;&nbsp;</td>

			<td width="10%" align="right"><b><?php echo __('DOB :')?> </b></td>
			<td align="left"><?php echo date("F d, Y", strtotime($patientDetails['Person']['dob']));?>
			</td>
			<td>&nbsp;&nbsp;&nbsp;</td>

			<td width="10%" align="right"><b><?php echo __('Visit ID :')?> </b></td>
			<td align="left"><?php echo $patientDetails['Patient']['admission_id'];?>
			</td>
		</tr>
	</table>
</div>
 
<?php 
	if(!$patient_id)
		$patient_id = $patientDetails['Patient']['id'];
	
	echo $this->Form->hidden('Diagnosis.appointment_id',array('value'=>$appointment_id,'id'=>'appointment_id','type'=>'text'));
	echo $this->Form->hidden('Diagnosis.patient_id',array('value'=>$patient_id,'id'=>'patient_id','type'=>'text'));
	
	echo $this->Form->hidden('location_id',array('value'=>$this->Session->read('locationid')));
	echo $this->Form->input('PatientPastHistory.id', array('type'=>'hidden','value'=>$this->data['PatientPastHistory']['id']));
	
	echo $this->Form->input('PatientPersonalHistory.id', array('type'=>'hidden','value'=>$this->data['PatientPersonalHistory']['id']));
	echo $this->Form->input('PatientFamilyHistory.id', array('type'=>'hidden','value'=>$this->data['PatientFamilyHistory']['id']));
	echo $this->Form->hidden('Diagnosis.flag',array('id'=>'flag','value'=>$flag));
?>
<div id="significant_history" style="display:<?php echo $display ;?>" class="section dragbox-content">
	<?php echo $this->Form->hidden('Diagnosis.id',array('value'=>$diagnosis_id)); ?>
		<table class="tdLabel" style="text-align: left;">
			<tr id="Past_Medical_History_link">
				<td colspan="4" style="" width="100%">
					<table width="100%" style="float: left;">
						<tr>
							<td style="font-size: 13px; color: #31859c !important; font-weight: bold;">
								<?php echo "PastMedical History";?>
							</td>
						</tr>
					</table>
					<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm">
						<tr>
							<td id='getDiagno'></td>
						</tr>
						<tr>
							<td width="22%" class="tdLabel" id="boxSpace" align="center" colspan="5">
								<?php 
									if($pastHistory[0]["PastMedicalHistory"]["no_known_problems"] == 1){
										echo $this->Form->checkbox('PastMedicalHistory.no_known_problems', array('id' => 'no_known_problems','checked' => 'checked'));
									}else if(!empty($pastHistory[0]["PastMedicalHistory"]["illness"]) ){
										echo $this->Form->checkbox('PastMedicalHistory.no_known_problems',array('id' => 'no_known_problems','disabled'=>'disabled'));
									}else{
										echo $this->Form->checkbox('PastMedicalHistory.no_known_problems',array('id' => 'no_known_problems'));
									}
									echo __('No known problems')
								?>
							</td>
						</tr>
					</table>
					<?php 
							if($pastHistory[0]["PastMedicalHistory"]["no_known_problems"] == 1){
								$displayIsPast='none';
							}else{
								$displayIsPast='blank';
							}
						?>
					<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm">
						<tr class="Past_Medical_History" style="display: <?php  echo $displayIsPast ?>;">
							<td>
								<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm">
									<tr>
										<td valign="top" width="20%" align="center" class="tdLabel" id="boxSpace" style="border-left: solid 1px #3E474A;">
											<b><?php echo __('Problem');?></b>
										</td>
										<td valign="top" width="20%" align="center" class="tdLabel"
											id="boxSpace"><b><?php echo __('Status');?> </b></td>
										<td valign="top" width="10%" align="center" class="tdLabel"
											id="boxSpace"><b><?php echo __('Duration(in years)');?> </b></td>
										<td valign="top" width="10%" align="center" class="tdLabel"
											id="boxSpace"><b><?php echo __('Duration(in months)');?> </b>
										</td>
										<td valign="top" width="10%" align="center" class="tdLabel"
											id="boxSpace"><b><?php echo __('Duration(in weeks)');?> </b></td>
										<td valign="top" width="13%" align="center" class="tdLabel"
											id="boxSpace"><b><?php echo __('Recovered Date/Time');?> </b>
										</td>
										<td valign="top" width="10%" align="center" class="tdLabel"
											id="boxSpace"><b><?php echo __('Significant Injuries');?> </b>
										</td>
										<td valign="top" width="7%" align="center" class="tdLabel"
											id="boxSpace"><b><?php echo __('Action');?> </b></td>
									</tr>
								</table>
							</td>
						</tr>

						<tr class="Past_Medical_History" style="display: <?php  echo $displayIsPast ?>;">
							<td>
								<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabularForm" id='DrugGroup_history' class="tdLabel">
								<?php  
									if(isset($pastHistory) && !empty($pastHistory)){
										$count_history  = count($pastHistory);
									}else{
										$count_history  = 1 ;
									}
									for($i=0;$i<$count_history;){
										$recoverd_date=$this->DateFormat->formatDate2Local($pastHistory[$i]['PastMedicalHistory']['recoverd_date'],Configure::read('date_format'),true);
										$illness_val= isset($pastHistory[$i]['PastMedicalHistory']['illness'])?$pastHistory[$i]['PastMedicalHistory']['illness']:'' ;
										$status_val= isset($pastHistory[$i]['PastMedicalHistory']['status'])?$pastHistory[$i]['PastMedicalHistory']['status']:'' ;
										$duration_val= isset($pastHistory[$i]['PastMedicalHistory']['duration'])?$pastHistory[$i]['PastMedicalHistory']['duration']:'' ;
										$month_val= isset($pastHistory[$i]['PastMedicalHistory']['month'])?$pastHistory[$i]['PastMedicalHistory']['month']:'' ;
										$week_val= isset($pastHistory[$i]['PastMedicalHistory']['week'])?$pastHistory[$i]['PastMedicalHistory']['week']:'' ;
										$comment_val= isset($pastHistory[$i]['PastMedicalHistory']['comment'])?$pastHistory[$i]['PastMedicalHistory']['comment']:'' ;
										$patient_id_val= isset($pastHistory[$i]['PastMedicalHistory']['patient_id'])?$pastHistory[$i]['PastMedicalHistory']['patient_id']:'' ;
										$id_val= isset($pastHistory[$i]['PastMedicalHistory']['id'])?$pastHistory[$i]['PastMedicalHistory']['id']:'' ;
										$appointment_id_val= isset($pastHistory[$i]['PastMedicalHistory']['appointment_id'])?$pastHistory[$i]['PastMedicalHistory']['appointment_id']:'' ;

								?>
								<tr id="DrugGroup_history<?php echo $i;?>">
									<?php  
											if($pastHistory[$i]['PastMedicalHistory']['patient_id'] != $patient_id && !empty($pastHistory[$i]['PastMedicalHistory']['patient_id'])){
												$isPrevious = "yes" ;
											}else{
												$isPrevious = "no" ;
											}
											echo $this->Form->input('',array('type'=>'hidden','value'=>$isPrevious,'name'=>'PastMedicalHistory[ancounter][]',
												'legend'=>false,'label'=>false,'id'=>'ancounter'));

											echo $this->Form->hidden('',array('type'=>'text','value'=>$patient_id_val,'name'=>'PastMedicalHistory[patient_id][]','legend'=>false,'label'=>false,'id'=>'patient_id'));
											echo $this->Form->hidden('',array('type'=>'text','value'=>$id_val,'name'=>'PastMedicalHistory[id][]','legend'=>false,'label'=>false,'id'=>'id'));
											echo $this->Form->hidden('',array('type'=>'text','value'=>$appointment_id_val,'name'=>'PastMedicalHistory[appointment_id][]','legend'=>false,'label'=>false,'id'=>'appointment_id'));
										?>
									<td width="20%" valign="top" align="left"><?php echo $this->Form->input('', array('type'=>'text','class' => 'problemAutocomplete textBoxExpnd validate[required,custom[mandatory-enter]]','id' =>"illness$i",'value'=>$illness_val,'name'=>'PastMedicalHistory[illness][]',style=>'','counter_history'=>$i)); ?>
									</td>
									<td width="20%" align="left"><?php $options = array(''=>'Please Select','Chronic'=>'Chronic','Existing'=>'Existing','New Onset'=>'New Onset','Recovered'=>'Recovered','Acute'=>'Acute','Inactive'=>'Inactive');
										echo $this->Form->input('', array('options'=>$options,'class' => 'textBoxExpnd','id'=>"status$i",'name' =>'PastMedicalHistory[status][]',style=>'','value'=>$status_val)); ?>
									</td>
									<td width="10%" align="left"><?php echo $this->Form->input('', array('type'=>'text','class' => 'validate[optional,custom[onlyNumber]] textBoxExpnd','id' =>"duration$i",'value'=>$duration_val,'name'=>'PastMedicalHistory[duration][]',style=>'','counter_history'=>$i,'autocomplete'=>"off",'maxlength'=>'4')); ?>
									</td>

									<td width="10%" align="left"><?php echo $this->Form->input('', array('type'=>'text','class' => 'validate[optional,custom[onlyNumber]] textBoxExpnd','id' =>"month$i",'value'=>$month_val,'name'=>'PastMedicalHistory[month][]','style'=>'','counter_history'=>$i,'autocomplete'=>"off",'maxlength'=>'2')); ?>
									</td>

									<td width="10%" align="left"><?php echo $this->Form->input('', array('type'=>'text','class' => 'validate[optional,custom[onlyNumber]] textBoxExpnd','id' =>"week$i",'value'=>$week_val,'name'=>'PastMedicalHistory[week][]','style'=>'','counter_history'=>$i,'autocomplete'=>"off",'maxlength'=>'2')); ?>
									</td>

									<td width="13%" align="left"><?php  echo $this->Form->input('', array('type'=>'text','id'=>"recoverd_date$i",'class'=>"recoverd_date textBoxExpnd ",'name'=>'PastMedicalHistory[recoverd_date][]','value'=>$recoverd_date,'readonly'=>'readonly','counter_history'=>$i,'autocomplete'=>"off")); ?>
									</td>

									<td width="10%" align="left"><?php echo $this->Form->input('', array('type'=>'text','class' => ' textBoxExpnd','id' =>"comment$i",'value'=>$comment_val,'name'=>'PastMedicalHistory[comment][]',style=>'','counter_history'=>$i,'autocomplete'=>"off")); ?>
									</td>
									<?php   ?>
									<td width="7%" align="left"><?php if($this->params->named['slug']!='true'){ 
										echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete','class'=>'DrugGroup_history','id'=>"pMH$i",'style'=>'margin:0 0 0 17px;'));
									}?></td>
								</tr>
								<?php $i++ ; } ?>
								</table>
							</td>
						</tr>
						<?php  if($this->params->named['slug']!='true'){ ?>
						<tr class="Past_Medical_History"  style="display: <?php  echo $displayIsPast ?>;">
							<td align="right" colspan="4"><input type="button"
								id="addButton_history" value="Add"> <?php if($count_history > 0)
								{?> <!-- <input type="button" id="removeButton_history"
									value="Remove"> --> <?php }
									else{ ?> <input type="button" id="removeButton_history"
								value="Remove" style="display: none;"> <?php } ?>
							</td>
						</tr>
						<?php } 
						if(strtolower($patient['Person']['sex'])=='female'){?>
						<tr>
							<td>
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td colspan="2"><?php echo __('<b>PREGNANCY STATUS</b>');?></td>
									</tr>
									<tr>
										<td class="tdLabel" id="boxSpace" valign="top" width="12%"
											align="left">Is Pregnant:</td>
										<td class="tdLabel" id="boxSpace"><?php 
										echo $this->Form->radio('PastMedicalRecord.is_pregnent', array('0'=>'No','1'=>'Yes'),array('value'=>$getpatient['PastMedicalRecord']['is_pregnent'],'legend'=>false,'label'=>false,'class' => 'is_pregnent','id'=>'is_pregnent','checked'=>$getpatient['PastMedicalRecord']['is_pregnent']));
										?> <?php if(!empty($getpatient['PastMedicalRecord']['is_pregnent'])){
											$displayWeek='block';
										}else{
														$displayWeek='none';
													}?>
										</td>

										<td>
											<div id="showWeeks" style="display:<?php echo $displayWeek ?>;">
												<span> From:<?php 
												echo $this->Form->input('PastMedicalRecord.is_pregnent_weeks',array('type'=>'text','legend'=>false,'label'=>false,'class' => ' is_pregnent_weeks ','id' => 'is_pregnent_weeks','value'=>$getpatient['PastMedicalRecord']['is_pregnent_weeks']));
												?> Weeks
												</span>
											</div>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<?php }?>
						<tr>
							<td>
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td colspan="2"><?php echo __('<b>TUBERCULOSIS SCREENING</b>');?></td>
									</tr>
									<tr>
										<td class="tdLabel" id="boxSpace" valign="top" width="12%" align="left"><span
											title="Tuberculin Skin Test - Purified Protein Derivative">Last
												PPD</span>:
										</td>
										<td class="tdLabel" id="boxSpace">
											<?php 
												echo $this->Form->radio('PastMedicalRecord.last_PPD', array('0'=>'No','1'=>'Yes'),array('value'=>$getpatient['PastMedicalRecord']['last_PPD'],'legend'=>false,'label'=>false,'class' => 'personalPPD','id'=>'last_PPD','checked'=>$getpatient['PastMedicalRecord']['last_PPD']));
												?> <?php if(!empty($getpatient['PastMedicalRecord']['last_PPD'])){
													$displayValue='block';
												}else{
												$displayValue='none';
											}?>
										</td>
										<td>
											<div id="showPPD" style="display:<?php echo $displayValue ?>;">
												<span> <?php $getpatient['PastMedicalRecord']['last_PPD_yes']=$this->DateFormat->formatDate2Local($getpatient['PastMedicalRecord']['last_PPD_yes'],Configure::read('date_format'));
												echo $this->Form->input('PastMedicalRecord.last_PPD_yes',array('type'=>'text','legend'=>false,'label'=>false,'class' => 'textBoxExpnd  last_PPD_yes ','id' => 'last_PPD_yes','readonly'=>'readonly','value'=>$getpatient['PastMedicalRecord']['last_PPD_yes']));
												/// removeSince '.$class
												?>
												</span>
											</div>
										</td>
										<td class="tdLabel" id="boxSpace" valign="top" width="12%"
											align="left"><?php echo __('Preventive Care : '); ?>
										</td>
										<td valign="top" width="38%" align="left"><?php  echo $this->Form->input('preventive_care', array('class' =>'textBoxExpnd','id' =>'preventive_care','value'=>$getpatient['PastMedicalRecord']['preventive_care'],'style'=>'width:270px','autocomplete'=>"off")); ?>
											<!--validate[custom[onlyLetterSp]]   -->
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
						<td>
							<table width="100%" border="0" cellspacing="0" cellpadding="0"
								class="tabularForm">
								<tr>
								<td colspan="4"><?php echo __('<b>Last Tetanus vaccination Received</b>');?>
								</td>
								</tr>
								<tr>
								<td colspan="4" class="tdLabel" id="boxSpace" valign="top"
										width="12%" align="left"><span
										title="Month and Year for Tetanus vaccination">Date</span>: <?php 
										$dateTa=explode('||',$getpatient['PastMedicalRecord']['dateTetanus']);
										$monthArry=array('Jan'=>'Jan','Feb'=>'Feb','Mar'=>'Mar',
				'Apr'=>'Apr','May'=>'May','Jun'=>'Jun','Jul'=>'Jul','Aug'=>'Aug',
				'Sep'=>'Sep','Oct'=>'Oct','Nov'=>'Nov','Dec'=>'Dec');
			$currntY=date('Y');
			$yrArry=array();
			$yrArry[]=$currntY;
			for($i=1;$i<=20;$i++){
				$yrArry[$currntY-($i)]=$currntY-($i);
			}
			echo $this->Form->input('PastMedicalRecord.monthTetanus',array('empty'=>"Please select month",'options'=>$monthArry,'value'=>$dateTa['0']));?>
										<?php echo $this->Form->input('PastMedicalRecord.yearTetanus',array('empty'=>"Please select year" ,'options'=>$yrArry,'value'=>$dateTa['1']));?>
									</td>
								</tr>
								<tr>

									<td width="20%"><?php $positiveTb_date=$this->DateFormat->formatDate2Local($getpatient['PastMedicalRecord']['positive_tb_date'],Configure::read('date_format'),true);
									echo __('<b>Positive TB skin test (PPD) Date/Time:</b>');?>
									</td>
									<td><?php echo $this->Form->input('positive_tb_date',array('type'=>'text','class'=>'textBoxExpnd','id'=>"positiveTb",
											'autocomplete'=>'off','label'=>false,'div'=>false,'value'=>$positiveTb_date));?>
									</td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td colspan="4"><?php echo __('Please indicate if patient is having any of the following problems for three to four weeks or longer:');?>
									</td>
								</tr>
								<tr>
									<td id="boxSpace" class="tdLabel"><?php echo __('Chronic Cough (greater than 3 weeks)');?>
									</td>
									<td colspan="3" class="tdLabel" id="boxSpace"><?php echo $this->Form->radio('chronic_cough', array('no'=>'No','yes'=>'Yes'),array('legend'=>false,'label'=>false,'id' => 'chronic_cough','value'=>$getpatient['PastMedicalRecord']['chronic_cough']));?>
								
								</tr>
								<tr>
									<td id="boxSpace" class="tdLabel"><?php echo __('Production of Sputum');?>
									</td>
									<td colspan="3" class="tdLabel" id="boxSpace"><?php echo $this->Form->radio('production_sputum', array('no'=>'No','yes'=>'Yes'),array('legend'=>false,'label'=>false,'id' => 'production_sputum','value'=>$getpatient['PastMedicalRecord']['production_sputum']));?>
								
								</tr>
								<tr>
									<td id="boxSpace" class="tdLabel"><?php echo __('Blood-Streaked Sputum');?>
									</td>
									<td colspan="3" class="tdLabel" id="boxSpace"><?php echo $this->Form->radio('blood_sputum', array('no'=>'No','yes'=>'Yes'),array('legend'=>false,'label'=>false,'id' => 'blood_sputum','value'=>$getpatient['PastMedicalRecord']['blood_sputum']));?>
								
								</tr>
								<tr>
									<td id="boxSpace" class="tdLabel"><?php echo __('Unexplained Weight Loss');?>
									</td>
									<td colspan="3" class="tdLabel" id="boxSpace"><?php echo $this->Form->radio('weight_loss',array('no'=>'No','yes'=>'Yes'),array('legend'=>false,'label'=>false,'id' => 'weight_loss','value'=>$getpatient['PastMedicalRecord']['weight_loss']));?>
								
								</tr>
								<tr>
									<td id="boxSpace" class="tdLabel"><?php echo __('Fever');?></td>
									<td colspan="3" class="tdLabel" id="boxSpace"><?php echo $this->Form->radio('fever',array('no'=>'No','yes'=>'Yes'),array('legend'=>false,'label'=>false,'id' => 'fever','value'=>$getpatient['PastMedicalRecord']['fever']));?>
								
								</tr>
								<tr>
									<td id="boxSpace" class="tdLabel"><?php echo __('Fatigue/Tiredness');?>
									</td>
									<td colspan="3" class="tdLabel" id="boxSpace"><?php echo $this->Form->radio('fatigue',array('no'=>'No','yes'=>'Yes'),array('legend'=>false,'label'=>false,'id' => 'fatigue','value'=>$getpatient['PastMedicalRecord']['fatigue']));?>
								
								</tr>
								<tr>
									<td id="boxSpace" class="tdLabel"><?php echo __('Night Sweats');?>
									</td>
									<td colspan="3" class="tdLabel" id="boxSpace"><?php echo $this->Form->radio('night_sweat',array('no'=>'No','yes'=>'Yes'),array('legend'=>false,'label'=>false,'id' => 'night_sweat','value'=>$getpatient['PastMedicalRecord']['night_sweat']));?>
								
								</tr>
								<tr>
									<td id="boxSpace" class="tdLabel"><?php echo __('Shortness of Breath');?>
									</td>
									<td colspan="3" class="tdLabel" id="boxSpace"><?php echo $this->Form->radio('breath_shortness',array('no'=>'No','yes'=>'Yes'),array('legend'=>false,'label'=>false,'id' => 'breath_shortness','value'=>$getpatient['PastMedicalRecord']['breath_shortness']));?>
								
								</tr>
							</table>
						</td>
					</tr>

				</table>
			</td>
		</tr>



		<tr id="Past_Surgical_History_link">

			<td style="" width="100%" colspan="4">
				<table>
					<tr>
						<td
							style="font-size: 13px; color: #31859c !important; font-weight: bold;">Past
							Surgical History</td>
					</tr>
				</table>
				<table width="100%" border="0" cellspacing="1" cellpadding="0"
					class="tabularForm" class="tdLabel">
					<tr>
						<td width="22%" class="tdLabel" id="boxSpace" align="center"
							colspan="5"><?php 
							if($procedureHistory[0]['ProcedureHistory']["no_surgical"] == 1){
								echo $this->Form->checkbox('ProcedureHistory.no_surgical', array('id' => 'no_surgical','checked' => 'checked'));
							}else if(!empty($procedureHistory[0]['TariffList']['name']) ){
								echo $this->Form->checkbox('ProcedureHistory.no_surgical',array('id' => 'no_surgical','disabled'=>'disabled'));
							}else{
								echo $this->Form->checkbox('ProcedureHistory.no_surgical',array('id' => 'no_surgical'));
							}
							echo $this->Form->hidden('ProcedureHistory.appointment_id',array('value'=>$appointment_id,'id'=>'appointment_id','type'=>'text'));
							?> <?php echo __(' No past surgical history')?></td>
					</tr>
				</table>
				<table width="100%" border="0" cellspacing="1" cellpadding="0"
					class="tabularForm" class="tdLabel">
					<?php if($procedureHistory[0]["ProcedureHistory"]["no_surgical"] == 1){
						$displayPast='none';
					}else{
											$displayPast='blank';
										}?>

					<tr class ='ProcedureHistory' style="display: <?php  echo $displayPast ?>;">
						<td colspan="7">
							<table width="100%" border="0" cellspacing="0" cellpadding="0"
								class="tabularForm" class="tdLabel">
								<tr>
									<td height="20px" align="center" valign="top" width="17%"><b>Surgical/Hospitalization</b>
									</td>
									<td height="20px" align="center" valign="top" width="17%"><b>Provider</b>
									</td>
									<td height="20px" align="center" valign="top" colspan="2"
										width="17%"><b>Age</b>
									</td>
									<td height="20px" align="center" valign="top" width="17%"><b>Date/Time</b>
									</td>
									<td height="20px" align="center" valign="top" width="17%"
										style="padding-left: 15px"><b>Comment</b></td>
									<td height="20px" align="center" valign="top" width="4%"><b>Action</b>
									</td>
								</tr>
							</table>
						</td>
					</tr>

<tr class ='ProcedureHistory' style="display: <?php  echo $displayPast ?>;">
<td colspan="7">
	<table width="100%" border="0" cellspacing="0" cellpadding="0"class="tabularForm " id='DrugGroup_procedure' class="tdLabel">
		<?php
		//debug($procedureHistory);
			if(isset($procedureHistory) && !empty($procedureHistory))
				$count_procedure  = count($procedureHistory);
			else
				$count_procedure  = 1 ;
		
			for($i=0;$i<$count_procedure;$i++){
				$procedure_name = !empty($procedureHistory[$i]['TariffList']['name'])?$procedureHistory[$i]['TariffList']['name']:$procedureHistory[$i]['ProcedureHistory']['procedure_name'] ;
				$provider_name = !empty($procedureHistory[$i]['DoctorProfile']['doctor_name'])?$procedureHistory[$i]['DoctorProfile']['doctor_name']:$procedureHistory[$i]['ProcedureHistory']['provider_name'] ;
				$procedure_val = !empty($procedureHistory[$i]['TariffList']['id'])?$procedureHistory[$i]['TariffList']['id']:'' ;
				$provider_val = !empty($procedureHistory[$i]['DoctorProfile']['id'])?$procedureHistory[$i]['DoctorProfile']['id']:'' ;
				$procedureHistory[$i]['ProcedureHistory']['procedure_date'] = $this->DateFormat->formatDate2Local($procedureHistory[$i]['ProcedureHistory']['procedure_date'],Configure::read('date_format'),true);
				$age_value_val = isset($procedureHistory[$i]['ProcedureHistory']['age_value'])?$procedureHistory[$i]['ProcedureHistory']['age_value']:'' ;
				$age_unit_val = isset($procedureHistory[$i]['ProcedureHistory']['age_unit'])?$procedureHistory[$i]['ProcedureHistory']['age_unit']:'' ;
				$procedure_date_val = isset($procedureHistory[$i]['ProcedureHistory']['procedure_date'])?$procedureHistory[$i]['ProcedureHistory']['procedure_date']:'' ;
				$comment_val = isset($procedureHistory[$i]['ProcedureHistory']['comment'])?$procedureHistory[$i]['ProcedureHistory']['comment']:'' ;
		?>
		<tr id="DrugGroup_procedure<?php echo $i;?>">
			<?php  
				echo $this->Form->hidden("ProcedureHistory.id", array('type'=>'text' ,'class' => "textBoxExpnd ",'id'=>"id_$i",'value'=>$procedureHistory[$i]['ProcedureHistory']['id'],'name'=>'ProcedureHistory[id][]')); 
				
				echo $this->Form->hidden("ProcedureHistory.patient_id", array('type'=>'text' ,'class' => "textBoxExpnd ",'id'=>"patient_id_$i",'value'=>$procedureHistory[$i]['ProcedureHistory']['patient_id'],'name'=>'ProcedureHistory[patient_id][]')); ?>
			<td width="19%" height="20px" align="left" valign="top">
				<?php  
					echo $this->Form->input("ProcedureHistory.procedure", array('type'=>'text' ,'class' => "textBoxExpnd procedure validate[required,custom[mandatory-enter]] ",'id'=>"procedureDisplay_$i",'title' =>$procedure_name,'alt' => $procedure_name,'value'=>$procedure_name,'name'=>'ProcedureHistory[procedure_name][]',style=>'width:90%','counter_procedure'=>$i)); ?>
			</td>
				<?php 
					echo $this->Form->hidden("ProcedureHistory.procedure", array('name'=>'ProcedureHistory[procedure][]','type'=>'text','id'=>"procedure_$i",'counter_procedure'=>$i,'value'=>$procedure_val));
					?>

			<td width="17%" height="20px" align="left" valign="top">
				<?php echo $this->Form->input("ProcedureHistory.provider_name", array('type'=>'text','class' =>'textBoxExpnd providercls','name'=>'ProcedureHistory[provider_name][]','id' => "providerDisplay_$i",'value'=>$provider_name,'style'=>'width:244px','counter_procedure'=>$i)); ?>
				<?php echo $this->Form->hidden("ProcedureHistory.provider.$i", array('name'=>'ProcedureHistory[provider][]','type'=>'text','id'=>"provider_$i",'counter_procedure'=>$i,'value'=>$provider_val)); ?>
			</td>
			<td style="padding: 0 0 0 60px; width: 12%;">
				<?php  
					echo $this->Form->input('', array('type'=>'text' ,'class' =>'validate[optional,custom[onlyNumber]] textBoxExpnd','MaxLength'=>'3','id'=>"age_value$i",'value'=>$age_value_val,'name'=>'ProcedureHistory[age_value][]','style'=>'','counter_procedure'=>$i,'autocomplete'=>"off"));
				?>
			</td>
			<td>
				<?php  
					$options = array(''=>'Please Select','Days'=>'Days','Months'=>'Months','Years'=>'Years');
					echo $this->Form->input('', array( 'options'=>$options,'style'=>'width:auto','class' => '','id'=>"age_unit$i",'name'=> 'ProcedureHistory[age_unit][]','value'=>$age_unit_val));
				 ?>
			</td>
			<td width="17%" height="20px" align="left" valign="top" style="">
				<?php  
					echo $this->Form->input('',array('type'=>'text','id'=>"procedure_date$i",'class'=>"procedure_date textBoxExpnd ",'name'=>'ProcedureHistory[procedure_date][]','value'=>$procedure_date_val,'readonly'=>'readonly','counter_procedure'=>$i,'autocomplete'=>"off"));
				?>
			</td>
			<td width="17%" height="20px" align="left" valign="top">
				<?php
					 echo $this->Form->input('', array('type'=>'text' ,'class' =>'textBoxExpnd','id'=>"comment$i",'value'=>$comment_val,'name'=>'ProcedureHistory[comment][]','style'=>'width:90%','counter_procedure'=>$i,'autocomplete'=>"off"));
				?>
			</td>
			<td width="4%">
				<?php 
					if($this->params->named['slug']!='true'){ 
						echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete','class'=>'DrugGroup_procedure','id'=>"surgery$i"));
				}?>
			</td>
		</tr>
		<?php
		}
		?>
	</table>
</td>
</tr>
<?php  if($this->params->named['slug']!='true'){ ?>
<tr class ='ProcedureHistory' style="display: <?php  echo $displayPast ?>;">
<td align="right" colspan="7"><input type="button"
	id="addButton_procedure" value="Add"> <?php if($count_procedure > 0)
	{?> <!-- <input type="button" id="removeButton_procedure"
		value="Remove"> --> <?php }
		else{ ?> <input type="button" id="removeButton_procedure"
	value="Remove" style="display: none;"> <?php } ?>
</td>
</tr>
<?php } ?>

				</table>

			</td>
		</tr>

		<?php 
			if(!empty($pastMedication)){?>
		<tr id="Past_Medication_link">

			<td colspan="4" style="" width="100%">
				<table>
					<tr>
						<td
							style="font-size: 13px; color: #31859c !important; font-weight: bold;">Past
							Medication</td>
					</tr>
				</table> <!-- <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabularForm"> -->
				<!-- row 1 --> <!-- <tr>
							<td width="100%" valign="top" align="left" colspan="6"> -->
				<table width="100%" border="0" cellspacing="1" cellpadding="0"
					id='DrugGroup' class="tabularForm">
					<tr>
						<td width="20%" height="20" align="left" valign="top">Drug Name</td>
						<td width="5%" height="20" align="left" valign="top">Dose</td>
						<!-- <td width="5%" height="20" align="left" valign="top">Strength</td> -->
						<td width="5%" height="20" align="left" valign="top">Route</td>
						<td width="5%" align="left" valign="top">Frequency</td>
						<td width="5%" align="left" valign="top">Dosage Form</td>
						<td width="5%" align="left" valign="top">Days</td>
						<td width="5%" align="left" valign="top">Qty</td>
						<td width="5%" align="center" valign="top">Refills</td>
						<td width="5%" align="center" valign="top">PRN</td>
						<td width="5%" align="center" valign="top">DAW</td>
						<!--<td width="10%" align="center" valign="top">Special Instruction</td>-->
						<td width="5%" align="center" valign="top">Is Active</td>
					</tr>

					<?php   $doseValue = Configure :: read('dose_type');
					$freqValue = Configure :: read('frequency');
					$doseFrom = Configure :: read('strength');
					$route_admin=Configure :: read('route_administration');

					if(isset($pastMedication) && !empty($pastMedication)){
                                     	$count  = count($pastMedication) ;
			               			}
			               			for($i=0;$i<$count;){

										$drug_name_val1= isset($pastMedication[$i]['NewCropPrescription']['drug_name'])?$pastMedication[$i]['NewCropPrescription']['description']:'' ;
										$drug_name_val = stripslashes($drug_name_val1);
										$drug_id_val= isset($pastMedication[$i]['NewCropPrescription']['drug_id'])?$pastMedication[$i]['NewCropPrescription']['drug_id']:'' ;
										$dose_val= isset($pastMedication[$i]['NewCropPrescription']['dose'])?$pastMedication[$i]['NewCropPrescription']['dose']:'' ;
										$strength_val= isset($pastMedication[$i]['NewCropPrescription']['strength'])?$pastMedication[$i]['NewCropPrescription']['strength']:'' ;
										$route_val= isset($pastMedication[$i]['NewCropPrescription']['route'])?$pastMedication[$i]['NewCropPrescription']['route']:'' ;
										$frequency_val= isset($pastMedication[$i]['NewCropPrescription']['frequency'])?$pastMedication[$i]['NewCropPrescription']['frequency']:'' ;
										$day_val= isset($pastMedication[$i]['NewCropPrescription']['day'])?$pastMedication[$i]['NewCropPrescription']['day']:'' ;
										$quantity_val= isset($pastMedication[$i]['NewCropPrescription']['quantity'])?$pastMedication[$i]['NewCropPrescription']['quantity']:'' ;
										$refills_val= isset($pastMedication[$i]['NewCropPrescription']['refills'])?$pastMedication[$i]['NewCropPrescription']['refills']:'' ;
										$prn_val= isset($pastMedication[$i]['NewCropPrescription']['prn'])?$pastMedication[$i]['NewCropPrescription']['prn']:'' ;
										$daw_val= isset($pastMedication[$i]['NewCropPrescription']['daw'])?$pastMedication[$i]['NewCropPrescription']['daw']:'' ;
										$special_instruction_val= isset($pastMedication[$i]['NewCropPrescription']['special_instruction'])?$pastMedication[$i]['NewCropPrescription']['special_instruction']:'' ;
										$isactive_val= isset($pastMedication[$i]['NewCropPrescription']['archive'])?$pastMedication[$i]['NewCropPrescription']['archive']:'' ;
										$prescription_guid= isset($pastMedication[$i]['NewCropPrescription']['PrescriptionGuid'])?$pastMedication[$i]['NewCropPrescription']['PrescriptionGuid']:'' ;

										$dosage_form= isset($pastMedication[$i]['NewCropPrescription']['DosageForm'])?$pastMedication[$i]['NewCropPrescription']['DosageForm']:'' ;
										//if($isactive_val=='N'){

										if($prn_val =='1')
										{
											$prnVal='Yes';
										}
										else
										{
											$prnVal='No';
										}
										if($daw_val =='1')
										{
											$dawVal='Yes';
										}
										else
										{
											$dawVal='No';
										}

										if($isactive_val == 'N'){
											$isactiveVal='Yes';
										}else{
											$isactiveVal='No';
										}
											
										?>
					<tr id="DrugGroup<?php echo $i;?>">
						<td align="left"><?php echo ($drug_name_val);?></td>
						<td align="left"><?php echo $doseValue[($dose_val)];?></td>
						<!--  <td align="left"><?php echo ($strength_val);?></td>-->
						<td align="left"><?php echo $route_admin[($route_val)];?></td>

						<td align="left"><?php echo $freqValue[($frequency_val)];?></td>
						<td align="left"><?php echo $doseFrom[($dosage_form)];?></td>
						<td align="left"><?php echo ($day_val);?></td>
						<td align="left"><?php echo ($quantity_val);?></td>

						<td align="left"><?php echo ($refills_val);?></td>
						<td align="left"><?php echo $prnVal;?></td>
						<td align="left"><?php echo $dawVal;?></td>
						<!-- <td align="left"><?php echo ($special_instruction_val);?></td>-->

						<td align="left"><?php echo $isactiveVal;?></td>

					</tr>
					<?php
					$i++ ;
			               			}
			               			?>

				</table> <!-- </td>
						</tr> --> <!-- row 3 end --> <!--</table>-->
			</td>
		</tr>
		<?php }?>




		<tr id="Social_History_link">

			<td colspan="4" style="" width="100%">
				<table>
					<tr>
						<td
							style="font-size: 13px; color: #31859c !important; font-weight: bold;">Social
							History</td>
					</tr>
				</table>
				<table width="100%" border="0" cellspacing="1" cellpadding="0"
					class="tabularForm">
					<?php //debug($this->data['PatientPersonalHistory']);
						if($patient['Patient']['age']>=18){?>
					<tr>
						<td valign="top" width="120" colspan='5' style="color: fuchsia;">Have
							you screened for tobbaco use?</td>
					</tr>
					<?php }?>

					<tr>
						<td valign="top" class="tdLabel" id="boxSpace">Marital Status</td>

						<td valign="top" class="tdLabel" id="boxSpace"><?php echo $this->Form->input('maritail_status',array('empty'=>__('Please Select'),'options'=>Configure::read('maritail_status'),'value'=>$getmaritailStatusData,'style'=>'width:270px','id' => 'maritail_status')); ?>
						</td>

						</td>
						<td valign="top">Ethnicity</td>

						<td valign="top"><?php // echo $this->Form->input('ethnicity', array('empty'=>__('Please Select'),'id' => 'ethnicity','class' => 'textBoxExpnd','value'=>$getEthnicityData,'autocomplete'=>"off",'readonly'=>'readonly'));  ?>
							<?php  $ethnicity=array('2135-2:Hispanic or Latino'=>'Hispanic or Latino','2186-5:Not Hispanic or Latino'=>'Not Hispanic or Latino','UnKnown'=>'UnKnown','Denied to Specific'=>'Declined to specify');?>
							<?php echo $this->Form->input('ethnicity',array('empty'=>__('Please Select'),'options'=>$ethnicity,'value'=>$getEthnicityData,'style'=>'width:270px','id' => 'ethnicity')); ?>
						</td>
						<td>&nbsp;</td>
					</tr>
					<tr>

						<td valign="top" width=21% class="tdLabel" id="boxSpace">Smoking/Tobacco</td>
						<td valign="top" width=15% class="tdLabel" id="boxSpace"><?php 
						if(empty($this->data['PatientPersonalHistory']['diagnosis_id'])){
								echo $this->Form->hidden('PatientPersonalHistory.diagnosis_id',array('type'=>'text','value'=>$diagnosis_id));
							}else if(!empty($this->data['PatientPersonalHistory']['diagnosis_id'])&& ($this->data['PatientPersonalHistory']['diagnosis_id'] == $diagnosis_id)){
								echo $this->Form->hidden('PatientPersonalHistory.orignial_diagnosis_id',array('type'=>'text','value'=>$diagnosis_id));
								echo $this->Form->hidden('PatientPersonalHistory.diagnosis_id',array('type'=>'text','value'=>$diagnosis_id));
							}else{
								echo $this->Form->hidden('PatientPersonalHistory.diagnosis_id',array('type'=>'text','value'=>$this->data['PatientPersonalHistory']['diagnosis_id']));
								echo $this->Form->hidden('PatientPersonalHistory.orignial_diagnosis_id',array('type'=>'text','value'=>$diagnosis_id));
							}
							echo $this->Form->hidden('PatientPersonalHistory.appointment_id',array('value'=>$appointment_id,'id'=>'appointment_id','type'=>'text'));
							echo $this->Form->hidden('PatientPersonalHistory.patient_id',array('value'=>$patient_id,'id'=>'patient_id_patient_personal_history','type'=>'text'));
							if($this->data['PatientPersonalHistory']['smoking']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}
                        				//debug($this->data['PatientPersonalHistory']['smoking']);
                        				$smokingPersonalVal = isset($this->data['PatientPersonalHistory']['smoking'])?$this->data['PatientPersonalHistory']['smoking']:2 ;
                        				echo $this->Form->radio('PatientPersonalHistory.smoking', array('No','Yes'),array('value'=>$smokingPersonalVal,'legend'=>false,'label'=>false,'class' => 'personal','id' => 'smoking'));
                        				 
                        				?></td>
						<td valign="top" width=16%><?php 	
						echo $this->Form->input('PatientPersonalHistory.smoking_desc',array('type'=>'text','legend'=>false,'label'=>false,
				                        			 	'class' => 'textBoxExpnd removeSince '.$class,'id' => 'smoking_desc','placeHolder'=>'Since'));
									 ?>
						</td>



						<td valign="top" width=17%><?php 	

						echo $this->Form->input('PatientPersonalHistory.smoking_fre',array('type' => 'select', 'id' => 'smoking_fre', 'class' => 'removeSince '.$class, 'empty' => 'Please Select', 'options'=> $smokingOptions, 'label'=> false, 'div'=> false, 'style' => 'width:55%'));
						if($this->data['PatientPersonalHistory']['smoking']==1 || $this->data['PatientPersonalHistory']['smoking'] !=""){
                        					$show = 'blank';
                        				}else{
                        					$show  ='none';
                        				}
                        				?> </br> <span style="display:<?php echo $show ?>;">
								<label id="smoking_info"
								style="cursor: pointer; text-decoration: underline;"
								class="removeSince " .$class><?php echo __('Fill information');?>
							</label>
						</span>
						</td>
						<td valign="top" width=17%><?php 
						echo $this->Form->input('PatientSmoking.patient_id',array('type'=>'hidden','value'=>$patient_id,'legend'=>false,'label'=>false,
												'class' => 'textBoxExpnd removeSince '.$class,'id' => ''));

										echo $this->Form->input('PatientSmoking.smoking_fre',array('type'=>'hidden','legend'=>false,'label'=>false,
												'class' => 'textBoxExpnd removeSince ','id' => ''));
if(!empty($this->data['PatientSmoking']['current_smoking_fre'])){
										echo $this->Form->input('SmokingStatusOncs.description',array('type'=>'text','legend'=>false,'label'=>false,
				                        			 	'class' => 'textBoxExpnd removeSince '.$class,'id' => 'smoking_fre0_id0','value'=>$smokingOptions[$this->data['PatientSmoking']['current_smoking_fre']],'readonly'=>'readonly'));//echo'to';
}
echo $this->Form->input('PatientSmoking.current_smoking_fre',array('type'=>'hidden','legend'=>false,'label'=>false,
												'class' => 'textBoxExpnd removeSince ','id' => ''));?> </br>
							</br> <?php if(!empty($this->data['PatientSmoking']['current_smoking_fre'])){
								//echo $this->Form->input('SmokingStatusOncs1.description',array('type'=>'text','legend'=>false,'label'=>false,
								//	'class' => 'textBoxExpnd removeSince '.$class,'id' => 'smoking_fre1_id1','value'=>$smokingOptions[$this->data['PatientSmoking']['smoking_fre']]));
								echo $smokingOptions[$this->data['PatientSmoking']['smoking_fre']];
							}
							echo $this->Form->input('PatientSmoking.smoking_fre2',array('type'=>'hidden','legend'=>false,'label'=>false,
										'class' => 'textBoxExpnd removeSince ','id' => 'smoking_fre_id'));
				                        			 ?></td>
					</tr>
					<!--  <tr>
							<td valign="top" class="tdLabel" id="boxSpace">Alcohol/ETOH</td>
							<td valign="top" class="tdLabel" id="boxSpace"><?php
							if($this->data['PatientPersonalHistory']['alcohol']==1){
			                        					$class = '';
			                        				}else{
			                        					$class  ='hidden';
			                        				}
			                        				$alcoholPersonalVal = isset($this->data['PatientPersonalHistory']['alcohol'])?$this->data['PatientPersonalHistory']['alcohol']:2 ;
			                        				echo $this->Form->radio('PatientPersonalHistory.alcohol', array('No','Yes'),array('value'=>$alcoholPersonalVal,'legend'=>false,'label'=>false,'class' => 'personal','id' => 'alcohol'));
			                        			 ?>
							</td>
							<td valign="top"><?php 
							echo $this->Form->input('PatientPersonalHistory.alcohol_desc',array('type'=>'text','legend'=>false,'label'=>false,
				                        			 	'class' => 'textBoxExpnd removeSince '.$class,'id' => 'alcohol_desc','placeHolder'=>'Since'));
				                        			 ?>
							</td>
							<td valign="top"><?php 
							echo $this->Form->input('PatientPersonalHistory.alcohol_fre',array('type'=>'text','legend'=>false,'label'=>false,
				                        			 	'class' => 'textBoxExpnd removeSince '.$class,'id' => 'alcohol_fre_id'));?>


							</td>


							<td valign="top"><?php 	


							$alcoholoption = array(
												'0 bottle per day (non-alcoholic or less than 100 in lifetime)' => '0 bottle per day (non-alcoholic or less than 100 in lifetime)',
												'0 bottle per day (previous alcoholic)' => '0 bottle per day (previous alcoholic)',
												'Few (1-3) bottle per day' => 'Few (1-3) bottle per day',
												'Upto 1 bottle per day' => 'Upto 1 bottle per day',
												'1-2 bottle per day' => '1-2 bottle per day',
												'2 or more bottle per day' => '2 or more bottle per day',
												'Current status unknown' => 'Current status unknown',

										);
										echo $this->Form->input('PatientPersonalHistory.alcohol_fre',array('type' => 'select', 'id' => 'alcohol_fre', 'class' => 'removeSince', 'empty' => 'Please Select', 'options'=> $alcoholoption, 'label'=> false, 'div'=> false, 'style' => 'width:55%'));
										?><span><label id="alcohol_fill"
									style="cursor: pointer; text-decoration: underline; display: none;"><?php echo __('Fill information');?>
								</label> </span>
							</td>
						</tr>-->
					<tr>
						<td valign="top" class="tdLabel" id="boxSpace">Alcohol/ETOH</td>
						<td colspan="4"><table>
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>Score</td>
								
								
								<tr>
									<td><?php $ques1=array('0'=>'Never','1'=>'Monthly or less','2'=>'2-4 times a month','3'=>'2-3 times a week','4'=>'4 or more times a week');
									echo "1. How often do you have a drink containing alcohol?";?></td>
									<td><?php echo $this->Form->input('PatientPersonalHistory.alchohol_q1',array('legend'=>false,'label'=>false,'options'=>$ques1,
			                        			 		'class' => 'textBoxExpnd alcohol-score ','id' => 'alcoholQ1','empty'=>'Please Select','style'=>'float:right;','autocomplete'=>"off"));?>
									</td>
									<td><?php echo $this->Form->input('PatientPersonalHistory.alchohol_q1',array('type'=>'text','legend'=>false,'label'=>false,
											'class' => 'textBoxExpnd','id' => 'alcoholQ1Score','autocomplete'=>"off",'disabled=disabled'));?>
									</td>
								</tr>
								<tr>
									<td><?php $ques2=array('0'=>'Never','1'=>'1 or 2','2'=>'3 or 4','3'=>'5 or 6','4'=>'7 to 9','4'=>'10 or more');
						 echo "2. How many drinks containing alcohol do you have on a typical day when you are drinking?";?>
									</td>
									<td><?php echo $this->Form->input('PatientPersonalHistory.alchohol_q2',array('legend'=>false,'label'=>false,'options'=>$ques2,
			                        			 		'class' => 'textBoxExpnd alcohol-score ','id' => 'alcoholQ2','empty'=>'Please Select','style'=>'float:right;','autocomplete'=>"off"));?>
									</td>
									<td><?php echo $this->Form->input('PatientPersonalHistory.alchohol_q2',array('type'=>'text','legend'=>false,'label'=>false,
											'class' => 'textBoxExpnd','id' => 'alcoholQ2Score','autocomplete'=>"off",'disabled=disabled'));?>
									</td>
								</tr>
								<tr>
									<td><?php $ques3=array('0'=>'Never ','1'=>'Less than monthly','2'=>'Monthly ','3'=>'Weekly ','4'=>'Daily or almost daily');
						 echo "3. If you drink, how often do you have 6 or more drinks on a single occasion?";?>
									</td>
									<td><?php echo $this->Form->input('PatientPersonalHistory.alchohol_q3',array('legend'=>false,'label'=>false,'options'=>$ques2,'class' => 'textBoxExpnd alcohol-score ','id' => 'alcoholQ3','empty'=>'Please Select','style'=>'float:right;','autocomplete'=>"off"));?>
									</td>
									<td><?php echo $this->Form->input('PatientPersonalHistory.alchohol_q3',array('type'=>'text','legend'=>false,'label'=>false,
											'class' => 'textBoxExpnd','id' => 'alcoholQ3Score','autocomplete'=>"off",'disabled=disabled'));?>
									</td>
								</tr>
								<tr id="alcholScoreTr">
									<td style="text-align: right;"><?php echo "Total Score:";?></td>
									<td><?php echo $this->Form->input('PatientPersonalHistory.alcohol_score',
			             							array('type'=>'text','id'=>'alcholScore','legend'=>false,'label'=>false,'class' => 'textBoxExpnd','autocomplete'=>"off"))?>
									</td>
									<?php if($this->data['PatientPersonalHistory']['alcohol_score']>=5){
										$style="blank";
									}
									else{
													$style="none";
													}?>
									<!--  <td id="furtherAsses"style="display:<?php echo $style ?>;">
				             <?php 
				            	 echo "<font color='red'>Further Assessment is Required</font> ";
				             ?>
			             	<span style="float:right">
			             		<label id="alcohol_fill" style="cursor: pointer; text-decoration: underline;">
			             			<?php echo __('Withdrawal assessment score2');?>
								</label> 
							</span>
								
			             </td>
			             -->
									<td id="furtherAsses"style="display:<?php echo $style ?>;">
										<table width="100%">
											<tr>
												<td><?php  echo "<font color='red'>Further Assessment is Required</font> ";  ?>
												</td>
											</tr>
											<tr>
												<td width="100%"><font id="alcohol_fill"
													style="cursor: pointer; text-decoration: underline;"> <?php echo __('Withdrawal assessment score');?>
												</font>
												</td>
											</tr>
										</table>
									</td>
									<?php //if($alcohol_fill['AlcohalAssesment']['total_score']){?>
									<td id="alcohal_fill" style="display:<?php echo $style ?>;"><?php echo $this->Form->input('PatientPersonalHistory.alcohol_fill_info_score',
			             							array('type'=>'text','id'=>'alcholFillInfo','legend'=>false,'label'=>false,'class' => 'textBoxExpnd','autocomplete'=>"off",'value'=>$alcohol_fill['AlcohalAssesment']['total_score']))?>
									</td>
									<?php // }?>
								</tr>
							</table></td>
					</tr>
					<tr>
						<td valign="top" class="tdLabel" id="boxSpace">Substance Use/Drug</td>
						<td valign="top" class="tdLabel" id="boxSpace"><?php 
						if($this->data['PatientPersonalHistory']['drugs']==1){
			                        					$class = '';
			                        				}else{
			                        					$class  ='hidden';
			                        				}
			                        				$drugsPersonalVal = isset($this->data['PatientPersonalHistory']['drugs'])?$this->data['PatientPersonalHistory']['drugs']:2 ;
			                        				echo $this->Form->radio('PatientPersonalHistory.drugs', array('No','Yes'),array('value'=>$drugsPersonalVal,'legend'=>false,'label'=>false,
			                        			 	'class' => 'personal','id' => 'drug'));
			                        			 	?>
						</td>
						<td valign="top"><?php 
						echo $this->Form->input('PatientPersonalHistory.substance',array('type'=>'text','legend'=>false,'label'=>false,
			                        			 		'class' => 'textBoxExpnd removeSince '.$class,'id' => 'substance','placeholder'=>'substance'));
			                        				?>
						</td>
						<td valign="top"><?php 
						echo $this->Form->input('PatientPersonalHistory.drugs_desc',array('type'=>'text','legend'=>false,'label'=>false,
			                        			 		'class' => 'textBoxExpnd removeSince '.$class,'id' => 'drug_desc','placeholder'=>'Since'));
			                        				?>
						</td>
						<td valign="top"><?php 
						echo $this->Form->input('PatientPersonalHistory.drugs_fre',array('legend'=>false,'label'=>false,'class' => 'textBoxExpnd removeSince '.$class,'id' => 'drug_fre','placeholder'=>' Frequency '));
						?>
						</td>

					</tr>



					<tr>
						<td valign="top" class="tdLabel" id="boxSpace">Caffeine Usage</td>
						<td valign="top" class="tdLabel" id="boxSpace"><?php 
						if($this->data['PatientPersonalHistory']['tobacco']==1){
			                        					$class = '';
			                        				}else{
			                        					$class  ='hidden';
			                        				}
			                        				$tobaccoPersonalVal = isset($this->data['PatientPersonalHistory']['tobacco'])?$this->data['PatientPersonalHistory']['tobacco']:2 ;
			                        				echo $this->Form->radio('PatientPersonalHistory.tobacco', array('No','Yes'),array('value'=>$tobaccoPersonalVal,'legend'=>false,'label'=>false,'class' => 'personal','id' => 'tobacco'));
			                        			 ?>
						</td>
						<td valign="top"><?php	
						echo $this->Form->input('PatientPersonalHistory.tobacco_desc',array('type'=>'text','legend'=>false,'label'=>false,'class' => 'textBoxExpnd removeSince '.$class,'id' => 'tobacco_desc','placeHolder'=>'Since'));
						?>
						</td>
						<td valign="top"><?php	
						echo $this->Form->input('PatientPersonalHistory.tobacco_fre',array('type'=>'text','legend'=>false,'label'=>false,'class' => 'textBoxExpnd removeSince '.$class,'id' => 'tobacco_fre','placeHolder'=>'Frequency'));
						?>
						</td>
						<td><?php echo $this->Form->input('PatientPersonalHistory.another',array('empty'=>'Please Select','options'=>array('Daily'=>'Daily','Monthly '=>'Monthly','Yearly'=>'Yearly'),'value'=>$this->data['PatientPersonalHistory']['another'],'legend'=>false,'label'=>false,'class' => 'textBoxExpnd removeSince '.$class,'id' => 'tobacco_another','autocomplete'=>"off"));?>
						</td>
					</tr>
					<tr>
						<td valign="top" class="tdLabel" id="boxSpace">Diet/Nutrition</td>
						<!--  	<td valign="top" class="tdLabel" id="boxSpace"><?php 
							if($this->data['PatientPersonalHistory']['diet']==1){
			                        					$class = '';
			                        				}else{
			                        					$class  ='hidden';
			                        				}
			                        				$dietPersonalVal = isset($this->data['PatientPersonalHistory']['diet'])?$this->data['PatientPersonalHistory']['diet']:2 ;
			                        				echo $this->Form->radio('PatientPersonalHistory.diet', array('Veg','Non-Veg'),array('value'=>$dietPersonalVal,'legend'=>false,'label'=>false,'class' => 'personal','id' => 'diet'));
			                        			 ?>
							</td>
						-->
						<?php $dietoPtion = array('Best Bet Diet'=>'Best Bet Diet','Colon Cancer Diet'=>'Colon Cancer Diet','Diabetic diet'=>'Diabetic diet','DASH Diet'=>'DASH Diet','Elemental diet'=>'Elemental diet','Elimination die'=>'Elimination die','Gluten-free diet'=>'Gluten-free diet','Gluten-free, casein-free die'=>'Gluten-free, casein-free die','Healthy kidney diet'=>'Healthy kidney diet','Ketogenic diet'=>'Ketogenic diet','Liquid diet'=>'Liquid diet','Specific Carbohydrate Diet'=>'Specific Carbohydrate Diet','Strict Avoidance Diet'=>'Strict Avoidance Diet','Low sodium'=>'Low sodium','Low carbohydrate'=>'Low carbohydrate','Low-fat diet'=>'Low-fat diet','Low glycemic index diet'=>'Low glycemic index diet','Low-protein diet'=>'Low-protein diet','Low sodium diet'=>'Low sodium diet','cardiac diet'=>'cardiac diet','ADA diet'=>'ADA diet','high cholesterol diet'=>'high cholesterol diet','Regular diet'=>'Regular diet');?>
						<td valign="top" class="tdLabel" id="boxSpace"><?php echo $this->Form->input('PatientPersonalHistory.diet',array('empty'=>'Please Select','options'=>$dietoPtion,'value'=>$this->data['PatientPersonalHistory']['diet'],'legend'=>false,'label'=>false,'class' => 'textBoxExpnd ','id' => 'diet','autocomplete'=>"off"));?>

						</td>
						<td><?php echo __('Recent weight loss/gain');?> <?php	
						echo $this->Form->input('PatientPersonalHistory.diet_exp',array('type'=>'text','legend'=>false,'label'=>false,'class' => 'textBoxExpnd ','style'=>'width:100px;float:right;','id' => 'diet_exp','autocomplete'=>"off"));
						?>
						</td>
						<td><?php 
						if(strtolower($sex)=='female')
						{?> <?php echo __('Other Dietary/Nutrition');?> <?php
						echo $this->Form->input('PatientPersonalHistory.other_diet',array('empty'=>'Please Select','options'=>array('formula'=>'Formula','breast feeding'=>'Breast Feeding','solid foods'=>'Solid Foods'),'value'=>$this->data['PatientPersonalHistory']['other_diet'],'legend'=>false,'label'=>false,'class' => 'textBoxExpnd ','id' => 'other_diet','autocomplete'=>"off"));
						?></td>
						<?php  }
							
						?>
						</td>
						<td>&nbsp;</td>

					</tr>
					<tr>
						<td valign="top" class="tdLabel" id="boxSpace">Occupational Risk</td>
						<td valign="top" colspan="4" class="tdLabel" id="boxSpace"><?php 
						if($this->data['PatientPersonalHistory']['work']==1){
			                        					$class = '';
			                        				}else{
			                        					$class  ='hidden';
			                        				}
			                        				//$workPersonalVal = isset($this->data['PatientPersonalHistory']['work'])?$this->data['PatientPersonalHistory']['work']:null ;
			                        				//echo $this->Form->radio('PatientPersonalHistory.work', array('Chemical','Sound','Injuries','Stress'),array('value'=>$workPersonalVal,'legend'=>false,'label'=>false,'id' => 'work'));



			                        				echo $this->Form->input('PatientPersonalHistory.chemical', array('type'=>'checkbox'));echo __('Chemical');
			                        				//'&nbsp';'&nbsp';'&nbsp';'&nbsp';'&nbsp';
			                        				echo $this->Form->input('PatientPersonalHistory.sound', array('type'=>'checkbox'));echo __('Sound');
			                        				//'&nbsp';'&nbsp';'&nbsp';'&nbsp';'&nbsp';
			                        				echo $this->Form->input('PatientPersonalHistory.injuries', array('type'=>'checkbox'));echo __('Injuries');
			                        				//'&nbsp';'&nbsp';'&nbsp';'&nbsp';'&nbsp';
			                        				echo $this->Form->input('PatientPersonalHistory.stress', array('type'=>'checkbox'));echo __('Stress');
			                        			 ?></td>


					</tr>
					<tr>
						<td class="tdLabel " id="boxSpace">Status of Military Services</td>

						<td valign="top" colspan="4" class="tdLabel" id="boxSpace"><?php echo $this->Form->radio('PatientPersonalHistory.military_services', array('Not applicable','Active','Retired','Separated','Reserve'),array('value'=>$this->data['PatientPersonalHistory']['military_services'],'legend'=>false,'label'=>false,'id' => 'military_services')); ?>

						</td>

					</tr>
					<tr>
						<td class="tdLabel " id="boxSpace">Exercise</td>
						<td class="tdLabel" id="boxSpace"><?php
						echo $this->Form->radio('PatientPersonalHistory.exercise', array('0'=>'No','1'=>'Yes'),array('value'=>$this->data['PatientPersonalHistory']['exercise'],'legend'=>false,'label'=>false,'class'=>'exercise','id'=>'exercise','checked'=>$this->data['PatientPersonalHistory']['exercise']));
						if(!empty($this->data['PatientPersonalHistory']['exercise'])){
											$displayexerciseValue='block';
										}else{
											$displayexerciseValue='none';
										}?>
						</td>

						<td>
							<div id="showExercise1" style="display:<?php echo $displayexerciseValue ?>;">
								<?php echo __('Type');?>
								<?php echo $this->Form->input('PatientPersonalHistory.exercise_type',array('type'=>'text','legend'=>false,'label'=>false,'class' => 'textBoxExpnd','id' => 'exercise_type','value'=>$this->data['PatientPersonalHistory']['exercise_type'],'autocomplete'=>"off"));	
								?>
								<div id="showExercise1" style="display: $displayexerciseValue;">
						
						</td>

						<td><div id="showExercise2" style="display:<?php echo $displayexerciseValue ?>;">
								<?php echo __('Frequency');?>
								<?php echo $this->Form->input('PatientPersonalHistory.exercise_frequency',array('type'=>'text','legend'=>false,'label'=>false,'class' => 'textBoxExpnd','id' => 'exercise_frequency','value'=>$this->data['PatientPersonalHistory']['exercise_frequency'],'autocomplete'=>"off"));	
								?>
							</div>
						</td>
						<td>
							<div id="showExercise3" style="display:<?php echo $displayexerciseValue ?>;">
								<?php echo __('Duration');?>
								<?php echo $this->Form->input('PatientPersonalHistory.exercise_duration',array('type'=>'text','legend'=>false,'label'=>false,'class' => 'textBoxExpnd','id' => 'exercise_duration','value'=>$this->data['PatientPersonalHistory']['exercise_duration'],'autocomplete'=>"off"));	
								?>
							</div>
						</td>

					</tr>
					<tr>
						<td valign="top" class="tdLabel" id="boxSpace">Suicidal Thoughts</td>
						<td valign="top" class="tdLabel" id="boxSpace"><?php 
						if($this->data['PatientPersonalHistory']['suicidal_thoughts']==1){
			                        					$class = '';
			                        				}else{
			                        					$class  ='hidden';
			                        				}
			                        				$suicidalPersonalVal = isset($this->data['PatientPersonalHistory']['suicidal_thoughts'])?$this->data['PatientPersonalHistory']['suicidal_thoughts']:2 ;
			                        				echo $this->Form->radio('PatientPersonalHistory.suicidal_thoughts', array('0'=>'No','1'=>'Yes'),array('value'=>$suicidalPersonalVal,'legend'=>false,'label'=>false,'id' => 'suicidal_thoughts'));
			                        			 ?>
						</td>
						<td valign="top" class="tdLabel" id="boxSpace">Suicide Plan</td>
						<td valign="top" colspan="3" class="tdLabel" id="boxSpace"><?php 
						if($this->data['PatientPersonalHistory']['suicidal_plan']==1){
			                        					$class = '';
			                        				}else{
			                        					$class  ='hidden';
			                        				}
			                        				$suicidalPlanVal = isset($this->data['PatientPersonalHistory']['suicidal_plan'])?$this->data['PatientPersonalHistory']['suicidal_plan']:2 ;
			                        				echo $this->Form->radio('PatientPersonalHistory.suicidal_plan', array('0'=>'No','1'=>'Yes'),array('value'=>$suicidalPlanVal,'legend'=>false,'label'=>false,'id' => 'suicidal_plan'));
			                        			 ?>
						</td>
					</tr>
					<tr>
						<td valign="top" class="tdLabel" id="boxSpace">Retired</td>
						<td valign="top" class="tdLabel" id="boxSpace"><?php 
						if($this->data['PatientPersonalHistory']['retired']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}
                        				echo $this->Form->radio('PatientPersonalHistory.retired', array('No'=>'No','Yes'=>'Yes'),array('value'=>$getpatient[0]['PatientPersonalHistory']['retired'],'legend'=>false,'label'=>false));
                        			 ?>
						</td>
						<td valign="top"></td>
						<td valign="top"></td>
						<td>&nbsp;</td>
					</tr>
				</table>
			</td>
			<td width="30">&nbsp;</td>
			<td width="19%" valign="top" class="tdLabel" id="boxSpace"
				style="padding-top: 10px;">&nbsp;</td>
			<td width="" valign="top">&nbsp;</td>
		</tr>


		<tr id="Family_History_link">

			<td colspan="4" style="" width="100%">
				<table>
					<tr>
						<td
							style="font-size: 13px; color: #31859c !important; font-weight: bold;">Family
							History</td>
					</tr>
				</table> <?php //debug($getpatientfamilyhistry);?>
				<table width="100%" border="0" cellspacing="1" cellpadding="0"
					class="tabularForm">
					<?php foreach($getpatientfamilyhistry as $getpatientfamilyhistory) ?>
					<?php
					/*unserialize staring */

					$getpatientfamilyhistory["FamilyHistory"]['problemf']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['problemf']));
					$getpatientfamilyhistory["FamilyHistory"]['statusf']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['statusf']));
					$getpatientfamilyhistory["FamilyHistory"]['commentsf']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['commentsf']));

					$getpatientfamilyhistory["FamilyHistory"]['problemm']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['problemm']));
					$getpatientfamilyhistory["FamilyHistory"]['statusm']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['statusm']));
					$getpatientfamilyhistory["FamilyHistory"]['commentsm']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['commentsm']));

					$getpatientfamilyhistory["FamilyHistory"]['problemb']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['problemb']));
					$getpatientfamilyhistory["FamilyHistory"]['statusb']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['statusb']));
					$getpatientfamilyhistory["FamilyHistory"]['commentsb']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['commentsb']));

					$getpatientfamilyhistory["FamilyHistory"]['problems']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['problems']));
					$getpatientfamilyhistory["FamilyHistory"]['statuss']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['statuss']));
					$getpatientfamilyhistory["FamilyHistory"]['commentss']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['commentss']));

					$getpatientfamilyhistory["FamilyHistory"]['problemson']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['problemson']));
					$getpatientfamilyhistory["FamilyHistory"]['statusson']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['statusson']));
					$getpatientfamilyhistory["FamilyHistory"]['commentsson']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['commentsson']));

					$getpatientfamilyhistory["FamilyHistory"]['problemd']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['problemd']));
					$getpatientfamilyhistory["FamilyHistory"]['statusd']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['statusd']));
					$getpatientfamilyhistory["FamilyHistory"]['commentsd']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['commentsd']));

					$getpatientfamilyhistory["FamilyHistory"]['problemuncle']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['problemuncle']));
					$getpatientfamilyhistory["FamilyHistory"]['statusuncle']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['statusuncle']));
					$getpatientfamilyhistory["FamilyHistory"]['commentsuncle']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['commentsuncle']));

					$getpatientfamilyhistory["FamilyHistory"]['problemaunt']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['problemaunt']));
					$getpatientfamilyhistory["FamilyHistory"]['statusaunt']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['statusaunt']));
					$getpatientfamilyhistory["FamilyHistory"]['commentsaunt']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['commentsaunt']));

					$getpatientfamilyhistory["FamilyHistory"]['problemgrandmother']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['problemgrandmother']));
					$getpatientfamilyhistory["FamilyHistory"]['statusgrandmother']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['statusgrandmother']));
					$getpatientfamilyhistory["FamilyHistory"]['commentsgrandmother']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['commentsgrandmother']));

					$getpatientfamilyhistory["FamilyHistory"]['problemgrandfather']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['problemgrandfather']));
					$getpatientfamilyhistory["FamilyHistory"]['statusgrandfather']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['statusgrandfather']));
					$getpatientfamilyhistory["FamilyHistory"]['commentsgrandfather']=unserialize(stripslashes($getpatientfamilyhistory["FamilyHistory"]['commentsgrandfather']));
					/*  */


					/*  array_filter starting*/
					$getpatientfamilyhistory["FamilyHistory"]['problemf'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['problemf']));
					$getpatientfamilyhistory['FamilyHistory']['statusf'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['statusf']));
					$getpatientfamilyhistory['FamilyHistory']['commentsf'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['commentsf']));

					$getpatientfamilyhistory['FamilyHistory']['problemm'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['problemm']));
					$getpatientfamilyhistory['FamilyHistory']['statusm'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['statusm']));
					$getpatientfamilyhistory['FamilyHistory']['commentsm'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['commentsm']));

					$getpatientfamilyhistory['FamilyHistory']['problemb'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['problemb']));
					$getpatientfamilyhistory['FamilyHistory']['statusb'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['statusb']));
					$getpatientfamilyhistory['FamilyHistory']['commentsb'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['commentsb']));

					$getpatientfamilyhistory['FamilyHistory']['problems'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['problems']));
					$getpatientfamilyhistory['FamilyHistory']['statuss'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['statuss']));
					$getpatientfamilyhistory['FamilyHistory']['commentss'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['commentss']));

					$getpatientfamilyhistory['FamilyHistory']['problemson'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['problemson']));
					$getpatientfamilyhistory['FamilyHistory']['statusson'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['statusson']));
					$getpatientfamilyhistory['FamilyHistory']['commentsson'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['commentsson']));

					$getpatientfamilyhistory['FamilyHistory']['problemd'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['problemd']));
					$getpatientfamilyhistory['FamilyHistory']['statusd'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['statusd']));
					$getpatientfamilyhistory['FamilyHistory']['commentsd'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['commentsd']));

					$getpatientfamilyhistory['FamilyHistory']['problemuncle'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['problemuncle']));
					$getpatientfamilyhistory['FamilyHistory']['statusuncle'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['statusuncle']));
					$getpatientfamilyhistory['FamilyHistory']['commentsuncle'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['commentsuncle']));

					$getpatientfamilyhistory['FamilyHistory']['problemaunt'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['problemaunt']));
					$getpatientfamilyhistory['FamilyHistory']['statusaunt'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['statusaunt']));
					$getpatientfamilyhistory['FamilyHistory']['commentsaunt'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['commentsaunt']));

					$getpatientfamilyhistory['FamilyHistory']['problemgrandmother'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['problemgrandmother']));
					$getpatientfamilyhistory['FamilyHistory']['statusgrandmother'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['statusgrandmother']));
					$getpatientfamilyhistory['FamilyHistory']['commentsgrandmother'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['commentsgrandmother']));

					$getpatientfamilyhistory['FamilyHistory']['problemgrandfather'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['problemgrandfather']));
					$getpatientfamilyhistory['FamilyHistory']['statusgrandfather'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['statusgrandfather']));
					$getpatientfamilyhistory['FamilyHistory']['commentsgrandfather'] = array_values(array_filter($getpatientfamilyhistory['FamilyHistory']['commentsgrandfather']));


					?>
					<tr>
						<td width="22%" class="tdLabel" id="boxSpace" align="center"><?php if($getpatientfamilyhistory["FamilyHistory"]["is_positive_family"] == 1){
							echo $this->Form->checkbox('is_positive_family', array('id' => 'is_positive_family','checked' => 'checked'));
						}else if(!empty($getpatientfamilyhistory["FamilyHistory"]['problemf']) /* || !empty($getpatientfamilyhistory["FamilyHistory"]['statusf']) || !empty($getpatientfamilyhistory["FamilyHistory"]['commentsf']) ||
										 !empty($getpatientfamilyhistory["FamilyHistory"]['problemm']) || !empty($getpatientfamilyhistory["FamilyHistory"]['statusm']) || !empty($getpatientfamilyhistory["FamilyHistory"]['commentsm']) ||
										 !empty($getpatientfamilyhistory["FamilyHistory"]['problemb']) || !empty($getpatientfamilyhistory["FamilyHistory"]['statusb']) || !empty($getpatientfamilyhistory["FamilyHistory"]['commentsb']) ||
										 !empty($getpatientfamilyhistory["FamilyHistory"]['problems']) || !empty($getpatientfamilyhistory["FamilyHistory"]['statuss']) || !empty($getpatientfamilyhistory["FamilyHistory"]['commentss']) ||
									 	 !empty($getpatientfamilyhistory["FamilyHistory"]['problemson']) || !empty($getpatientfamilyhistory["FamilyHistory"]['statusson']) || !empty($getpatientfamilyhistory["FamilyHistory"]['commentsson']) ||
									 	 !empty($getpatientfamilyhistory["FamilyHistory"]['problemd']) || !empty($getpatientfamilyhistory["FamilyHistory"]['statusd']) || !empty($getpatientfamilyhistory["FamilyHistory"]['commentsd']) ||
										 !empty($getpatientfamilyhistory["FamilyHistory"]['problemuncle']) || !empty($getpatientfamilyhistory["FamilyHistory"]['statusuncle']) || !empty($getpatientfamilyhistory["FamilyHistory"]['commentsuncle'])||
										 !empty($getpatientfamilyhistory["FamilyHistory"]['problemaunt']) || !empty($getpatientfamilyhistory["FamilyHistory"]['statusaunt']) || !empty($getpatientfamilyhistory["FamilyHistory"]['commentsaunt'])||
										 !empty($getpatientfamilyhistory["FamilyHistory"]['problemgrandmother']) || !empty($getpatientfamilyhistory["FamilyHistory"]['statusgrandmother']) || !empty($getpatientfamilyhistory["FamilyHistory"]['commentsgrandmother']) ||
										 !empty($getpatientfamilyhistory["FamilyHistory"]['problemgrandfather']) || !empty($getpatientfamilyhistory["FamilyHistory"]['statusgrandfather']) || !empty($getpatientfamilyhistory["FamilyHistory"]['commentsgrandfather']) */ ){
									echo $this->Form->checkbox('is_positive_family',array('id' => 'is_positive_family','disabled'=>'disabled'));
								}else{
									echo $this->Form->checkbox('is_positive_family',array('id' => 'is_positive_family'));
								}		?>
							<?php echo __('No Positive Family History')?>
						</td>
					</tr>
				</table> <?php if($getpatientfamilyhistory["FamilyHistory"]["is_positive_family"] == 1){
					$displayIs='none';
				}else{
											$displayIs='block';
										}
										echo $this->Form->hidden('FamilyHistory.appointment_id',array('value'=>$appointment_id,'id'=>'appointment_id','type'=>'text'));?>
				<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm" id="fmly" style="display: <?php echo $displayIs ?>;">
					<tr>
						<td width="30%" class="tdLabel" id="boxSpace" align="center"><b>Relation</b>
						</td>
						<td width="30%" class="tdLabel" id="boxSpace" align="center"><b>Problem</b>
						</td>
						<td width="30%" class="tdLabel" id="boxSpace" align="center"><b>Status</b>
						</td>
						<td width="30%" class="tdLabel" id="boxSpace" align="center"><b>Significant
								Injuries</b></td>
						<td></td>
						<td></td>
					</tr>
					<?php if(isset($getpatientfamilyhistory["FamilyHistory"]['problemf']) && !empty($getpatientfamilyhistory["FamilyHistory"]['problemf']))
						$countf=count($getpatientfamilyhistory["FamilyHistory"]['problemf']);
					else
						$countf=1;

					for($i=0;$i<$countf;)
					{
						$problemf= isset($getpatientfamilyhistory["FamilyHistory"]['problemf'][$i])?$getpatientfamilyhistory["FamilyHistory"]['problemf'][$i]:'' ;
						
						$statusf= isset($getpatientfamilyhistory["FamilyHistory"]['statusf'][$i])?$getpatientfamilyhistory["FamilyHistory"]['statusf'][$i]:'' ;
						
						$commentsf= isset($getpatientfamilyhistory["FamilyHistory"]['commentsf'][$i])?$getpatientfamilyhistory["FamilyHistory"]['commentsf'][$i]:'' ;
						?>
					<tr id="frow" class="father">
						<td class="tdLabel" id="boxSpace">
							<?php if($i==0)echo __('Father'); ?>
						</td>
						<td><?php  echo $this->Form->input('problemf', array('name'=>'data[Diagnosis][problemf][]','class' =>'problemAutocomplete textBoxExpnd','id' =>'father','style'=>'width:270px','value'=>$problemf)); ?>
						</td>
						<td><?php echo $this->Form->input('statusf',array('name'=>'data[Diagnosis][statusf][]','options'=>Configure::read('problemStatus'),'value'=>$statusf,'style'=>'width:270px','id' => 'Statusfather')); ?>
						</td>
						<td><?php echo $this->Form->input('commentsf', array('name'=>'data[Diagnosis][commentsf][]','class' => 'textBoxExpnd','style'=>'width:270px','id' => 'Comments','value'=>$commentsf,'autocomplete'=>"off")); ?>
						</td>
						<td><?php if($i==0){ 
							if($this->params->named['slug']!='true'){?><input type="button"
							id="addfather" value="Add"> <?php }
						}?>
						</td>
						<td>
							<?php 
								if($i==0 && $countf==0){
									if($this->params->named['slug']!='true'){
							?>
							<input type="button" id="removefather" value="Remove" style="display:none;">
							<?php }
								}
								if($i==0 && $countf!=0){
							?>
							<input type="button" id="removefather" value="Remove">
							<?php }?>
						</td>
					</tr>
					<?php $i++; 
}?>

					<?php if(isset($getpatientfamilyhistory["FamilyHistory"]['problemm']) && !empty($getpatientfamilyhistory["FamilyHistory"]['problemm']))
						$countm=count($getpatientfamilyhistory["FamilyHistory"]['problemm']);
					else
						$countm=1;

					for($j=0;$j<$countm;)
					{
						$problemm= isset($getpatientfamilyhistory["FamilyHistory"]['problemm'][$j])?$getpatientfamilyhistory["FamilyHistory"]['problemm'][$j]:'' ;
						$statusm= isset($getpatientfamilyhistory["FamilyHistory"]['statusm'][$j])?$getpatientfamilyhistory["FamilyHistory"]['statusm'][$j]:'' ;
						$commentsm= isset($getpatientfamilyhistory["FamilyHistory"]['commentsm'][$j])?$getpatientfamilyhistory["FamilyHistory"]['commentsm'][$j]:'' ;
						?>
					<tr id="mrow" class="mother">
						<td class="tdLabel" id="boxSpace"><?php if($j==0)echo __('Mother'); ?>
						</td>
						<td><?php  echo $this->Form->input('problemm', array('name'=>'data[Diagnosis][problemm][]','style'=>'width:270px','class' =>'problemAutocomplete textBoxExpnd','id' =>'mother','value'=>$problemm)); ?>
						</td>
						<td><?php echo $this->Form->input('statusm',array('name'=>'data[Diagnosis][statusm][]','options'=>Configure::read('problemStatus'),'style'=>'width:270px','value'=>$statusm,'id' => 'Statusmother')); ?>
						</td>
						<td><?php echo $this->Form->input('commentsm', array('name'=>'data[Diagnosis][commentsm][]','class' => ' textBoxExpnd','id' => 'Comments','value'=>$commentsm,'style'=>'width:270px','autocomplete'=>"off")); ?>
						</td>
						<td><?php if($j==0){
							if($this->params->named['slug']!='true'){?><input type="button"
							id="addmother" value="Add"> <?php }
						}?>
						</td>
						<td><?php if($j==0){
							if($this->params->named['slug']!='true'){?><input type="button"
							id="removemother" value="Remove"> <?php }
						}?>
						</td>
					</tr>
					<?php $j++; 
}?>

					<?php if(isset($getpatientfamilyhistory["FamilyHistory"]['problemb']) && !empty($getpatientfamilyhistory["FamilyHistory"]['problemb']))
						$countb=count($getpatientfamilyhistory["FamilyHistory"]['problemb']);
					else
						$countb=1;

					for($k=0;$k<$countb;)
					{
						$problemb= isset($getpatientfamilyhistory["FamilyHistory"]['problemb'][$k])?$getpatientfamilyhistory["FamilyHistory"]['problemb'][$k]:'' ;
						$statusb= isset($getpatientfamilyhistory["FamilyHistory"]['statusb'][$k])?$getpatientfamilyhistory["FamilyHistory"]['statusb'][$k]:'' ;
						$commentsb= isset($getpatientfamilyhistory["FamilyHistory"]['commentsb'][$k])?$getpatientfamilyhistory["FamilyHistory"]['commentsb'][$k]:'' ;
						?>
					<tr id="brow" class="brother">
						<td class="tdLabel" id="boxSpace">
							<?php if($k==0)echo __('Brother'); ?>
						</td>
						<td><?php  echo $this->Form->input('problemb', array('name'=>'data[Diagnosis][problemb][]','class' =>'problemAutocomplete textBoxExpnd','id' =>'brother','value'=>$problemb,'style'=>'width:270px')); ?>
						</td>
						<td><?php echo $this->Form->input('statusb',array('name'=>'data[Diagnosis][statusb][]','options'=>Configure::read('problemStatus'),'value'=>$statusb,'style'=>'width:270px','id' => 'Statusbrother')); ?>
						</td>
						<td><?php echo $this->Form->input('commentsb', array('name'=>'data[Diagnosis][commentsb][]','class' => 'textBoxExpnd','id' => 'Comments','style'=>'width:270px','value'=>$commentsb,'autocomplete'=>"off")); ?>
						</td>
						<td><?php if($k==0){
							if($this->params->named['slug']!='true'){?><input type="button"
							id="addbrother" value="Add"> <?php }
						}?>
						</td>
						<td><?php if($k==0){
							if($this->params->named['slug']!='true'){?><input type="button"
							id="removebrother" value="Remove"> <?php }
						}?>
						</td>
					</tr>
					<?php $k++; 
}?>

					<?php if(isset($getpatientfamilyhistory["FamilyHistory"]['problems']) && !empty($getpatientfamilyhistory["FamilyHistory"]['problems']))
						$counts=count($getpatientfamilyhistory["FamilyHistory"]['problems']);
					else
						$counts=1;

					for($l=0;$l<$counts;)
					{
						$problems= isset($getpatientfamilyhistory["FamilyHistory"]['problems'][$l])?$getpatientfamilyhistory["FamilyHistory"]['problems'][$l]:'' ;
						$statuss= isset($getpatientfamilyhistory["FamilyHistory"]['statuss'][$l])?$getpatientfamilyhistory["FamilyHistory"]['statuss'][$l]:'' ;
						$commentss= isset($getpatientfamilyhistory["FamilyHistory"]['commentss'][$l])?$getpatientfamilyhistory["FamilyHistory"]['commentss'][$l]:'' ;
						?>
					<tr id="srow" class="sister">
						<td class="tdLabel" id="boxSpace">
							<?php if($l==0)echo __('Sister'); ?>
						</td>
						<td><?php  echo $this->Form->input('problems', array('name'=>'data[Diagnosis][problems][]','class' =>'problemAutocomplete textBoxExpnd','style'=>'width:270px','id' =>'sister','value'=>$problems)); ?>
						</td>
						<td><?php echo $this->Form->input('statuss',array('name'=>'data[Diagnosis][statuss][]','options'=>Configure::read('problemStatus'),'value'=>$statuss,'style'=>'width:270px','id' => 'Statussister')); ?>
						</td>
						<td><?php echo $this->Form->input('commentss', array('name'=>'data[Diagnosis][commentss][]','class' => 'textBoxExpnd','style'=>'width:270px','id' => 'Comments','value'=>$commentss,'autocomplete'=>"off")); ?>
						</td>
						<td><?php if($l==0){
							if($this->params->named['slug']!='true'){?><input type="button"
							id="addsister" value="Add"> <?php }
						}?>
						</td>
						<td><?php if($l==0){
							if($this->params->named['slug']!='true'){?><input type="button"
							id="removesister" value="Remove"> <?php }
						}?>
						</td>
					</tr>
					<?php $l++; 
}?>

					<?php if(isset($getpatientfamilyhistory["FamilyHistory"]['problemson']) && !empty($getpatientfamilyhistory["FamilyHistory"]['problemson']))
						$countson=count($getpatientfamilyhistory["FamilyHistory"]['problemson']);
					else
						$countson=1;

					for($m=0;$m<$countson;)
					{
						$problemson= isset($getpatientfamilyhistory["FamilyHistory"]['problemson'][$m])?$getpatientfamilyhistory["FamilyHistory"]['problemson'][$m]:'' ;
						$statusson= isset($getpatientfamilyhistory["FamilyHistory"]['statusson'][$m])?$getpatientfamilyhistory["FamilyHistory"]['statusson'][$m]:'' ;
						$commentsson= isset($getpatientfamilyhistory["FamilyHistory"]['commentsson'][$m])?$getpatientfamilyhistory["FamilyHistory"]['commentsson'][$m]:'' ;
						?>
					<tr id="sonrow" class="son">
						<td class="tdLabel" id="boxSpace"><?php if($m==0)echo __('Son'); ?>
						</td>
						<td><?php  echo $this->Form->input('problemson', array('name'=>'data[Diagnosis][problemson][]','style'=>'width:270px','class' =>'problemAutocomplete textBoxExpnd','id' =>'son','value'=>$problemson,'')); ?>
						</td>
						<td><?php echo $this->Form->input('statusson',array('name'=>'data[Diagnosis][statusson][]','options'=>Configure::read('problemStatus'),'value'=>$statusson,'id' => 'Statusson','style'=>'width:270px')); ?>
						</td>
						<td><?php echo $this->Form->input('commentsson', array('name'=>'data[Diagnosis][commentsson][]','style'=>'width:270px','class' => 'textBoxExpnd','id' => 'Comments','value'=>$commentsson,'autocomplete'=>"off")); ?>
						</td>
						<td><?php if($m==0){
							if($this->params->named['slug']!='true'){?><input type="button"
							id="addson" value="Add"> <?php }
						}?>
						</td>
						<td><?php if($m==0){
							if($this->params->named['slug']!='true'){?><input type="button"
							id="removeson" value="Remove"> <?php }
						}?>
						</td>
					</tr>
					<?php $m++; 
}?>

					<?php if(isset($getpatientfamilyhistory["FamilyHistory"]['problemd']) && !empty($getpatientfamilyhistory["FamilyHistory"]['problemd']))
						$countd=count($getpatientfamilyhistory["FamilyHistory"]['problemd']);
					else
						$countd=1;

					for($n=0;$n<$countd;)
					{
						$problemd= isset($getpatientfamilyhistory["FamilyHistory"]['problemd'][$n])?$getpatientfamilyhistory["FamilyHistory"]['problemd'][$n]:'' ;
						$statusd= isset($getpatientfamilyhistory["FamilyHistory"]['statusd'][$n])?$getpatientfamilyhistory["FamilyHistory"]['statusd'][$n]:'' ;
						$commentsd= isset($getpatientfamilyhistory["FamilyHistory"]['commentsd'][$n])?$getpatientfamilyhistory["FamilyHistory"]['commentsd'][$n]:'' ;
						?>
					<tr id="drow" class="daughter">
						<td class="tdLabel" id="boxSpace"><?php if($n==0)echo __('Daughter'); ?>
						</td>
						<td><?php  echo $this->Form->input('problemd', array('name'=>'data[Diagnosis][problemd][]','style'=>'width:270px','class' =>'problemAutocomplete textBoxExpnd','id' =>'daughter','value'=>$problemd,'')); ?>
						</td>
						<td><?php echo $this->Form->input('statusd',array('name'=>'data[Diagnosis][statusd][]','options'=>Configure::read('problemStatus'),'value'=>$statusd,'id' => 'Statusdaughter','style'=>'width:270px')); ?>
						</td>
						<td><?php echo $this->Form->input('commentsd', array('name'=>'data[Diagnosis][commentsd][]','style'=>'width:270px','class' =>'textBoxExpnd','id' => 'Comments','value'=>$commentsd,'autocomplete'=>"off")); ?>
						</td>
						<td><?php if($n==0){
							if($this->params->named['slug']!='true'){?><input type="button"
							id="adddaughter" value="Add"> <?php }
						}?>
						</td>
						<td><?php if($n==0){
							if($this->params->named['slug']!='true'){?><input type="button"
							id="removedaughter" value="Remove"> <?php }
						}?>
						</td>
					</tr>
					<?php $n++; 
}?>

					<tr id="otherrow" class="other_relative">
						<td class="tdLabel" id="boxSpace"><?php echo __('Other Relatives'); ?>
						</td>
						<td colspan="5"><?php echo $this->Form->input('other_relatives',array('options'=>array(""=>__('Please Select'),"Uncle"=>__('Uncle'),'Aunt'=>__('Aunt'),'Grandmother'=>__('Grandmother'),'Grandfather'=>__('Grandfather')),'value'=>$getpatientfamilyhistory['FamilyHistory']['other_relatives'],'id' => 'other_relatives','style'=>'width:270px')); ?>
						</td>

					</tr>

					<?php if(isset($getpatientfamilyhistory["FamilyHistory"]['problemuncle']) && !empty($getpatientfamilyhistory["FamilyHistory"]['problemuncle']))
						$countuncle=count($getpatientfamilyhistory["FamilyHistory"]['problemuncle']);
					else
						$countuncle=1;

					for($o=0;$o<$countuncle;)
					{
						$problemuncle= isset($getpatientfamilyhistory["FamilyHistory"]['problemuncle'][$o])?$getpatientfamilyhistory["FamilyHistory"]['problemuncle'][$o]:'' ;
						$statusuncle= isset($getpatientfamilyhistory["FamilyHistory"]['statusuncle'][$o])?$getpatientfamilyhistory["FamilyHistory"]['statusuncle'][$o]:'' ;
						$commentsuncle= isset($getpatientfamilyhistory["FamilyHistory"]['commentsuncle'][$o])?$getpatientfamilyhistory["FamilyHistory"]['commentsuncle'][$o]:'' ;
						?>
					<?php $unHideRelation = '';?>
					<?php if(empty($getpatientfamilyhistory["FamilyHistory"]['problemuncle'][$o])){
						$unHideRelation='showUncle';
							  }?>
					<tr id="showUncle" class="<?php echo $showUncle1 ?> uncle">
						<td class="tdLabel" id="boxSpace"><?php if($o==0)echo __('Uncle'); ?>
						</td>
						<td><?php  echo $this->Form->input('problemuncle', array('name'=>'data[Diagnosis][problemuncle][]','style'=>'width:270px','class' =>'problemAutocomplete textBoxExpnd','id' =>'uncle','value'=>$problemuncle,'','div'=>false)); ?>
						</td>
						<td><?php echo $this->Form->input('statusuncle',array('name'=>'data[Diagnosis][statusuncle][]','options'=>Configure::read('problemStatus'),'value'=>$statusuncle,'id' => 'statusuncle','style'=>'width:270px','div'=>false)); ?>
						</td>
						<td><?php echo $this->Form->input('commentsuncle', array('name'=>'data[Diagnosis][commentsuncle][]','style'=>'width:270px','class' =>'textBoxExpnd','id' => 'commentsuncle','value'=>$commentsuncle,'div'=>false)); ?>
						</td>
						<td><?php if($o==0){?><input type="button" id="adduncle"
							value="Add"> <?php }?></td>
						<td><?php if($o==0){?><input type="button" id="removeuncle"
							value="Remove"> <?php }?></td>
					</tr>
					<?php $o++; 
}?>

					<?php if(isset($getpatientfamilyhistory["FamilyHistory"]['problemaunt']) && !empty($getpatientfamilyhistory["FamilyHistory"]['problemaunt']))
						$countaunt=count($getpatientfamilyhistory["FamilyHistory"]['problemaunt']);
					else
						$countaunt=1;

					for($p=0;$p<$countaunt;)
					{
						$problemaunt= isset($getpatientfamilyhistory["FamilyHistory"]['problemaunt'][$p])?$getpatientfamilyhistory["FamilyHistory"]['problemaunt'][$p]:'' ;
						$statusaunt= isset($getpatientfamilyhistory["FamilyHistory"]['statusaunt'][$p])?$getpatientfamilyhistory["FamilyHistory"]['statusaunt'][$p]:'' ;
						$commentsaunt= isset($getpatientfamilyhistory["FamilyHistory"]['commentsaunt'][$p])?$getpatientfamilyhistory["FamilyHistory"]['commentsaunt'][$p]:'' ;
						?>

					<?php if(empty($getpatientfamilyhistory["FamilyHistory"]['problemaunt'][$p])){
						$unHideRelation .= ($unHideRelation) ? ',showAunt' : 'showAunt';
							  }?>
					<tr id="showAunt" class="<?php echo $showAunt1 ?> aunt">
						<td class="tdLabel" id="boxSpace"><?php if($p==0)echo __('Aunt'); ?>
						</td>
						<td><?php  echo $this->Form->input('problemaunt', array('name'=>'data[Diagnosis][problemaunt][]','style'=>'width:270px','class' =>'problemAutocomplete textBoxExpnd','id' =>'aunt','value'=>$problemaunt,'')); ?>
						</td>
						<td><?php echo $this->Form->input('statusaunt',array('name'=>'data[Diagnosis][statusaunt][]','options'=>Configure::read('problemStatus'),'value'=>$statusaunt,'id' => 'statusaunt','style'=>'width:270px')); ?>
						</td>
						<td><?php echo $this->Form->input('commentsaunt', array('name'=>'data[Diagnosis][commentsaunt][]','style'=>'width:270px','class' =>'textBoxExpnd','id' => 'commentsaunt','value'=>$commentsaunt)); ?>
						</td>
						<td><?php if($p==0){?><input type="button" id="addaunt"
							value="Add"> <?php }?></td>
						<td><?php if($p==0){?><input type="button" id="removeaunt"
							value="Remove"> <?php }?></td>
					</tr>
					<?php $p++; 
}?>

					<?php if(isset($getpatientfamilyhistory["FamilyHistory"]['problemgrandmother']) && !empty($getpatientfamilyhistory["FamilyHistory"]['problemgrandmother']))
						$countgm=count($getpatientfamilyhistory["FamilyHistory"]['problemgrandmother']);
					else
						$countgm=1;

					for($q=0;$q<$countgm;)
					{
						$problemgm= isset($getpatientfamilyhistory["FamilyHistory"]['problemgrandmother'][$q])?$getpatientfamilyhistory["FamilyHistory"]['problemgrandmother'][$q]:'' ;
						$statusgm= isset($getpatientfamilyhistory["FamilyHistory"]['statusgrandmother'][$q])?$getpatientfamilyhistory["FamilyHistory"]['statusgrandmother'][$q]:'' ;
						$commentsgm= isset($getpatientfamilyhistory["FamilyHistory"]['commentsgrandmother'][$q])?$getpatientfamilyhistory["FamilyHistory"]['commentsgrandmother'][$q]:'' ;
						?>

					<?php if(empty($getpatientfamilyhistory["FamilyHistory"]['problemgrandmother'][$q])){
						$unHideRelation .= ($unHideRelation) ? ',showGrandmother' : 'showGrandmother';
							  }?>
					<tr id="showGrandmother"
						class="<?php echo $showgrandmother1 ?> grandmother">
						<td class="tdLabel" id="boxSpace"><?php if($q==0)echo __('Grandmother'); ?>
						</td>
						<td><?php  echo $this->Form->input('problemgrandmother', array('name'=>'data[Diagnosis][problemgrandmother][]','style'=>'width:270px','class' =>'problemAutocomplete textBoxExpnd','id' =>'grandmother','value'=>$problemgm,'')); ?>
						</td>
						<td><?php echo $this->Form->input('statusgrandmother',array('name'=>'data[Diagnosis][statusgrandmother][]','options'=>Configure::read('problemStatus'),'value'=>$statusgm,'id' => 'statusgrandmother','style'=>'width:270px')); ?>
						</td>
						<td><?php echo $this->Form->input('commentsgrandmother', array('name'=>'data[Diagnosis][commentsgrandmother][]','style'=>'width:270px','class' =>'textBoxExpnd','id' => 'commentsgrandmother','value'=>$commentsgm)); ?>
						</td>
						<td><?php if($q==0){?><input type="button" id="addgrandmother"
							value="Add"> <?php }?></td>
						<td><?php if($q==0){?><input type="button" id="removegrandmother"
							value="Remove"> <?php }?></td>
					</tr>
					<?php $q++; 
}?>

					<?php if(isset($getpatientfamilyhistory["FamilyHistory"]['problemgrandfather']) && !empty($getpatientfamilyhistory["FamilyHistory"]['problemgrandfather']))
						$countgf=count($getpatientfamilyhistory["FamilyHistory"]['problemgrandfather']);
					else
						$countgf=1;

					for($r=0;$r<$countgf;)
					{
						$problemgf= isset($getpatientfamilyhistory["FamilyHistory"]['problemgrandfather'][$r])?$getpatientfamilyhistory["FamilyHistory"]['problemgrandfather'][$r]:'' ;
						$statusgf= isset($getpatientfamilyhistory["FamilyHistory"]['statusgrandfather'][$r])?$getpatientfamilyhistory["FamilyHistory"]['statusgrandfather'][$r]:'' ;
						$commentsgf= isset($getpatientfamilyhistory["FamilyHistory"]['commentsgrandfather'][$r])?$getpatientfamilyhistory["FamilyHistory"]['commentsgrandfather'][$r]:'' ;
						?>

					<?php if(empty($getpatientfamilyhistory["FamilyHistory"]['problemgrandfather'][$r])){
						$unHideRelation .= ($unHideRelation) ? ',showGrandfather' : 'showGrandfather';
							  }?>

					<tr id="showGrandfather"
						class="<?php echo $showgrandfather1 ?> grandfather">
						<td class="tdLabel" id="boxSpace"><?php if($r==0)echo __('Grandfather'); ?>
						</td>
						<td><?php  echo $this->Form->input('problemgrandfather', array('name'=>'data[Diagnosis][problemgrandfather][]','style'=>'width:270px','class' =>'problemAutocomplete textBoxExpnd','id' =>'grandfather','value'=>$problemgf,'')); ?>
						</td>
						<td><?php echo $this->Form->input('statusgrandfather',array('name'=>'data[Diagnosis][statusgrandfather][]','options'=>Configure::read('problemStatus'),'value'=>$statusgf,'id' => 'statusgrandfather','style'=>'width:270px')); ?>
						</td>
						<td><?php echo $this->Form->input('commentsgrandfather', array('name'=>'data[Diagnosis][commentsgrandfather][]','style'=>'width:270px','class' =>'textBoxExpnd','id' => 'commentsgrandfather','value'=>$commentsgf)); ?>
						</td>
						<td><?php if($r==0){?><input type="button" id="addgrandfather"
							value="Add"> <?php }?></td>
						<td><?php if($r==0){?><input type="button" id="removegrandfather"
							value="Remove"> <?php }?></td>
					</tr>
					<?php $r++; 
}?>
					<tr id="afterGrandfather"></tr>
				</table>
			</td>
		</tr>

		<?php 
		if(strtolower($sex)=='female')
		{

			?>

		<tr id="Obstetric_History_link">
			<td style="" width="100%" colspan="4">
				<table>
					<tr>
						<td
							style="font-size: 13px; color: #31859c !important; font-weight: bold;">Obstetric
							History</td>
					</tr>
				</table>
				<table width="100%" border="0" cellspacing="1" cellpadding="0"
					class="tabularForm">
					<tr>
						<td width="21%" class="tdLabel" id="boxSpace"><?php echo __('Age Onset of Menses:'); ?>
						</td>
						<td width="73%"><?php echo $this->Form->input('age_menses', array('class' => 'textBoxExpnd validate[optional,custom[onlyNumber]]','id' =>'age_menses','value'=>$getpatient['PastMedicalRecord']['age_menses'],'style'=>'width:270px','autocomplete'=>"off")); ?><font>&nbsp;Years</font>
						</td>
					</tr>

					<tr>
						<td class="tdLabel" id="boxSpace"><?php echo __('Length of Periods: '); ?>
						</td>
						<td><?php echo $this->Form->input('length_period', array('class' => 'textBoxExpnd validate[optional,custom[onlyNumber]]','id' =>'length_period','value'=>$getpatient['PastMedicalRecord']['length_period'],'style'=>'width:270px','autocomplete'=>"off")); ?><font>&nbsp;Days</font>
						</td>
					</tr>

					<tr>
						<td class="tdLabel" id="boxSpace"><?php echo __('Number of days between Periods: '); ?>
						</td>
						<td><?php echo $this->Form->input('days_betwn_period', array('class' => 'textBoxExpnd validate[optional,custom[onlyNumber]]','id' =>'days_betwn_period','value'=>$getpatient['PastMedicalRecord']['days_betwn_period'],'style'=>'width:270px','autocomplete'=>"off")); ?><font>&nbsp;Days</font>
						</td>
					</tr>

					<tr>
						<td class="tdLabel" id="boxSpace"><?php echo __('Any recent changes in Periods: '); ?>
						</td>
						<td><?php  $option_Periods = array(''=>'Please Select','Yes'=>'Yes','No'=>'No');
							echo $this->Form->input('Diagnosis.recent_change_period', array( 'options'=>$option_Periods,'style'=>'width:270px','class' => '','id'=>"recent_change_period",'value'=>$getpatient['PastMedicalRecord']['recent_change_period'])); ?>
						</td>
					</tr>

					<tr>
						<td class="tdLabel" id="boxSpace"><?php echo __('Age at Menopause: '); ?>
						</td>
						<td><?php echo $this->Form->input('age_menopause', array('class' => 'textBoxExpnd validate[optional,custom[onlyNumber]]','id' =>'age_menopause','value'=>$getpatient['PastMedicalRecord']['age_menopause'],'style'=>'width:270px','autocomplete'=>"off")); ?>
							<font>&nbsp;Years</font>
						</td>
					</tr>
				</table>
			</td>
		</tr>

		<tr id="">
			<td style="" width="100%" colspan="4">
				<table>
					<tr>
						<td style="font-size: 13px; color: #31859c !important; font-weight: bold;">
							Number of Pregnancies
						</td>
					</tr>
				</table>
				<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm" class="tdLabel">
					<tr>
						<td colspan="7">
							<table width="100%" border="0" cellspacing="1" cellpadding="0"
								class="tabularForm" class="tdLabel">
								<tr>
									<td width="5%" height="20px" align="center" valign="top"><b>Sr.
											No.</b></td>
									<td width="14%" height="20px" align="center" valign="top"><b>Date
											of Birth</b></td>
									<td width="14%" height="20px" align="center" valign="top"><b>Weight
											(in lbs)</b></td>
									<td width="13%" height="20px" align="center" valign="top"><b>Baby's
											Gender</b></td>
									<td width="14%" height="20px" align="center" valign="top"><b>Weeks
											Pregnant</b></td>
									<td width="14%" height="20px" align="center" valign="top"><b>Type
											of Delivery</b></td>
									<td width="14%" height="20px" align="center" valign="top"><b>Complications</b>
									</td>
									<td width="4%" height="20px" align="center" valign="top"><b>Action</b>
									</td>

								</tr>
							</table>
						</td>
					</tr>

					<tr>
						<td colspan="7">
							<table width="100%" border="0" cellspacing="1" cellpadding="0"
								class="tabularForm" id='DrugGroup_nw' class="tdLabel">
								<?php  
							if(isset($pregnancyData) && !empty($pregnancyData))
							{
								$count_nw  = count($pregnancyData);
							}else
							{
								$count_nw  = 3 ;
							}
							for($i=0;$i<$count_nw;)
							{
								$pregnancyData[$i]['PregnancyCount']['date_birth'] = $this->DateFormat->formatDate2Local($pregnancyData[$i]['PregnancyCount']['date_birth'],Configure::read('date_format'),true);
								$patient_id_val = isset($pregnancyData[$i]['PregnancyCount']['patient_id'])?$pregnancyData[$i]['PregnancyCount']['patient_id']:'' ;
								$counts_val = isset($pregnancyData[$i]['PregnancyCount']['counts'])?$pregnancyData[$i]['PregnancyCount']['counts']:'' ;
								$date_birth_val = isset($pregnancyData[$i]['PregnancyCount']['date_birth'])?$pregnancyData[$i]['PregnancyCount']['date_birth']:'' ;
								$weight_val = isset($pregnancyData[$i]['PregnancyCount']['weight'])?$pregnancyData[$i]['PregnancyCount']['weight']:'' ;
								$week_pregnant_val = isset($pregnancyData[$i]['PregnancyCount']['week_pregnant'])?$pregnancyData[$i]['PregnancyCount']['week_pregnant']:'' ;
								$baby_gender_val = isset($pregnancyData[$i]['PregnancyCount']['baby_gender'])?$pregnancyData[$i]['PregnancyCount']['baby_gender']:'' ;
								$type_delivery_val = isset($pregnancyData[$i]['PregnancyCount']['type_delivery'])?$pregnancyData[$i]['PregnancyCount']['type_delivery']:'' ;
								$complication_val = isset($pregnancyData[$i]['PregnancyCount']['complication'])?$pregnancyData[$i]['PregnancyCount']['complication']:'' ;
								$appointment_id_val = isset($pregnancyData[$i]['PregnancyCount']['appointment_id'])?$pregnancyData[$i]['PregnancyCount']['appointment_id']:'' ;
								?>
								<input type="hidden" class="allHiddenId"
									id="PregnancyCount_' + counter + '" name="pregnancy[id][]"
									value="<?php echo $pregnancyData[$i]['PregnancyCount']['id']?>">
								<tr id="DrugGroup_nw<?php echo $i;?>">

									<td width="5%" height="20px" align="left" valign="top"><?php echo $i+1?>
									</td>
									<?php echo $this->Form->hidden('', array('type'=>'text','id' => "patient_id$i",'class'=>'patient_id','name'=>'pregnancy[patient_id][]','value'=>$patient_id_val,'style'=>'width:130px','counter_nw'=>$i, 'readonly' => 'readonly','autocomplete'=>"off"));
										echo $this->Form->hidden('', array('type'=>'text','id' => "appointment_id$i",'class'=>'appointment_id','name'=>'pregnancy[appointment_id][]','value'=>$appointment_id_val,'style'=>'width:130px','counter_nw'=>$i, 'readonly' => 'readonly','autocomplete'=>"off")); ?>
									<td width="14%" height="20px" align="left" valign="top"
										class="tddate"><?php echo $this->Form->input('', array('type'=>'text','id' => "date_birth$i",'class'=>'date_birth','name'=>'pregnancy[date_birth][]','value'=>$date_birth_val,'style'=>'width:130px','counter_nw'=>$i, 'readonly' => 'readonly','autocomplete'=>"off")); ?>
									</td>

									<td width="14%" height="20px" align="left" valign="top"><?php  echo $this->Form->input('', array('type'=>'text' ,'class' =>'validate[optional,custom[onlyNumber]] textBoxExpnd','id'=>"weight$i",'value'=>$weight_val,'name'=>'pregnancy[weight][]',style=>'width:146px','counter_nw'=>$i,'autocomplete'=>"off")); ?>
									</td>

									<td width="13%" height="20px" align="left" valign="top"><?php  $options = array(''=>'Please Select','M'=>'Male','F'=>'Female');
										echo $this->Form->input('', array( 'options'=>$options,'style'=>'width:148px','class' => '','id'=>"baby_gender$i",'name' => 'pregnancy[baby_gender][]','value'=>trim($baby_gender_val))); ?>
									</td>

									<td width="14%" height="20px" align="left" valign="top"><?php  echo $this->Form->input('', array('type'=>'text' ,'class' =>'validate[optional,custom[onlyNumber]] textBoxExpnd','id'=>"week_pregnant$i",'value'=>$week_pregnant_val,'name'=>'pregnancy[week_pregnant][]','style'=>'width:146px','counter_nw'=>$i,'autocomplete'=>"off",'maxlength'=>'2')); ?>
									</td>

									<td width="14%" height="20px" align="left" valign="top"><?php  $delivery_options = array(''=>'Please Select','Vaginal Delivery - No Complications'=>'Vaginal Delivery - No Complications','Vaginal Delivery-Episiotomy'=>'Vaginal Delivery-Episiotomy','Vaginal Delivery-Induced labor'=>'Vaginal Delivery-Induced labor','Vaginal Delivery -Forceps delivery'=>'Vaginal Delivery -Forceps delivery','Vaginal Delivery-Vacuum extraction'=>'Vaginal Delivery-Vacuum extraction','Cesarean section'=>'Cesarean section');
										echo $this->Form->input('', array('options'=>$delivery_options ,'class' =>'textBoxExpnd','id'=>"type_delivery$i",'value'=>$type_delivery_val,'name'=>'pregnancy[type_delivery][]','style'=>'width:148px','counter_nw'=>$i)); ?>
									</td>

									<td width="14%" height="20px" align="left" valign="top"><?php echo $this->Form->input('', array('type'=>'text' ,'class' =>'textBoxExpnd','id'=>"complication$i",'value'=>$complication_val,'name'=>'pregnancy[complication][]','style'=>'width:145px','counter_nw'=>$i,'autocomplete'=>"off")); ?>
									</td>
									<td width="4%"><?php if($this->params->named['slug']!='true'){  
										$this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete','class'=>'DrugGroup_nw','id'=>"pregnancy$i"));
									}?></td>
								</tr>
								<?php
								$i++ ;
							}
							?>
							</table>
						</td>
					</tr>
					<?php if($this->params->named['slug']!='true'){?>
					<tr>
						<td align="right" colspan="7"
							style="border-bottom: solid 1px #3E474A;"><input type="button"
							id="addButton_nw" value="Add"> <?php if($count_nw > 0)
							{?> <!-- <input type="button" id="removeButton_nw" value="Remove">  -->
							<?php }
							else{ ?> <input type="button" id="removeButton_nw" value="Remove"
							style="display: none;"> <?php } ?></td>
					</tr>
					<?php }?>
					<tr>
						<td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Abortions, Still Births, Miscarriages: '); ?>
						</td>
						<td width="60%" colspan="6"><?php  echo $this->Form->input('abortions_miscarriage', array('class' =>'textBoxExpnd','id' =>'abortions_miscarriage','value'=>$getpatient['PastMedicalRecord']['abortions_miscarriage'],'style'=>'width:250px','autocomplete'=>"off")); ?>
						</td>
					</tr>

				</table>

			</td>
		</tr>



		<tr id="Gynecology_History_link">

			<td style="" width="100%" colspan="4">
				<table>
					<tr>
						<td
							style="font-size: 13px; color: #31859c !important; font-weight: bold;">Gynecology
							History</td>
					</tr>
				</table>
				<table width="100%" border="0" cellspacing="1" cellpadding="0"
					class="tabularForm" class="tabularForm" id='DrugGroup'
					class="tdLabel">
					<tr>
						<td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Present Symptoms:'); ?>
						</td>
						<td width="40%" class="tdLabel" id="boxSpace"><?php
						if($this->data['PastMedicalRecord']['present_symptom']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}

                        				echo $this->Form->radio('present_symptom', array('None'=>'None','Yes'=>'Yes'),array('value'=>$getpatient['PastMedicalRecord']['present_symptom'],'legend'=>false,'label'=>false));
                        			 ?>
						</td>
						<td width="40%"></td>
					</tr>

					<tr>
						<td class="tdLabel" id="boxSpace"><?php echo __('Past Infections: '); ?>
						</td>
						<td class="tdLabel" id="boxSpace"><?php
						if($this->data['PastMedicalRecord']['past_infection']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}

                        				echo $this->Form->radio('past_infection', array('None'=>'None','Chlamydia'=>'Chlamydia','Syphilis'=>'Syphilis','PID'=>'PID','Gonorrhea'=>'Gonorrhea','Other STD'=>'Other STD'),array('value'=>$getpatient['PastMedicalRecord']['past_infection'],'legend'=>false,'label'=>false));
                        			 ?>
						</td>
						<td></td>
					</tr>

					<tr>
						<td class="tdLabel " id="boxSpace"><span
							title="Papanicolaou smear">Last PAP</span>:</td>
						<td class="tdLabel" id="boxSpace"><?php
						/*if($this->data['PastMedicalRecord']['hx_abnormal_pap']==1){
						 $class = '';
                        				}else{
                        					$class  ='hidden';
                        				}
                        				$pastMedicalRecordVal = isset($this->data['PastMedicalRecord']['hx_abnormal_pap'])?$this->data['PastMedicalRecord']['hx_abnormal_pap']:2 ;
                        				*///echo $this->Form->radio('hx_abnormal_pap', array('None'=>'None','Yes'=>'Yes'),array('value'=>$getpatient['PastMedicalRecord']['hx_abnormal_pap'],'legend'=>false,'label'=>false));

	echo $this->Form->radio('PastMedicalRecord.hx_abnormal_pap', array('0'=>'None','1'=>'Yes'),array('value'=>$getpatient['PastMedicalRecord']['hx_abnormal_pap'],'legend'=>false,'class'=>'personalPAP','label'=>false,'id'=>'hx_abnormal_pap','checked'=>$getpatient['PastMedicalRecord']['hx_abnormal_pap']));

	if(!empty($getpatient['PastMedicalRecord']['hx_abnormal_pap'])){
                        					$displayPAPValue='block';
                        				}else{
											$displayPAPValue='none';
										}?>
						</td>
						<td>
							<div id="showPAP" style="display:<?php echo $displayPAPValue ?>;">
								<span> <?php 
								$getpatient['PastMedicalRecord']['hx_abnormal_pap_yes']=$this->DateFormat->formatDate2Local($getpatient['PastMedicalRecord']['hx_abnormal_pap_yes'],Configure::read('date_format'));
								echo $this->Form->input('PastMedicalRecord.hx_abnormal_pap_yes',array('type'=>'text','legend'=>false,'label'=>false,'class' => 'textBoxExpnd  hxabnormalpap_yes ','id' => 'hxabnormalpap_yes','readonly'=>'readonly','value'=>$getpatient['PastMedicalRecord']['hx_abnormal_pap_yes'],'autocomplete'=>"off"));
								/// removeSince '.$class
								?>
								</span>
							</div>
						</td>
					</tr>
					<tr>
						<td class="tdLabel " id="boxSpace">Last Mammography</td>
						<td class="tdLabel" id="boxSpace"><?php
						/*if($this->data['PastMedicalRecord']['last_mammography']==1){
						 $class1 = '';
                        				}else{
                        					$class1  ='hidden';
                        				}
                        				$lastMammographyVal = isset($this->data['PastMedicalRecord']['last_mammography'])?$this->data['PastMedicalRecord']['last_mammography']:2 ;
                        				//echo $this->Form->radio('hx_abnormal_pap', array('None'=>'None','Yes'=>'Yes'),array('value'=>$getpatient['PastMedicalRecord']['hx_abnormal_pap'],'legend'=>false,'label'=>false));
                        				*/
										echo $this->Form->radio('PastMedicalRecord.last_mammography', array('0'=>'None','1'=>'Yes'),array('value'=>$getpatient['PastMedicalRecord']['last_mammography'],'legend'=>false,'label'=>false,'class' => 'personalMammography','id'=>'last_mammography','checked'=>$getpatient['PastMedicalRecord']['last_mammography']));
										if(!empty($getpatient['PastMedicalRecord']['last_mammography'])){
											$displaymammographyValue='block';
										}else{
											$displaymammographyValue='none';
										}?>
						</td>
						<td>
							<div id="showMammography" style="display:<?php echo $displaymammographyValue ?>;">
								<span> <?php $getpatient['PastMedicalRecord']['last_mammography_yes']=$this->DateFormat->formatDate2Local($getpatient['PastMedicalRecord']['last_mammography_yes'],Configure::read('date_format'));
								echo $this->Form->input('PastMedicalRecord.last_mammography_yes',array('type'=>'text','legend'=>false,'label'=>false,'class' => 'textBoxExpnd  last_mammography_yes ','id' => 'last_mammography_yes','readonly'=>'readonly','value'=>$getpatient['PastMedicalRecord']['last_mammography_yes'],'autocomplete'=>"off"));
								/// removeSince '.$class
								?>
								</span>
							</div>
						</td>
					</tr>

					<tr>
						<td class="tdLabel" id="boxSpace"><?php echo __('History of cervical biopsy: '); ?>
						</td>
						<td class="tdLabel" id="boxSpace"><?php
						if($this->data['PastMedicalRecord']['hx_cervical_bx']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}

                        				echo $this->Form->radio('hx_cervical_bx', array('None'=>'None','Yes'=>'Yes'),array('value'=>$getpatient['PastMedicalRecord']['hx_cervical_bx'],'legend'=>false,'label'=>false));
                        			 ?>
						</td>
						<td></td>
					</tr>

					<tr>
						<td class="tdLabel" id="boxSpace"><?php echo __('History of fertility drugs: '); ?>
						</td>
						<td class="tdLabel" id="boxSpace"><?php
						if($this->data['PastMedicalRecord']['hx_fertility_drug']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}

                        				echo $this->Form->radio('hx_fertility_drug', array('None'=>'None','Yes'=>'Yes'),array('value'=>$getpatient['PastMedicalRecord']['hx_fertility_drug'],'legend'=>false,'label'=>false));
                        			 ?>
						</td>
						<td></td>
					</tr>

					<tr>
						<td class="tdLabel" id="boxSpace">History of <span
							title="Hormone Replacement Therapy "> HRT </span> use:
						</td>
						<td class="tdLabel" id="boxSpace"><?php
						if($this->data['PastMedicalRecord']['hx_hrt_use']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}

                        				echo $this->Form->radio('hx_hrt_use', array('None'=>'None','Yes'=>'Yes'),array('value'=>$getpatient['PastMedicalRecord']['hx_hrt_use'],'legend'=>false,'label'=>false));
                        			 ?>
						</td>
						<td></td>
					</tr>

					<tr>
						<td class="tdLabel" id="boxSpace"><?php echo __('History of irregular menses: '); ?>
						</td>
						<td class="tdLabel" id="boxSpace"><?php
						if($this->data['PastMedicalRecord']['hx_irregular_menses']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}

                        				echo $this->Form->radio('hx_irregular_menses', array('None'=>'None','Yes'=>'Yes'),array('value'=>$getpatient['PastMedicalRecord']['hx_irregular_menses'],'legend'=>false,'label'=>false));
                        			 ?>
						</td>
						<td></td>
					</tr>

					<tr>
						<td class="tdLabel" id="boxSpace"><span
							title="Last Menstrual Period "> L.M.P. </span>:</td>
						<?php $getpatient['PastMedicalRecord']['lmp'] = $this->DateFormat->formatDate2Local($getpatient['PastMedicalRecord']['lmp'],Configure::read('date_format'),true); ?>
						<td width="60%" class="tdLabel" id="boxSpace"><?php echo $this->Form->input('lmp', array('type'=>'text','id' =>'lmp','readonly'=>'readonly','class'=>'textBoxExpnd','value'=>$getpatient['PastMedicalRecord']['lmp'],'style'=>'width:120px','autocomplete'=>"off")); ?>
						</td>
						<td></td>
					</tr>

					<tr>
						<td class="tdLabel" id="boxSpace">Symptoms since <span
							title="Last Menstrual Period "> L.M.P. </span>:
						</td>
						<td class="tdLabel" id="boxSpace"><?php
						if($this->data['PastMedicalRecord']['symptom_lmp']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}
                        				echo $this->Form->radio('symptom_lmp', array('None'=>'None','Yes'=>'Yes'),array('value'=>$getpatient['PastMedicalRecord']['symptom_lmp'],'legend'=>false,'label'=>false));
                        			 ?>
						</td>
						<td></td>
					</tr>
				</table>
			</td>
		</tr>

		<tr id="Sexual_Activity_link">

			<td style="" width="100%" colspan="4">
				<table>
					<tr>
						<td
							style="font-size: 13px; color: #31859c !important; font-weight: bold;">Sexual
							Activity</td>
					</tr>
				</table>
				<table width="100%" border="0" cellspacing="1" cellpadding="0"
					class="tabularForm" id='DrugGroup' class="tdLabel">
					<tr>
						<td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Are you sexually active?'); ?>
						</td>
						<td width="60%" class="tdLabel" id="boxSpace"><?php
						if($this->data['PastMedicalRecord']['sexually_active']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}

                        				echo $this->Form->radio('sexually_active', array('No'=>'No','Yes'=>'Yes'),array('value'=>$getpatient['PastMedicalRecord']['sexually_active'],'legend'=>false,'label'=>false,'class'=>'sexually'));
                        			 ?>
						</td>
						<td><?php if($getpatient['PastMedicalRecord']['with']){
							$displayWith = 'block';
						}else{
									$displayWith = 'none';
								}?>
							<div class="with" style="display:<?php echo $displayWith ?>;">
								<?php echo __('With');?>
								<?php  echo $this->Form->input('with',array('empty'=>__('Please Select'),'options'=>array('Male'=>'Male','Female'=>'Female'),'value'=>$getpatient['PastMedicalRecord']['with'],'style'=>'width:270px','id' => 'with'));?>
							</div>
						</td>
					</tr>


					<tr>
						<td class="tdLabel" id="boxSpace"><?php echo __('Do you use birth control?'); ?>
						</td>
						<td class="tdLabel" id="boxSpace"><?php

						//	echo $this->Form->radio('birth_controll', array('No'=>'No','Yes'=>'Yes','Condoms'=>'Condoms'),array('value'=>$getpatient['PastMedicalRecord']['birth_controll'],'legend'=>false,'label'=>false));
						echo $this->Form->input('birth_controll',array('empty'=>__('Please Select'),'options'=>array('Condom'=>'Condom','IUD'=>'IUD'),'value'=>$getpatient['PastMedicalRecord']['birth_controll'],'style'=>'width:270px','class' => 'birthControll','id'=>'birthControll'));
						?>
						</td>
						<?php $cntrlDate = $this->DateFormat->formatDate2Local($getpatient['PastMedicalRecord']['birth_expiry_date'],Configure::read('date_format'),false);?>
						<td><?php if($getpatient['PastMedicalRecord']['birth_controll'] == 'IUD'){
							$displayCntrl = 'block';
						}else{
									$displayCntrl = 'none';
								}?>
							<div class="controlDate" style="display:<?php echo $displayCntrl ?>;">
								<?php echo __('Expiry Date')?>
								<?php echo $this->Form->input('birth_expiry_date',array('type'=>'text','class'=>'textBoxExpnd','id'=>"birthExpiryDate",'autocomplete'=>'off','label'=>false,'div'=>false,'value'=>$cntrlDate));?>
						
						</td>
						</div>
					</tr>

					<tr>
						<td class="tdLabel" id="boxSpace"><?php echo __('Do you do regular Breast self-exam?'); ?>
						</td>
						<td class="tdLabel" id="boxSpace"><?php
						if($this->data['PastMedicalRecord']['breast_self_exam']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}

                        				echo $this->Form->radio('breast_self_exam', array('No'=>'No','Yes'=>'Yes'),array('value'=>$getpatient['PastMedicalRecord']['breast_self_exam'],'legend'=>false,'label'=>false));
                        			 ?>
						</td>
						<td></td>
					</tr>

					<tr>
						<td class="tdLabel" id="boxSpace"><?php echo __('New Partners? '); ?>
						</td>
						<td class="tdLabel" id="boxSpace"><?php
						if($this->data['PastMedicalRecord']['new_partner']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}

                        				echo $this->Form->radio('new_partner', array('No'=>'No','Yes'=>'Yes'),array('value'=>$getpatient['PastMedicalRecord']['new_partner'],'legend'=>false,'label'=>false));
                        			 ?>
						</td>
						<td></td>
					</tr>

					<tr>
						<td class="tdLabel" id="boxSpace"><?php echo __('Partner Notification '); ?>
						</td>

						<td class="tdLabel" id="boxSpace"><?php 

						if($getpatient['PastMedicalRecord']['partner_notification'] == 1){
								echo $this->Form->checkbox('partner_notification', array('checked' => 'checked'));
							}else{
								echo $this->Form->checkbox('partner_notification');
							}


							//echo $this->Form->checkbox('partner_notification',array('name'=>'1'));?>


						</td>
						<td></td>
					</tr>

					<tr>
						<td class="tdLabel" id="boxSpace"><span
							title="Human Immunodeficiency Virus"> HIV </span> Education
							Given:</td>
						<td class="tdLabel" id="boxSpace"><?php
						if($this->data['PastMedicalRecord']['hiv_education']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}

                        				echo $this->Form->radio('hiv_education', array('No'=>'No','Referred'=>'Referred'),array('value'=>$getpatient['PastMedicalRecord']['hiv_education'],'legend'=>false,'label'=>false));
                        			 ?>
						</td>
						<td></td>
					</tr>


					<tr>
						<td class="tdLabel" id="boxSpace"><span title="Papanicolaou"> PAP
						</span>/<span title="Sexually Transmitted Diseases"> STD </span>
							Education Given:</td>
						<td class="tdLabel" id="boxSpace"><?php
						if($this->data['PastMedicalRecord']['pap_education']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}

                        				echo $this->Form->radio('pap_education', array('No'=>'No','Referred'=>'Referred'),array('value'=>$getpatient['PastMedicalRecord']['pap_education'],'legend'=>false,'label'=>false));
                        			 ?>
						</td>
						<td></td>
					</tr>

					<tr>
						<td class="tdLabel" id="boxSpace"><span title="Gynecology"> GYN </span>
							Referral:</td>
						<td class="tdLabel" id="boxSpace"><?php
						if($this->data['PastMedicalRecord']['gyn_referral']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}

                        				echo $this->Form->radio('gyn_referral', array('No'=>'No','Referred'=>'Referred'),array('value'=>$getpatient['PastMedicalRecord']['gyn_referral'],'legend'=>false,'label'=>false));
                        			 ?>
						</td>
						<td></td>
					</tr>

				</table>
			</td>

		</tr>
		<?php }?>






		<tr>
			<td></td>
			<td align="right"><?php 
		$cancelBtnUrl =  array('controller'=>'Diagnoses','action'=>'initialAssessment',$patient_id,$diagnosis_id,$appointment_id,'?'=>array('expand'=>'History'));?>
				<?php  if($this->params->named['slug']!=true){
					echo $this->Html->link(__('Cancel'),$cancelBtnUrl,array('class'=>'blueBtn','div'=>false));
					echo $this->Form->submit(__('Submit'), array('class'=>'blueBtn','div'=>false,'id'=>'submit_diagno'));
				}
				?>
			</td>
			</td>
		</tr>
	</table>
	<?php echo $this->Form->end();?>


	</table>
</div>
<script>
var sample;
var global_note_id = "<?php echo $global_note_id;?>";	
var diagnosisSelectedArray = new Array();
function addDiagnosisDetails(){
	var selectedPatientId = parent.$('#Patientsid').val();
	
	if(selectedPatientId != ''){
		
		var currEle = diagnosisSelectedArray.pop();
		if((currEle !='') && (currEle !== undefined)){
			parent.openbox(currEle,selectedPatientId,parent.global_note_id);
		}
	}
	
}

function openbox(icd,note_id,linkId) { 
	var sample;
	 
	icd = icd.split("::");
	var patient_id = '<?php echo $patient_id?>';
	if (patient_id == '') {
		alert("Please select patient");
		return false;
	}
	
	$.fancybox({
				'width' : '40%',
				'height' : '80%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'hideOnOverlayClick':false,
				'showCloseButton':false,
				'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "make_diagnosis")); ?>"
						 + '/' + patient_id + '/' + icd , 
				
			}); 

}

function problem(patient_id) {  
	if (patient_id == '') {
		alert("Something went wrong");
		return false;
	} 
	$("#Patientsid").val(patient_id);
	$.fancybox({ 
				'width' : '70%',
				'height' : '120%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe', 
				'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "snowmed")); ?>" + '/' + patient_id,
	});

}

$(document).ready(function(){  	
//	$('#furtherAsses').hide();
	$("#smoking_fre").change(function(){ 
		 $("#smoking_fre_id").val($(this).val());
	});

	$('#no_known_problems').click(function() {
	    if( $(this).is(':checked')) {
	        $(".Past_Medical_History").hide();
	    } else {
	        $(".Past_Medical_History").show();
	    }
	});
	$('#no_surgical').click(function() {
	    if( $(this).is(':checked')) {
	        $(".ProcedureHistory").hide();
	    } else {
	        $(".ProcedureHistory").show();
	    }
	});
	
	$('#is_positive_family').click(function() {
	    if( $(this).is(':checked')) {
	        $("#fmly").hide();
	    } else {
	        $("#fmly").show();
	    }
	});
	
	
	$(document).ajaxStart(function () {
	    $("#temp-busy-indicator1").show();
	});

	$(document).ajaxComplete(function () {
	    $("#temp-busy-indicator1").hide();
	});	
	$( "#accordionCust" ).accordion({
		active : false,
		collapsible: true,
		autoHeight: false,
		clearStyle :true,				
		navigation: true,
		change:function(event,ui){				 
				//BOF template call
			 	var currentEleID = $(ui.newContent).attr("id") ; 	
			 	var replacedID  = "templateArea-"+currentEleID; 	
			  
			 	if(currentEleID=='investigation'){
				 	//redirect to lab request page
				 	//window.location.href = "<?php echo $this->Html->url(array('controller'=>'laboratories','action'=>'lab_order',$patientDetails['Patient']['id'],'?'=>array('return'=>'assessment')));?>";
			 	}	 
			 	if(currentEleID == 'examine' || currentEleID == 'diagnosis' || currentEleID == 'care_plan' || currentEleID== 'complaints' || currentEleID=='lab-reports' || currentEleID=='surgery' || currentEleID=='investigation' || currentEleID=='investigationDashboard' || currentEleID=='ManualLAb'){
					
			 		$("#"+replacedID).html($('#temp-busy-indicator').html());					 		 
				 	if(currentEleID == 'examine'){
				 		$("#templateArea-diagnosis").html('');
						$("#templateArea-lab-reports").html('');
						$("#templateArea-complaints").html('');
						$("#templateArea-surgery").html('');
						$("#templateArea-care_plan").html('');
						$("#templateArea-investigation").html('');
						$("#templateArea-investigationDashboard").html('');
						$("#templateArea-ManualLAb").html('');
					 	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'doctor_templates', "action" => "add",'examine',"admin" => false)); ?>"; 
				 	}else if(currentEleID == 'diagnosis'){
				 		$("#templateArea-examine").html('');
						$("#templateArea-surgery").html('');
						$("#templateArea-care_plan").html(''); 
						$("#templateArea-lab-reports").html('');
						$("#templateArea-complaints").html('');
						$("#templateArea-investigation").html('');
						$("#templateArea-investigationDashboard").html('');
						$("#templateArea-ManualLAb").html('');
				 		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'doctor_templates', "action" => "add",'diagnosis',"admin" => false)); ?>";
					}else if(currentEleID == 'care_plan'){
						$("#templateArea-examine").html('');
						$("#templateArea-diagnosis").html('');
						$("#templateArea-lab-reports").html('');
						$("#templateArea-complaints").html('');
						$("#templateArea-surgery").html('');
						$("#templateArea-investigation").html('');
						$("#templateArea-investigationDashboard").html('');
						$("#templateArea-ManualLAb").html('');
				 		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'doctor_templates', "action" => "add",'care_plan',"admin" => false)); ?>";
					}else if(currentEleID == 'complaints'){
						$("#templateArea-examine").html('');
						$("#templateArea-diagnosis").html('');
						$("#templateArea-lab-reports").html('');	
						$("#templateArea-care_plan").html(''); 
						$("#templateArea-surgery").html('');
						$("#templateArea-investigation").html('');
						$("#templateArea-investigationDashboard").html('');
						$("#templateArea-ManualLAb").html('');
				 		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'doctor_templates', "action" => "add",'complaints',"admin" => false)); ?>";
					}else if(currentEleID == 'lab-reports'){
						$("#templateArea-examine").html('');
						$("#templateArea-diagnosis").html('');
						$("#templateArea-complaints").html(''); 								 
						$("#templateArea-surgery").html('');
						$("#templateArea-care_plan").html('');
						$("#templateArea-investigation").html('');
						$("#templateArea-investigationDashboard").html('');
						$("#templateArea-ManualLAb").html('');
				 		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'doctor_templates', "action" => "add",'lab-reports',"admin" => false)); ?>";
					}else if(currentEleID == 'surgery'){
						$("#templateArea-examine").html('');
						$("#templateArea-diagnosis").html('');
						$("#templateArea-complaints").html(''); 								 
						$("#templateArea-care_plan").html('');
						$("#templateArea-lab-reports").html('');
						$("#templateArea-investigation").html('');
						$("#templateArea-investigationDashboard").html('');
						$("#templateArea-ManualLAb").html('');
				 		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'doctor_templates', "action" => "add",'surgery',"admin" => false)); ?>";
					}else if(currentEleID == 'investigation'){
						
						$("#templateArea-examine").html('');
						$("#templateArea-diagnosis").html('');
						$("#templateArea-complaints").html(''); 								 
						$("#templateArea-care_plan").html('');
						$("#templateArea-lab-reports").html('');
						$("#templateArea-surgery").html('');
				 		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'diagnoses', "action" => "investigation",$patientDetails['Patient']['id'], 'source'=>'fromAssessment','type'=>$patient['Patient']['admission_type']) ,array('escape'=>false)); ?>";
					}else if(currentEleID == 'investigationDashboard'){
						
						$("#templateArea-examine").html('');
						$("#templateArea-diagnosis").html('');
						$("#templateArea-complaints").html(''); 								 
						$("#templateArea-care_plan").html('');
						$("#templateArea-lab-reports").html('');
						$("#templateArea-surgery").html('');
				 		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'diagnoses', "action" => "investigationdashboard",$patientDetails['Patient']['id'],"admin" => false)); ?>";
					}
						 								 
					 		$.ajax({  
					 			  type: "POST",						 		  	  	    		
								  url: ajaxUrl,
								  data: "updateID="+replacedID,
								  context: document.body,								   					  		  
								  success: function(data){	
									 
								   	 	$("#"+replacedID).html(data);								   		
								   	 	$("#"+replacedID).fadeIn();
								  }
								});
					 	}else{					 			
					 		$("#templateArea-assessment").html('');
					 		$("#templateArea-examine").html('');
					 		$("#templateArea-lab-reports").html('');
					 		$("#templateArea-complaints").html('');
						}					 		 		
					 	//EOF template call
				}
										
			});
 

	$(document).on('focus','.drugText', function() {
//	$(".drugText").live("focus",function() {
	
				var currentId=	$(this).attr('id').split("_"); // Important
				var attrId = this.id;
				var counter = $(this).attr("counter");
				if ($(this).val() == "") {
					$("#Pack" + counter).val("");
				}
				$(this)
						.autocomplete(
																															
								"<?php echo $this->Html->url(array("controller" => "Notes", "action" => "pharmacyComplete","PharmacyItem",'name',"drug_id",'MED_STRENGTH','MED_STRENGTH_UOM','MED_ROUTE_ABBR','Status=A',"admin" => false,"plugin"=>false)); ?>",
								{
									
									width : 250,
									selectFirst : true,
									valueSelected:true,
									minLength: 3,
									delay: 1000,
									isOrderSet:true,
									showNoId:true,
									loadId : $(this).attr('id')+','+$(this).attr('id').replace("Text_",'_')+','+$(this).attr('id').replace("drugText_",'dose_type')
									+','+$(this).attr('id').replace("drugText_",'strength')
										+','+$(this).attr('id').replace("drugText_",'route_administration'),
										
									onItemSelect:function(event, ui) {
										//lastSelectedOrderSetItem
										var compositStringArray = lastSelectedOrderSetItem.split("    ");
										if((compositStringArray[1] !== undefined) && (compositStringArray[1] != '')){
											var pharmacyIdArray = compositStringArray[1].split("|");
											//var doseId = attrId.replace("drugText_",'dose_type');
											var routeId = attrId.replace("drugText_",'route_administration');
											var strengthId = attrId.replace("drugText_",'strength');
											$("#drug_"+currentId[1]).val(pharmacyIdArray[0]);
											$("#"+strengthId).val(pharmacyIdArray[2]);
											if($("#"+strengthId).val() == ''){
												$("#"+strengthId).append( new Option(pharmacyIdArray[2],pharmacyIdArray[2]) );
												if(pharmacyIdArray[2]!='')
												$("#"+strengthId).val(pharmacyIdArray[2]);
													else
														$("#"+strengthId).val("Select");
												$.ajax({

													  url: "<?php echo $this->Html->url(array("controller" => 'app', "action" => "saveConfiguration", "admin" => false)); ?>",
													  context: document.body,	
													  beforeSend:function(){
													    // this is where we append a loading image
													    $('#busy-indicator').show('fast');
														}, 	
														type: "POST",  
													  	data:{putArea:pharmacyIdArray[2],searchArea:'strength'},		  
													  	success: function(data){
																$('#busy-indicator').hide('slow');
													  			
													  	}				  			
													});
											}
											$("#"+routeId).val(pharmacyIdArray[3]);
											if($("#"+routeId).val() == ''){
												$("#"+routeId).append( new Option(pharmacyIdArray[3],pharmacyIdArray[3]) );
												if(pharmacyIdArray[3]!='')
												$("#"+routeId).val(pharmacyIdArray[3]);
													else
														$("#"+routeId).val('Select');
												$.ajax({

													  url: "<?php echo $this->Html->url(array("controller" => 'app', "action" => "saveConfiguration1", "admin" => false)); ?>",
													  context: document.body,	
													  beforeSend:function(){
													    // this is where we append a loading image
													    $('#busy-indicator').show('fast');
														}, 	
														type: "POST",  
													  	data:{putArea:pharmacyIdArray[3],searchArea:'route'},		  
													  	success: function(data){
																$('#busy-indicator').hide('slow');
													  			
													  	}				  			
													});
											}
											/*$("#"+doseId).val(pharmacyIdArray[1]);
											if($("#"+doseId).val() == ''){
												$("#"+doseId).append( new Option(pharmacyIdArray[1],pharmacyIdArray[1]) );
												
												if(pharmacyIdArray[1]!='')
													$("#"+doseId).val(pharmacyIdArray[1]);
												else
													$("#"+doseId).val('Select');
									
												$.ajax({

													  url: "<?php echo $this->Html->url(array("controller" => 'app', "action" => "saveConfiguration2", "admin" => false)); ?>",
													  context: document.body,	
													  beforeSend:function(){
													    // this is where we append a loading image
													    $('#busy-indicator').show('fast');
														}, 	
														type: "POST",  
													  	data:{putArea:pharmacyIdArray[1],searchArea:'dose'},		  
													  	success: function(data){
																$('#busy-indicator').hide('slow');
													  			
													  	}				  			
													});
											}*/
											
											
										}
									}
									
								});
				

			});//EOF autocomplete
			$(document).on('focus','.foodText', function() {
		//	$(".foodText").live("focus",function() {
			 
			  		var counter = $(this).attr("counter");
				    $(this).autocomplete("<?php echo $this->Html->url(array("controller" => "diagnoses", "action" => "getfoodtype","admin" => false,"plugin"=>false)); ?>", {
						width: 250,
						 selectFirst: false,
						 extraParams: {drug:$("#drug"+counter).val() },
				  	});	 
				    
					  
			});//EOF autocomplete
			
			$(document).on('focus','.envText', function() {
		//		$(".envText").live("focus",function() {
			 
			  		var counter = $(this).attr("counter");
				    $(this).autocomplete("<?php echo $this->Html->url(array("controller" => "diagnoses", "action" => "getenvtype","admin" => false,"plugin"=>false)); ?>", {
						width: 250,
						 selectFirst: false,
						 extraParams: {drug:$("#drug"+counter).val() },
				  	});	 
				    
					  
			});//EOF autocomplete
			$(document).on('focus','.drugPack', function() {
		//		$(".drugPack").live("focus",function() {
				
			   
			  		var counter = $(this).attr("counter");
				    $(this).autocomplete("<?php echo $this->Html->url(array("controller" => "Pharmacy", "action" => "getPack","PharmacyItem","name", "admin" => false,"plugin"=>false)); ?>", {
						width: 250,
						 selectFirst: false,
						 extraParams: {drug:$("#drug"+counter).val() },
				  	});	 
				    
					  
			});//EOF autocomplete
			$(".drugText").addClass("validate[optional,custom[onlyLetterNumber]]");  
			//jQuery("#diagnosisfrm").validationEngine();
			  
			$('.templateText').click(function(){
			  	    //add current text to diagnosis textarea			  	    	  		  
			  		$('#diagnosis').val($('#diagnosis').val()+"\n"+$(this).text());
			  		$('#diagnosis').focus();
			  		$(this).removeAttr("href");
			  		$(this).css('text-decoration','none');
			  		$(this).attr('class','templateadd');
			  		$(this).unbind('click');
			  	 	return false ;
			});
			  
			  
			//new changes for allergies
				$('#Allergies1').click(function(){
					$('#allergy-table').fadeIn('slow');
				});
				$('#Allergies0').click(function(){
					$('#allergy-table').fadeOut('slow');
				});
				
				$('.past:radio').click(function(){
					 var textName = $(this).attr('id').substr(0,($(this).attr('id').length)-1) ;				 
					 var lowercase = textName.toLowerCase();				 	 
					if($(this).val() =='1'){
						$('#'+lowercase+'_since').fadeIn('slow');
						$('#'+lowercase+'_since').val('Since');
					}else{
						$('#'+lowercase+'_since').fadeOut('slow');
					}
				});
				
				$('.removeSince:input').focus(function(){
					if($(this).val() == 'Since' || $(this).val() == 'Frequency'){
						$(this).val('') ;
					}
				});

			/*	  $("#HxAbnormalPap").click(function(){	
					  alert('jhhhhhhh');
					    $("#showPAP").fadeToggle();
			});*/
					
				$('.personalPAP:radio').click(function(){								
						
						if($(this).val() =='1'){
						$('#showPAP').fadeIn('slow');	
						$('#hxabnormalpap_yes').fadeIn('slow');
						}else{
						$('#showPAP').fadeOut('slow');	
						$('#hxabnormalpap_yes').fadeOut('slow');
						$('#hxabnormalpap_yes').val("");		
						}
					});
			$('.personalMammography:radio').click(function(){		
				if($(this).val() =='1'){
				$('#showMammography').fadeIn('slow');	
				$('#last_mammography_yes').fadeIn('slow');
				
				}else{
				$('#showMammography').fadeOut('slow');	
				$('#last_mammography_yes').fadeOut('slow');		
				$('#last_mammography_yes').val("");	
				}
			});
			$('.personalPPD:radio').click(function(){	
				if($(this).val() =='1'){
				$('#showPPD').fadeIn('slow');	
				$('#last_PPD_yes').fadeIn('slow');
				}else{
				$('#showPPD').fadeOut('slow');	
				$('#last_PPD_yes').fadeOut('slow');
				$('#last_PPD_yes').val("");	
					
				}
			});

			$('.is_pregnent:radio').click(function(){			
				if($(this).val() =='1'){
					$('#showWeeks').fadeIn('slow');	
					$('#is_pregnent_weeks').fadeIn('slow');
				}else{
					$('#showWeeks').fadeOut('slow');	
					$('#is_pregnent_weeks').fadeOut('slow');
					$('#is_pregnent_weeks').val("");	
				}
			});

			$('.military_services:radio').click(function(){		
				if($(this).val() =='1'){		
				$('#showMilitaryServices').fadeIn('slow');	
				$('#militaryservices').fadeIn('slow');
			
				}else{
				$('#showMilitaryServices').fadeOut('slow');	
				$('#militaryservices').fadeOut('slow');	
				$('#militaryservices_yes').val("");
					
				}
			});
			$('.exercise:radio').click(function(){	
			
				if($(this).val() =='1'){					
				$('#showExercise1').fadeIn('slow');	
				$('#showExercise2').fadeIn('slow');	
				$('#showExercise3').fadeIn('slow');
				$('#exercise_type').fadeIn('slow');	
				$('#exercise_frequency').fadeIn('slow');	
				$('#exercise_duration').fadeIn('slow');		
			}else{				
				$('#showExercise1').fadeOut('slow');	
				$('#showExercise2').fadeOut('slow');	
				$('#showExercise3').fadeOut('slow');	
				$('#exercise_type').fadeOut('slow');	
				$('#exercise_frequency').fadeOut('slow');	
				$('#exercise_duration').fadeOut('slow');
				$('#exercise_type').val("");
				$('#exercise_frequency').val("");
				$('#exercise_duration').val("");	
			}
			});
				$('.chemotherapy:radio').click(function(){	
				
				if($(this).val() =='1'){					
				$('.showChemotherapy1Lbl').show();	
				$('.showChemotherapy2Lbl').show();	
				$('.showChemotherapy3Lbl').show();				
				$('#showChemotherapy1').show();	
				$('#showChemotherapy2').show();	
				$('#showChemotherapy3').show();				
				$('#chemotherapy_drug_name').show();	
				$('#first_round_date').show();	
				$('#last_round_date').show();		
			}else{			
				$('.showChemotherapy1Lbl').hide();	
				$('.showChemotherapy2Lbl').hide();	
				$('.showChemotherapy3Lbl').hide();	
				$('#showChemotherapy1').hide();	
				$('#showChemotherapy2').hide();	
				$('#showChemotherapy3').hide();	
				$('#chemotherapy_drug_name').hide();	
				$('#first_round_date').hide();	
				$('#last_round_date').hide();
				$('#chemotherapy_drug_name').val("");
				$('#first_round_date').val("");
				$('#last_round_date').val("");	
			}
			});
			$('.radiation_therapy:radio').click(function(){	
				
				if($(this).val() =='1'){					
				$('.showRadiation1Lbl').show();	
				$('.showRadiation2Lbl').show();	
				$('.showRadiation3Lbl').show();				
				$('#showRadiation1').show();	
				$('#showRadiation2').show();	
				$('#showRadiation3').show();				
				$('#radiation_previous_treatment').show();	
				$('#radiation_start_date').show();	
				$('#radiation_finish_date').show();		
			}else{			
				$('.showRadiation1Lbl').hide();	
				$('.showRadiation2Lbl').hide();	
				$('.showRadiation3Lbl').hide();	
				$('#showRadiation1').hide();	
				$('#showRadiation2').hide();	
				$('#showRadiation3').hide();	
				$('#radiation_previous_treatment').hide();	
				$('#radiation_finish_date').hide();	
				$('#exercise_duration').hide();
				$('#radiation_previous_treatment').val("");
				$('#radiation_start_date').val("");
				$('#radiation_finish_date').val("");	
			}
			});
			
			$('.sexually:radio').click(function(){	
				if($(this).val() =='Yes'){					
				$('.with').fadeIn('slow');	
				
			}else{				
				$('.with').fadeOut('slow');	
				$('#with').val("");
			}
			});
			$('.birthControll').change(function(){
				birthCntrl=$("#birthControll option:selected").text();
				if(birthCntrl == 'IUD'){
					$('.controlDate').fadeIn('slow');
				}else if(birthCntrl == 'Condom'){
					$('.controlDate').fadeOut('slow');
					$('#birthExpiryDate').val("");
				}else{
					$('.controlDate').hide();
					$('#birthExpiryDate').val("");
				}
			 
			});
			
			$('.receive_chemotherapy_concurrentlyCls:radio').click(function(){	
					
			if($(this).val() =='1'){					
				$('.showReceiveChemotherapyLbl').show();	
				$('#receive_chemotherapy_date').show();	
				$('#showReceiveChemotherapy').show();		
				
			}else{			
				$('.showReceiveChemotherapyLbl').hide();	
				$('#showReceiveChemotherapy').hide();
				$('#receive_chemotherapy_date').hide();	
				$('#receive_chemotherapy_date').val("");	
				}
			});
			//smoking_info
				$('.personal:radio').click(function(){		

					 textName = $(this).attr('id') ;
					 if(textName.indexOf(0) > 0 || textName.indexOf(1) > 0){
					 	var textName = $(this).attr('id').substr(0,($(this).attr('id').length)-1) ;			 
					 } 						
					 var lowercase = textName.toLowerCase(); 
					if($(this).val() =='1'){
						
						$('#'+lowercase+'_desc').fadeIn('slow');	
						$('#'+lowercase+'_desc').val('Since');			 
						$('#'+lowercase+'_fre').fadeIn('slow');	
						$('#'+lowercase+'_info').fadeIn('slow');
						$('#'+lowercase+'_fill').fadeIn('slow');	
						$('#'+lowercase+'_smoke_fill').fadeIn('slow');
						$('#'+lowercase+'_alco_info').fadeIn('slow');
						//$('#'+lowercase+'_fre').val('Frequency');
						$('#'+lowercase+'_fre option').each(function(key,val) {  
							if ( key == 4 ) {
					            $(this).attr('disabled', true) ;   
					        }else{  
					            $(this).attr('disabled', false) ;
					        }   
				    	});
						$('#'+lowercase+'_fre0_id0').fadeIn('slow');
						$('#'+lowercase+'_fre1_id1').fadeIn('slow');
						$('#'+lowercase+'_another').fadeIn('slow');
						$('#substance').fadeIn('slow');
						
					}else{
						$('#'+lowercase+'_desc').fadeOut('slow');
						$('#'+lowercase+'_info').fadeOut('slow');
						$('#'+lowercase+'_fill').fadeOut('slow');
						$('#'+lowercase+'_fre').fadeOut('slow');
						$('#'+lowercase+'_smoke_fill').fadeOut('slow');
						$('#'+lowercase+'_alco_info').fadeOut('slow');
						$('#'+lowercase+'_fre_id').fadeOut('slow');
						$('#'+lowercase+'_fre option').each(function(key,val) { 
					        if ( key != 4 ) {
					            $(this).attr('disabled', true) ;   
					        }
					    });
						$('#'+lowercase+'_fre0_id0').fadeOut('slow');
						$('#'+lowercase+'_fre1_id1').fadeOut('slow');
						$('#'+lowercase+'_another').fadeOut('slow');
						$('#'+lowercase+'_another').val('');
						$('#'+lowercase+'_fre').val('');
						$('#substance').fadeOut('slow');
						
					}
				});
				$('.personal1:radio').click(function(){
					 var textName = $(this).attr('id').substr(0,($(this).attr('id').length)-1) ;				 
					 var lowercase = textName.toLowerCase();
					//alert($(this).val());
					if($(this).val() =='1'){
						var currentId='Smoking1';
					 
						inlineMsg(currentId,'Tobbaco use cessation counseling to be done..');
						$('#'+lowercase+'_desc').fadeIn('slow');	
						$('#'+lowercase+'_desc').val('Since');			 
						$('#'+lowercase+'_fre').fadeIn('slow');	
						$('#'+lowercase+'_info').fadeIn('slow');
						$('#'+lowercase+'_fill').fadeIn('slow');	
						$('#'+lowercase+'_smoke_fill').fadeIn('slow');
						$('#'+lowercase+'_alco_info').fadeIn('slow');
						//$('#'+lowercase+'_fre').val('Frequency');
						$('#'+lowercase+'_fre option').each(function(key,val) {
							if ( key == 4 ) {
					            $(this).attr('disabled', true) ;   
					        }else{  
					            $(this).attr('disabled', false) ;
					        }    
					    });
					    
					}else{
						$('#'+lowercase+'_desc').fadeOut('slow');
						$('#'+lowercase+'_desc').fadeOut('slow');
						$('#'+lowercase+'_info').fadeOut('slow');
						$('#'+lowercase+'_fill').fadeOut('slow');
						$('#'+lowercase+'_fre').fadeIn('slow');
						
						$('#'+lowercase+'_fre option').each(function(key,val) { 
					        if ( key != 4 ) {
					            $(this).attr('disabled', true) ;   
					        }else{
					        	$(this).attr('disabled', false) ;   
					        }
					        
					    });
					    
						$('#'+lowercase+'_smoke_fill').fadeOut('slow');
						$('#'+lowercase+'_alco_info').fadeOut('slow');
						$('#'+lowercase+'_fre_id').fadeOut('slow');
					}
				});
				//EOF new changes for allergies
				//BOF timer
				$(document).on('change','.frequency', function() {
				//	$(".frequency").live("change",function() {
				
					id 	= $(this).attr('id');
					 
					currentCount 	= id.split("_");
					currentFrequency= $(this).val();
					$('#first_'+currentCount[2]).val('');
					$('#second_'+currentCount[2]).val('');
					$('#third_'+currentCount[2]).val('');
					$('#forth_'+currentCount[2]).val('');
					 
					//set timer
       				switch(currentFrequency){       					
       					case "BD":     	
       						$('#first_'+currentCount[2]).removeAttr('disabled');
       						$('#second_'+currentCount[2]).removeAttr('disabled');
       						$('#third_'+currentCount[2]).attr('disabled','disabled');       					 
       						$('#forth_'+currentCount[2]).attr('disabled','disabled');
       						break;
       					case "TDS":
       						$('#first_'+currentCount[2]).removeAttr('disabled');
       						$('#second_'+currentCount[2]).removeAttr('disabled');
       						$('#third_'+currentCount[2]).removeAttr('disabled');       						  						
       						$('#forth_'+currentCount[2]).attr('disabled','disabled');
       						break;
       					case "QID":
       						$('#first_'+currentCount[2]).removeAttr('disabled');
       						$('#second_'+currentCount[2]).removeAttr('disabled');
       						$('#third_'+currentCount[2]).removeAttr('disabled');
       						$('#forth_'+currentCount[2]).removeAttr('disabled');       						
       						break;
       					case "OD":
       					case "HS":
       						$('#first_'+currentCount[2]).removeAttr('disabled');       					  						
       						$('#second_'+currentCount[2]).attr('disabled','disabled');
       						$('#third_'+currentCount[2]).attr('disabled','disabled');
       						$('#forth_'+currentCount[2]).attr('disabled','disabled');
           					break;
           				case "Once fort nightly":
       						$('#first_'+currentCount[2]).removeAttr('disabled');       					  						
       						$('#second_'+currentCount[2]).attr('disabled','disabled');
       						$('#third_'+currentCount[2]).attr('disabled','disabled');
       						$('#forth_'+currentCount[2]).attr('disabled','disabled');
           					break;
           				case "Twice a week":
       						$('#first_'+currentCount[2]).removeAttr('disabled');       					  						
       						$('#second_'+currentCount[2]).attr('disabled','disabled');
       						$('#third_'+currentCount[2]).attr('disabled','disabled');
       						$('#forth_'+currentCount[2]).attr('disabled','disabled');
           					break;
           				case "Once a week":
       						$('#first_'+currentCount[2]).removeAttr('disabled');       					  						
       						$('#second_'+currentCount[2]).attr('disabled','disabled');
       						$('#third_'+currentCount[2]).attr('disabled','disabled');
       						$('#forth_'+currentCount[2]).attr('disabled','disabled');
           					break;
           				case "Once a month":
       						$('#first_'+currentCount[2]).removeAttr('disabled');       					  						
       						$('#second_'+currentCount[2]).attr('disabled','disabled');
       						$('#third_'+currentCount[2]).attr('disabled','disabled');
       						$('#forth_'+currentCount[2]).attr('disabled','disabled');
           					break;  
           				case "A/D":
       						$('#first_'+currentCount[2]).removeAttr('disabled');       					  						
       						$('#second_'+currentCount[2]).attr('disabled','disabled');
       						$('#third_'+currentCount[2]).attr('disabled','disabled');
       						$('#forth_'+currentCount[2]).attr('disabled','disabled');
           					break;      					
       				}
					
				});	
				$(document).on('change','.first', function() {
			//		$(".first").live("change",function() {
					currentValue 	= Number($(this).val()) ;
					id 			 	= $(this).attr('id');
					currentCount 	= id.split("_");
					currentFrequency= $('#tabs_frequency_'+currentCount[1]).val();
					hourDiff		= 0 ;					 
					//set timer
       				switch(currentFrequency){       					
       					case "BD":
       						hourDiff = 12 ;
       						break;
       					case "TDS":
       						hourDiff = 6 ;
       						break;
       					case "QID":
       						hourDiff = 4 ;
       						break;       					
       				}			
					
					switch(hourDiff){
						case 12:						 
							$('#second_'+currentCount[1]).val(currentValue+12);
							break;
						case 6:						 
							$('#second_'+currentCount[1]).val(currentValue+6);
							$('#third_'+currentCount[1]).val(currentValue+12);
							break;
						case 4: 
							$('#second_'+currentCount[1]).val(currentValue+4);
							$('#third_'+currentCount[1]).val(currentValue+8);
							$('#forth_'+currentCount[1]).val(currentValue+12);
							break;
						}
				});

				$('#submit_diagno,#id2')
				.click(
						function() { 
							//var validateDiagnosisNotes = jQuery("#diagnosisfrm").validationEngine('validate');
							//if (validateDiagnosisNotes) {$(this).css('display', 'none');}
						});
				//EOF timer  
		});
   	//script to include datepicker
			$(function() {
				$("#next_visit").datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				yearRange: '1950',
				minDate: new Date(),
				dateFormat:'<?php echo $this->General->GeneralDate();?>',		
				onSelect: function ()
			    {			        // The "this" keyword refers to the input (in this case: #someinput)
			        this.focus();
			    }	
			});

			
			
			$('.icd_eraser').click(function(){
			//	alert($(this).attr('id'));
			});
			
			$("#eraser").click(function(){
				 
				$('#icdSlc').html('');
				$('#icd_ids').val('');
				$("#eraser").hide();
			}); 
			
			$("#eraser").hide();
			 
			


			    //add1 n remove1 drud inputs
			 var counter_nw = <?php echo $count_nw?>
			
		    $("#addButton_nw").click(function () {			 
				
				$("#diagnosisfrm").validationEngine('detach'); 
				var newCostDiv_nw = $(document.createElement('tr'))
				     .attr("id", 'DrugGroup_nw' + counter_nw);
				  
				//var route_option = '<select id="mode'+counter1+'" style="width:80px" class="" name="mode[]"><option value="">Select</option><option value="IV">IV</option><option value="IM">IM</option><option value="S/C">S/C</option><option value="P.O">P.O</option><option value="P.R">P.R</option><option value="P/V">P/V</option><option value="R.T">R.T</option><option value="LA">LA</option></select>';
				//var fre_option = '<select id="tabs_frequency_'+counter+'"  class="frequency" name="tabs_frequency[]"><option value="">Select</option><option value="SOS">SOS</option><option value="OD">OD</option><option value="BD">BD</option><option value="TDS">TDS</option><option value="QID">QID</option><option value="HS">HS</option><option value="Twice a week">Twice a week</option><option value="Once a week">Once a week</option><option value="Once fort nightly">Once fort nightly</option><option value="Once a month">Once a month</option><option value="A/D">A/D</option></select>';
				var counts = '<td width="10%" height="20px" align="left" valign="top">'+counter_nw +'</td>';
				var date_birth = '<td width="20%" height="20px" align="left" valign="top"  class="tddate"><input type="text" value="" id="date_birth'+counter_nw+'" class="" style=>"width:120px" name="pregnancy[date_birth][]"></td>';
				var weight = '<td width="10%" height="20px" align="left" valign="top"><input type="text" value="" id="weight'+counter_nw+'" class="validate[optional,custom[onlyNumber]]" style=>"width:70px" name="pregnancy[weight][]"></td>';
				var baby_gender = '<select style="width:148px;" id="baby_gender'+counter_nw+'" class="" name="pregnancy[baby_gender][]"><option value="">Please Select</option><option value="M">Male</option><option value="F">Female</option></select>';
				var week_pregnant = '<td width="10%" height="20px" align="left" valign="top"><input type="text" value="" id="week_pregnant'+counter_nw+'" class="validate[optional,custom[onlyNumber]]" style=>"width:70px" name="pregnancy[week_pregnant][]"></td>';
				var type_delivery = '<select style="width:148px;" id="type_delivery'+counter_nw+'" class="" name="pregnancy[type_delivery][]"><option value="">Please Select</option><option value="Episiotomy">Vaginal Delivery-Episiotomy</option><option value="Induced_labor">Vaginal Delivery-Induced labor</option><option value="Forceps_delivery">Vaginal Delivery-Forceps delivery</option><option value="Vacuum_extraction">Vaginal Delivery-Vacuum extraction</option><option value="Cesarean">Cesarean section</option></select>';
				var complication = '<td width="10%" height="20px" align="left" valign="top"><input type="text" value="" id="complication'+counter_nw+'" class="" style=>"width:100px" name="pregnancy[complication][]"></td>';
				'</tr></table></td>';
				var add = parseInt(counter_nw,10)+1 ;
				var newHTml_nw = '<td> '+ add  +'</td><td class="tddate"><input  type="text" style="width:130px" class="date_birth" name="pregnancy[date_birth][]" value="" id="date_birth' + counter_nw + '"  counter_nw='+counter_nw+', readonly =readonly autocomplete="off"></td><td><input  type="text" style="width:146px" class="validate[optional,custom[onlyNumber]]" name="pregnancy[weight][]" id="weight' + counter_nw + '"  autocomplete="off" counter_nw='+counter_nw+'></td><td>'+baby_gender+'</td><td><input  type="text" style="width:146px" class="validate[optional,custom[onlyNumber]]" name="pregnancy[week_pregnant][]" id="week_pregnant' + counter_nw + '" autocomplete="off" counter_nw='+counter_nw+' maxlength="2"></td><td>'+type_delivery+'</td><td><input  type="text" style="width:145px" class="" name="pregnancy[complication][]" id="complication' + counter_nw + '" autocomplete="off" counter_nw='+counter_nw+'></td><td width="20"><span class="DrugGroup_nw" id=pregnancy'+ counter_nw +'><?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete'));?></td>';
				
				newCostDiv_nw.append(newHTml_nw);		 
				newCostDiv_nw.appendTo("#DrugGroup_nw");		
				$("#diagnosisfrm").validationEngine('attach'); 			 			 
				counter_nw++;
				if(counter_nw > 0) $('#removeButton_nw').show('slow');
				 $(".date_birth")
				   	.datepicker({
							showOn : "button",
							buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
							buttonImageOnly : true,
							changeMonth : true,
							changeYear : true,
							yearRange: '-100:' + new Date().getFullYear(),
							maxDate : new Date(),
							dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
							onSelect : function() {
								$(this).focus();
												}
											});
		     });
		 
		     $("#removeButton_nw").click(function () {
							 
					counter_nw--;			 
			 
			        $("#DrugGroup_nw" + counter_nw).remove();
			 		if(counter_nw == 0) $('#removeButton_nw').hide('slow');
			  });
		     $(document).on('click','.DrugGroup_nw', function() {
		 //   	 $(".DrugGroup_nw").live("click",function() {
		     
		         if(confirm("Do you really want to delete this record?")){
		         var pregTrId = $(this).attr('id').replace("pregnancy","DrugGroup_nw");
		     	 $('#' + pregTrId).remove();
		     		counter_nw--;			 
		     	 if(counter_nw == 0) $('#removeButton_nw').hide('slow');
		         }else{
		             return false;
		         }
		       
		         });
			  //EOF add1 n remove1 drug inputs


			  
			 // Add more for past medical record
			 
			 var counter_history = <?php echo $count_history?>;
		 	$("#addButton_history").click(function () {		 				 
				//$("#diagnosisfrm").validationEngine('detach'); 
				var newCostDiv_history = $(document.createElement('tr'))
				     .attr("id", 'DrugGroup_history' + counter_history);
				
				var illness = '<td  height="20px" align="left" valign="top"><a href="javascript:icdwin1(\'illness'+counter_history+'\')"><input type="text" value="" id="illness'+counter_history+'" class="validate[required,custom[name],custom[onlyLetter]] textBoxExpnd " style=>"width:70px" name="PastMedicalHistory[illness][]"></a></td>';
				var status = '<select style="" id="status'+counter_history+'" class="textBoxExpnd" name="PastMedicalHistory[status][]"><option value="">Please Select</option><option value="Chronic">Chronic</option><option value="Existing">Existing</option><option value="New_on_set">New OnSet</option><option value="Recovered">Recovered</option><option value="Acute">Acute</option><option value="Inactive">Inactive</option></select>';
				var duration = '<td  height="20px" align="left" valign="top"><input type="text" value="" id="duration'+counter_history+'" class="validate[optional,custom[onlyNumber]]" style=>"width:70px" name="PastMedicalHistory[duration][]" ></td>';
				var comment = '<td  height="20px" align="left" valign="top"><input type="text" value="" id="comment'+counter_history+'" class="textBoxExpnd" style=>"width:120px" name="PastMedicalHistory[comment][]"></td>';
				'</tr></table></td>';
				
				var newHTml_history = '<td style=""><input class="textBoxExpnd problemAutocomplete validate[required,custom[mandatory-enter]]" type="text" value="" name="PastMedicalHistory[illness][]" id="illness' + counter_history + '" autocomplete="off" counter_history='+counter_history+'></td><td>'+status+'</td><td><input  type="text"  value="" name="PastMedicalHistory[duration][]" class="validate[optional,custom[onlyNumber]] textBoxExpnd" id="duration' + counter_history + '"  autocomplete="off" counter_history='+counter_history+' maxlength="4"></td><td><input  type="text"  value="" name="PastMedicalHistory[month][]" class="validate[optional,custom[onlyNumber]] textBoxExpnd" id="month' + counter_history + '"  autocomplete="off" counter_history='+counter_history+' maxlength="4"></td><td><input  type="text"  value="" name="PastMedicalHistory[week][]" class="validate[optional,custom[onlyNumber]] textBoxExpnd" id="week' + counter_history + '"  autocomplete="off" counter_history='+counter_history+' maxlength="4"></td><td><input  type="text"  value="" name="PastMedicalHistory[recoverd_date][]" readonly="readonly" class="recoverd_date textBoxExpnd" id="recoverd_date' + counter_history + '"  autocomplete="off" counter_history='+counter_history+'></td><td><input  type="text"  value="" name="PastMedicalHistory[comment][]" id="comment' + counter_history + '"  class="textBoxExpnd" autocomplete="off" counter_history='+counter_history+'></td><td width="20"><span class="DrugGroup_history" id=pMH'+counter_history+'><?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete','style'=>'margin:0 0 0 17px;'));?></td>';
				
				newCostDiv_history.append(newHTml_history);		 
				newCostDiv_history.appendTo("#DrugGroup_history");		
				$("#diagnosisfrm").validationEngine('attach'); 			 			 
				counter_history++;
				if(counter_history > 0) $('#removeButton_history').show('slow');
				 $(".recoverd_date").datepicker({
						showOn : "button",
						buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
						buttonImageOnly : true,
						changeMonth : true,
						changeYear : true,
						yearRange: '-100:' + new Date().getFullYear(),
						maxDate : new Date(),
						dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
						onSelect : function() {
							$(this).focus();
											}
										});
				   
		     });
		 
		     $("#removeButton_history").click(function () {
							 
					counter_history--;			 
			 
			        $("#DrugGroup_history" + counter_history).remove();
			 		if(counter_history == 0) $('#removeButton_history').hide('slow');
			  });
			 
			 //EOF  Add more for past medical record
			  
			      //add1 n remove1 procedure history
			 counter_procedure = <?php echo $count_procedure ?>
		 
		    $("#addButton_procedure").click(function () {		 				 
				
				//$("#diagnosisfrm").validationEngine('detach'); 
				var newCostDiv_procedure = $(document.createElement('tr'))
				     .attr("id", 'DrugGroup_procedure' + counter_procedure);
				  
				 	var age_unit = '<select style="width:auto;" id="age_unit'+counter_procedure+'" class="" name="ProcedureHistory[age_unit][]"><option value="">Please Select</option><option value="Days">Days</option><option value="Months">Months</option><option value="Years">Years</option></select>';
				 
				 	
				 	var newHTml_procedure = ' <td style="" width="17%">  <input id="patient_id_' + counter_procedure + '" type="hidden" counter_procedure=' + counter_procedure + ' name="ProcedureHistory[patient_id][]">  <input  type="text" style="width:244px" value="" name="ProcedureHistory[procedure_name][]" id="procedureDisplay_' + counter_procedure + '" class="procedure validate[required,custom[mandatory-enter]]" autocomplete="off" counter_procedure='+counter_procedure+'><input id="procedure_' + counter_procedure + '" type="hidden" counter_procedure=' + counter_procedure + ' name="ProcedureHistory[procedure][]"></td><td width="17%"><input  type="text" style="width:244px" value="" name="ProcedureHistory[provider_name][]" id="providerDisplay_' + counter_procedure + '" class="providercls" autocomplete="off" counter_procedure='+counter_procedure+'><input  type="hidden" style="width:244px" value="" name="ProcedureHistory[provider][]" id="provider_' + counter_procedure + '" autocomplete="off" counter_procedure='+counter_procedure+'></td><td style=" padding: 0 0 0 60px; width: 12%;" ><input  type="text" style="" value="" name="ProcedureHistory[age_value][]" class="validate[optional,custom[onlyNumber]] textBoxExpnd" id="age_value' + counter_procedure + '" autocomplete="off" counter_procedure='+counter_procedure+'></td><td>'+age_unit+'</td><td width="17%" style=""><input  type="text" readonly="readonly" class="procedure_date textBoxExpnd" name="ProcedureHistory[procedure_date][]" value="" autocomplete="off" id="procedure_date' + counter_procedure + '"  counter_procedure='+counter_procedure+'></td><td width="17%"><input  type="text" style="width:90%" value="" name="ProcedureHistory[comment][]" id="comment' + counter_procedure + '" autocomplete="off" counter_procedure='+counter_procedure+'></td><td width="4%" ><span class="DrugGroup_procedure" id=surgery'+counter_procedure+'><?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete'));?></td>';
				
				newCostDiv_procedure.append(newHTml_procedure);		 
				newCostDiv_procedure.appendTo("#DrugGroup_procedure");		
				$("#diagnosisfrm").validationEngine('attach'); 			 			 
				counter_procedure++;
				if(counter_procedure > 0) $('#removeButton_procedure').show('slow');
				 $(".procedure_date").datepicker({
						showOn : "button",
						buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
						buttonImageOnly : true,
						changeMonth : true,
						changeYear : true,
						yearRange: '-100:' + new Date().getFullYear(),
						maxDate : new Date(),
						dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
						onSelect : function() {
							$(this).focus();
											}
										});
		     });
		 
		     $("#removeButton_procedure").click(function () {
							 
					counter_procedure--;			 
			 
			        $("#DrugGroup_procedure" + counter_procedure).remove();
			 		if(counter_procedure == 0) $('#removeButton_procedure').hide('slow');
			  });
		     $(document).on('click','.DrugGroup_history', function() {
		    //	 $(".DrugGroup_history").live("click",function() {
		    
		    	  if(confirm("Do you really want to delete this record?")){
		        var trId = $(this).attr('id').replace("pMH","DrugGroup_history");
		    	 $('#' + trId).remove();
		    	 counter_history--;			 
		    	 if(counter_history == 0) $('#removeButton_history').hide('slow');
		    	  }else{
			    	 
					return false;
		        	  }
		        });
		     $(document).on('click','.DrugGroup_procedure', function() {
		     	if(confirm("Do you really want to delete this record?")){
		         	var surgTrId = $(this).attr('id').replace("surgery","DrugGroup_procedure");
		         	var delIDName = $(this).attr('id').replace("surgery","id_");
		         	var delIDVal=$('#'+delIDName).val();
		         	counter_procedure--;
		 			$('#' + surgTrId).remove();
		      		if(counter_procedure == 0) $('#removeButton_procedure').hide('slow');
		      		
		      		/* Delete Record Past Surgical History Aditya Vijay...*/
			      		if(delIDVal!==undefined && delIDVal!=''){
			      			var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "diagnoses", "action" => "deletePSH","admin" => false)); ?>";
		  
				           	$.ajax({
				            	type: 'POST',
				            	url: ajaxUrl+"/"+delIDVal,
				            	dataType: 'html',
				            	success: function(data){
				            		alert(data);
				            	},
								error: function(message){}
							});
			      		}
					/* EOD*/
		        }else{
		              return false;
		          }
		        
		     });
			  //EOF add1 n remove1 procedure history
			  
			  
			  
			   $(".date_birth")
			   	.datepicker({
						showOn : "button",
						buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
						buttonImageOnly : true,
						changeMonth : true,
						changeYear : true,
						yearRange: '-100:' + new Date().getFullYear(),
						maxDate : new Date(),
						dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
						onSelect : function() {
							$(this).focus();
											}
										});


				 
			   $("#positiveTb")
			   	.datepicker({ 
						showOn : "button",
						buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
						buttonImageOnly : true,
						changeMonth : true,
						changeYear : true,
						yearRange: '-100:' + new Date().getFullYear(),
						maxDate : new Date(),
						dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
						onSelect : function() {
							$(this).focus();
											}
										});

										$("#birthExpiryDate")
									   	.datepicker({
												showOn : "button",
												buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
												buttonImageOnly : true,
												changeMonth : true,
												changeYear : true,
												yearRange: '-100:' + new Date().getFullYear(),
												//maxDate : new Date(),
												dateFormat:'<?php echo $this->General->GeneralDate();?>',
												onSelect : function() {
													$(this).focus();
																	}
																});
			  
		     

			   $(".recoverd_date").datepicker({
					showOn : "button",
					buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
					buttonImageOnly : true,
					changeMonth : true,
					changeYear : true,
					yearRange: '-100:' + new Date().getFullYear(),
					maxDate : new Date(),
					dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
					onSelect : function() {
						$(this).focus();
										}
									
			   });


			 $(".procedure_date").datepicker({
						showOn : "button",
						buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
						buttonImageOnly : true,
						changeMonth : true,
						changeYear : true,
						yearRange: '-100:' + new Date().getFullYear(),
						maxDate : new Date(),
						dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
						onSelect : function() {
							$(this).focus();
											}
										});
				
			});
			 
			function remove_icd(val,id){
				//alert(val);alert(id);	 
				 var ids= $('#icd_ids').val(); 
				 var tt = ids.replace(val+'|',''); 
				 $('#icd_ids').val(tt); 
				 $("#icd_"+val).remove();
				 
 			}
			
			//script to include datepicker
			$(function() {
				$( "#register_on" ).datepicker({
					showOn: "button",
					buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
					buttonImageOnly: true,
					changeMonth: true,
					changeYear: true,
					yearRange: '1950',			 
					minDate:new Date(<?php echo $this->General->minDate($patient['Patient']['form_received_on']) ?>),
					dateFormat:'<?php echo $this->General->GeneralDate("HH:II");?>'
				});
				
				$("#lmp")
				.datepicker(
						{
							showOn : "button",
							buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
							buttonImageOnly : true,
							changeMonth : true,
							changeYear : true,
							yearRange: '-100:' + new Date().getFullYear(),
							maxDate : new Date(),
							dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
							onSelect : function() {
								$(this).focus();
								//foramtEnddate(); //is not defined hence commented
							}

						});

				$("#capture_date")
				.datepicker(
						{
							showOn : "button",
							buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
							buttonImageOnly : true,
							changeMonth : true,
							changeYear : true,
							yearRange: '-100:' + new Date().getFullYear(),
							maxDate : new Date(),
							dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
							onSelect : function() {
								$(this).focus();
								//foramtEnddate(); //is not defined hence commented
							}

						});
				
				
				$( "#dob" ).datepicker({
					showOn: "button",
					buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
					buttonImageOnly: true,
					changeMonth: true,
					changeYear: true,
					yearRange: '1950',			 
					minDate:new Date(<?php echo $this->General->minDate($patient['Patient']['form_received_on']) ?>),
					dateFormat:'<?php echo $this->General->GeneralDate("HH:II");?>'
				});
				
				$( "#consultant_on" ).datepicker({
					showOn: "button",
					buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
					buttonImageOnly: true,
					changeMonth: true,
					changeYear: true,
					yearRange: '1950',			 
					minDate:new Date(<?php echo $this->General->minDate($patient['Patient']['form_received_on']) ?>),
					dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>'
				});
			});	

			function diagnosisMsg(){
				alert("You have not fill anything!");
				return false;				
			}
	
			
//added by pankaj
			$( "#startdate" ).datepicker({
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
			//window.location.href = '<?php echo $this->Html->url('/hospital_acquire_infections/index/'); ?>'+patientid+'/'+dateval;
           // $("#intrinsic_date").action = "<?php echo $this->Html->url('/hospital_acquire_infections/index'); ?>"
			//alert($( "#intrinsic_date" ).val());
		}
	});
	$( "#onsets_date" ).datepicker({
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
			//window.location.href = '<?php echo $this->Html->url('/hospital_acquire_infections/index/'); ?>'+patientid+'/'+dateval;
           // $("#intrinsic_date").action = "<?php echo $this->Html->url('/hospital_acquire_infections/index'); ?>"
			//alert($( "#intrinsic_date" ).val());
		}
	});


	$( "#startdatefood" ).datepicker({
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
			//window.location.href = '<?php echo $this->Html->url('/hospital_acquire_infections/index/'); ?>'+patientid+'/'+dateval;
           // $("#intrinsic_date").action = "<?php echo $this->Html->url('/hospital_acquire_infections/index'); ?>"
			//alert($( "#intrinsic_date" ).val());
		}
	});
	$( "#onsets_date_food" ).datepicker({
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
			//window.location.href = '<?php echo $this->Html->url('/hospital_acquire_infections/index/'); ?>'+patientid+'/'+dateval;
           // $("#intrinsic_date").action = "<?php echo $this->Html->url('/hospital_acquire_infections/index'); ?>"
			//alert($( "#intrinsic_date" ).val());
		}
	});

	$( "#startdateenv" ).datepicker({
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
			//window.location.href = '<?php echo $this->Html->url('/hospital_acquire_infections/index/'); ?>'+patientid+'/'+dateval;
           // $("#intrinsic_date").action = "<?php echo $this->Html->url('/hospital_acquire_infections/index'); ?>"
			//alert($( "#intrinsic_date" ).val());
		}
	});
	$( "#onsets_date_env" ).datepicker({
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
			//window.location.href = '<?php echo $this->Html->url('/hospital_acquire_infections/index/'); ?>'+patientid+'/'+dateval;
           // $("#intrinsic_date").action = "<?php echo $this->Html->url('/hospital_acquire_infections/index'); ?>"
			//alert($( "#intrinsic_date" ).val());
		}
	});
	 $(document).on('click','.effective_date', function() {
	//	 $(".effective_date").live("click",function() {
			
		$(this).datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		changeTime:true,
		showTime: true,  		
		yearRange: '1950',			 
		dateFormat:'<?php echo $this->General->GeneralDate();?>'
	})
	});
/*
	//jQuery("#drugallergyfrm").validationEngine();

	
         //validation by vikas
         
  <!--// function save_allergy1("env"){
  // var error = "";
  
    //if (env.DrugAllergy.fromenv.length == 0) {
       
       // error = "The required field has not been filled in.\n"
   // } else {
      //  fld.style.background = 'White';
  // }
    //return error;   
//} 
	/*  function validateForm("env")
	  {
	  var x=document.forms["diagnosisfrm"]["DrugAllergy.fromenv"].value;
	  if (x==null || x=="")
	    {
	    alert("First name must be filled out");
	    return false;
	    }
	  }*/
	
	function save_allergy(allergytype){
		//code added by vikas
			//validation on allergy
		  var alrgyenv = $('#envval').val();
		  var alrgyfood = $('#foodval').val();
		  var alrgydrug = $('#drugval').val();
		  
		  if (allergytype =='env' && alrgyenv== "")
		    {
		    alert("Please enter Environment type");
		    return false;
		    }
		  
		
			
		  if (allergytype=='food' && alrgyfood== "")
		    {
		    alert("Please enter food type");
		    return false;
		    }
		  
		  
			
		  if (allergytype=='drug' && alrgydrug== "")
		    {
		    alert("Please enter drug type");
		    
		    }
		  
		//validation on startdate
		  var drugdate = $('#startdate').val();
		  var envdate = $('#startdateenv').val();
		  var fooddate = $('#startdatefood').val();
		 
		  if (allergytype=='drug' && drugdate == "")
		    {
		    alert("Please enter Start Date");
		    
		    return false;
		    }
		  
		  if (allergytype =='env' && envdate == "")
		    {
		    alert("Please enter Start Date");
		    return false;
		    }
		  
		
			
		  if (allergytype=='food' && fooddate== "")
		    {
		    alert("Please enter Start Date");
		    return false;
		    }
		  
		  
		  //validation on checkbox
		/*var activedrug = $('#active').val();
		  
		 if(allergytype=='drug' && activedrug.checked == false)
		 {
				 alert('Please Check the active');
				
			 return false;
			 
			  }*/

			  /* if(document.getElementById('active').checked == false)
					 { 
						 alert('Please Check the active');
					 return false;
					 
					 	if(document.getElementById('active1').checked == false)
				 			{ 
					 			alert('Please Check the active');
								 return false;
				 
						 if(document.getElementById('active2').checked == false)
							 {
								 alert('Please Check the active');
								 return false;
			 				 }
				 		 }
					  }*/
			  
		  
		 
		
		/*	 var check   = 0;
		  if(diagnosisfrm.Active.checked== false)
		 {
			//  alert('Check the active');
		 return false;
		  }*/
		 // var alrgyfood = $('#active1').val();
		  
		  if(allergytype=='drug' && document.getElementById('active').checked == false)
			{ alert
			('Please Check the active');
						 return false;
				 				 }
		  
	if(allergytype=='food' && document.getElementById('active1').checked == false)
		{ alert
		('Please Check the active');
					 return false;
			 				 }
	if(allergytype=='env' && document.getElementById('active2').checked == false)
	{ alert
	('Please Check the active');
				 return false;
		 				 }
	
		  
	//	 if ( ( form.active[0].checked == false )  ) 
						//{
						//alert ( "Please choose your Gender: Male or Female" ); 
						//return false;
					//	}
		 
			
		
		
		 //validation code end here added by vikas
		  
		  
		 

	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "diagnoses", "action" => "save_allergy",$patientDetails['Patient']['id'],"admin" => false)); ?>";
	   var formData = $('#diagnosisfrm').serialize();
      patientid="<?php echo $patientDetails['Patient']['id']?>";
	  
           $.ajax({
            type: 'POST',
            url: ajaxUrl+"/"+allergytype,
            data: formData,
            dataType: 'html',
            success: function(data){
            	//alert(data);
            	 window.location.href = '<?php echo $this->Html->url('/diagnoses/add/'); ?>'+patientid; 
            },
			error: function(message){
               // alert(message);
            }        });
      
      return false;
	}

	$("#displayDrugAllergy").click(function () { 
        $("#displayDrugAllergyId").show();
		$("#displayFoodAllergyId").hide();
		 $("#displayEnvAllergyId").hide();
    });
	$("#displayFoodAllergy").click(function () {  
        $("#displayFoodAllergyId").show();
		$("#displayDrugAllergyId").hide();
		 $("#displayEnvAllergyId").hide();
    });
	$("#displayEnvAllergy").click(function () {  
        $("#displayEnvAllergyId").show();
		$("#displayDrugAllergyId").hide();
		$("#displayFoodAllergyId").hide();
    });
    $("#closedrugallergy").click(function () { 
       $("#displayDrugAllergyId").hide();
    });
	 $("#closefoodallergy").click(function () { 
       $("#displayFoodAllergyId").hide();
    });
	$("#closeenvallergy").click(function () { 
		$("#displayEnvAllergyId").hide();
    });

	function hideallergy(val1)
	{
		
		
		if(document.getElementById("noknown").checked)
		{
			
			 document.getElementById("displayDrugAllergy").style.display="none";
			 document.getElementById("displayFoodAllergy").style.display="none";
			 document.getElementById("displayEnvAllergy").style.display="none";
		}
		else
		{
			 document.getElementById("displayDrugAllergy").style.display="block";
			 document.getElementById("displayFoodAllergy").style.display="block";
			 document.getElementById("displayEnvAllergy").style.display="block";
		}


	}

	//----fancy box---
	
	function icdwin() {
		
		var patient_id = $('#patient_id').val();  
		if (patient_id == '') {
			alert("Please select patient");
			return false;
		}
		$.fancybox({

			'width' : '50%',
			'height' : '120%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "icd")); ?>"
					+ '/' + patient_id
		});

}
	

   
 //----fancy box---
   function snowmed(){ 
		var patient_id = '<?php echo $patient_id;?>';
		if (patient_id == '') {
			alert("Please select patient");
			return false;
		}
		$.fancybox({
				'width' : '70%',
				'height' : '120%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "snowmed")); ?>"+'/'+patient_id
				});

		}
	   
   $('#pres')
	.click(
			function() {
				//	var patient_id = $('#selectedPatient').val();

				$
						.fancybox({
							'width' : '70%',
							'height' : '90%',
							'autoScale' : true,
							'transitionIn' : 'fade',
							'transitionOut' : 'fade',
							'type' : 'iframe',
							'onComplete' : function() {
								$("#allergies").css({
									top : '20px',
									bottom : auto,
									position : absolute
								});
							},
							'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "bmi_chart",$patientDetails['Patient']['id'])); ?>"

						});

					
			});

   function icdwin1(id) {
	    var identify =""; 
		identify = id;
	/*	$.fancybox({
					'width' : '70%',
					'height' : '120%',
					'autoScale' : true,
					'transitionIn' : 'fade',
					'transitionOut' : 'fade',
					'type' : 'iframe',
					'href' : "<?php // echo $this->Html->url(array("controller" => "Diagnoses", "action" => "familyproblem")); ?>" + "/" + identify,
				});*/
		window.location.href = "<?php  echo $this->Html->url(array("controller" => "Diagnoses", "action" => "familyproblem")); ?>" + "/" + identify
       }
 	//----fancy box---
   function pres1() {
		
		var patient_id = $('#p_id').val();  
		
		if (patient_id == '') {
			alert("Please select patient");
			return false;
		}
		$
				.fancybox({

					'width' : '70%',
					'height' : '75%',
					'autoScale' : true,
					'transitionIn' : 'fade',
					'transitionOut' : 'fade',
					'type' : 'iframe',
					'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "smoking_detail")); ?>"+'/'+ patient_id
				});

		}


 //------ for ccda-----
				$("#from" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,
			yearRange: '1950',
			dateFormat:'<?php echo $this->General->GeneralDate();?>'
			});
			
			$("#to" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,
			yearRange: '1950',
			dateFormat:'<?php echo $this->General->GeneralDate();?>'
			});

			$("#from_current" ).datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				changeTime:true,
				showTime: true,
				yearRange: '1950',
				dateFormat:'<?php echo $this->General->GeneralDate();?>'
				});
				
				$("#to_current" ).datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				changeTime:true,
				showTime: true,
				yearRange: '1950',
				dateFormat:'<?php echo $this->General->GeneralDate();?>'
				});

				$(".orderlabdate" ).datepicker({
					showOn: "button",
					buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
					buttonImageOnly: true,
					changeMonth: true,
					changeYear: true,
					changeTime:true,
					showTime: true,
					yearRange: '1950',
					dateFormat:'<?php echo $this->General->GeneralDate();?>'
					});

		function callDragon(notetype){
		

		$ .fancybox({
			'width' : '50%',
			'height' : '50%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'href' : "<?php echo $this->Html->url(array("controller" => "patients", "action" => "dragon")); ?>"+'/'+ notetype
		});
		 
	}
//-------eof ccda code
 
var counter=0;

var labText = '<tr><td width="19%" valign="middle" class="tdLabel" id="rectal_examine">&nbsp;</td><td width="19%" valign="middle" class="tdLabel" id="boxspace">&nbsp;</td><td width="19%" valign="middle" class="tdLabel" id="boxspace">&nbsp;</td></tr>';
var labInput = '<tr><td   valign="middle"  id="rectal_examine"><?php echo $this->Form->input("PersonalHealth.disability_0", array("type"=>"text","label"=>false,"style"=>"width:150px","id" => "disability")); ?></td><td valign="top"  id="rectal_examine">Date :</td><td  valign="middle" class="" id="boxspace"><?php echo $this->Form->input("effective_date_0", array("type"=>"text","label"=>false,"style"=>"width:80px","class" => "effective_date")); ?></td><td   valign="middle"   id="boxspace"><?php echo $this->Form->radio('PersonalHealth.status_option_0', array('Active'=>'Active','Inactive'=>'Inactive'), array('legend'=>false,'label'=>false,'id' => 'status_option' ? FALSE : TRUE,));?></td><td>&nbsp;</td><td>&nbsp;</td></tr>';
var labInput1 = '<tr><td   valign="middle"  id="rectal_examine"><?php echo $this->Form->input("PersonalHealth.disability_0", array("type"=>"text","label"=>false,"style"=>"width:150px","id" => "disability")); ?></td><td valign="top"  id="rectal_examine">Date :</td><td  valign="middle" class="" id="boxspace"><?php echo $this->Form->input("effective_date_0", array("type"=>"text","label"=>false,"style"=>"width:80px","class" => "effective_date")); ?></td><td   valign="middle"   id="boxspace"><?php echo $this->Form->radio('PersonalHealth.status_option_0', array('Active'=>'Active','Inactive'=>'Inactive'), array('legend'=>false,'label'=>false,'id' => 'status_option' ? FALSE : TRUE,));?></td><td>&nbsp;</td><td>&nbsp;</td></tr>';

$(function() {
    $("#labResultButton").click(function(event) {//alert('Here');
    	ss= "disabilityAdd_"+counter ;
		counter++;
		
    	var newCostDiv = $(document.createElement('table')).attr("id",'disabilityAdd_'+ counter);
    	labInput = labInput1;
    	
		labInput = labInput.replace("disability_0","disability_"+counter);
		labInput = labInput.replace("disability_0","disability_"+counter); 
		labInput = labInput.replace("effective_date_0","PersonalHealth][effective_date_"+counter);
		labInput = labInput.replace("effective_date_0","PersonalHealth][effective_date_"+counter);
		labInput = labInput.replace("status_option_0","status_option_"+counter);
		labInput = labInput.replace("status_option_0","status_option_"+counter);
		labInput = labInput.replace("status_option_0","status_option_"+counter);
		
		
		
		//newCostDiv.append(labText);
		newCostDiv.append(labInput);
		
		
		
		$(newCostDiv).insertAfter('#'+ss);
		$("#labcount").val(counter);
		
		
		
		
		
    });
});
$(function() { //RemoveLabResultButton
    $("#RemoveLabResultButton").click(function(event) {
    $('#disabilityAdd_'+ (counter-1)).nextAll().remove()
		//$("#labHl7Results").remove('labHl7Results'+ '_' + (counter));
		counter--;
		
    });
    $("#plancare_desc").autocomplete("<?php echo $this->Html->url(array("controller" => "SmartPhrases", "action" => "getSmartPhrase","admin" => false,"plugin"=>false)); ?>", {
		width: 250,
		//selectFirst: true,
		isSmartPhrase:true,
		//autoFill:true,
		select: function(e){ }
	});
	$("#general_examine").autocomplete("<?php echo $this->Html->url(array("controller" => "SmartPhrases", "action" => "getSmartPhrase","admin" => false,"plugin"=>false)); ?>", {
		width: 250,
		//selectFirst: true,
		isSmartPhrase:true,
		//autoFill:true,
		select: function(e){ }
	});

	$("#complaints_desc").autocomplete("<?php echo $this->Html->url(array("controller" => "SmartPhrases", "action" => "getSmartPhrase","admin" => false,"plugin"=>false)); ?>", {
		width: 250,
		//selectFirst: true,
		isSmartPhrase:true,
		//autoFill:true,
		select: function(e){ }
	});
	
	$("#lab-reports_desc").autocomplete("<?php echo $this->Html->url(array("controller" => "SmartPhrases", "action" => "getSmartPhrase","admin" => false,"plugin"=>false)); ?>", {
		width: 250,
		//selectFirst: true,
		isSmartPhrase:true,
		//autoFill:true,
		select: function(e){ }
	});
	
	$("#surgery_desc").autocomplete("<?php echo $this->Html->url(array("controller" => "SmartPhrases", "action" => "getSmartPhrase","admin" => false,"plugin"=>false)); ?>", {
		width: 250,
		//selectFirst: true,
		isSmartPhrase:true,
		//autoFill:true,
		select: function(e){ }
	});

	$("#final_diagnosis").autocomplete("<?php echo $this->Html->url(array("controller" => "SmartPhrases", "action" => "getSmartPhrase","admin" => false,"plugin"=>false)); ?>", {
		width: 250,
		//selectFirst: true,
		isSmartPhrase:true,
		//autoFill:true,
		select: function(e){ }
	});
   
});
$("#date_smoke")
.datepicker(
		{
			showOn : "button",
			buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly : true,
			changeMonth : true,
			changeYear : true,
			yearRange: '-100:' + new Date().getFullYear(),
			maxDate : new Date(),
			dateFormat:'<?php echo $this->General->GeneralDate();?>',
			onSelect : function() {
				$(this).focus();
				//foramtEnddate(); //is not defined hence commented
			}

		});
$("#date_smoke1")
.datepicker(
		{
			showOn : "button",
			buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly : true,
			changeMonth : true,
			changeYear : true,
			yearRange: '-100:' + new Date().getFullYear(),
			maxDate : new Date(),
			dateFormat:'<?php echo $this->General->GeneralDate();?>',
			onSelect : function() {
				$(this).focus();
				//foramtEnddate(); //is not defined hence commented
			}

		});
$(document).ready(function(){
    $("#doctor_id_txt").autocomplete("<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "testcomplete","DoctorProfile",'user_id',"doctor_name",'null',"admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true,
			valueSelected:true,
			loadId : 'doctor_id_txt,consultant_sb'
		});

	$('#smoking_info').click(function (){
	
		$.fancybox({
			'width' : '70%',
			'height' : '35%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "alcohal_cessation_assesment",$patientDetails['Patient']['id'])); ?>"
	});
	});
		 $('#alcohol_fill').click(function (){
			$.fancybox({
				'width' : '70%',
				'height' : '60%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "alcohal_assesment",$patientDetails['Patient']['id'])); ?>"
		});
	});

		 $('#smoking_alco_info').click(function (){
				$.fancybox({
					'width' : '70%',
					'height' : '100%',
					'autoScale' : true,
					'transitionIn' : 'fade',
					'transitionOut' : 'fade',
					'type' : 'iframe',
					'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "alcohal_cessation_assesment",$patientDetails['Patient']['id'])); ?>"
			});
			});
				 $('#alcohol_smoke_fill').click(function (){
					$.fancybox({
						'width' : '70%',
						'height' : '100%',
						'autoScale' : true,
						'transitionIn' : 'fade',
						'transitionOut' : 'fade',
						'type' : 'iframe',
						'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "alcohal_assesment",$patientDetails['Patient']['id'])); ?>"
						
				});
			});
				 $(document).on('focus','.procedure', function() {
				//	 $(".procedure").live("focus",function() {
				//alert($(this).attr('id')+'-----'+$(this).attr('id').replace("Display_","_"));
					 $(this).autocomplete("<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "testcomplete","TariffList","id",'name','service_category_id='.Configure::read('servicecategoryid'),"admin" => false,"plugin"=>false)); ?>", {
							width: 250, 
							showNoId:true,
							//delay:2000,
							valueSelected:true,
							selectFirst: true,
							loadId : $(this).attr('id')+','+$(this).attr('id').replace("Display_","_")
						});
						  });
				 $(document).on('focus','.providercls', function() {
			//		 $(".providercls").live("focus",function() {
			  		 $(this).autocomplete("<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "testcomplete","DoctorProfile","id",'doctor_name','is_active=1',"admin" => false,"plugin"=>false)); ?>", {
						width: 250, 
						showNoId:true,
						//delay:2000,
						valueSelected:true,
						selectFirst: true,
						loadId : $(this).attr('id')+','+$(this).attr('id').replace("Display_","_")
					});
				});
});
</script>

<script>
$("#date_vital").datepicker({
	showOn : "button",
	style : "margin-left:50px",
	buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly : true,
	changeMonth : true,
	changeYear : true,
	yearRange : '1950',
	dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
	});


$(document).ready(function(){
	
	//$("#diagnosisfrm").validationEngine();
	/*$('#submit').click(function() { 
		var validatePerson = jQuery("#diagnosisfrm").validationEngine('validate');
		if (validatePerson) {$(this).css('display', 'none');
		return true;}
		else{
		return false;
		}
		});
*/		
	$('#reset-bmi').click(function(){
		$('.bmi').each(function(){
			if ($(this).attr("type") == "radio") {
				$(this).attr('checked',false);
			} else {
				$(this).val('');
			}
		});
		return false  ;
	}); 
		 
	});  	

  $(window).load(function () {
	if ($('#TypeHeightFeet').is(':checked')) {
		$('#feet_result').show();
	}
  });




function showBmi()
		 { //alert($("input:radio.Weight:checked").val());
		 		var h = $('#height_result').val();
		 		var height = h.slice(0, h.lastIndexOf(" "));

		 		/*if(height==0){
			 		alert('Please enter proper height');
			 		//$('#height1').val("");
			 		 $('#feet_result').val("");
			 		  $('#height_result').val("");
			 		  $('.Height').attr('checked', false);
			 		  $('#bmis').val("");
			 			return false;
		 		}*/
		 		
		 		/*if(($('#height_result').val())=="")
		 		 {
		 		 alert('Please Enter Height.');
		 		 return;
		 		 }*/
		 		if(/*($('#height_result').val())==""||*/($('#weights').val())==""||($('#weight_result').val())=="")
		 		 {
		 		 alert('Please Enter Weight.');
		 		 return;
		 		 }
		 		
		 		if($("input:radio.Height:checked").val()=="Inches"||$("input:radio.Height:checked").val()=="Cm"||$("input:radio.Height:checked").val()=="Feet")
		 		{
		 		
		 		if($("input:radio.Weight:checked").val()=="Kg")
		 		{
		 			var weight = $('#weights').val();
		 		}
		 		if($("input:radio.Weight:checked").val()=='Lbs')
		 		{	
		 			var w = $('#weight_result').val();
		 			var weight = w.slice(0, w.lastIndexOf(" "));
		 		}
		 		height = (height / 100);
		 		weight = weight;
		 		height = (height * height);
		 		//height = (height / 100);
		 		var total = weight / height;
		 		
		 		total=Math.round((total * 100) / 100);

				 if(!isNaN(parseInt(total)) && isFinite(total)){
					$('#bmis').val(total);
				 }
		   
		 		}
		 		else
		 		{
		 			//alert('Please Enter Height.');
		 			 return;
		 			}
		 		
		  }; 


$('.cercumference').click(function ()
{//alert($(this).val());
		//alert($('#head_circumference').val());
		$('#head_result').val($('#head_circumference').val());

		 if(isNaN($('#head_circumference').val())==false){ 
				  if($(this).val()=="Inches")
				  {
				    var val=$('#head_circumference').val();
				    var res=(val/0.3937);
				    res= Math.round(res * 100) / 100;
				    //var result=Math.round(res);
				    $('#head_result').val(res+" Cm");
				  }
				  else 
				  {
				    var val=$('#head_circumference').val();
				    var res1=(val*0.3937);
				    res1= Math.round(res1 * 100) / 100;
				    //var result1=Math.round(res);
				    $('#head_result').val(res1+" Inches");
				  }
		 }
		 else{
			 
			  alert('Please enter valid head cercumference');
			  $('#head_circumference').val("");
			  $('#head_result').val("");
			  $('.cercumference').attr('checked', false);
				return false;
			}
		 
 });  

$('#head_circumference').keyup(function ()
{//alert($('.cercumference').val());
				//alert($('#head_circumference').val());
				$('#head_result').val($('#head_circumference').val());

				 if(isNaN($('#head_circumference').val())==false){ 
				  if($('.cercumference').val()=="Inches")
				  {
				    var val=$('#head_circumference').val();
				    var res=(val/0.3937);
				    res= Math.round(res * 100) / 100;
				    //var result=Math.round(res);
				    $('#head_result').val(res+" Cm");
				  }
				  else 
				  {
				    var val=$('#head_circumference').val();
				    var res1=(val*0.3937);
				    res1= Math.round(res1 * 100) / 100;
				    //var result1=Math.round(res);
				    $('#head_result').val(res1+" Inches");
				  }
				 }
				 else{
					 
				  alert('Please enter valid head cercumference');
				  $('#head_circumference').val("");
				  $('#head_result').val("");
				  $('.cercumference').attr('checked', false);
					return false;
					}
				 
});

$('.waist').click(function ()
	{//alert($(this).val());
			//alert($('#waist_circumference').val());
			$('#waist_result').val($('#waist_circumference').val());
			 if(isNaN($('#waist_circumference').val())==false){  
				  if($(this).val()=="Inches")
				  {
				    var val=$('#waist_circumference').val();
				    var res=(val/0.3937);
				    res= Math.round(res * 100) / 100;
				   // var result=Math.round(res);
				    $('#waist_result').val(res+" Cm");
				  }
				  else 
				  {
				    var val=$('#waist_circumference').val();
				    var res1=(val*0.3937);
				    res1= Math.round(res1 * 100) / 100;
				    //var result1=Math.round(res);
				    $('#waist_result').val(res1+" Inches");
				  }
			 }
			 else{
				 
				  alert('Please enter valid waist');
				  $('#waist_circumference').val("");
				  $('#waist_result').val("");
				  $('.waist').attr('checked', false);
					return false;
				}
			 
	 });  


$('#waist_circumference').keyup(function ()
{//alert($('.waist').val());
		//alert($('#waist_circumference').val());
		$('#waist_result').val($('#waist_circumference').val());
		 if(isNaN($('#waist_circumference').val())==false){  
			  if($('.waist').val()=="Inches")
			  {
			    var val=$('#waist_circumference').val();
			    var res=(val/0.3937);
			    res= Math.round(res * 100) / 100;
			   // var result=Math.round(res);
			    $('#waist_result').val(res+" Cm");
			  }
			  else 
			  {
			    var val=$('#waist_circumference').val();
			    var res1=(val*0.3937);
			    res1= Math.round(res1 * 100) / 100;
			    //var result1=Math.round(res);
			    $('#waist_result').val(res1+" Inches");
			  }
		 }
		 else{
			 
			  alert('Please enter valid waist');
			  $('#waist_circumference').val("");
			  $('#waist_result').val("");
			  $('.waist').attr('checked', false);
				return false;
			}
 });


$('.degree').click(function ()
{
	$('#equal_value').val($('#temperature').val());

		 if(($('#temperature').val())=="")
			 {
			 alert('Please Enter Tempreture in Degrees.');
			 return;
			 }
		 if(isNaN($('#temperature').val())==false){
				
		  if($(this).val()=="F")
		  {
			  var val=$('#temperature').val();
			    var tf=(val);
			    var tc=(5/9)*(tf-32);
			    var res=(tc*Math.pow(10,2))/Math.pow(10,2);
			    res= Math.round(res * 100) / 100;
		    	$('#equal_value').val(res+" C");
		  }
		  else 
		  {
			  var val=$('#temperature').val();
			    var tc=(val);
			    var tf=((9/5)*tc)+32;
			    var res1=(tf*Math.pow(10,2))/Math.pow(10,2);
			    res1= Math.round(res1 * 100) / 100;
			    $('#equal_value').val(res1+" F");
		  }
		 }
		 else{
			  alert('Please enter valid temprature');
			  $('#temperature').val("");
			  $('#equal_value').val("");
			  $('.degree').attr('checked', false);
				return false;
			}
});   

$('#temperature').keyup(function ()
	{
		$('#equal_value').val($('#temperature').val());
	 if(($('#temperature').val())=="")
		 {
		 alert('Please Enter Tempreture in Degrees.');
		 return;
		 }
	 if(isNaN($('#temperature').val())==false){
			
	  if($('.degree').val()=="F")
	  {
		  var val=$('#temperature').val();
		    var tf=(val);
		    var tc=(5/9)*(tf-32);
		    var res=(tc*Math.pow(10,2))/Math.pow(10,2);
		    res= Math.round(res * 100) / 100;
	    	$('#equal_value').val(res+" C");
	  }
	  else 
	  {
		  var val=$('#temperature').val();
		    var tc=(val);
		    var tf=((9/5)*tc)+32;
		    var res1=(tf*Math.pow(10,2))/Math.pow(10,2);
		    res1= Math.round(res1 * 100) / 100;
		    $('#equal_value').val(res1+" F");
	  }
	 }
	 else{
		 
		  alert('Please enter valid temprature');
		  $('#temperature').val("");
		  $('#equal_value').val("");
		  $('.degree').attr('checked', false);
			return false;
		}
		  
});

$('.Weight').click(function ()
	{//alert($('.Weight').val());
			 //alert($('#weights').val());
		
			$('#weight_result').val($('#weights').val());

			if(($('#weights').val())=="")
			{
			 alert('Please Enter Weight.');
			 $('.Weight').attr('checked', false);
			 return;
			}	
			
			if(isNaN($('#weights').val())==false){
				  if($(this).val()=="Kg")
				  {
				    var val=$('#weights').val();
				    var res=(val*2.2);
				    res= Math.round(res * 100) / 100;
				   // var result=Math.round(res);
				    $('#weight_result').val(res+" Pounds");
				  }
				  else 
				  {
				    var val=$('#weights').val();
				    var res1=(val/2.2);
				    res1= Math.round(res1 * 100) / 100;
				    //var result1=Math.round(res);
				    $('#weight_result').val(res1+" Kg");
				  }
			}
			else{
				 
				alert('Please enter valid weight');
				  $('#weights').val("");
				  $('#weight_result').val("");
				  $('.Weight').attr('checked', false);
					return false;
			}
			showBmi();
		
	 });  

$('#weights').keyup(function ()
	{//alert($('.Weight').val());
			 //alert($('#weights').val());
		
			$('#weight_result').val($('#weights').val());

			if(($('#weights').val())=="")
			{
			 alert('Please Enter Weight.');
			 //$('.Weight').attr('checked', false);
			 return;
			}	
			
			if(isNaN($('#weights').val())==false){
				  if($('.Weight').val()=="Kg")
				  {
				    var val=$('#weights').val();
				    var res=(val*2.2);
				    res= Math.round(res * 100) / 100;
				   // var result=Math.round(res);
				    $('#weight_result').val(res+" Pounds");
				  }
				  else 
				  {
				    var val=$('#weights').val();
				    var res1=(val/2.2);
				    res1= Math.round(res1 * 100) / 100;
				    //var result1=Math.round(res);
				    $('#weight_result').val(res1+" Kg");
				  }
			}
			else{
				 
				alert('Please enter valid weight');
				  $('#weights').val("");
				  $('#weight_result').val("");
				  $('.Weight').attr('checked', false);
					return false;
			}

			showBmi();
	 });

$('#height1').keyup(function ()
{  
	  checkedRadiod  = $(".Height input[type='radio']:checked").val();
	  $('.Height').each(function(){		  
		  if($(this).attr('checked')==true){ 
		    calHeight($(this).attr('id')) ;
	   	  }
	  });
	  showBmi();
});


$("#feet_result").keyup(function ()		{  
	 checkedRadiod  = $(".Height input[type='radio']:checked").val();
	  $('.Height').each(function(){		  
		  if($(this).attr('checked')==true){ 
		    calHeight($(this).attr('id')) ;
	   	  }
	  }); 
	  showBmi(); 	
});

$('.Height').click(function ()
{  
	 calHeight($(this).attr('id'));
	 showBmi();
}); 

$('#height1').blur(function ()
{  
	 //calHeight($(this).attr('id'));
		    	
});




function calHeight(idStr){	
	if(($('#height1').val())=="")
	{
	 alert('Please Enter Height.');
	// $('.Height').attr('checked', false);
	 $('#height_result').val("");
	 $('#feet_result').val("");
	 return;
	}	 
	if(isNaN($('#height1').val())==false){
			
		 $('#height_result').val($('#height1').val());
		  id = "#"+idStr ;
	}
	else{	 
	  alert('Please enter valid height');
	  $('#height1').val("");
	  $('#feet_result').val("");
	  $('#height_result').val("");
	  //$('.Height').attr('checked', false);
	  $('#bmi').val("");
		return false;
	}
	 
	  if($(id).val()=="Inches")
	  {		   
		  $('#feet_inch').hide();
	      var val=$('#height1').val();
	      var res=(val*2.54);
	      res= Math.round(res * 100) / 100;
	      $('#height_result').val(res+" Cm");
	      return res ;
	  }
	 if($(id).val()=="Cm")
	  {  
		$('#feet_inch').hide();
	    var val=$('#height1').val();
	    var res1=val;
	    res1= Math.round(res1 * 100) / 100;
	    //var result1=Math.round(res);
	    $('#height_result').val(res1+" Cm");
	    return res1 ;
	  }
	 if($(id).val()=="Feet")
	  {
		$('#feet_result')//calculate inches
		
		$('#feet_inch').show();
	    var val=$('#height1').val();
	    var res2=(val/0.032808);
	    res2= Math.round(res2 * 100) / 100;
	    var feetInches = $('#feet_result').val();
	    feetInches= Math.round(feetInches * 100) / 100;
        var feetInchesCalc=(feetInches*2.54);
        feetInchesCalc= Math.round(feetInchesCalc * 100) / 100;
	    //var result1=Math.round(res);
	    $('#height_result').val(+(res2+feetInchesCalc).toFixed(2)+" Cm");
	    return res2 ;
	  }

	  if(idStr=='height'){
		   
		 // checkedRadiod  = $('input[name=data[BmiResult][height]]:checked', '#design1').val() ;
		  checkedRadiod  = $(".Height input[type='radio']:checked").val();
		  $('.Height').each(function(){
			  //var id=$('.Height').attr('id');
			  //calHeight(id);
			  if($(this).attr('checked')==true){
			    calHeight($(this).attr('id')) ;
		   	  }
		  }); 
	  }else if(idStr=='feet_result'){ 
		  feetID = $('input[name=height_volume]:checked', '#diagnosisfrm').attr('id') ; //checked radio button 
		  $("input[name=height_volume]:radio").each(function () {
				if(this.checked) feetID=this.id;
		  });
		  feetCalc= calHeight(feetID);  
		  feetCalc= Math.round(feetCalc * 100) / 100;
	      var feetInches = $('#feet_result').val();
	      var feetInchesCalc=(feetInches*2.54); 
	      feetInchesCalc= Math.round(feetInchesCalc * 100) / 100; 
	      var total = Math.round(feetCalc+feetInchesCalc) ; 
	      $('#height_result').val(total+" Cm"); 
	  }
}



$(document).ready(function(){
	//$('#hxabnormalpap_yes').hide();
	 $(document).on('focus','.problemAutocomplete', function() {
	//	 $(".problemAutocomplete").live("focus",function() {
	 
		$(this).autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","SnomedMappingMaster","icd9name",'null','null','null','icd9code<>=','icd9name',"admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true,
			//minLength: 3
		});
	});
	 
	 $(".last_PPD_yes").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '-100:' + new Date().getFullYear(),
			dateFormat:'<?php echo $this->General->GeneralDate("");?>',
			maxDate: new Date(),
			onSelect : function() {
				$(this).focus();
			} 
		}); 
	 $(".hxabnormalpap_yes").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '-100:' + new Date().getFullYear(),
			dateFormat:'<?php echo $this->General->GeneralDate("");?>',
			maxDate: new Date(),
			onSelect : function() {
				$(this).focus();
			} 
		}); 
		$(".last_mammography_yes").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '-100:' + new Date().getFullYear(),
			dateFormat:'<?php echo $this->General->GeneralDate("");?>',
			maxDate: new Date(),
			onSelect : function() {
				$(this).focus();
			} 
		}); 
		$("#first_round_date,#last_round_date,#radiation_start_date,#radiation_finish_date").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '-100:' + new Date().getFullYear(),
			dateFormat:'<?php echo $this->General->GeneralDate("");?>',
			maxDate: new Date(),
			onSelect : function() {
				$(this).focus();
			} 
		}); 
		$(".receive_chemotherapy_dateCls").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '-100:' + new Date().getFullYear(),
			dateFormat:'<?php echo $this->General->GeneralDate("");?>',
			maxDate: new Date(),
			onSelect : function() {
				$(this).focus();
			} 
		}); 
		
		$("#other_relatives").change(function(){
			var data= $("#other_relatives option:selected").val();
			if(data=='Uncle'){
				$("#showUncle").fadeIn(10);	
				$("#other_relatives").val('');	
			}
			if(data=='Aunt'){
				$("#showAunt").fadeIn(10);
				$("#other_relatives").val('');		
			}
			if(data=='Grandmother'){
				$("#showGrandmother").fadeIn(10);
				$("#other_relatives").val('');		
			}
			if(data=='Grandfather'){
				$("#showGrandfather").fadeIn(10);
				$("#other_relatives").val('');		
			}
		});
// calls on ready
var relstr = "<?php echo $unHideRelation ?>";
var unHiderelationArray = relstr.split(',');
var relationArray = [];
var relationArray = ['showUncle','showAunt','showGrandmother','showGrandfather'];
	$.each(unHiderelationArray,function(index,value){
			if ($.inArray( value, relationArray ) !== -1){
				$('#'+value).hide();
			}
		});
});

/*jQuery(document).ready(function(){
	$('#expandBtn').click(function(){ 
				jQuery("#complaints").show();
				jQuery("#lab-reports").show();
				jQuery("#treatment").show();											
				jQuery("#other_treatments").show();
				jQuery("#significant_history").show();
				jQuery("#vitals").show();
			  	var validatePerson = jQuery("#diagnosisfrm").validationEngine('validate');
				if (validatePerson) {$(this).css('display', 'none');
				return false;}
			});


});*/
function expandCollapseAll(id){
	if(id=='collapseBtn'){//dragbox-content
		$(".dragbox-content").css('display','none'); 
		$('#expandBtn').removeClass('active');
		$('#collapseBtn').addClass('active');
	}else{
		$(".dragbox-content").css('display','block');
		$('#expandBtn').addClass('active');
		$('#collapseBtn').removeClass('active');
	}	
}


//***family history add more****//

$('#removefather').hide();
$('#removemother').hide();
$('#removebrother').hide();
$('#removesister').hide();
$('#removeson').hide();
$('#removedaughter').hide();

	var counterf=0;
	$("#addfather" ).click(function() {
		/*currentId = $(this).attr('id') ;
		splittedVar = currentId.split("_");		 
		Id = splittedVar[1];*/
		addMoreF();
	});
	function addMoreF(){
		var numItems = $('.father').length;
 		if(parseInt(numItems) == 1){
 			$("#removefather").show();
 		}
 		if(parseInt(numItems) < 5){
 			counterf=counterf+'_f';
		$("#mrow")
	 	 .before($('<tr class=father id=father'+counterf+'>')
    		.append($('<td>'))
    		.append($('<td>').append($('<input>').attr({'class':'problemAutocomplete textBoxExpnd','style':'width: 270px','type':'text','name':'data[Diagnosis][problemf][]'})))
    		.append($('<td>').append($('<select>').attr({'id':'problem_'+counterf,'style':'width: 270px','class':'problem_'+counterf+' textBoxExpnd','type':'select','name':'data[Diagnosis][statusf][]'})))
    		.append($('<td>').append($('<input>').attr({'class':'textBoxExpnd','style':'width: 270px','type':'text','name':'data[Diagnosis][commentsf][]'})))
    		.append($('<td>'))
    		.append($('<td>')))
		
    	problemStatus(counterf);
    	splittedVar = counterf.split("_");
    	counterf=splittedVar[0];	
    	counterf++;
		}
	}

	$("#removefather").click(function(){
		var numItems = $('.father').length;
 		if(parseInt(numItems) > 1){
	 		counterf--;
	 		counterf=counterf+'_f';
	 		$('.father').last().remove();
	 		splittedVar = counterf.split("_");
	    	counterf=splittedVar[0];
 		}
 		if(parseInt(numItems) == 2){
 			$("#removefather").hide();
 		}
 	});

	function problemStatus(flag){
 		var selectproblemStatus = <?php echo json_encode(Configure::read('problemStatus'));?>;
 		$.each(selectproblemStatus, function(key, value) {
	 		 $('#problem_'+flag).append($('<option>', { value : key }).text(value));
		});
 	}


	var counterm=0;
	$("#addmother" ).click(function() {
		addMoreM();
	});
	function addMoreM(){
		var numItems = $('.mother').length;
		if(parseInt(numItems) == 1){
 			$("#removemother").show();
 		}
 		if(parseInt(numItems) < 5){
 			counterm=counterm+'_m';
		$("#brow")
	 	 .before($('<tr class=mother id=mother'+counterm+'>')
    		.append($('<td>'))
    		.append($('<td>').append($('<input>').attr({'class':'problemAutocomplete textBoxExpnd','style':'width: 270px','type':'text','name':'data[Diagnosis][problemm][]'})))
    		.append($('<td>').append($('<select>').attr({'id':'problem_'+counterm,'style':'width: 270px','class':'problem_'+counterm+' textBoxExpnd','type':'select','name':'data[Diagnosis][statusm][]'})))
    		.append($('<td>').append($('<input>').attr({'class':'textBoxExpnd','style':'width: 270px','type':'text','name':'data[Diagnosis][commentsm][]'})))
    		.append($('<td>'))
    		.append($('<td>')))

    	problemStatus(counterm);
    	splittedVar = counterm.split("_");
		counterm=splittedVar[0];	
    	counterm++;
		}
	}

	$("#removemother").click(function(){
 		var numItems = $('.mother').length;
 		if(parseInt(numItems) > 1){
 			counterm--;
 			counterm=counterm+'_m';
	 		$('.mother').last().remove();
	 		splittedVar = counterm.split("_");
	 		counterm=splittedVar[0];
 		}
 		if(parseInt(numItems) == 2){
 			$("#removemother").hide();
 		}
 	});
		

	var counterb=0;
	$("#addbrother" ).click(function() {
		addMoreB();
	});
	function addMoreB(){
		var numItems = $('.brother').length;
		if(parseInt(numItems) == 1){
 			$("#removebrother").show();
 		}
 		if(parseInt(numItems) < 5){
 			counterb=counterb+'_b';
		$("#srow")
	 	 .before($('<tr class=brother id=brother'+counterb+'>')
    		.append($('<td>'))
    		.append($('<td>').append($('<input>').attr({'class':'problemAutocomplete textBoxExpnd','style':'width: 270px','type':'text','name':'data[Diagnosis][problemb][]'})))
    		.append($('<td>').append($('<select>').attr({'id':'problem_'+counterb,'style':'width: 270px','class':'problem_'+counterb+' textBoxExpnd','type':'select','name':'data[Diagnosis][statusb][]'})))
    		.append($('<td>').append($('<input>').attr({'class':'textBoxExpnd','style':'width: 270px','type':'text','name':'data[Diagnosis][commentsb][]'})))
    		.append($('<td>'))
    		.append($('<td>')))

    	problemStatus(counterb);
    	splittedVar = counterb.split("_");
		counterb=splittedVar[0];	
    	counterb++;
		}
	}

	$("#removebrother").click(function(){
 		var numItems = $('.brother').length;
 		if(parseInt(numItems) > 1){
 			counterb--;
 			counterb=counterb+'_b';
	 		$('.brother').last().remove();
	 		splittedVar = counterb.split("_");
	 		counterb=splittedVar[0];
 		}
 		if(parseInt(numItems) == 2){
 			$("#removebrother").hide();
 		}
 	});


	var counters=0;
	$("#addsister" ).click(function() {
		addMoreS();
	});
	function addMoreS(){
		var numItems = $('.sister').length;
		if(parseInt(numItems) == 1){
 			$("#removesister").show();
 		}
 		if(parseInt(numItems) < 5){
 			counters=counters+'_s';
		$("#sonrow")
	 	 .before($('<tr class=sister id=sister'+counters+'>')
    		.append($('<td>'))
    		.append($('<td>').append($('<input>').attr({'class':'problemAutocomplete textBoxExpnd','style':'width: 270px','type':'text','name':'data[Diagnosis][problems][]'})))
    		.append($('<td>').append($('<select>').attr({'id':'problem_'+counters,'style':'width: 270px','class':'problem_'+counters+' textBoxExpnd','type':'select','name':'data[Diagnosis][statuss][]'})))
    		.append($('<td>').append($('<input>').attr({'class':'textBoxExpnd','style':'width: 270px','type':'text','name':'data[Diagnosis][commentss][]'})))
    		.append($('<td>'))
    		.append($('<td>')))

    	problemStatus(counters);
		splittedVar = counters.split("_");
		counters=splittedVar[0];
    	counters++;
		}
	}

	$("#removesister").click(function(){
 		var numItems = $('.sister').length;
 		if(parseInt(numItems) > 1){
 			counters--;
 			counters=counters+'_s';
	 		$('.sister').last().remove();
	 		splittedVar = counters.split("_");
	 		counters=splittedVar[0];
 		}
 		if(parseInt(numItems) == 2){
 			$("#removesister").hide();
 		}
 	});


	var counterson=0;
	$("#addson" ).click(function() {
		addMoreSon();
	});
	function addMoreSon(){
		var numItems = $('.son').length;
		if(parseInt(numItems) == 1){
 			$("#removeson").show();
 		}
 		if(parseInt(numItems) < 5){
 			counterson=counterson+'_son';
		$("#drow")
	 	 .before($('<tr class=son id=son'+counterson+'>')
    		.append($('<td>'))
    		.append($('<td>').append($('<input>').attr({'class':'problemAutocomplete textBoxExpnd','style':'width: 270px','type':'text','name':'data[Diagnosis][problemson][]'})))
    		.append($('<td>').append($('<select>').attr({'id':'problem_'+counterson,'style':'width: 270px','class':'problem_'+counterson+' textBoxExpnd','type':'select','name':'data[Diagnosis][statusson][]'})))
    		.append($('<td>').append($('<input>').attr({'class':'textBoxExpnd','style':'width: 270px','type':'text','name':'data[Diagnosis][commentsson][]'})))
    		.append($('<td>'))
    		.append($('<td>')))

    	problemStatus(counterson);
		splittedVar = counterson.split("_");
		counterson=splittedVar[0];
    	counterson++;
		}
	}

	$("#removeson").click(function(){
 		var numItems = $('.son').length;
 		if(parseInt(numItems) > 1){
 			counterson--;
 			counterson=counterson+'_son';
	 		$('.son').last().remove();
	 		splittedVar = counterson.split("_");
	 		counterson=splittedVar[0];
 		}
 		if(parseInt(numItems) == 2){
 			$("#removeson").hide();
 		}
 	});


	var counterd=0;
	$("#adddaughter" ).click(function() {
		addMoreD();
	});
	function addMoreD(){
		var numItems = $('.daughter').length;
		if(parseInt(numItems) == 1){
 			$("#removedaughter").show();
 		}
 		if(parseInt(numItems) < 5){
 			counterd=counterd+'_d';
		$("#otherrow")
	 	 .before($('<tr class=daughter id=daughter'+counterd+'>')
    		.append($('<td>'))
    		.append($('<td>').append($('<input>').attr({'class':'problemAutocomplete textBoxExpnd','style':'width: 270px','type':'text','name':'data[Diagnosis][problemd][]'})))
    		.append($('<td>').append($('<select>').attr({'id':'problem_'+counterd,'style':'width: 270px','class':'problem_'+counterd+' textBoxExpnd','type':'select','name':'data[Diagnosis][statusd][]'})))
    		.append($('<td>').append($('<input>').attr({'class':'textBoxExpnd','style':'width: 270px','type':'text','name':'data[Diagnosis][commentsd][]'})))
    		.append($('<td>'))
    		.append($('<td>')))

    	problemStatus(counterd);
		splittedVar = counterd.split("_");
		counterd=splittedVar[0];
    	counterd++;
		}
	}

	$("#removedaughter").click(function(){
 		var numItems = $('.daughter').length;
 		if(parseInt(numItems) > 1){
 			counterd--;
 			counterd=counterd+'_d';
	 		$('.daughter').last().remove();
	 		splittedVar = counterd.split("_");
	 		counterd=splittedVar[0];
 		}
 		if(parseInt(numItems) == 2){
 			$("#removedaughter").hide();
 		}
 	});


	var counteru=0;
	$("#adduncle" ).click(function() {
		addMoreU();
	});
	function addMoreU(){
		var numItems = $('.uncle').length;
 		if(parseInt(numItems) < 5){
 			counteru=counteru+'_u';
		$("#showAunt")
	 	 .before($('<tr class=uncle id=uncle'+counteru+'>')
    		.append($('<td>'))
    		.append($('<td>').append($('<input>').attr({'class':'problemAutocomplete textBoxExpnd','style':'width: 270px','type':'text','name':'data[Diagnosis][problemuncle][]'})))
    		.append($('<td>').append($('<select>').attr({'id':'problem_'+counteru,'style':'width: 270px','class':'problem_'+counteru+' textBoxExpnd','type':'select','name':'data[Diagnosis][statusuncle][]'})))
    		.append($('<td>').append($('<input>').attr({'class':'textBoxExpnd','style':'width: 270px','type':'text','name':'data[Diagnosis][commentsuncle][]'})))
    		.append($('<td>'))
    		.append($('<td>')))

    	problemStatus(counteru);
		splittedVar = counteru.split("_");
		counteru=splittedVar[0];
    	counteru++;
		}
	}

	$("#removeuncle").click(function(){
 		var numItems = $('.uncle').length;
 		if(parseInt(numItems) > 1){
 			counteru--;
 			counteru=counteru+'_u';
	 		$('.uncle').last().remove();
	 		splittedVar = counteru.split("_");
	 		counteru=splittedVar[0];
 		}else{
 			$("#showUncle").fadeOut(10);
 		}
 	});


	var countera=0;
	$("#addaunt" ).click(function() {
		addMoreA();
	});
	function addMoreA(){
		var numItems = $('.aunt').length;
 		if(parseInt(numItems) < 5){
 			countera=countera+'_a';
		$("#showGrandmother")
	 	 .before($('<tr class=aunt id=aunt'+countera+'>')
    		.append($('<td>'))
    		.append($('<td>').append($('<input>').attr({'class':'problemAutocomplete textBoxExpnd','style':'width: 270px','type':'text','name':'data[Diagnosis][problemaunt][]'})))
    		.append($('<td>').append($('<select>').attr({'id':'problem_'+countera,'style':'width: 270px','class':'problem_'+countera+' textBoxExpnd','type':'select','name':'data[Diagnosis][statusaunt][]'})))
    		.append($('<td>').append($('<input>').attr({'class':'textBoxExpnd','style':'width: 270px','type':'text','name':'data[Diagnosis][commentsaunt][]'})))
    		.append($('<td>'))
    		.append($('<td>')))

    	problemStatus(countera);
		splittedVar = countera.split("_");
		countera=splittedVar[0];
    	countera++;
		}
	}

	$("#removeaunt").click(function(){
 		var numItems = $('.aunt').length;
 		if(parseInt(numItems) > 1){
 			countera--;
 			countera=countera+'_a';
	 		$('.aunt').last().remove();
	 		splittedVar = countera.split("_");
	 		countera=splittedVar[0];
 		}else{
 			$("#showAunt").fadeOut(10);
 		}
 	});


	var countergm=0;
	$("#addgrandmother" ).click(function() {
		addMoregm();
	});
	function addMoregm(){
		var numItems = $('.grandmother').length;
 		if(parseInt(numItems) < 5){
 			countergm=countergm+'_gm';
		$("#showGrandfather")
	 	 .before($('<tr class=grandmother id=grandmother'+countergm+'>')
    		.append($('<td>'))
    		.append($('<td>').append($('<input>').attr({'class':'problemAutocomplete textBoxExpnd','style':'width: 270px','type':'text','name':'data[Diagnosis][problemgrandmother][]'})))
    		.append($('<td>').append($('<select>').attr({'id':'problem_'+countergm,'style':'width: 270px','class':'problem_'+countergm+' textBoxExpnd','type':'select','name':'data[Diagnosis][statusgrandmother][]'})))
    		.append($('<td>').append($('<input>').attr({'class':'textBoxExpnd','style':'width: 270px','type':'text','name':'data[Diagnosis][commentsgrandmother][]'})))
    		.append($('<td>'))
    		.append($('<td>')))

    	problemStatus(countergm);
		splittedVar = countergm.split("_");
		countergm=splittedVar[0];
    	countergm++;
		}
	}

	$("#removegrandmother").click(function(){
 		var numItems = $('.grandmother').length;
 		if(parseInt(numItems) > 1){
 			countergm--;
 			countergm=countergm+'_gm';
	 		$('.grandmother').last().remove();
	 		splittedVar = countergm.split("_");
	 		countergm=splittedVar[0];
 		}else{
 			$("#showGrandmother").fadeOut(10);
 		}
 	});


	var countergf=0;
	$("#addgrandfather" ).click(function() {
		addMoregf();
	});
	function addMoregf(){
		var numItems = $('.grandfather').length;
 		if(parseInt(numItems) < 5){
 			countergf=countergf+'_gf';
		$("#afterGrandfather")
	 	 .before($('<tr class=grandfather id=grandfather'+countergf+'>')
    		.append($('<td>'))
    		.append($('<td>').append($('<input>').attr({'class':'problemAutocomplete textBoxExpnd','style':'width: 270px','type':'text','name':'data[Diagnosis][problemgrandfather][]'})))
    		.append($('<td>').append($('<select>').attr({'id':'problem_'+countergf,'style':'width: 270px','class':'problem_'+countergf+' textBoxExpnd','type':'select','name':'data[Diagnosis][statusgrandfather][]'})))
    		.append($('<td>').append($('<input>').attr({'class':'textBoxExpnd','style':'width: 270px','type':'text','name':'data[Diagnosis][commentsgrandfather][]'})))
    		.append($('<td>'))
    		.append($('<td>')))

    	problemStatus(countergf);
		splittedVar = countergf.split("_");
		countergf=splittedVar[0];
    	countergf++;
		}
	}

	$("#removegrandfather").click(function(){
 		var numItems = $('.grandfather').length;
 		if(parseInt(numItems) > 1){
 			countergf--;
 			countergf=countergf+'_gf';
	 		$('.grandfather').last().remove();
	 		splittedVar = countergf.split("_");
	 		countergf=splittedVar[0];
 		}else{
 			$("#showGrandfather").fadeOut(10);
 		}
 	});

 	 
	
	$(".alcohol-score").change(function(){ 
		finalScore = 0;
		$(".alcohol-score").each(function() {
			if($(this).val() != ''){
				finalScore += parseInt($(this).val()) ;
			}
		});		
		$('#alcholScore').val(finalScore);
		if($('#alcholScore').val()>=5){
			$("#furtherAsses").show();
			$("#alcohal_fill").show();
		
		}else{
			$("#furtherAsses").hide();
			$("#alcohal_fill").hide();
		}
	});

	$("#alcoholQ1").change(function(){ 
		value=$(this).val();
		$('#alcoholQ1Score').val(value);
	});

	$("#alcoholQ2").change(function(){ 
		value=$(this).val();
		$('#alcoholQ2Score').val(value);
	});

	$("#alcoholQ3").change(function(){ 
		value=$(this).val();
		$('#alcoholQ3Score').val(value);
	});
	 


	 

	function getPastMedicalHistory() {
		 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "getPastMedicalHistory",$patient_id,$personId,"admin" => false)); ?>";
	        $.ajax({
	        	beforeSend : function() {
	            	//loading("outerDiv","class");
	          	},
	        type: 'POST',
	        url: ajaxUrl,
	        //data: formData,
	        dataType: 'html',
	        success: function(data){
	        	//onCompleteRequest("outerDiv","class");
	        
	        	if(data!=''){
	       			 $('#getDiagno').html(data);
	        	}
	        },
			});
	}
</script>

