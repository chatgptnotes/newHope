<div class="inner_title">
<h3><?php echo __('Doctor Schedule::Scheduled Doctor View Details'); ?></h3>
</div>
<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Doctor Name',true); ?></strong>
  </td>
  <td class="row_format">
   <?php echo $doctorschedule['DoctorProfile']['doctor_name']?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Scheduled Date',true); ?></strong>
  </td>
  <td class="row_format">
   <?php
   echo $this->DateFormat->formatDate2Local($doctorschedule['DoctorSchedule']['schedule_date'],Configure::read('date_format'));
   ?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Start Scheduled Time',true); ?></strong>
  </td>
  <td class="row_format">
   <?php echo $doctorschedule['DoctorSchedule']['schedule_time']?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('End Scheduled Time',true); ?></strong>
  </td>
  <td class="row_format">
   <?php echo $doctorschedule['DoctorSchedule']['end_schedule_time']?>
  </td>
 </tr>
 <tr>
	<td colspan="2" align="center">
	<?php echo $this->Html->link(__('Cancel', true), array('action' => 'scheduled_doctor'),  array('class' => 'blueBtn','escape' => false));
	?>
        </td>
	</tr>
 </table>
