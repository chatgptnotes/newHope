<?php 
	echo $this->Html->script('jquery.autocomplete');
	echo $this->Html->css('jquery.autocomplete.css');
?>
<div class="inner_title">
<h3><?php echo __('PCMH IT Checklist 2', true); ?></h3>
</div>
<?php echo $this->Form->create(null,array('url' => array('action'=>'pcmh_report'),'type'=>'post', 'id'=> 'pcmhreportfrm'));
echo $this->Form->hidden('id',array('name'=>'data[PcmhServices][id]','id'=>'id','value'=>$result['PcmhServices']['id']));
?>	
<!-- <table border="0"   cellpadding="0" cellspacing="0" width="600px" align="left">
           <tr>				 
			<td  align="right"><?php echo __('Provider') ?> <font color="red">*</font>:</td>										
			<td class="row_format">											 
		    	<?php 
		    		 echo    $this->Form->input(null, array('name' => 'provider', 'class' => 'validate[required,custom[mandatory-select]]', 'options' => $doctorlist, 'empty' => 'Select Provider', 'style' => 'width:300px;',  'id' => 'provider', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false, 'value' => $provider));
		    	?>
		  	</td>
		 </tr>	
		  <tr>				 
			<td  align="right"><?php echo __('Report Type') ?> <font color="red">*</font>:</td>										
			<td class="row_format">											 
		    	<?php 
		    		 echo    $this->Form->input(null, array('name' => 'duration', 'class' => 'validate[required,custom[mandatory-select]]', 'options' => array('90' => '90 Days'), 'empty' => 'Select Duration', 'style' => 'width:300px;',  'id' => 'duration', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false, 'value' => $duration));
		    	?>
		  	</td>
		    </tr>
	        <tr>				 
			 <td   align="right" ><?php echo __('Start Date') ?> <font color="red">*</font>:</td>										
			 <td class="row_format">											 
		    <?php 
		      echo $this->Form->input(null, array('class' => 'validate[required,custom[dateSelect]]','name' => 'startdate', 'id' => 'startdate', 'label'=> false, 'div' => false, 'error' => false, 'type'=> 'text','autocomplete'=>false));
            ?>
		  	</td>
		    </tr>
             
		  <tr>				 
			<td class="row_format" align="left" colspan="2" style="padding-left:155px;">
				<?php
					echo $this->Form->submit(__('Show Report'),array('class'=>'blueBtn','div'=>false,'label'=>false));	
				?>
			</td>
		 
		 </tr>	
		
</table>	 -->
 
   <div>&nbsp;</div>    
     <div class="clr ht5"></div>
 
    <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
          <tr>
           <th><?php echo __('Measures Name', true); ?></th>
           <th style="text-align:center; width:8%"> <?php echo __('Yes/No', true); ?></th>
	       <!-- <th style="text-align:center;"><?php echo __('Denominator', true); ?></th>
	       <th style="text-align:center;"> <?php echo __('Numerator', true); ?></th>
           <th style="text-align:center;"> <?php echo __('Ratio of N/D', true); ?></th> -->
          </tr>
	      <tr>
		    <td colspan="5"><b>Element 1A: Patient- Centered Appointment Access</b></td>
		  </tr>
		  <tr>
		    <td colspan="5"><b> Ability to provide alternative types of clinical encounters</b></td>
		  </tr>
		  <tr>
		    <td>1. Video chat capability. </td>
		    <td align="center"><?php echo $this->Form->radio('video_chat',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][video_chat]','value'=>$result['PcmhServices']['options']['video_chat'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  <tr>
		    <td>2. Secure instant messaging.</td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.instant_massage',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][instant_massage]','value'=>$result['PcmhServices']['options']['instant_massage'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		   <tr>
		    <td>3. Other forms of acceptable electronic communication.</td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.electronic_communication',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][electronic_communication]','value'=>$result['PcmhServices']['options']['electronic_communication'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
			<tr>
			    <td>4. Patient Communicates with Physician using Secure Instant Messaging (Premium Feature)</td>
			 	<td align="center"><?php echo $this->Form->radio('PcmhServices.secure_msg',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][secure_msg]','value'=>$result['PcmhServices']['options']['secure_msg'],'legend'=>false,'label'=>false));?></td>
			</tr>
			
			<tr>
			    <td>5. Patient Communicates with Physician using Secure Video Messaging (Stretch Goal) (Premium Feature)</td>
			 	<td align="center"><?php echo $this->Form->radio('PcmhServices.secure_video',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][secure_video]','value'=>$result['PcmhServices']['options']['secure_video'],'legend'=>false,'label'=>false));?></td>
			</tr>
			
			<tr>
			    <td>6. Patient Communicates with Physician using at least one other Electronic Communication Tool- DrM secure messaging</td>
			 	<td align="center"><?php echo $this->Form->radio('PcmhServices.one_elec_tool',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][one_elec_tool]','value'=>$result['PcmhServices']['options']['one_elec_tool'],'legend'=>false,'label'=>false));?></td>
			</tr>
			
			<tr>
			    <td>7. Patient Communicates with Physician using Secure Email Messaging (Direct) (Premium Feature)</td>
			 	<td align="center"><?php echo $this->Form->radio('PcmhServices.secure_email',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][secure_email]','value'=>$result['PcmhServices']['options']['secure_email'],'legend'=>false,'label'=>false));?></td>
			</tr>
			
			<tr>
			    <td>8. Patient Communicates with Physician using Secure Text Messaging (Premium Feature)</td>
			 	<td align="center"><?php echo $this->Form->radio('PcmhServices.secure_text',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][secure_text]','value'=>$result['PcmhServices']['options']['secure_text'],'legend'=>false,'label'=>false));?></td>
			</tr>
		  
		  
		  <tr>
		    <td colspan="5"><b>Element 1B: 24/7 Access to clinical advice</b></td>
		  </tr>
		  <tr>
		    <td>Patient can access a Physician in Off Hours to access to his/her Medical Record (Call Service has access to call 'Physician on Call for the Clinic', who can share the Medical Record to other Physicians or Patient or ) (Business Process)</td>
		  <td align="center"><?php echo $this->Form->radio('PcmhServices.off_hours_rec',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][off_hours_rec]','value'=>$result['PcmhServices']['options']['off_hours_rec'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  <tr>
		    <td>EMR Generates Automatic email reply for non-urgent services in Off Hours with Contact options (Custom Feature)</td>
		 	<td align="center"><?php echo $this->Form->radio('PcmhServices.auto_email_reply',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][auto_email_reply]','value'=>$result['PcmhServices']['options']['auto_email_reply'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		  <tr>
		    <td colspan="5"><b> Providing continuity of medical record information for care and advice when office is closed</b></td>
		  </tr>
		  <tr>
		    <td>1. Physican can access Medical Records outside the Clinic premises (EMR access) (Standard web access).</td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.clinical_info',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][clinical_info]','value'=>$result['PcmhServices']['options']['clinical_info'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  <tr>
		    <td>2. Provide patients with ability to access their own medical record.</td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.access_med_rec',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][access_med_rec]','value'=>$result['PcmhServices']['options']['access_med_rec'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  <tr>
		    <td>3. If cannot link with outside resources, provide on-call physician with ability to remotely access patient health record.</td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.link_resourse',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][link_resourse]','value'=>$result['PcmhServices']['options']['link_resourse'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  <tr>
		    <td>4. Medical Record Info for Care and Advice when Clinic is closed is available to Patient</td>
		 	<td align="center"><?php echo $this->Form->radio('PcmhServices.available_info',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][available_info]','value'=>$result['PcmhServices']['options']['available_info'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  <tr>
		    <td colspan="5"><b>	Providing timely clinical advice using a secure, interactive electronic system</b></td>
		  </tr>
		  <tr>
		    <td><?php echo $this->Html->link('1. Patient can send electronic message to Physician after hours and Receives automated secure reply (Premium Feature) ',array('controller'=>'Messages','action'=>'index','admin'=>false));?></td>
		    <td align="center"><?php echo $this->Form->radio('PcmhServices.secure_massage',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][secure_massage]','value'=>$result['PcmhServices']['options']['secure_massage'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  <tr>
		    <td colspan="5"><b>	Ability to document clinical advice in patient records</b></td>
		  </tr>
		  <tr>
		    <td>1. Ability to Document Clinical Advice Provided by Physician through Phone or Instant Massaging or text or email into EMR (Premium Feature) .</td>
		    <td align="center"><?php echo $this->Form->radio('PcmhServices.clinical_advice',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][clinical_advice]','value'=>$result['PcmhServices']['options']['clinical_advice'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  <tr>
		    <td>2. Have offline process to update EMR the next business day when the patient contacts Physician in off hours .</td>
		    <td align="center"><?php echo $this->Form->radio('PcmhServices.reconciliation_process',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][reconciliation_process]','value'=>$result['PcmhServices']['options']['reconciliation_process'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td colspan="5"><b>Element 1C: Electronic Access</b></td>
		  </tr>
		  
		  <tr>
		    <td>1. More than 50% patients have access to their Health Information within 4 business days (Standard; Patient Portal)</td>
		 	<td align="center"><?php echo $this->Form->radio('PcmhServices.getinfo_4days',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][getinfo_4days]','value'=>$result['PcmhServices']['options']['getinfo_4days'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		
		  <tr>
		    <td>2. EMR includes all data needed for Diagnosis and treatment of diseases (Patient Portal)</td>
		 	<td align="center"><?php echo $this->Form->radio('PcmhServices.emr_alldata',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][emr_alldata]','value'=>$result['PcmhServices']['options']['emr_alldata'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		
		  <tr>
		    <td>3. Patient can download and transmit their Health Informaton electronically to a third party (Standard; Patient Portal)</td>
		 	<td align="center"><?php echo $this->Form->radio('PcmhServices.download_healthinfo',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][download_healthinfo]','value'=>$result['PcmhServices']['options']['download_healthinfo'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		
		  <tr>
		    <td>4. Clincal Summary is provided within 1 business day for more than 50% of office visits</td>
		 	<td align="center"><?php echo $this->Form->radio('PcmhServices.getinfo_1day',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][getinfo_1day]','value'=>$result['PcmhServices']['options']['getinfo_1day'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		
		  <tr>
		    <td>5. Clinical Summary is provided in Patient Portal (All visits are pushed to Patient Portal; Front office needs to give UserID, starter password, and ask patient to access portain in office or later)</td>
		 	<td align="center"><?php echo $this->Form->radio('PcmhServices.summary_ptportal',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][summary_ptportal]','value'=>$result['PcmhServices']['options']['summary_ptportal'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		
		  <tr>
		    <td>6. Clinical Summary is provided to outside Physician using Direct Email (Standard)</td>
		 	<td align="center"><?php echo $this->Form->radio('PcmhServices.summary_otherdoc',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][summary_otherdoc]','value'=>$result['PcmhServices']['options']['summary_otherdoc'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		
		  <tr>
		    <td>7. Allow Legal Guardian to Communicate with Caregivers (Standard)</td>
		 	<td align="center"><?php echo $this->Form->radio('PcmhServices.guar_commu_caregiver',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][guar_commu_caregiver]','value'=>$result['PcmhServices']['options']['guar_commu_caregiver'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td>8. Patient Portal allows Patient to Request Appointments (Stretch Goal)  </td>
		 	<td align="center"><?php echo $this->Form->radio('PcmhServices.ptportal_appoinment',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][ptportal_appoinment]','value'=>$result['PcmhServices']['options']['ptportal_appoinment'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td>9. Patient Portal allows Patient to Refill Prescriptions (Stretch Goal) </td>
		 	<td align="center"><?php echo $this->Form->radio('PcmhServices.ptportal_prescription',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][ptportal_prescription]','value'=>$result['PcmhServices']['options']['ptportal_prescription'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td>10. Clinic Generates User Transimissions Log Report for Tracking Users who viewed/downloaded/transmitted EMR to caregiver by Date Range </td>
		 	<td align="center"><?php echo $this->Form->radio('PcmhServices.transmission_logreport',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][transmission_logreport]','value'=>$result['PcmhServices']['options']['transmission_logreport'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td>11. Clinic Generates a Report Showing Clinical Summaries Transmitted to Physicians Electornically by Date Range </td>
		 	<td align="center"><?php echo $this->Form->radio('PcmhServices.report_clsmry',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][report_clsmry]','value'=>$result['PcmhServices']['options']['report_clsmry'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td>12. Patients have two-way communicaiton with Practice </td>
		 	<td align="center"><?php echo $this->Form->radio('PcmhServices.twoway_comm',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][twoway_comm]','value'=>$result['PcmhServices']['options']['twoway_comm'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td>13. Patient and Physician can send instant messages during regular and off hours (Standard) </td>
		 	<td align="center"><?php echo $this->Form->radio('PcmhServices.regular_inst_msg',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][regular_inst_msg]','value'=>$result['PcmhServices']['options']['regular_inst_msg'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td>14. Patient Portal Shows Test Results (Standard) </td>
		 	<td align="center"><?php echo $this->Form->radio('PcmhServices.ptportal_testresult',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][ptportal_testresult]','value'=>$result['PcmhServices']['options']['ptportal_testresult'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td>15. Engage Legal in EULA that notifies that Portal is for Non Emergency Care etc. for accessing different types of caregivers: Auto reply </td>
		 	<td align="center"><?php echo $this->Form->radio('PcmhServices.eula_notify',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][eula_notify]','value'=>$result['PcmhServices']['options']['eula_notify'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td>16. Clinic Genrates a Report Showing Two-Way Communications of Patients and Clinic </td>
		 	<td align="center"><?php echo $this->Form->radio('PcmhServices.twoway_comm_clinic',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][twoway_comm_clinic]','value'=>$result['PcmhServices']['options']['twoway_comm_clinic'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		   <tr>
		    <td>17. The practice has a secure, interactive electronic system, such as a Web site, patient portal or a 
					secure e-mail system that allows two-way communication between patients/families/caregivers, as applicable for a patient, and the practice.</td>
		    <td align="center"><?php echo $this->Form->radio('PcmhServices.interactive_system',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][interactive_system]','value'=>$result['PcmhServices']['options']['interactive_system'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		 
		  <tr>
		    <td colspan="5"><b>Element 2B: Medical Home Responsibilities</b></td>
		  </tr>
		  <tr>
		    <td colspan="5"><b>	The practice functions most effectively as a medical home if patients provide a complete medical history and information about care obtained outside the practice</b></td>
		  </tr>
		  <tr>
		    <td>1. To be an effective medical home, the practice has comprehensive patient information about medications; visits to specialists; medical history; 
					health status; recent test results; self-care information; and data from recent hospitalizations, specialty care or ER visits.</td>
		    <td align="center"><?php echo $this->Form->radio('PcmhServices.effective_med_home',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][effective_med_home]','value'=>$result['PcmhServices']['options']['effective_med_home'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  <tr>
		    <td>2. Although this element heavily depends on the patient’s ability to answer these questions an ideal future scenario would be that the practice can 
					access this information from any patient that has already had a clinical encounter at DHR or one of its associated clinics.</td>
		    <td align="center"><?php echo $this->Form->radio('PcmhServices.future_scenario',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][future_scenario]','value'=>$result['PcmhServices']['options']['future_scenario'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td>3. Patient provides comprehensive patient info on meds, visits, lab results, self-care, ER visits, hospitalizations etc. (Standard)</td>
		 	<td align="center"><?php echo $this->Form->radio('PcmhServices.ptinfo_facility2',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][ptinfo_facility2]','value'=>$result['PcmhServices']['options']['ptinfo_facility2'],'legend'=>false,'label'=>false));?></td>
		</tr>
		
		<tr>
		    <td>4. DHR or Other Clinic provdies the comprehensive patient info on meds, visits, lab results, self-care, ER visits, hospitalizations etc to other care providers (Through Secure Direct Email)</td>
		 	<td align="center"><?php echo $this->Form->radio('PcmhServices.clinic_provide_info',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][clinic_provide_info]','value'=>$result['PcmhServices']['options']['clinic_provide_info'],'legend'=>false,'label'=>false));?></td>
		</tr>
		  
		  <tr>
		    <td colspan="5"><b>Element 3A: Patient Information</b></td>
		  </tr>
		  <tr>
		    <td>1.Over 80% of EMRs in a Clinic are searchable by 'Date of Birth' of Patient </td>
		    <td align="center"><?php echo $this->Form->radio('PcmhServices.search_dob',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][search_dob]','value'=>$result['PcmhServices']['options']['search_dob'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  <tr>
		    <td>2.Over 80% of EMRs in a Clinic are searchable by 'Sex' of Patient' </td>
		    <td align="center"><?php echo $this->Form->radio('PcmhServices.search_sex',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][search_sex]','value'=>$result['PcmhServices']['options']['search_sex'],'legend'=>false,'label'=>false));?></td>
		  </tr> 
		  <tr>
		    <td>3.Over 80% of EMRs in a Clinic are searchable by 'Race' of Patient (include: 'Declined to specify') </td>
		    <td align="center"><?php echo $this->Form->radio('PcmhServices.search_race',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][search_race]','value'=>$result['PcmhServices']['options']['search_race'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  <tr>
		    <td>4.Over 80% of EMRs in a Clinic are searchable by 'Ethnicity' of Patient' (include: 'Declined to specify') </td>
		    <td align="center"><?php echo $this->Form->radio('PcmhServices.search_ethnicity',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][search_ethnicity]','value'=>$result['PcmhServices']['options']['search_ethnicity'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  <tr>
		    <td>5.Over 80% of EMRs in a Clinic are searchable by 'Preferred Language' of Patient' </td>
		    <td align="center"><?php echo $this->Form->radio('PcmhServices.search_language',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][search_language]','value'=>$result['PcmhServices']['options']['search_language'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  <tr>
		    <td>6.Over 80% of EMRs in a Clinic are searchable by 'Telephone' of Patient </td>
		    <td align="center"><?php echo $this->Form->radio('PcmhServices.search_telephone',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][search_telephone]','value'=>$result['PcmhServices']['options']['search_telephone'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  <tr>
		    <td>7.Over 80% of EMRs in a Clinic are searchable by 'Alternate Telephone' of Patient (mandatory; can be same as primary) </td>
		    <td align="center"><?php echo $this->Form->radio('PcmhServices.search_telephone_alt',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][search_telephone_alt]','value'=>$result['PcmhServices']['options']['search_telephone_alt'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  <tr>
		    <td>8.Over 80% of EMRs in a Clinic are searchable by 'eMail' of Patient' </td>
		    <td align="center"><?php echo $this->Form->radio('PcmhServices.search_email',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][search_email]','value'=>$result['PcmhServices']['options']['search_email'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  <tr>
		    <td>9.Over 80% of EMRs in a Clinic are searchable by 'Occupation' of Patient' </td>
		    <td align="center"><?php echo $this->Form->radio('PcmhServices.search_occupation',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][search_occupation]','value'=>$result['PcmhServices']['options']['search_occupation'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  <tr>
		    <td>10.Over 80% of EMRs in a Clinic are searchable by 'Dates of Previous Clinical Visits' of Patient' </td>
		    <td align="center"><?php echo $this->Form->radio('PcmhServices.search_visit',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][search_visit]','value'=>$result['PcmhServices']['options']['search_visit'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  <tr>
		    <td>11.Over 80% of EMRs in a Clinic are searchable by 'Legal Guardian/Healthcare Proxy' of Patient' </td>
		    <td align="center"><?php echo $this->Form->radio('PcmhServices.search_guardian',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][search_guardian]','value'=>$result['PcmhServices']['options']['search_guardian'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  <tr>
		    <td>12.Over 80% of EMRs in a Clinic are searchable by 'Primary Care Giver' of Patient' </td>
		    <td align="center"><?php echo $this->Form->radio('PcmhServices.search_caregiver',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][search_caregiver]','value'=>$result['PcmhServices']['options']['search_caregiver'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  <tr>
		    <td>13.Over 80% of EMRs in a Clinic are searchable by 'Advanced Directives' of Patient' </td>
		    <td align="center"><?php echo $this->Form->radio('PcmhServices.search_directive',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][search_directive]','value'=>$result['PcmhServices']['options']['search_directive'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  <tr>
		    <td>14.Over 80% of EMRs in a Clinic are searchable by 'Health Insurance Information' of Patient' </td>
		    <td align="center"><?php echo $this->Form->radio('PcmhServices.search_health',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][search_health]','value'=>$result['PcmhServices']['options']['search_health'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  <tr>
		    <td>15.Over 80% of EMRs in a Clinic are searchable by 'Name and Contact of Other Healthcare Professionals involved in care' of Patient':( list of patients seen by a physician) </td>
		    <td align="center"><?php echo $this->Form->radio('PcmhServices.search_other_healthcare',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][search_other_healthcare]','value'=>$result['PcmhServices']['options']['search_other_healthcare'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td colspan="5"><b>Element 3B: Clinical Data</b></td>
		  </tr>
		  <tr>
		    <td>1.EMR calculates and displays BMI (Standard) </td>
		    <td align="center"><?php echo $this->Form->radio('PcmhServices.cal_bmi',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][cal_bmi]','value'=>$result['PcmhServices']['options']['cal_bmi'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td colspan="5"><b>Element 3D: Use of Data for Population Management(ALL MUST BE MET)</b></td>
		</tr>
		<tr>
		    <td><b>Practice Generates the List of Patients for Preventive Care (any 2 of below)</b></td>
		 	<td align="center"><?php echo $this->Form->radio('PcmhServices.practice_generate_list',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][practice_generate_list]','value'=>$result['PcmhServices']['options']['practice_generate_list'],'legend'=>false,'label'=>false));?></td>
		</tr>
		
		<tr>
		    <td>1. Practice Generates the List of Patients to Remind them for Preventive Care Service 1 (e.g. Mammogram for women over 40 yrs)</td>
		 	<td align="center"><?php echo $this->Form->radio('PcmhServices.list_remind_service1',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][list_remind_service]','value'=>$result['PcmhServices']['options']['list_remind_service'],'legend'=>false,'label'=>false));?></td>
		</tr>
		
		<tr>
		    <td>2. Practice Generates the List of Patients to Remind them for Preventive Care Service 2 (e.g. Blood Sugar)</td>
		 	<td align="center"><?php echo $this->Form->radio('PcmhServices.list_remind_service2',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][list_remind_service2]','value'=>$result['PcmhServices']['options']['list_remind_service2'],'legend'=>false,'label'=>false));?></td>
		</tr>
		
		<tr>
		    <td>3. Practice Generates the List of Patients to Remind them for Preventive Care Service 3 (e.g. Pap Test)</td>
		 	<td align="center"><?php echo $this->Form->radio('PcmhServices.list_remind_service3',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][list_remind_service3]','value'=>$result['PcmhServices']['options']['list_remind_service3'],'legend'=>false,'label'=>false));?></td>
		</tr>
		
		<tr>
		    <td>4. Practice Generates the List of Patients to Remind them for Preventive Care Service 4 (e.g. Prostrate Cancer Screening)</td>
		 	<td align="center"><?php echo $this->Form->radio('PcmhServices.list_remind_service4',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][list_remind_service4]','value'=>$result['PcmhServices']['options']['list_remind_service4'],'legend'=>false,'label'=>false));?></td>
		</tr>
		
		<tr>
		    <td>5. Practice Generates the List of Patients to Remind them for Preventive Care Service 5 (e.g. Cholesterol Screening including LDL)</td>
		 	<td align="center"><?php echo $this->Form->radio('PcmhServices.list_remind_service5',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][list_remind_service5]','value'=>$result['PcmhServices']['options']['list_remind_service5'],'legend'=>false,'label'=>false));?></td>
		</tr>
		
		<tr>
		    <td>6. Practice Generates the List of Patients to Remind them for Preventive Care Service 6 (e.g. Colorectal Cancer Screening)</td>
		 	<td align="center"><?php echo $this->Form->radio('PcmhServices.list_remind_service6',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][list_remind_service6]','value'=>$result['PcmhServices']['options']['list_remind_service6'],'legend'=>false,'label'=>false));?></td>
		</tr>
		
		<tr>
		    <td>7. Practice Generates the List of Patients to Remind them for Preventive Care Service 7 (e.g. Bone Mineral Density Screening)</td>
		 	<td align="center"><?php echo $this->Form->radio('PcmhServices.list_remind_service7',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][list_remind_service7]','value'=>$result['PcmhServices']['options']['list_remind_service7'],'legend'=>false,'label'=>false));?></td>
		</tr>
		
		<tr>
		    <td>8. Practice Generates the List of Patients to Remind them for Preventive Care Service 8 (e.g. HBA1C)</td>
		 	<td align="center"><?php echo $this->Form->radio('PcmhServices.list_remind_service8',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][list_remind_service8]','value'=>$result['PcmhServices']['options']['list_remind_service8'],'legend'=>false,'label'=>false));?></td>
		</tr>
		
		<tr>
		    <td>9. Practice Generates the List of Patients to Remind them for Preventive Care Service 9 (e.g. Urine Microalbumin)</td>
		 	<td align="center"><?php echo $this->Form->radio('PcmhServices.list_remind_service9',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][list_remind_service9]','value'=>$result['PcmhServices']['options']['list_remind_service9'],'legend'=>false,'label'=>false));?></td>
		</tr>
		
		<tr>
		    <td>10. Practice Generates the List of Patients to Remind them for Preventive Care Service 10 (e.g. Dilated Eye Exam Screening)</td>
		 	<td align="center"><?php echo $this->Form->radio('PcmhServices.list_remind_service10',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][list_remind_service10]','value'=>$result['PcmhServices']['options']['list_remind_service10'],'legend'=>false,'label'=>false));?></td>
		</tr>
		
		<tr>
		    <td>11. Practice Generates the List of Patients to Remind them for Preventive Care Service 11 (e.g. Foot Exam Screening)</td>
		 	<td align="center"><?php echo $this->Form->radio('PcmhServices.list_remind_service11',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][list_remind_service11]','value'=>$result['PcmhServices']['options']['list_remind_service11'],'legend'=>false,'label'=>false));?></td>
		</tr>
		
		<tr>
		    <td><b>Practice Generates the List of Patients for Immunization (any 2 of below)</b></td>
		 	<td align="center"><?php echo $this->Form->radio('PcmhServices.list_immunization',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][list_immunization]','value'=>$result['PcmhServices']['options']['list_immunization'],'legend'=>false,'label'=>false));?></td>
		</tr>
		
		<tr>
		    <td>1. Practice Generates the List of Patients to Remind them for Immunization Service 1 (e.g. Influenza)</td>
		 	<td align="center"><?php echo $this->Form->radio('PcmhServices.list_immunization_service1',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][list_immunization_service1]','value'=>$result['PcmhServices']['options']['list_immunization_service1'],'legend'=>false,'label'=>false));?></td>
		</tr>
		
		<tr>
		    <td>2. Practice Generates the List of Patients to Remind them for Immunization Service 2 (e.g. Pneumococcal Vaccination)</td>
		 	<td align="center"><?php echo $this->Form->radio('PcmhServices.list_immunization_service2',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][list_immunization_service2]','value'=>$result['PcmhServices']['options']['list_immunization_service2'],'legend'=>false,'label'=>false));?></td>
		</tr>
		
		<tr>
		    <td>3. Practice Generates the List of Patients to Remind them for Immunization Service 3 (e.g. Tetanus & Diphtheria)</td>
		 	<td align="center"><?php echo $this->Form->radio('PcmhServices.list_immunization_service3',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][list_immunization_service3]','value'=>$result['PcmhServices']['options']['list_immunization_service3'],'legend'=>false,'label'=>false));?></td>
		</tr>
		  
		  <tr>
		    <td colspan="5"><b>	At least three different chronic or acute care services</b></td>
		  </tr>
		  <tr>
		    <td colspan="5">1. The practice generates lists (registries) of patients who need chronic care management services and uses the lists to remind identified patients of at least three chronic care services.</td>
		  </tr>
		  <tr>
		    <td>For adults: Examples include diabetes care, coronary artery disease care, lab values outside normal range and post-hospitalization follow-up appointments</td>
		    <td align="center"><?php echo $this->Form->radio('PcmhServices.chronic_1',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][chronic_1]','value'=>$result['PcmhServices']['options']['chronic_1'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  <tr>
		    <td>For children: Examples include services related to chronic conditions such as asthma, ADHD, ADD, obesity and depression.</td>
		    <td align="center"><?php echo $this->Form->radio('PcmhServices.chronic_2',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][chronic_2]','value'=>$result['PcmhServices']['options']['chronic_2'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  <tr>
		    <td colspan="5"><b> Patients not recently seen by the practice</b></td>
		  </tr>
		  <tr>
		    <td>The practice generates lists of patients who are overdue for an office visit or service (e.g., care management follow-up visit, overdue periodic physical exam) and acts to remind them</td>
		    <td align="center"><?php echo $this->Form->radio('PcmhServices.overdue_visit',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][overdue_visit]','value'=>$result['PcmhServices']['options']['overdue_visit'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  <tr>
		    <td colspan="5"><b>	Medication monitoring or alert</b></td>
		  </tr>
		  <tr>
		    <td colspan="5">The practice generates lists of patients on specific medications. Lists may be used to:</td>
		  </tr>
		  <tr>
		    <td>1. Manage patients prescribed medications with potentially harmful side effects.</td>
		    <td align="center"><?php echo $this->Form->radio('PcmhServices.Medication_1',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][Medication_1]','value'=>$result['PcmhServices']['options']['Medication_1'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  <tr>
		    <td>2. Identify patients prescribed a brand-name drug instead of a generic drug.</td>
		    <td align="center"><?php echo $this->Form->radio('PcmhServices.Medication_2',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][Medication_2]','value'=>$result['PcmhServices']['options']['Medication_2'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  <tr>
		    <td>3. Notify patients about a medication recall or warning.</td>
		    <td align="center"><?php echo $this->Form->radio('PcmhServices.Medication_3',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][Medication_3]','value'=>$result['PcmhServices']['options']['Medication_3'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  <tr>
		    <td>4. Remind patients about necessary monitoring because of specific medications (e.g., warfarin, liver function test for patients on selected medications, growth hormone).</td>
		    <td align="center"><?php echo $this->Form->radio('PcmhServices.Medication_4',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][Medication_4]','value'=>$result['PcmhServices']['options']['Medication_4'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  <tr>
		    <td>5. Inform patients about drug-drug or dosage concerns.</td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.Medication_5',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][Medication_5]','value'=>$result['PcmhServices']['options']['Medication_5'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  
		  <tr>
		    <td><?php echo $this->Html->link('Cervical cancer screening',array('controller'=>'MeaningfulReport','action'=>'patient_reminder','?'=>array('flag'=>'cancer'),'admin'=>false));?> </td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.cancerscreening',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][cancerscreening]','value'=>$result['PcmhServices']['options']['cancerscreening'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td><?php echo $this->Html->link('Influenza vaccination',array('controller'=>'MeaningfulReport','action'=>'patient_reminder','?'=>array('flag'=>'influenza'),'admin'=>false));?></td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.influenzavaccin',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][influenzavaccin]','value'=>$result['PcmhServices']['options']['influenzavaccin'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  <tr>
		    <td><?php echo $this->Html->link('Smoking',array('controller'=>'MeaningfulReport','action'=>'patient_reminder','?'=>array('flag'=>'smoking'),'admin'=>false));?></td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.smoking',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][smoking]','value'=>$result['PcmhServices']['options']['smoking'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  <tr>
		    <td><?php echo $this->Html->link('Diabetes',array('controller'=>'MeaningfulReport','action'=>'patient_reminder','?'=>array('flag'=>'diabetes'),'admin'=>false));?></td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.diabetes',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][diabetes]','value'=>$result['PcmhServices']['options']['diabetes'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  <tr>
		    <td><?php echo $this->Html->link('High Blood Pressure',array('controller'=>'MeaningfulReport','action'=>'patient_reminder','?'=>array('flag'=>'highbp'),'admin'=>false));?></td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.highBP',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][highBP]','value'=>$result['PcmhServices']['options']['highBP'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  <tr>
		    <td><?php echo $this->Html->link('Depression',array('controller'=>'MeaningfulReport','action'=>'patient_reminder','?'=>array('flag'=>'depression'),'admin'=>false));?></td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.depression',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][depression]','value'=>$result['PcmhServices']['options']['depression'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td><?php echo $this->Html->link('Coronary Artery Disease care',array('controller'=>'reports','action'=>'admin_patient_list','?'=>array('flag'=>'problem')));?></td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.coronaryArtery',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][coronaryArtery]','value'=>$result['PcmhServices']['options']['coronaryArtery'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td><?php echo $this->Html->link('Lab Values outside normal range',array('controller'=>'Laboratories','action'=>'lab_manager','admin'=>false));?></td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.labOutofNormal',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][labOutofNormal]','value'=>$result['PcmhServices']['options']['labOutofNormal'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td><?php echo $this->Html->link('Post Hospitalization follow up appointments',array('controller'=>'reports','action'=>'admin_patient_list','?'=>array('flag'=>'problem')));?></td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.postAppts',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][postAppts]','value'=>$result['PcmhServices']['options']['postAppts'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td><?php echo $this->Html->link('Asthma',array('controller'=>'reports','action'=>'admin_patient_list','?'=>array('flag'=>'problem')));?></td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.asthma',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][asthma]','value'=>$result['PcmhServices']['options']['asthma'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td><?php echo $this->Html->link('Chronic back pain',array('controller'=>'reports','action'=>'admin_patient_list','?'=>array('flag'=>'problem')));?></td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.backPain',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][backPain]','value'=>$result['PcmhServices']['options']['backPain'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td><?php echo $this->Html->link('Otitis media',array('controller'=>'reports','action'=>'admin_patient_list','?'=>array('flag'=>'problem')));?></td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.otitis_media',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][otitis_media]','value'=>$result['PcmhServices']['options']['otitis_media'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td><?php echo $this->Html->link('Colonic cancer',array('controller'=>'reports','action'=>'admin_patient_list','?'=>array('flag'=>'problem')));?></td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.colonicCancer',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][colonicCancer]','value'=>$result['PcmhServices']['options']['colonicCancer'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td><?php echo $this->Html->link('3 more Cancer screening, including age- and sex-appropriate screenings, such as colorectal screening for men and mammograms for women',array('controller'=>'reports','action'=>'admin_patient_list','?'=>array('flag'=>'problem')));?></td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.cancerScreening',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][cancerScreening]','value'=>$result['PcmhServices']['options']['cancerScreening'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td><?php echo $this->Html->link('Osteoporosis screening for appropriate populations',array('controller'=>'reports','action'=>'admin_patient_list','?'=>array('flag'=>'problem')));?></td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.osteoporosisScreening',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][osteoporosisScreening]','value'=>$result['PcmhServices']['options']['osteoporosisScreening'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td><?php echo $this->Html->link('Depression screening in adults or adolescents, or in patients with chronic conditions or co-morbidities',array('controller'=>'reports','action'=>'admin_patient_list','?'=>array('flag'=>'problem')));?></td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.depressionScreening',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][depressionScreening]','value'=>$result['PcmhServices']['options']['depressionScreening'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td colspan="5"><b>Other Preventive Care Services</b></td>
		  </tr>
		  
		  <tr>
		    <td><?php echo $this->Html->link('1. Well - Child visits',array('controller'=>'reports','action'=>'admin_patient_list','?'=>array('flag'=>'problem')));?></td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.childVisit',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][childVisit]','value'=>$result['PcmhServices']['options']['childVisit'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td><?php echo $this->Html->link('2. Paediatric Child Screenings',array('controller'=>'reports','action'=>'admin_patient_list','?'=>array('flag'=>'problem')));?></td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.pediatricChild',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][pediatricChild]','value'=>$result['PcmhServices']['options']['pediatricChild'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td><?php echo $this->Html->link('3. Mammograms',array('controller'=>'reports','action'=>'admin_patient_list','?'=>array('flag'=>'problem')));?></td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.mammograms',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][mammograms]','value'=>$result['PcmhServices']['options']['mammograms'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td><?php echo $this->Html->link('4. Fasting Blood Sugar',array('controller'=>'reports','action'=>'admin_patient_list','?'=>array('flag'=>'problem')));?></td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.fastingSugar',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][fastingSugar]','value'=>$result['PcmhServices']['options']['fastingSugar'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td><?php echo $this->Html->link('5. Stress Tests',array('controller'=>'reports','action'=>'admin_patient_list','?'=>array('flag'=>'problem')));?></td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.stressTest',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][stressTest]','value'=>$result['PcmhServices']['options']['stressTest'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  
		  
		  
		  
		  
		  
		  <tr>
		    <td colspan="5"><b>Element 4C: Medication Management</b></td>
		  </tr>
		  <tr>
		    <td>1. Reviews and Reconciles Medications for more then 50% of Patients Received from Care Transition .</td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.reconsile_med',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][reconsile_med]','value'=>$result['PcmhServices']['options']['reconsile_med'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td>2. Scenario 1:  Patient Already Registered in PCMH EMR:  Go to Medication Reconciliation.</td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.reconsile_med_sr1',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][reconsile_med_sr1]','value'=>$result['PcmhServices']['options']['reconsile_med_sr1'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td>3. Scenario 2: Register Patient in PCMH EMR. Go to Reconcile Medications module in EMR </td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.reconsile_med_sr2',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][reconsile_med_sr2]','value'=>$result['PcmhServices']['options']['reconsile_med_sr2'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td>4. EMR Logs when Physician Completes Medications Reconciliation (Custom Feature)  </td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.reconsile_med_cmplete',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][reconsile_med_cmplete]','value'=>$result['PcmhServices']['options']['reconsile_med_cmplete'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td>5. EMR Logs when Patient has Care Transition (Structured Data Element:  Custom Feature) </td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.emrlog_ptcare_transition',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][emrlog_ptcare_transition]','value'=>$result['PcmhServices']['options']['emrlog_ptcare_transition'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		   <tr>
		    <td>6. Clinic generates Medications Reconciliation Report by Date Range to validate that > 80% of patients at Transitions of Care get their Medications Reconciled </td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.med_reconsile_date',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][med_reconsile_date]','value'=>$result['PcmhServices']['options']['med_reconsile_date'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td>7. Clinic generates Medications Reconciliation Report by Date Range for all patients at Relevant Visits </td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.med_reconsile_date_visit',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][med_reconsile_date_visit]','value'=>$result['PcmhServices']['options']['med_reconsile_date_visit'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td>8. Clinic generates Medications Reconciliation Report by Date Range for all patients Annually </td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.med_reconsile_date_annually',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][med_reconsile_date_annually]','value'=>$result['PcmhServices']['options']['med_reconsile_date_annually'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td>9. Clinic Generates New Medications Information Report to validate that >80% of Patients Received Information on New Medications </td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.new_med_info',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][new_med_info]','value'=>$result['PcmhServices']['options']['new_med_info'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td>10. EMR Logs the Reasons for not taking Medications as Prescribed (Structured Data Element) with Date Stamp (Custom Feature) </td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.not_taking_med',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][not_taking_med]','value'=>$result['PcmhServices']['options']['not_taking_med'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td>11. Clinic Generates Report that Assessment is done for >50% of Patients their Response to Medications and Barriers to Adherence </td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.report_assessment_done',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][report_assessment_done]','value'=>$result['PcmhServices']['options']['report_assessment_done'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td>12. EMR Logs in Initial Assessment Section, all OTC Medications (Custom Feature) </td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.emrlogs_allotc',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][emrlogs_allotc]','value'=>$result['PcmhServices']['options']['emrlogs_allotc'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td>13. EMR Logs when New Medication information is printed and given to Patient/Familieis/CareGiver </td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.medInfoToPt',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][medInfoToPt]','value'=>$result['PcmhServices']['options']['medInfoToPt'],'legend'=>false,'label'=>false));?></td>
		  </tr>

		  <tr>
		    <td>14. EMR Logs when Medication Information is Explained to the Patient considering their health literacy and date stamps assessment </td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.medInfoHealthLiteracy',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][medInfoHealthLiteracy]','value'=>$result['PcmhServices']['options']['medInfoHealthLiteracy'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td>15. EMR Logs when Patient has Difficulty in taking Medications as prescribed with Date Stamp </td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.emrlogs_medDiff',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][emrlogs_medDiff]','value'=>$result['PcmhServices']['options']['emrlogs_medDiff'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td>16. EMR Logs when Patient has Side Effects when taking Medications as prescribed with Date Stamp </td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.emrlogs_sideEff',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][emrlogs_sideEff]','value'=>$result['PcmhServices']['options']['emrlogs_sideEff'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td>17. EMR Logs whether Patient is taking Medications as prescribed with Date Stamp </td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.emrlogs_takingMed',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][emrlogs_takingMed]','value'=>$result['PcmhServices']['options']['emrlogs_takingMed'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td>18. EMR Logs in Initial Assessment Section, all Supplements </td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.emrlogs_iniAssSupp',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][emrlogs_iniAssSupp]','value'=>$result['PcmhServices']['options']['emrlogs_iniAssSupp'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td>19. EMR Logs in Initial Assessment Section, all Herbal Therapies </td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.emrlogs_iniAssHerbal',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][emrlogs_iniAssHerbal]','value'=>$result['PcmhServices']['options']['emrlogs_iniAssHerbal'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td>20. EMR Logs when Clinic Assesses the interactions of Medictions with OTC Medications, Supplements, and Herbal Therapies </td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.emrlogs_interactOTCMed',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][emrlogs_interactOTCMed]','value'=>$result['PcmhServices']['options']['emrlogs_interactOTCMed'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td>21. EMR Adds a Structured Data Element on how Non-Formularies are Handeld by Physician </td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.emrlogs_structDataHandle',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][emrlogs_structDataHandle]','value'=>$result['PcmhServices']['options']['emrlogs_structDataHandle'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td>22. Physician Assesses the Use of Non-Formularies and Changes Order if needed (Structured Data Element -- All are Formularies, Continued with Non-Formulary, Changed to Formulary) </td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.emrlogs_phyAccess',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][emrlogs_phyAccess]','value'=>$result['PcmhServices']['options']['emrlogs_phyAccess'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  
		  <tr>
		    <td>23. EMR Logs when Clinic Assesses the interactions of Medictions with OTC Medications, Supplements, and Herbal Therapies </td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.emrlogs_interactOTCMed',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][emrlogs_interactOTCMed]','value'=>$result['PcmhServices']['options']['emrlogs_interactOTCMed'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td>24. Clinic will Generate Abnormal Lab Test Results Report Daily or On Demand (CRITICAL) </td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.emrlogs_abnrmlLab',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][emrlogs_abnrmlLab]','value'=>$result['PcmhServices']['options']['emrlogs_abnrmlLab'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td>25. Clinic will Generate Over Due Lab Test Results Report Daily or On Demand (CRITICAL) </td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.emrlogs_overDuLab',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][emrlogs_overDuLab]','value'=>$result['PcmhServices']['options']['emrlogs_overDuLab'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td>26. Clinic will Generate Over Due Radiology Test Results Report Daily or On Demand (CRITICAL) </td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.emrlogs_overDuRad',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][emrlogs_overDuRad]','value'=>$result['PcmhServices']['options']['emrlogs_overDuRad'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		 
		  <tr>
		    <td colspan="5"><b>CCDA</b></td>
		  </tr>
		  
		  <tr>
		    <td>1. Transitions of Care that are Documented in EMRs with Electronic Discharge Summaries from Hospitals and Other Facilities </td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.transitioncare',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][transitioncare]','value'=>$result['PcmhServices']['options']['transitioncare'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td>2. Patient Hospitalizations during which Clinic Exchanged Patient Information with Hospital </td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.clinicExchange',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][clinicExchange]','value'=>$result['PcmhServices']['options']['clinicExchange'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td colspan="5"><b>Element 4D: Use Electronic Prescribing</b></td>
		  </tr>
		  <tr>
		    <td colspan="5"><b> Performs patient-specific checks for drug-drug and drug-allergy interactions</b></td>
		  </tr>
		  <tr>
		    <td>1. When a new prescription request is entered, the practice’s electronic prescribing system alerts the clinician to potentially harmful, patient-specific interactions between drugs or to a patient’s drug allergy</td>
		    <td align="center"><?php echo $this->Form->radio('PcmhServices.interaction',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][interaction]','value'=>$result['PcmhServices']['options']['interaction'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  <tr>
		    <td colspan="5"><b> Alerts prescribers to generic alternatives</b></td>
		  </tr>
		  <tr>
		    <td>1. The system alerts the clinician to cost-effective, generic options to name-brand medications</td>
		    <td align="center"><?php echo $this->Form->radio('PcmhServices.generic_alternative',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][generic_alternative]','value'=>$result['PcmhServices']['options']['generic_alternative'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td colspan="5"><b>Alerts prescribers to formulary status++</b></td>
		  </tr>
		  <tr>
		    <td>1. The system connects with or downloads the formulary for the patient's health plan to identify covered drugs and the copayment tier, if applicable.</td>
		    <td align="center"><?php echo $this->Form->radio('PcmhServices.formulary_status',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][formulary_status]','value'=>$result['PcmhServices']['options']['formulary_status'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td colspan="5"><b>Element 4E: Support Self-Care and Shared Decision Making</b></td>
		  </tr>
		  <tr>
		    <td>1. Practice Uses EHR to provide Patient-specific Education Resources and EMR Logs it (Custom Feature) </td>
		    <td align="center"><?php echo $this->Form->radio('PcmhServices.provide_resource_emr',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][provide_resource_emr]','value'=>$result['PcmhServices']['options']['provide_resource_emr'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td>2. Clinic Generates a Report to validate that >10% of Patients received Patient-Specific Education Resources for Self-Care & Shared Decision Making </td>
		    <td align="center"><?php echo $this->Form->radio('PcmhServices.report_provide_resource_emr',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][report_provide_resource_emr]','value'=>$result['PcmhServices']['options']['report_provide_resource_emr'],'legend'=>false,'label'=>false));?></td>
		  </tr>
		  
		  <tr>
		    <td colspan="5"><b>Element 5A:  Test tracking and follow-up</b></td>
		  </tr>
		 
		 <tr>
	    	<td><?php echo $this->Html->link('1. Clinic has a Documented Process for Tracking and Responding to Over Due Lab Test Results (Manual/Patient Portal/Email Alert with URL to Patient Portal)',array('controller'=>'Laboratories','action'=>'labOverdueTestReport','admin'=>false));?> </td>
	    	<td align="center"><?php echo $this->Form->radio('PcmhServices.track_respond_labtest',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][track_respond_labtest]','value'=>$result['PcmhServices']['options']['track_respond_labtest'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		 
		 <tr>
	    	<td><?php echo $this->Html->link('2. Clinic has a Documented Process for Tracking and Responding to Over Due Radiology Test Results (Manual/Patient Portal/Email Alert with URL to Patient Portal)',array('controller'=>'Radiologies','action'=>'radOverdueTestReport','admin'=>false));?> </td>
	    	<td align="center"><?php echo $this->Form->radio('PcmhServices.track_respond_radtest',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][track_respond_radtest]','value'=>$result['PcmhServices']['options']['track_respond_radtest'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		 
		 <tr>
	    	<td><?php echo $this->Html->link('3. Clinic will Generate Abnormal Radiology Test Results Report Daily or On Demand (CRITICAL)',array('controller'=>'Laboratories','action'=>'labAbnormalTestReport','admin'=>false));?> </td>
	    	<td align="center"><?php echo $this->Form->radio('PcmhServices.abnormal_radtest_result',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][abnormal_radtest_result]','value'=>$result['PcmhServices']['options']['abnormal_radtest_result'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		 
		 <tr>
	    	<td><?php echo $this->Html->link('4. Clinic has a Documented Process for Tracking and Responding to Abnormal Radiology Test Results (Manual/Patient Portal/Email Alert with URL to Patient Portal)',array('controller'=>'Radiologies','action'=>'radAbnormalTestReport','admin'=>false));?> </td>
	    	<td align="center"><?php echo $this->Form->radio('PcmhServices.track_respond_abnrml_radtest',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][track_respond_abnrml_radtest]','value'=>$result['PcmhServices']['options']['track_respond_abnrml_radtest'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		 
		 <tr>
	    	<td>5. Clinic Generates Report to Validate that >30% of Lab Test Orders are captured in EMR </td>
	    	<td align="center"><?php echo $this->Form->radio('PcmhServices.validate_labtest',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][validate_labtest]','value'=>$result['PcmhServices']['options']['validate_labtest'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		 
		 <tr>
	    	<td>6. Clinic Generates Report to Validate that >30% of Radiology Test Orders are captured in EMR </td>
	    	<td align="center"><?php echo $this->Form->radio('PcmhServices.validate_radtest',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][validate_radtest]','value'=>$result['PcmhServices']['options']['validate_radtest'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		 
		 <tr>
	    	<td>7. Clinic Generates Report to Validate that >55% of Lab Test Results are captured in EMR as Structured Data Elements </td>
	    	<td align="center"><?php echo $this->Form->radio('PcmhServices.reoprt_55labtest',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][reoprt_55labtest]','value'=>$result['PcmhServices']['options']['reoprt_55labtest'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		 
		 <tr>
	    	<td>8. Clinic Generates Report to Validate that >55% of Radiology Test Results are captured in EMR as Structured Data Elements </td>
	    	<td align="center"><?php echo $this->Form->radio('PcmhServices.reoprt_55radtest',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][reoprt_55radtest]','value'=>$result['PcmhServices']['options']['reoprt_55radtest'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		 
		 <tr>
	    	<td>9. Clinic Generates Report to Validate that EMR contains images (URL & PDF) from >10% of Scans/Radiology Tests that Generate Images </td>
	    	<td align="center"><?php echo $this->Form->radio('PcmhServices.reoprt_urlpdf',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][reoprt_urlpdf]','value'=>$result['PcmhServices']['options']['reoprt_urlpdf'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		 
		 <tr>
		    <td colspan="5"><b>Element 5B: Referral Tracking and Follow-Up (All Must Be Met)</b></td>
		 </tr>
		 <tr>
		    <td>1. Clinic Generates a Report of Over Due Summary of Care Reports from Referred Specialists/Consultants </td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.report_specialist',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][report_specialist]','value'=>$result['PcmhServices']['options']['report_specialist'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		 
		 <tr>
		    <td>2. Clinic has a Documents Process for Following up with Specialists/Consultants to Remind them to Send Electronic Summary of Care Reports </td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.doc_process_send_elec',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][doc_process_send_elec]','value'=>$result['PcmhServices']['options']['doc_process_send_elec'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		 
		  <tr>
		    <td>3. Clinic Generates a Report Showing the Actions Taken by PCP to Track the Over Due Reports from Specialists/Consultants </td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.report_action',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][report_action]','value'=>$result['PcmhServices']['options']['report_action'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		 
		 <tr>
		    <td>4. Clinic has Documented Co-Management Agreements in place with SLAs for Timely Sharing of Patient Status, Treatment Plan into both EMRs </td>
			<td align="center"><?php echo $this->Form->radio('PcmhServices.doc_agreement',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][doc_agreement]','value'=>$result['PcmhServices']['options']['doc_agreement'],'legend'=>false,'label'=>false));?></td>
		 </tr>
		 
		 
		 
		<tr>
		    <td colspan="5"><b>Element 5C: Coordinate Care Transitions</b></td>
		</tr>
		<tr>
	    	<td><?php echo $this->Html->link('Shares clinical information with admitting hospitals and emergency departments',array('controller'=>'Messages','action'=>'patientList','admin'=>false));?> </td>
	    	<td align="center"><?php echo $this->Form->radio('PcmhServices.shair_information',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][shair_information]','value'=>$result['PcmhServices']['options']['shair_information'],'legend'=>false,'label'=>false));?></td>
		</tr>  
		<tr>
	    	<td><?php echo $this->Html->link('Consistently obtains patient discharge summaries from the hospital and other facilities',array('controller'=>'Messages','action'=>'patientList','admin'=>false));?> </td>
	    	<td align="center"><?php echo $this->Form->radio('PcmhServices.discharge_summry',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][discharge_summry]','value'=>$result['PcmhServices']['options']['discharge_summry'],'legend'=>false,'label'=>false));?></td>
		</tr>
		<tr>
	    	<td><?php echo $this->Html->link('Exchanges patient information with the hospital during a patient’s hospitalization',array('controller'=>'Messages','action'=>'patientList','admin'=>false));?> </td>
	    	<td align="center"><?php echo $this->Form->radio('PcmhServices.exchange_info_hospitalization',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][exchange_info_hospitalization]','value'=>$result['PcmhServices']['options']['exchange_info_hospitalization'],'legend'=>false,'label'=>false));?></td>
		</tr>
		<tr>
	    	<td><?php echo $this->Html->link('Exchanges key clinical information with facilities and provides an electronic summary-of-care record to another care facility for more than 50 percent of patient transitions of care',array('controller'=>'Messages','action'=>'patientList','admin'=>false));?> </td>
	    	<td align="center"><?php echo $this->Form->radio('PcmhServices.exchange_info_transaction',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][exchange_info_transaction]','value'=>$result['PcmhServices']['options']['exchange_info_transaction'],'legend'=>false,'label'=>false));?></td>
		</tr>
		
		
		
		
		<tr>
		    <td><b>Provide Access to Legal Guardians to access Patient's Health Information (They can print or send secure Direct email to other care givers)</b></td>
		 	<td align="center"><?php echo $this->Form->radio('PcmhServices.accessInfo_guardian',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][accessInfo_guardian]','value'=>$result['PcmhServices']['options']['accessInfo_guardian'],'legend'=>false,'label'=>false));?></td>
		</tr>
		
		<tr>
		    <td><b>EMR allows Clinic to Enter into EMR the Immunizations done by Other Service Providers (1C14 mandate) (Custom Feature)</b></td>
		 	<td align="center"><?php echo $this->Form->radio('PcmhServices.allow_emr_entry',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][allow_emr_entry]','value'=>$result['PcmhServices']['options']['allow_emr_entry'],'legend'=>false,'label'=>false));?></td>
		</tr>
		
		<tr>
		    <td><b>EMR sends HL7 message to Immunization Registries as needed (Standard)</b></td>
		 	<td align="center"><?php echo $this->Form->radio('PcmhServices.send_hl7_message',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][send_hl7_message]','value'=>$result['PcmhServices']['options']['send_hl7_message'],'legend'=>false,'label'=>false));?></td>
		</tr>
		
		
		
		<tr>
		    <td><?php echo $this->Html->link('EMR Generates an Alert for Abnormal Lab Test Results to Physician (Required) (Custom Feature)',array('controller'=>'Appointments','action'=>'appointments_management','admin'=>false));?></td>
		 	<td align="center"><?php echo $this->Form->radio('PcmhServices.alert_abnormal_lab_test',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][alert_abnormal_lab_test]','value'=>$result['PcmhServices']['options']['alert_abnormal_lab_test'],'legend'=>false,'label'=>false));?></td>
		</tr>
		
		<tr>
		    <td><?php echo $this->Html->link('EMR Generates an Alert for Abnormal RadiologyTest Results to Physician (Required) (Custom Feature)',array('controller'=>'Appointments','action'=>'appointments_management','admin'=>false));?></td>
		 	<td align="center"><?php echo $this->Form->radio('PcmhServices.abnormal_radiology_test_required',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][abnormal_radiology_test_required]','value'=>$result['PcmhServices']['options']['abnormal_radiology_test_required'],'legend'=>false,'label'=>false));?></td>
		</tr>
		
		<tr>
		    <td><b>EMR Logs Over Due Radiology Test Results (CRITICAL) (Custom Feature)</b></td>
		 	<td align="center"><?php echo $this->Form->radio('PcmhServices.overdue_radiology_test',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][overdue_radiology_test]','value'=>$result['PcmhServices']['options']['overdue_radiology_test'],'legend'=>false,'label'=>false));?></td>
		</tr>
		
		<tr>
		    <td><b>EMR Generates an Alert for Over Due Radiology Test Results (Preferred) (Custom Feature)</b></td>
		 	<td align="center"><?php echo $this->Form->radio('PcmhServices.overdue_radiology_test_preferd',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][overdue_radiology_test_preferd]','value'=>$result['PcmhServices']['options']['overdue_radiology_test_preferd'],'legend'=>false,'label'=>false));?></td>
		</tr>
		
		
		
		<tr>
		    <td><b>EMR Logs when Images for Scans/Radiology Tests are stored in EMR (Custom Feature)</b></td>
		 	<td align="center"><?php echo $this->Form->radio('PcmhServices.logs_stored_emr',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][logs_stored_emr]','value'=>$result['PcmhServices']['options']['logs_stored_emr'],'legend'=>false,'label'=>false));?></td>
		</tr>
		
		<tr>
		    <td><b>EMR Logs Over Due Summary of Care Reports from Referred Specialists</b></td>
		 	<td align="center"><?php echo $this->Form->radio('PcmhServices.overdue_care_report',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][overdue_care_report]','value'=>$result['PcmhServices']['options']['overdue_care_report'],'legend'=>false,'label'=>false));?></td>
		</tr>
		
		<tr>
		    <td><b>EMR Alerts to Physician when Summary of Care Documents are Over Due from Specialists (Custom Feature)</b></td>
		 	<td align="center"><?php echo $this->Form->radio('PcmhServices.alert_care_doc_overdue',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][alert_care_doc_overdue]','value'=>$result['PcmhServices']['options']['alert_care_doc_overdue'],'legend'=>false,'label'=>false));?></td>
		</tr>
		
		<tr>
		    <td><b>EMR Logs when a Clinic Exchanges Summay of Care of its Patient with Hospitals and Other Facilities as Structured Data Element (Custom Feature)</b></td>
		 	<td align="center"><?php echo $this->Form->radio('PcmhServices.exchange_summary_log',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][exchange_summary_log]','value'=>$result['PcmhServices']['options']['exchange_summary_log'],'legend'=>false,'label'=>false));?></td>
		</tr>
		
		<tr>
		    <td><b>EMR Logs when Clinic Exchanges Clinical Information including Electronic Summary of Care to another Facility</b></td>
		 	<td align="center"><?php echo $this->Form->radio('PcmhServices.exchange_info_log',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][exchange_info_log]','value'=>$result['PcmhServices']['options']['exchange_info_log'],'legend'=>false,'label'=>false));?></td>
		</tr>
		
		
		
		
		<tr>
		    <td>EMR Validates the Medictions Ordered against List of Formularies in Surescripts database for the Insurer and Flags Non-Formularies (Standard)</td>
		 	<td align="center"><?php echo $this->Form->radio('PcmhServices.emr_validate_med',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][emr_validate_med]','value'=>$result['PcmhServices']['options']['emr_validate_med'],'legend'=>false,'label'=>false));?></td>
		</tr>
		
		<tr>
		    <td>EMR Logs when an Order is Submitted Electronically (Standard)</td>
		 	<td align="center"><?php echo $this->Form->radio('PcmhServices.emr_logs_electr',array('Yes'=>'Yes','No'=>'No'),array('name'=>'data[PcmhServices][options][emr_logs_electr]','value'=>$result['PcmhServices']['options']['emr_logs_electr'],'legend'=>false,'label'=>false));?></td>
		</tr>
		
		
		
		
		
			
	</table>
	<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
		<tr>
		<td align="right"><?php echo $this->Form->submit(__('Submit'),array('class'=>'blueBtn','div'=>false,'label'=>false)); ?></td>
		</tr>
	</table>
<br />
<?php echo $this->Form->end();?>
 <script>
	$(function() {
		$("#startdate").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',
			maxDate: new Date(),
			dateFormat: 'mm/dd/yy',			
		});	

	});
	jQuery(document).ready(function(){
		// binds form submission and fields to the validation engine
		jQuery("#automatedmeasurecalfrm").validationEngine();
		
 });
 
</script>