<?php 
//echo $this->Html->script(array('jquery.autocomplete','jquery.fancybox-1.3.4'));
//echo $this->Html->css(array( 'jquery.autocomplete.css','jquery.fancybox-1.3.4.css'));
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
.center {
	text-align: center;
}

#PersonSearchForm .formFull td {
	padding: 0px 3px 20px 0px !important;
}

#submit {
	margin: 0 30px 0 0 !important;
}

.table_cell {
	float: left;
	width: 89px !important;
}

#language {
	border: 1px solid #214A27 !important;
}

#race {
	height: 77px;
}
</style>

<div class="inner_title">
	<h3 style="padding-left: 5px;">
		<?php echo __('New Visit', true); ?>
	</h3>

</div>

<div class="clr">&nbsp;</div>
<?php echo $this->Form->create('',array('action'=>'searchPerson','type'=>'get','id'=>'PersonSearchForm'));
?>
<table border="0" class="formFull" cellpadding="0" cellspacing="0"
	width="99%" align="center" style="padding: 10px;">
	<tbody>
		<tr>
			<?php /* ?><td class="tdLabel" id="boxSpace" width="13%"><?php echo __('Is this your first visit ?')?>
			</td>
			<td width="10%"><?php  echo $this->Form->input('Person.is_first_visit', array('type'=>'checkbox','class' =>'','id' => 'is_first','value'=>'',
			'legend'=>false,'label'=> false));?>
			</td><?php */?>

			<td class=" tdLabel" id="boxSpace" width="9%"><?php echo __('Date of Birth')?>
			</td>
			<td width="15%"><?php echo $this->Form->input('Person.dob', array('id' => 'dob_person', 'label'=> false, 'div' => false, 'style'=>'width:150px', 'error' => false,
					'autocomplete'=>false,'class'=>'yello_bg textBoxExpnd','readonly'=>'readonly', 'div' => false,'type'=>'text'));?>
			</td>
			<!-- <td class=" tdLabel" id="boxSpace" width="9%"><?php echo __('First Name')?>
			</td>
			<td width="14%"><?php echo $this->Form->input('Person.first_name', array('id' => 'first_name','label'=> false, 'style'=>'width:150px','class'=>'textBoxExpnd',
					 'div' => false,'error' => false,'autocomplete'=>false));	?>
			</td>
			<td class=" tdLabel" id="boxSpace" width="13%"><?php echo __('Last Name')?></td>
			<td width="13%"><?php echo $this->Form->input('Person.last_name', array('id' => 'last_name', 'label'=> false, 'style'=>'width:150px', 'div' => false, 
					'error' => false,'autocomplete'=>false,'class'=>'textBoxExpnd'));?>
			</td>
			 -->
			<?php if( $this->Session->read('website.instance') == 'lifespring' ){?>
			<td class=" tdLabel" id="boxSpace" width="5%"><?php echo __('Patient ID')?></td>
			<td width="14%"><?php echo $this->Form->input('Person.patient_uid', array('class' => 'textBoxExpnd','id' => 'patientUid', 'style'=>'width:170px;','label'=>false, 'div' => false)); ?>
			</td>
			<?php }?>
			<!-- 
			<td class=" tdLabel" id="boxSpace" width="14%"><?php echo __('Visit ID')?></td>
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
				<?php $display = $this->request->data['Person']['prospect'] == '1' ? 'block' : 'none';?>
				<?php $displayPatient = $this->request->data['Person']['prospect'] != '1' ? 'block' : 'none';?>
			 <td><span id='patientSearch' class="patientProspectSearch" style="display:<?php echo $displayPatient;?>;"><?php echo $this->Form->input('patient_name',array('type'=>'text','class'=>'patient_name','id'=>"patient_name",
											'autofocus'=>'autofocus','autocomplete'=>'off','label'=>false,'div'=>false,"placeholder"=>"Patient Name"));
					//echo $this->Form->hidden('patient_id',array('id'=>'patient_id'));?></span>
					<span id="prospectSearch" class="patientProspectSearch" style="display:<?php echo $display;?>;"><?php echo $this->Form->input('prospect_name',array('type'=>'text','class'=>'prospect_name','id'=>"prospect_name",
											'autofocus'=>'autofocus','autocomplete'=>'off','label'=>false,'div'=>false,"placeholder"=>"Prospect Name"));?></span>
			</td>
			<td class=" tdLabel" id="boxSpace" width="14%"><?php echo $this->Form->checkbox('Person.prospect', array('id' => 'prospect', 'label'=> false,  'div' => false,
					 'error' => false,'autocomplete'=>false,'hiddenField'=>false));?><?php echo __('Prospect')?></td>
			<td width="20%">
			</td>
			<td>&nbsp;</td>
		</tr>

		<tr>
			<td class=" tdLabel" colspan=8 class='blueBtn'><span
				style="cursor: pointer; text-decoration: underline;"
				id="advanced_search"><strong>Advanced Search Options</strong> </span>
			</td>
		</tr>
		<tr id="show0" style="display: none">
			<td class="tdLabel"><?php echo __('Mobile Number') ?>
			</td>
			<td><?php echo $this->Form->input('Person.mobile', array('id' => 'mobile', 'style'=>'width:118px;','maxLength'=>'10',
					 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'class'=>'yello_bg validate["",custom[phone]] textBoxExpnd'));?>
			</td>
			<td class="tdLabel"><?php echo __('E-mail Address')?></td>
			<td><?php echo $this->Form->input('Person.email', array('id' => 'email', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'class'=>'yello_bg validate["",custom[email]] textBoxExpnd'));
			?>
			</td>

			<td class=" tdLabel"><?php echo __('Primary Care Provider');?>
			</td>
			<td><?php
			echo $this->Form->input('Person.doctor_id_txt', array('id'=>'doctor_id_txt','class'=>'textBoxExpnd','label'=>false, 'div' => false, 'error' => false,'autocomplete'=>false,));
			//actual field to enter in db
			echo $this->Form->hidden('Person.doctor_id', array('label'=>false,'id'=>'doctorID'));
			?> <!--  </td>
			<td class=" tdLabel"  width="12%"><?php echo __('AADHAR NO')?>
			</td>
			<td><?php echo $this->Form->input('Person.ssn_us', array('class' => 'validate[optional] textBoxExpnd','id' => 'ssn','MaxLength'=>'12','label'=>false, 'div' => false, 'error' => false,'autocomplete'=>false)); ?>
			</td>-->
			
			<td class=" tdLabel"><?php echo __('Gender')?></td>
			<td><?php echo $this->Form->input('Person.sex', array('options'=>array(''=>__('Please Select'),'Male'=>__('Male'),'Female'=>__('Female')),
					'id' => 'gender', 'label'=> false,'class' => 'yello_bg textBoxExpnd	', 'div' => false, 'error' => false,'autocomplete'=>false));
			?>
			</td>
			<td></td>

		</tr>
		<tr id="show1" style="display: none">
		<?php if( $this->Session->read('website.instance') != 'lifespring' ){?>
			<td class="tdLabel"><?php echo __('Bar Code')?></td>
			<td><?php echo $this->Form->input('Person.patient_uid', array('class' => 'textBoxExpnd','id' => 'patientUid', 'style'=>'width:117px;','label'=>false, 'div' => false)); ?>
			</td>
			<?php }?>
			<td class="tdLabel"><?php echo __('Home Phone No.') ?>
			</td>
			<td><?php echo $this->Form->input('Person.home_phone', array('id' => 'home_phone', 'style'=>'width:118px;','maxLength'=>'10',
					 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'class'=>'validate["",custom[phone]] textBoxExpnd'));?>
			</td>
		</tr>
		<?php /*?> 	<tr id="show1" style="display: none">
			<td class="tdLabel" ><?php echo __('Ethnicity')?></td>
			<td><?php echo $this->Form->input('Person.ethnicity', array('class' => 'yello_bg textBoxExpnd','empty'=>__('Please Select'),'id' => 'ethnicity', 'style'=>'width:117px;','label'=>false, 'div' => false,	'options'=>array('2135-2:Hispanic or Latino'=>'Hispanic or Latino','2186-5:Not Hispanic or Latino'=>'Not Hispanic or Latino','UnKnown'=>'UnKnown','Denied to Specific'=>'Declined to specify'))); ?>
			</td>
			<td class=" tdLabel" ><?php echo __('Gender')?></td>
			<td><?php echo $this->Form->input('Person.sex', array('options'=>array(''=>__('Please Select'),'Male'=>__('Male'),'Female'=>__('Female')),
					'id' => 'gender', 'label'=> false,'class' => 'yello_bg textBoxExpnd	', 'div' => false, 'error' => false,'autocomplete'=>false));
			?>
			</td>
			<td class="tdLabel" ><?php echo __('Occupation')?></td>
			<td><?php echo $this->Form->input('Person.occupation', array('class' => 'yello_bg textBoxExpnd','id' => 'occupation','label'=>false, 'div' => false,'empty'=>'Please Select','options'=>configure::read('occupation'))); ?>
			</td>
			<td class="tdLabel" ><?php echo __('Legal Guardian/Health Care Proxy') ?>
			</td>
			<td><?php 
			echo $this->Form->input('Person.guar_first_name', array('id' => 'guar_first_name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'class'=>'yello_bg textBoxExpnd'));
			?>
			</td>
		</tr> 
		<tr id="show2" style="display: none">
			<td class="tdLabel" ><?php echo __('Health Insurance Information')?>
			</td>
			<td><?php echo $this->Form->input('Person.hidden_tariff_standard_id', array('id' => 'hidden_tariff_standard_id','label'=> false,'style'=>'width:117px;', 'div' => false, 'error' => false,'autocomplete'=>false,'class'=>'yello_bg textBoxExpnd','type'=>'text'));
			echo $this->Form->input('Person.tariff_standard_id',array('type'=>'hidden','id'=>'tariff_standard_id'));
			?>
			</td>
			<td class=" tdLabel"  width="12%"><?php echo __('Middle Name') ?>
			</td>
			<td width="12%"><?php echo $this->Form->input('Person.middle_name', array('id' => 'middle_name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'class'=>'textBoxExpnd'));?>
			</td>
			<td class="tdLabel" ><?php echo __('Primary Caregiver')?>
			</td>
			<td><?php echo $this->Form->input('Person.gau_first_name', array('id' => 'gau_first_name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'class'=>'yello_bg textBoxExpnd'));
			?>
			</td>
			<td class="tdLabel" ><?php echo __('Dates of Previous Clinical Visits')?>
			</td>
			<td style="float: left; width: 170px;"><?php 
			echo $this->Form->input('Person.form_received_on', array('id' => 'form_received_on','label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'class'=>'yello_bg textBoxExpnd'));
			?>
			</td>
		</tr>
		<tr id="show3" style="display: none">
			<td class="tdLabel" ><?php echo __('Race')?></td>
			<td><?php echo $this->Form->input('Person.race', array('class' => 'yello_bg textBoxExpnd','options'=>$race, 'multiple'=>'true','id' =>'race','style'=>'width:117px;','label'=>false, 'div' => false)); ?>
			</td>
			<td class="tdLabel" ><?php echo __('Preferred Lang')?>
			</td>
			<td><?php echo $this->Form->input('Person.language', array('id' => 'language','label'=> false, 'style'=>'width:126px;', 'div' => false, 'error' => false,'autocomplete'=>false,'options'=>$languages,'multiple'=>true,'class' => 'yello_bg textBoxExpnd'));?>
			</td>

			<td class="tdLabel" ><?php echo __('Presence of Adv Directives')?>
			</td>
			<td><?php  echo $this->Form->input('Person.is_directives', array('type'=>'checkbox','class' =>'yello_bg','id' => 'is_directives','value'=>'Y','legend'=>false,'label'=> false));?>
			</td>
			<td class=" tdLabel" ><?php echo __('Visit ID')?></td>
			<td><?php echo $this->Form->input('Person.mrn_no', array('id' => 'mrn_no', 'label'=> false, 'style'=>'width:108px', 'div' => false, 'error' => false,'autocomplete'=>false,'class'=>'textBoxExpnd'));?>
			</td>
			<!-- 	<td class="tdLabel" ><?php //echo __('Other Health Care Info') ?>
			</td>
			<td><?php //echo $this->Form->input('middle_name', array('id' => 'middle_name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'class'=>'textBoxExpnd'));
			?>
			</td> 
		</tr><?php */?>
		<tr class="">
			<td align="right" colspan="10"><span class="reset"><?php echo $this->Form->submit(__('Reset'),array('type'=>'button','id'=>'reset','class'=>'blueBtn','div'=>false,'label'=>false),array('alt'=>'Reset','title'=>'Reset'));?>
			</span> <?php echo $this->Form->submit(__('Continue'),array('id'=>'submit','class'=>'blueBtn','div'=>false,'label'=>false),array('alt'=>'Search','title'=>'Search'));?>
			</td>
		</tr>
	</tbody>
</table>
<div class="ht5"></div>
<div style="text-align: right;"><?php 
	$url= $this->Html->url(array('controller'=>'persons','action'=>'add'));
		//$url1= $this->Html->url(array('controller'=>'persons','action'=>'quickReg'));?>
	<?php //echo $this->Form->button(__('Quick Reg and Schedule'),array('url'=>$url1,'type'=>'button','escape' => false,'class'=>'blueBtn passData','id'=>'quickReg','style'=>'text-align:right;margin:0 6px 0 0;'));
	echo $this->Html->link(__('OPD Quick Reg and Schedule'),array('controller'=>'persons','action'=>'quickReg'),array('type'=>'button','escape' => false,'class'=>'blueBtn','id'=>'quickReg','style'=>'text-align:right;margin:0 6px 0 0;'));

	//if($showRegistrationButton)echo $this->Form->button(__('Patient Registration'),array('url'=>$url,'type'=>'button','id'=>'patientReg','class'=>'blueBtn passData','div'=>false,'label'=>false),array('alt'=>'Patient Registration','title'=>'Patient Registration'));
		echo $this->Html->link(__('Patient Registration'),array('controller'=>'persons','action'=>'add'),
				array( 'div'=>false,'label'=>false,'class'=>'blueBtn','type'=>'button','alt'=>'Patient Registration',
						'title'=>'Patient Registration'));
		?></div>
<!--<div style="text-align: right;" class="clr inner_title"></div>-->
<div  class="clr inner_title">
	
	<?php 

	/* if(isset($data) && !empty($data)){
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
		<td class="tdLabel" id="field" width="10%" title="Date of Birth"><?php echo  __('DOB', true); ?>
		</td>
		<!-- 	<td class="tdLabel"  width="5%"
			title="Social Security Number"><?php echo  __('AADHAR NO', true); ?>
		</td> -->
		<td class="tdLabel" width="10%" style="" title="Patient Name"><?php echo  __('Name', true); ?>
		</td>
		 <td class="tdLabel"  width="5%" title="Patient ID"><?php echo __('Patient ID', true); ?> 
		</td> 
		<td class="tdLabel center" width="10%" title="Patient ID"><?php echo __('Visit ID', true); ?>
		</td>
		<td class="tdLabel" width="10%" title="Patient ID"><?php echo __('Provider', true); ?>
		</td>
		<td class="tdLabel center" width="10%" title="Sex"><?php echo  __('Sex', true); ?>
		</td>
		<!-- <td class="tdLabel"  width="3%" title="Race"><?php echo  __('Race', true); ?>
		</td>
		<td class="tdLabel"  width="5%"
			style="text-align: center;" title="Ethnicity"><?php echo  __('Ethnicity', true); ?>
		</td> -->
		<!-- <td class="tdLabel"  width="5%" title="Preffered Language"><?php echo  __('Pref. Lang.', true); ?>
		</td> -->
		<td class="tdLabel" width="10%" style="text-align: center;"
			title="E-mail Address"><?php echo  __('E-mail', true); ?>
		</td>
		<!-- 	<td class="tdLabel"  width="5%" title="Occupation"><?php echo  __('Occupation', true); ?>
		</td> -->
		<td class="tdLabel" width="10%" style="text-align: center;"
			title="Mobile Number"><?php echo  __('Mobile', true); ?>
		</td>
		<td class="tdLabel" width="10%" style="text-align: center;"
			title="Dates of Previous Clinical Visits "><?php echo  __('Previous Visit', true); ?>
		</td>
		<!-- <td class="tdLabel"  width="12%"
			title="Legal Guardian/Health Care Proxy"><?php echo  __('Guardian Proxy', true); ?>
		</td>
		<td class="tdLabel"  width="5%" title="Primary Caregiver"><?php echo  __('Primary Caregiver', true); ?>
		</td> 
		<td class="tdLabel"  width="5%"
			title="Health Insurance Information"><?php echo  __('Insu. Info.', true); ?>
		</td>-->


		<?php //if($discharged){ ?>
		<td class="tdLabel" width="12%" title="Select Type of admission"><?php echo  __('Select Type of admission'); ?>
		</td>
		<?php //} ?>
		<!-- 
		<td class="tdLabel"  width="5%"><?php //if($Unmerge){ 
			//echo  __('UnMerge');
		//}else{ echo  __('Merge');
		//} ?>
		</td> -->
		<!-- <td class="tdLabel"  width="5%" title="Quick Visit"><?php// echo __("Quick Visit")?>
		</td> -->
		<td class="tdLabel" width="10%" title="View"><?php echo __("View")?>
		</td>
		<td class="tdLabel center" width="10%" title="Status"><?php echo __("Status")?>
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
	<td class="row_format "><?php echo $this->DateFormat->formatDate2LocalForReport($Persons['Person']['dob'],Configure::read('date_format'),false); ?>
	</td>
	<!-- <td  class="row_format "><?php// echo $Persons['Person']['ssn_us']; ?>
	</td> -->
	<?php $idPatient=$Persons['Patient']['id'];
	$uidperson=$Persons['Person']['patient_uid'];
	$role=$this->Session->read('role');?>

	<td class="row_format " style=""><?php
	/* if(($role == Configure::read('doctorLabel')||$role == Configure::read('nurseLabel')) && $idPatient != null) {
		echo $this->Html->link($Persons['Person']['full_name'],array('controller'=>'PatientsTrackReports','action'=>'sbar',$idPatient,'Summary'),array('alt'=>'Patient Name','title'=>'Name'));
	}else{
	if($Persons['Patient']['is_discharge'] || $Persons['Appointment']['status'] == 'Seen')
		echo $this->Html->link($Persons['Person']['full_name'],"javascript:gettoregistration('$uidperson','admissiontype_$i')",array('alt'=>'Patient Name','title'=>'Name'));
	else echo $Persons['Person']['full_name'];
	} */
	echo $Persons['Person']['full_name']; ?>
	</td>

	 <td  class="row_format "><?php echo $Persons['Person']['patient_uid']; ?>
	</td> 
	<td class="row_format " style="text-align: center;"><?php echo ucfirst($Persons['Patient']['admission_id']); ?>
	</td>
	<td class="row_format "><?php echo $Persons['DoctorProfile']['doctor_name']; ?>
	</td>

	<td class="row_format " style="text-align: center;"><?php echo ucfirst($Persons['Person']['sex']); ?>
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
	<!-- <td  class="row_format " style="text-align: center;"
		title="<?php //echo $raceString;?>"><?php if($raceString)echo substr($raceString,0,5).'...';?>
	</td>
	<?php // $increStrPos = (strtolower($Persons['Person']['ethnicity']) == 'denied to specific')? 0 : 1;?>
	<?php //$ethnicity = substr($Persons['Person']['ethnicity'],  strpos($Persons['Person']['ethnicity'], ':')+$increStrPos);//);?>
	<td  class="row_format" title="<?php // echo $ethnicity?>"><?php // if($ethnicity)echo substr($ethnicity,0,5).'...'; ?>
	</td> -->
	<!-- <td  class="row_format "><?php 
	if(!empty($Persons['Person']['language'])){
	$expLang=explode(',',$Persons['Person']['language']);
	}
	if(count($expLang)>0){
	for($k=0;$k<count($expLang);$k++){
	echo ucfirst($languages[$expLang[$k]])."<br>";
	}
	}?>
	</td> -->
	<td class="row_format"><?php echo $Persons['Person']['email']; ?>
	</td>
	<!-- <td  class="row_format "><?php echo ucfirst($Persons['Person']['occupation']); ?>
	</td> -->
	<td class="row_format " style="text-align: center;"><?php echo $Persons['Person']['mobile']; ?>
	</td>
	<td class="row_format center"><?php 
	if($Persons['Patient']['is_paragon']==1){
		echo $this->DateFormat->formatDate2LocalForReport($Persons['Patient']['form_received_on'],Configure::read('date_format'),false);
	}else{
		echo $this->DateFormat->formatDate2Local($Persons['Patient']['form_received_on'],Configure::read('date_format'),false);
	}



	//echo $this->DateFormat->formatDate2Local($Persons['Patient']['form_received_on'],Configure::read('date_format'),false);

	?>
	</td>
	<!-- <td  class="row_format "><?php //echo ucfirst($Persons['Guardian']['guar_first_name']); ?>
	</td>
	<td  class="row_format "><?php // echo ucfirst($Persons['Guarantor']['gau_first_name']); ?>
	</td> 
	<?php $insType = ($getDataInsuranceType[$Persons['Person']['insurance_type_id']]) ? $getDataInsuranceType[$Persons['Person']['insurance_type_id']] : ''; ?>
	<td  class="row_format" title="<?php echo ucfirst($insType); ?>">
	<?php if($insType)echo ucfirst(substr($insType,0,5)).'...'; ?>
	</td>
-->
	<?php //if($discharged){ ?>
	<!-- <td class="row_format "><?php //echo $this->Form->input('admission_type',array('empty'=>("Select admission type"),'options'=>array('OPD'=>'Ambulatory','IPD'=>'Impatient','emergency'=>'ER'),'id'=>'admissiontype_'.$i));?>
	</td> -->
	<?php //}?>
	<!-- <td  class="row_format " style="padding: 0 0 0 20px;"><?php  
	//echo $this->Form->checkbox('personId'.$Persons['Person']['id'], array('hiddenField'=>false,'value'=>$Persons['Person']['id'],'class' => 'selChk','id' => 'personId'.$Persons['Person']['id']));
	?>
	</td> -->
	<!-- <td align="center"><?php $status = ($Persons['Appointment']['status'] == 'Pending') ? 'Scheduled'  :  $Persons['Appointment']['status']; 
	
	if($status==='Seen' || $status==='Closed' || $status==='Scheduled' || $status== 'No-Show'){
	  		echo $this->Html->link($this->Html->image('icons/uerInfo.png',array('title'=>'Patient quick registration','style'=>'float: right;')),
	  			"javascript:pt_reg(".$Persons['Person']['id'].")",array('escape'=>false));
	  }
	  ?>
	</td> -->
	<!-- For Patient Reg by @7387737062-->
	<?php if($Persons['Patient']['is_discharge']=='0' or $Persons['Patient']['is_discharge']=='1' or empty($Persons['Patient']['id'])){ ?>
	<td id="boxSpace" class="row_format "><?php echo $this->Form->input('admission_type',array('empty'=>("Select admission type"),'options'=>array('OPD'=>'OPD','IPD'=>'IPD','RAD'=>'RADIOLOGY', 'emergency'=>'EMERGENCY','LAB'=>'LABORATORY'),'class'=>'admissiontype','personId'=>$Persons['Person']['id']));?>
	</td>
	<?php }else{?>
		<!-- For Patient Reg by @7387737062-->
	<td></td>
	<?php }?>
	<td style="padding: 0 0 0 20px;"><?php 
	echo $this->Html->link($this->Html->image('icons/view-icon.png',array('alt'=>__('View'),'title'=>__('view'))),
    		array('controller'=>'persons','action' => 'patient_information', $Persons['Person']['id']),
    		array('escape' => false,'title'=>'View'));
    ?>
	</td>
	<?php
// 	$status = ($Persons['Appointment']['status'] == 'Pending') ? 'Scheduled'  :  $Persons['Appointment']['status']; 
	
// 	if($status==='Seen' || $status==='Closed' || $status==='Scheduled' || $status== 'No-Show'){
// 	  		echo $this->Html->link($this->Html->image('icons/uerInfo.png',array('title'=>'Patient quick registration','style'=>'float: right;')),
// 	  			"javascript:pt_reg(".$Persons['Person']['id'].")",array('escape'=>false));
// 	  }
	  ?>
	<td class="row_format " style="text-align: center;"><?php echo $status;?>
	</td>
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
			/*var pager = new Pager('patientGrid', 20); 
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
			$('#prospect').click(function (){
				$('.patientProspectSearch').toggle();
				if($("#prospect").is(':checked')){
					
				}else{
					
				}
			});	
			$('#prospect_name').autocomplete({
				source: "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "personComplete","admin" => false,"plugin"=>false)); ?>",
				select: function(event,ui){			
				},
			 	messages: {
	         		noResults: '',
	         		results: function() {},
		   		},
			});
			$('#patient_name').autocomplete({
				source: "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "admissionComplete",'no',"admin" => false,"plugin"=>false)); ?>",
				select: function(event,ui){			
			},
			 messages: {
		         noResults: '',
		         results: function() {},
		   },
		});
			 $("#first_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Person","first_name",'null','null','null','null',"first_name","admin" => false,"plugin"=>false)); ?>", {
					width: 250,
					selectFirst: true
				});
			 $("#last_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Person","last_name",'null','null','null','null',"last_name","admin" => false,"plugin"=>false)); ?>", {
					width: 250,
					selectFirst: true
				});
			/* $("#mrn_no").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","admission_id",'null','null','null','null',"admission_id","admin" => false,"plugin"=>false)); ?>", {
					width: 250,
					selectFirst: true
				});*/

			 $("#mrn_no").autocomplete("<?php echo $this->Html->url(array("controller" => "Persons", "action" => "mrn_search","admission_id","plugin"=>false)); ?>", {
					width: 250,
					selectFirst: true
					});
		/*	 $("#doctor_id_txt").autocomplete({
					source: "<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "testcomplete","DoctorProfile",'user_id',"doctor_name",'null',"admin" => false,"plugin"=>false)); ?>", 
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

				
			$("#hidden_tariff_standard_id").autocomplete("<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "testcomplete","TariffStandard","id","name",'null',"admin" => false,"plugin"=>false)); ?>", {
							width: 250,
							selectFirst: true,
							valueSelected:true,
							showNoId:true,
							loadId : 'hidden_tariff_standard_id,tariff_standard_id'
						});	
				
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
			
			if($("#prospect").is(':checked')){
				$('.patientProspectSearch').toggle();	
			}
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
	/*$('.passData').click(function(){
		$('form').attr({"action": $(this).attr('url'), "method": 'POST'});
		$('#submit').trigger('click');
	});	*/


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

