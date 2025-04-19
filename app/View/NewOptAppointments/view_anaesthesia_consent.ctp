<div class="inner_title">
<h3> &nbsp; <?php echo __('Anaesthesia Consent Form', true); ?></h3>
<span> <a class="blueBtn" href="<?php echo $this->Html->url("/opt_appointments/anaesthesia_consent/". $patient_id); ?>"><?php echo __('Back'); ?></a></span>
</div>
<div class="patient_info">
 <?php echo $this->element('patient_information');?>
</div> 
<div class="clr"></div>
<div style="text-align: right;" class="clr inner_title"></div>
 <!--single column table start here -->
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" class="formFull" style="border:0;">
                    	<tr>
                        	<td width="100%" colspan="2">&nbsp;</td>
                      </tr>
                     <tr>
                                    	<td width="160">Name of Anesthesiologist: </td>
                                        <td>
                                        	<table cellspacing="0" cellpadding="0" border="0" width="210">
                                                  <tbody><tr>
                                                    <td width="140"><?php echo $patientConsentDetails['User']['full_name']; ?></td>
                                                    <td align="right" width="30"></td>
                                                  </tr>
                                          </tbody></table>
                                        </td>
                                    </tr>
                      <tr>
                                    	<td width="160">Surgery: </td>
                                        <td>
                                        	<table cellspacing="0" cellpadding="0" border="0" width="210">
                                                  <tbody><tr>
                                                    <td width="140"><?php echo $patientConsentDetails['Surgery']['name']; ?></td>
                                                    <td align="right" width="30"></td>
                                                  </tr>
                                          </tbody></table>
                                        </td>
                                    </tr>
                        <tr>
                       	  <td width="30" valign="top" align="left">I.</td>
                            <td style="padding-bottom:7px;">The Proposed Type of Anesthesia Technique (explain briefly in non-medical terms):<br />
                              <div style="padding-top:3px;  padding-left:30px;">
                              	1. Surgical intervention to be administered by the surgeons:<br />
                                2. Proposed anesthesia technique(s):
                                <div style="padding-top:3px; padding-left:40px;">
                                	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                                	  <?php if($patientConsentDetails['AnaesthesiaConsentForm']['general_anaesthesia'] == 1) { ?>
                                    	<tr>
                                        	<td width="25" valign="middle"><!--  <input type="checkbox" name="data[AnaesthesiaConsentForm][general_anaesthesia]" value="1" id="general_anaesthesia" <?php //if($patientConsentDetails['AnaesthesiaConsentForm']['general_anaesthesia'] == 1) echo "checked"; ?> disabled/>--></td>
                                            <td>General Anesthesia</td>
                                        </tr>
                                       <?php } ?>
                                       <?php if($patientConsentDetails['AnaesthesiaConsentForm']['regional_anaesthesia'] == 1) { ?>
                                        <tr>
                                        	<td valign="middle"><!-- <input type="checkbox" name="data[AnaesthesiaConsentForm][regional_anaesthesia]" value="1" id="regional_anaesthesia" <?php //if($patientConsentDetails['AnaesthesiaConsentForm']['regional_anaesthesia'] == 1) echo "checked"; ?> disabled />--></td>
                                            <td>Regional Anesthesia</td>
                                        </tr>
                                        <?php } ?>
                                        <?php if($patientConsentDetails['AnaesthesiaConsentForm']['nerve_block'] == 1) { ?>
                                        <tr>
                                        	<td valign="middle"><!--<input type="checkbox" name="data[AnaesthesiaConsentForm][nerve_block]" value="1" id="nerve_block" <?php //if($patientConsentDetails['AnaesthesiaConsentForm']['nerve_block'] == 1) echo "checked"; ?> disabled />--></td>
                                            <td>Nerve block</td>
                                        </tr>
                                        <?php } ?>
                                    </table>
                                </div>
                              </div> 
                          </td>
                      </tr>
                        <tr>
                          <td valign="top" align="left">II. </td>
                          <td style="padding-bottom:7px;">
                          		Physician's Statements
                                <div style="padding-top:3px; padding-left:30px;">
                              	1. I have adequately assessed the patient's physical condition prior to the anesthesia<br />
                                2. I have verbally explained to the patient in the way that the patient can understand, concerning the anesthesia intervention to be carried out, as following:
                                <div style="padding-top:3px; padding-left:40px;">
                                	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                                	  <?php if($patientConsentDetails['AnaesthesiaConsentForm']['anaesthesia_procedure'] == 1) { ?>
                                    	<tr>
                                        	<td width="25" valign="middle"><!-- <input type="checkbox" name="data[AnaesthesiaConsentForm][anaesthesia_procedure]" value="1" id="anaesthesia_procedure" <?php //if($patientConsentDetails['AnaesthesiaConsentForm']['anaesthesia_procedure'] == 1) echo "checked"; ?> disabled />--></td>
                                            <td>Anesthesia procedure</td>
                                        </tr>
                                       <?php } ?>
                                       <?php if($patientConsentDetails['AnaesthesiaConsentForm']['anaesthesia_risks'] == 1) { ?>
                                        <tr>
                                        	<td valign="middle"><!-- <input type="checkbox" name="data[AnaesthesiaConsentForm][anaesthesia_risks]" value="1" id="anaesthesia_risks" <?php //if($patientConsentDetails['AnaesthesiaConsentForm']['anaesthesia_risks'] == 1) echo "checked"; ?> disabled />--></td>
                                            <td>Anesthesia-related risks</td>
                                        </tr>
                                       <?php } ?>
                                       <?php if($patientConsentDetails['AnaesthesiaConsentForm']['anaesthesia_symptoms'] == 1) { ?>
                                        <tr>
                                        	<td valign="middle"><!-- <input type="checkbox" name="data[AnaesthesiaConsentForm][anaesthesia_symptoms]" value="1" id="anaesthesia_symptoms" <?php //if($patientConsentDetails['AnaesthesiaConsentForm']['anaesthesia_symptoms'] == 1) echo "checked"; ?> disabled />--></td>
                                            <td>The potential adverse symptoms following the anesthesia</td>
                                        </tr>
                                        <?php  } ?>
                                        <?php if($patientConsentDetails['AnaesthesiaConsentForm']['anaesthesia_suppliment'] == 1) { ?>
                                        <tr>
                                          <td valign="middle"><!--  <input type="checkbox"  name="data[AnaesthesiaConsentForm][anaesthesia_suppliment]" value="1" id="anaesthesia_suppliment" <?php //if($patientConsentDetails['AnaesthesiaConsentForm']['anaesthesia_suppliment'] == 1) echo "checked"; ?> disabled />--></td>
                                          <td>I have rendered the patient with supplementary information regarding the anesthesia</td>
                                        </tr>
                                       <?php } ?>
                                    </table>                                   
                                </div>
                                3. I have also provided the patient with sufficient time to inquire for the following questions concerning the anesthesia to be undertaken in this surgery. 
                            </div> 
                          </td>
                        </tr>
                        <tr>
                          <td colspan="2" valign="top" align="left">
                          		<table width="100%" cellpadding="0" cellspacing="0" border="0">
                                	<tr>
                                    	<td width="80">Date / Time</td>
                                        <td>
                                        	<table width="210" border="0" cellspacing="0" cellpadding="0">
                                                  <tr>
                                                    <td width="140"><?php if($patientConsentDetails['AnaesthesiaConsentForm']['anaesthesia_time'] && $patientConsentDetails['AnaesthesiaConsentForm']['anaesthesia_time'] !="0000-00-00 00:00:00") echo  $this->DateFormat->formatDate2Local($patientConsentDetails['AnaesthesiaConsentForm']['anaesthesia_time'],Configure::read('date_format'), true);  ?></td>
                                                    <td width="30" align="right"></td>
                                                  </tr>
                                          </table>
                                        </td>
                                    </tr>
                                </table>
                          </td>                          
                      </tr>
                        <tr>
                          <td valign="top" align="left">III.</td>
                          <td style="padding-bottom:7px;">
                          		Patient's Statements
                                <div style="padding-top:3px; padding-left:30px;">
                                	1. I understand that the anesthesia procedure is necessary for undertaking this surgery in order to alleviate pain and fear during the operation<br />
                                    2. The anesthesia doctor has explained the risk and procedure of anesthesia to me<br />
                                    3. I fully understand the information provided relating to the anesthesia<br />
                                    4. I had addressed my concerns and doubts regarding the anesthesia to the anesthesia doctor and he/she has given me satisfactory responses.
                                </div>
                          </td>
                        </tr>
                        
                        
                    </table>
                    <!--single column table end here -->
                    <p class="ht5"></p>
                    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm">
                      <tr>
                      	 <th colspan="2">Relationship to the Patient:</th>
                      </tr>
                      <tr>
                        <td width="60%" align="left" valign="top" style="padding-top:7px;">
                          <table width="500" border="0" cellspacing="0" cellpadding="0" >
                              <tr>
                                <td width="145" height="25" valign="middle" class="tdLabel1">Relationship to Patient:</td>
                                <td align="left" valign="top"><?php echo $patientConsentDetails['AnaesthesiaConsentForm']['relationship_to_patient']; ?></td>
                              </tr>
                              <tr>
                                <td height="25" valign="middle" class="tdLabel1">Address</td>
                                <td align="left" valign="top"><?php echo $patientConsentDetails['AnaesthesiaConsentForm']['relationship_to_address']; ?></td>
                              </tr>
                       	  </table>
                        </td>
                        	<td width="40%" align="left" valign="top" style="padding-top:7px;">
										<table width="350" border="0" cellspacing="0" cellpadding="0" >
                                              <tr>
                                                <td width="160" height="35" valign="middle" class="tdLabel1" id="boxSpace1">Tel No.:</td>
                                                <td align="left" valign="top"><?php echo $patientConsentDetails['AnaesthesiaConsentForm']['relationship_to_telephone']; ?></td>
</tr>
                                              <tr>
                                                <td height="35" valign="middle" class="tdLabel1" id="boxSpace1">Date / Time</td>
                                                <td align="left" valign="top" style="padding:0;">
                                                <table width="230" border="0" cellspacing="0" cellpadding="0">
                                                  <tr>
                                                    <td width="140"><?php if($patientConsentDetails['AnaesthesiaConsentForm']['relationship_to_date'] && $patientConsentDetails['AnaesthesiaConsentForm']['relationship_to_date'] !="0000-00-00 00:00:00") echo $this->DateFormat->formatDate2Local($patientConsentDetails['AnaesthesiaConsentForm']['relationship_to_date'],Configure::read('date_format'), true); ?></td>
                                                    <td width="25" align="left" style="padding:0;"></td>
                                                  </tr>
                                                </table></td>
                                              </tr>
                                      </table>                                        </td>
                                        
                                  
                      </tr>
                    </table>
                     <p class="ht5"></p>
                    <div class="tdLabel2">
                    	Note 1. Please specify the relationship to the patient if the authorized signer is not the patient himself/herself
                    </div>
                    <p class="clr ht5"></p>
               		<div class="btns">
                          <?php echo $this->Html->link('Print','#',
			 array('class'=>'blueBtn', 'escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('admin' => false, 'action'=>'print_anaesthesia_consent',$patientConsentDetails['AnaesthesiaConsentForm']['id']))."', '_blank',
			 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,left=400,top=400,height=600,width=800');  return false;"));
   			 ?>
                           
                           
                           
                     </div>
