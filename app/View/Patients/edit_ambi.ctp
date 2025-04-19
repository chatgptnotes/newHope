<?php 
//echo $this->Html->script(array('jquery.autocomplete','jquery.ui.accordion.js','stuHover.js'));

// echo $this->Html->css(array('jquery.autocomplete.css','skeleton.css'));


#pr($this->data['Patient']['bed_id']);exit;
//echo $this->Html->script(array('jquery.ui.widget.js','jquery.ui.mouse.js','jquery.ui.core.js','jquery.ui.slider.js','jquery-ui-timepicker-addon.js'));
//set array of patient category
if($this->data['Patient']['admission_type'] == "OPD"){
	$type =  'Outpatient';
	$buttonLabel = "Set Appointment";
	$extraButton ='Submit & Print Sheet';
	$urlType= 'OPD';
}else{
	//$category = array('OPD'=>__('Outpatient'),'IPD'=>__('Inpatient'));
	//echo $this->Form->input('admission_type', array('empty'=>__('Please select'),'options'=>$category,'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'admission_type'));
	$type =  'Inpatient';
	$buttonLabel = "Submit";
	$extraButton ='';
	if($this->data['Patient']['is_emergency']==1) $urlType= 'emergency';
	else $urlType= 'IPD';

}

?>
<?php 
debug($getadd);
debug($state_code);?>
<?php $type =  $gettype['0']['Patient']['admission_type'];  ?>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Edit Patient Information', true); ?>
	</h3>
	<span> <?php echo $this->Html->link(__('Search Patient'), array('action' => 'search','?'=>array('type'=>$urlType)), array('escape' => false,'class'=>'blueBtn')); ?>
	</span>
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
		<input class="grayBtn" type="button" value="Cancel"
			onclick="window.location='<?php echo $this->Html->url(array("controller" => $this->params['controller'], "action" => "patient_information",$this->data['Patient']['id'],'?'=>$this->params->query));?>'">
		<input class="blueBtn" type="submit"
			value="<?php echo $buttonLabel ;?>" id="submit_btn">
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
			<td width="19%" valign="middle" class="tdLabel" id="boxSpace"><?php echo __("Lookup Patient Name");?><font
				color="red">*</font></td>
			<td width="30%"><table width="100%" cellpadding="0" cellspacing="0"
					border="0">
					<tr>
						<td><?php echo $this->Form->input('lookup_name', array('class' => 'validate[required,custom[name]] textBoxExpnd','id' => 'lookup_name', 'label'=> false,
			 												  'div' => false, 'error' => false,'readonly'=>'readonly')); ?>
						</td>
						<td width="35" style="padding-right: 10px;"><?php
						//echo $this->Html->link($this->Html->image('icons/patient-name.png',array('alt'=>__('View'),'title'=>__('View'))),'#',
						//	   array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'persons','action'=>'patient_search'))."', '_blank',
								      //     'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=1000,height=500,left=400,top=400');  return false;"));

						   			//echo  $this->Html->image('icons/eraser.png',array('alt'=>__('View'),'title'=>__('View'),'onclick'=>'clearLookup();')) ;
								?></td>

					</tr>
				</table></td>


		</tr>
		<tr>
			<!--
                        <td valign="middle" class="tdLabel" id="boxSpace">Patient Name <font color="red">*</font></td>
                        <td>
                        	<?php //echo $this->Form->input('full_name', array('class' => 'validate[required,custom[name]] textBoxExpnd','id' => 'full_name')); ?>
                        </td>
                        -->
			<td class="tdLabel" id="boxSpace"><?php echo Configure::read('doctor');?><font
				color="red">*</font>
			</td>
			<td width="250"><?php echo $this->Form->input('doctor_id', array('empty'=>__('Please Select'),'options'=>$doctors,'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'doctor_id')); ?>
			</td>
			<td>&nbsp;</td>
			<td class="tdLabel" id="boxSpace"><?php __("Specilty");?></td>
			<td><?php echo $this->Form->input('department_id', array('empty'=>__('Please Select'),'options'=>$departments,'class' => 'textBoxExpnd','id' => 'department_id', 'disabled' => 'disabled')); ?>
			</td>

		</tr>
		<!--  <tr>
                        <td valign="middle" class="tdLabel" id="boxSpace">Sex</td>
                        <td>
                        	<?php //echo $this->Form->input('sex', array('options'=>array(""=>__('Please select'),"male"=>__('Male'),'female'=>__('Female')),'class' => 'validate[required,custom[patient_gender]] textBoxExpnd','id' => 'sex')); ?>	
                        	
                        </td>
                        <td>&nbsp;</td>
                        <td class="tdLabel" id="boxSpace">Date of Admission</td>
                        <td>
							<?php //echo $this->Form->input('dateofadmission', array('readonly','class' => 'textBoxExpnd','id' => 'dateofadmission','readonly'=>'readonly','type'=>'text','style'=>'width:85%;')); ?>
                        </td>
                     </tr> -->
		<tr>
			<td valign="middle" class="tdLabel" id="boxSpace">Previous Receivable</td>
			<td><?php 
			echo $this->Form->input('previous_receivable', array('class' => 'textBoxExpnd','id' => 'previous_receivable'));
			?>
			</td>
			<td></td>
			<td class="tdLabel" id="boxSpace">Category</td>
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
							<td width="16%" class="tdLabel" id="boxSpace">Ward Alloted</td>
							<td width="20%"><strong> <?php 
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
							<td width="16%" class="tdLabel" id="boxSpace"><?php echo __('OP Check up', true); ?><font
								color="red">*</font></td>
							<td width="20%"><?php 
							$opdoptions = array('4' => 'First Consultation',
			                        						'5' => 'Follow-Up Consultation',
			                        						'6' => 'Preventive Health Check-up',
			                        						'7' => 'Vaccination',
			                        						'8' => 'Pre-Employment Check-up',
			                        						'9' => 'Pre Policy Check up',
			                        						'0'=>'Skip Registration/Consultation');
			                        		echo $this->Form->input('treatment_type', array('empty'=>__('Please Select'),'options'=>$opdoptions,'id' => 'opd_id', 'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd'));
			                        		?>
							</td>
						</tr>
					</table>
				</div>
			</td>
		</tr>

		<tr>
			<td class="tdLabel" id="boxSpace"></td>
			<td><?php //echo $this->Form->input('doctor_id', array('empty'=>__('Please select'),'options'=>$doctors,'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'doctor_id')); ?>
			</td>
			<td></td>
			<td colspan="2">
				<div id="roomSection" style="display:<?php echo $display ;?>;">
					<table style="width: 100%;">
						<tr>
							<td width="16%" class="tdLabel" id="boxSpace">Room Alloted</td>
							<td width="20%"><strong> <?php 
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
			<td class="tdLabel" id="boxSpace"></td>
			<td></td>
			<td></td>
			<td colspan="2">
				<div id="bedSection" style="display:<?php echo $display ;?>;">
					<table style="width: 100%;">
						<tr>
							<td width="16%" class="tdLabel" id="boxSpace">Bed Alloted</td>
							<td width="20%"><strong> <?php 
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
			<td valign="top" class="tdLabel" id="boxSpace">Email</td>
			<td valign="top"><?php echo $this->Form->input('email', array('class' => 'validate["",custom[email]] textBoxExpnd','id' => 'email')); ?>
			</td>
			<td>&nbsp;</td>
			<td></td>
		</tr>

		<!-- New Lines End -->
		<tr>
			<td class="tdLabel" id="boxSpace" valign="top"><?php echo  __('Referral Doctor'); ?>
			</td>
			<td valign="top"><?php //echo $this->Form->input('known_fam_physician', array('class' => 'textBoxExpnd','id' => 'knownPhysician')); 

							echo $this->Form->input('known_fam_physician', array('empty'=>__('Please select'), 'id'=>'familyknowndoctor', 'class'=>'textBoxExpnd',
                              'options'=>$reffererdoctors,'onchange'=> $this->Js->request(array('action' => 'getDoctorsList'),
                              array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
    							'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
    							'async' => true, 'update' => '#changeDoctorsList', 'data' => '{familyknowndoctor:$("#familyknowndoctor").val()}',
    							'dataExpression' => true, 'div'=>false))));
                          ?> <span id="changeDoctorsList"> <?php
                          $displayRefererContact = 'none' ;
                          if($this->data['Patient']['known_fam_physician']){
                           		 // if consultant id  exist //
                                   if($this->data['Patient']['consultant_id']){
	                           		 echo $this->Form->input('Patient.consultant_id', array('options' => $doctorlist, 'empty' => 'Select Doctor', 'id' => 'doctorlisting',
	                           		  'label'=> false, 'div' => false, 'error' => false,'class'=>'textBoxExpnd'));
                                   }
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
			<td valign="middle" class="tdLabel" id="boxSpace">Date of Referral</td>
			<td><?php echo $this->Form->input('date_of_referral', array('type'=>'text','class' => 'textBoxExpnd1','id' => 'date_of_referral')); ?>
			</td>
		</tr>
		<tr id="refererArea" style="display:<?php echo $displayRefererContact ;?>;">
			<td valign="middle" class="tdLabel" id="boxSpace">Referral Doctor
				Contact No.</td>
			<td><?php echo $this->Form->input('family_phy_con_no', array('class' => 'textBoxExpnd','id' => 'phyContactNo', 'value' => $someData['Person']['family_phy_con_no'])); ?>
			</td>
			<td>&nbsp;</td>
			<td class="tdLabel" id="boxSpace">&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td class="tdLabel" id="boxSpace">Relatives Name</td>
			<td><?php echo $this->Form->input('relative_name', array('class' => 'validate[optional,custom[onlyLetterSp]] textBoxExpnd','id' => 'relativeName')); ?>
			</td>
			<td>&nbsp;</td>
			<td class="tdLabel" id="boxSpace">Authorization From Sponsor</td>
			<td><?php echo $this->Form->input('sponsers_auth', array('class' => 'validate[optional,custom[onlyLetterSp]] textBoxExpnd','id' => 'sponsersAuth')); ?>
			</td>
		</tr>
		<!--  <tr>
                       <td valign="middle" class="tdLabel" id="boxSpace">&nbsp;</td>
                        <td>
                        	<?php //echo $this->Form->input('landline_phone', array('class' => 'textBoxExpnd','id' => 'landlinePhone')); ?>
                        </td>
                        <td>&nbsp;</td>
                       <td class="tdLabel" id="boxSpace">Patient's Photo</td>
                       <td><?php echo $this->Form->input('upload_image', array('type'=>'file','id' => 'patient_photo', 'label'=> false,
					 	'div' => false, 'error' => false)); ?></td>
                     </tr> -->
		<tr>
			<td valign="middle" class="tdLabel" id="boxSpace">Relative Phone No.</td>
			<td><?php echo $this->Form->input('mobile_phone', array('class' => 'validate["",custom[onlyNumber]] textBoxExpnd','Maxlength'=>'10','id' => 'mobilePhone')); ?>
			</td>
			<td>&nbsp;</td>
			<td class="tdLabel" id="boxSpace">Relationship With Patient</td>
			<td><?php
			$relationship = array('mother'=>'mother','father'=>'father','brother'=>'brother','other'=>'other');
			echo $this->Form->input('relation', array('empty'=>__('Please select'),
                        								  'options'=>$relationship,'class' => 'textBoxExpnd','id' => 'relation')); ?>
			</td>
		</tr>

		<tr>
			<td valign="middle" class="tdLabel" id="boxSpace">Instructions</td>
			<td><?php
			$instructions = array('Diabetic'=>'Diabetic- If found Unconscious give sugar/sweet/chocolate.','Epileptic'=>'Epileptic- In case of attack/fit turn patient to one side & refrain from feeding.','High Blood Pressure'=>'High Blood Pressure- If found unconscious or paralyzed, turn patient to one side & refrain from feeding.','Low Blood Pressure'=>'Low Blood Pressure- In case of vertigo keep head in low position & take plenty of fluids.','Cardiac Problem'=>'Cardiac Problem- In case of symtoms like chest pain or sweating administer Tablet Disprin & sublingual Tablet Sorbitrate.','Asthma'=>'Asthma- In case of acute attack administer 2 puffs of Scroflo inhaler & shift to hospital.');
			//$instructions = array('Diabetic'=>'Diabetic','Epileptic'=>'Epileptic','High Blood Pressure'=>'High Blood Pressure','Low Blood Pressure'=>'Low Blood Pressure','Prone to Angina Attacks'=>'Prone to Angina Attacks','Austistic'=>'Austistic');
			echo $this->Form->input('instructions', array('empty'=>__('Please select'),
                        								  'options'=>$instructions,'class' => 'textBoxExpnd','id' => 'instructions')); ?>
			</td>
			<td>&nbsp;</td>
			<td class="tdLabel" id="boxSpace">Tariff<font color="red">*</font>
			</td>
			<td><?php echo $this->Form->input('tariff_standard_id', array('empty'=>__('Please Select'),'options'=>$tariffStandard,'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd')); ?>
			</td>

		</tr>

		<!--  <tr>
                       <td class="tdLabel">Family Physician</td>
                        <td><?php echo $this->Form->input('family_physician', array('class' => 'textBoxExpnd','id' => 'family_physician')); ?></td>
                        <td>&nbsp;</td>
                        <td class="tdLabel" id="boxSpace">Relative's Signature</td>
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

			<td width="19%" class="tdLabel" id="boxSpace" valign="top">Sponsor
				Details <font color="red">*</font>
			</td>
			<td width="30%" valign="top"><?php 
			//	$paymentCategory = array('cash'=>'cash','card'=>'card');
			//echo $this->Form->input('payment_category', array('empty'=>__('Please select'),'options'=>$paymentCategory,'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'paymentCategory'));
			?> <?php
			$paymentCategory = array('cash'=>'Self Pay','card'=>'Card');
			echo $this->Form->input('payment_category', array('autocomplete'=>'off','empty'=>__('Please select'),'options'=>$paymentCategory,'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'paymentType','onchange'=> $this->Js->request(array('action' => 'getPaymentType'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
			    							'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeCreditTypeList', 'data' => '{paymentType:$("#paymentType").val()}', 'dataExpression' => true, 'div'=>false))));
			                       		?> <!-- BOF insurance section -->
				<div id="changeCreditTypeList">
					<?php 

					if($this->data['Patient']['credit_type_id'] == 1) {
			                        	?>
					<span><font color="red">*</font>&nbsp; <?php 
					echo $this->Form->input('Patient.credit_type_id', array('class'=>'validate[required,custom[mandatory-select]] textBoxExpnd1','options' => $credittypes, 'empty' => __('Select Credit Type'), 'id' => 'paymentCategoryId', 'label'=> false, 'div' => false, 'error' => false, 'onchange' => $this->Js->request(array('action' => 'getCorporateLocationList'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
				    							'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeCorprateLocationList', 'data' => '{paymentCategoryId:$("#paymentCategoryId").val()}', 'dataExpression' => true, 'div'=>false))));
				                          ?> <br> <span
						id="changeCorprateLocationList"><font color="red">*</font>&nbsp; <?php 
						echo $this->Form->input('Patient.corporate_location_id', array('class'=>'validate[required,custom[mandatory-select]] textBoxExpnd1','options' => $corporatelocations, 'empty' => __('Select Corporate Location'), 'id' => 'ajaxcorporatelocationid', 'label'=> false, 'div' => false, 'error' => false, 'onchange' => $this->Js->request(array('action' => 'getCorporateList'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
				    							'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeCorporateList', 'data' => '{ajaxcorporatelocationid:$("#ajaxcorporatelocationid").val()}', 'dataExpression' => true, 'div'=>false))));
				                          ?> <br> <span id="changeCorporateList"><font
								color="red">*</font>&nbsp; <?php 
								echo $this->Form->input('Patient.corporate_id', array('class'=>'validate[required,custom[mandatory-select]] textBoxExpnd1','options' => $corporates, 'empty' => __('Select Corporate'), 'id' => 'ajaxcorporateid', 'label'=> false, 'div' => false, 'error' => false, 'onchange' => $this->Js->request(array('action' => 'getCorporateSublocList'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
				    							'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeCorporateSublocList', 'data' => '{ajaxcorporateid:$("#ajaxcorporateid").val()}', 'dataExpression' => true, 'div'=>false))));
				                          ?> <br> <span
								id="changeCorporateSublocList"> <?php 
								echo $this->Form->input('Patient.corporate_sublocation_id', array('class'=>'textBoxExpnd','options' => $corporatesublocations, 'empty' => __('Select Corporate Sublocation'), 'id' => 'ajaxcorporatesublocationid', 'label'=> false, 'div' => false, 'error' => false));
								?> <?php
								echo "<br />";
								echo __('Other Details :');
								echo $this->Form->textarea('corporate_otherdetails', array('class' => 'textBoxExpnd','id' => 'otherdetails','row'=>'3'));
								?>
							</span> </span> </span> </span>

					<?php } if($this->data['Patient']['credit_type_id'] == 2) { ?>
					<span><font color="red">*</font>&nbsp; <?php 
					echo $this->Form->input('Patient.credit_type_id', array('class'=>'validate[required,custom[mandatory-select]] textBoxExpnd1','options' => $credittypes, 'empty' => __('Select Credit Type'), 'id' => 'paymentCategoryId', 'label'=> false, 'div' => false, 'error' => false, 'onchange' => $this->Js->request(array('action' => 'getCorporateLocationList'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
				    							'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeCorprateLocationList', 'data' => '{paymentCategoryId:$("#paymentCategoryId").val()}', 'dataExpression' => true, 'div'=>false))));
				                          ?> <span id="changeCorprateLocationList"><font
							color="red">*</font>&nbsp; <?php 
							echo $this->Form->input('Patient.insurance_type_id', array('class'=>'validate[required,custom[mandatory-select]] textBoxExpnd1','options' => $insurancetypes, 'empty' => __('Select Insurance Type'), 'id' => 'insurancetypeid', 'label'=> false, 'div' => false, 'error' => false, 'onchange' => $this->Js->request(array('action' => 'getInsuranceCompanyList'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
				    							'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeInsuranceCompanyList', 'data' => '{insurancetypeid:$("#insurancetypeid").val()}', 'dataExpression' => true, 'div'=>false))));
				                          ?> <span id="changeInsuranceCompanyList"><font
								color="red">*</font>&nbsp; <?php 
								echo $this->Form->input('Patient.insurance_company_id', array('class'=>'validate[required,custom[mandatory-select]] textBoxExpnd1','options' => $insurancecompanies, 'empty' => __('Select Insurance Company'), 'id' => 'ajaxinsurancecompanyid', 'label'=> false, 'div' => false, 'error' => false));
								?> </span> </span> </span>
					<?php 
								}

								?>
				</div> <!-- EOF insurance section -->
			</td>
			<td>&nbsp;</td>
			<td valign="top" width="49%" colspan="2" class="" id="status-remark">
				<table width="100%" cellpadding="0" cellspacing="0">
					<?php 
					$statusOpt = array( 'Received I card, referral letter'=>'Received I card, referral letter',
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
				</table>
			</td>
		</tr>
		<tr id="showwithcard" style="display: none;">
			<td width="100%" colspan="5" align="left" class="" id=" ">
				<table border="0" cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Name of the I.P.');?>
						</td>
						<td width="30%" align="left"><?php echo $this->Form->input('name_of_ip', array('class' => 'textBoxExpnd','id' => 'name_of_ip')); ?>
						</td>
						<td width="">&nbsp;</td>
						<td valign="middle" class="tdLabel" id="boxSpace" width="19%"><?php echo __('Relationship with Employee');?>
						</td>
						<td align="left" width="30%"><?php
						$relation = array('SELF'=>'Self','FAT'=>'Father','MOT'=>'Mother','BRO'=>'Brother','SIS'=>'Sister','WIFE' => 'Wife','HUSBAND'=>'Husband','SON' => 'Son', 'DAU' => 'Daughter','OTHER'=>'other');
														 echo $this->Form->input('relation_to_employee', array('empty'=>__('Please Select'),'options'=>$relation,'class' => 'textBoxExpnd','id' => 'insurance_relation_to_employee')); ?>
						</td>
					</tr>
					<tr>

						<td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Executive Employee ID No.');?>
						</td>
						<td width="30%" align="left"><?php echo $this->Form->input('executive_emp_id_no', array('class' => 'textBoxExpnd emp_id','id' => 'insurance_executive_emp_id_no')); ?>
						</td>
						<td>&nbsp;</td>
						<td class="tdLabel" id="boxSpace"><?php echo __('Non Executive Employee ID No.');?>
						</td>
						<td align="left"><?php echo $this->Form->input('non_executive_emp_id_no', array('style'=>'width:180px','class' => 'textBoxExpnd emp_id','id' => 'insurance_non_executive_emp_id_no')); ?>
							<?php echo $this->Form->input('emp_id_suffix', array('style'=>'width:60px','class' => 'textBoxExpnd emp_id','id' => 'insurance_esi_suffix', 'readonly' => 'readonly')); ?>
						</td>
					</tr>

					<tr>

						<td class="tdLabel" id="boxSpace" align="left"><?php echo __('Designation');?>
						</td>
						<td align="left"><?php echo $this->Form->input('designation', array('class' => 'textBoxExpnd','id' => 'designation')); ?>

						</td>
						<td>&nbsp;</td>
						<td class="tdLabel" id="boxSpace" align="left"><?php echo __('Company');?>
						</td>
						<td align="left"><?php echo $this->Form->input('sponsor_company', array('class' => 'textBoxExpnd','id' => 'sponsor_company')); ?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr id="showwithcardInsurance" style="display: none;">
			<td width="100%" colspan="5" align="left" class="" id=" ">
				<table border="0" cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Name of Insurance Holder');?>
						</td>
						<td width="30%" align="left"><?php echo $this->Form->input('name_of_ip', array('class' => 'textBoxExpnd','id' => 'name_of_ip')); ?>
						</td>
						<td width="">&nbsp;</td>
						<td valign="middle" class="tdLabel" id="boxSpace" width="19%"><?php echo __('Relationship with Insurance Holder');?>
						</td>
						<td align="left" width="30%"><?php
						$relation = array('SELF'=>'Self','FAT'=>'Father','MOT'=>'Mother','BRO'=>'Brother','SIS'=>'Sister','WIFE' => 'Wife','HUSBAND'=>'Husband','SON' => 'Son', 'DAU' => 'Daughter','OTHER'=>'other');
														 echo $this->Form->input('relation_to_employee', array('empty'=>__('Please Select'),'options'=>$relation,'class' => 'textBoxExpnd','id' => 'corpo_relation_to_employee')); ?>
						</td>
					</tr>
					<tr>

						<td class="tdLabel" id="boxSpace" align="left"><?php echo __('Designation');?>
						</td>
						<td align="left"><?php echo $this->Form->input('designation', array('class' => 'textBoxExpnd','id' => 'designation')); ?>

						</td>
						<td>&nbsp;</td>
						<td class="tdLabel" id="boxSpace"><?php echo __('Insurance Number');?>
						</td>
						<td align="left"><?php echo $this->Form->input('insurance_number', array('class' => 'textBoxExpnd','id' => 'insurance_number')); ?>
						</td>
					</tr>
					<tr>

						<td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Executive Employee ID No.');?>
						</td>
						<td width="30%" align="left"><?php echo $this->Form->input('executive_emp_id_no', array('class' => 'textBoxExpnd emp_id','id' => 'corpo_executive_emp_id_no')); ?>
						</td>
						<td>&nbsp;</td>
						<td class="tdLabel" id="boxSpace"><?php echo __('Non Executive Employee ID No.');?>
						</td>
						<td align="left"><?php echo $this->Form->input('non_executive_emp_id_no', array('style'=>'width:180px','class' => 'textBoxExpnd emp_id','id' => 'corpo_non_executive_emp_id_no')); ?>
							<?php echo $this->Form->input('emp_id_suffix', array('style'=>'width:60px','class' => 'textBoxExpnd emp_id','id' => 'corpo_esi_suffix', 'readonly' => 'readonly')); ?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<!-- EOF Sponsers Details -->
	<p class="ht5"></p>
	<!-- Patient Demographic record Edit start here -->
	<!- Aditya -->
	<!-- to calculate the date -->
	<?php 	
	$setdate=$getdemo[0][Person][dob];
	debug($setdate);
	$expodate = explode("-",$setdate);
	debug($getdemo);

	$str_dob=$expodate['2']."/".$expodate['1']."/".$expodate['0'];


	?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0"
		class="formFull">
		<tr>
			<th colspan="5"><?php echo __('Demographic');?></th>
		</tr>
		<tr>
			<td valign="middle" class="tdLabel" id="boxSpace">Date of Birth <font
				color="red">*</font>
			</td>
			<td><?php echo $this->Form->input('dob', array('type'=>'text','style'=>'width:136px','size'=>'20','value'=>$str_dob,'class' => 'textBoxExpnd','id' => 'dob')); ?>



			</td>
		</tr>
		<tr>
			<td valign="middle" class="tdLabel" id="boxSpace">Age <font
				color="red">*</font>
			</td>
			<td><?php echo $this->Form->input('age', array('type'=>'text','style'=>'width:80px','maxLength'=>'3','class' => 'validate[required,custom[customage]] textBoxExpnd','id' => 'age','value'=>$getdemo[0][Person][age])); ?>
				<?php  echo $this->Form->input('sex', array('readonly'=>'readonly','style'=>'width:160px','options'=>array(''=>__('Please Select Gender'),'Male'=>__('Male'),'Female'=>__('Female'),'Ambiguous'=>__('Ambiguous'),'Not applicable'=>__('Not applicable'),'Unknown'=>__('Unknown'),'Other'=>__('Other')),'class' => 'validate[required,custom[patient_gender]] textBoxExpnd','id' => 'sex','selected'=>$getdemo[0]['Person']['sex'])); ?>
				       

				<?php //echo $this->Form->input('age', array('type'=>'text','style'=>'width:40px','maxLength'=>'3','size'=>'20','class' => 'validate[required,custom[mandatory-enter],custom[onlyNumber]] textBoxExpnd','id' => 'age')); ?>
			</td>
		</tr>
		<tr>
			<?php $selected_ethnicity= $getdemo['0']['Person']['ethnicity']; 
			//debug( $getdemo);
			?>
			<td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Ethnicity');?>
			</td>
			<td width="30%"><?php echo $this->Form->input('ethnicity', array('empty'=>__('Select'),'options'=>array('Hispanic or Latino'=>'Hispanic or Latino','Not Hispanic or Latino'=>'Not Hispanic or Latino',':American'=>'American',':African'=>'African','Denied to Specific'=>'Denied to Specific'),'value'=>$selected_ethnicity,'id' => 'ethnicity','style'=>'width:150px')); ?>
			</td>
			<td width="30">&nbsp;</td>
		</tr>
		<tr>
			<td width="19%" class="tdLabel" id="boxSpace"></td>
			<td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Hold Ctrl to select multiple values'); ?>
			</td>
		</tr>
		<tr>
			<?php $selected_language = explode(",", $getdemo["0"]["Person"]["language"]); 
			?>
			<td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Preffered Language');?>
			</td>
			<td width="30%"><?php echo $this->Form->input('language', array('empty'=>__('Denied to Specific'),'options'=>$languages,'selected'=>$selected_language,'multiple'=>'true','id' => 'language','style'=>'width:230px')); ?>
			</td>
		</tr>
		<tr>
			<td width="19%" class="tdLabel" id="boxSpace"></td>
			<td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Hold Ctrl to select multiple values'); ?>
			</td>
		</tr>
		<tr>
			<td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Race(s)');?>
			</td>
			<?php $selected = explode(",", $getdemo["0"]["Person"]["race"]); 
			?>

			<td width="30%"><?php echo $this->Form->input('race', array('empty'=>__('Denied to Specific'),'selected'=>$selected,'multiple'=>'true','options'=>$race,'id' =>'race','style'=>'width:230px')); ?>
			</td>

		</tr>
	</table>
	<p class="ht5"></p>
	<!-- BOF Address Information -->
	<table width="100%" border="0" cellspacing="0" cellpadding="0"
		class="formFull">
		<tr>
			<th colspan="5"><?php echo __('Address Information');?>
			</th>
		</tr>
		<tr>
			<td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Address Line 1');?>
			</td>
			<td width="30%"><?php echo $this->Form->input('plot_no', array('class' => 'textBoxExpnd','id' => 'plot_no','value'=>$getadd['Person']['plot_no'])); ?>
			</td>
			<td width="30">&nbsp;</td>
			<td width="19%" class="tdLabel" id="boxSpace"><?php echo('Address Line 2');?>
			</td>
			<td width="30%"><?php echo $this->Form->input('landmark', array('class' => 'textBoxExpnd','id' => 'landmark','value'=>$getadd['Person']['landmark'])); ?>
			</td>
		</tr>

		<tr>
			<td class="tdLabel" id="boxSpace" valign="top"><?php echo __('Zip');?>
			</td>
			<td valign="top"><?php echo $this->Form->input('pin_code', array('class' => 'validate[optional,custom[onlyNumber]] textBoxExpnd','id' => 'pinCode','Maxlength'=>'5','value'=>$getadd['Person']['pin_code'])); ?>
			</td>
			<td>&nbsp;</td>
			<td class="tdLabel" id="boxSpace"><?php echo __('Zip 4');?>
			</td>
			<td><?php echo $this->Form->input('zip_four', array('class' =>'validate[optional,custom[onlyNumber]] textBoxExpnd','id' => 'zip_four','MaxLength'=>'4','value'=>$getadd['Person']['zip_four'])); ?>
			</td>
		</tr>
		<tr>
			<td class="tdLabel" id="boxSpace"><?php echo __('Phone No.');?>
			</td>
			<td><?php echo $this->Form->input('home_phone', array('class' => 'validate["",custom[onlyNumber]] textBoxExpnd','Maxlength'=>'10','id' => 'home_phone','value'=>$getadd['Person']['home_phone'])); ?>
			</td>
			<td>&nbsp;</td>
			<td class="tdLabel" id="boxSpace"><?php echo('Mobile No.');?>
			</td>
			<td><?php echo $this->Form->input('mobile', array('class' => 'validate["",custom[onlyNumber]] textBoxExpnd','id' => 'mobile','Maxlength'=>'10','value'=>$getadd['Person']['mobile'])); ?>
			</td>
		</tr>

		<tr>
			<td class="tdLabel" id="boxSpace"><?php echo __('Email Address');?>
			</td>
			<td><?php echo $this->Form->input('email', array('class' => 'validate["",custom[email]] textBoxExpnd','id' => 'email','value'=>$getadd['Person']['email'])); ?>
			</td>
			<td>&nbsp;</td>
			<td class="tdLabel" id="boxSpace"><?php echo __('Fax No.');?>
			</td>
			<td><?php echo $this->Form->input('fax', array('class' => 'validate["",custom[onlyNumber]] textBoxExpnd','id' => 'fax','Maxlength'=>'10','value'=>$getadd['Person']['fax'])); ?>
			</td>
		</tr>
		<tr>
			<td class="tdLabel" id="boxSpace"><?php echo __('Work No.');?>
			</td>
			<td><?php echo $this->Form->input('work', array('class' => 'validate["",custom[onlyNumber]] textBoxExpnd','Maxlength'=>'10','id' => 'work','value'=>$getadd['Person']['work'])); ?>
			</td>
			<td>&nbsp;</td>
			<?php //debug($countries);?>
			<td class="tdLabel" id="boxSpace"><?php echo __('Country');?>
			</td>
			<td><?php 
			echo $this->Form->input('country', array('options' => $countries,'value'=>$getadd['Person']['country'], 'empty' => 'Select Country', 'id' => 'customcountry', 'label'=> false, 'div' => false, 'error' => false,'onchange'=> $this->Js->request(array('controller'=>'persons','action' => 'get_state_city','reference'=>'State','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#customstate', 'data' => '{reference_id:$("#customcountry").val()}', 'dataExpression' => true, 'div'=>false))));
			?>
			</td>

		</tr>
		<tr>
			<td class="tdLabel" id="boxSpace"><?php echo __('Religion');?>
			</td>
			<td>
			<?php echo $this->Form->input('religion', array('empty'=>__('Select'),'options'=>$religion,'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'religion','value'=>$getadd['Person']['religion']));

			?>
			</td>

			<td>&nbsp;</td>


			<td class="tdLabel" id="boxSpace"><?php echo __('State',true); ?>
			</td>
			<td id="customstate"><?php echo $this->Form->input('Person.state', array('options' => $states,'value'=>$getadd['Person']['state'], 'selected'=>'selected', 'id' => 'customstate', 'label'=> false, 'div' => false, 'error' => false,'type'=>'select'));
			?>
			</td>
		</tr>
		<tr>
			<td class="tdLabel" id="boxSpace">&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td class="tdLabel" id="boxSpace"><?php echo __('City/Town');?>
			</td>
			<td><?php echo $this->Form->input('city', array('class' => 'textBoxExpnd','id' => 'city','value'=>$getadd['Person']['city'])); ?>
			</td>
		</tr>
		<tr>
		
		
		<tr>

			<td class="tdLabel" id="boxSpace"><?php echo __('Nationality');?>
			</td>
			<td><?php echo $this->Form->input('nationality', array('class' => 'textBoxExpnd','id' => 'nationality','Value'=>'Indian')); ?>
			</td>
		</tr>
	</table>
	<!-- EOF Address Information -->



	<!-- ------End of the Demograghic code------------------- -->
	<!-- Links to Records end here -->


	<p class="ht5"></p>
	<!-- Links to Records start here -->
	<table width="100%" border="0" cellspacing="0" cellpadding="0"
		class="formFull">
		<tr>
			<th colspan="5">Links to Records</th>
		</tr>
		<tr>
			<td width="19%" class="tdLabel" id="boxSpace">Case summary Link</td>
			<td width="81%"><?php echo $this->Form->input('case_summery_link', array('class' => 'textBoxExpnd','id' => 'caseSummeryLink')); ?>
			</td>

		</tr>
		<tr>
			<td class="tdLabel" id="boxSpace">Patient File</td>
			<td><?php echo $this->Form->input('patient_file', array('class' => 'textBoxExpnd','id' => 'patientFile')); ?>
			</td>

		</tr>
		<!-- 
                      <tr>
                        <td class="tdLabel" id="boxSpace">Consent Form</td>
                        <td><?php echo $this->Form->input('consent_form', array('class' => 'textBoxExpnd','id' => 'consentForm')); ?></td>
                        <td>&nbsp;</td>
                        <td class="tdLabel">&nbsp;</td>
                        <td>&nbsp;</td>
                     </tr>
                      -->
	</table>
	<!-- Links to Records end here -->
	<!-- BOF Advance -->
	<?php if($this->data['Patient']['admission_type'] != "OPD"){ ?>
	<p class="ht5"></p>

	<!-- Links to Records start here -->
	<table width="100%" border="0" cellspacing="0" cellpadding="0"
		class="formFull">
		<tr>
			<th colspan="5">Advance</th>
		</tr>
		<tr>
			<td width="19%" class="tdLabel" id="boxSpace">Against</td>
			<td width="30%"><?php 
			//echo $this->Form->hidden('Billing.id', array('value'=>$this->data['Billing']['id']));
			echo $this->Form->input('Billing.against', array('options'=>$against,'id'=>'against','class' => 'textBoxExpnd','type'=>'select','disabled'=>'disabled'));
			?>
			</td>
			<td width="30">&nbsp;</td>
			<td width="19%" class="tdLabel" id="boxSpace">Standard Amount:</td>
			<td width="30%"><?php echo $this->Form->input('', array('id'=>"standardAgainst",'options'=>$standardAgainst,'class' => 'textBoxExpnd','type'=>'select','disabled'=>'disabled')); ?>
			</td>
		</tr>
		<tr>
			<td class="tdLabel" id="boxSpace">Collected</td>
			<td width="30%"><?php echo $this->Form->input('Billing.amount', array('class' => 'textBoxExpnd','type'=>'text','error'=>false,'label'=>false,'disabled'=>'disabled')); ?>
			</td>
			<td width="30">&nbsp;</td>
			<td width="19%" class="tdLabel" id="boxSpace">&nbsp;</td>
			<td width="30%">&nbsp;</td>
		</tr>
		<tr>
			<td class="tdLabel" id="boxSpace">Mode Of Payment</td>
			<td width="30%"><?php echo $this->Form->input('Billing.mode_of_payment', array("class"=>"textBoxExpnd",'div' => false,'label' => false,'empty'=>__('Please select'),
					   								'options'=>array('Cash'=>'Cash','Cheque'=>'Cheque','Credit Card'=>'Credit Card'),'id' => 'mode_of_payment','autocomplete'=>'off','disabled'=>'disabled')); ?>
			</td>
		</tr>
		<tr>
			<td class="tdLabel" id="boxSpace" colspan="5">
				<table width="100%" id="paymentInfo" style="display: none">
					<tr>
						<td class="tdLabel" id="boxSpace">Bank Name</td>
						<td width="30%"><?php echo $this->Form->input('Billing.bank_name',array('class'=>'textBoxExpnd','type'=>'text','legend'=>false,'label'=>false,'id' => 'account_number'));?>
						</td>
						<td width="30">&nbsp;</td>
						<td width="19%">&nbsp;</td>
						<td width="30%">&nbsp;</td>
					</tr>
					<tr>
						<td class="tdLabel" id="boxSpace">Account No.</td>
						<td width="30%"><?php echo $this->Form->input('Billing.account_number',array('class'=>'textBoxExpnd','type'=>'text','legend'=>false,'label'=>false,'id' => 'account_number'));?>
						</td>
						<td width="30">&nbsp;</td>
						<td width="19%">&nbsp;</td>
						<td width="30%">&nbsp;</td>
					</tr>
					<tr>
						<td class="tdLabel" id="boxSpace">Cheque/Credit Card No.</td>
						<td width="30%"><?php echo $this->Form->input('Billing.check_credit_card_number',array('class'=>'textBoxExpnd','type'=>'text','legend'=>false,'label'=>false,'id' => 'card_check_number'));?>
						</td>
						<td width="30">&nbsp;</td>
						<td width="19%">&nbsp;</td>
						<td width="30%">&nbsp;</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<!-- EOF Advance -->
	<?php } ?>
	<p class="ht5"></p>

	<!-- Patient clinical record start here -->
	<table width="100%" border="0" cellspacing="0" cellpadding="0"
		class="formFull">
		<tr>
			<th colspan="5">Performance Indicator</th>
		</tr>


		<!--  <tr>
                      	 <td width="19%" valign="top" class="tdLabel" id="boxSpace" style="padding-top:10px;">Allergies</td>
                         <td width="30%"><?php echo $this->Form->textarea('allergies', array('class' => 'textBoxExpnd','id' => 'allergies','row'=>'3')); ?></td>
                         <td width="30">&nbsp;</td>
                        <td width="19%" valign="top" class="tdLabel" id="boxSpace" style="padding-top:10px;">On Examination</td>
                        <td width="" valign="top"><?php echo $this->Form->textarea('examination', array('class' => 'textBoxExpnd','id' => 'examination','row'=>'3')); ?>
                        </td>
                      </tr>
                      
                      
                      <tr>
                        <td valign="top" class="tdLabel" id="boxSpace" style="padding-top:10px;">Treatment in Hospital</td>
                        <td><?php echo $this->Form->textarea('treatment', array('row'=>'3','class' => 'textBoxExpnd','id' => 'treatment')); ?></td>
                        <td>&nbsp;</td>
                        <td valign="top" class="tdLabel" id="boxSpace" style="padding-top:10px;">Drug lookup</td>
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
                        <td valign="top" class="tdLabel" id="boxSpace"  style="padding-top:10px;">OT</td>
                        <td valign="top"><?php echo $this->Form->input('OT', array('class' => 'textBoxExpnd','id' => 'OT')); ?></td>
                        <td>&nbsp;</td>
                        <td valign="top" class="tdLabel" id="boxSpace" style="padding-top:10px;"> Review on </td>
                        <td><table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                              <td><?php echo $this->Form->input('review_on', array('class' => 'textBoxExpnd','style'=>'width:85%;','id' => 'reviewOn','readonly'=>'readonly','type'=>'text')); ?></td>
                            </tr>                  
                        </table></td>
                      </tr> -->
		<tr>
			<td class="tdLabel" id="boxSpace"><?php echo __('Form Received by Patient', true); ?><font
				color="red">*</font></td>
			<td><?php echo $this->Form->input('doc_ini_assessment', array('type'=>'checkbox','id' => 'docIniAssessment','value'=>1)); ?>
				<?php echo $this->Form->input('form_received_on', array('class' => 'validate[required,custom[mandatory-date]] textBoxExpnd','style'=>'width:76%;','id' => 'formReceivedOn','readonly'=>'readonly','type'=>'text')); ?>
			</td>
			<td>&nbsp;</td>
			<td valign="top" class="tdLabel" id="boxSpace"><?php echo __('Registration Completed by Patient', true); ?><font
				color="red">*</font></td>
			<td valign="top"><?php echo $this->Form->input('nurse_assessment', array('type'=>'checkbox','id' => 'nurseAssessment','value'=>1)); ?>
				<?php echo $this->Form->input('form_completed_on', array('class' => 'textBoxExpnd validate[required,custom[mandatory-date]]', 'style'=>'width:75%;','id' => 'formCompletedOn','type'=>'text')); ?>
			</td>
		</tr>
		<tr>
			<td valign="top" class="tdLabel" id="boxSpace"
				style="padding-top: 10px;">Start of Assessment by Doctor</td>
			<td><?php echo $this->Form->input('doc_ini_assess_on', array('class' => 'textBoxExpnd','style'=>'width:85%;','id' => 'docIniAssessOn','readonly'=>'readonly','type'=>'text')); ?>
			</td>
			<td>&nbsp;</td>
			<td valign="top" class="tdLabel" id="boxSpace"
				style="padding-top: 10px;">End of Assessment by Doctor</td>
			<td><?php echo $this->Form->input('doc_ini_assess_end_on', array('class' => 'textBoxExpnd','style'=>'width:85%;','id' => 'docIniAssessEndOn','readonly'=>'readonly','type'=>'text')); ?>
			</td>
		</tr>
		<tr>
			<td valign="top" class="tdLabel" id="boxSpace"
				style="padding-top: 10px;">Start of Nursing Assessment</td>
			<td><?php echo $this->Form->input('nurse_assess_on', array('class' => 'textBoxExpnd','style'=>'width:85%;','id' => 'nurseAssessmentOn','readonly'=>'readonly','type'=>'text')); ?>
			</td>
			<td>&nbsp;</td>
			<td valign="top" class="tdLabel" id="boxSpace"
				style="padding-top: 10px;">End of Nursing Assessment</td>
			<td><?php echo $this->Form->input('nurse_assess_end_on', array('class' => 'textBoxExpnd','style'=>'width:85%;','id' => 'nurseAssessmentEndOn','readonly'=>'readonly','type'=>'text')); ?>
			</td>
		</tr>
		<tr>
			<td valign="top" class="tdLabel" id="boxSpace"
				style="padding-top: 10px;">Start of Nutritional Assessment</td>
			<td><?php echo $this->Form->input('nutritional_assess_on', array('class' => 'textBoxExpnd','style'=>'width:85%;','id' => 'nutritionalAssessOn','readonly'=>'readonly','type'=>'text')); ?>
			</td>
			<td>&nbsp;</td>
			<td valign="top" class="tdLabel" id="boxSpace"
				style="padding-top: 10px;">End of Nutritional Assessment</td>
			<td><?php echo $this->Form->input('nutritional_assess_end_on', array('class' => 'textBoxExpnd','style'=>'width:85%;','id' => 'nutritionalAssessEndOn','readonly'=>'readonly','type'=>'text')); ?>
			</td>
		</tr>
	</table>
	<!--                        
                     <p class="ht5"></p>                     
                      
                     <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
                   	  <tr>
                      	<th colspan="5">Discharge Information</th>
                      </tr>
                      <tr>
                        <td width="19%" valign="top" class="tdLabel" id="boxSpace"  style="padding-top:10px;">Discharge Intimation done</td>
                        <td width="30%" valign="top"  style="padding-top:10px;"><?php echo $this->Form->checkbox('discharge_intimation', array('class' => 'textBoxExpnd','id' => 'dischargeIntimation','value'=>1)); ?></td>
                        <td>&nbsp;</td>
                        <td width="19%" valign="top" class="tdLabel" id="boxSpace" style="padding-top:10px;">Discharge Time intimation Date &amp; Time</td>
                        <td width="30%"><table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                              <td><?php echo $this->Form->input('discharge_intimation_on', array('class' => 'textBoxExpnd','style'=>'width:85%;','id' => 'dischargeIntimationOn','readonly'=>'readonly','type'=>'text')); ?></td>
                            </tr>                           
                        </table></td>
                      </tr>
                     <tr>
                       <td valign="top" class="tdLabel" id="boxSpace"> Full and Final intimation done </td>
                        <td valign="top"><?php echo $this->Form->checkbox('final_intimation', array('class' => 'textBoxExpnd','id' => 'fullIntimation','value'=>1)); ?></td>
                        <td>&nbsp;</td>
                        <td valign="top" class="tdLabel" id="boxSpace">Full &amp; Final discharge Date &amp; Time</td>
                        <td width="30%"><table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                              <td><?php echo $this->Form->input('final_intimation_on', array('class' => 'textBoxExpnd','style'=>'width:85%;','id' => 'fullIntimationOn','readonly'=>'readonly','type'=>'text')); ?></td>
                            </tr>                            
                        </table></td>
					</tr>
                     <tr>
                       <td valign="middle" class="tdLabel" id="boxSpace">Discharge Discription</td>
                        <td valign="top"><?php echo $this->Form->textarea('discharge_desc', array('class' => 'textBoxExpnd','id' => 'dischargeDesc','row'=>'3')); ?></td>
                        <td>&nbsp;</td>
                        <td valign="top" class="tdLabel" id="boxSpace">&nbsp;</td>
                       <td valign="top">&nbsp;</td>
                     </tr>
                    </table>
                                       
                    <p class="ht5"></p>                    
                     
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
                   	  <tr>
                      	<th colspan="5">InvActivity Information</th>
                      </tr>
                      <tr>
                        <td width="19%" valign="top" class="tdLabel" id="boxSpace" style="padding-top:10px;">Description</td>
                        <td width="30%"><?php echo $this->Form->textarea('inv_activity_desc', array('class' => 'textBoxExpnd','id' => 'invActivityDesc','row'=>3)); ?></td>
                        <td width="">&nbsp;</td>
                        
                      </tr>
                      <tr>
                        <td valign="top" class="tdLabel" id="boxSpace">Invoice settled</td>
                        <td valign="top"><?php echo $this->Form->checkbox('invoice_settled', array('class' => 'textBoxExpnd','id' => 'invoiceSettled','value'=>1)); ?></td>
                        <td>&nbsp;</td>
                        <td valign="top" class="tdLabel" id="boxSpace" style="padding-top:10px;">&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                     <tr>
                       <td valign="middle" class="tdLabel" id="boxSpace"> Advance Paid </td>
                       <td><?php echo $this->Form->input('advance_paid', array('class' => 'textBoxExpnd','id' => 'advancedPaid')); ?></td>
                       <td>&nbsp;</td>
                       <td class="tdLabel" id="boxSpace">&nbsp;</td>
                       <td>&nbsp;</td>
                     </tr>
                    </table> -->
	<!-- InvActivity Information end here -->

	<!-- form end here -->
	<div class="btns">
		<input class="grayBtn" type="button" value="Cancel"
			onclick="window.location='<?php echo $this->Html->url(array("controller" => $this->params['controller'], "action" => "patient_information",$this->data['Patient']['id']));?>'">
		<input class="blueBtn" type="submit"
			value="<?php echo $buttonLabel ; ?>" id='submit_btn1'>
		<?php 
		if($extraButton){
					             echo $this->Form->submit($extraButton,array('type'=>'submit','class'=>'blueBtn','div'=>false,'error'=>false,'id'=>'extra2'));
							   }
							   ?>

	</div>
	<?php //EOF new form design ?>
</div>
<?php echo $this->Form->end(); ?>


<script>
	jQuery(document).ready(function(){
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
	            $("#department_id").attr("disabled","");
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


		   
		   $('#doctor_id').change(function(){
			    $.ajax({
			      url: "<?php echo $this->Html->url(array("controller" => 'patients', "action" => "getDoctorsDept", "admin" => false)); ?>"+"/"+$(this).val(),
			      context: document.body,          
			      success: function(data){ 
			     $('#department_id').val(data); 
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
			dateFormat:'<?php echo $this->General->GeneralDate();?>'
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
			dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>'
		});
		$( "#nurseAssessmentOn" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',			 
			dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>'
		});
		$( "#nutritionalAssessOn" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',			 
			dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>'
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
			dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>'
		});
		$( "#nurseAssessmentEndOn" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',			 
			dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>'
		});
		$( "#nutritionalAssessEndOn" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',			 
			dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>'
		});
		$( "#formReceivedOn" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',			 
			dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
                        maxDate: new Date(),
		});
                $( "#formCompletedOn" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',			 
			dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
                        maxDate: new Date(),
		});
                // form received by patient date if check true
		$( "#docIniAssessment" ).click(function(){
			if($( "#docIniAssessment" ).is(':checked') == true) {
                          var currentdate = new Date();
                          var showdate = currentdate.getDate()+"/"+(currentdate.getMonth()+1)+"/"+currentdate.getFullYear()+" "+currentdate.getHours()+":"+currentdate.getMinutes();
                          $( "#formReceivedOn" ).val(showdate);
                        } else {
                          $( "#formReceivedOn" ).val('');
                        }
		}); 
                // form completed by patient date if check true
		$( "#nurseAssessment" ).click(function(){
			if($( "#nurseAssessment" ).is(':checked') == true) {
                          var currentdate = new Date();
                          var showdate = currentdate.getDate()+"/"+(currentdate.getMonth()+1)+"/"+currentdate.getFullYear()+" "+currentdate.getHours()+":"+currentdate.getMinutes();
                       $("#formCompletedOn" ).val(showdate);
                        } else {
                          $( "#formCompletedOn" ).val('');
                        }
		});
		//BOF card block
		
			$('#paymentType').change(function(){
					if($(this).val()=='cash'){
						$('#remark').attr('disabled',true);
						$('#sponsersAuthOpt').fadeOut();
						$('#status-remark').fadeOut('slow');
						$('#sponsersAuth').fadeIn(); 	
						$('#sponsersAuth').attr('disabled',true);
						
					}else{
						$('#sponsersAuth').fadeOut();
						$('#sponsersAuthOpt').fadeIn();
						$('#status-remark').fadeIn('slow'); 
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
         
	      $('#paymentCategoryId').live('change',function(){
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
			 if($('#paymentType').val() == "cash") {
			    	$('#showwithcard').hide();
		            $('#showwithcardInsurance').hide();
		     }
		 });
		
		//fnction to disable one option
		$('.emp_id').live('keyup change',function(){
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
		$( "#dob" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '-50:+50',
			maxDate: new Date(),
			dateFormat:'<?php echo $this->General->GeneralDate();?>',
		});
                  $( "body" ).click(function() {
                             var dateofbirth = $( "#dob" ).val();
			 if(dateofbirth !="") {
                 var currentdate = new Date();
                 var splitBirthDate = dateofbirth.split("/");
                 var caldateofbirth = new Date(splitBirthDate[2]+"/"+splitBirthDate[1]+"/"+splitBirthDate[0]);
                 var caldiff = currentdate.getTime() - caldateofbirth.getTime();                      
                 var calage =  Math.floor(caldiff / (1000 * 60 * 60 * 24 * 365.25));
                 $("#age" ).val(calage);
             }
                            
		});
                  $("#dobg")
					.datepicker(
							{
								showOn : "button",
								buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
								buttonImageOnly : true,
								changeMonth : true,
								changeYear : true,
								yearRange : '-50:+50',
								maxDate : new Date(),
								dateFormat:'<?php echo $this->General->GeneralDate();?>',
							});
 
</script>
