<?php echo $this->Form->create('',array('type' => 'file','default'=>false,'id'=>'SaveOrderMedication','inputDefaults' => array(
		'label' => false,
		'div' => false,
		'error' => false,
		'legend'=>false,
		'fieldset'=>false
)
));
?>
<table width="100%" cellpadding="0" cellspacing="0" border="1"
	class="formFull " style="margin-top: 20px">
	<?php  if(!empty($getDataMedication)){
		$dosevalue=$getDataMedication['NewCropPrescription']['dose'];
		$strengthvalue=$getDataMedication['NewCropPrescription']['strength'];
		$routevalue=$getDataMedication['NewCropPrescription']['route'];
		$frequencyvalue=$getDataMedication['NewCropPrescription']['frequency'];
		$durationvalue=$getDataMedication['NewCropPrescription']['duration'];
		$refillsvalue=$getDataMedication['NewCropPrescription']['refills'];
		if($getDataMedication['NewCropPrescription']['prn']){
			$prnvalue='checked';
		}
		else{
			$prnvalue='';
		}
		if($getDataMedication['NewCropPrescription']['daw']){
			$dawvalue='checked';
		}
		else{
			$dawvalue='';
		}
		$firstdose_datetimevalue=$this->DateFormat->formatDate2Local($getDataMedication['NewCropPrescription']['firstdose'],Configure::read('date_format'),true);
		if($getDataMedication['NewCropPrescription']['stopdose']!='0000-00-00 00:00:00'){
			$stopdose_datetimevalue=$this->DateFormat->formatDate2Local($getDataMedication['NewCropPrescription']['stopdose'],Configure::read('date_format'),true);
		}
		else{
		$stopdose_datetimevalue="";
		}
		$special_instructionvalue=$getDataMedication['NewCropPrescription']['special_instruction'];
	}

	else{

				$dosevalue=$dose_type;
				$strengthvalue=$strength;
				$routevalue=$route;
				$frequencyvalue=$frequency;
				$durationvalue=$duration;
				$refillsvalue=$refills;
				$prnvalue=$prn;
				$dawvalue=$daw;
				$firstdose_datetimevalue=$firstdose_datetime;
				$stopdose_datetimevalue=$stopdose_datetime;
				$special_instructionvalue=$special_instruction;


}?>
	<tr>
		<td>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"
				class="formFull formFullBorder" id="orderset_mainid"
				style="padding: 10px">
				<tr>
					<td width="100%" valign="top">
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td><strong><?php echo $patient_order['PatientOrder']['name']?>
								</strong></td>
							</tr>
							<tr>
								<td width="100%"><div id='showInteraction' ></div></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<!-- <tr>
									<td>
										<?php 
			    		                   echo __('Drug Name ',true);echo $this->Form->input('NewCropPrescription.drug_name', array('type'=>'text','id' => 'drug_name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'style'=>'width:350px;'));?>
										</td>						
										</tr>
									-->
							<?php echo $this->Form->hidden('NewCropPrescription.patient_uniqueid',array('id'=>'patient_id','value'=>$patient_order['PatientOrder']['patient_id']));?>
							<?php echo $this->Form->hidden('NewCropPrescription.description',array('value'=>$patient_order['PatientOrder']['name']));?>
							<?php echo $this->Form->hidden('NewCropPrescription.patient_order_id',array('id'=>'patient_order_id','value'=>$patient_order_id));?>
							<?php echo $this->Form->hidden('NewCropPrescription.patient_order_id',array('id'=>'patient_order_id','value'=>$patient_order_id));?>
							<?php echo $this->Form->hidden('NewCropPrescription.checkoverride',array('id'=>'checkoverride','value'=>$checkOverRidden));?>
							
							<tr>
								<td>
									<table width="100%">
										<tr>
											<td><div id='labCheck' style='display: none;  color:red;'>
													<font color='red'>Please check the validations.</font>
												</div>
											</td>
										</tr>

										<tr>
											<td><?php echo __('Dose',true); ?><font color="red">*</font>
											</td>
											<td><?php
                                         echo $this->Form->input('NewCropPrescription.dose', array('empty'=>'Please select','options'=> Configure :: read('dose_type'), 'id' => 'dose_type','label'=>false,'selected'=>$dosevalue,'class'=>'validate[required,custom[mandatory-select]]','style'=>'width:350px;' ));?>
											</td>
											<td><?php echo __('Form',true); ?><font color="red">*</font>
											</td>
											<td><?php echo $this->Form->input('NewCropPrescription.strength', array('empty'=>'Please Select','options'=> Configure :: read('strength'), 'id' => 'strength','selected'=>$strengthvalue,'label'=>false,'class'=>'validate[required,custom[mandatory-select]]','style'=>'width:350px;' ));?>
											</td>
										</tr>
										<tr>
											<td><?php echo __('Route of administration',true); ?><font
												color="red">*</font>
											</td>
											<td><?php echo $this->Form->input('NewCropPrescription.route', array('empty'=>'Please select','options'=> Configure :: read('route_administration'), 'id' => 'route_administration','selected'=>$routevalue,'label'=>false,'class'=>'validate[required,custom[mandatory-select]] ','style'=>'width:350px;' ));?>
											</td>
											<td><?php echo __('Frequency',true); ?><font color="red">*</font>
											</td>
											<td><?php echo $this->Form->input('NewCropPrescription.frequency', array('empty'=>'Please select','options'=> Configure :: read('frequency'), 'id' => 'frequency','width'=> '100%','selected'=>$frequencyvalue,'label'=>false,'class'=>'validate[required,custom[mandatory-select]]','style'=>'width:350px;' ));?>
											</td>
										</tr>

										<tr>
											<td><?php echo __('Duration',true); ?>
											</td>
											<td><?php echo $this->Form->input('NewCropPrescription.duration', array('empty'=>'Please select','options'=> Configure :: read('daysupply'), 'id' => 'duration','label'=>false,'selected'=>$durationvalue,'class'=>'validate[required,custom[onlyNumber]]','style'=>'width:350px;'));?>
											</td>
											<td><?php echo __('Refills',true); ?>
											</td>
											<td><?php echo $this->Form->input('NewCropPrescription.refills', array('options'=> Configure :: read('refills'), 'id' => 'refills','width'=> '100%','selected'=>$refillsvalue,'label'=>false,'class'=>'textBoxExpnd','style'=>'width:350px;' ));?>
											</td>
										</tr>

										<tr>
											<td><?php echo __('PRN',true); ?>
											</td>
											<td><?php echo $this->Form->checkbox('NewCropPrescription.prn', array('class'=>'servicesClick','id' => 'prn','label'=>false,'checked'=>$prnvalue));?>
											</td>
											<td><?php echo __('DAW / DNS',true); ?>
											</td>
											<td><?php echo $this->Form->checkbox('NewCropPrescription.daw', array('class'=>'servicesClick','id' => 'daw','label'=>false,'checked'=>$dawvalue));?>
											</td>
										</tr>

										<tr>
											<td><?php echo __('First Dose Date/Time',true); ?>
											</td>

											<td><?php echo $this->Form->input('NewCropPrescription.firstdose_time',array('type'=>'text','class' => 'validate[required] textBoxExpnd','id' =>'firstdose_datetime1','autocomplete'=>"off",'legend'=>false,'label'=>false,'value'=>$firstdose_datetimevalue,'style'=>'width:315px;'));?>

											</td>
											<td><?php echo __('Stop Date/Time',true); ?>
											</td>

											<td><?php echo $this->Form->input('NewCropPrescription.stopdose_time',array('type'=>'text','class' => 'validate[required] textBoxExpnd','id' =>'stopdose_datetime1','autocomplete'=>"off",'legend'=>false,'label'=>false,'value'=>$stopdose_datetimevalue,'style'=>'width:315px;'));?>

											</td>
										</tr>

										<tr>
											<td valign="top"><?php echo __('Special Instruction',true); ?>
											</td>
											<td valign="top"><?php echo $this->Form->textarea('NewCropPrescription.special_instruction', array('id' => 'special_instruction','rows'=>'5','label'=>false,'value'=>$special_instructionvalue,'style'=>'width:330px;'));?>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td></td><?php echo $this->Form->hidden('checkOverride',array('id'=>'checkOverride','value'=>'0'));?>
					<td><?php  echo $this->Form->submit(__('Sign'),array('id'=>'submit','class'=>'blueBtn')); ?>
				
				</tr>
			</table>
		</td>

	</tr>
</table>
<script>
$(document).ready(function(){

	$("#stopdose_datetime1")
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

	 $("#drug_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Rxnatomarchive","STR", "admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true
		   });
//Save Data to NewCrop.
$('#submit').click(function(){
	
	var dose_type=$("#dose_type").val();
	var strength=$("#strength").val();
	var route_administration=$("#route_administration").val();
	var frequency=$("#frequency").val();
	var stopdate=$("#stopdose_datetime1").val();
	var startdate=$("#firstdose_datetime1").val();
	if(stopdate < startdate){	
		$('#labCheck').html('Start date should be less than End date');
		$('#labCheck').show();
		return false;
	}
	if(dose_type==''||dose_type===undefined||strength==''||strength===undefined||route_administration==''||route_administration===undefined||frequency==''||frequency===undefined){

		if(dose_type==''){
			$('#labCheck').html("Dose can not be null");
			$('#labCheck').show();
			return false;
		}	
		if(strength==''){
			$('#labCheck').html("Form can not be null");
			$('#labCheck').show();
			return false;
		}
		if(route_administration==''){
			$('#labCheck').html("Route of administration can not be null");
			$('#labCheck').show();
			return false;
		}
		if(frequency==''){
			$('#labCheck').html("Frequency can not be null");
			$('#labCheck').show();
			return false;
		}

	}
	var chkOverride=$('#checkOverride').val();
	var patientId='<?php echo $patient_order['PatientOrder']['patient_id']?>';
	if(patientId==''){
		patientId='<?php echo $patient_id_new?>';
	}
	else{
		patientId=patientId;
	}
		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "SaveOrderMedication","admin" => false)); ?>"+"/"+chkOverride;
        $.ajax({	
       	 beforeSend : function() {
       		$('#busy-indicator').show('fast');
       		},     
         type: 'POST',
        url: ajaxUrl,
    	data:$('#SaveOrderMedication').serialize(),
         dataType: 'html',
         success: function(data){
       	  $('#busy-indicator').hide('fast');
       	  if(chkOverride!=1 && data!=1){	
	       		$("#showInteraction").html(data);
	       		$('#checkOverride').val();
       	  }
       	  else{
       		location.href="<?php echo $this->Html->url(array("controller" => "patients", "action" => "orders")); ?>"+"/"+patientId;
       	  }  
         },
			error: function(message){
				alert("Error in Retrieving data");
         }        });

	});
});



</script>
