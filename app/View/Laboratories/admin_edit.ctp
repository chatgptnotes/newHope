<style>
#first_table .textBoxExpnd {
	width: 100%;
}

  /*----- Tabs -----*/
.tabs {
	width: 100%;
	display: inline-block;
}

/*----- Tab Links -----*/ /* Clearfix */
.tab-links:after {
	display: block;
	clear: both;
	content: '';
}

.tab-links li {
	margin: 0px 5px;
	float: left;
	list-style: none;
}

.tab-links a {
	padding: 9px 15px;
	display: inline-block;
	border-radius: 3px 3px 0px 0px;
	background: #7FB5DA;
	font-size: 11px;
	font-weight: 600;
	color: #4c4c4c;
	transition: all linear 0.15s;
}

.tab-links a:hover {
	background: #a7cce5;
	text-decoration: none;
}

li.active a,li.active a:hover {
	background: #fff;
	color: #4c4c4c;
}

/*----- Content of Tabs -----*/
.tab-content {
	padding: 15px;
	border-radius: 3px;
	box-shadow: -1px 1px 1px rgba(0, 0, 0, 0.15);
	background: #fff;
}

.tab {
	display: none;
}

.tab.active {
	display: block;
}

.tdLabellableCustom {
	color: #000;
	font-size: 14px;
}
.ui-widget-content{
	color:#222222 !important;
	font-size:12px;
}
.blueBtn {
    left: 1px;
}
</style>

<?php
echo $this->Html->script ( 'jquery.autocomplete' );
echo $this->Html->css ( 'jquery.autocomplete.css' );
?>

<div class="inner_title">

	<?php
	if (isset ( $cat_id ) && ! empty ( $cat_id )) {
	?>
	<h3>
		<?php echo __('Edit Test', true); ?>
	</h3>
	<?php }else{ ?>
	<h3>
		<?php echo __('View Test', true); ?>
	</h3>
	<?php } ?>
	<span><?php echo $this->Html->link(__('Back to list'),array('action'=>'index'),array('escape'=>false,'class'=>'blueBtn')); ?>
	</span>
</div>
<?php
if (! empty ( $errors )) {
	?>
<table border="0" cellpadding="0" cellspacing="0" width="100%"
	align="center">
	<tr>
		<td colspan="2" align="left" class="error"><div>
				<?php
				foreach ( $errors as $errorsval ) {
		echo $errorsval [0];
		echo "<br />";
	}

	?>
			</div></td>
	</tr>
</table>
<?php } ?>

<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
		jQuery("#laboratoryFrm").validationEngine();
		 if('<?php echo $setData ['Laboratory'] ['lab_type']==2 ?>'){
			displayHistoTestOrder();
		 }
	});
	
</script>
<!--BOF lab Forms -->
<div>&nbsp;</div>
<?php
echo $this->Form->create ( 'Laboratory', array (
		'action' => 'edit',
		'id' => 'laboratoryFrm',
		'inputDefaults' => array (
				'label' => false,
				'div' => false,
				'error' => false
		)
) );

// debug($setData1);debug($setData);
// debug($setData1[0]['Laboratory']['id']);?>
<table width="100%" cellpadding="0" cellspacing="0" border="0"
	align="center" id="first_table">
	<tr>
		<td>
			<table align="center" width="100%">
				<tr>
					<td class="tdLabel" id="boxSpace">Select Sub Specialty:<font
						color="red"> *</font>
					</td>
					<td><?php
					echo $this->Form->input ( 'Laboratory.test_group_id', array (
									'options' => $testGroup,
									'empty' => __ ( 'Select Sub Specialty' ),
									'escape' => false,
									'id' => 'test_group_id',
									'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd',
									'autocomplete' => 'off',
									'style' => '',
									'value' => $setData ['Laboratory'] ['test_group_id']
							) );
							?>
					</td>
				</tr>
				<tr>
					<td class="tdLabel" id="boxSpace">Set as Default:</td>
					<td><?php
					echo $this->Form->input ( 'Laboratory.template_lab', array (
									'type' => 'checkbox',
									'escape' => false,
									'id' => '',
									'autocomplete' => 'off',
									'style' => '',
									'value' => $setData ['Laboratory'] ['template_lab']
							) );
							?>
					</td>
				</tr>
				<tr>
					<td class="tdLabel" id="boxSpace">Test Name<font color="red"> *</font>
					</td>
					<td><?php
					if (isset ( $test_name ) && ! empty ( $test_name )) {
																													$read_only = 'readonly';
																												} else {
																													$read_only = '';
																													$test_name = isset ( $setData ['Laboratory'] ['name'] ) ? $setData ['Laboratory'] ['name'] : '';
																												}
																												echo $this->Form->input ( 'Laboratory.name1', array (
																														'class' => 'textBoxExpnd validate[required,custom[mandatory-enter]]',
																														'autocomplete' => 'off',
																														'value' => $test_name,
																														'id' => 'name1',
																														'readonly' => $read_only
																												) );
																												echo $this->Form->hidden ( 'Laboratory.name', array (
																														'id' => 'name'
																												) );
																												echo $this->Form->hidden ( 'Laboratory.id', array (
																														'id' => 'labId'
																												) );
																												?>
					</td>
				</tr>
				<tr>
					<td class="tdLabel" id="boxSpace"><?php echo __('Interface Code');?> :</td>
					<td><?php echo $this->Form->input('Laboratory.test_code', array('class' => 'textBoxExpnd ', 'autocomplete'=>'off','id' => 'test_code','value'=>$setData['Laboratory']['test_code']));?>
					</td>
				</tr>
				<tr>
					<td class="tdLabel" id="boxSpace"><?php echo __('Test Order');?> :</td>
					<td><?php
					echo $this->Form->input ( 'Laboratory.sort_order', array (
																														'class' => 'textBoxExpnd ',
																														'id' => 'sort_order',
																														'value' => $setData ['Laboratory'] ['sort_order']
																												) );
																												?>
					</td>
				</tr>
				<tr>
					<td class="tdLabel" id="boxSpace"><?php echo __('ICD 10 Code');?> :</td>
					<td><?php
					echo $this->Form->input ( 'Laboratory.icd10_code', array (
																														'class' => 'textBoxExpnd ',
																														'autocomplete' => 'off',
																														'id' => 'icd10_code',
																														'value' => $setData ['Laboratory'] ['icd10_code']
																												) );
																												?>
					</td>
				</tr>

				<tr>
					<td class="tdLabel" id="boxSpace"><?php echo __('CGHS Code');?> :</td>
					<td><?php
					echo $this->Form->input ( 'Laboratory.cghs_code', array (
																														'class' => 'textBoxExpnd ',
																														'autocomplete' => 'off',
																														'id' => 'cghs_code',
																														'value' => $setData ['Laboratory'] ['cghs_code']
																												) );
																												?>
					</td>
				</tr>
				<tr>
					<td class="tdLabel" id="boxSpace"><?php echo __('RSBY Code');?> :</td>
					<td><?php
					echo $this->Form->input ( 'Laboratory.rsby_code', array (
																														'class' => 'textBoxExpnd ',
																														'autocomplete' => 'off',
																														'id' => 'rsby_code',
																														'value' => $setData ['Laboratory'] ['rsby_code']
																												) );
																												?>
					</td>
				</tr>
				<tr>
					<td class="tdLabel" id="boxSpace">Loinc Code:</td>
					<td><?php

					$read_only = "";
					if ($setData ['Laboratory'] ['lonic_code'])
						$read_only = "readonly";
					echo $this->Form->input ( 'Laboratory.lonic_code', array (
									'value' => $setData ['Laboratory'] ['lonic_code'],
									'class' => 'textBoxExpnd ',
									'autocomplete' => 'off',
									'id' => 'lonic_code',
									'readonly' => $read_only
							) );
							?></td>
				</tr>
				<tr>
					<td class="tdLabel" id="boxSpace">CPT Code:</td>
					<td><?php

					$read_only = "";
					if ($data ['Laboratory'] ['cbt'])
						$read_only = "readonly";
					echo $this->Form->input ( 'Laboratory.cbt', array (
									'value' => $setData ['Laboratory'] ['cbt'],
									'class' => 'textBoxExpnd',
									'autocomplete' => 'off',
									'id' => 'cbt',
									'readonly' => $read_only
							) );
							?></td>
				</tr>
				<tr>
					<td class="tdLabel" id="boxSpace"><?php echo __('Machine Name');?>
						:</td>
					<td><?php
					echo $this->Form->input ( 'Laboratory.machine_name', array (
																														'class' => 'textBoxExpnd ',
																														'autocomplete' => 'off',
																														'id' => 'machine_name',
																														'value' => $setData ['Laboratory'] ['machine_name']
																												) );
																												?>
					</td>
				</tr>
				<tr>

					<td class="tdLabel" id="boxSpace"><?php echo __('Title Machine Name');?>
						:</td>
					<td><?php
					echo $this->Form->input ( 'Laboratory.machine_title_name', array (
							'options' => Configure::read ( 'lab_machine_list' ),
							'empty' => 'Please Select',
							'class' => 'textBoxExpnd ',
							'id' => 'machine_title_name',
							'value' => $setData ['Laboratory'] ['machine_title_name']
					) );
					?>
					</td>
				</tr>
				<tr>
					<td class="tdLabel" id="boxSpace"><?php echo __('Sample Type');?> :</td>
					<td><?php
					echo $this->Form->input ( 'Laboratory.specimen_collection_type', array (
							'empty' => 'Please Select',
							'options' => $specimentTypes,
							'class' => 'textBoxExpnd ',
							'id' => 'specimen_collection_type',
							'value' => $setData ['Laboratory'] ['specimen_collection_type']
					) );
					?>
					</td>
				</tr>
				<tr>
					<td class="tdLabel"> <?php 
					
					echo __("Is Header").$this->Form->input('Laboratory.is_header',array('type'=>'checkbox','div'=>false,'label'=>false,'class'=>'category','id'=>'isHeader','value'=>$setData ['Laboratory'] ['is_header']));  ?>
					</td>
				</tr>
				<tr>
					<td class="tdLabel" id="boxSpace"><?php echo __('Test Method');?> :</td>
					<td><?php
					echo $this->Form->input ( 'Laboratory.test_method', array (
																														'type' => 'textarea',
																														'class' => 'textBoxExpnd ',
																														'id' => 'test_method',
																														'value' => $setData ['Laboratory'] ['test_method']
																												) );
																												?>
					</td>
				</tr>
				<!--  
				<tr>
					<td valign="top"><?php echo $this->Html->image('icons/plus_6.png', array('id'=>'addMoreDr','title'=>'Add','class'=>'addMoreDr'));?>
								<?php echo __('Doctor Name')?></td>
					<td>
						<table width="100%" id='addTr'>
										<?php
										$exploadDrId = explode ( ',', $setData ['Laboratory'] ['doctor_id'] );
										
										foreach ( $exploadDrId as $key => $docValue ) {
											?>
									<tr>
								<td>
									<?php
											
											if ($docValue) {
												echo $doctor_id [$docValue];
											} else {
												echo $this->Form->input ( '', array (
														'name' => 'data[Laboratory][doctor_id_txt][]',
														'type' => 'text',
														'id' => 'doctor_id_txt_0',
														'label' => false,
														'class' => 'doctor_id_txt textBoxExpnd',
														'value' => $doctor_id [$docValue] 
												) );
											}
											echo $this->Form->hidden ( '', array (
													'name' => 'data[Laboratory][doctor_id][]',
													'label' => false,
													'type' => 'text',
													'id' => 'doctor_id_0',
													'class' => 'validate[required,custom[mandatory-enter]]',
													'value' => $docValue 
											) );
											?>
											
										</td>
							</tr>
										<?php }?>
								</table>

					</td>

				</tr>
-->

			</table>
		</td>
		<td width='10%'></td>
		<td>
			<table align="center" width="75%">

				<tr>
					<td class="tdLabel" id="boxSpace"><?php echo __('Short Form');?> :</td>
					<td><?php
					echo $this->Form->input ( 'Laboratory.dhr_order_code', array (
																														'class' => 'textBoxExpnd ',
																														'autocomplete' => 'off',
																														'id' => 'dhr_order_code',
																														'value' => $setData ['Laboratory'] ['dhr_order_code']
																												) );
																												?>
					</td>
				</tr>
				<tr>
					<td class="tdLabel" id="boxSpace"><?php echo __('Preparation Time');?>
						:</td>
					<td width="300"><?php
					echo $this->Form->input ( 'Laboratory.preparation_time', array (
																														'class' => 'textBoxExpnd ',
																														'autocomplete' => 'off',
																														'id' => 'preparation_time',
																														'value' => $setData ['Laboratory'] ['preparation_time']
																												) );
																												?>
					</td>
				</tr>
				<tr>
					<td class="tdLabel" id="boxSpace"><?php echo __('Specific Instruction For Preparation');?>
						:</td>
					<td><?php
					echo $this->Form->input ( 'Laboratory.instructions_for_preparation', array (
																														'class' => 'textBoxExpnd ',
																														'autocomplete' => 'off',
																														'id' => 'instructions_for_preparation',
																														'value' => $setData ['Laboratory'] ['instructions_for_preparation']
																												) );
																												?>
					</td>
				</tr>
				<tr>
					<td class="tdLabel" id="boxSpace"><?php echo __('Attach File');?> :</td>
					<td><?php
					echo $this->Form->input ( 'Laboratory.is_file_attached', array (
									'div' => false,
									'type' => 'radio',
									'legend' => false,
									'id' => 'is_file_attached',
									'separator' => ' ',
									'default' => '0',
									'value' => $setData ['Laboratory'] ['is_file_attached'],
									'options' => array (
											'1' => 'Yes ',
											'0' => 'No'
									)
							) );
							?>
					</td>
				</tr>
				<tr>
					<td class="tdLabel" id="boxSpace">Select Service Group:<font
						color="red">*</font>
					</td>
					<td><?php
					echo $this->Form->input ( 'Laboratory.service_group_id', array (
									'options' => $serviceGroup,
									'empty' => __ ( 'Select Service Group' ),
									'escape' => false,
									'id' => 'service_group_id',
									'selected' => $setData ['Laboratory'] ['service_group_id'],
									'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd',
									'autocomplete' => 'off',
									'style' => 'width:94%;',
									'autocomplete' => 'off'
							) );
							?>
					</td>
				</tr>
				<tr>
					<td class="tdLabel" id="boxSpace">Map Test To Service:<font
						color="red">*</font>
					</td>
					<td><?php
					echo $this->Form->input ( '', array (
									'id' => 'lab_name',
									'name' => 'lab_name',
									'value' => 'Search Service',
									'autocomplete' => 'off',
									'type' => 'text',
									'class' => ''
							) );
							echo $this->Form->input ( 'Laboratory.tariff_list_id', array (
									'options' => $tariffList,
									'label' => false,
									'style' => 'width:64%;',
									'class' => 'validate[required,custom[mandatory-select]] ',
									'id' => 'tarifflist',
									'empty' => __ ( 'Select Service' ),
									'value' => $setData ['Laboratory'] ['tariff_list_id']
							) );
							?>
					</td>
				</tr>

				<tr>
					<td class="tdLabel" id="boxSpace"><?php echo __('Parameter (Panel Test)');?>
						:<font color="red"> *</font></td>
					<td><?php
					echo $this->Form->input ( 'Laboratory.is_panel', array (
									'div' => false,
									'type' => 'radio',
									'legend' => false,
									'id' => 'is_panel',
									'class' => 'validate[required,custom[mandatory-select]] is_panel_test',
									'separator' => ' ',
									'default' => '0',
									'value' => $setData ['Laboratory'] ['is_panel'],
									'options' => array (
											'0' => 'Single ',
											'1' => 'Multiple'
									)
							) );

							?></td>
				</tr>

				<tr class="classDescriptive">
					<td class="tdLabel" id="boxSpace">&nbsp;</td>
					<td><?php
					echo $this->Form->input ( 'Laboratory.is_descriptive', array (
									'div' => false,
									'type' => 'radio',
									'legend' => false,
									'id' => 'is_descriptive',
									'class' => 'is_descriptive',
									'separator' => ' ',
									'value' => $setData ['Laboratory'] ['is_descriptive'],
			
									// 'default' => '0',
									'options' => array (
											'0' => 'Non-Descriptive ',
											'1' => 'Descriptive'
									)
							) );

							?></td>
				</tr>
				<tr class="classTestResultHelp">
					<td class="tdLabel" id="boxSpace"><?php echo __('Test Result Help');?>
						:</td>
					<td><?php
					echo $this->Form->input ( 'Laboratory.test_result_help', array (
										'options' => '',
										'empty' => __ ( 'Select Test Result' ),
										'escape' => false,
										'id' => 'test_result_help',
										'class' => ' textBoxExpnd',
										'autocomplete' => 'off',
										'style' => '',
										'value' => $setData ['Laboratory'] ['test_result_help']
								) );
								?>
					</td>
				</tr>
				<tr class="classTestResultDefault">
					<td class="tdLabel" id="boxSpace"><?php echo __('Default Result');?>
						:</td>
					<td><?php
					echo $this->Form->input ( 'Laboratory.default_result', array (
																														'class' => 'textBoxExpnd ',
																														'autocomplete' => 'off',
																														'id' => 'default_result',
																														'value' => $setData ['Laboratory'] ['default_result']
																												) );
																												?>
					</td>
				</tr>
				<tr>
					<td class="tdLabel" id="boxSpace"><?php echo __('Note/Opinion Display Text');?>
						:</td>
					<td><?php
					echo $this->Form->input ( 'Laboratory.notes_display_text', array (
							'type' => 'text',
							'class' => 'textBoxExpnd',
							'id' => 'notes_display_text'
					) );
					?>
					</td>
				</tr>
				<tr>
					<td class="tdLabel" id="boxSpace"><?php echo __('Note/Opinion Template');?>
						:</td>
					<td><?php
					echo $this->Form->textarea ( 'Laboratory.notes', array (
							'class' => 'textBoxExpnd',
							'id' => 'note',
							'rows' => 5,
							'value' => $setData ['Laboratory'] ['notes']
					) );
					?>
					</td>
				</tr>
				<tr>
					<td class="tdLabel" id="boxSpace"><?php echo __('Speciality');?> :<font
						color="red"> *</font></td>
					<td><?php

					echo $this->Form->input ( 'Laboratory.lab_type', array (
																														'empty' => __ ( 'Please Select' ),
																														'class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd lab_type',
																														'id' => 'lab_type',
																														'options' => Configure::read ( 'lab_type' ),
																														'value' => $setData ['Laboratory'] ['lab_type']
																												) );
																												?>
					</td>
				</tr>
				<?php 
					if($setData ['Laboratory']['lab_type'] == '1'){
						 $showregShow = 'none';
					}elseif($setData ['Laboratory']['lab_type'] == '2'){
						$showregShow = 'blank';
					}elseif($setData ['Laboratory']['lab_type'] == '3'){
						$showregShow = 'blank';
					}else{
						$showregShow = 'none';
					}
				?>
                               
             <tr style="display:<?php echo $showregShow;?>">
					<td class="tdLabel histoCategoriesSubSect" style=""><?php echo __('Histo Categories');?> :<font color="red"> *</font></td>
					<td class="histoCategoriesSubSect"><?php
					
					echo $this->Form->input ( 'Laboratory.histo_sub_categories', array (
							'empty' => __ ( 'Please Select' ),
							'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd',
							'id' => 'histo_sub_categories',
							'options' => Configure::read ( 'lab_histo_template_sub_groups' ),
							 
							//'selected' => '' 
					) );
					?>
					</td>
			</tr>
				
				
				<!--~~~~Culture & sensitivity  -->
				<!--  <tr style="display:<?php echo $showregShow;?>">
					<td class="tdLabel Culture-Sensitivity" style=""><?php echo __('Category');?>
						:</td>
					<td class="Culture-Sensitivity"><?php

					echo $this->Form->input ( 'Laboratory.histo_sub_categories', array (
							'empty' => __ ( 'Please Select' ),
							'class' => 'validate[custom[mandatory-enter]] textBoxExpnd',
							'id' => 'histo_sub_categories',
							'options' => Configure::read ( 'CultureSensitivityGroup' ),

					) );
					?></td>
				</tr>
-->
			</table>
		</td>
	</tr>
</table>

<p class="ht5"></p> 
<!-- BOF-For histopathology_data -->
<?php if($setData ['Laboratory'] ['lab_type'] == 2){?>
<table width="100%" cellpadding="0"
	cellspacing="1" border="0" class="tabularForm showForHistopathology"
	align="center" id="TestGroupHistopathology" style="">
	<tr drmAttr="-1">
		<th width="5%">Sr. No.1</th>
		<th width="25%">Attribute Name</th>
		<th width="60%">Description</th>
		<th width="5%">Action</th>
	</tr>

	<!--  //histo-->
	<?php  //dpr($setData ['LaboratoryParameter']);?>
	<?php if(empty($setData ['LaboratoryParameter'])){

		$count_histopathology = 3;
		$getHistopathology = Configure::read ( 'histopathology_data_drm' );
		
		$tempForConfig = Configure::read('lab_histo_template_sub_groups_mapping');
		foreach ( $getHistopathology as $key => $getData ) { 
			?>
	<tr drmAttr="<?php echo $key;?>" id="TestGroupHistopathology_<?php echo $key ?>" class="getRow getRowClass"">
		<td valign="top" style="padding-top: 10px;" id="indexNum<?php echo $key+1;?>"><?php echo $key;?></td>
		<td valign="top"><?php

		echo $this->Form->input ( '', array (
						'name' => "data[LaboratoryHistopathology][$key][attribute]",
						'class' => "histoAttrDefault",
						'label' => false,
						'div' => false,
						'error' => false,
						'id' => 'histoAttrName'.$key,
						'value' => $getData,
						'type' => 'text',
						//'disabled'=>'disabled',
						'style'=>'width:280px;'
				) );
				?>
		</td>
		<td style="padding-top: 10px;"><?php

		echo $this->Form->textarea ( '', array (
						'name' => "data[LaboratoryHistopathology][$key][parameter_text_histo]",
						'id' => 'histoAttrValue'.$key,
						'label' => false,
						'div' => false,
						'error' => false,
						'style' => 'width:682px',
						'type' => 'text',
						'value' => '',
						'class'=>'histoAttrDefault',
						//'disabled'=>'disabled'
				) );
				?>
		</td>
		<td><?php

		echo $this->Html->link ( $this->Html->image ( 'icons/close-icon.png' ), 'javascript:return false;', array (
						'id' => "removeButtonHistopathology_$key",
						'escape' => false,
						'class' => 'removeBtnHistopathology',
						'title' => 'Remove'
				) );

				?>
		</td>
	</tr>
	<?php

	$counterInc = $key;
	$count_histopathology ++;
			}



	}else{?>
	<?php

	$isDisplayed = array ();
	$histoCountNo = 1;
	foreach ( $setData ['LaboratoryParameter'] as $key => $getData ) { 
								?>
	<tr drmAttr="<?php echo $key;?>" id="TestGroupHistopathology_<?php echo $key ?>" class="getRow getRowClass" ">
		<?php echo $this->Form->hidden('',array('name'=>"data[LaboratoryHistopathology][$key][id]",'type'=>'text','value'=>$getData['id']))?>
		<td valign="top" style="padding-top: 10px;" id="indexNum<?php echo $key+1;?>"><?php echo $histoCountNo?></td>
		<td valign="top"><?php

		echo $this->Form->input ( '', array (
										'name' => "data[LaboratoryHistopathology][$key][attribute]",
										'class' => "histoAttrDefault",
										'label' => false,
										'div' => false,
										'error' => false,
										'id' => 'histoAttrName'.$key,
										'value' => $getData ['name'],
										'type' => 'text',
										'disabled'=>'disabled',
										'style'=>'width:280px;'
								) );
								?>
		</td>
		<td style="padding-top: 10px;"><?php

		echo $this->Form->textarea ( '', array (
										'name' => "data[LaboratoryHistopathology][$key][parameter_text_histo]",
										'id' => 'histoAttrValue'.$key,
										'label' => false,
										'div' => false,
										'error' => false,
										'style' => 'width:682px',
										'type' => 'text',
										'value' => $getData ['parameter_text'],
										'class'=>'histoAttrDefault',
										'disabled'=>'disabled'
								) );
								?>
		</td>
		<td><?php

		echo $this->Html->link ( $this->Html->image ( 'icons/close-icon.png' ), 'javascript:return false;', array (
										'id' => "removeButtonHistopathology_$key",
										'escape' => false,
										'class' => 'removeBtnHistopathology',
										'title' => 'Remove'
								) );

								?>
		</td>
	</tr>
	<?php $histoCountNo++;}

			}?>
	<!--  //histo-->


</table>
<?php }?>
<p class="ht5"></p>
<!-- //Culture  -->
<!-- BOF-For MicroBiology -->
<?php  
echo $this->Form->hidden ( '', array (
		'class' => 'currentSelectedTab',
		'id' => 'currentSelectedTab',
		'value' => $defaultShowTab,
		'name' => "data[Laboratory][currentSelectedTab]"
) );
?>
<div class="tabs showForMicroBiology" id="TestGroupMicroBiology" style="display: none;">
    <!-- Navigation header -->
	    <ul class="tab-links">
	    <?php foreach(Configure::read ( 'CultureSensitivityGroup' ) as $keyGroup => $valGroup){
	    	if($keyGroup == $defaultShowTab) $classActive = 'active';else $classActive ='';
	    	?>
	        <li class="<?php echo $classActive;?>"><a href=#<?php echo $keyGroup?>><?php echo $valGroup?></a></li>
	       <?php  }?>
	    </ul>
	    <!-- tab Section --> 
	     <div class="tab-content">
	     <!-- DIV -->
	    	 <div id="" class="tab active">
	     
			<table width="100%" cellpadding="0" cellspacing="1" border="0"
			class="tabularForm  " align="center"
			id=" "  >
			<tr>
				<th width="5%">Sr. No.</th>
				<th width="25%">Attribute Name</th>
				<th width="60%">Description</th>
				<th width="5%">Action</th>
			</tr>
	<?php		//debug($this->data['LaboratoryParameter']);
			 if($this->data['LaboratoryParameter']){?>
			<?php $microBiologyCounter = 0;$srCounter = 0;?>
			<?php foreach ( $this->data['LaboratoryParameter'] as $key => $getData ) {?>
			<?php $microBiologyCounter++;
				if($getData['culture_group_id'] != $defaultShowTab)
					continue;
				$srCounter++;
			?>
			
			<tr id="TestGroupMicroBiology_<?php echo $microBiologyCounter?>"
				class="getRow">
				<td valign="top" style="padding-top: 10px;"><?php echo __($srCounter);?>
				<?php echo $this->Form->hidden("LaboratoryMicroBiology.$microBiologyCounter.culture_group_id",array('value'=>$defaultShowTab,'type'=>'text','class'=>'groupID'));?>
				</td>
				<td valign="top"><?php
				//if($getData['culture_group_id']==$defaultShowTab){
					echo $this->Form->hidden("LaboratoryMicroBiology.$microBiologyCounter.id", array ('value' => $getData['id']));
				//}
				echo $this->Form->input ( "LaboratoryMicroBiology.$microBiologyCounter.attribute", array (
						'label' => false,
						'div' => false,
						'error' => false,
						'type' => 'text' ,
						'value' => $getData['name']
				) );
				?>
				</td>
				<td style="padding-top: 10px;"><?php
		
				echo $this->Form->textarea ( "LaboratoryMicroBiology.$microBiologyCounter.parameter_text", array (
						'label' => false,
						'div' => false,
						'error' => false,
						'style' => 'width:682px',
						'type' => 'text' ,
						'value' => $getData['parameter_text']
				) );
				?>
				</td>
				<td><?php $display = (count($this->data['LaboratoryParameter']) >= $microBiologyCounter && count($this->data['LaboratoryParameter']) != 1) ? 'block' : 'none';?>
				
					<?php echo $this->Html->image('icons/close-icon.png', array('id'=>"removeMicroBiology_$microBiologyCounter",'title'=>'Delete',
							'class'=>'removeMicroBiology removeAttr','style'=>"display : $display",'parameterID'=>$getData['id']));?> 
							
				
							
					<?php $displayAdd = (count($this->data['LaboratoryParameter']) == $microBiologyCounter) ? 'block' : 'none';?>
					
					<?php echo $this->Html->image('icons/plus_6.png', array('id'=>"addMicroBiology_$microBiologyCounter",'title'=>'Add',
							'class'=>'addMicroBiology','style'=>"display : $displayAdd"));?></td>
		
			</tr>
			<?php }
			}else{?>
			<?php $microBiologyCounter = 1;?>
			<tr id="TestGroupMicroBiology_1" class="getRow">
				<td valign="top" style="padding-top: 10px;"><?php echo __('1');?></td>
				<?php echo $this->Form->hidden("LaboratoryMicroBiology.$microBiologyCounter.culture_group_id",array('value'=>$defaultShowTab,'type'=>'text','class'=>'groupID'));?>
				<td valign="top"><?php
		
				echo $this->Form->input ( "LaboratoryMicroBiology.1.attribute", array (
						'label' => false,
						'div' => false,
						'error' => false,
						'type' => 'text'
				) );
				?>
				</td>
				<td style="padding-top: 10px;"><?php
		
				echo $this->Form->textarea ( "LaboratoryMicroBiology.1.parameter_text", array (
						'id' => 'microBiology_data_Frst',
						'label' => false,
						'div' => false,
						'error' => false,
						'style' => 'width:682px',
						'type' => 'text'
				) );
				?>
				</td>
				<td><?php echo $this->Html->image('icons/plus_6.png', array('id'=>'addMicroBiology_1','title'=>'Add','class'=>'addMicroBiology'));?>
				</td>
			</tr>
		
			<?php }?>
		
		
		</table>
			<p class="ht5"></p>
			<!--  
			<table width="100%" cellpadding="0" cellspacing="1" border="0"
				class="tabularForm showForMicroBiology" align="center"
				id="TestGroupMicroBiologyMeds" style="display: none;">-->
				<table width="100%" cellpadding="0" cellspacing="1" border="0"
				class="tabularForm  " align="center" id=" "  >
				<tr>
					<th width="5%">Sr. No.</th>
					<th width="25%">Medication</th>
					<th width="60%">Sensitivity</th>
					<th width="5%">Action</th>
				</tr>
				<?php $medication = unserialize($this->data['Laboratory']['medication']);
					  $medication = $medication[$defaultShowTab];
				
					 if($medication){
						$microBiologyCounterMeds = 0;
						 foreach ( $medication as $key => $getData ) {
							 $microBiologyCounterMeds++;?>
				<tr id="TestGroupMicroBiologyMeds_<?php echo $microBiologyCounterMeds?>" class="getRow">
					<td valign="top" style="padding-top: 10px;"><?php echo __($microBiologyCounterMeds);?>
						<?php echo $this->Form->hidden("Laboratory.medication.$microBiologyCounterMeds.culture_group_id",array('value'=>$defaultShowTab,'type'=>'text','class'=>'groupID'));?>
					</td>
					<td valign="top"><?php
					
					echo $this->Form->input ( "Laboratory.medication.$microBiologyCounterMeds.name", array (
							'label' => false,
							'div' => false,
							'error' => false,
							'type' => 'text' ,
							'id' => 'pharmacyAutoComplete_'.$microBiologyCounterMeds,
							'value' => $getData['name'],
							'class' => 'pharmacyAutoComplete'
					) );
					echo $this->Form->hidden("Laboratory.medication.$microBiologyCounterMeds.pharmacy_item_id",array('id'=>'pharmacyAutoCompleteId_'.$microBiologyCounterMeds,
						'value'=>$getData['pharmacy_item_id']));
					?>
			
					</td>
					<td style="padding-top: 10px;"><?php
					
					echo $this->Form->input ( "Laboratory.medication.$microBiologyCounterMeds.sensitivity_flag", array (
							'label' => false,
							'div' => false,
							'error' => false,
							'style' => 'width:68px',
							'options' => Configure::read('sensitivity'),
							'default' => $getData['sensitivity_flag']
					) );
					?>
					</td>
					<td><?php $display = (count($medication) >= $microBiologyCounterMeds && count($medication) != 1) ? 'block' : 'none';?>
						<?php echo $this->Html->image('icons/close-icon.png', array('id'=>"removeMicroBiologyMeds_$microBiologyCounterMeds",'title'=>'Add',
								'class'=>'removeMicroBiologyMeds','style'=>"display : $display"));?> 
								<?php $displayAdd = (count($medication) == $microBiologyCounterMeds) ? 'block' : 'none';?>
						<?php echo $this->Html->image('icons/plus_6.png', array('id'=>"addMicroBiologyMeds_$microBiologyCounterMeds",'title'=>'Add',
								'class'=>'addMicroBiologyMeds','style'=>"display : $displayAdd"));?></td>
				</tr>
			
				<?php }
			}else{?>
				<?php $microBiologyCounterMeds = 1;?>
				<tr id="TestGroupMicroBiologyMeds_1" class="getRow">
					<td valign="top" style="padding-top: 10px;"><?php echo __('1');?></td>
					<?php echo $this->Form->hidden("Laboratory.medication.$microBiologyCounterMeds.culture_group_id",array('value'=>$defaultShowTab,'type'=>'text','class'=>'groupID'));?>
					<td valign="top"><?php
			
					echo $this->Form->input ( "Laboratory.medication.1.name", array (
							'label' => false,
							'div' => false,
							'error' => false,
							'type' => 'text' ,
							'id' => 'pharmacyAutoComplete_1',
							'class' => 'pharmacyAutoComplete'
							
					) );
					echo $this->Form->hidden("Laboratory.medication.1.pharmacy_item_id",array('id'=>'pharmacyAutoCompleteId_1'));
					?>
					</td>
					<td style="padding-top: 10px;"><?php
					
					echo $this->Form->input ( "Laboratory.medication.1.sensitivity_flag", array (
							'label' => false,
							'div' => false,
							'error' => false,
							'style' => 'width:68px',
							'options' => Configure::read('sensitivity')
					) );
					?>
					</td>
					<td><?php echo $this->Html->image('icons/close-icon.png', array('id'=>"removeMicroBiologyMeds_$microBiologyCounter",'title'=>'Add',
								'class'=>'removeMicroBiologyMeds','style'=>"display :none;"));?>
					<?php echo $this->Html->image('icons/plus_6.png', array('id'=>'addMicroBiologyMeds_1','title'=>'Add','class'=>'addMicroBiologyMeds'));?>
					</td>
				</tr>
				<?php }?>
				<tr>
					<td width="100%" align="right" colspan="4"
						style="background: none repeat scroll 0% 0% white;"><?php
						echo $this->Form->submit ( __ ( 'Save' ), array ('id' => 'save','escape' => false,'class' => 'blueBtn','label' => false,'div' => false,'error' => false ) );
						echo $this->Html->link ( __ ( 'Cancel' ), array ('action' => 'index' ), array ('escape' => false,'class' => 'grayBtn' ) );
						?>
					</td>
				</tr>
			</table>
	    	 
	    	 </div>
	     
	     </div>
</div>
 
<p class="ht5"></p>
<!-- EOF MicroBilogy -->
<table width="100%" cellpadding="0" cellspacing="0" border="0"
	align="center" style="display: none;" class="showForHistopathology">
	<tr>
		<td width="50%" align="left"><?php
		// echo $this->Form->Button(__('Add More Category'), array('type'=>'button','label' => false,'div' => false,'error'=>false,'escape' => false,'class' => 'blueBtn','id'=>'addButtonHistopathology'));

		?>

			<div align="center" id='busy-indicator' style="display: none;">
				&nbsp;
				<?php echo $this->Html->image('indicator.gif', array()); ?>
			</div>
		</td>
		<td width="50%" align="right"><?php
		echo $this->Form->hidden ( 'whichActHistopathology', array (
																																			'id' => 'whichActHistopathology'
																																	) );
																																	echo $this->Form->submit ( __ ( 'Save' ), array (
																																			'id' => 'save',
																																			'escape' => false,
																																			'class' => 'blueBtn',
																																			'label' => false,
																																			'div' => false,
																																			'error' => false,
																																			'style' => 'margin:0 10px 0 0;'
																																	) );
																																	// echo $this->Form->submit(__('Save & Add More Category'), array('id'=>'add-morehistopathology','title'=>'Save and Add More Category','escape' => false,'class' => 'blueBtn','label' => false,'div' => false,'error'=>false));
																																	 echo $this->Html->link(__('Cancel'), array('action' => 'index'), array('escape' => false,'class' => 'grayBtn '));
																																	?>
		</td>
	</tr>
</table>
<!-- EOF-For histopathology_data -->
<p class="ht5"></p>
<?php
// if(isset($cat_id) && !empty($cat_id)){
?>
<table width="100%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm hideForHistopathology" align="center" id="TestGroup">
	<tr>
		<!--<th width="50">Sr. No.4</th>-->
		<th width="200">Category Name</th>
		<th width="400">Normal Range</th>
		<th width="50">Units</th>
		<th width="10">&nbsp;</th>
	</tr>
	<?php
	// debug($setData);
	$count = count ( $setData );
	$i = 0;
	$listArray = array ();
	$isDisplayed = array ();
	$listCat = array_keys($categoryList);
	//debug($listCat);
	foreach ( $setData ['LaboratoryParameter'] as $paraKey => $paraValue ) {
		$listArray [$paraValue ['id']] = $paraValue ['name'];
	}
	$counter = 0;
	foreach ( $setData ['LaboratoryParameter'] as $lab => $lab_value ) {
		$lab_value ['Laboratory'] = $lab_value;
		//dpr($lab_value ['Laboratory']);//exit;
		echo $this->Form->hidden ( '', array (
				'name' => "data[LaboratoryParameter][$lab][id_new]",
				'value' => $lab_value ['Laboratory'] ['id']
		) );
		/*
		 * if(empty($categoryList[$lab_value['Laboratory']['laboratory_categories_id']])){
		 *
		* $i++;
		* }
		*/
		$labCatId = $lab_value ['Laboratory'] ['laboratory_categories_id'];
		?>
	<tr id="TestGroup<?php echo $lab ?>"
		class="catClassDef_<?php echo $labCatId; ?>">
		<!--<td valign="top" style="padding-top:10px;"><?php echo $i ;?></td>-->

		<td valign="top">
			<table>
				<tr>
					<td><?php
					if (! in_array ( $lab_value ['Laboratory'] ['laboratory_categories_id'], $isDisplayed )) {
						echo __ ( "is Category?" ) . $this->Form->input ( 'Category', array (
								'type' => 'checkbox',
								'div' => false,
								'label' => false,
								'class' => 'category',
								'id' => 'category_' . $lab
						) ) . __ ( "Yes/No" );
						$lastMainCategoryId = $lab_value ['Laboratory'] ['laboratory_categories_id'];
					}
					?>
					</td>
				</tr>
				<?php
				/*
				 * if($categoryList[$lab_value['Laboratory']['laboratory_categories_id']]){
																										 * $display = 'display:block;';
				* }else{
																										 * $display = 'display:none;';
				* }
				*/
				if (! in_array ( $lab_value ['Laboratory'] ['laboratory_categories_id'], $isDisplayed )) {
					$display = 'display:block;';
				} else {
					$display = 'display:none;';
				}
				?>
				<tr>
					<?php echo $this->Form->hidden('',array('type'=>'text','name'=>"data[LaboratoryCategory][$lab][id]",'class'=>'CategoryId','id'=>'CategoryId_'.$lab,'value'=>$lab_value['Laboratory']['laboratory_categories_id'])); ?>
					<?php //echo $this->Form->input('',array('type'=>'text','name'=>"data[LaboratoryCategory][$lab][category_name]",'class'=>'CategoryId','id'=>'CategoryId_'.$lab,'value'=>$categoryList[$lab_value['Laboratory']['laboratory_categories_id']])); ?>
					<td><?php

					if (! in_array ( $lab_value ['Laboratory'] ['laboratory_categories_id'], $isDisplayed )) {
						$counter++;
						($categoryList [$lab_value ['Laboratory'] ['laboratory_categories_id']]) ? $display = 'display:block;' : $display = 'display:none;';
						echo $this->Form->input ( '', array (
							'type' => 'text',
							'name' => '',
							'class' => 'CategoryName validate[required,custom[name]]',
							'autocomplete' => 'off',
							'id' => 'CategoryName_' . $lab,
							'style' => $display,
							'value' => $categoryList [$lab_value ['Laboratory'] ['laboratory_categories_id']],
							'count'=>$counter,																											) );
					$catagory = $categoryList [$lab_value ['Laboratory'] ['laboratory_categories_id']];

					?></td>
				</tr>
				<tr>
					<td><?php if($lab_value ['Laboratory'] ['sort'])
					echo "Sort";
				echo $this->Form->input('',array(
							'type'=>'text',
						'id'=>'sort_' . $lab,
						'name' => "data[LaboratoryCategory][$lab][sort]",
						'class'=>'sort',
						'autocomplete'=>'off',
						'style'=>'width:75px;',
						'placeholder'=>'Sort Order',
						'count'=>$counter,
						'value' => $lab_value ['Laboratory'] ['sort_category']));?>
					</td>
				</tr>
				<?php } ?>
				<tr>
					<td><?php
					if (! in_array ( $lab_value ['Laboratory'] ['laboratory_categories_id'], $isDisplayed )) {
						echo $this->Html->image ( 'icons/plus_6.png', array (
								'id' => "addMore_$lab",
								'class' => "addMore catClass_" . $lab_value ['Laboratory'] ['laboratory_categories_id'],
								'title' => 'Add',
								'count'=>$counter,
								'style' => "display:$display;"
						) );
						array_push ( $isDisplayed, $lab_value ['Laboratory'] ['laboratory_categories_id'] );
					}
					?>
					</td>

				</tr>
			</table>
		</td>

		<!--  
	                                <td valign="top">                                	 
	                                	<?php
																										echo $this->Form->input ( '', array (
																												'type' => 'text',
																												'name' => "data[LaboratoryParameter][$lab][name]",
																												'value' => $lab_value ['Laboratory'] ['name'],
																												'class' => '',
																												'id' => "name",
																												'label' => false,
																												'autocomplete' => 'off',
																												'div' => false,
																												'error' => false 
																										) );
																										echo $this->Form->hidden ( '', array (
																												'name' => "data[LaboratoryParameter][$lab][id]",
																												'value' => $lab_value ['Laboratory'] ['id'] 
																										) );
																										?>
	                                </td>
	                    		 -->
		<td style="padding-top: 10px;">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">


				<tr>
					<td colspan="4">
						<table>
							<tr>
								<td><?php 
								//dpr($setData['LaboratoryCategory']);
								//dpr($lab_value);
								echo __ ( "Attribute Name:" ) . "&nbsp;";
								echo $this->Form->input ( '', array (
								'name' => "data[LaboratoryParameter][$lab][name_txt]",
								'class' => "name_lab_par1",
								'autocomplete' => 'off',
								'label' => false,
								'div' => false,
								'error' => false,
								'id' => 'labParaNameDisplay_Frst',
								'value' => $lab_value ['Laboratory'] ['name']
						) );
																										// echo $this->Form->input('', array('type'=>'text','name'=>"data[LaboratoryParameter][0][name]",'value'=>$lab_value['Laboratory']['name'],'class' => '',
																										// 'id' => "name", 'label' => false,'div' => false,'error'=>false));
																										echo $this->Form->hidden ( '', array (
																												'name' => "data[LaboratoryParameter][$lab][laboratory_id]",
																												'value' => $lab_value ['Laboratory'] ['laboratory_id']
																										) );
																										echo $this->Form->hidden ( '', array (
																												'name' => "data[LaboratoryParameter][$lab][laboratory_categories_id]",
																												'value' => $lab_value ['Laboratory'] ['laboratory_categories_id']
																										) );
																										echo $this->Form->hidden ( '', array (
																												'name' => "data[LaboratoryParameter][$lab][id]",
																												'value' => $lab_value ['Laboratory'] ['id']
																										) );
																										echo $this->Form->hidden ( '', array (
																												'class' => 'CategoryValue',
																												'id' => 'CategoryValue_1',
																												'value' => $categoryList [$lab_value ['Laboratory'] ['laboratory_categories_id']],
																												'name' => "data[LaboratoryCategory][$lab][category_name]"
																										) );
																										echo $this->Form->hidden ( '', array (
																												'class' => 'CateName',
																												'id' => 'CateName_1',
																												'value' => '',
																												'name' => "data[LaboratoryParameter][$lab][category_name]"
																										) );
																										echo $this->Form->hidden( '', array (
																												'class' => 'altCateName_'.$counter,
																												'id' => 'altCateName_' . $lab,
																												'value' => $categoryList [$lab_value ['Laboratory'] ['laboratory_categories_id']],
																												'name' => "data[LaboratoryParameter][$lab][altCateName]"
																										) );
																										echo $this->Form->hidden( '', array (
																												'class' => 'categorySort_'.$counter,
																												'id' => 'categorySort_' . $lab,
																												'value' =>$lab_value ['Laboratory'] ['sort_category'],
																												'name' => "data[LaboratoryCategory][$lab][sort]"
																										) );
																										echo $this->Form->hidden( '', array (
																												'class' => 'sortCategory_'.$counter,
																												'id' => 'sortCategory_' . $lab,
																												'value' =>$lab_value ['Laboratory'] ['sort_category'],
																												'name' => "data[LaboratoryParameter][$lab][sort_category]"
																										) );

																										echo $this->Form->hidden ( '', array (
																												'name' => "data[LaboratoryParameter][$lab][name]",
																												'id' => "labParaName_Frst",
																												'label' => false,
																												'div' => false,
																												'error' => false,
																												'value' => ''
																										) );
																										?>
								</td>
								
								<td>
								<?php echo __ ( "Machine Name:" ) . "&nbsp;";
								echo $this->Form->input ( 'Machine1', array (
								'name' => "data[LaboratoryParameter][$lab][machine_name]",
								'class' => "machineName1",
								'autocomplete' => 'off',
								'label' => false,
								'div' => false,
								'error' => false,
								'placeholder'=>'Machine Name',
								'id' => 'machineName_1',
								'value' => $lab_value ['Laboratory'] ['machine_name']
						) );?>
								</td>
								<td><?php  echo __ ( "Multiply By:" ) . "&nbsp;";
								echo $this->Form->input ( 'Multiply', array (
										'style'=>'width:70px;',
										'id' => 'multiply_by_1',
										'autocomplete' => 'off',
										'label' => false,
										'div' => false,
										'error' => false,
										'placeholder'=>'Multiply By',
										'name' => "data[LaboratoryParameter][$lab][multiply_by]",
										'value' => $lab_value ['Laboratory'] ['multiply_by']
								) ); ?></td>
								<td><?php  echo __ ( "Decimal:" ) . "&nbsp;";
								echo $this->Form->input ( 'Decimal', array (
										'style'=>'width:55px;',
										'id' => 'decimal_1',
										'autocomplete' => 'off',
										'label' => false,
										'div' => false,
										'error' => false,
										'placeholder'=>'Decimal',
										'name' => "data[LaboratoryParameter][$lab][decimal]",
										'value' => $lab_value ['Laboratory'] ['decimal']
								) ); ?></td>
								
								<td><?php   
								if($lab_value ['Laboratory']['is_descriptive'] == '1'){
									$checked = "checked";
								}else{
									$checked = '';
								}
								echo __ ( "Is Descriptive : " ) . $this->Form->input ( 'is_descriptive', array (
										'type' => 'checkbox',
										'div' => false,
										'checked' =>$checked,
										'label' => false,
										'hiddenField'=>false,
										'id' => 'is_descriptive-' . $lab,
										'name' => 'data[LaboratoryParameter][' . $lab . '][is_descriptive]',
										 
								) );
								?>
								</td>
								
								<?php if(in_array($lab_value['laboratory_categories_id'],$listCat)){?>
								<td id="sortCategoryAttr_<?php echo $lab;?>" ><?php 
								echo __ ( "Sort Attribute:" ) . "&nbsp;";
								 echo $this->Form->input( 'Sort', array (
										'class' => 'sortOrder_'.$counter,
								 		'id' => 'sortOrder_' . $lab,
								 		'style'=>'width:67px;',
								 		'placeholder'=>'Sort Order',
								 		'value' =>$lab_value ['Laboratory'] ['sort_attribute'],
								 		'name' => "data[LaboratoryParameter][$lab][sort_attribute]"
																										) );?>
								</td>
								<?php } ?>
								<td><b> <?php
								if ($lab_value ['Laboratory'] ['formula']) {
										echo __ ( "Formula :" );
								}
																										?>
								</b></td>
								<td cols><?php
								$formulacheckbox = '';
								if ($lab_value ['Laboratory'] ['formula']) {
									 echo $lab_value ['Laboratory'] ['name'] . " = (" . $lab_value ['Laboratory'] ['formula_text'] . ")";
									 $formulacheckbox = "checked";
								}
																										?>
								</td>
							</tr>
						</table>
						<hr>
					</td>
				</tr>
				<tr>
					<?php

					$type_arr = array (
																												'numeric' => 'Numeric',
																												'text' => 'Text'
																										);
																										if ($lab_value ['Laboratory'] ['type'] == 'text') {
																											$selected = 'text';
																											$radio_display = 'none';
																											$parameter_text = 'block';
																											$gender_section = 'none ';
																											$age_section = 'none';
																											$range_section = 'none';
																										} else {
																											$selected = 'numeric';
																											$radio_display = 'block';
																											$parameter_text = 'none';
																											if ($lab_value ['Laboratory'] ['by_gender_age'] == 'gender') {
																												$gender_section = 'block ';
																												$age_section = 'none';
																												$range_section = 'none';
																												$gender = 'checked';
																												$age = '';
																												$range = '';
																												$range_section_type = 'block';
																											} else if ($lab_value ['Laboratory'] ['by_gender_age'] == 'age') {
																												$gender_section = 'none ';
																												$range_section = 'none';
																												$age_section = 'block';
																												$gender = '';
																												$range = '';
																												$age = 'checked';
																												$range_section_type = 'block';
																											} else if ($lab_value ['Laboratory'] ['by_gender_age'] == 'range') {
																												$gender_section = 'none ';
																												$age_section = 'none';
																												$range_section = 'block';
																												$range_section_type = 'none';
																												$gender = '';
																												$age = '';
																												$range = 'checked';
																											}
																										}
																										 
																										if ($lab_value ['Laboratory'] ['is_formula']) {
																											 
																											$formulacheck = 'cheched';
																										} else {
																											$formulacheck = '';
																										}
																										?>
					<td width="40" class="" id="type_text_<?php echo $lab?>">Type</td>
					<td width="100"><?php

					echo $this->Form->input ( '', array (
																												'style' => "display:$range_section_type",
																												'selected' => $selected,
																												'options' => $type_arr,
																												'name' => "data[LaboratoryParameter][$lab][type]",
																												'class' => 'attr-type textBoxExpnd validate[required,custom[name]]',
																												'id' => "type_$lab",
																												'label' => false,
																												'div' => false,
																												'error' => false
																										) );
																										?>
					</td>
					<td><?php
					if ($lab_value ['Laboratory'] ['is_mandatory'] == '1')
						$mandatory = 'checked';
					else
						$mandatory = '';
					echo __ ( "Is Mandatory : " ) . $this->Form->input ( 'is_mandatory', array (
																												'type' => 'checkbox',
																												'div' => false,
																												'checked' => $mandatory,
																												'label' => false,
																												'class' => 'isMandatory',
																												'id' => 'isMandatory-' . $lab,
																												'name' => 'data[LaboratoryParameter][' . $lab . '][is_mandatory]',
																												'value' => $lab_value ['Laboratory'] ['is_mandatory']
																										) );
																										?>
					</td>
					<td colspan="3">
						<div id="radioGroup_<?php echo $lab; ?>" style="display:<?php  echo $radio_display;?>">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td width="25"><input type="radio" class="sort-by"
										name="data[LaboratoryParameter][<?php echo $lab ;?>][by_gender_age]"
										id="gender-<?php echo $lab ;?>" value="gender"
										<?php echo $gender ;?> /></td>
									<td width="80"><?php echo __('By Sex'); ?></td>
									<td width="25"><input type="radio" class="sort-by"
										name="data[LaboratoryParameter][<?php echo $lab ;?>][by_gender_age]"
										id="age-<?php echo $lab ;?>" value="age" <?php echo $age ;?> />
									</td>
									<td><?php echo __('By Age');?>
									</td>
									<td width="25"><input type="radio" class="sort-by"
										name="data[LaboratoryParameter][<?php echo $lab ;?>][by_gender_age]"
										id="range_positive_negative-<?php echo $lab ;?>" value="range"
										<?php echo $range ;?> /></td>
									<td><?php echo __('By Range');?></td>
									<td width="25">  
									<!--  <input class="is-formula"
										name="data[LaboratoryParameter][<?php echo $lab ;?>][is_formula]"
										id="is_formula-<?php echo $lab ;?>" type="checkbox"
										value = "1" 	
										<?php //echo $formula ;?> />-->
										
										
										<?php echo $this->Form->input ( 'is_formula', array (
										'type' => 'checkbox',
										'div' => false,
										'class'=>"is-formula",
										'checked' =>$formulacheck,
										'id'=>"is_formula-".$lab,
										'label' => false,
										'hiddenField'=>false,
										'id' => 'is_descriptive-' . $lab,
										'name' => "data[LaboratoryParameter][$lab][is_formula]",
										 
								) );?>
										
										
										</td>
									<td><?php echo __('Formula');?></td>

								</tr>
							</table>
						</div>
					</td>
				</tr>
			</table>
			<div class="ht5"></div>
			<div id="parameter_text_<?php echo $lab ;?>" style="display:<?php echo $parameter_text ;?>;">
				<table width="100%" cellpadding="0" cellspacing="0" border="0"
					style="border-top: 1px solid #3e474a;">
					<tr>
						<td style="padding-top: 5px;"><?php
						echo $this->Form->textarea ( '', array (
																												'value' => $lab_value ['Laboratory'] ['parameter_text'],
																												'name' => "data[LaboratoryParameter][$lab][parameter_text]",
																												'class' => 'textBoxExpnd validate[custom[mandatory-enter]]',
																												'id' => "parameter_text_id_$lab",
																												'label' => false,
																												'div' => false,
																												'error' => false
																										) );
																										?>
						</td>
					</tr>
					<tr>
						<td align="right" style="padding-top: 5px; padding-bottom: 5px;">
							<?php echo __("Is multiple options?");?> <?php

							echo $this->Form->input ( '', array (
							'name' => "data[LaboratoryParameter][$lab][is_multiple_options]",
							'type' => 'checkbox',
							'class' => '',
							'id' => 'is_multiple_options_' . $lab,
							'size' => "3",
							'label' => false,
							'div' => false,
							'error' => false,
							'checked' => $lab_value ['Laboratory'] ['is_multiple_options']
					) );
					?> [Please add comma (,) separated values]
						</td>
					</tr>
				</table>
			</div>
			<div id="gender-section_<?php echo $lab;?>" style="display:<?php echo $gender_section ;?>">
				<table width="100%" cellpadding="0" cellspacing="0" border="0"
					style="border-top: 1px solid #3e474a;">
					<tr>
						<td height="25">&nbsp;</td>
						<td>&nbsp;</td>
						<td align="center">LL</td>
						<td align="center">UL</td>
						<td align="center">Default</td>
					</tr>
					<tr>
						<td width="25"><?php
						if ($lab_value ['Laboratory'] ['by_gender_female'] == '1') {
																											$gender_female = 'checked';
																										} else {
																											$gender_female = '';
																										}

																										if ($lab_value ['Laboratory'] ['by_gender_male'] == '1') {
																											$gender_male = 'checked';
																										} else {
																											$gender_male = '';
																										}

																										if ($lab_value ['Laboratory'] ['by_gender_child'] == '1') {
																											$gender_child = 'checked';
																										} else {
																											$gender_child = '';
																										}

																										echo $this->Form->input ( '', array (
																												'checked' => $gender_male,
																												'value' => $lab_value ['Laboratory'] ['by_gender_male'],
																												'name' => "data[LaboratoryParameter][$lab][by_gender_male]",
																												'type' => 'checkbox',
																												'class' => 'radioBtn' . $lab,
																												'label' => false,
																												'div' => false,
																												'error' => false,
																												'id' => 'by_gender_female' . $lab
																										) );
																										?>
						</td>
						<td width="">Male</td>
						<td width="70" align="center"><?php
						echo $this->Form->input ( '', array (
																												'value' => $lab_value ['Laboratory'] ['by_gender_male_lower_limit'],
																												'name' => "data[LaboratoryParameter][$lab][by_gender_male_lower_limit]",
																												'type' => 'text',
																												'autocomplete' => 'off',
																												'class' => 'txtBoxLower-' . $lab,
																												'size' => "3",
																												'label' => false,
																												'div' => false,
																												'error' => false,
																												'id' => "by_gender_male_lower_limit_" . $lab
																										) );
																										?>
						</td>
						<td width="70" align="center"><?php
						echo $this->Form->input ( '', array (
																												'id' => 'by_gender_male_upper_limit_' . $lab,
																												'value' => $lab_value ['Laboratory'] ['by_gender_male_upper_limit'],
																												'name' => "data[LaboratoryParameter][$lab][by_gender_male_upper_limit]",
																												'type' => 'text',
																												'autocomplete' => 'off',
																												'class' => 'txtBoxUpper-' . $lab,
																												'size' => "3",
																												'label' => false,
																												'div' => false,
																												'error' => false
																										) );
																										?>
						</td>
						<td width="70" align="center"><?php
						echo $this->Form->input ( '', array (
																												'id' => 'by_gender_male_default_result' . $lab,
																												'value' => $lab_value ['Laboratory'] ['by_gender_male_default_result'],
																												'name' => "data[LaboratoryParameter][$lab][by_gender_male_default_result]",
																												'type' => 'text',
																												'autocomplete' => 'off',
																												'class' => 'txtBoxUpper-' . $lab,
																												'size' => "20",
																												'label' => false,
																												'div' => false,
																												'error' => false
																										) );
																										?>
						</td>
					</tr>
					<tr>
						<td width="25"><?php

						echo $this->Form->input ( '', array (
																												'checked' => $gender_female,
																												'value' => $lab_value ['Laboratory'] ['by_gender_female'],
																												'name' => "data[LaboratoryParameter][$lab][by_gender_female]",
																												'type' => 'checkbox',
																												'class' => 'radioBtn' . $lab,
																												'id' => 'by_gender_female' . $lab,
																												'label' => false,
																												'div' => false,
																												'error' => false
																										) );
																										?>
						</td>
						<td width="">Female</td>
						<td width="70" align="center"><?php

						echo $this->Form->input ( '', array (
																												'name' => "data[LaboratoryParameter][$lab][by_gender_female_lower_limit]",
																												'value' => $lab_value ['Laboratory'] ['by_gender_female_lower_limit'],
																												'type' => 'text',
																												'autocomplete' => 'off',
																												'class' => 'txtBoxLower-' . $lab,
																												'id' => 'by_gender_female_lower_limit' . $lab,
																												'size' => "3",
																												'label' => false,
																												'div' => false,
																												'error' => false
																										) );
																										?>
						</td>
						<td width="70" align="center"><?php

						echo $this->Form->input ( '', array (
																												'value' => $lab_value ['Laboratory'] ['by_gender_female_upper_limit'],
																												'name' => "data[LaboratoryParameter][$lab][by_gender_female_upper_limit]",
																												'type' => 'text',
																												'autocomplete' => 'off',
																												'class' => 'txtBoxUpper-' . $lab,
																												'id' => 'by_gender_female_upper_limit' . $lab,
																												'size' => "3",
																												'label' => false,
																												'div' => false,
																												'error' => false
																										) );
																										?>
						</td>
						<td width="70" align="center"><?php

						echo $this->Form->input ( '', array (
																												'value' => $lab_value ['Laboratory'] ['by_gender_female_default_result'],
																												'name' => "data[LaboratoryParameter][$lab][by_gender_female_default_result]",
																												'type' => 'text',
																												'autocomplete' => 'off',
																												'class' => 'txtBoxUpper-' . $lab,
																												'id' => 'by_gender_female_default_result' . $lab,
																												'size' => "20",
																												'label' => false,
																												'div' => false,
																												'error' => false
																										) );
																										?>
						</td>
					</tr>


					<!-- CHILD -->
					<tr>
						<td width="25"><?php

						echo $this->Form->input ( '', array (
																												'checked' => $gender_child,
																												'value' => $lab_value ['Laboratory'] ['by_gender_child'],
																												'name' => "data[LaboratoryParameter][$lab][by_gender_child]",
																												'type' => 'checkbox',
																												'class' => 'radioBtn' . $lab,
																												'id' => 'by_gender_child' . $lab,
																												'label' => false,
																												'div' => false,
																												'error' => false
																										) );
																										?>
						</td>
						<td width="">Child</td>
						<td width="70" align="center"><?php

						echo $this->Form->input ( '', array (
																												'name' => "data[LaboratoryParameter][$lab][by_gender_child_lower_limit]",
																												'value' => $lab_value ['Laboratory'] ['by_gender_child_lower_limit'],
																												'type' => 'text',
																												'autocomplete' => 'off',
																												'class' => 'txtBoxLower-' . $lab,
																												'id' => 'by_gender_child_lower_limit' . $lab,
																												'size' => "3",
																												'label' => false,
																												'div' => false,
																												'error' => false
																										) );
																										?>
						</td>
						<td width="70" align="center"><?php

						echo $this->Form->input ( '', array (
																												'value' => $lab_value ['Laboratory'] ['by_gender_child_upper_limit'],
																												'name' => "data[LaboratoryParameter][$lab][by_gender_child_upper_limit]",
																												'type' => 'text',
																												'autocomplete' => 'off',
																												'class' => 'txtBoxUpper-' . $lab,
																												'id' => 'by_gender_child_upper_limit' . $lab,
																												'size' => "3",
																												'label' => false,
																												'div' => false,
																												'error' => false
																										) );
																										?>
						</td>
						<td width="70" align="center"><?php

						echo $this->Form->input ( '', array (
																												'value' => $lab_value ['Laboratory'] ['by_gender_child_default_result'],
																												'name' => "data[LaboratoryParameter][$lab][by_gender_child_default_result]",
																												'type' => 'text',
																												'autocomplete' => 'off',
																												'class' => 'txtBoxUpper-' . $lab,
																												'id' => 'by_gender_child_default_result' . $lab,
																												'size' => "20",
																												'label' => false,
																												'div' => false,
																												'error' => false
																										) );
																										?>
						</td>
					</tr>

					<!--CHILD  -->

				</table>
			</div>
			<div style="display:<?php echo $age_section; ?>;" id="age-section_<?php echo $lab; ?>" >
				<table width="100%" cellpadding="0" cellspacing="0" border="0"
					style="border-top: 1px solid #3e474a;"
					id="addTrAge_<?php echo $lab; ?>">
					<tr>
						<td height="25">&nbsp;</td>

						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>

						<td align="center">LL</td>
						<td align="center">UL</td>
						<td align="center">Default</td>
					</tr>
					<tr>
						<?php
						if ($lab_value ['Laboratory'] ['by_age_less_years'] == '1') {
																											$by_age_less_years = 'checked';
																										} else {
																											$by_age_less_years = '';
																										}

																										if ($lab_value ['Laboratory'] ['by_age_more_years'] == '1') {
																											$by_age_more_years = 'checked';
																										} else {
																											$by_age_more_years = '';
																										}

																										if ($lab_value ['Laboratory'] ['by_age_between_years'] == '1') {
																											$by_age_between_years = 'checked';
																										} else {
																											$by_age_between_years = '';
																										}

																										?>
						<td width="25"><?php

						echo $this->Form->input ( '', array (
																												'checked' => $by_age_less_years,
																												'value' => $lab_value ['Laboratory'] ['by_age_less_years'],
																												'name' => "data[Laboratory][$lab][by_age_less_years]",
																												'type' => 'checkbox',
																												'class' => '',
																												'id' => 'by_age_less_years' . $lab,
																												'size' => "3",
																												'label' => false,
																												'div' => false,
																												'error' => false
																										) );
																										?>
						</td>
						<td width="80" align="left"><?php echo __("Less Than For Male");?>
						</td>
						<td width="50"><?php

						echo $this->Form->input ( '', array (
																												'value' => $lab_value ['Laboratory'] ['by_age_num_less_years'],
																												'name' => "data[LaboratoryParameter][$lab][by_age_num_less_years]",
																												'type' => 'text',
																												'autocomplete' => 'off',
																												'class' => '',
																												'id' => 'by_age_num_less_years' . $lab,
																												'size' => "3",
																												'label' => false,
																												'div' => false,
																												'error' => false
																										) );
																										?>
						</td>
						<td width="100"><?php

						echo $this->Form->input ( '', array (
									'selected' => $lab_value ['Laboratory'] ['by_age_days_less'],
									'options' => array('Day(s)'=>'Day(s)','Month(s)'=>'Month(s)','Year(s)'=>'Year(s)'),
									'name' => "data[LaboratoryParameter][$lab][by_age_days_less]",
									'class' => 'textBoxExpnd',
									'id' => "by_age_days_less_$lab",
									'label' => false,
									'div' => false,
									'error' => false
							) );
							?>
						</td>
						<td width="70" align="center"><?php

						echo $this->Form->input ( '', array (
																												'value' => $lab_value ['Laboratory'] ['by_age_num_less_years_lower_limit'],
																												'name' => "data[Laboratory][$lab][by_age_num_less_years_lower_limit]",
																												'type' => 'text',
																												'autocomplete' => 'off',
																												'class' => '',
																												'id' => 'by_age_num_less_years_lower_limit' . $lab,
																												'size' => "3",
																												'label' => false,
																												'div' => false,
																												'error' => false
																										) );
																										?>
						</td>
						<td width="70" align="center"><?php

						echo $this->Form->input ( '', array (
																												'value' => $lab_value ['Laboratory'] ['by_age_num_less_years_upper_limit'],
																												'name' => "data[LaboratoryParameter][$lab][by_age_num_less_years_upper_limit]",
																												'type' => 'text',
																												'autocomplete' => 'off',
																												'class' => '',
																												'id' => 'by_age_num_less_years_upper_limit' . $lab,
																												'size' => "3",
																												'label' => false,
																												'div' => false,
																												'error' => false
																										) );
																										?>
						</td>
						<td width="70" align="center"><?php

						echo $this->Form->input ( '', array (
																												'value' => $lab_value ['Laboratory']['by_age_num_less_years_default_result'],
																												'name' => "data[LaboratoryParameter][$lab][by_age_num_less_years_default_result]",
																												'type' => 'text',
																												'autocomplete' => 'off',
																												'class' => '',
																												'id' => 'by_age_num_less_years_default_result' . $lab,
																												'size' => "20",
																												'label' => false,
																												'div' => false,
																												'error' => false
																										) );
																										?>
						</td>
					</tr>
					<tr>
						<td width="25"><?php

						echo $this->Form->input ( '', array (
																												'checked' => $by_age_more_years,
																												'value' => $lab_value ['Laboratory'] ['by_age_more_years'],
																												'name' => "data[LaboratoryParameter][$lab][by_age_more_years]",
																												'type' => 'checkbox',
																												'class' => '',
																												'id' => 'by_age_more_years' . $lab,
																												'label' => false,
																												'div' => false,
																												'error' => false
																										) );
																										?>
						</td>
						<td width="55" align="left"><?php echo __("More Than For Male");?>
						</td>
						<td width="50"><?php

						echo $this->Form->input ( '', array (
																												'value' => $lab_value ['Laboratory'] ['by_age_num_more_years'],
																												'name' => "data[LaboratoryParameter][$lab][by_age_num_more_years]",
																												'type' => 'text',
																												'autocomplete' => 'off',
																												'class' => '',
																												'id' => 'by_age_num_more_years' . $lab,
																												'size' => "3",
																												'label' => false,
																												'div' => false,
																												'error' => false
																										) );
																										?>
						</td>
						<td width="100"><?php

						echo $this->Form->input ( '', array (
									'selected' => $lab_value ['Laboratory'] ['by_age_days_more'],
									'options' => array('Day(s)'=>'Day(s)','Month(s)'=>'Month(s)','Year(s)'=>'Year(s)'),
									'name' => "data[LaboratoryParameter][$lab][by_age_days_more]",
									'class' => 'textBoxExpnd',
									'id' => "by_age_days_more_$lab",
									'label' => false,
									'div' => false,
									'error' => false
							) );
							?>
						</td>
						<td width="70" align="center"><?php

						echo $this->Form->input ( '', array (
																												'value' => $lab_value ['Laboratory'] ['by_age_num_gret_years_lower_limit'],
																												'name' => "data[LaboratoryParameter][$lab][by_age_num_gret_years_lower_limit]",
																												'type' => 'text',
																												'autocomplete' => 'off',
																												'class' => '',
																												'id' => 'by_age_num_gret_years_lower_limit' . $lab,
																												'size' => "3",
																												'label' => false,
																												'div' => false,
																												'error' => false
																										) );
																										?>
						</td>
						<td width="70" align="center"><?php

						echo $this->Form->input ( '', array (
																												'value' => $lab_value ['Laboratory'] ['by_age_num_gret_years_upper_limit'],
																												'name' => "data[LaboratoryParameter][$lab][by_age_num_gret_years_upper_limit]",
																												'type' => 'text',
																												'autocomplete' => 'off',
																												'class' => '',
																												'id' => 'by_age_num_gret_years_upper_limit' . $lab,
																												'size' => "3",
																												'label' => false,
																												'div' => false,
																												'error' => false
																										) );
																										?>
						</td>

						<td width="70" align="center"><?php

						echo $this->Form->input ( '', array (
																												'value' => $lab_value ['Laboratory']  ['by_age_num_gret_years_default_result'],
																												'name' => "data[LaboratoryParameter][$lab][by_age_num_gret_years_default_result]",
																												'type' => 'text',
																												'autocomplete' => 'off',
																												'class' => '',
																												'id' => 'by_age_num_gret_years_default_result' . $lab,
																												'size' => "20",
																												'label' => false,
																												'div' => false,
																												'error' => false
																										) );
																										?>
						</td>
					</tr>


					<tr>
						<?php
						if ($lab_value ['Laboratory'] ['by_age_less_years'] == '1') {
																											$by_age_less_years = 'checked';
																										} else {
																											$by_age_less_years = '';
																										}

																										if ($lab_value ['Laboratory'] ['by_age_more_years'] == '1') {
																											$by_age_more_years = 'checked';
																										} else {
																											$by_age_more_years = '';
																										}

																										if ($lab_value ['Laboratory'] ['by_age_between_years'] == '1') {
																											$by_age_between_years = 'checked';
																										} else {
																											$by_age_between_years = '';
																										}

																										?>
						<td width="25"><?php

						echo $this->Form->input ( '', array (
																												'checked' => $by_age_less_years,
																												'value' => $lab_value ['Laboratory'] ['by_age_less_years_female'],
																												'name' => "data[Laboratory][$lab][by_age_less_years_female]",
																												'type' => 'checkbox',
																												'class' => '',
																												'id' => 'by_age_less_years_female' . $lab,
																												'size' => "3",
																												'label' => false,
																												'div' => false,
																												'error' => false
																										) );
																										?>
						</td>
						<td width="80" align="left"><?php echo __("Less Than For Female");?>
						</td>
						<td width="50"><?php

						echo $this->Form->input ( '', array (
																												'value' => $lab_value ['Laboratory'] ['by_age_num_less_years_female'],
																												'name' => "data[LaboratoryParameter][$lab][by_age_num_less_years_female]",
																												'type' => 'text',
																												'autocomplete' => 'off',
																												'class' => '',
																												'id' => 'by_age_num_less_years_female' . $lab,
																												'size' => "3",
																												'label' => false,
																												'div' => false,
																												'error' => false
																										) );
																										?>
						</td>
						<td width="100"><?php

						echo $this->Form->input ( '', array (
									'selected' => $lab_value ['Laboratory'] ['by_age_days_less_female'],
									'options' => array('Day(s)'=>'Day(s)','Month(s)'=>'Month(s)','Year(s)'=>'Year(s)'),
									'name' => "data[LaboratoryParameter][$lab][by_age_days_less_female]",
									'class' => 'textBoxExpnd',
									'id' => "by_age_days_less_female_$lab",
									'label' => false,
									'div' => false,
									'error' => false
							) );
							?>
						</td>
						<td width="70" align="center"><?php

						echo $this->Form->input ( '', array (
																												'value' => $lab_value ['Laboratory'] ['by_age_num_less_years_lower_limit_female'],
																												'name' => "data[LaboratoryParameter][$lab][by_age_num_less_years_lower_limit_female]",
																												'type' => 'text',
																												'autocomplete' => 'off',
																												'class' => '',
																												'id' => 'by_age_num_less_years_lower_limit_female' . $lab,
																												'size' => "3",
																												'label' => false,
																												'div' => false,
																												'error' => false
																										) );
																										?>
						</td>
						<td width="70" align="center"><?php

						echo $this->Form->input ( '', array (
																												'value' => $lab_value ['Laboratory'] ['by_age_num_less_years_upper_limit_female'],
																												'name' => "data[LaboratoryParameter][$lab][by_age_num_less_years_upper_limit_female]",
																												'type' => 'text',
																												'autocomplete' => 'off',
																												'class' => '',
																												'id' => 'by_age_num_less_years_upper_limit_female' . $lab,
																												'size' => "3",
																												'label' => false,
																												'div' => false,
																												'error' => false
																										) );
																										?>
						</td>
						<td width="70" align="center"><?php

						echo $this->Form->input ( '', array (
																												'value' => $lab_value ['Laboratory']['by_age_num_less_years_default_result_female'],
																												'name' => "data[LaboratoryParameter][$lab][by_age_num_less_years_default_result_female]",
																												'type' => 'text',
																												'autocomplete' => 'off',
																												'class' => '',
																												'id' => 'by_age_num_less_years_default_result_female' . $lab,
																												'size' => "20",
																												'label' => false,
																												'div' => false,
																												'error' => false
																										) );
																										?>
						</td>
					</tr>
					<tr>
						<td width="25"><?php

						echo $this->Form->input ( '', array (
																												'checked' => $by_age_more_years,
																												'value' => $lab_value ['Laboratory'] ['by_age_more_years_female'],
																												'name' => "data[LaboratoryParameter][$lab][by_age_more_years_female]",
																												'type' => 'checkbox',
																												'class' => '',
																												'id' => 'by_age_more_years_female' . $lab,
																												'label' => false,
																												'div' => false,
																												'error' => false
																										) );
																										?>
						</td>
						<td width="55" align="left"><?php echo __("More Than For Female");?>
						</td>
						<td width="50"><?php

						echo $this->Form->input ( '', array (
																												'value' => $lab_value ['Laboratory'] ['by_age_num_more_years_female'],
																												'name' => "data[LaboratoryParameter][$lab][by_age_num_more_years_female]",
																												'type' => 'text',
																												'autocomplete' => 'off',
																												'class' => '',
																												'id' => 'by_age_num_more_years_female' . $lab,
																												'size' => "3",
																												'label' => false,
																												'div' => false,
																												'error' => false
																										) );
																										?>
						</td>
						<td width="100"><?php

						echo $this->Form->input ( '', array (
									'selected' => $lab_value ['Laboratory'] ['by_age_days_more_female'],
									'options' => array('Day(s)'=>'Day(s)','Month(s)'=>'Month(s)','Year(s)'=>'Year(s)'),
									'name' => "data[LaboratoryParameter][$lab][by_age_days_more_female]",
									'class' => 'textBoxExpnd',
									'id' => "by_age_days_more_female_$lab",
									'label' => false,
									'div' => false,
									'error' => false
							) );
							?>
						</td>
						<td width="70" align="center"><?php

						echo $this->Form->input ( '', array (
																												'value' => $lab_value ['Laboratory'] ['by_age_num_gret_years_lower_limit_female'],
																												'name' => "data[LaboratoryParameter][$lab][by_age_num_gret_years_lower_limit_female]",
																												'type' => 'text',
																												'autocomplete' => 'off',
																												'class' => '',
																												'id' => 'by_age_num_gret_years_lower_limit_female' . $lab,
																												'size' => "3",
																												'label' => false,
																												'div' => false,
																												'error' => false
																										) );
																										?>
						</td>
						<td width="70" align="center"><?php

						echo $this->Form->input ( '', array (
																												'value' => $lab_value ['Laboratory'] ['by_age_num_gret_years_upper_limit_female'],
																												'name' => "data[LaboratoryParameter][$lab][by_age_num_gret_years_upper_limit_female]",
																												'type' => 'text',
																												'autocomplete' => 'off',
																												'class' => '',
																												'id' => 'by_age_num_gret_years_upper_limit_female' . $lab,
																												'size' => "3",
																												'label' => false,
																												'div' => false,
																												'error' => false
																										) );
																										?>
						</td>

						<td width="70" align="center"><?php

						echo $this->Form->input ( '', array (
																												'value' => $lab_value ['Laboratory']  ['by_age_num_gret_years_default_result_female'],
																												'name' => "data[LaboratoryParameter][$lab][by_age_num_gret_years_default_result_female]",
																												'type' => 'text',
																												'autocomplete' => 'off',
																												'class' => '',
																												'id' => 'by_age_num_gret_years_default_result_female' . $lab,
																												'size' => "20",
																												'label' => false,
																												'div' => false,
																												'error' => false
																										) );
																										?>
						</td>
					</tr>
					<?php $unSzSex = array_values(unserialize($lab_value ['Laboratory']['by_age_sex']));
					$unSzLess = array_values(unserialize($lab_value ['Laboratory']['by_age_between_num_less_years']));
					$unSzGret = array_values(unserialize($lab_value ['Laboratory']['by_age_between_num_gret_years']));
					$unSzBetween = array_values(unserialize(unserialize($lab_value ['Laboratory']['by_age_days_between'])));
					$unSzLower = array_values(unserialize($lab_value ['Laboratory']['by_age_between_years_lower_limit']));
					$unSzUpper = array_values(unserialize($lab_value ['Laboratory']['by_age_between_years_upper_limit']));
					$unSzDefault = array_values(unserialize($lab_value ['Laboratory']['by_age_between_years_default_result']));

					$invisibleAge = 0;
																								 for($age=0;$age<(count($unSzLess));){ ?>
					<tr>
						<?php ?>
						<td width="25"><?php if($age == 0){

							echo $this->Form->input ( '', array (
																												'checked' => $by_age_between_years,
																												'value' => $lab_value ['Laboratory'] ['by_age_between_years'],
																												'name' => "data[LaboratoryParameter][$lab][by_age_between_years]",
																												'type' => 'checkbox',
																												'class' => '',
																												'id' => 'by_age_between_years' . $lab,
																												'label' => false,
																												'div' => false,
																												'error' => false
																										) );
						}
						?>
						</td>
						<td width="55" align="left">Between <?php
						echo $this->Form->input ( '', array (
									'selected' => $unSzSex[$age],
									'options' => array('Male'=>'Male','Female'=>'Female'),
									'name' => "data[LaboratoryParameter][$lab][by_age_sex][$age]",
									'class' => 'textBoxExpnd',
									'id' => "by_age_sex_$lab",
									'label' => false,
									'div' => false,
									'error' => false
							) );


							?>
						</td>

						<td width="58" colspan=""><?php

						echo $this->Form->input ( '', array (
																												//'value' => $lab_value ['Laboratory'] ['by_age_between_num_less_years'],
																												'value' => $unSzLess[$age],
																												'name' => "data[LaboratoryParameter][$lab][by_age_between_num_less_years][$age]",
																												'type' => 'text',
																												'autocomplete' => 'off',
																												'class' => '',
																												'id' => 'by_age_between_num_less_years' . $lab,
																												'size' => "1",
																												'label' => false,
																												'div' => false,
																												'error' => false
																										) );
																										?>- <?php

																										echo $this->Form->input ( '', array (
																												//'value' => $lab_value ['Laboratory'] ['by_age_between_num_gret_years'],
																												'value' =>$unSzGret[$age],
																												'name' => "data[LaboratoryParameter][$lab][by_age_between_num_gret_years][$age]",
																												'type' => 'text',
																												'class' => '',
																												'id' => 'by_age_between_num_gret_years' . $lab,
																												'size' => "1",
																												'label' => false,
																												'div' => false,
																												'error' => false
																										) );
																										?>
						</td>
						<td><?php

						echo $this->Form->input ( '', array (
									'selected' => $unSzBetween[$age],
									'options' => array('Day(s)'=>'Day(s)','Month(s)'=>'Month(s)','Year(s)'=>'Year(s)'),
									'name' => "data[LaboratoryParameter][$lab][by_age_days_between][$age]",
									'class' => 'textBoxExpnd',
									'id' => "by_age_days_between". $lab,
									'label' => false,
									'div' => false,
									'error' => false
							) );
							?>
						</td>
						<td width="70" align="center"><?php

						echo $this->Form->input ( '', array (
																												'value' => $unSzLower[$age],
																												'name' => "data[LaboratoryParameter][$lab][by_age_between_years_lower_limit][$age]",
																												'type' => 'text',
																												'autocomplete' => 'off',
																												'class' => '',
																												'id' => 'by_age_between_years_lower_limit' . $lab,
																												'size' => "3",
																												'label' => false,
																												'div' => false,
																												'error' => false
																										) );
																										?>
						</td>
						<td width="70" align="center"><?php

						echo $this->Form->input ( '', array (
																												'value' => $unSzUpper[$age],
																												'name' => "data[LaboratoryParameter][$lab][by_age_between_years_upper_limit][$age]",
																												'type' => 'text',
																												'autocomplete' => 'off',
																												'class' => '',
																												'id' => 'by_age_between_years_upper_limit' . $lab,
																												'size' => "3",
																												'label' => false,
																												'div' => false,
																												'error' => false
																										) );
																										?>
						</td>
						<td width="70" align="center"><?php

						echo $this->Form->input ( '', array (
																												'value' => $unSzDefault[$age],
																												'name' => "data[LaboratoryParameter][$lab][by_age_between_years_default_result][$age]",
																												'type' => 'text',
																												'autocomplete' => 'off',
																												'class' => '',
																												'id' => 'by_age_between_years_default_result' . $lab,
																												'size' => "20",
																												'label' => false,
																												'div' => false,
																												'error' => false
																										) );
																										?>
						</td>
						<?php if($age==(count($unSzLess)-1)){?>
						<td width="70"><?php echo $this->Html->image('icons/plus_6.png', array('id'=>'addButtonAge_'.$lab,'title'=>'Add','class'=>'addMoreAge'));?>
						</td>
						<?php }else{?>
						<td></td>
						<?php }?>
					</tr>
					<?php $age++; $invisibleAge++;
}?>
				</table>
			</div>


			<div id="formula-section_<?php echo $lab;?>" style="display: none">
				<table width="100%" cellpadding="0" cellspacing="0" border="0"
					style="border-top: 1px solid #3e474a;">

					<tr>
						<td height="25"><?php echo __('Select Test');?> :</td>
						<td><?php
						$listArrayChanged = $listArray;
						unset ( $listArrayChanged [$lab_value ['Laboratory'] ['id']] );
						echo $this->Form->input ( 'Laboratory.formula_field', array (
																												'options' => $listArrayChanged,
																												'empty' => __ ( 'Please Select' ),
																												'escape' => false,
																												'id' => 'formulaField_' . $lab,
																												'class' => 'textBoxExpnd formula_field',
																												'autocomplete' => 'off',
																												'style' => 'width:100px;'
																										) );

																										?>
						</td>
						<td><?php
						echo $this->Form->Button ( __ ( '1' ), array (
																												'value' => '1',
																												'style' => 'font-size:16px;text-align:center;',
																												'type' => 'button',
																												'label' => false,
																												'div' => false,
																												'error' => false,
																												'escape' => false,
																												'class' => 'blueBtn closingParaBtn calcBtn',
																												'id' => 'one_' . $lab
																										) );
																										?>
						</td>
						<td><?php
						echo $this->Form->Button ( __ ( '2' ), array (
																												'value' => '2',
																												'style' => 'font-size:16px;text-align:center;',
																												'type' => 'button',
																												'label' => false,
																												'div' => false,
																												'error' => false,
																												'escape' => false,
																												'class' => 'blueBtn closingParaBtn calcBtn',
																												'id' => 'two_' . $lab
																										) );
																										?>
						</td>
						<td><?php
						echo $this->Form->Button ( __ ( '3' ), array (
																												'value' => '3',
																												'style' => 'font-size:16px;text-align:center;',
																												'type' => 'button',
																												'label' => false,
																												'div' => false,
																												'error' => false,
																												'escape' => false,
																												'class' => 'blueBtn closingParaBtn calcBtn',
																												'id' => 'three_' . $lab
																										) );
																										?>
						</td>
						<td><?php
						echo $this->Form->Button ( __ ( '4' ), array (
																												'value' => '4',
																												'style' => 'font-size:16px;text-align:center;',
																												'type' => 'button',
																												'label' => false,
																												'div' => false,
																												'error' => false,
																												'escape' => false,
																												'class' => 'blueBtn closingParaBtn calcBtn',
																												'id' => 'four_' . $lab
																										) );
																										?>
						</td>
						<td><?php
						echo $this->Form->Button ( __ ( '5' ), array (
																												'value' => '5',
																												'style' => 'font-size:16px;text-align:center;',
																												'type' => 'button',
																												'label' => false,
																												'div' => false,
																												'error' => false,
																												'escape' => false,
																												'class' => 'blueBtn closingParaBtn calcBtn',
																												'id' => 'five_' . $lab
																										) );
																										?>
						</td>
						<td><?php
						echo $this->Form->Button ( __ ( '6' ), array (
																												'value' => '6',
																												'style' => 'font-size:16px;text-align:center;',
																												'type' => 'button',
																												'label' => false,
																												'div' => false,
																												'error' => false,
																												'escape' => false,
																												'class' => 'blueBtn closingParaBtn calcBtn',
																												'id' => 'six_' . $lab
																										) );
																										?>
						</td>
						<td><?php
						echo $this->Form->Button ( __ ( '7' ), array (
																												'value' => '7',
																												'style' => 'font-size:16px;text-align:center;',
																												'type' => 'button',
																												'label' => false,
																												'div' => false,
																												'error' => false,
																												'escape' => false,
																												'class' => 'blueBtn closingParaBtn calcBtn',
																												'id' => 'seven_' . $lab
																										) );
																										?>
						</td>
						<td><?php
						echo $this->Form->Button ( __ ( '8' ), array (
																												'value' => '8',
																												'style' => 'font-size:16px;text-align:center;',
																												'type' => 'button',
																												'label' => false,
																												'div' => false,
																												'error' => false,
																												'escape' => false,
																												'class' => 'blueBtn closingParaBtn calcBtn',
																												'id' => 'eight_' . $lab
																										) );
																										?>
						</td>
						<td><?php
						echo $this->Form->Button ( __ ( '9' ), array (
																												'value' => '9',
																												'style' => 'font-size:16px;text-align:center;',
																												'type' => 'button',
																												'label' => false,
																												'div' => false,
																												'error' => false,
																												'escape' => false,
																												'class' => 'blueBtn closingParaBtn calcBtn',
																												'id' => 'nine_' . $lab
																										) );
																										?>
						</td>

						<td><?php
						// echo $this->Form->Button(__('0'), array('value'=>"0",'style'=>'font-size:16px;text-align:center;','type'=>'button','label' => false,'div' => false,'error'=>false,'escape' => false,'class' => 'blueBtn closingParaBtn calcBtn','id'=>'zero_'.$lab));
						?>

							<button id="zero_<?php echo $lab;?>"
								class="blueBtn closingParaBtn calcBtn"
								style="font-size: 16px; text-align: center;" value="0"
								type="button">0</button>
						</td>
						<td><?php
						echo $this->Form->Button ( __ ( '.' ), array (
																												'value' => '.',
																												'style' => 'font-size:20px;text-align:center;',
																												'type' => 'button',
																												'label' => false,
																												'div' => false,
																												'error' => false,
																												'escape' => false,
																												'class' => 'blueBtn plusBtn calcBtn',
																												'id' => 'dotBtn_' . $lab
																										) );
																										?>
						</td>
						<td><?php
						echo $this->Form->Button ( __ ( '+' ), array (
																												'value' => '+',
																												'style' => 'font-size:18px;text-align:center;',
																												'type' => 'button',
																												'label' => false,
																												'div' => false,
																												'error' => false,
																												'escape' => false,
																												'class' => 'blueBtn plusBtn calcBtn',
																												'id' => 'plusBtn_' . $lab
																										) );
																										?>
						</td>
						<td><?php
						echo $this->Form->Button ( __ ( '-' ), array (
																												'value' => '-',
																												'style' => 'font-size:18px;text-align:center;',
																												'type' => 'button',
																												'label' => false,
																												'div' => false,
																												'error' => false,
																												'escape' => false,
																												'class' => 'blueBtn minusBtn calcBtn',
																												'id' => 'minusBtn_' . $lab
																										) );
																										?>
						</td>
						<td><?php
						echo $this->Form->Button ( __ ( '*' ), array (
																												'value' => '*',
																												'style' => 'font-size:18px;text-align:center;',
																												'type' => 'button',
																												'label' => false,
																												'div' => false,
																												'error' => false,
																												'escape' => false,
																												'class' => 'blueBtn multiplyBtn calcBtn',
																												'id' => 'multiplyBtn_' . $lab
																										) );
																										?>
						</td>
						<td><?php
						echo $this->Form->Button ( __ ( '/' ), array (
																												'value' => '/',
																												'style' => 'font-size:18px;text-align:center;',
																												'type' => 'button',
																												'label' => false,
																												'div' => false,
																												'error' => false,
																												'escape' => false,
																												'class' => 'blueBtn devideBtn calcBtn',
																												'id' => 'devideBtn_' . $lab
																										) );
																										?>
						</td>
						<td><?php
						echo $this->Form->Button ( __ ( '(' ), array (
																												'value' => '(',
																												'style' => 'font-size:16px;text-align:center;',
																												'type' => 'button',
																												'label' => false,
																												'div' => false,
																												'error' => false,
																												'escape' => false,
																												'class' => 'blueBtn openingParaBtn calcBtn',
																												'id' => 'openingParaBtn_' . $lab
																										) );
																										?>
						</td>
						<td><?php
						echo $this->Form->Button ( __ ( ')' ), array (
																												'value' => ')',
																												'style' => 'font-size:16px;text-align:center;',
																												'type' => 'button',
																												'label' => false,
																												'div' => false,
																												'error' => false,
																												'escape' => false,
																												'class' => 'blueBtn closingParaBtn calcBtn',
																												'id' => 'closingParaBtn_' . $lab
																										) );
																										?>
						</td>
	<td><?php
																										echo $this->Form->Button ( __ ( 'x<sup>y</sup>' ), array (
																												'value' => 'raiseToPower',
																												'style' => 'font-size:16px;text-align:center;',
																												'type' => 'button',
																												'label' => false,
																												'div' => false,
																												'error' => false,
																												'escape' => false,
																												'class' => 'blueBtn raiseToPowerBtn calcBtn',
																												'id' => 'raiseToPowerBtn_' . $lab 
																										) );
																										?></td>
																										
						<td><?php
						echo $this->Form->Button ( __ ( 'x<sup>y</sup>' ), array (
																												'value' => 'raiseToPower',
																												'style' => 'font-size:16px;text-align:center;',
																												'type' => 'button',
																												'label' => false,
																												'div' => false,
																												'error' => false,
																												'escape' => false,
																												'class' => 'blueBtn raiseToPowerBtn calcBtn',
																												'id' => 'raiseToPowerBtn_' . $lab
																										) );
																										?>
						</td>

						<td><?php
						echo $this->Form->Button ( __ ( 'DEL' ), array (
																												'value' => 'del',
																												'style' => 'font-size:12px;text-align:center;',
																												'type' => 'button',
																												'label' => false,
																												'div' => false,
																												'error' => false,
																												'escape' => false,
																												'class' => 'blueBtn closingParaBtn calcBtn',
																												'id' => 'delBtn_' . $lab
																										) );
																										?>
						</td>
					</tr>

					<tr>
						<td><?php
						echo __ ( "Formula" );
						?> :</td>
						<td colspan="16"><?php
						echo $this->Form->input ( '', array (
																												"readonly" => "readonly",
																												'name' => "data[LaboratoryParameter][$lab][formulaText]",
																												'escape' => false,
																												'id' => 'formulaText_' . $lab,
																												'class' => 'textBoxExpnd formulaText',
																												'autocomplete' => 'off',
																												'type' => 'textarea',
																												'rows' => '8',
																												'cols' => '15'
																										) );
																										echo $this->Form->hidden ( '', array (
																												'escape' => false,
																												'id' => 'formula_' . $lab,
																												'value' => '',
																												'name' => "data[LaboratoryParameter][$lab][formula]"
																										) );
																										echo $this->Form->hidden ( '', array (
																												'escape' => false,
																												'id' => 'formulaSafeChar_' . $lab,
																												'value' => '',
																												'name' => "data[LaboratoryParameter][$lab][formulaSafeChar]"
																										) );
																										echo $this->Form->hidden ( '', array (
																												'escape' => false,
																												'id' => 'formulaSafeText_' . $lab,
																												'value' => '',
																												'name' => "data[LaboratoryParameter][$lab][formulaSafeText]"
																										) );

																										?>
						</td>


					</tr>

				</table>
			</div> <!-- Pawan By range start -->
			<div style="display:<?php echo $range_section; ?>;" id="range_positive_negative_section_<?php echo $lab; ?>" >
				<table width="100%" cellpadding="0" cellspacing="0" border="0"
					style="border-top: 1px solid #3e474a;" ><!--  id="addTrRange_<?php //echo $lab; ?>"-->
					<tr>
						<td height="25">&nbsp;</td>
						<td>&nbsp;</td>

						<td align="left">Value</td>
						<td align="left">Interpretation</td>
					</tr>
					<?php

					if ($lab_value ['Laboratory'] ['by_range_less_than'] == '1') {
																											$by_range_less_than = 'checked';
																										} else {
																											$by_range_less_than = '';
																										}

																										if ($lab_value ['Laboratory'] ['by_range_greater_than'] == '1') {
																											$by_range_greater_than = 'checked';
																										} else {
																											$by_range_greater_than = '';
																										}
																										//debug($lab_value ['Laboratory'] ['by_range_between']);exit;
																										if ($lab_value ['Laboratory'] ['by_range_between'] == '1') {
																											$by_range_between = 'checked';
																										} else {
																											$by_range_between = '';
																										}

																										?>
					<tr>
						<td width="25"><?php

						echo $this->Form->input ( '', array (
																												'name' => "data[LaboratoryParameter][$lab][by_range_less_than]",
																												'type' => 'checkbox',
																												'class' => '',
																												'id' => 'by_range_less_than',
																												'label' => false,
																												'div' => false,
																												'error' => false,
																												'checked' => $by_range_less_than
																										) );
																										?>
						</td>
						<td width="25">Less Than</td>

						<td width="70" align="left"><?php

						echo $this->Form->input ( '', array (
																												'value' => $lab_value ['Laboratory'] ['by_range_less_than_limit'],
																												'name' => "data[LaboratoryParameter][$lab][by_range_less_than_limit]",
																												'type' => 'text',
																												'autocomplete' => 'off',
																												'class' => '',
																												'id' => 'by_gender_male_lower_limit',
																												'size' => "3",
																												'label' => false,
																												'div' => false,
																												'error' => false
																										) );
																										?>
						</td>
						<td width="70" align="left"><?php

						echo $this->Form->input ( '', array (
																												'value' => $lab_value ['Laboratory'] ['by_range_less_than_interpretation'],
																												'name' => "data[LaboratoryParameter][$lab][by_range_less_than_interpretation]",
																												'type' => 'text',
																												'autocomplete' => 'off',
																												'class' => '',
																												'id' => 'by_gender_male_upper_limit',
																												'size' => "20",
																												'label' => false,
																												'div' => false,
																												'error' => false
																										) );
																										?>
						</td>

					</tr>
					
					
					
					
					
					
					<tr>
						<td colspan="5">
						<table width="100%" cellpadding="0" cellspacing="0" border="0" id="addTrRange_<?php echo $lab; ?>">
						 <?php 
							$unSzLower = array_values(unserialize($lab_value ['Laboratory']['by_range_between_lower_limit']));
							$unSzUpper = array_values(unserialize($lab_value ['Laboratory']['by_range_between_upper_limit']));
							$unSzInter = array_values(unserialize($lab_value ['Laboratory']['by_range_between_interpretation']));
							$invisible = 0;
							for($i=0;$i<(count($unSzLower));){ ?>

					<tr>
						<?php if($invisible==0){?>
						<td width="25"><?php

						echo $this->Form->input ( '', array (
								'name' => "data[LaboratoryParameter][$lab][by_range_between]",
								'type' => 'checkbox',
								'class' => '',
								'id' => 'by_range_between',
								'label' => false,
								'div' => false,
								'error' => false,
								'checked' => $by_range_between
						) );
						?>
						</td>
						<td width="25" align="right">Between</td>
						<?php }else{?>
						<td></td>
						<td></td>
						<?php }?>

						<td width="154" align="left"><?php

						echo $this->Form->input ( '', array (
							//'value' => $lab_value ['Laboratory'] ['by_range_between_lower_limit'],
							'value' => $unSzLower[$i],
							'name' => "data[LaboratoryParameter][$lab][by_range_between_lower_limit][$i]",
							'type' => 'text',
							'autocomplete' => 'off',
							'class' => '',
							'id' => 'by_range_between_lower_limit',
							'size' => "3",
							'label' => false,
							'div' => false,
							'error' => false
					) );
					?> - <?php

					echo $this->Form->input ( '', array (
								//'value' => $lab_value ['Laboratory'] ['by_range_between_upper_limit'],
								'value'=>$unSzUpper[$i],
								'name' => "data[LaboratoryParameter][$lab][by_range_between_upper_limit][$i]",
								'type' => 'text',
								'autocomplete' => 'off',
								'class' => '',
								'id' => 'by_range_between_upper_limit',
								'size' => "3",
								'label' => false,
								'div' => false,
								'error' => false
						) );
						?>
						</td>
						<td width="70" align="left"><?php

						echo $this->Form->input ( '', array (
								//'value' => $lab_value ['Laboratory'] ['by_range_between_interpretation'],
								'value'=>$unSzInter[$i],
								'name' => "data[LaboratoryParameter][$lab][by_range_between_interpretation][$i]",
								'type' => 'text',
								'autocomplete' => 'off',
								'class' => '',
								'id' => 'by_range_between_interpretation',
								'size' => "20",
								'label' => false,
								'div' => false,
								'error' => false
						) );
						?>
						</td>
						<?php if($i==(count($unSzLower)-1)){?>
						<td width="70"><?php echo $this->Html->image('icons/plus_6.png', array('id'=>'addButtonRange_'.$lab,'title'=>'Add','class'=>'addMoreRange'));?>
						</td>
						<?php }else{?>
						<td></td>
						<?php }?>
					</tr>
					<?php $i++; $invisible++; }?>
					</table>
						</td>
					</tr>
					
					
					
					
					
					
					<tr>
						<td width="25"><?php

						echo $this->Form->input ( '', array (
																												'name' => "data[LaboratoryParameter][$lab][by_range_greater_than]",
																												'type' => 'checkbox',
																												'class' => '',
																												'id' => 'by_range_greater_than',
																												'label' => false,
																												'div' => false,
																												'error' => false,
																												'checked' => $by_range_greater_than
																										) );
																										?>
						</td>
						<td width="">More Than</td>
						<td width="70" align="left"><?php

						echo $this->Form->input ( '', array (
																												'value' => $lab_value ['Laboratory'] ['by_range_greater_than_limit'],
																												'name' => "data[LaboratoryParameter][$lab][by_range_greater_than_limit]",
																												'type' => 'text',
																												'autocomplete' => 'off',
																												'class' => '',
																												'id' => 'by_range_greater_than',
																												'size' => "3",
																												'label' => false,
																												'div' => false,
																												'error' => false
																										) );
																										?>
						</td>
						<td width="70" align="left"><?php

						echo $this->Form->input ( '', array (
																												'value' => $lab_value ['Laboratory'] ['by_range_greater_than_interpretation'],
																												'name' => "data[LaboratoryParameter][$lab][by_range_greater_than_interpretation]",
																												'type' => 'text',
																												'autocomplete' => 'off',
																												'class' => '',
																												'id' => 'by_range_greater_than_interpretation',
																												'size' => "20",
																												'label' => false,
																												'div' => false,
																												'error' => false
																										) );
																										?>
						</td>
					</tr>
					<!--  
					<?php 
					$unSzLower = array_values(unserialize($lab_value ['Laboratory']['by_range_between_lower_limit']));
					$unSzUpper = array_values(unserialize($lab_value ['Laboratory']['by_range_between_upper_limit']));
					$unSzInter = array_values(unserialize($lab_value ['Laboratory']['by_range_between_interpretation']));
					$invisible = 0;
																								 for($i=0;$i<(count($unSzLower));){ ?>

					<tr>
						<?php if($invisible==0){?>
						<td width="25"><?php

						echo $this->Form->input ( '', array (
																												'name' => "data[LaboratoryParameter][$lab][by_range_between]",
																												'type' => 'checkbox',
																												'class' => '',
																												'id' => 'by_range_between',
																												'label' => false,
																												'div' => false,
																												'error' => false,
																												'checked' => $by_range_between
																										) );
																										?>
						</td>
						<td width="">Between</td>
						<?php }else{?>
						<td></td>
						<td></td>
						<?php }?>

						<td width="70" align="left"><?php

						echo $this->Form->input ( '', array (
																											//'value' => $lab_value ['Laboratory'] ['by_range_between_lower_limit'],
																											'value' => $unSzLower[$i],
																											'name' => "data[LaboratoryParameter][$lab][by_range_between_lower_limit][$i]",
																											'type' => 'text',
																											'autocomplete' => 'off',
																											'class' => '',
																											'id' => 'by_range_between_lower_limit',
																											'size' => "3",
																											'label' => false,
																											'div' => false,
																											'error' => false
																									) );
																									?> - <?php

																									echo $this->Form->input ( '', array (
																												//'value' => $lab_value ['Laboratory'] ['by_range_between_upper_limit'],
																												'value'=>$unSzUpper[$i],
																												'name' => "data[LaboratoryParameter][$lab][by_range_between_upper_limit][$i]",
																												'type' => 'text',
																												'autocomplete' => 'off',
																												'class' => '',
																												'id' => 'by_range_between_upper_limit',
																												'size' => "3",
																												'label' => false,
																												'div' => false,
																												'error' => false
																										) );
																										?>
						</td>
						<td width="70" align="left"><?php

						echo $this->Form->input ( '', array (
																												//'value' => $lab_value ['Laboratory'] ['by_range_between_interpretation'],
																												'value'=>$unSzInter[$i],
																												'name' => "data[LaboratoryParameter][$lab][by_range_between_interpretation][$i]",
																												'type' => 'text',
																												'autocomplete' => 'off',
																												'class' => '',
																												'id' => 'by_range_between_interpretation',
																												'size' => "20",
																												'label' => false,
																												'div' => false,
																												'error' => false
																										) );
																										?>
						</td>
						<?php if($i==(count($unSzLower)-1)){?>
						<td width="70"><?php echo $this->Html->image('icons/plus_6.png', array('id'=>'addButtonRange_'.$lab,'title'=>'Add','class'=>'addMoreRange'));?>
						</td>
						<?php }else{?>
						<td></td>
						<?php }?>
					</tr>
					<?php $i++; $invisible++;
}?>-->
				</table>
			</div> <!-- Pawan By range end -->
		</td>
		<td valign="top"><?php
																										$unitData = ($optUcums [$lab_value ['Laboratory'] ['unit']]) ? $optUcums [$lab_value ['Laboratory'] ['unit']] : $lab_value ['Laboratory'] ['unit_text']?>
			<?php

			echo $this->Form->input ( "LaboratoryParameter.$lab.unit_txt", array (
																												'type' => 'text',
																												'autocomplete' => 'off',
																												'class' => 'name_Ucms textBoxExpnd',
																												'value' => $optUcums [$lab_value ['Laboratory'] ['unit']],
																												'id' => "unitDisplay_$lab",
																												'size' => "3",
																												'label' => false,
																												'div' => false,
																												'error' => false/* ,'readonly'=>'readonly' */) ); // ,'value'=>$optUcums[$lab_value['Laboratory']['unit']]));
																										echo $this->Form->hidden ( "LaboratoryParameter.$lab.unit", array (
																												'value' => $lab_value ['Laboratory'] ['unit'],
																												'id' => "unit_$lab"
																										) );
																										?>
		</td>
		<td valign="top" align="center" style="padding-top: 15px;"><?php
		// Remove these commetn if want to enable delete functionality for attribute level
		echo $this->Html->link ( $this->Html->image ( 'icons/close-icon.png' ), '#', array (
																												'id' => "removeButton_$lab",
																												'escape' => false,
																												'class' => 'removeBtn',
																												'title' => 'Remove'
																										) );
																										?>
		</td>
	</tr>
	<?php
																									} // EOF foreach lab parameter
																									  // }																									?>
</table>
<p class="ht5"></p>
<table width="100%" cellpadding="0" cellspacing="0" border="0"
	align="center">
	<tr>
		<td width="50%" align="left"><?php
		echo $this->Form->Button ( __ ( 'Add More Category' ), array (
																															'type' => 'button',
																															'label' => false,
																															'div' => false,
																															'error' => false,
																															'escape' => false,
																															'class' => 'blueBtn hideForHistopathology',
																															'id' => 'addButton'
																													) );
																													?>
			<div align="center" id='busy-indicator' style="display: none;">
				&nbsp;
				<?php echo $this->Html->image('indicator.gif', array()); ?>
			</div>
		</td>
		<td width="50%" align="right"><?php
		echo $this->Form->hidden ( 'whichAct', array (
																																				'id' => 'whichAct'
																																		) );
																																		echo $this->Form->submit ( __ ( 'Save' ), array (
																																				'id' => 'save',
																																				'escape' => false,
																																				'class' => 'blueBtn hideForHistopathology',
																																				'label' => false,
																																				'div' => false,
																																				'error' => false,
																																				'style' => 'margin:0 10px 0 0;'
																																		) );
																																		// echo $this->Form->submit(__('Save & Add More Testing Method'), array('id'=>'add-more','title'=>'Save & Add More Testing Method','escape' => false,'class' => 'blueBtn hideForHistopathology','label' => false,'div' => false,'error'=>false));
																																		if($setData ['Laboratory']['lab_type'] != '2' && $setData ['Laboratory']['lab_type'] != '3'){
																																			 echo $this->Html->link ( __ ( 'Cancel' ), array (
																																					'action' => 'index'
																																			), array (
																																					'escape' => false,
																																					'class' => 'grayBtn '
																																			) ); 
																																		}
																																		?>
		</td>
	</tr>
</table>
<?php
// } //EOF cat check
echo $this->Form->end ();

?>
<!-- EOF lab Forms -->
<script language="javascript"> 
		$(document).ready(function(){
			$("#lab_type option[value='4']").attr("disabled","disabled");
			var getlab=$('#lab_type').val();		
			 if(getlab == '3'){ // for microBiology
				$('.showForMicroBiology').show();
				$('.Culture-Sensitivity').show();
                $('.histoCategoriesSubSect').hide();
                
			} 
			 if(getlab == '1'){ // for microBiology
					$('.histoCategoriesSubSect').hide();
	                
				} 
			var labType = $("#lab_type").val();
			/* if(labType == '2'){
				$("#lab_type option[value='1']").attr("disabled","disabled");
				$("#lab_type option[value='3']").attr("disabled","disabled");
			}else
				if(labType == '1'){
					$("#lab_type option[value='2']").attr("disabled","disabled");
					$("#lab_type option[value='3']").attr("disabled","disabled");
				
			}else
				if(labType == '3'){
					$("#lab_type option[value='1']").attr("disabled","disabled");
					$("#lab_type option[value='2']").attr("disabled","disabled");
				
			} */
			/*
			$("#name1").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","Laboratory",'id',"name",'null',"admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true,
				valueSelected:true,
				loadId : 'name,labId',
				
			});
			$("#name1").click(function(){
				 $("#name").val('');$("#labId").val('');$("#name1").val('');
			});
			*/
			getServiceGroup();			
			 var counter = <?php echo count($setData['LaboratoryParameter']); ;?>; 
			 var radioId = 2;

			 $(".is_descriptive").attr('checked',false);
			 	$('.is_panel_test').click(function(){
		  			if($(this).attr('id') == 'IsPanel1'){
		  				$(".classDescriptive").hide('slow');
		  				$(".classTestResultHelp").hide('slow');
		  				$(".classTestResultDefault").hide('slow');
		  				$(".is_descriptive").attr('checked',false);
		  				
		  			}else{
		  				$(".classDescriptive").show('slow');
		  				$(".is_descriptive").attr('checked',false);
		  			}
			  	});

			 	$('.is_descriptive').click(function(){
		  			if($(this).attr('id') == 'IsDescriptive1'){
		  				$(".classTestResultHelp").hide('slow');
		  				$(".classTestResultDefault").hide('slow');
		  			}else{
		  				$(".classTestResultHelp").show('slow');
		  				$(".classTestResultDefault").show('slow');
		  			}
			  	});
			  	
		  		$('#add-more').click(function(){
		  			$('#whichAct').val($(this).attr('id'));
			  	});
			  	
			 	$('.attr-type').live('change',function(){
			 		currEleText = $(this).attr('id');						 
					currTextPos  = currEleText.split("_");					 
				 	if($(this).val()=='text'){
						$('#radioGroup_'+currTextPos[1]).fadeOut();	
						$('#gender-section_'+currTextPos[1]).fadeOut(400);
						$('#age-section_'+currTextPos[1]).fadeOut('fast');
						$('#parameter_text_'+currTextPos[1]).delay(400).fadeIn(400);					
						$('#unit_'+currTextPos[1]).delay(400).fadeOut();
					}else{
						$('#parameter_text_'+currTextPos[1]).fadeOut(400);						
						$('#gender-'+currTextPos[1]).attr('checked','checked');						
						$('#age-section_'+currTextPos[1]).fadeOut('fast');
						$('#gender-section_'+currTextPos[1]).delay(400).fadeIn(400);
						$('#radioGroup_'+currTextPos[1]).delay(400).fadeIn(400);
						$('#unit_'+currTextPos[1]).delay(400).fadeIn(400);							
					}
				});
				//show/hide age or gender wise
				 
				$('.sort-by').live('click',function()
				{ 	
					var currEle = $(this).attr('id');						 
					var currPos  = currEle.split("-");						 	
					if(currPos[0]=='gender'){
						$('#type_'+currPos[1]).fadeIn(400);
						$('#type_text_'+currPos[1]).fadeIn(400);
						$('#range_positive_negative_section_'+currPos[1]).fadeOut(400);
						$('#age-section_'+currPos[1]).fadeOut(400);
						$('#formula-section_'+currPos[1]).fadeOut(400);
						$('#gender-section_'+currPos[1]).delay(400).fadeIn(400);
					}else if(currPos[0]=='age'){
						$('#type_'+currPos[1]).fadeIn(400);
						$('#type_text_'+currPos[1]).fadeIn(400);
						$('#range_positive_negative_section_'+currPos[1]).fadeOut(400);
						$('#gender-section_'+currPos[1]).fadeOut(400);
						$('#formula-section_'+currPos[1]).fadeOut(400);
						$('#age-section_'+currPos[1]).delay(400).fadeIn(400);
					}else if(currPos[0]=='range_positive_negative'){
						$('#type_'+currPos[1]).fadeOut(400);
						$('#type_text_'+currPos[1]).fadeOut(400);
						$('#age-section_'+currPos[1]).fadeOut(400);
						$('#gender-section_'+currPos[1]).fadeOut(400);
						$('#formula-section_'+currPos[1]).fadeOut(400);
						$('#range_positive_negative_section_'+currPos[1]).delay(400).fadeIn(400);
					}					
				 
				});
				//EOF age/gender
	 
	 		$('.is-formula').live('click',function(){
	 			var currEle = $(this).attr('id');						 
				var currPos  = currEle.split("-");
				if($(this).is(':checked',true)){
					$('#range_positive_negative_section_'+currPos[1]).fadeOut(400);
					$('#age-section_'+currPos[1]).fadeOut(400);
					$('#gender-section_'+currPos[1]).fadeOut(400);
					$('#formula-section_'+currPos[1]).delay(400).fadeIn(400);
				}else{
					$('#type_'+currPos[1]).fadeIn(400);
					$('#range_positive_negative_section_'+currPos[1]).fadeOut(400);
					$('#age-section_'+currPos[1]).fadeOut(400);
					$('#formula-section_'+currPos[1]).fadeOut(400);
					$('#gender-section_'+currPos[1]).delay(400).fadeIn(400);
				}
			});
	 
		   
		    $("#addButton").click(function () {		 
		    	var newCostDiv = $(document.createElement('tr'))
			     .attr("id", 'TestGroup' + counter);
				
		    	$.ajax({
					  url: "<?php echo $this->Html->url(array("controller" => 'laboratories', "action" => "ajax_edit_block", "admin" => false)); ?>",
					  data:{"counter":counter,"radioId":radioId},
					  context: document.body,
					  beforeSend:function(){
			    		//this is where we append a loading image
		    			$('#busy-indicator').show('fast');
			  		  },				  		  
					  success: function(data){	
			  			    $('#busy-indicator').hide('fast');							  
			  			  	newCostDiv.append(data);		 
							newCostDiv.appendTo("#TestGroup");	
							
					  }
				});   					 			 
				counter++;
				radioId = radioId+2  ;
				if(counter > 1) $('#removeButton').show('slow');
			});


		    $(".addMore").live("click",function(){
		    	id = $(this).attr('id');
		    	categoryValueCount = $(this).attr('count');
		    	var lastCounter = counter;
		    	var appendCounter = '';
		    	var lastClass = $(this).attr('class').split(' ').pop();
		    	var splitClassId = lastClass.split("catClass_");
		    	if(splitClassId[1] !== undefined){
					appendCounter = splitClassId[1];
				}
		    	if(appendCounter == ''){
		    		isCategoryAllowed = 'isCategoryAllowed';
		    	}
				newId = id.split("_");
				CategoryValue = $("#CategoryValue_"+newId[1]).val();
				altCateName   = $("#altCateName_"+newId[1]).val();
				categorySort   = $("#categorySort_"+newId[1]).val();
				sortCategory   = $("#sortCategory_"+newId[1]).val();
				hideCatCheckBox = 'hideCatCheckBox';
				
				
		    	//if(CategoryValue != '')
		    	if($("#CategoryValue_"+newId[1]) != '')
		        {
			    	var newCostDiv = $(document.createElement('tr')).attr("id", 'TestGroup' + counter).attr("class", 'catClassDef_'+appendCounter);
					$.ajax({
						  url: "<?php echo $this->Html->url(array("controller" => 'laboratories', "action" => "ajax_edit_block", "admin" => false)); ?>",
						  data:{"counter":counter,"radioId":radioId,"CategoryValue":CategoryValue,"altCateName":altCateName,"isCategoryAllowed":appendCounter,"categoryValueCount":categoryValueCount,"categorySort":categorySort,"hideCatCheckBox":hideCatCheckBox,"sortCategory":sortCategory},
						  context: document.body,
						  beforeSend:function(){
				    		//this is where we append a loading image
			  				$('#busy-indicator').show('fast');
				  		  },				  		  
						  success: function(data){	
				  			    $('#busy-indicator').hide('fast');							  
				  			  	newCostDiv.append(data);		 
				  			  	if(appendCounter != ''){
				  			  		newCostDiv.insertAfter($(".catClassDef_"+appendCounter).last());
				  			  	}else{
				  			  		newCostDiv.appendTo("#TestGroup");
				  			  	}
				  			  	//if(altCateName !=''){
									$("#sortCategoryAttr_"+lastCounter).show();
				  			  	//}	
						  }
					}); 
					counter++;
					radioId = radioId+2  ;
					if(counter > 1) $('#removeButton').show('slow');
		        }  					 
			});
					
		 
		     $(".removeBtn").live('click',function () {
		    	 	//if(confirm('Are You Sure?')){
		    			readyToRem = $(this).attr('id');						 
		    			readyToRemPos  = readyToRem.split("_");				 
			        	$("#TestGroup" + readyToRemPos[1]).remove();
			        	counter--;
		    	 	//}else{
						return false;
		    	 	//}					
			  });
			 
			   //BOF pankaj
			 	$('#service_group_id').change(function (){ 
			 		getServiceGroup();
			 	});

		 	function getServiceGroup()
		 	{
			 	$("#tarifflist option").remove();
		 		$.ajax({
		 				  url: "<?php echo $this->Html->url(array("controller" => 'wards', "action" => "getServiceGroup", "admin" => false)); ?>"+"/"+$('#service_group_id').val(),
		 				  context: document.body,
		 				  beforeSend:function(){
		 				    // this is where we append a loading image
		 				    $('#busy-indicator').show('fast');
		 				  }, 				  		  
		 				  success: function(data){
		 						$('#busy-indicator').hide('slow');
		 					  	data = jQuery.parseJSON(data);
		 					  	$("#tarifflist").append( "<option value=''>Select Service</option>" );
		 					  	if(data != ''){
		 					  		$('#list-content').show('slow'); 
		 							$.each(data, function(val, text) {
		 							    $("#tarifflist").append( "<option value='"+val+"'>"+text+"</option>" );
		 							});
		 							$('#tarifflist').attr('disabled', '');	
		 							$('#tarifflist').val('<?php echo $setData['Laboratory']['tariff_list_id'];?>');//for fetching saved value. --yashwant
		 					  	}else{
		 							$('#lsit-content').hide('fast');
		 					  	}		
		 					  	/*
		 					  	$("#lab_name").autocomplete("<?php
											// echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","TariffList",
											// "name",'null','null','service_category_id', "admin" => false,"plugin"=>false));											?>/service_category_id="+$('#service_group_id').val(), {
		 							width: 250,
		 							onItemSelect:function (data1) {  
		 								var itemID = data1.extra[0]; 
		 								$("#tarifflist").val(itemID);
		 							}
		 							 
		 						});
		 						*/
		 					  	$("#lab_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","TariffList",'id',"name","admin" => false,"plugin"=>false)); ?>"
			 							+"/service_category_id="+$('#service_group_id').val(), {
	 								width: 250,
	 								selectFirst: true,
	 								valueSelected:true,
	 								showNoId:true,
	 								loadId : 'lab_name,tarifflist',
	 								
	 							});
		 				  }
		 		});
		 	}
		 		
/*
				$("#lab_name").autocomplete("<?php
				// echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","TariffList",
				// "name",'null','null','service_category_id', "admin" => false,"plugin"=>false));				?>/service_category_id="+$('#service_group_id').val(), {
					width: 250, 				 
					onItemSelect:function (data1) {  
						var itemID = data1.extra[0]; 
						$("#tarifflist").val(itemID);
					}
				});   
*/
				$('#lab_name').focus(function() {
			        if (this.value === this.defaultValue) {
			            this.value = '';
			        }
				})
				.blur(function() {
			        if (this.value === '') {
			            this.value = this.defaultValue;
			        }
				});
			 	//formatItem: function(row) { $("#tarifflist").val(row[1]); return row[0];}
			 	//EOF pankaj     

			 	/* $("input").live('blur',function(){
				 	currentEleID = ($(this).attr('class')).split("-");
				 	nextUL=  $(".txtBoxUpper-"+currentEleID[1]).val() ;
				 	prevLL=  $(".txtBoxLower-"+currentEleID[1]).val() ; 
				 	selectedVal = $(this).val();
				 	
				 	var $startElement = $('#'+$(this).attr('id'));

				 	//get all text inputs
				 	var $inputs = $('input[type=text]');

				 	//search inputs for one that comes after starting element
				 	 
				 	if((currentEleID[0]=='txtBoxLower')){
				 		for (var i = 0; i < $inputs.length; i++) {
					 	    if (isAfter($inputs[i], $startElement)) {
					 	        var nextInput = $inputs[i];
					 	       	nextUL = $(nextInput).val();
					 	        break ;
					 	    } 
					 	}
					 	
					 	if((nextUL < selectedVal) || (nextUL == selectedVal)){
					 		alert('Please enter the value less than upper limit.');
					 		$(this).val('');
				 		}
					}else if((currentEleID[0]=='txtBoxUpper')){
						for (var i = 0; i < $inputs.length; i++) {
					 	    if (isLower($inputs[i], $startElement)) {
					 	        var nextInput = $inputs[i];
					 	       	prevLL = $(nextInput).val();
					 	        break ;
					 	    } 
					 	}
					 	alert(prevLL);
					 	if((prevLL > selectedVal) || (prevLL == selectedVal)){
					 		alert('Please enter the value More Than lower limit.');
						 	$(this).val('');
				 		}
					 	
					} 
				});

			 	function isAfter(elA, elB) {
			 	    return ($('*').index($(elA).last()) > $('*').index($(elB).first()));
			 	}
			 	
			 	function isLower(elA, elB) {
				 	alert($('*').index($(elA).first()));
			 	    return ($('*').index($(elA).first()) > $('*').index($(elB).last()));
			 	}*/
						
				var getlab=$('#lab_type').val();		
				if(getlab=='2'){
					$('.hideForHistopathology').hide();	
					$('.showForHistopathology').show();	
					$('.showForMicroBiology').hide();
					 $('.Culture-Sensitivity').hide();									
				}else if(getlab == '3'){ // for microBiology
					$('.showForMicroBiology').show();	
					$('.hideForHistopathology').hide();	
					$('.showForHistopathology').hide();		
					 $('.Culture-Sensitivity').show();		
				}else {
					$('.hideForHistopathology').show();	
					$('.showForHistopathology').hide();
					$('.showForMicroBiology').hide();	
					 $('.Culture-Sensitivity').hide();			
				}	
				$('.lab_type').click(function(){
					var getlab=$('#lab_type').val();		
					if(getlab=='2'){
						$('.hideForHistopathology').hide();	
						$('.showForHistopathology').show();	
						$('.showForMicroBiology').hide();	
						$('.Culture-Sensitivity').hide();							
					}else if(getlab == '3'){ // for microBiology
						$('.showForMicroBiology').show();	
						$('.hideForHistopathology').hide();	
						$('.showForHistopathology').hide();	
						$('.Culture-Sensitivity').show();		
					}else {
						$('.hideForHistopathology').show();	
						$('.showForHistopathology').hide();
						$('.showForMicroBiology').hide();	
						$('.Culture-Sensitivity').hide();		
					}		
				});	
				$('#add-morehistopathology').click(function(){
		  			$('#whichActHistopathology').val($(this).attr('id'));
			  	});
				 $("#addButtonHistopathology").click(function () {	
					 var cureentId=$(".getRow").last().attr('id');
					 var getNo=cureentId.split("_");
				//	 alert(getNo['1'])
					 var counter=parseInt(getNo['1']);
					 counter++;				
					 //parseInt("<?php //echo $counterInc;?>"); alert(counter);
					 if(isNaN()==true){
					//	 counter=1;
					 }
					// var counter=1;
					
				    	var newCostDiv = $(document.createElement('tr'))
					     .attr("id", 'TestGroupHistopathology_' + counter).attr('class','getRow');
						
				    	$.ajax({
							  url: "<?php echo $this->Html->url(array("controller" => 'laboratories', "action" => "ajax_add_histopathology", "admin" => false)); ?>",
							  data:{"counter":counter},
							  context: document.body,
							  beforeSend:function(){
					    		//this is where we append a loading image
				    			$('#busy-indicator').show('fast');
					  		  },				  		  
							  success: function(data){	
					  			    $('#busy-indicator').hide('fast');							  
					  			  	newCostDiv.append(data);		 
									newCostDiv.appendTo("#TestGroupHistopathology");	
									
							  }
						});   					 			 
				    	counter++;	 
						//radioId = radioId+2  ;
						if(counter > 1) $('#removeButtonHistopathology_').show('slow');
					});
				 $(".removeBtnHistopathology").live('click',function () {
			    	 	if(confirm('Are You Sure?')){
			    			readyToRem = $(this).attr('id');					    							 
			    			readyToRemPos  = readyToRem.split("_");				    			
			    			//var getLabID=$('#labID').val();		 
				        	$("#TestGroupHistopathology_" + readyToRemPos[1]).remove();
				        	//delete_code('histhopathology',readyToRemPos[1],getLabID);
			    	 	}					
				  });
				
	  });
		
	  // lab unit Ucums table
		$('.name_Ucms')
			.live('focus',function() { //alert($(this).attr('id')+','+$(this).attr('id').replace("Display_","_"));
			$(this).autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","Ucums",'code',"display_name",'null',"admin" => false,"plugin"=>false)); ?>",
				{
					width: 250,
					selectFirst : false,
					valueSelected:true,
					showNoId:true,
					loadId : $(this).attr('id')+','+$(this).attr('id').replace("Display_","_"),
					
					
				});

		});


		$(".category").live("click",function(){
			idd = $(this).attr('id');
			newId = idd.split("_");
			if($(this).is(':checked',true)){
				$("#CategoryName_"+newId[1]).show();
				$("#addMore_"+newId[1]).show();
				$("#sort_"+newId[1]).show();
				$("#sortCategoryAttr_"+newId[1]).show();
			}
			else{
				$("#CategoryName_"+newId[1]).hide();
				$("#addMore_"+newId[1]).hide();
				$("#sortCategoryAttr_"+newId[1]).hide();
				$("#sort_"+newId[1]).hide();
				
				
			}
		});

		$(".CategoryName").live("blur",function(){
			idd = $(this).attr('id');
			newId = idd.split("_");
			val = $(this).val();
			//$("#altCateName_"+newId[1]).val(val);
			count = $(this).attr('count');
			$(".altCateName_"+count).val(val);
		})
		$(".sort").live("blur",function(){
			idd = $(this).attr('id');
			newId = idd.split("_");
			val = $(this).val();
			count = $(this).attr('count');
			$(".categorySort_"+count).val(val);
			$(".sortCategory_"+count).val(val);
		})

		$("#test_group_id").change(function(){
		optionText = $("#test_group_id option:selected").text();
		if(optionText == 'Chemistry'){
			$('#lab_type').val('');
			$('.showForHistopathology').hide();
			$('.hideForHistopathology').show();	
		 	$("#lab_type option[value='2']").attr("disabled","disabled");
		}else{
			$("#lab_type option[value='2']").attr("disabled","");
		}
	});
	
	var formulaText = '';
	var formulaReal ='';
	var numberParaArray = ["0","1","2","3","4","5","6","7","8","9","raiseToPower"];
	var operatorArray = ["+","-","*","/","raiseToPower"];
	var paranthesisArray = ["(",")"];
	var isLastOperatorRaise = '';
	
	function allowedActions(lastElement,character,currentValue){
		if(lastElement != '' && lastElement !== undefined){
			if(character == 'select'){
				if(-1 != operatorArray.indexOf(lastElement) || currentValue == ')' || lastElement == '('){
					return true;
				}else{
					return false;
				}
			}else{
				
				/* var re = new RegExp(".", 'g');
				if(val.match(re)){
					val = val.replace(new RegExp("{{", 'g'), "");
					val = val.replace(new RegExp("}}", 'g'), "");
				} */
				if(((-1 == operatorArray.indexOf(lastElement)) && (-1 == numberParaArray.indexOf(lastElement)) && (-1 == paranthesisArray.indexOf(lastElement))) && ((-1 != operatorArray.indexOf(currentValue)) || (currentValue == ')') && (currentValue != '.'))){
					return true;
				}else if((-1 != numberParaArray.indexOf(lastElement)) && ((currentValue == 0) || (currentValue == '0') || (-1 != numberParaArray.indexOf(currentValue)) || (-1 != operatorArray.indexOf(currentValue)) || currentValue == ')'|| currentValue == '.')){
					return true;
				}else if((-1 != operatorArray.indexOf(lastElement)) && ((-1 == operatorArray.indexOf(currentValue)) && currentValue != ')'  && (currentValue != '.'))){
					return true;
				} else if((lastElement == '(')  && ((-1 == operatorArray.indexOf(currentValue)) && (currentValue != ')')  && (currentValue != '.'))){
					return true;
				}else if((lastElement == ')') && (-1 != operatorArray.indexOf(currentValue)) && (currentValue != '.')){
					return true;
				}else if((lastElement == '.') && (-1 != numberParaArray.indexOf(currentValue))){
					return true;
				}else if((lastElement == 'raiseToPower') && (-1 != numberParaArray.indexOf(currentValue))){
					return true;
				}else{
					return false;
				}
			}
		}else{
			if(-1 != operatorArray.indexOf(currentValue) || currentValue == ')'){
				return false;
			}else{
				return true;
			}
		}
	}
	var select = $.parseJSON('<?php echo json_encode(Configure::read('sensitivity') )?>');
	jQuery(document).ready(function(){
		//BOF Microbiology --Gaurav
	 	var microBiologyCounter = parseInt('<?php echo $microBiologyCounter;?>');
		$('.addMicroBiology').live('click',function(){
			var rowCount = $('#TestGroupMicroBiology tr').length;
			var groupID = $(".groupID").val();
			if(rowCount == 2)
				$('.removeMicroBiology:last').show();
			microBiologyCounter++;
			$(this).closest("tr")
			.after($('<tr>').attr({'id':'TestGroupMicroBiology_'+microBiologyCounter,'class':'getRow'})
				.append($('<td>').text(microBiologyCounter)
						.append($('<input>').attr({'type':'hidden','name':'data[LaboratoryMicroBiology]['+microBiologyCounter+'][culture_group_id]','autocomplete':'off','class':'groupID','value':groupID})))
				.append($('<td>').append($('<input>').attr({'type':'text','name':'data[LaboratoryMicroBiology]['+microBiologyCounter+'][attribute]','autocomplete':'off'})))
	    		.append($('<td>').append($('<input>').attr({'type':'textarea','name':'data[LaboratoryMicroBiology]['+microBiologyCounter+'][parameter_text]','autocomplete':'off','rows':'2'}).css({'width':'682px','height':'60px','resize':'both'})))
	    		.append($('<td>').append($('<img>').attr({'src':"<?php echo $this->webroot ?>theme/Black/img/icons/close-icon.png",'class':'removeMicroBiology',
	        				'id':'removeMicroBiology_'+microBiologyCounter,'title':'Remove'}))
						.append($('<img>').attr({'src':"<?php echo $this->webroot ?>theme/Black/img/icons/plus_6.png",'class':'addMicroBiology','id':'addMicroBiology_'+microBiologyCounter,
							'title':'Add'})))
				)
				$(this).hide();	
		});
		$('.removeMicroBiology').live('click',function(){
			currentId=$(this).attr('id');
			splitedId=currentId.split('_');
			ID=splitedId['1'];
			$("tr#TestGroupMicroBiology_"+ID).remove();
			$('.addMicroBiology:last').show();
			var rowCount = $('#TestGroupMicroBiology tr').length;
			if(rowCount == 2)
				$('.removeMicroBiology:last').hide();
		});

	var microBiologyCounterMeds  = parseInt('<?php echo $microBiologyCounterMeds; ?>');
	$('.pharmacyAutoComplete').live('focus',function() { 
		$(this).autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","PharmacyItem",'id',"name",'null',"admin" => false,"plugin"=>false)); ?>",{
			width: 250,
			selectFirst: true,
			valueSelected:true,
			loadId : $(this).attr('id')+','+$(this).attr('id').replace("pharmacyAutoComplete","pharmacyAutoCompleteId")
		});
	});
	$('.addMicroBiologyMeds').live('click',function(){
		var rowCount = $('#TestGroupMicroBiologyMeds tr').length;
		var groupID = $(".groupID").val();
		if(rowCount == 3)
			$('.removeMicroBiologyMeds:last').show();
		microBiologyCounterMeds++;
		$(this).closest("tr")
		.after($('<tr>').attr({'id':'TestGroupMicroBiologyMeds_'+microBiologyCounterMeds,'class':'getRow'})
			.append($('<td>').text(microBiologyCounterMeds)
					.append($('<input>').attr({'type':'hidden','name':'data[Laboratory][medication]['+microBiologyCounterMeds+'][culture_group_id]','autocomplete':'off','class':'groupID','value':groupID})))
			.append($('<td>').append($('<input>').attr({'type':'text','name':'data[Laboratory][medication]['+microBiologyCounterMeds+'][name]','id':'pharmacyAutoComplete_'+microBiologyCounterMeds}))
					.append($('<input>').attr({'type':'hidden','name' : 'data[Laboratory][medication]['+microBiologyCounterMeds+'][pharmacy_item_id]' , 'id' : 'pharmacyAutoCompleteId_'+microBiologyCounterMeds })))
    		.append($('<td>').append($('<select>').attr({'name':'data[Laboratory][medication]['+microBiologyCounterMeds+'][sensitivity_flag]','id':'selectType'+microBiologyCounterMeds}).css({'width':'68px'})))
    		.append($('<td>').append($('<img>').attr({'src':"<?php echo $this->webroot ?>theme/Black/img/icons/close-icon.png",'class':'removeMicroBiologyMeds',
        				'id':'removeMicroBiologyMeds_'+microBiologyCounterMeds,'title':'Remove'}))
					.append($('<img>').attr({'src':"<?php echo $this->webroot ?>theme/Black/img/icons/plus_6.png",'class':'addMicroBiologyMeds','id':'addMicroBiologyMeds_'+microBiologyCounterMeds,
						'title':'Add'})))
			)
			$(this).hide();	
		$('#pharmacyAutoComplete_'+microBiologyCounterMeds).autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","PharmacyItem",'id',"name",'null',"admin" => false,"plugin"=>false)); ?>",{
			width: 250,
			selectFirst: true,
			valueSelected:true,
			loadId : 'pharmacyAutoComplete_'+microBiologyCounterMeds+',pharmacyAutoCompleteId_'+microBiologyCounterMeds
		});
		
 	 	$.each(select, function(key, value) {
 	 	 	$('#selectType'+microBiologyCounterMeds).append(new Option(value , value) );
 		});
	});
	$('.removeMicroBiologyMeds').live('click',function(){
		currentId=$(this).attr('id');
		splitedId=currentId.split('_');
		ID=splitedId['1'];
		$("tr#TestGroupMicroBiologyMeds_"+ID).remove();
		$('.addMicroBiologyMeds:last').show();
		var rowCount = $('#TestGroupMicroBiologyMeds tr').length;
		if(rowCount == 3)
			$('.removeMicroBiologyMeds:last').hide();
	});
	//EOF gaurav
		//EOF gaurav
		
		$(".formula_field").change(function(){
			var id = $(this).attr('id');
			id  = id.split("_");
			formulaReal = $("#formula_"+id[1]).val();
			if(formulaReal != '' && formulaReal !== undefined){
				var lastElement =  searchLastElement(id[1]);
				if(!allowedActions(lastElement,'select')){
					$("#formulaField_"+id[1]).val("");
					return;
				}
			}
			
			var txt = $("#formulaField_"+id[1]+" option:selected").text();
			var val = $("#formulaField_"+id[1]+"  option:selected").val();
	
			formulaText = $("#formulaText_"+id[1]).val();
			formulaText += txt+" ";
			$("#formulaText_"+id[1]).val(formulaText);
	
			formulaReal = $("#formula_"+id[1]).val();
			formulaReal += "{{.formulaId_" + val + "}} ";
			$("#formula_"+id[1]).val(formulaReal);
	
			$("#formulaField_"+id[1]).val("");
	
			var formulaSafeText = $("#formulaSafeText_"+id[1]).val();
			var formulaSafeChar = $("#formulaSafeChar_"+id[1]).val();
			formulaSafeChar += "{{"+val+"}}";
			formulaSafeText += "{{"+txt+"}}";
			$("#formulaSafeText_"+id[1]).val(formulaSafeText);
			$("#formulaSafeChar_"+id[1]).val(formulaSafeChar);
			formulaText = '';formulaReal = '';
			
		});

		$(".calcBtn").click(function(){
			var id = $(this).attr('id');
			id  = id.split("_"); 
			var txt = val = $(this).val();
			txt = txt.trim();
			
			var lastElement =  searchLastElement(id[1]);
			if(id['0'] == 'zero'){
				 txt = '0';
			}

			if(txt == 'raiseToPower'){
				isLastOperatorRaise = '1';
			}else if(txt == '+' || txt == '-' || txt == '*' ||  txt == '/' || txt == ')'){
				isLastOperatorRaise = '';
			}
			
			if(txt == 'raiseToPower'){
				//raiseToPowerBtn
				if(!allowedActions(lastElement,'operators',txt)){
					$("#formulaField_"+id[1]).val("");
					return;
				}
				
				formulaText = $("#formulaText_"+id[1]).val();
				formulaText = formulaText.trim();
				formulaText += " "+txt+" ";
				$("#formulaText_"+id[1]).val(formulaText);

				/*formulaReal = $("#formula_"+id[1]).val();
				formulaReal = formulaReal.trim();
				lastElementIndex = formulaReal.lastIndexOf("}}");
				formulaReal = formulaReal.substr(0,lastElementIndex);
				formulaReal += val+"}} ";
				$("#formula_"+id[1]).val(formulaReal);*/ 

				 

				formulaReal = $("#formula_"+id[1]).val();
				formulaReal += "{{"+val+"}} ";
				$("#formula_"+id[1]).val(formulaReal);

				

				var formulaSafeText = $("#formulaSafeText_"+id[1]).val();
				var formulaSafeChar = $("#formulaSafeChar_"+id[1]).val();
				formulaSafeChar += "{{"+txt+"}}";
				formulaSafeText += "{{"+txt+"}}";
				$("#formulaSafeText_"+id[1]).val(formulaSafeText); 
				$("#formulaSafeChar_"+id[1]).val(formulaSafeChar); 
				
				formulaText = '';formulaReal = '';
				
			}else if(txt == 'del'){
				formulaText = $("#formulaText_"+id[1]).val();
				formulaReal = $("#formula_"+id[1]).val();
				lastElementIndex = formulaText.lastIndexOf(lastElement);
				$("#formulaText_"+id[1]).val(formulaText.substr(0,lastElementIndex));
				lastElementIndex = formulaReal.lastIndexOf("{{");
				
				$("#formula_"+id[1]).val(formulaReal.substr(0,lastElementIndex));
				var formulaSafeText = $("#formulaSafeText_"+id[1]).val();
				var formulaSafeChar = $("#formulaSafeChar_"+id[1]).val();
				lastElementIndex = formulaSafeText.lastIndexOf("{{");
				
				$("#formulaSafeText_"+id[1]).val(formulaSafeText.substr(0,lastElementIndex));
				lastElementIndex = formulaSafeChar.lastIndexOf("{{");
				$("#formulaSafeChar_"+id[1]).val(formulaSafeChar.substr(0,lastElementIndex));
				return;
			}else{
				formulaReal = $("#formula_"+id[1]).val();
				if(formulaReal === undefined){
					return;
				}
				
				if(!allowedActions(lastElement,'operators',txt)){
					$("#formulaField_"+id[1]).val("");
					return;
				}
				
				
				// two consecutive numbers
				var isFound = numberParaArray.indexOf(lastElement);
				var isFoundCurr = numberParaArray.indexOf(txt);
				//console.log(lastElement+ '---' +isFound+'????'+isFoundCurr);
				if((isFound != -1 && isFoundCurr != -1) || (isFound != -1 && txt == '.') || (lastElement == '.' && isFoundCurr != -1)){
					formulaText = $("#formulaText_"+id[1]).val();
					formulaText = formulaText.trim();
					formulaText += txt+" ";
					$("#formulaText_"+id[1]).val(formulaText);

					formulaReal = $("#formula_"+id[1]).val();
					formulaReal = formulaReal.trim();
					lastElementIndex = formulaReal.lastIndexOf("}}");
					formulaReal = formulaReal.substr(0,lastElementIndex);
					formulaReal += val+"}} ";
					$("#formula_"+id[1]).val(formulaReal);
					
				}else{
					formulaText = $("#formulaText_"+id[1]).val();
					formulaText += txt+" ";
					$("#formulaText_"+id[1]).val(formulaText);
			
					formulaReal = $("#formula_"+id[1]).val();
					formulaReal += "{{"+val+"}} ";
					$("#formula_"+id[1]).val(formulaReal);
				}
					
				$("#formulaField_"+id[1]).val("");

				var formulaSafeText = $("#formulaSafeText_"+id[1]).val();
				var formulaSafeChar = $("#formulaSafeChar_"+id[1]).val();
				formulaSafeChar += "{{"+txt+"}}";
				formulaSafeText += "{{"+txt+"}}";
				$("#formulaSafeText_"+id[1]).val(formulaSafeText);
				$("#formulaSafeChar_"+id[1]).val(formulaSafeChar);
				
				formulaText = '';formulaReal = '';
			}
		});

		function searchLastElement(id){
			var formulaSafeText = $("#formulaSafeText_"+id).val();
			var formulaSafeChar = $("#formulaSafeChar_"+id).val();
			if(formulaSafeText === undefined) formulaSafeText ='';
			if(formulaSafeChar === undefined) formulaSafeChar ='';
			formulaSafeText = formulaSafeText.split("}}");
			formulaSafeChar = formulaSafeChar.split("}}");
			var lastElement = formulaSafeText.length - 2;
			if(lastElement === undefined) lastElement = ''; 
			lastElement = formulaSafeText[lastElement];
			if(lastElement === undefined) lastElement = ''; 
			var find = '{{';
			var re = new RegExp(find, 'g');
			lastElement = lastElement.replace(re, "");
			if(lastElement === undefined) lastElement = ''; 
			return lastElement.trim();
			//formulaVal = formulaVal.trim();
		}


		var counter = 1;
		$('#addMoreDr').click(function(){
			$('#addTr')
			.append($('<tr>').attr({'id':'newRow_'+counter,'class':'newRow'})
					.append($('<td>').append($('<input>').attr({'id':'doctor_id_txt_'+counter,'class':'doctor_id_txt textBoxExpnd','type':'text','name':'data[Laboratory][doctor_id_txt][]'}))
									 .append($('<input>').attr({'id':'doctor_id_'+counter,'class':'textBoxExpnd','type':'hidden','name':'data[Laboratory][doctor_id][]'}))
							.append($('<img>').attr('src',"<?php echo $this->webroot ?>theme/Black/img/cross.png")
									.attr({'class':'removeButton','id':'removeButton_'+counter,'title':'Remove current row'}).css('float','right')))
			)
			counter++;
		});
			$('.removeButton').live('click',function() { 
			currentId=$(this).attr('id');
			splitedId=currentId.split('_');
			ID=splitedId['1'];
			$("#newRow_"+ID).remove();
	 });
	 
			$('.doctor_id_txt').live('focus',function() { 
			$(this).autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","DoctorProfile",'user_id',"doctor_name",'is_active=1','null','yes',"admin" => false,"plugin"=>false)); ?>", 
				{
				width: 250,
				selectFirst: true,
				valueSelected:true,
				loadId : $(this).attr('id')+','+$(this).attr('id').replace("_txt_","_")
				});
		});
	});

	
	
	
	
	var counter = ('<?php echo $i;?>' == '') ? 0 : '<?php echo $i?>';
		$('.addMoreRange').live('click',function(){
		idd = $(this).attr('id');
		newId = idd.split("_");
		$("#addTrRange_"+newId[1])
		.append($('<tr>').attr({'id':'newBrowseRow_'+counter,'class':'newBrowseRow'})
				.append($('<td>'))
				.append($('<td>'))
    		.append($('<td>').append($('<input>').attr({'id':'by_range_between_lower_limit_'+counter,'size':'3','type':'text','name':'data[LaboratoryParameter]['+newId[1]+'][by_range_between_lower_limit]['+counter+']','autocomplete':'off'})).append('&nbsp;-&nbsp;')
    			.append($('<input>').attr({'id':'by_range_between_upper_limit_'+counter,'size':'3','type':'text','name':'data[LaboratoryParameter]['+newId[1]+'][by_range_between_upper_limit]['+counter+']','autocomplete':'off'})))
    		.append($('<td>').append($('<input>').attr({'id':'by_range_between_interpretation_'+counter,'type':'text','name':'data[LaboratoryParameter]['+newId[1]+'][by_range_between_interpretation]['+counter+']','autocomplete':'off'})))
    		.append($('<td>').append($('<img>').attr('src',"<?php echo $this->webroot ?>theme/Black/img/cross.png")
					.attr({'class':'removeButton','id':'removeButton_'+counter,'title':'Remove current row'}).css('float','right')))
			)	
			counter++;
		
	});
	$('.removeButton').live('click',function(){
		currentId=$(this).attr('id');
		splitedId=currentId.split('_');
		ID=splitedId['1'];
		$("#newBrowseRow_"+ID).remove();
		 
	});	

	var counterAge = ('<?php echo $i;?>' == '') ? 0 : '<?php echo $i?>';
	$('.addMoreAge').live('click',function(){
		idd = $(this).attr('id');
		newId = idd.split("_");
		$("#addTrAge_"+newId[1])
		.append($('<tr>').attr({'id':'newAgeRow_'+counterAge,'class':'newAgeRow'})
				.append($('<td>'))
				.append($('<td>').append($('<select>').attr({'id':'by_age_sex'+counterAge,'class':'textBoxExpnd ','type':'select','name':'data[LaboratoryParameter]['+newId[1]+'][by_age_sex]['+counterAge+']'}).append($(' <option value="Male">Male</option><option value="Female">Female</option>'))))
    		.append($('<td>').append($('<input>').attr({'id':'by_age_between_num_less_years_'+counterAge,'size':'1','type':'text','name':'data[LaboratoryParameter]['+newId[1]+'][by_age_between_num_less_years]['+counterAge+']','autocomplete':'off'})).append('&nbsp;-&nbsp;')
    			.append($('<input>').attr({'id':'by_age_between_num_gret_years_'+counterAge,'size':'1','type':'text','name':'data[LaboratoryParameter]['+newId[1]+'][by_age_between_num_gret_years]['+counterAge+']','autocomplete':'off'})))
    		.append($('<td  width="100">')
    			.append($('<select>').attr({'id':'by_age_days_between_'+counterAge,'class':'textBoxExpnd','type':'select','name':'data[LaboratoryParameter]['+newId[1]+'][by_age_days_between]['+counterAge+']'})))
    			    			
    		.append($('<td  align="center">').append($('<input>').attr({'id':'by_age_between_years_lower_limit_'+counterAge,'size':'3','type':'text','name':'data[LaboratoryParameter]['+newId[1]+'][by_age_between_years_lower_limit]['+counterAge+']','autocomplete':'off'})))
    		.append($('<td  align="center">').append($('<input >').attr({'id':'by_age_between_years_upper_limit_'+counterAge,'size':'3','type':'text','name':'data[LaboratoryParameter]['+newId[1]+'][by_age_between_years_upper_limit]['+counterAge+']','autocomplete':'off'})))
    		.append($('<td  align="center">').append($('<input>').attr({'id':'by_age_between_years_default_result_'+counterAge,'size':'20','type':'text','name':'data[LaboratoryParameter]['+newId[1]+'][by_age_between_years_default_result]['+counterAge+']','autocomplete':'off'})))
    		.append($('<td>').append($('<img>').attr('src',"<?php echo $this->webroot ?>theme/Black/img/cross.png")
					.attr({'class':'removeButtonAge','id':'removeButtonAge_'+counterAge,'title':'Remove current row'}).css('float','right')))
			)	
			getDays();
			counterAge++;
		
	});
	function getDays(){
 	 	var selectDaysBetween = $.parseJSON('<?php echo json_encode(array('Day(s)'=>'Day(s)','Month(s)'=>'Month(s)','Year(s)'=>'Year(s)')) ?>');
 	 	$.each(selectDaysBetween, function(key, value) {
 	 	 	$('#by_age_days_between_'+counterAge).append(new Option(value , value) );
 		});
 	}
	$('.removeButtonAge').live('click',function(){
		currentId=$(this).attr('id');
		splitedId=currentId.split('_');
		ID=splitedId['1'];
		$("#newAgeRow_"+ID).remove();
		 
 	});
	var histopathologyConfigData = $.parseJSON('<?php echo $histopathologyConfigData;?>');
	var histopathologyConfigSubGroupData = $.parseJSON('<?php echo $histopathologyConfigSubGroupData;?>');
	var histopathologyConfigDataGroup = $.parseJSON('<?php echo $histopathologyConfigDataGroup;?>');

	$('#histo_sub_categories').live('change',function(){
		displayHistoTestOrder();
	});
	function displayHistoTestOrder(){
		var selectedGroup = $("#histo_sub_categories").val();
		var showList = histopathologyConfigSubGroupData[selectedGroup];
		console.log(showList);
		$(".histoAttrDefault").attr('disabled',true);
		$(".getRowClass").hide();
		
		$.each(showList, function( index, value ) { 
			$("#TestGroupHistopathology_"+index).show();
			$("#histoAttrName"+index).attr('disabled',false);
			$("#histoAttrValue"+index).attr('disabled',false);
			$("#TestGroupHistopathology_"+index).attr("drmAttr",index);
			$("#indexNum"+value).html(index + 1);
			
		});
			
		/*var $table=$('#TestGroupHistopathology');
		var rows = $table.find('tr').get();
		rows.sort(function(a, b) {
			var keyA = $(a).attr('drmAttr');console.log(keyA+'hello'+keyB);
			var keyB = $(b).attr('drmAttr');
			if (keyA > keyB) return 1;
			if (keyA < keyB) return -1;
			return 0;
		});
		$.each(rows, function(index, row) {
		$table.children('tbody').append(row);
		});*/
	}
	//displayHistoTestOrder();
	
	//-----------------------------------------------------------------------------------------------------------------------------------	
	$('.tabs .tab-links a').live('click', function(e)  {
        var currentAttrValue = $(this).attr('href');
        currentAttrValue = currentAttrValue.replace("#","");
        $("#currentSelectedTab").val(currentAttrValue);
        e.preventDefault();
        $("#laboratoryFrm").submit();
    });

	 $(".removeAttr").live('click',function () {
 	 	
 			readyToRem = $(this).attr('parameterID');	
 								 
 			$.ajax({
				  url: "<?php echo $this->Html->url(array("controller" => 'laboratories', "action" => "deleteAttr", "admin" => false)); ?>"+'/'+readyToRem,
				 // data:{"counter":counter,"radioId":radioId},
				 // context: document.body,
				  beforeSend:function(){
		    		//this is where we append a loading image
	    			$('#busy-indicator').show('fast');
		  		  },				  		  
				  success: function(data){	
		  			    $('#busy-indicator').hide('fast');							  
		  			   
						
				  }
			}); 
 	 					
	  });

	 
    
 </script>
