<?php 
	echo $this->Html->script(array('jquery.blockUI.js'));
?>
<style>
/*#busy-indicator {
    display: none;
    left: 50%;
    margin-top: 415px;
    position: absolute;
}*/
</style>
<div class="inner_title">
	<?php 
			$complete_name  = $patient[0]['lookup_name'] ;
			//echo __('Set Appoinment For-')." ".$complete_name;
	?> 
	<h3>  &nbsp; <?php echo __('Patient Information-')." ".$complete_name ?></h3>
	<span> <?php echo $this->Html->link(__('Search Patient'),array('action' => 'search'), array('escape' => false,'class'=>'blueBtn')); ?></span>
</div> 
<div class="patient_info">
 <?php echo $this->element('patient_information');?>
</div> 
<div class="clr"></div>
<div class="interIconLink" style="margin-right:10px;">
 <div class="icon">
  <?php echo $this->Html->link($this->Html->image('/img/icons/register.jpg', array('alt' => 'OR Appointment')),array("controller" => "opt_appointments", "action" => "otevent", "admin" => false, 'plugin' => false, $patient_id), array('escape' => false)); ?>
 </div>
 <div class="iconLink"><?php echo __('OR Appointment'); ?></div>
</div>
<div class="interIconLink" style="margin-right:10px;">
 <div class="icon">
  <?php echo $this->Html->link($this->Html->image('/img/icons/ward-management.jpg', array('alt' => 'Ward Management')),array("controller" => "wards", "action" => "ward_occupancy", "admin" => false, 'plugin' => false,'?' => array('Ward' => $ward_details['Ward']['id'], 'otpatientid' => $patient_id)), array('escape' => false)); ?>
 </div>
 <div class="iconLink"><?php echo __('Room Management'); ?></div>
</div>
<div class="interIconLink" style="margin-right:10px;">
 <div class="icon">
  <?php echo $this->Html->link($this->Html->image('/img/icons/advance-payment.jpg', array('alt' => 'Advance Payment')),array("controller" => "billings", "action" => "advancePayment", $patient_id,"admin" => false,'plugin' => false), array('escape' => false)); ?>
 </div>
 <div class="iconLink"><?php echo __('Advance Payment'); ?></div>
</div>
<div class="interIconLink" style="margin-right:10px;">
 <div class="icon">
  <?php //echo $this->Html->link($this->Html->image('/img/icons/anesthesia-consent-form.jpg', array('alt' => 'Anaesthesia Consent Form')),array("controller" => "opt_appointments", "action" => "anaesthesia_consent", "admin" => false,'plugin' => false, $patient_id), array('escape' => false));
  		echo $this->Html->link($this->Html->image('/img/icons/anesthesia-consent-form.jpg', array('alt' => 'Anaesthesia Consent Form','id'=>'Anaesthesia')),'javascript:void(0);', array('escape' => false));
  ?>
 </div>
 <div class="iconLink"><?php echo __('Anaesthesia Consent Form'); ?></div>
</div>
 <!-- <div class="interIconLink" style="margin-right:10px;">
 <div class="icon">
  <?php //echo $this->Html->link($this->Html->image('/img/icons/surgery-consent-form.jpg', array('alt' => 'Consent Form')),array("controller" => "opt_appointments", "action" => "surgery_consent", 'plugin' => false, $patient_id), array('escape' => false)); ?>
 </div>
 <div class="iconLink"><?php echo __('Consent Form'); ?></div>
</div>-->
<div class="interIconLink" style="margin-right:10px;">
 <div class="icon">
  <?php 
  		//echo $this->Html->link($this->Html->image('/img/icons/surgery-consentform.jpg', array('alt' => 'Surgery Consent Form')),array("controller" => "opt_appointments", "action" => "surgery_consentform", 'plugin' => false, $patient_id), array('escape' => false)); 
  		echo $this->Html->link($this->Html->image('/img/icons/surgery-consentform.jpg', array('alt' => 'Surgery Consent Form','id'=>'SurgeryConsent')),'javascript:void(0);', array('escape' => false));
  	?>
 </div>
 <div class="iconLink"><?php echo __('Surgery Consent Form'); ?></div>
</div>
<div class="interIconLink" style="margin-right:10px;">
 <div class="icon">
  <?php 
  //echo $this->Html->link($this->Html->image('/img/icons/interpreter-statement-form.jpg', array('alt' => 'Interpreter Statement')),array("controller" => "opt_appointments", "action" => "interpreter_statement", 'plugin' => false, $patient_id), array('escape' => false));
  echo $this->Html->link($this->Html->image('/img/icons/interpreter-statement-form.jpg', array('alt' => 'Interpreter Statement','id'=>'InterpreterStatement')),'javascript:void(0);', array('escape' => false));
  ?>
 </div>
 <div class="iconLink"><?php echo __('Interpreter Statement'); ?></div>
</div>
<div class="interIconLink" style="margin-right:10px;">
 <div class="icon">
  <?php 
  	//echo $this->Html->link($this->Html->image('/img/icons/consent-form.jpg', array('alt' => 'Patient Specific Consent Form')),array("controller" => "consents", "action" => "patient_specific_consent", "admin" => false,'plugin' => false, $patient_id), array('escape' => false));
  	echo $this->Html->link($this->Html->image('/img/icons/consent-form.jpg', array('alt' => 'Patient Specific Consent Form','id'=>'PatientSpecificConsent')),'javascript:void(0);', array('escape' => false));
  ?>
 </div>
 <div class="iconLink"><?php echo __('Patient Specific Consent Form'); ?></div>
</div>

<!-- <div class="interIconLink" style="margin-right:10px;">
 <div class="icon">
  <?php echo $this->Html->link($this->Html->image('/img/icons/investigation.jpg', array('alt' => 'Investigation')),array("controller" => "laboratories", "action" => "lab_order",'?'=>array('return'=>'ot'), "admin" => false,'plugin' => false, $patient_id), array('escape' => false)); ?>
 </div>
 <div class="iconLink"><?php echo __('Investigation'); ?></div>
</div> -->

<div class="interIconLink" style="margin-right:10px;">
 <div class="icon">
  <?php 
  		//echo $this->Html->link($this->Html->image('/img/icons/pre-operative-instruction.jpg', array('alt' => 'Pre Operative Checklist')),array("controller" => "opt_appointments", "action" => "ot_pre_operative_checklist", "admin" => false,'plugin' => false, $patient_id), array('escape' => false)); 
  		echo $this->Html->link($this->Html->image('/img/icons/pre-operative-instruction.jpg', array('alt' => 'Pre Operative Checklist','id'=>'PreOperativeChecklist')),'javascript:void(0);', array('escape' => false));
  	?>
 </div>
 <div class="iconLink"><?php echo __('Pre Operative Checklist'); ?></div>
</div>
<div class="interIconLink" style="margin-right:10px;">
 <div class="icon">
  <?php 
  		//echo $this->Html->link($this->Html->image('/img/icons/post-operative-instruction.jpg', array('alt' => 'Post Operative Checklist')),array("controller" => "opt_appointments", "action" => "ot_post_operative_checklist", "admin" => false,'plugin' => false, $patient_id), array('escape' => false));
  		echo $this->Html->link($this->Html->image('/img/icons/post-operative-instruction.jpg', array('alt' => 'Post Operative Checklist','id'=>'PostOperativeChecklist')),'javascript:void(0);', array('escape' => false));
  	 ?>
 </div>
 <div class="iconLink"><?php echo __('Post Operative Checklist'); ?></div>
</div>
<div class="interIconLink" style="margin-right:10px;">
 <div class="icon">
  <?php 
  		//echo $this->Html->link($this->Html->image('/img/icons/surgical-safety-checklist.jpg', array('alt' => 'Surgical Safety Checklist')),array("controller" => "opt_appointments", "action" => "surgical_safety_checklist", "admin" => false,'plugin' => false, $patient_id), array('escape' => false));
  		echo $this->Html->link($this->Html->image('/img/icons/surgical-safety-checklist.jpg', array('alt' => 'Surgical Safety Checklist','id'=>'SurgicalSafetyChecklist')),'javascript:void(0);', array('escape' => false));
   ?>
 </div>
 <div class="iconLink"><?php echo __('Surgical Safety Checklist'); ?></div>
</div>
<div class="interIconLink" style="margin-right:10px;">
 <div class="icon">
  <?php 
  		//echo $this->Html->link($this->Html->image('/img/icons/anaesthesia-notes.jpg', array('alt' => 'Anaesthesia Notes')),array("controller" => "opt_appointments", "action" => "anaesthesia_notes", "admin" => false,'plugin' => false, $patient_id), array('escape' => false));
  		echo $this->Html->link($this->Html->image('/img/icons/anaesthesia-notes.jpg', array('alt' => 'Anaesthesia Notes','id'=>'AnaesthesiaNotes')),'javascript:void(0);', array('escape' => false));
   ?>
 </div>
 <div class="iconLink"><?php echo __('Anaesthesia Notes'); ?></div>
</div>
<div class="interIconLink" style="margin-right:10px;">
 <div class="icon">
  <?php 
  		//echo $this->Html->link($this->Html->image('/img/icons/surgery-notes.jpg', array('alt' => 'Surgery Notes')),array("controller" => "opt_appointments", "action" => "surgery_notes", "admin" => false,'plugin' => false, $patient_id), array('escape' => false));
  		echo $this->Html->link($this->Html->image('/img/icons/surgery-notes.jpg', array('alt' => 'Surgery Notes','id'=>'SurgeryNotes')),'javascript:void(0);', array('escape' => false));
   ?>
 </div>
 <div class="iconLink"><?php echo __('Surgery Notes'); ?></div>
</div>

<!--<div class="interIconLink" style="margin-right:10px;">
  <div class="icon"> -->
  <?php 
//   		//echo $this->Html->link($this->Html->image('/img/icons/preferences_card.png', array('alt' => 'Preference Card')),array("controller" => "Preferences", "action" => "preferencecard", "admin" => false,'plugin' => false, $patient_id), array('escape' => false));
//   		echo $this->Html->link($this->Html->image('/img/icons/preferences_card.png', array('alt' => 'Preference Card','id'=>'PreferenceCard')),'javascript:void(0);', array('escape' => false));
//    ?>
<!--  </div> 
 <div class="iconLink"><?php //echo __('Preference Card'); ?></div>-->
<!-- </div> -->

<!--<div class="interIconLink" style="margin-right:10px;">
  <div class="icon"> -->
  <?php 
  		
//   		echo $this->Html->link($this->Html->image('/img/icons/surgery-category.jpg', array('alt' => 'Surgery Requisition Card','id'=>'surgeryRequisition')),'javascript:void(0);', array('escape' => false));
//    ?>
<!--  </div> 
 <div class="iconLink"><?php echo __('Surgery Requisition Card'); ?></div>-->
<!-- </div> -->

<div class="inner_left" id="list_content"><br>
  <div class="clr ht5">&nbsp;</div>
  <div class="clr ht5">&nbsp;</div> 
  <div class="clr ht5">&nbsp;</div> 
</div>
<div class="clr"></div>				

<div id="render-ajax">	<!-- this div is used for rendering the ajaxs on click of images -->
	
</div>
	<?php echo $this->Js->writeBuffer();?>
<script>
		jQuery(document).click(function(){
             $("a").click(function(){
             	$("form").validationEngine('hide');
             });
             $(document).validationEngine('hideAll');
		});

		/*$( document ).ajaxStart(function() {
		//	loading("render-ajax",'id'); 
		});

		$( document ).ajaxStop(function() {
		//	onCompleteRequest('render-ajax','id');
		});*/

		
		
		//for Anaesthesia
		$("#Anaesthesia").click(function(){
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
		//End of Anaesthesia
		

		//for Surgery Consent
		$("#SurgeryConsent").click(function(){
			$.ajax({
				url: '<?php echo $this->Html->url(array("controller" => "opt_appointments", "action" => "surgery_consentform", 'plugin' => false, $patient_id)); ?>',
				beforeSend:function(data){
					$('#busy-indicator').show();
				},
				success: function(data){
					$('#busy-indicator').hide();
					$("#render-ajax").html(data);
			     }
			});
		});
		//End of Surgery Consent
		
		
		//for Interpreter Statement
		$("#InterpreterStatement").click(function(){
			$.ajax({
				url: '<?php echo $this->Html->url(array("controller" => "opt_appointments", "action" => "interpreter_statement", 'plugin' => false, $patient_id)); ?>',
				beforeSend:function(data){
					$('#busy-indicator').show();
				},
				success: function(data){
					$('#busy-indicator').hide();
					$("#render-ajax").html(data);
			     }
			});
		});
		//End of Interpreter Statement
		
		
		//for Patient Specific Consent
		$("#PatientSpecificConsent").click(function(){
			$.ajax({
				url: '<?php echo $this->Html->url(array("controller" => "consents", "action" => "patient_specific_consent", "admin" => false,'plugin' => false, $patient_id)); ?>',
				beforeSend:function(data){
					$('#busy-indicator').show();
				},
				success: function(data){
					$('#busy-indicator').hide();
					$("#render-ajax").html(data);
			     }
			});
		});
		//End of Patient Specific Consent
		
		
		//for Pre Operative Checklist
		$("#PreOperativeChecklist").click(function(){
			$.ajax({
				url: '<?php echo $this->Html->url(array("controller" => "opt_appointments", "action" => "ot_pre_operative_checklist", "admin" => false,'plugin' => false, $patient_id)); ?>',
				beforeSend:function(data){
					$('#busy-indicator').show();
				},
				success: function(data){
					$('#busy-indicator').hide();
					$("#render-ajax").html(data);
			     }
			});
		});
		//End of Pre Operative Checklist
		
		
		//for Post Operative Checklist
		$("#PostOperativeChecklist").click(function(){
			$.ajax({
				url: '<?php echo $this->Html->url(array("controller" => "opt_appointments", "action" => "ot_post_operative_checklist", "admin" => false,'plugin' => false, $patient_id)); ?>',
				beforeSend:function(data){
					$('#busy-indicator').show();
				},
				success: function(data){
					$('#busy-indicator').hide();
					$("#render-ajax").html(data);
			     }
			});
		});
		//End of Post Operative Checklist
		
		
		//for Surgical Safety Checklist
		$("#SurgicalSafetyChecklist").click(function(){
			$.ajax({
				url: '<?php echo $this->Html->url(array("controller" => "opt_appointments", "action" => "surgical_safety_checklist", "admin" => false,'plugin' => false, $patient_id)); ?>',
				beforeSend:function(data){
					$('#busy-indicator').show();
				},
				success: function(data){
					$('#busy-indicator').hide();
					$("#render-ajax").html(data);
			     }
			});
		});
		//End of Surgical Safety Checklist
		
		
		//for Anaesthesia Notes
		$("#AnaesthesiaNotes").click(function(){
			$.ajax({
				url: '<?php echo $this->Html->url(array("controller" => "opt_appointments", "action" => "anaesthesia_notes", "admin" => false,'plugin' => false, $patient_id)); ?>',
				beforeSend:function(data){
					$('#busy-indicator').show();
				},
				success: function(data){
					$('#busy-indicator').hide();
					$("#render-ajax").html(data);
			     }
			});
		});
		//End of Anaesthesia Notes
		
		
		//for Surgery Notes
		$("#SurgeryNotes").click(function(){
			$.ajax({
				url: '<?php echo $this->Html->url(array("controller" => "opt_appointments", "action" => "surgery_notes", "admin" => false,'plugin' => false, $patient_id)); ?>',
				beforeSend:function(data){
					$('#busy-indicator').show();
				},
				success: function(data){
					$('#busy-indicator').hide();
					$("#render-ajax").html(data);
			     }
			});
		});
		//End of Surgery Notes
		
		
		//for Preference Card
		$("#PreferenceCard").click(function(){
			$.ajax({
				url: '<?php echo $this->Html->url(array("controller" => "Preferences", "action" => "user_preferencecard", "admin" => false,'plugin' => false, $patient_id)); ?>',
				beforeSend:function(data){
					$('#busy-indicator').show();
				},
				success: function(data){
					$('#busy-indicator').hide();
					$("#render-ajax").html(data);
			     }
			});
		});
		//End of Preference Card
		
		//for surgeryRequisition Card
		$("#surgeryRequisition").click(function(){
			$.ajax({
				url: '<?php echo $this->Html->url(array("controller" => "OptAppointments", "action" => "surgeryRequisitionCard", "admin" => false,'plugin' => false, $patient_id)); ?>',
				beforeSend:function(data){
					$('#busy-indicator').show();
				},
				success: function(data){
					$('#busy-indicator').hide();
					$("#render-ajax").html(data);
			     }
			});
		});
		//End of surgeryRequisition Card
</script>