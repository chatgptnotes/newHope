<div class="inner_title">
<h3><?php echo __('Consultant Schedules', true); ?></h3>
</div>
<table border="0" cellpadding="0" class="table_format" cellspacing="0" width="100%">
  <tr class="row_title">
   <!--  <td class="table_cell"><strong><?php echo $this->Paginator->sort('Consultant.id', __('Id', true)); ?></strong></td>
   -->
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('Consultant.first_name', __('Consultant Name', true)); ?></strong></td>
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('Consultant.last_name', __('Last Name', true)); ?></strong></td>
   <td class="table_cell"><strong><?php echo __('Action', true); ?></strong></th>
  </tr>
  <?php 
       $cnt=0;
       if(count($data) > 0) {
       foreach($data as $consultantschedule): 
         $cnt++;
  ?>
  <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?> >
   <!-- <td class="row_format"><?php echo $consultantschedule['Consultant']['id']; ?></td>
    -->
   <td class="row_format"><?php echo $consultantschedule['Consultant']['first_name']; ?> </td>
   <td class="row_format"><?php echo $consultantschedule['Consultant']['last_name']; ?> </td>
   <td>
    <?php echo $this->Html->link(__('Yes, this one!', true),array("action" => "consultant_event",$consultantschedule['Consultant']['id']), array('class' => 'blueBtn','escape' => false)); ?>
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
   <TD colspan="4" align="center"><?php echo __('No record found', true); ?>.</TD>
  </tr>
  <?php
      }
  ?>
</table>

