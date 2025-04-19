 <?php
	echo $this->Html->script ( 'jquery.autocomplete' );
	echo $this->Html->css ( 'jquery.autocomplete.css' );
	?>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Add Panel', true); ?>
	</h3>
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
});

</script>
<!--BOF lab Forms -->
<div>&nbsp;</div>
<?php
echo $this->Form->create ( 'Laboratory', array (
		'action' => 'add',
		'id' => 'laboratoryFrm',
		'inputDefaults' => array (
				'label' => false,
				'div' => false,
				'error' => false 
		) 
) );

?>
<table width="100%" cellpadding="0" cellspacing="0" border="0"
	align="center" id="first_table">
	<tr>
		<td>
			<table align="center" width="150%">
				<tr>
					<td class="tdLabel" id="boxSpace">Select Sub Specialty:<font
						color="red"> *</font></td>
					<td> 
					<?php
					echo $this->Form->input ( 'Laboratory.test_group_id', array (
							'options' => $testGroup,
							'empty' => __ ( 'Select Sub Specialty' ),
							'escape' => false,
							'id' => 'test_group_id',
							'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd',
							'autocomplete' => 'off',
							'style' => '' 
					) );
					?> 
				</td>
				</tr>
				<tr>
					<td class="tdLabel" id="boxSpace">Test Name<font color="red"> *</font></td>
					<td>
                            <?php
						 
						echo $this->Form->input ( 'Laboratory.name', array (
								'class' => 'textBoxExpnd validate[required,ajax[ajaxCheckDupLabName],custom[mandatory-enter]]',
								'value' => $test_name,
								'id' => 'name',
								'autocomplete' => 'off' 
						) );
						 
						?>
				</td>
				</tr>
				<tr>
					<td class="tdLabel" id="boxSpace"><?php echo __('Test Code');?>
					:</td>
					<td><?php
					echo $this->Form->input ( 'Laboratory.test_code', array (
							'class' => 'textBoxExpnd ',
							'autocomplete' => 'off',
							'id' => 'test_code' 
					) );
					?>
				</td>
				</tr>

				<tr>
					<td class="tdLabel" id="boxSpace"><?php echo __('Test Order');?>
				:</td>
					<td><?php
					echo $this->Form->input ( 'Laboratory.sort_order', array (
							'class' => 'textBoxExpnd ',
							'id' => 'sort_order' , 'type'=>'text'
					) );
					?>
			</td>
				</tr>
				<tr>
					<td class="tdLabel" id="boxSpace"><?php echo __('ICD 10 Code');?>
			:</td>
					<td><?php
					echo $this->Form->input ( 'Laboratory.icd10_code', array (
							'class' => 'textBoxExpnd ',
							'autocomplete' => 'off',
							'id' => 'icd10_code' 
					) );
					?>
		</td>
				</tr>


				<tr>
					<td class="tdLabel" id="boxSpace"><?php echo __('CGHS Code');?>
			:</td>
					<td><?php
					echo $this->Form->input ( 'Laboratory.cghs_code', array (
							'class' => 'textBoxExpnd ',
							'autocomplete' => 'off',
							'id' => 'cghs_code' 
					) );
					?>
		</td>
				</tr>


				<tr>
					<td class="tdLabel" id="boxSpace"><?php echo __('RSBY Code');?>
			:</td>
					<td><?php
					echo $this->Form->input ( 'Laboratory.rsby_code', array (
							'class' => 'textBoxExpnd ',
							'autocomplete' => 'off',
							'id' => 'rsby_code' 
					) );
					?>
		</td>
				</tr>


				<tr>
					<td class="tdLabel" id="boxSpace">Loinc Code:</td>
					<td><?php
					
					$read_only = "";
					if ($data ['Laboratory'] ['lonic_code'])
						$read_only = "readonly";
					echo $this->Form->input ( 'Laboratory.lonic_code', array (
							'value' => $data ['Laboratory'] ['lonic_code'],
							'class' => 'textBoxExpnd ',
							'autocomplete' => 'off',
							'id' => 'lonic_code',
							'readonly' => $read_only 
					) );
					?>
		</td>
				</tr>
				<tr>
					<td class="tdLabel" id="boxSpace">CPT Code:</td>
					<td><?php
					
					$read_only = "";
					if ($data ['Laboratory'] ['cbt'])
						$read_only = "readonly";
					echo $this->Form->input ( 'Laboratory.cbt', array (
							'value' => $data ['Laboratory'] ['cbt'],
							'class' => 'textBoxExpnd',
							'autocomplete' => 'off',
							'id' => 'cbt',
							'readonly' => $read_only 
					) );
					?>
		</td>
				</tr>


				<tr>
					<td class="tdLabel" id="boxSpace"><?php echo __('Machine Name');?>
			:</td>
					<td><?php
					echo $this->Form->input ( 'Laboratory.machine_name', array (
							'options' => Configure::read ( 'lab_machine_list' ),
							'empty' => 'Please Select',
							'class' => 'textBoxExpnd ',
							'id' => 'machine_name' 
					) );
					?>
		</td>
				</tr>

				<tr>
					<td class="tdLabel" id="boxSpace"><?php echo __('Title Machine Name');?>
			:</td>
					<td><?php
					echo $this->Form->input ( 'Laboratory.machine_title_name', array (
							'class' => 'textBoxExpnd ',
							'autocomplete' => 'off',
							'id' => 'machine_title_name' 
					) );
					?>
		</td>
				</tr>
<?php array_push($specimentTypes, 'OTHER');?>
				<tr>
					<td class="tdLabel" id="boxSpace"><?php echo __('Sample Type');?> :</td>
					<td><?php
					echo $this->Form->input ( 'Laboratory.specimen_collection_type', array (
							'empty' => 'Please Select',
							'options' => $specimentTypes,
							'class' => 'textBoxExpnd ',
							'id' => 'specimen_collection_type'
					) );
					?>
					</td>
				</tr>
				

				<tr id='otherOptionTextBox' style="display: none;">
					<td class="tdLabel" id="boxSpace"><?php echo __('New Sample Type');?> :</td>
					<td><?php
					echo $this->Form->input ( 'Laboratory.other_specimen_collection_type', array (
							'type'=>'text',
							'class' => 'textBoxExpnd validate[required,custom[mandatory-enter]]',
							'id' => 'other_specimen_collection_type'
					) );
					?>
					</td>
				</tr>
				<!--  
				<tr>
					<td valign="top"><?php echo $this->Html->image('icons/plus_6.png', array('id'=>'addMoreDr','title'=>'Add','class'=>'addMoreDr'));?><?php echo __('Doctor Name')?></td>
					<td>
						<table width="100%" id='addTr'>
							<tr>
								<td>
				<?php echo $this->Form->input('', array('name'=>'data[Laboratory][doctor_id_txt][]','type'=>'text','id'=>'doctor_id_txt_0','label'=>false,'class'=>'doctor_id_txt textBoxExpnd '));?>
				<?php echo $this->Form->hidden('', array('name'=>'data[Laboratory][doctor_id][]','label'=>false,'type'=>'text','id'=>'doctor_id_0','class'=>'validate[required,custom[mandatory-enter]]'));?></td>
							</tr>
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
					<td class="tdLabel" id="boxSpace"><?php echo __('Short Form');?>
			:</td>
					<td><?php
					echo $this->Form->input ( 'Laboratory.dhr_order_code', array (
							'class' => 'textBoxExpnd ',
							'autocomplete' => 'off',
							'id' => 'dhr_order_code' 
					) );
					?>
		</td>
				</tr>

				<tr>
					<td class="tdLabel" id="boxSpace"><?php echo __('Preparation Time');?>
			:</td>
					<td><?php
					echo $this->Form->input ( 'Laboratory.preparation_time', array (
							'class' => 'textBoxExpnd ',
							'autocomplete' => 'off',
							'id' => 'preparation_time' 
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
							'id' => 'instructions_for_preparation' 
					) );
					?>
		</td>
				</tr>


				<tr>
					<td class="tdLabel" id="boxSpace"><?php echo __('Attach File');?> :</td>
					<td><?php
					echo $this->Form->input ( 'is_file_attached', array (
							'div' => false,
							'type' => 'radio',
							'legend' => false,
							'id' => 'is_file_attached',
							'separator' => ' ',
							'default' => '0',
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
							'selected' => $labId,
							'escape' => false,
							'id' => 'service_group_id',
							'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd',
							'autocomplete' => 'off',
							'style' => 'width:94%;' 
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
							'empty' => __ ( 'Select Service' ) 
					) );
					?>
		</td>
				</tr>

				<tr>
					<td class="tdLabel" id="boxSpace"><?php echo __('Parameter (Panel Test)');?>
			:<font color="red"> *</font></td>
					<td><?php
					echo $this->Form->input ( 'is_panel', array (
							'div' => false,
							'type' => 'radio',
							'legend' => false,
							'id' => 'is_panel',
							'class' => 'validate[required,custom[mandatory-select]] is_panel_test',
							'separator' => ' ',
							'default' => '0',
							'options' => array (
									'0' => 'Single ',
									'1' => 'Multiple' 
							) 
					) );
					
					?>
		</td>
				</tr>

				<tr class="classDescriptive">
					<td class="tdLabel" id="boxSpace">&nbsp;</td>
					<td><?php
					echo $this->Form->input ( 'is_descriptive', array (
							'div' => false,
							'type' => 'radio',
							'legend' => false,
							'id' => 'is_descriptive',
							'class' => 'is_descriptive',
							'separator' => ' ',
							
							// 'default' => '0',
							'options' => array (
									'0' => 'Non-Descriptive ',
									'1' => 'Descriptive' 
							) 
					) );
					
					?>
		</td>
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
							'style' => '' 
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
							'id' => 'default_result' 
					) );
					?>
		</td>
				</tr>

				<tr>
					<td class="tdLabel" id="boxSpace"><?php echo __('Note/Opinion Display Text');?> :</td>
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
					<td class="tdLabel" id="boxSpace"><?php echo __('Note/Opinion Template');?> :</td>
					<td><?php
					echo $this->Form->textarea ( 'Laboratory.notes', array (
							'class' => 'textBoxExpnd',
							'id' => 'note',
							'rows' => 5 
					) );
					?>
		</td>
				</tr>
				<tr>
					<td class="tdLabel" id="boxSpace"><?php echo __('Speciality');?>
			:<font color="red"> *</font></td>
					<td><?php
					
					echo $this->Form->input ( 'Laboratory.lab_type', array (
							'empty' => __ ( 'Please Select' ),
							'class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd lab_type',
							'id' => 'lab_type',
							'options' => Configure::read ( 'lab_type' ),
							'selected' => '1' 
					) );
					?>
		</td>
				</tr>

			</table>

		</td>
	</tr>

</table>

<p class="ht5"></p>
<!-- BOF-For histopathology_data -->
<table width="100%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm showForHistopathology" align="center"
	id="TestGroupHistopathology" style="display: none;">
	<tr>
		<th width="5%">Sr. No.</th>
		<th width="25%">Attribute Name</th>
		<th width="60%">Description</th>
		<th width="5%">Action</th>
	</tr>
	<?php
	
	$count_histopathology = 3;
	$getHistopathology = Configure::read ( 'histopathology_data' );
	foreach ( $getHistopathology as $key => $getData ) {
		?>
	<tr id="TestGroupHistopathology_<?php echo $key ?>" class="getRow">
		<td valign="top" style="padding-top: 10px;"><?php echo $key;?></td>
		<td valign="top"><?php
		
		echo $this->Form->input ( '', array (
				'name' => "data[LaboratoryHistopathology][$key][attribute]",
				'class' => "",
				'label' => false,
				'div' => false,
				'error' => false,
				'id' => '',
				'value' => $getData,
				'type' => 'text' 
		) );
		?>
		</td>
		<td style="padding-top: 10px;"><?php
		
		echo $this->Form->textarea ( '', array (
				'name' => "data[LaboratoryHistopathology][$key][parameter_text_histo]",
				'id' => 'histopathology_data_Frst',
				'label' => false,
				'div' => false,
				'error' => false,
				'style' => 'width:682px',
				'type' => 'text' 
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
	?>
		
</table>

<p class="ht5"></p>
<!-- BOF-For MicroBiology -->
<table width="100%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm showForMicroBiology" align="center"
	id="TestGroupMicroBiology" style="display: none;">
	<tr>
		<th width="5%">Sr. No.</th>
		<th width="25%">Attribute Name</th>
		<th width="60%">Description</th>
		<th width="5%">Action</th>
	</tr>
	<?php $microBiologyCounter = 1;?>
	<tr id="TestGroupMicroBiology_1" class="getRow">
		<td valign="top" style="padding-top: 10px;"><?php echo __('1');?></td>
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
		<td><?php echo $this->Html->image('icons/close-icon.png', array('id'=>"removeMicroBiology_$microBiologyCounter",'title'=>'Add',
					'class'=>'removeMicroBiology','style'=>"display :none;"));?>
		<?php echo $this->Html->image('icons/plus_6.png', array('id'=>'addMicroBiology_1','title'=>'Add','class'=>'addMicroBiology'));?>
		</td>
	</tr>
</table>
<p class="ht5"></p>
<table width="100%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm showForMicroBiology" align="center"
	id="TestGroupMicroBiologyMeds" style="display: none;">
	<tr>
		<th width="5%">Sr. No.</th>
		<th width="25%">Medication</th>
		<th width="60%">Sensitivity</th>
		<th width="5%">Action</th>
	</tr>
	<tr id="TestGroupMicroBiologyMeds_1" class="getRow">
		<td valign="top" style="padding-top: 10px;"><?php echo __('1');?></td>
		<td valign="top"><?php
		
		echo $this->Form->input ( "Laboratory.medication.1.name", array (
				'label' => false,
				'div' => false,
				'error' => false,
				'type' => 'text' ,
				'id' => 'pharmacyAutoComplete'
				
		) );
		echo $this->Form->hidden("Laboratory.medication.1.pharmacy_item_id",array('id'=>'pharmacyAutoCompleteId'));
		?>
		</td>
		<td style="padding-top: 10px;"><?php
		
		echo $this->Form->input ( "Laboratory.medication.1.kuchToh", array (
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
	<tr>
		<td width="100%" align="right" colspan="4"
			style="background: none repeat scroll 0% 0% white;"><?php
			echo $this->Form->submit ( __ ( 'Save' ), array ('id' => 'save','escape' => false,'class' => 'blueBtn','label' => false,'div' => false,'error' => false ) );
			//echo $this->Html->link ( __ ( 'Cancel' ), array ('action' => 'index' ), array ('escape' => false,'class' => 'grayBtn' ) );
			?>
		</td>
	</tr>
</table>
<!-- EOF MicroBilogy -->
<p class="ht5"></p>
<table width="100%" cellpadding="0" cellspacing="0" border="0"
	align="center" style="display: none;" class="showForHistopathology">
	<tr>
		<td width="50%" align="left"><?php
		// echo $this->Form->Button(__('Add More Attribute'), array('type'=>'button','label' => false,'div' => false,'error'=>false,'escape' => false,'class' => 'blueBtn','id'=>'addButtonHistopathology'));
		
		?>

			<div align="center" id='busy-indicator' style="display: none;">
				&nbsp;
				<?php echo $this->Html->image('indicator.gif', array()); ?>
			</div></td>
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
				'error' => false 
		) );
		// echo $this->Form->submit(__('Save & Add More Category'), array('id'=>'add-morehistopathology','title'=>'Save and Add More Category','escape' => false,'class' => 'blueBtn','label' => false,'div' => false,'error'=>false));
		echo $this->Html->link ( __ ( 'Cancel' ), array (
				'action' => 'index' 
		), array (
				'escape' => false,
				'class' => 'grayBtn' 
		) );
		?>
		</td>
	</tr>
</table>
<!-- EOF-For histopathology_data -->
<p class="ht5"></p>
<table width="100%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm hideForHistopathology" align="center" id="TestGroup">
	<tr>
		<!--<th width="50">Sr. No.</th>-->
		<th width="100">Category Name</th>
		<th width="400">Normal Range</th>
		<th width="50">Units</th>
		<th width="10">&nbsp;</th>
	</tr>
	<tr>
		<!--<td valign="top" style="padding-top: 10px;">1</td>-->
		<td valign="top">
			<table>
				<tr>
					<td><?php echo __("is Category?").$this->Form->input('Category',array('type'=>'checkbox','div'=>false,'label'=>false,'class'=>'category','id'=>'category_1')).__("Yes/No");  ?>
					</td>
				</tr>
				<tr>
					<td><?php echo $this->Form->input('',array('type'=>'text','name'=>'','class'=>'CategoryName','id'=>'CategoryName_1','autocomplete'=>'off','style'=>"display:none;")); ?>
					</td>
				</tr>
				<tr>
					<td><?php //echo $this->Form->input('',array('type'=>'text','id'=>'sort_1','name'=>'','class'=>'sort','autocomplete'=>'off'/* ,'style'=>'display:none;' */,'placeholder'=>'Sort Order'));?>
					</td>
				</tr>
				<tr>
					<td><?php echo $this->Html->image('icons/plus_6.png', array('id'=>'addMore_1','class'=>'addMore','title'=>'Add','style'=>'display:none;')); ?>
					</td>
					
				</tr>
				
			</table>
		</td>
		<td style="padding-top: 10px;">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td colspan="3">
						<table>
							<tr>
								<td><?php
								echo __ ( "Attribute Name:" ) . "&nbsp;";
								echo $this->Form->input ( '', array (
										'name' => "data[LaboratoryParameter][0][name_txt]",
										'class' => "name_lab_par1 validate[required,custom[mandatory-enter]]",
										'label' => false,
										'div' => false,
										'error' => false,
										'id' => 'labParaNameDisplay_Frst',
										'autocomplete' => 'off',
										'value' => '' 
								) );
								
								echo $this->Form->hidden ( '', array (
										'class' => 'CategoryValue',
										'id' => 'CategoryValue_1',
										'value' => '',
										'name' => "data[LaboratoryCategory][0][category_name]" 
								) );
								echo $this->Form->hidden ( '', array (
										'class' => 'categorySort',
										'id' => 'categorySort_1',
										'value' => '',
										'name' => "data[LaboratoryCategory][0][sort]"
								) );
								echo $this->Form->hidden ( '', array (
										'class' => 'CateName',
										'id' => 'CateName_1',
										'value' => '',
										'name' => "data[LaboratoryParameter][0][category_name]" 
								) );
								
								echo $this->Form->hidden ( '', array (
										'name' => "data[LaboratoryParameter][0][name]",
										'id' => "labParaName_Frst",
										'label' => false,
										'div' => false,
										'error' => false,
										'value' => '' 
								) );
								echo $this->Form->hidden ( '', array (
										'class' => 'sortCategory',
										'id' => 'sortCategory_1',
										'autocomplete' => 'off',
										'value' => '',
										'placeholder'=>'Sort Order',
										'name' => "data[LaboratoryParameter][0][sort_category]"
								) );
								?>
								</td>
								<td><?php /*echo __ ( "Sort Attribute:" ) . "&nbsp;";
								echo $this->Form->input ( '', array (
										'class' => 'sortOrder',
										'id' => 'sortOrder_1',
										'autocomplete' => 'off',
										'value' => '',
										'placeholder'=>'Sort Order',
										'name' => "data[LaboratoryParameter][0][sort_attribute]"
								) );*/ ?></td>
							</tr>
						</table>
						<hr>
					</td>
				</tr>
				<tr>
					<td width="40" class="tdLabel2">Type</td>
					<td width="100"><?php
					$type_arr = array (
							'numeric' => 'Numeric',
							'text' => 'Text' 
					);
					echo $this->Form->input ( '', array (
							'options' => $type_arr,
							'name' => "data[LaboratoryParameter][0][type]",
							'class' => 'attr-type textBoxExpnd validate[required,custom[name]]',
							'id' => "type_0",
							'label' => false,
							'div' => false,
							'error' => false 
					) );
					?>
					</td>
					<td><?php
					
					echo __ ( "Is Mandatory : " ) . $this->Form->input ( 'is_mandatory', array (
							'type' => 'checkbox',
							'div' => false,
							'checked' => 'checked',
							'label' => false,
							'class' => 'isMandatory',
							'id' => 'isMandatory-0',
							'name' => 'data[LaboratoryParameter][0][is_mandatory]' 
					) );
					?>
									</td>
					<td colspan="4">
						<div id="radioGroup_0" style="display: block">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td width="25"><input type="radio" class="sort-by"
										name="data[LaboratoryParameter][0][by_gender_age]"
										id="gender-0" value="gender" checked="checked" /></td>
									<td width="80"><?php echo __('By Sex'); ?></td>
									<td width="25"><input type="radio" class="sort-by"
										name="data[LaboratoryParameter][0][by_gender_age]" id="age-0"
										value="age" /></td>
									<td width="80">By Age</td>

									<!--  Pawan to check by range if positive or negative start -->
									<td width="25"><input type="radio" class="sort-by"
										name="data[LaboratoryParameter][0][by_gender_age]"
										id="range_positive_negative-0" value="range" /></td>
									<td width=""><?php echo __('By Range'); ?></td>
									<!--  Pawan to check by range if positive or negative end -->
								</tr>
							</table>
						</div>
					</td>




				</tr>
			</table>
			<div class="ht5"></div>
			<div id="parameter_text_0" style="display: none;">
				<table width="100%" cellpadding="0" cellspacing="0" border="0"
					style="border-top: 1px solid #3e474a;">
					<tr>
						<td style="padding-top: 5px;"><?php
						echo $this->Form->textarea ( '', array (
								'name' => "data[LaboratoryParameter][0][parameter_text]",
								'class' => 'textBoxExpnd validate[required,custom[mandatory-enter]]',
								'id' => "parameter_text_id_0",
								'label' => false,
								'div' => false,
								'error' => false 
						) );
						?>
						</td>

					</tr>
					<tr>
						<td align="right" style="padding-top: 5px; padding-bottom: 5px;">
							<?php echo __("Is multiple options?");?>
							<?php
							
							echo $this->Form->input ( '', array (
									'name' => "data[LaboratoryParameter][0][is_multiple_options]",
									'type' => 'checkbox',
									'class' => '',
									'id' => 'is_multiple_options_0',
									'size' => "3",
									'label' => false,
									'div' => false,
									'error' => false 
							) );
							?> [Please add comma (,) separated values]</td>
					</tr>
				</table>
			</div>
			<div id="gender-section_0">
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
						
						echo $this->Form->input ( '', array (
								'name' => "data[LaboratoryParameter][0][by_gender_male]",
								'type' => 'checkbox',
								'class' => '',
								'id' => 'by_gender_male',
								'label' => false,
								'div' => false,
								'error' => false 
						) );
						?>
						</td>
						<td width="">Male</td>

						<td width="70" align="center"><?php
						
						echo $this->Form->input ( '', array (
								'name' => "data[LaboratoryParameter][0][by_gender_male_lower_limit]",
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
						<td width="70" align="center"><?php
						
						echo $this->Form->input ( '', array (
								'name' => "data[LaboratoryParameter][0][by_gender_male_upper_limit]",
								'type' => 'text',
								'autocomplete' => 'off',
								'class' => '',
								'id' => 'by_gender_male_upper_limit',
								'size' => "3",
								'label' => false,
								'div' => false,
								'error' => false 
						) );
						?>
						</td>
						<td width="70" align="center"><?php
						
						echo $this->Form->input ( '', array (
								'name' => "data[LaboratoryParameter][0][by_gender_male_default_result]",
								'type' => 'text',
								'autocomplete' => 'off',
								'class' => '',
								'id' => 'by_gender_male_default_result',
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
								'name' => "data[LaboratoryParameter][0][by_gender_female]",
								'type' => 'checkbox',
								'class' => '',
								'id' => 'by_gender_female',
								'label' => false,
								'div' => false,
								'error' => false 
						) );
						?>
						</td>
						<td width="">Female</td>
						<td width="70" align="center"><?php
						
						echo $this->Form->input ( '', array (
								'name' => "data[LaboratoryParameter][0][by_gender_female_lower_limit]",
								'type' => 'text',
								'autocomplete' => 'off',
								'class' => '',
								'id' => 'by_gender_female_lower_limit',
								'size' => "3",
								'label' => false,
								'div' => false,
								'error' => false 
						) );
						?>
						</td>
						<td width="70" align="center"><?php
						
						echo $this->Form->input ( '', array (
								'name' => "data[LaboratoryParameter][0][by_gender_female_upper_limit]",
								'type' => 'text',
								'autocomplete' => 'off',
								'class' => '',
								'id' => 'by_gender_female_upper_limit',
								'size' => "3",
								'label' => false,
								'div' => false,
								'error' => false 
						) );
						?>
						</td>
						<td width="70" align="center"><?php
						
						echo $this->Form->input ( '', array (
								'name' => "data[LaboratoryParameter][0][by_gender_female_default_result]",
								'type' => 'text',
								'autocomplete' => 'off',
								'class' => '',
								'id' => 'by_gender_female_default_result',
								'size' => "20",
								'label' => false,
								'div' => false,
								'error' => false 
						) );
						?>
						</td>
					</tr>
					<!--CHILD-->
					<tr>
						<td width="25"><?php
						
						echo $this->Form->input ( '', array (
								'name' => "data[LaboratoryParameter][0][by_gender_child]",
								'type' => 'checkbox',
								'class' => '',
								'id' => 'by_gender_fchild',
								'label' => false,
								'div' => false,
								'error' => false 
						) );
						?>
						</td>
						<td width="">Child</td>
						<td width="70" align="center"><?php
						
						echo $this->Form->input ( '', array (
								'name' => "data[LaboratoryParameter][0][by_gender_child_lower_limit]",
								'type' => 'text',
								'autocomplete' => 'off',
								'class' => '',
								'id' => 'by_gender_child_lower_limit',
								'size' => "3",
								'label' => false,
								'div' => false,
								'error' => false 
						) );
						?>
						</td>
						<td width="70" align="center"><?php
						
						echo $this->Form->input ( '', array (
								'name' => "data[LaboratoryParameter][0][by_gender_child_upper_limit]",
								'type' => 'text',
								'autocomplete' => 'off',
								'class' => '',
								'id' => 'by_gender_child_upper_limit',
								'size' => "3",
								'label' => false,
								'div' => false,
								'error' => false 
						) );
						?>
						</td>
						<td width="70" align="center"><?php
						
						echo $this->Form->input ( '', array (
								'name' => "data[LaboratoryParameter][0][by_gender_child_default_result]",
								'type' => 'text',
								'autocomplete' => 'off',
								'class' => '',
								'id' => 'by_gender_child_default_result',
								'size' => "20",
								'label' => false,
								'div' => false,
								'error' => false 
						) );
						?>
						</td>
					</tr>
					<!--CHILD-->
				</table>
			</div>
			<div style="display: none;" id="age-section_0">
				<table width="100%" cellpadding="0" cellspacing="0" border="0"
					style="border-top: 1px solid #3e474a;" id="addTrAge_0">
					<tr>
						<td height="25">&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td align="center">LL</td>
						<td align="center">UL</td>
						<td align="center">Default</td>
					</tr>
					<!--  age For Male  -->
					<tr>
						<td width="25"><?php
						
						echo $this->Form->input ( '', array (
								'name' => "data[LaboratoryParameter][0][by_age_less_years]",
								'type' => 'checkbox',
								'class' => '',
								'id' => 'by_age_less_years',
								'size' => "3",
								'label' => false,
								'div' => false,
								'error' => false 
						) );
						?>
						</td>
						<td width="90" align="left"><?php echo __("Less Than For Male");?></td>
						<td width="50"><?php
						
						echo $this->Form->input ( '', array (
								'name' => "data[LaboratoryParameter][0][by_age_num_less_years]",
								'type' => 'text',
								'autocomplete' => 'off',
								'class' => '',
								'id' => 'by_age_num_less_years',
								'size' => "3",
								'label' => false,
								'div' => false,
								'error' => false 
						) );
						?>
						</td>
						
						<td width="100"><?php
																										
							echo $this->Form->input ( '', array (
									//'selected' => $lab_value ['Laboratory'] ['by_age_days_less'],
									'options' => array('Day(s)'=>'Day(s)','Month(s)'=>'Month(s)','Year(s)'=>'Year(s)'),
									'name' => "data[LaboratoryParameter][0][by_age_days_less]",
									'class' => 'textBoxExpnd',
									'id' => "by_age_days_less",
									'label' => false,
									'div' => false,
									'error' => false 
							) );
							?></td>
						<td width="70" align="center"><?php
						
						echo $this->Form->input ( '', array (
								'name' => "data[LaboratoryParameter][0][by_age_num_less_years_lower_limit]",
								'type' => 'text',
								'autocomplete' => 'off',
								'class' => '',
								'id' => 'by_age_num_less_years_lower_limit',
								'size' => "3",
								'label' => false,
								'div' => false,
								'error' => false 
						) );
						?>
						</td>
						<td width="70" align="center"><?php
						
						echo $this->Form->input ( '', array (
								'name' => "data[LaboratoryParameter][0][by_age_num_less_years_upper_limit]",
								'type' => 'text',
								'autocomplete' => 'off',
								'class' => '',
								'id' => 'by_age_num_less_years_upper_limit',
								'size' => "3",
								'label' => false,
								'div' => false,
								'error' => false 
						) );
						?>
						</td>
						<td width="70" align="center"><?php
						
						echo $this->Form->input ( '', array (
								'name' => "data[LaboratoryParameter][0][by_age_num_less_years_default_result]",
								'type' => 'text',
								'autocomplete' => 'off',
								'class' => '',
								'id' => 'by_age_num_less_years_default_result',
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
								'name' => "data[LaboratoryParameter][0][by_age_more_years]",
								'type' => 'checkbox',
								'class' => '',
								'id' => 'by_age_more_years',
								'label' => false,
								'div' => false,
								'error' => false 
						) );
						?>
						</td>
						<td width="55" align="left">More Than For Male</td>
						<td width="50"><?php
						
						echo $this->Form->input ( '', array (
								'name' => "data[LaboratoryParameter][0][by_age_num_more_years]",
								'type' => 'text',
								'autocomplete' => 'off',
								'class' => '',
								'id' => 'by_age_num_more_years',
								'size' => "3",
								'label' => false,
								'div' => false,
								'error' => false 
						) );
						?>
						</td>
						<td width="100">
						<?php echo $this->Form->input ( '', array (
									//'selected' => $lab_value ['Laboratory'] ['by_age_days_less'],
									'options' => array('Day(s)'=>'Day(s)','Month(s)'=>'Month(s)','Year(s)'=>'Year(s)'),
									'name' => "data[LaboratoryParameter][0][by_age_days_more]",
									'class' => 'textBoxExpnd',
									'id' => "by_age_days_more",
									'label' => false,
									'div' => false,
									'error' => false 
							) );?>
						</td>
						<td width="70" align="center"><?php
						
						echo $this->Form->input ( '', array (
								'name' => "data[LaboratoryParameter][0][by_age_num_gret_years_lower_limit]",
								'type' => 'text',
								'autocomplete' => 'off',
								'class' => '',
								'id' => 'by_age_num_gret_years_lower_limit',
								'size' => "3",
								'label' => false,
								'div' => false,
								'error' => false 
						) );
						?>
						</td>
						<td width="70" align="center"><?php
						
						echo $this->Form->input ( '', array (
								'name' => "data[LaboratoryParameter][0][by_age_num_gret_years_upper_limit]",
								'type' => 'text',
								'autocomplete' => 'off',
								'class' => '',
								'id' => 'by_age_num_gret_years_upper_limit',
								'size' => "3",
								'label' => false,
								'div' => false,
								'error' => false 
						) );
						?>
						</td>
						<td width="70" align="center"><?php
						
						echo $this->Form->input ( '', array (
								'name' => "data[LaboratoryParameter][0][by_age_num_gret_years_default_result]",
								'type' => 'text',
								'autocomplete' => 'off',
								'class' => '',
								'id' => 'by_age_num_gret_years_default_result',
								'size' => "20",
								'label' => false,
								'div' => false,
								'error' => false 
						) );
						?>
						</td>
					</tr>
					<!--  End Age For Male -->
					<!--  AGE for Female -->
					<tr>
						<td width="25"><?php
						
						echo $this->Form->input ( '', array (
								'name' => "data[LaboratoryParameter][0][by_age_less_years_female]",
								'type' => 'checkbox',
								'class' => '',
								'id' => 'by_age_less_years_female',
								'size' => "3",
								'label' => false,
								'div' => false,
								'error' => false 
						) );
						?>
						</td>
						<td width="105" align="left">Less Than For Female</td>
						<td width="50"><?php
						
						echo $this->Form->input ( '', array (
								'name' => "data[LaboratoryParameter][0][by_age_num_less_years_female]",
								'type' => 'text',
								'autocomplete' => 'off',
								'class' => '',
								'id' => 'by_age_num_less_years_female',
								'size' => "3",
								'label' => false,
								'div' => false,
								'error' => false 
						) );
						?>
						</td>
						<td width="100">
						<?php echo $this->Form->input ( '', array (
									//'selected' => $lab_value ['Laboratory'] ['by_age_days_less'],
									'options' => array('Day(s)'=>'Day(s)','Month(s)'=>'Month(s)','Year(s)'=>'Year(s)'),
									'name' => "data[LaboratoryParameter][0][by_age_days_less_female]",
									'class' => 'textBoxExpnd',
									'id' => "by_age_days_less_female",
									'label' => false,
									'div' => false,
									'error' => false 
							) );?>
						</td>
						<td width="70" align="center"><?php
						
						echo $this->Form->input ( '', array (
								'name' => "data[LaboratoryParameter][0][by_age_num_less_years_lower_limit_female]",
								'type' => 'text',
								'autocomplete' => 'off',
								'class' => '',
								'id' => 'by_age_num_less_years_lower_limit_female',
								'size' => "3",
								'label' => false,
								'div' => false,
								'error' => false 
						) );
						?>
						</td>
						<td width="70" align="center"><?php
						
						echo $this->Form->input ( '', array (
								'name' => "data[LaboratoryParameter][0][by_age_num_less_years_upper_limit_female]",
								'type' => 'text',
								'autocomplete' => 'off',
								'class' => '',
								'id' => 'by_age_num_less_years_upper_limit_female',
								'size' => "3",
								'label' => false,
								'div' => false,
								'error' => false 
						) );
						?>
						</td>
						<td width="70" align="center"><?php
						
						echo $this->Form->input ( '', array (
								'name' => "data[LaboratoryParameter][0][by_age_num_less_years_default_result_female]",
								'type' => 'text',
								'autocomplete' => 'off',
								'class' => '',
								'id' => 'by_age_num_less_years_default_result_female',
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
								'name' => "data[LaboratoryParameter][0][by_age_more_years_female]",
								'type' => 'checkbox',
								'class' => '',
								'id' => 'by_age_more_years_female',
								'label' => false,
								'div' => false,
								'error' => false 
						) );
						?>
						</td>
						<td width="55" align="left">More Than For Female</td>
						<td width="50"><?php
						
						echo $this->Form->input ( '', array (
								'name' => "data[LaboratoryParameter][0][by_age_num_more_years_female]",
								'type' => 'text',
								'autocomplete' => 'off',
								'class' => '',
								'id' => 'by_age_num_more_years_female',
								'size' => "3",
								'label' => false,
								'div' => false,
								'error' => false 
						) );
						?>
						</td>
						<td width="100">
						<?php echo $this->Form->input ( '', array (
									//'selected' => $lab_value ['Laboratory'] ['by_age_days_less'],
									'options' => array('Day(s)'=>'Day(s)','Month(s)'=>'Month(s)','Year(s)'=>'Year(s)'),
									'name' => "data[LaboratoryParameter][0][by_age_days_more_female]",
									'class' => 'textBoxExpnd',
									'id' => "by_age_days_more_female",
									'label' => false,
									'div' => false,
									'error' => false 
							) );?>
						</td>
						<td width="70" align="center"><?php
						
						echo $this->Form->input ( '', array (
								'name' => "data[LaboratoryParameter][0][by_age_num_gret_years_lower_limit_female]",
								'type' => 'text',
								'autocomplete' => 'off',
								'class' => '',
								'id' => 'by_age_num_gret_years_lower_limit_female',
								'size' => "3",
								'label' => false,
								'div' => false,
								'error' => false 
						) );
						?>
						</td>
						<td width="70" align="center"><?php
						
						echo $this->Form->input ( '', array (
								'name' => "data[LaboratoryParameter][0][by_age_num_gret_years_upper_limit_female]",
								'type' => 'text',
								'autocomplete' => 'off',
								'class' => '',
								'id' => 'by_age_num_gret_years_upper_limit_female',
								'size' => "3",
								'label' => false,
								'div' => false,
								'error' => false 
						) );
						?>
						</td>
						<td width="70" align="center"><?php
						
						echo $this->Form->input ( '', array (
								'name' => "data[LaboratoryParameter][0][by_age_num_gret_years_default_result_female]",
								'type' => 'text',
								'autocomplete' => 'off',
								'class' => '',
								'id' => 'by_age_num_gret_years_default_result_female',
								'size' => "20",
								'label' => false,
								'div' => false,
								'error' => false 
						) );
						?>
						</td>
					</tr>
					<!-- End for Female -->
					
					<tr>
						<td width="25"><?php
						
						echo $this->Form->input ( '', array (
								'name' => "data[LaboratoryParameter][0][by_age_between_years]",
								'type' => 'checkbox',
								'class' => '',
								'id' => 'by_age_between_years',
								'label' => false,
								'div' => false,
								'error' => false 
						) );
						?>
						</td>
						<td width="55" align="left">Between
						<?php
																										
																								
							echo $this->Form->input ( '', array (
									//'selected' => $lab_value ['Laboratory'] ['by_age_sex'],
									'options' => array('Male'=>'Male','Female'=>'Female'),
									'name' => "data[LaboratoryParameter][0][by_age_sex][0]",
									'class' => 'textBoxExpnd',
									'id' => "by_age_sex",
									'label' => false,
									'div' => false,
									'error' => false 
							) );
							?>
							
							</td>
						<td width="62" colspan=""><?php
						
						echo $this->Form->input ( '', array (
								'name' => "data[LaboratoryParameter][0][by_age_between_num_less_years][0]",
								'type' => 'text',
								'autocomplete' => 'off',
								'class' => '',
								'id' => 'by_age_between_num_less_years',
								'size' => "1",
								'label' => false,
								'div' => false,
								'error' => false 
						) );
						?> -
							<?php
							
							echo $this->Form->input ( '', array (
									'name' => "data[LaboratoryParameter][0][by_age_between_num_gret_years][0]",
									'type' => 'text',
									'autocomplete' => 'off',
									'class' => '',
									'id' => 'by_age_between_num_gret_years',
									'size' => "1",
									'label' => false,
									'div' => false,
									'error' => false 
							) );
							?>
							</td>
							<td width="100">
						<?php echo $this->Form->input ( '', array (
									//'selected' => $lab_value ['Laboratory'] ['by_age_days_less'],
									'options' => array('Day(s)'=>'Day(s)','Month(s)'=>'Month(s)','Year(s)'=>'Year(s)'),
									'name' => "data[LaboratoryParameter][0][by_age_days_between][0]",
									'class' => 'textBoxExpnd',
									'id' => "by_age_days_between",
									'label' => false,
									'div' => false,
									'error' => false 
							) );?>
						</td>
						<td width="70" align="center"><?php
						
						echo $this->Form->input ( '', array (
								'name' => "data[LaboratoryParameter][0][by_age_between_years_lower_limit][0]",
								'type' => 'text',
								'autocomplete' => 'off',
								'class' => '',
								'id' => 'by_age_between_years_lower_limit',
								'size' => "3",
								'label' => false,
								'div' => false,
								'error' => false 
						) );
						?>
						</td>
						<td width="70" align="center"><?php
						
						echo $this->Form->input ( '', array (
								'name' => "data[LaboratoryParameter][0][by_age_between_years_upper_limit][0]",
								'type' => 'text',
								'autocomplete' => 'off',
								'class' => '',
								'id' => 'by_age_between_years_upper_limit',
								'size' => "3",
								'label' => false,
								'div' => false,
								'error' => false 
						) );
						?>
						</td>
						<td width="70" align="center"><?php
						
						echo $this->Form->input ( '', array (
								'name' => "data[LaboratoryParameter][0][by_age_between_years_default_result][0]",
								'type' => 'text',
								'autocomplete' => 'off',
								'class' => '',
								'id' => 'by_age_between_years_default_result',
								'size' => "20",
								'label' => false,
								'div' => false,
								'error' => false 
						) );
						?>
						</td>
						<td width="70"><?php echo $this->Html->image('icons/plus_6.png', array('id'=>'addButtonAge_0','title'=>'Add','class'=>'addMoreAge'));?></td>
					</tr>
				</table>
			</div> <!-- Pawan By range start -->
			<div style="display: none;" id="range_positive_negative_section_0">
				<table width="100%" cellpadding="0" cellspacing="0" border="0"
					style="border-top: 1px solid #3e474a;" id="addTrRange_0">
					<tr>
						<td height="25">&nbsp;</td>
						<td>&nbsp;</td>

						<td align="left">Value</td>
						<td align="left">Interpretation</td>
					</tr>
					<tr>
						<td width="25"><?php
						
						echo $this->Form->input ( '', array (
								'name' => "data[LaboratoryParameter][0][by_range_less_than]",
								'type' => 'checkbox',
								'class' => '',
								'id' => 'by_range_less_than',
								'label' => false,
								'div' => false,
								'error' => false 
						) );
						?>
						</td>
						<td width="25">Less Than</td>

						<td width="70" align="left"><?php
						
						echo $this->Form->input ( '', array (
								'name' => "data[LaboratoryParameter][0][by_range_less_than_limit]",
								'type' => 'text',
								'autocomplete' => 'off',
								'class' => '',
								'id' => 'by_range_less_than_limit',
								'size' => "3",
								'label' => false,
								'div' => false,
								'error' => false 
						) );
						?>
						</td>
						<td width="70" align="left"><?php
						
						echo $this->Form->input ( '', array (
								'name' => "data[LaboratoryParameter][0][by_range_less_than_interpretation]",
								'type' => 'text',
								'autocomplete' => 'off',
								'class' => '',
								'id' => 'by_range_less_than_interpretation',
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
								'name' => "data[LaboratoryParameter][0][by_range_greater_than]",
								'type' => 'checkbox',
								'class' => '',
								'id' => 'by_range_greater_than',
								'label' => false,
								'div' => false,
								'error' => false 
						) );
						?>
						</td>
						<td width="">More Than</td>
						<td width="70" align="left"><?php
						
						echo $this->Form->input ( '', array (
								'name' => "data[LaboratoryParameter][0][by_range_greater_than_limit]",
								'type' => 'text',
								'autocomplete' => 'off',
								'class' => '',
								'id' => 'by_range_greater_than_limit',
								'size' => "3",
								'label' => false,
								'div' => false,
								'error' => false 
						) );
						?>
						</td>
						<td width="70" align="left"><?php
						
						echo $this->Form->input ( '', array (
								'name' => "data[LaboratoryParameter][0][by_range_greater_than_interpretation]",
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

					<tr>
						<td width="25"><?php
						
						echo $this->Form->input ( '', array (
								'name' => "data[LaboratoryParameter][0][by_range_between]",
								'type' => 'checkbox',
								'class' => '',
								'id' => 'by_range_between',
								'label' => false,
								'div' => false,
								'error' => false 
						) );
						?>
						</td>
						<td width="">Between</td>
						<td width="70" align="left"><?php
						
						echo $this->Form->input ( '', array (
								'name' => "data[LaboratoryParameter][0][by_range_between_lower_limit][0]",
								'type' => 'text',
								'autocomplete' => 'off',
								'class' => '',
								'id' => 'by_range_between_lower_limit_0',
								'size' => "3",
								'label' => false,
								'div' => false,
								'error' => false 
						) );
						?>
						 - <?php
							
							echo $this->Form->input ( '', array (
									'name' => "data[LaboratoryParameter][0][by_range_between_upper_limit][0]",
									'type' => 'text',
									'autocomplete' => 'off',
									'class' => '',
									'id' => 'by_range_between_upper_limit_0',
									'size' => "3",
									'label' => false,
									'div' => false,
									'error' => false 
							) );
							?>
						</td>
						<td width="70" align="left"><?php
						
						echo $this->Form->input ( '', array (
								'name' => "data[LaboratoryParameter][0][by_range_between_interpretation][0]",
								'type' => 'text',
								'autocomplete' => 'off',
								'class' => '',
								'id' => 'by_range_between_interpretation_0',
								'size' => "20",
								'label' => false,
								'div' => false,
								'error' => false 
						) );
						?>
						</td>
						<td width="70"><?php echo $this->Html->image('icons/plus_6.png', array('id'=>'addButtonRange_0','title'=>'Add','class'=>'addMoreRange'));?></td>
					</tr>
				</table>
			</div> <!-- Pawan By range end -->
		</td>
		<td valign="top"><?php
		
		echo $this->Form->input ( '', array (
				'name' => "data[LaboratoryParameter][0][unit_txt]",
				'class' => 'name_Ucms',
				'id' => 'unitDisplay_Frst',
				'label' => false,
				'div' => false,
				'error' => false,
				'value' => '' 
		) );
		echo $this->Form->hidden ( '', array (
				'id' => 'unit_Frst',
				'name' => "data[LaboratoryParameter][0][unit]",
				'value' => '' 
		) );
		?>
		</td>

		<td valign="top" align="center" style="padding-top: 15px;">&nbsp;</td>
	</tr>

</table>
<p class="ht5"></p>
<table width="100%" cellpadding="0" cellspacing="0" border="0"
	align="center" class="hideForHistopathology">
	<tr>
		<td width="50%" align="left"><?php
		echo $this->Form->Button ( __ ( 'Add More Category' ), array (
				'type' => 'button',
				'label' => false,
				'div' => false,
				'error' => false,
				'escape' => false,
				'class' => 'blueBtn ',
				'id' => 'addButton' 
		) );
		?>
			<div align="center" id='busy-indicator' style="display: none;">
				&nbsp;
				<?php echo $this->Html->image('indicator.gif', array()); ?>
			</div></td>
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
				'error' => false 
		) );
		// echo $this->Form->submit(__('Save & Add More Category'), array('id'=>'add-more','title'=>'Save and Add More Category','escape' => false,'class' => 'blueBtn ','label' => false,'div' => false,'error'=>false));
		echo $this->Html->link ( __ ( 'Cancel' ), array (
				'action' => 'index' 
		), array (
				'escape' => false,
				'class' => 'grayBtn ' 
		) );
		?>
		</td>
	</tr>
</table>
<?php echo $this->Form->end();?>
<!-- EOF lab Forms -->


<script language="javascript"> 
        
		$(document).ready(function(){


			var getlab=$('#lab_type').val();		
			if(getlab=='2'){
				$('.hideForHistopathology').hide();	
				$('.showForHistopathology').show();	
				$('.showForMicroBiology').hide();							
			}else if(getlab == '3'){ // for microBiology
				$('.showForMicroBiology').show();	
				$('.hideForHistopathology').hide();	
				$('.showForHistopathology').hide();		
			}else {
				$('.hideForHistopathology').show();	
				$('.showForHistopathology').hide();
				$('.showForMicroBiology').hide();		
			}
			
			getServiceGroup();
			 var counter = 1; 
			 var field = 1;
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
					}else{
						$('#parameter_text_'+currTextPos[1]).fadeOut(400);						
						$('#gender-'+currTextPos[1]).attr('checked','checked');						
						$('#age-section_'+currTextPos[1]).fadeOut('fast');
						$('#gender-section_'+currTextPos[1]).delay(400).fadeIn(400);
						$('#radioGroup_'+currTextPos[1]).delay(400).fadeIn(400);							
					}
				});
				//show/hide age or gender wise
				 
					$('.sort-by').live('click',function()
					{ 	
						var currEle = $(this).attr('id');						 
						var currPos  = currEle.split("-");						 	
						if(currPos[0]=='gender'){
							$('#type_'+currPos[1]).fadeIn(400);
							$('#age-section_'+currPos[1]).fadeOut(400);
							$('#range_positive_negative_section_'+currPos[1]).fadeOut(400);
							$('#gender-section_'+currPos[1]).delay(400).fadeIn(400);
						}else if(currPos[0]=='age'){
							$('#type_'+currPos[1]).fadeIn(400);
							$('#gender-section_'+currPos[1]).fadeOut(400);
							$('#range_positive_negative_section_'+currPos[1]).fadeOut(400);
							$('#age-section_'+currPos[1]).delay(400).fadeIn(400);
						}else if(currPos[0]=='range_positive_negative'){
							$('#type_'+currPos[1]).fadeOut(400);
							$('#age-section_'+currPos[1]).fadeOut(400);
							$('#gender-section_'+currPos[1]).fadeOut(400);
							$('#range_positive_negative_section_'+currPos[1]).delay(400).fadeIn(400);
						}					
					 
					});
				//EOF age/gender
	 
		   
		    $("#addButton").click(function () {		 
		    	var newCostDiv = $(document.createElement('tr'))
			     .attr("id", 'TestGroup' + counter);
				
		    	$.ajax({
					  url: "<?php echo $this->Html->url(array("controller" => 'laboratories', "action" => "ajax_add_block", "admin" => false)); ?>",
			  data:{"counter":counter,"radioId":radioId,"field":field},
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
		field++;
		radioId = radioId+2  ;
		if(counter > 1) $('#removeButton').show('slow');
	});

	$(".CategoryName").live("blur",function(){
		id = $(this).attr('id');
		newId = id.split("_");
		$("#CategoryValue_"+newId[1]).val($(this).val());
		$("#CateName_"+newId[1]).val($(this).val());
		//$("#sortOrder_"+newId[1]).val($(this).val());
	});
	$(".sort").live("blur",function(){
		id = $(this).attr('id');
		newId = id.split("_");
		$("#categorySort_"+newId[1]).val($(this).val());
		$("#sortCategory_"+newId[1]).val($(this).val());
	});

    $(".addMore").live("click",function(){
    	id = $(this).attr('id');
		newId = id.split("_");
		CategoryValue = $("#CategoryValue_"+newId[1]).val();
		categorySort = $("#categorySort_"+newId[1]).val();
		sortCategory = $("#sortCategory_"+newId[1]).val();
		hideCatCheckBox = 'hideCatCheckBox';
    	if($("#CategoryValue_"+newId[1]) != '')
        {
	    	var newCostDiv = $(document.createElement('tr')).attr("id", 'TestGroup' + counter);
			$.ajax({
				  url: "<?php echo $this->Html->url(array("controller" => 'laboratories', "action" => "ajax_add_block", "admin" => false)); ?>",
				  data:{"counter":counter,"radioId":radioId,"CategoryValue":CategoryValue,"categorySort":categorySort,"hideCatCheckBox":hideCatCheckBox,"sortCategory":sortCategory},
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
        }  					 
	});
	
     $(".removeBtn").live('click',function () {
    	 	if(confirm('Are You Sure?')){
    			readyToRem = $(this).attr('id');						 
    			readyToRemPos  = readyToRem.split("_");				 
	        	$("#TestGroup" + readyToRemPos[1]).remove();
    	 	}else{
				return false;
    	 	}					
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
 					  	data= $.parseJSON(data);
 					  	$("#tarifflist").append( "<option value=''>Select Service</option>" );
 					  	if(data != ''){
 					  		$('#list-content').show('slow'); 
 							$.each(data, function(val, text) {
 							    $("#tarifflist").append( "<option value='"+val+"'>"+text+"</option>" );
 							});
 							$('#tarifflist').attr('disabled', '');	
 							
		
 							$("#lab_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","TariffList",'id',"name","admin" => false,"plugin"=>false)); ?>"
		 							+"/service_category_id="+$('#service_group_id').val(), {
 								width: 250,
 								selectFirst: true,
 								valueSelected:true,
 								showNoId:true,
 								loadId : 'lab_name,tarifflist',
 								
 							});
 					  	}else{
 							$('#lsit-content').hide('fast');
 					  	}		
 				  }
 		});
 	}
 	//EOF pankaj
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
 
	// lab unit Ucums table
	$('.name_Ucms')
	.live('focus',function() { 
	$(this).autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","Ucums",'code',"display_name",'null',"admin" => false,"plugin"=>false)); ?>",
			{
			width: 250,
			selectFirst: true,
			valueSelected:true,
			loadId : $(this).attr('id')+','+$(this).attr('id').replace("Display_","_")
			});

	});
	//-----------------------------------------------------------------------------------------------------------------------------------	
		
		$('.lab_type').change(function(){
			var getlab=$('#lab_type').val();		
			if(getlab=='2'){
				$('.hideForHistopathology').hide();	
				$('.showForHistopathology').show();	
				$('.showForMicroBiology').hide();							
			}else if(getlab == '3'){ // for microBiology
				$('.showForMicroBiology').show();	
				$('.hideForHistopathology').hide();	
				$('.showForHistopathology').hide();		
			}else {
				$('.hideForHistopathology').show();	
				$('.showForHistopathology').hide();
				$('.showForMicroBiology').hide();		
			}			
			
		});	
		$('#add-morehistopathology').click(function(){
  			$('#whichActHistopathology').val($(this).attr('id'));
	  	});
		 $("#addButtonHistopathology").click(function () {		 
			 var cureentId=$(".getRow").last().attr('id');
				// alert(cureentId);
				 var getNo=cureentId.split("_");
			//	 alert(getNo['1'])
				 var counter=parseInt(getNo['1']);
				 counter++;
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
				//	radioId = radioId+2  ;
					if(counter > 1) $('#removeButtonHistopathology_').show('slow');
				});
			 $(".removeBtnHistopathology").live('click',function () {
		    	 	if(confirm('Are You Sure?')){
		    			readyToRem = $(this).attr('id');			 
		    			readyToRemPos  = readyToRem.split("_");						 
			        	$("#TestGroupHistopathology_" + readyToRemPos[1]).remove();
		    	 	}					
			  });
			 
			
	 

	$(".category").live("click",function(){
		idd = $(this).attr('id');
		newId = idd.split("_");
		if($(this).is(':checked',true)){
			$("#CategoryName_"+newId[1]).show();
			$("span#sort_"+newId[1]).show();
			$("#addMore_"+newId[1]).show();
			$("input#sort_"+newId[1]).show();
		}
		else{
			$("#CategoryName_"+newId[1]).hide();
			$("#addMore_"+newId[1]).hide();
			$("span#sort_"+newId[1]).hide();
			$("input#sort_"+newId[1]).hide();
		}
	});

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

						
		var counter = 1;
		//$('.addMoreRange').click(function(){
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
		//$(document).on('click','.removeButton', function() {
			currentId=$(this).attr('id');
			splitedId=currentId.split('_');
			ID=splitedId['1'];
			$("#newBrowseRow_"+ID).remove();
			 
	 	});
	

 	var counterAge = 1;
	//$('.addMoreRange').click(function(){
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
	
 	//BOF Microbiology --Gaurav
 	var microBiologyCounter = parseInt('<?php echo $microBiologyCounter;?>');
	$('.addMicroBiology').live('click',function(){
		var rowCount = $('#TestGroupMicroBiology tr').length;
		if(rowCount == 2)
			$('.removeMicroBiology:last').show();
		microBiologyCounter++;
		$(this).closest("tr")
		.after($('<tr>').attr({'id':'TestGroupMicroBiology_'+microBiologyCounter,'class':'getRow'})
			.append($('<td>').text(microBiologyCounter))
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
	
	$('#pharmacyAutoComplete').autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","PharmacyItem",'id',"name",'null',"admin" => false,"plugin"=>false)); ?>",{
			width: 250,
			selectFirst: true,
			valueSelected:true,
			loadId : 'pharmacyAutoComplete,pharmacyAutoCompleteId'
		});
	

	var microBiologyCounterMeds  = 1
	$('.addMicroBiologyMeds').live('click',function(){
		var rowCount = $('#TestGroupMicroBiologyMeds tr').length;
		if(rowCount == 3)
			$('.removeMicroBiologyMeds:last').show();
		microBiologyCounterMeds++;
		$(this).closest("tr")
		.after($('<tr>').attr({'id':'TestGroupMicroBiologyMeds_'+microBiologyCounterMeds,'class':'getRow'})
			.append($('<td>').text(microBiologyCounterMeds))
			.append($('<td>').append($('<input>').attr({'type':'text','name':'data[Laboratory][medication]['+microBiologyCounterMeds+'][name]','id':'pharmacyAutoComplete'+microBiologyCounterMeds}))
					.append($('<input>').attr({'type':'hidden','name' : 'data[Laboratory][medication]['+microBiologyCounterMeds+'][pharmacy_item_id]' , 'id' : 'pharmacyAutoCompleteId'+microBiologyCounterMeds })))
    		.append($('<td>').append($('<select>').attr({'name':'data[Laboratory][medication]['+microBiologyCounterMeds+'][kuchToh]','id':'selectType'+microBiologyCounterMeds}).css({'width':'68px'})))
    		.append($('<td>').append($('<img>').attr({'src':"<?php echo $this->webroot ?>theme/Black/img/icons/close-icon.png",'class':'removeMicroBiologyMeds',
        				'id':'removeMicroBiologyMeds_'+microBiologyCounterMeds,'title':'Remove'}))
					.append($('<img>').attr({'src':"<?php echo $this->webroot ?>theme/Black/img/icons/plus_6.png",'class':'addMicroBiologyMeds','id':'addMicroBiologyMeds_'+microBiologyCounterMeds,
						'title':'Add'})))
			)
			$(this).hide();	
		$('#pharmacyAutoComplete'+microBiologyCounterMeds).autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","PharmacyItem",'id',"name",'null',"admin" => false,"plugin"=>false)); ?>",{
			width: 250,
			selectFirst: true,
			valueSelected:true,
			loadId : 'pharmacyAutoComplete'+microBiologyCounterMeds+',pharmacyAutoCompleteId'+microBiologyCounterMeds
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
	
});
var select = $.parseJSON('<?php echo json_encode(Configure::read('sensitivity') )?>');

	$("#specimen_collection_type").change(function(){
		var text = $("#specimen_collection_type option:selected").text();
		if(text == 'OTHER'){
			$("#otherOptionTextBox").show();
		}else{
			$("#otherOptionTextBox").hide();
		}	
	});

 </script>
