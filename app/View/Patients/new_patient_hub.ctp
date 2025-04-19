<!DOCTYPE html>
<!-- Website template by freewebsitetemplates.com -->
  
<html>
<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

<?php echo $this->Html->css(array('patient_hub css','jquery.fancybox-1.3.4.css'));
echo $this->Html->script(array('jquery.fancybox-1.3.4'));
//debug($patient);
?>

<style>
#readMoreLink {
    color: blue;
    text-decoration: underline;
    cursor: pointer;
}

.body div div div div {
    float: right;
    width: 480px;
}
select.textBoxExpnd1 {
	width: 66%;
	margin-top: 5px;
}
/*select.textBoxExpnd{ width:70%;}*/
label {
	color: #000 !important;
	float: left;
	font-size: 13px;
	margin-right: 10px;
	padding-top: 3px;
	text-align: right;
	width: 25px;
}

img {
	border: 0 none;
	cursor: pointer;
	/*float: right;*/
}

.body div div.about h4,.body div div.classes h4 {
	color: #454545;
	text-transform: uppercase;
	/*font-family:QuicksandRegular;*/
	font-size: 14px;
	font-weight: 700;
	margin: 5px 0 0;
	padding: 0 20px;
}
</style>
</head>
<?php //echo $this->element('hub_patient_id');?>
<body>
	<div class="inner_title">
		<h3>
			<?php 
			 if(!empty($patient['Patient']['lookup_name'])){
			 	echo __('Patient Hub - '.$patient['Patient']['lookup_name'].' ('.$patient['Patient']['patient_id'].' -'.$patient['TariffStandard']['name'].')', true); 
			 }else{
			 	echo __('Patient Hub');
			 }
			 ?>
		</h3>
        <span style="width:450px;">
            <?php
                echo $this->Html->link('Patient Overview' , array('controller' => 'Persons', 'action' => 'patient_overview'), array('escape' => false, 'class' => 'blueBtn'));
            ?> 
        </span>
        
		<span><?php
		echo $this->Form->input('search_feild',array('id'=>'addmissionId','div'=>false,'label'=>false));
	 echo $this->Html->link('Add New Patient',array('controller'=>'Persons','action'=>'searchPerson'),array('escape'=>false,'class'=>'blueBtn'));
	 ?> </span>

	</div>
	<div class="clr ht5"></div>
	<?php if($patient){?>
	<div class="page">
		<div class="background">
			<div class="sidebar">
				<a id="logo"> <?php //photo
				 $photo=$patient['Person']['photo'];
				 if(file_exists(WWW_ROOT."/uploads/patient_images/thumbnail/".$photo) && !empty($photo)){
						echo $this->Html->image("/uploads/patient_images/thumbnail/".$photo);
				 }else if(strtolower($patient['Person']['sex'])=='male'){
						echo $this->Html->image('icons/male-thumb.gif');
				 }else{
						echo $this->Html->image('icons/female-thumb.gif');
				 }
				?>
				</a>
				<?php echo $this->Form->create('hub',array('type'=>'file'));
						  echo $this->Form->input('photo',array('type'=>'file','div'=>false,'label'=>false,'style'=>'width:150px'));?>
				<div style="text-align: left; padding: 2px">
					<?php echo $this->Form->button('Upload',array('type'=>'submit','div'=>false,'label'=>false,'class'=>'blueBtn'));
					echo $this->Form->hidden('prev_photo',array('value'=>$photo));
					echo $this->Form->end();?>
				</div>
				<ul class="navigation">
					<li class="selected"><a
						href="<?php echo $this->Html->url(array('action'=>'new_patient_hub',$patient['Patient']['id'],$patient['Person']['id']))?>">
							Personal Details </a>
					</li>
					<?php if($patient['Patient']['admission_type']=='IPD'){?>
					<li><a href="javascript:void(0)" id="wardDetails">Ward Details</a>
					</li>
					<?php }?>
					<li><a
						href="<?php echo $this->Html->url(array('controller'=>'Billings','action'=>'multiplePaymentModeIpd',$patient['Patient']['id']))?>">Billing
							Details</a>
					</li>
					<!-- <li><a href="javascript:void(0)">Future Appointment</a></li> -->
					<li><a href="javascript:void(0)" id="labDetails">Lab/Rad Details</a>
					</li>
					<?php if($patient['Patient']['admission_type']=='IPD'){ //Billings/discharge_summary/18053#patientnotesfrm?>
					<li><?php /*echo $this->Html->url(array('controller'=>'NewOptAppointments','action'=>'patientOtAppointments',
										$patient['Patient']['id']));*/?>
						<a href="javascript:void(0)" id="optDetails"> OT Appointments</a>
					</li>
					
					
					<li><a
						href="<?php echo $this->Html->url(array('controller'=>'Billings','action'=>'discharge_summary',
																	   $patient['Patient']['id']));?>"> Discharge Summary</a>
					</li>
					<li><a
						href="<?php echo $this->Html->url(array('controller'=>'Notes','action'=>'addNurseMedication',
																	   $patient['Patient']['id'],'?'=>array('from'=>'Nurse')));?>">Add
							Priscription</a></li>
					<li><a
						href="<?php echo $this->Html->url(array('controller'=>'Billings','action'=>'addNurseServices',
																	   $patient['Patient']['id']));?>">Add Service</a></li>
					<!-- <li><a href="<?php echo $this->Html->url(array('controller'=>'Billings','action'=>'dama',
																	   $patient['Patient']['id']));?>">DAMA</a></li>
							<li><a href="<?php echo $this->Html->url(array('controller'=>'Billings','action'=>'death_certificate',
																	   $patient['Patient']['id']));?>">Death</a></li>							
							<li><a href="<?php echo $this->Html->url(array('controller'=>'PatientDocuments','action'=>'add',
																	   $patient['Patient']['id'],'null','ipdDashboard'));?>">Patient Document</a></li>
							<li><a href="javascript:void(0)">Birth Form</a></li>
							<li><a href="javascript:void(0)">View previous SOAP </a></li> -->
					<li><?php 
					echo $this->Html->link('Wrist Band',
									'#',
									array('escape' => false,'class'=>'band','onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'Patients','action'=>'wrist_band',$patient['Patient']['id']))."', '_blank',
										           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=800,left=400,top=300,height=300');  return false;"));
							?>
					</li>
					<li><?php 
					echo $this->Html->link('Provosional Invoice',
									'#',
									array('escape' => false,'class'=>'pInvoice','onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'Billings','action'=>'printReceipt',$patient['Patient']['id']))."', '_blank',
										           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=800,left=400,top=300,height=500');  return false;"));
							?>
					</li>
					<li><?php 
					echo $this->Html->link('Detailed Invoice',
									'#',
									array('escape' => false,'class'=>'dInvoice','onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'Billings','action'=>'detail_payment',$patient['Patient']['id']))."', '_blank',
										           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=800,left=400,top=300,height=500');  return false;"));
							?>
					</li>
					<?php }else{?>
					<li><?php echo $this->Html->link('Print Sheet','#',array('escape'=>false,'class'=>
							'printsheet','onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'Patients','action'=>'opd_print_sheet',
										$patient['Patient']['id'],$patient['Patient']['doctor_id']))."', '_blank',
							'toolbar=0,scrollbars=1,location=0,status1,menubar=0,resizable=1,width=600,left=400,top=300,height=300');  return false;"));
					?>
					</li>
					<li><a
						href="<?php echo $this->Html->url(array('controller'=>'Patients','action'=>'add',
								'?'=>array('type'=>'IPD','is_opd'=>'1',
								'patient_id'=>$patient['Patient']['id'],
								'apptId'=>$apptId)));?>"> Admit to Hospital </a>
					</li>
					<li><?php 
					echo $this->Html->link('Reciepts','javascript:void(0)',array('escape' => false,'class'=>'opdReciept'));
							?>
					</li>
					<?php }?>
					<!--<li>-->
					<?php 
				// 	echo $this->Html->link('Qr Code','#',
								// array('escape' => false,'class'=>'qrcode','onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'Persons','action'=>'qr_card',$patient['Person']['id']))."', '_blank',
									           //'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=600,left=400,top=300,height=300');  return false;"));
				// 	?>
					<!--</li>-->
						<li><a
						href="<?php echo $this->Html->url(array('controller'=>'Radiologies','action'=>'getRgjayPackagePatientResult',$patient['Patient']['id']
																	  ));?>">Patient Document
						</a></li>
						<!--<li><a onclick="downloadQRCode()">-->
					<!--<button >-->
					    <!--Emergency QR Code-->
					    <!--</button>-->
						<!--</a></li>-->
						<!--by ashwin -->
						
				</ul>
			</div>
			<div class="body">
				<div>
					<?php //debug($patient);?>
					<div class="about">
						<span class="tag" style="clear: both;"><b></b> </span>
						<div id="content">
							<h3 style="border-bottom: solid 4px #20B2AA">Personal Details</h3>
							<h4>
								Personal Info
								<div style="padding-right: 58%">
									<?php //if(!$patient['Patient']['is_discharge']){
					echo $this->Html->link($this->Html->image('icons/edit-icon.png'),'javascript:void(0)',array('escape'=>false,'id'=>'edit','float'=>'center'));
					echo $this->Html->link($this->Html->image('icons/view-icon.png'),'javascript:void(0)',array('escape'=>false,'style'=>'display:none','id'=>'cancel_edit','float'=>'center'));
								  //}?>
								</div>
							</h4>
							<table class="infoDiv view" cellpadding="0" cellspacing="0">
								<tr class="tdBold">
									<td width="15%">Patient UID:</td>
									<td width="25%"><?php echo $patient['Patient']['patient_id'];?>
										</b></td>
									<td width="15%">Doctor:</td>
									<td width="25%"><?php 
									echo ucfirst($patient['User']['first_name']).' '.ucfirst($patient['User']['last_name']);
									?>
								
								</tr>
								<tr class="tdBold">
									<td>Admission Date:</td>
									<td><?php echo $this->DateFormat->formatDate2Local($patient['Patient']['form_received_on'],Configure::read('date_format'),true);?>
									</td>
									</td>
									<td>Admission type:</td>
									<td><?php echo $patient['Patient']['admission_type'];?>
									</td>
								</tr>
								<tr>
									<td>Patient Name:</td>
									<td><?php echo $patient['Patient']['lookup_name'];?></td>
									<td>Age/Sex :</td>
									<td><?php 
									echo $age.'/'.ucfirst($patient['Person']['sex']);
									?>
									</td>
								</tr>
								<tr>
									<td>Patient Tariff:</td>
									<td><?php 
									echo ucfirst(trim($patient['TariffStandard']['name']))?>
									</td>
									<td>Mobile No:</td>
									
									<td><?php echo $getPatientDetails['Person']['mobile'];?></td>
									<td><?php //echo isset($patient['Patient']['mobile_phone'])?$patient['Patient']['mobile_phone']:$patient['Person']['mobile'];?>
									</td>
								</tr>
								<tr>
									<td>Blood Group :</td>
									<td><?php echo $blood_group;?></td>
									<td>Address:</td>
									<td><?php echo $formatted_address ;?><?php 
									/*$add= ucfirst(trim($patient['Person']['plot_no']));
									if($patient['Person']['city'])
										$add.=', '.ucfirst($patient['Person']['city']);
									if($patientstatename)
										$add.=', '.ucfirst($patientstatename);
									echo $add;*/
									?>
									</td>

								</tr>
								<tr>
									<td>Emergency Contact Name</td>
									<td><?php echo $getPatientDetails['Person']['next_of_kin_name'];?></td>
									<td>Emergency Contact Number</td>
									<td><?php echo $getPatientDetails['Person']['next_of_kin_mobile'];?>
									</td>

								</tr>
									<tr>
									<td>Second Emergency Contact Name</td>
									<td><?php echo $getPatientDetails['Person']['second_next_of_kin_name'];?></td>
									<td>Second Emergency Contact Number</td>
									<td><?php echo $getPatientDetails['Person']['second_next_of_kin_mobile'];?>
									</td>

								</tr>
								<tr>
									<td>Allergy :</td>
									<td><?php echo $getPatientDetails['Person']['allergy'];?></td>
									<td>Diagnosis :</td>
									<td><?php echo $getPatientDetails['DischargeSummary']['final_diagnosis']?$getPatientDetails['DischargeSummary']['final_diagnosis']:$getPatientDetails['Person']['diagnosis'];?>
									</td>
								</tr>
								
								
									<tr>
									<td>Address Line </td>
									<td><?php echo $getPatientDetails['Person']['plot_no'];?></td>
									<td>Residential Address </td>
									<td><?php echo $getPatientDetails['Person']['landmark'];?>
									</td>

								</tr>
									<tr>
									<td>Chronic Conditions</td>
									<td><?php echo $getPatientDetails['Person']['chronic_conditions'];?></td>
									<td>Email ID</td>
									<td><?php echo $getPatientDetails['Person']['email'];?>
									</td>

								</tr>
									<tr>
									<td>Current Medication</td>
									<td><?php echo $getPatientDetails['Person']['current_medication'];?></td>
									<td>Known Medical Condition</td>
									<td><?php echo $getPatientDetails['Person']['known_medical_conditions'];?>
									</td>

								</tr>
									<tr>
									<td>Consent to Share Medical Information:</td>
									<td><?php echo $getPatientDetails['Person']['share_info'];?></td>
									<td>Insurance Informaton:</td>
									<td><?php echo $getPatientDetails['Person']['insurance_information'];?>
									</td>

								</tr>
									
									
									<tr>
									<td>Preferred Hospital:</td>
									<td><?php echo $getPatientDetails['Person']['preferred_hospital'];?></td>
									<td>Language Preference: </td>
									<td><?php echo $getPatientDetails['Person']['language_preference'];?></td>

								</tr>
									<tr>
									<td>Organ Donor Status:</td>
									<td><?php echo $getPatientDetails['Person']['dnr'];?></td>
									<td style="display:none">Do Not Resuscitate (DNR) Order:</td>
									<td><?php echo $getPatientDetails['Person']['organ_donor'];?>
									</td>

								</tr>
								
									<tr>
									<td>Registration Date</td>
									<td><?php echo $getPatientDetails['Person']['form_received_on'];?></td>
									<!--<td>Upload ID Proof</td>-->
									<!--<td><?php echo $getPatientDetails['Person']['next_of_kin_mobile'];?>-->
									<!--</td>-->

								</tr>
									
								
							</table>
							<!-- Hidden Section For Editing Patient Info -->
							<?php echo $this->Form->create('editInfo',array('id'=>'editInfo'))?>
							<table class="editDiv" cellpadding="0" cellspacing="0">
								<tr class="tdBold">
									<td width="20%">Admission Date:</td>
									<td width="15%"><?php echo $this->DateFormat->formatDate2Local($patient['Patient']['form_received_on'],
											Configure::read('date_format'),true);?></td>
									<td width="15%">Adm type:</td>
									<td width="50%"><?php echo $patient['Patient']['admission_type'];?>
									</td>
								</tr>
								<tr>
									<td>First Name:<font color="red">*</font>
									</td>
									<td><?php  echo $this->Form->input('first_name',array('value'=>$patient['Person']['first_name'],
											'style'=>'width:115px','type'=>'text','class'=>'validate[required,custom[mandatory-enter]]',
											'div'=>false,'label'=>false));?></td>
									<td>Last Name:<font color="red">*</font>
									</td>
									<td><?php echo $this->Form->input('last_name',array('value'=>$patient['Person']['last_name'],
											'style'=>'width:115px','type'=>'text','class'=>'validate[required,custom[mandatory-enter]]',
											'div'=>false,'label'=>false));?>
									</td>
								</tr>
								<tr>
									<td>Middle Name:</td>
									<td><?php echo $this->Form->input('middle_name',array('value'=>$patient['Person']['middle_name'],
											'style'=>'width:115px','type'=>'text',
											'div'=>false,'label'=>false));?>
									</td>
									<td><?php echo __('Date of Birth');?><font color="red">*</font>
									</td>
									<td><?php 
									$date1 = new DateTime($patient['Person']['dob']);
									$date2 = new DateTime();
									$interval = $date1->diff($date2);
									$age_year= $interval->y;
									$age_month = $interval->m;
									$age_day= $interval->d;

									$dob=$this->DateFormat->formatDate2Local($patient['Person']['dob'],Configure::read('date_format'),false);
									echo $this->Form->input('Person.age_year', array('value'=>$age_year,'div'=>false,'type'=>'text','style'=>'width:23px;float:left;','maxLength'=>'3','placeHolder'=>'  Y',
													'size'=>'20','class' => 'validate[required,custom[mandatory-enter],custom[onlyNumber]] ','id' => 'age','label'=>false));
											echo $this->Form->input('Person.age_month', array('value'=>$age_month,'div'=>false,'type'=>'text','style'=>'width:23px;float:left;','maxLength'=>'2','placeHolder'=>'  M',
													'size'=>'20','class' => 'validate[required,custom[mandatory-enter],custom[onlyNumber]] ','id' => 'ageMonth','label'=>false));
											echo $this->Form->input('Person.age_day', array('value'=>$age_day,'div'=>false,'type'=>'text','style'=>'width:23px;float:left;','maxLength'=>'2','placeHolder'=>'  D',
													'size'=>'20','class' => 'validate[required,custom[mandatory-enter],custom[onlyNumber]] ','id' => 'ageDay','label'=>false));
		                                    echo $this->Form->input('dob', array('label'=>'DOB','type'=>'text','style'=>'width:126px;float:left;',
													'readonly'=>'readonly','value'=>$dob,'size'=>'20','div'=>false,
													'class' => 'validate[optional,custom[mandatory-select]]','id' => 'dob'));
										?>
									</td>
								</tr>
								<tr>
									<td>Blood Group :</td>
									<td><?php  echo $this->Form->input('blood_group',array(
											'type'=>'select',
											'options'=>Configure::read('blood_group'),
											'empty'=>'Please Select',
											'value'=>$blood_group,
											'style'=>'width:115px',
											'div'=>false,'label'=>false));?></td>

									<td>Mobile No :</td>
									
								<td><?php echo $getPatientDetails['Person']['mobile'];?></td>	
								<!--  	<td><?php $mobile=isset($patient['Patient']['mobile_phone'])?$patient['Patient']['mobile_phone']:$patient['Person']['mobile'];
									echo $this->Form->input('mobile_no', array('label'=>false,'type'=>'text','div'=>false,'value'=>$mobile,
													'class' => 'validate[optional,custom[phone,minSize[10]]]  onlyNumber',
													'maxlength'=>'10','id' => 'phone_number','autocomplete'=>"off"));?>
									</td>-->
								</tr>
								<tr>
									<td>Address:</td>
									
									<td> <?php echo $formatted_address ;?> </td>
									
									<!--   <td><?php echo $this->Form->input('plot_no',array('id'=>'address','type'=>'textarea',
											'style'=>'height:29px;width:149px',
											'value'=>trim($patient['Person']['plot_no']),'div'=>false,'label'=>false));?>
										<?php 
										$add= ucfirst(trim($patient['Person']['plot_no']));
										if($patient['Person']['city'])
											$add.=', '.ucfirst($patient['Person']['city']);
										if($patientstatename)
											$add.=', '.ucfirst($patientstatename);
										// echo $add;
										?>
									</td> -->
									<td>Pin Code</td>
									<td><?php echo $this->Form->input('pin_code',array('value'=>$patient['Person']['pin_code'],
											'style'=>'width:115px','type'=>'text',
											'div'=>false,'label'=>false));?></td>
								</tr>
								<tr>
									<td>State :</td>
									<td><?php echo $this->Form->input('state',array('id'=>'state',
											'value'=>$patientstatename,'type'=>'text',
											'div'=>false,'label'=>false));
									echo $this->Form->hidden('state_id',array('id'=>'state_id',
																	  'value'=>$patient['Person']['state'],'type'=>'text',
																	  'div'=>false,'label'=>false));
										?>
									</td>
									<td>City :</td>
									<td><?php echo $this->Form->input('city',array('id'=>'city',
											'value'=>$patient['Person']['city'],
											'div'=>false,'label'=>false));?></td>
								</tr>
								<tr>
									<td>Care Provider: <font color="red">*</font>
									</td>
									<td><?php 
									echo $this->Form->input('doctor_id',array(
													'id'=>'doctor_id','value'=>$patient['User']['id'],
													'empty'=>'Please Select','options'=>$doctors,
													'div'=>false,'label'=>false,
												// 	'class'=>'validate[required,custom[mandatory-select]]'
											));

									?></td>
										<td>Tariff:
										<!--<font color="red">*-->
										<!--</font>-->
									</td>
									<td><?php 

									if(strtolower($this->Session->read('role'))=='admin'){
									 	$disabled = false;
									 }else{
									 	$disabled = true;
									 }

									if(!$patient['Patient']['is_discharge']){
										echo $this->Form->input('tariff_standard_id',array(
																		'id'=>'newTariff','value'=>$patient['TariffStandard']['id'],
																	    'options'=>$tariffStandard,
																		'div'=>false,'label'=>false,
																// 		'class'=>'validate[required,custom[mandatory-select]]',
																		'disabled'=>$disabled
																	));

										if(strtolower($this->Session->read('role'))!='admin'){
											echo  $this->Form->input('tariff_standard_id', array('type'=>'hidden','value'=>$patient['TariffStandard']['id']));
										}

											echo $this->Form->hidden('prev_tariff_id',array(
													'id'=>'prevTariff','value'=>$patient['TariffStandard']['id']));
									}else{
											echo $patient['TariffStandard']['name'];

											echo $this->Form->hidden('prev_tariff_id',array(
													'id'=>'prevTariff','value'=>$patient['TariffStandard']['id']));

											echo $this->Form->hidden('tariff_standard_id',array(
													'id'=>'newTariff','value'=>$patient['TariffStandard']['id']));
									}
									?></td>
								</tr>
							
                                <td>Registration Date:</td>
                                <td><?php echo $this->DateFormat->formatDate2Local($getPatientDetails['Person']['form_received_on'], Configure::read('date_format'), true); ?></td>

								</tr>
								<tr>
                                    <td>Second Emergency Contact Name:</td>
                                    <td><?php echo $this->Form->input('second_next_of_kin_name', array('value' => $getPatientDetails['Person']['second_next_of_kin_name'], 'style' => 'width:115px', 'type' => 'text', 'div' => false, 'label' => false)); ?></td>
                                    <td>Second Emergency Contact Number:</td>
                                    <td><?php echo $this->Form->input('second_next_of_kin_mobile', array('value' => $getPatientDetails['Person']['second_next_of_kin_mobile'], 'style' => 'width:115px', 'type' => 'text', 'div' => false, 'label' => false)); ?></td>
                                </tr>
                                <tr>
                                    <td>Allergy:</td>
                                    <td><?php echo $this->Form->input('allergy', array('value' => $getPatientDetails['Person']['allergy'], 'style' => 'width:115px', 'type' => 'text', 'div' => false, 'label' => false)); ?></td>
                                    <td>Diagnosis:</td>
                                    <td><?php echo $this->Form->input('diagnosis', array('value' => $getPatientDetails['DischargeSummary']['final_diagnosis'] ? $getPatientDetails['DischargeSummary']['final_diagnosis'] : $getPatientDetails['Person']['diagnosis'], 'style' => 'width:115px', 'type' => 'text', 'div' => false, 'label' => false)); ?></td>
                                </tr>
                                <tr>
                                    <td>Address Line:</td>
                                    <td><?php echo $this->Form->input('plot_no', array('value' => $getPatientDetails['Person']['plot_no'], 'style' => 'width:115px', 'type' => 'text', 'div' => false, 'label' => false)); ?></td>
                                    <td>Residential Address:</td>
                                    <td><?php echo $this->Form->input('landmark', array('value' => $getPatientDetails['Person']['landmark'], 'style' => 'width:115px', 'type' => 'text', 'div' => false, 'label' => false)); ?></td>
                                </tr>
                                <tr>
                                    <td>Chronic Conditions:</td>
                                    <td><?php echo $this->Form->input('chronic_conditions', array('value' => $getPatientDetails['Person']['diagnosis'], 'style' => 'width:115px', 'type' => 'text', 'div' => false, 'label' => false)); ?></td>
                                    <td>Email ID:</td>
                                    <td><?php echo $this->Form->input('email', array('value' => $getPatientDetails['Person']['email'], 'style' => 'width:115px', 'type' => 'email', 'div' => false, 'label' => false)); ?></td>
                                </tr>
                                <tr>
                                    <td>Current Medication:</td>
                                    <td><?php echo $this->Form->input('current_medication', array('value' => $getPatientDetails['Person']['known_medical_conditions'], 'style' => 'width:115px', 'type' => 'text', 'div' => false, 'label' => false)); ?></td>
                                    <td>Known Medical Conditions:</td>
                                    <td><?php echo $this->Form->input('known_medical_conditions', array('value' => $getPatientDetails['Person']['known_medical_conditions'], 'style' => 'width:115px', 'type' => 'text', 'div' => false, 'label' => false)); ?></td>
                                </tr>
                                <tr>
                                    <td>Consent to Share Medical Information:</td>
                                    <td><?php echo $this->Form->input('share_info', array('value' => $getPatientDetails['Person']['share_info'], 'style' => 'width:115px', 'type' => 'text', 'div' => false, 'label' => false)); ?></td>
                                    <td>Insurance Information:</td>
                                    <td><?php echo $this->Form->input('insurence_information', array('value' => $getPatientDetails['Person']['insurence_information'], 'style' => 'width:115px', 'type' => 'text', 'div' => false, 'label' => false)); ?></td>
                                </tr>
                                <tr>
                                    <td>Preferred Hospital:</td>
                                    <td><?php echo $this->Form->input('preferred_hospital', array('value' => $getPatientDetails['Person']['preferred_hospital'], 'style' => 'width:115px', 'type' => 'text', 'div' => false, 'label' => false)); ?></td>
                                    <td>Language Preference:</td>
                                    <td><?php echo $this->Form->input('language_preference', array('value' => $getPatientDetails['Person']['language_preference'], 'style' => 'width:115px', 'type' => 'text', 'div' => false, 'label' => false)); ?></td>
                                </tr>
                                <tr>
                                    <td>Organ Donor Status:</td>
                                    <td><?php echo $this->Form->input('dnr', array('value' => $getPatientDetails['Person']['dnr'], 'style' => 'width:115px', 'type' => 'text', 'div' => false, 'label' => false)); ?></td>
                                    <td style="display:none">Do Not Resuscitate (DNR) Order:</td>
                                    <td><?php echo $this->Form->input('organ_donor', array('value' => $getPatientDetails['Person']['organ_donor'], 'style' => 'width:115px', 'type' => 'text', 'div' => false, 'label' => false)); ?></td>
                                </tr>
                        	<tr>
									<td colspan="4" style="text-align: center"><?php 
									echo $this->Form->button('Submit',array('type'=>'submit','id'=>'submit','div'=>false
												,'label'=>false,'class'=>'blueBtn'));
											echo $this->Html->Link('Edit More Details',
																	array('controller'=>'Persons','action'=>'edit',$patient['Person']['id']),
																	array('escape'=>false,'class'=>'blueBtn'));

											?></td>

							</table>
							<?php echo $this->Form->end();?>
								<?php
				// 	debug($getPatientDetails);
					?>
							<!-- EOF Hidden Section For Editing Patient Info -->
							<h4>PREVIOUS VISITS INFO</h4>
							<div class="visitDetails">
								<table class="infoDiv" cellpadding="0" cellspacing="0">
									<?php if($personVisits){?>
									<tr>
										<th width="19%">Visit Date</th>
										<th width="11%">Visit Type</th>
										<th width="10%">Tariff</th>
										<th width="25%">Doctor</th>
										<th width="10%">Status</th>
										<th width="19%">Discharge Date</th>
										<th width="9%">View</th>
									</tr>
									<?php
									foreach($personVisits as $key=>$visits){?>
									<tr>

										<td style="margin: none !important; padding: none !important;">

											<?php echo $this->DateFormat->formatDate2Local($visits['Patient']['form_received_on'],Configure::read('date_format'),true);?>
										</td>
										<td><?php echo $visits['Patient']['admission_type'];?>
										</td>
										<td><?php echo $visits['TariffStandard']['name'];?>
										</td>
										<td><?php echo $visits['User']['first_name'].' '.$visits['User']['last_name'];?>
										</td>
										<td><?php if(!empty($visits['Patient']['is_discharge'])){
											if(strtolower($visits['Patient']['admission_type']=="OPD"))
												echo "Closed";
											else
												echo "Discharged";
										}else{
														if(strtolower($visits['Patient']['admission_type']=="OPD"))
															echo "Current Appointment";
														else
															echo "Admitted";
															
												 }
												 ?></td>
										<td><?php echo $this->DateFormat->formatDate2Local($visits['Patient']['discharge_date'],Configure::read('date_format'),true);?>
										</td>
										<td><?php 

										echo $this->Html->link($this->Html->image('icons/view-icon.png'),array('action'=>'new_patient_hub',$visits['Patient']['id'],$personId),array('escape'=>false,'id'=>'edit','float'=>'center'));
										?>
										</td>

									</tr>
									<?php }
									}else{?>
									<tr>
										<td align="center"><b>No Previous Visits</b></td>
									</tr>
									<?php }?>
								</table>
							</div>
							
							<!--desposition @7387737062-->
							<!--	<h4>Desposition and Subdespostion</h4>-->
							<!--<div class="visitDetails">-->
							<!--<table border="1" cellpadding="10" cellspacing="0">-->
       <!--                         <thead>-->
       <!--                             <tr>-->
                                        <!--<th>ID</th>-->
       <!--                                 <th>Disposition</th>-->
       <!--                                 <th>Sub Disposition</th>-->
       <!--                                 <th>Outcome</th>-->
       <!--                                 <th>Follow Up Date</th>-->
       <!--                                 <th>Follow Up Action</th>-->
       <!--                                 <th>Call Assigned To</th>-->
       <!--                                 <th>Call Timestamp</th>-->
       <!--                                  <th>Remark</th>-->
       <!--                             </tr>-->
       <!--                         </thead>-->
       <!--                         <tbody>-->
       <!--                             <?php if (!empty($desposition_hub)): ?>-->
       <!--                                 <?php foreach ($desposition_hub as $data): ?>-->
       <!--                                     <tr>-->
                                                <!--<td><?php echo h($data['Disposition']['id']); ?></td>-->
       <!--                                         <td><?php echo h($data['Disposition']['disposition']); ?></td>-->
       <!--                                         <td><?php echo h($data['Disposition']['sub_disposition']); ?></td>-->
       <!--                                         <td><?php echo h($data['Disposition']['outcome']); ?></td>-->
       <!--                                         <td><?php echo h($data['Disposition']['follow_up_date']); ?></td>-->
       <!--                                         <td><?php echo h($data['Disposition']['follow_up_action']); ?></td>-->
       <!--                                         <td><?php echo h($data['Disposition']['call_assigned_to']); ?></td>-->
       <!--                                         <td><?php echo h($data['Disposition']['call_timestamp']); ?></td>-->
       <!--                                         <td><?php echo h($data['Disposition']['remark']); ?></td>-->
       <!--                                     </tr>-->
       <!--                                 <?php endforeach; ?>-->
       <!--                             <?php else: ?>-->
       <!--                                 <tr>-->
       <!--                                     <td colspan="8">No disposition data found for this patient.</td>-->
       <!--                                 </tr>-->
       <!--                             <?php endif; ?>-->
       <!--                         </tbody>-->
       <!--                     </table>-->
                    
                     
							<!--</div>-->
							 <!-- <div class="container my-5">-->
        <!--<h1 class="mb-4">Patient Hub</h1>-->

        <!-- Patient Details -->
        <!--<div class="mb-4">-->
            <!--<p><strong>Patient Name:</strong> John Doe</p>-->
            
            <!--<p class="text-black" style="float: none">Next Appointment Date: 2024-12-20</p>-->
            <!--<p class="text-black" >Purpose of Visit: OPD</p>-->
            <!--<p class="text-black">Surgery/Diagnosis: None</p>-->
            <!--<p class="text-black">Budget Given: ₹10,000</p>-->
        <!--</div>-->

        <!-- Call Log -->
        <!--<div>-->
            <!--<h2 class="bg-secondary text-white p-2">Call Log</h2>-->
        <?= $this->Form->create(null, ['url' => ['controller' => 'Patients', 'action' => 'ready_to_discharge'], 'type' => 'post']) ?>
      <!--<?php echo isset($patient['Person']['id']) ? $patient['Person']['id'] : 'Not Available'; ?>-->
        
      
<table class="table table-bordered rounded shadow-sm">
    <!-- Next Appointment Date -->
    <!--code by dinesh tawade-->
       <tr style="display:none;"><!-- Next Appointment Date -->
	<?php echo $this->Form->input('Person.id', ['type' => 'hidden', 'value' => isset($patient['Person']['id']) ? $patient['Person']['id'] : '']); ?>
		<?php 
    echo $this->Form->input('Patient.id', [
        'type' => 'hidden', 
        'id' => 'patient_id', 
        'name' => 'data[Disposition][patient_id]', 
        'value' => isset($patient['Patient']['id']) ? $patient['Patient']['id'] : ''
    ]); 

    ?>
</tr> 
	<tr>
		<td class="p-3 align-middle">
			<label for="next_visite_date" class="font-weight-bold text-muted">Next Appointment Date:</label>
		</td>
		<td class="p-3 align-middle">
			<div class="row">
				<div class="col-md-6">
					<span class="mr-3 text-muted" style="font-size: 17px;">
						<?php echo isset($patient['Person']['next_visite_date']) ? date('Y-m-d', strtotime($patient['Person']['next_visite_date'])) : 'No date set'; ?>
					</span>
				</div>
				<div class="col-md-6">
					<?php echo $this->Form->input('Person.next_visite_date', [
						'type' => 'text',
						'label' => false,
						'class' => 'form-control',
						'readonly' => isset($patient['Person']['next_visite_date']) && !empty($patient['Person']['next_visite_date']) ? 'readonly' : null,
						'id' => 'next_visite_date',
						'value' => isset($patient['Person']['next_visite_date']) ? date('Y-m-d', strtotime($patient['Person']['next_visite_date'])) : null
					]); ?>
				</div>
			</div>
			<span id="calendar-icon" class="ml-2">
				<i class="fa fa-calendar"></i>
			</span>
		</td>
	</tr>

	<!-- Purpose of Visit -->
	<tr>
		<td class="p-3 align-middle">
			<label for="next_visite_type" class="font-weight-bold text-muted">Purpose of Visit:</label>
		</td>
		<td class="p-3 align-middle">
			<div class="row">
				<div class="col-md-6">
					<span class="mr-3 text-muted" style="font-size: 17px;">
						<?php echo isset($patient['Person']['next_visite_type']) ? $patient['Person']['next_visite_type'] : 'Not selected'; ?>
					</span>
				</div>
				<div class="col-md-6">
					<?= $this->Form->input('Person.next_visite_type', [
						'type' => 'select',
						'options' => ['' => 'Select Visit Type', 'OPD' => 'OPD', 'IPD' => 'IPD'],
						'label' => false,
						'class' => 'form-control',
						'id' => 'next_visite_type',
						'style' => 'width: 100%; padding: 10px;',
						'value' => isset($patient['Person']['next_visite_type']) ? $patient['Person']['next_visite_type'] : null,
						'onchange' => 'toggleSurgeryField()'
					]); ?>
				</div>
			</div>
		</td>
	</tr>

	<!-- Surgery/Diagnosis -->
	<tr id="surgery_row">
		<td class="p-3 align-middle">
			<label for="purpose_of_visite" class="font-weight-bold text-muted">Surgery:</label>
		</td>
		<td class="p-3 align-middle">
			<div class="row">
				<div class="col-md-6">
					<span class="mr-3 text-muted" style="font-size: 17px;">
						<?php echo isset($patient['Person']['purpose_of_visite']) ? $patient['Person']['purpose_of_visite'] : 'Not selected'; ?>
					</span>
				</div>
				<div class="col-md-6">
					<?= $this->Form->input('Person.purpose_of_visite', [
						'type' => 'select',
						'label' => false,
						'class' => 'form-control',
						'empty' => 'Select a surgery...',
						'options' => $surgeries,
						'value' => isset($patient['Person']['purpose_of_visite']) ? $patient['Person']['purpose_of_visite'] : null
					]); ?>
				</div>
			</div>
		</td>
	</tr>

    <!-- Budget -->
	<tr id="budget_row">
		<td class="p-3 align-middle">
			<label for="budget" class="font-weight-bold text-muted">Budget:</label>
		</td>
		<td class="p-3 align-middle">
			<div class="row">
				<div class="col-md-6">
					<span class="mr-3 text-muted" style="font-size: 17px;">
						<?php echo isset($patient['Person']['budget']) ? $patient['Person']['budget'] : 'Not set'; ?>
					</span>
				</div>
				<div class="col-md-6">
					<?php
					echo $this->Form->input('Person.budget', [
						'type' => 'hidden',
						'id' => 'hidden_budget',
						'value' => isset($patient['Person']['budget']) ? $patient['Person']['budget'] : ''
					]);

					echo $this->Form->input('Person.budget_select', [
						'type' => 'select',
						'options' => [
							'50000' => '50,000',
							'75000' => '75,000',
							'100000' => '1,00,000',
							'125000' => '1,25,000',
							'150000' => '1,50,000',
							'200000' => '2,00,000',
							'300000' => '3,00,000',
							'400000' => '4,00,000',
							'500000' => '5,00,000',
							'600000' => '6,00,000',
							'700000' => '7,00,000',
							'800000' => '8,00,000',
							'900000' => '9,00,000',
							'1000000' => '10,00,000',
							'Other' => 'Other'
						],
						'empty' => 'Select Budget',
						'label' => false,
						'class' => 'form-control',
						'id' => 'budget_select',
						'onchange' => 'handleBudgetChange()',
						'value' => isset($patient['Person']['budget']) ? $patient['Person']['budget'] : ''
					]);

					echo '<input type="text" 
							  id="other_budget" 
							  placeholder="Enter your budget" 
							  class="form-control mt-2" 
							  style="display: none;" />';
					?>
				</div>
			</div>
		</td>
	</tr>

    <!-- Submit Button -->
    <tr>
        <td colspan="2" class="p-3 text-center">
            <?= $this->Form->input('Person.id', [
                'type' => 'hidden',
                'label' => false,
                'value' => isset($patient['Person']['id']) ? $patient['Person']['id'] : null
            ]); ?>
            <?= $this->Form->button('Submit', [
                'class' => 'btn btn-success btn-lg',
                'style' => 'transition: background-color 0.3s ease;',
                'onmouseover' => "this.style.backgroundColor='#218838';",
                'onmouseout' => "this.style.backgroundColor='#28a745';"
            ]); ?>
        </td>
    </tr>
</table>



<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
 document.addEventListener('DOMContentLoaded', function () {
        const dateInput = document.getElementById('next_visite_date');

        flatpickr(dateInput, {
            dateFormat: "Y-m-d", // Database-friendly format
            altInput: true,
            altFormat: "F j, Y", // User-friendly format
            defaultDate: new Date(), // Always sets today's date dynamically
            allowInput: true // Allows manual date input
        });
    });
</script>


<script>
function toggleSurgeryField() {
    const visitType = document.getElementById('next_visite_type').value;
    const surgeryRow = document.getElementById('surgery_row');
    if (visitType === 'OPD') {
        surgeryRow.style.display = 'none'; // Hide surgery row for OPD
    } else {
        surgeryRow.style.display = 'table-row'; // Show surgery row for IPD or placeholder
    }
}

// Ensure all fields are visible initially and adjust based on selection
document.addEventListener('DOMContentLoaded', () => {
    toggleSurgeryField(); // Call function to check initial selection
});
</script>
<script>
    function handleBudgetChange() {
        const budgetSelect = document.getElementById('budget_select');
        const otherBudgetInput = document.getElementById('other_budget');
        const hiddenBudget = document.getElementById('hidden_budget');

        if (budgetSelect.value === 'Other') {
            otherBudgetInput.style.display = 'block'; // Show the manual input field
            otherBudgetInput.setAttribute('required', 'required'); // Make it required
            otherBudgetInput.addEventListener('input', () => {
                hiddenBudget.value = otherBudgetInput.value.trim(); // Sync manual input to hidden field
            });
        } else {
            otherBudgetInput.style.display = 'none'; // Hide the manual input field
            otherBudgetInput.removeAttribute('required'); // Remove required attribute
            otherBudgetInput.value = ''; // Clear the manual input value
            hiddenBudget.value = budgetSelect.value; // Sync dropdown value to hidden field
        }
    }

    // Attach event listener
    document.getElementById('budget_select').addEventListener('change', handleBudgetChange);

    // Initialize hidden field on page load
    document.addEventListener('DOMContentLoaded', () => {
        handleBudgetChange();
    });
</script>
            <!--table by dinesh tawade-->
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr style="font-size:11px;">
                        <!--<th>Date</th>-->
                        <th>Telecaller</th>
                        <th>Disposition</th>
                        <th>Sub-Disposition</th>
                        <th>Doctor</th>
                        <th>Follow-up On</th>
                        <th>Called On</th>
                        <th>Budget Amount</th>
                        <th>Remark</th>
                        <!--<th>Doctor</th>-->
            			<th>Admission Type</th>
                        <th>Department</th>
                        <th>Diagnosis</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($dispositions)): ?>
                        <?php foreach ($dispositions as $disposition): ?>
                            <tr style="font-size: 11px;">
                    <!--<td><?php echo !empty($disposition['Disposition']['created_at']) ? h($disposition['Disposition']['created_at']) : 'N/A'; ?></td>-->
					<td><?php echo !empty($disposition['Disposition']['call_assigned_to']) ? h($disposition['Disposition']['call_assigned_to']) : 'N/A'; ?></td>
					<td><?php echo !empty($disposition['DispositionList']['disposition_name']) ? h($disposition['DispositionList']['disposition_name']) : 'N/A'; ?></td>
					<td><?php echo !empty($disposition['SubDispositionList']['sub_disposition_name']) ? h($disposition['SubDispositionList']['sub_disposition_name']) : 'N/A'; ?></td>
					<td><?php echo ucfirst($patient['User']['first_name']).' '.ucfirst($patient['User']['last_name']); ?></td>
					<td><?php echo !empty($disposition['Disposition']['queue_date']) ? h($disposition['Disposition']['queue_date']) : 'N/A'; ?></td>
					<td><?php echo !empty($disposition['Disposition']['created_at']) ? h($disposition['Disposition']['created_at']) : 'N/A'; ?></td>
					<td><?php echo !empty($disposition['Disposition']['budget_amount']) ? h($disposition['Disposition']['budget_amount']) : 'N/A'; ?></td>
					<td><?php echo !empty($disposition['Disposition']['remark']) ? h($disposition['Disposition']['remark']) : 'N/A'; ?></td>
					<!--<td><?php echo !empty($disposition['Disposition']['doctor']) ? h($disposition['Disposition']['doctor']) : 'N/A'; ?></td>-->
					<td><?php echo !empty($disposition['Disposition']['admission_type']) ? h($disposition['Disposition']['admission_type']) : 'N/A'; ?></td>
					<td><?php echo !empty($disposition['Disposition']['department']) ? h($disposition['Disposition']['department']) : 'N/A'; ?></td>
					<td>
                        <?php
                        $text = $getPatientDetails['DischargeSummary']['final_diagnosis'] ? $getPatientDetails['DischargeSummary']['final_diagnosis'] : $getPatientDetails['Person']['diagnosis'];
                        $shortText = substr($text, 0, 30); // Display first 30 characters
                        $fullText = $text;
                        ?>
                        <span id="shortText"><?php echo $shortText; ?></span>
                        <span id="fullText" style="display:none;"><?php echo $fullText; ?></span>
                        <a href="#" id="readMoreLink">Read More</a>
                    </td>       </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="14" class="text-center">No data available</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <!--end by dinesh tawade-->

                        <!--    </div>-->
                        <!--</div>-->
							
						</div>
					</div>
				</div>
			</div>

		</div>
		<?php }?>
	 <div id="qrcode" style="display: none;"></div>
    
    <canvas id="canvas" style="display: none;"></canvas>
    
<script>
document.getElementById("readMoreLink").addEventListener("click", function(event) {
    event.preventDefault(); // Prevent the default link behavior
    var shortText = document.getElementById("shortText");
    var fullText = document.getElementById("fullText");
    var readMoreLink = document.getElementById("readMoreLink");

    if (fullText.style.display === "none") {
        fullText.style.display = "inline";
        shortText.style.display = "none";
        readMoreLink.textContent = "Read Less";
    } else {
        fullText.style.display = "none";
        shortText.style.display = "inline";
        readMoreLink.textContent = "Read More";
    }
});
</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
  
<script>
    function generateQRCode() {
        const mobileNumber = "<?php echo $patient['Person']['mobile']; ?>";
        const url = `https://admin.emergencyseva.in/public/emergency-sewa/?${mobileNumber}`;
        const qrCodeDiv = document.getElementById('qrcode');
        qrCodeDiv.innerHTML = '';
        new QRCode(qrCodeDiv, url);
        setTimeout(addTextToQRCode, 500); 
    }

    function addTextToQRCode() {
        const qrCodeDiv = document.getElementById('qrcode');
        const qrCodeImg = qrCodeDiv.querySelector('img');
        const canvas = document.getElementById('canvas');
        const context = canvas.getContext('2d');
        canvas.width = qrCodeImg.width;
        canvas.height = qrCodeImg.height;

        context.drawImage(qrCodeImg, 0, 0);
        context.font = 'bold 20px Arial'; 
        context.textAlign = 'center';
        context.fillStyle = 'black';

        qrCodeDiv.innerHTML = '';
        const newImg = new Image();
        newImg.src = canvas.toDataURL();
        qrCodeDiv.appendChild(newImg);
    }

    function downloadQRCode() {
        const canvas = document.getElementById('canvas');
        const link = document.createElement('a');
        link.href = canvas.toDataURL();
        link.download = 'qrcode.png';
        link.click();
    }

    window.onload = generateQRCode;
</script>


</body>
</html>


<script>
$(".navigation li a").click(function() {
    $(this).parent().addClass('selected').siblings().removeClass('selected');
});
var uid="<?php echo $patient['Patient']['patient_id'];?>";
var name='<?php echo $patient['Patient']['lookup_name']?>';
var age='Age/Sex : <?php echo $age.'/'.ucfirst($patient['Person']['sex']);?>';
var address='<?php $add= ucfirst(trim($patient['Person']['plot_no']));
								if($patient['Person']['city'])
									$add.=', '.ucfirst($patient['Person']['city']);
								if($patientstatename)
									$add.=', '.ucfirst($patientstatename);
								echo $add;?>';
var mobile='<?php echo isset($patient['Patient']['mobile_phone'])?$patient['Patient']['mobile_phone']:$patient['Person']['mobile'];?>';
var care_provider='<?php echo ucfirst($patient['User']['first_name']).' '.ucfirst($patient['User']['last_name']);?>';
var adm_type='<?php echo $patient['Patient']['admission_type'];?>';
var blood_group='<?php echo $blood_group;?>';
var tariffStandard='<?php echo ucfirst(trim($patient['TariffStandard']['name']));?>';
var adm_date='<?php echo $this->DateFormat->formatDate2Local($patient['Patient']['form_received_on'],Configure::read('date_format'),true);?>';

$(document).ready(function(){
$("#editInfo").validationEngine();
	
	//var dischargeMsg='';
	
	<?php if(!$patient['Patient']['is_discharge']){?>
			dischargeMsg="This patient is currently admitted";
			$('.tag').addClass('tagAdmit');
			tagClass='tagAdmit';
	<?php }else{?>
			dischargeMsg="This patient is discharged";
			$('.tag').addClass('tagDischarge');
			tagClass='tagDischarge';
	<?php }?>	
	$('.tag').text(dischargeMsg);
	$("#dob").datepicker({
		showOn : "both",
		buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly : true,
		buttonText: "Calendar",
		changeMonth : true,
		changeYear : true,
		yearRange: '-100:' + new Date().getFullYear(),
		maxDate : new Date(),
		dateFormat:'<?php echo $this->General->GeneralDate();?>',
		onSelect : function() {
			$("#dob").validationEngine("hide");   
			//calculateAge();getYearMonth();getYearMonthDay();CalculateDiff1();
			$.ajax({
				url :  "<?php echo $this->Html->url(array('controller'=>'Persons','action'=>'getAgeFromDob')); ?>",
				method : "GET",
				data : "dob="+$('#dob').val(),
				beforeSend : function(){
					//$('#busy-indicator').show();
				},
				success : function(data){
					var age = jQuery.parseJSON(data);
					$('#age').val(age[0]);
					//setAge();//.trigger('change');
					$('#ageMonth').val(age[1]);
					$('#ageDay').val(age[2]);
					//$('#busy-indicator').hide();
				}
			});
		}
	});		
	
	$('#edit').click(function(){
			$('.view').hide();
			$('.editDiv').show();
			$('#cancel_edit').show();
			$(this).hide();					
	});

	$('#cancel_edit').click(function(){
		$('.view').show();
		$('.editDiv').hide();
		$('#edit').show();
		$(this).hide();
    });

	$("#state").keypress(function(){
		$( "#state_id" ).val('');
	});
	$("#state").autocomplete({
	    source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","State","id&name",'no','no','no')); ?>", 
	    select: function(event,ui){
			$( "#state_id" ).val(ui.item.id);	
			$('#city').val('');	
		},
		 messages: {
		     noResults: '',
		     results: function() {},
		}
	});

	$(document).on('focus','#city', function() {
		var getStateId=$('#state_id').val();
		$(this).autocomplete({
				source:"<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","City","id&name",'no','no','no')); ?>"+'/'+'state_id='+getStateId,
				select: function(event,ui){
						$( "#city_id" ).val(ui.item.id);		
				},
				 messages: {
				     noResults: '',
				     results: function() {},
				}
		});
	});
	/*************************Ward Details ajax request*******************************************/
	$('#wardDetails').click(function(){
		var discharge="<?php echo $patient['Patient']['is_discharge']?>";
		var bed_id="<?php echo $patient['Patient']['bed_id']?>";
		$.ajax({
			  type : "POST",
			  url: "<?php echo $this->Html->url(array("controller" => "Wards", "action" => "patientWardTransaction",$patient['Patient']['id'], "admin" => false)); ?>?is_discharge="+discharge+'&bed_id='+bed_id,
			  context: document.body,	
			  beforeSend:function(){
				  $('#busy-indicator').show();
			  }, 	  		  
			  success: function(data){	
				  $('#busy-indicator').hide('fast');				  
				  $('#content').html(data);
			   }
		});	
	});
   /**************************EOF Ward Details***********************************************/
   /**************************LAB/RAD Details***********************************************/
   $('#labDetails').click(function(){	   
	   $.ajax({
			  type : "POST",
			  url: "<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "labDetailsPatientHub",$patient['Patient']['id'], "admin" => false)); ?>",
			  context: document.body,	
			  beforeSend:function(){
				  $('#busy-indicator').show();
			  }, 	  		  
			  success: function(data){	
				  $('#busy-indicator').hide('fast');				  
				  $('#content').html(data);
			   }
		});
   });
   /**************************EOF LAB/RAD Details***********************************************/
   /**************************OT Appointment Details***********************************************/
   
    $('#optDetails').click(function(){	   
	   $.ajax({
			  type : "POST",
			  url: "<?php echo $this->Html->url(array("controller" => "NewOptAppointments", "action" => "patientOtAppointments",$patient['Patient']['id'], "admin" => false)); ?>",
			  context: document.body,	
			  beforeSend:function(){
				  $('#busy-indicator').show();
			  }, 	  		  
			  success: function(data){	
				  $('#busy-indicator').hide('fast');				  
				  $('#content').html(data);
			   }
		});
   });
   
   
    
   
   /**************************EOF OT Appointment Details***********************************************/
   $("#addmissionId").autocomplete({
	    source: "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "admissionComplete","no","admin" => false,"plugin"=>false)); ?>",
		select: function(event,ui){
			$( "#patientId" ).val(ui.item.id);
			if($( "#addmissionId" ).val() != '')
	    		var url="<?php echo $this->Html->url(array('controller'=>$this->params['controller'],'action'=>'getLatestEncounter'));?>";
	    		 $('#busy-indicator').show(); 
	    		window.location.href = url+'/'+ui.item.id+'/'+ui.item.person_id;
	    		//$( "#addmissionId" ).trigger( "change" );
		},
		 messages: {
	        noResults: '',
	        results: function() {},
	 	}
	});

});

$('.opdReciept').click(function(){
	$.fancybox({
		'width'    : '70%',
	    'height'   : '50%',
	    'autoScale': true,
	    'transitionIn': 'fade',
	    'transitionOut': 'fade',
	    'type': 'iframe',
		'href':"<?php echo $this->Html->url(array('controller'=>'Billings','action'=>'allReceiptList',$patient['Patient']['id'], "admin" => false));?>"
	});
});


</script>
