<style>
.tdclass {
	padding-left: 10px;
}

.td1 {
	padding-left: 5px;
	width: 15%;
	border-bottom: 1px solid #3E4D4A;
	border-right: 1px solid #3E4D4A;
}

.tdrght {
	padding-left: 23px;
	width: 5%;
	border-bottom: 1px solid #3E4D4A;
	border-right: 1px solid #3E4D4A;
}

.td2 {
	border-bottom: 1px solid #3E4D4A;
	border-right: 1px solid #3E4D4A;
	padding-left: 10px;
	width: 20%;
	
	padding-bottom: 0px;
}

.tr1 {
	height: 50px;
	border-bottom: 1px solid #3E4D4A;
}

.formError .formErrorContent {
	width: 60px;
}

.label {
    color: #E7EEEF;
    float: left;
    font-size: 13px;
    margin-right: 10px;
    padding-top: 0;
    text-align: right;
    width: 97px;
}
</style>
<div class="inner_title">
	<h3>
		<?php echo __('Ventilator/Sedation Order Test');?>
	</h3>
</div>

<div class="clr ht5"></div>
<?php echo $this->element('patient_information');?>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
<?php echo $this->Form->create('',array('controller'=>'Nursing','action'=>'ventilator_nurse_checklist','name'=>'VentilatorNurseCheckList'),array('id'=>'ventilatorfrm'));
echo $this->Form->hidden('patient_id',array('value'=>$patient['Patient']['id']));
echo $this->Form->hidden('id',array('type'=>'text'));
 	echo $this->Form->hidden('ventilator_check_list_id',array('type'=>'text','value'=>$list_data['id']));?>

<table width="98%" border="0" cellspacing="1" cellpadding="0"
	class="tabularForm" style="margin: 11px 12px">
	<tr>
		<td width="289" style="text-align: center;">Ventilation Date</td>

		<td width="" style="text-align: center;"><?php echo $list_data['ventilator_date'] ;?>
		</td>
	</tr>
	<tr>
		<td width="289" style="text-align: center;">HOB</td>

		<td><table width="100%">
				<tr>
					<td width="50%" style="text-align: center;"><?php echo $list_data['hob'] ;?>
					</td>
					<td width="50%" style="text-align: center;"><?php echo $list_data['hob_priority'] ;?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td width="289" style="text-align: center;">Oral Care</td>

		<td width=""><table width="100%">
				<tr>
					<td width="50%" style="text-align: center;"><?php echo $list_data['oral_care'] ;?>
					</td>
					<td width="50%" style="text-align: center;"><?php echo $list_data['oral_care_priority'] ;?>
					</td>
				</tr>
			</table></td>
	</tr>
	<tr>
		<td width="289" style="text-align: center;">G.I Prophylaxis</td>

		<td width=""><table width="100%">
				<tr>
					<td width="50%" style="text-align: center;"><?php echo $list_data['gi_proph'] ;?>
					</td>
					<td width="50%" style="text-align: center;"><?php echo $list_data['gi_proph_priority'] ;?>
					</td>
				</tr>
			</table></td>
	</tr>

	<tr>
		<td width="289" style="text-align: center;">VTE Prophylaxis</td>

		<td width=""><table width="100%">
				<tr>
					<td width="50%" style="text-align: center;"><?php echo $list_data['vte_prophylaxis'];?>
					</td>
					<td width="50%" style="text-align: center;"><?php echo $list_data['vte_priority'];?>
					</td>
				</tr>
			</table></td>
	</tr>
	<tr>
		<td width="289" style="text-align: center;">Ventilator Management</td>

		<td width=""><table width="100%">
				<tr>
					<td width="50%" style="text-align: center;"><?php echo $list_data['vent_management'] ;?>
					</td>
					<td width="50%" style="text-align: center;"><?php echo $list_data['vent_priority'] ;?>
					</td>
				</tr>
			</table></td>
	</tr>

	<tr>
		<td width="289" style="text-align: center;">Ventilator Setting</td>

		<td width=""><table width="100%">
				<tr>
					<td width="50%" style="text-align: center;"><?php echo $list_data['vent_setting'];?>
					</td>
					<td width="50%" style="text-align: center;"><?php echo $list_data['vent_setting_priority'];?>
					</td>
				</tr>
			</table></td>
	</tr>
</table>
<!-- --------vikas Form -->
<div>


	<table width="100%" cellspacing="0" cellpadding="0" border="1" height="100px">
		<tbody>
			<tr>
				<td width="49%" valign="top" align="left">
					<table width="100%" cellspacing="0" cellpadding="0" border="0">
						<tbody>
							<tr width="100%" valign="middle" id="boxSpace" class="tr1">
								<td class="td1"><strong><?php echo ('Consult Dr Setting:');?> </strong>
								</td>
								<td class="td2" colspan="3"><?php echo ucfirst($treating_consultant[0]['fullname']) ;?>
								</td>
								<td class="tdrght"></td>
							</tr>


							<tr width="100%" valign="middle" class="tr1">


								<td class="td1"><strong><?php echo __('Ventilator Management:');?>
								</strong></td>
								<td class="td2" colspan="3"><?php echo $list_data['ventilator_management'];?>
								</td>
								<td class="tdrght"><strong><?php echo $this->Form->checkbox('ventilator_management', array('label'=>false,'class'=>'servicesClick','id' => 'ventilator_management'));?>
								</strong></td>
							</tr>
							<tr width="100%" valign="middle" id="boxSpace" class="tdLabel">
								<td class="td1"><strong><?php echo __('Ventilator Setting:');?>
								</strong></td>
								<td class="td2" colspan="3"><?php echo $list_data['ventilator_setting'];?>
								</td>
								<td class="tdrght"><strong><?php echo $this->Form->checkbox('ventilator_setting', array('label'=>false,'class'=>'servicesClick','id' => 'ventilator_setting'));?>
								</strong></td>
							</tr>
							<tr width="100%" valign="middle" id="boxSpace"
								class="tdLabel showclick">
								<td class="td1"></td>
								<td class="td2" colspan="3"><table width="100%" valign="middle"
										id="boxSpace" class="tdLabel">
										<tr>
											<td width="50%"><label class="label"><?php echo __("Tidal Volume");?>:</label>
												<?php echo $list_data['tidal_volume']; ?><span>ml</span></td>
											<td width="50%"><label class="label"><?php echo __("Rate");?>:</label>
												<?php echo $list_data['rate']; ?><span>breaths/min</span></td>
										</tr>
										<tr>
											<td width="50%"><label class="label">FIO<sub>2</sub>:
											</label> <?php echo $list_data['fio2']; ?><span>%</span></td>
											<td width="50%"><label class="label">Maintain SPO<sub>2</sub>:
											</label> <?php echo $list_data['spo2']; ?><span>%</span></td>
										</tr>
										<tr>
											<td width="50%"><label class="label">PSV:</label> <?php echo $list_data['psv']; ?><span><font
													size="-2">(start with 15cm H<sub>2</sub>O in SIMV </t>or
														PSV mode.)
												</font> </span></td>
											<td width="50%"><label class="label">PEEP:</label> <?php echo $list_data['peep']; ?><span>cm
													H<sub>2</sub>O
											</span></td>
										</tr>
									</table>
								</td>
								<td class="tdrght"></td>

							</tr>

							<tr width="100%" valign="middle" id="boxSpace" class="tr1">
								<td class="td1"><strong><?php echo __('Radiology:');?> </strong>
								</td>
								<td class="td2" colspan="3"><?php echo $list_data['radiology'];?>
								</td>
								<td class="tdrght"><strong><?php echo $this->Form->checkbox('radiology', array('label'=>false,'class'=>'servicesClick','id' => 'radiology'));?>
								</strong></td>
							</tr>
							<tr width="100%" valign="middle" id="boxSpace" class="tr1">
								<td class="td1"><strong><?php echo __('Labs:');?> </strong></td>
								<td class="td2" colspan="3"><?php echo $list_data['lab'];?></td>
								<td class="tdrght"><strong><?php echo $this->Form->checkbox('lab', array('label'=>false,'class'=>'servicesClick','id' => 'lab'));?>
								</strong></td>
							</tr>

							<tr width="100%" valign="middle" id="boxSpace" class="tr1">
								<td class="td1"><strong><?php echo __('Studies:');?> </strong></td>
								<td class="td2" colspan="3"><?php echo $list_data['studies'];?>
								</td>
								<td class="tdrght"><strong><?php echo $this->Form->checkbox('studies', array('label'=>false,'class'=>'servicesClick','id' => 'studies'));?>
								</strong></td>
							</tr>

							<tr width="100%" valign="middle" id="boxSpace" class="tr1">
								<td class="td1"><strong><?php echo __('Vital Signs:');?> </strong>
								
								<td class="td2" colspan="3"><?php echo $list_data['vital_sign'];?>
								</td>
								<td class="tdrght"><strong><?php echo $this->Form->checkbox('vital_sign', array('label'=>false,'class'=>'servicesClick','id' => 'vital_sign'));?>
								</strong></td>
							</tr>

							<tr width="100%" valign="middle" id="boxSpace" class="tr1">
								<td class="td1"><strong><?php echo __('Activity:');?> </strong>
								</td>
								<td class="td2" colspan="3"><?php echo $list_data['activity'];?>
								</td>
								<td class="tdrght"><strong><?php echo $this->Form->checkbox('activity', array('label'=>false,'class'=>'servicesClick','id' => 'activity'));?>
								</strong></td>

							</tr>
							<tr width="100%" valign="middle" id="boxSpace" class="tr1">
								<td class="td1"><strong><?php echo __('Consults:');?> </strong>
								</td>

								<td class="td2" colspan="3"><?php echo $list_data['consult_name'];?>
								</td>
								<td class="tdrght"><strong><?php echo $this->Form->checkbox('consult_name', array('label'=>false,'class'=>'servicesClick','id' => 'consult_name'));?>
								</strong></td>
							</tr>

							<tr width="100%" valign="middle" id="boxSpace" class="tr1">
								<td class="td1"><strong><?php echo __('Sedation:');?> </strong>
								</td>
								<td class="td2"><?php echo $list_data['sedation'][0];?></td>
								<td class="td2"><?php echo $list_data['sedation'][1];?></td>
								<td class="td2"><?php echo $list_data['sedation'][2];?></td>
								<?php if(!isset($list_data['sedation'][3])){?>
								<td class="tdrght"><strong><?php echo $this->Form->checkbox('sedation', array('label'=>false,'class'=>'servicesClick','id' => 'sedation'));?>
								</strong></td>
								<?php }?>
							</tr>
							<?php if(isset($list_data['sedation'][3])){?>
							<tr width="100%" valign="middle" id="boxSpace" class="tr1">
								<td class="td1"></td>
								<td class="td2"><?php echo $list_data['sedation'][3];?></td>
								<td class="td2" colspan="2"><?php echo $list_data['sedation'][4];?>
								</td>
								<td class="tdrght"><strong><?php echo $this->Form->checkbox('sedation', array('label'=>false,'class'=>'servicesClick','id' => 'sedation'));?>
								</strong></td>
							</tr>
							<?php }?>


							<tr width="100%" valign="middle" id="boxSpace" class="tr1">
								<td class="td1"><strong><?php echo __('Analgesia:');?> </strong>
								</td>
								<td class="td2"><?php echo $list_data['analgesia'][0];?></td>
								<td class="td2"><?php echo $list_data['analgesia'][1];?></td>
								<td class="td2"><?php echo $list_data['analgesia'][2];?></td>
								<td class="tdrght"><strong><?php echo $this->Form->checkbox('analgesia', array('label'=>false,'class'=>'servicesClick','id' => 'analgesia'));?>
								</strong></td>

							</tr>

							<tr width="100%" valign="middle" id="boxSpace" class="tr1">
								<td class="td1"><strong><?php echo __('Oral Care:');?> </strong>
								</td>
								<td class="td2" colspan="3"><?php echo $list_data['oral_care_order_set'];?>
								</td>
								<td class="tdrght"><strong><?php echo $this->Form->checkbox('oral_care_order_set', array('label'=>false,'class'=>'servicesClick','id' => 'oral_care_order_set'));?>
								</strong></td>
							</tr>

							<tr width="100%" valign="middle" id="boxSpace" class="tr1">
								<td class="td1"><strong><?php echo __('DVT Prophaxis:');?> </strong>
								</td>
								<td class="td2"><?php echo $list_data['dvt_prophaxis'][0];?></td>
								<td class="td2"><?php echo $list_data['dvt_prophaxis'][1];?></td>
								<td class="td2"><?php echo $list_data['dvt_prophaxis'][2];?></td>
								<td class="tdrght"><strong><?php echo $this->Form->checkbox('dvt_prophaxis', array('label'=>false,'class'=>'servicesClick','id' => 'dvt_prophaxis'));?>
								</strong></td>
							</tr>

							<tr width="100%" valign="middle" id="boxSpace" class="tr1">
								<td class="td1"><strong><?php echo __('PUD Prophaxis:');?> </strong>
								</td>
								<td class="td2" colspan="3"><?php echo $list_data['pud_prophaxis'];?>
								</td>
								<td class="tdrght"><strong><?php echo $this->Form->checkbox('pud_prophaxis', array('label'=>false,'class'=>'servicesClick','id' => 'pud_prophaxis'));?>
								</strong></td>

							</tr>
					
					</table>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<!-- ---------------- -->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>
			<div class="btns">
				<?php echo $this->Html->link(__('Cancel'), array('controller'=>'nursings','action' => 'ventilator_nurse_list', $patient['Patient']['id']), array('escape' => false,'class'=>'blueBtn'));
				echo $this->Form->submit(__('Submit'), array('id'=>'submit','label'=> false,'div' => false,'error' => false,'class'=>'blueBtn' ));
				?>
			</div>
		</td>
	</tr>
</table>
<?php echo $this->Form->end();?>

