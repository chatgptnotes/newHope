<?php 
echo $this->Html->css(array('jquery.autocomplete.css'));
echo $this->Html->script(array('jquery.autocomplete'));
?> 
<div class="inner_title">
	<h3>
		<?php echo __('Extra Notes'); ?>
	</h3>
</div>
<p class='ht5'>&nbsp;</p>
<div class='clr'>
	<?php echo $this->element('patient_information');?>
</div>
<p class='ht5'>&nbsp;</p>
<?php 
echo $this->Form->create('Note',array('id'=>'patientnotesfrm','inputDefaults' => array('label' => false,'div' => false,'error'=>false)));
echo $this->Form->hidden('id',array('id'=>'note_id','autocomplete'=>"off"));
echo $this->Form->hidden('patient_id',array('id'=>'Patientsid','value'=>$patientId,'autocomplete'=>"off"));
echo $this->Form->hidden('patientid', array('name'=>'patientid','value'=>$patientId, 'id' => 'patientid' ));
echo $this->Form->hidden('note_type',array('value'=>'extra note'));?>


<table class="table_format" style="padding: 15px;" id="schedule_form">
	<tr>
		<td width="255"><?php echo __('Primary Care Provider :');?><font
			color="red">*</font>
		</td>
		<td><?php 
		echo $this->Form->input('doctor_id_txt', array('style'=>' float:left;','id'=>'doctor_id_txt','value'=>$registrar[$this->data['Note']['sb_registrar']],'class'=>'validate[required,custom[mandatory-select]] textBoxExpnd','style'=>"width:383px"));
		//actual field to enter in db
		echo $this->Form->hidden('sb_registrar', array('type'=>'text','id'=>'sb_registrar'));
		?>
		</td>
	</tr>
	<tr>
		<td><?php echo __('S/B Registrar :');?><font color="red">*</font>
		</td>
		<td ><?php
		echo $this->Form->input('sb_consultant', array('options'=>$consultant,'empty'=>'Please select','id' => 'sb_consultant','style'=>"width:398px",'class'=>'validate[required,custom[mandatory-select]] textBoxExpnd' ));

		?>
		</td>
	</tr>
	<tr>
		<td><?php echo __('Visit Type :');?> <font color="red">*</font>
		</td>
		<td><?php 
		echo $this->Form->input('visit_type', array('options'=>$visitType,'empty'=>'Please select','id' => 'visit_type','style'=>"width:397px",'class'=>'validate[required,custom[mandatory-select]] textBoxExpnd' ));
		?></td>
	</tr>
	<tr>
		<td><?php echo __('Date :');?><font color="red">*</font>
		</td>
		<td><?php
		echo $this->Form->input('note_date', array('type'=>'text','readonly'=>'readonly','id' => 'note_date','style'=>"width:120px",'class'=>'validate[required,custom[mandatory-date]] date textBoxExpnd', 'style'=>'width:120px' ));
		?>
		</td>
	</tr>
	<tr id="to_be_billed_section" style="display: &amp;amp;">
		<td><?php echo __('To be Billed :');?>
		</td>
		<td><?php 
		echo $this->Form->checkbox('to_be_billed', array('class'=>'servicesClick','id' => 'to_be_billed'));
		?>
		</td>
	</tr>
	<tr>
		<td></td>
		<td><?php	$options=array('428191000124101'=>'Documentation of current medications','7'=>'Medical or other reason not done for current medication documentation');
		$attributes=array('legend'=>false,'label'=>false);
		echo $this->Form->radio('is_documentation',$options,$attributes);?>
		</td>
	</tr>


</table>
<div
	id="accordionCust" class="accordionCust">
	
	<!-- Start of Cognitive & functional Status -->
	<h3 style="display: &amp;amp;" id="cognitiveStatus-link">
		<a href="#">Cognitive Status</a>
	</h3>
	<div class="section" id="cognitive">
		<div align="center" id='temp-busy-indicator-cognitive'
			style="display: none;">
			&nbsp;
			<?php echo $this->Html->image('indicator.gif', array()); ?>
		</div>
		<table width="100%">
			<tr>
				<td width="100%" align="left" valign="top">&nbsp;</td>
			</tr>
			<tr>
				<td width="100%" align="left" valign="top">
					<table width="100%" cellpadding="0" cellspacing="0" border="0"
						class="formFull formFullBorder">
						<tr>
							<td><table width="100%" cellpadding="0" cellspacing="1"
									border="0" class="tabularForm">
									<tr>
										<td valign="top">
											<table width="100%" cellpadding="0" cellspacing="0"
												border="0">
												<tr>
													<td width="60" class="tdLabel2"><strong>Search :</strong></td>
													<td width="321" cellpadding:right='200px'><?php 
													echo $this->Form->input('search', array('class' => 'textBoxExpnd','style'=>'padding:6px 21px;','id'=>'search_cog','autocomplete'=>'true','label'=>false,'div'=>false));
													?>
													</td>
													<td width="80" colspan="4"><?php 
													echo $this->Html->link(__('Search'),"javascript:void(0)",array('class'=>'blueBtn','onclick'=>'javascript:snomed_LabRAd_test();'));
													?>
													</td>
													<td width="110" class="tdLabel2"><?php echo __('Search Result :');?>
													</td>
													<td width="" colspan="4"><?php 
													echo $this->Form->input('CognitiveFunction.toTest',array('options'=>'','escape'=>false,'multiple'=>false,'value'=>'',
					                                  'style'=>'width:345px;','id'=>'SelectLeft','label'=>false,'div'=>false,'empty'=> 'Please Select','onChange'=>'javascript:changeTest()'));
														echo $this->Form->hidden('CognitiveFunction.cog_name', array('id'=>'cog_name'));
														?>
													</td>
												</tr>
												<tr>

													<td width="123" class="tdLabel2"><?php echo __('Alternate Result :');?>
													</td>
													<td width="" colspan="4"><?php 
													$customArray = array(' '=>__('Please Select'),'386807006'=>__('Memory Impairment'),'66557003'=>__('No impairment')) ;
													echo $this->Form->input('CognitiveFunction.toTest', array('options'=>$customArray,'class'=>'textBoxExpnd ',  'style'=>'width:327px;','id' => 'func_name'));
													?>
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td>
											<table width="100%" cellpadding="0" cellspacing="0"
												border="0">
												<tr>
													<td width="123"><?php echo __('Date :');?><font color="red">*</font>
													</td>
													<td width="153"><?php echo $this->Form->input('CognitiveFunction.cog_date',array('class'=>'textBoxExpnd validate[required,custom[mandatory-date]] textBoxExpnd date','readonly'=>'readonly','style'=>'width:120px','id'=>'cog_date','readonly'=>'readonly','autocomplete'=>'off','type'=>'text','value'=>'','label'=>false )); ?>
													</td>
													<td width="123"></td>
													<td width="50"></td>
													<td width="18%" align="right"><?php echo __('Snomed CT Code :');?></td>
													<td><?php echo $this->Form->input('CognitiveFunction.cog_snomed_code',array('style'=>'width:330px','class'=>'textBoxExpnd','id'=>'cog_snomed_code','readonly'=>'readonly','autocomplete'=>'off','type'=>'text','value'=>'','label'=>false,'readonly'=>'readonly' )); ?>
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<?php if(!empty($cogFunc)){?>
									<tr>
										<td>
											<table width="100%" cellpadding="0" cellspacing="0"
												border="0" align="center">
												<tr>
													<td>
														<table border="0" class="table_format_body"
															cellpadding="0" cellspacing="0" width="100%">
															<tr class="row_title">
																<!-- <td class="table_cell"><strong>Sr. #</strong></td> -->
																<td class="table_cell"><strong>Date</strong></td>
																<td class="table_cell"><strong>Name</strong></td>
																<td class="table_cell"><strong>Snomed CT Code</strong></td>
																<td class="table_cell"><strong>Status</strong></td>
															</tr>
															<?php
															//$count=0;
															$toggle =0;
															foreach($cogFunc as $cog){
																if($toggle == 0) {
																	echo "<tr class='row_gray'>";
																	$toggle = 1;
																}else{
																	echo "<tr>";
																	$toggle = 0;
																}
																?>
															<td class="row_format">&nbsp;<?php echo $this->DateFormat->formatDate2Local($cog['CognitiveFunction']['cog_date'],Configure::read('date_format'));  ?>
															</td>
															<td class="row_format">&nbsp;<?php echo $cog['CognitiveFunction']['cog_name'];  ?>
															</td>
															<td class="row_format">&nbsp;<?php echo $cog['CognitiveFunction']['cog_snomed_code'];  ?>
															</td>
															<td class="row_format">&nbsp;<?php echo 'Active';  ?>
															</td>
															</tr>
															<?php }?>
														</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<?php }?>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
	<!-- End of Cognitive  Status -->
	<!-- EOF section div -->
	<h3 style="display: &amp;amp;" id="event-note-link">
		<a href="#">Event Note</a>
	</h3>
	<div class="section" id="event-note">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			class="formFull formFullBorder">
			<tr>
				<td width="27%" align="left" valign="top">
					<div align="center" id='temp-busy-indicator-event-note'
						style="display: none;">
						&nbsp;
						<?php echo $this->Html->image('indicator.gif', array()); ?>
					</div>
					<div id="templateArea-event-note"></div>
				</td>
				<td width="70%" align="left" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="20">&nbsp;</td>
							<td valign="top" colspan="4"><?php echo $this->Form->textarea('event_note', array('id' => 'event_note_desc'  ,'rows'=>'21','style'=>'width:90%')); ?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
	<!-- EOF section div -->
	<!-- EOF devices -->
	<h3 style="display: &amp;amp;" id="finalization-link">
		<a href="#">Finalization</a>
	</h3>
	<div class="section" id="finalization">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			class="formFull formFullBorder">
			<tr>
				<td width="27%" align="left" valign="top">
					<div align="center" id='temp-busy-indicator-finalization'
						style="display: none;">
						&nbsp;
						<?php echo $this->Html->image('indicator.gif', array()); ?>
					</div>
				</td>
			</tr>
			<tr>
				<td><strong><?php echo __("Enter the following quality reporting items below :");?>
				</strong>
				</td>
			</tr>
			<tr>
				<td>
					<table width="100%" cellpadding="0" cellspacing="0" border="0"
						class="formFull formFullBorder">
						<tr>
							<?php $count_visit=0;
							foreach($visittype as $visit){
					 			foreach($visit as $uniqueslot){
								$count_vist++;
								?>
							<td width='2px'><?php if(in_array($uniqueslot[id],$selected)){
								$checked= "checked";
							} else { $checked= "";
								}
								echo $this->Form->input('Note.visitid', array('type'=>'checkbox','hiddenField' => false,'name'=>'data[Note][visitid][]','checked'=>$checked,'value'=>$uniqueslot[id]));
								?>
							</td>
							<td valign="top"><?php echo $uniqueslot[description];  ?>
							</td>
							<?php  if($count_visit % 3 ==0){ 
								echo "</tr><tr>";
							}
								 }
								} ?>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<div class="section">
						<table width="100%" cellpadding="0" cellspacing="0" border="0"
							class="formFull formFullBorder">
							<tr>
								<td><?php echo __("Weight Screening:");?></td>
								<td valign="top"><?php echo __("Height");?>&nbsp;&nbsp;<?php	
								echo $this->Form->input('Note.ht',array('type'=>'text','legend'=>false,'label'=>false,'class' => 'validate[optional,custom[onlyNumber]]', 'style' => 'width:93px','id' => 'height'));
								?> <?php echo __("(Inch.)");?>
								</td>
								<td valign="top"><?php echo __("Weight");?>&nbsp;&nbsp;<?php	
								echo $this->Form->input('Note.wt',array('type'=>'text','legend'=>false,'label'=>false,'class' => 'validate[optional,custom[onlyNumber]]', 'style' => 'width:93px', 'id' => 'weight'));
								?> <?php echo __("(Lbs.)");?>
								</td>
								<td valign="top"><?php echo __("B.M.I.");?>&nbsp;&nbsp;<?php	
								echo $this->Form->input('Note.bmi',array('legend'=>false,'label'=>false, 'style' => 'width:99px', 'id' => 'bmi', 'readonly' => 'readonly'));
								?> <span id="bmiStatus"></span>
								</td>
								<td><?php echo __("Date:");?></td>
								<td valign="top">&nbsp;&nbsp;<?php	
								if($this->request->data['Note']['finalization_date']) {
									$finalizationDate = $this->DateFormat->formatDate2Local($this->request->data['Note']['finalization_date'],Configure::read('date_format_us'),false);
									echo $this->Form->input('finalization_date', array('type' => 'text','readonly'=>'readonly','class'=>'textBoxExpnd date','id' => 'finalization_date', 'label'=> false,'div' => false, 'error' => false,'value' => $finalizationDate));
								}else {
									echo $this->Form->input('finalization_date', array('type' => 'text','readonly'=>'readonly','class'=>'textBoxExpnd date', 'id' => 'finalization_date', 'label'=> false,'div' => false, 'error' => false, ));
								}?> <span id="bmiStatus"></span>
								</td>
							</tr>
						</table>
						<table>
							<tr>
								<td valign="top"><?php if(in_array("Nutritional counseling",$this->data['Note']['final'])){ 
									$nc="checked";
								}
								echo $this->Form->input('Note.final', array('checked'=> $nc,'type'=>'checkbox','hiddenField' => false,'name'=>'data[Note][final][]','value'=>'Nutritional counseling')); ?>
									&nbsp;<?php echo __("Nutritional counseling");?></td>
							</tr>
							<tr>
								<td><?php  if(in_array("Physical activity counseling",$this->data['Note']['final'])){ 
									$pac="checked";
								}
								echo $this->Form->input('Note.final', array('checked'=> $pac,'type'=>'checkbox','hiddenField' => false,'name'=>'data[Note][final][]','value'=>'Physical activity counseling')); ?>
									&nbsp;<?php echo __("Physical activity counseling");?></td>
							</tr>
							<tr>
								<td><?php   if(in_array("B.M.I - NOT DONE (Medical Reason)",$this->data['Note']['final'])){ 
									$mr="checked";
								}
								echo $this->Form->input('Note.final', array('checked'=>$mr,'type'=>'checkbox','hiddenField' => false,'name'=>'data[Note][final][]','value'=>'B.M.I - NOT DONE (Medical Reason)')); ?>
									&nbsp;<?php echo __("B.M.I - NOT DONE (Medical Reason)");?></td>
							</tr>
							<tr>
								<td><?php   if(in_array("B.M.I - NOT DONE (System Reason)",$this->data['Note']['final'])){ 
									$sr="checked";
								}
								echo $this->Form->input('Note.final', array('checked'=>$sr,'type'=>'checkbox','hiddenField' => false,'name'=>'data[Note][final][]','value'=>'B.M.I - NOT DONE (System Reason)')); ?>
									&nbsp;<?php echo __("B.M.I - NOT DONE (System Reason)");?></td>
							</tr>
							<tr>
								<td><?php   if(in_array("B.M.I - NOT DONE (Patient Reason)",$this->data['Note']['final'])){ 
									$pr="checked";
								}
								echo $this->Form->input('Note.final', array('checked'=>$pr,'type'=>'checkbox','hiddenField' => false,'name'=>'data[Note][final][]','value'=>'B.M.I - NOT DONE (Patient Reason)')); ?>
									&nbsp;<?php echo __("B.M.I - NOT DONE (Patient Reason)");?></td>
							</tr>
						</table>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="section">
						<table width="100%" cellpadding="0" cellspacing="0" border="0"
							class="formFull formFullBorder">
							<tr>
								<td  width="21%"><label style="float: inherit"><?php echo __('Patient Characterstic:') ?>
								</label></td>
								<td><?php  echo $this->Form->input('patient_character_snomed', array('style'=>'width:406px; float:left=5px;','empty'=>__('Select'),'options'=>array("13798002"=>"Gestation Period 38 weeks(finding)",'441924001'=>'Gestational age unknown'), 'id'=>'patient_character_snomed',
										'class' => 'textBoxExpnd')); ?>
								</td>
								<td><?php echo __('Characterstic Date :');?></td>
								<td><?php if($this->request->data['Note']['patient_char_date']) {
									$patientCharDate = $this->DateFormat->formatDate2Local($this->request->data['Note']['patient_char_date'],Configure::read('date_format_us'),false);
									echo $this->Form->input('patient_char_date', array('type' => 'text','class'=>'textBoxExpnd date', 'id' => 'patient_char_date', 'label'=> false,'div' => false, 'error' => false,'value' => $patientCharDate ));
								}else {
										echo $this->Form->input('patient_char_date', array('type' => 'text','class'=>'textBoxExpnd date', 'id' => 'patient_char_date', 'label'=> false,'div' => false, 'error' => false, ));
									}
									?>
								</td>
							</tr>
						</table>
					</div>
				</td>
			</tr>
		</table>
	</div>
	<!-- Start of Functional status -->
	<h3 style="display: &amp;amp;" id="functional-link">
		<a href="#">Functional Status</a>
	</h3>
	<!-- <div id="functional"> -->
	<div class="section" id="functional">
		<div align="center" id='temp-busy-indicator-functional'
			style="display: none;">
			&nbsp;
			<?php echo $this->Html->image('indicator.gif', array()); ?>
		</div>
		<table width="100%">
			<tr>
				<td width="100%" align="left" valign="top">&nbsp;</td>
			</tr>
			<tr>
				<td width="100%" align="left" valign="top">
					<table width="100%" cellpadding="0" cellspacing="0" border="0"
						class="formFull formFullBorder">
						<tr>
							<td><table width="100%" cellpadding="0" cellspacing="1"
									border="0" class="tabularForm">
									<tr>
										<td valign="top">
											<table width="100%" cellpadding="0" cellspacing="0"
												border="0">
												<tr>
													<td width="60" class="tdLabel2"><strong>Search :</strong></td>
													<td width="250" cellpadding:right='200px'><?php 
													echo $this->Form->input('search', array('class' => 'textBoxExpnd','style'=>'padding:7px 10px;','id'=>'search_funct','autocomplete'=>'true','label'=>false,'div'=>false));
													?>
													</td>
													<td width="80" colspan="4"><?php 
													echo $this->Html->link(__('Search'),"javascript:void(0)",array('class'=>'blueBtn','onclick'=>'javascript:snomed_LabRAd_test();'));
													?>
													</td>
													<td width="100"></td>
													<td width="110" class="tdLabel2"><?php echo __('Search Result :');?>
													</td>
													<td width="" colspan="4"><?php 
													echo $this->Form->input('Note.toTest1',array('options'=>'','escape'=>false,'multiple'=>false,'value'=>'',
	                                  					'style'=>'width:342px;', 'class'=>'textBoxExpnd','id'=>'SelectLeft_funct','label'=>false,'div'=>false,'empty'=> 'Please Select',
														'onChange'=>'javascript:changeTest1()'));
													echo $this->Form->hidden('FunctionalStatus.funct_name', array('id'=>'funct_name'));
													?>
													</td>
												</tr>
												<tr>
													<td width="123" class="tdLabel2"><?php echo __('Alternate result :');?>
													</td>
													<td width="31%" colspan="4"><?php 
													$customArray = array(''=>__('Please Select'),'105504002'=>__('Dependence on Walking Stick'),
															'66557003'=>__('No impairment')) ;
												 echo $this->Form->input('Note.toTest1', array('options'=>$customArray, 'class'=>'textBoxExpnd', 'style'=>'width:344px','id' => 'function_name'));
												 ?>
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td>
											<table width="100%" cellpadding="0" cellspacing="0"
												border="0">
												<tr>
													<td width="123" class="tdLabel2"><?php echo __('Date :');?><font
														color="red">*</font></td>
													<td><?php echo $this->Form->input('FunctionalStatus.funct_date',array('class'=>'validate[required,custom[mandatory-date]] textBoxExpnd date','id'=>'func_date','readonly'=>'readonly','autocomplete'=>'off','type'=>'text','value'=>'','label'=>false )); ?>
													</td>


													<td width="124" align="right" class="tdLabel2"><?php echo __('Snomed CT Code :');?>
													</td>
													<td width="30%"><?php echo $this->Form->input('FunctionalStatus.funct_snomed_code',array('class'=>'textBoxExpnd', 'style'=>'width:327px','id'=>'funct_snomed_code','readonly'=>'readonly','autocomplete'=>'off','type'=>'text','value'=>'','label'=>false ,'readonly'=>'readonly')); ?>
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<?php if(!empty($funStatus)){?>
									<tr>
										<td>
											<table width="100%" cellpadding="0" cellspacing="0"
												border="0" align="center">
												<tr>
													<td>
														<table border="0" class="table_format_body"
															cellpadding="0" cellspacing="0" width="100%">
															<tr class="row_title">
																<!-- <td class="table_cell"><strong>Sr. #</strong></td> -->
																<td class="table_cell"><strong>Date</strong></td>
																<td class="table_cell"><strong>Name</strong></td>
																<td class="table_cell"><strong>Snomed CT Code</strong></td>
																<td class="table_cell"><strong>Status</strong></td>
															</tr>
															<?php
															//$count=0;
															$toggle =0;
															foreach($funStatus as $funct){
															if($toggle == 0) {
																						echo "<tr class='row_gray'>";
																						$toggle = 1;
																					}else{
																						echo "<tr>";
																						$toggle = 0;
																					}
																					?>
															<td class="row_format">&nbsp;<?php echo $this->DateFormat->formatDate2Local($funct['CognitiveFunction']['cog_date'],Configure::read('date_format'));  ?>
															</td>
															<td class="row_format">&nbsp;<?php echo $funct['CognitiveFunction']['cog_name'];  ?>
															</td>
															<td class="row_format">&nbsp;<?php echo $funct['CognitiveFunction']['cog_snomed_code'];  ?>
															</td>
															<td class="row_format">&nbsp;<?php echo 'Active';  ?>
															</td>
															</tr>
															<?php }?>
														</table>
													</td>
												</tr>
											</table>
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
	</div>
	<!-- End of Functional status -->
	<h3 style="display: &amp;amp;" id="status-result">
		<a href="#">Functional Status Results</a>
	</h3>
	<div class="section" id="functional-result">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			class="formFull formFullBorder">
			<tr>
				<td width="27%" align="left" valign="top">
					<div align="center" id='temp-busy-indicator-functional-result'
						style="display: none;">
						&nbsp;
						<?php echo $this->Html->image('indicator.gif', array()); ?>
					</div>
					<table width="100%" cellpadding="0" cellspacing="1" border="0"
						class="tabularForm">
						<tr>
							<td valign="top">
								<table width="100%" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td width="60" class="tdLabel2"><strong>Search :</strong></td>
										<td width="400" cellpadding:right='200px'><?php 
										echo $this->Form->input('FunctionalResult.searchResult', array('class' => 'textBoxExpnd','style'=>'padding:7px 21px;','id'=>'searchResult','autocomplete'=>'true','label'=>false,'div'=>false));
										?></td>
										<td width="80" colspan="4" align="center"><?php 
										echo $this->Html->link(__('Search'),"javascript:void(0)",array('class'=>'blueBtn','onclick'=>'javascript:snomed_problem()'));
										?>
										</td>
										<td width="106" class="tdLabel2"><?php echo __('Search Result :');?>
										</td>
										<td width="328px" colspan="4"><?php 
										echo $this->Form->input('FunctionalResult.toTest',array('empty'=>__('Select'),'options'=>'','escape'=>false,'multiple'=>false,'value'=>'',
	                                  		'id'=>'result', 'class'=>'textBoxExpnd','label'=>false,'div'=>false,'empty'=> 'Please Select','onChange'=>'javascript:return $("#result_description").val($("#result :selected").text());'));
						               ?>
										</td>
									</tr>
									<tr>
										<td colspan="6"></td>
										<td align="left"><?php echo __('OR')?></td>
									</tr>
									<tr>
										<td width="110" class="tdLabel2"><?php echo __('Procedure Name :');?><font
											color="red">*</font>
										</td>
										<td width="400" class="tdLabel2" colspan="4"><?php echo $this->Form->input('FunctionalResult.result_description',array('style'=>'width:349px; padding:6px 7px;','id'=>'result_description','readonly'=>'readonly','class'=>'validate[required,custom[mandatory-select]] textBoxExpnd'));
										echo $this->Form->hidden('FunctionalResult.test_code',array('id'=>'test_codeRe','type'=>'text'));
										echo $this->Form->hidden('FunctionalResult.loinc_code',array('id'=>'loinc_codeRe','type'=>'text'));
										echo $this->Form->hidden('FunctionalResult.snomed_code',array('id'=>'snomed_codeRe','type'=>'text'));
										echo $this->Form->hidden('FunctionalResult.cpt_code',array('id'=>'cpt_codeRe','type'=>'text'));
										echo $this->Form->hidden('FunctionalResult.id',array('id'=>'dignostic_idRe','type'=>'text'));
										?>
										</td>
										<td width=""></td>

										<td width="143" class="tdLabel2"><?php echo __('Alternate result :');?>
										</td>
										<td width="400"><?php  echo $this->Form->input('FunctionalResult.dbprocedure',array('options'=>array(''=>'Please Select','71955-9'=>'Promise-29-sleep disturbance'),'escape'=>false,'multiple'=>false,
												'onChange'=>'javascript:return ($("#result_description").val($("#dbprocedureRe :selected").text()),$("#loinc_codeRe").val($("#dbprocedureRe").val()));',
												'style'=>'width:352px;','id'=>'dbprocedureRe', 'class'=>'textBoxExpnd','label'=>false,'div'=>false));
										?></td>
									</tr>
									<tr>
										<td width="223" colspan="1"><?php echo __('Functional Status Date');?><font
											color="red">*</font>
										</td>
										<td><?php 
										echo $this->Form->input('FunctionalResult.result_date',array('class'=>'validate[required,custom[mandatory-date]] textBoxExpnd date','style'=>'width:120px', 'readonly'=>'readonly','type'=>'text','id'=>'result_date'));
										?>
										</td>
										<td width="100" class="tdLabel2" align="right"></td>
										<td></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td width="70%" align="left" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<!-- <td width="20"></td> -->
							<td valign="top" colspan="4"><?php echo __('Functional Status Note :');?>
							</td>
						</tr>
						<tr>
							<td width="20">&nbsp;</td>
							<td valign="top" colspan="4"><?php echo $this->Form->textarea('FunctionalResult.instruction', array('id' => 'result_instruction'  ,'rows'=>'4','style'=>'width:97%')); ?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td colspan='4' align='right' valign='bottom'><?php  echo $this->Html->link(__('Submit'),"javascript:void(0)",array('id'=>'resultsubmit','class'=>'blueBtn','onclick'=>"javascript:save_result()")); ?>
				</td>
			</tr>
			<tr>
				<td>
					<table border="0" class="table_format" cellpadding="0"
						cellspacing="0" width="100%" style="text-align: center;">
						<?php if(isset($functionalResult) && !empty($functionalResult)){ ?>
						<tr class="row_title">
							<td class="table_cell"><strong> <?php echo  __('Problem Name', true); ?>
							</strong></td>
							<td class="table_cell"><strong> <?php echo  __('Loinc Code', true); ?>
							</strong></td>
							<td class="table_cell"><strong> <?php echo  __('Snomed Code', true); ?>
							</strong></td>
							<td class="table_cell"><strong> <?php echo  __('Result Date', true); ?>
							</strong></td>
							<td class="table_cell"><strong> <?php echo  __('Action'); ?>
							</strong></td>
						</tr>
						<?php
						$toggle =0;
						if(count($functionalResult) > 0) {
									foreach($functionalResult as $functionalResult){
										if(!empty($functionalResult)) {
										}else{
		                                 			echo "<tr class='row_title'><td colspan='5>&nbsp;</td></tr>" ;
		                                 		}
		                                 		$time  =  $currentTime;
		                                 		if($toggle == 0) {
												echo "<tr class='row_gray'>";
												$toggle = 1;
										   }else{
												echo "<tr>";
												$toggle = 0;
										   }
										   //status of the report
										   ?>

						<td class="row_format"><?php echo $functionalResult['FunctionalResult']['result_description']; ?>
						</td>
						<td class="row_format"><?php echo $functionalResult['FunctionalResult']['loinc_code']; ?>
						</td>
						<td class="row_format"><?php echo $functionalResult['FunctionalResult']['snomed_code']; ?>
						</td>

						<td class="row_format"><?php echo $this->DateFormat->formatDate2Local($functionalResult['FunctionalResult']['result_date'],Configure::read('date_format_us'),false); ?>
						</td>
						<td class="row_format" style="text-align: center;"><?php $result_id = $functionalResult['FunctionalResult']['id'];
						echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete', 'onclick'=>"delete_result($result_id);return false;")), array(), array('escape' => false));
						echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('title'=>'Edit','alt'=>'Edit', 'onclick'=>"edit_result($result_id);return false;")), array(), array('escape' => false));
						?>
						</td>
						</tr>
						<?php } 
						}
						} else { ?>
						<tr>
							<TD colspan="5" align="center" class="error"><?php echo __('No Functional Status Resulted for selected patient', true); ?>.
							</TD>
						</tr>
						<?php } ?>
					</table>
				</td>
			</tr>
		</table>
	</div>
	
	
	
	
	<!-- BOF Other Note type option -->
	<h3 style="display: &amp;amp;" id="notes-link">
		<a href="#">Instruction</a>
	</h3>
	<div class="section" id="notes">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			class="formFull formFullBorder">
			<tr>
				<td width="27%" align="left" valign="top">
					<div align="center" id='temp-busy-indicator-notes'
						style="display: none;">
						&nbsp;
						<?php echo $this->Html->image('indicator.gif', array()); ?>
					</div>
					<div id="templateArea-notes"></div>
				</td>
				<td width="70%" align="left" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="20">&nbsp;</td>
							<td valign="top" colspan="4"><?php echo $this->Form->textarea('note', array('id' => 'notes_desc' ,'rows'=>'21','style'=>'width:90%')); ?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
	<!-- BOF Intervention type option -->
	<h3 style="display: &amp;amp;" id="intervention-link">
		<a href="#">Intervention</a>
	</h3>
	<div class="section" id="intervention">
		<div align="center" id='temp-busy-indicator-intervention'
			style="display: none;">
			&nbsp;
			<?php echo $this->Html->image('indicator.gif', array()); ?>
		</div>
		<!-- ajax start of intervention -->
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			class="formFull formFullBorder">
			<tr>
				<td width="27%" align="left" valign="top">
					<table width="100%" cellpadding="0" cellspacing="1" border="0"
						class="tabularForm">
						<tr>
							<td valign="top">
								<table width="100%" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td class="row_format"><label style="float: inherit"><?php echo __('Intervention Type:') ?>
										</label></td>
										<?php // echo ($dbproblems1);?>
										<td width="145"><?php echo $this->Form->input('Intervention.icd9cm_inter',array('empty'=>__('Select'),'options'=>$dbproblems1,'escape'=>false,'multiple'=>false,'value'=>'',
												'style'=>'width:400px;','id'=>'icd9cm_inter','label'=>false,'div'=>false,'empty'=> 'Please Select','onChange'=>'javascript:dbProblem("intervention")'));
										?>
										</td>
										<td width="150" class="tdLabel2"><?php echo __('Intervention Name :');?><font
											color="red">*</font>
										</td>
										<td width="400" class="tdLabel2" colspan="4"><?php echo $this->Form->input('Intervention.intervention_name',array('style'=>'width:373px;','id'=>'intervention_name','readonly'=>'readonly','class'=>'validate[required,custom[mandatory-select]] textBoxExpnd'));
										echo $this->Form->hidden('Intervention.snomed_code',array('id'=>'snomed_codepr','type'=>'text'));
										echo $this->Form->hidden('Intervention.lonic_code',array('id'=>'lonic_code_inter','type'=>'text'));
										echo $this->Form->hidden('Intervention.id',array('id'=>'id_inter','type'=>'text'));
										?></td>
									</tr>
									<tr>
										<td width="145"><?php echo __('Intervention Date :');?><font
											color="red">*</font></td>
										<td width="100" class="tdLabel2" align="right" colspan="5"><?php echo $this->Form->input('Intervention.intervention_date',array('class'=>'validate[required,custom[mandatory-date]] textBoxExpnd date',
												'style'=>'width:120px', 'readonly'=>'readonly','type'=>'text','id'=>'intervention_date')); ?>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td width="70%" align="left" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="20"></td>
							<td valign="top" colspan="4"><?php echo __('Intervention Note :');?>
							</td>
						</tr>
						<tr>
							<td width="20">&nbsp;</td>
							<td valign="top" colspan="4"><?php echo $this->Form->textarea('Intervention.intervention_note', array('id' => 'intervention_note'  ,'rows'=>'4','style'=>'width:97%')); ?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td colspan='4' align='right' valign='bottom'><?php  echo $this->Html->link(__('Submit'),"javascript:void(0)",array('id'=>'interventionsubmit','class'=>'blueBtn','onclick'=>"javascript:save_intervention()")); ?>
				</td>
			</tr>
			<tr>
				<td>
					<table border="0" class="table_format" cellpadding="0"
						cellspacing="0" width="100%" style="text-align: center;">
						<?php if(isset($interventionResult) && !empty($interventionResult)){ ?>
						<tr class="row_title">
							<td class="table_cell"><strong> <?php echo  __('Test Name', true); ?>
							</strong></td>
							<td class="table_cell"><strong> <?php echo  __('Loinc Code', true); ?>
							</strong></td>
							<td class="table_cell"><strong> <?php echo  __('Snomed Code', true); ?>
							</strong></td>
							<td class="table_cell"><strong> <?php echo  __('Intervention Date', true); ?>
							</strong></td>
							<td class="table_cell"><strong> <?php echo  __('Action'); ?>
							</strong></td>
						</tr>
						<?php
						$toggle =0;
						if(count($interventionResult) > 0) {
									foreach($interventionResult as $interventionResult){
											 if(!empty($interventionResult)) {
											}else{
		                                 			echo "<tr class='row_title'><td colspan='5>&nbsp;</td></tr>" ;
		                                 		}
		                                 		if($toggle == 0) {
												echo "<tr class='row_gray'>";
												$toggle = 1;
										   }else{
												echo "<tr>";
												$toggle = 0;
										   }
										   //status of the report
										   ?>
						<td class="row_format"><?php echo $interventionResult['Intervention']['intervention_name']; ?>
						</td>
						<td class="row_format"><?php echo $interventionResult['Intervention']['lonic_code']; ?>
						</td>
						<td class="row_format"><?php echo $interventionResult['Intervention']['snomed_code']; ?>
						</td>
						<td class="row_format"><?php echo $this->DateFormat->formatDate2Local($interventionResult['Intervention']['intervention_date'],Configure::read('date_format_us'),false); ?>
						</td>
						<td class="row_format"><?php $inter_id = $interventionResult['Intervention']['id'];
						echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete', 'onclick'=>"delete_intervention($inter_id);return false;")), array(__('Are you sure?', true)), array('escape' => false));
						echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('title'=>'Edit','alt'=>'Edit', 'onclick'=>"edit_intervention($inter_id);return false;")), array(), array('escape' => false));
						?>
						</td>
						</tr>
						<?php	}	
								}
								} else { ?>
						<tr>
							<td colspan="5" align="center" class="error"><?php echo __('No Intervention Results for selected patient', true); ?>.
							</td>
						</tr>
						<?php } ?>
					</table>
				</td>
			</tr>
		</table>
	</div>
	<!-- ajax end of intervention -->
	<h3 style="display: &amp;amp;" id="recommended-decision">
		<a href="#">Recommended Decision Aids</a>
	</h3>
	<div class="section" id="aids">
		<div align="center" id='temp-busy-indicator-aids'
			style="display: none;">
			&nbsp;
			<?php echo $this->Html->image('indicator.gif', array()); ?>
		</div>

		<table border="0" class="table_format" cellpadding="0" cellspacing="0">
			<tr class="row_title">
				<td class="row_format"><label style="float: inherit"><?php echo __('Recommended Decision aids:') ?>
				</label></td>
				<td class="row_format"><?php echo $this->Form->textarea('decision_aids', array('id' => 'decision_aids'  ,'rows'=>'15','style'=>'width:600px')); ?>
				</td>
			</tr>
		</table>
	</div>
	
	<!-- BOF  Risk type option $icdOptions  -->
	<h3 id="risk_category_assessment">
		<a href="#">Risk Category Assessments </a>
	</h3>
	<div class="section" id="category_assessment">
		<!-- Start of Risk category ajax -->
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			class="formFull formFullBorder">
			<tr>
				<td width="27%" align="left" valign="top">
					<div align="center" id='temp-busy-indicator-category_assessment'
						style="display: none;">
						&nbsp;
						<?php echo $this->Html->image('indicator.gif', array()); ?>
					</div>
					<table width="100%" cellpadding="0" cellspacing="1" border="0"
						class="tabularForm">
						<tr>
							<td valign="top">
								<table width="100%" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td class="row_format"><label style="float: inherit"><?php echo __('Risk Category Type:') ?>
										</label></td>
										<td class="row_format"><?php echo $this->Form->input('RiskCategory.icd9cm_risk',array('empty'=>__('Select'),'options'=>$riskStatus,'escape'=>false,'multiple'=>false,'value'=>'',
												'style'=>'width:400px;','id'=>'icd9cm_risk', 'class'=>'textBoxExpnd','label'=>false,'div'=>false,'empty'=> 'Please Select','onChange'=>'javascript:dbProblem("riskcatass")'));
										?>
										</td>
										<td width="162" class="tdLabel2"><?php echo __('Risk Category Name :');?><font
											color="red">*</font>
										</td>
										<td width="400" class="tdLabel2" colspan="4"><?php echo $this->Form->input('RiskCategory.risk_category_name',array('style'=>'width:373px;','id'=>'risk_category_name','readonly'=>'readonly','class'=>'validate[required,custom[mandatory-select]] textBoxExpnd'));
										echo $this->Form->hidden('RiskCategory.snomed_code',array('id'=>'snomed_code_risk','type'=>'text'));
										echo $this->Form->hidden('RiskCategory.lonic_code',array('id'=>'lonic_code_risk','type'=>'text'));
										echo $this->Form->hidden('RiskCategory.id',array('id'=>'risk_id','type'=>'text'));
										?>
										</td>
									</tr>
									<tr>
										<td width="160"><?php echo __('Risk Category Date :');?><font
											color="red">*</font></td>
										<td width="100" class="tdLabel2" align="right" colspan="5"><?php 
										echo $this->Form->input('RiskCategory.risk_category_date',array('class'=>'validate[required,custom[mandatory-date]] textBoxExpnd date','style'=>'width:120px','readonly'=>'readonly','type'=>'text','id'=>'risk_category_date'));
										?></td>
										<td><label class="label" valign="top"> </label>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td width="70%" align="left" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="20"></td>
							<td valign="top" colspan="4"></td>
						</tr>
						<tr>
							<td width="265"><?php echo __('Reason Category Note:') ?>
							</td>
							<td valign="top" colspan="4"><?php echo $this->Form->textarea('RiskCategory.risk_category_note', array('id' => 'risk_category_note'  ,'rows'=>'4','style'=>'width:95%')); ?>
							</td>
						</tr>
						<tr>
							<td width="265"><?php echo __('Risk Category Assessment not done');?>:
							</td>
							<td><?php echo $this->Form->checkbox('RiskCategory.is_riskcheck', array('id' => 'is_riskcheck', )); ?>
							</td>
						</tr>
						<tr>
							<td width="265"><?php echo __('Reason Type:') ?>
							</td>
							<td><?php  echo $this->Form->input('RiskCategory.risk_reason_type', array('style'=>'width:329px; float:left;',
									'empty'=>__('Select'),'options'=>array("Medical Reason"=>"Medical Reason",'Patient Reason'=>'Patient Reason'),
									'id'=>'risk_reason_type','class' => 'textBoxExpnd')); ?></td>
						</tr>
						<tr>
							<td width="265"><?php echo __('Reason Type:') ?>
							</td>

							<td valign="top" colspan="4"><?php echo $this->Form->textarea('RiskCategory.risk_type_note', array('id' => 'risk_type_note'  ,'rows'=>'4','style'=>'width:95%')); ?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td colspan='4' align='right' valign='bottom'><?php  echo $this->Html->link(__('Submit'),"javascript:void(0)",array('id'=>'risk_category_onsubmit','class'=>'blueBtn','onclick'=>"javascript:save_risk_category()")); ?>
				</td>
			</tr>
			<tr>
				<td>
					<table border="0" class="table_format" cellpadding="0"
						cellspacing="0" width="100%" style="text-align: center;">
						<?php if(isset($risk_category_result) && !empty($risk_category_result)){ ?>
						<tr class="row_title">
							<td class="table_cell"><strong> <?php echo  __('Test Name', true); ?>
							</strong></td>
							<td class="table_cell"><strong> <?php echo  __('Loinc Code', true); ?>
							</strong></td>
							<td class="table_cell"><strong> <?php echo  __('Snomed Code', true); ?>
							</strong></td>
							<td class="table_cell"><strong> <?php echo  __('Risk Ctegory Date', true); ?>
							</strong></td>
							<td class="table_cell"><strong> <?php echo  __('Action'); ?>
							</strong></td>
						</tr>
						<?php
						$toggle =0;
						if(count($risk_category_result) > 0) {
									foreach($risk_category_result as $risk_category_result){
											 if(!empty($risk_category_result)) {
											}else{
		                                 			echo "<tr class='row_title'><td colspan='5>&nbsp;</td></tr>" ;
		                                 		}
		                                 		if($toggle == 0) {
												echo "<tr class='row_gray'>";
												$toggle = 1;
										   }else{
												echo "<tr>";
												$toggle = 0;
										   }

										   ?>

						<td class="row_format"><?php echo $risk_category_result['RiskCategory']['risk_category_name']; ?>
						</td>
						<td class="row_format"><?php echo $risk_category_result['RiskCategory']['lonic_code']; ?>
						</td>
						<td class="row_format"><?php echo $risk_category_result['RiskCategory']['snomed_code']; ?>
						</td>

						<td class="row_format"><?php echo $this->DateFormat->formatDate2Local($risk_category_result['RiskCategory']['risk_category_date'],Configure::read('date_format_us'),false); ?>
						</td>

						<td class="row_format"><?php $risk_id = $risk_category_result['RiskCategory']['id'];
						echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete', 'onclick'=>"delete_risk_category($risk_id);return false;")), array(__('Are you sure?', true)), array('escape' => false));
						echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('title'=>'Edit','alt'=>'Edit', 'onclick'=>"edit_risk_category($risk_id);return false;")), array(), array('escape' => false));
						?>
						</td>
						</tr>
						<?php } 
						}
							} else {
					 ?>
						<tr>
							<TD colspan="5" align="center" class="error"><?php echo __('No Risk Category Results for selected patient', true); ?>.
							</TD>
						</tr>
						<?php } ?>
					</table>
				</td>
			</tr>
		</table>
	</div>
	<!-- EOF Risk option -->

</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>
			<div class="btns">
				<?php echo $this->Html->link('Cancel',array('controller'=>'patients','action'=>'listExtraNotes',$patientId),array('class'=>'blueBtn'));?>
				<input type="submit" value="Submit" class="blueBtn" id="soap_submit">
			</div>
		</td>
	</tr>
</table>

<?php echo $this->Form->end(); ?>

<script>


	$(document).ready(function(){

 
		
		$( "#accordionCust" ).accordion({
			autoHeight: false,
			header: "h3",
			active: false,
			collapsible : true,
			//navigation : true,
			change : function(event, ui) {
				//BOF template call
				var currentEleID = $(ui.newContent).attr("id"); 
				var replacedID = "templateArea-"+ currentEleID;
				if (currentEleID == 'event-note' || currentEleID == 'notes') {
					$("#" + replacedID).html($('#temp-busy-indicator').html());
					$("#templateArea-event-note").html('');
					var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'notes', "action" => "add","admin" => false)); ?>";
					$("#" + currentEleID).css('height', 'auto'); 
					$.ajax({
						type : "POST",
						url : ajaxUrl+ "/" + currentEleID,
						data : "updateID="+ replacedID,
						context : document.body,
						beforeSend: function() {
							$("#temp-busy-indicator-"+currentEleID).show();
						},
						complete: function() {
								$("#temp-busy-indicator-"+currentEleID).hide();
						}, 
						success : function(data) {
							$("#"+ replacedID).html(data);
							$("#"+ replacedID).fadeIn();
						}
					});
				}
			}
		});

		
			 
		 
			jQuery("#patientnotesfrm").validationEngine(); 

		
	});
	function dbProblem(from){

		  if(from=='funcresult') {
		     var ajaxUrl = "<?php  echo $this->Html->url(array("controller" => "Patients", "action" => "dbproblem_functionalstatusresult","admin" => false)); ?>";
		     var problem = $('#dbprocedureRe').val();
		  }else if(from=='riskcatass'){
		     var ajaxUrl = "<?php  echo $this->Html->url(array("controller" => "Patients", "action" => "dbproblem_riskcategoryassesment","admin" => false)); ?>";
		     var problem = $('#icd9cm_risk').val();
		  }else if(from=='intervention'){
			  var ajaxUrl = "<?php  echo $this->Html->url(array("controller" => "Patients", "action" => "dbproblem","admin" => false)); ?>";
			  var problem = $('#icd9cm_inter').val();
		  }else{
		     var ajaxUrl = "<?php  echo $this->Html->url(array("controller" => "Patients", "action" => "dbproblem","admin" => false)); ?>";
		     var problem = $('#dbproblem').val();
		  }
	        $.ajax({
	          type: 'POST',
	          url: ajaxUrl+"/"+problem,
	          data: '',
	          dataType: 'html',
	          success: function(data){ 
		      	var data = data.split("|");	
	       		if(from=='funcresult'){
		          $("#result_description").val(data[0]);       
		          $("#test_codeRe").val(data[1]);
		          $("#snomed_codeRe").val(data[2]);
		          $("#loinc_codeRe").val(data[3]);
				}else if(from=='riskcatass'){
	         		$("#risk_category_name").val(data[0]);       
	      			$("#snomed_code_risk").val(data[2]);
	       			$("#lonic_code_risk").val(data[3]);
				}else if(from=='intervention'){
					$("#intervention_name").val(data[0]);       
			        $("#snomed_codepr").val(data[2]);
			        $("#lonic_code_inter").val(data[3]);
			    }else{
					$("#SNOMED_DESCRIPTION").val(data[0]);
		          	$("#SCT_US_CONCEPT_ID").val(data[3]);
		          	$("#SCT_CONCEPT_ID").val(data[2]);
		   		}
				},
					error: function(message){
	              alert("Internal Error Occured. Unable to set data.");
	        }        
	      });
	    return false; 
	}

	//----------BOF of function related to risk category------------
	function save_risk_category(id){
		switch (true) {
			case ($('#risk_category_date').val() == '' && $('#risk_category_name').val() == ''):
				 alert('Please Enter Category Name and Date.');
		        return false;
		    case ($('#risk_category_name').val() == '' && $('#risk_category_date').val() != ''):
		        alert('Please Enter Category Name.');
		    	return false;
		    case ($('#risk_category_date').val() == '' && $('#risk_category_name').val() != '' ):
		       alert("Please Enter Date.");
		    	return false;
	     }
		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "save_riskCategory",$patientId,"admin" => false)); ?>";
		var formData = $('#patientnotesfrm').serialize();
	   $.ajax({
         	type: 'POST',
        	url: ajaxUrl,
	         data: formData,
	         dataType: 'html',
	         success: function(data){
	        	 if(data != 'Please Insert Data'){
	         		alert("Risk Category Sucessfully Saved");
	         		$("#risk_category_name").val('');
			        $("#snomed_code_risk").val('');
			        $("#risk_id").val('');
			        $("#lonic_code_risk").val('');
			        $("#is_riskcheck").attr('checked',false);
			        $("#risk_reason_type").val('')
			         $("#risk_type_note").val('')
				}else{
                 //-----don't comment it. its error message
                 alert(data);
             	}
		    },
			error: function(message){
             alert("Internal Error Occured. Unable To Save Data.");
        	}        
         });
   		return false;
	}

	function edit_risk_category(id){
		
		  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "edit_riskCategory","admin" => false)); ?>";
		   var formData = $('#patientnotesfrm').serialize();
	        $.ajax({
	            type: 'POST',
	           url: ajaxUrl+"/"+id,
	            data: formData,
	            dataType: 'html',
	            success: function(data){
					var data = data.split("|");	
					$("#risk_category_name").val(data[0]);
			        $("#snomed_code").val(data[1]);
			        $("#risk_category_note").val(data[2]);
			        $("#risk_id").val(data[3]);
			        $("#lonic_code_risk").val(data[4]);
			        $("#risk_category_date").val(data[6]);
			        if(data[7]!=''){
			        $("#is_riskcheck").attr('checked','checked');;
			        }
			        $("#risk_reason_type").val(data[8]);
			        $("#risk_type_note").val(data[9]);
		       },
				error: function(message){
					alert("Error in Retrieving data");
	            }        
	         });
	       return false; 
	}

	function delete_risk_category(id){
		if (confirm("Are you sure?")) {
	       var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "delete_riskCategory","admin" => false)); ?>";
		   var formData = $('#patientnotesfrm').serialize();
	           $.ajax({
	            type: 'POST',
	           url: ajaxUrl+"/"+id,
	            data: formData,
	            dataType: 'html',
	            success: function(data){
	            	alert('Record Deleted Sucessfully');
	            },
				error: function(message){
					alert("Cannot Process Your Request");
	            }        
	       });
	     }
	    return false;
	}

	$(".date").datepicker({
		showOn : "button",
		buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly : true,
		changeMonth : true,
		changeYear : true, 
		dateFormat:'<?php echo $this->General->GeneralDate(false);?>',
		onSelect : function() {
			$(this).focus();
		}
	});
	//----------EOF of function related to intervention------------
	function createSnomedTitle(data){
		 var options = '';
		 options += "<option value= ''>Please Select</option>";
		  $.each(data, function(index, name) {
		 	options += '<option value=' + index + '>' + name.SnomedMappingMaster.sctName + '</option>';
		 });
		 return options;
	} 
	 
	function snomed_problem() 
	{ 
		var searchtest = $('#searchProcedure').val();
		if(searchtest == undefined) {
			var searchtest = $('#searchResult').val();
		}
		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "diagnoses", "action" => "snowmed",$patientId,"admin" => false)); ?>"+'/'+searchtest;
	 	var formData = $('#patientnotesfrm').serialize();
	
	   $.ajax({
           type: 'POST',
          url: ajaxUrl,
           data: formData,
           dataType: 'html',
           //--------------
           beforeSend: function() {
				$("#temp-busy-indicator-functional-result").show();
           	},
			complete: function() {
				$("#temp-busy-indicator-functional-result").hide();
			}, 
           //-------------SNOMED_DESCRIPTION SCT_US_CONCEPT_ID SCT_CONCEPT_ID
           success: function(data){ 
	       data = JSON && JSON.parse(data) || $.parseJSON(data);
           	titleData = createSnomedTitle(data);
			if(searchtest == ''){
            	$('#problem').html(titleData);
           	}
           	if($('#searchProcedure').val() != ''){
           		$('#procedure').html(titleData);
           	}
           	if($('#searchResult').val() != ''){
           		$('#result').html(titleData);
           	}	
           },
			error: function(message){
			 alert("Internal Error Occured. Unable To Save Data.");
           },       
           });
     
     return false;
		
	}

	function createTitle(data){
		 var options = '';
		 options += '<option value="">Please Select</option>';
		  $.each(data, function(index, name) {
		  options += '<option value=' + index + '>' + name + '</option>';
		 });
		 return options;
		 }
	 
	function snomed_LabRAd_test() 
	{ 	var searchtest = '';
		searchtest = $('#search_funct').val();
		if(searchtest == '' || searchtest == undefined) {
			var searchtest = $('#search_cog').val();
		}
		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "billings", "action" => "snowmed",$patientId,"admin" => false)); ?>";
		$.ajax({
	            type: 'POST',
	           	url: ajaxUrl+"/"+searchtest,
	            dataType: 'html',
	            beforeSend: function() {
					$("#temp-busy-indicator-functional").show();
					$("#temp-busy-indicator-cognitive").show();
	            },
	    		complete: function() {
	    				$("#temp-busy-indicator-functional").hide();
	    				$("#temp-busy-indicator-cognitive").hide();
	    		}, 
	            success: function(data){
		            data = JSON && JSON.parse(data) || $.parseJSON(data);
	            	titleData = createTitle(data.testTitle);
	            	codeIndex = data.testCode;
	            	SctCode = data.SctCode;
	            	LonicCode = data.LonicCode;
	            	if($('#search_funct').val() == undefined || $('#search_funct').val() == '') {
	            		$('#SelectLeft').html(titleData);
	            	}else{
	            		$('#SelectLeft_funct').html(titleData);
	            	}
	            	$('#search_funct').val('');
	            	$('#search_cog').val('');
	            },
				error: function(message){
	                alert("Internal Error Occured. Unable To Save Data.");
	            },       
	      });
	      
	      return false;
		
	}

	function changeTest1(){
		var e = document.getElementById("SelectLeft_funct");
	    var strUser = e.options[e.selectedIndex].text; 
		testnameIndex = e.selectedIndex;
		document.getElementById("funct_snomed_code").value = SctCode[testnameIndex];
		$('#funct_name').val(strUser);
	}

	function changeTest() 
	{
		var e = document.getElementById("SelectLeft");
	    var strUser = e.options[e.selectedIndex].text; 
		testnameIndex = e.selectedIndex;
		document.getElementById("cog_snomed_code").value = SctCode[testnameIndex];
		$('#cog_name').val(strUser);
	}
	
	//-----------result
	
	function save_result(){

		switch (true) {
		case ($('#result_date').val() == '' && $('#result_description').val() == ''):
			 alert('Please Enter Result Name and Date.');
	        return false;
	    case ($('#result_description').val() == '' && $('#result_date').val() != ''):
	        alert('Please Enter Result Name.');
	    	return false;
	    case ($('#result_date').val() == '' && $('#result_description').val() != '' ):
	       alert("Please Enter Date.");
	    	return false;
	    }
		 
			var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "save_result",$patientId,"admin" => false)); ?>";
			var formData = $('#patientnotesfrm').serialize();
		  	$.ajax({
	            type: 'POST',
	           url: ajaxUrl,
	            data: formData,
	            dataType: 'html',
	            success: function(data){
	            	 alert("Result Sucessfully Saved");
	            	$("#result_description").val('');
			        $("#test_codeRe").val('');
			        $("#loinc_codeRe").val('');
			        $("#snomed_codeRe").val('');
			        $("#cpt_codeRe").val('');
			        $("#result_date").val('');
			        $("#result_instruction").val('');
			        $("#dignostic_idRe").val('');
		          },
				error: function(message){
	                alert("Internal Error Occured. Unable To Save Data.");
	            }        
	            });
	      
	      return false;
		}

		function edit_result(id){
			
			  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "edit_result","admin" => false)); ?>";
			   var formData = $('#patientnotesfrm').serialize();
		           $.ajax({
		            type: 'POST',
		           url: ajaxUrl+"/"+id,
		            data: formData,
		            dataType: 'html',
		            success: function(data){
						var data = data.split("|");	
				        $("#result_description").val(data[0]);
				        $("#test_codeRe").val(data[1]);
				        $("#loinc_codeRe").val(data[2]);
				        $("#snomed_codeRe").val(data[3]);
				        $("#cpt_codeRe").val(data[4]);
				        $("#result_date").val(data[5]);
				        $("#result_instruction").val(data[6]);
				        $("#dignostic_idRe").val(data[7]);
					},
					error: function(message){
						alert("Error in Retrieving data");
		            }        
		          });
		      return false; 
		}

		function delete_result(id){
			if (confirm("Are you sure?")) {
		       var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "delete_result","admin" => false)); ?>";
			   var formData = $('#patientnotesfrm').serialize();
		           $.ajax({
			            type: 'POST',
			           	url: ajaxUrl+"/"+id,
			            data: formData,
			            dataType: 'html',
			            success: function(data){
						alert('Record Deleted Sucessfully');
			            },
						error: function(message){
							alert("Cannot Process Your Request");
			            }        
		            });
			}
		    return false;
		}

		//----------BOF of function related to intervention------------

		function save_intervention(){
			switch (true) {
			case ($('#intervention_date').val() == '' && $('#intervention_name').val() == ''):
				 alert('Please Enter Intervention Name and Date.');
		        return false;
		    case ($('#intervention_name').val() == '' && $('#intervention_date').val() != ''):
		        alert('Please Enter Intervention Name.');
		    	return false;
		    case ($('#intervention_date').val() == '' && $('#intervention_name').val() != '' ):
		       alert("Please Enter Date.");
		    	return false;
		    }
		 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "save_interventions",$patientId,"admin" => false)); ?>";
		var formData = $('#patientnotesfrm').serialize();
		  $.ajax({
	          type: 'POST',
	          url: ajaxUrl,
	          data: formData,
	          dataType: 'html',
	          success: function(data){
	        	  if(data != 'Please Insert Data'){
		          	alert("Intervention Sucessfully Saved");
		          	$("#intervention_name").val('');
			        $("#test_codepr").val('');
			        $("#snomed_codepr").val('');
			        $("#id").val('');
	        	  }else{
	                  //-----don't comment it. its error message
	                  alert(data);
	              }
			   },
				error: function(message){
	              alert("Internal Error Occured. Unable To Save Data.");
	          }        
		});
	    return false;
		}
		
		function edit_intervention(id){
			
			  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "edit_interventions","admin" => false)); ?>";
			   var formData = $('#patientnotesfrm').serialize();
		           $.ajax({
		            type: 'POST',
		            url: ajaxUrl+"/"+id,
		            data: formData,
		            dataType: 'html',
		            success: function(data){
						var data = data.split("|");	
				        $("#intervention_name").val(data[0]);
				        $("#snomed_code").val(data[1]);
				        $("#intervention_note").val(data[2]);
				        $("#id_inter").val(data[3]);
				        $("#intervention_date").val(data[6]);
		            },
					error: function(message){
						alert("Error in Retrieving data");
		            }        
		          });
		      return false; 
		}

		function delete_intervention(id){
			if (confirm("Are you sure?")) {
		       var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "delete_interventions","admin" => false)); ?>";
			   var formData = $('#patientnotesfrm').serialize();
		           $.ajax({
		            type: 'POST',
		           url: ajaxUrl+"/"+id,
		            data: formData,
		            dataType: 'html',
		            success: function(data){
		            	alert('Record Deleted Sucessfully');
		            },
					error: function(message){
						alert("Cannot Process Your Request");
		            }        });
		       }
		    return false;
		}
		//----------EOD of function related to intervention------------

		jQuery(document).ready(function() {
		var height,weight, bmi, message;
		jQuery.fn.checkBMI = function() {
			// on load set bmi
			height = jQuery("#height").val();
			weight = jQuery("#weight").val();

			bmi = weight / (height * height) * 703;
			if(height== ''){
				jQuery("#bmi").val("");
			}else{
				if(isNaN(height) || isNaN(weight))
					 jQuery("#bmi").val("");
					else
					 jQuery("#bmi").val(bmi);	
			}
			if (bmi < 18.5) {
				message = "Underweight";
			} else if (bmi > 18.5 && bmi <= 23) {
				message = "Normal";
			} else if (bmi >= 23.1 && bmi <= 30) {
				message = "Overweight";
			} else if (bmi >= 30) {
				message = "Obese";
			}
			jQuery("#bmiStatus").html(message);
		};
		jQuery("#bmi").checkBMI();

		jQuery('#height, #weight').change(function() {
			jQuery("#bmi").checkBMI();
		});
	});

	$("#doctor_id_txt").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","DoctorProfile",'user_id',"doctor_name",'null',"admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true,
			valueSelected:true,
			showNoId:true,
			loadId : 'doctor_id_txt,sb_registrar'
	});
	</script>
