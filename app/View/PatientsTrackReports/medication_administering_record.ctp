<?php 
echo $this->Html->script(array('jquery-1.5.1.min','/js/languages/jquery.validationEngine-en','jquery.validationEngine',
		'ui.datetimepicker.3.js','jquery.autocomplete'));
echo $this->Html->css(array('jquery.autocomplete.css','jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','internal_style.css'));
?>
<?php 
echo $this->Form->create('MedicationAdministeringRecord',array('type' => 'file','id'=>'MedicationAdministeringRecord',
		'url'=>array('controller'=>'PatientsTrackReports','action'=>'medicationAdministeringRecord'),
		'inputDefaults' => array('label' => false, 'div' => false, 'error' => false	)));

echo $this->Form->hidden('id',array('type'=>'text'));
echo $this->Form->hidden('new_crop_prescription_id',array('value'=>$newCropPrescId));
echo $this->Form->hidden('patient_id',array('value'=>$patientId));

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
			<td valign="middle" class="tdLabel" id="boxSpace"><?php echo __("Performed date/time"); ?><font
				color="red">*</font></td>
				<?php $curentTime= substr($this->DateFormat->formatDate2LocalForReport(date('Y-m-d H:i:s'),Configure::read('date_format'),true),0 ,16);?>
			<td><?php echo $this->Form->input('performed_datetime', array('type'=>'text','value'=>$curentTime,'style'=>'width: 164px;','readonly'=>'readonly','class'=>'validate[required,custom[mandatory-enter]]','id' => 'performed_datetime')); ?>
			</td>
		</tr>
		<tr>
			<td class="tdLabel" id="boxSpace"><?php echo __('Performed By');?><font
				color="red">*</font>
			</td>
			<td><?php echo $this->Form->input('performed_by_txt', array('type'=>'text','value' => $this->Session->read('first_name')." ".$this->Session->read('last_name'),'id' => 'performed_by_txt','class'=>'validate[required,custom[mandatory-enter]]'));
			echo $this->Form->hidden('performed_by', array('type'=>'text','value' =>$this->Session->read('userid'),'id' => 'performed_by'));
			?>
			</td>
		</tr>


	</table>
	<!-- Patient Information end here -->

	<p class="ht5" style="margin: 16px 0px 21px 25px; width: 246px;">Last
		Documented Administration:</p>

	<!-- Links to Records start here -->
	<table width="97%" align="center" border="0" cellspacing="0"
		cellpadding="0" class="formFull">
		<tr>
			<td class="tdLabel" id="boxSpace" style="width: 28%;"><?php echo __('Primary pain intensity');?>
			</td>
			<td><?php echo $this->Form->input('pain_intensity', array('id' => 'pain_intensity','type'=>'text','class'=>'validate[optional,custom[onlyNumber]]')); ?>
			</td>
		</tr>
	</table>
	<p class="ht5"></p>
	<table width="97%" align="center" border="0" cellspacing="0"
		cellpadding="0" class="formFull">
		<tr>
			<td class="tdLabel" id="boxSpace"><?php echo __($medicationData['NewCropPrescription']['drug_name']);?>
			</td>
			<td><?php echo $this->Form->input('dose', array('style'=>"width: 110px;",'class'=>'validate[optional,custom[onlyNumber]]','value' => $medicationData['NewCropPrescription']['dose'])); ?>
			</td>
			<td><?php echo $this->Form->input('form', array('style'=>"width: 110px;",'options'=>Configure::read('strength'),'value' => $medicationData['NewCropPrescription']['strength'])); ?>
			</td>
			<td class="tdLabel" id="boxSpace"><?php echo __('Volume');?>
			</td>
			<td><?php echo $this->Form->input('volume', array('id'=>'volume','style'=>"width: 110px;",'class'=>'validate[optional,custom[onlyNumber]]','value' => $medicationData['NewCropPrescription']['volume'],'placeholder'=>'in ml')); ?>
			</td>
		</tr>
		<tr>
			<td class="tdLabel" id="boxSpace"><?php echo __('Diluent');?>
			</td><?php $diluentOption = array(''=>'<none>','Sodium Chloride Injection, USP'=>'Sodium Chloride Injection, USP',
					'Dextrose (5%) Injection, USP'=>'Dextrose (5%) Injection, USP',
					'Dextrose (5%) and Sodium Chloride (0.9%) Injection, USP'=>'Dextrose (5%) and Sodium Chloride (0.9%) Injection, USP',
					'5% Dextrose in 0.45% Sodium Chloride Solution'=>'5% Dextrose in 0.45% Sodium Chloride Solution',
					'Dextrose (5%) in Lactated Ringer\'s Solution'=>'Dextrose (5%) in Lactated Ringer\'s Solution',
					'Sodium Lactate (1/6 Molar) Injection, USP'=>'Sodium Lactate (1/6 Molar) Injection, USP',
					'Lactated Ringer\'s Injection, USP'=>'Lactated Ringer\'s Injection, USP');?>
			<td><?php echo $this->Form->input('diluent', array('style'=>"width: 110px;",'options'=>$diluentOption,'id'=>'diluentType')); ?>
			</td>
			<td><?php echo $this->Form->input('diluent_volume', array('id'=>'diluentVolume','readOnly'=>true,'class'=>'validate[optional,custom[onlyNumber]]','style'=>"width: 110px;",'placeholder'=>'in ml')); ?>
			</td>
			<?php if($medicationData['NewCropPrescription']['route'] == 'intravenous'):?>
			<td class="tdLabel" id="boxSpace"><?php echo __('Bag no');?>
			</td>
			<td><?php echo $this->Form->input('bag_no', array('value'=>$bagCount+1,'readOnly'=>true,'id'=>'bag','style'=>"width: 110px;")); ?>
			</td>
			<?php endif;?>
		</tr>
		<tr>
			<td class="tdLabel" id="boxSpace"><?php echo __('Route');?>
			</td>
			<td><?php echo $this->Form->input('route', array('style'=>"width: 110px;",'options'=>Configure::read('route_administration'),'value' => $medicationData['NewCropPrescription']['route'])); ?>
			</td>
			<?php if($medicationData['NewCropPrescription']['route'] == 'intravenous' || $medicationData['NewCropPrescription']['route'] == 'IV Push'):?>
			<td class="tdLabel" id="boxSpace"><?php echo __('Site');?><font
				color="red">*</font>
			</td>
			<td><?php echo $this->Form->input('site', array('style'=>"width: 110px;",'options'=>Configure::read('site'),'class'=>'validate[required,custom[mandatory-select]]')); ?>
			</td>
			<?php endif;?>
		</tr>
		<tr>
			<td class="tdLabel" id="boxSpace"><?php echo __('Reason');?>
			</td>
			<td><?php echo $this->Form->input('reason', array('style'=>"width: 110px;",'class'=>'validate[optional,custom[onlyLetterSp]]')); ?>
			</td>
		</tr>
		<tr>
			<td class="tdLabel" id="boxSpace"><?php echo __('Total volume');?>
			</td>
			<td><?php echo $this->Form->input('total_volume', array('id'=>'totalVolume','style'=>"width: 110px;",'readOnly'=>true)); ?>
			</td>

			<td class="tdLabel" id="boxSpace"><?php echo __('Infused over');?>
			</td>
			<td><?php echo $this->Form->input('infused_time', array('style'=>"width: 110px;",'class'=>'validate[optional,custom[onlyNumber]]','id'=>'infused_time')); ?>
			</td><?php $infTimeOption = array(''=>'<none>','minutes'=>'Minutes','hour'=>'Hour');?>
			<td><?php echo $this->Form->input('inf_time_unit', array('style'=>"width: 110px;",'options' => $infTimeOption,'id'=>'inf_time_unit')); ?>
			</td>
		</tr>
	</table>
	<p class="ht5"></p>
	<!-- EOF address infto and BOF diagnosis -->
	<table width="97%" align="center" border="0" cellspacing="0"
		cellpadding="0" class="formFull">
		<tr>
			<td width="2%" class="tdLabel" id="boxSpace"><?php echo $this->Form->checkbox('not_given',array('id'=>'not_given'));?>
			</td>
			<td valign="bottom">Not given</td>
		</tr>
		<tr style="display: none" id="notGivenReason">
			<td>&nbsp;</td>
			<td width="2%" class="tdLabel" id="boxSpace"><?php echo __('Reason');?>
			</td>
			<td><?php echo $this->Form->input('not_given_reason', array('class'=>"textBoxExpnd",'id'=>'notGivenReasonInput')); ?>
			</td>
		</tr>

	</table>
	<p class="ht5"></p>
	<div style="margin-left: 22px;">
		<?php echo $this->Form->button('comment', array('type'=>'button','class'=>"grayBtn",'id' => 'comment')); ?>
	</div>
	<div id="commentDiv" style="margin-left: 22px; display: none;">
		<?php echo $this->Form->textarea('comment', array('class'=>"textBoxExpnd",'id'=>'commentInput')); ?>

	</div>
	<div class="btns" style="margin-top: -15px;">
		<input class="blueBtn" type="submit" value="Ok" id="submit">
		<?php
		echo $this->Form->input(__('Cancel'),array('type'=>'button','id'=>'cancelBtn','class'=>'blueBtn'));
		?>

	</div>
	<p class="ht5"></p>
</div>
<?php echo $this->Form->end(); ?>

<script>

$(document).ready(function(){
	// condition to close fancyBox and show sucess msg to parent wind.
	var parentTickClass = '<?php echo $newCropPrescId ?>';
	if('<?php echo $setFlash == '1'?>'){
		
		$('#flashMessage', parent.document).show();
		$('#'+parentTickClass, parent.document).hide();
		$('#'+parentTickClass+'tick', parent.document).show();
		$('#sign', parent.document).removeAttr('disabled').removeClass('grayBtn').addClass('Bluebtn');
		parent.insertedNewCropId.push( parentTickClass);
		parent.$.fancybox.close();
	}

	jQuery("#MedicationAdministeringRecord").validationEngine({
		validateNonVisibleFields: true,
		updatePromptsPosition:true,
		});
	$('#submit').click(function() {
		var validatePerson = jQuery("#MedicationAdministeringRecord").validationEngine('validate');
	});

	$('#cancelBtn').click(function(){
		parent.$.fancybox.close();
		});

	$('#diluentType').change(function(){
		if($(this).val() != ''){
			$('#diluentVolume').attr('readonly', false); 
		  } else {
			  $('#diluentVolume').val('');
		     $('#diluentVolume').attr('readonly', true);
		}
		});
	
	
	$('#comment').click(function(){
		if($("#commentDiv").is(':visible')){
			$('#commentInput').val('');
			$('#commentDiv').hide();
		}else{
			$('#commentDiv').show();
		}
		});
	$('#not_given').click(function(){
		if($(this).attr('checked')) {
		    $("#notGivenReason").show();
		} else {
			$("#notGivenReasonInput").val('');
		    $("#notGivenReason").hide();
		}
		});

	if($(this).attr('checked')) {
	    $("#notGivenReason").show();
	} else {
	    $("#notGivenReason").hide();
	}
	
	$("#performed_by_txt").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","User",'id',"full_name",'null',"admin" => false,"plugin"=>false)); ?>", {
		width: 250,
		selectFirst: true,
		valueSelected:true,
		showNoId:true,
		loadId : 'performed_by_txt,performed_by'
	});


	$("#performed_datetime").datepicker(
			{	
				showOn : "button",
				style : "margin-left:50px",
				buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif',array('style'=>'float: inherit; vertical-align: top;')); ?>",
				buttonImageOnly : true,
				changeMonth : true,
				changeYear : true,
				yearRange : '1950',
				dateFormat:'<?php echo $this->General->GeneralDate("HH:II");?>',
				/*onSelect : function() {
					$(this).focus();
				}*/
	});
	calculateVolume();//calls function on document ready
	var volume,diluentVolume,totalVolume;
	 function calculateVolume() { 
		// on load set bmi
		volume = ($("#volume").val() == '') ? 0 : $("#volume").val();
		diluentVolume = ($("#diluentVolume").val() == '') ? 0 : $("#diluentVolume").val();
		totalVolume = parseFloat(volume) + parseFloat(diluentVolume);
		if(!isNaN(totalVolume) && totalVolume != 0)
			$("#totalVolume").val(totalVolume);
		else
			$("#totalVolume").val('');
	};
	

	$('#volume, #diluentVolume').change(function() {
		calculateVolume();
	});     

$('#infused_time').change(function (){
	if($('#infused_time').val() != '')
		$('#inf_time_unit').addClass('validate[required,custom[mandatory-select]]');
	else
		$('#inf_time_unit').removeClass('validate[required,custom[mandatory-select]]');
	});
$('#inf_time_unit').change(function (){
	if($('#inf_time_unit').val() != '')
		$('#infused_time').addClass('validate[required,custom[mandatory-select]]');
	else
		$('#infused_time').removeClass('validate[required,custom[mandatory-select]]');
	});
                
});
	 
	</script>
