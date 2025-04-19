<?php if($status == "success"){?>
		<script> 
			jQuery(document).ready(function() { 
			//parent.location.reload(true);
			parent.$.fancybox.close(); 
		});
		</script>
<?php   } ?>
		<?php
		echo $this->Form->create('OtherTreatment',array('id'=>'diagnosisfrm','url'=>array('controller'=>'Diagnoses','action'=>'otherTreatment',$patientId),
		'inputDefaults' => array('label' => false, 'div' => false,'error'=>false )));
		
		?>
		<table class="tdLabel" style="text-align: left; float:left;" width="100%">
			<?php  /* debug($interactionData);exit; */ ?>
			<tr>
				<td width="100%" colspan="4">      
					<table width="100%" border="0" cellspacing="0" cellpadding="0"
						class="tabularForm" align="center" style="float:left;">
                         <tr><td colspan="10">&nbsp;</td></tr>
						<tr>
							<td class="tdLabel" id="boxSpace" width="12%"><?php echo __('Chemotherapy');?>
							</td>
							<td width="12%"><?php echo $this->Form->input('OtherTreatment.patient_id',array('type'=>'hidden','id'=>'chemotherapy_patient_id','value'=>$patientId));
												  echo $this->Form->input('OtherTreatment.appointment_id',array('type'=>'hidden','id'=>'appointment_id','value'=>$appointment_id));?>
								<?php echo $this->Form->radio('OtherTreatment.chemotherapy', array('0'=>'No','1'=>'Yes'),array('value'=>$getOtherTreatment['0']['OtherTreatment']['chemotherapy'],'legend'=>false,'label'=>false,'class' => 'chemotherapy','id'=>'chemotherapy','checked'=>$getOtherTreatment['0']['OtherTreatment']['chemotherapy']));
								?></td>
							<?php 	if(!empty($getOtherTreatment['0']['OtherTreatment']['chemotherapy'])){
								$displayChemotherapyValue='block';
							}else{
											$displayChemotherapyValue='none';
										}?>

							<td class="tdLabel" id="boxSpace" width="12%">
								<div class="showChemotherapy1Lbl" style="display:<?php echo $displayChemotherapyValue ?>;">
									<span> <?php echo __('Drug');?>
									</span>
								</div>
							</td>
							<td width="12%">
								<div id="showChemotherapy1" style="display:<?php echo $displayChemotherapyValue ?>;">
									<span> <?php echo $this->Form->input('OtherTreatment.chemotherapy_drug_name',array('type'=>'text','legend'=>false,'label'=>false,'class' => 'textBoxExpnd','id' => 'chemotherapy_drug_name','value'=>$getOtherTreatment['0']['OtherTreatment']['chemotherapy_drug_name']));?>
									</span>
								</div>
							</td>
							<td width="13%" class="tdLabel" id="boxSpace">
								<div class="showChemotherapy2Lbl" style="display:<?php echo $displayChemotherapyValue ?>;">
									<span> <?php echo __('First Round Date');?>
									</span>
								</div>
							</td>
							<td width="12%">
								<div id="showChemotherapy2" style="display:<?php echo $displayChemotherapyValue ?>;">
									<span> <?php $getOtherTreatment['0']['OtherTreatment']['first_round_date']=$this->DateFormat->formatDate2Local($getOtherTreatment['0']['OtherTreatment']['first_round_date'],Configure::read('date_format'));
									echo $this->Form->input('OtherTreatment.first_round_date',array('type'=>'text','legend'=>false,'label'=>false,'class' => 'textBoxExpnd  first_round_date ','id' => 'first_round_date','readonly'=>'readonly','value'=>$getOtherTreatment['0']['OtherTreatment']['first_round_date']));
									?>
									</span>
								</div>
							</td>
							<td width="13%" class="tdLabel" id="boxSpace">
								<div class="showChemotherapy3Lbl" style="display:<?php echo $displayChemotherapyValue ?>;">
									<span> <?php echo __('Last Round Date');?>
									</span>
								</div>
							</td>
							<td width="12%">
								<div id="showChemotherapy3" style="display:<?php echo $displayChemotherapyValue ?>;">
									<span> <?php $getOtherTreatment['0']['OtherTreatment']['last_round_date']=$this->DateFormat->formatDate2Local($getOtherTreatment['0']['OtherTreatment']['last_round_date'],Configure::read('date_format'));
							echo $this->Form->input('OtherTreatment.last_round_date',array('type'=>'text','legend'=>false,'label'=>false,'class' => 'textBoxExpnd  end_date ','id' => 'last_round_date','readonly'=>'readonly','value'=>$getOtherTreatment['0']['OtherTreatment']['last_round_date']));	?>
									</span>
								</div>
							</td>
							<td colspan="8"></td>
						</tr>

						<tr>
							<td class="tdLabel " id="boxSpace"><?php echo __('Radiation Therapy');?>
							</td>
							<td><?php	echo $this->Form->radio('OtherTreatment.radiation_therapy', array('0'=>'No','1'=>'Yes'),array('value'=>$getOtherTreatment['0']['OtherTreatment']['radiation_therapy'],'legend'=>false,'label'=>false,'class' => 'radiation_therapy','id'=>'radiation_therapy','checked'=>$getOtherTreatment['0']['OtherTreatment']['radiation_therapy']));
							?>
							</td>
							<?php	if(!empty($getOtherTreatment['0']['OtherTreatment']['radiation_therapy'])){
								$displayRadiationTherapyValue='block';
							}else{
											$displayRadiationTherapyValue='none';
										}?>

							<td class="tdLabel " id="boxSpace">
								<div class="showRadiation1Lbl" style="display:<?php echo $displayChemotherapyValue ?>;">
									<span> <?php echo __('Previous Treatment');?>
									</span>
								</div>
							</td>
							<td>
								<div id="showRadiation1" style="display:<?php echo $displayRadiationTherapyValue ?>;">
									<span> <?php echo $this->Form->input('OtherTreatment.radiation_previous_treatment',array('type'=>'text','legend'=>false,'label'=>false,'class' => 'textBoxExpnd','id' => 'radiation_previous_treatment','value'=>$getOtherTreatment['0']['OtherTreatment']['radiation_previous_treatment']));?>
									</span>
								</div>
							</td>
							<td class="tdLabel " id="boxSpace" width="13%">
								<div class="showRadiation2Lbl" style="display:<?php echo $displayChemotherapyValue ?>;">
									<span> <strong><?php echo __('Treatment center');?> </strong><br />
										<?php echo __('Date Start');?>
									</span>
								</div>
							</td>
							<td>
								<div id="showRadiation2" style="display:<?php echo $displayRadiationTherapyValue ?>;">
									<span> <?php $getOtherTreatment['0']['OtherTreatment']['radiation_start_date']=$this->DateFormat->formatDate2Local($getOtherTreatment['0']['OtherTreatment']['radiation_start_date'],Configure::read('date_format'));
									echo $this->Form->input('OtherTreatment.radiation_start_date',array('type'=>'text','legend'=>false,'label'=>false,'class' => 'textBoxExpnd  radiation_start_date ','id' => 'radiation_start_date','readonly'=>'readonly','value'=>$getOtherTreatment['0']['OtherTreatment']['radiation_start_date']));
									?>
									</span>
								</div>
							</td>
							<td class="tdLabel " id="boxSpace" width="13%">
								<div class="showRadiation3Lbl" style="display:<?php echo $displayChemotherapyValue ?>;">
									<span> <?php echo __('Date Finish');?>
									</span>
								</div>
							</td>
							<td>
								<div id="showRadiation3" style="display:<?php echo $displayRadiationTherapyValue ?>;">
									<span> <?php $getOtherTreatment['0']['OtherTreatment']['radiation_finish_date']=$this->DateFormat->formatDate2Local($getOtherTreatment['0']['OtherTreatment']['radiation_finish_date'],Configure::read('date_format'));
						echo $this->Form->input('OtherTreatment.radiation_finish_date',array('type'=>'text','legend'=>false,'label'=>false,'class' => 'textBoxExpnd  radiation_finish_date ','id' => 'radiation_finish_date','readonly'=>'readonly','value'=>$getOtherTreatment['0']['OtherTreatment']['radiation_finish_date']));?>
									</span>
								</div>
							</td>
							<td colspan="8"></td>
						</tr>
						<tr>
							<td class="tdLabel" id="boxSpace" colspan="4"><?php echo __('Will patient receive chemotherapy concurrently with the radiation');?>
                            <?php echo $this->Form->radio('OtherTreatment.receive_chemotherapy_concurrently', array('0'=>'No','1'=>'Yes'),array('value'=>$getOtherTreatment['0']['OtherTreatment']['receive_chemotherapy_concurrently'],'legend'=>false,'label'=>false,'class' => 'receive_chemotherapy_concurrentlyCls','id'=>'receive_chemotherapy_concurrently','checked'=>$getOtherTreatment['0']['OtherTreatment']['receive_chemotherapy_concurrently']));
							if(!empty($getOtherTreatment['0']['OtherTreatment']['receive_chemotherapy_concurrently'])){
											$displayOtherTreatmentValue='block';
										}else{
											$displayOtherTreatmentValue='none';
										}?>
							</td>
							<!--<td><?php echo $this->Form->radio('OtherTreatment.receive_chemotherapy_concurrently', array('0'=>'No','1'=>'Yes'),array('value'=>$getOtherTreatment['0']['OtherTreatment']['receive_chemotherapy_concurrently'],'legend'=>false,'label'=>false,'class' => 'receive_chemotherapy_concurrentlyCls','id'=>'receive_chemotherapy_concurrently','checked'=>$getOtherTreatment['0']['OtherTreatment']['receive_chemotherapy_concurrently']));
							if(!empty($getOtherTreatment['0']['OtherTreatment']['receive_chemotherapy_concurrently'])){
											$displayOtherTreatmentValue='block';
										}else{
											$displayOtherTreatmentValue='none';
										}?>
							</td>-->

							<td class="tdLabel " id="boxSpace">
								<div class="showReceiveChemotherapyLbl" style="display:<?php echo $displayOtherTreatmentValue ?>;">
									<span><?php echo __('Start Date');?> </span>
								</div>
							</td>
							<td>
								<div id="showReceiveChemotherapy" style="display:<?php echo $displayOtherTreatmentValue ?>;">
									<span> <?php $getOtherTreatment['0']['OtherTreatment']['receive_chemotherapy_date']=$this->DateFormat->formatDate2Local($getOtherTreatment['0']['OtherTreatment']['receive_chemotherapy_date'],Configure::read('date_format'));
									echo $this->Form->input('OtherTreatment.receive_chemotherapy_date',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'receive_chemotherapy_date','readonly'=>'readonly','value'=>$getOtherTreatment['0']['OtherTreatment']['receive_chemotherapy_date'],'class' => 'textBoxExpnd  receive_chemotherapy_dateCls'));

									?>
									</span>
								</div>
							</td>
							<td colspan="9"></td>

						</tr>
						<tr>
							<td class="tdLabel" id="boxSpace"><?php echo __('Karnofsky Score');?>
							</td>
							<td colspan="6"><?php echo $this->Form->input('OtherTreatment.karnofsky_score', array('options'=>Configure::read('karnofsky_score'),'style'=>'width:390px;','class' => 'textBoxExpnd','id' => 'karnofsky_score','value'=>$getOtherTreatment['0']['OtherTreatment']['karnofsky_score'])); 
							?>
							</td>
                            <!--<td align="right"><?php echo $this->Form->submit('Submit',array('class'=>'blueBtn','id'=>'submit','div'=>false,'label'=>false,));?>-->
							<td colspan="14"></td>

						</tr>
						<tr>
							<td class="tdLabel" id="boxSpace"><?php echo __('Information Notes');?>
							</td>
							<td colspan="4"><?php echo $this->Form->input('OtherTreatment.nurse_note', array('type'=>'textarea','class' => 'textBoxExpnd','id' => 'nurse_note','value'=>$getOtherTreatment['0']['OtherTreatment']['nurse_note'])); 
							?>
							</td>
							<td colspan="14"></td>
						</tr>
                        <tr><td colspan="9">&nbsp;</td></tr>
					</table>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="right"><?php echo $this->Form->submit('Submit',array('class'=>'blueBtn','id'=>'submit','div'=>false,'label'=>false));?>
				</td>
			</tr>
		</table>
        <!--<table cellpadding="0" cellspacing="0" width="100%">
        <tr>
				<td></td>
				<td align="right"><?php echo $this->Form->submit('Submit',array('class'=>'blueBtn','id'=>'submit','div'=>false,'label'=>false));?>
				</td>
			</tr>
        </table>    -->   
		
<script>
	$('.chemotherapy:radio').click(function(){	
		
		if($(this).val() =='1'){					
		$('.showChemotherapy1Lbl').show();	
		$('.showChemotherapy2Lbl').show();	
		$('.showChemotherapy3Lbl').show();				
		$('#showChemotherapy1').show();	
		$('#showChemotherapy2').show();	
		$('#showChemotherapy3').show();				
		$('#chemotherapy_drug_name').show();	
		$('#first_round_date').show();	
		$('#last_round_date').show();		
	}else{			
		$('.showChemotherapy1Lbl').hide();	
		$('.showChemotherapy2Lbl').hide();	
		$('.showChemotherapy3Lbl').hide();	
		$('#showChemotherapy1').hide();	
		$('#showChemotherapy2').hide();	
		$('#showChemotherapy3').hide();	
		$('#chemotherapy_drug_name').hide();	
		$('#first_round_date').hide();	
		$('#last_round_date').hide();
		$('#chemotherapy_drug_name').val("");
		$('#first_round_date').val("");
		$('#last_round_date').val("");	
	}
	});
	$('.radiation_therapy:radio').click(function(){	
		
		if($(this).val() =='1'){					
		$('.showRadiation1Lbl').show();	
		$('.showRadiation2Lbl').show();	
		$('.showRadiation3Lbl').show();				
		$('#showRadiation1').show();	
		$('#showRadiation2').show();	
		$('#showRadiation3').show();				
		$('#radiation_previous_treatment').show();	
		$('#radiation_start_date').show();	
		$('#radiation_finish_date').show();		
	}else{			
		$('.showRadiation1Lbl').hide();	
		$('.showRadiation2Lbl').hide();	
		$('.showRadiation3Lbl').hide();	
		$('#showRadiation1').hide();	
		$('#showRadiation2').hide();	
		$('#showRadiation3').hide();	
		$('#radiation_previous_treatment').hide();	
		$('#radiation_finish_date').hide();	
		$('#exercise_duration').hide();
		$('#radiation_previous_treatment').val("");
		$('#radiation_start_date').val("");
		$('#radiation_finish_date').val("");	
	}
	});
	$('.receive_chemotherapy_concurrentlyCls:radio').click(function(){	
		
		if($(this).val() =='1'){					
			$('.showReceiveChemotherapyLbl').show();	
			$('#receive_chemotherapy_date').show();	
			$('#showReceiveChemotherapy').show();		
			
		}else{			
			$('.showReceiveChemotherapyLbl').hide();	
			$('#showReceiveChemotherapy').hide();
			$('#receive_chemotherapy_date').hide();	
			$('#receive_chemotherapy_date').val("");	
			}
		});
	$("#first_round_date,#last_round_date,#radiation_start_date,#radiation_finish_date").datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
	//	yearRange: '-100:' + new Date().getFullYear(),
		dateFormat:'<?php echo $this->General->GeneralDate("");?>',
	//	maxDate: new Date(),
		onSelect : function() {
			$(this).focus();
		} 
	}); 
	$(".receive_chemotherapy_dateCls").datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '-100:' + new Date().getFullYear(),
		dateFormat:'<?php echo $this->General->GeneralDate("");?>',
	//	maxDate: new Date(),
		onSelect : function() {
			$(this).focus();
		} 
	}); 
	$(document).ready(function(){
		$('#diagnosisfrm').submit(function(){
			var date_admin = new Date($('#radiation_start_date').val());
			var expiry_date_ca = new Date($('#radiation_finish_date').val());
		var error = '';
			if (date_admin.getTime() > expiry_date_ca.getTime())
			{
			  	 error = "Finish date can not be smaller than Start date";
			}
			if(error !=''){
				alert(error);
				return false ;
			}
		});
		$('#diagnosisfrm').submit(function(){
			var first_round_date = new Date($('#first_round_date').val());
			var last_round_date = new Date($('#last_round_date').val());
		var error = '';
			if (first_round_date.getTime() > last_round_date.getTime())
			{
			  	 error = "Last Round Date can not be smaller than First Round Date";
			}
			if(error !=''){
				alert(error);
				return false ;
			}
		});
		
	});
</script>