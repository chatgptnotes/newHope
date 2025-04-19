
<?php //echo '>>';debug($data);exit;?>
<?php 
//echo $this->Html->script(array('jquery.autocomplete','jquery.fancybox-1.3.4'));
//echo $this->Html->css(array( 'jquery.autocomplete.css','jquery.fancybox-1.3.4.css'));
$referral = $this->request->referer();
echo $this->Form->hidden('formReferral',array('value'=>'','id'=>'formReferral'));
$docId=explode(',', $this->params->query['docID']);
?>
<!-- restrict browser back button gaurav -->
<script type="text/javascript">
    window.history.forward();
    function noBack() { window.history.forward(); }
</script>
<style>
/*label {
	width: 126px;
	padding: 0px;
}
.table_cell{ width:96px !important;}*/
/* for unwanted blue bacground and border*/
/* For space */
.tdLabel {
	padding-top: 30px !important;
}

#PersonSearchForm .formFull td {
	padding: 0px 0 20px 20px !important;
}

#submit {
	margin: 0 30px 0 0 !important;
}

.table_cell {
	float: left;
	width: 89px !important;
}

.view_img img {
	padding: 0 0 0 17px;
	text-align: center;
}

.person_img a img {
	padding: 0 0 0 17px;
	text-align: center;
}

#language {
	width: 108px;
	border: 1px solid #000 !important;
}
</style>
<?php 
	$flashMsg = $this->Session->flash('still') ;
	if(!empty($flashMsg)){ ?>
	<div>
		<?php echo $flashMsg ;?>
	</div> 
<?php } ?>
<div class="inner_title">
	<h3 style="padding-left: 5px;">
		<?php echo __('Search Patient', true); ?>
	</h3>

</div>
<div class="clr">&nbsp;</div>
<?php echo $this->Form->create('',array('action'=>'searchPatient','type'=>'get','id'=>'PersonSearchForm'));?>
<table border="0" class="formFull" cellpadding="0" cellspacing="0"
	width="99%" align="center">
	<tbody>
		<tr>
			<td></td>
		</tr>
		<tr>
			<?php /* ?><td class="tdLabel" id="boxSpace" width="13%"><?php echo __('Is this your first visit ?')?>
			</td>
			<td width="10%"><?php  echo $this->Form->input('Person.is_first_visit', array('type'=>'checkbox','class' =>'','id' => 'is_first','value'=>'',
			'legend'=>false,'label'=> false));?>
			</td><?php */?>

			<td class=" tdLabel" id="boxSpace" width="13%"><?php echo __('Date of Birth')?>
			</td>
			<td width="16%"><?php echo $this->Form->input('Person.dob', array('id' => 'dob_person', 'label'=> false, 'div' => false, 'style'=>'width:150px', 'error' => false,
					'autocomplete'=>false,'class'=>'yello_bg textBoxExpnd','readonly'=>'readonly', 'div' => false,'type'=>'text'));?>
			</td>
			<!-- <td class=" tdLabel" id="boxSpace" width="13%"><?php echo __('First Name')?>
			</td>
			<td width="20%"><?php echo $this->Form->input('Person.first_name', array('id' => 'first_name','label'=> false, 'style'=>'width:150px','class'=>'textBoxExpnd',
					 'div' => false,'error' => false,'autocomplete'=>false));	?>
			</td>
			<td class=" tdLabel" id="boxSpace" width="13%"><?php echo __('Last Name')?></td>
			<td width="15%"><?php echo $this->Form->input('Person.last_name', array('id' => 'last_name', 'label'=> false, 'style'=>'width:150px', 'div' => false, 
					'error' => false,'autocomplete'=>false,'class'=>'textBoxExpnd'));?>
			</td>
			<td class=" tdLabel" id="boxSpace" width="13%"><?php echo __('Visit ID')?></td>
			<td width="20%"><?php echo $this->Form->input('Person.mrn_no', array('id' => 'mrn_no', 'label'=> false, 'style'=>'width:150px', 'div' => false,
					 'error' => false,'autocomplete'=>false,'class'=>'textBoxExpnd'));?>
			</td>
			 -->
			 <td class=" tdLabel" id="boxSpace" width="15%"><?php
            if($this->Session->read('website.instance')=='vadodara'){
			 echo __('Patient Name/ Patient ID :');
                }else{
	         echo __('Patient Name/ Visit ID :');
				}?></td>
			 <td><?php echo $this->Form->input('patient_name',array('type'=>'text','class'=>'patient_name','id'=>"patient_name",
											'autofocus'=>'autofocus','autocomplete'=>'off','label'=>false,'div'=>false,"placeholder"=>"Patient Name"));
					//echo $this->Form->hidden('patient_id',array('id'=>'patient_id'));?>
			</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td class=" tdLabel" id="boxSpace" colspan="8"  class='blueBtn' width="25%"><span
				style="cursor: pointer; text-decoration: underline;"
				id="advanced_search"><strong>Advanced Search Options</strong> </span>
			</td>
			
		</tr>
		<tr id="show0" style="display: none">
			<td class="tdLabel" id="boxSpace"><?php echo __('Mobile Number') ?>
			</td>
			<td><?php echo $this->Form->input('Person.mobile', array('id' => 'person_local_number', 'label'=> false,
					 'div' => false, 'error' => false,'autocomplete'=>false,'class'=>'yello_bg validate["",custom[phone]] textBoxExpnd','maxlength'=>'10'));?>
			</td>
			<td  class="tdLabel" id="boxSpace"><?php echo __('E-mail Address')?></td>
			<td><?php echo $this->Form->input('Person.email', array('id' => 'email', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'class'=>'yello_bg validate["",custom[email]] textBoxExpnd'));
			?>
			</td>  
			<td class=" tdLabel" id="boxSpace"><?php echo __('Primary Care Provider');?>
			</td>
			<td><?php
			echo $this->Form->input('Person.doctor_id_txt', array('id'=>'doctor_id_txt','label'=>false, 'style'=>'width:108px', 'div' => false, 'error' => false,'autocomplete'=>false));
			//actual field to enter in db
			echo $this->Form->hidden('Person.doctor_id', array('label'=>false,'id'=>'doctorID'));
			?>
			</td>
			
			<td class=" tdLabel" id="boxSpace"><?php echo __('Gender')?></td>
			<td><?php echo $this->Form->input('Person.sex', array('options'=>array(''=>__('Please Select'),'Male'=>__('Male'),'Female'=>__('Female'),'Ambiguous'=>__('Ambiguous'),'Not applicable'=>__('Not applicable'),'Unknown'=>__('Unknown'),'Other'=>__('Other')),
					'id' => 'gender', 'label'=> false,'class' => 'yello_bg validate[optional,custom[mandatory-select]] textBoxExpnd	','style'=>'width:108px', 'div' => false, 'error' => false,'autocomplete'=>false));
			?>
			</td>
			  
		</tr>
		<tr id="show1" style="display: none">
			<td class="tdLabel"><?php echo __('Bar Code')?></td>
			<td><?php echo $this->Form->input('Person.patient_uid', array('class' => 'textBoxExpnd','id' => 'patientUid', 'style'=>'width:117px;','label'=>false, 'div' => false)); ?>
			</td>
			<td class="tdLabel"><?php echo __('Home Phone No.') ?>
			</td>
			<td><?php echo $this->Form->input('Person.home_phone', array('id' => 'home_phone', 'style'=>'width:118px;','maxLength'=>'10',
					 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'class'=>'validate["",custom[phone]] textBoxExpnd'));?>
			</td>
			
		</tr>
		<!-- <tr id="show1" style="display: none">
			<td class=" tdLabel" id="boxSpace" width="12%"><?php echo __('Middle Name') ?> 
			</td>
			<td width="12%"><?php echo $this->Form->input('Person.middle_name', array('id' => 'middle_name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'class'=>'textBoxExpnd'));?>
			</td>
			<td class="tdLabel" id="boxSpace" valign="top"><?php echo __('Race')?>
			</td>
			<td><?php echo $this->Form->input('Person.race', array('class' => 'yello_bg','options'=>$race, 'multiple'=>'true','id' =>'race','label'=>false, 'div' => false,'style'=>'width:108px')); ?>
			</td>
			<td class="tdLabel" id="boxSpace"><?php echo __('Ethnicity')?></td>
			<td><?php echo $this->Form->input('Person.ethnicity', array('class' => 'yello_bg textBoxExpnd','empty'=>__('Please Select'),'id' => 'ethnicity','label'=>false,'options'=>array('2135-2:Hispanic or Latino'=>'Hispanic or Latino','2186-5:Not Hispanic or Latino'=>'Not Hispanic or Latino','UnKnown'=>'UnKnown','Denied to Specific'=>'Declined to specify'), 'div' => false)); ?>
			</td>
			<td class="tdLabel" id="boxSpace" valign="top"><?php echo __('Preferred Language')?>
			</td>
			<td><?php echo $this->Form->input('Person.language', array('id' => 'language','label'=> false,'div' => false, 'error' => false,'autocomplete'=>false,'options'=>$languages,'multiple'=>true,'class' => 'yello_bg textBoxExpnd'));?>
			</td>

		</tr>
		<tr id="show2" style="display: none">

			<td class="tdLabel" id="boxSpace"><?php echo __('Occupation')?></td>
			<td><?php echo $this->Form->input('Person.occupation', array('class' => 'yello_bg textBoxExpnd','id' => 'occupation','label'=>false, 'div' => false,'empty'=>'Please Select','options'=>configure::read('occupation'))); ?>
			</td>
			<td class="tdLabel" id="boxSpace"><?php echo __('Dates of Previous Clinical Visits')?>
			</td>
			<td><?php 
			echo $this->Form->input('Person.form_received_on', array('id' => 'form_received_on','label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'class'=>'yello_bg textBoxExpnd'));
			?>
			</td>
			<td class="tdLabel" id="boxSpace"><?php echo __('Legal Guardian/Health Care Proxy') ?>
			</td>
			<td><?php 
			echo $this->Form->input('Person.guar_first_name', array('id' => 'guar_first_name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'class'=>'yello_bg textBoxExpnd'));
			?>
			</td>
			<td class=" tdLabel" id="boxSpace"><?php echo __('Gender')?></td>
			<td><?php echo $this->Form->input('Person.sex', array('options'=>array(''=>__('Please Select'),'Male'=>__('Male'),'Female'=>__('Female'),'Ambiguous'=>__('Ambiguous'),'Not applicable'=>__('Not applicable'),'Unknown'=>__('Unknown'),'Other'=>__('Other')),
					'id' => 'gender', 'label'=> false,'class' => 'yello_bg validate[optional,custom[mandatory-select]] textBoxExpnd	','style'=>'width:108px', 'div' => false, 'error' => false,'autocomplete'=>false));
			?>
			</td>
		</tr>
		<tr id="show3" style="display: none">
			<td class="tdLabel" id="boxSpace"><?php echo __('Primary Caregiver')?>
			</td>
			<td><?php echo $this->Form->input('Person.gau_first_name', array('id' => 'gau_first_name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'class'=>'yello_bg textBoxExpnd'));
			?>
			</td>
			<td class="tdLabel" id="boxSpace"><?php echo __('Presence of Advance Directives')?>
			</td>
			<td><?php  echo $this->Form->input('Person.is_directives', array('type'=>'checkbox','id' => 'is_directives','value'=>'Y','legend'=>false,'label'=> false));?>
			</td>
			<td class="tdLabel" id="boxSpace"><?php echo __('Health Insurance Information')?>
			</td>
			<td><?php echo $this->Form->input('Person.hidden_tariff_standard_id', array('id' => 'hidden_tariff_standard_id','label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'class'=>'yello_bg textBoxExpnd','type'=>'text'));
			echo $this->Form->input('Person.tariff_standard_id',array('type'=>'hidden','id'=>'tariff_standard_id'));
			?>
			</td>
			<td class=" tdLabel" id="boxSpace"><?php echo __('AADHAR NO')?>
			</td>
			<td><?php echo $this->Form->input('Person.ssn_us', array('class' => 'validate[optional] textBoxExpnd','id' => 'ssn','MaxLength'=>'12','label'=>false, 'div' => false, 'error' => false,'autocomplete'=>false)); ?>
			</td> -->
			<!-- <td class="tdLabel" id="boxSpace"><?php //echo __('Other Health Care Info') ?>
			</td>
			<td><?php //echo $this->Form->input('middle_name', array('id' => 'middle_name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'class'=>'textBoxExpnd'));
			?>
			</td> -->
		</tr>
		<tr class="">
			<!-- <td class="table_cell" align="left" ><?php //echo $this->Html->link(__('Quick Reg'),array('action' => 'quickReg'), array('escape' => false,'class'=>'blueBtn','style'=>'text-align:right'));
			?>
			</td>
			<td class="table_cell" align="left" ><?php //if($showAdvance)echo $this->Html->link(__('Registration'),array('action' => 'add'), array('escape' => false,'class'=>'blueBtn','style'=>'text-align:right'));
			?>
			</td>
			<td></td>
			<td></td>
			<td colspan="2"></td> -->
			
			<td align="right" colspan="8"><?php if($isFingerPrintEnable==1){echo $this->Html->link(__('Search through Fingerprint', true),array('controller'=>'persons','action' => 'finger_print'), array('escape' => false,'class'=>'blueBtn'));}?>&nbsp;<span class="reset"><?php echo $this->Form->submit(__('Reset'),array('type'=>'button','id'=>'reset','class'=>'blueBtn','div'=>false,'label'=>false),array('alt'=>'Reset','title'=>'Reset'));?>
			</span> <?php echo $this->Form->submit(__('Continue'),array('id'=>'submit','class'=>'blueBtn','div'=>false,'label'=>false),array('alt'=>'Search','title'=>'Search'));?>
			</td>
		</tr>
	</tbody>
</table>

<div style="text-align: right;" class="clr inner_title">
	<?php 
	$url= $this->Html->url(array('controller'=>'persons','action'=>'add'));
		//$url1= $this->Html->url(array('controller'=>'persons','action'=>'quickReg'));?>
	<?php //echo $this->Form->button(__('Quick Reg and Schedule'),array('url'=>$url1,'type'=>'button','escape' => false,'class'=>'blueBtn passData','id'=>'quickReg','style'=>'text-align:right'));
	if($showAdvance)echo $this->Form->button(__('Patient Registration'),array('url'=>$url,'type'=>'button','id'=>'patientReg','class'=>'blueBtn passData','div'=>false,'label'=>false),array('alt'=>'Patient Registration','title'=>'Patient Registration'));
	?>
	<?php /* if(isset($data) && !empty($data)){
	if(!$Unmerge){
		echo $this->Form->submit('View all merged records', array('class'=>'blueBtn','label'=> false, 'div' => false, 'error' => false,'id'=>'merge_submit'));
	echo $this->Form->hidden('merge_source',array('id'=>'merge_source'));
	}?>
	<?php if($Unmerge){
		echo $this->Html->link(__('UnMerge'),'#', array('onclick'=>"UnmergePerson();return false;",'escape' => false,'class'=>'blueBtn','style'=>'text-align:right'));
	}else{
		echo $this->Html->link(__('Merge'),'#', array('onclick'=>"mergePerson();return false;",'escape' => false,'class'=>'blueBtn','style'=>'text-align:right'));
	}
} */?>
</div>
<?php echo $this->Form->end();?>
<table border="0" class="table_format" cellpadding="0"
	cellspacing="0" width="100%" id="patientGrid">

	<?php if(isset($data) && !empty($data)){  ?>


	<tr class="row_title">
		<td class="tdLabel" id="field" width="5%" title="Date of Birth"><?php echo  __('DOB', true); ?>
		</td>
	<!--  <td class="tdLabel" id="boxSpace" width="5%"
			title="Social Security Number"><?php echo  __('AADHAR NO', true); ?>
		</td>-->	
		<td class="tdLabel" id="boxSpace" width="20%"
			style="text-align: center;" title="Patient Name"><?php echo  __('Name', true); ?>
		</td>
		<td class="tdLabel" id="boxSpace" width="5%" title="Patient ID"><?php echo __('Patient ID', true); ?>
		</td>
		<td class="tdLabel" id="boxSpace" width="5%" title="Patient ID"><?php echo __('Visit ID', true); ?>
		</td>
		<td class="tdLabel" id="boxSpace" width="5%" title="Sex"><?php echo  __('Sex', true); ?>
		</td>
		<!--  <td class="tdLabel" id="boxSpace" width="3%" title="Race"><?php echo  __('Race', true); ?>
		</td>
		<td class="tdLabel" id="boxSpace" width="5%"
			style="text-align: center;" title="Ethnicity"><?php echo  __('Ethnicity', true); ?>
		</td>-->
	<!-- 	<td class="tdLabel" id="boxSpace" width="5%"
			title="Preffered Language"><?php echo  __('Pref. Lang.', true); ?>
		</td> -->
		<td class="tdLabel" id="boxSpace" width="2%"
			style="text-align: center;" title="E-mail Address"><?php echo  __('E-mail', true); ?>
		</td>
	<!-- 	<td class="tdLabel" id="boxSpace" width="5%" title="Occupation"><?php echo  __('Occupation', true); ?>
		</td> -->
		<td class="tdLabel" id="boxSpace" width="5%"
			style="text-align: center;" title="Mobile Number"><?php echo  __('Mobile', true); ?>
		</td>
		<td class="tdLabel" id="boxSpace" width="9%"
			style="text-align: center;"
			title="Dates of Previous Clinical Visits "><?php echo  __('Previous Visit', true); ?>
		</td>
		<!-- <td class="tdLabel" id="boxSpace" width="12%"
			title="Legal Guardian/Health Care Proxy"><?php echo  __('Guardian Proxy', true); ?>
		</td>
		<td class="tdLabel" id="boxSpace" width="5%" title="Primary Caregiver"><?php echo  __('Primary Caregiver', true); ?>
		</td>
		<td class="tdLabel" id="boxSpace" width="5%"
			title="Health Insurance Information"><?php echo  __('Insu. Info.', true); ?>
		</td> -->

		<?php //if($discharged){ ?>
		<td class="tdLabel" id="boxSpace" width="5%"
			title="Select Type of admission"><?php echo  __('Select Type of admission'); ?>
		</td>
		<?php //} ?>
		<!-- <td class="tdLabel" id="boxSpace" width="5%"><?php /*if($Unmerge){ 
			echo  __('UnMerge');
		}else{ echo  __('Merge');
			}*/ ?>
		</td> -->
		<!-- <td class="tdLabel" id="boxSpace" width="5%" title="Quick Visit"><?php //echo __("Quick Visit")?>
		</td> -->
		<td class="tdLabel" id="boxSpace" width="5%" title="View"><?php echo __("View")?>
		</td>
		<td class="tdLabel" id="boxSpace" width="5%" title="Status"><?php echo __("Status")?>
		</td>
	</tr>
	<?php echo $this->Form->create('Person',array('url'=>array('controller'=>'persons','action'=>'searchPerson'),'id'=>'personRecord',
			'inputDefaults' => array('label' => false, 'div' => false, 'error' => false	)));
	$toggle =0;
	if(count($data) > 0) {
	$i=0;
	foreach($data as $Persons){
							       if($toggle == 0) {
								       	echo "<tr class='row_gray'>";
								       	$toggle = 1;
							       }else{
								       	echo "<tr>";
								       	$toggle = 0;
							       }?>
	<td id="boxSpace" class="row_format "><?php echo $this->DateFormat->formatDate2LocalForReport($Persons['Person']['dob'],Configure::read('date_format'),false); ?>
	</td>
	<!-- <td id="boxSpace" class="row_format "><?php echo $Persons['Person']['ssn_us']; ?>
	</td> -->
	<?php $idPatient=$Persons['Patient']['id'];
	$uidperson=$Persons['Person']['patient_uid'];
	$role=$this->Session->read('role');?>

	<td id="boxSpace" class="row_format" style="width: 120px;text-align: center" ><?php
	/* if(($role == Configure::read('doctorLabel')||$role == Configure::read('nurseLabel')) && $idPatient != null) {
	echo $this->Html->link($Persons['Person']['full_name'],array('controller'=>'PatientsTrackReports','action'=>'sbar',$idPatient,'Summary'),array('alt'=>'Patient Name','title'=>'Name'));
	}else{
	if($Persons['Patient']['is_discharge'])
		echo $this->Html->link($Persons['Person']['full_name'],"javascript:gettoregistration('$uidperson','admissiontype_$i')",array('alt'=>'Patient Name','title'=>'Name'));
	else echo $Persons['Person']['full_name'];
	} */ 
		echo ucwords(strtolower($Persons['Person']['full_name']));?>
	</td>
	<td id="boxSpace" class="row_format "><?php echo $Persons['Person']['patient_uid']; ?>
	</td>
	<td id="boxSpace" class="row_format " style="text-align: center;"><?php echo ucfirst($Persons['Patient']['admission_id']); ?>
	</td>
	<td id="boxSpace" class="row_format " style="text-align: center;"><?php echo ucfirst($Persons['Person']['sex']); ?>
	</td>
	<?php
	/* if(!empty($Persons['Person']['race'])){
			$expRace=explode(',',$Persons['Person']['race']);
	}
	if(count($expRace)>0){
		$raceString = '';
		for($k=0;$k<count($expRace);$k++){
			$raceString  .= ucfirst($race[$expRace[$k]])."\n";
		}
	} */
	?>
	<!-- <td id="boxSpace" class="row_format " style="text-align: center;"
		title="<?php echo $raceString;?>"><?php if($raceString)echo substr($raceString,0,5).'...';?>
	</td>
	<?php $increStrPos = (strtolower($Persons['Person']['ethnicity']) == 'denied to specific')? 0 : 1;?>
	<?php $ethnicity = substr($Persons['Person']['ethnicity'],  strpos($Persons['Person']['ethnicity'], ':')+$increStrPos); ?>
	<td id="boxSpace" class="row_format" title="<?php echo $ethnicity?>"><?php if($ethnicity)echo substr($ethnicity,0,5).'...'; ?>
	</td> -->
	<!-- <td id="boxSpace" class="row_format " style="text-align: center;"><?php 
	if(!empty($Persons['Person']['language'])){
	$expLang=explode(',',$Persons['Person']['language']);
	}
	if(count($expLang)>0){
	for($k=0;$k<count($expLang);$k++){
	echo ucfirst($languages[$expLang[$k]])."<br>";
	}
	}?>
	</td> -->
	<td id="boxSpace" class="row_format" style="text-align: center;"><?php echo $Persons['Person']['email']; ?>
	</td>
	<!-- <td id="boxSpace" class="row_format " style="text-align: center;"><?php echo ucfirst($Persons['Person']['occupation']); ?>
	</td> -->
	<td id="boxSpace" class="row_format " style="text-align: center;"><?php echo $Persons['Person']['mobile']; ?>
	</td>
	<td id="boxSpace" class="row_format " style="text-align: center;"><?php
	 
		if($Persons['Patient']['is_paragon']==1){
			echo $this->DateFormat->formatDate2LocalForReport($Persons['Patient']['form_received_on'],Configure::read('date_format'),false);
		}else{
			echo $this->DateFormat->formatDate2Local($Persons['Patient']['form_received_on'],Configure::read('date_format'),false);
		}

	
	?>
	</td>
	<!-- <td id="boxSpace" class="row_format " style="text-align: center;"><?php echo ucfirst($Persons['Guardian']['guar_first_name']); ?>
	</td>
	<td id="boxSpace" class="row_format "><?php echo ucfirst($Persons['Guarantor']['gau_first_name']); ?>
	</td>
	<?php $insType = ($getDataInsuranceType[$Persons['Person']['insurance_type_id']]) ? $getDataInsuranceType[$Persons['Person']['insurance_type_id']] : ''; ?>
	<td id="boxSpace" class="row_format" title="<?php echo ucfirst($insType); ?>">
	<?php if($insType)echo ucfirst(substr($insType,0,5)).'...'; ?>
	</td> -->

	<?php if($Persons['Patient']['is_discharge']=='1' or empty($Persons['Patient']['id'])){ ?>
	<td id="boxSpace" class="row_format "><?php echo $this->Form->input('admission_type',array('empty'=>("Select admission type"),'options'=>array('OPD'=>'OPD','IPD'=>'IPD','RAD'=>'RADIOLOGY', 'emergency'=>'EMERGENCY','LAB'=>'LABORATORY'),'class'=>'admissiontype','personId'=>$Persons['Person']['id']));?>
	</td>
	<?php }else{?>
	<td></td>
	<?php }?>
	<!-- <td id="boxSpace" class="row_format " style="text-align: center;"><?php  
	//echo $this->Form->checkbox('personId'.$Persons['Person']['id'], array('hiddenField'=>false,'value'=>$Persons['Person']['id'],'class' => 'selChk','id' => 'personId'.$Persons['Person']['id']));
	?>
	</td> -->
	<!-- <td class="person_img"><?php  $status = ($Persons['Appointment']['status'] == 'Pending') ? 'Scheduled'  :  $Persons['Appointment']['status']; 
	if($status==='Seen' || $status==='Closed' || $status==='Scheduled' || $status== 'No-Show'){
	  		echo $this->Html->link($this->Html->image('icons/uerInfo.png',array('title'=>'Patient quick Registration','style'=>'float: right;')),
	  			array("controller" => "Persons", "action" => "quickPatientRagistration",$Persons['Person']['id'],'?'=>array('flag'=>$this->params['action'])),array('escape'=>false));
	  }
	  ?>
	</td> -->
	<td class="view_img"><?php 
	echo $this->Html->link($this->Html->image('icons/view-icon.png',array('alt'=>__('View'),'title'=>__('View'))),
    		array('controller'=>'persons','action' => 'patient_information', $Persons['Person']['id']),
    		array('escape' => false,'title'=>'View'));
    ?>
	</td>
		<?php if($Persons['Patient']['admission_type']=='OPD'){ ?>
	<td id="boxSpace" class="row_format " style="text-align: center;"><?php echo $status;?>
	</td>
	<?php }else if($Persons['Patient']['is_discharge']){?>
	<td id="boxSpace" class="row_format " style="text-align: center;"><?php echo "Discharged";?></td>
	<?php }else{?>
	<td id="boxSpace" class="row_format " style="text-align: center;">&nbsp;</td>
	<?php }?>
	</tr>
	<?php  $i++;
}
//set get variables to pagination url
$queryStr = $this->General->removePaginatorSortArg($this->data) ; //for sort column
$this->Paginator->options(array('url' =>array("?"=>$queryStr['Person'])));
?>
	<tr>
		<TD colspan="18" align="center"><?php if($this->Paginator->params['paging']['Person']['prevPage'] !='')echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
			<!-- Shows the page numbers --> <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
			<!-- Shows the next and previous links --> <?php if($this->Paginator->params['paging']['Person']['nextPage'] !='')echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
			<!-- prints X of Y, where X is current page and Y is number of pages -->
			<span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
		</span>
		</TD>
	</tr>
	<?php } $this->Form->end();?>
	<?php } 
	else { ?>
	<tr align="center">
		<?php if($data1=='2'){			
		}else if($data1 =='1'){
echo "<td align='center' class='error ' id='boxSpace' >No Record found</td>";
} ?>
	</tr>
	<?php }?>
</table>
<div id="pageNavPosition"
	align="center"></div>
<script>			      
	function gettoregistration(id,element_id){
		var type=$('#'+element_id+' option:selected').val();
		if(type!=''){			
			window.top.location = '<?php echo $this->Html->url("/patients/add?type=OPD"); ?>'/*+type */+ '&id='+id; 		
		}
		else{
			alert("Please select the admission type for the patient");
		}	
	}
	
jQuery(document).ready(function() {
	
	var print="<?php echo isset($this->params->query['print'])?$this->params->query['print']:'' ?>";
	var OpdSheet="<?php echo isset($this->params->query['patientId'])?$this->params->query['patientId']:'' ?>";
	var referral = "<?php echo $referral ; ?>" ;
	if(print && referral != '/' && $("#formReferral").val()==''&& OpdSheet){
		
		$("#formReferral").val('yes') ;
		var url="<?php echo $this->Html->url(array('controller'=>'Billings','action'=>'printAdvanceReceipt',$this->params->query['print'])); ?>";
	    window.open(url, "_blank","toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=500,left=100,top=100"); // will open new tab on document ready

	    var docID =<?php echo json_encode($docId);?>;
	     $.each(docID, function(index, value) { 
	        var url="<?php echo $this->Html->url(array('controller'=>'patients','action'=>'opd_print_sheet',$this->params->query['patientId'])); ?>"+"/"+value;
	        window.open(url, "_blank","toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=500,left=400,top=400");
	    });
	    
	}else if(OpdSheet && referral != '/' && $("#formReferral").val()==''){

		 var docID =<?php echo json_encode($docId);?>;
		    $.each(docID, function(index, value) { 
		      var url="<?php echo $this->Html->url(array('controller'=>'patients','action'=>'opd_print_sheet',$this->params->query['patientId'])); ?>"+"/"+value;
		      window.open(url, "_blank","toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=500,left=200,top=200");
		    });
		}	
	
		 jQuery("#PersonSearchForm").validationEngine();
			$('#submit,#merge_submit')
					.click(
							function() { 
								if($(this).attr('id') == 'merge_submit'){
									$('#merge_source').val('1');
								};								 
								var validatePerson = jQuery(
										"#PersonSearchForm")
										.validationEngine(
												'validate');
								if (validatePerson) {
									$(this).css('display', 'none');}								
							});			
		});

		<?php if(!empty($data)) { ?>
			/* var pager = new Pager('patientGrid', 20); 
			pager.init(); 
			pager.showPageNav('pager', 'pageNavPosition'); 
			pager.showPage(1);*/
		<?php } ?>
	//script to include datepicker
		
jQuery(document).ready(
		function() {
			$("#dob_person,#form_received_on").datepicker({
			showOn: "both",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '-100:' + new Date().getFullYear(),
			dateFormat:'<?php echo $this->General->GeneralDate("");?>',
			maxDate: new Date(),
			onSelect : function() {
				$(this).focus();
			} 
		});
		});

		function mergePerson(){
			var cnt = 0 ; 			
			$("input:checkbox").each(function(){
			     var id =  $(this).attr('id');
			       if($("#"+id).is(':checked')){ 
			       		cnt++; 
			       }
			    }
			);
			if(cnt < 2){ 
				alert("Please select atleast one more patient.");
				return false ;
			}
			var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "persons", "action" => "searchPerson","admin" => false)); ?>";
			   var formData = $('#personRecord').serialize();
			    $.ajax({
		            type: 'POST',
		           url: ajaxUrl,
		            data: formData,
		            dataType: 'html',
		            success: function(data){
		            	window.location.href = '<?php echo $this->Html->url('/persons/mergeEmpi/'); ?>'+data;
		            },
					error: function(message){
		                alert("Internal Error Occured. Unable To Generate Message.");
		            },        });		      
		      return false;	
		}

		function UnmergePerson(){
			var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "persons", "action" => "unMergePerson","admin" => false)); ?>";
			   var formData = $('#personRecord').serialize();
			    $.ajax({
		            type: 'POST',
		           url: ajaxUrl,
		            data: formData,
		            dataType: 'html',
		            success: function(data){
		            	alert("Unmerge Sucessful");
		            	window.location.href = '<?php echo $this->Html->url(array("controller" => "persons", "action" => "searchPerson","admin" => false)); ?>';
		            },
					error: function(message){
		                alert("Internal Error Occured. Unable To Generate Message.");
		            },        });		      
		      return false;	
			}

		$(document).ready(function(){	

			$('#patient_name').autocomplete({
					source: "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "admissionComplete",'no',"admin" => false,"plugin"=>false)); ?>",
					select: function(event,ui){			
				},
				 messages: {
			         noResults: '',
			         results: function() {},
			   },
			});
			/*$("#doctor_id_txt").autocomplete({
					source:	"<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "testcomplete","DoctorProfile",'user_id',"doctor_name",'null',"admin" => false,"plugin"=>false)); ?>", 
				width: 250,
				selectFirst: true,
				valueSelected:true,
				showNoId:true,
				loadId : 'doctor_id_txt,doctorID'
			});
		 $('#doctor_id_txt').click(function(){
				$(this).val('');
				$("#doctorID").val('');	 
			}); */

			$("#doctor_id_txt").on('focus',function()
				    {
						var t = $(this);
						$(this).autocomplete({
						source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advanceTwoFieldsAutocomplete","DoctorProfile",'user_id',"doctor_name",'is_active=1','null',"admin" => false,"plugin"=>false)); ?>",
						select:function( event, ui ) {
							$("#doctorID").val(ui.item.id);
						},
						messages: {
					        noResults: '',
					        results: function() {}
						 }
						});
					});
		

			 $("#first_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Person","first_name",'null','null','null','null',"first_name","admin" => false,"plugin"=>false)); ?>", {
					width: 250,
					selectFirst: true
				});
			/* $("#mrn_no").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","admission_id",'null','null','null','null',"admission_id","admin" => false,"plugin"=>false)); ?>", {
					width: 250,
					selectFirst: true
				});*/
			 $("#last_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Person","last_name",'null','null','null','null',"last_name","admin" => false,"plugin"=>false)); ?>", {
					width: 250,
					selectFirst: true
				});

			 $("#mrn_no").autocomplete("<?php echo $this->Html->url(array("controller" => "Persons", "action" => "mrn_search","admission_id","plugin"=>false)); ?>", {
					width: 250,
					selectFirst: true
					});

			/*  $("#hidden_tariff_standard_id").autocomplete("<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "testcomplete","TariffStandard","id","name",'null',"admin" => false,"plugin"=>false)); ?>", {
					width: 250,
					selectFirst: true,
					valueSelected:true,
					showNoId:true,
					loadId : 'hidden_tariff_standard_id,tariff_standard_id'
				});	*/
		 
			  
			var showAd = '<?php echo $advanceSearch?>'; 
			if(showAd=='1'){
				$("#show0").fadeToggle();					
			    $("#show1").fadeToggle();
			    $("#show2").fadeToggle("slow");
			    $("#show3").fadeToggle(500);
			 }
			  $("#advanced_search").click(function(){	
				  	$("#show0").fadeToggle();	
				    $("#show1").fadeToggle();
				    $("#show2").fadeToggle("slow");
				    $("#show3").fadeToggle(500);
			  });
		
							
			});
		$( '.reset' ).click(function (){
			$(this).closest('form').find("input[type=text], textarea, select,input:hidden,input:checkbox").val("").removeAttr('checked');
		});

		//quick reg
		 function pt_reg(patient_id) {  
				if (patient_id == '') {
					alert("Something went wrong");
					return false;
				} 
				var width = '50%';var height = '80%';
				"<?php if(($role == Configure::read('doctorLabel')||$role == Configure::read('nurseLabel'))) {?>"
				var width = '100%';var height = '120%';
				"<?php } ?>"
				$("#Patientsid").val(patient_id);
				$.fancybox({ 
							'width' : width,
							'height' : height,
							'autoScale' : true,
							'transitionIn' : 'fade',
							'transitionOut' : 'fade',
							'type' : 'iframe', 
							'href' : "<?php echo $this->Html->url(array("controller" => "Persons", "action" => "quickPatientRagistration")); ?>"+"/"+patient_id,
				});
			
		}

		
		//EOF quick reg	
		// changing form action and submitting form  
	$('.passData').click(function(){
		$('form').attr({"action": $(this).attr('url'), "method": 'POST'});
		$('#submit').trigger('click');
	});	
	$("#ssn").focusout(function(){ 
		res2=$("#ssn").val();
		count2=($("#ssn").val()).length;
		str21=res2.substring(0, 4);
		str22=res2.substring(4, 8);
		str23=res2.substring(8, 12);
		if(count2=='12'){
			$("#ssn").val(str21+'-'+str22+'-'+str23);
		}
		if(count2=='0'){
			$('#ssn').val("");
		}
	});

	$(".admissiontype").change(function(){
		var type = $(this).val();
		var personId = $(this).attr('personId');
		window.location.href = '<?php echo $this->Html->url(array("controller" => "patients", "action" => "add")); ?>/'+personId+'/submitandregister:1?type='+type;
	});
  </script>

