<style>
.tddate img{float:inherit;}
</style>
<?php
echo $this->Html->script(array('ui.timepicker.js?v=0.3.1'));
echo $this->Html->css(array('ui.ui.timepicker'));
 echo $this->Html->script(array('jquery.signaturepad.min'));
  	echo $this->Html->css(array('jquery.signaturepad'));?>
	<script>
    $(document).ready(function() {
      $('.sigPad').signaturePad();
    });
  </script>
<style>
.formError .formErrorContent {
	width: 60px;
}

.hindi-para {
	font-size: 14px;
}

.tabularForm {
	margin: 10px;
}

.textBoxExpnd {
	padding: 3px;
}
</style>
<div class="inner_title">
	<h3>
		<?php echo __('Tracheostomy Consent -Edit'); ?>
	</h3>
	<span> <?php  echo $this->Html->link(__('Back'), array('action' => 'tracheostomy_consent_list', $patient['Patient']['id']), array('escape' => false,'class'=>"blueBtn"));?>
	</span>
</div>

<div class="clr ht5"></div>
<?php echo $this->element('patient_information');?>
<div class="clr ht5"></div>
<?php echo $this->Form->create('TracheostomyConsent');?>
<div class="hindi-para"><h4>Patient Statement and Consent for Operation</h4>
 <p>I hereby authorize <strong><?php echo ucfirst($treating_consultant[0]['fullname']) ;?></strong>,and any associates or assistants of his
choice to perform upon me <strong><?php echo  ucfirst($patient[0]['lookup_name']) ;?></strong>.</p>

<p>I understand that the Procedure may serve in the progress of medical education therefore, I will allow/refuse  observers during my procedure. I also Consent/refuse  audio-visual documentation (photos/video0 of the procedure and its use for medical education and research. I understand that my privacy and identity will be protected at all times When I consent with the documentation .</p> 

<p>I recognize that during the course of the procedure, unforeseen conditions may necessitate additional or different procedures than those explained. I, therefore, further authorize and request my doctor and any associates or assistants of his choice perform such as are, in their professional judgement , necessary or appropriate for such procedures. </p>

<p>I understand that the proposed care may involves risks and possibilities of complications, and that certain complications have been known to follow the procedure to which I am consenting even when the utmost care, judgement and skill are used. I acknowledge that no guarantees have been made to me as to the results of the procedure, nor are there any guarantees against unfavourable results.</p>

<p>I accept the risks of substantial and serious harm, if any, in hopes of obtaining desired beneficial results of such care and acknowledge that the physicians involved have explained my condition, the proposed health care, and alternatives forms of treatment in a satisfactory manner.</p>

<p>The basic procedures of the proposed surgery, the advantages , disadvantages, risks, possible complications, and alternative treatments have been explained and discussed with me by my doctor. Although it is impossible for the doctor to inform me of every possible complication that may occur, the doctor has answered all my questions to  my satisfaction .<strong>In signing this consent form, I am stating I have read this form (or it has been read to me), and I fully understand it and the possible risks, complications and benefits that can result from the surgery. I also acknowledge that the doctor has addressed all of my concerns regarding this surgery</strong>.</p>

<p class="tddate">
Patient's Name :  <?php echo  ucfirst($patient[0]['lookup_name']) ;?><br/></p>
<p><table width="100%">
<!--  signature part start-->
<tr><td>Patient signature:<br/><?php 
                            	     if($TracheostomyConsent['TracheostomyConsent']['patient_sign'] != "") { 
                            	       echo $this->Html->image('/signpad/'.$TracheostomyConsent['TracheostomyConsent']['patient_sign'], array('alt' => 'Signature', 'title' => 'Signature', 'width' => '320', 'height' => '150'));
                            		 } else {
                            	?>
                              
                                <div class="sigPad">
	                               <ul class="sigNav">
	                                <li class="drawIt" ><a href="#draw-it"><font color="white">Draw It</font></a></li>
	                                <li class="clearButton"><a href="#clear"><font color="white">Clear</font></a></li>
	                               </ul>
                                <div>
                                <div class="typed"></div>
                                 <canvas class="pad" width="290" height="150"></canvas>
                                 <?php echo $this->Form->input('patient_output', array('type' =>'hidden', 'id' => 'output', 'class' => 'output')); ?>
                                 </div>
                               </div> <?php } ?></td> 
                               <td>Witness signature:<br/><?php 
                            	     if($TracheostomyConsent['TracheostomyConsent']['witness_sign'] != "") { 
                            	       echo $this->Html->image('/signpad/'.$TracheostomyConsent['TracheostomyConsent']['witness_sign'], array('alt' => 'Signature', 'title' => 'Signature', 'width' => '320', 'height' => '150'));
                            		 } else {
                            	?>
                              
                                <div class="sigPad">
	                               <ul class="sigNav">
	                                <li class="drawIt" ><a href="#draw-it"><font color="white">Draw It</font></a></li>
	                                <li class="clearButton"><a href="#clear"><font color="white">Clear</font></a></li>
	                               </ul>
                                <div>
                                <div class="typed"></div>
                                 <canvas class="pad" width="290" height="150"></canvas>
                                 <?php echo $this->Form->input('witness_output', array('type' =>'hidden', 'id' => 'output', 'class' => 'output')); ?>
                                 </div>
                               </div> <?php } ?></td>
                               <td>Doctor signature:<br/><?php 
                            	     if($TracheostomyConsent['TracheostomyConsent']['doctor_sign'] != "") { 
                            	       echo $this->Html->image('/signpad/'.$TracheostomyConsent['TracheostomyConsent']['doctor_sign'], array('alt' => 'Signature', 'title' => 'Signature', 'width' => '320', 'height' => '150'));
                            		 } else {
                            	?>
                              
                                <div class="sigPad">
	                               <ul class="sigNav">
	                                <li class="drawIt" ><a href="#draw-it"><font color="white">Draw It</font></a></li>
	                                <li class="clearButton"><a href="#clear"><font color="white">Clear</font></a></li>
	                               </ul>
                                <div>
                                <div class="typed"></div>
                                 <canvas class="pad" width="290" height="150"></canvas>
                                 <?php echo $this->Form->input('doctor_output', array('type' =>'hidden', 'id' => 'output', 'class' => 'output')); ?>
                                 </div>
                               </div> <?php } ?></td></tr>
                             <tr><td>Date:<font color="red">*</font> <input type="text" id="date1" name="TracheostomyConsent[date1]" class="date validate[required]" value="<?php echo $this->DateFormat->formatDate2local($TracheostomyConsent['TracheostomyConsent']['date1'],Configure::read('date_format')); ?>"> <br/>
                             </td></tr>
                              


<!--  signature part end-->



</table>
</p>
<p>
As parent , guardian, caretaker, next of kin or other legal representative responsible for the patient whose name appears above on the appropriate signature line, I have read this document and, to the limit of the patient's understanding, I have discussed this informed consent  and its terms with the patient. Due to the patient's inability to sign this informed consent, I agree , on behalf of the patient, to sign for the patient and bind him/her to the terms of this informed consent.</p>
<p class="tddate">
Name : <input type="text" id="name" name="TracheostomyConsent[name]" class="validate[required]" value="<?php echo $TracheostomyConsent['TracheostomyConsent']['name'] ; ?>"><br/>
<table width="100%">
<!--  signature part start-->
<tr><td>Signature :<br/><?php 
                            	     if($TracheostomyConsent['TracheostomyConsent']['signature'] != "") { 
                            	       echo $this->Html->image('/signpad/'.$TracheostomyConsent['TracheostomyConsent']['signature'], array('alt' => 'Signature', 'title' => 'Signature', 'width' => '320', 'height' => '150'));
                            		 } else {
                            	?>
                              
                                <div class="sigPad">
	                               <ul class="sigNav">
	                                <li class="drawIt" ><a href="#draw-it"><font color="white">Draw It</font></a></li>
	                                <li class="clearButton"><a href="#clear"><font color="white">Clear</font></a></li>
	                               </ul>
                                <div>
                                <div class="typed"></div>
                                 <canvas class="pad" width="290" height="150"></canvas>
                                 <?php echo $this->Form->input('signature_output', array('type' =>'hidden', 'id' => 'output', 'class' => 'output')); ?>
                                 </div>
                               </div> <?php } ?></td></tr></table>
Relationship to patient : <input type="text" name="TracheostomyConsent[relationship]" size="80" value="<?php echo $TracheostomyConsent['TracheostomyConsent']['relationship'] ; ?>"><br/>
Date:<font color="red">*</font> <input type="text" id="date2" name="TracheostomyConsent[date2]" class="date validate[required]" value="<?php echo $this->DateFormat->formatDate2local($TracheostomyConsent['TracheostomyConsent']['date2'],Configure::read('date_format')); ?>"> <br/>
</p>
</div>





<div class="btns">

	<input name="submit" type="submit" value="Submit" class="blueBtn" />

</div>

<?php echo $this->Form->end();?>
<script>
jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#TracheostomyConsentTracheostomyConsentForm").validationEngine();
	});



(function($){
    $.fn.validationEngineLanguage = function(){
    };
    $.validationEngineLanguage = {
        newLang: function(){
            $.validationEngineLanguage.allRules = {
                "required": { // Add your regex rules here, you can take telephone as an example
                    "regex": "none",
                    "alertText":"Required.",
                    "alertTextCheckboxMultiple": "* Please select an option",
                    "alertTextCheckboxe": "* This checkbox is required"
                }
            };

        }
    };
    $.validationEngineLanguage.newLang();
})(jQuery);

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
			minDate: new Date(),
		});


</script>
