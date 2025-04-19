 <?php  
 echo $this->Html->script(array('jquery-1.5.1.min','validationEngine.jquery','ui.datetimepicker.3.js',
		'jquery.validationEngine','/js/languages/jquery.validationEngine-en',
		'jquery.isotope.min.js?ver=1.5.03','jquery.custom.js?ver=1.0','jquery-ui-1.10.2.js','jquery.fancybox-1.3.4','jquery.autocomplete'));?>
<?php echo $this->Html->css(array('jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','internal_style.css',
		'home-slider.css','ibox.css','jquery.fancybox-1.3.4.css','jquery.autocomplete.css'));?>
<?php echo $this->Html->script(array('jquery.signaturepad.min'));
echo $this->Html->css(array('jquery.signaturepad'));?>
<!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css"> -->
<!--  <script src="//code.jquery.com/jquery-1.9.1.js"></script>
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script> -->
<!-- <link rel="stylesheet" href="/resources/demos/style.css"> -->
<style>

body {
	margin-top: 0px;
	font-family: inherit;
	line-height: 1.6
}

.container {
	width: 1200px;
	margin: 0 auto;
}

.ui-widget-content {
	background: none;
	border: 0px solid #AAAAAA;
}

label {
	width: 126px;
	padding: 0px;
}
.pad_bg{ background:#f5f5f5 repeat-x; border:1px solid #000;}
</style>
<style>
.checkbox {
	float: left;
	width: 100%
}

.checkbox label {
	float: none;
}

.dat img {
	float: inherit;
}
.sigPad {
    margin: 0;
    padding: 0;
    width: 315px !important;
}
#tabs-1 .formFull .tdLabel {
    float: left;
    width: 255px !important;
}
#tabs-2 .formFull .tdLabel {
    float: left;
    width: 255px !important;
}
#tabs-3 .formFull .tdLabel {
    float: left;
    width: 255px !important;
}
a {
    color: #FFFFFF !important;
    font-size: 13px;
    text-decoration: none;
}
</style>
<script>
  $(function() {
    $( "#tabs" ).tabs();
  });
</script>
<script>
$(document).ready(function(){
var tabNumber = "<?php echo $checkTab?>";
var tabArray = new Array();
tabArray = [0,1,2];
  $(function() {
   if(tabNumber == ''){
	   tabNumber = 0;
   } 
    $( "#tabs" ).tabs({ active: tabNumber });   
   
   
    //tabArray.splice( $.inArray(tabNumber, tabArray), 2 );
   // tabArray.remove(tabNumber);
 //  $( "#tabs" ).tabs({ disabled: tabArray});
  });
  /*$('.tab-link').click(function (){
	  var patientId=$('#patient_id').val();
	  var activetab=$("#tabs").tabs('option', 'active'); 	
	if(activetab=='0'){
	  var getId="<?php echo $priorityArrayP;?>"; 
	//}else if(activetab=='1'){
	//  var getId="<?php echo $priorityArrayS;?>"; 
	}else if(activetab=='2'){		
		var getId="<?php echo $priorityArrayT;?>"; 
	}else{
		//alert("no Id");
	}	 

	//  parent.location.reload(true);
	 
//	 var url = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "editInsurance", "admin" => false)); ?>"+"/"+getId+"/"+patientId;
	window.location.href=url;	 
  });*/
});
   </script>
<div id="flashMessage"></div>
<div class="inner_title">
	<h3>
		<?php echo __('Manage Patient Insurance'); ?>
	</h3>
	<span align="right"> <?php echo $this->Html->link(__('Back', true),array('controller' => 'patients', 'action' => 'insuranceindex',$patient_id), array('escape' => false,'class'=>'blueBtn'));?>
	</span>
</div>

<div id='verifymsg'	style="display: none; font-weight: bold; text-align: center; background-color: #394145; color: #78D83E; height: 21px; padding-top: 10px;">
	<strong></strong>
</div>
<?php echo $this->element('patient_information');?>
<div id="tabs" class="container" style="padding-top: 10px;">
	<ul class="tabs">
		<li class="tab-link" data-tab="tab-1"><a href="#tabs-1"><?php echo __('Primary Insurance ');?>
		</a></li>
		<li class="tab-link" data-tab="tab-2" id="secondary"><a href="#tabs-2"><?php echo __('Secondary Insurance ');?>
		</a></li>
		<li class="tab-link" data-tab="tab-3" id="tritiary"><a href="#tabs-3"><?php echo __('Tertiary Insurance ');?>
		</a></li>
	</ul>
	<?php echo $this->Form->create('NewInsurance',array('url'=>array('controller'=>'patients','action'=>'editInsurance',$patient_id),'id'=>'editinsurance','enctype' => 'multipart/form-data'));?>
	<?php echo $this->Form->input('id',array('type'=>'hidden'));?>
	<?php echo $this->Form->input('uploadedImageName',array('type'=>'hidden','value'=>$getDataForEdit['0']['NewInsurance']['upload_card']));
		echo $this->Form->hidden('web_cam',array('id'=>'web_cam'));	?>
	<?php echo $this->Form->hidden('NewInsurance.location_id', array('label'=>false,'value'=>$this->Session->read('locationid'),'id' => 'location_id')); ?>
	<?php
	if(!empty($getDataForEdit['0']['NewInsurance']['patient_uid'])){
		$getPatinetUid0=$getDataForEdit['0']['NewInsurance']['patient_uid'];
	}else{
		$getPatinetUid0=$getDataForEditSec['0']['NewInsurance']['patient_uid'];
	}
	echo $this->Form->hidden('NewInsurance.patient_uid', array('label'=>false,'value'=>$patientUid,'id' => 'patient_uid')); ?>
	<?php 
	if(!empty($getDataForEdit['0']['NewInsurance']['patient_uid'])){
		$getPatinetid0=$getDataForEdit['0']['NewInsurance']['patient_id'];
	}else{
		$getPatinetid0=$getDataForEditSec['0']['NewInsurance']['patient_id'];
	}echo $this->Form->hidden('NewInsurance.patient_id', array('label'=>false,'value'=>$patient_id,'id' => 'patient_id')); ?>
	<?php if(!empty($getDataForEdit['0']['NewInsurance']['id'])){
		$getPrimaryId=$getDataForEdit['0']['NewInsurance']['id'];
	}
	echo $this->Form->hidden('NewInsurance.id', array('label'=>false,'value'=>$getPrimaryId,'id' => 'id')); ?>

	<div id="tabs-1" style="padding-top: 5px;" class="tab-content current">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
			<tr>
				<td width="19%" class="tdLabel">Payor Name<font color="red">*</font>
				<!--  <td width="20%"><?php //echo $this->Form->input('NewInsurance.tariff_standard_id', array('label'=>false,'empty'=>__('Select'),'options'=>$getDataInsuranceType,'id' =>'insurance_type_id','autocomplete'=> 'off','class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','selected'=>$getDataForEdit['0']['NewInsurance']['tariff_standard_id'])); ?>
				</td>-->
				<td width="28%"><?php echo $this->Form->input('NewInsurance.tariff_standard_name', array('label'=>false,'id' => 'tariff_standard_name','autocomplete'=> 'off','class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd','value'=>$getDataForEdit['0']['NewInsurance']['tariff_standard_name'])); ?>
				<?php echo $this->Form->hidden('NewInsurance.tariff_standard_id',array('id'=>'insurance_type_id'));
				echo $this->Form->hidden('NewInsurance.insurance_name',array('id'=>'insurance_name','value'=>$getDataForEdit['0']['NewInsurance']['insurance_name']));
				echo $this->Form->hidden('NewInsurance.payer_id',array('id'=>'payer_id','value'=>$getDataForEdit['0']['NewInsurance']['payer_id']));
				echo $this->Form->hidden('NewInsurance.insurance_number',array('id'=>'insurance_number','value'=>$getDataForEdit['0']['NewInsurance']['insurance_number']));
				?>	<?php //echo  $this->Form->hidden('NewInsurance.tariff_standard_name',array('id'=>'tariff_standard_name1','value'=>$getDataForEdit[0]['NewInsurance']['tariff_standard_name']));?>
				<?php echo $this->Form->hidden('check',array('value'=>'First_check'));?>
				</td>
				<td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Policy #/Insured ID');?><font
									color="red">*</font>
				</td>			
				<td width="16%"><?php echo $this->Form->input('NewInsurance.policy_no', array('label'=>false,'id' => 'policy_no','class'=> 'validate[required,custom[mandatory-enter]] textBoxExpnd','div'=>false,'value'=>$getDataForEdit['0']['NewInsurance']['policy_no'])); ?>
				<?php echo  $this->Form->hidden('policycheck',array('id'=>'policycheck','value'=>$getDataForEdit[0]['NewInsurance']['policy_type']));?>
				<input type="radio" id="Mi" name="NewInsurance[policy_type]" value="MI" style="display:none"><?php ///echo __('Member ID');?><br>
					<input type="radio" id="Zz" name="NewInsurance[policy_type]" value="ZZ" checked='checked' style="display:none"><?php ///echo __('Unique Health ID');?></td>
			</tr>

						<tr>
				<td class="tdLabel" id="boxSpace">Responsibility<font color="red">*</font>
				</td>
				<td><?php if($getDataForEdit[0]['NewInsurance']['priority']=='P' || $getDataForEdit[0]['NewInsurance']['priority']=='Primary' || $getDataForEdit[0]['NewInsurance']['priority']==''){
					echo __('Primary');
					$getRespo0='P';
					
				}elseif ($getDataForEdit[0]['NewInsurance']['priority']=='S' || $getDataForEdit[0]['NewInsurance']['priority']=='Secondary'){
					echo __('Secondary');
					$getRespo0='S';
				}else{
					echo __('Tertiary');
					$getRespo0='T';
				}?>
					
					<?php  echo $this->Form->input('NewInsurance.priority',array('type'=>'hidden','value'=>'P')) ?>
				</td>

				<td width="19%" class="tdLabel" id="boxSpace">Effective from</td>
				<?php $getDataForEdit['0']['NewInsurance']['effective_date']= $this->DateFormat->formatDate2Local($getDataForEdit['0']['NewInsurance']['effective_date'],Configure::read('date_format_us'),false);?>
				<td width="26%"><?php echo $this->Form->input('NewInsurance.effective_date', array('label'=>false,'type'=>'text','class' => 'textBoxExpnd','id' => 'efdate','readonly'=>'readonly','value'=>$getDataForEdit['0']['NewInsurance']['effective_date'])); ?>
				</td>
			</tr>
			<!-- <tr>
				<td width="21%" class="tdLabel" id="boxSpace"><?php echo __('Insurance Name');?>
				</td>
				<td width="28%"><?php echo $this->Form->input('NewInsurance.insurance_name', array('label'=>false,'id' => 'insurance_name','autocomplete'=> 'off','class' => 'validate["",custom[mandatory-select]] textBoxExpnd'
						,'value'=>$getDataForEdit['0']['NewInsurance']['insurance_name'])); ?>
				</td>
				<td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Insurance ID');?>
				</td>
				<td width="26%"><?php echo $this->Form->input('NewInsurance.insurance_number', array('label'=>false,'id' => 'insurance_number','class'=> 'textBoxExpnd','div'=>false,'value'=>$getDataForEdit['0']['NewInsurance']['insurance_number'])); ?>
				</td>
			</tr> -->
			<tr>
				<td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Group Name')?>
				</td>
			<td width="20%"><?php echo $this->Form->input('NewInsurance.group_name', array('label'=>false,'id' => 'group_name','class'=> 'textBoxExpnd','div'=>false,'value'=>$getDataForEdit['0']['NewInsurance']['group_name'])); ?>
				</td>

				<td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Group ID')?>
				</td>
				<td width="26%"><?php echo $this->Form->input('NewInsurance.group_number', array( 'id' =>'group_number', 'class'=> 'textBoxExpnd','label'=>false, 'div' => false, 'error' => false,'value'=>$getDataForEdit['0']['NewInsurance']['group_number'])); ?>
				</td>
			</tr>
			<tr>
				<td width="19%" id="boxSpace" class="tdLabel">Co pay type<font
					color="red">*</font>
				</td>
				<td width="20%"><?php echo $this->Form->input('NewInsurance.copay_type', array('label'=>false,'empty'=>__("Select"),'options'=>array('Fixed','Percentage'),'selected'=>$getDataForEdit['0']['NewInsurance']['copay_type'],'id' => 'copay_type','class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','onchange'=>'javascript:getPercentage()')); ?>
				</td>

				<td width="19%" class="tdLabel" id="boxSpace">Relation to insured</td>
				<td width="26%"><?php //Configure::read('relationship_with_insured')
				echo $this->Form->input('NewInsurance.relation', array( 'id' =>'relation','empty'=>'Select', 'options'=>array('self'=>'Self','spouse'=>'Spouse','child'=>'Child','other'=>'Other','D'=>'Unspecified Dependent'),'value'=>$getDataForEdit['0']['NewInsurance']['relation'] ,'class'=> 'textBoxExpnd','label'=>false, 'div' => false, 'error' => false)); ?>
				</td>
			</tr>
			<tr>
				<?php  if(!empty($getDataForEdit['0']['NewInsurance']['fixed_percentage'])){
					$dataFixPercentage=$getDataForEdit['0']['NewInsurance']['fixed_percentage'];
					$status='false';
				}
				else{
						$dataFixPercentage="Enter Percentage(ex:30%)";					
						}
						if(!empty($getDataForEdit['0']['NewInsurance']['fixed_amt'])){
							$dataFix=$getDataForEdit['0']['NewInsurance']['fixed_amt'];
						}
						else{
							$dataFix="Enter Amount(ex:$300)";
						
						}
						?>
				<td valign="middle" class="tdLabel" id="boxSpace"></td>
				<td><?php echo $this->Form->input('NewInsurance.fixed_percentage', array('type'=>'text','label'=>false,'class' => 'validate[required,custom[name],custom[onlyNumberSp]] textBoxExpnd fixed_percent','value'=>$dataFixPercentage,'id' => 'fixed_percentage','onclick'=>'javascript:removetext()','placeholder'=>$dataFixPercentage));
				echo $this->Form->input('NewInsurance.fixed_amt', array('type'=>'text','label'=>false,'class' => 'validate[required,custom[name],custom[onlyNumberSp]] textBoxExpnd','value'=>$dataFix,'id' => 'fixed_amt','onclick'=>'javascript:removetext()','placeholder'=>$dataFix)); ?>
				</td>
			</tr>
			<!-- <tr>
				<td width="19%" class="tdLabel" id="boxSpace"><?php //echo __('Active');?></td>
				<td width="26%"> --><?php echo $this->Form->checkbox('NewInsurance.is_active', array('label'=>false,'id' => 'is_active','checked'=>'checked','style'=>'display:none;')); ?>
				<!-- </td>
				<td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Is Person');?>
				</td> -->
				<?php echo $this->Form->hidden('isperson',array('id'=>'isperson','value'=>$getDataForEdit['0']['NewInsurance']['is_person']));?>
				<!-- <td width="16%">--><input type="radio" id="yes" name="NewInsurance[is_person]" value="Yes" style="display:none"><?php //echo __('Yes');?>
					<input type="radio"  id="no" name="NewInsurance[is_person]" value="No" style="display:none"><?php //echo __('No');?><!-- </td>
			</tr> -->
			<tr>
				<td width="19%" class="tdLabel" id="boxSpace">Upload Insurance Card</td>

				<td width="20%">
				<?php echo $this->Form->input('NewInsurance.upload_card', array('type'=>'file','id' => 'patient_photo1', 'class'=>"textBoxExpnd",'label'=> false,'div' => false, 'error' => false));?>
				<?php //if(!empty($getDataForEdit['NewInsurance']['id'])){?><?php echo $this->Html->image('/img/icons/webcam.png',array('id'=>'camera','title'=>'Capture photo from webcam'));?>
					<canvas width="320" height="240" id="parent_canvas"
						style="display: none;"></canvas>
				<?php //debug($this->request->data);
//debug($getDataForEdit['0']['NewInsurance']);exit;
										$imageName =  $getDataForEdit['0']['NewInsurance']['upload_card']; ?>
					<span id="viewImage" style="cursor: pointer;" title="View Image"
					onclick="getImage('<?php echo $imageName ?>');return false;">View
						Card</span></td>
				<td width="19%" class="tdLabel" id="boxSpace">Back of Card</td>
				<td width="19%"><?php 
					echo $this->Form->input('NewInsurance.back_of_card', array('type'=>'file','id' => 'back_of_card', 'class'=>"textBoxExpnd",'label'=> false,'div' => false, 'error' => false)); ?>
									<?php echo $this->Html->image('/img/icons/webcam.png',array('id'=>'camera_card','title'=>'Capture photo from webcam'));?>
									<canvas width="320" height="240" id="parent_canvas_card" style="display: none;"></canvas>
										<?php //debug($this->request->data);
//debug($getDataForEdit['0']['NewInsurance']);exit;
										$imageName =  $getDataForEdit['0']['NewInsurance']['back_of_card']; ?>
					<span id="viewImage" style="cursor: pointer;" title="View Image"
					onclick="getImage('<?php echo $imageName ?>');return false;">View
						Card</span>
				</td>

			</tr>

			<!-- <tr>
				<td class="tdLabel" style="text-align: left;" id="boxSpace">Claim Officer<font color="red">*</font>
				</td>
				<td><?php echo $this->Form->input('NewInsurance.claim_officer', array('type'=>'text','class'=>'textBoxExpnd validate[required,custom[mandatory-enter]]','label'=>false,'value'=>$getDataForEdit['0']['NewInsurance']['claim_officer'])); ?>
				</td>
				<td style="text-align: left;" class="tdLabel" id="boxSpace">Patient Student Status</td>
				<td><?php echo $this->Form->input('NewInsurance.patient_stuent_status', array('type'=>'text', 'class'=>'textBoxExpnd', 'label'=>false,'value'=>$getDataForEdit['0']['NewInsurance']['patient_stuent_status'])); ?>
				</td>
			</tr> -->
			<tr>
				<td id="boxSpace" class="tdLabel" colspan="4">
								<?php if(!empty($getDataForEdit['0']['NewInsurance']['verify'])){
									$checked='checked';
								}
								echo $this->Form->checkbox('NewInsurance.verify', array('label'=>false,'id' => 'is_active','checked'=>$checked)); ?>
										<?php echo __("Verified");?>
										<?php if(!empty($getDataForEdit['0']['NewInsurance']['is_assign'])){
									$checked='checked';
								}echo $this->Form->checkbox('NewInsurance.is_assign', array('label'=>false,'id' => 'is_assign','checked'=>$checked)); ?>
										<?php echo __("Accept Assign");?>
										<?php if(!empty($getDataForEdit['0']['NewInsurance']['is_assign'])){
									$checked='checked';
								}echo $this->Form->checkbox('NewInsurance.is_eob', array('label'=>false,'id' => 'is_eob','checked'=>$checked)); ?>
										<?php echo __("EOB");?>
				</td>
				</tr>
			    <tr>
				<td id="boxSpace" class="tdLabel" colspan="4" style="float:none;"><?php $checked = ($getDataForEdit['0']['NewInsurance']['pri_is_authorized'] == 'Y') ? true : false;
				echo $this->Form->checkbox('NewInsurance.pri_is_authorized', array('label'=>false,'id' => 'pri_is_authorized','checked'=>$checked,'value'=>'Y')); ?>
				<?php echo __("AUTHORIZATION TO PAY BENEFITS TO PHYSICIAN: I hereby authorize payment of surgical/medical/benefits directly to Hope Hospital Inpatient.");?>
				</td>
				</tr>                           
    	
		</table>
		<table width="100%" border="0" cellspacing="0" cellpadding="0"
			class="formFull">
			<tr>
				<th style="padding-left: 10px;" colspan="4"><?php echo __('Employer Information');?>
				</th>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Employer Name</td>
				<td width="43%"><?php echo $this->Form->input('NewInsurance.employer', array('label'=>false,'div'=>false,'id' => 'employer','value'=>$getDataForEdit['0']['NewInsurance']['employer'],'class'=> 'textBoxExpnd')); ?>
				</td>
				<td width="21%" class="tdLabel">Country</td>
				<td width="40%"><?php 
			//	echo $this->Form->input('NewInsurance.emp_country', array('options' => $countries, 'empty' => 'Select Country', 'id' => 'emp_country','value'=>$getDataForEdit['0']['NewInsurance']['emp_country'] ,'label'=> false, 'div' => false, 'error' => false,'onchange'=> $this->Js->request(array('controller'=>'persons','action' => 'get_state_city','reference'=>'State','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#emp_state', 'data' => '{reference_id:$("#emp_country").val()}', 'dataExpression' => true, 'div'=>false)),'class' => 'validate[,custom[mandatory-select]] textBoxExpnd'));
				if($getDataForEdit['0']['NewInsurance']['emp_country']){
					$getempSelectedCountry0=$getDataForEdit['0']['NewInsurance']['emp_country'];
				}else{
					$getempSelectedCountry0='2';
				}
				echo $this->Form->input('NewInsurance.emp_country', array('options' => $countries,'empty' =>'Please Select Country', 'id' => 'emp_country', 'label'=> false, 'div' => false, 'error' => false,'class' => 'textBoxExpnd','selected'=>$getempSelectedCountry0));
				?></td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Address</td>
				<td width="30%"><?php echo $this->Form->input('NewInsurance.emp_address', array('label'=>false,'id' => 'emp_address','class'=>'textBoxExpnd','value'=>$getDataForEdit['0']['NewInsurance']['emp_address'] )); ?>
				</td>
				<td width="21%" class="tdLabel">State</td>
				<td width="30%" ><?php //$states = ''; id="emp_state"
				if($getDataForEdit['0']['NewInsurance']['subscriber_state']){
					$getempSelectedState0=$getDataForEdit['0']['NewInsurance']['subscriber_state'];
				}else{
					$getempSelectedState0='84';
				}
				echo $this->Form->input('NewInsurance.emp_state', array('options' => $state,'empty' =>'Please Select State', 'id' => 'emp_state', 'label'=> false, 'div' => false, 'error' => false,'class' => 'textBoxExpnd','selected'=>$getempSelectedState0));?>
				</td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Note</td>
				<td width="30%"><?php echo $this->Form->input('NewInsurance.note', array('value'=>$getDataForEdit['0']['NewInsurance']['note'] ,'label'=>false,'id' => 'note','class'=> 'textBoxExpnd')); ?>
				</td>
				<td width="21%" class="tdLabel">City</td>
				<td width="30%" valign="top"><?php echo $this->Form->input('NewInsurance.emp_city', array('value'=>$getDataForEdit['0']['NewInsurance']['emp_city'] ,'label'=>false,'id' => 'emp_city1','class'=>'textBoxExpnd')); ?>
				</td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Zip Code</td>
				<td width=""><?php echo $this->Form->input('NewInsurance.emp_zip_code', array('type'=>'text','value'=>$getDataForEdit['0']['NewInsurance']['emp_zip_code'] ,'label'=>false,'id' => 'zip_codeote','class'=>'textBoxExpnd','Maxlength'=>5)); ?>
				</td>
			</tr>
			<!-- <tr>
				<td width="21%" class="tdLabel">SSN</td>
				<td width=""><?php echo $this->Form->input('NewInsurance.emp_ssn', array('value'=>$getDataForEdit['0']['NewInsurance']['emp_ssn'] ,'label'=>false,'id' => 'emp_ssn','class'=>'textBoxExpnd','Maxlength'=>5)); ?>
				</td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Phone</td>
				<td width=""><?php echo $this->Form->input('NewInsurance.emp_phone', array('value'=>$getDataForEdit['0']['NewInsurance']['emp_phone'] ,'label'=>false,'id' => 'emp_ssn','class'=>'textBoxExpnd','Maxlength'=>5)); ?>
				</td>
			</tr> -->
		</table>
		<table width="100%" border="0" cellspacing="0" cellpadding="0"
			class="formFull">
			<tr>
				<th style="padding-left: 10px;" colspan="4"><?php echo __('');?> <?php echo $this->Form->input('chkclick', array('type'=>'checkbox','id' => 'ckeckGua','label'=>'Check to copy Guaranter details')); ?>
				</th>
			</tr>

			<tr>
				<td width="24%" class="tdLabel">Subscriber name</td>
				<td width="28%"><?php echo $this->Form->input('NewInsurance.subscriber_name', array('value'=>$getDataForEdit['0']['NewInsurance']['subscriber_name'] ,'id'=>'subscriber_name','label'=>false,'class'=> '','style'=>'width:143px','div'=>false)); ?>
					<?php  echo $this->Form->input('NewInsurance.subscriber_initial', array('id'=>'gau_middle_name','label'=>false,'style'=>'width:72px','div'=>false,'value'=>$getDataForEdit['0']['NewInsurance']['subscriber_initial'])); ?>
				</td>
				<td width="21%" class="tdLabel">Subscriber Last name</td>
				<td width="20%"><?php echo $this->Form->input('NewInsurance.subscriber_last_name', array('value'=>$getDataForEdit['0']['NewInsurance']['subscriber_last_name'] ,'id'=>'gau_last_name','label'=>false,'class'=>'textBoxExpnd')); ?>
				</td>
			</tr>
			
			<tr>
				<td width="21%" class="tdLabel">Date of Birth</td>
				<td width="250"><?php $getDataForEdit['0']['NewInsurance']['subscriber_dob']= $this->DateFormat->formatDate2Local($getDataForEdit['0']['NewInsurance']['subscriber_dob'],Configure::read('date_format_us'),false);
				echo $this->Form->input('NewInsurance.subscriber_dob',array('value'=>$getDataForEdit['0']['NewInsurance']['subscriber_dob'] ,'id'=>'dobg','class'=>'textBoxExpnd','type'=>'text','autocomplete'=>"off",'legend'=>false,'div'=>false,'label'=>false,'readonly'=>'readonly'));?>
				</td>
				<td width="21%" class="tdLabel">Gender</td>
				<td width="27%"><?php echo $this->Form->input('NewInsurance.subscriber_gender', array('selected'=>$getDataForEdit['0']['NewInsurance']['subscriber_gender'],'id'=>'gau_sex','empty'=>__("Select"),'options' => array('Male'=>__('Male'),'Female'=>__('Female'),'Ambiguous'=>__('Ambiguous'),'Not applicable'=>__('Not applicable'),'Unknown'=>__('Unknown'),'Other'=>__('Other')), 'default' => '','label'=>false,'div'=>false,'class'=>'textBoxExpnd'));?>
				</td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Social Security Number
				</td>
				<td width="27%"><?php echo $this->Form->input('NewInsurance.subscriber_security', array('value'=>$getDataForEdit['0']['NewInsurance']['subscriber_security'],'id'=>'gau_ssn','maxLength'=>'9','label'=>false,'class'=>'textBoxExpnd')); ?>
				</td>
				<td width="21%" class="tdLabel">Address1</td>
				<td width="20%"><?php echo $this->Form->input('NewInsurance.subscriber_address1', array('value'=>$getDataForEdit['0']['NewInsurance']['subscriber_address1'],'id'=>'gau_plot_no','label'=>false,'class'=>'textBoxExpnd')); ?>
				</td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Address2</td>
				<td width="20%"><?php echo $this->Form->input('NewInsurance.subscriber_address2', array('value'=>$getDataForEdit['0']['NewInsurance']['subscriber_address2'],'id'=>'gau_landmark','label'=>false,'class'=>'textBoxExpnd')); ?>
				</td>
				<td width="21%" class="tdLabel">City</td>
				<td width="20%"><?php echo $this->Form->input('NewInsurance.subscriber_city', array('id'=>'city','label'=>false, 'class'=> 'textBoxExpnd','div'=>false,'value'=>$getDataForEdit['0']['NewInsurance']['subscriber_city'])); ?>
				</td>				
			</tr>
			<tr>
				<td width="21%" class="tdLabel">State</td>
				<td width="20%" ><?php ///$state ='';id="customstate1"
									if($getDataForEdit['0']['NewInsurance']['subscriber_state']){
										$getSelectedState1=$getDataForEdit['0']['NewInsurance']['subscriber_state'];
									}else{
										$getSelectedState1='84';
										}
								echo $this->Form->input('NewInsurance.subscriber_state', array('id'=>'customstate1','options' => $state, 'empty' => 'Please Select State', 'label'=> false, 'div' => false, 'error' => false,'class'=> 'textBoxExpnd','selected'=>$getSelectedState1)); ?>
				</td>
				<td width="21%" class="tdLabel">Country</td>
				<td width="200px"><?php //echo $this->Form->input('NewInsurance.subscriber_country', array('options' => $countries, 'empty' => 'Select Country', 'id' => 'customcountry1', 'label'=> false, 'div' => false, 'error' => false, 'class'=>'textBoxExpnd','onchange'=> $this->Js->request(array('controller'=>'persons','action' => 'get_state_city','reference'=>'State','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#customstate1', 'data' => '{reference_id:$("#customcountry1").val()}', 'dataExpression' => true, 'div'=>false)))); 
				if($getDataForEdit['0']['NewInsurance']['subscriber_country']){
						$getsubSelectedCountry0=$getDataForEdit['0']['NewInsurance']['subscriber_country'];
				}else{
						$getsubSelectedCountry0='2';
				}
				echo $this->Form->input('NewInsurance.subscriber_country', array('options' =>$countries,'empty' =>'Please Select Country', 'id' => 'customcountry1', 'label'=> false, 'div' => false, 'error' => false, 'class'=>'textBoxExpnd','selected'=>$getsubSelectedCountry0)); ?>
				</td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Zip Code</td>
				<td width="20%"><?php echo $this->Form->input('NewInsurance.subscriber_zip', array('value'=>$getDataForEdit['0']['NewInsurance']['subscriber_zip'],'id'=>'subscriber_zip','label'=>false, 'class'=> 'textBoxExpnd','Maxlength'=>5)); ?>
				</td>
				<td width="21%" class="tdLabel">Primary Phone</td>
				<td width="20%"><?php echo $this->Form->input('NewInsurance.subscriber_primary_phone', array('value'=>$getDataForEdit['0']['NewInsurance']['subscriber_primary_phone'],'type'=>'text','id'=>'gau_home_phone','label'=>false, 'class'=> 'textBoxExpnd','div'=>false,'maxLength'=>'14')); ?>
				</td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Secondary Phone</td>
				<td width="20%"><?php echo $this->Form->input('NewInsurance.subscriber_secondary_phone', array('value'=>$getDataForEdit['0']['NewInsurance']['subscriber_secondary_phone'],'type'=>'text','id'=>'gau_mobile','label'=>false,'class'=> 'textBoxExpnd','div'=>false,'maxLength'=>'14')); ?>
				</td>
			</tr>
			 <tr>
                                <!--<td width="50%" id="boxSpace">
                                  <table>-->
                                     <td width="19%" id="boxSpace" class="tdLabel" ><?php echo __('Signature'); ?></td>

                                      <td width="20%"><?php //echo $this->Form->input('NewInsurance.sign', array('type' =>'text', 'id' => 'signature','style'=>'visibility:hidden','label'=>false,'legend'=>false)); ?>

								<!-- <div class="sigPad">
									<ul class="sigNav">
										<li class="drawIt"><a href="#draw-it"><font color="#000000">Sign</font> </a>
										</li>
										<li class="clearButton"><a href="#clear"><font color="#000000">Clear</font>
										</a>
										</li>
									</ul>
									<div>
										<div class="typed"></div>
										<canvas class="pad pad_bg" width="290" height="150"></canvas>
										<?php echo $this->Form->input('NewInsurance.sign', array('type' =>'hidden', 'id' => 'output', 'class' => 'output ','label'=>false,'legend'=>false)); ?>
									</div>
								</div> -->
								
									<table width="100%" border="0" cellspacing="0" cellpadding="0"
										class="formFull formFullBorder">
										<tr>
											<td>
												<div>
													<?php 
													if($getDataForEdit['0']['NewInsurance']['sign'] != "") {
                            	       echo $this->Html->image('/signpad/'.$getDataForEdit['0']['NewInsurance']['sign'], array('alt' => 'Signature', 'title' => 'Signature', 'width' => '308', 'height' => '150','style'=>"border: 1px solid #000000"));
                            		 } else {
                            	?>
													<?php echo $this->Form->input('NewInsurance.sign', array('type' =>'text', 'id' => 'signature','style'=>'visibility:hidden','label'=>false)); ?>
													<div class="sigPad">
														<ul class="sigNav">
															<li class="drawIt"><a href="#draw-it"><font color="#000">Draw
																		It</font> </a></li>
															<li class="clearButton"><a href="#clear"><font
																	color="#000">Clear</font> </a></li>
														</ul>
														<div>
															<div class="typed"></div>
															<canvas class="pad pad_bg" width="290" height="150"></canvas>
															<?php echo $this->Form->input('NewInsurance.sign_output', array('type' =>'hidden', 'id' => 'output', 'class' => 'output')); ?>
														</div>
													</div>
													<?php } ?>
												</div>
											</td>
										</tr>
									</table>
							</td>
                            
                           <!--  <td class="tdLabel" id="boxSpace" style="text-align:left;">Reffering Doctor</td>
                             
                            <td valign="top">         
                <?php echo $this->Form->input('NewInsurance.refer_doctor', array('type'=>'text', 'class'=>'textBoxExpnd', 'label'=>false,'value'=>$getDataForEdit['0']['NewInsurance']['refer_doctor'])); ?>
							   </td>   -->                              
                                </tr>
		</table>
		<div align="right" style="padding-top:10px;">
		<?php	echo $this->Form->hidden('NewInsurance.refference_id',array());
			echo $this->Form->submit(__('Submit Primary'), array('escape' => false,'class'=>'blueBtn','id'=>'submit'));
			?>
			
		</div>
		<?php echo $this->Form->end();?>
	</div>
	<?php  
	echo $this->Form->create('NewInsurance',array('url'=>array('controller'=>'patients','action'=>'editInsurance',$patient_id),'id'=>'editinsurance1','enctype' => 'multipart/form-data'));?>
	<?php echo $this->Form->input('id',array('type'=>'hidden'));?>
	<?php echo $this->Form->input('uploadedImageName',array('type'=>'hidden','value'=>$this->request->data['NewInsurance']['upload_card']));
	echo $this->Form->hidden('web_cam',array('id'=>'web_cam'));	?>
	<?php echo $this->Form->hidden('NewInsurance.location_id', array('label'=>false,'value'=>$this->Session->read('locationid'),'id' => 'location_id')); ?>
	<?php if(empty($getDataForEdit[1]['NewInsurance']['patient_uid'])){
		$getUid1=$getDataForEdit[0]['NewInsurance']['patient_uid'];		
	}else if(!empty($getDataForEditSec[0]['NewInsurance']['patient_uid'])){
		$getUid1=$getDataForEditSec[0]['NewInsurance']['patient_uid'];
	}else{
		$getUid1=$getDataForEdit['1']['NewInsurance']['patient_uid'];
	}
	echo $this->Form->hidden('NewInsurance.patient_uid', array('label'=>false,'value'=>$patientUid,'id' => 'patient_uid')); ?>
	<?php if(empty($getDataForEdit[1]['NewInsurance']['patient_id'])){
		$getPatientid1=$getDataForEdit[0]['NewInsurance']['patient_id'];		
	}else if(!empty($getDataForEditSec[0]['NewInsurance']['patient_uid'])){
	$getPatientid1=$getDataForEditSec[0]['NewInsurance']['patient_id'];
	}else{
		$getPatientid1=$getDataForEdit['1']['NewInsurance']['patient_id'];
	}
	echo $this->Form->hidden('NewInsurance.patient_id', array('label'=>false,'value'=>$patient_id,'id' => 'patient_id')); ?>
	<?php /*if(empty($getDataForEdit[1]['NewInsurance']['id'])){
		//$getid1=$getDataForEdit[0]['NewInsurance']['id'];		
	}else */ if(!empty($getDataForEditSec[0]['NewInsurance']['id'])){
		$getid1=$getDataForEditSec[0]['NewInsurance']['id'];
	}else{
		$getid1=$getDataForEdit['1']['NewInsurance']['id'];
	}
	
	echo $this->Form->hidden('NewInsurance.id', array('label'=>false,'value'=>$getid1,'id' => 'id1')); ?>
	<div id="tabs-2" class="tab-content" style="padding-top: 5px;">
				<table width="100%" border="0" cellspacing="0" cellpadding="0"
			class="formFull">
			<tr><?php echo $this->Form->hidden('check',array('value'=>'Second_check'));?>
				<td width="21%" class="tdLabel">Payor Name<font color="red">*</font>
				<!-- <td width="20%"><?php 
				echo $this->Form->input('NewInsurance.tariff_standard_id', array('label'=>false,'empty'=>__('Select'),'options'=>$getDataInsuranceType,'id' =>'insurance_type_id2','autocomplete'=> 'off','class' => 'validate[required,custom[mandatory-select]] textBoxExpnd',
				'selected'=>$getDataForEdit[1]['NewInsurance']['tariff_standard_id'])); ?>
				</td> -->
				<?php //echo  $this->Form->hidden('NewInsurance.tariff_standard_name',array('id'=>'tariff_standard_name2','value'=>$getDataForEdit[1]['NewInsurance']['tariff_standard_name']));?>

				<td width="28%"><?php if(!empty($getDataForEdit['1']['NewInsurance']['tariff_standard_name'])){
					$gettariffName2=$getDataForEdit['1']['NewInsurance']['tariff_standard_name'];
				}else{
					$gettariffName2=$getDataForEditSec[0]['NewInsurance']['tariff_standard_name'];
				}
				echo $this->Form->input('NewInsurance.tariff_standard_name', array('label'=>false,'id' => 'tariff_standard_name2','autocomplete'=> 'off','class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd','value'=>$getDataForEdit['1']['NewInsurance']['tariff_standard_name'])); ?>
				<?php 
				echo $this->Form->hidden('NewInsurance.tariff_standard_id',array('id'=>'insurance_type_id2'));
				if(!empty($getDataForEdit['1']['NewInsurance']['insurance_name'])){
					$getinsurance_name2=$getDataForEdit['1']['NewInsurance']['insurance_name'];
				}else{
					$getinsurance_name2=$getDataForEditSec[0]['NewInsurance']['insurance_name'];
				}
				echo $this->Form->hidden('NewInsurance.insurance_name',array('id'=>'insurance_name2','value'=>$getDataForEdit['1']['NewInsurance']['insurance_name']));
				if(!empty($getDataForEdit['1']['NewInsurance']['payer_id'])){
					$getpayer_id2=$getDataForEdit['1']['NewInsurance']['payer_id'];
				}else{
					$getpayer_id2=$getDataForEditSec[0]['NewInsurance']['payer_id'];
				}
				echo $this->Form->hidden('NewInsurance.payer_id',array('id'=>'payer_id2','value'=>$getpayer_id2));
				if(!empty($getDataForEdit['1']['NewInsurance']['insurance_number'])){
					$getinsurance_number2=$getDataForEdit['1']['NewInsurance']['insurance_number'];
				}else{
					$getinsurance_number2=$getDataForEditSec[0]['NewInsurance']['insurance_number'];
				}
				echo $this->Form->hidden('NewInsurance.insurance_number',array('id'=>'insurance_number2','value'=>$getinsurance_number2));?>

				</td>
				<td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Policy #/Insured ID');?><font
									color="red">*</font>
				</td>			

				<td width="16%"><?php if(!empty($getDataForEdit['1']['NewInsurance']['policy_no'])){
					$getpolicy_no2=$getDataForEdit['1']['NewInsurance']['policy_no'];
				}else{
					$getpolicy_no2=$getDataForEditSec[0]['NewInsurance']['policy_no'];
				}
				echo $this->Form->input('NewInsurance.policy_no', array('label'=>false,'id' => 'policy_no2','class'=> 'validate[required,custom[mandatory-enter]] textBoxExpnd','div'=>false,'value'=>$getpolicy_no2)); ?>

				
				<?php if(!empty($getDataForEdit['1']['NewInsurance']['policycheck'])){
					$getpolicycheck2=$getDataForEdit['1']['NewInsurance']['policycheck'];
				}else{
					$getpolicycheck2=$getDataForEditSec[0]['NewInsurance']['policycheck'];
				}echo  $this->Form->hidden('policycheck',array('id'=>'policycheck2','value'=>$getpolicycheck2));?>
				<td width=""><input type="radio" id="Mi2" name="NewInsurance[policy_type]" value="MI"  style="display: none"><?php //echo __('Member ID');?>
					<input type="radio" id="Zz2" name="NewInsurance[policy_type]" value="ZZ" checked='checked' style="display: none"><?php //echo __('Unique Health ID');?></td>
				</tr>

				<tr>
				<td class="tdLabel" id="boxSpace">Responsibility<font color="red">*</font>
				</td>
				<td><?php if($getDataForEdit[1]['NewInsurance']['priority']=='P' || $getDataForEdit[1]['NewInsurance']['priority']==''){
					echo __('Primary');
					$getRespo1='P';
				}else if ($getDataForEdit[1]['NewInsurance']['priority']=='S' || $getDataForEdit[1]['NewInsurance']['priority']=='' || $getDataForEditSec[0]['NewInsurance']['priority']=='S' || $getDataForEditSec[0]['NewInsurance']['priority']==''){
					echo __('Secondary');
					$getRespo1='S';
				}else{
					echo __('Tertiary');
					$getRespo1='T';
					} ?>
					<?php echo $this->Form->input('NewInsurance.priority',array('type'=>'hidden','value'=>'S')) ?>
				</td>

				<td width="" class="tdLabel" id="boxSpace">Effective from</td>

				<?php if(!empty($getDataForEdit['1']['NewInsurance']['effective_date'])){
				$getDataForEdit['1']['NewInsurance']['effective_date']= $this->DateFormat->formatDate2Local($getDataForEdit['1']['NewInsurance']['effective_date'],Configure::read('date_format_us'),false);
				$getEffective2=$getDataForEdit['1']['NewInsurance']['effective_date'];
				}else{
				$getDataForEditSec[0]['NewInsurance']['effective_date']= $this->DateFormat->formatDate2Local($getDataForEditSec[0]['NewInsurance']['effective_date'],Configure::read('date_format_us'),false);
				$getEffective2=$getDataForEditSec[0]['NewInsurance']['effective_date'];
				}?>
				<td width="26%"><?php echo $this->Form->input('NewInsurance.effective_date', array('label'=>false,'type'=>'text','class' => 'textBoxExpnd','id' => 'efdate2','readonly'=>'readonly','value'=>$getEffective2)); ?>

				</td>
			</tr>
			<!-- <tr>
				<td width="21%" class="tdLabel" id="boxSpace"><?php echo __('Insurance Name');?>
				</td>
				<td width="28%"><?php echo $this->Form->input('NewInsurance.insurance_name', array('label'=>false,'id' => 'insurance_name2','autocomplete'=> 'off','class' => 'validate["",custom[mandatory-select]] textBoxExpnd'
						,'value'=>$getDataForEdit['1']['NewInsurance']['insurance_name'])); ?>
				</td>
				<td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Insurance ID');?>
				</td>
				<td width="26%"><?php echo $this->Form->input('NewInsurance.insurance_number', array('label'=>false,'id' => 'insurance_number2','class'=> 'textBoxExpnd','div'=>false,'value'=>$getDataForEdit['1']['NewInsurance']['insurance_number'])); ?>
				</td>
			</tr> -->
			<tr>
				<td width="" class="tdLabel" id="boxSpace"><?php echo __('Group Name')?>
				</td>

				<td width="20%"><?php  if(!empty($getDataForEdit['1']['NewInsurance']['group_name'])){
					$getgroup_name2=$getDataForEdit['1']['NewInsurance']['group_name'];
				}else{
					$getgroup_name2=$getDataForEditSec[0]['NewInsurance']['group_name'];
				}
				echo $this->Form->input('NewInsurance.group_name', array('label'=>false,'id' => 'group_name','class'=> 'textBoxExpnd','div'=>false,'value'=>$getgroup_name2)); ?>

				<!-- <td width=""><?php echo $this->Form->input('NewInsurance.group_name', array('label'=>false,'id' => 'group_name','class'=> 'textBoxExpnd','div'=>false,'value'=>$getDataForEdit['1']['NewInsurance']['group_name'])); ?> -->

				</td>

				<td width="" class="tdLabel" id="boxSpace"><?php echo __('Group ID')?>
				</td>
				<td width=""><?php echo $this->Form->input('NewInsurance.group_number', array( 'id' =>'group_number', 'class'=> 'textBoxExpnd','label'=>false, 'div' => false, 'error' => false,'value'=>$getDataForEdit['1']['NewInsurance']['group_number'])); ?>
				</td>
			</tr>
			<tr>
				<td width="" id="boxSpace" class="tdLabel">Co pay type<font
					color="red">*</font>
				</td>

				<td width="20%" valign="top"><?php 
				if(!empty($getDataForEdit['1']['NewInsurance']['copay_type'])){
					$getcopay_type2=$getDataForEdit['1']['NewInsurance']['copay_type'];
				}else{
					$getcopay_type2=$getDataForEditSec[0]['NewInsurance']['copay_type'];
				}
				
				 echo $this->Form->input('NewInsurance.copay_type', array('label'=>false,'empty'=>__("Please Select"),'selected'=>$getDataForEdit['1']['NewInsurance']['copay_type'],'options'=>array('Fixed','Percentage'),'id' => 'copay_type1','class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','onchange'=>'javascript:getPercentageSec()')); ?>

				</td>


				<td width="19%" class="tdLabel" id="boxSpace">Relation to insured</td>
				<td width="26%"><?php if(!empty($getDataForEdit['1']['NewInsurance']['relation'])){
					$getrelation2=$getDataForEdit['1']['NewInsurance']['relation'];
				}else{
					$getrelation2=$getDataForEditSec[0]['NewInsurance']['relation'];
				}
				echo $this->Form->input('NewInsurance.relation', array( 'id' =>'relation','empty'=>'Please Select', 'options'=>array('self'=>'Self','spouse'=>'Spouse','child'=>'Child','other'=>'Other','D'=>'Unspecified Dependent'),'value'=>$getrelation2, 'class'=> 'textBoxExpnd','label'=>false, 'div' => false, 'error' => false)); ?>

				</td>
			</tr>
			<tr>
				<?php if(!empty($getDataForEdit['1']['NewInsurance']['fixed_percentage'])){
					$dataFixPercentage=$getDataForEdit['1']['NewInsurance']['fixed_percentage'];
					$status='false';
				}else  if(!empty($getDataForEditSec[0]['NewInsurance']['fixed_percentage'])){
					$dataFixPercentage=$getDataForEditSec[0]['NewInsurance']['fixed_percentage'];
					$status='false';
				}
				else{
						$dataFixPercentage="Enter Percentage(ex:30%)";							
				}
				if(!empty($getDataForEdit['1']['NewInsurance']['fixed_amt'])){
							$dataFix=$getDataForEdit['1']['NewInsurance']['fixed_amt'];
				}else  if(!empty($getDataForEditSec[0]['NewInsurance']['fixed_amt'])){
					$dataFix=$getDataForEditSec[0]['NewInsurance']['fixed_amt'];
					$status='false';
				}
				else{
							$dataFix="Enter Amount(ex:$300)";
				}
						?>
				<td valign="middle" class="tdLabel" id="boxSpace"></td>
				<td><?php echo $this->Form->input('NewInsurance.fixed_percentage', array('type'=>'text','label'=>false,'class' => 'validate[required,custom[name],custom[onlyNumberSp]] textBoxExpnd fixed_percent','value'=>$dataFixPercentage,'id' => 'fixed_percentage_sec','onclick'=>'javascript:removetextSec()'));
				echo $this->Form->input('NewInsurance.fixed_amt', array('type'=>'text','label'=>false,'class' => 'validate[required,custom[name],custom[onlyNumberSp]] textBoxExpnd','value'=>$dataFix,'id' => 'fixed_amt_sec','onclick'=>'javascript:removetextSec()')); ?>
				</td>
			</tr>
			<tr>

				<td width="19%" class="tdLabel" id="boxSpace"><?php //echo __('Active');?></td>
				<td width="26%"><?php //echo $this->Form->checkbox('NewInsurance.is_active', array('label'=>false,'id' => 'is_active','checked'=>'checked','style'=>'display:none;')); ?>

				</td>
				<td width="" class="tdLabel" id="boxSpace"><?php //echo __('Is Person');?>
				</td>
				<?php if(!empty($getDataForEdit['1']['NewInsurance']['isperson'])){
					$getisperson2=$getDataForEdit['1']['NewInsurance']['isperson'];
				}else{
					$getisperson2=$getDataForEditSec[0]['NewInsurance']['isperson'];
				}
				echo $this->Form->hidden('isperson',array('id'=>'isperson2','value'=>$getisperson2));?>
				<td width=""><input type="radio" id="yes2" name="NewInsurance[is_person]" value="Yes" style="display:none"><?php //echo __('Yes');?>
					<input type="radio"  id="no2" name="NewInsurance[is_person]" value="No" style="display:none"><?php //echo __('No');?></td>
			</tr>
			<tr>
				<td width="" class="tdLabel" id="boxSpace">Upload Insurance Card</td>
				<td width=""><?php 
				echo $this->Form->input('NewInsurance.upload_card', array('type'=>'file','id' => 'patient_photo2', 'class'=>"textBoxExpnd",'label'=> false,'div' => false, 'error' => false));?>
				<?php if(!empty($getDataForEdit['1']['NewInsurance']['upload_card'])){			
					$imageNameu2 =  $getDataForEdit['1']['NewInsurance']['upload_card']; 
					}else{
					$imageNameu2 =  $getDataForEditSec['0']['NewInsurance']['upload_card'];
					}	?>
					<span id="viewImage" style="cursor: pointer;" title="View Image" onclick="getImage('<?php echo $imageNameu2 ?>');return false;">View
						Card</span><?php echo $this->Html->image('/img/icons/webcam.png',array('id'=>'camera','title'=>'Capture photo from webcam'));?>
					<canvas width="320" height="240" id="parent_canvas"
						style="display: none;"></canvas></td>
				<td width="" class="tdLabel" id="boxSpace">Back of Card</td>
				<td width=""><?php 
					echo $this->Form->input('NewInsurance.back_of_card', array('type'=>'file','id' => 'back_of_card', 'class'=>"textBoxExpnd",'label'=> false,'div' => false, 'error' => false)); ?>
									<?php echo $this->Html->image('/img/icons/webcam.png',array('id'=>'camera_card','title'=>'Capture photo from webcam'));?>
									<canvas width="320" height="240" id="parent_canvas_card" style="display: none;"></canvas>
										<?php if(!empty($getDataForEdit['1']['NewInsurance']['back_of_card'])){			
					$imageNameb2 =  $getDataForEdit['1']['NewInsurance']['back_of_card']; 
					}else{
					$imageNameb2 =  $getDataForEditSec['0']['NewInsurance']['back_of_card'];
					}	
										 ?>
					<span id="viewImage" style="cursor: pointer;" title="View Image"
					onclick="getImage('<?php echo $imageNameb2 ?>');return false;">View
						Card</span>
				</td>
						

			</tr>
			<!-- <tr>
				<td class="tdLabel" style="text-align: left;" id="boxSpace">Claim Officer<font color="red">*</font>
				</td>
				<td><?php echo $this->Form->input('NewInsurance.claim_officer', array('type'=>'text','class'=>'textBoxExpnd validate[required,custom[mandatory-enter]]','label'=>false,'value'=>$getDataForEdit['1']['NewInsurance']['claim_officer'])); ?>
				</td>
				<td style="text-align: left;" class="tdLabel" id="boxSpace">Patient Student Status</td>
				<td><?php echo $this->Form->input('NewInsurance.patient_stuent_status', array('type'=>'text', 'class'=>'textBoxExpnd', 'label'=>false,'value'=>$getDataForEdit['1']['NewInsurance']['patient_stuent_status'])); ?>
				</td>
			</tr> -->
			<tr>
				<td id="boxSpace" class="tdLabel" colspan="4">
									<?php if(!empty($getDataForEdit['1']['NewInsurance']['verify']) ||  !empty($getDataForEditSec['0']['NewInsurance']['verify'])){
									$checkedve2='checked';
								}
								echo $this->Form->checkbox('NewInsurance.verify', array('label'=>false,'id' => 'is_active2','checked'=>$checkedve2)); ?>
										<?php echo __("Verified");?>
										<?php if(!empty($getDataForEdit['1']['NewInsurance']['is_assign']) ||  !empty($getDataForEditSec['0']['NewInsurance']['is_assign'])){
									$checkedass2='checked';
								}echo $this->Form->checkbox('NewInsurance.is_assign', array('label'=>false,'id' => 'is_assign2','checked'=>$checkedass2)); ?>
										<?php echo __("Accept Assign");?>
										<?php if(!empty($getDataForEdit['1']['NewInsurance']['is_eob']) ||  !empty($getDataForEditSec['0']['NewInsurance']['is_eob'])){
									$checkedeob2='checked';
								}echo $this->Form->checkbox('NewInsurance.is_eob', array('label'=>false,'id' => 'is_eob2','checked'=>$checkedeob2)); ?>
										<?php echo __("EOB");?>
				</td>
				</tr>
                <tr>
				<td id="boxSpace" class="tdLabel" colspan="4" style="float:none;"><?php $checkedauth2 = ($getDataForEdit['1']['NewInsurance']['sec_is_authorized'] == 'Y' || $getDataForEditSec['0']['NewInsurance']['sec_is_authorized'] == 'Y') ? true : false;
				echo $this->Form->checkbox('NewInsurance.sec_is_authorized', array('label'=>false,'id' => 'sec_is_authorized','checked'=>$checkedauth2,'value'=>'Y')); ?>
				<?php echo __("AUTHORIZATION TO PAY BENEFITS TO PHYSICIAN: I hereby authorize payment of surgical/medical/benefits directly to Hope Hospital Inpatient.");?>
				</td>
				</tr>           
  
		</table>
		<table width="100%" border="0" cellspacing="0" cellpadding="0"
			class="formFull">
			<tr>
				<th style="padding-left: 10px;" colspan="4"><?php echo __('Employer Information');?>
				</th>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Employer Name</td>
				<td width="43%"><?php echo $this->Form->input('NewInsurance.employer', array('label'=>false,'div'=>false,'id' => 'employer','value'=>$getDataForEdit['1']['NewInsurance']['employer'],'class'=> 'textBoxExpnd')); ?>
				</td>
				<td width="21%" class="tdLabel">Country</td>
				<td width="40%"><?php if($getDataForEdit['1']['NewInsurance']['emp_country']){
					$getempSelectCountry2=$getDataForEdit['1']['NewInsurance']['emp_country'];
				}else if($getDataForEditSec['0']['NewInsurance']['emp_country']){
					$getempSelectCountry2=$getDataForEditSec['0']['NewInsurance']['emp_country'];
				}else{
					$getempSelectCountry2='2';
				}
				echo $this->Form->input('NewInsurance.emp_country', array('options' => $countries,'empty' =>'Please Select Country', 'id' => 'emp_country2','selected'=>$getempSelectCountry2 ,'label'=> false, 'div' => false, 'error' => false,'class' => 'textBoxExpnd'));
				?></td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Address</td>
				<td width="30%"><?php echo $this->Form->input('NewInsurance.emp_address', array('label'=>false,'id' => 'emp_address','class'=>'textBoxExpnd','value'=>$getDataForEdit['1']['NewInsurance']['emp_address'] )); ?>
				</td>
				<td width="21%" class="tdLabel">State</td>
				<td width="30%" id="emp_state"><?php //$states = ''; 
				//echo $this->Form->input('NewInsurance.emp_state', array('options' => $states,'empty' =>'Select State', 'id' => 'emp_state','value'=>$getDataForEdit['1']['NewInsurance']['emp_state'] , 'label'=> false, 'div' => false, 'error' => false,'class' => 'textBoxExpnd'));
				if($getDataForEdit['1']['NewInsurance']['emp_state']){
					$getempSelectedState1=$getDataForEdit['1']['NewInsurance']['emp_state'];
				}else if($getDataForEditSec['0']['NewInsurance']['emp_state']){
					$getempSelectedState1=$getDataForEditSec['0']['NewInsurance']['emp_state'];
				}else{
					$getempSelectedState1='84';
				}
				echo $this->Form->input('NewInsurance.emp_state', array('options' => $state,'empty' =>'Please Select State', 'id' => 'emp_state', 'label'=> false, 'div' => false, 'error' => false,'class' => 'textBoxExpnd','selected'=>$getempSelectedState1));?>
				</td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Note</td>
				<td width="30%"><?php if(!empty($getDataForEdit['1']['NewInsurance']['note'])){			
					$getNote2 =  $getDataForEdit['1']['NewInsurance']['note']; 
					}else{
					$getNote2 =  $getDataForEditSec['0']['NewInsurance']['note'];
					}	
				echo $this->Form->input('NewInsurance.note', array('value'=>$getNote2 ,'label'=>false,'id' => 'note','class'=> 'textBoxExpnd')); ?>
				</td>
				<td width="21%" class="tdLabel">City</td>
				<td width="30%" valign="top"><?php if(!empty($getDataForEdit['1']['NewInsurance']['emp_city'])){			
					$getemp_city2 =  $getDataForEdit['1']['NewInsurance']['emp_city']; 
					}else if(!empty($getDataForEditSec['0']['NewInsurance']['emp_city'])){
					$getemp_city2 =  $getDataForEditSec['0']['NewInsurance']['emp_city'];
					}	
				echo $this->Form->input('NewInsurance.emp_city', array('value'=>$getemp_city2 ,'label'=>false,'id' => 'emp_city2','class'=>'textBoxExpnd')); ?>
				</td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Zip Code</td>
				<td width=""><?php echo $this->Form->input('NewInsurance.emp_zip_code', array('type'=>'text','value'=>$getDataForEdit['1']['NewInsurance']['emp_zip_code'] ,'label'=>false,'id' => 'zip_codeote','class'=>'textBoxExpnd','Maxlength'=>5)); ?>
				</td>
			</tr>
			<!-- <tr>
				<td width="21%" class="tdLabel">SSN</td>
				<td width=""><?php echo $this->Form->input('NewInsurance.emp_ssn', array('value'=>$getDataForEdit['1']['NewInsurance']['emp_ssn'] ,'label'=>false,'id' => 'emp_ssn','class'=>'textBoxExpnd','Maxlength'=>5)); ?>
				</td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Phone</td>
				<td width=""><?php echo $this->Form->input('NewInsurance.emp_phone', array('value'=>$getDataForEdit['1']['NewInsurance']['emp_phone'] ,'label'=>false,'id' => 'emp_ssn','class'=>'textBoxExpnd','Maxlength'=>5)); ?>
				</td>
			</tr> -->
		</table>
		<table width="100%" border="0" cellspacing="0" cellpadding="0"
			class="formFull">
			<tr>
				<th style="padding-left: 10px;" colspan="4"><?php echo __('');?> <?php echo $this->Form->input('chkclick', array('type'=>'checkbox','id' => 'ckeckGua','label'=>'Check to copy Guaranter details')); ?>
				</th>
			</tr>

			<tr>
				<td width="24%" class="tdLabel" style="padding:10px 0 0;">Subscriber name</td>
				<td width="28%"><?php echo $this->Form->input('NewInsurance.subscriber_name', array('id'=>'subscriber_name','label'=>false,'class'=> '','style'=>'width:143px','div'=>false,'value'=>$getDataForEdit['1']['NewInsurance']['subscriber_name'])); ?>
					<?php  echo $this->Form->input('NewInsurance.subscriber_initial', array('id'=>'gau_middle_name','label'=>false,'style'=>'width:72px','div'=>false,'value'=>$getDataForEdit['1']['NewInsurance']['subscriber_initial'])); ?>
				</td>
				<td width="21%" class="tdLabel">Subscriber Last name</td>
				<td width="20%"><?php echo $this->Form->input('NewInsurance.subscriber_last_name', array('value'=>$getDataForEdit['1']['NewInsurance']['subscriber_last_name'] ,'id'=>'gau_last_name','label'=>false,'class'=>'textBoxExpnd')); ?>
				</td>

			</tr>
			<tr>
				<td width="21%" class="tdLabel">Date of Birth</td>
				<td width="250"><?php echo $this->Form->input('NewInsurance.subscriber_dob',array('value'=>$this->DateFormat->formatDate2Local($getDataForEdit['1']['NewInsurance']['subscriber_dob'],Configure::read('date_format_us'),false),'id'=>'dobg2','class'=>'textBoxExpnd','type'=>'text','autocomplete'=>"off",'legend'=>false,'div'=>false,'label'=>false,'readonly'=>'readonly'));?>
				</td>
				<td width="21%" class="tdLabel">Gender</td>
				<td width="27%"><?php echo $this->Form->input('NewInsurance.subscriber_gender', array('id'=>'gau_sex','empty'=>__("Select"),'options' => array('Male'=>__('Male'),'Female'=>__('Female'),'Ambiguous'=>__('Ambiguous'),'Not applicable'=>__('Not applicable'),'Unknown'=>__('Unknown'),'Other'=>__('Other')),'selected'=>$getDataForEdit['1']['NewInsurance']['subscriber_gender'] ,'label'=>false,'div'=>false,'class'=>'textBoxExpnd'));?>
				</td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Social Security Number
				</td>
				<td width="27%"><?php echo $this->Form->input('NewInsurance.subscriber_security', array('value'=>$getDataForEdit['1']['NewInsurance']['subscriber_security'],'id'=>'gau_ssn1','maxLength'=>'9','label'=>false,'class'=>'textBoxExpnd ')); ?>
				</td>
				<td width="21%" class="tdLabel">Address1</td>
				<td width="20%"><?php echo $this->Form->input('NewInsurance.subscriber_address1', array('value'=>$getDataForEdit['1']['NewInsurance']['subscriber_address1'],'id'=>'gau_plot_no','label'=>false,'class'=>'textBoxExpnd')); ?>
				</td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Address2</td>
				<td width="20%"><?php echo $this->Form->input('NewInsurance.subscriber_address2', array('value'=>$getDataForEdit['1']['NewInsurance']['subscriber_address2'],'id'=>'gau_landmark','label'=>false,'class'=>'textBoxExpnd')); ?>
				</td>
				<td width="21%" class="tdLabel">Country</td>
				<td width="200px"><?php if($getDataForEdit['1']['NewInsurance']['subscriber_country']){
						$getsubSelectedCountry1=$getDataForEdit['1']['NewInsurance']['subscriber_country'];
				}else{
						$getsubSelectedCountry1='2';
				}
				echo $this->Form->input('NewInsurance.subscriber_country', array('options' =>  $countries,'empty' =>'Please Select Country', 'id' => 'customcountry2', 'label'=> false, 'div' => false, 'error' => false, 'class'=>'textBoxExpnd','selected'=>$getsubSelectedCountry1)); ?>
				</td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">State</td>
				<td width="20%" id="customstate1"><?php ///$state ='';
				if($getDataForEdit['1']['NewInsurance']['subscriber_state']){
					$getsubSelectedState1=$getDataForEdit['1']['NewInsurance']['subscriber_state'];
				}else{
					$getsubSelectedState1='84';
				}
								echo $this->Form->input('NewInsurance.subscriber_state', array('id'=>'customstate2','options' => $state, 'empty' => 'Please Select State', 'label'=> false, 'div' => false, 'error' => false,'class'=> 'textBoxExpnd','selected'=>$getsubSelectedState1)); ?>
				</td>
				<td width="21%" class="tdLabel">City</td>
				<td width="20%" valign="top"><?php echo $this->Form->input('NewInsurance.subscriber_city', array('id'=>'city','label'=>false, 'class'=> 'textBoxExpnd','div'=>false,'value'=>$getDataForEdit['1']['NewInsurance']['subscriber_city'])); ?>
				</td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Zip Code</td>
				<td width="20%"><?php echo $this->Form->input('NewInsurance.subscriber_zip', array('value'=>$getDataForEdit['1']['NewInsurance']['subscriber_zip'],'id'=>'subscriber_zip','label'=>false, 'class'=> 'textBoxExpnd','Maxlength'=>5)); ?>
				</td>
				<td width="21%" class="tdLabel">Primary Phone</td>
				<td width="20%"><?php echo $this->Form->input('NewInsurance.subscriber_primary_phone', array('value'=>$getDataForEdit['1']['NewInsurance']['subscriber_primary_phone'],'type'=>'text','id'=>'gau_home_phone2','label'=>false, 'class'=> 'textBoxExpnd','div'=>false,'maxLength'=>'14')); ?>
				</td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Secondary Phone</td>
				<td width="20%"><?php echo $this->Form->input('NewInsurance.subscriber_secondary_phone', array('value'=>$getDataForEdit['1']['NewInsurance']['subscriber_secondary_phone'],'type'=>'text','id'=>'gau_mobile2','label'=>false,'class'=> 'textBoxExpnd','div'=>false,'maxLength'=>'14')); ?>
				</td>
			</tr>
			  <tr>
                                <!--<td width="50%" id="boxSpace">
                                  <table>-->
                                     <td width="19%" id="boxSpace" class="tdLabel" ><?php echo __('Signature'); ?></td>

                                      <td width="20%"><?php //echo $this->Form->input('NewInsurance.sign', array('type' =>'text', 'id' => 'signature','style'=>'visibility:hidden','label'=>false,'legend'=>false)); ?>

								<!-- <div class="sigPad">
									<ul class="sigNav">
										<li class="drawIt"><a href="#draw-it"><font color="#000000">Sign
													</font> </a>
										</li>
										<li class="clearButton"><a href="#clear"><font color="#000000">Clear</font>
										</a>
										</li>
									</ul>
									<div>
										<div class="typed"></div>
										<canvas class="pad pad_bg" width="290" height="150"></canvas>
										<?php //echo $this->Form->input('NewInsurance.sign', array('type' =>'hidden', 'id' => 'output', 'class' => 'output ','label'=>false,'legend'=>false)); ?>
									</div>
								</div> -->
								<table width="100%" border="0" cellspacing="0" cellpadding="0"
										class="formFull formFullBorder">
										<tr>
											<td>
												<div>
													<?php 
													if($getDataForEdit['1']['NewInsurance']['sign'] != "") {
                            	       echo $this->Html->image('/signpad/'.$getDataForEdit['1']['NewInsurance']['sign'], array('alt' => 'Signature', 'title' => 'Signature', 'width' => '308', 'height' => '150','style'=>"border: 1px solid #000000"));
                            		 } else {
                            	?>
													<?php echo $this->Form->input('NewInsurance.sign', array('type' =>'text', 'id' => 'signature','style'=>'visibility:hidden','label'=>false)); ?>
													<div class="sigPad">
														<ul class="sigNav">
															<li class="drawIt"><a href="#draw-it"><font color="#000">Draw
																		It</font> </a></li>
															<li class="clearButton"><a href="#clear"><font
																	color="#000">Clear</font> </a></li>
														</ul>
														<div>
															<div class="typed"></div>
															<canvas class="pad pad_bg" width="290" height="150"></canvas>
															<?php echo $this->Form->input('NewInsurance.sign_output', array('type' =>'hidden', 'id' => 'output', 'class' => 'output')); ?>
														</div>
													</div>
													<?php } ?>
												</div>
											</td>
										</tr>
									</table>
							</td>
                            
                           <!--  <td class="tdLabel" id="boxSpace" style="text-align:left;">Reffering Doctor</td>
                             
                            <td valign="top">
                             <table cellpadding="0" cellspacing="0" width="100%">
                              <tr>
                            <td>
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td><?php //echo $this->Form->input('NewInsurance.refer_doctor', array('type'=>'text', 'class'=>'textBoxExpnd', 'label'=>false,'value'=>$getDataForEdit['0']['NewInsurance']['refer_doctor'],'id'=>'NewInsuranceReferDoctor')); ?>
							</td>
						</tr>
					</table>
                    </td>
                    </tr>
                            </table>
                            </td> -->
				
			</tr>
		</table>
		<div align="right" style="padding-top:10px;">
			<?php	echo $this->Form->hidden('NewInsurance.refference_id',array('value'=>$id,'id'=>'ref_idsec'));
			echo $this->Form->submit(__('Submit Secondary'), array('escape' => false,'class'=>'blueBtn','id'=>'submit1'));
			?>
			
		</div>
		<?php  echo $this->Form->end();?>
			</div>
	<?php  echo $this->Form->create('NewInsurance3',array('url'=>array('controller'=>'patients','action'=>'editInsurance',$patient_id),'id'=>'editInsurance3','enctype' => 'multipart/form-data'));?>
	<?php echo $this->Form->input('id',array('type'=>'hidden'));?>
	<?php echo $this->Form->input('uploadedImageName',array('type'=>'hidden'));
 	echo $this->Form->hidden('web_cam',array('id'=>'web_cam'));	?>
	<?php echo $this->Form->hidden('NewInsurance.location_id', array('label'=>false,'value'=>$this->Session->read('locationid'),'id' => 'location_id')); ?>
	<?php  if(empty($getDataForEdit[2]['NewInsurance']['patient_uid'])){
		$getUid2=$getDataForEdit[0]['NewInsurance']['patient_uid'];		
	}else{
		$getUid2=$getDataForEdit['2']['NewInsurance']['patient_uid'];
	}echo $this->Form->hidden('NewInsurance.patient_uid', array('label'=>false,'value'=>$patientUid,'id' => 'patient_uid')); ?>
	<?php  if(empty($getDataForEdit[2]['NewInsurance']['patient_id'])){
		$getPatientid2=$getDataForEdit[0]['NewInsurance']['patient_id'];		
	}else{
		$getPatientid2=$getDataForEdit['2']['NewInsurance']['patient_id'];
		}
		echo $this->Form->hidden('NewInsurance.patient_id', array('label'=>false,'value'=>$patient_id,'id' => 'patient_id')); ?>
	<?php if(empty($getDataForEdit[2]['NewInsurance']['id'])){
		//$getid2=$getDataForEdit[0]['NewInsurance']['id'];		
	}else{
		$getid2=$getDataForEdit['2']['NewInsurance']['id'];
		}echo $this->Form->hidden('NewInsurance.id', array('label'=>false,'value'=>$getid2,'id' => 'id2')); ?>

	<div id="tabs-3" class="tab-content" style="padding-top: 5px;">
				<table width="100%" border="0" cellspacing="0" cellpadding="0"
			class="formFull">
			<tr>
				<td width="20%" class="tdLabel">Payor Name<font color="red">*</font>
				<!-- <td width="20%"><?php //debug($getDataForEdit['2']['NewInsurance']);
				echo $this->Form->input('NewInsurance.tariff_standard_id', array('label'=>false,'empty'=>__('Select'),'options'=>$getDataInsuranceType,'id' =>'insurance_type_id3','autocomplete'=> 'off','class' => 'validate[required,custom[mandatory-select]] textBoxExpnd',
				'selected'=>$getDataForEdit['2']['NewInsurance']['tariff_standard_id'])); ?>
				</td> -->
				<?php // echo  $this->Form->hidden('NewInsurance.tariff_standard_name',array('id'=>'tariff_standard_name3','value'=>$getDataForEdit[2]['NewInsurance']['tariff_standard_name']));?>
				<td width="28%"><?php echo $this->Form->input('NewInsurance.tariff_standard_name', array('label'=>false,'id' => 'tariff_standard_name3','autocomplete'=> 'off','class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd','value'=>$getDataForEdit['2']['NewInsurance']['tariff_standard_name'])); ?>
				
				<?php echo $this->Form->hidden('NewInsurance.tariff_standard_id',array('id'=>'insurance_type_id3'));
				echo $this->Form->hidden('NewInsurance.insurance_name',array('id'=>'insurance_name3','value'=>$getDataForEdit['2']['NewInsurance']['insurance_name']));
				echo $this->Form->hidden('NewInsurance.payer_id',array('id'=>'payer_id3','value'=>$getDataForEdit['2']['NewInsurance']['payer_id']));
				echo $this->Form->hidden('NewInsurance.insurance_number',array('id'=>'insurance_number3','value'=>$getDataForEdit['2']['NewInsurance']['insurance_number']));?>
				</td>
				<td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Policy #/Insured ID');?><font
									color="red">*</font>
				</td>			
				<td width="16%"><?php echo $this->Form->input('NewInsurance.policy_no', array('label'=>false,'id' => 'policy_no3','class'=> 'validate[required,custom[mandatory-enter]] textBoxExpnd','div'=>false,'value'=>$getDataForEdit['2']['NewInsurance']['policy_no'])); ?>
				
				<?php echo  $this->Form->hidden('policycheck3',array('id'=>'policycheck','value'=>$getDataForEdit['2']['NewInsurance']['policy_type']));?>
				<input type="radio" id="Mi3" name="NewInsurance[policy_type]" value="MI" style="display: none" ><?php ///echo __('Member ID');?>
					<input type="radio" id="Zz3" name="NewInsurance[policy_type]" value="ZZ" checked='checked'  style="display: none" ><?php ///echo __('Unique Health ID');?></td>
			</tr>
			<tr>
				<td class="tdLabel" id="boxSpace">Responsibility<font color="red">*</font>
				</td>
				<td><?php if($getDataForEdit['2']['NewInsurance']['priority']=='P' || $getDataForEdit['2']['NewInsurance']['priority']=='Primary' || $getDataForEdit['2']['NewInsurance']['priority']==''){
					echo __('Primary');
					$getRespo2='P';
				}else if ($getDataForEdit['2']['NewInsurance']['priority']=='S'){
					echo __('Secondary');
					$getRespo2='S';
				}else{
					echo __('Tertiary');
					$getRespo2='T';
					} ?>
					<?php echo $this->Form->input('NewInsurance.priority',array('type'=>'hidden','value'=>'T')) ?>
				</td>

				<td width="19%" class="tdLabel" id="boxSpace">Effective from</td>
				<?php $getDataForEdit['2']['NewInsurance']['effective_date']= $this->DateFormat->formatDate2Local($getDataForEdit['2']['NewInsurance']['effective_date'],Configure::read('date_format_us'),false);?>
				<td width="26%"><?php echo $this->Form->input('NewInsurance.effective_date', array('label'=>false,'type'=>'text','class' => 'textBoxExpnd','id' => 'efdate3','readonly'=>'readonly','value'=>$getDataForEdit['2']['NewInsurance']['effective_date'])); ?>
				</td>
			</tr>
		<!-- 	<tr>
				<td width="21%" class="tdLabel" id="boxSpace"><?php echo __('Insurance Name');?>
				</td>
				<td width="28%"><?php echo $this->Form->input('NewInsurance.insurance_name', array('label'=>false,'id' => 'insurance_name3','autocomplete'=> 'off','class' => 'validate["",custom[mandatory-select]] textBoxExpnd'
						,'value'=>$getDataForEdit['0']['NewInsurance']['insurance_name'])); ?>
				</td>
				<td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Insurance ID');?>
				</td>
				<td width="26%"><?php echo $this->Form->input('NewInsurance.insurance_number', array('label'=>false,'id' => 'insurance_number3','class'=> 'textBoxExpnd','div'=>false,'value'=>$getDataForEdit['2']['NewInsurance']['insurance_number'])); ?>
				</td>
			</tr> -->
			<tr>
				<td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Group Name')?>
				</td>
				<td width="20%"><?php echo $this->Form->input('NewInsurance.group_name', array('label'=>false,'id' => 'group_name','class'=> 'textBoxExpnd','div'=>false,'value'=>$getDataForEdit['2']['NewInsurance']['group_name'])); ?>
				</td>

				<td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Group ID')?>
				</td>
				<td width="26%"><?php echo $this->Form->input('NewInsurance.group_number', array( 'id' =>'group_number', 'class'=> 'textBoxExpnd','label'=>false, 'div' => false, 'error' => false,'value'=>$getDataForEdit['2']['NewInsurance']['group_number'])); ?>
				</td>
			</tr>
			<tr>
				<td width="19%" id="boxSpace" class="tdLabel">Co pay type<font
					color="red">*</font>
				</td>
				<td width="20%"><?php echo $this->Form->input('NewInsurance.copay_type', array('label'=>false,'empty'=>__("Select"),'options'=>array('Fixed','Percentage'),'selected'=>$getDataForEdit['2']['NewInsurance']['copay_type'],'id' => 'copay_type2','class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','onchange'=>'javascript:getPercentage()')); ?>
				</td>

				<td width="19%" class="tdLabel" id="boxSpace">Relation to insured</td>
				<td width="26%"><?php echo $this->Form->input('NewInsurance.relation', array( 'id' =>'relation','empty'=>'Select', 'options'=>array('self'=>'Self','spouse'=>'Spouse','child'=>'Child','other'=>'Other','D'=>'Unspecified Dependent'),'value'=>$getDataForEdit['2']['NewInsurance']['relation'] ,'class'=> 'textBoxExpnd','label'=>false, 'div' => false, 'error' => false)); ?>
				</td>
			</tr>
			<tr>
				<?php  if(!empty($getDataForEdit['2']['NewInsurance']['fixed_percentage'])){
					$dataFixPercentage=$getDataForEdit['2']['NewInsurance']['fixed_percentage'];
					$status='false';
				}
				else{
						$dataFixPercentage="Enter Percentage(ex:30%)";
							
						}
						if(!empty($getDataForEdit['2']['NewInsurance']['fixed_amt'])){
							$dataFix=$getDataForEdit['2']['NewInsurance']['fixed_amt'];
						}
						else{
							$dataFix="Enter Amount(ex:$300)";
						}
						?>
				<td valign="middle" class="tdLabel" id="boxSpace"></td>
				<td><?php echo $this->Form->input('NewInsurance.fixed_percentage', array('type'=>'text','label'=>false,'class' => 'validate[required,custom[name],custom[onlyNumberSp]] textBoxExpnd fixed_percent','value'=>$dataFixPercentage,'id' => 'fixed_percentage_tri','onclick'=>'javascript:removetextTri()'));
				echo $this->Form->input('NewInsurance.fixed_amt', array('type'=>'text','label'=>false,'class' => 'validate[required,custom[name],custom[onlyNumberSp]] textBoxExpnd','value'=>$dataFix,'id' => 'fixed_amt_tri','onclick'=>'javascript:removetextTri()')); ?>
				</td>
			</tr>
			<!-- <tr>
				<td width="19%" class="tdLabel" id="boxSpace">Active</td>
				<td width="26%"> --><?php echo $this->Form->checkbox('NewInsurance.is_active', array('label'=>false,'id' => 'is_active','checked'=>'checked' ,'style'=>'display:none;')); ?>
			<!--  	</td>
				<td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Is Person');?>
				</td>-->
				<?php echo $this->Form->hidden('isperson',array('id'=>'isperson3','value'=>$getDataForEdit['2']['NewInsurance']['is_person']));?>
				<!-- <td width="16%"> --><input type="radio" id="yes3" name="NewInsurance[is_person]" value="Yes" style="display: none"><?php //echo __('Yes');?><br>
					<input type="radio"  id="no3" name="NewInsurance[is_person]" value="No" style="display: none"><?php //echo __('No');?>	<!--</td>
		 </tr> -->
			<tr>
				<td width="19%" class="tdLabel" id="boxSpace">Upload Insurance Card</td>

				<td width="20%"><?php 
				echo $this->Form->input('NewInsurance.upload_card', array('type'=>'file','id' => 'patient_photo3', 'class'=>"textBoxExpnd",'label'=> false,
					 				'div' => false, 'error' => false));?>			
				<?php//if(!empty($getDataForEdit['NewInsurance']['id'])){?>
				<?php //debug($this->request->data);
										$imageName =  $getDataForEdit['2']['NewInsurance']['upload_card']; ?>
					<span  id="viewImage" style="cursor: pointer;" title="View Image"
					onclick="getImage('<?php echo $imageName ?>');return false;">View
						Card</span>
			<?php echo $this->Html->image('/img/icons/webcam.png',array('id'=>'camera','title'=>'Capture photo from webcam'));?>
					<canvas width="320" height="240" id="parent_canvas"
						style="display: none;"></canvas>
				</td>
				<td width="19%" class="tdLabel" id="boxSpace">Back of Card</td>
				<td width="19%"><?php 
					echo $this->Form->input('NewInsurance.back_of_card', array('type'=>'file','id' => 'back_of_card', 'class'=>"textBoxExpnd",'label'=> false,'div' => false, 'error' => false)); ?>
									<?php echo $this->Html->image('/img/icons/webcam.png',array('id'=>'camera_card','title'=>'Capture photo from webcam'));?>
									<canvas width="320" height="240" id="parent_canvas_card" style="display: none;"></canvas>
										<?php //debug($this->request->data);
//debug($getDataForEdit['0']['NewInsurance']);exit;
										$imageName =  $getDataForEdit['2']['NewInsurance']['back_of_card']; ?>
					<span id="viewImage" style="cursor: pointer;" title="View Image"
					onclick="getImage('<?php echo $imageName ?>');return false;">View
						Card</span>
				</td>
			</tr>


			<!-- <tr>
				<td class="tdLabel" style="text-align: left;" id="boxSpace">Claim Officer<font color="red">*</font>
				</td>
				<td><?php echo $this->Form->input('NewInsurance.claim_officer', array('type'=>'text','class'=>'textBoxExpnd validate[required,custom[mandatory-enter]]','label'=>false,'value'=>$getDataForEdit['2']['NewInsurance']['claim_officer'])); ?>
				</td>
				<td style="text-align: left;" class="tdLabel" id="boxSpace">Patient Student Status</td>
				<td><?php echo $this->Form->input('NewInsurance.patient_stuent_status', array('type'=>'text', 'class'=>'textBoxExpnd', 'label'=>false,'value'=>$getDataForEdit['1']['NewInsurance']['patient_stuent_status'])); ?>
				</td>
			</tr> -->
			<tr>
				<td id="boxSpace" class="tdLabel" colspan="4">
								<?php if(!empty($getDataForEdit['2']['NewInsurance']['verify'])){
									$checkedverify3='checked';
								}
								echo $this->Form->checkbox('NewInsurance.verify', array('label'=>false,'id' => 'is_active3','checked'=>$checkedverify3)); ?>
										<?php echo __("Verified");?>
										<?php if(!empty($getDataForEdit['2']['NewInsurance']['is_assign'])){
									$checkedass3='checked';
								}echo $this->Form->checkbox('NewInsurance.is_assign', array('label'=>false,'id' => 'is_assign3','checked'=>$checkedass3)); ?>
										<?php echo __("Accept Assign");?>
										<?php if(!empty($getDataForEdit['2']['NewInsurance']['is_assign'])){
									$checkedeob3='checked';
								}echo $this->Form->checkbox('NewInsurance.is_eob', array('label'=>false,'id' => 'is_eob3','checked'=>$checkedeob3)); ?>
										<?php echo __("EOB");?>
				</td>
				</tr>
				<tr>
				<td id="boxSpace" class="tdLabel" colspan="4" style="float:none;"><?php $checkedauth3 = ($getDataForEdit['2']['NewInsurance']['tri_is_authorized'] == 'Y') ? true : false;
				echo $this->Form->checkbox('NewInsurance.tri_is_authorized', array('label'=>false,'id' => 'tri_is_authorized','checked'=>$checkedauth3,'value'=>'Y')); ?>
				<?php echo __("AUTHORIZATION TO PAY BENEFITS TO PHYSICIAN: I hereby authorize payment of surgical/medical/benefits directly to Hope Hospital Inpatient.");?>
				</td>
				</tr>   
            	</table>
				
		<table width="100%" border="0" cellspacing="0" cellpadding="0"
			class="formFull">
			<tr>
				<th style="padding-left: 10px;" colspan="4"><?php echo __('Employer Information');?>
				</th>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Employer Name</td>
				<td width="43%"><?php echo $this->Form->input('NewInsurance.employer', array('label'=>false,'div'=>false,'id' => 'employer','value'=>$getDataForEdit['2']['NewInsurance']['employer'],'class'=> 'textBoxExpnd')); ?>
				</td>
				<td width="21%" class="tdLabel">Country</td>
				<td width="40%"><?php  if($getDataForEdit['2']['NewInsurance']['emp_country']){
						$getempempSelectedCountry2=$getDataForEdit['2']['NewInsurance']['emp_country'];
				}else{
						$getempempSelectedCountry2='2';
				}
				echo $this->Form->input('NewInsurance.emp_country', array('options' => $countries,'empty' =>'Please Select Country', 'id' => 'emp_country3','selected'=>$getempempSelectedCountry2 ,'label'=> false, 'div' => false, 'error' => false,'onchange'=> $this->Js->request(array('controller'=>'persons','action' => 'get_state_city','reference'=>'State','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#emp_state', 'data' => '{reference_id:$("#emp_country").val()}', 'dataExpression' => true, 'div'=>false)),'class' => 'validate[,custom[mandatory-select]] textBoxExpnd'));
				?></td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Address</td>
				<td width="30%"><?php echo $this->Form->input('NewInsurance.emp_address', array('label'=>false,'id' => 'emp_address','class'=>'textBoxExpnd','value'=>$getDataForEdit['2']['NewInsurance']['emp_address'] )); ?>
				</td>
				<td width="21%" class="tdLabel">State</td>
				<td width="30%" id="emp_state"><?php if($getDataForEdit['2']['NewInsurance']['emp_state']){
					$getempSelectedState2=$getDataForEdit['2']['NewInsurance']['emp_state'];
				}else{
					$getempSelectedState2='84';
				}
				 echo $this->Form->input('NewInsurance.emp_state', array('options' => $state,'empty' =>'Select State', 'id' => 'emp_state','selected'=>$getempSelectedState2 , 'label'=> false, 'div' => false, 'error' => false,'class' => 'validate[,custom[mandatory-select]] textBoxExpnd'));?>
				</td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Note</td>
				<td width="30%"><?php echo $this->Form->input('NewInsurance.note', array('value'=>$getDataForEdit['2']['NewInsurance']['note'] ,'label'=>false,'id' => 'note','class'=> 'textBoxExpnd')); ?>
				</td>
				<td width="21%" class="tdLabel">City</td>
				<td width="30%" valign="top"><?php echo $this->Form->input('NewInsurance.emp_city', array('value'=>$getDataForEdit['2']['NewInsurance']['emp_city'] ,'label'=>false,'id' => 'city','class'=>'textBoxExpnd')); ?>
				</td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Zip Code</td>
				<td width=""><?php echo $this->Form->input('NewInsurance.emp_zip_code', array('type'=>'text','value'=>$getDataForEdit['2']['NewInsurance']['emp_zip_code'] ,'label'=>false,'id' => 'zip_codeote','class'=>'textBoxExpnd','Maxlength'=>5)); ?>
				</td>
			</tr>
			<!-- <tr>
				<td width="21%" class="tdLabel">SSN</td>
				<td width=""><?php echo $this->Form->input('NewInsurance.emp_ssn', array('value'=>$getDataForEdit['2']['NewInsurance']['emp_ssn'] ,'label'=>false,'id' => 'emp_ssn','class'=>'textBoxExpnd','Maxlength'=>5)); ?>
				</td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Phone</td>
				<td width=""><?php echo $this->Form->input('NewInsurance.emp_phone', array('value'=>$getDataForEdit['2']['NewInsurance']['emp_phone'] ,'label'=>false,'id' => 'emp_ssn','class'=>'textBoxExpnd','Maxlength'=>5)); ?>
				</td>
			</tr> -->
		</table>
		<table width="100%" border="0" cellspacing="0" cellpadding="0"
			class="formFull">
			<tr>
				<th style="padding-left: 10px;" colspan="4"><?php echo __('');?> <?php echo $this->Form->input('chkclick', array('type'=>'checkbox','id' => 'ckeckGua','label'=>'Check to copy Guaranter details')); ?>
				</th>
			</tr>

			<tr>
				<td width="24%" class="tdLabel">Subscriber name</td>
				<td width="28%"><?php echo $this->Form->input('NewInsurance.subscriber_name', array('value'=>$getDataForEdit['2']['NewInsurance']['subscriber_name'] ,'id'=>'subscriber_name','label'=>false,'class'=> '','style'=>'width:143px','div'=>false)); ?>
					<?php  echo $this->Form->input('NewInsurance.subscriber_initial', array('id'=>'gau_middle_name','label'=>false,'style'=>'width:72px','div'=>false,'value'=>$getDataForEdit['2']['NewInsurance']['subscriber_initial'])); ?>
				</td>
				<td width="21%" class="tdLabel">Subscriber Last name</td>
				<td width="20%"><?php echo $this->Form->input('NewInsurance.subscriber_last_name', array('value'=>$getDataForEdit['2']['NewInsurance']['subscriber_last_name'] ,'id'=>'gau_last_name','label'=>false,'class'=>'textBoxExpnd')); ?>
				</td>

			</tr>
			<tr>
				<td width="21%" class="tdLabel">Date of Birth</td>
				<td width="250"><?php echo $this->Form->input('NewInsurance.subscriber_dob',array('value'=>$this->DateFormat->formatDate2Local($getDataForEdit['2']['NewInsurance']['subscriber_dob'],Configure::read('date_format_us'),false),'id'=>'dobg3','class'=>'textBoxExpnd','type'=>'text','autocomplete'=>"off",'legend'=>false,'div'=>false,'label'=>false,'readonly'=>'readonly'));?>
				</td>
				<td width="21%" class="tdLabel">Gender</td>
				<td width="27%"><?php echo $this->Form->input('NewInsurance.subscriber_gender', array('id'=>'gau_sex','empty'=>__("Select"),'options' => array('Male'=>__('Male'),'Female'=>__('Female'),'Ambiguous'=>__('Ambiguous'),'Not applicable'=>__('Not applicable'),'Unknown'=>__('Unknown'),'Other'=>__('Other')),'selected'=>$getDataForEdit['2']['NewInsurance']['subscriber_gender'],'label'=>false,'div'=>false,'class'=>'textBoxExpnd'));?>
				</td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Social Security Number
				</td>
				<td width="27%"><?php echo $this->Form->input('NewInsurance.subscriber_security', array('value'=>$getDataForEdit['2']['NewInsurance']['subscriber_security'],'id'=>'gau_ssn2','maxLength'=>'9','label'=>false,'class'=>'textBoxExpnd')); ?>
				</td>
				<td width="21%" class="tdLabel">Address1</td>
				<td width="20%"><?php echo $this->Form->input('NewInsurance.subscriber_address1', array('value'=>$getDataForEdit['2']['NewInsurance']['subscriber_address1'],'id'=>'gau_plot_no','label'=>false,'class'=>'textBoxExpnd')); ?>
				</td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Address2</td>
				<td width="20%"><?php echo $this->Form->input('NewInsurance.subscriber_address2', array('value'=>$getDataForEdit['2']['NewInsurance']['subscriber_address2'],'id'=>'gau_landmark','label'=>false,'class'=>'textBoxExpnd')); ?>
				</td>
				<td width="21%" class="tdLabel">Country</td>
				<td width="200px"><?php if($getDataForEdit['2']['NewInsurance']['subscriber_country']){
						$getsubSelectedCountry2=$getDataForEdit['2']['NewInsurance']['subscriber_country'];
				}else{
						$getsubSelectedCountry2='2';
				}
				echo $this->Form->input('NewInsurance.subscriber_country', array('options' => $countries,'empty' =>'Please Select Country',  'id' => 'customcountry3', 'label'=> false, 'div' => false, 'error' => false, 'class'=>'textBoxExpnd','selected'=>$getsubSelectedCountry2)); ?>
				</td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">State</td>
				<td width="20%" id="customstate1"><?php ///$state ='';
				 if($getDataForEdit['2']['NewInsurance']['subscriber_state']){
				 	$getsubSelectedState2=$getDataForEdit['2']['NewInsurance']['subscriber_state'];
				 }else{
				 	$getsubSelectedState2='84';
				 }
								echo $this->Form->input('NewInsurance.subscriber_state', array('id'=>'customstate3','options' => $state, 'empty' => 'Please Select State', 'label'=> false, 'div' => false, 'error' => false,'class'=> 'textBoxExpnd','selected'=>$getsubSelectedState2)); ?>
				</td>
				<td width="21%" class="tdLabel">City</td>
				<td width="20%" valign="top"><?php echo $this->Form->input('NewInsurance.subscriber_city', array('id'=>'subscriber_city3','label'=>false, 'class'=> 'textBoxExpnd','div'=>false,'value'=>$getDataForEdit['2']['NewInsurance']['subscriber_city'])); ?>
				</td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Zip Code</td>
				<td width="20%"><?php echo $this->Form->input('NewInsurance.subscriber_zip', array('type'=>'text','value'=>$getDataForEdit['2']['NewInsurance']['subscriber_zip'],'id'=>'subscriber_zip','label'=>false, 'class'=> 'textBoxExpnd','Maxlength'=>5)); ?>
				</td>
				<td width="21%" class="tdLabel">Primary Phone</td>
				<td width="20%"><?php echo $this->Form->input('NewInsurance.subscriber_primary_phone', array('value'=>$getDataForEdit['2']['NewInsurance']['subscriber_primary_phone'],'type'=>'text','id'=>'gau_home_phone3','label'=>false, 'class'=> 'textBoxExpnd','div'=>false,'maxLength'=>'14')); ?>
				</td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Secondary Phone</td>
				<td width="20%"><?php echo $this->Form->input('NewInsurance.subscriber_secondary_phone', array('value'=>$getDataForEdit['2']['NewInsurance']['subscriber_secondary_phone'],'type'=>'text','id'=>'gau_mobile3','label'=>false,'class'=> 'textBoxExpnd','div'=>false,'maxLength'=>'14')); ?>
				</td>
			</tr>
			   <tr>
                                     <td width="19%" id="boxSpace" class="tdLabel" ><?php echo __('Signature'); ?></td>

                                      <td width="20%"><?php //echo $this->Form->input('NewInsurance.sign', array('type' =>'text', 'id' => 'signature','style'=>'visibility:hidden','label'=>false,'legend'=>false)); ?>

								<!--  <div class="sigPad">
									<ul class="sigNav">
										<li class="drawIt"><a href="#draw-it"><font color="#000000">Sign
													</font> </a>
										</li>
										<li class="clearButton"><a href="#clear"><font color="#000000">Clear</font>
										</a>
										</li>
									</ul>
									<div>
										<div class="typed"></div>
										<canvas class="pad pad_bg" width="290" height="150"></canvas>
										<?php echo $this->Form->input('NewInsurance.sign', array('type' =>'hidden', 'id' => 'output', 'class' => 'output ','label'=>false,'legend'=>false)); ?>
									</div>
								</div>-->
									<table width="100%" border="0" cellspacing="0" cellpadding="0"
										class="formFull formFullBorder">
										<tr>
											<td>
												<div>
													<?php 
													if($getDataForEdit['2']['NewInsurance']['sign'] != "") {
                            	       echo $this->Html->image('/signpad/'.$getDataForEdit['2']['NewInsurance']['sign'], array('alt' => 'Signature', 'title' => 'Signature', 'width' => '308', 'height' => '150','style'=>"border: 1px solid #000000"));
                            		 } else {
                            	?>
													<?php echo $this->Form->input('NewInsurance.sign', array('type' =>'text', 'id' => 'signature','style'=>'visibility:hidden','label'=>false)); ?>
													<div class="sigPad">
														<ul class="sigNav">
															<li class="drawIt"><a href="#draw-it"><font color="#000">Draw
																		It</font> </a></li>
															<li class="clearButton"><a href="#clear"><font
																	color="#000">Clear</font> </a></li>
														</ul>
														<div>
															<div class="typed"></div>
															<canvas class="pad pad_bg" width="290" height="150"></canvas>
															<?php echo $this->Form->input('NewInsurance.sign_output', array('type' =>'hidden', 'id' => 'output', 'class' => 'output')); ?>
														</div>
													</div>
													<?php } ?>
												</div>
											</td>
										</tr>
									</table>
							</td>
                            
                           <!--  <td class="tdLabel" id="boxSpace" style="text-align:left;">Reffering Doctor</td>
                             
                            <td valign="top">
                             <table cellpadding="0" cellspacing="0" width="100%">
                              <tr>
                            <td>
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td><?php echo $this->Form->input('NewInsurance.refer_doctor', array('type'=>'text', 'class'=>'textBoxExpnd', 'label'=>false,'value'=>$getDataForEdit['0']['NewInsurance']['refer_doctor'])); ?>
							</td>
						</tr>
					</table>
                    </td>
                            </tr>
                            </table>
                            </td>-->
                                
                                </tr>
		</table>
		<?php //echo $this->Form->hidden('NewInsurance.refference_id',array('value'=>$lastInsertId));?>
		<div align="right" style="padding-top:10px;">
		<?php echo $this->Form->hidden('NewInsurance3.check',array('value'=>'thrid_tab'));
	 	if(empty($getDataForEdit['2']['NewInsurance']['refference_id'])){
			$getRefferannaceId2=$id;
		}else{
			$getRefferannaceId2=$getDataForEdit['2']['NewInsurance']['refference_id'];
			}echo $this->Form->hidden('NewInsurance.refference_id', array('label'=>false,'value'=>$getRefferannaceId2,'id' => 'id2')); 			
		echo $this->Form->submit(__('Submit Tertiary'), array('escape' => false,'class'=>'blueBtn','id'=>'submit2'));
		?>
	
	</div>
		<?php  echo $this->Form->end();?>
	</div>
</div>
<script>
function insurance_type_onchange(){
	var id = $('#insurance_type_id').val();
	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "insurance_onchange","admin" => false)); ?>";
	$.ajax({
	type: 'POST',
	url: ajaxUrl+"/"+id,
	data: '',
	dataType: 'html',
	success: function(data){
	  	data= $.parseJSON(data);
	  	if(data !=''){
	  		$("#insurance_company_id option").remove();
	  		//$("#save").removeAttr('disabled');
		  	$.each(data, function(val, text) {
			  	if(text)
			    $("#insurance_company_id").append( "<option value='"+val+"'>"+text+"</option>" );
			}); 
	  	}else{  
	  		$("#insurance_company_id option").remove();
	  		//$("#save").attr('disabled','disabled');
		  	alert("Data not available");
	  	} 
	  	
	  	    
	},

	error: function(message){
	alert("Internal Error Occured. Unable to set data.");
	} });

	return false;
	}

$('#camera')
.click(
		function() {
			$
					.fancybox({
						'autoDimensions' : false,
						'width' : '85%',
						'height' : '90%',
						'autoScale' : true,
						'transitionIn' : 'fade',
						'transitionOut' : 'fade',
						'type' : 'iframe',
						'href' : '<?php echo $this->Html->url(array("action" => "webcam")); ?>'
					});
		});

function getImage(imageName){ //alert(imageName);
	$.fancybox({
		'width' : '19%',
		'height' : '42%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',		
		'href' : "<?php echo $this->Html->url(array("controller" => "patients", "action" => "viewImage")); ?>"+'?image='+imageName

	});
}
 
 function getPercentage(){
	var getData = $("#copay_type option:selected").val();	
	if(getData=='1'){
		$("#fixed_percentage").show();
		$("#fixed_amt").hide();
		//alert('if');
	}	
	else if(getData=='0'){
		$("#fixed_amt").show();
		$("#fixed_percentage").hide();//alert('else');
	}else{
		$("#fixed_percentage").hide();
		$("#fixed_amt").hide();
	}	
}
function removetext(){	 
	 $("#fixed_amt").val(" ");
	 $("#fixed_percentage").val(" ");	 
 }
$(document).ready(function(){

$("#dobg").datepicker({
	showOn : "both",
	buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly : true,
	changeMonth : true,
	changeYear : true,
	yearRange: '-100:' + new Date().getFullYear(),
	maxDate : new Date(),
	dateFormat:'<?php echo $this->General->GeneralDate();?>',
	onSelect : function() {
		//$(this).focus();										
		$(this).validationEngine("hide");
	}			
});	
$("#dobg2").datepicker({
	showOn : "both",
	buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly : true,
	changeMonth : true,
	changeYear : true,
	yearRange: '-100:' + new Date().getFullYear(),
	maxDate : new Date(),
	dateFormat:'<?php echo $this->General->GeneralDate();?>',
	onSelect : function() {
		//$(this).focus();										
		$(this).validationEngine("hide");
	}			
});	
$("#dobg3").datepicker({
	showOn : "both",
	buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly : true,
	changeMonth : true,
	changeYear : true,
	yearRange: '-100:' + new Date().getFullYear(),
	maxDate : new Date(),
	dateFormat:'<?php echo $this->General->GeneralDate();?>',
	onSelect : function() {
		//$(this).focus();										
		$(this).validationEngine("hide");
	}			
});	
	 
$("#efdate").datepicker({
		showOn : "button",
		buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly : true,
		changeMonth : true,
		changeYear : true,
		yearRange: '-100:' + new Date().getFullYear(),
		maxDate : new Date(),
		dateFormat:'<?php echo $this->General->GeneralDate();?>',
		onSelect : function() {
			$(this).focus();
			//foramtEnddate(); //is not defined hence commented
		}
});
$("#efdate2").datepicker({
	showOn : "button",
	buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly : true,
	changeMonth : true,
	changeYear : true,
	yearRange: '-100:' + new Date().getFullYear(),
	maxDate : new Date(),
	dateFormat:'<?php echo $this->General->GeneralDate();?>',
	onSelect : function() {
		$(this).focus();
		//foramtEnddate(); //is not defined hence commented
	}
});
$("#efdate3").datepicker({
	showOn : "button",
	buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly : true,
	changeMonth : true,
	changeYear : true,
	yearRange: '-100:' + new Date().getFullYear(),
	maxDate : new Date(),
	dateFormat:'<?php echo $this->General->GeneralDate();?>',
	onSelect : function() {
		$(this).focus();
		//foramtEnddate(); //is not defined hence commented
	}
});
	

	

	//$('#secondary').trigger('click');

	$('#copay_type1, #secondary').click(function getPercentageSec(){ 
 		var getData1 = $("#copay_type1 option:selected").val();
 		
			if(getData1=='1'){
				$("#fixed_percentage_sec").show();
				$("#fixed_amt_sec").hide();
				//alert('if');
			}else if(getData1=='0'){
				$("#fixed_amt_sec").show();
				$("#fixed_percentage_sec").hide();//alert('else');
			}else{
				$("#fixed_percentage_sec").hide();
				$("#fixed_amt_sec").hide();
			}			
	});
	$('#copay_type2, #tritiary').click(function getPercentageSec(){ 
 		var getData1 = $("#copay_type2 option:selected").val();
			if(getData1=='1'){
				$("#fixed_percentage_tri").show();
				$("#fixed_amt_tri").hide();
				
				//alert('if');
			}else if(getData1=='0'){
				$("#fixed_amt_tri").show();
				$("#fixed_percentage_tri").hide();//alert('else');
			}else{
				$("#fixed_percentage_tri").hide();
				$("#fixed_amt_tri").hide();
			}			
	});
});
 function removetextSec(){	 
	 $("#fixed_amt_sec").val(" ");
	 $("#fixed_percentage_sec").val(" ");	 
 }
 function removetextTri(){	 
	 $("#fixed_amt_tri").val(" ");
	 $("#fixed_percentage_tri").val(" ");	 
 }
 


 $("#ckeckGua").change(function edit_loadGauranter(){
var id='<?php echo $patient_id ;?>';
	// alert(id);
		//return;
	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "edit_loadGauranter","admin" => false)); ?>";
						var formData = $('#editinsurance').serialize();
						if (formData == "") {
							var formData = $('#patientnotesfrm').serialize();
							var renderpage = true;
						}
						$.ajax({
							type : 'POST',
							url : ajaxUrl + "/" + id,
							//  data: formData,
							dataType : 'html',
							success : function(data) {

								var data = data.split("|"); //alert(data[9]);
								$("#person_id").val(id);
								$("#subscriber_name").val(data[1]);//alert(data[1]);
								$("#gau_middle_name").val(data[1]);
								$("#gau_last_name").val(data[2]);
								$("#dobg").val(data[3]);
								$("#gau_sex").val(data[4]);
								$("#gau_ssn").val(data[5]);
								$("#gau_plot_no").val(data[6]);
								$("#gau_landmark").val(data[7]);
								$("#customcountry1").val(data[8]);
								$("#customstate12").val(data[9]);
								$("#city").val(data[10]);
								$("#subscriber_zip").val(data[11]);
								$("#gau_home_phone").val(data[12]);
								$("#gau_mobile").val(data[13]);
							},
							error : function(message) {
								alert("Error in Retrieving data");
							}
						});
						return false;

					});
</script>
<script>
	$(document).ready(function() {
				var copay_type = $('#copay_type').val();
				if (copay_type == '0') {
					$('#fixed_amt').show();
					$('#fixed_percentage').hide();
				} else if (copay_type == '1') {
					$('#fixed_percentage').show();
					$('#fixed_amt').hide();
				} else {
					$("#fixed_percentage").hide();
					$("#fixed_amt").hide();
				}
				var copay_type = $('#copay_type1').val();
				if (copay_type == '0') {
					$('#fixed_amt_sec').show();
					$('#fixed_percentage_sec').hide();
				} else if (copay_type == '1') {
					$('#fixed_percentage_sec').show();
					$('#fixed_amt_sec').hide();
				} else {
					$("#fixed_percentage_sec").hide();
					$("#fixed_amt_sec").hide();
				}
				var copay_type = $('#copay_type2').val();
				if (copay_type == '0') {
					$('#fixed_amt_tri').show();
					$('#fixed_percentage_tri').hide();
				} else if (copay_type == '1') {
					$('#fixed_percentage_tri').show();
					$('#fixed_amt_tri').hide();
				} else {
					$("#fixed_percentage_tri").hide();
					$("#fixed_amt_tri").hide();
				}
				// alert(copay_type);
				///	fixed_amtfixed_percentage
				/*jQuery("#editinsurance").validationEngine({
					validateNonVisibleFields : true,
					updatePromptsPosition : true,
				});**/
				$('#submit,#submit1,#submit2').click(
						function() {
							//alert("hello");
							var validatePerson = jQuery("#editinsurance,#editinsurance1,#editinsurance3").validationEngine('validate');
	if (validatePerson) {$(this).css('display', 'none');}
	else{
	return false;
	}
							//return false;
						});
			});
	/* $("#refer_doctor").autocomplete("<?php //echo $this->Html->url(array("controller" => "Laboratories", "action" => "testcomplete","DoctorProfile","doctor_name",'null',"admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true,
			valueSelected:true,
			showNoId:true,
			loadId : 'refer_doctor,sb_registrar'
		});*/
	 $(document).ready(function(){
		 $("#NewInsuranceReferDoctor").autocomplete("<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "testcomplete","DoctorProfile","user_id","doctor_name",'null',"admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true,
				valueSelected:true,
				loadId : 'NewInsuranceReferDoctor,doctorID'
			});
	});
			
</script>
<script>
$('#insurance_type_id').change(function(){
	$('#tariff_standard_name1').val($('#insurance_type_id option:selected').text());
});
$('#insurance_type_id2').change(function(){
	$('#tariff_standard_name2').val($('#insurance_type_id2 option:selected').text());
});
$('#insurance_type_id3').change(function(){
	$('#tariff_standard_name3').val($('#insurance_type_id3 option:selected').text());
});
	
    $(document).ready(function() {
      $('.sigPad').signaturePad();
      //********************************************
      if($('#policycheck').val()=='ZZ'){
      $('#Zz'). attr('checked','checked');
      }else{
    	  $('#Mi'). attr('checked','checked');
      }
      if($('#isperson').val()=='Yes'){
    	  $('#yes'). attr('checked','checked');
      }else{
    	  $('#no'). attr('checked','checked');
      }
      //*********************************************
      if($('#policycheck2').val()=='ZZ'){
          $('#Zz2'). attr('checked','checked');
          }else{
        	  $('#Mi2'). attr('checked','checked');
          }
      if($('#isperson2').val()=='Yes'){
    	  $('#yes2'). attr('checked','checked');
      }else{
    	  $('#no2'). attr('checked','checked');
      }
      //***********************************************
      if($('#policycheck3').val()=='ZZ'){
          $('#Zz3'). attr('checked','checked');
          }else{
        	  $('#Mi3'). attr('checked','checked');
          }
      if($('#isperson3').val()=='Yes'){
    	  $('#yes3'). attr('checked','checked');
      }else{
    	  $('#no3'). attr('checked','checked');
      }
      $("#tariff_standard_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","TariffStandard","id","name",'null',"admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true,
			valueSelected:true,
			showNoId:true,
			loadId : 'tariff_standard_name,insurance_type_id',
			onItemSelect:function( ) {
				var payerID = $('#insurance_type_id').val();//code_type
				var URL = "<?php echo $this->Html->url(array('controller' => 'patients', 'action' => 'tariffPayerId','admin' => false,'plugin'=>false)); ?>";
				$.ajax({
				type: "GET",
				url: URL+"/"+payerID,
				success : function ( data ){
				var tariffStandardData = jQuery.parseJSON(data);
				console.log(data);
				$('#payer_id').val(tariffStandardData.TariffStandard.payer_id);
				$('#insurance_number').val(tariffStandardData.TariffStandard.HealthplanDetailID);	
				}
				});
				}
		});		
$('#tariff_standard_name').keydown(function(){
	$("#insurance_type_id").val('');	 
});
$("#tariff_standard_name2").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","TariffStandard","id","name",'null',"admin" => false,"plugin"=>false)); ?>", {
	width: 250,
	selectFirst: true,
	valueSelected:true,
	showNoId:true,
	loadId : 'tariff_standard_name2,insurance_type_id2',
	onItemSelect:function( ) {
		var payerID = $('#insurance_type_id2').val();//code_type
		var URL = "<?php echo $this->Html->url(array('controller' => 'patients', 'action' => 'tariffPayerId','admin' => false,'plugin'=>false)); ?>";
		$.ajax({
		type: "GET",
		url: URL+"/"+payerID,
		success : function ( data ){
		var tariffStandardData = jQuery.parseJSON(data);
		console.log(data);
		$('#payer_id2').val(tariffStandardData.TariffStandard.payer_id);
		$('#insurance_number2').val(tariffStandardData.TariffStandard.HealthplanDetailID);	
		}
		});
		}
});		
$('#tariff_standard_name2').keydown(function(){
$("#insurance_type_id2").val('');	 
}); 	
$("#tariff_standard_name3").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","TariffStandard","id","name",'null',"admin" => false,"plugin"=>false)); ?>", {
	width: 250,
	selectFirst: true,
	valueSelected:true,
	showNoId:true,
	loadId : 'tariff_standard_name3,insurance_type_id3',
	onItemSelect:function( ) {
		var payerID = $('#insurance_type_id3').val();//code_type
		var URL = "<?php echo $this->Html->url(array('controller' => 'patients', 'action' => 'tariffPayerId','admin' => false,'plugin'=>false)); ?>";
		$.ajax({
		type: "GET",
		url: URL+"/"+payerID,
		success : function ( data ){
		var tariffStandardData = jQuery.parseJSON(data);
		console.log(data);
		$('#payer_id3').val(tariffStandardData.TariffStandard.payer_id);
		$('#insurance_number3').val(tariffStandardData.TariffStandard.HealthplanDetailID);	
		}
		});
		}
});		
$('#tariff_standard_name3').keydown(function(){
$("#insurance_type_id3").val('');	 
}); 	 
   
 /*$("#tariff_standard_name").autocomplete("<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "testcomplete","TariffStandard","id","name",'null',"admin" => false,"plugin"=>false)); ?>", {
		width: 250,
		selectFirst: true,
		valueSelected:true,
		showNoId:true,
		loadId : 'tariff_standard_name,insurance_type_id'
	});		
$('#tariff_standard_name').keydown(function(){
$("#insurance_type_id").val('');	 
}); 	
$("#tariff_standard_name2").autocomplete("<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "testcomplete","TariffStandard","id","name",'null',"admin" => false,"plugin"=>false)); ?>", {
width: 250,
selectFirst: true,
valueSelected:true,
showNoId:true,
loadId : 'tariff_standard_name2,insurance_type_id2'
});		
$('#tariff_standard_name2').keydown(function(){
$("#insurance_type_id2").val('');	 
}); 	
$("#tariff_standard_name3").autocomplete("<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "testcomplete","TariffStandard","id","name",'null',"admin" => false,"plugin"=>false)); ?>", {
width: 250,
selectFirst: true,
valueSelected:true,
showNoId:true,
loadId : 'tariff_standard_name3,insurance_type_id3'
});		
$('#tariff_standard_name3').keydown(function(){
$("#insurance_type_id3").val('');	 
}); 
$("#insurance_name").autocomplete("<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "testcomplete","InsuranceCompany","HealthplanDetailID","name","Status=".'A',"admin" => false,"plugin"=>false)); ?>", {
width: 250,
selectFirst: true,
valueSelected:true,
showNoId:true,
loadId : 'insurance_name,insurance_number'
});		
$('#insurance_name').keydown(function(){
$("#insurance_number").val('');	 
});	
$("#insurance_name2").autocomplete("<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "testcomplete","InsuranceCompany","HealthplanDetailID","name","Status=".'A',"admin" => false,"plugin"=>false)); ?>", {
width: 250,
selectFirst: true,
valueSelected:true,
showNoId:true,
loadId : 'insurance_name2,insurance_number2'
});		
$('#insurance_name2').keydown(function(){
$("#insurance_number2").val('');	 
});	
$("#insurance_name3").autocomplete("<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "testcomplete","InsuranceCompany","HealthplanDetailID","name","Status=".'A',"admin" => false,"plugin"=>false)); ?>", {
width: 250,
selectFirst: true,
valueSelected:true,
showNoId:true,
loadId : 'insurance_name3,insurance_number3'
});		
$('#insurance_name3').keydown(function(){
$("#insurance_number3").val('');	 
});	*/
});
    $('#gau_home_phone , #gau_mobile,#gau_home_phone2 , #gau_mobile2,#gau_home_phone3 , #gau_mobile3' ).focus(function(){
       	 usPhonenumber('gau_home_phone');
      	 usPhonenumber('gau_mobile');
      	 usPhonenumber('gau_home_phone2');
      	 usPhonenumber('gau_mobile2');
      	 usPhonenumber('gau_home_phone3');
      	 usPhonenumber('gau_mobile3');
      	});

    $("#gau_ssn").focusout(function(){ 
		res2=$("#gau_ssn").val();
		count2=($("#gau_ssn").val()).length;
		str21=res2.substring(0, 3);
		str22=res2.substring(3, 5);
		str23=res2.substring(5, 9);
		if(count2=='9'){
			$("#gau_ssn").val(str21+'-'+str22+'-'+str23);
		}
		if(count2=='0'){
			$('#gau_ssn').val("");
		}
	});

    $("#gau_ssn1").focusout(function(){ 
		res2=$("#gau_ssn1").val();
		count2=($("#gau_ssn1").val()).length;
		str21=res2.substring(0, 3);
		str22=res2.substring(3, 5);
		str23=res2.substring(5, 9);
		if(count2=='9'){
			$("#gau_ssn1").val(str21+'-'+str22+'-'+str23);
		}
		if(count2=='0'){
			$('#gau_ssn1').val("");
		}
	});
	$("#gau_ssn2").focusout(function(){ 
		res2=$("#gau_ssn2").val();
		count2=($("#gau_ssn2").val()).length;
		str21=res2.substring(0, 3);
		str22=res2.substring(3, 5);
		str23=res2.substring(5, 9);
		if(count2=='9'){
			$("#gau_ssn2").val(str21+'-'+str22+'-'+str23);
		}
		if(count2=='0'){
			$('#gau_ssn2').val("");
		}
	});

</script>
    