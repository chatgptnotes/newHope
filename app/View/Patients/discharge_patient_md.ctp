<style>
*{margin:0px; padding:0px;}
.clear{clear:both;}
input, select {margin-right: 5px;}
.radio label{float:inherit}
.label_cls label{float:inherit}
.ul li{margin-top:10px;}
.plan_dis_ul li{list-style:none; margin-top:5px; }
.plan_dis li{list-style:none; margin-top:5px;}
.plan_dis{border:1px solid #4D5F66;padding-left:4px;}
.gap{margin:5px;}
.

.header{width:77%; background:#607A85; height:40px; padding-left:20px}
.sub_header{width:59%; background:#4d5f66; height:25px; padding-left:20px; padding-top:10px; margin:5px;text-align:center;}
.div_first{width:54%;margin-top: 10px;padding-left:25px;}
.div_first_left{width:50%;float:left;}
.div_first_right{width:50%;float:right}

.dis_checkdiv{width:100%;}
.dis_check1{width:36%;float:left;margin-top: 5px;}
.dis_check2{width:30%;float:left;margin-top: 5px;}
.dis_check3{width:34%;float:right;margin-top: 5px;}

.diet_acti_check{width:50%;float:left}
.addi_dis_inst{width:100%; float:left;}
.addi_dis_inst_left{width:50%; float:left;}
.addi_dis_inst_right{width:50%; float:right;}

.clininc_phone_check{float:left;margin-top:5px;padding-left: 5px;}
.clininc_phone_lbl{width:100%;margin-top:5px}

.const_schedule{float:left;margin-top:5px}
.const_schedule_lbl{width:100%;margin-top:5px}
.radio{float:left;}


</style>

<div>
<div class="header" ><h3>If form is NOT complete. SAVE then use Form Browser toUpdate/Modifyand SIGN when complete.</h3> </div>
<div class="sub_header" ><h3>Do not abbreviate! Information  on this form will be printed for patient</h3></div>

<div class="div_first">
	<div class="div_first_left"><b>Anticipated Discharge Date:</b></div>
	<div class="div_first_right">
	<?php  echo $this->Form->input('anti_discharge_date',array('id'=>'anti_discharge_date','type'=>'text','label'=>false,'size'=>"35px",'value'=>$result[BmiResult][comment]));?></div>
</div>
<div class="clear"></div>
<div class="div_first">
	<div class="div_first_left" ><b>Primary Diagnosis(at Discharge):</b></div>
	<div class="div_first_right">
	<?php  echo $this->Form->input('primary_diagno',array('id'=>'primary_diagno','type'=>'text','label'=>false,'size'=>"35px",'value'=>''));?></div>
</div>
<div class="clear"></div>
<div class="div_first">
	<div class="div_first_left" ><b>Secondary Diagnosis(at Discharge):</b></div>
	<div class="div_first_right">
	<?php  echo $this->Form->input('seco_diagno',array('id'=>'seco_diagno','type'=>'text','label'=>false,'size'=>"35px",'value'=>''));?></div>
</div>
<div class="clear"></div>

	<div class="div_first">
	<div class="div_first_left" ><b>Does Pt have Diagnosis of Congestive Heart Failure(CHF)?:</b></div>
	<div class="div_first_right radio">
	<?php	$options=array('Yes'=>'Yes','No'=>'No','Yes confort care Only'=>'Yes confort care Only');
		$attributes=array('legend'=>false,'label'=>false);
		echo $this->Form->radio('diagnosis_chf',$options,$attributes);?>
		
		
	</div>
	</div>
	<div class="clear"></div>
	<div class="div_first">
	<div class="div_first_left" ><b>Major Procedure During Inpatient Stay:</b></div>
	<div class="div_first_right"><?php  echo $this->Form->input('major_procedure',array('id'=>'major_procedure','type'=>'text','label'=>false,'size'=>"35px",'value'=>''));?></div>
</div>
	
</div>
<div class="clear"></div>
<div class="sub_header" ><h3>Post Discharge Order/Plan</h3></div>
<div style="width:70%;padding-left:25px;">
	<ul class="ul">
	<li><b>If a "Plan discharge to" is staying except "HOME:";"Facility" box is required.(FYI it will not be yellow)</b></li>
	<li><b>Facility name can be found  in teh patient White Board and will  be sent by the MSW via an alpha page</b></li>
	</ul></div>
	<div class="sub_header"> <h3>Chief Complaints</h3></div>
	<div style="width:70%;padding-left:25px;">
	<?php
													$complaints = ($this->data['DischargeSummary']['complaints'])?$this->data['DischargeSummary']['complaints']:$diagnosis['complaints']; 
													echo $this->Form->textarea('complaints', array('id' => 'complaints_desc','value'=>$complaints,'rows'=>'19','style'=>'width:98%')); 
													echo $this->Js->writeBuffer();
												?></div>
	<div class="sub_header"> <h3>Medication</h3></div>
	<div style="width:70%;padding-left:25px;">
	<ul class="ul">
	<?php	if($medication[0]['NewCropPrescription']['drug_name']!='') {?>
		<li><strong><?php echo("Current Medication:")?></strong>
					<ul>
					<?php foreach($medication as $medication){?>
			<li><strong><?php echo$medication['NewCropPrescription']['drug_name']; ?></strong> :<?php echo $medication['NewCropPrescription']['description']; }?></li>
			</ul></li><?php }?>
		</ul>
</div>

<div class="sub_header"> <h3>Investigation</h3></div>
	<div style="width:70%;padding-left:25px;">
	<?php   
								 
										$lab_ordered ='';
										if(empty($this->data['DischargeSummary']['investigation'])){
											foreach($testOrdered as $dept =>$testName){    
												if(!empty($testName)){
													foreach($testName as $name){			
														$lab_ordered .=  $name.":\n";
													}
												}
								  			}  
										}else{
											//$lab_ordered = str_replace("<br />","\n",$this->data['DischargeSummary']['investigation']); 
											$lab_ordered = $this->data['DischargeSummary']['investigation']; 
											//$lab_ordered = str_replace("<br />","\n",$lab_ordered); 
										}
										
										
										echo $this->Form->textarea('investigation', array('id' => 'investigation_desc'  ,'rows'=>'19','style'=>'width:98%','value'=>$lab_ordered)); 
										echo $this->Js->writeBuffer();
										?>
</div>


	
<div style="width:90%;margin-top: 20px;padding-left:25px;">
	<div style="width:30%;float:left"><h4>Plan Discharge To:</h4></div>
	<div style="width:32%; float:left"><h4>Facility Providing Discharge Service ti Care</h4></div>
	<div style="width:35% ;float:right;"><h4>Requested start Date for Discharge Services</h4></div>
	
	<div style="width:28%;float:left;border:1px solid #4D5F66; padding-left: 10px;"><ul class="plan_dis_ul">
	<?php $options=array('Home (0)'=>'Home (0)','Admit to other Long Term Acute Care Facility (63)'=>'Admit to other Long Term Acute Care Facility (63)',
			'Expired or cadaveric harvest (20)'=>'Expired or cadaveric harvest (20)','Home Health Service (06)'=>'Home Health Service (06)','Hospice(Home) (50)'=>'Hospice(Home) (50)',
			'Inpatient Rahab (62)'=>'Inpatient Rahab (62)','Hospice(Medical Facility) (51)'=>'Hospice(Medical Facility) (51)','Inpatient Rahab (62)'=>'Inpatient Rahab (62)','Hospice(Medical Facility) (51)'=>'Hospice(Medical Facility) (51)',
			'Interimmediate Care Facility (04)'=>'Interimmediate Care Facility (04)','Left Against Medical Advice (AMA) (07)'=>'Left Against Medical Advice (AMA) (07)','Non VMMC/Jail/Chemical Dependency(05)'=>'Non VMMC/Jail/Chemical Dependency(05)',
			'Skilled Nursing Facility (SNF) (03)'=>'Skilled Nursing Facility (SNF) (03)','Transferred to another facility (02)'=>'Transferred to another facility (02)');
		$attributes=array('legend'=>false,'label'=>false,'class'=>'radio');
		echo $this->Form->radio('plan_discharge_to',$options,$attributes);?>
	<li class=""> <input type="radio" name="sex" /> Home (0)</li>
	<li> <input type="radio"  name="sex"/> Admit to other Long Term Acute Care Facility (63)</li>
	<li> <input type="radio"  name="sex"/> Expired or cadaveric harvest (20)</li>
	<li> <input type="radio"  name="sex"/> Home Health Service (06)</li>
	<li> <input type="radio"  name="sex"/> Hospice(Home) (50)</li>
	<li> <input type="radio" name="sex"/> Hospice(Medical Facility) (51)</li>
	<li> <input type="radio" name="sex"/> Inpatient Rahab (62)</li>
	<li> <input type="radio" name="sex"/> Hospice(Medical Facility) (51)</li>
	<li> <input type="radio" name="sex"/> Interimmediate Care Facility (04)</li>
	<li> <input type="radio" name="sex"/> Left Against Medical Advice (AMA) (07)</li>
	<li> <input type="radio" name="sex"/> Non VMMC/Jail/Chemical Dependency(05)</li>
	<li> <input type="radio" name="sex"/> Skilled Nursing Facility (SNF) (03)</li>
	<li> <input type="radio" name="sex"/> Transferred to another facility (02)</li></ul></div>
	<div style="width:70%; float:left; margin-top: 10px; padding-left:10px;">
	<div style="width:42%; float:left">
	<?php echo $this->Form->textarea('facility_service_care', array('id' => ''  ,'rows'=>'','style'=>'width:80%;')); ?>
	</div>
	<div style="width:50% ;float:right"><input type="text" id="requested_start_date"/></div>
	<div class="clear"></div>
	<div style="width:33%;height:22px; float:left;background:#4d5f66;margin-top: 10px;padding-top: 8px;"><h3>Discharge Service Needed</h3></div>
	<div style="width:50%; float:right;margin-top: 10px;"><b>Checking Below any action consult to Social service, if patient has not one ordered in last 30 days</b></div>
	<div class="clear"></div>
	<div  style="width:100%; margin-top: 10px; height:150px; border:1px solid #4D5F66; padding-left:5px;">
	
		 <div class="dis_checkdiv">
				<div class="dis_check1">
				<?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Durable Medical Equipment (DME)</div>
			<div class="dis_check2" ><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Labs at next clinic visit</div>
			<div class="dis_check3" >
			<?php echo $this->Form->checkbox('clinic_visit', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>RT Consult for Home/Portable Oxygen</div>
		</div>
		
		 <div class="dis_checkdiv">
			<div class="dis_check1" ><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Financial assistance for DC meds</div>
			<div class="dis_check2" ><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Medical Social Worker</div>
			<div class="dis_check3"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Speech Therapy</div>
		</div>
		 <div class="dis_checkdiv">
			<div class="dis_check1" ><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Home Health Aide</div>
			<div class="dis_check2" ><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Occupational Therapy</div>
			<div class="dis_check3"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Transportation</div>
		</div>
		
		 <div class="dis_checkdiv">
			<div class="dis_check1" ><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Home IV Therapy</div>
			<div class="dis_check2" ><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Physiatry</div>
			<div class="dis_check3" ><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Wound care</div>
		</div>
		 <div class="dis_checkdiv">
			<div class="dis_check1"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Home Oxygen</div>
			<div class="dis_check2" ><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Physical Therapy</div>
			<div class="dis_check3"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Other</div>
		</div>
		 <div class="dis_checkdiv">
			<div class="dis_check1" ><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Homeless Shelter</div>
			<div class="dis_check2" ><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>RN Visits</div>
			
		</div>
		
	
		
	</div>
	</div>
	<div class="clear"></div>
	
	<div style="width:100%;margin-top: 20px;">
	<div style="width:50%;float:left"><h3>Diet</h3> </div>
	<div class="clear"></div>
	
	  		<div style="width:50%; background:#252C2F ">
				
						<div style="width:100%;float:left;"class="gap">
							<div class="diet_acti_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Regular Diet, as tolerated</div>
							<div class="diet_acti_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>No concentrated sweets</div>
						</div>
						
						<div style="width:100%;float:left"class="gap">
							<div class="diet_acti_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Cardiac Diet</div>
							<div class="diet_acti_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>CHF: Limit Sodium [2000 mg] & Liquids 2 L (8 cups) Daily</div>
						</div>
						
						<div style="width:100%;float:left"class="gap">
							<div class="diet_acti_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>No Added Salt</div>
							<div class="diet_acti_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Sodium Restricted - 2 gm</div>
							<div class="clear"></div>
						</div>
							<div style="width:100%;float:left"class="gap">
							<div class="diet_acti_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Low Cholesterol</div>
							<div class="diet_acti_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Fat restricted 45 gm</div>
							<div class="clear"></div>
						</div>
							<div style="width:100%;float:left"class="gap">
							<div class="diet_acti_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Bland Diet</div>
							<div class="diet_acti_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>High Fiber Diet</div>
							<div class="clear"></div>
						</div>
							<div style="width:100%;float:left"class="gap">
							<div class="diet_acti_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Low Residue Diet</div>
							<div class="diet_acti_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Dysphagia stimulation</div>
							<div class="clear"></div>
						</div>
						<div style="width:100%;float:left"class="gap">
							<div class="diet_acti_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Honey-thick liquids</div>
							<div class="diet_acti_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Nectar-thick liquids</div>
							<div class="clear"></div>
						</div>
						<div style="width:100%;float:left"class="gap">
							<div class="diet_acti_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Spoon-thick liquids</div>
							<div class="diet_acti_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Thin liquids</div>
							<div class="clear"></div>
						</div>
						<div style="width:100%;float:left"class="gap">
							<div class="diet_acti_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Protein enhanced</div>
							<div class="diet_acti_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Protein restricted, 70 gm (renal diet)</div>
							<div class="clear"></div>
						</div>
						<div style="width:100%;float:left"class="gap">
							<div class="diet_acti_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Protein restricted, 50 gm (hepatic diet)</div>
							<div class="diet_acti_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Other</div>
							<div class="clear"></div>
						</div>
						<div class="clear"></div>
			</div>
				<div class="clear"></div>
				
				
				<div style="width:48%; float:right;margin-top: -299px;;" >
				<div style="width:100%;float:left"><h3>Activity limitation</h3></div>
				<div class="clear"></div>
				<div style="background:#252C2F;width:100%;">
					<div style="width:100%;;float:left"class="gap">
						<div class="diet_acti_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>No limitations</div>
						<div class="diet_acti_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Crutches</div>
					</div>
					<div style="width:100%;float:left" class="gap">
						<div class="diet_acti_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Up as tolerated</div>
						<div class="diet_acti_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Walker</div>
					</div>
					<div style="width:100%;float:left" class="gap">
						<div class="diet_acti_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Up with Supervision only</div>
						<div class="diet_acti_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Wheel Chair</div>
					</div>
					<div style="width:100%;float:left"class="gap">
						<div class="diet_acti_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Up with Assistance only</div>
						<div class="diet_acti_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Other</div>
					</div>
					<div style="width:100%;float:left"class="gap">
						<div class="diet_acti_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>No Weight Bearing Limits</div>
						<div class="diet_acti_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Weight Bearing Limits</div>
					</div>
					<div style="width:100%;float:left"class="gap">
						<div class="diet_acti_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>No Heavy Lifting</div>
						<div class="diet_acti_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>No Driving, until approved by MD</div>
					</div>
					<div style="width:100%;float:left"class="gap">
						<div class="diet_acti_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>No Driving, while taking narcotics</div>
						<div class="diet_acti_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>No Lifting over 10 pounds</div>
					</div>
					<div style="width:100%;float:left"class="gap">
						<div class="diet_acti_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Keep back straight</div>
						<div class="diet_acti_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>No BENDING or stooping</div>
					</div>
					<div style="width:100%;float:left" class="gap">
						<div class="diet_acti_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Use upright posture - lower back supported</div>
						<div class="diet_acti_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Avoid TWISTING or REACHING across body</div>
					</div>
					<div style="width:100%;float:left" class="gap">
						<div class="diet_acti_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>No sitting more than 30 consecutive min </div>
						<div class="diet_acti_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Avoid working long periods overhead</div>
					</div>
					<div style="width:100%;float:left" class="gap">
						<div class="diet_acti_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Keep head in neutral position</div>
						<div class="diet_acti_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Cane</div>
					</div>
				</div>
				
	  	
		</div>
		
		<div style="width:60%; float:left; margin-top:50px;">
				<div class="diet_acti_check"><div style="width:100%; float:left; padding-left:4px"><h3>Discharge Home Monitoring</h3></div>
				<div style="width:80%; float:left;height:80px;background:#4D5F66;color:#000">For Patient With the CHF Diagnosis select >"Weight self daily. call if gain more than 3 lbs in 3 days.</div></div>
				
				<div style="width:50%; float:right;margin-top: 13px;">
				<ul class="plan_dis">
				<li><?php echo $this->Form->radio('',array('Weight self daily, call if fain waight'=>'Weight self daily, call if fain waight','Weight monitoring needed'=>'Weight monitoring needed','Other'=>'Other'),array('value'=>$result[BmiResult][height_volume],'class'=>"Height",'id'=>'type_height','legend'=>false,'label'=>false));?>
				</li>
				</ul>
					</div>
		</div>
		
		<div style="width:100%; float:left; margin-top:10px;">
			<div style="width:35%; float:left;">
			<div style="width:100%;float:left; ">
				<div style="width:100%;float:left"><h3>RN to provide discharge instruction per:</h3></div>
				<div style="width:80%;float:left;">
				<div style="width:100%;float:left;margin-right:5px; padding:4px;border:1px solid #4D5F66;">
				<div style="width:100%;float:left"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Discharge Diet, as tolerated</div>
				<div style="width:100%;float:left"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Additional concentrated sweets</div>
				<div style="width:100%;float:left"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Provider concentrated sweets</div>
				</div>
				</div></div>
				<div style="width:100%;float:left; margin-top:10px;"><h4>Provider Specific Discharge Instruction(such as detailed falery or dressing care)</h4></div>
				<div style="width:100%;float:left"><?php echo $this->Form->textarea('provider_discharge_instruction1', array('id' => ''  ,'rows'=>'','style'=>'')); ?></div>
				<div style="width:100%;float:left"><?php echo $this->Form->textarea('provider_discharge_instruction2', array('id' => ''  ,'rows'=>'','style'=>'')); ?></div>
			
		</div>
			
			
			<div style="width:65%; float:right;">
				<div style="width:100%; float:left; padding-left:10px"><h3>Additional discharge instruction to given a patient</h3></div>
					<div style="width:100%; float:left;border:1px solid #4D5F66; padding: 4px;">
						<div class="addi_dis_inst">
							<div class="addi_dis_inst_left"><input type="checkbox" name="vehicle"   value="Bike">Abdominal Drain output Record</div>
							<div class="addi_dis_inst_right"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Acute MI Education - per Clinical Bundle</div>
						</div>
						<div class="addi_dis_inst">
							<div class="addi_dis_inst_left"><input type="checkbox" name="vehicle"   value="Bike">CHF Education - per Clinical Bundle</div>
							<div class="addi_dis_inst_right"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Cardiac: CABG Patient Education Folder</div>
						</div>
						<div class="addi_dis_inst">
							<div class="addi_dis_inst_left"><input type="checkbox" name="vehicle"   value="Bike">Cardiac: Valve Replacement Patient Education Folder</div>
							<div class="addi_dis_inst_right"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>GI Endoscopy: Colonoscopy</div>
						</div>
						<div class="addi_dis_inst">
							<div class="addi_dis_inst_left"><input type="checkbox" name="vehicle"   value="Bike">GI Endoscopy: EGD</div>
							<div style="width:50%; float:right;"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>GI Endoscopy: ERCP</div>
						</div>
						<div class="addi_dis_inst">
							<div class="addi_dis_inst_left"><input type="checkbox" name="vehicle"   value="Bike">GI Liver Biopsy</div>
							<div class="addi_dis_inst_right"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>IR: Outpatient Angiography</div>
						</div>
						<div class="addi_dis_inst">
							<div class="addi_dis_inst_left"><input type="checkbox" name="vehicle"   value="Bike">General Angiography Instructions</div>
							<div class="addi_dis_inst_right"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>JP Drain Output Record</div>
						</div>
						<div class="addi_dis_inst">
							<div class="addi_dis_inst_left"><input type="checkbox" name="vehicle"   value="Bike">Low Back Surgery</div>
							<div class="addi_dis_inst_right"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Mastectomy Exercises</div>
						</div>
						<div class="addi_dis_inst">
							<div class="addi_dis_inst_left"><input type="checkbox" name="vehicle"   value="Bike">Neck Surgery - GHC</div>
							<div class="addi_dis_inst_right"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>PCU: Angioplasty/Stent Placement/Atherectomy</div>
						</div>
						<div class="addi_dis_inst">
							<div class="addi_dis_inst_left"><input type="checkbox" name="vehicle"   value="Bike">PCU: Cardiac Catheterization</div>
							<div class="addi_dis_inst_right"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>PCU: Cardioversion</div>
						</div>
						<div class="addi_dis_inst">
							<div class="addi_dis_inst_left"><input type="checkbox" name="vehicle"   value="Bike">PCU: Electrophysiology Study/Catheter Ablation</div>
							<div class="addi_dis_inst_right"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>PCU: Outpatient Angiography</div>
						</div>
						<div class="addi_dis_inst">
							<div class="addi_dis_inst_left"><input type="checkbox" name="vehicle"   value="Bike">PCU: Transesophageal</div>
							<div class="addi_dis_inst_right"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Percutaneous Vertebroplasty</div>
						</div>
						<div class="addi_dis_inst">
							<div class="addi_dis_inst_left"><input type="checkbox" name="vehicle"   value="Bike">RHU: per RHU Discharge Planning Manual</div>
							<div class="addi_dis_inst_right"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Short Stay Surgery Service/Post-op Instructions</div>
						</div>
						<div class="addi_dis_inst">
							<div class="addi_dis_inst_left"><input type="checkbox" name="vehicle"   value="Bike">Smoking Cessation Education</div>
							<div class="addi_dis_inst_right"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Stoma/Ostomy Care per Enterostomal Therapy</div>
						</div>
						<div class="addi_dis_inst">
							<div class="addi_dis_inst_left"><input type="checkbox" name="vehicle"   value="Bike">Stroke Education - per Clinical Bundle</div>
							<div class="addi_dis_inst_right"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Transplant Education Booklet</div>
						</div>
						<div class="addi_dis_inst">
							<input type="checkbox" name="vehicle"   value="Bike">Other
							
						</div>
					</div>
				</div>
			</div>
		
	</div>
	<div class="clear"></div>
	<div style="width:71%; float:left; margin-top:10px;">
		<div style="width:100%;text-align: center; background:#4D5F66"><h4>Follow Up Plan</h4></div>
		<div style="width:50%;float:left;margin-top:10px; ">
			<div style="width:100%;"><h4>Follow Up Appts, Procedure tests Patient To SCHEDULE</h4></div>
			<div style="width:90%;">
			<?php echo $this->Form->textarea('provider_discharge_instruction2', array('id' => ''  ,'rows'=>'','style'=>'width:100%;')); ?>
			</div>
		</div>
		<div style="width:50%; float:right;margin-top:10px; ">
			<div style="width:100%;"><h4>Use Boxes Below if more rooms needed</h4></div>
			<div style="width:90%;"><?php echo $this->Form->textarea('provider_discharge_instruction2', array('id' => ''  ,'rows'=>'','style'=>'width:100%;')); ?></div>
			<div style="width:90%; margin-top:7px;"><?php echo $this->Form->textarea('provider_discharge_instruction2', array('id' => ''  ,'rows'=>'','style'=>'width:100%;')); ?></div>
		</div>
		<div></div>
	</div>
	
	<div  style="width:100%; float:left;margin-top:10px;">
		<div style="width:84%;text-align: center; background:#4D5F66;"><b>Clinics and other frequently used Phone Number - Select as appropriate for patient reference when scheduling appointments</b></div>
		<div class="clear"></div>
		<div style="width:94%; border:1px solid #4D5F66;height:380px;margin-top:8px; ">
			<div style="width:35%;float:left;">
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">VM General Info: 206-624-1144
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">VM Toll Free Line: 1-866-TEAM-MED
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">Group Health/Family Practice: 206-326-3530
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">Group Health Anticoagmanagment: 206-326-3530
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">Group Health Home Health Services: 206-326-3530
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">Group Health/Family Neurosurgery: 206-326-3530
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">Group Health Otolaryngology: 206-326-3530
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">Group Health Surgery: 206-326-3530
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">Pacific Medical Center: 206-326-3530
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">PMC After Hours Paging Operator: 206-326-3530
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">Asthma/Allergy/Immunology: 206-326-3530
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">Audiology: 206-326-3530
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">Cardiology/Devices: 206-326-3530
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">Cardiology/Heart Institute: 206-326-3530
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">Cardiothoracic Surgery: 206-326-3530
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">Dermatology: 206-326-3530
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">Endocrinology: 206-326-3530
							</div>
				</div>
				
			<div style="width:30%;float:left;">
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">Gastroenterology: 206-223-2319
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">General Internal Medicine: 206-583-2299
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">General Surgery: 206-341-0060
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">Gynecology: 206-341-0060
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">Head & Neck Surgery: 206-341-0060
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">IR /Interventional Radiology: 206-341-0060
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">Hematology/Oncology: 206-341-0060
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">Infectious Disease: 206-341-0060
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">Nephrology: 206-341-0060
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">Neurology: 206-341-0060
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">Neurosurgery: 206-341-0060
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">Obstetrics: 206-341-0060
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">Opthomology & Optometry: 206-341-0060
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">VMMC Orthopedics: 206-341-0060
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">Otolaryngology: 206-341-0060
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">OIC/ Infusion Center: 206-341-0060
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">Plastics/Reconstructive Surgery: 206-341-0060
							</div>
							
			</div>
		
			<div style="width:30%;float:right;">
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">Psychiatry/Psychology: 206-223-6762
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">Pulmonary Clinic: 206-223-6634
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">Rheumatology: 206-223-6824
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">Radiation Oncology: 206-223-6824
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">Thracic Surgery: 206-223-6824
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">Urology: 206-223-6824
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">Vascular Surgery: 206-223-6824
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">VM Bellevue Clinic: 206-223-6824
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">VM Federal Way Clinic: 206-223-6824
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">VM Issaquah Clinic: 206-223-6824
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">VM Crickland Clinic: 206-223-6824
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">VM Lynnwood Clinic: 206-223-6824
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">VM Sand Point Pediatrics: 206-223-6824
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">VM Seattle Main Clinic: 206-223-6824
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">VM Sports Clinic: 206-223-6824
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">VM Winslow Clinic: 206-223-6824
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">Other
							</div>
			</div>
			
		</div>
		
	
	
	
	</div>
	
	
	<!-- start -->
	<div  style="width:100%; float:left;margin-top:10px;">
		<div style="width:90%;text-align: center; background:#4D5F66"><b>Consult to Schedule - PATIENT OR FAMILY NEEDS TO SET UP</b></div>
		<div class="clear"></div>
		<div style="width:100%; border:1px solid #4D5F66;height:200px;margin-top:8px; ">
			<div style="width:31%;float:left;">
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">Group Health: Resource Line 1-800-992-2279
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">Group Health: Consulting RN 1-800-297-6877
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">VMMC Anticoagulation Clinic: 206-223-6664
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">VMMC Cardiac Rehab: 206-625-7256
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">VMMC Diabetes Center: 206-583-6455
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">VMMC Gastroenterology: 206-223-2319
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div class="clininc_phone_lbl">VMMC Hyperbaric Medicine: 206-583-6543
							</div>
							
				</div>
				
			<div style="width:31%;float:left;">
							
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div style="width:100%;margin-top:5px">VMMC Medical Oncology: 206-223-6193
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div style="width:100%;margin-top:5px">VMMC Nutritional Services: 206-223-6729
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div style="width:100%;margin-top:5px">VMMC Physical Therapy: 206-223-6746
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div style="width:100%;margin-top:5px">VMMC Pulmonary Function Lab: 206-223-6767
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div style="width:100%;margin-top:5px">VMMC Radiology Scheduling: 206-223-6901
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div style="width:100%;margin-top:5px">VMMC Sleep Medicine: 206-625-7180
							</div>
							<div class="clininc_phone_check"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div >VMMC Stroke Center Clinic: 206-341-0420
							</div>
							
							
							
			</div>
		
			<div style="width:31%;float:right;">
							<div style="float:left;"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div style="width:100%;">Psychiatry/Psychology: 206-223-6762
							</div>
							<div style="float:left; margin-top:5px"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div style="width:100%;margin-top:5px">VMMC Stroke Rehab Clinic: 206-341-0420
							</div>
							<div style="float:left;margin-top:5px"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div style="width:100%;margin-top:5px">Tabacco Cessation (WA State) 1-877-270-7867
							</div>
							<div style="float:left;margin-top:5px"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?></div><div style="width:100%;margin-top:5px">Other
							</div>
							
							
							
			</div>
			
		</div>
		
	
	
	
	</div>
	<!-- end -->
	
	 
	 <div style="width:80%; ">
	 <div style="width:40%;float:left;margin-top:10px;">
	 <div style="width:100%;float:left;"><b>Call Provider if you experience</b></div>
	 <div style="width:100%;float:left;margin-top:10px; background:#252C2F;padding-left:7px;">
	 	<div style="float:left;width:100%; margin-top:5px;"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Chest Pain</div>
		<div style="float:left;width:100%;margin-top:5px;"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Increasing redness of wound</div>
		<div style="float:left;width:100%;margin-top:5px;"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Increasing wound drainage</div>
		<div style="float:left;width:100%;margin-top:5px;"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Naursea and vomiting</div>
		<div style="float:left;width:100%;margin-top:5px;"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Temperature > 101 degrees F (38.3c)</div>
		<div style="float:left;width:100%;margin-top:5px;"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Seizure</div>
		<div style="float:left;width:100%;margin-top:5px;"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Severe or positional headache</div>
		<div style="float:left;width:100%;margin-top:5px;"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Shortness of Breath</div>
		<div style="float:left;width:100%;margin-top:5px;"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Post IR: Abdominal pain</div>
		<div style="float:left;width:100%;margin-top:5px;"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Post IR: Bright red bleeding from puncture site</div>
		<div style="float:left;width:100%;margin-top:5px;"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Post IR: Coldness, numbness, weakness in leg</div>
		<div style="float:left;width:100%;margin-top:5px;"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Post IR: Increased pain/swelling at puncture site</div>
		<div style="float:left;width:100%;margin-top:5px;"><?php echo $this->Form->checkbox('', array('class'=>'','id' => '','label'=>false,'checked'=>'',));?>Other</div>
		
	 </div>
	  <div style="width:100%;float:left;margin-top:10px;">
	 	<div style="float:left;width:100%"><b>PCP or refferring MD Contracted by Discharging Provider</b></div>
	
		<div style="float:left;width:100%"margin-top:10px;>
		<?php echo $this->Form->textarea('pcp_reffering_md', array('id' => ''  ,'rows'=>'','style'=>'')); ?></div>
		
	 </div>
	 
	 
	 </div>
	 
	 <div style="width:50%;float:right;margin-top:10px;">
	 <div style="width:100%;float:left;"> <b>Provider to call for surgical questions</b></div>
	 <div style="width:100%;float:left;margin-top:10px;">
	 	<div style="float:left;width:100%">
	 	<?php echo $this->Form->textarea('provider_to_call_surgical', array('id' => ''  ,'rows'=>'','style'=>'')); ?></div>
		
	 </div>
	 <div style="width:100%;float:left;"> Provider to call for Medical questions</div>
	 <div style="width:100%;float:left;">
	 	<div style="float:left;width:100%;margin-top:10px;"><?php echo $this->Form->textarea('provider_to_call_medical', array('id' => ''  ,'rows'=>'','style'=>'')); ?></div>
		
	 </div>
	 
	 <div style="width:100%;float:left;"> freetext Box to outside providers. Enter full name.</div>
	 <div style="width:100%;float:left;">
	 	<div style="float:left;width:100%;margin-top:10px;">
	 	<?php echo $this->Form->textarea('freetext_box_out_provider', array('id' => ''  ,'rows'=>'','style'=>'')); ?></div>
		
	 </div>
	 
	  <div style="width:100%;float:left;"> Attending Physician at Discharge.</div>
	 <div style="width:100%;float:left;">
	 	<div style="float:left;width:100%;margin-top:10px;">
	 	<?php echo $this->Form->textarea('attending_physician_discharge', array('id' => ''  ,'rows'=>'','style'=>'')); ?></div>
		
	 </div>
	 <div style="width:100%;float:left;"> Provider to do discharge Summery.</div>
	 <div style="width:100%;float:left;">
	 	<div style="float:left;width:100%;margin-top:10px;margin-bottom: 5px;">
	 	<?php echo $this->Form->textarea('provider_discharge_summary', array('id' => ''  ,'rows'=>'','style'=>'')); ?></div>
		
	 </div>
	 </div>
	
	
</div>
</div>
<script>
$("#anti_discharge_date")
.datepicker(
		{
			showOn : "button",
			buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly : true,
			changeMonth : true,

			changeYear : true, 
			yearRange: "-80:+0",
			date_format_us : 'mm/dd/yy ',
			onSelect : function() {
				$(this).focus();
				//foramtEnddate(); //is not defined hence commented
			}	
			
		});
$("#requested_start_date")
.datepicker(
		{
			showOn : "button",
			buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly : true,
			changeMonth : true,

			changeYear : true, 

			date_format_us : 'mm/dd/yy ',
			onSelect : function() {
				$(this).focus();
				//foramtEnddate(); //is not defined hence commented
			}	
			
		});</script>