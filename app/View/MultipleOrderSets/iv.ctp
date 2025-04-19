<?php
//echo $this->Html->script(array('jquery-ui-1.8.5.custom.min.js','slides.min.jquery.js',
//'jquery.isotope.min.js','jquery.custom.js','ibox.js','jquery.selection.js','jquery.autocomplete','ui.datetimepicker.3.js'));?>



<?php echo $this->Form->create('',array('action'=>'ivsolution'),array('type' => 'file','default'=>false,'id'=>'ivsolution','inputDefaults' => array(
		'label' => false,
		'div' => false,
		'error' => false,
		'legend'=>false,
		'fieldset'=>false,
)
));
?>
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
											<td><?php echo __('First Dose',true); ?><Font color="red">*</Font></td>
											<?php //$date = $this->DateFormat->formatDate2Local($sentences[0],Configure::read('date_format'),true); ?>
											<td><?php echo $this->Form->input('PatientOrder.first_dose',array('type'=>'text','id' =>'firstdose_datetime1','autocomplete'=>"off",'legend'=>false,'label'=>false,'value'=>$date,'class' => 'validate[required,custom[mandatory-enter]]'));?>
											<td><?php echo __('Infuse Rate',true); ?><font color="red">*</font></td>
											<td><?php  echo $this->Form->input('PatientOrder.infuse_rate',array('type'=>'text','label'=>false,'div'=>false,'value'=>$sentences[1], 'class' => 'validate[required,custom[mandatory-enter]]'));
											echo $this->Form->input('PatientOrder.infuse_rate_volume', array('options'=> array("sec"=>"sec","min"=>"min","hr"=>"hr"), 'id' => 'strength', 'selected'=>$sentences[2],'label'=>false,'div'=>false,'class' => 'validate[required,custom[mandatory-enter]]'));?>
											</td>
										</tr>

										<tr>
											<td><?php echo __('Frequency',true); ?><font color="red">*</font></td>
											<td><?php echo $this->Form->input('PatientOrder.frequency', array('empty'=>'Please select','options'=> Configure :: read('frequency_lr'), 'id' => 'frequency_r','selected'=>$sentences[3],'label'=>false,'class' => 'validate[required,custom[mandatory-enter]]' ));?></td>
											<td><?php echo __('Quantity',true); ?><font color="red">*</font></td>
											<td><?php  echo $this->Form->input('PatientOrder.quantity',array('type'=>'text','label'=>false,'div'=>false,'value'=>$sentences[4], 'class' => 'validate[required,custom[mandatory-enter]]'));
											echo $this->Form->input('PatientOrder.quantity_volume', array('options'=> array("ML"=>"ML","Ltr"=>"Ltr"), 'id' => 'strength', 'selected'=>$sentences[5],'label'=>false,'div'=>false,'class' => 'validate[required,custom[mandatory-enter]]'));?>
											</td>
										</tr>
										<tr>
											<td><?php echo __('weight',true); ?></td>
											<td><?php  echo $this->Form->input('PatientOrder.weight',array('type'=>'text','label'=>false,'div'=>false,'value'=>$sentences[6], 'class' => 'validate[required,custom[mandatory-enter]]'))
											;echo $this->Form->input('PatientOrder.weight_volume', array('options'=> array("Lbs"=>"Lbs","Kg"=>"Kg"), 'id' => 'duration','label'=>false,'div'=>false,'selected'=>$sentences[7],'class' => 'validate[required,custom[mandatory-enter]]'));?>
											</td>
											</td>
											<td><?php echo __('Volume',true); ?></td>
											<td><?php  echo $this->Form->input('PatientOrder.volume',array('type'=>'text','label'=>false,'div'=>false,'value'=>$sentences[8],'class' => 'validate[required,custom[mandatory-enter]]'));
											echo $this->Form->input('PatientOrder.volume_weight', array('options'=> array("ML"=>"ML"), 'id' => 'duration','label'=>false,'div'=>false,'selected'=>$sentences[9],'class' => 'validate[required,custom[mandatory-enter]]'));?>
											</td>
											</td>
										</tr>
										
										<tr>
											</td>
											<td><?php echo __('Dose',true); ?></td>
											<td><?php echo $this->Form->input('PatientOrder.dose_volume', array('empty'=>'Please select','options'=> Configure :: read('dose_type'),'id' => 'dose_type','label'=>false, 'div'=>false,'selected'=>$sentences[10],'class'=>'validate[required,custom[mandatory-select]]'));?>
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

$('#save')
.click(
function() {
//alert("hello");
var validatePerson = jQuery("#ConfigueMedicationDisplayorderformForm").validationEngine('validate');
//alert(validatePerson);
if (validatePerson) {$(this).css('display', 'none');}
return false;
});


$("#firstdose_datetime1")
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



$("#drug_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","ivsolution","STR", "admin" => false,"plugin"=>false)); ?>", {
width: 250,
selectFirst: true
});

});
</script>
