<?php 
//echo $this->Html->script(array(/*'jquery-1.5.1.min',*/'validationEngine.jquery','ui.datetimepicker.3.js',
	//	'jquery.validationEngine','/js/languages/jquery.validationEngine-en','jquery.custom.js?ver=1.0','jquery-ui-1.10.2.js'));?>
<?php  //echo $this->Html->css(array('jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css',
		//'home-slider.css'));?>
<?php echo $this->Html->script(array(/*'jquery.autocomplete',*/'jquery.signaturepad.min'));
echo $this->Html->css(array('jquery.signaturepad'));?>

<style type="text/css">

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
#tabs-1 .formFull .tdLabel {
    float: left;
    width: 266px !important;
}
#tabs-2 .formFull .tdLabel {
    float: left;
    width: 266px !important;
}
#tabs-3 .formFull .tdLabel {
    float: left;
    width: 266px !important;
}
.pad_bg{ background:#f5f5f5 repeat-x; border:1px solid #000;}
.ui-tabs-anchor {
    color: #fff !important;
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
/*$(document).ready(function(){
	//var tabNumber = "<?php echo $checkTab?>";
	
var tabNumber = 0;
var tabArray = new Array();
tabArray = [0,1,2];

  $(function() { 
    $( "#tabs" ).tabs({ active: tabNumber });  
    //tabArray.splice( $.inArray(tabNumber, tabArray), 2 );
    var newTabArray = tabArray;
     newTabArray.remove(tabNumber);
   $("#tabs").tabs({ disabled: newTabArray});
  });

   $('.Sec_tri_link').click(function(){	
	   var newTabArray = tabArray;
	   if( tabNumber == 0 ){
		   tabNumber = 1;
	   }else if( tabNumber == 1 ){
		   tabNumber = 2;
	   }else{
		   tabNumber = 0;
	   }	
	 //  alert(tabNumber);
	   $("#tabs").tabs({ active: tabNumber });
	   newTabArray.remove(tabNumber);	
	//   alert(newTabArray);	  
	   $("#tabs").tabs({ disabled: newTabArray});
  });   
});*/
    </script>
<div id="flashMessage"></div>
<div class="inner_title">
	<h3>
		<?php echo __('Manage Patient Insurance'); ?>
	</h3>
	<span align="right"> <?php 	
	echo $this->Html->link(__('Back', true),array('controller' => 'patients', 'action' => 'insuranceindex',$patient_id,'?'=>array('flagBack'=>'1')), array('escape' => false,'class'=>'blueBtn'));
	?>
	</span>
</div>

<div id='verifymsg'
	style="display: none; font-weight: bold; text-align: center; background-color: #394145; color: #78D83E; height: 21px; padding-top: 10px;">
	<strong></strong>
</div>
<?php echo $this->element('patient_information');?>
<?php  echo $this->Form->create('NewInsurance',array('url'=>array('controller'=>'patients','action'=>'addInsurance',$patient_id),'id'=>'newinsurance','enctype' => 'multipart/form-data','div'=>false));?>
<table>
<!-- Insurance type - Mahalaxmi  -->
		 	<tr>
						<div width="5%" class="tdLabel" id="boxSpace" colspan="1"
							style="float: left; width: 118px !important;font-size: 15px; padding-top:0px!important;">
							<?php echo __('Payor Details ');?>
							
						</div>
						<div width="16%"
							style="border: 1px dotted #000000; color: #000; font-size: 15px;"
							colspan="7">
							<?php  

							$paymentCategory = array('Insurance'=>'Insurance');
							$attributes=array('default'=>'Insurance','class' => 'InsurancePaymentType InsurancePaymentTypeCls','legend'=>false, 'label'=> false, 'div' => false, 'error' => false);
							echo $this->Form->radio('Person.payment_category',$paymentCategory,$attributes);

							echo $this->Form->input('payment_category1', array('type'=>'checkbox','class' => 'InsurancePaymentType payment_categoryCls','id'=>'payment_category_selfpay','value'=>'cash','hiddenField'=>false,'legend'=>false, 'div' => false,'label'=>false));echo __('Self Pay');
							echo $this->Form->input('payment_category2', array('type'=>'checkbox','class' => 'InsurancePaymentType payment_categoryCls','id'=>'payment_category_indigent','value'=>'Indigent','hiddenField'=>false,'legend'=>false, 'div' => false,'label'=>false));echo __('Indigent');
							echo $this->Form->hidden('person_id',array('id'=>'person_id','value'=>$getpersonId));
							//echo $this->Form->radio('Encounter.frame_replace_Loss_or_theft',$options,$attributes);
							/*$paymentCategory = array('cash'=>'Self Pay','Insurance'=>'Insurance');
							 echo $this->Form->input('payment_category', array('empty'=>__('Please Select'),'options'=>$paymentCategory,'autocomplete'=>'off','class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'paymentType','onchange'=> $this->Js->request(array('action' => 'getPaymentType'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
	    								'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeCreditTypeList', 'data' => '{paymentType:$("#paymentType").val()}', 'dataExpression' => true, 'div'=>false))));
	                    */   		?>
						</div>
						<td width="12%" class="tdLabel" id="boxSpace"></td>
						<td width="30%"></td>
					</tr>
	<!-- end insurance type -->
			</table>
<div id="tabs" class="container" style="padding-top: 10px;">
	<ul class="tabs">
		<li class="tab-link bg_color" data-tab="tab-1"><a href="#tabs-1"><?php echo __('Primary Insurance ');?>
		</a>
		</li>
		<li class="tab-link bg_color" data-tab="tab-2"><a href="#tabs-2"><?php echo __('Secondary Insurance ');?>
		</a>
		</li>
		<li class="tab-link bg_color" data-tab="tab-3"><a href="#tabs-3"><?php echo __('Tertiary Insurance ');?>
		</a>
		</li>
	</ul>
	
	<?php //echo $this->Form->input('id',array('type'=>'hidden'));?>
	<?php echo $this->Form->input('uploadedImageName',array('type'=>'hidden'));
 			echo $this->Form->hidden('web_cam',array('id'=>'web_cam'));	?>
	<?php echo $this->Form->hidden('NewInsurance.location_id', array('label'=>false,'value'=>$this->Session->read('locationid'),'id' => 'location_id')); ?>
	<?php echo $this->Form->hidden('NewInsurance.patient_uid', array('label'=>false,'value'=>$getPatientUid,'id' => 'patient_uid')); ?>
	<?php  echo $this->Form->hidden('NewInsurance.patient_id', array('label'=>false,'value'=>$patient_id,'id' => 'patient_id')); ?>
	<div id="tabs-1" style="padding-top: 5px;" class="tab-content current">
		<table width="100%" border="0" cellspacing="0" cellpadding="0"
			class="formFull">
			<tr>
				<td class="tdLabel" id="boxSpace"><?php echo __('Payor Name');?><font
					color="red">*</font>
				</td>
				<td width="28%"><?php 
				echo $this->Form->input('NewInsurance.tariff_standard_name', array('label'=>false,'id' => 'tariff_standard_name','autocomplete'=> 'off','class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd text_bag'));
				echo $this->Form->hidden('NewInsurance.tariff_standard_id',array('id'=>'insurance_type_id'));
				echo $this->Form->hidden('NewInsurance.insurance_name',array('id'=>'insurance_name'));
									echo $this->Form->hidden('NewInsurance.payer_id',array('id'=>'payer_id'));
									echo $this->Form->hidden('NewInsurance.insurance_number',array('id'=>'insurance_number')); ?>
				</td>
				<td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Policy #/Insured ID');?><font
									color="red">*</font>
				</td>
				<td width="16%"><?php echo $this->Form->input('NewInsurance.policy_no', array('label'=>false,'id' => 'policy_no','class'=> 'validate[required,custom[mandatory-enter]] textBoxExpnd','div'=>false)); ?>
				<input type="radio" name="NewInsurance[policy_type]"
					value="MI" style="display: none;"><?php //echo __('Member ID');  ?><br> <input type="radio"
					name="NewInsurance[policy_type]" value="ZZ" checked='checked' style="display: none;"><?php //echo __('Unique');  ?>
					<?php //echo __('Health ID'); ?></td>

			</tr>
			<tr>
				<td class="tdLabel" id="boxSpace"><?php echo __('Responsibility');?><font
									color="red">*</font>
				</td>
				<td><?php echo __('Primary'); ?> <?php echo $this->Form->input('NewInsurance.priority',array('type'=>'hidden','value'=>'P')) ?>
				</td>

				<td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Effective from');?>
				</td>

				<td width="26%"><?php echo $this->Form->input('NewInsurance.effective_date', array('label'=>false,'type'=>'text','class' => 'textBoxExpnd efdate','id' => 'efdate','readonly'=>'readonly')); ?>
				</td>
			</tr>
			<!-- <tr>
				<td width="21%" class="tdLabel" id="boxSpace"><?php echo __('Insurance Name');?>
				</td>
				<td width="28%"><?php echo $this->Form->input('NewInsurance.insurance_name', array('label'=>false,'id' => 'insurance_name','autocomplete'=> 'off','class' => 'validate["",custom[mandatory-enter]] textBoxExpnd','div'=>false)); ?>
				</td>
				<td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Insurance ID');?>
				</td>
				<td width="26%"><?php echo $this->Form->input('NewInsurance.insurance_number', array('label'=>false,'id' => 'insurance_number','class'=> 'textBoxExpnd','div'=>false)); ?>
				</td>
			</tr> -->
			<tr>
				<td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Group Name')?>
				</td>
				<td width="20%"><?php echo $this->Form->input('NewInsurance.group_name', array('label'=>false,'id' => 'group_name','class'=> 'textBoxExpnd','div'=>false)); ?>
				</td>

				<td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Group ID')?>
				</td>
				<td width="26%"><?php echo $this->Form->input('NewInsurance.group_number', array( 'id' =>'group_number', 'class'=> 'textBoxExpnd','label'=>false, 'div' => false, 'error' => false)); ?>
				</td>
			</tr>
			<tr>
				<td width="19%" id="boxSpace" class="tdLabel">Co pay type<font
					color="red">*</font>
				</td>
				<td width="20%"><?php echo $this->Form->input('NewInsurance.copay_type', array('label'=>false,'empty'=>__("Select"),'options'=>array('Fixed','Percentage'),'id' => 'copay_type','class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','onchange'=>'javascript:getPercentage()')); ?>
				</td>

				<td width="19%" class="tdLabel" id="boxSpace">Relation to insured</td>
				<td width="26%"><?php //Configure::read('relationship_with_insured')
				echo $this->Form->input('NewInsurance.relation', array( 'id' =>'relation','empty'=>'Select', 'options'=>array('self'=>'Self','spouse'=>'Spouse','child'=>'Child','other'=>'Other','D'=>'Unspecified Dependent'), 'class'=> 'textBoxExpnd','label'=>false, 'div' => false, 'error' => false)); ?>
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
				<td><?php echo $this->Form->input('NewInsurance.fixed_percentage', array('type'=>'text','label'=>false,'class' => 'validate[required,custom[name],custom[onlyNumberSp]] textBoxExpnd fixed_percent','placeholder'=>'Enter Percentage(ex:30%)','id' => 'fixed_percentage'));
				echo $this->Form->input('NewInsurance.fixed_amt', array('type'=>'text','label'=>false,'class' => 'validate[required,custom[name],custom[onlyNumberSp]] textBoxExpnd','placeholder'=>'Enter Amount(ex:$300)','id' => 'fixed_amt')); ?>
				</td>
			</tr>
			<!-- <tr>
				<td width="19%" class="tdLabel" id="boxSpace"><?php //echo __('Is Active');?></td>
				<td width="26%"> --><?php echo $this->Form->checkbox('NewInsurance.is_active', array('label'=>false,'id' => 'is_active','value'=>'0','style'=>'display:none;')); ?>
				<!--</td>
				<td width="19%" class="tdLabel" id="boxSpace"><?php //echo __('Is Person');?>
				</td>
				<td width="16%"> --><input type="radio" name="NewInsurance[is_person]"
					value="Yes" checked="checked" style="display:none;"><?php //echo __('Yes');?> <input type="radio"
					name="NewInsurance[is_person]" value="No" style="display:none;"><?php //echo __('No');?><!--</td>
			</tr>-->
			<tr>
				<td width="19%" class="tdLabel" id="boxSpace">Upload Insurance Card</td>
				<td width="19%"><?php echo $this->Form->input('NewInsurance.upload_card', array('type'=>'file','id' => 'patient_photo1', 'class'=>"textBoxExpnd",'label'=> false,'div' => false, 'error' => false)); ?>
			
				<?php echo $this->Html->image('/img/icons/webcam.png',array('id'=>'camera','title'=>'Capture photo from webcam'));?>
					<canvas width="320" height="240" id="parent_canvas"
						style="display: none;"></canvas>
				</td>
				<td width="19%" class="tdLabel" id="boxSpace">Back of Card</td>
				<td width="19%"><?php 
					echo $this->Form->input('NewInsurance.back_of_card', array('type'=>'file','id' => 'back_of_card', 'class'=>"textBoxExpnd",'label'=> false,'div' => false, 'error' => false)); ?>
									<?php echo $this->Html->image('/img/icons/webcam.png',array('id'=>'camera_card','title'=>'Capture photo from webcam'));?>
									<canvas width="320" height="240" id="parent_canvas_card" style="display: none;"></canvas>
				</td>
			</tr>

			<!-- <tr>
				<td width="19%" id="boxSpace" class="tdLabel">Claim Officer<font
					color="red">*</font>
				</td>
				<td><?php echo $this->Form->input('NewInsurance.claim_officer', array('type'=>'text','class'=>"textBoxExpnd validate[required,custom[mandatory-enter]]",'label'=>false)); ?>
				</td>

				<td width="19%" class="tdLabel" id="boxSpace">Patient Student Status</td>
				<td width="26%"><table width="100%" cellpadding="0" cellspacing="0"
						border="0">
						<tr>
							<td><?php echo $this->Form->input('NewInsurance.patient_stuent_status', array('type'=>'text', 'class'=>"textBoxExpnd",'label'=>false)); ?>
							</td>
						</tr>
					</table></td>
			</tr> -->
			<tr>
				<td id="boxSpace" class="tdLabel" colspan="4">
								<?php echo $this->Form->checkbox('NewInsurance.verify', array('label'=>false,'id' => 'is_active')); ?>
										<?php echo __("Verified");?>
										<?php echo $this->Form->checkbox('NewInsurance.is_assign', array('label'=>false,'id' => 'is_active')); ?>
										<?php echo __("Accept Assign");?>
										<?php echo $this->Form->checkbox('NewInsurance.is_eob', array('label'=>false,'id' => 'is_active')); ?>
										<?php echo __("EOB");?>
				</td>
				</tr>
				<tr>
				<td id="boxSpace" class="tdLabel" colspan="4" style="float:none;"><?php echo $this->Form->checkbox('NewInsurance.pri_is_authorized', array('label'=>false,'id' => 'pri_is_authorized','value'=>'Y')); ?>
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
				<td width="43%"><?php echo $this->Form->input('NewInsurance.employer', array('label'=>false,'div'=>false,'id' => 'employer','class'=> 'textBoxExpnd')); ?>
				</td>
		
				<td width="21%" class="tdLabel">City</td>
				<td width="30%" valign="top"><?php echo $this->Form->input('NewInsurance.emp_city', array('label'=>false,'id' => 'city','class'=>'textBoxExpnd')); ?>
				</td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Address</td>
				<td width="30%"><?php echo $this->Form->input('NewInsurance.emp_address', array('label'=>false,'id' => 'emp_address','class'=>'textBoxExpnd')); ?>
				</td>
				<td width="21%" class="tdLabel">State</td>
				<td width="30%"><!-- id="emp_state"--><?php  //$states = ''; 
				echo $this->Form->input('NewInsurance.emp_state', array('options' => $state,'empty' =>'Please Select State', 'id' => 'emp_state', 'selected'=>'84', 'label'=> false, 'div' => false, 'error' => false,'class' => 'textBoxExpnd'));?>
				</td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Note</td>
				<td width="30%"><?php echo $this->Form->input('NewInsurance.note', array('label'=>false,'id' => 'note','class'=> 'textBoxExpnd')); ?>
				</td>
				<td width="21%" class="tdLabel">Country</td>
				<td width="40%"><?php 
				//echo $this->Form->input('NewInsurance.emp_country', array('options' => array('USA'=>'USA'), 'id' => 'emp_country', 'label'=> false, 'div' => false, 'error' => false,'onchange'=> $this->Js->request(array('controller'=>'persons','action' => 'get_state_city','reference'=>'State','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#emp_state', 'data' => '{reference_id:$("#emp_country").val()}', 'dataExpression' => true, 'div'=>false)),'class' => 'validate[,custom[mandatory-select]] textBoxExpnd'));
				echo $this->Form->input('NewInsurance.emp_country', array('options' => $countries,'selected'=>'2', 'id' => 'emp_country', 'label'=> false, 'div' => false, 'error' => false,'class' => 'textBoxExpnd'));
				?></td>				
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Zip Code</td>
				<td width=""><?php echo $this->Form->input('NewInsurance.emp_zip_code', array('type'=>'text','label'=>false,'id' => 'zip_codeote3','class'=>'textBoxExpnd','Maxlength'=>5)); ?>
				</td>
			</tr>
			<!-- <tr>
				<td width="21%" class="tdLabel">SSN</td>
				<td width=""><?php echo $this->Form->input('NewInsurance.emp_ssn', array('label'=>false,'id' => 'emp_ssn','class'=>'textBoxExpnd','Maxlength'=>5)); ?>
				</td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Phone</td>
				<td width=""><?php echo $this->Form->input('NewInsurance.emp_phone', array('label'=>false,'id' => 'emp_ssn','class'=>'textBoxExpnd','Maxlength'=>5)); ?>
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
				<td width="28%"><?php echo $this->Form->input('NewInsurance.subscriber_name', array('id'=>'subscriber_name','label'=>false,'class'=> '','style'=>'width:143px','div'=>false)); ?>
					<?php  echo $this->Form->input('NewInsurance.subscriber_initial', array('id'=>'gau_middle_name','label'=>false,'style'=>'width:72px','div'=>false)); ?>
				</td>
					<td width="24%" class="tdLabel">Subscriber Last Name</td>
				<td width="20%"><?php echo $this->Form->input('NewInsurance.subscriber_last_name', array('id'=>'gau_last_name','label'=>false,'class'=>'textBoxExpnd')); ?>
				</td>

			</tr>
			<tr>
				<td width="21%" class="tdLabel">Date of Birth</td>
				<td width="250"><?php echo $this->Form->input('NewInsurance.subscriber_dob',array('id'=>'dobg','class'=>'textBoxExpnd','type'=>'text','autocomplete'=>"off",'legend'=>false,'div'=>false,'label'=>false,'readonly'=>'readonly'));?>
				</td>
				<td width="21%" class="tdLabel">Gender</td>
				<td width="27%"><?php echo $this->Form->input('NewInsurance.subscriber_gender', array('id'=>'gau_sex','empty'=>__("Select"),'options' => array('Male'=>__('Male'),'Female'=>__('Female'),'Ambiguous'=>__('Ambiguous'),'Not applicable'=>__('Not applicable'),'Unknown'=>__('Unknown'),'Other'=>__('Other')), 'default' => '','label'=>false,'div'=>false,'class'=>'textBoxExpnd'));?>
				</td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Social Security Number
				</td>
				<td width="27%"><?php echo $this->Form->input('NewInsurance.subscriber_security', array('id'=>'gau_ssn','maxLength'=>'9','label'=>false,'class'=>'textBoxExpnd ')); ?>
				</td>
				<td width="21%" class="tdLabel">Address1</td>
				<td width="20%"><?php echo $this->Form->input('NewInsurance.subscriber_address1', array('id'=>'gau_plot_no','label'=>false,'class'=>'textBoxExpnd')); ?>
				</td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Address2</td>
				<td width="20%"><?php echo $this->Form->input('NewInsurance.subscriber_address2', array('id'=>'gau_landmark','label'=>false,'class'=>'textBoxExpnd')); ?>
				</td>
				<td width="21%" class="tdLabel">City</td>
				<td width="20%"><?php echo $this->Form->input('NewInsurance.subscriber_city', array('id'=>'city','label'=>false, 'class'=> 'textBoxExpnd','div'=>false)); ?>
				</td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">State</td>
				<td width="20%" ><!--id="customstate1"--><?php ///$state ='';
								echo $this->Form->input('NewInsurance.subscriber_state', array('id'=>'customstate1','options' => $state, 'selected'=>'84', 'empty' => 'Please Select State', 'label'=> false, 'div' => false, 'error' => false,'class'=> 'textBoxExpnd')); ?>
				</td>
				<td width="21%" class="tdLabel">Country</td>
				<td width="200px"><?php //echo $this->Form->input('NewInsurance.subscriber_country', array('options' => $countries, 'empty' => 'Select Country', 'id' => 'customcountry1', 'label'=> false, 'div' => false, 'error' => false, 'class'=>'textBoxExpnd','onchange'=> $this->Js->request(array('controller'=>'persons','action' => 'get_state_city','reference'=>'State','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#customstate1', 'data' => '{reference_id:$("#customcountry1").val()}', 'dataExpression' => true, 'div'=>false))));
				echo $this->Form->input('NewInsurance.subscriber_country', array('options' =>$countries,'selected'=>'2', 'id' => 'customcountry1', 'label'=> false, 'div' => false, 'error' => false, 'class'=>'textBoxExpnd')); ?>
				</td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Zip Code</td>
				<td width="20%"><?php echo $this->Form->input('NewInsurance.subscriber_zip', array('id'=>'subscriber_zip','label'=>false, 'class'=> 'textBoxExpnd','Maxlength'=>5)); ?>
				</td>
				<td width="21%" class="tdLabel">Primary Phone</td>
				<td width="20%"><?php echo $this->Form->input('NewInsurance.subscriber_primary_phone', array('type'=>'text','id'=>'gau_home_phone','label'=>false, 'class'=> 'textBoxExpnd','div'=>false,'maxLength'=>'14')); ?>
				</td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Secondary Phone</td>
				<td width="20%"><?php echo $this->Form->input('NewInsurance.subscriber_secondary_phone', array('type'=>'text','id'=>'gau_mobile','label'=>false,'class'=> 'textBoxExpnd','div'=>false,'maxLength'=>'14')); ?>
				</td>
			</tr>
			  <tr>
                                <!--<td width="50%" id="boxSpace">
                                  <table>-->
                                     <td width="19%" id="boxSpace" class="tdLabel"><?php echo __('Signature'); ?></td>

                                      <td width="20%"><?php //echo $this->Form->input('NewInsurance.sign', array('type' =>'text', 'id' => 'signature','style'=>'visibility:hidden','label'=>false,'legend'=>false)); ?>

								<div class="sigPad">
									<ul class="sigNav">
										<li class="drawIt"><a href="#draw-it"><font color="#000000">Draw
																		It
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
								</div>
							</td>
							  
                            <td class="tdLabel" id="boxSpace" style="text-align:left;"><?php //echo __('Reffering Doctor'); ?></td>
                             
                            <td valign="top">
                             <table cellpadding="0" cellspacing="0" width="100%">
                              <tr>
                            <td>
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td><?php //echo $this->Form->input('NewInsurance.refer_doctor', array('type'=>'text', 'class'=>'textBoxExpnd', 'label'=>false,'value'=>$getDataForEdit['0']['NewInsurance']['refer_doctor'])); ?>
							</td>
						</tr>
					</table>
                    </td>
                            </tr>
                            </table>
                            </td>
                                  <!--</table>
                               </td>-->
               	</tr>
		</table>
		<div align="right" style="margin-top:5px;">
			<?php 
			echo $this->Form->hidden('NewInsurance.refference_id',array());?>
			<?php echo $this->Form->submit(__('Submit Primary'), array('escape' => false,'class'=>'blueBtn','id'=>'submitSingle','div'=>false));
			echo $this->Form->hidden('NewInsurance.Forsingle', array('label'=>false,'value'=>'1','id' => 'Forsingle','div'=>false));
			//echo "&nbsp;&nbsp;".$this->Form->submit(__('Add Secondary Insurance'), array('type'=>'button','escape' => false,'class'=>'blueBtn Sec_tri_link','div'=>false));			
			//echo $this->Html->link(__('Back', true),array('controller' => 'patients', 'action' => 'addInsurance',$patient_id,null,'1'), array('escape' => false,'class'=>'blueBtn','id'=>'sec_link'));
			?>
			<?php echo $this->Form->end();?>
		</div>
	</div>
	<?php  echo $this->Form->create('NewInsurance2',array('url'=>array('controller'=>'patients','action'=>'addInsurance',$patient_id),'id'=>'newinsurance1','enctype' => 'multipart/form-data','div'=>false));?>
	<?php //echo $this->Form->input('id',array('type'=>'hidden'));?>
	<?php echo $this->Form->input('uploadedImageName',array('type'=>'hidden'));
 	echo $this->Form->hidden('web_cam',array('id'=>'web_cam'));	?>
	<?php echo $this->Form->hidden('NewInsurance.location_id', array('label'=>false,'value'=>$this->Session->read('locationid'),'id' => 'location_id')); ?>
	<?php echo $this->Form->hidden('NewInsurance.patient_uid', array('label'=>false,'value'=>$getPatientUid,'id' => 'patient_uid')); ?>
	<?php  echo $this->Form->hidden('NewInsurance.patient_id', array('label'=>false,'value'=>$patient_id,'id' => 'patient_id')); 
	echo $this->Form->hidden('person_id',array('id'=>'person_id','value'=>$getpersonId));?>
	<div id="tabs-2" class="tab-content" style="padding-top: 5px;">
		<table width="100%" border="0" cellspacing="0" cellpadding="0"
			class="formFull">
			<?php echo $this->Form->hidden('check',array('value'=>'Second_check'));?>
			<tr>
				<td width="21%" class="tdLabel" id="boxSpace"><?php echo __('Payor Name');?><font
					color="red">*</font>
				</td>
				<!-- <td width="28%"><?php echo $this->Form->input('NewInsurance.tariff_standard_id', array('label'=>false,'empty'=>__('Select'),'options'=>$getDataInsuranceType
						,'id' => 'insurance_type_id2','autocomplete'=> 'off','class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd')); ?>
				</td> -->
					<?php //echo $this->Form->hidden('NewInsurance.tariff_standard_name',array('id'=>'tariff_standard_name2'));?>
				<td width="28%"><?php echo $this->Form->input('NewInsurance.tariff_standard_name', array('label'=>false,'id' => 'tariff_standard_name2','autocomplete'=> 'off','class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd'));
				echo $this->Form->hidden('NewInsurance.tariff_standard_id',array('id'=>'insurance_type_id2'));//echo $this->Form->input('NewInsurance.tariff_standard_name', array('label'=>false,'id' => 'tariff_standard_name2','autocomplete'=> 'off','class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd')); ?>
			
				<?php //echo $this->Form->hidden('NewInsurance.tariff_standard_id',array('id'=>'insurance_type_id2'));
				echo $this->Form->hidden('NewInsurance.insurance_name',array('id'=>'insurance_name2'));
									echo $this->Form->hidden('NewInsurance.payer_id',array('id'=>'payer_id2'));
									echo $this->Form->hidden('NewInsurance.insurance_number',array('id'=>'insurance_number2')); ?>
				</td>
				<td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Policy #/Insured ID');?><font
									color="red">*</font>
				</td>
				<td width="16%"><?php echo $this->Form->input('NewInsurance.policy_no', array('label'=>false,'id' => 'policy_no2','class'=> 'validate[required,custom[mandatory-enter]] textBoxExpnd','div'=>false)); ?>
				<input type="radio" name="NewInsurance[policy_type]"
					value="MI" style="display: none;"><?php //echo __('Member ID');  ?><br> <input type="radio"
					name="NewInsurance[policy_type]" value="ZZ" checked='checked' style="display: none;"><?php //echo __('Unique');  ?>
					<?php //echo __('Health ID'); ?></td>

			</tr>
			<tr>
				<td class="tdLabel" id="boxSpace">Responsibility<font color="red">*</font>
				</td>
				<td><?php echo __('Secondary'); ?> <?php echo $this->Form->input('NewInsurance.priority',array('type'=>'hidden','value'=>'S')) ?>
				</td>

				<td width="19%" class="tdLabel" id="boxSpace">Effective from</td>

				<td width="26%"><?php echo $this->Form->input('NewInsurance.effective_date', array('label'=>false,'type'=>'text','class' => 'textBoxExpnd','id' => 'efdate1','readonly'=>'readonly')); ?>
				</td>
			</tr>
			<!-- <tr>
				<td width="21%" class="tdLabel" id="boxSpace"><?php echo __('Insurance Name');?>
				</td>
				<td width="28%"><?php echo $this->Form->input('NewInsurance.insurance_name', array('label'=>false,'id' => 'insurance_name2','autocomplete'=> 'off','class' => 'validate["",custom[mandatory-select]] textBoxExpnd')); ?>
				</td>
				<td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Insurance ID');?>
				</td>
				<td width="26%"><?php echo $this->Form->input('NewInsurance.insurance_number', array('label'=>false,'id' => 'insurance_number2','class'=> 'textBoxExpnd','div'=>false)); ?>
				</td>
			</tr> -->
			<tr>
				<td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Group Name')?>
				</td>
				<td width="20%"><?php echo $this->Form->input('NewInsurance.group_name', array('label'=>false,'id' => 'group_name','class'=> 'textBoxExpnd','div'=>false)); ?>
				</td>

				<td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Group ID')?>
				</td>
				<td width="26%"><?php echo $this->Form->input('NewInsurance.group_number', array( 'id' =>'group_number', 'class'=> 'textBoxExpnd','label'=>false, 'div' => false, 'error' => false)); ?>
				</td>
			</tr>
			<tr>
				<td width="19%" id="boxSpace" class="tdLabel">Co pay type<font
					color="red">*</font>
				</td>
				<td width="20%"><?php echo $this->Form->input('NewInsurance.copay_type', array('label'=>false,'empty'=>__("Select"),'options'=>array('Fixed','Percentage'),'id' => 'copay_type2','class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','onchange'=>'javascript:getPercentage()')); ?>
				</td>

				<td width="19%" class="tdLabel" id="boxSpace">Relation to insured</td>
				<td width="26%"><?php echo $this->Form->input('NewInsurance.relation', array( 'id' =>'relation','empty'=>'Select', 'options'=>array('self'=>'Self','spouse'=>'Spouse','child'=>'Child','other'=>'Other','D'=>'Unspecified Dependent'), 'class'=> 'textBoxExpnd','label'=>false, 'div' => false, 'error' => false)); ?>
				</td>
			</tr>
			<tr>
				<td valign="middle" class="tdLabel" id="boxSpace"></td>
				<td><div id='showcopay2' style='display:none';> <?php echo $this->Form->input('NewInsurance.fixed_percentage', array('type'=>'text','label'=>false,'class' => 'validate[required,custom[name],custom[onlyNumberSp]] textBoxExpnd fixed_percent','placeholder'=>'Enter Percentage(ex:30%)','id' => 'fixed_percentage2'));
				echo $this->Form->input('NewInsurance.fixed_amt', array('type'=>'text','label'=>false,'class' => 'validate[required,custom[name],custom[onlyNumberSp]] textBoxExpnd','placeholder'=>'Enter Amount(ex:$300)','id' => 'fixed_amt2')); ?>
				</div></td>
			</tr>
			<!-- <tr>
				<td width="19%" class="tdLabel" id="boxSpace"><?php //echo__('Active');?></td>
				<td width="26%"> --><?php echo $this->Form->checkbox('NewInsurance.is_active', array('label'=>false,'id' => 'is_active','value'=>'0','style'=>'display:none;')); ?>
			<!-- 	</td>
				<td width="19%" class="tdLabel" id="boxSpace"><?php //echo __('Is Person');?>
				</td>
				<td width="16%"> --><input type="radio" name="NewInsurance[is_person]"
					value="Yes" checked="checked" style="display:none;"><?php //echo __('Yes');?> <input type="radio"
					name="NewInsurance[is_person]" value="No" style="display:none;"><?php //echo __('No');?><!-- </td>
			</tr>-->
			<tr>
				<td width="19%" class="tdLabel" id="boxSpace">Upload Insurance Card</td>
				<td width="19%"><?php echo $this->Form->input('NewInsurance.upload_card', array('type'=>'file','id' => 'patient_photo2', 'class'=>"textBoxExpnd",'label'=> false,'div' => false, 'error' => false)); ?>
				<?php echo $this->Html->image('/img/icons/webcam.png',array('id'=>'camera','title'=>'Capture photo from webcam'));?>
					<canvas width="320" height="240" id="parent_canvas"
						style="display: none;"></canvas>
				</td>
				<td width="19%" class="tdLabel" id="boxSpace">Back of Card</td>
				<td width="19%"><?php 
					echo $this->Form->input('NewInsurance.back_of_card', array('type'=>'file','id' => 'back_of_card', 'class'=>"textBoxExpnd",'label'=> false,'div' => false, 'error' => false)); ?>
									<?php echo $this->Html->image('/img/icons/webcam.png',array('id'=>'camera_card','title'=>'Capture photo from webcam'));?>
									<canvas width="320" height="240" id="parent_canvas_card" style="display: none;"></canvas>
				</td>
			</tr>

			<!-- <tr>
				<td width="19%" id="boxSpace" class="tdLabel">Claim Officer<font color="red">*</font>
				</td>
				<td><?php echo $this->Form->input('NewInsurance.claim_officer', array('type'=>'text','class'=>"textBoxExpnd validate[required,custom[mandatory-enter]]",'label'=>false)); ?>
				</td>
				<td width="19%" class="tdLabel" id="boxSpace">Patient Student Status</td>
				<td width="26%"><?php echo $this->Form->input('NewInsurance.patient_stuent_status', array('type'=>'text', 'class'=>"textBoxExpnd",'label'=>false)); ?>
				</td>
			</tr> -->
			<tr>
				<td id="boxSpace" class="tdLabel" colspan="4">
								<?php echo $this->Form->checkbox('NewInsurance.verify', array('label'=>false,'id' => 'is_active')); ?>
										<?php echo __("Verified");?>
										<?php echo $this->Form->checkbox('NewInsurance.is_assign', array('label'=>false,'id' => 'is_active')); ?>
										<?php echo __("Accept Assign");?>
										<?php echo $this->Form->checkbox('NewInsurance.is_eob', array('label'=>false,'id' => 'is_active')); ?>
										<?php echo __("EOB");?>
				</td>
				</tr>
				<tr>
				<td id="boxSpace" class="tdLabel" colspan="4" style="float:none;"><?php echo $this->Form->checkbox('NewInsurance.pri_is_authorized', array('label'=>false,'id' => 'pri_is_authorized','value'=>'Y')); ?>
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
				<td width="43%"><?php echo $this->Form->input('NewInsurance.employer', array('label'=>false,'div'=>false,'id' => 'employer','class'=> 'textBoxExpnd')); ?>
				</td>
				<td width="21%" class="tdLabel">City</td>
				<td width="30%" valign="top"><?php echo $this->Form->input('NewInsurance.emp_city', array('label'=>false,'id' => 'city','class'=>'textBoxExpnd')); ?>
				</td>
				
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Address</td>
				<td width="30%"><?php echo $this->Form->input('NewInsurance.emp_address', array('label'=>false,'id' => 'emp_address','class'=>'textBoxExpnd')); ?>
				</td>
				<td width="21%" class="tdLabel">State</td>
				<td width="30%" ><?php // $states = ''; id="emp_state2"
				echo $this->Form->input('NewInsurance.emp_state', array('options' => $state,'empty' =>'Please Select State','selected'=>'84', 'id' => 'emp_state2', 'label'=> false, 'div' => false, 'error' => false,'class' => 'textBoxExpnd'));?>
				</td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Note</td>
				<td width="30%"><?php echo $this->Form->input('NewInsurance.note', array('label'=>false,'id' => 'note','class'=> 'textBoxExpnd')); ?>
				</td>
				<td width="21%" class="tdLabel">Country</td>
				<td width="40%"><?php 
			//	echo $this->Form->input('NewInsurance.emp_country', array('options' => $countries, 'empty' => 'Select Country', 'id' => 'emp_country', 'label'=> false, 'div' => false, 'error' => false,'onchange'=> $this->Js->request(array('controller'=>'persons','action' => 'get_state_city','reference'=>'State','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#emp_state1', 'data' => '{reference_id:$("#emp_country").val()}', 'dataExpression' => true, 'div'=>false)),'class' => 'validate[,custom[mandatory-select]] textBoxExpnd'));
				echo $this->Form->input('NewInsurance.emp_country', array('options' => $countries,'selected'=>'2', 'id' => 'emp_country', 'label'=> false, 'div' => false, 'error' => false,'class' => 'textBoxExpnd'));
				?></td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Zip Code</td>
				<td width=""><?php echo $this->Form->input('NewInsurance.emp_zip_code', array('type'=>'text','label'=>false,'id' => 'zip_codeote1','class'=>'textBoxExpnd','Maxlength'=>5)); ?>
				</td>
			</tr>
			<!--  <tr>
				<td width="21%" class="tdLabel">SSN</td>
				<td width=""><?php echo $this->Form->input('NewInsurance.emp_ssn', array('label'=>false,'id' => 'emp_ssn','class'=>'textBoxExpnd','Maxlength'=>5)); ?>
				</td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Phone</td>
				<td width=""><?php echo $this->Form->input('NewInsurance.emp_phone', array('label'=>false,'id' => 'emp_ssn','class'=>'textBoxExpnd','Maxlength'=>5)); ?>
				</td>
			</tr>-->
		</table>
		<table width="100%" border="0" cellspacing="0" cellpadding="0"
			class="formFull">
			<tr>
				<th style="padding-left: 10px;" colspan="4"><?php echo __('');?> <?php echo $this->Form->input('chkclick', array('type'=>'checkbox','id' => 'ckeckGua','label'=>'Check to copy Guaranter details')); ?>
				</th>
			</tr>

			<tr>
				<td width="24%" class="tdLabel">Subscriber name</td>
				<td width="28%"><?php echo $this->Form->input('NewInsurance.subscriber_name', array('id'=>'subscriber_name','label'=>false,'class'=> '','style'=>'width:143px','div'=>false)); ?>
					<?php  echo $this->Form->input('NewInsurance.subscriber_initial', array('id'=>'gau_middle_name','label'=>false,'style'=>'width:72px','div'=>false)); ?>
				</td>
				<td width="21%" class="tdLabel">Subscriber Last name</td>
				<td width="20%"><?php echo $this->Form->input('NewInsurance.subscriber_last_name', array('id'=>'gau_last_name','label'=>false,'class'=>'textBoxExpnd')); ?>
				</td>

			</tr>
			<tr>
				<td width="21%" class="tdLabel">Date of Birth</td>
				<td width="250"><?php echo $this->Form->input('NewInsurance.subscriber_dob',array('id'=>'dobg2','class'=>'textBoxExpnd','type'=>'text','autocomplete'=>"off",'legend'=>false,'div'=>false,'label'=>false,'readonly'=>'readonly'));?>
				</td>
				<td width="21%" class="tdLabel">Gender</td>
				<td width="27%"><?php echo $this->Form->input('NewInsurance.subscriber_gender', array('id'=>'gau_sex','empty'=>__("Select"),'options' => array('Male'=>__('Male'),'Female'=>__('Female'),'Ambiguous'=>__('Ambiguous'),'Not applicable'=>__('Not applicable'),'Unknown'=>__('Unknown'),'Other'=>__('Other')), 'default' => '','label'=>false,'div'=>false,'class'=>'textBoxExpnd'));?>
				</td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Social Security Number
				</td>
				<td width="27%"><?php echo $this->Form->input('NewInsurance.subscriber_security', array('id'=>'gau_ssn1','maxLength'=>'9','label'=>false,'class'=>'textBoxExpnd ')); ?>
				</td>
				<td width="21%" class="tdLabel">Address1</td>
				<td width="20%"><?php echo $this->Form->input('NewInsurance.subscriber_address1', array('id'=>'gau_plot_no','label'=>false,'class'=>'textBoxExpnd')); ?>
				</td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Address2</td>
				<td width="20%"><?php echo $this->Form->input('NewInsurance.subscriber_address2', array('id'=>'gau_landmark','label'=>false,'class'=>'textBoxExpnd')); ?>
				</td>
				<td width="21%" class="tdLabel">Country</td>
				<td width="200px"><?php //echo $this->Form->input('NewInsurance.subscriber_country', array('options' => $countries, 'empty' => 'Select Country', 'id' => 'customcountry1sec', 'label'=> false, 'div' => false, 'error' => false, 'class'=>'textBoxExpnd','onchange'=> $this->Js->request(array('controller'=>'persons','action' => 'get_state_city','reference'=>'State','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#customstate1sec', 'data' => '{reference_id:$("#customcountry1sec").val()}', 'dataExpression' => true, 'div'=>false))));
				echo $this->Form->input('NewInsurance.subscriber_country', array('options' => $countries,'selected'=>'2', 'id' => 'customcountry1sec', 'label'=> false, 'div' => false, 'error' => false, 'class'=>'textBoxExpnd')); ?>
				</td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">State</td>
				<td width="20%" ><?php ///$state ='';id="customstate1sec"
								echo $this->Form->input('NewInsurance.subscriber_state', array('id'=>'customstate12sec','options' => $state,'selected'=>'84', 'empty' => 'Select State', 'label'=> false, 'div' => false, 'error' => false,'class'=> 'textBoxExpnd')); ?>
				</td>
				<td width="21%" class="tdLabel">City</td>
				<td width="20%"><?php echo $this->Form->input('NewInsurance.subscriber_city', array('id'=>'city','label'=>false, 'class'=> 'textBoxExpnd','div'=>false)); ?>
				</td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Zip Code</td>
				<td width="20%"><?php echo $this->Form->input('NewInsurance.subscriber_zip', array('id'=>'subscriber_zip','label'=>false, 'class'=> 'textBoxExpnd','Maxlength'=>5)); ?>
				</td>
				<td width="21%" class="tdLabel">Primary Phone</td>
				<td width="20%"><?php echo $this->Form->input('NewInsurance.subscriber_primary_phone', array('type'=>'text','id'=>'gau_home_phone2','label'=>false, 'class'=> 'textBoxExpnd','div'=>false,'maxLength'=>'14')); ?>
				</td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Secondary Phone</td>
				<td width="20%"><?php echo $this->Form->input('NewInsurance.subscriber_secondary_phone', array('type'=>'text','id'=>'gau_mobile2','label'=>false,'class'=> 'textBoxExpnd','div'=>false,'maxLength'=>'14')); ?>
				</td>
			</tr>
			<?php 
			echo $this->Form->hidden('NewInsurance.refference_id',array()); //'value'=>$lastInsertId?>
			  <tr>
                                     <td width="19%" id="boxSpace" class="tdLabel" ><?php echo __('Signature'); ?></td>

                                      <td width="20%"><?php //echo $this->Form->input('NewInsurance.sign', array('type' =>'text', 'id' => 'signature','style'=>'visibility:hidden','label'=>false,'legend'=>false)); ?>

								<div class="sigPad">
									<ul class="sigNav">
										<li class="drawIt"><a href="#draw-it"><font color="#000000">Draw
																		It
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
								</div>
							</td> 
               </tr>			
		</table>
		<div align="right">
			<?php echo $this->Form->submit(__('Submit Secondary'), array('escape' => false,'class'=>'blueBtn','id'=>'submitSingleSec','div'=>false));
			echo $this->Form->hidden('NewInsurance.ForsingleSec', array('label'=>false,'value'=>'1','id' => 'ForsingleSec','div'=>false));		
			//echo "&nbsp;&nbsp;".$this->Form->submit(__('Add Tertiary Insurance'), array('escape' => false,'class'=>'blueBtn','id'=>'submit2','div'=>false));
		//	echo "&nbsp;&nbsp;".$this->Form->submit(__('Add Tertiary Insurance'), array('type'=>'button','escape' => false,'class'=>'blueBtn Sec_tri_link','div'=>false,'id'=>'tertiary_link'));
			?>
			<?php echo $this->Form->end();?>
		</div>
	</div>
	<?php  echo $this->Form->create('NewInsurance3',array('url'=>array('controller'=>'patients','action'=>'addInsurance',$patient_id),'id'=>'newinsurance3','enctype' => 'multipart/form-data','div'=>false));?>
	<?php //echo $this->Form->input('id',array('type'=>'hidden'));?>
	<?php echo $this->Form->input('uploadedImageName',array('type'=>'hidden'));
 	echo $this->Form->hidden('web_cam',array('id'=>'web_cam'));	?>
	<?php echo $this->Form->hidden('NewInsurance.location_id', array('label'=>false,'value'=>$this->Session->read('locationid'),'id' => 'location_id')); ?>
	<?php echo $this->Form->hidden('NewInsurance.patient_uid', array('label'=>false,'value'=>$getPatientUid,'id' => 'patient_uid')); ?>
	<?php  echo $this->Form->hidden('NewInsurance.patient_id', array('label'=>false,'value'=>$patient_id,'id' => 'patient_id'));
	echo $this->Form->hidden('person_id',array('id'=>'person_id','value'=>$getpersonId)); ?>
	<div id="tabs-3" class="tab-content" style="padding-top: 5px;">
		<table width="100%" border="0" cellspacing="0" cellpadding="0"
			class="formFull">
			<tr>
				<td width="21%" class="tdLabel" id="boxSpace"><?php echo __('Payor Name');?><font
					color="red">*</font>
				</td>
				<!--  <td width="28%"><?php echo $this->Form->input('NewInsurance.tariff_standard_id', array('label'=>false,'empty'=>__('Select'),'options'=>$getDataInsuranceType
						,'id' => 'insurance_type_id3','autocomplete'=> 'off','class' => 'validate[required,custom[mandatory-select]] textBoxExpnd')); ?>
				</td>-->
					<?php //echo $this->Form->hidden('NewInsurance.tariff_standard_name',array('id'=>'tariff_standard_name3'));?>
					<td width="28%"><?php //echo $this->Form->input('NewInsurance.tariff_standard_name', array('label'=>false,'id' => 'tariff_standard_name3','autocomplete'=> 'off','class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd')); ?>
			
				<?php //echo $this->Form->hidden('NewInsurance.tariff_standard_id',array('id'=>'insurance_type_id3'));
				echo $this->Form->input('NewInsurance.tariff_standard_name', array('label'=>false,'id' => 'tariff_standard_name3','autocomplete'=> 'off','class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd'));
				echo $this->Form->hidden('NewInsurance.tariff_standard_id',array('id'=>'insurance_type_id3'));
				echo $this->Form->hidden('NewInsurance.insurance_name',array('id'=>'insurance_name3'));
				echo $this->Form->hidden('NewInsurance.payer_id',array('id'=>'payer_id3'));
				echo $this->Form->hidden('NewInsurance.insurance_number',array('id'=>'insurance_number3'));?>
				</td>
				<td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Policy #/Insured ID');?><font
									color="red">*</font>
				</td>
				<td width="16%"><?php echo $this->Form->input('NewInsurance.policy_no', array('label'=>false,'id' => 'policy_no3','class'=> 'validate[required,custom[mandatory-enter]] textBoxExpnd','div'=>false)); ?>
				<input type="radio" name="NewInsurance[policy_type]"
					value="MI" style="display: none;"><?php //echo __('Member ID');  ?><br> <input type="radio"
					name="NewInsurance[policy_type]" value="ZZ" checked='checked' style="display: none;"><?php //echo __('Unique');  ?>
					<?php //echo __('Health ID'); ?></td>

			</tr>
			<tr>
				<td class="tdLabel" id="boxSpace">Responsibility<font color="red">*</font>
				</td>
				<td><?php echo __('Tertiary'); ?> <?php echo $this->Form->input('NewInsurance.priority',array('type'=>'hidden','value'=>'T')) ?>
				</td>

				<td width="19%" class="tdLabel" id="boxSpace">Effective from</td>

				<td width="26%"><?php echo $this->Form->input('NewInsurance.effective_date', array('label'=>false,'type'=>'text','class' => 'textBoxExpnd','id' => 'efdate2','readonly'=>'readonly')); ?>
				</td>
			</tr>
			<!--  <tr>
				<td width="21%" class="tdLabel" id="boxSpace"><?php echo __('Insurance Name');?>
				</td>
				<td width="28%"><?php echo $this->Form->input('NewInsurance.insurance_name', array('label'=>false,'id' => 'insurance_name3','autocomplete'=> 'off','class' => 'validate["",custom[mandatory-enter]] textBoxExpnd','div'=>false)); ?>
				</td>
				<td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Insurance ID');?>
				</td>
				<td width="26%"><?php echo $this->Form->input('NewInsurance.insurance_number', array('label'=>false,'id' => 'insurance_number3','class'=> 'textBoxExpnd','div'=>false)); ?>
				</td>
			</tr>-->
			<tr>
				<td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Group Name')?>
				</td>
				<td width="20%"><?php echo $this->Form->input('NewInsurance.group_name', array('label'=>false,'id' => 'group_name','class'=> 'textBoxExpnd','div'=>false)); ?>
				</td>

				<td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Group ID')?>
				</td>
				<td width="26%"><?php echo $this->Form->input('NewInsurance.group_number', array( 'id' =>'group_number', 'class'=> 'textBoxExpnd','label'=>false, 'div' => false, 'error' => false)); ?>
				</td>
			</tr>
			<tr>
				<td width="19%" id="boxSpace" class="tdLabel">Co pay type<font
					color="red">*</font>
				</td>
				<td width="20%"><?php echo $this->Form->input('NewInsurance.copay_type', array('label'=>false,'empty'=>__("Select"),'options'=>array('Fixed','Percentage'),'id' => 'copay_type3','class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','onchange'=>'javascript:getPercentage()')); ?>
				</td>

				<td width="19%" class="tdLabel" id="boxSpace">Relation to insured</td>
				<td width="26%"><?php echo $this->Form->input('NewInsurance.relation', array( 'id' =>'relation','empty'=>'Select', 'options'=>array('self'=>'Self','spouse'=>'Spouse','child'=>'Child','other'=>'Other','D'=>'Unspecified Dependent'), 'class'=> 'textBoxExpnd','label'=>false, 'div' => false, 'error' => false)); ?>
				</td>
			</tr>
			<tr>
				<td valign="middle" class="tdLabel" id="boxSpace"></td>
				<td><div id="showcopay3" style="display:none;"><?php echo $this->Form->input('NewInsurance.fixed_percentage', array('type'=>'text','label'=>false,'class' => 'validate[required,custom[name],custom[onlyNumberSp]] textBoxExpnd fixed_percent','placeholder'=>'Enter Percentage(ex:30%)','id' => 'fixed_percentage3','div'=>false));
				echo $this->Form->input('NewInsurance.fixed_amt', array('type'=>'text','label'=>false,'class' => 'validate[required,custom[name],custom[onlyNumberSp]] textBoxExpnd','placeholder'=>'Enter Amount(ex:$300)','id' => 'fixed_amt3','div'=>false)); ?>
				</div></td>
			</tr>
			<!-- <tr>
				<td width="19%" class="tdLabel" id="boxSpace">Active</td>
				<td width="26%"> --><?php echo $this->Form->checkbox('NewInsurance.is_active', array('label'=>false,'id' => 'is_active','value'=>'0','style'=>'display:none;')); ?>
				<!-- </td>
				<td width="19%" class="tdLabel" id="boxSpace"><?php echo __('Is Person');?>
				</td>
				<td width="16%"> --><input type="radio" name="NewInsurance[is_person]"
					value="Yes" checked="checked" style="display:none;"><?php //echo __('Yes');?> <input type="radio"
					name="NewInsurance[is_person]" value="No" style="display:none;"><?php //echo __('No');?><!-- </td>
			</tr> -->
			<tr>
				<td width="19%" class="tdLabel" id="boxSpace">Upload Insurance Card</td>
				<td width="19%"><?php echo $this->Form->input('NewInsurance.upload_card', array('type'=>'file','id' => 'patient_photo3', 'class'=>"textBoxExpnd",'label'=> false,'div' => false, 'error' => false)); ?>
				<?php echo $this->Html->image('/img/icons/webcam.png',array('id'=>'camera','title'=>'Capture photo from webcam'));?>
					<canvas width="320" height="240" id="parent_canvas"
						style="display: none;"></canvas>
				</td>
				<td width="19%" class="tdLabel" id="boxSpace">Back of Card</td>
				<td width="19%"><?php 
					echo $this->Form->input('NewInsurance.back_of_card', array('type'=>'file','id' => 'back_of_card', 'class'=>"textBoxExpnd",'label'=> false,'div' => false, 'error' => false)); ?>
									<?php echo $this->Html->image('/img/icons/webcam.png',array('id'=>'camera_card','title'=>'Capture photo from webcam'));?>
									<canvas width="320" height="240" id="parent_canvas_card" style="display: none;"></canvas>
				</td>
			</tr>

			<!-- <tr>
				<td width="19%" id="boxSpace" class="tdLabel">Claim Officer<font
					color="red">*</font>
				</td>
				<td><?php echo $this->Form->input('NewInsurance.claim_officer', array('type'=>'text','class'=>"textBoxExpnd validate[required,custom[mandatory-enter]]",'label'=>false)); ?>
				</td>

				<td width="19%" class="tdLabel" id="boxSpace">Patient Student Status</td>
				<td width="26%"><?php echo $this->Form->input('NewInsurance.patient_stuent_status', array('type'=>'text', 'class'=>"textBoxExpnd",'label'=>false)); ?>
				</td>
			</tr> -->
			<tr>
				<td id="boxSpace" class="tdLabel" colspan="4">
								<?php echo $this->Form->checkbox('NewInsurance.verify', array('label'=>false,'id' => 'is_active')); ?>
										<?php echo __("Verified");?>
										<?php echo $this->Form->checkbox('NewInsurance.is_assign', array('label'=>false,'id' => 'is_active')); ?>
										<?php echo __("Accept Assign");?>
										<?php echo $this->Form->checkbox('NewInsurance.is_eob', array('label'=>false,'id' => 'is_active')); ?>
										<?php echo __("EOB");?>
				</td>
				</tr>
				<tr>
				<td id="boxSpace" class="tdLabel" colspan="4" style="float:none;"><?php echo $this->Form->checkbox('NewInsurance.pri_is_authorized', array('label'=>false,'id' => 'pri_is_authorized','value'=>'Y')); ?>
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
				<td width="43%"><?php echo $this->Form->input('NewInsurance.employer', array('label'=>false,'div'=>false,'id' => 'employer','class'=> 'textBoxExpnd')); ?>
				</td>
				<td width="21%" class="tdLabel">City</td>
				<td width="30%" valign="top"><?php echo $this->Form->input('NewInsurance.emp_city', array('label'=>false,'id' => 'city','class'=>'textBoxExpnd')); ?>
				</td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Address</td>
				<td width="30%"><?php echo $this->Form->input('NewInsurance.emp_address', array('label'=>false,'id' => 'emp_address','class'=>'textBoxExpnd')); ?>
				</td>
				<td width="21%" class="tdLabel">State</td>
				<td width="30%" ><?php //$states = ''; id="emp_state1"
				echo $this->Form->input('NewInsurance.emp_state', array('options' => $state,'empty' =>'Please Select State','selected'=>'84', 'id' => 'emp_state3', 'label'=> false, 'div' => false, 'error' => false,'class' => 'textBoxExpnd'));?>
				</td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Note</td>
				<td width="30%"><?php echo $this->Form->input('NewInsurance.note', array('label'=>false,'id' => 'note','class'=> 'textBoxExpnd')); ?>
				</td>
				<td width="21%" class="tdLabel">Country</td>
				<td width="40%"><?php 
				//echo $this->Form->input('NewInsurance.emp_country', array('options' => $countries, 'empty' => 'Select Country', 'id' => 'emp_country', 'label'=> false, 'div' => false, 'error' => false,'onchange'=> $this->Js->request(array('controller'=>'persons','action' => 'get_state_city','reference'=>'State','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#emp_state1', 'data' => '{reference_id:$("#emp_country").val()}', 'dataExpression' => true, 'div'=>false)),'class' => 'validate[,custom[mandatory-select]] textBoxExpnd'));
				echo $this->Form->input('NewInsurance.emp_country', array('options' => $countries,'selected'=>'2', 'id' => 'emp_country3', 'label'=> false, 'div' => false, 'error' => false,'class' => 'textBoxExpnd'));
				?></td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Zip Code</td>
				<td width=""><?php echo $this->Form->input('NewInsurance.emp_zip_code', array('type'=>'text','label'=>false,'id' => 'zip_codeote2','class'=>'textBoxExpnd','Maxlength'=>5)); ?>
				</td>
			</tr>
			<!-- <tr>
				<td width="21%" class="tdLabel">SSN</td>
				<td width=""><?php echo $this->Form->input('NewInsurance.emp_ssn', array('label'=>false,'id' => 'emp_ssn','class'=>'textBoxExpnd','Maxlength'=>5)); ?>
				</td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Phone</td>
				<td width=""><?php echo $this->Form->input('NewInsurance.emp_phone', array('label'=>false,'id' => 'emp_ssn','class'=>'textBoxExpnd','Maxlength'=>5)); ?>
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
				<td width="28%"><?php echo $this->Form->input('NewInsurance.subscriber_name', array('id'=>'subscriber_name','label'=>false,'class'=> '','style'=>'width:143px','div'=>false)); ?>
					<?php  echo $this->Form->input('NewInsurance.subscriber_initial', array('id'=>'gau_middle_name','label'=>false,'style'=>'width:72px','div'=>false)); ?>
				</td>
				<td width="21%" class="tdLabel">Subscriber Last name</td>
				<td width="20%"><?php echo $this->Form->input('NewInsurance.subscriber_last_name', array('id'=>'gau_last_name','label'=>false,'class'=>'textBoxExpnd')); ?>
				</td>

			</tr>
			<tr>
				<td width="21%" class="tdLabel">Date of Birth</td>
				<td width="250"><?php echo $this->Form->input('NewInsurance.subscriber_dob',array('id'=>'dobg3','class'=>'textBoxExpnd','type'=>'text','autocomplete'=>"off",'legend'=>false,'div'=>false,'label'=>false,'readonly'=>'readonly'));?>
				</td>
				<td width="21%" class="tdLabel">Gender</td>
				<td width="27%"><?php echo $this->Form->input('NewInsurance.subscriber_gender', array('id'=>'gau_sex','empty'=>__("Select"),'options' => array('Male'=>__('Male'),'Female'=>__('Female'),'Ambiguous'=>__('Ambiguous'),'Not applicable'=>__('Not applicable'),'Unknown'=>__('Unknown'),'Other'=>__('Other')), 'default' => '','label'=>false,'div'=>false,'class'=>'textBoxExpnd'));?>
				</td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Social Security Number
				</td>
				<td width="27%"><?php echo $this->Form->input('NewInsurance.subscriber_security', array('id'=>'gau_ssn2','maxLength'=>'9','label'=>false,'class'=>'textBoxExpnd ')); ?>
				</td>
				<td width="21%" class="tdLabel">Address1</td>
				<td width="20%"><?php echo $this->Form->input('NewInsurance.subscriber_address1', array('id'=>'gau_plot_no','label'=>false,'class'=>'textBoxExpnd')); ?>
				</td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Address2</td>
				<td width="20%"><?php echo $this->Form->input('NewInsurance.subscriber_address2', array('id'=>'gau_landmark','label'=>false,'class'=>'textBoxExpnd')); ?>
				</td>
			
				<td width="21%" class="tdLabel">City</td>
				<td width="20%"><?php echo $this->Form->input('NewInsurance.subscriber_city', array('id'=>'city','label'=>false, 'class'=> 'textBoxExpnd','div'=>false)); ?>
				</td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">State</td>
				<td width="20%" ><?php ///$state ='';id="customstate1"
								echo $this->Form->input('NewInsurance.subscriber_state', array('id'=>'customstate12','options' => $state, 'empty' => 'Please Select State','selected'=>'84', 'label'=> false, 'div' => false, 'error' => false,'class'=> 'textBoxExpnd')); ?>
				</td>
				<td width="21%" class="tdLabel">Country</td>
				<td width="200px"><?php //echo $this->Form->input('NewInsurance.subscriber_country', array('options' => $countries, 'empty' => 'Select Country', 'id' => 'customcountry1', 'label'=> false, 'div' => false, 'error' => false, 'class'=>'textBoxExpnd','onchange'=> $this->Js->request(array('controller'=>'persons','action' => 'get_state_city','reference'=>'State','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#customstate1', 'data' => '{reference_id:$("#customcountry1").val()}', 'dataExpression' => true, 'div'=>false)))); 
				echo $this->Form->input('NewInsurance.subscriber_country', array('options' =>$countries,'selected'=>'2', 'id' => 'customcountry1', 'label'=> false, 'div' => false, 'error' => false, 'class'=>'textBoxExpnd')); ?>
				</td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Zip Code</td>
				<td width="20%"><?php echo $this->Form->input('NewInsurance.subscriber_zip', array('id'=>'subscriber_zip','label'=>false, 'class'=> 'textBoxExpnd','Maxlength'=>5)); ?>
				</td>
				<td width="21%" class="tdLabel">Primary Phone</td>
				<td width="20%"><?php echo $this->Form->input('NewInsurance.subscriber_primary_phone', array('type'=>'text','id'=>'gau_home_phone3','label'=>false, 'class'=> 'textBoxExpnd','div'=>false,'maxLength'=>'14')); ?>
				</td>
			</tr>
			<tr>
				<td width="21%" class="tdLabel">Secondary Phone</td>
				<td width="20%"><?php echo $this->Form->input('NewInsurance.subscriber_secondary_phone', array('type'=>'text','id'=>'gau_mobile3','label'=>false,'class'=> 'textBoxExpnd','div'=>false,'maxLength'=>'14')); ?>
				</td>
			</tr>
			 <tr>
                                <!--<td width="50%" id="boxSpace">
                                  <table>-->
                                     <td width="19%" id="boxSpace" class="tdLabel"><?php echo __('Signature'); ?></td>

                                      <td width="20%"><?php //echo $this->Form->input('NewInsurance.sign', array('type' =>'text', 'id' => 'signature','style'=>'visibility:hidden','label'=>false,'legend'=>false)); ?>

								<div class="sigPad">
									<ul class="sigNav">
										<li class="drawIt"><a href="#draw-it"><font color="#000000">Draw
																		It
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
								</div>
							</td>
                                  <!--</table>
                               </td>-->
                             </tr>
		</table>
		<?php echo $this->Form->hidden('NewInsurance.refference_id',array()); //'value'=>$lastInsertId?>
		<!-- to check its a last tab -->
		<?php echo $this->Form->hidden('NewInsurance3.check',array('value'=>'thrid_tab'));?>
		<div align="right">
		<?php
		echo $this->Form->submit(__('Submit Tertiary'), array('escape' => false,'class'=>'blueBtn','id'=>'submit3'));
		?>
		<?php echo $this->Form->end();?>
	</div>
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
$(document).ready(function(){

	
	$("#dobg,#dobg2,#dobg3")
	.datepicker(
			{
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
					//$(this).validationEngine("hide");
				}			

		});	
	 });
$(".efdate")
.datepicker(
		{
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
$("#efdate1")
.datepicker(
		{
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
$("#efdate2")
.datepicker(
		{
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
 </script>
<script>

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
	var getData2 = $("#copay_type2 option:selected").val();
	if(getData2=='1'){
		$('#showcopay2').show();
		$("#fixed_percentage2").show();
		$("#fixed_amt2").hide();
		//alert('if');
	}	
	else if(getData2=='0'){
		$('#showcopay2').show();
		$("#fixed_amt2").show();
		$("#fixed_percentage2").hide();//alert('else');
	}else{
		$("#fixed_percentage2").hide();
		$("#fixed_amt2").hide();
	}
	var getData3 = $("#copay_type3 option:selected").val();
	if(getData3=='1'){
		$('#showcopay3').show();
		$("#fixed_percentage3").show();
		$("#fixed_amt3").hide();
		//alert('if');
	}	
	else if(getData3=='0'){
		$('#showcopay3').show();
		$("#fixed_amt3").show();
		$("#fixed_percentage3").hide();//alert('else');
	}else{
		$("#fixed_percentage3").hide();
		$("#fixed_amt3").hide();
	}
}
/* function removetext(){
	 
	 $("#fixed_amt").val(" ");
	 $("#fixed_percentage").val(" ");
 }
*/

 $("#ckeckGua").change(function edit_loadGauranter(){
var id='<?php echo $patient_id ;?>';
	// alert(id);
		//return;
	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "edit_loadGauranter","admin" => false)); ?>";
	   var formData = $('#newinsurance').serialize();
		  if(formData==""){
			 var formData = $('#patientnotesfrm').serialize();
			 var renderpage=true;
			}
          $.ajax({
           type: 'POST',
          url: ajaxUrl+"/"+id,
         //  data: formData,
           dataType: 'html',
           success: function(data){
           	           	
			var data = data.split("|");  
				$("#person_id").val(id);
				$("#subscriber_name").val(data[0]);//alert(data[0]);
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
			error: function(message){
               alert("Error in Retrieving data");
           }       
		            });     
     return false; 

});
</script>
<script>

$(document).ready(function(){
	$('#insurance_type_id').blur(function (){
		$('#tariff_standard_name').val($('#insurance_type_id option:selected').text());
		});
	$('#insurance_type_id2').blur(function (){
		$('#tariff_standard_name2').val($('#insurance_type_id2 option:selected').text());
		});
	$('#insurance_type_id3').blur(function (){
		$('#tariff_standard_name3').val($('#insurance_type_id3 option:selected').text());
		});
	
    var copay_type=$('#copay_type').val();
    if(copay_type=='0'){
        $('#fixed_amt').show();
        $('#fixed_percentage').hide();
    } else if(copay_type=='1'){
    	$('#fixed_percentage').show();
    	$('#fixed_amt').hide();
    } else{
		$("#fixed_percentage").hide();
		$("#fixed_amt").hide();
	}
   // alert(copay_type);
    ///	fixed_amtfixed_percentage
	
	
	
	});

/*jQuery("#newinsurance,#newinsurance1,#newinsurance3").validationEngine({
	validateNonVisibleFields: true,
	updatePromptsPosition:true,
	});*/
	
$('#submitSingle,#submitSingleSec,#submit,#submit2,#submit3').click(function() { 	
	var validatePerson = jQuery("#newinsurance,#newinsurance1,#newinsurance3").validationEngine('validate');	
	if (validatePerson) {$(this).css('display', 'none');}
	else{
	return false;
	}
	});
	
$("#refer_doctor").autocomplete("<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "testcomplete","DoctorProfile",'user_id',"doctor_name",'null',"admin" => false,"plugin"=>false)); ?>", {
	width: 250,
	selectFirst: true,
	valueSelected:true,
	showNoId:true
//	loadId : 'refer_doctor,sb_registrar'
});
$(document).ready(function(){
	 $("#NewInsuranceReferDoctor").autocomplete("<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "testcomplete","DoctorProfile","user_id","doctor_name",'null',"admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true,
			valueSelected:true,
			loadId : 'NewInsuranceReferDoctor,doctorID'
		});
		///BOF-For Differentiating the save data
	 $('#submit').click(function() { 		
		 $('#submitSingle').attr('disabled', 'disabled');
		 $('#Forsingle').attr('disabled', 'disabled');
		});
	 $('#submit2').click(function() { 		
		 $('#submitSingleSec').attr('disabled', 'disabled');
		 $('#ForsingleSec').attr('disabled', 'disabled');
		});
	///EOF-For Differentiating the save data
		
});

</script>

<script>
var selectedTariffStandardName = '';
var selectedTariffStandardName2 = '';
var selectedTariffStandardName3 = '';
$('.pad_bg').click(function(){
	$('#tariff_standard_name').val(selectedTariffStandardName);
	$('#tariff_standard_name2').val(selectedTariffStandardName2);
	$('#tariff_standard_name3').val(selectedTariffStandardName3);
});
    $(document).ready(function() {   	
		
      $('.sigPad').signaturePad();
      $( ".div" ).tabs( { disabled: [tabs-1, tabs-2] } );

      
      $("#tariff_standard_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","TariffStandard","id","name",'null',"admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true,
			valueSelected:true,
			showNoId:true,
			loadId : 'tariff_standard_name,insurance_type_id',
			onItemSelect:function( ) {
				selectedTariffStandardName = $('#tariff_standard_name').val();
				var payerID = $('#insurance_type_id').val();//code_type
				
				var URL = "<?php echo $this->Html->url(array('controller' => 'patients', 'action' => 'tariffPayerId','admin' => false,'plugin'=>false)); ?>";
				$.ajax({
				type: "GET",
				url: URL+"/"+payerID,
				success : function ( data ){
				var tariffStandardData = jQuery.parseJSON(data);
				
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
		selectedTariffStandardName2 = $('#tariff_standard_name2').val();
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
		selectedTariffStandardName3 = $('#tariff_standard_name3').val();
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
/*$("#insurance_name").autocomplete("<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "testcomplete","InsuranceCompany","HealthplanDetailID","name","Status=".'A',"admin" => false,"plugin"=>false)); ?>", {
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
  $('#gau_home_phone ,#gau_mobile, #gau_home_phone2 , #gau_mobile2, #gau_home_phone3 , #gau_mobile3' ).focus(function(){
   	 usPhonenumber('gau_home_phone');
   	 usPhonenumber('gau_mobile');
   	 usPhonenumber('gau_home_phone2');
   	 usPhonenumber('gau_mobile2');
   	 usPhonenumber('gau_home_phone3');
   	 usPhonenumber('gau_mobile3');
   	});

  $(document).ready(function(){
  $( '.payment_categoryCls' ).click(function (){
  	var value=$(this).val(); 
		$('.InsurancePaymentTypeCls').removeAttr('checked');
		var payment_category_selfpay=$('#payment_category_selfpay').val(); 
		var payment_category_indigent=$('#payment_category_indigent').val(); 		
		var person_id=$('#person_id').val(); 
		var patient_id=$('#patient_id').val();
		if(value=='cash'){
			var getallNewInsurance ="<?php echo $getallNewInsurance;?>";		
			if(getallNewInsurance!=''){				
				var existsIns=confirm('Are you sure to Inactive your Insurance?');				
			    if (existsIns){	
				    valueInActive='1';				  
			    }else{
			    	  return false;
			    }			    					
			}				
			var payemnt_cat=payment_category_selfpay+','+payment_category_indigent;		
			//if($('#payment_category_selfpay').attr('checked')==true){	
			var isSchedule=confirm('Is patient is Indigent?');
		    if (isSchedule){				
		    	$('.payment_categoryCls').attr('checked',true);		    	
		    }else{
		    	$('.payment_categoryCls').attr('checked',false);	
		    	payemnt_cat=payment_category_selfpay;
		    }
			/*}else{
				return false;
			}*/
		}else if(value=='Indigent'){	
			payemnt_cat=payment_category_indigent;		
			$( '#payment_category_indigent').attr('checked',true);
		}			
	
		$.ajax({
			  type : "POST",
			  url: "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "saveInsuranceType", "admin" => false)); ?>",
			  context: document.body,
			  beforeSend:function(){
	 			  	// this is where we append a loading image
	 			  	$('#busy-indicator').show('fast');},
			  data:"payment_category="+payemnt_cat+"&id="+person_id+"&is_active="+valueInActive+"&patient_id="+patient_id,
			 success: function(data){			
				 $('#busy-indicator').hide('fast');			
				 window.location.href="<?php echo $this->Html->url(array("controller" => "appointments", "action" => "appointments_management", "admin" => false)); ?>"
		   }		  			  
		});
	  	 return true;      
	});
	$( '.InsurancePaymentTypeCls' ).click(function (){
		$('.payment_categoryCls').removeAttr('checked');
	});
 
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
