<style>
.tabularForm th{ border:none!important;}
</style>
<?php 
echo $this->Html->script(array('jquery-1.5.1.min'));
echo $this->Html->css(array('datePicker.css','jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','internal_style.css'));
//echo $this->Html->css(array('home-slider.css','ibox.css','jquery.fancybox-1.3.4.css','jquery.autocomplete.css'));

?>

<div class="inner_title">
	<h3>
		<?php echo __('Merge EMPI', true); ?>
	</h3>
	<?php echo $this->Form->create('Person',array('url'=>array('controller'=>'persons','action'=>'mergeEmpi',$data),'id'=>'mergeEmpiRecord',
			'inputDefaults' => array('label' => false, 'div' => false, 'error' => false	)));
	?>
	<table align="right">
			<tr>
				 <td>
					<?php echo $this->Form->input(__('Smart Merge'), array('type'=>'button','id'=>'smartMerge','class'=>'blueBtn')); ?>
				</td>
				<td>
				 
					<?php echo $this->Form->submit(__('Merge Manually'), array('escape' => false,'class'=>'blueBtn')); ?>
				</td>
			</tr>
		</table>

<div>&nbsp;</div>
</div>
<div>&nbsp;</div>
<div class="clr ht5"></div>
<table width="100%" cellpadding="0" cellspacing="1" border="0">
<?php for($i=0;$i<=count($personRecord);$i++){  ?>
	<tr><?php if(!empty($personRecord[$i]['Person']['initial_id'])){?>
		<td width="50%" valign="top">
        <table width="100%" cellpadding="0" cellspacing="1" border="0"
				class="tabularForm" style="float:left;">
				<tr>
					<th colspan="6" valign="top"><?php echo __('Patient Information', true); ?></th>
				</tr>
				<tr>
					<td width="19%" valign="middle" class="" id="boxSpace"><?php echo __("Prefix");?>
						
					</td>
					<td width="30%"><table width="100%" cellpadding="0" cellspacing="0"
							border="0">
							<tr>
								<td><?php echo __($personRecord[$i]['Initial']['name']); ?>
								</td>
								<td></td>
							</tr>
						</table></td>
					<td><?php echo $this->Form->checkbox('initial_id', array('hiddenField'=>false,'value'=>$personRecord[$i]['Person']['initial_id']==''?'#':$personRecord[$i]['Person']['initial_id'],'class' => 'selChk initial_id','id' => 'initial_id_'.$i)); ?>
					</td>
					<td colspan="3">&nbsp;</td>
				</tr>
				<tr>
					<td width="19%" valign="middle" class="" id="boxSpace"><?php echo __("First Name");?>
						
					</td>
					<td width="30%"><table width="100%" cellpadding="0" cellspacing="0"
							border="0">
							<tr>

								<td><?php echo __($personRecord[$i]['Person']['first_name']); ?>
								</td>

							</tr>
						</table></td>
					<td width=""><?php echo $this->Form->checkbox('first_name', array('hiddenField'=>false,'value'=>$personRecord[$i]['Person']['first_name']==''?'#':$personRecord[$i]['Person']['first_name'],'class' => 'selChk first_name','id' => 'first_name_'.$i)); ?>
					</td>
					<td valign="middle" class="" id="boxSpace"><?php echo __('Middle Initial');?>
					</td>
					<td><?php echo __($personRecord[$i]['Person']['middle_name']); ?>
					</td>
					<td><?php echo $this->Form->checkbox('middle_name', array('hiddenField'=>false,'value'=>$personRecord[$i]['Person']['middle_name']==''?'#':$personRecord[$i]['Person']['middle_name'],'class' => 'selChk middle_name','id' => 'middle_name_'.$i)); ?>
					</td>
				</tr>
				<tr>
					<td valign="middle" class="" id="boxSpace"><?php echo __('Last Name');?>
						
					</td>
					<td><?php echo __($personRecord[$i]['Person']['last_name']); ?>
					</td>
					<td><?php echo $this->Form->checkbox('last_name', array('hiddenField'=>false,'value'=>$personRecord[$i]['Person']['last_name']==''?'#':$personRecord[$i]['Person']['last_name'],'class' => 'selChk last_name','id' => 'last_name_'.$i)); ?>
					</td>
					<td width="19%" class="" id="boxSpace"><?php echo __('Name Type');?>
					</td>
					<td width="30%"><?php echo __($personRecord[$i]['Person']['name_type']); ?>
					</td>
					<td><?php echo $this->Form->checkbox('name_type', array('hiddenField'=>false,'value'=>$personRecord[$i]['Person']['name_type']==''?'#':$personRecord[$i]['Person']['name_type'],'class' => 'selChk name_type','id' => 'name_type_'.$i)); ?>
					</td>
				</tr>
				<tr>
					<td valign="middle" class="" id="boxSpace"><?php echo __('Suffix');?>
					</td>
					<td><?php echo __($personRecord[$i]['Person']['suffix1']); ?>
					</td>
					<td><?php echo $this->Form->checkbox('suffix1', array('hiddenField'=>false,'value'=>$personRecord[$i]['Person']['suffix1']==''?'#':$personRecord[$i]['Person']['suffix1'],'class' => 'selChk suffix1','id' => 'suffix1_'.$i)); ?>
					</td>
					<td width="19%" class="" id="boxSpace"><?php echo __('Date of Birth');?>
						
					</td>
					<td width="30%"><?php echo __($personRecord[$i]['Person']['dob']);?>
					</td>
					<td><?php echo $this->Form->checkbox('dob', array('hiddenField'=>false,'value'=>$personRecord[$i]['Person']['dob']==''?'#':$personRecord[$i]['Person']['dob'],'class' => 'selChk dob','id' => 'dob_'.$i)); ?>
					</td>
				</tr>
				<tr>
					<td width="19%" class="" id="boxSpace"><?php echo __('Gender');?> 
						
					</td>
					<td width="30%"><?php  echo __($personRecord[$i]['Person']['sex']);?>
					</td>
					<td><?php echo $this->Form->checkbox('sex', array('hiddenField'=>false,'value'=>$personRecord[$i]['Person']['sex']==''?'#':$personRecord[$i]['Person']['sex'],'class' => 'selChk sex','id' => 'sex_'.$i)); ?>
					</td>
					<td valign="middle" class="" id="boxSpace"><?php echo __('Marital Status');?>
					</td>
					<td><?php echo __($personRecord[$i]['Person']['maritail_status']);?>
					</td>
					<td><?php echo $this->Form->checkbox('maritail_status', array('hiddenField'=>false,'value'=>$personRecord[$i]['Person']['maritail_status']==''?'#':$personRecord[$i]['Person']['maritail_status'],'class' => 'selChk maritail_status','id' => 'maritail_status_'.$i)); ?>
					</td>
				</tr>
				<tr>
					<td class="" id="boxSpace">Patient's Photo</td>
					<td><?php echo 'upload_image'?></td>
					<td>&nbsp;</td>
					<td colspan="3"><?php //echo $this->Form->checkbox('maritail_status', array('hiddenField'=>false,'value'=>$personRecord[$i]['Person']['maritail_status'],'class' => 'selChk','id' => 'maritail_status_'.$i)); ?>
					</td>
				</tr>
				<tr>
					<td valign="middle" class="" id="boxSpace"><?php echo __('Blood Group');?>
					</td>
					<td><?php echo __($personRecord[$i]['Person']['blood_group']);?>
					</td>
					<td><?php echo $this->Form->checkbox('blood_group', array('hiddenField'=>false,'value'=>$personRecord[$i]['Person']['blood_group']==''?'#':$personRecord[$i]['Person']['blood_group'],'class' => 'selChk blood_group','id' => 'blood_group_'.$i)); ?>
					</td>
					<td valign="top" class="" id="boxSpace"><?php echo __('Allergies');?>
					</td>
					<td><?php echo __($personRecord[$i]['Person']['allergies']);?>
					</td>
					<td><?php echo $this->Form->checkbox('allergies', array('hiddenField'=>false,'value'=>$personRecord[$i]['Person']['allergies']==''?'#':$personRecord[$i]['Person']['allergies'],'class' => 'selChk allergies','id' => 'allergies_'.$i)); ?>
					</td>
				</tr>
				<tr>
					<td class=" " id="boxSpace" valign="top">Referral Doctor</td>
					<td><?php    echo __($personRecord[$i]['Person']['known_fam_physician']); ?>
					</td>
					<td><?php echo $this->Form->checkbox('known_fam_physician', array('hiddenField'=>false,'value'=>$personRecord[$i]['Person']['known_fam_physician']==''?'#':$personRecord[$i]['Person']['known_fam_physician'],'class' => 'selChk known_fam_physician','id' => 'known_fam_physician_'.$i)); ?>
					</td>
					<td valign="middle" class="" id="boxSpace">Consultant Name</td>
					<td><?php echo __($personRecord[$i]['Person']['consultant_id']); ?></td>
					<td><?php echo $this->Form->checkbox('consultant_id', array('hiddenField'=>false,'value'=>$personRecord[$i]['Person']['consultant_id']==''?'#':$personRecord[$i]['Person']['consultant_id'],'class' => 'selChk consultant_id','id' => 'consultant_id_'.$i)); ?>
					</td>
				</tr>
				<tr>
					<td valign="middle" class="" id="boxSpace"><?php echo __('SSN');?>
					</td>
					<td><?php echo __($personRecord[$i]['Person']['ssn_us']); ?>
					</td>
					<td><?php echo $this->Form->checkbox('ssn_us', array('hiddenField'=>false,'value'=>$personRecord[$i]['Person']['ssn_us']==''?'#':$personRecord[$i]['Person']['ssn_us'],'class' => 'selChk ssn_us','id' => 'ssn_us_'.$i)); ?>
					</td>
					<td class="" id="boxSpace"><?php echo __('ID Number/MRN');?></td>
					<td><?php echo __($personRecord[$i]['Person']['mrn_number']); ?>
					</td>
					<td><?php echo $this->Form->checkbox('mrn_number', array('hiddenField'=>false,'value'=>$personRecord[$i]['Person']['mrn_number']==''?'#':$personRecord[$i]['Person']['mrn_number'],'class' => 'selChk mrn_number','id' => 'mrn_number_'.$i)); ?>
					</td>
				</tr>
				<tr>
					<td valign="middle" class="" id="boxSpace"><?php echo __('Birth Order');?>
					</td>
					<td><?php echo __($personRecord[$i]['Person']['birth_order']); ?>
					</td>
					<td><?php echo $this->Form->checkbox('birth_order', array('hiddenField'=>false,'value'=>$personRecord[$i]['Person']['birth_order']==''?'#':$personRecord[$i]['Person']['birth_order'],'class' => 'selChk birth_order','id' => 'multiple_birth_indicator')); ?>
					</td>
					<td valign="middle" class="" id="boxSpace" width="20%"><?php echo __('Multiple Birth Indicator');?>
					</td>
					<td><?php echo __($personRecord[$i]['Person']['multiple_birth_indicator']); ?>
					</td>
					<td><?php echo $this->Form->checkbox('multiple_birth_indicator', array('hiddenField'=>false,'value'=>$personRecord[$i]['Person']['multiple_birth_indicator']==''?'#':$personRecord[$i]['Person']['multiple_birth_indicator'],'class' => 'selChk multiple_birth_indicator','id' => 'multiple_birth_indicator_'.$i)); ?>
					</td>
				</tr>
				<tr>
					<td valign="middle" class="" id="boxSpace"><?php echo __('Professional Suffix');?>
					</td>
					<td><?php echo __($personRecord[$i]['Person']['professional_suffix']); ?>
					</td>
					<td><?php echo $this->Form->checkbox('professional_suffix', array('hiddenField'=>false,'value'=>$personRecord[$i]['Person']['professional_suffix']==''?'#':$personRecord[$i]['Person']['professional_suffix'],'class' => 'selChk professional_suffix','id' => 'professional_suffix_'.$i)); ?>
					</td>
					<td colspan="4">&nbsp;</td>
				</tr>
				<tr>
					<th colspan="6"><?php echo __('Demographic', true); ?></th>
				</tr>
				<tr>
					<td width="19%" class="" id="boxSpace"><?php echo __('Ethnicity');?>
					</td>
					<!--Hispanic, Latino, American, African   -->
					<td width="30%"><?php echo __($personRecord[$i]['Person']['ethnicity']);?>
					</td>
					<td><?php echo $this->Form->checkbox('ethnicity', array('hiddenField'=>false,'value'=>$personRecord[$i]['Person']['ethnicity']==''?'#':$personRecord[$i]['Person']['ethnicity'],'class' => 'selChk ethnicity','id' => 'ethnicity_'.$i)); ?>
					</td>
					<td width="10%" class="" id="boxSpace"><?php echo __('Alternate Ethinicity');?>
					</td>
					<td width="30%"><?php echo __($personRecord[$i]['Person']['alt_ethinicity']);?>
					</td>
					<td><?php echo $this->Form->checkbox('alt_ethinicity', array('hiddenField'=>false,'value'=>$personRecord[$i]['Person']['alt_ethinicity']==''?'#':$personRecord[$i]['Person']['alt_ethinicity'],'class' => 'selChk alt_ethinicity','id' => 'alt_ethinicity_'.$i)); ?>
					</td>
				</tr>
				<tr>
					<td width="20%" class="" id="boxSpace"><?php echo __('Preferred Language');?>
					</td>
					<td width="30%"><?php echo __($personRecord[$i]['Person']['language']);?>
					</td>
					<td><?php echo $this->Form->checkbox('language', array('hiddenField'=>false,'value'=>$personRecord[$i]['Person']['language']==''?'#':$personRecord[$i]['Person']['language'],'class' => 'selChk language','id' => 'language_'.$i)); ?>
					</td>
					<td colspan="3"></td>
				</tr>
				<tr>
					<td width="19%" class="" id="boxSpace"><?php echo __('Race(s)');?>
					</td>
					<td width="30%"><?php echo __($personRecord[$i]['Person']['race']);?>
					</td>
					<td><?php echo $this->Form->checkbox('race', array('hiddenField'=>false,'value'=>$personRecord[$i]['Person']['race']==''?'#':$personRecord[$i]['Person']['race'],'class' => 'selChk race','id' => 'race_'.$i)); ?>
					</td>
					<td width="10%" class="" id="boxSpace"><?php echo __('Alternate Race');?>
					</td>
					<td width="30%"><?php echo __($personRecord[$i]['Person']['alt_race']);?>
					</td> 
					<td><?php echo $this->Form->checkbox('alt_race', array('hiddenField'=>false,'value'=>$personRecord[$i]['Person']['alt_race']==''?'#':$personRecord[$i]['Person']['alt_race'],'class' => 'selChk alt_race','id' => 'alt_race_'.$i)); ?>
					</td>
				</tr>
				<!-- prffred Communication -->
				<tr>
					<td width="19%" class="" id="boxSpace"><?php echo __('Preferred Communication');?>
					</td>
					<td width="30%"><?php echo __($personRecord[$i]['Person']['P_comm']); ?>
					</td>
					<td><?php echo $this->Form->checkbox('P_comm', array('hiddenField'=>false,'value'=>$personRecord[$i]['Person']['P_comm']==''?'#':$personRecord[$i]['Person']['P_comm'],'class' => 'selChk P_comm','id' => 'P_comm_'.$i)); ?>
					</td>
					<td colspan="3"></td>
				</tr>
				<!-- prffred Communication -->
				<tr>
					<td class="" id="boxSpace"><?php echo __('Religion');?>
					</td>
					<td><?php echo __($personRecord[$i]['Person']['religion']);?>
					</td>
					<td><?php echo $this->Form->checkbox('religion', array('hiddenField'=>false,'value'=>$personRecord[$i]['Person']['religion']==''?'#':$personRecord[$i]['Person']['religion'],'class' => 'selChk religion','id' => 'religion_'.$i)); ?>
					</td>
					<td colspan="3"></td>
				</tr>
				<tr>
					<th colspan="6"><?php echo __('Address Information One', true); ?>
					</th>
				</tr>
				<tr>
					<td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Address Line 1');?>
						
					</td>
					<td width="30%"><?php echo __($personRecord[$i]['Person']['plot_no']);?>
					</td>
					<td><?php echo $this->Form->checkbox('plot_no', array('hiddenField'=>false,'value'=>$personRecord[$i]['Person']['plot_no']==''?'#':$personRecord[$i]['Person']['plot_no'],'class' => 'selChk plot_no','id' => 'plot_no_'.$i)); ?>
					</td>
					<td width="19%" class="tdLabel" id="boxSpace"><?php echo('Address Line 2');?>
						
					</td>
					<td width="30%"><?php echo __($personRecord[$i]['Person']['landmark']);?>
					</td>
					<td><?php echo $this->Form->checkbox('landmark', array('hiddenField'=>false,'value'=>$personRecord[$i]['Person']['landmark']==''?'#':$personRecord[$i]['Person']['landmark'],'class' => 'selChk landmark','id' => 'landmark_'.$i)); ?>
					</td>
				</tr>
				<tr>
					<td class="tdLabel" id="boxSpace" valign="top"><?php echo __('Zip');?>
						
					</td>
					<td valign="top"><?php echo __($personRecord[$i]['Person']['pin_code']);?>
					</td>
					<td><?php echo $this->Form->checkbox('pin_code', array('hiddenField'=>false,'value'=>$personRecord[$i]['Person']['pin_code']==''?'#':$personRecord[$i]['Person']['pin_code'],'class' => 'selChk pin_code','id' => 'pin_code_'.$i)); ?>
					</td>
					<td class="tdLabel" id="boxSpace"><?php echo __('Zip 4');?>
					</td>
					<td><?php echo __($personRecord[$i]['Person']['zip_four']); ?>
					</td>
					<td><?php echo $this->Form->checkbox('zip_four', array('hiddenField'=>false,'value'=>$personRecord[$i]['Person']['zip_four']==''?'#':$personRecord[$i]['Person']['zip_four'],'class' => 'selChk zip_four','id' => 'zip_four_'.$i)); ?>
					</td>
				</tr>
				<tr>
					<td class="tdLabel" id="boxSpace"><?php echo __('Fax No.');?>
					</td>
					<td><?php echo __($personRecord[$i]['Person']['fax']); ?>
					</td>
					<td><?php echo $this->Form->checkbox('fax', array('hiddenField'=>false,'value'=>$personRecord[$i]['Person']['fax']==''?'#':$personRecord[$i]['Person']['country'],'class' => 'selChk fax','id' => 'fax_'.$i)); ?>
					</td>
					<td class="tdLabel" id="boxSpace"><?php echo __('Country');?>
					</td>
					<td><?php echo __($personRecord[$i]['Person']['country']); ?>
					</td>
					<td><?php echo $this->Form->checkbox('country', array('hiddenField'=>false,'value'=>$personRecord[$i]['Person']['country']==''?'#':$personRecord[$i]['Person']['country'],'class' => 'selChk country','id' => 'country_'.$i)); ?>
					</td>
				</tr>
				<tr>
					<td class="tdLabel" id="boxSpace">&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td class="tdLabel" id="boxSpace"><?php echo __('State',true); ?>
					</td>
					<td id="customstate1"><?php echo __($personRecord[$i]['Person']['state']);?>
					</td>
					<td><?php echo $this->Form->checkbox('state', array('hiddenField'=>false,'value'=>$personRecord[$i]['Person']['state']==''?'#':$personRecord[$i]['Person']['state'],'class' => 'selChk state','id' => 'state_'.$i)); ?>
					</td>
				</tr>
				<tr>
					<td class="tdLabel" id="boxSpace"><?php echo __('City/Town');?>
					</td>
					<td><?php echo __($personRecord[$i]['Person']['city']);?>
					</td>

					<td><?php echo $this->Form->checkbox('city', array('hiddenField'=>false,'value'=>$personRecord[$i]['Person']['city']==''?'#':$personRecord[$i]['Person']['city'],'class' => 'selChk city','id' => 'city_'.$i)); ?>
					</td>
					</td>
					<td class="tdLabel" id="boxSpace"><?php echo __('Nationality');?>
					</td>
					<td><?php echo __($personRecord[$i]['Person']['nationality']); ?>
					</td>
					<td><?php echo $this->Form->checkbox('nationality', array('hiddenField'=>false,'value'=>$personRecord[$i]['Person']['nationality']==''?'#':$personRecord[$i]['Person']['nationality'],'class' => 'selChk nationality','id' => 'nationality_'.$i)); ?>
					</td>
				</tr>
				<tr>
					<td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Address Type');?>
					</td>
					<td width="30%"><?php echo __($personRecord[$i]['Person']['person_address_type_first']); ?>
					</td>
					<td><?php echo $this->Form->checkbox('person_address_type_first', array('hiddenField'=>false,'value'=>$personRecord[$i]['Person']['person_address_type_first']==''?'#':$personRecord[$i]['Person']['person_address_type_first'],'class' => 'selChk person_address_type_first','id' => 'person_address_type_first_'.$i)); ?>
					</td>
					<td width="19%" class="tdLabel" id="boxSpace"><?php echo('Country/Parish Code');?>
					</td>
					<td width="30%"><?php echo __($personRecord[$i]['Person']['person_parish_code_first']);?>
					</td>
					<td><?php echo $this->Form->checkbox('person_parish_code_first', array('hiddenField'=>false,'value'=>$personRecord[$i]['Person']['person_parish_code_first']==''?'#':$personRecord[$i]['Person']['person_parish_code_first'],'class' => 'selChk person_parish_code_first','id' => 'person_parish_code_first_'.$i)); ?>
					</td>
				</tr>
			</table></td><?php } //end of if td1?>
		<?php if(!empty($personRecord[($i+1)]['Person']['initial_id'])){?>
		<!--<td>&nbsp;</td>-->
		<td valign="top" width="50%"><table width="100%" cellpadding="0" cellspacing="1" border="0"
				class="tabularForm">
				<tr>
					<th colspan="6"><?php echo __('Patient Information', true); ?></th>
				</tr>
				<tr>
					<td width="19%" valign="middle" class="" id="boxSpace"><?php echo __("Prefix");?>
						
					</td>
					<td width="30%"><table width="100%" cellpadding="0" cellspacing="1"
							border="0">
							<tr>
								<td><?php echo __($personRecord[($i+1)]['Initial']['name']); ?>
								</td>
								<td></td>
							</tr>
						</table></td>
					<td><?php echo $this->Form->checkbox('initial_id', array('hiddenField'=>false,'value'=>$personRecord[($i+1)]['Person']['initial_id']==''?'#':$personRecord[($i+1)]['Person']['initial_id'],'class' => 'selChk initial_id','id' => 'initial_id_'.($i+1))); ?>
					</td>
					<td colspan="3">&nbsp;</td>
				</tr>
				<tr>
					<td width="19%" valign="middle" class="" id="boxSpace"><?php echo __("First Name");?>
						
					</td>
					<td width="30%"><table width="100%" cellpadding="0" cellspacing="0"
							border="0">
							<tr>

								<td><?php echo __($personRecord[($i+1)]['Person']['first_name']); ?>
								</td>

							</tr>
						</table></td>
					<td width=""><?php echo $this->Form->checkbox('first_name', array('hiddenField'=>false,'value'=>$personRecord[($i+1)]['Person']['first_name']==''?'#':$personRecord[($i+1)]['Person']['first_name'],'class' => 'selChk first_name','id' => 'first_name_'.($i+1))); ?>
					</td>
					<td valign="middle" class="" id="boxSpace"><?php echo __('Middle Initial');?>
					</td>
					<td><?php echo __($personRecord[($i+1)]['Person']['middle_name']); ?>
					</td>
					<td><?php echo $this->Form->checkbox('middle_name', array('hiddenField'=>false,'value'=>$personRecord[($i+1)]['Person']['middle_name']==''?'#':$personRecord[($i+1)]['Person']['middle_name'],'class' => 'selChk middle_name','id' => 'middle_name_'.($i+1))); ?>
					</td>
				</tr>
				<tr>
					<td valign="middle" class="" id="boxSpace"><?php echo __('Last Name');?>
						
					</td>
					<td><?php echo __($personRecord[($i+1)]['Person']['last_name']); ?>
					</td>
					<td><?php echo $this->Form->checkbox('last_name', array('hiddenField'=>false,'value'=>$personRecord[($i+1)]['Person']['last_name']==''?'#':$personRecord[($i+1)]['Person']['last_name'],'class' => 'selChk last_name','id' => 'last_name_'.($i+1))); ?>
					</td>
					<td width="19%" class="" id="boxSpace"><?php echo __('Name Type');?>
					</td>
					<td width="30%"><?php echo __($personRecord[($i+1)]['Person']['name_type']); ?>
					</td>
					<td><?php echo $this->Form->checkbox('name_type', array('hiddenField'=>false,'value'=>$personRecord[($i+1)]['Person']['name_type']==''?'#':$personRecord[($i+1)]['Person']['name_type'],'class' => 'selChk name_type','id' => 'name_type_'.($i+1))); ?>
					</td>
				</tr>
				<tr>
					<td valign="middle" class="" id="boxSpace"><?php echo __('Suffix');?>
					</td>
					<td><?php echo __($personRecord[($i+1)]['Person']['suffix1']); ?>
					</td>
					<td><?php echo $this->Form->checkbox('suffix1', array('hiddenField'=>false,'value'=>$personRecord[($i+1)]['Person']['suffix1']==''?'#':$personRecord[($i+1)]['Person']['suffix1'],'class' => 'selChk suffix1','id' => 'suffix1_'.($i+1))); ?>
					</td>
					<td width="19%" class="" id="boxSpace"><?php echo __('Date of Birth');?>
						
					</td>
					<td width="30%"><?php echo __($personRecord[($i+1)]['Person']['dob']);?>
					</td>
					<td><?php echo $this->Form->checkbox('dob', array('hiddenField'=>false,'value'=>$personRecord[($i+1)]['Person']['dob']==''?'#':$personRecord[($i+1)]['Person']['dob'],'class' => 'selChk dob','id' => 'dob_'.($i+1))); ?>
					</td>
				</tr>
				<tr>
					<td width="19%" class="" id="boxSpace"><?php echo __('Gender');?> 
						
					</td>
					<td width="30%"><?php  echo __($personRecord[($i+1)]['Person']['sex']);?>
					</td>
					<td><?php echo $this->Form->checkbox('sex', array('hiddenField'=>false,'value'=>$personRecord[($i+1)]['Person']['sex']==''?'#':$personRecord[($i+1)]['Person']['sex'],'class' => 'selChk sex','id' => 'sex_'.($i+1))); ?>
					</td>
					<td valign="middle" class="" id="boxSpace"><?php echo __('Marital Status');?>
					</td>
					<td><?php echo __($personRecord[($i+1)]['Person']['maritail_status']);?>
					</td>
					<td><?php echo $this->Form->checkbox('maritail_status', array('hiddenField'=>false,'value'=>$personRecord[($i+1)]['Person']['maritail_status']==''?'#':$personRecord[($i+1)]['Person']['maritail_status'],'class' => 'selChk maritail_status','id' => 'maritail_status_'.($i+1))); ?>
					</td>
				</tr>
				<tr>
					<td class="" id="boxSpace">Patient's Photo</td>
					<td><?php echo 'upload_image'?></td>
					<td>&nbsp;</td>
					<td colspan="3"><?php //echo $this->Form->checkbox('maritail_status', array('hiddenField'=>false,'value'=>$personRecord[($i+1)]['Person']['maritail_status'],'class' => 'selChk','id' => 'maritail_status_'.($i+1))); ?>
					</td>
				</tr>
				<tr>
					<td valign="middle" class="" id="boxSpace"><?php echo __('Blood Group');?>
					</td>
					<td><?php echo __($personRecord[($i+1)]['Person']['blood_group']);?>
					</td>
					<td><?php echo $this->Form->checkbox('blood_group', array('hiddenField'=>false,'value'=>$personRecord[($i+1)]['Person']['blood_group']==''?'#':$personRecord[($i+1)]['Person']['blood_group'],'class' => 'selChk blood_group','id' => 'blood_group_'.($i+1))); ?>
					</td>
					<td valign="top" class="" id="boxSpace"><?php echo __('Allergies');?>
					</td>
					<td><?php echo __($personRecord[($i+1)]['Person']['allergies']);?>
					</td>
					<td><?php echo $this->Form->checkbox('allergies', array('hiddenField'=>false,'value'=>$personRecord[($i+1)]['Person']['allergies']==''?'#':$personRecord[($i+1)]['Person']['allergies'],'class' => 'selChk allergies','id' => 'allergies_'.($i+1))); ?>
					</td>
				</tr>
				<tr>
					<td class=" " id="boxSpace" valign="top">Referral Doctor</td>
					<td><?php    echo __($personRecord[($i+1)]['Person']['known_fam_physician']); ?>
					</td>
					<td><?php echo $this->Form->checkbox('known_fam_physician', array('hiddenField'=>false,'value'=>$personRecord[($i+1)]['Person']['known_fam_physician']==''?'#':$personRecord[($i+1)]['Person']['known_fam_physician'],'class' => 'selChk known_fam_physician','id' => 'known_fam_physician_'.($i+1))); ?>
					</td>
					<td valign="middle" class="" id="boxSpace">Consultant Name</td>
					<td><?php echo __($personRecord[($i+1)]['Person']['consultant_id']); ?></td>
					<td><?php echo $this->Form->checkbox('consultant_id', array('hiddenField'=>false,'value'=>$personRecord[($i+1)]['Person']['consultant_id']==''?'#':$personRecord[($i+1)]['Person']['consultant_id'],'class' => 'selChk consultant_id','id' => 'consultant_id_'.($i+1))); ?>
					</td>
				</tr>
				<tr>
					<td valign="middle" class="" id="boxSpace"><?php echo __('SSN');?>
					</td>
					<td><?php echo __($personRecord[($i+1)]['Person']['ssn_us']); ?>
					</td>
					<td><?php echo $this->Form->checkbox('ssn_us', array('hiddenField'=>false,'value'=>$personRecord[($i+1)]['Person']['ssn_us']==''?'#':$personRecord[($i+1)]['Person']['ssn_us'],'class' => 'selChk ssn_us','id' => 'ssn_us_'.($i+1))); ?>
					</td>
					<td class="" id="boxSpace"><?php echo __('ID Number/MRN');?></td>
					<td><?php echo __($personRecord[($i+1)]['Person']['mrn_number']); ?>
					</td>
					<td><?php echo $this->Form->checkbox('mrn_number', array('hiddenField'=>false,'value'=>$personRecord[($i+1)]['Person']['mrn_number']==''?'#':$personRecord[($i+1)]['Person']['mrn_number'],'class' => 'selChk mrn_number','id' => 'mrn_number_'.($i+1))); ?>
					</td>
				</tr>
				<tr>
					<td valign="middle" class="" id="boxSpace"><?php echo __('Birth Order');?>
					</td>
					<td><?php echo __($personRecord[($i+1)]['Person']['birth_order']); ?>
					</td>
					<td><?php echo $this->Form->checkbox('birth_order', array('hiddenField'=>false,'value'=>$personRecord[($i+1)]['Person']['birth_order']==''?'#':$personRecord[($i+1)]['Person']['birth_order'],'class' => 'selChk birth_order','id' => 'birth_order_'.($i+1))); ?>
					</td>
					<td valign="middle" class="" id="boxSpace"><?php echo __('Multiple Birth Indicator');?>
					</td>
					<td><?php echo __($personRecord[($i+1)]['Person']['multiple_birth_indicator']); ?>
					</td>
					<td><?php echo $this->Form->checkbox('multiple_birth_indicator', array('hiddenField'=>false,'value'=>$personRecord[($i+1)]['Person']['multiple_birth_indicator']==''?'#':$personRecord[($i+1)]['Person']['multiple_birth_indicator'],'class' => 'selChk multiple_birth_indicator','id' => 'multiple_birth_indicator_'.($i+1))); ?>
					</td>
				</tr>
				<tr>
					<td valign="middle" class="" id="boxSpace"><?php echo __('Professional Suffix');?>
					</td>
					<td><?php echo __($personRecord[($i+1)]['Person']['professional_suffix']); ?>
					</td>
					<td><?php echo $this->Form->checkbox('professional_suffix', array('hiddenField'=>false,'value'=>$personRecord[($i+1)]['Person']['professional_suffix']==''?'#':$personRecord[($i+1)]['Person']['professional_suffix'],'class' => 'selChk professional_suffix','id' => 'professional_suffix_'.($i+1))); ?>
					</td>
					<td colspan="4">&nbsp;</td>
				</tr>
				<tr>
					<th colspan="6"><?php echo __('Demographic', true); ?></th>
				</tr>
				<tr>
					<td width="19%" class="" id="boxSpace"><?php echo __('Ethnicity');?>
					</td>
					<!--Hispanic, Latino, American, African   -->
					<td width="30%"><?php echo __($personRecord[($i+1)]['Person']['ethnicity']);?>
					</td>
					<td><?php echo $this->Form->checkbox('ethnicity', array('hiddenField'=>false,'value'=>$personRecord[($i+1)]['Person']['ethnicity']==''?'#':$personRecord[($i+1)]['Person']['ethnicity'],'class' => 'selChk ethnicity','id' => 'ethnicity_'.($i+1))); ?>
					</td>
					<td width="10%" class="" id="boxSpace"><?php echo __('Alternate Ethinicity');?>
					</td>
					<td width="30%"><?php echo __($personRecord[($i+1)]['Person']['alt_ethinicity']);?>
					</td>
					<td><?php echo $this->Form->checkbox('alt_ethinicity', array('hiddenField'=>false,'value'=>$personRecord[($i+1)]['Person']['alt_ethinicity']==''?'#':$personRecord[($i+1)]['Person']['alt_ethinicity'],'class' => 'selChk alt_ethinicity','id' => 'alt_ethinicity_'.($i+1))); ?>
					</td>
				</tr>
				<tr>
					<td width="19%" class="" id="boxSpace"><?php echo __('Preferred Language');?>
					</td>
					<td width="30%"><?php echo __($personRecord[($i+1)]['Person']['language']);?>
					</td>
					<td><?php echo $this->Form->checkbox('language', array('hiddenField'=>false,'value'=>$personRecord[($i+1)]['Person']['language']==''?'#':$personRecord[($i+1)]['Person']['language'],'class' => 'selChk language','id' => 'language_'.($i+1))); ?>
					</td>
					<td colspan="3"></td>
				</tr>
				<tr>
					<td width="19%" class="" id="boxSpace"><?php echo __('Race(s)');?>
					</td>
					<td width="30%"><?php echo __($personRecord[($i+1)]['Person']['race']);?>
					</td>
					<td><?php echo $this->Form->checkbox('race', array('hiddenField'=>false,'value'=>$personRecord[($i+1)]['Person']['race']==''?'#':$personRecord[($i+1)]['Person']['race'],'class' => 'selChk race','id' => 'race_'.($i+1))); ?>
					</td>
					<td width="10%" class="" id="boxSpace"><?php echo __('Alternate Race');?>
					</td>
					<td width="30%"><?php echo __($personRecord[($i+1)]['Person']['alt_race']);?>
					</td>
					<td><?php echo $this->Form->checkbox('alt_race', array('hiddenField'=>false,'value'=>$personRecord[($i+1)]['Person']['alt_race']==''?'#':$personRecord[($i+1)]['Person']['alt_race'],'class' => 'selChk alt_race','id' => 'alt_race_'.($i+1))); ?>
					</td>
				</tr>
				<!-- prffred Communication -->
				<tr>
					<td width="19%" class="" id="boxSpace"><?php echo __('Preferred Communication');?>
					</td>
					<td width="30%"><?php echo __($personRecord[($i+1)]['Person']['P_comm']); ?>
					</td>
					<td><?php echo $this->Form->checkbox('P_comm', array('hiddenField'=>false,'value'=>$personRecord[($i+1)]['Person']['P_comm']==''?'#':$personRecord[($i+1)]['Person']['P_comm'],'class' => 'selChk P_comm','id' => 'P_comm_'.($i+1))); ?>
					</td>
					<td colspan="3"></td>
				</tr>
				<!-- prffred Communication -->
				<tr>
					<td class="" id="boxSpace"><?php echo __('Religion');?>
					</td>
					<td><?php echo __($personRecord[($i+1)]['Person']['religion']);?>
					</td>
					<td><?php echo $this->Form->checkbox('religion', array('hiddenField'=>false,'value'=>$personRecord[($i+1)]['Person']['religion']==''?'#':$personRecord[($i+1)]['Person']['religion'],'class' => 'selChk religion','id' => 'religion_'.($i+1))); ?>
					</td>
					<td colspan="3"></td>
				</tr>
				<tr>
					<th colspan="6"><?php echo __('Address Information One', true); ?>
					</th>
				</tr>
				<tr>
					<td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Address Line 1');?>
					</td>
					<td width="30%"><?php echo __($personRecord[($i+1)]['Person']['plot_no']);?>
					</td>
					<td><?php echo $this->Form->checkbox('plot_no', array('hiddenField'=>false,'value'=>$personRecord[($i+1)]['Person']['plot_no']==''?'#':$personRecord[($i+1)]['Person']['plot_no'],'class' => 'selChk plot_no','id' => 'plot_no_'.($i+1))); ?>
					</td>
					<td width="19%" class="tdLabel" id="boxSpace"><?php echo('Address Line 2');?>
					</td>
					<td width="30%"><?php echo __($personRecord[($i+1)]['Person']['landmark']);?>
					</td>
					<td><?php echo $this->Form->checkbox('landmark', array('hiddenField'=>false,'value'=>$personRecord[($i+1)]['Person']['landmark']==''?'#':$personRecord[($i+1)]['Person']['landmark'],'class' => 'selChk landmark','id' => 'landmark_'.($i+1))); ?>
					</td>
				</tr>
				<tr>
					<td class="tdLabel" id="boxSpace" valign="top"><?php echo __('Zip');?>
						
					</td>
					<td valign="top"><?php echo __($personRecord[($i+1)]['Person']['pin_code']);?>
					</td>
					<td><?php echo $this->Form->checkbox('pin_code', array('hiddenField'=>false,'value'=>$personRecord[($i+1)]['Person']['pin_code']==''?'#':$personRecord[($i+1)]['Person']['pin_code'],'class' => 'selChk pin_code','id' => 'pin_code_'.($i+1))); ?>
					</td>
					<td class="tdLabel" id="boxSpace"><?php echo __('Zip 4');?>
					</td>
					<td><?php echo __($personRecord[($i+1)]['Person']['zip_four']); ?>
					</td>
					<td><?php echo $this->Form->checkbox('zip_four', array('hiddenField'=>false,'value'=>$personRecord[($i+1)]['Person']['zip_four']==''?'#':$personRecord[($i+1)]['Person']['zip_four'],'class' => 'selChk zip_four','id' => 'zip_four_'.($i+1))); ?>
					</td>
				</tr>
				<tr>
					<td class="tdLabel" id="boxSpace"><?php echo __('Fax No.');?>
					</td>
					<td><?php echo __($personRecord[($i+1)]['Person']['fax']); ?>
					</td>
					<td><?php echo $this->Form->checkbox('fax', array('hiddenField'=>false,'value'=>$personRecord[($i+1)]['Person']['fax']==''?'#':$personRecord[($i+1)]['Person']['fax'],'class' => 'selChk fax','id' => 'fax_'.($i+1))); ?>
					</td>
					<td class="tdLabel" id="boxSpace"><?php echo __('Country');?>
					</td>
					<td><?php echo __($personRecord[($i+1)]['Person']['country']); ?>
					</td>
					<td><?php echo $this->Form->checkbox('country', array('hiddenField'=>false,'value'=>$personRecord[($i+1)]['Person']['country']==''?'#':$personRecord[($i+1)]['Person']['country'],'class' => 'selChk country','id' => 'country_'.($i+1))); ?>
					</td>
				</tr>
				<tr>
					<td class="tdLabel" id="boxSpace">&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td class="tdLabel" id="boxSpace"><?php echo __('State',true); ?>
					</td>
					<td id="customstate1"><?php echo __($personRecord[($i+1)]['Person']['state']);?>
					</td>
					<td><?php echo $this->Form->checkbox('state', array('hiddenField'=>false,'value'=>$personRecord[($i+1)]['Person']['state']==''?'#':$personRecord[($i+1)]['Person']['state'],'class' => 'selChk state','id' => 'state_'.($i+1))); ?>
					</td>
				</tr>
				<tr>
					<td class="tdLabel" id="boxSpace"><?php echo __('City/Town');?>
					</td>
					<td><?php echo __($personRecord[($i+1)]['Person']['city']);?>
					</td>

					<td><?php echo $this->Form->checkbox('city', array('hiddenField'=>false,'value'=>$personRecord[($i+1)]['Person']['city']==''?'#':$personRecord[($i+1)]['Person']['city'],'class' => 'selChk city','id' => 'city_'.($i+1))); ?>
					</td>
					</td>
					<td class="tdLabel" id="boxSpace"><?php echo __('Nationality');?>
					</td>
					<td><?php echo __($personRecord[($i+1)]['Person']['nationality']); ?>
					</td>
					<td><?php echo $this->Form->checkbox('nationality', array('hiddenField'=>false,'value'=>$personRecord[($i+1)]['Person']['nationality']==''?'#':$personRecord[($i+1)]['Person']['nationality'],'class' => 'selChk nationality','id' => 'nationality_'.($i+1))); ?>
					</td>
				</tr>
				<tr>
					<td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Address Type');?>
					</td>
					<td width="30%"><?php echo __($personRecord[($i+1)]['Person']['person_address_type_first']); ?>
					</td>
					<td><?php echo $this->Form->checkbox('person_address_type_first', array('hiddenField'=>false,'value'=>$personRecord[($i+1)]['Person']['person_address_type_first']==''?'#':$personRecord[($i+1)]['Person']['person_address_type_first'],'class' => 'selChk person_address_type_first','id' => 'person_address_type_first_'.($i+1))); ?>
					</td>
					<td width="19%" class="tdLabel" id="boxSpace"><?php echo('Country/Parish Code');?>
					</td>
					<td width="30%"><?php echo __($personRecord[($i+1)]['Person']['person_parish_code_first']);?>
					</td>
					<td><?php echo $this->Form->checkbox('person_parish_code_first', array('hiddenField'=>false,'value'=>$personRecord[($i+1)]['Person']['person_parish_code_first']==''?'#':$personRecord[($i+1)]['Person']['person_parish_code_first'],'class' => 'selChk person_parish_code_first','id' => 'person_parish_code_first_'.($i+1))); ?>
					</td>
				</tr>
			</table></td><?php }//end of if td 2?>
	</tr><tr><td>&nbsp;</td></tr>
	<?php $i++;} // end of for?>
</table>


<div>&nbsp;</div>
<?php echo $this->Form->end();?>
<script>

$(document).ready(function(){

	if('<?php echo $this->request->data == '1'?>'){
		var message = '<?php echo $message ?>';
		$('#flashMessage', parent.document).show();
		$( '#flashMessage', parent.document ).append(message);
		parent.$.fancybox.close();
	}

	$('#smartMerge').click(function(){ 
	var id = '<?php echo $data;?>';
	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "persons", "action" => "smartMerge","admin" => false)); ?>";
	    $.ajax({
            type: 'POST',
           url: ajaxUrl+'/'+id,
            dataType: 'html',
            success: function(data){
            //parent.window.location.reload();
           parent.window.location.href = '<?php echo $this->Html->url('/persons/add?q=mergecomplete'); ?>';
            parent.$.fancybox.close();
            },
			error: function(){
                alert("Internal Error Occured. Unable To Merge EMPI.");
            },        });
      
      return false;	
});
	
});
$('#mergeEmpiRecord').submit(function(){
	var msg = false ; 

	$("input:checkbox").each(function(){
	     var id =  $(this).attr('id');
	       if(!$("#"+id).is(':checked') && !$("#"+id).attr('disabled')){ 
	    	 //  if( !$("#"+id).attr('disabled')){ 
	       		msg = true  ;
	       }
	    }
	);
	if(msg){
		alert("Please select all field .");
		return false ;
	}		
});

$(".selChk").click(function(){
	var id = $(this).attr('id');
	var Clas = $(this).attr('class');
	var eleClas = Clas.split(' ');
	
	if($("#"+id).is(':checked')){
		$("."+eleClas[1]).attr("disabled", true);
		$("#"+id).removeAttr("disabled");
	}else{
		$("."+eleClas[1]).removeAttr("disabled");
		
		}
	});



	</script>
