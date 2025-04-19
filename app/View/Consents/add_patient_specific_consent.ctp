<?php 
		
	echo $this->Html->script(array('jquery.signaturepad.min'));
  	echo $this->Html->css(array('jquery.signaturepad'));
?>
<script>
    $(document).ready(function() {
      $('.sigPad').signaturePad();
    });
  </script>
  <div class="inner_title">
	<h3>
		<?php echo __('Add Patient Specific Consent Form', true); ?>
	</h3>
	<span>
	<?php echo $this->Html->link(__('Back'), array('controller'=>'consents','action' => 'patient_specific_consent',$patient_id,$optId), array('escape' => false,'class'=>'blueBtn'));?>
	 </span>
</div> 

<div class="patient_info">
 <?php //echo $this->element('patient_information');?>
</div> 

                   <p class="ht5"></p>
                 <form name="consentfrm" id="consentfrm" action="<?php echo $this->Html->url(array("controller" => "consents", "action" => "savePatientSpecificConsent")); ?>" method="post" >
                 <?php 
				 	echo $this->Form->hidden('Consent.opt_appointment_id', array('id' => 'opt_appointment_id', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off', 'style' => 'width:400px;', 'value'=> $optId));
                      echo $this->Form->input('Consent.patient_id', array('type' => 'hidden',  'id' => 'patient_id', 'value'=> $patient_id));
                      echo $this->Form->input('Consent.id', array('type' => 'hidden',  'id' => 'consent_id'));
                  ?>
                   <!-- two column table start here -->
                   <table width="100%" cellspacing="0" cellpadding="0" border="0">
                      <tbody><tr>
                          <td width="100%" valign="top" align="left"><table width="100%" cellspacing="0" cellpadding="0" border="0" class="formFull">
                          <tbody><tr>
                            <th colspan="2">Relative's Information</th>
                          </tr>
                          <tr>
                            <td width="160" valign="middle" id="boxSpace" class="tdLabel"><font color="red">*</font><?php echo __(' Name :'); ?></td>
                            <td align="left">
<?php echo $this->Form->input('Consent.relative_name', array('class' => 'validate[required,custom[name]]','id' => 'relative_name', 'label'=> false,'div' => false, 'error' => false,'style'=>'width:200px')); ?>
</td>
                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace" class="tdLabel"><font color="red">*</font><?php echo __(' Sex :'); ?></td>
                            <td align="left"><?php	echo $this->Form->input('Consent.relative_sex', array('empty'=>__('Please select'),'options'=>array('Male' =>'Male','Female' => 'Female'),'id' => 'relative_sex','class' => 'validate[required,custom[mandatory-select]]', 'label'=> false,'style'=>'width:220px')); ?>                      </td>
                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __(' Age :'); ?></td>
                            <td align="left">
<?php echo $this->Form->input('Consent.relative_age', array('id' => 'Consent.relative_age', 'label'=> false,'div' => false, 'error' => false,'style'=>'width:200px')); ?>
</td>
                          </tr>
                                                    <tr>
                            <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __(' Address1 :'); ?></td>
                            <td align="left">
<?php echo $this->Form->textarea('Consent.relative_address1', array('id' => 'Consent.relative_address1', 'label'=> false,'div' => false, 'error' => false)); ?>
</td>
                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __(' Address2 :'); ?></td>
                            <td align="left">
<?php echo $this->Form->textarea('Consent.relative_address2', array('id' => 'Consent.relative_address2', 'label'=> false,'div' => false, 'error' => false)); ?>
</td>
                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace" class="tdLabel" width="200px"><font color="red">*</font><?php echo __(' Relationship with the Patient :');?></td>
                            <td align="left">
<?php echo $this->Form->input('Consent.relation_with_patient', array('id' => 'Consent.relation_with_patient','class' => 'validate[required,custom[mandatory-enter-only]]', 'label'=> false,'div' => false, 'error' => false,'style'=>'width:200px')); ?>
</td>
                          </tr>
                        </tbody></table></td>
                      </tr>
                      <tr>
                        <td valign="top" align="left">&nbsp;</td>
                        <td valign="top" align="left">&nbsp;</td>
                        <td valign="top" align="left">&nbsp;</td>
                      </tr>
                    </tbody></table>
					<!-- two column table end here -->
                    
                    <!--single column table start here -->
                    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border: 0pt none;" class="formFull">
                    	<tbody><tr>
                        	<td colspan="2">
                    			<table width="100%" cellspacing="0" cellpadding="0" border="0">
                                	<tbody>
                                	<tr>
                                <td width="140"><font color="red">*</font><?php echo __(' Surgery :'); ?></td>
                                <td align="left">
<?php echo $this->Form->input('Consent.surgery_id', array('id' => 'surgery_id', 'label'=> false,'div' => false, 'class'=>'validate[required,custom[mandatory-select]]', 'error' => false, 'options' => $surgeries,'style'=>'width:220px', 'empty'=> 'Select Surgery')); ?>
</td>
                              </tr>
                              <tr>
                                <td width="140"><font color="red">*</font><?php echo __(' Operation Title :'); ?></td>
                                <td align="left">
<?php echo $this->Form->input('Consent.patient_operation_title', array('class' => 'validate[required,custom[mandatory-enter-only]]','id' => 'patient_operation_title', 'label'=> false,'div' => false, 'error' => false,'style'=>'width:200px')); ?>
</td>
                              </tr>
                                	<tr>
                                   	  	<td width="140">I the undersigned</td>
                                        <td>
<?php echo $this->Form->input('Consent.consent_owner', array('id' => 'consent_owner', 'label'=> false,'div' => false, 'error' => false ,'style'=>'width:200px')); ?>
</td>
                                    </tr>
                                    <tr>
                                    	<td style="padding-bottom: 7px;" colspan="2">GIVE CONSENT for 
                                   	    
<?php $person = array('mo' => 'MY OWN', 'ap' => 'AFOREMENTIONED PATIENT\'S'); ?>
                                   	    
<?php echo $this->Form->input('Consent.consent_for_type', array('options' => $person,'id' => 'consent_for_type', 'label'=> false,'div' => false, 'error' => false)); ?> 
                                   	     above mentioned operation and / or medication / investigation / anaesthesia / therapy / procedure etc.</td>
                                    </tr>
                                </tbody></table>                            </td>
                        </tr>
                        <tr>
                       	  <td width="30" valign="top" align="left">1.</td>
                            <td style="padding-bottom: 7px;">The necessity of this medication / investigation / anaesthesia / operation / therapy / procedure, the ill effect if this is not performed, hazards and complications in the therapeutic modalities other than operation, have been explained to me by Dr. 

<?php echo $this->Form->input('Consent.investigating_dr', array('id' => 'investigating_dr', 'label'=> false,'div' => false, 'error' => false, 'options'=>$doctorNotAnaesthesialist, 'empty' => 'Select Doctor')); ?>
</td>
                        </tr>
                        <tr>
                          <td valign="top" align="left">2. </td>
                          <td style="padding-bottom: 7px;">I have explained clearly that any medication / investigation / operation / therapy is not totally safe and that such procedure or anaesthesia can be a risk to life of an otherwise healthy person also.</td>
                        </tr>
                        <tr>
                          <td valign="top" align="left">3.</td>
                          <td style="padding-bottom: 7px;">Doctors have explained to me that excessive bleeding, infection, cardiac arrest, pulmonary embolism and complications like this can arise suddenly and unexpectedly while undergoing medication / investigation / operation therapy / procedure or anaesthesia.</td>
                        </tr>
                        <tr>
                          <td valign="top" align="left">4.</td>
                          <td style="padding-bottom: 7px;">I give consent for any change in the anaesthesia or operative procedure as well as for removal of any organ as deemed necessary by the Doctors at the time of medication / investigation / operation / therapy/ procedure.</td>
                        </tr>
                        <tr>
                          <td valign="top" align="left">5. </td>
                          <td style="padding-bottom: 7px;">I have been made aware that after the above operation / medication / investigation / therapy / procedure and anaesthesia, instead of desired benefit, some complications may arise e.g.
       <?php echo $this->Form->input('Consent.complications_arise', array('id' => 'complications_arise', 'label'=> false,'div' => false, 'error' => false)); ?> 
                          <br>
                          and I believe that to avoid such complications, if any, appropriate care shall be taken by<br>
                          <div class="ht5"></div>
                          <table width="100%" cellspacing="0" cellpadding="0" border="0">
                              <tbody><tr>
                                <td width="50">Dr. (Treating Doctor)</td>
                                <td width="200">
<?php echo $this->Form->input('Consent.surgeon_name', array('empty'=> 'Please Select','options' => $doctorNotAnaesthesialist,'id' => 'surgeon_name', 'label'=> false,'div' => false, 'error' => false,style=>'width:200px')); ?>
</td>
                    </tr>
                              <tr>
                                <td width="50">Dr. (Anaesthetist)</td>
                                <td width="200">
<?php echo $this->Form->input('Consent.anaesthetic_name', array('empty'=> 'Please Select','options' => $doctorWithAnaesthesialist,'id' => 'anaesthetic_name', 'label'=> false,'div' => false, 'error' => false,style=>'width:200px')); ?>
</td>
<!-- 
<td width="50">Sign.</td>
<td width="80">________________</td>
   <td>&nbsp;</td>   
              
          -->                     </tr>
                            </tbody></table>
							<div class="ht5"></div>
                            or any other doctors suggested by them.</td>
                        </tr>
                        <tr>
                          <td valign="top" align="left">6.</td>
                          <td style="padding-bottom: 7px;">On receipt of bill as and when and at the time of discharge, expenses of this hospital will be paid by me.</td>
                        </tr>
                        <tr>
                          <td valign="top" align="left">7.</td>
                          <td style="padding-bottom: 7px;">I am aware of the facilities available and facilities not available in this hospital and still willing for being admitted and treated, in this Hospital.</td>
                        </tr>
                        <tr>
                          <td align="center" style="padding-bottom: 7px; line-height: 23px;" colspan="2">
                          <strong>
 <?php echo $this->Form->checkbox('Consent.terms_conditions_1', array('id' => 'terms_conditions_1')); 	?>
                          I have read the above writing / 
<?php echo $this->Form->checkbox('Consent.terms_conditions_2', array('id' => 'terms_conditions_2')); 	?>
                          The above writing has been read out to me.<br> I have understood the aforesaid and I am giving my consent willingly.</strong>                          </td>
                        </tr>
                        <tr>
                          <td align="center" colspan="2">&nbsp;</td>
                        </tr>
                    </tbody></table>
                    <!--single column table end here -->
                    
                    <!--three column table start here -->
                    <table width="100%" cellspacing="0" cellpadding="0" border="0">
                      <tbody><tr>
                        <td><table width="100%" cellspacing="0" cellpadding="0" border="0" class="formFull">
                          <tbody><tr>
                            <th colspan="2"><?php echo __('Witness'); ?></th>
                          </tr>
                          <tr>
                            <td width="90" valign="middle" id="boxSpace" class="tdLabel"><?php //echo __('Sign.'); ?></td>
                            <td align="left">
<?php //echo $this->Form->input('witness1_sign', array('id' => 'witness1_sign', 'label'=> false,'div' => false, 'error' => false)); ?>
</td>
                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Name'); ?><font color="red">*</font></td>
                            <td align="left">
<?php echo $this->Form->input('Consent.witness1_name', array('class' => 'validate[required,custom[name]]','id' => 'witness1_name', 'label'=> false,'div' => false, 'error' => false)); ?>
                            </td>
                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Address'); ?> </td>
                            <td align="left">
<?php echo $this->Form->input('Consent.witness1_address1', array('id' => 'witness1_address1', 'label'=> false,'div' => false, 'error' => false)); ?>
</td>
                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace" class="tdLabel">&nbsp; </td>
                            <td align="left">
<?php echo $this->Form->input('Consent.witness1_address2', array('id' => 'witness1_address2', 'label'=> false,'div' => false, 'error' => false)); ?>
</td>
                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Age'); ?> </td>
                            <td align="left">
<?php echo $this->Form->input('Consent.witness1_age', array('id' => 'witness1_age', 'label'=> false,'div' => false, 'error' => false)); ?>
</td>
                          </tr>
     
                          <tr>
                            <td valign="middle" id="boxSpace" class="tdLabel"><?php //echo __('Date'); ?> </td>
                            <td align="left">
<?php //echo $this->Form->input('witness1_date', array('type' => 'text', 'id' => 'witness1_date', 'label'=> false,'div' => false, 'error' => false)); ?>

</td>
                          </tr>
                        </tbody></table></td>
                        <td width="30">&nbsp;</td>
                        <td><table width="100%" cellspacing="0" cellpadding="0" border="0" class="formFull">
                          <tbody><tr>
                            <th colspan="2"><?php echo __('Witness'); ?></th>
                          </tr>
                          <tr>
                            <td width="90" valign="middle" id="boxSpace2" class="tdLabel"><?php //echo __('Sign.'); ?></td>
                            <td align="left">
<?php //echo $this->Form->input('witness2_sign', array('id' => 'witness2_sign', 'label'=> false,'div' => false, 'error' => false)); ?>
</td>
                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace2" class="tdLabel"><?php echo __('Name'); ?><font color="red">*</font></td>
                            <td align="left">
<?php echo $this->Form->input('Consent.witness2_name', array('class' => 'validate[required,custom[name]]','id' => 'witness2_name', 'label'=> false,'div' => false, 'error' => false)); ?>                            </td>
                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace2" class="tdLabel"><?php echo __('Address'); ?> </td>
                            <td align="left">
<?php echo $this->Form->input('Consent.witness2_address1', array('id' => 'witness2_address1', 'label'=> false,'div' => false, 'error' => false)); ?> 
</td>
                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace2" class="tdLabel"> &nbsp;</td>
                            <td align="left">
                            <?php echo $this->Form->input('Consent.witness2_address2', array('id' => 'witness2_address2', 'label'=> false,'div' => false, 'error' => false)); ?>
                            </td>
                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace2" class="tdLabel"><?php echo __('Age'); ?></td>
                            <td align="left">
<?php echo $this->Form->input('Consent.witness2_age', array('id' => 'witness2_age', 'label'=> false,'div' => false, 'error' => false)); ?>
</td>
                          </tr>
                          
                          <tr>
                            <td valign="middle" id="boxSpace2" class="tdLabel"><?php //echo __('Date'); ?></td>
                            <td align="left">
<?php //echo $this->Form->input('witness2_date', array('type' => 'text','id' => 'witness2_date', 'label'=> false,'div' => false, 'error' => false)); ?>
</td>
                          </tr>
                        </tbody></table></td>
                        <td width="30">&nbsp;</td>
                        <td valign="top" align="left">
                        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="formFull">
                          <tbody><tr>
                            <th colspan="2"><?php echo __('Patient / Relative'); ?></th>
                          </tr>
                          <tr>
                            <td valign="top" align="left" style="text-align: left; padding-left: 10px; padding-top: 5px; height: 175px;" class="tdLabel" colspan="2">
                            	Sign. and / or L.H.T.I
                            	<div style="width:120px;">
                            	<?php 
                            	     if($this->request->data['Consent']['signpad_file'] != "") { 
                            	       echo $this->Html->image('/signpad/'.$this->request->data['Consent']['signpad_file'], array('alt' => 'Signature', 'title' => 'Signature', 'width' => '320', 'height' => '150'));
                            		 } else {
                            	?>
                              
                                <div class="sigPad">
	                               <ul class="sigNav">
	                                <li class="drawIt" ><a href="#draw-it"><font color="white">Draw It</font></a></li>
	                                <li class="clearButton"><a href="#clear"><font color="white">Clear</font></a></li>
	                               </ul>
                                <div>
                                <div class="typed"></div>
                                 <canvas class="pad" width="320" height="150"></canvas>
                                 <?php echo $this->Form->input('Consent.output', array('type' =>'hidden', 'id' => 'output', 'class' => 'output')); ?>
                                 </div>
                               </div>  
                               <?php } ?>
                               </div>
                            </td>
                          </tr>

                          <tr>
                            <td width="90" valign="middle" id="boxSpace" class="tdLabel"><?php //echo __('Date'); ?></td>
                            <td align="left">
<?php //echo $this->Form->input('relative_date', array('type' => 'text', 'id' => 'relative_date', 'label'=> false,'div' => false, 'error' => false)); ?>
</td>
                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Title'); ?><font color="red">*</font></td>
                            <td align="left">
<?php echo $this->Form->input('Consent.relative_title', array('class' => 'validate[required,custom[mandatory-enter-only]]','id' => 'relative_title', 'label'=> false,'div' => false, 'error' => false)); ?>
</td>
                          </tr>
                        </tbody></table></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                    </tbody></table>

                    <!--three column table end here -->
                     <div class="btns">
                           <?php 
                           		//echo $this->Html->link(__('Cancel', true),array('action' => 'patient_specific_consent', $patient_id), array('escape' => false,'class'=>'grayBtn'));
                           		echo $this->Html->link(__('Cancel', true),'javascript:void(0);', array('escape' => false,'class'=>'grayBtn Back'));
                           	?>
                         
                           <?php echo $this->Form->submit(__('Submit'), array('label'=> false,'div' => false,'error' => false,'class'=>'blueBtn' ));?>
                     </div>
 <?php echo $this->Form->end(); ?>

 <script>
	$(document).ready(function(){
    /*	$("#patient_id").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","patient_id", "admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true
		});
		$("#patient_id_search").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","patient_id", "admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true
		});
		*/
		jQuery("#submitconsent").click(function(){
			if(jQuery('#terms_conditions_1').is(':checked') == false || jQuery('#terms_conditions_2').is(':checked') == false) {
				alert("Please checked the terms and conditions.");
				return false;
			}
			
		});
		jQuery("#consentfrm").validationEngine();
		
 	});
 	
	//script to include datepicker
		$(function() {
			$("#witness1_date").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '-99:+0',			 
			dateFormat: '<?php echo $this->General->GeneralDate();?>'			
		});
		$("#witness2_date").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '-99:+0',			 
			dateFormat: '<?php echo $this->General->GeneralDate();?>',
			
		});
		$("#relative_date").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '-99:+0',			 
			dateFormat: '<?php echo $this->General->GeneralDate();?>',
			
		});
});


		$(".Back").click(function(){
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

</script>    