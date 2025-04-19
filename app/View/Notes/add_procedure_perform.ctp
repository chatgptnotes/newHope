<?php 
	if($hideSection!='1'){
		echo $this->Html->script(array('jquery.fancybox-1.3.4','pager'));
		echo $this->Html->script(array('jquery.selection.js','jquery.blockUI'));
		echo $this->Html->script('jquery.autocomplete');
		echo $this->Html->css('jquery.autocomplete.css');	
	}
?>
<style>
img {
	border: 0 none;
	cursor: pointer;
	padding: 0 0 9px;
	float: none;
}
.subTd{
	width:25%;font-size: 13px; text-align: left;padding: 10px;
}
</style>
<?php if($hideSection!='1'){?>
	<div class="inner_title">
		<h3 style="display: &amp;amp;" id="procedurePerform-link">
			<a href="#">Procedure Performed</a>
		</h3>
		<span>
		<?php if($noteId!='null'){ 	
				echo  $this->Html->link(__('Back'),array('controller'=>'notes','action'=>'soapNote',$patientId,$noteId,'appt'=>$appId,'#'=>'item'.$this->params->query['widgetId'],'?'=>array('expand'=>'Plan')),
						array('type'=>'button','id' => '','label'=> false, 'div' => false,
								'error' => false,'class'=>'blueBtn', 'style'=>'margin: 0 0 0 10px;'));
			}
			else{
		echo  $this->Html->link(__('Back'),array('controller'=>'notes','action'=>'soapNote',$patientId,'?'=>array('expand'=>'Plan')),
							array('type'=>'button','id' => '','label'=> false, 'div' => false,
							'error' => false,'class'=>'blueBtn', 'style'=>'margin: 0 0 0 10px;'));
		}?>
		</span>
	</div>

	<div>
		<table width="60%" class="formFull formFullBorder">
			<tr>
				<td width="10%" align="right"><b><?php echo __('Name :')?> </b></td>
				<td align="left"><?php  echo $patientDetails['Patient']['lookup_name'];?>
				</td>
				<td>&nbsp;&nbsp;&nbsp;</td>

				<td width="10%" align="right"><b><?php echo __('Gender :')?> </b></td>
				<td align="left"><?php echo ucfirst($patientDetails['Person']['sex']);?>
				</td>
				<td>&nbsp;&nbsp;&nbsp;</td>

				<td width="10%" align="right"><b><?php echo __('DOB :')?> </b></td>
				<td align="left"><?php echo date("F d, Y", strtotime($patientDetails['Person']['dob']));?>
				</td>
				<td>&nbsp;&nbsp;&nbsp;</td>

				<td width="10%" align="right"><b><?php echo __('Visit ID :')?> </b></td>
				<td align="left"><?php echo $patientDetails['Patient']['admission_id'];?>
				</td>

			</tr>
		</table>
	</div>
<?php }?>

<div class="section" id="procedure_performed">
	<!-- Start of Ajax for procedure -->
	<?php 
 
		echo $this->Form->create('ProcedurePerform',array('type' => 'file','id'=>'patientnotesfrm','inputDefaults' => array('label' => false,'div' => false,'error' => false,'legend'=>false,'fieldset'=>false)));

		echo $this->Form->hidden('ProcedurePerform.patient_id',array('value'=>$patientId,'id'=>'patient_id'));
		
		echo $this->Form->hidden('ProcedurePerform.id',array('value'=>$getEncounterDetails['0']['Encounter']['id']));
		
		if($hideSection!='1'){
	?>
	<!-- New Table form --Pooja -->
	<table width="100%" cellpadding="0" cellspacing="0" border="0"
		style="background-color: #E8EAED; margin: 11px 0 0;">
		<tr>
			<td style="width: 100%; float: left; border-bottom: 1px solid #ccc; padding-bottom: 5px; font-size: 13px; margin-bottom: 10px; background: #0078aa repeat-x; height: 30px; line-height: 30px;">
				<?php 
					echo $this->Form->input('uni_safety_protocol',array('type'=>'checkbox','id'=>'uni_safety_protocol','label' => false,'div' => false));
				?>
				<font color="white"> The following procedure performed during this
					visit using the universal safety protocol</font>
			</td>
		</tr>
		<tr>
			<td style="width: 100%; float: left; border-bottom: 1px solid #ccc; padding-bottom: 5px; margin-bottom: 10px; font-size: 13px;">
				<?php echo $this->Form->input('site_verified',array('type'=>'checkbox','id'=>'site_verified','label' => false,'div' => false)).$this->Html->image('icons/star.png');?>
				Correct patient, procedure and site verified with <?php echo $this->Form->input('verified_with',array('type'=>'text','id'=>'verified_with','label' => false,'div' => false))?>
				by verifying verbally with <?php echo $this->Form->input('verified_verbally',array('type'=>'text','id'=>'verified_verbally','label' => false,'div' => false))?>
				patient's name and date of birth

			</td>
		</tr>
		<tr>
			<td
				style="width: 100%; border-bottom: 1px solid #ccc; padding-bottom: 5px; margin-bottom: 10px; float: left; font-size: 13px;">
				<?php echo $this->Form->input('signed_informed',array('type'=>'checkbox','id'=>'signed_informed','label' => false,'div' => false)).$this->Html->image('icons/star.png');?>
				Signed informed consent in chart
			</td>
		</tr>
		<tr>
			<td
				style="width: 100%; border-bottom: 1px solid #ccc; padding-bottom: 5px; margin-bottom: 10px; float: left; font-size: 13px;">
				<?php echo $this->Form->input('informed_consent',array('type'=>'checkbox','id'=>'informed_consent','label' => false,'div' => false));?>
				Informed consent indicating procedure to be performed, location of
				procedure to be performed, and risk of procedures obtained and filed
				in paper.
			</td>
		</tr>
		<tr>
			<td
				style="width: 100%; border-bottom: 1px solid #ccc; padding-bottom: 5px; margin-bottom: 10px; float: left; font-size: 13px;">
				<?php echo $this->Form->input('site_market',array('type'=>'checkbox','id'=>'site_market','label' => false,'div' => false)).$this->Html->image('icons/star.png');?>
				Site Marketing Required <?php echo $this->Form->input('site_required',array('type'=>'radio','options'=>array('NO','Yes'),'label' => false,'div' => false));?>

			</td>
		</tr>
		<tr>
			<td
				style="width: 100%; border-bottom: 1px solid #ccc; padding-bottom: 5px; margin-bottom: 10px; float: left; font-size: 13px;">
				<?php echo $this->Form->input('equipment_needed',array('type'=>'checkbox','id'=>'equipment_needed','label' => false,'div' => false)).$this->Html->image('icons/star.png');?>
				Equipment and/or devices needed for the procedure present
			</td>
		</tr>
		<tr>
			<td
				style="width: 100%; border-bottom: 1px solid #ccc; padding-bottom: 5px; margin-bottom: 10px; float: left; font-size: 13px;">
				<?php echo $this->Form->input('correct_marked_site',array('type'=>'checkbox','id'=>'correct_marked_site','label' => false,'div' => false)).$this->Html->image('icons/star.png');?>
				Correct Side/Site marked by performing provider with initials and
				identified as : <?php echo $this->Form->input('correct_identified_site',array('type'=>'text','id'=>'correct_identified_site','label' => false,'div' => false)) ?>

			</td>
		</tr>
		<tr>
			<td
				style="width: 100%; border-bottom: 1px solid #ccc; padding-bottom: 5px; margin-bottom: 10px; float: left; font-size: 13px;">
				<?php echo $this->Form->input('final_verification',array('type'=>'checkbox','id'=>'final_verification','label' => false,'div' => false)).$this->Html->image('icons/star.png');?>
				Final verification of patient, procedure, and site done at <?php echo $this->Form->input('final_verify_date',array('id'=>'final_verify_date','readonly'=>'readonly','type'=>'text','id'=>'final_date','label'=>false));?>
				by me.
			</td>
		</tr>	
		<tr>
			<td
				style="width: 100%; border-bottom: 1px solid #ccc; padding-bottom: 5px;float: left; font-size: 13px;">
				<?php echo $this->Form->input('other_comment',array('id'=>'other_comment','type'=>'checkbox','label' => false,'div' => false));?>
				Comments(Other staff present during procedure)<br /> <?php echo $this->Form->textarea('staff_comment',array('id'=>'staff_comment','label' => false,'div' => false,'style'=>'margin:0 0 0 25px'));?>

			</td>
		</tr>
	</table>
<?php }?>

<table width="100%" cellpadding="0" cellspacing="0" border="0" class="formFull formFullBorder">
 <tr>
  <td style="background-color: '<?php echo $color;?>'">
	<table style="width:100%">
	 <tr>
	  <td width="27%" align="left" valign="top" style="background-color: '<?php echo $color;?>'">
		<div align="center" id='temp-busy-indicator-procedure_performed' style="display: none;">&nbsp;
			<?php echo $this->Html->image('indicator.gif', array()); ?>
		</div>
		<table width="100%" cellpadding="0" cellspacing="0" border="0" class='<?php echo $classTable ?>'>
		 	<tr>
		  		<td valign="top" style="background-color: '<?php echo $color;?>'">
					<table width="100%" cellpadding="0" cellspacing="0" border="0" class="formFull formFullBorder">
						<tr>
							<td class="tdOrders" colspan="4">
								<?php echo __("Add Services");?>
							</td>
						</tr>
						<tr>
			  				<td class="subTd">
							  	<?php echo __('Service Group');?>
							</td>
							<td class="subTd">
							  	<?php 
							  		echo $this->Form->input('ProcedurePerform.service_grp',array('class'=>' ','empty'=>__('Please Select'),'options'=>$getAllServiceGrp,'selected'=>$getProcedureID['ServiceCategory']['id'],'id'=>'service_grp','label'=>false));
								?>
							</td>
							<td class="subTd">
								<?php echo __("CPT Search:");?>
							</td>
							<td class="subTd">
								<?php echo $this->Form->input('ProcedurePerform.cpt_search',array('type'=>'text','escape'=>false,'id'=>'cpt_search','label'=>false,'div'=>false));?>
							</td>
						</tr>
						<tr>
						  	<td class="subTd">
						  		<?php echo __('Service name') ?><font color="red">*</font>
						  	</td>
						  	<td class="subTd" id="simpleWork">
								  <?php 
								  	echo $this->Form->hidden('ProcedurePerform.procedure_name_clone',array('type'=>'text','escape'=>false,'class'=>'procedure_name_clone','id'=>'procedure_name_clone','label'=>false,'div'=>false));

									echo $this->Form->input('ProcedurePerform.procedure_name1',array('type'=>'text','escape'=>false,'class'=>'validate[required,custom[mandatory-enter]]','id'=>'procedure_name','label'=>false,'div'=>false));

									echo $this->Form->hidden('ProcedurePerform.procedure_type',array('id'=>'procedure_type_perform1','type'=>'text','value'=>'2'));
									
									echo $this->Form->hidden('ProcedurePerform.service_bill_id',array('id'=>'service_bill_id','type'=>'text'));
									
									echo $this->Form->hidden('ProcedurePerform.tariff_list_id',array('type'=>'text','id'=>'tariffListId1'));
									
									echo $this->Form->hidden('ProcedurePerform.service_grp_id_holder1',array('type'=>'text','id'=>'service_grp_id_holder1','value'=>$getProcedureID['ServiceCategory']['alias']));
									
									echo $this->Form->hidden('ProcedurePerform.serviceGrp_id_holder1',array('type'=>'text','id'=>'serviceGrp_id_holder1','value'=>$getProcedureID['ServiceCategory']['id']));
									?>
						  	</td>
							<td class="subTd" style="display:none" id="radioWork">
								<?php 
									echo $this->Form->input('ProcedurePerform.procedure_name',array('type'=>'text','escape'=>false,'class'=>'validate[required,custom[mandatory-enter]]','id'=>'procedure_name_asRadio','label'=>false,'div'=>false));

									echo $this->Form->hidden('ProcedurePerform.procedure_type',array('id'=>'procedure_type_perform','type'=>'text','value'=>'2'));
									
									echo $this->Form->hidden('ProcedurePerform.tariff_list_id',array('type'=>'text','id'=>'tariffListId'));
									
									echo $this->Form->hidden('ProcedurePerform.service_grp_id_holder2',array('type'=>'text','id'=>'service_grp_id_holder2'));
									
									echo $this->Form->hidden('ProcedurePerform.serviceGrp_id_holder2',array('type'=>'text','id'=>'serviceGrp_id_holder2'));
									
									echo $this->Form->hidden('ProcedurePerform.service_amount',array('type'=>'text','id'=>'service_amount'));
								?>
							</td>
							<td class="subTd">
								<?php echo __('CPT');?>
							</td>
							<td class="subTd">
								<?php 
									echo $this->Form->hidden('ProcedurePerform.code_type',array('type'=>'text','id'=>'code_type','readonly'=>'readonly', 'class'=>'textBoxExpnd','label'=>false));
									
									echo $this->Form->hidden('ProcedurePerform.snowmed_code',array('id'=>'code_value','type'=>'text'));
									
									echo $this->Form->hidden('ProcedurePerform.id',array('id'=>'pro_id','type'=>'text'));
								?>
								<div id="showProcedurePerformType"></div>
							</td>
						</tr>
						<tr>
							<td class="subTd">
								<?php echo __('Service From Date') ?><font color="red">*</font>
							</td>
							<td class="subTd">
							<?php 
								echo $this->Form->input('ProcedurePerform.procedure_date',array('class'=>'textBoxExpnd validate[required,custom[mandatory-date]]','type'=>'text','id'=>'procedure_perform_date','label'=>false)); ?>
							</td>
							
							<td class="subTd">
								<?php echo __('Service To Date');?>
							</td>
							<td class="subTd">
							<?php 
								echo $this->Form->input('ProcedurePerform.procedure_to_date',array('class'=>'textBoxExpnd','type'=>'text','id'=>'procedure_to_date','label'=>false));
							?>
							</td>
						</tr>
						<tr>
							<td class="subTd"><?php echo __('Modifier 1') ?></td>
						
							<td class="subTd">
							<?php 
								echo $this->Form->input('ProcedurePerform.modifier1',array('class'=>' ','empty'=>__('Please Select'),'options'=>$nameBillingOtherCode,'id'=>'modifier1','label'=>false,'style'=>"width:82%"));
							?>
							</td>
							
							
							<td class="subTd"><?php echo __('Modifier 2');?></td>
							
							<td class="subTd">
							<?php 
								echo $this->Form->input('ProcedurePerform.modifier2',array('class'=>'','empty'=>__('Please Select'),'options'=>$nameBillingOtherCode,'id'=>'modifier2','label'=>false,'style'=>"width:82%"));
							?>
							</td>
						</tr>
						<tr>
							<td class="subTd"><?php echo __('Modifier 3') ?></td>
							
							<td class="subTd">
							<?php 
								echo $this->Form->input('ProcedurePerform.modifier3',array('class'=>'','empty'=>__('Please Select'),'options'=>$nameBillingOtherCode,'id'=>'modifier3','label'=>false,'style'=>"width:82%"));
							?>
							</td>
							
							
							
							<td class="subTd"><?php echo __('Modifier 4');?></td>
							
							<td class="subTd">
							<?php 
								echo $this->Form->input('ProcedurePerform.modifier4',array('class'=>' ','empty'=>__('Please Select'),'options'=>$nameBillingOtherCode,'id'=>'modifier4','label'=>false,'style'=>"width:82%"));
							?>
							</td>
						</tr>
						<tr>
							<td class="subTd">
								<?php echo __('Units') ?>
							</td>
							<td class="subTd">
								<?php 
									echo $this->Form->input('ProcedurePerform.units',array('class'=>'','type'=>'text','id'=>'units','value'=>'1','label'=>false));
								?>
							</td>
							<td class="subTd">
								<?php  echo __('Place of Service') ?>
							</td>
							<td class="subTd">
								<?php if($patientDetails['Patient']['admission_type']=='OPD'){
										$codeVal='22';
								}else{
										$codeVal='21';
								}
									echo $this->Form->input('ProcedurePerform.place_service',array('class'=>'','id'=>'place_service','options'=>Configure::read('place_service_code'),'label'=>false,'value'=>$codeVal,'style'=>'width:70%'));
								?>
							</td>
						</tr>
						<tr>
							<td class="subTd"><?php echo __('Patient Diagnosis');?></td>
							
							<td class="subTd" colspan="2">
							<?php 
								echo $this->Form->input('ProcedurePerform.patient_daignosis',array('hiddenField'=>false,'options'=>$nameNoteDiagnosis,'id'=>'patient_daignosis','multiple'=>'true','label'=>false,'autocomplete'=>'off','div'=>false,'style'=>'width:100%'));
							?>
							</td>
							<td class="subTd"> &nbsp;</td>
							
						</tr>
					</table>
				 </td>
			</tr>
		</table>
</td>
</tr>
	<!--  templates -->
	<?php if($hideSection!='1'){?>
		<tr>
		 <td>
			<div id="search_template" style="padding-top:2px;margin:0px 3px;display:<?php echo $search_template ;?>">
			<table>
				<tr id="sHide">
				<td>
					<?php 
						echo $this->Form->input('search100',array('type'=>'text', 'style'=>'','lable','id'=>'search','placeholder'=>'Search Template'));
					?>
				</td>
				<td>
					<?php 
						echo $this->Html->link('Search','javascript:void(0)',array('escape'=>false,'id'=>'searchBtn','title'=>'Search','alt'=>'Search','class'=>'blueBtn'));
					?>
				</td>
				<td>
				<table border="0" style="display: none" id="wheel">
					<tr>
						<td class="gradient_img" style="padding: 10px;">
							<table border="0">
								<tr>
									<td class="black_white" style="padding: 5px 10px 10px; font-size: 11px;">
										<div class="bloc">
										<?php 
											echo $this->Form->input('language', array('class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','options'=>$tName,'style'=>'margin:1px 0 0 10px;','multiple'=>'true','id' => 'language','autocomplete'=>'off'));
										?>
										</div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				</td>
				<td>
					<?php 
						echo $this->Html->link($this->Html->image('/img/icons/search_icon.png'),'javascript:void(0)',array('escape'=>false,'id'=>'icon_search','title'=>'Search','alt'=>'Search'));
					?>
				</td>
	</tr>
	</table>
	</div>
	</td>
	</tr>
	<tr>
		<td colspan="2"><div id="ProcedureDisplay"></div></td>
	</tr>
	<!--  templates EOM -->
		
	<tr>
		<td width="70%" align="left" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="20"></td>
				<td valign="top" colspan="4">
					<?php echo __('Procedure Note :');?>
				</td>
			</tr>
			
			<tr>
				<td width="20">&nbsp;</td>
				<td valign="top" colspan="4">
					<?php echo $this->Form->textarea('ProcedurePerform.procedure_note', array('id' =>'procedure_note'  ,'rows'=>'4','style'=>'width:97%')); ?>
				</td>
			</tr>
			</table>
	</td>
	</tr>

	<tr>
	<td>&nbsp;</td>
	</tr>
	
	<tr>
		<td colspan='4' align='right' valign='bottom'>
			<?php 
				if($noteId!='null'){ 	
					echo  $this->Html->link(__('Back'),array('controller'=>'notes','action'=>'soapNote',$patientId,$noteId,'appt'=>$appId,'#'=>'item'.$this->params->query['widgetId'],'?'=>array('expand'=>'Plan')),
					array('type'=>'button','id' => '','label'=> false, 'div' => false,'error' => false,'class'=>'blueBtn', 'style'=>'margin: 0 0 0 10px;'));
				}else{
					echo  $this->Html->link(__('Back'),array('controller'=>'notes','action'=>'soapNote',$patientId,'?'=>array('expand'=>'Plan')),array('type'=>'button','id' => '','label'=> false, 'div' => false,'error' => false,'class'=>'blueBtn', 'style'=>'margin: 0 0 0 10px;'));
			}
			echo $this->Html->link(__('Submit'),"javascript:void(0)",array('id'=>'procedure_perform_submit','class'=>'blueBtn','onclick'=>"javascript:save_procedure_perform()")); ?>
		</td>
	</tr>
	<?php }else{?>
	<tr>
		<td colspan='4' align='right' valign='bottom'>
			<?php 
				echo $this->Html->link(__('Submit'),"javascript:void(0)",array('id'=>'procedure_perform_submit','class'=>'blueBtn','onclick'=>"javascript:save_procedure_perform()"));
			?>
		</td>
	</tr>
	<?php }?>

	<tr>
	<td>
	<table border="0" class="" cellpadding="0" cellspacing="0" width="100%" style="text-align: center;">
	<?php if(isset($procedure_perform) && !empty($procedure_perform)){ ?>
	<tr class="">
		<td class="tdOrders">
			<strong>
				<?php echo  __('Service Category Name', true);?>
			</strong>
		</td>
		
		<td class="tdOrders">
			<strong>
				<?php echo  __('Service name', true);?>
			</strong>
		</td>

		<td class="tdOrders">
			<strong>
				<?php echo  __('Code', true); ?>
			</strong>
		</td>
		
		<td class="tdOrders">
			<strong>
				<?php echo  __('Service Date', true); ?>
			</strong>
		</td>

		<td class="tdOrders">
			<strong>
				<?php echo  __('Action'); ?>
			</strong>
		</td>
	</tr>
	<?php
	$toggle =0;
	if(count($procedure_perform) > 0) {
	foreach($procedure_perform as $procedure_perform){
	if(!empty($procedure_perform)) {
	$procedurePerformid="procedurePerform".$procedure_perform[ProcedurePerform][id];
	}else{
	echo "<tr class='' id='".$procedurePerformid."'><td colspan='5>&nbsp;</td></tr>" ;
	}
	if($toggle == 0) {
	echo "<tr class='' id='".$procedurePerformid."'>";
	$toggle = 1;
	}else{
	echo "<tr id='".$procedurePerformid."'>";
	$toggle = 0;
	}
	//status of the report
	?>
	<td class="row_format"><?php echo $procedure_perform['ProcedurePerform']['procedure_category']; ?>
	</td>
	<td class="row_format"><?php echo $procedure_perform['ProcedurePerform']['procedure_name']; ?>
	</td>

	<td class="row_format"><?php echo $procedure_perform['ProcedurePerform']['snowmed_code']; ?>
	</td>

	<td class="row_format"><?php echo $this->DateFormat->formatDate2Local($procedure_perform['ProcedurePerform']['procedure_date'],Configure::read('date_format_us'),false); ?>
	</td>

	<td class="row_format"><?php $pro_id = $procedure_perform['ProcedurePerform']['id']; 
	echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete')),'javascript:void(0)' , array(array(__('Are you sure?', true)),'escape' => false, 'onclick'=>"delete_procedure_perform($pro_id);return false;"));
	echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('title'=>'Edit','alt'=>'Edit')), 'javascript:void(0)', array('escape' => false, 'onclick'=>"edit_procedure_perform($pro_id);return false;"));
	?>
	</td>
	</tr>
	<?php } 
	}
	} else {
	?>
	<!-- <tr>
	<TD colspan="5" align="center" class="error"><?php echo __('No Procedure Results for selected patient', true); ?>.
	</TD>
	</tr> -->
	<?php } ?>
	</table>
	</td>
	</tr>

	</table></td>
	</tr>
	</table>
	<?php echo $this->Form->end();?>
	</div>


<!-- EOF procedure -->

<script>
$("#schedule_procedure_date").datepicker({
	showOn : "button",
	minDate: new Date(),
	buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly : true,
	changeMonth : true,
	changeYear : true,
	dateFormat:'<?php echo $this->General->GeneralDate(false);?>',
	onSelect : function() {
		$(this).focus();
		//foramtEnddate(); //is not defined hence commented
	}
	
});
		$("#procedure_perform_date").datepicker({
			showOn : "button",
			maxDate: new Date(),
			buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly : true,
			changeMonth : true,
			changeYear : true,
			dateFormat:'<?php echo $this->General->GeneralDate(false);?>',
			onSelect : function() {
				$(this).focus();
				//foramtEnddate(); //is not defined hence commented
			}
			
		});
	$("#procedure_to_date").datepicker({
				showOn : "button",
				buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly : true,
				changeMonth : true,
				changeYear : true,
				dateFormat:'<?php echo $this->General->GeneralDate(false);?>',
				onSelect : function() {
					$(this).focus();
					//foramtEnddate(); //is not defined hence commented
				}
				
			});	
	$('#final_date').datepicker({	
		showOn : "both",
		changeMonth : true,
		changeYear : true,
		dateFormat : '<?php echo $this->General->GeneralDate("HH:II:SS");?>',					
		buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly : true,
		onSelect : function() {
			$(this).focus();
		}
	});
	$(document).ready(function(){

		$("#procedure_perform_date").blur(function(){
			if($(this).val()===''){//nothing to do 
			}else{
				var date_regex = /^(0[1-9]|1[0-2])\/(0[1-9]|1\d|2\d|3[01])\/(19|20)\d{2}$/ ;
			    var procedure_perform_date =  date_regex.test($(this).val());
			    if(procedure_perform_date === false){
				    alert('Incorrect date format please enter in (mm/dd/yyyy) format');
				    $(this).focus();
				    $(this).val('');
				} 
			}
		});
		$("#procedure_to_date").blur(function(){
			if($(this).val()===''){//nothing to do 
			}else{
				var date_regex = /^(0[1-9]|1[0-2])\/(0[1-9]|1\d|2\d|3[01])\/(19|20)\d{2}$/ ;
			    var procedure_to_date =  date_regex.test($(this).val());
			    if(procedure_to_date === false){
				    alert('Incorrect date format please enter in (mm/dd/yyyy) format');
				    $(this).focus();
				    $(this).val('');
				} 
			}
		});
		
		var ServiceId;
		var gearShift;
			$('#procedure_perform_submit').click(function() { 
				var validatePerson = jQuery("#patientnotesfrm").validationEngine('validate');
				if (validatePerson) {//$(this).css('display', 'none');				
				parent.$.fancybox.close();
				return true;
				}
				else{			 
				return false;
				}
				});	
			$('#procedure_schedule_submit').click(function() { 
				var validatePerson = jQuery("#procedurePerformSchedulefrm").validationEngine('validate');
				if (validatePerson) {//$(this).css('display', 'inline');	
					return true;
				}
				else{			 
					return false;
				}
			});			
			$('#service_grp').change(function(){
				gearShift=$('#service_grp').val();
				gearShiftText=$('#service_grp option:selected').text();
				if(gearShift==''){
					$('#simpleWork').show();
					$('#radioWork').hide();
					$('#service_grp_id_holder1').val(gearShiftText);
					$('#serviceGrp_id_holder1').val(gearShift);
					

				}else{
					$('#simpleWork').hide();
					$('#radioWork').show();
					$('#service_grp_id_holder2').val(gearShiftText);
					$('#serviceGrp_id_holder2').val(gearShift);
					$("#procedure_name_asRadio" ).unautocomplete(); 
					$("#procedure_name_asRadio").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "radioComplete","admin" => false,"plugin"=>false)); ?>"+"/"+gearShift+"/"+"<?php echo $tariffStandardIdAuto?>", {
									width: 250,
									selectFirst: true,
									loadId:'procedure_name,code_value',
									showNoId:true,
									valueSelected:true,
									onItemSelect:function(event, ui) { 
										var compositStringArray = lastSelectedOrderSetItem.split("     ");
										if(compositStringArray['1']==''){
											alert('Please Update Charges for Service:'+compositStringArray['0']);
											$('#procedure_name').val('');
											return false;
										}else{
											var compositStringArrayVal = compositStringArray['1'].split("---");
											$('#service_amount').val(compositStringArrayVal['0']);
											//$('#showCodeType').show();
											$('#showProcedurePerformType').html(compositStringArrayVal['1']);
										}
									 }	
					}); 
				} 

			});
				$('#procedure_name_asRadio').change(function(){
					if($('#procedure_name_asRadio').val()==''){
						$('#showProcedurePerformType').html(' ');
					}
				});
				$('#procedure_name_clone').change(function(){
					if($('#procedure_name_clone').val()==''){
						$('#showProcedurePerformType').html(' ');
					}
				});
				$('#procedure_name').change(function(){
					if($('#procedure_name').val()==''){
						$('#showProcedurePerformType').html(' ');
					}
				});
			$("#procedure_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "radioComplete","admin" => false,"plugin"=>false)); ?>"+"/"+"<?php echo $getProcedureID['ServiceCategory']['id']?>"+"/"+"<?php echo $tariffStandardIdAuto?>", {
				width: 250,
				selectFirst: true,
				loadId:'procedure_name,code_value',
				showNoId:true,
				valueSelected:true,
				onItemSelect:function() { 
					var compositStringArray = lastSelectedOrderSetItem.split("     ");
					var chargeVal = compositStringArray['1'].split("---");
					if($.trim(chargeVal['0'])==''){
							alert('Please Update Charges for Service:'+compositStringArray['0']);
							$('#procedure_name').val('');
							return false;
						}else{
							var compositStringArrayVal = compositStringArray['1'].split("---");
							$('#service_amount').val(compositStringArray['1']);
							//$('#procedure_name').val(compositStringArray['0']);
							$('#showProcedurePerformType').html(compositStringArrayVal['1']);
						}
				 }	
			});

			$("#cpt_search").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "radioCompleteCbt","admin" => false,"plugin"=>false)); ?>"+"/"+gearShift+"/"+"<?php echo $tariffStandardIdAuto?>", {
				width: 250,
				selectFirst: true,
				loadId:'procedure_name,code_value',
				showNoId:true,
				valueSelected:true,
				onItemSelect:function() { 
					   var compositStringArray = lastSelectedOrderSetItem.split("     ");
					   var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "radioCompleteCbtControler","admin" => false)); ?>"+"/"+compositStringArray['0']+"/"+"<?php echo $tariffStandardIdAuto?>";
				           $.ajax({
				            type: 'POST',
				            url: ajaxUrl,
				            dataType: 'html',
				            beforeSend : function() {
								  $('#busy-indicator').show('fast');
								  },
				            success: function(data){
				            	 $('#busy-indicator').hide('fast');
				            	var data=jQuery.parseJSON(data);
				            	$('#service_grp').val(data.service_category_id);
				            	$('#procedure_name').val(data.value);
				            	$('#procedure_name_clone').val(data.value);
				            	$('#procedure_name_asRadio').val(data.value);
				            	$('#service_grp_id_holder1').val($('#service_grp option:selected').text());
				            	$('#serviceGrp_id_holder1').val(data.service_category_id);
				            	$('#service_amount').val(data.charges);
				            	$('#showProcedurePerformType').html($("#cpt_search").val());
				            }
				        });
										
				 }	
			});
		
			$("#schedule_procedure_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","TariffList","id","name","code_type<>=null", "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true,
				loadId:'schedule_procedure_name,schedule_code_value',
				showNoId:true,
				valueSelected:true,
				onItemSelect:function() { 
					var snomwID = $('#schedule_code_value').val();//code_type
					var URL = "<?php echo $this->Html->url(array('controller' => 'patients', 'action' => 'snowmedId','admin' => false,'plugin'=>false)); ?>";
					 $.ajax({
						  type: "GET",
						  url: URL+"/"+snomwID,
						  beforeSend : function() {
							  $('#busy-indicator').show('fast');
							  },
						  success : function (data){ 
							  $('#busy-indicator').hide('fast');
							  var patientData = jQuery.parseJSON(data);
							 // console.log(patientData);return false;
							  $('#tariff_list_id').val(patientData.TariffList.id);
							   $('#schedule_code_type').val(patientData.TariffList.code_type);
							   var code_value= $('#schedule_code_type').val();		
							   $('#showCodeType').html(code_value);//alert(code_value);
							  if(patientData.TariffList.code_type=='CPT'){
								  $('#schedule_code_value').val(patientData.TariffList.cbt);			  
								
							  }else if(patientData.TariffList.code_type=='hcpcs'){
								  $('#schedule_code_value').val(patientData.TariffList.hcpcs);
							  }					  
						 }
						});
				 }				
			});
	
	});
		
		//----------BOF of function related to Procedure Perform------------
		/*function dbProcedureperform1(){
			
			   $('#code_C_type').val($('#code_type option:selected').text());	
				//$("#code_C_type").val(problem);
			   $('#p_name').val($('#procedure_name').text());
			   var problemCodeType = $('#procedure_name').val();  alert(problemCodeType);	  
			   $("#code_type").val(problemCodeType); 
			   var problemCode = $('#procedure_name').val(); alert(problemCode);
			   var spCode= problemCode.split('- ('); alert(spCode);
			   //var resCode = spCode[1].replace(')',''); alert(resCode);
			   $("#code_value").val(resCode);
			   $('#p_daignosis_name').val($('#patient_daignosis option:selected').text());
			   
			    
			    return false; 
			}*/
		
		function save_procedure_perform(){
			var validateProcedure = jQuery("#patientnotesfrm").validationEngine('validate');
			if(validateProcedure){
			patientid=$("#patient_id").val();
		 	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "save_procedurePerform","admin" => false)); ?>";
		 	var formData = $('#patientnotesfrm').serialize();	  
	       	$.ajax({
	        	type: 'POST',
	       		url: ajaxUrl+"/"+patientid,
	        	data: formData,
	        	dataType: 'html',
	       		beforeSend : function() {					
					 var code_value= $('#code_value').val();	
	        	 	 	$('#busy-indicator').show('fast');					
						$('#procedure_perform_submit').hide();
				},
	        	success: function(data){ 
	        		$('#busy-indicator').hide('fast');	        	
	        	 	if(data !='Please Insert Data'){
	        	 	document.getElementById("patientnotesfrm").reset();
	        	 	
	        	 	var checkloads='<?php echo $this->params->query['LoadSet']?>';
	        	 	if(checkloads=='loadSet'){
	        	 		$( "#assessmentTab" ).trigger( "click" );
	        	 	}else{
	        	 		window.location.reload();
	        	 	}
	        	  
	        	  
	        	$("#procedure_name").val('');
			        $("#code_value").val('');
			        $("#code_type").val('');
			        $("#id").val('');
			        $("#patient_daignosis").val('');
	        	 }else{
	                 //-----don't comment it. its error message
	                 //alert(data);
	             }
			       
		          },	         
				error: function(message){
	            	alert("Internal Error Occured. Unable To Save Data.");
	        	}        
	        });
		}
	  
	  return false;
		}

		function edit_procedure_perform(id){
			  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "edit_procedurePerform","admin" => false)); ?>";
			   var formData = $('#patientnotesfrm').serialize();
		           $.ajax({
		            type: 'POST',
		           url: ajaxUrl+"/"+id,
		            data: formData,
		            dataType: 'html',
		            beforeSend : function() {
						  $('#busy-indicator').show('fast');
						  },
		            success: function(data){
			         
		          	  $('#busy-indicator').hide('fast');
					var data = data.split("|");	
					 $("#procedure_name").val($.trim(data[0]));
			        $("#code_value").val(data[1]);
			        $("#procedure_note").val(data[2]);
			        $("#pro_id").val(data[3]);
			        $("#procedure_perform_date").val(data[5]);
			        $("#procedure_to_date").val(data[6]);
			        $("#modifier1").val(data[7]);
			        $("#modifier2").val(data[8]);
			        $("#modifier3").val(data[9]);
			        $("#modifier4").val(data[10]);  
			        $("#code_type").val(data[11]);     
			        $("#units").val(data[13]);   
			        $("#place_service").val(data[14]);
			        //new form - pooja
			        if(data[15]=='1')
			       	 $("#uni_safety_protocol").attr('checked',true);
			        if(data[16]=='1')
			        	$("#site_verified").attr('checked',true);
			        $("#verified_with").val(data[17]);
			        $("#verified_verbally").val(data[18]);
			        if(data[19]=='1')
			        	$("#signed_informed").attr('checked',true);
			        if(data[20]=='1')
			        	$("#informed_consent").attr('checked',true);
			        if(data[21]=='1')
			        	$("#site_market").attr('checked',true);
			        if(data[22]=='0')
			        $("#ProcedurePerformSiteRequired0").attr('checked',true);
			        if(data[22]=='1')
				        $("#ProcedurePerformSiteRequired1").attr('checked',true);
			        if(data[23]=='1')
			        	$("#equipment_needed").attr('checked',true);
			        if(data[24]=='1')
			        	$("#correct_marked_site").attr('checked',true);
			        $("#correct_identified_site").val(data[25]);
			        if(data[26]=='1')
			        	$("#final_verification").attr('checked',true);
			        $("#final_date").val(data[27]);
			        if(data[28]=='1')
			        $("#other_comment").attr('checked',true);
			        $("#staff_comment").val(data[29]);
			        $("#procedure_type_perform").val(data[31]);
			        $("#service_bill_id").val(data[32]);
					//END -- Pooja
				
			        patientDiagnosis = $.parseJSON(data[12]);
						 $("#patient_daignosis option:selected").removeAttr("selected");
						 $(patientDiagnosis).each(function(val,text){
			        	$("select#patient_daignosis option[value='" + text + "']").attr("selected", "selected");
			        	 
				    });
					//	 $("#showProcedurePerformType").html(data[11]); 
						 $('#showProcedurePerformType').html(data[33]);						
						$(window).scrollTop(490);      
			             
		            },
					error: function(message){
						alert("Error in Retrieving data");
		            }        });
		      
		      return false; 
		}

		
		function delete_procedure_perform(id){
		if (confirm("Are you sure?")) {
		       var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "delete_procedurePerform","admin" => false)); ?>";
			   var formData = $('#patientnotesfrm').serialize();
		           $.ajax({
		            type: 'POST',
		           url: ajaxUrl+"/"+id,
		            data: formData,
		            dataType: 'html',
		            beforeSend : function() {
						  $('#busy-indicator').show('fast');
						  },
		            success: function(data){
		          	  $('#busy-indicator').hide('fast');
		            	alert('Record Deleted Successfully');
		            	$('#procedurePerform'+id).hide();
		            },
					error: function(message){
						alert("Cannot Process Your Request");
		            }        });	     
			 }
		    return false;
		}
		
		function save_procedure_schedule(){
			var validateProcedure = jQuery("#procedurePerformSchedulefrm").validationEngine('validate');
			if(validateProcedure){
			patientid=$("#schedule_patient_id").val();
		 	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "save_procedurePerform","admin" => false)); ?>";
		 	var formData = $('#procedurePerformSchedulefrm').serialize();	  
	       	$.ajax({
	        	type: 'POST',
	       		url: ajaxUrl+"/"+patientid,
	        	data: formData,
	        	dataType: 'html',
	       		beforeSend : function() {
	       		 var code_value_schedule= $('#schedule_code_value').val();	
        	 	 if($.trim(code_value_schedule)==''){
					 alert("Please enter the valid Procedure Name");
					 return false;
				 }else{					
					$('#busy-indicator').show('fast');					
					$('#procedure_schedule_submit').hide();
				 }
				},
	        	success: function(data){ 
	        		$('#busy-indicator').hide('fast');	        
	        	 	if(data !='Please Insert Data'){
	        	 	document.getElementById("procedurePerformSchedulefrm").reset();        	
	        	 	
	        	 window.location.reload();
	        	$("#schedule_procedure_name").val('');
			        $("#schedule_code_value").val('');
			        $("#schedule_code_type").val('');
			        $("#schedule_id").val('');
	        	 }else{
	                 //-----don't comment it. its error message
	                 alert(data);
	             }
			       
		          },	         
				error: function(message){
	            alert("Internal Error Occured. Unable To Save Data.");
	        }        
	        });
		}
	  
	  return false;
		}

		function edit_procedure_schedule(id){
			  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "edit_procedurePerform","admin" => false)); ?>";
			   var formData = $('#procedurePerformSchedulefrm').serialize();
		           $.ajax({
		            type: 'POST',
		           url: ajaxUrl+"/"+id,
		            data: formData,
		            dataType: 'html',
		            beforeSend : function() {
						  $('#busy-indicator').show('fast');
						  },
		            success: function(data){			     
		          	  $('#busy-indicator').hide('fast');
					var data = data.split("|");	
					 $("#schedule_procedure_name").val($.trim(data[0]));
			        $("#schedule_code_value").val(data[1]);
			        $("#procedure_note").val(data[2]);
			        $("#schedule_pro_id").val(data[3]);
			        $("#schedule_procedure_date").val(data[5]);
			        $("#procedure_to_date").val(data[6]);
			        $("#modifier1").val(data[7]);
			        $("#modifier2").val(data[8]);
			        $("#modifier3").val(data[9]);
			        $("#modifier4").val(data[10]);  
			        $("#schedule_code_type").val(data[11]);     
			        $("#units").val(data[13]);     
			        $("#place_service").val(data[14]);
			        //new form - pooja
			        if(data[15]=='1')
			       	 $("#uni_safety_protocol").attr('checked',true);
			        if(data[16]=='1')
			        	$("#site_verified").attr('checked',true);
			        $("#verified_with").val(data[17]);
			        $("#verified_verbally").val(data[18]);
			        if(data[19]=='1')
			        	$("#signed_informed").attr('checked',true);
			        if(data[20]=='1')
			        	$("#informed_consent").attr('checked',true);
			        if(data[21]=='1')
			        	$("#site_market").attr('checked',true);
			        if(data[22]=='0')
			        $("#ProcedurePerformSiteRequired0").attr('checked',true);
			        if(data[22]=='1')
				        $("#ProcedurePerformSiteRequired1").attr('checked',true);
			        if(data[23]=='1')
			        	$("#equipment_needed").attr('checked',true);
			        if(data[24]=='1')
			        	$("#correct_marked_site").attr('checked',true);
			        $("#correct_identified_site").val(data[25]);
			        if(data[26]=='1')
			        	$("#final_verification").attr('checked',true);
			        $("#final_date").val(data[27]);
			        if(data[28]=='1')
			        $("#other_comment").attr('checked',true);
			        $("#staff_comment").val(data[29]);			       
			        $("#schedule_physician_name").val(data[30]);
			        $("#procedure_type").val(data[31]);
			        $("#showCodeType").html(data[11]);
					//END -- Pooja
			        patientDiagnosis = $.parseJSON(data[12]);
						 $("#patient_daignosis option:selected").removeAttr("selected");
						 $(patientDiagnosis).each(function(val,text){
			        	$("select#patient_daignosis option[value='" + text + "']").attr("selected", "selected");
			        	 
				    });

			       // $("#patient_daignosis option[value='Unspecified choroidal hemorrhage : (I10)']").attr("selected", "selected");
			       // $("#patient_daignosis option[value='Unspecified choroidal hemorrhage : (H31.309)']").attr("selected", "selected");
			        

			        
			       // $("#patient_daignosis").val(data[12]);
			             
		            },
					error: function(message){
						alert("Error in Retrieving data");
		            }        });
		      
		      return false; 
		}

		
		function delete_procedure_schedule(id){
		if (confirm("Are you sure?")) {
		       var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "delete_procedurePerform","admin" => false)); ?>";
			   var formData = $('#procedurePerformSchedulefrm').serialize();
		           $.ajax({
		            type: 'POST',
		           url: ajaxUrl+"/"+id,
		            data: formData,
		            dataType: 'html',
		            beforeSend : function() {
						  $('#busy-indicator').show('fast');
						  },
		            success: function(data){
		          	  $('#busy-indicator').hide('fast');
		            	alert('Record Deleted Successfully');
		            	$('#procedureSchedule'+id).hide();
		            },
					error: function(message){
						alert("Cannot Process Your Request");
		            }        });	     
			 }
		    return false;
		}

		
		$("#language").dblclick(function(){searchTemplate();});
		$("#search").keypress(function(e) {
				 if(e.which == 13) {
						searchTemplate();
					}
			});
		$("#searchBtn").click(function(e) {	 
						searchTemplate();
			});
		$("#search").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","NoteTemplate","template_name",'null','null','null',"admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true,
			onItemSelect : function (){				
			
			var getserach=$("#search").val();
			$('#language').val(getserach);
			$('#language').focus();		
				}
		});
	
		$("#icon_search").click( function(){
			$('#wheel').show();
		});
		$("#wheel").click( function(){
			var valWheel=$('#wheel option:selected').text();			
			$('#search').val(valWheel);
			$('#search').focus();
		});
		
		function searchTemplate(){
			var serachText=$('#search').val();
			var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'notes', "action" => "getProPlan","admin" => false)); ?>";
			$.ajax({
			 			  type: "POST",
			 			  url: ajaxUrl+"/"+serachText,
			 			  beforeSend:function(){
			 			  	// this is where we append a loading image
			 			  	$('#busy-indicator').show('fast');
			 			  },
			 			  success: function(data){
						 $('#ProcedureDisplay').html(data);
						  $('#busy-indicator').hide('slow');

						  }
					});
		}
		  $("#procedure_note").autocomplete("<?php echo $this->Html->url(array("controller" => "SmartPhrases", "action" => "getSmartPhrase","admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				//selectFirst: true,
				isSmartPhrase:true,
				delay:500,
				//autoFill:true,
				select: function(e){ }
			});
		
		  

		     $( "#procedure_name" ).keyup(function() {
		    	 var procedureNameClone = $("#procedure_name_clone").val();
			     if($("#procedure_name").val() != procedureNameClone){
						$("#cpt_search").val('');
				 }
		    });
	</script>
