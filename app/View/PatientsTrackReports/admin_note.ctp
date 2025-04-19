<?php 
echo $this->Html->script(array('jquery-1.5.1.min','/js/languages/jquery.validationEngine-en','jquery.validationEngine'));
echo $this->Html->css(array('jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','internal_style.css'));
?>
<?php 
echo $this->Form->create('MedicationAdministeringRecord',array('type' => 'file','id'=>'MedicationAdministeringRecord',
		url=>array('controller'=>'PatientsTrackReports','action'=>'adminNote'),
		'inputDefaults' => array('label' => false, 'div' => false, 'error' => false	)));
echo $this->Form->hidden('id',array('type'=>'text'));
echo $this->Form->hidden('new_crop_prescription_id',array('value'=>$newCropPrescId));
echo $this->Form->hidden('patient_id',array('value'=>$patientId));

?>
<div class="inner_title">
	<h3> &nbsp; <?php echo __('Admin Note', true); ?></h3>
	<span></span>
</div>
<div
	class="inner_left">
	<table width="97%" height="20%" align="center" border="0" cellspacing="0"
		cellpadding="0" class="tabularForm">
		<tr>
			<td style=""><?php echo $this->Html->image('icons/mar_icon/mar5.png');?>
				<br /> <strong><span style="text-align: left;"><?php echo __($medicationData['NewCropPrescription']['description']);?>
				</span><br /> <span style="text-align: left; margin-left: 17px;"><?php echo __($medicationData['PatientOrder']['sentence']);?>
				</span> </strong></td>
		</tr>
	</table>
	<p class="ht5"></p>
	<!-- EOF address infto and BOF diagnosis -->
	<table width="97%" align="center" border="0" cellspacing="0"
		cellpadding="0" class="formFull">
		<tr>
			<td width="2%" class="tdLabel" id="boxSpace"><?php echo $this->Form->input('comment',array('rows'=>"13",'style'=>'width:97%;','type'=>'textarea','id'=>'comment'));?>
			</td>
		</tr>
	</table>
	<p class="ht5"></p>
		<div class="btns" style="margin-top: -15px;">
		<?php
		echo $this->Html->link(__('Clear'),'#',array('escape' => false,'class'=>'blueBtn','id'=>'clear'));
		?>
		<input class="blueBtn" type="submit" value="Ok" id="submit">
		<?php
		echo $this->Html->link(__('Cancel'),'#', array('escape' => false,'class'=>'blueBtn','id'=>'cancel'));
		?>

	</div>
	<p class="ht5"></p>
</div>
<?php echo $this->Form->end(); ?>

<script>

$(document).ready(function(){

	// condition to close fancyBox and show sucess msg to parent wind.
	if('<?php echo $setFlash == '1'?>'){
		$('#flashMessageRoot', parent.document).show();
		parent.$.fancybox.close();
	}

	jQuery("#MedicationAdministeringRecord").validationEngine({
		validateNonVisibleFields: true,
		updatePromptsPosition:true,
		});
	$('#submit').click(function() {
		var validatePerson = jQuery("#MedicationAdministeringRecord").validationEngine('validate');
		//return false;
	});

	$('#clear').click(function() {
		$('#comment').val('');
	});
	$('#cancel').click(function() {
		parent.$.fancybox.close();
	});
});
	 
</script>
