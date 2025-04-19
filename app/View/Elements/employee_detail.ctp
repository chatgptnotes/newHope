
<table width="100%" border="0" cellspacing="0" cellpadding="0"
	class="formFull">
	<tr>
		<th style="padding-left: 10px;" colspan="4"><?php echo __('Employee Detail');?>
		</th>
	</tr>
	<tr>
		<td width="21%" class="tdLabel"><?php echo __('Clinic Location'); ?><font color="red">*</font></td>
		<td width="30%"><?php echo $this->Form->input('User.location_id', array('empty'=>__('Please Select'),'options'=>$locations,'onChange'=>'getAdmin()',
                    'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'locationId', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));?>
		</td>
        </tr>
	<tr>
		<td width="21%" class="tdLabel">Other Locations</td>
		<td width="30%"><?php echo $this->Form->input('User.other_location_id', array('empty'=>__('Please Select'),'options'=>$locations,'multiple'=>true,
                    'style'=>'height: 63px;','class' => 'textBoxExpnd','id' => 'otherLocationId', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));?>
		</td>
        </tr>
	<tr>
		<td width="21%" class="tdLabel"><?php echo __('Role',true); ?><font  
			color="red">*</font>
		</td>
		<td width="30%"><?php
		if(!in_array($this->Session->read("role_code_name"),Configure::read('allow_doctor')))
			 $doctorRole = array_search('Doctor', $roles);
			  unset($roles[$doctorRole]);
			
		echo $this->Form->input('User.role_id', array('empty' => 'Select Role', 'options' => $roles, 'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd', 'id' => 'roletype',
				'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off',
				'onchange'=> $this->Js->request(array('action' => 'getDepartment', 'superadmin' => false, 'admin' => false),
		          	  array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
		    		  'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#showDepartmentList', 'data' => '{roletype:$("#roletype").val()}', 'dataExpression' => true, 'div'=>false))));
		        ?>
		</td>
	</tr>
	<tr style="display: none;" id="departmentslist">
		<td width="21%" class="tdLabel"><?php echo __('Specialty',true); ?><font
			color="red">*</font>
		</td>
		<?php  if($this->data['User']['id']) { ?>
		<td><?php 
		echo  $this->Form->input('DoctorProfile.department_id', array( 'class'=> 'textBoxExpnd validate[required,custom[mandatory-enter]]', 'options' => $dept, 'id' => 'customdepartments', 'label'=> false, 'div' => false, 'error' => false, 'empty' => 'Select Specialty ','value'=>$this->data['User']['department_id'], 'default' => $getDepartment['DoctorProfile']['department_id']));
		?>
		</td>
		<?php  } else {?>
		<td width="20%" id="showDepartmentList"></td>
		<?php }?>
	</tr>
	<?php if($this->data['User']['sub_specialty']){
		$dispSubSpclty = "display: blank;";
	}else{
		$dispSubSpclty = "display: none;";
	}?>
	
	<tr id="subSpecialtyTrID" style="display: none;">
		<td><?php echo __('Select Sub Specialty:');?></td>
		<td><?php echo $this->Form->input('User.sub_specialty',array('type'=>'select','options'=>$testGroup,'empty' => __ ( 'Select Sub Specialty' ),'id'=>'subSpecialty', 'div'=>false,'label'=>false,'class'=>'textBoxExpnd '));?>
		</td>
	</tr>

	<tr id="subSpecialtyTrID" style="display: none;">
		<td width="21%" class="tdLabel"><?php echo __('Select Sub Specialty:');?>
		</td>
		<td width="30%"><?php echo  $this->Form->input('User.sub_specialty',array('type'=>'select','options'=>$dept,'empty' => __ ( 'Select Sub Specialty' ),'id'=>'subSpecialty', 'div'=>false,'label'=>false,'class'=>'textBoxExpnd '));?>
		</td>
	</tr>
	<tr style="display: none;" id ='Wards'>
		<td width="21%" class="tdLabel">Allocated Ward</td>
		<td width="30%"><?php echo $this->Form->input('User.ward_id', array('empty'=>__('Please Select'),'options'=>$wards,'multiple'=>true,
                    'style'=>'height: 63px;','class' => 'textBoxExpnd','id' => 'wardId', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));?>
		</td>
        </tr>   
	<tr style="display: none;" id="surgeonshow">
		<td width="21%" class="tdLabel"><?php echo __('Surgeon',true); ?>
		</td>
		<td ><?php if(isset($ss['DoctorProfile']['is_surgeon'])){
			$default = $ss['DoctorProfile']['is_surgeon'];
		}else{ $default = '0';
			}
		echo $this->Form->input('DoctorProfile.is_surgeon', array('type' => 'radio','class' => '','label' => false,'legend' => false ,'options' => array('0'=>'No', '1' => 'Yes'), 'default' => $default));
		?>
		</td>
	</tr>
	<tr style="display: none;" id="opdDoctorshow">
		<td width="21%" class="tdLabel"><?php echo __('Need to Allot Chamber',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('DoctorProfile.is_opd_allow', array('type' => 'radio','class' => '','label' => false,'legend' => false ,'options' => array('0'=>'No', '1' => 'Yes'), 'default' => $ss['DoctorProfile']['is_opd_allow']));
                echo $this->Form->input('DoctorProfile.idUpdate', array('type' => 'hidden','value' => $ss['DoctorProfile']['id']));
		?>
		</td>
	</tr>
	<tr style="display: none;" id="doctorshow">
		<td width="21%" class="tdLabel"><?php echo __('Doctor',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('User.is_doctor', array('type' => 'checkbox','class' => '','label' => false,'legend' => false,'checked'=>'checked'));
		?>
		</td>
	</tr>
	 <tr style="display: none;" id="regshow">
		<td width="21%" class="tdLabel"><?php echo __('Registrar',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('DoctorProfile.is_registrar', array('type' => 'checkbox','class' => '','label' => false,'legend' => false,'checked'=>$ss['DoctorProfile']['is_registrar']));
		?>
		</td>
	</tr> 
	<?php  if($this->data['User']['id']) { ?>
	<tr>
		<td width="21%" class="tdLabel"><?php echo __('Username',true); ?><font color="red">*</font>
		</td>
		<td width="30%"><?php 
		  echo $this->Form->input('User.username', array('id' => 'username', 'class'=> 'textBoxExpnd', 'label'=> false/*,'readOnly'=>'readOnly'*/, 'div' => false, 'error' => false,'autocomplete'=>'off'/*,'readonly'=>'readonly'*/));
		?>
		</td>
	</tr>
	<tr>
		<td width="21%" class="tdLabel"><?php echo __('New Password',true); ?>
		</td>
		<td><?php echo $this->Form->input('User.password', array('id' => 'password','class' =>'validate[optional,custom[passwordOnly] textBoxExpnd','label'=> false ,'div' => false,
					'error' => false,'autocomplete'=>'off','value'=>'','onkeyup'=>'passwordStrength(this.value)')); ?>

			<span id="minLength" style="display: none; color: red;">Minimum 8
				Character</span> <br /> <span style="float: left;"><i>(Allowed
					special characters : !*@#$%^&+=~`_-)</i> </span>
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
		<td width="21%" class="tdLabel"><?php echo __('Confirm Password',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('User.conf_password', array('type'=>'password','id' => 'confPassword', 'label'=> false, 'class'=> 'textBoxExpnd validate[optional,custom[mandatory-enter]', 'div' => false, 'error' => false,'autocomplete'=>'off','onkeyup'=>'getChecked(this.value)'));
		echo $this->Html->image('icons/cross.png',array('id'=>'incorrect','style'=>'display:none;'));
		echo $this->Html->image('icons/tick.png',array('id'=>'correct','style'=>'display:none;'));
		?>
		</td>
	</tr>
	<?php } else { ?>
	<tr>
		<td width="21%" class="tdLabel"><?php echo __('Username',true); ?><font
			color="red">*</font>
		</td>
		<td width="30%"><?php  
		echo $this->Form->input('User.username', array('class' => 'validate[required,custom[username],ajax[ajaxUserCall]] textBoxExpnd','id' => 'username', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));
	?>
		</td>
	</tr>

	<tr>
		<td width="21%" class="tdLabel"><?php echo __('Password',true); ?><font
			color="red">*</font>
		</td>
		<td width="30%"><?php

		echo $this->Form->input('User.password', array('id' => 'password','class' =>'textBoxExpnd validate[required,custom[newpassrequired],custom[passwordOnly]',
			'label'=> false ,'div' => false, 'error' => false,'autocomplete'=>'off','value'=>'','onkeyup'=>'passwordStrength(this.value)'));

		?><span id="minLength" style="display: none; color: red;">Minimum 8
				Character</span> <br /> <span style="float: left;"><i>(Allowed
					special characters : !*@#$%^&+=~`_-)</i> </span>
		</td>

		<td width="30%">
			<div id="password_description"></div> <!-- Display password description like very week, better etc.-->
			<div id="password_strength_border" style="display: none;">
				<!-- Used for border only-->
				<div id="password_strength" class="strength0"></div>
				<!-- Display colors using css class -->
			</div>
		</td>
	</tr>

	<tr>
		<td width="21%" class="tdLabel"><?php echo __('Confirm Password',true); ?><font
			color="red">*</font>
		</td>
		<td width="30%"><?php  
		echo $this->Form->input('User.conf_password', array('type'=>'password','id' => 'confPassword', 'label'=> false, 'class'=> 'textBoxExpnd validate[required,custom[confirmpassrequired]', 'div' => false, 'error' => false,'autocomplete'=>'off','onkeyup'=>'getChecked(this.value)'));
		echo $this->Html->image('icons/cross.png',array('id'=>'incorrect','style'=>'display:none;'));
		echo $this->Html->image('icons/tick.png',array('id'=>'correct','style'=>'display:none;'));
		?>
		</td>
	</tr>
	<?php }?>
	<tr>
		<td width="21%" class="tdLabel"><?php echo __('HR Code',true); ?>
		</td>
		<td width="30%">
		<?php 
			echo $this->Form->input('User.hr_code', array('id'=>'hrCode','class'=>'validate[required,custom[mandatory-enter]] textBoxExpnd','label'=>false,'div'=>false,'error'=>false));
		?>
		</td>
	</tr>
	
	<tr>
		<td width="21%" class="tdLabel"><?php echo __('Active',true); ?>
		</td>
		<td width="30%"><?php 
		echo $this->Form->input('User.is_active', array('options' => array('No', 'Yes'), 'id' => 'customis_active', 'default'=>'1','class' => 'textBoxExpnd', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<?php $babyKey = array_search('Baby', $initials); 
         		unset($initials[$babyKey]);?>
	<tr>
		<td width="21%" class="tdLabel"><?php echo __('Initial',true); ?><font
			color="red">*</font>
		</td>
		<td width="30%"><?php echo $this->Form->input('User.initial_id', array('class' => 'validate[required,custom[custominitial]] textBoxExpnd', 'options' => $initials,'empty'=>'Select Prefix', 'id' => 'custominitial', 'label'=> false, 'div' => false, 'error' => false));?>
		</td>
	</tr>
	<tr>
		<td width="21%" class="tdLabel"><?php echo __('First Name',true); ?><font
			color="red">*</font>
		</td>
		<td width="30%"><?php 
		echo $this->Form->input('User.first_name', array('class' => 'validate[required,custom[customfirstname]] textBoxExpnd', 'id' => 'customfirstname', 'label'=> false, 'div' => false, 'error' => false));  //custom[onlyLetterSp],
		?>
		</td>
	</tr>
	<tr>
		<td width="21%" class="tdLabel"><?php echo __('Middle Name',true); ?>
		</td>
		<td width="30%"><?php 
		echo $this->Form->input('User.middle_name', array('id' => 'custommiddlename','class' => 'textBoxExpnd validate["",custom[onlyLetterSp]]', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr>
		<td width="21%" class="tdLabel"><?php echo __('Last Name',true); ?><font
			color="red">*</font>
		</td>
		<td width="30%"><?php 
		echo $this->Form->input('User.last_name', array('class' => 'validate[required,custom[customlastname]] textBoxExpnd', 'id' => 'customlastname', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr>
		<td width="21%" class="tdLabel"><?php echo __('Employee Code',true); ?>
		</td>
		<td width="30%"><?php 
		echo $this->Form->input('HrDetail.employee_id', array('type'=>'text','class'=>'textBoxExpnd','id' =>'employee_id', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr>
		<td width="21%" class="tdLabel"><?php echo __('SMS Alert',true); ?>
		</td>
		<td width="30%"><?php 
		echo $this->Form->checkbox('User.sms_alert',array('id'=>'sms_alert','style'=>'float:left','legend'=>false,'label'=>false));?>
		
		</td>
	</tr>
	<tr>
		<td width="21%" class="tdLabel"><?php echo __('Attendance tracked through this system:',true); ?>
		</td>
		<td width="30%"><?php 
		echo $this->Form->checkbox('User.attendance_track_system', array('style'=>'float:left','legend'=>false,'label'=>false,'class' => 'attendance_track_system'));?>
		</td>
	</tr>
	<?php $date = ($this->data['User']['attendance_track_system']) ? '' : 'display : none'; ?>
	<tr class= 'thumb_impression_registed' style="<?php echo $date;?>">
		<td width="21%" class="tdLabel"><?php echo __('Thumb impression Registered on',true); ?>
		</td>
		<td width="30%"><?php 
		echo $this->Form->input('HrDetail.thumb_impression_registed', array('type'=>'text','class'=>'textBoxExpnd', 'id' => 'thumbregDate', 'style'=>'float: left;', 'label'=> false, 'div' => false, 'error' => false,'readonly' => 'readonly'));
		?>
		</td>
	</tr>
	<tr>
		<td width="21%" class="tdLabel"><?php echo __('Paid through this system',true); ?>
		</td>
		<td width="30%"><?php 
		echo $this->Form->checkbox('User.paid_through_system', array('style'=>'float:left','legend'=>false,'label'=>false,'class' => 'paid_through_system')); ?>
		</td>
	</tr>
        <tr>
		<td width="21%" class="tdLabel"><?php echo __('Account Group',true); ?><font color="red">*</font>
		</td>
		<td width="30%"><?php 
		echo $this->Form->input('User.accounting_group_id', array('id' => 'group_id','type'=>'select','options'=>$group,'value'=>$groupId ,'class' =>'validate[required,custom[mandatory-select]] textBoxExpnd','label'=> false, 'div' => false, 'error' => false,'empty'=>'Please Select'));
		?>
		</td>
	</tr>
	<tr>
		<td width="21%" class="tdLabel"><?php echo __('Address',true); ?>
		</td>
		<td width="30%"><?php 
		echo $this->Form->textarea('User.address1', array('cols' => '2', 'rows' => '2','class'=>'', 'id' => 'customaddress1', 'label'=> false, 'div' => false, 'error' => false,'value' =>$hospAddr['addr1']));
		?>
		</td>
	</tr>
	<tr>
		<td width="21%" class="tdLabel"><?php echo __('Mobile',true); ?><font
			color="red">*</font>
		</td>
		<td width="30%"><?php 
		echo $this->Form->input('User.mobile', array('id' => 'custommobile','maxlength'=>'10', 'label'=> false, 'div' => false, 'error' => false,'class'=> 'textBoxExpnd validate[required,custom[phone,minSize[10]], custom[onlyNumberSp]]'));
		?>
		</td>
	</tr>
	<tr>
		<td width="21%" class="tdLabel"><?php echo __('Email',true); ?>
		</td>
		<td width="30%">(Official) <?php echo $this->Form->input('User.email', array('class' => 'validate[optional,custom[email]] textBoxExpnd','style'=>'width:261px;float:unset','id' => 'customemail', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));?>
		</td>
	</tr>
	<tr>
		<td></td>
		<td width="30%">(Personal) <?php echo $this->Form->input('HrDetail.personal_email', array('class' => 'validate[optional,custom[email]] textBoxExpnd','style'=>'width:251px;float:unset', 'id' => 'customepersonalmail', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));
		?>
			</div>
		</td>
	</tr>
	<tr>
		<td width="21%" class="tdLabel"><?php echo __('Date Of Birth',true); ?>
		</td>
		<td width="30%"><?php 
		echo $this->Form->input('User.dob', array('type'=>'text', 'id' => 'dateofbirth', 'class' => 'textBoxExpnd ', 'label'=> false, 'div' => false, 'error' => false,'readonly' => 'readonly'));
		?>
		</td>
	</tr>
	<tr>
		<td width="21%" class="tdLabel"><?php echo __('Gender',true); ?>
		</td>
		<td width="30%"><?php 
		echo $this->Form->input('User.gender', array('class' => 'textBoxExpnd', 'options' => array('M' => 'Male', 'F' => 'Female'), 'empty' => 'Select Gender', 'id' => 'customgender', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr>
		<td width="21%" class="tdLabel"><?php echo __('Religion',true); ?>
		</td>
		<td width="30%"><?php 
		echo $this->Form->input('HrDetail.religion', array('class' => 'textBoxExpnd', 'id' => 'customgender', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr>
		<td width="21%" class="tdLabel"><?php echo __('Caste',true); ?>
		</td>
		<td width="30%"><?php 
		echo $this->Form->input('HrDetail.caste', array('class' => 'textBoxExpnd', 'id' => 'customgender', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	
	<tr>
		<td width="21%" class="tdLabel"><?php echo __('Is Cash in Transit',true); ?></td>
		<td width="30%">
			<?php echo $this->Form->checkbox('User.cash_in_transit',array('id'=>'cash_in_transit','class'=>''));?>
		</td>
	</tr>
	 <!--<tr>
		<td width="21%" class="tdLabel"><?php //echo __('Is Guarantor',true); ?>
		</td>
		<td width="30%"><?php 
		//echo $this->Form->checkbox('User.is_guarantor',array('id'=>'is_guarantor','class'=>''));
		?>
		</td>
	</tr>
       
	<tr>
		<td width="21%" class="tdLabel"><?php //echo __('Is Authorized for discount',true); ?>
		</td>
		<td width="30%"><?php 
		//echo $this->Form->checkbox('User.is_authorized_for_discount',array('id'=>'is_authorized_for_discount','class'=>''));
		?>
		</td>
	</tr>
	-->
</table> 
<div style="padding-top: 10px;" align="right">
	<?php echo $this->Html->link(__('Cancel', true),array('action' => 'index','?' => array('newUser'=>'ls')), array('escape' => false,'class'=>'blueBtn')); ?>
	<input type="submit" value="Submit" class="blueBtn" id="submit">
</div>
<script>
$(document).ready(function(){
    jQuery(".forOthers").show();//class created in hr_qualification element
    $(".forDoctor").hide();//class created in Pay Details element
    $(".forOthers").show();//class created in Pay Details element
    $('.otherPayDetail').attr('disabled',false);
    $('.DoctorPayDetail').attr('disabled',true); 
	
//  click on  capture fingerprint it save the user data & redirect to finger_print page,by pankaj
	$('#capturefingerprint').click(function() {
		var input = $("<input>").attr("type", "hidden").attr("name", "data[User][capturefingerprint]").val("1");
		$('#userfrm').append($(input));
		$('#userfrm').submit();
	});

	$('#submit').click(function() { 
		$("#username").removeClass("validate[required,custom[username],ajax[ajaxUserCall]]");
		var validatePerson = jQuery("#userfrm").validationEngine('validate');
		if(validatePerson) {
			if(validateHrCode($("#hrCode").val()) == true){
				$('#submit').hide();
				return true;
			}else{
				return false;
			}
		}
	<?php  if(empty($this->request->data)){ ?>
				$("#username").addClass("validate[required,custom[username],ajax[ajaxUserCall]]");
		<?php } ?> 
		});

	$('#customdepartments').click(function(){ 
	    var deptName= $( "#customdepartments option:selected" ).text(); 
	    $('#prof_sharing_dept_name').val(deptName);
	    /*if(deptName == 'Pathology'){
	         $("#subSpecialtyTrID").show();
	    } else if(deptName == 'DMO'){
	    	 $(".forDoctor").hide();//class created in Pay Details element
	         $(".forOthers").show();//class created in Pay Details element
	         $('.otherPayDetail').attr('disabled',false);
	         $('.DoctorPayDetail').attr('disabled',true); 
	    }else{
	         $("#subSpecialtyTrID").hide();
	         //$(".forDoctor").show();//class created in Pay Details element
	         //$(".forOthers").hide();//class created in Pay Details element
	        // $('.otherPayDetail').attr('disabled',true);
	         //$('.DoctorPayDetail').attr('disabled',false); 
	    }*/  
	    $(".forDoctor").hide();//class created in Pay Details element
        $(".forOthers").show();//class created in Pay Details element
        $('.otherPayDetail').attr('disabled',false);
        $('.DoctorPayDetail').attr('disabled',true); 
	 });
	 
});		
var roletype = $('#roletype').val(); 

 
		
if(roletype && (jQuery("#roletype option:selected").text() == "<?php echo Configure::read('doctorLabel') ?>"   || jQuery("#roletype option:selected").text() == "consultant"   || jQuery("#roletype option:selected").text() == "<?php Configure::read('RegistrarLabel'); ?>" || jQuery("#roletype option:selected").text() == "registrar")) {
 var data = 'roletype=' + roletype ; 
 $.ajax({
	 url: "<?php echo $this->Html->url(array("controller" => "users", "action" => "getDepartment", "admin" => false)); ?>",
	 type: "GET",
	 data: data,
	 success:   function (html) { 
		 $('#departmentslist').show();
		 $('#showDepartmentList').html(html); 
		 } 
	});
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

$('#showDepartmentList').click(function(){ 
	
    var deptName= $( "#departmentid option:selected" ).text(); 
    $(".forOthers").show();//class created in Pay Details element
    $('#prof_sharing_dept_name').val(deptName);
    if(deptName == 'Pathology'){
         $("#subSpecialtyTrID").show();
    } /*else if(deptName == 'DMO'){   
     $(".forOthers").show();//class created in Pay Details element
    	 $(".forDoctor").hide();//class created in Pay Details element
     
         $('.otherPayDetail').attr('disabled',false);
         $('.DoctorPayDetail').attr('disabled',true); 
    }else*/{
         $("#subSpecialtyTrID").hide();  
         $(".forOthers").show();//class created in Pay Details element
        /* $(".forDoctor").show();//class created in Pay Details element
       
         $('.otherPayDetail').attr('disabled',true);
         $('.DoctorPayDetail').attr('disabled',false); */
    }  
 });
 
$("#dateofbirth").datepicker({
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
$("#thumbregDate").datepicker({
	showOn: "both",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	yearRange: '1950',
	maxDate: new Date(),
	dateFormat:'<?php echo $this->General->GeneralDate();?>',		
});
$('.attendance_track_system').click(function(){	
	if($(".attendance_track_system").is(':checked')){	
	$('.thumb_impression_registed').show();
	
		}else{
		$('.thumb_impression_registed').hide();
		$('#thumbregDate').val('');
	}
});
function getAdmin(){
    if($('#locationId').val() != '')
        $.ajax({
            url: "<?php echo $this->Html->url(array("controller" => "users", "action" => "getAdmin", "admin" => false)); ?>"+'/'+$('#locationId').val(),
            type: "GET",
            data: data,
            beforeSend:function(){
                   $('#busy-indicator').show();		
               },
            success:   function (data) { 
                data = jQuery.parseJSON(data);
                $("#roletype option:contains('<?php echo Configure::read('adminLabel'); ?>')").remove();//remove admin if already is there
                if(data.name == '<?php echo Configure::read('adminLabel'); ?>') // add admin it selected admin does not have it
                $("#roletype").append(new Option( data.name , data.id ));
                $('#busy-indicator').hide();
           } 
       });
    }
jQuery(document).ready(function(){  
      var roleName= $( "#roletype option:selected" ).text(); 
     // var role = $("#roletype").val();
    //  getHrCode(roleName,role); //get hr code by amit jain
      
      if('<?php echo Configure::read('adminLabel') ?>' == '<?php echo $this->data['Role']['name'] ?>'){
          $("#roletype").append(new Option( '<?php echo Configure::read('adminLabel') ?>' , '<?php echo $this->data['Role']['id'] ?>' )).val('<?php echo $this->data['Role']['id'] ?>');
      }      
      if(roleName== '<?php echo Configure::read('doctorLabel') ?>'){
	       $('#specialty').show();
	       $('#surgeonshow ').show();
	       $('.profitsharingshow').show();
	       $('#opdDoctorshow').show();
	      $('#regshow').show();
	       $('#doctorshow').show();
	       $('.profitsharingsconsultant').show();
	       //$(".forDoctor").show();//class created in Pay Details element
               $(".forOthers").show();//class created in Pay Details element
               //jQuery('.otherPayDetail').attr('disabled',true);
               jQuery('.DoctorPayDetail').attr('disabled',false);
               jQuery(".showDoctor").show();//class created in hr_qualification element
               jQuery(".docreg_no").attr('disabled',false);
               jQuery(".dr_is_scan_uplode").attr('disabled',false);
               jQuery(".showNurse").hide();//class created in hr_qualification element
               jQuery('.nursereg_no').attr('disabled',true);
               jQuery('.nurse_is_scan_uplode').attr('disabled',true);
      } else if(roleName == "<?php echo Configure::read('nurseLabel') ?>"){
    			$('.showNurse').show(); 
      }else{
   	   $('#specialty').hide();
	       $('#surgeonshow').hide();
	       $('.profitsharingshow').hide();
	       $('#opdDoctorshow').hide();
	      $('#regshow').hide();
	       $('#doctorshow').hide();
	       $('.profitsharingsconsultant').hide();
               //$(".forDoctor").hide();//class created in Pay Details element
               $(".forOthers").show();//class created in Pay Details element
               jQuery('.otherPayDetail').attr('disabled',false);
               jQuery('.DoctorPayDetail').attr('disabled',true);
      }

      
            jQuery("#roletype").change(function(){ 
            /* if($("#location_id").val()==''){
            alert("Please Select Location");
            $('#roletype').val(0); 
            }*/ 
            selectedRole = jQuery("#roletype option:selected").text() ;
           // var role = $("#roletype").val();
           // getHrCode(selectedRole,role); //get hr code by amit jain
            jQuery(".forDoctor").hide();//class created in Pay Details element
            jQuery(".forOthers").show();//class created in Pay Details element
            jQuery('.otherPayDetail').attr('disabled',false);
            jQuery('.DoctorPayDetail').attr('disabled',true); 
            jQuery("input[name='data[User][is_doctor]']").attr('checked',false);
           // jQuery("#DoctorProfileIsRegistrar").checked(false);
            if((selectedRole == "<?php echo Configure::read('doctorLabel') ?>"   || selectedRole == "<?php echo Configure::read('RMOLabel'); ?>" || selectedRole == "<?php echo Configure::read('MaushiLabel'); ?>"   || selectedRole == "<?php echo Configure::read('WardboyLabel'); ?>")) {
 				 jQuery("#Wards").show();
		 		}else{
		 			 jQuery("#Wards").hide();
		 		}
		       		
            if(selectedRole == '<?php echo Configure::read("doctorLabel") ?>' || selectedRole.toLowerCase() == "consultant") { 
	                 $('#custominitial').val(4);
	                 $('#customgender').val('');
	                jQuery("#surgeonshow").show();
	                jQuery("#opdDoctorshow").show();
	                jQuery("#regshow").show();
	                jQuery("#doctorshow").show();
	                jQuery("#UserIsDoctor").attr('checked',true); 
	                jQuery(".profitsharingshow").show();						        
	                jQuery("#direct_email").show();
	                jQuery("#departmentslist").show();
	                jQuery(".profitsharingsconsultant").show();
	                jQuery("#is_registrar").val("0");
	                jQuery(".showDoctor").show();//class created in hr_qualification element
	                jQuery(".showNurse").hide();//class created in hr_qualification element
	                jQuery(".forDoctor").show();//class created in Pay Details element
	                //jQuery('.otherPayDetail').attr('disabled',true);
	                jQuery('.DoctorPayDetail').attr('disabled',false);
	                jQuery(".forOthers").show();//class created in Pay Details element
		           
              } else if(selectedRole == "<?php echo Configure::read('RegistrarLabel'); ?>") {
            	$('#custominitial').val('');
            	 $('#customgender').val('');
                jQuery("#departmentslist").show();
                jQuery("#direct_email").show();
                jQuery("#is_registrar").val("1");
                jQuery(".showDoctor, .showNurse").hide();//class created in hr_qualification element
                jQuery(".forDoctor").toggle();//class created in Pay Details element
               // jQuery('.otherPayDetail').attr('disabled',true);
                jQuery('.DoctorPayDetail').attr('disabled',false);
            }else if(selectedRole == "<?php echo Configure::read('nurseLabel'); ?>") { 
            	$('#custominitial').val('');
           	 $('#customgender').val('');
                jQuery(".showNurse").show();//class created in hr_qualification element
                jQuery(".showDoctor").hide();//class created in hr_qualification element
                jQuery("#surgeonshow").hide();
                jQuery("#opdDoctorshow").hide();
                jQuery("#regshow").hide();
                jQuery("#doctorshow").hide();
 	        } else {
            	$('#custominitial').val('');
           	    $('#customgender').val('');
                jQuery("#surgeonshow").hide();
                jQuery("#opdDoctorshow").hide();
               jQuery("#regshow").hide();
                jQuery("#doctorshow").hide();
                jQuery(".profitsharingshow").hide();                                
                jQuery("#departmentslist").hide();
                jQuery("#direct_email").hide();
                jQuery(".profitsharingsconsultant").hide();
                jQuery(".showDoctor, .showNurse").hide();//class created in hr_qualification element                                                
            }
	});
	$('#departmentid').on('change', function(){ 
		$('#departmentid').html(jQuery("#departmentid option:selected").text());	
	});
});
var roleName= $( "#roletype option:selected" ).text(); 
if((roleName == "<?php echo Configure::read('doctorLabel') ?>"  || roleName == "<?php echo Configure::read('RMOLabel'); ?>"  || roleName == "<?php echo Configure::read('MaushiLabel'); ?>"   || roleName == "<?php echo Configure::read('WardboyLabel'); ?>")) {
	 jQuery("#Wards").show();
	}else{
		 jQuery("#Wards").hide();
	}

 $('#custominitial').change(function(){
						var getInitial=$("#custominitial option:selected").val(); 
						if( getInitial=='2' || getInitial=='3'){
							$("#customgender").val('F');
						}else if(getInitial=='1') {
							$("#customgender").val('M');
						}else if(getInitial=='3') {
							$("#customgender").val('F');
						}else if(getInitial=='4'){
							$("#customgender").val('');
						}else{
							$("#customgender").val('');
							}
					});				

// Function to check that passwords are matching or not
function getChecked(confirm){
    $('#confPassword').validationEngine('hide');
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


// function return hrCode by user role-----amit jain
//function getHrCode(roleName,roleId){
	//$.ajax({
		  //url: "<?php //echo $this->Html->url(array("controller"=>'Users',"action"=>"getHrCode","admin"=>false)); ?>"+"/"+roleName+"/"+roleId,
		 // context: document.body,	
		 //beforeSend:function(){
		    // this is where we append a loading image
		    //$('#busy-indicator').show('fast');
			//}, 	  		  
		 // success: function(data){
			//$('#busy-indicator').hide('slow');
		  	//myData= $.parseJSON(data);
			 //	$("#hrCode").val(myData);
		//  }
	//	});
//}

$(document).on('blur','#hrCode',function(){
	validateHrCode($("#hrCode").val());
});

function validateHrCode(hrCode){
	var toReturn = true;
	$.ajax({
	  url: "<?php echo $this->Html->url(array("controller"=>'Users',"action"=>"ajaxValidateEmployeeId","admin"=>false)); ?>"+"/"+hrCode+"/"+"<?php echo $userId;?>",
	  context: document.body,	
	 	beforeSend:function(){
	    	$('#busy-indicator').show('fast');
		},
		async : false,
	 success: function(data){
		$('#busy-indicator').hide('slow');
	  	myData= $.parseJSON(data);
	  	if(myData >= '1'){
	  		$('#hrCode').validationEngine('showPrompt', 'This HR Code is already taken', 'text', 'topLeft', true);
	  		toReturn = false;
	  	}
	 }
   });
   return toReturn;
}
$('#hrCode').keyup( function() {
	if (/[^0-9\.]/g.test(this.value)){
     	this.value = this.value.replace(/[^0-9\.]/g,'');
    }
});
</script>