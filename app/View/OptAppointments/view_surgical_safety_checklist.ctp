<div class="inner_title">
                     	<h3><?php echo __('Surgical Safety Checklist'); ?></h3>
<span> <a class="blueBtn" href="<?php echo $this->Html->url("/opt_appointments/surgical_safety_checklist/". $patient_id); ?>"><?php echo __('Back'); ?></a></span>
                  	</div>
<div class="patient_info">
 <?php echo $this->element('patient_information');?>
</div> 
<div class="clr"></div>
<div style="text-align: right;" class="clr inner_title"></div>
<p class="ht5"></p>
                 <!-- two column table start here -->
                   <div class="clr ht5"></div>
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" >
                     <tr>
                                                <td height="35" valign="middle" class="tdLabel1" id="boxSpace1" width="80"><strong><?php echo __('Surgery'); ?></strong> :</td>
                                                <td align="left" valign="middle">
                                                 <?php echo  isset($patientSSCheckListDetails['Surgery']['name'])?$patientSSCheckListDetails['Surgery']['name']:''; ?>
                                                </td>
                                              </tr>
                    	<tr>
                    </table>
                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                       <tr>
                        	<td width="250" height="30" valign="top" class="tdLabel2" style="text-align:center;"><strong>Sign In</strong></td>
                            <td width="30">&nbsp;</td>
                            <td width="250" align="left" class="tdLabel2" style="text-align:center;"><strong>Time Out</strong></td>
                            <td width="30">&nbsp;</td>
                            <td width="250" align="left" class="tdLabel2" style="text-align:center;"><strong>Sign Out</strong></td>
                        </tr>
                    	<tr>
                    	  <td align="left" valign="top">
                          		<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm">
                                	<tr>
                                    	<th style="font-size:14px; text-align:center;">Before induction of anesthesia</th>
                                    </tr>
                                </table>
                          </td>
                    	  <td>&nbsp;</td>
                    	  <td align="left" valign="top">
                          		<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm">
                                	<tr>
                                    	<th style="font-size:14px; text-align:center;">Before Skin incision</th>
                                    </tr>
                                </table>
                          </td>
                    	  <td>&nbsp;</td>
                    	  <td align="left" valign="top">
                          		<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm">
                                	<tr>
                                    	<th style="font-size:14px; text-align:center;">Before Patient leaves operating room</th>
                                    </tr>
                                </table>
                          </td>
                  	  </tr>
                    	<tr>
                    	  <td height="35" align="left" valign="middle" class="tdLabel2" style="text-align:center;">(with atleast nurse and anaesthetists)</td>
                    	  <td>&nbsp;</td>
                    	  <td align="left" valign="middle" class="tdLabel2" style="text-align:center;">(with nurse and surgeon)</td>
                    	  <td>&nbsp;</td>
                    	  <td align="left" valign="middle" class="tdLabel2" style="text-align:center;">(with nurse, anaesthetists and surgeon)</td>
                  	  </tr>
                    	<tr>
                    	  <td align="left" valign="top">
                          		<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm">
                                	<tr>
                                    	<td valign="top" height="75">
                                        	<strong>Has the patient confirmed his/her indentify, site, procedure and consent?</strong>
                                          <div style="padding-top:5px;">
                                            	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                	<tr>
                                                   	  <td width="25">Yes</td>
                                                        <td>
                                                         <?php  
                                                             if($patientSSCheckListDetails['SurgicalSafetyChecklist']['signin_confirmed'] == 1) 
                                                              echo  $this->Form->checkbox('SurgicalSafetyChecklist.signin_confirmed', array('value' => 1, 'checked' => 'checked' , 'disabled' => 'disabled')); 
                                                             else 
                                                              echo  $this->Form->checkbox('SurgicalSafetyChecklist.signin_confirmed', array('value' => 1, 'disabled' => 'disabled')); 
                                                         ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                          </div>                                      </td>
                                    </tr>
                                    <tr>
                                    	<td valign="top" height="60">
                                        	<strong>Is the site marked? </strong>
                                        	<div style="padding-top:15px;">
                                            	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                	<tr>
                                                   	  <td width="25">Yes</td>
                                                        <td width="60">
                                                         <input type="radio" class="textBoxExpnd" name="data[SurgicalSafetyChecklist][signin_marked_yes]" id="signin_marked_yes" value="1" <?php if($patientSSCheckListDetails['SurgicalSafetyChecklist']['signin_marked_yes'] == 1) echo "checked"; ?> disabled />
                                                        </td>
                                                        <td width="85">Not Applicable</td>
                                                        <td width="25">
                                                        <input type="radio" class="textBoxExpnd" name="data[SurgicalSafetyChecklist][signin_marked_yes]" id="signin_marked_yes" value="0" <?php if($patientSSCheckListDetails['SurgicalSafetyChecklist']['signin_marked_yes'] == 0) echo "checked"; ?> disabled />
                                                        </td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </div>                                      </td>
                                    </tr>
                                    <tr>
                                      <td valign="top"  height="60">
                                        	<strong>Are the equipments check complete? </strong>
                                        	<div style="padding-top:15px;">
                                            	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                	<tr>
                                                   	  <td width="25">Yes</td>
                                                        <td width="60">
                                                         <input type="radio" class="textBoxExpnd" name="data[SurgicalSafetyChecklist][signin_complete_yes]" id="signin_complete_yes" value="1" <?php if($patientSSCheckListDetails['SurgicalSafetyChecklist']['signin_complete_yes'] == 1) echo "checked"; ?> disabled />
                                                        
                                                        </td>
                                                        <td width="85">Not Applicable</td>
                                                        <td width="25">
                                                         <input type="radio" class="textBoxExpnd" name="data[SurgicalSafetyChecklist][signin_complete_yes]" id="signin_complete_yes" value="0" <?php if($patientSSCheckListDetails['SurgicalSafetyChecklist']['signin_complete_yes'] == 0) echo "checked"; ?> disabled />
                                                        
                                                        </td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </div>                                      </td>
                                    </tr>
                                </table>
                          </td>
                    	  <td>&nbsp;</td>
                    	  <td align="left" valign="top">
                          		<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm">
                                	<tr>
                                    	<td valign="top" height="75">
                                        	<div style="float:right; margin-left:20px;">
                                                 <?php
                                                         if($patientSSCheckListDetails['SurgicalSafetyChecklist']['timeout_confirmed'] == 1) 
                                                              echo  $this->Form->checkbox('SurgicalSafetyChecklist.timeout_confirmed', array('value' => 1, 'checked' => 'checked', 'disabled' => 'disabled')); 
                                                             else 
                                                              echo  $this->Form->checkbox('SurgicalSafetyChecklist.timeout_confirmed', array('value' => 1, 'disabled' => 'disabled')); 
                                                          ?>
                                               </div>
                                            <strong>Confirm patient's name, Procedures, and where the incision will be made</strong>                                            
                                        </td>
                                    </tr>
                                    <tr>
                                    	<td valign="top" height="60">
                                        	<strong>Is essential Imaging displayed? </strong>
                                        	<div style="padding-top:15px;">
                                            	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                	<tr>
                                                   	  <td width="25">Yes</td>
                                                        <td width="60">
                                                           <input type="radio" class="textBoxExpnd" name="data[SurgicalSafetyChecklist][timeout_displayed_yes]" id="timeout_displayed_yes" value="1" <?php if($patientSSCheckListDetails['SurgicalSafetyChecklist']['timeout_displayed_yes'] == 1) echo "checked"; ?> disabled />
                                                          
                                                        </td>
                                                        <td width="85">Not Applicable</td>
                                                        <td width="25">
                                                         <input type="radio" class="textBoxExpnd" name="data[SurgicalSafetyChecklist][timeout_displayed_yes]" id="timeout_displayed_yes" value="0" <?php if($patientSSCheckListDetails['SurgicalSafetyChecklist']['timeout_displayed_yes'] == 0) echo "checked"; ?> disabled />
                                                         </td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </div>                                      </td>
                                    </tr>
                                    <tr>
                                      <td valign="top" height="60">&nbsp;</td>
                                    </tr>
                                </table>
                          </td>
                    	  <td>&nbsp;</td>
                    	  <td align="left" valign="top">
                          		<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm">
                                	<tr>
                                    	<td valign="top" height="75">
                                        	<div style="float:right; margin-left:20px;">
                                                 <?php
                                                         if($patientSSCheckListDetails['SurgicalSafetyChecklist']['signout_confirmed'] == 1) 
                                                              echo  $this->Form->checkbox('SurgicalSafetyChecklist.signout_confirmed', array('value' => 1, 'checked' => 'checked', 'disabled' => 'disabled')); 
                                                             else 
                                                              echo  $this->Form->checkbox('SurgicalSafetyChecklist.signout_confirmed', array('value' => 1, 'disabled' => 'disabled')); 
                                                          ?>
                                                </div>
                                            <strong>Nurse verbally confirms:</strong>
                                            <div class="clr"></div>
                                            <strong>Name of the procedure</strong>
                                            <div style="height:2px;"></div>
                                            <?php echo isset($patientSSCheckListDetails['SurgicalSafetyChecklist']['signout_procedure_name'])?$patientSSCheckListDetails['SurgicalSafetyChecklist']['signout_procedure_name']:''; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                   	  <td valign="top" height="60">
                                   	  	<div style="float:right; margin-left:20px;">
                                                 <?php
                                                         if($patientSSCheckListDetails['SurgicalSafetyChecklist']['signout_specimen'] == 1) 
                                                              echo  $this->Form->checkbox('SurgicalSafetyChecklist.signout_specimen', array('value' => 1, 'checked' => 'checked', 'disabled' => 'disabled')); 
                                                             else 
                                                              echo  $this->Form->checkbox('SurgicalSafetyChecklist.signout_specimen', array('value' => 1, 'disabled' => 'disabled')); 
                                                          ?>
                                                </div>
                                        <strong>Is there is specimen the nurse reads specimens label including patients name? </strong>
                                     </td>
                                    </tr>
                                    <tr>
                                      <td valign="top" height="60">
                                      <div style="float:right; margin-left:20px;">
                                       <?php
                                                         if($patientSSCheckListDetails['SurgicalSafetyChecklist']['signout_instrument'] == 1) 
                                                              echo  $this->Form->checkbox('SurgicalSafetyChecklist.signout_instrument', array('value' => 1, 'checked' => 'checked', 'disabled' => 'disabled')); 
                                                             else 
                                                              echo  $this->Form->checkbox('SurgicalSafetyChecklist.signout_instrument', array('value' => 1, 'disabled' => 'disabled')); 
                                                          ?>
                                        </div>
                                   	  <strong>No. of  instruments, sponge and needle counts</strong></td>
                                    </tr>
                                </table>
                          </td>
                  	  </tr>
                    </table>
                 <div class="clr ht5"></div>
                  <div class="btns">
                           <?php echo $this->Html->link('Print','#',
			 array('class'=>'blueBtn', 'escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('admin' => false, 'action'=>'print_surgical_safety_checklist',$patient_id, 'sscid' => $patientSSCheckListDetails['SurgicalSafetyChecklist']['id']))."', '_blank',
			 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,left=400,top=400,height=600,width=800');  return false;"));
   			 ?>
                           
                     </div>
                   
                   <!-- Right Part Template ends here -->
