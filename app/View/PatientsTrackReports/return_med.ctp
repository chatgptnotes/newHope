<p class="ht5"></p>
<table width="97%" align="center" border="0" cellspacing="0"
	cellpadding="0" class="tabularForm">
	<tr>
		<td colspan="2"><?php echo $this->Html->image('icons/mar_icon/mar5.png');?>
			<strong><span style="text-align: left;"><?php				
			echo __($medicationData['NewCropPrescription']['description']);?> </span>
		</strong></td>
	</tr>
</table>
<p class="ht5"></p>
<?php echo $this->Form->create('',array('type' => 'POST','id'=>'administerMedFrm','inputDefaults' => array('label' => false,'div' => false,'error' => false)));
echo $this->Form->hidden('',array('name'=>'AdministerBy','value'=>$this->Session->read('userid')));
echo $this->Form->hidden('new_crop_prescription_id',array('name'=>'new_crop_prescription_id','value'=>$medicationData['NewCropPrescription']['id']));
echo $this->Form->hidden('patient_id',array('name'=>'patient_id','value'=>$medicationData['NewCropPrescription']['patient_uniqueid']));
?>
<table width="97%" align="center" border="0" cellspacing="0"
	cellpadding="0" class="formFull">
	
	<tr>
		<td class="tdLabel" id="boxSpace">Returned Quantity<font color="red">*</font></td>
		<td><?php echo $this->Form->input('returnQuantity', array("type"=>"text",'name'=>'returnQuantity','value'=>$medicationData['NewCropPrescription']['returnQuantity'],'class'=>'validate[required,custom[mandatory-enter]custom[onlyNumber]]',
				'style'=>"width: 130px;",'autoComplete'=>'off'));
		?>
		</td>
	</tr>
	<tr>
		<td class="tdLabel" id="boxSpace">Reason<font color="red">*</font></td>
		<td><?php echo $this->Form->textarea('returnReason', array('name'=>'returnReason','id' => 'reason','rows'=>'5','label'=>false,'value'=>$medicationData['NewCropPrescription']['returnReason'],'style'=>'width:330px;','class'=>'validate[required,custom[mandatory-enter]]'));?>
		</td>
	</tr>
	
	<tr>
		<td colspan="2"><?php echo $this->Form->submit(__('Submit'),array('id'=>'approvesubmit','class'=>'blueBtn','onClick'=>'return false;',
				'style'=>'float: right; margin-right: 66px;','div'=>false));?>
		</td>

	</tr>
</table>

<?php echo $this->Form->end();?>


<script>
$(document).ready(function(){
	$('#approvesubmit').click(function(){   
		var validateMandatory = jQuery("#administerMedFrm").validationEngine('validate');
		if(validateMandatory){  		
    	var ajaxUrl= "<?php echo $this->Html->url(array("controller" => "PatientsTrackReports", "action" => "saveReturnMed","admin" => false)); ?>";
	   		$.ajax({
	   			url: ajaxUrl,
	   			method : 'POST',
	   		 	data: $('#administerMedFrm').serialize(),
	   		 	beforeSend : function() {
	   		 		$('#busy-indicator').show('fast');
	   		 	},
	   		 	success: function(data){
	   		 	 	$('#busy-indicator').hide('fast');
	   		 		parent.viewExcel('time-view');
	   		 		parent.jQuery.fancybox.close();
	   		 	},
	   		 });	
		}							
	}); 
	$("#administeredTime").datepicker({	
		showOn : "button",
		style : "margin-left:50px",
		buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly : true,
		changeMonth : true,
		changeYear : true,
		yearRange: '-100:' + new Date().getFullYear(),
		
		minDate : new Date(),
		dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
	}); 

		    
});


</script>
