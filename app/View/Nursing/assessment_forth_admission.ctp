<?php echo $this->Form->create('nursings',array('controller'=>'incidents','action'=>'assessment_first_admission','id'=>'ConsultantBilling','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false,
																								        'legend'=>false,
																								        'fieldset'=>false
																								    )
			));
//echo $this->Form->hidden('Nursing.patient_id',array('value'=>$patient_details['Patient']['id']));
//echo $this->Form->hidden('Nursing.id');			
 $options = array('Yes' => 'Yes', 'No' => 'No');			
?>
<td valign="top" align="left" class="rightTopBg">
                    <!-- Right Part Template -->
                    
                    
                  	<div class="inner_title">
                     	<h3><?php echo __('Nursing Assessment on Admission', true); ?></h3>
                  	</div>
                   <p class="ht5"></p>  
                   <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm">
                   	  <tr>
                      	 <th>
                         	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                            	<tr>
                                    <td width="50"><?php echo __('GENITOURINARY', true); ?></td>                                    
                                    <td width="22">
                                     <?php echo $this->Form->checkbox('Nursing.nsf', array('class'=>'servicesClick','id' => 'nsf')); ?></td>
                                    <td width="800"><?php echo __('NSF', true); ?></td>
                                                          
                                </tr>
                            </table>
                         </th>
          			  </tr>
                      <tr>
                        <td width="100%" align="left" valign="middle" style="padding-top:7px;">
                   			<table width="100%" border="0" cellspacing="0" cellpadding="0">
                            	<tr>
                                	<td height="35" width="104" align="right"><?php echo __('Color of urine', true); ?></td>
                                    <td colspan="6">
                                    <?php echo $this->Form->input('Nursing.color_urine', array('class'=>'textBoxExpnd','id' => 'color_urine', 'style' => 'width:87%;')); ?>
                                    </td>
                                   
                                </tr>
                            	<tr>
                               	  <td align="right"><?php echo __('Frequency', true); ?></td>
                                    <td width="199">
                                     <?php echo $this->Form->input('Nursing.frequency', array('class'=>'textBoxExpnd','id' => 'frequency', 'style' => 'width:74%;')); ?>
                                    </td>
                                    
                                    <td width="37" align="right"><?php echo __('Odor', true); ?></td>
                                    <td width="85"><?php echo $this->Form->radio('Nursing.odor',$options,array('legend'=>false,'label'=>false));?></td>
                   	  				
                                    <td width="400"><?php echo $this->Form->input('Nursing.odor_text', array('class'=>'textBoxExpnd','id' => 'odor_text', 'style' => 'width:75%;')); ?></td>
                                   
                                </tr>
                            </table>
                            
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            	<tr>
                               	  	<td width="120" height="30" align="right"><?php echo __('Flank pain', true); ?></td>
                              		<td width="180"><?php echo $this->Form->radio('Nursing.flank_pain',$options,array('legend'=>false,'label'=>false));?></td>
                              		
                                    <td width="100" align="right"><?php echo __('Burning', true); ?></td>                      
                                    <td width="80">	<?php echo $this->Form->radio('Nursing.burning',$options,array('legend'=>false,'label'=>false));?></td>                                    
                                    <td align="right"><?php echo __('Incontinence', true); ?></td>
                            	  <td><?php echo $this->Form->radio('Nursing.incontinence',$options,array('legend'=>false,'label'=>false));?></td>
                                    
                                   
                           			
                                </tr>
                             <tr>
                            	  <td height="30" align="right"><?php echo __('Difficulty in starting', true); ?></td>
                            	  <td><?php echo $this->Form->radio('Nursing.difficult_start',$options,array('legend'=>false,'label'=>false));?></td>                                 
                            	  <td align="right"><?php echo __('Urgency', true); ?></td>
                            	  <td><?php echo $this->Form->radio('Nursing.urgency',$options,array('legend'=>false,'label'=>false));?></td>
                                  <td align="right"><?php echo __('Urostomy', true); ?></td>
                            	  <td><?php echo $this->Form->radio('Nursing.urostomy',$options,array('legend'=>false,'label'=>false));?></td>
                          	  </tr>
                              <tr>
                            	  <td height="30" align="right"><?php echo __('Itching', true); ?></td>
                            	  <td><?php echo $this->Form->radio('Nursing.genitourinary_itching',$options,array('legend'=>false,'label'=>false));?></td>
                   	  			 
                            	  <td align="right"><?php echo __('Nocturia', true); ?></td>
                            	  <td><?php echo $this->Form->radio('Nursing.nocturia',$options,array('legend'=>false,'label'=>false));?></td>
                   	  			  <td>&nbsp;</td>
								  <td>&nbsp;</td>                           	  
                   	  			 
                          	  </tr>
                              <tr>
                            	  <td height="30" align="right"><?php echo __('Hx of calculi', true); ?></td>
                            	  <td><?php echo $this->Form->radio('Nursing.hx_calculi',$options,array('legend'=>false,'label'=>false));?></td>
                   	  			  
                            	  <td align="right"><?php echo __('Hx UTI', true); ?></td>
                            	  <td><?php echo $this->Form->radio('Nursing.hx_uti',$options,array('legend'=>false,'label'=>false));?></td>
                   	  			  <td>&nbsp;</td>
								  <td>&nbsp;</td>
                            	  
                          	  </tr>
                              <tr>
                            	  <td height="30" align="right"><?php echo __('Foleys Catheter', true); ?></td>
                            	  <td><?php echo $this->Form->radio('Nursing.foleys_catheter',$options,array('legend'=>false,'label'=>false));?></td>
       	  						  
                            	  <td><?php echo __('Date of Insertion', true); ?></td>
                           		  <td><table width="165" border="0" cellspacing="0" cellpadding="0" >
										  <tr>
											<td width="100%">
											 <?php echo $this->Form->input('Nursing.date_insertion', array('type'=>'text','id' => 'date_insertion', 'class' => 'textBoxExpnd','style'=>'width:67%')); ?>
											</td>
											<td width="25" align="right"></td>
										  </tr>
									</table>
								</td>
								
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
                                	<td width="50"><?php echo __('REPRODUCTIVE', true); ?></td>                                    
                                    <td width="22"><?php echo $this->Form->checkbox('Nursing.reproductive_nsf', array('id' => 'reproductive_nsf')); ?></td>
                                    <td width="50"><?php echo __('NSF', true); ?></td>
                                    <td>&nbsp;</td>                                    
                                </tr>
                            </table>
                         </th>
          			  </tr>
                      <tr>
                        <td width="100%" align="left" valign="middle" style="padding-top:7px;">
                   			<table width="100%" border="0" cellspacing="0" cellpadding="0">
                            	<tr>
                                	<td width="40" align="right"><?php echo __('LMP', true); ?>:</td>
                                    <td>
                                    <?php echo $this->Form->input('Nursing.lmp', array('type'=>'text','id' => 'lmp', 'class' => 'textBoxExpnd', 'style' => 'width:100%;')); ?>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            	<tr>
                               	  	<td width="120" height="30" align="right"><?php echo __('Menopausal', true); ?></td>
                              		<td width="80" ><?php echo $this->Form->radio('Nursing.menopausal',$options,array('legend'=>false,'label'=>false));?></td>
                              		<td width="55">&nbsp;</td>
                                    <td width="60" align="right"><?php echo __('Duration', true); ?></td>
                                    <td width="192">
									<?php echo $this->Form->input('Nursing.menopausal_duration', array('type'=>'text','id' => 'menopausal_duration', 'class' => 'textBoxExpnd', 'style' => 'width:60%;')); ?>
                                    </td>                                    
                              		<td width="105" align="right"><?php echo __('Dysmenorrhea', true); ?></td>
                                    <td width="80"><?php echo $this->Form->radio('Nursing.dysmenorrhea',$options,array('legend'=>false,'label'=>false));?></td>
                           			
                                </tr>
                                <tr>
                               	  	<td height="30" align="right"><?php echo __('Amenorrhea', true); ?></td>
                              		<td><?php echo $this->Form->radio('Nursing.amenorrhea',$options,array('legend'=>false,'label'=>false));?>
                              		<td>&nbsp;</td>
                                    <td align="right"><?php echo __('Duration', true); ?></td>
                                    <td>
                                     <?php echo $this->Form->input('Nursing.amenorrhea_duration', array('type'=>'text','id' => 'amenorrhea_duration', 'class' => 'textBoxExpnd', 'style' => 'width:60%;')); ?>
                                    </td>       
                                   
                              		<td align="right"><?php echo __('Vaginal discharge', true); ?></td>
                                    <td><?php echo $this->Form->radio('Nursing.vaginal_discharge',$options,array('legend'=>false,'label'=>false));?></td>
                              	    <td>&nbsp;</td>
                                	<td>&nbsp;</td>
                                </tr>
                                <tr>
                               	  	<td height="30" align="right"><?php echo __('Itching', true); ?></td>
                              		<td><?php echo $this->Form->radio('Nursing.reproductive_itching',$options,array('legend'=>false,'label'=>false));?></td>
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
                    <div>&nbsp;</div>
                    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm">
                   	  <tr>
                      	 <th>
                         	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                            	<tr>
                                	<td width="50"><?php echo __('BREAST', true); ?></td>
                                    <td width="14"><?php echo $this->Form->checkbox('Nursing.breast_na', array('class'=>'servicesClick','id' => 'breast_na')); ?></td>
                                    <td width="28"><?php echo __('NA', true); ?></td>                                    
                                    <td width="18"><?php echo $this->Form->checkbox('Nursing.breast_nsf', array('class'=>'servicesClick','id' => 'breast_nsf')); ?></td>
                                    <td width="50"><?php echo __('NSF', true); ?></td>
                                    <td>&nbsp;</td>                                    
                                </tr>
                            </table>
                         </th>
          			  </tr>
                      <tr>
                        <td width="100%" align="left" valign="middle" style="padding-top:7px;">
                        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                            	<tr>
                               	  	<td width="60" height="30" align="right"><?php echo __('Lumps', true); ?></td>
                              		<td width="80"><?php echo $this->Form->radio('Nursing.lumps',$options,array('legend'=>false,'label'=>false));?></td>
                              		<td width="100">&nbsp;</td>
                                    <td width="100" align="right"><?php echo __('Breast feeding', true); ?></td>
                              		<td width="80"><?php echo $this->Form->radio('Nursing.breast_feeding',$options,array('legend'=>false,'label'=>false));?></td>
                              		<td width="100">&nbsp;</td>
                                    <td width="190" align="right"><?php echo __('Nipple discharge / Retraction', true); ?></td>
                                    <td width="80"><?php echo $this->Form->radio('Nursing.nipple_discharge',$options,array('legend'=>false,'label'=>false));?></td>
                              		<td width="50">&nbsp;</td>
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
                                	<td width="500"><?php echo __('PSYCHOSOCIAL / CULTURAL / SPIRITUAL', true); ?></td>                                                                        
                                    <td>&nbsp;</td>                                    
                                </tr>
                            </table>
                         </th>
          			  </tr>
                      <tr>
                        <td width="100%" align="left" valign="middle" style="padding-top:7px;">
                       	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            	<tr>
                               	  <td width="161" height="35" align="right"><?php echo __('Present Occupation', true); ?></td>
                                    <td width="300">
                                    <?php echo $this->Form->input('Nursing.psy_present_location',array('legend'=>false,'label'=>false,'id' => 'psy_present_location', 'div' => false , 'class' => 'textBoxExpnd','style' => 'width:79%;')); ?>
                                    </td>
                                    <td width="30">&nbsp;</td>
                                    <td width="130" align="right"><?php echo __('Previous Occupation', true); ?></td>
                                    <td width="300">
                                     <?php echo $this->Form->input('Nursing.psy_prev_occupation',array('legend'=>false,'label'=>false,'id' => 'psy_prev_occupation', 'div' => false , 'class' => 'textBoxExpnd','style' => 'width:79%;')); ?>
                                     </td>
                                    <td>&nbsp;</td>
                                </tr>
                          </table>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            	<tr>
                               	  <td width="160" height="35"><?php echo __('Highest Level of Education', true); ?></td>
                                    <td width="257">
                                       <?php echo $this->Form->input('Nursing.psy_highest_level_education',array('legend'=>false,'label'=>false,'id' => 'psy_highest_level_education', 'div' => false , 'class' => 'textBoxExpnd')); ?>
                                    </td>
                                    <td width="34">&nbsp;</td>
                                    <td width="250"><?php echo __('Do you read and / or understand English', true); ?></td>
                                    <td width="70"><input type="radio" name="data[Nursing][understand_eng]" style="position:relative; top:2px;" value="1" /><?php echo __('Yes', true); ?></td>
                              		<td width="100"><input type="radio" name="data[Nursing][understand_eng]" style="position:relative; top:2px;" value="0" /><?php echo __('No', true); ?></td>
                                    <td>&nbsp;</td>
                              </tr>
                            </table>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            	<tr>
                               	  <td width="125" height="30"><?php echo __('Learning Limitations', true); ?>:</td>
                                    <td width="100">
                                     <?php echo $this->Form->checkbox('Nursing.learn_limitation_none',array('legend'=>false,'label'=>false,'id' => 'learn_limitation_none'));?>
                                     <?php echo __('None', true); ?>
                                    </td>
                              	    <td width="100">
                                     <?php echo $this->Form->checkbox('Nursing.learn_limitation_yes',array('legend'=>false,'label'=>false,'id' => 'learn_limitation_yes')); ?>
                                     <?php echo __('Yes', true); ?>
                                    </td>
                                    <td width="120">
                                     <?php echo $this->Form->checkbox('Nursing.learn_limitation_hearing',array('legend'=>false,'label'=>false,'id' => 'learn_limitation_hearing')); ?>
                                     <?php echo __('Hearing', true); ?>
                                    </td>
                                    <td width="100">
                                     <?php echo $this->Form->checkbox('Nursing.learn_limitation_vision',array('legend'=>false,'label'=>false,'id' => 'learn_limitation_vision')); ?>
                                     <?php echo __('Vision', true); ?>
                                    </td>
                                    <td width="150">
                                     <?php echo $this->Form->checkbox('Nursing.learn_limitation_phy_deficits',array('legend'=>false,'label'=>false,'id' => 'learn_limitation_phy_deficits')); ?>
                                     <?php echo __('Physical Deficits', true); ?></td>
                                    <td>&nbsp;</td>
                                </tr>
                            	<tr>
                            	  <td height="30" colspan="3">
                                 <?php echo $this->Form->checkbox('Nursing.learn_limitation_known_read_diffcult',array('legend'=>false,'label'=>false,'id' => 'learn_limitation_known_read_diffcult')); ?>
                                 <?php echo __('Known Reading Difficulty', true); ?></td>
                            	  <td colspan="2">
                                  <?php echo $this->Form->checkbox('Nursing.learn_limitation_emotional_distress',array('legend'=>false,'label'=>false,'id' => 'learn_limitation_emotional_distress')); ?>
                                  <?php echo __('Emotional Distress / Anxiety', true); ?>
                                  </td>
                            	  <td>
                                   <?php echo $this->Form->checkbox('Nursing.learn_limitation_social',array('legend'=>false,'label'=>false,'id' => 'learn_limitation_social')); ?>
                                   <?php echo __('Social', true); ?>
                                  </td>
                            	  <td>&nbsp;</td>
                          	  </tr>
                            </table>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            	<tr>
                               	  <td width="150" height="35"><?php echo __('Other barriers to learning', true); ?></td>
                                    <td>
                                     <?php echo $this->Form->input('Nursing.other_barriers_learn',array('div' => false, 'class' => 'textBoxExpnd','legend'=>false,'label'=>false,'id' => 'other_barriers_learn')); ?>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                   	  	  </table>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            	<tr>
                               	  <td width="600" height="30"><?php echo __('Is there any way the Hospital can accommodate your cultural or religious beliefs or healthcare wishes?', true); ?></td>
                                    <td width="70">
                                      <input type="radio" name="data[Nursing][healthcare_wishes]" style="position:relative; top:2px;" value="1" /><?php echo __('Yes', true); ?>
                                    </td>
                              	    <td width="50">
                                     <input type="radio" name="data[Nursing][healthcare_wishes]" style="position:relative; top:2px;" value="0" /><?php echo __('No', true); ?>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                   	  	  </table>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            	<tr>
                                	<td width="60" height="35"><?php echo __('Specify', true); ?></td>
                                    <td height="35">
                                    <?php echo $this->Form->input('Nursing.psy_specify',array('div' => false, 'class' => 'textBoxExpnd','legend'=>false,'label'=>false,'id' => 'psy_specify', 'style'=> 'width:100%;')); ?>
                                    
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                            	<tr>
                            	  <td><?php echo __('Religion', true); ?>:</td>
                            	  <td>
                                  <?php echo $this->Form->input('Nursing.psy_religion',array('div' => false, 'class' => 'textBoxExpnd','legend'=>false,'label'=>false,'id' => 'psy_religion', 'style'=> 'width:100%;')); ?>
                                  </td>
                            	  <td>&nbsp;</td>
                          	  </tr>
                            </table>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="350" height="30"><?php echo __('Stress/recent life changes (moving, family loss, divorce)', true); ?></td>
                                <td width="70"><input type="radio" name="data[Nursing][psy_stress]" style="position:relative; top:2px;" value="1" /><?php echo __('Yes', true); ?></td>
                                <td width="50"><input type="radio" name="data[Nursing][psy_stress]" style="position:relative; top:2px;" value="0" /><?php echo __('No', true); ?></td>
                                <td>&nbsp;</td>
                              </tr>
                            </table>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            	<tr>
                                	<td width="110" height="35"><?php echo __('If yes, describe', true); ?></td>
                                    <td height="35">
                                     <?php echo $this->Form->input('Nursing.psy_stress_txt',array('div' => false, 'class' => 'textBoxExpnd','legend'=>false,'label'=>false,'id' => 'psy_stress_txt', 'style'=> 'width:100%;')); ?>
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
                                	<td width="250"><?php echo __('PAIN ASSESSMENT', true); ?>:</td>
                                    <td width="22">
                                     <?php echo $this->Form->checkbox('Nursing.pain_assessment_nsf', array('id' => 'pain_assessment_nsf')); ?></td>
                                    <td width="50"><?php echo __('NSF', true); ?></td>
                                    <td>&nbsp;</td>                                    
                                </tr>
                            </table>
                         </th>
          			  </tr>
                      <tr>
                        <td width="100%" align="left" valign="middle" style="padding-top:7px;">
                        	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                            	<tr>
                               	  <td>
                                   	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                              <td width="130" height="30"><?php echo __('Do you have pain now', true); ?></td>
                                              <td width="60"><input type="radio" name="data[Nursing][pain_assessment_pain]" style="position:relative; top:2px;" value="1" /><?php echo __('Yes', true); ?></td>
                                              <td width="120"><input type="radio" name="data[Nursing][pain_assessment_pain]" style="position:relative; top:2px;" value="0" /><?php echo __('No', true); ?></td>
                                              <td width="60"><?php echo __('Location', true); ?></td>
                                              <td width="120">
                                               <?php echo $this->Form->input('Nursing.pain_assessment_location',array('div' => false, 'class' => 'textBoxExpnd','legend'=>false,'label'=>false,'id' => 'pain_assessment_location')); ?>
                                              </td>       
                                              <td>&nbsp;</td>                                                
                                          </tr>
                                            <tr>
                                              <td height="35"><?php echo __('Intensity', true); ?></td>
                                              <td>
                                               <?php 
                                                   $options = array('1' => '1','2' => '2','3' => '3','4' => '4','5' => '5','6' => '6','7' => '7','8' => '8','9' => '9','10' => '10');
                                                   echo $this->Form->input('Nursing.intensity',array('div' => false, 'class' => 'textBoxExpnd','legend'=>false,'label'=>false,'id' => 'intensity', 'empty' => 'Select Intensity'));
                                               ?>
                                               </td>
                                              <td colspan="3"><?php echo __('(Select your pain using the pain scale)', true); ?></td>
                                              <td>&nbsp;</td>
                                            </tr>                                                                                       
                                   	  </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          	<tr>
                                            	<td width="130" height="30"><?php echo __('Duration', true); ?>:</td>
                                                <td colspan="2">
                                                 <?php echo $this->Form->input('Nursing.pain_assessment_duration',array('div' => false, 'class' => 'textBoxExpnd','legend'=>false,'label'=>false,'id' => 'pain_assessment_duration')); ?>
                                                </td>
                                                <td width="120">&nbsp;</td>
                                                <td>&nbsp;</td>
                                          	</tr>
                                          	<tr>
                                          	  <td width="130" height="30"><?php echo __('Quality', true); ?>:</td>
                                          	  <td width="110">
                                                   <?php echo $this->Form->checkbox('Nursing.quality_constant', array('style'=>'position:relative; top:2px;','id' => 'quality_constant')); ?><?php echo __('Constant', true); ?>
                                                  </td>
                                          	  <td width="120">
                                                   <?php echo $this->Form->checkbox('Nursing.quality_intermittent', array('style'=>'position:relative; top:2px;','id' => 'quality_intermittent')); ?><?php echo __('Intermittent', true); ?>
                                                  </td>
                                          	  <td width="120">&nbsp;</td>
                                          	  <td>&nbsp;</td>
                                       	  </tr>
                                          <tr>
                                          	  <td height="30"><?php echo __('Character', true); ?>:</td>
                                          	  <td>
                                                   <?php echo $this->Form->checkbox('Nursing.character_lacerating', array('style'=>'position:relative; top:2px;','id' => 'character_lacerating')); ?><?php echo __('Lacerating', true); ?>
                                                   </td>
                                          	  <td>
                                                  <?php echo $this->Form->checkbox('Nursing.character_burning', array('style'=>'position:relative; top:2px;','id' => 'character_burning')); ?><?php echo __('Burning', true); ?>
                                                  </td>
                                       	    	  <td>
                                                   <?php echo $this->Form->checkbox('Nursing.character_radiating', array('style'=>'position:relative; top:2px;','id' => 'character_radiating')); ?><?php echo __('Radiating', true); ?>
                                                  </td>
                                          	  <td>&nbsp;</td>
                                       	  </tr>
                                          <tr>
                                            <td height="30"><?php echo __('Exacerbating Factors', true); ?>:</td>
                                            <td colspan="2"><?php echo $this->Form->input('Nursing.exacerbating_factors', array('class'=>'textBoxExpnd','id' => 'exacerbating_factors')); ?></td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                          </tr>
                                          <tr>
                                       	  	<td height="30"><?php echo __('Relieving Factors', true); ?>:</td>
                                            	<td><?php echo $this->Form->checkbox('Nursing.relieving_factors_rest', array('style'=>'position:relative; top:2px;','id' => 'relieving_factors_rest')); ?><?php echo __('Rest', true); ?></td>
                                            	<td><?php echo $this->Form->checkbox('Nursing.relieving_factors_medication', array('style'=>'position:relative; top:2px;','id' => 'relieving_factors_medication')); ?><?php echo __('Medication', true); ?></td>
                                                <td><?php echo $this->Form->checkbox('Nursing.relieving_factors_others', array('style'=>'position:relative; top:2px;','id' => 'relieving_factors_others')); ?><?php echo __('Others', true); ?>
                                                </td>                                       	  	
                                          	  	<td>&nbsp;</td>
                                       	  </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                              <td width="195" height="30"><?php echo __('Does it affect your daily routine?', true); ?></td>
                                              <td width="60"><input type="checkbox" style="position:relative; top:2px;"/> Yes</td>
                                              <td width="120"><input type="checkbox" style="position:relative; top:2px;"/> No</td>                                              
                                              <td>&nbsp;</td>                                                
                                          </tr>
                                          <tr>
                                            <td height="30" align="right" style="padding-right:10px;">Sleep</td>
                                            <td><input type="checkbox" style="position:relative; top:2px;"/> Yes</td>
                                            <td><input type="checkbox" style="position:relative; top:2px;"/> No</td>
                                            <td>&nbsp;</td>
                                          </tr>                                                                                       
                                   	  </table>
                                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td width="160" height="35">Most likely cause of pain:</td>
                                            <td width="330" height="35"><input name="textfield4" type="text" class="textBoxExpnd" style="width:100%;"/></td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    </table>
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td width="50" height="35">Plans:</td>
                                            <td width="440" height="35"><input name="textfield4" type="text" class="textBoxExpnd" style="width:100%;"/></td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    </table>
                                  </td>
                                    <td width="30">&nbsp;</td>
                                    <td width="300" align="left" valign="top" class="tdLabel2">
                                        <table width="300" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td width="25" height="20" align="center" valign="middle"><strong>10</strong></td>
                                            <td width="20" class="hrLine">&nbsp;</td>
                                            <td width="10" class="vertLine">&nbsp;</td>
                                            <td rowspan="2" valign="top">WORST PAIN POSSIBLE<br />
                                              Unable to do any activities because of pain</td>
                                          </tr>
                                          <tr>
                                            <td height="20" align="center" valign="middle"><strong>9</strong></td>
                                            <td class="hrLine">&nbsp;</td>
                                            <td class="vertLine">&nbsp;</td>
                                          </tr>
                                          <tr>
                                          	<td colspan="4">&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td height="20" align="center" valign="middle"><strong>8</strong></td>
                                            <td class="hrLine">&nbsp;</td>
                                            <td class="vertLine">&nbsp;</td>
                                            <td rowspan="2" valign="top">INTENSE, DREADFUL HORRIBLE<br />
                                              Unable to do most activities because of pain</td>
                                          </tr>
                                          
                                          <tr>
                                            <td height="20" align="center" valign="middle"><strong>7</strong></td>
                                            <td class="hrLine">&nbsp;</td>
                                            <td class="vertLine">&nbsp;</td>
                                          </tr>
                                          <tr>
                                          	<td colspan="4">&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td height="20" align="center" valign="middle"><strong>6</strong></td>
                                            <td class="hrLine">&nbsp;</td>
                                            <td class="vertLine">&nbsp;</td>
                                            <td rowspan="2">MISERABLE DISTRESSING<br />
                                              Unable to do some activities because of pain</td>
                                          </tr>
                                          <tr>
                                            <td height="20" align="center" valign="middle"><strong>5</strong></td>
                                            <td class="hrLine">&nbsp;</td>
                                            <td class="vertLine">&nbsp;</td>
                                          </tr>
                                          <tr>
                                          	<td colspan="4">&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td height="20" align="center" valign="middle"><strong>4</strong></td>
                                            <td class="hrLine">&nbsp;</td>
                                            <td class="vertLine">&nbsp;</td>
                                            <td rowspan="2" valign="top">NAGGING UNCOMFORTABLE TROUBLE SOME<br />
                                              Can do most activities with rest period.</td>
                                          </tr>
                                          <tr>
                                            <td height="20" align="center" valign="middle"><strong>3</strong></td>
                                            <td class="hrLine">&nbsp;</td>
                                            <td class="vertLine">&nbsp;</td>
                                          </tr>
                                          <tr>
                                          	<td colspan="4">&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td height="20" align="center" valign="middle"><strong>2</strong></td>
                                            <td class="hrLine">&nbsp;</td>
                                            <td class="vertLine">&nbsp;</td>
                                            <td rowspan="2" valign="top">MILD PAIN<br />
                                              Pain is present but does not limit activities</td>
                                          </tr>
                                          <tr>
                                            <td height="20" align="center" valign="middle"><strong>1</strong></td>
                                            <td class="hrLine">&nbsp;</td>
                                            <td class="vertLine">&nbsp;</td>
                                          </tr>
                                          <tr>
                                          	<td colspan="4">&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td height="20" align="center" valign="middle"><strong>0</strong></td>
                                            <td class="hrLine">&nbsp;</td>
                                            <td class="vertLine">&nbsp;</td>
                                            <td>NO PAIN</td>
                                          </tr>
                                      </table>
                                    </td>
                              </tr>
                            </table>
                        </td>
                      </tr>
                    </table>
                    <div class="clr ht5"></div>
                	
                    
                   
<div class="btns">
                <?php

					echo $this->Html->link('Save','#',array('class'=>'blueBtn','escape'=>false)); ?>
					<input name="" type="button" value="Print" class="blueBtn" tabindex="18"/>
					<?php 
					echo $this->Html->link('Cancel',array('action'=>'assessment_first_admission'),array('class'=>'grayBtn','escape'=>false));
				?>
                    </div>
                    <div class="clr ht5"></div>
                   <!-- Right Part Template ends here -->
                   </td>
<?php echo $this->Form->end(); ?>
<script>
jQuery(document).ready(function(){
	$( "#date_insertion" ).datepicker({
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