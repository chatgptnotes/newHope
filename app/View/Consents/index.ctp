<?php 
	
	echo $this->Html->script('jquery.autocomplete');
  	echo $this->Html->css('jquery.autocomplete.css');
?>
<?php echo $this->element('patient_information');?>
<div class="inner_title">
<h3 style="float:left;">Consent Form</h3>
<div style="float:right;">
<?php echo $this->Html->link(__('Back'),array('controller'=>'patients','action' => 'patient_information',$patientDetails['Patient']['id']), array('escape' => false,'class'=>'blueBtn'));?>
</div>
<p class="clr"></p>
</div>
	
                   <p class="ht5"></p>
  <?php 
		  if(!empty($errors)) {
		?>
		<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
		 <tr>
		  <td colspan="2" align="left" class="error">
		   <?php 
		     foreach($errors as $errorsval){
		         echo $errorsval[0];
		         echo "<br />";
		     }
		   ?>
		  </td>
		 </tr>
		</table>
		<?php } ?>                  
    
 
                  	
   <?php echo $this->Form->create('Consent',array('type' => 'file','id'=>'consentfrm','inputDefaults' => array('label' => false,'div' => false,'error' => false	))); ?>
                
                   <!-- two column table start here -->
                   <table width="100%" cellspacing="0" cellpadding="0" border="0">
                      <tbody><tr>
                        <td width="49%" valign="top" align="left">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0" class="formFull">
                              <tbody><tr>
                              	<th colspan="2"><?php echo __('Patient Information'); ?></th>
                              </tr>
                              <tr>
                                <td width="140" valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Name'); ?><font color="red">*</font></td>
                                <td align="left">
<?php echo $this->Form->input('patient_name', array('class' => 'validate[required,custom[name]] textBoxExpnd','id' => 'patient_name', 'label'=> false,'div' => false, 'error' => false,'readonly'=>'readonly')); ?>
</td>
                              </tr>
                              <tr>
                                <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Sex'); ?><font color="red">*</font></td>
                                <td align="left">
                                <?php	echo $this->Form->input('patient_sex', array('empty'=>__('Please select'),'options'=>array('male' =>'Male','female' => 'Female'),'id' => 'patient_sex','class' => 'validate[required,custom[patient_gender]] textBoxExpnd','disabled')); ?>
                               </td>
                              </tr>
                              <tr>
                                <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Age in years'); ?><font color="red">*</font></td>
                                <td align="left">
<?php echo $this->Form->input('patient_age', array('class' => 'validate[required,custom[mandatory-enter-only]] textBoxExpnd','id' => 'patient_age', 'label'=> false,'div' => false, 'error' => false,'readonly'=>'readonly')); ?>
</td>
                              </tr>
                                                       <tr>
                                <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('MRN'); ?><font color="red">*</font></td>
                                <td align="left">
<?php echo $this->Form->input('patient_id', array('class' => 'validate[required,custom[mandatory-enter-only]] textBoxExpnd','type'=>'text','id' => 'patient_id', 'label'=> false,'div' => false, 'error' => false,'readonly' => 'readonly')); ?>
</td>
                              </tr>
                              <tr>
                                <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Diagnosis'); ?><font color="red">*</font></td>
                                <td align="left">
<?php echo $this->Form->input('patient_diagnosis', array('class' => 'validate[required,custom[mandatory-enter-only]] textBoxExpnd','id' => 'patient_diagnosis', 'label'=> false,'div' => false, 'error' => false)); ?>
</td>
                              </tr>
                              <tr>
                                <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Operation Title'); ?><font color="red">*</font></td>
                                <td align="left">
<?php echo $this->Form->input('patient_operation_title', array('class' => 'validate[required,custom[mandatory-enter-only]] textBoxExpnd','id' => 'patient_operation_title', 'label'=> false,'div' => false, 'error' => false)); ?>
</td>
                              </tr>
                            </tbody></table>
                        </td>
                        <td width="" valign="top" align="left">&nbsp;</td>
                        <td width="49%" valign="top" align="left"><table width="100%" cellspacing="0" cellpadding="0" border="0" class="formFull">
                          <tbody><tr>
                            <th colspan="2">Relative's Information</th>
                          </tr>
                          <tr>
                            <td width="160" valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Name'); ?><font color="red">*</font></td>
                            <td align="left">
<?php echo $this->Form->input('relative_name', array('class' => 'validate[required,custom[name],custom[onlyLetterSp]] textBoxExpnd','id' => 'relative_name', 'label'=> false,'div' => false, 'error' => false)); ?>
</td>
                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Sex'); ?><font color="red">*</font></td>
                            <td align="left"><?php	echo $this->Form->input('relative_sex', array('empty'=>__('Please select'),'options'=>array('Male' =>'Male','Female' => 'Female'),'id' => 'relative_sex','class' => 'validate[required,custom[mandatory-select]] textBoxExpnd')); ?>                      </td>
                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Age in years'); ?><font color="red">*</font></td>
                            <td align="left">
<?php echo $this->Form->input('relative_age', array('id' => 'relative_age', 'label'=> false, 'error' => false,'class' => 'validate[required,custom[name],custom[onlyNumber]] textBoxExpnd','style'=>'width:392px','maxlength'=>'3')); ?>
</td>
                          </tr>
                                                    <tr>
                            <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Address'); ?></td>
                            <td align="left">
<?php echo $this->Form->input('relative_address1', array('id' => 'relative_address1', 'class'=>'textBoxExpnd', 'label'=> false,'div' => false, 'error' => false)); ?>
</td>
                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace" class="tdLabel">&nbsp;</td>
                            <td align="left">
<?php echo $this->Form->input('relative_address2', array('id' => 'relative_address2', 'class'=>'textBoxExpnd', 'label'=> false,'div' => false, 'error' => false)); ?>
</td>
                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Relationship with the Patient');?><font color="red">*</font></td>
                            <td align="left">
<?php echo $this->Form->input('relation_with_patient', array('id' => 'relation_with_patient','class' => 'validate[required,custom[mandatory-enter-only],custom[onlyLetterSp]] textBoxExpnd', 'label'=> false,'div' => false, 'error' => false)); ?>
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
                                	<tbody><tr>
                                   	  	<td width="159">I the undersigned</td>
                                        <td>
<?php echo $this->Form->input('consent_owner', array('id' => 'consent_owner', 'class'=>'textBoxExpnd', 'style'=>"width:409px",'label'=> false,'div' => false, 'error' => false)); ?>
</td>
                                    </tr>
                                    <tr>
                                    	<td style="padding-bottom: 7px;" colspan="2">GIVE CONSENT for 
                                   	    
<?php echo $this->Form->checkbox('consent_for1'); 	?>
                                   	    MY OWN / 
<?php echo $this->Form->checkbox('consent_for2'); 	?> 
                                   	    AFOREMENTIONED PATIENT'S above mentioned operation and / or medication / investigation / anaesthesia / therapy / procedure etc.</td>
                                    </tr>
                                </tbody></table>                            </td>
                        </tr>
                        <tr>
                       	  <td width="30" valign="top" align="left">1.</td>
                            <td style="padding-bottom: 7px;">The necessity of this medication / investigation / anaesthesia / operation / therapy / procedure, the ill effect if this is not performed, hazards and complications in the therapeutic modalities other than operation, have been explained to me by Dr. 

<?php echo $this->Form->input('investigating_dr', array('id' => 'investigating_dr', 'class'=>'textBoxExpnd', 'style'=>"width:367px", 'label'=> false,'div' => false, 'error' => false)); ?>
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
       <?php echo $this->Form->input('complications_arise', array('id' => 'complications_arise', 'label'=> false,'div' => false, 'error' => false)); ?> 
                          <br>
                          and I believe that to avoid such complications, if any, appropriate care shall be taken by<br>
                          <div class="ht5"></div>
                          <table width="100%" cellspacing="0" cellpadding="0" border="0">
                              <tbody><tr>
                                <td width="20%">Dr. (Treating Doctor)</td>
                                <td width="128%">
<?php echo $this->Form->input('surgeon_name', array('empty'=> 'Please Select','options' => $doctorNotAnaesthesialist,'id' => 'surgeon_name','class'=>'textBoxExpnd',  'style'=>"width:411px", 'label'=> false,'div' => false, 'error' => false)); ?>
</td>
                    </tr>
                              <tr>
                                <td width="20%">Dr. (Anaesthetist)</td>
                                <td width="128%">
<?php echo $this->Form->input('anaesthetic_name', array('empty'=> 'Please Select','options' => $doctorWithAnaesthesialist,'id' => 'anaesthetic_name', 'class'=>'textBoxExpnd', 'style'=>"width:411px",'label'=> false,'div' => false, 'error' => false)); ?>
</td>
<!-- 
<td width="50">Sign.</td>
<td width="80">________________</td>
   <td>&nbsp;</td>   
              
          -->                     </tr>
                            </tbody></table>
							<div class="ht5"></div>
                            or any other doctors suggested by them.                         </td>
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
 <?php echo $this->Form->checkbox('terms_conditions_1'); 	?>
                          I have read the above writing / 
<?php echo $this->Form->checkbox('terms_conditions_2'); 	?>
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
<?php echo $this->Form->input('witness1_name', array('class' => 'validate[required,custom[name],custom[onlyLetterSp]] textBoxExpnd','id' => 'witness1_name', 'label'=> false,'div' => false, 'error' => false)); ?>
                            </td>
                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Address'); ?> </td>
                            <td align="left">
<?php echo $this->Form->input('witness1_address1', array('id' => 'witness1_address1', 'label'=> false, 'class'=>'textBoxExpnd', 'div' => false, 'error' => false)); ?>
</td>
                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace" class="tdLabel">&nbsp; </td>
                            <td align="left">
<?php echo $this->Form->input('witness1_address2', array('id' => 'witness1_address2', 'class'=>'textBoxExpnd',  'label'=> false,'div' => false, 'error' => false)); ?>
</td>
                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Age'); ?> </td>
                            <td style="padding-left: -10%"align="left">
<?php echo $this->Form->input('witness1_age', array('id' => 'witness1_age', 'label'=> false,'div' => false, 'error' => false,'class' => 'validate[" ",custom[name],custom[onlyNumber]] textBoxExpnd','maxlength'=>'3')); ?>
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
<?php echo $this->Form->input('witness2_name', array('class' => 'validate[required,custom[name]custom[onlyLetterSp]] textBoxExpnd','id' => 'witness2_name', 'label'=> false,'div' => false, 'error' => false)); ?>                            </td>
                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace2" class="tdLabel"><?php echo __('Address'); ?> </td>
                            <td align="left">
<?php echo $this->Form->input('witness2_address1', array('id' => 'witness2_address1', 'label'=> false, 'class'=>'textBoxExpnd','div' => false, 'error' => false)); ?> 
</td>
                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace2" class="tdLabel"> &nbsp;</td>
                            <td align="left">
                            <?php echo $this->Form->input('witness2_address2', array('id' => 'witness2_address2', 'class'=>'textBoxExpnd', 'label'=> false,'div' => false, 'error' => false)); ?>
                            </td>
                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace2" class="tdLabel"><?php echo __('Age'); ?></td>
                            <td style="padding-left: -10%" align="left">
<?php echo $this->Form->input('witness2_age', array('id' => 'witness2_age', 'label'=> false,'div' => false, 'error' => false,'class' => 'validate[" ",custom[name],custom[onlyNumber]] textBoxExpnd','maxlength'=>'3')); ?>
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
<?php echo $this->Form->input('relative_title', array('class' => 'validate[required,custom[mandatory-enter-only]] textBoxExpnd','id' => 'relative_title', 'label'=> false,'div' => false, 'error' => false)); ?>
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
                           <input class="grayBtn" type="button" value="Clear" 
                           	onclick="window.location='<?php echo $this->Html->url(array("controller" => $this->params['controller'],
                           	"action" => "index",$patientDetails['Patient']['id']));?>'">
						  <input class="blueBtn" type="submit" value="Submit" id="submit">
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
		jQuery("#consentfrm").validationEngine();
		$('#submit')
		.click(
				function() { 
					var validate = jQuery("#consentfrm").validationEngine('validate');
					if (validate) {$(this).css('display', 'none');}
				});
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


</script>                  