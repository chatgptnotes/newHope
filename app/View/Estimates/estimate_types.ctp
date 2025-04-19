<?php
echo $this->Html->script('jquery.autocomplete');
echo $this->Html->css('jquery.autocomplete.css'); 
?>
<script>
function addDatpicker(number_of_field){
	$("#ConsultantDate"+number_of_field).datepicker({
					showOn: "button",
					buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
					buttonImageOnly: true,
					changeMonth: true,
					changeYear: true,
					yearRange: '1950',				 
					dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
					minDate : new Date(explode[0],explode[1] - 1,explode[2]),
					
				}); 

	}
	 function checkApplyInADay(tarrifListID,standardId,tmp,apply_in_a_day){
		var count = 0;
		 if($.trim(apply_in_a_day)!="" && parseInt(apply_in_a_day)>0){
		  	if(parseInt(apply_in_a_day)>3)
		  		apply_in_a_day =3;
		  	var arr = new Array("morning"+tmp,"evening"+tmp,"night"+tmp);
			if($("#morning"+tmp).attr("checked")==true)
				count = count+1;
			if($("#evening"+tmp).attr("checked")==true)
				count = count+1;
			if($("#night"+tmp).attr("checked")==true)
				count = count+1;		
	  		if(parseInt(apply_in_a_day) == count){
	  			if($("#morning"+tmp).attr("checked")!=true)
	  				$("#morning"+tmp).attr("disabled","disabled")
	  			if($("#evening"+tmp).attr("checked")!=true)
	  				$("#evening"+tmp).attr("disabled","disabled")
	  			if($("#night"+tmp).attr("checked")!=true)
	  				$("#night"+tmp).attr("disabled","disabled")
	 		}else if(count < parseInt(apply_in_a_day)){
				if($("#morning"+tmp).attr("checked")!=true)
	  				$("#morning"+tmp).removeAttr("disabled", "disabled");
	  			if($("#evening"+tmp).attr("checked")!=true)
	  				$("#evening"+tmp).removeAttr("disabled", "disabled");
	  			if($("#night"+tmp).attr("checked")!=true)
	  				$("#night"+tmp).removeAttr("disabled", "disabled");
			}			
	   }
	 }

	 function defaultNoOfTimes(id,tariffListId){
			currentCount = Number($('#noOfTimes' + tariffListId).val()) ;		
			if($('#' + id).is(":checked")){			
				$('#noOfTimes' + tariffListId).val(currentCount+1);
			}else{
				if(currentCount > 0) 
					$('#noOfTimes' + tariffListId).val(currentCount-1);
				else
					$('#noOfTimes' + tariffListId).val('');
			}
		 }	

</script>
<div class="inner_title">
<h3>&nbsp; <?php echo __('Estimate Invoice', true); ?></h3>
<span></span></div>

<div class="patient_info"><?php echo $this->element('estimate_patient_information');?>
</div>

<table style="margin-bottom: 30px;" width="100%" align="right"
	cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td><?php 
		echo $this->Html->link(__('Generate Estimate Invoice'),array('action' => 'generateEstimateInvoice',$patientData['EstimatePatient']['id']), array('escape' => false,'class'=>'blueBtn','id'=>'advancePayment','style'=>'margin-left:0px;'));
		echo $this->Html->link(__('Edit Patient Info'),array('action' => 'edit',$patientData['EstimatePatient']['id']), array('escape' => false,'class'=>'blueBtn','id'=>'patientInfo','style'=>'margin-left:0px;'));
		?></td>
	</tr>
</table>

<table width="100%" align="right" cellpadding="0" cellspacing="0"
	border="0">
	<tr>
		<td width="22"><input type="radio" id="servicesSectionBtn"
			name="billtype" value="Services" checked="checked" autocomplete=off/></td>
		<td width="65" class="tdLabel2">Services</td>
		<td width="22"><input type="radio" id="consultantSectionBtn"
			name="billtype" value="Consultant" autocomplete=off/></td>
		<td width="110" class="tdLabel2">Consultant Visit</td>
		<td width="22"><input type="radio" name="billtype"
			id="pathologySectionBtn" value="Pathology" autocomplete=off/></td>
		<td width="75" class="tdLabel2">Laboratory</td>
		<td width="22"><input type="radio" name="billtype"
			id="radiologySectionBtn" value="Radiology" autocomplete=off/></td>
		<td width="75" class="tdLabel2">Radiology</td>
		<!-- 
		<td width="25"><input type="radio" name="billtype"
			id="pharmacy-sectionBtn" value="Pharmacy" /></td>
		<td width="80" class="tdLabel2">Pharmacy</td>
		 -->
		<td width="25"><input type="radio" name="billtype"
			id="otherServicesSectionBtn" value="Pharmacy" autocomplete=off/></td>
		<td width="120" class="tdLabel2">Other Services</td>

		<td>&nbsp;</td>
		<td class="tdLabel">
		</td>
		
		<td width="140">&nbsp;</td>
		<td width="25" align="right"></td>
	</tr>
</table>

<div id="servicesSection" style="margin-top: 30px;">
<div class="clr ht5"></div>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td align="left" width="180"><?php 

		echo $this->Html->link(__('View Patient Services'),array('action' => 'viewAllPatientServices',$patientData['EstimatePatient']['id']), array('escape' => false,'class'=>'blueBtn','style'=>'margin-left:0px;'));

		?></td>
		<?php       echo $this->Form->create('',array('type' => 'file','id'=>'servicefrm','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false
		)));


		?>
		<td align="left" width="100">Service:</td>
		<td align="left" width="150"><?php echo $this->Form->input('', array('name'=>'service_name','type'=>'text','id' => 'search_service_name','autocomplete'=>'off')); ?></td>
		<td align="left"><?php echo $this->Form->submit('Search', array('div'=>false,'label'=>false,'error'=>false,'class'=>'blueBtn'));?></td>
		<?php echo $this->Form->end();?>
		<?php       echo $this->Form->create('Estimates',array('controller'=>'estimates','action'=>'servicesBilling','type' => 'file','id'=>'servicefrm','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false
		)));
		echo $this->Form->hidden('location_id', array('value'=>$this->Session->read('locationid')));
		echo $this->Form->hidden('patient_id', array('id'=>'patient_id','value'=>$patientData['EstimatePatient']['id']));
		if(isset($corporateId) && $corporateId != '')
		echo $this->Form->hidden('corporate_id', array('value'=>$corporateId));
		else
		echo $this->Form->hidden('corporate_id', array('value'=>''));

		?><td>Date:</td>
		<td><?php echo $this->Form->input('date', array('value'=>$serviceDate,'type'=>'text','id' => 'billDate','class' => 'validate[required,custom[mandatory-date]]','style'=>'width:100px;','readonly'=>'readonly')); ?></td>

	</tr>
</table>

		<?php if(!empty($services)){?>
<table width="100%">
	<tr>
		<td align="right"><?php 
		echo $this->Html->link(__('Cancel'),array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
		echo $this->Form->submit('Save', array('div'=>false,'label'=>false,'error'=>false,'class'=>'blueBtn', 'id' => 'saveServiceBill'));?></td>
	</tr>
</table>
<table width="100%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm" id="serviceGrid">
	<tr>
		<th width="150">PARTICULAR</th>
		<!--  <th>&nbsp;</th>-->
		<th width="85" style="text-align: right;">UNIT PRICE</th>
		<th width="70" style="text-align: center;">MORNING</th>
		<th width="70" style="text-align: center;">EVENING</th>
		<th width="70" style="text-align: center;">NIGHT</th>
		<th width="70" style="text-align: center;">No Of Times</th>
	</tr>

	<?php
	$morning=$evening=$night=$noOfTimes='';
	foreach($services as $service){
		if($service['EstimateServiceBill']['morning'] ==1){
			$morning='checked';
		}
		if($service['EstimateServiceBill']['evening'] ==1){#echo 'here';exit;
			$evening='checked';
		}
		if($service['EstimateServiceBill']['night'] ==1){
			$night='checked';
		}//$str = strtr($str, get_html_translation_table(HTML_ENTITIES));
		if(!empty($service['EstimateServiceBill']['no_of_times'])){
			$noOfTimes=$service['EstimateServiceBill']['no_of_times'];
		}
		?>
	<tr>
		<td width="150"><?php //echo $service['TariffList']['name'];
		echo mb_convert_encoding($service['TariffList']['name'], 'HTML-ENTITIES', 'UTF-8');
			
		?></td>
		<!--  <td>&nbsp;</td> -->
		<td width="85" style="text-align: right;"><?php 
		$hospitalType = $this->Session->read('hospitaltype');
		if($hospitalType == 'NABH'){
			echo $this->Number->format($service['TariffAmount']['nabh_charges'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
		}else{
			echo $this->Number->format($service['TariffAmount']['non_nabh_charges'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
		}

		?></td>

		<td width="70" style="text-align: center;"><?php $temp = $service['TariffList']['id'];?>

		<?php //echo $this->Form->checkbox('', array('name'=>"data[Nursing][$temp][morning]",'id' => 'morning'.$temp,'value'=>1,'checked'=>$morning,"onchange"=>"checkApplyInADay('".$service['TariffList']['id']."','".$patient['EstimatePatient']['tariff_standard_id']."','".$temp."','".$service['TariffList']['apply_in_a_day']."');")); ?>
		<?php if($morning=='checked'){?> <input type="checkbox"
			name="data[Nursing][<?php echo $temp;?>][morning]"
			id="morning<?php echo $temp;?>" value="1"
			checked="<?php echo $morning;?>"
			onchange="defaultNoOfTimes('morning<?php echo $service['TariffList']['id'];?>','<?php echo $service['TariffList']['id'];?>');checkApplyInADay('<?php echo $service['TariffList']['id'];?>','<?php echo $patientData['EstimatePatient']['tariff_standard_id'];?>','<?php echo $temp;?>','<?php echo $service['TariffList']['apply_in_a_day'];?>')">
			<?php }else{?> <input type="checkbox"
			name="data[Nursing][<?php echo $temp;?>][morning]"
			id="morning<?php echo $temp;?>" value="1"
			onchange="defaultNoOfTimes('morning<?php echo $service['TariffList']['id'];?>','<?php echo $service['TariffList']['id'];?>');checkApplyInADay('<?php echo $service['TariffList']['id'];?>','<?php echo $patientData['EstimatePatient']['tariff_standard_id'];?>','<?php echo $temp;?>','<?php echo $service['TariffList']['apply_in_a_day'];?>')">
			<?php }?></td>
		<td width="70" style="text-align: center;"><?php //echo $this->Form->checkbox('', array('name'=>"data[Nursing][$temp][evening]",'id' => 'evening'.$temp,'value'=>1,'checked'=>$evening,"onchange"=>"checkApplyInADay('".$service['TariffList']['id']."','".$patientData['EstimatePatient']['tariff_standard_id']."','".$temp."','".$service['TariffList']['apply_in_a_day']."');")); ?>
		<?php if($evening=='checked'){?> <input type="checkbox"
			name="data[Nursing][<?php echo $temp;?>][evening]"
			id="evening<?php echo $temp;?>" value="1"
			checked="<?php echo $evening;?>"
			onchange="defaultNoOfTimes('evening<?php echo $service['TariffList']['id'];?>','<?php echo $service['TariffList']['id'];?>');checkApplyInADay('<?php echo $service['TariffList']['id'];?>','<?php echo $patientData['EstimatePatient']['tariff_standard_id'];?>','<?php echo $temp;?>','<?php echo $service['TariffList']['apply_in_a_day'];?>')">
			<?php }else{?> <input type="checkbox"
			name="data[Nursing][<?php echo $temp;?>][evening]"
			id="evening<?php echo $temp;?>" value="1"
			onchange="defaultNoOfTimes('evening<?php echo $service['TariffList']['id'];?>','<?php echo $service['TariffList']['id'];?>');checkApplyInADay('<?php echo $service['TariffList']['id'];?>','<?php echo $patientData['EstimatePatient']['tariff_standard_id'];?>','<?php echo $temp;?>','<?php echo $service['TariffList']['apply_in_a_day'];?>')">
			<?php }?></td>
		<td width="70" style="text-align: center;"><?php //echo $this->Form->checkbox('', array('name'=>"data[Nursing][$temp][night]",'id' => 'night'.$temp,'value'=>1,'checked'=>$night,"onchange"=>"checkApplyInADay('".$service['TariffList']['id']."','".$patientData['EstimatePatient']['tariff_standard_id']."','".$temp."','".$service['TariffList']['apply_in_a_day']."');")); ?>
		<?php if($night=='checked'){?> <input type="checkbox"
			name="data[Nursing][<?php echo $temp;?>][night]"
			id="night<?php echo $temp;?>" value="1"
			checked="<?php echo $night;?>"
			onchange="defaultNoOfTimes('night<?php echo $service['TariffList']['id'];?>','<?php echo $service['TariffList']['id'];?>');checkApplyInADay('<?php echo $service['TariffList']['id'];?>','<?php echo $patientData['EstimatePatient']['tariff_standard_id'];?>','<?php echo $temp;?>','<?php echo $service['TariffList']['apply_in_a_day'];?>')">
			<?php }else{?> <input type="checkbox"
			name="data[Nursing][<?php echo $temp;?>][night]"
			id="night<?php echo $temp;?>" value="1"
			onchange="defaultNoOfTimes('night<?php echo $service['TariffList']['id'];?>','<?php echo $service['TariffList']['id'];?>');checkApplyInADay('<?php echo $service['TariffList']['id'];?>','<?php echo $patientData['EstimatePatient']['tariff_standard_id'];?>','<?php echo $temp;?>','<?php echo $service['TariffList']['apply_in_a_day'];?>')">
			<?php }?></td>
		<td width="70" style="text-align: center;"><?php //echo $this->Form->input('', array('name'=>'no_of_times','type'=>'text','id' => 'no_of_times','style'=>'width:150px;','autocomplete'=>'off')); ?>
		<input type="text"
			name="data[Nursing][<?php echo $temp;?>][no_of_times]"
			value="<?php echo $noOfTimes;?>" id="noOfTimes<?php echo $service['TariffList']['id'];?>"></td>


		<script>
                            checkApplyInADay('<?php echo $service['TariffList']['id'];?>','<?php echo $patientData['EstimatePatient']['tariff_standard_id'];?>','<?php echo $temp;?>','<?php echo $service['TariffList']['apply_in_a_day'];?>');
                            </script>
	</tr>
	<?php
	$morning=$evening=$night=$noOfTimes='';
	}?>
	<tr>
		 	</tr>
			</table>
	<?php }else if(isset($this->request->data) && isset($this->request->data) && $this->request->data['service_name']!=''){?>
		<div align="center" style="border: 1px solid #3E474A; padding: 5px;">No Record in services <?php //echo $patientData['EstimatePatient']['lookup_name'];?></div>
	<?php }?>

			 <div id="pageNavPosition" align="center"></div>
			<!-- billing activity form end here -->
			<div>&nbsp;</div>
		<?php if(!empty($services)){
		 
			?>
			<div class="btns"><?php 
			
			echo $this->Html->link(__('Cancel'),array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
			echo $this->Form->submit('Save', array('div'=>false,'label'=>false,'error'=>false,'class'=>'blueBtn', 'id' => 'saveServiceBill'));
			
			
			?></div>
<?php }?>
<?php echo $this->Form->end();?>
</div>


<!-- Other Services Section Starts -->
<div id="otherServicesSection" style="margin-top: 30px; display: none">
<table width="100%" style="margin-top: 70px;" cellpadding="0"
	cellspacing="1" border="0" align="center">
	<tr>
		<td align="right"><input class="blueBtn" type="Button" value="Add"
			id="addOtherServices"></td>
	</tr>
</table>

<table width="100%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm" align="center" id="viewOtherServices">
	<?php if(!empty($otherServices)){?>
	<tr>
		<th><?php echo __('Date');?></th>
		<th><?php echo __('Service');?></th>
		<th><?php echo __('Amount');?></th>
		<th width="50"><?php echo __('Action');?></th>
	</tr>
	<?php
	foreach($otherServices as $otherService){?>
	<tr>
		<td><?php 
		$sDate = explode(" ",$otherService['EstimateOtherService']['service_date']);
		echo $this->DateFormat->formatDate2Local($otherService['EstimateOtherService']['service_date'],Configure::read('date_format'));
		//echo $otherService['OtherService']['service_date']?></td>
		<td><?php echo $otherService['EstimateOtherService']['service_name']?></td>
		<td align="right"><?php echo $this->Number->format($otherService['EstimateOtherService']['service_amount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));?></td>
		<td align="center"><?php echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete')), array('action' => 'deleteOtherServices', $otherService['EstimateOtherService']['id'],$otherService['EstimateOtherService']['patient_id']), array('escape' => false),__('Are you sure?', true));?></td>
	</tr>

	<?php }
	?>
	<?php }else{?>
	<tr>
		<td align="center">No Record in Other Services for <?php echo $patientData['EstimatePatient']['lookup_name'];?></td>
	</tr>
	<?php }?>
</table>

	<?php echo $this->Form->create('estimates',array('controller'=>'estimates','action'=>'saveOtherServices','type' => 'file','id'=>'otherServices','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false,
																								        'legend'=>false,
																								        'fieldset'=>false
	)
	));
	?>
<table width="100%" cellpadding="0" cellspacing="1" border="0"
	align="center" id="viewAddService" style="display: none">
	<tr>
		<td><?php echo __('Date');?></td>
		<td><?php echo $this->Form->input('EstimateOtherService.service_date',array('type'=>'text','class' => 'validate[required,custom[mandatory-enter]]','legend'=>false,'label'=>false,'id' => 'otherServiceDate','readonly'=>'readonly'));?></td>
	</tr>

	<tr>
		<td><?php echo __('Service');?></td>
		<td><?php echo $this->Form->input('EstimateOtherService.service_name',array('class' => 'validate[required,custom[mandatory-enter]]','legend'=>false,'label'=>false,'id' => 'serviceName'));?></td>
	</tr>

	<tr>
		<td><?php echo __('Amount');?></td>
		<td><?php echo $this->Form->input('EstimateOtherService.service_amount',array('class' => 'validate[required,custom[mandatory-enter]]','legend'=>false,'label'=>false,'id' => 'serviceAmount','style'=>'text-align:right;'));?></td>
	</tr>

	<tr>
		<td>&nbsp;</td>
		<td align="left" style="padding-left: 53px; padding-top: 10px;"><?php echo $this->Form->hidden('EstimateOtherService.patient_id',array('value'=>$patientData['EstimatePatient']['id'],'legend'=>false,'label'=>false,'id' => 'patientId'));?>

		<input class="blueBtn" style="margin: 0px;" type="submit" value="Save"
			id="saveOtherServices"> <input class="blueBtn" style="margin: 0px;"
			type="button" value="Cancel" id="otherServicesCancel"> <?php //echo $this->Html->link(__('Cancel'),'#', array('id'=>'otherServicesCancel','escape' => false,'class'=>'blueBtn'));?>
		</td>
	</tr>
</table>
	<?php echo $this->Form->end();?></div>
<!-- Other Services Section Ends -->

<!-- Consultant Section Section starts here -->
		<?php echo $this->Form->create('estimates',array('controller'=>'estimates','action'=>'consultantBilling','type' => 'file','id'=>'ConsultantBilling','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false,
																								        'legend'=>false,
																								        'fieldset'=>false
		)
		));
		echo $this->Form->hidden('EstimateConsultantBilling.patient_id',array('value'=>$patientData['EstimatePatient']['id']));
		?>
		<table id="consultantSection" width="100%" style="display: none">
	<tr>
		<td></td>
	</tr>
	<tr>
		<td>
		<table width="100%" style="margin-top: 70px;" cellpadding="0"
			cellspacing="1" border="0" class="tabularForm" align="center" id="consulTantGrid">
			<tr>
				<th width="230"><?php echo __('Date');?></th>
				<th width="250"><?php echo __('Type');?></th>
				<th width="250" style=""><?php echo __('Name');?></th>
				<th width="250" style=""><?php echo __('Service Group/Sub Group');?></th>
				<th width="250" style=""><?php echo __('Service');?></th>
				<th width="250" style=""><?php echo __('Hospital Cost');?></th>
				<th width="80"><?php echo __('Amount');?></th>
				<th width="80"><?php echo __('Action');?></th>
			</tr>
			<?php $totalAmount=0;
			foreach($consultantBillingData as $consultantData){ 
				?>
			<tr>
				<td valign="middle"><?php //echo $consultantData['ConsultantBilling']['date'] ;
				if(!empty($consultantData['EstimateConsultantBilling']['date']))
				echo $this->DateFormat->formatDate2Local($consultantData['EstimateConsultantBilling']['date'],Configure::read('date_format'),true);
				?></td>
				<td valign="middle"><?php 
				$totalAmount = $consultantData['EstimateConsultantBilling']['amount'] + $totalAmount;
				if($consultantData['EstimateConsultantBilling']['category_id']==0){
					echo 'External Consultant';
				}else if($consultantData['EstimateConsultantBilling']['category_id'] ==1){
					echo 'Treating Consultant';
				}
				?></td>
				<td valign="middle" style="text-align: left;"><?php
				if($consultantData['EstimateConsultantBilling']['category_id'] == 0){
					echo $allConsultantsList[$consultantData['EstimateConsultantBilling']['consultant_id']];
				}else if($consultantData['EstimateConsultantBilling']['category_id'] == 1){
					echo $allDoctorsList[$consultantData['EstimateConsultantBilling']['doctor_id']];
				}
				?></td>


				<td valign="middle"><?php echo $consultantData['ServiceCategory']['name']."/".$consultantData['ServiceSubCategory']['name'];?>
				</td>
				<td valign="middle"><?php echo $consultantData['TariffList']['name'];?>
				</td>
				<td valign="middle" style="text-align: center;">---</td>

				<td valign="middle" style="text-align: right;"><?php echo $this->Number->currency($consultantData['EstimateConsultantBilling']['amount']);?>
				</td>
				<td valign="middle" style="text-align: right;"><?php echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete')), 
				array('action' => 'deleteEstimateConsultantCharges', $consultantData['EstimateConsultantBilling']['id']), array('escape' => false),__('Are you sure?', true));?>
				</td>
			</tr>
			<?php }
			?>
				
			<tr id="row1">
				<td valign="top" width="260">
					<input type="hidden" value="1" id="no_of_fields">	
					<?php echo $this->Form->input('', array('type'=>'text','id' => 'ConsultantDate1','class' => 'validate[required,custom[mandatory-date]]  ConsultantDate',
					'style'=>'width:88px;','readonly'=>'readonly','fieldNo'=>1,'name'=>'data[EstimateConsultantBilling][date]')); ?>
				</td>
			
				<td valign="top">
					<?php echo $this->Form->input('', array('class' => 'validate[required,custom[mandatory-select]] textBoxExpnd category_id','div' => false,'label' => false,'empty'=>__('Please select'),'options'=>array('External Consultant','Treating Consultant'),
					'id' => 'category_id1','style'=>'width:100px;','fieldNo'=>1,'name'=>'data[EstimateConsultantBilling][category_id]',"onchange"=>"categoryChange(this)")) ?>
				</td> 
				<td valign="top" style="text-align: left;">
					<?php echo $this->Form->input('EstimateConsultantBilling.doctor_id', array('class' =>
					 'validate[required,custom[mandatory-select]] textBoxExpnd doctor_id','div' => false,'label' => false,'empty'=>__('Please Select'),
					 'options'=>array(''),'id' => 'doctor_id1','style'=>'width:100px;','fieldNo'=>1,'name'=>'data[EstimateConsultantBilling][doctor_id]',
					 "onchange"=>"doctor_id(this)")); ?>
				</td> 
				<td valign="top" style="text-align: left;">
					<select
						onchange="getListOfSubGroup(this);"
						name="data[EstimateConsultantBilling][service_category_id]"
						id="service-group-id1" style="width:100px;" class="textBoxExpnd service-group-id"  fieldNo="1">
						<option value="">Select Service Group</option>
						<?php
	
						foreach($service_group as $key =>$value){
							?>
						<option value="<?php echo $value['ServiceCategory']['id'];?>"><?php echo $value['ServiceCategory']['name'];?></option>
					<?php } ?>
					</select>
					<br />
					<select id="service-sub-group1" name="data[EstimateConsultantBilling][service_sub_category_id]" style="width:100px;" 
						fieldNo="1" class="service-sub-group"	onchange="serviceSubGroup(this)" >
					</select>
				</td>
				<td valign="top" style="text-align: left;">
					<?php  echo $this->Form->input('', array('class' => 'validate[required,custom[mandatory-select]] textBoxExpnd consultant_service_id',
								'div' => false,'label' => false,'empty'=>__('Please Select'),'options'=>array(''),'id' => 'consultant_service_id1',
								'style'=>'width:100px;','fieldNo'=>1,'name'=>'data[EstimateConsultantBilling][consultant_service_id]' ,
								"onchange"=>"consultant_service_id(this)"));
					?> 
				</td>
				<td valign="top" style="text-align: center;">
					<?php  echo $this->Form->input('', array('class' => 'textBoxExpnd','type'=>'select','options'=>array('private'=>'Private','cghs'=>'CGHS','other'=>'Other'),
								'div' => false,'label' => false,'empty'=>__('Please Select'),'id' => 'hospital_cost',
								'style'=>'width:100px;','name'=>'data[EstimateConsultantBilling][hospital_cost]' ,  ));
					?>
					<div id="hospital_cost_area" style="padding-top:5px;">
						<span id="private" style="display:none"></span>
						<span id="cghs" style="display:none"></span>
						<span id="other" style="display:none"></span>
					</div>
				</td>
				<td valign="top" style="text-align: center;"><?php echo $this->Form->input('amount',array('class' => 'validate[required,custom[onlyNumber]] amount','legend'=>false,'label'=>false,'id' => 'amount1','style'=>'width:80px;','fieldNo'=>1,'name'=>'data[EstimateConsultantBilling][amount]')); 
				?></td>
				<td valign="top" style="text-align:center;">  </td>  
			</tr>

			<tr id="ampoutRow">
				<td colspan="6" valign="middle" align="right"><?php echo __('Total Amount');?></td>
				<td valign="middle" style="text-align: right;"><?php echo $this->Number->currency($totalAmount);?>
				</td>
				<td>&nbsp;</td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td>
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			align="center">
			<tr>
				 <td width="50%"><input name="" type="button" value="Add More Visits" class="blueBtn" tabindex="17" onclick="addDatpicker(addConsultantVisitElement());"/> &nbsp;&nbsp;<input name="removeVisit" type="button" value="Remove" class="blueBtn" tabindex="17" onclick="removeConsultantVisitElement();" id="removeVisit" style="visibility:hidden"/></td>
                           
				<td width="50%" align="right"><input class="blueBtn" type="submit"
					value="Save" id="saveConsultantBill"> <?php echo $this->Html->link(__('Cancel'),'#', array('id'=>'consultantCancel','escape' => false,'class'=>'blueBtn'));?>
				</td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td></td>
	</tr>
</table>
	
		
			<?php echo $this->Form->end(); ?>
<!--  Consultant Section ends here -->				

<!-- Laboratory Starts Here -->
<div id="pathologySection"
	style="margin-bottom: 10px; margin-top: 80px; display: none; width: 100%">
<?php //view for lab order
/* View Section for Laboratory */
?>
<table class="tabularForm" style="position: relative; width: 100%"
	cellspacing="1">
	<tbody>
	<?php if(!empty($lab)){?>
		<tr class="row_title">
			<th class="table_cell" width="20"><strong><?php echo __('Sr.No.'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Service Name'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Date & Time'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Qty'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Amount(Rs.)'); ?></strong></th>
			<th class="table_cell" width="50"><strong><?php echo __('Action'); ?></strong></th>
		</tr>
		<?php

		//BOF laboratory
		$i=1;
		$hosType = ($this->Session->read('hospitaltype')=='NABH')?'nabh_rate':'non_nabh_rate' ;
		$lCost = 0 ;
		foreach($lab as $labKey=>$labCost){
			//if(!empty($labCost['LaboratoryTokens']['ac_id']) || !empty($labCost['LaboratoryTokens']['sp_id'])){
			$lCost += $labCost['CorporateLabRate'][$hosType] ;
			?>
		<tr>
			<td valign="top"><?php echo $i++ ;?></td>
			<td>&nbsp;&nbsp;<?php echo $labCost['Laboratory']['name'];?></td>
			<td>&nbsp;&nbsp;<?php
			$splitDateIn=  explode(" ",$labCost['EstimateLaboratoryTestOrder']['create_time']);
			echo $this->DateFormat->formatDate2Local($labCost['EstimateLaboratoryTestOrder']['create_time'],Configure::read('date_format'),true);
			?></td>
			<td align="right" valign="top">1</td>
			<td align="right" valign="top"><?php echo $this->Number->format($labCost['CorporateLabRate'][$hosType],array('places'=>2,'decimal'=>'.','before'=>false));?></td>
			<td align="center" valign="top"><?php echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete')),
			 array('action' => 'deleteLabTest', $labCost['EstimateLaboratoryTestOrder']['id'],$labCost['EstimateLaboratoryTestOrder']['patient_id']), array('escape' => false),__('Are you sure?', true));?></td>
		</tr>
		<?php
		//}
		}
		if($lCost>0){
			?>
		<tr>
			<td colspan="4" align="right"><!-- <div class="inner_title"><h3>Sub Total</h3><div class="clr"></div><div align="right"><h3><?php echo $this->Number->format($lCost,array('places'=>2,'decimal'=>'.','before'=>false)); ?></h3></div></div>
			 --> Total</td>
			<td align="right"><?php echo $this->Number->format($lCost,array('places'=>2,'decimal'=>'.','before'=>false)); ?></td>
			<td>&nbsp;</td>
		</tr>
		<?php
		}?>
		<?php }else{?>
		<tr>
			<td align="center" colspan="4">No Record in Laboratory for <?php echo $patientData['EstimatePatient']['first_name'].' '.$patientData['EstimatePatient']['last_name'];?></td>
		</tr>
		<?php }?>
	</tbody>
</table>

<?php 
/* View Section for Laboratory end*/

                   $deptHtml = $this->element('estimate_lab_order');
                   $pageHeading = __('Lab Test Order');
                   		
?>

                   <?php  
                   		echo $this->Form->create('estimates', array('url' => array('controller' => 'estimates', 'action' => 'lab_order',$patient_id)
																	,'id'=>'orderfrm','type'=>'get',
															    	'inputDefaults' => array(
															        'label' => false,
															        'div' => false,'error'=>false
															    )
						));
							$radioRadio = '';
							$radiohisto = '';
							$radioLab 	= '';
						
				   ?>	
				  
                   <div class='clr'></div>
                   
                   
                   <?php echo $this->Form->end() ;?>                  
                   
                   <div class="clr ht5"></div>
                   <div class="clr ht5"></div>
                   
                   <?php 
                   		echo $deptHtml;        		
                   ?>
                   
                   <!-- Right Part Template ends here -->  
</div>				
<!-- Laboratory Ends Here -->

<!--  radiology section start-->
<div id="radiologySection"
	style="margin-bottom: 10px; margin-top: 80px; display: none; width: 100%">
	
<table class="tabularForm" style="position: relative; width: 100%"
	cellspacing="1">
	<tbody>
	<?php if(!empty($rad)){?>
		<tr class="row_title">
			<th class="table_cell" width="20"><strong><?php echo __('Sr.No.'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Service Name'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Date & Time'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Qty'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Amount(Rs.)'); ?></strong></th>
			<th class="table_cell" width="50"><strong><?php echo __('Action'); ?></strong></th>
		</tr>
		<?php

		//BOF laboratory
		$i=1;
		$hosType = ($this->Session->read('hospitaltype')=='NABH')?'nabh_rate':'non_nabh_rate' ;
		$rCost = 0 ;
		foreach($rad as $radKey=>$radCost){
			//if(!empty($labCost['LaboratoryTokens']['ac_id']) || !empty($labCost['LaboratoryTokens']['sp_id'])){
			$rCost += $radCost['CorporateLabRate'][$hosType] ;
			?>
		<tr>
			<td valign="top"><?php echo $i++ ;?></td>
			<td>&nbsp;&nbsp;<?php echo $radCost['Radiology']['name'];?></td>
			<td>&nbsp;&nbsp;<?php
			$splitDateIn=  explode(" ",$radCost['EstimateRadiologyTestOrder']['create_time']);
			echo $this->DateFormat->formatDate2Local($radCost['EstimateRadiologyTestOrder']['create_time'],Configure::read('date_format'),true);
			?></td>
			<td align="right" valign="top">1</td>
			<td align="right" valign="top"><?php echo $this->Number->format($radCost['CorporateLabRate'][$hosType],array('places'=>2,'decimal'=>'.','before'=>false));?></td>
			<td align="center" valign="top"><?php echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete')), array('action' => 'deleteRadTest', $radCost['EstimateRadiologyTestOrder']['id'],$radCost['EstimateRadiologyTestOrder']['patient_id']), array('escape' => false),__('Are you sure?', true));?></td>
		</tr>
		<?php
		//}
		}
		if($rCost>0){
			?>
		<tr>
			<td colspan="4" align="right"><!-- <div class="inner_title"><h3>Sub Total</h3><div class="clr"></div><div align="right"><h3><?php echo $this->Number->format($rCost,array('places'=>2,'decimal'=>'.','before'=>false)); ?></h3></div></div>
			 --> Total</td>
			<td align="right"><?php echo $this->Number->format($rCost,array('places'=>2,'decimal'=>'.','before'=>false)); ?></td>
			<td>&nbsp;</td>
		</tr>
		<?php
		}?>
		<?php }else{?>
		<tr>
			<td align="center" colspan="4">No Record in Radiology for <?php echo $patientData['EstimatePatient']['first_name'].' '.$patientData['EstimatePatient']['last_name'];?></td>
		</tr>
		<?php }?>
	</tbody>
</table>	
	<?php 
/* View Section for Radiology end*/

                   $deptHtml1 = $this->element('estimate_radiology_order');
                   $pageHeading = __('Radiology Test Order');
                   		
?>

                   <?php  
                   		echo $this->Form->create('estimates', array('url' => array('controller' => 'estimates', 'action' => 'radiology_order',$patient_id)
																	,'id'=>'orderfrm','type'=>'get',
															    	'inputDefaults' => array(
															        'label' => false,
															        'div' => false,'error'=>false
															    )
						));
							$radioRadio = '';
							$radiohisto = '';
							$radioLab 	= '';
						
				   ?>	
				  
                   <div class='clr'></div>
                   
                   
                   <?php echo $this->Form->end() ;?>                  
                   
                   <div class="clr ht5"></div>
                   <div class="clr ht5"></div>
                   
                   <?php 
                   		echo $deptHtml1;        		
                   ?>
                   
                   
	
</div>

<script>
var viewSection="<?php echo $viewSection;?>";
$(document).ready(function(){
	$(".ConsultantDate").datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',				 
		dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
		minDate:new Date(<?php echo $this->General->minDate($patient['Patient']['form_received_on']) ?>),
		onSelect:function(){$(this).focus();}	
	}); 
	 


	$('#consultantCancel').click(function() {
		document.getElementById('ConsultantBilling').reset();
		$("#servicesSectionBtn").attr('checked', true);
		$("#consultantSection").hide();
		$("#servicesSection").show();
	});
	
	$('#dischargeBill').click(function() {
		 $("#servicesSectionBtn").attr('checked', true);
		 $("#pharmacy-section").hide();
		 $("#pathologySection").hide();
		 $("#consultantSection").hide();
		 $("#servicesSection").show();
		 $("#otherServicesSection").hide();
	});
	$('#advancePayment').click(function() {
		 $("#servicesSectionBtn").attr('checked', true);
		 $("#pharmacy-section").hide();
		 $("#pathologySection").hide();
		 $("#consultantSection").hide();
		 $("#servicesSection").show();
		 $("#otherServicesSection").hide();
	});
	
	 $("#servicesSection").show();
	 $('#saveConsultantBill').click(function() {
	    jQuery("#ConsultantBilling").validationEngine();
	 });
	 $('#saveServiceBill').click(function() {
	    jQuery("#servicefrm").validationEngine();
	 });
	 $('body').click(function() {
	   jQuery("#ConsultantBilling").validationEngine('hide');
	   jQuery("#servicefrm").validationEngine('hide');
	 });
	 $('#saveOtherServices').click(function() {
	     jQuery("#otherServices").validationEngine();
	  });
	 
	
	if(viewSection !=''){
	$("#consultantSection").hide();
	$("#servicesSection").hide();
	$("#servicesSectionBtn").attr('checked', false);
	$("#consultantSectionBtn").attr('checked', false);
	$("#"+viewSection).show();
	$("#"+viewSection+'Btn').attr('checked', true);
	//alert(viewSection);
	}
	
	
	$(".servicesClick").click(function(){
	var checkboxId = this.id;
	var splitArr = checkboxId.split("_");
	var enableInput = splitArr[0]+'_quantity_'+splitArr[1];
	//alert(enableInput);
	if ($("#"+checkboxId).is(":checked")) {
		 $("#"+enableInput).attr("readonly", false);
		 $("#"+enableInput).val(1);
	}else{
	 	$("#"+enableInput).attr("readonly", 'readonly');
	 	$("#"+enableInput).val('');
	}
	
	});
	
	$("#servicesSectionBtn").click(function(){
	 $("#consultantSection").hide();
	 $("#servicesSection").show();
	 $("#pharmacy-section").hide();
	 $("#pathologySection").hide();
	 $("#radiologySection").hide();
	 $("#OtherServicesSection").hide();
	 $("#otherServicesSection").hide();
	});
	$("#consultantSectionBtn").click(function(){
	 document.getElementById('ConsultantBilling').reset();
	 $("#consultantSection").show();
	 $("#servicesSection").hide();
	 $("#pharmacy-section").hide();
	 $("#pathologySection").hide();
	 $("#radiologySection").hide();
	 $("#OtherServicesSection").hide();
	 $("#otherServicesSection").hide();
	});
	$("#pathologySectionBtn").click(function(){
	 document.getElementById('ConsultantBilling').reset();
	 $("#consultantSection").hide();
	 $("#servicesSection").hide();
	 $("#pharmacy-section").hide();
	 $("#pathologySection").show();
	 $("#radiologySection").hide();
	 $("#OtherServicesSection").hide();
	 $("#otherServicesSection").hide();
	});
	$("#radiologySectionBtn").click(function(){
	 document.getElementById('ConsultantBilling').reset();
	 $("#consultantSection").hide();
	 $("#servicesSection").hide();
	 $("#pharmacy-section").hide();
	 $("#pathologySection").hide();
	 $("#radiologySection").show();
	 $("#OtherServicesSection").hide();
	 $("#otherServicesSection").hide();
	 //alert('here');
	});
	
	$("#pharmacy-sectionBtn").click(function(){ 
	 document.getElementById('ConsultantBilling').reset();
	 $("#consultantSection").hide();
	 $("#servicesSection").hide();
	 $("#pharmacy-section").show();
	 $("#pathologySection").hide();
	 $("#radiologySection").hide();
	 $("#OtherServicesSection").hide();
	 $("#otherServicesSection").hide();
	 //alert('here');
	});
	
	$("#otherServicesSectionBtn").click(function(){ 
	 document.getElementById('ConsultantBilling').reset();
	 $("#consultantSection").hide();
	 $("#servicesSection").hide();
	 $("#pharmacy-section").hide();
	 $("#pathologySection").hide();
	 $("#radiologySection").hide();
	 $("#otherServicesSection").show();
	 //alert('here');
	});	
	
	$("#addOtherServices").click(function(){ 
	 $("#viewAddService").show();
	 $("#viewOtherServices").hide();
	 $("#addOtherServices").hide();
	});
	
	$("#otherServicesCancel").click(function(){ 
	 $("#viewAddService").hide();
	 $("#viewOtherServices").show();
	 $("#addOtherServices").show();
	});
	
	
	
	$("#category_id").change(function(){
	// $("#amount").val('');
	 $("#doctor_id").val('Please Select');
	 $("#charges_type").val('Please Select');
	 $.ajax({
		  url: "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getDoctorList", "admin" => false)); ?>"+"/"+$('#category_id').val(),
		  context: document.body,				  		  
		  success: function(data){//alert(data);
		  	data= $.parseJSON(data);
		  	$("#doctor_id option").remove();
		  	$("#doctor_id").append( "<option value=''>Please Select</option>" );
			$.each(data, function(val, text) {
			    $("#doctor_id").append( "<option value='"+val+"'>"+text+"</option>" );
			});
			$('#doctor_id').attr('disabled', '');					  			
		    		
		  }
	});
	});
	
	/*  $("#category_id").change(function(){
	$("#doctor_id").val('Please select');
	$("#charges_type").val('Please select');
	
	});
	*/
	/*$("#charges_type").change(function(){
	$("#amount").val(''); 
	if($("#category_id").val() == 0){
		$.ajax({
			  url: "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getConsultantCharges", "admin" => false)); ?>"+"/"+$('#doctor_id').val()+"/"+$('#charges_type').val(),
			  context: document.body,				  		  
			  success: function(data){//alert(data);
			  	data= $.parseJSON(data);
			  	$("#amount").val(data);
			  }
		});
	}
	});*/
	
	
	$("#service-sub-group").change(function(){
		$("#amount").val(''); 
		
			$.ajax({
				  url: "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getConsultantServices", "admin" => false)); ?>"+"/"+$('#service-group-id').val()+"/"+$('#service-sub-group').val(),
				  context: document.body,				  		  
				  success: function(data){ 
				  	data= $.parseJSON(data);
				  	$("#consultant_service_id option").remove();
				  	$("#consultant_service_id").append( "<option value=''>Please Select</option>" );
					$.each(data, function(val, text) {
					    $("#consultant_service_id").append( "<option value='"+val+"'>"+text+"</option>" );
					});
				  }
			});
		
	 });
	//cost of consutatnt
	$("#consultant_service_id").change(function(){
		$("#amount").val(''); 
			var tariff_standard_id ='<?php echo $patient['Patient']['tariff_standard_id'];?>';
			$.ajax({
				  url: "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getConsultantCost", "admin" => false)); ?>"+"/"+$(this).val()+"/"+tariff_standard_id,
				  context: document.body,				  		  
				  success: function(data){ 
				  	data= $.parseJSON(data);
				  	$("#amount").val(data); 
				  }
			});
		
	 });
	
	$("#doctor_id").change(function(){
	 $("#amount").val(''); 
	 $("#charges_type").val('Please Select');
	});
	
	$(function() {
		$("#billDate").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',				 
			dateFormat:'<?php echo $this->General->GeneralDate();?>',
			maxDate: new Date(),	
			onSelect: function (theDate)
		    {			        // The "this" keyword refers to the input (in this case: #someinput)
		   		window.location.href = '?serviceDate='+theDate;
		    	 
		    }	
		}); 
	
		$("#otherServiceDate").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',				 
			dateFormat:'<?php echo $this->General->GeneralDate();?>',	
			maxDate: new Date(),		
		});
	
		$("#search_service_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","TariffList","name",'null','null','null', "admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true
		});
		
		//fnction to display hospital cost 
 		$("#hospital_cost").change(function(){ 
 			/*$("#hospital_cost_area").each(function() {
 			   $(this).hide();
 			});*/
 			 $("#hospital_cost_area").find('span').each(function(){ 
 	 			 	$("#"+$(this).attr('id')).hide();
 			 });
 			$("#"+$(this).val()).show();
 	 	});
		});
	});
	
	function getListOfSubGroup(obj){
	 	var currentField = $(obj);
	    var fieldno = currentField.attr('fieldNo') ;
	 	 $.ajax({
				  url: "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getListOfSubGroup", "admin" => false)); ?>"+"/"+obj.value,
				  context: document.body,				  		  
				  success: function(data){//alert(data);
				  	data= $.parseJSON(data);
				  	$("#service-sub-group"+fieldno+" option").remove();
				  	$("#service-sub-group"+fieldno).append( "<option value=''>Select Sub Group</option>" );
					$.each(data, function(val, text) {
					    $("#service-sub-group"+fieldno).append( "<option value='"+val+"'>"+text+"</option>" );
					});	
				  }
			});
	 
	 
					$.ajax({
						  url: "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getConsultantServices", "admin" => false)); ?>"+"/"+$('#service-group-id'+fieldno).val()+"/",
						  context: document.body,				  		  
						  success: function(data){ 
						  	data= $.parseJSON(data);
						  	$("#consultant_service_id"+fieldno+" option").remove();
						  	$("#consultant_service_id"+fieldno).append( "<option value=''>Select Service</option>" );
							$.each(data, function(val, text) {
							    $("#consultant_service_id"+fieldno).append( "<option value='"+val+"'>"+text+"</option>" );
							});
						  }
					});
	 }

	
  var pager = new Pager('serviceGrid', 20); 
        pager.init(); 
        pager.showPageNav('pager', 'pageNavPosition'); 
        pager.showPage(1);

        function categoryChange(obj){ 
    		var currentField = $(obj);
        	var fieldno = currentField.attr('fieldNo') ;
    		 $("#amount"+fieldno).val('');
    		 $("#doctor_id"+fieldno).val('Please Select');
    		 $("#charges_type"+fieldno).val('Please Select');
    		 $.ajax({
    			  url: "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getDoctorList", "admin" => false)); ?>"+"/"+$('#category_id'+fieldno).val(),
    			  context: document.body,				  		  
    			  success: function(data){//alert(data);
    			  	data= $.parseJSON(data);
    			  	$("#doctor_id"+fieldno+" option").remove();
    			  	$("#doctor_id"+fieldno).append( "<option value=''>Please Select</option>" );
    				$.each(data, function(val, text) {
    				    $("#doctor_id"+fieldno).append( "<option value='"+val+"'>"+text+"</option>" );
    				});
    				$('#doctor_id'+fieldno).attr('disabled', '');					  			
    			    		
    			  }
    		});
         }
         function serviceSubGroup(obj){
    	 	var currentField = $(obj);
        	var fieldno = currentField.attr('fieldNo') ;
    			$("#amount"+fieldno).val(''); 
    			
    				$.ajax({
    					  url: "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getConsultantServices", "admin" => false)); ?>"+"/"+$('#service-group-id'+fieldno).val()+"/"+$('#service-sub-group'+fieldno).val(),
    					  context: document.body,				  		  
    					  success: function(data){ 
    					  	data= $.parseJSON(data);
    					  	$("#consultant_service_id"+fieldno+" option").remove();
    					  	$("#consultant_service_id"+fieldno).append( "<option value=''>Select Service</option>" );
    						$.each(data, function(val, text) {
    						    $("#consultant_service_id"+fieldno).append( "<option value='"+val+"'>"+text+"</option>" );
    						});
    					  }
    				});
    			
    		 } 
    		 
    	//cost of consutatnt
    	  function consultant_service_id(obj){
    	   var currentField = $(obj);
        	var fieldno = currentField.attr('fieldNo') ;
    			$("#amount"+fieldno).val(''); 
    				var tariff_standard_id ='<?php echo $patientData['EstimatePatient']['tariff_standard_id'];?>';
    				$.ajax({
    					  url: "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getConsultantCost", "admin" => false)); ?>"+"/"+$(obj).val()+"/"+tariff_standard_id,
    					  context: document.body,				  		  
    					  success: function(data){ 
    					  	data= $.parseJSON(data);
    					  	$("#amount"+fieldno).val(data.tariff_amount);
    					  	$("#hospital_cost").val(''); 
    					  	$("#hospital_cost_area").find('span').each(function(){ 
    		 	 			 	$("#"+$(this).attr('id')).hide();
    		 			    });
    					  	$("#private").html(data.private);
    					  	$("#cghs").html(data.cghs);
    					  	$("#other").html(data.other);
    					  }
    				});
    			
    		 } 
    		 
          function doctor_id(obj){
    	 	var currentField = $(obj);
        	var fieldno = currentField.attr('fieldNo') ;
        	 $("#amount"+fieldno).val(''); 
        	 $("#charges_type"+fieldno).val('Please Select');
         } 
</script>
