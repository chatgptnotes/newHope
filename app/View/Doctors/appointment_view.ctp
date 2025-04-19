<div class="inner_title">
 <h3>	
  <div style="float:left"><?php echo __('Doctor Appointment Details'); ?></div>			
   <div style="float:right;">
    <?php
	       		echo $this->Html->link(__('Back to List'), array('action' => 'doctor_appointment'), array('escape' => false,'class'=>'blueBtn'));
    ?>
   </div>
 </h3>
<div class="clr"></div>
</div>
<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center" class="table_format">
 <tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Appointment Date',true); ?>
  </td>
  <td>
   <?php echo $doctor_appointment['DoctorAppointment']['date']; ?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Start Time',true); ?>
  </td>
  <td>
   <?php echo $doctor_appointment['DoctorAppointment']['start_time']; ?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('End Time',true); ?>
  </td>
  <td>
   <?php echo $doctor_appointment['DoctorAppointment']['end_time']; ?>
  </td>
 </tr>
<tr>
  <td class="row_format"><strong>
   <?php echo __('Purpose',true); ?>
  </td>
  <td>
   <?php echo $doctor_appointment['DoctorAppointment']['purpose']; ?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Visit Type',true); ?>
  </td>
  <td>
   <?php echo $doctor_appointment['DoctorAppointment']['visit_type']?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Location Name',true); ?>
  </td>
  <td>
   <?php echo $doctor_appointment['Location']['name']?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Specilty',true); ?>
  </td>
  <td>
   <?php echo $doctor_appointment['Department']['name']?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Patient ID',true); ?>
  </td>
  <td>
   <?php echo $doctor_appointment['Patient']['patient_id']?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Patient Name',true); ?>
  </td>
  <td>
   <?php echo $doctor_appointment['Patient']['full_name']?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Sex',true); ?>
  </td>
  <td>
   <?php echo $doctor_appointment['Patient']['sex']?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Date of Birth',true); ?>
  </td>
  <td>
   <?php echo $doctor_appointment['Patient']['dob']?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Blood Group',true); ?>
  </td>
  <td>
   <?php echo $doctor_appointment['Patient']['blood_group']?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('MRN',true); ?>
  </td>
  <td>
   <?php echo $doctor_appointment['Patient']['admission_id']?>
  </td>
 </tr>
</table>
