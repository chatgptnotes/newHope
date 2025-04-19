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
	width: 177px !important;
}
</style>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Edit User', true); ?>
	</h3>
</div>
<?php //echo'<pre>';print_r($this->data['Role']);?>
<?php //debug($userData['User']);
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
<?php 
$this->data["User"]["dob"] = $this->DateFormat->formatDate2Local($data['User']['dob'],Configure::read('date_format'));
$this->data['User']['expiary_date'] = $this->DateFormat->formatDate2Local($data['User']['expiary_date'],Configure::read('date_format'), true);
$this->data['User']['expiration_date'] = $this->DateFormat->formatDate2Local($data['User']['expiration_date'],Configure::read('date_format'), false);
?>
<!-- <form name="userfrm" type="file" id="userfrm" action="<?php echo $this->Html->url(array("controller" => "users", "action" => "edit", "admin" => true)); ?>" method="post" >-->
<?php echo $this->Form->create('User',array('autocomplete'=>"off",'type' => 'file','name'=>'userfrm','id'=>'userfrm','inputDefaults' => array('label' => false, 'div' => false, 'error' => false	))); ?>
<?php echo $this->Form->input('User.id', array('type' => 'hidden')); ?>
<?php if($this->data['Role']['name'] == "registrar" || $this->data['Role']['name'] == "Registrar") {?>
<?php echo $this->Form->input('DoctorProfile.is_registrar', array('type' => 'hidden', 'value' => '1', 'id' => 'is_registrar', 'label'=> false, 'div' => false, 'error' => false)); ?>
<?php } ?>

<table border="0" class="table_format" cellpadding="0"	cellspacing="0" width="100%" align="center">
<tr>
<td valign="top" width="50%">
<table border="0" class="table_format" cellpadding="0"
	cellspacing="0" width="100%" align="center">
	<?php 
	// if(strtolower($this->data['Role']['name']) == strtolower(Configure::read('doctor'))  || $this->data['Role']['name'] == "admin" || $this->data['Role']['name'] == "Registrar") {?>
	<!-- <tr>
		<td width="36%" class="form_lables"><?php echo __('Role',true); ?><font
			color="red">*</font>
		</td>
		<td width="56%"><input type="text" class="textBoxExpnd"
			name="data[User]rolename"
			value="<?php echo ucfirst($this->data['Role']['name']); ?>" readonly />
			<input type="hidden" class="textBoxExpnd" name="data[User][role_id]"
			value="<?php echo $this->data['User']['role_id'] ?>" />
			
			
		</td>
	</tr> 
	
	<tr>
		<td class="form_lables"><?php echo __('Specialty',true); ?><font
			color="red">*</font></td>
		<td><?php 
		echo $this->Form->input('DoctorProfile.department_id', array( 'class'=> 'textBoxExpnd validate[required,custom[mandatory-enter]]', 'options' => $departments, 'id' => 'customdepartments', 'label'=> false, 'div' => false, 'error' => false, 'empty' => 'Select Specialty ', 'default' => $getDepartment['DoctorProfile']['department_id']));
		?>
		</td>
	</tr> -->
	<?php /*if(strtolower($this->data['Role']['name']) == strtolower(Configure::read('doctor'))) {  ?>
		<tr id="surgeonshow">
		<td class="form_lables"><?php echo __('Surgeon',true); ?>
		</td>
		<td id="showDepartmentList"><?php  if(isset($ss['DoctorProfile']['is_surgeon'])){
			$default = $ss['DoctorProfile']['is_surgeon'];
		}else{ $default = '0';
}
		echo $this->Form->input('DoctorProfile.is_surgeon',array('type' => 'radio','label' => false,'legend' => false ,'options' => array('0'=>'No', '1' => 'Yes'), 'default' =>$default));
		?> <?php echo $this->Form->hidden('DoctorProfile.idUpdate',array('value'=> $ss['DoctorProfile']['id']));?>
		</td>
		</tr>
		<tr class="profitsharingshow">
		<td class="form_lables"><?php echo __('Profit Sharing',true); ?>
		</td>
		<td><?php
		echo $this->Form->input('User.profit_sharing', array('type' => 'text','class' => 'textBoxExpnd','label' => false,'legend' => false ,'id'=>'profit_sharing','style'=>"width:50px; float:left;margin-right:3px;",'maxlength'=>'3'));
		?><span style="float:left;">% of receipts</span>
		<?php
		echo $this->Form->input('User.prof_sharing_dept_name', array('type' => 'text','class' => '','label' => false,'legend' => false ,'id'=>'prof_sharing_dept_name','style'=>"float:left; margin:0 5px;"));
		?><span style="float:left;">Department.</span>
		</td>
		<td>
		</td>
		</tr>
	<?php } */?>
	<?php //} ?>
	
	<tr>
		<td class="form_lables"><?php echo __('Clinic Location',true); ?><font
			color="red">*</font>
		</td>
		<td><?php 
		echo $this->Form->input('User.location_id', array('empty'=>__('Please Select'),'options'=>$locations,'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'location_id', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Role',true); ?><font
			color="red">*</font>
		</td>
		<td ><?php 
		echo $this->Form->input('User.role_id', array('empty' => 'Select Role', 'options' => $roles, 'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd', 'id' => 'roletype',
		          	 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off',
		          	 'onchange'=> $this->Js->request(array('action' => 'getDepartment', 'superadmin' => false, 'admin' => false),
		          	  array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
		    		  'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#showDepartmentList1', 'data' => '{roletype:$("#roletype").val()}', 'dataExpression' => true, 'div'=>false))));
		        ?>
		</td>
	</tr>
	<tr id="specialty" style="display: none;">
		<td class="form_lables"><?php echo __('Specialty',true); ?><font
			color="red">*</font></td>
		<td><?php 

		echo $this->Form->input('DoctorProfile.department_id', array( 'class'=> 'textBoxExpnd validate[required,custom[mandatory-enter]]', 'options' => $dept, 'id' => 'customdepartments', 'label'=> false, 'div' => false, 'error' => false, 'empty' => 'Select Specialty ','value'=>$this->data['User']['department_id'], 'default' => $getDepartment['DoctorProfile']['department_id']));
		?>
		</td>
	</tr>
	<?php if($this->data['User']['sub_specialty']){
		$dispSubSpclty = "display: blank;";
	}else{
		$dispSubSpclty = "display: none;";
	}?>
	<tr id="subSpecialtyTrID" style="<?php echo $dispSubSpclty?>">
		<td><?php echo __('Select Sub Specialty:');?></td>
		<td><?php echo $this->Form->input('User.sub_specialty',array('type'=>'select','options'=>$testGroup,'empty' => __ ( 'Select Sub Specialty' ),'id'=>'subSpecialty', 'div'=>false,'label'=>false,'class'=>'textBoxExpnd ','value'=>$this->data['User']['sub_specialty']));?>
		</td>
	</tr>
	<tr id="surgeonshow" style="display: none;">
		<td class="form_lables"><?php echo __('Surgeon',true); ?>
		</td>
		<td id="showDepartmentList"><?php  if(isset($ss['DoctorProfile']['is_surgeon'])){
			$default = $ss['DoctorProfile']['is_surgeon'];
		}else{ $default = '0';
			}
			echo $this->Form->input('DoctorProfile.is_surgeon',array('type' => 'radio','label' => false,'legend' => false ,'options' => array('0'=>'No', '1' => 'Yes'), 'default' =>$default));
			?> <?php echo $this->Form->hidden('DoctorProfile.idUpdate',array('value'=> $ss['DoctorProfile']['id'])); ?>
		</td>
	</tr>
	<tr style="display: none;" id="opdDoctorshow">
		<td class="form_lables"><?php echo __('Need to Allot Chamber',true); ?>
		</td>
		<td><?php 
		
		echo $this->Form->input('DoctorProfile.is_opd_allow', array('type' => 'radio','class' => '','label' => false,'legend' => false ,'options' => array('0'=>'No', '1' => 'Yes'), 'default' => $ss['DoctorProfile']['is_opd_allow']));
		?>
		</td>
	</tr>
	<tr style="display: none;" id="doctorshow">
		<td class="form_lables"><?php echo __('Doctor',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('User.is_doctor', array('type' => 'checkbox','class' => '','label' => false,'legend' => false));
		?>
		</td>
	</tr>
	<tr style="display: none;" id="regshow">
		<td class="form_lables"><?php echo __('Registrar',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('DoctorProfile.is_registrar', array('type' => 'checkbox','class' => '','label' => false,'legend' => false,'checked'=>$ss['DoctorProfile']['is_registrar']));
		?>
		</td>
	</tr>
	<!--<tr class="profitsharingshow" style="display: none;">
		<td class="form_lables"><?php echo __('Profit Sharing',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('User.profit_sharing', array('type' => 'text','class' => 'textBoxExpnd','label' => false,'legend' => false ,'id'=>'profit_sharing','style'=>"width:50px; float:left;margin-right:3px;",'maxlength'=>'3'));
		?><span style="float: left;">% of receipts</span> <?php
		echo $this->Form->input('User.prof_sharing_dept_name', array('type' => 'text','class' => '','label' => false,'legend' => false ,'id'=>'prof_sharing_dept_name','style'=>"float:left; margin:0 5px;"));
		?><span style="float: left;">Department.</span>
		</td>
		<td></td>
	</tr>-->
	<?php if($this->Session->read('website.instance')=='kanpur'){?>
	<!-- for accounting sharing doctor percentage by amit jain -->
	<?php $consultantData = unserialize($this->data['User']['doctor_commision']); ?>
	<tr style="display: none;" class="profitsharingsconsultant">
		<td class="form_lables"><?php echo __('Doctor Commission',true); ?></td>
		<td>
			<span style="float:left;"><?php echo __('External Charges (%) '); ?></span>
			<?php echo $this->Form->input('Service.external_charges', array('value'=>$consultantData['external_charges'],'type' => 'text','class' => 'textBoxExpnd','label' => false,'legend' => false ,'id'=>'externalCharges','style'=>"width:50px;",'maxlength'=>'3'));?>
			<span style="float:left;"><?php echo __('Hospital Charges (%) '); ?></span>
			<?php echo $this->Form->input('Service.hospital_charges', array('value'=>$consultantData['hospital_charges'],'type' => 'text','class' => 'textBoxExpnd','label' => false,'legend' => false ,'id'=>'hospitalCharges','style'=>"width:50px;",'maxlength'=>'3'));?>
			<span style="float:left;"><?php echo __('From:'); ?></span>
			<?php echo $this->Form->input('Service.from', array('value'=>$consultantData['from'],'class'=>'validate[required,custom[mandatory-enter]] textBoxExpnd','style'=>'width:75px','id'=>'from','label'=> false, 'div' => false, 'error' => false,'placeholder'=>'From','autocomplete'=>'off'));?>
		</td>	
	</tr>
	 <?php }?>
	<tr>
		<td class="form_lables"><?php echo __('Username',true); ?><font
			color="red">*</font>
		</td>
		<td><?php 
		echo $this->Form->input('User.username', array('id' => 'username', 'class'=> 'textBoxExpnd validate[required,custom[mandatory-enter]]', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off','readonly'=>'readonly'));
		?>
		</td>
		<td>&nbsp;</td>
	</tr>
	<!-- <tr>
		<td class="form_lables"><?php //echo __('Hospital Location',true); ?><font color="red">*</font>
		</td>
		<td><?php 
		//echo $this->Form->input('User.second_location_id', array('empty'=>__('Please Select'),'options'=>$locations,'class' => 'textBoxExpnd validate[required,custom[mandatory-select]]','id' => 'second_location_id', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));
		?>
		</td>
	</tr> -->
	<tr>
		<td class="form_lables"><?php echo __('New Password',true); ?>
		</td>
		<td><?php //onkeyup='password_strength(this.value)' 
		
		
		if($this->Session->read('website.instance')=='kanpur'){
		   echo $this->Form->input('User.password', array('id' => 'password','class' =>'validate[optional,custom[mandatory-enter] textBoxExpnd','label'=> false ,'div' => false,
					 'error' => false,'autocomplete'=>'off','value'=>'','onkeyup'=>'passwordStrength(this.value)'));
		}
		else
		{
			echo $this->Form->input('User.password', array('id' => 'password','class' =>'validate[optional,custom[passwordOnly] textBoxExpnd','label'=> false ,'div' => false,
					'error' => false,'autocomplete'=>'off','value'=>'','onkeyup'=>'passwordStrength(this.value)'));
		}


		?><span id="minLength" style="display: none; color: red;">Minimum 8
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
		<td class="form_lables"><?php echo __('Confirm Password',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('User.conf_password', array('type'=>'password','id' => 'confPassword', 'label'=> false, 'class'=> 'textBoxExpnd validate[optional,custom[mandatory-enter]', 'div' => false, 'error' => false,'autocomplete'=>'off','onkeyup'=>'getChecked(this.value)'));
		echo $this->Html->image('icons/cross.png',array('id'=>'incorrect','style'=>'display:none;'));
		echo $this->Html->image('icons/tick.png',array('id'=>'correct','style'=>'display:none;'));
		?>
		</td>
	</tr>
	<?php if($emer && $emer == 'emer'){ ?>
	<tr>
		<td class="form_lables"><?php echo __('Expiry Date',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('User.expiary_date', array('class' => ' textBoxExpnd', 'type'=>'text', 'readonly'=>'readonly','id' => 'expiary_date', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));
		?>
		</td>
	</tr>
	<?php } ?>
	<tr>
		<td class="form_lables"><?php echo __('Email',true); ?></td>
		<td><?php 
		echo $this->Form->input('User.email', array('class' => 'validate[optional,custom[email]] textBoxExpnd', 'id' => 'customemail', 'label'=> false, 'div' => false, 'error' => false ));
		?>
		</td>
	</tr>
	<?php //debug($this->data);
	 if(strtolower($this->data['Role']['name']) == strtolower(Configure::read('doctor'))) {  ?>
	<tr>
		<td class="form_lables"><?php echo __('Direct Email',true); ?></td>
		<td><?php 
		echo $this->Form->input('User.direct_email', array('class' => 'validate[optional,custom[email]] textBoxExpnd', 'id' => 'direct_email', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));
		?>
		</td>
	</tr>
	<?php }?>
	 	<?php $mrKey = array_search('Baby', $initials); $masterKey = array_search('Master', $initials); $missKey = array_search('Miss', $initials); 
              unset($initials[$mrKey],$initials[$masterKey],$initials[$missKey]);?>
	<tr>
		<td class="form_lables"><?php echo __('Initial',true); ?><font
			color="red">*</font></td>
		<td><?php 
		echo $this->Form->input('User.initial_id', array('class' => 'validate[required,custom[custominitial]] textBoxExpnd', 'options' => $initials,'empty'=>'Select Prefix', 'id' => 'custominitial', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('First Name',true); ?><font
			color="red">*</font>
		</td>
		<td><?php 
		echo $this->Form->input('User.first_name', array('class' => 'validate[required,custom[customfirstname]] textBoxExpnd ', 'id' => 'customfirstname', 'label'=> false, 'div' => false, 'error' => false));   //validate[required,custom[onlyLetterSp]]
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Middle Name',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('User.middle_name', array('id' => 'custommiddlename', 'class'=> 'textBoxExpnd validate["",custom[onlyLetterSp]]', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Last Name',true); ?><font
			color="red">*</font>
		</td>
		<td><?php 
		echo $this->Form->input('User.last_name', array('class' => 'validate[required,custom[customlastname]] textBoxExpnd', 'id' => 'customlastname', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<?php if(strtolower($this->data['Role']['name']) == strtolower(Configure::read('doctor'))) {  ?>
	<tr id="shownpi">
		<td class="form_lables"><?php echo __('NPI',true); ?>
		</td>
		<td><?php  if(isset($ss['User']['npi']))
		{
			$default = $ss['User']['npi'];
		}else{ $default = '0';
			}
			echo $this->Form->input('User.npi', array('type' => 'text', 'id'=>'npi', 'class'=> 'textBoxExpnd','label' => false,'legend' => false,'value'=>$userData['User']['npi']));
			?> <input type="hidden" name="data[DoctorProfile][id]"
			value="<?php echo $ss['User']['id'] ?>" />
		</td>
	</tr>

	<tr id="showdea">
		<td class="form_lables"><?php echo __('Dea #',true); ?>
		</td>
		<td><?php  if(isset($ss['User']['dea']))
		{
			$default = $ss['User']['dea'];
		}else{ $default = '0';
			}
			echo $this->Form->input('User.dea', array('type' =>'text', 'id'=>'dea', 'class'=> 'textBoxExpnd ','label' => false,'legend' => false,'value'=>$userData['User']['dea'] ));
			?> <input type="hidden" name="data[User][id]"
			value="<?php echo $ss['User']['id'] ?>" />
		</td>
	</tr>


	<tr id="showdea">
		<td class="form_lables"><?php echo __('UPIN #',true); ?>
		</td>
		<td><?php  if(isset($ss['User']['upin']))
		{
			$default = $ss['User']['upin'];
		}else{ $default = '0';
			}
			echo $this->Form->input('User.upin', array('type' =>'text', 'id'=>'upin', 'class'=> 'textBoxExpnd','label' => false,'legend' => false,'value'=>$userData['User']['upin'] ));
			?> <input type="hidden" name="data[User][id]"
			value="<?php echo $ss['User']['id'] ?>" />
		</td>
	</tr>

	<!-- <tr id="showdea">
		<td class="form_lables"><?php echo __('State ID',true); ?>
		</td>
		<td ><?php  if(isset($ss['User']['state']))
			{
				$default = $ss['User']['state'];
			}else{ $default = '0';
			}
	echo $this->Form->input('User.state', array('type' =>'text', 'id'=>'state', 'class'=> 'textBoxExpnd','label' => false,'legend' => false,'value'=>$userData['User']['state'] ));
	?> <input type="hidden" name="data[User][id]"
			value="<?php echo $ss['User']['id'] ?>" />
		</td>
	</tr>
	 -->


	<tr id="showcaqh_provider_id">
		<td class="form_lables"><?php echo __('CAQH Provider ID',true); ?>
		</td>
		<td><?php  if(isset($ss['User']['caqh_provider_id']))
		{
			$default = $ss['User']['caqh_provider_id'];
		}else{ $default = '0';
			}

			echo $this->Form->input('User.caqh_provider_id', array('type' =>'text', 'id'=>'caqh_provider_id', 'class'=> 'textBoxExpnd','label' => false,'legend' => false,'value'=>$userData['User']['caqh_provider_id'] ));
			?> <input type="hidden" name="data[User][id]"
			value="<?php echo $ss['User']['id'] ?>" />
		</td>
	</tr>

	<tr id="showenrollment_status">
		<td class="form_lables"><?php echo __('Provider credentialing and enrollment applications status',true); ?>
		</td>
		<td><?php  if(isset($ss['User']['enrollment_status']))
		{
			$default = $ss['User']['enrollment_status'];
		}else{ $default = '0';
			}

			//debug($userData);
			echo $this->Form->input('User.enrollment_status', array('options'=>Configure::read('enrollment_status'),'label' => false, 'id'=>'enrollment_status', 'class'=> 'textBoxExpnd','legend' => false, 'value'=>$userData['User']['enrollment_status'] ));
			?> <input type="hidden" name="data[User][id]"
			value="<?php echo $ss['User']['id'] ?>" />
		</td>
	</tr>

	<tr id="showenrollment_status">
		<td class="form_lables"><?php echo __('Licensure Type',true); ?>
		</td>
		<td><?php  if(isset($ss['User']['licensure_type']))
		{
			$default = $ss['User']['licensure_type'];
		}else{ $default = '0';
			}
			echo $this->Form->input('User.licensure_type', array('options'=>$licenture,'empty' => 'Please Select Type', 'class' => 'textBoxExpnd', 'id' => 'licensure_type', 'label'=> false, 'div' => false, 'error' => false));
			//echo $this->Form->input('User.licensure_type', array('options'=>Configure::read('licensure_type'),'label' => false, 'id'=>'licensure_type', 'class'=> 'textBoxExpnd','legend' => false,'value'=>$userData['User']['licensure_type'] ));
			?> <input type="hidden" name="data[User][id]"
			value="<?php echo $ss['User']['id'] ?>" />
		</td>
	</tr>

	<tr id="showenrollment_status">
		<td class="form_lables"><?php echo __('Licensure no',true); ?>
		</td>
		<td><?php  if(isset($ss['User']['licensure_no']))
		{
			$default = $ss['User']['licensure_no'];
		}else{ $default = '0';
			}
			echo $this->Form->input('User.licensure_no', array('type' =>'text','id'=>'licensure_no','class'=> 'textBoxExpnd', 'label' => false,'legend' => false,'value'=>$userData['User']['licensure_no'] ));
			?> <input type="hidden" name="data[User][id]"
			value="<?php echo $ss['User']['id'] ?>" />
		</td>
	</tr>

	<tr id="showenrollment_status">
		<td class="form_lables"><?php echo __('Expiration Date',true); ?></td>
		<td><?php 
		 if(isset($ss['User']['expiration_date']))
		{
			$default = $ss['User']['expiration_date'];
		}else{ $default = '0';
					}
					if($userData['User']['exp_date_set_system']=='yes'){
			$val='';
			}else{$val=$userData['User']['expiration_date'];
			}
			echo $this->Form->input('User.expiration_date', array('class' => ' textBoxExpnd','id'=>'expiration_date', 'type'=>'text','label' => false,'autocomplete'=>'off','readonly'=>'readonly', 'div' => false, 'error' => false,'value'=>$val));
			?> <input type="hidden" name="data[User][id]"
			value="<?php echo $ss['User']['id'] ?>" />
		</td>
	</tr>
	<?php } ?>

	<!--  <tr>
		<td class="form_lables"><?php echo __('AADHAR NO',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('User.ssn', array('class' => 'textBoxExpnd ','maxlength'=>'12', 'id' => 'ssn', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>-->
	<tr>
		<td class="form_lables"><?php echo __('Suffix',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('User.suffix', array( 'id' => 'suffix', 'class' => 'validate[optional,custom[onlyLetterSp]] textBoxExpnd', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Name Type',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('User.name_type', array('empty'=>'Please Select','options'=>$name_type,'id' => 'name_type', 'class' => 'textBoxExpnd','label'=>false));
		?>
		</td>
	</tr>

	<tr>
		<td class="form_lables"><?php echo __('Gender',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('User.gender', array('class' => 'textBoxExpnd', 'options' => array('M' => 'Male', 'F' => 'Female'), 'empty' => 'Select Sex', 'id' => 'patient_gender', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Date Of Birth',true); ?>
		</td>
		<td><?php $this->data["User"]["dob"]=$enddate= $this->DateFormat->formatDate2Local($this->data["User"]["dob"],Configure::read('date_format'),true);
		if($this->data["User"]["dob"] == "" || $this->data["User"]["dob"] == "00/00/0000") {
        ?> <input type="text" class="textBoxExpnd"
			id="customdateofbirth" name="data[User][dob]"> <?php 
         } else {
        echo $this->Form->input('User.dob', array('type'=>'text', 'id' => 'customdateofbirth', 'class' => 'textBoxExpnd ', 'label'=> false, 'div' => false, 'error' => false));
         }
         ?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Designation',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('User.designation_id', array('options' => $designations, 'empty' => 'Select Designation', 'class' => 'textBoxExpnd', 'id' => 'customgender', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Payment',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('User.payment', array('type'=>'text', 'id' => 'payment', 'class' => 'textBoxExpnd', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>	
	<tr>
		<th align="left" colspan="2">Bank account details
		<?php echo $this->Form->hidden('HrDetail.id',array('id'=>'HrDetailId','value'=>$hrDetails['HrDetail']['id']));?></th>
	</tr>
	<tr>
		<td class="tdLabel">Bank name</td>
		<td><?php echo $this->Form->input('HrDetail.bank_name', array('label'=>false,'div'=>false,'id' => 'bank_name','class'=> 'textBoxExpnd','value'=>$hrDetails['HrDetail']['bank_name'])); ?>
		</td>
	</tr>
	<tr>
		<td class="tdLabel">Bank Branch</td>
		<td><?php echo $this->Form->input('HrDetail.branch_name', array('label'=>false,'id' => 'branch_name','class'=>'textBoxExpnd','value'=>$hrDetails['HrDetail']['branch_name'])); ?>
		</td>			
	</tr>
	<tr>
		<td class="tdLabel">Account number</td>
		<td><?php echo $this->Form->input('HrDetail.account_no', array('type'=>'text','label'=>false,'id' => 'account_no','class'=>'textBoxExpnd validate["",custom[onlyNumber]]','value'=>$hrDetails['HrDetail']['account_no'])); ?></td>
	</tr>
	<tr>
		<td class="tdLabel">IFSC Code</td>
		<td><?php echo $this->Form->input('HrDetail.ifsc_code', array('type'=>'text','label'=>false,'id' => 'ifsc_code','class'=>'textBoxExpnd','maxlength'=>'11','value'=>$hrDetails['HrDetail']['ifsc_code'])); ?></td>
	</tr>
	<tr>
		<td class="tdLabel">Bank pass book copy obtained :</td>
		<td>
		<?php echo $this->Form->checkbox('HrDetail.pass_book_copy', array('style'=>'float:left','legend'=>false,'label'=>false,'class' => 'neft_authorized_received','checked'=>$hrDetails['HrDetail']['pass_book_copy'])); ?>
		</td>
	</tr>
  
	<tr>
		<td  class="tdLabel">NEFT authorization received :</td>
		<td>
		<?php echo $this->Form->checkbox('HrDetail.neft_authorized_received', array('style'=>'float:left','legend'=>false,'label'=>false,'class' => 'neft_authorized_received','checked'=>$hrDetails['HrDetail']['neft_authorized_received'])); ?>
		</td>
	</tr>  		
	<tr>
		<td class="tdLabel">PAN</td>
		<td><?php 	echo $this->Form->input('HrDetail.pan', array( 'id' => 'pan','type'=>'text', 'selected'=>'84', 'label'=> false, 'div' => false, 'error' => false,'class' => 'textBoxExpnd','value'=>$hrDetails['HrDetail']['pan']));?>
		</td>
	</tr>

</table>
</td>

<!--Right Side HTML -->
<td valign="top" width="50%">
<table border="0" class="table_format" cellpadding="0"
	cellspacing="0" width="100%" align="center">
	<tr>
		<td class="form_lables"><?php echo __('Address1',true); ?></td>
		<td><?php 
		echo $this->Form->textarea('User.address1', array('cols' => '2', 'rows' => '2','class'=>'', 'id' => 'customaddress1', 'label'=> false, 'div' => false, 'error' => false,'class'=>''));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Address2',true); ?>
		</td>
		<td><?php 
		echo $this->Form->textarea('User.address2', array('cols' => '2', 'rows' => '2','class'=>'', 'id' => 'customaddress2', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Zipcode',true); ?></td>
		<td><?php 
		echo $this->Form->input('User.zipcode', array('id' => 'pinCode' ,'class' => 'textBoxExpnd validate[optional,custom[onlyNumber,minSize[6]]]', 'label'=> false, 'div' => false, 'error' => false,'maxlength'=>'6'));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Country',true); ?>
		</td>
		<td><?php ///'options' => $countries, 'empty' => 'Select Country',
		echo $this->Form->input('User.country_id', array( 'id' => 'customcountry','options' =>array('India'=>'India'),
			'label'=> false, 'class' => 'textBoxExpnd', 'div' => false, 'error' => false,
			/*'onchange'=> $this->Js->request(array('controller'=>'users','action' => 'get_state_city','reference'=>'State',
			 'admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
			'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
			'async' => true, 'update' => '#changeStates', 'data' => '{reference_id:$("#customcountry").val()}', 'dataExpression' => true, 'div'=>false))*/));
        ?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('State',true); ?>
		</td>
		<td id="changeStates"><?php //debug($this->request->data['State']['name']);
        echo $this->Form->input('User.state_name', array('id' => 'stateName', 'label'=> false, 'div' => false, 'error' => false,'class' => ' textBoxExpnd ','type'=>'text','value'=>$this->request->data['State']['name']));
        echo $this->Form->hidden('User.state_id',array('id'=>'stateId'));?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('City',true); ?></td>
		<td id="changeCities"><?php 
		echo $this->Form->input('User.city_id', array('type'=>'text', 'value'=>$this->data['City']['name'],
		'id' => 'city','class' => 'textBoxExpnd ', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Phone1',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('User.phone1', array('id' => 'customphone1','maxlength'=>'12', 'class' => 'textBoxExpnd ', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Phone2',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('User.phone2', array('id' => 'customphone2','maxlength'=>'11','class' => 'textBoxExpnd validate["",custom[phone]]', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Mobile',true); ?><font
			color="red">*</font>
		</td>
		<td><?php 
		echo $this->Form->input('User.mobile', array('id' => 'custommobile','maxlength'=>'11', 'class' => 'textBoxExpnd validate[required,custom[mandatory-select]]', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Fax',true); ?>
		</td>
		<td><?php echo $this->Form->input('User.fax', array('id' => 'customfax','maxlength'=>'11','class' => 'textBoxExpnd ', 'label'=> false, 'div' => false, 'error' => false));?>
		</td>
	</tr>

	<tr>
		<td class="form_lables"><?php echo __('Account Group',true); ?>
		</td>
		<td><?php
		if(empty($this->data['User']['accounting_group_id']) || $this->data['User']['accounting_group_id']=='0'){
			$Id = $groupId;
		}else{
			$Id = $this->data['User']['accounting_group_id'];
		}
		echo $this->Form->input('User.accounting_group_id', array('id' => 'group_id','type'=>'select','options'=>$group,'class'=>'textBoxExpnd','label'=> false, 'div' => false, 'error' => false,'empty'=>'Please Select','value'=>$Id));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Active',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('User.is_active', array('options' => array('No', 'Yes'), 'id' => 'customis_active','class' => 'textBoxExpnd', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Photo',true); ?>
		</td>
		<td><?php 
		echo $this->Form->input('User.upload_image', array('type'=>'file','id' => 'user_photo', 'class'=>'','label'=> false,
					 				'div' => false,'style'=>'width:177px','error' => false));
        ?>
		</td>
	</tr>

	<tr>
		<td class="form_lables"><?php echo __('Is Guarantor',true); ?>
		</td>
		<td><?php 
		echo $this->Form->checkbox('User.is_guarantor',array('id'=>'is_guarantor','name'=>"data[User][is_guarantor]"));
		?>
		</td>
	</tr>

	<tr>
		<td class="form_lables"><?php echo __('Is Authorized for discount',true); ?>
		</td>
		<td><?php 
		echo $this->Form->checkbox('User.is_authorized_for_discount',array('id'=>'is_authorized','name'=>"data[User][is_authorized_for_discount]"));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables"><?php echo __('Shifts Allowed',true); ?>
		</td>
		<td><?php 
		echo $this->Form->hidden("PlacementHistory.0.id",array('value'=>$shiftData['PlacementHistory']['id']));
		echo $this->Form->input("PlacementHistory.0.shifts",array('options' => $allShiftData,'value'=>$shiftData['PlacementHistory']['shifts'],'empty'=>'Select','class'=>"shiftname textBoxExpnd",'id'=>"shifts"));?>
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
		<td class="form_lables"><?php echo __('Password Expiry Date',true); ?>
		</td>
		<td><?php 
		$passExp=$this->DateFormat->formatDate2Local($this->data['User']['password_expiry'],Configure::read('date_format'),false);
		echo $this->Form->input('User.password_expiry', array('type'=>'text','id' => 'password_expiry', 'class'=>'textBoxExpnd','label'=> false,
					 				'div' => false ,'error' => false,'value'=>$passExp));
        ?> <br /> <span style="float: left;"><i>(This field is added for
					test purpose)</i> </span>
		</td>
	</tr>
	<tr>
		<td></td>
		<td><?php if(file_exists(WWW_ROOT."/uploads/user_images/".$this->data['User']['photo']) && !empty($this->data['User']['photo'])){ ?>
			<?php echo $this->Html->image("/uploads/user_images/".$this->data['User']['photo'], array('width'=>'100','height'=>100)); ?>
			<?php }?>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center">&nbsp;</td>
	</tr>
	<tr>
		<td><?php echo __('Signature',true); ?></td>
		<td class="form_lables" width="56%"><?php 
		if($this->data['User']['sign'] != "") {
                            	       echo $this->Html->image('/signpad/'.$this->data['User']['sign'], array('alt' => 'Signature', 'title' => 'Signature', 'width' => '320', 'height' => '150'));
                            		 }  else {
                            	?>
			<div class="sigPad">
				<ul class="sigNav">
					<li class="drawIt"><a href="#draw-it"><font color="#3d3d3d">Draw It</font>
					</a></li>
					<li class="clearButton"><a href="#clear"><font color="#3d3d3d">Clear</font>
					</a></li>
				</ul>
				<div>
					<div class="typed"></div>
					<canvas class="pad" width="300" height="150"></canvas>
					<?php echo $this->Form->input('User.sign', array('type' =>'hidden', 'id' => 'output', 'class' => 'output')); ?>
				</div>
			</div> <?php } ?>
		</td>
	</tr>

	<tr>
		<td colspan="2" align="right"><?php if($emer == 'emer'){ 
			echo $this->Html->link(__('Cancel', true),array('controller'=>'AuditLogs','action' => 'admin_emergency_access'), array('escape' => false,'class'=>'blueBtn'));
		}
		else { echo $this->Html->link(__('Cancel', true),array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
}
?> <input type="Submit" value="Submit" class="blueBtn", id = "save">
		</td>
	</tr>
</table>

</td>
</tr>
</table>
<?php echo $this->Form->end();?>
<script>
jQuery(document).ready(function(){

	$( "#save" ).click(function(){
		
		var externalCharges = $( "#externalCharges").val();
		externalCharges = externalCharges.trim();
		if(externalCharges == ''){
			$("#from").removeClass("validate[required,custom[mandatory-enter]]");
		}else{
			$("#from").addClass("validate[required,custom[mandatory-enter]]");
		}
	});
	  var roleName= $( "#roletype option:selected" ).text(); 
      if(roleName=='Primary Care Provider'){
	       $('#specialty').show();
	       $('#surgeonshow ').show();
	       $('.profitsharingshow').show();
	       $('#opdDoctorshow').show();
	       $('#regshow').show();
	       $('#doctorshow').show();
	       $('.profitsharingsconsultant').show();
	       
      }else{
   	   $('#specialty').hide();
	       $('#surgeonshow').hide();
	       $('.profitsharingshow').hide();
	       $('#opdDoctorshow').hide();
	       $('#regshow').hide();
	       $('#doctorshow').hide();
	       $('.profitsharingsconsultant').hide();
      }
	jQuery("#roletype").change(function(){ 
	       var roleName= $( "#roletype option:selected" ).text(); 
	       if(roleName=='Primary Care Provider'){
		       $('#specialty').show();
		       $('#surgeonshow ').show();
		       $('.profitsharingshow').show();
		       $('#opdDoctorshow').show();
		       $('#regshow').show();
		       $('#doctorshow').show();
		       $('.profitsharingsconsultant').show();
	       }else{
	    	   $('#specialty').hide();
		       $('#surgeonshow ').hide();
		       $('.profitsharingshow').hide();
		       $('#opdDoctorshow').hide();
		       $('#regshow').hide();
		       $('#doctorshow').hide();
		       $('.profitsharingsconsultant').hide();
	       }
	      
	        
	    });
	
			$(function() {
				var firstYr = new Date().getFullYear()-100;
    			var lastYr = new Date().getFullYear()-1;
                        //var dateminmax = new Date(new Date().getFullYear()-100, 0, 0)+':'+new Date(new Date().getFullYear()-20, 0, 0);
                      /*  $( "#customdateofbirth" ).datepicker({
							showOn: "button",
							buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
							buttonImageOnly: true,
							changeMonth: true,
							changeYear: true,
							defaultDate: '-52y',
							dateFormat:'<?php echo $this->General->GeneralDate();?>',
							yearRange: firstYr+':'+lastYr,
                            defaultDate: new Date(firstYr)
			
		         		});*/	
                        $("#customdateofbirth").live("focus",function() {
		            		$(this).datepicker({
        							showOn : "both",
        							buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
        							buttonImageOnly : true,
        							changeMonth : true,
        							changeYear : true,
        							yearRange: '-100:' + new Date().getFullYear(),
        							//yearRange : firstYr+':'+lastYr,
        							dateFormat:'<?php echo $this->General->GeneralDate();?>',
        							onSelect : function() {
        								$(this).focus();
        							},
        							maxDate : new Date(),
        						 });
                        }); 

                        $("#password_expiry").datepicker({	
        	  				changeMonth : true,
        	        		changeYear : true,
        	        		maxDate: new Date(),
        	        		dateFormat : '<?php echo $this->General->GeneralDate();?>',
        	        		showOn : 'button',
        	        		buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
        	        		buttonImageOnly : true,
        	        		onSelect : function() {
        	        			$(this).focus();
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

	  
			 $("#expiary_date")
				.datepicker(
						{
							showOn : "button",
							buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
							buttonImageOnly : true,
							changeMonth : true,
							changeYear : true,
							yearRange : '2013',
							dateFormat:'<?php echo $this->General->GeneralDate("HH:II");?>',
							onSelect : function() {
								$(this).focus();
							},
							minDate : new Date(),
						 });	
			 
 jQuery("#userfrm").validationEngine();	
        
   });

$(document).ready(function(){

	$('.sigPad').signaturePad();
	
	$('#confPassword').attr('readonly', true);
	
	$("#incorrect").hide();
	$("#correct").hide();
	url  = "<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","City","name",
			'null','no','null',"admin" => false,"plugin"=>false)); ?> " ;


	$("#customcity").autocomplete(url+"/state_id=" +$('#customstate').val(), {
		width: 250,
		selectFirst: true, 
	});
					
	 $("#customstate").live("change",function(){ 
		 $("#customcity").unautocomplete().autocomplete(url+"/state_id=" +$('#customstate').val(), {
			width: 250,
			selectFirst: true, 
		});
	 });
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

	function passwordStrength(password){	//alert($('#password').val().length);
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


	 $("#user_photo").live("change",function(){ 
	    var ext = $('#user_photo').val().split('.').pop().toLowerCase();
	    if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
	    	alert('only .gif, .png, .jpg, .jpeg extention files are allowed.');
	        $('#user_photo').val("");
	    }
	});


$(document).ready(function(){
	faxMandatory();
});
	
	/* $("#ssn").focusout(function(){ 
			res=$("#ssn").val();
			count=($("#ssn").val()).length;
			str1=res.substring(0, 3);
			str2=res.substring(3, 5);
			str3=res.substring(5, 9);
			if(count=='9'){
				$("#ssn").val(str1+'-'+str2+'-'+str3);
			}
			if(count=='0'){
				$('#ssn').val("");
			}
	 });*/	

	 $('#custominitial').change(function(){
		var getInitial=$("#custominitial option:selected").val();
		if(getInitial=='2' || getInitial=='3'){
			$("#patient_gender").val('F');
			//var getInitial=$("#sex option:selected").val();
		}else if(getInitial=='1' || getInitial=='5') {
			$("#patient_gender").val('M');
		}else{
			$("#patient_gender").val('');
		}
	});

	$('#patient_gender').change(function(){
		var getSex=$("#patient_gender option:selected").val();
		if(getSex=='F'){
			$("#custominitial").val('2');
		}else if(getSex=='M') {
			$("#custominitial").val('1');
		}else{
			$("#custominitial").val('');
		}
	});

	$('#customgender').change(function (){
		faxMandatory();
	});
	
	function faxMandatory(){
		val=$('#customgender').val();
		if(val=='115'){
			$('#fax1').hide();
			$('#fax2').show();
		}else{
			$('#fax1').show();
			$('#fax2').hide();
		}
	}
   //BOF-Mahalaxmi -Profit for Primary Care Provider
    
    $('#customdepartments').click(function(){     
       var deptName= $( "#customdepartments option:selected" ).text(); 
       $('#prof_sharing_dept_name').val(deptName);
       if(deptName == 'Pathology'){
           $("#subSpecialtyTrID").show();
      }else{
           $("#subSpecialtyTrID").hide();
      }
        
    });
//EOF--Mahalaxmi  -Profit for Primary Care Provider
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

  /*$('#location_id').change(function(){
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
