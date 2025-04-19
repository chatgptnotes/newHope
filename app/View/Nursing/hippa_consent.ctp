<?php 
echo $this->Html->script(array('ui.timepicker.js?v=0.3.1'));
echo $this->Html->css(array('ui.ui.timepicker'));?>
<?php echo $this->Html->script(array('jquery.signaturepad.min'));
  	echo $this->Html->css(array('jquery.signaturepad'));?>
	<script>
    $(document).ready(function() {
      $('.sigPad').signaturePad();
    });
  </script>
  <script>
	/*jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
		jQuery("#hippaconsent_frm").validationEngine();
	});*/
</script>
 <?php  if($status == "success"){?>
<script> 
jQuery(document).ready(function(){ 
	parent.$.fancybox.close(); 
 	});
</script>
<?php  } ?>
<style>
.formError .formErrorContent {
	width: 60px;
}
.inner{padding-left:8px;line-height: 2; /*padding-bottom:10px;*/}
.hindi-para {
	font-size: 13px;border:1px solid #4D5F66;
}
.hindi-para h4{ margin:0px; padding:0 0 0 10px;}
.tabularForm {
	margin: 10px;
}
td{ font-size:13px;}
.textBoxExpnd {
	padding: 3px;
}
.inner_title{ padding:10px;}
.date img{float:inherit}
</style>
<div class="inner_title">
	<h3>
		<?php 
		 echo __('HIPAA Consent'); ?>
		 <?php echo ($insurance_name['InsuranceCompany']['name']);?>
	</h3>
	<span><?php  //echo $this->Html->link(__('Back'), array('action' => 'patient_information', $patient['Patient']['id']), array('escape' => false,'class'=>"blueBtn"));?>
	</span>
</div>

<div class="clr ht5"></div>
<?php //echo $this->element('patient_information');?>
<div style="border:1px solid #4D5F66; padding: 0 0 10px 10px;"><table><tr><td><?php echo ('Doctor :');?><?php echo $patient['User']['first_name'].' '.$patient['User']['last_name']?></td></tr>
<tr><td><?php echo ('Hospital Address :');?><?php echo $address2['Location']['address1']?></td></tr></table></div>
<div class="clr ht5"></div>
<?php echo $this->Form->create('HippaConsent',array('id'=>'hippaconsent_frm'));?>
<?php echo $this->Form->hidden('id');?>
<div class="hindi-para"><h4>HIPAA Authorization Form</h4>
<div style="border:1px solid #4D5F66">
<table><tr><td class="inner">I, <strong><?php echo $patient['0']['lookup_name']?></strong></td><td> whose date of birth is</td>
	<td><?php echo $this->DateFormat->formatDate2local($patient['Person']['dob'],Configure::read('date_format'),false) ?> authorize <strong><?php echo $patient['User']['first_name'].' '.$patient['User']['last_name']?></strong> to disclose to and/or obtain from 
	<strong><?php //echo $insurance_name['InsuranceCompany']['name']?></strong>
	<?php echo $this->Form->input('obtain_input', array('type' => 'text', 'id' => 'obtain_input', 'label'=> false,'div' => false,'value'=>$insurance_name['InsuranceCompany']['name'],'adonly'=>'readonly', 'error' => false)); ?> &nbsp;the following information :</td></tr></table>
<table><tr><td style="padding:0 0 0 10px;"><strong>Description of information to be Disclosed</strong></td></tr></table>
<table><tr><td style="padding:0 0 0 10px;">(patient/Client should initial each item to be Disclosed.)</td></tr>

<tr><td style="padding:0 0 0 10px;"><?php if($advanceData['AdvanceDirective']['assesment_check'] == 1){echo $this->Form->checkbox('assesment_check', array('checked' => 'checked', 'disabled' => 'disabled'));
}else{echo $this->Form->checkbox('assesment_check');}?>Assessment </td>
		<td>  <?php if($advanceData['AdvanceDirective']['testing_info_check'] == 1){echo $this->Form->checkbox('testing_info_check', array('checked' => 'checked', 'disabled' => 'disabled'));
}else{echo $this->Form->checkbox('testing_info_check');}?>Testing Information</td></tr> 

<tr><td style="padding:0 0 0 10px;"><?php if($advanceData['AdvanceDirective']['diagnosis_check'] == 1){echo $this->Form->checkbox('diagnosis_check', array('checked' => 'checked', 'disabled' => 'disabled'));
}else{echo $this->Form->checkbox('diagnosis_check');}?>Diagnosis</td>
<td><?php if($advanceData['AdvanceDirective']['edu_info_check'] == 1){echo $this->Form->checkbox('edu_info_check', array('checked' => 'checked', 'disabled' => 'disabled'));
}else{echo $this->Form->checkbox('edu_info_check');}?>Educational Information</td></tr>
<tr><td style="padding:0 0 0 10px;"><?php  if($advanceData['AdvanceDirective']['psy_eval_check'] == 1){echo $this->Form->checkbox('psy_eval_check', array('checked' => 'checked', 'disabled' => 'disabled'));
}else{echo $this->Form->checkbox('psy_eval_check');}?>Psychosocial Evaluation</td>
<td><?php if($advanceData['AdvanceDirective']['parti_treat_check'] == 1){echo $this->Form->checkbox('parti_treat_check', array('checked' => 'checked', 'disabled' => 'disabled'));
}else{echo $this->Form->checkbox('parti_treat_check');}?>Presence/Participation  in Treatment</td></tr>
<tr><td style="padding:0 0 0 10px;"><?php if($advanceData['AdvanceDirective']['conti_care_plan_check'] == 1){echo $this->Form->checkbox('conti_care_plan_check', array('checked' => 'checked', 'disabled' => 'disabled'));
}else{echo $this->Form->checkbox('conti_care_plan_check');}?> Continuing Care Plan</td>
<td><?php if($advanceData['AdvanceDirective']['treat_plan_check'] == 1){echo $this->Form->checkbox('treat_plan_check', array('checked' => 'checked', 'disabled' => 'disabled'));
}else{echo $this->Form->checkbox('treat_plan_check');}?>  Treatment Plan or summary </td></tr>
<tr><td style="padding:0 0 0 10px;"><?php if($advanceData['AdvanceDirective']['prog_treat_check'] == 1){echo $this->Form->checkbox('prog_treat_check', array('checked' => 'checked', 'disabled' => 'disabled'));
}else{echo $this->Form->checkbox('prog_treat_check');}?> Progress in Treatment </td>
<td><?php if($advanceData['AdvanceDirective']['curr_treat_update_check'] == 1){echo $this->Form->checkbox('curr_treat_update_check', array('checked' => 'checked', 'disabled' => 'disabled'));
}else{echo $this->Form->checkbox('curr_treat_update_check');}?> Current Treatment Update</td></tr>
<tr><td style="padding:0 0 10px 10px;"><?php if($advanceData['AdvanceDirective']['other_check'] == 1){echo $this->Form->checkbox('other_check', array('checked' => 'checked', 'disabled' => 'disabled'));
}else{echo $this->Form->checkbox('other_check');}?>Other</td></tr></table></div>

<div style="border:1px solid #4D5F66"><table>
<tr><td><h4>Purpose</h4></td></tr>
<tr><td class="inner">The purpose of this disclosure of information is to improve assessment and treatment planning, share information relevant to treatment and when appropriate, Coordinate treatment services. If other purpose, please specify;
<?php echo $this->Form->input('process_input', array('type' => 'text', 'id' => 'process_input', 'label'=> false,'div' => false,'style'=>"width:250px", 'error' => false)); ?></td></tr></table>
</div>
<div style="border:1px solid #4D5F66">
<table>
<tr><td><h4>Revocation</h4></td></tr><?php //echo $patient['User']['first_name'].' '.$patient['User']['last_name']?>
<tr><td class="inner">I understand that I have a right to revoke this authorization, in writing, at any time by sending written notification to &nbsp;<?php echo $this->Form->input('revocation_input', array('type' => 'text', 'id' => 'revocation_input', 'label'=> false,'div' => false,'value'=>$patient['User']['first_name'].' '.$patient['User']['last_name'], 'style'=>'','error' => false)); ?>&nbsp;at the above address. I further understand that a revocation of the authorization is not effective to the extent that action has been taken in reliance on the authorization.</td></tr></table>
</div>
<div style="border:1px solid #4D5F66">
<table>
<tr><td><h4>Expiration</h4></td></tr>
<tr><td class="inner">Unless sooner revoked, this authorization expires on &nbsp;
	<span class="date"><?php echo $this->Form->input('expi_date', array('type' => 'text', 'id' => 'expi_date', 'label'=> false,'div' => false, 'error' => false)); ?></span> &nbsp;or as otherwise indicated;</td><td class="inner"> <?php echo $this->Form->input('expi_input', array('type' => 'text', 'id' => 'process_input', 'label'=> false,'div' => false, 'style'=>'width:250px','error' => false)); ?>.</td></tr></table>
</div>
<div style="border:1px solid #4D5F66">
<table>
<tr><td><h4>Condition</h4></td></tr>
<tr><td class="inner">I further understand that &nbsp; <?php echo $this->Form->input('condi_input', array('type' => 'text', 'id' => 'condi_input', 'value'=>$patient['User']['first_name'].' '.$patient['User']['last_name'],'label'=> false,'div' => false, 'error' => false)); ?>&nbsp;will not condition my treatment on whether I give authorization for the requested disclosure. However, it has been explained to me that failure to sign this authorization may have the following  consequences: <?php echo $this->Form->input('condi_conse', array('type' => 'text', 'id' => 'condi_conse', 'label'=> false,'div' => false, 'style'=>"width:250px",'error' => false)); ?></td></tr></table>
</div>
<div style="border:1px solid #4D5F66">
<p><h4>Form of Disclosure</h4></p>
<p class="inner">Unless you have specifically requested in writing that the disclosure be made in a certain format, we reserve the right to disclose information as permitted by this authorization in any manner that we deem to be appropriate  and consistent with applicable law, including, but not limited to, verbally in paper format or electronically.</p>
</div>
<div style="border:1px solid #4D5F66">
<p><h4>Redisclosure</h4></p>
<p class="inner">I understand that there is the potential that the protected health information (PHI) that is disclosed pursuant to this authorization may be redisclosed by the recipient and the protected health information will no longer be protected by the HIPAA privacy regulations, unless a state law applies that is more strict than HIPAA and provides additional privacy protections. Other types of information may be re-disclosed by the recipient of the information in the following circumstances :<?php echo $this->Form->input('redisclosure', array('type' => 'text', 'id' => 'redisclosure', 'label'=> false,'div' => false,'style'=>"width:250px", 'error' => false)); ?></p>
 <p class="inner">I will be given a copy of this authorization for my  records. </p>

<table width="100%"><tr><td class="inner">signature of client <div >
                            	<?php 
                            	     if($this->data['HippaConsent']['client_sign'] != "") { 
                            	       echo $this->Html->image('/signpad/'.$this->data['HippaConsent']['client_sign'], array('alt' => 'Signature', 'title' => 'Signature', 'width' => '320', 'height' => '150'));
                            		 } else {
                            	?>
                              
                                <div class="sigPad">
	                               <ul class="sigNav">
	                                <li class="drawIt" ><a href="#draw-it"><font color="black">Draw It</font></a></li>
	                                <li class="clearButton"><a href="#clear"><font color="black">Clear</font></a></li>
	                               </ul>
                                <div>
                                <div class="typed"></div>
                                 <canvas class="pad" width="290" height="150"></canvas>
                                 <?php echo $this->Form->input('client_output', array('type' =>'hidden', 'id' => 'output', 'class' => 'output')); ?>
                                 </div>
                               </div>  
                               <?php } ?>
                               </div></td> <td>signature of Parent, Guardian or Personal Representative <div >
                            	<?php 
                            	     if($this->data['HippaConsent']['parent_sign'] != "") { 
                            	       echo $this->Html->image('/signpad/'.$this->data['HippaConsent']['parent_sign'], array('alt' => 'Signature', 'title' => 'Signature', 'width' => '320', 'height' => '150'));
                            		 } else {
                            	?>
                              
                                <div class="sigPad">
	                               <ul class="sigNav">
	                                <li class="drawIt" ><a href="#draw-it"><font color="black">Draw It</font></a></li>
	                                <li class="clearButton"><a href="#clear"><font color="black">Clear</font></a></li>
	                               </ul>
                                <div>
                                <div class="typed"></div>
                                 <canvas class="pad" width="290" height="150"></canvas>
                                 <?php echo $this->Form->input('parent_output', array('type' =>'hidden', 'id' => 'output', 'class' => 'output')); ?>
                                 </div>
                               </div>  
                               <?php } ?>
                               </div></td></tr>
                               
                               <tr>
									<td class="inner"><?php echo __('Date'); ?><font	color="red">*</font>
										<span class="date"><?php echo $this->Form->input('redis_client_date', array('class' => 'validate[required,custom[mandatory-enter-only]]','type' => 'text', 'id' => 'redis_client_date', 'label'=> false,'div' => false, 'error' => false)); ?></span>
									</td>
								</tr>


                             
      </tr></table>
<table>

<tr><td class="inner">If you are signing as a personal representative of an individual, please describe your authority to act for this individual. Attach appropriate document (power of attorney, temporary orders, healthcare surrogate, etc.</td> </tr>
<tr><td style="padding:0 0 0 10px;"><?php echo $this->Form->input('redisclosure_file',array('type' => 'text','style'=>'width:250px','label'=>false,'div'=>false));?>	</td></tr>


<tr><td><?php if($advanceData['AdvanceDirective']['redis_check'] == 1){echo $this->Form->checkbox('redis_check', array('checked' => 'checked', 'disabled' => 'disabled'));
}else{echo $this->Form->checkbox('redis_check');}?> Check  here if client refuses to sign authorization.</td></tr>


<tr><td class="inner">
      	<p class="">Sign of Witness</p>
        <div>
                            	<?php 
                            	     if($this->data['HippaConsent']['staff_sign'] != "") { 
                            	       echo $this->Html->image('/signpad/'.$this->data['HippaConsent']['staff_sign'], array('alt' => 'Signature', 'title' => 'Signature', 'width' => '320', 'height' => '150'));
                            		 } else {
                            	?>
                              
                                <div class="sigPad">
	                               <ul class="sigNav">
	                                <li class="drawIt" ><a href="#draw-it"><font color="black">Draw It</font></a></li>
	                                <li class="clearButton"><a href="#clear"><font color="black">Clear</font></a></li>
	                               </ul>
                                <div>
                                <div class="typed"></div>
                                 <canvas class="pad" width="290" height="150"></canvas>
                                 <?php echo $this->Form->input('staff_output', array('type' =>'hidden', 'id' => 'output', 'class' => 'output')); ?>
                                 </div>
                               </div>  
                               <?php } ?>
                               </div>
         </td>
         <tr>
<td class="inner"><?php echo __('Date'); ?><font	color="red">*</font>
	<span class="date"><?php echo $this->Form->input('staff_witness_date', array('class' => 'validate[required,custom[mandatory-enter-only]]','type' => 'text', 'id' => 'staff_witness_date', 'label'=> false,'div' => false, 'error' => false)); ?></span>
</td></tr></table> </div>

<!--  <p>I hereby authorize <strong><?php echo ucfirst($treating_consultant[0]['fullname']) ;?></strong>,and any associates or assistants of his
choice to perform upon me <strong><?php echo  ucfirst($patient[0]['lookup_name']) ;?></strong>.</p>

<p>I understand that the Procedure may serve in the progress of medical education therefore, I will allow/refuse  observers during my procedure. I also Consent/refuse  audio-visual documentation (photos/video0 of the procedure and its use for medical education and research. I understand that my privacy and identity will be protected at all times When I consent with the documentation .</p> 

<p>I recognize that during the course of the procedure, unforeseen conditions may necessitate additional or different procedures than those explained. I, therefore, further authorize and request my doctor and any associates or assistants of his choice perform such as are, in their professional judgement , necessary or appropriate for such procedures. </p>

<p>I understand that the proposed care may involves risks and possibilities of complications, and that certain complications have been known to follow the procedure to which I am consenting even when the utmost care, judgement and skill are used. I acknowledge that no guarantees have been made to me as to the results of the procedure, nor are there any guarantees against unfavourable results.</p>

<p>I accept the risks of substantial and serious harm, if any, in hopes of obtaining desired beneficial results of such care and acknowledge that the physicians involved have explained my condition, the proposed health care, and alternatives forms of treatment in a satisfactory manner.</p>

<p>The basic procedures of the proposed surgery, the advantages , disadvantages, risks, possible complications, and alternative treatments have been explained and discussed with me by my doctor. Although it is impossible for the doctor to inform me of every possible complication that may occur, the doctor has answered all my questions to  my satisfaction .<strong>In signing this consent form, I am stating I have read this form (or it has been read to me), and I fully understand it and the possible risks, complications and benefits that can result from the surgery. I also acknowledge that the doctor has addressed all of my concerns regarding this surgery</strong>.</p>

<p>
Patient's Name :  <?php echo  ucfirst($patient[0]['lookup_name']) ;?><br/>
Patient's Signature:___________________<br/>
Date:<font color="red">*</font> <input type="text" id="date1" name="TracheostomyConsent[date1]" class="date validate[required]" value=""><br/>
Witness' Signature : ________________<br/>
Doctor's Signature : ___________________<br/>
</p>
<p>
As parent , guardian, caretaker, next of kin or other legal representative responsible for the patient whose name appears above on the appropriate signature line, I have read this document and, to the limit of the patient's understanding, I have discussed this informed consent  and its terms with the patient. Due to the patient's inability to sign this informed consent, I agree , on behalf of the patient, to sign for the patient and bind him/her to the terms of this informed consent.</p>
<p>
Name : <input type="text" id="name" name="TracheostomyConsent[name]" value=""><br/>
Signature : ___________<br/>
Relationship to patient : <input type="text" name="TracheostomyConsent[relationship]" size="80"><br/>
Date:<font color="red">*</font> <input type="text" id="date2" name="TracheostomyConsent[date2]" class="date validate[required]" value=""> <br/>
</p>-->
</div>


<div class="btns">

	<input name="submit" type="submit" id="submit" value="Submit" class="blueBtn" />

</div>

<?php echo $this->Form->end();?>
<script>
/*jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#TracheostomyConsentTracheostomyConsentForm").validationEngine();
	});*/

	$('#submit').click(function() { 
		var validatePerson = jQuery("#hippaconsent_frm").validationEngine('validate');
		if (validatePerson) {$(this).css('display', 'none');
			return true;
		}else{
			return false;
		}
	});


$( ".date" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,
			yearRange: '1950',
			dateFormat:'<?php echo $this->General->GeneralDate();?>',
		});
$( "#expi_date" ).datepicker({
	showOn: "button",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	yearRange: '1950',			 
	dateFormat:'<?php echo $this->General->GeneralDate();?>',
	buttonText:'Date of Incident',
	onSelect: function(){
		var dateval = $("#intrinsic_date").val();
		var patientid = $("#patientid").val();
		$(this).focus();
		//window.location.href = '<?php echo $this->Html->url('/hospital_acquire_infections/index/'); ?>'+patientid+'/'+dateval;
       // $("#intrinsic_date").action = "<?php echo $this->Html->url('/hospital_acquire_infections/index'); ?>"
		//alert($( "#intrinsic_date" ).val());
	}

});

$( "#dob" ).datepicker({
	showOn: "button",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	yearRange: '1950',			 
	dateFormat:'<?php echo $this->General->GeneralDate();?>',
	buttonText:'Date of Incident',
	onSelect: function(){
		var dateval = $("#intrinsic_date").val();
		var patientid = $("#patientid").val();
		$(this).focus();
		//window.location.href = '<?php echo $this->Html->url('/hospital_acquire_infections/index/'); ?>'+patientid+'/'+dateval;
       // $("#intrinsic_date").action = "<?php echo $this->Html->url('/hospital_acquire_infections/index'); ?>"
		//alert($( "#intrinsic_date" ).val());
	}

});

$( "#staff_witness_date" ).datepicker({
	showOn: "button",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	yearRange: '1950',			 
	dateFormat:'<?php echo $this->General->GeneralDate();?>',
	buttonText:'Date of Incident',
	onSelect: function(){
		var dateval = $("#intrinsic_date").val();
		var patientid = $("#patientid").val();
		$(this).focus();
		//window.location.href = '<?php echo $this->Html->url('/hospital_acquire_infections/index/'); ?>'+patientid+'/'+dateval;
       // $("#intrinsic_date").action = "<?php echo $this->Html->url('/hospital_acquire_infections/index'); ?>"
		//alert($( "#intrinsic_date" ).val());
	}

});

$( "#redis_client_date" ).datepicker({
	showOn: "button",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	yearRange: '1950',			 
	dateFormat:'<?php echo $this->General->GeneralDate();?>',
	buttonText:'Date of Incident',
	onSelect: function(){
		var dateval = $("#intrinsic_date").val();
		var patientid = $("#patientid").val();
		$(this).focus();
		//window.location.href = '<?php echo $this->Html->url('/hospital_acquire_infections/index/'); ?>'+patientid+'/'+dateval;
       // $("#intrinsic_date").action = "<?php echo $this->Html->url('/hospital_acquire_infections/index'); ?>"
		//alert($( "#intrinsic_date" ).val());
	}

});
$( "#client_sign_date" ).datepicker({
	showOn: "button",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	yearRange: '1950',			 
	dateFormat:'<?php echo $this->General->GeneralDate();?>',
	buttonText:'Date of Incident',
	onSelect: function(){
		var dateval = $("#intrinsic_date").val();
		var patientid = $("#patientid").val();
		$(this).focus();
		//window.location.href = '<?php echo $this->Html->url('/hospital_acquire_infections/index/'); ?>'+patientid+'/'+dateval;
       // $("#intrinsic_date").action = "<?php echo $this->Html->url('/hospital_acquire_infections/index'); ?>"
		//alert($( "#intrinsic_date" ).val());
	}

});

</script>
