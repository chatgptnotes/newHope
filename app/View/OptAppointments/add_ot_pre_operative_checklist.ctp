<div class="inner_title">
	<h3>
		<?php echo __('Add Pre Operative Check List'); ?>
	</h3>
	 <span>
	<?php 
		echo $this->Html->link(__('Back'),'javascript:void(0);', array('escape' => false,'class'=>"blueBtn Back"));
	?>
</span>
</div>
<div class="patient_info">
	<?php //echo $this->element('patient_information');?>
</div>
<div class="clr"></div>
<p class="ht5"></p>
<form name="preopchecklistfrm" id="preopchecklistfrm"
	action="<?php echo $this->Html->url(array("controller" => "opt_appointments", "action" => "savePreOperativeChecklist")); ?>"
	method="post">
	<?php 
	echo $this->Form->hidden('PreOperativeChecklist.opt_appointment_id', array('id' => 'opt_appointment_id', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off', 'style' => 'width:400px;', 'value'=> $optId));

	echo $this->Form->input('PreOperativeChecklist.patient_id', array('type' => 'hidden', 'value'=> $patient_id, 'id'=> 'patient_id'));
	echo $this->Form->input('PreOperativeChecklist.id', array('type' => 'hidden', 'value'=> isset($patientPOCheckListDetails['PreOperativeChecklist']['id'])?$patientPOCheckListDetails['PreOperativeChecklist']['id']:'', 'id'=> 'ot_pre_op_checklistid'));
	?>
	<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td><strong><font color="red">*</font><?php echo __(' Surgery : '); ?> </strong>
			</td>
			<td><?php 
			echo $this->Form->input('PreOperativeChecklist.surgery_id', array('empty'=>__('Please Select'),'options'=>$surgeries,'id' => 'surgeryname','class' => 'validate[required,custom[mandatory-select]]', 'selected' => $patientPOCheckListDetails['PreOperativeChecklist']['surgery_id'], 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off', 'style' => 'width:400px;'));
			?>
			</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
	</table>
	<table width="100%" border="0" cellspacing="1" cellpadding="0"
		class="tabularForm">
		<tr>
			<th colspan="2"><?php echo __('CHECK EVENING BEFORE SURGERY'); ?></th>
			<th>&nbsp;</th>
			<th><?php echo __('INSTRUCTIONS FOR OP CHECK'); ?></th>
		</tr>
		<tr>
			<td width="35">1.</td>
			<td width="380"><?php echo __('Surgery permit signed'); ?></td>
			<td width="110">
				<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td width="25"><input type="radio"
							name="data[PreOperativeChecklist][sp_signed]" value="1"
							id="sp_signed1"
							<?php if(isset($patientPOCheckListDetails['PreOperativeChecklist']['sp_signed']) && $patientPOCheckListDetails['PreOperativeChecklist']['sp_signed'] == 1) echo "checked"; ?> />
						</td>
						<td width="35"><?php echo __('Yes'); ?></td>
						<td width="25"><input type="radio"
							name="data[PreOperativeChecklist][sp_signed]" value="0"
							id="sp_signed2"
							<?php if(isset($patientPOCheckListDetails['PreOperativeChecklist']['sp_signed']) && $patientPOCheckListDetails['PreOperativeChecklist']['sp_signed'] == 0) echo "checked"; ?> />
						</td>
						<td><?php echo __('No'); ?></td>
					</tr>
				</table>
			</td>
			<td rowspan="22" align="left" valign="top">
				<table width="100%" cellpadding="5" cellspacing="0" border="0">
					<tr>
						<td width="20" valign="top">1.</td>
						<td valign="top" style="padding-bottom: 10px;">OT intimation
							regarding operation should be sent a day prior to surgery.</td>
					</tr>
					<tr>
						<td valign="top">2.</td>
						<td valign="top" style="padding-bottom: 10px;">Attach to I. P.
							file when item completed.</td>
					</tr>
					<tr>
						<td valign="top">3.</td>
						<td valign="top" style="padding-bottom: 10px;">If blood work urine
							analysis has been done but results not available</td>
					</tr>
					<tr>
						<td valign="top">4.</td>
						<td valign="top" style="padding-bottom: 10px;">Nurse preparing
							patient will check all items listed carefully</td>
					</tr>
					<tr>
						<td valign="top">a.</td>
						<td valign="top" style="padding-bottom: 10px;">All jewellery rings
							must be removed.</td>
					</tr>
					<tr>
						<td valign="top">b.</td>
						<td valign="top" style="padding-bottom: 10px;">Glasses / contact
							lenses, dentures and false eyes-lashes etc. must be removed.</td>
					</tr>
					<tr>
						<td valign="top">c.</td>
						<td valign="top" style="padding-bottom: 10px;">All make up,
							nailpolish, hairpins, false eye-lasher etc. must be removed.</td>
					</tr>
					<tr>
						<td valign="top">d.</td>
						<td valign="top" style="padding-bottom: 10px;">Artificial limbs
							must be removed.</td>
					</tr>
					<tr>
						<td valign="top">e.</td>
						<td valign="top" style="padding-bottom: 10px;">Patient must empty
							bladder within one hour of going to surgery.</td>
					</tr>
					<tr>
						<td valign="top">f.</td>
						<td valign="top" style="padding-bottom: 10px;">Clean hospital cap
							and gown are only clothing to be worn to surgery.</td>
					</tr>
					<tr>
						<td valign="top">g.</td>
						<td valign="top" style="padding-bottom: 10px;">Consult doctor's
							order for any special procedures ordered to prepare patient for
							surgery.</td>
					</tr>
					<tr>
						<td valign="top">h.</td>
						<td valign="top" style="padding-bottom: 10px;">Check doctor's
							order for pre-op medication (Time to be given, dose and route)</td>
					</tr>
					<tr>
						<td valign="top">&nbsp;</td>
						<td valign="top" style="padding-bottom: 10px;">SPECIAL INFORMATION</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td width="35">2.</td>
			<td width="350"><?php echo __('History and physical done'); ?></td>
			<td width="110">
				<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td width="25"><input type="radio"
							name="data[PreOperativeChecklist][hp_done]" value="1"
							id="hp_done1"
							<?php if(isset($patientPOCheckListDetails['PreOperativeChecklist']['hp_done']) && $patientPOCheckListDetails['PreOperativeChecklist']['hp_done'] == 1) echo "checked"; ?> />
						</td>
						<td width="35">Yes</td>
						<td width="25"><input type="radio"
							name="data[PreOperativeChecklist][hp_done]" value="0"
							id="hp_done2"
							<?php if(isset($patientPOCheckListDetails['PreOperativeChecklist']['hp_done']) && $patientPOCheckListDetails['PreOperativeChecklist']['hp_done'] == 0) echo "checked"; ?> />
						</td>
						<td>No</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>3.</td>
			<td>Consultation (if requested)</td>
			<td width="110">
				<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td width="25"><input type="radio"
							name="data[PreOperativeChecklist][consultation]" value="1"
							id="consultation1"
							<?php if(isset($patientPOCheckListDetails['PreOperativeChecklist']['consultation']) && $patientPOCheckListDetails['PreOperativeChecklist']['consultation'] == 1) echo "checked"; ?> />
						</td>
						<td width="35">Yes</td>
						<td width="25"><input type="radio"
							name="data[PreOperativeChecklist][consultation]" value="0"
							id="consultation2"
							<?php if(isset($patientPOCheckListDetails['PreOperativeChecklist']['consultation']) && $patientPOCheckListDetails['PreOperativeChecklist']['consultation'] == 0) echo "checked"; ?> />
						</td>
						<td>No</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>4.</td>
			<td>Blood work done, result or chart</td>
			<td width="110">
				<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td width="25"><input type="radio"
							name="data[PreOperativeChecklist][bw_done]" value="1"
							id="bw_done1"
							<?php if(isset($patientPOCheckListDetails['PreOperativeChecklist']['bw_done']) && $patientPOCheckListDetails['PreOperativeChecklist']['bw_done'] == 1) echo "checked"; ?> />
						</td>
						<td width="35">Yes</td>
						<td width="25"><input type="radio"
							name="data[PreOperativeChecklist][bw_done]" value="0"
							id="bw_done2"
							<?php if(isset($patientPOCheckListDetails['PreOperativeChecklist']['bw_done']) && $patientPOCheckListDetails['PreOperativeChecklist']['bw_done'] == 0) echo "checked"; ?> />
						</td>
						<td>No</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>5.</td>
			<td>Urine analysis done, result or chart</td>
			<td width="110">
				<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td width="25"><input type="radio"
							name="data[PreOperativeChecklist][ua_done]" value="1"
							id="ua_done1"
							<?php if(isset($patientPOCheckListDetails['PreOperativeChecklist']['ua_done']) && $patientPOCheckListDetails['PreOperativeChecklist']['ua_done'] == 1) echo "checked"; ?> />
						</td>
						<td width="35">Yes</td>
						<td width="25"><input type="radio"
							name="data[PreOperativeChecklist][ua_done]" value="0"
							id="ua_done2"
							<?php if(isset($patientPOCheckListDetails['PreOperativeChecklist']['ua_done']) && $patientPOCheckListDetails['PreOperativeChecklist']['ua_done'] == 0) echo "checked"; ?> />
						</td>
						<td>No</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>6.</td>
			<td>Operative part are prepared</td>
			<td width="110">
				<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td width="25"><input type="radio"
							name="data[PreOperativeChecklist][op_prepare]" value="1"
							id="op_prepare1"
							<?php if(isset($patientPOCheckListDetails['PreOperativeChecklist']['op_prepare']) && $patientPOCheckListDetails['PreOperativeChecklist']['op_prepare'] == 1) echo "checked"; ?> />
						</td>
						<td width="35">Yes</td>
						<td width="25"><input type="radio"
							name="data[PreOperativeChecklist][op_prepare]" value="0"
							id="op_prepare2"
							<?php if(isset($patientPOCheckListDetails['PreOperativeChecklist']['op_prepare']) && $patientPOCheckListDetails['PreOperativeChecklist']['op_prepare'] == 0) echo "checked"; ?> />
						</td>
						<td>No</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>7.</td>
			<td>Enema given, if ordered</td>
			<td width="110">
				<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td width="25"><input type="radio"
							name="data[PreOperativeChecklist][enema_given]" value="1"
							id="enema_given1"
							<?php if(isset($patientPOCheckListDetails['PreOperativeChecklist']['enema_given']) && $patientPOCheckListDetails['PreOperativeChecklist']['enema_given'] == 1) echo "checked"; ?> />
						</td>
						<td width="35">Yes</td>
						<td width="25"><input type="radio"
							name="data[PreOperativeChecklist][enema_given]" value="0"
							id="enema_given2"
							<?php if(isset($patientPOCheckListDetails['PreOperativeChecklist']['enema_given']) && $patientPOCheckListDetails['PreOperativeChecklist']['enema_given'] == 0) echo "checked"; ?> />
						</td>
						<td>No</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td valign="top">8.</td>
			<td valign="top">N. P. O. notice at bedside<font color="red">*</font>
			</td>
			<td><input type="text"
				name="data[PreOperativeChecklist][npo_notice_time]"
				class="textBoxExpnd validate[required,custom[mandatory-enter-only]]"
				id="npo_notice_time" style="width: 93px;"
				value="<?php echo $patientPOCheckListDetails['PreOperativeChecklist']['npo_notice_time']; ?>" />
			</td>
		</tr>

		<tr>
			<td valign="top">9.</td>
			<td>Type and crossmatch done number of blood (units) arranged</td>
			<td width="110">
				<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td width="25"><input type="radio"
							name="data[PreOperativeChecklist][tc_done]" value="1"
							id="tc_done1"
							<?php if(isset($patientPOCheckListDetails['PreOperativeChecklist']['tc_done']) && $patientPOCheckListDetails['PreOperativeChecklist']['tc_done'] == 1) echo "checked"; ?> />
						</td>
						<td width="35">Yes</td>
						<td width="25"><input type="radio"
							name="data[PreOperativeChecklist][tc_done]" value="0"
							id="tc_done2"
							<?php if(isset($patientPOCheckListDetails['PreOperativeChecklist']['tc_done']) && $patientPOCheckListDetails['PreOperativeChecklist']['tc_done'] == 0) echo "checked"; ?> />
						</td>
						<td>No</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td valign="top">10.</td>
			<td valign="top">N.P.O. after midnight or since<font color="red">*</font>
			</td>
			<td><input type="text"
				name="data[PreOperativeChecklist][npo_midnight]"
				class="textBoxExpnd validate[required,custom[mandatory-enter-only]]"
				id="npo_midnight" style="width: 93px;"
				value="<?php echo $patientPOCheckListDetails['PreOperativeChecklist']['npo_midnight']; ?>" />
			</td>
		</tr>
		<tr>
			<td valign="top">11.</td>
			<td valign="top">Identification band or wrist, with name, room,
				hospital number<font color="red">*</font>
			</td>
			<td><input type="text"
				name="data[PreOperativeChecklist][identification_band]"
				class="textBoxExpnd validate[required,custom[mandatory-enter-only]]"
				id="identification_band" style="width: 93px;"
				value="<?php echo $patientPOCheckListDetails['PreOperativeChecklist']['identification_band']; ?>" />
			</td>
		</tr>
		<tr>
			<td valign="top">12.</td>
			<td valign="top">Name plate with chart</td>
			<td><input type="text" name="data[PreOperativeChecklist][name_plate]"
				class="textBoxExpnd" id="name_plate" style="width: 93px;"
				value="<?php echo $patientPOCheckListDetails['PreOperativeChecklist']['name_plate']; ?>" />
			</td>
		</tr>
		<tr>
			<td valign="top">13.</td>
			<td valign="top">Glasses / contact lenses removed</td>
			<td width="110">
				<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td width="25"><input type="radio"
							name="data[PreOperativeChecklist][glassess_removed]" value="1"
							id="glassess_removed1"
							<?php if(isset($patientPOCheckListDetails['PreOperativeChecklist']['glassess_removed']) && $patientPOCheckListDetails['PreOperativeChecklist']['glassess_removed'] == 1) echo "checked"; ?> />
						</td>
						<td width="35">Yes</td>
						<td width="25"><input type="radio"
							name="data[PreOperativeChecklist][glassess_removed]" value="0"
							id="glassess_removed2"
							<?php if(isset($patientPOCheckListDetails['PreOperativeChecklist']['glassess_removed']) && $patientPOCheckListDetails['PreOperativeChecklist']['glassess_removed'] == 0) echo "checked"; ?> />
						</td>
						<td>No</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td valign="top">14.</td>
			<td valign="top">Dentures removed</td>
			<td width="110">
				<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td width="25"><input type="radio"
							name="data[PreOperativeChecklist][dentures_removed]" value="1"
							id="dentures_removed1"
							<?php if(isset($patientPOCheckListDetails['PreOperativeChecklist']['dentures_removed']) && $patientPOCheckListDetails['PreOperativeChecklist']['dentures_removed'] == 1) echo "checked"; ?> />
						</td>
						<td width="35">Yes</td>
						<td width="25"><input type="radio"
							name="data[PreOperativeChecklist][dentures_removed]" value="0"
							id="dentures_removed2"
							<?php if(isset($patientPOCheckListDetails['PreOperativeChecklist']['dentures_removed']) && $patientPOCheckListDetails['PreOperativeChecklist']['dentures_removed'] == 0) echo "checked"; ?> />
						</td>
						<td>No</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td valign="top">15.</td>
			<td valign="top">Jewellery removed and secured</td>
			<td width="110">
				<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td width="25"><input type="radio"
							name="data[PreOperativeChecklist][jewellery_removed]" value="1"
							id="jewellery_removed1"
							<?php if(isset($patientPOCheckListDetails['PreOperativeChecklist']['jewellery_removed']) && $patientPOCheckListDetails['PreOperativeChecklist']['jewellery_removed'] == 1) echo "checked"; ?> />
						</td>
						<td width="35">Yes</td>
						<td width="25"><input type="radio"
							name="data[PreOperativeChecklist][jewellery_removed]" value="0"
							id="jewellery_removed2"
							<?php if(isset($patientPOCheckListDetails['PreOperativeChecklist']['jewellery_removed']) && $patientPOCheckListDetails['PreOperativeChecklist']['jewellery_removed'] == 0) echo "checked"; ?> />
						</td>
						<td>No</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td valign="top">16.</td>
			<td valign="top">Hairpins, makeup, nailpolish removed</td>
			<td width="110">
				<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td width="25"><input type="radio"
							name="data[PreOperativeChecklist][hairpins_removed]" value="1"
							id="hairpins_removed1"
							<?php if(isset($patientPOCheckListDetails['PreOperativeChecklist']['hairpins_removed']) && $patientPOCheckListDetails['PreOperativeChecklist']['hairpins_removed'] == 1) echo "checked"; ?> />
						</td>
						<td width="35">Yes</td>
						<td width="25"><input type="radio"
							name="data[PreOperativeChecklist][hairpins_removed]" value="0"
							id="hairpins_removed2"
							<?php if(isset($patientPOCheckListDetails['PreOperativeChecklist']['hairpins_removed']) && $patientPOCheckListDetails['PreOperativeChecklist']['hairpins_removed'] == 0) echo "checked"; ?> />
						</td>
						<td>No</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td valign="top">17.</td>
			<td valign="top">Head cap and hospital gown on</td>
			<td width="110">
				<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td width="25"><input type="radio"
							name="data[PreOperativeChecklist][headcap_hp_gown_on]" value="1"
							id="headcap_hp_gown_on1"
							<?php if(isset($patientPOCheckListDetails['PreOperativeChecklist']['headcap_hp_gown_on']) && $patientPOCheckListDetails['PreOperativeChecklist']['headcap_hp_gown_on'] == 1) echo "checked"; ?> />
						</td>
						<td width="35">Yes</td>
						<td width="25"><input type="radio"
							name="data[PreOperativeChecklist][headcap_hp_gown_on]" value="0"
							id="headcap_hp_gown_on2"
							<?php if(isset($patientPOCheckListDetails['PreOperativeChecklist']['headcap_hp_gown_on']) && $patientPOCheckListDetails['PreOperativeChecklist']['headcap_hp_gown_on'] == 0) echo "checked"; ?> />
						</td>
						<td>No</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td valign="top">18.</td>
			<td valign="top">Voided within an hour of surgery</td>
			<td width="110">
				<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td width="25"><input type="radio"
							name="data[PreOperativeChecklist][voided_surgery]" value="1"
							id="voided_surgery1"
							<?php if(isset($patientPOCheckListDetails['PreOperativeChecklist']['voided_surgery']) && $patientPOCheckListDetails['PreOperativeChecklist']['voided_surgery'] == 1) echo "checked"; ?> />
						</td>
						<td width="35">Yes</td>
						<td width="25"><input type="radio"
							name="data[PreOperativeChecklist][voided_surgery]" value="0"
							id="voided_surgery2"
							<?php if(isset($patientPOCheckListDetails['PreOperativeChecklist']['voided_surgery']) && $patientPOCheckListDetails['PreOperativeChecklist']['voided_surgery'] == 0) echo "checked"; ?> />
						</td>
						<td>No</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td valign="top">19.</td>
			<td valign="top">Cathetrised Time</td>
			<td><input type="text"
				name="data[PreOperativeChecklist][cathertrised_time]"
				class="textBoxExpnd" id="cathertrised_time" style="width: 93px;"
				value="<?php echo $patientPOCheckListDetails['PreOperativeChecklist']['cathertrised_time']; ?>" />
			</td>
		</tr>
		<tr>
			<td colspan="2" valign="top">
				<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td height="35">Temp.&nbsp;:</td>
						<td colspan="3" ><input name="data[PreOperativeChecklist][temp]"
							class="textBoxExpnd" id="temp" style="width: 65px;"
							value="<?php echo $patientPOCheckListDetails['PreOperativeChecklist']['temp']; ?>" />
						</td>
						
						<td >Pulse</td>
						<td ><input name="data[PreOperativeChecklist][pulse]"
							class="textBoxExpnd" id="pulse" style="width: 65px;"
							value="<?php echo $patientPOCheckListDetails['PreOperativeChecklist']['pulse']; ?>" />
						</td>
						<td>&nbsp;</td>
						<td >Resp.&nbsp;:</td>
						<td ><input name="data[PreOperativeChecklist][resp]"
							class="textBoxExpnd" id="resp" style="width: 65px;"
							value="<?php echo $patientPOCheckListDetails['PreOperativeChecklist']['resp']; ?>" />
						</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td height="35">B.P. :</td>
						<td><input name="data[PreOperativeChecklist][blood_pressure]"
							class="textBoxExpnd" id="blood_pressure" style="width: 30px;"
							value="<?php echo $patientPOCheckListDetails['PreOperativeChecklist']['blood_pressure']; ?>" /></td>
						<td>/</td>
						<td><input name="data[PreOperativeChecklist][blood_pressure_di]"
							class="textBoxExpnd" id="blood_pressure_di" style="width: 30px;"
							value="<?php echo $patientPOCheckListDetails['PreOperativeChecklist']['blood_pressure_di']; ?>" /></td>
						<td>Weight&nbsp;:</td>
						<td><input name="data[PreOperativeChecklist][weight]"
							class="textBoxExpnd" id="weight" style="width: 65px;"
							value="<?php echo $patientPOCheckListDetails['PreOperativeChecklist']['weight']; ?>" /></td>
						<td text-align="left">lbs</td>
						<td>Height&nbsp;:</td>
						<td><input name="data[PreOperativeChecklist][height]"
							class="textBoxExpnd" id="height" style="width: 65px;"
							value="<?php echo $patientPOCheckListDetails['PreOperativeChecklist']['height']; ?>" /></td>
						<td>inches</td>
					</tr>
					
					<tr>
					<td colspan="10">
					<?php echo $this->Form->button('Show BMI',array('type'=>"button",'value'=>"Show BMI",'class'=>"blueBtn",'id'=>'showBmi','label'=>false,'div'=>false ));?>&nbsp;&nbsp;&nbsp;&nbsp;
					<?php echo $this->Form->input('PreOperativeChecklist.bmi',array('type'=>"text",'id'=>'bmi',name=>"data[PreOperativeChecklist][bmi]", 'value'=>$patientPOCheckListDetails['PreOperativeChecklist']['bmi'],'size'=>"25", 'label'=>false,'div'=>false));?>
					</td>
					</tr>
					
					<tr>
						<td height="35" colspan="9">PRE-OPERATIVE MEDICATION ORDER</td>
					</tr>
				</table>
			</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2" valign="top"><table width="100%" cellpadding="0"
					cellspacing="0" border="0">
					<tr>
						<td width="50" height="35">&nbsp;</td>
						<td width="70">&nbsp;</td>
						<td width="20">&nbsp;</td>
						<td width="70"></td>
						<td width=""></td>
					</tr>
					<tr>
					
						<td><table width="275" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td><font color="red">*</font> Date :</td>
									<td><input name="data[PreOperativeChecklist][pre_date]"
										class ='validate[required,custom[mandatory-date]] textBoxExpnd' id="pre_date" style="width: 150px;"
										tabindex="16"
										value="<?php if(!empty($patientPOCheckListDetails['PreOperativeChecklist']['pre_date']) && $patientPOCheckListDetails['PreOperativeChecklist']['pre_date'] != "0000-00-00" ) echo $this->DateFormat->formatDate2Local($patientPOCheckListDetails['PreOperativeChecklist']['pre_date'],Configure::read('date_format'));?>" />
									</td>

								</tr>
							</table>
						</td>
						<td height="35">Given&nbsp;:</td>
						<td><input name="data[PreOperativeChecklist][pre_given]"
							class="textBoxExpnd" id="pre_given" style="width: 65px;"
							value="<?php echo $patientPOCheckListDetails['PreOperativeChecklist']['pre_given']; ?>" />
						</td>
						<td></td>
						<td>&nbsp;</td>
						
					</tr>

				</table></td>

			<td valign="bottom"></td>
		</tr>
	</table>
	<div class="clr ht5"></div>
	<div class="btns">
	<?php 
		//echo $this->Html->link(__('Cancel', true),array('action' => 'ot_pre_operative_checklist', $patient_id), array('escape' => false,'class'=>'grayBtn', 'tabindex' => '19'));
		echo $this->Html->link(__('Cancel', true),'javascript:void(0);', array('escape' => false,'class'=>'grayBtn Back', 'tabindex' => '19'));
	 ?>
		<input type="submit" value="Submit" class="blueBtn" tabindex="17">
	</div>
	<div class="clr ht5"></div>

</form>
<?php 
echo $this->Html->css(array('jquery.timepicker'));
echo $this->Html->script(array('jquery.timepicker'));
?>
<script>
jQuery(document).ready(function(){
   jQuery("#preopchecklistfrm").validationEngine();
			    $( "#pre_date" ).datepicker({
									showOn: "button",
									buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
									buttonImageOnly: true,
									changeMonth: true,
									changeYear: true,
									changeTime:true,
									showTime: true,  		
									dateFormat:'<?php echo $this->General->GeneralDate();?>',
                                                                        minDate: new Date("<?php echo date("F d, Y H:i:s", strtotime($patient['Patient']['form_received_on'])) ?>") 
                                                                        
                                                                        
							});	
                          $( "#pre_given" ).timepicker({
                                                       'minTime': '12:00am',
	                                               'maxTime': '12:00pm',
	                                               'showDuration': true
                                                        });
                          $( "#npo_notice_time" ).timepicker({
                                                       'minTime': '12:00am',
	                                               'maxTime': '12:00pm',
	                                               'showDuration': true
                                                        });
                          $( "#cathertrised_time" ).timepicker({
                                                       'minTime': '12:00am',
	                                               'maxTime': '12:00pm',
	                                               'showDuration': true
                                                        });
                          $( "#npo_midnight" ).timepicker({
                                                            'minTime': '12:00am',
     	                                               'maxTime': '12:00pm',
     	                                               'showDuration': true
                                                             });

   });


$('#showBmi').click(function ()
		{ //alert($("input:radio.Weight:checked").val());

			var val=$('#height').val();
		    var res=(val/39.37);
		    res= Math.round(res * 100) / 100;
		    
		    var val=$('#weight').val();
		    var res1=(val/2.2);
		    res1= Math.round(res1 * 100) / 100;
		   
				var height = res;
				var weight = res1;
				
				weight = weight;
				height = (height * height);
				//height = (height / 100);
				var total = weight / height;

				total= Math.round(total * 100) / 100;
		  	$('#bmi').val(total);
		  
		 });


$(".Back").click(function(){
	$.ajax({
		url: '<?php echo $this->Html->url(array("controller" => "opt_appointments", "action" => "ot_pre_operative_checklist", "admin" => false,'plugin' => false, $patient_id)); ?>',
		beforeSend:function(data){
			$('#busy-indicator').show();
		},
		success: function(data){
			$('#busy-indicator').hide();
			$("#render-ajax").html(data);
	     }
	});
 });

</script>
