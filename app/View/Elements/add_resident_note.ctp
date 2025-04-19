<style>
.textBoxExpnd {
	width: 200px;
}

table td {
	font-size: 15px;
}

img {
	float: unset;
}

.discount {
	display: none;
}

input.getDiscount,input.discountValue,.brkUp,.cost,#totalAmount,#totalDiscount,#totalDiscountPackage,#packagePrice
	{
	text-align: right;
}

.highlightInput {
	border-color: #9ecaed;
	box-shadow: 0 0 10px #9ecaed;
}
</style>
<?php $discountOptions = array('inPercent'=>'%','inAmount'=>'amt');?>
<div>&nbsp;</div>
<div class="inner_title" style="width: 99%;">
	<h3>
		<?php echo __($title_for_layout, true); ?>
	</h3>
	<span> <?php
	$patientId = $this->request->query['patientId'];
	$appointmentId = $this->request->query['appointmentId'];
	$noteId = $this->request->query['noteId'];
	if($appointmentId){
		echo $this->Html->link(__('Back', true),array('controller'=>'Notes','action'=>'clinicalNote',$patientId,$appointmentId,$noteId), array('escape' => false,'class'=>'blueBtn'));
	}else if($this->params->query['admittedPatient'] != '1'){
		echo $this->Html->link(__('Back'),array('controller'=>'Estimates','action'=>'residentDashboard'), array('escape' => false,'class'=>'blueBtn'));
	}
	?>
	</span>
</div>
<div>
	<?php echo $this->Form->create('Resident',array('type' => 'file','id'=>'residentFrm','inputDefaults' => array(
			'label' => false,
			'div' => false,
			'error' => false,
			'legend'=>false,
			'fieldset'=>false
	)));
	//$linkToMail = $this->Html->url(array('controller'=>'Estimates','action'=>'packageEstimate'));
	//echo $this->Form->input('EstimateConsultantBilling.linkToMail',array('value'=>$linkToMail,'type'=>'text'));
	?>
	<table border="0" cellpadding="0" cellspacing="4"
		style="padding-top: 10px; line-height: 22px; float: left;"
		align="center" class="tdLabel" width="54%">
		<?php echo $this->Form->hidden('EstimateConsultantBilling.id', array('id'=>'estimateId'));?>
		<?php echo $this->Form->hidden('EstimateConsultantBilling.person_id',array('id'=>'personId'));
		if($this->request->query['patientId']) $this->request->data['EstimateConsultantBilling']['patient_id'] = $this->request->query['patientId'];
		echo $this->Form->hidden('EstimateConsultantBilling.patient_id',array('id'=>'patientId'));?>
		<?php  if($this->Session->read('role') == Configure::read('residentLabel')){ ?>
		<tr>
			<td width="28%">Patient name:</td>
			<td colspan="2"><?php echo $this->request->data['EstimateConsultantBilling']['patient_name']." ( ".$this->request->data['Person']['sex']." / ".$this->request->data['Person']['age']." )";
					echo $this->Form->hidden('EstimateConsultantBilling.patient_name',array('id'=>'patientname'));?>
				<span style="float: right; font-size: 15px; padding: 0px 180px;"><strong>
						<?php echo $this->Html->link('Add discount','#',array('id'=>'showDiscountFields'));?>
				</strong> </span>
			</td>
		</tr>
		<tr>
			<td width="24%">Assigned by:</td>
			<td><?php  
			echo $this->request->data['EstimateConsultantBilling']['doctor_name'];
			echo $this->Form->hidden('EstimateConsultantBilling.sendMailTo', array('value'=>$this->request->data['EstimateConsultantBilling']['doctor_id']));
			echo $this->Form->hidden('EstimateConsultantBilling.consultant_id', array('id'=>'assignedTo'));
			echo $this->Form->hidden('EstimateConsultantBilling.location_id', array('id'=>'locationId'));
			echo $this->Form->hidden('EstimateConsultantBilling.doctor_id',array('id'=>'doctorId'));
			echo $this->Form->hidden('EstimateConsultantBilling.send_for_approval',array('id'=>'sendForApproval'));
			?>
			</td>
		</tr>
		<?php }else{ ?>
		<tr>
			<td width="28%">Patient name:</td>
			<?php $inputType = ($this->request->data['EstimateConsultantBilling']['patient_name']) ? 'hidden' : 'input';?>
			<td colspan="2"><?php echo $this->request->data['EstimateConsultantBilling']['patient_name']." ( ".$this->request->data['Person']['sex']." / ".$this->request->data['Person']['age']." )";
			echo $this->Form->$inputType('EstimateConsultantBilling.patient_name',array('id'=>'patientname','class'=>'textBoxExpnd'));
			?> <span style="float: right; font-size: 15px; padding: 0px 180px;"><strong>
						<?php echo $this->Html->link('Add discount','#',array('id'=>'showDiscountFields'));?>
				</strong> </span>
			</td>
		</tr>
		<tr>
			<td width="20%">Hospital name:<font color="red">*</font>
			</td>
			<td width="80%"><?php  
			echo $this->Form->input('EstimateConsultantBilling.location_id', array('empty'=>'Please Select','options'=>$locations,'label'=>false,
				'class'=>'textBoxExpnd validate[required,custom[mandatory-select]]','id'=>'locationId','onchange'=>'getLocationConsultant();'));
			?>
			</td>
		</tr>
		<tr>
			<td width="20%">Assigned to:<font color="red">*</font>
			</td>
			<td width="80%"><?php  
			echo $this->Form->input('EstimateConsultantBilling.consultant_id', array('empty'=>'Please Select','options'=>$Residentlist,'label'=>false,
				'class'=>'textBoxExpnd validate[required,custom[mandatory-select]]','id'=>'consultantId'));
			echo $this->Form->hidden('EstimateConsultantBilling.doctor_id',array('value'=>$_SESSION['Auth']['User']['id']));
			echo $this->Form->hidden('EstimateConsultantBilling.sendMailTo', array('id'=>'sendMailTo','value'=>$this->request->data['EstimateConsultantBilling']['consultant_id']));
			?>
			</td>
		</tr>
		<?php $assignClass = 'assignedDate';?>
		<?php } ?>
		<?php $date = ($this->data['EstimateConsultantBilling']['date']) ? $this->data['EstimateConsultantBilling']['date'] : $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'),true);?>
		<tr>
			<td>Assigned date:</td>
			<td colspan="3">
				<div style="width: 38%; float: left;">
					<?php echo $this->Form->input(__('EstimateConsultantBilling.date'),array('type'=>'text','id' => 'assigned_date','class'=>"$assignClass textBoxExpnd",'div'=>false,'value'=>$date,'readOnly'=>true)); ?>
				</div>
				<div class="residentField">
					<label style="width: 10% !important; padding-top: 0px !important;"
						class="discount"><?php echo $this->Form->input(__('EstimateConsultantBilling.discount.direct_bill_surgeon'),array('hiddenField'=>false,
								'type'=>'checkbox','div'=>false,'id'=>'directBillSurgeon'))?> </label>
					<label style="padding-top: 0px ! important; width: 30%;"
						class="discount">Surgeon Fees directly billable</label>
				</div>
			</td>
		</tr>
		<tr class="residentField">
			<td>Tentative date of admission:<font color="red">*</font>
			</td>
			<td colspan="3"><div style="width: 38%; float: left;">
					<?php echo $this->Form->input(__('EstimateConsultantBilling.admission_date'),array('type'=>'text','class'=>'date validate[required,custom[mandatory-select]] textBoxExpnd','div'=>false))?>
				</div>
				<div>
					<label style="width: 10% !important; padding-top: 0px !important;"
						class="discount"><?php echo $this->Form->input(__('EstimateConsultantBilling.discount.direct_bill_implant'),array('hiddenField'=>false,
								'type'=>'checkbox','div'=>false,'id'=>'directBillImplant'))?> </label>
					<label style="padding-top: 0px ! important; width: 24%;"
						class="discount">Implant directly billable</label>
				</div></td>

		</tr>
		<tr class="residentField">
			<td>Tentative date of surgery:</td>
			<td colspan="3"><div style="width: 38%; float: left;">
					<?php echo $this->Form->input(__('EstimateConsultantBilling.surgery_date'),array('type'=>'text','class'=>'date textBoxExpnd','div'=>false))?>
				</div>
				<div>
					<label style="width: 10% !important; padding-top: 0px !important;"
						class="discount"><?php echo $this->Form->input(__('EstimateConsultantBilling.discount.direct_bill_anaesthetist'),array('hiddenField'=>false,
								'type'=>'checkbox','div'=>false,'id'=>'directBillAnaesthetist'))?>
					</label> <label style="padding-top: 0px ! important; width: 36%;"
						class="discount">Anaesthetist Charge directly billable</label>
				</div></td>
		</tr>
		<tr class="residentField">
			<td>Package name:<font color="red">*</font>
			</td>
			<td><?php echo $this->Form->input(__('EstimateConsultantBilling.package_name'),array('type'=>'text',
					'class'=>'validate[required,custom[mandatory-enter]] textBoxExpnd','div'=>false,'id'=>'packageName'));
		             echo $this->Form->hidden(__('EstimateConsultantBilling.package_estimate_id'),array('id'=>'packageId')); ?>
			</td>
		</tr>
		<tr>
			<td>Procedure name:</td>
			<td><?php echo $this->Form->input(__('EstimateConsultantBilling.surgery_name'),array('type'=>'text','class'=>'textBoxExpnd','div'=>false,'id'=>'surgeryName'));
					echo $this->Form->hidden(__('EstimateConsultantBilling.surgery_id'),array('id'=>'surgeryId')); ?>
				<?php if(file_exists(FULL_BASE_URL.Router::url('/')."uploads/surgeries_files/".$this->data['EstimateConsultantBilling']['surgery_info_file_name'])){
					$url = array('action'=>'showPpt',$this->data['EstimateConsultantBilling']['surgery_id']);
					$url = FULL_BASE_URL.Router::url('/')."uploads/surgeries_files/".$this->data['EstimateConsultantBilling']['surgery_info_file_name'];
					$display = 'block';
				}else{
			 $url = '#';
			 $display = 'none';
			}?> <span id="ppt" style="display:<?php echo $display;?>"><?php echo $this->Html->link('Click view PPT',
				$url,array('id'=>'showPPT' ,'target'=>'_blank' ));?> </span>
			</td>
		</tr>
		<tr class="residentField">
			<td>Surgeon fees:<font color="red">*</font>
			</td>
			<td><?php echo $this->Form->input(__('EstimateConsultantBilling.surgeon_fees'),array('type'=>'text',
				'class'=>'cost validate[required,custom[mandatory-enter],custom[onlyNumber]]  textBoxExpnd','div'=>false,'id'=>'surgeonFees'))?>
				<label style="width: 79px !important; padding-top: 0px !important;"
				class="discount"> <?php echo $this->Form->input('EstimateConsultantBilling.discount.fee_discount_type',array('options'=>$discountOptions,'class'=>'getDiscount','id'=>'surgeonFeesDiscountType'));?>
			</label> <?php echo $this->Form->input(__('EstimateConsultantBilling.discount.surgeon_fees_discount'),array('type'=>'text',
						'class'=>'discount getDiscount validate[custom[onlyNumber]]','style'=>'width:100px;','div'=>false,'id'=>'surgeonFeesDiscount')); ?>
			</td>
			<td class="discount"><?php echo $this->Form->input(__('EstimateConsultantBilling.discount.surgeon_discount'),array('type'=>'text',
					'class'=>'discountValue validate[custom[onlyNumber]]','div'=>false,'id'=>'surgeonFeesDiscountValue'))?>
			</td>
		</tr>
		<?php if(!empty($icuWardId))
		{
		?>
		<tr class="residentField">
			<td>Accomodation in ICU:<font color="red">*</font>
			</td>
			<td><?php 	
			echo $this->Form->hidden('icuId',array('id'=>'icuId','value'=>$icuWardId));
			echo $this->Form->input(__('EstimateConsultantBilling.days_in_icu'),array('type'=>'text','div'=>false,
					'class' => 'validate[required,custom[mandatory-enter],custom[onlyNumber]]  textBoxExpnd','id'=>'daysInIcu')); ?>
			</td>
		</tr>
		<?php }?>
		<tr class="residentField">
			<td>Accomodation:<font color="red">*</font>
			</td>
			<?php unset($ward[$icuWardId]);?>
			<td><?php echo $this->Form->input(__('EstimateConsultantBilling.ward_id'),array('class'=>'textBoxExpnd validate[required,custom[mandatory-select]]',
				'div'=>false,'id'=>'wardId','empty'=>'Please Select','options'=>$ward))?>
				<label style="width: 79px !important; padding-top: 0px !important;">No.
					of days</label> <?php echo $this->Form->input(__('EstimateConsultantBilling.no_of_days'),array('type'=>'text',
						'class'=>'textBoxExpnd validate[custom[onlyNumber]]','style'=>'width:100px;','div'=>false,'id'=>'noOfDays')); ?>
			</td>
		</tr>
		<tr class="residentField">
			<td>Accomodation charge:<font color="red">*</font>
			</td>
			<td><?php echo $this->Form->input(__('EstimateConsultantBilling.accomodation_charge'),array('type'=>'text','div'=>false,
				'class' => 'cost validate[required,custom[mandatory-enter],custom[onlyNumber]]  textBoxExpnd','id'=>'accomodation')); ?>
				<label style="width: 79px !important; padding-top: 0px !important;"
				class="discount"> <?php echo $this->Form->input('EstimateConsultantBilling.discount.accomodation_discount_type',array('options'=>$discountOptions,'class'=>'getDiscount','id'=>'accomodationDiscountType'));?>
			</label> <?php echo $this->Form->input(__('EstimateConsultantBilling.discount.accomodation_discount'),array('type'=>'text',
						'class'=>'discount getDiscount validate[custom[onlyNumber]]','style'=>'width:100px;','div'=>false,'id'=>'accomodationDiscount')); ?>
			</td>
			<td class="discount"><?php echo $this->Form->input(__('EstimateConsultantBilling.discount.accomodation_discount_value'),array('type'=>'text',
					'class'=>'discountValue validate[custom[onlyNumber]]','div'=>false,'id'=>'accomodationDiscountValue'))?>
			</td>
		</tr>
		<tr class="residentField">
			<td>Implant:</td>
			<td colspan="2"><?php echo $this->Form->input(__('OtItem.manufacturer'),array('type'=>'text','class'=>'textBoxExpnd ','div'=>false,'id'=>'implantCompany','placeHolder'=>'Company Name')); ?>
				<label style="width: 79px !important; padding-top: 0px !important;">Name</label>
				<?php echo $this->Form->input(__('OtItem.name'),array('type'=>'text','style'=>'width:100px;','div'=>false,
						'id'=>'implantName','placeHolder'=>'Implant Name','class' => 'textBoxExpnd'));
				echo $this->Form->hidden('EstimateConsultantBilling.ot_item_id',array('id'=>'otItemId'));
				?>
			</td>
		</tr>
		<tr class="residentField">
			<td>Implant charge:<!-- <font color="red">*</font> -->
			</td>
			<td><?php echo $this->Form->input(__('EstimateConsultantBilling.implant_charge'),array('default'=>0,'type'=>'text',
				'class'=>'cost textBoxExpnd','div'=>false,'id'=>'implant'));?>
				<label style="width: 79px !important; padding-top: 0px !important;"
				class="discount"> <?php echo $this->Form->input('EstimateConsultantBilling.discount.implant_discount_type',array('options'=>$discountOptions,'class'=>'getDiscount','id'=>'implantDiscountType'));?>
			</label> <?php echo $this->Form->input(__('EstimateConsultantBilling.discount.implant_discount'),array('type'=>'text',
						'class'=>'discount getDiscount validate[custom[onlyNumber]]','style'=>'width:100px;','div'=>false,'id'=>'implantDiscount')); ?>
			</td>
			<td class="discount"><?php echo $this->Form->input(__('EstimateConsultantBilling.discount.implant_discount_value'),array('type'=>'text',
					'class'=>'discountValue validate[custom[onlyNumber]]','div'=>false,'id'=>'implantDiscountValue'))?>
			</td>
		</tr>
		<tr class="residentField">
			<td>Sub Implant</td>
			<td colspan="2"><?php $serviceArray[''] = 'Please select';
			if($wardService[$this->data['EstimateConsultantBilling']['ward_id']]['i_assist'])$serviceArray['0'] = 'i-Assist';
			if($wardService[$this->data['EstimateConsultantBilling']['ward_id']]['psi'])$serviceArray['1'] = 'PSI';

			echo $this->Form->input(__('EstimateConsultantBilling.implant_service'),array('class' => 'textBoxExpnd','id'=>'implantService',
					'style'=>'text-align: left;','div'=>false,'options'=>$serviceArray)); ?>
				<label style="width: 79px !important; padding-top: 0px !important;">Cost</label>
				<?php echo $this->Form->input(__('EstimateConsultantBilling.implant_service_charge'),array('class' => 'cost','id'=>'implantserviceCharge',
						'default'=>0,'readOnly'=>true,'style'=>'width:100px;'));?></td>
		</tr>
		<tr class="residentField">
			<td>Anaesthesist charge:<font color="red">*</font>
			</td>
			<td><?php echo $this->Form->input(__('EstimateConsultantBilling.anaesthesist_charge'),array('type'=>'text',
				'class'=>'cost validate[required,custom[mandatory-enter],custom[onlyNumber]]  textBoxExpnd','div'=>false,'id'=>'anaesthesist'));?>
				<label style="width: 79px !important; padding-top: 0px !important;"
				class="discount"> <?php echo $this->Form->input('EstimateConsultantBilling.discount.anaesthesist_discount_type',array('options'=>$discountOptions,'class'=>'getDiscount','id'=>'anaesthesistDiscountType'));?>
			</label> <?php echo $this->Form->input(__('EstimateConsultantBilling.discount.anaesthesist_discount'),array('type'=>'text',
						'class'=>'discount getDiscount validate[custom[onlyNumber]]','style'=>'width:100px;','div'=>false,'id'=>'anaesthesistDiscount')); ?>
			</td>
			<td class="discount"><?php echo $this->Form->input(__('EstimateConsultantBilling.discount.anaesthesist_discount_value'),array('type'=>'text',
					'class'=>'discountValue validate[custom[onlyNumber]]','div'=>false,'id'=>'anaesthesistDiscountValue'))?>
			</td>
		</tr>
		<tr class="residentField">
			<td>Cardiologist:<font color="red">*</font>
			</td>
			<td><?php echo $this->Form->input(__('EstimateConsultantBilling.cardiologist'),array('type'=>'text',
				'class'=>'cost validate[required,custom[mandatory-enter],custom[onlyNumber]]  textBoxExpnd','div'=>false,'id'=>'cardiologist'));?>
				<label style="width: 79px !important; padding-top: 0px !important;"
				class="discount"> <?php echo $this->Form->input('EstimateConsultantBilling.discount.cardiologist_discount_type',array('options'=>$discountOptions,'class'=>'getDiscount','id'=>'cardiologistDiscountType'));?>
			</label> <?php echo $this->Form->input(__('EstimateConsultantBilling.discount.cardiologist_discount'),array('type'=>'text',
						'class'=>'discount getDiscount validate[custom[onlyNumber]]','style'=>'width:100px;','div'=>false,'id'=>'cardiologistDiscount')); ?>
			</td>
			<td class="discount"><?php echo $this->Form->input(__('EstimateConsultantBilling.discount.cardiologist_discount_value'),array('type'=>'text',
					'class'=>'discountValue validate[custom[onlyNumber]]','div'=>false,'id'=>'cardiologistDiscountValue'))?>
			</td>
		</tr>
		<tr class="residentField">
			<td>Medicine:<font color="red">*</font>
			</td>
			<td><?php echo $this->Form->input(__('EstimateConsultantBilling.medicine'),array('type'=>'text',
				'class'=>'cost validate[required,custom[mandatory-enter],custom[onlyNumber]]  textBoxExpnd','div'=>false,'id'=>'medicine')); ?>
				<label style="width: 79px !important; padding-top: 0px !important;"
				class="discount"> <?php echo $this->Form->input('EstimateConsultantBilling.discount.medicine_discount_type',array('options'=>$discountOptions,'class'=>'getDiscount','id'=>'medicineDiscountType'));?>
			</label> <?php echo $this->Form->input(__('EstimateConsultantBilling.discount.medicine_discount'),array('type'=>'text',
						'class'=>'discount getDiscount validate[custom[onlyNumber]]','style'=>'width:100px;','div'=>false,'id'=>'medicineDiscount')); ?>
			</td>
			<td class="discount"><?php echo $this->Form->input(__('EstimateConsultantBilling.discount.medicine_discount_value'),array('type'=>'text',
					'class'=>'discountValue validate[custom[onlyNumber]]','div'=>false,'id'=>'medicineDiscountValue'))?>
			</td>
		</tr>
		<tr class="residentField">
			<td>Investigations:<font color="red">*</font>
			</td>
			<td><?php echo $this->Form->input(__('EstimateConsultantBilling.investigation'),array('type'=>'text',
				'class'=>'cost validate[required,custom[mandatory-enter],custom[onlyNumber]]  textBoxExpnd','div'=>false,'id'=>'investigation')); ?>
				<label style="width: 79px !important; padding-top: 0px !important;"
				class="discount"> <?php echo $this->Form->input('EstimateConsultantBilling.discount.investigation_discount_type',array('options'=>$discountOptions,'class'=>'getDiscount','id'=>'investigationDiscountType'));?>
			</label> <?php echo $this->Form->input(__('EstimateConsultantBilling.discount.investigation_discount'),array('type'=>'text',
						'class'=>'discount getDiscount validate[custom[onlyNumber]]','style'=>'width:100px;','div'=>false,'id'=>'investigationDiscount')); ?>
			</td>
			<td class="discount"><?php echo $this->Form->input(__('EstimateConsultantBilling.discount.investigation_discount_value'),array('type'=>'text',
					'class'=>'discountValue validate[custom[onlyNumber]] ','div'=>false,'id'=>'investigationDiscountValue'))?>
			</td>
		</tr>
		<tr class="residentField">
			<td>Hospital charges:<font color="red">*</font>
			</td>
			<td><?php echo $this->Form->input(__('EstimateConsultantBilling.misc_charge'),array('type'=>'text',
				'class'=>'cost validate[required,custom[mandatory-enter],custom[onlyNumber]]  textBoxExpnd','div'=>false,'id'=>'misc')); ?>
				<label style="width: 79px !important; padding-top: 0px !important;"
				class="discount"> <?php echo $this->Form->input('EstimateConsultantBilling.discount.misc_discount_type',array('options'=>$discountOptions,'class'=>'getDiscount','id'=>'miscDiscountType'));?>
			</label> <?php echo $this->Form->input(__('EstimateConsultantBilling.discount.misc_discount'),array('type'=>'text',
						'class'=>'discount getDiscount validate[custom[onlyNumber]]','style'=>'width:100px;','div'=>false,'id'=>'miscDiscount')); ?>
			</td>
			<td class="discount"><?php echo $this->Form->input(__('EstimateConsultantBilling.discount.misc_discount_value'),array('type'=>'text',
					'class'=>'discountValue validate[custom[onlyNumber]]','div'=>false,'id'=>'miscDiscountValue'))?>
			</td>
		</tr>
		
		<tr class="residentField">
			<td>Total amount:</td>
			<td><?php echo $this->Form->input(__('EstimateConsultantBilling.package_total_cost'),array('type'=>'text','div'=>false,'class' => 'textBoxExpnd','id'=>'totalAmount','readOnly'=>true)); ?>
				<label style="width: 79px !important; padding-top: 0px !important;"
				class="discount"> <?php echo $this->Form->input(__('EstimateConsultantBilling.discount.total_discount'),array('type'=>'text',
						'readOnly'=>true,'div'=>false,'id'=>'totalDiscount'))?>
			</label> <label style="float: right; padding-top: 0px;"
				class="discount">Final amount</label>
			</td>
			<td class="discount"><?php echo $this->Form->input(__('EstimateConsultantBilling.discount.total_discount_package'),array('type'=>'text',
					'class'=>'validate[custom[onlyNumber]]','div'=>false,'id'=>'totalDiscountPackage','readOnly'=>true))?>
			</td>
		</tr>
		<tr class="residentField">
			<td>Package price:</td>
			<td><?php echo $this->Form->input(__('EstimateConsultantBilling.total_amount'),array('type'=>'text','div'=>false,'class' => 'textBoxExpnd',
					'id'=>'packagePrice','readOnly'=>true)); ?>
			</td>
		</tr>
		<?php 
		foreach($this->data['EstimateConsultantBilling']['other_doctor_staff'] as $selectedStaff){
			if(array_key_exists($selectedStaff, $surgeonlist)){
				$value[$selectedStaff] = $surgeonlist[$selectedStaff];
				unset($surgeonlist[$selectedStaff]);
			}
		}$value = ($value) ? $value : array();
		?>
		<tr class="residentField">
			<td><?php echo __('Other doctors and staff:') ?><font color="red">*</font>
			</td>
			<td colspan="2"><?php
			echo $this->Form->input('to', array('multiple' => 'multiple','style'=>'width:26%; float:left;','options'=>$surgeonlist , 'id'=>'SelectRight')); ?>
				<label style="width: 36px !important; padding-top: 0px !important;"><input
					id="MoveRight" type="button" value=" >> " /> </label> <label
				style="width: 26px !important; padding-top: 0px !important;"><input
					id="MoveLeft" type="button" value=" << " /> </label> <?php 
					echo $this->Form->input('EstimateConsultantBilling.other_doctor_staff', array('multiple' => 'multiple','empty'=>'Please select',
								'class' => 'validate[required,custom[mandatory-select]] ','style'=>'width:26%;','options'=>$value,'id'=>'SelectLeft'));
					?></td>
		</tr>
		<?php $rowCount = count($this->data['EstimateConsultantBilling']['payment_instruction']);?>
		<?php for($i = 0; $i < $rowCount; $i++ ){?>
		<tr class="residentField" id="instructionAdd<?php echo $i;?>">
			<?php if($i== 0){?>
			<td><?php echo __('Instruction how payment is to be taken:');?><font
				color="red">*</font></td>
			<?php }else{?>
			<td>&nbsp;</td>
			<?php } ?>
			<td><span><?php echo $this->Form->input(__("EstimateConsultantBilling.payment_instruction.$i.date"),array('type'=>'text',
					'class'=>' validate[required,custom[mandatory-select]] date','div'=>false,'id'=>'paymentInstruction')); ?>
			</span> <span><?php echo $this->Form->input(__("EstimateConsultantBilling.payment_instruction.$i.amount"),array('type'=>'text',
					'div'=>false,'class'=>'validate[custom[onlyNumber]] brkUp','style'=>'width:100px','placeHolder'=>'Amount'));  ?>
			</span> <span><?php echo $this->Form->input(__("EstimateConsultantBilling.payment_instruction.$i.instruction"),array('type'=>'text',
					'div'=>false,'placeHolder'=>'Instruction','id'=>$i."instruction"));  ?>

					<?php if($i == 0){?> <?php echo $this->Html->image('icons/plus_6.png', array('title'=> __('Add', true),
						'alt'=> __('Add', true),'id'=>'addMore','style'=>'float:none;'));?>
					<?php }else{?> <?php echo $this->Html->image('icons/cross.png', array('title'=> __('Remove', true), 'alt'=> __('Remove', true),
							'id'=>$i,'class'=>'removeRow','style'=>'float:none;'));?> <?php }?>
			</span>
			</td>
		</tr>
		<?php } ?>
		<tr class="residentField" id="addMoreNextTr">
			<td>Other terms and conditions:</td>
			<td><?php echo $this->Form->input(__('EstimateConsultantBilling.remark'),array('type'=>'textArea','class'=>'textBoxExpnd','div'=>false,'id'=>'termsConditions')); ?>
			</td>
		</tr>
		<tr class="physicianField" style="display: none;">
			<td colspan="2"><?php echo $this->Html->link('Click to view package details','#',array('id'=>'showDetails'));?>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<?php if($this->params->query['type'] != 'view'){?>
		<?php	$colSpan = "colspan='2'"; 
	if($this->Session->read('role') != Configure::read('residentLabel') ){?>
		<tr>
			<?php if( $this->request->data['EstimateConsultantBilling']['send_for_approval'] || $this->params->query['admittedPatient']){?>
			<?php echo $this->Form->hidden('EstimateConsultantBilling.approved',array('id'=>'approved'));?>
			<?php echo $this->Form->hidden('EstimateConsultantBilling.admittedPatient',array('value'=>$this->params->query['admittedPatient']));?>
			<?php $approve = ($this->request->data['EstimateConsultantBilling']['approved']) ? 'Approved' : 'Approve';?>
			<td><?php echo $this->Html->link($approve,"javascript:void(0)",array('class'=>'blueBtn','div'=>false,'title'=>$approve,'id'=>'approveNote'));?>
			</td>
			<?php $colSpan = ''; 
		}?>
			<?php if(!$this->params->query['admittedPatient']){?>
			<td <?php echo $colSpan;?>><?php echo $this->Html->link('Send',"javascript:void(0)",array('class'=>'blueBtn','div'=>false,'title'=>'Save','id'=>'saveresident'));?>
			</td>
			<?php }?>
		</tr>
		<?php }else if($this->request->data['EstimateConsultantBilling']['approved']){?>
		<td colspan='2'><strong>Estimate approved</strong></td>
		<?php }else{?>
		<td colspan='2'><?php echo $this->Html->link('Send',"javascript:void(0)",array('class'=>'blueBtn','div'=>false,'title'=>'Save','id'=>'saveresident'));?>
		</td>
		<?php }?>
	</table>
	<?php echo $this->Form->end();?>
	<?php if($this->Session->read('role') == Configure::read('residentLabel') && ! $this->data['EstimateConsultantBilling']['approved']){?>
	<table>
		<tr>
			<td><strong>Available Packages</strong> (<?php echo $this->Html->link("Add new Package",array('controller'=>'Estimates','action'=>'packageMaster',"?action=add&estimateId=".$this->data['EstimateConsultantBilling']['id']),array('class'=>'setPackagea','id'=>$keya));?>)</td>
		</tr>
		<tr>
			<td><ul>
					<?php if(empty($availablePackages)){?>
					<li><span>No package available</span></li>
					<?php }else{?>
					<?php foreach($availablePackages as $key => $package){
						unset($availablePackages[$key]['PackageEstimate']['misc_breakup']);//this element contains serialize array not required here
						?>
					<li><span><?php echo $this->Html->link(__($package['PackageEstimate']['name']),'#',array('class'=>'setPackage','id'=>$key));?>
					</span>
					</li>
					<?php }
		}			 ?>
				</ul>
			</td>
		</tr>

	</table>
	<?php }?>
	<?php }?>
</div>
<script type="text/javascript">

jQuery(document).ready(function (){
	
	var globalSurgeonCharge = $('#surgeonFees').val();
	var globalAnaesCharge=$('#anaesthesist').val();
	var globalImplantCharge = $('#implant').val();
	var requestTotalDiscount = '<?php echo $this->data['EstimateConsultantBilling']['discount']['total_discount'] ; ?>';
	var requestTotalDiscount = requestTotalDiscount.concat('<?php echo $this->data['EstimateConsultantBilling']['discount']['direct_bill_surgeon'] ; ?>');
	var requestTotalDiscount = requestTotalDiscount.concat('<?php echo $this->data['EstimateConsultantBilling']['discount']['direct_bill_implant'] ; ?>');
	var requestTotalDiscount = requestTotalDiscount.concat('<?php echo $this->data['EstimateConsultantBilling']['discount']['direct_bill_anaesthetist'] ; ?>');
	if($.trim(requestTotalDiscount) != '')
		$('.discount').fadeToggle( "slow", "linear" );

<?php if($this->Session->read('role') == Configure::read('doctorLabel')){ ?>
	$(".residentField").hide();
	$(".physicianField").show();
<?php } ?>
getwardCost(); // call on ready

$('.discountValue ').attr('readOnly',true);
	$('#addMore').click(function () {
		$('#addMoreNextTr')
			.before($('<tr>').attr('id','instructionAdd'+parseInt(addCount+1))
				.append($('<td>').text(''))
 		 		.append($('<td>')
 		 			.append($('<span>')
 		 				.append($('<input>').attr({'class':'date validate[required,custom[mandatory-select]]','name':'data[EstimateConsultantBilling][payment_instruction]['+parseInt(addCount+1)+'][date]'})))
 		 		 	.append($('<span>')
 		 		 		.append($('<input>').attr({'name':'data[EstimateConsultantBilling][payment_instruction]['+parseInt(addCount+1)+'][amount]',
 	 		 		 		 'type':'text','placeHolder':'Amount','class':'brkUp validate[custom[onlyNumber]]'})))
 		 		 	.append($('<span>').attr('id','spanId'+parseInt(addCount+1))
 		 		 		.append($('<input>').attr({'name':'data[EstimateConsultantBilling][payment_instruction]['+parseInt(addCount+1)+'][instruction]',
 	 		 		 		 'type':'text','placeHolder':'Instruction'}))
 	 		 		 		.append('<?php echo $this->Html->image('icons/cross.png', array('title'=> __('Remove', true),
	   			 					'alt'=> __('Remove', true),'class'=>'removeRow','style'=>'float:none;'));?>'))
 		 		 	));
		$('#spanId'+parseInt(addCount+1)+' img').attr('id',parseInt(addCount+1));
		addCount++;	
		$(".date").datepicker({
			changeMonth : true,
			changeYear : true,
			yearRange : '1950',
			showOtherMonths: true,
			dateFormat:'<?php echo $this->General->GeneralDate();?>',
			showOn : 'both',
			buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly : true,
			buttonText: "Calendar",
			onSelect : function() {
				$(this).focus();
			}
		});
		
		$('.removeRow').click(function (){
			$("#instructionAdd" + $(this).attr('id')).remove();
				addCount--;
		});
	});
		$('.removeRow').click(function (){
			$("#instructionAdd" + $(this).attr('id')).remove();
		});
      $('#consultantId').change(function(){
          $('#sendMailTo').val($(this).val());
		});
	$('#saveresident, #approveNote').click(function (){
		var personId = $("#personId").val();
		$('#SelectLeft option').prop('selected', true);
		
		var validateMandatory = jQuery("#residentFrm").validationEngine('validate');
		validateMandatory = checkPackageBreakups(validateMandatory);
		if(validateMandatory){ 
			 $('#sendForApproval').val('1');
			 if($(this).attr('id') == 'approveNote')$('#approved').val('1');
			$.ajax({
				  type : "POST",
				  data: $('#residentFrm').serialize(),
				  url: "<?php echo $this->Html->url(array( "action" => "estimateConsultantBill", "admin" => false)); ?>"+'/'+personId,
				  context: document.body,
				  beforeSend:function(){
					  $("#busy-indicator").show();
					  },		  
				  success: function(data){ 	
					  $("#busy-indicator").hide();
					  if(parent.jQuery().fancybox)
                  		parent.jQuery.fancybox.close();
                     			
					  <?php if($this->request->query['appointmentId']){ ?>
					  window.location.href = '<?php echo $this->Html->url(array('controller'=>'Notes','action'=>'clinicalNote',$patientId,$appointmentId,$noteId,'?'=>array('arrived_time'=>$arrivedTime)));?>';
					  
					  <?php } else{?>
					  window.location.href = '<?php echo $this->Html->url(array('controller'=>'Estimates','action'=>'residentDashboard'));?>';
					<?php }?>
				}
			});
			return true;  
		}
	});
	
	function checkPackageBreakups(validateMandatory){
		$('.brkUp').removeClass('highlightInput');
		 $('#packagePrice').removeClass('highlightInput');
		
		var breakupAmout = 0;
		$('.brkUp').each(function(){
			breakupAmout += parseInt($(this).val());
		  });
		  var finalAmount = parseInt($('#packagePrice').val());
		  var totalPackgAmount = parseInt($('#packagePrice').val());
		  if( isNaN(totalPackgAmount) )return validateMandatory;
		  if($.isNumeric(finalAmount) && breakupAmout == finalAmount){
			  $('#0instruction').validationEngine('hide');
			  return validateMandatory;
			 }else if( $.isNumeric(finalAmount) ){
				 $('#packagePrice').addClass('highlightInput');
				 $('.brkUp').addClass('highlightInput');
				 $('#0instruction').validationEngine('showPrompt', 'Breakup and package price should be equal.', 'input', 'topRight', true);
				 
			} else if(breakupAmout == totalPackgAmount){
				$('#0instruction').validationEngine('hide');
				 return validateMandatory;
			 }else{
				  $('#packagePrice').addClass('highlightInput');
				 $('.brkUp').addClass('highlightInput');
				 $('#0instruction').validationEngine('showPrompt', 'Breakup and package price should be equal.', 'input', 'topRight', true);
			 }
		  return false;
	}
	$(".assignedDate").datepicker({
		changeMonth : true,
		changeYear : true,
		yearRange : '1950',
		dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
		showOn : 'both',
		buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly : true,
		buttonText: "Calendar",
		minDate: new Date(),	
		onSelect : function() {
			$(this).focus();
		},
		showOtherMonths: true,
	});
	$(".date").datepicker({
		changeMonth : true,
		changeYear : true,
		yearRange : '1950',
		dateFormat:'<?php echo $this->General->GeneralDate();?>',
		showOn : 'both',
		buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly : true,
		minDate: new Date(),	
		buttonText: "Calendar",
		onSelect : function() {
			$(this).focus();
		},
		showOtherMonths: true
	});
	$( "#patientname" ).autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "autocompleteForPatientNameAndDob",'true',"admin" => false,"plugin"=>false)); ?>",
		minLength: 1,
		select: function( event, ui ) {
			var name = ui.item.value;
			name = name.split(" - ");
			ui.item.value = name[0];
			$("#patientname").val(ui.item.value);
			$("#personId").val(ui.item.id);
		},
		messages: {
		  noResults: '',
		  results: function() {}
		}
	});
			
	
	
	$('#noOfDays, #wardId, #daysInIcu').on('keyup change',function (){
		getwardCost();
		$('#accomodationDiscount, #accomodationDiscountValue').val();
	});
	
	
	
	$('.cost').keyup(function(){
		var thisId = $(this).attr('id');
		//$('#'+thisId+'Discount, #'+thisId+'DiscountValue').val('');
		totalAmount = 0; 
		$('.cost').each(function(){
			totalAmount += parseInt($(this).val());
		  });
		$('#totalAmount').val('');
		if(!isNaN(totalAmount)){
			$('#totalAmount').val(totalAmount);
			CalculateDiscountOnChange(thisId+'Discount');
		}
	});

	$( "#implantCompany" ).on('keypress',function(){
		$('#implant').validationEngine('hide');
		var name = $('#implantName').val();
		var implantCondition = (name != '') ? "name="+name+"&ot_item_category_id=<?php echo $categoryIdForImplant['OtItemCategory']['id'];?>" : "ot_item_category_id=<?php echo $categoryIdForImplant['OtItemCategory']['id'];?>";
		$( this ).autocomplete({
			source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advanceMultipleAutocomplete","OtItem","manufacturer",'null','null','null')); ?>"+"/"+implantCondition+"/manufacturer",
			setPlaceHolder: false,
			select: function( event, ui ) {
				companyFromAutoComplete = true
			},
			messages: {
			  noResults: '',
			  results: function() {}
			}
		});
	});
	$( "#implantCompany, #implantName " ).focusout(function (){
		if(!companyFromAutoComplete)
			$( '#implantCompany, #implant, #implantDiscount, #otItemId' ).val(''); 
		if(!implantFromAutocomplete)
			$( '#implantName, #implant, #implantDiscount, #otItemId' ).val('');
		$('.cost').trigger('keyup');
		CalculateDiscountOnChange('implantDiscount');
	});
	
	$( "#implantName" ).on('keypress',function(){
		$('#implant').validationEngine('hide');
		var name = $('#implantCompany').val();
		var implantCondition = (name != '') ? "manufacturer="+name+"&ot_item_category_id=<?php echo $categoryIdForImplant['OtItemCategory']['id'];?>" : "ot_item_category_id=<?php echo $categoryIdForImplant['OtItemCategory']['id'];?>";
		$( this ).autocomplete({
			source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advanceMultipleAutocomplete","OtItem","id&name&pharmacy_item_id",'null','null','null')); ?>"+"/"+implantCondition,
			setPlaceHolder: false,
			select: function( event, ui ) {
				implantFromAutocomplete = true;
				$("#otItemId").val(ui.item.id);
				getPackageDetails(ui.item.id);
			},
			messages: {
			  noResults: '',
			  results: function() {}
			}
		});
	});
	getPackageDetails('<?php echo $this->data["PackageEstimate"]["ot_item_id"];?>');
	function getPackageDetails(otItemId){
		/* if(otItemId){
		$.ajax({
	          type: 'POST',
	          url: "<?php echo $this->Html->url(array("action" => "getPackageDetails","admin" => false)); ?>"+'/null/'+otItemId,
	          data: '',
	          dataType: 'html',
	          success: function(data){ 
	        	  data = jQuery.parseJSON(data);
	        	  if(data.implantRate === null || data.implantRate == '' )data.implantRate = 0;
	        	  $("#implant").val($.trim(data.implantRate));
	        	  $('.cost').trigger('keyup');
		      }
			});
		}*/
	}
	

	$( "#surgeryName" ).autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advanceMultipleAutocomplete","Surgery","id&name&surgery_info_file_name",'null','null','1')); ?>",
		setPlaceHolder: false,
		select: function( event, ui ) {
			$("#surgeryId").val(ui.item.id);
			$('#ppt').hide();
			if( ui.item.surgery_info_file_name !== null){
				$('#ppt').show();
				$('#showPPT').attr('href',PPTURL+'/'+ui.item.surgery_info_file_name);
			}
		},
		messages: {
		  noResults: '',
		  results: function() {}
		}
	});
	$( "#surgeryName" ).focusout(function (){
		if($("#surgeryId").val() == '')
			$(this).val('');
	});
	
	$('.setPackage').click(function (){
		var values = packageValues[$(this).attr('id')].PackageEstimate;
		$('#directBillSurgeon, #directBillImplant, #directBillAnaesthetist').prop('checked', false);
		$("input.getDiscount:text, input.discountValue:text, #totalDiscount, #totalDiscountPackage").val("");
		
		setPackageValues(values);
	});


    $("#MoveRight,#MoveLeft").click(function(event) {
    	
        var id = $(event.target).attr("id");//MoveRight
        var selectFrom = (id == "MoveRight") ? "#SelectRight" : "#SelectLeft";//#selectLeft
        var moveTo = (id == "MoveRight") ? "#SelectLeft" : "#SelectRight";//#selectRight
        var selectedItems = $(selectFrom + " :selected").toArray();//empty
    	$(moveTo).append(selectedItems);
        selectedItems.remove;
    });
    
	$('.getDiscount').on('keyup change',function () {
		var thisElementID = $(this).attr('id');
		var thisID = $(this).attr('id');
		thisID = thisID.replace("Type", "");
		thisID = thisID.replace("Value", "");
		var type = $('#'+thisID+'Type option:selected').val();
		var costOfService = parseInt($($('#'+thisElementID).prev()).prev().val());
		var discountValue = parseInt($('#'+thisElementID).val()) ;
		if( type == 'inPercent' ){
			var discountAmount = (costOfService*discountValue)/100;
			var discountAmount = costOfService - discountAmount;
		}else{ 
			var discountAmount = costOfService - discountValue ;
		}
		if($.isNumeric(discountAmount))
			$('#'+thisID+'Value').val(discountAmount);
		else 
			$('#'+thisID+'Value').val('');
		if(thisID+'Type' ==  thisElementID)
			$('#'+thisID+'Value, #'+thisID ).val('');
		getDiscount();
	});

	

	$('#showDiscountFields').click(function (){
		var display = $('.discount').css('display');
		if(display == 'none')
		$(".residentField").show();
		$('.discount').fadeToggle( "slow", "linear" );
	});

	$("#showDetails").click(function(){
		$(".residentField").toggle('slow');
	});

	$("#implant").keypress(function(){
				
	 	if($('#otItemId').val() == ''){
	 		
	 		$('#implant').validationEngine('showPrompt', 'Please select implant ');
	 		$('#implant').val('0');
	 		return false;	
	 	
		 	}
		
	 	
		var implantFees =$('#implant').val();
		globalImplantCharge=implantFees;
		$("#directBillImplant").prop('checked',false);
	});
	$("#directBillImplant").click(function(){
		if($('#directBillImplant').is(':checked')){
			globalImplantCharge = $('#implant').val();
			$('#implant').val('0');
			$(' #implantDiscount, #implantDiscountValue').val('');
			$('.cost').trigger('keyup');
			var thisID = 'implantDiscount';
			CalculateDiscountOnChange(thisID);
			
		}else{
			$('#implant').val(globalImplantCharge);
			$('.cost').trigger('keyup');
			//getPackageDetails($('#otItemId').val());
		}
	});

	$("#anaesthesist").keypress(function(){
		var anaes_fees =$('#anaesthesist').val();
		globalAnaesCharge=anaes_fees;
		$("#directBillAnaesthetist").prop('checked',false);
	});

	$("#directBillAnaesthetist").click(function(){
		if($('#directBillAnaesthetist').is(':checked')){
			globalAnaesCharge=$('#anaesthesist').val();
			$('#anaesthesist').val('0');
			$(' #anaesthesistDiscount, #anaesthesistDiscountValue').val('');
			$('.cost').trigger('keyup');
			var thisID = 'anaesthesistDiscount';
			CalculateDiscountOnChange(thisID);
			
		}else{
			$('#anaesthesist').val(globalAnaesCharge);
			$('.cost').trigger('keyup');
		}
	});
	
	$("#surgeonFees").keypress(function(){
	  var Sur_fees =$('#surgeonFees').val();
	   globalSurgeonCharge = Sur_fees;
	   $("#directBillSurgeon").prop('checked',false);
	});
	
	$("#directBillSurgeon").click(function(){
		if($('#directBillSurgeon').is(':checked')){
			globalSurgeonCharge = $('#surgeonFees').val();	
			$('#surgeonFees').val('0');
			$(' #surgeonFeesDiscount, #surgeonFeesDiscountValue').val('');
			$('.cost').trigger('keyup');
			var thisID = 'surgeonFeesDiscount';
			CalculateDiscountOnChange(thisID);
		}else{
			$('#surgeonFees').val(globalSurgeonCharge);
			$('.cost').trigger('keyup');
		}
	});
	function CalculateDiscountOnChange(thisID){
		var thisElementID = thisID;
		thisID = thisID.replace("Type", "");
		thisID = thisID.replace("Value", "");
		var type = $('#'+thisID+'Type option:selected').val();
		var costOfService = parseInt($($('#'+thisElementID).prev()).prev().val());
		var discountValue = parseInt($('#'+thisElementID).val()) ;
		if( type == 'inPercent' ){
			var discountAmount = (costOfService*discountValue)/100;
			var discountAmount = costOfService - discountAmount;
		}else{ 
			var discountAmount = costOfService - discountValue ;
		}
		if($.isNumeric(discountAmount))
			$('#'+thisID+'Value').val(discountAmount);
		else 
			$('#'+thisID+'Value').val('');
		if(thisID+'Type' ==  $('#'+thisElementID).attr('id'))
			$('#'+thisID+'Value, #'+thisID ).val('');
		getDiscount();
	}

	$('#implantService').change(function(){
		var thisVal = $(this).val();
		//if(thisVal == '') return false;
		var key = (thisVal == '0') ? 'i_assist' : 'psi' ;
		var wardId = $('#wardId').val();
		if($.isNumeric(wardService[wardId][key]))
			$('#implantserviceCharge').val(wardService[wardId][key]);
		else
			$('#implantserviceCharge').val(0);
		$('.cost').trigger('keyup');
	});
	$( "#packageName" ).keypress(function (){
		if(instance == 'kanpur')
			var autocompleteUrl = "<?php echo $this->Html->url(array("controller" => "app", "action" => "advanceMultipleAutocomplete","PackageEstimate","name*",'null','null','no',"admin" => false,"plugin"=>false)); ?>"+"/location_id="+selectedLocation+"&surgery_id="+$('#surgeryId').val();
		else
			var autocompleteUrl = "<?php echo $this->Html->url(array("controller" => "app", "action" => "advanceMultipleAutocomplete","PackageEstimate","name*",'null','null','no',"admin" => false,"plugin"=>false)); ?>"+"/location_id="+selectedLocation;//+"&surgery_id="+$('#surgeryId').val(),
		$( this ).autocomplete({
			source: autocompleteUrl+"&tariff_standard_id=7",
			minLength: 1,
			select: function( event, ui ) {
				$("input.getDiscount:text, input.discountValue:text, #totalDiscount, #totalDiscountPackage").val("");
				setPackageValues(ui.item);
			},
			messages: {
			  noResults: '',
			  results: function() {}
			}
		});
		});
	
	$('#wardId').change(function (){
		var wardId = $(this).val();
		if(wardId !== undefined){
			$('#implantService').empty().append(new Option( 'Please select' , '') );
			if(wardService[wardId]['i_assist'] !== null)
				$("#implantService").append( new Option('i-Assist' , '0') );
			if(wardService[wardId]['psi'])
				$("#implantService").append( new Option('PSI' , '1') );
			$('#implantserviceCharge').val(0);
			$.ajax({
		        type: 'GET',
		        url: "<?php echo $this->Html->url(array("action" => "getPackagePrice","admin" => false)); ?>",
		        data: 'ward_id='+wardId+'&surgery_id='+$('#surgeryId').val(),
		        dataType: 'html',
		        beforeSend: function() {
		            $("#busy-indicator").show()
		        },
		        complete : function () {
		        	$("#busy-indicator").hide();
		        },
		        success: function(data){ 
		        	$('#showDiscountFields').trigger('click');
		        	$('.discount').fadeIn( "slow", "linear" );
		      		data = jQuery.parseJSON(data);
		      		$('#miscDiscountType').val(data.PackageEstimate.miscDiscountType);
		      		$('#miscDiscount').val(data.PackageEstimate.miscDiscount);
		      		var discountAmount = parseInt($('#misc').val()) - parseInt(data.PackageEstimate.miscDiscount) ;
		      		if($.isNumeric(discountAmount))
		      			$('#miscDiscountValue').val(discountAmount);
		      		getDiscount();
		      	}
			});
		}
   	});
});
function setPackageValues(array){
	var surgeryId = array.surgery_id;
	var otItemId = array.ot_item_id; 
	$.ajax({
        type: 'POST',
        url: "<?php echo $this->Html->url(array("action" => "getPackageDetails","admin" => false)); ?>"+'/'+surgeryId+'/'+otItemId,
        data: '',
        dataType: 'html',
        beforeSend: function() {
            $("#busy-indicator").show()
        },
        success: function(data){ 
      	  data = jQuery.parseJSON(data);
      	$("#packageName").val(array.name);
      	  	$("#packageId").val(array.id);
	      		$("#surgeryId").val(array.surgery_id);
	      		if(data.surgeryFileName !== null){
		      		$('#ppt').show();
					$('#showPPT').attr('href',PPTURL+'/'+data.surgeryFileName);
	      		}
	      		$("#surgeonFees").val(array.surgeon_fees);
	      		$("#surgeryName").val($.trim(data.surgery));
	      		//$("#amount").val(array.amount);
	      		$("#wardId").val(array.ward_id).trigger('change');
	      		$("#noOfDays").val(array.no_of_days);
	      		$('#daysInIcu').val(array.days_in_icu);
	      		getwardCost();
	      		$("#implantName").val($.trim(data.implant.name));
	      		$("#implantCompany").val($.trim(data.implant.manufacturer));
	      		$("#implant").val($.trim(array.implant_charge));
	      		$("#otItemId").val($.trim(array.ot_item_id));
	      		$("#anaesthesist").val(array.anaesthesist_charge);
	      		$("#cardiologist").val(array.cardiologist);
	      		$("#medicine").val(array.medicine);
	      		$("#investigation").val(array.investigation);
	      		$("#misc").val(array.misc_charge);
	      		$('#totalAmount').val(array.total_amount);
	      		$('#packagePrice').val(array.package_price);
	      		$('#directBillSurgeon, #directBillImplant, #directBillAnaesthetist').prop('checked', false);
	      		$("#busy-indicator").hide();
	        }
	});
}
function getwardCost(){
	if(wardCost !== null){
		if(isNaN(wardCost[$('#icuId').val()]))
			var icuCost = 0;
		else
			var icuCost = parseInt(wardCost[$('#icuId').val()]) * parseInt($('#daysInIcu').val());
		var totalDays = parseInt($('#noOfDays').val());
		var costPerDay = parseInt(wardCost[$("#wardId").val()]);
		var costOfAccomodation = (totalDays * costPerDay) + icuCost;
	}
	$('#accomodation').val('');
	if(!isNaN(costOfAccomodation))
	$('#accomodation').val(costOfAccomodation);
	$('.cost').trigger('keyup');
}
	
	

   	function getLocationConsultant (){
   	   	if($('#locationId').val() != ''){
   	   	   selectedLocation = $('#locationId').val();
   	   	$.ajax({
	        type: 'POST',
	        url: "<?php echo $this->Html->url(array("action" => "getLocationConsultant","admin" => false)); ?>"+'/'+$('#locationId').val(),
	        data: '',
	        dataType: 'html',
	        beforeSend: function() {
	            $("#busy-indicator").show()
	        },
	        success: function(data){ 
	      		data = jQuery.parseJSON(data);
	      		$('#consultantId').empty().append(new Option( 'Please select' , '') );
	      		$.each(data.consultant, function(key , value){
	      			$("#consultantId").append( new Option(value , key) );
	    		 });
	    		 $('#SelectRight').empty();
	      		$.each(data.surgeonAndNurse, function(key , value){
	      			$("#SelectRight").append( new Option(value , key) );
	    		 });
	      		$("#busy-indicator").hide();
	      		if(instance == 'kanpur')
	    			var autocompleteUrl = "<?php echo $this->Html->url(array("controller" => "app", "action" => "advanceMultipleAutocomplete","PackageEstimate","name*",'null','null','no',"admin" => false,"plugin"=>false)); ?>"+"/location_id="+selectedLocation+"&surgery_id="+$('#surgeryId').val();
	    		else
	    			var autocompleteUrl = "<?php echo $this->Html->url(array("controller" => "app", "action" => "advanceMultipleAutocomplete","PackageEstimate","name*",'null','null','no',"admin" => false,"plugin"=>false)); ?>"+"/location_id="+selectedLocation;//+"&surgery_id="+$('#surgeryId').val(),
	      		$( "#packageName" ).autocomplete({
	      			source: autocompleteUrl,
	      			minLength: 1,
	      			select: function( event, ui ) {
	      				$("input.getDiscount:text, input.discountValue:text, #totalDiscount, #totalDiscountPackage").val("");
	      				setPackageValues(ui.item);
	      			},
	      			messages: {
	      			  noResults: '',
	      			  results: function() {}
	      			}
	      		});
		    }
	
		});
   	   	}
   	   }
var instance = '<?php echo strtolower($this->Session->read('website.instance'));?>';
var wardCost = jQuery.parseJSON('<?php echo $wardCost;?>');
var wardService = jQuery.parseJSON('<?php echo json_encode($wardService);?>');
var packageValues  = jQuery.parseJSON('<?php echo json_encode($availablePackages);?>');
var PPTURL = '<?php echo FULL_BASE_URL.Router::url('/')."uploads/surgeries_files";?>';
var companyFromAutoComplete = implantFromAutocomplete = false;
var addCount = ('<?php echo $rowCount;?>' == 0) ? 0 : parseInt('<?php echo $rowCount-1;?>');
var globalTriggerId = '';
var globalSurgeonCharge = '';
var globalAnaesCharge='';
var globalImplantCharge = '';
var selectedLocation = '<?php echo $this->data['EstimateConsultantBilling']['location_id']?>';
function getDiscount(){
	totalAmount = 0; 
	$('.discountValue').each(function(){
		var thisID = $(this).attr('id');
		thisID = thisID.replace("Value", "");
		var type = $('#'+thisID+'Type option:selected').val();
		//alert(thisID);
		if( type == 'inPercent' ){
			if($.isNumeric(parseInt($(this).val()))){
				var totalValueId = thisID.replace("Discount", "");
				var totalValueAmount = parseInt($('#'+totalValueId).val());
				var discountValue = parseInt($(this).val());
				var discountAmount = totalValueAmount - discountValue;
				totalAmount += discountAmount ;
			}
		}else{
			if($.isNumeric(parseInt($('#'+thisID).val())))
				totalAmount += parseInt($('#'+thisID).val());
		}
	  });
	$('#totalDiscount, #totalDiscountPackage').val('');
	//alert(totalAmount);
	if($.isNumeric(totalAmount)){
		if(totalAmount == 0) $('#totalDiscount').val(""); else $('#totalDiscount').val(totalAmount);
		var discountedAmount = parseInt($('#totalAmount').val()) - totalAmount;
		if($.isNumeric(discountedAmount) && totalAmount != 0)
			$('#totalDiscountPackage, #packagePrice').val(discountedAmount);
		else if(totalAmount == 0){
			$('#totalDiscountPackage').val('');
			$('#packagePrice').val($('#totalAmount').val());
		}
	}
}
</script>
