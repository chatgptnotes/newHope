<?php echo $this->Html->script(array('validationEngine.jquery','ui.datetimepicker.3.js','jquery.validationEngine','/js/languages/jquery.validationEngine-en'));
echo $this->Html->css(array('validationEngine.jquery.css'));
?>
<?php echo $this->Form->create('',array('action'=>'activity'),array('type' => 'file','default'=>false,'id'=>'activity','inputDefaults' => array(
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

							<?php
							
							//debug($id);
							//exit;
							//debug($patientOrder);
							$sentences=explode(", ",$patientOrder[PatientOrder][sentence]);
							//debug($sentences);//exit;
							?>
							<?php echo $this->Form->hidden('PatientOrder.patient_id',array('value'=>$patient_id));?>
							<?php echo $this->Form->hidden('PatientOrder.type',array('value'=>$order_description));?>
							<?php echo $this->Form->hidden('PatientOrder.order_subcategory_id',array('value'=>$id));?>
							<?php echo $this->Form->hidden('PatientOrder.name',array('value'=>$name));?>
							<?php echo $this->Form->hidden('PatientOrder.order_category_id',array('value'=>$order_category_id));?>
							<tr>
								<td>
									<table width="100%" border="0">
										<tr>
										<?php //$start_date = $this->DateFormat->formatDate2Local($sentences[0],Configure::read('date_format'),true); ?>
										<?php //$stop_date = $this->DateFormat->formatDate2Local($sentences[1],Configure::read('date_format'),true); ?>
										
											<td><?php echo __('Requested Start Date/time',true); ?><font color="red">*</font>
											</td>
											<td><?php echo $this->Form->input('PatientOrder.collected_date',array('class' => 'validate[required,custom[mandatory-date]] textBoxExpnd','id'=>'collected_date','readonly'=>'readonly','autocomplete'=>'off','type'=>'text','value'=>$start_date,'label'=>false ,'style'=>'width:150px;')); ?>
											</td>
											<td><?php echo __('Frequency',true); ?>
											</td>
											<td><?php echo $this->Form->input('PatientOrder.frequency', array('empty'=>'Please select','options'=> Configure :: read('frequency'), 'selected'=>$sentences[2],'label'=>false,'style'=>'width:200px;'));?>
											</td>
										</tr>

										<tr>
											<td><?php echo __('Duration',true); ?>
											</td>
											<td><?php echo $this->Form->input('PatientOrder.duration', array('type'=>'text', 'value'=>$sentences[3],'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'style'=>'width:200px;'));?>

											</td>
											<td valign="top"><?php echo __('Duration Unit',true); ?>
											</td>
											<td valign="top"><?php echo $this->Form->input('PatientOrder.duration_unit', array('empty'=>'Please select','options'=> Configure :: read('duration_unit'), 'selected'=>$sentences[4],'label'=>false,'style'=>'width:200px;'));?>
											</td>
										</tr>

										<tr>
											<td valign="top"><?php echo __('PRN :',true); ?></td>
											<td valign="top"><?php echo $this->Form->radio('PatientOrder.PRN', array('Yes'=>'Yes','No'=>'No'),array('value'=>$sentences[5],'legend'=>false,'label'=>false));?>
											</td>
											<td valign="top"><?php echo __('Constant Order :',true); ?>
											</td>
											<td><?php echo $this->Form->radio('PatientOrder.Constant_Order', array('Yes'=>'Yes','No'=>'No'),array('value'=>$sentences[6],'legend'=>false,'label'=>false));?>
											</td>

										</tr>

										<tr>
											<td><?php echo __('Stop Date/time',true); ?><font color="red">*</font>
											</td>
											<td><?php echo $this->Form->input('PatientOrder.stop_datetime',array('class' => 'validate[required,custom[mandatory-date]] textBoxExpnd','id'=>'stop_datetime','readonly'=>'readonly','autocomplete'=>'off','type'=>'text','value'=>$stop_date,'label'=>false ,'style'=>'width:200px;')); ?>
											</td>
											<td valign="top"><?php echo __('Special Instruction',true); ?>
											</td>
											<td valign="top"><?php echo $this->Form->textarea('PatientOrder.special_instruction', array('rows'=>'3','label'=>false,'value'=>$sentences[7],'style'=>'width:300px;'));?>
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


	 $("#drug_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","activity","STR", "admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true
		   });

	});

$(document).ready(function(){

	jQuery("#RadiologyTestOrderDisplayorderformForm").validationEngine({
	validateNonVisibleFields: true,
	updatePromptsPosition:true,
	});
	$('#submit')
	.click(
	function() { 
	//alert("hello");
	var validatePerson = jQuery("#RadiologyTestOrderDisplayorderformForm").validationEngine('validate');
	//alert(validatePerson);
	if (validatePerson) {$(this).css('display', 'none');}
	return false;
	});
	});

</script>
