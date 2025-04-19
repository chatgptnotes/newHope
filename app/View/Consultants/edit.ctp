<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#consultantsfrm").validationEngine();
	});
	
</script>
<div class="inner_title">
<h3><?php echo __('Edit Consultant', true); ?></h3>
</div>
<?php 
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td colspan="2" align="left"><div class="alert">
   <?php 
     foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
   ?></div>
  </td>
 </tr>
</table>
<?php } ?>
<form name="consultantsfrm" id="consultantsfrm" action="<?php echo $this->Html->url(array("controller" => "consultants", "action" => "edit")); ?>" method="post">
        <?php 
             echo $this->Form->input('Consultant.id', array('type' => 'hidden')); 
        ?>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="60%"  align="center">
	<tr>
	<td class="form_lables">
	<?php echo __('Initial',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
          echo $this->Form->input('Consultant.initial_id', array('class' => 'validate[required,custom[custominitial]]', 'options' => $initials, 'empty' => 'Select Initial', 'id' => 'custominitial', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Refering Doctor Type',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php
          echo $this->Form->input('Consultant.refferer_doctor_id', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $referingdoctor, 'empty' => 'Select Type', 'id' => 'customrefering', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
	<tr>
	<td class="form_lables">
	<?php echo __('First Name',true); ?>
        <font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Consultant.first_name', array('class' => 'validate[required,custom[customfirstname]]', 'id' => 'customfirstname', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Middle Name',true); ?>
        
	</td>
	<td>
        <?php 
        echo $this->Form->input('Consultant.middle_name', array('id' => 'custommiddlename', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Last Name',true); ?>
        <font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Consultant.last_name', array('class' => 'validate[required,custom[customlastname]]', 'id' => 'customlastname', 'label'=> false, 'div' => false, 'error' => false));
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
        echo $this->Form->textarea('Consultant.address1', array('class' => 'validate[required,custom[customaddress1]]', 'cols' => '35', 'rows' => '10', 'id' => 'customaddress1', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Address2',true); ?>
	</td>
	<td>
         <?php 
        echo $this->Form->textarea('Consultant.address2', array('cols' => '35', 'rows' => '10', 'id' => 'customaddress2', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
	<tr>
	<td class="form_lables">
	<?php echo __('Country',true); ?><font color="red">*</font>
	</td>
	<td>
       <?php 
          echo $this->Form->input('Consultant.country_id', array('class' => 'validate[required,custom[customcountry]]', 'options' => $countries, 'empty' => 'Select Country', 'id' => 'customcountry', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('State',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
          echo $this->Form->input('Consultant.state_id', array('class' => 'validate[required,custom[customstate]]', 'options' => $states, 'empty' => 'Select State', 'id' => 'customstate', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
	<tr>
	<td class="form_lables">
	<?php echo __('City',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
          echo $this->Form->input('Consultant.city_id', array('class' => 'validate[required,custom[customcity]]', 'options' => $cities,'empty' => 'Select City', 'id' => 'customcity', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Zipcode',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Consultant.zipcode', array('class' => 'validate[required,custom[customzipcode]]', 'id' => 'customzipcode', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Email',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Consultant.email', array('class' => 'validate[required,custom[customemail]]', 'id' => 'customemail', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Phone1',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Consultant.phone1', array('class' => 'validate[required,custom[customphone1]]', 'id' => 'customphone1', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Phone2',true); ?>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Consultant.phone2', array('id' => 'customphone2', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Mobile',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Consultant.mobile', array('class' => 'validate[required,custom[custommobile]]', 'id' => 'custommobile', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Fax',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Consultant.fax', array('class' => 'validate[required,custom[customfax]]', 'id' => 'customfax', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Hospital Name',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Consultant.hospital_name', array('class' => 'validate[required,custom[customhospitalname]]', 'id' => 'customhospitalname', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Charges',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Consultant.charges', array('class' => 'validate[required,custom[customcharges]]', 'id' => 'customcharges', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Availability',true); ?>
	</td>
	<td>
        <?php 
          echo $this->Form->input('Consultant.availability', array('options' => array('0' => 'No', '1'=>'Yes'), 'id' => 'customavailability', 'label'=> false, 'div' => false, 'error' => false, 'selected' => $this->data['Consultant']['availability']));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Education',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Consultant.education', array('class' => 'validate[required,custom[customeducation]]', 'id' => 'customeducation', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Has Speciality',true); ?>
	</td>
	<td>
        <?php 
          echo $this->Form->input('Consultant.haspecility', array('options' => array('0' => 'No', '1'=>'Yes'), 'id' => 'customspecility', 'label'=> false, 'div' => false, 'error' => false, 'selected' => $this->data['Consultant']['haspecility']));
        ?>
        </td>
	</tr>
        <tr>
	<td class="form_lables">
        <?php echo __('Speciality Keyword',true); ?>
	<font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->textarea('Consultant.specility_keyword', array('class' => 'validate[required,custom[customspecility_keyword]]', 'cols' => '35', 'rows' => '10', 'id' => 'customspecility_keyword', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Experience',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Consultant.experience', array('class' => 'validate[required,custom[customexperience]]', 'id' => 'customexperience', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Date of Birth',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php
         
        $dob = $this->DateFormat->formatDate2Local($this->data['Consultant']['dateofbirth'],Configure::read('date_format'));
        
        
        echo $this->Form->input('Consultant.dateofbirth', array('type' => 'text', 'class' => 'validate[required,custom[customdateofbirth]]', 'id' => 'customdateofbirth', 'label'=> false, 'div' => false, 'error' => false, 'value'=> date("d/m/Y",$dob)));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Is Active',true); ?>
	</td>
	<td>
        <?php
          echo $this->Form->input('Consultant.is_active', array('options' => array('0' => 'No', '1'=>'Yes'), 'id' => 'customis_active', 'label'=> false, 'div' => false, 'error' => false, 'selected' => $this->data['Consultant']['is_active']));
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
        <?php echo $this->Html->link('Cancel',array("action" => "index"), array('class' => 'blueBtn','escape' => false)); ?>
	&nbsp;&nbsp;<input type="submit" value="Submit" class="blueBtn">
	</td>
	</tr>
	</table>
</form>
<script>
$(document).ready(function(){
		//script to include datepicker
		$(function() {
			$( "#customdateofbirth" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
                        defaultDate: '-52y',
			yearRange: '1960:1995',
			dateFormat:'<?php echo $this->General->GeneralDate();?>'
			
		});		
		});
                $('#customspecility').change(function() {
                 var specility = $('#customspecility').val();
                 if(specility == 1) {
                    $('#customspecility_keyword').show();
                 } else {
                    $('#customspecility_keyword').hide();
                 }
               });
               var specility = $('#customspecility').val();
                 if(specility == 1) {
                    $('#customspecility_keyword').show();
                 } else {
                    $('#customspecility_keyword').hide();
                 }
	});
</script>