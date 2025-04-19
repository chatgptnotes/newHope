<div class="inner_title">
<h3><?php echo __('Doctor Schedules', true); ?></h3>
</div>
<table border="0" cellpadding="0" class="table_format" cellspacing="0" width="100%">
  <tr class="row_title">
    
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('DoctorProfile.doctor_name', __('Doctor Name', true)); ?></strong></td>
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('Department.name', __('Specilty Name', true)); ?></strong></td>
   <td class="table_cell"><strong><?php echo __('Action', true); ?></strong></td>
  </tr>
  <?php 
       $cnt=0;
       if(count($data) > 0) {
       foreach($data as $doctorschedule): 
         $cnt++;
  ?>
  <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?> >
    
   <td class="row_format"><?php echo $doctorschedule['DoctorProfile']['doctor_name']; ?> </td>
   <td class="row_format"><?php echo $doctorschedule['Department']['name']; ?> </td>
   <td>
    <?php echo $this->Html->link(__('Yes, this one!', true),array("action" => "doctor_event",$doctorschedule['DoctorProfile']['id']), array('class' => 'blueBtn','escape' => false)); ?>
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

