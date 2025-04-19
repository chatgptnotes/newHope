
<?php /* echo $this->Html->css(array('validationEngine.jquery.css'));
echo $this->Html->script(array('jquery.validationEngine.js','languages/jquery.validationEngine-en.js')); */

?>
<?php echo $this->Html->script(array('validationEngine.jquery','ui.datetimepicker.3.js','jquery.validationEngine','/js/languages/jquery.validationEngine-en')); 
echo $this->Html->css(array('validationEngine.jquery.css'));
?>

<?php echo $this->Form->create('',array('action'=>'SaveOrderLab'),array('type' => 'file','default'=>false,'id'=>'saveLabOrder',
		'inputDefaults' => array(
		'label' => false,
		'div' => false,
		'error' => false,
		'legend'=>false,
		'fieldset'=>false
)
));
?>


<table width="100%" cellpadding="0" cellspacing="0" border="1" class=" "
	id="orderset_mainid" style="padding: 10px">
	<tr>
		<td width="100%" valign="top">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<?php //debug($getDataLab);?>
				<tr>
					<?php  if(empty($getDataLab)){
						$dataExp=explode(',',$patient_order_lab['PatientOrder']['sentence']);
						$getDataLab['LaboratoryToken']['specimen_type_id']=$dataExp['0'];
						$getDataLab['LaboratoryToken']['collection_priority']=$dataExp['1'];
						$getDataLab['LaboratoryToken']['frequency_l']=trim($dataExp['2']);
							}?>
					<td><strong><?php echo $patient_order_lab['PatientOrder']['name']?>
					</strong></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>

				<?php echo $this->Form->hidden('Laboratory.patient_id',array('value'=>$patient_order_lab['PatientOrder']['patient_id']));?>
				<?php echo $this->Form->hidden('LaboratoryTestOrder.patient_id',array('value'=>$patient_order_lab['PatientOrder']['patient_id']));?>
				<?php echo $this->Form->hidden('LaboratoryTestOrder.patient_order_id',array('value'=>$patient_order_id));?>
				<?php echo $this->Form->hidden('LaboratoryTestOrder.id');?>
				<?php echo $this->Form->hidden('Laboratory.name',array('value'=>$patient_order_lab['PatientOrder']['name']));?>

				<tr>
					<td>
						<table width="100%">
							<tr>
							<td> <div id='specimen_validation' style='display:none; color:red; width:270px'> </div></td>
							</tr>
							<tr>
								<td><?php echo __('Specimen Type',true); ?><font color="red">*</font>
								</td>
								<td><?php
								echo $this->Form->input('LaboratoryTestOrder.specimen_type_id',array('empty'=>'Please Select','style'=>'width:200px','readonly'=>'readonly',
											'options'=>$spec_type,'selected'=>$getDataLab['LaboratoryToken']['specimen_type_id'],'id'=>'specimen_type_id','class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','style'=>'width:350px;','div'=>false,'label'=>false));?>
								</td>
								<td><?php echo __('Collection Priority',true); ?><font
									color="red">*</font></td>
								<td><?php $collectionPriority=$getDataLab['LaboratoryToken']['collection_priority'];
								echo $this->Form->input('LaboratoryTestOrder.collection_priority', array('empty'=>'Please select','options'=> Configure :: read('collection_priority'), 'id' => 'collection_priority',
												'selected'=>trim($collectionPriority),'label'=>false,'class'=>'validate[required,custom[mandatory-select]] textBoxExpnd','style'=>'width:350px;' ));?>
								</td>
							</tr>
							<tr>
								<td><?php echo __('Specimen Collection Date',true); ?><font
									color="red">*</font></td>
								<?php $getDataLab['LaboratoryToken']['collected_date']=$this->DateFormat->formatDate2Local($getDataLab['LaboratoryToken']['collected_date'],'mm/dd/yyyy',true);?>

								<td><?php echo $this->Form->input('LaboratoryTestOrder.collected_date',array('class' => 'validate[required,custom[mandatory-date]] textBoxExpnd','style'=>'width:120px','id'=>'collected_date','readonly'=>'readonly','autocomplete'=>'off','type'=>'text',
												'value'=>$getDataLab['LaboratoryToken']['collected_date'],'label'=>false,'style'=>'width:315px;' )); ?>
								</td>
								<td><?php echo __('Frequency',true); ?>
								</td>
								<td><?php echo $this->Form->input('LaboratoryTestOrder.frequency_l', array('empty'=>'Please select','options'=> Configure :: read('frequency_lr'), 'id' => 'frequency_l',
												'selected'=>$getDataLab['LaboratoryToken']['frequency_l'],'label'=>false,'class'=>'validate[required,custom[mandatory-select]]','style'=>'width:350px;' ));?>
								</td>
							</tr>

							<tr>
								<td><?php echo __('Duration',true); ?>
								</td>
								<td><?php echo $this->Form->input('LaboratoryTestOrder.duration_l', array('type'=>'text','id' => 'duration_l', 'label'=> false,'value'=>$getDataLab['LaboratoryToken']['duration_l'], 'div' => false, 'error' => false,'autocomplete'=>false,'style'=>'width:330px;'));?>
								</td>
								<td><?php echo __('Duration Unit',true); ?>
								</td>
								<td><?php echo $this->Form->input('LaboratoryTestOrder.duration_unit', array('empty'=>'Please select','options'=> Configure :: read('duration_unit'), 'id' => 'duration_unit',
												'selected'=>$getDataLab['LaboratoryToken']['duration_unit'],'label'=>false,'class'=>'textBoxExpnd','style'=>'width:350px;' ));?>
								</td>
							</tr>

							<tr>
								<td><?php echo __('Stop Date/Time',true); ?>
								</td>
								<?php 
								if(!empty($getDataLab['LaboratoryToken']['end_date']) && $getDataLab['LaboratoryToken']['end_date'] != '0000-00-00 00:00:00'){
													$endDateToken=$this->DateFormat->formatDate2Local($getDataLab['LaboratoryToken']['end_date'],Configure::read('date_format'),true);
												}?>
								<td><?php echo $this->Form->input('LaboratoryTestOrder.end_date',array('legend'=>false,'label'=>false,'class' => 'validate[required] textBoxExpnd','label'=>false,'id' => 'stop_datetime',
												'value'=>$endDateToken,'autocomplete'=>"off",'style'=>'width:315px;'));?>
								</td>
								<td><?php echo __('Nurse Collect',true); ?>
								</td>
								<td><?php echo $this->Form->input('LaboratoryTestOrder.nurse_collect', array('empty'=>'Please select','options'=> array("Yes"=>"Yes","No"=>"No"), 'id' => 'nurse_collect',
												'selected'=>$getDataLab['LaboratoryToken']['nurse_collect'],'label'=>false,'class'=>'textBoxExpnd','style'=>'width:350px;' ));?>
								</td>
							</tr>

							<tr>
								<td valign="top"><?php echo __('Comment',true); ?>
								</td>
								<td valign="top"><?php echo $this->Form->textarea('LaboratoryTestOrder.special_instruction', array('id' => 'special_instruction','rows'=>'5','label'=>false,'value'=>$getDataLab['LaboratoryToken']['special_instruction'],'style'=>'width:350px;'));?>
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


	});

$(document).ready(function(){
			jQuery("#saveLabOrder").validationEngine({
		        validateNonVisibleFields: true,
		        updatePromptsPosition:true,
		    });
			$('#submit').click(
					
					function() {
						var specimen_type_id =$('#specimen_type_id').val();
						var collection_priority_id =$('#collection_priority').val();
						var collected_date_id =$('#collected_date').val();
						var stop_datetime=$('#stop_datetime').val();
						var duration_unit=$('#duration_unit').val();
						var duration_l=$('#duration_l').val();
						if(specimen_type_id==''){
							$('#specimen_validation').html("Specimen Type can not be null");
							$('#specimen_validation').show();
							return false;
						}
						if(collection_priority_id==''){
							$('#specimen_validation').html("collection priority can not be null");
							$('#specimen_validation').show();
							return false;
						}
						if(collected_date_id==''){
							$('#specimen_validation').html("collected date can not be null");
							$('#specimen_validation').show();
							return false;
						}	
						if( (collected_date_id > stop_datetime ) && (stop_datetime!='')){
							$('#specimen_validation').html("Start date can not be less than Collected Date");
							$('#specimen_validation').show();
							return false;
							
						}
						if((duration_l=='') && (duration_unit!='')){
							$('#specimen_validation').html("Please fill the Duration");
							$('#specimen_validation').show();
							return false;
							
						}
					});
	});


</script>
