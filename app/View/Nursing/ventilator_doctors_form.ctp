<style>
/* .tdclass {
	padding-left: 10px;
}

.td1 {
	padding-left: 5px;
	width: 20%;
	border-bottom: 1px solid #3E4D4A;
	border-right: 1px solid #3E4D4A;
}

.td2 {
	border-bottom: 1px solid #3E4D4A;
	border-right: 1px solid #3E4D4A;
}

.tr1 {
	height: 50px;
	border-bottom: 1px solid #3E4D4A;
}

.formError .formErrorContent {
	width: 60px;
} */
 
</style>

<div class="inner_title">
	<h3>
		<?php echo __('Ventilator/Sedation Order Test');?>
	</h3>
</div>

<div class="clr ht5"></div>
<?php echo $this->element('patient_information');?>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
<?php echo $this->Form->create('',array('url'=>array('action'=>'ventilator_doctors_form',$id),'id'=>'ventilatorfrm','name'=>'VentilatorConsentList'),
		array('inputDefaults' => array('label' => false,'div' => false,'error'=>false)));

echo $this->Form->hidden('patient_id',array('value'=>$id));
 	echo $this->Form->hidden('id',array('type'=>'text'));?>

<table width="98%" border="0" cellspacing="1" cellpadding="0"
	class="tabularForm" style="margin: 11px 12px">
	<tr>
		<td width="26%" style="text-align: center;">Ventilation Date<font color="red">*</font></td>
        <td colspan="2"><?php echo $this->Form->input('ventilator_date',array('class'=>'validate[required,custom[mandatory-date]] textBoxExpnd','label'=>false,'type'=>'text','id'=>'ventilation_date','div'=>false))?> </td>  
	</tr>
	<tr>
		<td width="26%" style="text-align: center;">HOB<font color="red">*</font></td>
 			<td ><?php echo $this->Form->input('hob',array( 'class' => 'validate[required,custom[onlyNumber]]textBoxExpnd ','label'=>false,'type'=>'text', 'style'=>'width:172px','id'=>'hob','div'=>false))?>
					<?php  echo $this->Form->input('hob_period',array('label'=>false,'options'=>array('Day'=>'Day','Hours'=>'Hours'),'div'=>false,'id'=>'hob_period', 'style'=>'width:146px','multiple'=>false))?>
					</td>
					<td ><?php echo $this->Form->input('hob_priority',array('label'=>false,'options'=>array('Moderate'=>'Moderate','High'=>'High'),'id'=>'hob_priority', 'class'=>'textBoxExpnd','multiple'=>false,'div'=>false));?>
					</td> 
	</tr>
	<tr>
		<td width="26%" style="text-align: center;">Oral Care<font color="red">*</font></td>
  
					<td width="35%"><?php echo $this->Form->input('oral_care',array('class' => 'validate[required,custom[onlyNumber]] textBoxExpnd', 'style'=>'width:172px','label'=>false,'type'=>'text','id'=>'oral_care','div'=>false))?>
						<?php  echo $this->Form->input('oral_care_period',array('label'=>false,'options'=>array('Day'=>'Day','Hours'=>'Hours'),'div'=>false,'id'=>'oral_care_period', 'style'=>'width:150px','multiple'=>false))?>
					</td>
					<td width="35%"><?php echo $this->Form->input('oral_care_priority',array('label'=>false,'options'=>array('Moderate'=>'Moderate','High'=>'High'),'id'=>'oral_care_priority', 'class'=>'textBoxExpnd','multiple'=>false,'div'=>false))?>
					</td>
				  
	</tr>
	<tr>
		<td width="26%" style="text-align: center;">G.I Prophylaxis<font color="red">*</font></td>
 
					<td width="35%" ><?php echo $this->Form->input('gi_proph',array('div'=>false,'class' => 'validate[required,custom[onlyNumber]] textBoxExpnd','label'=>false,'type'=>'text', 'style'=>'width:172px','id'=>'gi_proph'))?>
						<?php  echo $this->Form->input('gi_proph_period',array('div'=>false,'label'=>false,'options'=>array('Day'=>'Day','Hours'=>'Hours'),'div'=>false,'id'=>'gi_proph_period', 'style'=>'width:150px','multiple'=>false))?>
					</td>
					<td width="35%"><?php echo $this->Form->input('gi_proph_priority',array('label'=>false,'options'=>array('Moderate'=>'Moderate','High'=>'High'),'id'=>'gi_proph_priority', 'class'=>'textBoxExpnd','multiple'=>false))?>
					</td>
				 
	</tr>

	<tr>
		<td width="26%" style="text-align: center;">VTE Prophylaxis<font color="red">*</font></td>
 
					<td width="35%"><?php echo $this->Form->input('vte_prophylaxis',array('div'=>false,'class' => 'validate[required,custom[onlyNumber]]textBoxExpnd', 'style'=>'width:172px','label'=>false,'type'=>'text','id'=>'vte_prophylaxis'))?>
						<?php  echo $this->Form->input('vte_prophylaxis_period',array('label'=>false,'options'=>array('Day'=>'Day','Hours'=>'Hours'),'div'=>false,'id'=>'vte_prophylaxis_period', 'style'=>'width:146px','multiple'=>false))?>
					</td>
					<td width="35%"><?php echo $this->Form->input('vte_priority',array('label'=>false,'options'=>array('Moderate'=>'Moderate','High'=>'High'),'id'=>'vte_priority','class'=>'textBoxExpnd','multiple'=>false))?>
					</td> 
	</tr>
	<tr>
		<td width="26%" style="text-align: center;">Ventilator Management<font color="red">*</font></td>
 
					<td width="35%"><?php echo $this->Form->input('vent_management',array('div'=>false,'class' => 'validate[required,custom[onlyNumber]] textBoxExpnd','label'=>false, 'style'=>'width:172px','type'=>'text','id'=>'vent_management'))?>
						<?php  echo $this->Form->input('vent_management_period',array('label'=>false,'options'=>array('Day'=>'Day','Hours'=>'Hours'),'div'=>false,'id'=>'vent_management_period', 'style'=>'width:150px','multiple'=>false))?>
					</td>
					<td width="35%"><?php echo $this->Form->input('vent_priority',array('label'=>false,'options'=>array('Moderate'=>'Moderate','High'=>'High'),'id'=>'vent_priority','class'=>'textBoxExpnd','multiple'=>false))?>
					</td>
				 
	</tr>
	<tr>
		<td width="26%" style="text-align: center;">Ventilator Setting<font color="red">*</font></td>
 
					<td width="35%"><?php echo $this->Form->input('vent_setting',array('div'=>false,'class' => 'validate[required,custom[onlyNumber]] textBoxExpnd', 'style'=>'width:172px','label'=>false,'type'=>'text','id'=>'vent_setting'))?>
						<?php  echo $this->Form->input('vent_setting_period',array('label'=>false,'options'=>array('Day'=>'Day','Hours'=>'Hours'),'div'=>false,'id'=>'vent_setting_period', 'style'=>'width:150px','multiple'=>false))?>
					</td>
					<td width="35%"><?php echo $this->Form->input('vent_setting_priority',array('label'=>false,'options'=>array('Moderate'=>'Moderate','High'=>'High'),'id'=>'vent_setting_priority', 'class'=>'textBoxExpnd','multiple'=>false))?>
					</td>
				 
	</tr>
</table>
<!-- --------vikas Form -->
<div>


	<table width="98%" border="0" cellspacing="1" cellpadding="0"  style="margin: 11px 12px">
		<tbody>
			<tr>
				<td width="49%" valign="top" align="left">
					<table width="100%"cellspacing="1" cellpadding="0" class="tabularForm" border="0">
						<tbody>
							<tr width="100%" valign="middle" id="boxSpace" class="tr1">
								<td class="td1"><strong><?php echo __('Consult Dr Setting:');?>
								</strong>
								</td>
								<td class="td2" colspan="3"><?php echo ucfirst($treating_consultant[0]['fullname']) ;?>
								</td>
							</tr>


							<tr width="100%" valign="middle" class="tr1">


								<td class="td1"><strong><?php echo __('Ventilator Management:');?>
								</strong>
								</td>
								<td class="td2"><?php echo $this->Form->radio(__('ventilator_management'), array('Anesthesia'=>'Anesthesia'),array('legend'=>false,'label'=>false,'id' => 'Anesthesia' ,'hiddenField' => false));?>
								</td>
								<td class="td2" colspan="2"><?php echo $this->Form->radio(__('ventilator_management'), array('Medical'=>'Medical'),array('legend'=>false,'label'=>false,'id' => 'Medical' ,'hiddenField' => false));?>
								</td>

							</tr>




							<tr width="100%" valign="middle" id="boxSpace" class="tdLabel">
								<td class="td1"><strong><?php echo __('Ventilator Setting:');?>
								</strong>
								</td>
								<td class="td2"><?php echo $this->Form->radio(__('ventilator_setting'), array('SIMV'=>'SIMV'),array('legend'=>false,'label'=>false,'id' => 'ventilator_setting1','hiddenField' => false ,'class'=>'setting' )); ?>
								</td>
								<td class="td2"><?php echo $this->Form->radio(__('ventilator_setting'), array('Assist Control'=>'Assist Control'),array('legend'=>false,'label'=>false,'id' => 'ventilator_setting2','hiddenField' => false ,'class'=>'setting'));?>
								</td>
								<td class="td2"><?php echo $this->Form->radio(__('ventilator_setting'), array('PSV'=>'PSV'),array('legend'=>false,'label'=>false,'id' => 'ventilator_setting3','hiddenField' => false,'class'=>'setting' ));?>
								</td>
							</tr>
							<tr width="100%" valign="middle" id="boxSpace" class="tdLabel showclick" style="display:none;">
								<td class="td1"></td>
								<td class="td2" colspan="3"><table width="100%" valign="middle" id="boxSpace" class="tdLabel">
										<tr >
											<td width="50%"><?php echo $this->Form->input(__('tidal_volume'), array('legend'=>false,'label'=>'Tidal Volume','id' => 'tidal_volume','hiddenField' => false,'div'=>false )); ?><span>ml</span></td>
											<td width="50%"><?php echo $this->Form->input(__('rate'),array('legend'=>false,'label'=>'Rate','id' => 'rate','hiddenField' => false,'div'=>false )); ?><span>breaths/min</span></td>
										</tr>
										<tr>
											<td width="50%"><?php echo $this->Form->input(__('fio2'), array('legend'=>false,'label'=>'FIO<sub>2</sub>','id' => 'fio2','hiddenField' => false,'div'=>false )); ?><span>%</span></td>
											<td width="50%"><?php echo $this->Form->input(__('spo2'), array('legend'=>false,'label'=>'Maintain Spo<sub>2</sub>','id' => 'fio2','hiddenField' => false,'div'=>false )); ?><span>%</span></td>
										</tr>
										<tr>
											<td width="50%"><?php echo $this->Form->input(__('psv'), array('legend'=>false,'label'=>'PSV','id' => 'fio2','hiddenField' => false,'div'=>false )); ?><span><font size="-2">(start with 15cm H<sub>2</sub>O in <span style="padding-left: 260px;">SIMV or PSV mode.)</span></font></span></td>
											<td width="50%"><?php echo $this->Form->input(__('peep'), array('legend'=>false,'label'=>'PEEP','id' => 'fio2','hiddenField' => false,'div'=>false )); ?><span>cm H<sub>2</sub>O</span></td>
										</tr>
									</table>
								</td>

							</tr>
							

							<tr width="100%" valign="middle" id="boxSpace" class="tr1">
								<td class="td1"><strong><?php echo __('Radiology:');?> </strong>
								</td>
								<td class="td2"><?php echo $this->Form->radio(__('radiology'), array('Portable Chest X-Ray on arrival'=>'Portable Chest X-Ray on arrival'),array('legend'=>false,'label'=>false,'id' => 'radiology1','hiddenField' => false ));?>
								</td>
								<td class="td2" colspan="2"><?php echo $this->Form->radio(__('radiology'), array('Portable Chest X-Ray on every other day while intubated'=>'Portable Chest X-Ray on every other day while intubated'),array('legend'=>false,'label'=>false,'id' => 'radiology2','hiddenField' => false ));?>
								</td>

							</tr>
							<tr width="100%" valign="middle" id="boxSpace" class="tr1">
								<td class="td1"><strong><?php echo __('Labs:');?> </strong>
								</td>
								<td class="td2"><?php echo $this->Form->radio(__('lab'), array('ABG 30 minutes after interval ventilator setting and call results'=>'ABG 30 minutes after interval ventilator setting and call results'),array('legend'=>false,'label'=>false,'id' => 'lab1','hiddenField' => false ));?>
								</td>
								<td class="td2" colspan="2"><?php echo $this->Form->radio(__('lab'), array('ABG Daily q AM while intubated'=>'ABG Daily q AM while intubated'),array('legend'=>false,'label'=>false,'id' => 'lab2' ,'hiddenField' => false));?>
								</td>

							</tr>

							<tr width="100%" valign="middle" id="boxSpace" class="tr1">
								<td class="td1"><strong><?php echo __('Studies:');?> </strong>
								</td>
								<td class="td2"><?php echo $this->Form->radio(__('studies'), array('Post Operative wean when criteria met'=>'Post Operative wean when criteria met'),array('legend'=>false,'label'=>false,'id' => 'studies1' ,'hiddenField' => false));?>
								</td>
								<td class="td2"><?php echo $this->Form->radio(__('studies'), array('Wean from ventilator when criteria met'=>'Wean from ventilator when criteria met'),array('legend'=>false,'label'=>false,'id' => 'studies2','hiddenField' => false ));?>
								</td>
								<td class="td2"><?php echo $this->Form->radio(__('studies'), array('Evaluate patient for weaning in Am'=>'Evaluate patient for weaning in Am'),array('legend'=>false,'label'=>false,'id' => 'studies3','hiddenField' => false ));?>
								</td>

							</tr>

							<tr width="100%" valign="middle" id="boxSpace" class="tr1">
								<td class="td1"><strong><?php echo __('Vital Signs:');?> </strong>
								
								<td class="td2" colspan="3"><?php echo $this->Form->checkbox(__('vital_sign'), array('value'=>'Q 15 min X 4 then q 1 hr and prn as needed with SpO2%'),array('legend'=>false,'label'=>false,'id' => 'vital_sign','hiddenField' => false));?>
									Q 15 min X 4 then q 1 hr and prn as needed with SpO2%</td>
							</tr>

							<tr width="100%" valign="middle" id="boxSpace" class="tr1">
								<td class="td1"><strong><?php echo __('Activity:');?> </strong>
								</td>
								<td class="td2" colspan="3"><?php echo $this->Form->checkbox(__('activity'), array('value'=>'Bed Rest with head of bed elevated 30-45 degrees if not contraindicated'),array('legend'=>false,'label'=>false,'id' => 'activity','hiddenField' => false ));?>
									Bed Rest with head of bed elevated 30-45 degrees if not
									contraindicated</td>
							</tr>
							<tr width="100%" valign="middle" id="boxSpace" class="tr1">
								<td class="td1"><strong><?php echo __('Consults:');?> </strong>
								</td>
								<td class="td2" colspan="3"><?php echo $this->Form->input('consult_name', array('options'=>$doctors,'multiple'=>true,'label'=>false,'class'=>'servicesClick','id' => 'consult_name'));?>
								</td>
							</tr>

							<tr width="100%" valign="middle" id="boxSpace" class="tr1">
								<td class="td1"><strong><?php echo __('Sedation:');?> </strong>
								</td>
								<td class="td2"><?php echo $this->Form->checkbox('VentilatorCheckList.sedation.0', array('value'=>'Midazolam infusion protocol:Titrate to obtain selected Rass','label'=>false,'class'=>'servicesClick','id' => 'ventilator'));?>
									Midazolam infusion protocol:Titrate to obtain selected Rass</td>
								<td class="td2"><?php echo $this->Form->checkbox('VentilatorCheckList.sedation.1', array('value'=>'Midazolam mg IV q 30 min prn for agitation','label'=>false,'class'=>'servicesClick','id' => 'ventilator'));?>
									Midazolam <?php echo $this->Form->input('VentilatorCheckList.sedation_vol', array('div'=>false,'style'=>'width: 20px','label'=>false,'class'=>''));?> IV q 30 min prn for agitation</td>
								<td class="td2"><?php echo $this->Form->checkbox('VentilatorCheckList.sedation.2', array('value'=>'Lorazepam infusion protocol: Titrate to obtain selected RASS','label'=>false,'class'=>'servicesClick','id' => 'ventilator'));?>
									Lorazepam infusion protocol: Titrate to obtain selected RASS</td>
							</tr>
							<tr width="100%" valign="middle" id="boxSpace" class="tr1">
								<td class="td1"></td>
								<td class="td2"><?php echo $this->Form->checkbox('VentilatorCheckList.sedation.3', array('value'=>'Lorazepam Img IV q 15 minutes prn for agitation','label'=>false,'class'=>'servicesClick','id' => 'ventilator'));?>
									Lorazepam Img IV q 15 minutes prn for agitation</td>
								<td class="td2" colspan="2"><?php echo $this->Form->checkbox('VentilatorCheckList.sedation.4', array('value'=>'Propofol infusion protocol. titrate to obtaining selected RASS','label'=>false,'class'=>'servicesClick','id' => 'ventilator'));?>
									Propofol infusion protocol. titrate to obtaining selected RASS
								</td>
							</tr>



							<tr width="100%" valign="middle" id="boxSpace" class="tr1">
								<td class="td1"><strong><?php echo __('Analgesia:');?> </strong>
								</td>
								<td class="td2"><?php echo $this->Form->checkbox('VentilatorCheckList.analgesia.0', array('value'=>'Morphine 2 mg IV q 1 hrs prn minor pain & Morphine 4 mg IV q 1 hrs prn major pain','label'=>false,'class'=>'servicesClick','id' => 'ventilator'));?>
									Morphine 2 mg IV q 1 hrs prn minor pain & Morphine 4 mg IV q 1
									hrs prn major pain</td>
								<td class="td2"><?php echo $this->Form->checkbox('VentilatorCheckList.analgesia.1', array('value'=>'Morphine infusion:loading dose ___ mg IV then:Infusion Rate mg/hr','label'=>false,'class'=>'servicesClick','id' => 'ventilator'));?>
									Morphine infusion:loading dose <?php echo $this->Form->input('VentilatorCheckList.analgesia_dose', array('div'=>false,'style'=>'width: 20px','label'=>false,'class'=>''));?> mg IV then:Infusion Rate <?php echo $this->Form->input('VentilatorCheckList.analgesia_rate', array('div'=>false,'style'=>'width: 20px','label'=>false,'class'=>''));?> mg/hr</td>
								<td class="td2"><?php echo $this->Form->checkbox('VentilatorCheckList.analgesia.2', array('value'=>'PCA see additional orders','label'=>false,'class'=>'servicesClick','id' => 'ventilator'));?>
									PCA see additional orders</td>


							</tr>

							<tr width="100%" valign="middle" id="boxSpace" class="tr1">
								<td class="td1"><strong><?php echo __('Oral Care:');?> </strong>
								</td>
								<td class="td2" colspan="3"><?php echo $this->Form->checkbox(__('oral_care_order_set'), array('value'=>'Q 4 hrs with 0.12% chlorexidine solution, and brush teeth q 12 hrs if possible.'),array('legend'=>false,'label'=>false,'id' => 'oral_care' ));?>
									Q 4 hrs with 0.12% chlorexidine solution, and brush teeth q 12
									hrs if possible.</td>
							</tr>

							<tr width="100%" valign="middle" id="boxSpace" class="tr1">
								<td class="td1"><strong><?php echo __('DVT Prophaxis:');?> </strong>
								</td>
								<td class="td2"><?php echo $this->Form->checkbox('VentilatorCheckList.dvt_prophaxis.0', array('value'=>'Ted Stocking knee length','label'=>false,'class'=>'servicesClick','id' => 'dvt_prophaxis0'));?>
									Ted Stocking knee length</td>
								<td class="td2"><?php echo $this->Form->checkbox('VentilatorCheckList.dvt_prophaxis.1', array('value'=>'Sequential Compression Device','label'=>false,'class'=>'servicesClick','id' => 'dvt_prophaxis1'));?>
									Sequential Compression Device</td>
								<td class="td2"><?php echo $this->Form->checkbox('VentilatorCheckList.dvt_prophaxis.2', array('value'=>'Heaprin 5000 units Sub Que q 12 hrs','label'=>false,'class'=>'servicesClick','id' => 'dvt_prophaxis2'));?>
									Heaprin 5000 units Sub Que q 12 hrs</td>
							</tr>

							<tr width="100%" valign="middle" id="boxSpace" class="tr1">
								<td class="td1"><strong><?php echo __('PUD Prophaxis:');?> </strong>
								</td>
								<td class="td2"><?php 	echo $this->Form->checkbox('VentilatorCheckList.pud_prophaxis.0', array('value'=>'Zantac 50 mg IV q 8 hrs','label'=>false,'class'=>'servicesClick','id' => 'pud_prophaxis'));?>
									Zantac 50 mg IV q 8 hrs</td>
								<td class="td2" colspan="2"><?php 	echo $this->Form->input('VentilatorCheckList.pud_prophaxis.1', array('label'=>false,'class'=>'servicesClick textBoxExpnd','id' => 'pud_prophaxis1'));?>
								</td>
							</tr>
					
					</table>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<!-- ---------------- -->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>
			<div class="btns">
				<?php echo $this->Html->link(__('Cancel'), array('controller'=>'nursings','action' => 'ventilator_doctor_list', $id), array('escape' => false,'class'=>'blueBtn'));
				echo $this->Form->submit(__('Submit'), array('id'=>'submit','label'=> false,'div' => false,'error' => false,'class'=>'blueBtn' ));
				?>
			</div>
		</td>
	</tr>
</table>
<?php echo $this->Form->end();?>
<script>
$(".setting").click(function (){ 
	$(".showclick").show();
});
$(function(){ 
	if($('[@name="ventilator_setting"]:checked').val()){
		$(".showclick").show();
	}
	jQuery("#ventilatorfrm").validationEngine();
	$("#ventilation_date").datepicker(
	{
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',			 
		date_format_us:'mm/dd/yy HH:II:SS',
	    maxDate: new Date(), 
	});
});
		 
		 
 
				

</script>
