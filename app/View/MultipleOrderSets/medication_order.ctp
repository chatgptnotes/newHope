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
	class="formFull" style="margin-top: 20px">
	<?php
	
	if(!empty($getDataMedication)){
		$dosevalue=$getDataMedication['NewCropPrescription']['dose'];
		$strengthvalue = $getDataMedication['NewCropPrescription']['strength'];
		$DosageFormvalue=$getDataMedication['NewCropPrescription']['DosageForm'];
		$routevalue=$getDataMedication['NewCropPrescription']['route'];
		$frequencyvalue=$getDataMedication['NewCropPrescription']['frequency'];
		$durationvalue=$getDataMedication['NewCropPrescription']['duration'];
		$qtyvalue=$getDataMedication['NewCropPrescription']['quantity'];
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
		$intakevalue = $getDataMedication['NewCropPrescription']['review_sub_category_id'];
		
			
	}

	else{
	

		$dosevalue=$dose_type;
		$strengthvalue=$strength;
		$routevalue=$route;
		$frequencyvalue=$frequency;
		$durationvalue=$duration;
		$prnvalue=$prn;
		$dawvalue=$daw;
		$firstdose_datetimevalue=$firstdose_datetime;
		$stopdose_datetimevalue=$stopdose_datetime;
		$special_instructionvalue=$special_instruction;
		$intakevalue = trim($intake);
		$DosageFormvalue = $DosageForm;
		$qtyvalue=$qtyval;
}



?>
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
								<td width="100%"><div id='showInteraction'></div></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<?php
							echo $this->Form->hidden('NewCropPrescription.patient_uniqueid',array('id'=>'patient_id','value'=>$patient_order['PatientOrder']['patient_id']));?>
							<?php echo $this->Form->hidden('NewCropPrescription.description',array('value'=>$patient_order['PatientOrder']['name']));?>
							<?php echo $this->Form->hidden('NewCropPrescription.patient_order_id',array('id'=>'patient_order_id','value'=>$patient_order_id));?>
							<?php echo $this->Form->hidden('NewCropPrescription.patient_order_id',array('id'=>'patient_order_id','value'=>$patient_order_id));?>
							<?php echo $this->Form->hidden('NewCropPrescription.checkoverride',array('id'=>'checkoverride','value'=>$checkOverRidden));?>
                           <?php echo $this->Form->hidden('NewCropPrescription.noteid',array('id'=>'checkoverride','value'=>$noteid));?>
                          
                          
							<tr>
								<td>
									<table width="100%">
										<tr>
											<td><?php echo __('Dose',true); ?><font color="red">*</font>
											</td>
											<td><?php
                                        		 echo $this->Form->input('NewCropPrescription.dose', array('type'=>'text', 'id' => 'dose_type','label'=>false,'value'=>$dosevalue,'class'=>'validate[required,custom[mandatory-select]]','style'=>'width:350px;' ));?>
											</td>
											<td><?php echo __('Dosage Form',true); ?><font color="red">*</font></font>
											</td>
											<td><?php  //echo $this->Form->input('NewCropPrescription.strength', array('empty'=>'Please Select','options'=>Configure::read('strength'), 'id' => 'strength','selected'=>$strengthvalue,'label'=>false,'class'=>'validate[required,custom[mandatory-select]]','style'=>'width:155px;' ));?>
											<span></span>
											<span><?php  echo $this->Form->input('NewCropPrescription.DosageForm', array('empty'=>'Please Select','options'=>Configure::read('roop'), 'id' => 'strength','selected'=>$DosageFormvalue,'label'=>false,'class'=>'validate[required,custom[mandatory-select]]','style'=>'width:104px;' ));?></span>
											</td>
										</tr>
										<tr>
											<td><?php echo __('Route of administration',true); ?><font
												color="red">*</font>
											</td>
											<td><?php echo $this->Form->input('NewCropPrescription.route', array('empty'=>'Please select','options'=>Configure::read('route_administration'), 'id' => 'route_administration','selected'=>$routevalue,'label'=>false,'class'=>'validate[required,custom[mandatory-select]] ','style'=>'width:350px;' ));?>
											</td>
											<td><?php echo __('Frequency',true); ?><font color="red">*</font>
											</td>
											<?php $frequency = Configure :: read('frequency');unset($frequency['Q4-6h'],$frequency['as directed'],$frequency['T;N'],$frequency['Per Protocol'],$frequency["Add'l Sig"]);?>
											<td><?php echo $this->Form->input('NewCropPrescription.frequency', array('empty'=>'Please select','options'=> $frequency, 'id' => 'frequency','width'=> '100%','selected'=>$frequencyvalue,'label'=>false,'class'=>'validate[required,custom[mandatory-select]]','style'=>'width:350px;' ));?>
											</td>
										</tr>
										<!--<tr>
											<td><?php echo __('PRN',true); ?>
											</td>
											<td><?php echo $this->Form->checkbox('NewCropPrescription.prn', array('class'=>'servicesClick','id' => 'prn','label'=>false,'checked'=>$prnvalue));?>
											</td>
											<td><?php echo __('DAW / DNS',true); ?>
											</td>
											<td><?php echo $this->Form->checkbox('NewCropPrescription.daw', array('class'=>'servicesClick','id' => 'daw','label'=>false,'checked'=>$dawvalue));?>
											</td>
										</tr>-->
										<tr>
											<td><?php echo __('First Dose Date/Time',true); ?><font color="red">*</font>
											</td>

											<td><?php echo $this->Form->input('NewCropPrescription.firstdose_time',array('type'=>'text','class' => 'validate[required,custom[mandatory-enter-only]]  textBoxExpnd strt_date','id' =>'firstdose_datetime1','autocomplete'=>"off",'legend'=>false,'label'=>false,'value'=>$firstdose_datetimevalue,'style'=>'width:315px;','readonly'=>'readonly'));?>

											</td>
											<td><?php echo __('Stop Date/Time',true); ?>
											</td>

											<td><?php echo $this->Form->input('NewCropPrescription.stopdose_time',array('type'=>'text','class' => 'validate[required] textBoxExpnd','id' =>'stopdose_datetime1','autocomplete'=>"off",'legend'=>false,'label'=>false,'value'=>$stopdose_datetimevalue,'style'=>'width:315px;','readonly'=>'readonly'));?>

											</td>
										</tr>

										<tr>
											<td valign="top"><?php echo __('Special Instruction',true); ?>
											</td>
											<td valign="top"><?php echo $this->Form->textarea('NewCropPrescription.special_instruction', array('id' => 'special_instruction','rows'=>'5','label'=>false,'value'=>$special_instructionvalue,'style'=>'width:330px;'));?>
											</td>
											<td valign="top"><?php echo __('Intake',true); ?>
											</td>

											<td valign="top"><?php echo $this->Form->input('NewCropPrescription.review_sub_category_id',array('class' => 'validate[required] textBoxExpnd','id' =>'intake',
													'legend'=>false,'label'=>false,'value'=>$intakevalue,'style'=>'width:150px;','empty'=>'Please Select',
													'options'=>$intakeForm));?>
													<span>&nbsp;&nbsp;<?php echo __('Quantity',true); ?></span>
											<span><?php  echo $this->Form->input('NewCropPrescription.quantity', array('type'=>'text', 'id' => 'quantity','label'=>false,'value'=>$qtyvalue,'class'=>'validate[required]','style'=>'width:50px;' ));?></span>

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
					<?php echo $this->Form->hidden('checkOverride',array('id'=>'checkOverride','value'=>'0'));?>
					<td><?php  if($this->Session->read('roleid')!=Configure::read('nurseId'))
						echo $this->Form->submit(__('Sign'),array('id'=>'submit','class'=>'blueBtn'));
					 ?>
					</td>

				</tr>
			</table>
		</td>

	</tr>
</table>
<script>


$( "#submit" ).click(function(){
//	var chkreturn=$("#stopdose_datetime1").rules('add', { greaterThan: "#firstdose_datetime1" });
		  var fromdate = new Date($( '#firstdose_datetime1' ).val());
	      var todate = new Date($( '#stopdose_datetime1' ).val());
			var stopdate='stopdose_datetime1';
		 if(fromdate.getTime() > todate.getTime()) {
			  inlineMsg(stopdate,'End date should be greater than First Dose date');
			  return false;
			
 }
});
 					
$(document).ready(function(){

	jQuery("#SaveOrderMedication").validationEngine({
		validateNonVisibleFields: true,
		updatePromptsPosition:true,
		});
	$('#submit').click(function() {
		var validatePerson = jQuery("#SaveOrderMedication").validationEngine('validate');
		if(validatePerson == false){ return false; 
		}else{
		var dose_type=$("#dose_type").val();
		var strength=$("#strength").val();
		var route_administration=$("#route_administration").val();
		var frequency=$("#frequency").val();
		var stopdate=$("#stopdose_datetime1").val();
		var startdate=$("#firstdose_datetime1").val();
		/*if((stopdate < startdate) && (stopdate!='')){	
			$('#labCheck').html('Start date should be less than End date');
			$('#labCheck').show();
			return false;
		}*/
		/*if(dose_type==''||dose_type===undefined||strength==''||strength===undefined||route_administration==''||route_administration===undefined||frequency==''||frequency===undefined){

			if(dose_type==''){
				$('#doseCheck').html("Dose can not be blank");
				$('#doseCheck').show();
				
			}
			else{
				$('#doseCheck').hide();
			}	
			if(strength==''){
				$('#strengthCheck').html("Form can not be blank");
				$('#strengthCheck').show();
				
			}
			else{
				$('#strengthCheck').hide();
			}
			if(route_administration==''){
				$('#labCheck1').html("Route of administration can not be blank");
				$('#labCheck1').show();
				
			}
			else{
				$('#labCheck1').hide();
			}
			if(frequency==''){
				$('#frequencyCheck').html("Frequency can not be blank");
				$('#frequencyCheck').show();
				
			}
			else{
				$('#frequencyCheck').hide();
			}
			return false;
		}*/
		var chkOverride=$('#checkOverride').val();
		var patientId='<?php echo $patient_order['PatientOrder']['patient_id']?>';
		if(patientId==''){
			patientId='<?php echo $patient_id_new?>';
		}
		else{
			patientId=patientId;
		}
			var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "MultipleOrderSets", "action" => "SaveOrderMedication","admin" => false)); ?>"+"/"+chkOverride;
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
	       	  if((chkOverride!=1) && ($.trim(data)!="update" && $.trim(data)!="save")){	
		       		$("#showInteraction").html(data);
		       		$('#checkOverride').val();
	       	  }
	       	  else{
		       	var patientencounterid='<?php echo $patientencounterid?>';
		      
		       	var noteid='<?php echo $noteid?>';
	       		location.href="<?php echo $this->Html->url(array("controller" => "MultipleOrderSets", "action" => "orders")); ?>"+"/"+patientId+"/null/"+patientencounterid+"?Preview=preview&noteId="+noteid;
	       		
	       	  }  
	         },
				error: function(message){
					alert("Error in Retrieving data");
	         }        });

		}
	});

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

	});
});
</script>
