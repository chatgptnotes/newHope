<?php
echo $this->Html->script(array('jquery.ui.widget.js','jquery.ui.mouse.js','jquery.ui.core.js','jquery.ui.slider.js','jquery-ui-timepicker-addon.js'));

?>
<div class="inner_title">
 <h3><?php echo __('Doctor Appointments') ?></h3>
</div> 
<div class="patient_info">
 <table width="100%">
  <tr>
   <td width="40%">
    <div id="datepicker"></div>
   </td>
  <td width="60%" valign="top">
   <?php 
      echo $this->Form->create('',array('id'=>'appointmentfrm','action'=>'doctor_appointment', 'inputDefaults' => array('label' => false,'div' => false))); 
      echo $this->Form->hidden('appointmentDate',array('id'=>'appointmentDate'));
      echo $this->Form->end();
   ?>
  </td>
  </tr>
</table>
</div>
<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%" >
 <tr class="row_title">
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('DoctorAppointment.id', __('Id', true)); ?></strong></td>
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('DoctorAppointment.date', __('Appointment Date', true)); ?></strong></td>
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('DoctorAppointment.start_time', __('Start Time', true)); ?></strong></td>
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('DoctorAppointment.end_time', __('End Time', true)); ?></strong></td>
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('DoctorAppointment.purpose', __('Purpose', true)); ?></strong></td>
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('DoctorAppointment.visit_type', __('Visit Type', true)); ?></strong></td>
   <td class="table_cell"><strong><?php echo __('Action', true); ?></td>
  </tr>
  <?php 
      $cnt =0;
      if(count($data) > 0) {
       foreach($data as $appointment): 
       $cnt++;
  ?>
   <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
   <td class="row_format"><?php echo $appointment['DoctorAppointment']['id']; ?></td>
   <td class="row_format"><?php echo $appointment['DoctorAppointment']['date']; ?> </td>
   <td class="row_format"><?php echo $appointment['DoctorAppointment']['start_time']; ?> </td>
   <td class="row_format"><?php echo $appointment['DoctorAppointment']['end_time']; ?> </td>
   <td class="row_format"><?php echo $appointment['DoctorAppointment']['purpose']; ?> </td>
   <td class="row_format"><?php echo $appointment['DoctorAppointment']['visit_type']; ?> </td>
   <td>
   <?php 
   echo $this->Html->link($this->Html->image('icons/view-icon.png'), array('action' => 'appointment_view',  $appointment['DoctorAppointment']['id']), array('escape' => false));
   ?>
   </td>
  </tr>
  <?php endforeach;  ?>
   <tr>
    <TD colspan="10" align="center">
     <!-- Shows the page numbers -->
     <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
     <!-- Shows the next and previous links -->
     <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
     <?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
     <!-- prints X of Y, where X is current page and Y is number of pages -->
     <span class="paginator_links"><?php echo $this->Paginator->counter(); ?></span>
    </TD>
   </tr>
  <?php
         } else {
  ?>
  <tr>
   <TD colspan="10" align="center"><?php echo __('No record found', true); ?>.</TD>
  </tr>
  <?php
      }
  ?>
</table>
<script>
			
		//script to include datepicker
		$(function() {
			$( "#datepicker" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',			 
			dateFormat:'<?php echo $this->General->GeneralDate();?>',
			onSelect: function(date) {
			  $("#appointmentDate").val(date);
			  $('#appointmentfrm').submit();
			},
			defaultDate:"<?php  if(isset($this->data['Doctor']['appointmentDate'])) echo $this->data['Doctor']['appointmentDate'];?>",					
			
		}); 
		 
		}); 
		</script>
