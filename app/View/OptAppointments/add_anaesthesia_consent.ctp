<?php 
//echo $this->Html->css(array('jquery.timepicker.css'));
//echo $this->Html->script(array('jquery.timepicker'));
?>
<div class="inner_title">
	<h3>Add Anesthesia Consent Form</h3>
	<span>
	<?php 
		echo $this->Html->link(__('Back'),'javascript:void(0);', array('escape' => false,'class'=>"blueBtn Back"));
	?>
	</span>
</div>
<div class="patient_info">
	<?php //echo $this->element('patient_information');?>
</div>
<div class="clr"></div>
<p class="ht5"></p>
<form
	name="anaesthesiaconsentfrm" id="anaesthesiaconsentfrm"
	action="<?php echo $this->Html->url(array("controller" => "opt_appointments", "action" => "saveAnaesthesiaConsent")); ?>"
	method="post">
	<?php 
	echo $this->Form->hidden('AnaesthesiaConsentForm.opt_appointment_id', array('id' => 'opt_appointment_id', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off', 'style' => 'width:400px;', 'value'=> $optId));

	echo $this->Form->input('AnaesthesiaConsentForm.patient_id', array('type' => 'hidden', 'value'=> $patient_id, 'id' => 'patient_id'));
	echo $this->Form->input('AnaesthesiaConsentForm.id', array('type' => 'hidden', 'value'=> $patientConsentDetails['AnaesthesiaConsentForm']['id'], 'id' => 'anaesthesia_consent_id'));
	?>
	<!--single column table start here -->
	<table width="100%" cellpadding="0" cellspacing="0" border="0"
		class="formFull" style="border: 0;">
		<tr>
			<td width="100%" colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td width="165">I. <font color="red">*</font> Name of Anesthesiologist</td>
			<td>
				<table cellspacing="0" cellpadding="0" border="0" width="210">
					<tbody>
						<tr>
							<td width="140"><?php 
							echo $this->Form->input('AnaesthesiaConsentForm.anaesthesiologist_name', array('empty'=>__('Please Select'),'options'=>$anaesthesialist,'class' => 'validate[required,custom[mandatory-select]]','id' => 'anaesthesiologist_name', 'selected' => $patientConsentDetails['AnaesthesiaConsentForm']['anaesthesiologist_name'], 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off', 'style' => 'width:400px;'));
							?>
							</td>
							<td align="right" width="30"></td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td width="100%" colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td width="165">II. <font color="red">*</font> Surgery</td>
			<td>
				<table cellspacing="0" cellpadding="0" border="0" width="210">
					<tbody>
						<tr>
							<td width="140"><?php 
							echo $this->Form->input('AnaesthesiaConsentForm.surgery_id', array('empty'=>__('Please Select'),'options'=>$surgeries,'id' => 'surgeryname', 'selected' => $patientConsentDetails['AnaesthesiaConsentForm']['surgery_id'],'class' => 'validate[required,custom[mandatory-select]]', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off', 'style' => 'width:400px;'));
							?>
							</td>
							<td align="right" width="30"></td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		
		<tr>
		<td colspan="2">III. The Proposed Type of Anesthesia Technique (explain briefly in non-medical terms):</td>
		</tr>
		<tr>
			<td width="30" valign="top" align="left"></td>
			<td style="padding-bottom: 7px;">
				<div style="padding-top: 3px; padding-left: 30px;">
					1. Surgical intervention to be administered by the surgeons:<br />
					2. Proposed anesthesia technique(s):
					<div style="padding-top: 3px; padding-left: 40px;">
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="25" valign="middle"><input type="checkbox"
									name="data[AnaesthesiaConsentForm][general_anaesthesia]"
									value="1" id="general_anaesthesia"
									<?php if($patientConsentDetails['AnaesthesiaConsentForm']['general_anaesthesia'] == 1) echo "checked"; ?> />
								</td>
								<td>General Anesthesia</td>
							</tr>
							<tr>
								<td valign="middle"><input type="checkbox"
									name="data[AnaesthesiaConsentForm][regional_anaesthesia]"
									value="1" id="regional_anaesthesia"
									<?php if($patientConsentDetails['AnaesthesiaConsentForm']['regional_anaesthesia'] == 1) echo "checked"; ?> />
								</td>
								<td>Regional Anesthesia</td>
							</tr>
							<tr>
								<td valign="middle"><input type="checkbox"
									name="data[AnaesthesiaConsentForm][nerve_block]" value="1"
									id="nerve_block"
									<?php if($patientConsentDetails['AnaesthesiaConsentForm']['nerve_block'] == 1) echo "checked"; ?> />
								</td>
								<td>Nerve block</td>
							</tr>
						</table>
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<td valign="top" align="left">IV. Physician's Statements:</td>
			<td style="padding-bottom: 7px;">
				<div style="padding-top: 3px; padding-left: 30px;">
					1. I have adequately assessed the patient's physical condition
					prior to the anesthesia<br /> 2. I have verbally explained to the
					patient in the way that the patient can understand, concerning the
					anesthesia intervention to be carried out, as following:
					<div style="padding-top: 3px; padding-left: 40px;">
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="25" valign="middle"><input type="checkbox"
									name="data[AnaesthesiaConsentForm][anaesthesia_procedure]"
									value="1" id="anaesthesia_procedure"
									<?php if($patientConsentDetails['AnaesthesiaConsentForm']['anaesthesia_procedure'] == 1) echo "checked"; ?> />
								</td>
								<td>Anesthesia procedure</td>
							</tr>
							<tr>
								<td valign="middle"><input type="checkbox"
									name="data[AnaesthesiaConsentForm][anaesthesia_risks]"
									value="1" id="anaesthesia_risks"
									<?php if($patientConsentDetails['AnaesthesiaConsentForm']['anaesthesia_risks'] == 1) echo "checked"; ?> />
								</td>
								<td>Anesthesia-related risks</td>
							</tr>
							<tr>
								<td valign="middle"><input type="checkbox"
									name="data[AnaesthesiaConsentForm][anaesthesia_symptoms]"
									value="1" id="anaesthesia_symptoms"
									<?php if($patientConsentDetails['AnaesthesiaConsentForm']['anaesthesia_symptoms'] == 1) echo "checked"; ?> />
								</td>
								<td>The potential adverse symptoms following the anesthesia</td>
							</tr>
							<tr>
								<td valign="middle"><input type="checkbox"
									name="data[AnaesthesiaConsentForm][anaesthesia_suppliment]"
									value="1" id="anaesthesia_suppliment"
									<?php if($patientConsentDetails['AnaesthesiaConsentForm']['anaesthesia_suppliment'] == 1) echo "checked"; ?> />
								</td>
								<td>I have rendered the patient with supplementary information
									regarding the anesthesia</td>
							</tr>
						</table>
					</div>
					3. I have also provided the patient with sufficient time to inquire
					for the following questions concerning the anesthesia to be
					undertaken in this surgery.
				</div>
			</td>
		</tr>
		
		<tr>
			<td valign="top" align="left">V. Patient's Statements: </td>
			<td style="padding-bottom: 7px;">
				<div style="padding-top: 3px; padding-left: 30px;">
					1. I understand that the anesthesia procedure is necessary for
					undertaking this surgery in order to alleviate pain and fear during
					the operation<br /> 2. The anesthesia doctor has explained the risk
					and procedure of anesthesia to me<br /> 3. I fully understand the
					information provided relating to the anesthesia<br /> 4. I had
					addressed my concerns and doubts regarding the anesthesia to the
					anesthesia doctor and he/she has given me satisfactory responses.
				</div>
			</td>
		</tr>
		<tr>
			<td  valign="top" align="left">VI.<font color="red">*</font> Date / Time: </td>
			<td style="padding-top: 3px; padding-left: 30px;" ><input type="text" class="validate[required,custom[mandatory-date]] textBoxExpnd"
										name="data[AnaesthesiaConsentForm][anaesthesia_time]"
										value="<?php if($patientConsentDetails['AnaesthesiaConsentForm']['anaesthesia_time'] && $patientConsentDetails['AnaesthesiaConsentForm']['anaesthesia_time'] !="0000-00-00 00:00:00") echo  $this->DateFormat->formatDate2Local($patientConsentDetails['AnaesthesiaConsentForm']['anaesthesia_time'],Configure::read('date_format'), true);  ?>"
										id="anaesthesia_time" style="width: 140px;" /></td>
									
				
		</tr>

	</table>
	<!--single column table end here -->
	<p class="ht5"></p>
	<table width="100%" border="0" cellspacing="1" cellpadding="0"
		class="tabularForm">
		<tr>
			<th colspan="2">Relationship to the Patient:</th>
		</tr>
		<tr>
			<td width="60%" align="left" valign="top" style="padding-top: 7px;">
				<table width="500" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="145" height="25" valign="middle" class="tdLabel1">Relationship
							to Patient:</td>
						<td align="left" valign="top"><input type="text"
							class="textBoxExpnd"
							name="data[AnaesthesiaConsentForm][relationship_to_patient]"
							id="relationship_to_patient"
							value="<?php echo $patientConsentDetails['AnaesthesiaConsentForm']['relationship_to_patient']; ?>" />
						</td>
					</tr>
					<tr>
						<td height="25" valign="middle" class="tdLabel1">Address</td>
						<td align="left" valign="top"><input type="text"
							class="textBoxExpnd"
							name="data[AnaesthesiaConsentForm][relationship_to_address]"
							id="relationship_to_address"
							value="<?php echo $patientConsentDetails['AnaesthesiaConsentForm']['relationship_to_address']; ?>" />
						</td>
					</tr>
				</table>
			</td>
			<td width="40%" align="left" valign="top" style="padding-top: 7px;">
				<table width="350" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="160" height="35" valign="middle" class="tdLabel1"
							id="boxSpace1">Tel No.:</td>
						<td align="left" valign="top"><input type="text"
							class="textBoxExpnd"
							name="data[AnaesthesiaConsentForm][relationship_to_telephone]"
							id="relationship_to_telephone" maxlength="10"
							value="<?php echo $patientConsentDetails['AnaesthesiaConsentForm']['relationship_to_telephone']; ?>" />
						</td>
					</tr>
					<tr>
						<td height="35" valign="middle" class="tdLabel1" id="boxSpace1">Date
							/ Time</td>
						<td align="left" valign="top" style="padding: 0;">
							<table width="230" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td width="140"><input type="text" class="textBoxExpnd"
										name="data[AnaesthesiaConsentForm][relationship_to_date]"
										id="relationship_to_date"
										value="<?php if($patientConsentDetails['AnaesthesiaConsentForm']['relationship_to_date'] && $patientConsentDetails['AnaesthesiaConsentForm']['relationship_to_date'] !="0000-00-00 00:00:00") echo $this->DateFormat->formatDate2Local($patientConsentDetails['AnaesthesiaConsentForm']['relationship_to_date'],Configure::read('date_format'), true); ?>"
										style="width: 150px;" /></td>
									<td width="25" align="left" style="padding: 0;"></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>


		</tr>
	</table>
	<p class="ht5"></p>
	<div class="tdLabel2">Note 1. Please specify the relationship to the
		patient if the authorized signer is not the patient himself/herself</div>
	<p class="clr ht5"></p>
	<div class="btns">
		<?php 
			//echo $this->Html->link(__('Cancel', true),array('action' => 'anaesthesia_consent', $patient_id), array('escape' => false,'class'=>'grayBtn'));
			echo $this->Html->link(__('Cancel', true),'javascript:void(0);', array('escape' => false,'class'=>'grayBtn Back'));
		 ?>
		<input type="submit" value="Submit" class="blueBtn">


	</div>
</form>
<!-- Right Part Template ends here -->

<script>
jQuery(document).ready(function(){
	 
      jQuery("#anaesthesiaconsentfrm").validationEngine();
	
                          $( "#anaesthesia_time" ).datepicker({
									showOn: "button",
									buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
									buttonImageOnly: true,
									changeMonth: true,
									changeYear: true,
									changeTime:true,
									showTime: true,  		
									dateFormat:'<?php echo $this->General->GeneralDate("HH:II");?>'
                                                 
							});

                          $( "#relationship_to_date" ).datepicker({
									showOn: "button",
									buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
                                                                        buttonImageOnly: true,
									changeMonth: true,
									changeYear: true,
									changeTime:true,
									showTime: true,  		
									dateFormat:'<?php echo $this->General->GeneralDate("HH:II");?>'
                                                                        
                                               
							});
 
   });
   $('#relationship_to_telephone').blur( function (){
	  /* /^[0-9]{3}-|\s[0-9]{3}-|\s[0-9]{4}$/ */
	if(!$('#relationship_to_telephone').val().match(/^([\+][0-9]{1,3}[ \.\-])?([\(]{1}[0-9]{2,6}[\)])?([0-9 \.\-\/]{3,20})((x|ext|extension)[ ]?[0-9]{1,4})?$/)) {
		alert('Phone Number should be Numbers Only');
		   return false;
		  
		  }
	   });
   $('#relationship_to_patient').blur( function (){
		if(!$('#relationship_to_patient').val().match(/^[a-zA-Z\ \"'"]+$/)) {
			alert('Name should be Alphabets Only');
			   return false;
			  
			  }
		   });

   $(".Back").click(function(){
		$.ajax({
			url: '<?php echo $this->Html->url(array("controller" => "opt_appointments", "action" => "anaesthesia_consent", "admin" => false,'plugin' => false, $patient_id)); ?>',
			beforeSend:function(data){
				$('#busy-indicator').show();
			},
			success: function(data){
				$('#busy-indicator').hide();
				$("#render-ajax").html(data);
		     }
		});
	 });

</script>
