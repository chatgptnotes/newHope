<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#patientsurveyfrm").validationEngine();
	});
	
</script>
<?php echo $this->element('patient_information');?>
<div class="inner_title">
	<h3>
		<?php echo __('IPD Patient Satisfaction Survey', true); ?>
	</h3>
</div>
<?php 
if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"
	align="center">
	<tr>
		<td colspan="2" align="left" class="error"><?php 
		foreach($errors as $errorsval){
		         		echo $errorsval[0];
		         		echo "<br />";
		     		}
		     		?>
		</td>
	</tr>
</table>
<?php } ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0"
	class="formFull">
	<tr>
		<th colspan="3" style="text-transform: uppercase;"><?php echo __("IPD Patient's Information", true); ?>
		</th>
	</tr>
	<tr>
		<td width="49%" align="left" valign="top" style="padding-top: 7px;">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="100" height="25" valign="top" class="tdLabel1"
						id="boxSpace1"><?php echo __("Name", true); ?></td>
					<td align="left" valign="top"><?php
					echo $patient['Patient']['lookup_name'];
					?>
					</td>
				</tr>
				<tr>
					<td valign="top" class="tdLabel1" id="boxSpace1"><?php echo __("Address", true); ?>
					</td>
					<td align="left" valign="top" style="padding-bottom: 10px;"><?php

					echo $address ;
					?>
					</td>
				</tr>
			</table>
		</td>
		<td width="" align="left" valign="top">&nbsp;</td>
		<td width="49%" align="left" valign="top" style="padding-top: 7px;">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="140" height="25" valign="top" class="tdLabel1"
						id="boxSpace1"><?php echo __("Visit ID", true); ?></td>
					<td align="left" valign="top"><?php
					echo $patient['Patient']['admission_id'];
					?>
					</td>
				</tr>
				<tr>
					<td width="140" height="25" valign="top" class="tdLabel1"
						id="boxSpace1"><?php echo __("Patient ID", true); ?></td>
					<td align="left" valign="top"><?php
					echo $patientUID  ;
					?>
					</td>
				</tr>
				<tr>
					<td height="25" valign="top" class="tdLabel1" id="boxSpace1"><?php echo __("Sex", true); ?>
					</td>
					<td align="left" valign="top"><?php
					echo ucfirst($patient['Patient']['sex']);
					?>
					</td>
				</tr>
				<tr>
					<td height="25" valign="top" class="tdLabel1" id="boxSpace1"><?php echo __("Age", true); ?>
					</td>
					<td align="left" valign="top"><?php
					echo $age;
					?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<!-- two column table end here -->
<form name="patientsurveyfrm" id="patientsurveyfrm"
	action="<?php echo $this->Html->url(array("controller" => "surveys", "action" => "patientSurveySave", "admin" => false)); ?>"
	method="post">
	<?php 
	echo $this->Form->input('PatientSurvey.patient_id', array('type' => 'hidden', 'value' => $patient['Patient']['id']));
	echo $this->Form->input('PatientSurvey.patient_type', array('type' => 'hidden', 'value' => 'IPD'));
	?>
	<div>&nbsp;</div>
	<div class="clr ht5"></div>

	<table width="100%" cellpadding="0" cellspacing="1" border="0"
		class="tabularForm">
		<tr>
			<th><?php echo __('Sr.No.', true); ?></th>
			<th><?php echo __('Questions', true); ?></th>
			<th><?php echo __('Answers', true); ?></th>
		</tr>
		<tr>
			<td>1.</td>
			<td>I was attended by doctor within 5 minutes of my arrival in the
				hospital?</td>
			<td><?php $options = array('Strongly Agree' => 'Strongly Agree', 'Agree' => 'Agree', 'Neither Agree Nor  Disagree' => 'Neither Agree Nor  Disagree.', 'Disagree' => 'Disagree','Strongly Disagree' => 'Strongly Disagree');
			if(count($this->data) > 0) {
                                  echo $this->data['PatientSurvey']['question_id'][1];
                                } else {
                                 echo $this->Form->input('PatientSurvey.question_id.1', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
                                }
                                ?>
			</td>
		</tr>
		<tr>
			<td>2.</td>
			<td>Reception staff was polite,helpful and friendly with me?</td>
			<td><?php 
			if(count($this->data) > 0) {
                                  echo $this->data['PatientSurvey']['question_id'][2];
                                } else {
                               echo $this->Form->input('PatientSurvey.question_id.2', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
                                }
                                ?>
			</td>
		</tr>
		<tr>
			<td>3.</td>
			<td>Staff clearly explained to me the charges, estimates and biling
				procedures?</td>
			<td><?php 
			if(count($this->data) > 0) {
                                  echo $this->data['PatientSurvey']['question_id'][3];
                                } else {
                               echo $this->Form->input('PatientSurvey.question_id.3', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
                                }
                                ?>
			</td>
		</tr>
		<tr>
			<td>4.</td>
			<td>All my queries were answered patiently by the staff at the desk?</td>
			<td><?php 
			if(count($this->data) > 0) {
                                  echo $this->data['PatientSurvey']['question_id'][4];
                                } else {
                               echo $this->Form->input('PatientSurvey.question_id.4', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
                               }
                               ?>
			</td>
		</tr>
		<tr>
			<td>5.</td>
			<td>I had to wait for less than 15 minutes to get a room allocated?</td>
			<td><?php 
			if(count($this->data) > 0) {
                                  echo $this->data['PatientSurvey']['question_id'][5];
                                } else {
                               echo $this->Form->input('PatientSurvey.question_id.5', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
                               }
                               ?>
			</td>
		</tr>
		<tr>
			<td>6.</td>
			<td>I got the room of my choice at the time of admission?</td>
			<td><?php 
			if(count($this->data) > 0) {
                                  echo $this->data['PatientSurvey']['question_id'][6];
                                } else {
                               echo $this->Form->input('PatientSurvey.question_id.6', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
                               }
                               ?>
			</td>
		</tr>
		<tr>
			<td>7.</td>
			<td>The room was ready and clean before I enterd my room?</td>
			<td><?php 
			if(count($this->data) > 0) {
                                  echo $this->data['PatientSurvey']['question_id'][7];
                                } else {
                               echo $this->Form->input('PatientSurvey.question_id.7', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
                               }
                               ?>
			</td>
		</tr>
		<tr>
			<td>8.</td>
			<td>I was explained about the facilities in the room by the nurse?</td>
			<td><?php 
			if(count($this->data) > 0) {
                                  echo $this->data['PatientSurvey']['question_id'][8];
                                } else {
                               echo $this->Form->input('PatientSurvey.question_id.8', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
                               }
                               ?>
			</td>
		</tr>
		<tr>
			<td>9.</td>
			<td>I was seen by a doctor within 15 minutes of my arrival in my
				room?</td>
			<td><?php 
			if(count($this->data) > 0) {
                                  echo $this->data['PatientSurvey']['question_id'][9];
                                } else {
                               echo $this->Form->input('PatientSurvey.question_id.9', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
                               }
                               ?>
			</td>
		</tr>
		<tr>
			<td>10.</td>
			<td>All the doubts/queries were answered patiently by the doctor?</td>
			<td><?php 
			if(count($this->data) > 0) {
                                  echo $this->data['PatientSurvey']['question_id'][10];
                                } else {
                               echo $this->Form->input('PatientSurvey.question_id.10', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
                               }
                               ?>
			</td>
		</tr>
		<tr>
			<td>11.</td>
			<td>The doctor explained to me the details of my procedure/diagnosis?</td>
			<td><?php 
			if(count($this->data) > 0) {
                                  echo $this->data['PatientSurvey']['question_id'][11];
                                } else {
                               echo $this->Form->input('PatientSurvey.question_id.11', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
                               }
                               ?>
			</td>
		</tr>
		<tr>
			<td>12.</td>
			<td>I was seen by a doctor regularly during my stay?</td>
			<td><?php 
			if(count($this->data) > 0) {
                                  echo $this->data['PatientSurvey']['question_id'][12];
                                } else {
                               echo $this->Form->input('PatientSurvey.question_id.12', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
                               }
                               ?>
			</td>
		</tr>
		<tr>
			<td>13.</td>
			<td>I was attended by a nurse within 15 minutes of my arrival in the
				room?</td>
			<td><?php 
			if(count($this->data) > 0) {
                                  echo $this->data['PatientSurvey']['question_id'][13];
                                } else {
                               echo $this->Form->input('PatientSurvey.question_id.13', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
                               }
                               ?>
			</td>
		</tr>
		<tr>
			<td>14.</td>
			<td>I was given the medicine on the time by the nurse?</td>
			<td><?php 
			if(count($this->data) > 0) {
                                  echo $this->data['PatientSurvey']['question_id'][14];
                                } else {
                               echo $this->Form->input('PatientSurvey.question_id.14', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
                               }
                               ?>
			</td>
		</tr>
		<tr>
			<td>15.</td>
			<td>I was informed by the nurse about my investigations ahead to me,
				time to time?</td>
			<td><?php 
			if(count($this->data) > 0) {
                                  echo $this->data['PatientSurvey']['question_id'][15];
                                } else {
                               echo $this->Form->input('PatientSurvey.question_id.15', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
                               }
                               ?>
			</td>
		</tr>
		<tr>
			<td>16.</td>
			<td>I was attended by a nurse withinutton. 5 minutes of pressing the
				nurse call b?</td>
			<td><?php 
			if(count($this->data) > 0) {
                                  echo $this->data['PatientSurvey']['question_id'][16];
                                } else {
                               echo $this->Form->input('PatientSurvey.question_id.16', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
                                }
                                ?>
			</td>
		</tr>
		<tr>
			<td>17.</td>
			<td>Nurses were attentive, polite,respectful and friendly with me
				during my stay?</td>
			<td><?php 
			if(count($this->data) > 0) {
                                  echo $this->data['PatientSurvey']['question_id'][17];
                                } else {
                               echo $this->Form->input('PatientSurvey.question_id.17', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
                                }
                                ?>
			</td>
		</tr>
		<tr>
			<td>18.</td>
			<td>I was satisfied with the clinical services received at ICU?</td>
			<td><?php 
			if(count($this->data) > 0) {
                                  echo $this->data['PatientSurvey']['question_id'][18];
                                } else {
                               echo $this->Form->input('PatientSurvey.question_id.18', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
                               }
                               ?>
			</td>
		</tr>
		<tr>
			<td>19.</td>
			<td>I was satisfied with the support services received at ICU?</td>
			<td><?php 
			if(count($this->data) > 0) {
                                  echo $this->data['PatientSurvey']['question_id'][19];
                                } else {
                               echo $this->Form->input('PatientSurvey.question_id.19', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
                               }
                               ?>
			</td>
		</tr>
		<tr>
			<td>20.</td>
			<td>I got my all investigation reports on time?</td>
			<td><?php 
			if(count($this->data) > 0) {
                                  echo $this->data['PatientSurvey']['question_id'][20];
                                } else {
                               echo $this->Form->input('PatientSurvey.question_id.20', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
                              }
                              ?>
			</td>
		</tr>
		<tr>
			<td>21.</td>
			<td>House keeping staff was attentive ,polite,respectful and friendly
				with me?</td>
			<td><?php 
			if(count($this->data) > 0) {
                                  echo $this->data['PatientSurvey']['question_id'][21];
                                } else {
                               echo $this->Form->input('PatientSurvey.question_id.21', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
                               }
                               ?>
			</td>
		</tr>
		<tr>
			<td>22.</td>
			<td>I was always provided prompt bed side assistance ?</td>
			<td><?php 
			if(count($this->data) > 0) {
                                  echo $this->data['PatientSurvey']['question_id'][22];
                                } else {
                               echo $this->Form->input('PatientSurvey.question_id.22', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
                               }
                               ?>
			</td>
		</tr>
		<tr>
			<td>23.</td>
			<td>I was Transported safely by the staff for all
				investigation/procedures?</td>
			<td><?php 
			if(count($this->data) > 0) {
                                  echo $this->data['PatientSurvey']['question_id'][23];
                                } else {
                               echo $this->Form->input('PatientSurvey.question_id.23', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
                               }
                               ?>
			</td>
		</tr>
		<tr>
			<td>24.</td>
			<td>During my stay all light fixtures and the fitting were in working
				condition?</td>
			<td><?php 
			if(count($this->data) > 0) {
                                  echo $this->data['PatientSurvey']['question_id'][24];
                                } else {
                               echo $this->Form->input('PatientSurvey.question_id.24', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
                               }
                               ?>
			</td>
		</tr>
		<tr>
			<td>25.</td>
			<td>Linen provided to me during my stay was clean and spotless?</td>
			<td><?php 
			if(count($this->data) > 0) {
                                  echo $this->data['PatientSurvey']['question_id'][25];
                                } else {
                               echo $this->Form->input('PatientSurvey.question_id.25', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
                               }
                               ?>
			</td>
		</tr>
		<tr>
			<td>26.</td>
			<td>My linen was changed and arranged neatly everyday?</td>
			<td><?php 
			if(count($this->data) > 0) {
                                  echo $this->data['PatientSurvey']['question_id'][26];
                                } else {
                               echo $this->Form->input('PatientSurvey.question_id.26', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
                               }
                               ?>
			</td>
		</tr>
		<tr>
			<td>27.</td>
			<td>I was able to get my prescribe medecine from the hospital
				pharmacy?</td>
			<td><?php 
			if(count($this->data) > 0) {
                                  echo $this->data['PatientSurvey']['question_id'][27];
                                } else {
                               echo $this->Form->input('PatientSurvey.question_id.27', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
                               }
                               ?>
			</td>
		</tr>
		<tr>
			<td>28.</td>
			<td>I was attended promptly and regularly by physiotherapist?</td>
			<td><?php 
			if(count($this->data) > 0) {
                                  echo $this->data['PatientSurvey']['question_id'][28];
                                } else {
                               echo $this->Form->input('PatientSurvey.question_id.28', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
                               }
                               ?>
			</td>
		</tr>
		<tr>
			<td>29.</td>
			<td>The discharge process was completed in 2 hours?</td>
			<td><?php 
			if(count($this->data) > 0) {
                                  echo $this->data['PatientSurvey']['question_id'][29];
                                } else {
                               echo $this->Form->input('PatientSurvey.question_id.29', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
                               }
                               ?>
			</td>
		</tr>
		<tr>
			<td>30.</td>
			<td>Overall I satisfied with the treatment received from the
				Hospital?</td>
			<td><?php 
			if(count($this->data) > 0) {
                                  echo $this->data['PatientSurvey']['question_id'][30];
                                } else {
                               echo $this->Form->input('PatientSurvey.question_id.30', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
                               }
                               ?>
			</td>
		</tr>
		<tr>
			<td>31.</td>
			<td>I would recommend Hope Hospital to the others for their care?</td>
			<td><?php 
			if(count($this->data) > 0) {
                                  echo $this->data['PatientSurvey']['question_id'][31];
                                } else {
                               echo $this->Form->input('PatientSurvey.question_id.31', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
                               }
                               ?>
			</td>
		</tr>
		<tr>
			<td>32.</td>
			<td>What do you like best about the hospital?</td>
			<td><?php 
			if(count($this->data) > 0) {
                                  echo $this->data['PatientSurvey']['question_id'][32];
                                } else {
                                  echo $this->Form->textarea('PatientSurvey.question_id.32', array('cols' => '35', 'rows' => '5', 'label'=> false, 'div' => false, 'error' => false));
                                }
                                ?>
			</td>
		</tr>
		<tr>
			<td>33.</td>
			<td>Would you like to appreciate any staff for services provided?</td>
			<td><?php 
			if(count($this->data) > 0) {
                                  echo $this->data['PatientSurvey']['question_id'][33];
                                } else {
                                  echo $this->Form->textarea('PatientSurvey.question_id.33', array('cols' => '35', 'rows' => '5', 'label'=> false, 'div' => false, 'error' => false));
                                }
                                ?>
			</td>
		</tr>
		<tr>
			<td>34.</td>
			<td>What can we do to improve?</td>
			<td><?php 
			if(count($this->data) > 0) {
                                  echo $this->data['PatientSurvey']['question_id'][34];
                                } else {
                                  echo $this->Form->textarea('PatientSurvey.question_id.34', array('cols' => '35', 'rows' => '5', 'label'=> false, 'div' => false, 'error' => false));
                                }
                                ?>
			</td>
		</tr>
	</table>
	<div>&nbsp;</div>
	<div class="clr ht5"></div>
	<div class="btns">

		<?php
		if(count($this->data) > 0) {
             echo $this->Html->link(__('Back'),array('controller'=>'patients','action'=>'patient_information',$patient['Patient']['id']),array('class'=>'blueBtn','div'=>false));
           } else {
             echo $this->Html->link(__('Cancel'),array('controller'=>'patients','action'=>'patient_information',$patient['Patient']['id']),array('class'=>'blueBtn','div'=>false));
             echo $this->Form->submit(__('Submit'), array('class'=>'blueBtn','div'=>false));
           }
           ?>
	</div>
	<?php echo $this->Form->end(); ?>