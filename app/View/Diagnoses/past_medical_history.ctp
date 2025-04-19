<?php 
echo $this->Html->script(array('jquery.autocomplete'));
echo $this->Html->css(array('jquery.autocomplete.css'));
?>
<?php echo $this->Form->create('pastMedicalHistory',array('id'=>'pastMedicalHistory','url'=>array('controller'=>'Diagnoses','action'=>'add',$patient['Patient']['id']),
		'inputDefaults' => array(
				'label' => false,
											        'div' => false,
											        'error'=>false )));
?>
<div class="patient_info">
	<?php echo $this->element('patient_information'); ?>
	<?php echo $this->Form->hidden('Diagnosis.patient_id',array('value'=>$patient['Patient']['id'])); 
	echo $this->Form->hidden('Diagnosis.id',array('value'=>$diagnosisId['Diagnosis']['id']));
	?>
</div>
<div style="display:<?php echo $display ;?>" class="section">


	<table class="tdLabel" style="text-align: left;">
		<tr>
			<td width="19%" valign="top" class="tdLabel" id="boxSpace"
				style="padding-top: 10px;">Past Medical History</td>
			<td colspan="4" style="" width="100%">
				<table width="100%" border="0" cellspacing="1" cellpadding="0"
					class="tabularForm">
					<tr>
						<td>
							<table width="100%" border="0" cellspacing="0" cellpadding="0"
								class="tabularForm" class="tdLabel">
								<tr>
									<td valign="top" width="25%" align="left"><?php echo __('Illness');?>
									</td>
									<td valign="top" width="20%" align="left"
										style="padding-left: 30px"><?php echo __('Status');?></td>
									<td valign="top" width="27%" align="left"><?php echo __('Duration(in years)');?>
									</td>
									<td valign="top" width="25%" align="left"
										style="padding-left: 10px"><?php echo __('Comments');?></td>
									<td valign="top" width="25%" align="left"
										style="padding-left: 10px"><?php echo __('Delete');?></td>
								</tr>
							</table>
						</td>
					</tr>

					<tr>
						<td>
							<table width="100%" border="0" cellspacing="0" cellpadding="0"
								class="tabularForm" id='DrugGroup_history' class="tdLabel">
								<?php  

								if(isset($pastHistory) && !empty($pastHistory))
								{
									$count_history  = count($pastHistory);
								}else
								{
									$count_history  = 3 ;
								}
								for($i=0;$i<$count_history;)
								{
									$illness_val= isset($pastHistory[$i][PastMedicalHistory][illness])?$pastHistory[$i][PastMedicalHistory][illness]:'' ;
									$status_val= isset($pastHistory[$i][PastMedicalHistory][status])?$pastHistory[$i][PastMedicalHistory][status]:'' ;
									$duration_val= isset($pastHistory[$i][PastMedicalHistory][duration])?$pastHistory[$i][PastMedicalHistory][duration]:'' ;
									$comment_val= isset($pastHistory[$i][PastMedicalHistory][comment])?$pastHistory[$i][PastMedicalHistory][comment]:'' ;


									?>

								<tr id="DrugGroup_history<?php echo $i;?>">

									<td valign="top" align="left"><?php echo $this->Form->input('', array('type'=>'text','class' => 'problemAutocomplete textBoxExpnd','id' =>"illness$i",'value'=>$illness_val,'name'=>'PastMedicalHistory[illness][]',style=>'width:230px','counter_history'=>$i)); ?>
									</td>
									<td class="tdLabel" align="left"><?php $options = array(''=>'Please Select','Chronic'=>'Chronic','Existing'=>'Existing','New_on_set'=>'New On Set','Recovered'=>'Recovered','Acute'=>'Acute','Inactive'=>'Inactive');
									echo $this->Form->input('', array('multiple'=>false,'options'=>$options,'class' => '','id'=>"status$i",'name' =>'PastMedicalHistory[status][]',style=>'width:150px','value'=>$status_val)); ?>
									</td>
									<td class="tdLabel" align="left"><?php echo $this->Form->input('', array('type'=>'text','class' => 'textBoxExpnd','id' =>"duration$i",'value'=>$duration_val,'name'=>'PastMedicalHistory[duration][]',style=>'width:230px','counter_history'=>$i)); ?>
									</td>
									<td class="tdLabel" align="left"><?php echo $this->Form->input('', array('type'=>'text','class' => 'textBoxExpnd','id' =>"comment$i",'value'=>$comment_val,'name'=>'PastMedicalHistory[comment][]',style=>'width:230px','counter_history'=>$i)); ?>
									</td>
									<td width="20"><?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete','class'=>'DrugGroup_history','id'=>"pMH$i"));?>
									</td>
								</tr>
								<?php
								$i++ ;
								}
								?>

							</table>
						</td>
					</tr>

					<tr>
						<td align="right" colspan="4"><input type="button"
							id="addButton_history" value="Add"> <?php if($count_history > 0)
							{?> <input type="button" id="removeButton_history" value="Remove">
							<?php }
							else{ ?> <input type="button" id="removeButton_history"
							value="Remove" style="display: none;"> <?php } ?>
						</td>
					</tr>
					<tr>
						<td>
							<table>

								<tr>
									<td class="tdLabel" valign="top" width="25%" align="left"><?php echo __('Preventive Care : '); ?>
									</td>
									<td class="tdLabel" valign="top" width="75%" align="left"><?php  echo $this->Form->input('Diagnosis.preventive_care', array('class' =>'textBoxExpnd','id' =>'preventive_care','value'=>$getpatient['0']['PastMedicalRecord']['preventive_care'],'style'=>'width:250px')); ?>
									</td>
								</tr>
							</table>
						</td>
					</tr>

				</table>
			</td>
		</tr>
		<tr>
			<td width="19%" valign="top" class="tdLabel" id="boxSpace"
				style="padding-top: 10px;">Family History</td>
			<td colspan="4" style="" width="100%">
				<table width="100%" border="0" cellspacing="1" cellpadding="0"
					class="tabularForm">
					<tr>
						<td>Relation</td>
						<td>Problem</td>
						<td>Status</td>
						<td>Comments</td>
					</tr>
					<tr>
						<td width=20%><?php echo __('Father'); ?>
						</td>
						<td class="tdLabel" id="boxSpace"><?php  echo $this->Form->input('Diagnosis.problemf', array('class' =>'problemAutocomplete textBoxExpnd','id' =>'father','value'=>$getpatientfamilyhistory[0][FamilyHistory][problemf])); ?>
						</td>
						<td class="tdLabel" id="boxSpace"><?php echo $this->Form->input('Diagnosis.statusf',array('options'=>array(""=>__('Please Select'),"Chronic"=>__('Chronic'),'Existing'=>__('Existing'),'New On Set'=>__('New On Set'),'Recovered'=>__('Recovered'),'Acute'=>__('Acute'),'Inactive'=>__('Inactive')),'value'=>$getpatientfamilyhistory[0][FamilyHistory][statusf],'id' => 'Statusfather')); ?>
						
						<td class="tdLabel" id="boxSpace"><?php echo $this->Form->input('Diagnosis.commentsf', array('class' => 'textBoxExpnd','id' => 'Comments','value'=>$getpatientfamilyhistory[0][FamilyHistory][commentsf])); ?>
						</td>
					</tr>
					<tr>
						<td width=20%><?php echo __('Mother'); ?>
						</td>
						<td class="tdLabel" id="boxSpace"><?php  echo $this->Form->input('Diagnosis.problemm', array('class' =>'problemAutocomplete textBoxExpnd','id' =>'mother','value'=>$getpatientfamilyhistory[0][FamilyHistory][problemm])); ?>
						</td>
						<td class="tdLabel" id="boxSpace"><?php echo $this->Form->input('Diagnosis.statusm',array('options'=>array(""=>__('Please Select'),"Chronic"=>__('Chronic'),'Existing'=>__('Existing'),'New On Set'=>__('New On Set'),'Recovered'=>__('Recovered'),'Acute'=>__('Acute'),'Inactive'=>__('Inactive')),'value'=>$getpatientfamilyhistory[0][FamilyHistory][statusm],'id' => 'Statusmother')); ?>
						
						<td class="tdLabel" id="boxSpace"><?php echo $this->Form->input('Diagnosis.commentsm', array('class' => 'textBoxExpnd','id' => 'Comments','value'=>$getpatientfamilyhistory[0][FamilyHistory][commentsm])); ?>
						</td>
					</tr>
					<tr>
						<td width=20%><?php echo __('Brother'); ?>
						</td>
						<td class="tdLabel" id="boxSpace"><?php  echo $this->Form->input('Diagnosis.problemb', array('class' =>'problemAutocomplete textBoxExpnd','id' =>'brother','value'=>$getpatientfamilyhistory[0][FamilyHistory][problemb])); ?>
						</td>
						<td class="tdLabel" id="boxSpace"><?php echo $this->Form->input('Diagnosis.statusb',array('options'=>array(""=>__('Please Select'),"Chronic"=>__('Chronic'),'Existing'=>__('Existing'),'New On Set'=>__('New On Set'),'Recovered'=>__('Recovered'),'Acute'=>__('Acute'),'Inactive'=>__('Inactive')),'value'=>$getpatientfamilyhistory[0][FamilyHistory][statusb],'id' => 'Statusbrother')); ?>
						
						<td class="tdLabel" id="boxSpace"><?php echo $this->Form->input('Diagnosis.commentsb', array('class' => 'textBoxExpnd','id' => 'Comments','value'=>$getpatientfamilyhistory[0][FamilyHistory][commentsb])); ?>
						</td>
					</tr>
					<tr>
						<td width=20%><?php echo __('Sister'); ?>
						</td>
						<td class="tdLabel" id="boxSpace"><?php  echo $this->Form->input('Diagnosis.problems', array('class' =>'problemAutocomplete textBoxExpnd','id' =>'sister','value'=>$getpatientfamilyhistory[0][FamilyHistory][problems])); ?>
						</td>
						<td class="tdLabel" id="boxSpace"><?php echo $this->Form->input('Diagnosis.statuss',array('options'=>array(""=>__('Please Select'),"Chronic"=>__('Chronic'),'Existing'=>__('Existing'),'New On Set'=>__('New On Set'),'Recovered'=>__('Recovered'),'Acute'=>__('Acute'),'Inactive'=>__('Inactive')),'value'=>$getpatientfamilyhistory[0][FamilyHistory][statuss],'id' => 'Statussister')); ?>
						
						<td class="tdLabel" id="boxSpace"><?php echo $this->Form->input('Diagnosis.commentss', array('class' => 'textBoxExpnd','id' => 'Comments','value'=>$getpatientfamilyhistory[0][FamilyHistory][commentss])); ?>
						</td>
					</tr>
					<tr>
						<td width=20%><?php echo __('Son'); ?>
						</td>
						<td class="tdLabel" id="boxSpace"><?php  echo $this->Form->input('Diagnosis.problemson', array('class' =>'problemAutocomplete textBoxExpnd','id' =>'son','value'=>$getpatientfamilyhistory[0][FamilyHistory][problemson],'')); ?>
						</td>
						<td class="tdLabel" id="boxSpace"><?php echo $this->Form->input('Diagnosis.statusson',array('options'=>array(""=>__('Please Select'),"Chronic"=>__('Chronic'),'Existing'=>__('Existing'),'New On Set'=>__('New On Set'),'Recovered'=>__('Recovered'),'Acute'=>__('Acute'),'Inactive'=>__('Inactive')),'value'=>$getpatientfamilyhistory[0][FamilyHistory][statusson],'id' => 'Statusson')); ?>
						
						<td class="tdLabel" id="boxSpace"><?php echo $this->Form->input('Diagnosis.commentsson', array('class' => 'textBoxExpnd','id' => 'Comments','value'=>$getpatientfamilyhistory[0][FamilyHistory][commentsson])); ?>
						</td>
					</tr>
					<tr>
						<td width=20%><?php echo __('Daughter'); ?>
						</td>
						<td class="tdLabel" id="boxSpace"><?php  echo $this->Form->input('Diagnosis.problemd', array('class' =>'problemAutocomplete textBoxExpnd','id' =>'daughter','value'=>$getpatientfamilyhistory[0][FamilyHistory][problemd],'')); ?>
						</td>
						<td class="tdLabel" id="boxSpace"><?php echo $this->Form->input('Diagnosis.statusd',array('options'=>array(""=>__('Please Select'),"Chronic"=>__('Chronic'),'Existing'=>__('Existing'),'New On Set'=>__('New On Set'),'Recovered'=>__('Recovered'),'Acute'=>__('Acute'),'Inactive'=>__('Inactive')),'value'=>$getpatientfamilyhistory[0][FamilyHistory][statusd],'id' => 'Statusdaughter')); ?>
						
						<td class="tdLabel" id="boxSpace"><?php echo $this->Form->input('Diagnosis.commentsd', array('class' => 'textBoxExpnd','id' => 'Comments','value'=>$getpatientfamilyhistory[0][FamilyHistory][commentsd])); ?>
						</td>
					</tr>

				</table>
			</td>
		</tr>



		<?php 
		if(strtolower($sex)=='female')
		{

			?>

		<tr>
			<td width="19%" valign="top" class="tdLabel" id="boxSpace"
				style="padding-top: 10px;">Obstetric History</td>
			<td style="" width="100%">
				<table width="100%" border="0" cellspacing="1" cellpadding="0"
					class="tabularForm" class="tdLabel">
					<tr>
						<td width="25%" class="tdLabel"><?php echo __('Age Onset of Menses:'); ?>
						</td>
						<td width="60%" class="tdLabel" id="boxSpace"><?php echo $this->Form->input('Diagnosis.age_menses', array('class' => 'textBoxExpnd','id' =>'age_menses','value'=>$getpatient[0][PastMedicalRecord][age_menses],'style'=>'width:70px')); ?><font
							color="#FFFFFF">&nbsp;Years</font>
						</td>
					</tr>

					<tr>


						<td width="25%" class="tdLabel"><?php echo __('Length of Periods: '); ?>
						</td>
						<td width="60%" class="tdLabel" id="boxSpace"><?php echo $this->Form->input('Diagnosis.length_period', array('class' => 'textBoxExpnd','id' =>'length_period','value'=>$getpatient[0][PastMedicalRecord][length_period],'style'=>'width:70px')); ?><font
							color="#FFFFFF">&nbsp;Days</font>
						</td>
					</tr>

					<tr>
						<td width="25%" class="tdLabel"><?php echo __('Number of days between Periods: '); ?>
						</td>
						<td width="60%" class="tdLabel" id="boxSpace"><?php echo $this->Form->input('Diagnosis.days_betwn_period', array('class' => 'textBoxExpnd','id' =>'days_betwn_period','value'=>$getpatient[0][PastMedicalRecord][days_betwn_period],'style'=>'width:70px')); ?><font
							color="#FFFFFF">&nbsp;Days</font>
						</td>
					</tr>

					<tr>
						<td width="25%" class="tdLabel"><?php echo __('Any recent changes in Periods: '); ?>
						</td>
						<td width="60%" class="tdLabel" id="boxSpace"><?php  $option_Periods = array(''=>'Please Select','Yes'=>'Yes','No'=>'Not Currently');
						echo $this->Form->input('Diagnosis.recent_change_period', array( 'options'=>$option_Periods,'style'=>'width:150px','class' => '','id'=>"recent_change_period",'value'=>$getpatient[0][PastMedicalRecord][recent_change_period])); ?>
						</td>


					</tr>

					<tr>
						<td width="25%" class="tdLabel"><?php echo __('Age at Menopause: '); ?>
						</td>
						<td width="60%" class="tdLabel" id="boxSpace"><?php echo $this->Form->input('Diagnosis.age_menopause', array('class' => 'textBoxExpnd','id' =>'age_menopause','value'=>$getpatient[0][PastMedicalRecord][age_menopause],'style'=>'width:70px')); ?><font
							color="#FFFFFF">&nbsp;Years</font>
						</td>
					</tr>
				</table>
			</td>
		</tr>

		<tr>
			<td width="19%" valign="top" class="tdLabel" id="boxSpace"
				style="padding-top: 10px;"></td>
			<td width="100%" valign="top" class="tdLabel" id="boxSpace"
				style="padding-top: 10px;"><b>Number of Pregnancies:</b></td>
		</tr>

		<tr>
			<td width="19%" valign="top" class="tdLabel" id="boxSpace"
				style="padding-top: 10px;"></td>
			<td style="" width="100%">
				<table width="100%" border="0" cellspacing="1" cellpadding="0"
					class="tabularForm" class="tdLabel">
					<tr>
						<td colspan="7">
							<table width="100%" border="0" cellspacing="0" cellpadding="0"
								class="tabularForm" class="tdLabel">
								<tr>
									<td width="8%" height="20px" align="left" valign="top">Sr. No.</td>
									<td width="13%" height="20px" align="left" valign="top">DOB</td>
									<td width="8%" height="20px" align="left" valign="top">Weight
										(in lbs)</td>
									<td width="12%" height="20px" align="left" valign="top">Baby's
										Gender</td>
									<td width="9%" height="20px" align="left" valign="top">Weeks
										Pregnant</td>
									<td width="10%" height="20px" align="left" valign="top">Type of
										Delivery</td>
									<td width="10%" height="20px" align="left" valign="top">Complications</td>
									<td width="10%" height="20px" align="left" valign="top">Delete</td>
								</tr>
							</table>
						</td>
					</tr>

					<tr>
						<td colspan="7">
							<table width="100%" border="0" cellspacing="0" cellpadding="0"
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

									$counts_val = isset($pregnancyData[$i]['PregnancyCount']['counts'])?$pregnancyData[$i]['PregnancyCount']['counts']:'' ;
									$date_birth_val = isset($pregnancyData[$i]['PregnancyCount']['date_birth'])?$pregnancyData[$i]['PregnancyCount']['date_birth']:'' ;
									$weight_val = isset($pregnancyData[$i]['PregnancyCount']['weight'])?$pregnancyData[$i]['PregnancyCount']['weight']:'' ;
									$baby_gender_val = isset($pregnancyData[$i]['PregnancyCount']['baby_gender'])?$pregnancyData[$i]['PregnancyCount']['baby_gender']:'' ;
									$week_pregnant_val = isset($pregnancyData[$i]['PregnancyCount']['week_pregnant'])?$pregnancyData[$i]['PregnancyCount']['week_pregnant']:'' ;
									$type_delivery_val = isset($pregnancyData[$i]['PregnancyCount']['type_delivery'])?$pregnancyData[$i]['PregnancyCount']['type_delivery']:'' ;
									$complication_val = isset($pregnancyData[$i]['PregnancyCount']['complication'])?$pregnancyData[$i]['PregnancyCount']['complication']:'' ;
									?>

								<tr id="DrugGroup_nw<?php echo $i;?>">

									<td width="10%" height="20px" align="left" valign="top"><?php  echo $this->Form->input('', array('type'=>'text' ,'class' =>'textBoxExpnd','id'=>"counts$i",'value'=>$counts_val,'name'=>'pregnancy[counts][]',style=>'width:70px','counter_nw'=>$i)); ?>
									</td>

									<td width="12%" height="20px" align="left" valign="top"><?php echo $this->Form->input('', array('type'=>'text','id' => "date_birth$i",'class'=>'date_birth','name'=>'pregnancy[date_birth][]','value'=>$date_birth_val,'style'=>'width:130px','counter_nw'=>$i)); ?>
									</td>

									<td width="10%" height="20px" align="left" valign="top"><?php  echo $this->Form->input('', array('type'=>'text' ,'class' =>'textBoxExpnd','id'=>"weight$i",'value'=>$weight_val,'name'=>'pregnancy[weight][]',style=>'width:70px','counter_nw'=>$i)); ?>
									</td>

									<td width="10%" height="20px" align="left" valign="top"><?php  $options = array(''=>'Please Select','M'=>'Male','F'=>'Female');
									echo $this->Form->input('', array( 'options'=>$options,'style'=>'width:100px','class' => '','id'=>"baby_gender$i",'name' => 'pregnancy[baby_gender][]','value'=>$baby_gender_val)); ?>
									</td>

									<td width="10%" height="20px" align="left" valign="top"><?php  echo $this->Form->input('', array('type'=>'text' ,'class' =>'textBoxExpnd','id'=>"week_pregnant$i",'value'=>$week_pregnant_val,'name'=>'pregnancy[week_pregnant][]','style'=>'width:70px','counter_nw'=>$i)); ?>
									</td>

									<td width="10%" height="20px" align="left" valign="top"><?php  $delivery_options = array(''=>'Please Select','Episiotomy'=>'Vaginal Delivery-Episiotomy','Induced_labor'=>'Vaginal Delivery-Induced labor','Forceps_delivery'=>'Vaginal Delivery -Forceps delivery','Vacuum_extraction'=>'Vaginal Delivery-Vacuum extraction','Cesarean'=>'Cesarean section');
									echo $this->Form->input('', array('options'=>$delivery_options ,'class' =>'textBoxExpnd','id'=>"type_delivery$i",'value'=>$type_delivery_val,'name'=>'pregnancy[type_delivery][]','style'=>'width:130px','counter_nw'=>$i)); ?>
									</td>

									<td width="10%" height="20px" align="left" valign="top"><?php echo $this->Form->input('', array('type'=>'text' ,'class' =>'textBoxExpnd','id'=>"complication$i",'value'=>$complication_val,'name'=>'pregnancy[complication][]','style'=>'width:100px','counter_nw'=>$i)); ?>
									</td>
									<td width="20"><?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete','class'=>'DrugGroup_nw','id'=>"pregnancy$i"));?>
									</td>
								</tr>
								<?php
								$i++ ;
								}
								?>
							</table>
						</td>
					</tr>

					<tr>
						<td align="right" colspan="7"><input type="button"
							id="addButton_nw" value="Add"> <?php if($count_nw > 0)
							{?> <input type="button" id="removeButton_nw" value="Remove"> <?php }
							else{ ?> <input type="button" id="removeButton_nw" value="Remove"
							style="display: none;"> <?php } ?></td>
					</tr>

					<tr>
						<td width="25%" class="tdLabel"><?php echo __('Abortions. Still Births. Miscarriages: '); ?>
						</td>
						<td width="60%" colspan="6" class="tdLabel"><?php  echo $this->Form->input('Diagnosis.abortions_miscarriage', array('class' =>'textBoxExpnd','id' =>'abortions_miscarriage','value'=>$getpatient[0][PastMedicalRecord][abortions_miscarriage],'style'=>'width:250px')); ?>
						</td>
					</tr>

				</table>

			</td>
		</tr>



		<tr>
			<td width="19%" valign="top" class="tdLabel" id="boxSpace"
				style="padding-top: 10px;">Gynecology History</td>
			<td style="" width="100%">
				<table width="100%" border="0" cellspacing="1" cellpadding="0"
					class="tabularForm" class="tabularForm" id='DrugGroup'
					class="tdLabel">
					<tr>
						<td width="25%" class="tdLabel"><?php echo __('Present Symptoms:'); ?>
						</td>
						<td width="60%" class="tdLabel" id="boxSpace"><?php
						if($this->data['PastMedicalRecord']['present_symptom']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}

                        				echo $this->Form->radio('Diagnosis.present_symptom', array('None'=>'None','Yes'=>'Yes'),array('value'=>$getpatient[0]['PastMedicalRecord']['present_symptom'],'legend'=>false,'label'=>false));
                        			 ?>
						</td>
					</tr>

					<tr>
						<td width="25%" class="tdLabel"><?php echo __('Past Infections: '); ?>
						</td>
						<td width="60%" class="tdLabel" id="boxSpace"><?php
						if($this->data['PastMedicalRecord']['past_infection']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}

                        				echo $this->Form->radio('Diagnosis.past_infection', array('None'=>'None','Chlamydia'=>'Chlamydia','Syphilis'=>'Syphilis','PID'=>'PID','Gonorrhea'=>'Gonorrhea','Other STD'=>'Other STD'),array('value'=>$getpatient[0]['PastMedicalRecord']['past_infection'],'legend'=>false,'label'=>false));
                        			 ?>
						</td>
					</tr>

					<tr>
						<td width="25%" class="tdLabel ">History of abnormal <font
							class="tooltip" title="Papanicolaou smear">PAP smear</font>:
						</td>
						<td width="60%" class="tdLabel" id="boxSpace"><?php
						if($this->data['PastMedicalRecord']['hx_abnormal_pap']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}

                        				echo $this->Form->radio('Diagnosis.hx_abnormal_pap', array('None'=>'None','Yes'=>'Yes'),array('value'=>$getpatient[0]['PastMedicalRecord']['hx_abnormal_pap'],'legend'=>false,'label'=>false));
                        			 ?>
						</td>
					</tr>

					<tr>
						<td width="25%" class="tdLabel"><?php echo __('History of cervical biopsy: '); ?>
						</td>
						<td width="60%" class="tdLabel" id="boxSpace"><?php
						if($this->data['PastMedicalRecord']['hx_cervical_bx']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}

                        				echo $this->Form->radio('Diagnosis.hx_cervical_bx', array('None'=>'None','Yes'=>'Yes'),array('value'=>$getpatient[0]['PastMedicalRecord']['hx_cervical_bx'],'legend'=>false,'label'=>false));
                        			 ?>
						</td>
					</tr>

					<tr>
						<td width="25%" class="tdLabel"><?php echo __('History of fertility drugs: '); ?>
						</td>
						<td width="60%" class="tdLabel" id="boxSpace"><?php
						if($this->data['PastMedicalRecord']['hx_fertility_drug']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}

                        				echo $this->Form->radio('Diagnosis.hx_fertility_drug', array('None'=>'None','Yes'=>'Yes'),array('value'=>$getpatient[0]['PastMedicalRecord']['hx_fertility_drug'],'legend'=>false,'label'=>false));
                        			 ?>
						</td>
					</tr>

					<tr>
						<td width="25%" class="tdLabel">History of <font class="tooltip"
							title="Hormone Replacement Therapy "> HRT </font> use:
						</td>
						<td width="60%" class="tdLabel" id="boxSpace"><?php
						if($this->data['PastMedicalRecord']['hx_hrt_use']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}

                        				echo $this->Form->radio('Diagnosis.hx_hrt_use', array('None'=>'None','Yes'=>'Yes'),array('value'=>$getpatient[0]['PastMedicalRecord']['hx_hrt_use'],'legend'=>false,'label'=>false));
                        			 ?>
						</td>
					</tr>

					<tr>
						<td width="25%" class="tdLabel"><?php echo __('History of irregular menses: '); ?>
						</td>
						<td width="60%" class="tdLabel" id="boxSpace"><?php
						if($this->data['PastMedicalRecord']['hx_irregular_menses']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}

                        				echo $this->Form->radio('Diagnosis.hx_irregular_menses', array('None'=>'None','Yes'=>'Yes'),array('value'=>$getpatient[0]['PastMedicalRecord']['hx_irregular_menses'],'legend'=>false,'label'=>false));
                        			 ?>
						</td>
					</tr>

					<tr>
						<td width="25%" class="tdLabel"><font class="tooltip"
							title="Last Menstrual Period "> L.M.P. </font>:</td>
						<?php $getpatient[0]['PastMedicalRecord']['lmp'] = $this->DateFormat->formatDate2Local($getpatient[0]['PastMedicalRecord']['lmp'],Configure::read('date_format'),true); ?>
						<td width="60%" class="tdLabel" id="boxSpace"><?php echo $this->Form->input('Diagnosis.lmp', array('type'=>'text','id' =>'lmp','class'=>'textBoxExpnd','value'=>$getpatient[0]['PastMedicalRecord']['lmp'],'style'=>'width:120px')); ?>
						</td>
					</tr>

					<tr>
						<td width="25%" class="tdLabel">Symptoms since <font
							class="tooltip" title="Last Menstrual Period "> L.M.P. </font>:
						</td>
						<td width="60%" class="tdLabel" id="boxSpace"><?php
						if($this->data['PastMedicalRecord']['symptom_lmp']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}

                        				echo $this->Form->radio('Diagnosis.symptom_lmp', array('None'=>'None','Yes'=>'Yes'),array('value'=>$getpatient[0]['PastMedicalRecord']['symptom_lmp'],'legend'=>false,'label'=>false));
                        			 ?>
						</td>
					</tr>

				</table>
			</td>
		</tr>

		<tr>
			<td width="19%" valign="top" class="tdLabel" id="boxSpace"
				style="padding-top: 10px;"></td>
			<td width="100%" valign="top" class="tdLabel" id="boxSpace"
				style="padding-top: 10px;"><b>Sexual Activity:</b></td>
		</tr>

		<tr>
			<td width="19%" valign="top" class="tdLabel" id="boxSpace"
				style="padding-top: 10px;"></td>
			<td style="" width="100%">
				<table width="100%" border="0" cellspacing="1" cellpadding="0"
					class="tabularForm" id='DrugGroup' class="tdLabel">
					<tr>
						<td width="25%" class="tdLabel"><?php echo __('Are you sexually active?'); ?>
						</td>
						<td width="60%" class="tdLabel" id="boxSpace"><?php
						if($this->data['PastMedicalRecord']['sexually_active']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}

                        				echo $this->Form->radio('Diagnosis.sexually_active', array('No'=>'No','Yes'=>'Yes'),array('value'=>$getpatient[0]['PastMedicalRecord']['sexually_active'],'legend'=>false,'label'=>false));
                        			 ?>
						</td>
					</tr>


					<tr>
						<td width="25%" class="tdLabel"><?php echo __('Do you use birth control?'); ?>
						</td>
						<td width="60%" class="tdLabel" id="boxSpace"><?php
						if($this->data['PastMedicalRecord']['birth_controll']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}

                        				echo $this->Form->radio('Diagnosis.birth_controll', array('No'=>'No','Yes'=>'Yes','Condoms'=>'Condoms'),array('value'=>$getpatient[0]['PastMedicalRecord']['birth_controll'],'legend'=>false,'label'=>false));
                        			 ?>
						</td>
					</tr>

					<tr>
						<td width="25%" class="tdLabel"><?php echo __('Do you do regular Breast self-exam?'); ?>
						</td>
						<td width="60%" class="tdLabel" id="boxSpace"><?php
						if($this->data['PastMedicalRecord']['breast_self_exam']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}

                        				echo $this->Form->radio('Diagnosis.breast_self_exam', array('No'=>'No','Yes'=>'Yes'),array('value'=>$getpatient[0]['PastMedicalRecord']['breast_self_exam'],'legend'=>false,'label'=>false));
                        			 ?>
						</td>
					</tr>

					<tr>
						<td width="25%" class="tdLabel"><?php echo __('New Partners? '); ?>
						</td>
						<td width="60%" class="tdLabel" id="boxSpace"><?php
						if($this->data['PastMedicalRecord']['new_partner']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}

                        				echo $this->Form->radio('Diagnosis.new_partner', array('No'=>'No','Yes'=>'Yes'),array('value'=>$getpatient[0]['PastMedicalRecord']['new_partner'],'legend'=>false,'label'=>false));
                        			 ?>
						</td>
					</tr>

					<tr>
						<td width="25%" class="tdLabel"><?php echo __('Partner Notification '); ?>
						</td>

						<td width="60%" class="tdLabel" id="boxSpace"><?php 

						if($getpatient[0]['PastMedicalRecord']['partner_notification'] == 1){
								echo $this->Form->checkbox('Diagnosis.partner_notification', array('checked' => 'checked'));
							}else{
								echo $this->Form->checkbox('Diagnosis.partner_notification');
							}


							//echo $this->Form->checkbox('partner_notification',array('name'=>'1'));?>


						</td>
					</tr>

					<tr>
						<td width="25%" class="tdLabel"><font class="tooltip"
							title="Human Immunodeficiency Virus"> HIV </font> Education
							Given:</td>
						<td width="60%" class="tdLabel" id="boxSpace"><?php
						if($this->data['PastMedicalRecord']['hiv_education']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}

                        				echo $this->Form->radio('Diagnosis.hiv_education', array('No'=>'No','Referred'=>'Referred'),array('value'=>$getpatient[0]['PastMedicalRecord']['hiv_education'],'legend'=>false,'label'=>false));
                        			 ?>
						</td>
					</tr>


					<tr>
						<td width="25%" class="tdLabel"><font class="tooltip"
							title="Papanicolaou"> PAP </font>/<font class="tooltip"
							title="Sexually Transmitted Diseases"> STD </font> Education
							Given:</td>
						<td width="60%" class="tdLabel" id="boxSpace"><?php
						if($this->data['PastMedicalRecord']['pap_education']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}

                        				echo $this->Form->radio('Diagnosis.pap_education', array('No'=>'No','Referred'=>'Referred'),array('value'=>$getpatient[0]['PastMedicalRecord']['pap_education'],'legend'=>false,'label'=>false));
                        			 ?>
						</td>
					</tr>

					<tr>
						<td width="25%" class="tdLabel"><font class="tooltip"
							title="Gynecology"> GYN </font> Referral:</td>
						<td width="60%" class="tdLabel" id="boxSpace"><?php
						if($this->data['PastMedicalRecord']['gyn_referral']==1){
                        					$class = '';
                        				}else{
                        					$class  ='hidden';
                        				}

                        				echo $this->Form->radio('Diagnosis.gyn_referral', array('No'=>'No','Referred'=>'Referred'),array('value'=>$getpatient[0]['PastMedicalRecord']['gyn_referral'],'legend'=>false,'label'=>false));
                        			 ?>
						</td>
					</tr>

				</table>
			</td>

		</tr>

		<?php 
		}
		?>



		<tr>
			<td width="19%" valign="top" class="tdLabel" id="boxSpace"
				style="padding-top: 10px;">Social History</td>
			<td colspan="4" style="" width="100%">
				<table width="100%" border="0" cellspacing="1" cellpadding="0"
					class="tabularForm">
					<?php if($patient['Patient']['age']>=18){?>
					<tr>
						<td valign="top" width="120" colspan='5' style="color: fuchsia;"'>Have
							you screened for tobbaco use.</td>
					</tr>
					<?php }?>
					<tr>

						<td valign="top" width="120">Smoking<?php echo $this->Form->hidden('PatientPersonalHistory.id',array('type'=>'text'));?>
						</td>
						<td valign="top" width="120"><?php 

						if($this->data['PatientPersonalHistory']['smoking']==1){
			                        					$class = '';
			                        				}else{
			                        					$class  ='hidden';
			                        				}
			                        				//debug($this->data['PatientPersonalHistory']['smoking']);
			                        				$smokingPersonalVal = isset($this->data['PatientPersonalHistory']['smoking'])?$this->data['PatientPersonalHistory']['smoking']:2 ;
			                        				echo $this->Form->radio('PatientPersonalHistory.smoking', array('No','Yes'),array('value'=>$smokingPersonalVal,'legend'=>false,'label'=>false,'class' => 'personal1','id' => 'smoking'));

			                        			 ?></td>
						<td valign="top"><?php 	
						echo $this->Form->input('PatientPersonalHistory.smoking_desc',array('type'=>'text','legend'=>false,'label'=>false,
				                        			 	'class' => 'textBoxExpnd removeSince '.$class,'id' => 'smoking_desc'));
									 ?>
						</td>

						<td valign="top"><?php 
						echo $this->Form->input('PatientSmoking.patient_id',array('type'=>'hidden','value'=>$patient_id,'legend'=>false,'label'=>false,
												'class' => 'textBoxExpnd removeSince '.$class,'id' => ''));

										echo $this->Form->input('PatientSmoking.smoking_fre',array('type'=>'hidden','legend'=>false,'label'=>false,
												'class' => 'textBoxExpnd removeSince ','id' => ''));

										echo $this->Form->input('SmokingStatusOncs.description',array('type'=>'text','legend'=>false,'label'=>false,
				                        			 	'class' => 'textBoxExpnd removeSince '.$class,'id' => ''));//echo'to';

										echo $this->Form->input('PatientSmoking.current_smoking_fre',array('type'=>'hidden','legend'=>false,'label'=>false,
												'class' => 'textBoxExpnd removeSince ','id' => ''));
										echo $this->Form->input('SmokingStatusOncs1.description',array('type'=>'text','legend'=>false,'label'=>false,
												'class' => 'textBoxExpnd removeSince '.$class,'id' => ''));
										echo $this->Form->input('PatientSmoking.smoking_fre2',array('type'=>'hidden','legend'=>false,'label'=>false,
										'class' => 'textBoxExpnd removeSince ','id' => 'smoking_fre_id'));
				                        			 ?></td>
						<td valign="top"><?php 	

						echo $this->Form->input('PatientPersonalHistory.smoking_fre',array('type' => 'select', 'id' => 'smoking_fre', 'class' => 'removeSince', 'empty' => 'Please Select', 'options'=> $smokingOptions, 'label'=> false, 'div'=> false, 'style' => 'width:150px','onChange'=>'javascript:getSmokingDetails()'));
						?><span><label id="smoking_info"
								style="cursor: pointer; text-decoration: underline; display: none;"><?php echo __('Fill information');?>
							</label> </span>
						</td>
					</tr>
					<tr>
						<td valign="top">Alcohol</td>
						<td valign="top"><?php
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
				                        			 	'class' => 'textBoxExpnd removeSince '.$class,'id' => 'alcohol_desc'));
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
										echo $this->Form->input('PatientPersonalHistory.alcohol_fre',array('type' => 'select', 'id' => 'alcohol_fre', 'class' => 'removeSince', 'empty' => 'Please Select', 'options'=> $alcoholoption, 'label'=> false, 'div'=> false, 'style' => 'width:150px'));
										?><span><label id="alcohol_fill"
								style="cursor: pointer; text-decoration: underline; display: none;"><?php echo __('Fill information');?>
							</label> </span>
						</td>
					</tr>
					<tr>
						<td valign="top">Substance Use</td>
						<td valign="top"><?php 
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
						echo $this->Form->input('PatientPersonalHistory.drugs_desc',array('type'=>'text','legend'=>false,'label'=>false,
			                        			 		'class' => 'textBoxExpnd removeSince '.$class,'id' => 'drug_desc'));
			                        				?>
						</td>
						<td valign="top"><?php 
						echo $this->Form->input('PatientPersonalHistory.drugs_fre',array('legend'=>false,'label'=>false,'class' => 'textBoxExpnd removeSince '.$class,'id' => 'drug_fre'));
						?>
						</td>
						<td>&nbsp;</td>
					</tr>

					<tr>
						<td valign="top">Retired</td>
						<td valign="top"><?php 
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

					<tr>
						<td valign="top">Caffiene Usage</td>
						<td valign="top"><?php 
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
						echo $this->Form->input('PatientPersonalHistory.tobacco_desc',array('type'=>'text','legend'=>false,'label'=>false,'class' => 'textBoxExpnd removeSince '.$class,'id' => 'tobacco_desc'));
						?>
						</td>
						<td valign="top"><?php	
						echo $this->Form->input('PatientPersonalHistory.tobacco_fre',array('type'=>'text','legend'=>false,'label'=>false,'class' => 'textBoxExpnd removeSince '.$class,'id' => 'tobacco_fre'));
						?>
						</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td valign="top">Diet</td>
						<td valign="top" colspan="3"><?php 
						if($this->data['PatientPersonalHistory']['diet']==1){
			                        					$class = '';
			                        				}else{
			                        					$class  ='hidden';
			                        				}
			                        				$dietPersonalVal = isset($this->data['PatientPersonalHistory']['diet'])?$this->data['PatientPersonalHistory']['diet']:2 ;
			                        				echo $this->Form->radio('PatientPersonalHistory.diet', array('Veg','Non-Veg'),array('value'=>$dietPersonalVal,'legend'=>false,'label'=>false,'class' => 'personal','id' => 'diet'));
			                        			 ?>
						</td>

						<td>&nbsp;</td>
					</tr>
				</table>
			</td>
			<td width="30">&nbsp;</td>
			<td width="19%" valign="top" class="tdLabel" id="boxSpace"
				style="padding-top: 10px;">&nbsp;</td>
			<td width="" valign="top">&nbsp;</td>
		</tr>

		<tr>
			<td width="19%" valign="top" class="tdLabel" id="boxSpace"
				style="padding-top: 10px;">Surgical / Hospitalization History</td>
			<td style="" width="100%">
				<table width="100%" border="0" cellspacing="1" cellpadding="0"
					class="tabularForm" class="tdLabel">
					<tr>
						<td colspan="7">
							<table width="100%" border="0" cellspacing="0" cellpadding="0"
								class="tabularForm" class="tdLabel">
								<tr>
									<td width="10%" height="20px" align="left" valign="top">Surgical/Hospitalization</td>
									<td width="12%" height="20px" align="left" valign="top"
										style="padding-left: 30px">Provider</td>
									<td width="5%" height="20px" align="left" valign="top"
										style="padding-left:0px">Age</td>
									<td width="10%" height="20px" align="left" valign="top">Date</td>
									<td width="15%" height="20px" align="left" valign="top">Comment</td>
									
								</tr>
							</table>
						</td>
					</tr>

					<tr>
						<td colspan="7">
							<table width="100%" border="0" cellspacing="0" cellpadding="0"
								class="tabularForm" id='DrugGroup_procedure' class="tdLabel">
								<?php  
								if(isset($procedureHistory) && !empty($procedureHistory))
								{
									$count_procedure  = count($procedureHistory);
								}else
								{
									$count_procedure  = 3 ;
								}
								for($i=0;$i<$count_procedure;)
								{

									$procedureHistory[$i]['ProcedureHistory']['procedure_date'] = $this->DateFormat->formatDate2Local($procedureHistory[$i]['ProcedureHistory']['procedure_date'],Configure::read('date_format'),true);
									$procedure_name = !empty($procedureHistory[$i]['TariffList']['name'])?$procedureHistory[$i]['TariffList']['name']:$procedureHistory[$i]['ProcedureHistory']['procedure_name'] ;
									$provider_name = !empty($procedureHistory[$i]['DoctorProfile']['doctor_name'])?$procedureHistory[$i]['DoctorProfile']['doctor_name']:$procedureHistory[$i]['ProcedureHistory']['provider_name'] ;
									$procedure_val = !empty($procedureHistory[$i]['TariffList']['id'])?$procedureHistory[$i]['TariffList']['id']:'' ;
									$provider_val = !empty($procedureHistory[$i]['DoctorProfile']['id'])?$procedureHistory[$i]['DoctorProfile']['id']:'' ;
									$age_value_val = isset($procedureHistory[$i]['ProcedureHistory']['age_value'])?$procedureHistory[$i]['ProcedureHistory']['age_value']:'' ;
									$age_unit_val = isset($procedureHistory[$i]['ProcedureHistory']['age_unit'])?$procedureHistory[$i]['ProcedureHistory']['age_unit']:'' ;
									$procedure_date_val = isset($procedureHistory[$i]['ProcedureHistory']['procedure_date'])?$procedureHistory[$i]['ProcedureHistory']['procedure_date']:'' ;
									$comment_val = isset($procedureHistory[$i]['ProcedureHistory']['comment'])?$procedureHistory[$i]['ProcedureHistory']['comment']:'' ;


									?>

								<tr id="DrugGroup_procedure<?php echo $i;?>">

									<td width="10%" height="20px" align="left" valign="top"><?php  echo $this->Form->input("ProcedureHistory.procedure", array('type'=>'text' ,'class' => "textBoxExpnd procedure",'id'=>"procedureDisplay_$i",'value'=>$procedure_name,'name'=>'ProcedureHistory[procedure_name][]',style=>'width:150px','counter_procedure'=>$i)); ?>
									</td>
									<?php echo $this->Form->hidden("ProcedureHistory.procedure", array('name'=>'ProcedureHistory[procedure][]','type'=>'text','id'=>"procedure_$i",'counter_procedure'=>$i,'value'=>$procedure_val)); ?>

									<td width="12%" height="20px" align="left" valign="top"><?php echo $this->Form->input("ProcedureHistory.provider_name", array('type'=>'text','class' =>'textBoxExpnd providercls','name'=>'ProcedureHistory[provider_name][]','id' => "providerDisplay_$i",'value'=>$provider_name,'style'=>'width:150px','counter_procedure'=>$i)); ?>
										<?php echo $this->Form->hidden("ProcedureHistory.provider.$i", array('name'=>'ProcedureHistory[provider][]','type'=>'text','id'=>"provider_$i",'counter_procedure'=>$i,'value'=>$provider_val)); ?>
									</td>

									<td width="10%" height="20px" align="left" valign="top"><?php  echo $this->Form->input('', array('type'=>'text' ,'class' =>'validate[optional,custom[onlyNumber]] textBoxExpnd','id'=>"age_value$i",'value'=>$age_value_val,'name'=>'ProcedureHistory[age_value][]','style'=>'width:50px','counter_procedure'=>$i)); ?>
									</td>

									<td width="10%" height="20px" align="left" valign="top"><?php  $options = array(''=>'Please Select','Days'=>'Days','Months'=>'Months','Years'=>'Years');
									echo $this->Form->input('', array( 'options'=>$options,'class' => '','id'=>"age_unit$i",'name' => 'ProcedureHistory[age_unit][]','value'=>$age_unit_val)); ?>
									</td>

									<td width="15%" height="20px" align="left" valign="top"><?php  echo $this->Form->input('', array('type'=>'text','id'=>"procedure_date$i",'class'=>"create_time procedure_date textBoxExpnd",'name'=>'ProcedureHistory[procedure_date][]','value'=>$procedure_date_val,'style'=>'width:110px','counter_procedure'=>$i)); ?>
									</td>

									<td width="10%" height="20px" align="left" valign="top"><?php echo $this->Form->input('', array('type'=>'text' ,'class' =>'textBoxExpnd','id'=>"comment$i",'value'=>$comment_val,'name'=>'ProcedureHistory[comment][]','style'=>'width:220px','counter_procedure'=>$i)); ?>
									</td>
									<td width="20"><?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete','class'=>'DrugGroup_procedure','id'=>"surgery$i"));?>
									</td>
								</tr>
								<?php
								$i++ ;
								}
								?>
							</table>
						</td>
					</tr>

					<tr>
						<td align="right" colspan="7"><input type="button"
							id="addButton_procedure" value="Add"> <?php if($count_procedure > 0)
							{?> <input type="button" id="removeButton_procedure"
							value="Remove"> <?php }
							else{ ?> <input type="button" id="removeButton_procedure"
							value="Remove" style="display: none;"> <?php } ?>
						</td>
					</tr>

				</table>

			</td>
		</tr>

	</table>
</div>

<div class="btns">
	<?php echo $this->Form->submit(__('Submit'), array('class'=>'blueBtn','div'=>false,'id'=>'submit_diagno')); ?>
	<?php  echo $this->Html->link(__('Cancel'),array('controller'=>'Patients','action'=>'patient_information',$patient['Patient']['id']),array('class'=>'blueBtn','div'=>false)); ?>
</div>
<?php echo $this->Form->end();?>
<script>
	function icdwin1(id) {
		   var identify ="";
		   
			
			identify = id;
			$.fancybox({

						'width' : '70%',
						'height' : '120%',
						'autoScale' : true,
						'transitionIn' : 'fade',
						'transitionOut' : 'fade',
						'type' : 'iframe',
						'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "familyproblem")); ?>" + "/" + identify,
								
					});
	   }

	var counter_history = <?php echo $count_history?>
	 
    $("#addButton_history").click(function () {		 				 
		
		$("#diagnosisfrm").validationEngine('detach'); 
		var newCostDiv_history = $(document.createElement('tr'))
		     .attr("id", 'DrugGroup_history' + counter_history);

		var illness = '<td width="230px" height="20px" align="left" valign="top"><input type="text" value="" id="illness'+counter_history+'" class="problemAutocomplete" style=>"width:70px" name="PastMedicalHistory[illness][]"></td>';
		var status = '<select style="width:150px" id="status'+counter_history+'" class="" name="PastMedicalHistory[status][]"><option value="">Please Select</option><option value="Chronic">Chronic</option><option value="Existing">Existing</option><option value="New_on_set">New On Set</option><option value="Recovered">Recovered</option><option value="Acute">Acute</option><option value="Inactive">Inactive</option></select>';
		var duration = '<td width="230px" height="20px" align="left" valign="top"><input type="text" value="" id="duration'+counter_history+'" class="" style=>"width:70px" name="PastMedicalHistory[duration][]"></td>';
		var comment = '<td width="230px" height="20px" align="left" valign="top"><input type="text" value="" id="comment'+counter_history+'" class="" style=>"width:120px" name="PastMedicalHistory[comment][]"></td>';
		'</tr></table></td>';
		
		var newHTml_history = '<td><input class="problemAutocomplete" type="text" style="width:230px" value="" name="PastMedicalHistory[illness][]" id="illness' + counter_history + '" autocomplete="off" counter_history='+counter_history+'></td><td style="padding-left:15px">'+status+'</td><td style="padding-left:15px"><input  type="text" style="width:230px" value="" name="PastMedicalHistory[duration][]" id="duration' + counter_history + '"  autocomplete="off" counter_history='+counter_history+'></td><td style="padding-left:15px"><input  type="text" style="width:230px" value="" name="PastMedicalHistory[comment][]" id="comment' + counter_history + '"  autocomplete="off" counter_history='+counter_history+'></td><td width="20"><span class="DrugGroup_history" id=pMH'+counter_history+'><?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete'));?></td>';
		
		newCostDiv_history.append(newHTml_history);		 
		newCostDiv_history.appendTo("#DrugGroup_history");		
		$("#diagnosisfrm").validationEngine('attach'); 			 			 
		counter_history++;
		if(counter_history > 0) $('#removeButton_history').show('slow');
     });

    $("#removeButton_history").click(function () {
		 
		counter_history--;			 
 
        $("#DrugGroup_history" + counter_history).remove();
 		if(counter_history == 0) $('#removeButton_history').hide('slow');
  });

    $('.DrugGroup_history').live('click',function (){
    	  if(confirm("Do you really want to delete this record?")){
        var trId = $(this).attr('id').replace("pMH","DrugGroup_history");
    	 $('#' + trId).remove();
    	 counter_history--;			 
    	 if(counter_history == 0) $('#removeButton_history').hide('slow');
    	  }else{
			return false;
        	  }
        });

    var counter_procedure = <?php echo $count_procedure?>;
	
    $("#addButton_procedure").click(function () {		 				 
		
		$("#diagnosisfrm").validationEngine('detach'); 
		var newCostDiv_procedure = $(document.createElement('tr'))
		     .attr("id", 'DrugGroup_procedure' + counter_procedure);
		  
		var procedure = '<td width="10%" height="20px" align="left" valign="top"><input type="text" value="" id="procedure'+counter_procedure+'" class ="procedure" style=>"width:150px" name="ProcedureHistory[procedure][]"></td>';
		var provider = '<td width="10%" height="20px" align="left" valign="top"><input type="text" value="" id="provider'+counter_procedure+'" class="provider" style=>"width:150px" name="ProcedureHistory[provider][]"></td>';
		var age_value = '<td width="10%" height="20px" align="left" valign="top"><input type="text" value="" id="age_value'+counter_procedure+'" class="" style=>"width:50px" name="ProcedureHistory[age_value][]"></td>';
		var age_unit = '<select style="width:120px;" id="age_unit'+counter_procedure+'" class="" name="ProcedureHistory[age_unit][]"><option value="">Please Select</option><option value="Days">Days</option><option value="Months">Months</option><option value="Years">Years</option></select>';
		var create_time = '<td width="20%" height="20px" align="left" valign="top"><input type="text" value="" id="create_time'+counter_procedure+'" class="create_time " style=>"width:110px" name="ProcedureHistory[create_time][]"></td>';
		var comment = '<td width="10%" height="20px" align="left" valign="top"><input type="text" value="" id="comment'+counter_procedure+'" class="" style=>"width:220px" name="ProcedureHistory[comment][]"></td>';
		'</tr></table></td>';
		
		var newHTml_procedure = '<td><input  type="text" style="width:150px" value="" name="ProcedureHistory[procedure_name][]" id="procedureDisplay_' + counter_procedure + '" class="procedure" autocomplete="off" counter_procedure='+counter_procedure+'><input id="procedure_' + counter_procedure + '" type="hidden" counter_procedure=' + counter_procedure + ' name="ProcedureHistory[procedure][]"></td><td><input  type="text" style="width:150px" value="" name="ProcedureHistory[provider_name][]" id="providerDisplay_' + counter_procedure + '" class="providercls" autocomplete="off" counter_procedure='+counter_procedure+'><input  type="hidden" style="width:150px" value="" name="ProcedureHistory[provider][]" id="provider_' + counter_procedure + '" autocomplete="off" counter_procedure='+counter_procedure+'></td><td><input  type="text" style="width:50px" value="" name="ProcedureHistory[age_value][]" id="age_value' + counter_procedure + '" autocomplete="off" counter_procedure='+counter_procedure+'></td><td>'+age_unit+'</td><td><input  type="text" style="width:110px" class="create_time" name="ProcedureHistory[create_time][]" value="" id="create_time' + counter_procedure + '"  counter_procedure='+counter_procedure+'></td><td><input  type="text" style="width:220px" value="" name="ProcedureHistory[comment][]" id="comment' + counter_procedure + '" autocomplete="off" counter_procedure='+counter_procedure+'></td><td width="20"><span class="DrugGroup_procedure" id=surgery'+counter_history+'><?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete'));?></td>';
		
		newCostDiv_procedure.append(newHTml_procedure);		 
		newCostDiv_procedure.appendTo("#DrugGroup_procedure");		
		$("#diagnosisfrm").validationEngine('attach'); 			 			 
		counter_procedure++;
		if(counter_procedure > 0) $('#removeButton_procedure').show('slow');
     });
 
     $("#removeButton_procedure").click(function () {
			counter_procedure--; 
	 
	        $("#DrugGroup_procedure" + counter_procedure).remove();
	 		if(counter_procedure == 0) $('#removeButton_procedure').hide('slow');
	  });

     $('.DrugGroup_procedure').live('click',function (){
        if(confirm("Do you really want to delete this record?")){
        	var surgTrId = $(this).attr('id').replace("surgery","DrugGroup_procedure");
        	counter_procedure--;
			$('#' + surgTrId).remove();
     		if(counter_procedure == 0) $('#removeButton_procedure').hide('slow');
         }else{
             return false;
         }
       
         });
     
     //add1 n remove1 drud inputs
	 var counter_nw = <?php echo $count_nw?>
 
    $("#addButton_nw").click(function () {		 				 
		
		$("#diagnosisfrm").validationEngine('detach'); 
		var newCostDiv_nw = $(document.createElement('tr'))
		     .attr("id", 'DrugGroup_nw' + counter_nw);
		  
		//var route_option = '<select id="mode'+counter1+'" style="width:80px" class="" name="mode[]"><option value="">Select</option><option value="IV">IV</option><option value="IM">IM</option><option value="S/C">S/C</option><option value="P.O">P.O</option><option value="P.R">P.R</option><option value="P/V">P/V</option><option value="R.T">R.T</option><option value="LA">LA</option></select>';
		//var fre_option = '<select id="tabs_frequency_'+counter+'"  class="frequency" name="tabs_frequency[]"><option value="">Select</option><option value="SOS">SOS</option><option value="OD">OD</option><option value="BD">BD</option><option value="TDS">TDS</option><option value="QID">QID</option><option value="HS">HS</option><option value="Twice a week">Twice a week</option><option value="Once a week">Once a week</option><option value="Once fort nightly">Once fort nightly</option><option value="Once a month">Once a month</option><option value="A/D">A/D</option></select>';
		var counts = '<td width="10%" height="20px" align="left" valign="top"><input type="text" value="" id="counts'+counter_nw+'" class="" style=>"width:70px" name="pregnancy[counts][]"></td>';
		var date_birth = '<td width="20%" height="20px" align="left" valign="top"><input type="text" value="" id="date_birth'+counter_nw+'" class="" style=>"width:120px" name="pregnancy[date_birth][]"></td>';
		var weight = '<td width="10%" height="20px" align="left" valign="top"><input type="text" value="" id="weight'+counter_nw+'" class="" style=>"width:70px" name="pregnancy[weight][]"></td>';
		var baby_gender = '<select style="width:100px;" id="baby_gender'+counter_nw+'" class="" name="pregnancy[baby_gender][]"><option value="">Please Select</option><option value="M">Male</option><option value="F">Female</option></select>';
		var week_pregnant = '<td width="10%" height="20px" align="left" valign="top"><input type="text" value="" id="week_pregnant'+counter_nw+'" class="" style=>"width:70px" name="pregnancy[week_pregnant][]"></td>';
		var type_delivery = '<select style="width:130px;" id="type_delivery'+counter_nw+'" class="" name="pregnancy[type_delivery][]"><option value="">Please Select</option><option value="Episiotomy">Vaginal Delivery-Episiotomy</option><option value="Induced_labor">Vaginal Delivery-Induced labor</option><option value="Forceps_delivery">Vaginal Delivery-Forceps delivery</option><option value="Vacuum_extraction">Vaginal Delivery-Vacuum extraction</option><option value="Cesarean">Cesarean section</option></select>';
		var complication = '<td width="10%" height="20px" align="left" valign="top"><input type="text" value="" id="complication'+counter_nw+'" class="" style=>"width:100px" name="pregnancy[complication][]"></td>';
		'</tr></table></td>';
		
		var newHTml_nw = '<td><input  type="text" style="width:70px" value="" name="pregnancy[counts][]" id="counts' + counter_nw + '" autocomplete="off" counter_nw='+counter_nw+'></td><td><input  type="text" style="width:130px" class="date_birth" name="pregnancy[date_birth][]" value="" id="date_birth' + counter_nw + '"  counter_nw='+counter_nw+'></td><td><input  type="text" style="width:70px" value="" name="pregnancy[weight][]" id="weight' + counter_nw + '"  autocomplete="off" counter_nw='+counter_nw+'></td><td>'+baby_gender+'</td><td><input  type="text" style="width:70px" value="" name="pregnancy[week_pregnant][]" id="week_pregnant' + counter_nw + '" autocomplete="off" counter_nw='+counter_nw+'></td><td>'+type_delivery+'</td><td><input  type="text" style="width:100px" value="" name="pregnancy[complication][]" id="complication' + counter_nw + '" autocomplete="off" counter_nw='+counter_nw+'></td><td width="20"><span class="DrugGroup_nw" id=pregnancy'+counter_nw+'><?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete'));?></td>';
		
		newCostDiv_nw.append(newHTml_nw);		 
		newCostDiv_nw.appendTo("#DrugGroup_nw");		
		$("#diagnosisfrm").validationEngine('attach'); 			 			 
		counter_nw++;
		if(counter_nw > 0) $('#removeButton_nw').show('slow');
     });
 
     $("#removeButton_nw").click(function () {
					 
			counter_nw--;			 
	 
	        $("#DrugGroup_nw" + counter_nw).remove();
	 		if(counter_nw == 0) $('#removeButton_nw').hide('slow');
	  });

     $('.DrugGroup_nw').live('click',function (){
         if(confirm("Do you really want to delete this record?")){
         var pregTrId = $(this).attr('id').replace("pregnancy","DrugGroup_nw");
     	 $('#' + pregTrId).remove();
     		counter_nw--;			 
     	 if(counter_nw == 0) $('#removeButton_nw').hide('slow');
         }else{
             return false;
         }
       
         });
     
     $('.personal:radio').click(function(){
		 var textName = $(this).attr('id').substr(0,($(this).attr('id').length)-1) ;				 
		 var lowercase = textName.toLowerCase();
		
		if($(this).val() =='1'){
			$('#'+lowercase+'_desc').fadeIn('slow');	
			$('#'+lowercase+'_desc').val('Since');			 
			$('#'+lowercase+'_fre').fadeIn('slow');	
			$('#'+lowercase+'_info').fadeIn('slow');
			$('#'+lowercase+'_fill').fadeIn('slow');	
			$('#'+lowercase+'_smoke_fill').fadeIn('slow');
			$('#'+lowercase+'_alco_info').fadeIn('slow');
			$('#'+lowercase+'_fre').val('Frequency');
		}else{
			$('#'+lowercase+'_desc').fadeOut('slow');
			$('#'+lowercase+'_info').fadeOut('slow');
			$('#'+lowercase+'_fill').fadeOut('slow');
			$('#'+lowercase+'_fre').fadeOut('slow');
			$('#'+lowercase+'_smoke_fill').fadeOut('slow');
			$('#'+lowercase+'_alco_info').fadeOut('slow');
			$('#'+lowercase+'_fre_id').fadeOut('slow');
		}
	});

     $('#alcohol_fill').click(function (){
			$.fancybox({
				'width' : '70%',
				'height' : '100%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "alcohal_assesment",$patient['Patient']['id'])); ?>"
		});
	});

     $('.provider').live('focus',function()
			  {  
  $(this).autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","DoctorProfile","user_id",'doctor_name','null','null','null','name',"admin" => false,"plugin"=>false)); ?>", {
		width: 250,
		showNoId:true,
		selectFirst: true
		});
	});

     $('.procedure').live('focus',function()
			  { 
    	 $(this).autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","TariffList","id",'name','service_category_id='.Configure::read('servicecategoryid'),"admin" => false,"plugin"=>false)); ?>", {
				width: 250, 
				showNoId:true,
				delay:2000,
				valueSelected:true,
				selectFirst: true,
				loadId : $(this).attr('id')+','+$(this).attr('id').replace("Display_","_")
			}); 
		 /*$(this).autocomplete("<?php echo $this->Html->url(array("controller" => "Tariffs", "action" => "getServiceByCategory","admin" => false,"plugin"=>false)); ?>", {
		width: 250,
		showNoId:true,
		delay:2000,
		 extraParams: {
			 Surgery: function() { return 'Surgery'; },
		         },
		
		selectFirst: true
	});*/
			  });

     $(".create_time, .date_birth").live("click",function() {
			
			$(this).datepicker({
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
					dateFormat:'<?php echo $this->General->GeneralDate();?>',
					onSelect : function() {
						$(this).focus();
						//foramtEnddate(); //is not defined hence commented
					}

				});
	</script>
<script>
$(document).ready(function(){
	 $('.problemAutocomplete').live('focus',function(){ 
		$(this).autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","SnomedMappingMaster","sctName",'null','null','null','null','null',"admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true,
			minLength: 3
		});
	});
	 $('.providercls').live('focus',function() { // 
  		 $(this).autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","DoctorProfile","id",'doctor_name','null',"admin" => false,"plugin"=>false)); ?>", {
			width: 250, 
			showNoId:true,
			delay:2000,
			valueSelected:true,
			selectFirst: true,
			loadId : $(this).attr('id')+','+$(this).attr('id').replace("Display_","_")
		});
	});
});
</script>
