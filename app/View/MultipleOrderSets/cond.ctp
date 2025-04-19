<?php //echo $this->Html->script(array('validationEngine.jquery','ui.datetimepicker.3.js','jquery.validationEngine','/js/languages/jquery.validationEngine-en'));
//echo $this->Html->css(array('validationEngine.jquery.css'));
?>
<?php echo $this->Form->create('',array('url'=>'SaveOtherOrder/cond'),array('type' => 'file','default'=>false,'id'=>'conditions','inputDefaults' => array(
		'label' => false,
		'div' => false,
		'error' => false,
		'legend'=>false,
		'fieldset'=>false
)
));
?>
<table width="100%" cellpadding="0" cellspacing="0" border="0"
	class="formFull " style="margin-top: 20px">

	<tr>
		<td>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"
				class="formFull formFullBorder" id="orderset_mainid"
				style="padding: 10px">
				<tr>
					<td width="100%" valign="top">
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td><strong><?php  echo $name;?>
								</strong></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>

							<?php $sentences=explode(", ",$patientOrder[PatientOrder][sentence]);?>
							<?php echo $this->Form->hidden('PatientOrder.patient_id',array('value'=>$patientOrder['PatientOrder']['patient_id']));?>
							<?php echo $this->Form->hidden('PatientOrder.order_data_master_id',array('value'=>$orderDatamasterId));?>
							<?php echo $this->Form->hidden('PatientOrder.patient_order_id',array('value'=>$patient_order_id));?>
							<?php echo $this->Form->hidden('PatientOrder.name',array('value'=>$name));?>
							<?php echo $this->Form->hidden('PatientOrder.order_category_id',array('value'=>$patientOrder['PatientOrder']['order_category_id']));?>
							<tr>
								<td>
									<table width="100%" border="0">
										<tr>
										
											<td><?php echo __('Start/Admit Date :',true); ?><font color="red">*</font>
											</td>
											<td><?php echo $this->Form->input('PatientOrder.start_date',array('class' => 'validate[required,custom[mandatory-date]] textBoxExpnd','id'=>'start_date','readonly'=>'readonly','autocomplete'=>'off','type'=>'text','value'=>$start_date,'label'=>false ,'style'=>'width:150px;'));echo "&nbsp;".$this->Form->checkbox('PatientOrder.chktn', array('div' => false,'type'=>'checkbox','id' => 'chktn','label'=>false,'style'=>'display:inline','checked'=>$multipleOrderContent['MultipleOrderContaint']['chktn'],'onclick'=>'javascript:fillStartdate()'))."T;N";?>
											</td>
											<td><?php

											echo __('Status :',true); ?><font color="red">*</font>
											</td>
											<td><?php echo $this->Form->input('PatientOrder.admit_status', array('empty'=>'Please select','options'=> array('Inpatient'=>'Inpatient','Outpatient Observation'=>'Outpatient Observation','Outpatient Stay'=>'Outpatient Stay'),'label'=>false,'class' => 'validate[required,custom[mandatory-select]]','style'=>'width:200px;','selected'=>$multipleOrderContent['MultipleOrderContaint']['admit_status']));?>
											</td>
										</tr>
										<tr>
																				
											<td><?php echo __('Admit to :',true); ?><font color="red">*</font>
											</td>
											<td><?php echo $this->Form->input('PatientOrder.admitto', array('empty'=>'Please select','options'=>Configure::read('admit_to'),'label'=>false,'class'=>'validate[required,custom[mandatory-select]]' ,'style'=>'width:200px;','selected'=>$multipleOrderContent['MultipleOrderContaint']['admitto']));?>
											</td>
											<td valign="top"><?php echo __('Resuscitation Status',true); ?></td>
											<td valign="top"><?php echo $this->Form->input('PatientOrder.resuscitation_status', array('empty'=>'Please select','options'=> array('Full Code (full resuscitative measures)'=>'Full Code (full resuscitative measures)','DNR (do not resuscitate)'=>'DNR (do not resuscitate)','DNR/DNI (do not resuscitate/do not intubate)'=>'DNR/DNI (do not resuscitate/do not intubate)'),'label'=>false,'style'=>'width:200px;','selected'=>$multipleOrderContent['MultipleOrderContaint']['resuscitation_status']));?>
											</td>
										</tr>


										<tr>
											<td valign="top"><?php echo __('Special Instruction',true); ?></td>
											<td valign="top"><?php echo $this->Form->textarea('PatientOrder.special_instruction', array('rows'=>'3','label'=>false,'value'=>$special_instruction,'style'=>'width:300px;'));?></td>
										</tr>
									</table>
								</td>

							</tr>

						</table>
					</td>

				</tr>
				<tr>
					<td></td>
					<td><?php  if($this->Session->read('roleid')!=Configure::read('nurseId'))
                    {echo $this->Form->submit(__('Sign'),array('id'=>'submit','class'=>'blueBtn'));} ?>
					</td>

				</tr>
			</table>
		</td>

	</tr>
</table>
<script>
$(document).ready(function(){
	//alert($('#subCategory_id').val());
	
	$('#submit')
	.click(
	function() {
	//alert("hello");
	var validatePerson = jQuery("#ConfigueMedicationDisplayorderformForm").validationEngine('validate');
	//alert(validatePerson);
	if (validatePerson) {
	return true;
	}
	else{
	return false;
	}
	});


	$("#start_date")
	.datepicker(
			{
				showOn : "button",
				buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly : true,
				changeMonth : true,

				changeYear : true, 

				dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
				onSelect : function() {
					$(this).focus();
					//foramtEnddate(); //is not defined hence commented
				}
				
			});

	 $("#collected_date")
	 .datepicker(
	                 {
	                         showOn : "button",
	                         buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	                         buttonImageOnly : true,
	                         changeMonth : true,
	                         changeYear : true,
	                         dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
	                         'float' : 'right',        
	                         onSelect : function() {
	                                 $(this).focus();
	                                 //foramtEnddate(); //is not defined hence commented
	                         }
	                         
	                 });


	 $("#drug_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","conditions","STR", "admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true
		   });

	});

</script>
