<?php 
echo $this->Html->script(array('ui.datetimepicker.3.js','jquery.autocomplete'));
echo $this->Html->css(array('jquery.autocomplete.css'));?>


<?php 
if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"
	align="center">
	<tr>
		<td colspan="2" align="left"><?php 
		foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }

     ?></td>
	</tr>
</table>
<?php } ?>
<style>
<!--
select { /*	width: 350px;*/
	
}
-->
</style>
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#EncounterBeforeClaim").validationEngine();
	});
	
</script>

<div class="inner_title">
	<h3>
		<?php echo __('Add Before Claim Submission'); ?>
	</h3>
	<?php  //echo $this->Html->link('Back',array("controller"=>"Insurances","action"=>"addNewEncounter",$patient_id,$id),array('escape'=>false,'class'=>'blueBtn','title'=>'Back'));?>
	<?php  echo $this->Html->link('Initial Assessment PDF',array("controller"=>"Insurances","action"=>"initialPdf",$patient_id),array('escape'=>false,'class'=>'blueBtn','title'=>'Intail Assessment PDF'));?>
	<?php  echo $this->Html->link('SOAP PDF',array("controller"=>"Insurances","action"=>"soapPdf",$noteId,$patient_id),array('escape'=>false,'class'=>'blueBtn','title'=>'SOAP PDF'));?>
	<?php  echo $this->Html->link('HPI PDF',array("controller"=>"Insurances","action"=>"hpiPdf",$patient_id),array('escape'=>false,'class'=>'blueBtn','title'=>'HPI PDF'));?>
	<span><?php  echo $this->Html->link('Back',array("controller"=>"Insurances","action"=>"addNewEncounter",$patient_id,$id),array('escape'=>false,'class'=>'blueBtn','title'=>'Back')); ?>
	</span>

</div>
<?php echo $this->element('patient_information');?>
<?php echo $this->Form->create('Encounter',array('url'=>array('controller'=>'Insurances','action'=>'addBeforeClaim',$patient_id,$id),'type' => 'file','id'=>'EncounterBeforeClaim','inputDefaults' => array(
		'label' => false,
		'div' => false,
		'error' => false,
		'legend'=>false,
		'fieldset'=>false
)
));
echo $this->Form->hidden('Encounter.patient_id',array('value'=>$patient_id,'id'=>'patientId'));
echo $this->Form->hidden('Encounter.id',array('value'=>$id,'id'=>'encRecordId'));
?>
<table border="0" cellpadding="0" cellspacing="0" width="100%"
	class="formFull" align="center">
	<tr>
		<td class="tdLabel" id="boxSpace" width="25%"><?php echo __('Billing Status'); ?><font
			color="red">*</font>
		</td>
		<td width="25%"><?php 
		echo $this->Form->input('Encounter.billing_status', array('class' => 'textBoxExpnd validate[required,custom[mandatory-select]] ','empty'=>__('Please Select'), 'id' => 'billing_status','options'=>Configure::read('billing_status'), 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
		<td class="tdLabel" id="boxSpace" width="25%"></td>
		<td width="25%"></td>
	</tr>
	<tr>
	<td width="50%" colspan="2" style="padding-left:2px;padding-right:2px;" valign="top">
	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="formFull" >
	<tr class="row_title">
	<td class="tdLabel" id="boxSpace" width="19%" align="left" colspan="3">
	<strong><?php echo __('Type'); ?></strong>
	</td>
	</tr>	
	<tr>
	<td width="13%" class="tdLabel" id="boxSpace">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
			<td valign="top"><?php if(in_array("Employment",$this->data['Encounter']['accident_clk'])){ 
			}
			$this->request->data['Encounter']['accident_clk'] = explode('|',$this->request->data['Encounter']['accident_clk']);
			//debug($this->request->data['Encounter']['accident_clk']['1']);exit;
			echo $this->Form->input('Encounter.accident_clk', array('type'=>'checkbox','hiddenField' => false,'name'=>'data[Encounter][accident_clk][]','value'=>'EM','checked'=>$this->request->data['Encounter']['accident_clk']['0'])); ?>
				&nbsp;<?php echo __("Employment");?></td>
		</tr>
		<tr>
			<td><?php  if(in_array("Auto Accident",$this->data['Encounter']['accident_clk'])){ 									
			}
			echo $this->Form->input('Encounter.accident_clk', array('type'=>'checkbox','hiddenField' => false,'name'=>'data[Encounter][accident_clk][]','value'=>'AA','checked'=>$this->request->data['Encounter']['accident_clk']['1'])); ?>
				&nbsp;<?php echo __("Auto Accident");?></td>
		</tr>
		<tr>
			<td><?php   if(in_array("Other Accident",$this->data['Encounter']['accident_clk'])){ 								
			}
			echo $this->Form->input('Encounter.accident_clk', array('type'=>'checkbox','hiddenField' => false,'name'=>'data[Encounter][accident_clk][]','value'=>'OA','checked'=>$this->request->data['Encounter']['accident_clk']['2'])); ?>
				&nbsp;<?php echo __("Other Accident");?></td>
		</tr></table>
	
	<?php //echo $this->Form->input('Encounter.employment', array('empty'=>__('Please Select'),'class'=>'textBoxExpnd','options'=>array('Yes'=>'Yes','No'=>'No'), 'id' => 'employment', 'label'=> false, 'div' => false, 'error' => false));
	?>
	</td>
	<td class="tdLabel" id="boxSpace" width="12%" valign="top"><?php echo __('States'); ?>
	</td>
	<td width="25%" valign="top"><?php echo $this->Form->input('Encounter.state', array('id' => 'state','empty'=>__('Please Select'),'options'=>$getstateInfo, 'label'=> false, 'div' => false, 'error' => false,'class'=>'textBoxExpnd'));
	?></td>
	</tr>	
	</table>	
	</td>
	<td width="50%" colspan="2" valign="top" style="padding-right:2px;padding-left:2px;">	
	<table border="0" cellpadding="0" cellspacing="0" width="100%"	height="108px"  class="formFull">
	<tr class="row_title">
	<td class="tdLabel" id="boxSpace" width="19%" align="left" colspan="2">
	<strong><?php echo __('Special Program Code'); ?></strong>
	</td>
	</tr>
	<tr>
	<td class="tdLabel" id="boxSpace" width="25%"><?php echo __('Special Program'); ?>
		</td>
		<td width="25%"><?php 
					echo $this->Form->input('Encounter.special_program', array('type'=>'text','class'=>'textBoxExpnd', 'id' => 'special_program', 'label'=> false, 'div' => false, 'error' => false));
					?>
					</td>
					</tr>
					<tr>
					<td class="tdLabel" id="boxSpace" width="25%"><?php echo __('Delay Reason'); ?>
					</td>
					<td width="25%"><?php echo $this->Form->input('Encounter.delay_reason', array('id' => 'delay_reason','empty'=>__('Please Select'),'options'=>Configure::read('delay_reason'), 'label'=> false, 'div' => false, 'error' => false,'class'=>'textBoxExpnd'));
					?> <?php //echo __('(HCFA Box #19)'); ?></td>
				</tr>	
</table>
</td>
</tr>	
<table border="0" cellpadding="0" cellspacing="0" width="100%"
	class="formFull" align="center">
	<tr>
		<td colspan="2" valign="top">
			<table border="0" cellpadding="0" cellspacing="0" width="100%"
				align="center">
				<tr>
					<td valign="top" width="50%">
						<table border="0" cellpadding="0" cellspacing="0" width="100%"
							valign="top" style="padding-left: 2px; padding-right: 2px;">
							<tr>
								<td width="50%" valign="top">
									<table border="0" cellpadding="0" cellspacing="0"
										class="formFull" width="100%" valign="top">
										<tr>
											<td width="1%"><div id='icdError'></div></td>
											<td class="tdLabel " id="boxSpace" width="47%"><strong> <?php echo __('ICD-9 Codes'); ?>
											</strong>
											</td>
											<td width="47%"><?php 
											echo $this->Form->input('Encounter.icd_codes12', array('class' => '','type'=>'text', 'id' => 'icd_codes', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:334px;','placeholder'=>'Find Diagnosis codes'));
											?>
											</td>
											<td width="5%"><?php echo $this->Html->link($this->Html->image('/img/icons/search_icon.png',array('title'=>'Search','alt'=>'Search')),'javascript:void(0)', array('escape' => false,'onclick'=>'getIcdDetails()')); ?>
											</td>
										</tr>
										<tr class="row_gray">
											<td colspan="4">
												<table border="0" cellpadding="0" cellspacing="0"
													width="100%" id='icdTable'>
													<tr>
														<td class="tdLabel" id="boxSpace" width="33%"><strong> <?php echo __('#'); ?>
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="33%"><strong><?php echo __('Code'); ?>
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="33%"><strong><?php echo __('Description'); ?>
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="33%"><strong><?php echo __('Action'); ?>
														</strong>
														</td>
													</tr>														
													<?php //debug($getIcdData);exit;
													if(!empty($getIcdData)){ 
														foreach($getIcdData as $key=>$data){ ?>
													<tr id=data<?php echo $key ?>>
														<td class="tdLabel" id="boxSpace" width="33%"><strong><?php echo $key+1; ?></strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="33%"><strong><?php echo $this->Form->hidden('',array('value'=>$data['SnomedMappingMaster']['icd9code'],'name'=>'Encounter[icd9code][]'));
														echo $data['SnomedMappingMaster']['icd9code']; ?>
														</strong></td>
														<td class="tdLabel" id="boxSpace" width="33%"><strong><?php echo $data['SnomedMappingMaster']['icd9name']; ?>
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="33%"><?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete','class'=>'removeIcd','id'=>"icdremove_$inc"));?>
														</td>
													</tr>
													<?php }
													}else if(!empty($icd_codes9)){
													foreach($icd_codes9 as $key=>$icd9){ 
													$idicd9=$icd9['NoteDiagnosis']['id'];?>													
														<tr id=preIcd<?php echo $idicd9.'icd';?>>
														<td class="tdLabel" id="boxSpace" width="33%"><strong><?php echo $key+1; ?>
														</strong>
														</td>
														<?php echo $this->Form->hidden('note_diagnosis_id',array('id'=>'note_daignosis_'.$idicd9,'value'=>$idicd9));?>
														<td class="tdLabel" id="boxSpace" width="33%"><strong><?php echo $this->Form->hidden('Encounter.icd9code',array('value'=>$icd9['NoteDiagnosis']['icd_id']));
														echo $icd9['NoteDiagnosis']['icd_id']; ?>
														</strong></td>
														<td class="tdLabel" id="boxSpace" width="33%"><strong><?php echo $icd9['NoteDiagnosis']['diagnoses_name']; ?>
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="33%"><?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete',
																'class'=>'pre_removeIcd','id'=>"icdremove_$idicd9".icd));?>
														</td>
													</tr>
													<?php }}
														else{?>
													<tr>
														<!-- <td colspan="8" align="center" class="error tdLabel"
															id="boxSpace"><?php //echo __('No record found', true); ?>
														</td>-->
													</tr>
													<?php } ?>
												</table>
											</td>
										</tr>
									</table>
								</td>
							
								<td  width="50%" valign="top">
									<table border="0" cellpadding="0" cellspacing="0"
										class="formFull" width="100%" valign="top">
										<tr>
											<td width="1%"><div id='ndcError'></div></td>
											<td class="tdLabel " id="boxSpace" width="47%"><strong> <?php echo __('NDC Codes'); ?>
											</strong>
											</td>
											<td width="47%"><?php 
											echo $this->Form->input('Encounter.ndc_codes12', array('class' => '','type'=>'text', 'id' => 'ndc_codes', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:334px;','placeholder'=>'Find NDC codes'));
											?>
											</td>
											<td width="5%"><?php echo $this->Html->link($this->Html->image('/img/icons/search_icon.png',array('title'=>'Search','alt'=>'Search')),'javascript:void(0)', array('escape' => false,'onclick'=>'getNdcDetails1()')); ?>
											</td>
										</tr>
										<tr class="row_gray">
											<td colspan="4">
												<table border="0" cellpadding="0" cellspacing="0"
													width="100%" id='NdcTable'>
													<tr>
														<td class="tdLabel" id="boxSpace" width="33%"><strong> <?php echo __('NDC Code'); ?>
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="33%"><strong><?php echo __('Descrption'); ?>
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="33%"><strong><?php echo __('MedId'); ?>
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="33%"><strong><?php echo __('Action'); ?>
														</strong>
														</td>
													</tr>
													<?php if(!empty($getncdDetails)) {
														foreach( $getncdDetails as $key=>$data){
														?>
													<tr id=<?php echo $data['NdcMaster']['id'] ?>><?php echo $this->Form->hidden('',array('value'=>$data['NdcMaster']['NDC'],'name'=>'Encounter[ndccode][]'));?>
														<td class="tdLabel" id="boxSpace" width="33%"><strong><?php echo $data['NdcMaster']['NDC']; ?>
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="33%"><strong> <?php echo $data['NdcMaster']['LN']; ?>
														</strong>
														</td>														
														<td class="tdLabel" id="boxSpace" width="33%"><strong><?php echo $data['NdcMaster']['MEDID']; ?>
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="33%"><strong><?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete','class'=>'removeNDC','id'=>"ndcremove"));?>
														</strong>
														</td>
													</tr>
													<?php }
														}elseif(!empty($ncdCode)){
																foreach($ncdCode as $ndc){?>
																<tr id=<?php echo ndc.$ndc['NewCropPrescription']['id'];?>>
														<td class="tdLabel" id="boxSpace" width="33%"><strong> <?php echo $ndc['NdcMaster']['NDC']; ?>
														</strong>
														</td>
														<?php
														$ncdId=$ndc['NewCropPrescription']['id'];
														echo $this->Form->hidden('newcrop_prescription_id',array('id'=>'newcrop_prescription_'.$ncdId,'value'=>$ncdId));?>
														<td class="tdLabel" id="boxSpace" width="33%"><strong><?php echo $ndc['NdcMaster']['LN']; ?>
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="33%"><strong><?php echo $ndc['NdcMaster']['MEDID']; ?>
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="33%"><strong><?php echo $this->Html->image('/img/icons/cross.png',
																 array('alt'=>'Delete','title'=>'delete','class'=>'delete_ndcremove','id'=>"ndcremove_$ncdId")); ?>
														</strong>
														</td>
													</tr>
														<?php }}else{?>
													<tr>
													<!--  	<td colspan="4" align="center" class="error tdLabel"
															id="boxSpace"><?php //echo __('No record found', true); ?>
														</td>-->
													</tr>
													<?php } ?>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>

							<!-- <tr>
								<td>
									<table border="0" cellpadding="0" cellspacing="0"
										class="formFull" width="100%" valign="top">
										<tr>
											<td width="1%"><div style='text-align: center; color: red'
													id='errorDiv'></div></td>
											<td class="tdLabel " id="boxSpace" width="47%"><strong><?php echo __('APC Codes'); ?>
											</strong>
											</td>
											<td width="47%"><span id='apcs1'><?php 
											echo $this->Form->input('Encounter.apc_codes12', array('class' => 'apcs1','type'=>'text', 'id' => 'apc_codes', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:334px;','placeholder'=>'Find APC codes'));
											?> </span><span id='apcs2' style='display: none'><?php
											echo $this->Form->input('Encounter.apc_codes', array('class' => 'apcs2','type'=>'text', 'id' => 'apc_codes2', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:334px;','placeholder'=>'Find By Name'));
											?> </span> <?php echo $this->Form->input('Encounter.check_for_apcs',array('type'=>'checkbox','id'=>'checkForApcs','name'=>'[Encounter][chk]'))."Check to search by Name";?>
											</td>
											<td width="5%"><?php echo $this->Html->link($this->Html->image('/img/icons/search_icon.png',array('title'=>'Search','alt'=>'Search')),'javascript:void(0)', array('escape' => false,'onclick'=>'getAPCSDetails1()')); ?>
											</td>
											<td>&nbsp;</td>
										</tr>
										<tr class="row_gray">
											<td colspan="4">
												<table border="0" cellpadding="0" cellspacing="0"
													width="100%" id='acpcsTable1'>
													<tr>
														<td class="tdLabel" id="boxSpace" width="33%"><strong> <?php echo __('APC Code'); ?>
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="33%"><strong><?php echo __('Name'); ?>
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="33%"><strong><?php echo __('Price'); ?>
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="33%"><strong><?php echo __('Action'); ?>
														</strong>
														</td>
													</tr>
														<?php if(!empty($getapcsDetails)) {
															foreach( $getapcsDetails as $key=>$data){
														?>
													<tr id=dataApc<?php echo $key ?>><?php echo $this->Form->hidden('',array('value'=>$data['TariffList']['apc'],'name'=>'Encounter[apccode][]'));?>
														<td class="tdLabel" id="boxSpace" width="33%"><strong><?php echo $data['TariffList']['apc']; ?>
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="33%"><strong> <?php echo $data['TariffList']['name']; ?>
														</strong>
														</td>														
														<td class="tdLabel" id="boxSpace" width="33%"><strong><?php echo $data['TariffList']['price_for_private']; ?>
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="33%"><strong><?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete','class'=>'removeAPC','id'=>"apcremove_$key"));?>
														</strong>
														</td>
													</tr>
													<?php }
}else{?>
													<tr>
														<td colspan="4" align="center" class="error tdLabel"
															id="boxSpace"><?php echo __('No record found', true); ?>.
														</td>
													</tr>
													<?php } ?>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr> -->

						</table>
					</td>


					<!--<td valign="top" width="50%">
						 comment For  ml <table border="0" cellpadding="0" cellspacing="0" align="center"
							width="100%" style="padding-right: 2px;">
							<tr>
								<td>
									<table cellpadding="0" cellspacing="0" width="100%"
										class="formFull">
										<tr>
											<td class="tdLabel " id="boxSpace" width="47%"><strong> <?php echo __('CPT Codes'); ?>
											</strong>
											</td>
											<td width="47%"><?php echo $this->Form->input('Encounter.cpt_codes12', array('class' => 'ctpSearch','type'=>'text', 'id' => 'cptSerach', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:334px;','placeholder'=>'Find CPT Procedure codes'));
											?>
											</td>
											<td width="5%"><?php echo $this->Html->link($this->Html->image('/img/icons/search_icon.png',array('title'=>'Search','alt'=>'Search')),'javascript:void(0)', array('escape' => false,'onclick'=>'getCptCodeDetials()')); ?>
											</td>																				
										</tr>
										<tr class="row_gray">
											<td colspan="8">
												<table border="0" cellpadding="0" cellspacing="0"
													width="100%" id='cptTable'>
													<tr>
														<td class="tdLabel" id="boxSpace" width="13%"><strong> <?php echo __('Code'); ?>
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="13%"><strong><?php echo __('Description'); ?>
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="13%"><strong><?php echo __('Price'); ?>
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="13%"><strong><?php echo __('Modifer');?>
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="13%"><strong><?php echo __('Modifer');?>
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="13%"><strong><?php echo __('Modifer');?>
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="13%"><strong><?php echo __('Modifer');?>
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="13%"><strong><?php echo __('Action');?>
														</strong>
														</td>
													</tr>
												</table>
										
										</tr>
											<?php if(!empty($getcptDetails)) {
													foreach( $getcptDetails as $key=>$data){
														?>
													<tr id=dataCpt<?php echo $key ?>><?php echo $this->Form->hidden('',array('value'=>$data['TariffList']['cbt'],'name'=>'Encounter[cptcode][]'));?>
														<td class="tdLabel" id="boxSpace" width="13%"><strong><?php echo $data['TariffList']['cbt']; ?>
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="13%"><strong> <?php echo $data['TariffList']['name']; ?>
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="13%"><strong><?php echo $data['TariffList']['price_for_private']; ?>
														
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="13%"><strong><?php echo $this->Form->input('',array('empty'=>__('Please Select'),'options'=>$getModifiers,'name'=>'Encounter[modifiers1edit][]','value'=>$getcptDetails['Encounter']['modifiers1'],'style'=>'width:100px'));?>
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="13%"><strong><?php echo $this->Form->input('',array('empty'=>__('Please Select'),'options'=>$getModifiers,'name'=>'Encounter[modifiers2edit][]','value'=>$getcptDetails['Encounter']['modifiers2'],'style'=>'width:100px'));?>
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="13%"><strong><?php echo $this->Form->input('',array('empty'=>__('Please Select'),'options'=>$getModifiers,'name'=>'Encounter[modifiers3edit][]','value'=>$getcptDetails['Encounter']['modifiers3'],'style'=>'width:100px'));?>
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="13%"><strong><?php echo $this->Form->input('',array('empty'=>__('Please Select'),'options'=>$getModifiers,'name'=>'Encounter[modifiers4edit][]','value'=>$getcptDetails['Encounter']['modifiers4'],'style'=>'width:100px'));?>
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="13%"><strong><?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete','class'=>'removecpt','id'=>"cptremove_$key"));?>
														</strong>
														</td>
													</tr>
													<?php }}elseif(!empty($cptCode)){
													foreach($cptCode as $cptCode){debug($cptCode);?>
													<tr id=<?php echo cpt_pp.$cptCode['ProcedurePerform']['id']; ?>><?php echo $this->Form->hidden('',array('value'=>$cptCode['ProcedurePerform']['snowmed_code'],'name'=>'Encounter[cptcode][]'));?>
														<td class="tdLabel" id="boxSpace" width="13%"><strong><?php echo $cptCode['ProcedurePerform']['snowmed_code']; ?>
														</strong>
														<?php $cptCode_pp=$cptCode['ProcedurePerform']['id'];
														echo $this->Form->hidden('pp_cpt',array('id'=>'cpt_pp_'.$cptCode_pp,'value'=>$cptCode_pp));?>
														</td>
														<td class="tdLabel" id="boxSpace" width="13%"><strong> <?php echo $cptCode['ProcedurePerform']['procedure_name']; ?>
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="13%"><strong><?php echo $cptCode['TariffAmount']['non_nabh_charges']; ?>
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="13%"><strong><?php echo $this->Form->input('',array('empty'=>__('Please Select'),'options'=>$getModifiers,'name'=>'Encounter[modifiers1edit][]','value'=>$cptCode['ProcedurePerform']['modifier1'],'style'=>'width:100px'));?>
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="13%"><strong><?php echo $this->Form->input('',array('empty'=>__('Please Select'),'options'=>$getModifiers,'name'=>'Encounter[modifiers2edit][]','value'=>$cptCode['ProcedurePerform']['modifier2'],'style'=>'width:100px'));?>
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="13%"><strong><?php echo $this->Form->input('',array('empty'=>__('Please Select'),'options'=>$getModifiers,'name'=>'Encounter[modifiers3edit][]','value'=>$cptCode['ProcedurePerform']['modifier3'],'style'=>'width:100px'));?>
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="13%"><strong><?php echo $this->Form->input('',array('empty'=>__('Please Select'),'options'=>$getModifiers,'name'=>'Encounter[modifiers4edit][]','value'=>$cptCode['ProcedurePerform']['modifier4'],'style'=>'width:100px'));?>
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="13%"><strong><?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete','class'=>'delete_removecpt','id'=>"cptremove_$cptCode_pp"));?>
														</strong>
														</td>
													</tr>
													<?php }}else{?>
															<tr><td colspan="8" align="center" class="error tdLabel" id="boxSpace"><?php echo __('No record found', true); ?>.
															</td></tr>
													<?php } ?>-->
										<!-- <tr>
											<td class="tdLabel" id="boxSpace" width="37%"><strong><font
													color="#6C95AC"><?php //echo __('1'); ?>&nbsp;&nbsp;&nbsp;<?php echo __('99347'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo __('HOME VISIT EST PATIENT'); ?>
												</font> </strong></td>
											<td width="11%"><?php //echo $this->Form->input('Encounter.codes_home1', array('class' => '','type'=>'text', 'id' => 'codes_home', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:334px;','placeholder'=>''));?>
												<?php //echo $this->Html->link($this->Html->image('icons/cross.png',array('title'=>'Delete','alt'=>'Delete')), array('action' => 'addBeforeClaim', $tariff['TariffStandard']['id']), array('escape' => false,'style'=>'float:right;padding-right:10px;'),__('Are you sure?', true)); ?>
											</td>
										</tr>
										<tr>
											<td class="tdLabel" id="boxSpace" width="37%"><?php echo __('99347 Modifiers:'); ?>
											</td>
											<td width="11%"><?php 
											echo $this->Form->input('Encounter.modifiers1', array('class' => '', 'id' => 'modifiers1','empty'=>__('Please Select'),'options'=>'', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:81px;','placeholder'=>''));
											?> <?php
											echo $this->Form->input('Encounter.modifiers2', array('class' => '', 'id' => 'modifiers2','empty'=>__('Please Select'),'options'=>'', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:81px;','placeholder'=>''));
											?> <?php
											echo $this->Form->input('Encounter.modifiers3', array('class' => '', 'id' => 'modifiers3','empty'=>__('Please Select'),'options'=>'', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:80px;','placeholder'=>''));
											?> <?php
											echo $this->Form->input('Encounter.modifiers4', array('class' => '', 'id' => 'modifiers4','empty'=>__('Please Select'),'options'=>'', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:80px;','placeholder'=>''));
											?>
											</td>
										</tr>
										<tr>
											<td class="tdLabel" id="boxSpace" width="37%"><?php echo __('Quantity/Minutes:'); ?>
											</td>
											<td width="11%"><?php 
											echo $this->Form->input('Encounter.quantity1', array('class' => '','type'=>'text', 'id' => 'quantity1', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:334px;','placeholder'=>''));
											?>
											</td>
										</tr>
										<tr>
											<td class="tdLabel" id="boxSpace" width="37%"><?php echo __('Diagnosis Pointers:'); ?>
											</td>
											<td width="11%"><?php 
											echo $this->Form->input('Encounter.diagnosis_pointers1', array('class' => '','type'=>'text', 'id' => 'diagnosis_pointers1', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:334px;','placeholder'=>''));
											?>
											</td>
										</tr>
										<tr>
											<td class="tdLabel" id="boxSpace" width="37%"><strong><font
													color="#6C95AC"><?php echo __('2'); ?>&nbsp;&nbsp;&nbsp;<?php echo __('99174'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo __('OCULAR INSTRUMNT SCREEN BILL'); ?>
												</font> </strong></td>
											<td width="11%"><?php echo $this->Form->input('Encounter.codes_home2', array('class' => '','type'=>'text', 'id' => 'cpt_codes1', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:334px;','placeholder'=>''));?>
												<?php echo $this->Html->link($this->Html->image('icons/cross.png',array('title'=>'Delete','alt'=>'Delete')), array('action' => 'addBeforeClaim', $tariff['TariffStandard']['id']), array('escape' => false,'style'=>'float:right;padding-right:10px;'),__('Are you sure?', true)); ?>
											</td>
										</tr>
										<tr>
											<td class="tdLabel" id="boxSpace" width="37%"><?php echo __('99174 Modifiers:'); ?>
											</td>
											<td width="11%"><?php 
											//echo $this->Form->input('Encounter.modifiers5', array('class' => '', 'id' => 'modifiers5','empty'=>__('Please Select'),'options'=>'', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:81px;','placeholder'=>''));
											?> <?php
											//echo $this->Form->input('Encounter.modifiers6', array('class' => '', 'id' => 'modifiers6','empty'=>__('Please Select'),'options'=>'', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:81px;','placeholder'=>''));
											?> <?php
											//echo $this->Form->input('Encounter.modifiers7', array('class' => '', 'id' => 'modifiers7','empty'=>__('Please Select'),'options'=>'', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:80px;','placeholder'=>''));
											?> <?php
											//echo $this->Form->input('Encounter.modifiers8', array('class' => '', 'id' => 'modifiers8','empty'=>__('Please Select'),'options'=>'', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:80px;','placeholder'=>''));
											?>
											</td>
										</tr>
										<tr>
											<td class="tdLabel" id="boxSpace" width="37%"><?php echo __('Quantity/Minutes:'); ?>
											</td>
											<td width="11%"><?php 
											echo $this->Form->input('Encounter.quantity2', array('class' => '','type'=>'text', 'id' => 'quantity2', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:334px;','placeholder'=>''));
											?>
											</td>
										</tr>
										<tr>
											<td class="tdLabel" id="boxSpace" width="37%"><?php echo __('Diagnosis Pointers:'); ?>
											</td>
											<td width="11%"><?php 
											echo $this->Form->input('Encounter.diagnosis_pointers2', array('class' => '','type'=>'text', 'id' => 'diagnosis_pointers2', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:334px;','placeholder'=>''));
											?>
											</td>
										</tr> -->

								<!-- 	</table>
								</td>
							</tr>

							<tr>
								<td>
									<table border="0" cellpadding="0" cellspacing="0"
										class="formFull" width="100%">
										<tr>
											<td width="1%"><div id='errorDiv' style="display: none"></div>
											</td>
											<td class="tdLabel " id="boxSpace" width="47%"><strong> <?php echo __('HCPCS Codes'); ?>
											</strong>
											</td>
											<td width="47%"><?php 
											echo $this->Form->input('Encounter.hcpcs_codes11', array('class' => 'hcpcs','type'=>'text', 'id' => 'hcpcs_codes', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:334px;','placeholder'=>'Find HCPS Procedure codes'));
											?> <?php echo $this->Form->input('Encounter.check_for_name',array('type'=>'checkbox','id'=>'checkForName','name'=>'chk'))."Check to search by Name";?>
											</td>
											<td width="5%"><?php echo $this->Html->link($this->Html->image('/img/icons/search_icon.png',array('title'=>'Search','alt'=>'Search')),'javascript:void(0)', array('escape' => false,'onclick'=>'getHCPCSDetails()')); ?>
											</td>

										</tr>
										<tr class="row_gray">
											<td colspan="4">
												<table border="0" cellpadding="0" cellspacing="0"
													width="100%" id='hcpcsTable'>
													<tr>
														<td class="tdLabel" id="boxSpace" width="33%"><strong><?php echo __('Code'); ?>
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="33%"><strong> <?php echo __('Description'); ?>
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="33%"><strong><?php echo __('Price'); ?>
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="33%"><strong><?php echo __('Action'); ?>
														</strong>
														</td>
													</tr>
														<?php if(!empty($hcpsDetails)) {
															foreach( $hcpsDetails as $key=>$data){
														?>
													<tr id=dataHcpcs<?php echo $key ?>><?php echo $this->Form->hidden('',array('value'=>$data['TariffList']['hcpcs'],'name'=>'Encounter[hcpcscode][]'));?>
														<td class="tdLabel" id="boxSpace" width="33%"><strong><?php echo $data['TariffList']['hcpcs']; ?>
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="33%"><strong> <?php echo $data['TariffList']['name']; ?>
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="33%"><strong><?php echo $data['TariffList']['price_for_private']; ?>
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="33%"><strong><?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete','class'=>'removeHcpcs','id'=>"hcpcsremove_$key"));?>
														</strong>
														</td>
													</tr>
													<?php }
															}else if(!empty($hcpcsCode)){
																foreach($hcpcsCode as $hcpcsCode){?>
																<tr id=<?php echo pro_perform.$hcpcsCode['ProcedurePerform']['id'] ?>><?php echo $this->Form->hidden('',array('value'=>$data['TariffList']['hcpcs'],'name'=>'Encounter[hcpcscode][]'));?>
														<td class="tdLabel" id="boxSpace" width="33%"><strong><?php echo $hcpcsCode['ProcedurePerform']['snowmed_code']; ?>
														</strong>
														</td>
														<?php $idhpcs=$hcpcsCode['ProcedurePerform']['id'];
														echo $this->Form->hidden('',array('id'=>'hcpcs_pp'.$idhpcs,'value'=>$idhpcs));?>
														<td class="tdLabel" id="boxSpace" width="33%"><strong> <?php echo $hcpcsCode['ProcedurePerform']['procedure_name']; ?>
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="33%"><strong><?php echo $this->Number->currency($hcpcsCode['TariffAmount']['non_nabh_charges']); ?>
														</strong>
														</td>
														<td class="tdLabel" id="boxSpace" width="33%"><strong><?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete','class'=>'delete_removeHcpcs','id'=>"hcpcsremove_$idhpcs"));?>
														</strong>
														</td>
													</tr>
															<?php }}else{?>
													<tr>
														<td colspan="4" align="center" class="error tdLabel"
															id="boxSpace"><?php echo __('No record found', true); ?>.
														</td>
													</tr>
													<?php } ?>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>-->
				</tr>
			</table>
		</td>
	</tr>
</table>
<?php

echo $this->Form->input('Encounter.apc_codes', array('type'=>'hidden', 'id' => 'apc_codes_dyna', 'label'=> false, 'div' => false, 'error' => false));
echo $this->Form->input('Encounter.ndc_codes', array('type'=>'hidden', 'id' => 'ndc_codes_dyna', 'label'=> false, 'div' => false, 'error' => false));
echo $this->Form->input('Encounter.hcpcs_codes', array('type'=>'hidden', 'id' => 'hcps_codes_dyna', 'label'=> false, 'div' => false, 'error' => false));
echo $this->Form->input('Encounter.icd_codes', array('type'=>'hidden', 'id' => 'icd_codes_dyna', 'label'=> false, 'div' => false, 'error' => false));
echo $this->Form->input('Encounter.cpt_codes', array('type'=>'hidden', 'id' => 'cpt_codes_dyna', 'label'=> false, 'div' => false, 'error' => false));

?>
<div class="btns">
	<?php
	//echo "&nbsp;&nbsp;".$this->Form->submit('Save & Close',array('class'=>'blueBtn','div'=>false,'id'=>'submit','title'=>'Save & Close'));
	echo "&nbsp;&nbsp;".$this->Form->submit('Save',array('class'=>'blueBtn','div'=>false,'id'=>'EncounterSubmit','title'=>'Save'));
	//echo "&nbsp;&nbsp;".$this->Form->submit('Delete',array('class'=>'blueBtn','div'=>false,'id'=>'submit','title'=>'Delete'));
	echo $this->Html->link(__('Cancel'),array('action' => 'addBeforeClaim'),array('escape' => false,'class'=>'grayBtn','title'=>'Cancel'));
	?>
</div>
<?php // debug($getModifiers);exit;?>
<div id="cptCodes1" style="display: none">
	<select style="width: 100px" name="data[Encounter][modifiers1][]"><option
			value="">Please Select</option>
		<?php  foreach ($getModifiers as $data){?>
		<option value=<?php echo $data['BillingOtherCode']['code']?>>
			<?php echo $data['BillingOtherCode']['name']?>
		</option>
		<?php }?>
	</select>
</div>
<div id="cptCodes2" style="display: none">
	<select style="width: 100px" name="data[Encounter][modifiers2][]"><option
			value="">Please Select</option>
		<?php  foreach ($getModifiers as $data){?>
		<option value=<?php echo $data['BillingOtherCode']['code']?>>
			<?php echo $data['BillingOtherCode']['name']?>
		</option>
		<?php }?>
	</select>
</div>
<div id="cptCodes3" style="display: none">
	<select style="width: 100px" name="data[Encounter][modifiers3][]"><option
			value="">Please Select</option>
		<?php  foreach ($getModifiers as $data){?>
		<option value=<?php echo $data['BillingOtherCode']['code']?>>
			<?php echo $data['BillingOtherCode']['name']?>
		</option>
		<?php }?>
	</select>
</div>
<div id="cptCodes4" style="display: none">
	<select style="width: 100px" name="data[Encounter][modifiers4][]"><option
			value="">Please Select</option>
		<?php  foreach ($getModifiers as $data){?>
		<option value=<?php echo $data['BillingOtherCode']['code']?>>
			<?php echo $data['BillingOtherCode']['name']?>
		</option>
		<?php }?>
	</select>
</div>
<?php echo $this->Form->end(); ?>
<script>
$(document).ready(function(){
	$('#billing_status').focus();	
	 });
$(document).ready(function(){
	
	$('#billing_profile_name').focus();
	
	
if('<?php echo $setFlash == '1'?>'){
	parent.location.reload();
	//parent.window.location.href = "<?php echo $this->Html->url(array("controller"=>"Insurances", "action" => "addNewEncounter","admin" => false)); ?>"
	parent.$.fancybox.close();
	
}
});
//***************************************For CPT*********************************************************************************************************************
$('#cptSerach').autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","TariffList","name",'null',"no",'no',"admin" => false,"plugin"=>false)); ?>",
		{
			width : 250,
			selectFirst : true
		});
var calling_url_ctp = "<?php echo $this->Html->url(array("controller" => 'Insurances', "action" => "searchCpt","admin" => false)); ?>" ;
function getCptCodeDetials(){
	var codeCtp=$('#cptSerach').val();	
	if(httpRequest) httpRequest.abort();
		var httpRequest = $.ajax({
			  beforeSend: function(){
				  $('#busy-indicator').show('fast');
			  },
		      url: calling_url_ctp+"/"+codeCtp,
		      context: document.body,
		      success: function(data){ 
		    	  $('#busy-indicator').hide('fast');
		    	  data= JSON && JSON.parse(data) || $.parseJSON(data);
		    	  var checkValue=data.code;
		    	  if(checkValue!=null){
		    	 	 addRowWithCptSDetails(data,'');
		    	  }
		    	  else{
		    		  $('#errorDiv').show();
			    	  $('#errorDiv').html('Check code');
		    	  }
			  },
			  error:function(){
					alert('Please try again');
				  }
		});
}
 var cptcnt=0;
 var selectedCPTCodeIndexArr = new Array();
 var selectedCPTCodeArr = new Array(); 
function addRowWithCptSDetails(data,pickedId){
	 if(data != '' && data !== undefined){
		$("#cptTable").find('tbody')
	    .append($('<tr>').attr('class', '').attr('id', 'dataCpt'+cptcnt)
	    .append($('<td class="tdLabel" id="boxSpace">').text(data.code))
	    .append($('<td class="tdLabel" id="boxSpace" >').text(data.name))	
	    .append($('<td class="tdLabel" id="boxSpace" width=10px colspan=0 >').text(cptcnt))	    	
	    .append($('<td class="tdLabel" id="boxSpace" >').append($('#cptCodes1').html()))
        .append($('<td class="tdLabel" id="boxSpace">').append($('#cptCodes2').html()))
		.append($('<td class="tdLabel id="boxSpace"">').append($('#cptCodes3').html()))
		.append($('<td class="tdLabel id="boxSpace"">').append($('#cptCodes4').html()))
	    .append($('<td style="padding-left:25px">').attr('class','removecpt').attr('id', 'removecpt_'+cptcnt).html('<?php echo $this->Html->image('/img/icons/cross.png', array('alt' => 'Remove'));?>'))
        .append($('<input>').attr({type:"hidden", name:"data[Encounter]["+cptcnt+"][cpt_codes]",value:data.code}))
       ); 
	
		//addBlankRow();		
	}
	 selectedCPTCodeIndexArr.push(cptcnt);
	 selectedCPTCodeArr.push(data.code);
	 cptcnt++;	 
}
$(".removecpt").live( "click", function() {
    var currentId=$(this).attr('id');
    if(confirm("Do you really want to delete this record?")){
    var trRemove=currentId.split('_');
    $('#dataCpt'+trRemove[1]).remove();
    var pid=$('#patientId').val(); 
    delete_code('cpt',trRemove[1],pid);
    }else{
    	return false;
    }
    selectedCPTCodeArr.splice( $.inArray(trRemove[1], selectedCPTCodeArr), 1 );
    selectedCPTCodeIndexArr.splice( $.inArray(trRemove[1], selectedCPTCodeArr), 1 );
});

//*******************************************************************************************************************************************************************
//------------------------------FOR HCPCS-----------------------------------------------------------------------------------------------------------------------------
$('#hcpcs_codes').autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","TariffList","hcpcs",'null',"no",'no',"admin" => false,"plugin"=>false)); ?>",
		{
			width : 250,
			selectFirst : true
		});
var calling_url = "<?php echo $this->Html->url(array("controller" => 'Insurances', "action" => "hcpcsSearch","admin" => false)); ?>" ;
var timeoutReference;
$(function() {
	$('.hcpcs').live('keyup',function() { 
		var _this = $(this); // copy of this object for further usage
	    
	    if (timeoutReference) clearTimeout(timeoutReference);
	    timeoutReference = setTimeout(function() {
	    	//getHCPCSDetails()
	    }, 2000);
	});
	});

function getHCPCSDetails(){
	var checkName=$('#checkForName:checked').length;
	var codeHCPS=$('#hcpcs_codes').val();
	if(checkName==1){
		var nameHCPS=checkName;
	}else{
		var nameHCPS='';
	}
	//var cdmCode = $('#hcpcs_codes').html().replace("&nbsp;","");
	if(httpRequest) httpRequest.abort();
	//if(lastCDMCode != cdmCode){
		var httpRequest = $.ajax({
			  beforeSend: function(){
				  $('#busy-indicator').show('fast');
			  },
		      url: calling_url+"/"+codeHCPS+"/"+nameHCPS,
		      context: document.body,
		      success: function(data){ 
		    	  $('#busy-indicator').hide('fast');
		    	  data= JSON && JSON.parse(data) || $.parseJSON(data);
		    	  var checkValue=data.code;
		    	  $('#checkForName').val('0');
		    	  $('#hcpcs_codes').val('');
		    	  if(checkValue!=null){
			    	 
		    	 	 addRowWithHCPCSDetails(data,'');
		    	  }
		    	  else{
			    	 
		    		  $('#errorDiv').show();
			    	  $('#errorDiv').html('Check code');
		    	  }
		    	  
		    	  //onCompleteRequest(); //remove loading sreen
		    	  //$("#excelArea").html(data).fadeIn('slow');
			  },
			  error:function(){
					alert('Please try again');
					//onCompleteRequest(); //remove loading sreen
				  }
		});
	///}
}
hcpcsCnt=0;
var selectedHCPCSCodeIndexArr = new Array();
var selectedHCPCSCodeArr = new Array(); 
function addRowWithHCPCSDetails(data,pickedId){
	 if(data != '' && data !== undefined){
	//	$('#hcpcsTable' tr:last').remove();
		$("#hcpcsTable").find('tbody')
		
	    .append($('<tr>').attr('class', '').attr('id', 'data'+hcpcsCnt)
    	.append($('<td class="tdLabel" id="boxSpace">').text(data.code))
    	.append($('<td class="tdLabel" id="boxSpace">').text(data.name))			        
        .append($('<td class="tdLabel" id="boxSpace">').text('$'+data.price)) 
        .append($('<td style="padding-left:25px" >').attr('class','removeHcpcs').attr('id', 'removehcpcs_'+hcpcsCnt).html('<?php echo $this->Html->image('/img/icons/cross.png', array('alt' => 'Remove'));?>'))
        .append($('<input>').attr({type:"hidden", name:"data[Encounter]["+hcpcsCnt+"][hcpcs_codes]",value:data.code}))); 
	      
		selectedHCPCSCodeIndexArr.push(hcpcsCnt);
		selectedHCPCSCodeArr.push(data.code);
		$('#data'+data.code).remove();
		//addBlankRow();
		
	}
}
$(".removeHcpcs").live( "click", function() {
    var currentId=$(this).attr('id');
    if(confirm("Do you really want to delete this record?")){
    var trRemove=currentId.split('_');
    $('#dataHcpcs'+trRemove[1]).remove();
    var pid=$('#patientId').val(); 
    delete_code('hcpcs',trRemove[1],pid);
    }else{
    	return false;
    }
    selectedHCPCSCodeArr.splice( $.inArray(trRemove[1], selectedHCPCSCodeArr), 1 );
    selectedHCPCSCodeIndexArr.splice( $.inArray(trRemove[1], selectedHCPCSCodeArr), 1 );
});

function addBlankRow(){
	$("#hcpcsTable").find('tbody')
    .append($('<tr>')
    		 .append($('<td contenteditable>').attr('class', 'searchCDM').attr('id', 'data').append('&nbsp;'))
			        .append($('<td>').text(''))
			        .append($('<td>').text(''))
			        .append($('<td>').text())
			       
    );
	
}
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//*******************************************************FOR APCS*****************************************************************************
$('.apcs1').autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","TariffList","apc",'null',"no",'no',"admin" => false,"plugin"=>false)); ?>",
		{
			width : 250,
			selectFirst : true
		});
		
$('.apcs2').autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","TariffList","name",'null',"no",'no',"admin" => false,"plugin"=>false)); ?>",
		{
			width : 250,
			selectFirst : true
		});
		$('#checkForApcs').change(function(){
			$('#apcs2').show();
			$('#apcs1').hide();
			$('#apc_codes').val('');
			});

 
var calling_url_apcs = "<?php echo $this->Html->url(array("controller" => 'Insurances', "action" => "apcsSearch","admin" => false)); ?>" ;
var timeoutReferenceApcs;
$(function() {
	$('.apcs1').live('keyup',function() { 
		var _this = $(this); // copy of this object for further usage
	    
	    if (timeoutReferenceApcs) clearTimeout(timeoutReferenceApcs);
	    timeoutReferenceApcs = setTimeout(function() {
	    	//getAPCSDetails1()
	    }, 2000);
	});
	});

function getAPCSDetails1(){
	var checkName=$('#checkForApcs:checked').length;
	var codeApcs=$('#apc_codes').val();
	if(checkName==1){
		var nameAcps=checkName;
	}else{
		var nameAcps='';
	}
	//var cdmCode = $('#hcpcs_codes').html().replace("&nbsp;","");
	if(httpRequest) httpRequest.abort();
	//if(lastCDMCode != cdmCode){
		var httpRequest = $.ajax({
			  beforeSend: function(){
				  $('#busy-indicator').show('fast');
			  },
		      url: calling_url_apcs+"/"+codeApcs+"/"+nameAcps,
		      context: document.body,
		      success: function(data){ 
		    	  $('#busy-indicator').hide('fast');
		    	  data= JSON && JSON.parse(data) || $.parseJSON(data);
		    	  //var checkValue=data.code;
		    	  $('#checkForApcs').val('0');
		    	  $('#apc_codes').val('');
		    	 	 addRowWithACPCSDetails1(data);
					  //onCompleteRequest(); //remove loading sreen
		    	  //$("#excelArea").html(data).fadeIn('slow');
			  },
			  error:function(){
					alert('Please try again');
					//onCompleteRequest(); //remove loading sreen
				  }
		});
	///}
} 
var cnt=0;
var selectedAPCCodeIndexArr = new Array();
var selectedAPCCodeArr = new Array(); 
function addRowWithACPCSDetails1(data){
	 if(data != '' && data !== undefined){//alert(data);
		 if(data.code==null){
				$('#errorDiv').show();
				$('#errorDiv').html('No Records Found.');
				return false;
		 }
		$("#acpcsTable1").find('tbody')
			  	.append($('<tr>').attr('class', '').attr('id', 'data'+cnt)	  	
			  	.append(($('<td class="tdLabel" id="boxSpace">').append($('<input>').attr({type:"hidden", name:"data[Encounter]["+cnt+"][apc_codes]",value:data.code})).text(data.code)))
			  	.append($('<td class="tdLabel" id="boxSpace">').text(data.name))
				.append($('<td class="tdLabel" id="boxSpace">').text(data.price))
				.append($('<td style="padding-left:25px">').attr('class','removeAPC').attr('id', 'remove_'+cnt).html('<?php echo $this->Html->image('/img/icons/cross.png', array('alt' => 'Remove'));?>')
		));
		selectedAPCCodeIndexArr.push(cnt);
		selectedAPCCodeArr.push(data.code);
	cnt++;
  }
}

$(".removeAPC").live( "click", function(){
    var currentId=$(this).attr('id');
    if(confirm("Do you really want to delete this record?")){
    var trRemove=currentId.split('_');
    $('#dataApc'+trRemove[1]).remove();
    var pid=$('#patientId').val(); 
    delete_code('apc',trRemove[1],pid);
    }else{
    	return false;
    }
    selectedAPCCodeArr.splice( $.inArray(trRemove[1], selectedAPCCodeArr), 1 );
    selectedAPCCodeIndexArr.splice( $.inArray(trRemove[1], selectedAPCCodeArr), 1 );
});

$("#EncounterSubmit").click(function(){
	var selAPCCodes = selectedAPCCodeArr.toString();
	$("#apc_codes_dyna").val(selAPCCodes);
	var selNDCCodes = selectedNDCCodeArr.toString();
	$("#ndc_codes_dyna").val(selNDCCodes);
	var selHCPSCodes = selectedHCPCSCodeArr.toString();
	$("#hcps_codes_dyna").val(selHCPSCodes);
	var selCPTCodes = selectedCPTCodeArr.toString();
	$("#cpt_codes_dyna").val(selCPTCodes);
	var selicdCodes = selectedicdCodeArr.toString();
	$("#icd_codes_dyna").val(selicdCodes);
});

    
function addBlankRow11(){
	$("#acpcsTable1").find('tbody')
    .append($('<tr>')
    		 .append($('<td contenteditable>').attr('class', 'searchCDM2').attr('id', 'data').append('&nbsp;'))
			        .append($('<td>').text(''))
			        .append($('<td>').text(''))
			        .append($('<td>').text())
			       
    );
	
}
//******************************************************************************NDC code*********************************************************************************************
$('#ndc_codes').autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","NdcMaster","NDC",'null',"no",'no',"admin" => false,"plugin"=>false)); ?>",
		{
			width : 250,
			selectFirst : true
		});

//var checkName=$('#checkForApcs:checked').length;
function getNdcDetails1(){
var calling_url_apcs = "<?php echo $this->Html->url(array("controller" => 'Insurances', "action" => "ndcSearch","admin" => false)); ?>" ;
var ncdcodes=$('#ndc_codes').val();
if(httpRequest) httpRequest.abort();
	var httpRequest = $.ajax({
		  beforeSend: function(){
			  $('#busy-indicator').show('fast');
		  },
	      url: calling_url_apcs+"/"+ncdcodes,
	      context: document.body,
	      success: function(data){ 
	    	  $('#busy-indicator').hide('fast');
	    	  data= JSON && JSON.parse(data) || $.parseJSON(data);
	    	 	 addRowWithNdcSDetails(data);
		  },
		  error:function(){
				alert('Please try again');
				//onCompleteRequest(); //remove loading sreen
			  }
	});
///}
} 
var ncdcode=0;
var selectedNDCCodeIndexArr = new Array();
var selectedNDCCodeArr = new Array();
function addRowWithNdcSDetails(data){
 if(data != '' && data !== undefined){//alert(data);
	 if(data.code==null){
			$('#ndcError').show();
			$('#ndcError').html('No Records Found.');
			return false;
	 }
	$("#NdcTable").find('tbody')
		  	.append($('<tr>').attr('class', '').attr('id', 'data'+ncdcode)	 
		  	.append(($('<td class="tdLabel" id="boxSpace">').text(data.code)))		  	
		  	.append($('<td class="tdLabel" id="boxSpace">').text(data.name))	
		  	.append($('<td class="tdLabel" id="boxSpace">').text(data.medid))		
			.append($('<td style="padding-left:25px">').attr('class','removeNDC').attr('id', 'remove_'+ncdcode).html('<?php echo $this->Html->image('/img/icons/cross.png', array('alt' => 'Remove'));?>'))
			.append($('<input>').attr({type:"hidden", name:"data[Encounter]["+ncdcode+"][ndc_codes]",value:data.code}))); 
	selectedNDCCodeIndexArr.push(ncdcode);
	selectedNDCCodeArr.push(data.code);
ncdcode++;
}
}

$(".removeNDC").live( "click", function() {
var currentId=$(this).attr('id');
if(confirm("Do you really want to delete this record?")){
var trRemove=currentId.split('_');
$('#dataNdc'+trRemove[1]).remove();
var pid=$('#patientId').val(); 
delete_code('ndc',trRemove[1],pid);
}else{
	return false;
}
selectedNDCCodeArr.splice( $.inArray(trRemove[1], selectedNDCCodeArr), 1 );
selectedNDCCodeIndexArr.splice( $.inArray(trRemove[1], selectedNDCCodeArr), 1 );
});
	
//**********************************************************IDC9 search*************************************************************************************************************************

$('#icd_codes').autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","SnomedMappingMaster","icd9code",'null',"no",'no',"icd9code !=".'',"icd9code","admin" => false,"plugin"=>false)); ?>",
		{
			width : 250,
			selectFirst : true
		});

//var checkName=$('#checkForApcs:checked').length;
function getIcdDetails(){
var calling_url_icd = "<?php echo $this->Html->url(array("controller" => 'Insurances', "action" => "icdSearch","admin" => false)); ?>" ;
var icdcodes=$('#icd_codes').val(); 
if(httpRequest) httpRequest.abort();
	var httpRequest = $.ajax({
		  beforeSend: function(){
			  $('#busy-indicator').show('fast');
		  },
	      url: calling_url_icd+"/"+icdcodes,
	      context: document.body,
	      success: function(data){ 
	    	  $('#busy-indicator').hide('fast');
	    	  data= JSON && JSON.parse(data) || $.parseJSON(data);
	    	 	 addRowWithICDDetails(data);
		  },
		  error:function(){
				alert('Please try again');
				//onCompleteRequest(); //remove loading sreen
			  }
	});
///}
} 
icdcode=0;
var selectedicdCodeIndexArr = new Array();
var selectedicdCodeArr = new Array();
function addRowWithICDDetails(data){

 if(data != '' && data !== undefined){
	 if(data.code==null){
			$('#icdError').show();
			$('#icdError').html('No Records Found.');
			return false;
	 }
	 	$("#icdTable").find('tbody')
	  	.append($('<tr>').attr('class', '').attr('id', 'data'+icdcode)	  	
	  	.append(($('<td class="tdLabel" id="boxSpace">').append($('<input>')
		.attr({type:"hidden", name:"data[Encounter]["+icdcode+"][icd_codes]",value:data.code})).text(icdcode+1)))
		.append($('<td class="tdLabel" id="boxSpace">').text(data.code))
	  	.append($('<td class="tdLabel" id="boxSpace">').text(data.name))		
		.append($('<td style="padding-left:25px">').attr('class','removeIcd')
		.attr('id', 'remove_'+icdcode).html('<?php echo $this->Html->image('/img/icons/cross.png', array('alt' => 'Remove'));?>')
));
	selectedicdCodeIndexArr.push(icdcode);
	selectedicdCodeArr.push(data.code);
	icdcode++;
}
}

$(".removeIcd").live( "click", function() {
var currentId=$(this).attr('id');
if(confirm("Do you really want to delete this record?")){
var trRemove=currentId.split('_');//alert(trRemove);
$('#data'+trRemove[1]).remove();
var pid=$('#patientId').val();
delete_code('icd',trRemove[1],pid);
}else{
	return false;
}
selectedicdCodeArr.splice( $.inArray(trRemove[1], selectedicdCodeArr), 1 );
selectedicdCodeIndexArr.splice( $.inArray(trRemove[1], selectedicdCodeArr), 1 );
});
$(".pre_removeIcd").live( "click", function() {
	var currentId=$(this).attr('id');
	if(confirm("Do you really want to delete this record?")){
		var trRemove=currentId.split('_');
		var dRemove=trRemove[1].split('i');
		var setToNoteDia=$('#note_daignosis_'+dRemove[0]).val();
		$('#preIcd'+trRemove[1]).remove();
		delete_code('noteDiagnosis',setToNoteDia);
		//var pid=$('#patientId').val();
		//delete_code('icd',trRemove[1],pid);
		}else{
			return false;
		}
	
});
$(".delete_ndcremove").live( "click", function() {
	var currentId=$(this).attr('id');
	if(confirm("Do you really want to delete this record?")){
		var trRemove=currentId.split('_');
		var setToNewCrop=$('#newcrop_prescription_'+trRemove[1]).val();
		$('#ndc'+trRemove[1]).remove();
		delete_code('newcrop_prescription',setToNewCrop);
		}else{
			return false;
		}
	
});
$(".delete_removeHcpcs").live( "click", function() {
	var currentId=$(this).attr('id');
	if(confirm("Do you really want to delete this record?")){
		var trRemove=currentId.split('_');
		var setToProPreform=$('#hcpcs_pp'+trRemove[1]).val();
		$('#pro_perform'+trRemove[1]).remove();
		delete_code('procedure_perform',setToProPreform);
		}else{
			return false;
		}	
});
$(".delete_removecpt").live( "click", function() {
	var currentId=$(this).attr('id');
	if(confirm("Do you really want to delete this record?")){
		var trRemove=currentId.split('_');
		var setToProPreform=$('#cpt_pp_'+trRemove[1]).val();
		$('#cpt_pp'+trRemove[1]).remove();
		delete_code('procedure_perform',setToProPreform);
		}else{
			return false;
		}	
});



//*********************************************Ajax call to delete codes of all type***************************************
function delete_code(modelName,code,patient_id){ 
var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Insurances", "action" => "deleteCode","admin" => false)); ?>"+"/"+modelName+"/"+code+"/"+patient_id;
$.ajax({	
	 beforeSend : function() {
		// this is where we append a loading image
		$('#busy-indicator').show('fast');
		},
		                           
 type: 'POST',
 url: ajaxUrl,
 dataType: 'html',
 success: function(data){
	  $('#busy-indicator').hide('fast');
	 // window.location.href = '<?php echo $this->Html->url("/patients/addorders"); ?>'+"/"+p_id+"/"+categoryOrderId;	
  		$("#resultorder").html(" ");  
 },
	error: function(message){
		alert("Error in Retrieving data");
 }        
 });
}
 //**************************************************end of ajax calls****************************************************** 
</script>
