<style>
.tddate img {
	float: inherit;
}
</style>
<?php 
echo $this->Html->script('jquery.autocomplete');
echo $this->Html->css('jquery.autocomplete.css');
echo $this->Html->script(array('jquery.signaturepad.min'));
echo $this->Html->css(array('jquery.signaturepad'));
?>
<style type="text/css">
#password_description {
	font-size: 12px;
}

#password_strength {
	height: 10px;
	display: block;
}

#password_strength_border {
	width: 144px;
	height: 10px;
	border: 1px solid black;
}

.strength0 {
	width: 144px;
	background: #cccccc;
}

.strength1 {
	width: 40px;
	background: #ff0000;
}

.strength2 {
	width: 60px;
	background: #ff5f5f;
}

.strength3 {
	width: 80px;
	background: #56e500;
}

.strength4 {
	background: #4dcd00;
	width: 100px;
}

.strength5 {
	background: #399800;
	width: 144px;
}
textarea {
	width: 259px !important;
} 
</style>
<div class="inner_title">
	<h3>
		<?php echo __('Add User', true); ?>
	</h3>

</div>
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#userfrm").validationEngine();
	});
	
</script>

<?php 
if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="100%"
	align="center">
	<tr>
		<td colspan="2" align="left" class="error"><?php 
		foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
     ?>
		</td>
	</tr>
</table>
<?php } ?>
<!-- <form name="userfrm" id="userfrm" type="file" action="<?php echo $this->Html->url(array("controller" => "users", "action" => "add", "admin" => true)); ?>" method="post" >-->
<?php echo $this->Form->create('User',array('type' => 'file','autocomplete'=>"off",'name'=>'userfrm','id'=>'userfrm','inputDefaults' => array('label' => false, 'div' => false, 'error' => false	))); ?>
<?php echo $this->Form->input('DoctorProfile.is_registrar', array('type' => 'hidden', 'id' => 'is_registrar', 'label'=> false, 'div' => false, 'error' => false)); ?>
<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%" align="center">
<tr>
<td valign="top" width="50%">
<table border="0" class="table_format" cellpadding="0"	cellspacing="0" width="100%" align="center">
	<tr id="locationArea">
		<td class="form_lables" ><?php echo __('Clinic Location',true); ?><font
			color="red">*</font>
		</td>
		<?php?>
		<td><?php 
		if($this->Session->read('website.instance')=='vadodara'){
		echo $this->Form->input('User.location_id', array('selected'=>'1','options'=>$locations,'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'location_id', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));
		}else{
			echo $this->Form->input('User.location_id', array('empty'=>__('Please Select'),'options'=>$locations,'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'location_id', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));
		}
		?>
		</td>
	</tr>
		<tr>
		<td class="form_lables"><?php echo __('Role',true); ?><font
			color="red">*</font>
		</td>
		<td><?php 
		echo $this->Form->input('User.role_id', array('empty' => 'Select Role', 'options' => $roles, 'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd', 'id' => 'roletype',
		          	 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off',
		          	 'onchange'=> $this->Js->request(array('action' => 'getDepartment', 'superadmin' => false, 'admin' => false),
		          	  array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
		    		  'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#showDepartmentList', 'data' => '{roletype:$("#roletype").val()}', 'dataExpression' => true, 'div'=>false))));
		        ?>
		</td>
	</tr>

	<!-- 
	<tr>
		<td class="form_lables" ><?php //echo __('Hospital Location',true); ?><font
			color="red">*</font>
		</td>
		<td><?php 
		//echo $this->Form->input('User.second_location_id', array('empty'=>__('Please Select'),'options'=>$locations,'class' => 'textBoxExpnd validate[required,custom[mandatory-select]]','id' => 'second_location_id', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));
		?>
		</td>
	</tr> -->


	<tr style="display: none;" id="departmentslist">
		<td class="form_lables" ><?php echo __('Specialty',true); ?><font
			color="red">*</font>
		</td>
		<td id="showDepartmentList"></td>
	</tr>
	
	<tr id="subSpecialtyTrID" style="display: none;">
		<td><?php echo __('Select Sub Specialty:');?></td>
		<td><?php echo $this->Form->input('User.sub_specialty',array('type'=>'select','options'=>$testGroup,'empty' => __ ( 'Select Sub Specialty' ),'id'=>'subSpecialty', 'div'=>false,'label'=>false,'class'=>'textBoxExpnd '));?>
		</td>
	</tr>
	<tr style="display: none;" id="surgeonshow">
		<td class="form_lables"><?php echo __('Surgeon',true); ?>
		</td>
		<td ><?php 
		echo $this->Form->input('DoctorProfile.is_surgeon', array('type' => 'radio','class' => '','label' => false,'legend' => false ,'options' => array('0'=>'No', '1' => 'Yes'), 'default' => 0));
		?>
		</td>
	</tr>
	<tr style="display: none;" id="opdDoctorshow">
		<td class="form_lables"><?php echo __('Need to Allot Chamber',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('DoctorProfile.is_opd_allow', array('type' => 'radio','class' => '','label' => false,'legend' => false ,'options' => array('0'=>'No', '1' => 'Yes'), 'default' => 0));
		?>
		</td>
	</tr>
	<tr style="display: none;" id="doctorshow">
		<td class="form_lables"><?php echo __('Doctor',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('User.is_doctor', array('type' => 'checkbox','class' => '','label' => false,'legend' => false,'checked'=>'checked'));
		?>
		</td>
	</tr>
	<tr style="display: none;" id="regshow">
		<td class="form_lables"><?php echo __('Registrar',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('DoctorProfile.is_registrar', array('type' => 'checkbox','class' => '','label' => false,'legend' => false));
		?>
		</td>
	</tr>
	
	<!--<tr style="display: none;" class="profitsharingshow">
		<td class="form_lables"><?php echo __('Profit Sharing',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('User.profit_sharing', array('type' => 'text','class' => 'textBoxExpnd','label' => false,'legend' => false ,'id'=>'profit_sharing','style'=>"width:50px;",'maxlength'=>'3'));
		?><span style="float:left;">% of receipts</span>
		<?php 
		echo $this->Form->input('User.prof_sharing_dept_name', array('type' => 'text','style'=>'width:28%!important;margin:0 5px;','class' => 'textBoxExpnd','label' => false,'legend' => false ,'id'=>'prof_sharing_dept_name'));
		?><span style="float:left;">Department.</span>
		</td>	
	
	</tr>-->
	<?php if($this->Session->read('website.instance')=='kanpur'){?>
	<!-- for accounting sharing doctor percentage by amit jain -->
	<tr style="display: none;" class="profitsharingsconsultant">
		<td class="form_lables"><?php echo __('Doctor Commission',true); ?></td>
		<td>
			<span style="float:left;"><?php echo __('External Charges (%) '); ?></span>
			<?php echo $this->Form->input('Service.external_charges', array('type' => 'text','class' => 'textBoxExpnd','label' => false,'legend' => false ,'id'=>'externalCharges','style'=>"width:50px;",'maxlength'=>'3'));?>
			<span style="float:left;"><?php echo __('Hospital Charges (%) '); ?></span>
			<?php echo $this->Form->input('Service.hospital_charges', array('type' => 'text','class' => 'textBoxExpnd','label' => false,'legend' => false ,'id'=>'hospitalCharges','style'=>"width:50px;",'maxlength'=>'3'));?>
			<span style="float:left;"><?php echo __('From:'); ?></span>
			<?php echo $this->Form->input('Service.from', array('class'=>'validate[required,custom[mandatory-enter]] textBoxExpnd','style'=>'width:75px','id'=>'from','label'=> false, 'div' => false, 'error' => false,'placeholder'=>'From','autocomplete'=>'off'));?>
		</td>	
	</tr>
<?php }?>
	<tr>
		<td class="form_lables"><?php echo __('Username',true); ?><font color="red">*</font>
		</td>
		<td><?php  
		echo $this->Form->input('User.username', array('class' => 'validate[required,custom[username],ajax[ajaxUserCall]] textBoxExpnd','id' => 'username', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));
		//echo $this->Form->input('User.username', array('class' => 'validate[required,ajax[ajaxUserCall]] textBoxExpnd','id' => 'username', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));
		?>
		</td>
	</tr>
	
	<tr>
		<td class="form_lables"><?php echo __('New Password',true); ?><font color="red">*</font> </td>
		<td><?php //onkeyup='password_strength(this.value)' 
		if($this->Session->read('website.instance')=='kanpur'){
		echo $this->Form->input('User.password', array('id' => 'password','class' =>'textBoxExpnd validate[required,custom[newpassrequired]]',
		'label'=> false ,'div' => false, 'error' => false,'autocomplete'=>'off','value'=>'','onkeyup'=>'passwordStrength(this.value)'));
}
else
{
	echo $this->Form->input('User.password', array('id' => 'password','class' =>'textBoxExpnd validate[required,custom[newpassrequired],custom[passwordOnly]',
			'label'=> false ,'div' => false, 'error' => false,'autocomplete'=>'off','value'=>'','onkeyup'=>'passwordStrength(this.value)'));
}
 
		?><span id="minLength" style="display: none; color: red;">Minimum 8 Character</span>
		<br /><span style="float:left;"><i>(Allowed special characters : !*@#$%^&+=~`_-)</i></span>
		</td>

		<td>
			<div id="password_description"></div> <!-- Display password description like very week, better etc.-->
			<div id="password_strength_border" style="display: none;">
				<!-- Used for border only-->
				<div id="password_strength" class="strength0"></div>
				<!-- Display colors using css class -->
			</div>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Confirm Password',true); ?><font color="red">*</font>
		</td>
		<td><?php 
		echo $this->Form->input('User.conf_password', array('type'=>'password','id' => 'confPassword', 'label'=> false, 'class'=> 'textBoxExpnd validate[required,custom[confirmpassrequired]', 'div' => false, 'error' => false,'autocomplete'=>'off','onkeyup'=>'getChecked(this.value)'));
		echo $this->Html->image('icons/cross.png',array('id'=>'incorrect','style'=>'display:none;'));
		echo $this->Html->image('icons/tick.png',array('id'=>'correct','style'=>'display:none;'));
		?>
		</td>
	</tr>
	
	<tr>
		<td class="form_lables"><?php echo __('Email',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('User.email', array('class' => 'validate[optional,custom[email]] textBoxExpnd', 'id' => 'customemail', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));
		?>
		</td>
	</tr>
	<tr style="display: none;" id="direct_email">
		<td class="form_lables"><?php echo __('Direct Email',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('User.direct_email', array('class' => 'validate[optional,custom[email]] textBoxExpnd', 'id' => 'direct_email', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));
		?>
		</td>
	</tr>
	<!--<tr>
	<td class="form_lables" align="right">
	<?php echo __('Password',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        //echo $this->Form->input('User.password', array('class' => 'validate[required,custom[customrequired]]', 'id' => 'customrequired', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables" align="right">
	<?php echo __('Confirm Password',true); ?><font color="red">*</font>
	</td>
	<td>
         <input class="validate[required,equals[customrequired]] text-input" type="password" name="password2" id="password2" />
        </td>
	</tr> -->
	 	<?php $mrKey = array_search('Baby', $initials); $masterKey = array_search('Master', $initials); $missKey = array_search('Miss', $initials); 
              unset($initials[$mrKey],$initials[$masterKey],$initials[$missKey]);?>
	<tr>
		<td class="form_lables"><?php echo __('Initial',true); ?><font
			color="red">*</font>
		</td>
		<td><?php echo $this->Form->input('User.initial_id', array('class' => 'validate[required,custom[custominitial]] textBoxExpnd', 'options' => $initials,'empty'=>'Select Prefix', 'id' => 'custominitial', 'label'=> false, 'div' => false, 'error' => false));?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('First Name',true); ?><font
			color="red">*</font>
		</td>
		<td><?php 
		echo $this->Form->input('User.first_name', array('class' => 'validate[required,custom[onlyLetterNumber]] textBoxExpnd', 'id' => 'customfirstname', 'label'=> false, 'div' => false, 'error' => false));  //custom[onlyLetterSp],
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Middle Name',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('User.middle_name', array('id' => 'custommiddlename','class' => 'textBoxExpnd validate["",custom[onlyLetterSp]]', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Last Name',true); ?><font
			color="red">*</font>
		</td>
		<td><?php 
		echo $this->Form->input('User.last_name', array('class' => 'validate[required,custom[onlyLetterNumber]] textBoxExpnd', 'id' => 'customlastname', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr style="display: none;" id="shownpi">
		<td class="form_lables"><?php echo __('NPI',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('User.npi', array('class' => 'textBoxExpnd' ,'id' => 'npi', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	
	<tr style="display: none;" id="showdea">
		<td class="form_lables"><?php echo __('Dea #',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('User.dea', array('type'=>'text','class' => 'textBoxExpnd ' ,'id' => 'dea', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	
	<tr style="display: none;" id="showupin">
		<td class="form_lables"><?php echo __('UPIN #',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('User.upin', array('type'=>'text','class' => 'textBoxExpnd' ,'id' => 'upin', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	
	<!-- <tr style="display: none;" id="showstate">
		<td class="form_lables"><?php echo __('State ID',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('User.state', array('class' => 'textBoxExpnd' ,'id' => 'state', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr> -->
	
	<tr style="display: none;" id="showcaqh_provider_id">
		<td class="form_lables"><?php echo __('CAQH Provider ID',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('User.caqh_provider_id', array('type'=>'text', 'class' => 'textBoxExpnd', 'id' => 'caqh_provider_id', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr style="display: none;" id="showenrollment_status">
		<td class="form_lables"><?php echo __('Provider credentialing and enrollment applications status',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('User.enrollment_status', array('class' => 'textBoxExpnd','options'=>Configure::read('enrollment_status'), 
		'id' => 'enrollment_status', 'label'=> false, 'div' => false, 'error' => false));
			?>
		</td>
	</tr>
	
	<tr style="display: none;" id="showlicensure_type">
		<td class="form_lables"><?php echo __('Licensure Type',true); ?>
		</td>
		<td>
		<?php echo $this->Form->input('User.licensure_type', array('options' => $licenture,'empty' => 'Please Select Type', 'class' => 'textBoxExpnd', 'id' => 'licensure_type', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr style="display: none;" id="showlicensure_no">
		<td class="form_lables"><?php echo __('Licensure No',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('User.licensure_no', array('class' => 'textBoxExpnd','type'=>'text',  'id' => 'licensure_no', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr style="display: none;" id="showexpiration_date">
		<td class="form_lables"><?php echo __('Expiration Date',true); ?>
		</td>
		<td>
		
		<?php 
         if($this->data['DoctorProfile']['expiration_date'] == "0000-00-00") {
            $expiration_dateVal = "";
         } else {
            $expiration_dateVal = $this->DateFormat->formatDate2Local($this->data['DoctorProfile']['expiration_date'],Configure::read('date_format'),false);
         }
         echo $this->Form->input('User.expiration_date', array('class'=>'','id' => 'expiration_date', 'readonly'=>'readonly', 'label'=> false, 'div' => false, 'error' => false, 'type' => 'text', "style" =>"float:left;", 'value'=> $expiration_dateVal));
        ?>
		</td>	
	</tr> 
	<!-- <tr>
		<td class="form_lables"><?php echo __('AADHAR NO',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('User.ssn', array('class' => 'textBoxExpnd','maxlength'=>'12', 'id' => 'ssn', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr> -->

	<tr>
		<td class="form_lables"><?php echo __('Suffix',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('User.suffix', array( 'id' => 'suffix', 'class' => 'textBoxExpnd', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Name Type',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('User.name_type', array('empty'=>'Please Select','class' => 'textBoxExpnd','options'=>$name_type,'id' => 'name_type','label'=>false));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Gender',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('User.gender', array('class' => 'textBoxExpnd', 'options' => array('M' => 'Male', 'F' => 'Female'), 'empty' => 'Select Gender', 'id' => 'customgender', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Date Of Birth',true); ?>
		</td>
		<td class="tddate"><?php 
		echo $this->Form->input('User.dob', array('type'=>'text', 'id' => 'customdateofbirth', 'class' => 'textBoxExpnd ', 'label'=> false, 'div' => false, 'error' => false,'readonly' => 'readonly'));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Designation',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('User.designation_id', array( 'options' => $designations, 'empty' => 'Select Designation', 'id' => 'customdesignation', 'class' => 'textBoxExpnd', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Payment',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('User.payment', array('type'=>'text', 'class' => 'textBoxExpnd', 'id' => 'payment', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr>
		<th align="left" colspan="2">Bank account details</th>
	</tr>
	<tr>
		<td class="tdLabel">Bank name</td>
		<td><?php echo $this->Form->input('HrDetail.bank_name', array('label'=>false,'div'=>false,'id' => 'bank_name','class'=> 'textBoxExpnd')); ?>
		</td>
	</tr>
	<tr>
		<td class="tdLabel">Bank Branch</td>
		<td><?php echo $this->Form->input('HrDetail.branch_name', array('label'=>false,'id' => 'branch_name','class'=>'textBoxExpnd')); ?>
		</td>			
	</tr>
	<tr>
		<td class="tdLabel">Account number</td>
		<td><?php echo $this->Form->input('HrDetail.account_no', array('type'=>'text','label'=>false,'id' => 'account_no','class'=>'textBoxExpnd validate["",custom[onlyNumber]]')); ?></td>
	</tr>
	<tr>
		<td class="tdLabel">IFSC Code</td>
		<td><?php echo $this->Form->input('HrDetail.ifsc_code', array('type'=>'text','label'=>false,'id' => 'ifsc_code','class'=>'textBoxExpnd','maxlength'=>'11')); ?></td>
	</tr>
	<tr>
		<td class="tdLabel">Bank pass book copy obtained :</td>
		<td>
		<?php echo $this->Form->checkbox('HrDetail.pass_book_copy', array('style'=>'float:left','legend'=>false,'label'=>false,'class' => 'neft_authorized_received')); ?>
		</td>
	</tr>
  
	<tr>
		<td  class="tdLabel">NEFT authorization received :</td>
		<td>
		<?php echo $this->Form->checkbox('HrDetail.neft_authorized_received', array('style'=>'float:left','legend'=>false,'label'=>false,'class' => 'neft_authorized_received')); ?>
		</td>
	</tr>  		
	<tr>
		<td class="tdLabel">PAN</td>
		<td><?php 	echo $this->Form->input('HrDetail.pan', array( 'id' => 'pan','type'=>'text', 'selected'=>'84', 'label'=> false, 'div' => false, 'error' => false,'class' => 'textBoxExpnd'));?>
		</td>
	</tr>
</table>
</td>
<!-- Right Side of Html-->
<td valign="top" width="50%">
<table border="0" class="table_format" cellpadding="0"	cellspacing="0" width="100%" align="center">
	<tr>
		<td class="form_lables"><?php echo __('Address1',true); ?>
		</td>
		<td><?php 
		echo $this->Form->textarea('User.address1', array('cols' => '2', 'rows' => '2','class'=>'textBoxExpnd', 'id' => 'customaddress1', 'label'=> false, 'div' => false, 'error' => false,'value' =>$hospAddr['addr1']));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables" ><?php echo __('Address2',true); ?>
		</td>
		<td><?php 
		echo $this->Form->textarea('User.address2', array('cols' => '2', 'rows' => '2', 'id' => 'customaddress2','class'=>'textBoxExpnd', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Zipcode',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('User.zipcode', array('id' => 'pinCode','label'=> false, 'div' => false, 'error' => false,'class' =>'textBoxExpnd validate[optional,custom[onlyNumber,minSize[5]]]','Maxlength'=>'6','value' =>$hospAddr['pin']));

		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Country',true); ?></td>
		<td><?php //$countries
		echo $this->Form->input('User.country_id', array('options' =>$countries ,'empty'=>'Select Country','id' => 'customcountry', 'class' => ' textBoxExpnd',
			'label'=> false, 'div' => false, 'error' => false,
			'onchange'=> $this->Js->request(array('controller'=>'users','action' => 'get_state_city','reference'=>'State',
			'admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
			'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
			'async' => true, 'update' => '#changeStates', 'data' => '{reference_id:$("#customcountry").val()}', 'dataExpression' => true, 'div'=>false)))); ?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('State',true); ?></td>
		<td id="changeStates"  width='1230px'><?php //'options'=>$tempState,'selected'=>'34' ,
		echo $this->Form->input('User.state_name', array('id' => 'stateName', 'label'=> false, 'div' => false, 'error' => false,'class' => ' textBoxExpnd ','type'=>'text'));
		echo $this->Form->hidden('User.state_id',array('id'=>'stateId'));?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('City',true); ?>
		<td><?php echo $this->Form->input('User.city_id', array('type'=>'text','id' => 'city','label'=> false,'class' =>'textBoxExpnd','value' =>$hospAddr['city'])); ?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Phone1',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('User.phone1', array('id' => 'customphone1','maxlength'=>'11', 'label'=> false, 'div' => false, 'error' => false,'class'=>' textBoxExpnd','value' =>$hospAddr['primary_phone']));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Phone2',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('User.phone2', array('id' => 'customphone2','maxlength'=>'11','class' => 'textBoxExpnd validate["",custom[phone]]', 'label'=> false, 'div' => false, 'error' => false,'value'=>$hospAddr['secondary_phone']));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Mobile',true); ?><font
			color="red">*</font>
		</td>
		<td><?php 
		echo $this->Form->input('User.mobile', array('id' => 'custommobile','maxlength'=>'11', 'label'=> false, 'div' => false, 'error' => false,'class'=>'validate["",custom[phone]] textBoxExpnd validate[required,custom[mandatory-select]]'));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Fax',true);?></td>
		<td><?php echo $this->Form->input('User.fax', array('id' => 'customfax','maxlength'=>'10', 'class' => 'textBoxExpnd ', 'label'=> false, 'div' => false, 'error' => false,'value' =>$hospAddr['fax']));?></td>
	</tr>
	 <tr>
		<td class="form_lables"><?php echo __('Account Group',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('User.accounting_group_id', array('id' => 'group_id','type'=>'select','options'=>$group,'value'=>$groupId ,'class' =>'textBoxExpnd','label'=> false, 'div' => false, 'error' => false,'empty'=>'Please Select'));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Active',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('User.is_active', array('options' => array('No', 'Yes'), 'id' => 'customis_active', 'default'=>'1','class' => 'textBoxExpnd', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Photo',true); ?>
		</td>
		<td width="20%"><?php 
		echo $this->Form->input('User.upload_image', array('type'=>'file','id' => 'user_photo', 'class'=> 'textBoxExpnd','label'=> false,
					 				'div' => false,'error' => false));
        ?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Is Guarantor',true); ?>
		</td>
		<td><?php 
		echo $this->Form->checkbox('User.is_guarantor',array('id'=>'is_guarantor','class'=>'textBoxExpnd'));
		?>
		</td>
	</tr>

	<tr>
		<td class="form_lables"><?php echo __('Is Authorized for discount',true); ?>
		</td>
		<td><?php 
		echo $this->Form->checkbox('User.is_authorized_for_discount',array('id'=>'is_authorized_for_discount','class'=>'textBoxExpnd'));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Shifts Allowed',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input("PlacementHistory.0.shifts",array('options' => $allShiftData,'empty'=>'Select','class'=>"shiftname textBoxExpnd",'id'=>"shifts"));?>
		</td>
	</tr> 
	<tr>
		<td class="form_lables"><?php echo __('SMS Alert',true); ?>
		</td>
		<td><?php 
		echo $this->Form->checkbox('User.sms_alert',array('id'=>'sms_alert','class'=>'textBoxExpnd'));
		?>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center">&nbsp;</td>
	</tr>

	<tr>
		<td valign="left" id="boxSpace" class="tdLabel"><?php echo __('Signature.'); ?></td>
		<td align="left"> <div >
        <div class="sigPad">
	    <ul class="sigNav">
	    <li class="drawIt" ><a href="#draw-it"><font color="#000">Draw It</font></a></li>
	    <li class="clearButton"><a href="#clear"><font color="#000">Clear</font></a></li>
	    </ul>
        <div>
        <div class="typed"></div>
        <canvas class="pad" width="290" height="150"></canvas>
        <?php echo $this->Form->input('User.sign', array('type' =>'text', 'id' => 'sign', 'class' =>'output textBoxExpnd','style'=>'visibility:hidden')); ?>
        </div>
        </div>  
        </div></td>
	</tr>
	<tr>
		<td colspan="2" align="right"><?php echo $this->Html->link(__('Cancel', true),array('action' => 'index'), array('escape' => false,'class'=>'blueBtn')); ?>
			<input type="submit" value="Submit" class="blueBtn" id="submit">
			<?php if($isfingerPrintSupportEnable==1){?>
			&nbsp;<input class="blueBtn" type="submit" value="Capture Fingerprint" id="capturefingerprint">
			<?php }?>
		</td>
	</tr>
</table>

</td>
</tr>
</table>


	
</form>
<script>
$(document).ready(function(){
//  click on  capture fingerprint it save the user data & redirect to finger_print page,by pankaj
                       $('#capturefingerprint').click(function() {
                           var input = $("<input>").attr("type", "hidden").attr("name", "data[User][capturefingerprint]").val("1");
                           $('#userfrm').append($(input));
                           $('#userfrm').submit();
                          });

	jQuery("#userfrm").validationEngine({
		//*****alert("hi");
		validateNonVisibleFields: true,
		updatePromptsPosition:true,
		});
	$('#submit')
	.click(
			function() { 
				var externalCharges = $( "#externalCharges").val();
				externalCharges = externalCharges.trim();
				if(externalCharges == ''){
					$("#from").removeClass("validate[required,custom[mandatory-enter]]");
				}else{
					$("#from").addClass("validate[required,custom[mandatory-enter]]");
				}
				//alert("hello");
				var validatePerson = jQuery("#userfrm").validationEngine('validate');
			///	alert(validatePerson);
			//	if (validatePerson) {$(this).css('display', 'none');
			//	return false;
			});
});
jQuery(document).ready(function(){ 
			jQuery("#roletype").change(function(){
				/* if($("#location_id").val()==''){
					 alert("Please Select Location");
					 $('#roletype').val(0); 
					 }*/
						selectedRole = jQuery("#roletype option:selected").text() ;
						 
						if(selectedRole == '<?php echo Configure::read("doctorLabel") ?>' || selectedRole.toLowerCase() == "consultant") {
						        jQuery("#surgeonshow").show();
						        jQuery("#opdDoctorshow").show();
						        jQuery("#regshow").show();
						        jQuery("#doctorshow").show(); 
						        jQuery(".profitsharingshow").show();						        
                                jQuery("#direct_email").show();
						        jQuery("#departmentslist").show();
                                jQuery("#shownpi").show();
                                jQuery("#showdea").show();
                                jQuery("#showupin").show();
                                jQuery("#showstate").show();
                                jQuery("#showenrollment_status").show();
                                jQuery("#showcaqh_provider_id").show();
                                jQuery("#showlicensure_no").show();
                                jQuery("#showlicensure_type").show();
                                jQuery("#showexpiration_date").show();
                                jQuery(".profitsharingsconsultant").show();
                                jQuery("#is_registrar").val("0");
                        } else if(jQuery("#roletype option:selected").text() == "<?php Configure::read('RegistrarLabel'); ?>") {
                                jQuery("#departmentslist").show();
                                jQuery("#direct_email").show();
                                jQuery("#shownpi").show();
                                jQuery("#showdea").show();
                                jQuery("#showupin").show();
                                jQuery("#showstate").show();                        
                               	jQuery("#showcaqh_provider_id").show();
                               	jQuery("#showlicensure_no").show();
                                jQuery("#showenrollment_status").show();
                                jQuery("#showlicensure_type").show();
                                jQuery("#showexpiration_date").show();
                                jQuery("#is_registrar").val("1");
                        } else {
                                jQuery("#surgeonshow").hide();
                                jQuery("#opdDoctorshow").hide();
                                jQuery("#regshow").hide();
                                jQuery("#doctorshow").hide();
                                jQuery(".profitsharingshow").hide();                                
                                jQuery("#departmentslist").hide();
                                jQuery("#direct_email").hide();
                                jQuery("#shownpi").hide();
                                jQuery("#showdea").hide();
                                jQuery("#showupin").hide();
                                jQuery("#showstate").hide();
                                jQuery("#showcaqh_provider_id").hide();
                                jQuery("#showenrollment_status").hide();
                                jQuery("#showlicensure_type").hide();
                                jQuery("#showlicensure_no").hide();
                                jQuery("#showexpiration_date").hide();
                                jQuery("#showexpiration_date").hide();
                                jQuery(".profitsharingsconsultant").hide();
                        }
					});
                       var roletype = $('#roletype').val(); 
                       
                       if(roletype && (jQuery("#roletype option:selected").text() == "<?php echo Configure::read('doctorLabel') ?>"   || jQuery("#roletype option:selected").text() == "consultant"   || jQuery("#roletype option:selected").text() == "<?php Configure::read('RegistrarLabel'); ?>" || jQuery("#roletype option:selected").text() == "registrar")) {
                        var data = 'roletype=' + roletype ; 
                        $.ajax({url: "<?php echo $this->Html->url(array("controller" => "users", "action" => "getDepartment", "admin" => false,'class'=>'validate[required,custom[mandatory-select]] textBoxExpnd')); ?>",type: "GET",data: data,success:   function (html) { $('#departmentslist').show();$('#showDepartmentList').html(html); } });
                       }
                       <?php 
                         if(!empty($this->request->data['DoctorProfile']['department_id'])) {
                       ?>
                        var data = 'roletype=' + <?php echo $this->request->data['User']['role_id']; ?> ; 
                        $.ajax({url: "<?php echo $this->Html->url(array("controller" => "users", "action" => "getDepartment", "admin" => false,'class'=>'validate[required,custom[mandatory-select]] textBoxExpnd','style'=>'width=120px')); ?>",type: "GET",data: data,success:   function (html) { $('#departmentslist').show();$('#showDepartmentList').html(html); $('#departmentid').val(<?php echo $this->request->data['DoctorProfile']['department_id']; ?>)} });
                        jQuery("#registrar").show();
                       <?php 
                         } 
                       ?>
                        
                       <?php 
                         if($this->request->data['User']['state_id']) {
                       ?>
                        var data = 'reference_id=' + <?php echo $this->request->data['User']['country_id']; ?> ; 
                        $.ajax({url: "<?php echo $this->Html->url(array("controller" => "users", "action" => "get_state_city",'reference'=>'State', "admin" => false)); ?>",type: "GET",data: data,success:   function (html) { $('#changeStates').html(html); $('#customstate').val(<?php echo $this->request->data['User']['state_id']; ?>)} });
                       <?php 
                         }
                       ?>
                       <?php 
                         if($this->request->data['User']['city_id']) {
                       ?>
                        var data = 'reference_id=' + <?php echo $this->request->data['User']['state_id']; ?> ; 
                        $.ajax({url: "<?php echo $this->Html->url(array("controller" => "users", "action" => "get_state_city",'reference'=>'City', "admin" => false)); ?>",type: "GET",data: data,success:   function (html) { $('#changeCities').html(html); $('#customcity').val(<?php echo $this->request->data['User']['city_id']; ?>)} });
                       <?php 
                         }
                       ?>
                      
                        $(function() {
                        	//var dateminmax = new Date(new Date().getFullYear()-100, 0, 0)+':'+new Date(new Date().getFullYear()-20, 0, 0);
                        	 	var firstYr = new Date().getFullYear()-100;
                    			var lastYr = new Date().getFullYear()-1;
                    	  		
			                $("#customdateofbirth").live("focus",function() {
			            		$(this).datepicker({
										showOn : "both",
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
			                });
			                $("#expiration_date").datepicker({	
			                	
			                		changeMonth : true,
			                		changeYear : true, 
			                		minDate: new Date(),
			                		dateFormat : '<?php echo $this->General->GeneralDate('HH:II:SS');?>',
			                		showOn : 'button',
			                		buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			                		buttonImageOnly : true,
			                		onSelect : function() {
			                			$(this).focus();
			                		}
			                	});
                
							
		        });
                        url  = "<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","City","name",
            			'null','no','null',"admin" => false,"plugin"=>false)); ?> " ;
            			
                        $("#city").autocomplete(url+"/state_id=" +$('#customstate').val(), {
                    		width: 250,
                    		selectFirst: true, 
                    	});
                    					
                        $("#customstate").live("change",function(){ 

                        	// alert($('#customstate').val());
                    		 $("#city").unautocomplete().autocomplete(url+"/state_id=" +$('#customstate').val(), {
                    			width: 250,
                    			selectFirst: true, 
                    		});
                    	 });
                       
   });
</script>
<script>
    $(document).ready(function() {
      $('.sigPad').signaturePad();
    });
   
 $("#user_photo").live("change",function(){ 
    var ext = $('#user_photo').val().split('.').pop().toLowerCase();
    if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
    	alert('only .gif, .png, .jpg, .jpeg extention files are allowed.');
        $('#user_photo').val("");
    }
 });

 
	/* $("#ssn").focusout(function(){ 
		res=$("#ssn").val();
		count=($("#ssn").val()).length;
		str1=res.substring(0, 4);
		str2=res.substring(4, 8);
		str3=res.substring(8, 12);
		if(count=='12'){
			$("#ssn").val(str1+'-'+str2+'-'+str3);
		}
		if(count=='0'){
			$('#ssn').val("");
		}
	});*/


 	$('#custominitial').change(function(){
		var getInitial=$("#custominitial option:selected").val();
		if(getInitial=='2' || getInitial=='3'){
			$("#customgender").val('F');
			//var getInitial=$("#sex option:selected").val();
		}else if(getInitial=='1' || getInitial=='5') {
			$("#customgender").val('M');
		}else{
			$("#customgender").val('');
		}
	});

	$('#customgender').change(function(){
		var getSex=$("#customgender option:selected").val();
		if(getSex=='F'){
			$("#custominitial").val('2');
		}else if(getSex=='M') {
			$("#custominitial").val('1');
		}else{
			$("#custominitial").val('');
		}
	});

	$('#roletype').change(function (){
		val=$('#roletype').val();
		if(val=='3'){
			$('#fax1').hide();
			$('#fax2').show();
		}else{
			$('#fax1').show();
			$('#fax2').hide();
			}
	});



	 // Function to check that passwords are matching or not
	function getChecked(confirm){
		var password = $("#password").val();
		
	  if(confirm != ''){
		if(password != confirm){
			$("#incorrect").show();
			$("#correct").hide();
		} else {
			$("#incorrect").hide();
			$("#correct").show();
		}
	  } else {		
		$("#incorrect").hide();
		$("#correct").hide();
	  }
	}
	$("#password").focusout(function(){
		var pasLength = $("#password").val().length;
		if(pasLength && pasLength < 8){
			$("#minLength").fadeIn('slow');
		}else{
			$("#minLength , #password_strength_border , #password_description").fadeOut('slow');
		}
	});

	function passwordStrength(password){	
		var pasLength = $("#password").val().length;
		if(pasLength < 8){
			$("#minLength").fadeIn('slow');
		}else{
			$("#minLength").fadeOut('slow');
		}

		if($('#password').val().length=='0'){
			$('#confPassword').attr('readonly', true);
		}else{
			$('#confPassword').attr('readonly', false);
		}
		
		$('#confPassword').val('');
		$("#incorrect").hide();
		$("#correct").hide();
		$("#password_strength_border").show();
		$("#password_description").show();
		
		var desc = new Array();
		desc[0] = "Too short";
		desc[1] = "Weak";
		desc[2] = "Fair";
		desc[3] = "Good";
		desc[4] = "Strong";
		desc[5] = "Not rated";
		
		var points = 0;

		//---- if password is bigger than 4 , give 1 point.
		if (password.length > 4) points++;

		//---- if password has both lowercase and uppercase characters , give 1 point.	
		if ( ( password.match(/[a-z]/) ) && ( password.match(/[A-Z]/) ) ) points++;

		//---- if password has at least one number , give 1 point.
		if (password.match(/\d+/)) points++;

		//---- if password has at least one special caracther , give 1 point.
		if ( password.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/) )	points++;

		//---- if password is bigger than 12 ,  give 1 point.
		if (password.length > 12) points++;

		//---- Showing  description for password strength.
		document.getElementById("password_description").innerHTML = desc[points];
		
		//---- Changeing CSS class.
		document.getElementById("password_strength").className = "strength" + points;
	}
 //BOF-Mahalaxmi -Profit for Primary Care Provider
    
    $('#showDepartmentList').click(function(){     
       var deptName= $( "#departmentid option:selected" ).text(); 
       $('#prof_sharing_dept_name').val(deptName);
       if(deptName == 'Pathology'){
            $("#subSpecialtyTrID").show();
       }else{
            $("#subSpecialtyTrID").hide();
       }
        
    });
//EOF--Mahalaxmi  -Profit for Primary Care Provider
 $(document).ready(function() {
$("#pinCode").blur(function(){
	var zipData = $(this).val(); //alert(zipData);
	var zipCount =	( $(this).val().length); //alert(zipCount);
	if(zipCount == 6){		
		//alert(zipData);
		$.ajax({
        	url: "<?php echo $this->Html->url(array("controller" => 'Persons', "action" => "getStateCity",'admin'=>false)); ?>"+"/"+zipData,
        	context: document.body,
        	
			success: function(data){
				//alert(data);				
				if(data !== undefined && data !== null){					
					data1 = jQuery.parseJSON(data);				
					//console.log(data1.zip);					
					if(data1.zip['State']['id']){
						$('#stateId').val(data1.zip['State']['id']);
						$('#stateName').val(data1.zip['State']['name']);
						$('#city').val(data1.zip['PinCode']['city_name']);
					}
				 }	
			} 
        });
	} else{
		$('#stateId').val("");
		$('#stateName').val("");
		$('#city').val("");
		}
			
	});
 });

 $("#externalCharges").keyup(function(){
		if($(this).val() > 100){
			alert("Percentage should be less than or equal to 100");
			$(this).val("");
			}
		
		var display = 100 - this.value;
		$("#hospitalCharges").val(display);
		
	});

	$("#hospitalCharges").keyup(function(){
		if($(this).val() > 100){
			alert("Percentage should be less than or equal to 100");
			$(this).val("");
			}
		
		var display = 100 - this.value;
		$("#externalCharges").val(display);
	});
 $("#from").datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		minDate: new Date(),
	//	maxDate: new Date(),
		//maxDate: new Date(),
		dateFormat: '<?php echo $this->General->GeneralDate();?>',			
	});	
 /*   $('#location_id').change(function(){
	   var val='';
	$.ajax({
		  url: "<?php echo $this->Html->url(array("controller" =>'users', "action" => "admin_getLocationwiseRole", "admin" => true)); ?>"+"/"+$('#location_id').val(),
		  context: document.body,	
			  		  
		  success: function(data){
		  			data= $.parseJSON(data);
		  			$("#roletype option").remove();
		  			$('#roletype').append( "<option value='"+val+"'>Select Role</option>" );		
					$.each(data, function(val, text) {
					    $("#roletype").append( "<option value='"+val+"'>"+text+"</option>" );
					});
							
		  }
	});			
	
});*/

  </script>
