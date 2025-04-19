<?php echo $this->Form->create('',array('action'=>'SaveOrderRad'),array('type' => 'file','default'=>false,'id'=>'SaveOrderRad','inputDefaults' => array(
		'label' => false,
		'div' => false,
		'error' => false,
		'legend'=>false,
		'fieldset'=>false
)
));
?>
<table width="100%" cellpadding="0" cellspacing="0" border="2"
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
								<td><strong><?php  echo $patient_order_rad['PatientOrder']['name'];?>
								</strong></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>

							<!-- <tr>
									<td>
										<?php 
			    		                   echo __('Drug Name ',true);echo $this->Form->input('NewCropPrescription.drug_name', array('type'=>'text','id' => 'drug_name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'style'=>'width:350px;'));?>
										</td>						
										</tr>
									-->
							<?php echo $this->Form->hidden('RadiologyTestOrder.patient_id',array('value'=>$patient_order_rad['PatientOrder']['patient_id']));?>
							<?php echo $this->Form->hidden('RadiologyTestOrder.patient_order_id',array('value'=>$patient_order_id));?>
							<?php echo $this->Form->hidden('RadiologyTestOrder.id');?>
							<?php echo $this->Form->hidden('RadiologyTestOrder.name',array('value'=>$patient_order_rad['PatientOrder']['name']));?>
							<?php echo $this->Form->hidden('Radiology.name',array('value'=>$patient_order_rad['PatientOrder']['name']));?>
							<?php if(!empty($getDataRad)){
								$requested_date=$this->DateFormat->formatDate2Local($getDataRad['RadiologyTestOrder']['collected_date'],'mm/dd/yyyy',true);
								$collection_priority=$getDataRad['RadiologyTestOrder']['collection_priority'];
								$strength=$getDataRad['RadiologyTestOrder']['frequency_r'];
								$refills=$getDataRad['RadiologyTestOrder']['order_future_visit'];
								$duration_l=$getDataRad['RadiologyTestOrder']['duration_l'];
								$duration_unit=$getDataRad['RadiologyTestOrder']['duration_unit'];
								$reason_exam=$getDataRad['RadiologyTestOrder']['reason_exam'];
								$spec_instr=$getDataRad['RadiologyTestOrder']['reason_exam_instruction'];
								$Pregnant=$getDataRad['RadiologyTestOrder']['Pregnant'];
								$special_instruction=$getDataRad['RadiologyTestOrder']['special_instruction'];

							}
						
							else{
								$requested_date=$requested_date;
								$collection_priority=$collection_priority;
								$strength=$strength;
								$refills=$refills;
								$duration_unit=$duration_unit;
								$reason_exam=$reason_exam;
								$spec_instr=$spec_instr;
								$Pregnant=$Pregnant;
								$special_instruction=$special_instruction;
}?>
							<tr>
								<td>
									<table width="100%" border="0">
										<tr>
											<td> <div id='specimen_validation' style='display:none; color:red;'> </div></td>
											</tr>
										<tr>
											<td><?php echo __('Requested Start Date/time',true); ?><font
												color="red">*</font>
											</td>
											<td><?php echo $this->Form->input('RadiologyTestOrder.collected_date',array('class'=>'textBoxExpnd','id'=>'collected_date','autocomplete'=>'off','type'=>'text','value'=>$requested_date,'label'=>false )); ?>
											</td>
											<td><?php echo __('Collection Priority',true); ?><font
												color="red">*</font>
											</td>
											<td><?php echo $this->Form->input('RadiologyTestOrder.collection_priority', array('empty'=>'Please select','options'=> Configure :: read('collection_priority'), 'id' => 'collection_priority','selected'=>$collection_priority,'label'=>false,'class'=>'validate[required,custom[mandatory-select]] textBoxExpnd'));?>
											</td>
										</tr>
										<tr>
											<td><?php echo __('Frequency',true); ?>
											</td>
											<td><?php echo $this->Form->input('RadiologyTestOrder.frequency_r', array('empty'=>'Please select','options'=> Configure :: read('frequency_lr'), 'id' => 'frequency_r','selected'=>$strength,'label'=>false,'class'=>'validate[required,custom[mandatory-select]] textBoxExpnd'));?>
											</td>
											<td><?php echo __('Order for future visit',true); ?>
											</td>
											<td><?php echo $this->Form->input('RadiologyTestOrder.order_future_visit', array('options'=> array("No"=>"No","Yes"=>"Yes"), 'id' => 'order_future_visit','selected'=>$refills,'label'=>false,'class'=>'textBoxExpnd'));?>
											</td>
										</tr>

										<tr>
											<td><?php echo __('Duration',true); ?>
											</td>
											<td><?php echo $this->Form->input('RadiologyTestOrder.duration_l', array('type'=>'text','id' => 'duration_r', 'value'=>$duration_l,'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'class'=>'textBoxExpnd'));?>

											</td>
											<td valign="top"><?php echo __('Duration Unit',true); ?>
											</td>
											<td valign="top"><?php echo $this->Form->input('RadiologyTestOrder.duration_unit', array('empty'=>'Please select','options'=> Configure :: read('duration_unit'), 'id' => 'duration_unit','selected'=>$duration_unit,'label'=>false,'class'=>'textBoxExpnd'));?>
											</td>
										</tr>



										<tr>
											<td valign="top"><?php echo __('Reason for exam - DCP',true); ?><font
												color="red">*</font>
											</td>
											<td ><?php echo $this->Form->input('RadiologyTestOrder.reason_exam', array('empty'=>'Please select','options'=> Configure :: read('reason_exam'), 'id' => 'reason_exam','selected'=>$reason_exam,'label'=>false,'class'=>'textBoxExpnd'));?>
											</td>
											<td valign="top"><?php echo __('Reason for exam',true); ?>
											</td>
											<td><?php echo $this->Form->textarea('RadiologyTestOrder.reason_exam_instruction', array('id' => 'special_instruction','rows'=>'3','label'=>false,'value'=>$spec_instr,'class'=>'textBoxExpnd'));?>
											</td>

										</tr>

										<tr>
											<td valign="top"><?php echo __('Pregnant',true); ?>
											</td>
											<td><?php echo $this->Form->input('RadiologyTestOrder.Pregnant', array('options'=> array("No"=>"No","Yes"=>"Yes"), 'id' => 'nurse_collect','selected'=>$Pregnant,'label'=>false,'class'=>'textBoxExpnd'));?>
											</td>
											<td valign="top"><?php echo __('Special Instruction',true); ?>
											</td>
											<td ><?php echo $this->Form->textarea('RadiologyTestOrder.special_instruction', array('id' => 'special_instruction','rows'=>'3','label'=>false,'value'=>$special_instruction,'class'=>'textBoxExpnd'));?>
											</td>
										</tr>
									</table>
								</td>

							</tr>

						</table>
					</td>

				</tr>
				<tr>
					<td></td>
					<td><?php  echo $this->Form->submit(__('Sign'),array('id'=>'submit','class'=>'blueBtn')); ?>
					</td>

				</tr>
			</table>
		</td>

	</tr>
</table>
<script>
$(document).ready(function(){

	$("#stop_datetime")
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

	 $("#drug_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Rxnatomarchive","STR", "admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true
		   });

	});

$(document).ready(function(){
	jQuery("#saveLabOrder").validationEngine({
        validateNonVisibleFields: true,
        updatePromptsPosition:true,
    });
	$('#submit').click(
			function() {
				var reason_exam_id =$('#reason_exam').val();
				var collection_priority_id =$('#collection_priority').val();
				var collected_date_id =$('#collected_date').val();
				if(collected_date_id==''){
					$('#specimen_validation').html("collected date can not be null");
					$('#specimen_validation').show();
					return false;
				}	
				if(collection_priority_id==''){
					$('#specimen_validation').html("collection priority can not be null");
					$('#specimen_validation').show();
					return false;
				}
				if(reason_exam_id==''){
					$('#specimen_validation').html("Specimen Type can not be null");
					$('#specimen_validation').show();
					return false;
				}
					
			});
});
</script>
