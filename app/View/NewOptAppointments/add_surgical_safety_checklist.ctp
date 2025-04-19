<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#surgicalsafetyfrm").validationEngine();
	});
	
</script>
<style>
.tdLabel1 {
    color: #000000 !important;
    font-size: 13px;
    text-align: left;
}
</style>
<div class="inner_title">
     <h3><?php echo __('Add Surgical Safety Checklist'); ?></h3>
         <span>
			<?php 
			echo $this->Html->link(__('Back'),array("controller" => "opt_appointments", "action" => "surgical_safety_checklist", $patient_id),array('escape' => false,'class'=>"blueBtn"));
				//echo $this->Html->link(__('Back'),'javascript:void(0);', array('escape' => false,'class'=>"blueBtn Back"));
			?>
		</span>
                  	</div>
<div class="patient_info">
 <?php //echo $this->element('patient_information');?>
</div> 
<div class="clr"></div>
<p class="ht5"></p>
                 <!-- two column table start here -->
                   <form name="surgicalsafetyfrm" id="surgicalsafetyfrm" action="<?php echo $this->Html->url(array("controller" => "opt_appointments", "action" => "saveSurgicalSafetyChecklist")); ?>" method="post" > 
                  <?php 
                       echo $this->Form->input('SurgicalSafetyChecklist.patient_id', array('type' => 'hidden', 'value'=> $patient_id));
                       echo $this->Form->input('SurgicalSafetyChecklist.id', array('type' => 'hidden', 'value'=> $patientSSCheckListDetails['SurgicalSafetyChecklist']['id']));  
                  ?>
                   <div class="clr ht5"></div>
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" >
                     <tr>
                                                <td height="35" valign="middle" class="tdLabel1" id="boxSpace1" width="80"><strong><?php echo __('Surgery'); ?></strong> :</td>
                                                <td align="left" valign="top"><?php 
		          echo $this->Form->input('SurgicalSafetyChecklist.surgery_id', array('empty'=>__('Please Select'),'options'=>$surgeries,'id' => 'surgeryname', 'selected' => $patientSSCheckListDetails['SurgicalSafetyChecklist']['surgery_id'], 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off', 'style' => 'width:400px;'));
		        ?></td>
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
                                                              echo  $this->Form->checkbox('SurgicalSafetyChecklist.signin_confirmed', array('value' => 1, 'checked' => 'checked')); 
                                                             else 
                                                              echo  $this->Form->checkbox('SurgicalSafetyChecklist.signin_confirmed', array('value' => 1)); 
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
                                                         <input type="radio" class="textBoxExpnd" name="data[SurgicalSafetyChecklist][signin_marked_yes]" id="signin_marked_yes" value="1" <?php if(isset($patientSSCheckListDetails['SurgicalSafetyChecklist']['signin_marked_yes']) && $patientSSCheckListDetails['SurgicalSafetyChecklist']['signin_marked_yes'] == 1) echo "checked"; ?> />
                                                        </td>
                                                        <td width="100">Not Applicable</td>
                                                        <td width="25">
                                                        <input type="radio" class="textBoxExpnd" name="data[SurgicalSafetyChecklist][signin_marked_yes]" id="signin_marked_yes" value="0" <?php if(isset($patientSSCheckListDetails['SurgicalSafetyChecklist']['signin_marked_yes']) && $patientSSCheckListDetails['SurgicalSafetyChecklist']['signin_marked_yes'] == 0) echo "checked"; ?> />
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
                                                         <input type="radio" class="textBoxExpnd" name="data[SurgicalSafetyChecklist][signin_complete_yes]" id="signin_complete_yes" value="1" <?php if(isset($patientSSCheckListDetails['SurgicalSafetyChecklist']['signin_complete_yes']) && $patientSSCheckListDetails['SurgicalSafetyChecklist']['signin_complete_yes'] == 1) echo "checked"; ?> />
                                                        
                                                        </td>
                                                        <td width="100">Not Applicable</td>
                                                        <td width="25">
                                                         <input type="radio" class="textBoxExpnd" name="data[SurgicalSafetyChecklist][signin_complete_yes]" id="signin_complete_yes" value="0" <?php if(isset($patientSSCheckListDetails['SurgicalSafetyChecklist']['signin_complete_yes']) && $patientSSCheckListDetails['SurgicalSafetyChecklist']['signin_complete_yes'] == 0) echo "checked"; ?> />
                                                        
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
                                                              echo  $this->Form->checkbox('SurgicalSafetyChecklist.timeout_confirmed', array('value' => 1, 'checked' => 'checked')); 
                                                             else 
                                                              echo  $this->Form->checkbox('SurgicalSafetyChecklist.timeout_confirmed', array('value' => 1)); 
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
                                                           <input type="radio" class="textBoxExpnd" name="data[SurgicalSafetyChecklist][timeout_displayed_yes]" id="timeout_displayed_yes" value="1" <?php if(isset($patientSSCheckListDetails['SurgicalSafetyChecklist']['timeout_displayed_yes']) && $patientSSCheckListDetails['SurgicalSafetyChecklist']['timeout_displayed_yes'] == 1) echo "checked"; ?> />
                                                          
                                                        </td>
                                                        <td width="100">Not Applicable</td>
                                                        <td width="25">
                                                         <input type="radio" class="textBoxExpnd" name="data[SurgicalSafetyChecklist][timeout_displayed_yes]" id="timeout_displayed_yes" value="0" <?php if(isset($patientSSCheckListDetails['SurgicalSafetyChecklist']['timeout_displayed_yes']) && $patientSSCheckListDetails['SurgicalSafetyChecklist']['timeout_displayed_yes'] == 0) echo "checked"; ?> />
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
                                                              echo  $this->Form->checkbox('SurgicalSafetyChecklist.signout_confirmed', array('value' => 1, 'checked' => 'checked')); 
                                                             else 
                                                              echo  $this->Form->checkbox('SurgicalSafetyChecklist.signout_confirmed', array('value' => 1)); 
                                                          ?>
                                                </div>
                                            <strong>Nurse verbally confirms:</strong>
                                            <div class="clr"></div>
                                            <strong>Name of the procedure</strong>
                                            <div style="height:2px;"></div>
                                            <input type="text" class="textBoxExpnd" name="data[SurgicalSafetyChecklist][signout_procedure_name]" value="<?php echo isset($patientSSCheckListDetails['SurgicalSafetyChecklist']['signout_procedure_name'])?$patientSSCheckListDetails['SurgicalSafetyChecklist']['signout_procedure_name']:''; ?>" />
                                        </td>
                                    </tr>
                                    <tr>
                                   	  <td valign="top" height="60">
                                   	  	<div style="float:right; margin-left:20px;">
                                                 <?php
                                                         if($patientSSCheckListDetails['SurgicalSafetyChecklist']['signout_specimen'] == 1) 
                                                              echo  $this->Form->checkbox('SurgicalSafetyChecklist.signout_specimen', array('value' => 1, 'checked' => 'checked')); 
                                                             else 
                                                              echo  $this->Form->checkbox('SurgicalSafetyChecklist.signout_specimen', array('value' => 1)); 
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
                                                              echo  $this->Form->checkbox('SurgicalSafetyChecklist.signout_instrument', array('value' => 1, 'checked' => 'checked')); 
                                                             else 
                                                              echo  $this->Form->checkbox('SurgicalSafetyChecklist.signout_instrument', array('value' => 1)); 
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
                           <?php echo $this->Html->link(__('Cancel', true),array('action' => 'surgical_safety_checklist', $patient_id), array('escape' => false,'class'=>'grayBtn'));
                           	// 	 echo $this->Html->link(__('Cancel', true),'javascript:void(0);', array('escape' => false,'class'=>'grayBtn Back'));
                           	 ?>
                           <input type="submit" value="Submit" class="blueBtn" >
                           
                     </div>
                    </form>
                   <!-- Right Part Template ends here -->
                   
                   
<script>
		$(".Back").click(function(){
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
</script>