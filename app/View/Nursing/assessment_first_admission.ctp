<?php echo $this->Form->create('nursings',array('controller'=>'incidents','action'=>'assessment_first_admission','id'=>'ConsultantBilling','inputDefaults' => array(
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
                   <table width="100%" border="0" cellspacing="0" cellpadding="0">
                   		<tr>
                        	<td width="40" class="tdLabel2">Date</td>
                            <td width="165"><table width="165" border="0" cellspacing="0" cellpadding="0" >
                              <tr>
                                <td width="140">
                                
              <?php #echo $this->data['Nursing']['date'];exit;
              if(isset($this->data['Nursing']['date'])){
              	#echo 'here';exit;
              	echo $this->Form->input('Nursing.date',array('value'=>$this->DateFormat->formatDate2Local($this->data['Nursing']['date'],Configure::read('date_format')),'legend'=>false,'label'=>false,'id' => 'date'));
              }else{
              	echo $this->Form->input('Nursing.date',array('legend'=>false,'label'=>false,'id' => 'date')); 
			  	
              }
              ?>
              </td>
                                <td width="25" align="right"><a href="#"><img src="images/calendar-icon.png" alt="" border="0" style="position:relative;"/></a></td>
                              </tr>
                            </table>
                            </td>
                            <td width="40">&nbsp;</td>
                            <td width="40" class="tdLabel2">Time</td>
                            <td width="150">
                            	<?php echo $this->Form->input('Nursing.time',array('legend'=>false,'label'=>false,'id' => 'time')); 
			  					?>
                          </td>
                            <td width="30">&nbsp;</td>
                            <td width="100" class="tdLabel2">Admitting Unit</td>
                            <td width="150">
                            <?php echo $this->Form->input('Nursing.admitting_unit',array('value'=>$patient_details['Patient']['admission_id'],'legend'=>false,'label'=>false,'id' => 'admitting_unit')); 
			  				?>
                            </td>
                            <td width="">&nbsp;</td>
                        </tr>
                   </table>
                   <div>&nbsp;</div>
                   <p class="ht5"></p>
                   
                   <!-- two column table start here -->
                   <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm">
                   	  <tr>
                      	 <th>ALLERGIES: DRUG / FOOD / OTHER</th>
          </tr>
           <tr>
                      	 <td>
<?php echo $this->Form->textarea('Nursing.allergies', array('class' => 'textBoxExpnd','id' => 'allergies','row'=>'3')); ?>
</td>
          </tr>
                      <tr>
                        <td width="100%" align="left" valign="middle" style="padding-top:7px;">
                   			<table width="100%" border="0" cellspacing="0" cellpadding="0">
                   	  			<tr>
                                	<td height="35">Informant</td>
                                    <td>
    <?php echo $this->Form->checkbox('Nursing.patient', array('class'=>'servicesClick','id' => 'patient')); ?> Patient</td>
                                    <td>
<?php echo $this->Form->checkbox('Nursing.other', array('class'=>'servicesClick','id' => 'other')); ?>
 Other</td>
                                    <td>Relationship</td>
                                    <td colspan="2">
 
 <?php echo $this->Form->input('Nursing.relationship',array('legend'=>false,'label'=>false,'id' => 'relationship')); 
?>
 </td>
                                </tr>
                                <tr>
                                	<td width="120" height="35">Mode of access</td>
                                    <td width="120">
 <?php echo $this->Form->checkbox('Nursing.mode_of_access_ambulatory', array('class'=>'servicesClick','id' => 'mode_of_access_ambulatory')); ?> Ambulatory</td>
                                    <td width="120">
 <?php echo $this->Form->checkbox('Nursing.mode_of_access_wc', array('class'=>'servicesClick','id' => 'mode_of_access_wc')); ?> WC</td>
                                    <td width="120">
<?php echo $this->Form->checkbox('Nursing.mode_of_access_stretcher', array('class'=>'servicesClick','id' => 'mode_of_access_stretcher')); ?> Stretcher</td>
                                    <td width="80">
<?php echo $this->Form->checkbox('Nursing.mode_of_access_other', array('class'=>'servicesClick','id' => 'mode_of_access_other')); ?> Other</td>
                                    <td>
<?php echo $this->Form->input('Nursing.mode_of_access_other_txt',array('legend'=>false,'label'=>false,'id' => 'mode_of_access_other_txt')); 
?>

</td>
                                </tr>
                                <tr>
                                	<td height="35">Transported with</td>
                                    <td><?php echo $this->Form->checkbox('Nursing.transported_with_oxygen', array('class'=>'servicesClick','id' => 'transported_with_oxygen')); ?> Oxygen</td>
                                    <td><?php echo $this->Form->checkbox('Nursing.transported_with_monitor', array('class'=>'servicesClick','id' => 'transported_with_monitor')); ?> Monitor</td>
                                    <td><?php echo $this->Form->checkbox('Nursing.transported_with_iv', array('class'=>'servicesClick','id' => 'transported_with_iv')); ?> IV</td>
                                    <td><?php echo $this->Form->checkbox('Nursing.transported_with_other', array('class'=>'servicesClick','id' => 'transported_with_other')); ?> Other</td>
                                    <td>
<?php echo $this->Form->input('Nursing.transported_with_other_txt',array('legend'=>false,'label'=>false,'id' => 'transported_with_other_txt')); 
?> 
</td>
                                </tr>
                                <tr>
                                	<td height="35">From</td>
                                    <td>
<?php echo $this->Form->checkbox('Nursing.from_home', array('class'=>'servicesClick','id' => 'from_home')); ?> Home</td>
                                    <td>
                                    <?php echo $this->Form->checkbox('Nursing.from_er', array('class'=>'servicesClick','id' => 'from_er')); ?> ER</td>
                                    <td><?php echo $this->Form->checkbox('Nursing.from_opd', array('class'=>'servicesClick','id' => 'from_opd')); ?> OPD</td>
                                    <td><?php echo $this->Form->checkbox('Nursing.from_other', array('class'=>'servicesClick','id' => 'from_other')); ?> Other</td>
                                    <td>
<?php echo $this->Form->input('Nursing.from_other_txt',array('legend'=>false,'label'=>false,'id' => 'from_other_txt')); 
?>
</td>
                                </tr>
                            </table>
                            <p class="ht5"></p>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                   	  			<tr>
                                	<td width="120" height="35">Vital signs</td>
                                    <td width="80">Temperature</td>
                                    <td width="70">
<?php echo $this->Form->input('Nursing.temprature',array('class'=>'textBoxExpnd','legend'=>false,'label'=>false,'id' => 'temprature')); 
?>
</td>
                                    <td width="60">&deg;F</td>
                                    <td width="40">Pulse</td>
                                    <td width="70">
<?php echo $this->Form->input('Nursing.pulse',array('class'=>'textBoxExpnd','legend'=>false,'label'=>false,'id' => 'pulse')); 
?>
</td>
                                    <td width="70">/ min</td>
                                    <td width="25">RR</td>
                                    <td width="70">
<?php echo $this->Form->input('Nursing.rr',array('class'=>'textBoxExpnd','legend'=>false,'label'=>false,'id' => 'rr')); 
?>
</td>
                                    <td width="70">/ min</td>
                                    <td width="25">BP</td>
                                    <td width="70">
<?php echo $this->Form->input('Nursing.bp',array('class'=>'textBoxExpnd','legend'=>false,'label'=>false,'id' => 'bp')); 
?>
</td>
                                    <td width="60">mmHg</td>
                                    <td>&nbsp;</td>
                                </tr>
                   	  			<tr>
                   	  			  <td height="35">&nbsp;</td>
                   	  			  <td>Ht.</td>
                   	  			  <td>
<?php echo $this->Form->input('Nursing.ht',array('class'=>'textBoxExpnd','legend'=>false,'label'=>false,'id' => 'ht')); 
?>
</td>
                   	  			  <td>cm</td>
                   	  			  <td>Wt.</td>
                   	  			  <td>
<?php echo $this->Form->input('Nursing.wt',array('class'=>'textBoxExpnd','legend'=>false,'label'=>false,'id' => 'wt')); 
?></td>
                   	  			  <td>Kg.</td>
                   	  			  <td>&nbsp;</td>
                   	  			  <td>&nbsp;</td>
                   	  			  <td>&nbsp;</td>
                   	  			  <td>&nbsp;</td>
                   	  			  <td>&nbsp;</td>
                   	  			  <td>&nbsp;</td>
                   	  			  <td>&nbsp;</td>
               	  			  </tr>
                           	</table>
                        </td>               	  		
                      </tr>
                    </table>
					<!-- two column table end here -->
                    <div>&nbsp;</div>
                    <div class="tdLabel2"><strong>ACTIVITIES OF DAILY LIVING:</strong></div>
                    <div class="clr ht5"></div>
                   	<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm">
                      <tr>
                      		<th width="150">&nbsp;</th>
                        	<th width="150">Usual Level</th>
                            <th width="150">Level on Admission</th>
                            <td>Scrore</td>
                     </tr>
                     <?php $options=array('Please Select'=>'Please Select','Level 0'=>'Level 0','Level 1'=>'Level 1','Level 2'=>'Level 2','Level 3'=>'Level 3');?>
                      <tr>
                        <td>Can perform ADL?</td>
                        <td>
<?php echo $this->Form->input('Nursing.usual_can_perform_adl', array('label'=>false,'options'=>$options,'class' => 'textBoxExpnd','id' => 'usual_can_perform_adl'));?>
                        </td>
                        <td><?php echo $this->Form->input('Nursing.admission_can_perform_adl', array('label'=>false,'options'=>$options,'class' => 'textBoxExpnd','id' => 'admission_can_perform_adl'));?></td>
                      <td rowspan="6" valign="top">
                        	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                            	<tr>
                                	<td width="55" height="30" valign="top">Level 0 -</td>
                                  <td valign="top" style="padding-bottom:15px;">Independent requires no supervision, assistance or teaching</td>
                                </tr>
                                <tr>
                                	<td width="55" height="30" valign="top">Level 1 -</td>
                                  <td valign="top" style="padding-bottom:15px;">Requires Supervision and / or teaching</td>
                                </tr>
                                <tr>
                                	<td width="55" height="30" valign="top">Level 3 -</td>
                                    <td valign="top" style="padding-bottom:15px;">Requires at least minimum assistence from another person</td>
                                </tr>
                                <tr>
                                	<td width="55" height="30" valign="top">Level 4 -</td>
                                    <td valign="top" style="padding-bottom:15px;">Is dependent and does not participate.</td>
                                </tr>
                          </table>
                        </td>
                      </tr>
                      <tr>
                        <td>Feeding</td>
                        <td><?php echo $this->Form->input('Nursing.usual_feeding', array('label'=>false,'options'=>$options,'class' => 'textBoxExpnd','id' => 'usual_feeding'));?></td>
                        <td><?php echo $this->Form->input('Nursing.admission_feeding', array('label'=>false,'options'=>$options,'class' => 'textBoxExpnd','id' => 'admission_feeding'));?></td>
                      </tr>
                      <tr>
                        <td>Bathing</td>
                        <td><?php echo $this->Form->input('Nursing.usual_bathing', array('label'=>false,'options'=>$options,'class' => 'textBoxExpnd','id' => 'usual_bathing'));?></td>
                        <td><?php echo $this->Form->input('Nursing.admission_bathing', array('label'=>false,'options'=>$options,'class' => 'textBoxExpnd','id' => 'admission_bathing'));?></td>
                      </tr>
                      <tr>
                        <td>Toileting</td>
                        <td><?php echo $this->Form->input('Nursing.usual_toileting', array('label'=>false,'options'=>$options,'class' => 'textBoxExpnd','id' => 'usual_toileting'));?></td>
                        <td><?php echo $this->Form->input('Nursing.admission_toileting', array('label'=>false,'options'=>$options,'class' => 'textBoxExpnd','id' => 'admission_toileting'));?></td>
                      </tr>
                      <tr>
                        <td>General mobility / Gait</td>
                        <td><?php echo $this->Form->input('Nursing.usual_general_mobility', array('label'=>false,'options'=>$options,'class' => 'textBoxExpnd','id' => 'usual_general_mobility'));?></td>
                        <td><?php echo $this->Form->input('Nursing.admission_general_mobility', array('label'=>false,'options'=>$options,'class' => 'textBoxExpnd','id' => 'admission_general_mobility'));?></td>
                      </tr>
                      <tr>
                        <td>Dressing  / Grooming</td>
                        <td><?php echo $this->Form->input('Nursing.usual_dressing', array('label'=>false,'options'=>$options,'class' => 'textBoxExpnd','id' => 'usual_dressing'));?></td>
                        <td><?php echo $this->Form->input('Nursing.admission_dressing', array('label'=>false,'options'=>$options,'class' => 'textBoxExpnd','id' => 'admission_dressing'));?></td>
                      </tr>
                    </table>
                   <div>&nbsp;</div>
                   <div class="tdLabel2" style="text-align:center;"><strong>SAFETY</strong></div>
                   <div class="clr ht5"></div>
                   <table width="100%" border="0" cellspacing="0" cellpadding="0">
                   		<tr>
                        	<td width="75" class="tdLabel2">ID Band on:</td>
                            <td width="25"><?php echo $this->Form->checkbox('Nursing.id_band_on_1', array('class'=>'servicesClick','id' => 'id_band_on_1')); ?></td>
                            <td width="40" class="tdLabel2">Yes</td>
                            <td width="25"><?php echo $this->Form->checkbox('Nursing.id_band_on_2', array('class'=>'servicesClick','id' => 'id_band_on_2')); ?></td>
                            <td width="45" class="tdLabel2">No</td>
                            <td>&nbsp;</td>
                            <td width="100" class="tdLabel2">Oriented to Unit:</td>
                            <td width="25"><?php echo $this->Form->checkbox('Nursing.oriented_to_unit_1', array('class'=>'servicesClick','id' => 'oriented_to_unit_1')); ?></td>
                            <td width="40" class="tdLabel2">Yes</td>
                            <td width="25"><?php echo $this->Form->checkbox('Nursing.oriented_to_unit_2', array('class'=>'servicesClick','id' => 'oriented_to_unit_2')); ?></td>
                            <td width="45" class="tdLabel2">No</td>
                            <td>&nbsp;</td>
                            <td width="105" class="tdLabel2">Call Bell in reach:</td>
                            <td width="25"><?php echo $this->Form->checkbox('Nursing.call_bell_in_reach_1', array('class'=>'servicesClick','id' => 'call_bell_in_reach_1')); ?></td>
                            <td width="40" class="tdLabel2">Yes</td>
                            <td width="25"><?php echo $this->Form->checkbox('Nursing.call_bell_in_reach_2', array('class'=>'servicesClick','id' => 'call_bell_in_reach_2')); ?></td>
                            <td width="25" class="tdLabel2">No</td>
                        </tr>
                   </table>
                   <div class="clr ht5"></div>
                   <table width="" border="0" cellspacing="1" cellpadding="0" class="tabularForm">
                      <tr>
                   		<th>Score</th>
                        <th colspan="5" style="text-align:center;">Fall Risk Assessment Scale</th>
                     </tr>
                     <tr>
                        <td width="220">Confused - disoriented hallucinating</td>
                        <td width="60">
 <?php echo $this->Form->checkbox('Nursing.score_confused', array('class'=>'servicesClick','id' => 'score_confused')); ?> 20</td>
                        <td width="280">Post-op condition -sedated</td>
                        <td width="60">
<?php echo $this->Form->checkbox('Nursing.score_post_op_condition', array('class'=>'servicesClick','id' => 'score_post_op_condition')); ?> 10</td>
                        <td width="250">Narcotics, diuretics, antihypertensives etc.</td>
                        <td width="60">
<?php echo $this->Form->checkbox('Nursing.score_narcotics', array('class'=>'servicesClick','id' => 'score_narcotics')); ?> 10</td>
                     </tr>
                     <tr>
                        <td width="220">Unstable gait, weakness</td>
                        <td width="60">
<?php echo $this->Form->checkbox('Nursing.score_unstable_gait', array('class'=>'servicesClick','id' => 'score_unstable_gait')); ?> 20</td>
                        <td width="280">Drug or alcohol withdrawal</td>
                        <td width="60">
<?php echo $this->Form->checkbox('Nursing.drug', array('class'=>'servicesClick','id' => 'score_drug')); ?> 10</td>
                        <td width="250">Bowel, bladder urgency-incontinence</td>
                        <td width="60">
<?php echo $this->Form->checkbox('Nursing.score_bowel', array('class'=>'servicesClick','id' => 'score_bowel')); ?> 10</td>
                     </tr>
                     <tr>
                        <td width="220">Hx of syncope or seizures</td>
                        <td width="60">
<?php echo $this->Form->checkbox('Nursing.score_hx', array('class'=>'servicesClick','id' => 'score_hx')); ?> 15</td>
                        <td width="280">Use of walker, cane crutches etc.</td>
                        <td width="60">
<?php echo $this->Form->checkbox('Nursing.score_walker', array('class'=>'servicesClick','id' => 'score_walker')); ?> 10</td>
                        <td width="250">Age 70 or more</td>
                        <td width="60">
 <?php echo $this->Form->checkbox('Nursing.score_age_70_more', array('class'=>'servicesClick','id' => 'score_age_70_more')); ?> 5</td>
                     </tr>
                     <tr>
                        <td width="220">Recent Hx of falls</td>
                        <td width="60">
 <?php echo $this->Form->checkbox('Nursing.score_recent_hx_of_fall', array('class'=>'servicesClick','id' => 'score_recent_hx_of_fall')); ?> 15</td>
                        <td width="280">Postural hypo tension</td>
                        <td width="60">
 <?php echo $this->Form->checkbox('Nursing.score_postural_hypo_tension', array('class'=>'servicesClick','id' => 'score_postural_hypo_tension')); ?> 10</td>
                        <td width="250">Uncooperative, impaired judgement</td>
                        <td width="60">
 <?php echo $this->Form->checkbox('Nursing.score_uncooperative_impaired_judgement', array('class'=>'servicesClick','id' => 'score_uncooperative_impaired_judgement')); ?> 5</td>
                     </tr>
                     <tr>
                        <td width="220">Age 12 or younger</td>
                        <td width="60">
<?php echo $this->Form->checkbox('Nursing.score_age_12_younger', array('class'=>'servicesClick','id' => 'score_age_12_younger')); ?> 15</td>
                        <td width="280">Poor eyesight</td>
                        <td width="60">
<?php echo $this->Form->checkbox('Nursing.score_poor_eyesight', array('class'=>'servicesClick','id' => 'score_poor_eye_sight')); ?> 10</td>
                        <td width="250">Language barrier</td>
                        <td width="60">
<?php echo $this->Form->checkbox('Nursing.score_language_barrier', array('class'=>'servicesClick','id' => 'score_language_barrier')); ?> 5</td>
                     </tr>
                     <tr>
                        <td width="220">Paralysis hemiplegia stroke</td>
                        <td width="60">
<?php echo $this->Form->checkbox('Nursing.score_paralysis_hemiplegia', array('class'=>'servicesClick','id' => 'score_paralysis_hemiplegia')); ?> 15</td>
                        <td width="280">New medications (i.e. sedative antihypertensive)</td>
                        <td width="60">
<?php echo $this->Form->checkbox('Nursing.score_new_medication', array('class'=>'servicesClick','id' => 'score_new_medication')); ?> 15</td>
                        <td width="250">Poor hearing</td>
                        <td width="60">
<?php echo $this->Form->checkbox('Nursing.score_poor_hearing', array('class'=>'servicesClick','id' => 'score_poor_hearing')); ?> 5</td>
                     </tr>
                     <tr>
                       <td colspan="5" align="right"><strong>Total</strong></td>
                       <td>&nbsp;</td>
                     </tr>
                     </table>
                   <div class="clr ht5"></div>
                   <div class="tdLabel2">If the score is &gt; 25-fall prevention initiated</div>
                	<div>&nbsp;</div>
                    <div class="clr ht5"></div>
                    <div class="tdLabel2"><strong>SKIN ASSESSMENT:</strong></div>
                   	<div class="clr ht5"></div>
                    <div class="tdLabel2" style="font-size:12px;"><strong>BRADEN SCALE TOTAL SCORE: Total Score:</strong></div>                    
                   	<div class="clr ht5"></div>
                    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm">
                      	<tr>
                   			<th width="200">Sensory perception</th>
                            <th width="200">Moisture</th>
                            <th width="200">Activity</th>
                            <th width="200">Mobility</th>
                            <th width="200">Nutrition</th>
                            <th width="200">Friction / shear</th>
                        </tr>
                        <tr>
                        	<td><?php echo $this->Form->checkbox('Nursing.completely_limited', array('class'=>'servicesClick','id' => 'completely_limited')); ?> 1- Completely limited</td>
                            <td><?php echo $this->Form->checkbox('Nursing.always_moist', array('class'=>'servicesClick','id' => 'always_moist')); ?> 1- Always moist</td>
                            <td><?php echo $this->Form->checkbox('Nursing.bed_rest', array('class'=>'servicesClick','id' => 'bed_rest')); ?> 1- Bed rest</td>
                            <td><?php echo $this->Form->checkbox('Nursing.completely_immobile', array('class'=>'servicesClick','id' => 'completely_immobile')); ?> 1- Completely Immobile</td>
                            <td><?php echo $this->Form->checkbox('Nursing.very_poor', array('class'=>'servicesClick','id' => 'very_poor')); ?> 1- Very poor</td>
                            <td><?php echo $this->Form->checkbox('Nursing.problem', array('class'=>'servicesClick','id' => 'problem')); ?> 1- Problem</td>
                        </tr>
                        <tr>
                        	<td><?php echo $this->Form->checkbox('Nursing.very_limited', array('class'=>'servicesClick','id' => 'very_limited')); ?> 2- Very limited</td>
                            <td><?php echo $this->Form->checkbox('Nursing.very_moist', array('class'=>'servicesClick','id' => 'very_moist')); ?> 2- Very moist</td>
                            <td><?php echo $this->Form->checkbox('Nursing.chair_rest', array('class'=>'servicesClick','id' => 'chair_rest')); ?> 2- Chair rest</td>
                            <td><?php echo $this->Form->checkbox('Nursing.very_limited', array('class'=>'servicesClick','id' => 'very_limited')); ?> 2- Very limited</td>
                            <td><?php echo $this->Form->checkbox('Nursing.probably_inadequate', array('class'=>'servicesClick','id' => 'probably_inadequate')); ?> 2- Probably inadequate</td>
                            <td><?php echo $this->Form->checkbox('Nursing.potential_problem', array('class'=>'servicesClick','id' => 'potential_problem')); ?> 2- Potential problem</td>
                        </tr>
                        <tr>
                        	<td><?php echo $this->Form->checkbox('Nursing.slightly_limited', array('class'=>'servicesClick','id' => 'slightly_limited')); ?> 3- Slightly limited</td>
                            <td><?php echo $this->Form->checkbox('Nursing.occasionally_moist', array('class'=>'servicesClick','id' => 'occasionally_moist')); ?> 3- Occasionally moist</td>
                            <td><?php echo $this->Form->checkbox('Nursing.walks_occasionally', array('class'=>'servicesClick','id' => 'walks_occasionally')); ?> 3- Walks occasionally</td>
                            <td><?php echo $this->Form->checkbox('Nursing.slightly_limited_mobility', array('class'=>'servicesClick','id' => 'slightly_limited_mobility')); ?> 3- Slightly limited</td>
                            <td><?php echo $this->Form->checkbox('Nursing.adequate', array('class'=>'servicesClick','id' => 'adequate')); ?> 3- Adequate</td>
                            <td><?php echo $this->Form->checkbox('Nursing.no_apparent_problem', array('class'=>'servicesClick','id' => 'no_apparent_problem')); ?> 3- No apparent problem</td>
                        </tr>
                        <tr>
                        	<td><?php echo $this->Form->checkbox('Nursing.sensory_perception_no', array('class'=>'servicesClick','id' => 'sensory_perception_no')); ?> 4- No</td>
                            <td><?php echo $this->Form->checkbox('Nursing.rarely_moist', array('class'=>'servicesClick','id' => 'rarely_moist')); ?> 4- Rarely moist</td>
                            <td><?php echo $this->Form->checkbox('Nursing.walks_frequently', array('class'=>'servicesClick','id' => 'walks_frequently')); ?> 4- Walks frequently</td>
                            <td><?php echo $this->Form->checkbox('Nursing.no_limitation', array('class'=>'servicesClick','id' => 'no_limitation')); ?> 4- No limitation</td>
                            <td><?php echo $this->Form->checkbox('Nursing.excellent', array('class'=>'servicesClick','id' => 'excellent')); ?> 4- Excellent</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan="5" align="right"><strong>Total</strong></td>
                          <td>&nbsp;</td>
                        </tr>
                    </table>
                    <div class="clr ht5"></div>
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" class="tdLabel2" style="font-style:italic;">
                    	<tr>
                        	<td height="25" colspan="5" valign="top">For Score < 17, initiate Skin Care Plan</td>
                      </tr>
                    	<tr>
                        	<td width="300">Risk Levels: Score 15 or 16 - Low risk,</td>
                            <td>&nbsp;</td>
                            <td width="300" align="center">Score 14 or 13 - Moderate risk</td>
                            <td>&nbsp;</td>
                            <td width="160">Score 12 or less - High risk</td>
                        </tr>                        
                    </table>
                    
                   <div>&nbsp;</div>
                   <div class="clr ht5"></div>
                 
				<div class="btns">
				<?php

					//echo $this->Html->link('Save',array('action'=>'assessment_second_admission'),array('class'=>'blueBtn','escape'=>false));
				?>
				<input class="blueBtn" type="submit" value="Save" id="save">
					       <input name="" type="button" value="Print" class="blueBtn" tabindex="18"/>
			 
<?php echo $this->Form->end(); ?>				
				
                     </div>
                    <div class="clr ht5"></div>
                   <!-- Right Part Template ends here -->
                   </td>
<script>
jQuery(document).ready(function(){
	$( "#date" ).datepicker({
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
}