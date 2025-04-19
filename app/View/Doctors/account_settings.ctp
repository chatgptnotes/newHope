<script>
var imageUrl= "<?php echo $this->Html->url("/img/color.png"); ?>";
</script>
<?php
echo $this->Html->script(array('izzyColor'));
?>
<div class="inner_title">
<h3><?php echo __('Edit Doctor Profile', true); ?></h3>
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
<form name="doctorfrm" id="doctorfrm" action="<?php echo $this->Html->url(array("controller" => "doctors", "action" => "account_settings", "admin" => false, 'superadmin'=> false)); ?>" method="post" onSubmit="return Validate(this);" >
        <?php 
             echo $this->Form->input('Doctor.id', array('type' => 'hidden')); 
             echo $this->Form->input('DoctorProfile.id', array('type' => 'hidden')); 
        ?>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="60%"  align="center">
        <tr>
	<td class="form_lables">
        <?php echo __('Doctor Name',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('DoctorProfile.doctor_name', array('class' => 'validate[required,custom[customname]]', 'id' => 'customname', 'label'=> false, 'div' => false, 'error' => false, 'value' => $this->request->data['DoctorProfile']['doctor_name']));
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
        <!--<tr>
	<td class="form_lables">
	<?php //echo __('Location',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
          //echo $this->Form->input('DoctorProfile.location_id', array('class' => 'validate[required,custom[location_id]]', 'options' => $locations,'empty' => 'Select Location', 'id' => 'location_id', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr> -->
        <tr>
	<td class="form_lables">
        <?php echo __('Education',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('DoctorProfile.education', array('class' => 'validate[required,custom[customeducation]]', 'id' => 'customeducation', 'label'=> false, 'div' => false, 'error' => false, 'value' => $this->request->data['DoctorProfile']['education']));
        ?>
	</td>
        </tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Has Speciality',true); ?>
	</td>
	<td>
        <?php 
          echo $this->Form->input('DoctorProfile.haspecility', array('options' => array('No', 'Yes'), 'id' => 'customhaspecility', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
        <tr id="specility_keyword">
	<td class="form_lables">
	<?php echo __('Speciality Keyword',true); ?>
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
         if($this->data['DoctorProfile']['dateofbirth'] == "0000-00-00") {
            $datebirthVal = "";
         } else {
            $datebirthVal = $this->DateFormat->formatDate2Local($this->data['DoctorProfile']['dateofbirth'],Configure::read('date_format'),true);
			
			
         }
         echo $this->Form->input('DoctorProfile.dateofbirth', array('class' => 'validate[required,custom[customdateofbirth]]', 'id' => 'customdateofbirth', 'label'=> false, 'div' => false, 'error' => false, 'type' => 'text', 'value'=> $datebirthVal));
        ?>
	</td>
        </tr>
        <tr>
	<td class="form_lables">
	<?php echo __('Present Event Color Code',true); ?>
	</td>
	<td>
        <?php 
         echo $this->Form->input('DoctorProfile.present_event_color', array('class' => 'izzyColor', 'id' => 'presentcolorcode', 'label'=> false, 'div' => false, 'error' => false, 'type' => 'text'));
        ?>
	</td>
        </tr>
        <!-- <tr>
	<td class="form_lables">
	<?php //echo __('Past Event Color Code',true); ?>
	</td>
	<td>
        <?php 
        // echo $this->Form->input('DoctorProfile.past_event_color', array('class' => 'izzyColor', 'id' => 'pastcolorcode', 'label'=> false, 'div' => false, 'error' => false, 'type' => //'text'));
        ?>
	</td>
        </tr>
        <tr>
	<td class="form_lables">
	<?php //echo __('Future Event Color Code',true); ?>
	</td>
	<td>
        <?php 
         //echo $this->Form->input('DoctorProfile.future_event_color', array('class' => 'izzyColor', 'id' => 'futurecolorcode', 'label'=> false, 'div' => false, 'error' => false, 'type' => //'text'));
        ?>
	</td>
        </tr> -->
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
		//script to include datepicker
                $(function() {
                        //var dateminmax = new Date(new Date().getFullYear()-100, 0, 0)+':'+new Date(new Date().getFullYear()-20, 0, 0);
                        $( "#customdateofbirth" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
                        defaultDate: '-52y',
                       	dateFormat:'<?php echo $this->General->GeneralDate();?>',
                        yearRange: '1960:1995'
			//minDate: new Date(new Date().getFullYear()-100, 0, 0),
                       // maxDate: new Date(new Date().getFullYear()-20, 0, 0)
		});		
		});
               $('#customhaspecility').change(function() {
                 var specility = $('#customhaspecility').val();
                 if(specility == 1) {
                    $('#specility_keyword').show();
                 } else {
                    $('#specility_keyword').hide();
                 }
               });
               var specility = $('#customhaspecility').val();
                 if(specility == 1) {
                    $('#specility_keyword').show();
                 } else {
                    $('#specility_keyword').hide();
                 }
	});
</script>