<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#doctorappointmentfrm").validationEngine();
	});
	
</script>
<div class="inner_title">
 <h3>
 <?php echo __('Doctor Appointment'); ?>
 </h3>
</div>
<div class="inner_left">    
<form name="doctorappointmentfrm" id="doctorappointmentfrm" action="<?php echo $this->Html->url(array("controller" => "doctor_schedules", "action" => "doctor_event")); ?>" method="post" onSubmit="return Validate(this);" >
 <?php echo $this->Form->create('',array('id'=>'doctorappointmentfrm','default'=>false,'inputDefaults' => array('label' => false,'div' => false))); ?> 
 <table class="table_format"  id="schedule_form">
   
   <tr>
	<td class="form_lables"> <input type="hidden" name="patientid" value="<?php echo $patientid; ?>"></input>
	<?php echo __('Doctor List',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
          echo $this->Form->input('doctor_userid', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $doctorlist, 'empty' => 'Select Doctor', 'id' => 'customdoctor', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
   <tr>
   <td></td>
   <td>
    <input type="submit" value="Submit" class="blueBtn">
    </td>					 
   </tr>
  </table>
 <?php echo $this->Form->end();?>
</div>
