<div class="inner_title">
<h3><?php echo __('Consultant Schedule::Scheduled Consultant Listing', true); ?></h3>
</div>
<?php echo $this->element('schedule_consultant'); ?>
<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%">
  <tr class="row_title">
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('ConsultantSchedule.id', __('Id', true)); ?></td>
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('Consultant.first_name', __('First Name', true)); ?></td>
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('Consultant.last_name', __('Last Name', true)); ?></td>
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('ConsultantSchedule.schedule_date', __('Schedule Date', true)); ?></td>
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('ConsultantSchedule.schedule_time', __('Start Schedule Time', true)); ?></td>
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('ConsultantSchedule.end_schedule_time', __('End Schedule Time', true)); ?></td>
   <td class="table_cell"><strong><?php echo __('Action', true); ?></td>
  </tr>
  <?php 
      $cnt =0;
      if(count($data) > 0) {
       foreach($data as $scheduleConsultant): 
         $cnt++;
  ?>
   <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
   <td class="row_format"><?php echo $scheduleConsultant['ConsultantSchedule']['id']; ?></td>
   <td class="row_format"><?php echo $scheduleConsultant['Consultant']['first_name']; ?> </td>
   <td class="row_format"><?php echo $scheduleConsultant['Consultant']['last_name']; ?> </td>
   <td class="row_format"><?php echo $this->DateFormat->formatDate2Local($scheduleConsultant['ConsultantSchedule']['schedule_date'],Configure::read('date_format'),true); ?> </td>
   
   <td class="row_format"><?php echo $scheduleConsultant['ConsultantSchedule']['schedule_time']; ?> </td>
   <td class="row_format"><?php echo $scheduleConsultant['ConsultantSchedule']['end_schedule_time']; ?> </td>
   <td>
   <?php echo $this->Html->link($this->Html->image('icons/view-icon.png',array('alt'=>__('View'),'title'=>__('View'))),array('action' => 'scheduled_view', $scheduleConsultant['ConsultantSchedule']['id']), array('escape' => false));
   ?>	
   <?php echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('alt'=>__('Edit'),'title'=>__('Edit'))), array('action' => 'scheduled_edit', $scheduleConsultant['ConsultantSchedule']['id']), array('escape' => false));
   ?>								  
   <?php echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('alt'=>__('Delete'),'title'=>__('Delete'))), array('action' => 'scheduled_delete', $scheduleConsultant['ConsultantSchedule']['id']), array('escape' => false),"Are you sure you wish to cancel this appointment?");
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
   <TD colspan="7" align="center"><?php echo __('No record found', true); ?>.</TD>
  </tr>
  <?php
      }
  ?>
</table>

