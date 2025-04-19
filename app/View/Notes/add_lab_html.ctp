<tr class="added_1">
	<td width="40%" id="boxSpace" class="tdLabel">Universal Service
		Identifier: <font color="red">*</font>
	</td>
	<td width="60%"><?php  echo $this->Form->input('LaboratoryToken.arrayName.testname',array('class'=>'validate[required,custom[search-&-select]] textBoxExpnd','div'=>false,'label'=>false,'id'=>'testname','readonly'=>'readonly'));
	echo $this->Form->hidden('LaboratoryTestOrder.arrayName.patient_id', array('value'=>$patientId));
	echo $this->Form->hidden('LaboratoryTestOrder.arrayName.lab_id',array('type'=>'text','div'=>false,'label'=>false,'id'=>'testCode_1'));
	echo $this->Form->hidden('LaboratoryToken.arrayName.lab_id',array('type'=>'text','div'=>false,'label'=>false,'id'=>'testcodeToken_1'));
	echo $this->Form->hidden('LaboratoryToken.arrayName.patient_id',array('label'=>false,'type'=>'text','value'=>$patientId));
	?>
	</td>
</tr>
<tr class="added_1">
	<td id="specimen_type_name" class="tdLabel">Specimen Type:</td>
	<td><?php  echo $this->Form->input('LaboratoryTestOrder.arrayName.specimen_type_option',array('class'=>'textBoxExpnd'/*,'empty'=>'Please Select','options'=>''*/,'id'=>'specimen_type_option','type'=>'text','div'=>false,'label'=>false));
	?>
	</td>
</tr>
<tr class="added_1">
	<td class="tdLabel">Date of Order: <font color="red">*</font>
	</td>
	<?php $curentTime= $this->DateFormat->formatDate2LocalForReport(date('Y-m-d H:i:s'),Configure::read('date_format'),true);?>
	<td style="width: 163px; float: left;"><?php echo $this->Form->input('LaboratoryTestOrder.arrayName.start_date',array('id'=>'lab_start','class'=>'textBoxExpnd start_cal','readonly'=>'readonly','autocomplete'=>'off','type'=>'text','value'=>$curentTime,'label'=>false )); 
	?></td>
</tr>
<tr class="added_1">
	<td class="tdLabel">Priority:</td>
	<td><?php $Priority=array('Stat'=>'Stat','Daily'=>'Daily','Tommorrow'=>'Tommorrow','Today'=>'Today');
						 echo $this->Form->input('LaboratoryToken.arrayName.priority',array('class'=>'textBoxExpnd','empty'=>'Please Select','options'=>$Priority,'id'=>'priority','div'=>false,'label'=>false));  ?>
		</td>
</tr>
<tr class="added_1">
	<td class="tdLabel">Frequency:</td>
	<td><?php  echo $this->Form->input('LaboratoryToken.arrayName.frequency',array('class'=>'textBoxExpnd','empty'=>'Please Select','options'=>Configure::read('frequency'),'id'=>'','div'=>false,'label'=>false));  ?>
	</td>
</tr>
<tr class="added_1">
	<td width="19%" id="boxSpace" class="tdLabel">Specimen Collection Date:</td>
	<td width="19%"><?php 
	$curentTime= $this->DateFormat->formatDate2LocalForReport(date('Y-m-d H:i:s'),Configure::read('date_format'),true);
		echo $this->Form->input('LaboratoryTestOrder.arrayName.lab_order_date', array('class'=>'start_cal textBoxExpnd','id' => 'lab_order_date','type'=>'text','label'=>false,'value'=>$curentTime )); ?>
	</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr class="added_1">
	<td width="19%" id="boxSpace" class="tdLabel">Clinical Information <span
		style="font-size: 11px; font-style: italic">(Comments or Special
			Instructions)</span>
	</td>
	<td width="19%"><?php echo $this->Form->input('LaboratoryToken.arrayName.relevant_clinical_info', array('class'=>'textBoxExpnd','id' => 'relevant_clinical_info','type'=>'textarea','style'=>"resize:both; height:30px;",'label'=>false )); ?>
	</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr class="added_1">
	<td width="19%" id="boxSpace" class="tdLabel">Ordering Provider</td>
	<td width="19%"><?php 
						echo $this->Form->input('LaboratoryToken.arrayName.primary_care_pro', array('class'=>'textBoxExpnd primary_care_pro','type'=>'text','label'=>false,'value'=>$this->request->query[1] )); ?>
	</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>

<tr class="added_1" id="appendQuestions_1">
	<td width="19%" id="boxSpace" class="tdLabel">Select Diagnosis</td>
	<td width="19%"><?php  
	$diagnosisDatas = unserialize($this->request->query[0]);
	echo $this->Form->input('LaboratoryToken.arrayName.icd9_code',array('class'=>'textBoxExpnd icd9_code','options'=>unserialize($this->request->query[0]),'id'=>'icd9_code_1','div'=>false,'label'=>false,'selected'=>$labRad));
	echo $this->Form->input('LaboratoryToken.arrayName.diagnosis',array('class'=>'textBoxExpnd diagnoses_lab_name','type'=>'hidden','id'=>'diagnoses_lab_name_1','div'=>false,'label'=>false,'value'=>reset($diagnosesData)));
	
	
	?>
	</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr class="added_1">
	<td colspan="4" style="">
    <div style="border:1px solid #909090;">
    </div>
    </td>
</tr>
