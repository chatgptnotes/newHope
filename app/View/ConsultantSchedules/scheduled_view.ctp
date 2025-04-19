<div class="inner_title">
<h3><?php echo __('Consultant Schedule::Scheduled Consultant View Details'); ?></h3>
</div>
<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Consultant Name',true); ?>
  </td>
  <td class="row_format">
   <?php echo $consultantschedule['Consultant']['first_name']."&nbsp;".$consultantschedule['Consultant']['middle_name']."&nbsp;".$consultantschedule['Consultant']['last_name']; ?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Address1',true); ?>
  </td>
  <td class="row_format">
   <?php echo $consultantschedule['Consultant']['address1']; ?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Address2',true); ?>
  </td>
  <td class="row_format">
   <?php echo $consultantschedule['Consultant']['address2']; ?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Zipcode',true); ?>
  </td>
  <td class="row_format">
   <?php echo $consultantschedule['Consultant']['zipcode']; ?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Email',true); ?>
  </td>
  <td class="row_format">
   <?php echo $consultantschedule['Consultant']['email']; ?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Phone1',true); ?>
  </td>
  <td class="row_format">
   <?php echo $consultantschedule['Consultant']['phone1']; ?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Phone2',true); ?>
  </td>
  <td class="row_format">
   <?php echo $consultantschedule['Consultant']['phone2']; ?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Mobile',true); ?>
  </td>
  <td class="row_format">
   <?php echo $consultantschedule['Consultant']['mobile']; ?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Fax',true); ?>
  </td>
  <td class="row_format">
   <?php echo $consultantschedule['Consultant']['fax']; ?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Hospital Name',true); ?>
  </td>
  <td class="row_format">
   <?php echo $consultantschedule['Consultant']['hospital_name']; ?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Charges',true); ?>
  </td>
  <td class="row_format">
   <?php echo $consultantschedule['Consultant']['charges']; ?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Availability',true); ?>
  </td>
  <td class="row_format">
   <?php echo $consultantschedule['Consultant']['availability']; ?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Education',true); ?>
  </td>
  <td class="row_format">
   <?php echo $consultantschedule['Consultant']['education']; ?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Has Specility',true); ?>
  </td>
  <td class="row_format">
   <?php echo $consultantschedule['Consultant']['haspecility']; ?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Specility Keyword',true); ?>
  </td>
  <td class="row_format">
   <?php echo $consultantschedule['Consultant']['specility_keyword']; ?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Experience',true); ?>
  </td>
  <td class="row_format">
   <?php echo $consultantschedule['Consultant']['experience']; ?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Date of Birth',true); ?>
  </td>
  <td class="row_format">
   <?php echo $consultantschedule['Consultant']['dateofbirth']; ?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Profile Description',true); ?>
  </td>
  <td class="row_format">
   <?php echo $consultantschedule['Consultant']['profile_description']; ?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Scheduled Date',true); ?>
  </td>
  <td class="row_format">
   <?php echo  $this->DateFormat->formatDate2Local($consultantschedule['ConsultantSchedule']['schedule_date'],Configure::read('date_format')); ?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Start Scheduled Time',true); ?>
  </td>
  <td class="row_format">
   <?php echo $consultantschedule['ConsultantSchedule']['schedule_time']?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('End Scheduled Time',true); ?>
  </td>
  <td class="row_format">
   <?php echo $consultantschedule['ConsultantSchedule']['end_schedule_time']?>
  </td>
 </tr>
 <tr>
	<td colspan="2" align="center">
	<?php echo $this->Html->link(__('Cancel', true), array('action' => 'scheduled_consultant'),  array('class' => 'blueBtn','escape' => false));
	?>
        </td>
	</tr>
 </table>
