<style>
.border {
	border: 1px solid;
}
</style>
<?php 
echo $this->Html->script(array('jquery-1.9.1.js','jquery-ui-1.10.2.js',
		'jquery.validationEngine2','/js/languages/jquery.validationEngine-en','ui.datetimepicker.3.js','jquery.autocomplete'));
echo $this->Html->css(array('jquery.autocomplete.css','jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','internal_style.css'));
?>
<script>

var matched, browser;

jQuery.uaMatch = function( ua ) {
    ua = ua.toLowerCase();

    var match = /(chrome)[ \/]([\w.]+)/.exec( ua ) ||
        /(webkit)[ \/]([\w.]+)/.exec( ua ) ||
        /(opera)(?:.*version|)[ \/]([\w.]+)/.exec( ua ) ||
        /(msie) ([\w.]+)/.exec( ua ) ||
        ua.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec( ua ) ||
        [];

    return {
        browser: match[ 1 ] || "",
        version: match[ 2 ] || "0"
    };
};

matched = jQuery.uaMatch( navigator.userAgent );
browser = {};

if ( matched.browser ) {
    browser[ matched.browser ] = true;
    browser.version = matched.version;
}

// Chrome is Webkit, but Webkit is also Safari.
if ( browser.chrome ) {
    browser.webkit = true;
} else if ( browser.webkit ) {
    browser.safari = true;
}

jQuery.browser = browser;
</script>
<?php 
echo $this->Form->hidden('MedicationAdministeringRecord.id',array('type'=>'text','value'=>$medicationData['MedicationAdministeringRecord']['id']));
echo $this->Form->hidden('MedicationAdministeringRecord.new_crop_prescription_id',array('value'=>$newCropPrescId));
echo $this->Form->hidden('MedicationAdministeringRecord.patient_id',array('value'=>$patientId));

?>

<div class="clr">&nbsp;</div>
<table width="97%" align="center" border="0" cellspacing="0"
	cellpadding="0" class="tabularForm">
	<tr>
		<td colspan="2"><strong><span style="text-align: left;"><?php echo __($medicationData['NewCropPrescription']['description']);?>
			</span><br /> <span style="text-align: left; margin-left: 17px;"><?php echo __($medicationData['PatientOrder']['sentence']);?>
			</span> </strong></td>
	</tr>
</table>
<div class="clr">&nbsp;</div>
<table cellspacing="0" cellpadding="0" border="0" align="center"
	width="97%">
	<tr class="row_gray">
		<?php $dateBack = substr($this->DateFormat->formatDate2LocalForReport(date('Y-m-d H:i:s',strtotime("-1 day")),Configure::read('date_format'),true),0 , 16);
			  $dateFront = substr($this->DateFormat->formatDate2LocalForReport(date('Y-m-d H:i:s'),Configure::read('date_format'),true),0 , 16);;?>

		<td align="center" colspan=<?php echo '3';?> style="font-size: 13px"><?php echo $dateBack." - ".$dateFront;?>
		</td>
	</tr>
</table>
<div class="clr">&nbsp;</div>
<div class="inner_left" style="padding-left: 20px;">

	<table width="35%" align="left" border="0" cellspacing="1"
		cellpadding="0" class="tabularForm">
		<tr class="statusTD">
			<td width="45%">&nbsp;</td>
			<?php $performedDatetime= substr($this->DateFormat->formatDate2Local($medicationData['MedicationAdministeringRecord']['performed_datetime'],Configure::read('date_format'),true),0 ,16);?>
			<td width=""><?php echo __($performedDatetime);?></td>
		</tr>
		<tr class="statusTD">
			<td style="cursor: pointer;" id="beginBag" class="windowOptions"><?php echo __("Begin Bag");?>
			</td>
			<td><strong>Bag no <?php echo $medicationData['MedicationAdministeringRecord']['bag_no'];?>
			</strong></td>
		</tr>
		<tr>
			<td style="cursor: pointer;" id="siteChange" class="windowOptions"><?php echo __("Site Change");?>
			</td>
			<td><strong><?php echo $medicationData['MedicationAdministeringRecord']['site'];?>
			</strong></td>
		</tr>
		<tr>
			<td style="cursor: pointer;" id="infuse" class="windowOptions"><?php echo __("Infuse");?>
			</td>
			<td><strong><?php echo $medicationData['MedicationAdministeringRecord']['infuse_vol'];?>ml</strong>
			</td>
		</tr>
		<tr>
			<td style="cursor: pointer;" id="bolus" class="windowOptions"><?php echo __("Bolus");?>
			</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td style="cursor: pointer;" id="waste" class="windowOptions"><?php echo __("Waste");?>
			</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td style="cursor: pointer;" id="rateChange" class="windowOptions"><?php echo __("Rate Change");?>
			</td>
			<td><strong><?php echo $medicationData['MedicationAdministeringRecord']['inf_volume_hourly'];?>ml/hr</strong>
			</td>
		</tr>
	</table>
</div>
<div class="clr">&nbsp;</div>
<div
	class="inner_left">
	<table width="97%" align="center" border="0" cellspacing="0"
		cellpadding="0" class="tabularForm">
		<tr>
			<td colspan="2"><strong><span style="text-align: left;"><?php echo __($medicationData['NewCropPrescription']['description']);?>
				</span><br /> <span style="text-align: left; margin-left: 17px;"><?php echo __($medicationData['PatientOrder']['sentence']);?>
				</span> </strong></td>
		</tr>
	</table>
	<div class="clr ht5"></div>
	<table width="97%" align="center" border="0" cellspacing="0"
		cellpadding="0" class="formFull">
		<?php $infHours = $medicationData['MedicationAdministeringRecord']['infused_time'];
			$yes = (strtotime(date('Y-m-d H:i')) >= strtotime($performedDatetime) && strtotime(date('Y-m-d H:i')) <= strtotime($performedDatetime)+3600*$infHours)? true : false; ?>
		<?php $no = $yes ? false : true;?>
		<tr>
			<td class="tdLabel" width="10%"><?php echo $this->Form->checkbox('Yes', array('checked'=>$yes,'disabled'=>true,'hiddenField'=>false)); ?><span>Yes</span>
			</td>
			<td class="tdLabel" width="8%"><?php echo $this->Form->checkbox('No', array('checked'=>$no,'disabled'=>true,'hiddenField'=>false)); ?><span>No</span>
			</td>
			<td class="tdLabel"><strong><?php echo __($medicationData['NewCropPrescription']['description']);?>
			</strong>
			</td>
		</tr>
	</table>
	<div class="clr ht5"></div>
	<!-- Start of Begin Bag HTML -->
	<div class="optionDiv" id="BEGINBAG" style="display: block;">
		<?php echo $this->Form->create('BeginBag',array('type' => 'file','class'=>'MedicationAdministeringRecord',
				'url'=>array('controller'=>'PatientsTrackReports','action'=>'contineousInfusionChanges',$patientId,$newCropPrescId),
				'inputDefaults' => array('label' => false, 'div' => false, 'error' => false	)));?>
		<table width="97%" align="center" border="0" cellspacing="0"
			cellpadding="0" class="formFull">

			<tr>
				<td valign="middle" class="tdLabel" id="boxSpace"><?php echo __("Performed date/time"); ?><font
					color="red">*</font></td>

				<td><?php echo $this->Form->input('BeginBag.performed_datetime', array('type'=>'text','value'=>$performedDatetime,'style'=>'width: 92%;',
						'readonly'=>'readonly','class'=>'textBoxExpnd datePicker validate[required,custom[mandatory-enter]]','id' => 'performed_datetime')); ?>
				</td>
				<td style="float: right; width: 50%;"><?php echo $this->Form->button(__('Comment'),array('type' => 'button','class'=>'blueBtn'));?>
				</td>
			</tr>
			<tr>
				<td class="tdLabel" id="boxSpace"><?php echo __('Performed By');?><font
					color="red">*</font>
				</td>
				<td><?php echo $this->Form->input('performed_by_txt', array('type'=>'text','value' => $this->Session->read('first_name')." ".$this->Session->read('last_name'),
						'id' => 'performed_by_txt','class'=>'userAutoComplete textBoxExpnd validate[required,custom[mandatory-enter]]','label'=>false));
				echo $this->Form->hidden('BeginBag.performed_by', array('type'=>'text','value' =>$this->Session->read('userid'),'id' => 'performed_by_0'));
				?>
				</td>
				<td style="float: right; width: 50%;"><?php echo $this->Form->button(__('Clear'),array('style'=>"width:95%",'type' => 'button','class'=>'blueBtn'));?>
				</td>


			</tr>
			<tr>
				<td class="tdLabel" id="boxSpace"><?php echo __('Witnessed by');?>
				</td>
				<td><?php echo $this->Form->input('witnessed_by_txt', array('id'=>'witnessed_by_txt','class'=>'textBoxExpnd userAutoComplete','label'=>false)); 
						echo $this->Form->hidden('BeginBag.witnessed_by', array('id'=>'witnessed_by_0','type'=>'text'));?>
				</td>
				<td style="float: right; width: 50%;"><?php echo $this->Form->submit(__('Apply'),array('id'=>'beginApply','disabled'=>$yes,'style'=>"width:95%",'class'=>'blueBtn'));?>
				</td>
			</tr>
			<tr>
				<td class="tdLabel" id="boxSpace"><?php echo __("Bag no");?>
				</td>
				<?php $bagno = $yes ? $medicationData['MedicationAdministeringRecord']['bag_no'] : $medicationData['MedicationAdministeringRecord']['bag_no']+1;?>
				<td><?php echo $this->Form->input('BeginBag.bag_no', array('value' => $bagno,'class'=>'textBoxExpnd','label'=>false)); ?>
				</td>

			</tr>
			<tr>
				<td class="tdLabel" id="boxSpace"><?php echo __('Site');?><font
					color="red">*</font>
				</td>
				<?php $site = $yes ? $medicationData['MedicationAdministeringRecord']['site'] : ''; ?>
				<td><?php echo $this->Form->input('BeginBag.site', array('options'=>Configure::read('site'),'label'=>false,
						'class'=>'textBoxExpnd validate[required,custom[mandatory-select]]','value'=>$site)); ?>
				</td>
			</tr>
			<tr>
				<td class="tdLabel" id="boxSpace"><?php echo __('Volume');?>
				</td>
				<?php $volume = $yes ? $medicationData['MedicationAdministeringRecord']['volume'] : ''; ?>
				<td><?php echo $this->Form->input('BeginBag.volume', array('id'=>'volume','placeholder'=>'in ml','value' => $volume,
						'class'=>'validate[optional,custom[onlyNumber]] textBoxExpnd','label'=>false)); ?>
				</td>
			</tr>
			<tr>
				<td class="tdLabel" id="boxSpace"><?php echo __('Diluent');?>
				</td>
				<?php $diluentOption = array(''=>'<none>','Sodium Chloride Injection, USP'=>'Sodium Chloride Injection, USP',
						'Dextrose (5%) Injection, USP'=>'Dextrose (5%) Injection, USP',
						'Dextrose (5%) and Sodium Chloride (0.9%) Injection, USP'=>'Dextrose (5%) and Sodium Chloride (0.9%) Injection, USP',
						'5% Dextrose in 0.45% Sodium Chloride Solution'=>'5% Dextrose in 0.45% Sodium Chloride Solution',
						'Dextrose (5%) in Lactated Ringer\'s Solution'=>'Dextrose (5%) in Lactated Ringer\'s Solution',
						'Sodium Lactate (1/6 Molar) Injection, USP'=>'Sodium Lactate (1/6 Molar) Injection, USP',
					'Lactated Ringer\'s Injection, USP'=>'Lactated Ringer\'s Injection, USP');?>
				<td><?php echo $this->Form->input('diluent', array('style'=>"width: 110px;",'options' => $diluentOption)); ?>
					<?php echo $this->Form->input('diluent_volume', array('id'=>'diluentVolume','style'=>"width: 110px;",
							'placeholder'=>'in ml','class'=>'validate[optional,custom[onlyNumber]]')); ?>
				</td>

			</tr>
			<tr>
				<td class="tdLabel" id="boxSpace"><?php echo __('Total volume');?>
				</td>
				<td><?php echo $this->Form->input('total_volume', array('id'=>'totalVolume','readOnly'=>true)); ?>
				<span>Dose available</span>
					<?php echo $this->Form->input('avail_dose', array('placeHolder'=>'in mg','id'=>'availDose','class'=>'checkRate validate[optional,custom[onlyNumber]]')); ?>
				</td>
			</tr>
			<tr>
				<td class="tdLabel" id="boxSpace"><?php echo __('Dose ordered');?>
				</td>
				<td><?php echo $this->Form->input('BeginBag.dose_ordered', array('placeHolder'=>'in mcg','id'=>'doseOrdered','class'=>'checkRate validate[optional,custom[onlyNumber]]')); ?>

					<span>Patient's weight</span>
					<?php echo $this->Form->input('weight', array('placeHolder'=>'in Kg','id'=>'patientWeight','class'=>'checkRate validate[optional,custom[onlyNumber]]')); ?>
				</td>
			</tr>
			<tr>
				<td class="tdLabel" id="boxSpace"><?php echo __('Rate (ml/hr)');?>
				</td>
				<td><?php echo $this->Form->input('BeginBag.inf_volume_hourly', array('id'=>'inf_volume_hourly','class'=>'textBoxExpnd','label'=>false)); ?>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td style="float: right; width: 50%;"><font size="4"><strong><?php echo __("Begin Bag");?>
					</strong> </font></td>
			</tr>
		</table>
		<?php echo $this->Form->end();?>

	</div>
	<!-- End of Begin Bag -->
	<!-- start of Infuse -->
	<div class="optionDiv" id="INFUSE" style="display: none;">
		<table width="97%" align="center" border="0" cellspacing="0"
			cellpadding="0" class="formFull">
			<tr>
				<td valign="middle" class="tdLabel" id="boxSpace"><?php echo __("Infuse Volume (ml)"); ?><font
					color="red">*</font></td>

				<td><?php echo $this->Form->input('volume', array('type'=>'text','class'=>'validate[required,custom[mandatory-enter]]','style'=>"width: 76%;")); ?>
					<?php echo $this->Form->checkbox('bolus', array('label'=>false,'class'=>'bolus'));?><span
					style="vertical-align: 2px;" class="bolus">&nbsp;<strong><?php echo  __("Bolus"); ?>
					</strong>
				</span>
				</td>
				<td style="float: right; width: 55%;"><?php echo $this->Form->button(__('Comment'),array('type' => 'button','class'=>'blueBtn'));?>
				</td>
			</tr>
			<tr>
				<td class="tdLabel" id="boxSpace"><?php echo __("From");?><font
					color="red">*</font>
				</td>
				<td><?php echo $this->Form->input('from', array('class'=>'datePicker textBoxExpnd','style'=>"width: 92%;",'id'=>'INFfrom')); ?>
				</td>
				<td style="float: right; width: 55%;"><?php echo $this->Form->button(__('Clear'),array('style'=>"width:95%",'type' => 'button','class'=>'blueBtn'));?>
				</td>
			</tr>
			<tr>
				<td class="tdLabel" id="boxSpace"><?php echo __("To");?><font
					color="red">*</font>
				</td>
				<td><?php echo $this->Form->input('to', array('class'=>'datePicker textBoxExpnd','style'=>"width: 92%;",'id'=>'INFto')); ?>
				</td>
				<td style="float: right; width: 55%;"><?php echo $this->Form->button(__('Apply'),array('style'=>"width:95%",'type' => 'button','class'=>'blueBtn'));?>
				</td>
			</tr>
			<tr>
				<td class="tdLabel" id="boxSpace"><?php echo __("Infused Over");?>
				</td>
				<td id="INFoverTime"></td>
			</tr>
			<tr>
				<td class="tdLabel" id="boxSpace"><?php echo __('Performed By');?><font
					color="red">*</font>
				</td>
				<td><?php echo $this->Form->input('performed_by_txt', array('type'=>'text','value' => $this->Session->read('first_name')." ".$this->Session->read('last_name'),
						'id' => 'INFperformed_by_txt','class'=>'userAutoComplete textBoxExpnd validate[required,custom[mandatory-enter]]'));
				echo $this->Form->hidden('performed_by', array('type'=>'text','value' =>$this->Session->read('userid'),'id' => 'INFperformed_by_0'));
				?>
				</td>
			</tr>
			<tr class="bolus" style="display: none;">
				<td class="tdLabel"><?php echo __('Witnessed by');?>
				</td>
				<td><?php echo $this->Form->input('witnessed_by_txt', array('id'=>'witnessed_by_txt','class'=>'textBoxExpnd userAutoComplete')); 
						echo $this->Form->hidden('witnessed_by', array('id'=>'INFwitnessed_by_0','type'=>'text'));?>
				</td>
			</tr>
			<tr>
				<td class="tdLabel" id="boxSpace"><?php echo __("Bag #");?>
				</td>
				<td><?php echo $this->Form->input('bag_no', array('value' => $medicationData['MedicationAdministeringRecord']['bag_no']+1,
						'class'=>'textBoxExpnd','readonly'=>true)); ?>
				</td>

			</tr>
			<tr>
				<td class="tdLabel" id="boxSpace"><?php echo __('Site');?><font
					color="red">*</font>
				</td>
				<td><?php echo $this->Form->input('site', array('options'=>Configure::read('site'),
						'class'=>'textBoxExpnd validate[required,custom[mandatory-select]]')); ?>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td style="float: right; width: 50%; display: none;" class="bolus"><font
					size="4"><strong><?php echo __("Bolus");?> </strong> </font></td>
				<td style="float: right; width: 50%;" class="infuse"><font size="4"><strong><?php echo __("Infuse");?>
					</strong> </font></td>
			</tr>
		</table>
	</div>
	<!-- End Of Infuse -->
</div>

<script>

$(document).ready(function(){

	jQuery(".MedicationAdministeringRecord").validationEngine({
		validateNonVisibleFields: true,
		updatePromptsPosition:true,
		});
	
	$('#beginBag').addClass('border');
	// condition to close fancyBox and show sucess msg to parent wind.
	var parentTickClass = '<?php echo $newCropPrescId ?>';
	if('<?php echo $setFlash == '1'?>'){
		
		$('#flashMessage', parent.document).show();
		$('#'+parentTickClass, parent.document).hide();
		$('#'+parentTickClass+'tick', parent.document).show();
		$('#sign', parent.document).removeAttr('disabled').removeClass('grayBtn').addClass('Bluebtn');
		parent.$.fancybox.close();
	}

	$(".userAutoComplete").on('focus',function() { 
		$(this).autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","User",'id',"full_name",'null',"admin" => false,"plugin"=>false)); ?>", {
		width: 250,
		selectFirst: true,
		valueSelected:true,
		showNoId:true,
		loadId : $(this).attr('id')+','+$(this).attr('id').replace("txt","0")//'performed_by_txt,performed_by'
		});
	});
	$(".datePicker").datepicker(
			{
				showOn : "button",
				style : "margin-left:50px",
				buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly : true,
				changeMonth : true,
				changeYear : true,
				yearRange : '1950',
				dateFormat:'<?php echo $this->General->GeneralDate("HH:II");?>',
				onSelect : function() {
					$(this).focus();
					$('#INFto').trigger('change');
				}
	});
	$('#INFto').change(function() {
		if($('#INFto').val() !='' && $('#INFfrom').val() !=''){
			var fromTime,toTime;
			fromTime = new Date($('#INFfrom').val());
			toTime = new Date($('#INFto').val());
			var diff = Math.abs(fromTime - toTime);
			if (Math.floor(diff/86400000)) {
				if (Math.floor(diff/86400000) == 1)
					$('#INFoverTime').html(Math.floor(diff/86400000) + " Day");
				else
					$('#INFoverTime').html(Math.floor(diff/86400000) + " Days");
			    } else if (Math.floor(diff/3600000)) {
			    	if(Math.floor(diff/3600000) == 1)
			    		$('#INFoverTime').html(Math.floor(diff/3600000) + " Hour");
				    else
			    		$('#INFoverTime').html(Math.floor(diff/3600000) + " Hours");
			    } else if (Math.floor(diff/60000)) {
				    if(Math.floor(diff/60000) == 1)
			    		$('#INFoverTime').html(Math.floor(diff/60000) + " Minute");
				    else
				    	$('#INFoverTime').html(Math.floor(diff/60000) + " Minutes");
			    } else {
			    	$('#INFoverTime').html("< 1 minute");
			    }
		}
		else { 
			return false;
		}
	});
	
	$('.windowOptions').click(function(){
		$('td').removeClass('border');
		
		if($(this).attr('id') == 'bolus'){
			$('#bolus').addClass('border');
			$('.optionDiv').fadeOut('fast');
			$('#INFUSE').fadeIn('slow');
			$('.bolus').fadeIn('slow').attr({'checked':true,'disabled':true});
			$('.infuse').hide();
		}else {
			$('#'+$(this).attr('id')).addClass('border');
			$('.optionDiv').fadeOut('fast');
			$('#'+$(this).attr('id').toUpperCase()).fadeIn('slow');
			$('.bolus').hide();
			$('.infuse').fadeIn('slow');
		}
			
	});

	$('#beginApply').click(function(){
		//alert('yes');
	});

	calculateVolume();//calls function on document ready
	var volume,diluentVolume,totalVolume;
	 function calculateVolume() {
		// on load set bmi
		volume = ($("#volume").val() == '') ? 0 : $("#volume").val();
		diluentVolume = ($("#diluentVolume").val() == '') ? 0 : $("#diluentVolume").val();
		totalVolume = parseInt(volume) + parseInt(diluentVolume);
		if(!isNaN(totalVolume) && totalVolume != 0)
		$("#totalVolume").val(totalVolume);
	};
	$('#volume, #diluentVolume').change(function() {
		calculateVolume();
	}); 
	//var idArray = new Array( '#inf_time_unit','#totalVolume','#availDose','#doseOrdered','#patientWeight');
	//$('#inf_time_unit,#totalVolume,#availDose,#doseOrdered,#patientWeight').on('focusOut focus keyUp', function(){
	$('.checkRate').keyup(function(){
		calculateRate();
	});

	function calculateRate(){
		var mgPerHr = ( (parseInt($('#doseOrdered').val()) * parseInt($('#patientWeight').val())) / 1000 ) * 60;
		var mlPerHr = ( (parseInt(mgPerHr)) / parseInt($('#availDose').val()) ) * parseInt($('#totalVolume').val());
		if(!isNaN(mlPerHr))
		$('#inf_volume_hourly').val(mlPerHr);	
	}  
	/*function calculateRate(){
		if($('#totalVolume').val() == '' || $('#inf_time_unit').val() == '')return false;
			if($('#inf_time_unit').val() == 'hour'){
				var infVolumeHourl = parseInt($("#totalVolume").val())/parseInt($('#infused_time').val());
				$('#inf_volume_hourly').val(infVolumeHourl);
				}else{
				infusedHour = parseInt($('#infused_time').val())/60;
				var infVolumeHourl =parseInt($("#totalVolume").val())/infusedHour;
				$('#inf_volume_hourly').val(infVolumeHourl);
			}
		
	}*/
	    
});
	 
	</script>
