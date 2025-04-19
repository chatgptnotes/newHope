<style>
.cost,.getDiscount,#totalAmount,#miscCharge,#packagePrice {
	text-align: right;
}
.discountLabel{
	padding-left: 35px;
	width: 40px !important;
	padding-top: 0px !important;
}
.getDiscount{
	width : 115px;
	float : right;
}
.miscBorderleft1 {
	border: thin ridge black;
	border-bottom-style: none;
	border-top-style: none;
	border-left-style: none;
}

.miscBorderRight1 {
	border: thin ridge black;
	border-bottom-style: none;
	border-top-style: none;
	border-right-style: none;
}

.miscBorderTop {
	border: thin ridge black;
	border-bottom-style: none;
}

.miscBorderBottom {
	border: thin ridge black;
	border-top-style: none;
}
</style>
<div id="doctemp_content">
	<div class="inner_title">
		<h3>
			<?php echo __($title_for_layout, true); ?>
		</h3>
		<span> <?php
		echo $this->Html->link(__('Add', true),"javascript:void(0);", array('escape' => false,'class'=>'blueBtn','id'=>'add-note'));
		if(!empty($this->params->query['estimateId']))
			echo $this->Html->link(__('Back', true),array('controller' => 'Estimates', 'action' => 'packageEstimate',$this->params->query['estimateId']), array('escape' => false,'class'=>'blueBtn'));
		else 
			echo $this->Html->link(__('Back', true),array('controller' => 'Tariffs', 'action' => 'viewTariffAmount', '?' => array('fromPackage'=>1),'admin'=>false), array('escape' => false,'class'=>'blueBtn'));
		?>
		</span>
	</div>
	<?php echo $this->Form->create('packageMastr',array('url'=>array('controller'=>'Estimates','action'=>'packageMaster',$tariffStandardId,'?'=>array($this->params->query)),'id'=>'packageMasterfrm', 'inputDefaults' => array('label' => false,'div' => false,'autocomplete'=>'off')));
	echo $this->Form->hidden('PackageEstimate.id',array('id'=>'note-id'));
	echo $this->Form->hidden('PackageEstimate.tariff_standard_id',array('value'=>$tariffStandardId,'id'=>'tariffStandardId'));
	if($action=='edit'){
		$display  = '' ; $displayList = 'none';
	}else $display = 'none';
	?>
	<div align="center" id="busy-indicator" style="display: none;">
		<?php echo $this->Html->image('indicator.gif'); ?>
	</div>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="40%" align="right" style="display:<?php echo $display; ?>;" id="note-add-form">
		<tr>
			<td><label style="width: 99px;"><?php echo __('Package name');?>:<font
					color="red">*</font> </label>
			</td>
			<td><?php echo $this->Form->input('PackageEstimate.name', array('style'=>'width:157px;','type'=>'text','class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd','id' => 'customdescription')); ?>
			</td>
		</tr>
		<tr>
			<td><label style="width: 99px;"><?php echo __('Category');?>:<font
					color="red">*</font> </label>
			</td>
			<td><?php echo $this->Form->input('PackageEstimate.surgery_category_id', array('style'=>'width:157px;','empty'=>'Please select','options'=>$surgeryCategories,'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'surgeryCategoryId')); ?>
			</td>
		</tr>
		<?php /*?>
		<tr>
			<td><label style="width: 99px;"><?php echo __('Surgery subcategory');?>:<font
					color="red">*</font> </label>
			</td>
			<td><?php echo $this->Form->input('PackageEstimate.surgery_subcategory_id', array('style'=>'width:157px;','empty'=>'Please select','options'=>$subCategory,'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'surgerySubCategoryId')); ?>
			</td>
		</tr>
		<?php */ ?>
		<tr>
			<td><label style="width: 99px;"><?php echo __('Procedure');?>:<font
					color="red">*</font> </label>
			</td>
			<td><?php echo $this->Form->input('PackageEstimate.surgery_id', array('style'=>'width:157px;','empty'=>'Please select','options'=>$surgery,'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'surgeryId')); ?>
			</td>
		</tr>
		<tr>
			<td><label style="width: 99px;"><?php echo __('Surgeon fees');?>:<font
					color="red">*</font> </label>
			</td>
			<td><?php echo $this->Form->input('PackageEstimate.surgeon_fees', array('style'=>'width:157px;','type'=>'text',
					'class' => 'cost validate[required,custom[onlyNumber,mandatory-enter]] textBoxExpnd','id' => 'surgeonFees')); ?>
			</td>
		</tr>
		<?php if(!empty($icuWardId))
		{
		?>
		<tr>
			<td><label style="width: 99px;"><?php echo __('Accomodation in ICU');?>:<font
					color="red">*</font> </label>
			</td>
			<td><?php 	
			echo $this->Form->hidden('icuId',array('id'=>'icuId','value'=>$icuWardId));
			echo $this->Form->input(__('PackageEstimate.days_in_icu'),array('type'=>'text','style'=>'width:157px;','div'=>false,
					'class' => 'validate[required,custom[onlyNumber,mandatory-enter]] textBoxExpnd','id'=>'daysInIcu')); ?>
			</td>
		</tr>
		<?php }?>
		<tr>
			<td><label style="width: 99px;"><?php echo __('Accomodation');?>:<font
					color="red">*</font> </label>
			</td>
			<?php unset($ward[$icuWardId]);?>
			<td><?php echo $this->Form->input(__('PackageEstimate.ward_id'),array('empty'=>'Please select','options'=>$ward,'id'=>'wardId',
					'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','style'=>'width:157px;','div'=>false)); ?>
				<label style="width: 79px !important; padding-top: 7px !important;">No.
					of days:</label> <?php echo $this->Form->input(__('PackageEstimate.no_of_days'),array('type'=>'text','id'=>'totalDays',
							'style'=>'width:75px;','div'=>false,'class' => 'validate[required,custom[onlyNumber,mandatory-enter]] textBoxExpnd')); ?>
			</td>
		</tr>
		<tr>
			<td><label style="width: 99px;"><?php echo __('Accomodation charge');?>:<font
					color="red">*</font> </label>
			</td>
			<td><?php echo $this->Form->input(__('PackageEstimate.accomodation_charge'),array('type'=>'text','style'=>'width:157px;','div'=>false,
					'class' => 'cost validate[required,custom[onlyNumber,mandatory-enter]] textBoxExpnd','id'=>'accomodationCharge')); ?>
			</td>
		</tr>
		<tr>
			<td><label style="width: 99px;"><?php echo __('Implant');?>:<!-- <font
					color="red">*</font> --> </label>
			</td>
			<td><?php echo $this->Form->input(__('OtItem.manufacturer'),array('type'=>'text','style'=>'width:157px;','div'=>false,
					'placeHolder'=>'Company name','class' => 'textBoxExpnd','id'=>'implantCompany')); ?>
				<label style="width: 40px !important; padding-top: 7px !important;">Name:</label>
				<?php echo $this->Form->input(__('OtItem.name'),array('type'=>'text','style'=>'width:115px;','div'=>false,'placeHolder'=>'Implant name',
						'class' => 'textBoxExpnd','id'=>'implantName'));
						echo $this->Form->hidden('PackageEstimate.ot_item_id',array('id'=>'otItemId'));?>
			</td>
		</tr>
		<tr>
			<td><label style="width: 99px;"><?php echo __('Implant charge');?>: <!-- <font
					color="red">*</font> --> </label>
			</td>
			<td><?php echo $this->Form->input(__('PackageEstimate.implant_charge'),array('default'=>0,'type'=>'text','style'=>'width:157px;','div'=>false,
					'class' => 'cost textBoxExpnd','id'=>'implantCharge')); ?>
			</td>
		</tr>
		<?php /* ?>
			<tr>
			<td><label style="width: 99px;"><?php echo __('Sub Implant');?>:<font
			color="red">*</font> </label>
			</td>
			<td><?php
			$serviceArray[''] = 'Please select';
			if($wardService[$this->data['PackageEstimate']['ward_id']]['i_assist'])$serviceArray['0'] = 'i-Assist';
			if($wardService[$this->data['PackageEstimate']['ward_id']]['psi'])$serviceArray['1'] = 'PSI';
			echo $this->Form->input(__('PackageEstimate.implant_service'),array('class' => 'textBoxExpnd','id'=>'implantService',
					'style'=>'text-align: left; width:157px;','div'=>false,'options'=>$serviceArray)); ?>
			<?php echo $this->Form->hidden(__('PackageEstimate.implant_service_charge'),array('class' => 'cost','id'=>'implantserviceCharge','default'=>0));?>
			</td>
			</tr>
		<?php */?>
		<tr>
			<td><label style="width: 99px;"><?php echo __('Anaesthesist charge');?>:<font
					color="red">*</font> </label>
			</td>
			<td><?php echo $this->Form->input(__('PackageEstimate.anaesthesist_charge'),array('type'=>'text','class' => 'cost validate[required,custom[onlyNumber,mandatory-enter]] textBoxExpnd','style'=>'width:157px;','div'=>false))?>
			</td>
		</tr>
		<tr>
			<td><label style="width: 99px;"><?php echo __('Cardiologist');?>:<font
					color="red">*</font> </label>
			</td>
			<td><?php echo $this->Form->input(__('PackageEstimate.cardiologist'),array('type'=>'text','class' => 'cost validate[required,custom[onlyNumber,mandatory-enter]] textBoxExpnd','style'=>'width:157px;','div'=>false))?>
			</td>
		</tr>
		<tr>
			<td><label style="width: 99px;"><?php echo __('Medicine');?>:<font
					color="red">*</font> </label>
			</td>
			<td><?php echo $this->Form->input(__('PackageEstimate.medicine'),array('type'=>'text','class' => 'cost validate[required,custom[onlyNumber,mandatory-enter]] textBoxExpnd','style'=>'width:157px;','div'=>false))?>
			</td>
		</tr>
		<tr>
			<td><label style="width: 99px;"><?php echo __('Investigations');?>:<font
					color="red">*</font> </label>
			</td>
			<td><?php echo $this->Form->input(__('PackageEstimate.investigation'),array('type'=>'text','class' => 'cost validate[required,custom[onlyNumber,mandatory-enter]] textBoxExpnd','style'=>'width:157px;','div'=>false))?>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="miscBorderTop"><font><i><?php echo __('Hospital charges :-');?>
				</i> </font><?php $discountOptions = array('inPercent'=>'%','inAmount'=>'amt');?>
			</td>
		</tr>
		<tr>
			<td class="miscBorderleft"><label style="width: 101px;"><?php echo __('Asst. surgeon I');?>:<font
					color="red">*</font>
			
			</td>
			<td class="miscBorderRight"><?php echo $this->Form->input(__('PackageEstimate.misc_breakup.assistant_surgeon_one'),array('type'=>'text','style'=>'width:157px;','div'=>false,
					'class' => 'cost miscCost validate[required,custom[onlyNumber,mandatory-enter]] textBoxExpnd','default'=>0,'id'=>'assistantSurgeonOneDiscountValue')); ?>
					
					<label class="discountLabel">
					<?php echo $this->Form->input('PackageEstimate.misc_breakup.assistant_surgeon_one_discount_type',array('options'=>$discountOptions,
							'class'=>'discountType','id'=>'assistantSurgeonOneDiscountType'));?></label>
				
				<?php echo $this->Form->input(__('PackageEstimate.misc_breakup.assistant_surgeon_one_discount'),array('type'=>'text',
						'div'=>false,'default'=>'0','class' => 'getDiscount validate[required,custom[mandatory-enter]] textBoxExpnd','id'=>'assistantSurgeonOneDiscount')); ?>
			</td>
		</tr>
		<tr>
			<td class="miscBorderleft"><label style="width: 101px;"><?php echo __('Asst. surgeon II');?>:<font
					color="red">*</font>
			
			</td>
			<td class="miscBorderRight"><?php echo $this->Form->input(__('PackageEstimate.misc_breakup.assistant_surgeon_two'),array('type'=>'text','style'=>'width:157px;','div'=>false,
					'class' => 'cost miscCost validate[required,custom[onlyNumber,mandatory-enter]] textBoxExpnd','default'=>0,'id'=>'assistantSurgeonTwoDiscountValue'))?>
					<label class="discountLabel">
					<?php echo $this->Form->input('PackageEstimate.misc_breakup.assistant_surgeon_two_discount_type',array('options'=>$discountOptions,
							'class'=>'discountType','id'=>'assistantSurgeonTwoDiscountType'));?></label>
				
				<?php echo $this->Form->input(__('PackageEstimate.misc_breakup.assistant_surgeon_two_discount'),array('type'=>'text',
						'div'=>false,'default'=>'0','class' => 'getDiscount validate[required,custom[mandatory-enter]] textBoxExpnd','id'=>'assistantSurgeonTwoDiscount')); ?>
			</td>
		</tr>
		<tr>
			<td class="miscBorderleft"><label style="width: 99px;"><?php echo __('OT Asst.');?>:<font
					color="red">*</font>
			
			</td>
			<td class="miscBorderRight"><?php echo $this->Form->input(__('PackageEstimate.misc_breakup.ot_assistant'),array('type'=>'text','style'=>'width:157px;','div'=>false,
					'class' => 'cost miscCost validate[required,custom[onlyNumber,mandatory-enter]] textBoxExpnd','default'=>0,'id'=>'otAssistantDiscountValue'))?>
					<label class="discountLabel">
					<?php echo $this->Form->input('PackageEstimate.misc_breakup.ot_assistant_discount_type',array('options'=>$discountOptions,
							'class'=>'discountType','id'=>'otAssistantDiscountType'));?></label>
				
				<?php echo $this->Form->input(__('PackageEstimate.misc_breakup.ot_assistant_discount'),array('type'=>'text',
						'div'=>false,'default'=>'0','class' => 'getDiscount validate[required,custom[mandatory-enter]] textBoxExpnd','id'=>'otAssistantDiscount')); ?>
			</td>
		</tr>
		<tr>
			<td class="miscBorderLeft"><label style="width: 99px;"><?php echo __('OT charge');?>:<font
					color="red">*</font>
			
			</td>
			<td class="miscBorderRight"><?php echo $this->Form->input(__('PackageEstimate.misc_breakup.ot_charge'),array('type'=>'text','style'=>'width:157px;','div'=>false,
					'class' => 'cost miscCost validate[required,custom[onlyNumber,mandatory-enter]] textBoxExpnd','default'=>0,'id'=>'otChargeDiscountValue'))?>
					<label class="discountLabel">
					<?php echo $this->Form->input('PackageEstimate.misc_breakup.ot_charge_discount_type',array('options'=>$discountOptions,
							'class'=>'discountType','id'=>'otChargeDiscountType'));?></label>
				
				<?php echo $this->Form->input(__('PackageEstimate.misc_breakup.ot_charge_discount'),array('type'=>'text',
						'div'=>false,'default'=>'0','class' => 'getDiscount validate[required,custom[mandatory-enter]] textBoxExpnd','id'=>'otChargeDiscount')); ?>
			</td>
		</tr>
		<tr>
			<td class="miscBorderLeft"><label style="width: 99px;"><?php echo __('Inst. charge');?>:<font
					color="red">*</font>
			
			</td>
			<td class="miscBorderRight"><?php echo $this->Form->input(__('PackageEstimate.misc_breakup.instrument_charge'),array('type'=>'text','style'=>'width:157px;','div'=>false,
					'class' => 'cost miscCost validate[required,custom[onlyNumber,mandatory-enter]] textBoxExpnd','default'=>0,'id'=>'instrumentChargeDiscountValue'))?>
					<label class="discountLabel">
					<?php echo $this->Form->input('PackageEstimate.misc_breakup.instrument_charge_discount_type',array('options'=>$discountOptions,
							'class'=>'discountType','id'=>'instrumentChargeDiscountType'));?></label>
				
				<?php echo $this->Form->input(__('PackageEstimate.misc_breakup.instrument_charge_discount'),array('type'=>'text',
						'div'=>false,'default'=>'0','class' => 'getDiscount validate[required,custom[mandatory-enter]] textBoxExpnd','id'=>'instrumentChargeDiscount')); ?>
			</td>
		</tr>
		<tr>
			<td class="miscBorderLeft"><label style="width: 99px;"><?php echo __('Physio. charge');?>:<font
					color="red">*</font>
			
			</td>
			<td class="miscBorderRight"><?php echo $this->Form->input(__('PackageEstimate.misc_breakup.physio_charge'),array('type'=>'text','style'=>'width:157px;','div'=>false,
					'class' => 'cost miscCost validate[required,custom[onlyNumber,mandatory-enter]] textBoxExpnd','default'=>0,'id'=>'physioChargeDiscountValue'))?>
					<label class="discountLabel">
					<?php echo $this->Form->input('PackageEstimate.misc_breakup.physio_charge_discount_type',array('options'=>$discountOptions,
							'class'=>'discountType','id'=>'physioChargeDiscountType'));?></label>
				
				<?php echo $this->Form->input(__('PackageEstimate.misc_breakup.physio_charge_discount'),array('type'=>'text',
						'div'=>false,'default'=>'0','class' => 'getDiscount validate[required,custom[mandatory-enter]] textBoxExpnd','id'=>'physioChargeDiscount')); ?>
			</td>
		</tr>
		<tr>
			<td class="miscBorderLeft"><label style="width: 99px;"><?php echo __('Dress. charge');?>:<font
					color="red">*</font>
			
			</td>
			<td class="miscBorderRight"><?php echo $this->Form->input(__('PackageEstimate.misc_breakup.dressing_charge'),array('type'=>'text','style'=>'width:157px;','div'=>false,
					'class' => 'cost miscCost validate[required,custom[onlyNumber,mandatory-enter]] textBoxExpnd','default'=>0,'id'=>'dressingChargeDiscountValue'))?>
					<label class="discountLabel" >
					<?php echo $this->Form->input('PackageEstimate.misc_breakup.dressing_charge_discount_type',array('options'=>$discountOptions,
							'class'=>'discountType','id'=>'dressingChargeDiscountType'));?></label>
				
				<?php echo $this->Form->input(__('PackageEstimate.misc_breakup.dressing_charge_discount'),array('type'=>'text',
						'div'=>false,'default'=>0,'class' => 'getDiscount validate[required,custom[mandatory-enter]] textBoxExpnd','id'=>'dressingChargeDiscount')); ?>
			</td>
			
		</tr>
		
		<tr>
			<td class="miscBorderLeft"><label style="width: 99px;"><?php echo __('C-ARM Charge');?>:<font
					color="red">*</font>
			
			</td>
			<td class="miscBorderRight"><?php echo $this->Form->input(__('PackageEstimate.misc_breakup.carm_charge'),array('type'=>'text','style'=>'width:157px;','div'=>false,
					'class' => 'cost miscCost validate[required,custom[onlyNumber,mandatory-enter]] textBoxExpnd','default'=>0,'id'=>'carmChargeDiscountValue'))?>
					<label class="discountLabel" >
					<?php echo $this->Form->input('PackageEstimate.misc_breakup.carm_charge_discount_type',array('options'=>$discountOptions,
							'class'=>'discountType','id'=>'carmChargeDiscountType'));?></label>
				
				<?php echo $this->Form->input(__('PackageEstimate.misc_breakup.carm_charge_discount'),array('type'=>'text',
						'div'=>false,'default'=>0,'class' => 'getDiscount validate[required,custom[mandatory-enter]] textBoxExpnd','id'=>'carmChargeDiscount')); ?>
			</td>
			
		</tr>
		
		<tr>
			<td class="miscBorderLeft"><label style="width: 99px;"><?php echo __('Cautery Charges');?>:<font
					color="red">*</font>
			
			</td>
			<td class="miscBorderRight"><?php echo $this->Form->input(__('PackageEstimate.misc_breakup.cautery_charge'),array('type'=>'text','style'=>'width:157px;','div'=>false,
					'class' => 'cost miscCost validate[required,custom[onlyNumber,mandatory-enter]] textBoxExpnd','default'=>0,'id'=>'cauteryChargeDiscountValue'))?>
					<label class="discountLabel" >
					<?php echo $this->Form->input('PackageEstimate.misc_breakup.cautery_charge_discount_type',array('options'=>$discountOptions,
							'class'=>'discountType','id'=>'cauteryChargeDiscountType'));?></label>
				
				<?php echo $this->Form->input(__('PackageEstimate.misc_breakup.cautery_charge_discount'),array('type'=>'text',
						'div'=>false,'default'=>0,'class' => 'getDiscount validate[required,custom[mandatory-enter]] textBoxExpnd','id'=>'cauteryChargeDiscount')); ?>
			</td>
			
		</tr>
		
		<tr>
			<td class="miscBorderLeft"><label style="width: 99px;"><?php echo __('Monitoring Charges');?>:<font
					color="red">*</font>
			
			</td>
			<td class="miscBorderRight"><?php echo $this->Form->input(__('PackageEstimate.misc_breakup.monitoring_charge'),array('type'=>'text','style'=>'width:157px;','div'=>false,
					'class' => 'cost miscCost validate[required,custom[onlyNumber,mandatory-enter]] textBoxExpnd','default'=>0,'id'=>'monitoringChargeDiscountValue'))?>
					<label class="discountLabel" >
					<?php echo $this->Form->input('PackageEstimate.misc_breakup.monitoring_charge_discount_type',array('options'=>$discountOptions,
							'class'=>'discountType','id'=>'monitoringChargeDiscountType'));?></label>
				
				<?php echo $this->Form->input(__('PackageEstimate.misc_breakup.monitoring_charge_discount'),array('type'=>'text',
						'div'=>false,'default'=>0,'class' => 'getDiscount validate[required,custom[mandatory-enter]] textBoxExpnd','id'=>'monitoringChargeDiscount')); ?>
			</td>
			
		</tr>
		
		<tr>
			<td class="miscBorderLeft"><label style="width: 99px;"><?php echo __('Nitrous Gas Charges');?>:<font
					color="red">*</font>
			
			</td>
			<td class="miscBorderRight"><?php echo $this->Form->input(__('PackageEstimate.misc_breakup.nitrous_charge'),array('type'=>'text','style'=>'width:157px;','div'=>false,
					'class' => 'cost miscCost validate[required,custom[onlyNumber,mandatory-enter]] textBoxExpnd','default'=>0,'id'=>'nitrousChargeDiscountValue'))?>
					<label class="discountLabel" >
					<?php echo $this->Form->input('PackageEstimate.misc_breakup.nitrous_charge_discount_type',array('options'=>$discountOptions,
							'class'=>'discountType','id'=>'nitrousChargeDiscountType'));?></label>
				
				<?php echo $this->Form->input(__('PackageEstimate.misc_breakup.nitrous_charge_discount'),array('type'=>'text',
						'div'=>false,'default'=>0,'class' => 'getDiscount validate[required,custom[mandatory-enter]] textBoxExpnd','id'=>'nitrousChargeDiscount')); ?>
			</td>
			
		</tr>
		
		<tr>
			<td class="miscBorderLeft"><label style="width: 99px;"><?php echo __('Oxyzen Charges');?>:<font
					color="red">*</font>
			
			</td>
			<td class="miscBorderRight"><?php echo $this->Form->input(__('PackageEstimate.misc_breakup.oxygen_charge'),array('type'=>'text','style'=>'width:157px;','div'=>false,
					'class' => 'cost miscCost validate[required,custom[onlyNumber,mandatory-enter]] textBoxExpnd','default'=>0,'id'=>'oxygenChargeDiscountValue'))?>
					<label class="discountLabel" >
					<?php echo $this->Form->input('PackageEstimate.misc_breakup.oxygen_charge_discount_type',array('options'=>$discountOptions,
							'class'=>'discountType','id'=>'oxygenChargeDiscountType'));?></label>
				
				<?php echo $this->Form->input(__('PackageEstimate.misc_breakup.oxygen_charge_discount'),array('type'=>'text',
						'div'=>false,'default'=>0,'class' => 'getDiscount validate[required,custom[mandatory-enter]] textBoxExpnd','id'=>'oxygenChargeDiscount')); ?>
			</td>
			
		</tr>
		
		
		
		<tr>
			<td>&nbsp;</td>
			<td><label style="float: left; text-align: -moz-right; width: 61%;"><i>Discount amt.</i></label>
				<label style="text-align: center; float: right; width: 34%;"><i>Final amt.</i></label></td>
		</tr>
		<tr>
			<td class="miscBorderBottom" style="border-right-style: none;"><label
				style="width: 99px;"><?php echo __('Total hospital charge');?>:<font color="red">*</font>
			
			</td>
			<td class="miscBorderBottom" style="border-left-style: none;"><?php echo $this->Form->input(__('PackageEstimate.misc_charge'),array('type'=>'text','style'=>'width:157px;','div'=>false,'readOnly'=>true,
					'class' => 'validate[required,custom[onlyNumber,mandatory-enter]] textBoxExpnd','id'=>'miscCharge'))?>
					<label class="discountLabel">
					<?php echo $this->Form->input(__('PackageEstimate.misc_breakup.discount_amount'),array('type'=>'text','style'=>'width:44px;','div'=>false,'readOnly'=>true,
					'class' => 'textBoxExpnd','id'=>'miscChargeDiscountAmount'))?></label>
				<?php echo $this->Form->input(__('PackageEstimate.misc_breakup.misc_charge_discount'),array('type'=>'text','style'=>'width: 115px; float: right;',
						'div'=>false,'default'=>'0','class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd','id'=>'miscChargeDiscount','readOnly'=>true)); ?>
			</td>
		</tr>
		<tr>
			<td style="padding-top: 5px;"><label style="width: 99px;"><?php echo __('Total amount');?>:<font
					color="red">*</font> </label>
			</td>
			<td><?php echo $this->Form->input(__('PackageEstimate.total_amount'),array('type'=>'text','style'=>'width:157px;','div'=>false,
					'class' => 'validate[required,custom[onlyNumber,mandatory-enter]] textBoxExpnd','id'=>'totalAmount','readOnly'=>true)); ?>
			</td>
		</tr>
		<tr>
			<td><label style="width: 99px;"><?php echo __('Package price');?>:<font
					color="red">*</font> </label>
			</td>
			<td><?php echo $this->Form->input(__('PackageEstimate.package_price'),array('type'=>'text','style'=>'width:157px;','div'=>false,
					'class' => 'validate[required,custom[onlyNumber,mandatory-enter]] textBoxExpnd','id'=>'packagePrice','readonly'=>true)); ?>
			</td>
		</tr>
		<tr>
			<td class="row_format" align="right" colspan="2"><?php
			echo $this->Html->link('Cancel','javascript:void(0);',array('escape' => false,'id'=>'note-cancel','class'=>'blueBtn'));
			echo $this->Form->submit(__('Submit'), array('label'=> false,'div' => false,'error' => false,'class'=>'blueBtn' ));
			?>
			</td>
		</tr>
	</table>
	<?php echo $this->Form->end();?>
	<div>&nbsp;</div>
	<?php echo $this->Form->create('PackageEstimateSearch',array('url'=>array('controller'=>'Estimates','action'=>'packageMaster',$tariffStandardId),'type'=>'Get',
			'id'=>'PackageEstimatefrmsearch', 'inputDefaults' => array('label' => false,'div' => false)));?>
	<table border="0" cellpadding="0" cellspacing="0" width="500px;"
		style="padding-left: 19px; padding-right: 20px;">
		<tbody>
			<tr class="row_title">
				<td width="30%" class=""
					style="border: none !important; font-size: 13px;"><?php echo __('Package name :') ?>
				</td>
				<td width="30%" style="border: none !important;"><?php  echo $this->Form->input('name', array('type'=>'text','id' => 'name_search', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'style'=>'width:150px;'));?>
				</td>
				<td width="40%" style="border: none !important;"><?php echo $this->Form->submit(__('Search'),array('label'=> false,'div' => false, 'error' => false,'class'=>'blueBtn','title'=>'Search','style'=>'margin-left:10px;'));	?>
					<?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('controller'=>'Estimates','action'=>'packageMaster',$tariffStandardId),array('escape'=>false, 'title' => 'refresh'));?>
				</td>
			</tr>
		</tbody>
	</table>
	<?php echo $this->Form->end();?>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" id="note-add-list" style="display:<?php echo $displayList; ?>;"
		width="100%">
		<tr class="row_title">
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('PackageEstimate.name', __('Package name', true)); ?>
			</strong>
			</td>
			</td>
			<td class="table_cell"><strong><?php echo __('Action', true); ?> </strong>
			</td>
		</tr>
		<?php 
		$cnt =0;
		if(count($data) > 0) {
		       foreach($data as $packageAry):
		       $cnt++;
		       ?>
		<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
			<td class="row_format"><?php echo $packageAry['PackageEstimate']['name']; ?>
			</td>
			<td><?php
			echo $this->Html->link($this->Html->image('icons/view-icon.png', array('title'=> __('View', true),
		   			 					'alt'=> __('View', true))), array('controller'=>'Estimates','action' => 'viewLocationType', $packageAry['PackageEstimate']['id']), array('escape' => false ));
		   			echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('title'=> __('Edit', true),
		   			 					'alt'=> __('Edit', true))), array('controller'=>'Estimates','action' => 'packageMaster',$tariffStandardId, $packageAry['PackageEstimate']['id']), array('escape' => false ));
		   			echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('title'=> __('Delete', true),
		   			 					'alt'=> __('Delete', true))), array('controller'=>'Estimates','action' => 'deletePackage', $packageAry['PackageEstimate']['id']), array('escape' => false ),"Are you sure you wish to delete this package?");
			?>
		
		</tr>
		<?php endforeach;  ?>
		<tr>
			<TD colspan="8" align="center" class="table_format"><?php 
			$queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
                        
			$this->Paginator->options(array('url' =>array(implode(',',$this->params->pass),"?"=>$queryStr)));
			echo $this->Paginator->counter(array('class' => 'paginator_links'));
			echo $this->Paginator->prev(__('« Previous', true), array(/*'update'=>'#doctemp_content',*/
						'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
		    												'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))), null, array('class' => 'paginator_links')); ?>

				<?php 
				echo $this->Paginator->numbers(); ?> <?php echo $this->Paginator->next(__('Next »', true), array(/*'update'=>'#doctemp_content',*/
							'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
		    												'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))), null, array('class' => 'paginator_links')); ?>

				<span class="paginator_links"> </span>
			</TD>
		</tr>
		<?php
 			} else {
		  	?>
		<tr>
			<TD colspan="8" align="center"><?php echo __('No record found', true); ?>.</TD>
		</tr>
		<?php }
		echo $this->Js->writeBuffer(); 	//please do not remove
		?>
	</table>
</div>
<script>
		
jQuery(document).ready(function(){
	
 	jQuery("#packageMasterfrm").validationEngine();	
 	var action = '<?php echo $this->params->query['action'];?>';	
 		 
 	if(action == 'add'){ 
 	 
 		$( "#packageMasterfrm *" ).filter(':input').not(':input[type=button], :input[type=submit], :input[type=reset]').each(function( index ) {
		 	
		 	if($(this).attr('id') != 'icuId' && $(this).attr('id') != 'implantCharge' && $(this).attr('id') != 'tariffStandardId')
				$(this).val('');
		 	if($(this).hasClass('getDiscount'))
				$(this).val(0);
		});
		$("#note-add-form").show('slow') ;
		$("#note-add-list").hide() ;
 	}
	$("#add-note").click(function(){
		$( "#packageMasterfrm *" ).filter(':input').not(':input[type=button], :input[type=submit], :input[type=reset]').each(function( index ) {
			//alert($(this).attr('id'));
			if($(this).attr('id') != 'icuId' && $(this).attr('id') != 'tariffStandardId')
				$(this).val('');
			if( $(this).attr('id') == 'implantCharge')
				$(this).val('0');
			if($(this).hasClass('getDiscount'))
				$(this).val(0);
		});
		$("#note-add-form").show('slow') ;
		$("#note-add-list").hide() ;
	});

	$("#note-cancel").click(function(){
		$( "#packageMasterfrm *" ).filter(':input').not(':input[type=button], :input[type=submit], :input[type=reset]').each(function( index ) { //reset current form
			if($(this).attr('id') != 'icuId' && $(this).attr('id') != 'tariffStandardId')
			$(this).val('');
			if($(this).hasClass('getDiscount'))
				$(this).val(0);
		});
		$("#note-add-form").hide('slow') ;
		$("#note-add-list").show() ;
	});
	$('.getDiscount').trigger('keyup');
	$('.getDiscount').on('keyup',function () {
		var finalDiscount = 0;
		$('.getDiscount').each(function(){
			var thisElementID = $(this).attr('id');
			var type = $('#'+thisElementID+'Type option:selected').val();
			var costOfService = parseInt($('#'+thisElementID+'Value').val());
			var discountValue = parseInt($('#'+thisElementID).val()) ;
			if( type == 'inPercent' ){
				var discountAmount = ( costOfService * discountValue ) / 100;
				var discountAmount = costOfService - discountAmount;
			}else{ 
				var discountAmount = costOfService - discountValue ;
			}
			finalDiscount = finalDiscount + discountAmount;
		});
		amount = 0;
		$('.miscCost').each(function(){
			amount += parseInt($(this).val());
		  });
		if($.isNumeric(amount))
			$('#miscCharge').val(amount)
		if($.isNumeric(finalDiscount)){
			var totalAmount = parseInt($('#totalAmount').val());
			if(finalDiscount == parseInt($('#miscCharge').val())){
				var packagePrice = totalAmount
				var totalDiscount = 0
			}else{
				var totalDiscount = parseInt($('#miscCharge').val()) - finalDiscount;
				var packagePrice = totalAmount - totalDiscount;
			}
			
			if($.isNumeric(packagePrice))
				$('#packagePrice').val(packagePrice);
			$('#miscChargeDiscount').val(finalDiscount);
			//alert(parseInt($('#miscCharge').val())+' - '+finalDiscount+'***'+totalDiscount);
			if($.isNumeric(totalDiscount))
				$('#miscChargeDiscountAmount').val(totalDiscount);
		}
	});
	
	$('.discountType').change(function(){
		var thisElementID = $(this).attr('id');
		thisID = thisElementID.replace("Type", "");
		$('#'+thisID).val(0);
		$('.getDiscount').trigger('keyup');
	});
	
	$("#surgeryCategoryId").change(function() {
        $('#busy-indicator').show();
         var surgery_category = $('#surgeryCategoryId').val();
        var data = 'surgery_category=' + surgery_category ;
        // for surgery category name field //
        $.ajax({
            url: "<?php echo $this->Html->url(array("action" => "getSurgeryAndSubcategoryList", "admin" => false)); ?>",
            type: "GET",
            data: data,
            success:   function (option) {
               option = jQuery.parseJSON(option);
				$('#surgerySubCategoryId , #surgeryId') .empty().append( new Option('Please select' , '') );

                              
                 if(option.subCategory != undefined){
         			$.each(option.subCategory, function (key, value) {
         				 $("#surgerySubCategoryId").append( new Option(value , key) );
         			});
         		}
                 if(option.surgery != undefined){
           			$.each(option.surgery, function (key, value) {
           				 $("#surgeryId").append( new Option(value , key) );
           			});
           		}
                 $('#busy-indicator').hide();
            } 
        });
       
    });
	$( "#implantCompany" ).on('keypress',function(){
		$('#implantCharge').validationEngine('hide');
		companyFromAutoComplete = false;
		var name = $('#implantName').val();
		var implantCondition = (name != '') ? "name="+name+"&ot_item_category_id=<?php echo $categoryIdForImplant['OtItemCategory']['id'];?>" : "ot_item_category_id=<?php echo $categoryIdForImplant['OtItemCategory']['id'];?>";
		$( this ).autocomplete({
			source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advanceMultipleAutocomplete","OtItem","id&manufacturer",'null','null','null')); ?>"+"/"+implantCondition+"/manufacturer",
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


	$("#implantCharge").keypress(function(){
		
	 	if($('#otItemId').val() == ''){
	 		
	 		$('#implantCharge').validationEngine('showPrompt', 'Please select implant ');
	 		$('#implantCharge').val('0');
	 		return false;	
	 	
		 	}
	});
	
	$( "#implantCompany, #implantName " ).focusout(function (){
		
		if(!companyFromAutoComplete){
			$( '#implantCompany' ).val('');
		}
		if(!implantFromAutocomplete){
			$( '#implantName' ).val('');
		}
	});
	$( "#implantName" ).on('keypress',function(){
		$('#implantCharge').validationEngine('hide');
		implantFromAutocomplete = false;
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
		/* if(otItemId == ''){
		$.ajax({
	          type: 'POST',
	          url: "<?php echo $this->Html->url(array("action" => "getPackageDetails","admin" => false)); ?>"+'/null/'+otItemId,
	          data: '',
	          dataType: 'html',
	          success: function(data){ 
	        	  data = jQuery.parseJSON(data);
	        	  if(data.implantRate === null || data.implantRate == '' )data.implantRate = 0;
	        	  $("#implantCharge").val($.trim(data.implantRate));
	        	  $('.cost').trigger('keyup');
		      }
			});
		}*/
	}
	$('#totalDays, #wardId, #daysInIcu').on('keyup change',function (){
		getwardCost();
	});
	getwardCost();
	function getwardCost(){
		if(isNaN(wardCost[$('#icuId').val()]))
		{
			var icuCost = 0;
		}else
		{
		var icuCost = parseInt(wardCost[$('#icuId').val()]) * parseInt($('#daysInIcu').val());//alert(icuCost);
		}
		var totalDays = parseInt($('#totalDays').val());//alert(totalDays);
		var costPerDay = parseInt(wardCost[$('#wardId').val()]);//alert(costPerDay);
		var costOfAccomodation = (totalDays * costPerDay) + icuCost;//alert(costOfAccomodation);
		$('#accomodationCharge').val('');
		if(!isNaN(costOfAccomodation))
		$('#accomodationCharge').val(costOfAccomodation);
		$('.cost').trigger('keyup');
	}

	$('.cost').keyup(function(){
		totalAmount = 0; 
		$('.cost').each(function(){
			totalAmount += parseInt($(this).val());
		  });
		$('#totalAmount').val('');
		if(!isNaN(totalAmount))
		$('#totalAmount').val(totalAmount);
		$('.getDiscount').trigger('keyup');
	});

	$('.miscCost').keyup(function(){
		var thisId = $(this).attr('id');
		var amount = 0; 
		$('.miscCost').each(function(){
			amount += parseInt($(this).val());
		  });
		if(!isNaN(amount)){
			$('#miscCharge').val(amount);
		}
	});

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

	$('#wardId').change(function (){
		var wardId = $(this).val();
		$('#implantService').empty().append(new Option( 'Please select' , '') );
		if(wardService[wardId]['i_assist'])
			$("#implantService").append( new Option('i-Assist' , '0') );
		if(wardService[wardId]['psi'])
			$("#implantService").append( new Option('PSI' , '1') );
		$('#implantserviceCharge').val(0);
		$('.cost').trigger('keyup');
   	});
	

});
var companyFromAutoComplete = implantFromAutocomplete = false;
var wardCost = jQuery.parseJSON('<?php echo $wardCost;?>');
var wardService = jQuery.parseJSON('<?php echo json_encode($wardService);?>');
</script>
