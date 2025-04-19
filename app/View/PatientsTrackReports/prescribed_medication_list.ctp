<?php //echo "<pre>";pr($this->Session);
/**
 * TODO $this->Form->hidden("SignMar.$administerOverDueMeds['2']",  find this
 */
echo $this->Html->script(array('jquery-1.5.1.min','jquery-ui-1.8.5.custom.min.js'));
echo $this->Html->css(array('internal_style.css'));
$intravenousRoute = configure::read('selected_route_administration');
$makeCrossMandatory = false;// this will always display blue cross icon
?>
<style>
.ready {
	margin-left: 20px;
	margin-top: 0px;
}

.pagetxt {
	margin-left: 412px;
	margin-top: -15px;
}

.positionBtn {
	margin-left: 730px;
	margin-top: -39px;
}
</style>
<div id="flashMessage" class="message" style="display: none">
	<?php echo __("Sucessfully saved please press Sign to complete");?>
</div>
<div class="patient_info">
	<?php echo $this->element('patient_information');?>
</div>
<table cellspacing="0" cellpadding="0" border="0" align="center"
	width="95%">
	<tr class="row_gray">
		<?php $dateBack = substr($this->DateFormat->formatDate2LocalForReport(date('Y-m-d H:i:s',strtotime("-1 hour")),Configure::read('date_format'),true),0 , 16);
			  $dateFront = substr($this->DateFormat->formatDate2LocalForReport(date('Y-m-d H:i:s',strtotime("+1 hour")),Configure::read('date_format'),true),0 , 16);?>

		<td align="center" colspan=<?php echo '3';?> style="font-size: 13px"><?php echo $dateBack." - ".$dateFront." (Clinical Range)";?>
		</td>
	</tr>
</table>
<div class="clr">&nbsp;</div>
<span style="opacity: 0;"><?php echo $this->Form->input('scan',array('div'=>false,'label'=>false,'id'=>'scanId')); ?>
</span>
<form id="SignMar">
	<table cellspacing="0" cellpadding="0" border="0" align="center"
		width="95%">
		<tr class="row_title">
			<td width="5%">&nbsp;</td>
			<td width="7%">&nbsp;</td>
			<td width="9%" style="font-size: smaller;"><strong><?php echo __("Scheduled");?></strong></td>
			<td width="34%" style="font-size: smaller;"><strong><?php echo __("Mnemonic");?></strong></td>
			<td style="font-size: smaller;"><strong><?php echo __("Details");?></strong></td>
		</tr>
		<?php $varcnt = 0 ;
		$toggle =0;
		foreach($administerNowMeds['1'] as $key => $administerOverDueMeds):
		if($toggle == 0) {
		       	echo "<tr class='row_gray'>";
		       	$toggle = 1;
	       }else{
		       	echo "<tr>";
		       	$toggle = 0;
	       }
	       $keyAsId = preg_replace('/[^A-Za-z0-9\-]/', '', $key);
	       $varcnt++;
	       ?>

		<td width="7%"><?php echo $this->Form->checkbox("SignMar.$varcnt.id",array('value'=>$administerOverDueMeds['2'],'id'=>$keyAsId.$varcnt,'label'=>false,
				'class'=>'prescMed','hiddenField'=>false,'disabled'=>true));
		?>
		</td>
		<td width="7%" class="overDueTiming"><span><?php echo $this->Html->image('icons/mar_icon/alarm.png',
				array('class'=>$keyAsId.$varcnt.'alarm alarm', 'id'=>$administerOverDueMeds['2']."-",'style'=>'display:block;'));?>
		</span> <span><?php echo $this->Html->image('icons/mar_icon/tick1.png',
				array('class'=>$keyAsId.$varcnt."tick",'style'=>'display:none;','id'=>$administerOverDueMeds['2'].'tick'));?>
		</span> <?php if($administerOverDueMeds['3'] == $intravenousRoute['INTRAVENOUS'] || $administerOverDueMeds['3'] == $intravenousRoute['INJECT INTRAMUSCULAR'] || $makeCrossMandatory){?> <span><?php echo $this->Html->image('icons/mar_icon/cross3.png',
				array('class'=>$keyAsId.$varcnt."cross cross",'style'=>'display:none;','id'=>$administerOverDueMeds['2']));?>
		</span> <?php }else{?> <span><?php echo $this->Html->image('icons/mar_icon/mar5.png',
				array('class'=>$keyAsId.$varcnt."mar cross",'style'=>'display:none;','id'=>$administerOverDueMeds['2']));?>
		</span> <?php }?> <?php $dateOverDue = substr($this->DateFormat->formatDate2LocalForReport($administerOverDueMeds['1'],Configure::read('date_format'),true),0 , 16);
		//$overDueTimeClass =  str_replace(' ', '', $dateOverDue);?> <?php echo $this->Form->hidden("SignMar.$varcnt.scheduled_datetime",array('class'=>"overDueTimingVal" ,'value'=>$dateOverDue));?>
		</td>
		<td style="font-size: 13px"
			class=<?php echo preg_replace(array('/[^\s\w]/','/\s/'),'_', $dateOverDue);  ?>
			id="schTime<?php echo $administerOverDueMeds['2'];?>"><span
			class="overDueTime"><?php echo __($dateOverDue);?> </span>
		</td>
		<td style="font-size: 13px"><?php echo __($key); ?></td>
		<td width="50%" style="font-size: 13px"><?php echo __($administerOverDueMeds['0']);?>
		</td>
		</tr>
		<?php endforeach;?>
		<?php 

		foreach($administerNowMeds['0'] as $key => $administerScheduleMeds):
		if($toggle == 0) {
		       	echo "<tr class='row_gray'>";
		       	$toggle = 1;
	       }else{
		       	echo "<tr>";
		       	$toggle = 0;
	       }
	       $keyAsId = preg_replace('/[^A-Za-z0-9\-]/', '', $key);
	       $varcnt++;
	       ?>

		<td width="7%"><?php echo $this->Form->checkbox("SignMar.$varcnt.id",array('value'=>$administerScheduleMeds['2'],'id'=>$keyAsId.$varcnt,'label'=>false,
				'class'=>'prescMed','hiddenField'=>false));
		?>
		</td>
		<td width="7%"><span><?php echo $this->Html->image('icons/mar_icon/tick1.png',
				array('class'=>$keyAsId.$varcnt.'tick '.$administerScheduleMeds['2'],'style'=>'display:none;','id'=>$administerScheduleMeds['2'].'tick'));?>
		</span> <?php if($administerScheduleMeds['3'] == $intravenousRoute['INTRAVENOUS'] || $administerScheduleMeds['3'] == $intravenousRoute['INJECT INTRAMUSCULAR'] || $makeCrossMandatory){?>
			<span><?php echo $this->Html->image('icons/mar_icon/cross3.png',
				array('class'=>$keyAsId.$varcnt."cross cross",'style'=>'display:none;','id'=>$administerScheduleMeds['2']));?>
		</span> <?php }else{?> <span><?php echo $this->Html->image('icons/mar_icon/mar5.png',
			array('class'=>$keyAsId.$varcnt."mar cross",'style'=>'display:none;','id'=>$administerScheduleMeds['2']));?>
		</span> <?php }?></td>
		<?php $dateSchedule = substr($this->DateFormat->formatDate2LocalForReport(date('Y-m-d')." ".$administerScheduleMeds['1'],Configure::read('date_format'),true),0 ,16);
			$scheduleTimeClass =  $this->DateFormat->formatDate2LocalForReport(date('Y-m-d')." ".$administerScheduleMeds['1'],Configure::read('date_format'),true);?>
		<?php echo $this->Form->hidden("SignMar.$varcnt.scheduled_datetime",array('class'=>"SchTimingVal" ,'value'=>$dateSchedule));?>
		<td style="font-size: 13px"
			class=<?php echo preg_replace(array('/[^\s\w]/','/\s/'),'_', $scheduleTimeClass); ?>
			id="schTime<?php echo $administerScheduleMeds['2'];?>"><?php echo $dateSchedule;?>
		</td>

		<td style="font-size: 13px"><?php echo __($key); ?></td>
		<td width="50%" style="font-size: 13px"><?php echo __($administerScheduleMeds['0']);?>
		</td>
		</tr>
		<?php endforeach;?>
		<?php 
		foreach($prnMedication as $administerprnMeds):
		if($toggle == 0) {
		       	echo "<tr class='row_gray'>";
		       	$toggle = 1;
	       }else{
		       	echo "<tr>";
		       	$toggle = 0;
	       }
	       $keyAsId = preg_replace('/[^A-Za-z0-9\-]/', '', $administerprnMeds['NewCropPrescription']['drug_name']);
	       $varcnt++;
	       ?>

		<td width="7%"><?php echo $this->Form->checkbox("SignMar.$varcnt.id",
				array('value'=>$administerprnMeds['NewCropPrescription']['id'],'id'=>$keyAsId.$varcnt,'label'=>false,'class'=>'prescMed','hiddenField'=>false)); ?>
		</td>
		<td width="7%"><span><?php echo $this->Html->image('icons/mar_icon/tick1.png',
				array('class'=>$keyAsId.$varcnt.'tick','style'=>'display:none;','id'=>$administerprnMeds['NewCropPrescription']['id'].'tick'));?>
		</span> <?php if($administerprnMeds['NewCropPrescription']['route'] == $intravenousRoute['INTRAVENOUS'] || $administerprnMeds['NewCropPrescription']['route'] == $intravenousRoute['INJECT INTRAMUSCULAR'] || $makeCrossMandatory){?>
			<span><?php echo $this->Html->image('icons/mar_icon/cross3.png',
					array('class'=>$keyAsId.$varcnt."cross cross",'style'=>'display:none;','id'=>$administerprnMeds['NewCropPrescription']['id']));?>
		</span> <?php }else{?> <span><?php echo $this->Html->image('icons/mar_icon/mar5.png',
				array('class'=>$keyAsId.$varcnt."mar cross",'style'=>'display:none;','id'=>$administerprnMeds['NewCropPrescription']['id']));?></span>
			<?php }?></td>
		<td style="font-size: 13px"><?php echo __("PRN");?></td>
		<td style="font-size: 13px"><?php echo __($administerprnMeds['NewCropPrescription']['drug_name']); ?>
		</td>
		<td width="50%" style="font-size: 13px"><?php echo __($administerprnMeds['PatientOrder']['sentence']);?>
		</td>
		</tr>
		<?php endforeach;?>
		<?php 
		foreach($contineousInfusion as $contineous):
		if($toggle == 0) {
		       	echo "<tr class='row_gray'>";
		       	$toggle = 1;
	       }else{
		       	echo "<tr>";
		       	$toggle = 0;
	       }
	       $keyAsId = preg_replace('/[^A-Za-z0-9\-]/', '', $contineous['NewCropPrescription']['drug_name']);
	       $varcnt++;
	       ?>

		<td width="7%"><?php echo $this->Form->checkbox("SignMar.$varcnt.id",
				array('value'=>$contineous['NewCropPrescription']['id'],'id'=>$keyAsId.$varcnt,'label'=>false,'class'=>'prescMed','hiddenField'=>false)); ?>
		</td>
		<td width="7%"><span><?php echo $this->Html->image('icons/mar_icon/tick1.png',
				array('class'=>$keyAsId.$varcnt.'tick','style'=>'display:none;','id'=>$contineous['NewCropPrescription']['id'].'tick'));?>
		</span> <?php if($contineous['NewCropPrescription']['route'] == $intravenousRoute['INTRAVENOUS'] || $contineous['NewCropPrescription']['route'] == $intravenousRoute['INJECT INTRAMUSCULAR']  || $makeCrossMandatory){?>
			<span><?php echo $this->Html->image('icons/mar_icon/cross3.png',
					array('class'=>$keyAsId.$varcnt."cross cross",'style'=>'display:none;','id'=>$contineous['NewCropPrescription']['id']));?>
		</span> <?php }else{?> <span><?php echo $this->Html->image('icons/mar_icon/mar5.png',
				array('class'=>$keyAsId.$varcnt."mar cross",'style'=>'display:none;','id'=>$contineous['NewCropPrescription']['id']));?></span>
			<?php }?></td>
		<td style="font-size: 13px"><?php echo __("Continuous");?></td>
		<td style="font-size: 13px"><?php echo __($contineous['NewCropPrescription']['drug_name']); ?>
		</td>
		<td width="50%" style="font-size: 13px"><?php echo __($contineous['PatientOrder']['sentence']);?>
		</td>
		</tr>
		<?php endforeach;?>
	</table>
</form>

<div class='ready'>
	<table width="100%">
		<tr>
			<td width="30%" style="font-size: medium;"><strong><?php echo __("Ready to scan"); ?></strong></td>
			<td width="20%" align="center" style="font-size: smaller;"><strong><?php echo __("2 of 2"); ?></strong></td>
			<td width="40%" align="right">
			<?php echo $this->Form->input('Back',array('div'=>false,'label'=>false,'type'=>'button','id'=>'back','class'=>'Bluebtn')); ?>
			<?php echo $this->Form->input('Sign',array('div'=>false,'label'=>false,'disabled'=>true,'type'=>'button','id'=>'sign','class'=>'grayBtn')); ?></td>
		</tr>
	</table>
</div>
<script>
var selectedTime = 'aaa'; 
var insertedNewCropId = [];
$(".overDueTiming").click(function(){
	selectedTime= $(this).find('.overDueTimingVal').val();
	
});


function getSelectedTime(){
	return selectedTime;
}
$(document).ready(function(){
	$('#patientSearchDiv').remove();
	$('#scanId').focus();
	$(document).click(function(){
		//$('#scanId').focus();
		});
	$('#back').click(function(){
		window.location.href = '<?php echo $this->Html->url(array('controller'=>'PatientsTrackReports','action'=>'patientWristBandCheck',$patient['Patient']['id'])); ?>' ;
		});
	
	$('#scanId').change(function(){
		var medName = $('#scanId').val().split('^~~^');
		var newMedName = medName[0].replace(/\ /g, "");
		var idArray = $(document)
        .find("input:checkbox") //Find the spans
        .map(function() { return this.id; }) //Project Ids
        .get(); //ToArray
        
        $.each(idArray, function(key, value) {
        var newValue = value.replace(/\ /g, "");
            		if(newValue == newMedName){
                		$("#"+newValue).attr('checked',true);
                		$('.'+newValue+'cross').css('display','block').addClass('new');
                		$('.'+newValue+'mar').css('display','block').addClass('new');
                		$('#scanId').val(' ').focus();
                		return true;
            		}	
             });
        $('#scanId').val('');
        $('#scanId').focus();
		});
	
	$('.prescMed').click(function(){
		var didScanConfirm = confirm("Task has not been verified by a scan."+'\n'+"Do you want to continue without scanning?");
		if(didScanConfirm == false)return false;
		var didMedVerified =confirm("The medication task,"+$(this).attr('id')+",has not been verified. Continue?");
		if(didMedVerified == false)return false;
		var classVar = $(this).attr('id')+'cross';
		if ($("#"+$(this).val()).hasClass(classVar)){
			$('.'+$(this).attr('id')+'cross').css('display','block').addClass('new');
		}else{
			$('.'+$(this).attr('id')+'mar').css('display','block').addClass('new');
			$('.'+$(this).attr('id')+'tick').css('display','block');
			$('#sign').removeAttr('disabled').removeClass('grayBtn').addClass('Bluebtn');
		}
		
	});

	$('.cross').click(function(){
		if($(this).hasClass('new')){
			
			$.fancybox({ 
				'width':'80%',
				'height':'100%',
			    'autoScale': true, 
			    'scrolling':'auto',
			    'href': "<?php echo $this->Html->url(array("controller" => "PatientsTrackReports", "action" => "medicationAdministeringRecord",$patient_id, "admin" => false)); ?>"+'/'+$(this).attr('id'),
			    'transitionIn'	:	'elastic',
				'transitionOut'	:	'elastic',
				'speedIn'		:	600, 
				'speedOut'		:	200, 
				'overlayShow'	:	true,
				'type':'iframe'
				 
		    });
			}
		
	});	

	$('.alarm').click(function(){
		$.fancybox({ 
				'width':'60%',
				'height':'100%',
			    'autoScale': true, 
			    'scrolling':'auto',
			    'href': "<?php echo $this->Html->url(array("controller" => "PatientsTrackReports", "action" => "earlyLateReason",$patient_id, "admin" => false)); ?>"+'/'+$(this).attr('id'),
			    'transitionIn'	:	'elastic',
				'transitionOut'	:	'elastic',
				'speedIn'		:	600, 
				'speedOut'		:	200, 
				'overlayShow'	:	true,
				'type':'iframe'
				 
		    });
	});

	$("#sign").click(function(){ 
		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "PatientsTrackReports", "action" => "prescribedMedicationList",$patient_id, "admin" => false)); ?>";
		$.ajax({
			data: $('#SignMar').serialize(),
	  		type: 'POST',
			url: ajaxUrl+'/'+insertedNewCropId,
			dataType: 'html',
     		success: function(data){
     			$('#flashMessageRoot', parent.document).show(); 
     			var idArray = $(document)
     	        .find("input:checkbox") //Find the spans
     	        .map(function() { if($(this).attr('checked')) return $(this).val(); }) //Project Ids  vertical-align: inherit;
     	        .get(); //ToArray
     	       
     	       $.each(idArray, function(key, value) {
         	     var parentSelectedMedication = $('#schTime'+value).attr('class');
     	    	 	parent.$("#"+parentSelectedMedication+'td').css({ "background-color": "gray", "vertical-align": "inherit"} ).html('<span id="completedImg">Completed</br><?php echo $this->Html->image('icons/mar_icon/tick1.png',array('id'=>$medTime."img",'style'=>'margin-left: 21px;'));?></span>');
     	    	 	parent.$("#"+parentSelectedMedication+'img').show();
         	       });
         		parent.$.fancybox.close();
	      	}
		});
	});
});
</script>
