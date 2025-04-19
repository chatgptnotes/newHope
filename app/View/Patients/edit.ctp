<?php $corporateStatus = Configure::read('corporateStatus');?>
<style>
.txtpad_align {
	padding-left: 0px !important;
}

.txtbx_align {
	width: 23% !important;
}

.textBoxExpnd {
	width: 62.3%;
}
</style>
<?php 
echo $this->Html->css(array('jquery.fancybox-1.3.4.css'/* ,'jquery.autocomplete.css' */));
//echo $this->Html->script(array('jquery.autocomplete','jquery.autocomplete.js'));
?>
<?php
// /debug($insurancecompanies);//exit;
//echo $this->Html->script(array('jquery.ui.widget.js','jquery.ui.mouse.js','jquery.ui.core.js','jquery.ui.slider.js','jquery-ui-timepicker-addon.js'));
//set array of patient category
if($this->data['Patient']['admission_type'] == "OPD"){
	$type =  'Outpatient';
	//	$buttonLabel = "Set Appointment";
	$extraButton ='Submit';
	$urlType= 'OPD';
}else{
	//$category = array('OPD'=>__('Outpatient'),'IPD'=>__('Inpatient'));
	//echo $this->Form->input('admission_type', array('empty'=>__('Please select'),'options'=>$category,'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'admission_type'));
	$type =  'Inpatient';
	//$buttonLabel = "Submit";
	$extraButton ='Submit';
	if($this->data['Patient']['is_emergency']==1) $urlType= 'emergency';
	else $urlType= 'IPD';
}
?>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Patient Information', true); ?>
	</h3>
<!-- 	<span> <?php echo $this->Html->link(__('Search Patient'), array('action' => 'search','?'=>array('type'=>$urlType)), array('escape' => false,'class'=>'blueBtn')); ?>
	</span> -->
</div>
<?php echo $this->Form->create('Patient',array('type' => 'file','id'=>'patientfrm','inputDefaults' => array(
		'label' => false,
		'div' => false,
		'error' => false
)));
echo $this->Form->hidden('patient_id',array('id'=>'patientID'));
 
 
?>
<!-- Form Left -->
<div
	class="inner_left">
	<?php 
	if(!empty($errors)) {
		?>
	<table border="0" cellpadding="0" cellspacing="0" width="60%"
		align="center">
		<tr>
			<td colspan="2" align="left" class="error"><?php 
			foreach($errors as $errorsval){
		         echo $errorsval[0];
		         echo "<br />";
		     }
		     ?>
			</td>
		</tr>
	</table>
	<?php } ?>
	<?php //BOF new form design ?>
	<!-- form start here -->
	<?php  	echo $this->Form->input('id', array('type'=>'hidden'));		 ?>
	<div class="btns">
		<input class="blueBtn" type="button" value="Cancel"
			onclick="window.location='<?php echo $this->Html->url(array("controller" => "Persons" /* $this->params['controller']  */
                      		, "action" => "patient_information",$this->data['Patient']['person_id'],'?'=>$this->params->query));?>'">
		<!--  <input class="blueBtn" type="submit" value="<?php echo $buttonLabel ;?>" id="submit"> -->
		<?php 
		if($extraButton){
				             echo $this->Form->submit($extraButton,array('type'=>'submit','class'=>'blueBtn','div'=>false,'error'=>false,'id'=>'extra1'));
				             echo $this->Form->hidden('print_sheet',array('id'=>'print_sheet','autocomplete'=>'off'));
				         }
				         ?>
	</div>
	<div class="clr"></div>
	<!-- Patient Information start here -->
	<table width="100%" border="0" cellspacing="0" cellpadding="0"
		class="formFull">
		<tr>
			<th colspan="5"><?php echo __("Patient Information") ; ?></th>
		</tr>
		<tr>
			<td width="19%" valign="middle" class="tdLabel" id=""><?php echo __("Lookup Patient Name");?><font
				color="red">*</font></td>
			<td width="30%"><table width="100%" cellpadding="0" cellspacing="0"
					border="0">
					<tr>
						<td><?php echo $this->Form->input('lookup_name', array('class' => 'validate[required,custom[name]] textBoxExpnd','id' => 'lookup_name', 'label'=> false,
			 												  'div' => false, 'error' => false,'readonly'=>'readonly')); ?>
						</td>
						<!-- <td width="35" style="padding-right:10px;">
                            	<?php
						   			//echo $this->Html->link($this->Html->image('icons/patient-name.png',array('alt'=>__('View'),'title'=>__('View'))),'#',
						   			//	   array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'persons','action'=>'patient_search'))."', '_blank',
								      //     'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=1000,height=500,left=400,top=400');  return false;"));
								           
						   			//echo  $this->Html->image('icons/eraser.png',array('alt'=>__('View'),'title'=>__('View'),'onclick'=>'clearLookup();')) ;
								?>                            	 
                            </td>-->

					</tr>
				</table></td>
			<td width="">&nbsp;</td>
			<td valign="middle" class="tdLabel txtpad_align" id="" width="19%">Age
				<font color="red">*</font>
			</td>
			<td width="30%"><?php echo $this->Form->input('age', array('type'=>'text','style'=>'width:90px;margin-right:10px;','maxLength'=>'3','readOnly'=>true,'class' => 'validate[required,custom[customage]] textBoxExpnd','id' => 'age'));
			 	echo $this->Form->input('sex', array('readonly'=>'readonly','style'=>'width:126px','options'=>array(""=>__('Please select'),"male"=>__('Male'),'female'=>__('Female')),'class' => 'validate[required,custom[patient_gender]] textBoxExpnd','id' => 'sex')); ?>

				<?php //echo $this->Form->input('age', array('class' => 'validate[required,custom[customage]] textBoxExpnd','id' => 'age')); ?>
			</td>
		</tr>
		<?php
		if(($this->data['Patient']['admission_type']=='IPD') || ($this->data['Patient']['admission_type']=='emergency') ){ ?>
		<tr>
			<!--
                        <td valign="middle" class="tdLabel" id="">Patient Name <font color="red">*</font></td>
                        <td>
                        	<?php //echo $this->Form->input('full_name', array('class' => 'validate[required,custom[name]] textBoxExpnd','id' => 'full_name')); ?>
                        </td>
                        -->
		    <td class="tdLabel " id="">Treating Consultant<font color="red">*</font></td>
			<td  width="250"><?php echo $this->Form->input('doctor_id', array('empty'=>__('Please Select'),'options'=>$doctors,'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'doctor_id',$doctor_id)); ?>

			</td>
		
			<td>&nbsp;</td>
				<td class="tdLabel txtpad_align" id="">Department</font>
			</td>
			<td><?php echo $this->Form->input('department_id', array('empty'=>__('Please Select'),'options'=>$departments,'class' => 'textBoxExpnd','id' => 'department_id','value'=>$department_id,'disabled'=>'disabled')); ?>
			<?php echo $this->Form->hidden('',array('name'=>"data[Patient][department_id]",'id'=>'d_id')); ?>
			</td>
			
		</tr>
		<?php }else{?>
		<tr>
            <td class="tdLabel " id="">Treating Consultant<font color="red">*</font></td>
			<td  width="250"><?php echo $this->Form->input('doctor_id', array('empty'=>__('Please Select'),'options'=>$opddoc,'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'doctor_id',$doctor_id)); ?>
			
			</td>	
			<td>&nbsp;</td>
			<td class="tdLabel txtpad_align" id="">Department
			</td>
			<td><?php echo $this->Form->input('department_id', array('empty'=>__('Please Select'),'options'=>$departments,'class' => 'textBoxExpnd','id' => 'department_id','value'=>$department_id,'disabled'=>'disabled')); ?>
			<?php echo $this->Form->hidden('',array('name'=>"data[Patient][department_id]",'id'=>'d_id')); ?>
			</td>
			

		</tr>
		<?php }?>
		<!--  <tr>
                        <td valign="middle" class="tdLabel" id="">Sex</td>
                        <td>
                        	<?php //echo $this->Form->input('sex', array('options'=>array(""=>__('Please select'),"male"=>__('Male'),'female'=>__('Female')),'class' => 'validate[required,custom[patient_gender]] textBoxExpnd','id' => 'sex')); ?>	
                        	
                        </td>
                        <td>&nbsp;</td>
                        <td class="tdLabel" id="">Date of Admission</td>
                        <td>
							<?php //echo $this->Form->input('dateofadmission', array('readonly','class' => 'textBoxExpnd','id' => 'dateofadmission','readonly'=>'readonly','type'=>'text','style'=>'width:85%;')); ?>
                        </td>
                     </tr> -->
		<tr>
			<?php //if($this->params->query['from'] != 'UID'){?>
		<!-- 	<td valign="middle" class="tdLabel" id="">Balance From Last Visit</td>
			<td><?php 
			//echo $this->Form->input('previous_receivable', array('class' => 'textBoxExpnd','id' => 'previous_receivable','value'=>$previousReceivable));

			?></td>
 -->
			<?php //}else{?>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<?php // }?>
			<td></td>
			<td class="tdLabel txtpad_align" id="">Category</td>
			<td><strong> <?php
			echo $type ;
			echo $this->Form->hidden('admission_type', array());
			?>
			</strong>
			</td>
		</tr>
		<tr>

			<td></td>
			<td></td>
			<td></td>
			<td colspan="2"><?php
			//visibility of ward section
			if($this->data['Patient']['admission_type']=='IPD'){
                       			$display ="block";
                       			$displayOpd ="none";
                       		}else{
                       			$display ="none";
                       			$displayOpd ="block";
                       		}
                       		?>
				<div id="wardSection" style="display:<?php echo $display ;?>;">
					<table style="width: 100%;">
						<tr>
							<td width="10%" class="tdLabel" id="" style=" padding-left: 0px !important;">Ward Allotted</td>
							<td width="16%"><strong> <?php 
							echo $this->data['Ward']['name'];
							//$rooms = $wardsAvailable;;
			                        		//echo $this->Form->input('ward_id', array('empty'=>__('Please select'),'options'=>$rooms,'id' => 'ward_id','class' => 'validate[required,custom[mandatory-select]] textBoxExpnd')); ?>
							</strong>
							</td>

						</tr>
					</table>
				</div>
				<div id="opdSection" style="display:<?php echo $displayOpd ;?>;">
					<table style="width: 100%;">
						<tr>
							<td width="19%" class="tdLabel txtpad_align" id=""><?php echo __('Visit Type', true); ?><font
								color="red">*</font></td>
							<td width="30%"><?php 
							/*	$opdoptionsNew = array(//'4' => 'First Consultation',
							 //'5' => 'Follow-Up Consultation',
			                        						'6' => 'Preventive Health Check-up',
			                        						'7' => 'Vaccination',
			                        						'8' => 'Pre-Employment Check-up',
			                        						'9' => 'Pre Policy Check up',
			                        						'0'=>'Skip Registration/Consultation'); */
			                        		echo $this->Form->input('treatment_type', array('empty'=>__('Please Select'),'options'=>$opdoptions,'id' => 'opd_id','selected'=>$ddOption, 'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd'));
			                        		?>
							</td>
						</tr>
					</table>
				</div>
			</td>
		</tr>

		<tr>
			<td class="tdLabel" id=""></td>
			<td><?php //echo $this->Form->input('doctor_id', array('empty'=>__('Please select'),'options'=>$doctors,'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'doctor_id')); ?>
			</td>
			<td></td>
			<td colspan="2">
				<div id="roomSection" style="display:<?php echo $display ;?>;">
					<table style="width: 100%;">
						<tr>
							<td width="10%" class="tdLabel" id="" style=" padding-left: 0px !important;">Room Allotted</td>
							<td width="16%"><strong> <?php 
							echo $this->data['Room']['name'];
							//$rooms = $wardsAvailable;
			                        		//echo $this->Form->input('room_id', array('empty'=>__('Please select'),'id' => 'room_id','class' => 'validate[required,custom[mandatory-select]] textBoxExpnd')); ?>
							</strong></td>
						</tr>
					</table>
				</div>
			</td>
		</tr>
		<tr>
			<td class="tdLabel" id=""></td>
			<td></td>
			<td></td>
			<td colspan="2">
				<div id="bedSection" style="display:<?php echo $display ;?>;">
					<table style="width: 100%;">
						<tr>
							<td width="10%" class="tdLabel" id="" style=" padding-left: 0px !important;">Bed Allotted</td>
							<td width="16%"><strong> <?php 
							echo $this->data['Room']['bed_prefix'].$this->data['Bed']['bedno'];
			                        		//echo $this->Form->input('bed_id', array('empty'=>__('Please select'),'id' => 'bed_id','class' => 'validate[required,custom[mandatory-select]] textBoxExpnd')); ?>
							</strong></td>
						</tr>
					</table>
				</div>
			</td>
		</tr>

		<!-- New Lines Start -->
		<tr>
			<td valign="top" class="tdLabel" id="">Email</td>
			<td valign="top"><?php echo $this->Form->input('email', array('class' => 'textBoxExpnd','id' => 'email','value'=>$result['Person']['email'])); ?>
			</td>
			<td>&nbsp;</td>
			<td></td>
		</tr>

		<!-- New Lines End -->
		<?php   if(strtolower($this->Session->read('role'))=='admin' || strtolower($this->Session->read('userid'))=='128'){  //added by pankaj w  
		$consultantData=unserialize($this->data['Patient']['consultant_id']);
		?>
		<tr>
			<td class="tdLabel " id="" valign="top"><?php echo  __('Referral Doctor'); ?><font color="red">*</font>
			</td>
			<td><?php echo $this->Form->input('known_fam_physician', array('empty'=>__('Please Select'),'autocomplete'=>"off", 'id'=>'familyknowndoctor',
					  'class'=>'textBoxExpnd validate[required,custom[mandatory-enter]]',  'options'=>$reffererdoctors,'div'=>false));
	                          	?>
	            <div style="margin-top:7%">
					<span id="refferalDocSearch" style="display: none"> 
					<?php echo $this->Form->input('doctor_name',array('class'=>'textBoxExpnd','escape'=>false,
							'label'=>false,'div'=>false,'id'=>'searchDoctor','autocomplete'=>false,'placeHolder'=>'Search Referral Doctor'));
					?>
					</span>
				</div>
				<table width="60%" id=refferalDoctorArea class="tabularForm  top" style="display: none">

				</table>
			</td>
			<td>&nbsp;</td>
			<td valign="top" class="tdLabel txtpad_align" id="">Date of Referral</td>
			<td valign="top"><?php echo $this->Form->input('Patient.date_of_referral', array('type'=>'text','class' => '','id' => 'date_of_referral')); ?>

			</td>
		</tr>
		<!-- <tr>
			<td class="tdLabel" id="" valign="top"><?php echo  __('Referral Doctor'); ?>
			</td>
			<td valign="top"><?php 
			$consultantData=unserialize($this->data['Patient']['consultant_id']);
			$referalDisplay = $this->Session->read('rolename') == configure::read('admin') ? 'block' : 'none';
			      //echo $this->Form->input('known_fam_physician', array('class' => 'textBoxExpnd','id' => 'knownPhysician')); 
					$known_fam_physician = !empty($result['Person']['known_fam_physician'])?$result['Person']['known_fam_physician']:$result['Patient']['known_fam_physician'];
							
							if($known_fam_physician and $referalDisplay == 'none'){
								echo $reffererdoctors[$known_fam_physician].'<br>';
							}else{
							echo $this->Form->input('known_fam_physician', array('empty'=>__('Please select'), 'id'=>'familyknowndoctor', 'class'=>'textBoxExpnd','value'=>$known_fam_physician,
                              'options'=>$reffererdoctors,'onchange'=> $this->Js->request(array('action' => 'getDoctorsList'),
                              array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
    							'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
    							'async' => true, 'update' => '#changeDoctorsList', 'data' => '{familyknowndoctor:$("#familyknowndoctor").val()}',
    							'dataExpression' => true, 'div'=>false))));
							}
                          ?> 
                 <span id="changeDoctorsList"> <?php
                          $displayRefererContact = 'none' ;
                          /* if($this->data['Patient']['known_fam_physician']){
                           // if consultant id  exist //
                                   if($this->data['Patient']['consultant_id']){
	                           		 echo $this->Form->input('Patient.consultant_id', array('options' => $doctorlist, 'empty' => 'Select Doctor', 'id' => 'doctorlisting',
	                           		  'label'=> false, 'div' => false, 'error' => false,'class'=>'textBoxExpnd'));
                                   } */
                           if($this->data['Patient']['known_fam_physician']){
	                           if($this->data['Patient']['known_fam_physician'] == Configure :: read('referralforregistrar')) {
	                              	echo $this->Form->input('Patient.registrar_id', array('options' => $treatmentConsultant,'value'=>$this->data['Patient']['registrar_id'],'empty' => 'Select Registrar', 'id' => 'doctorlisting', 'label'=> false, 'div' => false, 'error' => false,'style'=>"display:$referalDisplay;"));
	                              	if($referalDisplay == 'none')
	                              	echo $treatmentConsultant[$this->data['Patient']['registrar_id']];
								} else {	
									if($consultantData){
										echo $this->Form->input('Patient.consultant_id', array('options' => $treatmentConsultant,'value'=>$consultantData,'multiple' => true,'empty' => 'Please Select', 'style' => "display:$referalDisplay;", 'label'=> false, 'div' => false, 'error' => false));
										foreach($consultantData as $key =>$value){
											$consultants[] = $treatmentConsultant[$value];
										}
										if($referalDisplay == 'none')
										echo '<span style="float: left;">'.implode('<br>',$consultants).'</span>';
									}else{
										echo $this->Form->input('Patient.consultant_id', array('options' => $treatmentConsultant,'value'=>$consultantData,'multiple' => true,'empty' => 'Please Select', 'id' => 'doctorlisting', 'label'=> false, 'div' => false, 'error' => false));
									}					 
                 					
                 					
								}
                      }else{
	               echo $this->Form->input('Patient.consultant_id', array('options' => $treatmentConsultant,'value'=>$consultantData,'multiple' => true, 'id' => 'doctorlisting', 'label'=> false, 'div' => false, 'error' => false,'style'=>'display:none;'));
	                
	               // if registrar id exist //
	               if($this->data['Patient']['registrar_id']){
	                           		 	echo $this->Form->input('Patient.registrar_id', array('options' => $registrarlist, 'empty' => 'Select Doctor', 'id' => 'doctorlisting',
	                           		 	 'label'=> false, 'div' => false, 'error' => false,'class'=>'textBoxExpnd'));
                                   }
                                   $displayRefererContact = '' ;
                          	}
                          	?>
			</span>
			</td>
			<td>&nbsp;</td>
			<td valign="middle" class="tdLabel txtpad_align" id="">Date of
				Referral</td>
			<td><?php echo $this->Form->input('date_of_referral', array('style'=>'float:left;','type'=>'text','class' => '','id' => 'date_of_referral')); ?>
			</td>
		</tr>  -->
		<?php } ?>
		<!--<tr>
					<td valign="middle" class="tdLabel" id="">Referral cost
			</td>
			<td><?php echo $this->Form->input('Patient.refferal_cost', array('class' => 'textBoxExpnd','type'=>'text','id' => 'ref_cost','value' => $someData['Patient']['refferal_cost']))."%"; ?>
			</td>
			<td>&nbsp;</td>
			<td class="tdLabel txtpad_align" id=""></td>
			<td>
			</td>
		</tr> -->
		<tr>
		</tr>
		<tr id="refererArea" style="display:<?php echo $displayRefererContact ;?>;">
		<?php if($this->Session->read('website.instance')=='hope'){?>
			<td valign="middle" class="tdLabel" id="">Referral Doctor Contact No.<font color="red">*</font></td>
			<td><?php echo $this->Form->input('family_phy_con_no', array('class' => 'textBoxExpnd validate[required,custom[mandatory-enter]]','MaxLength'=>'10','id' => 'phyContactNo', 'value' => $someData['Person']['family_phy_con_no'])); ?>
			</td>
			<?php }else{?>	
			<td valign="middle" class="tdLabel" id="">Referral Doctor Contact No.</td>
			<td><?php echo $this->Form->input('family_phy_con_no', array('class' => 'textBoxExpnd','id' => 'phyContactNo','MaxLength'=>'10', 'value' => $someData['Person']['family_phy_con_no'])); ?>
			</td>
			<?php }?>
		</tr>
		<tr>
			<td class="tdLabel" id="">Relatives Name</td>
			<td><?php echo $this->Form->input('relative_name', array('class' => 'textBoxExpnd','id' => 'relativeName','value'=>$result['Person']['relative_name'])); ?>
			</td>
			<td>&nbsp;</td>
			<!--  
                       <td class="tdLabel txtpad_align" id="">Authorization From Sponsor</td>
                       <td><?php //echo $this->Form->input('sponsers_auth', array('class' => 'textBoxExpnd','id' => 'sponsersAuth')); 
                       			
                       			$authOption = array('procedure not initiated'=>'Procedure not Initiated','form submitted'=>'Form Submitted','approval in progress'=>'Approval in Progress','approved'=>'Approved','rejected'=>'Rejected','Partial Approval'=>'Partial Approval') ;
                       
                       			echo $this->Form->input('sponsers_auth', array('empty'=>'Please Select','type'=>'select','options'=>$authOption,'class' => 'textBoxExpnd','id' => 'sponsersAuthOpt'));
                       
                       		?></td>-->
			<td class="tdLabel txtpad_align"><?php echo __('Date of Registration', true); ?><font
				color="red">*</font> <?php echo $this->Form->input('doc_ini_assessment', array('style'=>'float:right;','type'=>'checkbox','id' => 'docIniAssessment','value'=>1)); ?>
			</td>
			<td width="30%"><?php echo $this->Form->input('form_received_on', array('class' => 'validate[required,custom[mandatory-date]] ','style'=>'float:left;','id' => 'formReceivedOn','readonly'=>'readonly','type'=>'text')); ?>
			</td>
		</tr>
		<!--  <tr>
                       <td valign="middle" class="tdLabel" id="">&nbsp;</td>
                        <td>
                        	<?php //echo $this->Form->input('landline_phone', array('class' => 'textBoxExpnd','id' => 'landlinePhone')); ?>
                        </td>
                        <td>&nbsp;</td>
                       <td class="tdLabel" id="">Patient's Photo</td>
                       <td><?php echo $this->Form->input('upload_image', array('type'=>'file','id' => 'patient_photo', 'label'=> false,
					 	'div' => false, 'error' => false)); ?></td>
                     </tr> -->
		<tr>
		<?php if($this->Session->read('website.instance')=='hope'){?>
			<td valign="middle" class="tdLabel" id="">Relative Phone No.<font color="red">*</font></td>
			<td><?php echo $this->Form->input('mobile_phone', array('class' =>'textBoxExpnd  validate[required,custom[mandatory-enter]]','id' => 'mobilePhone','MaxLength'=>'10')); ?>
			</td>
			<?php }else{?>
			<td valign="middle" class="tdLabel" id="">Relative Phone No.</td>
			<td><?php echo $this->Form->input('mobile_phone', array('class' =>'textBoxExpnd','id' => 'mobilePhone','MaxLength'=>'10')); ?>
			</td>
			<?php } ?>
			<td>&nbsp;</td>
			<td class="tdLabel txtpad_align" id="">Relationship With Patient</td>
			<td><?php
			$relationship = array('self'=>'Self','mother'=>'Mother','father'=>'Father','brother'=>'Brother','sister'=>'Sister','wife' => 'Wife','husband'=>'Husband','son' => 'Son', 'daughter' => 'Daughter','other'=>'Other');
			echo $this->Form->input('relation', array(/* 'empty'=>__('Please select'), */
                        								  'options'=>$relationship,'class' => 'textBoxExpnd','id' => 'relation')); ?>
			</td>
		</tr>
		<tr id="showBeneficiaryBlock" style="display: none">
				<td valign="middle" class="tdLabel" id=""></td>
				<td></td>
				<td>&nbsp;</td>
				<td valign="middle" class="tdLabel txtpad_align" >Beneficiary Name</td>
				<td valign="middle" class="tdLabel txtpad_align" ><?php echo $this->Form->input('beneficiary_name', array('class' =>'textBoxExpnd','id' =>'beneficiaryName','autocomplete' => 'off'));?>
	            </td> 
		</tr>
		<tr>
			<td valign="middle" class="tdLabel" id="">Instructions</td>
			<td><?php
			$instructions = array('Diabetic'=>'Diabetic- If found Unconscious give sugar/sweet/chocolate.','Epileptic'=>'Epileptic- In case of attack/fit turn patient to one side & refrain from feeding.','High Blood Pressure'=>'High Blood Pressure- If found unconscious or paralyzed, turn patient to one side & refrain from feeding.','Low Blood Pressure'=>'Low Blood Pressure- In case of vertigo keep head in low position & take plenty of fluids.','Cardiac Problem'=>'Cardiac Problem- In case of symtoms like chest pain or sweating administer Tablet Disprin & sublingual Tablet Sorbitrate.','Asthma'=>'Asthma- In case of acute attack administer 2 puffs of Scroflo inhaler & shift to hospital.');
			//$instructions = array('Diabetic'=>'Diabetic','Epileptic'=>'Epileptic','High Blood Pressure'=>'High Blood Pressure','Low Blood Pressure'=>'Low Blood Pressure','Prone to Angina Attacks'=>'Prone to Angina Attacks','Austistic'=>'Austistic');
			echo $this->Form->input('instruction', array('empty'=>__('Please select'),
                        								  'options'=>$instructions,'class' => 'textBoxExpnd','id' => 'instructions','value'=>$result['Person']['instruction'])); ?>
			</td>
			<td>&nbsp;</td>
			<td class="tdLabel txtpad_align " id="">Tariff<font color="red">*</font>
			</td>
			<td><?php

			 if(strtolower($this->Session->read('role'))=='admin'){
			 	$disabled = false;
			 }else{
			 	$disabled = true;
			 }
			if($this->Session->read('website.instance')=='hope'){	
				echo $this->Form->input('tariff_standard_id', array( 'disabled'=>$disabled,'empty'=>__('Please Select'), 'options'=>$tariffStandard,'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd',
						'id'=>'tariff','value'=>$tariffID,'onchange'=> $this->Js->request(array('action' => 'getCorporateSublocList'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn',
								array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeCreditTypeList',
								'data' => '{tariffId:$("#tariff").val()}', 'dataExpression' => true, 'div'=>false))));
			if(strtolower($this->Session->read('role'))!='admin'){
				echo  $this->Form->input('tariff_standard_id', array('type'=>'hidden','value'=>$tariffID));
			}
			}else{
                		echo $this->Form->input('tariff_standard_id', array('empty'=>__('Please Select'),'options'=>$tariffStandard,'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id'=>'tariff'));
                }
			 ?>
			</td>
		</tr>
		
		<?php if($this->Session->read("website.instance")=='lifespring' & $privateID == $this->data['Patient']['tariff_standard_id'] ){ 	?>
   
         <tr class="approval" style="display:none;"> 
         <td colspan="3"></td>
		
			   <td >
			    				<?php echo $this->Form->input('DiscountRequest.discount_by', array('class' => ' textBoxExpnd','style'=>'width:20px;','autocomplete'=>'off','div' => false,'label' => false,'type'=>'select','options'=>array('empty'=>'Select User',$authPerson),'id' => 'authorize_by','style'=>"width:200px;",'readonly'=>false)); ?>
			    </td><td>
			                 	<?php 
									echo $this->Html->link(__('Send request for Approval'),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn','id'=>'send-approval'  ));
									echo $this->Html->link(__('Cancel Request'),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn','id'=>'cancel-approval',"style"=>"display:none;"));
									echo $this->Form->hidden('ApproveRequest.is_approved',array('value'=>0,'id'=>'is_approved'));
			             ?>
		        </td>		
	     </tr>     
			 <tr class="note"> 
			 <td colspan="3"></td>
           <td colspan="2" valign="top" align="left" style="padding-top: 15px;">&nbsp;
        	<div style="float: left; margin-top: 3px;">
				   <i id="message" style="display:none;">
				   	(<font color="red">Note: </font> <span id="status-approved-message"></span> )  
				   		<span class="gif" id="image-gif" style="float: right; margin: -3px 0px 0px 7px;"> </span>
				   	</i>
			  </div> 
		</td>
     </tr>  
     <?php } ?>    
		<tr>
			<td valign="middle" class="tdLabel" id="">Diagnosis</td>
			<td><?php echo $this->Form->input('diagnosis_txt', array('class' => 'textBoxExpnd','id'=>'diagnoses','maxlength'=>'40')); ?>
			</td>
			<td>&nbsp;</td>		
			 <td class="tdLabel txtpad_align" id="">Other Consultants:
                      
                       </td>                     
                        <td><?php  $otherConsultant = unserialize($this->request->data['Patient']['other_consultant']);                      
                        echo  $this->Form->input('Patient.other_consultant',array('options'=>$getOtherConsultant, 'multiple'=>true,'selected'=>$otherConsultant,'id' => 'other_consultant','style'=>'width:288px;')); ?>
                        </td>
		</tr>
			
		<tr>
			<?php $websie=$this->Session->read("website.instance");
		        if($websie=="kanpur"){?>
		   <td class="tdLabel"><?php echo __('Weight')?></td>
		   <td width="30%"><?php echo $this->Form->input('Patient.patient_weight', array('label'=>false,'type'=>'text','class' => ' validate[optional,custom[onlyNumber]]','style'=>'width:60px','maxlength'=>'3','autocomplete'=>"off",'div'=>false,'value'=>$this->data['Patient']['patient_weight'])); echo "&nbsp;"."Kg"?></td>
	        <?php }?>
			<td>&nbsp;</td>
		</tr>

		<!--  <tr>
                       <td class="tdLabel">Family Physician</td>
                        <td><?php echo $this->Form->input('family_physician', array('class' => 'textBoxExpnd','id' => 'family_physician')); ?></td>
                        <td>&nbsp;</td>
                        <td class="tdLabel" id="">Relative's Signature</td>
                        <td><?php echo $this->Form->input('relative_sign', array('class' => 'textBoxExpnd','id' => 'relativeSign')); ?></td>
                      </tr> -->

	</table>
	<!-- Patient Information end here -->
	<!-- BOF Sponsers Details -->
	<p class="ht5"></p>
	<!-- Links to Records start here -->
	<table width="100%" border="0" cellspacing="0" cellpadding="0"
		class="formFull">
		<tr>
			<th colspan="5"><?php echo __('Sponsor Information'); ?></th>
		</tr>
		<tr>

			<td width="19%" class="tdLabel" id="" valign="top">Sponsor Details <font
				color="red">*</font>
			</td>
			<td width="30%" valign="top"><?php 
			$paymentCategory = array('cash'=>'Self Pay','Corporate'=>'Corporate','Insurance company'=>'Insurance company','TPA'=>'TPA');
			echo $this->Form->input('payment_category', array('autocomplete'=>'off','empty'=>__('Please select'),'options'=>$paymentCategory,'value'=>$this->data['Patient']['payment_category'],'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'paymentType','onchange'=> $this->Js->request(array('action' => 'getPaymentType'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
			    							'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeCreditTypeList', 'data' => '{paymentType:$("#paymentType").val(),tariffId:$("#tariff").val()}', 'dataExpression' => true, 'div'=>false))));
			                       		?> <!-- BOF insurance section -->
				<div id="changeCreditTypeList">
					<?php 

					if($this->data['Patient']['payment_category'] == 'Corporate') {
			                        	?>
					<br><!--  <span id="changeCorprateLocationList"><font color="red">*</font>&nbsp;
						<?php 
						    echo $this->Form->input('Patient.corporate_location_id', array('class'=>'validate[required,custom[mandatory-select]] textBoxExpnd1','options' => $corporatelocations, 'empty' => __('Select Corporate Location'), 'id' => 'ajaxcorporatelocationid', 'label'=> false, 'div' => false, 'error' => false, 'onchange' => $this->Js->request(array('action' => 'getCorporateList'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
				    							'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeCorporateList', 'data' => '{ajaxcorporatelocationid:$("#ajaxcorporatelocationid").val()}', 'dataExpression' => true, 'div'=>false))));
				                          ?> <br> <span id="changeCorporateList"><font
							color="red">*</font>&nbsp; <?php 
							echo $this->Form->input('Patient.corporate_id', array('class'=>'validate[required,custom[mandatory-select]] textBoxExpnd1','options' => $corporates, 'empty' => __('Select Corporate'), 'id' => 'ajaxcorporateid', 'label'=> false, 'div' => false, 'error' => false, 'onchange' => $this->Js->request(array('action' => 'getCorporateSublocList'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
				    							'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeCorporateSublocList', 'data' => '{ajaxcorporateid:$("#ajaxcorporateid").val()}', 'dataExpression' => true, 'div'=>false))));
				                          ?> <br>  -->
				        <span id="changeCorporateSublocList"> <?php
							echo $this->Form->input('Patient.corporate_sublocation_id', array('class'=>'textBoxExpnd','options' => $corporatesublocations, 'empty' => __('Select Corporate Sublocation'), 'id' => 'ajaxcorporatesublocationid', 'label'=> false, 'div' => false, 'error' => false));
							?> <?php
						    //echo "<br />";
							//echo __('Other Details :');
							//echo $this->Form->textarea('corporate_otherdetails', array('class' => 'textBoxExpnd','id' => 'otherdetails','row'=>'3'));
							?>
						</span> <!-- </span> </span> -->


					<?php } if(($this->data['Patient']['payment_category'] == 'Insurance company') || ($this->data['Patient']['payment_category'] == 'TPA')) { ?>
					<!--  <span><font color="red">*</font>&nbsp; -->
					<?php 
					/*  echo $this->Form->input('Patient.credit_type_id', array('class'=>'validate[required,custom[mandatory-select]] textBoxExpnd1','options' => $credittypes, 'empty' => __('Select Credit Type'), 'id' => 'paymentCategoryId', 'label'=> false, 'div' => false, 'error' => false, 'onchange' => $this->Js->request(array('action' => 'getCorporateLocationList'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
					 'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeCorprateLocationList', 'data' => '{paymentCategoryId:$("#paymentCategoryId").val()}', 'dataExpression' => true, 'div'=>false)))); */
				                          ?>
					<!--  <span id="changeCorprateLocationList"><font color="red">*</font>&nbsp; -->
					<?php 
					/* echo $this->Form->input('Patient.insurance_type_id', array('class'=>'validate[required,custom[mandatory-select]] textBoxExpnd1','options' => $insurancetypes, 'empty' => __('Select Insurance Type'), 'id' => 'insurancetypeid', 'label'=> false, 'div' => false, 'error' => false, 'onchange' => $this->Js->request(array('action' => 'getInsuranceCompanyList'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
					 'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeInsuranceCompanyList', 'data' => '{insurancetypeid:$("#insurancetypeid").val()}', 'dataExpression' => true, 'div'=>false)))); */
				                          ?>
					<span id="changeInsuranceCompanyList"><font color="red">*</font>&nbsp;
						<?php 
						echo $this->Form->input('Patient.insurance_company_id', array('class'=>'validate[required,custom[mandatory-select]] textBoxExpnd1','options' => $insurancecompanies, 'empty' => __('Select Insurance Company'), 'id' => 'ajaxinsurancecompanyid', 'label'=> false, 'div' => false, 'error' => false));
						?> </span> </span> </span>
					<?php 
							}

							?>
				</div> <!-- EOF insurance section -->
			</td>
			<td>&nbsp;</td>
			<?php if($this->data['Patient']['admission_type'] == 'IPD'){?>
			<td valign="top" width="49%" colspan="2" class="" id="corporateStatus" style="display: none">
				<table width="100%" cellpadding="0" cellspacing="0">
				     <tr>
						<td width="19%" class=""><?php echo __('Status');?>
						</td>
						<td width="30%" align="left" class=" "><?php 
						
						echo $this->Form->input('corporate_status', array('empty'=>__('Please select'),'options'=>$corporateStatus,'class' => 'textBoxExpnd','id' => 'status','value'=>$this->data['Patient']['corporate_status'])); ?>
						</td>
					</tr>
					<?php 
					       /*$statusOpt = array( 'Received I card, referral letter'=>'Received I card, referral letter',
																	 'Received MPKAY member verification letter, NOC\'s'=>'Received MPKAY member verification letter, NOC\'s',
																	 '5 page MPKAY bunch form filled by patient'=>'5 page MPKAY bunch form filled by patient',
																	 'Pre-authorization sent'=>'Pre-authorization sent',
																	 'Queries received'=>'Queries received',
																	 'Queries replied'=>'Queries replied',
																	 'Pre-authorization approval received'=>'Pre-authorization approval received',
																	 'Enhancement requested'=>'Enhancement requested',
																	 'Enhancement approved'=>'Enhancement approved',
																	 'MPKAY Units approval for enhanced amount'=>'MPKAY Units approval for enhanced amount'
												 );
												 $statusAfterDischarge = array(
												 	   		'Bill ready'=>'Bill ready',
															'File ready for submission'=>'File ready for submission',
															'File submitted'=>'File submitted',
															'Acknowledgement copy sent to PHPL'=>'Acknowledgement copy sent to PHPL',
															'Bill scrutinised'=>'Bill scrutinised',
															'Bill sent to accounts'=>'Bill sent to accounts',
															'Bill sent to cash section'=>'Bill sent to cash section',
															'Payment received'=>'Payment received',
															'Details of deduction received'=>'Details of deduction received',
												 	   );

		                       			  	if(!empty($this->data['Patient']['status']) && !(in_array($this->data['Patient']['status'],$statusAfterDischarge))) { ?>
					<tr>
						<td width="19%" class=""><?php echo __('Current Status');?>
						</td>
						<td width="30%" align="left" class=" "><?php 
						echo ucfirst($this->data['Patient']['status']) ;
						?>
						</td>
					</tr>
					<?php } ?>
					<tr>


						<td class="tdLabel txtpad_align" id="">Status of Authorization</td>
						<td><?php //echo $this->Form->input('sponsers_auth', array('class' => 'textBoxExpnd','id' => 'sponsersAuth')); 

						$authOption = array('procedure not initiated'=>'Procedure not Initiated','form submitted'=>'Form Submitted','approval in

										progress'=>'Approval in Progress','approved'=>'Approved','rejected'=>'Rejected','Partial Approval'=>'Partial Approval') ;
									
										                       			echo $this->Form->input('sponsers_auth', array('empty'=>'Please Select','type'=>'select','options'=>$authOption,'class' =>

										'textBoxExpnd','id' => 'sponsersAuthOpt'));
									
										                       		?></td>
					</tr>
					<tr>
						<td width="19%" class=""><?php echo __('Status');?>
						</td>
						<td width="30%" align="left" class=" "><?php 
							
						if($this->data['Patient']['is_discharge']==1){
													echo $this->Form->input('status', array('empty'=>__('Please select'),'options'=>$statusAfterDischarge,'class' => 'textBoxExpnd','id' => 'status'));
												}else{
													echo $this->Form->input('status', array('empty'=>__('Please select'),'options'=>$statusOpt,'class' => 'textBoxExpnd','id' => 'status'));
												}
												?></td>
					</tr>
					<tr>
						<td width="19%" class=""><?php echo __('Remark');?>
						</td>
						<td width="30%" align="left" class=" "><?php echo $this->Form->input('remark', array('class' => 'textBoxExpnd','id' => 'remark','disabled'=>'disabled')); ?>
						</td>
					</tr>
					<?php */ ?>
				</table>
			</td>
			<?php }?>
		</tr>
		<tr id="showwithcard" style="display: none;">
			<td width="100%" colspan="5" align="left" class="" id=" ">
				<table border="0" cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td width="19%" class="tdLabel" id=""><?php echo __('Name of the Employee.');?>
						</td>
						<td width="30%" align="left"><?php echo $this->Form->input('name_of_ip', array('class' => 'textBoxExpnd','id' => 'name_of_ip')); ?>
						</td>
						<td width="">&nbsp;</td>
						<td valign="middle" class="tdLabel txtpad_align" id="" width="19%"><?php echo __('Relationship with Employee');?>
						</td>
						<td align="left" width="30%"><?php
						$relation = array('SELF'=>'Self','FAT'=>'Father','MOT'=>'Mother','BRO'=>'Brother','SIS'=>'Sister','WIFE' => 'Wife','HUSBAND'=>'Husband','SON' => 'Son', 'DAU' => 'Daughter','OTHER'=>'other');
														 echo $this->Form->input('relation_to_employee', array('empty'=>__('Please Select'),'options'=>$relation,'class' => 'textBoxExpnd','id' => 'insurance_relation_to_employee')); ?>
						</td>
					</tr>
					<tr>

						<td width="19%" class="tdLabel" id=""><?php echo __('Executive Employee ID No.');?>
						</td>
						<td width="30%" align="left"><?php echo $this->Form->input('executive_emp_id_no', array('class' => 'textBoxExpnd emp_id','id' => 'insurance_executive_emp_id_no')); ?>
						</td>
						<td>&nbsp;</td>
						<td class="tdLabel txtpad_align" id=""><?php echo __('Non Executive Employee ID No.');?>
						</td>
						<td align="left"><?php echo $this->Form->input('non_executive_emp_id_no', array('style'=>'width:180px;margin-right:10px;','class' => 'textBoxExpnd emp_id','id' => 'insurance_non_executive_emp_id_no')); ?>
							<?php echo $this->Form->input('emp_id_suffix', array('style'=>'width:60px','class' => 'textBoxExpnd emp_id','id' => 'insurance_esi_suffix', 'readonly' => 'readonly')); ?>
						</td>
					</tr>

					<tr>

						<td class="tdLabel" id="" align="left"><?php echo __('Designation');?>
						</td>
						<td align="left"><?php echo $this->Form->input('designation', array('class' => 'textBoxExpnd','id' => 'designation')); ?>

						</td>
						<td>&nbsp;</td>
						<td class="tdLabel txtpad_align" id="" align="left"><?php echo __('Company');?>
						</td>
						<td align="left"><?php echo $this->Form->input('sponsor_company', array('class' => 'textBoxExpnd','id' => 'sponsor_company')); ?>
						</td>
					</tr>
					<tr>

						<td width="19%" class="tdLabel" id=""><?php echo __('Name of Police Station');?>
						</td>
						<td width="30%" align="left"><?php echo $this->Form->input('name_police_station', array('value'=>$someData['Person']['name_police_station'],'class' => 'textBoxExpnd name_police_station','id' => 'name_police_station')); ?>
						</td>
						<td>&nbsp;</td>
						<td class="tdLabel txtpad_align" id="">&nbsp;
						</td>
						<td align="left">&nbsp;
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr id="showwithcardInsurance" style="display: none;">
			<td width="100%" colspan="5" align="left" class="" id=" ">
				<table border="0" cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td width="19%" class="tdLabel" id=""><?php echo __('Name of Insurance Holder');?>
						</td>
						<td width="30%" align="left"><?php echo $this->Form->input('name_of_ip', array('class' => 'textBoxExpnd','id' => 'name_of_ip')); ?>
						</td>
						<td width="">&nbsp;</td>
						<td valign="middle" class="tdLabel txtpad_align" id="" width="19%"><?php echo __('Relationship with Insurance Holder');?>
						</td>
						<td align="left" width="30%"><?php
						$relation = array('SELF'=>'Self','FAT'=>'Father','MOT'=>'Mother','BRO'=>'Brother','SIS'=>'Sister','WIFE' => 'Wife','HUSBAND'=>'Husband','SON' => 'Son', 'DAU' => 'Daughter','OTHER'=>'other');
														 echo $this->Form->input('relation_to_employee', array('empty'=>__('Please Select'),'options'=>$relation,'class' => 'textBoxExpnd','id' => 'corpo_relation_to_employee')); ?>
						</td>
					</tr>
					<tr>

						<td class="tdLabel" id="" align="left"><?php echo __('Designation');?>
						</td>
						<td align="left"><?php echo $this->Form->input('designation', array('class' => 'textBoxExpnd','id' => 'designation')); ?>

						</td>
						<td>&nbsp;</td>
						<td class="tdLabel txtpad_align" id=""><?php echo __('Insurance Number');?>
						</td>
						<td align="left"><?php echo $this->Form->input('insurance_number', array('class' => 'textBoxExpnd','id' => 'insurance_number')); ?>
						</td>
					</tr>
					<tr>

						<td width="19%" class="tdLabel" id=""><?php echo __('Executive Employee ID No.');?>
						</td>
						<td width="30%" align="left"><?php echo $this->Form->input('executive_emp_id_no', array('class' => 'textBoxExpnd emp_id','id' => 'corpo_executive_emp_id_no')); ?>
						</td>
						<td>&nbsp;</td>
						<td class="tdLabel txtpad_align" id=""><?php echo __('Non Executive Employee ID No.');?>
						</td>
						<td align="left"><?php echo $this->Form->input('non_executive_emp_id_no', array('style'=>'width:180px','class' => 'textBoxExpnd emp_id','id' => 'corpo_non_executive_emp_id_no')); ?>
							<?php echo $this->Form->input('emp_id_suffix', array('style'=>'width:60px','class' => 'textBoxExpnd emp_id','id' => 'corpo_esi_suffix', 'readonly' => 'readonly')); ?>
						</td>
					</tr>

					<tr>

						<td width="19%" class="tdLabel" id=""><?php echo __('Name of Police Station');?>
						</td>
						<td width="30%" align="left"><?php echo $this->Form->input('name_police_station', array('value'=>$someData['Person']['name_police_station'],'class' => 'textBoxExpnd name_police_station','id' => 'name_police_station')); ?>
						</td>
						<td>&nbsp;</td>
						<td class="tdLabel txtpad_align" id="">&nbsp;
						</td>
						<td align="left">&nbsp;
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<!-- EOF Sponsers Details -->
	<p class="ht5"></p>
<?php 	$website=$this->Session->read("website.instance");   
			if($website=='lifespring'){ ?>	
	<table width="100%" border="0" cellspacing="0" cellpadding="0"
		class="formFull">
		<tr>
			<th colspan="5">Other Information</th>
		</tr>
		<tr>	
			<td valign="middle" class="tdLabel"><?php echo __('Coupon No.');?></td>
			<?php if($this->data['Patient']['coupon_name']) {?>
	        <td><?php echo $this->data['Patient']['coupon_name']; ?> </td>
	         <?php   } else { ?>
	    <td> <?php echo $this->Form->input('coupon_name', array('class' =>'coupon_name','value'=>$this->params->query['coupon_name'],'id' =>'coupon_name')); ?>
	      <spane id="validcoupon" style='display:none; color:green' ><?php echo 'Valid Coupon'; ?></spane></td>
	    <?php }?> 
	     </tr>
	     
        <tr class="pregnant" style='display:none;'>
			<td class="tdLabel" id="boxSpace"><?php echo __('Is Pregnant');?></td>
			<?php $val = ($this->data['Patient']['pregnant_week']) ? '' : 'display : none';?> 
			<td ><?php echo $this->Form->checkbox('is_pregnent', array('legend'=>false,'label'=>false,'class' => 'is_pregnent',
				'id'=>'is_pregnent','checked'=>$this->data['Patient']['pregnant_week'] )); ?> 
			<span class="hideRow" style="<?php echo $val;?>"><?php echo $this->Form->input('Patient.pregnant_week',array('type'=>'text','legend'=>false,'label'=>false,
					'class' => 'pregnant_week','id' =>'pregnant_week','value'=>$this->data['Patient']['pregnant_week'])); ?>Weeks </span></td>
					<td>&nbsp;</td>
			<td class=" hideRow " id="boxSpace" style="<?php echo $val;?>"><?php echo __('EDD');?> </td>
			<td colspan="1" class ="hideRow" style="<?php echo $val;?>" > <?php 
					echo $this->Form->input('Patient.expected_date_del',array('type'=>'text','legend'=>false,'label'=>false,
					'class' => 'edd ','id' => 'edd','style'=>"float: left;"));?></td>	
		</tr>	
	</table>
	<!-- EOF Advance -->
	<?php }?>

	<!-- Links to Records start here -->
	<!--  
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
                   	  <tr>
                      	<th colspan="5">Links to Records</th>
                      </tr>
                      <tr>
                        <td width="19%" class="tdLabel" id="">Case summary Link</td>
                        <td width="81%"><?php echo $this->Form->input('case_summery_link', array('class' => 'textBoxExpnd txtbx_align','id' => 'caseSummeryLink')); ?></td>
                        
                      </tr>
                      <tr>
                        <td class="tdLabel" id="">Patient File</td>
                        <td><?php echo $this->Form->input('patient_file', array('class' => 'textBoxExpnd txtbx_align','id' => 'patientFile')); ?></td>
                       
                      </tr>
		                      <!-- 
		                      <tr>
		                        <td class="tdLabel" id="">Consent Form</td>
		                        <td><?php echo $this->Form->input('consent_form', array('class' => 'textBoxExpnd','id' => 'consentForm')); ?></td>
		                        <td>&nbsp;</td>
		                        <td class="tdLabel">&nbsp;</td>
		                        <td>&nbsp;</td>
		                     </tr>
		                      -->
	<!--  
                    </table>
                    -->
	<!-- Links to Records end here -->
	<!-- BOF Advance -->
	<?php //if($this->data['Patient']['admission_type'] != "OPD"){ ?>
	<p class="ht5"></p>

	<!-- Links to Records start here ->
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
                   	  <tr>
                      	<th colspan="5">Advance</th>
                      </tr> 
                       <tr>
                      	<td width="19%" class="tdLabel" id="">Against </td>
                        <td width="30%">
                        	<?php 
                        		//echo $this->Form->hidden('Billing.id', array('value'=>$this->data['Billing']['id']));
                        		//echo $this->Form->input('Billing.against', array('options'=>$against,'id'=>'against','class' => 'textBoxExpnd','type'=>'select','disabled'=>'disabled')); 
                        	?>
                        </td>
                   		<td width="30">&nbsp;</td>
                        <td width="19%" class="tdLabel" id="">Standard Amount: </td>
                        <td width="30%"><?php //echo $this->Form->input('', array('id'=>"standardAgainst",'options'=>$standardAgainst,'class' => 'textBoxExpnd','type'=>'select','disabled'=>'disabled')); ?></td>
                      </tr>
                      <tr>
	                        <td class="tdLabel" id="">Collected </td>
	                        <td width="30%"> <?php //echo $this->Form->input('Billing.amount', array('class' => 'textBoxExpnd','type'=>'text','error'=>false,'label'=>false,'disabled'=>'disabled')); ?></td>
	                        <td width="30">&nbsp;</td>
	                     <td width="19%" class="tdLabel" ></td>
                          <td width="30%"></td>
                        
                      </tr> 
                   	  <tr>
					         <td class="tdLabel" id="">Mode Of Payment</td>
					         <td width="30%"> 
					   				<?php //echo $this->Form->input('Billing.mode_of_payment', array("class"=>"textBoxExpnd",'div' => false,'label' => false,'empty'=>__('Please select'),
					   						//		'options'=>array('Cash'=>'Cash','Cheque'=>'Cheque','Credit Card'=>'Credit Card'),'id' => 'mode_of_payment','autocomplete'=>'off','disabled'=>'disabled')); ?>
					   		</td>
					  </tr>                                        
					  <tr>
					  	<td class="tdLabel" id="" colspan="5"> 
						  	<table width="100%" id="paymentInfo" style="display:none"> 
							    <tr>
								    <td class="tdLabel" id="">Bank Name</td>
								    <td width="30%"><?php //echo $this->Form->input('Billing.bank_name',array('class'=>'textBoxExpnd','type'=>'text','legend'=>false,'label'=>false,'id' => 'account_number'));?></td>
								    <td width="30">&nbsp;</td>
                        			<td width="19%">&nbsp;</td>
                        			<td width="30%">&nbsp;</td>
							    </tr>
							    <tr>
								    <td class="tdLabel" id="">Account No.</td>
								    <td width="30%"><?php //echo $this->Form->input('Billing.account_number',array('class'=>'textBoxExpnd','type'=>'text','legend'=>false,'label'=>false,'id' => 'account_number'));?></td>
								    <td width="30">&nbsp;</td>
                        			<td width="19%">&nbsp;</td>
                        			<td width="30%">&nbsp;</td>
							    </tr>
							    <tr>
								    <td class="tdLabel" id="">Cheque/Credit Card No.</td>
								    <td width="30%"><?php //echo $this->Form->input('Billing.check_credit_card_number',array('class'=>'textBoxExpnd','type'=>'text','legend'=>false,'label'=>false,'id' => 'card_check_number'));?></td>
								    <td width="30">&nbsp;</td>
                        			<td width="19%">&nbsp;</td>
                        			<td width="30%">&nbsp;</td>
							    </tr>
						    </table>
					 	</td>
					  </tr> 
                    </table>
                    <!-- EOF Advance -->
	<?php //} ?>
	<p class="ht5"></p>

	<!-- Patient clinical record start here -->
	<!--  
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
                   	  <tr>
                      	<th colspan="5">Performance Indicator</th>
                      </tr>
                        
                      
                     <!--  <tr>
                      	 <td width="19%" valign="top" class="tdLabel" id="" style="padding-top:10px;">Allergies</td>
                         <td width="30%"><?php echo $this->Form->textarea('allergies', array('class' => 'textBoxExpnd','id' => 'allergies','row'=>'3')); ?></td>
                         <td width="30">&nbsp;</td>
                        <td width="19%" valign="top" class="tdLabel" id="" style="padding-top:10px;">On Examination</td>
                        <td width="" valign="top"><?php echo $this->Form->textarea('examination', array('class' => 'textBoxExpnd','id' => 'examination','row'=>'3')); ?>
                        </td>
                      </tr>
                      
                      
                      <tr>
                        <td valign="top" class="tdLabel" id="" style="padding-top:10px;">Treatment in Hospital</td>
                        <td><?php echo $this->Form->textarea('treatment', array('row'=>'3','class' => 'textBoxExpnd','id' => 'treatment')); ?></td>
                        <td>&nbsp;</td>
                        <td valign="top" class="tdLabel" id="" style="padding-top:10px;">Drug lookup</td>
                        <td valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0">
                          <tr>
                            <td>
                            	<?php echo $this->Form->input('drug_lookup', array('class' => 'textBoxExpnd','id' => 'drugLookup')); ?>
                            </td>
                            <td width="60" align="right" style="padding-right:15px;"><a href="#"><img src="images/pill.png" alt="" border="0"/></a> <a href="#"><img src="images/eraser-icon.png" alt="" border="0"/></a></td>
                          </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td valign="top" class="tdLabel" id=""  style="padding-top:10px;">OT</td>
                        <td valign="top"><?php echo $this->Form->input('OT', array('class' => 'textBoxExpnd','id' => 'OT')); ?></td>
                        <td>&nbsp;</td>
                        <td valign="top" class="tdLabel" id="" style="padding-top:10px;"> Review on </td>
                        <td><table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                              <td><?php echo $this->Form->input('review_on', array('class' => 'textBoxExpnd','style'=>'width:85%;','id' => 'reviewOn','readonly'=>'readonly','type'=>'text')); ?></td>
                            </tr>                  
                        </table></td>
                      </tr> -->
	<!--  <tr>                 
	                         <td class="tdLabel" id="" width="19%"><?php echo __('Form Received by Patient', true); ?><font color="red">*</font>
                             <?php echo $this->Form->input('doc_ini_assessment', array('style'=>'float:right;','type'=>'checkbox','id' => 'docIniAssessment','value'=>1)); ?>
                             </td>
	                         <td width="30%">
	                         	<?php echo $this->Form->input('form_received_on', array('class' => 'validate[required,custom[mandatory-date]] ','style'=>'float:left;','id' => 'formReceivedOn','readonly'=>'readonly','type'=>'text')); ?>
	                         </td>
	                         <td>&nbsp;</td>
	                         <td valign="top" class="tdLabel txtpad_align" id="" width="19%">
							 <?php echo __('Registration Completed by Patient', true); ?><font color="red">*</font>
                             <?php echo $this->Form->input('nurse_assessment', array('style'=>'float:right;','type'=>'checkbox','id' => 'nurseAssessment','value'=>1)); ?>
                             </td>
	                         <td valign="top" width="30%">
                                  <?php echo $this->Form->input('form_completed_on', array('class' => ' validate[required,custom[mandatory-date]]', 'style'=>'float:left;','id' => 'formCompletedOn','type'=>'text')); ?>
                                 </td>
	                     </tr>
	                     <tr>
	                       	<td valign="top" class="tdLabel" id="" style="padding-top:10px;">Start of Assessment by Doctor</td>
	                  		<td><?php echo $this->Form->input('doc_ini_assess_on', array('class' => '','style'=>'float:left;','id' => 'docIniAssessOn','readonly'=>'readonly','type'=>'text')); ?></td>
	                        <td>&nbsp;</td>
	                        <td valign="top" class="tdLabel txtpad_align" id="" style="padding-top:10px;">End of Assessment by Doctor</td>                  
	                        <td><?php echo $this->Form->input('doc_ini_assess_end_on', array('class' => '','style'=>'float:left;','id' => 'docIniAssessEndOn','readonly'=>'readonly','type'=>'text')); ?></td>
	                     </tr>
	                     <tr>
	                     	<td valign="top" class="tdLabel" id="" style="padding-top:10px;">Start of Nursing Assessment</td>
	                  		  <td><?php echo $this->Form->input('nurse_assess_on', array('class' => '','style'=>'float:left;','id' => 'nurseAssessmentOn','readonly'=>'readonly','type'=>'text')); ?></td>
	                        <td>&nbsp;</td>
	                        <td valign="top" class="tdLabel txtpad_align" id="" style="padding-top:10px;">End of Nursing Assessment</td>                  
	                          <td><?php echo $this->Form->input('nurse_assess_end_on', array('class' => '','style'=>'float:left;','id' => 'nurseAssessmentEndOn','readonly'=>'readonly','type'=>'text')); ?></td>                  
	                     </tr>
	                     <tr>
	                     	<td valign="top" class="tdLabel" id="" style="padding-top:10px;">Start of Nutritional Assessment</td>
	                  		<td><?php echo $this->Form->input('nutritional_assess_on', array('class' => '','style'=>'float:left;','id' => 'nutritionalAssessOn','readonly'=>'readonly','type'=>'text')); ?></td>
	                        <td>&nbsp;</td>
	                        <td valign="top" class="tdLabel txtpad_align" id="" style="padding-top:10px;">End of Nutritional Assessment</td>                  
	                        <td><?php echo $this->Form->input('nutritional_assess_end_on', array('class' => '','style'=>'float:left;','id' => 'nutritionalAssessEndOn','readonly'=>'readonly','type'=>'text')); ?></td>                  
	                     </tr> 
                    </table>
                    -->
	<!--                        
                     <p class="ht5"></p>                     
                      
                     <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
                   	  <tr>
                      	<th colspan="5">Discharge Information</th>
                      </tr>
                      <tr>
                        <td width="19%" valign="top" class="tdLabel" id=""  style="padding-top:10px;">Discharge Intimation done</td>
                        <td width="30%" valign="top"  style="padding-top:10px;"><?php echo $this->Form->checkbox('discharge_intimation', array('class' => 'textBoxExpnd','id' => 'dischargeIntimation','value'=>1)); ?></td>
                        <td>&nbsp;</td>
                        <td width="19%" valign="top" class="tdLabel" id="" style="padding-top:10px;">Discharge Time intimation Date &amp; Time</td>
                        <td width="30%"><table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                              <td><?php echo $this->Form->input('discharge_intimation_on', array('class' => 'textBoxExpnd','style'=>'width:85%;','id' => 'dischargeIntimationOn','readonly'=>'readonly','type'=>'text')); ?></td>
                            </tr>                           
                        </table></td>
                      </tr>
                     <tr>
                       <td valign="top" class="tdLabel" id=""> Full and Final intimation done </td>
                        <td valign="top"><?php echo $this->Form->checkbox('final_intimation', array('class' => 'textBoxExpnd','id' => 'fullIntimation','value'=>1)); ?></td>
                        <td>&nbsp;</td>
                        <td valign="top" class="tdLabel" id="">Full &amp; Final discharge Date &amp; Time</td>
                        <td width="30%"><table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                              <td><?php echo $this->Form->input('final_intimation_on', array('class' => 'textBoxExpnd','style'=>'width:85%;','id' => 'fullIntimationOn','readonly'=>'readonly','type'=>'text')); ?></td>
                            </tr>                            
                        </table></td>
					</tr>
                     <tr>
                       <td valign="middle" class="tdLabel" id="">Discharge Discription</td>
                        <td valign="top"><?php echo $this->Form->textarea('discharge_desc', array('class' => 'textBoxExpnd','id' => 'dischargeDesc','row'=>'3')); ?></td>
                        <td>&nbsp;</td>
                        <td valign="top" class="tdLabel" id="">&nbsp;</td>
                       <td valign="top">&nbsp;</td>
                     </tr>
                    </table>
                                       
                    <p class="ht5"></p>                    
                     
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
                   	  <tr>
                      	<th colspan="5">InvActivity Information</th>
                      </tr>
                      <tr>
                        <td width="19%" valign="top" class="tdLabel" id="" style="padding-top:10px;">Description</td>
                        <td width="30%"><?php echo $this->Form->textarea('inv_activity_desc', array('class' => 'textBoxExpnd','id' => 'invActivityDesc','row'=>3)); ?></td>
                        <td width="">&nbsp;</td>
                        
                      </tr>
                      <tr>
                        <td valign="top" class="tdLabel" id="">Invoice settled</td>
                        <td valign="top"><?php echo $this->Form->checkbox('invoice_settled', array('class' => 'textBoxExpnd','id' => 'invoiceSettled','value'=>1)); ?></td>
                        <td>&nbsp;</td>
                        <td valign="top" class="tdLabel" id="" style="padding-top:10px;">&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                     <tr>
                       <td valign="middle" class="tdLabel" id=""> Advance Paid </td>
                       <td><?php echo $this->Form->input('advance_paid', array('class' => 'textBoxExpnd','id' => 'advancedPaid')); ?></td>
                       <td>&nbsp;</td>
                       <td class="tdLabel" id="">&nbsp;</td>
                       <td>&nbsp;</td>
                     </tr>
                    </table> -->
	<!-- InvActivity Information end here -->

	<!-- form end here -->
	<div class="btns">
		<input class="blueBtn" type="button" value="Cancel"
			onclick="window.location='<?php echo $this->Html->url(array("controller" =>"Persons", "action" => "patient_information",$this->data['Patient']['person_id']));?>'">

		<!--   <input class="blueBtn" type="submit" value="<?php echo $buttonLabel ; ?>" id='submit_btn1'> -->
		<?php 
		if($extraButton){
					             echo $this->Form->submit($extraButton,array('type'=>'submit','class'=>'blueBtn','div'=>false,'error'=>false,'id'=>'extra2'));
							   }
							   ?>

	</div>


	<?php  $patientId = $result['Patient']['id'];//EOF new form design 
							   ?>
</div>
<?php echo $this->Form->end(); ?>


<script>
	jQuery(document).ready(function(){
		var relationWithPatient = '<?php echo $this->data['Patient']['relation'];?>';
		if(relationWithPatient !='self'){
			 $("#showBeneficiaryBlock").show();
	    }else{
	    	 $("#showBeneficiaryBlock").hide();
		}
		var pid='<?php echo $privateID;?>';
	    var tariff=$('#tariff').val();
        if(tariff !=pid){
          $("#showwithcard").show();
           $('#showwithcardInsurance :input').attr('disabled', true); // disable hide block input variables
          $("#corporateStatus").show();
           }
        
		//to display the default values of referral dosctors by Swati Neole
		var familyknowndoctor = $("#familyknowndoctor").val();
		if(familyknowndoctor != ''){
			getConsultantForEdit();
			refferalAutocomplete(familyknowndoctor);
			$("#doctorlisting").show();
		}	
		if(('<?php echo $someData['Person']['pregnant_week']?>')){
			$(".pregnant").show();
			}else{
				$(".pregnant").hide();
			} 
		
		/*if('<?php echo $this->data['Patient']['payment_category']?>' =='cash'){
			$('#tariff').val(pid);
	}else if('<?php echo $this->data['Patient']['payment_category']?>' =='Corporate'){
			$('#showwithcard').hide('fast');  
            $('#showwithcardInsurance').show('slow'); 
            $('#showwithcardInsurance :input').attr('disabled', false);
            $('#showwithcard :input').attr('disabled', true);
	}else if('<?php echo $this->data['Patient']['payment_category']?>' =='Insurance company'){
		 $('#showwithcard').hide('fast');  
            $('#showwithcardInsurance').show('slow'); 
            $('#showwithcardInsurance :input').attr('disabled', false);
            $('#showwithcard :input').attr('disabled', true);
	}
	else if('<?php echo $this->data['Patient']['payment_category']?>' =='TPA'){
		 $('#showwithcard').hide('fast');  
            $('#showwithcardInsurance').show('slow'); 
            $('#showwithcardInsurance :input').attr('disabled', false);
            $('#showwithcard :input').attr('disabled', true);
	};
*/

		
		// binds form submission and fields to the validation engine
		   	 jQuery("#patientfrm").validationEngine(); 
		     //BOF pankaj - against standard amount
			 $('#against').change(function(){
				 $('#standardAgainst').val($('#against').val());
			 });
			 //EOF panakj - agianst standard amount 	
			 //BOF performance indicator date validation
			 var target = null;
			 $('#patientfrm :input').focus(function() {
			    target = $(this).attr('id');
			 })
  			 $("#extra2").click(function(){ 
		    	 $('#print_sheet').val('extra');
		
		     });
			 $("#extra1").click(function(){
			 	$('#print_sheet').val('extra');
			 });
				   	
		   $('#patientfrm').submit(function(){
				var validationRes = jQuery("#patientfrm").validationEngine('validate');
	         //   $("#department_id").attr("disabled","");
				var received			 	= new Date($('#formReceivedOn').val()); 
			 
				var completed 			 	= new Date($('#formCompletedOn').val());

				var docIniAssessOn		 	= new Date($('#docIniAssessOn').val()); 
				var docIniAssessEndOn 	 	= new Date($('#docIniAssessEndOn').val()); 
				
				var nurseAssessmentOn	 	= new Date($('#nurseAssessmentOn').val()); 
				var nurseAssessmentEndOn 	= new Date($('#nurseAssessmentEndOn').val()); 
				
				var nutritionalAssessOn	 	= new Date($('#nutritionalAssessOn').val()); 
				var nutritionalAssessEndOn 	= new Date($('#nutritionalAssessEndOn').val());  
				 
				var error = '';
				if (received.getTime() > completed.getTime())
				{
				  	 error = "*Form Received date can not be greater than Registration Completed by patient";
				}
				
				if(docIniAssessOn.getTime() > docIniAssessEndOn.getTime())
				{
					 error += "\n*Start of Assessment can not be greater than End of Assessment by Doctor";
				}

				if(nurseAssessmentOn.getTime() > nurseAssessmentEndOn.getTime()){
					 error += "\n*Start of Nursing Assessment can not be greater than End of Nursing Assessment"; 
				}

				if(nutritionalAssessOn.getTime() > nutritionalAssessEndOn.getTime()){
					 error += "\n*Start of Nutritional Assessment can not be greater than End of Nutritional Assessment";
				}
				
				if(error !=''){
					alert(error);
					return false ;
				}
				if(validationRes){
					$("#extra2").attr('disabled','disabled');
					$("#extra1").attr('disabled','disabled');
					$("#submit").attr('disabled','disabled');
					$("#submit-1").attr('disabled','disabled');
				}  
			});
				
			  
		 //BOF performance indicator date validation


		   /*
		   $('#doctor_id').change(function(){
			    $.ajax({
			      url: "<?php echo $this->Html->url(array("controller" => 'patients', "action" => "getDoctorsDept", "admin" => false)); ?>"+"/"+$(this).val(),
			      context: document.body,          
			      success: function(data){ 
				      alert(data);
			     $('#department_id').val(parseInt(data)); 
			      }
			    });
			   });
*/
		   $('#doctor_id').change(function(){
				
			    $.ajax({
			      url: "<?php echo $this->Html->url(array("controller" => 'patients', "action" => "getDoctorsDept", "admin" => false)); ?>"+"/"+$(this).val(),
			      context: document.body,          
			      success: function(data){ 
			       $('#department_id').val(parseInt(data)); 
			       $('#d_id').val(parseInt(data));
			      }
			    });
			   }); 

			$('#department_id').change(function(){
				var val='';
				$.ajax({
			      url: "<?php echo $this->Html->url(array("controller" => 'patients', "action" => "getDoctorByDepartmentWise", "admin" => false)); ?>"+"/"+$(this).val(),
			      context: document.body,          
			      success: function(data){ 
			    	   
					  if(data !== undefined && data !== null){				    
							data1 = $.parseJSON(data);	
							if(data1 !='' && data1 !== undefined && data1 !== null){	
								
								$("#doctor_id option").remove();	
								$('#doctor_id').append( "<option value='"+val+"'>Please Select</option>" );								
								$.each(data1, function(val, text) {
									if(val !='' && val !== undefined && val !== null)
								    $('#doctor_id').append( "<option value='"+val+"'>"+text+"</option>" );
								});
					  		}else{
						  	
					  			$("#doctor_id option").remove();
					  			$('#doctor_id').append( "<option value='"+val+"'>Please Select</option>" );
					  		}
					  }
			      }
			    });
			   });
					   
		    //new changes
			$('#Allergies1').click(function(){
				$('#allergy-table').fadeIn('slow');
			});
			$('#Allergies0').click(function(){
				$('#allergy-table').fadeOut('slow');
			});
			
			$('.past:radio').click(function(){
				 var textName = $(this).attr('id').substr(0,($(this).attr('id').length)-1) ;				 
				 var lowercase = textName.toLowerCase();
			 
				if($(this).val() =='1'){
					$('#'+lowercase+'_since').fadeIn('slow');
				}else{
					$('#'+lowercase+'_since').fadeOut('slow');
				}
			});
			
				$('.personal:radio').click(function(){
				 var textName = $(this).attr('id').substr(0,($(this).attr('id').length)-1) ;				 
				 var lowercase = textName.toLowerCase();
			 
				if($(this).val() =='1'){
					$('#'+lowercase+'_desc').fadeIn('slow');
				}else{
					$('#'+lowercase+'_desc').fadeOut('slow');
				}
			});
			//EOF new changes
			
			
			//function to hide/show ward dropdown
			$('#admission_type').change(function (){
				if($(this).val()=='IPD'){
					$('#wardSection').val('');
					$('#wardSection').show('slow');
				}else{
					$('#wardSection').hide('slow');
					$('#roomSection').hide('slow');
					$('#bedSection').hide('slow');
				}
			});	
		
		 
			
			$('#ward_id').change(function (){				
				roomSection();
			});
			
			$('#room_id').change(function (){			
				bedSection();
			});
			
			//defaultt call
			<?php
				//check room and bed ids are set or not
				if(!empty($this->data['Patient']['room_id'])){
					echo "var room_id=".$this->data['Patient']['room_id']." ;" ;
				}else{					
					echo "var room_id=null; " ;
				}
				if(!empty($this->data['Patient']['bed_id'])){
					echo "var bed_id=".$this->data['Patient']['bed_id']." ;" ;
				}else{
					echo "var bed_id=null; ";
				}
			?> 
			/*if(room_id != null){
				roomSection(room_id);
			}
			if(bed_id != null){
				bedSection(bed_id,room_id);
			}*/
			
			function roomSection(room_id){
				if($('#ward_id').val() != ''){
					$('#roomSection').show('slow');
				}else{
					$('#roomSection').hide('slow');
					$('#bedSection').hide('slow');
				}
				$("#room_id option").remove();
				$.ajax({
				  url: "<?php echo $this->Html->url(array("controller" => 'rooms', "action" => "getRooms", "admin" => false)); ?>"+"/"+$('#ward_id').val(),
				  context: document.body,				  		  
				  success: function(data){
				  	data= $.parseJSON(data);
				  	$("#room_id").append( "<option value=''>Please Select</option>" );
					
				  	$.each(data, function(val, text) {
				  		if(room_id==val){
					    	$("#room_id").append( "<option value='"+val+"' selected>"+text+"</option>" );
					   	}else{
					   		$("#room_id").append( "<option value='"+val+"'>"+text+"</option>" );
					   	}
					});
					$('#room_id').attr('disabled', '');	
				   }
				  });
			}
			
			
			function bedSection(bed_id,room_id){
					if($('#room_id').val() != ''){
					$('#bedSection').show('slow');
					}else{
						$('#bedSection').hide('slow');
					}
					$("#bed_id option").remove();
					if(room_id =='' || room_id == undefined){
						room_id = $('#room_id').val();
					}
					
					$.ajax({
					<?php if($this->data['Patient']['admission_type'] == 'IPD'){?>
						url: "<?php echo $this->Html->url(array("controller" => 'rooms', "action" => "getBeds", "admin" => false)); ?>"+"/"+room_id + "<?php if($this->data['Patient']['bed_id']) echo "/".$this->data['Patient']['bed_id'];?>",
					<?php }else{ ?>
					url: "<?php echo $this->Html->url(array("controller" => 'rooms', "action" => "getBeds", "admin" => false)); ?>"+"/"+room_id,
							<?php }?>
					  context: document.body,				  		  
					  success: function(data){
					  	data= $.parseJSON(data);
					  	$("#bed_id").append( "<option value=''>Please Select</option>" );
						$.each(data, function(val, text) {
							if(bed_id==val){
						    	$("#bed_id").append( "<option value='"+val+"' selected>"+text+"</option>" );
						    }else{
						    	$("#bed_id").append( "<option value='"+val+"'>"+text+"</option>" );
						    }
						});
						$('#bed_id').attr('disabled', '');	
					   
					  }
					});
			}

			 $('#familyknowndoctor').change(function(){
				    $("#refferalDoctorArea").html('');
					var category=$(this).val();
					if(category != ''){
						$("#refferalDoctorArea").show();
						$("#refferalDocSearch").show();
						refferalAutocomplete(category);
						var rowCount = document.getElementById('refferalDoctorArea').rows.length;
						if(rowCount == 0){
	                    	$("#refferalDocSearch").css({ display: "block" });
	                    	$("#searchDoctor").addClass("validate[required,custom[mandatory-select]]");
		                 }
						
					}else{
						$("#refferalDoctorArea").hide();
						$("#refferalDocSearch").hide();
					}
						
				});	
	});
	 
		//script to include datepicker
		$(function() {
		$("#date_of_referral" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,  		
			yearRange: '1950',	
			minDate: new Date(),		 
			dateFormat:'dd/mm/yy'
		});
				 
		$( "#docIniAssessOn" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,  		
			yearRange: '1950',			 
			dateFormat:'dd/mm/yy HH:II:SS'
		});
		$( "#nurseAssessmentOn" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',			 
			dateFormat:'dd/mm/yy HH:II:SS'
		});
		$( "#nutritionalAssessOn" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',			 
			dateFormat:'dd/mm/yy HH:II:SS',
		});
		$( "#docIniAssessEndOn" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,  		
			yearRange: '1950',			 
			dateFormat:'dd/mm/yy HH:II:SS'
		});
		$( "#nurseAssessmentEndOn" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',			 
			dateFormat:'dd/mm/yy HH:II:SS',
			onSelect : function() {
		 		var selDate = $("#nutritionalAssessOn").val();
		 		if(selDate == '') $(this).val('');
			}
		});
		$( "#nutritionalAssessEndOn" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',			 
			dateFormat:'dd/mm/yy HH:II:SS'
		});
		$( "#formReceivedOn" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',			 
			//maxTime : true,
            maxDate: new Date(),
            dateFormat: '<?php echo $this->General->GeneralDate('HH:II:SS');?>',
		});
                $( "#formCompletedOn" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',			 
			//dateFormat:'dd/mm/yy HH:II:SS',
                        maxDate: new Date(),
            dateFormat: '<?php echo $this->General->GeneralDate('HH:II:SS');?>',
		});
                // form received by patient date if check true
		$( "#docIniAssessment" ).click(function(){
			if($( "#docIniAssessment" ).is(':checked') == true) {
                          var currentdate = new Date();
                         // var showdate = currentdate.getDate()+"/"+(currentdate.getMonth()+1)+"/"+currentdate.getFullYear()+" "+currentdate.getHours()+":"+currentdate.getMinutes();
                          var showdate = '<?php echo $this->DateFormat->formatdate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'),true);?>';
                          $( "#formReceivedOn" ).val(showdate);
                        } else {
                          $( "#formReceivedOn" ).val('');
                        }
		}); 
                // form completed by patient date if check true
		$( "#nurseAssessment" ).click(function(){
			if($( "#nurseAssessment" ).is(':checked') == true) {
                          var currentdate = new Date();
                         // var showdate = currentdate.getDate()+"/"+(currentdate.getMonth()+1)+"/"+currentdate.getFullYear()+" "+currentdate.getHours()+":"+currentdate.getMinutes();
                          var showdate = '<?php echo $this->DateFormat->formatdate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'),true);?>';
                         $("#formCompletedOn" ).val(showdate);
                        } else {
                          $( "#formCompletedOn" ).val('');
                        }
		});
		//BOF card block
		
			$('#paymentType').change(function(){
				//var pid='<?php echo $privateID;?>';
				if($(this).val()=='cash'){
					//$('#tariff').val(pid);
					$('#remark').attr('disabled',true);
					$('#sponsersAuthOpt').fadeOut();
					$('#status-remark').fadeOut('slow');
					$('#sponsersAuth').fadeIn(); 	
					$('#sponsersAuth').attr('disabled',true);
					$("#corporateStatus").hide('slow');
					}else if($(this).val() == 'Corporate'){
		               	 $('#showwithcard').show('slow');  
		                 $('#showwithcardInsurance').hide('fast'); 
		                $('#showwithcardInsurance :input').attr('disabled', true);
		                $('#showwithcard :input').attr('disabled', false);
		                $("#corporateStatus").show('slow');
		            }else if($(this).val() == 'Insurance company'){
		           		 $('#showwithcard').hide('fast');  
		                 $('#showwithcardInsurance').show('slow'); 
		                 $('#showwithcardInsurance :input').attr('disabled', false);
		                 $('#showwithcard :input').attr('disabled', true);
		                 $("#corporateStatus").show('slow');
		            }
		            else if($(this).val() == 'TPA'){
		           		 $('#showwithcard').hide('fast');  
		                 $('#showwithcardInsurance').show('slow'); 
		                 $('#showwithcardInsurance :input').attr('disabled', false);
		                 $('#showwithcard :input').attr('disabled', true);
		                 $("#corporateStatus").show('slow');
		            }else{
						$('#sponsersAuth').fadeOut();
						$('#sponsersAuthOpt').fadeIn();
						$('#status-remark').fadeIn('slow'); 
						$("#corporateStatus").hide('slow');
					}
			});
		
		   $('#status').change(function(){
				if($(this).val()==''){
					$('#remark').attr('disabled',true);
				}else{
					 
					if($(this).val()=='Pre-authorization sent'){
						$('#remark').val('Estimate Amount');
					}
					if($(this).val()=='Pre-authorization approval received'){
						$('#remark').val('Pre-authorization approval received');
					}
					if($(this).val()=='Payment received'){
						$('#remark').val('Details of payment received\nAmount:\nCheq no:\nDate:\NEFT no:\nDeductions: TDS\nOthers:');
					} 
					
					$('#remark').attr('disabled',false);
				}
			});  
		   if($('#paymentType').val() == "card") {
		   		$('#status-remark').show();
		   		if($('#status').val()!='')
				$('#remark').attr('disabled',false);
		   }else{
			   $('#status-remark').hide('fast');
			   $('#remark').attr('disabled',true);
		   }
			
		   if($('#insurance_non_executive_emp_id_no').val() != ''){
				  $('#insurance_executive_emp_id_no').attr('disabled',true);
		   }
       	   if($('#insurance_executive_emp_id_no').val() != ''){
				  $('#insurance_non_executive_emp_id_no').attr('disabled',true);
		   }
       	   if($('#corpo_executive_emp_id_no').val() != ''){
				  $('#corpo_non_executive_emp_id_no').attr('disabled',true);
		   }
		   if($('#corpo_non_executive_emp_id_no').val() != ''){ 
				  $('#corpo_executive_emp_id_no').attr('disabled',true);
		   }
		  
		  if($('#paymentCategoryId').val() == "1") { 
		      $('#showwithcard').show();
		      $('#showwithcardInsurance :input').attr('disabled', true);
		      $('#showwithcardInsurance :input').val(''); 
          }else if($('#paymentCategoryId').val() == "2") {
              $('#showwithcardInsurance').show(); 
              $('#showwithcard :input').attr('disabled', true);
              $('#showwithcard :input').val('');
          }
         
	      $('#paymentCategoryId').on('change',function(){
			 if($('#paymentCategoryId').val() == 1) {
             	$('#showwithcardInsurance').hide('fast');
                $('#showwithcard').show('slow');
                $('#showwithcardInsurance :input').attr('disabled', true);
                $('#showwithcard :input').attr('disabled', false);
             }else if($('#paymentCategoryId').val() == 2) {
                $('#showwithcard').hide('fast');  
                $('#showwithcardInsurance').show('slow'); 
                $('#showwithcardInsurance :input').attr('disabled', false);
                $('#showwithcard :input').attr('disabled', true);
             }else{  
                $('#showwithcard').hide();
                $('#showwithcardInsurance').hide();
             } 
		 });
			  
		 $('#paymentType').change(function(){
			 var pid='<?php echo $privateID;?>';
			 if($('#paymentType').val() == "cash") {
				// $('#tariff').val(pid);
			    	$('#showwithcard').hide();
		            $('#showwithcardInsurance').hide();
		     }else if($('#paymentType').val() == ''){
            	 $('#showwithcard').hide();
                 $('#showwithcardInsurance').hide();
            }	
		 });

			<?php if($this->Session->read('website.instance')=='kanpur' ){?>
		 $('#tariff').change(function(){
				var pid='<?php echo $privateID;?>';
				if($(this).val()==pid){
						 $('#paymentType').val("cash");
						 $('#showwithcard').hide('fast');  
		                 $('#showwithcardInsurance').hide('slow'); 
		                 $('#showwithcardInsurance :input').attr('disabled', false);
		                 $('#showwithcard :input').attr('disabled', true);
					}else {
						 $('#paymentType').val("TPA");
		           		 $('#showwithcard').hide('fast');  
		                 $('#showwithcardInsurance').show('slow'); 
		                 $('#ajaxinsurancecompanyid').hide('slow');
		                 $('#showwithcardInsurance :input').attr('disabled', false);
		                 $('#showwithcard :input').attr('disabled', true);
		            }
			});
			<?php }?>
			<?php if($this->Session->read('website.instance')=='hope' ){?>
			 $('#tariff').change(function(){
					var pid='<?php echo $privateID;?>';
					if($(this).val()==pid){
							 $('#paymentType').val("cash");
							 $('#showwithcard').hide('fast');  
			                 $('#showwithcardInsurance').hide('slow'); 
			                 $('#showwithcardInsurance :input').attr('disabled', false);
			                 $('#showwithcard :input').attr('disabled', true);
			                 $("#corporateStatus").hide('slow');
						}else {
							 $('#paymentType').val("Corporate");
			           		 $('#showwithcard').hide('fast');  
			                 $('#showwithcardInsurance').show('slow'); 
			                 $('#ajaxinsurancecompanyid').hide('slow');
			                 $('#showwithcardInsurance :input').attr('disabled', false);
			                 $('#showwithcard :input').attr('disabled', true);
			                 $("#corporateStatus").show('slow');
			            }
				});
				<?php }?>
		//fnction to disable one option
		$('.emp_id').on('keyup change',function(){
			if($(this).val() != ''){
				$('.emp_id').not(this).attr('disabled',true);
				if($(this).attr('id')=='insurance_executive_emp_id_no'){
					$('#insurance_esi_suffix').val('');
					$('#insurance_non_executive_emp_id_no').val();
				}else if($(this).attr('id')=='insurance_non_executive_emp_id_no'){
					$('#insurance_esi_suffix').val($('#insurance_relation_to_employee').val());
					$('#insurance_executive_emp_id_no').val(); 
				}
				if($(this).attr('id')=='corpo_executive_emp_id_no'){
					$('#corpo_esi_suffix').val('');
				}else if($(this).attr('id')=='corpo_non_executive_emp_id_no'){
					$('#corpo_esi_suffix').val($('#corpo_relation_to_employee').val());
				} 
		   }else{
				$('.emp_id').attr('disabled',false);
		   }
		}); 
		//on realtion select
		$('#insurance_relation_to_employee').change(function(){
			$('#insurance_esi_suffix').val($(this).val());
			$('#corpo_esi_suffix').val('');
			$('#corpo_relation_to_employee').val('');
		});

		$('#corpo_relation_to_employee').change(function(){
			$('#insurance_esi_suffix').val('');
			$('#corpo_esi_suffix').val($(this).val());
			$('#insurance_relation_to_employee').val('');
		});		
		
		$("#familyknowndoctor").change(function(){
			if($(this).val() != ''){
				$("#refererArea").show();
			}else{
				$("#refererArea").hide();
			}
		});
			//EOF card block
	});
		$('#doctorlisting').on('change',function(){
			var consultantId=$('#doctorlisting option:selected').val();
			$.ajax({
				  url: "<?php echo $this->Html->url(array("controller" => 'patients', "action" => "getReferralPercent", "admin" => false)); ?>"+"/"+consultantId,
				  context: document.body,				  		  
				  success: function(data){
				  	$('#ref_cost').val(data);
				  }
		   });
			
		});

		<?php if($this->Session->read('website.instance')=='lifespring' ){?>	
			$('#tariff').change(function(){         
					if($("#tariff option:selected") && $("#tariff option:selected").text()!='Private')
						{ 
					 		$(".approval").show();
						}else{
							$(".approval").hide();
							$(".note").hide();
							}
				});
			 $("#extra2").click(function(){ 
		    	 $('#print_sheet').val('extra');
		    	 if($('#is_approved').length != 0 && $.trim($("#is_approved").val()) != '1' && $("#tariff option:selected").val()!='<?php echo $privateID;?>' ){		 
			    	 alert("Please Get Approval for Ward Change.");
						return false ;
		    	 }
		     });
				
							
			$('#coupon_name').keypress(function(){
				if($('#coupon_name').val() == ''){
					$('#validcoupon').hide();
					$("#coupon_name").validationEngine("hidePrompt");
					validatePerson = true  ;
				}else{
					$('#validcoupon').hide();
					$('#coupon_name').validationEngine('showPrompt', 'Invalid Coupon', 'text', 'topRight', true);
					validatePerson = false ;
				}
			});
			
				/*$("#coupon_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Coupon","batch_name",'null',"null",'null',"parent_id NOT='0'","admin" => false,"plugin"=>false)); ?>", {
					width: 80,
					selectFirst: true,
					onItemSelect:function (data) { 
						 name = $('#coupon_name').val();
						$.ajax({
							type:'POST',
				   			url : "<?php echo $this->Html->url(array("controller" => 'patients', "action" => "couponValidate","admin" => false));?>"+"/"+name,
				   			 context: document.body,   
				   			success: function(data){ 
				   				
				   				if($.trim(data) != 'Coupon Available' ){
									
				   					$('#validcoupon').hide();
									$('#coupon_name').validationEngine('showPrompt', data, 'text', 'topRight', true);
									validatePerson = false;
				   				}else{
				   					$('#validcoupon').show();
					   				}
					   		}
						}); 
					}
				});	*/
				

				$('#is_pregnent').click(function(){			
					if($("#is_pregnent").is(':checked')){	
						$('.hideRow').show();
					}else{
						$('.hideRow').hide();
						$('#pregnant_week , #edd').val("");	
					}
				});		

				$(".edd").datepicker({
					showOn: "button",
					buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
					buttonImageOnly: true,
					changeMonth: true,
					changeYear: true,
					yearRange: '1950',
					minDate: new Date(),
					dateFormat: '<?php echo $this->General->GeneralDate();?>',		
				});		
				$("#send-approval").click(function(){  
					if($("#authorize_by").val() == 'empty'){
				    	alert('Please select the user for approval');
						return false;
				    }else if($("#authorize_by").val() != 'empty'){
					    patientId = '<?php echo $patientId; ?>'; 
						user = $("#authorize_by").val();	//authhorized user whom we are sending approval
					    $.ajax({
							  type : "POST",
							  data: "patient_id="+patientId+"&request_to="+user,
							  url: "<?php echo $this->Html->url(array("controller" => "patients", "action" => "requestForApproval","admin" => false)); ?>",
							  context: document.body,
							  beforeSend:function(){
								  $("#busy-indicator").show();
							  },	
							  success: function(data){ 
								 $("#busy-indicator").hide(); 
								 $("#message").show();
									$("#status-approved-message").html(" send apporval Request for Change Tariff has been sent, please wait for approval");
									$("#is_approved").val(0);	//for approval waiting
									 $("#image-gif").show();
									 $("#image-gif").html('<?php echo $this->Html->image('/img/wait.gif')?>'); //loader
									 $("#send-approval").hide();	//hide send approval button 
									 $("#cancel-approval").show();	//show reset button
									 interval = setInterval("Notifications()", 10000);  // this will call Notifications() function in each 5000ms
							} //end of success
						}); //end of ajax
					} //end of if else
					
				});
				//set request timer to check approval status 
				function Notifications()
				{
					patientId = '<?php echo $result['Patient']['id']; ?>';
			    	user = $("#authorize_by").val();

			        $.ajax({
			        	type : "POST",
						  data: "patient_id="+patientId+"&request_to="+user,
						  url: "<?php echo $this->Html->url(array("controller" => "patients", "action" => "resultofrequest","admin" => false)); ?>",
						  context: document.body,	
						  success: function(data){   

							  $("#message").show();	//message Container
							  $("#authorize_by").attr('disabled',true);
							  $("#send-approval").hide();
							  $("#cancel-approval").show();			//show cancel button to remove approval
							 // alert(data)
							if(parseInt(data) == 0)
							{ 
								$("#status-approved-message").html("Request for Change Tariff has been sent, please wait for approval");
								$("#image-gif").html('<?php echo $this->Html->image('/img/wait.gif')?>');
								$("#is_approved").val(data);
								$("#send-approval").hide();
							}else
							if(data == 1)		//approved
							{				
								$("#status-approved-message").html('<font color="green">Request for Change Tariff has been completed</font>');
								$("#image-gif").hide();
								$("#is_approved").val(data);  //for approval complete
								clearInterval(interval); // stop the interval
							}else
							if(data == 2)		// if rejected by users
							{
								$("#message").show();
								$("#status-approved-message").html('<font color="red">Request for Change Tariff has been rejected</font>');
								$("#image-gif").hide();
								$("#is_approved").val(data);	// for approval reject
								$('#tariff').val('<?php echo $privateID?>');
								$('#authorize_by').val('');
								
								clearInterval(interval); // stop the interval 
									
							}
						} //end of success
					});
				}
				//for cancelling the unapproved approval of bed transfer only
				 $("#cancel-approval").click(function(){

					 var conResult = confirm("Are you sure to cancel the request for Change Tariff?");
					 if(conResult == true)
					 {
						patientId = '<?php echo $result['Patient']['id']; ?>';
						user = $("#authorize_by").val();

						$.ajax({
							  type : "POST",
							  data: "patient_id="+patientId+"&request_to="+user,
							  url: "<?php echo $this->Html->url(array("controller" => "patients", "action" => "cancelApproval","admin" => false)); ?>",
							  context: document.body,
							  beforeSend:function(){ 
								  $("#busy-indicator").show();
							  },	
							  async: false,
							  success: function(data){ 
								$("#busy-indicator").hide(); 
								clearInterval(interval); // stop the interval
								$("#is_approved").val('');
								$("#authorize_by").val('');
								$("#authorize_by").attr('disabled',false);
								$("#send-approval").show();
								$("#cancel-approval").hide();
								$('#tariff').val('<?php echo $privateID?>');
								$("#message").hide();
							  }
						});
				 	}else{
					 	return false;
				 	}
				 });				
		<?php } ?>
		
		 $("#relation").change(function(){
				var relation = $(this).val();
				if(relation != 'self'){
					 $("#showBeneficiaryBlock").show();
				}else{
					$("#showBeneficiaryBlock").hide();
				}
		 });

	 function getConsultantForEdit(){
			var patientID = '<?php echo $this->data['Patient']['id'];?>';	
			var refferalType = '<?php echo $this->data['Patient']['known_fam_physician'];?>';	
		    var ajaxUrl= "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "getAssigenedRefferalDoctor","admin"=>false)); ?>";
		    $.ajax({
		        beforeSend : function() {
		            $('#busy-indicator').show('fast');	
		        },
		        url: ajaxUrl+"/"+patientID+"/"+refferalType,
		        dataType: 'html',
		        success: function(data){
		            obj=$.parseJSON(data);
		            if(obj!='' && obj != null ){
		           	 $("#refferalDoctorArea").show();
		     		 $("#refferalDocSearch").show();
		     		 $("#refferalDocSearch").css({ display: "block" });
		                    $.each(obj, function(key, val) {
		                        var doctorId=key;
		                        var doctorName=val;
		                        img= '<a href="javascript:void(0);" class="removeRow" id=remove_'+doctorId+'> <img src="<?php echo $this->webroot ?>theme/Black/img/cross.png" alt="Remove Row" title="Remove Row" /></a>';
				    	    	inputVar  = '<input class="service-box" type="hidden" name="data[Patient][consultant_id][]" value='+doctorId+'>';// to maintain hidden values 
				    	    	li = $('<tr id=refferalTr_'+doctorId+' class=""><td><span style="float:left">'+ doctorName + '</span><span>'+inputVar+'</span></td><td style="width: 5%">'+ img +'</td></tr>'); 
		                        li.appendTo('.top');
		                    });
		              
		                $('#busy-indicator').hide('fast');	
				   		
		            }else{
		            	$("#refferalDoctorArea").show();
			     		$("#refferalDocSearch").show();
			     		img= '<a href="javascript:void(0);" class="removeRow" id="remove_None"> <img src="<?php echo $this->webroot ?>theme/Black/img/cross.png" alt="Remove Row" title="Remove Row" /></a>';
		    	    	inputVar  = '<input class="service-box" type="hidden" name="data[Patient][consultant_id][]" value="None">';// to maintain hidden values 
		    	    	li = $('<tr id="refferalTr_None"  class=""><td><span style="float:left">None</span><span>'+inputVar+'</span></td><td style="width: 5%">'+ img +'</td></tr>'); 
		    	    	li.appendTo('.top');
		                $('#busy-indicator').hide('fast');	
		                return false;
		            }
		        },
		        messages: {
		            noResults: '',
		            results: function() {}
		        }
		    });
	  }

	  function refferalAutocomplete(category){
		  $('#searchDoctor').autocomplete({
			    source: "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "getRefferalDoctor","admin" => false,"plugin"=>false)); ?>"+"/"+category,
			    setPlaceHolder : false,
			    select: function(event,ui){	
			    	    var doctorName=ui.item.value;	    	        	    		
				    	var doctorId=ui.item.id;	 
				    	$('.service-box').each(function() { //check for duplicate 
		                    if(doctorId == this.value){ 
			                    if(category == 7){
			                    	alert('Camp Date already selected!!'); 
				                  }else{
			                  		 alert('This Referral Doctor already added!!'); 
				                  }
			                   $("#refferalTr_"+doctorId).remove();
		                    }
		                });
				    	    				  
			    	    	$("#refferalDoctorArea").find('tbody')
				    	    img= '<a href="javascript:void(0);" class="removeRow" id=remove_'+doctorId+'> <img src="<?php echo $this->webroot ?>theme/Black/img/cross.png" alt="Remove Row" title="Remove Row" /></a>';
			    	    	inputVar  = '<input class="service-box" type="hidden" name="data[Patient][consultant_id][]" value='+doctorId+'>';// to maintain hidden values 
			    	    	li = $('<tr id=refferalTr_'+doctorId+' class=""><td><span style="float:left">'+ doctorName + '</span><span>'+inputVar+'</span></td><td style="width: 5%">'+ img +'</td></tr>'); 
			    	    	li.appendTo('.top');

			    	    	//validation if refferal not selected
			    	    	var rowsCount = document.getElementById('refferalDoctorArea').rows.length;
			                    if(rowsCount == 0){
			                    	$("#refferalDocSearch").css({ display: "block" });
			                    	$("#searchDoctor").addClass("validate[required,custom[mandatory-select]]");
				                 }else{
				                	 $("#refferalDocSearch").css({ });
				                	 $("#searchDoctor").removeClass("validate[required,custom[mandatory-select]]");
					             }

			    	    	this.value = "";
			    	    	return false ;	
			    	        	    	
			    	 },
			    	  messages: {
			    	    noResults: '',
			    	    results: function() {},
			    	 },
			});
		}

		$(document).on('click','.removeRow', function(){
			var rowId = $(this).attr('id').split("_")[1];
			$("#refferalTr_"+rowId).remove(); 

			var trCount = document.getElementById('refferalDoctorArea').rows.length;
			if(trCount == 0){
	        	$("#refferalDocSearch").css({ display: "block" });
	        	$("#searchDoctor").addClass("validate[required,custom[mandatory-select]]");
	         }else{
	        	$("#refferalDocSearch").css({ });
	        	 $("#searchDoctor").removeClass("validate[required,custom[mandatory-select]]");
	         }
	 });
</script>
