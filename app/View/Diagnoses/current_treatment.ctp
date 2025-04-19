<div class="inner_title">
	<h3 style="font-size:13px; margin-left: 5px;">
		<?php  echo __('Current Medication'); ?>
	</h3>
</div>
<p class="ht5"></p>
<?php  

if(empty($patientHealthPlanID))
	$patientHealthPlanIDfreq=0;
else
	$patientHealthPlanIDfreq=$patientHealthPlanID;

echo $this->Html->script(array('jquery.autocomplete','jquery.blockUI'));
echo $this->Html->css(array('jquery.autocomplete.css'));


if($status == "success"){

?>
		<script> 
			jQuery(document).ready(function() { 
			//parent.location.reload(true);
			//parent.$.fancybox.close(); 
		});
		</script>
<?php   } ?>
<?php 
//echo $this->Form->create('NewCropPrescription',array('id'=>'diagnosisfrm','inputDefaults' => array('label' => false,'div' => false,'error'=>false)));
echo $this->Form->create('NewCropPrescription',array('id'=>'diagnosisfrm','url'=>array('controller'=>'Diagnoses','action'=>'currentTreatment',$this->request->query['patientId']),
		'inputDefaults' => array('label' => false, 'div' => false,'error'=>false )));
echo $this->Form->hidden('patientId',array('id'=>'patientId','value'=>$personId,'autocomplete'=>"off"));
echo $this->Form->hidden('patientUId',array('id'=>'patientUId','value'=>$patientUid,'autocomplete'=>"off"));
echo $this->Form->hidden('patient_uniqueid',array('id'=>'patient_uniqueid','value'=>$patientId,'autocomplete'=>"off")); 
?>
<div class="message" id="flashMessage" style="display:none;"><!-- flash Message --></div>

<?php if($flag=='notPresent'){?>
<div align="center">
	<font color="red"><?php echo __('Drug is not present in our database, so select alternate drug.', true); ?></font>
	<?php echo $this->Form->button(__('Change Drug'), array('id'=>'changeMed','label'=> false,'div' => false,'error' => false,'class'=>'blueBtn' )); ?>
</div>
<div align="center">
	<?php echo $this->Form->input('NewCropPrescription.newMed', array('options'=>$temp,'empty'=>'Select alternate drug','class' => '','id' => 'newMed','label'=> false,'style'=>'display:none; width:250px'));?>
</div>
<?php }?>

<table id='loading' class="tdLabel" style="text-align: left;" width="100%">
	<tr>
		<td width="100%" colspan='14'>
			<div class="message" id='successMsg'
				style='display: none; color: green; text-align: center'>
				<!-- Show  sevirity  -->
			</div>
		</td>
	</tr>
				<tr>
				<td width="100%" colspan='14'>
					<div id='showInteractions' style="color:red;"><!-- Interaction Data --></div>
					<div id='allergyInteractions' style="color:red;"><!-- Interaction Allergy Data --></div>
				</td>
				
			</tr>
			<tr style='border: none !important;' id="tr2">
								<td width="10%" colspan='2'>
									<div id='overRide' style='display:none;border: none;'>
										<?php
												echo $this->Form->input(__('Override Instructions'),array('name'=>'override_inst[]','class'=>'','id'=>'overText','type'=>'text'));?>
									</div>
								</td>
								<td width="50%" colspan='15'>
									<div id='overRideButton' style='display:none;border: none;'>
										<?php echo $this->Html->link(__('Override Instructions'),'javascript:void(0)',array('id'=>'oversubmit','class'=>'blueBtn','onclick'=>'save_med("1");'));?>
									</div>
								</td>
							</tr>
			
			<tr>
				<td width="100%" valign="top" align="left" style="padding: 2px;"
					colspan="4">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabularForm">
						<!-- row 1 -->
						<tr>
							<td width="100%" valign="top" align="left" colspan="6">
								<table width="100%" border="0" cellspacing="1" cellpadding="0"
									id='DrugGroup' class="tabularForm">
									<tr>
										<td width="1%" height="20" align="left" valign="top">Drug Name</td>
										<td width="2%" height="20" align="left" valign="top">Dosage</td>
										<td width="4%" height="20" align="left" valign="top">Dosage Form</td>
										<td width="2%" height="20" align="left" valign="top">Route</td>
										<td width="3%" align="left" valign="top">Frequency</td>
									<!-- <td width="5%" align="left" valign="top">Strength</td>-->
										<td width="3%" align="left" valign="top">Days</td>
										<td width="2%" align="left" valign="top">Qty</td>
										<td width="1%" align="left" valign="top" >Refills</td>
										<td width="2%" align="center" valign="top" >As Needed (p.r.n)</td>
										<td width="2%" align="center" valign="top" >Dispense As Written
										</td>
										<td  align="left" valign="top" class="tdLabel" style="width:11%">First Dose Date/Time</td>
										<td  align="left" 	valign="top" class="tdLabel" style="width:11%">Stop Date/Time</td>
									<!--<td width="7%" align="center" valign="top">Special Instruction</td>-->
										<td width="3%" align="center" valign="top">Active</td>
										
										<td width="3%" align="center" valign="top">Action</td>
										
									</tr>

									<?php  
									
									if(isset($currentresult) && !empty($currentresult)){
									$readonly='readonly';
			               				
                                     $count  = count($currentresult) ;
                                     if($count<=1)
                                     	$count  = 1 ;
			               			}else{
			               				$count  = 1 ;
			               				$readonly='';
			               			}
			               			for($i=0;$i<$count;){
										$start_date=$this->DateFormat->formatDate2Local($currentresult[$i][NewCropPrescription][firstdose],Configure::read('date_format'),true);
										$end_date=$this->DateFormat->formatDate2Local($currentresult[$i][NewCropPrescription][stopdose],Configure::read('date_format'),true);
										$crossID= isset($currentresult[$i]['NewCropPrescription']['id'])?$currentresult[$i]['NewCropPrescription']['id']:'' ;
										$drug_name_val_core= isset($currentresult[$i]['NewCropPrescription']['drug_name'])?$currentresult[$i]['NewCropPrescription']['description']:'' ;
										$drug_name_val=stripslashes($drug_name_val_core);
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
									
									?>
									<tr id="DrugGroup<?php echo $i;?>">
										<td align="left"><?php// echo $i;?> <?php echo $this->Form->input('', array('type'=>'text','class' => 'medName validate[required,custom[customname]] input_width drugText','readonly'=>$readonly,'id'=>"drugText_$i",'name'=> 'NewCropPrescription[drug_name][]','value'=>$drug_name_val,'autocomplete'=>'off','counter'=>$i,'style'=>'width: 271px !important;'));?>
										<?php echo $this->Form->hidden('drugId',array('class'=>'allHiddenId','id'=>"drug_$i" ,'name'=>'NewCropPrescription[drug_id][]','value'=>$drug_id_val));
										echo $this->Form->hidden('newcroptableid',array('id'=>"newcroptableid_$i" ,'name'=>'NewCropPrescription[newcroptableid][]','value'=>$newcrop_table_id));
										echo $this->Form->hidden('drugId',array('id'=>"prescriptionguid_$i" ,'name'=>'NewCropPrescription[PrescriptionGuid][]','value'=>$prescription_guid));
										?>
										<span id="drugType_<?php echo $i?>"></span>&nbsp;<span id="formularylinkId_<?php echo $i?>"></span>
										</td>
										
										<td align="left" valign="top"><?php echo $this->Form->input('', array( 'empty'=>'Select','options'=>Configure :: read('dose_type'),'style'=>'width:80px','class' => 'validate[required,custom[mandatory-select]] dose_val','id'=>"dose_type$i",'name' => 'NewCropPrescription[dose][]','value'=>$dose_val)); ?>
										</td>
										<td align="left" valign="top"><?php echo $this->Form->input('', array( 'options'=>Configure :: read('strength'),'style'=>'width:80px','empty'=>'Select','class' => 'validate[required,custom[mandatory-select]]','id'=>"dosageform_$i",'name' => 'NewCropPrescription[DosageForm][]','value'=>$dosage_form)); ?>
										</td>
										
										<td align="left" valign="top"><?php echo $this->Form->input('', array( 'empty'=>'Select','options'=>Configure :: read('route_administration'),'style'=>'width:80px','class' => 'validate[required,custom[mandatory-select]]','id'=>"route_administration$i",'name' => 'NewCropPrescription[route][]','value'=>$route_val));?>
										</td>
										<td align="left" valign="top"><?php echo $this->Form->input('', array( 'options'=>Configure :: read('frequency'),'style'=>'width:80px','empty'=>'Select','class' => 'validate[required,custom[mandatory-select]] frequency_value','id'=>"frequency$i",'name' => 'NewCropPrescription[frequency][]','value'=>$frequency_val)); ?>
										</td>
								<!-- 	 <td align="left"><?php echo $this->Form->input('', array('empty'=>'Select','options'=>$strenght,'style'=>'width:80px','class' => '','id'=>"strength$i",'name' => 'NewCropPrescription[strength][]','value'=>$strength_val));?>
										</td>-->
										<td align="left" valign="top"><?php echo $this->Form->input('', array('size'=>2,'type'=>'text','class' => 'day','autocomplete'=>'off','id'=>"day$i",'name' => 'NewCropPrescription[day][]','value'=>$day_val)); ?>
										</td>
										<td align="left" valign="top"><?php	echo $this->Form->input('', array('size'=>2,'type'=>'text','class' => '','id'=>"quantity$i",'autocomplete'=>'off','name' => 'NewCropPrescription[quantity][]','value'=>$quantity_val)); ?>
										</td>
										<td align="left" valign="top"><?php echo $this->Form->input('', array( 'options'=>Configure :: read('refills'),'empty'=>'Select','style'=>'width:80px','class' => '','id'=>"refills$i",'name' => 'NewCropPrescription[refills][]','value'=>$refills_val));  ?>
										</td>
										<td align="center" valign="top"><?php $options = array('0'=>'No','1'=>'Yes');
										echo $this->Form->input('', array( 'options'=>$options,'style'=>'width:57px','class' => '','id'=>"prn$i",'name' => 'NewCropPrescription[prn][]','value'=>$prn_val));?>
										</td>
										<td align="center" valign="top"><?php $option1= array('1'=>'Yes','0'=>'No');
										echo $this->Form->input('', array( 'options'=>$option1,'style'=>'width:63px','class' => '','id'=>"daw$i",'name' => 'NewCropPrescription[daw][]','value'=>$daw_val));?>
										</td>
										
										<td align="center" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array('type'=>'text','size'=>16, 'class'=>'my_start_date1 textBoxExpnd','name'=> 'NewCropPrescription[start_date][]','value'=> $start_date, 'id' =>"start_date".$i ,'counter'=>$count,'label'=>false )); ?>
										</td>
			
										<td align="center" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array('type'=>'text','size'=>16,'class'=>'my_end_date1 textBoxExpnd','name'=> 'NewCropPrescription[end_date][]','value'=>$end_date,'id' => "end_date".$i,'counter'=>$count,'label'=>false)); ?>
										</td>
										
									<!-- <td align="center"><?php //echo $this->Form->textarea('', array('size'=>2,'style'=>'width:125px','type'=>'text','class' => '','id'=>"special_instruction$i",'name' => 'NewCropPrescription[special_instruction][]','value'=>$special_instruction_val));?>
										</td> -->	
										<td align="center" valign="top"><?php $options_active = array('1'=>'Yes','0'=>'No');
										echo $this->Form->input('', array( 'options'=>$options_active,'style'=>'width:63px','class' => '','id'=>"isactive$i",'name' => 'NewCropPrescription[is_active][]','value'=>$isactive_val));
										?></td>
										
										
										<td align="center" style="padding:5px 0 0 20px;" valign="top"><?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete','class'=>'DrugGroup_history','id'=>"pMH$i"._."$crossID"));?>
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
						<?php if(empty($currentresult)){?>
						<tr>
							<td align="Left" colspan="5"><input type="button" id="addButton" value="Add Row"> 
							<?php //if($count > 0){?><!--  <input type="button" id="removeButton" value="Remove">  -->
							<?php //}else{ ?> <input type="button" id="removeButton" value="Remove" style="display: none;"> <?php //} ?></td>
						</tr>
						<?php }?>
						
						<tr>
							
							<td align='left'>
							
							<?php if(empty($currentresult)){
								echo $this->Html->link('Frequently Prescribed Medication','javascript:void(0)',array('onclick'=>'frequentMedication('.$patientUid.','.$patientHealthPlanIDfreq.');'));
							}?>	</td>
							
							<td align="right">
							<?php echo $this->Html->link(__('Back'), array('controller'=>'Diagnoses','action' => 'initialAssessment',$this->request->query['patientId'],$this->Session->read('diagnosesID'),$appointmentID), array('class'=>'blueBtn'));?>
							<?php echo $this->Html->link('Update Medication','javascript:void(0)',array('class'=>'blueBtn','id'=>'submit','div'=>false,'label'=>false,'onclick'=>'save_med();'));?>
							</td>
						</tr>
						<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
			</table>
					
				</td>
			</tr>
		</table>
<?php echo $this->Form->end(); ?>
<div style="padding-left:20px;" id="formularyData"></div>

<script>
$("#diagnosisfrm").submit(function(){
	 loading('loading','id');
});
//add n remove drud inputs
var counter = <?php echo $count?>;
var calenderAry = new Array();

$("#addButton")
	.click(
			function() {
				$("#diagnosisfrm").validationEngine('detach'); 
				var newCostDiv = $(document.createElement('tr'))
				     .attr("id", 'DrugGroup' + counter);

				//var start= '<select style="width:80px;" id="start_date'+counter+'" class="" name="start_date[]"><input type="tex">';
								var str_option_value='<?php echo $str;?>';
								var route_option_value='<?php echo $str_route;?>';
								var dose_option_value='<?php echo $str_dose;?>';

								var dose_option ='<select style="width:80px;" id="dose_type'+counter+'" class="validate[required,custom[mandatory-select]] dose_val" name="NewCropPrescription[dose][]"><option value="">Select</option>'+dose_option_value;
								var dosage_form = '<select style="width:80px", id="dosageform_'+counter+'" class="validate[required,custom[mandatory-select]] dosageform" name="NewCropPrescription[DosageForm][]"><option value="">Select</option><option value="12">tablet</option><option value="1">application</option><option value="2">capsule</option><option value="3">drop</option><option value="4">gm</option><option value="19">item</option><option value="5">lozenge</option><option value="17">mcg</option><option value="18">mg</option><option value="6">ml</option><option value="7">patch</option><option value="8">pill</option><option value="9">puff</option><option value="10">squirt</option><option value="11">suppository</option><option value="13">troche</option><option value="14">unit</option><option value="15">syringe</option><option value="16">package</option></select>';
								var route_option = '<select style="width:80px;" id="route_administration'+counter+'" class="validate[required,custom[mandatory-select]] frequency" name="NewCropPrescription[route][]"><option value="">Select</option>'+route_option_value;
				//var frequency_option = '<select  style="width:80px", id="frequency'+counter+'" class="validate[required,custom[mandatory-select]] frequency frequency_value" name="NewCropPrescription[frequency][]"><option value="">Select</option><option value="1">as directed</option><option value="2">Daily</option><option value="4">in A.M.</option><option value="5">BID</option><option value="6">TID</option><option value="7">QID</option><option value="29">Q2h</option><option value="28">Q3h</option><option value="8">Q4h</option><option value="9">Q6h</option><option value="10">Q8h</option><option value="11">Q12h</option><option value="26">Q48h</option><option value="23">Q72h</option><option value="24">Q4-6h</option><option value="13">Q2h WA</option><option value="14">Q1wk</option><option value="15">Q2wks</option><option value="16">Q3wks</option><option value="25">Q1h WA</option><option value="12">Every Other Day</option><option value="27">2 Times Weekly</option><option value="20">3 Times Weekly</option><option value="22">Once a Month</option><option value="18">Nightly</option><option value="19">QHS</option></select>';

				var frequency_option = '<select  style="width:80px", id="frequency'+counter+'" class="validate[required,custom[mandatory-select]] frequency frequency_value" name="NewCropPrescription[frequency][]"><option value="">Select</option><option value="1">As directed</option><option value="2">Daily</option><option value="4">In the morning, before noon</option><option value="5">Twice a day</option><option value="6">Thrice a day</option><option value="7">Four times a day</option><option value="29">Every 2 hours</option><option value="28">Every 3 hours</option><option value="8">Every 4 hours</option><option value="9">Every 6 hours</option><option value="10">Every 8 hours</option><option value="11">Every 12 hours</option><option value="26">Every 48 hours</option><option value="23">Every 72 hours</option><option value="24">Every 4-6 hours</option><option value="13">Every 2 hours with assistance</option><option value="14">Every 1 week</option><option value="15">Every 2 weeks</option><option value="16">Every 3 weeks</option><option value="25">Every 1 hour with assistance</option><option value="12">Every Other Day</option><option value="27">2 Times Weekly</option><option value="20">3 Times Weekly</option><option value="22">Once a Month</option><option value="18">Nightly</option><option value="19">Every night at bedtime</option><option value="35">Fasting</option><option value="31">Stat</option><option value="32">Now</option></select>';
				var strength_option = '<select style="width:93px;" id="strength'+counter+'" class="frequency" name="NewCropPrescription[strength][]"><option value="">Select</option>'+str_option_value;
				var refills_option = '<select style="width:80px;" id="refills_'+counter+'" class="frequency" name="NewCropPrescription[refills][]"><option value="">Select</option><option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option></select>';
				var prn_option = '<select style="width:57px;" id="prn'+counter+'" class="" name="NewCropPrescription[prn][]"><option value="0">No</option><option value="1">Yes</option></select>';
				var daw_option = '<select style="width:63px;" id="daw'+counter+'" class="" name="NewCropPrescription[daw][]"><option value="1">Yes</option><option value="0">No</option></select>';
				var active_option = '<select style="width:63px;" id="isactive'+counter+'" class="" name="NewCropPrescription[is_active][]"><option value="1">Yes</option><option value="0">No</option></select>';
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
				var newHTml = '<td valign="top"><input  type="text" style="width:271px !important" value="" id="drugText_' + counter + '"  class="validate[required,custom[customname]] input_width drugText  ac_input" name="NewCropPrescription[drug_name][]" autocomplete="off" counter='+counter+'><input  type="hidden" class="allHiddenId" id="drug_' + counter + '"  name="NewCropPrescription[drug_id][]" ><span id="drugType_' + counter + '"></span>&nbsp;<span id="formularylinkId_' + counter + '"></span></td><td valign="top">'
				
						+ dose_option
						+ '</td><td valign="top">'
						+ dosage_form
						+ '</td><td valign="top">'
						+ route_option
						+ '</td><td valign="top">'
						+ frequency_option
						+ '</td>' 
						+ '<td valign="top"><input size="2" type="text" value="" id="day'+counter+'" class="day" name="NewCropPrescription[day][]" autocomplete="off"></td>'
						+ '<td valign="top"><input size="2" type="text" value="" id="quantity'+counter+'" class="" name="NewCropPrescription[quantity][]" autocomplete="off"></td>'
						+ '<td valign="top">'
						+ refills_option
						+ '</td>'
						+ '<td valign="top" align="center">'
						+ prn_option
						+ '</td>'
						+ '<td valign="top" align="center">'
						+ daw_option
						+ '</td>'
						+ '<td valign="top" align="center"><input  type="text" value="" id="start_date' + counter + '"  class="my_start_date1 textBoxExpnd" name="NewCropPrescription[start_date][]"  size="16" counter='+counter+'></td>'
						+ '<td valign="top" align="center"><input  type="text" value="" id="end_date' + counter + '"  class="my_end_date1 textBoxExpnd" name="NewCropPrescription[end_date][]"  size="16" counter='+counter+'></td>'
						+ '<td valign="top" align="center">'
						+ active_option
						+ '</td><td width="20" style="padding: 5px 0px 0px 20px;" valign="top"><span class="DrugGroup_history" id=pMH'+counter+'><?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete'));?></td>';
						
				newCostDiv.append(newHTml);		 
				newCostDiv.appendTo("#DrugGroup");		
				$("#diagnosisfrm").validationEngine('attach'); 
				$("#start_date"+ counter).datepicker({
					showOn : 'both',
					changeYear : true,
					changeMonth : true,
					yearRange : '1950',
					buttonText: "Calendar",
					buttonImageOnly : true,
					dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
					minDate:new Date(<?php echo $this->General->minDate(date('Y-m-d')); ?>),
					//minDate:new Date(),
					buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
					onSelect : function() {
						var thisId = $(this).attr('id');
						var thisCounter  = thisId.replace("start_date", ""); 
						var selDate = $(this).val();
						spltDate = selDate.split(' ');
						spltDate[0] = spltDate[0].split('/');
						spltDate[0][1]--;
						spltDate = spltDate[0]+','+spltDate[1];
						$('#end_date'+ thisCounter ).datepicker('option', {
				 			minDate: new Date(spltDate)
					    });
						$(this).focus();
						$('#end_date'+ thisCounter ).val('');
					}
				});
				
				$("#end_date"+counter).datepicker({
					changeMonth : true,
					changeYear : true,
					yearRange : '1950',
					dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
					showOn : 'both',
					buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
					buttonImageOnly : true,
					buttonText: "Calendar",
					onSelect : function() {
						var thisId = $(this).attr('id');
						var thisCounter  = thisId.replace("end_date", ""); 
						if($("#start_date"+ thisCounter == '').val() == '') $(this).val('');
					}
				}); 			 
				counter++;
				if(counter > <?php echo $count?>) $('#removeButton').show('slow');
				
		     });
$(document).ready(function(){
	var endDate = $("#start_date0").val();
	spltEndDate = endDate.split(' ');
	spltEndDate[0] = spltEndDate[0].split('/');
	spltEndDate[0][1]--;
	spltEndDate = spltEndDate[0]+','+spltEndDate[1];
	 	$("#start_date0").datepicker({
			showOn : 'both',
			changeYear : true,
			changeMonth : true,
			yearRange : '1950',
			buttonText: "Calendar",
			buttonImageOnly : true,
			dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
			minDate:new Date(<?php echo $this->General->minDate(date('Y-m-d')); ?>),
			buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			onSelect : function() {
				var selDate = $(this).val();
				spltDate = selDate.split(' ');
				spltDate[0] = spltDate[0].split('/');
				spltDate[0][1]--;
				spltDate = spltDate[0]+','+spltDate[1];
				$('#end_date0').datepicker('option', {
		 			minDate: new Date(spltDate)
			    });
				$("#end_date0").val('');
				$(this).focus();
			}
		});
		
		$("#end_date0").datepicker({
			changeMonth : true,
			changeYear : true,
			yearRange : '1950',
			dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
			showOn : 'both',
			buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly : true,
			buttonText: "Calendar",
			minDate: new Date(spltEndDate),
			onSelect : function() {
				if($("#start_date0").val() == '') $(this).val('');
			}
		});
	
});
		     $("#removeButton").click(function () {
					/*if(counter==3){
			          alert("No more textbox to remove");
			          return false;
			        }   	*/		 
					counter--;			 
			 
			        $("#DrugGroup" + counter).remove();
			 		if(counter == <?php echo $count?>) $('#removeButton').hide('slow');
			  });
			  //EOF add n remove drug inputs
			  
			  		
	//$('.drugText').on('focus',function() {
		$(document).on('focus', '.drugText', function() {//console.log(this);
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
												var doseId = attrId.replace("drugText_",'dosageform_');
												var routeId = attrId.replace("drugText_",'route_administration');
												var strengthId = attrId.replace("drugText_",'strength');
												var patientId = '<?php echo $patientId?>';
												var healthPlanId = '<?php echo $patientHealthPlanID?>';
												var drugId = compositStringArray[1].split("|");
												var drugId=drugId[0];
												//alert(routeId);
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

												
												
												if(healthPlanId!="")
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


			//--------------------------------------------- -to use live() in datepicker---------------------------------


			//var admissionDate = <?php //echo json_encode($splitDate[0]); ?>;
			//	var explode = admissionDate.split('-');
				var selDate = '';
						$("#start_date0").datepicker({
							showOn : 'both',
							changeYear : true,
							changeMonth : true,
							yearRange : '1950',
							buttonText: "Calendar",
							buttonImageOnly : true,
							dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
							minDate:new Date(<?php echo $this->General->minDate(date('Y-m-d')); ?>),
							buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
							onSelect : function() {
								selDate = $(this).val();
								spltDate = selDate.split(' ')
								$('#end_date0').datepicker('option', {
						 			minDate: new Date(spltDate[0])
							    });
								$(this).focus();
							}
						});
						
						$("#end_date0").datepicker({
							changeMonth : true,
							changeYear : true,
							yearRange : '1950',
							dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
							showOn : 'both',
							buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
							buttonImageOnly : true,
							buttonText: "Calendar",
							onSelect : function() {
								if(selDate == '') $(this).val('');
							}
						});
			//---------------------------------------------end of the datepicker------------------------------------------------
			

			$('#submit')
			.click(
					function() { 
						var validateDiagnosis = jQuery("#diagnosisfrm").validationEngine('validate');
						if (validateDiagnosis) {
							$(this).css('display', 'none');
						}else{
							return false ;
						}
					});

		$(document).on('change', '.frequency_value', function(){
			currentId = $(this).attr('id') ;
			Id = currentId.slice(-1);
	  		if($('#frequency'+Id).val()=='31'){ 
				$('#day'+Id).val('1');
	  			freq='1';
				dose=$('#dose_type'+Id+' option:selected').text();
				if($('#dose_type'+Id).val()=='')dose='1';
				if(dose=='0.5/half')dose='0.5';
				if(dose=='1-2')dose='2';
				if(dose=='1-3')dose='3';
				if(dose=='2-3')dose='3';
				if(dose=='0.33/third')dose='0.33';
				if(dose=='0.5-1')dose='1';
				qty=(dose)*(freq);
				qtyId=$('#quantity'+Id).val(qty);
				$('#dose_type'+Id).val('2'); 
	  		}else if($(this).val()=='32'){
	  			$('#day'+Id).val('1');
	  			freq='1';
				dose=$('#dose_type'+Id+' option:selected').text();
				if($('#dose_type'+Id).val()=='')dose='1';
				if(dose=='0.5/half')dose='0.5';
				if(dose=='1-2')dose='2';
				if(dose=='1-3')dose='3';
				if(dose=='2-3')dose='3';
				if(dose=='0.33/third')dose='0.33';
				if(dose=='0.5-1')dose='1';
				qty=(dose)*(freq);
				qtyId=$('#quantity'+Id).val(qty);
				$('#dose_type'+Id).val('2');
	  		}else if($('#dose_type'+Id).val()=="" || $('#frequency'+Id).val()==""){
	  			$('#quantity'+Id).val("");
				return false;
			}else {
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


		 $(document).on('click','.DrugGroup_history',function (){
			currentId = $(this).attr('id') ;
	  		splittedVar = currentId.split("_");		 
	  		Id = splittedVar[1];
	  		if(!Id){
        		alert("Please Save Medication First");
        		return false;
    		}
	  		if(confirm("Do you really want to delete this record?")){
		        var trId = $(this).attr('id').replace("pMH","DrugGroup");
		        $('#' + trId).remove();
		    	counter--;			 
		    	if(counter == 0) $('#removeButton').hide('slow');
		    }else{
				return false;
		    }

	    	patientId = '<?php echo $patientId;?>';
	    	patientUid = '<?php echo $patientUid;?>';
	    	appointmentID = '<?php echo $this->request->query['appt_id'] ?>';
    		is_deleted='1';
				$.ajax({
				  type : "POST",
				  url: "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "currentTreatment",$patientId,"admin" => false)); ?>"+"/null/"+patientUid+"/"+is_deleted+"/"+Id,
				  context: document.body,	
				  beforeSend:function(){
					  loading('loading','id');
				  }, 	  		  
				  success: function(data){
					window.location.href="<?php echo $this->Html->url(array("controller"=>'Diagnoses',"action" => "initialAssessment",$this->request->query['patientId']));?>"+"/null/"+appointmentID+"?msg=saved",
					$('#flashMessage', parent.document).html("Medication Deleted Successfully.");
					$('#flashMessage', parent.document).show();
					onCompleteRequest('loading','id')();
				  }
				});			
				
		 });
		//******************TO save medication by ajax Aditya*****************************
		function save_med(isOverride){
			var checkExit='0';
			var validateDiagnosis = jQuery("#diagnosisfrm").validationEngine('validate');
			if (validateDiagnosis) {
				$(this).css('display', 'none');
			}else{
				return false ;
			}
			jQuery('.allHiddenId').each(function() {
			    var currentElement = $(this);
				var value = currentElement.val(); 
			    if(value==''){
			    	 var currentElementId = $(this).attr('id');
					   var faultValue=currentElementId.split('_');
					   var faultNameById=$('#drugText_'+faultValue['1']).val();
				   		// alert(faultNameById+':Is not a valid drug please select other.');
				    checkExit++;
			    	
			    }
			});
		
			if(checkExit>0){
				//alert(checkExit);
				//return false;
			}
			
			if((isOverride!='1')||(isOverride==='undefined')){
				isOverride='0';
			}
			else{
				var chkConfrim=confirm('Are you sure you want to Override the Instructions?');
				if($.trim(chkConfrim)=='false'){
					 $('#successMsg').show();
					 $('#successMsg').html("Please change the medication.");
					 $('#busy-indicator').hide('fast');
					 return false;
				}
				else{
					if($('#overText').val()==''){
						alert('Please fill the Override text.')
						 return false;
						}
				}
				isOverride=isOverride;
			}
			var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'Diagnoses', "action" => "save_med","admin" => false)); ?>"+"/"+isOverride;
			var ClinicalEffects='';
			$.ajax({
				type : "POST",
				data:$('#diagnosisfrm').serialize(),
				url : ajaxUrl , 
				beforeSend : function() {
					 $('#busy-indicator').show('fast');
	        		},
				//context : document.body,
				success: function(data){
					if((data != '') && (data !== undefined) && (data != 1)){
						data = jQuery.parseJSON(data);
						
						if(data.DrugDrug != null ){
							$.each(data.DrugDrug,function(index,value){
								ClinicalEffects+=value;
								ClinicalEffects += '</br>';
							});
								$('#showInteractions').show();
								$('#overRideButton').show();
								$('#overRide').show();
								$('#allergyInteractions').show();
								
								//overRideButton  overRide
								$('#showInteractions').html(ClinicalEffects);

								$('#showsevirity').show();
								$('#showsevirity').html(ClinicalEffects);
							 
						}
						else{
							$('#showsevirity').html("");
						}
						
						
						var allergy='';
						if(data.Interaction.rowDta!= null){
						$.each(data.Interaction.rowDta,function(index,value){
							allergy+=value;
							allergy += '</br>';
						});
					  //  var interactionData=data.Interaction;
					    //$('#interactionData').show();
						$('#allergyInteractions').show();
						$('#allergyInteractions').html("ALLERGY INTERACTION:<br/>"+allergy);
					}
						else{
							$('#allergyInteractions').html("");
						}
						$('#overRide').show();
						$('#overRideButton').show();
						 $('#busy-indicator').hide('fast');
						return false;
					
					}else{
						 $('#showsevirity').hide();
							$('#showInteractions').hide();
							$('#overRide').hide();
							$('#overRideButton').hide();
							$('#interactionData').hide();
						    $('#busy-indicator').hide('fast');
						    
							window.location.href='<?php echo $this->Html->url(array("controller"=>'Diagnoses',"action" => "initialAssessment",$this->request->query['patientId'],$this->Session->read('diagnosesID'),$appointmentID,'?'=>array('msg'=>'saved')));?>'
						    $( '#flashMessage', parent.document).html("Medication saved succesfully.");
							$('#flashMessage', parent.document).show();
						
					}
					},
				
				error: function(message){
				alert("Connection Error please try after some time.");
				}
				
			});
		}
		//EOF

		function frequentMedication(patientId,healthPlanId)
		{
			$.ajax({
			     type: 'POST',
			     url:  "<?php echo $this->Html->url(array("controller" => 'Diagnoses', "action" => "getFrequentMedication", "admin" => false)); ?>"+"/"+patientId+"/"+healthPlanId,
			     dataType: 'html',
			     beforeSend:function(){ 
			    	 $('#busy-indicator').show('fast');; 
			     },
			     success: function(data){		
			    	  data = data.trim();	
			    	  if(data != ''){
			    		  $("#formularyData").html(data);
				      }else{
				    	  inlineMsg(id,$('#loading-text').html(),10); 
				      }
			    	  $('#busy-indicator').hide('fast');; 
			     },
				 error: function(message){
					  inlineMsg(id,$('#loading-text').html(),5); 	     
			     }        
			});
		}

		function selectAlternateDrug(patientId,drugId,healthPlanId,sequenceNo)
		{
			$.ajax({
			     type: 'POST',
			     url:  "<?php echo $this->Html->url(array("controller" => 'notes', "action" => "getAlternateDrugFormulary", "admin" => false)); ?>"+"/"+patientId+"/"+drugId+"/"+healthPlanId+"/"+sequenceNo,
			     dataType: 'html',
			     beforeSend:function(){ 
			    	 $('#busy-indicator').show('fast');; 
			     },
			     success: function(data){		
			    	  data = data.trim();	
			    	  if(data != ''){
			    		  $("#formularyData").html(data);
				      }else{
				    	  inlineMsg(id,$('#loading-text').html(),10); 
				      }
			    	  $('#busy-indicator').hide('fast');; 
			     },
				 error: function(message){
					  inlineMsg(id,$('#loading-text').html(),5); 	     
			     }        
			});
		}
		/*----------------EOF-----------------------*/	 

$('#changeMed').click(function(){
	$('#newMed').show();
	return false;
});

$('#newMed').change(function(){ 
	if($(this).val() !=""){
		valmed=document.getElementById("newMed").options[document.getElementById('newMed').selectedIndex].text;
		$('.medName').val(valmed);
		$('.allHiddenId').val($(this).val());
	}
});
</script>		