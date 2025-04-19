<?php 
echo $this->Html->script('jquery.autocomplete');
echo $this->Html->css('jquery.autocomplete.css');
?>
<div class="inner_title">
	<h3>
		&nbsp;<?php echo __('Quick Patient Registration'); ?>
	</h3>
	<span></span>
</div>
<?php echo $this->Form->create('',array('id'=>'quickPatientRagistrationForm','url'=>array('controller'=>'Persons','action'=>'quickPatientRagistration',$pesonData['Person']['id']),'inputDefaults' => array(
		'label' => false,
		'div' => false,
		'error' => false,
		'legend'=>false,
		'fieldset'=>false
)
));
?>
<?php echo $this->Form->hidden('Patient.lookup_name',array('value'=>$pesonData['Person']['first_name']." ".$pesonData['Person']['last_name']));?>
<?php echo $this->Form->hidden('Patient.person_id',array('value'=>$pesonData['Person']['id']));?>
<?php echo $this->Form->hidden('Patient.location_id',array('value'=>$pesonData['Person']['location_id']));?>
<?php echo $this->Form->hidden('Patient.age',array('value'=>$pesonData['Person']['age']));?>
<?php echo $this->Form->hidden('Patient.sex',array('value'=>$pesonData['Person']['sex']));?>
<?php echo $this->Form->hidden('Patient.patient_id',array('value'=>$pesonData['Person']['patient_uid']));?>
<?php echo $this->Form->hidden('Patient.admission_type',array('value'=>'OPD'));?>
<?php echo $this->Form->hidden('Patient.tariff_standard_id', array('id'=>'tariff_standard_id','value'=>'4'));?>
<table style="margin: 10px;" width="99%" cellspacing="0" align="center">
	<tr>
		<td class="tdLabel" width="30%"><b><?php echo __('Patient Name :')?>
		
		</td>
		<td><?php $name = $pesonData['Person']['first_name']." ".$pesonData['Person']['middle_name']." ".$pesonData['Person']['last_name'];
		echo $name; ?>
		</td>
	</tr>
	<tr>
		<td class="tdLabel"><b><?php echo __('Type of Encounter')?><font color="red">* </font>:</b></td>
		<td><?php $mode = array(''=>'Please Select','Consultation'=>'Consultation','Secure Email'=>'Secure Email','Group Visit'=>'Group Visit','Phone'=>'Phone','SMS'=>'SMS','Walk-in'=>'Walk-in','Other'=>'Other');
		echo $this->Form->input('Patient.mode_communication', array('options'=>$mode ,'id'=>"mode",'class' => 'validate[required,custom[mandatory-select]]','style'=>'width:250px','value'=>$adviceRec['mode_communication'])); ?>
		</td>
	</tr>
	<tr id= "otherCommunication" style="display:none">
		<td class="tdLabel">&nbsp;</td>
		<td><?php 
		echo $this->Form->input('Patient.other_mode_communication', array('id'=>"other_mode_communication",'class' => 'validate[required,custom[mandatory-enter]]','style'=>'width:250px','value'=>$adviceRec['other_mode_communication'])); ?>
		</td>
	</tr>
	<?php $role=$this->Session->read('role');?>
	<?php if(($role == Configure::read('doctorLabel')||$role == Configure::read('nurseLabel'))) {?>
	<tr>
		<td class="tdLabel"><b><?php echo __('Advice / Confirmation of appointment :')?> </b></td>
		<td width="19%"><?php echo $this->Form->input('Patient.advice', array('type'=>'textarea','rows'=>'3','cols'=>'5','id' => 'advice','label'=>false,'value'=>$adviceRec['advice']));?></td>
		<td><?php echo $this->Form->submit(__('Transmit'), array('class'=>'blueBtn','div'=>false,'id'=>'')); ?></td>
	</tr>
	<?php }?>
	<tr>
		<td class="tdLabel"><b><?php echo __('Time of Patient Contact')?>:</b></td>
		<td><?php $d= $this->DateFormat->formatDate2LocalForReport(date('Y-m-d H:i:s'),Configure::read('date_format'),true);
		echo $this->Form->input('Patient.form_received_on', array('type'=>'text','class' => 'textBoxExpnd ','readonly'=>'readonly','id' => 'date','label'=>false,'style'=>'width:250px','value'=>$d));?>
		</td>
	</tr>
	<tr>
		<td class="tdLabel"><b><?php echo __('Primary Care Provider')?><font
				color="red">* </font>:</b></td>
		<td><?php
		if($this->Session->read('role')=='Primary Care Provider'){
			$dr_name=$this->Session->read('first_name')." ".$this->Session->read('last_name');
			echo $this->Form->input('DoctorProfile.doctor_name', array('style'=>'float:left; width:250px','id'=>'doctor_id_txt','class'=>'validate[required,custom[mandatory-enter]] validate[required,custom[name],custom[onlyLetterSp]]','value'=>$dr_name));
			//actual field to enter in db
			echo $this->Form->hidden('Patient.doctor_id', array('type'=>'text','id'=>'doctorID','value'=>$this->Session->read('userid')));
		}else{
			echo $this->Form->input('DoctorProfile.doctor_name', array('style'=>'float:left; width:250px','id'=>'doctor_id_txt','class'=>'validate[required,custom[mandatory-enter]] validate[required,custom[name],custom[onlyLetterSp]]','value'=>$getuser['first_name'].' '.$getuser['last_name']));
			//actual field to enter in db
			echo $this->Form->hidden('Patient.doctor_id', array('type'=>'text','id'=>'doctorID','value'=>$getuser['id']));
		}

		?>
		</td>
	</tr>
	<tr>
		<td class="tdLabel"><b><?php echo __('Specialty:')?> </b></td>
		<td><?php 
		if($this->Session->read('role')=='Primary Care Provider'){
			$dr_name=$this->Session->read('first_name')." ".$this->Session->read('last_name');
			echo $this->Form->input('Patient.department', array('empty'=>__('Please Select'),'options'=>$departments,'style'=>'width:250px','class' => 'department_id','id' => 'department_id','disabled' =>'disabled','value'=>$this->Session->read('department')));

			echo $this->Form->hidden('Patient.department_id', array('type'=>'text','id'=>'department_id_hidan','class' => 'department_id','value'=>$this->Session->read('departmentid')));
		}else{
			echo $this->Form->input('Patient.department', array('empty'=>__('Please Select'),'options'=>$departments,'style'=>'width:250px','class' => 'department_id','id' => 'department_id','disabled' =>'disabled'));

			echo $this->Form->hidden('Patient.department_id', array('type'=>'text','id'=>'department_id_hidan','class' => 'department_id'));
		}


		?>
		</td>
	</tr>

	<?php //if(($role == Configure::read('doctorLabel')||$role == Configure::read('nurseLabel'))) {?>
	<tr>
		<td class="tdLabel"><h3>
				<?php echo __('Treatment Advice :')?>
			</h3></td>
		<td></td>
	</tr>
	<tr>
		<table style="margin: 10px;" width="80%" cellspacing="0" align="center">
			<tr>
				<td>
					<div class="section" id="treatment">
						<div align="center" id='temp-busy-indicator-treatment' style="display: none;">
							&nbsp;
							<?php echo $this->Html->image('indicator.gif', array()); ?>
						</div>
						<!--BOF medicine  -->
						<table  class="tabularForm" style="text-align: left; padding: 0px !important" width="100%">
							<tr>
								<td width="100%" valign="top" align="left" style="padding: 2px;" colspan="4">
									<table width="100%" border="0" cellspacing="0" cellpadding="0" >
										<!-- row 1 -->
										<tr>
											<td width="100%" valign="top" align="left" colspan="6">
												<table width="100%" border="1" cellspacing="0" cellpadding="0" class="tabularForm" id='DrugGroup' class="" style="padding: 0px !important">
													<tr>
														<td width="100%" colspan='14'>
															<div id='successMsg' style='display: none; color: #78D73E; text-align: center'></div>
														</td>
													</tr>

													<tr>
														<td width="8%" height="20" align="left" valign="top" style="padding-right: 3px;">Drug Name</td>
														<td width="5%" height="20" align="left" valign="top" style="">Dosage</td>
														<td width="5%" height="20" align="left" valign="top" style="">Dosage Form</td>
														<td width="5%" height="20" align="left" valign="top" style="">Route</td>
														<td width="5%" align="left" valign="top" style="">Frequency</td>
														<td width="3%" align="left" valign="top" style="">Days</td>
														<td width="3%" align="left" valign="top" style="">Qty</td>
														<td width="5%" align="left" valign="top" style="">Refills</td>
														<td width="5%" align="center" valign="top" style="">PRN</td>
														<td width="5%" align="center" valign="top" style="">Dispense As Written</td>
														<td width="10%" align="center" valign="top" style="">First
															Dose Date/Time</td>
														<td width="10%" align="center" valign="top" style="">Stop
															Date/Time</td>
														<td width="5%" align="center" valign="top" style="">Active</td>
													</tr>
													<?php  //debug($currentresult);
													if(isset($currentresult) && !empty($currentresult)){
					               				$count  = count($currentresult) ;
					               			}else{
					               				$count  = 3 ;
					               			}
					               			for($i=0;$i<$count;){

					               				$drugValue= isset($drugRec[$i]['NewCropPrescription']['drug'])?$drugRec[$i]['NewCropPrescription']['drug']:'';
					               				$drugId= isset($drugRec[$i]['NewCropPrescription']['drug_id'])?$drugRec[$i]['NewCropPrescription']['drug_id']:'';
					               				
					               				$start_date=$this->DateFormat->formatDate2Local($currentresult[$i][NewCropPrescription][firstdose],Configure::read('date_format'),true);
												$end_date=$this->DateFormat->formatDate2Local($currentresult[$i][NewCropPrescription][stopdose],Configure::read('date_format'),true);
												
												$crossID= isset($currentresult[$i]['NewCropPrescription']['id'])?$currentresult[$i]['NewCropPrescription']['id']:'' ;
												$drug_name_val= isset($currentresult[$i]['NewCropPrescription']['description'])?$currentresult[$i]['NewCropPrescription']['description']:'' ;
												$drug_id_val= isset($currentresult[$i]['NewCropPrescription']['drug_id'])?$currentresult[$i]['NewCropPrescription']['drug_id']:'' ;
												$dose_val= isset($currentresult[$i]['NewCropPrescription']['dose'])?$currentresult[$i]['NewCropPrescription']['dose']:'' ;
												$strength_val= isset($currentresult[$i]['NewCropPrescription']['strength'])?$currentresult[$i]['NewCropPrescription']['strength']:'' ;
												$route_val= isset($currentresult[$i]['NewCropPrescription']['route'])?$currentresult[$i]['NewCropPrescription']['route']:'' ;
												$frequency_val= isset($currentresult[$i]['NewCropPrescription']['frequency'])?$currentresult[$i]['NewCropPrescription']['frequency']:'' ;
												$day_val= isset($currentresult[$i]['NewCropPrescription']['day'])?$currentresult[$i]['NewCropPrescription']['day']:'' ;
												$quantity_val= isset($currentresult[$i]['NewCropPrescription']['quantity'])?$currentresult[$i]['NewCropPrescription']['quantity']:'' ;
												$refills_val= isset($currentresult[$i]['NewCropPrescription']['refills'])?$currentresult[$i]['NewCropPrescription']['refills']:'' ;
												$prn_val= isset($currentresult[$i]['NewCropPrescription']['prn'])?$currentresult[$i]['NewCropPrescription']['prn']:'' ;
												$daw_val= isset($currentresult[$i]['NewCropPrescription']['daw'])?$currentresult[$i]['NewCropPrescription']['daw']:'' ;
												$special_instruction_val= isset($currentresult[$i]['NewCropPrescription']['special_instruction'])?$currentresult[$i]['NewCropPrescription']['special_instruction']:'' ;
												$isactive_val= isset($currentresult[$i]['NewCropPrescription']['archive'])?$currentresult[$i]['NewCropPrescription']['archive']:'' ;
												$prescription_guid= isset($currentresult[$i]['NewCropPrescription']['PrescriptionGuid'])?$currentresult[$i]['NewCropPrescription']['PrescriptionGuid']:'' ;
												$dosage_form= isset($currentresult[$i]['NewCropPrescription']['DosageForm'])?$currentresult[$i]['NewCropPrescription']['DosageForm']:'' ;
												//if($isactive_val=='N'){
												$newcrop_table_id= isset($currentresult[$i]['NewCropPrescription']['id'])?$currentresult[$i]['NewCropPrescription']['id']:'' ;
												if($isactive_val=='N')
		                                        {
												   $isactive_val='1';
											    }
											     else if($isactive_val=='Y')
		                                        {
												     $isactive_val='0';
											    }
											   else
												  $isactive_val='1';

					               				//$special_instruction_value=isset($this->data['special_instruction'][$i])?$this->data['special_instruction'][$i]:'' ;
					               				?>
													<tr id="DrugGroup<?php echo $i;?>">
														<td align="left" valign="top" style="padding-right: 3px"><?php // echo $i;?>
															<?php echo $this->Form->input('', array('type'=>'text','class' => 'drugText' ,'id'=>"drugText_$i",'name'=> 'drugText[]','value'=>$drug_name_val,'autocomplete'=>'off','counter'=>$i,'style'=>'width:150px')); 
															echo $this->Form->hidden("",array('id'=>"drug_$i",'name'=>'drug_id[]','value'=>$drug_id_val));
															?>
															<span id="drugType_<?php echo $i?>"></span>&nbsp;<span id="formularylinkId_<?php echo $i?>"></span>
														</td>
														<td align="left" valign="top"><?php echo $this->Form->input('', array('empty'=>'Select','options'=>Configure :: read('dose_type'),'style'=>'width:80px','class' => 'dose_val','id'=>"dose_type$i",'name' => 'dose_type[]','value'=>$dose_val)); ?>
														</td>

														<td align="left" valign="top"><?php echo $this->Form->input('', array('empty'=>'Select','options'=>Configure :: read('strength'),'style'=>'width:80px','class' => '','id'=>"strength$i",'name' => 'strength[]','value'=>$strength_val));?>
														</td>

														<td align="left" valign="top"><?php echo $this->Form->input('', array('empty'=>'Select','options'=>Configure :: read('route_administration'),'style'=>'width:80px','class' => '','id'=>"route_administration$i",'name' => 'route_administration[]','value'=>$route_val)); ?>
														</td>

														<td align="left" valign="top"><?php echo $this->Form->input('', array('empty'=>'Select','options'=>Configure :: read('frequency'),'style'=>'width:80px','class' => 'frequency_value','id'=>"frequency$i",'name' => 'frequency[]','value'=>$frequency_val)); ?>
														</td>

														<td align="left" valign="top"><?php echo $this->Form->input('', array('size'=>2,'type'=>'text','class' => 'day','id'=>"day$i",'name' => 'day[]','value'=>$day_val)); ?>
														</td>

														<td align="left" valign="top"><?php echo $this->Form->input('', array('size'=>2,'type'=>'text','class' => '','id'=>"quantity$i",'name' => 'quantity[]','value'=>$quantity_val)); ?>
														</td>

														<td align="left" valign="top"><?php echo $this->Form->input('', array( 'options'=>Configure :: read('refills'),'empty'=>'Select','style'=>'width:80px','class' => '','id'=>"refills$i",'name' => 'refills[]','value'=>$refills_val));  ?>
														</td>

														<td align="center" valign="top"><?php $options = array('0'=>'No','1'=>'Yes');
														echo $this->Form->input('', array( 'options'=>$options,'class' => '','id'=>"prn$i",'name' => 'prn[]','value'=>$prn_val));?>
														</td>

														<td align="center" valign="top"><?php $option_daw = array('1'=>'Yes','0'=>'No');
														echo $this->Form->input('', array( 'options'=>$option_daw,'class' => '','id'=>"daw$i",'name' => 'daw[]','value'=>$daw_val));?>
														</td>

														<td width="20%" align="center" valign="top"><?php echo $this->Form->input('', array('type'=>'text','size'=>15, 'class'=>'my_start_date1 textBoxExpnd','readonly'=>'readonly','style'=>'width:130px','name'=> 'start_date[]','value'=>$start_date, 'id' =>"start_date".$i ,'counter'=>$count )); ?>
														</td>

														<td width="20%" align="center" valign="top"><?php echo $this->Form->input('', array('type'=>'text','size'=>15,'class'=>'my_end_date1 textBoxExpnd','readonly'=>'readonly','style'=>'width:130px','name'=> 'end_date[]','value'=>$end_date,'id' => "end_date".$i,'counter'=>$count)); ?>
														</td>
														<td align="center" valign="top"><?php $options_active = array('1'=>'Yes','0'=>'No');
														echo $this->Form->input('', array( 'options'=>$options_active,'class' => '','id'=>"isactive$i",'name' => 'isactive[]','value'=>$isactive_val));?>
														</td>
													</tr>
													<?php
													$i++ ;
					               			}
					               			?>
												</table>
											</td>
										</tr>
										<!-- row 3 end -->
										<tr>
											<td>&nbsp;</td>
											<td align="right" colspan="5"
												style="margin-top: 10px; float: right;"><input type="button"
												id="addButton" class="bluebtn" value="Add"> <?php if($count > 0){?>
												<input type="button" id="removeButton" class="bluebtn"
												value="Remove"> <?php }else{ ?> <input type="button"
												id="removeButton" value="Remove" style="display: none;"> <?php } ?>
											</td>
										</tr>

									</table>
								</td>
							</tr>
						</table>
						<!--EOF medicine -->
					</div>

				</td>
			</tr>
		</table>
	</tr>
	<?php //}?>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<?php //debug($this->params->query['signDone']);?>
		<td class="table_cell"></td>
		<td style="margin-top: 10px; float: right;"><?php  //echo $this->Html->link(__('Cancel'),$cancelBtnUrl,array('class'=>'blueBtn','div'=>false));?>
			&nbsp;<?php 
			if($this->params->query['signDone']=='yes'){
				?><font color="red"><?php echo ('This note is signed by '.$userSign['User']['first_name'].' '.$userSign['User']['last_name']);?></font></br></br>&nbsp;<?php 
				echo $this->Html->link(('Back'),array("controller" => "Appointments", "action" => "appointments_management"), array('class'=>'blueBtn','div'=>false,'id'=>''));
			}else{
				echo $this->Form->submit(__('Submit'), array('class'=>'blueBtn','div'=>false,'id'=>'submit'));
			}
			?>
			<?php 
			if($flag=='searchPatient'){
				echo $this->Html->link(('Back'),array("controller" => "Persons", "action" => "searchPatient"), array('class'=>'blueBtn','div'=>false,'id'=>''));
			}
			if($flag=='searchPerson'){
				echo $this->Html->link(('Back'),array("controller" => "Persons", "action" => "searchPerson"), array('class'=>'blueBtn','div'=>false,'id'=>''));
			}
			if($sign=='toSign' && $this->Session->read('role')=='Primary Care Provider'){
				echo $this->Html->link(('Co-sign'),array("controller" => "Persons", "action" => "signNote",'?'=>array('patientID'=>$patientID,'doctorID'=>$this->Session->read('userid'),'from'=>$this->params->query['from'])),array('class'=>'blueBtn','div'=>false,'id'=>'sign'));?>&nbsp;<?php 
				echo $this->Html->link(('Cancel'),array("controller" => "Appointments", "action" => "appointments_management"), array('class'=>'blueBtn','div'=>false,'id'=>''));
			}
			?>
		</td>
	</tr>
</table>
<?php echo $this->Form->end(); ?>
<?php $splitDate = explode(' ',$admissionDate);?>
<script>
$("#sign").click(function(){
	 if(confirm('Do you really want to sign note?')){
	 }else{
		return false;
	 }
});


$("#submit").click(function() {
	var validateMandatory = jQuery("#quickPatientRagistrationForm").validationEngine('validate');
	if(validateMandatory == false){
		return false;
	}
});
	
$( "#date" ).datepicker({
	showOn: "button",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	changeTime:true,
	maxDate: new Date(),
	showTime: true,  		
	yearRange: '1950',			 
	dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
});

$("#mode").change(function(){
	if($(this).val() == 'Other'){
		$("#otherCommunication").show();
	}else{
		$("#otherCommunication").hide();
	}
	
});

$(document).ready(function(){

	if($("#mode").val() == 'Other'){
		$("#otherCommunication").show();
	}else{
		$("#otherCommunication").hide();
	}
		
	//add n remove drud inputs
	var counter = <?php echo ($count)? $count : 3;?>;
	 $("#addButton").click(
				function() {
					$("#quickPatientRagistrationForm").validationEngine('detach'); 
					var newCostDiv = $(document.createElement('tr'))
					     .attr("id", 'DrugGroup' + counter);

					//var start= '<select style="width:80px;" id="start_date'+counter+'" class="" name="start_date[]"><input type="tex">';
					var str_option_value='<?php echo $str;?>';
								var route_option_value='<?php echo $str_route;?>';
								var dose_option_value='<?php echo $str_dose;?>';
								var dosage_form = '<select style="width:80px", id="strength'+counter+'" class="validate[required,custom[mandatory-select]] " name="strength[]"><option value="">Select</option><option value="12">tablet</option><option value="1">application</option><option value="2">capsule</option><option value="3">drop</option><option value="4">gm</option><option value="19">item</option><option value="5">lozenge</option><option value="17">mcg</option><option value="18">mg</option><option value="6">ml</option><option value="7">patch</option><option value="8">pill</option><option value="9">puff</option><option value="10">squirt</option><option value="11">suppository</option><option value="13">troche</option><option value="14">unit</option><option value="15">syringe</option><option value="16">package</option></select>';
					var dose_option ='<select style="width:80px;" id="dose_type'+counter+'" class="dose_val" name="dose_type[]"><option value="">Select</option>'+dose_option_value;
					var strength_option = '<select style="width:80px;" id="strength'+counter+'" class="" name="strength[]"><option value="">Select</option>'+str_option_value;
					var route_option = '<select style="width:80px;" id="route_administration'+counter+'" class="" name="route_administration[]"><option value="">Select</option>'+route_option_value;
					var frequency_option = '<select  style="width:80px", id="frequency'+counter+'" class="validate[required,custom[mandatory-select]] frequency frequency_value" name="frequency[]"><option value="">Select</option><option value="1">As directed</option><option value="2">Daily</option><option value="4">In the morning, before noon</option><option value="5">Twice a day</option><option value="6">Thrice a day</option><option value="7">Four times a day</option><option value="29">Every 2 hours</option><option value="28">Every 3 hours</option><option value="8">Every 4 hours</option><option value="9">Every 6 hours</option><option value="10">Every 8 hours</option><option value="11">Every 12 hours</option><option value="26">Every 48 hours</option><option value="23">Every 72 hours</option><option value="24">Every 4-6 hours</option><option value="13">Every 2 hours with assistance</option><option value="14">Every 1 week</option><option value="15">Every 2 weeks</option><option value="16">Every 3 weeks</option><option value="25">Every 1 hour with assistance</option><option value="12">Every Other Day</option><option value="27">2 Times Weekly</option><option value="20">3 Times Weekly</option><option value="22">Once a Month</option><option value="18">Nightly</option><option value="19">Every night at bedtime</option><option value="31">Stat</option><option value="32">Now</option></select>';
					var refills_option = '<select style="width:80px;" id="refills'+counter+'" class="" name="refills[]"><option value="">Select</option><option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option></select>';
					var prn_option = '<select  id="prn'+counter+'" class="" name="prn[]"><option value="0">No</option><option value="1">Yes</option></select>';
					var daw_option = '<select  id="daw'+counter+'" class="" name="daw[]"><option value="1">Yes</option><option value="0">No</option></select>';
					var active_option = '<select   id="isactive'+counter+'" class="" name="isactive[]"><option value="">Select</option><option value="0">No</option><option value="1">Yes</option></select>';
					//var route_opt = '<td><input type="text" size=2 value="" id="quantity'+counter+'" class="" name="quantity[]"></td>';
					var options = '<option value=""></option>';
					for (var i = 1; i < 25; i++) {
						if (i < 13) {
							str = i + 'am';
						} else {
							str = (i - 12) + 'pm';
						}
						options += '<option value="'+i+'"'+'>'
								+ str + '</option>';
					}

					timerHtml1 = '<td><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center"><tr><td width="25%" height="20" align="center" valign="top"><select class="first" style="width: 80px;" id="first_'+counter+'" disabled="" name="drugTime['+counter+'][]">'
							+ options
							+ '</select></td> ';
					timerHtml2 = '<td width="25%" height="20" align="center" valign="top"><select class="second" style="width: 80px;" id="second_'+counter+'" disabled="" name="drugTime['+counter+'][]">'
							+ options
							+ '</select></td> ';
					timerHtml3 = '<td width="25%" height="20" align="center" valign="top"><select class="third" style="width: 80px;" id="third_'+counter+'" disabled="" name="drugTime['+counter+'][]">'
							+ options
							+ '</select></td> ';
					timerHtml4 = '<td width="25%" height="20" align="center" valign="top"><select class="forth" style="width: 80px;" id="forth_'+counter+'" disabled="" name="drugTime['+counter+'][]">'
							+ options
							+ '</select></td> ';
					timer = timerHtml1 + timerHtml2
							+ timerHtml3 + timerHtml4
							+ '</tr></table></td>';
					<?php //echo $this->Form->input('', array('type'=>'text','size'=>16, 'class'=>'my_start_date','name'=> 'start_date[]', 'id' =>"start_date".$i ,'counter'=>$i )); ?>
					var newHTml = '<td valign="top"><input  type="text" style="width:150px" value="" id="drugText_' + counter + '"  class="drugText validate[optional,custom[onlyLetterNumber]]" name="drugText[]" autocomplete="off" counter='+counter+'>'+
							'<input  type="hidden"  id="drug_' + counter + '"  name="drug_id[]" ><span id="drugType_' + counter + '"></span>&nbsp;<span id="formularylinkId_' + counter + '"></span></td><td valign="top">'
							+ dose_option
							+ '</td><td valign="top">'
							+ dosage_form
							+ '</td><td valign="top">'
							+ route_option
							+ '</td><td valign="top">'
							+ frequency_option
							+ '</td>'
							+ '<td valign="top"><input size="2" type="text" value="" id="day'+counter+'" class="day" name="day[]"></td>'
							+ '<td valign="top"><input size="2" type="text" value="" id="quantity'+counter+'" class="" name="quantity[]"></td>'
							+ '<td valign="top">'
							+ refills_option
							+ '</td>'
							+ '<td valign="top" align="center">'
							+ prn_option
							+ '</td>'
							+ '<td valign="top" align="center">'
							+ daw_option
							+ '</td>'
							+ '<td valign="top" align="center"><input type="text" style="width:130px" value="" id="start_date' + counter + '"  class="my_start_date1 textBoxExpnd" readonly name="start_date[]"  size="15" counter='+counter+'></td>'
							+ '<td valign="top" align="center"><input type="text" style="width:130px" value="" id="end_date' + counter + '"  class="my_end_date1 textBoxExpnd" readonly name="end_date[]"  size="15" counter='+counter+'></td>'
						//	+ '<td valign="top" align="center" ><textarea id="special_instruction' + counter + '"  name="special_instruction[]" style="width:118px"  "size"="2" counter='+counter+'></textarea></td>'
							+ '<td valign="top" align="center">'
							+ active_option
							+ '</td>'
							;
																						
					newCostDiv.append(newHTml);		 
					newCostDiv.appendTo("#DrugGroup");		
					$("#diagnosisfrm").validationEngine('attach'); 			 			 
					counter++;
					if(counter > 0) $('#removeButton').show('slow');

					$(".my_start_date1").on("click",function() { 
						$(this).datepicker({
									changeMonth : true,
									changeYear : true,
									yearRange : '1950',
									minDate : new Date(explode[0], explode[1] - 1,
											explode[2]),
											dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
									showOn : 'button',
									buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
									buttonImageOnly : true,
									onSelect : function() {
										$(this).focus();
									}
								});
					});

					//For live click
					$('.drugText').on('focus',
		function() {
			var currentId=	$(this).attr('id').split("_"); // Important
			var attrId = this.id;
			var counter = $(this).attr("counter");
			if ($(this).val() == "") {
				$("#Pack" + counter).val("");
			}
			$(this).autocomplete( "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "pharmacyComplete","PharmacyItem",'name',"drug_id",'MED_STRENGTH','MED_STRENGTH_UOM','MED_ROUTE_ABBR','Status=A',"admin" => false,"plugin"=>false)); ?>",
							{
								
								width : 250,
								selectFirst : true,
								valueSelected:true,
								minLength: 3,
								delay: 1000,
								isOrderSet:true,
								showNoId:true,
								loadId : $(this).attr('id')+','+$(this).attr('id').replace("Text_",'_')+','+$(this).attr('id').replace("drugText_",'dose_type')
								+','+$(this).attr('id').replace("drugText_",'strength')
									+','+$(this).attr('id').replace("drugText_",'route_administration'),
									
									onItemSelect:function(event, ui) {
										//lastSelectedOrderSetItem
										var compositStringArray = lastSelectedOrderSetItem.split("    ");
										
										if((compositStringArray[1] !== undefined) && (compositStringArray[1] != '')){
											var pharmacyIdArray = compositStringArray[1].split("|");
											var doseId = attrId.replace("drugText_",'strength');
											var routeId = attrId.replace("drugText_",'route_administration');
											//var strengthId = attrId.replace("drugText_",'strength');
											var patientId = '<?php echo $pesonData['Patient']['id']?>';
											//var healthPlanId = '<?php echo $patientHealthPlanID?>';
											var drugId = compositStringArray[1].split("|");
											var drugId=drugId[0];

											//find the DrugType
											$.ajax({

												  url: "<?php echo $this->Html->url(array("controller" => 'notes', "action" => "getDrugType", "admin" => false)); ?>"+"/"+drugId,
												  dataType: 'html',
												  beforeSend:function(){
												    // this is where we append a loading image
												    $('#busy-indicator').show('fast');
													}, 	
													type: "POST",  
												  		  
												  	success: function(data){
												  		finData=data.split("~~~");

												  		var dosageFrm=<?php echo json_encode(Configure::read('selected_dosageform'));?>;
														var routeFrm=<?php echo json_encode(Configure::read('selected_route'));?>;
																									  		
												  		var drugType='<br/><strong>Drug Type :</strong>'+finData[0];
												  		
							                               $("#drugType_"+counter).html(drugType);
							                             //select route and dose
													  		
															if(routeFrm[finData[2]]!='')
															   $("#"+routeId).val(routeFrm[finData[2]]);
																																		
															if(dosageFrm[finData[1]]!='')
																$("#"+doseId).val(dosageFrm[finData[1]]);
															
														//end
															$('#busy-indicator').hide('slow');
												  			
												  	}				  			
												});
										
									/*	if(healthPlanId!="" || healthPlanId!="NULL")
										{
											
											
											
											//get formulary status
												$.ajax({

												  url: "<?php //echo $this->Html->url(array("controller" => 'notes', "action" => "getFormularyCoverage", "admin" => false)); ?>"+"/"+patientId+"/"+drugId+"/"+healthPlanId,
												/*  dataType: 'html',
												  beforeSend:function(){
												    // this is where we append a loading image
												    $('#busy-indicator').show('fast');
													}, 	
													type: "POST",  
												  		  
												  	success: function(data){
													  	var linkTxt=data.split("~");
												  		
												  		var formularylink='<br/><strong>Formulary Status : </strong><a title="'+linkTxt[1]+'"><span style="cursor: pointer; cursor: hand" id="collapse_id" onclick="selectAlternateDrug('+patientId+','+drugId+','+healthPlanId+','+counter+')">'+linkTxt[0]+'</span></a>';
							                               $("#formularylinkId_"+counter).html(formularylink);
															$('#busy-indicator').hide('slow');
												  			
												  	}				  			
												});
																						
										   
			                              
										}
									
										/*$("#"+routeId).val(pharmacyIdArray[3]);
										if($("#"+routeId).val() == ''){
											$("#"+routeId).append( new Option(pharmacyIdArray[3],pharmacyIdArray[3]) );
											if(pharmacyIdArray[3]!='')
											$("#"+routeId).val(pharmacyIdArray[3]);
												else
													$("#"+routeId).val('Select');
											$.ajax({

												  url: "<?php echo $this->Html->url(array("controller" => 'app', "action" => "saveConfiguration1", "admin" => false)); ?>",
												  context: document.body,	
												  beforeSend:function(){
												    // this is where we append a loading image
												    $('#busy-indicator').show('fast');
													}, 	
													type: "POST",  
												  	data:{putArea:pharmacyIdArray[3],searchArea:'route'},		  
												  	success: function(data){
															$('#busy-indicator').hide('slow');
												  			
												  	}				  			
												});
										}*/
									//	$("#"+doseId).val(pharmacyIdArray[1]);
										/*if($("#"+doseId).val() == ''){
											$("#"+doseId).append( new Option(pharmacyIdArray[1],pharmacyIdArray[1]) );
											
											if(pharmacyIdArray[1]!='')
												$("#"+doseId).val(pharmacyIdArray[1]);
											else
												$("#"+doseId).val('Select');
								
											$.ajax({

												  url: "<?php echo $this->Html->url(array("controller" => 'app', "action" => "saveConfiguration2", "admin" => false)); ?>",
												  context: document.body,	
												  beforeSend:function(){
												    // this is where we append a loading image
												    $('#busy-indicator').show('fast');
													}, 	
													type: "POST",  
												  	data:{putArea:pharmacyIdArray[1],searchArea:'dose'},		  
												  	success: function(data){
															$('#busy-indicator').hide('slow');
												  			
												  	}				  			
												});
										}*/
									}
									//$('input:checkbox[name=data[Note][no_medication]]').attr('checked',false);
									//document.getElementById("namecheck").checked = false;
									//$('.submit_button').show();
									//$('#namecheck').attr('disabled', true);
								}
								
							});
			
		});  //EOF autocomplete
		 


					var admissionDate = <?php echo json_encode($splitDate[0]); ?>;
					var explode = admissionDate.split('-');
					$(".my_end_date1").on("click",function() {
						
								$(this).datepicker({
											changeMonth : true,
											changeYear : true,
											yearRange : '1950',
											minDate : new Date(explode[0], explode[1] - 1,
													explode[2]),
													dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
											showOn : 'button',
											buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
														buttonImageOnly : true,
														onSelect : function() {
															$(this).focus();
														}
													});
								});
					
			     });
			 
			     $("#removeButton").click(function () {
						/*if(counter==3){
				          alert("No more textbox to remove");
				          return false;
				        }   	*/		 
						counter--;			 
				 
				        $("#DrugGroup" + counter).remove();
				 		if(counter == 0) $('#removeButton').hide('slow');
				  });
				  //EOF add n remove drug inputs

				  
	var admissionDate = <?php echo json_encode($splitDate[0]); ?>;
	var explode = admissionDate.split('-');
	$(".my_start_date1").on("click",function() {

				$(this).datepicker({
							changeMonth : true,
							changeYear : true,
							yearRange : '1950',
							minDate : new Date(explode[0], explode[1] - 1,
									explode[2]),
									dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
							showOn : 'button',
							buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
							buttonImageOnly : true,
							onSelect : function() {
								$(this).focus();
							}
						});
	});

	var admissionDate = <?php echo json_encode($splitDate[0]); ?>;
	var explode = admissionDate.split('-');
	$(".my_end_date1").on("click",function() {
		
				$(this).datepicker({
							changeMonth : true,
							changeYear : true,
							yearRange : '1950',
							minDate : new Date(explode[0], explode[1] - 1,
									explode[2]),
									dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
							showOn : 'button',
							buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
										buttonImageOnly : true,
										onSelect : function() {
											$(this).focus();
										}
									});
				});


	$('#namecheck').click(function ()
	{	currentId = $(this).attr('id') ;
		$('.submit_button').toggle();
		value = $(this).val();
		if(document.getElementById('namecheck').checked){
			$.ajax({
				  type : "POST",
				  url: "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "notesadd",$patient_id, "admin" => false)); ?>",
				  context: document.body,	
				  data : "value="+value,
				  beforeSend:function(){
					 // loading();
				  }, 	  		  
				  success: function(data){					  
					  //$('#busy-indicator').hide('fast');
					 // inlineMsg(currentId,'No madication Prescribed.');
				  }
			});			
		}			
	});  

	 $("#doctor_id_txt").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","DoctorProfile",'user_id',"doctor_name",'is_active=1','null','yes',"admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true,
			valueSelected:true,
			showNoId:true,
			loadId : 'doctor_id_txt,doctorID',
			onItemSelect:function () { 
				getDoctorSpecialty();
			}
		});
	 	getDoctorName();
	    getDoctorSpecialty();
		function getDoctorSpecialty(){
			var doctorId = $("#doctorID").val();
			if(doctorId)
			$.ajax({
	        	url: "<?php echo $this->Html->url(array("controller" => 'patients', "action" => "getDoctorsDept", "admin" => false)); ?>"+"/"+doctorId,
	        	context: document.body,          
				success: function(data){ 
	        		$('.department_id').val(parseInt(data)); 
				}
	        });
		}


		function getDoctorName(){
			var doctorId = $("#doctorID").val();
			if(doctorId)
			$.ajax({
	        	url: "<?php echo $this->Html->url(array("controller" => 'patients', "action" => "getDoctorsName", "admin" => false)); ?>"+"/"+doctorId,
	        	context: document.body,          
				success: function(data){ 
	        		$('#doctor_id_txt').val(data); 
				}
	        });
		}
		
		$('#doctor_id_txt').click(function(){
			$(this).val('');
			$("#doctorID").val('');	 
			$(".department_id").val(''); 
			$("#doctorID").validationEngine("hide");   
	    }); 



		/*if($("#doctor_id_txt").val() != ''){
			$("#doctorID").val("");
			$("#department_id").val("");
			$("#department_id_hidan").val("");
		}*/


		
		$('.drugText')
		.on(
				'focus',
				function() {
					var currentId=	$(this).attr('id').split("_"); // Important
					var attrId = this.id;
				var counter = $(this).attr(
							"counter");
					
					if ($(this).val() == "") {
						$("#Pack" + counter).val("");
					}
					$(this)
							.autocomplete(
																															
								"<?php echo $this->Html->url(array("controller" => "Notes", "action" => "pharmacyComplete","PharmacyItem",'name',"drug_id",'MED_STRENGTH','MED_STRENGTH_UOM','MED_ROUTE_ABBR','Status=A',"admin" => false,"plugin"=>false)); ?>",
								{
									
									width : 250,
									selectFirst : true,
									valueSelected:true,
									minLength: 3,
									delay: 1000,
									isOrderSet:true,
									showNoId:true,
									loadId : $(this).attr('id')+','+$(this).attr('id').replace("Text_",'_')+','+$(this).attr('id').replace("drugText_",'dose_type')
									+','+$(this).attr('id').replace("drugText_",'strength')
										+','+$(this).attr('id').replace("drugText_",'route_administration'),
											
										onItemSelect:function(event, ui) {
											//lastSelectedOrderSetItem
											var compositStringArray = lastSelectedOrderSetItem.split("    ");
											
											if((compositStringArray[1] !== undefined) && (compositStringArray[1] != '')){
												var pharmacyIdArray = compositStringArray[1].split("|");
												var doseId = attrId.replace("drugText_",'strength');
												var routeId = attrId.replace("drugText_",'route_administration');
												//var strengthId = attrId.replace("drugText_",'strength');
												var patientId = '<?php echo $pesonData['Patient']['id']?>';
												//var healthPlanId = '<?php echo $patientHealthPlanID?>';
												var drugId = compositStringArray[1].split("|");
												var drugId=drugId[0];

												//find the DrugType
												$.ajax({

													  url: "<?php echo $this->Html->url(array("controller" => 'notes', "action" => "getDrugType", "admin" => false)); ?>"+"/"+drugId,
													  dataType: 'html',
													  beforeSend:function(){
													    // this is where we append a loading image
													    $('#busy-indicator').show('fast');
														}, 	
														type: "POST",  
													  		  
													  	success: function(data){
													  		finData=data.split("~~~");

													  		var dosageFrm=<?php echo json_encode(Configure::read('selected_dosageform'));?>;
															var routeFrm=<?php echo json_encode(Configure::read('selected_route'));?>;
																										  		
													  		var drugType='<br/><strong>Drug Type :</strong>'+finData[0];
													  		
								                               $("#drugType_"+counter).html(drugType);
								                             //select route and dose
														  		
																if(routeFrm[finData[2]]!='')
																   $("#"+routeId).val(routeFrm[finData[2]]);
																																			
																if(dosageFrm[finData[1]]!='')
																	$("#"+doseId).val(dosageFrm[finData[1]]);
																
															//end
																$('#busy-indicator').hide('slow');
													  			
													  	}				  			
													});
											
											/*if(healthPlanId!="")
											{
												
												
												
												//get formulary status
													$.ajax({

													  url: "<?php echo $this->Html->url(array("controller" => 'notes', "action" => "getFormularyCoverage", "admin" => false)); ?>"+"/"+patientId+"/"+drugId+"/"+healthPlanId,
													  dataType: 'html',
													  beforeSend:function(){
													    // this is where we append a loading image
													    $('#busy-indicator').show('fast');
														}, 	
														type: "POST",  
													  		  
													  	success: function(data){
														  	var linkTxt=data.split("~");
													  		
													  		var formularylink='<br/><strong>Formulary Status : </strong><a title="'+linkTxt[1]+'"><span style="cursor: pointer; cursor: hand" id="collapse_id" onclick="selectAlternateDrug('+patientId+','+drugId+','+healthPlanId+','+counter+')">'+linkTxt[0]+'</span></a>';
								                               $("#formularylinkId_"+counter).html(formularylink);
																$('#busy-indicator').hide('slow');
													  			
													  	}				  			
													});
																							
											   
				                              
											}
										
											/*$("#"+routeId).val(pharmacyIdArray[3]);
											if($("#"+routeId).val() == ''){
												$("#"+routeId).append( new Option(pharmacyIdArray[3],pharmacyIdArray[3]) );
												if(pharmacyIdArray[3]!='')
												$("#"+routeId).val(pharmacyIdArray[3]);
													else
														$("#"+routeId).val('Select');
												$.ajax({

													  url: "<?php echo $this->Html->url(array("controller" => 'app', "action" => "saveConfiguration1", "admin" => false)); ?>",
													  context: document.body,	
													  beforeSend:function(){
													    // this is where we append a loading image
													    $('#busy-indicator').show('fast');
														}, 	
														type: "POST",  
													  	data:{putArea:pharmacyIdArray[3],searchArea:'route'},		  
													  	success: function(data){
																$('#busy-indicator').hide('slow');
													  			
													  	}				  			
													});
											}*/
										//	$("#"+doseId).val(pharmacyIdArray[1]);
											/*if($("#"+doseId).val() == ''){
												$("#"+doseId).append( new Option(pharmacyIdArray[1],pharmacyIdArray[1]) );
												
												if(pharmacyIdArray[1]!='')
													$("#"+doseId).val(pharmacyIdArray[1]);
												else
													$("#"+doseId).val('Select');
									
												$.ajax({

													  url: "<?php echo $this->Html->url(array("controller" => 'app', "action" => "saveConfiguration2", "admin" => false)); ?>",
													  context: document.body,	
													  beforeSend:function(){
													    // this is where we append a loading image
													    $('#busy-indicator').show('fast');
														}, 	
														type: "POST",  
													  	data:{putArea:pharmacyIdArray[1],searchArea:'dose'},		  
													  	success: function(data){
																$('#busy-indicator').hide('slow');
													  			
													  	}				  			
													});
											}*/
										}
										//$('input:checkbox[name=data[Note][no_medication]]').attr('checked',false);
										//document.getElementById("namecheck").checked = false;
										//$('.submit_button').show();
										//$('#namecheck').attr('disabled', true);
									}
							});
		});//EOF autocomplete

	});//EOF doc ready

	$(".drugText").addClass(
		"validate[optional,custom[onlyLetterNumber]]");
		jQuery("#quickPatientRagistrationForm").validationEngine();

		
		$(document).on('change', '.frequency_value', function(){
			currentId = $(this).attr('id') ;
			Id = currentId.slice(-1);
	  		if($('#dose_type'+Id).val()=="" || $('#frequency'+Id).val()==""){
	  			$('#quantity'+Id).val("");
				return false;
			}else if($('#frequency'+Id).val()=='31'){ 
				$('#day'+Id).val('1');
	  			freq='1';
				dose=$('#dose_type'+Id+' option:selected').text();
				if(dose=='0.5/half')dose='0.5';
				if(dose=='1-2')dose='2';
				if(dose=='1-3')dose='3';
				if(dose=='2-3')dose='3';
				if(dose=='0.33/third')dose='0.33';
				if(dose=='0.5-1')dose='1';
				qty=(dose)*(freq);
				qtyId=$('#quantity'+Id).val(qty);
				 
	  		}else if($(this).val()=='32'){
	  			$('#day'+Id).val('1');
	  			freq='1';
				dose=$('#dose_type'+Id+' option:selected').text();
				if(dose=='0.5/half')dose='0.5';
				if(dose=='1-2')dose='2';
				if(dose=='1-3')dose='3';
				if(dose=='2-3')dose='3';
				if(dose=='0.33/third')dose='0.33';
				if(dose=='0.5-1')dose='1';
				qty=(dose)*(freq);
				qtyId=$('#quantity'+Id).val(qty);
	  		}else{
		  		freq_val = <?php echo json_encode(Configure::read('frequency_value'));?>;
				freq=$(this).val();
				dose=$('#dose_type'+Id+' option:selected').text();
				if(dose=='0.5/half')dose='0.5';
				if(dose=='1-2')dose='2';
				if(dose=='1-3')dose='3';
				if(dose=='2-3')dose='3';
				if(dose=='0.33/third')dose='0.33';
				if(dose=='0.5-1')dose='1';
				freq_val1=freq_val[$.trim(freq)];
				qty=(dose)*(freq_val1);
				qtyId=$('#quantity'+Id).val(qty);
				$('#day'+Id).val("30");
			}
		});

		$(document).on('change','.dose_val',function(){
			currentId = $(this).attr('id') ;
			Id = currentId.slice(-1);
			//alert($('#frequency'+Id).val());

			if($('#dose_type'+Id).val()=="" || $('#frequency'+Id).val()==""){
				$('#quantity'+Id).val("");
				return false;
			}else if($('#frequency'+Id).val()=='31'){ 
				$('#day'+Id).val('1');
				doseID=$(this).attr('id');
				dose=$('#'+doseID+' option:selected').text();
				if(dose=='0.5/half')dose='0.5';
				if(dose=='1-2')dose='2';
				if(dose=='1-3')dose='3';
				if(dose=='2-3')dose='3';
				if(dose=='0.33/third')dose='0.33';
				if(dose=='0.5-1')dose='1';
				freq='1';
				qty=(dose)*(freq); 
				qtyId=$('#quantity'+Id).val(qty);
	  		}else if($('#frequency'+Id).val()=='32'){ 
	  			$('#day'+Id).val('1');
				doseID=$(this).attr('id');
				dose=$('#'+doseID+' option:selected').text();
				if(dose=='0.5/half')dose='0.5';
				if(dose=='1-2')dose='2';
				if(dose=='1-3')dose='3';
				if(dose=='2-3')dose='3';
				if(dose=='0.33/third')dose='0.33';
				if(dose=='0.5-1')dose='1';
				freq='1';
				qty=(dose)*(freq); 
				qtyId=$('#quantity'+Id).val(qty);
	  		}else{
				doseID=$(this).attr('id');
				dose=$('#'+doseID+' option:selected').text();
				if(dose=='0.5/half')dose='0.5';
				if(dose=='1-2')dose='2';
				if(dose=='1-3')dose='3';
				if(dose=='2-3')dose='3';
				if(dose=='0.33/third')dose='0.33';
				if(dose=='0.5-1')dose='1';
				freq=$('#frequency'+Id).val();
				freq_val = <?php echo json_encode(Configure::read('frequency_value'));?>;
				freq_val1=freq_val[$.trim(freq)];
				qty=(dose)*(freq_val1);
				qtyId=$('#quantity'+Id).val(qty);
				$('#day'+Id).val("30");
			}
		});

		$(document).on('keyup','.day',function(){
			days=$(this).val();
			currentId = $(this).attr('id') ;
			Id = currentId.slice(-1);
			if($(this).val()=="" || $('#dose_type'+Id).val()=="" || $('#frequency'+Id).val()==""){
				$('#quantity'+Id).val("");
			}else{
				dose=$('#dose_type'+Id+' option:selected').text();
				if(dose=='0.5/half')dose='0.5';
				if(dose=='1-2')dose='2';
				if(dose=='1-3')dose='3';
				if(dose=='2-3')dose='3';
				if(dose=='0.33/third')dose='0.33';
				if(dose=='0.5-1')dose='1';
				freqency=$('#frequency'+Id+' option:selected').text();
				if(freqency=='As directed'||freqency=='Daily'||freqency=='In the morning, before noon'||freqency=='Nightly' || freqency=='Every night at bedtime' || freqency=='Fasting' || freqency=='Now' || freqency=='Stat')freqency='1';
				if(freqency=='Twice a day'||freqency=='Every 12 hours')freqency='2';
				if(freqency=='Thrice a day'||freqency=='Every 8 hours')freqency='3';
				if(freqency=='Four times a day'||freqency=='Every 6 hours' ||freqency=='Every 4-6 hours')freqency='4';
				if(freqency=='Every 3 hours'||freqency=='Every 2 hours with assistance')freqency='8';
				if(freqency=='Every 48 hours'||freqency=='Every Other Day')freqency='0.5';
				if(freqency=='Every 2 hours')freqency='12';
				if(freqency=='Every 4 hours')freqency='6';
				if(freqency=='Every 72 hours')freqency='0.33';
				if(freqency=='Every 1 week')freqency='0.1429';
				if(freqency=='Every 2 weeks')freqency='0.0714';
				if(freqency=='Every 3 weeks')freqency='0.0476';
				if(freqency=='Every 1 hour with assistance')freqency='16';
				if(freqency=='2 Times Weekly')freqency='0.2857';
				if(freqency=='3 Times Weekly')freqency='0.4856';
				if(freqency=='Once a Month')freqency='0.0333';
				
				qty=dose*freqency*days;
				$('#quantity'+Id).val(qty);
			}
		});
</script>
