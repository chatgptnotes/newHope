<?php echo $this->Form->create('nursings',array('controller'=>'incidents','action'=>'assessment_second_admission','id'=>'ConsultantBilling','inputDefaults' => array(
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
                   <table width="100%" border="0" cellspacing="0" cellpadding="0"class="tabularForm">
                   		<tr>
                        	<th style="text-align:center; font-size:13px;">Part II System Review</th>
                        </tr>
                   </table>
                   <p class="ht5"></p>
                   <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tdLabel2">
                   	  <tr>
                      		<td width="350"><strong>NA - Not Applicable</strong></td>
                            <td width=""><strong>NSF - No Significant Findings</strong></td>
                      </tr>
                   </table>
                   <div>&nbsp;</div>
                   <p class="ht5"></p>
                   <!-- two column table start here -->
                   <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm">
                   	  <tr>
                      	 <th>
                         	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                            	<tr>
                                	<td width="80">Pediatrics:</td>
                                    <td width="22"><?php echo $this->Form->checkbox('Nursing.pediatrics_na', array('class'=>'servicesClick','id' => 'pediatrics_na')); ?></td>
                                    <td width="35">NA</td>
                                    <td width="22"><?php echo $this->Form->checkbox('Nursing.pediatrics_nsf', array('class'=>'servicesClick','id' => 'pediatrics_nsf')); ?></td>
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
                                	<td width="110" height="30">Diet: Formula</td>
                                    <td width="100"><?php echo $this->Form->checkbox('Nursing.diet_formula_yes', array('class'=>'servicesClick','id' => 'diet_formula_yes')); ?>Yes</td>
                                    <td width="100"><?php echo $this->Form->checkbox('Nursing.diet_formula_no', array('class'=>'servicesClick','id' => 'diet_formula_no')); ?> No</td>
                                    <td width="100">Bottlefed</td>
                                    <td width="100"><?php echo $this->Form->checkbox('Nursing.bottlefed_yes', array('class'=>'servicesClick','id' => 'bottlefed_yes')); ?> Yes</td>
                                    <td width="100"><?php echo $this->Form->checkbox('Nursing.bottlefed_no', array('class'=>'servicesClick','id' => 'bottlefed_no')); ?> No</td>
                                    <td width="100">BF</td>
                                    <td width="100"><?php echo $this->Form->checkbox('Nursing.bf_yes', array('class'=>'servicesClick','id' => 'bf_yes')); ?> Yes</td>
                                    <td width="100"><?php echo $this->Form->checkbox('Nursing.bf_no', array('class'=>'servicesClick','id' => 'bf_no')); ?> No</td>
                                    <td width="100">Warmed?</td>
                                    <td width="100"><?php echo $this->Form->checkbox('Nursing.warmed_yes', array('class'=>'servicesClick','id' => 'warmed_yes')); ?> Yes</td>
                                    <td width="100"><?php echo $this->Form->checkbox('Nursing.warmed_no', array('class'=>'servicesClick','id' => 'warmed_no')); ?> No</td>                                    
                                    <td>&nbsp;</td>
                                </tr>
                   	  			<tr>
                   	  			  <td height="30">Teeth / Teething</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.teeth_yes', array('class'=>'servicesClick','id' => 'teeth_yes')); ?> Yes</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.teeth_no', array('class'=>'servicesClick','id' => 'teeth_no')); ?> No</td>
                   	  			  <td>&nbsp;</td>
                   	  			  <td>&nbsp;</td>
                   	  			  <td>&nbsp;</td>
                   	  			  <td>&nbsp;</td>
                   	  			  <td>&nbsp;</td>
                   	  			  <td>&nbsp;</td>
                   	  			  <td>&nbsp;</td>
                   	  			  <td>&nbsp;</td>
                   	  			  <td>&nbsp;</td>
                   	  			  <td>&nbsp;</td>
               	  			  </tr>
                   	  			<tr>
                   	  			  <td height="30">Feeding problems</td>
                   	  			  <td colspan="5">
<?php echo $this->Form->input('Nursing.feeding_problem',array('legend'=>false,'label'=>false,'id' => 'feeding_problem')); 
?>
</td>
                   	  			  <td>&nbsp;</td>
                   	  			  <td>&nbsp;</td>
                   	  			  <td>&nbsp;</td>
                   	  			  <td>&nbsp;</td>
                   	  			  <td>&nbsp;</td>
                   	  			  <td>&nbsp;</td>
                   	  			  <td>&nbsp;</td>
               	  			  </tr>
                              <tr>
                   	  			  <td height="30">Diapers:</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.diapers_yes', array('class'=>'servicesClick','id' => 'diapers_yes')); ?> Yes</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.diapers_no', array('class'=>'servicesClick','id' => 'diapers_no')); ?> No</td>
                   	  			  <td>Toilet Training</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.toilet_training_yes', array('class'=>'servicesClick','id' => 'toilet_training_yes')); ?> Yes</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.toilet_training_no', array('class'=>'servicesClick','id' => 'toilet_training_no')); ?> No</td>
                   	  			  <td>&nbsp;</td>
                   	  			  <td colspan="2">Word used for BM</td>
                   	  			  <td colspan="3">
  <?php echo $this->Form->input('Nursing.word_used_form_bm',array('legend'=>false,'label'=>false,'id' => 'word_used_for_bm')); 
?>
  </td>
                   	  			  <td>&nbsp;</td>
               	  			  </tr>
                              <tr>
                   	  			  <td height="30" colspan="3">Immunization Status: As per schedule</td>
               	  			    <td>&nbsp;</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.immunization_status_yes', array('class'=>'servicesClick','id' => 'immunization_status_yes')); ?> Yes</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.immunization_status_no', array('class'=>'servicesClick','id' => 'immunization_status_no')); ?> No</td>
                   	  			  <td>&nbsp;</td>
                   	  			  <td colspan="2">&nbsp;</td>
                   	  			  <td colspan="3">&nbsp;</td>
                   	  			  <td>&nbsp;</td>
               	  			  </tr>
                            </table>
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
                   	  			<tr>
                                	<td width="225" height="35">For children under 2 years: Head circ</td>
                                    <td width="150">
                                    <?php echo $this->Form->input('Nursing.head_circ_child_under_2',array('class' => 'textBoxExpnd','legend'=>false,'label'=>false,'id' => 'head_circ_child_under_2')); 
									?></td>
                                    <td width="20">&nbsp;</td>
                                    <td width="70">Chest circ</td>                                    
                                    <td width="100">
									<?php echo $this->Form->input('Nursing.chest_circ_child_under_2',array('class' => 'textBoxExpnd','legend'=>false,'label'=>false,'id' => 'chest_circ_child_under_2')); 
									?>
									</td>
                                    <td width="20">&nbsp;</td>
                                    <td width="60">Abd circ</td>
                                    <td width="100">
                                    <?php echo $this->Form->input('Nursing.abd_circ_child_under_2',array('class' => 'textBoxExpnd','legend'=>false,'label'=>false,'id' => 'abd_circ_child_under_2')); 
									?>
                                    <td>&nbsp;</td>
                                </tr>
                           	</table>
                        </td>               	  		
                      </tr>
                    </table>
					<!-- two column table end here -->
                    <div>&nbsp;</div>
                    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm">
                   	  <tr>
                      	 <th>
                         	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                            	<tr>
                                	<td width="80">HEAD:</td>
                                    <td width="22">&nbsp;</td>
                                    <td width="35">&nbsp;</td>
                                    <td width="22"><?php echo $this->Form->checkbox('Nursing.head_nsf', array('class'=>'servicesClick','id' => 'head_nsf')); ?></td>
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
                                	<td width="50" height="30">Scalp</td>
                                    <td width="70"><?php echo $this->Form->checkbox('Nursing.head_scalp_dry', array('class'=>'servicesClick','id' => 'head_scalp_dry')); ?> Dry</td>
                                    <td width="85"><?php echo $this->Form->checkbox('Nursing.head_scalp_scaly', array('class'=>'servicesClick','id' => 'head_scalp_scaly')); ?> Scaly</td>
                                    <td width="160"><?php echo $this->Form->checkbox('Nursing.head_scalp_normal', array('class'=>'servicesClick','id' => 'head_scalp_normal')); ?> Normal</td>
                                    <td width="50">Hair</td>
                                    <td width="75"><?php echo $this->Form->checkbox('Nursing.head_hair_brittle', array('class'=>'servicesClick','id' => 'head_hair_brittle')); ?> Brittle</td>
                                    <td width="90"><?php echo $this->Form->checkbox('Nursing.head_hair_scantly', array('class'=>'servicesClick','id' => 'head_hair_scantly')); ?> Scantly</td>
                                    <td width="95"><?php echo $this->Form->checkbox('Nursing.head_hair_normal', array('class'=>'servicesClick','id' => 'head_hair_normal')); ?> Normal</td>                                
                                    <td>&nbsp;</td>
                                </tr>
                   	  			<tr>
                   	  			  <td height="30" colspan="3">Injuries Specify if any</td>
                   	  			  <td colspan="3">
                   	  			  <?php echo $this->Form->input('Nursing.head_injuries',array('legend'=>false,'label'=>false,'id' => 'head_injuries')); 
?></td>
                   	  			  <td>&nbsp;</td>
                   	  			  <td>&nbsp;</td>
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
                                	<td width="80">EYES:</td>
                                    <td width="22">&nbsp;</td>
                                    <td width="35">&nbsp;</td>
                                    <td width="22"><?php echo $this->Form->checkbox('Nursing.eyes_nsf', array('class'=>'servicesClick','id' => 'eyes_nsf')); ?></td>
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
                                <td width="138" height="30">Blurred Vision</td>
                              <td width="55"><?php echo $this->Form->checkbox('Nursing.eyes_blurred_vision_yes', array('class'=>'servicesClick','id' => 'eyes_blurred_vision_yes')); ?> Yes</td>
                              <td width="150"><?php echo $this->Form->checkbox('Nursing.eyes_blurred_vision_no', array('class'=>'servicesClick','id' => 'eyes_blurred_vision_no')); ?> No</td>
                              <td width="120">Double Vision</td>
                              <td width="55"><?php echo $this->Form->checkbox('Nursing.eyes_double_vision_yes', array('class'=>'servicesClick','id' => 'eyes_double_vision_yes')); ?> Yes</td>
                              <td width="120"><?php echo $this->Form->checkbox('Nursing.eyes_double_vision_no', array('class'=>'servicesClick','id' => 'eyes_double_vision_no')); ?> No</td>                              
                                <td>&nbsp;</td>
                                </tr>
                   	  			<tr>
                   	  			  <td height="30">Inflammation</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.eyes_inflammation_yes', array('class'=>'servicesClick','id' => 'eyes_inflammation_yes')); ?>
                   	  			    Yes</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.eyes_inflammation_no', array('class'=>'servicesClick','id' => 'eyes_inflammation_no')); ?>
                   	  			    No</td>
                   	  			  <td>Pain</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.eyes_pain_yes', array('class'=>'servicesClick','id' => 'eyes_pain_yes')); ?>
                   	  			    Yes</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.eyes_pain_no', array('class'=>'servicesClick','id' => 'eyes_pain_no')); ?>
                   	  			    No</td>
                   	  			  <td>&nbsp;</td>
               	  			  </tr>
                   	  			<tr>
                   	  			  <td height="30">Colour Blind</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.eyes_color_blind_yes', array('class'=>'servicesClick','id' => 'eyes_color_blind_yes')); ?>
                   	  			    Yes</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.eyes_color_blind_no', array('class'=>'servicesClick','id' => 'eyes_color_blind_no')); ?>
                   	  			    No</td>
                   	  			  <td>Itching</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.eyes_itching_yes', array('class'=>'servicesClick','id' => 'eyes_itching_yes')); ?>
                   	  			    Yes</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.eyes_itching_no', array('class'=>'servicesClick','id' => 'eyes_itching_no')); ?>
                   	  			    No</td>
                   	  			  <td>&nbsp;</td>
               	  			  </tr>
                   	  			<tr>
                   	  			  <td height="30">Pupils Abnormal</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.eyes_pupil_abnormal_yes', array('class'=>'servicesClick','id' => 'eyes_pupil_abnormal_yes')); ?>
                   	  			    Yes</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.eyes_pupil_abnormal_no', array('class'=>'servicesClick','id' => 'eyes_pupil_abnormal_no')); ?>
                   	  			    No</td>
                   	  			  <td>Discharge</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.eyes_discharge_yes', array('class'=>'servicesClick','id' => 'eyes_discharge_yes')); ?>
                   	  			    Yes</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.eyes_discharge_no', array('class'=>'servicesClick','id' => 'eyes_discharge_no')); ?>
                   	  			    No</td>
                   	  			  <td>&nbsp;</td>
               	  			  </tr>
                            </table>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                   	  			<tr>
                                	<td width="47" height="35">Colour</td>
                                    <td width="150">
     <?php echo $this->Form->input('Nursing.eyes_colour',array('legend'=>false,'label'=>false,'id' => 'eyes_colour')); 
?></td>
                                    <td width="50">&nbsp;</td>
                                    <td width="45">Other</td>                                    
                                    <td width="300"><?php echo $this->Form->input('Nursing.eyes_other',array('legend'=>false,'label'=>false,'id' => 'eyes_other')); 
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
                                	<td width="80">EARS:</td>
                                    <td width="22">&nbsp;</td>
                                    <td width="35">&nbsp;</td>
                                    <td width="22"><?php echo $this->Form->checkbox('Nursing.ears_nsf', array('class'=>'servicesClick','id' => 'ears_nsf')); ?></td>
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
                               	  <td width="100" height="30">Deaf</td>
                              		<td width="100"><?php echo $this->Form->checkbox('Nursing.ears_deaf_yes', array('class'=>'servicesClick','id' => 'ears_deaf_yes')); ?> Yes</td>
                              		<td width="100"><?php echo $this->Form->checkbox('Nursing.ears_deaf_no', array('class'=>'servicesClick','id' => 'ears_deaf_no')); ?> No</td>
                           		  <td width="100">Tinnitus</td>
                              		<td width="100"><?php echo $this->Form->checkbox('Nursing.ears_tinnitus_yes', array('class'=>'servicesClick','id' => 'ears_tinnitus_yes')); ?> Yes</td>
                              		<td width="100"><?php echo $this->Form->checkbox('Nursing.ears_tinnitus_no', array('class'=>'servicesClick','id' => 'ears_tinnitus_no')); ?> No</td>                              
                                  <td width="100">Dizziness</td>
                              		<td width="100"><?php echo $this->Form->checkbox('Nursing.ears_dizziness_yes', array('class'=>'servicesClick','id' => 'ears_dizziness_yes')); ?> Yes</td>
                           		  <td width="100"><?php echo $this->Form->checkbox('Nursing.ears_dizziness_no', array('class'=>'servicesClick','id' => 'ears_dizziness_no')); ?>No</td>                              
                                	<td>&nbsp;</td>
                                </tr>
                   	  			<tr>
                   	  			  <td height="30">Discharge</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.ears_discharge_yes', array('class'=>'servicesClick','id' => 'ears_discharge_yes')); ?>
                   	  			    Yes</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.ears_discharge_no', array('class'=>'servicesClick','id' => 'ears_discharge_no')); ?>
                   	  			    No</td>
                   	  			  <td>Pain</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.ears_pain_yes', array('class'=>'servicesClick','id' => 'ears_pain_yes')); ?>
                   	  			    Yes</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.ears_pain_no', array('class'=>'servicesClick','id' => 'ears_pain_no')); ?>
                   	  			    No</td>
                   	  			  <td>Other</td>
                   	  			  <td colspan="2">
                   	  			  <?php echo $this->Form->input('Nursing.ears_other_txt',array('legend'=>false,'label'=>false,'id' => 'ears_other_txt')); 
?>
                   	  			  </td>
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
                                	<td width="80">NOSE:</td>
                                    <td width="22">&nbsp;</td>
                                    <td width="35">&nbsp;</td>
                                    <td width="22"><?php echo $this->Form->checkbox('Nursing.nose_nsf', array('class'=>'servicesClick','id' => 'nose_nsf')); ?></td>
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
                               	  <td width="100" height="30">Congestion</td>
                              		<td width="100"><?php echo $this->Form->checkbox('Nursing.nose_congestion_yes', array('class'=>'servicesClick','id' => 'nose_congestion_yes')); ?> Yes</td>
                              		<td width="100"><?php echo $this->Form->checkbox('Nursing.nose_congestion_no', array('class'=>'servicesClick','id' => 'nose_congestion_no')); ?> No</td>
                           		  <td width="100">Sinus problem</td>
                              		<td width="100"><?php echo $this->Form->checkbox('Nursing.nose_sinus_problem_yes', array('class'=>'servicesClick','id' => 'nose_sinus_probelm_yes')); ?> Yes</td>
                              		<td width="100"><?php echo $this->Form->checkbox('Nursing.nose_sinus_problem_no', array('class'=>'servicesClick','id' => 'nose_sinus_problem_no')); ?> No</td>                              
                                  <td width="100">Nasal Flaring</td>
                              		<td width="100"><?php echo $this->Form->checkbox('Nursing.nose_nasal_flaring_yes', array('class'=>'servicesClick','id' => 'nose_nasal_flaring_yes')); ?> Yes</td>
                           		  <td width="100"><?php echo $this->Form->checkbox('Nursing.nose_nasal_flaring_no', array('class'=>'servicesClick','id' => 'nose_nasal_flaring_no')); ?> No</td>                              
                                	<td>&nbsp;</td>
                                </tr>
                   	  			<tr>
                   	  			  <td height="30">Nosebleeds</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.nose_nosebleeds_yes', array('class'=>'servicesClick','id' => 'nose_nosebleeds_yes')); ?>
                   	  			    Yes</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.nose_nosebleeds_no', array('class'=>'servicesClick','id' => 'nose_nosebleeds_no')); ?>
                   	  			    No</td>
                   	  			  <td>Drainage</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.nose_drainage_yes', array('class'=>'servicesClick','id' => 'nose_drainage_yes')); ?>
                   	  			    Yes</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.nose_drainage_no', array('class'=>'servicesClick','id' => 'nose_drainage_no')); ?>
                   	  			    No</td>
                   	  			  <td>Colour</td>
                   	  			  <td colspan="2">
                   	  			  <?php echo $this->Form->input('Nursing.nose_colour',array('legend'=>false,'label'=>false,'id' => 'nose_colour')); 
									?></td>
                   	  			  <td>&nbsp;</td>
               	  			  </tr>
                            </table>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                   	  			<tr>
                                	<td width="55" height="35">Amount</td>
                                    <td width="150">
                                    <?php echo $this->Form->input('Nursing.nose_amount',array('legend'=>false,'label'=>false,'id' => 'nose_amount')); 
?></td>
                                    <td width="50">&nbsp;</td>
                                    <td width="45">Other</td>                                    
                                    <td width="300">
                                    <?php echo $this->Form->input('Nursing.nose_other',array('legend'=>false,'label'=>false,'id' => 'nose_other')); 
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
                                	<td width="80">MOUTH:</td>
                                    <td width="22">&nbsp;</td>
                                    <td width="35">&nbsp;</td>
                                    <td width="22">
<?php echo $this->Form->checkbox('Nursing.mouth_nsf', array('class'=>'servicesClick','id' => 'mouth_nsf')); ?>
</td>
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
                               	  <td width="100" height="30">Halitosis</td>
                              		<td width="100"><?php echo $this->Form->checkbox('Nursing.mouth_halitosis_yes', array('class'=>'servicesClick','id' => 'mouth_halitosis_yes')); ?> Yes</td>
                              		<td width="100"><?php echo $this->Form->checkbox('Nursing.mouth_halitosis_no', array('class'=>'servicesClick','id' => 'mouth_halitosos_no')); ?> No</td>
                           		  <td width="100">Bleeding gums</td>
                              		<td width="100"><?php echo $this->Form->checkbox('Nursing.mouth_bleeding_gums_yes', array('class'=>'servicesClick','id' => 'mouth_bleeding_gums_yes')); ?> Yes</td>
                              		<td width="100"><?php echo $this->Form->checkbox('Nursing.mouth_bleeding_gums_no', array('class'=>'servicesClick','id' => 'mouth_bleeding_gums_no')); ?> No</td>                              
                                  <td width="100">Lesion</td>
                              		<td width="100"><?php echo $this->Form->checkbox('Nursing.mouth_lesion_yes', array('class'=>'servicesClick','id' => 'mouth_lesion_yes')); ?> Yes</td>
                           		  <td width="100"><?php echo $this->Form->checkbox('Nursing.mouth_lesion_no', array('class'=>'servicesClick','id' => 'mouth_lesion_no')); ?> No</td>                              
                                	<td>&nbsp;</td>
                                </tr>
                   	  			<tr>
                   	  			  <td height="30">Sense of taste</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.mouth_sense_of_taste_yes', array('class'=>'servicesClick','id' => 'mouth_sense_of_taste_yes')); ?>
                   	  			    Yes</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.mouth_sense_of_taste_no', array('class'=>'servicesClick','id' => 'mouth_sense_of_taste_no')); ?>
                   	  			    No</td>
                   	  			  <td>Dental Hygiene</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.mouth_dental_hygiene_yes', array('class'=>'servicesClick','id' => 'mouth_dental_hygiene_yes')); ?>
                   	  			    Yes</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.mouth_dental_hygiene_no', array('class'=>'servicesClick','id' => 'mouth_dental_hygiene_no')); ?>
                   	  			    No</td>
                   	  			  <td>&nbsp;</td>
                   	  			  <td colspan="2">&nbsp;</td>
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
                                	<td width="140">THROAT / NECK:</td>                                    
                                  <td width="22"><?php echo $this->Form->checkbox('Nursing.throat_nsf', array('class'=>'servicesClick','id' => 'throat_nsf')); ?></td>
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
                               	  <td width="100" height="30">Sore throat</td>
                              		<td width="100">
                              		<?php echo $this->Form->checkbox('Nursing.throat_sore_throat', array('class'=>'servicesClick','id' => 'throat_sore_throat_yes')); ?> Yes</td>
                              		<td width="100"><?php echo $this->Form->checkbox('Nursing.throat_sore_throat_no', array('class'=>'servicesClick','id' => 'throat_sore_throat_no')); ?> No</td>
                           		  <td width="100">Hoarseness</td>
                              		<td width="100"><?php echo $this->Form->checkbox('Nursing.throat_hoarseness_yes', array('class'=>'servicesClick','id' => 'throat_hoarseness_yes')); ?> Yes</td>
                              		<td width="100"><?php echo $this->Form->checkbox('Nursing.throat_hoarseness_no', array('class'=>'servicesClick','id' => 'throat_hoarseness_no')); ?> No</td>                              
                                  <td width="100">Lumps</td>
                              		<td width="100"><?php echo $this->Form->checkbox('Nursing.throat_lumps_yes', array('class'=>'servicesClick','id' => 'throat_lumps_yes')); ?> Yes</td>
                           		  <td width="100"><?php echo $this->Form->checkbox('Nursing.throat_lumps_no', array('class'=>'servicesClick','id' => 'throat_lumps_no')); ?> No</td>                              
                                	<td>&nbsp;</td>
                                </tr>
                   	  			<tr>
                   	  			  <td height="30">Swollen glands</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.throat_swollen_glands_yes', array('class'=>'servicesClick','id' => 'throat_swollen_glands_yes')); ?>
                   	  			    Yes</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.throat_swollen_glands_no', array('class'=>'servicesClick','id' => 'throat_swollen_glands_no')); ?>
                   	  			    No</td>
                   	  			  <td>Stiffness</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.throat_stiffness_yes', array('class'=>'servicesClick','id' => 'throat_stiffness_yes')); ?>
                   	  			    Yes</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.throat_stiffness_no', array('class'=>'servicesClick','id' => 'throat_stiffness_no')); ?>
                   	  			    No</td>
                   	  			  <td>Dysphagia</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.throat_dysphagia_yes', array('class'=>'servicesClick','id' => 'throat_dysphagia_yes')); ?>
                   	  			    Yes</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.throat_dysphagia_no', array('class'=>'servicesClick','id' => 'throat_dysphagia_no')); ?>
                   	  			    No</td>
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
                                	<td width="140">NEUROLOGICAL</td>                                    
                                    <td width="22"><?php echo $this->Form->checkbox('Nursing.neurological_nsf', array('class'=>'servicesClick','id' => 'neurological_nsf')); ?></td>
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
                               	  <td width="100" height="30">Cooperative</td>
                              		<td width="100"><?php echo $this->Form->checkbox('Nursing.neurological_cooperative_yes', array('class'=>'servicesClick','id' => 'neurological_cooperative_yes')); ?> Yes</td>
                              		<td width="100"><?php echo $this->Form->checkbox('Nursing.neurological_cooperative_no', array('class'=>'servicesClick','id' => 'neurological_cooperative_no')); ?> No</td>
                           		  <td width="100">Memory Changes</td>
                              		<td width="100"><?php echo $this->Form->checkbox('Nursing.neurological_memory_changes_yes', array('class'=>'servicesClick','id' => 'neurological_memory_changes_yes')); ?> Yes</td>
                              		<td width="100"><?php echo $this->Form->checkbox('Nursing.neurological_memory_changes_no', array('class'=>'servicesClick','id' => 'neurological_memory_changes_no')); ?> No</td>                              
                                  <td width="100">Dizziness</td>
                              		<td width="100"><?php echo $this->Form->checkbox('Nursing.neurological_dizziness_yes', array('class'=>'servicesClick','id' => 'neurological_dizziness_yes')); ?> Yes</td>
                           		  <td width="100"><?php echo $this->Form->checkbox('Nursing.neurological_dizziness_no', array('class'=>'servicesClick','id' => 'neurological_dizziness_no')); ?> No</td>                              
                                	<td>&nbsp;</td>
                                </tr>
                   	  			<tr>
                   	  			  <td height="30">Headache</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.neurological_headache_yes', array('class'=>'servicesClick','id' => 'neurological_headache_yes')); ?>
                   	  			    Yes</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.neurological_headache_no', array('class'=>'servicesClick','id' => 'neurological_headache_no')); ?>
                   	  			    No</td>
                   	  			  <td>Oriented</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.neurological_oriented_yes', array('class'=>'servicesClick','id' => 'neurological_oriented_yes')); ?>
                   	  			    Yes</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.neurological_oriented_no', array('class'=>'servicesClick','id' => 'neurological_oriented_no')); ?>
                   	  			    No</td>
                   	  			  <td>Other</td>
                   	  			  <td colspan="2">
 <?php echo $this->Form->input('Nursing.neurological_other',array('legend'=>false,'label'=>false,'id' => 'neurological_other')); 
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
                        <td width="100%" align="left" valign="middle" style="padding-top:7px;">
                   			<table width="100%" border="0" cellspacing="0" cellpadding="0">
                   	  			<tr>
                               	  <td width="100" height="30">Oriented to Person</td>
                              		<td width="100">
               <?php echo $this->Form->checkbox('Nursing.neurological_oriented_to_person_yes', array('class'=>'servicesClick','id' => 'neurological_oriented_to_person_yes')); ?> Yes</td>
                              		<td width="100">
        <?php echo $this->Form->checkbox('Nursing.neurological_oriented_to_person_no', array('class'=>'servicesClick','id' => 'neurological_oriented_to_person_no')); ?> No</td>
                           		  <td width="100">Place</td>
                              		<td width="100">
  <?php echo $this->Form->checkbox('Nursing.neurological_place_yes', array('class'=>'servicesClick','id' => 'neurological_place_yes')); ?> Yes</td>
                              		<td width="100"><?php echo $this->Form->checkbox('Nursing.neurological_place_no', array('class'=>'servicesClick','id' => 'neurological_place_no')); ?> No</td>                              
                                  <td width="100">&nbsp;</td>
                              		<td width="100">&nbsp;</td>
                           		  <td width="100">&nbsp;</td>                              
                                	<td>&nbsp;</td>
                                </tr>
                   	  			<tr>
                   	  			  <td height="30" align="right" style="padding-right:11px;">Time</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.neurological_time_yes', array('class'=>'servicesClick','id' => 'neurological_time_yes')); ?>
                   	  			    Yes</td>
                   	  			  <td><?php echo $this->Form->checkbox('Nursing.neurological_time_no', array('class'=>'servicesClick','id' => 'neurological_time_no')); ?>
                   	  			    No</td>
                   	  			  <td>Pupils Size</td>
                   	  			  <td colspan="2">
   <?php echo $this->Form->input('Nursing.neurological_pupils_size',array('legend'=>false,'label'=>false,'id' => 'neurological_pupils_size')); 
?></td>
                   	  			  <td style="padding-left:40px;">Deviation</td>
                   	  			  <td colspan="2">
               <?php echo $this->Form->input('Nursing.neurological_deviation',array('legend'=>false,'label'=>false,'id' => 'neurological_deviation')); 
?></td>
                   	  			  <td>&nbsp;</td>
               	  			  </tr>
                            </table>
                        </td>
                      </tr>
                    </table>
                   
                   <div class="clr ht5"></div> 
                   
					<div class="btns">
					<?php

					//echo $this->Html->link('Save &amp; Next',array('action'=>'assessment_third_admission'),array('class'=>'blueBtn','escape'=>false)); ?>
					<input class="blueBtn" type="submit" value="Save" id="save">
					<!-- <input name="" type="button" value="Print" class="blueBtn" tabindex="18"/>
					 -->
					<?php 
					echo $this->Html->link('Cancel',array('action'=>'assessment_first_admission'),array('class'=>'grayBtn','escape'=>false));
				?>
                         
                     </div>
                    <div class="clr ht5"></div>
                   <!-- Right Part Template ends here -->
                   </td>
<?php echo $this->Form->end(); ?>                   