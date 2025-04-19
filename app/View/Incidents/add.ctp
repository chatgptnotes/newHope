<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
		jQuery("#incidentAddForm").validationEngine();
	});
</script>
<!-- Right Part Template -->
 <?php echo $this->Form->create('incident',array('url'=>array('controller'=>'incidents','action'=>'add',$this->params['pass'][0])));
//echo $this->Form->hidden('Incident.patient_id',array('value'=>$patient_id));
$patient_id = $this->params['pass'][0];
echo $this->Form->hidden('Incident.id');
#pr($this->data['Incident']['patient_id']);exit;
//pr($this->data);exit; ?>          
                    
<div class="inner_title">
  <h3>Incident Reporting Form</h3>
</div>
<p class="ht5"></p>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
  <tr>
	<th> Who was harmed or nearly harmed?</th>
  </tr>                      
  <tr>
	<td width="100%" style="padding:8px;">
		<table width="" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td width="25">
                     <?php if(isset($this->data['Incident']['who_harmed']) && $this->data['Incident']['who_harmed']=="Patient"){?>
                     <input type="radio" value="Patient" name="data[Incident][who_harmed]" checked="checked"/>
                     <?php }else{?>
                     <input type="radio" value="Patient" name="data[Incident][who_harmed]" checked="checked"/>
                     <?php }?>
                     </td>
					<td width="70">Patient</td>
					 <td width="25">
					  <?php if(isset($this->data['Incident']['who_harmed']) && $this->data['Incident']['who_harmed']=="Employee"){?>                    
					   <input type="radio" value="Employee" name="data[Incident][who_harmed]" checked="checked"/>
					   <?php }else{?>
					   <input type="radio" value="Employee" name="data[Incident][who_harmed]" />
					   <?php }?>
					  </td>
					  <td width="90">Employee</td>
					  <td width="25">
						<?php if(isset($this->data['Incident']['who_harmed']) && $this->data['Incident']['who_harmed']=="Visitor"){?>
						<input type="radio" value="Visitor" name="data[Incident][who_harmed]" checked="checked"/>
						<?php }else{?>
						<input type="radio" value="Visitor" name="data[Incident][who_harmed]" />
						<?php }?>
					  </td>
					  <td width="70">Visitor</td>
					  <td width="25">
						<?php if(isset($this->data['Incident']['who_harmed']) && $this->data['Incident']['who_harmed']=="Doctor"){?>
						<input type="radio" value="Doctor" name="data[Incident][who_harmed]" checked="checked"/>
						<?php }else{?>
						<input type="radio" value="Doctor" name="data[Incident][who_harmed]" />
						<?php }?>
						</td>
                    
						<td width="70">Doctor</td>
					</tr>                                
				</table>
			</td>                        
		  </tr>
		</table>					
		<div>&nbsp;</div>
		
		<table width="100%" cellpadding="0" cellspacing="0" border="0" class="formFull">
			<tr>
				<th> Inpatient / Outpatient Incident </th>
			</tr> 
			<tr>
			  <td width="100%" valign="top" align="left" style="padding:8px;"><table width="" cellpadding="0" cellspacing="0" border="0">
				<tr>
				  <td width="25">
					<?php if(isset($this->data['Incident']['inpatient_outpatient']) && $this->data['Incident']['inpatient_outpatient']=="Inpatient"){?>
					<input type="radio" value="Inpatient" name="data[Incident][inpatient_outpatient]" checked="checked"/>
					<?php }elseif($patient_details['Patient']['admission_type']=='IPD'){?>
					<input type="radio" value="Inpatient" name="data[Incident][inpatient_outpatient]" checked="checked"/>
					<?php }else{?>
					<!--<input type="radio" value="Inpatient" name="data[Incident][inpatient_outpatient]"/>-->
					<?php }?>
					</td>
				  <td width="80">Inpatient</td>
				  <td width="25">
				  <?php if(isset($this->data['Incident']['inpatient_outpatient']) && $this->data['Incident']['inpatient_outpatient']=="Outpatient"){?>                            
				  <input type="radio" value="Outpatient" name="data[Incident][inpatient_outpatient]" checked="checked"/>
				  <?php }elseif($patient_details['Patient']['admission_type']=='OPD'){?>
				  <input type="radio" value="Outpatient" name="data[Incident][inpatient_outpatient]" checked="checked" />
				  <?php }else{?>
				  <!--<input type="radio" value="Outpatient" name="data[Incident][inpatient_outpatient]" />-->
				  <?php }?>
				  </td>
				  <td>Incident Type: </td>	 <td width="48%"><?php 
			 		//$patient_fall  = array('patient fall'=>'patient fall','bed sores'=>'bed sores','needle stick injury'=>'needle stick injury','tranfusion error'=>'tranfusion error','other'=>'other');
					echo $this->Form->input('Incident.analysis_option', array('type'=>'select','class' => 'textBoxExpnd','id' => 'analysis_option','empty'=>'Please select','options'=>$incidentType,'label'=>false,'div'=>false));
			 ?></td> 
			</tr>
		  </table></td>
		</tr>
		</table>
		<div>&nbsp;</div>

		<table width="100%" cellpadding="0" cellspacing="0" border="0" class="formFull">
		<tr>
			<th> How did you learn about the incident?</th>
		</tr> 
		<tr>
		  <td width="100%" valign="top" align="left" style="padding:8px;">
		  <table width="" cellpadding="0" cellspacing="0" border="0">
			<tr>
			  <td width="25">
			   <?php if(isset($this->data['Incident']['witness_involved']) && $this->data['Incident']['witness_involved']=="Witnesses / Involved"){?>
			   <input type="checkbox" value="Witnesses / Involved" name="data[Incident][witness_involved]" checked="checked" />
			   <?php }else{?>
			   <input type="checkbox" value="Witnesses / Involved" name="data[Incident][witness_involved]" />
			   <?php }?>
			   </td>
			  <td width="220">Witnesses / Involved</td>
			  <td width="25">
			 <?php if(isset($this->data['Incident']['report_by_patient']) && $this->data['Incident']['report_by_patient']=="Report by patient"){?>                             
			 <input type="checkbox" value="Report by patient" name="data[Incident][report_by_patient]" checked="checked"/>
			 <?php }else{?>
			 <input type="checkbox" value="Report by patient" name="data[Incident][report_by_patient]" />
			 <?php }?>
			 </td>
			  <td width="190">Report by Patient</td>
			  <td width="25">
			<?php if(isset($this->data['Incident']['report_by_family']) && $this->data['Incident']['report_by_family']=="Report by family or visitors"){?>                             
			  <input type="checkbox" value="Report by family or visitors" name="data[Incident][report_by_family]" checked="checked"/>
			<?php }else{?>
			<input type="checkbox" value="Report by family or visitors" name="data[Incident][report_by_family]" />
			<?php }?>
			  </td>
			  <td width="170">Report by Family or Visitors</td>                              
			</tr>
			<tr>
				<td>
				 <?php if(isset($this->data['Incident']['report_by_staff']) && $this->data['Incident']['report_by_staff']=="Report by another staff member"){?>
				 <input type="checkbox" value="Report by another staff member" name="data[Incident][report_by_staff]" checked="checked"/>
				 <?php }else{?>
				 <input type="checkbox" value="Report by another staff member" name="data[Incident][report_by_staff]" />
				 <?php }?>
				 </td>
				<td>Report by Another Staff Member</td>
				<td>
				 <?php if(isset($this->data['Incident']['assetment_after_incident']) && $this->data['Incident']['assetment_after_incident']=="Assessment after incident"){?>
				 <input type="checkbox" value="Assessment after incident" name="data[Incident][assetment_after_incident]" checked="checked"/>
				 <?php }else{?>
				 <input type="checkbox" value="Assessment after incident" name="data[Incident][assetment_after_incident]" />
				 <?php }?>
				 </td>
				<td>Assessment After Incident</td>
				<td>
				<?php if(isset($this->data['Incident']['review_of_record']) && $this->data['Incident']['review_of_record']=="Review of record or chart"){?>
				<input type="checkbox" value="Review of record or chart" name="data[Incident][review_of_record]" checked="checked"/>
				 <?php }else{?>
				 <input type="checkbox" value="Review of record or chart" name="data[Incident][review_of_record]" />
				 <?php }?>
				 </td>  
				<td>Review of Record or Chart</td>
			</tr>
		  </table>
		 </td>
	  </tr>
	</table>
	<div>&nbsp;</div>
	
  <table width="100%" cellpadding="0" cellspacing="0" border="0" class="formFull">
		<tr>
			<th> Name of Person Affected :</th>
		</tr> 
		<tr>
		  <td width="100%" valign="top" align="left" style="padding:8px;">
		  <table width="" cellpadding="0" cellspacing="0" border="0">
			<tr>
			  <td width="10%">Last Name:</td>

			  <td width="10%">
				  <?php 
				  if(isset($patient_uiddetails['Person']['last_name']) && $patient_uiddetails['Person']['last_name']!=''){
					echo $this->Form->input('Incident.last_name',array('readonly'=>'readonly','value'=>$patient_uiddetails['Person']['last_name'],'legend'=>false,'label'=>false, 'class'=>'textBoxExpnd','id' => 'last_name'));
				  }else{
					echo $this->Form->input('Incident.last_name',array('legend'=>false,'label'=>false,'id' => 'last_name'));
				  } 
				  ?>
				
				  <td width="10%">First Name:</td>
				  <td width="10%">
				 <?php 
				 if(isset($patient_uiddetails['Person']['first_name']) && $patient_uiddetails['Person']['first_name']!=''){                     
					echo $this->Form->input('Incident.first_name',array('readonly'=>'readonly','value'=>$patient_uiddetails['Person']['first_name'],'legend'=>false,'label'=>false, 'class'=>'textBoxExpnd','id' => 'first_name'));
				 }else{
					echo $this->Form->input('Incident.first_name',array('legend'=>false,'label'=>false,'id' => 'first_name', 'class'=>'textBoxExpnd'));
				 } 
				  ?></td>
				 
				  <td width="10%">Middle Name:</td>
				  <td width="10%">
				 <?php echo $this->Form->input('Incident.middle_name',array('legend'=>false, 'class'=>'textBoxExpnd','label'=>false,'id' => 'middle_name')); 
				  ?></td>
				</tr>
				<tr>
				  <td width="10%"><?php echo __("MRN");?></td>
				  <td width="10%">
					 <?php 
					 if(isset($patient_details['Patient']['admission_id']) && $patient_details['Patient']['admission_id']!=''){
						echo $this->Form->input('Incident.registration_no',array('readonly'=>'readonly','value'=>$patient_details['Patient']['admission_id'],'legend'=>false,'label'=>false, 'class'=>'textBoxExpnd','id' => 'registration_no'));
					 }else{
						echo $this->Form->input('Incident.registration_no',array('legend'=>false,'label'=>false,'class'=>'textBoxExpnd','id' => 'registration_no'));
					 } 
			  ?></td> 
				  
				  <td width="10%"><?php echo __('Sex'); ?></td>
				  <td width="10%">
					<?php 
					if(isset($patient_uiddetails['Person']['sex']) && $patient_uiddetails['Person']['sex']!=''){
						echo $this->Form->input('Incident.sex', array('class' => 'textBoxExpnd','id' => 'sex','value'=>ucfirst($patient_uiddetails['Person']['sex']),'readonly'=>'readonly','label'=>false)); 
					}else{
						echo $this->Form->input('Incident.sex', array('options'=>array(""=>__('Please Select Sex'),"male"=>__('Male'),'female'=>__('Female')),'class' => 'textBoxExpnd','id' => 'sex'));
					}
					?>
				  </td>
				 
				  <td width="10%">Age</td>
				  <td width="10%">
					<?php 
					if(isset($patient_uiddetails['Person']['age']) && $patient_uiddetails['Person']['age']!=''){
						echo $this->Form->input('Incident.age',array('readonly'=>'readonly', 'class'=>'textBoxExpnd','value'=>$patient_uiddetails['Person']['age'],'legend'=>false,'label'=>false,'id' => 'age')); 
					}else{
						echo $this->Form->input('Incident.age',array('legend'=>false, 'class'=>'textBoxExpnd','label'=>false,'id' => 'age'));
					}
					  ?></td>              
			</tr>
		  </table></td>
	  </tr>
	</table>
	<div>&nbsp;</div>
	
  <table width="100%" cellpadding="0" cellspacing="0" border="0" class="formFull">
	<tr>
		<th>	Location Where Incident Occurred :</th>
	</tr> 
	<tr>
	  <td width="10%" class="tdLabel" valign="top" align="left" style="padding:2px 27%;">
		<?php echo $this->Form->input('Incident.location_incident',array('type'=>'text', 'class'=>'textBoxExpnd','legend'=>false,'label'=>false,'id' => 'location_incident')); ?>
	</td>
  </tr>
</table>
<div>&nbsp;</div>
                    
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="formFull">
	<tr>
		<th> OP Visit / Admission</th>
	</tr> 
	<tr>
	  <td width="100%" valign="top" align="left" style="padding:8px;">
	  <table width="" cellpadding="0" cellspacing="0" border="0">
		<tr>
		  <td width="170">Date of OP Visit/Admission:</td>
		  <td width="235">                              
			  <?php 
			  if(isset($this->data['Incident']['op_visit_date']) && $this->data['Incident']['op_visit_date']!=''){
					echo $this->Form->input('Incident.op_visit_date',array('value'=>$this->DateFormat->formatDate2Local($this->data['Incident']['op_visit_date'],Configure::read('date_format')),'type'=>'text', 'class'=>'textBoxExpnd','legend'=>false,'label'=>false,'id' => 'op_visit_date'));
			  }else{
					echo $this->Form->input('Incident.op_visit_date',array('type'=>'text','legend'=>false, 'class'=>'textBoxExpnd','label'=>false,'id' => 'op_visit_date'));
			  }?>
		  </td>
		  <td width="20%">&nbsp;</td>
		  <td width="20%" class="tdLabel">Date and Time of Incident:<font color="red">*</font></td>
		  <td width="235">
			 <?php 
			 if(isset($this->data['Incident']['incident_date']) && $this->data['Incident']['incident_date']!=''){
				echo $this->Form->input('Incident.incident_date',array('class'=>'validate[required,custom[mandatory-date]] textBoxExpnd','value'=>$this->DateFormat->formatDate2Local($this->data['Incident']['incident_date'],Configure::read('date_format')).' '.$this->data['Incident']['incident_time'],'type'=>'text','legend'=>false,'label'=>false,'id' => 'incident_date'));
			 }else{
				echo $this->Form->input('Incident.incident_date',array('class'=>'validate[required,custom[mandatory-date]] textBoxExpnd','type'=>'text','legend'=>false,'label'=>false,'id' => 'incident_date')); 
			 }
			 ?>
		</td>		  
	</tr>
  </table>
  </td>
</tr>
</table>
<div>&nbsp;</div>
                    
  <table width="100%" cellpadding="0" cellspacing="0" border="0" class="formFull">
		<tr>
			<th>	Describe the incident in your own words: <span style="font-weight:normal;">(maximum 1000 characters)</span></th>
		</tr> 
		<tr>
		  <td width="100%" valign="top" align="left" style="padding:8px;">
				<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td>
							<?php
								
								echo __('Analysis Option');
							?>
						</td>
					</tr>
					<tr>
						<td style="padding-bottom:10px;">
							<?php echo $this->Form->textarea('Incident.incident_description', array('class' => 'textBoxExpnd','id' => 'incident_description','row'=>'3')); ?>
						</td>
					</tr>
					<tr>
						<td>Root Cause Analysis:</td>
					</tr>
					<tr>
						<td style="padding-bottom:10px;">
							<?php echo $this->Form->textarea('Incident.root_cause_ananysis', array('class' => 'textBoxExpnd','id' => 'root_cause_ananysis','row'=>'3')); ?>
						</td>
					</tr>
					<tr>
						<td>Corrective Action:</td>
					</tr>
					<tr>
						<td style="padding-bottom:10px;">
							<?php echo $this->Form->textarea('Incident.corrective_action', array('class' => 'textBoxExpnd','id' => 'corrective_action','row'=>'3')); ?>
						</td>
					</tr>
					<tr>
						<td>Preventive Action:</td>
					</tr>
					<tr>
						<td>
							<?php echo $this->Form->textarea('Incident.preventive_action', array('class' => 'textBoxExpnd','id' => 'preventive_action','row'=>'3')); ?>
						</td>
					</tr>
				</table>
				
		  </td>
		</tr>
	</table>
   <div>&nbsp;</div>
	<table width="100%" cellpadding="0" cellspacing="0" border="0" class="formFull">
		<tr>
			<th > Medication Error</th>
		</tr> 
		<tr>
		  <td width="100%" valign="top" align="left" style="padding:8px;">
				<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<tr>
					
					<td width="15%"style="padding-left:8px">
						<?php  	$error = array('extra dose'=>'extra dose','improper dose/quantity'=>'improper dose/quantity','omission'=>'omission','wrong administration technique'=>'wrong administration technique','wrong dosage form'=>'wrong dosage form','wrong drug'=>'wrong drug','wrong preparation'=>'wrong preparation','wrong patient'=>'wrong patient', 'wrong route'=>'wrong route','wrong time'=>'wrong time','other'=>'other (specify)');
						echo $this->Form->input('Incident.medication_error', array('class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd','id' => 'medication_error','empty'=>'Please select','options'=>$error,'style'=>'width:160px'));
						?>
<font color="red">*</font>

					</td>
				</tr>
				<tr>
					<td style="padding-bottom:10px;">
						<?php echo $this->Form->textarea('Incident.medication_error_desc', array('class' => 'textBoxExpnd','id' => 'medication_error_desc','row'=>'3' )); ?>
					</td>
                </tr>
              </table>
            </td>
          </tr>
         </table>
         <div>&nbsp;</div>
                  
		<table width="100%" cellpadding="0" cellspacing="0" border="0" class="formFull">
			<tr>
				<th> Harm Score <span style="font-weight:normal;">(check one)</span></th>
			</tr> 
			<tr>
			  <td width="100%" valign="top" align="left" style="padding:8px;">
				<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td style="padding-bottom:10px;">Select the highest level of harm present at the time of the incident report. If harm cannot be determined at the time of the report,then inform the administrator.</td>	
					</tr>
					<tr>
						 <td height="25" valign="top"><strong>No Actual Incident</strong></td>	
					</tr>
					<tr>
						 <td valign="top">
							<table width="100%" cellpadding="0" cellspacing="0" border="0">
								<tr>
									<td width="25" valign="top">
										<?php if(isset($this->data['Incident']['harm_score']) && $this->data['Incident']['harm_score']=="Unsafe Conditions  Incident, No Harm"){?>                      	  	
										 <input type="radio" value="Unsafe Conditions  Incident, No Harm" name="data[Incident][harm_score]" checked="checked"/>
										 <?php }else{?>
										 <input type="radio" value="Unsafe Conditions  Incident, No Harm" name="data[Incident][harm_score]" checked="checked"/>
										 <?php }?>
									</td>                                               
                                    <td valign="top" style="padding-bottom:10px;">Unsafe Conditions  Incident, No Harm</td>
                                  </tr>
                                        	                                     
   								  <tr>
								    <td width="25" valign="top">
									   <?php if(isset($this->data['Incident']['harm_score']) && $this->data['Incident']['harm_score']=="The incident did not reach the individual by chance (Near-miss)"){?>
									   <input type="radio" value="The incident did not reach the individual by chance (Near-miss)" name="data[Incident][harm_score]" checked="checked"/>
									   <?php }else{?>
									   <input type="radio" value="The incident did not reach the individual by chance (Near-miss)" name="data[Incident][harm_score]"/>
									   <?php }?>
								   </td>
                                                 
                                   <td valign="top" style="padding-bottom:10px;">The incident did not reach the individual by chance (Near-miss)</td>
                                </tr>
                                <tr>
                                    <td valign="top">
										<?php if(isset($this->data['Incident']['harm_score']) && $this->data['Incident']['harm_score']=="The incident did not reach the individual because of active recovery efforts by caregivers (Near-miss)"){?>
										<input type="radio" value="The incident did not reach the individual because of active recovery efforts by caregivers (Near-miss)" name="data[Incident][harm_score]" checked="checked"/>
										<?php }else{?>
										<input type="radio" value="The incident did not reach the individual because of active recovery efforts by caregivers (Near-miss)" name="data[Incident][harm_score]" />
										<?php }?>
									</td>
									<td valign="top" style="padding-bottom:15px;">The incident did not reach the individual because of active recovery efforts by caregivers (Near-miss)</td>
                                </tr>
                                               
                                <tr>
                                   <td valign="top">
									   <?php if(isset($this->data['Incident']['harm_score']) && $this->data['Incident']['harm_score']=="The incident reached the individual but did not cause harm (an error of omission such as a missed medication does not reach the patient)"){?>
									   <input type="radio" value="The incident reached the individual but did not cause harm (an error of omission such as a missed medication does not reach the patient)" name="data[Incident][harm_score]" checked="checked"/>
									   <?php }else{?>
									   <input type="radio" value="The incident reached the individual but did not cause harm (an error of omission such as a missed medication does not reach the patient)" name="data[Incident][harm_score]" />
									   <?php }?>
								   </td>
                               	  <td valign="top" style="padding-bottom:15px;">The incident reached the individual but did not cause harm (an error of omission such as a missed medication does not reach the patient).</td>
							  </tr>
								<tr>
								  <td valign="top">
									<?php if(isset($this->data['Incident']['harm_score']) && $this->data['Incident']['harm_score']=="The incident reached the individual and required additional monitoring or treatment to prevent harm.Incident, Harm"){?>
									<input value="The incident reached the individual and required additional monitoring or treatment to prevent harm.Incident, Harm" type="radio" name="data[Incident][harm_score]" checked="checked"/>
									 <?php }else{?>
									 <input value="The incident reached the individual and required additional monitoring or treatment to prevent harm.Incident, Harm" type="radio" name="data[Incident][harm_score]" />
									 <?php }?> 
									</td> 
                                    <td valign="top" style="padding-bottom:15px;">The incident reached the individual and required additional monitoring or treatment to prevent harm.Incident, Harm
									</td>
								  </tr>
									<tr>
									  <td valign="top">
										<?php if(isset($this->data['Incident']['harm_score']) && $this->data['Incident']['harm_score']=="The individual experienced temporary harm and required treatment or intervention"){?>                                             
										<input type="radio" value="The individual experienced temporary harm and required treatment or intervention" name="data[Incident][harm_score]" checked="checked"/>
										<?php }else{?>
										<input type="radio" value="The individual experienced temporary harm and required treatment or intervention" name="data[Incident][harm_score]" />
										<?php }?>
									</td>
                                	<td valign="top" style="padding-bottom:15px;">The individual experienced temporary harm and required treatment or intervention.</td>
								  </tr>
									<tr>
									  <td valign="top">
										<?php if(isset($this->data['Incident']['harm_score']) && $this->data['Incident']['harm_score']=="The individual experienced temporary harm and required initial or prolonged hospitalization"){?>                                            
										<input type="radio" value="The individual experienced temporary harm and required initial or prolonged hospitalization" name="data[Incident][harm_score]" checked="checked"/>
										  <?php }else{?>
										  <input type="radio" value="The individual experienced temporary harm and required initial or prolonged hospitalization" name="data[Incident][harm_score]" />
										  <?php }?>
									  </td>
                                   	  <td valign="top" style="padding-bottom:15px;">The individual experienced temporary harm and required initial or prolonged hospitalization.</td>
	                              	 </tr>
                                     <tr>
                                        <td valign="top">
											<?php if(isset($this->data['Incident']['harm_score']) && $this->data['Incident']['harm_score']=="The individual experienced permanent harm"){?>                                              
												<input type="radio" value="The individual experienced permanent harm" name="data[Incident][harm_score]" checked="checked"/>
												<?php }else{?> 
												<input type="radio" value="The individual experienced permanent harm" name="data[Incident][harm_score]" />
												<?php }?>
										</td>
									    <td valign="top" style="padding-bottom:15px;">The individual experienced permanent harm.</td>
									  </tr>
									   <tr>
										  <td valign="top">
											<?php if(isset($this->data['Incident']['harm_score']) && $this->data['Incident']['harm_score']=="The individual experienced harm and required intervention necessary to sustain life(e.g. transfer to ICU)"){?>                                              
											<input value="The individual experienced harm and required intervention necessary to sustain life(e.g. transfer to ICU)" type="radio" name="data[Incident][harm_score]" checked="checked"/>
											<?php }else{?>
											<input value="The individual experienced harm and required intervention necessary to sustain life(e.g. transfer to ICU)" type="radio" name="data[Incident][harm_score]" />
											<?php }?>
										  </td>
                                        	  <td valign="top" style="padding-bottom:15px;">The individual experienced harm and required intervention necessary to sustain life(e.g. transfer to ICU).
										   </td>
                                      	 </tr>
                                     </table>
								  </td>	
                                </tr>
                                <tr>
                                  <td height="25" valign="top" style="padding-top:5px;"><strong>Incident, Death</strong></td>
                                </tr>
                                <tr>
                                  <td valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0">
                                    <tr>
                                      <td width="25" valign="top">
										<?php if(isset($this->data['Incident']['harm_score']) && $this->data['Incident']['harm_score']=="The individual died"){?>                                      
										<input type="radio" value="The individual died" name="data[Incident][harm_score]" checked="checked"/>
										<?php }else{?>
										<input type="radio" value="The individual died" name="data[Incident][harm_score]"/>
										<?php }?>
										</td>
                                      <td valign="top">The individual died.</td>
                                    </tr>

                                  </table></td>
                                </tr>
                            </table>
                          </td>
                        </tr>
                    </table>
                    <div>&nbsp;</div>
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" class="formFull">
                    	<tr>
                        	<th> Patient clinical service/Specilty at the time of incident</th>
                      	</tr> 
                        <tr>
                       	  <td width="100%" valign="top" align="left" style="padding:8px;">
								<?php echo $this->Form->textarea('Incident.patient_clinical_service', array('class' => 'textBoxExpnd','id' => 'patient_clinical_service','row'=>'3')); ?>
						</td>
                        </tr>
                    </table>
                    <div>&nbsp;</div>
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" class="formFull">
                    	<tr>
                        	<th> Who was notified of the incident?</th>
                      	</tr> 
                        <tr>
                       	  <td width="100%" valign="top" align="left" style="padding:8px;"><table width="" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                              <td width="130">Covering Consultant:</td>
                              <td width="170">
                              	<table width="" cellpadding="0" cellspacing="0" border="0">
                                	<tr>
                                    	<td width="25">
									  <?php if(isset($this->data['Incident']['covering_consultant']) && $this->data['Incident']['covering_consultant']=="Yes"){?>
									  <input type="radio" value="Yes" name="data[Incident][covering_consultant]" checked="checked"/>
									  <?php }else{?>
									  <input type="radio" value="Yes" name="data[Incident][covering_consultant]" checked="checked"/>
									  <?php }?>
									  </td>
										<td width="35">Yes</td>
										<td width="25">
									 <?php if(isset($this->data['Incident']['covering_consultant']) && $this->data['Incident']['covering_consultant']=="No"){?>
									 <input type="radio" value="No" name="data[Incident][covering_consultant]" checked="checked"/>
									 <?php }else{?>
									 <input type="radio" value="No" name="data[Incident][covering_consultant]" />
									 <?php }?>
									 </td>
									<td width="30">No</td>
									<td width="25">
									 <?php if(isset($this->data['Incident']['covering_consultant']) && $this->data['Incident']['covering_consultant']=="NA"){?>
									 <input type="radio" value="NA" name="data[Incident][covering_consultant]" checked="checked"/>
									 <?php }else{?>
									 <input type="radio" value="NA" name="data[Incident][covering_consultant]" />
									 <?php }?>
									 
									 </td>
									<td width="50">NA</td>
								</tr>
							</table>
							
						  </td>
						  <td width="30">&nbsp;</td>
						  <td width="45">Date:</td>
						  <td width="185">
						   <?php 
						   if(isset($this->data['Incident']['notified_date']) && $this->data['Incident']['notified_date']!=''){
							echo $this->Form->input('Incident.notified_date',array('value'=>$this->DateFormat->formatDate2Local($this->data['Incident']['notified_date'],Configure::read('date_format')).' '.$this->data['Incident']['notified_time'],'type'=>'text', 'class'=>'textBoxExpnd' , 'readonly'=>'readonly','legend'=>false, 'label'=>false,'id' => 'notified_date')); 
						   }else{
								echo $this->Form->input('Incident.notified_date',array('type'=>'text', 'class'=>'textBoxExpnd','readonly'=>'readonly','legend'=>false, 'label'=>false,'id' => 'notified_date'));
						   }

						   ?>
						   </td>
              
                            </tr>

                          </table>
                          <table width="" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                              <td width="19%">Patient</td>
                              <td width="28%">
								 <?php echo $this->Form->input('Incident.notified_patient',array('legend'=>false,'label'=>false,'id' => 'notified_patient','class' => 'validate[required,custom[name],custom[onlyLetterSp]] textBoxExpnd')); ?>
							  </td>
                              <td width="108">&nbsp;</td>
                              <td width="19%">Family/designated contact</td>
                              <td width="29%">
							  <?php echo $this->Form->input('Incident.notified_family_contact',array('legend'=>false,'label'=>false, 'class'=>'textBoxExpnd','id' => 'notified_family_contact'));  ?>                         </td>                              
                            </tr>
                            <tr>
                              <td width="19%" >Director</td>
                              <td width="20%">
								 <?php echo $this->Form->input('Incident.notified_director',array('legend'=>false,'label'=>false, 'class'=>'textBoxExpnd','id' => 'notified_director')); ?>
							  </td>
                              <td>&nbsp;</td>
                              <td width="19%">Administrator</td>
                              <td width="20%">
								<?php echo $this->Form->input('Incident.notified_administrator',array('legend'=>false,'label'=>false, 'class'=>'textBoxExpnd','id' => 'notified_administrator')); ?>
								</td>
                            </tr>
                            <tr>
                              <td width="19%">Security</td>
                              <td>
								<?php echo $this->Form->input('Incident.notified_security',array('legend'=>false,'label'=>false, 'class'=>'textBoxExpnd','id' => 'notified_security')); ?>                             
								</td>
                              <td>&nbsp;</td>
                              <td width="19%">OTHER(please specify below)</td>
                              <td width="20%">
								<?php echo $this->Form->input('Incident.notified_other',array('legend'=>false,'label'=>false, 'class'=>'textBoxExpnd','id' => 'notified_other')); ?>
								</td>
                            </tr>
                          </table>
                          
                          </td>
                        </tr>
                    </table>
                    <div>&nbsp;</div>
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" class="formFull">
                    	<tr>
                        	<th> Reporter's role</th>
                      	</tr> 
                        <tr>
                       	  <td width="100%" valign="top" align="left" style="padding:8px;">
							<?php echo $this->Form->textarea('Incident.reporters_role', array('class' => 'textBoxExpnd','id' => 'reporters_role','row'=>'3')); ?>
							</td>
                        </tr>
                    </table>
                    <div>&nbsp;</div>
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" class="formFull">
                    	<tr>
                        	<th> Person Submitting Report</th>
                      	</tr> 
                        <tr>
                       	  <td width="100%" valign="top" align="left" style="padding:8px;">
                          	<table width="" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                              <td width="17%">Name:</td>
                              <td width="33%" style='padding:7px 27px;',>
								<?php echo $this->Form->input('Incident.person_submitting_report',array('legend'=>false,'label'=>false, 'class'=>'textBoxExpnd','id' => 'person_submitting_report')); ?>
							  </td>
                              <td >&nbsp;</td>
                               
                              <td width="21%">Contact No.:</td>
                              <td width="100%" style='padding-left:21px;',>
								<?php echo $this->Form->input('Incident.person_submitting_contact_no',array('legend'=>false,'label'=>false, 'class'=>'textBoxExpnd','id' => 'person_submitting_contact_no')); ?>
							   </td>                              
                            </tr>
                          </table>
                          </td>
                        </tr>
                    </table>
                    <div>&nbsp;</div>
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" class="formFull">
                    	<tr>
                        	<th> Recommendation </th>
                      	</tr> 
                        <tr>
                       	  <td width="100%" valign="top" align="left" style="padding:8px;">
							<?php echo $this->Form->textarea('Incident.recommendation', array('class' => 'textBoxExpnd','id' => 'recommendation','row'=>'3')); ?>
						  </td>
                        </tr>
                    </table>
                    
			   		<div class="btns">
                            <input class="blueBtn" type="submit" value="Save" id="save">
                          <!--     <input name="" type="button" value="Print" class="blueBtn" tabindex="18"/>-->
							 <?php 
							 if($this->data['Incident']['patient_id'] !=''){
							echo $this->Html->link('Print','#',
										 array('class'=>'grayBtn', 'escape' => false,'onclick'=>"var openWin = window.open('".html_entity_decode($this->Html->url(array('admin' => false, 'action'=>'printForm',$this->data['Incident']['patient_id']),true))."', '_blank',
										 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,left=400,top=400,width:800,height:800');  return false;"));
							 echo "&nbsp;&nbsp;&nbsp;";
							 }
							// echo $this->Html->link(__('Print'),array('action' => 'printReceipt',$patient['Patient']['id']), array('escape' => false,'class'=>'blueBtn'));
							echo $this->Html->link(__('Cancel'),array('controller'=>'Patients','action' => 'patient_information',$patient_id), array('escape' => false,'class'=>'blueBtn'));
							?>                          
 
 <!-- <input name="" type="button" value="Cancel" class="grayBtn" tabindex="19"/> -->
                     </div>
   <?php echo $this->Form->end(); ?>                
                   <!-- Right Part Template ends here -->
                   
<script>
jQuery(document).ready(function(){

	  
	// binds form submission and fields to the validation engine
	jQuery("#incident").validationEngine();
	 
	 


	$( "#op_visit_date" ).datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',			 
		dateFormat:'<?php echo $this->General->GeneralDate();?>',
		buttonText:'Date of OP Visit/Admission'
	});
	$( "#incident_date" ).datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',			 
		dateFormat:'<?php echo $this->General->GeneralDate("HH:II");?>',
		buttonText:'Date of Incident'
	});
	$( "#notified_date" ).datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',			 
		dateFormat:'<?php echo $this->General->GeneralDate("HH:II");?>',
		buttonText:'Date of Incident'
	});

	//display textarea for options
	/*$('#medication_error').change(function() {
 
		if($(this).val()=='other'){
				$('#medication_error_desc').fadeIn();
		}else{
				$('#medication_error_desc').fadeOut();
		}
	});

	$('#analysis_option').change(function() {
 
		if($(this).val()=='other'){
				$('#incident_description').fadeIn();
		}else{
				$('#incident_description').fadeOut();
		}
	});*/
	
});

</script>                   