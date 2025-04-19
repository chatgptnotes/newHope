<?php echo $this->Html->css(array('ros_accordian.css'));
?>
<?php echo $this->Html->script(array('jquery.selection.js','jquery.fancybox','inline_msg' )); ?>
<style>
.shift {
	color: #E7EEEF;
	font-size: 13px;
	text-align: right;
}

.clear img {
	clear: both;
}

#navc,#navc ul {
	padding: 0 0 5px 0;
	margin: 0;
	list-style: none;
	font: 15px verdana, sans-serif;
	border-color: #000;
	border-width: 1px 2px 2px 1px;
	background: #374043;
	position: relative;
	z-index: 200;
}

#navc {
	height: 35px;
	padding: 0;
	width: 350px;
	margin-left: -7px;
	margin-top: 70px;
}

#navc li {
	float: left;
}

#navc li li {
	float: none;
	background: #fff;
}

#swap_investigation {
	color: #FFFFFF;
}

* html #navc li li {
	float: left;
}

#navc li a {
	display: block;
	float: left;
	color: #fff;
	margin: 0 25px 0 10px;
	height: 35px;
	line-height: 12px;
	text-decoration: none;
	white-space: nowrap;
	font-size: 14px;
}

#navc li li a {
	height: 20px;
	line-height: 20px;
	float: none;
}

#navc ul {
	position: absolute;
	left: -9999px;
	top: -9999px;
}

* html #navc ul {
	width: 1px;
}

#navc li:hover li:hover>ul {
	left: -15px;
	margin-left: 100%;
	top: -1px;
}

#navc li:hover>ul ul {
	position: absolute;
	left: -9999px;
	top: -9999px;
	width: auto;
}

#navc li:hover>a {
	color: #fff;
}

.inter {
	display: block;
	height: 120px;
	overflow: visible;
	padding-bottom: 10px;
	padding-top: 10px;
}

.radio_check {
	border: none !important;
	padding: none !important;
}

/*
.radio_check label {
	float: inherit;
	line-height:32px!important;
	background:none;
}

.row_format label {
	float: inherit;
}
*/
.radio_check label {
	display: block !important;
	background: none;
	float: left;
	width: 210px !important;
	text-align: left;
	color: #000 !important;
}

.row_format label {
	width: 140px !important;
	text-align: left !important;
}

label {
	float: left;
	width: 135px !important;
	font-size: 12px;
	text-align: left;
}

#SelectRad {
	margin: 0 0 0 32px !important;
}

.ros_row .radio_check label {
	margin-right: 5px !important;
}

.tbl label {
	width: 35px !important;
}
.patientHub .patientInfo .heading {
	float: left;
	width: 174px;
}
</style>
<div class="inner_title">
	<h3>
		<?php echo __('Add Progress Notes'); ?>
	</h3>
</div>
<?php echo $this->element('patient_information');?>
<?php //debug($this->data);
echo $this->Form->create('Note',array('id'=>'patientnotesfrm','inputDefaults' => array('label' => false,'div' => false,'error'=>false)));
echo $this->Form->hidden('Note.id');
echo $this->Form->hidden('Patientsid',array('id'=>'Patientsid','value'=>$data['Patient']['id'],'autocomplete'=>"off"));
echo $this->Form->hidden('icdcode',array('id'=>'icdcode','value'=>'','autocomplete'=>"off"));
$note_type  = $this->data['Note']['note_type'] ;
$toBeBilled = ($note_type=='general') ? 'block' : 'none';
echo $this->Form->hidden('Note.flag',array('id'=>'flag','value'=>$flag));
?>
<!-- BOF new HTML -->
<?php
$options = array();
foreach($record as $d) {
 $options[$d['Note']['id']] = 'Dated: '.$d['Note']['create_time'];
} ?>

<table class="table_format" style="padding: 15px;">
	<tr>
		<td>
			<table class="table_format" style="padding: 15px;" id="schedule_form">
				<?php if($patient['Patient']['admission_type'] == 'IPD'){?>
				<tr>
					<td width="255px" class="tdLabel"><?php echo __('Other SOAP Notes In Same Encounter :');?>
					</td>
					<td width="59%"><?php echo $this->Form->input('encounter', array('options'=>$options,'empty'=>'Please select','id' => 'encounter','class'=>'textBoxExpnd')); ?>
					</td>
					<td></td>
				</tr>
				<?php } ?>
				<tr>
					<td width="255px" class="tdLabel"><?php echo __('Primary Care Provider :');?><font
						color="red">*</font>
					</td>
					<td width="59%"><?php 
					if(/*$this->Session->read('role') == Configure::read('doctor') && */empty($this->data['Note']['sb_registrar'])){
			//$this->request->data['Note']['doctor_id_txt'] = $patient['User']['first_name'].' '.$patient['User']['last_name'];//$this->Session->read('first_name').' '.$this->Session->read('last_name');
			$this->request->data['Note']['sb_registrar'] = $patient['Patient']['doctor_id'];//$this->Session->read('userid');
		}
		echo $this->Form->input('patientid', array('name'=>'patientid', 'type' => 'hidden','value'=>$data[Patient][id], 'id' => 'patientid' ));
		echo $this->Form->input('patient_id', array( 'type' => 'hidden','value'=>$data[Patient][id], 'id' => 'patient_id' ));
		//echo $this->Form->input('doctor_id_txt', array('style'=>' float:left;','id'=>'doctor_id_txt','value'=>$registrar[$this->data['Note']['sb_registrar']],'class'=>'validate[required,custom[mandatory-select]] textBoxExpnd'));
		echo $this->Form->input('sb_registrar', array('empty'=>__('Please Select'),'options'=>$registrar,'id'=>'sb_registrar','class'=>'validate[required,custom[mandatory-select]] textBoxExpnd'));
		?>
					</td>
				</tr>
				<tr>
					<td width="255px" class="tdLabel"><?php echo __('S/B Registrar :');?>
					</td>
					<td><?php
					echo $this->Form->input('sb_consultant', array('options'=>$consultant,'empty'=>'Please select','id' => 'sb_consultant','class'=>' textBoxExpnd' ));

					?>
					</td>
				</tr>
				<tr>
					<td width="255px" class="tdLabel"><?php echo __('Visit Type :');?>
						<font color="red">*</font>
					</td>
					<td><?php $visitTypes = Configure::read('patient_visit_type');
					echo $this->Form->input('visit_type_txt',array('id'=>'visit_type_txt','class'=>'validate[required,custom[mandatory-select]] textBoxExpnd','value'=>$visitTypes[$patient['Patient']['treatment_type']]));
					echo $this->Form->hidden('visit_type', array('type'=>'text','id'=>'visit_type','value'=>$patient['Patient']['treatment_type']));
					?>
					</td>
				</tr>
				<tr>
					<td width="255px" class="tdLabel"><?php echo __('Date :');?><font
						color="red">*</font>
					</td>
					<td><?php $currentDate= $this->DateFormat->formatDate2LocalForReport(date('Y-m-d H:i:s'),Configure::read('date_format'),false);
					echo $this->Form->input('note_date', array('type'=>'text','id' => 'note_date','value'=>$currentDate,'class'=>'textBoxExpnd validate[required,custom[mandatory-date]] DatePicker textBoxExpnd'));
					?>
					</td>
				</tr>
				<tr>
					<td width="255px" class="tdLabel"><?php echo __('Note Type :');?><font
						color="red">*</font>
					</td>
					<td><?php 

					$noteType= array('general'=>'General','pre-operative'=>'Pre Operative','OT'=>'OT','post-operative'=>'Post Operative','event'=>'Event','template-type'=>'Template Type');

					echo $this->Form->input('note_type', array('empty'=>'Please select','options'=>$noteType,'selected'=>'general', 'id' => 'note_type','class'=>'validate[required,custom[mandatory-select]] textBoxExpnd' ));
					?> <input type="hidden" name="authorname"
						value="<?php echo AuthComponent::user('first_name'); ?>" readonly />
					</td>
				</tr>
				<tr><td class="tdLabel"><?php //For doctor to decide the follow up schedule --Pooja
				echo $this->Form->input('has_no_followup',array('type'=>'checkbox','id'=>'followUp','label'=>false,'hiddenField'=>false));?>No Follow up Needed </td></tr>
				<!--  <tr width="255px" class="tdLabel">
		<td><?php /* echo $this->Form->hidden('Note.sign_note',array('id'=>'noteSign'));
		$idNote=$icdTrack[0]["Note"]["id"];
		echo $this->Form->hidden('nID',array('value'=>$idNote,'id'=>'nId'));
		echo __(''); */?></td>
		<td valign="top"><?php/*  if($icdTrack[0]['Note']['sign_note']=='1'){
			echo $this->Html->link($this->Html->image('icons/lock2.png',
				array('title' => 'UnSign Note', 'alt'=> 'UnSign Note')),'javascript:void(0)',array('class'=>'sendNote','id'=>'lock','escape'=>false)); */?>
			<?php /* echo $this->Html->link($this->Html->image('icons/view-icon2.png', array('id'=>'viewSign','title' => 'View Note', 'alt'=> 'Note View')), array('controller'=>'patientForms','action' => 'power_note',
					$data['Note']['id'],$patientid),array('escape'=>false)); */
		/* } */?></td>
	</tr>-->
				<!--  <tr id="to_be_billed_section" style="display: &amp;amp;">
		<td><?php echo __('To be Billed :');?></td>
		<td><?php echo $this->Form->checkbox('to_be_billed', array('class'=>'servicesClick','id' => 'to_be_billed'));?>
		 <input type="hidden" name="authorname" value="<?php echo AuthComponent::user('first_name'); ?>" readonly /></td>
	</tr>  -->
			</table>
		</td>
		<td valign="top" style="padding-top: 21px"><?php echo $this->Form->hidden('Note.sign_note',array('id'=>'noteSign'));
		$idNote=$icdTrack[0]["Note"]["id"];
		echo $this->Form->hidden('nID',array('value'=>$idNote,'id'=>'nId'));
		echo __('');?></td>
		<td valign="top" style="padding-top: 21px"><?php
		// if($icdTrack[0]['Note']['sign_note']=='1'){
		//if($role!=Configure::read('nurseLabel')){
//echo $this->Html->link($this->Html->image('icons/lock2.png',
			//	array('title' => 'Signed', 'alt'=> 'Signed')),'javascript:void(0)',array('class'=>'sendNote','id'=>'lock','escape'=>false));}?>
		</td>
		<td valign="top" style="padding-top: 21px"><?php //  echo $this->Html->link($this->Html->image('icons/view_new.jpg', array('id'=>'viewSign','title' => 'View Note', 'alt'=> 'Note View')), array('controller'=>'patientForms','action' => 'power_note',
					//$icdTrack[0]['Note']['id'],$patientid),array('escape'=>false));

		//}else{
//echo $this->Html->link($this->Html->image('icons/lock3.png',
				//array('title' => 'Sign Off', 'alt'=> 'Sign Off')),'javascript:void(0)',array('class'=>'sendNote','id'=>'lock','escape'=>false));

		//}?></td>
	</tr>
</table>
<table class="table_format" id="schedule_form">
	<tr>
		<td><?php $agecheck='0';

		$age= $data['Patient']['age'];// PAtient Age

		$d_age=$CDS_Data['0']['ClinicalSupport']['age'];// doctor select age

		$sign=$CDS_Data['0']['ClinicalSupport']['com_h'];// range seleted by doctor

		if(($CDS_Data['0']['ClinicalSupport']['Hyptension']=='1')){
//debug($sign);
			if($sign=='>'){


if(($age >=$d_age && $geticds == 'ok') && (($role=="Primary Care Provider") ||($role=="Admin"))){ ?>
			<ul id="navc">
				<li><a href="" id="cr">Hypertension Reminder </a>
					<ul id="navc">
						<li><?php echo $this->Html->link(__("Hypertension"),array("controller"=>"Patients","action"=>"showhypertension"),array("style"=>"color:black"));?>
						</li>
					</ul></li>
			</ul> <?php }
}?> <?php $agecheck='0';
if($sign=='<'){
if(($age <=$d_age && $geticds == 'ok') && (($role=="Primary Care Provider") ||($role=="Admin"))){ ?>
			<ul id="navc">
				<li><a href="" id="cr">Clinical Reminder 0/1 </a>
					<ul id="navc">
						<li><?php echo $this->Html->link(__("Hypertension"),array("controller"=>"Patients","action"=>"showhypertension"),array("style"=>"color:black"));?>
						</li>
					</ul></li>
			</ul> <?php }
}?> <?php $agecheck='0';
//echo $sign;
if($sign=='=='){
if(($age == $d_age && $geticds == 'ok') && (($role=="Primary Care Provider") ||($role=="Admin"))){ ?>
			<ul id="navc">
				<li><a href="" id="cr">Clinical Reminder 0/1 </a>
					<ul id="navc">
						<li><?php echo $this->Html->link(__("Hypertension"),array("controller"=>"Patients","action"=>"showhypertension"),array("style"=>"color:black"));?>
						</li>
					</ul></li>
			</ul> <?php }
}
}?>
		</td>
	</tr>

</table>
<?php

if($CDS_Data['0']['ClinicalSupport']['ccr']=='1' && $CDS_Data['0']['ClinicalSupport']['dr']=='1' && $geticds1!="" && $Diabetes!="" ){
//-------------conditions form the database---------------------------
$signc=$CDS_Data['0']['ClinicalSupport']['com_c'];
$signc1=$CDS_Data['0']['ClinicalSupport']['com_c1'];
$signd=$CDS_Data['0']['ClinicalSupport']['com_d'];
$signd1=$CDS_Data['0']['ClinicalSupport']['com_d1'];
//--------------------age form the database------------------------
$agec=$CDS_Data['0']['ClinicalSupport']['c_age'];
$agec1=$CDS_Data['0']['ClinicalSupport']['c_age1'];
$aged=$CDS_Data['0']['ClinicalSupport']['d_age'];
$aged1=$CDS_Data['0']['ClinicalSupport']['d_age1'];

if(($signc=='>' && $signc1=='<')||($signD=='>' && $signD1=='<')){// first conditions
if(($data >=$agec || $data <=$agec1 ) && $geticds1 == 'cancer'){
if($cancer=='Pap smear' || $cancer=='Human papillomavirus (HPV) 11 antigen detection'){?>
<ul id="navc">
	<li><a href="#nogo" id="cr"><font color="green">Cervial Cancer Reminder
				Recorded </font> </a>
	</li>
</ul>
<?php 
}
}
if(($data >=$aged || $data <=$aged1 ) && $geticds1 == 'cancer'){
if($cancer=='Hemoglobin A1c' || $cancer=='Glucose tolerance test'){?>
<ul id="navc">
	<li><a href="#nogo" id="cr"><font color="green">Clinical Reminder For
				Diabetes Recorded </font> </a>
	</li>
</ul>
<?php }
}

elseif((($data >=$agec && $data <=$agec1 )||($data >=$agec && $data <=$agec1 ) && $geticds1 == 'cancer' && $Diabetes == 'Diabetes') && (($role=="Primary Care Provider") ||($role=="Admin"))){ // display of the reminder for the first conditions?>
<ul id="navc">
	<li><a href="#nogo" style="color: #000" id="cr"><font color="red">Cervial
				Cancer and Diabetes Reminder</font> </a>
	</li>
</ul>

<?php }
}
elseif(($signc=='<' && $signc1=='>')||($signD=='<' && $signD1=='>')){ // display of the  second conditions
if(($data <=$agec || $data >=$agec1 ) && $geticds1 == 'cancer'){
if($cancer=='Pap smear' || $cancer=='Human papillomavirus (HPV) 11 antigen detection'){?>
<ul id="navc">
	<li><a href="#nogo" id="cr"><font color="green">Cervial Cancer Reminder
				Recorded </font> </a>
	</li>
</ul>
<?php 
}
}
if(($data <=$aged || $data >=$aged1 ) && $geticds1 == 'cancer'){
if($cancer=='Hemoglobin A1c' || $cancer=='Glucose tolerance test'){?>
<ul id="navc">
	<li><a href="#nogo" id="cr"><font color="green">Clinical Reminder For
				Diabetes Recorded </font> </a>
	</li>
</ul>
<?php }
}

elseif((($data >=$agec && $data <=$agec1 )||($data >=$agec && $data <=$agec1 ) && $geticds1 == 'cancer' && $Diabetes == 'Diabetes') && (($role=="Primary Care Provider") ||($role=="Admin"))){ // display of the reminder for the first conditions?>
<ul id="navc">
	<li><a href="#nogo" style="color: #000" id="cr"><font color="red">Cervial
				Cancer and Diabetes Reminder</font> </a>
	</li>
</ul>

<?php }
}
//---------------------------------------- end of both reminders-----------------------------------------
}

else{
$c_AGE=$CDS_Data['0']['ClinicalSupport']['c_age'];
$c_AGE1=$CDS_Data['0']['ClinicalSupport']['c_age1'];
$d_AGE=$CDS_Data['0']['ClinicalSupport']['d_age'];
$d_AGE1=$CDS_Data['0']['ClinicalSupport']['d_age1'];
//------------------------------condition for db---------------------------------------------------
$signc=$CDS_Data['0']['ClinicalSupport']['com_c'];
$signc1=$CDS_Data['0']['ClinicalSupport']['com_c1'];
$signd=$CDS_Data['0']['ClinicalSupport']['com_d'];
$signd1=$CDS_Data['0']['ClinicalSupport']['com_d1'];
//--------------------------------cancer reminder-----------------------------------------
if($CDS_Data['0']['ClinicalSupport']['ccr']=='1'){
//echo ('CCR');
if($signc =='>' && $signc1== '<'){
if(($data >=$c_AGE || $data <=$c_AGE1 ) && $geticds1 == 'cancer' && ($cancer=='Pap smear' || $cancer=='Human papillomavirus (HPV) 11 antigen detection')){?>
<ul id="navc">
	<li><a href="#nogo" id="cr"><font color="green">Cervial Cancer Reminder
				Recorded </font> </a>
	</li>
</ul>
<?php 
}
elseif((($data >=$c_AGE || $data <=$c_AGE1 ) && $geticds1 == 'cancer') && (($role=="Primary Care Provider") ||($role=="Admin"))){?>
<ul id="navc">
	<li><a href="#nogo" style="color: #000" id="cr"><font color="red"
			id='changecolor1'>Cervial Cancer Reminder</font> </a>
	</li>
</ul>
<?php }
}
}?>

<!--------------------------------Diabetes reminder--------------------------------------- -->
<?php 
if($CDS_Data['0']['ClinicalSupport']['dr']=='1'){

if($signd =='>' && $signd1== '<'){
if(($data >=$d_AGE || $data <=$d_AGE1 ) && ($cancer=='Hemoglobin A1c' || $cancer=='Glucose tolerance test')){
?>
<ul id="navc">
	<li><a href="#nogo" id="cr"><font color="green">Clinical Reminder
				Recorded Diabetes.</font> </a>
	</li>
</ul>
<?php 
}
elseif((($data >=$d_AGE || $data <=$d_AGE1 ) && ($Diabetes=='Diabetes')) && (($role=="Primary Care Provider") ||($role=="Admin"))){//$Diabetes == 'Diabetes'

//echo ($CDS_Data['0']['ClinicalSupport']['dr']); ?>
<ul id="navc">
	<li><a href="#nogo" style="color: #000" id="cr"><font color="red"
			id='changecolor'>Clinical Reminder For Diabetes.</font> </a>
	</li>
</ul>
<?php }
}
}
}?>
<?php
// set variable for edit form
if(isset($this->data['Note']['note_type'])){
		 	 	 $note_type  = $this->data['Note']['note_type'] ;
		 	 	 $gen_display  = 'none';
		 	 	 $pre_display  = 'none';
		 	 	 $other_display ='none';
		 	 	 $ot_display  = 'none';
		 	 	 $post_display  = 'none';
		 	 	 $template_display  = 'none';

		 	 	 if($note_type=='general'){
		 	 	 	$gen_display  = 'block';
		 	 	 }else if($note_type=='pre-operative'){
		 	 	 	$pre_display  = 'block';
		 	 	 }else if($note_type=='post-operative'){
		 	 	 	$post_display  = 'block';
		 	 	 }else if($note_type=='OT'){
		 	 	 	$ot_display  = 'block';
		 	 	 }else if($note_type=='Template Type'){
		 	 	 	$template_display  = 'block';
		 	 	 }else{
		 	 	 	$other_display ='block';
		 	 	 }
		 	 }else{
		 	 		$gen_display  = 'none';
		 	 		$pre_display  = 'none';
		 	 		$other_display ='none';
		 	 		$ot_display  = 'none';
		 	 		$post_display  = 'none';
		 	 		$template_display  = 'none';
		 	 }
		 	 ?>
<?php/*  if($icdTrack[0]['Note']['sign_note']=='1'){
$showAll='none';
}else{
$showAll='block';
				} */?>
<div
	id="accordionCust" class="accordionCust">



	<!-- BOF General Note type option -->
	<h3 style="display:'<?php echo $gen_display; ?>' &amp;amp;" id="present-cond-link">
		<a href="#">Vitals</a>
	</h3>

	<div class="section" id="present-cond">
		<div align="center" id='temp-busy-indicator-present-cond'
			style="display: none;">
			&nbsp;
			<?php echo $this->Html->image('indicator.gif', array()); ?>
		</div>
		<table width="100%" border="0" cellspacing="1" cellpadding="1"
			class="tbl" align="center">
			<tr>
				<td colspan='4' style="font-size:13px;"><?php 
				echo $this->Form->input('Use vitals from Initial Assessment',array('type'=>'checkbox','id'=>'assesmentVital','label'=>false,'hiddenField'=>false));
				?> Use vitals from Initial Assessment</td>
			</tr>
			<tr>
				<td valign="top" width="1%"><label> <?php echo __('Temp:');?>
				</label></td>
				<td valign="top" width="8%" id="boxSpace" class="tdLabel"><?php 
				echo $this->Form->input('temp',array('legend'=>false,'class' => 'validate[optional,custom[onlyNumber]]','label'=>false ,'id' => 'TEMP','size'=>5,'value'=>$temp));
				?> &#8457;</td>
				<td valign="top" width="1%"><label> <?php echo __('P.R:');?>
				</label></td>
				<td valign="top" width="8%" id="boxSpace" class="tdLabel"><?php	
				echo $this->Form->input('pr',array('legend'=>false,'class' => 'validate[optional,custom[integer]]','label'=>false,'id' => 'PR','size'=>5,'value'=>$pr));
				?>/Min</td>
				<td valign="top" width="1%"><label> <?php echo __('R.R:');?>
				</label></td>
				<td valign="top" width="8%" id="boxSpace" class="tdLabel"><?php	
				echo $this->Form->input('rr',array('legend'=>false,'class' => 'validate[optional,custom[integer]]','label'=>false,'id' => 'RR','size'=>5,'value'=>$rr));
				?>/Min</td>
				<td valign="top" width="1%"><label> <?php echo __('BP:');?>
				</label></td>
				<td valign="top" width="15%" id="boxSpace" class="tdLabel"><?php	
				echo $this->Form->input('Note.bpSysto',array('class' => 'validate[optional,custom[integer]]','legend'=>false,'label'=>false ,'id' => 'BPSysto','size'=>3,'autocomplete'=>'off','placeholder'=>'Systolic'))
				.'/'. $this->Form->input('Note.bpDysto',array('class' => 'validate[optional,custom[integer]]','legend'=>false,'label'=>false ,'id' => 'BPDysto','size'=>3,'autocomplete'=>'off','placeholder'=>'Diastolic'));
				?> mm/hg</td>
				<td valign="top" width="1%"><label> <?php echo __('SPO');?><sub>2</sub>:
				</label>
				</td>
				<td valign="top" width="13%" id="boxSpace" class="tdLabel"><?php	
				echo $this->Form->input('spo2',array('legend'=>false,'class' => 'validate[optional,custom[integer]]','label'=>false ,'id' => 'spo2','size'=>5,'value'=>$spo2));
				?>% in Room Air
				<?php $optionSPO=array('1.0 L/Min Oxygen'=>'1.0 L/Min Oxygen',
						'2.0 L/Min Oxygen'=>'2.0 L/Min Oxygen',
						'3.0 L/Min Oxygen'=>'3.0 L/Min Oxygen',
						'4.0 L/Min Oxygen'=>'4.0 L/Min Oxygen',
						'5.0 L/Min Oxygen'=>'5.0 L/Min Oxygen',
						'6.0 L/Min Oxygen'=>'6.0 L/Min Oxygen',
						'7.0 L/Min Oxygen'=>'7.0 L/Min Oxygen',
						'8.0 L/Min Oxygen'=>'8.0 L/Min Oxygen',
						'9.0 L/Min Oxygen'=>'9.0 L/Min Oxygen',
						'10.0 L/Min Oxygen'=>'10.0 L/Min Oxygen',
						'11.0 L/Min Oxygen'=>'11.0 L/Min Oxygen',
						'12.0 L/Min Oxygen'=>'12.0 L/Min Oxygen',
						'13.0 L/Min Oxygen'=>'13.0 L/Min Oxygen',
						'14.0 L/Min Oxygen'=>'14.0 L/Min Oxygen',
						'15.0 L/Min Oxygen'=>'15.0 L/Min Oxygen',
						)?>
 				<?php echo $this->Form->input('spo2_percentage',array('empty'=>__('Please Select'),'options'=>$optionSPO,'class' => 'validate[optional,custom[integer]]','label'=>false ,'id' => 'spo21','value'=>$spo2)); ?></td>
				<td valign="left" width="1%"><label> <?php echo __('Date:');?>
				</label></td>
				<td style="width: 12%" valign="top"><?php	
				if($this->request->data['Note']['vital_date']) {
				echo $this->Form->input('vital_date', array('type' => 'text','readonly'=>'readonly','class'=>'textBoxExpnd validate[required,custom[mandatory-date]] DatePicker textBoxExpnd','id' => 'vital_date', 'label'=> false,'div' => false, 'error' => false, 'value' => date("m/d/Y", strtotime($this->request->data['Note']['vital_date']))));
			} else {
					echo $this->Form->input('vital_date', array('type' => 'text','readonly'=>'readonly','class'=>'textBoxExpnd','id' => 'vital_date', 'label'=> false,'div' => false, 'error' => false, ));
                } ?>
				</td>
			</tr>
		 	<tr>
				<td valign="top" width="1%"><label> <?php echo __('Pain:');?>
				</label></td>
				<?php $optPain=array('Not recorded'=>'Not recorded',
						'0-No Pain'=>'0-No Pain',
						'1'=>'1',
						'2'=>'2',
						'3'=>'3',
						'4'=>'4',
						'5'=>'5',
						'6'=>'6',
						'7'=>'7',
						'8'=>'8',
						'9'=>'9',
						'10'=>'10',)?>
				<td valign="top" width="8%" id="boxSpace" class="tdLabel"><?php 
				echo $this->Form->input('pain',array('legend'=>false,'options'=>$optPain,'label'=>false ,'id' => 'Pain','value'=>$temp));
				?> </td>
				<td valign="top" width="1%"><label> <?php echo __('Location:');?>
				</label></td>
				<td valign="top" width="8%" id="boxSpace" class="tdLabel"><?php	
				echo $this->Form->input('location',array('legend'=>false,'label'=>false,'id' => 'Location','value'=>$pr));
				?></td>
				<td valign="top" width="1%"><label> <?php echo __('Duration:');?>
				</label></td>
				<td valign="top" width="8%" id="boxSpace" class="tdLabel"><?php	
				echo $this->Form->input('duration',array('legend'=>false,'label'=>false,'id' => 'Duration','value'=>$rr));
				?></td>
				<td valign="top" width="1%"><label> <?php echo __('Frequency: ');?>
				</label></td>
				<td valign="top" width="15%" id="boxSpace" class="tdLabel"><?php	
				echo $this->Form->input('Note.frequency',array('label'=>false ,'id' => 'Frequency','autocomplete'=>'off','placeholder'=>''));
				?></td>
			</tr> 
		</table>
	</div>

	<h3 style="display: &amp;amp;" id="chief-link">
		<a href="#">Chief complaints</a>
	</h3>
	<div class="section" id="chief">
		<div align="center" id='temp-busy-indicator-chief'
			style="display: none;">
			&nbsp;
			<?php echo $this->Html->image('indicator.gif', array()); ?>
		</div>
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			class="formFull formFullBorder">
			<tr>
				<td width="70%" align="left" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="20">&nbsp;</td>
							<td valign="top" colspan="3"><?php echo $this->Form->textarea('cc', array('id' => 'cc_desc','rows'=>'5','style'=>'width:98%','value'=>$CcFromDiagnosis)); ?><br />
								<a href="javascript:void(0);" onclick="callDragon('C')"
								style="text-align: left;"><font color="#000">Use speech
										recognition</font> </a>
							</td>
						</tr>
						<tr>
							<td align="right" style="padding-right: 15px" colspan="2"><?php echo $this->Form->checkbox('chiefChk', array('class'=>'servicesClick','id' => 'chiefChk','label'=>false,'checked'=>'','onclick'=>'javascript:display_chief()'));?>Use
								chief complaints from initial assessment</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
			
		</table>
	</div>
	<h3 style="display: &amp;amp;" id="subjective-link">
		<a href="#">Subjective</a>
	</h3>
	<div class="section" id="subjective">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			class="formFull formFullBorder">
			<tr>
				<td width="27%" align="left" valign="top">
					<div align="center" id='temp-busy-indicator-subjective'
						style="display: none;">
						&nbsp;
						<?php echo $this->Html->image('indicator.gif', array()); ?>
					</div>
					<div id="templateArea-subjective"></div>
				</td>
				<td width="70%" align="left" valign="top">

					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="20">&nbsp;</td>
							<td valign="top" colspan="4"><?php echo $this->Form->textarea('subject', array('id' => 'subjective_desc'  ,'rows'=>'19','style'=>'width:90%')); ?><br />
								<a href="javascript:void(0);" onclick="callDragon('S')"
								style="text-align: left;"><font color="#000">Use speech
										recognition</font> </a>
							</td>


						</tr>
						<tr>
							<td style="padding-left: 15px" colspan="2"><?php echo $this->Form->checkbox('pmh', array('class'=>'servicesClick','id' => 'pmh','label'=>false,'checked'=>'','onclick'=>'javascript:display_significant_history()'));?>Use
								default PMH of Patient</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
	<h3 style="display: &amp;amp;" id="review-link">

		<a href="#">Review Of System</a>
	</h3>
	<div class="section" id="ros">
		<div align="center" id='temp-busy-indicator-aids'
			style="display: none; padding-bottom: 20px;" class="row_format">
			&nbsp;
			<?php echo $this->Html->image('indicator.gif', array()); ?>
		</div>
		<table class="ros_row">
			<?php 
			$g=0;

			foreach($rosData as  $dataRos =>$datakey) {
				$g++ ;
				$newId= "reset-input".$g;
				$newName ="data[TemplateTypeContent][".$datakey['Template']['id']."]" ;
				?>
			<tr class="" style="margin-top: 10px; width: 100%;">
				<td class="row_format" style="border-bottom: 1px solid #424A4D;"><label><b><?php echo $datakey['Template']['category_name'] ?>
					</b> </label> <?php $name=$datakey['Template']['category_name']?>
				</td>
				<?php  
				$selectedOptions= unserialize($templateTypeContent[$datakey['Template']['id']]);

				foreach($datakey['TemplateSubCategories'] as $sub =>$subkey) {
					 	$subCategory=$selectedOptions[$subkey['id']];
					 	$color ='' ;
					 	if($subCategory == '1' ){
					 		$rosChked="checked";
					 		$subText=$subCategory;
					 		$color='green';
					 	}elseif( $subCategory == '2' ){
					 		$rosChked="";
					 		$color='red';
					 	} else{
					 		$rosChked="";
}

?>
				<td class="radio_check"
					style="width: 100%; display: inline; border-bottom: 1px solid #424A4D;">
					<?php 
					$name = "data[TemplateTypeContent][".$datakey['Template']['id']."][".$subkey['id']."]" ;
					if($subkey['sub_category']=='OTHER'){

							echo $this->Form->input($datakey['Template']['category_name'],array('type'=>'checkbox','label' => $subkey['sub_category'],$subkey['sub_category'], 'onclick'=>"setVal('".trim($subkey['sub_category'])."','".$newId."','".$datakey['Template']['id']."')",
											'value'=>$subCategory,'id'=>$datakey['Template']['category_name']."_".$subkey['sub_category'] ,'class'=>'rad'." ".$datakey['Template']['category_name'],
											'name'=>$name ,$att,'autocomplete'=>'off','multiple'=>'checkbox','legend'=>false,'for'=>$datakey['Template']['category_name']));
						}else{

							echo $this->Form->hidden($datakey['Template']['category_name'],array('type'=>'checkbox',$subkey['sub_category'],'label' => $subkey['sub_category'] ,'onclick'=>"setVal('".$subkey['id']."','".$newId."','".$datakey['Template']['id']."')",
									'id'=>$g.'_'.$sub."_" ,'class'=>'rad'." ".$datakey['Template']['category_name'],
									'value'=>$subCategory,'name'=>$name,$att,'autocomplete'=>'off','multiple'=>'checkbox','legend'=>false,'for'=>$datakey['Template']['category_name'],'class'=>'rad','checked'=>$rosChked));
						}
						?> <?php if($subkey['sub_category'] != 'OTHER'){ ?> <label class='dClick_Ros' id='<?php echo $g.'_'.$sub."_myid1"?>'
						style="background:<?php echo $color; ?>"><?php echo $subkey['sub_category'];?>
				</label> <?php }?>
				</td>
				<?php $display = ($subkey['sub_category'] == 'OTHER' && $rosChked == 'checked')? 'block': 'none'; ?>
				<?php } ?>
				<td style="display:<?php echo $display; ?>" id= '<?php echo $datakey['Template']['id'];?>'>
					<?php echo $this->Form->input('textBox',array('type'=>'text','name'=>"data[TemplateTypeContent][textbox][".$datakey['Template']['id']."]",'autocomplete'=>'off' ));?>
				</td>
				<?php 
				$subText="";
				?>
			</tr>
			<?php }?>
		</table>

	</div>
	<!-- EOF Review Of System -->
	<h3 style="display: &amp;amp;" id="objective-link">
		<a href="#">Objective</a>
	</h3>
	<div class="section" id="objective">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			class="formFull formFullBorder">
			<tr>
				<td width="27%" align="left" valign="top">
					<div align="center" id='temp-busy-indicator-objective'
						style="display: none;">
						&nbsp;
						<?php echo $this->Html->image('indicator.gif', array()); ?>
					</div>
					<div id="templateArea-objective"></div>
				</td>
				<td width="70%" align="left" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="20">&nbsp;</td>
							<td valign="top" colspan="4"><?php echo $this->Form->textarea('object', array('id' => 'objective_desc' , 'class'=>"tdInput" ,'data-nusa-concept-name'=>"findings"  ,'rows'=>'21','style'=>'width:90%')); ?><br />
								<a href="javascript:void(0);" onclick="callDragon('O')"
								style="text-align: left;"><font color="#000">Use speech
										recognition</font> </a>
							</td>

						</tr>

					</table>
				</td>
			</tr>
		</table>

	</div>
	<!-- BOF Review Of System Examination-->

	<h3 style="display: &amp;amp;" id="review-link">

		<a href="#">Systemic Examination</a>
	</h3>
	<div class="section" id="rose">
		<div align="center" id='temp-busy-indicator-aids'
			style="display: none; padding-bottom: 20px;" class="row_format">
			&nbsp;
			<?php echo $this->Html->image('indicator.gif', array()); ?>
		</div>
		<table class="rose_row">



			<?php 
			$g=0;

			foreach($roseData as  $dataRose =>$datakey) {
				$g++ ;
				$newId= "reset-input-examination".$g;
				$newName ="data[subCategory_examination][".trim($datakey['Template']['id'])."]" ;
				//	debug($templateTypeContent[$datakey['Template']['category_name']]);
				?>
			<tr class="" style="margin-top: 10px; width: 100%;">
				<td class="row_format" style="border-bottom: 1px solid #424A4D;"><label><b><?php echo $datakey['Template']['category_name'] ?>
					</b> </label>
				</td>
				<?php    
				$selectedOptions= unserialize($templateTypeContent[$datakey['Template']['id']]);
				foreach($datakey['TemplateSubCategories'] as $sub =>$subkey) {
						$subCategory=$selectedOptions[$subkey['id']];
						$color ='' ;
						//if($datakey['Template']['id']==27) pr($selectedOptions) ;
						if($subCategory == '1' ){
				$rosChked="checked";
				$subText=$subCategory;
				$color='green';
			}elseif( $subCategory == '2' ){
				 $rosChked="";
				 $color='red';
				} else{
			 $rosChked="";
}
?>
				<td class="radio_check" id="radiocheck"
					style="width: 100%; display: inline; border-bottom: 1px solid #424A4D;">
					<?php  

					//$att=array('legend'=>false,'for'=>$datakey['Template']['category_name'],'class'=>'rad','checked'=>$rosChked);
					//$name = "data[Category2][se_".$datakey['Template']['category_name']."]" ;
					$name = "data[subCategory_examination][".$datakey['Template']['id']."][".$subkey['id']."]" ;
					if(trim($subkey['sub_category'])=='OTHER'){
							echo $this->Form->input($datakey['Template']['category_name'],array($subkey['sub_category'] ,'label' => $subkey['sub_category'],'type'=>'checkbox',
											'onclick'=>"setVal('".trim($subkey['sub_category'])."','".$newId."','".$datakey['Template']['id']."')",
											'id'=>$datakey['Template']['category_name']."_SE_".$subkey['sub_category'] ,'class'=>'rad',
											'value'=>$subCategory,'name'=>$name ,'autocomplete'=>'off','multiple'=>'checkbox'));
						}else{
							echo $this->Form->hidden($datakey['Template']['category_name'],array($subkey['sub_category'],'label' => $subkey['sub_category'],'type'=>'checkbox',
									'onclick'=>"setVal('".$subkey['id']."','".$newId."','".$datakey['Template']['id']."')",
									'id'=>$dataRose.'_'.$sub,'class'=>'rad',
									'value'=>$subCategory,'name'=>$name,'checked'=>$rosChked,'autocomplete'=>'off','multiple'=>'checkbox'));
						}
						?> <?php if(trim($subkey['sub_category']) != 'OTHER'){ ?> <label class='dClick'
			id='<?php echo $dataRose.'_'.$sub."_myid"?>' style="background:<?php echo $color; ?>"><?php echo $subkey['sub_category'];?>
				</label> <?php }?>
				</td>
				<?php } ?>
				<td style="display:<?php echo $display; ?>" id= '<?php echo $datakey['Template']['id'];?>'>
					<?php echo $this->Form->input('textBox',array('type'=>'text','name'=>"data[subCategory_examination][textbox2][".$datakey['Template']['id']."]",'autocomplete'=>'off' ));?>
				</td>
				<?php 
				//echo $this->Form->hidden('',array('name'=>$newName,'id'=>$newId,'value'=>$subText,'autocomplete'=>'off'));
				$subText="";
				?>
			</tr>
			<?php }?>
		</table>
	</div>


	<h3 style="display: &amp;amp;" id="assessment-link">
		<a href="#">Assessment</a>
	</h3>
	<div class="section" id="assessment">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			class="formFull formFullBorder">
			<tr>
				<td width="27%" align="left" valign="top">
					<div align="center" id='temp-busy-indicator-assessment'
						style="display: none;">
						&nbsp;
						<?php echo $this->Html->image('indicator.gif',array()); ?>
					</div>
					<div id="templateArea-assessment"></div>
				</td>
				<td width="70%" align="left" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="20">&nbsp;</td>
							<td valign="top" colspan="4"><?php echo $this->Form->textarea('assis', array('class' => 'textBoxExpnd','id' =>'assessment_desc','class'=>"tdInput" ,'data-nusa-concept-name'=>"impression",'style'=>'width:98%','rows'=>'20')); ?><br />
								<a href="javascript:void(0);" onclick="callDragon('A')"
								style="text-align: left;"><font color="#000">Use speech
										recognition</font> </a>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td width="27%" align="left" valign="top"><?php //echo "<pre>";print_r($icdTrack); //----------old construct for no active diagnosis
				if($icdTrack == 0 ){
								echo $this->Form->input('Note.icd_record', array('type'=>'checkbox','hiddenField' => false,'value'=>'1','id'=>'nojschkbox'));
							}else
							{  echo $this->Form->input('Note.icd_record', array('type'=>'checkbox','hiddenField' => false,'value'=>'1','id'=>'chkbox'));
							}
							?> &nbsp;No Active Diagnoses</td>
				<td width="70%" align="left" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td align="left" valign="top">ICD Code&nbsp;<?php echo $this->Html->link($this->Html->image('icons/search_icon.png',array('title'=>'Search ICD Code')),
					  			"javascript:icdwin()",array('escape'=>false));?>
							</td>
							<td width="30" align="left">&nbsp;</td>
						</tr>
						<tr>
							<td colspan="2" class="tempHead row_format"><?php echo $this->Form->input('icd',array('type'=>'hidden','id'=>'icd_ids'));
							echo $this->Form->hidden('notediagnosis_id',array('type'=>'text','id'=>'notediagnosis_id'));
							if(empty($this->data['Note']['icd'])){
			              	  				$displayICD ="none";
			              	  			}else{
			              	  				$displayICD ="block";
			              	  			} ?>
								<div id="icdSlc" style="display: &amp;amp;">
									<?php

									for($i=0;$i<count($getdiagnoses_name);$i++){
										$id = $getdiagnoses_name[$i]['NoteDiagnosis']['id'];
										echo '<p style="padding:0px 10px;" id="icd_'.$id.'">';
										?>
									<?php echo $this->Html->image('/img/icons/cross.png',array("align"=>"right","id"=>"ers_$id","onclick"=>"javascript:remove_icd(\"".$id."\");","title"=>"Remove","style"=>"cursor: pointer;","alt"=>"Remove","class"=>"icd_eraser defaultLoad"));?>
									<?php echo $getdiagnoses_name[$i]['NoteDiagnosis']['diagnoses_name']."<br/>";
									echo $this->Form->input('ICD_code_count',array('type'=>'hidden','id'=>'icd_ids_count','value'=>$id));
									echo "</p>";
									}
									?>
								</div>
							</td>
						</tr>
					</table>
				</td>
				<td>&nbsp;</td>
			</tr>
		</table>
	</div>



	<h3 style="display: &amp;amp;" id="investigation-link">
		<a href="#">Investigation</a>
	</h3>

	<div class="section" id="CPOE" style="color: #fff;">
		<div align="center" id='temp-busy-indicator1' style="display: none;">
			&nbsp;
			<?php echo $this->Html->image('indicator.gif', array()); ?>
		</div>
		<!-- --Not  Blank  Code for Lab And Rad Orders display's here-- -->
	</div>

	<!-- 

	<h3 style="display: &amp;amp;" id="study-result">
		<a href="#">Diagnostic Study Results</a>
	</h3>
	<div class="section" id="diagnostic-study">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			class="formFull formFullBorder">
			<tr>
				<td width="27%" align="left" valign="top">
					<div align="center" id='temp-busy-indicator-diagnostic-study'
						style="display: none;">
						&nbsp;
						<?php //echo $this->Html->image('indicator.gif', array()); ?>
					</div>
					<table width="100%" cellpadding="0" cellspacing="1" border="0"
						class="tabularForm">
						<tr>
							<td valign="top">
								<table width="100%" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td width="60" class="tdLabel2"><strong>Search :</strong></td>
										<td width="400" cellpadding:right='200px'><?php 
										//echo $this->Form->input('DignosticStudy.searchProcedure', array('class' => 'textBoxExpnd','style'=>'padding:7px 10px;','id'=>'searchProcedure','autocomplete'=>'true','label'=>false,'div'=>false));
										?></td>
										<td width="" colspan="4"><?php 
									//	echo $this->Html->link(__('Search'),"javascript:void(0)",array('class'=>'blueBtn','onclick'=>'javascript:snomed_problem()'));
										?>
										</td>
										<td width="60" class="tdLabel2"><?php //echo __('Search Result :');?>
										</td>
										<td width="" colspan="4"><?php 
									//	echo $this->Form->input('DignosticStudy.toTest',array('empty'=>__('Select'),'options'=>'','escape'=>false,'multiple'=>false,'value'=>'',
	                                //  		'style'=>'width:400px;','id'=>'procedure','label'=>false,'div'=>false,'empty'=> 'Please Select','onChange'=>'javascript:LoadProcedure()'));
						               ?>
										</td>
									</tr>
									<tr>
										<td colspan="6"></td>
										<td align="left"><?php //echo __('OR')?></td>
									</tr>
									<tr>
										<td width="167" class="tdLabel2"><?php //echo __('Procedure Name');?><font
											color="red">*</font>
										</td>
										<td width="400" class="tdLabel2" colspan="4"><?php /*echo $this->Form->input('DignosticStudy.procedure_description',array('style'=>'width:373px;','id'=>'Procedure_description','readonly'=>'readonly'));
										echo $this->Form->hidden('DignosticStudy.test_code',array('id'=>'test_code','type'=>'text'));
										echo $this->Form->hidden('DignosticStudy.loinc_code',array('id'=>'loinc_code','type'=>'text'));
										echo $this->Form->hidden('DignosticStudy.snomed_code',array('id'=>'snomed_code','type'=>'text'));
										echo $this->Form->hidden('DignosticStudy.cpt_code',array('id'=>'cpt_code','type'=>'text'));
										echo $this->Form->hidden('DignosticStudy.id',array('id'=>'dignostic_id','type'=>'text'));*/
										?>
										</td>
										<td width=""></td>
										<td width="129" class="tdLabel2"><?php //echo __('Alternate result :');?>
										</td>
										<td><?php //echo $this->Form->input('DignosticStudy.dbprocedure',array('empty'=>__('Select'),'options'=>$diagnosticStatus,'escape'=>false,'multiple'=>false,'value'=>'',
												//'style'=>'width:400px;','id'=>'dbprocedure','label'=>false,'div'=>false,'empty'=> 'Please Select','onChange'=>'javascript:dbProblem("digresult")'));
										?></td>
									</tr>
									<tr>
										<td width="40"><?php //echo __('Procedure Date :');?><font color="red">*</font></td>
										<td width="100" class="tdLabel2" align="right" colspan="5"><?php 
										//echo $this->Form->input('DignosticStudy.procedure_date',array('class'=>'textBoxExpnd DatePicker','style'=>'width:120px','type'=>'text','id'=>'procedure_date'));
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
							<td width="14%" style="padding-left: 15px"><?php // echo __('Diagnostic Note :');?></td>
							<td valign="top" colspan="4"><?php //echo $this->Form->textarea('DignosticStudy.instruction', array('id' => 'procedure_instruction'  ,'rows'=>'4','style'=>'width:97%')); ?>
							</td>
						</tr>
						<tr>

							<td width="14%" style="padding-left: 3px"><label> <?php //echo __('VTE Advice ');?>:
							</label></td>
							<td><?php //echo $this->Form->checkbox('DignosticStudy.vte_confirm', array('id' => 'vte_confirm', )); ?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td colspan='4' align='right' valign='bottom'><?php  //echo $this->Html->link(__('Submit'),"javascript:void(0)",array('id'=>'proceduresubmit','class'=>'blueBtn','onclick'=>"javascript:save_procedure()")); ?>
				</td>
			</tr>
			<tr>
				<td>
					<table border="0" class="table_format" cellpadding="0"
						cellspacing="0" width="100%" style="text-align: center;">
						<?php //if(isset($studyResult) && !empty($studyResult)){ ?>
						<tr class="row_title">
							<td class="table_cell"><strong> <?php //echo  __('Test Name', true); ?>
							</strong></td>
							<td class="table_cell"><strong> <?php //echo  __('Loinc Code', true); ?>
							</strong></td>
							<td class="table_cell"><strong> <?php //echo  __('Snomed Code', true); ?>
							</strong></td>
							<td class="table_cell"><strong> <?php //echo  __('Procedure Date', true); ?>
							</strong></td>
							<td class="table_cell"><strong> <?php //echo  __('Action'); ?>
							</strong></td>
						</tr>
						<?php
						/*$toggle =0;
						if(count($studyResult) > 0) {
									foreach($studyResult as $studyResult){
											 if(!empty($studyResult)) {
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
										   //status of the report*/
										   ?>

						<td class="row_format"><?php //echo $studyResult['DignosticStudy']['procedure_description']; ?>
						</td>
						<td class="row_format"><?php //echo $studyResult['DignosticStudy']['loinc_code']; ?>
						</td>
						<td class="row_format"><?php //echo $studyResult['DignosticStudy']['snomed_code']; ?>
						</td>

						<td class="row_format"><?php //echo $this->DateFormat->formatDate2Local($studyResult['DignosticStudy']['procedure_date'],Configure::read('date_format_us'),false); ?>
						</td>
						<td class="row_format" style="text-align: center;"><?php //$result_id = $studyResult['DignosticStudy']['id'];
						//echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete', 'onclick'=>"delete_procedure($result_id);return false;")), array(), array('escape' => false));
						//echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('title'=>'Edit','alt'=>'Edit', 'onclick'=>"edit_procedure($result_id);return false;")), array(), array('escape' => false));
						?>
						</td>
						</tr>
						<?php /* } 
						}
										} else {
					 */?>
						<tr>
							<TD colspan="5" align="center" class="error"><?php //echo __('No Diagnostic Study Results for selected patient', true); ?>.
							</TD>
						</tr>
						<?php //} ?>
					</table>
				</td>
			</tr>
		</table>
	</div>-->


	<h3 style="display: &amp;amp;" id="implants-link">
		<a href="#">Implants</a>
	</h3>
	<div class="section" id="implants">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			class="formFull formFullBorder">
			<tr>
				<td width="27%" align="left" valign="top">
					<div align="center" id='temp-busy-indicator-implants'
						style="display: none;">
						&nbsp;
						<?php echo $this->Html->image('indicator.gif', array()); ?>
					</div>
					<div id="templateArea-implants"></div>
				</td>
				<td width="70%" align="left" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="20">&nbsp;</td>
							<td valign="top" colspan="4"><?php echo $this->Form->textarea('implants', array('id' => 'implants_desc'  ,'rows'=>'22','style'=>'width:90%')); ?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>


	<?php if($patient['Patient']['admission_type'] == 'OPD'){?>

	<h3 style="display: &amp;amp;" id="treatment-link">
		<a href="#">Treatment Advised</a>
	</h3>
	<div class="section" id="treatment">
		<div align="center" id='temp-busy-indicator-treatment'
			style="display: none;">
			&nbsp;
			<?php echo $this->Html->image('indicator.gif', array()); ?>
		</div>
		<!--BOF medicine  -->
		<table class="" style="text-align: left; padding: 0px !important"
			width="100%">
			<tr>
				<td width="100%" valign="top" align="left" style="padding: 2px;"
					colspan="4">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<!-- row 1 -->
						<tr>
							<td width="100%" valign="top" align="left" colspan="6">
								<table width="100%" border="0" cellspacing="0" cellpadding="0"
									id='DrugGroup' class="" style="padding: 0px !important">
									<tr>
										<td width="100%" colspan='14'>
											<div class="message" id='successMsg'
												style='display: none; color: green; text-align: center'>
												<!-- Show  sevirity  -->
											</div>
										</td>
									</tr>

									<!-- ALL DEVELOPER ITS INTERACTION DO NOT COMMENT OR DELETE -->
									<tr>
										<td width="100%" colspan='14'>
											<div id='showsevirity' style='display: none; color: #cc3333'>
												<!-- Show  sevirity  -->
											</div>
										</td>
									</tr>

									<tr>
										<td width="100%" colspan='14'>
											<div id='interactionData'
												style='display: none; color: #cc3333'>
												<!-- interaction Data  -->
											</div>
										</td>
									</tr>

									<tr>
										<td width="50%" colspan='2'>
											<div id='overRide' style='display: none;'>
												<?php
												echo $this->Form->input(__('Override Instructions'),array('id'=>'overText','type'=>'text'));?>
											</div>
										</td>
										<td width="50%" colspan='14'>
											<div id='overRideButton' style='display: none;'>
												<?php $isOverride='1';
												echo $this->Form->submit(__('Override Instructions'),array('id'=>'oversubmit','class'=>'blueBtn','onclick'=>"javascript:save_med(".$isOverride.");return false;"));?>
											</div>
										</td>
									</tr>

									<tr>
										<td width="8%" height="20" align="left" valign="top"
											style="padding-right: 3px;" class="tdLabel">Drug Name</td>
										<td width="5%" height="20" align="left" valign="top"
											class="tdLabel">Dose</td>
										<td width="5%" height="20" align="left" valign="top"
											class="tdLabel">Form</td>
										<td width="5%" height="20" align="left" valign="top"
											class="tdLabel">Route</td>
										<td width="5%" align="left" valign="top" class="tdLabel">Frequency</td>
										<td width="3%" align="left" valign="top" class="tdLabel">Days</td>
										<td width="3%" align="left" valign="top" class="tdLabel">Qty</td>
										<td width="5%" align="left" valign="top" class="tdLabel">Refills</td>
										<td width="5%" align="center" valign="top" class="tdLabel">PRN</td>
										<td width="5%" align="center" valign="top" class="tdLabel">DAW</td>
										<td width="10%" align="center" valign="top" class="tdLabel">First
											Dose Date/Time</td>
										<td width="10%" align="center" valign="top" class="tdLabel">Stop
											Date/Time</td>
										<td width="8%" align="center" valign="top" class="tdLabel">Special
											Instruction</td>
										<td width="5%" align="center" valign="top" class="tdLabel">Is
											Active</td>
										<td width="5%" align="center" valign="top" class="tdLabel"
											title="Medication to be administered in clinic">Administered
											in Clinic?</td>
									</tr>
									<?php  
									if(isset($this->data['drug']) && !empty($this->data['drug'])){
			               				$count  = count($this->data['drug']) ;
			               			}else{
			               				$count  = 3 ;
			               			}
			               			for($i=0;$i<$count;){
										//debug($this->data['drug_id'][$i]);
			               				$drugValue= isset($this->data['drug'][$i])?$this->data['drug'][$i]:'' ;
			               				$drugId= isset($this->data['drug_id'][$i])?$this->data['drug_id'][$i]:'' ;
			               				$pack= isset($this->data['drug'][$i])?$this->data['pack'][$i]:'' ;
			               				$start_date=isset($this->data['start_date'][$i])?$this->DateFormat->formatDate2Local($this->data['start_date'][$i],Configure::read('date_format'),true):''  ;
			               				$end_date=isset($this->data['end_date'][$i])?$this->DateFormat->formatDate2Local($this->data['end_date'][$i],Configure::read('date_format'),true):'' ;
			               				$routeValue= isset($this->data['route'][$i])?$this->data['route'][$i]:'' ;
			               				$doseValue= isset($this->data['dose'][$i])?$this->data['dose'][$i]:'' ;
			               				$frequencyValue = isset($this->data['frequency'][$i])?$this->data['frequency'][$i]:'' ;
			               				$quantity = isset($this->data['quantity'][$i])?$this->data['quantity'][$i]:'' ;

			               				$strengthValue=isset($this->data['strength'][$i])?$this->data['strength'][$i]:'' ;
			               				$dayvalue=isset($this->data['day'][$i])?$this->data['day'][$i]:'' ;
			               				$refillsvalue=isset($this->data['refills'][$i])?$this->data['refills'][$i]:'' ;

			               				$prnValue=isset($this->data['prn'][$i])?$this->data['prn'][$i]:'' ;
			               				$dawValue=isset($this->data['daw'][$i])?$this->data['daw'][$i]:'1' ;
			               				$is_activevalue=isset($this->data['isactive'][$i])?$this->data['isactive'][$i]:'' ;
			               				$special_instruction_value=isset($this->data['special_instruction'][$i])?$this->data['special_instruction'][$i]:'' ;

			               				$firstValue= isset($this->data['first'][$i])?$this->data['first'][$i]:'' ;
			               				$secondValue= isset($this->data['second'][$i])?$this->data['second'][$i]:'' ;
			               				$thirdValue = isset($this->data['third'][$i])?$this->data['third'][$i]:'' ;
			               				$forthValue = isset($this->data['forth'][$i])?$this->data['forth'][$i]:'' ;


			               				$first  ='disabled';
			               				$second ='disabled';
			               				$third  = 'disabled';
			               				$forth  ='disabled';
			               				$hourDiff =0;
			               				//set timer
			               				switch($frequency){
			               					case "OD":
			               						$first ='enabled';
			               						break;
			               					case "BD":
			               						$hourDiff =  12;
			               						$first ='enabled';
			               						$second = 'enabled';
			               						break;
			               					case "TDS":
			               						$hourDiff = 6 ;
			               						$first ='enabled';
			               						$second = 'enabled';
			               						$third = 'enabled';
			               						break;
			               					case "QID":
			               						$hourDiff = 4 ;
			               						$first ='enabled';
			               						$second = 'enabled';
			               						$third = 'enabled';
			               						$forth = 'enabled';
			               						break;
			               					case "HS":
			               						$first ='enabled';
			               						break;
			               					case "Twice a week":
			               						$first ='enabled';
			               						break;
			               					case "Once a week":
			               						$first ='enabled';
			               						break;
			               					case "Once fort nightly":
			               						$first ='enabled';
			               						break;
			               					case "Once a month":
			               						$first ='enabled';
			               						break;
			               					case "A/D":
			               						$first ='enabled';
			               						break;
			               				}
			               				//EOF timer
			               				?>
									<tr id="DrugGroup<?php echo $i;?>">
										<td align="left" valign="top" style="padding-right: 3px"><?php// echo $i;?>
											<?php echo $this->Form->input('', array('type'=>'text','class' => 'drugText' ,'id'=>"drugText_$i",'name'=> 'drugText[]','value'=>$drugValue,'autocomplete'=>'off','counter'=>$i,'style'=>'width:150px')); 
											echo $this->Form->hidden("",array('id'=>"drug_$i",'name'=>'drug_id[]','value'=>$drugId));
											?>
										</td>
										<td align="left" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array('empty'=>'Select','options'=>$dose,'style'=>'width:80px','class' => '','id'=>"dose_type$i",'name' => 'dose_type[]','value'=>$doseValue)); ?>
										</td>

										<td align="left" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array('empty'=>'Select','options'=>$strenght,'style'=>'width:80px','class' => '','id'=>"strength$i",'name' => 'strength[]','value'=>$strengthValue));?>
										</td>

										<td align="left" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array('empty'=>'Select','options'=>$route,'style'=>'width:80px','class' => '','id'=>"route_administration$i",'name' => 'route_administration[]','value'=>$routeValue)); ?>
										</td>

										<td align="left" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array('empty'=>'Select','options'=>Configure :: read('frequency'),'style'=>'width:80px','class' => '','id'=>"frequency$i",'name' => 'frequency[]','value'=>$frequencyValue)); ?>
										</td>

										<td align="left" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array('size'=>2,'type'=>'text','class' => '','id'=>"day$i",'name' => 'day[]','value'=>$dayvalue)); ?>
										</td>

										<td align="left" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array('size'=>2,'type'=>'text','class' => '','id'=>"quantity$i",'name' => 'quantity[]','value'=>$quantity)); ?>
										</td>

										<td align="left" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array( 'options'=>Configure :: read('refills'),'empty'=>'Select','style'=>'width:80px','class' => '','id'=>"refills$i",'name' => 'refills[]','value'=>$refillsvalue));  ?>
										</td>

										<td align="center" valign="top" style="padding-right: 3px"><?php $options = array('0'=>'No','1'=>'Yes');
										echo $this->Form->input('', array( 'options'=>$options,'class' => '','id'=>"prn$i",'name' => 'prn[]','value'=>$prnValue));?>
										</td>

										<td align="center" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array( 'options'=>$options,'class' => '','id'=>"daw$i",'name' => 'daw[]','value'=>$dawValue));?>
										</td>

										<td align="center" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array('type'=>'text','size'=>16, 'class'=>'my_start_date1 textBoxExpnd','name'=> 'start_date[]','value'=>$start_date, 'id' =>"start_date".$i ,'counter'=>$count )); ?>
										</td>

										<td align="center" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array('type'=>'text','size'=>16,'class'=>'my_end_date1 textBoxExpnd','name'=> 'end_date[]','value'=>$end_date,'id' => "end_date".$i,'counter'=>$count)); ?>
										</td>

										<td align="center" valign="top"><?php echo $this->Form->textarea('', array('size'=>2,'type'=>'text','class' => '','id'=>"special_instruction$i",'name' => 'special_instruction[]','value'=>$special_instruction_value));?>
										</td>

										<td align="center" valign="top" style="padding-right: 3px"><?php $options_active = array('1'=>'Yes','0'=>'No');
										echo $this->Form->input('', array( 'options'=>$options_active,'class' => '','id'=>"isactive$i",'name' => 'isactive[]','value'=>$is_activevalue));?>
										</td>
										<td align="center" valign="top" style="padding-right: 3px"><?php $options_avd = array('0'=>'No','1'=>'Yes');
										echo $this->Form->input('', array( 'options'=>$options_avd,'class' => '','id'=>"isadv$i",'name' => 'isadv[]','value'=>""));?>
										</td>
									</tr>
									<?php
									$i++ ;
			               			}
			               			?>

								</table>
							</td>
						</tr>
						<!-- row 3 end -->
						<tr>
							<td>&nbsp;</td>
							<td align="right" colspan="5"
								style="margin-top: 10px; float: right;"><input type="button"
								id="addButton" value="Add"> <?php if($count > 0){?> <input
								type="button" id="removeButton" value="Remove"> <?php }else{ ?>
								<input type="button" id="removeButton" value="Remove"
								style="display: none;"> <?php } ?></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td class="tdLabel"><?php echo $this->Form->input('no_medication', array('type'=>'checkbox','id'=>'namecheck',
										'checked'=>$checked,'disabled'=>false,'label'=> false, 'div' => false, 'error' => false));?>
								<?php echo __("No Medications Currently Prescribed");?></td>
							<td class=submit_button style="display: blok;" colspan='5'
								align='right' valign='bottom'><?php echo $this->Form->submit(__('Save Medication'),array('id'=>'labsubmit','class'=>'blueBtn','onclick'=>"javascript:save_med();return false;")); ?>
							</td>
							<td class=submit_button style="display: none;" colspan='5'
								align='right' valign='bottom'></td>

						</tr>
					</table>
				</td>
			</tr>
		</table>
		<!--EOF medicine -->
	</div>
	<?php } ?>


	<h3 style="display: none;" id="order-set">
		<a href="#">Order Set</a>
	</h3>
	<div class="section" style="display: none;">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			class="formFull formFullBorder">
			<tr>
				<td class="form_lables" align="left"><?php echo __('Select Diagnosis Type '); ?>:<?php echo $this->Form->input('OrderSet.diagnosisid', array('options' => $specialitycat, 'id' => 'specilaity_id', 'label'=> false, 'div' => false, 'error' => false,'class' => '','onChange'=>'javascript:change_diag_type(this.value)'));?>
				</td>

			</tr>
			<tr>
				<td>
					<table width="100%" cellpadding="0" cellspacing="0" border="0"
						class="formFull formFullBorder">
						<tr>
							<td width="25%" valign="top">
								<table width="100%" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td><b> <?php echo ('Lab')."<br/>";?>
										</b> <?php 
										for($i=0;$i<count($dataOrderSetLab);$i++){
											$labData[]=$dataOrderSetLab[$i]['OrderSetLab']['name'];
									}


									foreach($dataOrderSetLab as $lab_datas){
											if(in_array($lab_datas['OrderSetLab']['name'],$selectedLab)){
															$checkedLab= "checked";
																	}
																	else {
														$checkedLab= "checked";
														}
														//echo $this->Form->input("test", array("type" => "checkbox"));echo $lab_datas['OrderSetLab']['name'];
														echo $this->Form->input("Laboratory.name", array("type" => "checkbox","checked"=>$checkedLab,'hiddenFields'=>false,'name'=>'data[Laboratory][name][]',
									'class'=>given_medi,'value'=>$lab_datas['OrderSetLab']['name']));echo $lab_datas['OrderSetLab']['name']."<br/>";
									}
									$checkedLab= " ";
									?></td>
									</tr>

									<tr>
										<td></td>
										<td><?php // echo $this->Html->link(__('Submit'),"javascript:void(0)",array('id'=>'proceduresubmit','class'=>'blueBtn','onclick'=>"javascript:save_order_set_lab('$p_id')")); 
													echo $this->Form->input("Laboratory.patient_id", array("type" => "hidden"));?>

										</td>
									</tr>

								</table>
							</td>
							<td width="25%" valign="top"><table width="100%" cellpadding="0"
									cellspacing="0" border="0">
									<tr>
										<td><b> <?php echo ('Medication')."<br/>";?>
										</b></td>
									</tr>
									<?php 
									for($i=0;$i<count($dataOrderSetMed);$i++){
											$medData[]=$dataOrderSetMed[$i]['OrderSetMed']['name'];
									}


									?>

									<?php 

									foreach($dataOrderSetMed as $phar_datas){


											if(in_array($phar_datas['OrderSetMed']['name'],$selectedMed)){
	//debug(array_intersect($medData,$selectedMed));
												$checkedMed= "checked";
											}
											else {
													$checkedMed= "checked";
											}
											echo "<tr><td>".$this->Form->input("NewCropPrescription.description", array("type" => "checkbox","checked"=>$checkedMed,'hiddenFields'=>false,'name'=>'data[NewCropPrescription][description][]','class'=>given_medi,'value'=>$phar_datas['OrderSetMed']['name']));echo $phar_datas['OrderSetMed']['name']."</td></tr>";
											echo $this->Form->input("NewCropPrescription.patient_uniqueid", array("type" => "hidden"));
											$checkedMed= "";
									}
									?>

									<tr>
										<td></td>
										<td><?php // echo $this->Html->link(__('Submit'),"javascript:void(0)",array('id'=>'setmedication','class'=>'blueBtn','onclick'=>"javascript:save_order_set_medication()")); ?>
									
									</tr>
								</table></td>
							<td width="25%" valign="top"><table width="100%" cellpadding="0"
									cellspacing="0" border="0">
									<tr>
										<td id="lowback"><b> <?php echo ('Radiology')."<br/>";?>
										</b> <?php 
										for($i=0;$i<count($dataOrderSetMed);$i++){
											$radData[]=$dataOrderSetMed[$i]['OrderSetRad']['name'];
									}


									?> <?php
									//debug($dataOrderSetRad);
									//debug($selectedDataRad);
									//exit;
									foreach($dataOrderSetRad as $rad_datas){
													if(in_array($rad_datas['OrderSetRad']['name'],$selectedDataRad)){
															//debug(in_array($rad_datas['OrderSetRad']['name'],$selectedRad));
															$checkedRad= "checked";
														}
														else {
														$checkedRad= "checked";
													}
													echo $this->Form->input("Radiology.name", array("type" => "checkbox","checked"=>$checkedRad,'hiddenFields'=>false,'name'=>'data[Radiology][name][]','class'=>given_medi,'value'=>$rad_datas['OrderSetRad']['name']));echo $rad_datas['OrderSetRad']['name']."<br/>";
													//echo $this->Form->input("Radiology.patient_uniqueid", array("type" => "hidden"));

									}
									$checkedRad= "";
									?>
										</td>

										<td id="kneepain" style="display: none"><b> <?php echo ('Radiology')."<br/>";?>
										</b> <?php 
										for($i=0;$i<count($dataOrderSetMed);$i++){
											$radData[]=$dataOrderSetMed[$i]['OrderSetRad']['name'];
									}


									?> <?php
									//debug($dataOrderSetRad);
									//debug($selectedDataRad);
									//exit;
									foreach($dataOrderSetRad_knee as $rad_datas){
													if(in_array($rad_datas['OrderSetRad']['name'],$selectedDataRad)){
															//debug(in_array($rad_datas['OrderSetRad']['name'],$selectedRad));
															$checkedRad= "checked";
														}
														else {
														$checkedRad= "checked";
													}
													echo $this->Form->input("Radiology.name", array("type" => "checkbox","checked"=>$checkedRad,'hiddenFields'=>false,'name'=>'data[Radiology][name][]','class'=>given_medi,'value'=>$rad_datas['OrderSetRad']['name']));echo $rad_datas['OrderSetRad']['name']."<br/>";
													//echo $this->Form->input("Radiology.patient_uniqueid", array("type" => "hidden"));

									}
									$checkedRad= "";
									?>
										</td>

										<td id="neckpain" style="display: none"><b> <?php echo ('Radiology')."<br/>";?>
										</b> <?php 
										for($i=0;$i<count($dataOrderSetMed);$i++){
											$radData[]=$dataOrderSetMed[$i]['OrderSetRad']['name'];
									}


									?> <?php
									//debug($dataOrderSetRad);
									//debug($selectedDataRad);
									//exit;
									foreach($dataOrderSetRad_neck as $rad_datas){
													if(in_array($rad_datas['OrderSetRad']['name'],$selectedDataRad)){
															//debug(in_array($rad_datas['OrderSetRad']['name'],$selectedRad));
															$checkedRad= "checked";
														}
														else {
														$checkedRad= "checked";
													}
													echo $this->Form->input("Radiology.name", array("type" => "checkbox","checked"=>$checkedRad,'hiddenFields'=>false,'name'=>'data[Radiology][name][]','class'=>given_medi,'value'=>$rad_datas['OrderSetRad']['name']));echo $rad_datas['OrderSetRad']['name']."<br/>";
													//echo $this->Form->input("Radiology.patient_uniqueid", array("type" => "hidden"));

									}
									$checkedRad= "";
									?>
										</td>

										<td id="upper" style="display: none"><b> <?php echo ('Radiology')."<br/>";?>
										</b> <?php 
										for($i=0;$i<count($dataOrderSetMed);$i++){
											$radData[]=$dataOrderSetMed[$i]['OrderSetRad']['name'];
									}


									?> <?php
									//debug($dataOrderSetRad);
									//debug($selectedDataRad);
									//exit;
									foreach($dataOrderSetRad_upper as $rad_datas){
													if(in_array($rad_datas['OrderSetRad']['name'],$selectedDataRad)){
															//debug(in_array($rad_datas['OrderSetRad']['name'],$selectedRad));
															$checkedRad= "checked";
														}
														else {
														$checkedRad= "checked";
													}
													echo $this->Form->input("Radiology.name", array("type" => "checkbox","checked"=>$checkedRad,'hiddenFields'=>false,'name'=>'data[Radiology][name][]','class'=>given_medi,'value'=>$rad_datas['OrderSetRad']['name']));echo $rad_datas['OrderSetRad']['name']."<br/>";
													//echo $this->Form->input("Radiology.patient_uniqueid", array("type" => "hidden"));

									}
									$checkedRad= "";
									?>
										</td>

										<td id="lower" style="display: none"><b> <?php echo ('Radiology')."<br/>";?>
										</b> <?php 
										for($i=0;$i<count($dataOrderSetMed);$i++){
											$radData[]=$dataOrderSetMed[$i]['OrderSetRad']['name'];
									}


									?> <?php
									//debug($dataOrderSetRad);
									//debug($selectedDataRad);
									//exit;
									foreach($dataOrderSetRad_lower as $rad_datas){
													if(in_array($rad_datas['OrderSetRad']['name'],$selectedDataRad)){
															//debug(in_array($rad_datas['OrderSetRad']['name'],$selectedRad));
															$checkedRad= "checked";
														}
														else {
														$checkedRad= "checked";
													}
													echo $this->Form->input("Radiology.name", array("type" => "checkbox","checked"=>$checkedRad,'hiddenFields'=>false,'name'=>'data[Radiology][name][]','class'=>given_medi,'value'=>$rad_datas['OrderSetRad']['name']));echo $rad_datas['OrderSetRad']['name']."<br/>";
													//echo $this->Form->input("Radiology.patient_uniqueid", array("type" => "hidden"));

									}
									$checkedRad= "";
									?>
										</td>


									</tr>
									<tr>
										<td></td>
										<td><?php  //echo $this->Html->link(__('Submit'),"javascript:void(0)",array('id'=>'proceduresubmit','class'=>'blueBtn','onclick'=>"javascript:save_order_set_rad()")); ?>
									
									</tr>
								</table></td>

						</tr>
					</table>

				</td>
			</tr>
		</table>

		<span style="float: right; margin-top: -12px"> <?php  echo $this->Html->link(__('Submit'),"javascript:void(0)",array('id'=>'proceduresubmit','class'=>'blueBtn','onclick'=>"javascript:callOrderSetSave()")); ?>
		</span>
	</div>


	<h3 style="display: &amp;amp;" id="pre-opt-link">
		<a href="#">Pre Operative Note</a>
	</h3>
	<div class="section" id="pre-opt">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			class="formFull formFullBorder">
			<tr>
				<td width="27%" align="left" valign="top">
					<div align="center" id='temp-busy-indicator-pre-opt'
						style="display: none;">
						&nbsp;
						<?php echo $this->Html->image('indicator.gif', array()); ?>
					</div>
					<div id="templateArea-pre-opt"></div>
				</td>
				<td width="70%" align="left" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="20">&nbsp;</td>
							<td valign="top" colspan="4"><?php echo $this->Form->textarea('pre_opt', array('id' => 'pre-opt_desc','rows'=>'22','style'=>'width:90%')); ?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
	<!-- EOF section div -->
	<!-- EOF pre-oprative Note type option -->


	<h3 style="display: &amp;amp;" id="surgery-link">
		<a href="#">Description of Surgery</a>
	</h3>
	<div class="section" id="surgery">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			class="formFull formFullBorder">
			<tr>
				<td width="27%" align="left" valign="top">
					<div align="center" id='temp-busy-indicator-surgery'
						style="display: none;">
						&nbsp;
						<?php echo $this->Html->image('indicator.gif', array()); ?>
					</div>
					<div id="templateArea-surgery"></div>
				</td>
				<td width="70%" align="left" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="20">&nbsp;</td>
							<td valign="top" colspan="4"><?php echo $this->Form->textarea('surgery', array('id' => 'surgery_desc'  ,'rows'=>'22','style'=>'width:90%')); ?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>


	<h3 style="display: &amp;amp;" id="post-opt-link">
		<a href="#">Post Operative Note</a>
	</h3>
	<div class="section" id="post-opt">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			class="formFull formFullBorder">
			<tr>
				<td width="27%" align="left" valign="top">
					<div align="center" id='temp-busy-indicator-post-opt'
						style="display: none;">
						&nbsp;
						<?php echo $this->Html->image('indicator.gif', array()); ?>
					</div>
					<div id="templateArea-post-opt"></div>
				</td>
				<td width="70%" align="left" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="20">&nbsp;</td>
							<td valign="top" colspan="4"><?php echo $this->Form->textarea('post_opt', array('id' => 'post-opt_desc','rows'=>'22','style'=>'width:90%')); ?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>


	<!-- BOF procedure -->
	<h3 style="display: &amp;amp;" id="procedurePerform-link">
		<a href="#">Procedure Performed</a>
	</h3>
	<div class="section" id="procedure_performed">
		<!-- Start of Ajax for procedure -->

		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			class="formFull formFullBorder">
			<tr>
				<td><table>
						<tr>
							<td width="27%" align="left" valign="top">
								<div align="center" id='temp-busy-indicator-procedure_performed'
									style="display: none;">
									&nbsp;
									<?php echo $this->Html->image('indicator.gif', array()); ?>
								</div>
								<table width="100%" cellpadding="0" cellspacing="1" border="0"
									class="tabularForm">
									<tr>
										<td valign="top">
											<table width="100%" cellpadding="0" cellspacing="0"
												border="0">
												<!--<tr>
													 <td width="145" class="tdLabel2"><strong>Search :</strong>
													</td>
													<td width="250" cellpadding:right='200px'><?php 
													echo $this->Form->input('search', array('class' => 'textBoxExpnd','style'=>'padding:7px 10px;','id'=>'search','autocomplete'=>'true','label'=>false,'div'=>false));
													//echo $this->Form->hidden('LaboratoryTestOrder.patient_id', array('value'=>$patient_id));
													//echo $this->Form->hidden('LaboratoryTestOrder.from_assessment', array('value'=>1));

													?>
													</td>
													<td width="" colspan="2"><?php 

													echo $this->Html->link(__('Search'),"javascript:void(0)",array('class'=>'blueBtn','onclick'=>'javascript:snomed_labrad_test()'));
													?>
													</td>
													<td width="60" class="tdLabel2"><?php echo __('Search Result :');?>
													</td>
													<td width="" colspan="4"><?php 

													echo $this->Form->input('LaboratoryTestOrder.toTest',array('empty'=>__('Select'),'options'=>'','escape'=>false,'multiple'=>false,'value'=>'',
	                                  'style'=>'width:300px;','id'=>'SelectLeftProc','label'=>false,'div'=>false,'empty'=> 'Please Select','onChange'=>'javascript:changeTestProc()'));
	                                 ?>
													</td>

												</tr> -->


												<tr>
													<td class="tdLabel2" id="boxSpace"><?php echo __('Procedure Name') ?><font
														color="red">*</font>
													</td>
													<td class="row_format"><?php 
													echo $this->Form->input('ProcedurePerform.procedure_name',array('type'=>'text','escape'=>false,/*'onchange'=>'javascript:dbProcedureperform()',*/
															'id'=>'procedure_name','label'=>false,'div'=>false,'style'=>'width:290px;'))."&nbsp;OR&nbsp;".$this->Html->link(__('IMO Search'),"javascript:void(0)",array('class'=>'blueBtn','onclick'=>'javascript:proceduresearch("forproc")'));

														//echo $this->Form->hidden('ProcedurePerform.code_type',array('type'=>'text','id'=>'code_type','value'=>$codeType));
													?>
													</td>
													<!--<td	class="row_format"><?php 
														//echo $this->Form->input('ProcedurePerform.procedure_name',array('type'=>'text','escape'=>false, 'class'=>'textBoxExpnd',/*'onchange'=>'javascript:dbProcedureperform()',*/
															/*'id'=>'procedure_name1','label'=>false,'div'=>false));*/

														//echo $this->Form->hidden('ProcedurePerform.code_type',array('type'=>'text','id'=>'code_type','value'=>$codeType));
													?>
													</td>		-->
													<td width="" colspan="2"></td>
													<td width="135" class="tdLabel2"><?php echo __('Procedure Type');?>
													</td>
													<td width="31%" style="padding-right: 1%" class="tdLabel2"
														colspan="4"><?php echo $this->Form->input('ProcedurePerform.code_type',array('type'=>'text','id'=>'code_type','readonly'=>'readonly', 'class'=>'textBoxExpnd'));
														echo $this->Form->hidden('ProcedurePerform.snowmed_code',array('id'=>'code_value','type'=>'text'));
														echo $this->Form->hidden('ProcedurePerform.id',array('id'=>'pro_id','type'=>'text'));
														//echo $this->Form->hidden('ProcedurePerform.id',array('id'=>'pro_id','type'=>'text'));
														/*echo $this->Form->hidden('ProcedurePerform.p_name',array('id'=>'p_name','type'=>'text'));
														 echo $this->Form->hidden('ProcedurePerform.code_C_type',array('id'=>'code_C_type','type'=>'text'));*/
														//	echo $this->Form->hidden('ProcedurePerform.p_daignosis_name',array('id'=>'p_daignosis_name','type'=>'text'));
														?>
													</td>
													<!-- <td width="135" class="tdLabel2"><?php //echo __('Procedure Name');?><font
														color="red">*</font>
													</td>
													<td width="31%" style="padding-right: 1%" class="tdLabel2"
														colspan="4"><?php /*echo $this->Form->input('ProcedurePerform.procedure_name',array('id'=>'procedure_name','readonly'=>'readonly','class'=>'validate[required,custom[mandatory-select]] textBoxExpnd'));
														echo $this->Form->hidden('ProcedurePerform.snowmed_code',array('id'=>'code_value','type'=>'text'));
														echo $this->Form->hidden('ProcedurePerform.id',array('id'=>'pro_id','type'=>'text'));*/
														?>
													</td> -->
												</tr>
												<tr>
													<td width="12%" class="tdLabel2"><?php echo __('Service From Date') ?><font
														color="red">*</font>
													</td>
													<td width="32%" style="padding-right: -3%"
														class="row_format"><?php 
														echo $this->Form->input('ProcedurePerform.procedure_date',array('class'=>'textBoxExpnd validate[required,custom[mandatory-date]]','readonly'=>'readonly','type'=>'text','id'=>'procedure_perform_date'));
														?>
													</td>
													<td width="" colspan="2"></td>
													<td width="12%" class="tdLabel2"><?php echo __('Service To Date');?>
													</td>
													<td width="31%" style="padding-right: 1%" class="tdLabel2"
														colspan="4"><?php 
														echo $this->Form->input('ProcedurePerform.procedure_to_date',array('class'=>'textBoxExpnd','readonly'=>'readonly','type'=>'text','id'=>'procedure_to_date'));
														?>
													</td>
												</tr>
												<tr>
													<td width="12%" class="tdLabel2"><?php echo __('Modifier1') ?>
													</td>
													<td width="32%" style="padding-right: -3%"
														class="row_format"><?php 
														echo $this->Form->input('ProcedurePerform.modifier1',array('class'=>'textBoxExpnd ','empty'=>__('Please Select'),'options'=>$nameBillingOtherCode,'id'=>'modifier1'));
														?>
													</td>
													<td width="" colspan="2"></td>
													<td width="12%" class="tdLabel2"><?php echo __('Modifier2');?>
													</td>
													<td width="31%" style="padding-right: 1%" class="tdLabel2"
														colspan="4"><?php 
														echo $this->Form->input('ProcedurePerform.modifier2',array('class'=>'textBoxExpnd','empty'=>__('Please Select'),'options'=>$nameBillingOtherCode,'id'=>'modifier2'));
														?>
													</td>
												</tr>
												<tr>
													<td width="12%" class="tdLabel2"><?php echo __('Modifier3') ?>
													</td>
													<td width="32%" style="padding-right: -3%"
														class="row_format"><?php 
														echo $this->Form->input('ProcedurePerform.modifier3',array('class'=>'textBoxExpnd','empty'=>__('Please Select'),'options'=>$nameBillingOtherCode,'id'=>'modifier3'));
														?>
													</td>
													<td width="" colspan="2"></td>
													<td width="12%" class="tdLabel2"><?php echo __('Modifier4');?>
													</td>
													<td width="31%" style="padding-right: 1%" class="tdLabel2"
														colspan="4"><?php 
														echo $this->Form->input('ProcedurePerform.modifier4',array('class'=>'textBoxExpnd ','empty'=>__('Please Select'),'options'=>$nameBillingOtherCode,'id'=>'modifier4'));
														?>
													</td>
												</tr>
												<tr>
													<td width="12%" class="tdLabel2"><?php echo __('Units') ?>
													</td>
													<td width="32%" style="padding-right: -3%"
														class="row_format"><?php 
														echo $this->Form->input('ProcedurePerform.units',array('class'=>'textBoxExpnd','type'=>'text','id'=>'units','value'=>'1','style'=>'width:120px;'));
														?>
													</td>
													<td width="" colspan="2"></td>
													<td width="12%" class="tdLabel2"><?php echo __('Place of Services') ?><font
														color="red">*</font>
													</td>
													<td width="31%" style="padding-right: 1%" class="tdLabel2"
														colspan="4"><?php 
														echo $this->Form->input('ProcedurePerform.place_service',array('class'=>'textBoxExpnd validate[required,custom[mandatory-select]]','empty'=>__('Please Select'),'id'=>'place_service','options'=>Configure::read('place_service_code')));
														?>
													</td>
												</tr>
												<tr>
													<td width="12%" class="tdLabel2"><?php echo __('Patient Diagnosis');?>
													</td>
													<td width="32%" style="padding-right: -3%"
														class="row_format"><?php 
														echo $this->Form->input('ProcedurePerform.patient_daignosis',array('class'=>'textBoxExpnd ','options'=>$nameNoteDiagnosis,'id'=>'patient_daignosis','multiple'=>true));
														?>
													</td>
													<td width="" colspan="2"></td>
													<td width="135" class="tdLabel2"></td>
													<td width="31%" style="padding-right: 1%" class="tdLabel2"
														colspan="4"></td>
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
										<td valign="top" colspan="4"><?php echo __('Procedure Note :');?>
										</td>
									</tr>
									<tr>
										<td width="20">&nbsp;</td>
										<td valign="top" colspan="4"><?php echo $this->Form->textarea('ProcedurePerform.procedure_note', array('id' =>'procedure_note'  ,'rows'=>'4','style'=>'width:97%')); ?>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td colspan='4' align='right' valign='bottom'><?php  echo $this->Html->link(__('Submit'),"javascript:void(0)",array('id'=>'procedure_perform_submit','class'=>'blueBtn','onclick'=>"javascript:save_procedure_perform()")); ?>
							</td>
						</tr>
						<tr>
							<td>
								<table border="0" class="table_format" cellpadding="0"
									cellspacing="0" width="100%" style="text-align: center;">
									<?php if(isset($procedure_perform) && !empty($procedure_perform)){ ?>
									<tr class="row_title">
										<td class="table_cell"><strong> <?php echo  __('Test Name', true); ?>
										</strong></td>

										<td class="table_cell"><strong> <?php echo  __('Code', true); ?>
										</strong></td>
										<td class="table_cell"><strong> <?php echo  __('Procedure Date', true); ?>
										</strong></td>
										<td class="table_cell"><strong> <?php echo  __('Action'); ?>
										</strong></td>
									</tr>
									<?php
									$toggle =0;
									if(count($procedure_perform) > 0) {
									foreach($procedure_perform as $procedure_perform){
											if(!empty($procedure_perform)) {
	$procedurePerformid="procedurePerform".$procedure_perform[ProcedurePerform][id];
}else{
	echo "<tr class='row_title' id='".$procedurePerformid."'><td colspan='5>&nbsp;</td></tr>" ;
}
if($toggle == 0) {
	echo "<tr class='row_gray' id='".$procedurePerformid."'>";
	$toggle = 1;
}else{
	echo "<tr id='".$procedurePerformid."'>";
	$toggle = 0;
}
//status of the report
?>

									<td class="row_format"><?php echo $procedure_perform['ProcedurePerform']['procedure_name']; ?>
									</td>

									<td class="row_format"><?php echo $procedure_perform['ProcedurePerform']['snowmed_code']; ?>
									</td>

									<td class="row_format"><?php echo $this->DateFormat->formatDate2Local($procedure_perform['ProcedurePerform']['procedure_date'],Configure::read('date_format_us'),false); ?>
									</td>

									<td class="row_format"><?php $pro_id = $procedure_perform['ProcedurePerform']['id'];
									echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete', 'onclick'=>"delete_procedure_perform($pro_id);return false;")), array(__('Are you sure?', true)), array('escape' => false));
									echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('title'=>'Edit','alt'=>'Edit', 'onclick'=>"edit_procedure_perform($pro_id);return false;")), array(), array('escape' => false));
									?>
									</td>
									</tr>
									<?php } 
						}
														} else {
					 ?>
									<tr>
										<TD colspan="5" align="center" class="error"><?php echo __('No Procedure Results for selected patient', true); ?>.
										</TD>
									</tr>
									<?php } ?>
								</table>
							</td>
						</tr>

					</table></td>
			</tr>
		</table>




	</div>


	<!-- EOF procedure -->

	<!-- BOF Devices -->
	<?php if($data['Patient']['admission_type']=='IPD'){?>
	<?php //if($data['Patient']['admission_type'] == 'IPD'){ ?>
	<h3 style="display: &amp;amp;" id="aids-link">
		<a href="#">Devices Used</a>
	</h3>
	<div class="section" id="device_used">

		<!--  -->
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			class="formFull formFullBorder">
			<tr>
				<td width="27%" align="left" valign="top">
					<div align="center" id='temp-busy-indicator-device_used'
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



										<td class="row_format"><label style="float: inherit"><?php echo __('Device Type') ?>:</label>
										</td>
										<td class="row_format"><?php echo $this->Form->input('DeviceUse.device_detail',array('empty'=>__('Select'),'options'=>$device_list,'escape'=>false,'multiple'=>false,'value'=>'',
												'style'=>'width:400px;','id'=>'device_detail','label'=>false,'div'=>false,'empty'=> 'Please Select','onChange'=>'javascript:device_onchange()'));
										?>
										</td>

										<td width="60" class="tdLabel2"><?php echo __('Device Name :');?>
										</td>
										<td width="400" class="tdLabel2" colspan="4"><?php echo $this->Form->input('DeviceUse.device_name',array('style'=>'width:373px;','id'=>'device_name'));
										echo $this->Form->hidden('DeviceUse.snowmed_code',array('id'=>'device_sno','type'=>'text'));
										echo $this->Form->hidden('DeviceUse.id',array('id'=>'dev_id','type'=>'text'));
										?></td>
									</tr>
									<tr>
										<td width="40"><?php echo __('Device Date :');?></td>
										<td width="100" class="tdLabel2" align="right" colspan="5"><?php 
										echo $this->Form->input('DeviceUse.device_date',array('type'=>'text','id'=>'device_date','class'=>'textBoxExpnd','style'=>'width:120px'));
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
							<td valign="top" colspan="4"><?php echo __('Device Note :');?>
							</td>
						</tr>
						<tr>
							<td width="20">&nbsp;</td>
							<td valign="top" colspan="4"><?php echo $this->Form->textarea('DeviceUse.device_note', array('id' =>'device_note'  ,'rows'=>'4','style'=>'width:97%')); ?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td colspan='4' align='right' valign='bottom'><?php  echo $this->Html->link(__('Submit'),"javascript:void(0)",array('id'=>'device_submit','class'=>'blueBtn','onclick'=>"javascript:save_device()")); ?>
				</td>
			</tr>
			<tr>
				<td>
					<table border="0" class="table_format" cellpadding="0"
						cellspacing="0" width="100%" style="text-align: center;">
						<?php if(isset($device_use) && !empty($device_use)){ ?>
						<tr class="row_title">
							<td class="table_cell"><strong> <?php echo  __('Test Name', true); ?>
							</strong></td>
							<td class="table_cell"><strong> <?php echo  __('Loinc Code', true); ?>
							</strong></td>
							<td class="table_cell"><strong> <?php echo  __('Snomed Code', true); ?>
							</strong></td>
							<td class="table_cell"><strong> <?php echo  __('Devices Date', true); ?>
							</strong></td>
							<td class="table_cell"><strong> <?php echo  __('Action'); ?>
							</strong></td>
						</tr>
						<?php
						$toggle =0;
						if(count($device_use) > 0) {
									foreach($device_use as $device_use){
											 if(!empty($device_use)) {
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

						<td class="row_format"><?php echo $device_use['DeviceUse']['device_name']; ?>
						</td>
						<td class="row_format"><?php echo $device_use['DeviceUse']['loinc_code']; ?>
						</td>
						<td class="row_format"><?php echo $device_use['DeviceUse']['snowmed_code']; ?>
						</td>

						<td class="row_format"><?php echo $this->DateFormat->formatDate2Local($device_use['DeviceUse']['device_date'],Configure::read('date_format_us'),false); ?>
						</td>

						<td class="row_format"><?php $device_id = $device_use['DeviceUse']['id'];
						echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete', 'onclick'=>"delete_device($device_id);return false;")), array(__('Are you sure?', true)), array('escape' => false));
						echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('title'=>'Edit','alt'=>'Edit', 'onclick'=>"edit_device($device_id);return false;")), array(), array('escape' => false));
						?>
						</td>
						</tr>
						<?php } 
						}
										} else {
					 ?>
						<tr>
							<TD colspan="5" align="center" class="error"><?php echo __('No Device Results for selected patient', true); ?>.
							</TD>
						</tr>
						<?php } ?>
					</table>
				</td>
			</tr>
		</table>



	</div>

	<?php }?>

	<h3 style="display: &amp;amp;" id="plan-link">
		<a href="#">Plan</a>
	</h3>
	<div class="section" id="plan">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			class="formFull formFullBorder">
			<tr>
				<td width="27%" align="left" valign="top">
					<div align="center" id='temp-busy-indicator-plan'
						style="display: none;">
						&nbsp;
						<?php echo $this->Html->image('indicator.gif', array()); ?>
					</div>
					<div id="templateArea-plan"></div>
				</td>
				<td width="70%" align="left" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="20">&nbsp;</td>
							<td valign="top" colspan="4"><?php echo $this->Form->textarea('plan', array('id' => 'plan_desc','rows'=>'22','style'=>'width:90%')); ?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			class="formFull formFullBorder">
			<tr>
				<td width="27%" align="left" valign="top">
					<div align="center" id='temp-busy-indicator-Plan'
						style="display: none;">
						&nbsp;
						<?php echo $this->Html->image('indicator.gif', array()); ?>
					</div>
<!-- 
					<table width="100%" cellpadding="0" cellspacing="1" border="0"
						class="tabularForm">
						<tr>
							<td valign="top">
								<table width="100%" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td width="10%" class="tdLabel2"><strong>Search :</strong></td>
										<td width="33%" style='padding: 1px 4px;'
											cellpadding:right='200px'><?php echo $this->Form->input('PlannedProblem.sct_name', array('class' => 'textBoxExpnd','escape'=>false,'multiple'=>false,'id'=>'searchproblem','autocomplete'=>false,'label'=>false,'div'=>false));
											//echo $this->Form->hidden('PlannedProblem.sct_us_concept_id',array('type'=>'text','div'=>false,'label'=>false,'id'=>'sct_us_concept_id'));
											?>
										</td>
										<td width="5%" colspan="4"><?php 
										//echo $this->Html->link(__('Search'),"javascript:void(0)",array('class'=>'blueBtn','onclick'=>'javascript:snomed_problem()'));
										?>
										</td>
										<td width="20%" class="tdLabel2" style="padding-left: 1px;"><?php //echo __('Search Result :');?>
										</td>

										<td width="60" style="padding-right: 4px; padding-left: 2px;"><?php 
										/*echo $this->Form->input('PlannedProblem.toTest',array('empty'=>__('Select'),'options'=>'','escape'=>false,'multiple'=>false,'value'=>'',

	                                  		'style'=>'width:250px;','id'=>'problem','label'=>false,'div'=>false,'empty'=> 'Please Select','onChange'=>'javascript:LoadProblem()'));*/
						                echo $this->Form->hidden('PlannedProblem.sct_us_concept_id',array('id'=>'SCT_US_CONCEPT_ID','type'=>'text'));
						                echo $this->Form->hidden('PlannedProblem.sct_concept_id',array('id'=>'SCT_CONCEPT_ID','type'=>'text'));
						                echo $this->Form->hidden('PlannedProblem.id',array('id'=>'id','type'=>'text'));
						                ?>
										</td>
									</tr>
									<tr>
										<td colspan="6"></td>
										<td align="left"><?php //echo __('OR')?></td>
									</tr>
									<tr>
										<td width="10%" class="tdLabel2"><?php echo __('Plan:'); ?><font
											color="red">*</font></td>

										<td width="33%" style='padding: 1px 4px;'
											cellpadding:right='200px'><?php echo $this->Form->input('PlannedProblem.snomed_description',array('div'=>false,'label'=>false,'readonly'=>'readonly','id'=>'SNOMED_DESCRIPTION','class'=>'validate[required,custom[mandatory-select]] textBoxExpnd'));

											?></td>

										<td width="60" class="tdLabel2"></td>
										<td width="8%" class="tdLabel2"><?php echo __('Plan Date: '); ?><font
											color="red">*</font>
										</td>
										<td width="400"><?php echo $this->Form->input('PlannedProblem.plan_date',array('class'=>'textBoxExpnd DatePicker validate[required,custom[mandatory-date]]','readonly'=>'readonly','type'=>'text','id'=>'plan_date'));

										?>
										</td>
									</tr>
									<tr>
										<td width="60" class="tdLabel2"></td>
										<td><?php echo  $this->Form->input('PlannedProblem.is_followup', array('onchange'=>'javascript:show_textarea()','type'=>'checkbox','hiddenField' => false,'value'=>'','id'=>'is_followup'));?>
											<?php echo __('Add Follow Up Document '); ?></td>

										<td width="400"></td>
										<td width="20%" colspan="4" style="padding-left: 30px"></td>
										<td width="60" class="tdLabel2"></td>
										<td width="60" class="tdLabel2"></td>
										<td width="100" class="tdLabel2" align="right" colspan="5"></td>
										<td width="40"></td>
										<td width="" colspan=""></td>
										<td colspan=""></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>-->
				</td>
			</tr>
			<tr id="follow_doc" style="display: none;">
				<td width="70%" align="left" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="20">&nbsp;</td>
							<td valign="top" colspan="4"><?php echo $this->Form->textarea('PlannedProblem.instruction', array('id' => 'instruction'  ,'rows'=>'4','style'=>'width:97%')); ?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<!-- 
			<tr>
				<td colspan='4' align='right' valign='bottom'><?php  echo $this->Html->link(__('Submit'),"javascript:void(0)",array('id'=>'plansubmit','class'=>'blueBtn','onclick'=>"javascript:save_problem()")); ?>
				</td>
			</tr> -->
			<tr>
				<td>
					<table border="0" class="table_format" cellpadding="0"
						cellspacing="0" width="100%" style="text-align: center;">
						<?php //debug($plannedProblem);exit;
										if(isset($plannedProblem) && !empty($plannedProblem)){ ?>
						<tr class="row_title">
							<td class="table_cell"><strong> <?php echo  __('Problem Name', true); ?>
							</strong></td>

							<td class="table_cell"><strong> <?php echo  __('SNOMED CT Code', true); ?>
							</strong></td>
							<td class="table_cell"><strong> <?php echo  __('Planned Date', true); ?>
							</strong></td>
							<td class="table_cell"><strong> <?php echo  __('Action'); ?>
							</strong></td>
						</tr>
						<?php
						$toggle =0;
						if(count($plannedProblem) > 0) {
									foreach($plannedProblem as $plannedProblem){
										 if(!empty($plannedProblem)) {
										$plannedid="plan".$plannedProblem[PlannedProblem][id];

}else{

	echo "<tr class='row_title' id='".$plannedid."'><td colspan='5>&nbsp;</td></tr>" ;
}
$time  =  $currentTime;
if($toggle == 0) {
	echo "<tr class='row_gray' id='".$plannedid."'>";
	$toggle = 1;
}else{
	echo "<tr id='".$plannedid."'>";
	$toggle = 0;
}
//status of the report
?>
						<td class="row_format"><?php echo $plannedProblem['PlannedProblem']['snomed_description']; ?>
						</td>
						<td class="row_format"><?php echo $plannedProblem['PlannedProblem']['sct_us_concept_id']; ?>
						</td>
						<td class="row_format"><?php echo $this->DateFormat->formatDate2Local($plannedProblem['PlannedProblem']['plan_date'],Configure::read('date_format_us'),false); ?>

						</td>
						<td class="row_format"><?php 
						$plan_id = $plannedProblem['PlannedProblem']['id'];
						//debug($plan_id);exit;
						//	echo $this->Form->hidden('PlannedProblem.id',array('type'=>'text','div'=>false,'label'=>false,'value'=>$plan_id));
						echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete', 'onclick'=>"delete_Problem($plan_id);return false;")), array(__('Are you sure?', true)), array('escape' => false));
						echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('title'=>'Edit','alt'=>'Edit', 'onclick'=>"edit_problem($plan_id);return false;")), array(), array('escape' => false));
						?>
						</td>
						</tr>
						<?php } 
						//set get variables to pagination url
						//$this->Paginator->options(array('url' =>array("?"=>$this->params->query)));
						?>

						<?php } ?>
						<?php					  
										} else {
					 ?>
					 <!-- 
						<tr>
							<TD colspan="5" align="center" class="error"><?php echo __('No problem plan for selected patient', true); ?>.
							</TD>
						</tr> -->
						<?php
						  }
 						//echo $this->Js->writeBuffer(); ?>
					</table>
				</td>
			</tr>
		</table>
	</div>
	<!--  <h3 style="display: &amp;amp;" id="event-link">
		<a href="#">Event</a>
	</h3>
	<div class="section" id="event">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			class="formFull formFullBorder">
			<tr>
				<td width="27%" align="left" valign="top">
					<div align="center" id='temp-busy-indicator-Plan'
						style="display: none;">
						&nbsp;
						<?php echo $this->Html->image('indicator.gif', array()); ?>
					</div>

					<table width="100%" cellpadding="0" cellspacing="0" border="0"
						class="tabularForm">
						<tr>
							<td valign="top">
								<table width="100%" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td width="3%" class="tdLabel2"><strong>Discharge Summary :</strong>
										</td>
										<td width="25%" cellpadding:right='300px'><?php echo $this->Form->input('Note.event_discharge', array('type'=>'textarea','escape'=>false,'multiple'=>false,'style'=>'padding:7px 10px;','id'=>'event_discharge','autocomplete'=>false,'label'=>false,'div'=>false));
										//echo $this->Form->hidden('PlannedProblem.sct_us_concept_id',array('type'=>'text','div'=>false,'label'=>false,'id'=>'sct_us_concept_id'));
										?>
										</td>
									</tr>
									<tr>
										<td width="60" class="tdLabel2"></td>
										<td><?php echo  $this->Form->input('Note.is_event', array('type'=>'checkbox','hiddenField' => false,'value'=>'','id'=>'is_event'));?>
											<?php echo __('Event In Discharge Summary '); ?></td>
									</tr>
									<tr>
										<td colspan='4' align='right' valign='bottom'><?php // echo $this->Html->link(__('Submit'),"#",array('id'=>'eventsubmit','class'=>'blueBtn','onclick'=>"save_event()")); ?>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>-->


	<!-- EOF new HTML -->
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>
			<div class="btns"> <?php $role = $this->Session->read('role');?>
			<?php if($role != Configure::read('nurseLabel')){?>
				<?php if(!empty($icdTrack[0]['Note']['reason_to_unsign'])){?>
				<span id='lowerSubmit' style='display: block; padding-top: 20px'> <input
					type="submit" value="Sign Again" class="blueBtn" id="soap_submit2"
					style='border-color: red;'>
				</span>
				<?php }else{?>
				<span id='lowerSubmit' style='display: block; padding-top: 20px'> <input
					type="submit" value="Sign" class="blueBtn" id="soap_submit1"
					style='border-color: red;'>
				</span>
				<?php }?>
				<?php } ?>
			</div>
		</td>
		<td style='padding-top: 20px;' width='4%'>
			<div class="btns">
				<?php $cancelBtnUrl =  array('controller'=>'patients','action'=>'patient_notes',$p_id);
				echo $this->Html->link(__('Cancel'),$cancelBtnUrl,array('class'=>'blueBtn','div'=>false));
				?>
			</div>

			</div>
		</td>
		<td width='1%'>
			<div class="btns">
				<?php if(empty($icdTrack[0]['Note']['reason_to_unsign'])){
					$displaySign='block';
				}else{
				$displaySign='none';
				}?>
				<span id='lowerSubmit'style='display:<?php echo $displaySign ?>;padding-top:20px'>
					<input type="submit" value="Submit" class="blueBtn"
					id="soap_submit">
				</span>
			</div>
		</td>
	</tr>
</table>

<?php echo $this->Form->end(); ?>
<?php $splitDate = explode(' ',$admissionDate);?>
<script>
var sample;
var global_note_id = "<?php echo $global_note_id;?>";	
var diagnosisSelectedArray = new Array();
function addDiagnosisDetails(){
	var selectedPatientId = parent.$('#Patientsid').val();
	
	if(selectedPatientId != ''){
		
		var currEle = diagnosisSelectedArray.pop();
		if((currEle !='') && (currEle !== undefined)){
			parent.openbox(currEle,selectedPatientId,parent.global_note_id);
		}
	}
	
}

function openbox(icd,note_id,linkId) { 
	// disable link after first click
	///---split for sending via url
	icd = icd.split("::");
	var patient_id = $('#Patientsid').val();
	if (patient_id == '') {
		alert("Please select patient");
		return false;
	}
	$.fancybox({
				'width' : '40%',
				'height' : '80%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'hideOnOverlayClick':false,
				'showCloseButton':false,
				'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "make_diagnosis")); ?>"
						 + '/' + patient_id + '/' + icd  + '/'+global_note_id , 
				
			});


	/*$('#fancybox-overlay').live('click',function(){
		var chk=confirm('Do you wish to cancel diagnosis?');
		if(chk==true){ 			
			addDiagnosisDetails();
			$.fancybox.close();			
		}else{ 
			return false;
		} 
	});*/

}


$(document).ready(function(){

	jQuery("#patientnotesfrm").validationEngine({
		//*****alert("hi");
		validateNonVisibleFields: true,
		updatePromptsPosition:true,
		});
	$('#plansubmit')
	.click(
			function() { 
				//alert("hello");
				var validatePerson = jQuery("#patientnotesfrm").validationEngine('validate');
			///	alert(validatePerson);
			//	if (validatePerson) {$(this).css('display', 'none');}
				return false;
			});
});


				function setVal(what,where,extra){ 
					if(what == 'OTHER'){
						$('#'+extra).toggle();
					} 
					 
					$("#"+where).val(what) ;
				}
				
	var admissionDate = <?php echo json_encode($splitDate[0]); ?>;
	var explode = admissionDate.split('-');
	$(document).ready(function(){
   	 
		$("#subjective_desc").autocomplete("<?php echo $this->Html->url(array("controller" => "SmartPhrases", "action" => "getSmartPhrase","admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			//selectFirst: true,
			isSmartPhrase:true,
			delay:500,
			//autoFill:true,
			select: function(e){ }
		});
		$("#objective_desc").autocomplete("<?php echo $this->Html->url(array("controller" => "SmartPhrases", "action" => "getSmartPhrase","admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			//selectFirst: true,
			isSmartPhrase:true,
			//autoFill:true,
			select: function(e){ }
		});
		$("#assessment_desc").autocomplete("<?php echo $this->Html->url(array("controller" => "SmartPhrases", "action" => "getSmartPhrase","admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			//selectFirst: true,
			isSmartPhrase:true,
			//autoFill:true,
			select: function(e){ }
		});
		$("#pre-opt_desc").autocomplete("<?php echo $this->Html->url(array("controller" => "SmartPhrases", "action" => "getSmartPhrase","admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			//selectFirst: true,
			isSmartPhrase:true,
			//autoFill:true,
			select: function(e){ }
		});
		$("#surgery_desc").autocomplete("<?php echo $this->Html->url(array("controller" => "SmartPhrases", "action" => "getSmartPhrase","admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			//selectFirst: true,
			isSmartPhrase:true,
			//autoFill:true,
			select: function(e){ }
		});
		$("#post-opt_desc").autocomplete("<?php echo $this->Html->url(array("controller" => "SmartPhrases", "action" => "getSmartPhrase","admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			//selectFirst: true,
			isSmartPhrase:true,
			//autoFill:true,
			select: function(e){ }
		});
		$("#doctor_id_txt").autocomplete("<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "testcomplete","User",'id',"full_name","is_active=1&role_id=".$this->Session->read('doctorRoleId')."&location_id=".$this->Session->read('locationid'),"admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true,
			valueSelected:true,
			showNoId:true,
			loadId : 'doctor_id_txt,sb_registrar'
		});
		
 	});
 	

	//----------------------------------------------------------------------------
		//----------GAURAV------------

	$("#eraser").click(function() {

		$('#icdSlc').html('');
		$('#icd_ids').val('');
		$("#eraser").hide();
	});
	
	$("#eraser").hide();

	function remove_icd(val) {
		 
		
			var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'notes', "action" => "deleteNoteDiagnosis","admin" => false)); ?>";
			$.ajax({
				type : "POST",
				url : ajaxUrl +"/"+val, 
				context : document.body,
				success : function(data) {
					if(data == 1 ){
						
						var ids = $('#icd_ids').val();
						tt = ids.replace(val + '|', '');
						 
						$('#icd_ids').val(tt);
						$('#icd_' + val).remove();
						var	ht = $.trim($('#icdSlc').html());
						if(ht == ''){
							$('#chkbox').attr('checked','checked');
							//$("#chkbox").attr("disabled", true);
						}
					
					}else{  
						alert("Please try again");
					} 
				}
			});
		 
	
	}

	function save_med(isOverride){
		if((isOverride!='1')||(isOverride==='undefined')){
			isOverride='0';
		}
		else{
			var chkConfrim=confirm('Are you sure you want to override the drug drug interaction.');
			if($.trim(chkConfrim)=='false'){
				 $('#successMsg').show();
				 $('#successMsg').html("Please change the medication.");
				 $('#busy-indicator').hide('fast');
				 return false;
			}
			isOverride=isOverride;
		}
		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'notes', "action" => "save_med","admin" => false)); ?>"+"/"+isOverride;
		
		$.ajax({
			type : "POST",
			data:$('#patientnotesfrm').serialize(),
			url : ajaxUrl , 
			beforeSend : function() {
        		// this is where we append a loading image
        		$('#busy-indicator').show('fast');
        		},
			//context : document.body,
			success: function(data){
				if((data != '') && (data !== undefined) && (data != 1)){
					data = jQuery.parseJSON(data);
					if(data.DrugDrug.rowcount!='0'){
					var ClinicalEffects= data.DrugDrug.rowDta.DrugInteraction.ClinicalEffects;
					$('#showInteractions').show();
					$('#showInteractions').html(ClinicalEffects);
					}
					if(data.DrugDrug.rowcount!='0'){
					var SeverityLevel=data.DrugDrug.rowDta.DrugInteraction.SeverityLevel;
					$('#showsevirity').show();
					$('#showsevirity').html(SeverityLevel);
					}
					if(data.Interaction.rowDta!=''){
				    var interactionData=data.Interaction.rowDta;
				    $('#interactionData').show();
					$('#interactionData').html("ALLERGY INTERACTION:"+interactionData);
					}
					$('#overRide').show();
					$('#overRideButton').show();
					 $('#busy-indicator').hide('fast');
					return false;
				
				}else{
					 
					    $('#showsevirity').hide();
						$('#showInteractions').hide();
						$('#overRide').hide();
						$('#overRideButton').hide();
						$('#interactionData').hide();
					    $('#busy-indicator').hide('fast');
					    $('#successMsg').show();
					    $('#successMsg').html("Medication saved succesfully. Please click on submit button to continue.");
					
				}
				},
			
			error: function(message){
			alert("Connection Error please try after some time.");
			}
			
		});
	}

	$("#assessment-link").click(function() {
	var	ht = $.trim($('#icdSlc').html());
		
		if(ht == ''){
			$('#chkbox').attr('checked','checked');
			//$("#chkbox").attr("disabled", true);
		}else{
			$('#chkbox').attr('checked',false);
			$("#chkbox").attr("disabled", true);
		}
	});

	$("#eraser").click(function() {

		$('#icdSlc').html('');
		$('#icd_ids').val('');
		$("#eraser").hide();
	});

	function remove_icdr(val) {
		 
		 
		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'notes', "action" => "deleteNoteDiagnosis","admin" => false)); ?>";
		$.ajax({
			type : "POST",
			url : ajaxUrl +"/"+val, 
			context : document.body,
			success : function(data) {
				if(data == 1 ){
					//alert(data);
					var ids = $('#icd_idsr').val();
					tt = ids.replace(val + '|', '');
					 
					$('#icd_idsr').val(tt);
					$('#icdr_' + val).remove();
				}else{  
					alert("Please try again");
				} 
			}
		});
	 

}

	$("#eraser").click(function() {

		$('#icdSlc').html('');
		$('#icd_ids').val('');
		$("#eraser").hide();
	});

	$("#eraser").hide();
	function remove_icdi(val) {
		 
		 
		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'notes', "action" => "deleteNoteDiagnosis","admin" => false)); ?>";
		$.ajax({
			type : "POST",
			url : ajaxUrl +"/"+val, 
			context : document.body,
			success : function(data) {
				if(data == 1 ){
					
					var ids = $('#icd_idsi').val();
					tt = ids.replace(val + '|', '');
					 
					$('#icd_idsi').val(tt);
					$('#icdi_' + val).remove();
				}else{  
					alert("Please try again");
				} 
			}
		});
	 

}

	$("#eraser").click(function() {

		$('#icdSlc').html('');
		$('#icd_ids').val('');
		$("#eraser").hide();
	});

	$("#eraser").hide();
	function remove_icdi(val) {
		 
		 
		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'notes', "action" => "deleteNoteDiagnosis","admin" => false)); ?>";
		$.ajax({
			type : "POST",
			url : ajaxUrl +"/"+val, 
			context : document.body,
			success : function(data) {
				if(data == 1 ){
					
					var ids = $('#icd_idsr').val();
					tt = ids.replace(val + '|', '');
					 
					$('#icd_idsr').val(tt);
					$('#icdi_' + val).remove();
				}else{  
					alert("Please try again");
				} 
			}
		});
	 

}


	//----------------------------------------------------------------------------
	//-----------
	var admissionDate = <?php echo json_encode($splitDate[0]); ?>;
	var explode = admissionDate.split('-');
	$(function() {
		$('input')
				.filter('.my_end_date')
				.datepicker(
						{
							changeMonth : true,
							changeYear : true,
							yearRange : '1950',
							minDate : new Date(explode[0], explode[1] - 1,
									explode[2]),

							dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
                    	    showOn : 'button',
							buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
							buttonImageOnly : true,
							onSelect : function() {
								$(this).focus();
							}
						});
	});
	
//----------------------------------------------------------------------------
	// To sate min date not more than the admission date 

	jQuery(document)
			.ready(
					function() {

						/*$('#diagicd').click(function(){
							alert("hello");
						    var patient_id = '933';
							if(patient_id==''){
								alert("Please select patient");
								return false ;
							} 
							$.fancybox({
								
						        'width'    : '90%',
							    'height'   : '90%',
							    'autoScale': true,
							    'transitionIn': 'fade',
							    'transitionOut': 'fade',
							    'type': 'iframe',
							    'href': "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "icd")); ?>"+'/'+patient_id 
						    });
							
						});*/

						$("#note_date")
								.datepicker(
										{
											showOn : "button",
											style : "margin-left:50px",
											buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
											buttonImageOnly : true,
											changeMonth : true,
											changeYear : true,
											yearRange : '1950',
											
											dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
											onSelect : function() {
												$(this).focus();
											}
										});
						$("#start_date")
								.datepicker(
										{
											showOn : "button",
											buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
											buttonImageOnly : true,
											changeMonth : true,
											changeYear : true,
											yearRange : '1950',
											minDate : new Date(explode[0],
													explode[1] - 1, explode[2]),
											dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
											onSelect : function() {
												$(this).focus();
											}
										});

						$("#end_date")
								.datepicker(
										{
											showOn : "button",
											buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
											buttonImageOnly : true,
											changeMonth : true,
											changeYear : true,
											yearRange : '1950',
											minDate : new Date(explode[0],
													explode[1] - 1, explode[2]),
											dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
											onSelect : function() {
												$(this).focus();
											}
										});

						$("#note_type").change(function() {

							if ($("#note_type").val() == 'general') {
								//alert('here'+$("#note_type").val());
								$("#to_be_billed_section").show()
							} else {
								$("#to_be_billed_section").hide();
							}
						});
						
						//	$('.drugText').keydown(function(){
						//		 var currentId=$(this).attr(id);
						//		 alert(currentId);
						//		 return;
								//$("#testname").val('');	 
								
						//	}); 
				
						$('.drugText')
								.live(
										'focus',
										function() {
											var currentId=	$(this).attr('id').split("_"); // Important
											var attrId = this.id;
											var counter = $(this).attr(
													"counter");
											if ($(this).val() == "") {
												$("#Pack" + counter).val("");
											}
											$(this)
													.autocomplete(
																																						
															"<?php echo $this->Html->url(array("controller" => "Notes", "action" => "pharmacyComplete","PharmacyItem",'name',"drug_id",'MED_STRENGTH','MED_STRENGTH_UOM','MED_ROUTE_ABBR','Status=A',"admin" => false,"plugin"=>false)); ?>",
															{
																
																width : 250,
																selectFirst : true,
																valueSelected:true,
																minLength: 3,
																delay: 1000,
																isOrderSet:true,
																showNoId:true,
																loadId : $(this).attr('id')+','+$(this).attr('id').replace("Text_",'_')+','+$(this).attr('id').replace("drugText_",'dose_type')
																+','+$(this).attr('id').replace("drugText_",'strength')
																	+','+$(this).attr('id').replace("drugText_",'route_administration'),
																	
																onItemSelect:function(event, ui) {
																	//lastSelectedOrderSetItem
																	var compositStringArray = lastSelectedOrderSetItem.split("    ");
																	if((compositStringArray[1] !== undefined) && (compositStringArray[1] != '')){
																		var pharmacyIdArray = compositStringArray[1].split("|");
																		var doseId = attrId.replace("drugText_",'dose_type');
																		var routeId = attrId.replace("drugText_",'route_administration');
																		var strengthId = attrId.replace("drugText_",'strength');
																		$("#drug_"+currentId[1]).val(pharmacyIdArray[0]);
																		
																		$("#"+strengthId).val(pharmacyIdArray[2]);
																		if($("#"+strengthId).val() == ''){
																			$("#"+strengthId).append( new Option(pharmacyIdArray[2],pharmacyIdArray[2]) );
																			if(pharmacyIdArray[2]!='')
																			$("#"+strengthId).val(pharmacyIdArray[2]);
																				else
																					$("#"+strengthId).val("Select");
																			$.ajax({

																				  url: "<?php echo $this->Html->url(array("controller" => 'app', "action" => "saveConfiguration", "admin" => false)); ?>",
																				  context: document.body,	
																				  beforeSend:function(){
																				    // this is where we append a loading image
																				    $('#busy-indicator').show('fast');
																					}, 	
																					type: "POST",  
																				  	data:{putArea:pharmacyIdArray[2],searchArea:'strength'},		  
																				  	success: function(data){
																							$('#busy-indicator').hide('slow');
																				  			
																				  	}				  			
																				});
																		}
																		$("#"+routeId).val(pharmacyIdArray[3]);
																		if($("#"+routeId).val() == ''){
																			$("#"+routeId).append( new Option(pharmacyIdArray[3],pharmacyIdArray[3]) );
																			if(pharmacyIdArray[3]!='')
																			$("#"+routeId).val(pharmacyIdArray[3]);
																				else
																					$("#"+routeId).val('Select');
																			$.ajax({

																				  url: "<?php echo $this->Html->url(array("controller" => 'app', "action" => "saveConfiguration1", "admin" => false)); ?>",
																				  context: document.body,	
																				  beforeSend:function(){
																				    // this is where we append a loading image
																				    $('#busy-indicator').show('fast');
																					}, 	
																					type: "POST",  
																				  	data:{putArea:pharmacyIdArray[3],searchArea:'route'},		  
																				  	success: function(data){
																							$('#busy-indicator').hide('slow');
																				  			
																				  	}				  			
																				});
																		}
																		$("#"+doseId).val(pharmacyIdArray[1]);
																		if($("#"+doseId).val() == ''){
																			$("#"+doseId).append( new Option(pharmacyIdArray[1],pharmacyIdArray[1]) );
																			
																			if(pharmacyIdArray[1]!='')
																				$("#"+doseId).val(pharmacyIdArray[1]);
																			else
																				$("#"+doseId).val('Select');
																
																			$.ajax({

																				  url: "<?php echo $this->Html->url(array("controller" => 'app', "action" => "saveConfiguration2", "admin" => false)); ?>",
																				  context: document.body,	
																				  beforeSend:function(){
																				    // this is where we append a loading image
																				    $('#busy-indicator').show('fast');
																					}, 	
																					type: "POST",  
																				  	data:{putArea:pharmacyIdArray[1],searchArea:'dose'},		  
																				  	success: function(data){
																							$('#busy-indicator').hide('slow');
																				  			
																				  	}				  			
																				});
																		}
																	}
																	//$('input:checkbox[name=data[Note][no_medication]]').attr('checked',false);
																	document.getElementById("namecheck").checked = false;
																	$('.submit_button').show();
																	$('#namecheck').attr('disabled', true);
																}
																
															});
											

										});//EOF autocomplete

						$('.drugPack')
								.live(
										'focus',
										function() {
											var counter = $(this).attr(
													"counter");
											$(this)
													.autocomplete(
															"<?php echo $this->Html->url(array("controller" => "Pharmacy", "action" => "getPack","PharmacyItem","name", "admin" => false,"plugin"=>false)); ?>",
															{
																width : 250,
																selectFirst : false,
																extraParams : {
																	drug : $(
																			"#drug"
																					+ counter)
																			.val()
																},
															});

										});//EOF autocomplete

											  
										//add n remove drud inputs
										var counter = '<?php echo $count?>';
										 $("#addButton").click(
													function() {
														$("#quickPatientRagistrationForm").validationEngine('detach'); 
														var newCostDiv = $(document.createElement('tr'))
														     .attr("id", 'DrugGroup' + counter);

														//var start= '<select style="width:80px;" id="start_date'+counter+'" class="" name="start_date[]"><input type="tex">';
														var str_option_value='<?php echo $str;?>';
														var route_option_value='<?php echo $str_route;?>';
														var dose_option_value='<?php echo $str_dose;?>';
														var dose_option ='<select style="width:80px;" id="dose_type'+counter+'" class="" name="dose_type[]"><option value="">Select</option>'+dose_option_value;
														var strength_option = '<select style="width:80px;" id="strength'+counter+'" class="" name="strength[]"><option value="">Select</option>'+str_option_value;
														var route_option = '<select style="width:80px;" id="route_administration'+counter+'" class="" name="route_administration[]"><option value="">Select</option>'+route_option_value;
														var frequency_option = '<select style="width:80px;" id="frequency'+counter+'" class="frequency" name="frequency[]"><option value="">Select</option><option value="as directed">as directed</option><option value="Daily">Daily</option><option value="BID">BID</option><option value="TID">TID</option><option value="QID">QID</option><option value="Q1h WA">Q1h WA</option><option value="Q2h WA">Q2h Wa</option><option value="Q4h">Q4h</option><option value="Q2h">Q2h</option><option value="Q3h">Q3h</option><option value="Q4-6h">Q4-6h</option><option value="Q6h">Q6h</option><option value="Q8h">Q8h</option><option value="Q12h">Q12h</option><option value="Q48h">Q48h</option><option value="Q72h">Q72h</option><option value="Nightly">Nightly</option><option value="QHS">QHS</option><option value="in A.M.">in A.M.</option><option value="Every Other Day">Every Other Day</option><option value="2 Times Weekly">2 Times Weekly</option><option value="3 Times Weekly">3 Times Weekly</option><option value="Q1wk">Q1wk</option><option value="Q2wks">Q2wks</option><option value="Q3wks">Q3wks</option><option value="Once a Month">Once a Month</option><option value="Add\'l Sig">Add\'l Sig</option></select>';
														var refills_option = '<select style="width:80px;" id="refills'+counter+'" class="" name="refills[]"><option value="">Select</option><option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option></select>';
														var prn_option = '<select style="width:80px;" id="prn'+counter+'" class="" name="prn[]"><option value="0">No</option><option value="1">Yes</option></select>';
														var daw_option = '<select style="width:80px;" id="daw'+counter+'" class="" name="daw[]"><option value="1">Yes</option><option value="0">No</option></select>';
														var active_option = '<select style="width:66px;" id="isactive'+counter+'" class="" name="isactive[]"><option value="1">Yes</option><option value="0">No</option></select>';
														var is_adv = '<select style="width:69px;" id="isadv'+counter+'" class="" name="isadv[]"><option value="0">No</option><option value="1">Yes</option></select>';
														//var route_opt = '<td><input type="text" size=2 value="" id="quantity'+counter+'" class="" name="quantity[]"></td>';
														var options = '<option value=""></option>';
											for (var i = 1; i < 25; i++) {
												if (i < 13) {
													str = i + 'am';
												} else {
													str = (i - 12) + 'pm';
												}
												options += '<option value="'+i+'"'+'>'
														+ str + '</option>';
											}

											timerHtml1 = '<td><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center"><tr><td width="25%" height="20" align="center" valign="top"><select class="first" style="width: 80px;" id="first_'+counter+'" disabled="" name="drugTime['+counter+'][]">'
													+ options
													+ '</select></td> ';
											timerHtml2 = '<td width="25%" height="20" align="center" valign="top"><select class="second" style="width: 80px;" id="second_'+counter+'" disabled="" name="drugTime['+counter+'][]">'
													+ options
													+ '</select></td> ';
											timerHtml3 = '<td width="25%" height="20" align="center" valign="top"><select class="third" style="width: 80px;" id="third_'+counter+'" disabled="" name="drugTime['+counter+'][]">'
													+ options
													+ '</select></td> ';
											timerHtml4 = '<td width="25%" height="20" align="center" valign="top"><select class="forth" style="width: 80px;" id="forth_'+counter+'" disabled="" name="drugTime['+counter+'][]">'
													+ options
													+ '</select></td> ';
											timer = timerHtml1 + timerHtml2
													+ timerHtml3 + timerHtml4
													+ '</tr></table></td>';
											<?php //echo $this->Form->input('', array('type'=>'text','size'=>16, 'class'=>'my_start_date','name'=> 'start_date[]', 'id' =>"start_date".$i ,'counter'=>$i )); ?>
											var newHTml = '<td valign="top"><input  type="text" style="width:150px" value="" id="drugText_' + counter + '"  class=" drugText validate[optional,custom[onlyLetterNumber]]" name="drugText[]" autocomplete="off" counter='+counter+'>'+
																'<input  type="hidden"  id="drug_' + counter + '"  name="drug_id[]" ></td><td valign="top">'
													+ dose_option
													+ '</td><td valign="top">'
													+ strength_option
													+ '</td><td valign="top">'
													+ route_option
													+ '</td><td valign="top">'
													+ frequency_option
													+ '</td>'
													+ '<td valign="top"><input size="2" type="text" value="" id="day'+counter+'" class="" name="day[]"></td>'
													+ '<td valign="top"><input size="2" type="text" value="" id="quantity'+counter+'" class="" name="quantity[]"></td>'
													+ '<td valign="top">'
													+ refills_option
													+ '</td>'
													+ '<td valign="top" align="center">'
													+ prn_option
													+ '</td>'
													+ '<td valign="top" align="center">'
													+ daw_option
													+ '</td>'
													+ '<td valign="top" align="center"><input  type="text" value="" id="start_date' + counter + '"  class="my_start_date1 textBoxExpnd" name="start_date[]"  size="16" counter='+counter+'></td>'
													+ '<td valign="top" align="center"><input  type="text" value="" id="end_date' + counter + '"  class="my_end_date1 textBoxExpnd" name="end_date[]"  size="16" counter='+counter+'></td>'
													+ '<td valign="top" align="center"><textarea id="special_instruction' + counter + '"  name="special_instruction[]" style=""  size="2" counter='+counter+'></textarea></td>'
													+ '<td valign="top" align="center">'
													+ active_option
													+'</td>'
													+ '<td valign="top" align="center">'
													+ is_adv
													+ '</td>'
													;

											//newCostDiv.append(newHTml);
											//newCostDiv.appendTo("#DrugGroup");
											//$("#patientnotesfrm").validationEngine('attach'); 			 			 
											newCostDiv.append(newHTml);		 
											newCostDiv.appendTo("#DrugGroup");		
											$("#patientnotesfrm").validationEngine('attach');			 			 
											counter++;
											if (counter > 0)
												$('#removeButton').show('slow');
										});

						$("#removeButton").click(function() {
							/*if(counter==3){
							  alert("No more textbox to remove");
							  return false;
							}  */
							counter--;

							$("#DrugGroup"+counter).remove();
							if (counter == 0)
								$('#removeButton').hide('slow');
						});

						/*	$(".my_start_date").livequery({
									alert('here');
							}); */

						/*$(".my_start_date").live({
							click: function() {
							$(this).after("<p>Another paragraph!</p>");
							});*/
						//EOF add n remove drug inputs

						

						//EOF add/remove medicine textboxes

						$('#note_type').change(function(data) {
							var selOpt = $(this).val();//current type selection
							
							if (selOpt == 'general') {
								$('#notes-link').hide('fast');
								$('#surgery-link').hide('fast');//display one by one 
								$('#implants-link').hide('fast');
								$('#event-note-link').hide('fast');
								$('#post-opt-link').hide('fast');
								$('#pre-opt-link').hide('fast');
								$('#notes').hide('fast');
								$('#surgery').hide('fast');//display one by one 
								$('#implants').hide('fast');
								$('#event-note').hide('fast');
								$('#post-opt').hide('fast');
								$('#pre-opt').hide('fast');

								$('#template_chief_complaint_id').hide('fast');
								$('#template_basic_information_id').hide('fast');
								$('#template_health_status_id').hide('fast');
								
								$('#investigation-link').fadeIn('fast');
								$('#investigation1').fadeIn('fast');
								$('#treatment-link').fadeIn('slow');
								$('#present-cond-link').fadeIn('slow');
								$('#chief-link').fadeIn('slow');
								$('#subjective-link').fadeIn('slow');
								$('#objective-link').fadeIn('slow');
								$('#assessment-link').fadeIn('slow');
								$('#plan-link').fadeIn('slow');
								$('#finalization-link').fadeIn('slow');
								$('#intervention-link').fadeIn('slow');
								$('#rca-link').fadeIn('slow');
								$('#diagnostic-study').hide('fast');
								$('#risk_category_assessment').fadeIn('slow');
								
							} else if (selOpt == 'OT') {
								$('#investigation-link').hide('fast');
								$('#investigation1').hide('fast');
								$('#treatment-link').hide('fast');
								$('#notes-link').hide('slow');
								$('#investigation').hide('fast');
								$('#investigation2').hide('fast');
								$('#treatment').hide('fast');
								$('#notes').hide('fast');
								$('#present-cond-link').hide('fast');
								$('#template_chief_complaint_id').hide('fast');
								$('#template_basic_information_id').hide('fast');
								$('#template_health_status_id').hide('fast');
								$('#chief-link').hide('slow');
								$('#subjective-link').hide('slow');
								$('#objective-link').hide('slow');
								$('#assessment-link').hide('slow');
								$('#plan-link').hide('slow');
								$('#finalization-link').hide('slow');
								$('#present-cond').hide('fast');
								$('#chief').hide('fast');
								$('#subjective').hide('fast');
								$('#objective').hide('fast');
								$('#assessment').hide('fast');
								$('#intervention-link').hide('fast');
								$('#rca-link').hide('fast');
								
								$('#plan').hide('fast');
								$('#finalization').hide('fast');
								$('#post-opt-link').hide('fast');
								$('#post-opt').hide('fast');
								$('#pre-opt').hide('fast');
								$('#implants').hide('fast');
								$('#pre-opt-link').hide('fast');
								$('#surgery-link').fadeIn('500');//display one by one 
								$('#implants-link').fadeIn('1000');
								$('#event-note-link').fadeIn('1500');	
								$('#risk_category_assessment').hide('fast');
								$('#category_assessment').hide('fast');
								
							} else if (selOpt == 'pre-operative') {
								$('#investigation-link').hide('fast');
								$('#investigation1').hide('fast');
								$('#treatment-link').hide('fast');
								$('#notes-link').hide('slow');
								$('#investigation').hide('fast');
								$('#investigation2').hide('fast');
								$('#treatment').hide('fast');
								$('#notes').hide('fast');
								$('#present-cond-link').hide('fast');
								$('#template_chief_complaint_id').hide('fast');
								$('#template_basic_information_id').hide('fast');
								$('#template_health_status_id').hide('fast');
								$('#chief-link').hide('slow');
								$('#subjective-link').hide('slow');
								$('#objective-link').hide('slow');
								$('#assessment-link').hide('slow');
								$('#plan-link').hide('slow');
								$('#finalization-link').hide('slow');
								$('#present-cond').hide('fast');
								$('#chief').hide('fast');
								$('#subjective').hide('fast');
								$('#objective').hide('fast');
								$('#assessment').hide('fast');
								$('#intervention-link').hide('fast');
								$('#rca-link').hide('fast');
								$('#plan').hide('fast');
								$('#finalization').hide('fast');
								$('#surgery').hide('500');//display one by one
								$('#surgery-link').hide('500');//display one by one 
								$('#implants').hide('1000');
								$('#implants-link').hide('1000');
								$('#event-note').hide('fast');
								$('#event-note-link').hide('1500');
								$('#post-opt-link').hide('1500');
								$('#post-opt').hide('1500');
								$('#pre-opt-link').fadeIn('2000');
								$('#risk_category_assessment').hide('fast');
								$('#category_assessment').hide('fast');
								
							} else if (selOpt == 'post-operative') {
								$('#investigation-link').hide('fast');
								$('#investigation1').hide('fast');
								$('#treatment-link').hide('fast');
								$('#notes-link').hide('slow');
								$('#investigation').hide('fast');
								$('#investigation2').hide('fast');
								$('#treatment').hide('fast');
								$('#notes').hide('fast');
								$('#present-cond-link').hide('fast');
								$('#template_chief_complaint_id').hide('fast');
								$('#template_basic_information_id').hide('fast');
								$('#template_health_status_id').hide('fast');
								$('#chief-link').hide('slow');
								$('#subjective-link').hide('slow');
								$('#objective-link').hide('slow');
								$('#assessment-link').hide('slow');
								$('#plan-link').hide('slow');
								$('#finalization-link').hide('slow');
								$('#present-cond').hide('fast');
								$('#chief').hide('fast');
								$('#subjective').hide('fast');
								$('#objective').hide('fast');
								$('#assessment').hide('fast');
								$('#intervention-link').hide('slow');
								$('#rca-link').hide('slow');
								$('#plan').hide('fast');
								$('#finalization').hide('fast');
								$('#surgery').hide('500');//display one by one
								$('#surgery-link').hide('500');//display one by one 
								$('#implants-link').hide('1000');
								$('#implants').hide('1000');
								$('#event-note-link').hide('1500');
								$('#event-note').hide('1500');
								$('#pre-opt-link').hide('fast');
								$('#pre-opt').hide('fast');
								$('#post-opt-link').fadeIn('2000');
								$('#risk_category_assessment').hide('fast');
								$('#category_assessment').hide('fast');

							}
							else if (selOpt == 'template-type') {
								$('#investigation-link').hide('fast');
								$('#aids-link').hide('fast');
								$('#other-link').hide('fast');
								$('#procedurePerform-link').hide('fast');
								$('#cognitiveStatus-link').hide('fast');
								$('#status-result').hide('fast');
								$('#functional-link').hide('fast');
								$('#study-result').hide('fast');
								$('#post-opt-link').hide('fast');
								$('#investigation1').hide('fast');
								$('#treatment-link').hide('fast');
								$('#notes-link').hide('slow');
								$('#investigation').hide('fast');
								$('#investigation2').hide('fast');
								$('#treatment').hide('fast');
								$('#notes').hide('fast');
								$('#present-cond-link').hide('fast');
								$('#chief-link').hide('slow');
								$('#subjective-link').hide('slow');
								$('#objective-link').hide('slow');
								$('#assessment-link').hide('slow');
								$('#plan-link').hide('slow');
								$('#finalization-link').hide('slow');
								$('#present-cond').hide('fast');
								$('#chief').hide('fast');
								$('#subjective').hide('fast');
								$('#objective').hide('fast');
								$('#assessment').hide('fast');
								$('#intervention-link').hide('slow');
								$('#rca-link').hide('slow');
								$('#plan').hide('fast');
								$('#finalization').hide('fast');
								$('#surgery').hide('500');//display one by one
								$('#surgery-link').hide('500');//display one by one 
								$('#implants-link').hide('1000');
								$('#implants').hide('1000');
								$('#event-note-link').hide('1500');
								$('#event-note').hide('1500');
								$('#pre-opt-link').hide('fast');
								$('#pre-opt').hide('fast');
							//	$('#post-opt-link').fadeIn('2000');
								$('#risk_category_assessment').hide('fast');
								$('#category_assessment').hide('fast');

							} else {

								$('#surgery-link').hide('fast');//display one by one 
								$('#implants-link').hide('fast');
								$('#event-note-link').hide('fast');
								$('#post-opt-link').hide('fast');
								$('#pre-opt-link').hide('fast');
								$('#pre-opt').hide('fast');
								$('#investigation-link').hide('fast');
								$('#investigation1').hide('fast');
								$('#treatment-link').hide('fast');
								$('#present-cond-link').hide('fast');

								$('#template_chief_complaint_id').hide('fast');
								$('#template_basic_information_id').hide('fast');
								$('#template_health_status_id').hide('fast');
								
								$('#chief-link').hide('slow');
								$('#subjective-link').hide('slow');
								$('#objective-link').hide('slow');
								$('#assessment-link').hide('slow');
								$('#plan').hide('fast');
								$('#finalization').hide('fast');
								$('#present-cond').hide('fast');
								$('#chief').hide('slow');
								$('#subjective').hide('slow');
								$('#objective').hide('slow');
								$('#assessment').hide('slow');
								$('#plan').hide('fast');
								$('#finalization').hide('fast');
								$('#surgery').hide('fast');//display one by one 
								$('#implants').hide('fast');
								$('#event-note').hide('fast');
								$('#post-opt').hide('fast');
								$('#investigation').hide('fast');
								$('#investigation2').hide('fast');
								$('#treatment').hide('fast');
								$('#pre-opt-link').hide('fast');
								//$('#notes-link').fadeIn('slow');
								$('#intervention-link').hide('slow');
								$('#rca-link').hide('slow');
								$('#risk_category_assessment').hide('fast');
								$('#category_assessment').hide('fast');
							}
						});
						//BOF accordion
						$("#accordionCust")
								.accordion(
										{
											autoHeight: false,
											active : false,
											collapsible : true,
											//autoHeight : true,
											navigation : true,
											//fillSpace: true,
											change : function(event, ui) {

												//BOF template call
												var currentEleID = $(ui.newContent).attr("id"); 
											 
												var replacedID = "templateArea-"+ currentEleID;
												 
												if(currentEleID != 'CPOE'){
								
												if (currentEleID == 'implants'
														|| currentEleID == 'event-note'
														|| currentEleID == 'notes'
														|| currentEleID == 'post-opt'
														|| currentEleID == 'surgery'
														|| currentEleID == 'investigation'
														|| currentEleID == 'investigation2'
														|| currentEleID == 'device_used'
														|| currentEleID == 'symptoms'
														|| currentEleID == 'diagno_study'
														|| currentEleID == 'pre-opt'
														|| currentEleID == 'subjective'
														|| currentEleID == 'objective'
														|| currentEleID == 'assessment'
														|| currentEleID == 'plan'
														//|| currentEleID == 'finalization'
														//|| currentEleID == 'present-cond'
														//|| currentEleID == 'chief'
														//|| currentEleID == 'diagnostic-study'
														//|| currentEleID == 'functional-result'
														//|| currentEleID == 'intervention'
														//|| currentEleID == 'category_assessment'
														//|| currentEleID == 'cognitive'
														//|| currentEleID == 'functional'
														//|| currentEleID == 'aids'
														//|| currentEleID == 'other'
														//|| currentEleID == 'procedure_performed'
														//|| currentEleID == 'treatment'
															) {
													$("#" + replacedID).html($('#temp-busy-indicator').html());

													$("#templateArea-implants").html('');
													$("#templateArea-event-note").html('');
													$("#templateArea-treatment").html('');
													$("#templateArea-notes").html('');
													$("#templateArea-post-opt").html('');
													$("#templateArea-pre-opt").html('');
													$("#templateArea-investigation").html('');
													$("#templateArea-surgery").html('');
													$("#templateArea-present-cond").html('');
													$("#templateArea-chief").html('');
													$("#templateArea-subjective").html('');
													$("#templateArea-objective").html('');
													$("#templateArea-assessment").html('');
													$("#templateArea-plan").html('');
													$("#templateArea-finalization").html('');
													$("#templateArea-diagnostic-study").html('');
													$("#templateArea-functional-result").html('');
													$("#templateArea-intervention").html('');
													$("#templateArea-category_assessment").html('');
													$("#templateArea-cognitive").html('');
													$("#templateArea-functional").html('');
													$("#templateArea-aids").html('');
													$("#templateArea-other").html('');
													$("#templateArea-procedure_performed").html('');
													$("#templateArea-device_used").html('');
													$("#templateArea-symptoms").html('');
													$("#templateArea-diagno_study").html('');
													var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'notes', "action" => "add","admin" => false)); ?>";
													$("#" + currentEleID).css('height', 'auto'); 
													$
															.ajax({type : "POST",
															url : ajaxUrl+ "/"+ currentEleID,
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
												} else {    ////if closed
													$("#templateArea-implants").html('');
													$("#templateArea-event-note").html('');
													$("#templateArea-treatment").html('');
													$("#templateArea-notes").html('');
													$("#templateArea-post-opt").html('');
													$("#templateArea-pre-opt").html('');
													$("#templateArea-investigation").html('');
													$("#templateArea-surgery").html('');
													$("#templateArea-present-cond").html('');
													$("#templateArea-chief").html('');
													$("#templateArea-subjective").html('');
													$("#templateArea-objective").html('');
													$("#templateArea-assessment").html('');
													$("#templateArea-plan").html('');
													$("#templateArea-finalization").html('');
													$("#templateArea-finalization").html('');
													$("#templateArea-diagnostic-study").html('');
													$("#templateArea-functional-result").html('');
													$("#templateArea-intervention").html('');
													$("#templateArea-category_assessment").html('');
													$("#templateArea-cognitive").html('');
													$("#templateArea-functional").html('');
													$("#templateArea-aids").html('');
													$("#templateArea-other").html('');
													$("#templateArea-procedure_performed").html('');
													$("#templateArea-device_used").html('');
													$("#templateArea-symptoms").html('');
													$("#templateArea-diagno_study").html('');
												}  

												}else{
												//	$("#"+replacedID).html($('#temp-busy-indicator').html());
													
												$("#templateArea-implants").html('');
												$("#templateArea-event-note").html('');
												$("#templateArea-treatment").html('');
												$("#templateArea-notes").html('');
												$("#templateArea-post-opt").html('');
												$("#templateArea-pre-opt").html('');
												$("#templateArea-investigation").html('');
												$("#templateArea-surgery").html('');
												$("#templateArea-present-cond").html('');
												$("#templateArea-chief").html('');
												$("#templateArea-subjective").html('');
												$("#templateArea-objective").html('');
												$("#templateArea-assessment").html('');
												$("#templateArea-plan").html('');
												$("#templateArea-finalization").html('');
												$("#templateArea-finalization").html('');
												$("#templateArea-diagnostic-study").html('');
												$("#templateArea-functional-result").html('');
												$("#templateArea-intervention").html('');
												$("#templateArea-category_assessment").html('');
												$("#templateArea-cognitive").html('');
												$("#templateArea-functional").html('');
												$("#templateArea-aids").html('');
												$("#templateArea-other").html('');
												$("#templateArea-procedure_performed").html('');
												$("#templateArea-device_used").html('');
												$("#templateArea-symptoms").html('');
												$("#templateArea-diagno_study").html('');
												
												var patient_id = $('#Patientsid').val();
											 //	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'diagnoses', "action" => "investigation","admin" => false)); ?>"+"/"+patient_id +"/?source=fromNotes";
												var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'diagnoses', "action" => "investigation",$patient_id, 'source'=>'fromNotes','type'=>$patient['Patient']['admission_type']) ,array('escape'=>false)); ?>";
											 	
													$.ajax({  
											 			  type: "POST",						 		  	  	    		
														  url: ajaxUrl,
														  beforeSend: function() {

													           	$("#temp-busy-indicator1").show();
																},
																complete: function() {
																	$("#temp-busy-indicator1").hide();
																},
														  success: function(data){	
															  $("#CPOE").html(data);
															 $("#CPOE").css("height","auto");								   		
														  }
														});
												} ////else close
												//EOF template call
											}

										});
						function resizeElementHeight(element) {
							  var height = 0;
							  var body = window.document.body;
							  if (window.innerHeight) {
							      height = window.innerHeight;
							  } else if (body.parentElement.clientHeight) {
							      height = body.parentElement.clientHeight;
							  } else if (body && body.clientHeight) {
							      height = body.clientHeight;
							  }
							  element.style.height = ((height - element.offsetTop) + "px");
							}
													
						//EOF accordion
						//binds form submission and fields to the validation engine
						$(".drugText").addClass(
								"validate[optional,custom[onlyLetterNumber]]");
						jQuery("#patientnotesfrm").validationEngine();

						jQuery("#patientnotesfrm").submit(
								function() {

									var returnVal = jQuery("#patientnotesfrm")
											.validationEngine('validate');
									//if (returnVal) {jQuery(this).css('display', 'none');}
									//if (returnVal) {$(this).css('display', 'none');}
									//	var singleCheck = jQuery('#drug0')..validationEngine('validate');	
               
									if (returnVal) {
										return true;
										//ajaxPost('patientnotesfrm',
												//'list_content');
									}//alert($("#BPDysto").val());
								});

						function ajaxPost(formname, updateId) {

							$
									.ajax({
										data : $("#" + formname)
												.closest("form").serialize(),
										dataType : "html",
										beforeSend : function() {
											// this is where we append a loading image
											$('#busy-indicator').show('fast');
										},
										success : function(data, textStatus) {
											$('#busy-indicator').hide('slow');
											$("#" + updateId).html(data);

										},
										type : "post",
										url : "<?php echo $this->Html->url((array('controller'=>'patients','action' => 'notesadd')));?>"
									});
						}

						//BOF timer
						$('.frequency').live(
								'change',
								function() {

									id = $(this).attr('id');
									currentCount = id.split("_");
									currentFrequency = $(this).val();
									$('#first_' + currentCount[1]).val('');
									$('#second_' + currentCount[1]).val('');
									$('#third_' + currentCount[1]).val('');
									$('#forth_' + currentCount[1]).val('');
									//set timer
									switch (currentFrequency) {
									case "BD":
										$('#first_' + currentCount[1])
												.removeAttr('disabled');
										$('#second_' + currentCount[1])
												.removeAttr('disabled');
										$('#third_' + currentCount[1]).attr(
												'disabled', 'disabled');
										$('#forth_' + currentCount[1]).attr(
												'disabled', 'disabled');
										break;
									case "TDS":
										$('#first_' + currentCount[1])
												.removeAttr('disabled');
										$('#second_' + currentCount[1])
												.removeAttr('disabled');
										$('#third_' + currentCount[1])
												.removeAttr('disabled');
										$('#forth_' + currentCount[1]).attr(
												'disabled', 'disabled');
										break;
									case "QID":
										$('#first_' + currentCount[1])
												.removeAttr('disabled');
										$('#second_' + currentCount[1])
												.removeAttr('disabled');
										$('#third_' + currentCount[1])
												.removeAttr('disabled');
										$('#forth_' + currentCount[1])
												.removeAttr('disabled');
										break;
									case "OD":
									case "HS":
										$('#first_' + currentCount[1])
												.removeAttr('disabled');
										$('#second_' + currentCount[1]).attr(
												'disabled', 'disabled');
										$('#third_' + currentCount[1]).attr(
												'disabled', 'disabled');
										$('#forth_' + currentCount[1]).attr(
												'disabled', 'disabled');
										break;
									case "Once fort nightly":
										$('#first_' + currentCount[1])
												.removeAttr('disabled');
										$('#second_' + currentCount[1]).attr(
												'disabled', 'disabled');
										$('#third_' + currentCount[1]).attr(
												'disabled', 'disabled');
										$('#forth_' + currentCount[1]).attr(
												'disabled', 'disabled');
										break;
									case "Twice a week":
										$('#first_' + currentCount[1])
												.removeAttr('disabled');
										$('#second_' + currentCount[1]).attr(
												'disabled', 'disabled');
										$('#third_' + currentCount[1]).attr(
												'disabled', 'disabled');
										$('#forth_' + currentCount[1]).attr(
												'disabled', 'disabled');
										break;
									case "Once a week":
										$('#first_' + currentCount[1])
												.removeAttr('disabled');
										$('#second_' + currentCount[1]).attr(
												'disabled', 'disabled');
										$('#third_' + currentCount[1]).attr(
												'disabled', 'disabled');
										$('#forth_' + currentCount[1]).attr(
												'disabled', 'disabled');
										break;
									case "Once a month":
										$('#first_' + currentCount[1])
												.removeAttr('disabled');
										$('#second_' + currentCount[1]).attr(
												'disabled', 'disabled');
										$('#third_' + currentCount[1]).attr(
												'disabled', 'disabled');
										$('#forth_' + currentCount[1]).attr(
												'disabled', 'disabled');
										break;
									case "A/D":
										$('#first_' + currentCount[1])
												.removeAttr('disabled');
										$('#second_' + currentCount[1]).attr(
												'disabled', 'disabled');
										$('#third_' + currentCount[1]).attr(
												'disabled', 'disabled');
										$('#forth_' + currentCount[1]).attr(
												'disabled', 'disabled');
										break;
									}

								});

						$('.first').live(
								'change',
								function() {
									currentValue = Number($(this).val());
									id = $(this).attr('id');
									currentCount = id.split("_");
									currentFrequency = $(
											'#frequency_' + currentCount[1])
											.val();
									hourDiff = 0;
									//set timer
									switch (currentFrequency) {
									case "BD":
										hourDiff = 12;
										break;
									case "TDS":
										hourDiff = 6;
										break;
									case "QID":
										hourDiff = 4;
										break;
									}

									switch (hourDiff) {
									case 12:
										$('#second_' + currentCount[1]).val(
												currentValue + 12);
										break;
									case 6:
										$('#second_' + currentCount[1]).val(
												currentValue + 6);
										$('#third_' + currentCount[1]).val(
												currentValue + 12);
										break;
									case 4:

										$('#second_' + currentCount[1]).val(
												currentValue + 4);
										$('#third_' + currentCount[1]).val(
												currentValue + 8);
										$('#forth_' + currentCount[1]).val(
												currentValue + 12);
										break;
									}
								});
						//EOF timer 
					});
	//----open fancyBox from icd icon----
	
		function icdwin() { 
			var patient_id = $('#Patientsid').val();
			
			//alert(patient_id);
			if (patient_id == '') {
				alert("Please select patient");
				return false;
			}
			$
					.fancybox({ 
						'width' : '70%',
						'height' : '120%',
						'autoScale' : true,
						'transitionIn' : 'fade',
						'transitionOut' : 'fade',
						'type' : 'iframe', 
						'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "snowmed")); ?>" + '/' + patient_id,
						  
					});

		}

		


		function icdwin_intervention() {
			var patient_id = $('#Patientsid').val();
			//alert(patient_id);
			if (patient_id == '') {
				alert("Please select patient");
				return false;
			}
			$
					.fancybox({

						'width' : '70%',
						'height' : '120%',
						'autoScale' : true,
						'transitionIn' : 'fade',
						'transitionOut' : 'fade',
						'type' : 'iframe',
						'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "snowmed_intervention")); ?>" + '/' + patient_id
								
					});

		}


		function icdwin_risk() {
			var patient_id = $('#Patientsid').val();
			//alert(patient_id);
			if (patient_id == '') {
				alert("Please select patient");
				return false;
			}
			$
					.fancybox({

						'width' : '70%',
						'height' : '120%',
						'autoScale' : true,
						'transitionIn' : 'fade',
						'transitionOut' : 'fade',
						'type' : 'iframe',
						'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "snowmed_risk")); ?>" + '/' + patient_id
								
					});

		}

		//---added diagnosis values   undefined|
	
	function openbox_intervention(icd,note_id) {

		var patient_id = $('#Patientsid').val();
		 
		/*$("a").click(function(event) {
			randomID = event.target.html ;
			alert(randomID);
	        $("#place_holder_smowmat").val(randomID);
	    });*/
		//custom_snow_id =  $("#place_holder_smowmat").val(); 
	     
		
		
		if (patient_id == '') {
			alert("Please select patient");
			return false;
		}
		$
				.fancybox({

					'width' : '40%',
					'height' : '80%',
					'autoScale' : true,
					'transitionIn' : 'fade',
					'transitionOut' : 'fade',
					'type' : 'iframe',
					'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "make_diagnosis_intervention")); ?>"
							 + '/' + patient_id + '/' + icd + '/'+note_id 
				});

	}

	
	




	function changecolor() {
		//alert("hello");
		var getchange = "Hypertension Recorded";
		document.getElementById("cr").innerHTML = getchange;
		document.getElementById("cr").style.color = "green";
	}
	//--------------------------------------------- -to use live() in datepicker---------------------------------


	var admissionDate = <?php echo json_encode($splitDate[0]); ?>;
		var explode = admissionDate.split('-');
		$(".my_start_date1").live("focus",function() {

					$(this).datepicker({
								changeMonth : true,
								changeYear : true,
								yearRange : '1950',
								minDate : new Date(explode[0], explode[1] - 1,
										explode[2]),
										dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
								showOn : 'both',
								buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
								buttonImageOnly : true,
								buttonText: "Calendar",
								onSelect : function() {
									$(this).focus();
								}
							});
		});
		var admissionDate = <?php echo json_encode($splitDate[0]); ?>;
		var explode = admissionDate.split('-');
		$(".my_end_date1").live("click",function() {
			
					$(this).datepicker({
								changeMonth : true,
								changeYear : true,
								yearRange : '1950',
								minDate : new Date(explode[0], explode[1] - 1,
										explode[2]),
										dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
								showOn : 'both',
								buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
											buttonImageOnly : true,
											buttonText: "Calendar",
											onSelect : function() {
												$(this).focus();
											}
										});
					});
	//---------------------------------------------end of the datepicker------------------------------------------------
      
		$('#encounter').change(function(){
		    $.ajax({
		      url: "<?php echo $this->Html->url(array("controller" => 'patients', "action" => "getNoteDetail", "admin" => false)); ?>"+"/"+$(this).val(),
		      context: document.body,          
		      success: function(data){ 			      
			      var data1 = eval(data);			 	  
			      var TEMP=data1[0].Note.temp;
			      var PR=data1[0].Note.pr;
			      var RR=data1[0].Note.rr;
			      var BPSysto=data1[0].Note.bp;
			      var BPDysto=data1[0].Note.bp;
			      var spo2=data1[0].Note.spo2;
			      var cc=data1[0].Note.cc; 
			      var subject=data1[0].Note.subject;
			      var object=data1[0].Note.object;
			      var assis=data1[0].Note.assis;
			      var plan=data1[0].Note.plan;
			      var ht=data1[0].Note.ht;
			      var wt=data1[0].Note.wt;
			      var bmi=data1[0].Note.bmi;
			      var post_opt=data1[0].Note.post_opt;
			      var event_note=data1[0].Note.event_note;
			      var pre_opt=data1[0].Note.pre_opt;
			      var note=data1[0].Note.note;
			      var implants=data1[0].Note.implants;
			      var surgery=data1[0].Note.surgery;
			      var investigation=data1[0].Note.investigation;
			      var final1=data1[0].Note.final;
				      //alert(final1);
				  
			      document.getElementById('TEMP').value = TEMP;
			      document.getElementById('PR').value = PR;
			      document.getElementById('RR').value = RR;
			      document.getElementById('BPSysto').value = BPSysto; 
			      document.getElementById('BPDysto').value = BPDysto; 
			      document.getElementById('spo2').value = spo2;
			      document.getElementById('cc').value = cc;
			      document.getElementById('subject_desc').value = subject;
			      document.getElementById('objective_desc').value = object;
			      document.getElementById('assessment_desc').value = assis;
			      document.getElementById('plan_desc').value = plan;
			      document.getElementById('height').value = ht;
			      document.getElementById('weight').value = wt;
			      document.getElementById('bmi').value = bmi;
			      document.getElementById('event_note_desc').value = event_note;
			      document.getElementById('post-opt_desc').value = post_opt;
			      document.getElementById('pre-opt_desc').value = pre_opt;
			      document.getElementById('notes_desc').value = note;
			      document.getElementById('implants_desc').value = implants;
			      document.getElementById('surgery_desc').value = surgery;
			      document.getElementById('investigation_desc').value = investigation;
			    //  document.getElementById('final1').value= '1';
			    document.getElementById('Nutritional counseling').checked = false;
			    document.getElementById('Physical activity counseling').checked = false;
			    document.getElementById('B.M.I - NOT DONE (Medical Reason)').checked = false;
			    document.getElementById('B.M.I - NOT DONE (System Reason)').checked = false;
			    document.getElementById('B.M.I - NOT DONE (Patient Reason)').checked = false;
			    
			      document.getElementById(final1).checked = true;
			      
			     // document.example.test.checked=true
		     	$('#id').val(data);
		     }
		    });
		   });
</script>
<script type="text/javascript">

$('#namecheck').click(function ()
{	currentId = $(this).attr('id') ;
	$('.submit_button').toggle();
	value = $(this).val();
	if(document.getElementById('namecheck').checked){
		$.ajax({
			  type : "POST",
			  url: "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "notesadd",$patient_id, "admin" => false)); ?>",
			  context: document.body,	
			  data : "value="+value,
			  beforeSend:function(){
				 // loading();
			  }, 	  		  
			  success: function(data){					  
				  //$('#busy-indicator').hide('fast');
				 // inlineMsg(currentId,'No madication Prescribed.');
			  }
		});			
	}			
});  	

	jQuery(document).ready(function() {

		var height, /*height_in_meter,*/weight, bmi, message;
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

//function setvalue() {
		//name= $("#description").text() ;
      	//alert('name');
       // $("#inter_snow").html(name);		
//}

function changeTest_inter() {
		

      	var name = $("#icd9cm_inter option:selected").text() ;
      	//alert(name);
      	var code = $("#icd9cm_inter").val();
	splitted= code.split("|");
	
		$("#inter_snow").val(name);
		
}


	
// Cognitive funtion releted js code

	/*function createTitle(data){
		 var options = '';alert('3');
		  $.each(data, function(index, name) {
		  options += '<option value=' + index + '>' + name + '</option>';
		 });
		 return options;
		 }*/
	 
	function snomed_LabRAd_test() 
	{ 
		var searchtest = $('#search_cog').val();
		//alert(searchtest);
		 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "billings", "action" => "snowmed",$patientid,"admin" => false)); ?>";
		
		  //var formData = $('#diagnosisfrm').serialize();
		   $.ajax({
	            type: 'POST',
	           url: ajaxUrl+"/"+searchtest,
	            //data: formData,
	            dataType: 'html',
	            success: function(data){
		             
		            // return ;
	            data = JSON && JSON.parse(data) || $.parseJSON(data);
	            	
	            	titleData = createTitle(data.testTitle);
	            	
	            	codeIndex = data.testCode;
	            	SctCode = data.SctCode;
	            	LonicCode = data.LonicCode;//alert(data.LonicCode);
	            	//alert(SctCode+"sctcocde");

	            	$('#SelectLeft').html(titleData);
	            },
				error: function(message){
	                alert("Internal Error Occured. Unable To Save Data.");
	            },       
	            });
	      
	      return false;
		
	}
	function changeTest() 
	{
		var e = document.getElementById("SelectLeft");
	    var strUser = e.options[e.selectedIndex].text; 
		testnameIndex = e.selectedIndex;
		document.getElementById("cog_snomed_code").value = SctCode[testnameIndex];
		$('#cog_name').val(strUser);
	}
	

	$("#func_name").change(function(){
		if($(this).val() == ''){
			$("#SelectLeft").attr('disabled','');
		}else{
			$("#cog_snomed_code").val($(this).val());
			$("#SelectLeft").attr('disabled','disabled');
			$('#cog_name').val($("#func_name option:selected").text());
		}
	});

	$("#cog_date")
	.datepicker(
			{
				showOn : "button",
				buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly : true,
				changeMonth : true,

				changeYear : true, 

				dateFormat:'<?php echo $this->General->GeneralDate(false);?>',
				onSelect : function() {
					$(this).focus();
					//foramtEnddate(); //is not defined hence commented
				}
				
			});	


// Js code for functional status

	function createTitle(data){
		 var options = '';alert(data);
		  $.each(data, function(index, name) {
		  options += '<option value=' + index + '>' + name + '</option>';
		 });
		 return options;
		 }
	 
	function snomed_LabRAd_test1() 
	{ 
		var searchtest = $('#search_funct').val();
		//alert(searchtest);
		 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "billings", "action" => "snowmed",$patientid,"admin" => false)); ?>";
		
		  //var formData = $('#diagnosisfrm').serialize();
		   $.ajax({
	            type: 'POST',
	           url: ajaxUrl+"/"+searchtest,
	            //data: formData,
	            dataType: 'html',
	            success: function(data){
		        data = JSON && JSON.parse(data) || $.parseJSON(data);
	            	
	            	titleData = createTitle(data.testTitle);
	            	
	            	codeIndex = data.testCode;
	            	SctCode = data.SctCode;
	            	LonicCode = data.LonicCode;//alert(data.LonicCode);
	            	//alert(SctCode+"sctcocde");

	            	$('#SelectLeft_funct').html(titleData);
	            },
				error: function(message){
	                alert("Internal Error Occured. Unable To Save Data.");
	            },       
	            });
	      
	      return false;
		
	}
	function changeTest1() 
	{
		var e = document.getElementById("SelectLeft_funct");
	    var strUser = e.options[e.selectedIndex].text; 
		testnameIndex = e.selectedIndex;
		document.getElementById("funct_snomed_code").value = SctCode[testnameIndex];
		$('#funct_name').val(strUser);
	}
	

	$("#function_name").change(function(){
		if($(this).val() == ''){
			$("#SelectLeft_funct").attr('disabled','');
		}else{
			$("#funct_snomed_code").val($(this).val());
			$("#SelectLeft_funct").attr('disabled','disabled');
			$('#funct_name').val($("#function_name option:selected").text());
		}
	});

	$( "#func_date" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,  		
			yearRange: '1950',			 
			dateFormat:'<?php echo $this->General->GeneralDate(false);?>',
		});
	
	
	

	//vitals calender
	$( "#vital_date" ).datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',			 
		dateFormat:'<?php echo $this->General->GeneralDate(false);?>',
		minDate:new Date(<?php echo date("Y", strtotime($patient['Patient']['form_received_on']))?>,<?php echo date("m", strtotime($patient['Patient']['form_received_on'])) -1?>,<?php echo date("d", strtotime($patient['Patient']['form_received_on']))?>),
		onSelect: function(){
			var dateval = $("#intrinsic_date").val();
			var patientid = $("#patientid").val();
			//window.location.href = '<?php echo $this->Html->url('/hospital_acquire_infections/index/'); ?>'+patientid+'/'+dateval;
           // $("#intrinsic_date").action = "<?php echo $this->Html->url('/hospital_acquire_infections/index'); ?>"
			//alert($( "#intrinsic_date" ).val());
		}
	});

	$( "#finalization_date" ).datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',			 
		dateFormat:'<?php echo $this->General->GeneralDate(false);?>',
		minDate:new Date(<?php echo date("Y", strtotime($patient['Patient']['form_received_on']))?>,<?php echo date("m", strtotime($patient['Patient']['form_received_on'])) -1?>,<?php echo date("d", strtotime($patient['Patient']['form_received_on']))?>),
		onSelect: function(){
			var dateval = $("#intrinsic_date").val();
			var patientid = $("#patientid").val();
			//window.location.href = '<?php echo $this->Html->url('/hospital_acquire_infections/index/'); ?>'+patientid+'/'+dateval;
           // $("#intrinsic_date").action = "<?php echo $this->Html->url('/hospital_acquire_infections/index'); ?>"
			//alert($( "#intrinsic_date" ).val());
		}
	});

//--------------PLan gaurav

$(".DatePicker")
	.datepicker(
			{
				showOn : "button",
				buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly : true,
				changeMonth : true,

				changeYear : true, 

				dateFormat:'<?php echo $this->General->GeneralDate(false);?>',
				onSelect : function() {
					$(this).focus();
					//foramtEnddate(); //is not defined hence commented
				}
				
			});


var testnameIndex = '';
	var codeIndex = new Array();
	var SctCode = new Array();
		function LoadProblem() 
		{ 
			var e = document.getElementById("problem");
	        var strUser = e.options[e.selectedIndex].text; 
			testnameIndex = e.selectedIndex;
			document.getElementById("SNOMED_DESCRIPTION").value = strUser;
			document.getElementById("SCT_US_CONCEPT_ID").value = codeIndex[testnameIndex];
			document.getElementById("SCT_CONCEPT_ID").value = SctCode[testnameIndex];
			
		}
		
		function createSnomedTitle(data){
			 var options = '';
			  $.each(data, function(index, name) {
			  options += '<option value=' + index + '>' + name.SnomedMappingMaster.sctName + '</option>';
			  codeIndex[index] = name.SnomedMappingMaster.referencedComponentId;
			  SctCode[index] = name.SnomedMappingMaster.referencedComponentId;
			 });
			 return options;
			 } 
		
function snomed_problem() 
	{ 

	patientid="<?php echo $data[Patient][id] ?>";
	var searchtest = $('#searchProcedure').val();
	if(searchtest == '') {
		var searchtest = $('#searchResult').val();
	}

	 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "diagnoses", "action" => "snowmed","admin" => false)); ?>"+'/'+patientid+'/'+searchtest;
	  var formData = $('#patientnotesfrm').serialize();
	
	   $.ajax({
           type: 'POST',
          url: ajaxUrl,
           data: formData,
           dataType: 'html',
           //--------------
           beforeSend: function() {

           	$("#temp-busy-Plan").show();
           	$("#temp-busy-func").show();
           	$("#temp-busy-Dignostic").show();
			},
			complete: function() {
				$("#temp-busy-Plan").hide();
				$("#temp-busy-func").hide();
	           	$("#temp-busy-Dignostic").hide();
			}, 
           //-------------SNOMED_DESCRIPTION SCT_US_CONCEPT_ID SCT_CONCEPT_ID
           success: function(data){ 
	        
           data = JSON && JSON.parse(data) || $.parseJSON(data);
           	titleData = createSnomedTitle(data);
			//codeIndex = data.SnomedMappingMaster.referencedComponentId;
           //	SctCode = data.SnomedMappingMaster.referencedComponentId;
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

function dbProblem(from){

		  
		  if(from=='digresult')
		  {
                     var ajaxUrl = "<?php  echo $this->Html->url(array("controller" => "Patients", "action" => "dbproblem_diagnosisstatusresult","admin" => false)); ?>";
		      var problem = $('#dbprocedure').val();
		  }
		  else if(from=='funcresult')
		  {
		     var ajaxUrl = "<?php  echo $this->Html->url(array("controller" => "Patients", "action" => "dbproblem_functionalstatusresult","admin" => false)); ?>";
		     var problem = $('#dbprocedureRe').val();
		  }
		  else if(from=='riskcatass')
		  {
		     var ajaxUrl = "<?php  echo $this->Html->url(array("controller" => "Patients", "action" => "dbproblem_riskcategoryassesment","admin" => false)); ?>";
		      var problem = $('#icd9cm_risk').val();
		  }
		  else if(from=='intervention')
		  {
		    var ajaxUrl = "<?php  echo $this->Html->url(array("controller" => "Patients", "action" => "dbproblem","admin" => false)); ?>";
		      var problem = $('#icd9cm_inter').val();
		  }
		  else
		  {
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
	       

                if(from=='digresult')
		{
	           $("#Procedure_description").val(data[0]);       
	           $("#test_code").val(data[1]);
	           $("#snomed_code").val(data[2]);
	           $("#loinc_code").val(data[3]);

		 }
		else if(from=='funcresult')
                {
	          $("#result_description").val(data[0]);       
	          $("#test_codeRe").val(data[1]);
	          $("#snomed_codeRe").val(data[2]);
	          $("#loinc_codeRe").val(data[3]);

		}
		else if(from=='riskcatass')
                {
	          $("#risk_category_name").val(data[0]);       
	       $("#snomed_code_risk").val(data[2]);
	        $("#lonic_code_risk").val(data[3]);

		}
		else if(from=='intervention')
		{

	        $("#intervention_name").val(data[0]);       
	        //$("#test_codepr").val(data[1]);
	        $("#snomed_codepr").val(data[2]);
	        $("#lonic_code_inter").val(data[3]);
		}
		else
		{

		   $("#SNOMED_DESCRIPTION").val(data[0]);
	           $("#SCT_US_CONCEPT_ID").val(data[3]);
	           $("#SCT_CONCEPT_ID").val(data[2]);
		   
		}

	       
	        
	        },
				
				error: function(message){
	              alert("Internal Error Occured. Unable to set data.");
	          }        });
	    
	    return false; 
	}




function intervention(){
	 
	  var problem = $('#icd9cm_inter').val();
	  
	  var ajaxUrl = "<?php  echo $this->Html->url(array("controller" => "Patients", "action" => "procedure_problem","admin" => false)); ?>";
      $.ajax({
        type: 'POST',
        url: ajaxUrl+"/"+problem,
        data: '',
        dataType: 'html',
        success: function(data){ 
       
     	var data = data.split("|");	
      

      $("#intervention_name").val(data[0]);       
      $("#test_code").val(data[1]);
      $("#snomed_code").val(data[2]);

     
      },
			
			error: function(message){
            alert("Internal Error Occured. Unable to set data.");
        }        });
  
  return false; 
}
	

	function show_textarea(){
		
		if($('#is_followup').attr('checked')) {
		    $("#follow_doc").show();
		} else {
		    $("#follow_doc").hide();
		}
		}

	//------problem

	function save_problem(){
		
		switch (true) {
		case ($('#plan_date').val() == '' && $('#SNOMED_DESCRIPTION').val() == ''):
			 alert('Please Enter Problem Name and Date.');
            return false;
        case ($('#SNOMED_DESCRIPTION').val() == '' && $('#plan_date').val() != ''):
            alert('Please Enter Problem Name.');
        	return false;
        case ($('#plan_date').val() == '' && $('#SNOMED_DESCRIPTION').val() != '' ):
           alert("Please Enter Date.");
        	return false;
        
   		 }
	    
		 patientid="<?php echo $data[Patient][id] ?>";
		
	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "save_problemPlan","admin" => false)); ?>";

	 var formData = $('#patientnotesfrm').serialize();
	  
	  
           $.ajax({
            type: 'POST',
           url: ajaxUrl+"/"+patientid,
            data: formData,
            dataType: 'html',
            success: function(data){
                if(data != 'error'){
            	 alert("Plan Sucessfully Saved");
            	 window.location.reload();
            	$("#SNOMED_DESCRIPTION").val('');
		        $("#SCT_US_CONCEPT_ID").val('');
		        $("#SCT_CONCEPT_ID").val('');
		        $("#instruction").val('');
		        $("#id").val('');
		        $('#is_followup').attr('checked',false);
		        $("#follow_doc").hide();
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


	function edit_problem(id){
		
		  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "edit_problem","admin" => false)); ?>";
		   var formData = $('#patientnotesfrm').serialize();
	           $.ajax({
	            type: 'POST',
	           url: ajaxUrl+"/"+id,
	            data: formData,
	            dataType: 'html',
	            success: function(data){
				var data = data.split("|");	
		        $("#SNOMED_DESCRIPTION").val(data[0]);
		        $("#SCT_US_CONCEPT_ID").val(data[1]);
		        $("#SCT_CONCEPT_ID").val(data[2]);
		        $("#instruction").val(data[3]);
		        $("#id").val(data[4]);
		        $("#plan_date").val(data[5]);
		        if(data[3] != ''){
		        	$('#is_followup').attr('checked','checked');
		        	$("#follow_doc").show();
		        	 }	
	            },


	            
				error: function(message){
					alert("Error in Retrieving data");
	            }        });
	      
	      return false; 
	}

	function delete_Problem(id){
		if (confirm("Are you sure?")) {
	       var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "delete_problem","admin" => false)); ?>";
		   var formData = $('#patientnotesfrm').serialize();
	           $.ajax({
	            type: 'POST',
	           url: ajaxUrl+"/"+id,
	            data: formData,
	            dataType: 'html',
	            success: function(data){
	            	alert('Record Deleted Sucessfully');

	            	$('#plan'+id).hide();
	            	
	            },
				error: function(message){
					alert("Cannot Process Your Request");
	            }        });
	      
	     
		 }
	    return false;
	}

	//Code for Event Summary
function save_event(){
		
	patientid="<?php echo $data[Patient][id] ?>";
		
	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "save_discharge_event","admin" => false)); ?>";

	 var formData = $('#patientnotesfrm').serialize();
           $.ajax({
            type: 'POST',
           url: ajaxUrl+"/"+patientid,
            data: formData,
            dataType: 'html',
            success: function(data){
                if(data != 'error'){
            	 alert("Event Saved Successfully");
            	$("#event_discharge").val('');
		        $('#is_event').attr('checked',false);
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
		 patientid="<?php echo $data[Patient][id] ?>";
		
	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "save_interventions","admin" => false)); ?>";

	 var formData = $('#patientnotesfrm').serialize();
	  
	  
         $.ajax({
          type: 'POST',
         url: ajaxUrl+"/"+patientid,
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
	            }        });
	      
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
		 
		 patientid="<?php echo $data[Patient][id] ?>";
		
	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "save_riskCategory","admin" => false)); ?>";

	 var formData = $('#patientnotesfrm').serialize();
	  
	  
        $.ajax({
         type: 'POST',
        url: ajaxUrl+"/"+patientid,
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
	            }        });
	      
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
	            }        });
	      
	     
		 }
	    return false;
	}
	//----------EOF of function related to intervention------------
	$(document).ready(function(){		
	$("#procedure_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","TariffList","id","name","null", "admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true,
			loadId:'procedure_name,code_value',
			showNoId:true,
			valueSelected:true,
			onItemSelect:function(  ) { 
				var snomwID = $('#code_value').val();//code_type
				var URL = "<?php echo $this->Html->url(array('controller' => 'patients', 'action' => 'snowmedId','admin' => false,'plugin'=>false)); ?>";
				 $.ajax({
					  type: "GET",
					  url: URL+"/"+snomwID,
					  success : function ( data ){ 
						  var patientData = jQuery.parseJSON(data);
						  console.log(patientData);
						  $('#code_type').val(patientData.TariffList.code_type);
						/*  var strCpt = "cpt";
						  var resstrCpt = strCpt.toUpperCase();
						  var strHcpcs = "Hcpcs";
						  var resstrHcpcs = strHcpcs.toUpperCase();*/
						  if(patientData.TariffList.code_type=='CPT'){
							  $('#code_value').val(patientData.TariffList.cbt);
						  }else if(patientData.TariffList.code_type=='hcpcs'){
							  $('#code_value').val(patientData.TariffList.hcpcs);
						  }//alert(patientData.TariffList.cbt);						  
					 }
					});
			 }		
			/*onItemSelect:function (){
				dbProcedureperform();
				}*/
		});
});
	
	//----------BOF of function related to Procedure Perform------------
	/*function dbProcedureperform1(){
		
		   $('#code_C_type').val($('#code_type option:selected').text());	
			//$("#code_C_type").val(problem);
		   $('#p_name').val($('#procedure_name').text());
		   var problemCodeType = $('#procedure_name').val();  alert(problemCodeType);	  
		   $("#code_type").val(problemCodeType); 
		   var problemCode = $('#procedure_name').val(); alert(problemCode);
		   var spCode= problemCode.split('- ('); alert(spCode);
		   //var resCode = spCode[1].replace(')',''); alert(resCode);
		   $("#code_value").val(resCode);
		   $('#p_daignosis_name').val($('#patient_daignosis option:selected').text());
		   
		    
		    return false; 
		}*/
	
	function save_procedure_perform(){
		/* $('#code_C_type').val($('#code_type option:selected').text());
		  $('#p_name').val($('#procedure_name option:selected').text());*/
		 // var pDaignosisName = $('#patient_daignosis option:selected').text();  alert(pDaignosisName);	  
		  // $("#code_type").val(problemCodeType); 
		 // $('#p_daignosis_name').val($('#patient_daignosis option:selected').text());
		switch (true) {
		case ($('#procedure_perform_date').val() == '' && $('#procedure_name').val() == ''):
			 alert('Please Enter Procedure Name and Date.');
	        return false;
	    case ($('#procedure_name').val() == '' && $('#procedure_perform_date').val() != ''):
	        alert('Please Enter Procedure Name.');
	    	return false;
	    case ($('#procedure_perform_date').val() == '' && $('#procedure_name').val() != '' ):
	       alert("Please Enter Date.");
	    	return false;	    
			 }		
		 patientid="<?php echo $data[Patient][id] ?>";		
	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "save_procedurePerform","admin" => false)); ?>";
	 var formData = $('#patientnotesfrm').serialize();	  
       $.ajax({
        type: 'POST',
       url: ajaxUrl+"/"+patientid,
        data: formData,
        dataType: 'html',
        success: function(data){
        	 if(data !='Please Insert Data'){
        	 alert("Procedure Sucessfully Saved");
        	 window.location.reload();
        	$("#procedure_name").val('');
		        $("#code_value").val('');
		        $("#code_type").val('');
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

	function edit_procedure_perform(id){		
		  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "edit_procedurePerform","admin" => false)); ?>";
		   var formData = $('#patientnotesfrm').serialize();
	           $.ajax({
	            type: 'POST',
	           url: ajaxUrl+"/"+id,
	            data: formData,
	            dataType: 'html',
	            success: function(data){
				var data = data.split("|");	
		        $("#procedure_name").val($.trim(data[0]));
		        $("#code_value").val(data[1]);
		        $("#procedure_note").val(data[2]);
		        $("#pro_id").val(data[3]);
		        $("#procedure_perform_date").val(data[5]);
		        $("#procedure_to_date").val(data[6]);
		        $("#modifier1").val(data[7]);
		        $("#modifier2").val(data[8]);
		        $("#modifier3").val(data[9]);
		        $("#modifier4").val(data[10]);  
		        $("#code_type").val(data[11]);     
		        $("#units").val(data[13]);     
		        $("#place_service").val(data[14]);

		        patientDiagnosis = $.parseJSON(data[12]);
		        $(patientDiagnosis).each(function(val,text){
			        //alert(text);
		        	//$("#patient_daignosis option").eq(text).attr('selected','selected');
		        	$("select#patient_daignosis option[value='" + text + "']").attr("selected", "selected");
		        	 
			    });

		       // $("#patient_daignosis option[value='Unspecified choroidal hemorrhage : (I10)']").attr("selected", "selected");
		       // $("#patient_daignosis option[value='Unspecified choroidal hemorrhage : (H31.309)']").attr("selected", "selected");
		        

		        
		       // $("#patient_daignosis").val(data[12]);
		             
	            },
				error: function(message){
					alert("Error in Retrieving data");
	            }        });
	      
	      return false; 
	}

	
	function delete_procedure_perform(id){
		if (confirm("Are you sure?")) {
	       var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "delete_procedurePerform","admin" => false)); ?>";
		   var formData = $('#patientnotesfrm').serialize();
	           $.ajax({
	            type: 'POST',
	           url: ajaxUrl+"/"+id,
	            data: formData,
	            dataType: 'html',
	            success: function(data){
	            	alert('Record Deleted Sucessfully');
	            	$('#procedurePerform'+id).hide();
	            },
				error: function(message){
					alert("Cannot Process Your Request");
	            }        });	     
		 }
	    return false;
	}
//Bof function related to device used accordian
	function device_onchange(){
		   var problem = $('#device_detail').val(); 
		  
			  var ajaxUrl = "<?php  echo $this->Html->url(array("controller" => "Patients", "action" => "device_onChange","admin" => false)); ?>";
		        $.ajax({
		          type: 'POST',
		          url: ajaxUrl+"/"+problem,
		          data: '',
		          dataType: 'html',
		          success: function(data){ 
		         
		       	var data = data.split("|");	
		       	
		        

		        $("#device_name").val(data[0]);       
		        
		        $("#device_sno").val(data[1]);
		        },
					
					error: function(message){
		              alert("Internal Error Occured. Unable to set data.");
		          }        });
		    
		    return false; 
		}


	function save_device(){
		 patientid="<?php echo $data[Patient][id] ?>";
		
	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "save_devices","admin" => false)); ?>";

	 var formData = $('#patientnotesfrm').serialize();
	  
	  
      $.ajax({
       type: 'POST',
      url: ajaxUrl+"/"+patientid,
       data: formData,
       dataType: 'html',
       success: function(data){
       	 if(data !='Please Insert Data'){
       	 alert("Device Sucessfully Saved");
       	$("#device_name").val('');
		        $("#code_value").val('');
		        $("#dev_id").val('');
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

	function edit_device(id){
		
		  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "edit_devices","admin" => false)); ?>";
		   var formData = $('#patientnotesfrm').serialize();
	           $.ajax({
	            type: 'POST',
	           url: ajaxUrl+"/"+id,
	            data: formData,
	            dataType: 'html',
	            success: function(data){
				var data = data.split("|");	
		        $("#device_name").val(data[0]);
		        $("#device_sno").val(data[1]);
		        $("#device_note").val(data[2]);
		        $("#dev_id").val(data[3]);
		        $("#device_date").val(data[5]);
		        
		       
	            },
				error: function(message){
					alert("Error in Retrieving data");
	            }        });
	      
	      return false; 
	}



	function delete_device(id){
		if (confirm("Are you sure?")) {
	       var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "delete_devices","admin" => false)); ?>";
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
//eof device

//bof function related to symptoms
	function symptom_onchange(){
		   var problem = $('#symptom_detail').val(); 
		  
			  var ajaxUrl = "<?php  echo $this->Html->url(array("controller" => "Patients", "action" => "symptom_onChange","admin" => false)); ?>";
		        $.ajax({
		          type: 'POST',
		          url: ajaxUrl+"/"+problem,
		          data: '',
		          dataType: 'html',
		          success: function(data){ 
		         
		       	var data = data.split("|");	
		       	
		        

		        $("#symptom_name").val(data[0]);       
		        
		        $("#symptom_sno").val(data[1]);
		        },
					
					error: function(message){
		              alert("Internal Error Occured. Unable to set data.");
		          }        });
		    
		    return false; 
		}

	function save_symptom(){

		switch (true) {
		case ($('#symptom_date').val() == '' && $('#symptom_name').val() == ''):
			 alert('Please Enter Symptom Name and Date.');
	        return false;
	    case ($('#symptom_name').val() == '' && $('#symptom_date').val() != ''):
	        alert('Please Enter Symptom Name.');
	    	return false;
	    case ($('#symptom_date').val() == '' && $('#symptom_name').val() != '' ):
	       alert("Please Enter Date.");
	    	return false;
	    
			 }
		 
		 patientid="<?php echo $data[Patient][id] ?>";
		
	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "save_symptoms","admin" => false)); ?>";

	 var formData = $('#patientnotesfrm').serialize();
	  
	  
     $.ajax({
      type: 'POST',
     url: ajaxUrl+"/"+patientid,
      data: formData,
      dataType: 'html',
      success: function(data){
      	 if(data !='Please Insert Data'){
      	 alert("Symptom Sucessfully Saved");
      	$("#symptom_name").val('');
		        $("#symptom_sno").val('');
		        $("#sym_id").val('');
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


	function edit_symptom(id){
		
		  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "edit_symptoms","admin" => false)); ?>";
		   var formData = $('#patientnotesfrm').serialize();
	           $.ajax({
	            type: 'POST',
	           url: ajaxUrl+"/"+id,
	            data: formData,
	            dataType: 'html',
	            success: function(data){
				var data = data.split("|");	
		        $("#symptom_name").val(data[0]);
		        $("#symptom_sno").val(data[1]);
		        $("#symptom_note").val(data[2]);
		        $("#sym_id").val(data[3]);
		        $("#symptom_date").val(data[5]);
		        
		       
	            },
				error: function(message){
					alert("Error in Retrieving data");
	            }        });
	      
	      return false; 
	}


	function delete_symptom(id){
		if (confirm("Are you sure?")) {
	       var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "delete_symptoms","admin" => false)); ?>";
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
//eof function related to symptom----------
	function patient_char_onchange(){
		    var patient_id = $('#Patientsid').val(); 
		  
			  var ajaxUrl = "<?php  echo $this->Html->url(array("controller" => "Patients", "action" => "patient_char_onChange","admin" => false)); ?>";
		        $.ajax({
		          type: 'POST',
		          url: ajaxUrl+"/"+patient_id,
		          data: '',
		          dataType: 'html',
		          success: function(data){ 
		         
		       	var data = data.split("|");	
		       	
		        

		        $("#patient_character").val(data[0]);       
		        
		        $("#patient_char_sno").val(data[1]);
		        },
					
					error: function(message){
		              alert("Internal Error Occured. Unable to set data.");
		          }        });
		    
		    return false; 
		}

//bof of function related to diagnostic study
	function diagnostic_onchange(){
		   var problem = $('#diagnostic_detail').val(); 
		  
			  var ajaxUrl = "<?php  echo $this->Html->url(array("controller" => "Patients", "action" => "diagnostic_onChange","admin" => false)); ?>";
		        $.ajax({
		          type: 'POST',
		          url: ajaxUrl+"/"+problem,
		          data: '',
		          dataType: 'html',
		          success: function(data){ 
		         
		       	var data = data.split("|");	
		       	
		        

		        $("#diagnostic_name").val(data[0]);       
		        
		        $("#lonic_code").val(data[1]);
		        },
					
					error: function(message){
		              alert("Internal Error Occured. Unable to set data.");
		          }        });
		    
		    return false; 
		}

				function save_diagnostic(){
					 patientid="<?php echo $data[Patient][id] ?>";
					
				  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "save_diagnostics","admin" => false)); ?>";

				 var formData = $('#patientnotesfrm').serialize();
				  
				  
			     $.ajax({
			      type: 'POST',
			     url: ajaxUrl+"/"+patientid,
			      data: formData,
			      dataType: 'html',
			      success: function(data){
			      	 if(data !='Please Insert Data'){
			      	 alert("Diagnostic Sucessfully Saved");
			      	$("#diagnostic_name").val('');
					        $("#lonic_code").val('');
					        $("#diagno_id").val('');
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


				function edit_diagnostic(id){
					
					  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "edit_diagnostics","admin" => false)); ?>";
					   var formData = $('#patientnotesfrm').serialize();
				           $.ajax({
				            type: 'POST',
				           url: ajaxUrl+"/"+id,
				            data: formData,
				            dataType: 'html',
				            success: function(data){
							var data = data.split("|");	
					        $("#diagnostic_name").val(data[0]);
					        $("#lonic_code").val(data[1]);
					        $("#diagnostic_note").val(data[2]);
					        $("#diagno_id").val(data[3]);
					        $("#diagnostic_date").val(data[5]);
					        
					       
				            },
							error: function(message){
								alert("Error in Retrieving data");
				            }        });
				      
				      return false; 
				}


				function delete_diagnostic(id){
					if (confirm("Are you sure?")) {
				       var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "delete_diagnostics","admin" => false)); ?>";
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

//eof function related to diagnostic study
	//----------BOF of function related to intervention------------
	
	function save_procedure(){

		switch (true) {
		case ($('#procedure_date').val() == '' && $('#Procedure_description').val() == ''):
			 alert('Please Enter Procedure Name and Date.');
            return false;
        case ($('#Procedure_description').val() == '' && $('#procedure_date').val() != ''):
            alert('Please Enter Procedure Name.');
        	return false;
        case ($('#procedure_date').val() == '' && $('#Procedure_description').val() != '' ):
           alert("Please Enter Date.");
        	return false;
        
   		 }
		 patientid="<?php echo $data[Patient][id] ?>";
		
	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "save_procedure","admin" => false)); ?>";

	 var formData = $('#patientnotesfrm').serialize();
	  
	  
           $.ajax({
            type: 'POST',
           url: ajaxUrl+"/"+patientid,
            data: formData,
            dataType: 'html',
            success: function(data){
            	 alert("Procedure Sucessfully Saved");
            	
		        $("#Procedure_description").val('');
		        $("#test_code").val('');
		        $("#loinc_code").val('');
		        $("#snomed_code").val('');
		        $("#cpt_code").val('');
		        $("#procedure_date").val('');
		        $("#procedure_instruction").val('');
		        $("#dignostic_id").val('');
		        $("#vte_confirm").attr('checked',false);
	          },
			error: function(message){
                alert("Internal Error Occured. Unable To Save Data.");
            }        
            });
      
      return false;
	}
	
	function save_order_set_medication(){
		patientid="<?php echo $data[Patient][id] ?>";
		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "save_order_set","admin" => false)); ?>";
		var formData = $('#patientnotesfrm').serialize();
           $.ajax({
            type: 'POST',
           url: ajaxUrl+"/"+patientid,
            data: formData,
            dataType: 'html',
            success: function(data){
            	 ///alert("Medication Sucessfully Saved");
	          },
			error: function(message){
                alert("Internal Error Occured. Unable To Save Data.");
            }        
            });
      
    
	  
	}
	function callOrderSetSave(){
	
	save_order_set_medication();
	save_order_set_lab();
	save_order_set_rad();
	save_order_set_ekg();
	
	}
	function save_order_set_ekg(){
	
	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "save_order_ekg","admin" => false)); ?>";
	 var formData = $('#patientnotesfrm').serialize();
           $.ajax({
            type: 'POST',
           url: ajaxUrl+"/"+patientid,
            data: formData,
            dataType: 'html',
            success: function(data){
            	 alert("Sucessfully Saved");
	          },
			error: function(message){
                alert("Internal Error Occured. Unable To Save Data.");
            }        
            });
      
     
	  
	}
	
	function save_order_set_rad(){
	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "save_order_rad","admin" => false)); ?>";
	 var formData = $('#patientnotesfrm').serialize();
           $.ajax({
            type: 'POST',
           url: ajaxUrl+"/"+patientid,
            data: formData,
            dataType: 'html',
            success: function(data){
            	// alert("Sucessfully Saved");
	          },
			error: function(message){
                alert("Internal Error Occured. Unable To Save Data.");
            }        
            });
      
   
	  
	}
	
	function save_order_set_lab(){
	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "save_order_lab","admin" => false)); ?>";
	  var formData = $('#patientnotesfrm').serialize();
	       $.ajax({
            type: 'POST',
           url: ajaxUrl+"/"+patientid,
            data: formData,
            dataType: 'html',
            success: function(data){
            	// alert("Laboratory Sucessfully Saved");
	          },
			error: function(message){
                alert("Internal Error Occured. Unable To Save Data.");
            }        
            });
      
  
	  
	}

	function edit_procedure(id){
		
		  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "edit_procedure","admin" => false)); ?>";
		   var formData = $('#patientnotesfrm').serialize();
	           $.ajax({
	            type: 'POST',
	           url: ajaxUrl+"/"+id,
	            data: formData,
	            dataType: 'html',
	            success: function(data){
				var data = data.split("|");	
		        $("#Procedure_description").val(data[0]);
		        $("#test_code").val(data[1]);
		        $("#loinc_code").val(data[2]);
		        $("#snomed_code").val(data[3]);
		        $("#cpt_code").val(data[4]);
		        $("#procedure_date").val(data[5]);
		        $("#procedure_instruction").val(data[6]);
		        $("#dignostic_id").val(data[7]);
		        if(data[8]!=''){
			        $("#vte_confirm").attr('checked','checked');;
			        }
		        
	            },
				error: function(message){
					alert("Error in Retrieving data");
	            }        });
	      
	      return false; 
	}

	function delete_procedure(id){
		if (confirm("Are you sure?")) {
	       var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "delete_Procedure","admin" => false)); ?>";
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
	 
		 patientid="<?php echo $data[Patient][id] ?>";
		
	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "save_result","admin" => false)); ?>";

	 var formData = $('#patientnotesfrm').serialize();
	  
	  
           $.ajax({
            type: 'POST',
           url: ajaxUrl+"/"+patientid,
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
	            }        });
	      
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
	            }        });
	      
	     
		 }
	    return false;
	}



	$("#medication_order_date")
	.datepicker(
			{
				showOn : "button",
				buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly : true,
				changeMonth : true,

				changeYear : true, 

				dateFormat:'<?php echo $this->General->GeneralDate(false);?>',
				'float' : 'right',	
				onSelect : function() {
					$(this).focus();
					//foramtEnddate(); //is not defined hence commented
				}
				
			});
	$("#allergy_order_date")
	.datepicker(
			{
				showOn : "button",
				buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly : true,
				changeMonth : true,

				changeYear : true, 

				dateFormat:'<?php echo $this->General->GeneralDate(false);?>',
				'float' : 'right',	
				onSelect : function() {
					$(this).focus();
					//foramtEnddate(); //is not defined hence commented
				}
				
			});
	
	$("#lab_order_date")
	.datepicker(
			{
				showOn : "button",
				buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly : true,
				changeMonth : true,

				changeYear : true, 

				dateFormat:'<?php echo $this->General->GeneralDate(false);?>',
				'float' : 'right',	
				onSelect : function() {
					$(this).focus();
					//foramtEnddate(); //is not defined hence commented
				}
				
			});

	$("#radiology_order_date")
	.datepicker(
			{
				showOn : "button",
				buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly : true,
				changeMonth : true,

				changeYear : true, 

				dateFormat:'<?php echo $this->General->GeneralDate(false);?>',
				'float' : 'right',	
				onSelect : function() {
					$(this).focus();
					//foramtEnddate(); //is not defined hence commented
				}
				
			});

	$("#procedure_perform_date,#procedure_to_date")
	.datepicker(
			{
				showOn : "button",
				buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly : true,
				changeMonth : true,

				changeYear : true, 

				dateFormat:'<?php echo $this->General->GeneralDate(false);?>',
				onSelect : function() {
					$(this).focus();
					//foramtEnddate(); //is not defined hence commented
				}
				
			});	

	$("#risk_category_date")
	.datepicker(
			{
				showOn : "button",
				buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly : true,
				changeMonth : true,

				changeYear : true, 

				dateFormat:'<?php echo $this->General->GeneralDate(false);?>',
				onSelect : function() {
					$(this).focus();
					//foramtEnddate(); //is not defined hence commented
				}
				
			});
	$("#intervention_date")
	.datepicker(
			{
				showOn : "button",
				buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly : true,
				changeMonth : true,

				changeYear : true, 

				dateFormat:'<?php echo $this->General->GeneralDate(false);?>',
				onSelect : function() {
					$(this).focus();
					//foramtEnddate(); //is not defined hence commented
				}
				
			});
	$("#device_date")
	.datepicker(
			{
				showOn : "button",
				buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly : true,
				changeMonth : true,

				changeYear : true, 

				dateFormat:'<?php echo $this->General->GeneralDate(false);?>',
				onSelect : function() {
					$(this).focus();
					//foramtEnddate(); //is not defined hence commented
				}
				
			});
	
	$("#symptom_date")
	.datepicker(
			{
				showOn : "button",
				buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly : true,
				changeMonth : true,

				changeYear : true, 

				dateFormat:'<?php echo $this->General->GeneralDate(false);?>',
				onSelect : function() {
					$(this).focus();
					//foramtEnddate(); //is not defined hence commented
				}
				
			});
	

	$("#diagnostic_date")
	.datepicker(
			{
				showOn : "button",
				buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly : true,
				changeMonth : true,

				changeYear : true, 

				dateFormat : '<?php echo $this->General->GeneralDate(false);?>',
				onSelect : function() {
					$(this).focus();
					//foramtEnddate(); //is not defined hence commented
				}
				
			});

	$("#patient_char_date")
	.datepicker(
			{
				showOn : "button",
				buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly : true,
				changeMonth : true,
				changeYear : true, 
				dateFormat : '<?php echo $this->General->GeneralDate(false);?>',
				onSelect : function() {
					$(this).focus();
					//foramtEnddate(); //is not defined hence commented
				}	
				
			});

	function myfunc2() {
	      document.getElementById('showthis').style.visibility = "visible"
	    }
	function snomed_labrad_test() 
	{ 
		var searchtest = $('#search').val();
	 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "diagnoses", "action" => "snowmed",$data[Patient][id],"admin" => false)); ?>";
	  var formData = $('#diagnosisfrm').serialize();
	 
	   $.ajax({
           type: 'POST',
          url: ajaxUrl+"/"+searchtest,
           data: formData,
           dataType: 'html',
           //--------------
           beforeSend: function() {

           	$("#temp-busy-indicator1").show();
			},
			complete: function() {
				$("#temp-busy-indicator1").hide();
			}, 
           //-------------
           success: function(sucessData){ 
	       
           data = JSON && JSON.parse(sucessData) || $.parseJSON(sucessData);
           	titleData = createTitle(data.testTitle);
				codeIndex = data.testCode;
           	SctCode = data.SctCode;
           	LonicCode = data.LonicCode;
           	CptCode = data.CptCode; 
            $('#SelectLeftProc').html(titleData);
           },
			error: function(message){
			 alert("Internal Error Occured. Unable To Save Data.");
           },       
           });
     
     return false;
		
	}

	function changeTestProc() 
	{ 
		var e = document.getElementById("SelectLeftProc");
        var strUser = e.options[e.selectedIndex].text; 
		testnameIndex = e.selectedIndex;
		document.getElementById("procedure_name").value = strUser;
   }

   function change_diag_type(diagtype)
   {
   if(diagtype=="1")
   {
     $("#lowback").show();
     $("#neckpain").hide();
     $("#upper").hide();
     $("#lower").hide();
     $("#kneepain").hide();
   }
   if(diagtype=="2")
   {
     
     $("#lowback").hide();
     $("#neckpain").show();
     $("#upper").hide();
     $("#lower").hide();
     $("#kneepain").hide();
   }
   if(diagtype=="3")
   {
     
     $("#lowback").hide();
     $("#neckpain").hide();
     $("#upper").show();
     $("#lower").hide();
     $("#kneepain").hide();
   }
   if(diagtype=="4")
   {
    
     $("#lowback").hide();
     $("#neckpain").hide();
     $("#upper").hide();
     $("#lower").show();
     $("#kneepain").hide();
   }
   if(diagtype=="31")
   {
     
     $("#lowback").hide();
     $("#neckpain").hide();
     $("#upper").hide();
     $("#lower").hide();
     $("#kneepain").show();
   }

  
    
   }

//------------------------
	function callDragon(notetype){
		

		$
		.fancybox({
			'width' : '50%',
			'height' : '50%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'href' : "<?php echo $this->Html->url(array("controller" => "patients", "action" => "dragon")); ?>"+'/'+ notetype
		});
		 
	}

	/*$('#soap_submit')
	.click(
			function() { 
				var validatePatientNotes = jQuery("#patientnotesfrm").validationEngine('validate');
				if (validatePatientNotes) {$(this).css('display', 'none');}
			});*/


$(document).ready(function(){
    $('#BPDysto').attr('readonly',true);
    $('#BPSysto').keyup(function(){
        if($(this).val().length !=0){
            $('#BPDysto').attr('readonly', false);
        }
        else
        $('#BPDysto').attr('readonly',true);
    })
	 $(".rad").click(function() {
	   	var rates = $(this).val();
	   	if($(this).attr('id')=="ConstIdOTHER")
	   	{
	   		 $("#"+$(this).attr('id')+'_txt').show();
	   	}
	   	else
	   	{
	   	   	
	   		$('#ConstIdOTHER_txt').hide('fast');
	   	}
    $(".rad1").click(function() {
    	var rates = $(this).val();
    	if($(this).attr('id')=="NoteEyeRosOTHER")
       	{
       		 $("#"+$(this).attr('id')+'_txt').show();
       	}
       	else
       	{
       		$('#NoteEyeRosOTHER_txt').hide('fast');
       	}
       	});
    $(".rad2").click(function() {
    	var rates = $(this).val();
    	if($(this).attr('id')=="NoteEnmtRosOTHER")
       	{
       		 $("#"+$(this).attr('id')+'_txt').show();
       	}
       	else
       	{
       		$('#NoteEnmtRosOTHER_txt').hide('fast');
       	}
       	});
    $(".rad3").click(function() {
    	var rates = $(this).val();
    	if($(this).attr('id')=="NoteRepiratoryRosOTHER")
       	{
       		 $("#"+$(this).attr('id')+'_txt').show();
       	}
       	else
       	{
       		$('#NoteRepiratoryRosOTHER_txt').hide('fast');
       	}
       	});
    $(".rad4").click(function() {
    	var rates = $(this).val();
    	if($(this).attr('id')=="NoteCardivascularRosOTHER")
       	{
       		 $("#"+$(this).attr('id')+'_txt').show();
       	}
       	else
       	{
       		$('#NoteCardivascularRosOTHER_txt').hide('fast');
       	}
       	});
    $(".rad5").click(function() {
    	var rates = $(this).val();
    	
    	if($(this).attr('id')=="NoteGastrointestinalRosOTHER")
       	{
       		 $("#"+$(this).attr('id')+'_txt').show();
       	}
       	else
       	{
       		$('#NoteGastrointestinalRosOTHER_txt').hide('fast');
       	}
       	});
    $(".rad6").click(function() {
    	var rates = $(this).val();
    	if($(this).attr('id')=="NoteGenitourinaryRosOTHER")
       	{
       		 $("#"+$(this).attr('id')+'_txt').show();
       	}
       	else
       	{
       		$('#NoteGenitourinaryRosOTHER_txt').hide('fast');
       	}
       	});
    $(".rad7").click(function() {
    	var rates = $(this).val();
    	
    	if($(this).attr('id')=="NoteHemaLymphRosOTHER")
       	{
       		 $("#"+$(this).attr('id')+'_txt').show();
       	}
       	else
       	{
       		$('#NoteHemaLymphRosOTHER_txt').hide('fast');
       	}
       	});
    $(".rad8").click(function() {
    	var rates = $(this).val();
    	if($(this).attr('id')=="NoteEndocrineRosOTHER")
       	{
       		 $("#"+$(this).attr('id')+'_txt').show();
       	}
       	else
       	{
       		$('#NoteEndocrineRosOTHER_txt').hide('fast');
       	}});
    $(".rad9").click(function() {
    	var rates = $(this).val();
    	if($(this).attr('id')=="NoteImmunologicRosOTHER")
       	{
       		 $("#"+$(this).attr('id')+'_txt').show();
       	}
       	else
       	{
       		$('#NoteImmunologicRosOTHER_txt').hide('fast');
       	}});
    $(".rad10").click(function() {
    	var rates = $(this).val();
    	if($(this).attr('id')=="NoteMusculoskeletalRosOTHER")
       	{
       		 $("#"+$(this).attr('id')+'_txt').show();
       	}
       	else
       	{
       		$('#NoteMusculoskeletalRosOTHER_txt').hide('fast');
       	}});
    $(".rad11").click(function() {
    	var rates = $(this).val();
    	if($(this).attr('id')=="NoteIntegumentaryRosOTHER")
       	{
       		 $("#"+$(this).attr('id')+'_txt').show();
       	}
       	else
       	{
       		$('#NoteIntegumentaryRosOTHER_txt').hide('fast');
       	}});
    $(".rad12").click(function() {
    	var rates = $(this).val();
    	if($(this).attr('id')=="NoteNeurologicRosOTHER")
       	{
       		 $("#"+$(this).attr('id')+'_txt').show();
       	}
       	else
       	{
       		$('#NoteNeurologicRosOTHER_txt').hide('fast');
       	}});
    $(".rad13").click(function() {
    	var rates = $(this).val();
    	if($(this).attr('id')=="NotePsychiatricRosOTHER")
       	{
       		 $("#"+$(this).attr('id')+'_txt').show();
       	}
       	else
       	{
       		$('#NotePsychiatricRosOTHER_txt').hide('fast');
       	}});
       	$(".rad14").click(function() {
        	var rates = $(this).val();
        	if($(this).attr('id')=="NoteAllOtherRosOTHER")
           	{
           		 $("#"+$(this).attr('id')+'_txt').show();
           	}
           	else
           	{
           		$('#NoteAllOtherRosOTHER_txt').hide('fast');
           	}});
   	
   
   	
   
});
});
			
			$("#label_otr").click(function(){
		        $("#showthis").show();
		    });
			$("#psychiatric_label").click(function(){
		        $("#psychiatric").show();
		    });
			
			$("#neurologic_lbl").click(function(){
		        $("#neurologic_txt").show();
		    });
			$("#integumentary_lbl").click(function(){
		        $("#integumentary_txt").show();
		    });

			$("#musculoskeletal_lbl").click(function(){
		        $("#musculoskeletal_txt").show();
		    });
		    $("#immunologic_lbl").click(function(){
		        $("#immunologic_txt").show();
		    });
		    $("#endocrine_lbl").click(function(){
		        $("#endocrine_txt").show();
		    });
		    $("#hema_lymph_lbl").click(function(){
		        $("#hema_lymph_txt").show();
		    });
		    $("#genitourinary_lbl").click(function(){
		        $("#genitourinary_txt").show();
		    });
		    $("#gastrointestinal_lbl").click(function(){
		        $("#gastrointestinal_txt").show();
		    });
		    $("#cardivascular_lbl").click(function(){
		        $("#cardivascular_txt").show();
		    });
		    $("#repiratory_lbl").click(function(){
		        $("#repiratory_txt").show();
		    });
		    $("#enmt_lbl").click(function(){
		        $("#enmt_txt").show();
		    });
		    $("#enmt_lbl").click(function(){
		        $("#enmt_txt").show();
		    });
		    $("#eye_lbl").click(function(){
		        $("#eye_txt").show();
		    })
		     $("#eye_lbl").click(function(){
		        $("#eye_txt").show();
		    })
		    $("#eye_lbl").click(function(){
		        $("#eye_txt").show();
		    })
		  
		  
</script>

<script>

				
var cds_age = "<?php echo $CDS_Data_Drug['age_e'];?>";		
var age = "<?php echo $age;?>";
var dmc = "<?php echo $CDS_Data_Drug['dmc'];?>"; 
 	
 

 
				
	jQuery(document).ready(function() {
						$('#dischargebyconsultant')
								.click(
										function() {
											$
													.fancybox({
														'width' : '80%',
														'height' : '90%',
														'autoScale' : true,
														'transitionIn' : 'fade',
														'transitionOut' : 'fade',
														'type' : 'iframe',
														'href' : "<?php echo $this->Html->url(array("controller" => "patients", "action" => "child_birth", $patient['Patient']['id'])); ?>"
													});

										});
						$("#prescriptionLink").click(function() {

							window.location.href = "#list_content";

						});

					});
	jQuery(document).click(function() {
		$("a").click(function() {
			$("form").validationEngine('hide');
		});

	});

	//----------GAURAV---- and aditya--------

	   

	function load() { 

		/*document.getElementById("aframe").style.height="780px";
		document.getElementById("aframe").style.width="980px";
		document.getElementById("rxframeid").style.display="block";*/
		document.getElementById("aframe").style.height = "780px";
		document.getElementById("aframe").style.width = "980px";
		jQuery(".loader").hide();

	}


		jQuery("#Rx").click(function() {
		
			jQuery(".loader").show();
			document.getElementById("aframe").style.height = "0px";
			document.getElementById("aframe").style.width = "0px";
			document.getElementById("rxframeid").style.display = "block";
			
			//$("#aframe").contents().scrollTop( $("#aframe").contents().scrollTop() + 300 );
		});
		

		 
		
		
//-------checkbox js code--------
function save_checkinfo(){

	if($('#uncheck').attr('checked')) 
		{
   	     var checkrx=1; 
   	
      }
  else
  {
	  var checkrx=0; 
       }

patientid="<?php echo $patient['Patient']['id']?>";
patient_uid="<?php echo $patient['Patient']['patient_id']?>";

var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "save_checkinforx",$patientid,$checkrx,$patient_uid,"admin" => false)); ?>";



    $.ajax({
     type: 'POST',
     url: ajaxUrl+"/"+patientid+"/"+checkrx+"/"+patient_uid,
     //data: formData,
     dataType: 'html',
     success: function(data){
    	 //alert(hello);
     },
		error: function(message){
         alert(message);
         
     }        });

}
$('#procedure_name1').click(function(){
var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "diagnoses", "action" => "snowmed2","admin" => false)); ?>";
    $.ajax({
     type: 'POST',
     url: ajaxUrl,
     data: {search:'cho'},
     dataType: 'html',
     success: function(data){
    	 //alert(hello);
     },
		error: function(message){
         alert(message);
         
     }        });
});
function display_significant_history()
{
	
	if($('#pmh').attr('checked')) 
	{
	     var isview=1; 
	     var patientid="<?php echo $patient['Patient']['id']?>";
	     var patient_gender="<?php echo $patient['Person']['sex']?>";

	     var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "getSignificantHistory","admin" => false)); ?>";



	         $.ajax({
	          type: 'POST',
	          url: ajaxUrl+"/"+patientid+"/"+patient_gender+"/"+isview,
	          //data: formData,
	          dataType: 'html',
	          success: function(data){
	         	 $('#subjective_desc').val(data.replace(/<br\s*[\/]?>/gi, "\n"));
	          },
	     		error: function(message){
	              alert(message);
	              
	          }        });
	
  }
else
{
  var isview=0; 
  $('#subjective_desc').val('');
   }



}
	function display_chief()
	{
		
		if($('#chiefChk').attr('checked')) 
		{
		     var patientid="<?php echo $patient['Patient']['id']?>";
		     var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "getChiefComplaints","admin" => false)); ?>";
		         $.ajax({
		        	 beforeSend:function(){
						    // this is where we append a loading image
						    $('#busy-indicator').show('fast');
							}, 
		          type: 'POST',
		          url: ajaxUrl+"/"+patientid,
		          //data: formData,
		          dataType: 'html',
		          success: function(data){
		        	  $('#busy-indicator').hide('fast');
			          data = $.trim(data);
		         	 $('#cc_desc').val(data);
		          },
		     		error: function(message){
		              alert(message);
		              
		          }
		   });
	  }else{
		  var isview=0; 
		  $('#cc_desc').val('');
	  }
	}

function save_checkallergy(){

	if($('#allergycheck').attr('checked')) 
		{
   	     var checkall=1; 
   	
      }
  else
  {
	  var checkall=0; 
       }

patientid="<?php echo $patient['Patient']['id']?>";
patient_uid="<?php echo $patient['Patient']['patient_id']?>";

var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "save_checkinfoallergy",$patientid,$checkall,$patient_uid,"admin" => false)); ?>";



    $.ajax({
     type: 'POST',
     url: ajaxUrl+"/"+patientid+"/"+checkall+"/"+patient_uid,
     //data: formData,
     dataType: 'html',
     success: function(data){
    	 //alert(hello);
     },
		error: function(message){
         alert(message);
     }        });


}

var ajaxcreateCredentialsUrl ="<?php echo $this->Html->url(array("controller" => "messages", "action" => "createCredentials","admin" => false)); ?>"; ;//

function createPatientCredentials(patientid){

	$
	.fancybox({
		'width' : '50%',
		'height' : '50%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'href' : "<?php echo $this->Html->url(array("controller" => "messages", "action" => "openFancyBox", $patient['Patient']['person_id'],$patient['Patient']['id'])); ?>"
	});
	 
}

function pres_hgb(patientid){

	$
	.fancybox({
		'width' : '70%',
		'height' : '90%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'onComplete' : function() {
			$("#allergies").css({
				top : '20px',
				bottom : auto,
				position : absolute
			});
		},
		'href' : "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "hgb_chart")); ?>"
		+ '/' + patientid+'/'+"<?php echo $patient['Patient']['patient_id']?>"
		


	});
		 
	}

function pres_cbc(patientid){

	$
	.fancybox({
		'width' : '70%',
		'height' : '90%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'onComplete' : function() {
			$("#allergies").css({
				top : '20px',
				bottom : auto,
				position : absolute
			});
		},
		'href' : "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "cbc_chart")); ?>"
		+ '/' + patientid+'/'+"<?php echo $patient['Patient']['patient_id']?>"
		


	});
		 
	}

function pres_glucose(patientid){

	$
	.fancybox({
		'width' : '70%',
		'height' : '90%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'onComplete' : function() {
			$("#allergies").css({
				top : '20px',
				bottom : auto,
				position : absolute
			});
		},
		'href' : "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "glucose_chart")); ?>"
		+ '/' + patientid+'/'+"<?php echo $patient['Patient']['patient_id']?>"
		


	});
		 
	}

function chart_lft(patientid){

	$
	.fancybox({
		'width' : '70%',
		'height' : '90%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'onComplete' : function() {
			$("#allergies").css({
				top : '20px',
				bottom : auto,
				position : absolute
			});
		},
		'href' : "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "lft_chart")); ?>"
		+ '/' + patientid+'/'+"<?php echo $patient['Patient']['patient_id']?>"
		


	});
		 
	}

jQuery("#nursing_hub").click(function() {
	 if ( $('#nursingElement').css('display') == 'none'){
		 $('#nursingElement').fadeIn('slow');
		 }else{
			 $('#nursingElement').hide();
		 }

	 return false ;
});
$('#soap_submit,#soap_submit1')
.click(
		function() { 
		//var assessementDesc = $("#assessment_desc").val();
		var medication=$("#drug0").val();
		var chiefComplaints = $("#cc_desc").val();
		chiefComplaints = jQuery.trim( chiefComplaints );
		var assesstmentIcd = $("#icdSlc").html();
		assesstmentIcd = jQuery.trim( assesstmentIcd );
		var message = '';
		if(chiefComplaints.length == 0){
			message = message + "Chief complaints ";
		}
		if(assesstmentIcd.length == 0){
			if(message != '')
				message = message + "and assements ";
			else message = message + "Assements ";
		}
		var checkMedicalData='<?php empty($selectedMed)?>'+medication;
		var checkAllergylData='<?php empty($selectedAllergy)?>';
		if(checkMedicalData==''){
			if(message != '')
				message = message + "and medications ";
			else message = message + "Medication ";
		}
	//	else if(checkAllergylData==''){
		//	if(message != '')
			//	message = message + "and allergy ";
		//	else message = message + "Allergy ";
	//	}
		if((assesstmentIcd.length == 0) || (chiefComplaints.length == 0) || (checkMedicalData=='') /* || (checkAllergylData=='')*/ ){
			if(confirm(message + "are not entered! Are you sure you want to submit?")){
				return true;
			}else{
				return false;
			}
		}
		
		
		});
$(document).ready(function(){
	//calls on ready to load initial assessment vital
	$('#assesmentVital').attr('checked',true);
	$('#chiefChk').attr('checked',true);
	setVitals();
	$("#searchproblem").autocomplete("<?php echo $this->Html->url(array("controller" => "laboratories", "action" => "testcomplete","SnomedMappingMaster","referencedComponentId","sctName",'null','null','null',"admin" => false,"plugin"=>false)); ?>", {
		width: 250,
		selectFirst: true,
		valueSelected:true,
		showNoId:true,
		loadId : 'SNOMED_DESCRIPTION,SCT_US_CONCEPT_ID,searchproblem'
	});

	$("#visit_type_txt").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "configAutoComplete","patient_visit_type","admin" => false,"plugin"=>false)); ?>", {
		width: 250,
		selectFirst: true,
		valueSelected:true,
		showNoId:true,
		loadId : 'visit_type_txt,visit_type'
	});
	
	
});	

$(".dClick").dblclick(function (event) {
    //event.preventDefault();
	 var CurrentId=$(this).attr('id');
	 $('#'+CurrentId).css({'background-color':'red'});
	 CurrentIdSplit=CurrentId.split('_');
	 var hiddenId=CurrentIdSplit[0]+"_"+CurrentIdSplit[1];
	 $('#'+hiddenId).val('2');

});
$(".dClick").click(function (event) {
    //event.preventDefault();
	 var CurrentId=$(this).attr('id');
	 CurrentIdSplit=CurrentId.split('_');
	 var hiddenId=CurrentIdSplit[0]+"_"+CurrentIdSplit[1];

	 if( $('#'+hiddenId).val().length == 0 ) {
			$('#'+CurrentId).css({'background-color':'green'});
	 		$('#'+hiddenId).val('1');
	}else{
			$('#'+CurrentId).css({'background-color':''});
		 	$('#'+hiddenId).val('');
	}

});
$(".dClick_Ros").dblclick(function (event) {
	 var CurrentId=$(this).attr('id');
	 $('#'+CurrentId).css({'background-color':'red'});
	 CurrentIdSplit=CurrentId.split('_');
	 var hiddenId=CurrentIdSplit[0]+"_"+CurrentIdSplit[1]+"_";
	 $('#'+hiddenId).val('2');

});
$(".dClick_Ros").click(function (event) {
   var CurrentId=$(this).attr('id');
   CurrentIdSplit=CurrentId.split('_');
   var hiddenId=CurrentIdSplit[0]+"_"+CurrentIdSplit[1]+"_";

   if( $('#'+hiddenId).val().length == 0 ) {
		$('#'+CurrentId).css({'background-color':'green'});
 		$('#'+hiddenId).val('1');
	}else{
		$('#'+CurrentId).css({'background-color':''});
	 	$('#'+hiddenId).val('');
	}

});
$('.sendNote').click(function(){
	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "updateNote","admin" => false)); ?>";
$.ajax({
	 beforeSend : function() {
        		// this is where we append a loading image
        		$('#busy-indicator').show('fast');
        		},
    type: 'POST',
    url: ajaxUrl+"/"+$('#nId').val(),
    dataType: 'html',
	//data: formData,
    success: function(data){
    	$('#busy-indicator').hide('fast');
        var url='<?php  echo $this->Html->url(array('controller'=>'Appointments','action'=>'appointments_management'));?>';   	 
   	   	// window.location.href=url;
   	 	$('#lock').hide();
   	 	$('#viewSign').hide();
   	 	$('#lowerSubmit').show();
   		$('#showAll').show();
   	 
    },
		error: function(message){
        alert(message);
        
    }        });

});
$('#soap_submit1').click(function(){
	$('#noteSign').val('1');
	if(confirm("This will permanently finalize this encounter as a legal document.You will not be able to make edits after signing")){
		return true;
	}else{
		return false;
	}	
});
$('#soap_submit').click(function(){
	$('#noteSign').val('0');	
});

$('#assesmentVital').click(function(){setVitals();});
function setVitals(){
	var vitals = <?php echo $assessmentVitals; ?>;
	if(!$('#assesmentVital').is(':checked')){
		if(vitals['date']){
			$('#vital_date').val('');
		}
		//------------------------------------
		if(vitals['location']){
			$('#Location').val('');
		}
		if(vitals['pain']){
			$('#Pain').val('');
		}
		if(vitals['duration']){
			$('#Duration').val('');
		}
		if(vitals['frequency']){
			$('#Frequency').val('');
		}
		if(vitals['spo']){
			$('#spo2').val('');
		}
		if(vitals['sposelect']){
			$('#spo21').val('');
		}
		//=======================================
		if(vitals['temperature'])
			$('#TEMP').val('');
		if(vitals['pulse_rate'])
			$('#PR').val('');
		if(vitals['respiration'])
			$('#RR').val('');
		if(vitals['bpSystolic'] && vitals['bpDystolic']){
			$('#BPSysto').val('');
			$('#BPDysto').val('');
		}
		if(vitals['chiefComplaints'])
			$('#cc_desc').val('');
	}else{
	var returnVar = false;
	if(vitals['date']){
		var dateVital1=vitals['date'].split(' ');
		var dateVital=dateVital1['0'].split('-');
		$('#vital_date').val(dateVital[1]+"/"+"/"+dateVital[2]+"/"+dateVital[0]);
		returnVar = true;
	}
	if(vitals['temperature']){
		$('#TEMP').val(vitals['temperature']);
		returnVar = true;
	}
	
	if(vitals['pulse_rate']){
		$('#PR').val(vitals['pulse_rate']);
		returnVar = true;
	}
	if(vitals['respiration']){
		$('#RR').val(vitals['respiration']);
		returnVar = true;
	}
	//------------------------------------
	if(vitals['location']){
		$('#Location').val(vitals['location']);
		returnVar = true;
	}
	if(vitals['pain']){
		$('#Pain').val(vitals['pain']);
		returnVar = true;
	}
	if(vitals['duration']){
		$('#Duration').val(vitals['duration']);
		returnVar = true;
	}
	if(vitals['frequency']){
		$('#Frequency').val(vitals['frequency']);
		returnVar = true;
	}
	if(vitals['spo']){
		$('#spo2').val(vitals['spo']);
		returnVar = true;
	}
	if(vitals['spo2']){
		$('#spo21 option:selected').text(vitals['spo2']);
		returnVar = true;
	}
	//=======================================
	if(vitals['bpSystolic'] && vitals['bpDystolic']){
		$('#BPSysto').val(vitals['bpSystolic']);
		$('#BPDysto').val(vitals['bpDystolic']);
		returnVar = true;
	}
	
		$('#cc_desc').val('<?php echo $CcFromDiagnosis ?>');
	if(!returnVar){
		//alert('Vitals are not taken from Initial Assessment');
		return false;
	}
	}
}
	

function proceduresearch(source) {
    var identify =""; 
	identify = source;
	$.fancybox({
				'width' : '100%',
				'height' : '100%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "proceduresearch")); ?>" + "/" + identify,
			});
   }
</script>

