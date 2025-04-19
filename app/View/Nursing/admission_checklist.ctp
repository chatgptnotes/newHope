<?php //pr($patientData);exit;?><style>
.tddate img{float:right;}
</style>
<?php
  echo $this->Html->script('jquery.autocomplete');
  echo $this->Html->css('jquery.autocomplete.css');  
?>
<style>
	.tabularForm td td{
	padding:0px;
	font-size:13px;
	color:#e7eeef;
	background:#1b1b1b;
	}
	.tabularForm th td{
	padding:0px;
	font-size:13px;
	color:#e7eeef;
	background:none;
	}
   
.patientHub .patientInfo .heading {
    float: left;
    width: 174px;
}
</style>
<script>
$(document).ready(function(){

	jQuery("#itemfrm").validationEngine({
	validateNonVisibleFields: true,
	updatePromptsPosition:true,
	});
	$('#save')
	.click(
	function() { 
	//alert("hello");
	var validatePerson = jQuery("#itemfrm").validationEngine('validate');
	//alert(validatePerson);
	if (validatePerson) {$(this).css('display', 'none');}
//	return false;
	});
	});

	$(document).ready(function(){
		 $("#date").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',
			maxDate: new Date(),
			dateFormat:'<?php echo $this->General->GeneralDate("HH:II");?>',
			
		});
	});
</script>

<div class="inner_title">
  <h3><?php echo __('MRN Check List'); ?></h3>
  <span> <?php echo $this->Html->link(__('Back', true),array('controller'=>'nursings','action' => 'patient_information/',$this->params['pass'][0]), array('escape' => false,'class'=>'blueBtn'));?>
	</span>
 </div>
 <?php echo $this->element('patient_information');?>
   <p class="ht5"></p> 
   <form name="itemfrm" id="itemfrm" action="<?php echo $this->Html->url(array("controller" => $this->params['controller'], "action" => "admission_checklist/".$this->params['pass'][0])); ?>" method="post" >
   <table width="100%" cellpadding="0" cellspacing="0" border="0" align="right" style="color:#000000;">
		<tr>
			<td width="4%" style="margin: 15px 0 0 10px;" align="left">Date :<font color="red">*</font>&nbsp;</td>
			<td class="tddate" align="left" width="5%">
			<?php 
				if(!empty($this->request->data['AdmissionChecklist']['date'])){
					$split = explode(' ',$this->request->data['AdmissionChecklist']['date']);
					
					$this->request->data['AdmissionChecklist']['date'] = $this->DateFormat->formatDate2Local($split[0],Configure::read('date_format')).' '.$this->request->data['AdmissionChecklist']['time'];
				}
				echo $this->Form->input('AdmissionChecklist.date', array('type'=>'text','id'=>'date','label'=> false, 'div' => false,'class' => 'validate[required,custom[mandatory-date]] textBoxExpnd', 'error' => false,'readonly'=>'readonly'));
			?>
			</td>
			<td width="65%"></td>
		</tr>
	</table>
	<div class="clr ht5"></div>	
	<table width="99%" border="0" cellspacing="1" cellpadding="0" class="tabularForm">
	  <tr>
		 <th width="37" align="center">Sr. No.</th>
		 <th width="400" align="center">Particulars</th>
		 <th colspan="2">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td  colspan="2" align="center" height="25" valign="top" style="border-bottom:1px solid #3e474a;">Completion</td>
				</tr>
				<tr>
					<td width="50%" align="center" height="25">Yes</td>
					<td width="50%" align="center">No</td>
				</tr>
			</table>                         </th>
		 <th align="center">Remark</th>
	  </tr>
	  <tr>
		<td>1.</td>
		<td width="">Patient's File</td>	
		 <?php 
			 if(isset($this->data['AdmissionChecklist']['patient_file']) && $this->data['AdmissionChecklist']['patient_file']=="Yes"){?>
				<td width="30%" align="center"><input id="PatientFileNo" type="radio" value="Yes" checked= "checked" name="data[AdmissionChecklist][patient_file]"></td>
				<td width="30%" align="center"><input id="PatientFileNo" type="radio" value="No"  name="data[AdmissionChecklist][patient_file]"></td>	
		<?php }else{ ?>
				<td width="30" align="center"><input id="PatientFileNo" type="radio" value="Yes" name="data[AdmissionChecklist][patient_file]"></td>
				<td width="30" align="center"><input id="PatientFileNo" type="radio" value="No"  checked= "checked" name="data[AdmissionChecklist][patient_file]"></td>	
		<?php }	?>
		
		<td width="35%" style="padding-left:33px;"><?php echo $this->Form->input('AdmissionChecklist.patient_file_remark',array('legend'=>false,'class'=>'textBoxExpnd','label'=>false,'div'=>false));?></td>
	  </tr>
	  <tr>
		<td>2.</td>
		<td>Deposit Receipt</td>
		 <?php 
			 if(isset($this->data['AdmissionChecklist']['deposit_receipt']) && $this->data['AdmissionChecklist']['deposit_receipt']=="Yes"){?>
				<td align="center"><input id="deposit_receiptYes" type="radio" value="Yes" checked="checked" name="data[AdmissionChecklist][deposit_receipt]"></td>
				<td align="center"><input id="deposit_receipteNo" type="radio" value="No" name="data[AdmissionChecklist][deposit_receipt]"></td>
		<?php }else{ ?>
				<td align="center"><input id="deposit_receiptYes" type="radio" value="Yes" name="data[AdmissionChecklist][deposit_receipt]"></td>
				<td align="center"><input id="deposit_receipteNo" type="radio" value="No" checked="checked" name="data[AdmissionChecklist][deposit_receipt]"></td>
		<?php }	?>
		<td width="20%" style="padding-left:33px;"><?php echo $this->Form->input('AdmissionChecklist.deposit_receipt_remark',array('legend'=>false,'class'=>'textBoxExpnd','label'=>false,'div'=>false));?></td>
	  </tr>
	  <tr>
		<td>3.</td>
		<td>Identification Band</td>
		<?php 
			 if(isset($this->data['AdmissionChecklist']['identification_band']) && $this->data['AdmissionChecklist']['identification_band']=="Yes"){?>
				<td align="center"><input id="identification_bandYes" type="radio" value="Yes" checked="checked" name="data[AdmissionChecklist][identification_band]"></td>
				<td align="center"><input id="identification_bandNo" type="radio" value="No"  name="data[AdmissionChecklist][identification_band]"></td>
		<?php }else{ ?>
				<td align="center"><input id="identification_bandYes" type="radio" value="Yes" name="data[AdmissionChecklist][identification_band]"></td>
				<td align="center"><input id="identification_bandNo" type="radio" value="No" checked="checked" name="data[AdmissionChecklist][identification_band]"></td>
		<?php }	?>
		<td width="20%" style="padding-left:33px;"><?php echo $this->Form->input('AdmissionChecklist.identification_band_remark',array('legend'=>false,'class'=>'textBoxExpnd','label'=>false,'div'=>false));?></td>
	  </tr>
	  <tr>
		<td>4.</td>
		<td>Assessment Form</td>
		<?php 
			 if(isset($this->data['AdmissionChecklist']['assessment_form']) && $this->data['AdmissionChecklist']['assessment_form']=="Yes"){?>
				<td align="center"><input id="assessment_formYes" type="radio" value="Yes" checked="checked" name="data[AdmissionChecklist][assessment_form]"></td>
				<td align="center"><input id="assessment_formNo" type="radio" value="No"  name="data[AdmissionChecklist][assessment_form]"></td>
		<?php }else{ ?>
				<td align="center"><input id="assessment_formYes" type="radio" value="Yes" name="data[AdmissionChecklist][assessment_form]"></td>
				<td align="center"><input id="assessment_formNo" type="radio" value="No" checked="checked" name="data[AdmissionChecklist][assessment_form]"></td>
		<?php }	?>
		<td width="20%" style="padding-left:33px;"><?php echo $this->Form->input('AdmissionChecklist.assessment_form_remark',array('legend'=>false,'class'=>'textBoxExpnd','label'=>false,'div'=>false));?></td>
	  </tr>
	  <tr>
		<td>5.</td>
		<td>Unit Readiness</td>
		<?php 
			 if(isset($this->data['AdmissionChecklist']['unit_readiness']) && $this->data['AdmissionChecklist']['unit_readiness']=="Yes"){?>
				<td align="center"><input id="unit_readinessYes" type="radio" value="Yes" checked="checked" name="data[AdmissionChecklist][unit_readiness]"></td>
				<td align="center"><input id="unit_readinessNo" type="radio" value="No"  name="data[AdmissionChecklist][unit_readiness]"></td>
		<?php }else{ ?>
			<td align="center"><input id="unit_readinessYes" type="radio" value="Yes" name="data[AdmissionChecklist][unit_readiness]"></td>
			<td align="center"><input id="unit_readinessNo" type="radio" value="No" checked="checked" name="data[AdmissionChecklist][unit_readiness]"></td>
		<?php }	?>
		<td width="20%" style="padding-left:33px;"><?php echo $this->Form->input('AdmissionChecklist.unit_readiness_remark',array('legend'=>false,'class'=>'textBoxExpnd','label'=>false,'div'=>false));?></td>
	  </tr>
	  <tr>
		<td>6.</td>
		<td>Orientation to Patient</td>
		<?php 
			 if(isset($this->data['AdmissionChecklist']['orientation_to_patient']) && $this->data['AdmissionChecklist']['orientation_to_patient']=="Yes"){?>
				<td align="center"><input id="orientation_to_patientYes" type="radio" value="Yes" checked="checked" name="data[AdmissionChecklist][orientation_to_patient]"></td>
				<td align="center"><input id="orientation_to_patienteNo" type="radio" value="No" name="data[AdmissionChecklist][orientation_to_patient]"></td>
		<?php }else{ ?>
				<td align="center"><input id="orientation_to_patientYes" type="radio" value="Yes" name="data[AdmissionChecklist][orientation_to_patient]"></td>
				<td align="center"><input id="orientation_to_patienteNo" type="radio" value="No" checked="checked" name="data[AdmissionChecklist][orientation_to_patient]"></td>
		<?php }	?>
		<td width="20%" style="padding-left:33px;"><?php echo $this->Form->input('AdmissionChecklist.orientation_to_patient_remark',array('legend'=>false,'class'=>'textBoxExpnd','label'=>false,'div'=>false));?></td>
	  </tr>
	  <tr>
		<td>7.</td>
		<td>Orientation to Relative</td>
		<?php 
			 if(isset($this->data['AdmissionChecklist']['orientation_to_relative']) && $this->data['AdmissionChecklist']['orientation_to_relative']=="Yes"){?>
				<td align="center"><input id="orientation_to_relativeYes" type="radio" value="Yes" checked="checked" name="data[AdmissionChecklist][orientation_to_relative]"></td>
				<td align="center"><input id="orientation_to_relativeNo" type="radio" value="No" name="data[AdmissionChecklist][orientation_to_relative]"></td>
		<?php }else{ ?>
				<td align="center"><input id="orientation_to_relativeYes" type="radio" value="Yes" name="data[AdmissionChecklist][orientation_to_relative]"></td>
				<td align="center"><input id="orientation_to_relativeNo" type="radio" value="No" checked="checked" name="data[AdmissionChecklist][orientation_to_relative]"></td>
		<?php }	?>
		<td width="20%" style="padding-left:33px;"><?php echo $this->Form->input('AdmissionChecklist.orientation_to_relative_remark',array('legend'=>false,'class'=>'textBoxExpnd','label'=>false,'div'=>false));?></td>
	  </tr>
	  <tr>
		<td>8.</td>
		<td>Patient Uniform</td>
		<?php 
			 if(isset($this->data['AdmissionChecklist']['patient_uniform']) && $this->data['AdmissionChecklist']['patient_uniform']=="Yes"){?>
				<td align="center"><input id="patient_uniformYes" type="radio" value="Yes" checked="checked" name="data[AdmissionChecklist][patient_uniform]"></td>
				<td align="center"><input id="patient_uniformNo" type="radio" value="No" name="data[AdmissionChecklist][patient_uniform]"></td>
		<?php }else{ ?>
				<td align="center"><input id="patient_uniformYes" type="radio" value="Yes" name="data[AdmissionChecklist][patient_uniform]"></td>
				<td align="center"><input id="patient_uniformNo" type="radio" value="No" checked="checked" name="data[AdmissionChecklist][patient_uniform]"></td>
		<?php }	?>
		<td width="20%" style="padding-left:33px;"><?php echo $this->Form->input('AdmissionChecklist.patient_uniform_remark',array('legend'=>false,'class'=>'textBoxExpnd','label'=>false,'div'=>false));?></td>
	  </tr>
	  <tr>
		<td>9.</td>
		<td>Drinking Water</td>
		<?php 
			 if(isset($this->data['AdmissionChecklist']['drinking_water']) && $this->data['AdmissionChecklist']['drinking_water']=="Yes"){?>
				<td align="center"><input id="drinking_waterYes" type="radio" value="Yes" checked="checked" name="data[AdmissionChecklist][drinking_water]"></td>
				<td align="center"><input id="drinking_waterNo" type="radio" value="No" name="data[AdmissionChecklist][drinking_water]"></td>
		<?php }else{ ?>
				<td align="center"><input id="drinking_waterYes" type="radio" value="Yes" name="data[AdmissionChecklist][drinking_water]"></td>
				<td align="center"><input id="drinking_waterNo" type="radio" value="No" checked="checked" name="data[AdmissionChecklist][drinking_water]"></td>
		<?php }	?>
		<td width="20%" style="padding-left:33px;"><?php echo $this->Form->input('AdmissionChecklist.drinking_water_remark',array('legend'=>false,'class'=>'textBoxExpnd','label'=>false,'div'=>false));?></td>
	  </tr>
	  <tr>
		<td>10.</td>
		<td>Glass with Cover</td>
		<?php 
			 if(isset($this->data['AdmissionChecklist']['glass_with_cover']) && $this->data['AdmissionChecklist']['glass_with_cover']=="Yes"){?>
				<td align="center"><input id="glass_with_coverYes" type="radio" value="Yes" checked="checked" name="data[AdmissionChecklist][glass_with_cover]"></td>
				<td align="center"><input id="glass_with_coverNo" type="radio" value="No" name="data[AdmissionChecklist][glass_with_cover]"></td>
		<?php }else{ ?>
				<td align="center"><input id="glass_with_coverYes" type="radio" value="Yes" name="data[AdmissionChecklist][glass_with_cover]"></td>
				<td align="center"><input id="glass_with_coverNo" type="radio" value="No" checked="checked" name="data[AdmissionChecklist][glass_with_cover]"></td>
		<?php }	?>
		<td width="20%" style="padding-left:33px;"><?php echo $this->Form->input('AdmissionChecklist.glass_with_cover_remark',array('legend'=>false,'class'=>'textBoxExpnd','label'=>false,'div'=>false));?></td>
	  </tr>
	  <tr>
		<td>11.</td>
		<td>Information to RMO</td>
		<?php 
			 if(isset($this->data['AdmissionChecklist']['information_to_rmo']) && $this->data['AdmissionChecklist']['information_to_rmo']=="Yes"){?>
				<td align="center"><input id="information_to_rmoYes" type="radio" value="Yes" checked="checked" name="data[AdmissionChecklist][information_to_rmo]"></td>
				<td align="center"><input id="information_to_rmoNo" type="radio" value="No" name="data[AdmissionChecklist][information_to_rmo]"></td>
		<?php }else{ ?>
				<td align="center"><input id="information_to_rmoYes" type="radio" value="Yes"  name="data[AdmissionChecklist][information_to_rmo]"></td>
				<td align="center"><input id="information_to_rmoNo" type="radio" value="No" checked="checked" name="data[AdmissionChecklist][information_to_rmo]"></td>
		<?php }	?>
		<td width="20%" style="padding-left:33px;"><?php echo $this->Form->input('AdmissionChecklist.information_to_rmo_remark',array('legend'=>false,'class'=>'textBoxExpnd','label'=>false,'div'=>false));?></td>
	  </tr>
	  <tr>
		<td>12.</td>
		<td>Information to Consultant</td>
		<?php 
			 if(isset($this->data['AdmissionChecklist']['information_to_consultant']) && $this->data['AdmissionChecklist']['information_to_consultant']=="Yes"){?>
				<td align="center"><input id="information_to_consultantYes" type="radio" value="Yes" checked="checked" name="data[AdmissionChecklist][information_to_consultant]"></td>
				<td align="center"><input id="information_to_consultantNo" type="radio" value="No" name="data[AdmissionChecklist][information_to_consultant]"></td>
		<?php }else{ ?>
				<td align="center"><input id="information_to_consultantYes" type="radio" value="Yes" name="data[AdmissionChecklist][information_to_consultant]"></td>
				<td align="center"><input id="information_to_consultantNo" type="radio" value="No" checked="checked" name="data[AdmissionChecklist][information_to_consultant]"></td>
		<?php }	?>
		<td width="20%" style="padding-left:33px;"><?php echo $this->Form->input('AdmissionChecklist.information_to_consultant_remark',array('legend'=>false,'class'=>'textBoxExpnd','label'=>false,'div'=>false));?></td>
	  </tr>
	  <tr>
		<td>13.</td>
		<td>Vital Signs Checked</td>
		<?php 
			 if(isset($this->data['AdmissionChecklist']['vital_sign_checked']) && $this->data['AdmissionChecklist']['vital_sign_checked']=="Yes"){?>
				<td align="center"><input id="vital_sign_checkedYes" type="radio" value="Yes" checked="checked" name="data[AdmissionChecklist][vital_sign_checked]"></td>
				<td align="center"><input id="vital_sign_checkedNo" type="radio" value="No" name="data[AdmissionChecklist][vital_sign_checked]"></td>
		<?php }else{ ?>
				<td align="center"><input id="vital_sign_checkedYes" type="radio" value="Yes" name="data[AdmissionChecklist][vital_sign_checked]"></td>
				<td align="center"><input id="vital_sign_checkedNo" type="radio" value="No" checked="checked" name="data[AdmissionChecklist][vital_sign_checked]"></td>
		<?php }	?>
		<td width="20%" style="padding-left:33px;"><?php echo $this->Form->input('AdmissionChecklist.vital_sign_checked_remark',array('legend'=>false,'class'=>'textBoxExpnd','label'=>false,'div'=>false));?></td>
	  </tr>
	  <tr>
		<td>14.</td>
		<td>Preparation for OT</td>
		<?php 
			 if(isset($this->data['AdmissionChecklist']['preparation_for_ot']) && $this->data['AdmissionChecklist']['preparation_for_ot']=="Yes"){?>
				<td align="center"><input id="preparation_for_otYes" type="radio" value="Yes" checked="checked" name="data[AdmissionChecklist][preparation_for_ot]"></td>
				<td align="center"><input id="preparation_for_otNo" type="radio" value="No" name="data[AdmissionChecklist][preparation_for_ot]"></td>
		<?php }else{ ?>
				<td align="center"><input id="preparation_for_otYes" type="radio" value="Yes" name="data[AdmissionChecklist][preparation_for_ot]"></td>
				<td align="center"><input id="preparation_for_otNo" type="radio" value="No" checked="checked" name="data[AdmissionChecklist][preparation_for_ot]"></td>
		<?php }	?>
		<td width="20%" style="padding-left:33px;"><?php echo $this->Form->input('AdmissionChecklist.preparation_for_ot_remark',array('legend'=>false,'class'=>'textBoxExpnd','label'=>false,'div'=>false));?></td>
	  </tr>
	  <tr>
		<td>15.</td>
		<td>Information to Dietician</td>
		<?php 
			 if(isset($this->data['AdmissionChecklist']['information_to_dieticion']) && $this->data['AdmissionChecklist']['information_to_dieticion']=="Yes"){?>
				<td align="center"><input id="information_to_dieticionYes" type="radio" value="Yes" checked="checked" name="data[AdmissionChecklist][information_to_dieticion]"></td>
				<td align="center"><input id="information_to_dieticionNo" type="radio" value="No" name="data[AdmissionChecklist][information_to_dieticion]"></td>
		<?php }else{ ?>
				<td align="center"><input id="information_to_dieticionYes" type="radio" value="Yes" name="data[AdmissionChecklist][information_to_dieticion]"></td>
				<td align="center"><input id="information_to_dieticionNo" type="radio" value="No" checked="checked" name="data[AdmissionChecklist][information_to_dieticion]"></td>
		<?php }	?>
		<td width="20%" style="padding-left:33px;"><?php echo $this->Form->input('AdmissionChecklist.information_to_dieticion_reamrk',array('legend'=>false,'class'=>'textBoxExpnd','label'=>false,'div'=>false));?></td>
	  </tr>
	  <tr>
		<td>16.</td>
		<td>Diet Given in Time</td>
		<?php 
			 if(isset($this->data['AdmissionChecklist']['diet_given_time']) && $this->data['AdmissionChecklist']['diet_given_time']=="Yes"){?>
				<td align="center"><input id="diet_given_timeYes" type="radio" value="Yes" checked="checked" name="data[AdmissionChecklist][diet_given_time]"></td>
				<td align="center"><input id="diet_given_timeNo" type="radio" value="No" name="data[AdmissionChecklist][diet_given_time]"></td>
		<?php }else{ ?>
				<td align="center"><input id="diet_given_timeYes" type="radio" value="Yes" name="data[AdmissionChecklist][diet_given_time]"></td>
				<td align="center"><input id="diet_given_timeNo" type="radio" value="No" checked="checked" name="data[AdmissionChecklist][diet_given_time]"></td>
		<?php }	?>
		<td width="20%" style="padding-left:33px;"><?php echo $this->Form->input('AdmissionChecklist.diet_given_time_remark',array('legend'=>false,'class'=>'textBoxExpnd','label'=>false,'div'=>false));?></td>
	  </tr>
	  <tr>
		<td>17.</td>
		<td>Site Medication Given</td>
		<?php 
			 if(isset($this->data['AdmissionChecklist']['set_medication_given']) && $this->data['AdmissionChecklist']['set_medication_given']=="Yes"){?>
				<td align="center"><input id="set_medication_givenYes" type="radio" value="Yes" checked="checked" name="data[AdmissionChecklist][set_medication_given]"></td>
				<td align="center"><input id="set_medication_givenNo" type="radio" value="No" name="data[AdmissionChecklist][set_medication_given]"></td>
		<?php }else{ ?>
			<td align="center"><input id="set_medication_givenYes" type="radio" value="Yes" name="data[AdmissionChecklist][set_medication_given]"></td>
				<td align="center"><input id="set_medication_givenNo" type="radio" value="No" checked="checked" name="data[AdmissionChecklist][set_medication_given]"></td>
		<?php }	?>
		<td width="20%" style="padding-left:33px;"><?php echo $this->Form->input('AdmissionChecklist.set_medication_given_reamrk',array('legend'=>false,'class'=>'textBoxExpnd','label'=>false,'div'=>false));?></td>
	  </tr>
	</table>
	<div class="clr ht5"></div>
	<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
		  <td width="160" style="margin: 15px 0 0 10px;" height="35" align="right">Name of Staff Nurse :<font color="red">*</font></td>
		  <td width="33%" >&nbsp;<?php echo $this->Form->input('AdmissionChecklist.nurse_name',array('value'=>$patientData['User']['first_name'].' '.$patientData['User']['last_name'],'class'=>'textBoxExpnd validate[required,custom[mandatory-enter]]','id'=>'nurse_name','legend'=>false,'label'=>false,'div'=>false));?></td>
		  <td><?php echo $this->Form->hidden('AdmissionChecklist.staff_nurse', array('type'=>'text','id'=>'staff_nurse')); ?></td>
		</tr>
		<tr>
		  <td height="35" style="margin: 15px 0 0 10px; width:170px !important; float:left;" align="right">Name of Floor In Charge :<font color="red">*</font></td>
		  <td width="26%">&nbsp;<?php echo $this->Form->input('AdmissionChecklist.floor_incharge_id',array('type'=>'text','value'=>$patientData['User']['first_name'].' '.$patientData['User']['last_name'],'id'=>'floor_incharge_id','legend'=>false,'class'=>'textBoxExpnd validate[required,custom[mandatory-enter]]','label'=>false,'div'=>false));?></td>
		  <td><?php echo $this->Form->hidden('AdmissionChecklist.floor_incharge', array('type'=>'text','id'=>'floor_incharge')); ?></td>
	  </tr>
	</table>   
<div class="btns">
	<input type="submit" value="Save" class="blueBtn" tabindex="17" id="save" onClick="return getValidate();"/> 
	<?php if(!empty($lastEntryId)){
			echo $this->Html->link(__('Print'),'#', array('escape' => false,'class'=>'blueBtn','onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'print_admission_checklist',$this->params['pass'][0]))."', '_blank', 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=600,left=400,top=300,height=300');  return false;"));
								
		} ?>
	
</div>
<div class="clr ht5"></div>
   <!-- Right Part Template ends here -->
 </td>
</table>
<!-- Left Part Template Ends here -->

</div>  
<script>
	//To validate the form when date is empty
	
	function getValidate(){
		if($("#date").val() == ''){
			//alert('Please select date!');
			return false;
		} else if($("#nurse_name").val() == ''){
			//alert("Please enter the name of staff nurse!");
			return false;
		} else if($("#floor_incharge").val() == '') {
			//alert("Please enter the name of floor incharge!");
			return false;
		} else { 
			return true;
		}
	}


	/*$(document).ready(function(){
    	 
			$("#nurse_name").autocomplete("<?php // echo $this->Html->url(array("controller" => "nursings", "action" => "autocomplete","User","nurse", "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});
			$("#floor_incharge").autocomplete("<?php //echo $this->Html->url(array("controller" => "nursings", "action" => "autocomplete","User","floor_incharge", "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});
			
	 	});*/
	 	$(document).ready(function(){
	 	
	 		 $("#nurse_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","User",'id',"full_name",'role_id='.Configure::read('nurseId'),"admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			valueSelected:true,
         	showNoId:true,
			selectFirst: true,
			loadId : 'nurse_name,staff_nurse'
			});

	 		$("#floor_incharge_id").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","User",'id',"full_name",'role_id='.Configure::read('nurseId'),"admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				valueSelected:true,
	       	    showNoId:true,
				selectFirst: true,
				loadId : 'floor_incharge_id,floor_incharge'
				});
		});
	 
</script>