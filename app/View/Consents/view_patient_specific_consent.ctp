<div class="inner_title">
<h3> &nbsp; <?php echo __('Patient Specific Consent Form', true); ?></h3>
<span> <a class="blueBtn" href="<?php echo $this->Html->url("/consents/patient_specific_consent/". $patient_id); ?>"><?php echo __('Back'); ?></a></span>
</div>
<div class="patient_info">
 <?php echo $this->element('patient_information');?>
</div> 
<div class="clr"></div>
<div style="text-align: right;" class="clr inner_title"></div>
                  <p class="ht5"></p>
                  <!-- two column table start here -->
                   <table width="100%" cellspacing="0" cellpadding="0" border="0">
                      <tbody><tr>
                          <td width="100%" valign="top" align="left"><table width="100%" cellspacing="0" cellpadding="0" border="0" class="formFull">
                          <tbody><tr>
                            <th colspan="2">Relative's Information</th>
                          </tr>
                          <tr>
                            <td width="160" valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Name'); ?></td>
                            <td align="left"><?php  echo $patientConsentDetails['Consent']['relative_name']; ?></td>
                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Sex'); ?></td>
                            <td align="left"><?php  echo $patientConsentDetails['Consent']['relative_sex']; ?></td>
                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Age'); ?></td>
                            <td align="left"><?php  echo $patientConsentDetails['Consent']['relative_age']; ?>
                            </td>
                          </tr>
                                                    <tr>
                            <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Address1'); ?></td>
                            <td align="left"><?php  echo $patientConsentDetails['Consent']['relative_address1']; ?>
                            </td>
                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Address2'); ?></td>
                            <td align="left"><?php  echo $patientConsentDetails['Consent']['relative_address2']; ?>
                            </td>
                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Relationship with the Patient');?><font color="red">*</font></td>
                            <td align="left"><?php  echo $patientConsentDetails['Consent']['relation_with_patient']; ?>
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
                                <td width="140"><?php echo __('Surgery'); ?></td>
                                <td align="left"><?php  echo $patientConsentDetails['Surgery']['name']; ?>
                                </td>
                              </tr>
                              <tr>
                                <td width="140"><?php echo __('Operation Title'); ?><font color="red">*</font></td>
                                <td align="left"><?php  echo $patientConsentDetails['Consent']['patient_operation_title']; ?>
                                </td>
                              </tr>
                                	<tr>
                                   	  	<td width="140">I the undersigned</td>
                                        <td><?php  echo $patientConsentDetails['Consent']['consent_owner']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                    	<td style="padding-bottom: 7px;" colspan="2">GIVE CONSENT for 
                            <?php if($patientConsentDetails['Consent']['consent_for1'] == 1) { ?>       	    
<?php echo $this->Form->checkbox('Consent.consent_for1', array('disabled'=>'disabled', 'checked'=>'checked')); 	?>
                            <?php } else { ?>
                            <?php echo $this->Form->checkbox('Consent.consent_for1', array('disabled'=>'disabled')); 	?>
                            <?php }?>
                                   	    MY OWN / 
                                   	    <?php if($patientConsentDetails['Consent']['consent_for2'] == 1) { ?> 
<?php echo $this->Form->checkbox('Consent.consent_for2', array('disabled'=>'disabled', 'checked'=>'checked')); 	?>
                                       <?php } else { ?>
                                       <?php echo $this->Form->checkbox('Consent.consent_for2', array('disabled'=>'disabled')); 	?>
                                       <?php } ?> 
                                   	    AFOREMENTIONED PATIENT'S above mentioned operation and / or medication / investigation / anaesthesia / therapy / procedure etc.</td>
                                    </tr>
                                </tbody></table>                            </td>
                        </tr>
                        <tr>
                       	  <td width="30" valign="top" align="left">1.</td>
                            <td style="padding-bottom: 7px;">The necessity of this medication / investigation / anaesthesia / operation / therapy / procedure, the ill effect if this is not performed, hazards and complications in the therapeutic modalities other than operation, have been explained to me by Dr. 
<?php  echo $patientConsentDetails[0]['doctorfullname']; ?>
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
                          <?php  echo $patientConsentDetails['Consent']['complications_arise']; ?>
                          <br>
                          and I believe that to avoid such complications, if any, appropriate care shall be taken by<br>
                          <div class="ht5"></div>
                          <table width="100%" cellspacing="0" cellpadding="0" border="0">
                              <tbody><tr>
                                <td width="120">Dr. (Treating Doctor)</td>
                                <td> <?php  echo $patientConsentDetails[0]['userfullname']; ?>
                                </td>
                    </tr>
                              <tr>
                                <td width="120">Dr. (Anaesthetist)</td>
                                <td width="200">
                                <?php  echo $patientConsentDetails['DoctorProfile']['doctor_name']; ?>
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
                          <?php if($patientConsentDetails['Consent']['terms_conditions_1'] == 1) { ?>
 <?php echo $this->Form->checkbox('Consent.terms_conditions_1', array('id' => 'terms_conditions_1','disabled' => 'disabled', 'checked'=>'checked'));?>
                          <?php } else { ?>
                          <?php echo $this->Form->checkbox('Consent.terms_conditions_1', array('id' => 'terms_conditions_1','disabled' => 'disabled'));?>
                          <?php } ?>
                          I have read the above writing /
                          <?php if($patientConsentDetails['Consent']['terms_conditions_2'] == 1) { ?> 
<?php echo $this->Form->checkbox('Consent.terms_conditions_2', array('id' => 'terms_conditions_2','disabled' => 'disabled', 'checked'=>'checked')); 	?>
                         <?php } else { ?>
                         <?php echo $this->Form->checkbox('Consent.terms_conditions_2', array('id' => 'terms_conditions_2','disabled' => 'disabled')); 	?>
                         <?php } ?>
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
                            <td align="left"><?php  echo $patientConsentDetails['Consent']['witness1_name']; ?>
                            </td>
                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Address'); ?> </td>
                            <td align="left"><?php  echo $patientConsentDetails['Consent']['witness1_address1']; ?>
                            </td>
                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace" class="tdLabel">&nbsp; </td>
                            <td align="left"><?php  echo $patientConsentDetails['Consent']['witness1_address2']; ?>
                            </td>
                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace" class="tdLabel"><?php echo __('Age'); ?> </td>
                            <td align="left"><?php  echo $patientConsentDetails['Consent']['witness1_age']; ?>
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
                            <td align="left"><?php  echo $patientConsentDetails['Consent']['witness2_name']; ?>
                            </td>
                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace2" class="tdLabel"><?php echo __('Address'); ?> </td>
                            <td align="left"><?php  echo $patientConsentDetails['Consent']['witness2_address1']; ?>
                            </td>
                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace2" class="tdLabel"> &nbsp;</td>
                            <td align="left"><?php  echo $patientConsentDetails['Consent']['witness2_address2']; ?>
                            </td>
                          </tr>
                          <tr>
                            <td valign="middle" id="boxSpace2" class="tdLabel"><?php echo __('Age'); ?></td>
                            <td align="left"><?php  echo $patientConsentDetails['Consent']['witness2_age']; ?>
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
                            <td align="left"><?php  echo $patientConsentDetails['Consent']['relative_title']; ?>
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
                    <div class="clr ht5"></div>
                    <div class="btns">
                          <?php echo $this->Html->link('Print','#',
			 array('class'=>'blueBtn', 'escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('admin' => false, 'action'=>'print_patient_specific_consent',$patientConsentDetails['Consent']['id']))."', '_blank',
			 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,left=400,top=400,height=600,width=800');  return false;"));
   			 ?>
                         
		    </div>
                    <div class="clr ht5"></div>
                     
