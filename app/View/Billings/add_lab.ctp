<style>
.timeCalender {
	border-radius: 25px;
	height: 20px;
	text-align: center;
	width: 50px !important;
}

.textBoxExpndAutoComplete {
	background: none;
	border: 1px solid #214a27;
	color: #000000;
	float: left;
	font-size: 13px;
	height: 20px;
	line-height: 20px;
	outline: medium none;
	resize: none;
}
</style> 
 
<div id="lab-investigation"  >
	<div class="clr ht5"></div>
	<table width="99%" cellpadding="0" cellspacing="1" border="0"
		class="tabularForm" style="margin: 0 auto;">
		<tr>
			<td width="30%" valign="top">
				<table width="100%" cellpadding="0" cellspacing="1" border="0"
					class="tabularForm">

					<!-- <tr>
						<td valign="top">
							<table width="100%" cellpadding="0" cellspacing="0" border="0">
								<tr>

									<td><?php 
									echo $this->Html->image('/img/favourite-icon.png',array('style'=>'margin-right:5px;'));
									echo $this->Form->input('test_name',array('class'=>'textBoxExpnd AutoComplete','escape'=>false,'multiple'=>false,
											'label'=>false,'div'=>false,'id'=>'test_name','autocomplete'=>false,'placeHolder'=>'Lab Search','style'=>'width:286px;'));
									echo $this->Form->hidden('testCode',array('id'=>'testCode'));

									?></td>

									<td width=""></td>

									<td width=""></td>
								</tr>
							</table>
						</td>

					</tr> -->

				</table> <?php echo $this->Form->create('AddLab',array('action'=>'addLab','id'=>'labfrm','type'=>'post'));?>
				<div style="float: right;margin-top: 6px;"
					id="">
					<input type="button" id="addMoreLab" value="Add Order"> <span
						id="showRemove" style="display: none"> <input type="button"
						id="removeMoreLab" value="Remove Order">
					</span>
				</div>
				<table border="0" class="" cellpadding="0" cellspacing="3"
					width="100%" style="text-align: left; color: #fff;"
					id="mainLabTable1">
					<tr>
						<td width="40%" id="boxSpace" class="tdLabel">Universal Service
							Identifier: <font color="red">*</font>
						</td>
						<td width="60%"><?php  echo $this->Form->input('LaboratoryToken.0.testname',array('class'=>'validate[required,custom[search-&-select]] textBoxExpnd','div'=>false,'label'=>false,'id'=>'testname','readonly'=>'readonly'));
						echo $this->Form->hidden('LaboratoryTestOrder.0.lab_id',array('type'=>'text','div'=>false,'label'=>false,'id'=>'testcode_0'));
						echo $this->Form->hidden('LaboratoryToken.0.lab_id',array('type'=>'text','div'=>false,'label'=>false,'id'=>'testcodeToken_0'));
						echo $this->Form->hidden('LaboratoryToken.0.patient_id',array('label'=>false,'type'=>'text','value'=>$patientId));
						echo $this->Form->hidden('LaboratoryTestOrder.0.patient_id', array('label'=>false,'type'=>'text','value'=>$patientId));

						/*echo $this->Form->hidden('LaboratoryToken.0.curdate',array('id'=>'curdate'));
						 echo $this->Form->hidden('LaboratoryTestOrder.0.sct_concept_id',array('type'=>'text','div'=>false,'label'=>false,'id'=>'sctCode'));
						echo $this->Form->hidden('LaboratoryTestOrder.0.sct_desc',array('type'=>'text','div'=>false,'label'=>false,'id'=>'sctDesc'));
						echo $this->Form->hidden('LaboratoryTestOrder.0.isIMO',array('type'=>'text','div'=>false,'label'=>false,'id'=>'isIMO'));

						echo $this->Form->hidden('LaboratoryTestOrder.0.cpt_code',array('type'=>'text','div'=>false,'label'=>false,'id'=>'cptCode'));
						echo $this->Form->hidden('LaboratoryTestOrder.0.lonic_code',array('type'=>'text','div'=>false,'label'=>false,'id'=>'LonicCode'));
						echo $this->Form->hidden('LaboratoryTestOrder.0.lonic_desc',array('type'=>'text','div'=>false,'label'=>false,'id'=>'LonicDesc'));

						echo $this->Form->hidden('LaboratoryTestOrder.0.cpt_desc',array('type'=>'text','div'=>false,'label'=>false,'id'=>'cptDesc'));
						echo $this->Form->hidden('LaboratoryTestOrder.0.icd9_code',array('type'=>'text','div'=>false,'label'=>false,'id'=>'icd9Code'));
						echo $this->Form->hidden('LaboratoryTestOrder.0.icd9_desc',array('type'=>'text','div'=>false,'label'=>false,'id'=>'icd9Desc'));

						echo $this->Form->hidden('LaboratoryTestOrder.0.icd10pcs_code',array('type'=>'text','div'=>false,'label'=>false,'id'=>'icd10pcsCode'));
						echo $this->Form->hidden('LaboratoryTestOrder.0.icd10pcs_desc',array('type'=>'text','div'=>false,'label'=>false,'id'=>'icd10pcsDesc'));
						echo $this->Form->hidden('LaboratoryTestOrder.0.hcpcs_code',array('type'=>'text','div'=>false,'label'=>false,'id'=>'hcpcsCode'));

						echo $this->Form->hidden('LaboratoryTestOrder.0.hcpcs_desc',array('type'=>'text','div'=>false,'label'=>false,'id'=>'hcpcsDesc'));

						echo $this->Form->hidden('LaboratoryToken.0.id',array('id'=>'token_id','div'=>false,'label'=>false));
						echo $this->Form->hidden('LaboratoryToken.0.testOrder_id',array('type'=>'text','id'=>'testOrder_id','div'=>false,'label'=>false));*/
						if($flagSbar=='sbar')
							echo $this->Form->hidden('LaboratoryToken.0.sbar',array('id'=>'sbar','value'=>$flagSbar));
						?>
						</td>
					</tr>
					<!-- 
					<tr>
						<td   id="boxSpace" class="tdLabel">Specimen:
						</td>
						<td>
						
						<?php  
							
						//echo $this->Form->input('LaboratoryToken.specimen_type_id',array('class'=>'validate[required,custom[mandatory-enter]] textBoxExpnd','empty'=>'Please Select','readonly'=>'readonly','options'=>$spec_type,'id'=>'specimen_type_id','div'=>false,'label'=>false));
						?>
						</td>
					</tr>
					-->
					<tr>
						<td id="specimen_type_name" class="tdLabel">Specimen Type:</td>
						<td><?php  echo $this->Form->input('LaboratoryTestOrder.0.specimen_type_option',array('class'=>'textBoxExpnd',/*'empty'=>'Please Select','options'=>'',*/'id'=>'specimen_type_option','type'=>'text','div'=>false,'label'=>false));
						?>
						</td>
					</tr>
					<tr>
						<!--<td>Status:</td>
			<td><?php //echo $this->Form->input('LaboratoryToken.status', array('readonly'=>'readonly','style'=>'width:160px','options'=>array("Entered"=>__('Entered'),'Approved'=>__('Approved'),'Ordered'=>__('Ordered')),'id'=>'status','label' => false)); ?>
			</td>-->

						<td class="tdLabel">Date of Order: <font color="red">*</font>
						</td>
						<?php $curentTime= $this->DateFormat->formatDate2LocalForReport(date('Y-m-d H:i:s'),Configure::read('date_format'),true);?>
						<td style="width: 163px; float: left;"><?php echo $this->Form->input('LaboratoryTestOrder.0.start_date',array('id'=>'lab_start','class'=>'textBoxExpnd start_cal','readonly'=>'readonly','autocomplete'=>'off','type'=>'text','value'=>$curentTime,'label'=>false )); 
						//echo $this->Form->input('LaboratoryToken.collected_date',array('class'=>'validate[required,custom[mandatory-enter]] textBoxExpnd','id'=>'collected_date','readonly'=>'readonly','autocomplete'=>'off','type'=>'text','value'=>'','label'=>false,'value'=>date('m/d/y H:i:s') )); ?>
						</td>
					</tr>

					<!-- 	<tr>
						<td  class="tdLabel">Sample:</td>
						<td  ><?php echo $this->Form->input('LaboratoryToken.0.sample', array('class'=>'textBoxExpnd','readonly'=>'readonly','options'=>array("Office"=>__('Office'),' PSC'=>__(' PSC')),'label' => false,'id' => 'sample')); ?>
						</td>
					</tr> -->

					<!--  	<tr>
						<td   class="tdLabel">Start date: <!--  <font color="red">*</font>
						</td>
						<td  ><?php //echo $this->Form->input('LaboratoryTestOrder.start_date',array('id'=>'lab_start','class'=>'textBoxExpnd start_cal','readonly'=>'readonly','autocomplete'=>'off','type'=>'text','value'=>'','label'=>false )); ?>
						</td>
					</tr> -->
					<!--  <tr>

						<td  class="tdLabel">End date/time: <!--  <font color="red">*</font>
						</td>

						<td  ><?php echo $this->Form->input('LaboratoryToken.0.end_date',array('class'=>'textBoxExpnd','id'=>'end_date','readonly'=>'readonly','autocomplete'=>'off','type'=>'text','value'=>'','label'=>false )); ?>
						</td>
					</tr> -->
					<!--
					<tr>
						<td id="boxSpace" class="tdLabel">Specimen Action Code:</td>
						<td><?php  echo $this->Form->input('LaboratoryToken.0.specimen_action_id',array('class'=>'textBoxExpnd','empty'=>'Please Select','readonly'=>'readonly','options'=>$spec_action,'id'=>'specimen_action_id','div'=>false,'label'=>false));
						?>
						</td>
					</tr>
					<tr>
						<td class="tdLabel">Accession ID:</td>
						<td><?php  echo $this->Form->input('LaboratoryToken.0.ac_id',
								array('readonly'=>'readonly','class'=>'textBoxExpnd','type'=>'text','id'=>'ac_id','div'=>false,'label'=>false,'value'=>$accesionId));  ?>

						</td>

					</tr>
					<tr>
						<td class="tdLabel">Specimen Condition:</td>
						<td><?php  echo $this->Form->input('LaboratoryToken.0.specimen_condition_id',array('class'=>'textBoxExpnd','empty'=>'Please Select','options'=>$spec_cond,'id'=>'specimen_condition_id','div'=>false,'label'=>false));  ?>

						</td>

					</tr>
					-->
					<tr>
						<td class="tdLabel">Priority:</td>
						<td><?php $Priority=array('Stat'=>'Stat','Daily'=>'Daily','Tommorrow'=>'Tommorrow','Today'=>'Today');
						 echo $this->Form->input('LaboratoryToken.0.priority',array('class'=>'textBoxExpnd','empty'=>'Please Select','options'=>$Priority,'id'=>'priority','div'=>false,'label'=>false));  ?>


							<!-- <div id="showTime"
								style="padding-left: 43px; padding-bottom: 5px; display: none;">
								<span>At</span> <input type="text" id="timepicker_start"
									class="timeCalender" readonly="readonly"
									name="data[LaboratoryToken][starthours]">
							</div> --></td>

					</tr>
					<tr>
						<td class="tdLabel">Frequency:</td>
						<td><?php  echo $this->Form->input('LaboratoryToken.0.frequency',array('class'=>'textBoxExpnd','empty'=>'Please Select','options'=>Configure::read('frequency'),'id'=>'','div'=>false,'label'=>false));  ?>

						</td>


					</tr>

					<!-- 
					<tr>
						<td class="tdLabel">Condition Original Text:</td>
						<td><?php echo $this->Form->input('LaboratoryToken.0.cond_org_txt', array('class'=>'textBoxExpnd','type'=>'text','label' => false,'id' => 'cond_org_txt')); ?>
						</td>
					</tr>
					<tr>
						<td id="boxSpace" class="tdLabel">Alternate Specimen Type:</td>
						<td><?php  echo $this->Form->input('LaboratoryToken.0.alt_spec',array('class'=>'textBoxExpnd','type'=>'text','id'=>'alt_spec','div'=>false,'label'=>false));  ?>
						</td>
					</tr>

					<tr>
						<td id="boxSpace" class="tdLabel">Specimen Reject Reason:</td>
						<td><?php echo $this->Form->input('LaboratoryToken.0.specimen_rejection_id', array('class'=>'textBoxExpnd','empty'=>'Please Select','readonly'=>'readonly','options'=>$spec_rej,'label' => false,'id' => 'spec_rej')); ?>
						</td>
					</tr>
 
					<tr>
						<td id="boxSpace" class="tdLabel">Reject Reason Original Text:</td>
						<td><?php echo $this->Form->input('LaboratoryToken.0.rej_reason_txt', array('class'=>'textBoxExpnd','type'=>'text','label' => false,'id' => 'rej_reason_txt')); ?>
						</td>
					</tr>
					
					<!--  <tr>
						<td   id="boxSpace" class="tdLabel">No of written Lab
							orders:</td>
						<td  ><?php echo $this->Form->input('LaboratoryTestOrder.0.lab_order', array('class'=>'textBoxExpnd','type'=>text,'div'=>false,'label'=>false,'id' => 'lab_order')); ?>
						</td>
					</tr> 


					<tr>
						<td width="19%" id="boxSpace" class="tdLabel">Alternate Specimen
							Condition:</td>
						<td width="20%"><?php  echo $this->Form->input('LaboratoryToken.0.alt_spec_cond',array('class'=>'textBoxExpnd','type'=>'text','id'=>'alt_spec_cond','div'=>false,'label'=>false));  ?>
							
						</td>
					</tr>
-->
					<!-- 
		<tr>
			<td>Bill Type:</td>
			<td><?php //echo $this->Form->input('LaboratoryToken.bill_type', array('id'=>'bill_type','style'=>'width:165px','options'=>array("None"=>__('None'),'Patient'=>__('Patient'),'Client'=>__('Client'),'Third Party'=>__('Third Party')),'label' => false)); 
			?>
			</td>
			<td>Account No:</td>
			<td><?php  //echo $this->Form->input('LaboratoryToken.account_no',array('id'=>'account_no','class' => 'validate[required,custom[mandatory-enter]]','div'=>false,'label'=>false));  ?>
			</td>
			
		</tr>
		 -->
					<!-- <tr>
						<td width="19%" id="boxSpace" class="tdLabel"><?php echo __("Send To Laboratory");?>:</td>
						<td width="31%"><?php echo $this->Form->input('LaboratoryTestOrder.0.service_provider_id', array('class'=>'textBoxExpnd','empty'=>'Please Select','id'=>'service_provider_id','options'=>$serviceProviders,'label' => false)); ?>
						</td>
					</tr> -->

					<tr>

						<td width="19%" id="boxSpace" class="tdLabel">Specimen Collection
							Date:</td>
						<td width="19%"><?php 
						$curentTime= $this->DateFormat->formatDate2LocalForReport(date('Y-m-d H:i:s'),Configure::read('date_format'),true);
						echo $this->Form->input('LaboratoryTestOrder.0.lab_order_date', array('class'=>'start_cal textBoxExpnd','id' => 'lab_order_date','type'=>'text','label'=>false,'value'=>$curentTime )); ?>
						</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td width="19%" id="boxSpace" class="tdLabel">Clinical Information
							<span style="font-size: 11px; font-style: italic">(Comments or
								Special Instructions)</span>
						</td>
						<td width="19%"><?php echo $this->Form->input('LaboratoryToken.0.relevant_clinical_info', array('class'=>'textBoxExpnd','id' => 'relevant_clinical_info','type'=>'textarea','style'=>"resize:both; height:30px;",'label'=>false )); ?>
						</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td width="19%" id="boxSpace" class="tdLabel">Ordering Provider</td>
						<td width="19%"><?php 

						//if($this->Session->read('role')=='Primary Care Provider'){
						$getDocName=$dName; // From Appointment
						//}
						//debug($getDocName);
						echo $this->Form->input('LaboratoryToken.0.primary_care_pro', array('class'=>'textBoxExpnd primary_care_pro','type'=>'text','label'=>false,'value'=>$getDocName )); ?>
						</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>

					<tr id="appendQuestions_0">
						<td width="19%" id="boxSpace" class="tdLabel">Select Diagnosis<font color="red">*</font></td>
						<td width="19%"><?php  
						echo $this->Form->input('LaboratoryToken.0.icd9_code',array('class'=>'textBoxExpnd icd9_code validate[required,custom[mandatory-select]]','empty'=>'Please Select','options'=>$diagnosesData,'id'=>'icd9_code_0','div'=>false,'label'=>false,'selected'=>$labRad));
						echo $this->Form->input('LaboratoryToken.0.diagnosis',array('class'=>'textBoxExpnd diagnoses_lab_name','type'=>'hidden','id'=>'diagnoses_lab_name_0','div'=>false,'label'=>false,'value'=>reset($diagnosesData)));
						?>
						</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>

					<!-- 
		<tr>
			<td>Number of written Laboratory orders:</td>
			<td><?php //echo $this->Form->input('LaboratoryTestOrder.lab_order', array('type'=>text,'div'=>false,'label'=>false,'id' => 'lab_order'  )); ?>
			</td>

			<td>Date of order:</td>
			<td><?php //echo $this->Form->input('LaboratoryTestOrder.lab_order_date', array('class'=>'textBoxExpnd','style'=>'width:120px','id' => 'lab_order_date','type'=>'text','label'=>false )); ?>
			</td>
		</tr>
		 -->
				</table> <?php echo $this->Form->end();?>
			</td>
		</tr>
	</table>
	<!-- <table width="99%" cellpadding="0" cellspacing="0" border="0" class="tabularForm" style="margin: 0 auto;">
		<tr>
			<td align='right' valign='bottom' colspan='2'><?php if($flagSbar != 'sbar' ){
				if($noteId=='null')
					echo $this->Html->link(__('Cancel'),array("controller"=>'notes',"action"=>'soapNote',$patientId),array('id'=>'labsubmit1','class'=>'blueBtn'));
				else
					echo $this->Html->link(__('Cancel'),array("controller"=>'notes',"action"=>'soapNote',$patientId,$noteId),array('id'=>'labsubmit1','class'=>'blueBtn'));
			} ?> <?php  echo $this->Form->submit(__('Submit'),array('id'=>'labsubmit','class'=>'blueBtn','onclick'=>"javascript:save_lab();return false;",'div'=>false)); ?>
			</td>

		</tr>
	</table> -->
	<!-- PRocudure search ends -->

</div>
<table border="0" class="tabularForm" cellpadding="0" cellspacing="3"
	width="100%" style="text-align: left; color: #fff;" id="gaurav">
</table>
<script>
var radioOption = '<?php echo $this->Form->input('LaboratoryToken.0.radio_question_',array('type'=>'radio',
'options'=>array(true=>'Yes',false=>'No'),
'label'=>false,'div'=>false,'legend'=>false,'hiddenField'=>false));?>';
var specimenCollectionUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "getAoeQuestionAnswer","admin" => false)); ?>";
//procedureList
var addMoreHtml = '';
var labCounter = 1;
$(document).click(function(){
	var value = $('.descriptionField'+(labCounter-1)).val();
	$('.description'+(labCounter-1)).val(value);
});

jQuery(document).ready(function(){


	$('.start_cal').datepicker({ 
		    showOn: "both",
			buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly : true,
			changeMonth : true,
			changeYear : true,
			yearRange: '-100:' + new Date().getFullYear(),
			//maxDate : new Date(),
			dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
			onSelect : function() { 
			} 
	}); 
	

	/*$.ajax({
        type: 'POST',
       	url: "<?php echo html_entity_decode($this->Html->url(array("controller" => "Notes", "action" => "addLabHtml",'?'=>array(serialize($diagnosesData),$dName),"admin" => false))); ?>",
        dataType: 'html',
        success: function(data){ 
        	addMoreHtml = data;
		},
	});*/

	$('.icd9_code').change(function(){
		var selectedDiagnosisId = this.id;
		var selectedDiagnosis = $("#"+selectedDiagnosisId+" option:selected").text();
		selectedDiagnosisId = selectedDiagnosisId.split("icd9_code_");
		$("#diagnoses_lab_name_"+selectedDiagnosisId[1]).val(selectedDiagnosis);
	});
	
	$('#addMoreLab').click(function(){
		var validate = jQuery("#labfrm").validationEngine('validate');
		if(validate){
			$('#test_name').val('');
		var mapObj = { 
				icd9_code_1 : 'icd9_code_'+labCounter,
				diagnoses_lab_name_1 : 'diagnoses_lab_name_'+labCounter,
				added_1 : 'added_'+labCounter,
				testCode_1 : 'testcode_'+labCounter, 
				testcodeToken_1 : 'testcodeToken_'+labCounter, 
				appendQuestions_1 : 'appendQuestions_'+labCounter,
				arrayName : labCounter
				};
		addMoreHtmlData = addMoreHtml.replace(/added_1|testCode_1|diagnoses_lab_name_1|icd9_code_1|testcodeToken_1|appendQuestions_1|arrayName/gi, function(matched){ return mapObj[matched]; });
		labCounter++;
		$("#mainLabTable1").find('tbody').prepend(addMoreHtmlData);
		$("#showRemove").show();
		$(".start_cal").datepicker({
			showOn : "both",
			buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly : true,
			changeMonth : true,
			changeYear : true,
			yearRange: '-100:' + new Date().getFullYear(),
			dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
		});
		$(".primary_care_pro").autocomplete("<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "testcomplete","DoctorProfile",'user_id',"doctor_name",'null',"admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true,
			valueSelected:true,
			showNoId:true,
			loadId : 'doctor_id_txt,doctorID',
		});
		$('.icd9_code').change(function(){
			var selectedDiagnosisId = this.id;
			var selectedDiagnosis = $("#"+selectedDiagnosisId+" option:selected").text();
			selectedDiagnosisId = selectedDiagnosisId.split("icd9_code_");
			$("#diagnoses_lab_name_"+selectedDiagnosisId[1]).val(selectedDiagnosis);
	});
	}});
	$('#removeMoreLab').click(function(){
		var removrTr = labCounter-1;
		$( "tr.added_"+removrTr+', tr.removeIdentifier_'+removrTr ).remove();
		labCounter--;
		if(labCounter < 2){
			$("#showRemove").hide();
		} 
		$("#labfrm").validationEngine('hideAll');
		//$('.formErrorContent, .formErrorArrowBottom').hide();
	});

	
	$("#test_name").autocomplete("<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "labRadAutocomplete","Laboratory",'id',"dhr_order_code","name",'dhr_flag=1',"admin" => false,"plugin"=>false)); ?>", {
		width: 250,
		selectFirst: true,
		valueSelected:true,
		showNoId:true,
		loadId : 'testname,testCode',
		onItemSelect:function () { 
			$("#labfrm").validationEngine('hideAll');
			if ( ( /culture/i.test($("#test_name").val()) ) && labCounter == 1 ){ //if test name is of type culture restrict addMore
				$('#addMoreLab').hide('slow');
			}else if(( /culture/i.test($("#test_name").val()) )){	
				$('#test_name, #testCode, #testname:first').val('');
				$('#test_name').validationEngine('showPrompt', 'Cannot place this order.', 'checkbox', 'bottomRight', true);
				return false;
			}else{
				$('#addMoreLab').show('slow');
			}
			var labId = $('#testCode').val();
			$('#testcode_'+(labCounter-1)).val(labId);
			$('#testcodeToken_'+(labCounter-1)).val(labId);
			$('.removeIdentifier_'+(labCounter-1)).remove();
			getSpecimenOptions();
			$("#test_name").val('');
		}
	});

// Pawan get Specimen Options
function getSpecimenOptions(){
	//specimen_type_option//specimen_type_name
	var isOption = false;
	$.ajax({
        type: 'POST',
       	url: specimenCollectionUrl+'/'+$("#testcode_"+(labCounter-1)).val(),
       	//data: {laboratory_id: $("#testcode").val()},
        dataType: 'html',
        beforeSend : function() {
        	//loading('lab-investigation','id');
		},
		success: function(data){ 
			data = jQuery.parseJSON(data);
			var questionAns = data.queAns;
			$("#specimen_type_option").val(data.labArray.Laboratory.specimen_collection_type);
				/*$.each(options, function (i, item) {
					isOption = true;
					$("#specimen_type_option").append( new Option(item,i) );
					onCompleteRequest('lab-investigation','id');
				});*/
				
			buildAoeQuestions(questionAns);
			//onCompleteRequest('lab-investigation','id');
        },
		error: function(message){
			 alert("Please try again") ;
        }        
});
}
	
function buildAoeQuestions(data){
	var dropDown = '';
	$.each(data, function (i, item) {
		var obj = item['Question']['LaboratoryAoeCode'];
		var isRequired ='';	
		var appendTr = labCounter-1;
		
	if(obj.is_specimen_description){	
		$("#appendQuestions_"+appendTr).append($('<input>').attr('type', 'hidden').attr('class', 'description'+appendTr).attr('name', 'data[LaboratoryTestOrder]['+appendTr+'][specimen_description]'));
		var descClass = 'descriptionField'+appendTr;
	}else{
		var descClass = '';
	}
	if(obj.field_type == 'DD'){
		
		var ansAry  = item['Question']['Answer'];
		if(obj.is_required == 1){
			var className  = 'validate[required,custom[mandatory-select]] textBoxExpnd'; 
			isRequired = '<font color="red">*</font>';
		}else if(obj.is_required){
			var className  = 'textBoxExpnd';
		} 

		$("#appendQuestions_"+appendTr)
		.after($('<tr>').attr('class', 'removeIdentifier_'+appendTr).attr('id', 'SelectedServiceHighlighted_'+obj.id)
	    		 .append($('<td width="12%" class="tdLabel">').text(obj.question).append(isRequired))
				       .append($('<td>').append($('<select />').attr('class', className+' '+descClass).css('width', '66%')
						       .attr('id', 'optionDropDown').attr('type', 'select').attr('name', 'data[LaboratoryToken]['+appendTr+'][LaboratoryTokenSerialize][drop_down_question_'+obj.id+']')
						)));
		$("#optionDropDown").append( new Option('Please Select' , '') );
		if(ansAry != undefined){
			$.each(ansAry, function (key, value) {
				 $("#optionDropDown").append( new Option(value , value) );
			});
		}
		
	}else if(obj.field_type == 'FT'){
		var question = $.trim(obj.question);
		var addCalenderClass = (question.indexOf('Date') > -1) ? 'start_cal' : '';
		if(obj.is_required == 1){
			var className  = 'validate[required,custom[mandatory-enter]] textBoxExpnd '+addCalenderClass;
			isRequired = '<font color="red">*</font>'; 
		}else{
			var className  = 'textBoxExpnd '+addCalenderClass;
		}
		var style = (addCalenderClass == '') ? {resize:"both", height:"30px"} : {resize:"none", height:"20px"};
		$("#appendQuestions_"+appendTr)
		.after($('<tr>').attr('id', 'SelectedServiceHighlighted_'+obj.id).attr('class', 'removeIdentifier_'+appendTr)
	    		 .append($('<td width="12%" class="tdLabel">').text(obj.question).append(isRequired))
				       
				       .append($('<td>').append($('<input>').
				    		   attr('class', className+' '+descClass).attr('type', 'textarea').attr('name', 'data[LaboratoryToken]['+appendTr+'][LaboratoryTokenSerialize][free_text_question_'+obj.id+']')
				    		   // .css( style )
						)));
        
	}else if(obj.field_type == 'ST'){
		
		var newRadio = radioOption.replace("data[LaboratoryToken][0][radio_question_]","data[LaboratoryToken]["+appendTr+"][LaboratoryTokenSerialize][radio_question_"+obj.id+"]");
		var newRadio = newRadio.replace("data[LaboratoryToken][0][radio_question_]","data[LaboratoryToken]["+appendTr+"][LaboratoryTokenSerialize][radio_question_"+obj.id+"]");
		if(obj.is_required == 1){
			var className  = 'validate[required,custom[mandatory-select]] textBoxExpnd';
			isRequired = '<font color="red">*</font>'; 
		}else if(obj.is_required){
			var className  = 'textBoxExpnd';
		}
		$("#appendQuestions_"+appendTr)
	    .after($('<tr>').attr('id', 'SelectedServiceHighlighted_'+obj.id).attr('class', 'removeIdentifier_'+appendTr)
	    		 .append($('<td width="12%" class="tdLabel">').text(obj.question).append(isRequired))
				       .append($('<td>').append(newRadio)
						));
		$( "input[type='radio', name='data[LaboratoryToken][0][radio_question_]']").attr('name','data[LaboratoryToken]['+appendTr+'][LaboratoryTokenSerialize][radio_question_'+ obj.id +']');
	}
	
	});
	$(".start_cal").datepicker({
		showOn : "both",
		buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly : true,
		changeMonth : true,
		changeYear : true,
		yearRange: '-100:' + new Date().getFullYear(),
		//maxDate : new Date(),
		dateFormat:'<?php echo $this->General->GeneralDate();?>',
		onSelect : function() {
			
		}
});

}

/// End (Pawan)


	//BOF procedure search
	$("#procedureSearch").click(function(){
		  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "proceduresearch",$patient_id,"admin" => false)); ?>";

		  var formData = $('#procedureForm').serialize(); 
		   $.ajax({
	            type: 'POST',
	           	url: ajaxUrl,
	            data: formData,
	            dataType: 'html',
	            beforeSend : function() {
	            	loading();
				},
				success: function(data){ 
					$("#procedureList").html(data);
					onCompleteRequest();
	            },
				error: function(message){
					 alert("Please try again") ;
	            }        
	   });
	});
			//EOF procedure search
});
 
	


function save_lab(Clinical){ 
	/*if($('#specimen_type_id').val()==""){
		alert('Check validations');
		return false;
	}
	if($('#testname').val()==""){
		alert('Check validations');
		return false;
	}*/
	var value = $('.descriptionField'+(labCounter-1)).val();
	$('.description'+(labCounter-1)).val(value);
	var validateMandatory = jQuery("#labfrm").validationEngine('validate');
	if(validateMandatory == false){ 
		return false;
	}else{ 	
		 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "notes", "action" => "addLab",
		 		$patientId,$noteId,"admin" => false)); ?>"; 
		 var formData = $('#labfrm').serialize(); 
		   $.ajax({
	            type: 'POST',
	           	url: ajaxUrl,
	            data: formData,
	            dataType: 'html',
	            beforeSend : function() {
					//this is where we append a loading image
	            	$('#busy-indicator').show('fast');
				},
				success: function(data){ 
					if($.trim(data)=='sbar'){
						parent.$.fancybox.close();
						
					}else{
					$('#busy-indicator').hide('fast');
					var noteId='<?php echo $noteId?>';
					if(noteId=='null'){
						noteId=$.trim(data);
					}
					window.location.href='<?php echo $this->Html->url(array("controller"=>'notes',"action" => "soapNote",$patientId));?>'+'/'+noteId
					}
		            },
				error: function(message){
					$( '#flashMessage', parent.document).html('Please try later.');
					$('#flashMessage', parent.document).show();
					parent.$.fancybox.close();
	            }        });
	      
	      return false;
	}

	 
}
function proceduresearch(source) {
    var identify =""; 
	identify = source;
	$.fancybox({
				'width' : '100%',
				'height' : '100%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "proceduresearch")); ?>" + "/" + identify,
			});
   } 

function loading(){
	  
	 $('#procedureList').block({ 
       message: '<h1><?php echo $this->Html->image('icons/ajax-loader_dashboard.gif');?> Please wait...</h1>', 
       css: {            
           padding: '5px 0px 5px 18px',
           border: 'none', 
           padding: '15px', 
           backgroundColor: '#000000', 
           '-webkit-border-radius': '10px', 
           '-moz-border-radius': '10px',               
           color: '#fff',
           'text-align':'left' 
       },
       overlayCSS: { backgroundColor: '#000000' } 
   }); 
}

function onCompleteRequest(){
	$('#procedureList').unblock(); 
	return false ;
}
/* $(".primary_care_pro").autocomplete("<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "testcomplete","DoctorProfile",'user_id',"doctor_name",'null',"admin" => false,"plugin"=>false)); ?>", {
	width: 250,
	selectFirst: true,
	valueSelected:true,
	showNoId:true,
	loadId : 'doctor_id_txt,doctorID',
});*/
$('#timepicker_start').timepicker({
    showLeadingZero: true,
    onSelect: tpStartSelect,
   // onClose: updateDoctorTime,
    minTime: {
        //hour: <?php echo Configure::read('calendar_start_time') ?>, minute: 0
    },
    maxTime: {
       // hour: parseInt('<?php //echo Configure::read('calendar_end_time') ?>'//)-1, minute: 0
    }
});
function tpStartSelect( time, endTimePickerInst ) {
    $('#timepicker_end').timepicker('option', {
        minTime: {
            hour: endTimePickerInst.hours+1,
            minute: endTimePickerInst.minutes
        }
    });
}
$('#priority').change(function(){
	if($('#priority').val()=='Tommorrow' || $('#priority').val()=='Today')
		$('#showTime').show();
	else
		$('#showTime').hide();
	
});

		</script>
