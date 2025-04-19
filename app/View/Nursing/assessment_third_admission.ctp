<?php echo $this->Form->create('nursings',array('controller'=>'incidents','action'=>'assessment_third_admission','id'=>'ConsultantBilling','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false,
																								        'legend'=>false,
																								        'fieldset'=>false
																								    )
			));
echo $this->Form->hidden('Nursing.patient_id',array('value'=>$patient_details['Patient']['id']));
echo $this->Form->hidden('Nursing.id');			
?>
<td valign="top" align="left" class="rightTopBg">
                    <!-- Right Part Template -->
                    
                    
                  	<div class="inner_title">
                     	<h3>Nursing Assessment on Admission</h3>
                  	</div>
                   <p class="ht5"></p>  
                   <table width="100%" border="0" cellspacing="0" cellpadding="7" style="border:1px solid #3E474A;">
                   	  <tr>
                      	<td width="100%" class="tdLabel2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="90" height="25">PEARLA</td>
                            <td width="100"><?php echo $this->Form->checkbox('Nursing.pearla_yes', array('class'=>'servicesClick','id' => 'pearla_yes')); ?>
                              Yes</td>
                            <td width="120"><?php echo $this->Form->checkbox('Nursing.pearla_no', array('class'=>'servicesClick','id' => 'pearla_no')); ?>
                              No</td>
                            <td width="120">&nbsp;</td>
                            <td width="120">&nbsp;</td>
                            <td width="90">&nbsp;</td>
                            <td width="100">&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="25">Reaction</td>
                            <td><?php echo $this->Form->checkbox('Nursing.reaction_brisk', array('class'=>'servicesClick','id' => 'reaction_brisk')); ?> Brisk</td>
                            <td><?php echo $this->Form->checkbox('Nursing.reaction_sluggish', array('class'=>'servicesClick','id' => 'reaction_sluggish')); ?> Sluggish</td>
                            <td><?php echo $this->Form->checkbox('Nursing.reaction_no_response', array('class'=>'servicesClick','id' => 'reaction_no_response')); ?> No response</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="25">LOC</td>
                            <td><?php echo $this->Form->checkbox('Nursing.loc_alert', array('class'=>'servicesClick','id' => 'loc_alert')); ?> Alert</td>
                            <td><?php echo $this->Form->checkbox('Nursing.loc_confused', array('class'=>'servicesClick','id' => 'loc_confused')); ?> Confused</td>
                            <td><?php echo $this->Form->checkbox('Nursing.loc_sedated', array('class'=>'servicesClick','id' => 'loc_sedated')); ?> Sedated</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="25">Speech</td>
                            <td><?php echo $this->Form->checkbox('Nursing.speech_clear', array('class'=>'servicesClick','id' => 'speech_clear')); ?> Clear</td>
                            <td><?php echo $this->Form->checkbox('Nursing.speech_slurred', array('class'=>'servicesClick','id' => 'speech_slurred')); ?> Slurred</td>
                            <td><?php echo $this->Form->checkbox('Nursing.speech_aphasic', array('class'=>'servicesClick','id' => 'speech_aphasic')); ?> Aphasic</td>
                            <td><?php echo $this->Form->checkbox('Nursing.speech_dysphasia', array('class'=>'servicesClick','id' => 'speech_dysphasia')); ?> Dysphasia</td>
                            <td><?php echo $this->Form->checkbox('Nursing.speech_none', array('class'=>'servicesClick','id' => 'speech_none')); ?> None</td>
                            <td><?php echo $this->Form->checkbox('Nursing.speech_other', array('class'=>'servicesClick','id' => 'speech_other')); ?> Other</td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="35" colspan="2"><strong>GCS : TOTAL SCORE</strong></td>
                            <td>
                            <?php echo $this->Form->input('Nursing.gcs_total_score',array('legend'=>false,'label'=>false,'id' => 'gcs_total_score')); 
?></td>
                            <td><?php echo $this->Form->checkbox('Nursing.gcs_na', array('class'=>'servicesClick','id' => 'gcs_na')); ?> <strong>NA</strong></td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>

                        </table></td>
                      </tr>
                   </table>
                   <div>&nbsp;</div>   
                   <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm">
                   	  <tr>
                   	    <th width="300" style="text-align:center;">Category</th>
                         <th style="text-align:center;">Instructions</th>
                      </tr>
                      <tr>
                      	 <td valign="top"><strong>EYE OPENING</strong></td>
                        <td valign="top" style="line-height:20px;">
                         		<?php echo $this->Form->checkbox('Nursing.eye_opening_no_response', array('class'=>'servicesClick','id' => 'eye_opening_no_response')); ?> 1 = No response<br />
                                <?php echo $this->Form->checkbox('Nursing.eye_opening_to_pain', array('class'=>'servicesClick','id' => 'eye_opening_to_pain')); ?> 2 = To pain<br />
                                <?php echo $this->Form->checkbox('Nursing.eye_opening_to_speech', array('class'=>'servicesClick','id' => 'eye_opening_to_speech')); ?> 3 = To speech<br />
                                <?php echo $this->Form->checkbox('Nursing.eye_opening_spontaneous', array('class'=>'servicesClick','id' => 'eye_opening_spontaneous')); ?> 4 = Spontaneous
                        </td>
                      </tr>
                      <tr>
                      	 <td valign="top"><strong>BEST MOTOR RESPONSE</strong></td>
                         <td valign="top" style="line-height:20px;">
                         		<?php echo $this->Form->checkbox('Nursing.bmr_no_response', array('class'=>'servicesClick','id' => 'bmr_no_response')); ?> 1 = No response<br />
                                <?php echo $this->Form->checkbox('Nursing.bmr_extension', array('class'=>'servicesClick','id' => 'bmr_extension')); ?> 2 = Extension<br />
                                <?php echo $this->Form->checkbox('Nursing.bmr_flexion_abnormal', array('class'=>'servicesClick','id' => 'bmr_flexion_abnormal')); ?> 3 = Flexion-abnormal<br />
                                <?php echo $this->Form->checkbox('Nursing.bmr_flexion_withdrawal', array('class'=>'servicesClick','id' => 'bmr_flexion_withdrawal')); ?> 4 = Flexion-withdrawal<br />
                                <?php echo $this->Form->checkbox('Nursing.bmr_localizes_pain', array('class'=>'servicesClick','id' => 'bmr_localizes_pain')); ?> 5 = Localizes pain<br />
                                <?php echo $this->Form->checkbox('Nursing.bmr_obeys_a_simple_response', array('class'=>'servicesClick','id' => 'bmr_obeys_a_simple_response')); ?> 6 = Obeys a simple response
                         </td>
                      </tr>
                      <tr>
                      	 <td valign="top"><strong>BEST VERBAL RESPONSE</strong></td>
                         <td valign="top" style="line-height:20px;">
                         		<?php echo $this->Form->checkbox('Nursing.bvr_no_verbal_response', array('class'=>'servicesClick','id' => 'bvr_no_verbal_response')); ?> 1 = No verbal response<br />
                                <?php echo $this->Form->checkbox('Nursing.bvr_incomprehensible_sound', array('class'=>'servicesClick','id' => 'bvr_response_incomprehensible_sound')); ?> 2 = Response with incomprehensible sounds<br />
                                <?php echo $this->Form->checkbox('Nursing.bvr_inappropriate_words', array('class'=>'servicesClick','id' => 'bvr_inappropriate_words')); ?> 3 = Inappropriate words<br />
                                <?php echo $this->Form->checkbox('Nursing.bvr_confused', array('class'=>'servicesClick','id' => 'bvr_confused')); ?> 4 = Confused<br />
                                <?php echo $this->Form->checkbox('Nursing.bvr_oriented', array('class'=>'servicesClick','id' => 'bvr_oriented')); ?> 5 = Oriented
                         </td>
                      </tr>
                   </table>
                         
                   <div>&nbsp;</div>                
                   <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm">
                   	  <tr>
                      	 <th>
                         	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                            	<tr>
                                	<td width="250">RESPIRATORY</td>                                    
                                  <td width="22"><?php echo $this->Form->checkbox('Nursing.respiratory_nsf', array('class'=>'servicesClick','id' => 'respiratory_nsf')); ?></td>
                                    <td width="50">NSF</td>
                                    <td>&nbsp;</td>                                    
                                </tr>
                            </table>
                         </th>
          			  </tr>
                      <tr>
                        <td width="100%" align="left" valign="middle" style="padding-top:7px;">
                   			<table width="100%" border="0" cellspacing="0" cellpadding="0">
                            	
                   	  			<tr>
                               	  	<td width="100" height="30">Dyspnea</td>
                              		<td width="100"><?php echo $this->Form->checkbox('Nursing.dyspnea_none', array('class'=>'servicesClick','id' => 'dyspnea_none')); ?> None</td>
                              		<td width="100"><?php echo $this->Form->checkbox('Nursing.dyspnea_with_activity', array('class'=>'servicesClick','id' => 'dyspnea_with_activity')); ?> With activity</td>
                              		<td width="100"><?php echo $this->Form->checkbox('Nursing.dyspnea_at_rest', array('class'=>'servicesClick','id' => 'dyspnea_at_rest')); ?> At rest</td>
                              		<td width="100"><?php echo $this->Form->checkbox('Nursing.dyspnea_lying_down', array('class'=>'servicesClick','id' => 'dyspnea_lying_down')); ?> Lying down</td>                              
                              		<td width="100"><?php echo $this->Form->checkbox('Nursing.dyspnea_retractions', array('class'=>'servicesClick','id' => 'dyspnea_retractions')); ?> Retractions</td>
                                    <td width="100">&nbsp;</td>                      
                                	<td>&nbsp;</td>
                                </tr>
                   	  			<tr>
                   	  			  <td height="30">Cough</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.cough_none', array('class'=>'servicesClick','id' => 'cough_none')); ?> None</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.cough_non_productive', array('class'=>'servicesClick','id' => 'cough_non_productive')); ?> Non-Productive</td>
                   	  			  <td>&nbsp;</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.cough_productive_colour', array('class'=>'servicesClick','id' => 'cough_productive_colour')); ?> Productive-colour</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.cough_amount', array('class'=>'servicesClick','id' => 'cough_amount')); ?> 
                   	  			    Amount</td>
                   	  			  <td><?php echo $this->Form->input('Nursing.cough_amount_txt',array('legend'=>false,'label'=>false,'id' => 'cough_amount_txt')); 
?></td>
                   	  			  <td>&nbsp;</td>
               	  			  </tr>
                   	  			<tr>
                   	  			  <td height="30">Night Sweats</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.night_sweats_yes', array('class'=>'servicesClick','id' => 'night_sweats_yes')); ?> Yes</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.night_sweats_no', array('class'=>'servicesClick','id' => 'night_sweats_no')); ?> No</td>
                   	  			  <td>Hemoptysis:</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.hemoptysis_yes', array('class'=>'servicesClick','id' => 'hemoptysis_yes')); ?>Yes</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.hemoptysis_no', array('class'=>'servicesClick','id' => 'hemoptysis_no')); ?> No</td>
                                  <td>&nbsp;</td>                   	  			  
                   	  			  <td>&nbsp;</td>
               	  			  </tr>
                   	  			<tr>
                   	  			  <td height="30">Cyanosis</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.cysnosis_yes', array('class'=>'servicesClick','id' => 'cyanosis_yes')); ?> Yes</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.cyanosis_no', array('class'=>'servicesClick','id' => 'cyanosis')); ?> No</td>
                   	  			  <td>Where</td>
                   	  			  <td colspan="3"><?php echo $this->Form->input('Nursing.cyanosis_where',array('legend'=>false,'label'=>false,'id' => 'cyanosis_where')); 
?></td>
                                  <td>&nbsp;</td>
                   	  			  
               	  			  </tr>
                   	  			<tr>
                   	  			  <td height="30">Other</td>
                   	  			  <td colspan="6"><?php echo $this->Form->input('Nursing.cyanosis_other',array('legend'=>false,'label'=>false,'id' => 'cyanosis_other')); 
?></td>
                                  <td>&nbsp;</td>
               	  			  </tr>
                            </table>
                        </td>
                      </tr>
                    </table>
                    <div>&nbsp;</div>
                    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm">
                   	  <tr>
                      	 <th>
                         	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                            	<tr>
                                	<td width="250">CARDIOVASCULAR</td>                                    
                                  <td width="22"><?php echo $this->Form->checkbox('Nursing.cardiovascular_nsf', array('class'=>'servicesClick','id' => 'cardio_vascular_nsf')); ?></td>
                                    <td width="50">NSF</td>
                                    <td>&nbsp;</td>                                    
                                </tr>
                            </table>
                         </th>
          			  </tr>
                      <tr>
                        <td width="100%" align="left" valign="middle" style="padding-top:7px;">
                   			<table width="100%" border="0" cellspacing="0" cellpadding="0">
                            	
                   	  			<tr>
                               	  	<td width="120" height="30">Chest discomfort</td>
                              		<td width="80"><?php echo $this->Form->checkbox('Nursing.chest_disconfort_yes', array('class'=>'servicesClick','id' => 'chest_disconfort_yes')); ?> Yes</td>
                              		<td width="120"><?php echo $this->Form->checkbox('Nursing.chest_discomfort_no', array('class'=>'servicesClick','id' => 'chest_disconfort_no')); ?> No</td>
                                    <td width="100">Edema</td>
                              		<td width="80"><?php echo $this->Form->checkbox('Nursing.edema_yes', array('class'=>'servicesClick','id' => 'edema_yes')); ?> Yes</td>
                              		<td width="120"><?php echo $this->Form->checkbox('Nursing.edema_no', array('class'=>'servicesClick','id' => 'edema_no')); ?> No</td>         
                                    <td width="70">Location</td>
                                    <td width="150"><?php echo $this->Form->input('Nursing.edema_location',array('class' => 'textBoxExpnd','legend'=>false,'label'=>false,'id' => 'edema_location')); 
?></td>                     
                                    <td width="20">&nbsp;</td>
                              		<td width="80"><?php echo $this->Form->checkbox('Nursing.edema_pitting', array('class'=>'servicesClick','id' => 'edema_pitting')); ?> Pitting</td>
                                    <td width="110"><?php echo $this->Form->checkbox('Nursing.edema_non_pitting', array('class'=>'servicesClick','id' => 'edema_non_pitting')); ?> Non-pitting</td>
                                	<td>&nbsp;</td>
                                </tr>
                   	  			<tr>
                   	  			  <td height="30">Pace Maker</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.pacemaker_yes', array('class'=>'servicesClick','id' => 'pacemaker_yes')); ?> Yes</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.pacemaker_no', array('class'=>'servicesClick','id' => 'pacemaker_no')); ?> No</td>
                   	  			  <td>Type</td>
                   	  			  <td colspan="2"><?php echo $this->Form->input('Nursing.pacemaker_type',array('class' => 'textBoxExpnd','legend'=>false,'label'=>false,'id' => 'pacemaker_type')); 
?></td>
                   	  			  <td>&nbsp;</td>
                   	  			  <td align="right">Date Inserted:</td>
                   	  			  <td>&nbsp;</td>
                   	  			  <td colspan="2"><table width="165" border="0" cellspacing="0" cellpadding="0" >
                                    <tr>
                                      <td width="140"><?php 
                                    if(isset($this->data['Nursing']['pacemaker_date_inserted'])){
                                      	echo $this->Form->input('Nursing.pacemaker_date_inserted',array('value'=>$this->DateFormat->formatDate2Local($this->data['Nursing']['pacemaker_date_inserted'],Configure::read('date_format')),'class' => 'textBoxExpnd','legend'=>false,'label'=>false,'id' => 'pacemaker_date_inserted'));
                                    }else{
                                      echo $this->Form->input('Nursing.pacemaker_date_inserted',array('class' => 'textBoxExpnd','legend'=>false,'label'=>false,'id' => 'pacemaker_date_inserted')); 
									}?></td>
                                      <td width="25" align="right"><a href="#"><img src="images/calendar-icon.png" alt="" border="0" style="position:relative;"/></a></td>
                                    </tr>
                                  </table></td>
                   	  			  <td>&nbsp;</td>
               	  			  </tr>
                            </table>
                        </td>
                      </tr>
                    </table>
                    <div>&nbsp;</div>
                    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm">
                   	  <tr>
                      	 <th>
                         	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                            	<tr>
                                	<td width="250">EXTREMITIES-MUSCULOSKELETAL</td>                                    
                                    <td width="22"><?php echo $this->Form->checkbox('Nursing.musculoskeletal_nsf', array('class'=>'servicesClick','id' => 'musculoskeletal_nsf')); ?></td>
                                    <td width="50">NSF</td>
                                    <td>&nbsp;</td>                                    
                                </tr>
                            </table>
                         </th>
          			  </tr>
                      <tr>
                        <td width="100%" align="left" valign="middle" style="padding-top:7px;">
                   			<table width="100%" border="0" cellspacing="0" cellpadding="0">
                            	<tr>
                               	  	<td width="120" height="30">Skin</td>
                              		<td width="80"><?php echo $this->Form->checkbox('Nursing.skin_warm', array('class'=>'servicesClick','id' => 'skin_warm')); ?> Warm</td>
                              		<td width="80"><?php echo $this->Form->checkbox('Nursing.skin_cool', array('class'=>'servicesClick','id' => 'skin_cool')); ?> Cool</td>
                              		<td width="75"><?php echo $this->Form->checkbox('Nursing.skin_dry', array('class'=>'servicesClick','id' => 'skin_dry')); ?> Dry</td>
                              		<td width="80"><?php echo $this->Form->checkbox('Nursing.skin_firm', array('class'=>'servicesClick','id' => 'skin_firm')); ?> Firm</td>         
                                    <td width="150"><?php echo $this->Form->checkbox('Nursing.skin_flasscid', array('class'=>'servicesClick','id' => 'skin_flaccid')); ?> Flaccid</td>         
                                    <td width="50">Colour</td>
                                    <td width="200"><?php echo $this->Form->input('Nursing.skin_colour',array('class' => 'textBoxExpnd','legend'=>false,'label'=>false,'id' => 'skin_colour')); 
?></td>                     
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            	<tr>
                               	  	<td width="180" height="30">Extremities:- Tingling</td>
                              		<td width="70"><?php echo $this->Form->checkbox('Nursing.tingling_yes', array('class'=>'servicesClick','id' => 'tingling_yes')); ?> Yes</td>
                              		<td width="120"><?php echo $this->Form->checkbox('Nursing.tingling_no', array('class'=>'servicesClick','id' => 'tingling_no')); ?> No</td>
                                    <td width="80">Weakness</td>
                              		<td width="70"><?php echo $this->Form->checkbox('Nursing.weakness_yes', array('class'=>'servicesClick','id' => 'weakness_yes')); ?> Yes</td>
                              		<td width="120"><?php echo $this->Form->checkbox('Nursing.weakness_no', array('class'=>'servicesClick','id' => 'weakness_no')); ?> No</td>
                                    <td width="70">Deformity</td>
                                    <td width="70"><?php echo $this->Form->checkbox('Nursing.deformity_yes', array('class'=>'servicesClick','id' => 'deformity_yes')); ?> Yes</td>
                              		<td width="50"><?php echo $this->Form->checkbox('Nursing.deformity_no', array('class'=>'servicesClick','id' => 'deformity_no')); ?> No</td>
                                    <td>&nbsp;</td>
                                </tr>
                            	<tr>
                            	  <td height="30" style="padding-left:78px;">Contractures</td>
                            	  <td><?php echo $this->Form->checkbox('Nursing.contractures_yes', array('class'=>'servicesClick','id' => 'contractures_yes')); ?> Yes</td>
                            	  <td><?php echo $this->Form->checkbox('Nursing.contractures_no', array('class'=>'servicesClick','id' => 'contractures_no')); ?> No</td>
                            	  <td>&nbsp;</td>
                            	  <td>&nbsp;</td>
                            	  <td>&nbsp;</td>
                            	  <td>&nbsp;</td>
                            	  <td>&nbsp;</td>
                            	  <td>&nbsp;</td>
                            	  <td>&nbsp;</td>
                          	  </tr>
                            	<tr>
                            	  <td height="30">Joints:- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pain</td>
                            	   <td><?php echo $this->Form->checkbox('Nursing.joints_pain_yes', array('class'=>'servicesClick','id' => 'joints_pain_yes')); ?> Yes</td>
                            	  <td><?php echo $this->Form->checkbox('Nursing.joints_pain_no', array('class'=>'servicesClick','id' => 'joints_pain_no')); ?> No</td>
                            	  <td>Stiffness</td>
                            	   <td><?php echo $this->Form->checkbox('Nursing.joints_stiffness_yes', array('class'=>'servicesClick','id' => 'joints_stiffness_yes')); ?> Yes</td>
                            	  <td><?php echo $this->Form->checkbox('Nursing.joints_stiffness_no', array('class'=>'servicesClick','id' => 'joints_stiffness_no')); ?> No</td>
                            	  <td>ROM</td>
                            	  <td><?php echo $this->Form->checkbox('Nursing.rom_wnl', array('class'=>'servicesClick','id' => 'rom_wnl')); ?> WNL</td>
                            	  <td>Other</td>
                            	  <td><?php echo $this->Form->input('Nursing.joints_other',array('legend'=>false,'label'=>false,'id' => 'joints_other')); 
?></td>
                          	  </tr>
                            </table>
                        </td>
                      </tr>
                    </table>
                    <div>&nbsp;</div>
                    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm">
                   	  <tr>
                      	 <th>
                         	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                            	<tr>
                                	<td width="250">GASTROINTESTINAL</td>                                    
                                    <td width="22"><?php echo $this->Form->checkbox('Nursing.gastrointestinal_nsf', array('class'=>'servicesClick','id' => 'gastrointestinal_nsf')); ?></td>
                                    <td width="50">NSF</td>
                                    <td>&nbsp;</td>                                    
                                </tr>
                            </table>
                         </th>
          			  </tr>
                      <tr>
                        <td width="100%" align="left" valign="middle" style="padding-top:7px;">
                   			<table width="100%" border="0" cellspacing="0" cellpadding="0">
                            	<tr>
                            	  <td height="30">Appetite</td>
                            	  <td><?php echo $this->Form->checkbox('Nursing.appetite_good', array('class'=>'servicesClick','id' => 'appetite_good')); ?> Good</td>
                            	  <td><?php echo $this->Form->checkbox('Nursing.appetite_poor', array('class'=>'servicesClick','id' => 'appetite_poor')); ?> Poor</td>
                            	  <td height="30">Nausea</td>
                            	  <td><?php echo $this->Form->checkbox('Nursing.nausea_yes', array('class'=>'servicesClick','id' => 'nausea_yes')); ?>Yes</td>
                            	  <td><?php echo $this->Form->checkbox('Nursing.nausea_no', array('class'=>'servicesClick','id' => 'nausea_no')); ?> No</td>
                            	  <td height="30">&nbsp;</td>
                            	  <td>&nbsp;</td>
                            	  <td>&nbsp;</td>
                            	  <td>&nbsp;</td>
                          	  </tr>
                            	<tr>
                               	  	<td width="120" height="30">Vomiting</td>
                              		<td width="80"><?php echo $this->Form->checkbox('Nursing.vomiting_yes', array('class'=>'servicesClick','id' => 'vomiting_yes')); ?> Yes</td>
                           		  	<td width="110"><?php echo $this->Form->checkbox('Nursing.vomiting_no', array('class'=>'servicesClick','id' => 'vomiting_no')); ?> No</td>
                                  	<td width="120" height="30">Distention</td>
                                    <td width="80"><?php echo $this->Form->checkbox('Nursing.distention_yes', array('class'=>'servicesClick','id' => 'distention_yes')); ?> Yes</td>
                              		<td width="110"><?php echo $this->Form->checkbox('Nursing.distention_no', array('class'=>'servicesClick','id' => 'distention_no')); ?> No</td>
                                  	<td width="100" height="30">Heartburn</td>
                                  	<td width="80"><?php echo $this->Form->checkbox('Nursing.heartburn_yes', array('class'=>'servicesClick','id' => 'heartburn_yes')); ?> Yes</td>
                              		<td width="80"><?php echo $this->Form->checkbox('Nursing.heartburn_no', array('class'=>'servicesClick','id' => 'heartburn_no')); ?> No</td>
                                    <td>&nbsp;</td>
                                </tr>
                            	<tr>
                            	  <td height="30">Flatus</td>
                            	  <td><?php echo $this->Form->checkbox('Nursing.flatus_yes', array('class'=>'servicesClick','id' => 'flatus_yes')); ?> Yes</td>
                            	  <td><?php echo $this->Form->checkbox('Nursing.flatus_no', array('class'=>'servicesClick','id' => 'flatus_no')); ?> No</td>
                            	  <td height="30">Colostomy</td>
                            	  <td><?php echo $this->Form->checkbox('Nursing.colostomy_yes', array('class'=>'servicesClick','id' => 'colostomy_yes')); ?> Yes</td>
                            	  <td><?php echo $this->Form->checkbox('Nursing.colostomy_no', array('class'=>'servicesClick','id' => 'colostomy_no')); ?> No</td>
                            	  <td height="30">IIeostomy</td>
                            	  <td><?php echo $this->Form->checkbox('Nursing.iieostomy_yes', array('class'=>'servicesClick','id' => 'iieostomy_yes')); ?> Yes</td>
                            	  <td><?php echo $this->Form->checkbox('Nursing.iieostomy_no', array('class'=>'servicesClick','id' => 'iieostomy_no')); ?> No</td>
                            	  <td>&nbsp;</td>
                          	  	</tr>
                                <tr>
                            	  <td height="30">Pain</td>
                            	  <td><?php echo $this->Form->checkbox('Nursing.gastrointentinal_pain_yes', array('class'=>'servicesClick','id' => 'gastrointentinal_pain_yes')); ?> Yes</td>
                            	  <td><?php echo $this->Form->checkbox('Nursing.gastrointentinal_pain_no', array('class'=>'servicesClick','id' => 'gastrointentinal_pain_no')); ?> No</td>
                            	  <td height="30">Rectal Bleeding</td>
                            	  <td><?php echo $this->Form->checkbox('Nursing.rectal_bleeding_yes', array('class'=>'servicesClick','id' => 'rectal_bleeding_yes')); ?> Yes</td>
                            	  <td><?php echo $this->Form->checkbox('Nursing.rectal_bleeding_no', array('class'=>'servicesClick','id' => 'rectal_bleeding_no')); ?> No</td>
                            	  <td height="30">&nbsp;</td>
                            	  <td>&nbsp;</td>
                            	  <td>&nbsp;</td>
                            	  <td>&nbsp;</td>
                          	  	</tr>
                                <tr>
                                  <td height="30"><strong>BOWEL</strong></td>
                                  <td colspan="2"><?php echo $this->Form->checkbox('Nursing.bowel_no_problem', array('class'=>'servicesClick','id' => 'bowel_no_problem')); ?> No Problem</td>
                                  <td height="30"><?php echo $this->Form->checkbox('Nursing.bowel_diarrhea', array('class'=>'servicesClick','id' => 'bowel_diarrhea')); ?> Diarrhea</td>
                                  <td colspan="2"><?php echo $this->Form->checkbox('Nursing.bowel_constipation', array('class'=>'servicesClick','id' => 'bowel_constipation')); ?> Constipation</td>
                                  <td height="30"><?php echo $this->Form->checkbox('Nursing.bowel_incontience', array('class'=>'servicesClick','id' => 'bowel_incontience')); ?> Incontience</td>
                                  <td colspan="2"><?php echo $this->Form->checkbox('Nursing.bowel_blood_in_stool', array('class'=>'servicesClick','id' => 'bowel_blood_in_stool')); ?> Blood in stool</td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                            	  <td height="30">&nbsp;</td>
                            	  <td>Pain</td>
                            	  <td><?php echo $this->Form->checkbox('Nursing.bowel_pain_yes', array('class'=>'servicesClick','id' => 'bowel_pain_yes')); ?> Yes</td>
                            	  <td><?php echo $this->Form->checkbox('Nursing.bowel_pain_no', array('class'=>'servicesClick','id' => 'bowel_pain_no')); ?> No</td>
                            	  <td>Hemorrhoids</td>
                            	  <td><?php echo $this->Form->checkbox('Nursing.bowel_hemorrhoids_yes', array('class'=>'servicesClick','id' => 'bowel_hemorrhoids_yes')); ?> Yes</td>
                            	  <td><?php echo $this->Form->checkbox('Nursing.bowel_hemorrhoids_no', array('class'=>'servicesClick','id' => 'bowel_hemorrhoids_no')); ?> No</td>
                            	  <td colspan="3">
                                  	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                                    	<tr>
                                       	  <td width="40">Other </td>
                                            <td><?php echo $this->Form->input('Nursing.bowel_other',array('legend'=>false,'label'=>false,'id' => 'bowel_other')); 
?></td>
                                        </tr>
                                    </table>
                                  </td>
                            	</tr>
                            </table>
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            	<tr>
                               	  <td width="80">Frequency</td>
                                    <td width="200"><?php echo $this->Form->input('Nursing.gastrointestinal_frequency',array('legend'=>false,'label'=>false,'id' => 'gastrointestinal_frequency')); 
?></td>
                                    <td width="35">&nbsp;</td>
                                    <td width="140">Last bowel movement</td>
                                    <td width="300"><?php echo $this->Form->input('Nursing.last_bowel_movement',array('legend'=>false,'label'=>false,'id' => 'last_bowel_movement')); 
?></td>
                                    <td>&nbsp;</td>
                                </tr>
                          	</table>
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            	<tr>
                                	<td width="120">Interventions</td>
                                  	<td width="190">
     <?php echo $this->Form->checkbox('Nursing.interventions_none', array('class'=>'servicesClick','id' => 'interventions_none')); ?> None</td>
                                  	<td width="65">Laxatives</td>
                                    <td width="70"><?php echo $this->Form->checkbox('Nursing.interventions_laxatives_yes', array('class'=>'servicesClick','id' => 'interventions_laxatives_yes')); ?> Yes</td>
                                    <td width="120"><?php echo $this->Form->checkbox('Nursing.interventions_laxatives_no', array('class'=>'servicesClick','id' => 'interventions_laxatives_no')); ?> No</td>
                                    <td width="40">Type:</td>                                    
                                    <td width="137"><?php echo $this->Form->input('Nursing.interventions_type',array('legend'=>false,'label'=>false,'id' => 'interventions_type')); 
?></td>
                                    <td width="20">&nbsp;</td>
                                    <td width="70">Frequency</td>                                    
                                    <td width="137"><?php echo $this->Form->input('Nursing.interventions_frequency',array('legend'=>false,'label'=>false,'id' => 'interventions_frequency')); 
?></td>
                                    <td>&nbsp;</td>
                                </tr>                            	
                            </table>
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            	<tr>
                                	<td width="120">&nbsp;</td>
                                  	<td width="70">Enemas</td>
                                    <td width="70"><?php echo $this->Form->checkbox('Nursing.enemas_yes', array('class'=>'servicesClick','id' => 'enemas_yes')); ?> Yes</td>
                                    <td width="178"><?php echo $this->Form->checkbox('Nursing.enemas_no', array('class'=>'servicesClick','id' => 'enemas_no')); ?> No</td>
                                  	<td width="40">Other</td>                                    
                                    <td width="137">
<?php echo $this->Form->input('Nursing.enemas_other',array('legend'=>false,'label'=>false,'id' => 'enemas_other')); 
?>
</td>
                                    <td width="20">&nbsp;</td>
                                    <td width="70">Frequency</td>                                    
                                    <td width="200"><?php echo $this->Form->input('Nursing.enemas_frequency',array('legend'=>false,'label'=>false,'id' => 'enemas_frequency')); 
?></td>
                                    <td>&nbsp;</td>
                                </tr>
                            	<tr>
                            	  <td>Others:</td>
                            	  <td colspan="8"><?php echo $this->Form->input('Nursing.enemas_others',array('legend'=>false,'label'=>false,'id' => 'enemas_others')); 
?></td>
                            	  <td>&nbsp;</td>
                          	  </tr>                            	
                            </table>
                        </td>
                      </tr>
                    </table>
                    <div class="clr ht5"></div>
                	
                    
                   
<div class="btns">
<input class="blueBtn" type="submit" value="Save" id="save">
               <?php

					//echo $this->Html->link('Save &amp; Next',array('action'=>'assessment_forth_admission'),array('class'=>'blueBtn','escape'=>false)); ?>
					<!--  <input name="" type="button" value="Print" class="blueBtn" tabindex="18"/>
					--><?php 
					//echo $this->Html->link('Cancel',array('action'=>'assessment_second_admission'),array('class'=>'grayBtn','escape'=>false));
				?>
                     </div>
                    <div class="clr ht5"></div>
                   <!-- Right Part Template ends here -->
                   </td>
<?php echo $this->Form->end(); ?>
<script>
jQuery(document).ready(function(){
	$( "#pacemaker_date_inserted" ).datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',			 
		dateFormat:'<?php echo $this->General->GeneralDate();?>',
		buttonText:'Date of Incident'
	});

});
</script>