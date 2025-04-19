<?php
echo $this->Html->script(array('jquery.ui.widget.js','jquery.ui.mouse.js','jquery.ui.core.js','jquery.ui.slider.js','jquery-ui-timepicker-addon.js'));
?>
<div class="inner_title">
<h3><?php echo __('Add Doctor', true); ?></h3>
</div>
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#doctorfrm").validationEngine();
	});
	
</script>

<?php 
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td colspan="2" align="left">
   <?php 
     foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
   ?>
  </td>
 </tr>
</table>
<?php } ?>
<form name="doctorfrm" id="doctorfrm" action="<?php echo $this->Html->url(array("controller" => "doctors", "action" => "add", "superadmin" => true)); ?>" method="post" onSubmit="return Validate(this);" >
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="60%"  align="center">
	<tr>
	<td class="form_lables">
	<?php echo __('Hospital Name',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
          echo $this->Form->input('facility.name', array('class' => 'validate[required,custom[facilityname]]', 'options' => $facilities,'empty' => 'Select Hospital', 'id' => 'facilityname', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
	<tr>
	 <td class="form_lables">
	  <?php echo __('Location'); ?><font color="red">*</font>
	 </td>
	 <td>
	  <?php 
	        echo $this->Form->input('Role.location_id', array('class' => 'validate[required,custom[location_id]]', 'id' => 'location_id', 'label'=> false, 'div' => false, 'error' => false,'empty'=>__('Please select'),'disabled'=>'disabled'));
	        ?>
	 </td>
	</tr>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Role',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
          echo $this->Form->input('Doctor.role_id', array('class' => 'validate[required,custom[customroles]]','options' => $roles, 'id' => 'customroles', 'label'=> false, 'div' => false, 'error' => false,'disabled'=>'disabled', 'empty' => __('Please select')));
        ?>
	</td>
	</tr>
	<tr>
	<td class="form_lables">
	<?php echo __('Email',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Doctor.email', array('class' => 'validate[required,custom[customemail]]', 'id' => 'customemail', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Password',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Doctor.password', array('class' => 'validate[required,custom[customrequired]]', 'id' => 'customrequired', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Confirm Password',true); ?><font color="red">*</font>
	</td>
	<td>
         <input class="validate[required,equals[customrequired]] text-input" type="password" name="password2" id="password2" />
        </td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Initial',true); ?>
	</td>
	<td>
        <?php 
          echo $this->Form->input('Doctor.initial_id', array('class' => 'validate[required,custom[custominitial]]', 'options' => $initials, 'id' => 'custominitial', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('First Name',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Doctor.first_name', array('class' => 'validate[required,custom[customfirstname]]', 'id' => 'customfirstname', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Middle Name',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Doctor.middle_name', array('class' => 'validate[required,custom[custommiddlename]]', 'id' => 'custommiddlename', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Last Name',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Doctor.last_name', array('class' => 'validate[required,custom[customlastname]]', 'id' => 'customlastname', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables">
        <?php echo __('Address1',true); ?>
	<font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->textarea('Doctor.address1', array('class' => 'validate[required,custom[customaddress1]]', 'cols' => '35', 'rows' => '10', 'id' => 'customaddress1', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Address2',true); ?>
	</td>
	<td>
         <?php 
        echo $this->Form->textarea('Doctor.address2', array('cols' => '35', 'rows' => '10', 'id' => 'customaddress2', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
	<tr>
	<td class="form_lables">
	<?php echo __('Zipcode',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Doctor.zipcode', array('class' => 'validate[required,custom[customzipcode]]', 'id' => 'customzipcode', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Country',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
           
            
                   
          echo $this->Form->input('Doctor.country_id', array('class' => 'validate[required,custom[customcountry]]', 'options' => $countries, 'empty' => 'Select Country', 'id' => 'customcountry', 'label'=> false, 'div' => false, 'error' => false
));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('State',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
          echo $this->Form->input('Doctor.state_id', array('class' => 'validate[required,custom[customstate]]', 'options' => $states, 'empty' => 'Select State', 'id' => 'customstate', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
	<tr>
	<td class="form_lables">
	<?php echo __('City',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
          echo $this->Form->input('Doctor.city_id', array('class' => 'validate[required,custom[customcity]]', 'options' => $cities,'empty' => 'Select City', 'id' => 'customcity', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Phone1',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Doctor.phone1', array('class' => 'validate[required,custom[customphone1]]', 'id' => 'customphone1', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Phone2',true); ?>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Doctor.phone2', array('id' => 'customphone2', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Mobile',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Doctor.mobile', array('class' => 'validate[required,custom[custommobile]]', 'id' => 'custommobile', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Fax',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Doctor.fax', array('class' => 'validate[required,custom[customfax]]', 'id' => 'customfax', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
        </tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Specilty',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
          echo $this->Form->input('DoctorProfile.department_id', array('class' => 'validate[required,custom[customdepartment]]', 'options' => $departments,'empty' => 'Select Specilty', 'id' => 'customdepartment', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Education',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('DoctorProfile.education', array('class' => 'validate[required,custom[customeducation]]', 'id' => 'customeducation', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
        </tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Has Specility',true); ?>
	</td>
	<td>
        <?php 
          echo $this->Form->input('DoctorProfile.haspecility', array('options' => array('No', 'Yes'), 'id' => 'customhaspecility', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Specility Keyword',true); ?>
	</td>
	<td>
         <?php 
        echo $this->Form->textarea('DoctorProfile.specility_keyword', array('class' => 'validate[required,custom[customspecility_keyword]]','cols' => '35', 'rows' => '10', 'id' => 'customspecility_keyword', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Experience',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('DoctorProfile.experience', array('class' => 'validate[required,custom[customexperience]]', 'id' => 'customexperience', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
        </tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Profile Description',true); ?>
	</td>
	<td>
         <?php 
        echo $this->Form->textarea('DoctorProfile.profile_description', array('class' => 'validate[required,custom[customprofile_description]]','cols' => '35', 'rows' => '10', 'id' => 'customprofile_description', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Date of Birth',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
         echo $this->Form->input('DoctorProfile.dateofbirth', array('class' => 'validate[required,custom[customdateofbirth]]', 'id' => 'customdateofbirth', 'label'=> false, 'div' => false, 'error' => false, 'type' => 'text'));
        ?>
	</td>
        </tr>
	<tr>
	<td class="form_lables">
	<?php echo __('Active',true); ?>
	</td>
	<td>
        <?php 
          echo $this->Form->input('Doctor.is_active', array('options' => array('No', 'Yes'), 'id' => 'customis_active', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
        <tr>
	<td colspan="2" align="center">
        &nbsp;
	</td>
	</tr>
	<tr>
	<td colspan="2" align="center">
        <?php 
   	echo $this->Html->link(__('Cancel', true),array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
        ?>&nbsp;&nbsp;
	<input type="submit" value="Submit" class="blueBtn">
	</td>
	</tr>
	</table>
</form>
<script>
$(document).ready(function(){
		
		$('#facilityname').change(function(){
			$.ajax({
				  url: "<?php echo $this->Html->url(array("controller" => "users", "action" => "getLocations", "superadmin" => true)); ?>"+"/"+$('#facilityname').val(),
				  context: document.body,				  		  
				  success: function(data){
					data= $.parseJSON(data);
					$("#location_id option").remove();
					$.each(data, function(val, text) {
						$('#location_id').append( new Option(text,val) );
					});
					$('#location_id').attr('disabled', '');
					
				  }
			});			
			if($('#facilityname').val() == ""){
				$('#location_id').attr('disabled', 'disabled');
				$('#customroles').attr('disabled', 'disabled');
			}
		});
		$('#location_id').change(function(){
		$.ajax({
				  url: "<?php echo $this->Html->url(array("controller" => "users", "action" => "getRoles", "superadmin" => true)); ?>"+"/"+$('#location_id').val(),
				  context: document.body,				  		  
				  success: function(data){
					data= $.parseJSON(data);
					$("#customroles option").remove();
					$.each(data, function(val, text) {
						$('#customroles').append( new Option(text,val) );
					});
					$('#customroles').attr('disabled', '');
					
				  }
			});
			if($('#facilityname').val() == ""){
				$('#customroles').attr('disabled', 'disabled');
			}
		});
                //script to include datepicker
		$(function() {
			$( "#customdateofbirth" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',
			maxDate: new Date(),
			dateFormat:'<?php echo $this->General->GeneralDate();?>',
			
		});		
		});
	});
</script>