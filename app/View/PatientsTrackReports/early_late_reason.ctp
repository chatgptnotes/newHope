<?php 
echo $this->Html->script(array('jquery-1.5.1.min','/js/languages/jquery.validationEngine-en','jquery.validationEngine',
		'/theme/Black/js/ui.datetimepicker.3.js'));
echo $this->Html->css(array('jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','internal_style.css'));
?>
<?php 
echo $this->Form->create('MedicationAdministeringRecord',array('type' => 'file','id'=>'MedicationAdministeringRecord',
		url=>array('controller'=>'PatientsTrackReports','action'=>'earlyLateReason'),
		'inputDefaults' => array('label' => false, 'div' => false, 'error' => false	)));
echo $this->Form->hidden('id',array('type'=>'text'));
echo $this->Form->hidden('new_crop_prescription_id',array('value'=>$newCropPrescId));
//for js parent image replace
echo $this->Form->hidden('patient_id',array('value'=>$patientId));
echo $this->Form->hidden('scheduled_datetime',array('class'=>'scheduleTime'));
echo $this->Form->hidden('route',array('value'=>$medicationData['NewCropPrescription']['route']));
echo $this->Form->hidden('dose',array('value'=>$medicationData['NewCropPrescription']['dose']));
echo $this->Form->hidden('form',array('value'=>$medicationData['NewCropPrescription']['strength']));
$intravenousRoute = configure::read('selected_route_administration');
?>

<div
	class="inner_left">
	<table width="97%" align="center" border="0" cellspacing="0"
		cellpadding="0" class="tabularForm">
		<tr>
			<td colspan="2"><?php echo $this->Html->image('icons/mar_icon/mar5.png');?>
				<br /> <strong><span style="text-align: left;"><?php echo __($medicationData['NewCropPrescription']['description']);?>
				</span><br /> <span style="text-align: left; margin-left: 17px;"><?php echo __($medicationData['PatientOrder']['sentence']);?>
				</span> </strong></td>
		</tr>
	</table>
	<div class="clr ht5"></div>
	<table width="97%" align="center" border="0" cellspacing="0"
		cellpadding="0" class="formFull">

		<tr width="50%">
			<td valign="middle" class="tdLabel" id="boxSpace"><?php echo __('Scheduled date/time:'); ?></td>

			<td class="scheduleTime"><!-- load schedule time from js --></td>
		</tr>
		<tr>
			<td class="tdLabel" id="boxSpace"><?php echo __('Performed date/time:');?>
			</td><?php $currentDate = $this->DateFormat->formatDate2LocalForReport(date('Y-m-d H:i'),Configure::read('date_format'),true);?>
				<td><?php echo $this->Form->input('performed_datetime', array('type'=>'hidden','value'=>$currentDate)); echo $currentDate; ?>
			</td>
					</tr>


	</table>
	<!-- Patient Information end here -->


	<!-- Links to Records start here -->
	
	<p class="ht5"></p>
	<table width="97%" align="center" border="0" cellspacing="0"
		cellpadding="0" class="formFull">
		<tr><td class="tdLabel" id="boxSpace">Please Specify a resaon why medication is being 
			documented late:<font
				color="red">*</font></td>
		</tr>
		<tr>			
				<td class="tdLabel" id="boxSpace"><p class="ht5" style="margin: 16px 0px 21px 25px; width: 300px;"><?php echo $this->Form->input('reason', array('empty'=>"Please Select",'options'=>Configure::read('late_reason_mar'),'label'=>false,'class' => 'validate[required,custom[mandatory-select]]','id'=>'reason'));?></p></td>
		</tr>		
	</table>
	<p class="ht5"></p>
	<!-- EOF address infto and BOF diagnosis -->
	<table width="97%" align="center" border="0" cellspacing="0"
		cellpadding="0" class="formFull">
		<tr>
			<td width="2%" class="tdLabel" id="boxSpace">Comment</td>
		</tr>
		<tr>
			<td width="2%" class="tdLabel" id="boxSpace"><?php echo $this->Form->input('comment',array('type'=>'textarea','id'=>'comment'));?>
			</td>
		</tr>
	</table>
		<div class="btns" style="margin-top: -15px;">
		<input class="blueBtn" type="submit" value="Ok" id="submit">
		<?php
		echo $this->Form->input(__('Cancel'),array('type'=>'button','class'=>'blueBtn','id'=>'cancel'));
		?>

	</div>
	<p class="ht5"></p>
</div>
<?php echo $this->Form->end(); ?>

<script>

$(document).ready(function(){
	$('.scheduleTime').html(parent.selectedTime);
	$('.scheduleTime').val(parent.selectedTime);
	//$.parent.(".overDueTime").cleck
	// condition to close fancyBox and show sucess msg to parent wind.
	var parentTickClass = '<?php echo $newCropPrescId ?>';
	if('<?php echo $setFlash == '1'?>'){
		//$('#flashMessage', parent.document).show();
		var route = "<?php echo $route ?>";
		if(route == '<?php echo $intravenousRoute['INTRAVENOUS'] ?>' || route == '<?php echo $intravenousRoute['INJECT INTRAMUSCULAR'];?>' ){//|| true ){ // true to make insert volume of drug mandatory
			$('#'+parentTickClass, parent.document).show().addClass('new');
		}else{
			$('#'+parentTickClass+'tick', parent.document).show();
			$('#sign', parent.document).removeAttr('disabled').removeClass('grayBtn').addClass('Bluebtn');
		}
		$('#'+parentTickClass+'-', parent.document).hide();
		parent.$(":checkbox[value="+parentTickClass+"]").attr("disabled",false).attr("checked",true);
		parent.insertedNewCropId.push( parentTickClass );
		parent.$.fancybox.close();
	}
	$('#cancel').click(function(){
		parent.$.fancybox.close();
		});
	jQuery("#MedicationAdministeringRecord").validationEngine({
		validateNonVisibleFields: true,
		updatePromptsPosition:true,
		});
	$('#submit').click(function() {
		var validatePerson = jQuery("#MedicationAdministeringRecord").validationEngine('validate');
		//return false;
	});
});
	 
</script>
