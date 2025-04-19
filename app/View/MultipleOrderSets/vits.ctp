<?php
//echo $this->Html->script(array('jquery-ui-1.8.5.custom.min.js','slides.min.jquery.js',
//'jquery.isotope.min.js','jquery.custom.js','ibox.js','jquery.selection.js','jquery.autocomplete','ui.datetimepicker.3.js'));?>



<?php echo $this->Form->create('',array('url'=>'SaveOtherOrder/vits'),array('type' => 'file','default'=>false,'id'=>'vital_sign','inputDefaults' => array(
		'label' => false,
		'div' => false,
		'error' => false,
		'legend'=>false,
		'fieldset'=>false,
)
));
?>

<style>
.checkbox{float: left; width:100%}
.checkbox label{float: none;}
.dat img{float:inherit;}
</style>


<table width="100%" cellpadding="0" cellspacing="0" border="0"
	class="formFull" style="margin-top: 20px">

	<tr>
		<td>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"
				class="formFull formFullBorder" id="orderset_mainid" align="center" style="padding: 10px">
				<tr>
					<td width="100%" valign="top">
						<table width="95%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td><strong><?php echo $name;?>
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
									<table width="100%">
										<tr>
											<td><?php echo __('Start Date :',true); ?><Font color="red">*</Font></td>
											<?php //$date = $this->DateFormat->formatDate2Local($sentences[0],Configure::read('date_format'),true); ?>
											<td><?php echo $this->Form->input('PatientOrder.start_date',array('class' => 'validate[required,custom[mandatory-date]] textBoxExpnd','id'=>'start_date','readonly'=>'readonly','autocomplete'=>'off','type'=>'text','value'=>$start_date,'label'=>false ,'style'=>'width:150px;'));echo "&nbsp;".$this->Form->checkbox('PatientOrder.chktn', array('div' => false,'type'=>'checkbox','id' => 'chktn','label'=>false,'style'=>'display:inline','checked'=>$multipleOrderContent['MultipleOrderContaint']['chktn'],'onclick'=>'javascript:fillStartdate()'))."T;N";?>
											<td><?php echo __('Frequency :',true); ?><Font color="red">*</Font></td>
											<td><?php echo $this->Form->input('PatientOrder.frequency', array('empty'=>'Please select','options'=> Configure :: read('frequency'), 'id' => 'frequency','selected'=>$frequency,'label'=>false,'style'=>'width:200px','class' => 'validate[required,custom[mandatory-select]]' ));?></td>
											
										</tr>

										<tr>
											<td><?php echo __('Temperature :',true); ?><Font color="red">*</Font></td>
											<td><?php  echo $this->Form->input('PatientOrder.temprature', array('options'=> array(""=>"Please Select","Axillary"=>"Axillary","Central"=>"Central","Oral"=>"Oral","Rectal"=>"Rectal","Tympanic"=>"Tympanic","Temporal"=>"Temporal"), 'id' => 'temprature', 'selected'=>$multipleOrderContent['MultipleOrderContaint']['temprature'],'label'=>false,'div'=>false,'style'=>'width:200px','class' => 'validate[required,custom[mandatory-enter]]'));?></td>

											<td><?php echo __('B.P. :',true); ?><Font color="red">*</Font></td>
											<td><?php  echo $this->Form->input('PatientOrder.bp', array('options'=> array(""=>"Please Select","Arterial line"=>"Arterial Line","Cuff"=>"Cuff"), 'id' => 'bp', 'selected'=>$multipleOrderContent['MultipleOrderContaint']['bp'],'style'=>'width:200px','label'=>false,'div'=>false,'class' => 'validate[required,custom[mandatory-enter]]'));?></td>
										
										</tr>
										<tr>
											<td><?php echo __('Heart Rate :',true); ?><Font color="red">*</Font></td>
											<td><?php  echo $this->Form->input('PatientOrder.heart_rate', array('options'=> array(""=>"Please Select","Peripheral Pulse Rate"=>"Peripheral Pulse Rate","Apical Heart Rate"=>"Apical Heart Rate","Heart Monitoring Rate"=>"Heart Monitoring Rate"), 'id' => 'heart_rate', 'selected'=>$multipleOrderContent['MultipleOrderContaint']['heart_rate'],'style'=>'width:200px','label'=>false,'div'=>false,'class' => 'validate[required,custom[mandatory-enter]]'));?></td>

											<td valign="top"><?php echo __('Respiratory :',true); ?></td>
											<td><?php //$optioncheck= explode('|',$this->data['AlcohalCessationAssesment']['smoke_again']);
							//debug($optioncheck);
							echo $this->Form->input('PatientOrder.respiratory',array('class'=>'textBoxExpnd','id'=>'respiratory','autocomplete'=>'off','type'=>'text','value'=>$multipleOrderContent['MultipleOrderContaint']['respiratory'],'label'=>false ,'style'=>'width:200px;')); ?></td>
										
										</tr>
										
										<tr>
											<td valign="top"><?php echo __('Oxygen Therapy :',true); ?></td>
											<td valign="top"><?php  echo $this->Form->input('PatientOrder.oxygen_therapy', array('options'=> array(""=>"Please Select","Room Air"=>"Room Air","Biphasic Positive Airway Pressure (BiPAP)"=>"Biphasic Positive Airway Pressure (BiPAP)","Continuous Positive Airway Pressure (CPAP)"=>"Continuous Positive Airway Pressure (CPAP)","Expiratory Positive Airway Pressure (EPAP)"=>"Expiratory Positive Airway Pressure (EPAP)"), 'id' => 'strength','style'=>'width:200px', 'selected'=>$multipleOrderContent['MultipleOrderContaint']['oxygen_therapy'],'label'=>false,'div'=>false));	?>	
											</td>
											<td valign="top"><?php echo __('Special Instruction',true); ?><font color="red">*</font>
											</td>
											<td valign="top"><?php echo $this->Form->textarea('PatientOrder.special_instruction', array('rows'=>'3','label'=>false,'value'=>$special_instruction,'style'=>'width:300px','class' => 'validate[required,custom[mandatory-enter]]'));?>
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
					<td><?php  if($this->Session->read('roleid')!=Configure::read('nurseId'))
                    {echo $this->Form->submit(__('Sign'),array('id'=>'submit','class'=>'blueBtn'));} ?>
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
'float' : 'right',
onSelect : function() {
$(this).focus();
//foramtEnddate(); //is not defined hence commented
}

});

$("#drug_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","vital_sign","STR", "admin" => false,"plugin"=>false)); ?>", {
width: 250,
selectFirst: true
});

});
</script>
